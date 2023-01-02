<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Logistics extends ERP_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            redirect( base_url().'auth/login', 'refresh');
        }
	
        $this->load->library(array( 'form_validation'));

		// $this->load->helper('logistics/logistics');
        // $this->load->model('logistics_model');
		$this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
		$this->settings['css'][] = 'assets/plugins/ion.rangeSlider/css/ion.rangeSlider.css';
		$this->settings['css'][] = 'assets/plugins/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css';
		$this->settings['css'][] = 'assets/modules/logistics/css/style.css';
		//$this->settings['css'][] = 'assets/css/new-style.css';
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
		$this->scripts['js'][] = 'assets/modules/logistics/js/script.js';
		


		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


	}

    /* Main Function to fetch all the listing of departments */
    public function create(){
		
		$this->load->helper('url');
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Create', base_url() . 'Create');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Dispatch Order List';
		// $created_id = $_SESSION['loggedInUser']->u_id;
		$this->_render_template('create/index', $this->data);
		//$this->load->view('create/index');
	}
	
	 public function add_saleorder(){
		
		$this->load->helper('url');
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Create', base_url() . 'Create');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Sale Order List';
		// $created_id = $_SESSION['loggedInUser']->u_id;
		$this->_render_template('create/add_saleorder', $this->data);
		//$this->load->view('create/index');
	}
	
	
	 public function saleorder_view(){
		
		$this->load->helper('url');
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Create', base_url() . 'Create');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Sale Order View';
		// $created_id = $_SESSION['loggedInUser']->u_id;
		$this->_render_template('create/saleorder_view', $this->data);
		//$this->load->view('create/index');
	}
	
	
	 public function Create_Label(){
		
		$this->load->helper('url');
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Create', base_url() . 'Create');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Label List';
		// $created_id = $_SESSION['loggedInUser']->u_id;
		$this->_render_template('create/Create_Label', $this->data);
		//$this->load->view('create/index');
	}
	
	 public function lables(){
		    $this->load->library('Pdf');  
		    
		    $this->load->view('create/lables');
	}	
	
}	
	