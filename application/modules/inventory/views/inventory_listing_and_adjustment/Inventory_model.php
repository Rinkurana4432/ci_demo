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
                $all_fields = array('material_code', 'material_type_id', 'sub_type', 'material_name', 'sales_price', 'cost_price', 'sale_purchase', 'non_inventry_material', 'material_code', 'specification', 'hsn_code', 'opening_balance', 'uom', 'lead_time', 'time_period', 'min_inventory', 'inventory_unit', 'max_inventory', 'max_uom', 'route', 'prefix', 'tax', 'featured_image', 'facebook', 'twitter', 'instagram', 'linkedin', 'created_by', 'created_by_cid', 'sale_purchase', 'min_order', 'save_status', 'edited_by', 'job_card', 'cess', 'valuation_type');
            break;
            case 'material_type':
                $all_fields = array('name', 'prefix', 'sub_type', 'created_by', 'created_by_cid');
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
                $all_fields = array('job_card_detail', 'scrap_qty', 'material_scrap_id','acknowledge_date','aknowlwdge_by', 'created_by_cid', 'created_by');
            break;
			case 'quality_finish_goods':
                $all_fields = array('job_card_detail', 'scrap_qty', 'material_scrap_id','acknowledge_date','aknowlwdge_by', 'created_by_cid', 'created_by');
            break;
            case 'attachments':
                $all_fields = array('rel_type', 'rel_id', 'file_type', 'file_name');
            break;
            case 'inventory_flow':
                $all_fields = array('current_location','new_location','material_id', 'material_in', 'material_out', 'uom', 'through', 'ref_id', 'uom', 'created_by', 'created_by_cid', 'location','comment');
            break;
            case 'mat_locations':
                $all_fields = array('location_id', 'Storage', 'RackNumber', 'quantity', 'Qtyuom', 'created_by_cid', 'material_type_id', 'material_name_id', 'physical_stock', 'balance');
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
            $all_fields = array('mat_detail', 'acknowledege_date', 'acknowledge_by','created_by', 'created_by_cid');
            break;

            case 'company_address':
            $all_fields = array('area');
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
		//echo $dynamicdb->last_query();
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
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            //if($table=="material" || $table=="company_detail" || $table=="inventory_listing" || $table=="location_settings" || $table == 'material_type' || $table == 'work_in_process_material'){
            if ($table == "material" || $table == "company_detail" || $table == "inventory_listing" || $table == 'material_type' || $table == 'work_in_process_material' || $table == "uom" || $table == "permissions" || $table == "wip" || $table == "inventory_flow"||$table == "mrp_details") {
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
            //$this->db->order_by('id','desc');
			if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
			//echo  $dynamicdb->last_query();
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            //if($table=="material" || $table=="company_detail" || $table=="inventory_listing" || $table=="location_settings" || $table == 'material_type' || $table == 'work_in_process_material'){
            if ($table == "material" || $table == "company_detail" || $table == "inventory_listing" || $table == 'material_type' || $table == 'work_in_process_material' || $table == "uom" || $table == "permissions" || $table == "reoder_level_report" || $table == "wip" || $table == "inventory_flow"||$table == "mrp_details") {
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
        //    echo $dynamicdb->last_query();
            
        }
            #echo $dynamicdb->last_query();
        $result = $qry->result_array();
        return $result;
    }
    /*************************************************************common function *******************************************************************************/
    /* Function to fetch Data of material */
    public function get_data($table = '', $where = array(), $limit = '') {
        $table = $table ? $table : $this->tablename;
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            //if($table=="material" || $table=="company_detail" || $table=="inventory_listing" || $table=="location_settings" || $table == 'material_type' || $table == 'work_in_process_material'){
            if ($table == "material" || $table == "company_detail" || $table == "inventory_listing" || $table == 'material_type' || $table == 'work_in_process_material' || $table == "uom" || $table == "permissions" || $table =="work_order" || $table == "mrp_details") {
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
            //$this->db->order_by('id','desc');
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            //if($table=="material" || $table=="company_detail" || $table=="inventory_listing" || $table=="location_settings" || $table == 'material_type' || $table == 'work_in_process_material'){
            if ($table == "material" || $table == "company_detail" || $table == "inventory_listing" || $table == 'material_type' || $table == 'work_in_process_material' || $table == "uom" || $table == "permissions" || $table =="work_order" || $table == "mrp_details") {
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
            $dynamicdb->where($where);
            $qry = $dynamicdb->get();
           // echo $dynamicdb->last_query();
            
        }
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
        //echo $this->db->last_query();
        #echo $dynamicdb->last_query();die;
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
            } else if ($table == 'inventory_listing' || $table == 'location_settings' || $table == 'material_type' || $table == 'company_address' || $table == 'work_in_process_material' || $table == 'finish_goods' || $table == 'thrd_party_invtry') {
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
            } else if ($table == 'inventory_listing' || $table == 'location_settings' || $table == 'material_type' || $table == 'company_address'|| $table == 'work_in_process_material' || $table == 'finish_goods' || $table == 'thrd_party_invtry') {
                $dynamicdb->select($table . '.*');
                $dynamicdb->from($table);
            }else{
				  $dynamicdb->select($table . '.*');
                $dynamicdb->from($table);
			}
 
            $dynamicdb->where($table . '.' . $field, $id);
            $qry = $dynamicdb->get();
        }
        //echo $dynamicdb->last_query();
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
        }
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
	
	public function getNameById($table,$id,$field){
		  $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($field, $id);
			$qry = $dynamicdb->get();
			//echo $dynamicdb->last_query();die();
        $result = $qry->row();
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
    public function getMatrial_history($matid) {
        $field = '%"material_name_id":"' . $matid . '"%';
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $query = $this->db->query("(SELECT DISTINCT purchase_indent.complete_date,purchase_indent.id,purchase_indent.status,purchase_indent.material_name FROM purchase_indent where (pay_or_not = 1 AND ifbalance = 0 AND purchase_indent.material_name LIKE '$field') ORDER BY complete_date DESC LIMIT 12) 
			UNION 
			(SELECT DISTINCT purchase_order.complete_date,purchase_order.id,purchase_order.status,purchase_order.material_name FROM purchase_order where (pay_or_not = 1 AND ifbalance = 0 AND purchase_order.material_name LIKE '$field') ORDER BY complete_date DESC LIMIT 12 ) 
			UNION 
			(SELECT DISTINCT mrn_detail.complete_date,mrn_detail.id,mrn_detail.status,mrn_detail.material_name FROM mrn_detail where (pay_or_not = 1 AND ifbalance = 0 AND mrn_detail.material_name LIKE '$field')ORDER BY complete_date DESC LIMIT 12 )  ");
        } else {
            $query = $dynamicdb->query("(SELECT  DISTINCT purchase_indent.complete_date,purchase_indent.id,purchase_indent.status,purchase_indent.material_name FROM purchase_indent where (pay_or_not = 1 AND ifbalance = 0 AND purchase_indent.material_name LIKE '$field') ORDER BY complete_date DESC LIMIT 12) 
			UNION 
			(SELECT DISTINCT purchase_order.complete_date,purchase_order.id,purchase_order.status,purchase_order.material_name FROM purchase_order where (pay_or_not = 1 AND ifbalance = 0 AND purchase_order.material_name LIKE '$field') ORDER BY complete_date DESC LIMIT 12 ) 
			UNION 
			(SELECT  DISTINCT mrn_detail.complete_date,mrn_detail.id,mrn_detail.status,mrn_detail.material_name FROM mrn_detail where (pay_or_not = 1 AND ifbalance = 0 AND mrn_detail.material_name LIKE '$field')ORDER BY complete_date DESC LIMIT 12 )");
        }
        return $query->result_array();
    }
    public function getMonthlyReport() {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $query = $dynamicdb->query("SELECT mt.id , mt.name, ( SELECT sum(winp.quantity)  FROM work_in_process_material winp  WHERE winp.material_type_id=mt.id) sumMaterialIssued,( SELECT sum(material.opening_balance) FROM material WHERE material.material_type_id=mt.id ) sumOpeningBalance   FROM material_type mt");
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
    public function get_data_fromMaterial($table, $where) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select($table . '.material_name,material.sub_type,material.id as materialId,material.material_type_id,material.uom,material.location,material_type.name,material_type.id,mat_locations.location_id,mat_locations.Storage,mat_locations.RackNumber,mat_locations.quantity,mat_locations.Qtyuom,mat_locations.physical_stock,mat_locations.balance');
            $this->db->from($table);
            $this->db->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            $this->db->join("mat_locations", $table . ".id = mat_locations.material_name_id", 'left');
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
            foreach ($result as $subarray) {
                if (!isset($locIndex[$subarray['materialId']])) $locIndex[$subarray['materialId']] = array('materialId' => $subarray['materialId'], 'location' => array());
                $locIndex[$subarray['materialId']]['material_type_name'] = $subarray['name'];
                $locIndex[$subarray['materialId']]['material_type_id'] = $subarray['material_type_id'];
                $locIndex[$subarray['materialId']]['sub_type'] = $subarray['sub_type'];
                $locIndex[$subarray['materialId']]['material_name'] = $subarray['material_name'];
                $locIndex[$subarray['materialId']]['material_name_id'] = $subarray['materialId'];
                $locIndex[$subarray['materialId']]['uom'] = $subarray['uom'];
                $locIndex[$subarray['materialId']]['location'][] = array('location' => $subarray['location_id'], 'area' => $subarray['Storage'], 'rack_no' => $subarray['RackNumber'], 'qty' => $subarray['quantity'], 'Qtyuom' => $subarray['Qtyuom'] , 'physical_stock' => $subarray['physical_stock'], 'balance' => $subarray['balance']);
                /* $locIndex[$subarray['materialId']]['area'][] = $subarray['Storage'];
                $locIndex[$subarray['materialId']]['RackNumber'][] = $subarray['RackNumber'];
                $locIndex[$subarray['materialId']]['Qtyuom'][] = $subarray['Qtyuom'];
                $locIndex[$subarray['materialId']]['quantity'][] = $subarray['quantity']; */
            }
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select($table . '.material_name,material.sub_type,material.id as materialId,material.material_type_id,material.uom,material.location,material_type.name,material_type.id,mat_locations.location_id,mat_locations.Storage,mat_locations.RackNumber,mat_locations.quantity,mat_locations.Qtyuom,mat_locations.physical_stock,mat_locations.balance');
            $dynamicdb->from($table);
            $dynamicdb->join("material_type", $table . ".material_type_id = material_type.id", 'left');
            $dynamicdb->join("mat_locations", $table . ".id = mat_locations.material_name_id", 'left');
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
                $locIndex[$subarray['materialId']]['location'][] = array('location' => $subarray['location_id'], 'area' => $subarray['Storage'], 'rack_no' => $subarray['RackNumber'], 'qty' => $subarray['quantity'], 'Qtyuom' => $subarray['Qtyuom'], 'physical_stock' => $subarray['physical_stock'], 'balance' => $subarray['balance']);
                /* $locIndex[$subarray['materialId']]['area'][] = $subarray['Storage'];
                $locIndex[$subarray['materialId']]['RackNumber'][] = $subarray['RackNumber'];
                $locIndex[$subarray['materialId']]['Qtyuom'][] = $subarray['Qtyuom'];
                $locIndex[$subarray['materialId']]['quantity'][] = $subarray['quantity']; */
            }
            //pre($locIndex);
            
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
    public function update_single_field($table, $data, $materialId) {
        $db_data = $this->get_field_type_data($data, $table);
        $data = $db_data;
		//pre($data);die();
        $this->db->where('location_id', $data['location_id']);
        $this->db->where('RackNumber', $data['RackNumber']);
        $this->db->where('material_name_id', $materialId);
        $this->db->update('mat_locations', $db_data);
       # echo $this->db->last_query();
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('location_id', $data['location_id']);
            $dynamicdb->where('material_name_id', $materialId);
            $dynamicdb->where('RackNumber', $data['RackNumber']);
            $dynamicdb->update('mat_locations', $db_data);
        }
      # echo $dynamicdb->last_query();die;
        #return true;
    }
	
    public function update_single_field_mat($table, $data, $materialId) {
        $db_data = $this->get_field_type_data($data, $table);
        $data = $db_data;
        //pre($data);die();
        $this->db->where('location_id', $data['location_id']);
        $this->db->where('RackNumber', $data['RackNumber']);
        $this->db->where('material_name_id', $materialId);
        $this->db->update('mat_locations', $db_data);
        #echo $this->db->last_query();
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('location_id', $data['location_id']);
            $dynamicdb->where('RackNumber', $data['RackNumber']);
            $dynamicdb->where('material_name_id', $materialId);
            $dynamicdb->update('mat_locations', $db_data);
        }
        #echo $dynamicdb->last_query();
        return true;
    }

	 public function update_single_field_inventeory_flows($table, $data, $materialId) {
        $db_data = $this->get_field_type_data($data, $table);
        $data = $db_data;
		//pre($data);die();
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
            $dataArray[] = array('location_id' => $locationData['location_id'], 'Storage' => $locationData['Storage'], 'RackNumber' => $locationData['RackNumber'], 'quantity' => $locationData['quantity'], 'Qtyuom' => $locationData['Qtyuom'], 'material_name_id' => $locationData['material_name_id'], 'material_type_id' => $locationData['material_type_id']);

            $this->db->where('material_name_id', $locationData['material_name_id']);
            $this->db->where('location_id', $locationData['location_id']);
            $this->db->update_batch('mat_locations', $dataArray, 'location_id');
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('material_name_id', $locationData['material_name_id']);
             $dynamicdb->where('location_id',$locationData['location_id']);
            $dynamicdb->update_batch('mat_locations', $dataArray, 'location_id');
        }

       # echo $dynamicdb->last_query();
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

        $result = $qry->result_array();
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
    /******************For updating records**********************/
    function updateRowWhere($table, $where = array(), $data = array()) {
        $this->db->where($where);
        $this->db->update($table, $data);
        if ($_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($where);
            $dynamicdb->update($table, $data);
        }
        //echo $this->db->last_query();
        
    }
    /****************************************************************************************************************************/
    /**********************************************Import Data Modal*******************************************************************/
    /*************************************************************************************************************************************/
    public function importData($table, $data) {
        // $res = $this->db->insert_batch($table,$data);
        // if($res){
        // return TRUE;
        // }else{
        // return FALSE;
        // }
        if (!empty($data)) {
            //pre($data);die();
            foreach ($data as $dt) {
                $this->db->insert($table, $dt);
                $insertedid = $this->db->insert_id();
                if ($insertedid) {
                    $dynamicdb = $this->load->database('dynamicdb', TRUE);
                    $dt['id'] = $insertedid;
                    $dynamicdb->insert($table, $dt);
                }
            }
        }
        return true;
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
}
