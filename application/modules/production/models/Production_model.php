<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class production_model extends ERP_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tablename = 'process_type';
        //$this->column_search = array('name');
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
    }  
	
		public function get_field_type_data($data, $type){
		switch($type){
			case 'process_type': 
				$all_fields = array('process_type','description','created_by_cid');
				break;	
				case 'add_process':
				$all_fields = array('process_type_id','process_name','description','created_by_cid');
				break;				
			case 'add_machine':
				#$all_fields = array('machine_name','machine_code','preventive_maintenance','machine_parameter','process_name','company_branch','department','make_model','year_purchase','placement','add_similar_machine','created_by_cid','save_status','created_by','edited_by','department_id','process_type','process');
				$all_fields = array('machine_name','machine_code','machine_group_id','preventive_maintenance','machine_parameter','company_branch','department','make_model','year_purchase','placement','add_similar_machine','machine_capacity','created_by_cid','save_status','created_by','edited_by','department_id','remark','location','process');
				break;
			case 'material':
                $all_fields = array('material_code', 'material_type_id', 'sub_type', 'material_name', 'sales_price', 'cost_price', 'sale_purchase', 'non_inventry_material', 'material_code', 'specification', 'hsn_code', 'opening_balance', 'uom', 'lead_time', 'time_period', 'min_inventory', 'inventory_unit', 'max_inventory', 'max_uom', 'route', 'prefix', 'tax', 'featured_image', 'facebook', 'twitter', 'instagram', 'linkedin', 'created_by', 'created_by_cid', 'sale_purchase', 'min_order', 'save_status', 'edited_by', 'job_card', 'cess', 'valuation_type' , 'mat_sku');
            break;
			case 'job_card':
				$all_fields = array('job_card_no','party_code','linked_material_details','product_specification','party_requirement','test_certificate','material_details','material_costing','lot_qty','lot_uom','machine_details','created_by_cid','save_status','created_by','edited_by','process_type','job_card_product_name','scrap_material_details', 'final_process');
				break;
			case 'production_data':
				$all_fields = array('shift','shift_name','date','electr_unit_price','planning_id','production_data','department_id','company_branch','created_by_cid','save_status','created_by','edited_by','no_of_dys');
				break;	
			case 'production_planning':
				$all_fields = array('supervisor_name','date','shift','shift_name','planning_data','created_by_cid','save_status','created_by','company_branch','department_id','edited_by');
				break;	
			case 'production_setting':
				$all_fields = array('company_unit','department','shift_number','shift_name','shift_duration','shift_start','shift_end','week_off','created_by_cid','created_by','edited_by');
				break;
			case 'worker':
				$all_fields = array('company_unit','name','address','country','state','city','mobile_number','bank_name','branch_name','ifsc_code','account_no','date_of_joining','date_of_relieving','salary','other','created_by_cid','save_status','created_by','edited_by');
				break;
			case 'production_scheduling':
				$all_fields = array('month','data','created_by_cid','date','save_status','created_by','edited_by');
				break;	
			case 'machine_group':
				$all_fields = array('machine_group_name','created_by_cid');
				break;	
			case 'sale_order':
				$all_fields = array('dispatch_product','dispatch_type','dispatched_date');
				break;	
			case 'department':
				$all_fields = array('name','unit_name','created_by_cid','created_by','edited_by');
				break;
			/*case 'electricity_unit':
				$all_fields = array('electr_unit_price','created_by_cid');
				break;*/
			 	
			case 'wages_perpiece_setting':
				$all_fields = array('company_unit','department','wages_perpiece','created_by_cid');
				break;	
			case 'user_dashboard':
				$all_fields = array('graph_id','user_id','show');
				break;	
			case 'sale_order_dispatch':
				$all_fields = array('account_id','product', 'dispatch_date','production_dispatch_date','dispatch_documents', 'comments', 'transport_tel_no','vehicle_no','created_by','created_by_cid','total','grandTotal','invoice_no','save_status','material_type_id','sale_order_id');
				break;	
			case 'work_order':
				$all_fields = array('sale_order_id','company_branch_id','department_id','customer_name_id','stock_saleOrder','sale_order_no', 'work_order_no','product_detail','expected_delivery_date','workorder_name','progress_status','priority_order','created_by','created_by_cid','material_type_id','specification','inprocess_complete');
				break;	
			case 'production_report':
				$all_fields = array('month','company_branch','department_id','workorder_count','workorder_ids','qty','status','created_by','created_by_cid');
				break;	
			case 'controlled_report_master':				
				$all_fields = array('report_name','saleorder','workorder_id','material_id','material_name1','created_date','created_by','created_by_cid','final_report');
				break;
			case 'inventory_flow':
                $all_fields = array('material_type_id','current_location','new_location','material_id', 'material_in', 'material_out', 'uom', 'through', 'ref_id', 'uom', 'created_by', 'created_by_cid', 'location','comment');
                break;
			case 'mat_locations':
                $all_fields = array('location_id', 'Storage', 'RackNumber', 'quantity', 'Qtyuom', 'created_by_cid', 'material_type_id', 'material_name_id', 'physical_stock', 'balance');
            break;

            
            
			case 'reserved_material':
			$all_fields = array('material_type', 'mayerial_id', 'quantity', 'unreserve_qty','work_order_id','job_card_id', 'created_by', 'created_by_cid','saleorder_product');
			break;
            
			case 'inspection_report_master':				
				$all_fields = array('report_name','workorder_id','process_id','job_card','created_date','created_by','created_by_cid','final_report');
				break;
		case 'workorder_report':
        $all_fields = array('report_alldata','created_by', 'created_by_cid', 'branch_id','department_id','month_report');
			 break;
			case 'production_dataWages':
        $all_fields = array('production_id', 'wages_or_per_piece', 'machine_name_id', 'machine_grp', 'job_card_product_id', 'process_name', 'party_code', 'npdm', 'worker_id', 'working_hrs', 'totalsalary', 'sale_order', 'work_order', 'output', 'planing_output', 'labour_costing' ,'created_date','actual_time');
            break;
		 	 case 'taskListData':				
				$all_fields = array('sale_order_id', 'work_order_id', 'jobcard_id', 'product_Id_in_workorder', 'processID', 'workerName', 'outputMatid', 'expectedProduction', 'actualProduction', 'rejectedProduction', 'task_details', 'status', 'created_by', 'updated_by', 'created_by_cid');
				break;
		   case 'auto_production_plan':
				$all_fields = array('date','shift','shift_name','planning_data','created_by_cid','save_status','created_by','company_branch','department_id','edited_by');
				break;
			}
			
			return $data = format_data_to_be_added($all_fields, $data);
		}
	
		/*****************************************************************************/
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
		 // echo $dynamicdb->last_query();die();
		$result = $qry->num_rows();		
		return $result; 
	}	
	
		public function get_data1($table = '' , $where = array(),$limit, $start,$where2,$order,$export_data){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			//pagination
			$start = ($start-1) * $limit;
			$table = $table?$table:$this->tablename;			
			if($table=="process_type"){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}
			elseif($table=="add_machine"){
				$dynamicdb->select($table.'.*,add_process.process_name as ProcesName');
				$dynamicdb->from($table);
				$dynamicdb->join("add_process", $table . ".process_name = add_process.id", 'left');	
				//$dynamicdb->order_by("add_machine.priority_order", "asc");	
			}
			elseif($table=="add_process" || $table == "mat_locations"){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
				//$dynamicdb->order_by("order_id", "asc");
			}
			/*elseif($table=="sale_order_priority"){
				$dynamicdb->select($table.'.*,sale_order.*');
				$dynamicdb->from($table);
				$dynamicdb->join("sale_order", $table . ".sale_order_id = sale_order.id", 'left');	
				$dynamicdb->order_by("sale_order_priority.priority", "asc");
			}*/elseif($table=="department"){
				// $this->db->select($table.'.*,location_settings.location as unit_name');
				// $this->db->from($table);
				// $this->db->join("location_settings", $table . ".unit_ = location_settings.id", 'left');
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}elseif($table=="production_setting"){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}elseif($table=="sale_order"){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
				//$dynamicdb->order_by("sale_order.sale_order_priority", "asc");
			}else{
				$dynamicdb->select('*');
				$dynamicdb->from($table);
				//$dynamicdb->order_by("id desc");
			}
			$dynamicdb->where($where);
			if($where2!='')
			{
			$dynamicdb->where($where2);	
			}
			if(isset($_GET['sort'])){
				$sort=(string)$_GET['sort'];
				$dynamicdb->order_by('id',$sort);
			}elseif($table=="work_order"){
				$dynamicdb->order_by('priority_order', "asc");
			}else{
				$dynamicdb->order_by('id',$order);
			}
		
		//	$dynamicdb->order_by("id",$order);
			if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
		
			$qry = $dynamicdb->get();
	//echo $dynamicdb->last_query();//die(); 
			$result = array();
			if($qry !== FALSE && $qry->num_rows() > 0){
				$result = $qry->result_array();
			}
			return $result;
		}
		
		public function get_data($table = '' , $where = array()) {
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;			
			if($table=="process_type"){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}
			elseif($table=="add_machine"){
				$dynamicdb->select($table.'.*,add_process.process_name as ProcesName');
				$dynamicdb->from($table);
				$dynamicdb->join("add_process", $table . ".process_name = add_process.id", 'left');	
				$dynamicdb->order_by("add_machine.priority_order", "asc");	
			}
			elseif($table=="add_process"){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
				$dynamicdb->order_by("order_id", "asc");
			}
			/*elseif($table=="sale_order_priority"){
				$dynamicdb->select($table.'.*,sale_order.*');
				$dynamicdb->from($table);
				$dynamicdb->join("sale_order", $table . ".sale_order_id = sale_order.id", 'left');	
				$dynamicdb->order_by("sale_order_priority.priority", "asc");
			}*/elseif($table=="department"){
				// $this->db->select($table.'.*,location_settings.location as unit_name');
				// $this->db->from($table);
				// $this->db->join("location_settings", $table . ".unit_ = location_settings.id", 'left');
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}elseif($table=="production_setting"){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
				$dynamicdb->order_by("production_setting.shift_number", "asc");
			}elseif($table=="sale_order"){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
				$dynamicdb->order_by("sale_order.sale_order_priority", "asc");
			}else{
				$dynamicdb->select('*');
				$dynamicdb->from($table);
				$dynamicdb->order_by("id desc");
			}
			$dynamicdb->where($where);
			$qry = $dynamicdb->get();
			//echo $dynamicdb->last_query(); die;
			$result = array();
			if($qry !== FALSE && $qry->num_rows() > 0){
				$result = $qry->result_array();
			}
			return $result;
		}

		public function get_data_wo_bypriorty($table = '' , $where = array()) {
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;			
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->order_by('priority_order', "asc");
			$dynamicdb->where($where);
			$qry = $dynamicdb->get();
			
			$result = array();
			if($qry !== FALSE && $qry->num_rows() > 0){
				$result = $qry->result_array();
			}
			return $result;
		}

			/* Insert Data */
		public function insert_tbl_data($table,$data) {	
			$fieldData = $this->get_field_type_data($data,$table);
			$this->db->insert($table,$fieldData);
			$insertedid = $this->db->insert_id();
		//echo $this->db->last_query();die;
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$fieldData['id'] = $insertedid;	
			$dynamicInsertedid = $dynamicdb->insert($table,$fieldData);	
			// echo $dynamicdb->last_query();die();
			return $insertedid; 
		}
	public function get_data_byId($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,');    
		$dynamicdb->from($table);
		//$this->db->join("user_detail", $table . ".id = user_detail.u_id", 'left');
		$dynamicdb->where($table.'.'.$field, $id);
		$qry = $dynamicdb->get();
		$result = $qry->row();
         # echo $dynamicdb->last_query();die();		
		return $result;
	}
	
	public function get_data_process($table ,$where) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get($table);
		$result = $qry->result_array(); 	
		return $result;
	}
	
	public function get_data_byAddress($table,$where = array()){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');    
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();

		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}	
		return $result;

		// echo $dynamicdb->last_query();
	}
	public function get_process_namebyadd($table,$where = array()){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('machine_details');    
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();		
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}		
		return $result;

		// echo $dynamicdb->last_query();
	}
	/***************from location swettings*************/
	public function get_data_byCid($table,$where = array()){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('compny_branch_id,company_unit');    
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}
	
		return $result;
	}
	public function update_prodData_single_data($table,$field,$id){
		$this->db->where('id', $id);
		$status = array('convert_to_prod_data' => 1);
		$this->db->update($table, $status);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->update($table, $status);
		//echo $this->db->last_query();die();
		return true;
	}
	
	/*gte uom and qty data from material issue based on material select in job card*/
	public function get_QtyUom_byId($table ,$field, $id) {	
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('opening_balance,inventory_unit');    
		$dynamicdb->from($table);
		$dynamicdb->where($table.'.'.$field, $id);
		$qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}
		return $result;
	}
	/**********************check if proces type allready exist************/
	public function processTypeExist($processTypeExist,$update = '' ){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('process_type'); 
		$dynamicdb->from('process_type');
		$dynamicdb->where('process_type',$processTypeExist);
		#$dynamicdb->where('created_by_cid',$_SESSION['loggedInUser']->c_id);
		$dynamicdb->where('created_by_cid',$this->companyGroupId);
		/*if($update == ''){
			$this->db->where('created_by_cid',$_SESSION['loggedInUser']->c_id);
		}else{
			$this->db->where('created_by_cid != ',$_SESSION['loggedInUser']->c_id);
		}*/
		$qry = $dynamicdb->get();
		//pre($this->db->last_query());die;
		$result = $qry->row();	
		return $result;
	}
	/*public function get_data_byId($table ,$field, $id) {
			if($table=="material" || $table=="purchase_indent" || $table=="purchase_order" || $table=="mrn_detail"){
				$this->db->select($table.'.*, material_type.name as materialtype ');  
				$this->db->from($table);
				$this->db->join("material_type", $table . ".material_type_id = material_type.id", 'left'); 
			}else if($table == 'supplier' || $table == 'ledger'){
				$this->db->select($table.'.*,'.$table.'.id as supplier_id, material.material_name as material_name');  
				$this->db->from($table);
				$this->db->join("material", $table . ".material_name_id = material.id", 'left');	
			}
			$this->db->where($table.'.'.$field, $id);
			$qry = $this->db->get();
			$result = $qry->row();	
			return $result;
		}
		*/
		
	public function get_data_parameter($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('machine_parameter');    
		$dynamicdb->from($table);
		$dynamicdb->where($field, $id);
		$qry = $dynamicdb->get();
		$result = $qry->row();	
		return $result;
	}
	/*check if smae date shift exist in data and planning*****/
	public function xdateAndShiftExist($table,$createdData,$shift,$dept){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('date,shift,department_id'); 
		$dynamicdb->from($table);
		$dynamicdb->where('date',$createdData);
		$dynamicdb->where('shift',$shift);
		$dynamicdb->where('department_id',$dept);
		#$dynamicdb->where('created_by_cid',$_SESSION['loggedInUser']->c_id);
		$dynamicdb->where('created_by_cid',$this->companyGroupId);
		$qry = $dynamicdb->get();
pre( $dynamicdb->last_query());
	 die; 
		$result = $qry->row_array();	
		return $result;
	}
	public function dateAndShiftExist($table,$createdData,$shift,$dept){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('date,shift,department_id,id'); 
		$dynamicdb->from($table);
		$dynamicdb->where('date',$createdData);
		$dynamicdb->where('shift_name',$shift);
		$dynamicdb->where('department_id',$dept);
		#$dynamicdb->where('created_by_cid',$_SESSION['loggedInUser']->c_id);
		$dynamicdb->where('created_by_cid',$this->companyGroupId);
		$qry = $dynamicdb->get();
 
		$result = $qry->row_array();
		//echo $dynamicdb->last_query(); pre($result); die;	
		return $result;
	}
	/*Update Data*/ 

	public function update_data_res($table,$db_data,$field) {
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		
		$this->db->where($field);	
		$result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->where($field);	
		$dynamicdb->update($table, $db_data);	
		
		return true;
	}


	public function update_data($table,$db_data,$field,$id) {
		// pre($field);
		// pre($db_data); die;
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		
		$this->db->where($field, $id);	
		$result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->where($field, $id);	
		$dynamicdb->update($table, $db_data);	
		
		return true;
	}
	/* delete data*/
	public function delete_data($table ,$field ,$id) {	
		$this->db->where($field, $id);
		$this->db->delete($table);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->where($field, $id);
		$dynamicdb->delete($table);
		return true;
	}
	
	/*change status function*/
	public function change_process_status($data, $id) {	
		$data = array( 
					'process_type_id' => $_POST['processTypeId']
				);	
		$this->db->where('id', $_POST['processId']);	
		$this->db->update('add_process', $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->where('id', $_POST['processId']);	
		$dynamicdb->update('add_process', $data);
		return true;
		
	}	
		/*change Remark function*/
	public function update_remark($data, $id) {	
		 $data = array('remark' =>$_POST['remark'] );
		$this->db->where('id', $_POST['id']);	
		$this->db->update('add_machine', $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->where('id', $_POST['id']);	
		$dynamicdb->update('add_machine', $data);
		return true;
		
	}	
	
	/* Function to fetch Data by Id of material */
	public function get_tbl_data_byId($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');  
		$dynamicdb->from($table);
		$dynamicdb->where($table.'.'.$field, $id);
		$qry = $dynamicdb->get();	
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}
		return $result;
	}
	
	public function productionFilter($fromDate,$toDate,$table) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');    
		$dynamicdb->from($table);		
		$dynamicdb->where('date >=', $fromDate);	
		$dynamicdb->where('date <=', $toDate);
		$dynamicdb->order_by('date');		
		$qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}
		return $result;
	}
	
	
	public function get_user_data($table,$query = '',$where = array()){		
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('name');    
		$dynamicdb->from($table);
		$dynamicdb->like('name', $query);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}		
		return $result;
	}

	public function get_machine_data($table,$field,$id ){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$b = "'".'"'.'%';
		$a = '%"machine_name":"'."'".','. $id .','.$b;			
		$qry = "SELECT add_machine.*, job_card.* FROM add_machine INNER JOIN job_card ON job_card.machine_details LIKE CONCAT('".$a."') where add_machine.id=$id ORDER BY add_machine.id asc";
		$qryy = $dynamicdb->query($qry);
		$result = $qryy->row();
		
		return $result;	
	}
	
	public function change_process_order($orders){
		foreach ($orders as $order) {
            $id = $order['id'];
                if ($order['id'] == $id) {					
					$data =  array('order_id' => $order['position']);	
					$this->db->where('id', $id);
					$this->db->update('add_process', $data);
					$dynamicdb = $this->load->database('dynamicdb', TRUE);
					$data =  array('order_id' => $order['position']);	
					$dynamicdb->where('id', $id);
					$dynamicdb->update('add_process', $data);			
				}
			}
		}
		
		
	/*succesfull pi created */
	function get_sales_count($table) {
			$dynamicdb = $this->load->database('dynamicdb', TRUE);	
			$dynamicdb->select('COUNT(*)');  
			$dynamicdb->from($table);
			$dynamicdb->where('approve', 1);
			$query = $dynamicdb->get();	
			return $query->row_array();
	}
	
	/***************************change sael order********************************/
	
	/*public function changeSaleOrderPriority($orders){
		foreach ($orders as $order) {
            $id = $order['id'];
			if ($order['id'] == $id) {					
				$data =  array('priority' => $order['position']);	
				$this->db->where('sale_order_priority_id', $id);
				$this->db->update('sale_order_priority', $data);	
				pre($this->db->last_query());
				$dynamicdb = $this->load->database('dynamicdb', TRUE);
				$dynamicdb->where('sale_order_priority_id', $id);
				$dynamicdb->update('sale_order_priority', $data);				
			}
		}
	}*/
	
	
	public function changeSaleOrderPriority($orders){
		
		foreach ($orders as $order) {
			
            $id = $order['id'];
			if ($order['id'] == $id) {
//pre($order['position']);				
				$data =  array('sale_order_priority' => $order['position']);
				///pre($data);		
				$this->db->where('id', $id);
				$this->db->update('sale_order', $data);
				
				$dynamicdb = $this->load->database('dynamicdb', TRUE);
				$dynamicdb->where('id', $id);
				$dynamicdb->update('sale_order', $data);
		
			}
			/*if ($order['id'] == $id) {					
				$data =  array('priority' => $order['position']);	
				$this->db->where('sale_order_priority_id', $id);
				$this->db->update('sale_order_priority', $data);	
				$dynamicdb = $this->load->database('dynamicdb', TRUE);
				$dynamicdb->where('sale_order_priority_id', $id);
				$dynamicdb->update('sale_order_priority', $data);	
		
			}*/
		}
	}

	public function changeWorkOrderPriority($orders){
		
		foreach ($orders as $order) {
			
            $id = $order['id'];
			if ($order['id'] == $id) {				
				$data =  array('priority_order' => $order['position']);	
				$this->db->where('id', $id);
				$this->db->update('work_order', $data);
				
				$dynamicdb = $this->load->database('dynamicdb', TRUE);
				$dynamicdb->where('id', $id);
				$dynamicdb->update('work_order', $data);
		
			}
		}
	}
	/****************************change machine order*******************************/
	public function	changeMachineOrderPriority($machine_orders){
		foreach ($machine_orders as $order) {
            $id = $order['id'];
                if ($order['id'] == $id) {					
					$data =  array('priority_order' => $order['position']);	
					$this->db->where('id', $id);
					$this->db->update('add_machine', $data);
					$dynamicdb = $this->load->database('dynamicdb', TRUE);
					$dynamicdb->where('id', $id);
					$dynamicdb->update('add_machine', $data);	
						
				}
			}
	}
	
	
	
	
	public function insert_multiple_data($table , $data){
		/*$this->db->insert_batch($table, $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->insert_batch($table, $data);*/
		//pre($data);
		if(!empty($data)){			
			foreach($data as $dt){
				//pre($dt);
				$fieldData = $this->get_field_type_data($dt,$table);
				$this->db->insert($table,$fieldData);
				//pre($this->db->last_query());
				$insertedid = $this->db->insert_id();
				
				if($insertedid){
					$dynamicdb = $this->load->database('dynamicdb', TRUE);
					$fieldData['id'] = $insertedid;	
					$dynamicInsertedid = $dynamicdb->insert($table,$fieldData);
				}
				
			}
			return $insertedid; 
		}
		
		
	}
	
	/***********************************getMatType_ById*****************************************************/
	public function getMatType_ById($table,$data,$id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('work_in_process_material.id ,work_in_process_material.material_id,material_type.name as materialType, material.material_name' );
		$dynamicdb->from($table);
		$dynamicdb->join('material_type', $table.'.material_type_id = material_type.id', 'LEFT');
		$dynamicdb->join('material', $table.'.material_id = material.id', 'LEFT');
		$dynamicdb->where($table.'.material_type_id',$data);
		$qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}
		return $result;
	}
	
		
	public function approveJobCard($data) {
		$this->db->where('id', $data['id']);		
		$approveData = array('approve' => $data['approve'],'validated_by' =>  $data['validated_by'] ,'disapprove' => 0 ,'disapprove_reason' => '');
		$this->db->update('job_card', $approveData );
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $data['id']);		
		$approveData = array('approve' => $data['approve'],'validated_by' =>  $data['validated_by'] ,'disapprove' => 0 ,'disapprove_reason' => '');
		$dynamicdb->update('job_card', $approveData);
		return true;
	}
	
	public function disApproveJobCard($data) {
		$this->db->where('id', $data['id']);		
		//$approveData = array('approve' => 0,'validated_by' =>  $data['validated_by'] ,'disapprove' => 1, 'disapprove_reason' =>'');
		$this->db->update('job_card', $data );
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $data['id']);	
		$dynamicdb->update('job_card', $data );
		return true;
	}
	
	
	/*change status in worker when click on toggle */
	public function toggle_change_status($id, $status) {	
	#pre($id);
	#pre($status);
		$this->db->where('id', $id);
		$status = array('active_inactive' => $status);
		$this->db->update('worker', $status);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $id);
		#$status = array('active_inactive' => $status);
		$dynamicdb->update('worker', $status);
		return true;
	}	
	public function get_company_branch($table, $where = array()){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('*');	
		$dynamicdb->from($table);	
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}
		return $result;
	}
	/********get department when unit is selctd*************/
	public function get_department_data($table,$field,$data){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('id,name');	
		$dynamicdb->from($table);	
		#$dynamicdb->where('created_by_cid',$_SESSION['loggedInUser']->c_id );
		$dynamicdb->where('created_by_cid',$this->companyGroupId );
		$dynamicdb->where($field,$data );
		$qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}
		return $result;
	}
	/***********get machine based on department select**************/
	public function get_departmentMachine_data($table,$field,$data){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,department.name');	
		$dynamicdb->from($table);	
		$dynamicdb->join('department', $table.'.department = department.id', 'LEFT');
		#$dynamicdb->where('add_machine.created_by_cid',$_SESSION['loggedInUser']->c_id );
		$dynamicdb->where('add_machine.created_by_cid',$this->companyGroupId );
		$dynamicdb->order_by("add_machine.priority_order", "asc");
		$dynamicdb->where('add_machine.'.$field,$data);
		$qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}
		return $result;
	}
	public function insert_on_spot_tbl_data($table,$added_data) {
		 
		$this->db->insert($table,$added_data);
		$insertedId = $this->db->insert_id();
		#echo '$insertedId==>>'.$insertedId; die;
		$added_data['id'] = $insertedId;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->insert($table,$added_data);
		//echo $dynamicdb->last_query();die();
		$dynamicdb->insert_id();
		return $insertedId;
	}
	public function insert_on_spot_tbl_data22($table,$added_data) {
		 
		$this->db->insert($table,$added_data);		
		$cid = $this->db->insert_id();
		//pre($this->db->last_query()); die;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$added_data['id']  = $cid;
		$dynamicdb->insert($table,$added_data);		
		$dynamicdb->insert_id();
		return $cid;
	}
	/*******************company filter in worker********************************/
		public function get_worker_salary($table , $data){	
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
	  // $this->db->select('SUm(salary) as TotalSalary');	
	  $dynamicdb->select('id as Id,salary as TotalSalary');	
	   $dynamicdb->from($table);	
	   //$this->db->where($where);		
	   $dynamicdb->where('id'." IN (".$data.")");
		//ORDER BY instr('13,1', id)	   
	   $qry = $dynamicdb->get();	 
	   $result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}
	   return $result;
	   
	}
	
	/*******************company filter in worker********************************/
	public function get_filter_details($table = '' , $where = array() , $limit ='') {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}	
		return $result;
	}
	public function update_user_graph_data($table ,$data) {		
		$db_data = $this->get_field_type_data($data, $table);
		$this->db->where('user_id', $data['user_id']);
		$this->db->where('graph_id', $data['graph_id']);
		$result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('user_id', $data['user_id']);
		$dynamicdb->where('graph_id', $data['graph_id']);
		$dynamicdb->update($table, $db_data);
		return true;
	}

	//Function to Check if any graph in dashboard is inserted in database
	public function get_data_dashboard($table = '' , $where = array(), $limit = '') {	
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$table = $table?$table:$this->tablename;
		$dynamicdb->select('*'); 
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		if($limit)		
		$dynamicdb->limit($limit);
		if($table != 'permissions')
		$dynamicdb->order_by('created_date', "desc");
		$qry = $dynamicdb->get();			
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}	
		return $result;
	}	
	/*check if smae department and company exist in setting pf production wages *****/
	public function compAndDepartExist($table,$companyUnit,$Depart,$update = '' ){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('company_unit,department'); 
		$dynamicdb->from($table);
		$dynamicdb->where('company_unit',$companyUnit);
		$dynamicdb->where('department',$Depart);
		#$dynamicdb->where('created_by_cid',$_SESSION['loggedInUser']->c_id);
		$dynamicdb->where('created_by_cid',$this->companyGroupId);
		$qry = $dynamicdb->get();
		
		$result = $qry->row_array();	
		return $result;
	}
	/*****data FROM RPDOCUTIN DATA BASED ON DATE AT THE TIME OF CONVERWSION IN PLANNING******/
	public function get_data_accrdingToDate($table,$field,$date){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('date'); 
		$dynamicdb->from($table);
		$dynamicdb->where($field,$date);
		#$dynamicdb->where('created_by_cid',$_SESSION['loggedInUser']->c_id);
		$dynamicdb->where('created_by_cid',$this->companyGroupId);
		$qry = $dynamicdb->get();
		//pre($dynamicdb->last_query());
		$result = $qry->row_array();	
		return $result;
	}
	
	
	/******************************sale order dispatch functions*****************************************/
	/****************get attchments in sale order ****************************/
	public function get_attachmets_by_saleOrderId($table ,$where = '') {
		//$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->db->select('*');    
		$this->db->from($table);
		$this->db->where($where);
		$qry =$this->db->get();			
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}
		return $result;
	}
	public function completeSaleOrder($data) {
		$this->db->where('id', $data['id']);		
		$completeSaleOrderData = array('complete_status' => $data['complete_status'],'completed_by' =>  $data['completed_by'] );
		$this->db->update('sale_order', $completeSaleOrderData );
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $data['id']);		
		$dynamicdb->update('sale_order', $completeSaleOrderData );
		return true;
	}
		public function get_dispatch_data($table = '' , $where = array(), $limit = '') {	
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$table = $table?$table:$this->tablename;
		$dynamicdb->select('*'); 
		$dynamicdb->from($table);
		//$dynamicdb->join("attachments", $table . ".id = attachments.rel_id", 'left');
		//$dynamicdb->where('attachments.rel_type','sale_order_dispatch');
		//$dynamicdb->order_by('attachments.created_date', "desc");		
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}
		$saleOrderDispatch_arrayId = array();
		$i = 0;
		foreach($result as $res){
			$sale_dispatch_id = $res['id'];
			$dynamicdb->select('*'); 
			$dynamicdb->from('attachments');
			$dynamicdb->where('attachments.rel_type','sale_order_dispatch');
			$dynamicdb->where('attachments.rel_id',$sale_dispatch_id);
		    $dynamicdb->order_by('attachments.created_date', "desc");
			$qry1 = $dynamicdb->get();
			$issue_result = array();
			if($qry1 !== FALSE && $qry1->num_rows() > 0){
				$issue_result = $qry1->result_array();
			}
			$saleOrderDispatch_arrayId[$i]['sale_order'] = $res;
			foreach($issue_result as $ir){
				//pre($ir);
				if($ir['rel_id'] == $res['id']){
				//$saleOrderDispatch_arrayId[$i]['sale_order'] = $res;
				//$saleOrderDispatch_arrayId[$i][]['file_type'] = $ir['file_type'];
				$saleOrderDispatch_arrayId[$i]['file_name'][] = $ir['file_name']; 
				}
		
			}	$i++;	
		
		}
		//pre($saleOrderDispatch_arrayId);
		//die;
		return $saleOrderDispatch_arrayId;		
		
	}
	public function update_singleField_data($table,$db_data,$field,$id){
		
		$this->db->where($field, $id);
		$status = array('production_dispatch_date' =>$db_data );
		$result = $this->db->update($table, $status);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$table = $table?$table:$this->tablename;
		$dynamicdb->where($field, $id);
		$status = array('production_dispatch_date' =>$db_data );
		$dynamicdb->update($table, $status);
		//pre($this->db->last_query());die();
		return true;
	}
	
	
	/***********get machine based on department select**************/
	public function get_dataIn_ProdConversion_byId($table,$field,$data){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,wages_perpiece_setting.department ,wages_perpiece_setting.wages_perpiece ');	
		$dynamicdb->from($table);	
		$dynamicdb->join('wages_perpiece_setting', $table.'.department_id = wages_perpiece_setting.department', 'LEFT');
		// $dynamicdb->where(table.created_by_cid',$_SESSION['loggedInUser']->c_id );
		$dynamicdb->where('production_planning.'.$field,$data);
		#$dynamicdb->where('production_planning.created_by_cid',$_SESSION['loggedInUser']->c_id);
		$dynamicdb->where('production_planning.created_by_cid',$this->companyGroupId);
		//$dynamicdb->order_by("add_machine.priority_order", "asc");
		
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();
		//pre($dynamicdb->last_query());
		$result = $qry->row();		
		return $result;
	}
	
	public function get_dataWithProdSetting_byId($table,$field,$data){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,wages_perpiece_setting.department ,wages_perpiece_setting.wages_perpiece ');	
		$dynamicdb->from($table);	
		$dynamicdb->join('wages_perpiece_setting', $table.'.department_id = wages_perpiece_setting.department', 'LEFT');
		$dynamicdb->where('production_data.'.$field,$data);
		#$dynamicdb->where('production_data.created_by_cid',$_SESSION['loggedInUser']->c_id);
		$dynamicdb->where('production_data.created_by_cid',$this->companyGroupId);
		$qry = $dynamicdb->get();
		$result = $qry->row();		
		return $result;
	}
	/*******************get shift setting accrdn to dept in planning and data at the time of add *************/
	public function get_shiftdata_withDept($table,$companyUnit,$dept){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');	
		$dynamicdb->from($table);
		$dynamicdb->where('production_setting.company_unit',$companyUnit);
		$dynamicdb->where('production_setting.department',$dept);
		#$dynamicdb->where('production_setting.created_by_cid',$_SESSION['loggedInUser']->c_id);
		$dynamicdb->where('production_setting.created_by_cid',$this->companyGroupId);
		$qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}	
		return $result;
	}
	//get_dataWithProdSetting_byId
	
	public function updateOldProductionPlanningData($id,$data){		
		$this->db->where('id', $id);
		$dd = array('planning_data' =>$data );
		$result = $this->db->update('production_planning', $dd);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		#$table = $table?$table:$this->tablename;
		$dynamicdb->where('id', $id);
		$dd = array('planning_data' =>$data );
		$dynamicdb->update('production_planning', $dd);
		//pre($this->db->last_query());die();
		return true;
	}
	public function get_saleOrder_productDetail($table,$sale_order_id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('product');	
		$dynamicdb->from($table);
		$dynamicdb->where('id',$sale_order_id);
		#$dynamicdb->where('sale_order.created_by_cid',$_SESSION['loggedInUser']->c_id);
		$dynamicdb->where('sale_order.created_by_cid',$this->companyGroupId);
		$qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}			
		return $result;
	}
	
	
	public function get_job_card_based_onMaterialId($table,$material_id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('material.id,job_card.job_card_no');	
		$dynamicdb->from($table);
		$dynamicdb->join('job_card', $table.'.job_card = job_card.id', 'LEFT');
		//$dynamicdb->where($table.'.id',$material_id);
		$dynamicdb->where('material.id'." IN (".$material_id.")");
		#$dynamicdb->where('material.created_by_cid',$_SESSION['loggedInUser']->c_id);
		$dynamicdb->where('material.created_by_cid',$this->companyGroupId);
		$qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}		
		return $result;
	}
	
	
	
	public function get_data_byId_fromMaterial($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,job_card.job_card_no as job_card');    
		$dynamicdb->from($table);
		$dynamicdb->join('job_card', $table.'.job_card = job_card.id', 'LEFT');
		$dynamicdb->where($table.'.'.$field, $id);
		$qry = $dynamicdb->get();
		$result = $qry->row();			
		return $result;
	}


	/*******************************FAVOURITES IN PURCHASE ***************************/
	public function markfavour($table,$data,$key) {
			$data1 = array('favourite_sts' => $data);
			$ids = $key;
			$this->db->where('id',$ids);
			$result = $this->db->update($table,$data1);

			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('id',$ids);		
			$dynamicdb->update($table, $data1);	
		return TRUE;
	}


/******************For updating records**********************/
	function updateRowWhere($table, $where = array(), $data = array()) {
        $this->db->where($where);
		$this->db->update($table, $data);
			if($_SESSION['loggedInUser']->role != 3){	
				$dynamicdb = $this->load->database('dynamicdb', TRUE);
				$dynamicdb->where($where);	
				$dynamicdb->update($table, $data);	
			}
			//echo $this->db->last_query();
	}
	
	
	/********************** update Process Scheduling ***********************/ 
	public function get_mat_data_byId($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,');    
		$dynamicdb->from($table);
		//$this->db->join("user_detail", $table . ".id = user_detail.u_id", 'left');
		$dynamicdb->where($table.'.'.$field, $id);
		$qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}		
		return $result;
	}
	
	public function update_process_sechduling_Data($mat_val,$mat_idd,$table){
		//echo "UPDATE ".$table." SET `opening_balance`= '".$mat_val."' WHERE `id` = '".$mat_idd."'";die();
	   $query = $this->db->query("UPDATE ".$table." SET `opening_balance`= '".$mat_val."' WHERE `id` = '".$mat_idd."'");
	   $dynamicdb = $this->load->database('dynamicdb', TRUE);	 
       $query = $dynamicdb->query("UPDATE ".$table." SET `opening_balance`= '".$mat_val."' WHERE `id` = '".$mat_idd."'");
      #echo  $dynamicdb->last_query();
      #die;
	}

	public function update_process_sechduling_plus_output($mat_val,$mat_idd,$table){
		//echo "UPDATE ".$table." SET `opening_balance`= '".$mat_val."' WHERE `id` = '".$mat_idd."'";die();
	   $query = $this->db->query("UPDATE ".$table." SET `output`= '".$mat_val."' WHERE `material_id` = '".$mat_idd."'");
	   $dynamicdb = $this->load->database('dynamicdb', TRUE);	 
       $query = $dynamicdb->query("UPDATE ".$table." SET `output`= '".$mat_val."' WHERE `material_id` = '".$mat_idd."'");
     # echo  $dynamicdb->last_query();
      #die;
	}

	public function update_process_sechduling_Data_minus_wipinput($mat_val,$mat_idd,$table){
		//echo "UPDATE ".$table." SET `opening_balance`= '".$mat_val."' WHERE `id` = '".$mat_idd."'";die();
	   $query = $this->db->query("UPDATE ".$table." SET `quantity`= '".$mat_val."' WHERE `material_id` = '".$mat_idd."'");
	   $dynamicdb = $this->load->database('dynamicdb', TRUE);	 
       $query = $dynamicdb->query("UPDATE ".$table." SET `quantity`= '".$mat_val."' WHERE `material_id` = '".$mat_idd."'");
      #echo  $dynamicdb->last_query();
      #die;
	}
	

	
	
	public function get_wip_mat_data($table, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('material_id,quantity');
            $dynamicdb->from($table);
            $dynamicdb->where('material_id' . " IN (" . $id . ")");
            $qry = $dynamicdb->get();
			   $result = array();
			if($qry !== FALSE && $qry->num_rows() > 0){
				$result = $qry->result_array();
			}	
            return $result;
        }
    }
	
	
	
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
      #  echo $dynamicdb->last_query();
        return true;

    }
	
	/********************** update Process Scheduling ***********************/
	
   /********************** update Process Scheduling ***********************/
    
    // Get DataTable data
    function getWorkOrderList($searchQuery = null){
        ## Total number of records without filtering
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('count(*) as allcount');
        $where = "work_order.created_by_cid = " . $_SESSION['loggedInUser']->c_id . " AND work_order.progress_status=0  AND sale_order_no != ''";
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
			$where = "work_order.created_by_cid = " . $_SESSION['loggedInUser']->c_id . " AND work_order.progress_status=0 AND sale_order_no != ''";
			$dynamicdb->where($where);
		}
	   	$dynamicdb->order_by('priority_order', 'ASC');
        $dynamicdb->limit($rowperpage, $start);
        $records = $dynamicdb->get('work_order')->result();
        
        ## Response
        $response = array(
            "totalRecords" => $totalRecords,
            "totalRecordwithFilter" => $totalRecordwithFilter,
            "records" => $records
        );
        return $response;
    }

	public function update_single_field($table, $data, $materialId) {
		 $db_data = $this->get_field_type_data($data, $table);
	      $data = $db_data;
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
	     //  echo $dynamicdb->last_query();
	        return true;
	    }

	public function change_status_toggle($id, $status) {
        $this->db->where('id', $id);
        $status = array('active_inactive' => $status);
        $this->db->update('work_order', $status);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('id', $id);
            $dynamicdb->update('work_order', $status);
        }
        return true;
    }
    
    public function get_production_data($table, $column_name,$work_order_id) {
		$workOrderId = '"'.$work_order_id.'"';
		$columnName = '{'.'"'.$column_name.'"'.':'.$workOrderId.'}';
		$where = "JSON_CONTAINS(production_data, '$columnName')";
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,');    
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$dynamicdb->where('save_status',1);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();	
		$result = $qry->result_array();	
		return $result;
    }
    
    public function get_material_approved_data($table, $column_name,$work_order_id) {
		$workOrderId = '"'.$work_order_id.'"';
		$columnName = '{'.'"'.$column_name.'"'.':'.$workOrderId.'}';
		$where = "JSON_CONTAINS(mat_detail, '$columnName')";
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,');    
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$dynamicdb->where('issued_status',1);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();	
		$result = $qry->result_array();	
		return $result;
    }

    public function get_fg_approved_data($table, $column_name,$work_order_id) {
		$workOrderId = '"'.$work_order_id.'"';
		$columnName = '{'.'"'.$column_name.'"'.':'.$workOrderId.'}';
		$where = "JSON_CONTAINS(job_card_detail, '$columnName')";
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,');    
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();	
		$result = $qry->result_array();	
		return $result;
    }
    
    /*Update update_material_job_card */ 
	public function update_material_job_card($table,$db_data,$field,$id) {
		$this->db->where($field, $id);	
		$result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->where($field, $id);	
		$dynamicdb->update($table, $db_data);	
		return true;
	}
	
	public function get_work_order_by_material($table, $column_name, $condition) {
		//$productId = '"'.$condition['product_id'].'"';
		//$columnName = '{'.'"'.$column_name.'"'.':'.$productId.'}';
		//$where = "JSON_CONTAINS(product_detail, '$columnName')";
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,');    
		$dynamicdb->from($table);
		//$dynamicdb->where($where);
		$dynamicdb->where('id',$condition['id']);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query().'<br/>';
		$result = $qry->row_array();	
		return $result;
    }

	public function get_job_card_data($table, $column_name, $condition) {
		$where = '';
		if($condition['material_id']){
			$materialId = '"'.$condition['material_id'].'"';
			$columnName = '{'.'"'.$column_name.'"'.':'.$materialId.'}';
			$where = "JSON_CONTAINS(material_details, '$columnName')";
		}
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,');    
		$dynamicdb->from($table);
		if($where){
			$dynamicdb->where($where);
		}
		$dynamicdb->where('job_card_no',$condition['job_card_no']);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query().'<br/>';
		$result = $qry->row_array();	
		return $result;
    }
    
    public function get_finish_good_data($table, $column_name,$json_column_key,$work_order_id) {
		$workOrderId = '"'.$work_order_id.'"';
		$jsonColumnName = '{'.'"'.$json_column_key.'"'.':'.$workOrderId.'}';
		$where = "JSON_CONTAINS($column_name, '$jsonColumnName')";
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,');    
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query().'<br/>';
		$result = $qry->result_array();	
		return $result;
    }
    
    
    public function change_status_material_conversion($id, $status) {
        $this->db->where('id', $id);
        $status = array('material_conversion_on_off' => $status);
        $this->db->update('company_detail', $status);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('id', $id);
            $dynamicdb->update('company_detail', $status);
        }
        return true;
    }
    
    public function get_data_single($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$table = $table?$table:$this->tablename;			
		if($table=="process_type"){
			$dynamicdb->select('*');
			$dynamicdb->from($table);
		}
		elseif($table=="add_machine"){
			$dynamicdb->select($table.'.*,add_process.process_name as ProcesName');
			$dynamicdb->from($table);
			$dynamicdb->join("add_process", $table . ".process_name = add_process.id", 'left');	
			$dynamicdb->order_by("add_machine.priority_order", "asc");	
		}
		elseif($table=="add_process"){
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->order_by("order_id", "asc");
		}
		/*elseif($table=="sale_order_priority"){
			$dynamicdb->select($table.'.*,sale_order.*');
			$dynamicdb->from($table);
			$dynamicdb->join("sale_order", $table . ".sale_order_id = sale_order.id", 'left');	
			$dynamicdb->order_by("sale_order_priority.priority", "asc");
		}*/elseif($table=="department"){
			// $this->db->select($table.'.*,location_settings.location as unit_name');
			// $this->db->from($table);
			// $this->db->join("location_settings", $table . ".unit_ = location_settings.id", 'left');
			$dynamicdb->select('*');
			$dynamicdb->from($table);
		}elseif($table=="production_setting"){
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->order_by("production_setting.shift_number", "asc");
		}elseif($table=="sale_order"){
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->order_by("sale_order.sale_order_priority", "asc");
		}else{
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->order_by("id desc");
		}
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->row_array();
		}
		return $result;
	}
	
	public function get_work_order_material_data($table = '' , $where = array(),$limit, $start,$where2,$order) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$table = $table?$table:$this->tablename;			
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		if($order){
			$dynamicdb->order_by($order);
		} else {
			$dynamicdb->order_by("id desc");
		}
		$dynamicdb->where($where);
		if($where2){
			$dynamicdb->where($where2);
		}
        if($limit && $start){
			$start = ($start-1) * $limit;
            $dynamicdb->limit($limit, $start);
        }

		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query(); 
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}
		return $result;
	}
	
	public function update_work_order_production_status($table,$where,$updateData) {
		$this->db->where($where);
        $this->db->update($table, $updateData);
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($where);
            $dynamicdb->update($table, $updateData);
        }
        return true;
	}
	 public function Work_order_and_jobCart_value( $table,$where ) {  
         
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql ="SELECT * FROM {$table} WHERE {$where}";
        $query = $dynamicdb->query($sql);
       // echo $dynamicdb->last_query(); die;
        return $query->row();
    }
	public function get_compdata($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*'); 
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		#echo $dynamicdb->last_query();
		$result = $qry->result_array();			
		return $result;
	}
	
	public function departmentExist($table,$created_by,$unit_name,$name){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('name,unit_name,created_by'); 
		$dynamicdb->from($table);
		$dynamicdb->where('created_by',$created_by);
		$dynamicdb->where('unit_name',$unit_name);
		$dynamicdb->where('name',$name);
		$qry = $dynamicdb->get();
		$result = $qry->row_array();	
		return $result;
	}
	public function groupExist($table,$name){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('machine_group_name'); 
		$dynamicdb->from($table);
		$dynamicdb->where('machine_group_name',$name);
		$qry = $dynamicdb->get();
		$result = $qry->row_array();	
		return $result;
	}
	public function process_nameExist($table,$process_type_id,$process_name){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('process_type_id,process_name'); 
		$dynamicdb->from($table);
		$dynamicdb->where('process_type_id',$process_type_id);
		$dynamicdb->where('process_name',$process_name);
		$qry = $dynamicdb->get();
		$result = $qry->row_array();	
		return $result;
	}
	public function autoget_dataIn_ProdConversion_byId($table,$field,$data){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,wages_perpiece_setting.department ,wages_perpiece_setting.wages_perpiece ');	
		$dynamicdb->from($table);	
		$dynamicdb->join('wages_perpiece_setting', $table.'.department_id = wages_perpiece_setting.department', 'LEFT');
		// $dynamicdb->where(table.created_by_cid',$_SESSION['loggedInUser']->c_id );
		$dynamicdb->where('auto_production_plan.'.$field,$data);
		#$dynamicdb->where('production_planning.created_by_cid',$_SESSION['loggedInUser']->c_id);
		$dynamicdb->where('auto_production_plan.created_by_cid',$this->companyGroupId);
		//$dynamicdb->order_by("add_machine.priority_order", "asc");
		
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();
		//pre($dynamicdb->last_query());
		$result = $qry->row();		
		return $result;
	}

	public function get_worker_data( $table,$where ) {
         
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql ="SELECT * FROM {$table} WHERE {$where}";
        $query = $dynamicdb->query($sql);
           //echo $dynamicdb->last_query(); die; 
        return $query->result_array();
    }

    public function get_worker_dataIN( $table,$fildname,$where ) {
         
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql ="SELECT * FROM `{$table}` WHERE `{$fildname}` IN ({$where})";
        $query = $dynamicdb->query($sql);
          //echo $dynamicdb->last_query();  
        return $query->result_array();
    }

}
