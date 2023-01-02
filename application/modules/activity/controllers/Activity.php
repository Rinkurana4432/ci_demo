<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Activity extends ERP_Controller{
	
	public function __construct(){
		parent::__construct();
		is_login();
		$this->load->model('activity_model');
		#$this->load->helper('activity/activity');
		$this->load->library(array('form_validation'));
		$this->settings['parent_menu'] = 'activities';
	}

	
	/* Main Function to fetch all the listing of announcements */
	public function index(){
	  	$this->settings['module_title'] = 'Activity';
		$this->data['activities']  = $this->activity_model->get_data('activity_log');
		$this->_render_template('activity/index', $this->data);
	}

	
	
	/* Function to clear activity log from database */
	public function clear_activity_log(){
       if (is_admin()){
            $result = $this->db->empty_table('activity_log');
			if($result) {	
				$this->session->set_flashdata('message',  'Activity Log Cleared Successfully');
				$result = array('msg' => 'Activity Logs Deleted', 'status' => 'success', 'code' => 'C288','url' => base_url().'activity');
				echo json_encode($result);
			} 
        }
		else {
				echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C292'));
		}       
    }
	

	
	

}

