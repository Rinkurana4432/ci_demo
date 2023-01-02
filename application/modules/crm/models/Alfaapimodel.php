<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Alfaapimodel extends ERP_Model {
         function __construct() {
         parent::__construct();
         $this->load->helper('url');
		 $this->load->database();
		 error_reporting(0);
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
			case 'sale_order':
				$all_fields = array('sale_order_priority', 'so_order','party_state_id', 'company_unit', 'account_id', 'contact_id', 'tender_id', 'party_ref', 'order_date', 'material_type_id', 'product', 'total', 'grandTotal', 'dispatch_date', 'production_dispatch_date', 'dispatch_product', 'dispatch_type', 'dispatched_date', 'gst', 'agt', 'freight', 'payment_terms', 'payment_date', 'payment_status', 'advance_received', 'cash_discount', 'discount_offered', 'label_printing_express', 'brand_label', 'dispatch_documents', 'product_application', 'guarantee', 'convrtd_frm_quot_to_pi', 'convrtd_frm_quot_to_so', 'created_by', 'created_by_cid', 'approve', 'approve_date','pending_so','counter_offer','speacial_so', 'disapprove', 'disapprove_reason', 'save_status', 'salesperson', 'favourite_sts', 'validated_by', 'complete_status', 'partially_complete_status', 'completed_by','resone_code','comments','reasone_comment');
				break;
			case 'account':
			$all_fields = array('account_owner','name','phone','fax','parent_account','website','type','route_id','employee','industry','revenue','description','billing_street','billing_city','billing_zipcode','billing_state','pan','billing_country','shipping_street','shipping_city','shipping_zipcode','shipping_state','shipping_country','new_billing_address','new_shipping_address', 'type_of_customer', 'contact_name', 'gstin','email','created_by','edited_by','save_status','purchaseLimit','temp_credit_limit','temp_crlimitDate','due_days', 'api_data','sales_area');
				//$all_fields = array('account_owner','name','phone','fax','parent_account','website','type','route_id','employee','industry','revenue','description','billing_street','billing_city','billing_zipcode','billing_state','pan','billing_country','shipping_street','shipping_city','shipping_zipcode','shipping_state','shipping_country','gstin','email','created_by','edited_by','save_status','salesPersons','purchaseLimit','temp_credit_limit','temp_crlimitDate','due_days','salesPersons','areastation','ledger_id','limit_type','credit_limit','days_limit','per_credit_limit','per_days_limit','password','status','otp','device_Token');
				break;
			case 'ledger':
				$all_fields = array('name','account_group_id','mailing_address','contact_person','phone_no','mobile_no','email','website','registration_type','gstin','pan','created_by','edited_by','parent_group_id','conn_comp_id','created_by_cid','compny_branch_id','save_status','opening_balance','new_billing_address','type_of_customer','contact_name');
				break;
			case 'proforma_invoice': 
				$all_fields = array('pi_code','account_id', 'order_date', 'product', 'dispatch_date', 'freight', 'payment_terms', 'advance_received', 'cash_discount', 'discount_offered', 'label_printing_express', 'brand_label', 'dispatch_documents', 'product_application', 'guarantee','created_by','created_by_cid','total','grandTotal','save_status','load_type','party_ref','material_type_id','freightCharges','discount_rate','pi_cbf','pi_weight','pi_paymode','pi_permitted','special_discount','pi_remarks','apply_comment','special_discount_authorized');
				break;
			case 'pi_comment_log':
				$all_fields = array('apply_comment','date','userid','rel_id','rel_type');
				break;		
		}

		return $data = format_data_to_be_added($all_fields, $data);
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
	public function insert_tbl_data($config_app,$table,$data) {
		$this->db->insert($table,$data);
		$insertedid = $this->db->insert_id();
		$data['id'] = $insertedid;
		$dynamicdb = $this->load->database($config_app, TRUE);
		$dynamicdb->insert($table,$data);
		return $insertedid;
	}

	public function insert_tbl_data_pi($config_app,$table,$data) {
			$fieldData = $this->get_field_type_data($data,$table);
			$this->db->insert($table,$fieldData);
			$insertedid = $this->db->insert_id();				
			$data['id'] = $insertedid;
			$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->insert($table,$fieldData);
			return $insertedid; 
	}

	public function update_single_value_data($config_app,$table,$data,$where) {
		$this->db->where($where);
		$this->db->update($table, $data);
		if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->where($where);
			$dynamicdb->update($table, $data);
		}
		return true;
	}

	public function insert_data($config_app,$table,$data) {
	# pre($data);	pre($config_app);pre($table);die;
		$this->db->insert($table,$data);
		$insertedid = $this->db->insert_id();
		$data['id'] = $insertedid;
		//echo $this->db->last_query();die;
		$dynamicdb = $this->load->database($config_app, TRUE);
		$dynamicdb->insert($table,$data);
		//echo $dynamicdb->last_query();die;
		return $insertedid;
	}

		public function add_balance_amount_or_paid($config_app,$table,$update_data, $invoice_id){
			$this->db->where('id',$invoice_id);
			$this->db->update($table,$update_data);
			$update_rows_data = $this->db->affected_rows();

			 $dynamicdb = $this->load->database($config_app, TRUE);
			 $dynamicdb->where('id',$invoice_id);
			 $dynamicdb->update($table,$update_data);
			 $update_rows_data = $dynamicdb->affected_rows();

			 return $update_rows_data;
		}

	public function update_data($config_app,$table,$data,$field,$id) {
		$this->db->where($field, $id);
		$result = $this->db->update($table, $data);
		$dynamicdb = $this->load->database($config_app, TRUE);
		$dynamicdb->where($field, $id);
		$result = $dynamicdb->update($table, $data);
		//return TRUE;
	}

	public function update_data_pi($config_app,$table,$db_data,$field,$id) {		
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);		
		$result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database($config_app, TRUE);
		$dynamicdb->where($field, $id);
		$result = $dynamicdb->update($table, $db_data);
		return $result;

	}
	public function update_data_customer($config_app,$table,$data,$field,$id) {
		$this->db->where($field, $id);
		$result = $this->db->update($table, $data);
		$dynamicdb = $this->load->database($config_app, TRUE);
		$dynamicdb->where($field, $id);
		$result = $dynamicdb->update($table, $data);
		return $result;
	}

	public function emailExist($email,$name,$phone_no) {
        $this->db->select('*');
        $this->db->from('account');
        $this->db->where('email', $email);
        $this->db->where('name', $name);
        $this->db->where('phone', $phone_no);
        $qry = $this->db->get();
        $result = $qry->result_array();
        return $result;
    }

	public function update_data_multiple($config_app,$table,$data,$where) {

			$this->db->where($where);
	    	$result = $this->db->update($table, $data);

	        $dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->where($where);
			$result = $dynamicdb->update($table, $data);
		//echo $dynamicdb->last_query();die;

		//return TRUE;
	}
	public function get_data($table = '' , $where = array(), $config_app) {
		$dynamicdb = $this->load->database($config_app, TRUE);
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where($where);
			if($table == 'country'){
			$this->db->order_by('country_id','DESC');
			} else if($table == 'state'){
			$this->db->order_by('state_id','DESC');
			} else if($table == 'city'){
			$this->db->order_by('city_id','DESC');
			} else {
			$this->db->order_by('id','DESC');
			}
			$qry = $this->db->get();
			 // echo $this->db->last_query(); die;
			$result = $qry->result();
			return $result;
	}
	public function get_mat_list($table = '', $config_app) {
		$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->where('created_by_cid=1 OR created_by_cid=0');
			$qry = $dynamicdb->get();
			$result = $qry->result();
			#echo $this->db->last_query();
			return $result;
	}
	public function get_stock_data($table = '', $c_id, $config_app) {
		$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->where('created_by_cid='.$c_id.' AND sale_purchase!=""');
			$dynamicdb->where('status = 1');
			$qry = $dynamicdb->get();
			$result = $qry->result();
			#echo $this->db->last_query();
			return $result;
	}
	public function get_single_record($table = '' , $where = array()) {
		$dynamicdb = $this->load->database($config_app, TRUE);
			$sql="SELECT * FROM {$table} WHERE id IN (SELECT MAX(id) FROM {$table} GROUP BY created_by)";
			$query = $this->db->query($sql);
			$data = array();
			if($query !== FALSE && $query->num_rows() > 0){
				$data = $query->result_array();
			}

			return $data;
	}

	public function get_user_by_cid($table ,$field, $where) {
		$dynamicdb = $this->load->database($config_app, TRUE);
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
		$dynamicdb->select('sm.sub_module_name as sub_module_name,sm.id as sub_module_id,p.id ,p.is_all as is_all,p.is_view as is_view,p.is_add as is_add,p.is_edit as is_edit,p.is_delete as is_delete,p.is_validate as is_validate');
		$dynamicdb->from('sub_module sm');
		$dynamicdb->join('permissions p', 'sm.id = p.sub_module_id and p.user_id="'.$id.'"','left');
		$dynamicdb->where($where);
		$query = $dynamicdb->get();
		// echo $this->db->last_query();die();
		$result = $query->row();
		return $result;
	}
	function getNameById($table='',$id='',$field='', $config_app){
		$dynamicdb = $this->load->database($config_app, TRUE);
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



	function ForgotPassword($email){
		$this->db->select('email');
		$this->db->from('user');
		$this->db->where('email', $email);
		$query=$this->db->get();
		//echo $this->db->last_query();die();
		return $query->row_array();
	 }

	public function get_data_by($table ,$field, $fieldValue) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($field, $fieldValue);
		$qry = $this->db->get();
		$result = $qry->row();
		return $result;
	}


// $udatedData = $this->alfaapimodel->update_data_Email('user',$dataArray,'email',$_REQUEST['email'],'companyDbExist',$data->company_db_name) ;
	public function update_data_Email($table,$db_data,$field,$id, $companyDbExist = '',$company_db_name ='') {
		$data = $db_data;
		if($field == 'email'){
			$db_data = $this->get_field_type_data($db_data, $table,'updatePassword');
		}else if($data == array('email_status' => 'verified')){
			$db_data = $data;
		}else{
			$db_data = $this->get_field_type_data($db_data, $table,'updateUserCid');
		}
		
		
		$this->db->where($field, $id);
		$result = $this->db->update($table, $db_data);
	// echo $this->db->last_query();die();
		if((($data == array('email_status' => 'verified')) && $companyDbExist=='companyDbExist')){
			$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->where($field, $id);
			$dynamicdb->update($table, $db_data);
		}
		return true;
	}

	function get_CompaniesOfGroup($config_app,$company_id,$login_userID){
		$dynamicdb = $this->load->database($config_app, TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from('company_detail');
		$dynamicdb->where(array('parent_cid' => $company_id));
		$dynamicdb->or_where(array('id' => $login_userID));
		$query = $dynamicdb->get();
		$result = $query->result_array();
		return $result;
	}

	public function get_legers_dtl($table = '' , $created_id,$json_match,$config_app) {
		$dynamicdb = $this->load->database($config_app, TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		//$dynamicdb->where('created_by_cid = 0 OR created_by_cid = "'.$created_id.'"');
		$dynamicdb->where('created_by_cid = "'.$created_id.'"');
		//$dynamicdb->where('account_group_id = 54');
		$dynamicdb->where('account_group_id = 54 OR parent_group_id = 6');
		if($json_match == '0'){
			$dynamicdb->where('created_by_cid = 0 OR created_by_cid = "'.$created_id.'"');
		}
		else{
			$dynamicdb->where("JSON_SEARCH(salesPersons, 'all', '" . $json_match. "') IS NOT NULL AND created_by_cid ='" . $created_id . "'");
		}
		// $dynamicdb->where('account_group_id = 7');
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result();
		return $result;
	}
	public function get_Purchase_legers_dtl($table = '' , $created_id,$config_app) {
		$dynamicdb = $this->load->database($config_app, TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		//$dynamicdb->where('created_by_cid = 0 OR created_by_cid = "'.$created_id.'"');
		$dynamicdb->where('created_by_cid = "'.$created_id.'"');
		//$dynamicdb->where('account_group_id = 55 AND parent_group_id = 3');
		$dynamicdb->where('account_group_id = 54 OR parent_group_id = 6');
		// $dynamicdb->where('account_group_id = 8');
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result();
		return $result;
	}
	public function get_All_legers_dtl($table = '' , $created_id,$config_app,$json_match,$LedgerType) {
		$dynamicdb = $this->load->database($config_app, TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		if($json_match == '0'){
			$dynamicdb->where('created_by_cid = 0 OR created_by_cid = "'.$created_id.'"');
		}else{
			$dynamicdb->where("JSON_SEARCH(salesPersons, 'all', '" . $json_match. "') IS NOT NULL AND created_by_cid ='" . $created_id . "'");
		}
		//echo $LedgerType;
		if($LedgerType == 'debtors'){
			$dynamicdb->where('account_group_id = 54');
		}else if($LedgerType ==  'creditors'){
			$dynamicdb->where('	account_group_id = 55');
		}

		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
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
			// echo $dynamicdb->last_query();die();
			$result = $qry->row();
			return $result;
		}
	public function get_ladger_account_Data2($table,$where_details,$config_app){
			$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->where($where_details);
			$dynamicdb->or_where('created_by_cid','0');
			$dynamicdb->where('cancel_restore','1');
			//$dynamicdb->order_by('DATE_FORMAT(transaction_dtl.add_date, "%Y" "%m") = 04 DESC');
			$dynamicdb->order_by('date_format(transaction_dtl.add_date,  "%Y-%m-%d") ASC');
			$qry = $dynamicdb->get();
			// pre();
			 // echo $dynamicdb->last_query();die();
			$result = $qry->result();
			return $result;
		}
	   public function insert_data_so($config_app,$table,$data) {
	 // pre($data);	pre($config_app);pre($table);die;
    	 $fieldData = $this->get_field_type_data($data, $table);
		$this->db->insert($table,$fieldData);
		$insertedid = $this->db->insert_id();
		$data['id'] = $insertedid;
		$dynamicdb = $this->load->database($config_app, TRUE);
		$dynamicdb->insert($table,$fieldData);
		//echo $this->db->last_query();die;
		$insertedid2 = $dynamicdb->insert_id();
		return $insertedid2;
	}
	public function update_data_so($config_app,$table,$data,$field,$id) {
			$this->db->where($field, $id);
			$result = $this->db->update($table, $data);
			$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->where($field, $id);
			$result = $dynamicdb->update($table, $data);
		//return TRUE;
	}
	public function getNameById_using_modal($table='',$id='',$field='',$config_app){
		$dynamicdb = $this->load->database($config_app, TRUE);
		 // echo "select * from $table where $field='$id'";die();
		$query = $dynamicdb->query("select * from $table where $field='$id'");
		return $query->row();
	}
		public function getNameById_using_modalForImage($table='',$id='',$field='',$config_app){
		$dynamicdb = $this->load->database($config_app, TRUE);
		 // echo "select * from $table where $field='$id'";die();
		$query = $dynamicdb->query("select * from $table where $field='$id' AND rel_type = 'material'");
		return $query->row();
	}
	public function getNameById_using_modalwithMulti($table='',$id='',$field='',$id1='',$field1='',$config_app){
		$dynamicdb = $this->load->database($config_app, TRUE);
		$query = $dynamicdb->query("select * from $table where $field1='$id1' && $field='$id'");
		return $query->row();
	}
	public function getNameById_using_modalWithArray($table='',$id='',$field='',$config_app){
		$dynamicdb = $this->load->database($config_app, TRUE);
		 // echo "select * from $table where $field='$id'";die();
		$query = $dynamicdb->query("select * from $table where $field='$id'");
		return $query->result_array();
	}

	public function get_total_user_amount_debit_dateWise($table='',$ledger_id,$Login_user_id,$config_app,$where){
		$dynamicdb = $this->load->database($config_app, TRUE);
		//echo "SELECT sum(debit_dtl) FROM $table where ledger_id = '".$ledger_id."' AND cancel_restore = 1 AND ".$where."";
		$query = $dynamicdb->query("SELECT sum(debit_dtl) FROM $table where ledger_id = '".$ledger_id."' AND cancel_restore = 1 AND ".$where."");
		return $query->row_array();
	}
	public function get_total_user_amount_crdt_dateWise($table='',$ledger_id,$Login_user_id,$config_app,$where){
		$dynamicdb = $this->load->database($config_app, TRUE);
		$query = $dynamicdb->query("SELECT sum(credit_dtl) FROM $table where ledger_id = '".$ledger_id."' AND cancel_restore = 1  AND ".$where."");
		return $query->row_array();
	}


	public function get_total_user_amount_debit($table='',$ledger_id,$Login_user_id,$config_app){
		$dynamicdb = $this->load->database($config_app, TRUE);
		$query = $dynamicdb->query("SELECT sum(debit_dtl) FROM $table where ledger_id = '".$ledger_id."' AND cancel_restore = 1 AND created_by_cid = '".$Login_user_id."'");
		return $query->row_array();
	}
	public function get_total_user_amount_crdt($table='',$ledger_id,$Login_user_id,$config_app){
		$dynamicdb = $this->load->database($config_app, TRUE);
		$query = $dynamicdb->query("SELECT sum(credit_dtl) FROM $table where ledger_id = '".$ledger_id."' AND cancel_restore = 1  AND  created_by_cid = '".$Login_user_id."'");
		return $query->row_array();
	}
	public function get_closing_balance($ledger_id,$Login_user_id,$config_app){
		$dynamicdb = $this->load->database($config_app, TRUE);
		$query = $dynamicdb->query("SELECT transaction_dtl.*, ledger.opening_balance,ledger.openingbalc_cr_dr,ledger.account_group_id FROM transaction_dtl RIGHT JOIN ledger on transaction_dtl.ledger_id = ledger.id where ledger.id = '".$ledger_id."' ");
		return $query->row_array();
	}
	public function get_invoice_details_aging_report($table = '',$config_app) {
		$dynamicdb = $this->load->database($config_app, TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($where);

		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();//die();
		$result = $qry->result_array();
		return $result;
	}

	public function get_voucherDtl($table = '' , $created_id,$config_app,$voucherNO) {
		$dynamicdb = $this->load->database($config_app, TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($created_id);
		$dynamicdb->where('id = "'.$voucherNO.'"');
		$qry = $dynamicdb->get();
		$result = $qry->row();
		return $result;
	}
	public function get_saleDtls($table = '' , $where,$config_app){
		$dynamicdb = $this->load->database($config_app, TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select_sum('total_amount');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		// echo $dynamicdb->last_query();die();
		$result = $qry->row();
		return $result;
	}

    public function get_purchaseDtls($table = '' , $where,$config_app){
		$dynamicdb = $this->load->database($config_app, TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select_sum('grand_total');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->row();
		return $result;
	}

	public function get_ALLvoucherDtl($table = '' , $where,$config_app) {
		$dynamicdb = $this->load->database($config_app, TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		 // echo $dynamicdb->last_query();die();
		$result = $qry->result();
		return $result;
	}

	public function get_tags_data($table = '' , $created_id,$config_app) {
		$dynamicdb = $this->load->database($config_app, TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		//$dynamicdb->where('created_by_cid = 0 OR created_by_cid = "'.$created_id.'"');
		$dynamicdb->where('created_by_cid = "'.$created_id.'" AND active_inactive = 1');
		//$dynamicdb->where('account_group_id = 54');
		#$dynamicdb->where('created_by_cid = 0');
		$qry = $dynamicdb->get();
		#echo $dynamicdb->last_query();die();
		$result = $qry->result();
		return $result;
	}

	public function get_data_dynamic($table = '' , $where = array() , $config_app) {
			$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->where($where);
			if($table == 'sale_order'){
				$dynamicdb->order_by('id','DESC');
			}
			$qry = $dynamicdb->get();
			$result = $qry->result();
			return $result;
	}
	public function get_dataByRow($table = '' , $where = array() , $config_app) {	
			$dynamicdb = $this->load->database($config_app, TRUE);		
			$dynamicdb->select('*'); 
			$dynamicdb->from($table);
			$dynamicdb->where($where);
			$qry = $dynamicdb->get();
			$result = $qry->row();	
			// echo $dynamicdb->last_query();
			return $result;
	}	
	
	
#SELECT * FROM ((sale_order INNER JOIN account ON account.id = sale_order.account_id AND account.type = ''))

	function get_sale_order_data($config_app,$id , $where = array()){
		$dynamicdb = $this->load->database($config_app, TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from('sale_order so');
		$dynamicdb->join('account ap', 'ap.id = so.account_id and ap.type = '.$id.'','inner');
		$dynamicdb->where($where);
		#$query = $dynamicdb->get();
		$dynamicdb->order_by('so.id','DESC');
		$qry = $dynamicdb->get();
		$result = $qry->result();

		#echo $dynamicdb->last_query();
		return $result;
	}


	// public function update_data_multiple($config_app,$table,$data,$where) {

	// 		$this->db->where($where);
	//     	$result = $this->db->update($table, $data);

	//         $dynamicdb = $this->load->database($config_app, TRUE);
	// 		$dynamicdb->where($where);
	// 		$result = $dynamicdb->update($table, $data);
	// 	//return TRUE;
	// }
	public function get_closing_blnc($table='',$id='',$field='',$config_app){
		$dynamicdb = $this->load->database($config_app, TRUE);
		$query = $dynamicdb->query("select * from $table where $field='$id'");
		$result = $query->result_array();
		$yu = $result;
		$sum = 0;
		 if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
		 else{ $sum = 0;}
		 return $sum;
	}


	public function update_single_dataForLimit($ledgerID,$table,$limit,$config_app){
	   $query = $this->db->query("UPDATE ".$table." SET `purchaseLimit`= ".$limit." WHERE `id` = '".$ledgerID."'");
	   $dynamicdb = $this->load->database($config_app, TRUE);
       $query = $dynamicdb->query("UPDATE ".$table." SET `purchaseLimit`= ".$limit." WHERE `id` = '".$ledgerID."'");
	}
	public function update_single_dataForTempLimit($ledgerID,$table,$limit,$tempLimitDate,$config_app){
	   $query = $this->db->query("UPDATE ".$table." SET `temp_credit_limit`= '".$limit."',`temp_crlimitDate` = '".$tempLimitDate."' WHERE `id` = '".$ledgerID."'");
	   $dynamicdb = $this->load->database($config_app, TRUE);
       $query = $dynamicdb->query("UPDATE ".$table." SET `temp_credit_limit`= '".$limit."', `temp_crlimitDate`= '".$tempLimitDate."' WHERE `id` = '".$ledgerID."'");
	}

	#$this->db->select('user.*,user_detail.u_id, user_detail.name, user_detail.address1, user_detail.address2, user_detail.designation,user_detail.gender,user_detail.age,user_detail.contact_no,user_detail.experience, user_detail.experience_detail,user_detail.qualification, user_detail.user_profile, user_detail.date_joining, user_detail.facebook, user_detail.twitter, user_detail.instagram, user_detail.linkedin, user_detail.skill');
	function get_so_data($config_app,$id , $where = array()){
		$dynamicdb = $this->load->database($config_app, TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from('material as matdt');
		$dynamicdb->join('import_price_list impl', 'impl.mat_code = matdt.material_code','inner');
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		// echo $dynamicdb->last_query();die;
		$result = $qry->result();
		return $result;
	}

	public function get_data_dynamic_routeplan($table = '' , $where = array() , $config_app , $from , $to) {
			$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->select($from);
			$dynamicdb->select($to);
			$dynamicdb->from($table);
			$dynamicdb->where($where);
			if($table == 'sale_order'){
				$dynamicdb->order_by('id','DESC');
			}
			$qry = $dynamicdb->get();
				#echo $dynamicdb->last_query();
			$result = $qry->result();

			#echo $dynamicdb->last_query();
			return $result;
	}

	public function dealer_loginmodel($phn,$otp = ''){
			$this->db->select('*,account.email as  accEmail,account.id as  accID');
			$this->db->from('account');
			$this->db->join("user", "user.c_id = account.account_owner", 'left');
			$this->db->where('phone', $phn);
			if($otp){
			$this->db->where('otp',$otp);
			}
			$this->db->where('user.role = 1');
			$qry = $this->db->get();
		//echo $this->db->last_query();die();
			return $result = $qry->row();

	}

	public function getNameByIdForLogin($table='',$id='',$field=''){
		$query = $this->db->query("select * from $table where $field='$id'");
		return $query->row();
	}


	public function update_otp($phn,$table,$otp){
	   $query = $this->db->query("UPDATE ".$table." SET `otp`= ".$otp." WHERE `phone` = '".$phn."'");
	}
	public function update_deviceToken($phn,$table,$device_Token,$config_app){

	   $query = $this->db->query("UPDATE ".$table." SET `device_Token`= '".$device_Token."' WHERE `phone` = '".$phn."'");

	   $dynamicdb = $this->load->database($config_app, TRUE);
       $query = $dynamicdb->query("UPDATE ".$table." SET `device_Token`= '".$device_Token."' WHERE `phone` = '".$phn."'");
	 }

	 /* For Ganpati*/
	 public function getNameByIdForLoginotp($table='',$id='',$field=''){
		$query = $this->db->query("select * from $table where $field='$id' AND active_inactive = 1");
		return $query->row();
	}

	public function update_empotp($phn,$table,$otp){
		//echo "UPDATE ".$table." SET `otp`= ".$otp." WHERE `mobile_number` = '".$phn."'";die();
	   $query = $this->db->query("UPDATE ".$table." SET `otp`= ".$otp." WHERE `mobile_number` = '".$phn."'");
	}

	 public function updateEmp_deviceToken($phn,$table,$device_Token,$config_app){

	   $query = $this->db->query("UPDATE ".$table." SET `device_Token`= '".$device_Token."' WHERE `mobile_number` = '".$phn."'");

	   $dynamicdb = $this->load->database($config_app, TRUE);
       $query = $dynamicdb->query("UPDATE ".$table." SET `device_Token`= '".$device_Token."' WHERE `mobile_number` = '".$phn."'");
	 }


	 public function get_dataRowID($table = '' , $where = array()) {
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where($where);
			$qry = $this->db->get();
			$result = $qry->row();
			#echo $this->db->last_query();
			return $result;
	}
	
	public function get_userdata($table = '') {
			$this->db->select('*');
			$this->db->from($table);
			$qry = $this->db->get();
			$result = $qry->row();
			#echo $this->db->last_query();
			return $result;
	}



	function getDataByWhere($table,$where,$order = [],$select = "",$config_app){
		$dynamicdb = $this->load->database($config_app, TRUE);
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





	 /* For Ganpati*/

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


	public function get_banknamedata($table = '') {
			$this->db->select('*');
			$this->db->from($table);
		//	$this->db->where($where);
			$qry = $this->db->get();
			$result = $qry->result();
			#echo $this->db->last_query();
			return $result;
	}



	public function update_Taskdata($table,$data,$field,$id,$config_app) {

		$this->db->where($field, $id);
		$result = $this->db->update($table, $data);
		$dynamicdb = $this->load->database($config_app, TRUE);
		$dynamicdb->where($field, $id);
		$result = $dynamicdb->update($table, $data);
		//return TRUE;
	}


	public function update_singledata($absent_present,$shitTime,$atten_date,$worker_idd,$table,$limit,$config_app){

	   $query = $this->db->query("UPDATE ".$table." SET `$shitTime` = '".$absent_present."' WHERE `atten_date` = '".$atten_date."' AND `worker_id` = '".$worker_idd."'");
	   $dynamicdb = $this->load->database($config_app, TRUE);
       $query = $dynamicdb->query("UPDATE ".$table." SET `$shitTime` = '".$absent_present."' WHERE `atten_date` = '".$atten_date."' AND `worker_id` = '".$worker_idd."'");
	}


	public function updateLedgerID($config_app,$table,$addedLedgerid,$accountTblID){

	   $query = $this->db->query("UPDATE ".$table." SET `ledger_id` = '".$addedLedgerid."' WHERE `id` = '".$accountTblID."'");
	   $dynamicdb = $this->load->database($config_app, TRUE);
       $query = $dynamicdb->query("UPDATE ".$table." SET `ledger_id` = '".$addedLedgerid."' WHERE `id` = '".$accountTblID."'");
	}



	public function checkDataUSerExists($table = '' , $where = array() , $config_app) {

			$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->where($where);
			// if($table == 'sale_order'){
				// $dynamicdb->order_by('id','DESC');
			// }
			$qry = $dynamicdb->get();
			$result = $qry->row();
			//echo $dynamicdb->last_query();die();
			return $result;
	}


	public function get_image_by_materialId($table, $field, $id, $config_app) {

		$dynamicdb = $this->load->database($config_app, TRUE);
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->where($field, $id);
			$dynamicdb->where('rel_type', 'material');
			$qry = $dynamicdb->get();
			$result = $qry->row();
			return $result;
    }

	public function get_materialDetails($table ,$field, $where,$config_app) {
		$dynamicdb = $this->load->database($config_app, TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		// echo $dynamicdb->last_query();
		$result = $qry->row();
		return $result;
	}
	public function get_userDetails($table ,$field, $where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$qry = $this->db->get();
		// echo $dynamicdb->last_query();
		$result = $qry->row();
		return $result;
	}
	
	public function get_PDF_data($table='',$config_app){
		$dynamicdb = $this->load->database($config_app, TRUE);
		$query = $dynamicdb->query("select * from $table ORDER BY id DESC");
		return $query->result_array();
	}
	

}	//main
