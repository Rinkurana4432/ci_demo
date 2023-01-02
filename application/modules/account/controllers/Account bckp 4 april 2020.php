<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Account extends ERP_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            redirect( base_url().'auth/login', 'refresh');
        }
		/*$this->settings['parent_menu'] = 'setup';
		$this->settings['active_menu'] = 'setup';		*/
        $this->load->library(array( 'form_validation'));
		
		$this->load->helper('account/account');
        $this->load->model('account_model');
		$this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
		$this->settings['css'][] = 'assets/plugins/ion.rangeSlider/css/ion.rangeSlider.css';
		$this->settings['css'][] = 'assets/modules/account/css/custom_style.css';
		$this->settings['css'][] = 'assets/plugins/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css';
		$this->settings['css'][] = 'assets/modules/account/css/style.css';
		$this->settings['css'][] = 'assets/css/new-style.css';
		$this->scripts['js'][] = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';
		$this->scripts['js'][] = 'assets/plugins/ion.rangeSlider/js/ion.rangeSlider.min.js';
		$this->scripts['js'][] = 'assets/js/select2.js';
		$this->scripts['js'][] = 'assets/js/custom/ajax_script.js';	
		
		
		$this->scripts['js'][] = 'assets/plugins/fastclick/lib/fastclick.js';
		$this->scripts['js'][] = 'assets/plugins/nprogress/nprogress.js';
		$this->scripts['js'][] = 'assets/plugins/raphael/raphael.min.js';
		$this->scripts['js'][] = 'assets/plugins/morris.js/morris.min.js';		
		$this->scripts['js'][] = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';		
		$this->scripts['js'][] = 'assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js';
		
	
		$this->settings['css'][] = 'assets/plugins/switchery/dist/switchery.min.css';
		$this->scripts['js'][] = 'assets/plugins/switchery/dist/switchery.min.js"';
		$this->scripts['js'][] = 'assets/modules/purchase/js/script.js';
		$this->scripts['js'][] = 'assets/modules/inventory/js/script.js';
		$this->scripts['js'][] = 'assets/modules/account/js/script.js';
		
		
		
		
		
	}
	
    /* Main Function to fetch all the listing of departments */
    public function index() { 
		/*if(!is_admin()){
			redirect( base_url().'dashboard', 'refresh');
		}*/
		#else{
			$this->data['title'] = "Users";
			$this->data['module'] = "User";
			$this->data['sidetab'] = "support";
			$this->data['currenttab'] = "User";
			$this->settings['module_title'] = 'Users';
			$this->data['company']  = $this->account_model->get_data('company',array('user_id'=> 0));	
			$this->_render_template('index', $this->data);
		#}
    }
	
	/* Main Function to fetch all the listing of departments */
    public function account_groups() { 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account Group', base_url() . 'leads');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Account Group';
		$created_id = $_SESSION['loggedInUser']->u_id;
		$this->data['account_groups']  = $this->account_model->get_data_with_zero_id_condtions('account_group',$created_id);
		$this->_render_template('account_group/index', $this->data);
    }
		
	public function editAccountGroup(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['account_group'] = $this->account_model->get_data_byId('account_group','id',$this->input->post('id'));			
			$this->load->view('account_group/edit', $this->data);
		}	
	}
	
	/*  Function to add/edit Lead */
	public function saveAccountGroup(){	 
		if ($this->input->post()) { 
		//pre($_POST);die();
			$required_fields = array('name');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				$data  = $this->input->post();	
				
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				$id = $data['id'];
				// $default_group_name_check = checkValue('account_group',$data['name'],'name');
				// if($default_group_name_check > 0){
					// $this->session->set_flashdata('message', 'This Group Name is Alrady Added');
					// redirect(base_url().'account/account_groups', 'refresh');
					
				// }
				
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->account_model->update_data('account_group',$data, 'id', $id);	
					if ($success) {
                        $data['message'] = "Group updated successfully";
                        logActivity('Group Updated','account_group',$id);
                        $this->session->set_flashdata('message', 'Group Updated successfully');
					    redirect(base_url().'account/account_groups', 'refresh');
                    }
				}else{
					$id = $this->account_model->insert_tbl_data('account_group',$data);					
					if ($id) {                        
                        logActivity('New Group Created','account_group',$id);
                        $this->session->set_flashdata('message', 'Group inserted successfully');
					    redirect(base_url().'account/account_groups', 'refresh');
                    }else{
						$this->session->set_flashdata('message', 'This Group Name is Alrady Added');
					    redirect(base_url().'account/account_groups', 'refresh');
					}   				
				}
				
			}			
        }
	}
	
	
	/* Main Function to fetch all the listing of departments */
    public function ledgers() { 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account', base_url() . 'ledger');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Ledgers';
		$created_id = $_SESSION['loggedInUser']->u_id;
		$created_c_id = $_SESSION['loggedInUser']->c_id;
		//pre($_POST);
		//$this->data['ledgers']  = $this->account_model->get_data('ledger',array('created_by'=> $created_id));
		if(!empty($_POST)){
		 $invalid_gst = implode(',', $_POST['gst_number']);
		 
			$this->data['ledgers']  = $this->account_model->get_ledgers_whereIn_conditions('ledger',$created_c_id,$invalid_gst);
			$this->_render_template('ledger/index', $this->data);
		}else{
			$this->data['ledgers']  = $this->account_model->get_data_with_zero_id_condtions('ledger',$created_c_id);
			$this->_render_template('ledger/index', $this->data);
		}	
    }
	
	public function editLedger(){
	
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['ledger'] = $this->account_model->get_data_byId('ledger','id',$this->input->post('id'));
		//echo 'there';die();
			$this->load->view('ledger/edit', $this->data);
		}	
	}
	
	public function viewLedger(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['ledger'] = $this->account_model->get_data_byId('ledger','id',$this->input->post('id'));			
			$this->load->view('ledger/view', $this->data);
		}	
	}
	
		/*  Function to add/edit Lead */
	public function saveLedger(){
		//
		if ($this->input->post()) {
			
			///pre($_POST);die();
			$required_fields = array('name','account_group_id');	
			
			$mailing_addressLength = count($_POST['mailing_address']);
				if($mailing_addressLength >0){
					$arr = [];
					$i = 0;
					$tt = 1;
					while($i < $mailing_addressLength) {	
						$jsonArrayObject = (array('ID'=>$tt,'mailing_name' =>$_POST['mailing_name'][$i],'mailing_address' => $_POST['mailing_address'][$i],'mailing_country' => $_POST['mailing_country'][$i], 'mailing_state' => $_POST['mailing_state'][$i], 'mailing_city' => $_POST['mailing_city'][$i], 'mailing_pincode' => $_POST['mailing_pincode'][$i],'gstin_no' => $_POST['gstin_no'][$i]));
						$arr[$i] = $jsonArrayObject;
						$i++;				
						$tt++;				
					}
					$descr_of_ldgr_array = json_encode($arr);
				}else{
					$descr_of_ldgr_array = '';
				}
		
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}else{
				
				$data  = $this->input->post();
				    $created_by_id = $_SESSION['loggedInUser']->u_id;
					$group_id = $_POST['account_group_id']; 
					$dd = $this->account_model->get_ledger_account_grp_Dtl('account_group',$created_by_id,$group_id); 
					
					//@$data['parent_group_id'] = $dd[0]['parent_group_id'];	
				
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				$data['mailing_address'] = $descr_of_ldgr_array;	
				$id = $data['id'];
			 
				if($id && $id != ''){
					 $created_by_id = $_SESSION['loggedInUser']->u_id; 
					 $group_id = $_POST['account_group_id']; 
					 $dd = $this->account_model->get_ledger_account_grp_Dtl('account_group',$created_by_id,$group_id); 
					// $data['parent_group_id'] = @$dd[0]['parent_group_id'];	
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					//pre($data);die();
					$success = $this->account_model->update_data('ledger',$data, 'id', $id);	
					if ($success) {
                        $data['message'] = "Ledger updated successfully";
                        logActivity('Ledger Updated','ledger',$id);
                        $this->session->set_flashdata('message', 'Ledger Updated successfully');
					    redirect(base_url().'account/ledgers', 'refresh');
                    }
				}else{
					
					$id = $this->account_model->insert_tbl_data('ledger',$data);
					if ($id) {                        
                        logActivity('New Ledger Created','ledger',$id);
                        $this->session->set_flashdata('message', 'Ledger Inserted successfully');
					    redirect(base_url().'account/ledgers', 'refresh');
                    }    				
				}
			}			
        }
	}
	



	/*delete supplier*/
	public function deleteLedger($id = ''){	
		if (!$id) {
           redirect('account/ledgers', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('ledger','id',$id);
		if($result){
			logActivity('Ledgers Deleted','ledger',$id);
			$this->session->set_flashdata('message', 'Ledger Deleted Successfully');
			$result = array('msg' => 'Ledger Deleted Successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/ledgers');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
	}
	public function deleteAccountGroup($id = ''){
		if (!$id) {
           redirect('account/account_groups', 'refresh');   
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('account_group','id',$id);
		if($result){
			logActivity('Account Group Deleted','account_group',$id);
			$this->session->set_flashdata('message', 'Account Group Deleted Successfully');
			$result = array('msg' => 'Account Group Deleted Successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/account_groups');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => '188'));
        }
		
	}
	public function voucher_types() { 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Voucher Type', base_url() . 'Voucher');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Voucher';
		$created_id = $_SESSION['loggedInUser']->u_id;
		$created_cid = $_SESSION['loggedInUser']->c_id;
		$this->data['voucher']  = $this->account_model->get_data_with_zero_id_condtions('voucher_type',$created_cid); 
		$this->_render_template('voucher/index', $this->data);
    }
	public function saveVoucher_type(){	  
		if ($this->input->post()) {
			$required_fields = array('voucher_name','voucher_desc');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				$data  = $this->input->post();			
				$data['created_by_uid'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_c_id'] = $_SESSION['loggedInUser']->c_id;
				$id = $data['id'];
				//pre($data);die('dd');
				$default_voucher_name_check = checkValue('voucher_type',$data['voucher_name'],'voucher_name');
				if($default_voucher_name_check > 0){
					$this->session->set_flashdata('message', 'This Voucher Name is Alrady Added');
					redirect(base_url().'account/voucher_types', 'refresh');
				}
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->account_model->update_data('voucher_type',$data, 'id', $id);	
					if ($success) {
                        $data['message'] = "Voucher updated successfully";
                        logActivity('Voucher  Updated','voucher_type',$id);
                        $this->session->set_flashdata('message', 'Voucher Type Updated successfully');
					    redirect(base_url().'account/voucher_types', 'refresh');
                    }
				}else{
					$id = $this->account_model->insert_tbl_data('voucher_type',$data);  					
					if ($id) {                        
                        logActivity('New Voucher Created','voucher_type',$id);
                        $this->session->set_flashdata('message', 'Voucher Type inserted successfully');
					    redirect(base_url().'account/voucher_types', 'refresh');
                    }    				
				}
			}			
        }
	}
	/* Quick Add voucher */
	public function quick_add_voucher(){
		$voucher_name = $_REQUEST['voucher_name'];
		$voucher_desc = $_REQUEST['voucher_desc'];
		
		$vouchers_details = array(
					'voucher_name'=>$voucher_name,
					'voucher_desc'=>$voucher_desc,
					'created_by_c_id'=>$_SESSION['loggedInUser']->c_id,
					'created_by_uid'=>$_SESSION['loggedInUser']->u_id,
				);	
		
		
		$data = $this->account_model->insert_on_spot_tbl_data('voucher_type',$vouchers_details);
		if($data > 0){
			echo 'true';
		}else{
			echo 'false';
		}
	}
	
	/* Quick Add voucher */
	
	
	public function viewVoucher(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['voucher'] = $this->account_model->get_data_byId('voucher_type','id',$this->input->post('id'));			
			$this->load->view('voucher/view', $this->data);
		}	
	}
	public function editVoucher(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['voucher'] = $this->account_model->get_data_byId('voucher_type','id',$this->input->post('id'));			
			$this->load->view('voucher/edit', $this->data);
		}	
	}
	public function deleteVoucher($id = ''){	
		if (!$id) {
           redirect('account/voucher_types', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('voucher_type','id',$id);
		if($result){
			logActivity('Voucher Deleted','voucher_type',$id);
			$this->session->set_flashdata('message', 'Voucher Deleted Successfully');
			$result = array('msg' => 'Voucher Deleted Successfully', 'status' => 'success', 'code' => 'C264','url' => base_url() . 'account/voucher_types');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}
	
	//Add Voucher Function
	
	public function invoices() { 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Invoice Details', base_url() . 'Add Invoice');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Add Invoice Details';
		$created_by_id  = $_SESSION['loggedInUser']->c_id;
		
		/* For Financial Year*/
			$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id);//Fetch Data to Company Table
			$date_fcal = json_decode($date_fun->financial_year_date,true);
			
			if(empty($date_fcal)){
				if (date('m') <= 4) {//Upto June 2014-2015
					$mydate = date(date('Y-04-01'));
					$lastyear = strtotime("-1 year", strtotime($mydate));
					$first_date = date("Y-m-d", $lastyear); 
					$date = date(date('Y-03-31'));
					$second_date = date('Y-m-d', strtotime("$date"));
				} else {//After June 2015-2016
					$mydate = date(date('Y-04-01'));
					$lastyear = strtotime("-1 year", strtotime($mydate));
					$first_date = date("Y-m-d", $lastyear);
					$date = date(date('Y-03-31'));
					$second_date = date('Y-m-d', strtotime("$date"));
				}
			}else{
				
				if (date('m') <= 4) {//Upto June 2014-2015
					$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
					$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
					$first_date = date(date($s_Date));
					$date = date(date($e_Date));
					$second_date = date('Y-m-d', strtotime("$date"));
				} else {//After June 2015-2016
					$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
					$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
					$first_date = date(date($s_Date));
					$date = date(date($e_Date));
					$second_date = date('Y-m-d', strtotime("$date"));
				}
			}	
/* For Financial Year*/
		if(!empty($_POST['hsnsac_number'])){
			$invalid_hsnsac = implode(',', $_POST['hsnsac_number']);
			$this->data['add_invoice_details']  = $this->account_model->get_ledgers_whereIn_conditions('invoice',$created_by_id,$invalid_hsnsac);
			$this->_render_template('invoice/index', $this->data);
		}

		if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
			
			 $this->data['add_invoice_details']  = $this->account_model->get_invoice_details('invoice',array('created_by_cid'=> $created_by_id,'invoice.created_date >=' =>$first_date, 'invoice.created_date <=' => $second_date));
			 $this->_render_template('invoice/index', $this->data);
		}
		
		if(!empty($_POST) && isset($_POST['start']) &&  isset($_POST['end'])){
			
			$where = array('invoice.created_date >=' => $_POST['start'] , 'invoice.created_date <=' => $_POST['end'],'invoice.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
			$this->data['add_invoice_details']  = $this->account_model->get_invoice_details('invoice',$where);
			//$this->load->view('invoice/index', $this->data);
			$this->_render_template('invoice/index', $this->data);
		}else{
			//$where = array('invoice.created_by_cid' => $_SESSION['loggedInUser']->c_id);
			$where = array('created_by_cid'=> $created_by_id,'invoice.created_date >=' =>$first_date, 'invoice.created_date <=' => $second_date);
			
			$this->data['add_invoice_details']  = $this->account_model->get_invoice_details('invoice',$where);
			
			$where2 = array('account_freeze.created_by_cid' => $_SESSION['loggedInUser']->c_id);
			$this->data['freeze_date']  = $this->account_model->get_account_freeze('account_freeze',$where2);
			$this->_render_template('invoice/index', $this->data);
		}
	
	}
	
	public function viewInvoice_details(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['invoice_detail'] = $this->account_model->get_data_byId('invoice','id',$this->input->post('id'));			
			$this->load->view('invoice/view', $this->data);
		}	
	}
	public function saleregister_view(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['invoice_detail'] = $this->account_model->get_data_byId('invoice','id',$this->input->post('id'));			
			$this->load->view('saleregister/view', $this->data);
		}	
	}
	public function view_unpaid_invoice_detail(){
	
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			//$this->data['purchase_data'] = $this->account_model->get_data_byId('purchase_bill','id',$this->input->post('id'));
			$this->data['invoice_details_unpaid'] = $this->account_model->not_paid_purchase_bill('invoice',array('party_name'=> $_REQUEST['id']));	
			$this->load->view('accountreciveable/view_unpaid_invoices', $this->data);
		}	
	}
	public function editInvoice_details(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');
			$this->data['invoice_detail'] = $this->account_model->get_data_byId('invoice','id',$this->input->post('id'));			
			$this->load->view('invoice/edit', $this->data);
		}	
	}
	public function check_invoice_email(){
		$dataPdf['dataPdf'] = $this->account_model->get_data_byId('invoice','id',292);
		$this->load->view('invoice/invoice_pdf_email',$dataPdf);
	}
	
	public function saveInvoice_Details(){
		
		if ($this->input->post()) {
			//pre($_POST);die();
			
			 $sec = strtotime( $_POST['date_time_of_invoice_issue']);  
			 $add_Date = date ("Y-m-d H:i", $sec); 
			
			
			 if($_POST['save_status'] == '1'){
			
			if($_POST['party_billing_state_id'] != $_POST['sale_company_state_id']){
				$_POST['CGST'] = '';
				 $_POST['SGST'] = '';
			}else{
				 $_POST['IGST'] = '';
			}
			$charges_tax = array_sum($_POST['amt_tax']);//ADD Charges and Discount Tax for add material Tax.
			if($_POST['CGST'] != '' && $_POST['SGST'] != '' ){
				$both_tax = $charges_tax / 2;
			}else{
				$both_tax = $charges_tax;
			}
			
			$descr_of_goodsLength = count($_POST['descr_of_goods']);
				if($descr_of_goodsLength >0){
					$arr = [];
					$i = 0;
					while($i < $descr_of_goodsLength) {	
						$jsonArrayObject = (array('material_id' =>$_POST['material_id'][$i],'descr_of_goods' => $_POST['descr_of_goods'][$i],'hsnsac' => $_POST['hsnsac'][$i], 'quantity' => $_POST['quantity'][$i], 'rate' => $_POST['rate'][$i], 'tax' => $_POST['tax'][$i],'added_tax_Row_val'=> $_POST['added_tax_Row_val'][$i],'UOM' => $_POST['UOM'][$i],'amount'=>$_POST['amount'][$i],'disctype'=>$_POST['disctype'][$i],'discamt'=>$_POST['discamt'][$i],'after_desc_amt'=>$_POST['after_desc_amt'][$i],'amount_with_tax_after_disco'=>$_POST['amount'][$i],'item_code'=>$_POST['item_code'][$i],'cess'=>$_POST['cess'][$i],'valuation_type'=>$_POST['valuation_type'][$i],'cess_tax_calculation'=>$_POST['cess_tax_calculation'][$i]));
						$arr[$i] = $jsonArrayObject;
						$i++;				
					}
					$descr_of_goods_array = json_encode($arr);
				}else{
					$descr_of_goods_array = '';
				}
			
				$get_mat_id_qty = json_decode($descr_of_goods_array);
				
				
			
				$invoice_price_totalLength = count($_POST['invoice_total_with_tax']);
					if($invoice_price_totalLength >0){ 
							$arra = [];
							$j = 0;
						while($j < $invoice_price_totalLength) {	
								$jsonArrayObject1 = array('total' =>$_POST['total'][$j],'totaltax' => $_POST['totaltax'][$j],'invoice_total_with_tax' => $_POST['invoice_total_with_tax'][$j],'cess_all_total' => $_POST['cess_all_total'][$j]);
								$arra[$j] = $jsonArrayObject1;
								$j++;
							}
							$invoice_price_total_array = json_encode($arra);
						}else{
							$invoice_price_total_array = '';
						}
					//pre($invoice_price_total_array);die();
				$charges_Added_Count = 	count($_POST['charges_added']);
					
					if($charges_Added_Count > 0){
						$charg_Add = [];
						$ch = 0;
						while($ch < $charges_Added_Count){
							$jsonarray_chargeobj = (array('particular_charges_name'=>$_POST['particular_charges'][$ch],'type_charges'=>$_POST['type_charges'][$ch],'ledger_name'=>$_POST['ledger_name'][$ch],'ledger_name_id'=>$_POST['ledger_name_id'][$ch],'amt_tax'=>$_POST['amt_tax'][$ch],'charges_added'=>$_POST['charges_added'][$ch],'sgst_amt'=>$_POST['sgst_amt'][$ch],'cgst_amt'=>$_POST['cgst_amt'][$ch],'igst_amt'=>$_POST['igst_amt'][$ch],'amt_with_tax'=>$_POST['amt_with_tax'][$ch]));
							$charg_Add[$ch] = $jsonarray_chargeobj;
							$ch++;
						}
						$json_charg_lead_total_array = json_encode($charg_Add);
					}else{
						$json_charg_lead_total_array = '';
					}
					
					$required_fields = array('party_name');	
					$is_valid = validate_fields($_POST, $required_fields);
					if (count($is_valid) > 0) {
						valid_fields($is_valid);				
					}else{
					
					
					
				$data  = $this->input->post();
				$data['descr_of_goods'] = $descr_of_goods_array;	
				$data['invoice_total_with_tax'] = $invoice_price_total_array;	
				$data['charges_added'] = $json_charg_lead_total_array;	
				
				// $data['disctype'] = $json_discount_added_array;	
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				$id = $data['id'];
				
				
				
				//$check_invoice_num = $this->account->invoiceExist($_POST['invoice_num']);
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					if($data['accept_reject'] !='' && $data['reject_invoice'] !='' ){
						$data['accept_reject'] = '';
						//pre($data);die('1');
						$success = $this->account_model->update_data('invoice',$data, 'id', $id);
						
					}else{	
					//pre($data);die('2');
						 $success = $this->account_model->update_data('invoice',$data, 'id', $id);
					}
					/***************** For Transaction Table Update*********************/
					
					
					// if($_POST['total_amout_without_tax_on_keyup'] != ''){
						// $debit_data['debit_dtl'] = $_POST['total_amout_without_tax_on_keyup'];
					// }
					$ledger_id = $_REQUEST['sale_ledger'];
					$debit_data['credit_dtl'] = $_POST['total_amout_without_tax_on_keyup'];
					$debit_data['type'] = 'invoice';
					$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$debit_data['type_id'] = $id;
					$debit_data['add_date'] = $add_Date;
					//pre($debit_data);die('hmm');
					$this->account_model->update_transaction_data('transaction_dtl',$debit_data, 'type_id', $id, 'invoice',$ledger_id);
					/* For Sale Ledger Details data*/
					
					/* For Purchase Ledger Details data*/
					$credit_data['credit_dtl'] = '0';
					$ledger_id = $_POST['party_name'];
					if($_POST['total_amout_with_tax_on_keyup'] !=''){
					 $credit_data['debit_dtl'] = $_POST['total_amout_with_tax_on_keyup'];
					}
					$credit_data['type'] = 'invoice';
					$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$credit_data['type_id'] = $id;
					$credit_data['add_date'] = $add_Date;
					$this->account_model->update_transaction_data('transaction_dtl',$credit_data, 'type_id', $id, 'invoice',$ledger_id);
					
					/* For Purchase Ledger Details data*/
					
					/* For CGST SGST IGST Table*/
							if($_POST['CGST'] !=''){
								
								$ledger_id = '2';
								$CGST_data['debit_dtl'] = '0';
								$CGST_data['credit_dtl'] = $_POST['CGST'] + $both_tax ;
								$CGST_data['type'] = 'invoice';
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$CGST_data['type_id'] = $id;
								$CGST_data['add_date'] = $add_Date;
								$this->account_model->update_transaction_data('transaction_dtl',$CGST_data, 'type_id', $id, 'invoice',$ledger_id);
							}
							
							if($_POST['SGST'] != ''){
								$SGST_data['debit_dtl'] = '0';
								$ledger_id = '3';
								$SGST_data['credit_dtl'] = $_POST['SGST'] + $both_tax ;
								$SGST_data['type'] = 'invoice';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->update_transaction_data('transaction_dtl',$SGST_data, 'type_id', $id, 'invoice',$ledger_id);
							}
							
							if($_POST['IGST'] != ''){
								$IGST_data['debit_dtl'] = '0';
								$ledger_id = '1';
								$IGST_data['credit_dtl'] = $_POST['IGST'] + $both_tax ;
								$IGST_data['type'] = 'invoice';
								$IGST_data['type_id'] = $id;
								$IGST_data['add_date'] = $add_Date;
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$IGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->update_transaction_data('transaction_dtl',$IGST_data, 'type_id', $id, 'invoice',$ledger_id);
							}
							
					/* For CGST SGST IGST Table*/
					/*INSERT Code For charges Ledgers and Discount Ledgers*/
					$ddt =	json_decode($json_charg_lead_total_array, true);
					
				if($ddt[0]['particular_charges_name'] != ''){
						$charges_Discount_data = json_decode($json_charg_lead_total_array,true);
						foreach($charges_Discount_data as $chrg_data){
							if(!empty($chrg_data)){
							if($chrg_data['type_charges'] == 'plus'){
								
								$charges_Data['debit_dtl'] = '0';
								$charges_Data['credit_dtl'] = $chrg_data['charges_added'];
								$charges_Data['add_date'] = $add_Date;
								$this->account_model->update_single_data_for_charges($chrg_data['amt_with_tax'], $id,'invoice');//USd to add Charges in Per invoice 
								$this->account_model->update_transaction_data('transaction_dtl',$charges_Data, 'type_id', $id, 'invoice',$chrg_data['ledger_name_id']);
							}else{
								$charges_Data['debit_dtl'] = $chrg_data['charges_added'];
								$charges_Data['credit_dtl'] = '0';
								$charges_Data['add_date'] = $add_Date;
								$this->account_model->update_transaction_data('transaction_dtl',$charges_Data, 'type_id', $id, 'invoice',$chrg_data['ledger_name_id']);	
							}
						}
						}		
					}
					/***************** For Transaction Table Update*********************/
					
					/* Inventory Flow*/
					if(!empty($data) && $data['descr_of_goods'] !=''){
						$inventoryFlowData = json_decode($data['descr_of_goods']);
						$inventoryFlowDataArray = [];
						$inCount = 0;
						foreach($inventoryFlowData as $key => $item) {
							$inventoryFlowDataArray['material_id'] =  $item->material_id;
							$inventoryFlowDataArray['material_out'] =  $item->quantity;
							$inventoryFlowDataArray['uom'] =  $item->UOM;
							$inventoryFlowDataArray['through'] =  'Invoice';
							$inventoryFlowDataArray['ref_id'] =  $id;
							
							// $get_Data  = $this->account_model->get_previous_inventery_flow_data('inventory_flow',$item->material_id,$id,'Invoice');
							// pre($get_Data);
							//pre($inventoryFlowDataArray);die('Inventory');
							
							$this->account_model->update_inventery_mat_details('inventory_flow',$item->material_id,$id,$inventoryFlowDataArray);
							$inCount++;
						}					
					}
					
					/* Inventory Flow*/
					//die('ACCHA');
					
					
					if ($success) {
                        $data['message'] = "Invoice updated successfully";
                        logActivity('Invoice  Updated','invoice',$id);
                        $this->session->set_flashdata('message', 'Invoice Details Updated successfully');
					    redirect(base_url().'account/invoices', 'refresh');
                    }
				}else{
					$check_invoice_num = $this->account_model->invoiceExist($_POST['invoice_num']);
					if(empty($check_invoice_num)){
				/*Product Details Inventory Process*/
					foreach($get_mat_id_qty as $for_decrease_qty){
					$mat_idd = $for_decrease_qty->material_id;
					$mat_qqty = $for_decrease_qty->quantity;
					$get_dataa = $this->account_model->get_matrial_qty_invoice('material',$mat_idd);
					$remaining_qty =  $get_dataa['closing_balance'] - $mat_qqty;
					$this->account_model->update_matrial_qty_invoice('material',$mat_idd,$remaining_qty);
					}
				/*Product Details Inventory Process*/	
				
				//pre($data);
				
				
				
					$id = $this->account_model->insert_tbl_data('invoice',$data);
					/* Inventory Flow*/
					if(!empty($data) && $data['descr_of_goods'] !=''){
						$inventoryFlowData = json_decode($data['descr_of_goods']);
						$inventoryFlowDataArray = [];
						$inCount = 0;
						foreach($inventoryFlowData as $key => $item) {
							$inventoryFlowDataArray['material_id'] =  $item->material_id;
							$inventoryFlowDataArray['material_out'] =  $item->quantity;
							$inventoryFlowDataArray['uom'] =  $item->UOM;
							$inventoryFlowDataArray['through'] =  'Invoice';
							$inventoryFlowDataArray['ref_id'] =  $id;
							$inventoryFlowDataArray['created_by'] =  $_SESSION['loggedInUser']->id;
							$inventoryFlowDataArray['created_by_cid'] =  $_SESSION['loggedInUser']->c_id;
							$this->account_model->insert_tbl_data('inventory_flow',$inventoryFlowDataArray);
							$inCount++;
						}					
					}
					/* Inventory Flow*/
					/* For Sale Ledger Details data*/
					$debit_data['debit_dtl'] = '0';
					$debit_data['ledger_id'] = $_REQUEST['sale_ledger'];
					$debit_data['credit_dtl'] = $_POST['total_amout_without_tax_on_keyup'];
					$debit_data['type'] = 'invoice';
					$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$debit_data['type_id'] = $id;
					$debit_data['add_date'] = $add_Date;
						$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
					/* For Sale Ledger Details data*/
					
					/* For Purchase Ledger Details data*/
					$credit_data['debit_dtl'] = $_POST['total_amout_with_tax_on_keyup'];
					// $credit_data['debit_dtl'] = $_POST['total_amout_without_tax_on_keyup'];
					$credit_data['ledger_id'] = $_POST['party_name'];
					$credit_data['credit_dtl'] = '0';
					$credit_data['type'] = 'invoice';
					$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$credit_data['type_id'] = $id;
					$credit_data['add_date'] = $add_Date;
					$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
					
					
					
					/* For Purchase Ledger Details data*/
					
					/* For CGST SGST IGST Table*/
							if($_POST['CGST'] !=''){
								$CGST_data['debit_dtl'] = '0';
								$CGST_data['ledger_id'] = '2';
								$CGST_data['credit_dtl'] = $_POST['CGST'] + $both_tax ;
								$CGST_data['type'] = 'invoice';
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$CGST_data['type_id'] = $id;
								$CGST_data['add_date'] = $add_Date;
								$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
								//$tax = array('CGST'=> $_POST['CGST']);
							}
							
							if($_POST['SGST'] != ''){
								$SGST_data['debit_dtl'] = '0';
								$SGST_data['ledger_id'] = '3';
								$SGST_data['credit_dtl'] = $_POST['SGST'] + $both_tax ;
								$SGST_data['type'] = 'invoice';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
								//$tax = array('SGST'=> $_POST['SGST']);
							}
							
							if($_POST['IGST'] != ''){
								$IGST_data['debit_dtl'] = '0';
								$IGST_data['ledger_id'] = '1';
								$IGST_data['credit_dtl'] = $_POST['IGST'] + $both_tax ;
								$IGST_data['type'] = 'invoice';
								$IGST_data['type_id'] = $id;
								$IGST_data['add_date'] = $add_Date;
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$IGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
							}
					/* For CGST SGST IGST Table*/
					/*INSERT Code For charges Ledgers and Discount Ledgers*/
					$ddt =	json_decode($json_charg_lead_total_array, true);
				if($ddt[0]['particular_charges_name'] != ''){
					
						$charges_Discount_data = json_decode($json_charg_lead_total_array,true);
						foreach($charges_Discount_data as $chrg_data){
						if(!empty($chrg_data)){	
							if($chrg_data['type_charges'] == 'plus'){
								$charges_Data['debit_dtl'] = '0';
								$charges_Data['ledger_id'] = $chrg_data['ledger_name_id'];
								$charges_Data['credit_dtl'] = $chrg_data['charges_added'];
								$charges_Data['type'] = 'invoice';
								$charges_Data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$charges_Data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$charges_Data['type_id'] = $id;
								$charges_Data['add_date'] = $add_Date;
								$this->account_model->update_single_data_for_charges($chrg_data['amt_with_tax'], $id,'invoice');//USd to add Charges in Per invoice 
								$this->account_model->insert_tbl_data('transaction_dtl',$charges_Data);
							}else{
								$charges_Data['debit_dtl'] = $chrg_data['charges_added'];
								$charges_Data['ledger_id'] = $chrg_data['ledger_name_id'];
								$charges_Data['credit_dtl'] = '0';
								$charges_Data['type'] = 'invoice';
								$charges_Data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$charges_Data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$charges_Data['type_id'] = $id;
								$charges_Data['add_date'] = $add_Date;
								$this->account_model->insert_tbl_data('transaction_dtl',$charges_Data);
							}
							}
						}
							
					}
					
					
					/*INSERT Code For charges Ledgers and Discount Ledgers*/
					
					
							
						
					if(!empty($_FILES['file_attachment']['name']) && $_FILES['file_attachment']['name'][0]!=''){
								$docs_array = array();
								$docCount = count($_FILES['file_attachment']['name']);
								for($i = 0; $i < $docCount; $i++){
									$filename     = $_FILES['file_attachment']['name'][$i];
									$tmpname     = $_FILES['file_attachment']['tmp_name'][$i];               
									$type     = $_FILES['file_attachment']['type'][$i];               
									$error    = $_FILES['file_attachment']['error'][$i];
									$size    = $_FILES['file_attachment']['size'][$i];
									$exp=explode('.', $filename);
									$ext=end($exp);
									$newname=  $exp[0].'_'.time().".".$ext; 
									$config['upload_path'] = 'assets/modules/account/uploads/';
									$config['upload_url'] =  base_url().'assets/modules/account/uploads/';
									$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
									$config['max_size'] = '2000000'; 
									$config['file_name'] = $newname;
									$this->load->library('upload', $config);
									move_uploaded_file($tmpname,"assets/modules/account/uploads/".$newname);				
									$docs_array[$i]['rel_id'] = $id;
									$docs_array[$i]['rel_type'] = 'invoice';
									$docs_array[$i]['file_name'] = $newname;
									$docs_array[$i]['file_type'] = $type;
								}
								if(!empty($docs_array)){
							/* Insert file information into the database */
							$docsAttachmentID = $this->account_model->insert_attachment_data('attachments', $docs_array, $id);
							}  
						}
						
							
															
					if ($id) {
						
						$company_email_Settings = $this->account_model->get_data('company_detail',array('id'=> $_SESSION['loggedInUser']->c_id));
						if($company_email_Settings[0]['email_send_setting'] == 'email_send' || $company_email_Settings[0]['email_send_setting'] == '' ){	
					    $email_id = $data['email'];
						}else{
							$email_id = '';
						}

						
						$party_name = getNameById('ledger',$data['party_name'],'id');
						$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<meta name="viewport" content="width=device-width" />
							</head>
							<body style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; text-align: center; background: #efefef; margin: 0; padding: 40px 0;" bgcolor="#efefef">
								<table class="body-wrap text-center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; text-align: center; background: #efefef; margin: 0; padding: 0;" bgcolor="#efefef">
									<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
										<td class="container" align="center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">
											<!-- Message start -->
											<table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
												<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
													<td align="center" class="masthead" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: white; background: #099a8c; margin: 0; padding: 30px 0;     border-radius: 4px 4px 0 0;" bgcolor="#099a8c"> <img src="'.base_url().'assets/modules/company/uploads/'.$_SESSION['loggedInCompany']->logo.'" alt="logo" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; max-width: 20%; display: block; margin: 0 auto; padding: 0;" /></td>
												</tr>';    
										
								$footer = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
										<td class="container" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">
											<!-- Message start -->
											<table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
											<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
												<td class="content footer" align="center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white none; margin: 0; padding: 30px 35px;     border-radius: 0 0 4px 4px;" bgcolor="white">							
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center"><a href="'. base_url() .'" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: #888; text-decoration: none; font-weight: bold; margin: 0; padding: 0;">ERP</a></p>
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Support: dev@lastingerp.com</p>
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Phase 1 Industrial Area Panchkula Plot No 39, India - 134109</p>
												</td>
											</tr>
										</table>
										</td>
									</tr>
								</table>
							</body>
						</html>';
						$email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
															<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
																<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi '.$party_name->name.',</p>								
																
																<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Message '.$data['message_for_email'].'</p>	
															</td>
														</tr>
													</table>
												</td>
											</tr>';	
						$messageContent = $header.$email_message.$footer;

	
					ini_set('memory_limit', '20M');
						$this->load->library('Pdf');
						$this->load->library('email');
						$dataPdf['dataPdf'] = $this->account_model->get_data_byId('invoice','id',$id);
						
						$html = $this->load->view('invoice/invoice_pdf_email',$dataPdf, true);
						
						
						
						
					    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
							$pdf->SetCreator(PDF_CREATOR);
							$pdf->AddPage();
						
						$pdfFilePath = FCPATH . "assets/modules/account/pdf_invoice/pdf_invoice.pdf";
						
						$pdf->WriteHTML($html);
						
						//pre($ddddf);die('chk Pdf');
						
						$pdf->Output($pdfFilePath, "F");
						$this->email->attach($pdfFilePath);
						
						    $this->load->library('email');
							$config['mailtype'] = 'html';
							$this->email->initialize($config);
							$this->email->to($email_id);
							$this->email->from('admin@lastingerp.com', "Lasting ERP Team");
							$this->email->subject("Invoice");
						
						 if(!empty($docs_array)){ 
							  foreach($docs_array as $key => $value){
								$attched_file = $_SERVER['DOCUMENT_ROOT'] . "/assets/modules/account/uploads/".$value['file_name'];
								$this->email->attach($attched_file);
							}
							
						 }  
						 $this->email->message($messageContent);
						
						 $data['message'] = "Sorry Unable to send email..."; 
						  if($this->email->send()){     
						   $data['message'] = "Mail sent...";  
							unlink($pdfFilePath);
						  }

                        logActivity('New Invoice Created','invoice',$id);
                        $this->session->set_flashdata('message', 'Invoice Details inserted successfully');
					    redirect(base_url().'account/invoices', 'refresh');
                    }
					}else{
						$this->session->set_flashdata('message', 'Invoice  Number is  Already exists');
						redirect(base_url().'account/invoices', 'refresh');
						} 
					}
				
			}
		 }//Save not draft 
		 if($_POST['save_status'] == '0'){//This code Is used to Save as Drafts
			$descr_of_goodsLength = count($_POST['descr_of_goods']);
				if($descr_of_goodsLength >0){
					$arr = [];
					$i = 0;
					while($i < $descr_of_goodsLength) {	
						$jsonArrayObject = (array('material_id' =>$_POST['material_id'][$i],'descr_of_goods' => $_POST['descr_of_goods'][$i],'hsnsac' => $_POST['hsnsac'][$i], 'quantity' => $_POST['quantity'][$i], 'rate' => $_POST['rate'][$i], 'tax' => $_POST['tax'][$i] ,'UOM' => $_POST['UOM'][$i],'amount'=>$_POST['amount'][$i],'disctype'=>$_POST['disctype'][$i],'discamt'=>$_POST['discamt'][$i],'after_desc_amt'=>$_POST['after_desc_amt'][$i],'amount_with_tax_after_disco'=>$_POST['amount'][$i]));
						$arr[$i] = $jsonArrayObject;
						$i++;				
					}
					$descr_of_goods_array = json_encode($arr);
				}else{
					$descr_of_goods_array = '';
				}
				
				//pre($descr_of_goods_array);die();
				$get_mat_id_qty = json_decode($descr_of_goods_array);
				
				
			
				$invoice_price_totalLength = count($_POST['invoice_total_with_tax']);
					if($invoice_price_totalLength >0){ 
							$arra = [];
							$j = 0;
						while($j < $invoice_price_totalLength) {	
								$jsonArrayObject1 = (array('total' =>$_POST['total'][$j],'totaltax' => $_POST['totaltax'][$j],'invoice_total_with_tax' => $_POST['invoice_total_with_tax'][$j]));
								$arra[$j] = $jsonArrayObject1;
								$j++;
							}
							$invoice_price_total_array = json_encode($arra);
						}else{
							$invoice_price_total_array = '';
						}
						
				$charges_Added_Count = 	count($_POST['charges_added']);
					
					if($charges_Added_Count > 0){
						$charg_Add = [];
						$ch = 0;
						while($ch < $charges_Added_Count){
							$jsonarray_chargeobj = (array('particular_charges_name'=>$_POST['particular_charges'][$ch],'charges_added'=>$_POST['charges_added'][$ch],'sgst_amt'=>$_POST['sgst_amt'][$ch],'cgst_amt'=>$_POST['cgst_amt'][$ch],'igst_amt'=>$_POST['igst_amt'][$ch],'amt_with_tax'=>$_POST['amt_with_tax'][$ch]));
							$charg_Add[$ch] = $jsonarray_chargeobj;
							$ch++;
						}
						$json_charg_lead_total_array = json_encode($charg_Add);
					}else{
						$json_charg_lead_total_array = '';
					}
					
					$required_fields = array('sale_ledger','party_name');	
					$is_valid = validate_fields($_POST, $required_fields);
					if (count($is_valid) > 0) {
						valid_fields($is_valid);				
					}else{
					
				$data  = $this->input->post();
				$data['descr_of_goods'] = $descr_of_goods_array;	
				$data['invoice_total_with_tax'] = $invoice_price_total_array;	
				$data['charges_added'] = $json_charg_lead_total_array;	
				// $data['disctype'] = $json_discount_added_array;	
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				$id = $data['id'];
				// pre($data);
				// die('pp');
				//$check_invoice_num = $this->account->invoiceExist($_POST['invoice_num']);
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					if($data['accept_reject'] !='' && $data['reject_invoice'] !='' ){
						$data['accept_reject'] = '';
						$success = $this->account_model->update_data('invoice',$data, 'id', $id);
						
					}else{	
						 $success = $this->account_model->update_data('invoice',$data, 'id', $id);
					}
					
					if ($success) {
                        $data['message'] = "Invoice updated successfully";
                        logActivity('Invoice  Updated','invoice',$id);
                        $this->session->set_flashdata('message', 'Invoice Details Updated successfully');
					    redirect(base_url().'account/invoices', 'refresh');
                    }
				}else{
					$check_invoice_num = $this->account_model->invoiceExist($_POST['invoice_num']);
					if(empty($check_invoice_num)){
				/*Product Details Inventory Process*/
					foreach($get_mat_id_qty as $for_decrease_qty){
					$mat_idd = $for_decrease_qty->material_id;
					$mat_qqty = $for_decrease_qty->quantity;
					$get_dataa = $this->account_model->get_matrial_qty_invoice('material',$mat_idd);
					$remaining_qty =  $get_dataa['closing_balance'] - $mat_qqty;
					$this->account_model->update_matrial_qty_invoice('material',$mat_idd,$remaining_qty);
					}
				/*Product Details Inventory Process*/	
					$id = $this->account_model->insert_tbl_data('invoice',$data);
					
					
							
						
					if(!empty($_FILES['file_attachment']['name']) && $_FILES['file_attachment']['name'][0]!=''){
								$docs_array = array();
								$docCount = count($_FILES['file_attachment']['name']);
								for($i = 0; $i < $docCount; $i++){
									$filename     = $_FILES['file_attachment']['name'][$i];
									$tmpname     = $_FILES['file_attachment']['tmp_name'][$i];               
									$type     = $_FILES['file_attachment']['type'][$i];               
									$error    = $_FILES['file_attachment']['error'][$i];
									$size    = $_FILES['file_attachment']['size'][$i];
									$exp=explode('.', $filename);
									$ext=end($exp);
									$newname=  $exp[0].'_'.time().".".$ext; 
									$config['upload_path'] = 'assets/modules/account/uploads/';
									$config['upload_url'] =  base_url().'assets/modules/account/uploads/';
									$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
									$config['max_size'] = '2000000'; 
									$config['file_name'] = $newname;
									$this->load->library('upload', $config);
									move_uploaded_file($tmpname,"assets/modules/account/uploads/".$newname);				
									$docs_array[$i]['rel_id'] = $id;
									$docs_array[$i]['rel_type'] = 'invoice';
									$docs_array[$i]['file_name'] = $newname;
									$docs_array[$i]['file_type'] = $type;
								}
								if(!empty($docs_array)){
							/* Insert file information into the database */
							$docsAttachmentID = $this->account_model->insert_attachment_data('attachments', $docs_array, $id);
							}  
						}
						
							
															
					if ($id) {
                        logActivity('New Invoice Created','invoice',$id);
                        $this->session->set_flashdata('message', 'Invoice Details Added as Drafts successfully');
					    redirect(base_url().'account/invoices', 'refresh');
                    }
					}else{
						$this->session->set_flashdata('message', 'Invoice  Number is  Already exists');
						redirect(base_url().'account/invoices', 'refresh');
						}    				
				}
			}
		 }//Save
        }
	}

	
	
	
	
	
	
	public function deleteInvoice_details($id = ''){	
		if (!$id) {
           redirect('account/invoices', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('invoice','id',$id);
		$this->account_model->delete_inventery_mat_details('inventory_flow',$id, 'invoice');
		$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'invoice');
		if($result){
			logActivity('Invoice Details Deleted','invoice',$id);
			$this->session->set_flashdata('message', 'Invoice Details Deleted Successfully');
			$result = array('msg' => 'Invoice Details Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'account/invoices');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}
	
	public function cancelInvoice_details($id = ''){	
		if (!$id) {
           redirect('account/invoices', 'refresh');
        }
		$result = $this->account_model->cancel_restore_data('invoice','id',$id,'0');
		$this->account_model->cancel_restore_transational_tbl_data('transaction_dtl','type_id', $id, 'invoice','0');
		//$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'invoice');
		if($result){
			$this->session->set_flashdata('message', 'Invoice Canceled Successfully');
			$result = array('msg' => 'Invoice Details Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'account/invoices');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}
	public function restoreInvoice_details($id = ''){	
		if (!$id) {
           redirect('account/invoices', 'refresh');
        }
		$result = $this->account_model->cancel_restore_data('invoice','id',$id,'1');
		$this->account_model->cancel_restore_transational_tbl_data('transaction_dtl','type_id', $id, 'invoice','1');
		//$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'invoice');
		if($result){
			$this->session->set_flashdata('message', 'Invoice Restore Successfully');
			$result = array('msg' => 'Invoice Details Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'account/invoices');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}
	
	
	
	
	
	
	
	
	
	
	
	//GET PARTY DETAILS
	public function GetParty_details(){
		
		if($_REQUEST['id'] && $_REQUEST['id'] != ''){
			$data = $this->account_model->get_matrial_data_byId('ledger','id',$_REQUEST['id']);
			echo json_encode($data,true);
			die;
			 
		 }
		
	}
	public function selectMatrial(){
		 if($_REQUEST['id'] && $_REQUEST['id'] != ''){
			$data = $this->account_model->get_matrial_data_byId('material','id',$_REQUEST['id']);
			echo json_encode($data,true);
			die;
		 }
	}
	public function selectMatrial_according_item_code(){
		 if($_REQUEST['material_code'] && $_REQUEST['material_code'] != ''){
			$data = $this->account_model->get_matrial_data_byId('material','material_code',$_REQUEST['material_code']);
			echo json_encode($data,true);
			die;
		 }
	}
	/* Get Leger state id during Tax Calulation*/
	public function get_ledger_mailing_state(){
		 if($_REQUEST['id'] && $_REQUEST['id'] != ''){
			$data = $this->account_model->get_ledger_sate_Data('ledger','id',$_REQUEST['id'],$_SESSION['loggedInUser']->c_id);
			//pre($data);die();
			echo json_encode($data,true);
			die;
		 }
	}
	
	public function get_company_branch_state(){
		 if($_REQUEST['id'] && $_REQUEST['id'] != ''){
			$data = $this->account_model->get_comapny_sate_Data('company_detail','id',$_SESSION['loggedInUser']->c_id);
			echo json_encode($data,true);
			die;
		 }
	}
	public function get_ledger_address_more_thanOne(){
		 if($_REQUEST['id'] && $_REQUEST['id'] != ''){
			$created_by_cid  = $_SESSION['loggedInUser']->c_id;
			$resultt = $this->account_model->get_ledger_sate_Data('ledger','id',$_REQUEST['id'],$created_by_cid);
			//echo json_encode($data,true);
			die;
			 
		 }
	}
	/* Get Leger state id during Tax Calulation*/
	/* Get Particulars charges Data */
	public function get_charges_details(){
		
		 if($_REQUEST['id'] && $_REQUEST['id'] != ''){
			$data22 = $this->account_model->get_particulars_charges_data('charges_lead','id',$_REQUEST['id']);
			$data['data'] = $this->account_model->get_particulars_charges_data('charges_lead','id',$_REQUEST['id']);
			$ledger_Data = getNameById('ledger',$data22->ledger_id,'id');
			$data['ledger_nam'] =  $ledger_Data->name;
			
			echo json_encode($data);
			die;
			 
		 }
	}
	/* Get Particulars charges Data */
	
		public function get_company_branch(){
		  $data22 = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id);
		  $adress_id = $_REQUEST['selected_sale_ledger_brch_id'];
		  $address_Data = json_decode($data22->address);
		foreach($address_Data as $get_Add_id){
			 if($get_Add_id->add_id == $adress_id){
				$term_arr[] = $get_Add_id->prefix_inv_num;
			 }
		 }
	
		  $query = $this->db->query('SELECT * FROM invoice');
			$invoice_count =  $query->num_rows();
			if(!empty($term_arr[0])){
				//$ccounnt = $invoice_count + 1;
				$ccounnt = rand(10,100) + 1;
				echo strtoupper($term_arr[0].'_'.$ccounnt);
			}else{
				$ccount = $invoice_count + 2;
				echo 'INVOICE_'.$ccount;
			}	
	  // }
   }
   
   
   public function get_company_address(){
	    if($_REQUEST['login_c_id'] && $_REQUEST['login_c_id'] != ''){
			 $c_data = $this->account_model->get_termconditions_details('company_detail','id',$_REQUEST['login_c_id']);
			 $json_array  = json_decode($c_data->address, true);
			 $elementCount  = count($json_array);
			if($elementCount == 1){
				$single_add_dataa =  Json_decode($c_data->address,true);
				$single_add_Data = array();
				foreach($single_add_dataa as $get_add_name){
					$mailing_address = $get_add_name['address'];
					$mailing_country_id = $get_add_name['country'];
					$mailing_state_id = $get_add_name['state'];
					$mailing_city_id = $get_add_name['city'];
					$postal_zipcode = $get_add_name['postal_zipcode'];
					
					 $country_name = getNameById('country',$mailing_country_id,'country_id');
					 $state_name = getNameById('state',$mailing_state_id,'state_id');
					 $city_name = getNameById('city',$mailing_city_id,'city_id');
					
						$single_add_Data[] = array(
							'country_id' => $mailing_country_id,
							'state_id' => $mailing_state_id,
							'city_id' => $mailing_city_id,
							'mailing_add' => $mailing_address,
							'postal_zipcode' => $postal_zipcode,
							'postal_zipcode' => $postal_zipcode,
							'country_name' => $country_name->country_name,
							'state_name' => $state_name->state_name,
							'city_name' => $city_name->city_name
						);
					} 
				echo json_encode($single_add_Data,true);
				die;
			}
		}
	}
   
   public function get_company_unit_address(){
	  // $unit_Data =  $this->account_model->get_termconditions_details('location_settings','id',$_REQUEST['selected_unit_id']);
	  // $selected_company_id = $unit_Data->c_id;
	  //$selected_compny_branch_name = $unit_Data->compny_branch_name;
	  $get_login_com_details = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
	  $company_add = $get_login_com_details->address;
		
	  $company_multi_add =  Json_decode($company_add,true);
	 
		$multi_add_Data ='';
		$multi_add_Data = array();
	
	  foreach ($company_multi_add as $key => $val) {
		  
		  if ($val['add_id'] == $_REQUEST['selected_unit_id']) {
			        $compny_branch_name = $val['compny_branch_name'];
			        $mailing_address = $val['address'];
					$mailing_country_id = $val['country'];
					$mailing_state_id = $val['state'];
					$mailing_city_id = $val['city'];
					$postal_zipcode = $val['postal_zipcode'];
					$company_gstin = $val['company_gstin'];
					$country_name = getNameById('country',$mailing_country_id,'country_id');
					$state_name = getNameById('state',$mailing_state_id,'state_id');
					$city_name = getNameById('city',$mailing_city_id,'city_id');
					
					$multi_add_Data[] = array(
						'compny_branch_name' => $compny_branch_name,
						'country_id' => $mailing_country_id,
						'state_id' => $mailing_state_id,
						'city_id' => $mailing_city_id,
						'mailing_add' => $mailing_address,
						'postal_zipcode' => $postal_zipcode,
						'company_gstin' => $company_gstin,
						'country_name' => $country_name->country_name,
						'state_name' => $state_name->state_name,
						'city_name' => $city_name->city_name
					);
			
		}
		
		
	}
	
		echo json_encode($multi_add_Data,true);

}
	
	
	
	public function add_party_details_during_invoice(){
		$account_name = $_REQUEST['name'];
		$email = $_REQUEST['email'];
		$gstin = $_REQUEST['gstin'];
		$country = $_REQUEST['country'];
		$state = $_REQUEST['state'];
		$city_id = $_REQUEST['city_id'];
		$acc_group_id = $_REQUEST['acc_group_id'];
		$compny_branch_id = $_REQUEST['compny_branch_id'];
		$mailing_address = $_REQUEST['mailing_address'];
		$opening_balance = $_REQUEST['opening_balance'];
		$created_by_id  = $_SESSION['loggedInUser']->u_id;
		$created_by_cid  = $_SESSION['loggedInUser']->c_id;
		 $dd = $this->account_model->get_ledger_account_grp_Dtl('account_group',$created_by_cid,$_REQUEST['acc_group_id']); 
		
		if($_REQUEST['sale_ledger_data_val'] != 'Add Sale Ledger'){
			$mailing_addressLength = count($_POST['country']);
				if($mailing_addressLength >0){
					$arr = [];
					$i = 0;
					$idds = 1;
					while($i < $mailing_addressLength) {	
						$jsonArrayObject = (array('ID'=> $idds,'mailing_name'=>$account_name,'mailing_country' =>$country,'mailing_state' => $state,'mailing_city' => $city_id,'mailing_address'=>$mailing_address,'gstin_no'=>$gstin));
						$arr[$i] = $jsonArrayObject;
						$i++;
						$idds++;	
			
					}
					
					$descr_of_ldgr_array = json_encode($arr);
				}else{
					$descr_of_ldgr_array = '';
				}
			
			
			$party_details = array(
					'name'=>$account_name,
					'email'=>$email,
					'gstin'=>$gstin,
					'opening_balance '=>$opening_balance,
					'mailing_address' =>$descr_of_ldgr_array,
					'account_group_id'=>$acc_group_id,	
					'compny_branch_id'=>$compny_branch_id,	
					'created_by'=>$created_by_id, 
					'created_by_cid'=>$created_by_cid, 
					'parent_group_id'=>@$dd[0]['parent_group_id'],	 
				);
		
		}else{
			$party_details = array(
					'name'=>$account_name,
					'email'=>$email,
					'gstin'=>$gstin,
					'mailing_address' =>$descr_of_ldgr_array,
					'account_group_id'=>$acc_group_id,	
					'compny_branch_id'=>$compny_branch_id,	
					'parent_group_id'=>@$dd[0]['parent_group_id'],	
					'opening_balance '=>$opening_balance, 
					'created_by '=>$created_by_id, 
					'created_by_cid'=>$created_by_cid, 
				);	
			
		}
		
		//pre($party_details);die();
		
		$data = $this->account_model->insert_on_spot_tbl_data('ledger',$party_details);
		if($data > 0){
			echo 'true';
		}else{
			echo 'false';
		}
		
	}
	
	
	public function add_matrial_Details_onthe_spot(){
		$material_name = $_REQUEST['material_name'];
		$hsn_code = $_REQUEST['hsn_code'];
		$uom = $_REQUEST['uom'];
		$tax = $_REQUEST['tax'];
		$specification = $_REQUEST['specification'];
		$chk_box_val = $_REQUEST['chk_box_val'];
		$material_type_id = $_REQUEST['material_type_id'];
		$prefix = $_REQUEST['prefix'];
		$created_by_id  = $_SESSION['loggedInUser']->u_id;
		$created_by_cid  = $_SESSION['loggedInUser']->c_id;
		$last_id = getLastTableId('material');
					$rId = $last_id + 1;
					$matCode = 'MAT_'.rand(1, 1000000).'_'.$rId; 
	$non_inventry_material = 0;
			if($chk_box_val == 'checked'){
				$non_inventry_material = 1;
			}
	
			$matrial_details = array(
					'material_name'=>$material_name,
					'hsn_code'=>$hsn_code,
					'uom'=>$uom,
					'tax'=>$tax,
					'specification '=>$specification, 
					'created_by '=>$created_by_id, 
					'closing_balance '=>200,  
					'material_type_id '=>$material_type_id, 
					'prefix '=>$prefix, 
					'non_inventry_material '=>$non_inventry_material, 
					'material_code '=>$matCode, 
					'created_by '=>$created_by_id, 
					'created_by_cid '=>$created_by_cid, 
				);
				// pre($matrial_details);die();
			
		$data = $this->account_model->insert_on_spot_tbl_data('material',$matrial_details);
		if($data > 0){
			echo 'true';
		}else{
			echo 'false';
		}
		
	}
	/*GEt Material type*/
	public function Get_matrial_type(){
		$get_data = $this->account_model->get_data_material_type('material_type');
		echo json_encode($get_data,true);
			die;
	}
	/*GEt Material type*/
	
	
	
	
	public function create_pdf($id = ''){
		$this->load->library('Pdf');
		$dataPdf['dataPdf'] = $this->account_model->get_data_byId('invoice','id',$id);
     	$this->load->view('invoice/invoice_pdf_genrate',$dataPdf);	//$this->_render_template('purchase_order/view_pdf', $this->data);
		
	}
	public function create_pdf_all($id = ''){
		$this->load->library('Pdf');
		$login_cid = $_POST['login_c_id'];
		$start_date = $_POST['start'];
		$end_date = $_POST['end'];
		
		if($login_cid !='' && $start_date != '' &&  $end_date !='' ){
			$where = array('invoice.created_date >=' => $start_date , 'invoice.created_date <=' => $end_date,'invoice.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
			$dataPdfs['dataPdfs']  = $this->account_model->get_data_bywhereId('invoice',$where);
			
			 $this->load->view('invoice/all_invoice_pdf',$dataPdfs);
		}else{
			$where = array('invoice.created_by_cid' => $_SESSION['loggedInUser']->c_id);
			$dataPdfs['dataPdfs'] = $this->account_model->get_data_bywhereId('invoice',$where);
		    $this->load->view('invoice/all_invoice_pdf',$dataPdfs);	//$this->_render_template('purchase_order/view_pdf', $this->data);
		}
		
		// $dataPdfs['dataPdfs'] = $this->account_model->get_data_bywhereId('invoice','created_by_cid',$login_cid);
		// $this->load->view('invoice/all_invoice_pdf',$dataPdfs);	//$this->_render_template('purchase_order/view_pdf', $this->data);
		
  }
	
	public function invoice_setting() {
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Invoice Settings', base_url() . 'Add Invoice Settings');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Add Invoice Settings';
		$company_id = $_SESSION['loggedInUser']->c_id;
		
		$this->data['update_invoice_setting']  = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id); 
		$this->_render_template('invoice/invoice_setting_index', $this->data);
    }
	public function viewInvoice_setting(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['invoice_settingss'] = $this->account_model->get_data_byId('company_detail','id',$this->input->post('id'));			
			$this->load->view('invoice/viewInvoice_Setting', $this->data);
		}	
	}
	public function financial_year_settings() {
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Financial Year Settings', base_url() . 'Financial Year Settings');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Financial Year Settings';
		$company_id = $_SESSION['loggedInUser']->c_id;
		
		$this->data['update_invoice_setting']  = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id); 
		$this->_render_template('invoice/fiscal_year_settings', $this->data);
    }
	
	
	
	public function editInvoice_setting(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');
			$this->data['invoice_settingss'] = $this->account_model->get_data_byId('company_detail','id',$this->input->post('id'));			
			$this->load->view('invoice/editInvoice_setting', $this->data);
		}	
	}
	public function saveInvoice_settings(){	 
		if ($this->input->post()) {
			$data  = $this->input->post();
			$data['id'] = $_SESSION['loggedInUser']->id;
			$id = $data['id'];
			if($id && $id != ''){
				$success = $this->account_model->update_data('company_detail',$data, 'u_id', $_SESSION['loggedInUser']->id);	
					if ($success) {
                        $data['message'] = "Terms and Conditions Added successfully";
                        logActivity('Terms and Conditions Added','company_detail',$id);
                        $this->session->set_flashdata('message', 'Terms and Conditions Added successfully');
					    redirect(base_url().'account/invoice_setting', 'refresh');
                    }
				 }
			}			
        }
	
	public function uploadFile($fielName) {
		$filename=$_FILES[$fielName]['name'];
		$tmpname=$_FILES[$fielName]['tmp_name']; 
		$exp=explode('.', $filename);
		$ext=end($exp);
		$newname=  $exp[0].'_'.time().".".$ext; 
		$config['upload_path'] = 'assets/modules/account/uploads/';
		$config['upload_url'] =  base_url().'assets/modules/account/uploads/';
		$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
		$config['max_size'] = '2000000'; 
		$config['file_name'] = $newname;
		$this->load->library('upload', $config);
		move_uploaded_file($tmpname,"assets/modules/account/uploads/".$newname);
		return $newname;
	}
	
public function voucher_detail(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Voucher Details', base_url() . 'Voucher Details');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Voucher Details';
		$created_by_id  = $_SESSION['loggedInUser']->c_id;
		// $this->data['voucher_dtls']  = $this->account_model->get_voucher_dtatils('voucher',array('created_by'=> $created_by_id)); 
		// $this->_render_template('voucher_detail/index', $this->data);
		/* For Financial Year*/
		$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id);//Fetch Data to Company Table
		$date_fcal = json_decode($date_fun->financial_year_date,true);
	
			if(empty($date_fcal)){
				
				if (date('m') <= 4) {//Upto June 2014-2015
				
					$mydate = date(date('Y-04-01'));
					$lastyear = strtotime("-1 year", strtotime($mydate));
					$first_date = date("Y-m-d", $lastyear); 
					$date = date(date('Y-03-31'));
					$second_date = date('Y-m-d', strtotime("$date"));
				} else {//After June 2015-2016
				
					$mydate = date(date('Y-04-01'));
					$lastyear = strtotime("-1 year", strtotime($mydate));
					$first_date = date("Y-m-d", $lastyear);
					$date = date(date('Y-03-31'));
					$second_date = date('Y-m-d', strtotime("$date"));
				}
			}else{
				
				if (date('m') <= 4) {//Upto June 2014-2015
				
					$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
					$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
					$first_date = date(date($s_Date));
					$date = date(date($e_Date));
					$second_date = date('Y-m-d', strtotime("$date"));
				} else {//After June 2015-2016
				
					$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
					$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
					$first_date = date(date($s_Date));
					$date = date(date($e_Date));
					$second_date = date('Y-m-d', strtotime("$date"));
				}
			}
// echo $first_date;
// echo '<br/>';
// echo $second_date;
/* For Financial Year*/
		
		
		if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
			 $this->data['voucher_dtls']  = $this->account_model->get_voucher_dtatils('voucher',array('voucher.created_by_cid'=> $created_by_id,'voucher.created_date >=' =>$first_date, 'voucher.created_date <=' => $second_date));
			 $this->_render_template('voucher_detail/index', $this->data);
		}
		
		if(isset($_POST['start'])  && isset($_POST['end'])){
			$where = array('voucher.created_date >=' => $_POST['start'] , 'voucher.created_date <=' => $_POST['end'],'voucher.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'auto_entry'=>'1');
			$this->data['voucher_dtls']  = $this->account_model->get_voucher_dtatils('voucher',$where);
			$this->load->view('voucher_detail/index', $this->data);
		}else{
			$where = array('voucher.created_by_cid'=> $created_by_id,'voucher.created_date >=' =>$first_date, 'voucher.created_date <=' => $second_date,'auto_entry'=>'0');
			$this->data['voucher_dtls']  = $this->account_model->get_voucher_dtatils('voucher',$where);
			//pre($this->data['voucher_dtls']);die();
			
			$where = array('voucher.created_by_cid'=> $created_by_id,'voucher.created_date >=' =>$first_date, 'voucher.created_date <=' => $second_date,'auto_entry'=>'1');
			$this->data['voucher_dtls_auto']  = $this->account_model->get_voucher_dtatils('voucher',$where);
			
			
			$where2 = array('account_freeze.created_by_cid' => $_SESSION['loggedInUser']->c_id);
			$this->data['freeze_date']  = $this->account_model->get_account_freeze('account_freeze',$where2);
			$this->_render_template('voucher_detail/index', $this->data);
		}
	}
	
	public function viewVoucher_detail(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['voucher_dtls'] = $this->account_model->get_data_byId('voucher','id',$this->input->post('id'));			
			$this->load->view('voucher_detail/view', $this->data);
		}	
	}
	public function editVoucher_detail(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['voucher_dtls'] = $this->account_model->get_data_byId('voucher','id',$this->input->post('id'));			
			$this->load->view('voucher_detail/edit', $this->data);
		}	
	}
  public function saveVoucher_Details(){
	  if ($this->input->post()) {
		
		

		  
		 $voucher_detlsLength = count($_POST['credit_debit_party_dtl']);
				if($voucher_detlsLength >0){
					$arra = [];
					$i = 0;
					
					while($i < $voucher_detlsLength) {	
				
						$jsonArrayObject = (array('credit_debit_party_dtl' => $_POST['credit_debit_party_dtl'][$i],'credit_1' => $_POST['credit_1'][$i], 'debit_1' => $_POST['debit_1'][$i],'cr_dr'=>$_POST['cr_dr'][$i]));
						$arra[$i] = $jsonArrayObject;
						$i++;
					 // pre($arra);			
					}
					$description_voucher = json_encode($arra);
					}else{
					$description_voucher = '';
				}
				
				 $sec = strtotime( $_POST['voucher_date']);  
				 $add_Date = date ("Y-m-d H:i", $sec); 
				 //echo $add_Date = $add_Date . ":00";die();
				
			
		 	$required_fields = array('voucher_name');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				$data  = $this->input->post();			
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				$data['credit_debit_party_dtl'] = $description_voucher;
				$data['auto_entry'] = 0;
				$id = $data['id'];
				
				
				if($id && $id != ''){
					
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->account_model->update_data('voucher',$data, 'id', $id);	
					$for_transation_tbl = json_decode($description_voucher);
						if($for_transation_tbl !=''){
								$credit_Data = array();
								$debit_Data = array();
								$taxxxs = '';
								 $i=0;
							foreach($for_transation_tbl as $val){
								if($val->credit_debit_party_dtl == '1'){
										$ledger_id = $val->credit_debit_party_dtl;
										$IGST_data['debit_dtl'] = $val->debit_1;
										$IGST_data['ledger_id'] = $val->credit_debit_party_dtl;
										$IGST_data['credit_dtl'] = '0';
										$IGST_data['type'] = 'voucher';
										$IGST_data['type_id'] = $id;
										$IGST_data['add_date'] = $add_Date;
										$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										$IGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
										//$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
										$this->account_model->update_transaction_data('transaction_dtl',$IGST_data, 'type_id', $id, 'voucher',$ledger_id);
									}
								if($val->credit_debit_party_dtl == '2'){
									    $ledger_id = $val->credit_debit_party_dtl;
										$CGST_data['debit_dtl'] = $val->debit_1;
										$CGST_data['ledger_id'] = $val->credit_debit_party_dtl;
										$CGST_data['credit_dtl'] = '0';
										$CGST_data['type'] = 'voucher';
										$CGST_data['type_id'] = $id;
										$CGST_data['add_date'] = $add_Date;
										$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										$CGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
										//$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
										$this->account_model->update_transaction_data('transaction_dtl',$CGST_data, 'type_id', $id, 'voucher',$ledger_id);
									}	
								if($val->credit_debit_party_dtl == '3'){
									 $ledger_id = $val->credit_debit_party_dtl;
										$SGST_data['debit_dtl'] = $val->debit_1;
										$SGST_data['ledger_id'] = $val->credit_debit_party_dtl;
										$SGST_data['credit_dtl'] = '0';
										$SGST_data['type'] = 'voucher';
										$SGST_data['type_id'] = $id;
										$SGST_data['add_date'] = $add_Date;
										$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										$SGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
										//$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
										$this->account_model->update_transaction_data('transaction_dtl',$SGST_data, 'type_id', $id, 'voucher',$ledger_id);
									}	
								if($val->cr_dr == 'credit'  && $val->credit_debit_party_dtl !='1' && $val->credit_debit_party_dtl !='2' && $val->credit_debit_party_dtl !='3'){
									 $ledger_id = $val->credit_debit_party_dtl;
									$credit_data['debit_dtl'] = '0';
									$credit_data['ledger_id'] = $val->credit_debit_party_dtl;
									$credit_data['credit_dtl'] = $val->credit_1;
									$credit_data['type'] = 'voucher';
									$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
									$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
									$credit_data['type_id'] = $id;
									$credit_data['add_date'] = $add_Date;
									//$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
									$this->account_model->update_transaction_data('transaction_dtl',$credit_data, 'type_id', $id, 'voucher',$ledger_id);
									}else if($val->cr_dr == 'debit' && $val->credit_debit_party_dtl !='1' && $val->credit_debit_party_dtl !='2' && $val->credit_debit_party_dtl !='3'){
										 $ledger_id = $val->credit_debit_party_dtl;
										$debit_data['debit_dtl'] = $val->debit_1;
										$debit_data['ledger_id'] = $val->credit_debit_party_dtl;
										$debit_data['credit_dtl'] = '0';
										$debit_data['type'] = 'voucher';
										$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
										$debit_data['type_id'] = $id;
										$debit_data['add_date'] = $add_Date;
										//$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
										$this->account_model->update_transaction_data('transaction_dtl',$debit_data, 'type_id', $id, 'voucher',$ledger_id);
									}
									//pre($debit_data);
									
								}
								//die('Accha');
								
						}
					
					if ($success) {
                        $data['message'] = "Voucher updated successfully";
                        logActivity('Voucher details  Updated','voucher_type',$id);
                        $this->session->set_flashdata('message', 'Voucher Updated successfully');
					    redirect(base_url().'account/voucher_detail', 'refresh');
                    }
				}else{
					//pre($_POST);die('dfdf');
					$id = $this->account_model->insert_tbl_data('voucher',$data);
					/*Transaction table Data*/
				$for_transation_tbl = json_decode($description_voucher);
				if($for_transation_tbl !=''){
						$credit_Data = array();
						$debit_Data = array();
						$taxxxs = '';
						 $i=0;
					foreach($for_transation_tbl as $val){
						if($val->credit_debit_party_dtl == '1'){
								$IGST_data['debit_dtl'] = $val->debit_1;
								$IGST_data['ledger_id'] = $val->credit_debit_party_dtl;
								$IGST_data['credit_dtl'] = '0';
								$IGST_data['type'] = 'voucher';
								$IGST_data['type_id'] = $id;
								$IGST_data['add_date'] = $add_Date;
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$IGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
							}
						if($val->credit_debit_party_dtl == '2'){
								$CGST_data['debit_dtl'] = $val->debit_1;
								$CGST_data['ledger_id'] = $val->credit_debit_party_dtl;
								$CGST_data['credit_dtl'] = '0';
								$CGST_data['type'] = 'voucher';
								$CGST_data['type_id'] = $id;
								$CGST_data['add_date'] = $add_Date;
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
							}	
						if($val->credit_debit_party_dtl == '3'){
								$SGST_data['debit_dtl'] = $val->debit_1;
								$SGST_data['ledger_id'] = $val->credit_debit_party_dtl;
								$SGST_data['credit_dtl'] = '0';
								$SGST_data['type'] = 'voucher';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
							}	
						if($val->cr_dr == 'credit'  && $val->credit_debit_party_dtl !='1' && $val->credit_debit_party_dtl !='2' && $val->credit_debit_party_dtl !='3'){
							$credit_data['debit_dtl'] = '0';
							$credit_data['ledger_id'] = $val->credit_debit_party_dtl;
							$credit_data['credit_dtl'] = $val->credit_1;
							$credit_data['type'] = 'voucher';
							$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
							$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
							$credit_data['type_id'] = $id;
							$credit_data['add_date'] = $add_Date;
							$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
							// pre($credit_data);
							}else if($val->cr_dr == 'debit' && $val->credit_debit_party_dtl !='1' && $val->credit_debit_party_dtl !='2' && $val->credit_debit_party_dtl !='3'){
								// $debit_Data[$i]['sale_ledger_id']  = $val->credit_debit_party_dtl;
								// $debit_Data[$i]['debit'] = $val->debit_1;
								$debit_data['debit_dtl'] = $val->debit_1;
								$debit_data['ledger_id'] = $val->credit_debit_party_dtl;
								$debit_data['credit_dtl'] = '0';
								$debit_data['type'] = 'voucher';
								$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$debit_data['type_id'] = $id;
								$debit_data['add_date'] = $add_Date;
								$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
							}
							//pre($debit_data);
							
						}
						//die('Accha');
						
				}
			/*Transaction table Data*/
						
					if ($id) {                        
                        logActivity('New Voucher details Created','voucher_type',$id);
                        $this->session->set_flashdata('message', 'Voucher inserted successfully');
					    redirect(base_url().'account/voucher_detail', 'refresh');
                    }    				
				}
			}			
        }
	
  }
  
  public function deleteVoucher_details($id = ''){	
		if (!$id) {
           redirect('account/voucher_detail', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('voucher','id',$id);
		$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'voucher');
		if($result){
			logActivity('Voucher Details Deleted','voucher',$id);
			$this->session->set_flashdata('message', 'Voucher Details Deleted Successfully');
			$result = array('msg' => 'Voucher Details Deleted Successfully', 'status' => 'success', 'code' => 'C264','url' => base_url() . 'account/voucher_detail');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}


	


/************************************************************************************************************************************************/	
/*******************************************************Recepit TO MODULE START******************************************************************/	
/************************************************************************************************************************************************/	
public function recvpayment(){
	    $this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Receive Payment', base_url() . 'Receive Payment');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Receive Payment';
		$created_by_id  = $_SESSION['loggedInUser']->c_id;
		// $this->data['payment_dtl']  = $this->account_model->get_data_for_wherecdtion('payment',array('type'=> '0','created_by'=>$created_by_id)); 
		// $this->_render_template('receive_payment/index', $this->data);
		/* For Financial Year*/
			$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id);//Fetch Data to Company Table
			$date_fcal = json_decode($date_fun->financial_year_date,true);
			
			if(empty($date_fcal)){
				if (date('m') <= 4) {//Upto June 2014-2015
					$mydate = date(date('Y-04-01'));
					$lastyear = strtotime("-1 year", strtotime($mydate));
					$first_date = date("Y-m-d", $lastyear); 
					$date = date(date('Y-03-31'));
					$second_date = date('Y-m-d', strtotime("$date"));
				} else {//After June 2015-2016
					$mydate = date(date('Y-04-01'));
					$lastyear = strtotime("-1 year", strtotime($mydate));
					$first_date = date("Y-m-d", $lastyear);
					$date = date(date('Y-03-31'));
					$second_date = date('Y-m-d', strtotime("$date"));
				}
			}else{
				
				if (date('m') <= 4) {//Upto June 2014-2015
					$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
					$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
					$first_date = date(date($s_Date));
					$date = date(date($e_Date));
					$second_date = date('Y-m-d', strtotime("$date"));
				} else {//After June 2015-2016
					$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
					$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
					$first_date = date(date($s_Date));
					$date = date(date($e_Date));
					$second_date = date('Y-m-d', strtotime("$date"));
				}
			}	
/* For Financial Year*/
		
		if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
			 $this->data['payment_dtl']  = $this->account_model->get_data_for_wherecdtion('payment',array('payment.type'=> '0','payment.created_by_cid'=> $created_by_id,'payment.created_date >=' =>$first_date, 'payment.created_date <=' => $second_date)); 
			 $this->_render_template('receive_payment/index', $this->data);
		}
		
		if(isset($_POST['start']) && isset($_POST['end'])){
			//pre($_POST);die();
			$where = array('payment.type'=> '0','payment.created_date >=' => $_POST['start'] , 'payment.created_date <=' => $_POST['end'],'payment.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
			$this->data['payment_dtl']  = $this->account_model->get_data_for_wherecdtion('payment',$where);
			$this->_render_template('receive_payment/index', $this->data);
		}else{
			$where = array('payment.type'=> '0','payment.created_by_cid'=> $created_by_id,'payment.created_date >=' =>$first_date, 'payment.created_date <=' => $second_date);
			$this->data['payment_dtl']  = $this->account_model->get_data_for_wherecdtion('payment',$where);
			
			$where2 = array('account_freeze.created_by_cid' => $_SESSION['loggedInUser']->c_id);
			$this->data['freeze_date']  = $this->account_model->get_account_freeze('account_freeze',$where2);
			$this->_render_template('receive_payment/index', $this->data);
		}
		
		
	}	
public function editrecvpayment_detail(){
	if($this->input->post()){
		$this->data['id'] = $this->input->post('id');	
		$this->data['payment_dtl'] = $this->account_model->get_data_byId('payment','id',$this->input->post('id'));			
		$this->load->view('receive_payment/edit', $this->data);
	}	
}
public function viewrecvpayment_detail(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['payment_dtl'] = $this->account_model->get_data_byId('payment','id',$this->input->post('id'));			
			$this->load->view('receive_payment/view', $this->data);
		}	
	}

	//GET NOT PAID INVOICES to show Payment Recepit
// public function get_not_paid_invoices(){
		 // if($_REQUEST['party_id'] && $_REQUEST['party_id'] != ''){
			// $invoice_data22 = $this->account_model->not_paid_data_byID('invoice',array('party_name'=> $_REQUEST['party_id'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id));
			// $data['data'] = $this->account_model->not_paid_data_byID('invoice',array('party_name'=> $_REQUEST['party_id'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id));
			
			
			
			// $charges_amt_sum = 0;
			// foreach($invoice_data22 as $charg_DD){
				// $chrg = json_decode($charg_DD['charges_added']);
				// foreach($chrg as $chargs){
					// $charges_amt_sum = $chargs->amt_with_tax;
					 // $charges_amt_sum2 = number_format((float)$charges_amt_sum, 2, '.', '');
			        // $data['charge_taxamt'] = $charges_amt_sum2;
				// }
			// }
			
		
			// echo json_encode($data);
			// die;
		// }
	// }
	public function get_not_paid_invoices(){
		 if($_REQUEST['party_id'] && $_REQUEST['party_id'] != ''){
			$invoice_data = $this->account_model->not_paid_data_byID('invoice',array('party_name'=> $_REQUEST['party_id'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id));
			echo json_encode($invoice_data);
			die;
		}
	}
public function get_seleceted_user_balance(){
	 if($_REQUEST['party_id'] && $_REQUEST['party_id'] != ''){
			$payment_data_advance = $this->account_model->Get_advance_payment('payment',array('party_id'=> $_REQUEST['party_id'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id));
			$bblnce = number_format((float)$payment_data_advance->amount_to_credit, 2, '.', '');
			echo $bblnce ;
			die;
	 }		
}

public function get_supplier_details(){
	 if($_REQUEST['party_id'] && $_REQUEST['party_id'] != ''){
			$supplier_details = $this->account_model->get_ledger_sate_Data('ledger','id',$_REQUEST['party_id'],$_SESSION['loggedInUser']->c_id);
			
			echo json_encode($supplier_details);
			
			//echo $details_new =  $supplier_details->email;
			
			die;
	 }		
}	
	
	

public function saverecept_Details(){

	if ($this->input->post()) {
	
		 $sec = strtotime($_POST['payment_date']);  
		 $add_Date = date ("Y-m-d H:i", $sec); 
	//pre($_POST['payment_date']);die();
	   $add_reciptdetail_Length = count($_POST['description']);
			if($add_reciptdetail_Length > 0){
				$arra = [];
				$i = 0;
				
				while($i < $add_reciptdetail_Length) {	
				if($_POST['invoice_id'][$i] != ''){
					$jsonArrayObject = (array('invoice_id' => $_POST['invoice_id'][$i],'open_balance' => $_POST['open_balance'][$i], 'payment_amount' => $_POST['payment_amount'][$i],'due_date' => $_POST['due_date'][$i]));
					$arra[$i] = $jsonArrayObject;
					}
				$i++;
			}	
			$payment_receipt_Detail = json_encode($arra);
				}else{
				$payment_receipt_Detail = '';
			}
			$required_fields = array('party_id','party_email','created_date','payment_method','reference_no');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
					valid_fields($is_valid);				
			}else{
					$data  = $this->input->post();
					$data['created_by'] = $_SESSION['loggedInUser']->u_id;
					$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$data['payment_detail'] = $payment_receipt_Detail;
					$data['balance'] = abs($data['balance']);
					$id = $data['id'];
				
			if($id && $id != ''){
				//pre($_POST);die();
				$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
				$success = $this->account_model->update_data('payment',$data, 'id', $id);
					if($payment_receipt_Detail != ''){
    					$ledger_id = $_REQUEST['recieve_ledger_id'];
						$debit_data['credit_dtl'] = '0';
						$debit_data['debit_dtl'] = $_POST['added_amount'];
						$debit_data['type'] = 'Payment Receive';
						//$debit_data['ifadvance'] = 'advance';
						$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						$debit_data['type_id'] = $id;
						$debit_data['add_date'] = $add_Date;
						
						$this->account_model->update_transaction_data('transaction_dtl',$debit_data, 'type_id', $id, 'Payment Receive',$ledger_id);
						/* For Sale Ledger Details data*/
						
						/* For Purchase Ledger Details data*/
						$credit_data['debit_dtl'] = '0';
						$ledger_id = $_POST['party_id'];
						$credit_data['credit_dtl'] = $_POST['added_amount'];
						//$debit_data['ifadvance'] = 'advance';
						$credit_data['type'] = 'Payment Receive';
						$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						$credit_data['type_id'] = $id;
						$credit_data['add_date'] = $add_Date;
						$this->account_model->update_transaction_data('transaction_dtl',$credit_data, 'type_id', $id, 'Payment Receive',$ledger_id);
					}
					/* For Purchase Ledger Details data*/
					
						
				if ($success) {
					$data['message'] = "Receive Payment updated successfully";
					logActivity('Receive Payment Updated','payment',$id);
					$this->session->set_flashdata('message', 'Receive Payment Updated successfully');
					redirect(base_url().'account/recvpayment', 'refresh');
				}
				}else{
					if (!empty($data)){
					/* Get Details of paid and not paid and update invoice Table accordingly*/
					
					$get_proper_invoice_paid = json_decode($data['payment_detail']);
							foreach($get_proper_invoice_paid as $paid_invc_data)
							{
								$invoice_id = $paid_invc_data->invoice_id;
								$open_balance = $paid_invc_data->open_balance;
								$payment_amount = $paid_invc_data->payment_amount;
								
								
								if($open_balance != $payment_amount){
								// if($_POST['total_amount'] != $_POST['added_amount']){
								// if($data['balance'] != 0){
									$data['balance'] = $open_balance - $payment_amount;
									$update_data = array(
											'total_amount' => abs($data['balance']),
											'charges_total_tax' => '0'
									);
									$this->account_model->add_balance_amount_or_paid('invoice',$update_data, $invoice_id);
								}else{
										$update_data = array(
											'pay_or_not' => '1',
											'charges_total_tax' => '0'
										);
									$this->account_model->add_balance_amount_or_paid('invoice',$update_data, $invoice_id);
								}
							}
						
						
					/* Get Details of paid and not paid and update invoice Table accordingly*/
					$id = $this->account_model->insert_tbl_data('payment',$data);
					
					
					
							if($payment_receipt_Detail != ''){
								
								$debit_data['debit_dtl'] = $_POST['added_amount'];
								$debit_data['ledger_id'] = $_REQUEST['recieve_ledger_id'];
								$debit_data['credit_dtl'] = '0';
								$debit_data['type'] = 'Payment Receive';
								$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$debit_data['type_id'] = $id;
								$debit_data['add_date'] = $add_Date;
								
									$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
								/* For Sale Ledger Details data*/
								
								/* For Purchase Ledger Details data*/
								$credit_data['debit_dtl'] = '0';
								$credit_data['ledger_id'] = $_POST['party_id'];
								$credit_data['credit_dtl'] = $_POST['added_amount'];
								$credit_data['type'] = 'Payment Receive';
								$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$credit_data['type_id'] = $id;
								$credit_data['add_date'] = $add_Date;
								$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
								/* For Purchase Ledger Details data*/
							}
							/*Code For Charges and Testing*/
							
							

				}
				if ($id) {                        
					logActivity('New add payment details Created','payment',$id);
					$this->session->set_flashdata('message', 'Receive Payment inserted successfully');
				   redirect(base_url().'account/recvpayment', 'refresh');
				}    				
			}
		}			
	}
	}	
	
	public function deleterecipt($id = ''){	
		if (!$id) {
           redirect('account/recvpayment', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('payment','id',$id);
		if($result){
			logActivity('Receive Payment Deleted','payment',$id);
			$this->session->set_flashdata('message', 'Receive Payment Deleted Successfully');
			$result = array('msg' => 'Receive Payment Deleted Successfully', 'status' => 'success', 'code' => 'C264','url' => base_url() . 'account/recvpayment');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}	

/***********************************************************************************************************************************************/	
/******************************************************PAYMENT TO MODULE START******************************************************************/	
/***********************************************************************************************************************************************/	
	public function paymentto(){
	    $this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Payment', base_url() . 'Payment');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Payment To';
		$created_by_id  = $_SESSION['loggedInUser']->c_id;
		/* For Financial Year*/
			$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id);//Fetch Data to Company Table
			$date_fcal = json_decode($date_fun->financial_year_date,true);
			
			if(empty($date_fcal)){
				if (date('m') <= 4) {//Upto June 2014-2015
					$mydate = date(date('Y-04-01'));
					$lastyear = strtotime("-1 year", strtotime($mydate));
					$first_date = date("Y-m-d", $lastyear); 
					$date = date(date('Y-03-31'));
					$second_date = date('Y-m-d', strtotime("$date"));
				} else {//After June 2015-2016
					$mydate = date(date('Y-04-01'));
					$lastyear = strtotime("-1 year", strtotime($mydate));
					$first_date = date("Y-m-d", $lastyear);
					$date = date(date('Y-03-31'));
					$second_date = date('Y-m-d', strtotime("$date"));
				}
			}else{
				
				if (date('m') <= 4) {//Upto June 2014-2015
					$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
					$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
					$first_date = date(date($s_Date));
					$date = date(date($e_Date));
					$second_date = date('Y-m-d', strtotime("$date"));
				} else {//After June 2015-2016
					$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
					$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
					$first_date = date(date($s_Date));
					$date = date(date($e_Date));
					$second_date = date('Y-m-d', strtotime("$date"));
				}
			}	
/* For Financial Year*/
		if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
			 $this->data['payment_to_dtl']  = $this->account_model->get_data_for_wherecdtion('payment',array('payment.type'=> '1','payment.created_by_cid'=> $created_by_id,'payment.created_date >=' =>$first_date, 'payment.created_date <=' => $second_date)); 
			 $this->_render_template('payment_to/index', $this->data);
		}
		
		if(!empty($_POST)){
			$where = array('payment.type'=> '1','payment.created_date >=' => $_POST['start'] , 'payment.created_date <=' => $_POST['end'],'payment.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
			$this->data['payment_to_dtl']  = $this->account_model->get_data_for_wherecdtion('payment',$where);
			$this->_render_template('payment_to/index', $this->data);
		}else{
			$where = array('payment.type'=> '1','payment.created_by_cid' => $_SESSION['loggedInUser']->c_id,'payment.created_date >=' =>$first_date, 'payment.created_date <=' => $second_date);
			
			$this->data['payment_to_dtl']  = $this->account_model->get_data_for_wherecdtion('payment',$where);
		
			// $where2 = array('account_freeze.created_by_cid' => $_SESSION['loggedInUser']->c_id);
			
			// $this->data['freeze_date']  = $this->account_model->get_account_freeze('account_freeze',$where2);
			
			$this->_render_template('payment_to/index', $this->data);
		}
		
	}		

public function editpayment_to_detail(){
	if($this->input->post()){
		$this->data['id'] = $this->input->post('id');	
		$this->data['payment_to_dtl'] = $this->account_model->get_data_byId('payment','id',$this->input->post('id'));
		$this->data['bank_name'] = $this->account_model->get_data('bank_name');
		
		$this->load->view('payment_to/edit', $this->data);
	}	
}
public function viewpayment_to_detail(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['payment_to_dtl'] = $this->account_model->get_data_byId('payment','id',$this->input->post('id'));			
			$this->load->view('payment_to/view', $this->data);
		}	
	}
	
public function get_not_paid_bills(){
	
		 if($_REQUEST['supplier_name'] && $_REQUEST['supplier_name'] != ''){
			$bills_data = $this->account_model->not_paid_purchase_bill('purchase_bill',array('supplier_name'=> $_REQUEST['supplier_name'],'auto_entry'=>'0'));
		//	pre($bills_data);die();
			$purchase_order_data = $this->account_model->not_paid_purchase_bill('purchase_order',array('supplier_name'=> $_REQUEST['supplier_name'],'mrn_or_not'=>'0'));
			$merage_Data = array_merge($bills_data, $purchase_order_data); 
			
  			echo json_encode($merage_Data);
			die();
		}
	}

public function savepayment_to_Details(){
	
	  if ($this->input->post()) {
		    $sec = strtotime( $_POST['payment_date']);  
			$add_Date = date ("Y-m-d H:i", $sec); 
//pre($_POST);die();
	   $add_reciptdetail_Length = count($_POST['description']);
			if($add_reciptdetail_Length >0){
				$arra = [];
				$i = 0;
				while($i < $add_reciptdetail_Length) {	
					if($_POST['bill_id'][$i] != ''){
						$jsonArrayObject = (array('bill_id' => $_POST['bill_id'][$i],'open_balance' => $_POST['open_balance'][$i], 'payment_amount' => $_POST['payment_amount'][$i],'date' => $_POST['date'][$i],'order_code' => $_POST['order_code'][$i],'from_detail'=>$_POST['from_detail'][$i]));
						$arra[$i] = $jsonArrayObject;
				}
					$i++;
			}	
				$payment_receipt_Detail = json_encode($arra);
				}else{
					$payment_receipt_Detail = '';
				}
				$required_fields = array('party_id');	
				$is_valid = validate_fields($_POST, $required_fields);
				if (count($is_valid) > 0) {
					valid_fields($is_valid);				
				}
			else{
				
				
				$data  = $this->input->post();			
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				$data['payment_detail'] = $payment_receipt_Detail;
				$data['type'] = '1';//0 for payment recived 1 for payment to
				$id = $data['id'];
				
				// pre($_POST);die();
				// pre($data);die();
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->account_model->update_data('payment',$data, 'id', $id);
					//Code for  add Transaction Details according to Details	
						$ledger_id = $_REQUEST['recieve_ledger_id'];
						$debit_data['credit_dtl'] = $_POST['added_amount'];
						$debit_data['debit_dtl'] =  '0';
						$debit_data['type'] = 'purchase_bill_payment_recive';
						$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						$debit_data['type_id'] = $id;
						$debit_data['add_date'] = $add_Date;
						
						$this->account_model->update_transaction_data('transaction_dtl',$debit_data, 'type_id', $id, 'purchase_bill_payment_recive',$ledger_id);
						/* For Sale Ledger Details data*/
						
						/* For Purchase Ledger Details data*/
						$credit_data['debit_dtl'] = $_POST['added_amount'];
						$ledger_id = $_POST['party_id'];
						$credit_data['credit_dtl'] =  '0';
						$credit_data['type'] = 'purchase_bill_payment_recive';
						$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						$credit_data['type_id'] = $id;
						$credit_data['add_date'] = $add_Date;
						$this->account_model->update_transaction_data('transaction_dtl',$credit_data, 'type_id', $id, 'purchase_bill_payment_recive',$ledger_id);
						
					//Code for  add Transaction Details according to Details	


					if ($success) {
                        $data['message'] = "Payment updated successfully";
                        logActivity('Payment Updated','payment',$id);
                        $this->session->set_flashdata('message', 'Payment Updated successfully');
					    redirect(base_url().'account/paymentto', 'refresh');
                    }
				}else{
					if (!empty($data)){
						/* Get Details of paid and not paid and update invoice Table accordingly*/
						$get_proper_bills_paid = json_decode($data['payment_detail']);
						
						
							foreach($get_proper_bills_paid as $paid_bills_data)
							{
								
						
								 $bill_id = $paid_bills_data->bill_id;
								 $open_balance = $paid_bills_data->open_balance;
								 $payment_amount = $paid_bills_data->payment_amount;
								$order_code_check_for_order_table_data = $paid_bills_data->order_code;
								$pi_id = $paid_bills_data->pi_id;
							
								if($order_code_check_for_order_table_data == 'undefined' && $_POST['throu_pi_or_not'] == 0){
										if($open_balance != $payment_amount){
										// if($data['balance'] != 0){
											$balance = $open_balance - $payment_amount;
											 $update_data = array(
													'grand_total' => abs($balance),
													'charges_total_tax' => '0'
											);
											$this->account_model->add_balance_amount_or_paid('purchase_bill',$update_data, $bill_id);
										}else{
											$update_data = array(
													'pay_or_not' => '1',
													'charges_total_tax' => '0'
											);
									    	$this->account_model->add_balance_amount_or_paid('purchase_bill',$update_data, $bill_id);
										}
										// pre($update_data);	
										// die('Accha ji');
								}elseif($order_code_check_for_order_table_data != 'undefined' && $_POST['throu_pi_or_not'] == 0){
									if($open_balance != $payment_amount){
									// if($data['balance'] != 0){
											$balance = $open_balance - $payment_amount;
											 $update_data = array(
													'grand_total' => abs($balance),
													//'charges_total_tax' => '0'
											);
											$this->account_model->add_balance_amount_or_paid('purchase_order',$update_data, $bill_id);
										}else{
											$date22 = date('Y-m-d H:i:s');
											$update_data = array(
													'pay_or_not' => '1',
													'mrn_or_not' => '1',
													'ifbalance' => '0',
													'complete_date' => $date22 
											);
											$this->account_model->add_balance_amount_or_paid('purchase_order',$update_data, $bill_id);
										}
								}elseif($_POST['throu_pi_or_not'] != 0){
									
									if($open_balance != $payment_amount){
										// if($data['balance'] != 0){
											$balance = $open_balance - $payment_amount;
										
											 $update_data = array(
													'grand_total' => $balance,
													//'charges_total_tax' => '0'
											);
											$this->account_model->add_balance_amount_or_paid('purchase_indent',$update_data, $_POST['throu_pi_or_not']);
										}else{
											$update_data = array(
													'pay_or_not' => '1',
													//'charges_total_tax' => '0'		
											);
										
											$this->account_model->add_balance_amount_or_paid('purchase_indent',$update_data, $_POST['throu_pi_or_not']);
										}
									
								}	
							}
							
							//die('after for loop');
				
						/* Get Details of paid and not paid and update invoice Table accordingly*/
						
						
						
						$id = $this->account_model->insert_tbl_data('payment',$data);
							$debit_data['debit_dtl'] = '0';
							$debit_data['ledger_id'] = $_REQUEST['recieve_ledger_id'];
							$debit_data['credit_dtl'] = $_POST['added_amount'];
							$debit_data['type'] = 'purchase_bill_payment_recive';
							$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
							$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
							$debit_data['type_id'] = $id;
							$debit_data['add_date'] = $add_Date;
								$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
							/* For Sale Ledger Details data*/
							
							/* For Purchase Ledger Details data*/
							$credit_data['debit_dtl'] = $_POST['added_amount'];
							$credit_data['ledger_id'] = $_POST['party_id'];
							$credit_data['credit_dtl'] = '0';
							$credit_data['type'] = 'purchase_bill_payment_recive';
							$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
							$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
							$credit_data['type_id'] = $id;
							$credit_data['add_date'] = $add_Date;
							$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);						
						
					}
					if ($id) {                        
                        logActivity('New add payment details Created','payment',$id);
                        $this->session->set_flashdata('message', 'Payment inserted successfully');
					   redirect(base_url().'account/paymentto', 'refresh');
                    }    				
				}
			}			
        }
	
  }	

public function delete_payment_to($id = ''){	
		if (!$id) {
           redirect('account/paymentto', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('payment','id',$id);
		if($result){
			logActivity('Payment Deleted','payment',$id);
			$this->session->set_flashdata('message', 'Payment Deleted Successfully');
			$result = array('msg' => 'Payment Deleted Successfully', 'status' => 'success', 'code' => 'C264','url' => base_url() . 'account/paymentto');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1050'));
        }
	}




/************************************************************************************************************************************************/	
/****************************************************Purchase Bill MODULE Start******************************************************************/	
/************************************************************************************************************************************************/
	public function  purchase_bill(){
			$this->data['can_edit'] = edit_permissions();
			$this->data['can_delete'] = delete_permissions();
			$this->data['can_add'] = add_permissions();
			$this->breadcrumb->add('Purchase Bill', base_url() . 'Purchase Bill');
			$this->settings['breadcrumbs'] = $this->breadcrumb->output();
			$this->settings['pageTitle'] = 'Purchase Bill';
			$created_by_id  = $_SESSION['loggedInUser']->u_id;
			$connected_com_id  = $_SESSION['loggedInUser']->c_id;
			/* For Financial Year*/
				$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id);//Fetch Data to Company Table
				$date_fcal = json_decode($date_fun->financial_year_date,true);
				
				if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						$mydate = date(date('Y-04-01'));
						$lastyear = strtotime("-1 year", strtotime($mydate));
						$first_date = date("Y-m-d", $lastyear); 
						$date = date(date('Y-03-31'));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$mydate = date(date('Y-04-01'));
						$lastyear = strtotime("-1 year", strtotime($mydate));
						$first_date = date("Y-m-d", $lastyear);
						$date = date(date('Y-03-31'));
						$second_date = date('Y-m-d', strtotime("$date"));
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					}
				}	
			/* For Financial Year*/
			
			if(!empty($_POST['hsnsac_number'])){
			$invalid_hsnsac = implode(',', $_POST['hsnsac_number']);
			$this->data['purchase_data']  = $this->account_model->get_ledgers_whereIn_conditions('purchase_bill',$connected_com_id,$invalid_hsnsac);
			$this->_render_template('purchase_bill/index', $this->data);
		}
			
			if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
				$this->data['purchase_data']  = $this->account_model->get_purchase_invoice_details('purchase_bill',array('purchase_bill.created_by_cid'=> $connected_com_id,'purchase_bill.created_date >=' =>$first_date, 'purchase_bill.created_date <=' => $second_date));
				$this->data['automatic_purchase_bill']  = $this->account_model->get_auto_invoice_details('invoice',array('party_conn_company'=> $connected_com_id,'accept_reject'=>'','invoice.created_date >=' =>$first_date, 'invoice.created_date <=' => $second_date));
				$this->_render_template('purchase_bill/index', $this->data);
			}
			if(isset($_POST['start']) && isset($_POST['end']) ){
				
				$where = array('purchase_bill.created_date >=' => $_POST['start'] , 'purchase_bill.created_date <=' => $_POST['end'],'purchase_bill.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
				$this->data['purchase_data']  = $this->account_model->get_purchase_invoice_details('purchase_bill',$where);
			    
				$this->data['automatic_purchase_bill']  = $this->account_model->get_auto_invoice_details('invoice',array('party_conn_company'=> $connected_com_id,'accept_reject'=>'','invoice.created_date >=' => $_POST['start'] , 'invoice.created_date <=' => $_POST['end'],'invoice.created_by_cid'=> $_SESSION['loggedInUser']->c_id));
				
				$this->_render_template('purchase_bill/index', $this->data);
			}else{
				$where = array('purchase_bill.created_by_cid' => $_SESSION['loggedInUser']->c_id,'auto_entry'=>'0','purchase_bill.created_date >=' =>$first_date, 'purchase_bill.created_date <=' => $second_date);
				$this->data['purchase_data']  = $this->account_model->get_purchase_invoice_details('purchase_bill',$where);
				
				$this->data['purchase_data_form_mrn']  = $this->account_model->get_purchase_invoice_details('purchase_bill',array('purchase_bill.created_by_cid' => $_SESSION['loggedInUser']->c_id,'auto_entry'=>'1','purchase_bill.created_date >=' =>$first_date, 'purchase_bill.created_date <=' => $second_date));
				
			    $this->data['automatic_purchase_bill']  = $this->account_model->get_auto_invoice_details('invoice',array('party_conn_company'=> $connected_com_id,'accept_reject'=>'','invoice.created_date >=' =>$first_date, 'invoice.created_date <=' => $second_date)); 
				$where2 = array('account_freeze.created_by_cid' => $_SESSION['loggedInUser']->c_id);
				$this->data['freeze_date']  = $this->account_model->get_account_freeze('account_freeze',$where2);
				$this->_render_template('purchase_bill/index', $this->data);
			}
			
			// $this->data['purchase_data']  = $this->account_model->get_purchase_invoice_details('purchase_bill',array('created_by'=> $created_by_id));
			// $this->data['automatic_purchase_bill']  = $this->account_model->get_auto_invoice_details('invoice',array('party_conn_company'=> $connected_com_id,'accept_reject'=>''));$this->_render_template('purchase_bill/index', $this->data);
	} 


	public function editpurchase_bill_detail(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['purchase_data'] = $this->account_model->get_data_byId('purchase_bill','id',$this->input->post('id'));			
			$this->load->view('purchase_bill/edit', $this->data);
		}	
	}
	
public function viewpurchase_bill_detail(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['purchase_data'] = $this->account_model->get_data_byId('purchase_bill','id',$this->input->post('id'));			
			$this->load->view('purchase_bill/view', $this->data);
		}	
	}
public function viewpurchase_register_detail(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['purchase_data'] = $this->account_model->get_data_byId('purchase_bill','id',$this->input->post('id'));			
			$this->load->view('purchaseregister/view', $this->data);
		}	
	}	
	
public function viewpurchase_unpaid_bill_detail(){
	if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			//$this->data['purchase_data'] = $this->account_model->get_data_byId('purchase_bill','id',$this->input->post('id'));
			$this->data['purchase_data'] = $this->account_model->not_paid_purchase_bill('purchase_bill',array('supplier_name'=> $_REQUEST['id'],'auto_entry'=> 0));	
			$this->load->view('accountpayable/view_unpaid_bill', $this->data);
		}	
	}	
	


public function viewautomatic_entry_invoice(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['auto_invoice_data'] = $this->account_model->get_data_byId('invoice','id',$this->input->post('id'));			
			$this->load->view('purchase_bill/view_auto_invoice', $this->data);
		}	
	}	


//GET supplier DETAILS
	public function Getsupplier_details(){
		
		if($_REQUEST['id'] && $_REQUEST['id'] != ''){
			$data = $this->account_model->get_matrial_data_byId('ledger','id',$_REQUEST['id']);
			echo json_encode($data,true);
			die;
			 
		 }
		
	}
//Get Email for Supplier Payment	
public function getEmail(){        
        $id = $_POST['supplier_name'];
        $data = $this->account_model->get_email('supplier',$id);
    
        $contact_email = '';    
        foreach($data as $val){
            $email_Data = json_decode($val['contact_detail'],true);
            $contact_email = $email_Data[0]['email'];
        }
        echo $contact_email;
}
//Get Email for Supplier Payment

public function savepurchase_bill_Details(){
	  if ($this->input->post()) {
		  /*Calulation for get amount with tax and tax*/
		  //pre($_POST);die();
		    $sec = strtotime( $_POST['date']);  
			$add_Date = date ("Y-m-d H:i", $sec);
			
			$total =  $_POST['total_amount'] -  $_POST['totaltax_total'];
			$subtotal_tax_withtax = array(array('total'=>$_POST['total_AMMT'],'totaltax'=>$_POST['totaltax_total'],'invoice_total_with_tax'=>$_POST['total_amount'],'cess_all_total' => $_POST['cess_total']));
			$totoaal_tax_data = json_encode($subtotal_tax_withtax);
		  /*Calulation for get amount with tax and tax*/
		    $get_supplier_details_in_ledger_tbl = $this->account_model->get_ledger_sate_Data('ledger','id',$_REQUEST['supplier_name'],$_SESSION['loggedInUser']->c_id);//This Code is used when Ledger and Supplier Table is Mixed
		
		    $supplier_data = $this->account_model->get_ledger_sate_Data('ledger','id',$get_supplier_details_in_ledger_tbl->id,$_SESSION['loggedInUser']->u_id);
			//$supplier_datastate_id = $supplier_data->state;
			
			$CGST = $SGST = $IGST = 0;
			$sale_ledger_Data = $this->account_model->get_ledger_sate_Data('ledger','id',$_REQUEST['party_name'],$_SESSION['loggedInUser']->u_id);
			$purchase_ledger_state_id = $sale_ledger_Data->mailing_address;
			
			$Purchase_ledger_state_id = Json_decode($purchase_ledger_state_id,true);
			$supplier_datastate_id = Json_decode($supplier_data->mailing_address,true);
			//pre($supplier_datastate_id);die();
			
			$charges_tax = array_sum($_POST['amt_tax']);//ADD Charges and Discount Tax for add material Tax.
			
			
			if($supplier_datastate_id[0]['mailing_state'] != $Purchase_ledger_state_id[0]['mailing_state']){
				$IGST = $_POST['totaltax_total'] + $charges_tax ;
			}else{
				$divide_cgst_sgst = $_POST['totaltax_total']/2;
				$divide_charge_tax = $charges_tax / 2;
				$CGST = $divide_cgst_sgst + $divide_charge_tax;
				$SGST = $divide_cgst_sgst + $divide_charge_tax;
			}
			$charges_Added_Count = 	count($_POST['charges_added']);
					
					if($charges_Added_Count > 0){
						$charg_Add = [];
						$ch = 0;
						while($ch < $charges_Added_Count){
							//$jsonarray_chargeobj = (array('particular_charges_name'=>$_POST['particular_charges'][$ch],'charges_added'=>$_POST['charges_added'][$ch],'sgst_amt'=>$_POST['sgst_amt'][$ch],'cgst_amt'=>$_POST['cgst_amt'][$ch],'igst_amt'=>$_POST['igst_amt'][$ch],'amt_with_tax'=>$_POST['amt_with_tax'][$ch]));

							$jsonarray_chargeobj = (array('particular_charges_name'=>$_POST['particular_charges'][$ch],'type_charges'=>$_POST['type_charges'][$ch],'ledger_name'=>$_POST['ledger_name'][$ch],'ledger_name_id'=>$_POST['ledger_name_id'][$ch],'amt_tax'=>$_POST['amt_tax'][$ch],'charges_added'=>$_POST['charges_added'][$ch],'sgst_amt'=>$_POST['sgst_amt'][$ch],'cgst_amt'=>$_POST['cgst_amt'][$ch],'igst_amt'=>$_POST['igst_amt'][$ch],'amt_with_tax'=>$_POST['amt_with_tax'][$ch]));
							$charg_Add[$ch] = $jsonarray_chargeobj;
							$ch++;
						}
						$json_charg_lead_total_array = json_encode($charg_Add);
					}else{
						$json_charg_lead_total_array = '';
					}
					
				
					

		   $descr_of_bills_Length = count($_POST['descr_of_bills']);
				if($descr_of_bills_Length >0){
					$arra = [];
					$i = 0;
					while($i < $descr_of_bills_Length) {	
						$jsonArrayObject = (array('descr_of_bills' => $_POST['descr_of_bills'][$i],'product_details' => $_POST['product_details'][$i], 'qty' => $_POST['qty'][$i],'UOM' => $_POST['UOM'][$i],'hsnsac' => $_POST['hsnsac'][$i],'rate' => $_POST['rate'][$i],'tax' => $_POST['tax'][$i],'added_tax_Row_val' => $_POST['added_tax_Row_val'][$i],'amountwittax' => $_POST['amount'][$i],'subtotal' => $_POST['subtotal'][$i],'disctype'=>$_POST['disctype'][$i],'discamt'=>$_POST['discamt'][$i],'after_desc_amt'=>$_POST['after_desc_amt'][$i],'cess'=>$_POST['cess'][$i],'valuation_type'=>$_POST['valuation_type'][$i],'cess_tax_calculation'=>$_POST['cess_tax_calculation'][$i]));
						$arra[$i] = $jsonArrayObject;
						$i++;
				}	
					$purchase_bill_Detail = json_encode($arra);
				}else{
					$purchase_bill_Detail = '';
				}
					$debit_amt = $_POST['total_amount']  -  $_POST['totaltax_total']; 
					//$debit_amt = $_POST['total_amount']  -  $_POST['totaltax_total']; 
					$matrial_dtl = json_decode($purchase_bill_Detail);
			 
				
			
			
			$required_fields = array('supplier_name','descr_of_bills');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				
				$data  = $this->input->post();			
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				$data['descr_of_bills'] = $purchase_bill_Detail;
				$data['charges_added'] = $json_charg_lead_total_array;	
				$data['IGST'] = $IGST;
				$data['CGST'] = $CGST;
				$data['SGST'] = $SGST;
				$data['invoice_total_with_tax'] = $totoaal_tax_data;
				$data['product_detail'] = 'From Bill';
				$id = $data['id'];
				$data['grand_total'] = $_POST['total_amount'];
				
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$success = $this->account_model->update_data('purchase_bill',$data, 'id', $id);	
					 /* For Sale Ledger Details data*/
					$debit_data['debit_dtl'] = '0';
					$debit_data['ledger_id'] = $_POST['supplier_name'];
					$debit_data['credit_dtl'] = $debit_amt;
					$debit_data['type'] = 'purchase_bill';
					$debit_data['type_id'] = $id;
					$debit_data['add_date'] = $add_Date; 
					$this->account_model->update_transaction_data('transaction_dtl',$debit_data, 'type_id', $id, 'purchase_bill',$_POST['supplier_name']);
					/* For Sale Ledger Details data*/
					
					/* For Purchase Ledger Details data*/
					$credit_data['debit_dtl'] = $_POST['total_amount'];
					$credit_data['ledger_id'] = $_POST['party_name'];
					//$credit_data['credit_dtl'] = $debit_amt;
					$credit_data['credit_dtl'] = '0';
					$credit_data['type'] = 'purchase_bill';
					$credit_data['type_id'] = $id;
					$credit_data['add_date'] = $add_Date; 
					$this->account_model->update_transaction_data('transaction_dtl',$credit_data, 'type_id', $id, 'purchase_bill',$_POST['party_name']);
					/* For Purchase Ledger Details data*/
					
					/* For CGST SGST IGST Table*/
							if($CGST !=''){
								$CGST_data['debit_dtl'] = $CGST;
								$CGST_data['ledger_id'] = '2';
								$CGST_data['credit_dtl'] = '0';
								$CGST_data['type'] = 'purchase_bill';
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$CGST_data['type_id'] = $id;
								$CGST_data['add_date'] = $add_Date; 
								$this->account_model->update_transaction_data('transaction_dtl',$CGST_data, 'type_id', $id, 'purchase_bill','2');
							}
							
							if($SGST != ''){
								$SGST_data['debit_dtl'] = $SGST;
								$SGST_data['ledger_id'] = '3';
								$SGST_data['credit_dtl'] = '0';
								$SGST_data['type'] = 'purchase_bill';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date; 
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->update_transaction_data('transaction_dtl',$SGST_data, 'type_id', $id, 'purchase_bill','3');
								//$tax = array('SGST'=> $_POST['SGST']);
							}
							
							if($IGST != ''){
								$IGST_data['debit_dtl'] = $IGST;
								$IGST_data['ledger_id'] = '1';
								$IGST_data['credit_dtl'] = '0';
								$IGST_data['type'] = 'purchase_bill';
								$IGST_data['type_id'] = $id;
								$IGST_data['add_date'] = $add_Date; 
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$IGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->update_transaction_data('transaction_dtl',$IGST_data, 'type_id', $id, 'purchase_bill','1');
							}
						if($data['auto_entry'] == '1' ){
							
							 /* For Sale Ledger Details data*/
									$debit_data['debit_dtl'] = '0';
									$debit_data['ledger_id'] = $_POST['supplier_name'];
									$debit_data['credit_dtl'] = $_POST['total_amount'];
									$debit_data['type'] = 'purchase_bill';
									$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
									$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
									$debit_data['type_id'] = $id;
									$debit_data['add_date'] = $add_Date;
									
									$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
									/* For Sale Ledger Details data*/
									
									/* For Purchase Ledger Details data*/
									$credit_data['debit_dtl'] = $debit_amt;;
									$credit_data['ledger_id'] = $_POST['party_name'];
									//$credit_data['credit_dtl'] = $debit_amt;
									$credit_data['credit_dtl'] = '0';
									$credit_data['type'] = 'purchase_bill';
									$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
									$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
									$credit_data['type_id'] = $id;
									$credit_data['add_date'] = $add_Date;
									$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
									/* For Purchase Ledger Details data*/
							
							/* For CGST SGST IGST Table*/
									if($CGST !=''){
										$CGST_data['debit_dtl'] = $CGST;
										$CGST_data['ledger_id'] = '2';
										$CGST_data['credit_dtl'] = '0';
										$CGST_data['type'] = 'purchase_bill';
										$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										$CGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
										$CGST_data['type_id'] = $id;
										$CGST_data['add_date'] = $add_Date;
										$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
										//$tax = array('CGST'=> $_POST['CGST']);
									}
									
									if($SGST != ''){
										$SGST_data['debit_dtl'] = $SGST;
										$SGST_data['ledger_id'] = '3';
										$SGST_data['credit_dtl'] = '0';
										$SGST_data['type'] = 'purchase_bill';
										$SGST_data['type_id'] = $id;
										$SGST_data['add_date'] = $add_Date;
										$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										$SGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
										$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
										//$tax = array('SGST'=> $_POST['SGST']);
									}
									
									if($IGST != ''){
										$IGST_data['debit_dtl'] = $IGST;
										$IGST_data['ledger_id'] = '1';
										$IGST_data['credit_dtl'] = '0';
										$IGST_data['type'] = 'purchase_bill';
										$IGST_data['type_id'] = $id;
										$IGST_data['add_date'] = $add_Date;
										$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										$IGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
										$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
									}
									
									//$this->account_model->update_data('purchase_bill',$data, 'id', $id);
									$this->account_model->update_single_data_for_purchase_bill_auto_entery($id,'purchase_bill');
								}		
					
					/*Update Code For charges Ledgers and Discount Ledgers*/
					$ddt =	json_decode($json_charg_lead_total_array, true);
				if($ddt[0]['particular_charges_name'] != ''){	
						$charges_Discount_data = json_decode($json_charg_lead_total_array,true);
						
						foreach($charges_Discount_data as $chrg_data){
							if(!empty($chrg_data)){
							
							if($chrg_data['type_charges'] == 'plus'){
								$charges_Data['debit_dtl'] =  $chrg_data['charges_added'];
								$charges_Data['credit_dtl'] = '0';
								$charges_Data['add_date'] = $add_Date;
								$this->account_model->update_single_data_for_charges($chrg_data['amt_with_tax'], $id,'purchase_bill');//USd to add Charges in Per invoice 
								$this->account_model->update_transaction_data('transaction_dtl',$charges_Data, 'type_id', $id, 'purchase_bill',$chrg_data['ledger_name_id']);
							}else{
								$charges_Data['debit_dtl'] = '0';
								$charges_Data['credit_dtl'] = $chrg_data['charges_added'];
								$this->account_model->update_transaction_data('transaction_dtl',$charges_Data, 'type_id', $id, 'purchase_bill',$chrg_data['ledger_name_id']);
							}
						}	
					}
				}
		
					/*Update Code For charges Ledgers and Discount Ledgers*/
					
					/* Enable RCM code start*/
						
						$get_RCM_enable_or_not = getNameById('ledger',$_POST['supplier_name'],'id');
				
						$get_party_state = getNameById('ledger',$_POST['party_name'],'id');
						$supplier_state_id = json_decode($get_RCM_enable_or_not->mailing_address,true);
						$party_state_id = json_decode($get_party_state->mailing_address,true);
						
						if($get_RCM_enable_or_not->enble_disbl_rcm == 1){// if 1 its Enable RCM
						
						if($party_state_id[0]['mailing_state'] != $supplier_state_id[0]['mailing_state']){	
							  $Voucher_DAta ='[{"credit_debit_party_dtl":"'.$_POST['supplier_name'].'","credit_1":"'.$_POST['total'][0].'","debit_1":"","cr_dr":"credit"},{"credit_debit_party_dtl":"'.$_POST['party_name'].'","credit_1":"","debit_1":"'.$_POST['total'][0].'","cr_dr":"debit"},{"credit_debit_party_dtl":"1","credit_1":"","debit_1":"'.$IGST.'","cr_dr":"debit"},{"credit_debit_party_dtl":"4","credit_1":"'.$IGST.'","debit_1":"","cr_dr":"credit"}]';
						}else{
							$Voucher_DAta ='[{"credit_debit_party_dtl":"'.$_POST['supplier_name'].'","credit_1":"'.$_POST['total'][0].'","debit_1":"","cr_dr":"credit"},{"credit_debit_party_dtl":"'.$_POST['party_name'].'","credit_1":"","debit_1":"'.$_POST['total'][0].'","cr_dr":"debit"},{"credit_debit_party_dtl":"2","credit_1":"","debit_1":"'.$CGST.'","cr_dr":"debit"},{"credit_debit_party_dtl":"3","credit_1":"","debit_1":"'.$SGST.'","cr_dr":"debit"},{"credit_debit_party_dtl":"5","credit_1":"'.$CGST.'","debit_1":"","cr_dr":"credit"},{"credit_debit_party_dtl":"6","credit_1":"'.$SGST.'","debit_1":"","cr_dr":"credit"}]';
						}
										
						$voucher_tbl_Data['credit_debit_party_dtl'] = $Voucher_DAta;
						$voucher_tbl_Data['voucher_name'] = '18';
						$voucher_tbl_Data['voucher_date'] = $_POST['date'];
						$voucher_tbl_Data['total'] = $_POST['total'][0];
						$voucher_tbl_Data['purchase_id'] = $id;
						$voucher_tbl_Data['created_by'] = $_SESSION['loggedInUser']->c_id;
						$voucher_tbl_Data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						$voucher_tbl_Data['edited_by'] = $_SESSION['loggedInUser']->c_id;
						
						$this->account_model->update_data('voucher',$voucher_tbl_Data, 'purchase_id', $id);
				}
					/* Enable RCM code start*/
					
					
					if ($success) {
                        $data['message'] = "Bill Detail updated successfully";
                        logActivity('Bill Detail Updated','purchase_bill',$id);
                        $this->session->set_flashdata('message', 'Bill Detail Updated successfully');
					    redirect(base_url().'account/purchase_bill', 'refresh');
                    }
				}else{
					
					if (!empty($data)){
						
					/*Product Details Inventory Process*/
						foreach($matrial_dtl as $for_increase_qty){
							$mat_idd = $for_increase_qty->product_details;
							$mat_qqty = $for_increase_qty->qty;
							$get_dataa = $this->account_model->get_matrial_qty_invoice('material',$mat_idd);
							$remaining_qty =  $get_dataa['closing_balance'] + $mat_qqty;
							$this->account_model->update_matrial_qty_invoice('material',$mat_idd,$remaining_qty);
						}
					/*Product Details Inventory Process*/
						
						$id = $this->account_model->insert_tbl_data('purchase_bill',$data); 
						
						
						/* Enable RCM code start*/
						
						$get_RCM_enable_or_not = getNameById('ledger',$_POST['supplier_name'],'id');
				
						$get_party_state = getNameById('ledger',$_POST['party_name'],'id');
						$supplier_state_id = json_decode($get_RCM_enable_or_not->mailing_address,true);
						$party_state_id = json_decode($get_party_state->mailing_address,true);
						
						if($get_RCM_enable_or_not->enble_disbl_rcm == 1){// if 1 its Enable RCM
						
							if($party_state_id[0]['mailing_state'] != $supplier_state_id[0]['mailing_state']){	
								  $Voucher_DAta ='[{"credit_debit_party_dtl":"'.$_POST['supplier_name'].'","credit_1":"'.$_POST['total'][0].'","debit_1":"","cr_dr":"credit"},{"credit_debit_party_dtl":"'.$_POST['party_name'].'","credit_1":"","debit_1":"'.$_POST['total'][0].'","cr_dr":"debit"},{"credit_debit_party_dtl":"1","credit_1":"","debit_1":"'.$IGST.'","cr_dr":"debit"},{"credit_debit_party_dtl":"4","credit_1":"'.$IGST.'","debit_1":"","cr_dr":"credit"}]';
										
										$IGST_urds_data['debit_dtl'] = '0';
										$IGST_urds_data['ledger_id'] = 4;
										$IGST_urds_data['credit_dtl'] = $IGST;
										$IGST_urds_data['type'] = 'purchase_bill';
										$IGST_urds_data['type_id'] = $id;
										$IGST_urds_data['add_date'] = $add_Date;
										$IGST_urds_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										$IGST_urds_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
										$this->account_model->insert_tbl_data('transaction_dtl',$IGST_urds_data); 
										
								}else{
								$Voucher_DAta ='[{"credit_debit_party_dtl":"'.$_POST['supplier_name'].'","credit_1":"'.$_POST['total'][0].'","debit_1":"","cr_dr":"credit"},{"credit_debit_party_dtl":"'.$_POST['party_name'].'","credit_1":"","debit_1":"'.$_POST['total'][0].'","cr_dr":"debit"},{"credit_debit_party_dtl":"2","credit_1":"","debit_1":"'.$CGST.'","cr_dr":"debit"},{"credit_debit_party_dtl":"3","credit_1":"","debit_1":"'.$SGST.'","cr_dr":"debit"},{"credit_debit_party_dtl":"5","credit_1":"'.$CGST.'","debit_1":"","cr_dr":"credit"},{"credit_debit_party_dtl":"6","credit_1":"'.$SGST.'","debit_1":"","cr_dr":"credit"}]';
								
								$CGST_URDS_data['debit_dtl'] = $CGST;
								$CGST_URDS_data['ledger_id'] = 5;
								$CGST_URDS_data['credit_dtl'] = '0';
								$CGST_URDS_data['type'] = 'voucher';
								$CGST_URDS_data['type_id'] = $id;
								$CGST_URDS_data['add_date'] = $add_Date;
								$CGST_URDS_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_URDS_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->insert_tbl_data('transaction_dtl',$CGST_URDS_data);
								
								$SGST_URDS_data['debit_dtl'] = $SGST;
								$SGST_URDS_data['ledger_id'] = 6;
								$SGST_URDS_data['credit_dtl'] = '0';
								$SGST_URDS_data['type'] = 'voucher';
								$SGST_URDS_data['type_id'] = $id;
								$SGST_URDS_data['add_date'] = $add_Date;
								$SGST_URDS_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_URDS_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->insert_tbl_data('transaction_dtl',$SGST_URDS_data);
							}				
							$voucher_tbl_Data['credit_debit_party_dtl'] = $Voucher_DAta;
							$voucher_tbl_Data['voucher_name'] = '18';
							$voucher_tbl_Data['voucher_date'] = $_POST['date'];
							$voucher_tbl_Data['total'] = $_POST['total'][0];
							$voucher_tbl_Data['purchase_id'] = $id;
							$voucher_tbl_Data['created_by'] = $_SESSION['loggedInUser']->c_id;
							$voucher_tbl_Data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
							//pre($voucher_tbl_Data);die();
						
						$this->account_model->insert_tbl_data('voucher',$voucher_tbl_Data);
							
					}
					/* Enable RCM code End*/
				
				
				
					 /* For Sale Ledger Details data*/
					$debit_data['debit_dtl'] = '0';
					$debit_data['ledger_id'] = $_POST['supplier_name'];
					$debit_data['credit_dtl'] = $_POST['total_amount'];
					$debit_data['type'] = 'purchase_bill';
					$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$debit_data['type_id'] = $id;
					$debit_data['add_date'] = $add_Date;
					$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
					/* For Sale Ledger Details data*/
					
					/* For Purchase Ledger Details data*/
					$credit_data['debit_dtl'] = $debit_amt;;
					$credit_data['ledger_id'] = $_POST['party_name'];
					//$credit_data['credit_dtl'] = $debit_amt;
					$credit_data['credit_dtl'] = '0';
					$credit_data['type'] = 'purchase_bill';
					$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$credit_data['type_id'] = $id;
					$credit_data['add_date'] = $add_Date;
					$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
					/* For Purchase Ledger Details data*/
					
					/* For CGST SGST IGST Table*/
							if($CGST !=''){
								$CGST_data['debit_dtl'] = $CGST;
								$CGST_data['ledger_id'] = '2';
								$CGST_data['credit_dtl'] = '0';
								$CGST_data['type'] = 'purchase_bill';
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$CGST_data['type_id'] = $id;
								$CGST_data['add_date'] = $add_Date;
								$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
								//$tax = array('CGST'=> $_POST['CGST']);
							}
							
							if($SGST != ''){
								$SGST_data['debit_dtl'] = $SGST;
								$SGST_data['ledger_id'] = '3';
								$SGST_data['credit_dtl'] = '0';
								$SGST_data['type'] = 'purchase_bill';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
								//$tax = array('SGST'=> $_POST['SGST']);
							}
							
							if($IGST != ''){
								$IGST_data['debit_dtl'] = $IGST;
								$IGST_data['ledger_id'] = '1';
								$IGST_data['credit_dtl'] = '0';
								$IGST_data['type'] = 'purchase_bill';
								$IGST_data['type_id'] = $id;
								$IGST_data['add_date'] = $add_Date;
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$IGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
							}
					/*INSERT Code For charges Ledgers and Discount Ledgers*/
					
					
					/*INSERT Code For charges Ledgers and Discount Ledgers*/
					$ddt =	json_decode($json_charg_lead_total_array, true);
				if($ddt[0]['particular_charges_name'] != ''){	
						$charges_Discount_data = json_decode($json_charg_lead_total_array,true);
						foreach($charges_Discount_data as $chrg_data){
							if(!empty($chrg_data)){
							if($chrg_data['type_charges'] == 'plus'){
								$charges_Data['debit_dtl'] = $chrg_data['charges_added'];
								$charges_Data['ledger_id'] = $chrg_data['ledger_name_id'];
								$charges_Data['credit_dtl'] = '0';
								$charges_Data['type'] = 'purchase_bill';
								$charges_Data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$charges_Data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$charges_Data['type_id'] = $id;
								$charges_Data['add_date'] = $add_Date;
								$this->account_model->update_single_data_for_charges($chrg_data['amt_with_tax'], $id,'purchase_bill');//USd to add Charges in Per invoice 
								$this->account_model->insert_tbl_data('transaction_dtl',$charges_Data);
							}else{
								$charges_Data['debit_dtl'] = '0';
								$charges_Data['ledger_id'] = $chrg_data['ledger_name_id'];
								$charges_Data['credit_dtl'] = $chrg_data['charges_added'];
								$charges_Data['type'] = 'purchase_bill';
								$charges_Data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$charges_Data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$charges_Data['type_id'] = $id;
								$charges_Data['add_date'] = $add_Date;
								$this->account_model->insert_tbl_data('transaction_dtl',$charges_Data);
							}
						}	
					}
				}	
					
					/*INSERT Code For charges Ledgers and Discount Ledgers*/
					
					
					
					
					/* For Purchase Details data*/
						if(!empty($_FILES['bill_attachment_files']['name']) && $_FILES['bill_attachment_files']['name'][0]!=''){
							
							$bills_array = array();
							$docCount = count($_FILES['bill_attachment_files']['name']);
							for($j = 0; $j < $docCount; $j++)
							{
									$filename = $_FILES['bill_attachment_files']['name'][$j];
									$tmpname  = $_FILES['bill_attachment_files']['tmp_name'][$j];               
									$type     = $_FILES['bill_attachment_files']['type'][$j];               
									$error    = $_FILES['bill_attachment_files']['error'][$j];
									$size     = $_FILES['bill_attachment_files']['size'][$j];
									$exp=explode('.', $filename);
									$ext=end($exp);
									$newname=  $exp[0].'_'.time().".".$ext; 
									$config['upload_path'] = 'assets/modules/account/uploads/';
									$config['upload_url'] =  base_url().'assets/modules/account/uploads/';
									$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
									$config['max_size'] = '2000000'; 
									$config['file_name'] = $newname;
									$this->load->library('upload', $config);
									
									move_uploaded_file($tmpname,"assets/modules/account/uploads/".$newname);
									
									$bills_array[$j]['rel_id'] = $id;
									$bills_array[$j]['rel_type'] = 'purchase bill';
									$bills_array[$j]['file_name'] = $newname;
									$bills_array[$j]['file_type'] = $type;
									
							}
							if(!empty($bills_array)){
						   /* Insert file information into the database */
							$docsAttachmentID = $this->account_model->insert_attachment_data('attachments', $bills_array,'account/purchase_bill/'.$id);
							}
							
						}
						
						
						
					}
					if ($id) {                        
                        logActivity('New Bill Detail Created','purchase_bill',$id);
                        $this->session->set_flashdata('message', 'New Bill Detail inserted successfully');
					     redirect(base_url().'account/purchase_bill', 'refresh');
                    }    				
				}
			}			
        }
	
  }
public function deletePurchase_bill_details($id = ''){	
		if (!$id) {
           redirect('account/purchase_bill', 'refresh');
        }
		permissions_redirect('is_delete');
		$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'purchase_bill');
		$this->account_model->delete_RCM_data('voucher','purchase_id', $id);
		
		$result = $this->account_model->delete_data('purchase_bill','id',$id);
		
		if($result){
			logActivity('Bill Detail Deleted','purchase_bill',$id);
			$this->session->set_flashdata('message', 'Bill Detail Deleted Successfully');
			$result = array('msg' => 'Bill Detail Deleted Successfully', 'status' => 'success', 'code' => 'C264','url' => base_url() . 'account/purchase_bill');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1080'));
        }
	}

public function add_suppliers_detials_on_the_spot(){
	  
		$supplier_name = $_REQUEST['name'];
		$mailing_address = $_REQUEST['mailing_address'];
		$gstin = $_REQUEST['gstin'];
		$country = $_REQUEST['country'];
		$state = $_REQUEST['state'];
		$city_id = $_REQUEST['city_id'];
		$acc_group_id = $_REQUEST['acc_group_id'];
		$created_by_cid  = $_SESSION['loggedInUser']->c_id;
		$created_by_id  = $_SESSION['loggedInUser']->u_id;
		
		$last_id = getLastTableId('supplier'); 
		$rId = $last_id + 1;
		$supCode = 'SUPP_'.rand(1, 1000000).'_'.$rId;
		
		$dd = $this->account_model->get_ledger_account_grp_Dtl('account_group',$created_by_cid,$_REQUEST['acc_group_id']); 
		
		$supplier_details = array(
					'supplier_code'=>$supCode,
					'name'=>$supplier_name,
					//'address'=>$address,
					'gstin'=>$gstin,
					'country'=>$country,
					'state'=>$state,
					'city'=>$city_id,
					'address'=>$mailing_address,
					'supp_account_group_id'=>$acc_group_id,
					'created_by_cid'=>$created_by_cid, 
					'created_by '=>$created_by_id 
				);
				
					
			//pre($supplier_details);die();		
					
					//$data_for_ledger['parent_group_id'] = $dd[0]['parent_group_id'];
		$data = $this->account_model->insert_on_spot_tbl_data('supplier',$supplier_details);
		
		$mailing_addressLength = count($_REQUEST['country']);
				if($mailing_addressLength >0){
					$arr = [];
					$i = 0;
					$idds = 1;
					while($i < $mailing_addressLength) {	
						$jsonArrayObject = (array('ID'=> $idds,'mailing_name'=>$supplier_name,'mailing_country' =>$country,'mailing_state' => $state,'mailing_city' => $city_id,'mailing_address'=>$mailing_address,'gstin_no'=>$gstin));
						$arr[$i] = $jsonArrayObject;
						$i++;
						$idds++;	
			
					}
					
					$descr_of_ldgr_array = json_encode($arr);
				}else{
					$descr_of_ldgr_array = '';
				}
		$supplier_details_ledger_tbl = array(
							'name'=>$supplier_name,
							'supp_id'=>$data,
							'gstin'=>$gstin,
							'account_group_id'=>$_REQUEST['acc_group_id'],
							'parent_group_id'=>$dd[0]['parent_group_id'],
							'created_by_cid'=>$created_by_cid, 
							'mailing_address'=>$descr_of_ldgr_array, 
							'created_by '=>$created_by_id 
						);
			$this->account_model->insert_on_spot_tbl_data('ledger',$supplier_details_ledger_tbl);
		
		if($data > 0){
			echo 'true';
		}else{
			echo 'false';
		}
		
	}




/*************************************************************************************************************************************************/	
/****************************************************** Ledger Report MODULE Start **************************************************************/	
/***********************************************************************************************************************************************/

public function ledger_report(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Ledger Report', base_url() . 'Ledger Report');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Ledger Report';
	$created_by_id  = $_SESSION['loggedInUser']->c_id;
	//$ladger_Rdata['get_Data']  = $this->account_model->get_invoice_details('ledger',array('created_by'=> $created_by_id)); 
	$merage_report_Data['get_Data']  = $this->account_model->get_data_with_zero_id_condtions('ledger',$created_by_id); 
	//$suppliers_data  = $this->account_model->get_invoice_details('supplier',array('created_by'=> $created_by_id)); 
	//$merage_report_Data['get_Data'] = array_merge($ladger_Rdata, $suppliers_data);  
	
	$this->_render_template('ladger_report/index', $merage_report_Data);
}
public function get_ledger_account_detials(){
	$created_by_id  = $_SESSION['loggedInUser']->u_id;
	$created_by_cid  = $_SESSION['loggedInUser']->c_id;
	$selected_ledger_id = $_REQUEST['ledger_party_id'];
	$data_type_transaction = $_REQUEST['data_type_transaction'];
	$login_user_id = $_SESSION['loggedInUser']->u_id;
	
	
		
		/* For Financial Year*/
			$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id);//Fetch Data to Company Table
			$date_fcal = json_decode($date_fun->financial_year_date,true);
			if(empty($date_fcal)){
				if (date('m') <= 4) {//Upto June 2014-2015
					$mydate = date(date('Y-04-01'));
					$lastyear = strtotime("-1 year", strtotime($mydate));
					$first_date = date("Y-m-d", $lastyear); 
					$date = date(date('Y-03-31'));
					$second_date = date('Y-m-d', strtotime("$date"));
				} else {//After June 2015-2016
					$mydate = date(date('Y-04-01'));
					$lastyear = strtotime("-1 year", strtotime($mydate));
					$first_date = date("Y-m-d", $lastyear);
					$date = date(date('Y-03-31'));
					$second_date = date('Y-m-d', strtotime("$date"));
				}
			}else{
				
				if (date('m') <= 4) {//Upto June 2014-2015
					$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
					$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
					$first_date = date(date($s_Date));
					$date = date(date($e_Date));
					$second_date = date('Y-m-d', strtotime("$date"));
				} else {//After June 2015-2016
					$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
					$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
					$first_date = date(date($s_Date));
					$date = date(date($e_Date));
					$second_date = date('Y-m-d', strtotime("$date"));
				}
			}
	/* For Financial Year*/
	
	if($_REQUEST['start'] =='' && $_REQUEST['end'] ==''){
	
			$selected_ledger_id = $_REQUEST['ledger_party_id'];
			$login_user_id = $_SESSION['loggedInUser']->u_id;
				$get_details = array(
					'ledger_id' => $selected_ledger_id,
					'created_by_cid' => $created_by_cid,
					'add_date >=' => $first_date,
					'add_date <=' => $second_date
				);
		}
	
		if($_REQUEST['start'] !='' && $_REQUEST['end'] !=''){
			
				$where = array(
					'ledger_id' => $_REQUEST['ledger_party_id'],
					'created_by' => $_REQUEST['login_user_id'],
					'created_by_cid' => $created_by_cid,
					'add_date >=' => $_REQUEST['start'],
					'add_date <=' => $_REQUEST['end']
				);
			
			}else{
				$where = array(
					'ledger_id' => $_REQUEST['ledger_party_id'],
					'created_by' => $_REQUEST['login_user_id'],
					'created_by_cid' => $created_by_cid,
					'add_date >=' => $_REQUEST['start'],
					'add_date <=' => $_REQUEST['end']
					
				);
			}


			$get_ledger_Data = $this->account_model->get_ladger_account_Data('ledger',array('id'=> $selected_ledger_id));

			
			
			if(empty($get_ledger_Data)){
				$data1['ledger_Data']  = $this->account_model->get_ladger_account_Data('ledger',array('supp_id'=> $selected_ledger_id));
			}else{
				$data1['ledger_Data']  = $this->account_model->get_ladger_account_Data('ledger',array('id'=> $selected_ledger_id)); 
					
			}
			if($_REQUEST['start'] !='' && $_REQUEST['end'] !=''){
				
				$data1['ledger_dtl']  = $this->account_model->get_ladger_account_Data2('transaction_dtl',$where);    
				$this->load->view('ladger_report/ledger_report', $data1);
			}else{
			
				$data1['ledger_dtl']  = $this->account_model->get_ladger_account_Data2('transaction_dtl',$get_details);
				$this->load->view('ladger_report/ledger_report', $data1);
			}
	}
	
	public function invoice_report(){
		if($this->input->post()){
			
			$invoice_idd = $this->input->post('id');
			$created_by_cid  = $_SESSION['loggedInUser']->c_id;
				$where = array(
					'type_id' => $invoice_idd,
					'type' => 'invoice',
					'created_by_cid' => $created_by_cid,
				);
			$this->data['invoice_dtl_report'] = $this->account_model->get_invoice_report_details('transaction_dtl',$where); 			
			$this->load->view('invoice/view_report', $this->data);
		}	
		
	}
	
	
	
	
	
	
	
	public function get_pdf_for_ledger_report($id = ''){
	    $selected_ledger_id =$this->uri->segment(3);
		$login_user_id = $_SESSION['loggedInUser']->u_id;
		
		$this->load->library('Pdf');
		if($_REQUEST['start'] =='' && $_REQUEST['end'] ==''){
			$get_details = array(
					'ledger_id' => $selected_ledger_id,
					'created_by' => $login_user_id,
					'created_by_cid' => $_SESSION['loggedInUser']->c_id
				);
		}else{
			$get_details = array(
					'ledger_id' => $selected_ledger_id,
					'created_by' => $login_user_id,
					'created_by_cid' => $_SESSION['loggedInUser']->c_id,
					'created_date >=' => $_REQUEST['start'],
					'created_date <=' => $_REQUEST['end']
				);
			
		}		
		$dataPdf['ledger_rpt_data']  = $this->account_model->get_ladger_account_Data2('transaction_dtl',$get_details);   
     	$this->load->view('ladger_report/ledger_report_pdf_genrate',$dataPdf);	//$this->_render_template('purchase_order/view_pdf', $this->data);
	}
	
//Get Ledger Account Details For Ledgers
public function get_ledger_account_onserach(){
	$text_box_val = $_REQUEST['text_box_val'];
	$login_user_id = $_REQUEST['login_user_id'];
	$get_serach_details = array(
		'created_by_cid' => $login_user_id
	);
	$data_serach1 = $this->account_model->get_ladger_account_search_Data('ledger',$get_serach_details,$text_box_val);
	//$data_serach2 = $this->account_model->get_ladger_account_search_Data('supplier',$get_serach_details,$text_box_val);
	//$merage_report_serach_Data = array_merge($data_serach1, $data_serach2);
	//pre($merage_report_serach_Data);die();
	echo json_encode($data_serach1);
	die;
	
}


/*************************************************************************************************************************************************/	
/*******************************************************Trial Balance MODULE Start **************************************************************/	
/************************************************************************************************************************************************/

public function trial_balance(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Trial Balance', base_url() . 'Trial Balance');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Trial Balance';
	$created_by_id  = $_SESSION['loggedInUser']->u_id;
	$company_id  = $_SESSION['loggedInUser']->c_id;
	/* For Financial Year*/
	$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id);//Fetch Data to Company Table
	$date_fcal = json_decode($date_fun->financial_year_date,true);
	if(empty($date_fcal)){
		if (date('m') <= 4) {//Upto June 2014-2015
		    $mydate = date(date('Y-04-01'));
			$lastyear = strtotime("-1 year", strtotime($mydate));
			$first_date = date("Y-m-d", $lastyear); 
			$date = date(date('Y-03-31'));
			$second_date = date('Y-m-d', strtotime("$date"));
		} else {//After June 2015-2016
		    $mydate = date(date('Y-04-01'));
			$lastyear = strtotime("-1 year", strtotime($mydate));
			$first_date = date("Y-m-d", $lastyear);
			$date = date(date('Y-03-31'));
			$second_date = date('Y-m-d', strtotime("$date"));
		}
	}else{
		
		if (date('m') <= 4) {//Upto June 2014-2015
		    $s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
			$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
			$first_date = date(date($s_Date));
			$date = date(date($e_Date));
			$second_date = date('Y-m-d', strtotime("$date"));
		} else {//After June 2015-2016
		    $s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
			$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
			$first_date = date(date($s_Date));
			$date = date(date($e_Date));
			$second_date = date('Y-m-d', strtotime("$date"));
		}
	}	
	/* For Financial Year*/
	
	if($_POST['selected_branch_idd'] == 'All'){
		$where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$this->_render_template('trial_balance/index', $ladger_Rdata);
	}
	
	
	
	if(isset($_POST['start'] ) && isset($_POST['end']) && $_POST['selected_branch_idd'] =='' && $_POST['create_excel'] ==''){
		
		$where = "(ledger.created_date >='".$_POST['start']."' AND  ledger.created_date <='".$_POST['end']."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
	    $this->_render_template('trial_balance/index', $ladger_Rdata);
	}elseif(isset($_POST['selected_branch_idd']) && $_POST['start']==''  && $_POST['end'] =='' && $_POST['On_selected_Branch_idd'] == '' &&$_POST['create_excel'] == '' ){
		
		$where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.compny_branch_id = '". $_POST['selected_branch_idd']  ."' AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$this->_render_template('trial_balance/index', $ladger_Rdata);
	}elseif(isset($_POST['create_excel']) && $_POST['On_selected_Branch_idd'] == '' && $_POST['start'] == '' && $_POST['end'] == ''){
	
		$where = "( ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$this->load->view('trial_balance/excel', $ladger_Rdata);	
	}elseif(isset($_POST['create_excel']) && isset($_POST['On_selected_Branch_idd']) && !isset($_POST['start'] ) && !isset($_POST['end'])){
		
		$where = "( ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."' AND ledger.compny_branch_id = '". $_POST['On_selected_Branch_idd']  ."'";
		$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$this->load->view('trial_balance/excel', $ladger_Rdata);
	}elseif($_POST['start']!= ''  && $_POST['end'] != '' && $_POST['selected_branch_idd'] != ''){
		
		$where = "(ledger.created_date >='".$_POST['start']."' AND  ledger.created_date <='".$_POST['end']."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."' AND ledger.compny_branch_id = '". $_POST['selected_branch_idd']  ."'";
		$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
	    $this->_render_template('trial_balance/index', $ladger_Rdata);
	}elseif($_POST['start']!= ''  && $_POST['end'] != '' && $_POST['On_selected_Branch_idd'] != '' && $_POST['create_excel'] != ''){
	
		$where = "(ledger.created_date >='".$_POST['start']."' AND  ledger.created_date <='".$_POST['end']."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."' AND ledger.compny_branch_id = '". $_POST['selected_branch_idd']  ."'";
		$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
	    $this->load->view('trial_balance/excel', $ladger_Rdata);
	}else{
		$where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		//$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($company_id,$first_date,$second_date);
		$this->_render_template('trial_balance/index', $ladger_Rdata);
	}	
}

public function get_ledger_balance_details(){ 
	$selected_ledger_id = $_REQUEST['ledger_id'];
	$login_user_id = $_REQUEST['login_user_id'];
	$get_details = array(
		'id' => $selected_ledger_id,
		'created_by' => $login_user_id
	);
	$data133 = $this->account_model->get_ladger_account_Data('ledger',$get_details);
	
	// $this->load->view('trial_balance/index', $data133);
	//echo json_encode($data133);
	die;
}

/***************************************************************************************************************************************/
/**************************************************** GSTR1 Start  *********************************************************************/
/***************************************************************************************************************************************/

public function Gstr_1(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('GSTR-1', base_url() . 'GSTR-1');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'GSTR-1';
	$created_by_id  = $_SESSION['loggedInUser']->c_id;
	$data['invoice_data']  = $this->account_model->get_data('invoice',array('created_by_cid'=> $created_by_id)); 
	$data['credit_debit_notes']  = $this->account_model->get_data('voucher',array('created_by_cid'=> $created_by_id)); 
	$data1 = GSTR1_helper();
	$data['GSTR1_data'] = $data1; 
	
	$this->_render_template('GSTR1/index', $data);
}

 public function gstr1_validations() { 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account', base_url() . 'validations');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Incomplete / Mismatch in Information (GSTR-1)';
		$created_id = $_SESSION['loggedInUser']->u_id;
		$created_c_id = $_SESSION['loggedInUser']->c_id;
		$this->data['get_outwards_sales']  = $this->account_model->get_data_for_GSTR1_validation('invoice',$created_c_id);
		$this->_render_template('GSTR1/gstr1_validation', $this->data);
    }

/**********************************************************************************************************************************/
/****************************************** GSTR3B Start  ***********************************************************************/
/***********************************************************************************************************************************/

public function Gstr_3b(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('GSTR-3B', base_url() . 'GSTR-3B');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'GSTR-3B';
	$created_by_id  = $_SESSION['loggedInUser']->c_id;
	$data['Sale_Data']  = $this->account_model->get_data('invoice',array('created_by_cid'=> $created_by_id)); 
	$data['Purchase_Data']  = $this->account_model->get_data('purchase_bill',array('created_by_cid'=> $created_by_id,'auto_entry'=>0)); 
	$data1 = GSTR3B_helper();
	$data['GSTR1_data'] = $data1;
	if(isset($_POST['create_excel'])){
		$this->load->view('GSTR3B/gstr3b_excel', $data);
		// pre($data);
	}else{
		$this->_render_template('GSTR3B/index', $data);
	}	
}



public function gstr3B_validations() { 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account', base_url() . 'validations');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Incomplete / Mismatch in Information (GSTR-3B)';
		$created_id = $_SESSION['loggedInUser']->u_id;
		$created_c_id = $_SESSION['loggedInUser']->c_id;
		$this->data['get_inwards_purchase']  = $this->account_model->get_data_for_GST3B_validation('purchase_bill',$created_c_id);
		$this->_render_template('GSTR3B/gstr3b_validations', $this->data);
    }

/*******************************************************************************************************************************************/
/****************************************************** GSTR3B End  ***********************************************************************/
/*****************************************************************************************************************************************/



/****************************************************************************************************************************/
/************************************************ Balance Sheet Start  ******************************************************/
/***************************************************************************************************************************/
public function balance_sheet(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Balance Sheet', base_url() . 'Balance Sheet');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Balance Sheet';
	$created_by_id  = $_SESSION['loggedInUser']->c_id;
	
	
	/* For Financial Year*/
	$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id);//Fetch Data to Company Table
	$date_fcal = json_decode($date_fun->financial_year_date,true);
	//pre($_POST['selected_branch_idd']);
	
	if(empty($date_fcal)){
		if (date('m') <= 4) {//Upto June 2014-2015
		    $mydate = date(date('Y-04-01'));
			$lastyear = strtotime("-1 year", strtotime($mydate));
			$first_date = date("Y-m-d", $lastyear); 
			$date = date(date('Y-03-31'));
			$second_date = date('Y-m-d', strtotime("$date"));
		} else {//After June 2015-2016
		    $mydate = date(date('Y-04-01'));
			$lastyear = strtotime("-1 year", strtotime($mydate));
			$first_date = date("Y-m-d", $lastyear);
			$date = date(date('Y-03-31'));
			$second_date = date('Y-m-d', strtotime("$date"));
		}
	}else{
		
		if (date('m') <= 4) {//Upto June 2014-2015
		    $s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
			$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
			$first_date = date(date($s_Date));
			$date = date(date($e_Date));
			$second_date = date('Y-m-d', strtotime("$date"));
		} else {//After June 2015-2016
		    $s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
			$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
			$first_date = date(date($s_Date));
			$date = date(date($e_Date));
			$second_date = date('Y-m-d', strtotime("$date"));
		}
	}	
	
	// if($_POST['selected_branch_idd'] == 'All'){
		// $where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		
		// $ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		
		// $this->_render_template('balance_sheet/index', $ladger_Rdata);
	// }
	
	if(isset($_POST['start']) && isset($_POST['end']) && $_POST['selected_branch_idd']=='' && $_POST['create_excel']==''  ){
		$start_Date = $_POST['start'];
		$end_Date = $_POST['end'];
		$where = "(ledger.created_date >='".$start_Date."' AND  ledger.created_date <='".$end_Date."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		$ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);	
	    $this->_render_template('balance_sheet/index', $ladger_Rdata);
	}elseif($_POST['selected_branch_idd'] != 'All' && $_POST['selected_branch_idd'] != '' && $_POST['create_excel'] == '' && $_POST['start']=='' && $_POST['end']=='' ){
	
		$where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.compny_branch_id = ". $_POST['selected_branch_idd']  ." AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		
		$ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		$this->_render_template('balance_sheet/index', $ladger_Rdata);
	}elseif(isset($_POST['create_excel']) && $_POST['On_selected_Branch_idd'] == '' && $_POST['start'] =='' &&  $_POST['end'] =='' ){
		$where = "( ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		$ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		$this->load->view('balance_sheet/balance_sheet_excel', $ladger_Rdata);
	}elseif(isset($_POST['create_excel']) && $_POST['On_selected_Branch_idd'] != '' && $_POST['start'] =='' &&  $_POST['end'] =='' ){
		$where = "( ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND  ledger.compny_branch_id = ". $_POST['On_selected_Branch_idd']  ."  AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		$ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		$this->load->view('balance_sheet/balance_sheet_excel', $ladger_Rdata);
	}elseif(isset($_POST['create_excel']) && $_POST['On_selected_Branch_idd'] != '' && $_POST['start'] !='' &&  $_POST['end'] !='' ){
		$where = "( ledger.created_date >='".$start_Date."' AND  ledger.created_date <='".$end_Date."') AND ledger.compny_branch_id = ". $_POST['On_selected_Branch_idd']  ."  AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		$ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		$this->load->view('balance_sheet/balance_sheet_excel', $ladger_Rdata);
	}else{
		//$ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($created_by_id,$first_date,$second_date); 
		$where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		$ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		$this->_render_template('balance_sheet/index', $ladger_Rdata);
	}
	
	
}
 


/**********************************************************************************************************/
/************************************************ Profit and Loss Start ***********************************/
/***********************************************************************************************************/
public function profit_and_loss(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Profit And Loss', base_url() . 'Profit And Loss');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Profit And Loss';
	$created_by_id  = $_SESSION['loggedInUser']->c_id;
	
	
	/* For Financial Year*/
	$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id);//Fetch Data to Company Table
	$date_fcal = json_decode($date_fun->financial_year_date,true);
	if(empty($date_fcal)){
		if (date('m') <= 4) {//Upto June 2014-2015
		    $mydate = date(date('Y-04-01'));
			$lastyear = strtotime("-1 year", strtotime($mydate));
			$first_date = date("Y-m-d", $lastyear); 
			$date = date(date('Y-03-31'));
			$second_date = date('Y-m-d', strtotime("$date"));
		} else {//After June 2015-2016
		    $mydate = date(date('Y-04-01'));
			$lastyear = strtotime("-1 year", strtotime($mydate));
			$first_date = date("Y-m-d", $lastyear);
			$date = date(date('Y-03-31'));
			$second_date = date('Y-m-d', strtotime("$date"));
		}
	}else{
		
		if (date('m') <= 4) {//Upto June 2014-2015
		    $s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
			$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
			$first_date = date(date($s_Date));
			$date = date(date($e_Date));
			$second_date = date('Y-m-d', strtotime("$date"));
		} else {//After June 2015-2016
		    $s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
			$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
			$first_date = date(date($s_Date));
			$date = date(date($e_Date));
			$second_date = date('Y-m-d', strtotime("$date"));
		}
	}	
	
	/* For Financial Year*/
	if($_POST['selected_branch_idd'] == 'All'){
		$where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		$this->_render_template('profitand_loss/index', $ladger_Rdata);
	}
	
	if(isset($_POST['start'] ) && isset($_POST['end']) && $_POST['selected_branch_idd'] == '' && $_POST['create_excel'] == ''){
		$start_Date = $_POST['start'];
		$end_Date = $_POST['end'];
		//$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_using_group_byid($created_by_id,$start_Date,$end_Date);
		$where = "(ledger.created_date >='".$start_Date."' AND  ledger.created_date <='".$end_Date."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$opening_Stock = "(inventory_flow.created_date <='".$first_date."') AND inventory_flow.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";//opening Stock
		$closing_Stock = "(inventory_flow.created_date <='".$second_date."') AND inventory_flow.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";//closing Stock
		$ladger_Rdata['opening_Stock']  = $this->account_model->getClosingBalance($opening_Stock); 
		$ladger_Rdata['closing_Stock']  = $this->account_model->getClosingBalance($closing_Stock); 
		$this->_render_template('profitand_loss/index', $ladger_Rdata);	
	}elseif(isset($_POST['selected_branch_idd']) && $_POST['start']=='' && $_POST['end']=='' && $_POST['create_excel'] == '' ){
		$where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.compny_branch_id = '". $_POST['selected_branch_idd']  ."' AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		$opening_Stock = "(inventory_flow.created_date <='".$first_date."') AND inventory_flow.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";//opening Stock
		$closing_Stock = "(inventory_flow.created_date <='".$second_date."') AND inventory_flow.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";//closing Stock

		$ladger_Rdata['opening_Stock']  = $this->account_model->getClosingBalance($opening_Stock); 
		$ladger_Rdata['closing_Stock']  = $this->account_model->getClosingBalance($closing_Stock); 
		$this->_render_template('profitand_loss/index', $ladger_Rdata);
	}elseif(isset($_POST['create_excel']) && $_POST['On_selected_Branch_idd']==''  && $_POST['start']=='' && $_POST['end']==''){
		$where = "( ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		
		$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$opening_Stock = "(inventory_flow.created_date <='".$first_date."') AND inventory_flow.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";//opening Stock
		
		$closing_Stock = "(inventory_flow.created_date <='".$second_date."') AND inventory_flow.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";//closing Stock

		$ladger_Rdata['opening_Stock']  = $this->account_model->getClosingBalance($opening_Stock); 
		$ladger_Rdata['closing_Stock']  = $this->account_model->getClosingBalance($closing_Stock); 
		
		$this->load->view('profitand_loss/profit_and_loss_excel', $ladger_Rdata);	
	}elseif(isset($_POST['create_excel']) && $_POST['On_selected_Branch_idd']!=''  && $_POST['start']=='' && $_POST['end']==''){
		$where = "( ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.compny_branch_id = '". $_POST['On_selected_Branch_idd']  ."' AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		
		$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$opening_Stock = "(inventory_flow.created_date <='".$first_date."') AND inventory_flow.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";//opening Stock
		
		$closing_Stock = "(inventory_flow.created_date <='".$second_date."') AND inventory_flow.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";//closing Stock

		$ladger_Rdata['opening_Stock']  = $this->account_model->getClosingBalance($opening_Stock); 
		$ladger_Rdata['closing_Stock']  = $this->account_model->getClosingBalance($closing_Stock); 
		
		$this->load->view('profitand_loss/profit_and_loss_excel', $ladger_Rdata);	
		
	}elseif(isset($_POST['create_excel']) && $_POST['On_selected_Branch_idd']!=''  && $_POST['start']!='' && $_POST['end']!=''){
		$where = "( ledger.created_date >='".$start_Date."' AND  ledger.created_date <='".$end_Date."') AND ledger.compny_branch_id = '". $_POST['On_selected_Branch_idd']  ."' AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		
		$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$opening_Stock = "(inventory_flow.created_date <='".$first_date."') AND inventory_flow.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";//opening Stock
		
		$closing_Stock = "(inventory_flow.created_date <='".$second_date."') AND inventory_flow.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";//closing Stock

		$ladger_Rdata['opening_Stock']  = $this->account_model->getClosingBalance($opening_Stock); 
		$ladger_Rdata['closing_Stock']  = $this->account_model->getClosingBalance($closing_Stock); 
		
		$this->load->view('profitand_loss/profit_and_loss_excel', $ladger_Rdata);	
		
	}else{
		$where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_using_group_byid($where); 
		//$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_using_group_byid($created_by_id,$first_date,$second_date);
		
	
		$opening_Stock = "(inventory_flow.created_date <='".$first_date."') AND inventory_flow.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";//opening Stock
		$closing_Stock = "(inventory_flow.created_date <='".$second_date."') AND inventory_flow.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";//closing Stock

		
		$ladger_Rdata['opening_Stock']  = $this->account_model->getClosingBalance($opening_Stock); 
		$ladger_Rdata['closing_Stock']  = $this->account_model->getClosingBalance($closing_Stock); 
		$this->_render_template('profitand_loss/index', $ladger_Rdata);
	}
}

/*******************************************************************************************************************************/
/*************************************************** Profit and Loss End  *****************************************************/
/******************************************************************************************************************************/

	public function Get_Ledgers_according_toParent(){
		$created_id = $_SESSION['loggedInUser']->u_id;
		$dded = $this->account_model->get_data_new('account_group',$created_id);
		$paret_idd = [];
				foreach($dded as $get_data){
				  $paret_idd[] = $get_data['parent_group_id'];
				}
				$data_parent =  implode(", ", $paret_idd);
				$dded_check = $this->account_model->get_data_Accrding_toparent_id($data_parent,$created_id);
				echo json_encode($dded_check);
			}
/***************************************************************************************************************************/
/*********************************Get connected Company controller START HERE for drop Down*********************************/
/***************************************************************************************************************************/	
		public function Get_connected_company_ctrller(){
			$company_id = $_REQUEST['login_company_id'];
			$data_get = $this->account_model->get_connected_company_data('connection',array('requested_by' => $_SESSION['loggedInUser']->c_id,'requested_to' => $_SESSION['loggedInUser']->c_id));
			$data_get = connectedCompany();
			echo json_encode($data_get);
			//pre($data);
			
		}     			
	public function accept_reject_invoice(){
		$accept_reject_invoice_id = $_REQUEST['invoice_idd'];
		@$reject_invoice_msg = $_REQUEST['reject_invoice'];
		$accept_reject = $_REQUEST['accept_reject'];//0 for accept and 1 for Reject
		if($accept_reject == '1'){
			$update_data = array(
						'accept_reject' => 1,
						'reject_invoice' => $reject_invoice_msg,
						);
		
		$accept_reject_Data = $this->account_model->accept_reject_invoice_modl('invoice',array('id'=>$accept_reject_invoice_id),$update_data);				
		}
		if($accept_reject == '0'){
			$update_data = array(
						'accept_reject' => 0,
						);
		$accept_reject_Data = $this->account_model->accept_reject_invoice_modl('invoice',array('id'=>$accept_reject_invoice_id),$update_data);
			
		}
		
		if($accept_reject_Data > 0){
			echo 'true';
		}else{
			echo 'false';
		}
	}
		
/***************************************************************************************************************************************/
				/************************************************Bank Reconciliation**************************************************/
/*************************************************************************************************************************************/
	Public function bank_reconciliation(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Bank Reconciliation', base_url() . 'Bank Reconciliation');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Bank Reconciliation';
		$created_by_id  = $_SESSION['loggedInUser']->u_id;
		$ladger_Rdata['bank_reconciliation_data']  = $this->account_model->Get_profit_and_loss_data($created_by_id); 
		$this->_render_template('bank_reconciliation/index', $ladger_Rdata);
}

/*****************************************************************************************************************************************/
				/********************************************Sale Register AND other**************************************************/
/*************************************************************************************************************************************/
Public Function sale_register(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Sale Register', base_url() . 'Sale Register');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Sale Register';
	$created_by_id  = $_SESSION['loggedInUser']->u_id;
	
 if($_POST['selected_branch_idd'] == 'All'){
		redirect(base_url().'account/sale_register', 'refresh');
	}
	
	if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
		 $where = array('invoice.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
			$ladger_Rdata['saleReg_Data']  = $this->account_model->Get_get_Sale_register('invoice',$where); 
			$this->_render_template('saleregister/index', $ladger_Rdata);
	}elseif(!empty($_POST['start']) && !empty($_POST['end']) && !isset($_POST['selected_branch_idd'])){
			$where = array('invoice.created_date >=' => $_POST['start'] , 'invoice.created_date <=' => $_POST['end'],'invoice.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
			$this->data['saleReg_Data']  = $this->account_model->Get_get_Sale_register('invoice',$where);
			$this->load->view('saleregister/index', $this->data);
		}elseif(isset($_POST['selected_branch_idd'])){
				$where2 = array('invoice.sale_lger_brnch_id =' => $_POST['selected_branch_idd'], 'invoice.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
				$ladger_Rdata['saleReg_Data']  = $this->account_model->Get_get_Sale_register('invoice',$where2);
				$this->_render_template('saleregister/index', $ladger_Rdata);
		}elseif(!empty($_POST['start']) && !empty($_POST['end']) && isset($_POST['selected_branch_idd'])){
			echo 'ttth';die();
			$where = array('invoice.created_date >=' => $_POST['start'] , 'invoice.created_date <=' => $_POST['end'],'invoice.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
			$this->data['saleReg_Data']  = $this->account_model->Get_get_Sale_register('invoice',$where);
			$this->load->view('saleregister/index', $this->data);
		}else{
			$where = array('invoice.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
		    $this->data['saleReg_Data']  = $this->account_model->Get_get_Sale_register('invoice',$where);
			$this->_render_template('saleregister/index', $this->data);
		}

}


Public Function prchase_register(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Purchase Register', base_url() . 'Purchase Register');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Purchase Register';
	$created_by_id  = $_SESSION['loggedInUser']->c_id;
	// $pur_Rdata['purchaseReg_Data']  = $this->account_model->Get_get_Sale_register('purchase_bill',$created_by_id); 
	// $this->_render_template('purchaseregister/index', $pur_Rdata);
	
	if($_POST['selected_branch_idd'] == 'All'){
		redirect(base_url().'account/sale_register', 'refresh');
	}
	
	if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
		$where = array('purchase_bill.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'auto_entry'=>0);
		$pur_Rdata['purchaseReg_Data']  = $this->account_model->Get_get_Sale_register('purchase_bill',$where); 
		$this->_render_template('purchaseregister/index', $pur_Rdata);
	}
	if(!empty($_POST['start']) && !empty($_POST['end'])){
		$where = array('purchase_bill.created_date >=' => $_POST['start'] , 'purchase_bill.created_date <=' => $_POST['end'],'purchase_bill.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'auto_entry'=>0);
		$this->data['purchaseReg_Data']  = $this->account_model->Get_get_Sale_register('purchase_bill',$where);
		$this->load->view('purchaseregister/index', $this->data);
	}elseif(isset($_POST['selected_branch_idd'])){
		
		
			$where2 = array('purchase_bill.sale_company_state_id =' => $_POST['selected_branch_idd'], 'purchase_bill.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
			$this->data['purchaseReg_Data']  = $this->account_model->Get_get_Sale_register('purchase_bill',$where2);
			$this->_render_template('purchaseregister/index', $this->data);
	}else{
	    $where = array('purchase_bill.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'auto_entry'=>0);
		$this->data['purchaseReg_Data']  = $this->account_model->Get_get_Sale_register('purchase_bill',$where);
		$this->_render_template('purchaseregister/index', $this->data);
	}   
}


Public Function account_payable(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Account Payable', base_url() . 'Account Payable');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Account Payable';
	$created_by_id  = $_SESSION['loggedInUser']->u_id;
	//$payabledata['payable_Data']  = $this->account_model->get_supplier_Dtl('supplier',$created_by_id,'3'); 
	//$this->_render_template('accountpayable/index', $payabledata);

	if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
		$where = array('ledger.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'ledger.parent_group_id'=>'3');
		$this->data['payable_Data']  = $this->account_model->get_supplier_Dtl('ledger',$where); 
		$this->_render_template('accountpayable/index', $this->data);
	}
	
	if(!empty($_POST)){
		//pre($_POST);die();
		$where = array('ledger.created_date >=' => $_POST['start'] , 'ledger.created_date <=' => $_POST['end'],'ledger.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'ledger.parent_group_id'=>'3');
		$this->data['payable_Data']  = $this->account_model->get_supplier_Dtl('ledger',$where);
		$this->load->view('accountpayable/index', $this->data);
	}else{
	    $where = array('ledger.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'ledger.parent_group_id'=>'3');
		$this->data['payable_Data']  = $this->account_model->get_supplier_Dtl('ledger',$where);
		$this->_render_template('accountpayable/index', $this->data);
	}
	
	
	
	
}

Public Function account_recivable(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Account Receivable', base_url() . 'Account Receivable');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Account Receivable';
	$created_by_id  = $_SESSION['loggedInUser']->c_id;
	
	
	if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
		$where = array('ledger.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'ledger.parent_group_id'=>'6');
		$this->data['reciva_data']  = $this->account_model->get_ledger_Dtl('ledger',$where); 
		$this->_render_template('accountreciveable/index', $this->data);
	}
	
	if(!empty($_POST)){
		
		$suppidd != 0; 
		$where = array('ledger.created_date >=' => $_POST['start'] , 'ledger.created_date <=' => $_POST['end'],'ledger.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'ledger.parent_group_id'=>'6');
		$this->data['reciva_data']  = $this->account_model->get_ledger_Dtl('ledger',$where);
		$this->load->view('accountreciveable/index', $this->data);
	}else{
	    $where = array('ledger.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'ledger.parent_group_id'=>'6');
		
		$this->data['reciva_data']  = $this->account_model->get_ledger_Dtl('ledger',$where); 
		$this->_render_template('accountreciveable/index', $this->data);
	}	
	
}

/********************************************************************************************************************************************/  
	/************************************************************Import Data**************************************************/
/*******************************************************************************************************************************************/
	public function import_view(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Import Data', base_url() . 'Import Data');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Import Data';
    
		$this->load->library('excel');

  if ($_FILES) {
	 
			$created_by_id  = $_SESSION['loggedInUser']->c_id;
			$path = 'assets/modules/import/uploads/';
			$this->load->library('excel');
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config); 
		
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
			
            if(empty($error)){
              if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
				
	
				
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				
				
                $flag = true;
                $i=0;
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
						$worksheetTitle     = $worksheet->getTitle();
						$highestRow         = $worksheet->getHighestRow(); // e.g. 10
						$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
						$headings = $worksheet->rangeToArray('A1:' . $highestColumn . 1,NULL,TRUE,FALSE);
					}

				for ($row = 2; $row <= $highestRow; $row++){ 
						$rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
							$rowData[0] = array_combine($headings[0], $rowData[0]);
							
							
					
							$EXCEL_DATE  = $rowData[0]['Ledger.`$CreatedDate`'];
							$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
	
							$created_Date = date('Y-m-d H:m:i', (int) $UNIX_DATE);
							
							// if($flag){
								 // $flag =false;
								 // continue;
							// }
     					  $inserdata[$i]['id'] = $rowData[0]['id'];
     					  $inserdata[$i]['name'] = $rowData[0]['name'] ? $rowData[0]['name']:'';
						  $inserdata[$i]['account_group_id'] = $rowData[0]['account_group_id'] ? $rowData[0]['account_group_id']:'';
						  
						 
						  $inserdata[$i]['parent_group_id'] = $rowData[0]['parent_group_id'] ? $rowData[0]['parent_group_id']:'';
						  $inserdata[$i]['compny_branch_id'] = $rowData[0]['compny_branch_id'] ? $rowData[0]['compny_branch_id']:'';
						  $inserdata[$i]['opening_balance'] = $rowData[0]['opening_balance']  ? $rowData[0]['opening_balance']:'';
						  $inserdata[$i]['openingbalc_cr_dr'] = $rowData[0]['openingbalc_cr_dr']  ? $rowData[0]['openingbalc_cr_dr']:'';
						  $inserdata[$i]['enble_disbl_rcm'] = $rowData[0]['enble_disbl_rcm']  ? $rowData[0]['enble_disbl_rcm']:'';
						  $inserdata[$i]['mailing_address'] = $rowData[0]['mailing_address']  ? $rowData[0]['mailing_address']:'';
						  $inserdata[$i]['gstin'] = $rowData[0]['gstin'];
						 // $inserdata[$i]['created_date'] = $created_Date;
						  $inserdata[$i]['created_by'] = $created_by_id;
						  $inserdata[$i]['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						  $i++;
                } 
				//pre($inserdata);die('Ledgers');
				$result = $this->account_model->importdata('ledger',$inserdata);   
                if($result){
                  //echo "Imported successfully";
				   $this->session->set_flashdata('message', 'Imported successfully');
                }else{
                //  echo "ERROR !";
				 $this->session->set_flashdata('message', 'ERROR !');
                }             

          } catch (Exception $e) {
              $this->session->set_flashdata('message', 'This Type File Not allowed for upload');
				redirect('account/import_view', 'refresh');	
            }
          }else{
             $this->session->set_flashdata('message', $error['error']);
			  redirect('account/import_view', 'refresh');	
            }
            
            
    }
	//$this->load->view('import_ledger/index',$this->data);
	$this->_render_template('import/index');
  }
  public function import_invoices(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Import Data', base_url() . 'Import Data');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Import Data';
		
		 $this->load->library('excel');
		

	if ($_FILES) {
			$created_by_id  = $_SESSION['loggedInUser']->c_id;
			
			$path = 'assets/modules/import/uploads/';
			$this->load->library('excel');
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls';
            $config['remove_spaces'] = TRUE;
	
            $this->load->library('upload', $config);
            $this->upload->initialize($config);            
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if(empty($error)){
              if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
          $inputFileName = $path . $import_xls_file;
         
		  
            
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
				
	            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				
				//$ledgers_details = $this->account_model->get_data_with_zero_id_condtions('ledger',$created_by_id);
				
				
				
                $flag = true;
                $i=0;
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
						$worksheetTitle     = $worksheet->getTitle();
						$highestRow         = $worksheet->getHighestRow(); // e.g. 10
						$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
						$headings = $worksheet->rangeToArray('A1:' . $highestColumn . 1,NULL,TRUE,FALSE);
					}
		
				for ($row = 2; $row <= $highestRow; $row++){ 
						$rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
						$rowData[0] = array_combine($headings[0], $rowData[0]);
						
						
						
						//Create JSON material and Tax Details
						$descr_of_goodsLength = count($rowData[0]['material_id']);
							if($descr_of_goodsLength >0){
								$arr = [];
								$arra = [];
								$j = 0;
								while($j < $descr_of_goodsLength) {	
									$jsonArrayObject = (array('material_id' =>$rowData[0]['material_id'],'descr_of_goods' => $rowData[0]['descr_of_goods'],'hsnsac' => $rowData[0]['hsnsac'], 'quantity' => $rowData[0]['quantity'], 'rate' => $rowData[0]['rate'], 'tax' => $rowData[0]['tax'],'added_tax_Row_val'=> $rowData[0]['added_tax_Row_val'],'UOM' => $rowData[0]['UOM'],'amount'=>$rowData[0]['amount'],'disctype'=>$rowData[0]['disctype'],'discamt'=>$rowData[0]['discamt'],'after_desc_amt'=>$rowData[0]['after_desc_amt'],'amount_with_tax_after_disco'=>$rowData[0]['amount'],'item_code'=>$rowData[0]['item_code'],'cess'=>$rowData[0]['cess'],'valuation_type'=>$rowData[0]['valuation_type'],'cess_tax_calculation'=>$rowData[0]['cess_tax_calculation']));
									$arr[$j] = $jsonArrayObject;
									
									
									$jsonArrayObject1 = array('total' =>$rowData[0]['total_amount'],'totaltax' => $rowData[0]['totaltax_total'],'invoice_total_with_tax' => $rowData[0]['invoice_total_with_tax'],'cess_all_total' => $rowData[0]['cess_all_total']);
									$arra[$j] = $jsonArrayObject1;
								
									$j++;				
								}
								$descr_of_goods_array = json_encode($arr);
								$invoice_price_total_array = json_encode($arra);
							}else{
								$descr_of_goods_array = '';
								$invoice_price_total_array = '';
							}
							//Create JSON material and Tax Details
							
							//Create changes JSON If have
							$Added_changrges_Details = count($rowData[0]['charges_added']);
							if($Added_changrges_Details > 0){
								$charg_Add = [];
								$ch = 0;
								while($ch < $Added_changrges_Details){
									$jsonarray_chargeobj = (array('particular_charges_name'=>$rowData[0]['particular_charges_name'],'type_charges'=>$rowData[0]['type_charges'],'ledger_name'=>$rowData[0]['ledger_name'],'ledger_name_id'=>$rowData[0]['ledger_name_id'],'amt_tax'=>$rowData[0]['amt_tax'],'charges_added'=>$rowData[0]['charges_added'],'sgst_amt'=>$rowData[0]['sgst_amt'],'cgst_amt'=>$rowData[0]['cgst_amt'],'igst_amt'=>$rowData[0]['igst_amt'],'amt_with_tax'=>$rowData[0]['amt_with_tax']));
									$charg_Add[$ch] = $jsonarray_chargeobj;
									$ch++;
								}
								$json_charg_lead_total_array = json_encode($charg_Add);
							}else{
								$json_charg_lead_total_array = '';
							}
							//Create changes JSON If have	
							
							
						//pre($descr_of_goods_array);
							
						//$matchArray = array();
						// $j=0;
						if($rowData[0]['CGST'] == ''){
							$cgst = '0';
						}else{
							$cgst = $rowData[0]['CGST'];
						}
						if($rowData[0]['SGST'] == ''){
							$sgst = '0';
						}else{
							$sgst = $rowData[0]['SGST'];
						}
						if($rowData[0]['IGST'] == ''){
							$igst = '0';
						}else{
							$igst = $rowData[0]['IGST'];
						}
						if($rowData[0]['eway_bill_no'] == ''){
							$eway_bill_no = '0';
						}else{
							$eway_bill_no = $rowData[0]['IGST'];
						}
						if($rowData[0]['invoice_type'] == ''){
							$invoice_type = '0';
						}else{
							$invoice_type = $rowData[0]['invoice_type'];
						}
						
						
						
							$EXCEL_DATE  = $rowData[0]['date_time_of_invoice_issue'];
							$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
							$date_time_of_invoice_issue = date('d-m-Y', (int) $UNIX_DATE);
							
							$EXCEL_DATE2  = $rowData[0]['date_time_removel_of_goods'];
							$UNIX_DATE2 = ($EXCEL_DATE2 - 25569) * 86400;
							$date_time_removel_of_goods = date('d-m-Y', (int) $UNIX_DATE2);
							
							$EXCEL_DATE3  = $rowData[0]['date_time_removel_of_goods'];
							$UNIX_DATE3 = ($EXCEL_DATE3 - 25569) * 86400;
							$gr_date22 = date('d-m-Y', (int) $UNIX_DATE3);
							if($gr_date == ''){
								$gr_date = '';
							}else{
								$gr_date = $gr_date22;
							}
							
							
							$inserdata[$i]['created_date'] = date('Y/m/d H:i:s');
							$inserdata[$i]['buyer_order_no'] = $rowData[0]['buyer_order_no'];					  
							$inserdata[$i]['party_name'] = $rowData[0]['party_name'];					  
							$inserdata[$i]['sale_ledger'] = $rowData[0]['sale_ledger'];					  
							$inserdata[$i]['eway_bill_no'] = $eway_bill_no;					  
							$inserdata[$i]['email'] = $rowData[0]['email'];					  
							$inserdata[$i]['gr_date'] = $gr_date;					  
							$inserdata[$i]['party_phone'] = $rowData[0]['party_phone'];					  
							$inserdata[$i]['invoice_type'] = $invoice_type;					  
							$inserdata[$i]['invoice_num'] = $rowData[0]['invoice_num'];				  
							$inserdata[$i]['vehicle_reg_no'] = $rowData[0]['vehicle_reg_no'];					  
							$inserdata[$i]['pan'] = $rowData[0]['pan'];					  
							$inserdata[$i]['gstin'] = $rowData[0]['gstin'];					  
							$inserdata[$i]['transport_driver_pno'] = $rowData[0]['transport_driver_pno'];					  
							$inserdata[$i]['date_time_of_invoice_issue'] = $date_time_of_invoice_issue;					  
							$inserdata[$i]['date_time_removel_of_goods'] = $date_time_removel_of_goods;					  
							$inserdata[$i]['CGST'] = $cgst;					  
							$inserdata[$i]['SGST'] = $sgst;					  
							$inserdata[$i]['IGST'] = $igst;					  
							$inserdata[$i]['charges_total_tax'] = $rowData[0]['charges_total_tax'];	
							$inserdata[$i]['descr_of_goods'] = $descr_of_goods_array;		
							$inserdata[$i]['invoice_total_with_tax'] = $invoice_price_total_array;		
							$inserdata[$i]['charges_added'] = $json_charg_lead_total_array;		
							$inserdata[$i]['total_amount'] = $rowData[0]['total_amount'];		
							$inserdata[$i]['totaltax_total'] = $rowData[0]['totaltax_total'];		
							$inserdata[$i]['party_state_id'] = $rowData[0]['party_state_id'];		
							$inserdata[$i]['pay_or_not'] = $rowData[0]['pay_or_not'];		
							// $inserdata[$i]['material_id'] = $rowData[0]['material_id'];					  
							// $inserdata[$i]['descr_of_goods'] = $rowData[0]['descr_of_goods'];					  
							// $inserdata[$i]['hsnsac'] = $rowData[0]['hsnsac'];					  
							// $inserdata[$i]['quantity'] = $rowData[0]['quantity'];					  
							// $inserdata[$i]['rate'] = $rowData[0]['rate'];					  
							// $inserdata[$i]['tax'] = $rowData[0]['tax'];					  
							// $inserdata[$i]['UOM'] = $rowData[0]['UOM'];					  
							// $inserdata[$i]['amount'] = $rowData[0]['amount'];					  
							// $inserdata[$i]['disctype'] = $rowData[0]['disctype'];					  
							// $inserdata[$i]['discamt'] = $rowData[0]['discamt'];					  
							// $inserdata[$i]['after_desc_amt'] = $rowData[0]['after_desc_amt'];					  
							// $inserdata[$i]['amount_with_tax_after_disco'] = $rowData[0]['amount_with_tax_after_disco'];					  
						    $inserdata[$i]['created_by_cid'] = $created_by_id;
						    $inserdata[$i]['created_by'] = $_SESSION['loggedInUser']->u_id;
						  $i++;
               
			}
			 pre($inserdata);
		die('There');
			// redirect('account/invoices', 'refresh');	
			// die();
		
			
				$result = $this->account_model->importdata('invoice',$inserdata);   
                if($result){
                // unlink($for_delete_well);
				 $this->session->set_flashdata('message', 'Imported successfully');
				 redirect('account/invoices', 'refresh');	
                }else{
                 // echo "ERROR !";
				 $this->session->set_flashdata('message', 'ERROR !');
				 redirect('account/invoices', 'refresh');	
                }             

          }
		  catch (Exception $e) {
			
               //die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                       // . '": ' .$e->getMessage());
				$this->session->set_flashdata('message', 'This Type File Not allowed for upload');
				redirect('account/invoices', 'refresh');	
            }
          }else{
			  //echo $error['error'];
			  $this->session->set_flashdata('message', $error['error']);
			  redirect('account/invoices', 'refresh');	
			}
    }
	$this->_render_template('import/index');
  }
  
/*Function to Import invoices*/	
	function Create_invoice_blankxls(){
	$fileName = 'Blank_invoice'.time().'.xls'; 
	$this->load->library('excel');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
		
	
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'party_name');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'sale_ledger');
	$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'eway_bill_no');
	$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'email');
	$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'gr_date');       
	$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'party_phone');       
	$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'buyer_order_no');       
	$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'invoice_type');       
	$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'vehicle_reg_no');       
	$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'pan');       
	$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'gstin');       
	$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'transport_driver_pno'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'date_time_of_invoice_issue'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'date_time_removel_of_goods'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'CGST'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'SGST'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'IGST'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'charges_total_tax'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'invoice_num'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'material_id'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'descr_of_goods'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'hsnsac'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'quantity'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('X1', 'rate'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'tax'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'UOM'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'amount'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'disctype'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'discamt'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'after_desc_amt'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'amount_with_tax_after_disco');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'item_code');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'cess');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'valuation_type');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'cess_tax_calculation');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'total_amount');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'totaltax_total');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'cess_all_total');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'party_state_id');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'mode_of_payment');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AO1', 'pay_or_not');  //0 for not Paid and 1 for Paid
	$objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'particular_charges_name');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'type_charges');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AR1', 'ledger_name');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AS1', 'ledger_name_id');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AT1', 'amt_tax');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AU1', 'charges_added');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AV1', 'sgst_amt');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AW1', 'cgst_amt');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AX1', 'igst_amt');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AY1', 'amt_with_tax');  
	
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$fileName.'"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
         redirect(site_url().$fileName);
		 redirect(base_url().'account/invoices', 'refresh');
	
}	  
/*Function to Import invoices*/
function Create_ledgers_blankxls(){
	
	$fileName = 'Blank_ledger'.time().'.xls'; 
	$this->load->library('excel');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
		
	
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'name');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'account_group_id');
	$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'parent_group_id');
	$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'conn_comp_id');
	$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'compny_branch_id');       
	$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'opening_balance');       
	$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'openingbalc_cr_dr');       
	$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'enble_disbl_rcm');       
	$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'mailing_address');       
	$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'contact_person');       
	$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'phone_no');       
	$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'mobile_no'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'email'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'date_time_removel_of_goods'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'registration_type'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'gstin'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'pan'); 
	
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$fileName.'"');
	header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
         redirect(site_url().$fileName);
		 redirect(base_url().'account/invoices', 'refresh');
	
}

  public function import_sale_ledgers(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Import Data', base_url() . 'Import Data');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Import Data';
    
		$this->load->library('excel');

  if ($_FILES) {
	 
			$created_by_id  = $_SESSION['loggedInUser']->u_id;
			$path = 'assets/modules/import/uploads/';
			$this->load->library('excel');
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config); 
		
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
			
            if(empty($error)){
              if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            
            try {
                $inputFileType = PHPExcel_IOFa<tory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
				
	
				
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				
				
				
                $flag = true;
                $i=0;
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
						$worksheetTitle     = $worksheet->getTitle();
						$highestRow         = $worksheet->getHighestRow(); // e.g. 10
						$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
						$headings = $worksheet->rangeToArray('A1:' . $highestColumn . 1,NULL,TRUE,FALSE);
					}

				for ($row = 2; $row <= $highestRow; $row++){ 
						$rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
						$rowData[0] = array_combine($headings[0], $rowData[0]);
						
						
						foreach($rowData as $dd){
							$result = array_merge($dd,$rowData[0]);
							// if($rowData[0]['Vch Type'] == ){
								
							 // pre($rowData[0]['Vch Type']);
								
							// }
							
							pre(array($result));
							
							
						}
						
							
							 
							
							// $EXCEL_DATE  = $rowData[0]['Ledger.`$CreatedDate`'];
							// $UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
	
							// $created_Date = date('Y-m-d H:m:i', (int) $UNIX_DATE);
							
							
     					  // $inserdata[$i]['name'] = $rowData[0]['Ledger.`$Name`'];
						  // $inserdata[$i]['email'] = $rowData[0]['Ledger.`$EMail`'];
						  
						  // $inserdata[$i]['created_date'] = $created_Date;
						  // $inserdata[$i]['mailing_country'] = $rowData[0]['Ledger.`$CountryName`'];
						  // $inserdata[$i]['gstin'] = $rowData[0]['Ledger.`$PartyGSTIN`'];
						  // $inserdata[$i]['created_by'] = $created_by_id;
						  $i++;
                } 
				die();
				//pre($inserdata);die('Ledgers');
				$result = $this->account_model->importdata('ledger',$inserdata);   
                if($result){
                  //echo "Imported successfully";
				   $this->session->set_flashdata('message', 'Imported successfully');
                }else{
                //  echo "ERROR !";
				 $this->session->set_flashdata('message', 'ERROR !');
                }             

          } catch (Exception $e) {
              $this->session->set_flashdata('message', 'This Type File Not allowed for upload');
				redirect('account/import_view', 'refresh');	
            }
          }else{
             $this->session->set_flashdata('message', $error['error']);
			  redirect('account/import_view', 'refresh');	
            }
            
            
    }
	//$this->load->view('import_ledger/index',$this->data);
	$this->_render_template('import/index');
  }
  
/*********************************************************************************************************************************/
  /****************************************Integration Inventery and account*************************************************************/
/**********************************************************************************************************************************/
		public function get_closing_matrila_qty(){
			$matrial_id = $_REQUEST['matral_idds'];
			$ddf = $this->account_model->get_matrial_qty_invoice('material',$matrial_id);
			echo $ddf['closing_balance'];
			// pre($ddf);            
		}
		

/******************************************************************************************************************************************/
  /***********************************************Create GSTR1 CSV Functions*************************************************************/
/**********************************************************************************************************************************/

 public function createXLS_GSTR1() {
			// create file name
			$fileName = 'ERP_GSTR1_'.time().'.xls'; 
			$created_id = $_SESSION['loggedInUser']->c_id;		
			// load excel library
			
			$this->load->library('excel');
			$gst_Datas = $this->account_model->get_data_for_xls_import($created_id);
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'GSTIN/UIN of Recipient');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Invoice Number');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Invoice Date');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Invoice Value');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Place Of Supply');       
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Reverse Charge');       
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Applicable % of Tax Rate');       
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Invoice Type');       
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'E-Commerce GSTIN');       
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Rate');       
			$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Taxable Value');       
			$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Cess Amount');       
			// set Row
			if(!empty($gst_Datas)){
			$rowCount = 2;
			foreach ($gst_Datas as $element) {
				
			
				$descr_goods = json_decode($element['descr_of_goods'],true);
		    	//$sale_ledger_data  = getNameById('ledger',$element['sale_ledger'],'id');
				$party_dtail  = getNameById('ledger',$element['party_name'],'id');
				
				$party_city_name  = getNameById('city',$party_dtail->mailing_city,'city_id')->city_name;
				
				$invoice_date = date("d-M-y", strtotime($element['created_date']));
					if($element['invoice_type'] == ''){
						  $invoice_type = 'Regular';
					}else{
						$invoice_type = $element['invoice_type'];
					}
				// if($party_dtail->gstin != ''){
				// $gstin_no =  $party_dtail->gstin;
					// }else{
						// $gstin_no =   '';
					// }
				$Taxable_value = $descr_goods[0]['quantity'] *  $descr_goods[0]['rate'];
			
    		 $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $party_dtail->gstin);
             $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['id']);
             $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $invoice_date);
             $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($descr_goods[0]['amount']));
             $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $party_city_name);
			 $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'R');
             $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
             $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $invoice_type);
             $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '');
             $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $descr_goods[0]['tax']);
             $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, number_format($Taxable_value));
             $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, '');
            $rowCount++;
        }
		//pre($objPHPExcel);die();
		
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$fileName.'"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
         redirect(site_url().$fileName);
		}else{
			$this->session->set_flashdata('message', 'No Data Avilable');
			redirect(base_url().'account/Gstr_1', 'refresh');
		}
    
}
public function create_GSTR1_json(){
	$created_by_id = $_SESSION['loggedInUser']->c_id;	
	$invoice_data  = $this->account_model->get_data('invoice',array('created_by_cid'=> $created_by_id)); 
	$data['credit_debit_notes']  = $this->account_model->get_data('voucher',array('created_by_cid'=> $created_by_id)); 
	
		$unique_GST_number = array_unique(array_map(function($elem){return $elem['sale_leger_gstin_no'];}, $invoice_data));
		$finalArray = array();
		if(!empty($unique_GST_number)){
			$i = 0;
			foreach($unique_GST_number as $uniq_gst){
				$invoices  = $this->account_model->get_data('invoice',array('created_by_cid'=> $created_by_id,'sale_leger_gstin_no'=>$uniq_gst)); 				
				$finalArray[$i]['ctin'] = $uniq_gst;
				if(!empty($invoices)){
					
					$j = 0;
					foreach($invoices as $invoice){
						
						$total_amount_witout_tax_Amount = json_decode($invoice['invoice_total_with_tax']);
						$total_amount_for_conditions = $total_amount_witout_tax_Amount[0]->total;
						if($invoice['gstin'] !='' && $invoice['invoice_type']=='domestic_invoice'){
							$finalArray[$i]['inv'][$j]['inum'] = $invoice['invoice_num'];
							$finalArray[$i]['inv'][$j]['idt'] = $invoice['date_time_of_invoice_issue'];
							$finalArray[$i]['inv'][$j]['val'] = $invoice['total_amount'];
							$finalArray[$i]['inv'][$j]['pos'] = sprintf("%02d", $invoice['party_state_id']);
							$finalArray[$i]['inv'][$j]['rchrg'] = 'N';
							if($invoice['descr_of_goods'] !=''){
								$products = json_decode($invoice['descr_of_goods']);
								if(!empty($products)){
									$k = 0;
									$mat_num = 1;
									foreach($products as $product){
										$total_mat_amt = $product->amount - $product->added_tax_Row_val;
										$finalArray[$i]['inv'][$j]['items'][$k]['num'] = $mat_num;	
										$finalArray[$i]['inv'][$j]['items'][$k]['itm_det']['txval'] = $total_mat_amt;	
										$finalArray[$i]['inv'][$j]['items'][$k]['itm_det']['rt'] = $product->tax;	
										$finalArray[$i]['inv'][$j]['items'][$k]['itm_det']['iamt'] = $product->added_tax_Row_val;	
										$finalArray[$i]['inv'][$j]['items'][$k]['itm_det']['csamt'] = $product->cess;	
										
										$k++;
										$mat_num++;
									}
									$finalArray[$i]['inv'][$j]['inv_typ'] = 'R';
								}
							}
							
							$j++;
						}
						if($invoice['gstin'] =='' && $total_amount_for_conditions < 1500 && $invoice['invoice_type']=='domestic_invoice' ){
							
							$finalArrayb2cs =array();
							if($invoice['descr_of_goods'] !=''){
								
								
								$products2 = json_decode($invoice['descr_of_goods']);
								
								if(!empty($products2)){
									
									
									$g = 0;
									foreach($invoices as $b2cs){
										$finalArrayb2cs[$g]['rt'] = '18';
										if($b2cs['CGST'] != '' && $b2cs['SGST'] != '' && $b2cs['IGST'] == '0.00' ){
											$finalArrayb2cs[$g]['sply_ty'] = 'INTRA';	
										}
										if($b2cs['IGST'] != '' && $b2cs['CGST'] == '0.00' && $b2cs['SGST'] == '0.00'){
										   $finalArrayb2cs[$g]['sply_ty'] = 'INTER';
										}
											$finalArrayb2cs[$g]['pos'] = sprintf("%02d", $b2cs['party_state_id']);
											$finalArrayb2cs[$g]['typ'] = 'OE';			
											$finalArrayb2cs[$g]['txval'] = $b2cs['totaltax_total'];
										if($b2cs['CGST'] != '' && $b2cs['SGST'] != '' && $b2cs['IGST'] == '0.00' ){
											$finalArrayb2cs[$g]['camt'] = $b2cs['CGST'];	
											$finalArrayb2cs[$g]['samt'] = $b2cs['SGST'];		
										}
										if($b2cs['IGST'] != '' && $b2cs['CGST'] == '0.00' && $b2cs['SGST'] == '0.00'){
										  $finalArrayb2cs[$g]['iamt'] = $b2cs['IGST'];
										}
											$finalArrayb2cs[$g]['csamt'] = 'cess';
									$g++;			
									}
									
									
									
								
									
									
								}
							}
						}
						
					}
					
					if($invoice['descr_of_goods'] !=''){
								$products = json_decode($invoice['descr_of_goods']);
								if(!empty($products)){
									$w = 0;
									$mat_num = 1;
									foreach($products as $product){
										
										$total_mat_amt = $product->amount - $product->added_tax_Row_val;
										$hsn_array['data'][$w]['num'] = $mat_num;	
										$hsn_array['data'][$w]['hsn_sc'] = $product->hsnsac;	
										$hsn_array['data'][$w]['desc'] = $product->descr_of_goods;	
										$hsn_array['data'][$w]['uqc'] = $product->UOM;	
										$hsn_array['data'][$w]['qty'] = $product->quantity;	
										$hsn_array['data'][$w]['val'] = $total_mat_amt;	
										$hsn_array['data'][$w]['txval'] = $product->added_tax_Row_val;
										
										if($invoice['IGST'] !='' && $invoice['SGST'] == '0.00' && $invoice['CGST'] == '0.00' ){	
										
											$hsn_array['data'][$w]['iamt'] = $product->added_tax_Row_val;
											$hsn_array['data'][$w]['camt'] = '0.00';	
										    $hsn_array['data'][$w]['samt'] = '0.00';	
										}
										if($invoice['IGST'] =='0.00' && $invoice['SGST']!= '' && $invoice['CGST'] != ''){	
										
										$hsn_array['data'][$w]['camt'] = $product->added_tax_Row_val;	
										$hsn_array['data'][$w]['samt'] = $product->added_tax_Row_val;
										$hsn_array['data'][$w]['iamt'] = '0.00';
										}	
										$hsn_array['data'][$w]['csamt'] = $product->cess_tax_calculation;	
										
										$w++;
										$mat_num++;
									}
									
								}
							}
						}
					$i++;  
				}
		}
		
			$posts = array(
					'gstin'=> $_SESSION['loggedInCompany']->gstin,
					'fp'=> '022020',
					'gt'=> '022020',
					'cur_gt'=> '022020',
					'b2b' =>$finalArray,
					'b2cs' =>$finalArrayb2cs,
					'hsn'=>$hsn_array
				);
			// $json_data = json_encode($posts, JSON_PRETTY_PRINT);
			
		 $json_data = json_encode($posts);
			header('Content-disposition: attachment; filename=gstr1.json');
			header('Content-type: application/json');
			echo $json_data;
			
			redirect(base_url().'account/Gstr_1', 'refresh');
	
}
	
public function create_GSTR3B_json() {
			$created_by_id = $_SESSION['loggedInUser']->c_id;	
			$Sale_Data = $this->account_model->get_data('invoice',array('created_by_cid'=> $created_by_id)); 
			$Purchase_Data  = $this->account_model->get_data('purchase_bill',array('created_by_cid'=> $created_by_id,'auto_entry'=>0)); 
			$finalArray_first = array();
			$finalArray_second = array();
			setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
		$i = 0;
		$m = 0;
		
			foreach($Sale_Data as $invoice){
				if($invoice['gstin'] !=''  ){
					$total_amount_witout_tax_Amount = json_decode($invoice['invoice_total_with_tax']);
						$total_amount = $total_amount + $total_amount_witout_tax_Amount[0]->total;
							if($invoice['CGST'] == '0.00' && $invoice['CGST'] == '0.00' && $invoice['IGST'] != ''){
								$integrated_tax_sum = $integrated_tax_sum + $invoice['IGST'];
							}
							if($invoice['CGST'] != '' && $invoice['SGST'] != '' && $invoice['IGST'] == '0.00'){
								$cgst_sum = $cgst_sum + $invoice['CGST'];
								$sgst_sum = $sgst_sum + $invoice['SGST'];
							}
						
							$finalArray_first['osup_det']['txval'] = money_format('%!i',$total_amount);
							$finalArray_first['osup_det']['iamt'] = money_format('%!i',$integrated_tax_sum);
							$finalArray_first['osup_det']['camt'] = money_format('%!i',$cgst_sum);
							$finalArray_first['osup_det']['samt'] = money_format('%!i',$sgst_sum);
							$finalArray_first['osup_det']['csamt'] = '0.00';
							
						}
						
					if($invoice['gstin'] =='' && $invoice['party_state_id'] != $invoice['sale_L_state_id'] ){	
								$total_amount_witout_tax_of_supplies = json_decode($invoice['invoice_total_with_tax']);
								foreach($total_amount_witout_tax_of_supplies as $data_total){
								  $total_taax =	$data_total->totaltax;
								  $integrated_tax_sumof_supplies = $integrated_tax_sumof_supplies + $total_taax;
								  $total_amountof_supplies = $total_amountof_supplies + $data_total->total;
									
									$finalArray_first['osup_zero']['txval'] = money_format('%!i',$total_amountof_supplies);
									$finalArray_first['osup_zero']['iamt'] = money_format('%!i',$integrated_tax_sumof_supplies);
									$finalArray_first['osup_zero']['camt'] = '0.00';
									$finalArray_first['osup_zero']['samt'] = '0.00';
									$finalArray_first['osup_zero']['csamt'] = '0.00';
								}
							}
					//if($invoice['CGST'] == '0.00' && $invoice['SGST'] == '0.00' && $invoice['IGST'] == '0.00'){
					
							if($invoice['CGST'] == '0.00' && $invoice['SGST'] == '0.00' && $invoice['IGST'] == '0.00'){
								pre($invoice);
								$total_amount_witout_tax_Amount = json_decode($invoice['invoice_total_with_tax']);
								$total_amount_nill = $total_amount + $total_amount_witout_tax_Amount[0]->total;
								
								$integrated_tax_sum_nill = $integrated_tax_sum + $invoice['IGST'];
								$cgst_sum_nill = $cgst_sum + $invoice['CGST'];
								$sgst_sum_nill = $sgst_sum + $invoice['SGST'];
							}
							
						
							$finalArray_first['osup_nil_exmp']['txval'] = money_format('%!i',$total_amount_nill);
							$finalArray_first['osup_nil_exmp']['iamt'] = money_format('%!i',$integrated_tax_sum_nill);
							$finalArray_first['osup_nil_exmp']['camt'] = money_format('%!i',$cgst_sum_nill);
							$finalArray_first['osup_nil_exmp']['samt'] = money_format('%!i',$sgst_sum_nill);
							$finalArray_first['osup_nil_exmp']['csamt'] = '0.00';
							
						//}			
							$finalArray_first['isup_rev']['txval'] = '0.00';
							$finalArray_first['isup_rev']['iamt'] = '0.00';
							$finalArray_first['isup_rev']['camt'] = '0.00';
							$finalArray_first['isup_rev']['samt'] = '0.00';
							
							$finalArray_first['osup_nongst']['txval'] = '0.00';
							$finalArray_first['osup_nongst']['iamt'] = '0.00';
							$finalArray_first['osup_nongst']['camt'] = '0.00';
							$finalArray_first['osup_nongst']['samt'] = '0.00';
						
							$finalArray_second['itc_avl'][$i]['ty'] = 'IMPG';
							$finalArray_second['itc_avl'][$i]['iamt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['camt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['samt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['csamt'] = '0.00';
							
							$finalArray_second['itc_avl'][$i]['ty'] = 'IMPS';
							$finalArray_second['itc_avl'][$i]['iamt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['camt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['samt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['csamt'] = '0.00';
							
							$finalArray_second['itc_avl'][$i]['ty'] = 'ISRC';
							$finalArray_second['itc_avl'][$i]['iamt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['camt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['samt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['csamt'] = '0.00';
							
							$finalArray_second['itc_avl'][$i]['ty'] = 'ISD';
							$finalArray_second['itc_avl'][$i]['iamt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['camt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['samt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['csamt'] = '0.00';
							
							$finalArray_second['itc_avl'][$i]['ty'] = 'ISD';
							$finalArray_second['itc_avl'][$i]['iamt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['camt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['samt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['csamt'] = '0.00';
							
							$finalArray_second['itc_rev']['ty'] = 'RUL';
							$finalArray_second['itc_rev']['iamt'] = '0.00';
							$finalArray_second['itc_rev']['camt'] = '0.00';
							$finalArray_second['itc_rev']['samt'] = '0.00';
							$finalArray_second['itc_rev']['csamt'] = '0.00';
							
							$finalArray_second['itc_rev']['ty'] = 'OTH';
							$finalArray_second['itc_rev']['iamt'] = '0.00';
							$finalArray_second['itc_rev']['camt'] = '0.00';
							$finalArray_second['itc_rev']['samt'] = '0.00';
							$finalArray_second['itc_rev']['csamt'] = '0.00';
							
							$finalArray_second['itc_net']['iamt'] = '0.00';
							$finalArray_second['itc_net']['camt'] = '0.00';
							$finalArray_second['itc_net']['samt'] = '0.00';
							$finalArray_second['itc_net']['csamt'] = '0.00';
							
							$finalArray_second['itc_inelg']['ty'] = 'RUL';
							$finalArray_second['itc_inelg']['iamt'] = '0.00';
							$finalArray_second['itc_inelg']['camt'] = '0.00';
							$finalArray_second['itc_inelg']['samt'] = '0.00';
							$finalArray_second['itc_inelg']['csamt'] = '0.00';
							
							$finalArray_second['itc_inelg']['ty'] = 'OTH';
							$finalArray_second['itc_inelg']['iamt'] = '0.00';
							$finalArray_second['itc_inelg']['camt'] = '0.00';
							$finalArray_second['itc_inelg']['samt'] = '0.00';
							$finalArray_second['itc_inelg']['csamt'] = '0.00';
				$i++;		
				$m++;		
				}
				$finalArray_first_inward = array();
				$finalArray_first_inward_un_reg = array();
				$b = 0;
				$bm = 0;
				
				foreach($Purchase_Data as $inward_supp){
					
					if($inward_supp['gstin'] !=''  ){
					$total_amount_inward_supp = json_decode($inward_supp['invoice_total_with_tax']);
					
						$total_amount_inward_supp1 = $total_amount_inward_supp1 + $total_amount_inward_supp[0]->total;
							if($inward_supp['CGST'] == '0.00' && $inward_supp['CGST'] == '0.00' && $inward_supp['IGST'] != ''){
								$integrated_tax_sum1 = $integrated_tax_sum1 + $inward_supp['IGST'];
							}
							if($inward_supp['CGST'] != '' && $inward_supp['SGST'] != '' && $inward_supp['IGST'] == '0.00'){
								$cgst_sum1 = $cgst_sum1 + $inward_supp['CGST'];
								$sgst_sum1 = $sgst_sum1 + $inward_supp['SGST'];
								$inter = $cgst_sum1 + $sgst_sum1;
							}
						
							$finalArray_first_inward['isup_details'][$b]['ty'] = 'GST';
							$finalArray_first_inward['isup_details'][$b]['inter'] = money_format('%!i',$inter);
							$finalArray_first_inward['isup_details'][$b]['intra'] = money_format('%!i',$integrated_tax_sum1);
							
							
						}elseif($inward_supp['gstin'] ==''  ){
							
									$total_amount_inward_supp = json_decode($inward_supp['invoice_total_with_tax']);
									$total_amount_inward_supp1 = $total_amount_inward_supp1 + $total_amount_inward_supp[0]->total;
							if($inward_supp['CGST'] == '0.00' && $inward_supp['CGST'] == '0.00' && $inward_supp['IGST'] != ''){
								$integrated_tax_sum1 = $integrated_tax_sum1 + $inward_supp['IGST'];
							}
							if($inward_supp['CGST'] != '' && $inward_supp['SGST'] != '' && $inward_supp['IGST'] == '0.00'){
								$cgst_sum1 = $cgst_sum1 + $inward_supp['CGST'];
								$sgst_sum1 = $sgst_sum1 + $inward_supp['SGST'];
								$inter = $cgst_sum1 + $sgst_sum1;
							}
						
							$finalArray_first_inward['isup_details'][$b]['ty'] = 'NONGST';
							$finalArray_first_inward['isup_details'][$b]['inter'] = money_format('%!i',$inter);
							$finalArray_first_inward['isup_details'][$b]['intra'] = money_format('%!i',$integrated_tax_sum1);
							
							
						}
						
							if($inward_supp['CGST'] == '0.00' && $inward_supp['CGST'] == '0.00' && $inward_supp['IGST'] != ''){
								$iggst = $iggst + $inward_supp['IGST'];
							}
							if($inward_supp['CGST'] != '' && $inward_supp['SGST'] != '' && $inward_supp['IGST'] == '0.00'){
								$cgst_sum12 = $cgst_sum12 + $inward_supp['CGST'];
								$sgst_sum12 = $sgst_sum12 + $inward_supp['SGST'];
								
							}
						$total_amountforcess = json_decode($inward_supp['invoice_total_with_tax']);
						
						    $finalArray_first_inwardintr_details['intr_details']['iamt'] = money_format('%!i',$iggst);
							$finalArray_first_inwardintr_details['intr_details']['camt'] = money_format('%!i',$cgst_sum12);
							$finalArray_first_inwardintr_details['intr_details']['samt'] = money_format('%!i',$sgst_sum12);
							$finalArray_first_inwardintr_details['intr_details']['csamt'] = money_format('%!i',$total_amountforcess[0]->cess_all_total);
						
				

					if($inward_supp['gstin'] !='' &&  $inward_supp['CGST'] == '0.00' && $inward_supp['SGST'] == '0.00' ){
						
						
						$tax_val = $inward_supp['total_amount'] - $inward_supp['totaltax_total'];
					
						    $finalArray_first_inward_un_reg['unreg_details'][$bm]['pos'] = sprintf("%02d", $inward_supp['party_billing_state_id']);
							$finalArray_first_inward_un_reg['unreg_details'][$bm]['txval'] = money_format('%!i',$tax_val);
							$finalArray_first_inward_un_reg['unreg_details'][$bm]['iamt'] = money_format('%!i',$inward_supp['IGST']);
							
					}	
				$b++;	
				$bm++;	
					}
				

				
			$posts = array(
					'gstin'=> $_SESSION['loggedInCompany']->gstin,
					'ret_period'=> '042020',
					'sup_details'=> $finalArray_first,
					'itc_elg'=> $finalArray_second,
					'inward_sup'=> $finalArray_first_inward,  
					'intr_ltfee'=> $finalArray_first_inwardintr_details,  
					'inter_sup'=> $finalArray_first_inward_un_reg,  
					
					
				);
			
			// $json_data = json_encode($posts, JSON_PRETTY_PRINT);
			
			$json_data = json_encode($posts);
			// pre($json_data);		
		// die();
			header('Content-disposition: attachment; filename=gstr_3B.json');
			header('Content-type: application/json');
			echo $json_data;
			
			redirect(base_url().'account/Gstr_3b', 'refresh');
			
			
    }	

	
		
/**************************************************************************************************************************************/
  /********************************************Create Ledger CSV Functions*************************************************************/
/*********************************************************************************************************************************/	
		
	public function add_financial_year_date() {
	 $login_company_id = $created_id = $_SESSION['loggedInUser']->c_id;
	 $start_date = $_REQUEST['start'];
	 $end_date = $_REQUEST['end'];
		 $return_data = $this->account_model->save_financial_year_date('company_detail',$login_company_id,$start_date,$end_date); 
		 if($return_data > 0){
			 echo 'true';
		 }
	}
	
	
	public function remove_financial_year_date() {
		$login_company_id = $created_id = $_SESSION['loggedInUser']->c_id;
		//$remove_Date = $_REQUEST['remove_Date'];
		 $return_data = $this->account_model->remove_financial_year_date('company_detail',$login_company_id); 
		 if($return_data > 0){
			 $this->session->set_flashdata('message', 'Financial Year Date Removed');
				redirect('account/financial_year_settings', 'refresh');	
		 }
	}
	
	public function save_invoice_num_prefix(){
		//pre($_POST);die();
		if (isset($_POST['prefix_inv_num'])) {
			
			$addressLength = count($_POST['prefix_inv_num']);	
				if($addressLength >0){
					$addressArr = [];
					$i = 0;
					$idds = 1;
					while($i < $addressLength) {				
						$addressJsonArrayObject = array('add_id'=> $idds,'address' => $_POST['address'][$i], 'country' => $_POST['country'][$i], 'state' => $_POST['state'][$i], 'city' => $_POST['city'][$i],'postal_zipcode' => $_POST['postal_zipcode'][$i],'company_gstin' => $_POST['company_gstin'][$i],'compny_branch_name'=>$_POST['compny_branch_name'][$i],'prefix_inv_num' => $_POST['prefix_inv_num'][$i]);
						$addressArr[$i] = $addressJsonArrayObject;
						$i++;	
						$idds++;	
					
					}
					$address_array = json_encode($addressArr);
				}else{
					$address_array = '';
				}
			$retrn_val = $this->account_model->update_data_check('company_detail',$address_array); 
			if($retrn_val > 0){
			 $this->session->set_flashdata('message', 'Prefix Invoice Settings Added.');
				redirect('account/invoice_setting', 'refresh');	
		 }
		}
		if(isset($_POST['email_send_setting'])){
		
			$login_company_id = $_SESSION['loggedInUser']->c_id;
			$retrn_val_Email = $this->account_model->update_email_Settings('company_detail',$_POST['email_send_setting'],$login_company_id); 
			if($retrn_val_Email > 0){
			 $this->session->set_flashdata('message', 'Email Settings changed');
			 redirect('account/invoice_setting', 'refresh');	
		 }
		}
		if(isset($_POST['invoice_num_of_copies'])){
			$login_company_id = $_SESSION['loggedInUser']->c_id;
			$rtrn = $this->account_model->save_number_of_invoice_copeies('company_detail','invoice_num_of_copies',$_POST['invoice_num_of_copies'],$login_company_id); 
			//echo $rtrn;die();
			if($rtrn >=0 ){
			 $this->session->set_flashdata('message', 'Update Number of Invoice Copies ');
				redirect('account/invoice_setting', 'refresh');	
		 }
			
		}
		if(isset($_POST['discount_on_off'])){
			$login_company_id =  $_SESSION['loggedInUser']->c_id;
			
			$rtrn = $this->account_model->save_number_of_invoice_copeies('company_detail','discount_on_off',$_POST['discount_on_off'],$login_company_id); 
			//echo $rtrn;die();
			if($rtrn >=0 ){
			 $this->session->set_flashdata('message', 'Update Discount Settings');
				redirect('account/invoice_setting', 'refresh');	
		 }
	}
		if(isset($_POST['multi_loc_on_off'])){
			$login_company_id =  $_SESSION['loggedInUser']->c_id;
			
			$rtrn = $this->account_model->save_number_of_invoice_copeies('company_detail','multi_loc_on_off',$_POST['multi_loc_on_off'],$login_company_id); 
			//echo $rtrn;die();
			if($rtrn >=0 ){
			 $this->session->set_flashdata('message', 'Update Multi Location  Settings');
				redirect('account/invoice_setting', 'refresh');	
		 }
			
		}
		if(isset($_POST['item_code_on_off'])){
			$login_company_id =  $_SESSION['loggedInUser']->c_id;
			$rtrn = $this->account_model->save_number_of_invoice_copeies('company_detail','item_code_on_off',$_POST['item_code_on_off'],$login_company_id); 
			if($rtrn >=0 ){
			 $this->session->set_flashdata('message', 'Update Item Code   Settings');
				redirect('account/invoice_setting', 'refresh');	
		 }
		}
		if(isset($_POST['invoice_cancl_restor'])){
			$login_company_id =  $_SESSION['loggedInUser']->c_id;
			$rtrn = $this->account_model->save_number_of_invoice_copeies('company_detail','invoice_cancl_restor',$_POST['invoice_cancl_restor'],$login_company_id); 
			if($rtrn >=0 ){
			 $this->session->set_flashdata('message', 'Update invoice Cancel Restore   Settings');
				redirect('account/invoice_setting', 'refresh');	
		 }
		}
		
	}
		
	public function get_quantity_calulation_and_more(){
			$created_by_id  = $_SESSION['loggedInUser']->u_id;
			$ladger_Rdata['qtty_dtls']  = $this->account_model->get_data('invoice',array('created_by'=> $created_by_id)); 			
			$this->load->view('saleregister/quantity_check', $ladger_Rdata);
			
	}	
		
		
		public function dashboard(){		
		$this->breadcrumb->add('dashboard', base_url() . 'dashboard');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Dashboard';	
		$this->data['user_dashboard']  = $this->account_model->get_data('user_dashboard',array('user_id' => $_SESSION['loggedInUser']->id));
		$this->_render_template('dashboard/index', $this->data);
	}
	
	public function monthWiseIncomeExpenseAmountGraph(){
		if(!empty($_POST)) {
			$startDate = $_POST['startDate'];
			$endDate = $_POST['endDate'];
		}else{
			$startDate =  $endDate = '' ;
		}		
		$getPermissions = getPermissionsForDashboard(array('permissions.user_id' => $_SESSION['loggedInUser']->id,'modules.id'=>6,'permissions.is_view'=>1));
		$this->data['incomeExpenseGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;
		$this->data['productSaleGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;
		$this->data['cashFlowGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;		
		$accountGraphDashboardArray = array();
		if((!empty($getPermissions) &&  $_SESSION['loggedInUser']->role == 2) || $_SESSION['loggedInUser']->role == 1){
			$monthWiseIncomeExpenseAmountGraph = monthWiseIncomeExpenseAmountGraph($startDate, $endDate);
			$materialSaleAmountGraph = materialSaleAmountGraph($startDate, $endDate);
			$monthWiseCashFlowGraph = monthWiseCashFlowGraph($startDate, $endDate);
		}
		$accountGraphDashboardArray = array('monthWiseIncomeExpenseAmountGraph' => $monthWiseIncomeExpenseAmountGraph ,'materialSaleAmountGraph' => $materialSaleAmountGraph ,'monthWiseCashFlowGraph'=> $monthWiseCashFlowGraph);		
		echo json_encode($accountGraphDashboardArray);
	}
		
	public function showDashboardOnRequirement(){
		$data = $_POST;
		$data['user_id'] = $_SESSION['loggedInUser']->id;
		$userDashboardRes = $this->account_model->get_data('user_dashboard',array('user_id'=> $_SESSION['loggedInUser']->id , 'graph_id' => $data['graph_id']));	
		if(!empty($userDashboardRes)){
			$id = $this->account_model->update_data('user_dashboard',$data,'id',$userDashboardRes[0]['id']);	
		}else{
			$id = $this->account_model->insert_tbl_data('user_dashboard',$data);
		}	
		if($id){
			$result = array('msg' => 'Data for user set', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/dashbaord');    
			echo json_encode($result);
			die;	
		}		
	}	
		
	public function chart_of_accounts() { 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Chart of Accounts', base_url() . 'chart_of_accounts');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Chart of Accounts';
		$created_id = $_SESSION['loggedInUser']->c_id;
		$this->data['ChartAccount']  = $this->account_model->get_parent('account_group',$created_id);
		$this->_render_template('chart_of_accounts/index', $this->data);
    }		
		
	
	public function createLedgerViaAjax(){	
		$id = $this->account_model->createLedgerViaAjax('ledger',array('account_group_id'=>$_POST['account_group_id'] , 'name' => $_POST['name'] , 'parent_group_id' => $_POST['parent_group_id'],'created_by_cid' => $_SESSION['loggedInUser']->c_id, 'created_by' => $_SESSION['loggedInUser']->id));
		if($id){
			$result = array('msg' => 'Ledger created successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/chart_of_accounts');    
			echo json_encode($result);
			die;	
		}	
	}	
	
	
	
	public function createLedgerAccountViaAjax(){

		if($_POST['table'] == 'ledger'){
		$id = $this->account_model->createLedgerAccountViaAjax($_POST['table'],array('account_group_id'=>$_POST['account_group_id'] , 'name' => $_POST['name'] , 'parent_group_id' => $_POST['parent_group_id'],'created_by_cid' => $_SESSION['loggedInUser']->c_id, 'created_by' => $_SESSION['loggedInUser']->id));
		}else{
			$id = $this->account_model->createLedgerAccountViaAjax($_POST['table'],array('name' => $_POST['name'] , 'parent_group_id' => $_POST['parent_group_id'],'created_by_cid' => $_SESSION['loggedInUser']->c_id, 'created_by' => $_SESSION['loggedInUser']->id));
		}
		if($id){
			$result = array('msg' => 'Created successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/chart_of_accounts');    
			echo json_encode($result);
			die;	
		}	
	}	
	
	
	
	
	public function updateLedgerGroupNameViaAjax(){			
		$id = $this->account_model->updateLedgerGroupNameViaAjax($_POST['table'],array('name' => $_POST['name']),'id',$_POST['id']);	
		if($id){
			$result = array('msg' => 'Updated successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/chart_of_accounts');    
			echo json_encode($result);
			die;	
		}	
	}	
	
/*************************************************account freeze*************************************************************/

	public function account_freeze(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account Freeze', base_url() . 'account_freeze');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Account Freeze';
		$where = array('account_freeze.created_by_cid' => $_SESSION['loggedInUser']->c_id);
		
		$this->data['account_freeze']  = $this->account_model->get_account_freeze_date('account_freeze',$where);
		$this->_render_template('account_freeze/index', $this->data);
	}		
		
	public function	editAccountFreeze(){
			$id=$_POST['id'];
			//permissions_redirect('is_view');
			$this->data['get_account_freeze'] = $this->account_model->get_data_byId('account_freeze','id',$id);
			$this->load->view('account_freeze/edit', $this->data);		
	}
		
	public function saveAccountFreeze(){	
		if ($this->input->post()) {
			$required_fields = array('freeze_date');		
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);
			}else{
				$data  = $this->input->post();	
				
				//$data['created_by'] =$_SESSION['loggedInUser']->id;
				$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
				$id=$data['id'];
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->id;
					$success = $this->account_model->update_data('account_freeze',$data, 'id', $id);	
					if ($success) {
						$data['message'] = "Account freeze updated successfully";
						logActivity('Account freeze Updated','Account freeze',$id);
						$this->session->set_flashdata('message', 'Account freeze Updated successfully');
						redirect(base_url().'account/account_freeze', 'refresh');
					}	
				}else{	
						//pre("sdfsd");
					$id = $this->account_model->insert_tbl_data('account_freeze',$data);
					
					if ($id) {
                       
						logActivity('Account freeze inserted','Account freeze',$id);
						$this->session->set_flashdata('message', 'Account freeze inserted successfully');
						redirect(base_url().'account/account_freeze', 'refresh');
					}              
				}
			}
		}
	}	

// Crages Head
public function charges_lead() { 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account', base_url() . 'Charges Head');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Charges Head';
		$created_id = $_SESSION['loggedInUser']->c_id;
		//$this->data['ledgers']  = $this->account_model->get_data('ledger',array('created_by'=> $created_id));
		$this->data['charge_lead_Datas']  = $this->account_model->get_data('charges_lead',array('created_by_cid'=> $created_id,'charges_for'=>0));
		$this->_render_template('charges_lead/index', $this->data);
    }

	
	public function editcharges(){
	
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['charge_lead_Datas'] = $this->account_model->get_data_byId('charges_lead','id',$this->input->post('id'));
		//echo 'there';die();
			$this->load->view('charges_lead/edit', $this->data);
		}	
	}
    public function savecharges(){
		
		if ($this->input->post()) {
			
			$required_fields = array('account_group','particular_charges');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				$data  = $this->input->post();			
				$data['created_by_uid'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				$id = $data['id'];
			// pre($data);die();
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->account_model->update_data('charges_lead',$data, 'id', $id);	
					if ($success) {
                        $data['message'] = "Charges updated successfully";
                        logActivity('Charges  Updated','charges_lead',$id);
                        $this->session->set_flashdata('message', 'Charges  Updated successfully');
					    redirect(base_url().'account/charges_lead', 'refresh');
                    }
				}else{
					$id = $this->account_model->insert_tbl_data('charges_lead',$data);  					
					if ($id) {                        
                        logActivity('New Charges Created','charges_lead',$id);
                        $this->session->set_flashdata('message', 'Charges  inserted successfully');
					    redirect(base_url().'account/charges_lead', 'refresh');
                    }    				
				}
			}			
        }
	}
public function deleteCharges_leads($id = ''){	
		if (!$id) {
           redirect('account/charges_lead', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('charges_lead','id',$id);
		if($result){
			logActivity('Charge  Deleted','charges_lead',$id);
			$this->session->set_flashdata('message', 'Charge Deleted Successfully');
			$result = array('msg' => 'Charge Deleted Successfully', 'status' => 'success', 'code' => 'C264','url' => base_url() . 'account/charges_lead');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}	
// Crages Lead	
	public function delivery_chln() { 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account', base_url() . 'delivery chln');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Delivery Challan';
		$created_id = $_SESSION['loggedInUser']->c_id;
		
		if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
		$this->data['delivery_data']  = $this->account_model->get_data('challan_dilivery',array('created_by_cid'=> $created_id));
		$this->_render_template('delivery_chln/index', $this->data);
		}
		if(!empty($_POST) && isset($_POST['start']) &&  isset($_POST['end'])){
			
			$where = array('challan_dilivery.created_date >=' => $_POST['start'] , 'challan_dilivery.created_date <=' => $_POST['end'],'challan_dilivery.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
			$this->data['delivery_data']  = $this->account_model->get_data('challan_dilivery',$where);
			$this->_render_template('delivery_chln/index', $this->data);
		}else{
			$this->data['delivery_data']  = $this->account_model->get_data('challan_dilivery',array('created_by_cid'=> $created_id));
			$this->_render_template('delivery_chln/index', $this->data);
		}
    }
	public function editdelivery_chln(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['delivery_data'] = $this->account_model->get_data_byId('challan_dilivery','id',$this->input->post('id'));
			$this->load->view('delivery_chln/edit', $this->data);
		}	
	}
	public function viewchalan_details(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['delivery_data'] = $this->account_model->get_data_byId('challan_dilivery','id',$this->input->post('id'));			
			$this->load->view('delivery_chln/view', $this->data);
		}	
	}
	public function saveChallan_Details(){
		
		if ($this->input->post()) {
			
			$required_fields = array('descr_of_goods');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				$descr_of_goodsLength = count($_POST['descr_of_goods']);
				if($descr_of_goodsLength >0){
					$arr = [];
					$i = 0;
					while($i < $descr_of_goodsLength) {	
						$jsonArrayObject = (array('material_id' =>$_POST['material_id'][$i],'descr_of_goods' => $_POST['descr_of_goods'][$i],'hsnsac' => $_POST['hsnsac'][$i], 'quantity' => $_POST['quantity'][$i], 'rate' => $_POST['rate'][$i],'UOM' => $_POST['UOM'][$i],'amount'=>$_POST['amount'][$i]));
						$arr[$i] = $jsonArrayObject;
						$i++;				
					}
					$descr_of_goods_array = json_encode($arr);
				}else{
					$descr_of_goods_array = '';
				}
				$data  = $this->input->post();
				//pre($_POST);
				$data['descr_of_goods'] = $descr_of_goods_array;
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				$id = $data['id'];
			// pre($data);die();
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->account_model->update_data('challan_dilivery',$data, 'id', $id);	
					if ($success) {
                        $data['message'] = "Challan updated successfully";
                        logActivity('Challan  Updated','delivery_chln',$id);
                        $this->session->set_flashdata('message', 'Challan  Updated successfully');
					    redirect(base_url().'account/delivery_chln', 'refresh');
                    }
				}else{
					$id = $this->account_model->insert_tbl_data('challan_dilivery',$data);  					
					if ($id) {                        
                        logActivity('New Challan Created','delivery_chln',$id);
                        $this->session->set_flashdata('message', 'Challan  inserted successfully');
					    redirect(base_url().'account/delivery_chln', 'refresh');
                    }    				
				}
			}			
        }
	}
	public function deleteChallan_details($id = ''){	
		if (!$id) {
           redirect('account/delivery_chln', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('challan_dilivery','id',$id);
		
		if($result){
			logActivity('Challan Details Deleted','challan_dilivery',$id);
			$this->session->set_flashdata('message', 'Challan Details Deleted Successfully');
			$result = array('msg' => 'Challan Details Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'account/delivery_chln');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}	
	public function create_challan_pdf($id = ''){
		$this->load->library('Pdf');
		$dataPdf['dataPdf'] = $this->account_model->get_data_byId('challan_dilivery','id',$id);
     	$this->load->view('delivery_chln/dilivery_challan_pdf',$dataPdf);	//$this->_render_template('purchase_order/view_pdf', $this->data);
		
	}
	
	function share_pdf_using_email_invoice(){
		$share_email_address = $_REQUEST['share_email'];
		$invoiceid = $_REQUEST['invoice_id'];
		$email_message = $_REQUEST['email_msg_id'];
		$invoice_details = getNameById('invoice',$invoiceid,'id');
		$company_details = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
		$company_emails = getNameById('user',$_SESSION['loggedInUser']->c_id,'c_id');
		$company_dtl = json_decode($company_details->address,true);
		$country_dtl = getNameById('country',$company_dtl[0]['country'],'country_id');
		
		$namddd = $country_dtl->country_name . ' - ' . $company_dtl[0]['postal_zipcode'];
		
		
		
		
		
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<meta name="viewport" content="width=device-width" />
							</head>
							<body style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; text-align: center; background: #efefef; margin: 0; padding: 40px 0;" bgcolor="#efefef">
								<table class="body-wrap text-center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; text-align: center; background: #efefef; margin: 0; padding: 0;" bgcolor="#efefef">
									<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
										<td class="container" align="center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">
											<!-- Message start -->
											<table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
												<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
													<td align="center" class="masthead" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: white; background: #099a8c; margin: 0; padding: 30px 0;     border-radius: 4px 4px 0 0;" bgcolor="#099a8c"> <img src="'.base_url().'assets/modules/company/uploads/'.$_SESSION['loggedInCompany']->logo.'" alt="logo" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; max-width: 20%; display: block; margin: 0 auto; padding: 0;" /></td>
												</tr>';    
										
								$footer = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
										<td class="container" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">
											<!-- Message start -->
											<table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
											<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
												<td class="content footer" align="center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white none; margin: 0; padding: 30px 35px;     border-radius: 0 0 4px 4px;" bgcolor="white">							
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center"><a href="'. base_url() .'" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: #888; text-decoration: none; font-weight: bold; margin: 0; padding: 0;">ERP</a></p>
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Support: '.$company_emails->email.'</p>
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">'.$company_dtl[0]['address'].',  '. $namddd .' </p>
												</td>
											</tr>
										</table>
										</td>
									</tr>
								</table>
							</body>
						</html>';
						$email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
															<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
																<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi ,</p>								
																
																<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Message '.$email_message.'</p>	
															</td>
														</tr>
													</table>
												</td>
											</tr>';	
											//$invoice_details->message_for_email
						$messageContent = $header.$email_message.$footer;
						
						$invoice_numm = 'Invoice No:- '.$invoice_details->invoice_num;
						ini_set('memory_limit', '20M');
						$this->load->library('pdf');
						$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
						// $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
						$pdf->SetCreator(PDF_CREATOR);  
						$pdf->SetTitle("TAX INVOICE");  
						$pdf->SetHeaderData('TAX INVOICE', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
						$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
						$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
						$pdf->SetDefaultMonospacedFont('helvetica');  
						$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
						$pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
						$pdf->setPrintHeader(false);  
						$pdf->setPrintFooter(false);  
						$pdf->SetAutoPageBreak(TRUE, 2);
						
						
						// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
						$pdf->SetTopMargin(1);	
						$pdf->SetFont('helvetica', '', 9);
						$this->load->library('email');
						$dataPdf['dataPdf'] = $this->account_model->get_data_byId('invoice','id',$invoice_details->id);
						//$dataPdf = $this->account_model->get_data_byId('invoice','id',$invoice_details->id);
						$pdf->SetCreator(PDF_CREATOR);
						$pdf->AddPage();
						$html = $this->load->view('invoice/invoice_pdf_email',$dataPdf, true);
						
						
			
						$pdf->WriteHTML($html); 
						// $pdf->writeHTML($html, true, 0, true, 0);
						$pdf->lastPage();
						// $pdf->WriteHTML(0, $html, '', 0, 'L', true, 0, false, false, 0);	
						$pdfFilePath = FCPATH . "assets/modules/account/pdf_invoice/pdf_invoice.pdf";
						ob_clean();
						$pdf->Output($pdfFilePath, "F");
							
							//$config['mailtype'] = 'html';
							//$this->email->initialize($config);
							$config = array(
							  'mailtype' => 'html',
							  'charset'  => 'utf-8',
							  'priority' => '1'
						   );
						$this->email->initialize($config);
							
							
						   // $this->load->library('email');
							$this->email->to($share_email_address);
							$this->email->from('invoice', $company_details->name);
							$this->email->subject($invoice_numm);
						
						$this->email->message($messageContent);
						$this->email->attach($pdfFilePath);
						
						  if($this->email->send()){     
						   echo  "sent";  
							unlink($pdfFilePath);
						  }else{
							echo "notsend"; 
						  }	
		
	}
	
/* Day book functionality Start*/	
function day_book(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Account', base_url() . 'day_book');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Day Book';
	$created_id = $_SESSION['loggedInUser']->c_id;
		
		$current_date = date('Y-m-d');
		
		if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
			$this->data['day_data_val']  = $this->account_model->get_data_daybook('transaction_dtl',array('created_by_cid'=> $created_id));
			$this->_render_template('day_book/index', $this->data);
		}
		if(!empty($_POST) && isset($_POST['start']) &&  isset($_POST['end'])){
			$where = array('transaction_dtl.created_date >=' => $_POST['start'],'transaction_dtl.created_date <=' => $_POST['end'],'transaction_dtl.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
			
			$this->data['day_data_val']  = $this->account_model->get_data_day_book('transaction_dtl',$where);
			$this->_render_template('day_book/index', $this->data);
		}else{
			$this->data['day_data_val']  = $this->account_model->get_data_daybook('transaction_dtl',array('created_by_cid'=> $created_id));
			$this->_render_template('day_book/index', $this->data);
		}
		
		//SELECT * FROM `transaction_dtl` WHERE `created_by_cid` = '3' AND DATE_FORMAT(`created_date`,'%Y-%m-%d') = '2020-02-06'
}
/* Day book functionality Start*/	
function cash_flow(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Account', base_url() . 'cash_flow');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Cash Flow';
	$created_id = $_SESSION['loggedInUser']->c_id;
	
	/* 0 for Payment receive and 1 for Payment to */
	/* For Financial Year*/
	$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id);//Fetch Data to Company Table
	$date_fcal = json_decode($date_fun->financial_year_date,true);
	
	if(empty($date_fcal)){
		if (date('m') <= 4) {//Upto June 2014-2015
		    $mydate = date(date('Y-04-01'));
			$lastyear = strtotime("-1 year", strtotime($mydate));
			$first_date = date("Y-m-d", $lastyear); 
			$date = date(date('Y-03-31'));
			$second_date = date('Y-m-d', strtotime("$date"));
		} else {//After June 2015-2016
		    $mydate = date(date('Y-04-01'));
			$lastyear = strtotime("-1 year", strtotime($mydate));
			$first_date = date("Y-m-d", $lastyear);
			$date = date(date('Y-03-31'));
			$second_date = date('Y-m-d', strtotime("$date"));
		}
	}else{
		
		if (date('m') <= 4) {//Upto June 2014-2015
		    $s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
			$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
			$first_date = date(date($s_Date));
			$date = date(date($e_Date));
			$second_date = date('Y-m-d', strtotime("$date"));
		} else {//After June 2015-2016
		    $s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
			$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
			$first_date = date(date($s_Date));
			$date = date(date($e_Date));
			$second_date = date('Y-m-d', strtotime("$date"));
		}
	}	
	/* For Financial Year*/
	
	if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
			 $where = " (ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND  transaction_dtl.created_by_cid = ".$_SESSION['loggedInUser']->c_id."";
			$this->data['cash_flow_val']  = $this->account_model->get_cash_flow_data($where);
			$this->_render_template('cash_flow/index', $this->data);
		}
	if($_POST['selected_branch_idd'] == 'All'){
		$where = " (ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND  transaction_dtl.created_by_cid = ".$_SESSION['loggedInUser']->c_id."";
		$this->data['cash_flow_val']  = $this->account_model->get_cash_flow_data($where);
		$this->_render_template('cash_flow/index', $this->data);
	}
	
	if(!empty($_POST) && isset($_POST['start']) &&  isset($_POST['end']) && !isset($_POST['selected_branch_idd'])){
			$where = ' AND ledger.created_date >="'.$_POST['start'] . '" AND ledger.created_date <="' .$_POST['end'] . '"' ;
			$this->data['cash_flow_val']  = $this->account_model->get_cash_flow_data($_POST['start'],$_POST['end']);
			$this->_render_template('cash_flow/index', $this->data);
		}elseif(isset($_POST['selected_branch_idd'])){
			
			$where = " (ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.compny_branch_id = '". $_POST['selected_branch_idd']  ."' AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
			$this->data['cash_flow_val']  = $this->account_model->get_cash_flow_data($where);
			
			$this->_render_template('cash_flow/index', $this->data);
		}else{
			$where = " (ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND  transaction_dtl.created_by_cid = ".$_SESSION['loggedInUser']->c_id."";
			$this->data['cash_flow_val']  = $this->account_model->get_cash_flow_data($where);
			$this->_render_template('cash_flow/index', $this->data);
	}
}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}//main