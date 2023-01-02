<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Maintenance extends ERP_Controller {
    public function __construct() {
        parent::__construct();
        is_login();
        $this->load->library(array( 'form_validation'));
		//$this->load->helper('crm/crm');
        $this->load->model('maintenance_model');
		$this->settings['css'][]= 'assets/plugins/google-code-prettify/bin/prettify.min.css';
		$this->settings['css'][] = 'assets/modules/maintenance/css/style.css';
		$this->scripts['js'][] = 'assets/plugins/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js';
		$this->scripts['js'][] = 'assets/plugins/jquery.hotkeys/jquery.hotkeys.js';
		$this->scripts['js'][] = 'assets/plugins/google-code-prettify/src/prettify.js';
		$this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
		$this->scripts['js'][] = 'assets/plugins/switchery/dist/switchery.min.js';
		# for Graph
		$this->scripts['js'][] = 'assets/plugins/fastclick/lib/fastclick.js';
		$this->scripts['js'][] = 'assets/plugins/nprogress/nprogress.js';  
		$this->scripts['js'][] = 'assets/plugins/raphael/raphael.min.js';
		$this->scripts['js'][] = 'assets/plugins/morris.js/morris.min.js';		
		$this->scripts['js'][] = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';		
		$this->scripts['js'][] = 'assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js';		
		$this->scripts['js'][] = 'assets/modules/maintenance/js/script.js';
        $this->load->library('CSVReader');//load PHPExcel library 
		//$this->load->model('upload_model');//To Upload file in a directory
           $this->load->model('maintenance_model');


       $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;



    }

public function index(){

	
}

public function dashboard(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Maintenance', base_url() . 'dashboard');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Dashboard';
		$this->data['user_dashboard']  = $this->maintenance_model->get_data_dashboard('user_dashboard',array('user_id' => $_SESSION['loggedInUser']->id));
		$this->_render_template('dashboard/index', $this->data);
    }


 /*dashboard*/
	public function graphDashboardData(){
		if(!empty($_POST)) {
			$startDate = $_POST['startDate'];
			$endDate = $_POST['endDate'];
		}else{
			$startDate =  $endDate = '' ;
		}
		$graphDashboardArray=array();
		$getPoductionDataListingGraph = getPoductionDataListingGraph($startDate, $endDate);
		//re($getPoductionDataListingGraph);
		$getProductionPlanning = getProductionPlanning($startDate, $endDate);
		//$getComparison = getComparison($startDate, $endDate);
		
		//$getDashboardCount = getDashboardCount($startDate, $endDate);
		$graphDashboardArray = array('getPoductionDataListingGraph' => $getPoductionDataListingGraph , 'getProductionPlanning' => $getProductionPlanning );
		
		//pre($graphDashboardArray);die;
			
			
		echo json_encode($graphDashboardArray);
	}



/*add mantance*/

public function breakdown(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Maintenance', base_url() . 'maintenance');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Breakdown Maintenance List';
		$this->data['user_breakdown']  = $this->maintenance_model->get_data_breakdown('add_bd_request',array('user_id' => $_SESSION['loggedInUser']->id));
		$this->_render_template('addmaintenance/index', $this->data);
    }

   public function addmaintenance(){

        $this->data['user_breakdown']  = $this->maintenance_model->get_data_breakdown('add_bd_request',array('user_id' => $_SESSION['loggedInUser']->id));
		$this->load->view('addmaintenance/addmaintenance', $this->data);
    }

    
    public function addsimiller(){
		
		$this->data['addsimilerdata'] = $this->maintenance_model->get_data_byId('add_bd_request','id',$this->input->post('id'));
		$this->load->view('addmaintenance/addsimiller', $this->data);
    }

   public function savebreakdown(){
		$data  = $this->input->post();
		$data['created_by'] = $_SESSION['loggedInUser']->u_id;
		$data['created_by_cid'] = $this->companyGroupId;
		$insertdata = $this->maintenance_model->insert_bd_data('add_bd_request',$data);
        
        if($insertdata == true){
        	$this->session->set_flashdata('message', 'Breakdown Request inserted successfully');
					redirect(base_url().'maintenance/breakdown', 'refresh');
				}else{
                    
                    $this->session->set_flashdata('error', 'Breakdown Request Not inserted successfully');
					redirect(base_url().'maintenance/breakdown', 'refresh');

				}
 
    }

    public function editmaintenance(){

		$this->data['editbddata'] = $this->maintenance_model->get_data_byId('add_bd_request','id',$this->input->post('id'));

		$this->data['user_breakdown']  = $this->maintenance_model->get_data_breakdown('add_bd_request',array('user_id' => $_SESSION['loggedInUser']->id));

		$this->load->view('addmaintenance/editmaintenance', $this->data);
    }

    public function updatebreakdown(){

    	$id  = $this->input->post('id');
		$data  = $this->input->post();
		$data['created_by'] = $_SESSION['loggedInUser']->u_id;
		$data['created_by_cid'] = $this->companyGroupId;
		
		if($id !=''){

					//$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->maintenance_model->update_bd_data('add_bd_request',$data, 'id', $id);
	
					if ($success) {

                        $this->session->set_flashdata('message', 'Breakdown Request Updated successfully');
					    redirect(base_url().'maintenance/breakdown', 'refresh');

                    }else{
                        
                        $this->session->set_flashdata('error', 'Breakdown Request Not Updated successfully');
					    redirect(base_url().'maintenance/breakdown', 'refresh');

                    }
				}
 
    }


    public function viewmaintenance(){

		$this->data['viewbreakdown'] = $this->maintenance_model->get_data_byId('add_bd_request','id',$this->input->post('id'));
		$this->load->view('addmaintenance/viewmaintenance', $this->data);

		if($this->input->post('id') != ''){
			permissions_redirect('is_view');
		}
		
   }


   public function deletemaintenance($id=''){
     if (!$id) {
           redirect('maintenance/breakdown', 'refresh');
        }
		//permissions_redirect('is_delete');
        $result = $this->maintenance_model->delete_bd_data('add_bd_request','id',$id);
		if($result) {

       	$this->session->set_flashdata('message', 'Breakdown Request Delete successfully');
					    redirect(base_url().'maintenance/breakdown', 'refresh');

       }else{

         $this->session->set_flashdata('error', 'Breakdown Request Not Delete successfully');
					    redirect(base_url().'maintenance/breakdown', 'refresh');

       }

     }
   	


    


}

