<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends ERP_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tablename = 'leads';
        //$this->column_search = array('name');
    }  
	
	/* database field columns */
	public function get_field_type_data($data, $table){
		switch($table){
			case 'leads':				
				$all_fields = array('company','designation','street','city','state','country','zipcode','website','lead_source','material_type_id','product_detail','grand_total','lead_status','lead_owner','created_by','contacts','converted_to_account','converted_to_contact','edited_by','created_by_cid','save_status');
				break;			
			case 'account':
				$all_fields = array('account_owner','name','phone','fax','parent_account','website','type','employee','industry','revenue','description','billing_street','billing_city','billing_zipcode','billing_state','billing_country','shipping_street','shipping_city','shipping_zipcode','shipping_state','shipping_country','gstin','email','created_by','edited_by','save_status');
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
				$all_fields = array('company_unit','account_id','contact_id', 'order_date', 'product', 'dispatch_date', 'agt', 'freight', 'payment_terms', 'advance_received', 'cash_discount', 'discount_offered', 'label_printing_express', 'brand_label', 'dispatch_documents', 'product_application', 'guarantee','created_by','created_by_cid','total','grandTotal','payment_date','save_status','party_ref','material_type_id','completed_by','complete_status');
				break;			
			case 'proforma_invoice':
				$all_fields = array('account_id','contact_id', 'order_date', 'product', 'dispatch_date', 'agt', 'freight', 'payment_terms', 'advance_received', 'cash_discount', 'discount_offered', 'label_printing_express', 'brand_label', 'dispatch_documents', 'product_application', 'guarantee','created_by','created_by_cid','total','grandTotal','save_status','party_ref','material_type_id');
				break;
			case 'user_sale_target':
				$all_fields = array('user_id','created_by','sale_target','lead_generation_target','payment_target','start_date','end_date','save_status');
				break;
			case 'sale_order_priority':
				$all_fields = array('sale_order_id','product_id','gst','quantity','uom','price','individualTotal','individualTotalWithGst','created_by_cid','priority');
				break;
			case 'ledger':
				$all_fields = array('name','account_group_id','mailing_address','contact_person','phone_no','mobile_no','email','website','registration_type','gstin','pan','created_by','edited_by','parent_group_id','conn_comp_id','created_by_cid','compny_branch_id','save_status','opening_balance');
				break;	
			case 'user_dashboard':
				$all_fields = array('graph_id','user_id','show');
				break;
			case 'attachments':
				$all_fields = array('rel_type','rel_id','file_type','file_name');
				break;
			case 'sale_order_dispatch':
				$all_fields = array('account_id','product', 'dispatch_date','dispatch_documents', 'comments', 'transport_tel_no','vehicle_no','created_by','created_by_cid','total','grandTotal','invoice_no','save_status','material_type_id','sale_order_id');
				break;
		}
		return $data = format_data_to_be_added($all_fields, $data);
	}
	
	
	 /* Function to fetch Data */
	public function get_data($table = '' , $where = array(), $limit = '') {	
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$table = $table?$table:$this->tablename;
		$dynamicdb->select('*'); 
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		if($limit !='')	
		$dynamicdb->limit($limit);
		if($table != 'permissions')
		$dynamicdb->order_by('created_date', "desc");		
		$qry = $dynamicdb->get();	
		$result = $qry->result_array();	
		return $result;
	}	

	
}