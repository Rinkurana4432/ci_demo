<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class inventory_model extends ERP_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tablename = 'material';
        //$this->column_search = array('name');
        $this->companyId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
    }
    /* database field columns */
    public function get_field_type_data($data, $type) {
        switch ($type) {
            case 'material':
                $all_fields = array('material_code', 'material_type_id', 'sub_type', 'material_name', 'sales_price', 'cost_price', 'sale_purchase', 'non_inventry_material', 'material_code', 'specification', 'hsn_code', 'opening_balance', 'uom', 'lead_time', 'time_period', 'min_inventory', 'inventory_unit', 'max_inventory', 'max_uom', 'route','tags', 'prefix', 'tax', 'featured_image', 'facebook', 'twitter', 'instagram', 'linkedin', 'created_by', 'created_by_cid', 'sale_purchase', 'min_order', 'save_status', 'edited_by', 'job_card', 'cess', 'valuation_type' , 'mat_sku','product_code','MatAliasName','quality_check','dimension_length','dimension_width','dimension_height','total_cbf','packing_data','standard_packing','item_code','quality_check_type','barcode','alternateuom','alternate_qty','closing_balance');
            break;
            case 'material_type':
                $all_fields = array('name', 'prefix', 'sub_type', 'created_by', 'created_by_cid');
            break;
            case 'material_variants':
                $all_fields = array('item_code', 'temp_material_name', 'temp_material_data', 'packing_data', 'variants_data', 'status');
            break;
            case 'inventory_listing':
                $all_fields = array('material_type_id', 'material_name_id', 'converted_material', 'action_type', 'quantity', 'uom', 'reason', 'source_location', 'party_name', 'half_full_book', 'time_period', 'total_qty', 'location', 'created_by_cid');
            break;
            case 'inventory_listing_adjustment':
                $all_fields = array('material_type_id', 'material_name_id', 'date', 'action_type', 'quantity', 'converted_material_id', 'uom', 'reason', 'source_address', 'destination_address', 'scrapIntoMaterial_id', 'ScrapUom', 'party_name', 'half_or_full_book', 'created_by_cid');
            break;
            case 'location_settings':
                $all_fields = array('location_id','location', 'area', 'created_by_cid');
            break;
            case 'tags_in':
                $all_fields = array('rel_id', 'rel_typ', 'tags_id');
            break;

            case 'lot_details':
            $all_fields = array( 'lot_number', 'mat_type_id', 'mat_id', 'active_inactive', 'quantity', 'mou_price', 'date', 'mrp_price', 'created_by', 'created_by_cid');
            break;
            case 'add_machine':
                $all_fields = array('machine_name','machine_code','machine_group_id','preventive_maintenance','machine_parameter','company_branch','department','make_model','year_purchase','placement','add_similar_machine','machine_capacity','created_by_cid','save_status','created_by','edited_by','department_id','process');
                break;

            case 'tags':
                $all_fields = array('name');
            break;
            case 'user_dashboard':
                $all_fields = array('graph_id', 'user_id', 'show');
            break;
            case 'work_in_process_material':
                #$all_fields = array('material_type_id','material_name_id','quantity','uom','location','material_status','created_by_cid');
                $all_fields = array('sale_order_id', 'material_type_id', 'material_status', 'material_id', 'output', 'quantity', 'uom', 'location', 'aknowlwdge_by', 'acknowledge_date', 'created_by_cid');
            break;
            case 'finish_goods':
               // $all_fields = array('job_card_detail', 'scrap_qty', 'material_scrap_id','acknowledge_date','aknowlwdge_by', 'created_by_cid', 'created_by');
               $all_fields = array('job_card_detail', 'scrap_material_detail','voucher_date','location_id','acknowledge_date','aknowlwdge_by', 'created_by_cid', 'created_by');
            break;

            case 'tag_types':
                $all_fields = array('tag_types', 'created_by_cid', 'created_by');
            break;

            case 'tag_details':
                $all_fields = array('tag_id', 'tag_name', 'created_by_cid', 'created_by');
            break;


			case 'quality_finish_goods':
                $all_fields = array('job_card_detail', 'scrap_qty', 'material_scrap_id','acknowledge_date','aknowlwdge_by', 'created_by_cid', 'created_by');
            break;
            case 'attachments':
                $all_fields = array('rel_type', 'rel_id', 'file_type', 'file_name');
            break;
            case 'inventory_flow':
                $all_fields = array('material_type_id','current_location','new_location','material_id', 'material_in', 'material_out', 'uom', 'through', 'ref_id', 'uom', 'created_by', 'created_by_cid', 'location','comment','opening_blnc','closing_blnc');
            break;
            case 'mat_locations':
                $all_fields = array('location_id', 'Storage', 'quantity', 'Qtyuom', 'created_by_cid', 'material_type_id', 'material_name_id' );
            break;
            case 'uom':
                $all_fields = array('uom_quantity', 'uom_quantity_type', 'ugc_code', 'created_by', 'created_by_cid', 'created_date', 'modified_data');
            break;
            case 'purchase_indent':
                $all_fields = array('indent_code', 'material_type_id', 'material_name', 'preffered_supplier', 'grand_total', 'inductor', 'specification', 'other', 'departments', 'required_date', 'poCreate', 'created_by', 'validated_by', 'disapprove_reason', 'created_by_cid', 'po_or_not', 'mrn_or_not', 'edited_by', 'save_status', 'company_unit', 'ifbalance', 'status');
            break;

            case 'reoder_level_report':
            $all_fields = array('no_of_items', 'inventory_items', 'created_by_cid', 'created_by');
            break;


            case 'mrp_details':
            $all_fields =  array('company_branch', 'department_id', 'month', 'mrp_data', 'created_by', 'created_by_cid');
            break;

            case 'wip':
            $all_fields = array('mat_detail', 'acknowledege_date', 'acknowledge_by', 'record_date', 'created_by', 'created_by_cid');
            break;

            case 'wip_request':
            $all_fields = array('mat_detail', 'request_id','created_by', 'created_by_cid','issued_date','issued_status');
            break;

            case 'company_address':
            $all_fields = array('area');
            break;

            case 'reserved_material':
            $all_fields = array('customer_id', 'material_type', 'mayerial_id', 'quantity', 'created_by', 'created_by_cid');
            break;


            case 'daily_report_setting':
        $all_fields = array('report_name', 'material_type_id', 'frequency', 'created_by', 'created_by_cid', 'created_date','toEmail');
            break;
            case 'lot_details':
            $all_fields = array( 'lot_number', 'mat_type_id', 'mat_id', 'active_inactive', 'quantity', 'mou_price', 'date', 'mrp_price', 'created_by', 'created_by_cid');
            break;

           case 'material_in_process_inventory_flow':
                $all_fields = array('material_type_id','material_id', 'material_in', 'material_out', 'uom', 'through', 'ref_id','created_by', 'created_by_cid','opening_blnc','closing_blnc');
            break;

            case 'variant_types':
                $all_fields = array('varient_name');
            break;
            case 'stock_permission':
                $all_fields = array('stock_permission');
            break;
            case 'variant_options':
                $all_fields = array('variant_type_id', 'option_name', 'option_img_name' );
            break;
            case 'material_old_price':
                $all_fields = array('material_type_id', 'old_sales_price', 'new_sales_price','created_by');
            break;
            
            default:
                $all_fields = array('subject', 'contactid', 'department', 'service', 'status', 'userid', 'adminreplying', 'email', 'name', 'priority', 'ticketkey', 'message', 'admin', 'project_id', 'lastReply', 'clientread', 'adminread', 'ip', 'assigned');
        }
        return $data = format_data_to_be_added($all_fields, $data);
    }


	//num rows
	public function num_rows($table, $where = array(),$where2){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($where);
	 if($where2!=''){
		 $dynamicdb->where($where2);
		 }
		$qry = $dynamicdb->get();
		// echo $dynamicdb->last_query();
		$result = $qry->num_rows();
		return $result;
	}

    /********************************update costprice/salesprice in material through evaluation **************************/
    public function updateMaterialData($table, $data) {
        $field_data = $data;
        $data = array();
        foreach ($field_data as $key => $result) {
            $data[] = array('id' => $result['id'], 'cost_price' => (array_key_exists("costprice", $result) ? $result['costprice'] : ''), 'sales_price' => (array_key_exists("saleprice", $result) ? $result['saleprice'] : ''));
            $arrayMap = array_map('array_filter', $data); // this is apply to remove empty key values
            $array = array_filter($arrayMap);
        }
        $this->db->update_batch('material', $array, 'id');
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->update_batch('material', $array, 'id');
        return true;
    }
    /**************************filter data in material and material adjustment **************************************/
    public function get_filter_details($table = '', $where = array(), $limit = '') {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where($where);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($where);
            $qry = $dynamicdb->get();
        }
        $result = $qry->result_array();
        return $result;
    }
    /****************************Function dashboard data****************************************************/
    public function get_data_dashboard($table = '', $where = array(), $limit = '') {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $table = $table ? $table : $this->tablename;
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($where);
            if ($limit) $dynamicdb->limit($limit);
            if ($table != 'permissions') $dynamicdb->order_by('created_date', "desc");
            $qry = $dynamicdb->get();
            $result = $qry->result_array();
            return $result;
        }
    }
    /*******************************Function for display evaluation listing data***************************/
    public function get_evaluation_data($table = '', $where = array()) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $table = $table ? $table : $this->tablename;
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($where);
            $dynamicdb->where('non_inventry_material!=', 1);
            $dynamicdb->order_by('material_type_id');
            $qry = $dynamicdb->get();
            #echo $dynamicdb->last_query();
            $result = $qry->result_array();
            return $result;
        }
    }
    /***************************************************************************functions use in WIP and finish goods*********************************************/
    /*insert multiple values using single query in material issue*/
    public function insert_multiple_data($table, $data) {
        if (!empty($data)) {
            foreach ($data as $dt) {
                $this->db->insert($table, $dt);
                $insertedid = $this->db->insert_id();
                if ($insertedid) {
                    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
                        $dynamicdb = $this->load->database('dynamicdb', TRUE);
                        $dt['id'] = $insertedid;
                        $dynamicInsertedid = $dynamicdb->insert('work_in_process_material', $dt);
                    }
                }
            }
            //return $insertedid;

        }
        return true;
    }
    /*get quantity based on multiple ids in material issue and perform subtraction */
    /*public function get_Materialtbl_data($table,$where){
    if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
    $this->db->select('id,closing_balance');
    $this->db->from($table);
    $this->db->where('id'." IN (".$where.")");
    $qry1 = $this->db->get();
    $materialResult = $qry1->result_array();
    $resultArray = array();
    $i = 0;
    foreach($materialResult as $res){
    $this->db->select('id as material_issue_id , material_id as material_id,quantity');  //second query from wip table to get corresponding data
    $this->db->from('work_in_process_material');
    $this->db->where('material_id',$res['id']);
    $qry = $this->db->get();
    $material_issue_result = $qry->result_array();
    $resultArray[$i]['id'] = $res['id'];
    $resultArray[$i]['closing_balance'] = $res['closing_balance'];
    $resultArray[$i]['material_issue_id'] = $material_issue_result[0]['material_issue_id'];
    $resultArray[$i]['quantity'] = $material_issue_result[0]['quantity'];
    $resultArray[$i]['final_value'] = $res['closing_balance'] -  $material_issue_result[0]['quantity'];//subtaract closing balance value from WIP material quantity and update
    $i++;
    }
    }else{
    $dynamicdb = $this->load->database('dynamicdb', TRUE);
    $dynamicdb->select('id,closing_balance');
    $dynamicdb->from($table);
    $dynamicdb->where('id'." IN (".$where.")");
    $qry1 = $dynamicdb->get();
    $materialResult = $qry1->result_array();
    $resultArray = array();
    $i = 0;
    foreach($materialResult as $res){
    $dynamicdb->select('id as material_issue_id , material_id as material_id,quantity');  //second query from wip table to get corresponding data
    $dynamicdb->from('work_in_process_material');
    $dynamicdb->where('material_id',$res['id']);
    $qry = $dynamicdb->get();
    $material_issue_result = $qry->result_array();
    $resultArray[$i]['id'] = $res['id'];
    $resultArray[$i]['closing_balance'] = $res['closing_balance'];
    $resultArray[$i]['material_issue_id'] = $material_issue_result[0]['material_issue_id'];
    $resultArray[$i]['quantity'] = $material_issue_result[0]['quantity'];
    $resultArray[$i]['final_value'] = $res['closing_balance'] -  $material_issue_result[0]['quantity'];//subtaract closing balance value from WIP material quantity and update
    $i++;
    }
    }
    return $resultArray;
    }
    */
    public function get_Materialtbl_data($table, $where) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('id,opening_balance');
            $this->db->from($table);
            $this->db->where('id' . " IN (" . $where . ")");
            $qry1 = $this->db->get();
            $materialResult = $qry1->result_array();
            $resultArray = array();
            $i = 0;
            foreach ($materialResult as $res) {
                $this->db->select('id as material_issue_id , material_id as material_id, location as location , quantity'); //second query from wip table to get corresponding data
                $this->db->from('work_in_process_material');
                $this->db->where('material_id', $res['id']);
                $qry = $this->db->get();
                $material_issue_result = $qry->result_array();
                $resultArray[$i]['id'] = $res['id'];

                $resultArray[$i]['opening_balance'] = $res['opening_balance'];
                $resultArray[$i]['location_id'] = $material_issue_result[0]['location'];
                $resultArray[$i]['material_issue_id'] = $material_issue_result[0]['material_issue_id'];
                $resultArray[$i]['quantity'] = $material_issue_result[0]['quantity'];
                $resultArray[$i]['final_value'] = $res['opening_balance'] - $material_issue_result[0]['quantity']; //subtaract closing balance value from WIP material quantity and update

               # pre($resultArray);
                $i++;
            }
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('id,opening_balance');
            $dynamicdb->from($table);
            $dynamicdb->where('id' . " IN (" . $where . ")");
            $qry1 = $dynamicdb->get();
            $materialResult = $qry1->result_array();
            $resultArray = array();
            $i = 0;
            foreach ($materialResult as $res) {
                $dynamicdb->select('id as material_issue_id , material_id as material_id, location as location , quantity'); //second query from wip table to get corresponding data
                $dynamicdb->from('work_in_process_material');
                $dynamicdb->where('material_id', $res['id']);
                $qry = $dynamicdb->get();
                $material_issue_result = $qry->result_array();
                $resultArray[$i]['id'] = $res['id'];
                $resultArray[$i]['opening_balance'] = $res['opening_balance'];
                 $resultArray[$i]['location_id'] = $material_issue_result[0]['location'];
                $resultArray[$i]['material_issue_id'] = $material_issue_result[0]['material_issue_id'];
                $resultArray[$i]['quantity'] = $material_issue_result[0]['quantity'];
                $resultArray[$i]['final_value'] = $res['opening_balance'] - $material_issue_result[0]['quantity']; //subtaract closing balance value from WIP material quantity and update
                $i++;
            }
        }
        return $resultArray;
    }
    /*update material closing  value in material table */
    public function update_matTbl_data($table, $data) {
        $field_data = $data;
        $dataArray = array();
        foreach ($field_data as $key => $dt) {
            $dataArray[] = array('id' => $dt['id'], 'opening_balance' => $dt['final_value']);
        }
        $this->db->update_batch('material', $dataArray, 'id');
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->update_batch('material', $dataArray, 'id');
        }
        return true;
    }
    /*get closing qty from material and get closing amnt value  */
    public function get_material_closing_qty($table, $mat_idd) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where('id', $mat_idd);
            $query = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where('id', $mat_idd);
            $query = $dynamicdb->get();
        }
        #echo $dynamicdb->last_query();
        return $query->row_array();
    }
    /*get job card deail based on id in material receipt****/
    public function getDataByJobId($table, $field, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('material_details');
            $this->db->from($table);
            $this->db->where($field, $id);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('material_details');
            $dynamicdb->from($table);
            $dynamicdb->where($field, $id);
            $qry = $dynamicdb->get();
        }
        $result = $qry->result_array();
        return $result;
    }
    /*get material name in finish goods based on their fetched ID**/
    public function getDataByMatId($table, $field, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('material_name,uom,job_card');
            $this->db->from($table);
            $this->db->where($field, $id);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('material_name,uom,job_card');
            $dynamicdb->from($table);
            $dynamicdb->where($field, $id);
            $qry = $dynamicdb->get();
        }
        $result = $qry->result_array();
        return $result;
    }
    /*get wip data in finish goods  save function*/
    public function get_wip_mat_data($table, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('material_id,quantity');
            $dynamicdb->from($table);
            $dynamicdb->where('material_id' . " IN (" . $id . ")");
            $qry = $dynamicdb->get();
            $result = $qry->result_array();
            return $result;
        }
    }
    /* update WIP Quantity after subtraction*/
    public function update_mat_in_wip_data($table, $data, $id) {
        $field_data = $data;
        $data = array();
        foreach ($field_data as $key => $qty) {
            $data[] = array('material_id' => $qty['material_id'], 'quantity' => $qty['result'] , 'output' => $qty['output']);
        }
        //pre($data);
        $this->db->update_batch('work_in_process_material', $data, 'material_id');
        //pre($this->db->last_query());die;
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->update_batch('work_in_process_material', $data, 'material_id');
        }
        return true;

    }
    /*Update particular field in material through Finish goods */
    public function update_single_column($table, $db_data, $field, $id) {
        $data = $db_data;
        $db_data = $this->get_field_type_data($db_data, $table);
        $this->db->where($field, $id);
        $source = array('opening_balance' => $data);
        $this->db->update('material', $source);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($field, $id);
            $dynamicdb->update('material', $source);
        }
        return true;
    }
    /*******************************************************************end of WIP /finish goods fucntions*************************************************************/
	    public function get_data1($table = '', $where = array(),$limit,$start,$where2,$order,$export_data) {
        $table = $table ? $table : $this->tablename;
		//pagination

		$start = ($start-1) * $limit;
		$start = abs($start);
		
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            //if($table=="material" || $table=="company_detail" || $table=="inventory_listing" || $table=="location_settings" || $table == 'material_type' || $table == 'work_in_process_material'){
            if ($table == "material" || $table == "company_detail" || $table == "inventory_listing" || $table == 'material_type' || $table == 'work_in_process_material' || $table == "uom" || $table == "permissions" || $table == "wip" || $table == "inventory_flow"||$table == "mrp_details" || $table == "wip_request" ) {
                $this->db->select('*');
                $this->db->from($table);
            } else if ($table == "company") {
                $this->db->select($table . '.*,company_detail.address1');
                $this->db->from($table);
                $this->db->join("company_detail", $table . ".id = company_detail.company_id", 'left');
            } else if ($table == "mat_locations") {
                $this->db->select('*');
                $this->db->from($table);
            } else if ($table == "inventory_listing_adjustment") {
                $this->db->select('*');
                $this->db->from($table);
                #}else if($table=="finish_goods"){

            } else if ($table == "finish_goods" || $table == "company_address" || $table == "thrd_party_invtry") {
                $this->db->select('*');
                $this->db->from($table);
                /* }else if($table=="company_address"){
                #$this->db->select($table.'.*,location_settings.area');
                $this->db->select($table.'.*');
                $this->db->from($table);	 */
                #$this->db->join("location_settings", $table . ".compny_branch_id = location_settings.location_id", 'left');
                #$this->db->join("location_settings", $table . ".compny_branch_id = location_settings.location_id", 'left');

            } else {
                $this->db->select($table . '.*,material_type.name as materialType');
                $this->db->from($table);
                $this->db->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            }
            $this->db->where($where);
			if($where2!=''){
		        $this->db->where($where2);
		    }
		    if(isset($_GET['sort'])){
			    $sort=(string)$_GET['sort'];
			    $this->db->order_by('id',$sort);
			}else{
				$this->db->order_by('id',$order);
			}
		    //$dynamicdb->order_by('id',$order);
		    //$dynamicdb->limit($limit, $start);
            //$this->db->order_by('id','desc');
			if($export_data == 0){
				$this->db->limit($limit, $start);
			}
			//echo  $dynamicdb->last_query();
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            //if($table=="material" || $table=="company_detail" || $table=="inventory_listing" || $table=="location_settings" || $table == 'material_type' || $table == 'work_in_process_material'){
            if ($table == "material" || $table == "company_detail" || $table == "inventory_listing" || $table == 'material_type' || $table == 'work_in_process_material' || $table == "uom" || $table == "permissions" || $table == "reoder_level_report" || $table == "wip" || $table == "inventory_flow"||$table == "mrp_details" || $table == "wip_request") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
            } else if ($table == "company") {
                $dynamicdb->select($table . '.*,company_detail.address1');
                $dynamicdb->from($table);
                $dynamicdb->join("company_detail", $table . ".id = company_detail.company_id", 'left');
            } else if ($table == "inventory_listing_adjustment") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
            } else if ($table == "mat_locations") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
                #}else if($table=="finish_goods"){

            } else if ($table == "finish_goods" || $table == "company_address" || $table == "thrd_party_invtry") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
                /* }else if($table=="company_address"){
                $dynamicdb->select($table.'.*,location_settings.area');
                $dynamicdb->from($table);
                #$dynamicdb->join("location_settings", $table . ".compny_branch_id = location_settings.location_id", 'left');
                $dynamicdb->join("location_settings", $table . ".id = location_settings.location_id", 'left'); */
            } else {
                $dynamicdb->select($table . '.*,material_type.name as materialType');
                $dynamicdb->from($table);
                $dynamicdb->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            }
			// pre($where2);
			// pre($export_data);
			if($where2!=''){
		        $dynamicdb->where($where2);
		    }
		    if(isset($_GET['sort'])){
		    	$sort=(string)$_GET['sort'];
			    $dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
			
		    //$dynamicdb->order_by('id',$order);
		    //$dynamicdb->limit($limit, $start);
            $dynamicdb->where($where);
			if($export_data == 0){
				 $dynamicdb->limit($limit, $start);
			}
            $qry = $dynamicdb->get();
            //echo $dynamicdb->last_query();
        }
           // echo $dynamicdb->last_query();
		   //die();
        $result = $qry->result_array();
        return $result;
    }
	 public function get_ledger_data($table = '', $where = array(), $limit = '') {
		$table = $table ? $table : $this->tablename;
		 $dynamicdb = $this->load->database('dynamicdb', TRUE);
		 $dynamicdb->select('*');
         $dynamicdb->from($table);
		 $dynamicdb->where($where);
            $qry = $dynamicdb->get();
			$result = $qry->row_array();
			return $result;
	 }
    /*************************************************************common function *******************************************************************************/
    /* Function to fetch Data of material */ 
   public function get_data($table = '', $where = array(), $limit = '') {
        $table = $table ? $table : $this->tablename;
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            if ($table == "material" || $table == "company_detail" || $table == "inventory_listing" || $table == 'material_type' || $table == 'work_in_process_material' || $table == "uom" || $table == "permissions" || $table =="work_order" || $table == "mrp_details" || $table=="daily_report_setting" || $table=="lot_details" || $table=="reserved_material" ) {
                $this->db->select('*');
                $this->db->from($table);
            } else if ($table == "company") {
                $this->db->select($table . '.*,company_detail.address1');
                $this->db->from($table);
                $this->db->join("company_detail", $table . ".id = company_detail.company_id", 'left');
            } else if ($table == "mat_locations") {
                $this->db->select('*');
                $this->db->from($table);
            } else if ($table == "inventory_listing_adjustment" || $table == "material_variants") {
                $this->db->select('*');
                $this->db->from($table);
            } else if ($table == "finish_goods" || $table == "company_address" || $table == "thrd_party_invtry" || $table == "tag_types" || $table == "tag_details" || $table == "inventory_flow") {
                $this->db->select('*');
                $this->db->from($table);
            } else {
                $this->db->select($table . '.*,material_type.name as materialType');
                $this->db->from($table);
                $this->db->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            }
            $this->db->where($where);
            //$this->db->order_by('id','desc');
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            if ($table == "material" || $table == "company_detail" || $table == "inventory_listing" || $table == 'material_type' || $table == 'work_in_process_material' || $table == "uom" || $table == "permissions" || $table =="work_order" || $table == "mrp_details" || $table=="daily_report_setting" || $table=="lot_details"  || $table=="reserved_material"   || $table == "variant_types" || $table == "variant_options" || $table == "stock_permission") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
            } else if ($table == "company") {
                $dynamicdb->select($table . '.*,company_detail.address1');
                $dynamicdb->from($table);
                $dynamicdb->join("company_detail", $table . ".id = company_detail.company_id", 'left');
            } else if ($table == "inventory_listing_adjustment" || $table == "material_variants") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
            } else if ($table == "mat_locations") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
            } else if ($table == "finish_goods" || $table == "company_address" || $table == "thrd_party_invtry"  || $table == "tag_types" || $table == "tag_details" || $table == "inventory_flow") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
            } else {
                $dynamicdb->select($table . '.*,material_type.name as materialType');
                $dynamicdb->from($table);
                $dynamicdb->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            }
            $dynamicdb->where($where);
            $qry = $dynamicdb->get();
              // echo $dynamicdb->last_query();die('asdf');
        }
        $result = $qry->result_array();
        return $result;
    }

    /*** Get all users by ids */
    public function getUserAll($table, $emailIds){
        //pre($emailIds);die;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		// $dynamicdb->where_in($emailIds);
	    if($emailIds != ''){
		    $dynamicdb->where_in('id', $emailIds);
		}
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();
		$result = $qry->result_array();
		return $result;
    }
    /* common function for Insert Data */
    public function insert_tbl_data($table, $data) {

        #pre($data);
        #die;
        $fieldData = $this->get_field_type_data($data, $table);
        $this->db->insert($table, $fieldData);
        $insertedid = $this->db->insert_id();
        if ($insertedid) {
            //&& $_SESSION['loggedInUser']->role != 3
            if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
                $fieldData['id'] = $insertedid;
                $dynamicdb = $this->load->database('dynamicdb', TRUE);
                $dynamicdb->insert($table, $fieldData);
                $dynamicdb->insert_id();
            }
        }
       // echo $this->db->last_query();
        // echo '<br />';
         // echo $dynamicdb->last_query();
         // die;
        return $insertedid;
    }
	
	public function insert_tbl_data2($table, $data) {

        #pre($data);
        #die;
        $fieldData = $this->get_field_type_data($data, $table);
        $this->db->insert($table, $fieldData);
        $insertedid = $this->db->insert_id();
        if ($insertedid) {
            //&& $_SESSION['loggedInUser']->role != 3
            if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
                $fieldData['id'] = $insertedid;
                $dynamicdb = $this->load->database('dynamicdb', TRUE);
                $dynamicdb->insert($table, $fieldData);
                $dynamicdb->insert_id();
            }
        }
       // echo $this->db->last_query();
       //  echo '<br />';
       //   echo $dynamicdb->last_query();
       //   die;
        return $insertedid;
    }
	
	
	
    /*common functon for Update Data*/
    public function update_data($table, $db_data, $field, $id) {
        $data = $db_data;
        $db_data = $this->get_field_type_data($db_data, $table);
        $this->db->where($field, $id);
        $result = $this->db->update($table, $db_data);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($field, $id);
            $dynamicdb->update($table, $db_data);
        }
        // echo $dynamicdb->last_query();
         // die;
        return true;
    }
    /* Function to fetch Data by Id of material */
	
    public function get_data_byId($table, $field, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            if ($table == "material") {
                $this->db->select($table . '.*, material_type.name as materialtype ');
                $this->db->from($table);
                $this->db->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            } else if ($table == 'inventory_listing' || $table == 'location_settings' || $table == 'material_type' || $table == 'company_address' || $table == 'work_in_process_material' || $table == 'finish_goods' || $table == 'thrd_party_invtry' || $table == 'material' || $table == 'wip_request') {
                $this->db->select($table . '.*');
                $this->db->from($table);
            }else{
				$this->db->select($table . '.*');
                $this->db->from($table);
			}
            $this->db->where($table . '.' . $field, $id);
            $qry = $this->db->get();
            //pre($this->db->last_query());
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            if ($table == "material") {
                $dynamicdb->select($table . '.*, material_type.name as materialtype ');
                $dynamicdb->from($table);
                $dynamicdb->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            } else if ($table == 'inventory_listing' || $table == 'location_settings' || $table == 'material_type' || $table == 'company_address'|| $table == 'work_in_process_material' || $table == 'finish_goods' || $table == 'thrd_party_invtry' || $table == 'material' || $table == 'wip_request') {
                $dynamicdb->select($table . '.*');
                $dynamicdb->from($table);
            }else{
				  $dynamicdb->select($table . '.*');
                $dynamicdb->from($table);
			}

            $dynamicdb->where($table . '.' . $field, $id);
            $qry = $dynamicdb->get();
        }
       // echo $dynamicdb->last_query(); die;
        $result = $qry->row();
        return $result;
    }

    /*Function to delete data from selected Table */
    public function delete_data($table, $field, $id) {
        $this->db->where($field, $id);
        $this->db->delete($table);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($field, $id);
            $dynamicdb->delete($table);
			//echo $dynamicdb->last_query();die();
        }
        return true;
    }

    public function truncate_table($table){
        $this->db->truncate($table);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->truncate($table);
        return true;
    }

    /*************************************************************inventory listing function call at the time of save*************************************************/
    /*Update closing balance field in material when save MOVE/STOCK CHECK/CONVERSION/CONSUMED/SCRAP action in listing*/
    public function update_qty_data($table, $db_data, $field, $id) {
        $data = $db_data;
        $db_data = $this->get_field_type_data($db_data, $table);
        $this->db->where($field, $id);
        $source = array('opening_balance' => $data);
        //pre($this->db->last_query());die;
        $this->db->update('material', $source);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($field, $id);
            $dynamicdb->update('material', $source);
        }
        return true;
    }
    /*update particular fields in material data after conversion */
    public function update_material_data_after_conversion($table, $db_data, $field, $id) {
        $data = $db_data;
        $db_data = $this->get_field_type_data($db_data, $table);
        $this->db->where($field, $id);
        $source = array("closing_balance" => $data['closing_balance'], 'location' => $data['location']);
        $this->db->update('material', $source);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($field, $id);
            $dynamicdb->update('material', $source);
        }
        return true;
    }
    /******************************************************function call for MATERIAL***********************************************************/
    /*change status in material when click on toggle */
    public function change_status_toggle($id, $status) {
        $this->db->where('id', $id);
        $status = array('status' => $status);
        $this->db->update('material', $status);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('id', $id);
            $dynamicdb->update('material', $status);
        }
        return true;
    }
    /*function to ftech image by id*/
    public function get_image_by_materialId($table, $field, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where($field, $id);
            $this->db->where('rel_type', 'material');
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($field, $id);
            $dynamicdb->where('rel_type', 'material');
            $qry = $dynamicdb->get();
        }
        $result = $qry->result_array();
        return $result;
    }
    /* Insert attachment Data */
    public function insert_attachment_data($table, $data = array(), $type) {
        if (!empty($data)) {
            foreach ($data as $dt) {
                $fieldData = $this->get_field_type_data($dt, $table);
                $this->db->insert($table, $fieldData);
                $insertedid = $this->db->insert_id();
                if ($insertedid) {
                    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
                        $dynamicdb = $this->load->database('dynamicdb', TRUE);
                        $fieldData['id'] = $insertedid;
                        $dynamicInsertedid = $dynamicdb->insert($table, $fieldData);
                    }
                }
            }
            return $insertedid;
        }
    }
	
	
	public function update_attachment_data($table, $data = array(), $type) {
		 if (!empty($data)) {
            foreach ($data as $dt) {
			// $fieldData = $this->get_field_type_data($dt, $table);
               	$this->db->set('file_name', $dt['file_name']);
				$this->db->where('rel_id',$dt['rel_id']);
				$this->db->where('rel_type',$type);
				$this->db->update($table);
			
                        $dynamicdb = $this->load->database('dynamicdb', TRUE);
                    	$dynamicdb->set('file_name', $dt['file_name']);
						$dynamicdb->where('rel_id',$dt['rel_id']);
						$dynamicdb->where('rel_type',$type);
						$dynamicdb->update($table);
						$dynamicdb->affected_rows();
            }
			return $dynamicdb->affected_rows();;
			
        }
    }

    /* Insert attachment Data */
    public function insert_single_attachment_data($table, $data = array(), $type) {
        if (!empty($data)) {
                $fieldData = $this->get_field_type_data($data, $table);
                $this->db->insert($table, $fieldData);
                $insertedid = $this->db->insert_id();
                if ($insertedid) {
                    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
                        $dynamicdb = $this->load->database('dynamicdb', TRUE);
                        $fieldData['id'] = $insertedid;
                        $dynamicInsertedid = $dynamicdb->insert($table, $fieldData);
                    }
                }
            return $insertedid;
        }
    }

	public function getNameById($table,$id,$field){
		  $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($field, $id);
			$qry = $dynamicdb->get();
			// echo $dynamicdb->last_query();die();
        $result = $qry->row();
        return $result;
		}
		public function getNameByIdVAriant($table,$id,$field){
		  $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($field, $id);
			$qry = $dynamicdb->get();
			// echo $dynamicdb->last_query();die();
        $result = $qry->result_array();
        return $result;
		}
    /*get address byy location */
    public function get_data_byLcoationArea($table, $data) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('area');
            $this->db->from($table);
            //$this->db->where('location_id', $data);
            $this->db->where('id', $data);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('area');
            $dynamicdb->from($table);
            //$dynamicdb->where('location_id', $data);
            $dynamicdb->where('id', $data);
            $qry = $dynamicdb->get();
        }
        $result = $qry->result_array();
		//pre($dynamicdb->last_query());
        return $result;
    }
    /*********************insert tags***********************/
    public function insert_tags_data($rel_id, $rel_type, $tags = array()) {
        if (!empty($tags)) {
            $this->db->trans_start();
            /* Delete previous Tags*/
            $this->db->where(array("rel_id" => $rel_id, "rel_type" => $rel_type));
            if ($this->db->delete("tags_in")) {
                if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
                    $dynamicdb = $this->load->database('dynamicdb', TRUE);
                    $dynamicdb->where(array("rel_id" => $rel_id, "rel_type" => $rel_type));
                    $dynamicdb->delete("tags_in");
                }
            }
            $i = 1;
            foreach ($tags as $dt) {
                $tag_id = $dt;
                if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
                    $this->db->select('*');
                    $this->db->from('tags');
                    $this->db->where('id', $dt);
                    $qry = $this->db->get();
                } else {
                    $dynamicdb = $this->load->database('dynamicdb', TRUE);
                    $dynamicdb->select('*');
                    $dynamicdb->from('tags');
                    $dynamicdb->where('id', $dt);
                    $qry = $dynamicdb->get();
                }
                $result = $qry->row();
                if (empty($result)) {
                    $data2[$i]["name"] = $dt;
                    $this->db->insert("tags", $data2[$i]);
                    $tag_id = $this->db->insert_id();
                    if ($tag_id) {
                        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
                            $data2[$i]['id'] = $tag_id;
                            $dynamicdb->insert("tags", $data2[$i]);
                            #$tag_id = $dynamicdb->insert_id();
                            $dynamicdb->insert_id();
                        }
                    }
                }
                $data1[$i]["tag_id"] = $tag_id;
                $data1[$i]["rel_id"] = $rel_id;
                $data1[$i]["rel_type"] = $rel_type;
                $data1[$i]["tag_order"] = $i;
                $this->db->insert("tags_in", $data1[$i]);
                if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
                    $dynamicdb->insert("tags_in", $data1[$i]);
                }
                $i++;
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) $dynamicdb->trans_rollback();
            } else {
                $this->db->trans_complete();
                if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) $dynamicdb->trans_complete();
            }
        }
        return true;
    }
    /*ftehc tags value in material edit page*/
    public function get_tags_data($table, $field, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('tags.name as tagname , tags_in.tag_order as order_id , tags.id as TagId');
            $this->db->from('tags_in');
            $this->db->join("tags", "tags_in.tag_id = tags.id", 'left');
            $this->db->where(array('rel_id' => $id));
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('tags.name as tagname , tags_in.tag_order as order_id , tags.id as TagId');
            $dynamicdb->from('tags_in');
            $dynamicdb->join("tags", "tags_in.tag_id = tags.id", 'left');
            $dynamicdb->where(array('rel_id' => $id));
            $qry = $dynamicdb->get();
        }
        //pre($dynamicdb->last_query());
        $result = $qry->result_array();
        return $result;
    }
    /*******************************************************************material tyep fucntion ***********************************************************************/
    /*delete fucntion to change status */
    public function change_status_material_type($table, $id, $status) {
        $this->db->where('id', $id);
        $status = array('status' => $status);
        $this->db->update($table, $status);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('id', $id);
            $dynamicdb->update($table, $status);
        }
        return true;
    }
    /*get prefixx and sub type data in material  */
    public function get_prefix_and_subType_data($table, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('prefix as Prefix  , sub_type as SubType');
            $this->db->from($table);
            $this->db->where('id', $id);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('prefix as Prefix  , sub_type as SubType');
            $dynamicdb->from($table);
            $dynamicdb->where('id', $id);
            $qry = $dynamicdb->get();
        }
        $result = $qry->row();
        return $result;
    }
    /**********************dashboard functions**************************/
    public function get_data_Move($table = '', $where = array()) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where('action_type', 'Move');
            $dynamicdb->where($where);
            $dynamicdb->order_by('action_type', 'DESC');
            $dynamicdb->limit(3);
            $qry = $dynamicdb->get();
            //pre($this->db->last_query()); die;
            $result = $qry->result_array();
            return $result;
        }
    }
    public function get_data_Not_Move($table = '', $where = array()) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            //get material ids with action type move from last three months
            $dynamicdb->select('material.id ,material.material_name as materialName');
            $dynamicdb->from($table);
            $dynamicdb->join("inventory_listing", $table . ".id = inventory_listing.material_name_id", 'left');
            $dynamicdb->where('inventory_listing.action_type =', 'move');
            $dynamicdb->where('material.created_date >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)');
            $qry = $dynamicdb->get();
            //convert and get  these ids into single array with comma separation
            $insertArray = array();
            foreach ($qry->result_array() as $Query) {
                $insertArray[] = $Query['id'];
            }
            $arrayValue = implode(',', $insertArray);
            $getNotMoveValue_query = "SELECT * FROM inventory_listing WHERE material_name_id NOT IN(119,119,194,231) ORDER BY material_name_id DESC LIMIT 5";
            $qryy = $dynamicdb->query($getNotMoveValue_query);
            $result = $qryy->result_array();
            return $result;
        }
    }
    public function getMatrial_history($matid = false) {
        $field = '%"material_name_id":"' . $matid . '"%';
		 
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
			$query = $dynamicdb->query("(SELECT  DISTINCT mrn_detail.created_date,mrn_detail.id,mrn_detail.status,mrn_detail.material_name FROM mrn_detail where ( mrn_detail.material_name LIKE '$field')ORDER BY complete_date DESC LIMIT 10 )");
			// $query = $this->db->query("(SELECT DISTINCT purchase_indent.complete_date,purchase_indent.id,purchase_indent.status,purchase_indent.material_name FROM purchase_indent where (pay_or_not = 1 AND ifbalance = 0 AND purchase_indent.material_name LIKE '$field') ORDER BY complete_date DESC LIMIT 10)
			// UNION
			// (SELECT DISTINCT purchase_order.complete_date,purchase_order.id,purchase_order.status,purchase_order.material_name FROM purchase_order where (pay_or_not = 1 AND ifbalance = 0 AND purchase_order.material_name LIKE '$field') ORDER BY complete_date DESC LIMIT 10 )
			// UNION
			// (SELECT DISTINCT mrn_detail.complete_date,mrn_detail.id,mrn_detail.status,mrn_detail.material_name FROM mrn_detail where (pay_or_not = 1 AND ifbalance = 0 AND mrn_detail.material_name LIKE '$field')ORDER BY complete_date DESC LIMIT 10 )  ");
        } else {
			
			// echo "SELECT  DISTINCT mrn_detail.created_date,mrn_detail.id,mrn_detail.status,mrn_detail.material_name FROM mrn_detail where ( mrn_detail.material_name LIKE '$field')ORDER BY complete_date DESC LIMIT 10 ";

			// $query = $dynamicdb->query("(SELECT  DISTINCT purchase_indent.complete_date,purchase_indent.id,purchase_indent.status,purchase_indent.material_name FROM purchase_indent where (pay_or_not = 1 AND ifbalance = 0 AND purchase_indent.material_name LIKE '$field') ORDER BY complete_date DESC LIMIT 10)
			// UNION
			// (SELECT DISTINCT purchase_order.complete_date,purchase_order.id,purchase_order.status,purchase_order.material_name FROM purchase_order where (pay_or_not = 1 AND ifbalance = 0 AND purchase_order.material_name LIKE '$field') ORDER BY complete_date DESC LIMIT 10 )
			// UNION
			// (SELECT  DISTINCT mrn_detail.complete_date,mrn_detail.id,mrn_detail.status,mrn_detail.material_name FROM mrn_detail where (pay_or_not = 1 AND ifbalance = 0 AND mrn_detail.material_name LIKE '$field')ORDER BY complete_date DESC LIMIT 10 )");
			$query = $dynamicdb->query("(SELECT  DISTINCT mrn_detail.created_date,mrn_detail.id,mrn_detail.status,mrn_detail.material_name FROM mrn_detail where ( mrn_detail.material_name LIKE '$field')ORDER BY complete_date DESC LIMIT 10 )");
			

        }
         if($matid)
        {
            return $query->result_array();
        }
        return $query->result_array();
    }
    public function getMonthlyReport() {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $query = $dynamicdb->query("SELECT mt.id , mt.name, ( SELECT sum(winp.quantity)  FROM work_in_process_material winp  WHERE winp.material_type_id=mt.id AND created_by_cid=" . $this->companyId . " ) sumMaterialIssued,( SELECT sum(material.opening_balance) FROM material WHERE material.material_type_id=mt.id ) sumOpeningBalance   FROM material_type mt");
      # echo $dynamicdb->last_query();die;
        $result = $query->result_array();
        if (!empty($result)) {
            $i = 0;
            $k = 0;
            $result[$k]['materialTypeClosingBalance'] = 0;
            foreach ($result as $res) {
                $matQuery = $dynamicdb->query("SELECT id,material_name FROM material where created_by_cid=" . $this->companyId . " AND material_type_id=" . $res['id'] . " AND status=1");

                $matRes = $matQuery->result_array();
                $materialTypeClosingBalance = 0;
                $res[$i]['materialTypeClosingBalance'] = 0;
                if (!empty($matRes)) {
                    foreach ($matRes as $mr) {
                        $materialTypeClosingBalance = getClosingBalance($mr['id']);
                        $res[$i]['materialTypeClosingBalance']+= $materialTypeClosingBalance;
                    }
                    $result[$k]['materialTypeClosingBalance'] = $res[$i]['materialTypeClosingBalance'];
                } else {
                    $result[$k]['materialTypeClosingBalance'] = 0;
                }
                $k++;
            }
        }
        return $result;
    }
    /*************************combine inventory listign and adjustment funcion **************************/
    /*public function get_data_fromMaterial($table,$where){
    if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
    $this->db->select($table.'.material_name,material.sub_type,material.id as materialId,material.material_type_id,material.uom,material.location,material_type.name,material_type.id');
    $this->db->from($table);
    $this->db->join("material_type", $table . ".material_type_id = material_type.id", 'left');
    //$this->db->like('location', '"location":"'.$company_unit_id.'"');
    $this->db->where($where);
    //$this->db->where("material_type.used_status",1);
    $this->db->order_by("material_type.id,material.sub_type", "Asc");
    $qry = $this->db->get();

    $result = $qry->result_array();
    $resultArray = array();
    $i= 0;
    foreach($result as $res){
    ////$data1 = $this->db->query("select so_order from sale_order where product LIKE %".$res['materialId']."%");
    //pre($data1);
    $data = $this->db->query("select half_or_full_book from inventory_listing_adjustment where action_type ='half_full_book' AND material_name_id='".$res['materialId']."'");
    $half_full_book = $data->row_array();
    $resultArray[$res['id']]['material_type_name']=$res['name'];
    $resultArray[$res['id']]['material_type_id']=$res['material_type_id'];
    $resultArray[$res['id']]['sub_type'][]= array('sub_type'=>$res['sub_type'],'material_name'=>$res['material_name'],'material_name_id'=>$res['materialId'],'uom'=>$res['uom'],'location'=>$res['location'],'half_full_book'=>$half_full_book);
    //$resultArray[$res['id']]['sub_type'][]= array('sub_type'=>$res['sub_type'],'material_name'=>$res['material_name'],'material_name_id'=>$res['materialId'],'uom'=>$res['uom'],'location'=>$res['location']);
    $i++;

    }
    }else{
    $dynamicdb = $this->load->database('dynamicdb', TRUE);
    $dynamicdb->select($table.'.material_name,material.sub_type,material.id as materialId,material.material_type_id,material.uom,material.location,material_type.name,material_type.id');
    $dynamicdb->from($table);
    $dynamicdb->join("material_type", $table . ".material_type_id = material_type.id", 'left');
    //$dynamicdb->like('location', '"location":"'.$company_unit_id.'"');
    $dynamicdb->where($where);
    //$dynamicdb->where("material_type.used_status",1);
    $dynamicdb->order_by("material_type.id,material.sub_type", "Asc");
    $qry =$dynamicdb->get();
    //pre($dynamicdb->last_query());
    $result = $qry->result_array();
    $resultArray = array();
    $i= 0;
    foreach($result as $res){
    $data = $dynamicdb->query("select half_or_full_book from inventory_listing_adjustment where action_type ='half_full_book' AND material_name_id='".$res['materialId']."'");
    $half_full_book = $data->row_array();
    $resultArray[$res['id']]['material_type_name']=$res['name'];
    $resultArray[$res['id']]['material_type_id']=$res['material_type_id'];
    $resultArray[$res['id']]['sub_type'][]= array('sub_type'=>$res['sub_type'],'material_name'=>$res['material_name'],'material_name_id'=>$res['materialId'],'uom'=>$res['uom'],'location'=>$res['location'],'half_full_book'=>$half_full_book);
    $i++;

    }
    /*$CombinedArray = array();

    foreach($resultArray as $rel){
    $material_name =
    foreach($rel['sub_type'] as $type){

    	$subtypeArray[] = $type['sub_type'];
    	$uniqeArrayvalue = array_unique($subtypeArray);
    	foreach($uniqeArrayvalue as $key => $unique_value){

    		if($unique_value == $type['sub_type']){
    		//$CombinedArray[$val["sub_type"]]["sub_type"] = $val;

    		$CombinedArray[$type["sub_type"]]["sub_type"] = $type["sub_type"];
    		$CombinedArray[$type["sub_type"]][]= array('material_name'=>$type["material_name"],'material_name_id'=>$type["material_name_id"],'uom'=> $type["uom"],'location'=>$type["location"]);
    /* $CombinedArray[$type["sub_type"]]["material_name"][] = $type["material_name"];
    		$CombinedArray[$type["sub_type"]]["material_name_id"][] = $type["material_name_id"];
    		$CombinedArray[$type["sub_type"]]["uom"][] = $type["uom"];
    		$CombinedArray[$type["sub_type"]]["location"][] = $type["location"];

    		}
    	}

    }

    }*/
    //pre($resultArray);
    /*}
    return $resultArray;
    }*/

    // 28-02-2022
   //  public function get_data_fromMaterial($table, $where) {
   //      if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
   //          $this->db->select($table . '.material_name, material.sub_type, material.id as materialId, material.material_type_id, material.uom, material.location, material.closing_balance, material_type.name, material_type.id, mat_locations.id as matLocId, mat_locations.location_id, mat_locations.Storage, mat_locations.RackNumber, mat_locations.quantity, mat_locations.Qtyuom, mat_locations.physical_stock, mat_locations.balance, rm.id as rm_id,rm.customer_id,rm.customer_id,rm.available_quantity,rm.quantity as reserve_quentity');
   //          $this->db->from($table);
   //          $this->db->join("material_type", $table . ".material_type_id = material_type.id", 'left');
   //          $this->db->join("mat_locations", $table . ".id = mat_locations.material_name_id", 'left');
   //          $this->db->join("reserved_material as rm", $table . ".id = rm.mayerial_id", 'left');
   //          $this->db->where($where);
   //          $this->db->where($table .'.'.'non_inventry_material !=',1);
   //          $this->db->order_by("material_type.id,material.sub_type", "Asc");
   //          $qry = $this->db->get();
   //          $result = $qry->result_array();
   //          $resultArray = array();
   //          $subtypeArray = array();
   //          $CombinedArray = array();
   //          $locationIndex = array();
   //          $locIndex = array();
   //          foreach ($result as $subarray){
   //              if (!isset($locIndex[$subarray['materialId']])) $locIndex[$subarray['materialId']] = array('materialId' => $subarray['materialId'], 'location' => array());
   //              $locIndex[$subarray['materialId']]['material_type_name'] = $subarray['name'];
   //              $locIndex[$subarray['materialId']]['material_type_id'] = $subarray['material_type_id'];
   //              $locIndex[$subarray['materialId']]['sub_type'] = $subarray['sub_type'];
   //              $locIndex[$subarray['materialId']]['material_name'] = $subarray['material_name'];
   //              $locIndex[$subarray['materialId']]['material_name_id'] = $subarray['materialId'];
   //              $locIndex[$subarray['materialId']]['uom'] = $subarray['uom'];
   //              $locIndex[$subarray['materialId']]['closing_balance'] = $subarray['closing_balance'];
   //              $locIndex[$subarray['materialId']]['location'][] = array('id' => $subarray['matLocId'], 'location' => $subarray['location_id'], 'area' => $subarray['Storage'], 'rack_no' => $subarray['RackNumber'], 'qty' => $subarray['quantity'], 'Qtyuom' => $subarray['Qtyuom'] , 'physical_stock' => $subarray['physical_stock'], 'balance' => $subarray['balance']);
   //              /* $locIndex[$subarray['materialId']]['area'][] = $subarray['Storage'];
   //              $locIndex[$subarray['materialId']]['RackNumber'][] = $subarray['RackNumber'];
   //              $locIndex[$subarray['materialId']]['Qtyuom'][] = $subarray['Qtyuom'];
   //              $locIndex[$subarray['materialId']]['quantity'][] = $subarray['quantity']; */
			// 	$locIndex[$subarray['materialId']]['reserved_material'][] = array('id' => $subarray['rm_id'],'customer_id' => $subarray['customer_id'], 'available_quantity' => $subarray['available_quantity'], 'quantity' => $subarray['reserve_quentity']);
   //          }
   //      } else {
   //          $dynamicdb = $this->load->database('dynamicdb', TRUE);
			// $dynamicdb->select($table . '.material_name, material.sub_type, material.id as materialId, material.material_type_id, material.uom, material.location, material.closing_balance, material_type.name, material_type.id, mat_locations.id as matLocId, mat_locations.location_id, mat_locations.Storage, mat_locations.RackNumber, mat_locations.quantity, mat_locations.Qtyuom, mat_locations.physical_stock, mat_locations.balance, rm.id as rm_id, rm.customer_id,rm.customer_id,rm.available_quantity,rm.quantity as reserve_quentity');
   //          $dynamicdb->from($table);
   //          $dynamicdb->join("material_type", $table . ".material_type_id = material_type.id", 'left');
   //          $dynamicdb->join("mat_locations", $table . ".id = mat_locations.material_name_id", 'left');
			// $dynamicdb->join("reserved_material as rm", $table . ".id = rm.mayerial_id", 'left');
   //          $dynamicdb->where($where);
   //          $dynamicdb->where($table .'.'.'non_inventry_material !=',1);
   //          $dynamicdb->order_by("material_type.id,material.sub_type", "Asc");
   //          $qry = $dynamicdb->get();
   //          #echo  $dynamicdb->last_query();
   //          $result = $qry->result_array();
   //          $resultArray = array();
   //          $subtypeArray = array();
   //          $CombinedArray = array();
   //          $locationIndex = array();
   //          $locIndex = array();
   //          foreach ($result as $subarray) {
   //              if (!isset($locIndex[$subarray['materialId']])) $locIndex[$subarray['materialId']] = array('materialId' => $subarray['materialId'], 'location' => array());
   //              $locIndex[$subarray['materialId']]['material_type_name'] = $subarray['name'];
   //              $locIndex[$subarray['materialId']]['material_type_id'] = $subarray['material_type_id'];
   //              $locIndex[$subarray['materialId']]['sub_type'] = $subarray['sub_type'];
   //              $locIndex[$subarray['materialId']]['material_name'] = $subarray['material_name'];
   //              $locIndex[$subarray['materialId']]['material_name_id'] = $subarray['materialId'];
   //              $locIndex[$subarray['materialId']]['uom'] = $subarray['uom'];
   //              $locIndex[$subarray['materialId']]['closing_balance'] = $subarray['closing_balance'];
   //              $locIndex[$subarray['materialId']]['location'][] = array('id' => $subarray['matLocId'], 'location' => $subarray['location_id'], 'area' => $subarray['Storage'], 'rack_no' => $subarray['RackNumber'], 'qty' => $subarray['quantity'], 'Qtyuom' => $subarray['Qtyuom'], 'physical_stock' => $subarray['physical_stock'], 'balance' => $subarray['balance']);
   //              /* $locIndex[$subarray['materialId']]['area'][] = $subarray['Storage'];
   //              $locIndex[$subarray['materialId']]['RackNumber'][] = $subarray['RackNumber'];
   //              $locIndex[$subarray['materialId']]['Qtyuom'][] = $subarray['Qtyuom'];
   //              $locIndex[$subarray['materialId']]['quantity'][] = $subarray['quantity']; */
			// 	$locIndex[$subarray['materialId']]['reserved_material'][] = array('id' => $subarray['rm_id'],'customer_id' => $subarray['customer_id'], 'available_quantity' => $subarray['available_quantity'], 'quantity' => $subarray['reserve_quentity']);
   //          }
   //          //pre($locIndex);
   //      }
   //      return $locIndex;
   //  }
   
   public function get_data_fromMaterial($table, $where) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select($table . '.material_name, material.sub_type, material.id as materialId, material.material_type_id, material.uom, material.location, material.closing_balance, material_type.name, material_type.id, mat_locations.id as matLocId, mat_locations.location_id, mat_locations.Storage, mat_locations.RackNumber, mat_locations.quantity, mat_locations.Qtyuom, mat_locations.physical_stock, mat_locations.balance, rm.id as rm_id,rm.customer_id,rm.customer_id,rm.available_quantity,rm.quantity as reserve_quentity');
            $this->db->from($table);
            $this->db->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            $this->db->join("mat_locations", $table . ".id = mat_locations.material_name_id", 'left');
            $this->db->join("reserved_material as rm", $table . ".id = rm.mayerial_id", 'left');
            $this->db->where($where);
            $this->db->where($table .'.'.'non_inventry_material !=',1);
            $this->db->order_by("material_type.id,material.sub_type", "Asc");
            $qry = $this->db->get();
            $result = $qry->result_array();
            $resultArray = array();
            $subtypeArray = array();
            $CombinedArray = array();
            $locationIndex = array();
            $locIndex = array();
            foreach ($result as $subarray){
                if (!isset($locIndex[$subarray['materialId']])) $locIndex[$subarray['materialId']] = array('materialId' => $subarray['materialId'], 'location' => array());
                $locIndex[$subarray['materialId']]['material_type_name'] = $subarray['name'];
                $locIndex[$subarray['materialId']]['material_type_id'] = $subarray['material_type_id'];
                $locIndex[$subarray['materialId']]['sub_type'] = $subarray['sub_type'];
                $locIndex[$subarray['materialId']]['material_name'] = $subarray['material_name'];
                $locIndex[$subarray['materialId']]['material_name_id'] = $subarray['materialId'];
                $locIndex[$subarray['materialId']]['uom'] = $subarray['uom'];
                $locIndex[$subarray['materialId']]['closing_balance'] = $subarray['closing_balance'];
                $locIndex[$subarray['materialId']]['location'][] = array('id' => $subarray['matLocId'], 'location' => $subarray['location_id'], 'area' => $subarray['Storage'], 'rack_no' => $subarray['RackNumber'], 'qty' => $subarray['quantity'], 'Qtyuom' => $subarray['Qtyuom'] , 'physical_stock' => $subarray['physical_stock'], 'balance' => $subarray['balance']);
                /* $locIndex[$subarray['materialId']]['area'][] = $subarray['Storage'];
                $locIndex[$subarray['materialId']]['RackNumber'][] = $subarray['RackNumber'];
                $locIndex[$subarray['materialId']]['Qtyuom'][] = $subarray['Qtyuom'];
                $locIndex[$subarray['materialId']]['quantity'][] = $subarray['quantity']; */
				$locIndex[$subarray['materialId']]['reserved_material'][] = array('id' => $subarray['rm_id'],'customer_id' => $subarray['customer_id'], 'available_quantity' => $subarray['available_quantity'], 'quantity' => $subarray['reserve_quentity']);
            }
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select($table . '.material_name, material.sub_type, material.id as materialId, material.material_type_id, material.uom, material.location, material.closing_balance, material_type.name, material_type.id, mat_locations.id as matLocId, mat_locations.location_id, mat_locations.Storage, mat_locations.RackNumber, mat_locations.quantity, mat_locations.Qtyuom, mat_locations.physical_stock, mat_locations.balance, rm.id as rm_id, rm.customer_id,rm.customer_id,rm.available_quantity,rm.quantity as reserve_quentity');
            $dynamicdb->from($table);
            $dynamicdb->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            $dynamicdb->join("mat_locations", $table . ".id = mat_locations.material_name_id", 'left');
			$dynamicdb->join("reserved_material as rm", $table . ".id = rm.mayerial_id", 'left');
            $dynamicdb->where($where);
            $dynamicdb->where($table .'.'.'non_inventry_material !=',1);
            $dynamicdb->order_by("material_type.id,material.sub_type", "Asc");
            $qry = $dynamicdb->get();
            #echo  $dynamicdb->last_query();
            $result = $qry->result_array();
            $resultArray = array();
            $subtypeArray = array();
            $CombinedArray = array();
            $locationIndex = array();
            $locIndex = array();
            foreach ($result as $subarray) {
                if (!isset($locIndex[$subarray['materialId']])) $locIndex[$subarray['materialId']] = array('materialId' => $subarray['materialId'], 'location' => array());
                $locIndex[$subarray['materialId']]['material_type_name'] = $subarray['name'];
                $locIndex[$subarray['materialId']]['material_type_id'] = $subarray['material_type_id'];
                $locIndex[$subarray['materialId']]['sub_type'] = $subarray['sub_type'];
                $locIndex[$subarray['materialId']]['material_name'] = $subarray['material_name'];
                $locIndex[$subarray['materialId']]['material_name_id'] = $subarray['materialId'];
                $locIndex[$subarray['materialId']]['uom'] = $subarray['uom'];
                $locIndex[$subarray['materialId']]['closing_balance'] = $subarray['closing_balance'];
                $locIndex[$subarray['materialId']]['location'][] = array('id' => $subarray['matLocId'], 'location' => $subarray['location_id'], 'area' => $subarray['Storage'], 'rack_no' => $subarray['RackNumber'], 'qty' => $subarray['quantity'], 'Qtyuom' => $subarray['Qtyuom'], 'physical_stock' => $subarray['physical_stock'], 'balance' => $subarray['balance']);
                /* $locIndex[$subarray['materialId']]['area'][] = $subarray['Storage'];
                $locIndex[$subarray['materialId']]['RackNumber'][] = $subarray['RackNumber'];
                $locIndex[$subarray['materialId']]['Qtyuom'][] = $subarray['Qtyuom'];
                $locIndex[$subarray['materialId']]['quantity'][] = $subarray['quantity']; */
				$locIndex[$subarray['materialId']]['reserved_material'][] = array('id' => $subarray['rm_id'],'customer_id' => $subarray['customer_id'], 'available_quantity' => $subarray['available_quantity'], 'quantity' => $subarray['reserve_quentity']);
            }
            //pre($locIndex);
        }
        return $locIndex;
    }
    public function get_data_fromMaterial_bakup_15072022($table, $where) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select($table . '.material_name, material.sub_type, material.id as materialId, material.material_type_id, material.uom, material.location, material.closing_balance, material_type.name, material_type.id, mat_locations.id as matLocId, mat_locations.location_id, mat_locations.Storage, mat_locations.RackNumber, mat_locations.quantity, mat_locations.Qtyuom, mat_locations.physical_stock, mat_locations.balance, mat_locations.lot_no, rm.id as rm_id,rm.customer_id,rm.customer_id,rm.available_quantity,rm.quantity as reserve_quentity');
            $this->db->from($table);
            $this->db->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            $this->db->join("mat_locations", $table . ".id = mat_locations.material_name_id", 'left');
            $this->db->join("reserved_material as rm", $table . ".id = rm.mayerial_id", 'left');
            $this->db->where($where);
            $this->db->where($table .'.'.'non_inventry_material !=',1);
            $this->db->order_by("material_type.id,material.sub_type", "Asc");
            $qry = $this->db->get();
            $result = $qry->result_array();
            $resultArray = array();
            $subtypeArray = array();
            $CombinedArray = array();
            $locationIndex = array();
            $locIndex = array();
            foreach ($result as $subarray){
                if (!isset($locIndex[$subarray['materialId']])) $locIndex[$subarray['materialId']] = array('materialId' => $subarray['materialId'], 'location' => array());
                $locIndex[$subarray['materialId']]['material_type_name'] = $subarray['name'];
                $locIndex[$subarray['materialId']]['material_type_id'] = $subarray['material_type_id'];
                $locIndex[$subarray['materialId']]['sub_type'] = $subarray['sub_type'];
                $locIndex[$subarray['materialId']]['material_name'] = $subarray['material_name'];
                $locIndex[$subarray['materialId']]['material_name_id'] = $subarray['materialId'];
                $locIndex[$subarray['materialId']]['uom'] = $subarray['uom'];
                $locIndex[$subarray['materialId']]['closing_balance'] = $subarray['closing_balance'];
                $locIndex[$subarray['materialId']]['location'][] = array('id' => $subarray['matLocId'], 'location' => $subarray['location_id'], 'area' => $subarray['Storage'], 'rack_no' => $subarray['RackNumber'], 'qty' => $subarray['quantity'], 'Qtyuom' => $subarray['Qtyuom'] , 'physical_stock' => $subarray['physical_stock'], 'balance' => $subarray['balance'], 'lot_no' => $subarray['lot_no']);
                /* $locIndex[$subarray['materialId']]['area'][] = $subarray['Storage'];
                $locIndex[$subarray['materialId']]['RackNumber'][] = $subarray['RackNumber'];
                $locIndex[$subarray['materialId']]['Qtyuom'][] = $subarray['Qtyuom'];
                $locIndex[$subarray['materialId']]['quantity'][] = $subarray['quantity']; */
                $locIndex[$subarray['materialId']]['reserved_material'][] = array('id' => $subarray['rm_id'],'customer_id' => $subarray['customer_id'], 'available_quantity' => $subarray['available_quantity'], 'quantity' => $subarray['reserve_quentity']);
            }
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select($table . '.material_name, material.sub_type, material.id as materialId, material.material_type_id, material.uom, material.location, material.closing_balance, material_type.name, material_type.id, mat_locations.id as matLocId, mat_locations.location_id, mat_locations.Storage, mat_locations.RackNumber, mat_locations.quantity, mat_locations.Qtyuom, mat_locations.physical_stock, mat_locations.balance, mat_locations.lot_no,  rm.id as rm_id, rm.customer_id,rm.customer_id,rm.available_quantity,rm.quantity as reserve_quentity');
            $dynamicdb->from($table);
            $dynamicdb->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            $dynamicdb->join("mat_locations", $table . ".id = mat_locations.material_name_id", 'left');
            $dynamicdb->join("reserved_material as rm", $table . ".id = rm.mayerial_id", 'left');
            $dynamicdb->where($where);
            $dynamicdb->where($table .'.'.'non_inventry_material !=',1);
            $dynamicdb->order_by("material_type.id,material.sub_type", "Asc");
            $qry = $dynamicdb->get();
            // echo  $dynamicdb->last_query();
            $result = $qry->result_array();
            $resultArray = array();
            $subtypeArray = array();
            $CombinedArray = array();
            $locationIndex = array();
            $locIndex = array();
            foreach ($result as $subarray) {
                if (!isset($locIndex[$subarray['materialId']])) $locIndex[$subarray['materialId']] = array('materialId' => $subarray['materialId'], 'location' => array());
                $locIndex[$subarray['materialId']]['material_type_name'] = $subarray['name'];
                $locIndex[$subarray['materialId']]['material_type_id'] = $subarray['material_type_id'];
                $locIndex[$subarray['materialId']]['sub_type'] = $subarray['sub_type'];
                $locIndex[$subarray['materialId']]['material_name'] = $subarray['material_name'];
                $locIndex[$subarray['materialId']]['material_name_id'] = $subarray['materialId'];
                $locIndex[$subarray['materialId']]['uom'] = $subarray['uom'];
                $locIndex[$subarray['materialId']]['closing_balance'] = $subarray['closing_balance'];
                $locIndex[$subarray['materialId']]['location'][] = array('id' => $subarray['matLocId'], 'location' => $subarray['location_id'], 'area' => $subarray['Storage'], 'rack_no' => $subarray['RackNumber'], 'qty' => $subarray['quantity'], 'Qtyuom' => $subarray['Qtyuom'], 'physical_stock' => $subarray['physical_stock'], 'balance' => $subarray['balance'], 'lot_no' => $subarray['lot_no']);
                /* $locIndex[$subarray['materialId']]['area'][] = $subarray['Storage'];
                $locIndex[$subarray['materialId']]['RackNumber'][] = $subarray['RackNumber'];
                $locIndex[$subarray['materialId']]['Qtyuom'][] = $subarray['Qtyuom'];
                $locIndex[$subarray['materialId']]['quantity'][] = $subarray['quantity']; */
                $locIndex[$subarray['materialId']]['reserved_material'][] = array('id' => $subarray['rm_id'],'customer_id' => $subarray['customer_id'], 'available_quantity' => $subarray['available_quantity'], 'quantity' => $subarray['reserve_quentity']);
            }
            // pre($locIndex);
        }
        return $locIndex;
    }
    public function get_Material_detail_byId($table, $field, $id) {
        $this->db->select($table . '.*, material.material_name as materialName,material.location as Currentlocation,material.id');
        $this->db->from($table);
        $this->db->join("material", $table . ".material_name_id = material.id", 'left');
        //$this->db->where('created_by_cid',$this->companyId);
        $this->db->where($table . '.' . $field, $id);
        $qry = $this->db->get();
       # pre($this->db->last_query());
        $result = $qry->result_array();
        return $result;
    }

    public function get_Material_detail_byId_inventory_flow($table, $field, $id) {
        $this->db->select($table . '.*, material.material_name as materialName,material.location as Currentlocation,material.id');
        $this->db->from($table);
        $this->db->join("inventory_flow", $table . ".material_id = material.id", 'left');
        //$this->db->where('created_by_cid',$this->companyId);
        $this->db->where($table . '.' . $field, $id);
        $qry = $this->db->get();
        //pre($this->db->last_query());
        $result = $qry->result_array();
        return $result;
    }

    /*************on the spot material addd***************/
    public function insert_on_spot_tbl_data($table, $added_data) {
        $this->db->insert($table, $added_data);
        $cid = $this->db->insert_id();
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $added_data['id'] = $cid;
        $dynamicdb->insert($table, $added_data);
        //pre($dynamicdb->last_query());
        $dynamicdb->insert_id();
        return $cid;
    }
    /* public function get_filter_details($table = '' , $where = array() , $limit ='') {
    $dynamicdb = $this->load->database('dynamicdb', TRUE);
    $dynamicdb->select('*');
    $dynamicdb->from($table);
    $dynamicdb->where($where);
    $qry = $dynamicdb->get();
    $result = $qry->result_array();
    return $result;
    }	 */
    public function get_data_fromMaterial_basedOnloc($table, $where, $company_unit_id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select($table . '.material_name,material.sub_type,material.id as materialId,material.material_type_id,material.uom,material.location,material_type.name,material_type.id');
            $this->db->from($table);
            $this->db->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            $this->db->like('location', '"location":"' . $company_unit_id . '"');
            $this->db->where($where);
            //$this->db->where("material_type.used_status",1);
            $this->db->where($table .'.'.'non_inventry_material !=',1);
            $this->db->order_by("material_type.id,material.sub_type", "Asc");
            $qry = $this->db->get();
			//echo $this->db->last_query();die();
            $result = $qry->result_array();
            $resultArray = array();
            $i = 0;
            foreach ($result as $res) {
                ////$data1 = $this->db->query("select so_order from sale_order where product LIKE %".$res['materialId']."%");
                //pre($data1);
                $data = $this->db->query("select half_or_full_book from inventory_listing_adjustment where action_type ='half_full_book' AND material_name_id='" . $res['materialId'] . "'");
                $half_full_book = $data->row_array();
                $resultArray[$res['id']]['material_type_name'] = $res['name'];
                $resultArray[$res['id']]['material_type_id'] = $res['material_type_id'];
                $resultArray[$res['id']]['sub_type'][] = array('sub_type' => $res['sub_type'], 'material_name' => $res['material_name'], 'material_name_id' => $res['materialId'], 'uom' => $res['uom'], 'location' => $res['location'], 'half_full_book' => $half_full_book);
                //$resultArray[$res['id']]['sub_type'][]= array('sub_type'=>$res['sub_type'],'material_name'=>$res['material_name'],'material_name_id'=>$res['materialId'],'uom'=>$res['uom'],'location'=>$res['location']);
                $i++;
            }
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select($table . '.material_name,material.sub_type,material.id as materialId,material.material_type_id,material.uom,material.location,material_type.name,material_type.id');
            $dynamicdb->from($table);
            $dynamicdb->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            $dynamicdb->like('location', '"location":"' . $company_unit_id . '"');
            $dynamicdb->where($where);
            //$dynamicdb->where("material_type.used_status",1);
			 $dynamicdb->where($table .'.'.'non_inventry_material !=',1);
            $dynamicdb->order_by("material_type.id,material.sub_type", "Asc");
            $qry = $dynamicdb->get();
            //pre($dynamicdb->last_query());die();
            $result = $qry->result_array();
            $resultArray = array();
            $i = 0;
            foreach ($result as $res) {
                $data = $dynamicdb->query("select half_or_full_book from inventory_listing_adjustment where action_type ='half_full_book' AND material_name_id='" . $res['materialId'] . "'");
                $half_full_book = $data->row_array();
                $resultArray[$res['id']]['material_type_name'] = $res['name'];
                $resultArray[$res['id']]['material_type_id'] = $res['material_type_id'];
                $resultArray[$res['id']]['sub_type'][] = array('sub_type' => $res['sub_type'], 'material_name' => $res['material_name'], 'material_name_id' => $res['materialId'], 'uom' => $res['uom'], 'location' => $res['location'], 'half_full_book' => $half_full_book);
                $i++;
            }
        }
        return $resultArray;
    }
    /*Update particular field in material in move listing save function */
    /*public function update_single_field($table,$db_data,$field,$id) {
    //pre($db_data);
    $db_data = $this->get_field_type_data($db_data, $table);
    $data = $db_data;
    $this->db->where($field, $id);
    $source = array('location' => $data['location']);
    $this->db->update('material', $source );
    //pre($this->db->last_query());
    if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3){
    $dynamicdb = $this->load->database('dynamicdb', TRUE);
    $dynamicdb->where($field, $id);
    $dynamicdb->update('material', $source );
    }
    return true;
    }	*/
    public function update_single_field($table, $data, $materialId='') {
        
        $db_data = $this->get_field_type_data($data, $table);
        // pre($data);die;
        $this->db->where('location_id', $data['location_id']);
        $this->db->where('material_name_id', $data['material_name_id']);
        $this->db->update('mat_locations', $db_data);
         // echo $this->db->last_query();die();
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('location_id', $data['location_id']);
            $dynamicdb->where('material_name_id', $data['material_name_id']);
            $dynamicdb->update('mat_locations', $db_data);
        }
         // echo $dynamicdb->last_query();die;
       return true;
    }
	
	
	
    public function update_single_field_adj($table, $data, $materialId, $id) {
        $db_data = $this->get_field_type_data($data, $table);
        $data = $db_data;
        $this->db->where('action_type', 'Rejected');
         $this->db->where('id', $id);
        $this->db->update('inventory_listing_adjustment', $db_data);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
           $dynamicdb->where('action_type', 'Rejected');
            $dynamicdb->where('id', $id);
            $dynamicdb->update('inventory_listing_adjustment', $db_data);
		 }
        #
        return true;
    }
    public function update_single_field_mat($table, $data, $materialId, $id) {
        $db_data = $this->get_field_type_data($data, $table);
        $data = $db_data;
       // pre($materialId);die();
        $this->db->where('id', $id);
        $this->db->where('location_id', $data['location_id']);
       // $this->db->where('RackNumber', $data['RackNumber']);
        $this->db->where('material_name_id', $materialId);
        $this->db->update('mat_locations', $db_data);
        #echo $this->db->last_query();
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $this->db->where('id', $id);
            $dynamicdb->where('location_id', $data['location_id']);
           // $dynamicdb->where('RackNumber', $data['RackNumber']);
            $dynamicdb->where('material_name_id', $materialId);
            $dynamicdb->update('mat_locations', $db_data);
        }
        // echo $dynamicdb->last_query();die();
        return true;
    }



	 public function update_single_field_inventeory_flows($table, $data, $materialId) {
        $db_data = $this->get_field_type_data($data, $table);
        $data = $db_data;
		$this->db->where('location_id', $data['location_id']);
        $this->db->where('RackNumber', $data['RackNumber']);
        $this->db->where('material_name_id', $materialId);
        $this->db->update('mat_locations', $db_data);
         if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
             $dynamicdb = $this->load->database('dynamicdb', TRUE);
             $dynamicdb->where('location_id', $data['location_id']);
             $dynamicdb->where('RackNumber', $data['RackNumber']);
             $dynamicdb->where('material_name_id', $materialId);
             $dynamicdb->update('mat_locations', $db_data);
         }
         //echo $this->db->last_query();die;
        return true;
    }
    /*******************************FAVOURITES IN Inventory ***************************/
    public function markfavour($table, $data, $key) {
        $data1 = array('favourite_sts' => $data);
        $ids = $key;
        $this->db->where('id', $ids);
        $result = $this->db->update($table, $data1);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $ids);
        $dynamicdb->update($table, $data1);
        return TRUE;
    }
    /*******************************FAVOURITES IN Inventory ***************************/
    public function update_Locationdata_multiple($table, $data) {
        $field_data = $data;
        $dataArray = array();

        foreach ($field_data as $locationData) {
            $dataArray[] = array('id' => $locationData['id'], 'location_id' => $locationData['location_id'], 'Storage' => $locationData['Storage'], 'RackNumber' => $locationData['RackNumber'], 'quantity' => $locationData['quantity'], 'Qtyuom' => $locationData['Qtyuom'], 'material_name_id' => $locationData['material_name_id'], 'material_type_id' => $locationData['material_type_id'] , 'lot_no' => $locationData['lot_no']);

            // $this->db->where('material_name_id', $locationData['material_name_id']);
            // $this->db->where('location_id', $locationData['location_id']);
            $this->db->where('id', $locationData['id']);
            $this->db->update_batch('mat_locations', $dataArray, 'id');

            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            // $dynamicdb->where('material_name_id', $locationData['material_name_id']);
            // $dynamicdb->where('location_id',$locationData['location_id']);
            $dynamicdb->where('id',$locationData['id']);
            $dynamicdb->update_batch('mat_locations', $dataArray, 'id');
            #echo $dynamicdb->last_query();
        }
        return true;

        /* $field_data = $data;
        $data = array();
        foreach($field_data as  $key => $result){
        $data[] = array('location_id' => $result['location_id'] ,'Storage' => $result['Storage'] , 'RackNumber' =>$result['RackNumber'] ,'quantity' =>$result['quantity'],'Qtyuom' =>$result['Qtyuom'],'material_name_id' =>$result['material_name_id'],'material_type_id' =>$result['material_type_id']);


        }
        $this->db->where('material_name_id',$field_data['material_name_id']);
        $this->db->update_batch('mat_locations',$data,'location_id');
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('material_name_id',$field_data['material_name_id']);
        $dynamicdb->update_batch('mat_locations',$data,'location_id');
        return true;	 */
    }
    public function get_data_byLocationId($table, $field, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where($table . '.' . $field, $id);
            $qry1 = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($table . '.' . $field, $id);
            $qry = $dynamicdb->get();
        }
       //echo $dynamicdb->last_query();
        $result = $qry->result_array();
        return $result;
    }
    public function get_dataw($table = '', $where = array(), $limit = '') {
        $table = $table ? $table : $this->tablename;
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            //if($table=="material" || $table=="company_detail" || $table=="inventory_listing" || $table=="location_settings" || $table == 'material_type' || $table == 'work_in_process_material'){
            if ($table == "material" || $table == "company_detail" || $table == "inventory_listing" || $table == 'material_type' || $table == 'work_in_process_material' || $table == "inventory_flow") {
                $this->db->select('*');
                $this->db->from($table);
            } else if ($table == "company") {
                $this->db->select($table . '.*,company_detail.address1');
                $this->db->from($table);
                $this->db->join("company_detail", $table . ".id = company_detail.company_id", 'left');
            } else if ($table == "mat_locations") {
                $this->db->select('*');
                $this->db->from($table);
            } else if ($table == "inventory_listing_adjustment") {
                $this->db->select('*');
                $this->db->from($table);
            } else if ($table == "finish_goods") {
                $this->db->select('*');
                $this->db->from($table);
            } else if ($table == "permissions") {
                $this->db->select('*');
                $this->db->from($table);
            } else if ($table == "company_address") {
                $this->db->select($table . '.*,location_settings.area');
                $this->db->from($table);
                $this->db->join("location_settings", $table . ".compny_branch_id = location_settings.location_id", 'left');
            } else {
                $this->db->select($table);
                $this->db->from($table);
            }
            $this->db->where($where);
            //$this->db->order_by('id','desc');
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            //if($table=="material" || $table=="company_detail" || $table=="inventory_listing" || $table=="location_settings" || $table == 'material_type' || $table == 'work_in_process_material'){
            if ($table == "material" || $table == "company_detail" || $table == "inventory_listing" || $table == 'material_type' || $table == 'work_in_process_material' || $table == "inventory_flow") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
            } else if ($table == "company") {
                $dynamicdb->select($table . '.*,company_detail.address1');
                $dynamicdb->from($table);
                $dynamicdb->join("company_detail", $table . ".id = company_detail.company_id", 'left');
            } else if ($table == "inventory_listing_adjustment") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
            } else if ($table == "mat_locations") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
            } else if ($table == "finish_goods") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
            } else if ($table == "permissions") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
            } else if ($table == "company_address") {
                $dynamicdb->select($table . '.*,location_settings.area');
                $dynamicdb->from($table);
                $dynamicdb->join("location_settings", $table . ".compny_branch_id = location_settings.location_id", 'left');
            } else {
                $dynamicdb->select($table);
                $dynamicdb->from($table);
            }
            $dynamicdb->where($where);
            $qry = $dynamicdb->get();
            #pre($dynamicdb->last_query());
        }
        $result = array();
        if($qry !== FALSE && $qry->num_rows() > 0){
            foreach ($qry->result_array() as $row) {
                $result[] = $row;
            }
        }
        return $result;
    }
    /* Function to fetch Data by Id of material */
    public function get_data_byIdpricelist($table, $field, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where($table . '.' . $field, $id);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($table . '.' . $field, $id);
            $qry = $dynamicdb->get();
        }
        $result = $qry->row();
        return $result;
    }
    /*change status in worker when click on toggle */
    public function toggle_change_status($id, $status) {
        #pre($id);
        #pre($status);
        $this->db->where('id', $id);
        $status = array('active_inactive' => $status);
        $this->db->update('uom', $status);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        #$status = array('active_inactive' => $status);
        $dynamicdb->update('uom', $status);
        return true;
    }

    public function toggle_change_status_lot($table, $id, $status) {
        $statuss = array('active_inactive' => $status);
        $this->db->where('id', $id);
        $this->db->update($table, $statuss);

        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        //$status = array('active_inactive' => $status);
        $dynamicdb->update($table, $statuss);
        return true;
    }
    /******************For updating records**********************/
    function updateRowWhere($table, $where = array(), $data = array()) {
        $this->db->where($where);
        $this->db->update($table, $data);
        if ($_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($where);
            $dynamicdb->update($table, $data);
        }


    }
    /****************************************************************************************************************************/
    /**********************************************Import Data Modal*******************************************************************/
    /*************************************************************************************************************************************/
	 public function importData($table, $data) {

        if (!empty($data)) {
            //pre($data);die();
            foreach ($data as $dt) {
				
                $this->db->insert($table, $dt);
				// echo $this->db->last_query();die();
                $insertedid = $this->db->insert_id();
                if ($insertedid) {
                    $dynamicdb = $this->load->database('dynamicdb', TRUE);
                    $dt['id'] = $insertedid;
                    $dynamicdb->insert($table, $dt);
                }
            }
        }
		
        return $insertedid;
    }
    public function importDataProductMatrix($table, $data,$locationID) {
        if (!empty($data)) {
           
            foreach ($data as $dt) {
				$this->db->insert($table, $dt);
				$insertedid = $this->db->insert_id();
				if ($insertedid){
                    $dynamicdb = $this->load->database('dynamicdb', TRUE);
                    $dt['id'] = $insertedid;
                    $dynamicdb->insert($table, $dt);
                }
				$dataLocation = array(
					'material_type_id' =>$dt['material_type_id'],	
					'material_name_id' =>$insertedid,	
					'location_id' =>$locationID	
					);
				$this->db->insert('mat_locations', $dataLocation);
				$dynamicdb = $this->load->database('dynamicdb', TRUE);
				$dynamicdb->insert('mat_locations', $dataLocation);	
				$this->sellingPriceHistoryProductmat($insertedid, $dt['sales_price']);
				
				
	       }
	    }
		   return $insertedid;
    }
	
	public function sellingPriceHistoryProductmat($id, $salesPrice){
        $material_type_id = $id;
		$existSalesPrice = $this->inventory_model->getSalePrice('material_old_price','material_type_id',$material_type_id);

        if(!empty($existSalesPrice)){
               foreach ($existSalesPrice as  $existSalesPricevalue) {
                      $salePriceNew = $existSalesPricevalue['new_sales_price'];
                      if($salePriceNew==$salesPrice){
                  return $insertSalesPrice='';
        
                      }else{
            $data['material_type_id']=$id;
            $data['old_sales_price']=$salePriceNew;
            $data['new_sales_price']=$salesPrice;
            $data['created_by']=$_SESSION['loggedInUser']->id;
             // pre($data);die();
            $insertSalesPrice = $this->inventory_model->insert_tbl_data('material_old_price', $data);
            return $insertSalesPrice;
                      }
               }
        }else{
            $data['material_type_id']=$id;
            $data['old_sales_price']=$salesPrice;
            $data['new_sales_price']=$salesPrice;
            $data['created_by']=$_SESSION['loggedInUser']->id;
			
			
             
            $insertSalesPrice = $this->inventory_model->insert_tbl_data('material_old_price', $data);
            return $insertSalesPrice;
            
        }
       
        
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
    public function insert_multiple_data_mtloc($table, $data) {
        if (!empty($data)) {
            foreach ($data as $dt) {
                $this->db->insert($table, $dt);
                $insertedid = $this->db->insert_id();
                if ($insertedid) {
                    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
                        $dynamicdb = $this->load->database('dynamicdb', TRUE);
                        $dt['id'] = $insertedid;
                        $dynamicInsertedid = $dynamicdb->insert('mat_locations', $dt);
                    }
                }
            }
            //return $insertedid;

        }
        return true;
    }
	
	
	public function importdataMaterial($table,$data,$insertsellingPrice="") {
		
		// pre($insertsellingPrice);die('asdf');
		if(!empty($data)){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			foreach($data as $dt){
				$this->db->insert($table,$dt);
				// echo $this->db->last_query();die();
				$insertedid = $this->db->insert_id();
				if($insertedid){
					$dt['id'] = $insertedid;
					$dynamicdb->insert($table,$dt);
					$lastId = $dt['id'];
					// if( $insertsellingPrice ){
						// $this->createMatSelleingPrice($dt,$lastId,$dynamicdb);
					// }
				}
			}
		}
	return true;
}
	
function createMatSelleingPrice($data,$lastId,$dynamicdb){
	
			$dataprice['material_type_id']=$lastId;
            $dataprice['old_sales_price']=$data['sales_price'];
            $dataprice['new_sales_price']=$data['sales_price'];
            $dataprice['created_by']=$_SESSION['loggedInUser']->id;
           
			$dynamicdb->insert('material_old_price',$dataprice);
			// pre($dynamicdb->last_query());die();
}	
	
	
	
	
	
	
	
	
	
	 /****************************************************************************************************************************/
    /**********************************************Import Data Modal*******************************************************************/
    /*************************************************************************************************************************************/
	


public function update_Locationdata($table, $data) {
        $field_data = $data;
        $dataArray = array();
    # pre($field_data);

        foreach ($field_data as $locationData) {
            $dataArray = array('quantity' => $locationData['final_value']);

			 $this->db->where('material_name_id', $locationData['id']);
			 $this->db->where('location_id', $locationData['location_id']);
            $this->db->update('mat_locations', $dataArray);
			  //echo $this->db->last_query();die();
			 if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
				$dynamicdb = $this->load->database('dynamicdb', TRUE);
				$dynamicdb->where('material_name_id', $locationData['id']);
				$dynamicdb->where('location_id', $locationData['location_id']);
				$dynamicdb->update('mat_locations', $dataArray);
			 }
		}
		 #echo $dynamicdb->last_query();

		//die();

        return true;
    }
    public function update_wip_request($table,$data,$field,$id) {

        $data = $this->get_field_type_data($data,$table);
        $this->db->where($field, $id);
        $result = $this->db->update($table, $data);

        if($_SESSION['loggedInUser']->role != 3){
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($field, $id);
            $dynamicdb->update($table, $data);
        }
        return TRUE;
    }

    public function update_wip($table,$data,$field,$id) {

        $data = $this->get_field_type_data($data,$table);
        $this->db->where($field, $id);
        $result = $this->db->update($table, $data);

        if($_SESSION['loggedInUser']->role != 3){
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($field, $id);
            $dynamicdb->update($table, $data);
        }
        return TRUE;
    }

      function getWorkOrderList($searchQuery = null){
        #$rowperpage = "";
       # $limit = "";
        ## Total number of records without filtering
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('count(*) as allcount');
        $where = "work_order.created_by_cid = " . $_SESSION['loggedInUser']->c_id . " AND work_order.progress_status=0";
        $dynamicdb->where($where);
        $dynamicdb->order_by('priority_order', 'ASC');
        $records      = $dynamicdb->get('work_order')->result();
        $totalRecords = $records[0]->allcount;
        ## Total number of record with filtering
        $dynamicdb->select('count(*) as allcount');
        if ($searchQuery != ''){
          $dynamicdb->where($searchQuery);
        }
        $dynamicdb->order_by('priority_order', 'ASC');
        $records1               = $dynamicdb->get('work_order')->result();
        $totalRecordwithFilter = $records1[0]->allcount;
        ## Fetch records
        $dynamicdb->select('*');
        if ($searchQuery != ''){
          $dynamicdb->where($searchQuery);
        }else{
            $where = "work_order.created_by_cid = " . $_SESSION['loggedInUser']->c_id . " AND work_order.progress_status=0";
            $dynamicdb->where($where);
        }
       # $dynamicdb->order_by('priority_order', 'ASC');
       #$dynamicdb->limit($rowperpage, $start);
        $records = $dynamicdb->get('work_order');
        #echo $this->db->last_query();
        $result = $records->result_array();
        return $result;
        ## Response
        // $response = array(
        //     "totalRecords" => $totalRecords,
        //     "totalRecordwithFilter" => $totalRecordwithFilter,
        //     "records" => $records
        // );
       // return $response;
    }

        public function importmaterial($data) {
                $res = $this->db->insert_batch('material',$data);
                 if($_SESSION['loggedInUser']->role != 3){
                    $dynamicdb = $this->load->database('dynamicdb', TRUE);
                    $res = $dynamicdb->insert_batch('material',$data);
                }
                 if($res){
                 return TRUE;
                 }else{
                 return FALSE;
                 }
         }

		public function get_data_byAddress($table,$where = array()){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('address');
			$dynamicdb->from($table);
			$dynamicdb->where($where);
			$qry = $dynamicdb->get();
			$result = $qry->result_array();
			return $result;
		}
		public function get_data_report($table, $field, $id){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->where($table . '.' . $field, $id);
            $qry = $dynamicdb->get();
			$result = $qry->result_array();
			return $result;
		}

    public function update_single_field_lotdetails($table, $data, $id) {
        $db_data = $this->get_field_type_data($data, $table);
        $data = $db_data;
        //pre($data);die();
        $this->db->where('id', $id);
        $this->db->update('lot_details', $db_data);
        #echo $this->db->last_query();
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('id', $id);
            $dynamicdb->update('lot_details', $db_data);
        }
        #echo $dynamicdb->last_query();
        return true;
    }

    public function insert_multiple_data_reserve_custmr($table, $data) {
        if (!empty($data)) {
            foreach ($data as $dt) {
                $this->db->insert($table, $dt);
                $insertedid = $this->db->insert_id();
                if ($insertedid) {
                    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
                        $dynamicdb = $this->load->database('dynamicdb', TRUE);
                        $dt['id'] = $insertedid;
                        $dynamicInsertedid = $dynamicdb->insert('reserved_material', $dt);
                    }
                }
            }
            //return $insertedid;

        }
        return true;
    }
    public function update_resrved_multiple($table, $data) {
        $field_data = $data;
        $dataArray = array();
        foreach ($field_data as $insertDataresr) {
            $dataArray[] = array('customer_id' => $insertDataresr['customer_id'], 'material_type' => $insertDataresr['material_type'], 'mayerial_id' => $insertDataresr['mayerial_id'], 'quantity' => $insertDataresr['quantity']);
            $this->db->where('id', $insertDataresr['id']);
            $this->db->update_batch('reserved_material', $dataArray, 'id');
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
             $dynamicdb->where('id',$insertDataresr['id']);
            $dynamicdb->update_batch('mat_locations', $dataArray, 'id');
        }
        return true;
    }
    public function insertcustomertype($table , $data = array()) {
        if(!empty($data)){
            foreach($data as $dt){
                $fieldData = $this->get_field_type_data($dt,$table);
                $this->db->insert($table,$fieldData);
                $insertedid = $this->db->insert_id();
                if($_SESSION['loggedInUser']->role != 3){
                    if($insertedid){
                        $dynamicdb = $this->load->database('dynamicdb', TRUE);
                        //$fieldData['sale_order_priority_id'] = $insertedid;
                        $dynamicInsertedid = $dynamicdb->insert($table,$fieldData);
                    }
                }
            }
            return $insertedid;
        }
    }

    public function change_status_mat_loc($id, $status) {
        $this->db->where('id', $id);
        $status = array('invnt_loc_on_off' => $status);
        $this->db->update('company_detail', $status);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('id', $id);
            $dynamicdb->update('company_detail', $status);
        }
        return true;
    }

    // public function change_status_toggle($id, $status) {
    //     $this->db->where('id', $id);
    //     $status = array('active_inactive' => $status);
    //     $this->db->update('uom', $status);
    //     if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
    //         $dynamicdb = $this->load->database('dynamicdb', TRUE);
    //         $dynamicdb->where('id', $id);
    //         $dynamicdb->update('uom', $status);
    //     }
    //     return true;
    // }

    public function toggle_change_tagtypes_status($id, $status) {
        #pre($id);
        #pre($status);
        $this->db->where('id', $id);
        $status = array('active_inactive' => $status);
        $this->db->update('tag_types', $status);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        #$status = array('active_inactive' => $status);
        $dynamicdb->update('tag_types', $status);
        return true;
    }

     public function toggle_change_tagdetails_status($id, $status) {
        #pre($id);
        #pre($status);
        $this->db->where('id', $id);
        $status = array('active_inactive' => $status);
        $this->db->update('tag_details', $status);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        #$status = array('active_inactive' => $status);
        $dynamicdb->update('tag_details', $status);
        return true;
    }

    public function get_data_monthwise($id){
		if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('material_id,year(created_date) as year,month(created_date) as month,sum(material_in) as material_in,sum(material_out) as material_out, sum(opening_blnc) as opening_blnc,sum(closing_blnc) as closing_blnc');
            $this->db->from('inventory_flow');
            $this->db->where('material_id ="'.$id.'" group by year(created_date),month(created_date) order by year(created_date),month(created_date) asc');
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('material_id,year(created_date) as year,month(created_date) as month,sum(material_in) as material_in,sum(material_out) as material_out, sum(opening_blnc) as opening_blnc,sum(closing_blnc) as closing_blnc');
            $dynamicdb->from('inventory_flow');
            $dynamicdb->where('material_id ="'.$id.'" group by year(created_date),month(created_date) order by year(created_date),month(created_date) asc');
			$qry = $dynamicdb->get();
		}
		$result = $qry->result_array();
		return $result;
	}

    public function getMaterialInfo($table, $field, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('material_name,uom,job_card');
            $this->db->from($table);
            $this->db->where($field, $id);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('material_name,uom,job_card');
            $dynamicdb->from($table);
            $dynamicdb->where($field, $id);
            $qry = $dynamicdb->get();
        }
        $result = $qry->row_array();
        return $result;
    }


    /* Function to fetch Data of material */
    public function get_data_single($table = '', $where = array()) {
        $table = $table ? $table : $this->tablename;
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            //if($table=="material" || $table=="company_detail" || $table=="inventory_listing" || $table=="location_settings" || $table == 'material_type' || $table == 'work_in_process_material'){
            if ($table == "material" || $table == "company_detail" || $table == "inventory_listing" || $table == 'material_type' || $table == 'work_in_process_material' || $table == "uom" || $table == "permissions" || $table =="work_order" || $table == "mrp_details" || $table=="daily_report_setting" || $table=="lot_details" || $table=="reserved_material"  ) {
                $this->db->select('*');
                $this->db->from($table);
            } else if ($table == "company") {
                $this->db->select($table . '.*,company_detail.address1');
                $this->db->from($table);
                $this->db->join("company_detail", $table . ".id = company_detail.company_id", 'left');
            } else if ($table == "mat_locations") {
                $this->db->select('*');
                $this->db->from($table);
            } else if ($table == "inventory_listing_adjustment") {
                $this->db->select('*');
                $this->db->from($table);
                #}else if($table=="finish_goods"){

            } else if ($table == "finish_goods" || $table == "company_address" || $table == "thrd_party_invtry" || $table == "tag_types" || $table == "tag_details" || $table == "inventory_flow") {
                $this->db->select('*');
                $this->db->from($table);
                /* }else if($table=="company_address"){
                #$this->db->select($table.'.*,location_settings.area');
                $this->db->select($table.'.*');
                $this->db->from($table);	 */
                #$this->db->join("location_settings", $table . ".compny_branch_id = location_settings.location_id", 'left');
                #$this->db->join("location_settings", $table . ".compny_branch_id = location_settings.location_id", 'left');

            } else {
                $this->db->select($table . '.*,material_type.name as materialType');
                $this->db->from($table);
                $this->db->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            }
            $this->db->where($where);
            //$this->db->order_by('id','desc');
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            //if($table=="material" || $table=="company_detail" || $table=="inventory_listing" || $table=="location_settings" || $table == 'material_type' || $table == 'work_in_process_material'){
            if ($table == "material" || $table == "company_detail" || $table == "inventory_listing" || $table == 'material_type' || $table == 'work_in_process_material' || $table == "uom" || $table == "permissions" || $table =="work_order" || $table == "mrp_details" || $table=="daily_report_setting" || $table=="lot_details"  || $table=="reserved_material" ) {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
            } else if ($table == "company") {
                $dynamicdb->select($table . '.*,company_detail.address1');
                $dynamicdb->from($table);
                $dynamicdb->join("company_detail", $table . ".id = company_detail.company_id", 'left');
            } else if ($table == "inventory_listing_adjustment") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
            } else if ($table == "mat_locations") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
                #}else if($table=="finish_goods"){

            } else if ($table == "finish_goods" || $table == "company_address" || $table == "thrd_party_invtry"  || $table == "tag_types" || $table == "tag_details" || $table == "inventory_flow") {
                $dynamicdb->select('*');
                $dynamicdb->from($table);
                /* }else if($table=="company_address"){
                $dynamicdb->select($table.'.*,location_settings.area');
                $dynamicdb->from($table);
                #$dynamicdb->join("location_settings", $table . ".compny_branch_id = location_settings.location_id", 'left');
                $dynamicdb->join("location_settings", $table . ".id = location_settings.location_id", 'left'); */
            } else {
                $dynamicdb->select($table . '.*,material_type.name as materialType');
                $dynamicdb->from($table);
                $dynamicdb->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            }
            $dynamicdb->where($where);
            $qry = $dynamicdb->get();
            #echo $dynamicdb->last_query();

        }
        $result = $qry->row_array();
        return $result;
    }

    public function get_material_process_data($table,$whereData){
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where('material_type_id',$whereData['material_type_id']);
        $dynamicdb->where('material_id',$whereData['material_id']);
        $dynamicdb->order_by('id','desc');
        $qry = $dynamicdb->get();
        $result = $qry->row_array();
        return $result;
    }

    public function getMaterialInProcessDetails($table,$whereData){
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where('material_type_id',$whereData['material_type_id']);
        $dynamicdb->where('material_id',$whereData['material_id']);
        $dynamicdb->where('work_order_id',$whereData['work_order_id']);
        $dynamicdb->order_by('id','desc');
        $qry = $dynamicdb->get();
        $result = $qry->row_array();
        return $result;
    }

    public function updateWorkProcessData($table,$whereData,$updateData){
        $this->db->where('material_type_id',$whereData['material_type_id']);
        $this->db->where('material_id',$whereData['material_id']);
        $this->db->where('work_order_id',$whereData['work_order_id']);
		$result = $this->db->update($table, $updateData);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('material_type_id',$whereData['material_type_id']);
        $dynamicdb->where('material_id',$whereData['material_id']);
        $dynamicdb->where('work_order_id',$whereData['work_order_id']);
		$dynamicdb->update($table, $updateData);
		return true;
    }

    public function insert_work_in_process_data($table, $data) {
        if (!empty($data)) {
            $this->db->insert($table, $data);
            $insertedid = $this->db->insert_id();
            if ($insertedid) {
                if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
                    $dynamicdb = $this->load->database('dynamicdb', TRUE);
                    $data['id'] = $insertedid;
                    $dynamicInsertedid = $dynamicdb->insert($table, $data);
                }
            }
        }
        return true;
    }

    function joinTables($select,$firstTable,array $joinData,$where,$order = [],$limitData = [],$groupBy=""){

        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = $dynamicdb->select($select)->from($firstTable);

        if( $joinData ){
            foreach ($joinData as $tableName => $joinClause) {
                $sql = $sql->join($tableName,$joinClause,'left');
            }
        }
        $sql = $sql->where($where);

        if( $groupBy ){
            $sql = $sql->group_by($groupBy);
        }

        if( $order ){
            $sql = $sql->order_by($order[0],$order[1]);
        }
        if( $limitData ){
            $limt = $limitData[0];
            $start = ($limitData[1] - 1) * 10;
            $sql = $sql->limit($limit, $start);
        }
        $sql = $sql->get();
        // echo $dynamicdb->last_query();
        // die;
        return $sql->result_array();
    }

    public function updateRowData($table,$where,$data) {
		// pre($where);
		// pre($data);
		
		// die();
        $this->db->where($where);
        $this->db->update($table,$data);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($where);
            $dynamicdb->update($table,$data);
            return $dynamicdb->affected_rows();
        }
    }
    public function getSaleOrder($table, $field, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where($field, $id);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($field, $id);
            $qry = $dynamicdb->get();
        }
        //  echo $dynamicdb->last_query();
        // die;
        $result = $qry->result_array();
        return $result;
    }
     public function getSaleOrderID($table, $ids) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('product_detail');
            $this->db->from($table);
            $this->db->where_in('id', $ids);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('product_detail');
            $dynamicdb->from($table);
            $dynamicdb->where_in('id', $ids);
            $qry = $dynamicdb->get();
        }
        // echo $dynamicdb->last_query();
        // die;
        $result = $qry->result_array();
        return $result;
    }

      public function getworkID($table, $ids) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('id,workorder_name');
            $this->db->from($table);
            $this->db->where_in('sale_order_id', $ids);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('id,workorder_name');
            $dynamicdb->from($table);
            $dynamicdb->where_in('sale_order_id', $ids);
            $qry = $dynamicdb->get();
        }
        // echo $dynamicdb->last_query();
        // die;
        $result = $qry->result_array();
        return $result;
    }

    public function getSaleOrderData($table, $ids ) {

       if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where_in('job_card_no', $ids);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where_in('job_card_no', $ids);
            $qry = $dynamicdb->get();
        }
        // echo $dynamicdb->last_query();
        // die;
        $result = $qry->result_array();
        return $result;
    }
    public function get_datafor_res( $table,$where ) {

        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql ="SELECT * FROM {$table} WHERE {$where}";
        $query = $dynamicdb->query($sql);
        //    echo $dynamicdb->last_query(); die;
        return $query->result();
    }
    public function admin_email_data($table,$select, $where){
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = $dynamicdb;
        if( $select ){
            $sql = $dynamicdb->select($select);
        }
        $sql = $sql->where($where);
        return $sql->get($table)->result_array();
      }
   public function getworkIDdata($table, $ids ) {
                  
       if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where_in('id', $ids);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where_in('id', $ids);
            $qry = $dynamicdb->get();
        }
        // echo $dynamicdb->last_query();
        // die;
        $result = $qry->row();
        return $result;
    }
	
	
	public function getDatabycheckid($table, $where ){
		 if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where($where);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($where);
            $qry = $dynamicdb->get();
        }
        // echo $dynamicdb->last_query();
        // die;
        $result = $qry->row_array();
        return $result;
	}

    public function insertData($table,$data){
        $this->db->insert($table,$data);
        $id = $this->db->insert_id();
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        if( $id ){
            $dynamicdb->insert($table,$data);
            return $dynamicdb->insert_id();
        }
    }

   // Selling Price Data 28-02-2022
   public function update_selling_price($table, $db_data, $field, $id) {
        $data = $db_data;
        $db_data = $this->get_field_type_data($db_data, $table);
        $this->db->where($field, $id);
        $result = $this->db->update($table, $db_data);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($field, $id);
            $dynamicdb->update($table, $db_data);
        }
        return true;
    }


    public function insert_selling_price($table, $data) {
        $fieldData = $this->get_field_type_data($data, $table);
        $this->db->insert($table, $fieldData);
        $insertedid = $this->db->insert_id();
        if ($insertedid) {
            if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
                $fieldData['id'] = $insertedid;
                $dynamicdb = $this->load->database('dynamicdb', TRUE);
                $dynamicdb->insert($table, $fieldData);
                $dynamicdb->insert_id();
            }
        }
        return $insertedid;
    }
    public function getSalePrice($table, $field, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where($field, $id);
            $this->db->order_by('id','DESC');
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($field, $id);
            $dynamicdb->order_by('id','DESC');
            $qry = $dynamicdb->get();
        }
        $result = $qry->result_array();
        return $result;
    }

    public function get_worker_data( $table,$where ) {
			// $dynamicdb = $this->load->database('dynamicdb', TRUE);
			// $sql ="SELECT * FROM {$table} WHERE {$where}";
			// $query = $dynamicdb->query($sql);
			// return $query->result_array();
			 $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($where);
            $qry = $dynamicdb->get();
			 $result = $qry->result_array();
			 // echo $dynamicdb->last_query();
				return $result;
    }
	 public function get_worker_dataIN( $table,$fildname,$where ) {
         
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql ="SELECT * FROM `{$table}` WHERE `{$fildname}` IN ({$where})";
        $query = $dynamicdb->query($sql);
          //echo $dynamicdb->last_query();  
        return $query->result_array();
    }
	
	public function update_materialPrice($table,$db_data,$field,$id) {
		$this->db->where($field, $id);
		$result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->update($table, $db_data);
		return true;
		}
	
	public function delete_rejected_inv($table,$field,$id){
		 $this->db->where($field, $id);
        $this->db->delete($table);
        //if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($field, $id);
            $dynamicdb->delete($table);
			//echo $dynamicdb->last_query();die();
       // }
        return true;
		
	}
	
	   public function get_one_field($table, $select, $where){
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select($select);    
        $dynamicdb->from($table);
        $dynamicdb->where($where);
        $qry = $dynamicdb->get();
        $result = $qry->result();         
        return $result;
    }
	
	
	public function get_data_fromMaterial_new($query) {        
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {            
            $qry = $this->db->query($query);                        
            $result = $qry->result_array();
            $resultArray = array();
            $subtypeArray = array();
            $CombinedArray = array();
            $locationIndex = array();
            $locIndex = array();
           foreach ($result as $subarray) {
                if (!isset($locIndex[$subarray['material_id']])) $locIndex[$subarray['material_id']] = array('material_id' => $subarray['material_id'], 'location' => array());
                $materialname=getNameById('material',$subarray['material_id'],'id');
                $materialtype=getNameById('material_type',$subarray['material_type_id'],'id');
                $locIndex[$subarray['material_id']]['material_type_name'] = $materialtype->name;
                $locIndex[$subarray['material_id']]['material_type_id'] = $subarray['material_type_id'];
                $locIndex[$subarray['material_id']]['sub_type'] =$materialname->sub_type;
                $locIndex[$subarray['material_id']]['material_name'] = $materialname->material_name;
                $locIndex[$subarray['material_id']]['material_name_id'] = $subarray['material_id'];
                $locIndex[$subarray['material_id']]['uom'] = $subarray['uom'];
                $locIndex[$subarray['material_id']]['closing_balance'] = $subarray['closing_balance'];
                $locIndex[$subarray['material_id']]['location'][] = array('id' => $subarray['matLocId'], 'location' => $subarray['location_id'], 'area' => $subarray['Storage'], 'rack_no' => $subarray['RackNumber'], 'qty' => $subarray['quantity'], 'Qtyuom' => $subarray['Qtyuom'], 'physical_stock' => $subarray['physical_stock'], 'balance' => $subarray['balance']);             
                $locIndex[$subarray['material_id']]['reserved_material'][] = array('id' => $subarray['rm_id'],'customer_id' => $subarray['customer_id'], 'available_quantity' => $subarray['available_quantity'], 'quantity' => $subarray['reserve_quentity']);
                $locIndex[$subarray['material_id']]['inventoryflowClosingblance'] = $subarray['closing_blnc'];
            }
        } else {   
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $qry = $dynamicdb->query($query);  
            $result = $qry->result_array();
            
            $resultArray =  $locIndex = $subtypeArray = $CombinedArray = $locationIndex = array();
             foreach ($result as $subarray) {
				
                if (!isset($locIndex[$subarray['material_id']])) $locIndex[$subarray['material_id']] = array('material_id' => $subarray['material_id'], 'location' => array());
                $materialname=getNameById('material',$subarray['material_id'],'id');
                $materialtype=getNameById('material_type',$subarray['material_type_id'],'id');
                $locIndex[$subarray['material_id']]['material_type_name'] = $materialtype->name;
                $locIndex[$subarray['material_id']]['material_type_id'] = $subarray['material_type_id'];
                $locIndex[$subarray['material_id']]['sub_type'] =$materialname->sub_type;
                $locIndex[$subarray['material_id']]['material_name'] = $materialname->material_name;
                $locIndex[$subarray['material_id']]['material_name_id'] = $subarray['material_id'];
                $locIndex[$subarray['material_id']]['uom'] = $subarray['uom'];
                $locIndex[$subarray['material_id']]['closing_balance'] = $subarray['closing_balance'];
                $locIndex[$subarray['material_id']]['location'][] = array('id' => $subarray['matLocId'], 'location' => $subarray['location_id'], 'area' => $subarray['Storage'], 'rack_no' => $subarray['RackNumber'], 'qty' => $subarray['quantity'], 'Qtyuom' => $subarray['Qtyuom'], 'physical_stock' => $subarray['physical_stock'], 'balance' => $subarray['balance']);             
                $locIndex[$subarray['material_id']]['reserved_material'][] = array('id' => $subarray['rm_id'],'customer_id' => $subarray['customer_id'], 'available_quantity' => $subarray['available_quantity'], 'quantity' => $subarray['reserve_quentity']);
                $locIndex[$subarray['material_id']]['inventoryflowClosingblance'] = $subarray['closing_blnc'];
            }
		
        }
           // pre($locIndex); 
             // die;
        return $locIndex;
    }
	
	
	public function get_HSNSACMASTERDATA($table = '', $where = array(), $limit = '') {
        $table = $table ? $table : $this->tablename;
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where($where);
        $qry = $dynamicdb->get();
		// echo $dynamicdb->last_query();die();
        $result = $qry->result_array();
        return $result;
    }
	
	
	
}//main
