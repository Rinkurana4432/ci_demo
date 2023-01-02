<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crm_model extends ERP_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tablename = 'leads';
        $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
        //$this->column_search = array('name');
    }  
	
	/* database field columns */
	public function get_field_type_data($data, $table){
		switch($table){
		    
			case 'leads':				
				$all_fields = array('end_date','company','lead_industry','street','city','state','country','zipcode','website','lead_source','material_type_id','product_detail','totalwithoutgst','grand_total','lead_status','lead_owner','created_by','contacts','converted_to_account','converted_to_contact','edited_by','created_by_cid','save_status' ,'favourite_sts','status_comment',' converted_to_quotation','converted_to_proinvc','converted_to_so','existing_customer');
				break;	

				case 'sales_area':
				$all_fields = array('sales_area', 'created_by_cid');
				break;	

			case 'leads_status_history':
				$all_fields = array('lead_id', 'status', 'start_date', 'end_date', 'created_by_cid');
				break;
						
			// case 'account':
				// $all_fields = array('account_owner','name','phone','fax','parent_account','website','type','employee','industry','revenue','description','billing_street','billing_city','billing_zipcode','billing_state','billing_country','shipping_street','shipping_city','shipping_zipcode','shipping_state','shipping_country','gstin','email','created_by','edited_by','save_status');
				// break;
			case 'account':
				$all_fields = array('account_owner','name','phone','fax','parent_account','website','type','route_id','employee','industry','revenue','description','billing_street','billing_city','billing_zipcode','billing_state','pan','billing_country','shipping_street','shipping_city','shipping_zipcode','shipping_state','shipping_country','new_billing_address','new_shipping_address', 'type_of_customer', 'sales_area', 'contact_name', 'gstin','email','created_by','edited_by','save_status','salesPersons','purchaseLimit','temp_credit_limit','temp_crlimitDate','due_days','salesPersons','api_data');
				break;	
			case 'contacts':
				$all_fields = array('contact_owner','first_name','last_name','phone','mobile', 'email','account_id','title', 'mailing_street','mailing_city','mailing_zipcode', 'mailing_state','mailing_country','other_street', 'other_city','other_zipcode', 'other_state','other_country','fax','home_phone','other_phone','asst_phone','assistant','department','lead_source','dob', 'description','company','created_by','edited_by','save_status');
				break;
			case 'lead_activity':
				$all_fields = array('lead_id','subject','comment','created_by','assigned_to','due_date','activity_type','created_by_cid','new_task_status');
				break;
			case 'account_activity':
				$all_fields = array('account_id','subject','comment','created_by','assigned_to','due_date','activity_type','created_by_cid','new_task_status');
				break;
			case 'sale_order':
				$all_fields = array('so_order','company_unit','account_id','contact_id', 'order_date', 'product', 'dispatch_date', 'agt', 'freight', 'payment_terms', 'advance_received', 'cash_discount', 'discount_offered', 'label_printing_express', 'brand_label', 'dispatch_documents', 'product_application', 'guarantee','convrtd_frm_quot_to_pi','convrtd_frm_quot_to_so','created_by','created_by_cid','total','grandTotal','payment_date','save_status','party_ref','material_type_id','completed_by','complete_status','freightCharges','pi_cbf','pi_weight','pi_paymode','pi_permitted','special_discount', 'load_type','special_discount_authorized','pi_remarks','discount_rate');
				break;			
			case 'proforma_invoice':
				$all_fields = array('pi_code','account_id','contact_id', 'order_date', 'product', 'dispatch_date', 'agt', 'freight', 'payment_terms', 'advance_received', 'cash_discount', 'discount_offered', 'label_printing_express', 'brand_label', 'dispatch_documents', 'product_application', 'guarantee','convrtd_frm_quot_to_pi','convrtd_frm_quot_to_so','created_by','created_by_cid','total','grandTotal','save_status','load_type','party_ref','material_type_id','freightCharges','discount_rate','pi_cbf','pi_weight','pi_paymode','pi_permitted','pi_remarks','special_discount','special_discount_authorized','edited_by','apply_comment','extra_charges');
				break;
			case 'user_sale_target':
				$all_fields = array('user_id','created_by','sale_target','lead_generation_target','payment_target','start_date','end_date','save_status');
				break;
			case 'sale_order_priority':
				$all_fields = array('sale_order_id','product_id','gst','quantity','uom','price','individualTotal','individualTotalWithGst','created_by_cid','priority');
				break;
			case 'ledger':
				$all_fields = array('name','account_group_id','mailing_address','contact_person','phone_no','mobile_no','email','website','registration_type','gstin','pan','created_by','edited_by','parent_group_id','conn_comp_id','created_by_cid','compny_branch_id','save_status','opening_balance','new_billing_address','type_of_customer','contact_name');
				break;	


			case 'sale_metrics_report':
			$all_fields = array('created_date');
			break;
			case 'user_dashboard':
				$all_fields = array('graph_id','user_id','show');
				break;
			case 'pi_comment_log':
				$all_fields = array('apply_comment','date','userid','rel_id','rel_type');
				break;
			case 'attachments':
				$all_fields = array('rel_type','rel_id','file_type','file_name');
				break;
			case 'sale_order_dispatch':
				$all_fields = array('account_id','product', 'dispatch_date','dispatch_documents', 'comments', 'transport_tel_no','vehicle_no','created_by','created_by_cid','total','grandTotal','invoice_no','save_status','material_type_id','sale_order_id');
				break;
			case 'quotation':
				$all_fields = array('account_id','contact_id', 'valid_date','order_date', 'product',  'agt', 'freight', 'payment_terms','cash_discount', 'discount_offered', 'brand_label','terms_conditions','created_by','created_by_cid','total','grandTotal','save_status','party_ref','material_type_id');
				break;
			
			case 'pi_activitylog':
				$all_fields = array('p_id', 'subject', 'created_by', 'created_by_cid', 'activity_type', 'created_date');
				break;
			case 'termscond':
		        $all_fields = array('account_id', 'terms_tittle', 'content', 'save_status', 'created_by', 'created_by_cid', 'created_date', 'modified_date');
				break;

			case 'types_of_customer':
			 	$all_fields = array('type_of_customer','full_load','part_load', 'created_by', 'created_by_cid', 'created_date', 'modified_date');
			 	break;

			case 'price_list':
			 	$all_fields = array('customer_type', 'product_id', 'price', 'created_by', 'created_by_cid', 'created_date', 'modified_date');
			 	break;

			case 'npdm':				
				$all_fields = array('product_name', 'product_require', 'product_detail', 'job_card', 'expenses', 'labour_expenses', 'budget_assigned', 'npdm_owner', 'end_date', 'save_status', 'favourite_sts', 'created_by', 'edited_by', 'created_by_cid', 'created_date', 'updated_date', 'npdm_status');
				break;			 

				case 'competitor_details':
				$all_fields = array('account_owner', 'name', 'phone', 'fax', 'parent_account', 'website', 'gstin', 'email', 'type','product_detail', 'employee', 'industry', 'revenue', 'description', 'billing_street', 'billing_city', 'billing_zipcode', 'billing_state', 'billing_country', 'shipping_street', 'shipping_city', 'shipping_zipcode', 'shipping_state', 'shipping_country', 'save_status', 'favourite_sts', 'created_by', 'edited_by');
			 	break;
				 case 'comp_price':
				 $all_fields = array('account_owner', 'account_id', 'phone', 'fax', 'gstin', 'product_detail', 'save_status', 'favourite_sts', 'created_by', 'edited_by');
				 break;
			case 'mat_locations':
                $all_fields = array('location_id', 'Storage', 'RackNumber', 'quantity', 'Qtyuom', 'created_by_cid', 'material_type_id', 'material_name_id', 'physical_stock', 'balance');
                break;

             case 'lead_report':
            	 $all_fields = array('created_date');  
            	break;

             case 'activity_reports':
            	 $all_fields = array('created_date');  
            	break;

             case 'accounts_company_reports':
             $all_fields = array('created_date');
             break; 

            case 'sale_reports':
            $all_fields = array('created_date');
			break;	

			case 'invoice_report':
			$all_fields = array('created_date');
			break;

			


			case 'add_industry':
				$all_fields = array('industry_detl', 'created_by', 'created_by_cid', 'created_date', 'modified_date');
				break;

			case 'add_lead_source':
				$all_fields = array('leads_source_name', 'created_by', 'created_by_cid', 'created_date', 'modified_date');
				break;

			 case 'prodct_price':
				 $all_fields = array('material_type_id', 'material_name', 'comp_price_info', 'favourite_sts', 'created_by', 'created_by_cid');
				 break;
				
		}
		return $data = format_data_to_be_added($all_fields, $data);
	}
	
	
	//num rows
	public function tot_rows($table, $where = array(),$where2){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');  
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		 if($where2!=''){
		 $dynamicdb->where($where2);
		 }
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->num_rows();		
		return $result; 
	}	
	
		public function get_data1($table = '' , $where = array(),$limit, $start,$where2,$order,$export_data) {
			$start = ($start-1) * $limit;
		if($_SESSION['loggedInUser']->role == 3){			
			$table = $table?$table:$this->tablename;
			//pagination
			$this->db->select('*'); 
			$this->db->from($table);
			$this->db->where($where);
			if($where2!='')
			{$this->db->where($where2);
			}
			
			 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
				//$this->db->order_by('id',$order);
			//$this->db->order_by('created_date', "desc");		
			//$this->db->limit($limit, $start);
			//if($limit !='')	
			//$this->db->limit($limit);
			if($table != 'permissions' && $table != 'lead_status' && $table != 'user_detail' && $table != 'material' && $table != 'contacts' && $table != 'account_activity' && $table != 'sale_order_dispatch' && $table != 'user_dashboard' && $table != 'user' && $table != 'lead_activity' && $table != 'activity_log' && $table != 'company_act_log' && $table != 'price_list')
			
			if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
			
			#$this->db->order_by('favourite_sts','created_date', 'asc');		
			$qry = $this->db->get();	
			$result = $qry->result_array();	
		//	echo $dynamicdb->last_query();
			return $result;
		}else{			
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			$dynamicdb->select('*'); 
			$dynamicdb->from($table);

			//echo $table;
			$dynamicdb->where($where);
			if($where2!='')
			{$dynamicdb->where($where2);
			}
			
			 if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
				//$dynamicdb->order_by('id',$order);
			//	$dynamicdb->limit($limit, $start);
			//if($limit !='')	
			//$dynamicdb->limit($limit);
			if($table != 'permissions'  && $table != 'lead_status' && $table != 'user_detail' && $table != 'material' && $table != 'contacts'
			&& $table != 'account_activity'  && $table != 'sale_order_dispatch'  && $table != 'user_dashboard' && $table != 'user' && $table != 'lead_activity' && $table != 'activity_log' && $table != 'company_act_log' && $table != 'price_list')
			//	$dynamicdb->order_by('created_date', "desc");
					
			#$dynamicdb->order_by('favourite_sts','created_date', 'asc');	
		if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}			
			$qry = $dynamicdb->get();
			$result = $qry->result_array();	
		#echo $dynamicdb->last_query();
			return $result;
		}
	}	
	
	 /* Function to fetch Data */
	public function get_data($table = '' , $where = array(), $limit = '') {	
	//pre($where);die;
		if($_SESSION['loggedInUser']->role == 3){			
			$table = $table?$table:$this->tablename;
			$this->db->select('*'); 
			$this->db->from($table);
			$this->db->where($where);
			if($limit !='')	
			$this->db->limit($limit);
			if($table != 'leads' && $table != 'permissions' && $table != 'lead_status' && $table != 'user_detail' && $table != 'material' && $table != 'contacts' && $table != 'account_activity' && $table != 'sale_order_dispatch' && $table != 'user_dashboard' && $table != 'user' && $table != 'activity_log' && $table != 'company_act_log' && $table != 'price_list' && $table != 'leads_status_history' && $table != 'types_of_customer' &&  $table != 'import_price_list')
				$this->db->order_by('created_date', "desc");		
			#$this->db->order_by('favourite_sts','created_date', 'asc');		
			$qry = $this->db->get();	
		#echo $this->db->last_query();
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
			if($table != 'leads' && $table != 'permissions'  && $table != 'lead_status' && $table != 'user_detail' && $table != 'material' && $table != 'contacts'
			&& $table != 'account_activity'  && $table != 'sale_order_dispatch'  && $table != 'user_dashboard' && $table != 'user' && $table != 'activity_log' && $table != 'company_act_log' && $table != 'price_list' && $table != 'leads_status_history' && $table != 'types_of_customer' &&  $table != 'import_price_list')
				$dynamicdb->order_by('created_date', "desc");
			#$dynamicdb->order_by('favourite_sts','created_date', 'asc');		
			$qry = $dynamicdb->get();
			 // echo $dynamicdb->last_query();	die(); 
			$result = $qry->result_array();	
			return $result;
		}
	}	
	
	

	public function get_activity_log_PI($table = '' , $where = array(), $limit = '') {	
			$table = $table?$table:$this->tablename;
			$this->db->select('*'); 
			$this->db->from($table);
			$this->db->where($where);
			if($limit !='')	
			$this->db->limit($limit);
			if($table != 'pi_comment_log' && $table != 'leads' && $table != 'permissions' && $table != 'lead_status' && $table != 'user_detail' && $table != 'material' && $table != 'contacts' && $table != 'account_activity' && $table != 'sale_order_dispatch' && $table != 'user_dashboard' && $table != 'user' && $table != 'activity_log' && $table != 'company_act_log' && $table != 'price_list' && $table != 'leads_status_history' && $table != 'types_of_customer' &&  $table != 'import_price_list')
				$this->db->order_by('created_date', "desc");		
			#$this->db->order_by('favourite_sts','created_date', 'asc');		
			$qry = $this->db->get();	
		#echo $this->db->last_query();
			$result = $qry->result_array();	
			return $result;

	}	

	public function get_dispatch_data($table = '' , $where = array(), $limit = '') {	
		if($_SESSION['loggedInUser']->role != 3){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$table = $table?$table:$this->tablename;
		$dynamicdb->select('*'); 
		$dynamicdb->from($table);
		//$dynamicdb->join("attachments", $table . ".id = attachments.rel_id", 'left');
		//$dynamicdb->where('attachments.rel_type','sale_order_dispatch');
		//$dynamicdb->order_by('attachments.created_date', "desc");		
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		//pre($dynamicdb->last_query());		
		$result = $qry->result_array();	
		$saleOrderDispatch_arrayId = array();
		$i = 0;
		foreach($result as $res){
			$sale_dispatch_id = $res['id'];
			$dynamicdb->select('*'); 
			$dynamicdb->from('attachments');
			$dynamicdb->where('attachments.rel_type','sale_order_dispatch');
			$dynamicdb->where('attachments.rel_id',$sale_dispatch_id);
		    $dynamicdb->order_by('attachments.created_date', "desc");
			$qry1 = $dynamicdb->get();
			
			$issue_result = $qry1->result_array();
			$saleOrderDispatch_arrayId[$i]['sale_order'] = $res;
			foreach($issue_result as $ir){
				//pre($ir);
				if($ir['rel_id'] == $res['id']){
				//$saleOrderDispatch_arrayId[$i]['sale_order'] = $res;
				//$saleOrderDispatch_arrayId[$i][]['file_type'] = $ir['file_type'];
				$saleOrderDispatch_arrayId[$i]['file_name'][] = $ir['file_name']; 
				}
		
			}	$i++;	
		
		}
		//pre($saleOrderDispatch_arrayId);
		//die;
		return $saleOrderDispatch_arrayId;		
		
		}
	}
	
	/* Function to get matched data of auto leads  */
	public function get_matched_data($table = '' , $where = array()) {
		if($_SESSION['loggedInUser']->role == 3){
			$companyId = $_SESSION["loggedInUser"]->c_id;
			$table = $table?$table:$this->tablename;
			$this->db->select('*'); 
			$this->db->from($table);
			$this->db->where("company_ids LIKE '%$companyId%'");
			$qry = $this->db->get();
			$result = $qry->result_array();
			return $result;
		}else{
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$companyId = $_SESSION["loggedInUser"]->c_id;
			$table = $table?$table:$this->tablename;
			$dynamicdb->select('*'); 
			$dynamicdb->from($table);
			$dynamicdb->where("company_ids LIKE '%$companyId%'");
			$qry = $dynamicdb->get();
			$result = $qry->result_array();
			return $result;
		}
	}	
	
		 /* Function to fetch Data */
	/*public function get_sale_target_data_list($table = '' , $where = array(), $limit = '') {		
		$table = $table?$table:$this->tablename;
		$this->db->select($table.'.*,count(leads.id) AS leadsAcheived'); 
		//$this->db->select($table.'.*'); 
		$this->db->from($table);
		$this->db->join("leads as leads", "leads.created_by = ".$table.".user_id", 'left');
		//$this->db->join("user_detail as leadOwner", $table . ".lead_owner = leadOwner.u_id", 'left');
		$this->db->where($where);		
		$this->db->group_by($table.'.user_id');
		$this->db->limit($limit);
		$this->db->order_by($table.'.created_date', "desc");
		$qry = $this->db->get();	
		echo $this->db->last_query();
		$result = $qry->result_array();	
		//pre($result);		
		return $result;
	}*/
	
	public function getLeadCountByUserId($table = '' , $where = array(), $date = ''){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		//pagination
	//	$start = ($start-1) * $limit;
		if($table == 'leads') $dynamicdb->select('count(leads.id) as leadAcheivedTarget');
		if($table == 'sale_order') $dynamicdb->select('count(sale_order.id) as acheivedSaleTarget,SUM(sale_order.grandTotal) as acheivedPaymentTarget');	
		$dynamicdb->from($table);		
		$dynamicdb->where($where);
		//$dynamicdb->limit($limit, $start);
		$qry = $dynamicdb->get();	
		//echo $this->db->last_query();
		$result = $qry->result_array();	
		//$result = $qry->row();
		//pre($result);		
		return $result[0];		
	}
	
	
	 /* Function to fetch Data */
	public function get_tbl_data($table = '' , $where = array(), $limit = '') {
		if($_SESSION['loggedInUser']->role == 3){		
			$table = $table?$table:$this->tablename;
				if($table == 'leads'){
					$this->db->distinct();
				}
			$this->db->select($table.'.* ,createdBy.name AS createdByName, leadOwner.name AS leadOwnerName'); 
			$this->db->from($table);
			$this->db->join("user_detail as createdBy", $table . ".created_by = createdBy.u_id", 'left');
			$this->db->join("user_detail as leadOwner", $table . ".lead_owner = leadOwner.u_id", 'left');
			$this->db->where($where);
			if($limit != '')
			$this->db->limit($limit);
			#$this->db->order_by('leads.favourite_sts','leads.created_date', "desc");	
			$this->db->order_by('leads.created_date', "desc");		
			$qry = $this->db->get();			
			$result = $qry->result_array();	
			//echo $this->db->last_query();
			return $result;
		}else{			
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			$dynamicdb->select($table.'.* ,createdBy.name AS createdByName, leadOwner.name AS leadOwnerName'); 
			$dynamicdb->from($table);
			$dynamicdb->join("user_detail as createdBy", $table . ".created_by = createdBy.u_id", 'left');
			$dynamicdb->join("user_detail as leadOwner", $table . ".lead_owner = leadOwner.u_id", 'left');
			$dynamicdb->where($where);
			if($limit != '')
			$dynamicdb->limit($limit);
			$dynamicdb->order_by('leads.created_date', "desc");		
			#$dynamicdb->order_by('leads.favourite_sts','leads.created_date', "desc");		
			$qry = $dynamicdb->get();			
			$result = $qry->result_array();	
		#echo $dynamicdb->last_query();
			return $result;
		}
	}	
	
	
	
	//public function get_own_tbl_lead_data($table = '', $limit = ''){
	public function get_own_tbl_data($table = '', $where = array(), $limit = '', $ownerKey = ''){
		if($_SESSION['loggedInUser']->role != 3){		
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			$dynamicdb->select($table.'.* ,createdBy.name AS createdByName, leadOwner.name AS leadOwnerName'); 
			$dynamicdb->from($table);
			$dynamicdb->join("user_detail as createdBy", $table . ".created_by = createdBy.u_id", 'left');
			$dynamicdb->join("user_detail as leadOwner", $table . ".".$ownerKey." = leadOwner.u_id", 'left');
			
			if($table == 'leads'){			
				$dynamicdb->where($where);			
				$dynamicdb->where($ownerKey,$_SESSION['loggedInUser']->id);
				
			}else{
				$dynamicdb->where('created_by',$_SESSION['loggedInUser']->id);			
				$dynamicdb->or_where($ownerKey,$_SESSION['loggedInUser']->id);
				
			}
			
			/*//$dynamicdb->where('created_by',$_SESSION['loggedInUser']->id);
			$dynamicdb->where($where);
			#$dynamicdb->or_where($ownerKey,$_SESSION['loggedInUser']->id);
			$dynamicdb->where($ownerKey,$_SESSION['loggedInUser']->id);*/
			if($limit != '')
			$dynamicdb->limit($limit);
			#$dynamicdb->order_by($table.'favourite_sts',"desc");
			$dynamicdb->order_by($table.'.'.'created_date','desc');
			$qry = $dynamicdb->get();
			//echo $this->db->last_query();die();
			$result = $qry->result_array();		
			return $result;
		}
	}
	    /* Insert Data */
	public function insert_tbl_data($table,$data) {
			$fieldData = $this->get_field_type_data($data,$table);
			// pre($fieldData);
			// die;			
			$this->db->insert($table,$fieldData);
			$insertedid = $this->db->insert_id();				
			if($insertedid){
				if($_SESSION['loggedInUser']->role != 3){
					$dynamicdb = $this->load->database('dynamicdb', TRUE);
					$fieldData['id'] = $insertedid;
					$dynamicdb->insert($table,$fieldData);
					$dynamicdb->insert_id();	
				}
			}
			//echo $this->db->last_query();die();
			return $insertedid; 
	}
		
    /* Update Data */
	public function update_data($table,$db_data,$field,$id) {		
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);		
		$result = $this->db->update($table, $db_data);	

		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($field, $id);		
			$dynamicdb->update($table, $db_data);	
		}
		   // echo $dynamicdb->last_query();die();
		return TRUE;
	}	
	
	public function update_after_save_saleorder($table,$data,$tabl_fld,$id_send) {
		$this->db->where($tabl_fld, $id_send);
		$this->db->update($table,$data);
		if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($tabl_fld, $id_send);
			$dynamicdb->update($table,$data);
		}
		return true;
	}
	
	/* Function to fetch Data by Id */
	public function get_data_by_key($table ,$field, $fieldValue) {
		if($_SESSION['loggedInUser']->role == 3){	
			$this->db = $this->load->database('dynamicdb', TRUE);
			$this->db->select('user.*,'.$table.'.*');    
			$this->db->from($table);
			$this->db->join("user", $table . ".id = user.c_id", 'left');
			$this->db->where($table.'.'.$field, $fieldValue);
			$qry = $this->db->get();			
			$result = $qry->row();	
			return $result;
		}else{	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('user.*,'.$table.'.*');    
			$dynamicdb->from($table);
			$dynamicdb->join("user", $table . ".id = user.c_id", 'left');
			$dynamicdb->where($table.'.'.$field, $fieldValue);
			$qry = $dynamicdb->get();			
			$result = $qry->row();	
			return $result;
		}
	}
	
	
	/* Function to fetch Data by Id of material */
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
		// echo $dynamicdb->last_query();die();	
		}
		$result = $qry->row();
	
		return $result;
	}
	
	
	

	
	
	/* Function to delete data from selected Table */
	public function delete_data($table ,$field ,$id) {	
		$this->db->where($field, $id);
		if($this->db->delete($table)){	
			if($_SESSION['loggedInUser']->role != 3){		
				$dynamicdb = $this->load->database('dynamicdb', TRUE);
				$dynamicdb->where($field, $id);
				$dynamicdb->delete($table);
				
			}
			return true;
		}		
	}
	
	/* Insert attachment Data */
	public function insert_attachment_data($table , $data = array(), $type) {
		if(!empty($data)){			
			foreach($data as $dt){
				$fieldData = $this->get_field_type_data($dt,$table);
				$this->db->insert($table,$fieldData);
				$insertedid = $this->db->insert_id();	
				if($_SESSION['loggedInUser']->role != 3){
					if($insertedid){
						$dynamicdb = $this->load->database('dynamicdb', TRUE);
						$fieldData['id'] = $insertedid;	
						$dynamicInsertedid = $dynamicdb->insert($table,$fieldData);
					}
				}				
			}
			return $insertedid; 
		}
		
	}
	
	public function change_lead_status($id, $status, $statusComment = '') {
		$this->db->where('id', $id);		
		$status = array('lead_status' => $status,'status_comment' => $statusComment);
		$this->db->update('leads', $status );
	//	echo $this->db->last_query();die();
		if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('id', $id);	
			$dynamicdb->update('leads', $status);
		}
		return true;
	}	
	
	public function activityFilter($id, $fromDate,$toDate,$table) {
		if($_SESSION['loggedInUser']->role == 3){			
			$relKey = $table=='lead_activity'?'lead_id':'account_id';
			$this->db->select('*');    
			$this->db->from($table);
			$this->db->where($relKey, $id);
			$this->db->where('created_date >=', $fromDate);
			$this->db->where('created_date <=', $toDate);
			$this->db->order_by('created_date', "desc");
			$qry = $this->db->get();
			$result = $qry->result_array();	
			return $result;
		}else{
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$relKey = $table=='lead_activity'?'lead_id':'account_id';
			$dynamicdb->select('*');    
			$dynamicdb->from($table);
			$dynamicdb->where($relKey, $id);
			$dynamicdb->where('created_date >=', $fromDate.' 00:00:00');
			$dynamicdb->where('created_date <=', $toDate.' 24:00:00');
			$dynamicdb->order_by('created_date', "desc");
			$qry = $dynamicdb->get();
			//echo $dynamicdb->last_query();die();
			$result = $qry->result_array();	
			return $result;
		}
	}	
	
	 /* Function to fetch Data */
	public function get_sale_target_data($table = '' , $where = array()) {
		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			$dynamicdb->select($table.'.*,user_sale_target.id AS sale_target_id,user_sale_target.sale_target,user_sale_target.lead_generation_target,user_sale_target.payment_target'); 
			$dynamicdb->from($table);
			$dynamicdb->join("user_sale_target", $table . ".u_id = user_sale_target.user_id", 'left');
			$dynamicdb->where($where);		
			$qry = $dynamicdb->get();			
			$result = $qry->result_array();		
			return $result;
		}
	}
	
	public function approveSaleOrder($data) {
		$this->db->where('id', $data['id']);		
		$approveData = array('approve' => $data['approve'],'validated_by' =>  $data['validated_by'] ,'disapprove' => 0 ,'disapprove_reason' => '', 'approve_date' => date('Y-m-d H:i:s'));
		$this->db->update('sale_order', $approveData );
	//	echo $this->db->last_query();
		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('id', $data['id']);		
			$dynamicdb->update('sale_order', $approveData );
		}
		return true;
	}
	
	
	public function completeSaleOrder($data) {		
		$this->db->where('id', $data['id']);		
		$completeSaleOrderData = array('complete_status' => $data['complete_status'],'completed_by' =>  $data['completed_by'] );
		$this->db->update('sale_order', $completeSaleOrderData );
		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('id', $data['id']);		
			$dynamicdb->update('sale_order', $completeSaleOrderData );
		}
		return true;
	}
	
	
	public function disApproveSaleOrder($data,$idss) {
             
        $ids = explode(",",$idss);
            foreach ($ids as $key) {
            		$this->db->where('id',$key);		
				$rr = $this->db->update('sale_order', $data );
            }

            if($_SESSION['loggedInUser']->role != 3){	
				$dynamicdb = $this->load->database('dynamicdb', TRUE);
				foreach ($ids as $key) {
					$dynamicdb->where('id', $key);	
					$dynamicdb->update('sale_order', $data );
				}
		}
		
		return true;
           	
	}
	
	/* Function to fetch attachments  by sale order Id */
	/*public function get_attachmets_by_saleOrderId($table ,$field, $id) {
		$this->db->select('*');    
		$this->db->from($table);
		$this->db->where($field, $id);
		$this->db->where('rel_type', 'sale_order');
		$qry = $this->db->get();			
		$result = $qry->result_array();	
		return $result;
	}*/
	
	public function get_attachmets_by_saleOrderId($table ,$where = '') {
		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*');    
			$dynamicdb->from($table);
			$dynamicdb->where($where);
			$qry = $dynamicdb->get();			
			$result = $qry->result_array();	
			return $result;
		}
	}
	
		/* Function to fetch Data by Id */
	/*public function getTargetsByDate($table ,$field, $fieldValue) {
		$this->db->select('*');    
		$this->db->from($table);
		$this->db->where($table.'.'.$field, $fieldValue);
		$this->db->where($table.'.created_by', $_SESSION['loggedInUser']->c_id);
		$qry = $this->db->get();			
		$result = $qry->result_array();	
		return $result;
	} */
	
	
	/* Update Data */
	public function updateSaleTarget($table,$where = array(),$db_data) {
		$data = $db_data;
		$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($where);		
		$result = $this->db->update($table, $db_data);
		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($where);		
			$dynamicdb->update($table, $db_data);
		}			
		return $result;
	
	/*	if($this->db->update($table, $db_data)){			
		return TRUE;
		}
		else {
		return  'Target is already set or this month';
		}*/
	}	
	public function insertPriorityData($table , $data = array()) {
		if(!empty($data)){			
			foreach($data as $dt){
				$fieldData = $this->get_field_type_data($dt,$table);
				$this->db->insert($table,$fieldData);
				$insertedid = $this->db->insert_id();	
				if($_SESSION['loggedInUser']->role != 3){	
					if($insertedid){
						$dynamicdb = $this->load->database('dynamicdb', TRUE);
						$fieldData['sale_order_priority_id'] = $insertedid;	
						$dynamicInsertedid = $dynamicdb->insert($table,$fieldData);
					}
				}
			}
			return $insertedid; 
		}
	}
	
	public function get_sale_target_data_by_company_user($table = '' , $where = array()) {
		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select($table.'.*,user.id AS user_id'); 
			$dynamicdb->from($table);
			//$this->db->join("user", $table . ".user_id = user.id", 'left');
			$dynamicdb->join("user", "user.id = ".$table . ".user_id", 'left');
			$dynamicdb->where($where);		
			$qry = $dynamicdb->get();	
			$result = $qry->result_array();	
			return $result;
		}
	}
	
	
	/* Function to fetch Data by Id */
	public function getTargetsByDate($table ,$field, $fieldValue) {
		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*');    
			$dynamicdb->from($table);
			$dynamicdb->where($table.'.'.$field, $fieldValue);
			//$dynamicdb->where($table.'.created_by', $_SESSION['loggedInUser']->c_id);

			$dynamicdb->where($table.'.created_by', $this->companyGroupId);
			$qry = $dynamicdb->get();			
			$result = $qry->result_array();	
			return $result;
		}
	}
	
	
	public function getSaleTargetEditDataByMonth($start_date = ''){
		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);	
			$dynamicdb->select('user_detail.u_id , user_detail.name, user_sale_target .*');    
			$dynamicdb->from('user_detail');
			$dynamicdb->join("user_sale_target", "user_detail.u_id = user_sale_target.user_id and user_sale_target.start_date = '".$start_date."'", 'left');
			//$dynamicdb->where('user_detail.c_id', $_SESSION['loggedInUser']->c_id);

			$dynamicdb->where('user_detail.c_id', $this->companyGroupId);
			$qry = $dynamicdb->get();			
			$result = $qry->result_array();	
			return $result;	
		}
	}
	public function insert_on_spot_tbl_data($table,$added_data) {
		$this->db->insert($table,$added_data);
		$cid = $this->db->insert_id();	
		$added_data['id'] = $cid;
		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->insert($table,$added_data);
			$dynamicdb->insert_id();	
		}
		return $cid;
	}
	
	/* Function to fetch Data */
	 public function get_data_material_type($table='' ,$field , $id) {
		if($_SESSION['loggedInUser']->role == 3){	
			$this->tablename = $table?$table:$this->tablename;
			$this->db->select('*'); 
			$this->db->from($this->tablename);
			$this->db->where('id',$id);
			$qry = $this->db->get();
			$result = $qry->result_array();			
			return $result;			
		}else{
			 $dynamicdb = $this->load->database('dynamicdb', TRUE);
			$this->tablename = $table?$table:$this->tablename;
			$dynamicdb->select('*'); 
			$dynamicdb->from($this->tablename);
			$dynamicdb->where('id',$id);
			$qry = $dynamicdb->get();
			$result = $qry->result_array();			
			return $result;			
		}
	}
	
	public function userTargetExist( $user_id = '' , $target = '' ){
		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*'); 
			$dynamicdb->from('user_sale_target');
			$dynamicdb->where('user_id',$user_id);
			$dynamicdb->where('start_date',$target);
			$qry = $dynamicdb->get();			
			$result = $qry->result_array();	
			return $result;
		}
	}
	/*get datab by id from company in sale order */
	public function get_data_byAddress($table,$where = array()){
		if($_SESSION['loggedInUser']->role == 3){	
			$this->db = $this->load->database('dynamicdb', TRUE);			
			$this->db->select('address');    
			$this->db->from($table);
			$this->db->where($where);
			$qry= $this->db->get();
			$result = $qry->result_array();			
			return $result;
		}else{
			$dynamicdb = $this->load->database('dynamicdb', TRUE);			
			$dynamicdb->select('address');    
			$dynamicdb->from($table);
			$dynamicdb->where($where);
			$qry= $dynamicdb->get();
			$result = $qry->result_array();			
			return $result;
		}
	}
	/*company filter in sale order*/
	public function get_filter_details($table = '' , $where = array() , $limit ='') {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$qry = $this->db->get();
		$result = $qry->result_array();	
//echo 	$this->db->last_query();	
		return $result;
	}


	/*   Update single value in table with where array given   */
	public function update_single_value_data($table,$data,$where) {
		$this->db->where($where);
		$this->db->update($table, $data);
		if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($where);
			$dynamicdb->update($table, $data);
		}
		return true;
	}


		/* Function to fetch Data from activity log*/
	public function get_activity_log($table ,$field1,$feild2) {
		if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
			$this->db->select('*');  
			$this->db->from($table);
			$this->db->where($table.'.'.$field1, $table.'.'.$field2);
			$qry = $this->db->get();
		}else{
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*');  
			$dynamicdb->from($table);
			$dynamicdb->where($table.'.'.$field1, $table.'.'.$field2);
			$qry = $dynamicdb->get();
		}
		$result = $qry->row();	
		return $result;
	}

public function importData($data) {
  
    	$res = $this->db->insert_batch('proforma_invoice',$data);
           
		 if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$res = $dynamicdb->insert_batch('proforma_invoice',$data);
		}    
		 if($res){
		 return TRUE;
		 }else{
		 return FALSE;
		 }

 }


public function exportdata() {
        $this->db->select(array('pi.pi_code', 'pi.account_id', 'pi.contact_id', 'pi.party_ref', 'pi.order_date', 'pi.material_type_id','pi.total','pi.grandTotal','pi.dispatch_date','pi.payment_terms','pi.advance_received','pi.cash_discount','discount_offered','product_application','pi.created_date','pi.product'));
        $this->db->from('proforma_invoice as pi');
        $query = $this->db->get();
        return $query->result_array();
    }


public function importContacts($data) {
  
    	$res = $this->db->insert_batch('contacts',$data);
         //echo $this->db->last_query();die();
		 if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$res = $dynamicdb->insert_batch('contacts',$data);
		}    
		 if($res){
		 return TRUE;
		 }else{
		 return FALSE;
		 }

 }

public function exportcontacts() {
        $this->db->select(array('co.contact_owner', 'co.first_name', 'co.last_name', 'co.phone', 'co.mobile', 'co.email', 'co.account_id', 'co.title', 'co.mailing_street', 'co.mailing_city', 'co.mailing_zipcode', 'co.mailing_state', 'co.mailing_country', 'co.other_street', 'co.other_city', 'co.other_zipcode', 'co.other_state', 'co.other_country', 'co.fax', 'co.home_phone', 'co.other_phone', 'co.asst_phone', 'co.assistant', 'co.department', 'co.lead_source', 'co.dob', 'co.description', 'co.company', 'co.created_by', 'co.edited_by'));
        $this->db->from('contacts as co');
        $query = $this->db->get();
        return $query->result_array();
    }


public function importLeads($data) {
  
    	$res = $this->db->insert_batch('leads',$data);
           
		 if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$res = $dynamicdb->insert_batch('leads',$data);
		}    
		 if($res){
		 return TRUE;
		 }else{
		 return FALSE;
		 }

 }

public function exportleads() {
        $this->db->select(array('le.website','le.company','le.designation','le.street','le.city','le.state','le.country','le.zipcode','le.lead_source','le.lead_owner','le.grand_total','le.created_by','le.edited_by','le.created_by_cid','le.lead_status','le.created_date','le.updated_date'));
        $this->db->from('leads as le');
        $query = $this->db->get();
        return $query->result_array();
    }
	
	
	// public function get_DuplicateDATA($table, $fieldData , $fieldName) {
	public function get_DuplicateDATA($table, $where) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		
		$dynamicdb->select('*');
		$dynamicdb->from($table);
		
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		$result = $qry->num_rows();

		return $result;
	   
	   
    }



public function markfavour($table,$data,$key) {
			$data1 = array('favourite_sts' => $data);
			$ids = $key;
			$this->db->where('id',$ids);
			$result = $this->db->update($table,$data1);

		if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('id',$ids);		
			$dynamicdb->update($table, $data1);	
		}
		return TRUE;
	}

/*PipeLine change status fucntion*/
	public function change_process_status($data, $id) {	
		$data = array( 
					'lead_status' => $_POST['processTypeId']
				);	
		$this->db->where('id', $_POST['processId']);	
		$this->db->update('leads', $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
		$dynamicdb->where('id', $_POST['processId']);	
		$dynamicdb->update('leads', $data);
		return true;
		
	}
/*PipeLine change  order fucntion*/
   public function change_process_order($orders){
		foreach ($orders as $order) {
            $id = $order['id'];
                if ($order['id'] == $id) {					
					$data =  array('order_id' => $order['position']);	
					$this->db->where('id', $id);
					$this->db->update('leads', $data);
					$dynamicdb = $this->load->database('dynamicdb', TRUE);
					$data =  array('order_id' => $order['position']);	
					$dynamicdb->where('id', $id);
					$dynamicdb->update('leads', $data);			
				}
			}
		}	

public function insertcustomertypeOLD($table , $data = array()) {
	
		$this->db->insert($table,$data);
		echo $this->db->last_query();die();
		
		die();
        $id = $this->db->insert_id();
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        if( $id ){
            $dynamicdb->insert($table,$data);
            return $dynamicdb->insert_id();
        }
	}
	public function insertcustomertype($table , $data = array()) {
		if(!empty($data)){
			foreach($data as $dt){

				$fieldData = $this->get_field_type_data($dt,$table);
				$this->db->insert($table,$fieldData);
				$insertedid = $this->db->insert_id();
				if($_SESSION['loggedInUser']->role != 3){
					if($insertedid){
						$dynamicdb = $this->load->database('dynamicdb', TRUE);
						//$fieldData['sale_order_priority_id'] = $insertedid;
						$dynamicInsertedid = $dynamicdb->insert($table,$fieldData);
					}
				}
			}
			return $insertedid;
		}
	}

public function insertcustomertype222($table , $data = array()) {
		if(!empty($data)){			
			foreach($data as $dt){
			
				$fieldData = $this->get_field_type_data($dt,$table);
				$this->db->insert($table,$fieldData);
				$insertedid = $this->db->insert_id();	
				if($_SESSION['loggedInUser']->role != 3){	
					if($insertedid){
						$dynamicdb = $this->load->database('dynamicdb', TRUE);
						//$fieldData['sale_order_priority_id'] = $insertedid;	
						$dynamicInsertedid = $dynamicdb->insert($table,$fieldData);
					}
				}
			}
			return $insertedid; 
		}
	}

public function get_last_record($table , $feild1 , $feild2 , $feild3){
     $this->db->select($feild1,$feild2,$feild3);
     $this->db->from($table);
     $this->db->order_by('id', 'DESC'); // 'create_at' is the column name of the date on which the record has stored in the database.
     $qry = $this->db->get();
     $result = $qry->row();	
		return $result;
}



public function record_exists($table , $feild){
   $exists = $this->db->get_where($table,$feild);
   if($exists->num_rows() > 0 ){
      # echo "Some message";
       return true;
   }else{
      # echo "message";
      return false;
   }
}


function updateRowWhere($table, $where = array(), $data = array()) {
    
    $this->db->where($where);
    $this->db->update($table, $data);

    if($_SESSION['loggedInUser']->role != 3){	
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($where);	
			$dynamicdb->update($table, $data);	
		}

   // echo $this->db->last_query();
}


public function toggle_change_status($id, $status) {	
	
		$this->db->where('id', $id);
		$status = array('active_inactive' => $status);
		$this->db->update('types_of_customer', $status);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $id);
		#$status = array('active_inactive' => $status);
		$dynamicdb->update('types_of_customer', $status);
		return true;
	}	
	
	
	public function leadSourceStatus($id, $status) {	
		$this->db->where('id', $id);
		$status = array('active_inactive' => $status);
		$this->db->update('add_lead_source', $status);
		
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $id);
		//$statusw = array('active_inactive' => $status);
		
		$dynamicdb->update('add_lead_source', $status);
		 // echo $dynamicdb->last_query();die();
		return true;
	}
	public function SaleAreaStatus($id, $status) {	
		$this->db->where('id', $id);
		$status = array('active_inactive' => $status);
		$this->db->update('sales_area', $status);
		
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $id);
		//$statusw = array('active_inactive' => $status);
		
		$dynamicdb->update('sales_area', $status);
		 // echo $dynamicdb->last_query();die();
		return true;
	}	
//end of modal





public function get_data_listing($table = '',$where = array(),$limit, $start,$where2,$order,$export_data){
#pre($where);
#die;	
//pagination
		$start = ($start-1) * $limit;	
		if($_SESSION['loggedInUser']->role == 3){			
			$table = $table?$table:$this->tablename;
			if($table == 'leads'){
				$this->db->select($table.'.* ,createdBy.name AS createdByName, leadOwner.name AS leadOwnerName'); 
				$this->db->from($table);
				$this->db->join("user_detail as createdBy", $table . ".created_by = createdBy.u_id", 'left');
				$this->db->join("user_detail as leadOwner", $table . ".lead_owner = leadOwner.u_id", 'left');
			}else{			
				$this->db->select('*'); 
				$this->db->from($table);
			}
			$this->db->where($where);
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
	//	$dynamicdb->order_by('id',$order);
		//	$dynamicdb->limit($limit, $start);
			//$this->db->limit($limit, $offset);	
			$qry = $this->db->get();
			echo $dynamicdb->last_query();			
			$result = $qry->result_array();	
			return $result;
		}else{			
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			if($table == 'leads'){
				$dynamicdb->select($table.'.* ,createdBy.name AS createdByName, leadOwner.name AS leadOwnerName'); 
				$dynamicdb->from($table);
				$dynamicdb->join("user_detail as createdBy", $table . ".created_by = createdBy.u_id", 'left');
				$dynamicdb->join("user_detail as leadOwner", $table . ".lead_owner = leadOwner.u_id", 'left');
			}else{			
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
			if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
			
		//$dynamicdb->order_by('id',$order);
		//	$dynamicdb->limit($limit, $start);
			//$dynamicdb->limit($limit, $offset);
			if($table == 'leads'){
			    $dynamicdb->group_by('id');
			}
			$qry = $dynamicdb->get();
			#echo $dynamicdb->last_query();			
			$result = $qry->result_array();				
			return $result;
		}
	}	


public function get_data_listing1($table = '',$where = array(),$limit, $start,$where2,$order,$export_data){	
//pagination
		$start = ($start-1) * $limit;	
		if($_SESSION['loggedInUser']->role == 3){			
			$table = $table?$table:$this->tablename;
			if($table == 'leads'){
				$this->db->select($table.'.* ,createdBy.name AS createdByName, leadOwner.name AS leadOwnerName'); 
				$this->db->from($table);
				$this->db->join("user_detail as createdBy", $table . ".created_by = createdBy.u_id", 'left');
				$this->db->join("user_detail as leadOwner", $table . ".lead_owner = leadOwner.u_id", 'left');
			}else{			
				$this->db->select('*'); 
				$this->db->from($table);
			}
			$this->db->where($where);
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
	//	$dynamicdb->order_by('id',$order);
			#$dynamicdb->limit($limit, $start);
			//$this->db->limit($limit, $offset);	
			$qry = $this->db->get();	
			$result = $qry->result_array();	
			return $result;
		}else{			
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			if($table == 'leads'){
				$dynamicdb->select($table.'.* ,createdBy.name AS createdByName, leadOwner.name AS leadOwnerName'); 
				$dynamicdb->from($table);
				$dynamicdb->join("user_detail as createdBy", $table . ".created_by = createdBy.u_id", 'left');
				$dynamicdb->join("user_detail as leadOwner", $table . ".lead_owner = leadOwner.u_id", 'left');
			}else{			
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
			if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
			
		//$dynamicdb->order_by('id',$order);
			#$dynamicdb->limit($limit, $start);
			//$dynamicdb->limit($limit, $offset);							
			$qry = $dynamicdb->get();			
			$result = $qry->result_array();				
			return $result;
		}
	}	



public function num_rows($table, $where = array() , $search_string = '',$ownerKey = '', $likeArray = array()){
		if($_SESSION['loggedInUser']->role == 3){			
			$table = $table?$table:$this->tablename;
			$this->db->select('*'); 
			$this->db->from($table);
			$this->db->where($where);
			if($ownerKey != '')
				$this->db->where($ownerKey,$_SESSION['loggedInUser']->id);	
			if($search_string!='') {
				$this->db->like($table.'.id',$search_string);
				$this->db->or_like($likeArray);
			}
			$qry = $this->db->get();	
			$result = $qry->result_array();	
		}else{			
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$table = $table?$table:$this->tablename;
			$dynamicdb->select('*'); 
			$dynamicdb->from($table);
			$dynamicdb->where($where);
			if($ownerKey != '')
				$dynamicdb->where($ownerKey,$_SESSION['loggedInUser']->id);	
			if($search_string!='') {
				$dynamicdb->like($table.'.id',$search_string);
				$dynamicdb->or_like($likeArray);
			}
			$qry = $dynamicdb->get();	
			$result = $qry->num_rows();	
		}		
		return $result;
	}	
	
public function get_data_user_detail($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		if($table=="sub_module" || $table=="modules" || $table=="activity_log" || $table=="user_detail" || $table =="work_status" || $table == "worker"){
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
		$result = $qry->result_array();	
		return $result;
	}	

	public function get_matrial_data_byId($table ,$field, $id) {
		// $this->db->select('*');  
		// $this->db->from($table);
		// $this->db->where($field, $id );
		// $qry = $this->db->get();
		// $result = $qry->row();	
		// return $result;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');  
		$dynamicdb->from($table);
		$dynamicdb->where($field, $id );
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query();die();
		$result = $qry->row();	
		return $result;
	}
	

	public function update_data_add_comment($tablename,$data,$field,$id){
		$this->db->where($field, $id);		
		$this->db->update($tablename, $data);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($field,$id);
		$dynamicdb->update($tablename,$data);
		#echo $this->db->last_query();
		return true;
		}


		public function importlead($data) {
		    	$res = $this->db->insert_batch('leads',$data);
				 if($_SESSION['loggedInUser']->role != 3){
					$dynamicdb = $this->load->database('dynamicdb', TRUE);
					$res = $dynamicdb->insert_batch('leads',$data);
				}    
				 if($res){
				 return TRUE;
				 }else{
				 return FALSE;
				 }
		 }

		 public function import_price_list($data) {
		    	$res = $this->db->insert_batch('import_price_list',$data);
				 if($_SESSION['loggedInUser']->role != 3){
					$dynamicdb = $this->load->database('dynamicdb', TRUE);
					$res = $dynamicdb->insert_batch('import_price_list',$data);
				}    
				 if($res){
				 return TRUE;
				 }else{
				 return FALSE;
				 }
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

    public function insert_multiple_data_mtloc($table, $data) {

    	pre($table);
    	pre($data);
    	die;
        if (!empty($data)) {
            foreach ($data as $dt) {
                $this->db->insert($table, $dt);
                $insertedid = $this->db->insert_id();
                if ($insertedid) {
                    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
                        $dynamicdb = $this->load->database('dynamicdb', TRUE);
                        $dt['id'] = $insertedid;
                        $dynamicInsertedid = $dynamicdb->insert('mat_locations', $dt);
                        echo $dynamicdb->last_query();
                    }
                }
            }
            //return $insertedid;
            
        }
        return true;
    }

    public function update_leads_history_enddates($id, $end_date) {
		$this->db->where('id', $id);		
		$en_dt = array('end_date' => $end_date);
		$this->db->update('leads_status_history', $en_dt);
		//	echo $this->db->last_query();die();
		if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where('id', $id);	
			$dynamicdb->update('leads_status_history', $en_dt);
		}
		return true;
	}	

	public function importCompanies($data) {
    	$res = $this->db->insert_batch('account',$data);
         //echo $this->db->last_query();die();
		 if($_SESSION['loggedInUser']->role != 3){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$res = $dynamicdb->insert_batch('account',$data);
		}    
		 if($res){
		 return TRUE;
		 }else{
		 return FALSE;
		 }
 	}
	
	 public function crm_delivery($id, $status) {	
		$this->db->where('id', $id);
		$status = array('crm_delivery_setting' => $status);
		$this->db->update('company_detail', $status);
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('id', $id);
		 //$status = array('crm_delivery_setting' => $status);
		$dynamicdb->update('company_detail', $status);
		return true;
	}
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
	public function get_compdata($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*'); 
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		#echo $dynamicdb->last_query();
		$result = $qry->result_array();			
		return $result;
	}
	
	/*function to ftech image by id*/
    public function get_image_by_materialId($table, $field, $id) {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where($field, $id);
            $this->db->where('rel_type', 'material');
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($field, $id);
            $dynamicdb->where('rel_type', 'material');
            $qry = $dynamicdb->get();
        }
        $result = $qry->result_array();
        return $result;
    }
	public function area_exits($area) {
        $this->db->select('*');
        $this->db->from('sales_area');
        $this->db->where('sales_area',$area);
        $this->db->where('created_by_cid',$this->companyGroupId);
        $qry = $this->db->get();
		// echo $this->db->last_query();die();
        $result = $qry->result_array();
        return $result;
    }
	
}