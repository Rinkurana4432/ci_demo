<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Dailyreport_inventory_model extends CI_Model {
    public function __construct() {
         parent::__construct();
       // $this->load->database();
       // $this->tablename = 'material';
        //$this->column_search = array('name');
        #$this->companyId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
    }

	public function get_mat_spec_column($config_app, $table = '' , $where = array() , $column_name, $limit ='') {
		$dynamicdb = $this->load->database($config_app, TRUE);
		$dynamicdb->select($column_name);
		$dynamicdb->from($table);
		$dynamicdb->where($where);	
		$qry = $dynamicdb->get();
		
		$result = array();
		if($qry !== FALSE && $qry->num_rows() > 0){
			$result = $qry->result_array();
		}
		return $result;		
	}

    public function get_data($config_app, $table = '' , $where = array() , $limit ='') {	
			$dynamicdb = $this->load->database($config_app, TRUE);			
			$table = $table?$table:$this->tablename;
			if($table=="material" || $table == 'inventory_flow' || $table=='daily_report_setting'){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}else if($table=="supplier"){
					$dynamicdb->select($table.'.*,'.$table.'.id as supplier_id,material.material_name as material_name');  
					$dynamicdb->from($table);		
					$dynamicdb->join("material", $table . ".material_name_id = material.id", 'left');
					$dynamicdb->order_by('supplier_id','DESC');	
			}
			else{
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}
			$dynamicdb->where($where);
			$qry = $dynamicdb->get();
			//echo $dynamicdb->last_query();
			$result = array();
			if($qry !== FALSE && $qry->num_rows() > 0){
				$result = $qry->result_array();
			}
			 if($table=="permissions"){
				$tempArr = array_unique(array_column($result, 'user_id'));
				$result = array_intersect_key($result, $tempArr);				
			}

			return $result;
	}

	public function getDatabycheckid($config_app,$table, $where,$orderBy='', $limit ){
		//if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
			$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->where($where);
			if($orderBy){
		    	$dynamicdb->order_by($orderBy);
        	}
        	if($limit){
			    $dynamicdb->limit($limit);
        	}
		   $qry = $dynamicdb->get();
	  /*  } else {
		   $dynamicdb = $this->load->database('dynamicdb', TRUE);
		   $dynamicdb->select('*');
		   $dynamicdb->from($table);
		   $dynamicdb->where($where);
		   $qry = $dynamicdb->get();
	   } */
	    //echo $dynamicdb->last_query();
	   // die;
	   $result = $qry->row_array();
	   return $result;
	   
   }	
	
	public function get_data1($config_app,$table = '' , $where = array() , $limit ='') {	
			$dynamicdb = $this->load->database($config_app, TRUE);			
			$table = $table?$table:$this->tablename;
			if($table=="material" || $table == 'inventory_flow' || $table=='daily_report_setting'){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}else if($table=="supplier"){
					$dynamicdb->select($table.'.*,'.$table.'.id as supplier_id,material.material_name as material_name');  
					$dynamicdb->from($table);		
					$dynamicdb->join("material", $table . ".material_name_id = material.id", 'left');
					$dynamicdb->order_by('supplier_id','DESC');	
			}
			else{
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}
			$dynamicdb->where($where);
			$qry = $dynamicdb->get();
		#	echo $dynamicdb->last_query();
			$result = array();
			if($qry !== FALSE && $qry->num_rows() > 0){
				$result = $qry->result_array();
			}
			 if($table=="permissions"){
				$tempArr = array_unique(array_column($result, 'user_id'));
				$result = array_intersect_key($result, $tempArr);				
			}

			return $result;
	}

	public function get_data_dynamic($table = '' , $where = array() , $config_app) {	
			$dynamicdb = $this->load->database($config_app, TRUE);		
			$dynamicdb->select('*'); 
			$dynamicdb->from($table);
			$dynamicdb->where($where);
			$qry = $dynamicdb->get();
			$result = $qry->result();	
			#echo $dynamicdb->last_query();
			return $result;
	}	

		 public function get_task_list($config_app,$table,$where=array()){
	 		$dynamicdb = $this->load->database($config_app, TRUE);			
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->where($where);
			$qry = $dynamicdb->get();
			$result = $qry->result();
           // echo $dynamicdb->last_query();
            return $result;
    }
	

     public function insert_tbl_data($config_app,$table, $data) {//pre($data);die;
        $dynamicdb = $this->load->database($config_app, TRUE);     
        $dynamicdb->insert($table, $data);
        // echo $dynamicdb->last_query();die();
        $this->db->insert($table, $data);
        $userInsertedid = $this->db->insert_id();
        return $userInsertedid;
    }

}