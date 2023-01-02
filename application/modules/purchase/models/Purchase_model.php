<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class purchase_model extends ERP_Model {
	var $column_search = array('indent_code','grand_total','departments','required_date','material_name'); //set column field database for datatable searchable
         var $order = array('id' => 'DESC'); // default order
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tablename = 'material';
        //$this->column_search = array('name');
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

    } 




	public function get_field_type_data($data, $type){
		switch($type){
			 case 'company_detail':
				$all_fields = array('purchase_term_conditions' );
				break;
			case 'material':
				$all_fields = array('material_type_id','material_name','material_code','hsn_code','specification','inventory_amount','inventory_unit','prefix','tax','created_by','created_by_cid');
				break;
			case 'supplier':
				$all_fields = array('supplier_code','name','address','country','city','state','gstin','contact_detail','material_type_id','material_name_id','website','bank_name','branch_name','account_no','ifsc_code','other','created_by','created_by_cid','edited_by','supp_account_group_id','mailing_name','save_status','favourite_sts');
				break;
				case 'controlled_report_master':
				$all_fields = array('report_name','saleorder','material_id','created_date','created_by','created_by_cid','final_report');
				break;
			case 'ledger':
				$all_fields = array('supp_id','name','website','gstin','account_group_id','parent_group_id','mailing_address','created_by','created_by_cid');
				break;
			case 'purchase_indent':
				#$all_fields = array('indent_code','material_type_id','material_name','preffered_supplier','grand_total','inductor','specification','other','departments','required_date','poCreate','created_by','approve','disapprove','validated_by','disapprove_reason','created_by_cid','po_or_not','edited_by','save_status');
				$all_fields = array('sale_order_id','work_order_id','indent_code','material_name','preffered_supplier','grand_total','inductor','specification','other','departments','required_date','delivery_address','poCreate','created_by','validated_by','disapprove_reason','created_by_cid','po_or_not','mrn_or_not','edited_by','save_status','company_unit','ifbalance','status','approve','purchase_type');
				break;
			case 'purchase_order':
				$all_fields = array('pi_id','order_code','supplier_name','material_name','grand_total','payment_terms','delivery_address','payment_date','date','expected_delivery_date','terms_delivery','freight','charges_added','terms_conditions','created_by','created_by_cid','mrn_or_not','save_status','edited_by','party_billing_state_id','other_charges','company_unit','ifbalance','status','date', 'purchase_type','selectApproveUsers','is_purchase_date','open_purchase_from','open_purchase_to');
				break;
				case 'work_order':
				$all_fields = array('work_order_material_status');
				break;
			case 'purchase_bill':
				$all_fields = array('supplier_name','supp_address','driver_phone','vehicle_reg_no','ifsc_code','gstin','created_by','edited_by','message_for_email','date','gstin','descr_of_bills','edited_by','bill_attachment_files','total_amount','product_detail','party_name','totaltax_total','CGST','SGST','IGST','created_by_cid','invoice_total_with_tax','save_status','save_status','charges_added','auto_entry','throu_pi_or_not','grand_total');
				break;
			case 'charges_lead':
				$all_fields = array('particular_charges','ledger_id','type_charges','tax_slab','created_by_cid','created_by_uid','hsnsac','amount_of_charges','charges_for');
				break;
			case 'mrn_detail':
				$all_fields = array('po_id','supplier_name','is_quality_check','material_name','grand_total','payment_terms','delivery_address','payment_date','received_date','date','terms_delivery','freight','charges_added','terms_conditions','rating','comments','created_by','created_by_cid','save_status','bill_no','bill_date','pi_id','party_billing_state_id','other_charges','company_unit','ifbalance','status','gate_id','purchase_type','cost_center','due_days');
				break;
			case 'voucher':
				$all_fields = array('voucher_name','credit_debit_party_dtl','edited_by','created_by','narration','total','type','created_by_cid','auto_entry');
				break;
			case 'user_dashboard':
				$all_fields = array('graph_id','user_id','show');
				break;
			case 'attachments':
				$all_fields = array('rel_type','rel_id','file_type','file_name');
				break;
			case 'purchase_budget':
				$all_fields = array('material_type_id','budget','created_by_cid');
				break;
			case 'purchase_budget':
				$all_fields = array('material_type_id','budget','created_by_cid');
				break;
			case 'material_type':
				$all_fields = array('budget');
				break;
			case 'inventory_flow':
                $all_fields = array('material_type_id','current_location','new_location','material_id', 'material_in', 'material_out', 'uom', 'through', 'ref_id', 'uom', 'created_by', 'created_by_cid', 'location','comment' , 'closing_blnc' , 'opening_blnc');
			break;
			case 'purchase_rfq':
				$all_fields = array('product_induction_id','product_id','supplier_id','supplier_expected_amount','created_by','supplier_expected_deliv_date');
				break;

			 case 'mat_locations':
                $all_fields = array('location_id', 'Storage', 'RackNumber', 'quantity', 'Qtyuom', 'created_by_cid', 'material_type_id', 'material_name_id', 'physical_stock', 'balance');
            break;
            case 'purchase_budget_limit':
				$all_fields = array('budget_limit','created_by','edited_by','created_by_cid');
				break;
			  case 'challan_dilivery':
				$all_fields = array('party_name','sale_ledger','consignee_address','party_phone','challan_num','challan_date','vehicle_reg_no','created_by','created_by_cid','sale_lger_brnch_id','created_by','edited_by','challan_total_amt','descr_of_goods','challan_type','terms_of_delivery','transporter_phone','puo_id','auto_entry_po');
				break;

			 case 'lot_details':
            $all_fields = array( 'lot_number', 'mat_type_id', 'mat_id', 'active_inactive', 'quantity', 'mou_price', 'date', 'mrp_price', 'created_by', 'created_by_cid');
            break;
			case 'material_old_price':
                $all_fields = array('material_type_id', 'old_sales_price', 'new_sales_price','created_by');
            break;

			default:
				$all_fields = array('subject','contactid','department','service','status','userid','adminreplying' , 'email' , 'name','priority','ticketkey','message','admin','project_id','lastReply','clientread','adminread','ip','assigned');


		}
		return $data = format_data_to_be_added($all_fields, $data);
	}



	/*****************query use in pruchase setting budgeting***********************/
	public function get_data_bymaterial($table = '',$where = array(),$limit,$start,$where2, $order){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		//pagination
		$start = ($start-1) * $limit;
		$dynamicdb->select('*');
		$dynamicdb->from($table);
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

		$dynamicdb->limit($limit, $start);
		$dynamicdb->order_by('id',$order);
		$dynamicdb->group_by($table.'.id');
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		//echo $dynamicdb->last_query();die();
		$material_arrayId = array();
		$i = 0;
		foreach($result as $res){
			$material_Id = $res['id'];
			$query = "SELECT status , SUM(purchase_indent.grand_total) as PiTotal  from purchase_indent WHERE material_type_id = '".$material_Id."' AND approve = 1 AND created_by_cid ='".$this->companyGroupId."'
			UNION
			SELECT status , SUM(purchase_order.grand_total) as PoTotal  from purchase_order WHERE material_type_id = '".$material_Id."' AND created_by_cid ='".$this->companyGroupId."'
			UNION
			SELECT status , SUM(mrn_detail.grand_total) as MRNTotal from mrn_detail WHERE material_type_id = '".$material_Id."' AND created_by_cid ='".$this->companyGroupId."'";
			$result = $dynamicdb->query($query);
			$material_issue_result = $result->result_array();
			$material_arrayId[$i]['id'] = $res['id'];
			$material_arrayId[$i]['name'] = $res['name'];
			$material_arrayId[$i]['budget'] = $res['budget'];
			$material_arrayId[$i]['Pitotal'] = $material_issue_result[0]['PiTotal'];
			$material_arrayId[$i]['PoTotal'] = $material_issue_result[1]['PiTotal'];
			$material_arrayId[$i]['MRNTotal'] = $material_issue_result[2]['PiTotal'];
			$material_arrayId[$i]['payment'] = $material_issue_result[0]['status'];
			$i++;
		}
		return $material_arrayId;
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

	function updateByWhereIn($table,$data,$field,$where){
		/*$this->db->where_in($field,$where);
		$result = $this->db->update($table, $data);*/
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where_in($field,$where);
		$dynamicdb->update($table, $data);
		return $dynamicdb->affected_rows();
	}

	public function checkApprovematerial($where){
			$where = implode(',',$where);
			$sql = "SELECT MIN(IF(`approved`,TRUE,FALSE)) as checkApproved FROM material_type WHERE id IN({$where})";
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$data = $dynamicdb->query($sql)->row_array();
			return $data['checkApproved'];

	}

	public function approvedMaterial( $approve ){

		if( $approve ){
			$approve = 1;
		}else{
			$approve = 0;
		}
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$sql = "SELECT id,name FROM material_type WHERE approved = {$approve} AND (created_by_cid = {$this->companyGroupId} OR created_by_cid = 0)";
		return $dynamicdb->query($sql)->result_array();
	}


	/*material code*/
	 /* Function to fetch Data od material */
		public function get_data($table = '' , $where = array() , $limit ='') {
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			if($table=="material_type" || $table == "mat_locations"){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}else if($table=="supplier"){
					$dynamicdb->select($table.'.*,'.$table.'.id as supplier_id,material.material_name as material_name');
					$dynamicdb->from($table);
					$dynamicdb->join("material", $table . ".material_name_id = material.id", 'left');
					$dynamicdb->order_by('supplier_id','DESC');
			}
			else{
				// $this->db->select($table.'.*,material_type.name as materialType');
				// $this->db->from($table);
				// $this->db->join("material_type", $table . ".material_type_id = material_type.id", 'left');
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}
			$dynamicdb->where($where);
			$dynamicdb->order_by('id', "desc");
			$qry = $dynamicdb->get();
			$result = $qry->result_array();
			 if($table=="permissions"){
				$tempArr = array_unique(array_column($result, 'user_id'));
				$result = array_intersect_key($result, $tempArr);
			}
			return $result;
		}

		public function get_filter_details($table = '' , $where = array() , $limit ='') {
				$dynamicdb = $this->load->database('dynamicdb', TRUE);
				$dynamicdb->select('*');
				$dynamicdb->from($table);
				$dynamicdb->where($where);
				$qry = $dynamicdb->get();
				$result = $qry->result_array();
				return $result;
		}
	public function get_export_details($table = '' ,$where = array(),$limit = '') {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$dynamicdb->order_by($table.'.created_date', "desc");
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		return $result;
	}

	/* Insert Data */
		public function insert_tbl_data($table,$data) {
		$fieldData = $this->get_field_type_data($data,$table);
		$this->db->insert($table,$fieldData);
		// echo $this->db->last_query();die();
		$insertedid = $this->db->insert_id();
		if($insertedid){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$fieldData['id'] = $insertedid;
			$dynamicInsertedid = $dynamicdb->insert($table,$fieldData);
		}

		 // echo $dynamicdb->last_query();die;
		return $insertedid;

		}
		
		

		// public function insert_tbl_data1($table,$data) {

		// 	#pre($data);

		// $fieldData = $this->get_field_type_data($data,$table);

		// #pre($fieldData);
		// #die;
		// $this->db->insert($table,$fieldData);
		// //echo $this->db->last_query();die();
		// $insertedid = $this->db->insert_id();
		// if($insertedid){
		// 	$dynamicdb = $this->load->database('dynamicdb', TRUE);
		// 	$fieldData['id'] = $insertedid;
		// 	$dynamicInsertedid = $dynamicdb->insert($table,$fieldData);
		// }

		// echo $dynamicdb->last_query();die;
		// return $insertedid;

		// }

	/*Update Data*/
		public function update_data($table,$db_data,$field,$id) {

		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);
		$result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->update($table, $db_data);
		// echo $dynamicdb->last_query();die;
		return true;
	}

	/*update ledger*/
	public function update_ledger_data($table,$db_data,$field,$id) {
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		//$this->db->where($field, $id);
		$this->db->where('supp_id', $id);
		$result = $this->db->update($table, $db_data);
		//echo $this->db->last_query();die();
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$db_data = $this->get_field_type_data($db_data, $table);
		$dynamicdb->where('supp_id', $id);
		$result = $dynamicdb->update($table, $db_data);
		return true;
	}

	public function update_pI_material_data($table,$id,$update_data) {
		$this->db->where('id', $id);
		$status = array('material_name' => $update_data);
		$this->db->update($table, $status);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $id);
		$dynamicdb->update($table, $status);
		return true;
		}

	/*Update Data*/
	public function update_single_field($table,$data,$field,$id) {
		$this->db->where($field, $id);
		//$data = array($field => $val);
		$this->db->update($table, $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->update($table, $data);
		//echo $this->db->last_query();die();
		 return true;
	 }
	/*Update Data*/
		// public function update_po_single_data_pi_ornot($table,$id) {
			// $this->db->where('id', $id);
			// $status = array('throu_pi_or_not' => $id);
			// $this->db->update($table, $status);
			//echo $this->db->last_query();die();
			// return true;
		// }
		public function update_pI_single_data($table,$id) {
			$this->db->where('id', $id);
			$status = array('po_or_not' => 1);
			$this->db->update($table, $status);
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('id', $id);
			$dynamicdb->update($table, $status);
			return true;
		}
	public function update_po_single_data($table,$id) {
		$this->db->where('id', $id);
		$status = array('mrn_or_not' => 1);
		$this->db->update($table, $status);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $id);
		$dynamicdb->update($table, $status);
		return true;
	}


	public function update_payment_data_po_mrn($table,$id,$tbl_fld) {
		$this->db->where($tbl_fld, $id);
		$status = array('pay_or_not' => 1);
		$this->db->update($table, $status);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($tbl_fld, $id);
		$dynamicdb->update($table, $status);
		return true;
	}

	 /* Function to fetch Data by Id of material */
		public function get_data_byId($table ,$field, $id) {
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			if($table=="material" || $table=="purchase_indent" || $table=="purchase_order" || $table=="mrn_detail" ){
				$dynamicdb->select($table.'.*, material_type.name as materialtype ');
				$dynamicdb->from($table);
				$dynamicdb->join("material_type", $table . ".material_type_id = material_type.id", 'left');
			}else if($table == 'supplier' || $table == 'ledger'){
				$dynamicdb->select($table.'.*,'.$table.'.id as supplier_id, material.material_name as material_name');
				$dynamicdb->from($table);
				$dynamicdb->join("material", $table . ".material_name_id = material.id", 'left');
			}else if($table == 'charges_lead' || $table == 'purchase_rfq' || $table == 'purchase_budget_limit'){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}else if($table == 'material_type'){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}
			$dynamicdb->where($table.'.'.$field, $id);
			$qry = $dynamicdb->get();
			 // echo $this->dynamicdb->last_query(); die;
			$result = $qry->row();
			return $result;
		}
		public function get_ledger_Data($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->where($table.'.'.$field, $id);
			$qry = $dynamicdb->get();
			$result = $qry->row();
			return $result;

	}

	/*function to fetch id proof by id*/
	public function get_idproof_by_supplierId($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($field, $id);
		$dynamicdb->where('rel_type', 'supplier');
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		return $result;
	}
	/*Add Document In PI PO And  MRN*/
	public function get_docs_in_PI_PO_MRN($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($field, $id);
		$dynamicdb->where('rel_type', 'PI_PO_MRN');
		//$this->db->where('rel_type', 'material');

		$qry = $dynamicdb->get();
		/*echo $this->db->last_query(); die;*/
		$result = $qry->result_array();
		return $result;
	}

	/*Add Document In PI PO And  MRN*/


	/*function to ftech iamge by id*/
	public function get_idproof_by_materialId($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($field, $id);
		$dynamicdb->where('rel_type', 'material');
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		return $result;
	}
	/*Function to delete data from selected Table */
	public function delete_data($table ,$field ,$id) {
		$this->db->where($field, $id);
		$this->db->delete($table);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field, $id);
		$dynamicdb->delete($table);
		return $this->db->affected_rows();
		//return true;
	}




	/*delete from supplier as well as ledger*/
	public function delete_data_from_supplierLedger($table ,$field ,$id) {
		$this->db->where('id', $id);
		$this->db->delete('supplier');
		$this->db->where('supp_id', $id);
		$this->db->delete('ledger');
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $id);
		$dynamicdb->delete('supplier');
		$dynamicdb->where('supp_id', $id);
		$dynamicdb->delete('ledger');
		return true;
	}
	/* Insert attachment Data */
	public function insert_attachment_data($table , $data = array(), $type) {
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
	/*GSTIn exist*/
	public function gstinExist($gstin,$update = '' ){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('gstin');
		$dynamicdb->from('supplier');
		$dynamicdb->where('gstin',$gstin);
	//	if($update == ''){
	//		$this->db->where('created_by_cid',$_SESSION['loggedInUser']->c_id);
	//	}else{
	//		$this->db->where('created_by_cid != ',$_SESSION['loggedInUser']->c_id);
	//	}

		$qry = $dynamicdb->get();
		$result = $qry->row_array();
		return $result;
	}



	/*get datab by id from company in po and mrn */
		public function get_data_byAddress($table,$where = array()){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		return $result;
	}

	/*change status fucntion
	public function change_status($id, $status, $comment) {
		$this->db->where('id', $id);
		//$status = array('status' => $status);
		$status = array('status' => $status, 'comment' => $comment);

		$this->db->update('purchase_indent', $status);

		return true;

	}	*/
	public function approveSaleOrder($data) {
		$this->db->where('id', $data['id']);
		$approveData = array('approve' => $data['approve'],'validated_by' =>  $data['validated_by'] ,'disapprove' => 0 ,'disapprove_reason' => '');
		$this->db->update('purchase_indent', $approveData );
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $data['id']);
		$dynamicdb->update('purchase_indent', $approveData );
		return true;
	}
	
	public function approvePurchaseOrder($data) {
		$this->db->where('id', $data['id']);
		$approveData = array('approve' => $data['approve'],'validated_by' =>  $data['validated_by'] ,'disapprove' => 0 ,'disapprove_reason' => '');
		$this->db->update('purchase_order', $approveData );
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $data['id']);
		$dynamicdb->update('purchase_order', $approveData );
		return true;
	}
	public function disApprovePurchaseOrder($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('purchase_order', $data );
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $data['id']);
		$dynamicdb->update('purchase_order', $data );
		return true;
	}

	public function disApproveSaleOrder($data) {
		$this->db->where('id', $data['id']);
		//$approveData = array('approve' => 0,'validated_by' =>  $data['validated_by'] ,'disapprove' => 1, 'disapprove_reason' =>'');
		$this->db->update('purchase_indent', $data );
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $data['id']);
		$dynamicdb->update('purchase_indent', $data );
		return true;
	}

	public function count_total_rating($where){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
	   $dynamicdb->select('AVG(ratings) as average');

    $dynamicdb->where('id', $where);
    $dynamicdb->from('mrn_detail');


    return $query = $dynamicdb->get()->result_array();


	//
	}
	/*public function get_rating_data($blogid)
	{
    $this->db->select('*');
    $this->db->from('users u');
    $this->db->join('rating r', 'r.user_id = u.user_id');
    $this->db->where('blog_id', $blogid);
    return $query = $this->db->get()->result();
	}
*/



public function update_user_graph_data($table ,$data) {
		$db_data = $this->get_field_type_data($data, $table);
		$this->db->where('user_id', $data['user_id']);
		$this->db->where('graph_id', $data['graph_id']);
		$result = $this->db->update($table, $db_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('user_id', $data['user_id']);
		$dynamicdb->where('graph_id', $data['graph_id']);
		$dynamicdb->update($table, $db_data);
		return true;

}

	/* Function to fetch Data by Id of material */
	public function get_tbl_data_byId($table ,$field, $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($table.'.'.$field, $id);
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		return $result;
	}

	/*single data fetched**/
	function visitor_count($table) {
	$dynamicdb = $this->load->database('dynamicdb', TRUE);
	$dynamicdb->select('COUNT(*)');
	$dynamicdb->from($table);

	$query = $dynamicdb->get();
    return $query->row_array();
	}

	/*name of material type fetched
	function coulmn_count($table) {
	//$this->db->select('material_type,count(*) AS materialTypeCount');
	$this->db->select('material_type.name as materialType,count(*) AS materialTypeCount');
	$this->db->from($table);
	//$this->db->where('material_type',1);
	$this->db->join("material_type", $table . ".material_type = material_type.id", 'left');
	$this->db->group_by('material_type.id');
	$query = $this->db->get();
	//pre($this->db->last_query());
    return $query->result_array();
	}

	/*single material fetched for graph
	function single_count($table) {
	$this->db->select('count(*) as raw');
	//$array = array('material_type' => 1, 'material_type' => 2);
	///$this->db->where($array);
	$this->db->where('material_type', 1);
	//$this->db->where('material_type', 1);
	$this->db->from($table);
	//$cnt = $this->db->count_all_results();
	$query = $this->db->get();
	//pre($this->db->last_query());
    return $query->result_array();
	}

	/*created pi through PO
	function po_created($table) {
	$this->db->select('COUNT(*)');
	$this->db->from($table);
	$this->db->where('poCreate', 1);
	$query = $this->db->get();
    return $query->row_array();
	}

	/*succesfull pi created
	function success_po($table) {
			$this->db->select('COUNT(*)');
			$this->db->from($table);
			$this->db->where('approve', 1);

	$query = $this->db->get();
    return $query->row_array();
	}

	/*succesfull pi created
	function dissaprove_po($table) {
	$this->db->select('COUNT(*)');
	$this->db->from($table);
	$this->db->where('disapprove', 0);
	$query = $this->db->get();

    return $query->row_array();
	}



	public function indentFilter($fromDate,$toDate,$table) {

		$this->db->select('COUNT(*) as totalIndent');
		$this->db->from($table);

		$this->db->where('created_date >=', $fromDate);

		$this->db->where('created_date <=', $toDate);
		$this->db->order_by('created_date');

		$qry = $this->db->get();
		//pre($this->db->last_query());
		$result = $qry->result_array();


		return $result;
	}	*/
	public function material_amount($table){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table .'.name as Name , SUM(grand_total) as total');
		$dynamicdb->from($table);
		//$this->db->where('created_by_cid',$_SESSION['loggedInUser']->c_id);
		$dynamicdb->join('purchase_order',$table .".id = material_type_id", 'left');
		$dynamicdb->group_by($table.'.id');
		//$this->db->group_by($table.'.id, purchase_order.created_by_cid,'.$_SESSION['loggedInUser']->c_id);
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		return $result;
	}


	public function get_data_new($created_id){

		// $query = $this->db->query("SELECT  DISTINCT   parent_group_id FROM account_group where parent_group_id !='' OR acc_group_id !='' AND created_by ='".$created_id."' or created_by ='0' ");
		// return $query->result_array();
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$query = $dynamicdb->query("SELECT  DISTINCT   parent_group_id FROM account_group where parent_group_id !='' OR acc_group_id !='' AND created_by ='".$created_id."' or created_by ='0' ");
		return $query->result_array();
	}
	public function get_data_Accrding_toparent_id($data_parent){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$query = $dynamicdb->query("SELECT * FROM `account_group` WHERE `id` NOT IN (".$data_parent.")");
		return $query->result_array();
	}




	/* Function to fetch Data */
	  public function get_data_material_type($table='' ,$field , $id) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where('id',$id);
		$qry = $dynamicdb->get();
//pre($this->db->last_query()); die;
		$result = $qry->result_array();
		return $result;
	}


	public function insert_on_spot_tbl_data($table,$added_data) {
		$this->db->insert($table,$added_data);
		$cid = $this->db->insert_id();
		//pre($this->db->last_query()); die;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$added_data['id']  = $cid;
		$dynamicdb->insert($table,$added_data);
		$dynamicdb->insert_id();
		return $cid;
	}


	public function get_ledger_account_grp_Dtl($table,$created_by_id,$account_group_id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where('created_by_cid',$created_by_id);
        $dynamicdb->or_where('created_by_cid',0);
        $dynamicdb->where('id',$account_group_id);
		$query = $dynamicdb->get();
		return $query->result_array();
	}

	public function get_charges_Datatt($table='', $where = array()){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*');
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
//echo $this->db->last_query();die('sss');
		return $result;

	}

/* 	//for Upload Supplier Data Through Excel File
	public function importData($table,$data) {
		$res = $this->db->insert_batch($table,$data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->insert_batch($table,$data);
		 	if($res){
				return TRUE;
				}else{
				return FALSE;
			}
		} */



	/****************************************************************************************************************************/
  /**********************************************Import Data Modal*******************************************************************/
/*************************************************************************************************************************************/
	public function importData($table,$data) {
		if(!empty($data)){
			foreach($data as $dt){
				$this->db->insert($table,$dt);
				$insertedid = $this->db->insert_id();
				if($insertedid){
					$dynamicdb = $this->load->database('dynamicdb', TRUE);
					$dt['id'] = $insertedid;
					$dynamicdb->insert($table,$dt);
				}
			}
		}
	return true;
}


	public function changePiStatus($table,$data,$tabl_fld,$id_send) {
		$this->db->where($tabl_fld, $id_send);
		$this->db->update($table,array('status'=> $data['status']));
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($tabl_fld, $id_send);
		$dynamicdb->update($table,array('status'=> $data['status']));
		return true;
	}
		public function update_balance_status_chng($table,$db_data,$field,$id,$tbl_id) {
		$this->db->where($tbl_id,$id);
		$this->db->set($field,$db_data);
		//$this->db->set('ifbalance',$db_data);
		$this->db->update($table);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($tbl_id,$id);
		$dynamicdb->set($field,$db_data);
		$dynamicdb->update($table);
		return true;
	}
	public function change_status_complete_or_not($table,$update_data, $indent_id,$table_fldd){
		$this->db->where($table_fldd,$indent_id);
		$this->db->update($table,$update_data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($table_fldd,$indent_id);
		$dynamicdb->update($table,$update_data);
		return $this->db->affected_rows();

	}
	public function get_budget_accrdng_materialType($table ,$id) {

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.budget,  SUM(purchase_indent.grand_total) as Total');
		$dynamicdb->from($table);
		$dynamicdb->join("purchase_indent", $table . ".id = purchase_indent.material_type_id", 'left');

		$dynamicdb->where('purchase_indent.created_by_cid', $this->companyGroupId);
		$dynamicdb->where('purchase_indent.material_type_id', $id);
		$dynamicdb->where('purchase_indent.po_or_not', 1);
		$qry = $dynamicdb->limit(1,0)->get();
		$result = $qry->row_array();
		return $result;
	}

	/********if material type already exist***************/
	public function Exist($material_type,$update = '' ){
		$this->db->select('material_type_id');
		$this->db->from('budget');
		$this->db->where('material_type_id',$material_type);
		$qry = $this->db->get();
		$result = $qry->row_array();
		return $result;
	}
	/*   Update single value in table with where array given   */
	public function update_single_value_data($table,$data,$where) {
		$this->db->where($where);
		$this->db->update($table, $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($where);
		$dynamicdb->update($table, $data);
		return true;
	}

	/*******************************FAVOURITES IN PURCHASE ***************************/
	public function markfavour($table,$data,$key) {
			/*$data1 = array('favourite_sts ' => $data);
			$ids = $key;
			$this->db->where('id',$ids);
			$result = $this->db->update($table,$data1);*/
			/*$dynamicdb->where('id',$ids);
			$dynamicdb->update($table, $data1);	*/
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$sql = "UPDATE {$table} SET `favourite_sts` = 1 ^ `favourite_sts` WHERE id = {$key} ";
			$this->db->query($sql);
			$dynamicdb->query($sql);
			return TRUE;
	}

	/*******************************FAVOURITES IN PURCHASE ***************************/


	/*********************************For Updating previouse UOM***********************/
	function updateRowWhere($table, $where = array(), $data = array()) {

    $this->db->where($where);
    $this->db->update($table, $data);

    if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($where);
			$dynamicdb->update($table, $data);
		}

	return $dynamicdb->affected_rows();

   // echo $this->db->last_query();
}
	function getLastTableId($table=''){
	$masterDbQuery =$this->db->query("SELECT * FROM $table ORDER BY id DESC LIMIT 1");
	$masterDbResult = $masterDbQuery->row();


	$dynamicdb = $this->load->database('dynamicdb', TRUE);
	$query =$dynamicdb->query("SELECT * FROM $table ORDER BY id DESC LIMIT 1");
	$result = $query->row();
	#pre($result); die;
	if(!empty($result))
		return $result->id;
	elseif(empty($result)){
		return $masterDbResult->id;
	}
	else return false;
}


public function update_single_field_mat($table, $data, $materialId) {
	
	//pre($data);die();
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
       // echo $dynamicdb->last_query();die;
        return true;
    }

	public function update_single_field_lotdetails($table, $data, $id) {
        $db_data = $this->get_field_type_data($data, $table);
        $data = $db_data;
        //pre($data);die();
        $this->db->where('id', $id);
        $this->db->update('lot_details', $db_data);
        #echo $this->db->last_query();
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('id', $id);
            $dynamicdb->update('lot_details', $db_data);
        }
        #echo $dynamicdb->last_query();
        return true;
    }


	public function tot_rows($table, $where,$where2){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		$dynamicdb->where($where);
	 if($where2!=''){
		 $dynamicdb->where($where2);
		 }
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query(); die();
		  $result = $qry->num_rows();
		return $result;
	}

	public function customQuery($sql){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		return $dynamicdb->query($sql)->get()->row_array();
	}

	public function get_data_listing($table = '',$where,$limit, $start,$where2,$order,$export_data){


		$start = ($start-1) * $limit;
			$getPurchaseIndent = $this->db->get('purchase_indent')->result();
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			if($table=="material_type"){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}else if($table=="supplier"){
					$dynamicdb->select($table.'.*,'.$table.'.id as supplier_id,material.material_name as material_name');
					$dynamicdb->from($table);
					$dynamicdb->join("material", $table . ".material_name_id = material.id", 'left');
			}else{
				//$dynamicdb->select('*, sum(grand_total) as grandtotal');
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}
			$dynamicdb->where($where);
			//pre($where);

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
			$qry = $dynamicdb->get();
	// echo $dynamicdb->last_query();

			$result = $qry->result_array();
			//pre($result);
			if($table=="permissions"){
				$tempArr = array_unique(array_column($result, 'user_id'));
				$result = array_intersect_key($result, $tempArr);
			}


			return $result;
		}

		function getNameByIdLIKE_modal($table='',$id='',$field='',$whereInProcess,$limit, $start, $where2, $order,$export_data,$ptbl){
		$start = ($start-1) * $limit;
		  $dynamicdb = $this->load->database('dynamicdb', TRUE);
		  $dynamicdb->select('*');
		  $dynamicdb->from($table);
		  $dynamicdb->like($field, $id);
		  $qry = $dynamicdb->get();
		  $result_mat = $qry->result();
		   //pre($result_mat);

			$i =0;
			$piMaterialArray1 = array();
		 foreach($result_mat as $val1){
			//pre($val1);


			$mat_name  = '%"material_name_id":"%'.$val1->id.'"%';

			$where21 = "$ptbl.material_name!=''  AND  `material_name` LIKE  '". $mat_name ."'" ;

			//$qry2 = "select * from $ptbl where $whereInProcess AND $where21";
			 $dynamicdb->select('*');
			 $dynamicdb->from($ptbl);
			 $dynamicdb->where($whereInProcess);
			 $dynamicdb->where($where21);
			  $dynamicdb->order_by("id", "DESC");
			  $dynamicdb->limit($limit, $start);
			$qry = $dynamicdb->get();

			// pre($dynamicdb->last_query());
			    $piAmountResult = $qry->row_array();



				// $qryy2 = $dynamicdb->query($qry2);
				// $piAmountResult = $qryy2->row_array();
				 if(!empty($piAmountResult)){
					$piMaterialArray[$i] = $piAmountResult;
					$i++;
				 }
				 // pre($piMaterialArray);

		}
//die();
		return $piMaterialArray;
//die();


	}

	function getNameByIdLIKE_modal_type($table='',$id='',$field='',$whereComplete,$limit, $start, $where2, $order,$export_data,$ptbl){


		$start = ($start-1) * $limit;
		  $dynamicdb = $this->load->database('dynamicdb', TRUE);
		  $dynamicdb->select('*');
		  $dynamicdb->from($table);
		  $dynamicdb->like($field, $id);
		  $qry = $dynamicdb->get();

		  $result_mat = $qry->result();

			$i =0;
			$piMaterialArray1 = array();
		 foreach($result_mat as $val){

			//$json_dtl ='{"material_type_id" : "'.$val->id.'"}';


			$mat_type_name  = '%"material_type_id":"%'.$val->id.'"%';

			$where21 = "$ptbl.material_name!=''  AND  `material_name` LIKE  '". $mat_type_name ."'" ;

			//$qry2 = "select * from $ptbl where $whereComplete AND $where21";
			 $dynamicdb->select('*');
			 $dynamicdb->from($ptbl);
			 $dynamicdb->where($whereComplete);
			 $dynamicdb->where($where21);
			 $dynamicdb->order_by("id", "DESC");
			 $dynamicdb->limit($limit, $start);
				$qry = $dynamicdb->get();
				//echo $dynamicdb->last_query();
			    $piAmountResult = $qry->row_array();


				// $qryy2 = $dynamicdb->query($qry2);
				// $piAmountResult = $qryy2->row_array();
				 if(!empty($piAmountResult)){
					$piMaterialArray[$i] = $piAmountResult;
					$i++;
				 }

		}

	return $piMaterialArray;

	}
	public function get_data1($table = '' , $where = array(), $limit,$start,$where2,$order) {
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			//pagination
		$start = ($start-1) * $limit;
			if($table=="material_type"){
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}else if($table=="supplier"){
					$dynamicdb->select($table.'.*,'.$table.'.id as supplier_id,material.material_name as material_name');
					$dynamicdb->from($table);
					$dynamicdb->join("material", $table . ".material_name_id = material.id", 'left');
					//$dynamicdb->order_by('supplier_id','DESC');
			}
			else{
				// $this->db->select($table.'.*,material_type.name as materialType');
				// $this->db->from($table);
				// $this->db->join("material_type", $table . ".material_type_id = material_type.id", 'left');
				$dynamicdb->select('*');
				$dynamicdb->from($table);
			}
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

		$dynamicdb->order_by('id',$order);
		$dynamicdb->limit($limit, $start);
			$qry = $dynamicdb->get();
			$result = $qry->result_array();
			 if($table=="permissions"){
				$tempArr = array_unique(array_column($result, 'user_id'));
				$result = array_intersect_key($result, $tempArr);
			}
			return $result;
		}

	public function num_rows($table, $where = array() , $search_string = ''){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$table = $table?$table:$this->tablename;
		if($table == 'supplier'){
			$dynamicdb->select($table.'.*,'.$table.'.id as supplier_id,material.material_name as material_name');
			$dynamicdb->from($table);
			$dynamicdb->join("material", $table . ".material_name_id = material.id", 'left');
		}else{
			$dynamicdb->select('*');
			$dynamicdb->from($table);
		}
		$dynamicdb->where($where);
		if($search_string != '' && $table == 'supplier') {
				$dynamicdb->like($table.'.id',$search_string);
				$dynamicdb->or_like($table.'.name',$search_string);
				$dynamicdb->or_like($table.'.material_type_id',$search_string);
			}

			else if($search_string != '' && $table == 'purchase_indent' ) {
				$dynamicdb->like($table.'.id',$search_string);
				$dynamicdb->or_like($table.'.indent_code',$search_string);
				$dynamicdb->or_like($table.'.material_type_id',$search_string);
			} 	else if($search_string != '' && $table == 'purchase_order' ) {
				$dynamicdb->like($table.'.id',$search_string);
				$dynamicdb->or_like($table.'.order_code',$search_string);
				$dynamicdb->or_like($table.'.pi_id',$search_string);
			} 	else if($search_string != '' && $table == 'mrn_detail' ) {
				$dynamicdb->like($table.'.id',$search_string);
			} 	else if($search_string != '' && $table == 'charges_lead' ) {
				$dynamicdb->like($table.'.id',$search_string);
			}
		$qry = $dynamicdb->get();
		$result = $qry->num_rows();
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

	public function update_single_auto_entry($encoded_data,$table,$po_id,$id){
	   $query = $this->db->query("UPDATE ".$table." SET `material_descr`= '".$encoded_data."' WHERE `challa_pur_ordr_no` = '".$po_id."'  AND `id` = '".$id."'");
	   $dynamicdb = $this->load->database('dynamicdb', TRUE);
       $query = $dynamicdb->query("UPDATE ".$table." SET `material_descr`= '".$encoded_data."' WHERE `challa_pur_ordr_no` = '".$po_id."' AND `id` = '".$id."'");
	}

	function updateWhere($table,$data,$where){
		$this->db->update($table,$data,$where);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->update($table,$data,$where);
	}

	function getIdByName($select,$table,$fieldName,$name,$conduction=""){
		$name = ltrim($name);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$sql = "SELECT {$select} FROM {$table} WHERE {$fieldName} LIKE '%{$name}%'";
		if( empty($conduction) ){
			$sql .= " AND (created_by_cid = 0 OR created_by_cid =  {$this->companyGroupId})";
		}
		$data = $dynamicdb->query($sql)->row_array();
		return $data[$select];

	}

	function getIdByNameAndId($select,$table,$fieldName,$name,$fieldName2,$name2,$conduction = ""){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$sql = "SELECT {$select} FROM {$table} WHERE {$fieldName} LIKE '%{$name}%' AND {$fieldName2} = {$name2} ";
		if( empty($conduction) ){
			$sql .= " AND (created_by_cid = 0 OR created_by_cid =  {$this->companyGroupId})";
		}
		$data = $dynamicdb->query($sql)->row_array();
		return $data[$select];

	}

	function insertData($table,$data){
		$this->db->insert($table,$data);
		$insertedid = $this->db->insert_id();
		if($insertedid){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicInsertedid = $dynamicdb->insert($table,$data);
		}
		return $dynamicInsertedid;
	}

	function getGateEntryIndexData($id = "",$column = ""){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$result =  $dynamicdb->select('pge.*,pge.id as pgeId,po.order_code,s.name,po.created_date,po.mrn_or_not')
				->from('purchase_gateEntry as pge')
				->join('purchase_order as po','po.id = pge.po_id','left')
				->join('supplier as s','s.id = pge.supplier')
				->where('pge.created_by_cid',$this->companyGroupId);
				if( $id ){
				$result = $result->where($column,$id);
				}
				return $result->get()->result_array();
	}

	function getGateEntryIndex($limit,$start){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$start = ($start - 1) * $limit;
		$sql = "SELECT pge.*,pge.id as pgeId,po.order_code,s.name,po.created_date,po.mrn_or_not FROM purchase_gateEntry as pge LEFT JOIN purchase_order as po ON po.id = pge.po_id LEFT JOIN supplier as s ON s.id = pge.supplier WHERE pge.created_by_cid = {$this->companyGroupId} ORDER BY id DESC LIMIT $start,$limit ";
		return $dynamicdb->query($sql)->result_array();

	}

	public function getLastIdWithInc($table,$column){
    	$sql       = "SELECT Max($column) + 1 as lastId From {$table}";
    	$dynamicdb = $this->load->database('dynamicdb', TRUE);
    	$result    = $dynamicdb->query($sql)->row_array();
    	if( empty($result['lastId']) ){
    		$result['lastId'] = 1;
    	}
    	$number = str_pad($result['lastId'],5,0,STR_PAD_LEFT);
    	return $number;
    }

    public function twoJoinTables($numRows = fasle,$select,$table1,$table2,$table2Join,$where,$orderBy = "",$start ="",$limit = ""){
    	$dynamicdb = $this->load->database('dynamicdb', TRUE);
    	$start = ($start - 1) * $limit;
    	$sql = "SELECT $select FROM $table1 LEFT JOIN $table2 ON $table2Join WHERE $where ";
   		if( $numRows != true && !empty($orderBy) ){
    		$sql .= " ORDER BY $orderBy LIMIT $start,$limit ";
   		}
		$result =  $dynamicdb->query($sql);
		if( !$numRows ){
		 return	$result->result_array();
		}else{
	     return $result->num_rows();
		}
    }

    public function getDataByWhereId($table,$where,$select = []){
    	$dynamicdb = $this->load->database('dynamicdb', TRUE);
    	$data = $dynamicdb;
    	if( $select ){
    		$data = $dynamicdb->select($select);
    	}
    	return $data->where($where)->get($table)->result_array();
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

    public function getDataWhereIn($table,$where,$in,$select = []){
    	$dynamicdb = $this->load->database('dynamicdb', TRUE);
    	$data = $dynamicdb;
    	if( $select ){
    		$data = $dynamicdb->select($select);
    	}
    	return $data->where_in($where,$in)->get($table)->result_array();
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

	function rightTables($select,$firstTable,array $joinData,$where,$order = [],$limitData = [],$groupBy=""){

		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$sql = $dynamicdb->select($select)->from($firstTable);

		if( $joinData ){
			foreach ($joinData as $tableName => $joinClause) {
				$sql = $sql->join($tableName,$joinClause,'right');
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

	function getRowArray($select = "*",$table,$where){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		return $dynamicdb->select($select)->where($where)->get($table)->row_array();
	}

	function getNumRowPDB(){
		$orderNo = $this->db->select('order')
						->where('parent_id',375)
						->order_by('id','desc')
						->get('menus')->row_array();
		if( $orderNo ){
			return $orderNo['order'] + 1;
		}else{
			return 2;
		}

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
  public function defected_Order( $table,$where ) {

        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql ="SELECT * FROM {$table} WHERE {$where}";
        $query = $dynamicdb->query($sql);
      // echo $dynamicdb->last_query(); die;
        return $query->row();
    }
	
	
	    public function get_image_by_materialId($table, $field, $id) {
       
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($field, $id);
            $dynamicdb->where('rel_type', 'material');
            $qry = $dynamicdb->get();
        
        $result = $qry->result_array();
        return $result;
    }
	
	
		public function update_material($table,$db_data,$field,$id) {
			$this->db->where($field, $id);	
			$result = $this->db->update($table, $db_data);
			$dynamicdb = $this->load->database('dynamicdb', TRUE);	
			$dynamicdb->where($field, $id);	
			$dynamicdb->update($table, $db_data);
			//echo $dynamicdb->last_query(); die;
			return true;
		}
		
	public function getSalePrice($table, $field, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where($field, $id);
            $this->db->order_by('id','DESC');
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($field, $id);
            $dynamicdb->order_by('id','DESC');
            $qry = $dynamicdb->get();
        }
        $result = $qry->result_array();
        return $result;
    }
	
	
	
	
	
	
	
	
	
	
	
	


}
