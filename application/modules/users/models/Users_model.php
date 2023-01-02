<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends ERP_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tablename = 'user';
        //$this->column_search = array('name');
    }  
	
	/* database field columns */
	public function get_field_type_data($data, $type){
		switch($type){
			case 'user':
					$all_fields = array('email','password','email_status','status','role','c_id','activation_code','company_db_name','business_status');							
				break;
			case 'user_detail':
					$all_fields = array('name','correspondence_state','permanent_state','address1','address2','designation','gender','age','contact_no','experience','qualification','date_joining','u_id','c_id','facebook','linkedin','twitter','instagram','skill','experience_detail','save_status');								
				break;
			case 'company':
				$all_fields = array('name','email','password','email_status','user_id');
				break;	
			case 'permissions':
				$all_fields = array('sub_module_id','user_id','is_all','is_view','is_edit','is_delete','is_add');
				break;
			
		}
		return $data = format_data_to_be_added($all_fields, $data);
	}
	
	
	 /* Function to fetch Data 
	public function get_data($table = '' , $where = array()) {
		$this->tablename = $table?$table:$this->tablename;
		$this->db->select('user.*,company.email,company.name'); 
		$this->db->from($this->tablename);
		$this->db->join("company", $table . ".company_id = company.id", 'left');
		$this->db->where($where);
		$qry = $this->db->get();			
		$result = $qry->result_array();			
		return $result;
	}	
	
	    /* Insert Data */
	public function insert_tbl_data($table , $data) {
		$fieldData = $this->get_field_type_data($data,$table);
		$this->db->insert($table,$fieldData);
		$userInsertedid = $this->db->insert_id();
		if($userInsertedid){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$fieldData['id'] = $userInsertedid;	
			$dynamicUserInsertedid = $dynamicdb->insert($table,$fieldData);
		}
		return $userInsertedid; 
	}
		
	public function get_data($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		#pre($dynamicdb);
		if($table=="sub_module" || $table=="modules" || $table=="activity_log"){
			$dynamicdb->select('*'); 
			$dynamicdb->from($table);
		}
		else{			
			$dynamicdb->select($table.'.*,`user_detail`.u_id, user_detail.name, user_detail.address1, user_detail.address2, user_detail.designation,user_detail.gender,user_detail.age,user_detail.contact_no,user_detail.experience, user_detail.experience_detail,user_detail.qualification, user_detail.user_profile, user_detail.date_joining, user_detail.facebook, user_detail.twitter, user_detail.instagram, user_detail.linkedin, user_detail.skill','user_detail.save_status'); 
			$dynamicdb->from($table);
			$dynamicdb->join("user_detail", $table . ".id = user_detail.u_id", 'left');
		}		
		
		if($table=="modules" && !empty($where))
		$dynamicdb->where_in('id',$where);
		else
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();		
		#echo $dynamicdb->last_query();
		$result = $qry->result_array();	
		return $result;
	}	
	
	
    /* Update Data in master database table in individual database*/
	public function update_data($table,$db_data,$field,$id) {
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);
		$result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE); // Connect to individual database and than update
		$dynamicdb->where($field, $id);
		$dynamicdb->update($table, $db_data);
		return true;
	}	
	
	/* Function to fetch Data by Id */
	public function get_data_byId($table ,$field, $id) {	
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,user_detail.u_id, user_detail.name, user_detail.address1, user_detail.address2, user_detail.designation,user_detail.gender,user_detail.age,user_detail.contact_no,user_detail.experience, user_detail.experience_detail,user_detail.qualification, user_detail.user_profile, user_detail.date_joining, user_detail.facebook, user_detail.twitter, user_detail.instagram, user_detail.linkedin, user_detail.skill,user_detail.save_status');    
		$dynamicdb->from($table);
		$dynamicdb->join("user_detail", $table . ".id = user_detail.u_id", 'left');
		$dynamicdb->where($table.'.'.$field, $id);
		$qry = $dynamicdb->get();	
		$result = $qry->row();	
		return $result;
	}
	
	
	public function get_user_data_byId($table ,$field, $id) {	
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('user.*, company.id as companyId , company.email as email,company.name as companyName');    
		$dynamicdb->from($table);
		$dynamicdb->join("user", $table . ".user_id = user.id", 'left');
		$dynamicdb->where('company.'.$field, $id);
		$qry = $dynamicdb->get();			
		$result = $qry->row();	
		return $result;
	}
	
	
	public function emailExist($email){
		$this->db->select('*'); 
		$this->db->from('user');
		$this->db->where('email',$email);
		$qry = $this->db->get();			
		$result = $qry->result_array();	
		return $result;
	}
	/* Function to delete data from selected Table */
	public function delete_data($table ,$field ,$id) {	
		$this->db->where($field, $id);
		$del=$this->db->delete($table);
		if($del){
			$this->db->where('u_id', $id);
			$this->db->delete('user_detail'); 
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($field, $id);
			$delFromDynamicDb=$dynamicdb->delete($table);
			if($delFromDynamicDb){
				$dynamicdb->where('u_id', $id);
				$dynamicdb->delete('user_detail'); 
			}	
		}
		return true;
	}
	
		/*Update group permissions*/
    function update_user_permissions($user_id,$id,$permissions_data) {
        $this->db->where('user_id', $user_id);
        $this->db->where('sub_module_id', $id);
        $q = $this->db->get('permissions');
        if ($q->num_rows() > 0 ){
            $this->db->where('user_id', $user_id);
            $this->db->where('sub_module_id', $id);
			$this->db->update('permissions',$permissions_data);
			$dynamicdb = $this->load->database('dynamicdb', TRUE);	
			$dynamicdb->where('user_id', $user_id);
            $dynamicdb->where('sub_module_id', $id);			
			$dynamicUserInsertedid = $dynamicdb->update('permissions',$permissions_data);
        } else {
           $this->db->insert('permissions',$permissions_data);
		   
		  $insertedId =  $this->db->insert_id();
		   $dynamicdb = $this->load->database('dynamicdb', TRUE);
			$permissions_data['id']		  = $insertedId;
		   $dynamicUserInsertedid = $dynamicdb->insert('permissions',$permissions_data);
        }
        return true;
    }  
	
	
	# Save user permissions
	public function save_user_permissions($data){
		$this->db->insert('permissions',$data);
		$id = $this->db->insert_id();
		$dynamicdb = $this->load->database('dynamicdb', TRUE);			
		$dynamicUserInsertedid = $dynamicdb->insert('permissions',$data);
		return $id;
	}
	
	# get group permission by group Id
	function fetch_user_premissions($id){		
		$dynamicdb = $this->load->database('dynamicdb', TRUE);				
		$dynamicdb->select('sm.sub_module_name as sub_module_name,sm.id as sub_module_id,p.is_all as is_all,p.is_view as is_view,p.is_add as is_add,p.is_edit as is_edit,p.is_delete as is_delete,p.is_validate as is_validate');
		$dynamicdb->from('sub_module sm');
		$dynamicdb->join('permissions p', 'sm.id = p.sub_module_id and p.user_id="'.$id.'"','left');
		$query = $dynamicdb->get(); 			
		$result = $query->result();	
		return $result;
	}
	

	public function change_status($id, $status) {
		$this->db->where('id', $id);
		$status = array('status' => $status);
		$this->db->update('user', $status );
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $id);
		$dynamicdb->update('user', $status );
		return true;
	}	
	
	public function change_password($id, $password) {
		$this->db->where('id', $id);
		$password = array('password' => $password);
		$this->db->update('user', $password );
		$dynamicdb = $this->load->database('dynamicdb', TRUE);			
		$dynamicdb->update('user', $password);
		return true;
	}	
	
	
	# get group permission by group Id
	function fetch_user_premissions_by_id($id , $where = array()){		
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('sm.sub_module_name as sub_module_name,sm.id as sub_module_id,p.id ,p.is_all as is_all,p.is_view as is_view,p.is_add as is_add,p.is_edit as is_edit,p.is_delete as is_delete,p.is_validate as is_validate');
		$dynamicdb->from('sub_module sm');
		$dynamicdb->join('permissions p', 'sm.id = p.sub_module_id and p.user_id="'.$id.'"','left');
		$dynamicdb->where($where);
		$query = $dynamicdb->get(); 			
		$result = $query->result();	
		return $result;
	}
	
	
	function fetch_user_activity_log($start,$limit, $id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('*'); 
		$dynamicdb->from('activity_log');
		$dynamicdb->where('userid',$id);
		$dynamicdb->order_by("id", "DESC");
		$dynamicdb->limit($limit, $start);	
		$qry = $dynamicdb->get();			
		$result = $qry->result_array();	
		return $result;
	}
	
	
	function fetch_country()
 {
  $this->db->order_by("country_name", "ASC");
  $query = $this->db->get("country");
  return $query->result();
 }

 function fetch_state($country_id)
 {
  $this->db->where('country_id', $country_id);
  $this->db->order_by('state_name', 'ASC');
  $query = $this->db->get('state');
  $output = '<option value="">Select State</option>';
  foreach($query->result() as $row)
  {
   $output .= '<option value="'.$row->state_id.'">'.$row->state_name.'</option>';
  }
  return $output;
 }

	function fetch_city($state_id){
		$this->db->where('state_id', $state_id);
		$this->db->order_by('city_name', 'ASC');
		$query = $this->db->get('city');
		$output = '<option value="">Select City</option>';
		foreach($query->result() as $row){
			$output .= '<option value="'.$row->city_id.'">'.$row->city_name.'</option>';
		}
		return $output;
	}
	
	
	function updateUserProfile($table,$db_data,$field,$id) {		
		$this->db->where($field, $id);
		$result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->update($table, $db_data);
		return true;
	}
}