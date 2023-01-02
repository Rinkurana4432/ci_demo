<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        //$this->tablename = 'departments';
        //$this->column_search = array('name');
    } 
	
	/**
      * This function is used authenticate user at login
      */
  	function auth_user() {
		$email = $this->input->post('email');
		$pwd = easy_crypt($this->input->post('password'));
		//$this->db->select('user.*,user_detail.*'); 
		$this->db->select('user.*,user_detail.u_id, user_detail.name, user_detail.address1, user_detail.address2, user_detail.designation,user_detail.gender,user_detail.age,user_detail.contact_no,user_detail.experience, user_detail.experience_detail,user_detail.qualification, user_detail.user_profile, user_detail.date_joining, user_detail.facebook, user_detail.twitter, user_detail.instagram, user_detail.linkedin, user_detail.skill'); 
		$this->db->from('user');
		$this->db->join("user_detail", "user.id = user_detail.u_id", 'left');
		$this->db->where('password', $pwd);
		$this->db->where('email', $email);
		$qry = $this->db->get();
		//echo $this->db->last_query();die();
		$result = $qry->row();
		//pre($result);die();
		if(!empty($result)){       
			if ($result->email_status != 'verified') { 
					return 'Please verify your email id';
			}else if($result->status == 0){
				return 'Inactive account';
			}else{
				/* For Chat*/
				$this->db->where('u_id', $result->id);
				$this->db->update('user_detail', ['is_logged_in' => 1, 'last_login' => date('Y-m-d')]);
				/* For Chat*/
				return $result;
			}			
		}
		else {
			return 'Entered Wrong detail';
		}
  	}
	
	
	/*function auth_user_company_detail($companyid) {
		$this->db->select('user.*,company_detail.*'); 
		$this->db->from('company_detail');
		$this->db->join("user", "company_detail.id = user.c_id", 'left');
		$this->db->where('company_detail.id', $companyid);
		$qry = $this->db->get();
		echo $this->db->last_query();
		$result = $qry->row();
		return $result;
  	}*/
	
	function auth_user_company_detail($id) {
		$this->db->select('user.*, company_detail.u_id, company_detail.company_pan , company_detail.name , company_detail.gstin, company_detail.company_type, company_detail.year_of_establish, company_detail.description, company_detail.no_of_employees,company_detail.website, company_detail.phone,company_detail.logo, company_detail.cover_photo,company_detail.business_certificate_type,company_detail.business_certificate, company_detail.address, company_detail.certification, company_detail.key_people, company_detail.term_and_conditions, company_detail.revenue, company_detail.facebook, company_detail.twitter, company_detail.instagram, company_detail.linkedin, company_detail.google_plus, company_detail.mapiframe');	
		$this->db->from('user');
		$this->db->join("company_detail", "user.c_id = company_detail.id", 'left');
		$this->db->where('user.id', $id);
		$qry = $this->db->get();
		//echo $this->db->last_query();
		$result = $qry->row();
		return $result;
  	}
	
	    /* Insert Data */
	public function insert_tbl_data($data, $table) {
		//$fieldData = $this->get_field_type_data($data,$table);
		$fieldData = $this->get_field_type_data($data,$table);
		$this->db->insert($table,$fieldData);
		$insertedid = $this->db->insert_id();		 
		return $insertedid; 
	}
	
	/* database field columns */
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
				}
		
		return $data = format_data_to_be_added($all_fields, $data);
	}
	
	public function emailExist($email){
		$this->db->select('*'); 
		$this->db->from('user');
		$this->db->where('email',$email);
		$qry = $this->db->get();			
		$result = $qry->result_array();	
		return $result;
	}
	public function gstinExist($gstin){
		$this->db->select('*'); 
		$this->db->from('company_detail');
		$this->db->where('gstin',$gstin);
		$qry = $this->db->get();			
		$result = $qry->result_array();	
		return $result;
	}
	
	/* Function to fetch Data by field */
	public function get_data_by($table ,$field, $fieldValue) {
		$this->db->select('*');    
		$this->db->from($table);
		$this->db->where($field, $fieldValue);
		$qry = $this->db->get();			
		$result = $qry->row();
		return $result;
	}
	
		/* Update Data */
	public function update_data($table,$db_data,$field,$id, $companyDbExist = '') {
		$data = $db_data;		
		
		if($field == 'email'){
			#echo 'in 1';
			$db_data = $this->get_field_type_data($db_data, $table,'updatePassword');			
		}else if($data == array('email_status' => 'verified')){
				#echo 'in 2';
			$db_data = $data;
		}else{
			#	echo 'in 3';
			$db_data = $this->get_field_type_data($db_data, $table,'updateUserCid');
		}
		$this->db->where($field, $id);		
		$result = $this->db->update($table, $db_data);		
		if(($data == array('email_status' => 'verified')) && $companyDbExist=='companyDbExist'){			 
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($field, $id);		
			$dynamicdb->update($table, $db_data);	
		}
		return true;
	}
	
	
	
	
	//funtion to get email of user to send password
 public function ForgotPassword($email){
	$this->db->select('email');
	$this->db->from('user'); 
	$this->db->where('email', $email); 
	$query=$this->db->get();
	return $query->row_array();
 }
 
 
 public function logout_for_chat($logout_user_id){
	/* For Chat*/
	$this->db->where('u_id', $logout_user_id);
	$this->db->update('user_detail', ['is_logged_in' => 0, 'last_login' => date('Y-m-d')]);
 }
 

	
 
}