<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Account_api_model extends ERP_Model {
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
		public function get_legers_dtl($table = '' , $created_id,$config_app) {
			$dynamicdb = $this->load->database($config_app, TRUE);	
			$this->tablename = $table?$table:$this->tablename;
			$dynamicdb->select('*'); 
			$dynamicdb->from($this->tablename);
			$dynamicdb->where('created_by_cid = 0 OR created_by_cid = "'.$created_id.'"');
			$qry = $dynamicdb->get();
			$result = $qry->result();			
			return $result;
		}
		public function get_leger_dtl($table = '' , $created_id,$config_app,$ledger_id) {
			$dynamicdb = $this->load->database($config_app, TRUE);	
			$this->tablename = $table?$table:$this->tablename;
			$dynamicdb->select('*'); 
			$dynamicdb->from($this->tablename);
			$dynamicdb->where('created_by_cid = "'.$created_id.'"');
			$dynamicdb->where('id = "'.$ledger_id.'"');
			
			$qry = $dynamicdb->get();
			//echo $dynamicdb->last_query();die();
			$result = $qry->result();			
			return $result;
		}
		public function get_termconditions_details($table ,$field, $id,$config_app) {
			$dynamicdb = $this->load->database($config_app, TRUE);	
			$dynamicdb->select('*');  
			$dynamicdb->from($table);
			//$this->db->where($table.'.'.$field, $id);
			$dynamicdb->where($field, $id );
			$qry = $dynamicdb->get();
			//echo $dynamicdb->last_query();die();
			$result = $qry->row();	
			return $result;
		}
		public function get_ladger_account_Data2($table,$where_details,$config_app){
			$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->select('*'); 
			$dynamicdb->from($table);
			$dynamicdb->where($where_details);
			$dynamicdb->where('cancel_restore','1');
			//$dynamicdb->order_by('DATE_FORMAT(transaction_dtl.add_date, "%Y" "%m") = 04 DESC');
			$dynamicdb->order_by('date_format(transaction_dtl.add_date,  "%Y-%m-%d") ASC');
			$qry = $dynamicdb->get();
			//echo $dynamicdb->last_query();
			$result = $qry->result();
			return $result;
		}
		
		public function getNameById_using_modal($table='',$id='',$field='',$config_app){
			// $qry="select * from $table where $field='$id'";
			// $CI =& get_instance();
			// $dynamicdb = $CI->load->database('dynamicdb', TRUE);
			// $qryy = $dynamicdb->query($qry);	
			// $result = $qryy->row();	
			// return $result;
			$dynamicdb = $this->load->database($config_app, TRUE);
            $query = $dynamicdb->query("select * from $table where $field='$id'");
			return $query->row();			
		}
		
		public function get_data($table = '' , $where = array(),$config_app) {
			$dynamicdb = $this->load->database($config_app, TRUE);
			$this->tablename = $table?$table:$this->tablename;
			$dynamicdb->select('*'); 
			$dynamicdb->from($this->tablename);
			$dynamicdb->where($where);
			
			$qry = $dynamicdb->get();
			#echo $dynamicdb->last_query();
			$result = $qry->result_array();			
			return $result;
	}
}//Main		