<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Quality_control_model extends ERP_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
    }  
	
	public function get_field_type_data($data, $table){
		switch($table){
			case 'quality_control':				
				$all_fields = array('report_name','observations','per_lot_of','uom','type','at','report_for','created_by','created_by_cid');
				break;	
			case 'quality_control_trans':
				    $all_fields=array('sno','parameter','instrument','expectation','deviation_min','deviation_max','exp_min_dev','exp_max_dev','report_id');
		        break;
			case 'controlled_report_master':				
				$all_fields = array('report_name','observations','per_lot_of','uom','saleorder','material_id','quantity_info','created_date','created_by','created_by_cid','final_report');
				break;
			case 'instrument':				
				$all_fields = array('name','ins_range','upper_range','range_uom','least_count','least_uom','date_of_purchase','last_calibrated_on','calibration_due_date','ins_assign_to','calibration_certificate','created_by','created_by_cid');
				break;
		    case 'job_position':				
				$all_fields = array('designation','department','recruitment_responsible','website','location','expected_new_employee','hr_responsible','job_description','created_by','created_by_cid');
				break;
		    case 'job_application':				
				$all_fields = array('name','email','phone_no','short_intro','resume_upload','job_position_id','reference','exp_salary','created_by','created_by_cid','status');
				break;
			case 'hrm_terms':
			    $all_fields = array('title','terms_cond','created_date');
			    break;
			case 'register_complaint':
	            $all_fields = array('cust_id','auto_cust_id','email','saleorder_id','product_id','complaint_date','lot_size','complaint_priority','problem','status','cause','approve','disapprove','disapprove_reason','validated_by','created_by_cid');
			    break; 
			case 'finish_goods':
                $all_fields = array('job_card_detail', 'scrap_qty', 'material_scrap_id','acknowledge_date','aknowlwdge_by', 'created_by_cid', 'created_by');
            break;
			    }
		return $data = format_data_to_be_added($all_fields, $data);
	}
		/*********************************** report***************************/
	public function get_data($tablename,$val){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb ->select('*');    
		$dynamicdb ->from($tablename);
		if($val=='quality_control')
		{
		$dynamicdb ->where('created_by_cid',$this->companyGroupId);
		}
		if($val=='id'){
			$dynamicdb ->order_by($val,"desc");
		}
		$qry = $dynamicdb->get();
		if($val =='saleorder'||$val=='report_status'||$tablename='grn_quality_status')
		{
		   $result = $qry->result_array();	
		}else
		{
		    $result = $qry->result();	
		}
//echo $dynamicdb->last_query();//die();
		return $result;
	}
		
	public function get_report_data()	{
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb ->select('*');    
		$dynamicdb ->from('quality_control');
		$dynamicdb ->where('quality_control.created_by_cid',$this->companyGroupId);
		$dynamicdb ->group_by('quality_control.id');
		$dynamicdb ->order_by('id','desc');
		$qry = $dynamicdb ->get();
		$result = $qry->result();	
//echo $dynamicdb->last_query();die();
		return $result;
		}
		
		public function get_table_field($table,$field,$id){
		    $dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*');  
			$dynamicdb->from($table);
			$dynamicdb->where($field, $id);
			//$dynamicdb->order_by($id);
			$qry = $dynamicdb->get();
		    $result = $qry->result();
		   //echo $dynamicdb->last_query();
		    /*if($table=='quality_control_trans'&&$field=='report_id')
		    {
		        echo json_encode($result);
		    }else{
				return $result;
		    }*/

		    return $result;

		}

		public function get_table_quality($table ,$where)	{
		    $dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*');  
			$dynamicdb->from($table);
			$dynamicdb->where($where);
		//	$dynamicdb->order_by($id,'asc');
			$qry = $dynamicdb->get();
		    // echo $dynamicdb->last_query();die();
			  if ($qry->num_rows()==1) {
			  $result = $qry->row_array();
			 }else{
			 	$result = $qry->result_array();
			 }
				
				return $result;
		}
			public function get_table_field_array($table ,$field, $id)	{
		    $dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*');  
			$dynamicdb->from($table);
			$dynamicdb->where($field, $id);
		//	$dynamicdb->order_by($id,'asc');
			$qry = $dynamicdb->get();
		    // echo $dynamicdb->last_query();die();
			  if ($qry->num_rows()==1) {
			  $result = $qry->row_array();
			 }else if ($qry->num_rows() > 1){
			 	 $result = $qry->result_array();
			 }
				
		return $result;
		}
		
		public function get_data_byId($table ,$field, $id) {
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*');  
			$dynamicdb->from($table);
			$dynamicdb->where($table.'.'.$field, $id);
			$qry = $dynamicdb->get();
		$result = $qry->row();	
		return $result;
	}
	
		public function get_material_name($id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('material.*');    
		$dynamicdb->from('material_type,material');
		$dynamicdb->where('material.material_type_id=material_type.id');
		$dynamicdb->where('material_type.id',$id);
		$qry = $dynamicdb->get();
		$result = $qry->result();	
//echo $this->db->last_query();die();
		echo json_encode($result);
		}
		
	public function get_process_type($id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('process_type.*');    
		$dynamicdb->from('process_type,job_card');
		$dynamicdb->where('job_card.process_type=process_type.id');
		$dynamicdb->where('job_card.id',$id);
		$dynamicdb->where('process_type.created_by_cid',$this->companyGroupId);
		$qry = $dynamicdb->get();
		$result = $qry->result();	
//echo $this->db->last_query();die();
		echo json_encode($result);
		}
		
		public function update_data($tablename,$data,$field,$id){
		$this->db->where($field, $id);		
		$this->db->update($tablename, $data);
		//echo $this->db->last_query();die();
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field,$id);
		$dynamicdb->update($tablename,$data);
		return true;
		}
	//approve ncr data
	public function approve_ncr_data($data) {
			$this->db->where('id', $data['id']);		
			$approveData = array('approve' => $data['approve'],'validated_by' =>  $data['validated_by'] ,'disapprove' => 0 ,'disapprove_reason' => '','status'=>'Close');
			$this->db->update('register_complaint', $approveData );
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('id', $data['id']);	
			$dynamicdb->update('register_complaint', $approveData );	
			return true;
		}	
		
	public function disApprovedata($data) {
		$this->db->where('id', $data['id']);		
		//$approveData = array('approve' => 0,'validated_by' =>  $data['validated_by'] ,'disapprove' => 1, 'disapprove_reason' =>'');
		$this->db->update('register_complaint', $data );
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $data['id']);
		$dynamicdb->update('register_complaint', $data );
//	echo $dynamicdb->last_query();die();	
		return true;
	}
	
	public function delete_data($tablename,$field,$id){
		$this->db->where($field, $id);		
		$this->db->delete($tablename);
		
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field,$id);
		$dynamicdb->delete($tablename);
		}

		public function insert($table,$data) {
		    if($table=='quality_control_trans'||$table=='inspection_report_trans'||$table=='controlled_report_trans')
		    {
		      $this->db->insert($table,$data);
	          $dynamicdb = $this->load->database('dynamicdb', TRUE);
	          $insert=$dynamicdb->insert($table,$data);
		    }else{
		$fieldData = $this->get_field_type_data($data,$table);
		$this->db->insert($table,$fieldData);
	    //echo $this->db->last_query();die();
		$insertedid = $this->db->insert_id();
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$fieldData['id'] =  $insertedid;
		$dynamicdb->insert($table,$fieldData);
		$dynamicdb->insert_id();
	 	return $insertedid; 
		    }
	}

	function insertReport($table,$data){
		$this->db->insert($table,$data);
	    $dynamicdb = $this->load->database('dynamicdb', TRUE);
	    $dynamicdb->insert($table,$data);
	    return $dynamicdb->insert_id();

	}
		
		public function get_row_value1($table,$field,$id){
		    $dynamicdb = $this->load->database('dynamicdb', TRUE);
		    $dynamicdb->select('*');    
			$dynamicdb->from($table);
			$dynamicdb->where($field,$id);
			$qry = $dynamicdb->get();
			 $result = $qry->row();
			 return $result;
		}
		
	public function get_row_value($table,$field,$id){
		    $dynamicdb = $this->load->database('dynamicdb', TRUE);
		    $dynamicdb->select('*');    
			$dynamicdb->from($table);
			$dynamicdb->where($field,$id);
			$qry = $dynamicdb->get();
			if($table=='material')
			{
			   	$result = $qry->row('material_name');  
			} elseif($table=='material_type')
			  {
			          $result = $qry->row('name');
			  } elseif($table=='add_process')
			    {
			          $result = $qry->row('process_name');
			    } elseif($table=='sale_order')
			    {
			          $result = $qry->row('so_order');
			    } elseif($table=='quality_control')
			    {
			          $result = $qry->row('id');
			          return $result;
			    }elseif($table=='inspection_report_trans')
			    {
			          $result = $qry->row('final_report');
					  return $result;
			    }elseif($table=='controlled_report_trans')
			    {
			          $result = $qry->row('final_report');
					  return $result;
			    }else
			   {
	     	$result = $qry->row('workorder_name');	
		      	 }
     //  echo $this->db->last_query();//die();
	    	echo $result;
		}
		
	    public function get_user_name($usrid,$cid){
	        $dynamicdb = $this->load->database('dynamicdb', TRUE);
		   $dynamicdb->select('*');    
		   $dynamicdb->from('user_detail');
		   $dynamicdb->where('c_id',$cid);
		    $dynamicdb->where('u_id',$usrid);
		   $qry = $dynamicdb->get();
	       $result = $qry->row('name');	
      //echo $this->db->last_query();die();
		echo $result;
	    }
	    
			public function get_saleorder($table,$field,$val){
		   $dynamicdb = $this->load->database('dynamicdb', TRUE);
		   $dynamicdb->select('*');    
		   $dynamicdb->from($table);
		   $dynamicdb->where($field,$val);
		   $dynamicdb->order_by('id',"desc");
		   $qry = $dynamicdb->get();
	       $result = $qry->result();	
      //echo $this->db->last_query();die();
		return $result;
		}
		
	public function get_sale_order($table,$field,$id){
		    $dynamicdb = $this->load->database('dynamicdb', TRUE);
		    $dynamicdb->select('*');    
			$dynamicdb->from($table);
			$dynamicdb->where($field,$id);
			$qry = $dynamicdb->get();
	     	$result = $qry->row('product');	
      //echo $this->db->last_query();die();
		$ch=json_decode($result);
		return $ch[0]->product; 
		}
		
	function get_jobcard_product_no(){ 
		    $dynamicdb = $this->load->database('dynamicdb', TRUE);
		    $dynamicdb->select('material_details');    
			$dynamicdb->from('job_card');
			$qry =  $dynamicdb->get();
	     	$result = $qry->result_array();
	     //	echo $result->material_name_id;
	     return $result;
	}
	
    function get_jobcard_no($product_id){
	    $dynamicdb = $this->load->database('dynamicdb', TRUE);
	    $dynamicdb->select('id,job_card_no');    
		$dynamicdb->from('job_card');
		$dynamicdb->like('material_details', '"material_name_id":"'.$product_id.'"', 'both'); 
		$dynamicdb->group_by('job_card_no');
		$qry = $dynamicdb->get();
		//	echo $this->db->last_query();die();
	    $result = $qry->result();
	   return json_encode($result);
	}
		
	function get_jobcard_table_data($table,$field,$job_id,$field1,$process_id){
	 $dynamicdb = $this->load->database('dynamicdb', TRUE);
	 $dynamicdb->select('*');    
	 $dynamicdb->from($table);
	 $dynamicdb->where($field,$job_id);
	 $dynamicdb->where($field1,$process_id);
	 $qry = $dynamicdb->get();
	 $result = $qry->row('id');
	//echo $dynamicdb->last_query();die();
	 return $result;
		}	
	function get_grn_material($id){   
	$dynamicdb = $this->load->database('dynamicdb', TRUE);
	$dynamicdb->select('material.*');
	$dynamicdb->from('material,mrn_detail');
	$dynamicdb->where('material.id',$id);
	$dynamicdb->where("material.id like
 '%'||mrn_detail.material_name||'%'");
 $dynamicdb->group_by("material.id");
	$qry = $dynamicdb->get();
	//	echo $dynamicdb->last_query();die();
	$result = $qry->result();
	 return $result;
	}
	
	function get_material_qty($table,$field,$id){   
	$dynamicdb = $this->load->database('dynamicdb', TRUE);
	$dynamicdb->select('*');
	$dynamicdb->from($table);
	$dynamicdb->where($field." like '%".$id."%'");
 $dynamicdb->group_by($field);
	$qry = $dynamicdb->get();
	//	echo $dynamicdb->last_query();die();
	$result = $qry->result();
	 return $result;
	}
	
	function get_sale_products(){   
	$dynamicdb = $this->load->database('dynamicdb', TRUE);
	$dynamicdb->select('material.id,material.material_name,sale_order.product');
	$dynamicdb->from('sale_order');
	$dynamicdb->join('material',"material.id like
 '%'||sale_order.product||'%'");
	$dynamicdb->group_by('material_name');
	$qry = $dynamicdb->get();
	//	echo $dynamicdb->last_query();die();
	$result = $qry->result();
	echo json_encode($result);
		}
	/*** get sale order report**/
	function get_saleorder_report($id){
	    $dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('inspection_report_master.*');
    	$dynamicdb->from('inspection_report_master,work_order');
    	$dynamicdb->where('inspection_report_master.workorder_id',$id);
    	//$dynamicdb->group_by('inspection_report_master.report_name');
        $query = $dynamicdb->get();
        $result = $query->result();
        return $result;
	}
	function get_report_status($table,$id){
	    $dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
    	$dynamicdb->from($table);
    	$dynamicdb->where('final_report',$id);
      //  $dynamicdb->group_by('report_name');
        $query = $dynamicdb->get();
       //echo $dynamicdb->last_query();die();
        $result = $query->result_array();
        return $result;
	}
	
	function get_quality_status($table,$where){
		 $dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
    	$dynamicdb->from($table);
    	$dynamicdb->where($where);
        $query = $dynamicdb->get();
      // echo $dynamicdb->last_query();//die();
        $result = $query->result_array();
        return $result;
	}
	
	
/*PipeLine change status fucntion*/
	public function change_process_status($table,$data, $id) {	
	  // print_r($data);die();
		$data = array( 
					'final_report' => $_POST['processTypeId']
				);	
		$this->db->where('id', $_POST['processId']);	
		$this->db->update($table, $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->where('id', $_POST['processId']);	
		$dynamicdb->update($table, $data);
		return true;	
	}
/*PipeLine change  order fucntion*/
   public function change_process_order($table,$orders){
		foreach ($orders as $order) {
            $id = $order['id'];
                if ($order['id'] == $id) {					
					$data =  array('order_id' => $order['position']);	
					$this->db->where('id', $id);
					$this->db->update($table, $data);
					$dynamicdb = $this->load->database('dynamicdb', TRUE);
					$data =  array('order_id' => $order['position']);	
					$dynamicdb->where('id', $id);
					$dynamicdb->update($table,$data);			
				}
			}
		}
	public function get_count($table){
	     $dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('count(*) as count');
    	$dynamicdb->from($table);
        $query = $dynamicdb->get();
       //echo $dynamicdb->last_query();die();
        $result = $query->row('count');
        return $result;
		}
    //hrm 
        public function get_data1($table = '' , $where = array(), $limit = '') {	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*'); 
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		if($table=='job_position'||'controlled_report_master')
		$dynamicdb->order_by('id',"desc");
	    $qry =$dynamicdb->get();
		//echo $dynamicdb->last_query();	
		$result = $qry->result_array();	
		return $result;
		}
		public function get_element_by_id($table,$field,$id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*'); 
		$dynamicdb->from($table);
		$dynamicdb->where($field,$id);
	    $qry =$dynamicdb->get();	
		$result = $qry->row();	
		return $result;
		}
		public function get_list($table){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*'); 
		$dynamicdb->from($table);
	    $qry =$dynamicdb->get();	
		$result = $qry->result();	
		return $result;
		}
		function get_status($table,$id){
	    $dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
    	$dynamicdb->from($table);
    	$dynamicdb->where('status',$id);
        $query = $dynamicdb->get();
        $result = $query->result_array();
        return $result;
	}
		function get_status_job($table,$id,$job_position_id){
	    $dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
    	$dynamicdb->from($table);
    	$dynamicdb->where('status',$id);
        $dynamicdb->where('job_position_id',$job_position_id);
        $query = $dynamicdb->get();
        $result = $query->result_array();
        return $result;
	}
	/*PipeLine change status function*/
	public function change_process_status1($table,$data, $id) {	
	  // print_r($data);die();
		$data = array( 
					'status' => $_POST['processTypeId']
				);	
		$this->db->where('id', $_POST['processId']);	
		$this->db->update($table, $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->where('id', $_POST['processId']);	
		$dynamicdb->update($table, $data);
		return true;	
	}
public function get_name($table,$name,$val){
	  $dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
    	$dynamicdb->from($table);
    	$dynamicdb->where('name',$name);
        $query = $dynamicdb->get();
        $result = $query->row($val);
        echo $result;
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
		# Save user permissions
	public function save_user_permissions($data){
		$this->db->insert('permissions',$data);
		$id = $this->db->insert_id();
		$dynamicdb = $this->load->database('dynamicdb', TRUE);			
		$dynamicUserInsertedid = $dynamicdb->insert('permissions',$data);
		return $id;
	}
	public function chk_usr($table,$field,$val){
	  $dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('count(*) as count');
    	$dynamicdb->from($table);
    	$dynamicdb->where($field,$val);
        $query = $dynamicdb->get();
        $result = $query->row('count');
		//pre($result);
		return $result;
	}

	function rowExist($table,$where){
	    $dynamicdb = $this->load->database('dynamicdb', TRUE);
		return $dynamicdb->where($where)->get($table)->num_rows();
	}

	public function getReportByType($where,$table = ""){
		if( empty($table) ){
			$table = 'quality_control';
		}
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb ->select('*');    
		$dynamicdb ->from($table);
		$dynamicdb ->where($where);
		$dynamicdb ->order_by('id','desc');
		$qry = $dynamicdb->get();
		$result = $qry->result();	
		return $result;
	}


public function twoJoinTables($numRows = fasle,$select,$table1,$table2,$table2Join,$where,$orderBy = "",$start ="",$limit = ""){
    	$dynamicdb = $this->load->database('dynamicdb', TRUE);
    	if( $start ){
    		$start = ($start - 1) * $limit;
    	}
    	$sql = "SELECT $select FROM $table1 LEFT JOIN $table2 ON $table2Join WHERE $where ";
    	if( $orderBy ){
    		$sql .= " ORDER BY $orderBy";
    	}
   		if( $numRows != true && !empty($limit) ){
    		$sql .= " LIMIT $start,$limit ";
   		}
		$result =  $dynamicdb->query($sql);
		if( !$numRows ){
		 return	$result->result_array();
		}else{
	     return $result->num_rows();
		}
    }

    function getColumnValue($select,$where,$table){
    	$dynamicdb = $this->load->database('dynamicdb', TRUE);
    	$data = $dynamicdb->select($select)->where($where)->get($table)->row_array();
    	return $data[$select];

    }

   	public function insertAllData($table,$data) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->db->insert($table,$data);
		$insertId  = $this->db->insert_id();
		if( $insertId ){
			$dynamicdb->insert($table,$data);
			return $dynamicdb->insert_id();

		}
	}

	public function updateWhereData($table,$where,$data){
		$this->db->where($where);		
		$this->db->update($table, $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($where);
		$dynamicdb->update($table,$data);
		//echo $dynamicdb->last_query();
		return $dynamicdb->affected_rows();
	}
	
		public function delete_row($table ,$data) {	
		$this->db->delete($table,$data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->delete($table,$data);
		return $dynamicdb->affected_rows();
	}

	function getDataByWhere($table,$where,$order = [],$select = ""){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
			
			$sql = $dynamicdb;
			if( $select ){
				$sql = $dynamicdb->select($select);
			}
			$sql = $sql->where($where);
			if( $order ){
				$sql = $sql->order_by(implode(' ', $order));
			}
		return $sql->get($table)->result_array();
	}

	function getRowByWhere($table,$where,$select = []){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$sql = $dynamicdb;
		if( $select ){
			$sql = $dynamicdb->select($select);
		}
		$sql = $sql->where($where);
		return $sql->get($table)->row_array();

	}

	function insertAllDetails($table,$where){
		$this->db->insert($table,$where);
		$insertId = $this->db->insert_id();
		if( $insertId ){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->insert($table,$where);
			return $dynamicdb->insert_id();

		}
	}

	function limitedData($table,$where,$order = [],$select = "",$start="",$limit=""){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$sql = $dynamicdb;
			if( $select ){
				$sql = $dynamicdb->select($select);
			}
			$sql = $sql->where($where);
			if( $order ){
				$sql = $sql->order_by(implode(' ', $order));
			}

			if ($limit != '' && $start != '') {
				$start = ($start - 1 ) * $limit;
       			$sql = $sql->limit($limit, $start);
    		}
			return $sql->get($table)->result_array();		
	}

    function joinTables($select,$firstTable,array $joinData,$where,$order = [],$limitData = [],$groupBy=""){

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$sql = $dynamicdb->select($select)->from($firstTable);

		if( $joinData ){
			foreach ($joinData as $tableName => $joinClause) {
				$sql = $sql->join($tableName,$joinClause,'left');
			}
		}
		$sql = $sql->where($where);

		if( $groupBy ){
			$sql = $sql->group_by($groupBy);
		}

		if( $order ){
			$sql = $sql->order_by($order[0],$order[1]);
		}
		if( $limitData ){
			$limt = $limitData[0];
			$start = ($limitData[1] - 1) * 10;
			$sql = $sql->limit($limit, $start);
		}
		return $sql->get()->result_array();
	}

  public function get_worker_data($table,$where ) {
         
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql ="SELECT * FROM {$table} WHERE {$where}";
        $query = $dynamicdb->query($sql);
       //echo $dynamicdb->last_query(); die;
        return $query->result_array();
    }


}//main