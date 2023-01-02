<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ERP_Controller extends CI_Controller {	
	var $breadcrumb;
	public function __construct(){
		parent::__construct();
		$this->load->database();		
		//$this->CI =& get_instance();		
		#$this->load->model('erp_model');		
		#$this->load->library(array('form_validation','breadcrumb','twilio'));
		$this->load->library(array('form_validation','breadcrumb'));
		$this->load->helper(array('language','url','layout_helper','functions_helper','pdf_helper','database_helper','setup_helper','theme_style_helper','datatable_helper'));	
		$this->styles = array();
		$this->scripts = array();		
		$this->settings['css'] = array(	'assets/plugins/bootstrap/dist/css/bootstrap.min.css',   
										'assets/plugins/font-awesome/css/font-awesome.min.css',
										'assets/plugins/nprogress/nprogress.css',
										'assets/plugins/iCheck/skins/flat/green.css',
										'assets/plugins/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css',
										'assets/plugins/jqvmap/dist/jqvmap.min.css',
										'assets/plugins/bootstrap-daterangepicker/daterangepicker.css',
										'assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css',
										#'assets/plugins/datatables.net/tabletools/2.2.4/css/dataTables.tableTools.min.css',
										'assets/plugins/datatables.net-buttons-bs/css/buttons.bootstrap.min.css',
										'assets/plugins/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css',
										'assets/plugins/datatables.net-responsive-bs/css/responsive.bootstrap.min.css',
										'assets/plugins/datatables.net-scroller-bs/css/scroller.bootstrap.min.css',
										'assets/css/custom.min.css',
										'assets/css/select2.css',
										'assets/css/style.css',
		);			
		$this->scripts['js'] = array(  'assets/plugins/jquery/dist/jquery.min.js',   
									   'assets/plugins/bootstrap/dist/js/bootstrap.min.js',   
									   'assets/plugins/fastclick/lib/fastclick.js',  
									   'assets/plugins/nprogress/nprogress.js', 
									   'assets/plugins/Chart.js/dist/Chart.min.js',   
									   'assets/plugins/gauge.js/dist/gauge.min.js', 
									   'assets/plugins/bootstrap-progressbar/bootstrap-progressbar.min.js', 
									   'assets/plugins/iCheck/icheck.min.js',   
									   'assets/plugins/skycons/skycons.js',    
									   'assets/plugins/Flot/jquery.flot.js', 
									   'assets/plugins/Flot/jquery.flot.pie.js', 
									   'assets/plugins/Flot/jquery.flot.time.js', 
									   'assets/plugins/Flot/jquery.flot.stack.js', 
									   'assets/plugins/Flot/jquery.flot.resize.js', 
									   'assets/plugins/flot.orderbars/js/jquery.flot.orderBars.js', 
									   'assets/plugins/flot-spline/js/jquery.flot.spline.min.js', 
									   'assets/plugins/flot.curvedlines/curvedLines.js', 
									   'assets/plugins/DateJS/build/date.js', 
									   'assets/plugins/jqvmap/dist/jquery.vmap.js', 
									   'assets/plugins/jqvmap/dist/maps/jquery.vmap.world.js', 
									   'assets/plugins/jqvmap/examples/js/jquery.vmap.sampledata.js', 
									   'assets/plugins/moment/min/moment.min.js', 
									   'assets/plugins/bootstrap-daterangepicker/daterangepicker.js', 
									   'assets/plugins/datatables.net/js/jquery.dataTables.min.js', 									  
									   #'assets/plugins/datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js', 									  
									   'assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js', 
									   'assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js', 
									   'assets/plugins/datatables.net-buttons-bs/js/buttons.bootstrap.min.js', 
									   'assets/plugins/datatables.net-buttons/js/buttons.flash.min.js', 
									   'assets/plugins/datatables.net-buttons/js/buttons.html5.min.js', 
									   'assets/plugins/datatables.net-buttons/js/buttons.print.min.js', 
									   'assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js', 
									   'assets/plugins/datatables.net-responsive-bs/js/responsive.bootstrap.js', 
									   'assets/plugins/datatables.net-scroller/js/dataTables.scroller.min.js', 
									   'assets/plugins/validator/multifield.js', 									   
									   'assets/plugins/validator/validator.js', 									   
									   //'assets/js/custom.min.js',
									   'assets/js/custom.js',
									   'assets/js/custom/global_script.js',
									   'assets/js/select2.js',
									   'assets/js/custom/ajax_script.js'	
		
		
									   
		); 	
		$this->data['pageTitle'] = '';	
		
	$this->data['permissions'] = array();
		$all_permissions = CheckPermission();
		#pre($all_permissions);
		if(!empty($all_permissions)) {
			//if(($all_permissions->is_all == 0 && $all_permissions->is_add == 0 && ($all_permissions->is_view == 0 && $all_permissions->sub_module_name!='leads')  && $all_permissions->is_edit == 0 && 	$all_permissions->is_delete == 0)  || ($all_permissions->is_view == 0 && $all_permissions->sub_module_name!='leads')) {
			if(($all_permissions->is_all == 0 && $all_permissions->is_add == 0 && ($all_permissions->is_view == 0 && ($all_permissions->sub_module_name!='leads' && $all_permissions->sub_module_name!='contacts' && $all_permissions->sub_module_name!='accounts'  && $all_permissions->sub_module_name != 'sale orders' && $all_permissions->sub_module_name != 'proforma invoice'))  && $all_permissions->is_edit == 0 && 	$all_permissions->is_delete == 0)  || ($all_permissions->is_view == 0 && ($all_permissions->sub_module_name!='leads' && $all_permissions->sub_module_name!='contacts'  && $all_permissions->sub_module_name != 'accounts'  && $all_permissions->sub_module_name != 'sale orders' && $all_permissions->sub_module_name != 'proforma invoice'))) {
				redirect('dashboard', 'refresh');	
			} else {
				$this->data['permissions'] = $all_permissions;	
			}
		}
		/*else {
				redirect('dashboard', 'refresh');		
			}*/	
			
			
			
			

 	}
	
	/*public function get_user($id){		
		$user = $this->ion_auth->user($id)->row();
		return $user;		
	}
	*/
	/* Render Template with Header and Footer*/
	public function _render_template($view, $data=null, $returnhtml=false, $header = true, $menu = true, $footer = true){
		$this->viewdata = (empty($data)) ? $this->data: $data;
		if($header){
			$this->load->view('template/header', $this->settings);
		}		
		if($header){
			#$this->load->view('template/header-and-sidebar', $this->settings);
		}		
		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);		
		if($footer){
			$this->load->view('template/footer', $this->scripts);
		}		
		/* This will return html on 3rd argument being true */
		if ($returnhtml) return $view_html;		
	}
	
	# Let's validate if all required fields are in the ajax request
	function validate_fields($fields = array(), $required = array()){		
		$output = array();		
		foreach($required as $val){			
			if(isset($fields[$val]) && $fields[$val] == ''){
				$output[$val] = '<p>' . ucwords(str_replace('_', ' ', $val)) . ' is an required field! </p>';
			}			
			if(!isset($fields[$val])){
				$output[$val] = '<p>' . ucwords(str_replace('_', ' ', $val)) . ' is missing from your request! </p>';
			}			
		}		
		return $output;
	}
	
	
	public function sendSms(){ 
		//$this->load->library('twilio');
		$sms_sender = trim($this->input->post('sms_sender'));
		$sms_reciever = $this->input->post('sms_recipient');
		$sms_message = trim($this->input->post('sms_message'));
		$from = '+'.$sms_sender; //trial account twilio number
		$to = '+'.$sms_reciever; //sms recipient number
		$response = $this->twilio->sms($from, $to,$sms_message); 
		if($response->IsError){ 
			echo 'Sms Has been Not sent';
		}
		else{ 
			echo 'Sms Has been sent';
		}
	}
	
}