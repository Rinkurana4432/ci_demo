 <?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Hrm_task extends ERP_Controller {
    function __construct() {
        parent::__construct();
        $dynamicdb = $this->load->database();
         $this->load->helper('daily_report_inventory_helper');
        $this->load->model('dailyreport_inventory_model');
        $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
    }/*Automatic Task Creation HRM*/

  public function switch_db_dinamico($name_db){
        $config_app['hostname'] = 'lastingerp-instance-1.cihrq4rjnxlt.ap-south-1.rds.amazonaws.com';
        $config_app['username'] = 'lastingerp';
        $config_app['password'] = '!lastingerpamitaerp!';
        $config_app['database'] = $name_db;
        $config_app['dbdriver'] = 'mysqli';
        $config_app['dbprefix'] = '';
        $config_app['pconnect'] = FALSE;
        $config_app['db_debug'] = (ENVIRONMENT !== 'production'); 
        $config_app['save_queries'] = true;
        $config_app['db_debug'] = FALSE;
        $config_app['cache_on'] = FALSE;
        $config_app['cachedir'] = '';
        $config_app['char_set'] = 'utf8mb4';
        $config_app['dbcollat'] = 'utf8mb4_unicode_ci';
        $config_app['swap_pre'] = '';
        $config_app['encrypt'] = FALSE;
        $config_app['compress'] = FALSE;
        $config_app['stricton'] = FALSE;
        $config_app['failover'] = array();
        $config_app['save_queries'] = TRUE;
        return $config_app;
    }   

public function create_task_list(){
       $config_app  = $this->switch_db_dinamico('lerp_ntc_concrete_products');
	
        $this->data['get_task_list'] = $this->dailyreport_inventory_model->get_task_list($config_app,
              'new_work_detail',['repeat_task'=>1,'repeatation_days!='=>0]);
			 
        foreach($this->data['get_task_list'] as $values){
          $date=date('Y-m-d', strtotime($values->start_date. ' + '.$values->repeatation_days.' days'));
          $current_date=date('Y-m-d');
          //$current_date=date('2021-11-22');
          if($values->repeatation_on_off==0){
            $verify_status_date=strtotime(date('Y-m-d', strtotime($values->update_date)));
            $start_date=strtotime(date('Y-m-d', strtotime($values->start_date)));
            if($values->pipeline_status==4 && $verify_status_date>$start_date){
                $diffstartsandcurrentdate = strtotime($current_date. ' - 1 days') - $start_date;
                if(round(($verify_status_date - $start_date) / (60 * 60 * 24))>$values->repeatation_days){
                    $quotient=floor(round($diffstartsandcurrentdate / (60 * 60 * 24))/$values->repeatation_days);
                    $repeatation_days=(round($quotient)*$values->repeatation_days)+$values->repeatation_days;
                    if(date('Y-m-d', strtotime($values->start_date. ' + '.$repeatation_days.' days'))>date('Y-m-d', $verify_status_date)){
                      $date=date('Y-m-d', strtotime($values->start_date. ' + '.$repeatation_days.' days'));
                    }
                }
            }
            //echo "<pre>".$date.'-----'.$values->description;
            if($date==$current_date && $values->pipeline_status==4){
              $data['assigned_to'] = $values->assigned_to;
              $data['superviser'] = $values->superviser;
              $data['task_name'] = $values->task_name;
              $data['description'] = $values->description;
              $data['pipeline_status'] =1;
              $data['task_done']=0;
              $data['start_date'] = $date;
              // $data['due_date'] =$due_date;
              $data['npdm'] = isset($values->npdm);
              $data['attachment'] = $values->attachment;
              $data['repeat_task'] = $values->repeat_task;
              $data['repeatation_days'] = $values->repeatation_days;
              $data['repeatation_on_off'] = 0;
              $data['created_by'] = $values->created_by;
              $data['created_by_cid'] = $values->created_by_cid;
              //if($values->task_name=='task one 23 date'){
                $duplicate_data=$this->dailyreport_inventory_model->get_repeted_duplicate_task($config_app, 'new_work_detail',['task_name'=>$values->task_name]);
                  $inserted_id = $this->dailyreport_inventory_model->insert_tbl_data($config_app,'new_work_detail', $data);
                if($inserted_id){
                  $this->dailyreport_inventory_model->updateData($config_app, 'new_work_detail', $duplicate_data);
                }
              //}
            }
          }
        }
    }
}