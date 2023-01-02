<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends ERP_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tablename = 'leads';
		$this->proTable   = 'products';
        $this->transTable = 'payments';
        //$this->column_search = array('name');
    }  
	
	
	/* database field columns */
	public function get_field_type_data($data, $table){
		switch($table){
			case 'rfq':				
				$all_fields = array('contacts','email','mobile','products','quantity','uom');
				break;
			case 'leads':				
				$all_fields = array('contacts','products','quantity','uom');
				break;
			case 'reviews':				
				$all_fields = array('created_by_cid','comments','rating','material_id');
				break;
		}
		return $data = format_data_to_be_added($all_fields, $data);
	}
	
	 /* Function to fetch Data */
	/*public function get_data($table = '' , $where = array()) {
		$table = $table?$table:$this->tablename;
		$this->db->select('*'); 
		$this->db->from($table);
		$this->db->where($where);	
		if($table == 'material')		
		$this->db->order_by('id', "RANDOM");		
		//$this->db->order_by('created_date', "desc");	
		
		$qry = $this->db->get();	
	
		$result = $qry->result_array();		
		return $result;
	}*/
	public function get_data($table = '' , $where = array(),$saleType = '',$landingPage= '') {
		$table = $table?$table:$this->tablename;
		$this->db->select('*'); 
		$this->db->from($table);
		$this->db->where($where);	
		if($table == 'material'){
			if($saleType == 'saleMaterial')
			$this->db->or_where('sale_purchase' , '["Sale","Purchase"]' );
			$this->db->where('created_by_cid !=' , 1 );
			$this->db->order_by('id', "RANDOM");	
			if($landingPage !='') $this->db->limit(10);			
		//$this->db->order_by('created_date', "desc");
		}
		$this->db->order_by('created_date', "desc");	
		#$this->db->limit(3);
		$qry = $this->db->get();
		$result = $qry->result_array();		
		return $result;
	}
	
	public function get_Top_Selling_data($table = '' , $where = array()) {
		$table = $table?$table:$this->tablename;
		if($table == 'material'){		
		$this->db->select($table.'.*,material.id  , AVG(reviews.rating) AS rating_average');
		$this->db->from($table);
		$this->db->join("reviews", $table . ".id = reviews.material_id", 'left');
		}
		$this->db->group_by('reviews.material_id');	
		$this->db->order_by('rating_average', "desc");	
		$qry = $this->db->get();
//pre($this->db->last_query());die;		
		$result = $qry->result_array();		
		return $result;
	}
	
	
	
	
	public function topSellingMaterial() {
		$this->db->select('material.* , COUNT(*) as reviewCount');
		$this->db->from('reviews as rev');
		$this->db->join("material", "rev.material_id = material.id", 'left');
		$this->db->where('material.status',1);
		$this->db->group_by('rev.material_id');	
		$this->db->order_by('reviewCount', "desc");	
		$qry = $this->db->get();	
		$result = $qry->result_array();		
		return $result;
	}
	
	
	
	  /* Insert Data */
	public function insert_tbl_data($table,$data) {
		$fieldData = $this->get_field_type_data($data,$table);
		$this->db->insert($table,$fieldData);
		$insertedid = $this->db->insert_id();	
		return $insertedid; 
		}
		

	
	public function getCompanyEmailsRelatedToMaterial($table , $material = '' , $where = array()){
		$this->db->select('*');  
		$this->db->from($table);
		#$this->db->where($table.'.'.$field, $id);
		$this->db->like('material_name', $material);
		$this->db->where($where);	
		$qry = $this->db->get();
		$result = $qry->result_array();	
		return $result;
	}
	
	/*  Search like function */
	public function getSearchRelatedData($table , $like = array() , $where = array(),$saleType = ''){
		$this->db->select('*');  
		$this->db->from($table);
		#$this->db->where($table.'.'.$field, $id);
		//$this->db->like('material_name', $material);
		$this->db->like($like);
		$this->db->where($where);	
		if($saleType == 'saleMaterial')
			$this->db->or_where('sale_purchase' , '["Sale","Purchase"]' );
		$qry = $this->db->get();
		$result = $qry->result_array();			
		return $result;
	}
	
	/* Function to fetch Data by Id */
	public function get_data_by_key($table ,$field, $fieldValue) {
		$this->db->select('*');    
		$this->db->from($table);
		$this->db->where($table.'.'.$field, $fieldValue);
		$qry = $this->db->get();			
		$result = $qry->row();	
		return $result;
	}
	
	/*function to ftech iamge by id*/
	//public function get_attachment_by_id($table ,$field, $id) {
	public function get_attachment_by_id($table ,$where = array()) {
		$this->db->select('*');    
		$this->db->from($table);
		//$this->db->where($field, $id);
		//$this->db->where('rel_type', 'material');
		$this->db->where($where);
		
		$qry = $this->db->get();

		$result = $qry->result_array();	
		return $result;
	}
	
	public function get_material_attachment_by_id($table ,$field  ,$data) {
		$query = $this->db->query("select featured_image from material where id = '".$field."' UNION select file_name from attachments where rel_id='".$field."' AND rel_type='".$data."'");
		return $query->result_array();
	}
		/*$this->db->select('*');    
		$this->db->from($table);
		//$this->db->where($field, $id);
		//$this->db->where('rel_type', 'material');
		$this->db->where($where);
		$qry = $this->db->get();

	
		$result = $qry->result_array();	*/
	
	
	
	
	
	/*get count of reviews */
	public function getReviewRating($table ,$where = array()){
		$this->db->select('count(comments) as Review');    
		$this->db->from($table);
		$this->db->where($where);
		$qry = $this->db->get();
		$result = $qry->result_array();	
		return $result;
	}
	
	
	
	public function fetch_data_records($tablename, $limit, $start ,$field) {        
            $this->load->database();
           $start = ($start-1) * $limit;  
		
           $this->db->limit($limit, $start);        
            
            $this->db->select('*');
            $this->db->from($tablename);
            $this->db->where('material_id',$field);
			
            $this->db->order_by('created_date','DESC');
            $query = $this->db->get();
			//echo $this->db->last_query();die();
            $this->db->reset_query();
            if ($query->num_rows() > 0) {
                
               foreach ($query->result() as $row) {
                   $data[] = $row;
				 
               }
               return $data;
            }
            return false;

        } 
	/*public function fetch_data_records($tablename,$field) {        
            $this->load->database();
           $start = ($start-1) * $limit;  
		
           $this->db->limit($limit, $start);        
            
            $this->db->select('*');
            $this->db->from($tablename);
            $this->db->where('material_id',$field);
			
            $this->db->order_by('created_date','DESC');
            $query = $this->db->get();
			//echo $this->db->last_query();die();
            $this->db->reset_query();
            if ($query->num_rows() > 0) {
                
               foreach ($query->result() as $row) {
                   $data[] = $row;
				 
               }
               return $data;
            }
            return false;

        }*/
	public function manage_users_Data(){
             $this->load->database();
             $this->db->select('*');
             $this->db->from('reviews');
             $data = $this->db->get();
             return $data->result_array();
    }
    
	
	
	/*
     * Insert data in the database
     * @param data array
     */
    public function insertTransaction($data){
        $insert = $this->db->insert($this->transTable,$data);
        return $insert?true:false;
    }
	
	
	  /*
     * Fetch products data from the database
     * @param id returns a single record if specified, otherwise all records
     */
    public function getRows($id = ''){
        $this->db->select('*');
        $this->db->from($this->proTable);
        $this->db->where('status', '1');
        if($id){
            $this->db->where('id', $id);
            $query  = $this->db->get();
            $result = $query->row_array();
        }else{
            $this->db->order_by('name', 'asc');
            $query  = $this->db->get();
            $result = $query->result_array();
        }
        
        // return fetched data
        return !empty($result)?$result:false;
    }
    
    
	
}