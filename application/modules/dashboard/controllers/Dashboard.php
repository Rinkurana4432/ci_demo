<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends ERP_Controller {
	public function __construct(){
		parent::__construct();		
		is_login();
        $this->load->library(array( 'form_validation'));
		//$this->load->helper('crm/crm');
      //  $this->load->model('crm/crm_model');
        $this->load->model('inventory/inventory_model');
        $this->load->helper('inventory/inventory');
        $this->load->model('dashboard_model');
		$this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
		$this->settings['css'][] = 'assets/plugins/morris.js/morris.css';
		$this->settings['css'][]= 'assets/plugins/google-code-prettify/bin/prettify.min.css';
		$this->settings['css'][]= 'assets/modules/dashboard/css/style.css';
		$this->scripts['js'][] = 'assets/plugins/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js';
		$this->scripts['js'][] = 'assets/plugins/jquery.hotkeys/jquery.hotkeys.js';
		$this->scripts['js'][] = 'assets/plugins/google-code-prettify/src/prettify.js';
		# for Graph
		$this->scripts['js'][] = 'assets/plugins/fastclick/lib/fastclick.js';
		$this->scripts['js'][] = 'assets/plugins/nprogress/nprogress.js';
		$this->scripts['js'][] = 'assets/plugins/raphael/raphael.min.js';
		$this->scripts['js'][] = 'assets/plugins/morris.js/morris.min.js';		
		$this->scripts['js'][] = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';		
		#$this->scripts['js'][] = 'assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js';	
		$this->scripts['js'][] = 'assets/plugins/echarts/dist/echarts.min.js';		
		#for graph
		$this->scripts['js'][] = 'assets/modules/dashboard/js/script.js';
		#$this->scripts['js'][] = 'assets/modules/crm/js/script.js';
		#$this->scripts['js'][] = 'assets/modules/account/js/script.js';
		
		if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
			redirect( base_url().'company/view/', 'refresh');
		}

		
		
		
		
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){
		$this->breadcrumb->add('', base_url() . 'dashboard');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Dashboard';
		$where = array('inventory_listing.created_by_cid' => $_SESSION['loggedInUser']->c_id);
		$this->data['materialMove']  = $this->inventory_model->get_data_Move('inventory_listing',$where);		
		$where = array('inventory_listing.created_by_cid' => $_SESSION['loggedInUser']->c_id);
		$this->data['materialDonotMove']  = $this->inventory_model->get_data_Not_Move('material',$where);
		
		$getPermissions = getPermissionsForDashboard(array('permissions.user_id' => $_SESSION['loggedInUser']->id,'modules.id'=>5,'permissions.is_view'=>1));
		$this->data['contactGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;
		$this->data['accountGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;
		$this->data['saleOrderGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;	
		
		
		$this->data['user_dashboard']  = $this->dashboard_model->get_data('user_dashboard',array('user_id' => $_SESSION['loggedInUser']->id));
		#pre($this->data['user_dashboard']);
		$this->_render_template('index',$this->data);
	}
}
