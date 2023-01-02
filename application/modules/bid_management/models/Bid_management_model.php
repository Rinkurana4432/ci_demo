<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bid_management_model extends ERP_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tablename = 'leads';
        //$this->column_search = array('name');

         $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

    }  
	
	/* database field columns */
	public function get_field_type_data($data, $table){
		switch($table){
			case 'register_opportunity':				
				$all_fields = array('tender_detail','issue_date', 'clossing_date', 'emd_amount', 'tender_amount', 'bid_id', 'bid_location', 'lpr_rate', 'material_type_id', 'agent_id', 'product_detail', 'totalwithoutgst', 'grand_total',  'quantites', 'tender_owner', 'tender_status','bid_comp_price_info', 'comp_status', 'counter_offer','offer_is_reject','offer_is_accept','status_comment', 'save_status', 'favourite_sts','approve','disapprove','validated_by','disapprove_reason','result','reject_reason','loa_code','loa_date','payment_terms','billing_name','delivery_schedule','contact_person_name','company_address','inspection_agency','other_terms','svc_clause','email_id','deposit_name','deposit_date','item_rate','loa_gst','contact_number','item_desc','rites_add','option_clause','consignee','po_code','po_date','po_payment_terms','po_billing_name','amendments','po_delivery_schedule','po_contact_person_name','po_company_address','po_inspection_agency','po_other_terms','po_svc_clause','po_email_id','po_item_rate','po_gst','po_contact_number','po_item_desc','po_rites_add','po_option_clause','po_bank_details','po_consignee','created_by', 'edited_by', 'created_by_cid', 'created_date', 'updated_date');
				break;			
			
			case 'tender_activity':
				$all_fields = array('lead_id','subject','comment','created_by','assigned_to','due_date','activity_type','created_by_cid','new_task_status');
				break;

			case 'attachments':
				$all_fields = array('rel_type','rel_id','file_type','file_name');
				break;

			case 'user_dashboard':
				$all_fields = array('graph_id','user_id','show');
				break;
			case 'liasoning_agent':
				$all_fields = array('id','name','phone','email','agreement_no','agreement_upload','address','created_by_cid','created_date');
				break;
			case 'meeting_scheduling':
				$all_fields = array('id','agent_id','tender_id','meeting_date','meeting_time','meeting_person','meeting_location','message_attachment','message_detail','attachment','detail','status','created_by_cid','created_date');
				break;
				case 'bid_competitor_details':
				$all_fields = array('account_owner', 'name', 'phone', 'fax', 'parent_account', 'website', 'gstin', 'email', 'type','product_detail', 'employee', 'industry', 'revenue', 'description', 'billing_street', 'billing_city', 'billing_zipcode', 'billing_state', 'billing_country', 'shipping_street', 'shipping_city', 'shipping_zipcode', 'shipping_state', 'shipping_country', 'save_status', 'favourite_sts', 'created_by', 'edited_by');
			 	break;
				 case 'bid_comp_price':
				 $all_fields = array('account_owner', 'account_id', 'phone', 'fax', 'gstin', 'product_detail', 'save_status', 'favourite_sts', 'created_by', 'edited_by');
				 break;
				 case 'bid_prodct_price':
				 $all_fields = array('material_type_id', 'material_name', 'comp_price_info', 'favourite_sts', 'created_by', 'created_by_cid');
				 break;
				  case 'tender_price':
				 $all_fields = array('id','tender_id','bid_comp_price_info','favourite_sts','save_status','created_by', 'created_by_cid');
				 break;
				 case 'sale_order':
				$all_fields = array('so_order','company_unit','account_id','contact_id','tender_id', 'order_date', 'product', 'dispatch_date', 'agt', 'freight', 'payment_terms', 'advance_received', 'cash_discount', 'discount_offered', 'label_printing_express', 'brand_label', 'dispatch_documents', 'product_application', 'guarantee','convrtd_frm_quot_to_pi','convrtd_frm_quot_to_so','created_by','created_by_cid','total','grandTotal','payment_date','save_status','party_ref','material_type_id','completed_by','complete_status');
				break;	
				case 'sale_order_priority':
				$all_fields = array('sale_order_id','product_id','gst','quantity','uom','price','individualTotal','individualTotalWithGst','created_by_cid','priority');
				break;
				case 'npdm':				
				$all_fields = array('product_name', 'product_require', 'product_detail', 'job_card', 'expenses', 'labour_expenses', 'budget_assigned', 'npdm_owner', 'end_date', 'save_status', 'favourite_sts', 'created_by', 'edited_by', 'created_by_cid', 'created_date', 'updated_date', 'npdm_status');
				break;	
				 case 'work_detail':
                $all_fields = array('job_name', 'work_assigned_to','tender_id', 'end_date_time', 'work_description', 'npdm_id', 'work_status', 'created_by', 'created_by_cid');

            break;
		}
		return $data = format_data_to_be_added($all_fields, $data);
	}
	
public function get_last_id()
{
	$this->load->database();
	$query = $this->db->query("SELECT id FROM register_opportunity order by id desc limit 1");
	$row =  $query->row();
	return $row->id;
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
		/*get datab by id from company in sale order */
	public function get_data_byAddress($table,$where = array()){
		if($_SESSION['loggedInUser']->role == 3){	
			$this->db = $this->load->database('dynamicdb', TRUE);			
			$this->db->select('address');    
			$this->db->from($table);
			$this->db->where($where);
			$qry= $this->db->get();
			$result = $qry->result_array();			
			return $result;
		}else{
			$dynamicdb = $this->load->database('dynamicdb', TRUE);			
			$dynamicdb->select('address');    
			$dynamicdb->from($table);
			$dynamicdb->where($where);
			$qry= $dynamicdb->get();
			$result = $qry->result_array();			
			return $result;
		}
	}
	public function get_data_listing($table = '',$where = array(),$limit, $start,$where2,$order){	
//pagination
		$start = ($start-1) * $limit;	
		if($_SESSION['loggedInUser']->role == 3){			
			$table = $table?$table:$this->tablename;
			if($table == 'leads'){
				$this->db->select($table.'.* ,createdBy.name AS createdByName, leadOwner.name AS leadOwnerName'); 
				$this->db->from($table);
				$this->db->join("user_detail as createdBy", $table . ".created_by = createdBy.u_id", 'left');
				$this->db->join("user_detail as leadOwner", $table . ".lead_owner = leadOwner.u_id", 'left');
			}else{			
				$this->db->select('*'); 
				$this->db->from($table);
			}
			$this->db->where($where);
			if($where2!=''){
		$dynamicdb->where($where2);
		}
		$dynamicdb->order_by('id',$order);
			$dynamicdb->limit($limit, $start);
			//$this->db->limit($limit, $offset);	
			$qry = $this->db->get();	
			$result = $qry->result_array();	
			return $result;
		}else{			
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			if($table == 'leads'){
				$dynamicdb->select($table.'.* ,createdBy.name AS createdByName, leadOwner.name AS leadOwnerName'); 
				$dynamicdb->from($table);
				$dynamicdb->join("user_detail as createdBy", $table . ".created_by = createdBy.u_id", 'left');
				$dynamicdb->join("user_detail as leadOwner", $table . ".lead_owner = leadOwner.u_id", 'left');
			}else{			
				$dynamicdb->select('*'); 
				$dynamicdb->from($table);
			}
			
			$dynamicdb->where($where);
			if($where2!=''){
		$dynamicdb->where($where2);
		}
		$dynamicdb->order_by('id',$order);
			$dynamicdb->limit($limit, $start);
			//$dynamicdb->limit($limit, $offset);							
			$qry = $dynamicdb->get();				
			$result = $qry->result_array();				
			return $result;
		}
	}	
	 /* Function to fetch Data */
	public function get_data($table = '' , $where = array(), $limit = '') {	
		if($_SESSION['loggedInUser']->role == 3){			
			$table = $table?$table:$this->tablename;
			$this->db->select('*'); 
			$this->db->from($table);
			$this->db->where($where);
			if($limit !='')	
			$this->db->limit($limit);
			if($table != 'permissions' && $table != 'lead_status' && $table != 'user_detail' && $table != 'material' && $table != 'contacts' && $table != 'account_activity' && $table != 'sale_order_dispatch' && $table != 'user_dashboard' && $table != 'user' && $table != 'lead_activity' && $table != 'activity_log' && $table != 'company_act_log' && $table != 'price_list' && $table != 'tender_status')
				$this->db->order_by('created_date', "desc");		
			#$this->db->order_by('favourite_sts','created_date', 'asc');		
			$qry = $this->db->get();	
			$result = $qry->result_array();	
			return $result;
		}else{			
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			$dynamicdb->select('*'); 
			$dynamicdb->from($table);

			//echo $table;
			$dynamicdb->where($where);
			if($limit !='')	
			$dynamicdb->limit($limit);
			if($table != 'permissions'  && $table != 'lead_status' && $table != 'user_detail' && $table != 'material' && $table != 'contacts'
			&& $table != 'account_activity'  && $table != 'sale_order_dispatch'  && $table != 'user_dashboard' && $table != 'user' && $table != 'lead_activity' && $table != 'activity_log' && $table != 'company_act_log' && $table != 'price_list' && $table != 'tender_status')
				$dynamicdb->order_by('created_date', "desc");
			#$dynamicdb->order_by('favourite_sts','created_date', 'asc');		
			$qry = $dynamicdb->get();	
			$result = $qry->result_array();	
			return $result;
		}
	}	

	 /* Function to fetch Data */
	public function get_tbl_data($table = '' , $where = array(), $limit = '') {
		if($_SESSION['loggedInUser']->role == 3){		
			$table = $table?$table:$this->tablename;
			if($table == 'register_opportunity'){
				$this->db->distinct();
			}
			$this->db->select($table.'.* ,createdBy.name AS createdByName, tender_owner.name AS tender_ownerName'); 
			$this->db->from($table);
			$this->db->join("user_detail as createdBy", $table . ".created_by = createdBy.u_id", 'left');
			$this->db->join("user_detail as tender_owner", $table . ".tender_owner = tender_owner.u_id", 'left');
			$this->db->where($where);
			if($limit != '')
			$this->db->limit($limit);
			#$this->db->order_by('leads.favourite_sts','leads.created_date', "desc");	
			$this->db->order_by('register_opportunity.created_date', "desc");	
			//$dynamicdb->group_by('register_opportunity.id');			
			$qry = $this->db->get();	
			//echo $this->db->last_query();die();		
			$result = $qry->result_array();	
			
			return $result;
		}else{			
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			$dynamicdb->select($table.'.* ,createdBy.name AS createdByName, tender_owner.name AS tender_ownerName'); 
			$dynamicdb->from($table);
			$dynamicdb->join("user_detail as createdBy", $table . ".created_by = createdBy.u_id", 'left');
			$dynamicdb->join("user_detail as tender_owner", $table . ".tender_owner = tender_owner.u_id", 'left');
			$dynamicdb->where($where);
			if($limit != '')
			$dynamicdb->limit($limit);
			$dynamicdb->order_by('register_opportunity.id', "desc");	
			//$dynamicdb->group_by('register_opportunity.id');
			#$dynamicdb->order_by('leads.favourite_sts','leads.created_date', "desc");		
			$qry = $dynamicdb->get();			
			$result = $qry->result_array();	
		//	echo $dynamicdb->last_query(); die();
			return $result;
		}
	}	
	
	
	
	//public function get_own_tbl_lead_data($table = '', $limit = ''){
	public function get_own_tbl_data($table = '', $where = array(), $limit = '', $ownerKey = ''){
		if($_SESSION['loggedInUser']->role != 3){		
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			$dynamicdb->select($table.'.* ,createdBy.name AS createdByName, leadOwner.name AS leadOwnerName'); 
			$dynamicdb->from($table);
			$dynamicdb->join("user_detail as createdBy", $table . ".created_by = createdBy.u_id", 'left');
			$dynamicdb->join("user_detail as leadOwner", $table . ".".$ownerKey." = leadOwner.u_id", 'left');
			
			if($table == 'leads'){			
				$dynamicdb->where($where);			
				$dynamicdb->where($ownerKey,$_SESSION['loggedInUser']->id);
				
			}else{
				$dynamicdb->where('created_by',$_SESSION['loggedInUser']->id);			
				$dynamicdb->or_where($ownerKey,$_SESSION['loggedInUser']->id);
				
			}
			
			/*//$dynamicdb->where('created_by',$_SESSION['loggedInUser']->id);
			$dynamicdb->where($where);
			#$dynamicdb->or_where($ownerKey,$_SESSION['loggedInUser']->id);
			$dynamicdb->where($ownerKey,$_SESSION['loggedInUser']->id);*/
			if($limit != '')
			$dynamicdb->limit($limit);
			#$dynamicdb->order_by($table.'favourite_sts',"desc");
			$dynamicdb->order_by($table.'.'.'created_date','desc');
			$qry = $dynamicdb->get();
			//echo $this->db->last_query();die();
			$result = $qry->result_array();		
			return $result;
		}
	}

	
	
	    /* Insert Data */
	public function insert_tbl_data($table,$data) {

			
			$fieldData = $this->get_field_type_data($data,$table);
			$this->db->insert($table,$fieldData);
			$insertedid = $this->db->insert_id();
			//echo $this->db->last_query();
			#pre($insertedid);
			#die;
			if($insertedid){
				if($_SESSION['loggedInUser']->role != 3){
					$dynamicdb = $this->load->database('dynamicdb', TRUE);
					$fieldData['id'] = $insertedid;
					$dynamicdb->insert($table,$fieldData);
					$dynamicdb->insert_id();	
				}
			}
		//	echo $this->db->last_query();die();
			return $insertedid; 

		}
		
    /* Update Data */
	
		public function update_data_details($table,$db_data,$field,$id) {		
	
		//$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);		
		$result = $this->db->update($table, $db_data);	

		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($field, $id);		
			$dynamicdb->update($table, $db_data);	
		}
		return TRUE;
	}	
	
	
	public function update_data($table,$db_data,$field,$id) {		
//	pre($db_data);
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);	
		
		$result = $this->db->update($table, $db_data);	
//echo $this->db->last_query(); die();
		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($field, $id);		
			$dynamicdb->update($table, $db_data);	
		}
		return TRUE;
	}	
	
	/* Function to fetch Data by Id of material */
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
	

	
	
	/* Function to delete data from selected Table */
	public function delete_data($table ,$field ,$id) {	
		$this->db->where($field, $id);
		if($this->db->delete($table)){	
			if($_SESSION['loggedInUser']->role != 3){		
				$dynamicdb = $this->load->database('dynamicdb', TRUE);
				$dynamicdb->where($field, $id);
				$dynamicdb->delete($table);
				
			}
			return true;
		}		
	}
	
	/* Insert attachment Data */
	public function insert_attachment_data($table , $data = array(), $type) {
		if(!empty($data)){			
			foreach($data as $dt){
				$fieldData = $this->get_field_type_data($dt,$table);
				$this->db->insert($table,$fieldData);
				$insertedid = $this->db->insert_id();	
				if($_SESSION['loggedInUser']->role != 3){
					if($insertedid){
						$dynamicdb = $this->load->database('dynamicdb', TRUE);
						$fieldData['id'] = $insertedid;	
						$dynamicInsertedid = $dynamicdb->insert($table,$fieldData);
					}
				}				
			}
			return $insertedid; 
		}
		
	}
	
	public function change_lead_status($id, $status, $statusComment = '') {
		$this->db->where('id', $id);		
		$status = array('tender_status' => $status,'status_comment' => $statusComment);
		$this->db->update('register_opportunity', $status );
		if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('id', $id);	
			$dynamicdb->update('register_opportunity', $status);
		}
		return true;
	}	
	public function get_attachmets_by_saleOrderId($table ,$where = '') {
		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*');    
			$dynamicdb->from($table);
			$dynamicdb->where($where);
			$qry = $dynamicdb->get();			
			$result = $qry->result_array();	
			return $result;
		}
	}
	
	/* Update Data */
	public function updateSaleTarget($table,$where = array(),$db_data) {
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($where);		
		$result = $this->db->update($table, $db_data);
		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($where);		
			$dynamicdb->update($table, $db_data);
		}			
		return $result;
	}




public function markfavour($table,$data,$key) {
			$data1 = array('favourite_sts' => $data);
			$ids = $key;
			$this->db->where('id',$ids);
			$result = $this->db->update($table,$data1);

		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('id',$ids);		
			$dynamicdb->update($table, $data1);	
		}
		return TRUE;
	}

/*PipeLine change status fucntion*/
	public function change_process_status($data, $id) {	
		$data = array( 
					'tender_status' => $_POST['processTypeId']
				);	
		$this->db->where('id', $_POST['processId']);	
		$this->db->update('register_opportunity', $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->where('id', $_POST['processId']);	
		$dynamicdb->update('register_opportunity', $data);
		return true;
		
	}
/*PipeLine change  order fucntion*/
   public function change_process_order($orders){
		foreach ($orders as $order) {
            $id = $order['id'];
                if ($order['id'] == $id) {					
					$data =  array('order_id' => $order['position']);	
					$this->db->where('id', $id);
					$this->db->update('register_opportunity', $data);
					$dynamicdb = $this->load->database('dynamicdb', TRUE);
					$data =  array('order_id' => $order['position']);	
					$dynamicdb->where('id', $id);
					$dynamicdb->update('register_opportunity', $data);			
				}
			}
		}

function updateRowWhere($table, $where = array(), $data = array()) {
    
    $this->db->where($where);
    $this->db->update($table, $data);

    if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($where);	
			$dynamicdb->update($table, $data);	
		}

   // echo $this->db->last_query();
}
function get_multiple_data($table,$where){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*,register_opportunity.id as tender_id'); 
			$dynamicdb->from($table);
			if($where!=''){
			$dynamicdb->where($where);
			}
			$dynamicdb->join("meeting_scheduling", $table . ".id = meeting_scheduling.agent_id", 'right');	
			$dynamicdb->join("register_opportunity","meeting_scheduling.tender_id = register_opportunity.id", 'inner');	
			$qry = $dynamicdb->get();	
	//echo $dynamicdb->last_query();die();	
			$result = $qry->result_array();	
			return $result;
}

public function disApprovedata($data) {
		$this->db->where('id', $data['id']);		
		//$approveData = array('approve' => 0,'validated_by' =>  $data['validated_by'] ,'disapprove' => 1, 'disapprove_reason' =>'');
		$this->db->update('register_opportunity', $data );
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $data['id']);
		$dynamicdb->update('register_opportunity', $data );
		//echo $dynamicdb->last_query();die();	
		return true;
	}
public function approvebiddata($data) {
		$this->db->where('id', $data['id']);		
		$approveData = array('approve' => $data['approve'],'validated_by' =>  $data['validated_by'] ,'disapprove' => 0 ,'disapprove_reason' => '');
		$this->db->update('register_opportunity', $approveData );
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $data['id']);	
		$dynamicdb->update('register_opportunity', $approveData );	
		return true;
	}

public function importbid($data) {
  
    	$res = $this->db->insert_batch('register_opportunity',$data);
       //echo $this->db->last_query();die();
		 if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$res = $dynamicdb->insert_batch('register_opportunity',$data);
		}    
		
		 if($res){
		 return TRUE;
		 }else{
		 return FALSE;
		 }

 }

 
 
 
 
 	/*   Update single value in table with where array given   */
	public function update_single_value_data($table,$data,$where) {
		$this->db->where($where);
		$this->db->update($table, $data);
		if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($where);
			$dynamicdb->update($table, $data);
		}
		return true;
	}
	public function insertPriorityData($table , $data = array()) {
		if(!empty($data)){			
			foreach($data as $dt){
				$fieldData = $this->get_field_type_data($dt,$table);
				$this->db->insert($table,$fieldData);
				$insertedid = $this->db->insert_id();	
				if($_SESSION['loggedInUser']->role != 3){	
					if($insertedid){
						$dynamicdb = $this->load->database('dynamicdb', TRUE);
						$fieldData['sale_order_priority_id'] = $insertedid;	
						$dynamicInsertedid = $dynamicdb->insert($table,$fieldData);
					}
				}
			}
			return $insertedid; 
		}
	}
//end of modal
}

