<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance_model extends ERP_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tablename = 'add_bd_request';

        $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
        //$this->column_search = array('name');
    } 


    public function get_field_type_data($data, $table){
		switch($table){
			case 'add_bd_request':				
				$all_fields = array('machine_name','breakdown_couses','machine_type','priority','favourite_sts','acknowledge','request_status','requested_by','aknowlwdge_by','assign_worker','required_time','complete_time','created_by','created_by_cid','conective_entry','purchase_id','machine_id','created_date', 'work_status');
				break;

			case 'material':
				$all_fields = array('material_type_id','material_name','material_code','hsn_code','specification','inventory_amount','inventory_unit','prefix','tax','created_by','created_by_cid');
				break;	

			case 'supplier':
				$all_fields = array('supplier_code','name','address','country','city','state','gstin','contact_detail','material_type_id','material_name_id','website','bank_name','branch_name','account_no','ifsc_code','other','created_by','created_by_cid','edited_by','supp_account_group_id','mailing_name','save_status','favourite_sts');
				break;
					
			case 'purchase_indent':
				
				$all_fields = array('indent_code','material_type_id','material_name','preffered_supplier','grand_total','inductor','specification','other','departments','required_date','poCreate','created_by','validated_by','disapprove_reason','created_by_cid','po_or_not','mrn_or_not','edited_by','save_status','company_unit','ifbalance','status');
				break;

			case 'add_machine':
				
				$all_fields = array('machine_name','preventive_id','machine_code','machine_group_id','preventive_maintenance','machine_parameter','company_branch','department','make_model','year_purchase','placement','add_similar_machine','created_by_cid','save_status','created_by','edited_by','department_id','process','set_unset');
			    break;

			case 'user_dashboard':
				$all_fields = array('graph_id','user_id','show');
				break;

			case 'attachments':
				$all_fields = array('rel_type','rel_id','file_type','file_name');
				break;

			case 'purchase_budget':
				$all_fields = array('material_type_id','budget','created_by_cid');
				break;

			case 'purchase_budget':
				$all_fields = array('material_type_id','budget','created_by_cid');
				break;

			case 'material_type':
				$all_fields = array('budget');
				break;

			case 'add_preventive_data';
				$all_fields = array('start_date','machine_id','frequency','check_list','material_detail','created_by','created_by_cid','pre_completed','work_status','schedule_date','shift','end_time','worker','done_by','preventiv_all_data','upcomming_date'); 
			    break;
             
            case 'job_card':
				$all_fields = array('job_card_no','party_code','product_specification','party_requirement','test_certificate','material_details','material_costing','lot_qty','lot_uom','machine_details','created_by_cid','save_status','created_by','edited_by','process_type','job_card_product_name');
				break;

			case 'schedule_mentaince':
				$all_fields = array('preventive_id','machine_id','material','check_list','frequency','work_status','created_by','created_by_cid','created_date');
				break;

			
			default:
				$all_fields = array('subject','contactid','department','service','status','userid','adminreplying' , 'email' , 'name','priority','ticketkey','message','admin','project_id','lastReply','clientread','adminread','ip','assigned');
				
		}
		return $data = format_data_to_be_added($all_fields, $data);
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
		$result = $qry->result_array();		
		return $result;
	}
    

    public function get_data_breakdown($table = '' , $where = array(), $limit = ''){
       $dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$table = $table?$table:$this->tablename;
       $dynamicdb->select('*');
       $dynamicdb->from($table);
        $dynamicdb->where($where);
       $qry = $dynamicdb->get();
       $result = $qry->result_array();

		return $result;
      
    }

   /* Insert Breakdown Data */

		public function insert_bd_data($table,$data) {	
			$fieldData = $this->get_field_type_data($data,$table);
			$this->db->insert($table,$fieldData);
			$insertedid = $this->db->insert_id();
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$fieldData['id'] = $insertedid;	
			$dynamicInsertedid = $dynamicdb->insert($table,$fieldData);	
			return $insertedid; 
		}

	/* Update Breakdown Data */

	public function update_bd_data($table,$data,$field,$id) {		
		
        $data = $this->get_field_type_data($data,$table);
        unset($data['created_date']);
        $this->db->where($field, $id);		
        $result = $this->db->update($table, $data);	

		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($field, $id);		
			$dynamicdb->update($table, $data);	
		}
		return TRUE;
	}

	/*view data breakdown*/

	public function get_data_byId($table ,$field, $id) {
		if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
			$this->db->select('*');  
			$this->db->from($table);
			$this->db->where($table.'.'.$field, $id);
			$qry = $this->db->get();
		}else{
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*');  
			$dynamicdb->from($table);
			$dynamicdb->where($table.'.'.$field, $id);
			$qry = $dynamicdb->get();
		}
		$result = $qry->row();	
		return $result;
	}


	/* delete data breakdown*/

	public function delete_bd_data($table ,$field ,$id) {	
		$this->db->where($field, $id);
		$this->db->delete($table);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->where($field, $id);
		$dynamicdb->delete($table);
		return true;
	}


   public function get_worker_data($table = '' , $where = array()){
       $dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$table = $table?$table:$this->tablename;
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

	/*machine name data*/
    
    public function get_machine_data($table = '' , $where = array(), $limit = ''){
       $dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$table = $table?$table:$this->tablename;
       $dynamicdb->select('*');
       $dynamicdb->from($table);
      $qry = $dynamicdb->get();
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}
		return $result;	

    }
    

    	//num rows
	public function num_rows($table, $where = array()){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');  
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		// if($where2!=''){
		// $dynamicdb->where($where2);
		// }
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();
		$result = $qry->num_rows();		
		return $result; 
	}
 


 /*material code*/
	 /* Function to fetch Data od material */
		public function get_data($table = '' , $where = array() , $limit ='') {	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);			
			$table = $table?$table:$this->tablename;
			if($table=="material_type"){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}else if($table=="supplier"){
					$dynamicdb->select($table.'.*,'.$table.'.id as supplier_id,material.material_name as material_name');  
					$dynamicdb->from($table);		
					$dynamicdb->join("material", $table . ".material_name_id = material.id", 'left');
					$dynamicdb->order_by('supplier_id','DESC');	
			}
			else{
				// $this->db->select($table.'.*,material_type.name as materialType');
				// $this->db->from($table);
				// $this->db->join("material_type", $table . ".material_type_id = material_type.id", 'left');
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}
			$dynamicdb->where($where);
			$qry = $dynamicdb->get();
			$result = array();
			if($qry !== FALSE && $qry->num_rows() > 0){
			#echo $dynamicdb->last_query();	
				$result = $qry->result_array();
			}
			 if($table=="permissions"){
				$tempArr = array_unique(array_column($result, 'user_id'));
				$result = array_intersect_key($result, $tempArr);				
			}

			return $result;
		}

		/*Update Data*/
		public function update_data($table,$db_data,$field,$id) {
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);
		$result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->update($table, $db_data);
		return true;
	}

		/*   Update single value in table with where array given   */
	public function update_single_value_data($table,$data,$where) {
		$this->db->where($where);
		$this->db->update($table, $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($where);
		$dynamicdb->update($table, $data);
		return true;
	}
    
    /* Function to fetch Data by Id of material */
	public function get_tbl_data_byId($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');  
		$dynamicdb->from($table);
		$dynamicdb->where($table.'.'.$field, $id);
		$qry = $dynamicdb->get();	
		$result = $qry->result_array();	
		return $result;
	}

	/*Add Document In PI PO And  MRN*/
	public function get_docs_in_PI_PO_MRN($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');    
		$dynamicdb->from($table);
		$dynamicdb->where($field, $id);
		$dynamicdb->where('rel_type', 'PI_PO_MRN');
		//$this->db->where('rel_type', 'material');
		
		$qry = $dynamicdb->get();
		//echo $this->db->last_query(); die;
		$result = $qry->result_array();	
		return $result;
	}

	
/*PipeLine change status fucntion*/
	public function change_process_status($data, $id) {	
		$data = array( 
					'work_status' => $_POST['processTypeId']
				);	
		$this->db->where('id', $_POST['processId']);	
		$this->db->update('add_bd_request', $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->where('id', $_POST['processId']);	
		$dynamicdb->update('add_bd_request', $data);
		return true;
		
	}

	public function change_process_status_pre(){

         $data = array( 
					'work_status' => $_POST['processTypeId'],
				);	
		$this->db->where('id', $_POST['processId']);	
		$this->db->update('add_preventive_data', $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->where('id', $_POST['processId']);	
		$dynamicdb->update('add_preventive_data', $data);
		return true;

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


	/* delete data*/
	public function delete_data($table ,$field ,$id) {	
		$this->db->where($field, $id);
		$this->db->delete($table);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->where($field, $id);
		$dynamicdb->delete($table);
		return true;
	}



	/* Insert attachment Data */
	public function insert_attachment_data($table , $data = array(), $type) {
		if(!empty($data)){			
			foreach($data as $dt){
				$fieldData = $this->get_field_type_data($dt,$table);
				$this->db->insert($table,$fieldData);
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




public function get_data1($table = '' , $where = array(),$limit, $start,$where2,$order) {
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
				$dynamicdb->order_by("add_machine.priority_order", "asc");	
			}
			elseif($table=="add_process"){
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
				$dynamicdb->order_by("sale_order.sale_order_priority", "asc");
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
			$dynamicdb->order_by("id",$order);
			$dynamicdb->limit($limit, $start);
			$qry = $dynamicdb->get();
			$result = $qry->result_array();	
			//pre($dynamicdb->last_query()); 
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


public function get_machine_hostory($table) {

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*,'.$table.'.created_date as bd_created_date');
		$dynamicdb->from($table);
		//$dynamicdb->join('purchase_indent', $table.'.purchase_id = purchase_indent.id', 'LEFT');
		$qry = $dynamicdb->get();
		$result = $qry->row();			
		return $result;
	}
	

}