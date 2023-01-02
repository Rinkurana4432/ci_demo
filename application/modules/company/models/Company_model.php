<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends ERP_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tablename = 'company';
        //$this->column_search = array('name');
    }

	/* database field columns */
	public function get_field_type_data($data, $table , $group = ''){
		switch($table){
			case 'company_detail':
			//	$all_fields = array('company_pan','year_of_establish','description','no_of_employees','website','address1','address2','key_people','logo','u_id','company_type','revenue');
			if($group != '')
				$all_fields = array('name','company_pan','year_of_establish','description','no_of_employees','website','address','key_people','logo','u_id','company_type','revenue','phone','facebook','google_plus','twitter','instagram','linkedin','mapiframe', 'parent_cid','name','gstin','company_group_email','bank_details','account_name','account_no','account_ifsc_code','bank_name','branch');
			else
				$all_fields = array('company_pan','year_of_establish','description','no_of_employees','website','address','key_people','logo','u_id','company_type','revenue','phone','facebook','google_plus','twitter','instagram','linkedin','mapiframe','bank_details','account_name','account_no','account_ifsc_code','bank_name','branch');
				break;
			case 'attachments':
				$all_fields = array('rel_id','rel_type','file_type','file_name');
				break;
			case 'post':
				$all_fields = array('description','image','created_by_cid','created_by');
				break;
			case 'comments':
				$all_fields = array('comment','post_id','created_by_cid','created_by');
				break;
			case 'connection':
				$all_fields = array('requested_by','requested_to','status','connection_activation_code');
				break;
			case 'inter_comm_chats_messages':
				$all_fields = array('chat_id', 'user_id', 'content','messaged_by');
				break;
			case 'inter_comm_chats':
				$all_fields = array('topic');
				break;
			case 'inter_comm_uri_segments':
				$all_fields = array('first','second','chat_id');
				break;
			case 'location_settings':
				$all_fields = array('c_id','created_by_cid','location','compny_branch_id','company_unit');
				break;
			case 'company_address':
				$all_fields = array('created_by_cid','location','compny_branch_id','company_unit','created_by');
				break;
			case 'company_settings':
				$all_fields = array('c_id','backup_frequency');
				break;
			case 'message':
				$all_fields = array('message','created_by','received_by');
				break;
			case 'ledger':
				$all_fields = array('name','account_group_id','mailing_address','contact_person','phone_no','mobile_no','email','website','registration_type','gstin','pan','created_by','edited_by','parent_group_id','conn_comp_id','created_by_cid','compny_branch_id','save_status','opening_balance','openingbalc_cr_dr');
				break;
			case 'grp_cmpny_setig':
				$all_fields = array('c_id','logo','name','email','phone','zipcode','gstin','address','year_of_establish','no_of_employee','bank_name','account_no','branch','ifsc_no','pan_no','created_by_cid','created_by','edited_by');
				break;

			case 'department':
				$all_fields = array('name','unit_name','created_by_cid','created_by','edited_by');
				break;



		}
		return $data = format_data_to_be_added($all_fields, $data);
	}


	 /* Function to fetch Data */
	/*public function get_data($table = '' , $where = array()) {
		$this->tablename = $table?$table:$this->tablename;
		$this->db->select('company.*,company_detail.website,company_detail.year_of_establish ,company_detail.no_of_employees');
		$this->db->from($this->tablename);
		$this->db->join("company_detail", $table . ".id = company_detail.company_id", 'left');
		$this->db->where($where);
		$qry = $this->db->get();
		$result = $qry->result_array();
		return $result;
	}	*/



	public function get_data($table = '') {
		$this->db->select($table.'.*,company_detail.u_id, company_detail.company_pan , company_detail.name , company_detail.gstin, company_detail.company_type, company_detail.year_of_establish, company_detail.description, company_detail.no_of_employees,company_detail.website, company_detail.phone,company_detail.logo, company_detail.cover_photo, company_detail.address, company_detail.certification, company_detail.key_people, company_detail.term_and_conditions, company_detail.revenue, company_detail.facebook, company_detail.twitter, company_detail.instagram, company_detail.linkedin, company_detail.google_plus, company_detail.mapiframe,company_detail.account_name, company_detail.account_no, company_detail.account_ifsc_code, company_detail.bank_name, company_detail.branch');
		$this->db->from($table);
		$this->db->join("company_detail", $table . ".c_id = company_detail.id", 'left');
		$this->db->where($table.'.role', 1);
		$qry = $this->db->get();
		//echo $this->db->last_query();
		$result = $qry->result_array();
		return $result;
	}



	    /* Insert Data Into table  */
	public function insert_tbl_data($table,$data , $group = '') {


		$fieldData = $this->get_field_type_data($data,$table);

		$insertData = $this->db->insert($table,$fieldData);
		if($table == 'inter_comm_chats' || $table == 'inter_comm_uri_segments'){
			 if ($insertData)  return 1;
			 else return 0;
		}elseif($table == 'location_settings' || $table == 'company_settings' || $table == 'company_address' ){
			$insertedid = $this->db->insert_id();
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$fieldData['id'] = $insertedid;
			$dynamicdb->insert($table,$fieldData);

			return $insertedid;
		}else{
			$insertedid = $this->db->insert_id();
			return $insertedid;
		}
	}

	public function insert_sale_ledger_data($table,$data) {
		$fieldData = $this->get_field_type_data($data,$table);
		$this->db->insert($table,$fieldData);
	//	echo $this->db->last_query();die();
		$insertedid = $this->db->insert_id();


		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$fieldData['id'] =  $insertedid;
		$dynamicdb->insert($table,$fieldData);
		$dynamicdb->insert_id();

	 	return $insertedid;
	}


    /* Update Data */
	public function update_data($table,$db_data,$field,$id,$group = '') {

		$this->companyId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		//echo $this->companyId;die();
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table ,$group);
		$this->db->where($field, $id);
		if($table == 'company_address' && $group ==''){
			$this->db->where('created_by_cid', $this->companyId);
		}else if($table == 'company_address' && $group == 'group'){
			$this->db->where('created_by_cid', $db_data['created_by_cid']);
		}
		$result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		if($table == 'company_address' && $group ==''){
			$dynamicdb->where('created_by_cid', $this->companyId);
		}else if($table == 'company_address' && $group == 'group'){
			$dynamicdb->where('created_by_cid', $db_data['created_by_cid']);
		}
		$dynamicdb->where($field, $id);
		$dynamicdb->update($table, $db_data);
		// echo $dynamicdb->last_query(); die;
		return TRUE;
	}



	/* Update Data */
	public function verify_connection_update_data($table,$db_data,$field,$id) {
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);
		$result = $this->db->update($table, $db_data);
		/*$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->update($table, $db_data);
		#echo $dynamicdb->last_query(); #die;*/
		return TRUE;
	}



	/* Function to fetch Data by Id */
	/*public function get_data_by_key($table ,$field, $fieldValue) {
		$this->db->select('user.*,'.$table.'.*');
		$this->db->from($table);
		$this->db->join("user", $table . ".id = user.c_id", 'left');
		$this->db->where($table.'.'.$field, $fieldValue);
		$qry = $this->db->get();
		echo $this->db->last_query();
		$result = $qry->row();
		return $result;
	}*/



	public function get_data_by_key($table ,$field, $fieldValue) {
		$this->db->select($table.'.*,company_detail.u_id, company_detail.company_pan , company_detail.name , company_detail.gstin, company_detail.company_type, company_detail.year_of_establish, company_detail.description, company_detail.no_of_employees,company_detail.website, company_detail.phone,company_detail.logo, company_detail.cover_photo,company_detail.business_certificate_type,company_detail.business_certificate, company_detail.address, company_detail.certification, company_detail.key_people, company_detail.term_and_conditions, company_detail.revenue, company_detail.facebook, company_detail.twitter, company_detail.instagram, company_detail.linkedin, company_detail.google_plus, company_detail.mapiframe,company_detail.account_name, company_detail.account_no, company_detail.account_ifsc_code, company_detail.bank_name, company_detail.branch');
		$this->db->from($table);
		$this->db->join("company_detail", $table . ".c_id = company_detail.id", 'left');
		$this->db->where($table.'.'.$field, $fieldValue);
		$qry = $this->db->get();
		//echo $this->db->last_query();
		$result = $qry->row();
		return $result;
	}



	public function get_data_by_key_for_business_proof($table ,$field, $fieldValue) {
		$this->db->select($table.'.*,company_detail.u_id, company_detail.company_pan , company_detail.name , company_detail.gstin, company_detail.company_type, company_detail.year_of_establish, company_detail.description, company_detail.no_of_employees,company_detail.website, company_detail.phone,company_detail.logo, company_detail.cover_photo,company_detail.business_certificate_type,company_detail.business_certificate, company_detail.address, company_detail.certification, company_detail.key_people, company_detail.term_and_conditions, company_detail.revenue, company_detail.facebook, company_detail.twitter, company_detail.instagram, company_detail.linkedin, company_detail.google_plus, company_detail.mapiframe,company_detail.account_name, company_detail.account_no, company_detail.account_ifsc_code, company_detail.bank_name, company_detail.branch');
		$this->db->from($table);
		$this->db->join("company_detail", $table . ".c_id = company_detail.id", 'left');
		$this->db->where($table.'.'.$field, $fieldValue);
		$qry = $this->db->get();
		$result = $qry->row();
		return $result;
	}


	/* Function to fetch Data by Id */
	public function get_user_by_cid($table ,$field, $fieldValue) {
		$this->db->select('user.*,'.$table.'.*');
		$this->db->from($table);
		$this->db->join("user", $table . ".u_id = user.id", 'left');
		$this->db->where($table.'.'.$field, $fieldValue);
		$qry = $this->db->get();
		$result = $qry->result_array();
		return $result;
	}

	/* Function to fetch Data by Id */
	public function get_user_by_cid_for_business_proof($table ,$field, $fieldValue) {
		$this->db->select('user.*,'.$table.'.*');
		$this->db->from($table);
		$this->db->join("user", $table . ".u_id = user.id", 'left');
		$this->db->where($table.'.'.$field, $fieldValue);
		$qry = $this->db->get();
		$result = $qry->result_array();
		return $result;
	}

	public function emailExist($email){
		$this->db->select('*');
		$this->db->from('company');
		$this->db->where('email',$email);
		$qry = $this->db->get();
		$result = $qry->result_array();
		return $result;
	}

	/* Insert attachment Data */
	public function insert_attachment_data($table , $data = array(), $type) {
		/*$this->db->insert_batch($table,$data);
		$insertedid = $this->db->insert_id();
		return $insertedid; */


		if(!empty($data)){
			foreach($data as $dt){
				$fieldData = $this->get_field_type_data($dt,$table);
				$this->db->insert($table,$fieldData);
				$insertedid = $this->db->insert_id();
				if($insertedid){
					$dynamicdb = $this->load->database('dynamicdb', TRUE);
					$fieldData['id'] = $insertedid;
					$dynamicInsertedid = $dynamicdb->insert($table,$fieldData);
				}

			}
			return $insertedid;
		}



	}

	/* Function to fetch certificates attachments by company Id */
	public function get_certificates_by_companyId($table ,$field, $id) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($field, $id);
		$this->db->where('rel_type', 'company');
		$qry = $this->db->get();
		$result = $qry->result_array();
		return $result;

	}

	/* Function to delete data from selected Table */
	public function delete_data($table ,$field ,$id) {
		$this->db->where($field, $id);
		$this->db->delete($table);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->delete($table);

		return true;
	}

	public function getProductsByCompanyId( $cid = '' ){
		$this->db->select('attachments.*,material.material_name,material.featured_image');
		$this->db->from('attachments');
		$this->db->join("material", 'attachments.rel_id = material.id', 'left');
		$this->db->where('material.created_by_cid', $cid);
		$this->db->where('attachments.rel_type', 'material');
		$this->db->where('material.sale_purchase', 'sale');
		$this->db->limit(9);
		$qry = $this->db->get();
		$result = $qry->result_array();
		return $result;
	}

	/* Update Data */
	public function updateCoverPhoto($table,$db_data,$field,$id) {
		//$data = $db_data;
		//$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);
		$result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->update($table, $db_data);
		return TRUE;
	}

	/* Function to delete data from selected Table */
	public function deleteCoverPhoto($id = '') {
		$this->db->where('u_id', $id);
		$result = $this->db->update('company_detail', array('cover_photo'=> ''));
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('u_id', $id);
		$dynamicdb->update('company_detail', array('cover_photo'=> ''));
		return true;
	}

	function fetch_country(){
		$this->db->order_by("country_name", "ASC");
		$query = $this->db->get("country");
		return $query->result();
	}

 function fetch_state($country_id){
	$this->db->where('country_id', $country_id);
	$this->db->order_by('state_name', 'ASC');
	$query = $this->db->get('state');
	$output = '<option value="">Select State</option>';
	foreach($query->result() as $row){
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

	function getPosts($company_id){
		$this->db->select('*');
		$this->db->from('post');
		//$this->db->where('created_by_cid', $company_id);
		$this->db->where_in('created_by_cid', $company_id);
		$this->db->order_by("created_date", "desc");
		$qry = $this->db->get();
		$postResult = $qry->result_array();
		$postCommentArray = array();
		if(!empty($postResult)){
			$i = 0;
			foreach($postResult as $pRes){
				$this->db->select('*');
				$this->db->from('comments');
				$this->db->where('post_id', $pRes['id']);
				$this->db->order_by("created_date", "desc");
				$cQry = $this->db->get();
				$commentResult = $cQry->result_array();
				$postCommentArray[$i]['post'] = $pRes;
				$postCommentArray[$i]['comments'] = $commentResult;
			$i++;
			}
		}
		return $postCommentArray;
	}


	//array('created_by_cid' => $this->data['company']->c_id ,'status'=>1,'sale_purchase'=> '["Sale"]')

public function get_product_saleTypeold($table = '' , $where = array()) {
		$table = $table?$table:$this->tablename;
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$this->db->or_where('sale_purchase' , '["Sale","Purchase"]' );
		$this->db->order_by('id', "RANDOM");
		$qry = $this->db->get();
		echo $this->db->last_query();
		$result = $qry->result_array();
		return $result;
	}

	public function get_product_saleType($table = '' , $cid ='') {

		$saleVar = '["Sale"]';
		$salePurVar = '["Sale","Purchase"]';
		$query = "select * from $table where created_by_cid=$cid AND status=1 AND ( sale_purchase = '$saleVar' OR sale_purchase = '$salePurVar') ORDER BY RAND()";

		$qryy = $this->db->query($query);
		$result = $qryy->result_array();
#echo $this->db->last_query();
		return $result;
		/*$table = $table?$table:$this->tablename;
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		//$this->db->or_where('sale_purchase' , '["Sale","Purchase"]' );
		$this->db->order_by('id', "RANDOM");
		$qry = $this->db->get();

		$result = $qry->result_array();
		return $result;		*/
	}



	public function get_company_related_data($table = '',$where = array() , $oneRecord = '') {
		$this->db->select($table.'.*');
		$this->db->from($table);
		$this->db->where($where);
		if($table == 'connection'){
			$this->db->where('status',0);
		}
		$qry = $this->db->get();
		if($oneRecord == 'oneRecord') $result = $qry->row_array();
		else $result = $qry->result_array();
		return $result;
	}

	    /**
     * Locate the id on uri_segments table
     * @param int $first_id
     * @param int $second_id
     * @return bool
     */
    public function locate($first_id, $second_id){
        $query = "SELECT * FROM inter_comm_uri_segments AS uri WHERE (first = '$first_id' AND second = '$second_id') OR (first = '$second_id' AND second = '$first_id') ORDER BY uri.id DESC";
		$record_array = $this->db->query($query)->row_array();
        $this->session->set_userdata(['chat_id' => $record_array['chat_id']]);
        $result = $this->db->query($query)->num_rows();
        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function get_chats_messages($chat_id, $last_chat_message_id = 0){
		$query = "SELECT
			cm.id,
			cm.user_id,
			cm.content,
			DATE_FORMAT(cm.created_at, '%D of %M %Y at %H:%i:%s') AS timestamp,
			cm.is_image,
			cm.is_doc,
			cm.messaged_by,
			u.name as messaged_by_name,
			c.name
		FROM
			inter_comm_chats_messages AS cm
		JOIN
			company_detail AS c
		ON
			cm.user_id = c.id
		JOIN
			user_detail AS u
		ON
			cm.messaged_by = u.u_id
		WHERE
			cm.chat_id = ?
		AND
			cm.id > ?
		ORDER BY
			cm.id
		ASC";
       # $result = $this->db->query($query, [$chat_id, $last_chat_message_id]);

        $result = $this->db->query($query, [$chat_id, $last_chat_message_id]);
        return $result;
    }



	/*public function get_chats_messages($chat_id, $last_chat_message_id = 0){
		$this->db->select("iccm.id,iccm.user_id,iccm.content,DATE_FORMAT(iccm.created_at, '%D of %M %Y at %H:%i:%s') AS timestamp,iccm.is_image,iccm.is_doc,cd.name");
		$this->db->from('inter_comm_chats_messages as iccm');
		$this->db->join("company_detail as cd", "iccm.user_id = cd.id", 'left');
		$this->db->where('iccm.chat_id', $chat_id);
		$this->db->where('iccm.id >', $last_chat_message_id);
		$this->db->order_by("iccm.id", "ASC");
		$qry = $this->db->get();
		$result = $qry->result_array();
		return $result;
    }*/
	function updateLogo($table,$db_data,$field,$id) {
		$this->db->where($field, $id);
		$result = $this->db->update($table, $db_data);

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->update($table, $db_data);
		return true;
	}
	/*function insertImage($table,$db_data,$field,$id) {
		public function insertImage($table,$data) {
		$fieldData = $this->get_field_type_data($data,$table);
		$this->db->insert($table,$fieldData);
		//echo $this->db->last_query(); die;
		$insertedid = $this->db->insert_id();

		return $insertedid;
		}*/


		/* Update Data for business proof*/
	public function updateCompanyProofs($table,$db_data,$field,$id) {
		$this->db->where($field, $id);
		$updateCompanyDetailResult = $this->db->update($table, $db_data);
		if($updateCompanyDetailResult){
			#$erp_master_user_data = $this->get_data_by_key('user','id',$id);
			$erp_master_user_data = $this->get_data_by_key_for_business_proof('user','c_id',$id);
			#echo "id==>>".$id.'<br>';
			#echo "erp_master_user_data->id==>>".$erp_master_user_data->id.'<br>';

			$this->db->where('c_id', $erp_master_user_data->id);
			$updateUserResult = $this->db->update('user', array('business_status'=>1));

			/* $dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('id', $erp_master_user_data->id);
			$updateUserResult = $dynamicdb->update('user', array('business_status'=>1)); */

		/*	if(!empty($updateUserResult)){
				$user_data = $this->get_single_row_tbl_data_by_key('user','id',$id);
				$user_detail_data = $this->get_single_row_tbl_data_by_key('user_detail','u_id',$id);
				$company_detail_data = $this->get_single_row_tbl_data_by_key('company_detail','u_id',$id);
				$user_data = (array) $user_data;
				$user_data['m_cid'] = $erp_master_user_data->c_id;
				$user_detail_data = (array) $user_detail_data;
				$user_detail_data['m_cid'] = $erp_master_user_data->c_id;
				$company_detail_data = (array) $company_detail_data;
				$company_detail_data['m_cid'] = $erp_master_user_data->c_id;
				if ($this->dbforge->create_database($erp_master_user_data->company_db_name)){
					$this->db->db_select($erp_master_user_data->company_db_name);
					$backup = file_get_contents(base_url().'erp_structure.sql');
					$sql_clean = '';
					foreach (explode("\n", $backup) as $line){
						if(isset($line[0]) && $line[0] != "#"){
							$sql_clean .= $line."\n";
						}
					}
					foreach (explode(";\n", $sql_clean) as $sql){
						$sql = trim($sql);
						if($sql){
							$this->db->query($sql);
						}
					}
					unset($user_data['company_db_name']);
					#unset($user_data['id']);
					#unset($user_detail_data['id']);
					#unset($company_detail_data['id']);
					$insertedUserId = $this->db->insert('user',$user_data);
					$insertedUserDetailId = $this->db->insert('user_detail',$user_detail_data);
					$insertedCompanyDetailId = $this->db->insert('company_detail',$company_detail_data);

				}
			}*/return TRUE;
		}
	}
	public function get_single_row_tbl_data_by_key($table ,$field, $fieldValue) {
        $this->db->select($table.'.*');
        $this->db->from($table);
        $this->db->where($table.'.'.$field, $fieldValue);
        $qry = $this->db->get();
        $result = $qry->row();
        return $result;
       /* $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select($table.'.*');
        $dynamicdb->from($table);
        $dynamicdb->where($table.'.'.$field, $fieldValue);
        $qry = $dynamicdb->get();
        $result = $qry->row();
        return $result;*/
    }
/* 	public function get_group_company_data($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		echo $dynamicdb->last_query();
		$result = $qry->result_array();
		pre($result);
		return $result;

	} */


	public function get_group_company_data($table = '' , $where = array()) {
		//$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$this->db->select($this->tablename.'.*, u.email');
		$this->db->from($this->tablename);
		$this->db->join("user as u", $this->tablename.".u_id = u.id", 'left');
		$this->db->where($where);
		$this->db->or_where($this->tablename.".id" , $_SESSION['loggedInUser']->c_id);
		$qry = $this->db->get();
		//echo $this->db->last_query();
		$result = $qry->result_array();
		#pre($result);
		return $result;

	}


	public function get_data_byId($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->where($table.'.'.$field, $id);
			$qry = $dynamicdb->get();
			//echo $dynamicdb->last_query();
			$result = $qry->row();
			return $result;

	}
	public function insert_group_company_tbl_data($table,$data, $group = '') {
		$fieldData = $this->get_field_type_data($data,$table ,$group);

		$this->db->insert($table,$fieldData);

		$insertedid = $this->db->insert_id();
		//echo $this->db->last_query();die;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$fieldData['id'] =  $insertedid;
		$dynamicdb->insert($table,$fieldData);
		$dynamicdb->insert_id();

	 	return $insertedid;
	}


	public function get_data_company($table = '' , $where = array()) {
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			if($table=="department" || $table =="permission"){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}
			else{
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}
			$dynamicdb->where($where);
			$qry = $dynamicdb->get();
			$result = $qry->result_array();
			//pre($dynamicdb->last_query());
			return $result;
		}

/* For insert multiple row in company */
public function insert_multiple_data($table , $data){
		/*$this->db->insert_batch($table, $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->insert_batch($table, $data);*/
		//pre($data);
		if(!empty($data)){
			foreach($data as $dt){
				//pre($dt);
				$fieldData = $this->get_field_type_data($dt,$table);
				$this->db->insert($table,$fieldData);
				//pre($this->db->last_query());
				$insertedid = $this->db->insert_id();

				if($insertedid){
					$dynamicdb = $this->load->database('dynamicdb', TRUE);
					$fieldData['id'] = $insertedid;
					$dynamicInsertedid = $dynamicdb->insert($table,$fieldData);
				}

			}
			return $insertedid;
		}


	}

		/**
      * This function is used authenticate user at login
      */
  	function auth_user_for_new_company($email) {
		//$email = $this->input->post('email');
		//$pwd = easy_crypt($this->input->post('password'));
		//$this->db->select('user.*,user_detail.*');
		$this->db->select('user.*,user_detail.u_id, user_detail.name, user_detail.address1, user_detail.address2, user_detail.designation,user_detail.gender,user_detail.age,user_detail.contact_no,user_detail.experience, user_detail.experience_detail,user_detail.qualification, user_detail.user_profile, user_detail.date_joining, user_detail.facebook, user_detail.twitter, user_detail.instagram, user_detail.linkedin, user_detail.skill');
		$this->db->from('user');
		$this->db->join("user_detail", "user.id = user_detail.u_id", 'left');
		//$this->db->where('password', $pwd);
		$this->db->where('email', $email);
		$qry = $this->db->get();
		//echo $this->db->last_query();
		$result = $qry->row();
		//pre($result);
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

	public function get_logs_related_data($table = '',$where = array() , $oneRecord = '')
    {
    	$dynamicdb = $this->load->database('dynamicdb', TRUE);
    	$dynamicdb->select($table.'.*');
    	$dynamicdb->from($table);
    	$dynamicdb->where($where);
    	$dynamicdb->order_by("id", "desc");
    	$qry = $dynamicdb->get();

    	if($oneRecord == 'oneRecord') $result = $qry->row_array();
    	else $result = $qry->result_array();
    	return $result;
    }
}
