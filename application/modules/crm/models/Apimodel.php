<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Apimodel extends ERP_Model {
         function __construct() {
         parent::__construct();
         $this->load->helper('url');
		 $this->load->database();
     	}
		public function loginmodel($email2,$pwd2){	
			$email = $email2;
			$pwd = base64_encode($pwd2 . "_@#!@");
			 $this->db->select('user.*,user_detail.u_id, user_detail.name, user_detail.address1, user_detail.address2, user_detail.designation,user_detail.gender,user_detail.age,user_detail.contact_no,user_detail.experience, user_detail.experience_detail,user_detail.qualification, user_detail.user_profile, user_detail.date_joining, user_detail.facebook, user_detail.twitter, user_detail.instagram, user_detail.linkedin, user_detail.skill'); 
			$this->db->from('user');
			$this->db->join("user_detail", "user.id = user_detail.u_id", 'left');
			$this->db->where('password', $pwd);
			$this->db->where('email', $email);
			$qry = $this->db->get();
		//	pre($this->db);
			//echo $this->db->last_query();
			return $result = $qry->row();
			
	}
	
	
	public function insert_tbl_data($table,$data) {
		$this->db->insert($table,$data);
		$insertedid = $this->db->insert_id();
		$data['id'] = $insertedid;
		$dynamicdb = $this->load->database('dynamicdb', TRUE); 
		$dynamicdb->insert($table,$data);
		return $insertedid; 
	} 
	public function insert_data($config_app,$table,$data) {
	# pre($data);	pre($config_app);pre($table);die;
		$this->db->insert($table,$data);
		$insertedid = $this->db->insert_id();
		$data['id'] = $insertedid;
		$dynamicdb = $this->load->database($config_app, TRUE); 
		$dynamicdb->insert($table,$data);
		#echo $this->db->last_query();die;
		return $insertedid; 
	}  
	
	public function get_field_type_data($data,$table, $type = ''){
		switch($table){			
			case 'user':	
					if($type =='updateUserCid'){
						$all_fields = array('c_id');
					}elseif( $type =='updatePassword'){
						$all_fields = array('password');
					}else{
						$all_fields = array('email','password','email_status','c_id','activation_code','role','status');
					}
					break;	

			case 'company_detail':
				$all_fields = array('u_id','gstin','name','phone');
				break;

			case 'user_detail':
				$all_fields = array('u_id','c_id','name');
				break;
				
			case 'attachments':
				$all_fields = array('rel_type','rel_id','file_type','file_name');
				break;

			case 'account':
				$all_fields = array('account_owner','name','phone','fax','parent_account','website','type','employee','industry','revenue','description','billing_street','billing_city','billing_zipcode','billing_state','pan','billing_country','shipping_street','shipping_city','shipping_zipcode','shipping_state','shipping_country','gstin','email','created_by','edited_by','save_status','salesPersons','limit_type','credit_limit','days_limit','per_credit_limit','per_days_limit','ledger_id','password','status');
				break;

			case 'sale_order':
				$all_fields = array('sale_order_priority', 'so_order', 'company_unit', 'account_id', 'contact_id', 'tender_id', 'party_ref', 'order_date', 'material_type_id', 'product', 'total', 'grandTotal', 'dispatch_date', 'production_dispatch_date', 'dispatch_product', 'dispatch_type', 'dispatched_date', 'gst', 'agt', 'freight', 'payment_terms', 'payment_date', 'payment_status', 'advance_received', 'cash_discount', 'discount_offered', 'label_printing_express', 'brand_label', 'dispatch_documents', 'product_application', 'guarantee', 'convrtd_frm_quot_to_pi', 'convrtd_frm_quot_to_so', 'created_by', 'created_by_cid', 'approve', 'approve_date','pending_so','counter_offer','speacial_so', 'disapprove', 'disapprove_reason', 'save_status', 'salesperson', 'favourite_sts', 'validated_by', 'complete_status', 'partially_complete_status', 'completed_by','resone_code','comments','reasone_comment');
				break;	
				
			}	

		
		return $data = format_data_to_be_added($all_fields, $data);
	}
	public function update_data($table,$data,$field,$id) {
		
			$this->db->where($field, $id);	
			$result = $this->db->update($table, $data);
		
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($field, $id);	
			$result = $dynamicdb->update($table, $data);	
		//return TRUE;
	}
	public function update_data_multiple($config_app,$table,$data,$where) {
		
			$this->db->where($where);
	    	$result = $this->db->update($table, $data);
	    	
	        $dynamicdb = $this->load->database($config_app, TRUE); 
			$dynamicdb->where($where);	
			$result = $dynamicdb->update($table, $data);
		//	pre($dynamicdb->last_query());die;

		//return TRUE;
	}
	public function get_data($table = '' , $where = array()) {		
			$this->db->select('*'); 
			$this->db->from($table);
			$this->db->where($where);
			$qry = $this->db->get();
			$result = $qry->result();	
			//echo $this->db->last_query();
			return $result;
	}	
	public function get_single_record($table = '' , $where = array()) {	
			$sql="SELECT * FROM {$table} WHERE id IN (SELECT MAX(id) FROM {$table} GROUP BY created_by)";    
			$query = $this->db->query($sql);
			$data = array();
			if($query !== FALSE && $query->num_rows() > 0){
				$data = $query->result_array();
			}

			return $data;
	}
	
	public function get_user_by_cid($table ,$field, $where) {
		$this->db->select('user.*,'.$table.'.*');    
		$this->db->from($table);
		$this->db->join("user", $table . ".u_id = user.id", 'left');
		$this->db->where($where);
		$qry = $this->db->get();	
		#echo $this->db->last_query();		
		$result = $qry->result_array();	
		return $result;
	}	
		
		# get group permission by group Id
	function fetch_user_premissions_by_id($config_app,$id , $where = array()){		
		$dynamicdb = $this->load->database($config_app, TRUE);	
		$dynamicdb->select('sm.sub_module_name as sub_module_name,sm.id as sub_module_id,p.id ,p.is_all as is_all,p.is_view as is_view,p.is_add as is_add,p.is_edit as is_edit,p.is_delete as is_delete,p.is_validate as is_validate ,p.is_validate_purchase_budget_limit as is_validate_purchase_budget_limit');
		$dynamicdb->from('sub_module sm');
		$dynamicdb->join('permissions p', 'sm.id = p.sub_module_id and p.user_id="'.$id.'"','left');
		$dynamicdb->where($where);
		$query = $dynamicdb->get(); 			
		$result = $query->row();	
		return $result;
	}	
	function getNameById($table='',$id='',$field=''){	
		$qry="select * from $table where $field='$id'";
		$qryy = $this->db->query($qry);	
		$result = $qryy->row();	
		return $result;	
	}
	function getNameById_con($table='',$id='',$field=''){	
		$qry="select * from $table where $field='$id'";
		$qryy = $this->db->query($qry);	
		$result = $qryy->row();	
		return $result;	
	}
	function check_attendance_signin($config_app,$table='', $where = array()){	
	    $dynamicdb = $this->load->database($config_app, TRUE);
	 $query = $dynamicdb->get_where($table, $where);
        return $query->num_rows();
	}
	
	public function insert_attachment_data($config_app,$table, $data = array(), $type) {
        if (!empty($data)) {
            foreach ($data as $dt) {
                $fieldData = $this->get_field_type_data($dt, $table);
                $this->db->insert($table, $fieldData);
                $insertedid = $this->db->insert_id();
                if ($insertedid) {
                        $dynamicdb = $this->load->database($config_app, TRUE);
                        $fieldData['id'] = $insertedid;
                        $dynamicInsertedid = $dynamicdb->insert($table, $fieldData);
                       # pre($this->dynamicdb->last_query());
                }
            }
             return $insertedid;
        }
    }

    public function insert_data_so($config_app,$table,$data) {
	# pre($data);	pre($config_app);pre($table);die;
    	 $fieldData = $this->get_field_type_data($data, $table);
		$this->db->insert($table,$fieldData);
		$insertedid = $this->db->insert_id();
		$data['id'] = $insertedid;
		$dynamicdb = $this->load->database($config_app, TRUE); 
		$dynamicdb->insert($table,$fieldData);
		//echo $this->db->last_query();die;
		return $insertedid; 
	}  

	public function update_data_route_plan($config_app,$table,$data,$field,$id) {
		
			$this->db->where($field, $id);	
			$result = $this->db->update($table, $data);
		
			$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->where($field, $id);	
			$result = $dynamicdb->update($table, $data);	
		//return TRUE;
	}

	public function update_data_so($config_app,$table,$data,$field,$id) {
			$this->db->where($field, $id);	
			$result = $this->db->update($table, $data);
			$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->where($field, $id);	
			$result = $dynamicdb->update($table, $data);	
		//return TRUE;
	}
}		