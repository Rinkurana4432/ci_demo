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
				$all_fields = array('machine_name','breakdown_couses','machine_type','priority');
				break;
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

}