<?php
/*
DataTable HTML 
*/




/* Render HTML */
function render_datatable($headings = array(), $class = '', $additional_classes = array(''), $table_attributes = array())
{
    $_additional_classes = '';
    $_table_attributes   = ' ';
    if (count($additional_classes) > 0) {
        $_additional_classes = ' ' . implode(' ', $additional_classes);
    }
   
    $IEfix   = '';
    $CI =& get_instance();
    /* 
    $browser = $CI->agent->browser();
    if ($browser == 'Internet Explorer') {
        $IEfix = 'ie-dt-fix';
    }
    */
    foreach ($table_attributes as $key => $val) {
        $_table_attributes .= $key . '=' . '"' . $val . '" ';
    }

    $table = '<div class="' . $IEfix . '"><table' . $_table_attributes . 'class="dt-table-loading table table-' . $class . '' . $_additional_classes . '" id="projects_listing" data-id="">';
    $table .= '<thead>';
    $table .= '<tr>';
    foreach ($headings as $heading) {
        if(!is_array($heading)){
            $table .= '<th>' . $heading . '</th>';
        } else {
            $th_attrs = '';
            if(isset($heading['th_attrs'])){
                foreach ($heading['th_attrs'] as $key => $val) {
                    $th_attrs .= $key . '=' . '"' . $val . '" ';
                }
            }
            $th_attrs = ($th_attrs != '' ? ' '.$th_attrs : $th_attrs);
            $table .= '<th'.$th_attrs.'>' . $heading['name'] . '</th>';
        }
    }
    $table .= '</tr>';
    $table .= '</thead>';
    $table .= '<tbody></tbody>';
    $table .= '</table></div>';
    echo $table;
}

/* Tags Listing  by relation type and relation id */
function get_tags_in($rel_id, $rel_type)
{
    $CI =& get_instance();
    $CI->db->where('rel_id', $rel_id);
    $CI->db->where('rel_type', $rel_type);
    $CI->db->order_by('tag_order', 'ASC');
    $tags = $CI->db->get('alpha_tags_in')->result_array();

    $tag_names = array();
    foreach ($tags as $tag) {
        $CI->db->where('id', $tag['tag_id']);
        $tag_row = $CI->db->get('alpha_tags')->row();
        if ($tag_row) {
            array_push($tag_names, $tag_row->name);
        }
    }

    return $tag_names;
}

function get_sql_select_client_company()
{
    return '(SELECT CONCAT(first_name, " ", last_name) FROM alpha_users WHERE userid = alpha_clients.userid ) as company';
}


function get_staff_user_id(){
	$CI =& get_instance();
	return $CI->session->userdata('user_id');
}

/*  fetch the database prefix */
function get_prefix(){
	$CI =& get_instance();
	$CI->load->database();
	return $CI->db->dbprefix;
}

function get_project_statuses(){	
        $statuses =  array(
            array(
                'id'=>1,
                'color'=>'#989898',
                'name'=> 'Status1',
                'order'=>1,
                'filter_default'=>true,
                ),
            array(
                'id'=>2,
                'color'=>'#03a9f4',
                'name'=> 'Status2',
                'order'=>2,
                'filter_default'=>true,
                ),
            array(
                'id'=>3,
                'color'=>'#ff6f00',
                'name'=>'Status3',
                'order'=>3,
                'filter_default'=>true,
                ),
            array(
                'id'=>4,
                'color'=>'#84c529',
                'name'=>'Status4',
                'order'=>100,
                'filter_default'=>false,
                ),
            array(
                'id'=>5,
                'color'=>'#989898',
                'name'=> 'Status5',
                'order'=>4,
                'filter_default'=>false,
                ),
            );

        usort($statuses, function ($a, $b) {
            return $a['order'] - $b['order'];
        });

        return $statuses;
}

/**
 * Function will render tags as html version to show to the user
 * @param  string $tags
 * @return string
 */
function render_tags($tags)
{
    $tags_html = '';
    if (!is_array($tags)) {
        $tags = explode(',', $tags);
    }
    $tags = array_filter($tags, function ($value) {
        return $value !== '';
    });
    if (count($tags) > 0) {
        $CI = &get_instance();
        $tags_html .= '<div class="tags-labels">';
        $i = 0;
        $len = count($tags);
        foreach ($tags as $tag) {
            $tag_id = 0;
            $tag_row = 1;
            if(!$tag_row){
                $CI->db->select('id')->where('name', $tag);
                $tag_row = $CI->db->get('tbltags')->row();
                if($tag_row){
                    $CI->object_cache->add('tag-id-by-name-'.$tag,$tag_row->id);
                }
            }

            if ($tag_row) {
                $tag_id = is_object($tag_row) ? $tag_row->id : $tag_row;
            }

            $tags_html .= '<span class="label label-tag tag-id-'.$tag_id.'"><span class="tag">'.$tag.'</span><span class="hide">'.($i != $len - 1 ? ', ' : '') .'</span></span>';
            $i++;
        }
        $tags_html .= '</div>';
    }

    return $tags_html;
}


/* Project SQL Columns*/
function project_sql_qry(){
	$aColumns = array(
    'alpha_projects.id as id',
    'name', 
    get_sql_select_client_company(),
    '(SELECT GROUP_CONCAT(name SEPARATOR ",") FROM alpha_tags_in LEFT JOIN alpha_tags ON alpha_tags_in.tag_id = alpha_tags.id WHERE rel_id = alpha_projects.id and rel_type="project" ORDER by tag_order ASC) as tags',
    'start_date',
    'deadline',
    '(SELECT GROUP_CONCAT(CONCAT(first_name, \' \', last_name) SEPARATOR ",") FROM alpha_projectmembers LEFT JOIN alpha_users on alpha_users.id = alpha_projectmembers.staff_id WHERE project_id=alpha_projects.id ORDER BY staff_id) as members',
    );	

    array_push($aColumns, 'billing_type');
	$billingTypeVisible = true;
	
	array_push($aColumns, 'status');

	$sIndexColumn = "id";
	$sTable       = 'alpha_projects';

	$join             = array(
	    'LEFT JOIN alpha_clients ON alpha_clients.userid = alpha_projects.clientid'
	);


	$where  = array();
	$filter = array();

	if (isset($clientid) && $clientid != '') {
	    array_push($where, ' AND clientid=' . $clientid);
	}

	array_push($where, ' AND alpha_projects.id IN (SELECT project_id FROM alpha_projectmembers WHERE staff_id=' . get_staff_user_id() . ')');
	

	$statusIds = array();

	foreach (get_project_statuses() as $status) {
	   // if ($CI->ci->input->post('project_status_' . $status['id'])) {
	    if (isset($_POST['project_status_' . $status['id']])) {
	        array_push($statusIds, $status['id']);
	    }
	}

	if (count($statusIds) > 0) {
	    array_push($filter, 'OR status IN (' . implode(', ', $statusIds) . ')');
	}

	if (count($filter) > 0) {
	    array_push($where, 'AND (' . prepare_dt_filter($filter) . ')');
	}

	//$custom_fields = get_table_custom_fields('projects');
	$custom_fields = array();
	$customFieldsColumns = array();

	foreach ($custom_fields as $key => $field) {
	    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_'.$key);
	    array_push($customFieldsColumns, $selectAs);
	    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
	    array_push($join, 'LEFT JOIN alpha_customfieldsvalues as ctable_' . $key . ' ON alpha_projects.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
	}

	$aColumns = $aColumns;

	// Fix for big queries. Some hosting have max_join_limit
	if (count($custom_fields) > 4) {
	    @$this->ci->db->query('SET SQL_BIG_SELECTS=1');
	}

	$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, array(
	    'clientid',
	    '(SELECT GROUP_CONCAT(staff_id SEPARATOR ",") FROM alpha_projectmembers WHERE project_id=alpha_projects.id ORDER BY staff_id) as members_ids'
	));

	$output  = $result['output'];
	$rResult = $result['rResult'];

	foreach ($rResult as $aRow) {
	    $row = array();

	    $row['id'] = '<a href="' . base_url().'projects/view/' . $aRow['id'] . '">' . $aRow['id'] . '</a>';

	    $row['name'] = '<a href="' . base_url() .'projects/view/' . $aRow['id'] . '">' . $aRow['name'] . '</a>';

	    $row['customer'] = '<a href="' . base_url(). 'clients/client/' . $aRow['clientid'] . '">' . $aRow['company'] . '</a>';

	    $row['tags'] = render_tags($aRow['tags']);

	    $row['startdate'] = $aRow['start_date'];

	    $row['deadline'] = $aRow['deadline'];

	    $membersOutput = '';

	    $members        = explode(',', $aRow['members']);
	    $exportMembers = '';
	    foreach ($members as $key=> $member) {
	        if ($member != '') {
	            $members_ids = explode(',', $aRow['members_ids']);
	            $member_id   = $members_ids[$key];
	            $membersOutput .= '<a href="' . base_url().'users/view' . $member_id . '"><img src=""></a>';
	                    // For exporting
	            $exportMembers .= $member . ', ';
	        }
	    }

	    $membersOutput .= '<span class="hide">' . trim($exportMembers, ', ') . '</span>';
	    $row['members'] = $membersOutput;

	    if ($billingTypeVisible) {
	        if ($aRow['billing_type'] == 1) {
	            $type_name = 'project_billing_type_fixed_cost';
	        } elseif ($aRow['billing_type'] == 2) {
	            $type_name = 'project_billing_type_project_hours';
	        } else {
	            $type_name = 'project_billing_type_project_task_hours';
	        }
	        $row['billing_type'] = $type_name;
	    }

	    $status = get_project_status_by_id($aRow['status']);
	    $row['status'] = '<span class="label label inline-block project-status-' . $aRow['status'] . '" style="color:'.$status['color'].';border:1px solid '.$status['color'].'">' . $status['name'] . '</span>';

	    // Custom fields add values
	    foreach ($customFieldsColumns as $customFieldColumn) {
	        $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
	    }

	    $hook =  array(
	        'output' => $row,
	        'row' => $aRow
	    );

	    $row = $hook['output'];

	    $options = '';

	   // if($hasPermissionCreate) {
	        $options .= "Clone";
	       // $options .= icon_btn('#', 'clone','btn-default',array('onclick'=>'copy_project('.$aRow['id'].');return false'));
	    //}

	  //  if ($hasPermissionEdit) {
	        //$options .= icon_btn('projects/project/' . $aRow['id'], 'pencil-square-o');
	        $options .= "Edit";
	  //  }

	  //  if ($hasPermissionDelete) {
	        $options .= "Delete";
	   // }

	    $row['options']              = $options;
	    $output['data'][] = $row;

}
return $output;

}

/**
 * Get project status by passed project id
 * @param  mixed $id project id
 * @return array
 */
function get_project_status_by_id($id)
{
   
    $statuses = get_project_statuses();

    $status = array(
      'id'=>0,
      'bg_color'=>'#333',
      'text_color'=>'#333',
      'name'=>'[Status Not Found]',
      'order'=>1,
      );

    foreach ($statuses as $s) {
        if ($s['id'] == $id) {
            $status = $s;
            break;
        }
    }

    return $status;
}

function strbefore($string, $substring)
{
    $pos = strpos($string, $substring);
    if ($pos === false) {
        return $string;
    } else {
        return (substr($string, 0, $pos));
    }
}

if (!function_exists('_startsWith')) {
    function _startsWith($haystack, $needle)
    {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
}

function get_sorting_due_date_columns()
{
    $dueDateColumns = array('tblprojects.deadline', 'tblstafftasks.duedate', 'tblcontracts.dateend');

    return $dueDateColumns;
}

function data_tables_init($aColumns, $sIndexColumn, $sTable, $join = array(), $where = array(), $additionalSelect = array(), $sGroupBy = '')
{

	$CI =& get_instance();
    $__post = $CI->input->post();

    /*
     * Paging
     */
    $sLimit = "";
    if ((is_numeric($CI->input->post('start'))) && $CI->input->post('length') != '-1') {
        $sLimit = "LIMIT " . intval($CI->input->post('start')) . ", " . intval($CI->input->post('length'));
    }
    $_aColumns = array();
    foreach ($aColumns as $column) {
        // if found only one dot
        if (substr_count($column, '.') == 1 && strpos($column, ' as ') === false) {
            $_column = explode('.', $column);
            if (isset($_column[1])) {
                if (_startsWith($_column[0], 'alpha_')) {
                   // $_prefix = prefixed_table_fields_wildcard($_column[0], $_column[0], $_column[1]);
                    $_prefix = '';
                    array_push($_aColumns, $_prefix);
                } else {
                    array_push($_aColumns, $column);
                }
            } else {
                array_push($_aColumns, $_column[0]);
            }
        } else {
            array_push($_aColumns, $column);
        }
    }

    /*
     * Ordering
     */
    $dueDateColumns = get_sorting_due_date_columns();
   // $dueDateColumns = 'name';
    $sOrder = "";
    if ($CI->input->post('order')) {
        $sOrder = "ORDER BY ";
        foreach ($CI->input->post('order') as $key => $val) {
            $columnName = $aColumns[intval($__post['order'][$key]['column'])];
            $dir = strtoupper($__post['order'][$key]['dir']);

            if (strpos($columnName, ' as ') !== false) {
                $columnName = strbefore($columnName, ' as');
            }

            // first checking is for eq tablename.column name
            // second checking there is already prefixed table name in the column name
            // this will work on the first table sorting - checked by the draw parameters
            // in future sorting user must sort like he want and the duedates won't be always last
            /* if ((in_array($sTable.'.'.$columnName, $dueDateColumns)
                || in_array($columnName, $dueDateColumns))
                ) {
                $sOrder .= $columnName . ' IS NULL ' . $dir . ', '.$columnName;
            } else {
                $sOrder .= do_action('datatables_query_order_column', $columnName);
            } */

             $sOrder .= $columnName . ' IS NULL ' . $dir . ', '.$columnName;
            $sOrder .= ' ' . $dir . ', ';
        }
        if (trim($sOrder) == "ORDER BY") {
            $sOrder = "";
        }
        $sOrder = rtrim($sOrder, ', ');
    }
    /*
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
     */
    $sWhere = "";
    if ((isset($__post['search'])) && $__post['search']['value'] != "") {
        $search_value = $__post['search']['value'];
        $search_value = trim($search_value);
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $columnName = $aColumns[$i];
            if (strpos($columnName, ' as ') !== false) {
                $columnName = strbefore($columnName, ' as');
            }
            if (stripos($columnName, 'AVG(') !== false || stripos($columnName, 'SUM(') !== false) {
            } else {
                if (($__post['columns'][0]) && $__post['columns'][0]['searchable'] == "true") {             
                    $sWhere .= 'convert('.$columnName.' USING utf8)' . " LIKE '%" . $search_value . "%' OR ";
               }
            }
        } 
        if (count($additionalSelect) > 0) {
            foreach ($additionalSelect as $searchAdditionalField) {
                if (strpos($searchAdditionalField, ' as ') !== false) {
                    $searchAdditionalField = strbefore($searchAdditionalField, ' as');
                }
                if (stripos($columnName, 'AVG(') !== false || stripos($columnName, 'SUM(') !== false) {
                } else {
                    $sWhere .= 'convert('.$searchAdditionalField.' USING utf8)' . " LIKE '%" . $search_value . "%' OR ";
                }
            }
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    } else {
        // Check for custom filtering
        $searchFound = 0;
        $sWhere      = "WHERE (";

		
        for ($i = 0; $i < count($aColumns); $i++) {

          
            if (($__post['columns'][0]) && $__post['columns'][0]['searchable'] == "true") {
                $search_value    = $__post['columns'][0]['search']['value'];

                $columnName = $aColumns[$i];
                if (strpos($columnName, ' as ') !== false) {
                    $columnName = strbefore($columnName, ' as');
                }
                if ($search_value != '') {
                    $sWhere .= 'convert('.$columnName.' USING utf8)' . " LIKE '%" . $search_value . "%' OR ";
                    if (count($additionalSelect) > 0) {
                        foreach ($additionalSelect as $searchAdditionalField) {
                            $sWhere .= 'convert('.$searchAdditionalField.' USING utf8)' . " LIKE '%" . $search_value . "%' OR ";
                        }
                    }
                    $searchFound++;
                }
            }
        }
        if ($searchFound > 0) {
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        } else {
            $sWhere = '';
        }
    }

    /*
     * SQL queries
     * Get data to display
     */
    $_additionalSelect = '';
    if (count($additionalSelect) > 0) {
        $_additionalSelect = ',' . implode(',', $additionalSelect);
    }
	//echo '<pre>'; print_r($where);
	
    $where = implode(' ', $where);
    if ($sWhere == '') {
        $where = trim($where);
        if (_startsWith($where, 'AND') || _startsWith($where, 'OR')) {
            if (_startsWith($where, 'OR')) {
                $where = substr($where, 2);
            } else {
                $where = substr($where, 3);
            }
            $where = 'WHERE ' . $where;
        }
    }
	
	//echo 'After SPLIT --     ';print_r($where);


    $join = implode(' ', $join);

    $sQuery  = "
    SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $_aColumns)) . " " . $_additionalSelect . "
    FROM $sTable
    " . $join . "
    $sWhere
    " . $where . "
    $sGroupBy
    $sOrder
    $sLimit
    ";
	

    $rResult = $CI->db->query($sQuery)->result_array();
	//echo 'Result    --->    '.$CI->db->last_query(); die;
	//echo '</br>';
    $hookData = array(
        'results'=>$rResult,
        'table'=>$sTable,
        'limit'=>$sLimit,
        'order'=>$sOrder,
        );

    $rResult = $hookData['results'];
    /* Data set length after filtering */
    $sQuery         = " 
    SELECT FOUND_ROWS()
    ";
    $_query         = $CI->db->query($sQuery)->result_array();
	
    $iFilteredTotal = $_query[0]['FOUND_ROWS()'];
	//echo 'where------';print_r($where);
	//echo 'var--->>>===';var_dump(_startsWith($where, 'AND'));
    if (_startsWith($where, 'AND')) {
        $where = 'WHERE ' . substr($where, 3);
    }
	
	
    /* Total data set length */
    $sQuery = "
    SELECT COUNT(" . $sTable . '.' . $sIndexColumn . ")
    FROM $sTable " . $join . ' ' . $where;
    $_query = $CI->db->query($sQuery)->result_array();
//echo 'last--->'.$CI->db->last_query();
	
    $iTotal = $_query[0]['COUNT(' . $sTable . '.' . $sIndexColumn . ')'];
		
    /*
     * Output
     */
    $output = array(
        "draw" => $__post['draw'] ? intval($__post['draw']) : 0,
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "data" => array(),
        );

    $final_output = array(
        'rResult' => $rResult,
        'output' => $output,
        );

    return $final_output;
}

function user_image($id){
	$CI = &get_instance();
	$sQuery =  'SELECT profile_image,first_name,last_name FROM alpha_users WHERE id = '.$id;
	$rResult = $CI->db->query($sQuery)->row();
	 
	if(!empty($rResult)){	
		if(!empty($rResult->profile_image)){
			return '<img src="' . base_url().'/assets/modules/users/uploads/'.$rResult->profile_image.'" data-toggle="tooltip" data-placement="top" title="'.$rResult->first_name.' '.$rResult->last_name.'"class="img-circle" style="width:30px;height:30px%"/>';
		}
		else
			return '<img src="' . base_url().'/assets/modules/users/uploads/default-user.jpeg" data-toggle="tooltip" data-placement="top" title="'.$rResult->first_name.' '.$rResult->last_name.'" class="img-circle" style="width:30px;height:30px%"/>';
	} else {
		return '';
	}
}


?>
