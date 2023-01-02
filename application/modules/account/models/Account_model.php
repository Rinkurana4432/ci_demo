<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends ERP_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tablename = 'company_detail';
        //$this->column_search = array('name');
		error_reporting(0);
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
    }

	/* database field columns */
	public function get_field_type_data($data, $table){  
		//pre($table);
		switch($table){
			case 'account_group':
				$all_fields = array('name','parent_group_id','acc_group_id','created_by','edited_by','created_by_cid');
				break;
			case 'ledger':
				//$all_fields = array('name','account_group_id','mailing_name','opening_balance','mailing_address','mailing_city','mailing_state','mailing_pincode','mailing_country','contact_person','phone_no','mobile_no','email','website','registration_type','gstin','pan','created_by','edited_by','parent_group_id','conn_comp_id','created_by_cid','compny_branch_id','save_status');
				$all_fields = array('name','account_group_id','mailing_address','contact_person','phone_no','mobile_no','email','website','registration_type','gstin','pan','created_by','edited_by','parent_group_id','conn_comp_id','created_by_cid','compny_branch_id','save_status','opening_balance','openingbalc_cr_dr','enble_disbl_rcm','due_days','purchaseLimit','temp_credit_limit','temp_crlimitDate','salesPersons','delarType','areastation','tcs_onOff','customer_id');
				break;
			case 'supply_type':
				$all_fields = array('supply_type_name','created_by_c_id','created_by_uid','edited_by');
				break;
			case 'voucher_type':
				$all_fields = array('voucher_name','voucher_desc','created_by_c_id','created_by_uid','edited_by');
				break;
			case 'invoice':
				$all_fields = array('buyer_order_no','dispatch_document_no','transport','transport_name','transport_gstin','supply_type','distance','v_date','pan','transport_driver_pno','date_time_of_invoice_issue','date_time_removel_of_goods','descr_of_goods','party_name','created_by','terms_of_delivery','invoice_total_with_tax','mode_of_payment','vehicle_reg_no','email','message_for_email','party_phone','file_attachment','gstin','total_amount','invoice_type','totaltax_total','sale_ledger','SGST','CGST','IGST','party_conn_company','accept_reject','created_by_cid','sale_lger_brnch_id','invoice_num','eway_bill_no','consignee_address','port_discharge','port_loading','gr_date','gr_no','save_status','charges_added','party_state_id','mailing_address_name','charges_total_tax','edited_by','buyer_order_date','dispatch_document_date','sale_leger_gstin_no','sale_L_state_id','due_date','sales_person','e_invoice_link','e_way_bill_link','irn_number','consignee_name','consignee_state_id','sale_order','comment','is_active_inactive');

				break;
			case 'company_detail':
				$all_fields = array('term_and_conditions','aging_email_text');
				break;
			case 'voucher':
				$all_fields = array('voucher_name','credit_debit_party_dtl','edited_by','created_by','narration','total','type','created_by_cid','auto_entry','voucher_date','purchase_id','company_state_id','com_branch_id','branch_gst','party_id','party_state_id','party_branch_id','party_gst','invoice_num_add','purch_num_add');
				break;
			case 'payment':
				$all_fields = array('party_id','party_email','payment_method','payment_detail','reference_no','bank_name_id','narration','type','created_by','edited_by','amount_to_credit','balance','added_amount','type','save_status','payment_date','recieve_ledger_id','created_by_cid','comp_branch_id','comp_brnch_gstno','party_branch_id','party_branch_gstno');
				break;
			case 'purchase_bill':
				$all_fields = array('supplier_name','grn_no','grn_date','transport_no','supp_address','driver_phone','vehicle_reg_no','ifsc_code','gstin','created_by','edited_by','message_for_email','date','gstin','npdm_id','descr_of_bills','edited_by','bill_attachment_files','total_amount','product_detail','party_name','totaltax_total','CGST','SGST','IGST','created_by_cid','invoice_total_with_tax','save_status','save_status','charges_added','auto_entry','grand_total','p_email','invoice_num','charges_total_tax','purchase_gstin','purchase_lger_brnch_id','sale_company_state_id','party_billing_state_id','tcsonOff');
				break;
			case 'account_freeze':
				$all_fields = array('freeze_date','created_by_cid');
				break;
			case 'transaction_dtl':
				$all_fields = array('debit_dtl','credit_dtl','type','type_id','created_by','created_by_cid','ledger_id','add_date','cancel_restore');
				break;
			case 'user_dashboard':
				$all_fields = array('graph_id','user_id','show');
				break;
			case 'charges_lead':
				$all_fields = array('particular_charges','ledger_id','type_charges','tax_slab','created_by_cid','created_by_uid','hsnsac','amount_of_charges','edited_by');
				break;
			case 'inventory_flow':
                $all_fields = array('material_type_id','new_location','material_id', 'material_in', 'material_out', 'uom', 'through', 'ref_id', 'uom', 'created_by', 'created_by_cid', 'location','comment','closing_blnc','opening_blnc');
            break;

			case 'mat_locations':
                $all_fields = array('location_id', 'Storage', 'RackNumber', 'quantity', 'Qtyuom', 'created_by_cid', 'material_type_id', 'material_name_id', 'physical_stock', 'balance');
            break;

			case 'challan_dilivery':
				$all_fields = array('reciver_name','reciver_address','supplier_ledger','supplier_address','consignee_address','party_phone','challan_num','challan_date','vehicle_reg_no','created_by','created_by_cid','created_by','edited_by','challan_total_amt','descr_of_goods','challan_type','terms_of_delivery','transporter_phone','auto_entry_po','puo_id','branch_name','save_status','comment');
				break;
			case 'challan_dilivery_inword':
				$all_fields = array('reciver_name','reciver_address','supplier_ledger','supplier_address','consignee_address','party_phone','challan_num','challan_date','vehicle_reg_no','created_by','created_by_cid','edited_by','challan_total_amt','descr_of_goods','challan_type','terms_of_delivery','transporter_phone','auto_entry','challan_id','branch_name','save_status','comment');
				break;
            case 'thrd_party_invtry':
				$all_fields = array('party_name','material_descr','party_state_id','challa_pur_ordr_no','challan_tbl_id','challan_totl_amt','created_by_cid','created_by','challan_number');
				break;
		    case 'trial_blnc_report':
				$all_fields = array('report_start_date','report_end_date','credit_total','debit_total','file_name','created_by','created_by_cid');
				break;
			case 'hsn_sac_master':
				$all_fields = array('hsn_sac','short_name','igst','sgst','cgst','type','uqc','cess','created_by_cid');
				break;
			case 'creditnote_tbl':
				$all_fields = array('crditNoteNo','date','customer_id','custmer_email','invoice_no','ledgerID','productDtl','amountDtl','created_by_cid','saleReturn_CN_ornot','created_by','sale_company_state_id','party_billing_state_id','IGST','CGST','SGST','creditAMt','comment','refrence','edited_by','edited_date');
				break;
			case 'debitnote_tbl':
				$all_fields = array('debitNoteNo','date','supplier_id','supplier_email','PurchaseBill_no','buyerID','productDtl','amountDtl','created_by_cid','PurchaseReturn_DN_ornot','created_by','sale_company_state_id','party_billing_state_id','IGST','CGST','SGST','debitAMt','refrence','comment','edited_by','edited_date');
				break;
             case 'user':
                $all_fields = array('email', 'password', 'email_status', 'status', 'role', 'c_id', 'activation_code', 'company_db_name', 'business_status');
            break;
            case 'user_detail':
                $all_fields = array('name', 'correspondence_state', 'permanent_state', 'address1', 'address2', 'designation', 'gender', 'age', 'contact_no', 'experience', 'qualification', 'date_joining', 'u_id', 'c_id', 'facebook', 'linkedin', 'twitter', 'instagram', 'skill', 'experience_detail', 'save_status','company_id','dept_id','probation_period','biometric_id','bankDetails','paymentMode','confirmation_date');
            break;
			case 'tbl_accounting_invoice':
                $all_fields = array('party_name', 'party_state_id', 'consignee_address', 'party_phone', 'invoice_num', 'date_time_of_invoice_issue', 'sale_ledger', 'sale_L_state_id', 'edited_by', 'created_by', 'created_by_cid', 'save_status','IGST','CGST','SGST','hsn_code','taxvalue','added_amt','totaltaxAMT','TotalWithTax','message','sale_lger_brnch_id','description');
            break;

            case 'tbl_accounting_purchase':
                      $all_fields = array('party_name', 'party_state_id', 'consignee_address', 'party_phone', 'invoice_num', 'date_time_of_invoice_issue', 'sale_ledger', 'sale_L_state_id', 'edited_by', 'created_by', 'created_by_cid', 'save_status','IGST','CGST','SGST','hsn_code','taxvalue','added_amt','totaltaxAMT','TotalWithTax','message','sale_lger_brnch_id','description');
                  break;

            case 'sale_order_dispatch':
				$all_fields = array('account_id','product', 'dispatch_date','dispatch_documents', 'comments', 'transport_tel_no','vehicle_no','created_by','created_by_cid','total','grandTotal','invoice_no','save_status','sale_order_id' , 'reasone_code','reasone_comment');
				break;
			case 'tbl_tdsinward':
                $all_fields = array('tds_details', 'supplier_name', 'supplier_panNo', 'supplier_state_id', 'supplier_phone', 'purchase_bill','TDS_value','Edu_cess', 'date_time_of_invoice_issue', 'sale_ledger', 'sale_L_state_id', 'edited_by', 'created_by', 'created_by_cid', 'save_status','IGST','CGST','SGST','hsn_code','taxvalue','added_amt','totaltaxAMT','TotalWithTax','message','sale_lger_brnch_id','description');
            break;
            case 'customer_discount':
                $all_fields = array('discount_name', 'party_name', 'day_discount', 'created_by', 'created_by_cid','status');
            break;

            case 'reserved_material':
            $all_fields = array('customer_id', 'material_type', 'mayerial_id', 'quantity', 'created_by', 'created_by_cid');
            break;
            case 'account':
				$all_fields = array('account_owner','name','phone','fax','parent_account','website','type','route_id','employee','industry','revenue','description','billing_street','billing_city','billing_zipcode','billing_state','pan','billing_country','shipping_street','shipping_city','shipping_zipcode','shipping_state','shipping_country','gstin','email','created_by','edited_by','save_status','salesPersons','purchaseLimit','temp_credit_limit','temp_crlimitDate','due_days','salesPersons','areastation');
				break;
			 case 'sale_targets':
				$all_fields = array('user_id','company_id','sale_target','acheived_target','start_date','end_date','created_by');
				break;	

		}
		return $data = format_data_to_be_added($all_fields, $data);
	}

	//num rows
	public function num_rows($table, $where = array(),$where2 = ""){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($where);
	 if($where2!=''){
		 $dynamicdb->where($where2);
		 }
         //$dynamicdb->where_not_in('ledger_id',['1','2','3','4','5','6','7']);
		$qry = $dynamicdb->get();
		$result = $qry->num_rows();
//echo $result;die();
		return $result;
	}

	/* Function to fetch Data by Id of material */
	public function get_data_byId($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($table.'.'.$field, $id);
		$qry = $dynamicdb->get();
		$result = $qry->row();
		return $result;

	}
	public function Delete_data_byId($table ,$field, $id,$field2, $id2) {
		$this->db->where($field, $id);
		$this->db->where($field2, $id2);
		$this->db->delete($table);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->where($field2, $id2);
		$dynamicdb->delete($table);
		return true;
	}
	
	public function update_data_byId($table,$qty,$sale_order_id,$materialID) {
		
		$query = $this->db->query("UPDATE ".$table." SET `quantity`= '".$qty."' WHERE `sale_order_id` = '".$sale_order_id."' AND  `mayerial_id` = '".$materialID."'");
	    $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $query = $dynamicdb->query("UPDATE ".$table." SET `quantity`= '".$qty."' WHERE `sale_order_id` = '".$sale_order_id."' AND  `mayerial_id` = '".$materialID."'");
	}
	public function get_inventery_flow_data_byId($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($table.'.'.$field, $id);
		$qry = $dynamicdb->get();
		$result = $qry->result();
		return $result;

	}
	public function get_data_bywhereId($table , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicd->select('*');
		$dynamicd->from($table);
		$dynamicd->where($where);
		$dynamicd->order_by($table.'.created_date', "desc");
		$qry = $dynamicd->get();
		$result = $qry->result();
		return $result;

	}


	 /* Function to fetch Data */
	 public function get_data_material_type($table = '' ) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		return $result;

	}



	public function get_data($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		// echo $dynamicdb->last_query();die();
		return $result;
	}
	public function get_dataTrialBalance($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$dynamicdb->order_by('id','DESC');
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		return $result;
	}

	public function get_data1($table = '' , $where = array(), $limit, $start,$where2,$order,$export_data) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		//pagination
		$start = ($start-1) * $limit;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		if($where2!=''){
		$dynamicdb->where($where2);
		}
		if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
			$dynamicdb->order_by('id',$order);
		}
		//$dynamicdb->order_by('id',$order);
		//$dynamicdb->limit($limit, $start);
		if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}

		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result_array();
		return $result;

	}

	public function get_data_day_book($table = '' , $where = array(), $limit, $start,$where2,$order) {$start = ($start-1) * $limit;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$dynamicdb->where_not_in('ledger_id',1);
		$dynamicdb->where_not_in('ledger_id',2);
		$dynamicdb->where_not_in('ledger_id',3);
		$dynamicdb->where_not_in('ledger_id',4);
		$dynamicdb->where_not_in('ledger_id',5);
		$dynamicdb->where_not_in('ledger_id',6);
		//$dynamicdb->group_by("type_id");
		if($where2!=''){
		    $dynamicdb->where($where2);
		}
		$dynamicdb->order_by('id',$order);
		$dynamicdb->limit($limit, $start);
		$qry = $dynamicdb->get();
        //echo  $dynamicdb->last_query();die;
		$result = $qry->result_array();
		return $result;

	}
	function get_data_daybook($table = '' , $where = array(), $limit, $start,$where2,$order){
		$current_date = date('Y-m-d');
		//pagination

        $start = ($start-1) * $limit;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$dynamicdb->where("DATE_FORMAT(add_date,'%Y-%m-%d')",$current_date);
		$dynamicdb->where_not_in('ledger_id',1);
		$dynamicdb->where_not_in('ledger_id',2);
		$dynamicdb->where_not_in('ledger_id',3);
		$dynamicdb->where_not_in('ledger_id',4);
		$dynamicdb->where_not_in('ledger_id',5);
		$dynamicdb->where_not_in('ledger_id',6);
		if($where2!=''){
		$dynamicdb->where($where2);
		}
			 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
        if( !isset($_GET['ExportType']) ){
            $dynamicdb->limit($limit, $start);
        }
		//$dynamicdb->group_by("type_id");
		//$dynamicdb->GROUP_CONCAT("DATE_FORMAT(created_date,'%Y-%m-%d')",$current_date);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die;
		$result = $qry->result_array();
		return $result;

	}

	    /* Insert Data */
	public function insert_tbl_data($table,$data) {
		$fieldData = $this->get_field_type_data($data,$table);

		$this->db->insert($table,$fieldData);

		$insertedid = $this->db->insert_id();
		//echo $this->db->last_query();die();

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$fieldData['id'] =  $insertedid;
		$dynamicdb->insert($table,$fieldData);
		$dynamicdb->insert_id();
		// echo $dynamicdb->last_query();die();

	 	return $insertedid;
	}



	public function insert_tbl_datachallan($table,$data) {
		$fieldData = $this->get_field_type_data($data,$table);

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$fieldData['id'] =  $insertedid;
		$dynamicdb->insert($table,$fieldData);
		$dynamicdb->insert_id();
		$insertedid = $dynamicdb->insert_id();
		// echo $dynamicdb->last_query();die();

	 	return $insertedid;
	}
	public function update_datachallan($table,$db_data,$field,$id) {
		$data = $db_data;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
        $result = $dynamicdb->update($table, $db_data);
		// 
		return TRUE;
	}


	public function update_single_data_for_purchase_bill_auto_entery($bill_id,$table){
	   $query = $this->db->query("UPDATE ".$table." SET `auto_entry`= '0' WHERE `id` = '".$bill_id."'");
	   $dynamicdb = $this->load->database('dynamicdb', TRUE);
       $query = $dynamicdb->query("UPDATE ".$table." SET `auto_entry`= '0' WHERE `id` = '".$bill_id."'");
	}

    /* Update Data */
	public function update_data($table,$db_data,$field,$id) {
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);
        $result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
        $result = $dynamicdb->update($table, $db_data);
		 // echo $dynamicdb->last_query();die();  
		return TRUE;
	}

	public function update_dataaging($table,$fildname,$updatefield,$id) {
		// echo "UPDATE ".$table." SET ".$fildname."= ".$updatefield." WHERE `u_id` = '".$id."'";die();
	   $query = $this->db->query("UPDATE ".$table." SET ".$fildname."= '".$updatefield."' WHERE `u_id` = '".$id."'");
	   $dynamicdb = $this->load->database('dynamicdb', TRUE);
       $query = $dynamicdb->query("UPDATE ".$table." SET ".$fildname."= '".$updatefield."' WHERE `u_id` = '".$id."'");
		return TRUE;
	}


	/*Update for Auto entry Invoice*/
	public function update_data_for_auto_entry($table,$data_auto_accept, $invoice_id){
		$this->db->where('id',$invoice_id);
		$this->db->update($table,$data_auto_accept);
		$updated_rows = $this->db->affected_rows();
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id',$invoice_id);
		$dynamicdb->update($table,$data_auto_accept);

		return $updated_rows;
	}
	/*Update for Auto entry Invoice*/

	//get email for supplier payment
	public function get_email($table,$field){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('contact_detail');
        $dynamicdb->from($table);
        $dynamicdb->where('id',$field);
        $qry = $dynamicdb->get();
        $result = $qry->result_array();
        return $result;
    }
	//get email for supplier payment

	public function emailExist($email){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from('company');
		$dynamicdb->where('email',$email);
		$qry = $dynamicdb->get();
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
	/* DELETE Transaction Table Model */
	public function cancel_restore_data($table ,$field ,$id,$can_restor) {
		$this->db->where('id', $id);
			$status = array('inv_cancel_restore' => $can_restor);
			$this->db->update($table, $status);
			//echo $this->db->last_query();die();
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('id', $id);
			$dynamicdb->update($table, $status);
			return true;
	}
	public function cancel_restore_transational_tbl_data($table ,$field ,$id,$type,$can_restor) {
			$status = array('cancel_restore' => $can_restor);
			$this->db->where('type_id', $id);
			$this->db->where('type', $type);
			$this->db->update($table, $status);

			//echo $this->db->last_query();die();
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('type_id', $id);
			$this->db->where('type', $type);
			$dynamicdb->update($table, $status);
			return true;
	}



	public function delete_transaction_data($table,$field,$id,$type) {

		$this->db->where($field, $id);
		$this->db->where('type', $type);
		$this->db->delete($table);
		//

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->where('type', $type);
		$dynamicdb->delete($table);
		//echo $dynamicdb->last_query();die();
		return true;
	}
	/* DELETE Transaction Table Model */
	public function delete_RCM_data($table,$field,$id) {

		$this->db->where($field, $id);
		$this->db->delete($table);

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->delete($table);
		return true;
	}








	public function get_data_for_wherecdtion($table = '' , $where = array(),$limit, $start,$where2,$order,$export_data) {
		//pagination
		$start = ($start-1) * $limit;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);

		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		//$dynamicdb->order_by($table.'.created_date', "desc");
		if($where2!=''){
		$dynamicdb->where($where2);
		}
			 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
		//$dynamicdb->order_by('id',$order);
		//$dynamicdb->limit($limit, $start);
		if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result_array();
		return $result;
	}

	public function get_voucher_dtatils($table = '' ,$where = array(),$limit, $start,$where2,$order,$export_data) {
		//pagination
		$start = ($start-1) * $limit;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		//$dynamicdb->order_by($table.'.created_date', "desc");
		if($where2!=''){
		$dynamicdb->where($where2);
		}
			 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id','DESC');
			}

		//$dynamicdb->order_by('id',$order);
		if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
		//$dynamicdb->limit($limit, $start);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result_array();
		return $result;
	}



	public function get_purchase_invoice_details($table = '' , $where = array(),$limit, $start,$where2,$order,$export_data) {
		//pagination
		$start = ($start-1) * $limit;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		if($where2!=''){
		$dynamicdb->where($where2);
		}
		 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
			if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
		//$dynamicdb->limit($limit, $start);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();
		$result = $qry->result_array();
		return $result;
	}

	public function get_invoice_details($table = '' ,$where = array(),$limit, $start,$where2,$order,$export_data) {
		//pagination
		$start = ($start-1) * $limit;

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		if($where2!='')
		{
		$dynamicdb->where($where2);
		}
		 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
		//$dynamicdb->order_by($table.'.created_date', "desc");
		//$dynamicdb->order_by('id',$order);
		//$dynamicdb->limit($limit, $start);
		if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();//die();
		$result = $qry->result_array();
		return $result;
	}

	public function get_account_freeze($table = '' ,$where = array(),$limit = ''){

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('freeze_date');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		$result = $qry->row();
		return $result;
	}
	public function get_auto_invoice_details($table = '' , $where = array(),$limit, $start,$where2,$order,$export_data) {
		//pagination
		$start = ($start-1) * $limit;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$dynamicdb->or_where('accept_reject','0');
		if($where2!=''){
		$dynamicdb->where($where2);
		}
		 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
		if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}

	//$dynamicdb->limit($limit, $start);
		$qry = $dynamicdb->get();
		//echo $this->db->last_query();//die();
		$result = $qry->result_array();
		return $result;
	}

	public function get_matrial_data_byId($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($field, $id );
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->row();
		return $result;
	}
	public function get_process_data_byId($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('machine_details');
		$dynamicdb->from($table);
		$dynamicdb->where($field, $id );
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->row();
		return $result;
	}
	public function get_ledger_sate_Data($table ,$field, $id,$login_id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($field, $id );
		$dynamicdb->where('created_by_cid', $login_id );
		$qry = $dynamicdb->get();
		$result = $qry->row();
		return $result;
	}
	public function get_comapny_sate_Data($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($field, $id );
		//$dynamicdb->where('created_by_cid', $login_id );
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->row();
		return $result;
	}
	/*Get Charges Data*/
	public function get_particulars_charges_data($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($field, $id );
		$qry = $dynamicdb->get();
		$result = $qry->row();
		return $result;
		// $this->db->select('*');
		// $this->db->from($table);
		// $this->db->where($field, $id );
		// $qry = $this->db->get();
		// $result = $qry->row();
		// return $result;
	}
	/*Get Charges Data*/

	public function get_termconditions_details($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		//$this->db->where($table.'.'.$field, $id);
		$dynamicdb->where($field, $id );
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->row();
		return $result;
	}
	public function insert_on_spot_tbl_data($table,$added_data) {
		$this->db->insert($table,$added_data);
		$insertedid = $this->db->insert_id();

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$added_data['id'] =  $insertedid;
		$dynamicdb->insert($table,$added_data);
		$dynamicdb->insert_id();
		return $insertedid;
	}



	/* Insert attachment Data */
	public function insert_attachment_data($table , $data = array(), $type) {
		$this->db->insert_batch($table,$data);
		$insertedid = $this->db->insert_id();

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->insert_batch($table,$data);
		$data['id'] =  $insertedid;
		$dynamicdb->insert_id();
		return $insertedid;
	}

	/* GET NOT PAID INVOICES */
	public function not_paid_data_byID($table = '' , $where = array()) {
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$dynamicdb->where('pay_or_not','0');
		$dynamicdb->where('accept_reject','');
		//$this->db->or_where('accept_reject','');
		$qry = $dynamicdb->get();
		// echo $dynamicdb->last_query();die();
		$result = $qry->result_array();
		return $result;
	}
	public function Get_advance_payment($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select_sum('amount_to_credit');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$dynamicdb->where('amount_to_credit !=','0');
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->row();
		return $result;
	}

    /* Check Amount and update invoice */
	/*Fetch Not Paid Purchase Bills*/

	public function not_paid_purchase_bill($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$dynamicdb->where('pay_or_not','0');
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result_array();
		return $result;
	}
	/*Fetch Not Paid Purchase Bills*/

	public function invoiceExist($invoice_num){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from('invoice');
		$dynamicdb->where('invoice_num',$invoice_num);
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		return $result;
	}

	public function add_balance_amount_or_paid($table,$update_data, $invoice_id){
		$this->db->where('id',$invoice_id);
		$this->db->update($table,$update_data);
		$update_rows_data = $this->db->affected_rows();

		 $dynamicdb = $this->load->database('dynamicdb', TRUE);
		 $dynamicdb->where('id',$invoice_id);
		 $dynamicdb->update($table,$update_data);
		 $update_rows_data = $dynamicdb->affected_rows();

		 return $update_rows_data;

	}

	public function update_inventery_mat_details($table,$mat_id,$id,$update_data){
		$this->db->where('material_id',$mat_id);
		$this->db->where('ref_id',$id);
		$this->db->update($table,$update_data);
		$update_rows_data = $this->db->affected_rows();

		 $dynamicdb = $this->load->database('dynamicdb', TRUE);
		 $dynamicdb->where('material_id',$mat_id);
		 $dynamicdb->where('ref_id',$id);
		 $dynamicdb->update($table,$update_data);
		 $update_rows_data = $dynamicdb->affected_rows();

		 return $update_rows_data;

	}

	public function delete_inventery_mat_details($table,$id,$through){
		$this->db->where('id', $id);
		$this->db->where('through', $through);
		$this->db->delete($table);

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($id, $id);
		$dynamicdb->where('through', $through);
		$dynamicdb->delete($table);
		return true;
	}
	// public function delete_invenetory_mat_idd($table,$mat_idd,$id,$through){
		// $this->db->where('id', $id);
		// $this->db->where('material_id', $mat_idd);
		// $this->db->where('through', $through);
		// $this->db->delete($table);

		// $dynamicdb = $this->load->database('dynamicdb', TRUE);
		// $dynamicdb->where($id, $id);
		// $dynamicdb->where('material_id', $mat_idd);
		// $dynamicdb->where('through', $through);
		// $dynamicdb->delete($table);
		// return true;
	// }

	public function get_previous_inventery_flow_data($table,$mat_id,$id,$through){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where('material_id',$mat_id);
		$dynamicdb->where('ref_id',$id);
		$dynamicdb->where('through',$through);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result();
		return $result;
	}
	public function Get_GST_data($table,$where_gstdata){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($where_gstdata);
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		return $result;
	}

	public function Get_GSTcredit_data($table,$where_gstdata){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($where_gstdata);
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		return $result;
	}


	/*GET LADGER ACCOUNT DATA*/
	public function get_ladger_account_Data($table,$where_details){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($where_details);
		//$dynamicdb->order_by('add_date', "desc");
		$qry = $dynamicdb->get();
		// echo $dynamicdb->last_query();die();
		$result = $qry->result();
		return $result;
	}
	public function get_ladger_account_Data2($table,$where_details){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($where_details);
		$dynamicdb->where('cancel_restore','1');
		//$dynamicdb->order_by('DATE_FORMAT(transaction_dtl.add_date, "%Y" "%m") = 04 DESC');
		$dynamicdb->order_by('date_format(transaction_dtl.add_date,  "%Y-%m-%d") DESC');
		$qry = $dynamicdb->get();
		 //echo $dynamicdb->last_query();die();
		$result = $qry->result();
		return $result;
	}
	public function get_invoice_report_details($table,$where_details){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($where_details);
		//$dynamicdb->order_by('DATE_FORMAT(transaction_dtl.add_date, "%m")');
		//$dynamicdb->order_by('DATE_FORMAT(transaction_dtl.add_date, "%Y" "%m") = 04 DESC');
		$dynamicdb->order_by('date_format(transaction_dtl.add_date,  "%Y-%m-%d") DESC');
		$qry = $dynamicdb->get();
		$result = $qry->result();
		return $result;

	}


	public function get_ladger_account_search_Data($table,$where_details,$text_box_val){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->like('name', $text_box_val);
		$dynamicdb->where($where_details);
		//$dynamicdb->or_where('created_by_cid','0');
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result_array();
		return $result;
		// return $dynamicdb->get()->result_array();
	}

	/* Function to fetch Data according to date date filter */
	public function get_data_according_to_date_range($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$table = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$dynamicdb->order_by('created_date', "desc");
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		return $result;
	}
	/* Function to fetch Data according to date date filter */

	/*Get Trail Balnce using group by id */

	/* public function get_ledgers_details_using_group_byid($created_by_id,$first_date,$second_date) {
			// $first_date	= '2019-04-01';
			// $second_date	= '2020-03-31';
		$this->db->select('*');
		$this->db->from('transaction_dtl');
		$this->db->join('invoice', 'invoice.id = transaction_dtl.type_id');
		$this->db->join('ledger', 'ledger.id = transaction_dtl.ledger_id');
		$this->db->where('invoice.created_by', $created_by_id );
		//$this->db->or_where('invoice.pay_or_not', 0 );
		$this->db->where('invoice.created_date >=', $first_date);
		$this->db->where('invoice.created_date <=', $second_date);
		// $this->db->where('transaction_dtl.type', 'invoice' );
		// $this->db->or_where('transaction_dtl.type', 'voucher' );
		$this->db->where("(transaction_dtl.type='invoice' OR transaction_dtl.type='voucher')");
		$qry1 = $this->db->get();
		#echo $this->db->last_query();die();



		$this->db->select('*');
		$this->db->from('transaction_dtl');
		$this->db->join('purchase_bill', 'purchase_bill.id = transaction_dtl.type_id');
		$this->db->join('ledger', 'ledger.id = transaction_dtl.ledger_id ','left');
		$this->db->where('purchase_bill.created_by', $created_by_id );
		//$this->db->or_where('purchase_bill.pay_or_not', 0 );
		$this->db->where('purchase_bill.created_date >=', $first_date);
		$this->db->where('purchase_bill.created_date <=', $second_date);
		// $this->db->where('transaction_dtl.type', 'purchase_bill' );
		// $this->db->or_where('transaction_dtl.type', 'voucher' );
		$this->db->where("(transaction_dtl.type='purchase_bill' OR transaction_dtl.type='voucher')");

		$qry2 = $this->db->get();
		//echo $this->db->last_query();die();

		$result1 = $qry1->result_array();

		$result2 = $qry2->result_array();
		//pre(array_merge($result1, $result2)); die;
		return array_merge($result1, $result2);
		-------
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('transaction_dtl.ledger_id, transaction_dtl.debit_dtl,transaction_dtl.credit_dtl,transaction_dtl.type, ledger.id,ledger.account_group_id,ledger.opening_balance,ledger.openingbalc_cr_dr,ledger.name');
		$dynamicdb->from('transaction_dtl');
		$dynamicdb->join('invoice', 'invoice.id = transaction_dtl.type_id');
		$dynamicdb->join('ledger', 'ledger.id = transaction_dtl.ledger_id','RIGHT');
		$dynamicdb->order_by("ledger.account_group_id", "asc");
		//$dynamicdb->group_by("ledger.name");
		$dynamicdb->where('ledger.created_by_cid', $created_by_id );

		// $dynamicdb->where('invoice.created_date >=', $first_date);
		// $dynamicdb->where('invoice.created_date <=', $second_date);

		//$dynamicdb->where("(transaction_dtl.type='invoice' OR transaction_dtl.type='voucher')");
		$qry1 = $dynamicdb->get();

		// echo $dynamicdb->last_query();
		// pre($qry1->result_array());die();

		$dynamicdb->select('transaction_dtl.ledger_id, transaction_dtl.debit_dtl,transaction_dtl.credit_dtl,transaction_dtl.type, ledger.id,ledger.account_group_id,ledger.opening_balance,ledger.openingbalc_cr_dr,ledger.name');
		$dynamicdb->from('transaction_dtl');
		$dynamicdb->join('purchase_bill', 'purchase_bill.id = transaction_dtl.type_id');
		$dynamicdb->join('ledger', 'ledger.id = transaction_dtl.ledger_id ','RIGHT');
		$dynamicdb->order_by("ledger.account_group_id", "asc");
		//$dynamicdb->group_by("ledger.name");
		$dynamicdb->where('purchase_bill.created_by_cid', $created_by_id );

		// $dynamicdb->where('purchase_bill.created_date >=', $first_date);
		// $dynamicdb->where('purchase_bill.created_date <=', $second_date);

		$dynamicdb->where("(transaction_dtl.type='purchase_bill' OR transaction_dtl.type='voucher')");

		$qry2 = $dynamicdb->get();
		$result1 = $qry1->result_array();

		$result2 = $qry2->result_array();
		return array_merge($result1, $result2);
		------

		$qry1 = $dynamicdb->query("SELECT t1.*, t2.*,t3.* FROM ledger as t1 LEFT JOIN transaction_dtl as t2 ON t1.id = t2.ledger_id LEFT JOIN invoice as t3 ON t2.type_id = t3.id WHERE t1.created_by_cid = '".$created_by_id."'");
	}*/
	//public function get_ledgers_details_using_group_byid($created_by_id,$first_date,$second_date) {


	public function get_ledgers_details_using_group_byid($where) {
	       $dynamicdb = $this->load->database('dynamicdb', TRUE);
		  $dynamicdb->select('ledger.id as ledgerid, transaction_dtl.*,ledger.*');
		  $dynamicdb->from('ledger');
		  $dynamicdb->join('transaction_dtl', 'ledger.id = transaction_dtl.ledger_id','LEFT');
		  $dynamicdb->where($where);
		  $dynamicdb->or_where('ledger.created_by_cid', 0 );
		  $dynamicdb->order_by('ledger.account_group_id', 'ASC');
		  $query = $dynamicdb->get();
		// echo $dynamicdb->last_query();die();
		   return $result12 = $query->result_array();
		 
	}
	
	public function get_ledgers_details_for_balance_sheet($where) {

	   	$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('ledger.id as ledgerid, transaction_dtl.*,ledger.*');
		$dynamicdb->from('ledger');
		$dynamicdb->join('transaction_dtl', 'ledger.id = transaction_dtl.ledger_id','LEFT');
		$dynamicdb->where($where);
		$dynamicdb->or_where('ledger.created_by_cid', 0 );
		$dynamicdb->order_by('ledger.account_group_id', "ASC");
		$query = $dynamicdb->get();
		 // echo $dynamicdb->last_query();
		return $result12 = $query->result_array();
	}


	function getClosingBalance($where){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('material_id,sum(material_in) as sum_material_in ,sum(material_out) as sum_material_out');
		$dynamicdb->from('inventory_flow');
		$dynamicdb->group_by('material_id');
		$dynamicdb->where($where);
		$query = $dynamicdb->get();
		 //
		$dynamicdb->select('opening_balance');
		$dynamicdb->from('material');
		$dynamicdb->where(array('created_by_cid'=> $this->companyGroupId));
		//$dynamicdb->where(array('created_by_cid'=> $_SESSION['loggedInUser']->c_id));
		$materialQuery = $dynamicdb->get();
		 // echo $dynamicdb->last_query();
		$result = $query->row();

		$materialResult = $materialQuery->row();
		
		 

		// $openingBalance = $materialResult->opening_balance;
		if(!empty($result)){
			
			$openingBalance = $openingBalance + $result->sum_material_in;
			$openingBalance  = $openingBalance - $result->sum_material_out;
		}
		// pre($openingBalance);

		return  $openingBalance;

	}

	/*New Bakcup*/
	// public function get_ledgers_details_for_balance_sheet($created_by_id,$first_date,$second_date) {
	   	// $dynamicdb = $this->load->database('dynamicdb', TRUE);
		// $dynamicdb->select('ledger.id as ledgerid, transaction_dtl.*,ledger.*');
		// $dynamicdb->from('ledger');
		// $dynamicdb->join('transaction_dtl', 'ledger.id = transaction_dtl.ledger_id','LEFT');
		// $dynamicdb->order_by('ledger.account_group_id', "asc");
		// $dynamicdb->where('ledger.created_date >=', $first_date);
		// $dynamicdb->where('ledger.created_date <=', $second_date);
		// $dynamicdb->where('ledger.created_by_cid', $created_by_id );
		// $dynamicdb->or_where('ledger.created_by_cid', 0 );
		// $query = $dynamicdb->get();
		// return $result12 = $query->result_array();
	// }
	/*New Bakcup*/



	
	/*public function get_ledgers_details_for_balance_sheet($created_by_id) {
		$this->db->select('*');
		$this->db->from('transaction_dtl');
		$this->db->join('invoice', 'invoice.id = transaction_dtl.type_id ');
		$this->db->join('ledger', 'ledger.id = transaction_dtl.ledger_id ');
		$this->db->where('invoice.created_by', $created_by_id );
		//$this->db->or_where('invoice.pay_or_not', 0 );
		//$this->db->where('transaction_dtl.type', 'invoice' );
		//$this->db->or_where('transaction_dtl.type', 'voucher' );
		$this->db->where("(transaction_dtl.type='invoice' OR transaction_dtl.type='voucher')");
		$qry12 = $this->db->get();

		$this->db->select('*');
		$this->db->from('transaction_dtl');
		$this->db->join('purchase_bill', 'purchase_bill.id = transaction_dtl.type_id');
		$this->db->join('ledger', 'ledger.id = transaction_dtl.ledger_id ','left');
		$this->db->where('purchase_bill.created_by', $created_by_id );
		//$this->db->or_where('purchase_bill.pay_or_not', 0 );
		// $this->db->where('transaction_dtl.type', 'purchase_bill' );
		// $this->db->or_where('transaction_dtl.type', 'voucher' );
		$this->db->where("(transaction_dtl.type='purchase_bill' OR transaction_dtl.type='voucher')");
		$qry22 = $this->db->get();

		$result12 = $qry12->result_array();
		$result22 = $qry22->result_array();

		return array_merge($result12, $result22);
		//return $result;
	}*/
	// for  Getting default and Created by Defalult Voucher
	public function get_data_with_zero_id_condtions($table = '' , $created_id, $limit, $start,$where,$order) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		//pagination
		$start = ($start-1) * $limit;
		//query
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->group_start();
		if($table == 'voucher_type'){
			$dynamicdb->where('created_by_c_id = 0 OR created_by_c_id = "'.$created_id.'"');
		}else if($table == 'supply_type'){
			$dynamicdb->where('created_by_c_id = 0 OR created_by_c_id = "'.$created_id.'"');
		}elseif($table == 'ledger'){
			$dynamicdb->where('created_by_cid = 0 OR created_by_cid = "'.$created_id.'"  AND activ_status = 1 ');
		}elseif($table == 'account_group'){
			$dynamicdb->where('created_by_cid = 0 OR created_by_cid = "'.$created_id.'"');
		}else{
			$dynamicdb->where('created_by_cid = 0 OR created_by_cid = "'.$created_id.'"');
		}
		$dynamicdb->group_end();
		if($where!=''){
		$dynamicdb->where($where);
		}
		 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
		$dynamicdb->limit($limit, $start);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();
		$result = $qry->result_array();
		return $result;
	}
	public function get_data_with_zero_id_condtionsFor_ledger_report($table = '' , $created_id, $limit, $start,$where,$order) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		//pagination
		$start = ($start-1) * $limit;
		//query
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->group_start();
		if($table == 'ledger'){
			$dynamicdb->where('created_by_cid = 0 OR created_by_cid = "'.$created_id.'"  AND activ_status = 1 ');
		}
		$dynamicdb->group_end();
		if($where!=''){
		$dynamicdb->where($where);
		}
		 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id','ASC');
			}
		$dynamicdb->limit($limit, $start);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();
		$result = $qry->result_array();
		return $result;
	}


	public function get_data_with_zero_id_condtions_ledger_report($table = '' , $created_id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where('created_by_cid = 0 OR created_by_cid = "'.$created_id.'"');
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();
		$result = $qry->result_array();
		return $result;
	}

	public function get_ledgers_whereIn_conditions($table = '' , $created_id ,$invalid_gst){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);

		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		//$dynamicdb->where_in('id', $invalid_gst);
		$dynamicdb->where('id'." IN (".$invalid_gst.")");
		$dynamicdb->where('created_by_cid = "'.$created_id.'"');
		//$dynamicdb->where('created_by_cid = "'.$created_id.'"');
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result_array();
		return $result;

	}
	public function get_active_and_inactive_ledgers($table = '' , $created_id ,$invalid_gst, $limit, $start,$where2='',$order){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		//pagination
		$start = ($start-1) * $limit;
		//query
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		//$dynamicdb->where_in('id', $invalid_gst);
		$dynamicdb->where('id'." IN (".$invalid_gst.")");
		$dynamicdb->where('created_by_cid = "'.$created_id.'"');
		//$dynamicdb->where('created_by_cid = "'.$created_id.'"');
		$dynamicdb->where('	activ_status = 1');
		if($where2!=''){
		$dynamicdb->where($where2);
		}
		$dynamicdb->order_by('id',$order);
		$dynamicdb->limit($limit, $start);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result_array();
		return $result;
	}

	public function get_ledgers_active($table = '' , $where , $limit, $start,$where2,$order,$export_data) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		//pagination
		$start = ($start-1) * $limit;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		if($where2!=''){
		$dynamicdb->where($where2);
		}
		 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
			if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
		//$dynamicdb->order_by('id','desc');
	//	$dynamicdb->limit($limit, $start);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();//die();
		$result = $qry->result_array();
		return $result;
	}

	public function get_data_for_GSTR1_validation($table = '' , $created_id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where('created_by_cid = 0 OR created_by_cid = "'.$created_id.'"');
		$dynamicdb->where('save_status = 1');
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result_array();
		return $result;
	}

	public function get_data_for_GST3B_validation($table = '' , $created_id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where('created_by_cid = 0 OR created_by_cid = "'.$created_id.'"');
		$dynamicdb->where('auto_entry = 0');
		$dynamicdb->where('save_status = 1');
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result_array();
		return $result;
	}



	// for  Getting default and Created by Defalult Voucher

	//For Get Loss And Profit Data
	function Get_profit_and_loss_data($created_by_id,$where = array()){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from('transaction_dtl');
		$dynamicdb->join('invoice', 'invoice.id = transaction_dtl.type_id ');
		$dynamicdb->join('ledger', 'ledger.id = transaction_dtl.ledger_id ');
		$dynamicdb->where('invoice.created_by', $created_by_id );
		$dynamicdb->where('invoice.pay_or_not', 0 );
		$dynamicdb->where($where);
		// $this->db->where('transaction_dtl.type', 'invoice' );
		// $this->db->or_where('transaction_dtl.type', 'voucher' );
		$dynamicdb->where("(transaction_dtl.type='invoice' OR transaction_dtl.type='voucher')");
		$qry12 = $this->db->get();

		$dynamicdb->select('*');
		$dynamicdb->from('transaction_dtl');
		$dynamicdb->join('purchase_bill', 'purchase_bill.id = transaction_dtl.type_id');
		$dynamicdb->join('ledger', 'ledger.id = transaction_dtl.ledger_id ','left');
		$dynamicdb->where('purchase_bill.created_by', $created_by_id );
		$dynamicdb->where('purchase_bill.pay_or_not', 0 );
		$dynamicdb->where($where);
		// $this->db->where('transaction_dtl.type', 'purchase_bill' );
		// $this->db->or_where('transaction_dtl.type', 'purchase_bill' );
		$dynamicdb->where("(transaction_dtl.type='purchase_bill' OR transaction_dtl.type='voucher')");
		$qry22 = $this->db->get();

		$result12 = $qry12->result_array();
		$result22 = $qry22->result_array();

		return array_merge($result12, $result22);
	}

	//For Get Loss And Profit Data

	/* Update Transaction Table Model */
	public function update_transaction_data_purchase_bill($table,$db_data,$field,$id,$type,$ledger_id) {
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);
		$this->db->where('ledger_id', $ledger_id);
		$this->db->where('type', $type);
		//$this->db->where('id', $trans_id);
		$this->db->update($table, $data);
		//echo $this->db->last_query();
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->where('ledger_id', $ledger_id);
		$dynamicdb->where('type', $type);
		//$dynamicdb->where('id', $trans_id);
		$dynamicdb->update($table, $data);
		return TRUE;
	}
	public function update_transaction_data($table,$db_data,$field,$id,$type,$ledger_id) {
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);
		$this->db->where('ledger_id', $ledger_id);
		$this->db->where('type', $type);
		//$this->db->where('id', $trans_id);
		$this->db->update($table, $data);
		//echo $this->db->last_query();die();
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->where('ledger_id', $ledger_id);
		$dynamicdb->where('type', $type);
		//$dynamicdb->where('id', $trans_id);
		
		$dynamicdb->update($table, $data);
		return TRUE;
	}


	public function get_data_byId_transcation_dtl($table ,$field, $id,$cr_dr_dtl) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		//pre($table);die();
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($table.'.'.$field, $id);
		//$dynamicdb->where('type_id', $type_id);
		$dynamicdb->where($cr_dr_dtl.'!=', '0');
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die('ddd');
		$result = $qry->row();
		return $result;

	}
	/* Update Transaction Table Model */
	public function update_transaction_data_chk($table,$db_data,$field,$id,$type,$ledger_id) {
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);
		$this->db->where('ledger_id', $ledger_id);
		$this->db->where('type', $type);
		//$this->db->where('id', $trans_id);
		$this->db->update($table, $data);
		//
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->where('ledger_id', $ledger_id);
		$dynamicdb->where('type', $type);
		//$dynamicdb->where('id', $trans_id);
		$dynamicdb->update($table, $data);
		
		return TRUE;
	}
	
	public function update_transaction_dataForPurchase($table,$db_data,$field,$id,$type,$ledger_id) {
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		//$this->db->where($field, $id);
		$this->db->where('id', $ledger_id);
		//$this->db->where('type', $type);
		//$this->db->where('id', $trans_id);
		$this->db->update($table, $data);
		//
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		//$dynamicdb->where($field, $id);
		$dynamicdb->where('id', $ledger_id);
		//$dynamicdb->where('type', $type);
		//$dynamicdb->where('id', $trans_id);
		$dynamicdb->update($table, $data);
	 // echo $dynamicdb->last_query();
		return TRUE;
	}

	public function get_data_new($created_id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);

		$query = $dynamicdb->query("SELECT  DISTINCT   parent_group_id FROM account_group where parent_group_id !='' OR acc_group_id !='' AND created_by ='".$created_id."' or created_by ='0' ");
		return $query->result_array();
	}
	public function get_data_Accrding_toparent_id($data_parent){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$query = $dynamicdb->query("SELECT * FROM `account_group` WHERE `id` NOT IN (".$data_parent.")");
		return $query->result_array();
	}

	/*****************************************************************************************************************************************************/
	/*****************************************************************Get connectd Company **************************************************************/
	/****************************************************************************************************************************************************/
	Public function get_connected_company_data($table = '',$where = array()){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*');
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		//echo $this->db->last_query();die();
		return $result;
	}



	Public function accept_reject_invoice_modl($table = '',$where = array(),$accept_reject){

		$this->db->where($where);
		$this->db->update($table,$accept_reject);
		$updated_rows = $this->db->affected_rows();

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($where);
		$dynamicdb->update($table,$accept_reject);
		return $updated_rows;

	}

	/*Excel Data*/
	public function get_data_for_xls_import($created_id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$get_invoice_tbl_Data = array('id','gstin', 'created_date','descr_of_goods','invoice_type','sale_ledger','party_name');
        $dynamicdb->select($get_invoice_tbl_Data);
        $dynamicdb->from('invoice');
        $dynamicdb->where('created_by_cid',$created_id);
		$qryexp_invoice = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		return $qryexp_invoice->result_array();

    }
	public function listing_export_Data($created_id,$get_ledger_Data,$table) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select($get_ledger_Data);
        $dynamicdb->from($table);
        $dynamicdb->where('created_by_cid',$created_id);
        $dynamicdb->or_where('created_by_cid','0');
        $query = $dynamicdb->get();

        return $query->result_array();
    }








	/*Excel Data*/
/**************************************************************************************************************************************************/
/********************************************************Get Sale Register**********************************************************************/
/*******************************************************************************************************************************************/

	public function Get_get_Sale_register($table,$where = array(),$limit,$start,$where2,$order,$export_data){
		$start = ($start-1) * $limit;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		//pagination
		$dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where('pay_or_not','0');
        //$dynamicdb->where('auto_entry','0');
		$dynamicdb->where($where);
		//$this->db->limit($limit);
		//$dynamicdb->order_by($table.'.created_date', "desc");
		$dynamicdb->order_by($table.'.id', "desc");
		if($where2!=''){
		$dynamicdb->where($where2);
		}

		if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
		if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
		//$dynamicdb->order_by('id',$order);
		//$dynamicdb->limit($limit, $start);
        $query = $dynamicdb->get();
		// echo $dynamicdb->last_query();
		return $query->result_array();
	}

    public function Get_get_Sale_register_grand($table,$where = array(),$limit,$start,$where2,$order,$export_data){
        $start = ($start-1) * $limit;
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        //pagination
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where('pay_or_not','0');
        $dynamicdb->where($where);
        $dynamicdb->order_by($table.'.id', "desc");
        if($where2!=''){
        $dynamicdb->where($where2);
        }
        $query = $dynamicdb->get();
        //echo $dynamicdb->last_query();
        return $query->result_array();
    }

	public function get_supplier_Dtl($table,$where = array(), $limit, $start,$where2,$order){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		//pagination
		$start = ($start-1) * $limit;
		$dynamicdb->select("*");
		$dynamicdb->from('transaction_dtl');
        $dynamicdb->join('ledger', 'transaction_dtl.ledger_id = ledger.id');
		$dynamicdb->where($where);
		if($where2!=''){
			$dynamicdb->where($where2);
		}
		 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('ledger.id',$sort);
			}else{
				$dynamicdb->order_by('ledger.id',$order);
			}
		//$dynamicdb->order_by('id',$order);
		$dynamicdb->limit($limit, $start);
		//$dynamicdb->group_by('ledger.id');
        $query = $dynamicdb->get();
	//	echo $dynamicdb->last_query();die();
		return $query->result_array();
	}
	public function get_supplier_Dtl_COUNT($where = array(),$where2){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		//pagination
		$start = ($start-1) * $limit;
		$dynamicdb->select("*");
		$dynamicdb->from('transaction_dtl');
        $dynamicdb->join('ledger', 'transaction_dtl.ledger_id = ledger.id');
		$dynamicdb->where($where);
		if($where2!=''){
			$dynamicdb->where($where2);
		}
		 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('ledger.id',$sort);
			}else{
				$dynamicdb->order_by('ledger.id',$order);
			}
		//$dynamicdb->order_by('id',$order);
		$dynamicdb->limit($limit, $start);
		//$dynamicdb->group_by('ledger.id');
        $query = $dynamicdb->get();

		$result = $query->num_rows();
		return $result;
	}

	public function get_ledger_account_grp_Dtl($table,$created_by_id,$account_group_id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->or_where('created_by_cid',$created_by_id);
        //$this->db->or_where('created_by',0);
        $dynamicdb->or_where('id',$account_group_id);
        $query = $dynamicdb->get();
		return $query->result_array();
	}

	// public function get_ledger_Dtl($table,$where = array(), $limit, $start,$where2,$order,$export_data){
		// $start = ($start-1) * $limit;
		// $dynamicdb = $this->load->database('dynamicdb', TRUE);
		// $dynamicdb->select("*");
		// $dynamicdb->from('transaction_dtl');
        // $dynamicdb->join('ledger', 'transaction_dtl.ledger_id = ledger.id');
		// $dynamicdb->where($where);
		// if($where2!=''){
			// $dynamicdb->where($where2);
		// }
		 // if(isset($_GET['sort'])){
			// $sort=(string)$_GET['sort'];
			// $dynamicdb->order_by('ledger.id',$sort);
			// }else{
				// $dynamicdb->order_by('ledger.id',$order);
			// }
		// if($export_data == 0){
				// $dynamicdb->limit($limit, $start);
			// }
		// $dynamicdb->group_by('ledger.id');
	    // $query = $dynamicdb->get();
		// $data = $query->result_array();
		// foreach($data as $data_val){
			// $amount_total = get_total_user_amount_debit('transaction_dtl',$data_val["id"],$this->companyGroupId);
			// $amount_total_credit = get_total_user_amount_crdt('transaction_dtl',$data_val["id"],$this->companyGroupId);
			// $ledger_details = get_closing_balance($data_val["id"],$this->companyGroupId);
				// foreach($ledger_details as $ledger_dtls){
					// if($ledger_dtls['openingbalc_cr_dr'] == 1 ){
					 	// $leger_debit_ttl = $amount_total['sum(debit_dtl)'];
						// $opening_balance =  $ledger_dtls['opening_balance'];
						// $leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
						// $ledger_amt_aftr_calcu_cr = $leger_credit_ttl + $opening_balance;
						// $ledger_amt_aftr_calcu_dr = $leger_debit_ttl;
					// }
						// if($ledger_dtls['openingbalc_cr_dr'] == 0 ){
							// $leger_debit_ttl = $amount_total['sum(debit_dtl)'];
							// $opening_balance =  $ledger_dtls['opening_balance'];
							// $leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
							// $ledger_amt_aftr_calcu_dr = $leger_debit_ttl + $opening_balance;
							// $ledger_amt_aftr_calcu_cr = $leger_credit_ttl;
					// }
					// if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
						// $closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
						// }else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
						// $closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
					// }
					// if($closing_bal != 0 || $closing_bal !=''){
						// $Ledger_data = array(
							// 'id' => $data_val["id"],
							// 'ledger_id' => $data_val["ledger_id"],
							// 'debit_dtl' => $data_val["debit_dtl"],
							// 'credit_dtl' => $data_val["credit_dtl"],
							// 'type' => $data_val["type"],
							// 'type_id' => $data_val["type_id"],
							// 'add_date' => $data_val["add_date"],
							// 'cancel_restore' => $data_val["cancel_restore"],
							// 'save_status' => $data_val["save_status"],
							// 'created_by' => $data_val["created_by"],
							// 'created_by_cid' => $data_val["created_by_cid"],
							// 'created_date' => $data_val["created_date"],
							// 'supp_id' => $data_val["supp_id"],
							// 'name' => $data_val["name"],
							// 'account_group_id' => $data_val["account_group_id"],
							// 'parent_group_id' => $data_val["parent_group_id"],
							// 'conn_comp_id' => $data_val["conn_comp_id"],
							// 'compny_branch_id' => $data_val["compny_branch_id"],
							// 'opening_balance' => $data_val["opening_balance"],
							// 'due_days' => $data_val["due_days"],
							// 'sales_person' => $data_val["sales_person"],
							// 'openingbalc_cr_dr' => $data_val["openingbalc_cr_dr"],
							// 'enble_disbl_rcm' => $data_val["enble_disbl_rcm"],
							// 'mailing_address' => $data_val["mailing_address"],
							// 'contact_person' => $data_val["contact_person"],
							// 'phone_no' => $data_val["phone_no"],
							// 'mobile_no' => $data_val["mobile_no"],
							// 'fax' => $data_val["fax"],
							// 'email' => $data_val["email"],
							// 'cc' => $data_val["cc"],
							// 'website' => $data_val["website"],
							// 'registration_type' => $data_val["registration_type"],
							// 'gstin' => $data_val["gstin"],
							// 'pan' => $data_val["pan"],
							// 'activ_status' => $data_val["activ_status"],
							// 'edited_by' => $data_val["edited_by"],
							// 'modified_date' => $data_val["modified_date"],
							// 'Closing_balance' => $closing_bal
							// );
					// }
			// }
			// $Ledger_data2[] =  $Ledger_data;

		// }
		// return array_filter($Ledger_data2);
	// }
	public function get_ledger_Dtl($table,$where = array(), $limit, $start,$where2,$order,$export_data){
		//pagination
		$start = ($start-1) * $limit;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
        $dynamicdb->from($table);
      	$dynamicdb->where($where);
		//$dynamicdb->order_by($table.'.created_date', "desc");
		if($where2!=''){
		$dynamicdb->where($where2);
		}
		 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
		if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
		//$dynamicdb->order_by('id',$order);
		//$dynamicdb->limit($limit, $start);
	    $query = $dynamicdb->get();
		//echo $dynamicdb->last_query();

		return $query->result_array();
	}
	public function get_ledger_Dtl_count($where = array(),$where2){
		$start = ($start-1) * $limit;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);

		$dynamicdb->select("*");

        $dynamicdb->from('transaction_dtl');
        $dynamicdb->join('ledger', 'transaction_dtl.ledger_id = ledger.id');

      	$dynamicdb->where($where);

		if($where2!=''){
		$dynamicdb->where($where2);
		}
		 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('ledger.id',$sort);
			}else{
				$dynamicdb->order_by('ledger.id','DESC');
			}
		if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
		$dynamicdb->group_by('ledger.id');
	    $query = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$data = $query->result_array();
		foreach($data as $data_val){
			$amount_total = get_total_user_amount_debit('transaction_dtl',$data_val["id"],$this->companyGroupId);
			$amount_total_credit = get_total_user_amount_crdt('transaction_dtl',$data_val["id"],$this->companyGroupId);
			$ledger_details = get_closing_balance($data_val["id"],$this->companyGroupId);

				foreach($ledger_details as $ledger_dtls){

					if($ledger_dtls['openingbalc_cr_dr'] == 1 ){
					 	$leger_debit_ttl = $amount_total['sum(debit_dtl)'];
						$opening_balance =  $ledger_dtls['opening_balance'];
						$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
						$ledger_amt_aftr_calcu_cr = $leger_credit_ttl + $opening_balance;
						$ledger_amt_aftr_calcu_dr = $leger_debit_ttl;
					}
						if($ledger_dtls['openingbalc_cr_dr'] == 0 ){
							$leger_debit_ttl = $amount_total['sum(debit_dtl)'];
							$opening_balance =  $ledger_dtls['opening_balance'];
							$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
							$ledger_amt_aftr_calcu_dr = $leger_debit_ttl + $opening_balance;
							$ledger_amt_aftr_calcu_cr = $leger_credit_ttl;
					}
					if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
						$closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
						}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
						$closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
					}

					// pre($closing_bal);
					if($closing_bal != 0 || $closing_bal !=''){
						$Ledger_data1 = array(
							'id' => $data_val["id"],
							'ledger_id' => $data_val["ledger_id"],
							'debit_dtl' => $data_val["debit_dtl"],
							'credit_dtl' => $data_val["credit_dtl"],
							'type' => $data_val["type"],
							'type_id' => $data_val["type_id"],
							'add_date' => $data_val["add_date"],
							'cancel_restore' => $data_val["cancel_restore"],
							'save_status' => $data_val["save_status"],
							'created_by' => $data_val["created_by"],
							'created_by_cid' => $data_val["created_by_cid"],
							'created_date' => $data_val["created_date"],
							'supp_id' => $data_val["supp_id"],
							'name' => $data_val["name"],
							'account_group_id' => $data_val["account_group_id"],
							'parent_group_id' => $data_val["parent_group_id"],
							'conn_comp_id' => $data_val["conn_comp_id"],
							'compny_branch_id' => $data_val["compny_branch_id"],
							'opening_balance' => $data_val["opening_balance"],
							'due_days' => $data_val["due_days"],
							'sales_person' => $data_val["sales_person"],
							'openingbalc_cr_dr' => $data_val["openingbalc_cr_dr"],
							'enble_disbl_rcm' => $data_val["enble_disbl_rcm"],
							'mailing_address' => $data_val["mailing_address"],
							'contact_person' => $data_val["contact_person"],
							'phone_no' => $data_val["phone_no"],
							'mobile_no' => $data_val["mobile_no"],
							'fax' => $data_val["fax"],
							'email' => $data_val["email"],
							'cc' => $data_val["cc"],
							'website' => $data_val["website"],
							'registration_type' => $data_val["registration_type"],
							'gstin' => $data_val["gstin"],
							'pan' => $data_val["pan"],
							'activ_status' => $data_val["activ_status"],
							'edited_by' => $data_val["edited_by"],
							'modified_date' => $data_val["modified_date"],
							'Closing_balance' => $closing_bal
							);
					}
			}

			$Ledger_data_count21[] =  $Ledger_data1;

		}
		return array_filter($Ledger_data_count21);

	}



/****************************************************************************************************************************/
  /**********************************************Import Data Modal*******************************************************************/
/*************************************************************************************************************************************/
	public function importData($table,$data,$insertAccountledger="") {
		// $res = $this->db->insert_batch($table,$data);
		 	// if($res){
				// return TRUE;
				// }else{
				// return FALSE;
			// }
		if(!empty($data)){
			//pre($data);die();

			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			foreach($data as $dt){
				$this->db->insert($table,$dt);
				$insertedid = $this->db->insert_id();
				if($insertedid){
					$dt['id'] = $insertedid;
					$dynamicdb->insert($table,$dt);
					$lastId = $dt['id'];
					if( $insertAccountledger ){
						$this->createledgerAccount($dt,$lastId,$dynamicdb);
					}
				}
			}
		}
	return true;
}

function createledgerAccount($data,$lastId,$dynamicdb){
	if( $data['account_group_id'] == 54 ){
		$accountBilling = [];
		if( $data['mailing_address'] ){
			$dataMail =  json_decode($data['mailing_address'],true);
			$accountBilling = ['billing_street' => $dataMail[0]['mailing_address']??'','billing_zipcode' => $dataMail[0]['mailing_pincode']??'',
			'billing_country' => $dataMail[0]['mailing_country']??'','billing_state' => $dataMail[0]['mailing_state']??'',
			'billing_city' => $dataMail[0]['mailing_city']??'','gstin' => $dataMail[0]['gstin_no']??'' ];
		}
		$accountData = ['account_owner' => $this->companyGroupId,'ledger_id' => $lastId,'name' => $data['name'],
						'phone' => $data['mobile_no']??'','email' => $data['email']??'',
						'type' => $data['delarType']??'','purchaseLimit' => $data['purchaseLimit']??'',
						'save_status' => 1,'salesPersons'=> $data['salesPersons']??''] + $accountBilling;
						//,'customer_id' => $lastId
		$this->db->insert('account',$accountData);
		$insertedid = $this->db->insert_id();
		$dynamicdb->insert('account',$accountData);
	}
}




/************************************************************************************************************************************/
  /************************************Integration Inventory and account*******************************************************/
/**********************************************************************************************************************************/

	public function get_matrial_qty_invoice($table,$mat_idd,$locationId){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		  $dynamicdb->select('*');
          $dynamicdb->from($table);
		  $dynamicdb->where('material_name_id',$mat_idd);
		  $dynamicdb->where('location_id',$locationId);
		  $query = $dynamicdb->get();
          //echo $dynamicdb->last_query();die;
		 return $query->row_array();
	}

	public function get_matrial_details2($table,$mat_idd,$field){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		  $dynamicdb->select('*');
          $dynamicdb->from($table);
		  $dynamicdb->where($field,$mat_idd);
		  $query = $dynamicdb->get();
		 //sszz echo $dynamicdb->last_query();die();
		 return $query->row_array();
	}

	public function update_matrial_for_dilivery_challan($table,$mat_idd,$remaining_qty,$location_id){
	    $query = $this->db->query("UPDATE `mat_locations` SET `quantity`= '".$remaining_qty."' WHERE `material_name_id` = '".$mat_idd."' AND `location_id` = '".$location_id."'");
	    $dynamicdb = $this->load->database('dynamicdb', TRUE);
    	$query = $dynamicdb->query("UPDATE `mat_locations` SET `quantity`= '".$remaining_qty."' WHERE `material_name_id` = '".$mat_idd."' AND `location_id` = '".$location_id."'");
	}



	public function update_matrial_qty_invoice($table,$mat_idd,$remaining_qty,$locationIds){
	    $query = $this->db->query("UPDATE `mat_locations` SET `quantity`= '".$remaining_qty."' WHERE `material_name_id` = '".$mat_idd."' AND `location_id` = '".$locationIds."'");
	    $dynamicdb = $this->load->database('dynamicdb', TRUE);
    	$query = $dynamicdb->query("UPDATE `mat_locations` SET `quantity`= '".$remaining_qty."' WHERE `material_name_id` = '".$mat_idd."' AND `location_id` = '".$locationIds."'");
	}

	public function save_financial_year_date($table,$login_company_id,$start_date,$end_date){
		$fscal_date = array(array('start'=>$start_date,'end'=>$end_date));
		$fscal_Date_json = json_encode($fscal_date,true);
		$update_query = $this->db->query("update `".$table."` SET `financial_year_date` ='".$fscal_Date_json."' where `id` = '".$login_company_id."'");

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$update_query = $dynamicdb->query("update `".$table."` SET `financial_year_date` ='".$fscal_Date_json."' where `id` = '".$login_company_id."'");
		return $update_query;
	}
	public function remove_financial_year_date($table,$login_company_id){
		$update_query = $this->db->query("update  `".$table."` SET `financial_year_date` ='' where `id` = '".$login_company_id."'");
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
	    $dynamicdb->query("update  `".$table."` SET `financial_year_date` ='' where `id` = '".$login_company_id."'");
		return $update_query;
	}

	public function update_single_data_for_charges($charges_data,$invoice_idd,$table){
	   $query = $this->db->query("UPDATE ".$table." SET `charges_total_tax`= '".$charges_data."' WHERE `id` = '".$invoice_idd."'");
	   $dynamicdb = $this->load->database('dynamicdb', TRUE);
       $query = $dynamicdb->query("UPDATE ".$table." SET `charges_total_tax`= '".$charges_data."' WHERE `id` = '".$invoice_idd."'");
	}


	public function update_single_date_fun($datee,$invoice_idd,$table,$field){
	   $query = $this->db->query("UPDATE ".$table." SET ".$field." = '".$datee."' WHERE `id` = '".$invoice_idd."'");
	   $dynamicdb = $this->load->database('dynamicdb', TRUE);
       $query = $dynamicdb->query("UPDATE ".$table." SET ".$field." = '".$datee."' WHERE `id` = '".$invoice_idd."'");
	}


	public function update_single_saleOrder($table,$saleorder_idd){
	   $query = $this->db->query("UPDATE ".$table." SET `inv_or_not`= '1' WHERE `id` = '".$saleorder_idd."'");
	   $dynamicdb = $this->load->database('dynamicdb', TRUE);
       $query = $dynamicdb->query("UPDATE ".$table." SET `inv_or_not`= '1' WHERE `id` = '".$saleorder_idd."'");
	}






	// public function save_number_of_invoice_copeies($table,$field,$update_val,$login_company_id){
        // $this->db->set($field, $update_val);
        // $this->db->where('id', $login_company_id);
        // $this->db->update($table);
        // return $this->db->affected_rows();
    // }

	public function save_number_of_invoice_copeies($table,$field,$update_val,$login_company_id){
        $this->db->set($field, $update_val);
        $this->db->where('id', $login_company_id);
        $this->db->update($table);

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->set($field, $update_val);
        $dynamicdb->where('id', $login_company_id);
        $dynamicdb->update($table);
        return $this->db->affected_rows();
    }

    Public Function update_data_check($table,$inv_prfx_name_Data){
		$update_prifix_invoice = $this->db->query("update `".$table."` SET `address` ='".$inv_prfx_name_Data."' where `id` = '".$this->companyGroupId."'");

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$update_prifix_invoice = $dynamicdb->query("update `".$table."` SET `address` ='".$inv_prfx_name_Data."' where `id` = '".$this->companyGroupId."'");
		return $update_prifix_invoice;
	}

	Public Function update_email_Settings($table,$check_email_on_of,$login_company_id){
		if($check_email_on_of != '' ){
			//echo "update `".$table."` SET `email_send_setting` ='".$check_email_on_of."' where `id` = '".$login_company_id."'";die();
			$update_emails = $this->db->query("update `".$table."` SET `email_send_setting` ='".$check_email_on_of."' where `id` = '".$login_company_id."'");

			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$update_emails = $dynamicdb->query("update `".$table."` SET `email_send_setting` ='".$check_email_on_of."' where `id` = '".$login_company_id."'");
		}
		return $update_emails;
	}

	public function get_parent($table){
		$accountArray = array();
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from('account_group');
		$dynamicdb->where('parent_group_id',0);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();
		$resultParentGroups = $qry->result_array();

		if(!empty($resultParentGroups)){
			$i = 0;
			foreach($resultParentGroups as $resultParentGroup){
				$dynamicdb->select('id,name as account_group_name');
				$dynamicdb->from('account_group');
				$dynamicdb->where('parent_group_id',$resultParentGroup['id']);
				#$dynamicdb->where('created_by_cid',$_SESSION['loggedInUser']->c_id);
				$accountGroupQry = $dynamicdb->get();
				#echo $dynamicdb->last_query();
				$resultAccountGroups = $accountGroupQry->result_array();

				$accountArray[$i]['parent_id'] = $resultParentGroup['parent_group_id'] ;
				$accountArray[$i]['account_parent_id'] = $resultParentGroup['id'] ;
				$accountArray[$i]['parent_name'] =$resultParentGroup['name'] ;
				$accountArray[$i]['accounts'] = $resultAccountGroups ;
				$accountAm = 0;

				if(!empty($resultAccountGroups)){
					$j = 0;
					$amount = 0;
					foreach($resultAccountGroups as $resultAccountGroup){
						#$this->db->select('*');
						$dynamicdb->select('ledger.*, IFNULL(sum(transaction_dtl.debit_dtl),0) as drAmount , IFNULL(sum(transaction_dtl.credit_dtl),0) as crAmount');
						$dynamicdb->from('ledger');
						$dynamicdb->join('transaction_dtl', 'ledger.id = transaction_dtl.ledger_id','left');
						$dynamicdb->where('ledger.account_group_id',$resultAccountGroup['id']);
						$dynamicdb->where('ledger.created_by_cid',$this->companyGroupId);
						$dynamicdb->group_by('ledger.id');
						$accountGroupQry = $dynamicdb->get();
						//echo $dynamicdb->last_query();die();
						$resultLedgers = $accountGroupQry->result_array();
						$accountArray[$i]['accounts'][$j]['ledger'] = $resultLedgers ;
						$k = 0;
						if(!empty($resultLedgers)){
							foreach($resultLedgers as $rl){
								$accountArray[$i]['accounts'][$j]['accountCrAmount'] += $rl['crAmount'];
								$accountArray[$i]['accounts'][$j]['accountDrAmount'] += $rl['drAmount'];
								$k++;
							}
						}
						$accountArray[$i]['parentAccountCrAmount'] += $accountArray[$i]['accounts'][$j]['accountCrAmount'];
						$accountArray[$i]['parentAccountDrAmount'] += $accountArray[$i]['accounts'][$j]['accountDrAmount'];
						$j++;
					}
				}
				#echo $accountAm;
				$i++;
			}
		}
		#pre($accountArray);
		#pre($accountArray); die;
		return $accountArray;
	}


	public function createLedgerAccountViaAjax($table,$db_data) {
		$this->db->insert($table,$db_data);
		$insertedid = $this->db->insert_id();

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$db_data['id'] =  $insertedid;
		$dynamicdb->insert($table,$db_data);
		$dynamicdb->insert_id();
		return $insertedid;
	}

	// public function updateLedgerGroupNameViaAjax($table,$db_data,$field,$id) {
		// $this->db->where($field, $id);
        // $result = $this->db->update($table, $db_data);
		// return TRUE;
	// }

	public function updateLedgerGroupNameViaAjax($table,$db_data,$field,$id) {
		$this->db->where($field, $id);
        $result = $this->db->update($table, $db_data);

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
        $result = $dynamicdb->update($table, $db_data);


		return TRUE;
	}



	public function get_account_freeze_date($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		//echo $this->db->last_query();die();
		$result = $qry->result_array();
		return $result;
	}


	function profitLoss($created_by_id){
		/*$this->db->select('account_group.id as accountGroupId, account_group.name as accountGroupName, ledger.name as ledgerName , transaction_dtl.*');
		$this->db->from('transaction_dtl');
		$this->db->join('ledger', 'ledger.id = transaction_dtl.ledger_id');
		$this->db->join('account_group', 'account_group.id = ledger.account_group_id  ');
		$this->db->where('transaction_dtl.created_by_cid', 9 );
		$qry = $this->db->get();
		$result = $qry->result_array();	*/
		error_reporting(0);
		$accountArray = array();
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from('account_group');
		$dynamicdb->where('parent_group_id',0);
		$qry = $dynamicdb->get();

		$resultParentGroups = $qry->result_array();

		if(!empty($resultParentGroups)){
			$i = 0;
			foreach($resultParentGroups as $resultParentGroup){
				$dynamicdb->select('id,name as account_group_name');
				$dynamicdb->from('account_group');
				$dynamicdb->where('parent_group_id',$resultParentGroup['id']);
				$dynamicdb->where('created_by_cid',$this->companyGroupId);
				$dynamicdb->or_where('created_by_cid',0);
				$accountGroupQry = $dynamicdb->get();
				$resultAccountGroups = $accountGroupQry->result_array();
				$accountArray[$i]['parent_id'] = $resultParentGroup['parent_group_id'] ;
				$accountArray[$i]['parent_auto_id'] = $resultParentGroup['id'] ;
				$accountArray[$i]['parent_name'] =$resultParentGroup['name'] ;
				$accountArray[$i]['accounts'] = $resultAccountGroups ;
				#pre($resultAccountGroups);
				if(!empty($resultAccountGroups)){
					$j = 0;
					foreach($resultAccountGroups as $resultAccountGroup){
						$dynamicdb->select('ledger.id as ledgerId , ledger.name as ledgerName , sum(transaction_dtl.credit_dtl) as ledgerCreditAmount , sum(transaction_dtl.debit_dtl)  as ledgerDebitAmount , opening_balance');
						$dynamicdb->from('ledger');
						$dynamicdb->join('transaction_dtl', 'ledger.id = transaction_dtl.ledger_id ','left');
						$dynamicdb->where('ledger.account_group_id',$resultAccountGroup['id']);
						$dynamicdb->where('ledger.created_by_cid',$this->companyGroupId);
						$dynamicdb->group_by('transaction_dtl.ledger_id');
						$ledgerQry = $dynamicdb->get();
						//echo $dynamicdb->last_query();
						$resultLedgers = $ledgerQry->result_array();
						$accountArray[$i]['accounts'][$j]['ledger'] = $resultLedgers ;
						if(!empty($resultLedgers)){
							$k = 0;
							foreach($resultLedgers as $resultLedger){
								$dynamicdb->select('id as txId , debit_dtl , credit_dtl, sum(credit_dtl) as total_credit_amount, sum(debit_dtl) as total_debit_amount');
								$dynamicdb->from('transaction_dtl');
								$dynamicdb->where('ledger_id',$resultLedger['ledgerId']);
								$dynamicdb->where('created_by_cid',$this->companyGroupId);
								$txQry = $dynamicdb->get();

								$resultTransaction = $txQry->result_array();
								$accountArray[$i]['accounts'][$j]['ledger'][$k]['transaction'] = $resultTransaction ;
								$accountArray[$i]['accounts'][$j]['accountGroupCreditAmount'] += $resultLedger['ledgerCreditAmount'];
								$accountArray[$i]['accounts'][$j]['accountGroupDebitAmount'] += $resultLedger['ledgerDebitAmount'] ;
								$accountArray['opening_balance'] += $resultLedger['opening_balance'];
								$accountArray['creditAmount'] += $resultLedger['ledgerCreditAmount'];
								$accountArray['debitAmount'] += $resultLedger['ledgerDebitAmount'];
								$k++;
							}
						}
							$accountArray[$i]['parentCreditAmount'] += $accountArray[$i]['accounts'][$j]['accountGroupCreditAmount'] ;
							$accountArray[$i]['parentDebitAmount'] += $accountArray[$i]['accounts'][$j]['accountGroupDebitAmount'] ;

						$j++;
					}
				}

				$i++;
			}
		}
		#pre($accountArray); die;
		return $accountArray;
	}

	function get_cash_flow_data($where){


		$dynamicdb = $this->load->database('dynamicdb', TRUE);

		$query = $dynamicdb->query("SELECT  substring(
				concat('  January'
					  ,' February'
					  ,'    March'
					  ,'    April'
					  ,'      May'
					  ,'     June'
					  ,'     July'
					  ,'   August'
					  ,'September'
					  ,'  October'
					  ,' November'
					  ,' December'
					  )
				 , m*9 - 8
				 , 9 ) as period , transaction_dtl.debit_dtl as debit_amount,transaction_dtl.credit_dtl as credit_amount,transaction_dtl.*,ledger.* FROM
		(
			SELECT 1 as m
			UNION SELECT 2 as m
			UNION SELECT 3 as m
			UNION SELECT 4 as m
			UNION SELECT 5 as m
			UNION SELECT 6 as m
			UNION SELECT 7 as m
			UNION SELECT 8 as m
			UNION SELECT 9 as m
			UNION SELECT 10 as m
			UNION SELECT 11 as m
			UNION SELECT 12 as m
		) as Months
		  LEFT JOIN transaction_dtl  on Months.m = MONTH(transaction_dtl.created_date)  LEFT JOIN  ledger on ledger.id = transaction_dtl.ledger_id  AND  ".$where."
		ORDER BY Months.m");

		$result = $query->result_array();
		//echo $dynamicdb->last_query();
		return $result;

	}

		  // $dynamicdb->select('ledger.id as ledgerid, transaction_dtl.*,ledger.*');
		  // $dynamicdb->from('ledger');
		  // $dynamicdb->join('transaction_dtl', 'ledger.id = transaction_dtl.ledger_id','LEFT');


/* For update UOM in table*/
function updateRowWhere($table, $where = array(), $data = array()) {

    $this->db->where($where);
    $this->db->update($table, $data);

    if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($where);
			$dynamicdb->update($table, $data);
		}

    // echo $dynamicdb->last_query();die();
}

	/*change status in Ledgers when click on toggle */
	public function change_status_toggle($id, $status) {
		$this->db->where('id', $id);
		$status = array('activ_status' => $status);
		$this->db->update('ledger', $status);
		//echo $this->db->last_query();
		if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('id', $id);
			$dynamicdb->update('ledger', $status);
			//echo $this->db->last_query();die();
		}
		return true;
	}

public function update_single_field($table, $data, $materialId) {
	 $db_data = $this->get_field_type_data($data, $table);
      $data = $db_data;
        $this->db->where('location_id', $data['location_id']);
        $this->db->where('RackNumber', $data['RackNumber']);
        $this->db->where('material_name_id', $materialId);
        $this->db->update('mat_locations', $db_data);
       # echo $this->db->last_query();
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('location_id', $data['location_id']);
            $dynamicdb->where('material_name_id', $materialId);
            $dynamicdb->where('RackNumber', $data['RackNumber']);
            $dynamicdb->update('mat_locations', $db_data);
        }
       # echo $dynamicdb->last_query();
        return true;
    }


	/****************************************For Aging Report ************************************************/
	public function get_invoice_details_aging_report($table = '' ,$where = array(),$limit, $start,$where2,$order,$export_data,$over_Due_invoice) {
		//pagination
		$start = ($start-1) * $limit;

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		if($where2!='')
		{
		$dynamicdb->where($where2);
		}
		 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}

		if(isset($over_Due_invoice)){
			$dynamicdb->where($table.'.due_date <= DATE(NOW())');
		}
		$dynamicdb->order_by('due_date' , "DESC");
		//$dynamicdb->limit($limit, $start);
		//SELECT * FROM `invoice` WHERE `created_by_cid` = '3' AND `invoice`.`created_date` >= '2020-04-01' AND `invoice`.`created_date` <= '2021-03-31' AND `invoice`.`pay_or_not` = 0 AND  `invoice`.`due_date` >= DATE(NOW()) ORDER BY `due_date` ASC
		if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result_array();
		return $result;
	}

	/****************************************For Aging Report ************************************************/
	/****************************************For Credit Note ************************************************/
	public function not_paid_InvoiceForReturn($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$dynamicdb->where('pay_or_not','0');
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->row();
		return $result;
	}

	public function get_credit_debitDATA($table = '' , $created_id, $limit, $start,$where,$order,$where_row) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		//pagination
		$start = ($start-1) * $limit;
		//query
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->group_start();
		$dynamicdb->where($where_row);

		$dynamicdb->group_end();
		if($where!=''){
		$dynamicdb->where($where);
		}
		 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
		$dynamicdb->limit($limit, $start);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die;
		$result = $qry->result_array();
		return $result;
	}
	/****************************************For Credit Note ************************************************/


	public function emailExistUSER($email){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from('user');
		$dynamicdb->where('email',$email);
		$qry = $dynamicdb->get();
		 $result = $qry->row();
        return $result;
	}


	public function not_paid_InvoiceForLIMIT($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);

		$dynamicdb->where('pay_or_not','0');
		if($invoiceid !=''){
			$dynamicdb->where_not_in('id',$invoiceid);
		}
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result();
		return $result;
	}
	public function not_paid_InvoiceForTDS($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
	//	$dynamicdb->where('pay_or_not','0');
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->result();
		return $result;
	}

	public function update_salesPersonjson($spersondata,$ledgerID){
	   $query = $this->db->query("UPDATE `ledger` SET `salesPersons`= '".$spersondata."' WHERE `id` = '".$ledgerID."'");
	   $dynamicdb = $this->load->database('dynamicdb', TRUE);
       $query = $dynamicdb->query("UPDATE `ledger` SET `salesPersons`= '".$spersondata."' WHERE `id` = '".$ledgerID."'");
	}


	  public function get_image_byId($table, $field, $id,$type) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where($field, $id);
            $this->db->where('rel_type', $type);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($field, $id);
            $dynamicdb->where('rel_type', $type);
            $qry = $dynamicdb->get();
        }
        $result = $qry->result_array();
        return $result;
    }

	public function get_so_details($table = '' , $where = array()) {
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		//$this->db->or_where('accept_reject','');
		$qry = $dynamicdb->get();
		$result = $qry->row();
		return $result;
	}

	public function completeInvoice($data){
		$this->db->where('id', $data['id']);
		$completeSaleOrderData = array('complete_status' => $data['complete_status'],'partially_complete_status' => $data['partially_complete_status']);
		$this->db->update('invoice', $completeSaleOrderData );
		if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('id', $data['id']);
			$dynamicdb->update('invoice', $completeSaleOrderData );
		}
		return true;
	}


	public function update_sO_material_data($table,$id,$update_data) {
		$this->db->where('id', $id);
		$status = array('product' => $update_data);
		$this->db->update($table, $status);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $id);
		$dynamicdb->update($table, $status);
		// echo $dynamicdb->last_query();die();
		return true;
	}

	public function update_so_single_data($table,$id) {
		$this->db->where('id', $id);
		$status = array('inv_or_not' => 1);
		$this->db->update($table, $status);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $id);
		$dynamicdb->update($table, $status);
		return true;
	}


	public function getSingleInvoiceData($id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('invoice.invoice_num,invoice.party_state_id,invoice.sale_L_state_id,invoice.gstin as buyer_gstin,invoice.transport,invoice.transport_name,invoice.distance,invoice.supply_type,invoice.descr_of_goods,invoice.invoice_total_with_tax,invoice.total_amount,buyer_ledger.mailing_address as buyer_mailing_address,seller_details.address as seller_mailing_address,invoice.sale_leger_gstin_no as seller_gstin,invoice.date_time_of_invoice_issue,invoice.e_invoice_link,invoice.invoice_total_with_tax,invoice.charges_added,invoice.vehicle_reg_no,invoice.transport_gstin,invoice.party_name,invoice.sale_lger_brnch_id,invoice.dispatch_document_no,invoice.dispatch_document_date,invoice.CGST,invoice.SGST,consignee_ledger.mailing_address as consignee_mailing_address,invoice.consignee_state_id,invoice.consignee_name,invoice.irn_number,invoice.eway_bill_no,invoice.e_way_bill_link');
		$dynamicdb->from('invoice');
		$dynamicdb->join('ledger as buyer_ledger', 'buyer_ledger.id = invoice.party_name','LEFT');
		$dynamicdb->join('ledger as seller_ledger', 'seller_ledger.id = invoice.sale_ledger','LEFT');
		$dynamicdb->join('ledger as consignee_ledger', 'consignee_ledger.id = invoice.consignee_name','LEFT');
		$dynamicdb->join('company_detail as seller_details', 'seller_details.id = invoice.created_by_cid','LEFT');
		$dynamicdb->where('invoice.id',$id);
		$query = $dynamicdb->get();
		return $result12 = $query->row_array();

	}

	public function update_data_invoice_data($table,$db_data,$field,$id){
		$this->db->where($field, $id);
        $result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
        $result = $dynamicdb->update($table, $db_data);
		return TRUE;

	}

	public function update_so_data_chk($table,$db_data,$field,$id) {
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);
		$this->db->update($table, $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->update($table, $data);
		// echo $dynamicdb->last_query();die();
		return TRUE;
	}


	function get_sale_order_data($where = array()){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('so.id as soid, so.*');
		$dynamicdb->from('sale_order so');
		$dynamicdb->join('account ap', 'ap.id = so.account_id','inner');
		$dynamicdb->where($where);
		$dynamicdb->order_by('so.id','DESC');
		$qry = $dynamicdb->get();
		$result = $qry->result();
		 //echo $dynamicdb->last_query();
		return $result;
	}
	public function update_mat_single_data($table,$id,$value,$last_rate) {
		$this->db->where('id', $id);
		$val = array('last_sale_date' => $value,'last_invoice_rate' => $last_rate);
		$this->db->update($table, $val);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $id);
		$dynamicdb->update($table, $val);
		return true;
	}

	function updateMultiData($table,$where,$data){
        $this->db->where($where);
        $this->db->update($table,$data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where($where);
        $dynamicdb->update($table,$data);
        return $this->db->affected_rows();

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
		$sql = $sql->get();
		/*echo $dynamicdb->last_query();
		die;*/
		return $sql->result_array();
	}

	public function update_single_field_mat($table, $data, $materialId) {
	   $db_data = $this->get_field_type_data($data, $table);
       $data = $db_data;
        $this->db->where('location_id', $data['location_id']);
        $this->db->where('RackNumber', $data['RackNumber']);
        $this->db->where('material_name_id', $materialId);
        $this->db->update('mat_locations', $db_data);
       # echo $this->db->last_query();
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('location_id', $data['location_id']);
            $dynamicdb->where('material_name_id', $materialId);
            $dynamicdb->where('RackNumber', $data['RackNumber']);
            $dynamicdb->update('mat_locations', $db_data);
        }
       # echo $dynamicdb->last_query();die;
        return true;
    }

    public function insertData($table,$data){
    	$this->db->insert($table,$data);
    	$id = $this->db->insert_id();
    	$dynamicdb = $this->load->database('dynamicdb', TRUE);
    	if( $id ){
    		$dynamicdb->insert($table,$data);
    		return $dynamicdb->insert_id();
    	}
    }

    public function get_ledeger_by_name($table,$ledger_name,$created_by,$created_by_cid){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where('name',$ledger_name);
		//$dynamicdb->where('created_by_cid', $created_by_cid);
		//$dynamicdb->where('created_by', $created_by);
		$query = $dynamicdb->get();
		return $result12 = $query->row_array();

	}

	public function update_transaction_data_chk_new($table,$db_data,$field,$id,$type,$ledger_id) {
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);
		$this->db->where('ledger_id', $ledger_id);
		$this->db->where('type', $type);
		$this->db->update($table, $data);

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->where('ledger_id', $ledger_id);
		$dynamicdb->where('type', $type);
		$dynamicdb->update($table, $data);
		return TRUE;
	}

	public function get_purcahse_report_details($table,$where_details){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($where_details);
		//$dynamicdb->order_by('DATE_FORMAT(transaction_dtl.add_date, "%m")');
		//$dynamicdb->order_by('DATE_FORMAT(transaction_dtl.add_date, "%Y" "%m") = 04 DESC');
		$dynamicdb->order_by('date_format(transaction_dtl.add_date,  "%Y-%m-%d") DESC');
		$qry = $dynamicdb->get();
		$result = $qry->result();
		return $result;

	}

	public function getPriceListData($table = '' , $where = array(), $limit = ''){
		if($_SESSION['loggedInUser']->role == 3){
			$table = $table?$table:$this->tablename;
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where($where);
			if($limit !='')
			$this->db->limit($limit);
			$this->db->order_by('id', "desc");
			$qry = $this->db->get();
			$result = $qry->result_array();
			return $result;
		}else{
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			//echo $table;
			$dynamicdb->where($where);
			if($limit !='')
			$dynamicdb->limit($limit);
			$dynamicdb->order_by('id', "desc");
			$qry = $dynamicdb->get();
			$result = $qry->result_array();
			// echo $dynamicdb->last_query();die();
			return $result;
		}
	}
	
	
	public function updateNewSaleTarget($table,$where = array(),$db_data){
		
		$this->db->where($where);
		$result = $this->db->update($table, $db_data);
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($where);
			$dynamicdb->update($table, $db_data);
			// echo $dynamicdb->last_query();die();
	     	return $result;
	}
	public function get_HSNSACMASTERDATA($table = '', $where = array(), $limit = '') {
        $table = $table ? $table : $this->tablename;
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where($where);
        $qry = $dynamicdb->get();
		// echo $dynamicdb->last_query();die();
        $result = $qry->result_array();
        return $result;
    }


}//main
