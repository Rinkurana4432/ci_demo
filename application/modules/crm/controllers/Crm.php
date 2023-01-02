<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Crm extends ERP_Controller {
    /* Controller Start */
    public function __construct() {
        parent::__construct();
        is_login();
        $this->load->library(array('form_validation'));
        $this->load->helper('crm/crm');
        $this->load->model('crm_model');
        $this->settings['css'][] = 'assets/plugins/google-code-prettify/bin/prettify.min.css';
        $this->settings['css'][] = 'assets/modules/crm/css/style.css';
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
        $this->scripts['js'][] = 'assets/plugins/daypilot/daypilot-all.min.js';
        #for Print
        $this->scripts['js'][] = 'assets/modules/crm/js/print.js';
        #for wsywig editor
        $this->scripts['js'][] = 'assets/modules/crm/js/ckeditor/ckeditor.js';
        $this->scripts['js'][] = 'assets/modules/crm/js/ckeditor/ckeditor.js';
        $this->settings['css'][] = 'assets/modules/crm/css/zooming.css';
        $this->scripts['js'][] = 'assets/modules/crm/js/script.js';
        $this->load->library('CSVReader'); //load PHPExcel library
        //$this->load->model('upload_model');//To Upload file in a directory
        // $this->load->model('excel_data_insert_model');
        $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
		 $CI =& get_instance();
		 $CI->createTableColumn('company_detail','priceLISTONOFF',"INT(11) NOT NULL DEFAULT '0'  AFTER crm_delivery_setting");
		 $CI->createTableColumn('company_detail','ledger_crdit_limtOnOff',"INT(11) NOT NULL DEFAULT '0'  AFTER priceLISTONOFF");
         $CI->createTableColumn('sale_order','freightCharges',"INT(150) NULL DEFAULT NULL AFTER freight");
         $CI->createTableColumn('proforma_invoice','freightCharges',"INT(150) NULL DEFAULT NULL AFTER freight");
 
    }

	 public function createTableColumn($table,$column,$defineColumType){
        $ci =& get_instance();


        $data = $ci->db->query("SHOW COLUMNS FROM  {$table} LIKE '{$column}'")->row_array();
        if( empty($data) ){
            $ci->db->query("ALTER TABLE {$table}  ADD {$column} {$defineColumType}");
        }


        $dynamicdb = $ci->load->database('dynamicdb', TRUE);
        $datachild = $dynamicdb->query("SHOW COLUMNS FROM  {$table} LIKE '{$column}'")->row_array();
        if( empty($datachild) ){
            $dynamicdb->query("ALTER TABLE {$table}  ADD {$column} {$defineColumType}");
        }


    }
    /* Main Function to fetch all the listing of leads */
    public function index() {
        $this->leads();
    }
    # Main Function to fetch all the listing of leads in datatable
    /*  public function leads(){

    $this->data['can_edit'] = edit_permissions();

    $this->data['can_view'] = view_permissions();

    $this->data['can_delete'] = delete_permissions();

    $this->data['can_add'] = add_permissions();

    $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');

    $this->breadcrumb->add('Leads', base_url() . 'crm/leads');

    $this->settings['breadcrumbs'] = $this->breadcrumb->output();

    $this->settings['pageTitle'] = 'Leads';

    $this->data['leadStatus'] = $this->crm_model->get_data('lead_status');

    //$this->data['lead_owner'] = $this->crm_model->get_data('user_detail',array("c_id"=>$_SESSION['loggedInUser']->c_id));



    $this->data['lead_owner'] = $this->crm_model->get_data('user_detail',array("c_id"=>$this->companyGroupId));

    //pre($_POST);









    if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' ) {



    //$inProcessWhere = array('leads.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6);





    $inProcessWhere = array('leads.created_by_cid' => $this->companyGroupId , 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6);







    //$complete_leads_where = array('leads.created_by_cid' => $_SESSION['loggedInUser']->c_id, 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3);



    $complete_leads_where = array('leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3);





    $this->data['in_process_leads'] = $this->crm_model->get_own_tbl_data('leads', $inProcessWhere,'','lead_owner');

    $this->data['complete_leads'] = $this->crm_model->get_own_tbl_data('leads', $complete_leads_where,'','lead_owner');

    //$this->_render_template('leads/index', $this->data);

    }elseif(!empty($_POST) && isset($_POST['start']) &&  isset($_POST['end']) ){



    //$inProcessWhere = array('leads.created_date >=' => $_POST['start'] , 'leads.created_date <=' => $_POST['end'], 'leads.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6 );





    $inProcessWhere = array('leads.created_date >=' => $_POST['start'] , 'leads.created_date <=' => $_POST['end'], 'leads.created_by_cid' => $this->companyGroupId , 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6 );





    //$complete_leads_where = array('leads.created_date >=' => $_POST['start'] , 'leads.created_date <=' => $_POST['end'],'leads.created_by_cid' => $_SESSION['loggedInUser']->c_id, 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3);





    $complete_leads_where = array('leads.created_date >=' => $_POST['start'] , 'leads.created_date <=' => $_POST['end'],'leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3);



    }else{



    //$inProcessWhere = array('leads.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'leads.lead_status!= ' => 4,'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6);





    $inProcessWhere = array('leads.created_by_cid' => $this->companyGroupId , 'leads.lead_status!= ' => 4,'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6);







    //$complete_leads_where = array('leads.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3);





    $complete_leads_where = array('leads.created_by_cid' => $this->companyGroupId , 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3);

    }



    # if view permission is disabled than the user can see only his leads

    if(!empty($this->data['permissions']) && $this->data['permissions']->is_view == 0){



    $this->data['in_process_leads'] = $this->crm_model->get_own_tbl_data('leads', $inProcessWhere,'','lead_owner');

    $this->data['complete_leads'] = $this->crm_model->get_own_tbl_data('leads', $complete_leads_where,'','lead_owner');

    }else if((!empty($this->data['permissions']) && $this->data['permissions']->is_view == 1) ||  ($_SESSION['loggedInUser']->role == 3 || $_SESSION['loggedInUser']->role == 1 ) ){



    # if view permission is enabled than users can see leads of others also

    $this->data['in_process_leads']  = $this->crm_model->get_tbl_data('leads', $inProcessWhere);

    $this->data['auto_leads']  = $this->crm_model->get_matched_data('rfq');

    $this->data['complete_leads']  = $this->crm_model->get_tbl_data('leads',$complete_leads_where);

    }





    #pre($this->data['complete_leads']);



    if (isset($_POST['favourites']) ){



    //$inProcessWhere = array('leads.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6 ,'favourite_sts'=> 1);





    $inProcessWhere = array('leads.created_by_cid' => $this->companyGroupId , 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6 ,'favourite_sts'=> 1);





    //$complete_leads_where = array('leads.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3 ,'favourite_sts'=> 1);



    $complete_leads_where = array('leads.created_by_cid' =>$this->companyGroupId , 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3 ,'favourite_sts'=> 1);





    $this->data['in_process_leads'] = $this->crm_model->get_tbl_data('leads', $inProcessWhere,'','lead_owner');

    $this->data['complete_leads'] = $this->crm_model->get_tbl_data('leads', $complete_leads_where,'','lead_owner');



    $this->_render_template('leads/index', $this->data);

    }

    else{



    if(!empty($_POST)){

    $this->_render_template('leads/index', $this->data);

    }else{

    $this->_render_template('leads/index', $this->data);

    }



    }



    } */
    public function leads() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Leads', base_url() . 'crm/leads');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Leads';
        $this->data['leadStatus'] = $this->crm_model->get_data('lead_status');
        $this->data['lead_owner'] = $this->crm_model->get_data('user_detail', array("c_id" => $this->companyGroupId));
        if (empty($_GET['tab']) || !empty($_GET['tab']) == 'inProcess_leads' || !empty($_GET['tab']) == 'complete_leadss' || !empty($_GET['tab']) == 'auto_leadss') {
            $inProcessWhere = array('leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6);
            $complete_leads_where = array('leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3);
            $auto_leads_where = array('rfq.company_ids like "%' . $this->companyGroupId . '%"');
            $bid_mangment_where = array('register_opportunity.created_by_cid' => $this->companyGroupId);
        }
        if (isset($_GET['favourites']) != '' && isset($_GET['ExportType']) == '') {
            if ($_GET['tab'] == 'inProcess_leads') {
                $inProcessWhere = array('leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6, 'favourite_sts' => 1);
            } else if ($_GET['tab'] == 'complete_leadss') {
                $complete_leads_where = array('leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3, 'favourite_sts' => 1);
            } else if ($_GET['tab'] == 'auto_leadss') {
                $auto_leads_where = array('rfq.company_ids like "%' . $this->companyGroupId . '%"');
            } else if ($_GET['tab'] == 'bid_mangment') {
                $bid_mangment_where = array('register_opportunity.created_by_cid' => $this->companyGroupId, 'favourite_sts' => 1);
            } else {
                $inProcessWhere = array('leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6, 'favourite_sts' => 1);
            }
        }
        if (isset($_GET['start']) != '' && $_GET['end'] != '' && isset($_GET['favourites']) == '') {
            if ($_GET['tab'] == 'inProcess_leads') {
                $inProcessWhere = array('leads.created_date >=' => $_GET['start'], 'leads.created_date <=' => $_GET['end'], 'leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6);
            } else if ($_GET['tab'] == 'complete_leadss') {
                $complete_leads_where = array('leads.created_date >=' => $_GET['start'], 'leads.created_date <=' => $_GET['end'], 'leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3);
            } else if ($_GET['tab'] == 'auto_leadss') {
                $auto_leads_where = array('rfq.company_ids like "%' . $this->companyGroupId . '%"', 'rfq.created_date >=' => $_GET['start'], 'rfq.created_date <=' => $_GET['end']);
            } else if ($_GET['tab'] == 'bid_mangment') {
                $bid_mangment_where = array('register_opportunity.created_by_cid' => $this->companyGroupId, 'register_opportunity.created_date >=' => $_GET['start'], 'register_opportunity.created_date <=' => $_GET['end']);
            } else {
                $inProcessWhere = array('leads.created_date >=' => $_GET['start'], 'leads.created_date <=' => $_GET['end'], 'leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6);
            }
        }
        if (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites'] == '') {
            if ($_GET['tab'] == 'inProcess_leads') {
                $inProcessWhere = array('leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6);
            } else if ($_GET['tab'] == 'complete_leadss') {
                $complete_leads_where = array('leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3);
            } else if ($_GET['tab'] == 'auto_leadss') {
                $auto_leads_where = array('rfq.company_ids like "%' . $this->companyGroupId . '%"');
            } else if ($_GET['tab'] == 'bid_mangment') {
                $bid_mangment_where = array('register_opportunity.created_by_cid' => $this->companyGroupId);
            } else {
                $inProcessWhere = array('leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6);
            }
        } else if (isset($_GET["ExportType"]) != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['favourites'] == '') {
            if ($_GET['tab'] == 'inProcess_leads') {
                $inProcessWhere = array('leads.created_date >=' => $_GET['start'], 'leads.created_date <=' => $_GET['end'], 'leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6);
            } else if ($_GET['tab'] == 'complete_leadss') {
                $complete_leads_where = array('leads.created_date >=' => $_GET['start'], 'leads.created_date <=' => $_GET['end'], 'leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3);
            } else if ($_GET['tab'] == 'auto_leadss') {
                $auto_leads_where = array('rfq.company_ids like "%' . $this->companyGroupId . '%"', 'rfq.created_date >=' => $_GET['start'], 'rfq.created_date <=' => $_GET['end']);
            } else if ($_GET['tab'] == 'bid_mangment') {
                $bid_mangment_where = array('register_opportunity.created_by_cid' => $this->companyGroupId, 'register_opportunity.created_date >=' => $_GET['start'], 'register_opportunity.created_date <=' => $_GET['end']);
            } else {
                $inProcessWhere = array('leads.created_date >=' => $_GET['start'], 'leads.created_date <=' => $_GET['end'], 'leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6);
            }
        } elseif (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites'] != '') {
            if ($_GET['tab'] == 'inProcess_leads') {
                $inProcessWhere = array('leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6, 'favourite_sts' => 1);
            } else if ($_GET['tab'] == 'complete_leadss') {
                $complete_leads_where = array('leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3, 'favourite_sts' => 1);
            } else if ($_GET['tab'] == 'auto_leadss') {
                $auto_leads_where = array('rfq.company_ids like "%' . $this->companyGroupId . '%"');
            } else if ($_GET['tab'] == 'bid_mangment') {
                $bid_mangment_where = array('register_opportunity.created_by_cid' => $this->companyGroupId, 'favourite_sts' => 1);
            } else {
                $inProcessWhere = array('leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 4, 'leads.lead_status != ' => 5, 'leads.lead_status !=' => 6, 'favourite_sts' => 1);
            }
        }
        //Search
        $where2 = '';
        $where3 = '';
        $where4 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            if (isset($_GET['tab']) == 'inProcess_leads') {
                $where2 = "(leads.id like '%" . $search_string . "%' or leads.first_name like '%" . $search_string . "%' or leads.company like '%" . $search_string . "%')";
            } else if (isset($_GET['tab']) == 'complete_leadss') {
                $where2 = "(leads.id like '%" . $search_string . "%' or leads.first_name like '%" . $search_string . "%' or leads.company like '%" . $search_string . "%')";
            } else if (isset($_GET['tab']) == 'auto_leadss') {
                $where3 = "(rfq.id like '%" . $search_string . "%')";
            } else if (isset($_GET['tab']) == 'bid_mangment') {
                $where4 = "(register_opportunity.id like '%" . $search_string . "%')";
            } else {
                $where2 = "(leads.id like '%" . $search_string . "%' or leads.first_name like '%" . $search_string . "%' or leads.company like '%" . $search_string . "%' or `leads`.`contacts` like '[{first_name:" % $search_string % "}])";
            }
            //$where2=" rfq.id like '%".$search_string."%' or leads.id like '%".$search_string."%'" ;
            redirect("crm/leads/?search=$search_string");
        } else if (isset($_GET['search'])) {
            if (isset($_GET['tab']) == 'inProcess_leads' && $_GET['tab'] != 'complete_leadss' && $_GET['tab'] != 'auto_leadss' && $_GET['tab'] != 'bid_mangment') {
                $str = str_replace(' ', '%', $_GET['search']);
                $where2 = "(leads.id like '%" . $_GET['search'] . "%' or leads.company like '%" . $_GET['search'] . "%' or `leads`.`contacts` like '[{\"first_name\":\"%" . $str . "%\"}]')";
            } else if (isset($_GET['tab']) == 'complete_leadss' && $_GET['tab'] != 'inProcess_leads' && $_GET['tab'] != 'auto_leadss' && $_GET['tab'] != 'bid_mangment') {
                $str = str_replace(' ', '%', $_GET['search']);
                $where2 = "(leads.id like '%" . $_GET['search'] . "%' or leads.first_name like '%" . $_GET['search'] . "%' or leads.company like '%" . $_GET['search'] . "%' or `leads`.`contacts` like '[{\"first_name\":\"%" . $str . "%\"}]' or `leads`.`contacts` like '[{\"first_name\":\"%" . $_GET['search'] . "%\"}]')";
            } else if (isset($_GET['tab']) == 'auto_leadss' && $_GET['tab'] != 'complete_leadss' && $_GET['tab'] != 'inProcess_leads' && $_GET['tab'] != 'bid_mangment') {
                $where3 = "(rfq.id like '%" . $_GET['search'] . "%' or rfq.contacts like '%" . $_GET['search'] . "%')";
            } else if (isset($_GET['tab']) == 'bid_mangment' && $_GET['tab'] != 'complete_leadss' && $_GET['tab'] != 'auto_leadss' && $_GET['tab'] != 'inProcess_leads') {
                $where4 = "(register_opportunity.id like '%" . $_GET['search'] . "%' or register_opportunity.tender_detail like '[{\"tender_name\":%" . $_GET['search'] . "%}]')";
            } else {
                $where2 = "(leads.id like '%" . $_GET['search'] . "%' or `leads`.`contacts` like '[{\"first_name\":\"%" . $str . "%\"}]' or `leads`.`contacts` like '[{\"first_name\":\"%" . $_GET['search'] . "%\"}]' or leads.company like '%" . $_GET['search'] . "%')";
            }
        }
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = "desc";
        }
        if (isset($_GET['tab']) == 'inProcess_leads' && $_GET['tab'] != 'complete_leadss' && $_GET['tab'] != 'auto_leadss' && $_GET['tab'] != 'bid_mangment') {
            $rows = $this->crm_model->tot_rows('leads', $inProcessWhere, $where2);
        } elseif (isset($_GET['tab']) == 'complete_leadss' && $_GET['tab'] != 'inProcess_leads' && $_GET['tab'] != 'auto_leadss' && $_GET['tab'] != 'bid_mangment') {
            $rows = $this->crm_model->tot_rows('leads', $complete_leads_where, $where2);
        } elseif (isset($_GET['tab']) == 'auto_leadss' && $_GET['tab'] != 'inProcess_leads' && $_GET['tab'] != 'complete_leadss' && $_GET['tab'] != 'bid_mangment') {
            $rows = $this->crm_model->tot_rows('rfq', $auto_leads_where, $where3);
        } elseif (isset($_GET['tab']) == 'bid_mangment' && $_GET['tab'] != 'inProcess_leads' && $_GET['tab'] != 'complete_leadss' && $_GET['tab'] != 'auto_leadss') {
            $rows = $this->crm_model->tot_rows('register_opportunity', $bid_mangment_where, $where4);
        } else {
            $rows = $this->crm_model->tot_rows('leads', $inProcessWhere, $where2);
        }
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "crm/leads";
        $config["total_rows"] = $rows;
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $config['anchor_class'] = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        if ($this->data['permissions']->is_view == 0) {
            $this->data['in_process_leads'] = $this->crm_model->get_data_listing('leads', $inProcessWhere, $config["per_page"], $page, $where2, $order, $export_data);
            $this->data['complete_leads'] = $this->crm_model->get_data_listing('leads', $complete_leads_where, $config["per_page"], $page, $where2, $order, $export_data);
            $this->data['auto_leads'] = $this->crm_model->get_data_listing('rfq', $auto_leads_where, $config["per_page"], $page, $where3, $order, $export_data);
            $this->data['register_opportunity'] = $this->crm_model->get_data_listing('register_opportunity', $bid_mangment_where, $config["per_page"], $page, $where4, $order, $export_data);
        } else {
            # if view permission is enabled than users can see leads of others also
            if (isset($_GET['tab']) == 'inProcess_leads' && $_GET['tab'] != 'complete_leadss' && $_GET['tab'] != 'auto_leadss' && $_GET['tab'] != 'bid_mangment') {
                $this->data['in_process_leads'] = $this->crm_model->get_data_listing('leads', $inProcessWhere, $config["per_page"], $page, $where2, $order, $export_data);
            } elseif (isset($_GET['tab']) == 'complete_leadss' && $_GET['tab'] != 'inProcess_leads' && $_GET['tab'] != 'auto_leadss' && $_GET['tab'] != 'bid_mangment') {
                $this->data['complete_leads'] = $this->crm_model->get_data_listing('leads', $complete_leads_where, $config["per_page"], $page, $where2, $order, $export_data);
            } elseif (isset($_GET['tab']) == 'auto_leadss' && $_GET['tab'] != 'inProcess_leads' && $_GET['tab'] != 'complete_leadss' && $_GET['tab'] != 'bid_mangment') {
                $this->data['auto_leads'] = $this->crm_model->get_data_listing('rfq', $auto_leads_where, $config["per_page"], $page, $where3, $order, $export_data);
            } elseif (isset($_GET['tab']) == 'bid_mangment' && $_GET['tab'] != 'inProcess_leads' && $_GET['tab'] != 'complete_leadss' && $_GET['tab'] != 'auto_leadss') {
                $this->data['register_opportunity'] = $this->crm_model->get_data_listing('register_opportunity', $bid_mangment_where, $config["per_page"], $page, $where4, $order, $export_data);
            } else {
                $this->data['in_process_leads'] = $this->crm_model->get_data_listing('leads', $inProcessWhere, $config["per_page"], $page, $where2, $order, $export_data);
            }
        }

        // if(!empty($this->data['permissions']) && $this->data['permissions']->is_view == 0){

        //     $this->data['in_process_leads'] = $this->crm_model->get_own_tbl_data('leads', $inProcessWhere,'','lead_owner');
        //     $this->data['complete_leads'] = $this->crm_model->get_own_tbl_data('leads', $complete_leads_where,'','lead_owner');
        // }else if((!empty($this->data['permissions']) && $this->data['permissions']->is_view == 1) ||  ($_SESSION['loggedInUser']->role == 3 || $_SESSION['loggedInUser']->role == 1 ) ){

        //     # if view permission is enabled than users can see leads of others also
        //     $this->data['in_process_leads']  = $this->crm_model->get_tbl_data('leads', $inProcessWhere);
        //     $this->data['auto_leads']  = $this->crm_model->get_matched_data('rfq');
        //     $this->data['complete_leads']  = $this->crm_model->get_tbl_data('leads',$complete_leads_where);
        // }
        $this->_render_template('leads/index', $this->data);
    }
    # Function to load add/edit lead page
    # Function to load add/edit lead page
    public function edit_lead() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['lead'] = $this->crm_model->get_data_byId('leads', 'id', $this->input->post('id'));
        $this->data['leadStatuses'] = $this->crm_model->get_data('lead_status');
        if ($this->input->post('id') != '') {
            $where = array('lead_id' => $this->input->post('id'));
            $lead_call_log = $this->crm_model->get_data('lead_activity', $where);
            $this->data['lead_activities'] = $lead_call_log;
        }
        //  $this->load->view('leads/edit', $this->data);
        $this->load->view('leads/edit_new', $this->data);
    }
    # Function to load view lead page
    public function viewLead() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_view');
        }
        $this->data['lead'] = $this->crm_model->get_data_byId('leads', 'id', $this->input->post('id'));
        if ($this->input->post('id') != '') {
            $where = array('lead_id' => $this->input->post('id'));
            $lead_call_log = $this->crm_model->get_data('lead_activity', $where);
            $this->data['lead_activities'] = $lead_call_log;
        }
        $this->load->view('leads/view', $this->data);
    }
    #  Function to insert/update lead
    public function saveLead() {
       // pre($this->input->post());die;
        if ($this->input->post()) {
            # required field server side validation
            $required_fields = array('first_name', 'company', 'email', 'phone_no', 'total', 'grandTotal');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                # If form is valid
                $data = $this->input->post();
                $contacts = count($_POST['first_name']);
                if ($contacts > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $contacts) {
                        $jsonArrayObject = array('first_name' => $_POST['first_name'][$i], 'last_name' => $_POST['last_name'][$i], 'email' => $_POST['email'][$i], 'phone_no' => $_POST['phone_no'][$i],'designation' => $_POST['designation'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $contact_array = json_encode($arr);
                } else {
                    $contact_array = '';
                }
                /*material detail save*/
                $countMaterial = count($_POST['material_name_id']);
                if ($countMaterial > 0) {
                    $materialarr = [];
                    $k = 0;
                    while ($k < $countMaterial) {
                        $MaterialArrayObject = array('material_type_id' => $_POST['material_type_id_val'][$k],'material_name_id' => $_POST['material_name_id'][$k], 'description' => $_POST['description'][$k], 'uom_material' => $_POST['uom_material'][$k], 'qty' => $_POST['qty'][$k], 'price' => $_POST['price'][$k], 'gst' => $_POST['gst'][$k], 'total' => $_POST['totals'][$k], 'TotalWithGst' => $_POST['TotalWithGsts'][$k]);
                        $materialarr[$k] = $MaterialArrayObject;
                        $k++;
                    }

                    $materialDetail_array = json_encode($materialarr);
                } else {
                    $materialDetail_array = '';
                }



                #pre($contact_array);
                #pre($materialDetail_array);die;

                // pre($_POST);
                // die;

                $data['totalwithoutgst'] = $_POST['total'];
                $data['grand_total'] = $_POST['grandTotal'];
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['contacts'] = $contact_array;
                $data['product_detail'] = $materialDetail_array;
                $data['lead_status'] = $data['lead_status'] ? $data['lead_status'] : 1;
                $id = $data['id'];
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 5));
                #pre($data);
                #die;
                if ($id && $id != '') {
                    # Edit lead
                    // pre($data);
                    // die;
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success = $this->crm_model->update_data('leads', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "lead updated successfully";
                        logActivity('Lead Updated', 'lead', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'Lead updated', 'message' => 'Lead updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'lead_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'Lead updated', 'message' => 'Lead updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'lead_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'Lead Updated successfully');
                        #redirect(base_url() . 'crm/leads', 'refresh');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                } else {
                    if (isset($_POST['is_npdm'])) {
                        $data12 = $this->input->post();
                        $data12['product_name'] = $_POST['product_name'];
                        $data12['product_require'] = $_POST['product_require'];
                        $data12['budget_assigned'] = $_POST['budget_assigned'];
                        $data12['end_date'] = $_POST['end_date'];
                        $data12['npdm_status'] = $_POST['npdm_status'];
                        $data12['created_by'] = $_SESSION['loggedInUser']->id;
                        $data12['created_by_cid'] = $this->companyGroupId;
                        $data12['created_date'] = date('y-m-d');
                        $id = $data12['id1'];
                        $this->crm_model->insert_tbl_data('npdm', $data12);
                    }
                    # Insert lead
                    #pre($_SESSION);
                    #die;
                    # $getdata = getNameById_leads('leads_status_history',$_POST['id'],'lead_id',$_POST['oldStatus']);
                    # pre($getdata->maxid);
                    # $this->crm_model->update_leads_history_enddates($getdata->maxid,date('Y-m-d'));
                    #pre($data);die;
                    $id = $this->crm_model->insert_tbl_data('leads', $data);
                    $data22['lead_id'] = $id;
                    $data22['status'] = $data['lead_status'];
                    $data22['start_date'] = date('Y-m-d');
                    $data22['created_by_cid'] = $this->companyGroupId;
                    if ($data['lead_status'] == 5) {
                        $data22['end_date'] = date('Y-m-d');
                    } else {
                        $data22['end_date'] = "0000-00-00";
                    }
                    #pre($data22);die;
                    $this->crm_model->insert_tbl_data('leads_status_history', $data22);
                    if ($id) {
                        logActivity('New Lead Created', 'lead', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'Lead created', 'message' => 'New Lead is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'lead_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'Lead created', 'message' => 'New Lead is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'lead_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'Lead inserted successfully');
                        #redirect(base_url() . 'crm/leads', 'refresh');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            }
        }
    }
    /*delete Lead */
    public function deleteLead($id = '') {
        if (!$id) {
            redirect('crm/leads', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->crm_model->delete_data('leads', 'id', $id);
        if ($result) {
            logActivity('Lead Deleted', 'leads', $id);
            $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 5));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Lead deleted', 'message' => 'Lead id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Lead deleted', 'message' => 'Lead id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
            }
            $this->session->set_flashdata('message', 'Lead Deleted Successfully');
            $result = array('msg' => 'Lead Deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/leads');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    /*  Function to add/update Lead activity */
    public function saveLeadActivity() {
        if ($this->input->post()) {
            $required_fields = array('subject', 'comment');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $id = $this->crm_model->insert_tbl_data('lead_activity', $data);
                if ($id) {
                    if ($data['activity_type'] != 'New task') {
                        change_new_task_status('lead_activity', 'lead_id', $data['lead_id']);
                    }
                    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                        $attachment_array = array();
                        $certificateCount = count($_FILES['attachment']['name']);
                        for ($i = 0;$i < $certificateCount;$i++) {
                            $filename = $_FILES['attachment']['name'][$i];
                            $tmpname = $_FILES['attachment']['tmp_name'][$i];
                            $type = $_FILES['attachment']['type'][$i];
                            $error = $_FILES['attachment']['error'][$i];
                            $size = $_FILES['attachment']['size'][$i];
                            $exp = explode('.', $filename);
                            $ext = end($exp);
                            $newname = $exp[0] . '_' . time() . "." . $ext;
							$newname = str_replace(' ', '_', $newname);;
                            $config['upload_path'] = 'assets/modules/crm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $id;
                            $attachment_array[$i]['rel_type'] = 'lead_activity';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array, 'crm/edit_lead/' . $data['lead_id']);
                        }
                    }
                    logActivity('New lead call log created', 'lead call log', $id);
                    $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 5));
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        //pushNotification(array('subject'=> 'Lead activity done' , 'message' => 'Lead activity done by '.$_SESSION['loggedInUser']->name'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id ,'class'=>'add_purchase_tabs','data_id' => 'lead_view','icon'=>'fa fa-shekel'));

                    }
                    $this->session->set_flashdata('message', 'Lead call log inserted successfully');
                    //redirect(base_url() . 'crm/leads', 'refresh');
					redirect($_SERVER['HTTP_REFERER']);
					// redirect(base_url() . 'crm/pipeline', 'refresh');
                }
            }
        }
    }
    /* Main Function to fetch all the listing of departments */
    /*  public function accounts(){

    $this->data['can_edit'] = edit_permissions();

    $this->data['can_delete'] = delete_permissions();

    $this->data['can_add'] = add_permissions();

    $this->data['can_view'] = view_permissions();

    $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');

    $this->breadcrumb->add('Company', base_url() . 'crm/accounts');

    $this->settings['breadcrumbs'] = $this->breadcrumb->output();

    $this->settings['pageTitle'] = 'Company';

    if (isset($_POST['favourites'])){

    $this->data['accounts'] = $this->crm_model->get_data('account',array('favourite_sts'=> 1 ,'account.account_owner'=> $this->companyGroupId));

    $this->_render_template('accounts/index', $this->data);

    }else{

    if(!empty($_POST) && isset($_POST['start']) &&  isset($_POST['end']) && !isset($_POST['ExportType'])){

    $where = array('account.created_date >=' => $_POST['start'] , 'account.created_date <=' => $_POST['end'],'account.account_owner'=> $this->companyGroupId);

    }elseif(!empty($_POST)  &&  $_POST['account_name'] !=''){

    $where = "account_owner = ".$this->companyGroupId." AND  created_by =".$_POST['account_name'];

    }elseif(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' &&  $_POST['account_name'] == '' ){

    $where = array('account.account_owner'=> $this->companyGroupId);

    }else{

    $where = array('account_owner'=> $this->companyGroupId);

    }

    if($this->data['permissions']->is_view == 0){

    $this->data['accounts']  = $this->crm_model->get_own_tbl_data('account', $where,'','created_by');

    }else{

    $this->data['accounts']  = $this->crm_model->get_data('account',$where);

    }

    $this->_render_template('accounts/index', $this->data);

    }

    } */
    public function accounts() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Company', base_url() . 'crm/accounts');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Buyer';
        $this->data['search_string'] = '';
        /*$search_string = $this->input->post('search');

        $likeArray = array( 'account.name' => $search_string,

        'account.phone' => $search_string); */
        //Search
        $where = array('account_owner' => $this->companyGroupId);
        if (isset($_GET['favourites']) != '' && isset($_GET['ExportType']) == '') {
            $where = array('account.favourite_sts' => 1, 'account.account_owner' => $this->companyGroupId);
        }
        if (isset($_GET['start']) && isset($_GET['end']) && isset($_GET['ExportType']) == '' && isset($_GET['favourites']) == '') {
            $where = array('account.created_date >=' => $_GET['start'], 'account.created_date <=' => $_GET['end'], 'account.account_owner' => $this->companyGroupId);
        }
        if (isset($_GET['account_name']) != '' && isset($_GET['ExportType']) == '') {
            $where = array('account.account_owner' => $this->companyGroupId, 'created_by' => $_GET['account_name']);
        }
        if (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites'] == '' && $_GET['search'] == '' && $_GET['account_name'] == '') {
            $where = array('account.account_owner' => $this->companyGroupId);
        } elseif (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites'] != '' && $_GET['search'] == '' && $_GET['account_name'] == '') {
            $where = array('account.favourite_sts' => 1, 'account.account_owner' => $this->companyGroupId);
        } elseif (isset($_GET["ExportType"]) != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['favourites'] == '' && $_GET['search'] == '' && $_GET['account_name'] == '') {
            $where = array('account.created_date >=' => $_GET['start'], 'account.created_date <=' => $_GET['end'], 'account.account_owner' => $this->companyGroupId);
        } elseif (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites'] == '' && $_GET['search'] == '' && $_GET['account_name'] != '') {
            $where = array('account.account_owner' => $this->companyGroupId, 'created_by' => $_GET['account_name']);
        }
        /*  if($this->data['permissions']->is_view == 0){

        $countRows = $this->crm_model->num_rows('account', $where,$search_string,'contact_owner',$likeArray);

        }else{

        # if view permission is enabled than users can see leads of others also

        $countRows = $this->crm_model->num_rows('account', $where,$search_string,'',$likeArray);

        }   */
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $where2 = "(account.id like ='" . $search_string . "' or account.name like '%" . $search_string . "%')";
            redirect("crm/accounts/?search=$search_string");
        } else if (isset($_GET['search'])) {
            $where2 = "(account.name like'%" . $_GET['search'] . "%' or account.id ='" . $_GET['search'] . "')";
        }
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = "desc";
        }
        $config = array();
        $config["base_url"] = base_url() . "crm/accounts/";
        $config["total_rows"] = $this->crm_model->tot_rows('account', $where, $where2);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $config['anchor_class'] = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        if ($this->data['permissions']->is_view == 0) {
            $this->data['accounts'] = $this->crm_model->get_data_listing('account', $where, $config["per_page"], $page, $where2, $order, $export_data);
        } else {
            # if view permission is enabled than users can see leads of others also
            $this->data['accounts'] = $this->crm_model->get_data_listing('account', $where, $config["per_page"], $page, $where2, $order, $export_data);
        }
        $this->_render_template('accounts/index', $this->data);
    }
    public function editAccount() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['account'] = $this->crm_model->get_data_byId('account', 'id', $this->input->post('id'));
        if ($this->input->post('id') != '') {
            $where = array('comp_id' => $this->input->post('id'));
            $account_call_log = $this->crm_model->get_data('company_act_log', $where);
            $this->data['account_activities'] = $account_call_log;
        }
        $this->load->view('accounts/edit', $this->data);
    }
    public function viewAccount() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_view');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['account'] = $this->crm_model->get_data_byId('account', 'id', $this->input->post('id'));
        $this->load->view('accounts/view', $this->data);
    }
    /*  Function to save/update Account */
	public function saveAccount() {
		
		// pre($_POST);die();

        if ($this->input->post()) {
			
			$company_details = getNameById('company_detail', $this->companyGroupId, 'id');
			$required_fields = array('phone');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();

                /*if( getSingleAndWhere('phone','account',['phone' => $_POST['phone']]) ){
                    $this->session->set_flashdata('message', 'Phone No already exist.Try another');
                    redirect('crm/accounts');
                }*/
				
				 // pre($_POST);die();
                // if (isset($_POST['same_address']) == 'same_address') {
                    // $data['billing_street'] = $_POST['shipping_street'];
                    // $data['billing_zipcode'] = $_POST['shipping_zipcode'];
                    // $data['billing_country'] = $_POST['shipping_country'];
                    // $data['billing_state'] = $_POST['shipping_state'];
                    // $data['billing_city'] = $_POST['shipping_city'];

               // }
			   // pre($data);
			    // pre($_POST);die();
                //$data['account_owner'] = $_SESSION['loggedInUser']->c_id;
                $data['account_owner'] = $this->companyGroupId;
                $id = $data['id'];

				$ledgerID = getNameById('account',$id , 'id');

                $dataLedger['name'] = $_POST['name'];
                $dataLedger['email'] = $_POST['email'];
                $dataLedger['phone_no'] = $_POST['phone'];
                $dataLedger['gstin'] = $_POST['billing_gstin_1'][0];
                $dataLedger['account_group_id'] = '54';
                $dataLedger['parent_group_id'] = '6';
                //$dataLedger['website'] = $_POST['website'];
                $dataLedger['save_status'] = $_POST['save_status'];
				if($company_details->ledger_crdit_limtOnOff == 1){
					$dataLedger['purchaseLimit'] = $_POST['purchaseLimit'];
					$dataLedger['temp_credit_limit'] = $_POST['temp_credit_limit'];
					$dataLedger['temp_crlimitDate'] =  date("Y-m-d", strtotime($_POST['temp_crlimitDate']));
				}

				$dataLedger['areastation'] = @$_POST['areastation'];
                // $dataLedger['due_days'] = $_POST['due_days'];
                // $dataLedger['delarType'] = $_POST['type'];
                $dataLedger['conn_comp_id'] = 0;
                $dataLedger['compny_branch_id'] = 0;
                $dataLedger['opening_balance'] = 0;
                $dataLedger['created_by_cid'] = $this->companyGroupId;
				$salesPerson = json_encode($_POST['salesPersons']??'');
				$dataLedger['salesPersons'] = $salesPerson;
                $mailing_namelength = count($_POST['billing_street_1']);
				
				// pre(count($_POST['billing_street_1']));

                if ($_POST['billing_company_1'] != '' && $mailing_namelength > 0) {
                    $arr = [];
                    $i = 0;
                    $tt = 1;
                    while ($i < $mailing_namelength) {
						
						$country = getNameById('country', $_POST['billing_country_1'][$i],'country_id');
						$country_name = $country->country_name;
						$state = getNameById('state', $_POST['billing_state_1'][$i],'state_id');
						$state_name = $state->state_name;
						$city = getNameById('city', $_POST['billing_city_1'][$i],'city_id');
						$city_name = $city->city_name;
						
						
						
                        $jsonArrayObject = (array('ID' => $tt,'mailing_name' =>$_POST['name'][$i],'mailing_address' => $_POST['billing_street_1'][$i], 'mailing_country' => $_POST['billing_country_1'][$i], 'mailing_state' => $_POST['billing_state_1'][$i], 'mailing_city' => $_POST['billing_city_1'][$i], 'mailing_pincode' => $_POST['billing_zipcode_1'][$i],'gstin_no' => $_POST['billing_gstin_1'][$i]));
                        $arr[] = $jsonArrayObject;
						
						 $jsonArrayObjectAccountTbl = (array('ID' => $tt,'billing_company_1' =>$_POST['billing_company_1'][$i],'billing_street_1' => $_POST['billing_street_1'][$i], 'billing_country_1' => $_POST['billing_country_1'][$i], 'billing_state_1' => $_POST['billing_state_1'][$i], 'billing_city_1' => $_POST['billing_city_1'][$i], 'billing_zipcode_1' => $_POST['billing_zipcode_1'][$i],'billing_gstin_1' => $_POST['billing_gstin_1'][$i],'billing_phone_addrs'=>$_POST['billing_phone_addrs'][$i], 'same_shipping' => $_POST['same_shipping'][$i], 'address_type' => 'billing', 'country_name' => $country_name, 'state_name' => $state_name, 'city_name' => $city_name));
                        $arrAccountTbl[] = $jsonArrayObjectAccountTbl;
						
						
                        $i++;
                        $tt++;
                    }
                    $descr_of_ldgr_array = json_encode($arr);
                    $descr_of_ldgr_arrayAccountTbl = json_encode($arrAccountTbl);
                } else {
                    $descr_of_ldgr_array = '';
                    $descr_of_ldgr_arrayAccountTbl = '';
                }
				if(!empty(@$_POST['shipping_country_1'])){
				 $shipping_count = count($_POST['shipping_company_1']);
				 
                if ($_POST['shipping_company_1'] != '' && $shipping_count > 0) {
                    $saddress = [];
                    $sa = 0;
                    while ($sa < $shipping_count) {
                    @$country = getNameById('country', $_POST['shipping_country_1'][$sa],'country_id');
					@$country_name = $country->country_name;
                    $state = getNameById('state', $_POST['shipping_state_1'][$sa],'state_id');
                    @$state_name = $state->state_name;
                    $city = getNameById('city', $_POST['shipping_city_1'][$sa],'city_id');
                    @$city_name = $city->city_name;
                    $SAddressArrayObject = (array('shipping_company_1' =>$_POST['shipping_company_1'][$sa],'shipping_street_1' => $_POST['shipping_street_1'][$sa], 'shipping_country_1' => $_POST['shipping_country_1'][$sa], 'shipping_state_1' => $_POST['shipping_state_1'][$sa], 'shipping_city_1' => $_POST['shipping_city_1'][$sa], 'shipping_zipcode_1' => $_POST['shipping_zipcode_1'][$sa], 'shipping_phone_addrs' => $_POST['shipping_phone_addrs'][$sa], 'address_type' => 'shipping', 'country_name' => $country_name, 'state_name' => $state_name, 'city_name' => $city_name));
                        $saddress[$sa] = $SAddressArrayObject;
                        $sa++;
                    }
                    $saddress_array = json_encode($saddress);
                } else {
                    $saddress_array = '';
                }
				$data['new_shipping_address'] = $saddress_array;
				}else{
					$data['new_shipping_address'] = '[]';
				}	
				 // pre($descr_of_ldgr_arrayAccountTbl);die();
				
                $data['parent_account'] = '0';
               // $data['route_id'] = '0';
				if($company_details->ledger_crdit_limtOnOff == 1){
					$data['temp_crlimitDate'] = date("Y-m-d", strtotime($_POST['temp_crlimitDate']));
				}
                $dataLedger['mailing_address'] = $descr_of_ldgr_array;
                $data['new_billing_address'] = $descr_of_ldgr_arrayAccountTbl;
				
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
                if ($id && $id != '') {
					$where = array('name' => $data['name']);
					// $CheckBuyerUpdateTime = $this->crm_model->get_DuplicateDATA('account', $data['name'] , 'name');
					$CheckBuyerUpdateTime = $this->crm_model->get_data('account', $where);

					
				
				//if($_POST['id'] == $CheckBuyerUpdateTime[0]['id']){
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					// pre($data);die();
					$success = $this->crm_model->update_data('account', $data, 'id', $id);
					$dataLedger['customer_id'] = $_POST['ledger_id'];
					$dataLedger['edited_by'] = $_SESSION['loggedInUser']->u_id;

					$this->crm_model->update_data('ledger', $dataLedger, 'id', $_POST['ledger_id']);
                  // die();
                    if ($success) {
                        $data['message'] = "Company updated successfully";
                        logActivity('Company Updated', 'company', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Company updated' , 'message' => 'Company updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Comapny updated', 'message' => 'Company updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'account_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*  pushNotification(array('subject'=> 'Company updated' , 'message' => 'Company updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));  */
                            pushNotification(array('subject' => 'Comapny updated', 'message' => 'Company updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'account_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'Company Updated successfully');
                        redirect(base_url() . 'crm/accounts', 'refresh');
                    }
					//}else {
                       //$this->session->set_flashdata('message', 'Please Check Your Email And Phone No. already exist');
						//$this->session->set_flashdata('error', 'ERROR !, Already Exist');
                      //  redirect(base_url() . 'crm/accounts', 'refresh');
                   //}	

                } else {
					$where = array('name' => $data['name']);
					$checkEmail = $this->crm_model->get_data('account', $where);
                    
				
					
                    if (empty($checkEmail)) {
						$data['created_by'] = $_SESSION['loggedInUser']->u_id;

						$id = $this->crm_model->insert_tbl_data('account', $data);


                        $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                        $dataLedger['customer_id'] = $id;
                        $dataLedger['created_by'] = $_SESSION['loggedInUser']->u_id;
                        $dataLedger['edited_by'] = $_SESSION['loggedInUser']->u_id;
                        $dataLedger['created_by_cid'] = $this->companyGroupId;

                        $ledger_id=$this->crm_model->insert_tbl_data('ledger', $dataLedger);
                        $data2=array('ledger_id'=>$ledger_id);
                        $this->crm_model->update_single_value_data('account', $data2, array('id'=> $id));

                        if ($id) {
                            logActivity('New Company Created', 'account', $id);
                            if (!empty($usersWithViewPermissions)) {
                                foreach ($usersWithViewPermissions as $userViewPermission) {
                                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                        /*pushNotification(array('subject'=> 'Company created' , 'message' => 'Company created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                        pushNotification(array('subject' => 'Company created', 'message' => 'New Comapny is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'account_view', 'icon' => 'fa fa-shekel'));
                                    }
                                }
                            }
                            if ($_SESSION['loggedInUser']->role != 1) {
                                /*pushNotification(array('subject'=> 'Company created' , 'message' => 'Company created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                                pushNotification(array('subject' => 'Company created', 'message' => 'New Comapny is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'account_view', 'icon' => 'fa fa-shekel'));
                            }
                            $this->session->set_flashdata('message', 'Company inserted successfully');
                             redirect(base_url() . 'crm/accounts', 'refresh');
                        }
                    } else {
                        //$this->session->set_flashdata('message', 'Please Check Your Email And Phone No. already exist');
						$this->session->set_flashdata('error', 'ERROR !, Already Exist');
                        redirect(base_url() . 'crm/accounts', 'refresh');
                    }
                }
            }
        }
    } 
	
	
	
   public function saveAccountOLD() {

        if ($this->input->post()) {

          
             // pre($this->input->post());die();
			 $company_details = getNameById('company_detail', $this->companyGroupId, 'id');

            // $required_fields = array('phone');
            // $is_valid = validate_fields($_POST, $required_fields);
            // if (count($is_valid) > 0) {
            //     valid_fields($is_valid);
            // } else {
                $data = $this->input->post();



                if (isset($_POST['same_address']) == 'same_address') {

                    $data['billing_street'] = $_POST['shipping_street'];
                    $data['billing_zipcode'] = $_POST['shipping_zipcode'];
                    $data['billing_country'] = $_POST['shipping_country'];
                    $data['billing_state'] = $_POST['shipping_state'];
                    $data['billing_city'] = $_POST['shipping_city'];


               }

			 // pre($_POST);
			 // pre($data);
				// die();
			   //

                //$data['account_owner'] = $_SESSION['loggedInUser']->c_id;
                $data['account_owner'] = $this->companyGroupId;
                $id = $data['id'];

				$ledgerID = getNameById('account',$id , 'id');

                $dataLedger['name'] = $_POST['name'];
                $dataLedger['email'] = $_POST['email'];
                $dataLedger['phone_no'] = $_POST['phone'];
                $dataLedger['gstin'] = $_POST['gstin'];
                $dataLedger['account_group_id'] = '54';
                $dataLedger['parent_group_id'] = '6';
                $dataLedger['website'] = $_POST['website'];
                $dataLedger['save_status'] = $_POST['save_status'];
				if($company_details->ledger_crdit_limtOnOff == 1){
					if($_POST['temp_credit_limit'] == '' || $_POST['temp_credit_limit'] == '1970-01-01'){
						$Temdate = '';
					}else{
						$Temdate = $data['temp_crlimitDate'] = date("Y-m-d", strtotime($_POST['temp_crlimitDate']));;
					}
					$dataLedger['purchaseLimit'] = $_POST['purchaseLimit'];
					$dataLedger['temp_credit_limit'] = $Temdate;
					$dataLedger['temp_crlimitDate'] =  date("Y-m-d", strtotime($_POST['temp_crlimitDate']));
				}

				$dataLedger['areastation'] = @$_POST['areastation'];
                @$dataLedger['due_days'] = $_POST['due_days'];
                $dataLedger['delarType'] = $_POST['type'];
                $dataLedger['conn_comp_id'] = 0;
                $dataLedger['compny_branch_id'] = 0;
                $dataLedger['opening_balance'] = 0;
                $dataLedger['created_by_cid'] = $this->companyGroupId;
				$salesPerson = json_encode($_POST['salesPersons']??'');
				$dataLedger['salesPersons'] = $salesPerson;
                $mailing_namelength = isset($_POST['billing_street']);

                // if ($_POST['billing_street'] != '' && $mailing_namelength > 0) {
                //     $arr = [];
                //     $i = 0;
                //     $tt = 1;
                //     while ($i < $mailing_namelength) {
                //         $jsonArrayObject = (array('ID' => $tt,'mailing_name' =>$_POST['name'],'mailing_address' => $_POST['billing_street'], 'mailing_country' => $_POST['billing_country'], 'mailing_state' => $_POST['billing_state'], 'mailing_city' => $_POST['billing_city'], 'mailing_pincode' => $_POST['billing_zipcode'],'gstin_no' => $_POST['gstin']));
                //         $arr[] = $jsonArrayObject;
                //         $i++;
                //         $tt++;
                //     }
                //     $descr_of_ldgr_array = json_encode($arr);
                // } else {
                //     $descr_of_ldgr_array = '';
                // }

                $address_count = count($_POST['billing_street_1']);
                if ($address_count > 0) {
                    $baddress = [];
                    $ba = 0;
                    while ($ba < $address_count) {
                    $country = getNameById('country', $_POST['billing_country_1'][$ba],'country_id');
                    $country_name = $country->country_name;
                    $state = getNameById('state', $_POST['billing_state_1'][$ba],'state_id');
                    $state_name = $state->state_name;
                    $city = getNameById('city', $_POST['billing_city_1'][$ba],'city_id');
                    $city_name = $city->city_name;
                    $BAddressArrayObject = (array('billing_company_1' =>$_POST['billing_company_1'][$ba],'billing_street_1' => $_POST['billing_street_1'][$ba], 'billing_country_1' => $_POST['billing_country_1'][$ba], 'billing_state_1' => $_POST['billing_state_1'][$ba], 'billing_city_1' => $_POST['billing_city_1'][$ba], 'billing_zipcode_1' => $_POST['billing_zipcode_1'][$ba], 'billing_gstin_1' => $_POST['billing_gstin_1'][$ba], 'billing_phone_addrs' => $_POST['billing_phone_addrs'][$ba], 'same_shipping' => $_POST['same_shipping'][$ba], 'address_type' => 'billing', 'country_name' => $country_name, 'state_name' => $state_name, 'city_name' => $city_name));
                        $baddress[$ba] = $BAddressArrayObject;
                        $ba++;
                    }
                    $address_array = json_encode($baddress);
                } else {
                    $address_array = '';
                }

                $shipping_count = count($_POST['shipping_street_1']);
                if ($shipping_count > 0) {
                    $saddress = [];
                    $sa = 0;
                    while ($sa < $shipping_count) {
                    $country = getNameById('country', $_POST['shipping_country_1'][$ba],'country_id');
                    $country_name = $country->country_name;
                    $state = getNameById('state', $_POST['shipping_state_1'][$ba],'state_id');
                    $state_name = $state->state_name;
                    $city = getNameById('city', $_POST['shipping_city_1'][$ba],'city_id');
                    $city_name = $city->city_name;
                    $SAddressArrayObject = (array('shipping_company_1' =>$_POST['shipping_company_1'][$sa],'shipping_street_1' => $_POST['shipping_street_1'][$sa], 'shipping_country_1' => $_POST['shipping_country_1'][$sa], 'shipping_state_1' => $_POST['shipping_state_1'][$sa], 'shipping_city_1' => $_POST['shipping_city_1'][$sa], 'shipping_zipcode_1' => $_POST['shipping_zipcode_1'][$sa], 'shipping_phone_addrs' => $_POST['shipping_phone_addrs'][$sa], 'address_type' => 'shipping', 'country_name' => $country_name, 'state_name' => $state_name, 'city_name' => $city_name));
                        $saddress[$sa] = $SAddressArrayObject;
                        $sa++;
                    }
                    $saddress_array = json_encode($saddress);
                } else {
                    $saddress_array = '';
                }
                $dataLedger['new_billing_address'] = $address_array;
                $dataLedger['type_of_customer'] = $_POST['type_of_customer'];
                $dataLedger['sales_area'] = $_POST['sales_area'];
                $dataLedger['contact_name'] = $_POST['contact_name'];
                $data['new_billing_address'] = $address_array;
                $data['new_shipping_address'] = $saddress_array;
                @$salesPerson = json_encode($_POST['salesPersons']);
                $data['salesPersons'] = $salesPerson;
                $data['parent_account'] = '0';
               // $data['route_id'] = '0';
				if($company_details->ledger_crdit_limtOnOff == 1){
					$data['temp_crlimitDate'] = date("Y-m-d", strtotime($_POST['temp_crlimitDate']));
				}
                $dataLedger['mailing_address'] = $descr_of_ldgr_array;
                // pre($_POST);
                 // pre($dataLedger);
                // die('accha');
                // die;
                $api_data_set = array(
                    'id' => $data['id'],
                    'created_by' => $data['created_by'],
                    'save_status' => $data['save_status'],
                    'name' => $data['name'],
                    'type_of_customer' => $data['type_of_customer'],
                    'sales_area' => $data['sales_area'],
                    'email' => $data['email'],
                    'description' => $data['description'],
                    'contact_name' => $data['contact_name'],
                    'phone' => $data['phone'],
                    'account_owner' => $data['account_owner'],
                    'new_billing_address' => $baddress,
                    'parent_account' => '0',
                    'salesPersons' => 'null'
                    );
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
                if ($id && $id != '') {
					// pre($id);die();
					//pre($data);die();
					$account_ledgerID = getNameById('account', $id, 'id');
				    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $data['api_data'] = json_encode($api_data_set);
					$success = $this->crm_model->update_data('account', $data, 'id', $id);
					$dataLedger['customer_id'] = $id;
					$dataLedger['edited_by'] = $_SESSION['loggedInUser']->u_id;



					$this->crm_model->update_data('ledger', $dataLedger, 'id', $account_ledgerID->ledger_id);
                  // die();
                    if ($success) {
                        $data['message'] = "Company updated successfully";
                        logActivity('Company Updated', 'company', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Company updated' , 'message' => 'Company updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Comapny updated', 'message' => 'Company updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'account_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*  pushNotification(array('subject'=> 'Company updated' , 'message' => 'Company updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));  */
                            pushNotification(array('subject' => 'Comapny updated', 'message' => 'Company updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'account_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'Company Updated successfully');
                       redirect(base_url() . 'crm/accounts', 'refresh');
                    }

                } else {
                    $data['api_data'] = json_encode($api_data_set);
                    $checkEmail = $this->crm_model->emailExist($data['email'], trim($data['name']), trim($data['phone']));

                    if (empty($checkEmail)) {
						$data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$id = $this->crm_model->insert_tbl_data('account', $data);
                        $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                        $dataLedger['customer_id'] = $id;
                        $dataLedger['created_by'] = $_SESSION['loggedInUser']->u_id;
                        $dataLedger['edited_by'] = $_SESSION['loggedInUser']->u_id;
                        $dataLedger['created_by_cid'] = $this->companyGroupId;

                        $ledger_id=$this->crm_model->insert_tbl_data('ledger', $dataLedger);
                        $data2=array('ledger_id'=>$ledger_id);
                        $this->crm_model->update_single_value_data('account', $data2, array('id'=> $id));

                        if ($id) {
                            logActivity('New Company Created', 'account', $id);
                            if (!empty($usersWithViewPermissions)) {
                                foreach ($usersWithViewPermissions as $userViewPermission) {
                                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                        /*pushNotification(array('subject'=> 'Company created' , 'message' => 'Company created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                        pushNotification(array('subject' => 'Company created', 'message' => 'New Comapny is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'account_view', 'icon' => 'fa fa-shekel'));
                                    }
                                }
                            }
                            if ($_SESSION['loggedInUser']->role != 1) {
                                /*pushNotification(array('subject'=> 'Company created' , 'message' => 'Company created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                                pushNotification(array('subject' => 'Company created', 'message' => 'New Comapny is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'account_view', 'icon' => 'fa fa-shekel'));
                            }
                            $this->session->set_flashdata('message', 'Company inserted successfully');
                            redirect(base_url() . 'crm/accounts', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('message', 'Email ,Phone No. already exist');
                        redirect(base_url() . 'crm/accounts', 'refresh');
                        die;
                    }
                }
            //}
        }
    }
    /*delete supplier*/
    public function deleteAccount($id = '') {
        if (!$id) {
            redirect('crm/accounts', 'refresh');
        }
        permissions_redirect('is_delete');

		$ledgerDtl = getNameById('account',$id,'id');

		if($ledgerDtl->ledger_id != ''){
			$result = $this->crm_model->delete_data('ledger', 'id', $ledgerDtl->ledger_id);
		}

		 $result = $this->crm_model->delete_data('account', 'id', $id);
        if ($result) {
            logActivity('Company Deleted', 'leads', $id);
            $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        /*pushNotification(array('subject'=> 'Company deleted' , 'message' => 'Company deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                        pushNotification(array('subject' => 'Company deleted', 'message' => 'Company id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                /*pushNotification(array('subject'=> 'Company deleted' , 'message' => 'Company deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                pushNotification(array('subject' => 'Company deleted', 'message' => 'Company id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
            }
            $this->session->set_flashdata('message', 'Account Deleted Successfully');
            $result = array('msg' => 'Account Deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/accounts');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    /* Main Function to fetch all the listing of departments */
    /*  public function contacts(){

    $this->data['can_edit'] = edit_permissions();

    $this->data['can_delete'] = delete_permissions();

    $this->data['can_add'] = add_permissions();

    $this->data['can_view'] = view_permissions();

    $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');

    $this->breadcrumb->add('Contacts', base_url() . 'crm/contacts');

    $this->settings['breadcrumbs'] = $this->breadcrumb->output();

    $this->settings['pageTitle'] = 'Contacts';

    if (isset($_POST['favourites'])){

    $this->data['contacts'] = $this->crm_model->get_data('contacts',array('favourite_sts'=> 1 ,'contact_owner'=> $this->companyGroupId));

    $this->_render_template('contacts/index', $this->data);

    }else{

    if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {

    $where = array('contact_owner'=> $this->companyGroupId);

    echo "date";

    $this->data['contacts'] = $this->crm_model->get_own_tbl_data('contacts', $where,'','contact_owner');

    $this->_render_template('contacts/index', $this->data);

    }

    if(!empty($_POST) && isset($_POST['start']) &&  isset($_POST['end'])){

    $where = array('contacts.created_date >=' => $_POST['start'] , 'contacts.created_date <=' => $_POST['end'],'contact_owner'=> $this->companyGroupId);

    }else{

    $where = array('contact_owner'=> $this->companyGroupId);

    }

    if($this->data['permissions']->is_view == 0){

    $this->data['contacts'] = $this->crm_model->get_own_tbl_data('contacts', $where,'','contact_owner');

    }else{

    # if view permission is enabled than users can see leads of others also

    $this->data['contacts']  = $this->crm_model->get_data('contacts',$where);

    }

    if(!empty($_POST)){

    //$this->load->view('contacts/index', $this->data);

    $this->_render_template('contacts/index', $this->data);

    }else{

    $this->_render_template('contacts/index', $this->data);

    }

    }

    }    */
    public function contacts() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Contacts', base_url() . 'crm/contacts');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Contacts';
        $this->data['search_string'] = '';
        $likeArray = '';
        $where = array('contact_owner' => $this->companyGroupId);
        /*  $search_string = $this->input->post('search');

        $likeArray = array('contacts.first_name'=>$search_string,

        'contacts.account_id'=>$search_string,

        'contacts.phone'=>$search_string,

        'contacts.email'=>$search_string);  */
        if (isset($_GET['favourites']) != '' && isset($_GET['ExportType']) == '') {
            //  $this->data['contacts'] = $this->crm_model->get_data('contacts', array('favourite_sts' => 1, 'contact_owner' => $this->companyGroupId));
            $where = array('favourite_sts' => 1, 'contact_owner' => $this->companyGroupId);
            #$this->_render_template('contacts/index', $this->data);

        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['favourites']) == '') {
            $where = array('contacts.created_date >=' => $_GET['start'], 'contacts.created_date <=' => $_GET['end'], 'contact_owner' => $this->companyGroupId);
        }
        if (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites'] == '') {
            $where = array('contact_owner' => $this->companyGroupId);
            #$this->_render_template('contacts/index', $this->data);

        } else if (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites'] != '') {
            $where = array('favourite_sts' => 1, 'contact_owner' => $this->companyGroupId);
            #$this->_render_template('contacts/index', $this->data);

        } else if (isset($_GET["ExportType"]) != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['favourites'] == '') {
            $where = array('contacts.created_date >=' => $_GET['start'], 'contacts.created_date <=' => $_GET['end'], 'contact_owner' => $this->companyGroupId);
            #$this->_render_template('contacts/index', $this->data);

        }
        //Search
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $where2 = "(contacts.id like '%" . $search_string . "%' or contacts.first_name like '%" . $search_string . "%'or contacts.last_name like '%" . $search_string . "%' or contacts.company like '%" . $search_string . "%')";
            redirect("crm/contacts/?search=$search_string");
        } else if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "(contacts.first_name like'%" . $_GET['search'] . "%' or contacts.id like'%" . $_GET['search'] . "%' or contacts.last_name like '%" . $_GET['search'] . "%' or contacts.company like '%" . $_GET['search'] . "%')";
        }
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = "desc";
        }
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "crm/contacts/";
        $config["per_page"] = 10;
        $config["total_rows"] = $this->crm_model->tot_rows('contacts', $where, $where2);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $config['anchor_class'] = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['contacts'] = $this->crm_model->get_data_listing('contacts', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if ($this->data['permissions']->is_view == 0) {
            #$this->data['contacts'] = $this->crm_model->get_own_data_listing('contacts', $where,$config['per_page'] , $page,  $this->data['sort_by'], $orderBy,$this->data['search_string'],'contact_owner');
            $this->data['contacts'] = $this->crm_model->get_data_listing('contacts', $where, $config["per_page"], $page, $where2, $order, $export_data);
        } else {
            # if view permission is enabled than users can see leads of others also
            $this->data['contacts'] = $this->crm_model->get_data_listing('contacts', $where, $config["per_page"], $page, $where2, $order, $export_data);
        }
        $this->_render_template('contacts/index', $this->data);
    }
    /*

    public function ajax_list()

    {

        $list = $this->contacts();

        $data = array();

        $no = $_POST['start'];





        foreach ($list as $contact) {

            $no++;

            $row = array();

            $row[] = $no;

            $data[] = $row;

        }



        echo $list;



        $output = array(

                        "draw" => $_POST['draw'],

                        "recordsTotal" => $this->crm_model->count_all(),

                        "recordsFiltered" => $this->crm_model->count_filtered(),

                        "data" => $data,

                );

        //output to json format

        echo json_encode($output);

    }





    */
    public function editContact() {
        if ($this->input->post()) {
            if ($this->input->post('id') != '') {
                permissions_redirect('is_edit');
            } else {
                permissions_redirect('is_add');
            }
            $this->data['id'] = $this->input->post('id');
            $this->data['contact'] = $this->crm_model->get_data_byId('contacts', 'id', $this->input->post('id'));
            $this->load->view('contacts/edit', $this->data);
        }
    }
    public function viewContact() {
        if ($this->input->post()) {
            permissions_redirect('is_view');
        }
        $this->data['id'] = $this->input->post('id');
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['contact'] = $this->crm_model->get_data_byId('contacts', 'id', $this->input->post('id'));
        $this->load->view('contacts/view', $this->data);
    }
    /*  Function to save/update Account */
    public function saveContact() {
        if ($this->input->post()) {
            $required_fields = array('phone');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                if (@$_POST['same_address'] == 'same_address') {
                    $data['other_street'] = $_POST['mailing_street'];
                    $data['other_zipcode'] = $_POST['mailing_zipcode'];
                    $data['other_country'] = $_POST['mailing_country'];
                    $data['other_state'] = $_POST['mailing_state'];
                    $data['other_city'] = $_POST['mailing_city'];
                }
                //$data['contact_owner'] = $_SESSION['loggedInUser']->id;
                //  $data['contact_owner'] = $_SESSION['loggedInUser']->c_id;
                $data['contact_owner'] = $this->companyGroupId;
                $id = $data['id'];
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 8));
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success = $this->crm_model->update_data('contacts', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Contact updated successfully";
                        logActivity('Contact Updated', 'contact', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Contact updated' , 'message' => 'Contact updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Contact updated', 'message' => 'Contact updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'contact_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*pushNotification(array('subject'=> 'Contact updated' , 'message' => 'Contact updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Contact updated', 'message' => 'Contact updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'contact_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'Contact Updated successfully');
                        redirect(base_url() . 'crm/contacts', 'refresh');
                    }
                } else {
                    $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                    $id = $this->crm_model->insert_tbl_data('contacts', $data);
                    if ($id) {
                        logActivity('New Contact Created', 'account', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'Contact created', 'message' => 'Contact created by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'Contact created', 'message' => 'Contact created by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id));
                        }
                        $this->session->set_flashdata('message', 'Contact inserted successfully');
                        redirect(base_url() . 'crm/contacts', 'refresh');
                    }
                }
            }
        }
    }
    /*delete supplier*/
    public function deleteContact($id = '') {
        if (!$id) {
            redirect('crm/contacts', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->crm_model->delete_data('contacts', 'id', $id);
        if ($result) {
            logActivity('Contact Deleted', 'leads', $id);
            $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 8));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        /*  pushNotification(array('subject'=> 'Contact deleted' , 'message' => 'Contact deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                        pushNotification(array('subject' => 'Contact deleted', 'message' => 'Contact id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                /*  pushNotification(array('subject'=> 'Contact deleted' , 'message' => 'Contact deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));  */
                pushNotification(array('subject' => 'Contact deleted', 'message' => 'Contact id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
            }
            $this->session->set_flashdata('message', 'Contact Deleted Successfully');
            $result = array('msg' => 'Contact Deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/contacts');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    /*  Function to add/update Lead aactivity */
    public function saveAccountActivity() {
        if ($this->input->post()) {
            $required_fields = array('subject', 'comment');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $id = $this->crm_model->insert_tbl_data('account_activity', $data);
                if ($id) {
                    if ($data['activity_type'] != 'New task') {
                        change_new_task_status('account_activity', 'account_id', $data['account_id']);
                    }
                    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                        $attachment_array = array();
                        $certificateCount = count($_FILES['attachment']['name']);
                        for ($i = 0;$i < $certificateCount;$i++) {
                            $filename = $_FILES['attachment']['name'][$i];
                            $tmpname = $_FILES['attachment']['tmp_name'][$i];
                            $type = $_FILES['attachment']['type'][$i];
                            $error = $_FILES['attachment']['error'][$i];
                            $size = $_FILES['attachment']['size'][$i];
                            $exp = explode('.', $filename);
                            $ext = end($exp);
                            $newname = $exp[0] . '_' . time() . "." . $ext;
							$newname = str_replace(' ', '_', $newname);;
                            $config['upload_path'] = 'assets/modules/crm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $id;
                            $attachment_array[$i]['rel_type'] = 'account_activity';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array, 'crm/edit_lead/' . $data['account_id']);
                        }
                    }
                    logActivity('New lead call log created', 'lead call log', $id);
                    $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                pushNotification(array('subject' => 'Company activity done', 'message' => 'Company activity done by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'lead_view', 'icon' => 'fa fa-shekel'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        pushNotification(array('subject' => 'Company activity done', 'message' => 'Company activity done by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'lead_view', 'icon' => 'fa fa-shekel'));
                    }
                    $this->session->set_flashdata('message', 'Lead call log inserted successfully');
                    redirect(base_url() . 'crm/accounts', 'refresh');
                }
            }
        }
    }
    public function change_lead_status() {
        $status_data = $this->crm_model->change_lead_status($_POST['id'], $_POST['status'], $_POST['status_comment']);
        $data['lead_id'] = $_POST['id'];
        $data['status'] = $_POST['status'];
        $data['start_date'] = date('Y-m-d');
        $data['created_by_cid'] = $this->companyGroupId;
        if ($_POST['status'] == 5) {
            $data['end_date'] = date('Y-m-d');
        } else {
            $data['end_date'] = "0000-00-00";
        }
        #return false;
        # pre($data);die;
        $this->crm_model->insert_tbl_data('leads_status_history', $data);
        $getdata = getNameById_leads('leads_status_history', $_POST['id'], 'lead_id', $_POST['oldStatus']);
        # pre($getdata->maxid);
        $this->crm_model->update_leads_history_enddates($getdata->maxid, date('Y-m-d'));
        logActivity('Lead Status Changed', 'lead', $_POST['id']);
        $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 5));
        if (!empty($usersWithViewPermissions)) {
            foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                    pushNotification(array('subject' => 'Lead status changed', 'message' => 'Lead status changed by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $_POST['id'] . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $_POST['id'], 'class' => 'add_crm_tabs', 'data_id' => 'lead_view', 'icon' => 'fa fa-shekel'));
                }
            }
        }
        if ($_SESSION['loggedInUser']->role != 1) {
            pushNotification(array('subject' => 'Lead status changed', 'message' => 'Lead status changed by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $_POST['id'] . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $_POST['id'], 'class' => 'add_crm_tabs', 'data_id' => 'lead_view', 'icon' => 'fa fa-shekel'));
        }
        $result = array('msg' => 'Lead Status Changed', 'status' => 'success', 'code' => 'C221', 'url' => base_url() . 'crm/leads/');
        echo json_encode($result);
    }
    public function change_lead_status_by_id() {
        $id = $this->input->get_post('ai');
        $selectedvalue = $this->input->get_post('selectedvalue');
        $comment = "";
        foreach ($id as $key) {
            $status_data = $this->crm_model->change_lead_status($key, $selectedvalue, $comment);
            logActivity('Lead Status Changed', 'lead', $key);
            $result = array('msg' => 'Lead Status Changed', 'status' => 'success', 'code' => 'C221', 'url' => base_url() . 'crm/leads/');
        }
        $this->session->set_flashdata('message', 'Lead Status Changed');
        echo json_encode($result);
    }
    public function activityFilter() {
        $activityResult = $this->crm_model->activityFilter($_POST['id'], $_POST['fromDate'], $_POST['toDate'], $_POST['table']);
        $activityArray = [];
		// pre($activityResult);die();
        $activityResultCount = count($activityResult);
        for ($i = 0;$i < $activityResultCount;$i++) {
            $activityArray[$i] = $activityResult[$i];
            $attachments = getAttachmentsById('attachments', $activityResult[$i]['id'], $_POST['table']);
            $activityArray[$i]['attachment'] = $attachments;
        }
        echo json_encode($activityArray);
    }
    public function convertLead($lead_id = '') {
        $leadConvertedIntoAccount = $this->convertLeadIntoAccount($lead_id);
        $leadConvertedIntoContact = $this->convertLeadIntoContact($lead_id);
        if ($leadConvertedIntoAccount && $leadConvertedIntoContact) {
            $this->session->set_flashdata('message', 'Lead converted successfully');
            redirect(base_url() . 'crm/leads', 'refresh');
        }
    }
    public function convertLeadIntoAccount($lead_id = '') {
        if ($lead_id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $leadData = $this->crm_model->get_data_byId('leads', 'id', $lead_id);
        $leadArray = (array)$leadData;
        $leadArray['converted_to_account'] = 1;
        $leadArray['lead_status'] = 5;
        $phone = '';
        if (!empty($leadData)) {
            # pre($leadData);
            $contacts = json_decode($leadData->contacts);
            $phone = $contacts[0]->phone_no;
            $email = $contacts[0]->email;
            // $getdata = getNameById_leads('leads_status_history', $lead_id, 'lead_id', $leadData->lead_status);
            //         # pre($getdata->maxid);

            // $this->crm_model->update_leads_history_enddates($getdata->maxid, date('Y-m-d'));
                $data['lead_id'] = $lead_id;
                $data['status'] = 5;
                $data['start_date'] = date('Y-m-d');
                $data['created_by_cid'] = $this->companyGroupId;
                $data['end_date'] = date('Y-m-d');
                $this->crm_model->insert_tbl_data('leads_status_history', $data);
                $getdata = getNameById_leads('leads_status_history', $lead_id, 'lead_id', $leadData->lead_status);
                $this->crm_model->update_leads_history_enddates($getdata->maxid, date('Y-m-d'));
        }

                    // $data['lead_id'] = $lead_id;
                    // $data['status'] = $_POST['status'];
                    // $data['start_date'] = date('Y-m-d');
                    // $data['created_by_cid'] = $this->companyGroupId;
                    // $data['end_date'] = date('Y-m-d');
                    // $data['end_date'] = "0000-00-00";
                    //$this->crm_model->insert_tbl_data('leads_status_history', $data);



        //$data = array('name' => $leadData->company ,'phone' => $phone, 'email' => $email,'account_owner' => $_SESSION['loggedInUser']->c_id, 'website' => $leadData->website, 'billing_street' => $leadData->street, 'billing_city' =>  $leadData->city, 'billing_state' =>  $leadData->state,'billing_country' =>  $leadData->country, 'billing_zipcode' =>  $leadData->zipcode,'created_by' => $_SESSION['loggedInUser']->id,'created_by_cid' => $_SESSION['loggedInUser']->c_id ,'save_status'=>1);
        $data = array('name' => $leadData->company, 'phone' => $phone, 'email' => $email, 'account_owner' => $this->companyGroupId, 'website' => $leadData->website, 'billing_street' => $leadData->street, 'billing_city' => $leadData->city, 'billing_state' => $leadData->state, 'billing_country' => $leadData->country, 'billing_zipcode' => $leadData->zipcode, 'created_by' => $_SESSION['loggedInUser']->u_id, 'created_by_cid' => $this->companyGroupId, 'save_status' => 1);
        $id = $this->crm_model->insert_tbl_data('account', $data);
        if ($id) {
            $leadConverted = $this->crm_model->update_data('leads', $leadArray, 'id', $lead_id);
            if ($leadConverted) {
                logActivity('Lead converted to account', 'lead', $id);
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 5));
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array('subject' => 'Lead converted into company', 'message' => 'Lead converted into company by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . ' from id ' . $lead_id, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'account_view', 'icon' => 'fa fa-shekel'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Lead converted into company', 'message' => 'Lead converted into company by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . ' from id ' . $lead_id, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'account_view', 'icon' => 'fa fa-shekel'));
                }
                //$this->session->set_flashdata('message', 'Lead converted into account successfully');
                return true;
            }
            //redirect(base_url().'crm/accounts', 'refresh');

        }
    }
    public function convertLeadIntoContact($lead_id = '') {
        if ($lead_id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $leadData = $this->crm_model->get_data_byId('leads', 'id', $lead_id);
        $get_account_last_id = getLastTableId('account');
        $leadArray = (array)$leadData;
        $leadArray['converted_to_contact'] = 1;
        $leadArray['lead_status'] = 5;
        if (!empty($leadData)) {
            $getdata = getNameById_leads('leads_status_history', $lead_id, 'lead_id', $leadData->lead_status);
                    # pre($getdata->maxid);
            $this->crm_model->update_leads_history_enddates($getdata->maxid, date('Y-m-d'));
            $contacts = json_decode($leadData->contacts);
            if (!empty($contacts)) {
                foreach ($contacts as $contact) {
                    //$data = array('company' => $leadData->company ,'first_name'=> $contact->first_name,'last_name'=> $contact->last_name,'phone'=> $contact->phone_no,'email'=> $contact->email, 'contact_owner' => $_SESSION['loggedInUser']->c_id, 'website' => $leadData->website, 'mailing_street' => $leadData->street, 'mailing_city' =>  $leadData->city, 'mailing_state' =>  $leadData->state,'mailing_country' =>  $leadData->country, 'mailing_zipcode' =>  $leadData->zipcode,'lead_source' => $leadData->lead_source,'company'=>$leadData->company,'created_by' => $_SESSION['loggedInUser']->id ,'save_status'=>1,'account_id'=>$get_account_last_id);
                    $data = array('company' => $leadData->company, 'first_name' => $contact->first_name, 'last_name' => $contact->last_name, 'phone' => $contact->phone_no, 'email' => $contact->email, 'contact_owner' => $this->companyGroupId, 'website' => $leadData->website, 'mailing_street' => $leadData->street, 'mailing_city' => $leadData->city, 'mailing_state' => $leadData->state, 'mailing_country' => $leadData->country, 'mailing_zipcode' => $leadData->zipcode, 'lead_source' => $leadData->lead_source, 'company' => $leadData->company, 'created_by' => $_SESSION['loggedInUser']->u_id, 'save_status' => 1, 'account_id' => $get_account_last_id);
                    $contactId = $this->crm_model->insert_tbl_data('contacts', $data);
                }
            }
        }
        $leadConverted = $this->crm_model->update_data('leads', $leadArray, 'id', $lead_id);
        logActivity('Lead converted to contact', 'lead', $lead_id);
        $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 5));
        if (!empty($usersWithViewPermissions)) {
            foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                    pushNotification(array('subject' => 'Lead converted into contact', 'message' => 'Lead converted into contact by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $contactId . ' from id ' . $lead_id, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $contactId, 'class' => 'add_crm_tabs', 'data_id' => 'account_view', 'icon' => 'fa fa-shekel'));
                }
            }
        }
        if ($_SESSION['loggedInUser']->role != 1) {
            pushNotification(array('subject' => 'Lead converted into contact', 'message' => 'Lead converted into contact by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $contactId . ' from id ' . $lead_id, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $contactId, 'class' => 'add_crm_tabs', 'data_id' => 'account_view', 'icon' => 'fa fa-shekel'));
        }
        //$this->session->set_flashdata('message', 'Lead converted into contact successfully');
        if ($leadConverted) return true;
        //  redirect(base_url().'crm/contacts', 'refresh');

    }
    public function convertLeadIntoSO($lead_id = '') {
        if ($lead_id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $SOdata = $this->crm_model->get_data_byId('leads', 'id', $lead_id);
        #pre($SOdata);
        # die;
        $last_id = getLastTableId('sale_order');
        $rId = $last_id + 1;
        $soCode = 'SOR_' . rand(1, 1000000) . '_' . $rId;
        $leadArray = (array)$SOdata;
        $leadArray['converted_to_so'] = 1;
        $leadArray['lead_status'] = 5;
        #pre($SOdata->product_detail);
        $py = json_decode($SOdata->product_detail);
        # pre($py);
        $items = array();
        $i = 0;
        foreach ($py as $rt) {
            $items[$i]['product'] = $rt->material_name_id;
            $items[$i]['description'] = $rt->description;
            $items[$i]['quantity'] = $rt->qty;
            $items[$i]['uom'] = $rt->uom_material;
            $items[$i]['price'] = $rt->price;
            $items[$i]['gst'] = $rt->gst;
            $items[$i]['individualTotal'] = $rt->total;
            $items[$i]['individualTotalWithGst'] = $rt->TotalWithGst;
            $i++;
        }
        $item_json = json_encode($items);
        $data = array('so_order' => $soCode, 'material_type_id' => $SOdata->material_type_id, 'product' => $item_json, 'total' => $SOdata->totalwithoutgst, 'grandTotal' => $SOdata->grand_total, 'created_by' => $_SESSION['loggedInUser']->u_id, 'created_by_cid' => $this->companyGroupId, 'save_status' => 1);
        $id = $this->crm_model->insert_tbl_data('sale_order', $data);
        if ($id) {
            $leadConverted = $this->crm_model->update_data('leads', $leadArray, 'id', $lead_id);
            if ($leadConverted) {
                logActivity('Lead converted to Sale Order', 'lead', $id);
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 5));
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array('subject' => 'Lead converted into Sale Order', 'message' => 'Lead converted into Sale Order by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . ' from id ' . $lead_id, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Lead converted into Sale Order', 'message' => 'Lead converted into Sale Order by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . ' from id ' . $lead_id, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                }
            }
            #die;
            $this->session->set_flashdata('message', 'Lead converted into Sale Order successfully');
            redirect(base_url() . 'crm/sale_orders', 'refresh');
        }
    }
    /* Main Function to fetch all the listing of departments */
    /*   public function sale_orders(){

    $this->data['can_edit'] = edit_permissions();

    $this->data['can_delete'] = delete_permissions();

    $this->data['can_add'] = add_permissions();

    $this->data['can_view'] = view_permissions();

    $this->data['can_validate'] = validate_permissions();

    $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');

    $this->breadcrumb->add('Sale Order', base_url() . 'crm/sale_orders');

    $this->settings['breadcrumbs'] = $this->breadcrumb->output();

    $this->settings['pageTitle'] = 'Sale Orders';

    //$whereCompany = "(id ='".$_SESSION['loggedInUser']->c_id."')";



    $whereCompany = "(id ='".$this->companyGroupId."')";





    $this->data['company_unit_adress']  = $this->crm_model->get_filter_details('company_detail',$whereCompany);



    if(isset($_POST["favourites"]) && $_POST['company_unit']=='') {



    //$whereCompany = "(id ='".$_SESSION['loggedInUser']->c_id."')";



    $whereCompany = "(id ='".$this->companyGroupId."')";





    $this->data['company_unit_adress']  = $this->crm_model->get_filter_details('company_detail',$whereCompany);

    //$this->data['sale_orders'] = $this->crm_model->get_data('sale_order',array('created_by_cid'=> $_SESSION['loggedInUser']->c_id , 'favourite_sts'=> 1));



    $this->data['sale_orders'] = $this->crm_model->get_data('sale_order',array('created_by_cid'=> $this->companyGroupId , 'favourite_sts'=> 1));

    $this->_render_template('sale_orders/index', $this->data);

    }



    else{





    if(!empty($_POST) && isset($_POST['start']) &&  isset($_POST['end']) && $_POST['company_unit']==''){

    //echo "2";

    //$where = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 0);

    //$completedSaleOrderWhere = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 1);





    $where = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $this->companyGroupId, 'complete_status' => 0);

    $completedSaleOrderWhere = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $this->companyGroupId, 'complete_status' => 1);



    $this->data['sale_orders']  = $this->crm_model->get_data('sale_order',$where);

    $this->data['complete_sale_orders']  = $this->crm_model->get_data('sale_order',$completedSaleOrderWhere);



    $this->_render_template('sale_orders/index', $this->data);

    }

    elseif(!empty($_POST) && $_POST['start']=='' &&  $_POST['end']=='' && $_POST['company_unit']!=''){

    //echo "3";

    //  $where = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 0,'company_unit'=> $_POST['company_unit']);

    //  $completedSaleOrderWhere = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 1,'company_unit'=> $_POST['company_unit']);





    $where = array('created_by_cid'=> $this->companyGroupId, 'complete_status' => 0,'company_unit'=> $_POST['company_unit']);

    $completedSaleOrderWhere = array('created_by_cid'=> $this->companyGroupId, 'complete_status' => 1,'company_unit'=> $_POST['company_unit']);



    $this->data['sale_orders']  = $this->crm_model->get_data('sale_order',$where);

    $this->data['complete_sale_orders']  = $this->crm_model->get_data('sale_order',$completedSaleOrderWhere);



    $this->_render_template('sale_orders/index', $this->data);



    }elseif(!empty($_POST) && $_POST['start']!='' && $_POST['end']!='' && $_POST['company_unit']!=''){

    //echo "4";

    //$where = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 0,'company_unit'=> $_POST['company_unit']);

    //$completedSaleOrderWhere = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 1,'company_unit'=> $_POST['company_unit']);





    $where = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $this->companyGroupId, 'complete_status' => 0,'company_unit'=> $_POST['company_unit']);

    $completedSaleOrderWhere = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $this->companyGroupId, 'complete_status' => 1,'company_unit'=> $_POST['company_unit']);









    $this->data['sale_orders']  = $this->crm_model->get_data('sale_order',$where);

    $this->data['complete_sale_orders']  = $this->crm_model->get_data('sale_order',$completedSaleOrderWhere);



    $this->_render_template('sale_orders/index', $this->data);



    }else{

    //$where = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 0);

    //$completedSaleOrderWhere = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 1);





    $where = array('created_by_cid'=> $this->companyGroupId, 'complete_status' => 0);

    $completedSaleOrderWhere = array('created_by_cid'=> $this->companyGroupId, 'complete_status' => 1);





    $this->data['sale_orders']  = $this->crm_model->get_data('sale_order',$where);

    $this->data['complete_sale_orders']  = $this->crm_model->get_data('sale_order',$completedSaleOrderWhere);



    $this->_render_template('sale_orders/index', $this->data);

    }

    if(isset($_POST["ExportType"])  && $_POST['start']=='' && $_POST['end']=='' &&  $_POST['company_unit']=='') {

    //echo "hell"; die;

    //$where = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 0);

    //$completedSaleOrderWhere = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 1);





    $where = array('created_by_cid'=> $this->companyGroupId, 'complete_status' => 0);

    $completedSaleOrderWhere = array('created_by_cid'=> $this->companyGroupId, 'complete_status' => 1);



    $this->data['sale_orders']  = $this->crm_model->get_data('sale_order',$where);

    $this->data['complete_sale_orders']  = $this->crm_model->get_data('sale_order',$completedSaleOrderWhere);



    $this->_render_template('sale_orders/index', $this->data);



    }else if(isset($_POST["ExportType"])  && $_POST['start']!='' &&  $_POST['end']!='' &&   $_POST['company_unit']=='') {



    //$where = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 0);

    //$completedSaleOrderWhere = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 1);





    $where = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $this->companyGroupId, 'complete_status' => 0);

    $completedSaleOrderWhere = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $this->companyGroupId, 'complete_status' => 1);



    $this->data['sale_orders']  = $this->crm_model->get_data('sale_order',$where);

    $this->data['complete_sale_orders']  = $this->crm_model->get_data('sale_order',$completedSaleOrderWhere);



    $this->_render_template('sale_orders/index', $this->data);



    }else if(isset($_POST["ExportType"])  && $_POST['start']!='' &&  $_POST['end']!='' &&   $_POST['company_unit']!='') {



    //$where = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 0,'company_unit'=> $_POST['company_unit']);



    //$completedSaleOrderWhere = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 1,'company_unit'=> $_POST['company_unit']);







    $where = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $this->companyGroupId, 'complete_status' => 0,'company_unit'=> $_POST['company_unit']);



    $completedSaleOrderWhere = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $this->companyGroupId, 'complete_status' => 1,'company_unit'=> $_POST['company_unit']);



    $this->data['sale_orders']  = $this->crm_model->get_data('sale_order',$where);

    $this->data['complete_sale_orders']  = $this->crm_model->get_data('sale_order',$completedSaleOrderWhere);



    $this->_render_template('sale_orders/index', $this->data);



    }else if(isset($_POST["ExportType"])  && $_POST['start']=='' &&  $_POST['end']=='' &&   $_POST['company_unit']!='') {



    //$where = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 0,'company_unit'=> $_POST['company_unit']);



    //$completedSaleOrderWhere = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 1,'company_unit'=> $_POST['company_unit']);





    $where = array('created_by_cid'=> $this->companyGroupId, 'complete_status' => 0,'company_unit'=> $_POST['company_unit']);



    $completedSaleOrderWhere = array('created_by_cid'=> $this->companyGroupId, 'complete_status' => 1,'company_unit'=> $_POST['company_unit']);



    $this->data['sale_orders']  = $this->crm_model->get_data('sale_order',$where);

    $this->data['complete_sale_orders']  = $this->crm_model->get_data('sale_order',$completedSaleOrderWhere);



    $this->_render_template('sale_orders/index', $this->data);

    }





    if($this->data['permissions']->is_view == 0){

    $this->data['sale_orders'] = $this->crm_model->get_own_tbl_data('sale_order', array_merge($where,array('created_by'=> $_SESSION['loggedInUser']->id)),'','created_by_cid');



    $this->data['complete_sale_orders'] = $this->crm_model->get_own_tbl_data('sale_order', array_merge($completedSaleOrderWhere,array('created_by'=> $_SESSION['loggedInUser']->id)),'','created_by_cid');

    }else{

    # if view permission is enabled than users can see leads of others also

    $this->data['sale_orders']  = $this->crm_model->get_data('sale_order',$where);

    $this->data['complete_sale_orders']  = $this->crm_model->get_data('sale_order',$completedSaleOrderWhere);

    }





    //$this->data['sale_orders']  = $this->crm_model->get_data('sale_order',$where);

    //$this->data['complete_sale_orders']  = $this->crm_model->get_data('sale_order',$completedSaleOrderWhere);







    /*if(!empty($_POST)){

    $this->_render_template('sale_orders/index', $this->data);

    }else{

    $this->_render_template('sale_orders/index', $this->data);

    }

    */
    /*if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {

    $where = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 0);

    $completedSaleOrderWhere = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 1);

    $this->data['sale_orders'] = $this->crm_model->get_own_tbl_data('sale_order', array_merge($where,array('created_by'=> $_SESSION['loggedInUser']->id)),'','created_by_cid');

    $this->data['complete_sale_orders'] = $this->crm_model->get_own_tbl_data('sale_order', array_merge($completedSaleOrderWhere, array('created_by'=> $_SESSION['loggedInUser']->id)),'','created_by_cid');

      $this->_render_template('sale_orders/index', $this->data);

    }



    if(!empty($_POST)){

    $where = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 0);

    $completedSaleOrderWhere = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 1);

    }else{

    $where = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 0);

    $completedSaleOrderWhere = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'complete_status' => 1);

    }



    //if($this->data['permissions']->is_view == 0){

    //$this->data['sale_orders'] = $this->crm_model->get_data('sale_order', array_merge($where,array('created_by'=> $_SESSION['loggedInUser']->id)));

    //}else{

    //$this->data['sale_orders']  = $this->crm_model->get_data('sale_order',$where);

    //}



    if($this->data['permissions']->is_view == 0){

    $this->data['sale_orders'] = $this->crm_model->get_own_tbl_data('sale_order', array_merge($where,array('created_by'=> $_SESSION['loggedInUser']->id)),'','created_by_cid');



    $this->data['complete_sale_orders'] = $this->crm_model->get_own_tbl_data('sale_order', array_merge($completedSaleOrderWhere,array('created_by'=> $_SESSION['loggedInUser']->id)),'','created_by_cid');

    }else{

    # if view permission is enabled than users can see leads of others also

    $this->data['sale_orders']  = $this->crm_model->get_data('sale_order',$where);

    $this->data['complete_sale_orders']  = $this->crm_model->get_data('sale_order',$completedSaleOrderWhere);

    }



    if(!empty($_POST)){

    $this->_render_template('sale_orders/index', $this->data);

    }else{

    $this->_render_template('sale_orders/index', $this->data);

    }   */
    /*}

     } */
    public function sale_orders() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_validate'] = validate_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Sale Order', base_url() . 'crm/sale_orders');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Sale Orders';
        $whereCompany = "(id ='" . $this->companyGroupId . "')";
        $this->data['company_unit_adress'] = $this->crm_model->get_filter_details('company_detail', $whereCompany);
        $where = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 0);
        $completedSaleOrderWhere = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 1, 'approve' => 1);
        if (empty($_GET)) {
            $where = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 0);
            $completedSaleOrderWhere = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 1, 'approve' => 1);
        } elseif (!empty($_GET['tab']) == 'inProcessorder' && $_GET['tab'] != 'complete_order') {
            $where = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 0);
            $completedSaleOrderWhere = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 1, 'approve' => 1);
        } elseif (!empty($_GET['tab']) == 'complete_order' && $_GET['tab'] != 'inProcessorder') {
            $completedSaleOrderWhere = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 1, 'approve' => 1);
            $where = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 0);
        }
        if (empty($_GET['start']) && empty($_GET['end']) && isset($_GET['company_unit']) != '') {
            if (isset($_GET['tab']) == 'complete_order') {
                $completedSaleOrderWhere = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 1, 'company_unit' => $_GET['company_unit']);
            } else {
                $where = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 0, 'company_unit' => $_GET['company_unit']);
            }
        }
        if (isset($_GET['start']) != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
            if ($_GET['tab'] == 'complete_order') {
                $completedSaleOrderWhere = array('created_date >=' => $_GET['start'], 'created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyGroupId, 'complete_status' => 1);
            } else {
                $where = array('created_date >=' => $_GET['start'], 'created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyGroupId, 'complete_status' => 0);
            }
        }
        if (!empty($_GET) && isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['company_unit']) == '' && isset($_GET["favourites"]) == '') {
            if ($_GET['tab'] == 'complete_order') {
                $completedSaleOrderWhere = array('created_date >=' => $_GET['start'], 'created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyGroupId, 'complete_status' => 1);
            } else {
                $where = array('created_date >=' => $_GET['start'], 'created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyGroupId, 'complete_status' => 0);
            }
        } elseif (!empty($_GET) && (isset($_GET['start']) && $_GET['start'] != '') && (isset($_GET['end']) && $_GET['end'] != '') && $_GET['company_unit'] != '' && $_GET["favourites"] == '') {
            $where = array('created_date >=' => $_GET['start'], 'created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyGroupId, 'complete_status' => 0, 'company_unit' => $_GET['company_unit']);
            $completedSaleOrderWhere = array('created_date >=' => $_GET['start'], 'created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyGroupId, 'complete_status' => 1, 'company_unit' => $_GET['company_unit']);
        }
        if (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites'] == '' && $_GET['company_unit'] == '') {
            if (!empty($_GET['tab']) == 'complete_order') {
                $completedSaleOrderWhere = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 1, 'approve' => 1);
            } else {
                $where = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 0);
            }
        } else if (isset($_GET["ExportType"]) && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '' && $_GET['favourites'] == '') {
            if (!empty($_GET['tab']) == 'complete_order') {
                $completedSaleOrderWhere = array('created_date >=' => $_GET['start'], 'created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyGroupId, 'complete_status' => 1);
            } else {
                $where = array('created_date >=' => $_GET['start'], 'created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyGroupId, 'complete_status' => 0);
            }
        } else if (isset($_GET["ExportType"]) && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] != '' && $_GET['favourites'] == '') {
            $where = array('created_date >=' => $_GET['start'], 'created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyGroupId, 'complete_status' => 0, 'company_unit' => $_GET['company_unit']);
            $completedSaleOrderWhere = array('created_date >=' => $_GET['start'], 'created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyGroupId, 'complete_status' => 1, 'company_unit' => $_GET['company_unit']);
        } else if (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '' && $_GET['favourites'] == '') {
            $where = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 0, 'company_unit' => $_GET['company_unit']);
            $completedSaleOrderWhere = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 1, 'company_unit' => $_GET['company_unit']);
        } else if (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '' && $_GET['favourites'] != '') {
            if ($_GET['tab'] == 'inProcessorder') {
                $where = array('created_by_cid' => $this->companyGroupId, 'favourite_sts' => 1, 'complete_status' => 0);
            } else {
                $completedSaleOrderWhere = array('created_by_cid' => $this->companyGroupId, 'favourite_sts' => 1, 'complete_status' => 1);
            }
        }
        if (isset($_GET["favourites"]) != '' && isset($_GET["ExportType"]) == '' && $_GET['start'] == '' && $_GET['end'] == '') {
            $whereCompany = "(id ='" . $this->companyGroupId . "')";
            $this->data['company_unit_adress'] = $this->crm_model->get_filter_details('company_detail', $whereCompany);
            if ($_GET['tab'] == 'complete_order') {
                $completedSaleOrderWhere = array('created_by_cid' => $this->companyGroupId, 'favourite_sts' => 1, 'complete_status' => 1);
            } else {
                $where = array('created_by_cid' => $this->companyGroupId, 'favourite_sts' => 1, 'complete_status' => 0);
            }
        }
        if (isset($_GET['start']) == '' && isset($_GET['end']) == '' && isset($_GET['company_unit']) != '') {
            if ($_GET['tab'] == 'complete_order') {
                $where = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 0, 'company_unit' => $_GET['company_unit']);
            } else {
                $completedSaleOrderWhere = array('created_by_cid' => $this->companyGroupId, 'complete_status' => 1, 'company_unit' => $_GET['company_unit']);
            }
        }
        //Search
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $where2 = " sale_order.so_order like '%" . $search_string . "%' or sale_order.id = '" . $search_string . "'";
            redirect("crm/sale_orders/?search=$search_string");
        } else if (isset($_GET['search']) && $_GET['search'] != '') {
            $accountName = getNameBySearch('account', $_GET['search'], 'name');
            $where2 = array();
            foreach ($accountName as $name) { //pre($name['id']);
                $where2[] = "(sale_order.account_id ='" . $name['id'] . "')";
            }
            if (sizeof($where2) != '') {
                $where2 = implode("||", $where2);
            } else {
                $where2 = "(sale_order.so_order like'%" . $_GET['search'] . "%' or sale_order.id ='" . $_GET['search'] . "')";
            }
        }
		

        /*if(!empty($accountName->id)){
        $where2 = "(sale_order.account_id ='" .$accountName->id. "')" ;
        }else
                $where2 = "(sale_order.so_order like'%" . $_GET['search'] . "%' or sale_order.id ='" . $_GET['search'] . "')";
            }*/
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        if (!empty($_GET['tab']) == 'inProcessorder' && $_GET['tab'] != 'complete_order') {
            $rows = $this->crm_model->tot_rows('sale_order', $where, $where2);
        } elseif (!empty($_GET['tab']) == 'complete_order' && $_GET['tab'] != 'inProcessorder') {
            $rows = $this->crm_model->tot_rows('sale_order', $completedSaleOrderWhere, $where2);
        } else {
            $rows = $this->crm_model->tot_rows('sale_order', $where, $where2);
        }
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "crm/sale_orders/";
        $config["total_rows"] = $rows;
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $config['anchor_class'] = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        if ($this->data['permissions']->is_view == 0) {
            $this->data['sale_orders'] = $this->crm_model->get_data_listing('sale_order', array_merge($where, array('created_by' => $_SESSION['loggedInUser']->u_id)), $config['per_page'], $page, $where2, $order, $export_data);
            $this->data['complete_sale_orders'] = $this->crm_model->get_data_listing('sale_order', array_merge($completedSaleOrderWhere, array('created_by' => $_SESSION['loggedInUser']->u_id)), $config['per_page'], $page, $where2, $order, $export_data);
        } else {
            if (!empty($_GET['tab']) == 'inProcessorder' && $_GET['tab'] != 'complete_order') {
                $this->data['sale_orders'] = $this->crm_model->get_data_listing('sale_order', $where, $config['per_page'], $page, $where2, $order, $export_data);
            } elseif (!empty($_GET['tab']) == 'complete_order' && $_GET['tab'] != 'inProcessorder') {
                $this->data['complete_sale_orders'] = $this->crm_model->get_data_listing('sale_order', $completedSaleOrderWhere, $config['per_page'], $page, $where2, $order, $export_data);
            } else {
                # if view permission is enabled than users can see leads of others also
                $this->data['sale_orders'] = $this->crm_model->get_data_listing('sale_order', $where, $config['per_page'], $page, $where2, $order, $export_data);
                $this->data['complete_sale_orders'] = $this->crm_model->get_data_listing('sale_order', $completedSaleOrderWhere, $config['per_page'], $page, $where2, $order, $export_data);
            }
        }
        $this->_render_template('sale_orders/index', $this->data);
    }
    public function editSaleOrder() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['sale_order'] = $this->crm_model->get_data_byId('sale_order', 'id', $this->input->post('id'));
        //$this->data['materials']  = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'sale_order');
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->load->view('sale_orders/edit', $this->data);
    }
    public function viewSaleOrder($id = '') {
        if ($this->input->post('id')) {
            permissions_redirect('is_view');
        }
        $this->data['id'] = $this->input->post('id');
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['sale_order'] = $this->crm_model->get_data_byId('sale_order', 'id', $this->input->post('id'));
        $this->data['sale_order_dispatch'] = $this->crm_model->get_dispatch_data('sale_order_dispatch', array('sale_order_id' => $this->input->post('id')));
        //$this->data['sale_order_dispatch'] = $this->crm_model->get_data('sale_order_dispatch',array('sale_order_id'=>  $this->input->post('id')));
        //$this->data['materials']  = $this->crm_model->get_data('material');
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'sale_order');
        $whereDispatchAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'sale_order_dispatch');
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->data['dispatch_attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereDispatchAttachment);
        $this->load->view('sale_orders/view', $this->data);
    }
    public function getAccountDataById() {
        if ($_POST['id'] != '') {
            $account = $this->crm_model->get_data_byId('account', 'id', $_POST['id']);
            echo json_encode($account);
        }
    }
    public function getContactDataById() {
        if ($_POST['id'] != '') {
            $contacts = $this->crm_model->get_data_byId('contacts', 'id', $_POST['id']);
            echo json_encode($contacts);
        }
    }
    /******************create sale order pdf********************************/
    public function create_sale_order_pdf($id = '') {
        $this->load->library('Pdf');
        $dataPdf = $this->crm_model->get_data_byId('sale_order', 'id', $id);
        create_pdf($dataPdf, 'modules/crm/views/sale_orders/view_saleOrder_pdf.php');
        $this->load->view('sale_orders/view_saleOrder_pdf');
    }
    /*  Function to add/update Lead aactivity */
    public function saveSaleOrder() {
          // pre($_POST); die;
        if ($this->input->post()) {
            $required_fields = array('account_id', 'product', 'qty', 'uom', 'price', 'order_date');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {


                $data = $this->input->post();
				unset($data['material_type_id']);
                $products = count($_POST['product']);
                $comp_id = $_POST['account_id'];
                $sale_order_priority_array = array();
                if ($products > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $products) {
						$materialDtl = getNameById('material',$_POST['product'][$i],'id');
						
                        $jsonArrayObject = array('product' => $_POST['product'][$i], 'productname' => $materialDtl->material_name,'description' => $_POST['description'][$i], 'quantity' => $_POST['qty'][$i], 'uom' => $_POST['uom'][$i], 'price' => $_POST['price'][$i], 'gst' => $_POST['gst'][$i], 'individualTotal' => $_POST['totals'][$i], 'individualTotalWithGst' => @$_POST['TotalWithGsts'][$i],'hsncode'=>$materialDtl->hsn_code);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }

                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
				// pre($jsonArrayObject);
				// die();
                $data['pi_paymode'] = json_encode(@$_POST['pi_paymode']);
                $data['so_order'] = ($data['revised_so_code'] != '') ? $data['revised_so_code'] : $data['so_order'];
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['product'] = $product_array;
                $data['material_type_id'] = json_encode($_POST['material_type_id']);
                $data['discount_offered'] = isset($data['discount_offered']) ? json_encode($data['discount_offered']) : '';
                $data['dispatch_documents'] = isset($data['dispatch_documents']) ? json_encode($data['dispatch_documents']) : '';
				
				// pre($data);die();
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                //  $data['payment_terms'] = json_encode($data['payment_terms']);
                $id = $data['id'];
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 9));
                #pre($data); die;
                if ($id && $id != '') {
                    $success = $this->crm_model->update_data('sale_order', $data, 'id', $id);
                    if ($success) {
                        if (!empty($arr)) {
                            foreach ($arr as $res) {
                                //$this->crm_model->update_single_value_data('material',array('sales_price'=>$res['price']), array('id'=> $res['product'],'created_by_cid'=>$_SESSION['loggedInUser']->c_id));
                                $this->crm_model->update_single_value_data('material', array('sales_price' => $res['price']), array('id' => $res['product'], 'created_by_cid' => $this->companyGroupId));
                            }
                        }
                        $data['message'] = "Sale Order updated successfully";
                        logActivity('Sale Order Updated', 'lead', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInCompany']->u_id) {
                                    /*pushNotification(array('subject'=> 'Sale order updated' , 'message' => 'Sale order updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Sale Order updated', 'message' => 'Sale order updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*  pushNotification(array('subject'=> 'Sale order updated' , 'message' => 'Sale order updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Sale Order updated', 'message' => 'Sale order updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                        }
                        ComplogActivity($comp_id, 'Sale Order Updated', 'Sale Order', $id);
                        $this->session->set_flashdata('message', 'Sale Order Updated successfully');
                    }
                } else {
					// pre($data);die();
                    $id = $this->crm_model->insert_tbl_data('sale_order', $data);
                    if ($id) {
                        if (!empty($arr)) {
                            foreach ($arr as $res) {
                                //$this->crm_model->update_single_value_data('material',array('sales_price'=>$res['price']), array('id'=> $res['product'],'created_by_cid'=>$_SESSION['loggedInUser']->c_id));
                                $this->crm_model->update_single_value_data('material', array('sales_price' => $res['price']), array('id' => $res['product'], 'created_by_cid' => $this->companyGroupId));
                            }
                        }
                        logActivity('New Sale Order Created', 'Sale Order', $id);
                        ComplogActivity($comp_id, 'Sale Order Inserted', 'Sale Order', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInCompany']->u_id) {
                                    /*  pushNotification(array('subject'=> 'Sale order created' , 'message' => 'Sale order created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Sale order created', 'message' => 'New Sale order is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*  pushNotification(array('subject'=> 'Sale created updated' , 'message' => 'Sale order created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Sale order created', 'message' => 'New Sale order is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'New Sale Order inserted successfully');
                    }
                }
                if ($id) {
                    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                        $attachment_array = array();
                        $certificateCount = count($_FILES['attachment']['name']);
                        for ($i = 0;$i < $certificateCount;$i++) {
                            $filename = $_FILES['attachment']['name'][$i];
                            $tmpname = $_FILES['attachment']['tmp_name'][$i];
                            $type = $_FILES['attachment']['type'][$i];
                            $error = $_FILES['attachment']['error'][$i];
                            $size = $_FILES['attachment']['size'][$i];
                            $exp = explode('.', $filename);
                            $ext = end($exp);
                            $newname = $exp[0] . '_' . time() . "." . $ext;
							$newname = str_replace(' ', '_', $newname);;
                            $config['upload_path'] = 'assets/modules/crm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $id;
                            $attachment_array[$i]['rel_type'] = 'sale_order';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array, 'crm/editSaleOrder/' . $data['id']);
                        }
                    }
                    if ($data['id'] && $data['id'] != '') {
                        $result = $this->crm_model->delete_data('sale_order_priority', 'sale_order_id', $data['id']);
                    }
                    /* insert sale order priority */
                    $sale_order_priority_array = array();
                    $maxPriority = getMaxSaleOrderPriority();
                    $maxPriority = $maxPriority ? ($maxPriority + 1) : 1;
                    $j = 0;
                    while ($j < $products) {
                        $sale_order_priority_array[$j]['sale_order_id'] = $id;
                        $sale_order_priority_array[$j]['product_id'] = $_POST['product'][$j];
                        $sale_order_priority_array[$j]['quantity'] = $_POST['qty'][$j];
                        $sale_order_priority_array[$j]['uom'] = $_POST['uom'][$j];
                        $sale_order_priority_array[$j]['price'] = $_POST['price'][$j];
                        $sale_order_priority_array[$j]['individualTotal'] = $_POST['totals'][$j];
                        $sale_order_priority_array[$j]['individualTotalWithGst'] = $_POST['TotalWithGsts'][$j];
                        $sale_order_priority_array[$j]['priority'] = $maxPriority;
                        //$sale_order_priority_array[$j]['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                        $sale_order_priority_array[$j]['created_by_cid'] = $this->companyGroupId;
                        $j++;
                        $maxPriority++;
                    }
                    if (!empty($sale_order_priority_array)) {
                        $attachmentId = $this->crm_model->insertPriorityData('sale_order_priority', $sale_order_priority_array);
                    }
                    /* insert sale order priority */
                }
                redirect(base_url() . 'crm/sale_orders', 'refresh');
            }
        }
    }
    /*delete supplier*/
    public function deleteSaleOrder($id = '') {
        if (!$id) {
            redirect('crm/sale_orders', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->crm_model->delete_data('sale_order', 'id', $id);
        if ($result) {
            logActivity('Sale Order Deleted', 'Sale Order', $id);
            $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 9));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        /*pushNotification(array('subject'=> 'Sale order deleted' , 'message' => 'Sale order deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                        pushNotification(array('subject' => 'Sale order deleted', 'message' => 'Sale order id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                /*pushNotification(array('subject'=> 'Sale order deleted' , 'message' => 'Sale order deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                pushNotification(array('subject' => 'Sale order deleted', 'message' => 'Sale order id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
            }
            $this->session->set_flashdata('message', 'Sale Order Deleted Successfully');
            $result = array('msg' => 'Lead Deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/sale_orders');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    public function getMaterials() {
        $result = $this->data['materials'] = $this->crm_model->get_data('material');
        echo json_encode($result);
    }
    /* Sale Target Listing*/
    public function sale_targets() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Sale Target', base_url() . 'crm/sale_targets');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Sale Targets';
        //$userData  = $this->crm_model->get_data('user', array('c_id' => $_SESSION['loggedInUser']->c_id));
        $userData = $this->crm_model->get_data('user', array('c_id' => $this->companyGroupId));
         //pre($userData);
        $userId = '';
        if(!empty($userData)){
        foreach($userData as $ud){
           # pre($ud);
            $userId .= $ud['id'].',';
        }
         $userId = rtrim($userId,",");
        }else{
           $userId = '0';
        }
       # die;
        //die();
        //die();
        $saleTargetMonthWiseData = getSaleTargetByMonth($userId);
        $saleTargetArray = array();
        $saleTargetData = $saleTargetMonthWiseData;
        foreach ($saleTargetData as $sta) {
            //$targetLeadGeneratedWhere  = array('created_by_cid'=>$_SESSION['loggedInUser']->c_id,'lead_status'=>5, 'MONTH(created_date)'=> date("m",strtotime($sta['start_date'])) , 'YEAR(created_date)'=> date("Y",strtotime($sta['start_date'])));
            //$targetSaleTargetWhere  = array('created_by_cid'=>$_SESSION['loggedInUser']->c_id, 'MONTH(created_date)'=> date("m",strtotime($sta['start_date'])) , 'YEAR(created_date)'=>date("Y",strtotime($sta['start_date'])));
            $targetLeadGeneratedWhere = array('created_by_cid' => $this->companyGroupId, 'lead_status' => 5, 'MONTH(created_date)' => date("m", strtotime($sta['start_date'])), 'YEAR(created_date)' => date("Y", strtotime($sta['start_date'])));
            $targetSaleTargetWhere = array('created_by_cid' => $this->companyGroupId, 'MONTH(created_date)' => date("m", strtotime($sta['start_date'])), 'YEAR(created_date)' => date("Y", strtotime($sta['start_date'])));
            $acheivedLeadTarget = $this->crm_model->getLeadCountByUserId('leads', $targetLeadGeneratedWhere, $sta['start_date']);
            $acheivedSaleTarget = $this->crm_model->getLeadCountByUserId('sale_order', $targetSaleTargetWhere, $sta['start_date']);
            $saleTargetArray[] = array('acheivedLeadTarget' => $acheivedLeadTarget, 'saleTarget' => $sta, 'acheivedSaleTarget' => $acheivedSaleTarget['acheivedSaleTarget'], 'acheivedPaymentTarget' => $acheivedSaleTarget['acheivedPaymentTarget']);
        }
        $this->data['saleTargetData'] = $saleTargetArray;
        if (!empty($_POST)) {
            //$this->load->view('sale_target/index', $this->data);
            $this->_render_template('sale_target/index', $this->data);
        } else {
            $this->_render_template('sale_target/index', $this->data);
        }
    }
    public function editSaleTarget() {
        if ($this->input->post()) {
            if ($this->input->post('id') != '') {
                permissions_redirect('is_edit');
            } else {
                permissions_redirect('is_add');
            }
            $start_date = isset($_POST['start_date']) ? isset($_POST['start_date']) : '';
            $this->data['userSaleTarget'] = $this->crm_model->getSaleTargetEditDataByMonth($start_date);
            $this->load->view('sale_target/edit', $this->data);
        }
    }
    public function viewSaleTarget() {
        if ($this->input->post()) {
            if ($this->input->post('id') != '') {
                permissions_redirect('is_view');
            }
            $start_date = isset($_POST['start_date']) ? isset($_POST['start_date']) : '';
            $this->data['userSaleTarget'] = $this->crm_model->getSaleTargetEditDataByMonth($start_date);
            $this->load->view('sale_target/view', $this->data);
        }
    }
    /*  Function to add/update Sale Target */
    public function saveSaleTarget() {
        #pre($_POST);
        if ($this->input->post()) {
            $required_fields = array('sale_target', 'lead_generation_target', 'payment_target');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                if (!empty($data['user_id']) && $data['user_id'] != '') {
                    $target_array = array();
                    $userCount = count($data['user_id']);
                    $duplicateCount = 0;
                    for ($i = 0;$i < $userCount;$i++) {
                        $target_array[$i]['id'] = $data['id'][$i];
                        $target_array[$i]['user_id'] = $data['user_id'][$i];
                        $target_array[$i]['sale_target'] = $data['sale_target'][$i];
                        $target_array[$i]['lead_generation_target'] = $data['lead_generation_target'][$i];
                        $target_array[$i]['payment_target'] = $data['payment_target'][$i];
                        //$target_array[$i]['start_date'] = $data['start_date'].'-01';
                        $target_array[$i]['start_date'] = $data['start_date'] . '-01';
                        //$target_array[$i]['end_date'] = mb_substr($_POST['start_date'], 13, 10);
                        $target_array[$i]['created_by'] = $_SESSION['loggedInUser']->u_id;
                        #pre($target_array);
                        #echo $i;
                        if ($target_array[$i]['id'] == '') {
                            #echo 'in if con';
                            $checkUserTarget = $this->crm_model->userTargetExist($target_array[$i]['user_id'], $target_array[$i]['start_date']);
                            #pre($checkUserTarget);
                            #die;
                            if (!empty($checkUserTarget)) {
                                $duplicateCount++;
                            } else {
                                $inserted_id[$i] = $this->crm_model->insert_tbl_data('user_sale_target', $target_array[$i]);
                            }
                            //$inserted_id[$i] = $this->crm_model->insert_tbl_data('user_sale_target',$target_array[$i]);
                            /*if(!$inserted_id[$i]){

                            $duplicateCount++;

                            }*/
                        } else {
                            #echo 'in else con';
                            #pre($target_array);
                            $checkUserTarget = $this->crm_model->userTargetExist($target_array[$i]['user_id'], $target_array[$i]['start_date']);
                            #pre($checkUserTarget);
                            if (!empty($checkUserTarget)) {
                                $duplicateCount++;
                                $where = array('user_id' => $target_array[$i]['user_id'], 'id' => $target_array[$i]['id'], 'start_date' => $target_array[$i]['start_date']);
                                $success[$i] = $this->crm_model->updateSaleTarget('user_sale_target', $where, $target_array[$i]);
                                if ($success[$i]) {
                                    $data['message'] = "Sale Target updated successfully";
                                    logActivity('Sale Target Updated', 'lead', $target_array[$i]['id']);
                                }
                            } else {
                                #echo 'else';
                                #$duplicateCount++;
                                #$this->session->set_flashdata('message', 'Sale Target for this month is already set.');
                                #redirect(base_url().'crm/sale_targets', 'refresh');

                            }
                        }
                    }
                    #die;
                    #pre($duplicateCount); die;
                    if ($duplicateCount > 0) {
                        $this->session->set_flashdata('message', 'Sale Target for this month is already set.');
                        redirect(base_url() . 'crm/sale_targets', 'refresh');
                    } else {
                        $this->session->set_flashdata('message', 'Sale Target set successfully');
                        redirect(base_url() . 'crm/sale_targets', 'refresh');
                    }
                }
            }
        }
    }
    /* Main Function to fetch all the listing of departments */
    /*   public function proforma_invoice(){

    $this->data['can_edit'] = edit_permissions();

    $this->data['can_delete'] = delete_permissions();

    $this->data['can_add'] = add_permissions();

    $this->data['can_view'] = view_permissions();

    $this->breadcrumb->add('CRM', base_url() . 'crm/dashboard');

    $this->breadcrumb->add('Proforma Invoice', base_url() . 'crm/performa_invoice');

    $this->settings['breadcrumbs'] = $this->breadcrumb->output();

    $this->settings['pageTitle'] = 'Proforma Invoices';

    if(isset($_POST["favourites"])) {

    //$this->data['pis'] = $this->crm_model->get_data('proforma_invoice',array('created_by_cid'=> $_SESSION['loggedInUser']->c_id , 'favourite_sts'=> 1));

    $this->data['pis'] = $this->crm_model->get_data('proforma_invoice',array('created_by_cid'=>$this->companyGroupId , 'favourite_sts'=> 1));

    $this->_render_template('proforma_invoices/index', $this->data);

    }else{

    if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' && $_POST['favourites'] == '' ) {

    //$where = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id);

    $where = array('created_by_cid'=>$this->companyGroupId);

    $this->data['pis'] = $this->crm_model->get_own_tbl_data('proforma_invoice', $where,'','created_by_cid');

    $this->_render_template('proforma_invoices/index', $this->data);

    }

    if(!empty($_POST)){

    //$where = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id);

    $where = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $this->companyGroupId);

    }else

    //$where = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id);

    $where = array('created_by_cid'=> $this->companyGroupId);

    //$this->data['pis']  = $this->crm_model->get_data('proforma_invoice',$where);

    if($this->data['permissions']->is_view == 0){

        $this->data['pis'] = $this->crm_model->get_own_tbl_data('proforma_invoice', $where,'','created_by_cid');

    }else{

        # if view permission is enabled than users can see leads of others also

        $this->data['pis']  = $this->crm_model->get_data('proforma_invoice',$where);

    }

    if(!empty($_POST)){

    //$this->load->view('proforma_invoices/index', $this->data);

    $this->_render_template('proforma_invoices/index', $this->data);

    }else{

    $this->_render_template('proforma_invoices/index', $this->data);

    }

    }

    } */
    public function proforma_invoice() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('CRM', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Proforma Invoice', base_url() . 'crm/performa_invoice');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Proforma Invoices';
        $where = array('created_by_cid' => $this->companyGroupId);
        if (isset($_GET["favourites"]) != '' && isset($_GET["ExportType"]) == '') {
            $where = array('created_by_cid' => $this->companyGroupId, 'favourite_sts' => 1);
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET["favourites"]) == '' && isset($_GET["ExportType"]) == '' && isset($_GET["search"]) == '') {
            $where = array('created_date >=' => $_GET['start'], 'created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyGroupId);
        }
        if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites'] == '' && $_GET['search'] == '') {
            $where = array('created_by_cid' => $this->companyGroupId);
        } else if (isset($_GET["ExportType"]) != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['favourites'] == '' && $_GET["search"] == '') {
            $where = array('created_date >=' => $_GET['start'], 'created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyGroupId);
        } else if (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && isset($_GET['favourites']) != '') {
            $where = array('favourite_sts' => 1, 'created_by_cid' => $this->companyGroupId);
        } else if (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites'] == '' && $_GET["search"] != '') {
            $where = array('created_by_cid' => $this->companyGroupId);
        }
        //Search
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $where2 = "proforma_invoice.id like '%" . $search_string . "%' or proforma_invoice.pi_code like '%" . $search_string . "%'";
            redirect("crm/proforma_invoice/?search=$search_string");
        } else if (isset($_GET['search']) && $_GET['search'] != '') {
            $materialName = getNameBySearch('material', $_GET['search'], 'material_name');
            $accountName = getNameBySearch('account', $_GET['search'], 'name');
            $where2 = array();
            foreach ($materialName as $material_name) { //pre($name['id']);
                $json_dtl = '{"product" : "' . $material_name['id'] . '"}';
                $where2[] = "json_contains(`product`, '" . $json_dtl . "')";
            }
            foreach ($accountName as $name) { //pre($name['id']);
                $where2[] = "(proforma_invoice.account_id ='" . $name['id'] . "')";
            }
            if (sizeof($where2) != '') {
                $where2 = implode("||", $where2);
            } else {
                $where2 = "(proforma_invoice.id like'%" . $_GET['search'] . "%'  or proforma_invoice.pi_code like '%" . $_GET['search'] . "%')";
            }
            /*if(!empty($materialName->id)){
            $json_dtl ='{"product" : "'.$materialName->id.'"}';
            $where2 = "json_contains(`product`, '".$json_dtl."')" ;
            }/*else{
            $accountName=getNameById('account',$_GET['search'],'name');
            if(!empty($accountName->id)){
            $where2 = "(proforma_invoice.account_id like'%" .$accountName->id. "%')" ;
            }*/
            /*if(!empty($accountName->id)){
            $where2 = "(proforma_invoice.account_id ='" .$accountName->id. "')" ;
            }else
            {
            $where2 = "(proforma_invoice.id like'%" . $_GET['search'] . "%'  or proforma_invoice.pi_code like '%" . $_GET['search']. "%')";
            }*/
        }
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = "desc";
        }
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "crm/proforma_invoice/";
        $config["total_rows"] = $this->crm_model->tot_rows('proforma_invoice', $where, $where2);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $config['anchor_class'] = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        if ($this->data['permissions']->is_view == 0) {
            $this->data['pis'] = $this->crm_model->get_data_listing('proforma_invoice', $where, $config['per_page'], $page, $where2, $order, $export_data);
        } else {
            # if view permission is enabled than users can see leads of others also
            $this->data['pis'] = $this->crm_model->get_data_listing('proforma_invoice', $where, $config['per_page'], $page, $where2, $order, $export_data);
        }
        $this->_render_template('proforma_invoices/index', $this->data);
    }
    public function editProformaInvoice() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['pi'] = $this->crm_model->get_data_byId('proforma_invoice', 'id', $this->input->post('id'));
        $this->data['materials'] = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'proforma_invoice');
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        //$this->data['pia'] = $this->crm_model->get_activity_log('activity_log','rel_type' = 'Porforma Invoice','rel_id',$this->input->post('id'));
        //$pidata = array('rel_id'=> $this->input->post('id'), 'rel_type'=> 'Porforma Invoice');
        //$this->data['pia'] = $this->crm_model->get_where('activity_log', array('rel_type' => 'Porforma Invoice'));
        /*if($this->input->post('id') != ''){

        $where = array('p_id'=> $this->input->post('id'));

        $this->data['pi_activity'] = $this->crm_model->get_data('activity_log',$where);*/
        $this->load->view('proforma_invoices/edit', $this->data);
    }
    public function viewProformaInvoice() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_view');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['quotation'] = $this->crm_model->get_data_byId('quotation', 'id', $this->input->post('id'));
        $this->data['pi'] = $this->crm_model->get_data_byId('proforma_invoice', 'id', $this->input->post('id'));
        $this->data['materials'] = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'proforma_invoice');
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $where = array('rel_id' => $this->input->post('id'));
        $account_call_log = $this->crm_model->get_activity_log_PI('pi_comment_log', $where);
        $this->data['account_activities'] = $account_call_log;
        $this->load->view('proforma_invoices/view', $this->data);
    }
	public function viewMATProformaInvoice() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_view');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['quotation'] = $this->crm_model->get_data_byId('quotation', 'id', $this->input->post('id'));
        $this->data['pi'] = $this->crm_model->get_data_byId('proforma_invoice', 'id', $this->input->post('id'));
        $this->data['materials'] = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'proforma_invoice');
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->load->view('proforma_invoices/viewmat', $this->data);
    }
    /*  Function to add/update Lead aactivity */
    public function saveProformaInvoice() {
		 // pre($_POST);die();
        if ($this->input->post()) {
            $required_fields = array('account_id', 'product', 'qty', 'uom', 'price', 'order_date', 'dispatch_date');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $products = count($_POST['product']);
                $comp_id = $_POST['account_id'];
                if ($products > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $products) {
                        $material_type_id = getNameById('material_variants',$_POST['material_type_id'][$i],'id');
                        $jsonArrayObject = array('product_code' => $_POST['material_type_id'][$i], 'code_name' => $material_type_id->item_code,'product' => $_POST['product'][$i],'pro_img' => $_POST['pro_img'][$i], 'description' => $_POST['description'][$i], 'quantity' => $_POST['qty'][$i],'box' => $_POST['box'][$i],'standard_packing' => $_POST['standard_packing'][$i], 'uom' => $_POST['uom'][$i], 'price' => $_POST['price'][$i], 'gst' => $_POST['gst'][$i], 'individualTotal' => $_POST['totals'][$i], 'individualTotalWithGst' => @$_POST['TotalWithGsts'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                @$data['pi_paymode'] = json_encode($_POST['pi_paymode']);
               
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['product'] = $product_array;
                $data['material_type_id'] = json_encode($_POST['material_type_id']);
                #pre($data);
                $data['pi_code'] = ($data['revised_po_code'] != '') ? $data['revised_po_code'] : $data['pi_code'];
                $data['discount_offered'] = isset($data['discount_offered']) ? json_encode($data['discount_offered']) : '';
                $data['dispatch_documents'] = isset($data['dispatch_documents']) ? json_encode($data['dispatch_documents']) : '';
                #die;
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                $id = $data['id'];
                
                //pre($data_log); die;
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 12));
                if ($id && $id != '') {
					$data_log['apply_comment'] = $_POST['apply_comment'];
					$data_log['userid'] = $comp_id;
					$data_log['rel_type'] = 'Proforma Invoice';
					$data_log['rel_id'] = $id;
					$data_log['date'] = date("d/m/Y");
					
					$createdID = getNameById('proforma_invoice',$id,'id');
					
					$data['created_by'] = $createdID->created_by;
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->crm_model->update_data('proforma_invoice', $data, 'id', $id);
                    $this->crm_model->insert_tbl_data('pi_comment_log', $data_log);
                    if ($success) {
                        logActivity('Proforma Invoice Updated', 'Porforma Invoice', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*  pushNotification(array('subject'=> 'Proforma invoice updated' , 'message' => 'Proforma invoice updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Proforma Invoice updated', 'message' => 'Proforma Invoice updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'proforma_invoice_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*  pushNotification(array('subject'=> 'Proforma invoice updated deleted' , 'message' => 'Proforma invoice updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Proforma Invoice updated', 'message' => 'Proforma Invoice updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'proforma_invoice_view', 'icon' => 'fa fa-shekel'));
                        }
                        ComplogActivity($comp_id, 'Proforma Invoice Updated', 'Proforma Invoice', $id);
                        $this->session->set_flashdata('message', 'Proforma Invoice Updated successfully');
                    }
                } else {
					
					 $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                    $id = $this->crm_model->insert_tbl_data('proforma_invoice', $data);
					$data_log['apply_comment'] = $_POST['apply_comment'];
					$data_log['userid'] = $comp_id;
					$data_log['rel_type'] = 'Proforma Invoice';
					$data_log['rel_id'] = $id;
					$data_log['date'] = date("d/m/Y");
					// pre($data_log);die();
                    $this->crm_model->insert_tbl_data('pi_comment_log', $data_log);
					
                    if ($id) {
                        logActivity('New Porforma Invoice Created', 'Porforma Invoice', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*  pushNotification(array('subject'=> 'Proforma invoice created' , 'message' => 'Proforma invoice created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Proforma Invoice created', 'message' => 'New Proforma Invoice is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'proforma_invoice_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*pushNotification(array('subject'=> 'Proforma invoice created deleted' , 'message' => 'Proforma invoice created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));  */
                            pushNotification(array('subject' => 'Proforma Invoice created', 'message' => 'New Proforma Invoice is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'proforma_invoice_view', 'icon' => 'fa fa-shekel'));
                        }
                        ComplogActivity($comp_id, 'Proforma Invoice inserted successfully', 'Proforma Invoice', $id);
                        $this->session->set_flashdata('message', 'Porforma Invoice inserted successfully');
                    }
                }
                if ($id) {
                    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                        $attachment_array = array();
                        $certificateCount = count($_FILES['attachment']['name']);
                        for ($i = 0;$i < $certificateCount;$i++) {
                            $filename = $_FILES['attachment']['name'][$i];
                            $tmpname = $_FILES['attachment']['tmp_name'][$i];
                            $type = $_FILES['attachment']['type'][$i];
                            $error = $_FILES['attachment']['error'][$i];
                            $size = $_FILES['attachment']['size'][$i];
                            $exp = explode('.', $filename);
                            $ext = end($exp);
                            $newname = $exp[0] . '_' . time() . "." . $ext;
							$newname = str_replace(' ', '_', $newname);;
                            $config['upload_path'] = 'assets/modules/crm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $id;
                            $attachment_array[$i]['rel_type'] = 'proforma_invoice';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array, 'crm/editSaleOrder/' . $data['id']);
                        }
                    }
                }
                 redirect(base_url() . 'crm/proforma_invoice', 'refresh');
            }
        }
    }
    /*delete supplier*/
    public function deleteProformaInvoice($id = '') {
        if (!$id) {
            redirect('crm/proforma_invoice', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->crm_model->delete_data('proforma_invoice', 'id', $id);
        if ($result) {
            logActivity('Proforma Invoice Deleted', 'Proforma Invoice', $id);
            $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 12));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        /*pushNotification(array('subject'=> 'Proforma invoice deleted' , 'message' => 'Proforma invoice deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                        pushNotification(array('subject' => 'Proforma Invoice deleted', 'message' => 'Proforma Invoice id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                /*pushNotification(array('subject'=> 'Proforma invoice deleted' , 'message' => 'Proforma invoice deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                pushNotification(array('subject' => 'Proforma Invoice deleted', 'message' => 'Proforma Invoice id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
            }
            $this->session->set_flashdata('message', 'Proforma Invoice Deleted Successfully');
            $result = array('msg' => 'Proforma invoice Deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/proforma_invoice');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    public function create_pdf($id = '') {
        $this->load->library('Pdf');
        $dataPdf = $this->crm_model->get_data_byId('proforma_invoice', 'id', $id);
        create_pdf($dataPdf, 'modules/crm/views/proforma_invoices/view_pdf1.php');
        //$this->load->view('proforma_invoices/view_pdf');
        $this->load->view('proforma_invoices/view_pdf1');
    }
    /*

    public function convertPiIntoSaleOrder($id = ''){



    if($id != ''){

    permissions_redirect('is_edit');

    }else{

    permissions_redirect('is_add');

    }

    $piData = $this->crm_model->get_data_byId('proforma_invoice','id',$id);



    $sale_ordr_arr = array('sale_ordr_converted' => 1);

    $this->crm_model->update_after_save_saleorder('proforma_invoice',$sale_ordr_arr,'id',$id);



    $whereAttachment = array('rel_id'=> $id, 'rel_type'=> 'proforma_invoice');

    $this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments',$whereAttachment);



    $PiArray = (array) $piData;

    unset( $PiArray['id'] );

    if(!empty($PiArray)){

    $id = $this->crm_model->insert_tbl_data('sale_order',$PiArray);

    if ($id) {

    $attachment = $this->data['attachments'];

    if($this->data['attachments']){

        $attachment_array = array();

        $attachmentCount = count($attachment);

        for($i = 0; $i < $attachmentCount; $i++){

            $attachment_array[$i]['rel_id'] = $id;

            $attachment_array[$i]['rel_type'] = 'sale_order';

            $attachment_array[$i]['file_name'] = $attachment[$i]['file_name'];

            $attachment_array[$i]['file_type'] = $attachment[$i]['file_type'];

        }

        if(!empty($attachment_array)){

    /* Insert file information into the database */
    /*

            $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array,'crm/sale_orders');

        }

    }



    logActivity('Proforma Invoice converted into Sale Order','Sale Order',$id);

    $this->session->set_flashdata('message', 'Performa Invoice converted into Sale Order successfully');

    redirect(base_url().'crm/sale_orders', 'refresh');

    }

    }



    } */
    public function convertPiIntoSaleOrderview($id = '') {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['pi'] = $this->crm_model->get_data_byId('proforma_invoice', 'id', $this->input->post('id'));
        $this->data['materials'] = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'proforma_invoice');
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->load->view('sale_orders/pi_to_saleorder', $this->data);
    }
    public function convertPIIntoSaleOrdersave() {
        if ($this->input->post()) {
			// pre($_POST);die();
            $required_fields = array('account_id', 'product', 'qty', 'uom', 'price', 'order_date');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $products = count($_POST['product']);
                $comp_id = $_POST['account_id'];
                $sale_order_priority_array = array();
                if ($products > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product' => $_POST['product'][$i], 'description' => $_POST['description'][$i], 'quantity' => $_POST['qty'][$i], 'uom' => $_POST['uom'][$i], 'price' => $_POST['price'][$i], 'gst' => $_POST['gst'][$i], 'individualTotal' => $_POST['totals'][$i], 'individualTotalWithGst' => @$_POST['TotalWithGsts'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $data['pi_paymode'] = json_encode($_POST['pi_paymode']);
                $data['so_order'] = $_POST['so_order'];
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['product'] = $product_array;
                $data['material_type_id'] = json_encode($_POST['material_type_id']);
                $data['discount_offered'] = isset($data['discount_offered']) ? json_encode($data['discount_offered']) : '';
                $data['dispatch_documents'] = isset($data['dispatch_documents']) ? json_encode($data['dispatch_documents']) : '';
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                //  $data['payment_terms'] = json_encode($data['payment_terms']);
                $id = $data['id'];
                #pre($data); die;
                $sale_ordr_arr = array('sale_ordr_converted' => 1);
                $this->crm_model->update_after_save_saleorder('proforma_invoice', $sale_ordr_arr, 'id', $id);
                $id = $this->crm_model->insert_tbl_data('sale_order', $data);
                if ($id) {
                    if (!empty($arr)) {
                        foreach ($arr as $res) {
                            //$this->crm_model->update_single_value_data('material',array('sales_price'=>$res['price']), array('id'=> $res['product'],'created_by_cid'=>$_SESSION['loggedInUser']->c_id));
                            $this->crm_model->update_single_value_data('material', array('sales_price' => $res['price']), array('id' => $res['product'], 'created_by_cid' => $this->companyGroupId));
                        }
                    }
                    ComplogActivity($comp_id, 'Proforma Invoice Converted  to Sale Order', 'Sale Order', $id);
                    logActivity('New Sale Order Created', 'Sale Order', $id);
                    $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 9));
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                /*  pushNotification(array('subject'=> 'Proforma invoice converted into sale order' , 'message' => 'Proforma invoice converted into sale order by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.' from id '.$data["id"], 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                pushNotification(array('subject' => 'Proforma invoice converted into sale order', 'message' => 'Proforma invoice converted into sale order ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        /*pushNotification(array('subject'=> 'Proforma invoice converted into sale order' , 'message' => 'Proforma invoice converted into sale order by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.' from id '.$data["id"], 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id)); */
                        pushNotification(array('subject' => 'Proforma invoice converted into sale order', 'message' => 'Proforma invoice converted into sale order ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                    }
                    $this->session->set_flashdata('message', 'Sale Order inserted successfully');
                }
                if ($id) {
                    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                        $attachment_array = array();
                        $certificateCount = count($_FILES['attachment']['name']);
                        for ($i = 0;$i < $certificateCount;$i++) {
                            $filename = $_FILES['attachment']['name'][$i];
                            $tmpname = $_FILES['attachment']['tmp_name'][$i];
                            $type = $_FILES['attachment']['type'][$i];
                            $error = $_FILES['attachment']['error'][$i];
                            $size = $_FILES['attachment']['size'][$i];
                            $exp = explode('.', $filename);
                            $ext = end($exp);
                            $newname = $exp[0] . '_' . time() . "." . $ext;
							$newname = str_replace(' ', '_', $newname);;
                            $config['upload_path'] = 'assets/modules/crm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $id;
                            $attachment_array[$i]['rel_type'] = 'sale_order';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array, 'crm/editSaleOrder/' . $data['id']);
                        }
                    }
                    if ($data['id'] && $data['id'] != '') {
                        $result = $this->crm_model->delete_data('sale_order_priority', 'sale_order_id', $data['id']);
                    }
                    /* insert sale order priority */
                    $sale_order_priority_array = array();
                    $maxPriority = getMaxSaleOrderPriority();
                    $maxPriority = $maxPriority ? ($maxPriority + 1) : 1;
                    $j = 0;
                    while ($j < $products) {
                        $sale_order_priority_array[$j]['sale_order_id'] = $id;
                        $sale_order_priority_array[$j]['product_id'] = $_POST['product'][$j];
                        $sale_order_priority_array[$j]['quantity'] = $_POST['qty'][$j];
                        $sale_order_priority_array[$j]['uom'] = $_POST['uom'][$j];
                        $sale_order_priority_array[$j]['price'] = $_POST['price'][$j];
                        $sale_order_priority_array[$j]['individualTotal'] = $_POST['totals'][$j];
                        $sale_order_priority_array[$j]['individualTotalWithGst'] = @$_POST['TotalWithGsts'][$j];
                        $sale_order_priority_array[$j]['priority'] = $maxPriority;
                        //$sale_order_priority_array[$j]['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                        $sale_order_priority_array[$j]['created_by_cid'] = $this->companyGroupId;
                        $j++;
                        $maxPriority++;
                    }
                    if (!empty($sale_order_priority_array)) {
                        $attachmentId = $this->crm_model->insertPriorityData('sale_order_priority', $sale_order_priority_array);
                    }
                    /* insert sale order priority */
                }
                 redirect(base_url() . 'crm/sale_orders', 'refresh');
            }
        }
    }
    public function approveSaleOrder() {
        if ($_POST['nameAttributeId'] && $_POST['nameAttributeId'] != '') {
            $id = $this->input->get_post('id');
            $approve = $this->input->get_post('approve');
            $validated_by = $this->input->get_post('validated_by');
            $disapprove_reason = "";
            $disapprove = "0";
            $comp_id = $this->input->get_post('accountid');
            $str = implode(',', $comp_id);
            foreach ($id as $key) {
                $data = array('id' => $key, 'approve' => $_POST['approve'], 'validated_by' => $_POST['validated_by'], 'disapprove_reason' => '', 'disapprove' => 0, 'approve_date' => date('Y-m-d H:i:s'));
                $result = $this->crm_model->approveSaleOrder($data);
                ComplogActivity($str, 'Sale Order Approved', 'Sale Order', $key);
                logActivity('Sale orders approved', 'sale_order', $key);
            }
            if ($result) {
                logActivity('Sale order approved', 'sale_order', $key);
                $this->session->set_flashdata('message', 'Sale order approved');
                $result = array('msg' => 'Sale order approved', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/sale_orders');
                echo json_encode($result);
                die;
            } else {
                echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
            }
        }
    }
    public function approveSaleOrderindi() {
        if ($_POST['id'] && $_POST['id'] != '') {
            $data = array('approve' => $_POST['approve'], 'validated_by' => $_POST['validated_by'], 'disapprove_reason' => '', 'disapprove' => 0, 'approve_date' => date('Y-m-d H:i:s'));
            $result = $this->crm_model->approveSaleOrder($_POST);
            if ($result) {
                logActivity('Sale order approved', 'sale_order', $_POST['id']);
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 9));
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            /*pushNotification(array('subject'=> 'Sale order approved' , 'message' => 'Sale order approved by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$_POST["id"].'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $_POST["id"]));*/
                            pushNotification(array('subject' => 'Sale Order Approved', 'message' => 'Sale order approved ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $_POST['id'], 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    /*pushNotification(array('subject'=> 'Sale order approved' , 'message' => 'Sale order approved by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$_POST["id"].'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $_POST["id"]));  */
                    pushNotification(array('subject' => 'Sale Order Approved', 'message' => 'Sale order approved ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                }
                $this->session->set_flashdata('message', 'Sale order approved');
                $result = array('msg' => 'Sale order approved', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/sale_orders');
                echo json_encode($result);
                die;
            } else {
                echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
            }
        }
    }
    public function disApproveSaleOrder() {
        if ($this->input->post()) {
            $required_fields = array('disapprove_reason');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $comp_id = $_POST['aci'];
                $data = array('validated_by' => $_POST['validated_by'], 'disapprove' => $_POST['disapprove'], 'approve' => $_POST['approve'], 'disapprove_reason' => $_POST['disapprove_reason']);
                $idss = $_POST['id'];
                $success = $this->crm_model->disApproveSaleOrder($data, $idss);
                if ($success) {
                    $data['message'] = "Sale Order Disapproved";
                    ComplogActivity($comp_id, 'Sale Order Disapproved', 'Sale Order', $idss);
                    logActivity('Sale Order Disapproved', 'sale_order', $idss);
                    $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 9));
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                /*pushNotification(array('subject'=> 'Sale order disapproved' , 'message' => 'Sale order disapproved by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$_POST["id"].'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $_POST["id"]));*/
                                pushNotification(array('subject' => 'Sale Order Disapproved', 'message' => 'Sale order Disapproved ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $idss, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        /*pushNotification(array('subject'=> 'Sale order disapproved' , 'message' => 'Sale order disapproved by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$_POST["id"].'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $_POST["id"]));*/
                        pushNotification(array('subject' => 'Sale Order Disapproved', 'message' => 'Sale order Disapproved ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $idss, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                    }
                    $this->session->set_flashdata('message', 'Sale Order Disapproved successfully');
                    redirect(base_url() . 'crm/sale_orders', 'refresh');
                }
            }
        }
    }
    public function fetchLocationById() {
        //pre($_POST); die;
        $country = $this->crm_model->get_data_byId('country', 'country_id', $_POST['billing_country']);
        $state = $this->crm_model->get_data_byId('state', 'state_id', $_POST['billing_state']);
        $city = $this->crm_model->get_data_byId('city', 'city_id', $_POST['billing_city']);
        //echo $address = $country->country_name . '</br>'.  $state->state_name . '</br>'.  $city->city_name;
        $address = array('country' => $country->country_name, 'state' => $state->state_name, 'city' => $city->city_name);
        echo json_encode($address);
    }
    public function fetch_city() {
        if ($this->input->post('state_id')) {
            echo $this->crm_model->fetch_city($this->input->post('state_id'));
        }
    }
    # Function to delete Sale attachments
    public function deleteAttachment($id = '') {
        if (!$id) {
            redirect('crm/sale_orders', 'refresh');
        }
        $result = $this->crm_model->delete_data('attachments', 'id', $id);
        if ($result) {
            logActivity('Sale Order Attachment Deleted', 'sale_order', $id);
            $msg = 'Sale Order Attachment Deleted Successfully';
            $this->session->set_flashdata('message', $msg);
            $result = array('msg' => $msg, 'status' => 'success', 'code' => 'C174', 'url' => base_url() . 'crm/sale_orders');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }
    public function deleteAttachmentPI($id = '') {
        if (!$id) {
            redirect('crm/proforma_invoice', 'refresh');
        }
        $result = $this->crm_model->delete_data('attachments', 'id', $id);
        if ($result) {
            logActivity('Proforma Invoice Attachment Deleted', 'proforma_invoice', $id);
            $msg = 'Proforma Invoice Attachment Deleted Successfully';
            $this->session->set_flashdata('message', $msg);
            $result = array('msg' => $msg, 'status' => 'success', 'code' => 'C174', 'url' => base_url() . 'crm/proforma_invoice');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }
    public function getMaterialDataById() {
        if ($_POST['id'] != '') {
            $material = $this->crm_model->get_data_byId('material', 'id', $_POST['id']);
            $ww = getNameById('uom', $material->uom, 'id');
            $material->uom = $ww->ugc_code;
            $material->uomid = $ww->id;
            $attachments = $this->crm_model->get_image_by_materialId('attachments', 'rel_id', $_POST['id']);
            if(!empty($attachments)){
            $material->main_img_path = base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'];
            } else {
            $material->main_img_path = base_url().'assets/modules/crm/uploads/no_image.jpg';    
            }
            //pre($material);
            echo json_encode($material);
        }
    }
	public function getPAckingDAta() {
        if ($_POST['id'] != '') {
            $material_variant = $this->crm_model->get_data_byId('material_variants', 'id', $_POST['id']);
            echo $material_variant->packing_data;
        }
    }
    public function getMaterialDataByIdCA() {
        if ($_POST['id'] != '') {
            //pre($_POST['id']);
            $material = $this->crm_model->get_data_byId('material', 'id', $_POST['id']);
            if ($material->uom) {
                $ww = getNameById('uom', $material->uom, 'id');
                $material->uom = $ww->ugc_code;
                $material->uomid = $ww->id;
                // pre($material);
				// die('asdf');
                echo json_encode($material);
            }
        }
    }
    # Main Function to load dashboard
    public function dashboard() {
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
            redirect(base_url() . 'crm/leads/', 'refresh');
        }
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'dashboard');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Dashboard';
        $getPermissions = getPermissionsForDashboard(array('permissions.user_id' => $_SESSION['loggedInUser']->u_id, 'modules.id' => 5, 'permissions.is_view' => 1));
        $this->data['contactGraphPermission'] = $_SESSION['loggedInUser']->role == 1 ? 1 : 0;
        $this->data['accountGraphPermission'] = $_SESSION['loggedInUser']->role == 1 ? 1 : 0;
        $this->data['saleOrderGraphPermission'] = $_SESSION['loggedInUser']->role == 1 ? 1 : 0;
        $limit = 10;
        //$where = array('leads.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where = array('leads.created_by_cid' => $this->companyGroupId);
        if ($this->data['permissions']->is_view == 0) {
            $this->data['leads'] = $this->crm_model->get_own_tbl_data('leads', $where, $limit, 'lead_owner');
        } else {
            $this->data['leads'] = $this->crm_model->get_tbl_data('leads', $where, $limit);
        }
        if ((!empty($getPermissions) && $_SESSION['loggedInUser']->role == 2) || $_SESSION['loggedInUser']->role == 1) {
            $crm_contact_key = array_search('contacts', array_column($getPermissions, 'sub_module_name'));
            if (gettype($crm_contact_key) != 'boolean' || $crm_contact_key != '' || $_SESSION['loggedInUser']->role == 1) {
                //$contactWhere = array('contact_owner'=> $_SESSION['loggedInUser']->c_id);
                $contactWhere = array('contact_owner' => $this->companyGroupId);
                $this->data['contacts'] = $this->crm_model->get_data('contacts', $contactWhere, $limit);
                $this->data['contactGraphPermission'] = 1;
            } else {
                //$contactWhere = array('contact_owner'=> $_SESSION['loggedInUser']->c_id);
                $contactWhere = array('contact_owner' => $this->companyGroupId);
                $this->data['contacts'] = $this->crm_model->get_own_tbl_data('contacts', $where, $limit, 'contact_owner');
                $this->data['contactGraphPermission'] = 1;
            }
            $crm_account_key = array_search('accounts', array_column($getPermissions, 'sub_module_name'));
            if (gettype($crm_account_key) != 'boolean' || $crm_account_key != '' || $_SESSION['loggedInUser']->role == 1) {
                //  $accountWhere = array('account_owner'=> $_SESSION['loggedInUser']->c_id);
				if (isset($_GET['start']) != '' && $_GET['end'] != ''){
						$accountWhere = 	array('account.created_date >=' => $_GET['start'], 'account.created_date <=' => $_GET['end'], 'account.account_owner' => $this->companyGroupId);
					 
					 $this->data['accounts'] = $this->crm_model->get_data('account', $accountWhere, $limit);
					 $this->data['accountGraphPermission'] = 1;
				}else{
					 $accountWhere = array('account_owner' => $this->companyGroupId);
					 $this->data['accounts'] = $this->crm_model->get_data('account', $accountWhere, $limit);
					 $this->data['accountGraphPermission'] = 1;
				}
                $accountWhere = array('account_owner' => $this->companyGroupId);
                $this->data['accounts'] = $this->crm_model->get_data('account', $accountWhere, $limit);
                $this->data['accountGraphPermission'] = 1;
            } else {
                //$accountWhere = array('account_owner'=> $_SESSION['loggedInUser']->c_id);
                $accountWhere = array('account_owner' => $this->companyGroupId);
                $this->data['accounts'] = $this->crm_model->get_own_tbl_data('account', $accountWhere, $limit, 'account_owner');
                $this->data['accountGraphPermission'] = 1;
            }
            $sale_order_key = array_search('sale orders', array_column($getPermissions, 'sub_module_name'));
            if (gettype($sale_order_key) != 'boolean' || $sale_order_key != '' || $_SESSION['loggedInUser']->role == 1) {
                //$sale_orderWhere = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $sale_orderWhere = array('created_by_cid' => $this->companyGroupId);
                $this->data['sale_orders'] = $this->crm_model->get_data('sale_order', $sale_orderWhere, $limit);
                $this->data['saleOrderGraphPermission'] = 1;
            } else {
                //  $sale_orderWhere = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id,'created_by'=> $_SESSION['loggedInUser']->id);
                $sale_orderWhere = array('created_by_cid' => $this->companyGroupId, 'created_by' => $_SESSION['loggedInUser']->u_id);
                $this->data['sale_orders'] = $this->crm_model->get_own_tbl_data('sale_order', $sale_orderWhere, $limit, 'created_by_cid');
                $this->data['saleOrderGraphPermission'] = 1;
            }
        }
        $this->data['user_dashboard'] = $this->crm_model->get_data('user_dashboard', array('user_id' => $_SESSION['loggedInUser']->u_id));
        #pre($this->data['user_dashboard']);
        $this->_render_template('dashboard/index', $this->data);
    }
    /* Function to fetch all the CRM dashboard data with or without month-year range */
    public function graphDashboardData() {
		
        if (!empty($_POST)) {
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
        } else {
            $startDate = $endDate = '';
        } 
		
		// if (!empty($_GET)) {
            // $startDate = $_GET['startDate'];
            // $endDate = $_GET['endDate'];
        // } else {
            // $startDate = $endDate = '';
        // }
        $getPermissions = getPermissionsForDashboard(array('permissions.user_id' => $_SESSION['loggedInUser']->u_id, 'modules.id' => 5, 'permissions.is_view' => 1));
        $this->data['contactGraphPermission'] = $_SESSION['loggedInUser']->role == 1 ? 1 : 0;
        $this->data['accountGraphPermission'] = $_SESSION['loggedInUser']->role == 1 ? 1 : 0;
        $this->data['saleOrderGraphPermission'] = $_SESSION['loggedInUser']->role == 1 ? 1 : 0;
        $graphDashboardArray = array();
        if ((!empty($getPermissions) && $_SESSION['loggedInUser']->role == 2) || $_SESSION['loggedInUser']->role == 1) {
            $monthLeadStatusGraph = monthLeadStatusGraph($startDate, $endDate);
            $monthLeadTargetGraph = monthLeadTargetGraph($startDate, $endDate);
            $monthSaleOrderGraph = monthSaleOrderGraph($startDate, $endDate);
            $getLeadStatusGraph = getLeadStatusGraph($startDate, $endDate);
            $getWinLeadVsTotalGraph = getWinLeadVsTotalGraph($startDate, $endDate);
            $getDashboardCount = getDashboardCount($startDate, $endDate);
            $recentActivitiesDashboardData = recentActivitiesDashboardData($startDate, $endDate);
            $getCrmTableData = getCrmTableData($startDate, $endDate);
        }
        $graphDashboardArray = array('monthLeadStatusGraph' => $monthLeadStatusGraph, 'monthLeadTargetGraph' => $monthLeadTargetGraph, 'monthSaleOrderGraph' => $monthSaleOrderGraph, 'getLeadStatusGraph' => $getLeadStatusGraph, 'getWinLeadVsTotalGraph' => $getWinLeadVsTotalGraph, 'getDashboardCount' => $getDashboardCount, 'leadActivity' => $recentActivitiesDashboardData['leadActivity'], 'accountActivity' => $recentActivitiesDashboardData['accountActivity'], 'saleOrderActivity' => $recentActivitiesDashboardData['saleOrderActivity'], 'getCrmTableData' => $getCrmTableData);
        echo json_encode($graphDashboardArray);
    }
    public function showDashboardOnRequirement() {
        $data = $_POST;
        $data['user_id'] = $_SESSION['loggedInUser']->u_id;
        $userDashboardRes = $this->crm_model->get_data('user_dashboard', array('user_id' => $_SESSION['loggedInUser']->u_id, 'graph_id' => $data['graph_id']));
        if (!empty($userDashboardRes)) {
            $id = $this->crm_model->update_data('user_dashboard', $data, 'id', $userDashboardRes[0]['id']);
        } else {
            $id = $this->crm_model->insert_tbl_data('user_dashboard', $data);
        }
        if ($id) {
            $result = array('msg' => 'Data for user set', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/dsahbaord');
            echo json_encode($result);
            die;
        }
    }
    /* Controller for quick Add*/
    public function add_matrial_Details_onthe_spot() {
        //pre($_POST);die;
        #echo "kmkldmkmk";
        #die;
        $material_name = $_REQUEST['material_name'];
        $hsn_code = $_REQUEST['hsn_code'];
        $uom = $_REQUEST['uom'];
        //  echo 'value of'.$uom;
        $specification = $_REQUEST['specification'];
        $gst_tax = $_REQUEST['gst_tax'];
        $opening_balance = $_REQUEST['opening_balance'];
        $material_type_id = $_REQUEST['material_type_id'];
        $prefix = $_REQUEST['prefix'];
        $created_by_id = $_SESSION['loggedInUser']->u_id;
        //$created_by_cid  = $_SESSION['loggedInUser']->c_id;
        $created_by_cid = $this->companyGroupId;
        $last_id = getLastTableId('material');
        $rId = $last_id + 1;
        $matCode = 'MAT_' . rand(1, 1000000) . '_' . $rId;
        $matrial_details = array('material_name' => $material_name, 'hsn_code' => $hsn_code, 'uom' => $uom, 'specification ' => $specification, 'created_by ' => $created_by_id, 'tax ' => $gst_tax, 'opening_balance ' => $opening_balance, 'material_type_id ' => $material_type_id, 'prefix ' => $prefix, 'material_code ' => $matCode, 'created_by ' => $created_by_id, 'created_by_cid ' => $created_by_cid,);
        # die;
         pre($matrial_details);die('there');
        $data2 = $this->crm_model->insert_on_spot_tbl_data('material', $matrial_details);
        $comp_details = getNameById('company_address', $this->companyGroupId, 'created_by_cid');
        #echo "comp";
        #pre($comp_details);
        $area1 = "";;
        $dataArray = json_decode($comp_details->area);
        foreach ($dataArray as $key) {
            $area1 = $key->area;
        }
        $matdtl = array('material_type_id' => $material_type_id, 'material_name_id' => $data2, 'location_id' => $comp_details->id, 'Storage' => $area1, 'quantity' => $opening_balance, 'Qtyuom' => $uom, 'created_by_cid' => $this->companyGroupId);
        $this->crm_model->insert_tbl_data('mat_locations', $matdtl);
        $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 4));
        if (!empty($usersWithViewPermissions)) {
            foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                    /*pushNotification(array('subject'=> 'New Product created' , 'message' => 'New Product created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$data2.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $data2));*/
                    pushNotification(array('subject' => 'New Product created', 'message' => 'New Product is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $data2, 'class' => 'add_crm_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-shekel'));
                }
            }
        }
        if ($_SESSION['loggedInUser']->role != 1) {
            /*pushNotification(array('subject'=> 'New Product created' , 'message' => 'New Product created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$data2.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $data2));  */
            pushNotification(array('subject' => 'New Product created', 'message' => 'New Product is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $data2, 'class' => 'add_crm_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-shekel'));
        }
        #die;
        if ($data2 > 0) {
            echo 'true';
        } else {
            echo 'false';
        }
    }
    /* Controller for quick Add*/
    public function Get_matrial_type() {
        //pre($_POST['user_id']);
        if ($_POST['mat_id'] != '') {
            $get_data = $this->crm_model->get_data_material_type('material_type', 'id', $_POST['mat_id']);
            echo json_encode($get_data, true);
            die;
        }
    }
    /* Controller for quick Add customer in performa_invoice*/
    public function add_customer_Details_onthe_spot() {
        //pre($_POST); die;
        $BAddressArrayObject = array();
        $account_owner = $_REQUEST['account_owner'];
        $customer_name = $_REQUEST['customer_name'];
        $type_of_customer = $_REQUEST['type_of_customer'];
        $gstin = $_REQUEST['gstin'];
        $phone_number = $_REQUEST['phone_number'];
        $billing_street = $_REQUEST['billing_street'];
        $billing_zipcode = $_REQUEST['billing_zipcode'];
        $billing_country = $_REQUEST['billing_country'];
        $billing_city = $_REQUEST['billing_city'];
        $billing_state = $_REQUEST['billing_state'];
        $created_by_id = $_SESSION['loggedInUser']->u_id;
        $country = getNameById('country', $_REQUEST['billing_country'],'country_id');
        $country_name = $country->country_name;
        $state = getNameById('state', $_REQUEST['billing_state'],'state_id');
        $state_name = $state->state_name;
        $city = getNameById('city', $_REQUEST['billing_city'],'city_id');
        $city_name = $city->city_name;
        //$created_by_cid  = $_SESSION['loggedInUser']->c_id;
        $BAddressArrayObject[] = (array('billing_company_1' =>$customer_name,'billing_street_1' => $_REQUEST['billing_street'], 'billing_country_1' => $_REQUEST['billing_country'], 'billing_state_1' => $_REQUEST['billing_state'], 'billing_city_1' => $_REQUEST['billing_city'], 'billing_zipcode_1' => $_REQUEST['billing_zipcode'], 'billing_gstin_1' => $_REQUEST['gstin'], 'billing_phone_addrs' => $_REQUEST['phone_number'], 'same_shipping' => '', 'address_type' => 'billing', 'country_name' => $country_name, 'state_name' => $state_name, 'city_name' => $city_name));
        $address_array = json_encode($BAddressArrayObject);
		
        $customer_details = array('account_owner' => $account_owner, 'name' => $customer_name, 'gstin' => $gstin, 'phone' => $phone_number, 'billing_street' => $billing_street, 'billing_zipcode ' => $billing_zipcode, 'created_by ' => $created_by_id, 'billing_country ' => $billing_country, 'billing_state ' => $billing_state, 'billing_city ' => $billing_city, 'new_billing_address ' => $address_array, 'created_by ' => $created_by_id,'type_of_customer'=>$type_of_customer);
        //pre($customer_details);die('there');
         $id = $this->crm_model->insert_on_spot_tbl_data('account', $customer_details);
		 
				$dataLedger['name'] = $_REQUEST['customer_name'];
                $dataLedger['email'] = '';
                $dataLedger['phone_no'] = $_REQUEST['phone_number'];
                $dataLedger['gstin'] = $_REQUEST['gstin'];
                $dataLedger['account_group_id'] = '54';
                $dataLedger['parent_group_id'] = '6';
				$dataLedger['areastation'] = '';
               
                $dataLedger['conn_comp_id'] = 0;
                $dataLedger['compny_branch_id'] = 0;
                $dataLedger['opening_balance'] = 0;
                $dataLedger['created_by_cid'] = $this->companyGroupId;
				
				$dataLedger['salesPersons'] = null;
				$mailing_namelength = 1;
				if ( $mailing_namelength > 0) {
				$arr = [];
                    $i = 0;
                    $tt = 1;
				  while ($i < $mailing_namelength) {
					  
						
						$jsonArrayObject = (array('ID' => $tt,'mailing_name' =>$_REQUEST['customer_name'][$i],'mailing_address' => $_REQUEST['billing_street'][$i], 'mailing_country' => $_REQUEST['billing_country'][$i], 'mailing_state' => $_REQUEST['billing_state'][$i], 'mailing_city' => $_REQUEST['billing_city'][$i], 'mailing_pincode' => $_REQUEST['billing_zipcode'][$i],'gstin_no' => $_REQUEST['gstin'][$i]));
						$arr[] = $jsonArrayObject;
						$i++;
                        $tt++;	
				  }
				  $descr_of_ldgr_array = json_encode($arr);
				}else{
					 $descr_of_ldgr_array = '';
				}
						$dataLedger['mailing_address'] = $descr_of_ldgr_array;
						$dataLedger['customer_id'] = $id;
                        $dataLedger['created_by'] = $_SESSION['loggedInUser']->u_id;
                        $dataLedger['edited_by'] = $_SESSION['loggedInUser']->u_id;
                        $dataLedger['created_by_cid'] = $this->companyGroupId;
                        $dataLedger['save_status'] = 1;

                        $ledger_id=$this->crm_model->insert_tbl_data('ledger', $dataLedger);
                        $data2=array('ledger_id'=>$ledger_id);
                        $this->crm_model->update_single_value_data('account', $data2, array('id'=> $id));
						$usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
        if (!empty($usersWithViewPermissions)) {
            foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                    pushNotification(array('subject' => 'Company created', 'message' => 'New Comapny is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'account_view', 'icon' => 'fa fa-shekel'));
                }
            }
        }
        if ($_SESSION['loggedInUser']->role != 1) {
            /*pushNotification(array('subject'=> 'New company created' , 'message' => 'New company created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$data2.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $data2));  */
            pushNotification(array('subject' => 'Company created', 'message' => 'New Comapny is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'account_view', 'icon' => 'fa fa-shekel'));
        }
        if ($id > 0) {
            echo '1';
        } else {
            echo '0';
        }
    }
    /* Controller for quick Add contacts in performa_invoice and sale order*/
    public function add_contact_Details_onthe_spot() {
        //pre($_POST);
        $contact_owner = $_REQUEST['contact_owner'];
        $contact_name = $_REQUEST['contact_name'];
        $account_id = $_REQUEST['account_id'];
        $email = $_REQUEST['email_id'];
        $phone_number = $_REQUEST['ph_no'];
        $contact_details = array('contact_owner' => $contact_owner, 'first_name' => $contact_name, 'account_id' => $account_id, 'email' => $email, 'phone' => $phone_number,);
        $data2 = $this->crm_model->insert_on_spot_tbl_data('contacts', $contact_details);
        $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 8));
        if (!empty($usersWithViewPermissions)) {
            foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                    /*  pushNotification(array('subject'=> 'New contact created' , 'message' => 'New contact created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$data2.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $data2));*/
                    pushNotification(array('subject' => 'New Contact created', 'message' => 'New Contact is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $data2, 'class' => 'add_crm_tabs', 'data_id' => 'contact_view', 'icon' => 'fa fa-shekel'));
                }
            }
        }
        if ($_SESSION['loggedInUser']->role != 1) {
            /*pushNotification(array('subject'=> 'New contact created' , 'message' => 'New contact created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$data2.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $data2));  */
            pushNotification(array('subject' => 'New Contact created', 'message' => 'New Contact is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $data2, 'class' => 'add_crm_tabs', 'data_id' => 'contact_view', 'icon' => 'fa fa-shekel'));
        }
        if ($data2 > 0) {
            echo 'true';
        } else {
            echo 'false';
        }
    }
    public function dispatchSaleOrder() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['sale_order'] = $this->crm_model->get_data_byId('sale_order', 'id', $this->input->post('id'));
        $this->data['sale_order_dispatch'] = $this->crm_model->get_data('sale_order_dispatch', array('sale_order_id' => $this->input->post('id')));
        //$this->data['materials']  = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'sale_order');
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->load->view('sale_orders/dispatch', $this->data);
    }
    /*  Function to add/update Lead aactivity */
    public function saveDispatchSaleOrder() {
        if ($this->input->post()) {
            $required_fields = array('account_id', 'product', 'qty', 'uom', 'price');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $products = count($_POST['product']);
                $comp_id = $_POST['account_id'];
                $sale_order_priority_array = array();
                if ($products > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product' => $_POST['product'][$i], 'description' => $_POST['description'][$i], 'quantity' => $_POST['qty'][$i], 'uom' => $_POST['uom'][$i], 'price' => $_POST['price'][$i], 'gst' => $_POST['gst'][$i], 'individualTotal' => $_POST['totals'][$i], 'individualTotalWithGst' => $_POST['TotalWithGsts'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['product'] = $product_array;
                $data['dispatch_documents'] = isset($data['dispatch_documents']) ? json_encode($data['dispatch_documents']) : '';
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                //  $data['payment_terms'] = json_encode($data['payment_terms']);
                $id = $data['id'];
                #pre($data); die;
                /*if($id && $id != ''){

                $success = $this->crm_model->update_data('sale_order_dispatch',$data, 'id', $id);

                if ($success) {

                        $data['message'] = "Sale Order dispatch updated successfully";

                        logActivity('Sale Order dispatch Updated','lead',$id);

                        $this->session->set_flashdata('message', 'Sale Order dispatch Updated successfully');

                    }

                #}else{*/
                $id = $this->crm_model->insert_tbl_data('sale_order_dispatch', $data);
                if ($id) {
                    ComplogActivity($comp_id, 'Sale Order Dispatched', 'Sale Order Dispatched', $id);
                    logActivity('Sale Order Dispatched', 'Sale Order Dispatched', $id);
                    $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 9));
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInCompany']->u_id) {
                                /*pushNotification(array('subject'=> 'Sale order dispatched' , 'message' => 'Sale order dispatched by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                pushNotification(array('subject' => 'Sale Order Dispatched', 'message' => 'Sale order dispatched by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        /*pushNotification(array('subject'=> 'Sale order dispatched' , 'message' => 'Sale order dispatched by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));    */
                        pushNotification(array('subject' => 'Sale Order Dispatched', 'message' => 'Sale order dispatched by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                    }
                    $this->session->set_flashdata('message', 'Sale Order Dispatched successfully');
                }
                #}
                if ($id) {
                    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                        $attachment_array = array();
                        $certificateCount = count($_FILES['attachment']['name']);
                        for ($i = 0;$i < $certificateCount;$i++) {
                            $filename = $_FILES['attachment']['name'][$i];
                            $tmpname = $_FILES['attachment']['tmp_name'][$i];
                            $type = $_FILES['attachment']['type'][$i];
                            $error = $_FILES['attachment']['error'][$i];
                            $size = $_FILES['attachment']['size'][$i];
                            $exp = explode('.', $filename);
                            $ext = end($exp);
                            $newname = $exp[0] . '_' . time() . "." . $ext;
							$newname = str_replace(' ', '_', $newname);;
                            $config['upload_path'] = 'assets/modules/crm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $id;
                            $attachment_array[$i]['rel_type'] = 'sale_order_dispatch';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array, 'crm/editSaleOrder/' . $data['id']);
                        }
                    }
                    /* insert sale order priority */
                }
                redirect(base_url() . 'crm/sale_orders', 'refresh');
            }
        }
    }
    public function completeSaleOrder() {
        if ($_POST['id'] && $_POST['id'] != '') {
            #$data = array('complete_status' => $_POST['complete_status'] , 'completed_by' => $_POST['completed_by']);
            $result = $this->crm_model->completeSaleOrder($_POST);
            if ($result) {
                ComplogActivity($_POST['datasaleorderai'], 'Sale Order Complete', 'Sale Order Dispatched compltely', $_POST['id']);
                logActivity('Sale order dispatched compltely', 'Sale Order', $_POST['id']);
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 9));
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            /*  pushNotification(array('subject'=> 'Sale order completed' , 'message' => 'Sale order completed by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Sale Order Completed', 'message' => 'Sale order completed by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $data2, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    /*pushNotification(array('subject'=> 'Sale order completed' , 'message' => 'Sale order completed by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$_POST["id"], 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $_POST['id']));*/
                    pushNotification(array('subject' => 'Sale Order Completed', 'message' => 'Sale order completed by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $data2, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                }
                $this->session->set_flashdata('message', 'Sale order dispatched compltely');
                $result = array('msg' => 'Sale order  dispatched compltely', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/sale_orders');
                echo json_encode($result);
                die;
            } else {
                echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
            }
        }
    }
    /*get company  addresses in crm sale order*/
    function getAddress() {
        //$where = array('id' => $_SESSION['loggedInUser']->c_id);
        $where = array('id' => $this->companyGroupId);
		$data = $this->crm_model->get_data_byAddress('company_detail', $where);

        $data1 = $data[0]['address'];

        $data2 = json_decode($data1);

        $addressArray = array();
        $i = 0;
        foreach ($data2 as $dt) {
            $addressArray[$i]['id'] = $dt->compny_branch_name;
            $addressArray[$i]['text'] = $dt->compny_branch_name;
            $i++;
        }
        echo json_encode($addressArray);
    }
    // For Indexing Quotation
    /*  public function quotation(){

    $this->data['can_edit'] = edit_permissions();

    $this->data['can_delete'] = delete_permissions();

    $this->data['can_add'] = add_permissions();

    $this->data['can_view'] = view_permissions();

    $this->breadcrumb->add('CRM', base_url() . 'crm/dashboard');

    $this->breadcrumb->add('Quotation', base_url() . 'crm/quotation');

    $this->settings['breadcrumbs'] = $this->breadcrumb->output();

    $this->settings['pageTitle'] = 'Quotation';

    if (isset($_POST['favourites'])){

    $this->data['quotation'] = $this->crm_model->get_data('quotation',array('created_by_cid'=> $this->companyGroupId , 'favourite_sts'=> 1));

    }else{

    $this->data['quotation'] = $this->crm_model->get_data('quotation',array('created_by_cid'=>$this->companyGroupId));

    }

    $this->_render_template('quotation/index', $this->data);

    } */
    public function quotation() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('CRM', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Quotation', base_url() . 'crm/quotation');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Quotation';
        $this->data['search_string'] = '';
        /*$search_string = $this->input->post('search');

        $likeArray = array( 'quotation.account_id' => $search_string,

        'quotation.contact_id' => $search_string

        );      */
        $where = array('created_by_cid' => $this->companyGroupId);
        if (isset($_GET['favourites']) != '' && isset($_GET['ExportType']) == '') {
            $where = array('created_by_cid' => $this->companyGroupId, 'favourite_sts' => 1);
        }
        if (isset($_GET['start']) != '' && $_GET['end'] != '' && isset($_GET['ExportType']) == '' && isset($_GET['favourites']) == '') {
            $where = array('created_by_cid' => $this->companyGroupId, 'created_date>=' => $_GET['start'], 'created_date<=' => $_GET['end']);
        }
        if (isset($_GET['ExportType']) != '' && $_GET['favourites'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search'] == '') {
            $where = array('created_by_cid' => $this->companyGroupId);
        } elseif (isset($_GET['ExportType']) != '' && $_GET['favourites'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search'] == '') {
            $where = array('created_by_cid' => $this->companyGroupId, 'favourite_sts' => 1);
        } elseif (isset($_GET['ExportType']) != '' && $_GET['favourites'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['search'] == '') {
            $where = array('created_by_cid' => $this->companyGroupId, 'created_date>=' => $_GET['start'], 'created_date<=' => $_GET['end']);
        }
        //Search
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $accountName = getNameBySearch('account', $_GET['search'], 'name');
            $where2 = array();
            foreach ($accountName as $name) { //pre($name['id']);
                $where2[] = "(quotation.account_id ='" . $name['id'] . "')";
            }
            if (sizeof($where2) != '') {
                $where2 = implode("||", $where2);
            } else {
                $where2 = " quotation.id like '%" . $search_string . "%'";
            }
            redirect("crm/quotation/?search=$search_string");
        } else if (!empty($_GET['search']) && $_GET['search'] != '') {
            $accountName = getNameBySearch('account', $_GET['search'], 'name');
            $where2 = array();
            foreach ($accountName as $name) { //pre($name['id']);
                $where2[] = "(quotation.account_id ='" . $name['id'] . "')";
            }
            if (sizeof($where2) != '') {
                $where2 = implode("||", $where2);
            } else {
                $where2 = " quotation.id like'%" . $_GET['search'] . "%'";
            }
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "crm/quotation/";
        $config["total_rows"] = $this->crm_model->tot_rows('quotation', $where, $where2);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $config['anchor_class'] = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        # if view permission is enabled than users can see leads of others also
        $this->data['quotation'] = $this->crm_model->get_data_listing('quotation', $where, $config['per_page'], $page, $where2, $order, $export_data);
        $this->_render_template('quotation/index', $this->data);
    }
    // For Editing Quotation
    public function quotation_edit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['quot'] = $this->crm_model->get_data_byId('quotation', 'id', $this->input->post('id'));
        $this->data['materials'] = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'quotation');
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->load->view('quotation/edit', $this->data);
    }
    // For Saving Quotation
    public function saveQuotation() {
        if ($this->input->post()) {
            $required_fields = array('product', 'phone_no');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $products = count($_POST['product']);
                $comp_id = $_POST['account_id'];
                if ($products > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product' => $_POST['product'][$i], 'description' => $_POST['description'][$i], 'quantity' => $_POST['qty'][$i], 'uom' => $_POST['uom'][$i], 'price' => $_POST['price'][$i], 'gst' => $_POST['gst'][$i], 'total' => $_POST['totals'][$i], 'TotalWithGst' => $_POST['TotalWithGsts'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['product'] = $product_array;
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 94));
                #pre($data);
                #die;
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                $id = $data['id'];
                if ($id && $id != '') {
                    $success = $this->crm_model->update_data('quotation', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Quotation updated successfully";
                        logActivity('Quotation Updated', 'Quotation', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Quotation updated' , 'message' => 'Quotation updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Quotation updated', 'message' => 'Quotation updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'quotation_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*  pushNotification(array('subject'=> 'Quotation updated' , 'message' => 'Quotation updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));  */
                            pushNotification(array('subject' => 'Quotation updated', 'message' => 'Quotation updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'quotation_view', 'icon' => 'fa fa-shekel'));
                        }
                        ComplogActivity($comp_id, 'Quotation Updated', 'Quotation', $id);
                        $this->session->set_flashdata('message', 'Quotation Updated successfully');
                    }
                } else {
                    //echo $comp_id = $_POST['accountid'];
                    //  die();
                    $id = $this->crm_model->insert_tbl_data('quotation', $data);
                    if ($id) {
                        logActivity('New Quotation Created', 'Quotation', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'New quotation created' , 'message' => 'New quotation created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'New quotation created', 'message' => 'New quotation is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'quotation_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*  pushNotification(array('subject'=> 'New quotation created' , 'message' => 'New quotation created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));  */
                            pushNotification(array('subject' => 'New quotation created', 'message' => 'New quotation is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'quotation_view', 'icon' => 'fa fa-shekel'));
                        }
                        ComplogActivity($comp_id, 'New Quotation Created', 'Quotation', $id);
                        $this->session->set_flashdata('message', 'Quotation inserted successfully');
                    }
                }
                if ($id) {
                    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                        $attachment_array = array();
                        $certificateCount = count($_FILES['attachment']['name']);
                        for ($i = 0;$i < $certificateCount;$i++) {
                            $filename = $_FILES['attachment']['name'][$i];
                            $tmpname = $_FILES['attachment']['tmp_name'][$i];
                            $type = $_FILES['attachment']['type'][$i];
                            $error = $_FILES['attachment']['error'][$i];
                            $size = $_FILES['attachment']['size'][$i];
                            $exp = explode('.', $filename);
                            $ext = end($exp);
                            $newname = $exp[0] . '_' . time() . "." . $ext;
							$newname = str_replace(' ', '_', $newname);;
                            $config['upload_path'] = 'assets/modules/crm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $id;
                            $attachment_array[$i]['rel_type'] = 'proforma_invoice';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array, 'crm/editSaleOrder/' . $data['id']);
                        }
                    }
                }
                redirect(base_url() . 'crm/quotation', 'refresh');
            }
        }
    }
    // For Viewing Quotation
    public function viewQuotation() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_view');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['quotation'] = $this->crm_model->get_data_byId('quotation', 'id', $this->input->post('id'));
        $this->data['materials'] = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'quotation');
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->load->view('quotation/view', $this->data);
    }
	public function viewQuotationmaterial() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_view');
        }
		 $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['quotation'] = $this->crm_model->get_data_byId('quotation', 'id', $this->input->post('id'));
        $this->data['materials'] = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'quotation');
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
          $this->data['materials'] = $this->crm_model->get_data('material');
          $this->load->view('quotation/viewmat', $this->data);
    }
    // For Deleting Quotation
    public function deletequotation($id = '') {
        if (!$id) {
            redirect('crm/quotation', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->crm_model->delete_data('quotation', 'id', $id);
        if ($result) {
            logActivity('Quotation Deleted', 'Quotation', $id);
            $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 94));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        /*pushNotification(array('subject'=> 'Quotation deleted' , 'message' => 'Quotation deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                        pushNotification(array('subject' => 'Quotation deleted', 'message' => 'Quotation id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                /*pushNotification(array('subject'=> 'Quotation deleted' , 'message' => 'Quotation deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                pushNotification(array('subject' => 'Quotation deleted', 'message' => 'Quotation id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
            }
            $this->session->set_flashdata('message', 'Quotation Deleted Successfully');
            $result = array('msg' => 'Quotation Deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/quotation');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    // For Creating PDF of Quotation
    public function Quotcreate_pdf($id = '') {
        $this->load->library('Pdf');
        $dataPdf = $this->crm_model->get_data_byId('quotation', 'id', $id);
        create_pdf($dataPdf, 'modules/crm/views/quotation/view_pdf1.php');
        //$this->load->view('proforma_invoices/view_pdf');
        $this->load->view('quotation/view_pdf1');
    }
    // For Indexing Terms & Condtions
    public function crmterms_condtn() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('CRM', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Settings', base_url() . 'crm/settings');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Term And Conditions';
        $where = array('created_by_cid' => $this->companyGroupId);
        if (isset($_GET["favourites"]) != '' && isset($_GET["ExportType"]) == '') {
            $where = array('created_by_cid' => $this->companyGroupId, 'favourite_sts' => 1);
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['favourites']) == '') {
            $where = array('termscond.created_date >=' => $_GET['start'], 'termscond.created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyGroupId);
        }
        if (isset($_GET['termscond_name']) != '' && isset($_GET['ExportType']) == '') {
            $where = array('created_by_cid' => $this->companyGroupId, 'created_by' => $_GET['termscond_name']);
        }
        if (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites'] == '' && $_GET['termscond_name'] == '') {
            $where = array('created_by_cid' => $this->companyGroupId);
            #$this->_render_template('contacts/index', $this->data);

        } else if (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites'] != '' && $_GET['termscond_name'] == '') {
            $where = array('favourite_sts' => 1, 'created_by_cid' => $this->companyGroupId);
            #$this->_render_template('contacts/index', $this->data);
            //pre($where);die();

        } else if (isset($_GET["ExportType"]) != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['favourites'] == '' && $_GET['termscond_name'] == '') {
            $where = array('termscond.created_date >=' => $_GET['start'], 'termscond.created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyGroupId);
            #$this->_render_template('contacts/index', $this->data);

        } else if (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites'] == '' && $_GET['termscond_name'] != '') {
            $where = array('created_by' => $_GET['termscond_name'], 'created_by_cid' => $this->companyGroupId);
            #$this->_render_template('contacts/index', $this->data);
            //pre($where);die();

        }
        //Search
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $where2 = "(termscond.id like '%" . $search_string . "%' or termscond.terms_tittle like '%" . $search_string . "%')";
            redirect("crm/crmterms_condtn/?search=$search_string");
        } else if (isset($_GET['search'])) {
            $where2 = "(termscond.terms_tittle like'%" . $_GET['search'] . "%' or termscond.id like'%" . $_GET['search'] . "%')";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "crm/crmterms_condtn/";
        $config["total_rows"] = $this->crm_model->tot_rows('termscond', $where, $where2);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $config['anchor_class'] = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['termsconds'] = $this->crm_model->get_data1('termscond', $where, $config["per_page"], $page, $where2, $order, $export_data);
        $this->_render_template('settings/terms_conditions/index', $this->data);
    }
    //  For Editing Terms & Conditions
    public function editterms_condtn() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['termsconds'] = $this->crm_model->get_data_byId('termscond', 'id', $this->input->post('id'));
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->load->view('settings/terms_conditions/edit', $this->data);
    }
    // For Viewing Terms & Conditions
    public function termscond_view() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_view');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['termsconds'] = $this->crm_model->get_data_byId('termscond', 'id', $this->input->post('id'));
        $this->load->view('settings/terms_conditions/view', $this->data);
    }
    // For Saving Terms & Conditions
    public function saveterms_condtn() {
         // pre($_POST);die();
        if ($this->input->post()) {
            $required_fields = array('terms_tittle');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //  $data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $id = $data['id'];
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 95));
                if ($id && $id != '') {
                    $success = $this->crm_model->update_data('termscond', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Terms & Conditions updated successfully";
                        logActivity('Terms & Conditions updated', 'lead', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'CRM terms & conditions updated' , 'message' => 'CRM terms & conditions updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'terms & conditions updated', 'message' => 'terms & conditions updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'termscond_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*  pushNotification(array('subject'=> 'CRM terms & conditions updated' , 'message' => 'CRM terms & conditions updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'terms & conditions updated', 'message' => 'terms & conditions updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'termscond_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'Terms & Conditions updated successfully');
                    }
                } else {
                    $id = $this->crm_model->insert_tbl_data('termscond', $data);
                    if ($id) {
                        logActivity('New Terms & Conditions Created', 'Terms & Conditions', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*  pushNotification(array('subject'=> 'CRM terms & conditions created' , 'message' => 'CRM terms & conditions created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'terms & conditions created', 'message' => 'New terms & conditions created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'termscond_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*pushNotification(array('subject'=> 'CRM terms & conditions created' , 'message' => 'CRM terms & conditions created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'terms & conditions created', 'message' => 'New terms & conditions created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'termscond_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'New Terms & Conditions Created', 'Terms & Conditions');
                    }
                }
                redirect(base_url() . 'crm/crmterms_condtn', 'refresh');
            }
        }
    }
    // For Deleting Terms & Conditions
    public function deletetermscond($id = '') {
        if (!$id) {
            redirect('crm/deletetermscond', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->crm_model->delete_data('termscond', 'id', $id);
        if ($result) {
            logActivity('Terms & Conditions Deleted', 'leads', $id);
            $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 95));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        /*  pushNotification(array('subject'=> 'CRM terms & conditions deleted' , 'message' => 'CRM terms & conditions deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                        pushNotification(array('subject' => 'terms & conditions', 'message' => 'terms & conditions id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                /*pushNotification(array('subject'=> 'CRM terms & conditions deleted' , 'message' => 'CRM terms & conditions deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                pushNotification(array('subject' => 'terms & conditions', 'message' => 'terms & conditions id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
            }
            $this->session->set_flashdata('message', 'New Terms & Condition Deleted Successfully');
            $result = array('msg' => 'Terms & Conditions Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/crmterms_condtn');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    // For Leads to QUOT , PI , SO
    // For Editing Leads to Quot
    public function convertLeads_to_quot() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['leads'] = $this->crm_model->get_data_byId('leads', 'id', $this->input->post('id'));
        $this->data['materials'] = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'quotation');
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->load->view('quotation/leads_to_quot', $this->data);
    }
    // For Saving Leads to Quot
    public function saveLeads_to_quot() {
        if ($this->input->post()) {
            $required_fields = array('product');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $products = count($_POST['product']);
                if ($products > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product' => $_POST['product'][$i], 'description' => $_POST['description'][$i], 'quantity' => $_POST['qty'][$i], 'uom' => $_POST['uom'][$i], 'price' => $_POST['price'][$i], 'gst' => $_POST['gst'][$i], 'total' => $_POST['totals'][$i], 'TotalWithGst' => $_POST['TotalWithGsts'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //  $data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['product'] = $product_array;
                $leadid = $data['id'];
                $id = $data['id'];
                $converted_to_quotation = array('converted_to_quotation' => 1);
                $this->crm_model->update_after_save_saleorder('leads', $converted_to_quotation, 'id', $id);
                $id = $this->crm_model->insert_tbl_data('quotation', $data);
                if ($id) {
                    logActivity('New Quotation Created', 'Quotation', $id);
                    $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 5));
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                /*pushNotification(array('subject'=> 'Lead is converted into quotation' , 'message' => 'Lead is converted into quotation by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.' from lead id '.$data['id'], 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                pushNotification(array('subject' => 'Lead is converted into quotation', 'message' => 'ead is converted into quotation by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'quotation_view', 'icon' => 'fa fa-shekel'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        /*pushNotification(array('subject'=> 'Lead is converted into quotation' , 'message' => 'Lead is converted into quotation by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.' from lead id '.$data['id'], 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                        pushNotification(array('subject' => 'Lead is converted into quotation', 'message' => 'ead is converted into quotation by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'quotation_view', 'icon' => 'fa fa-shekel'));
                    }
                    $this->session->set_flashdata('message', 'Quotation inserted successfully');
                }
                redirect(base_url() . 'crm/quotation', 'refresh');
            }
        }
    }
    // For Adding Lead to PI
    public function lead_to_pi() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['piCreate'] = $this->crm_model->get_data_byId('leads', 'id', $this->input->post('id'));
        $this->data['materials'] = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'proforma_invoice');
        $this->load->view('proforma_invoices/lead_to_pi', $this->data);
    }
    // For Saving Lead to PI
    public function saveLead_to_pi() {
        if ($this->input->post()) {
            $required_fields = array('account_id', 'product');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $products = count($_POST['product']);
                if ($products > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product' => $_POST['product'][$i], 'description' => $_POST['description'][$i], 'quantity' => $_POST['qty'][$i], 'uom' => $_POST['uom'][$i], 'price' => $_POST['price'][$i], 'gst' => $_POST['gst'][$i], 'individualTotal' => $_POST['totals'][$i], 'individualTotalWithGst' => $_POST['TotalWithGsts'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['product'] = $product_array;
                $data['pi_code'] = $_POST['so_order'];
                #pre($data);
                $data['discount_offered'] = isset($data['discount_offered']) ? json_encode($data['discount_offered']) : '';
                $data['dispatch_documents'] = isset($data['dispatch_documents']) ? json_encode($data['dispatch_documents']) : '';
                #die;
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                $id = $data['id'];
                $converted_to_proinvc = array('converted_to_proinvc' => 1);
                $this->crm_model->update_after_save_saleorder('leads', $converted_to_proinvc, 'id', $id);
                $id = $this->crm_model->insert_tbl_data('proforma_invoice', $data);
                if ($id) {
                    logActivity('New Performa Invoice Created', 'Performa Invoice', $id);
                    $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 5));
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                /*pushNotification(array('subject'=> 'Lead is converted into proforma invoice' , 'message' => 'Lead is converted into proforma invoice by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.' from lead id '.$data['id'], 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                pushNotification(array('subject' => 'Lead is converted into proforma invoice', 'message' => 'Lead is converted into proforma invoice by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'proforma_invoice_view', 'icon' => 'fa fa-shekel'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        /*  pushNotification(array('subject'=> 'Lead is converted into proforma invoice' , 'message' => 'Lead is converted into proforma invoice by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.' from lead id '.$data['id'], 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                        pushNotification(array('subject' => 'Lead is converted into proforma invoice', 'message' => 'Lead is converted into proforma invoice by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'proforma_invoice_view', 'icon' => 'fa fa-shekel'));
                    }
                    $this->session->set_flashdata('message', 'Performa Invoice inserted successfully');
                }
                if ($id) {
                    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                        $attachment_array = array();
                        $certificateCount = count($_FILES['attachment']['name']);
                        for ($i = 0;$i < $certificateCount;$i++) {
                            $filename = $_FILES['attachment']['name'][$i];
                            $tmpname = $_FILES['attachment']['tmp_name'][$i];
                            $type = $_FILES['attachment']['type'][$i];
                            $error = $_FILES['attachment']['error'][$i];
                            $size = $_FILES['attachment']['size'][$i];
                            $exp = explode('.', $filename);
                            $ext = end($exp);
                            $newname = $exp[0] . '_' . time() . "." . $ext;
							$newname = str_replace(' ', '_', $newname);;
                            $config['upload_path'] = 'assets/modules/crm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $id;
                            $attachment_array[$i]['rel_type'] = 'proforma_invoice';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array, 'crm/editSaleOrder/' . $data['id']);
                        }
                    }
                }
                redirect(base_url() . 'crm/proforma_invoice', 'refresh');
            }
        }
    }
    // For Editing Lead to SO
    public function lead_to_so() {
        if ($this->input->post('id')) {
            permissions_redirect('is_view');
        }
        $this->data['id'] = $this->input->post('id');
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['sale_order'] = $this->crm_model->get_data_byId('leads', 'id', $this->input->post('id'));
        $this->data['sale_order_dispatch'] = $this->crm_model->get_dispatch_data('sale_order_dispatch', array('sale_order_id' => $this->input->post('id')));
        //$this->data['sale_order_dispatch'] = $this->crm_model->get_data('sale_order_dispatch',array('sale_order_id'=>  $this->input->post('id')));
        //$this->data['materials']  = $this->crm_model->get_data('material');
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'sale_order');
        $whereDispatchAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'sale_order_dispatch');
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->data['dispatch_attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereDispatchAttachment);
        $this->load->view('sale_orders/lead_to_so', $this->data);
    }
    // For Saving Lead to SO
    public function saveLead_to_so() {
        if ($this->input->post()) {
            $required_fields = array('product');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $products = count($_POST['product']);
                $sale_order_priority_array = array();
                if ($products > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product' => $_POST['product'][$i], 'description' => $_POST['description'][$i], 'quantity' => $_POST['qty'][$i], 'uom' => $_POST['uom'][$i], 'price' => $_POST['price'][$i], 'gst' => $_POST['gst'][$i], 'individualTotal' => $_POST['totals'][$i], 'individualTotalWithGst' => $_POST['TotalWithGsts'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $data['so_order'] = $_POST['so_order'];
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['product'] = $product_array;
                $data['discount_offered'] = isset($data['discount_offered']) ? json_encode($data['discount_offered']) : '';
                $data['dispatch_documents'] = isset($data['dispatch_documents']) ? json_encode($data['dispatch_documents']) : '';
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                //  $data['payment_terms'] = json_encode($data['payment_terms']);
                $id = $data['id'];
                #pre($data); die;
                $converted_to_so = array('converted_to_so' => 1);
                $this->crm_model->update_after_save_saleorder('leads', $converted_to_so, 'id', $id);
                $id = $this->crm_model->insert_tbl_data('sale_order', $data);
                if ($id) {
                    if (!empty($arr)) {
                        foreach ($arr as $res) {
                            //$this->crm_model->update_single_value_data('material',array('sales_price'=>$res['price']), array('id'=> $res['product'],'created_by_cid'=>$_SESSION['loggedInUser']->c_id));
                            $this->crm_model->update_single_value_data('material', array('sales_price' => $res['price']), array('id' => $res['product'], 'created_by_cid' => $this->companyGroupId));
                        }
                    }
                    logActivity('New Sale Order Created', 'Sale Order', $id);
                    $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 5));
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                /*pushNotification(array('subject'=> 'Lead is converted into sale order' , 'message' => 'Lead is converted into sale order by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.' from lead id '.$data['id'], 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                pushNotification(array('subject' => 'Lead is converted into Sale order', 'message' => 'Lead is converted into Sale order by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        /*pushNotification(array('subject'=> 'Lead is converted into sale order' , 'message' => 'Lead is converted into sale order by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.' from lead id '.$data['id'], 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));  */
                        pushNotification(array('subject' => 'Lead is converted into Sale order', 'message' => 'Lead is converted into Sale order by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                    }
                    $this->session->set_flashdata('message', 'Sale Order inserted successfully');
                    if ($id) {
                        if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                            $attachment_array = array();
                            $certificateCount = count($_FILES['attachment']['name']);
                            for ($i = 0;$i < $certificateCount;$i++) {
                                $filename = $_FILES['attachment']['name'][$i];
                                $tmpname = $_FILES['attachment']['tmp_name'][$i];
                                $type = $_FILES['attachment']['type'][$i];
                                $error = $_FILES['attachment']['error'][$i];
                                $size = $_FILES['attachment']['size'][$i];
                                $exp = explode('.', $filename);
                                $ext = end($exp);
                                $newname = $exp[0] . '_' . time() . "." . $ext;
								$newname = str_replace(' ', '_', $newname);;
                                $config['upload_path'] = 'assets/modules/crm/uploads/';
                                $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                                $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                                $config['max_size'] = '2000000';
                                $config['file_name'] = $newname;
                                $this->load->library('upload', $config);
                                move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                                $attachment_array[$i]['rel_id'] = $id;
                                $attachment_array[$i]['rel_type'] = 'sale_order';
                                $attachment_array[$i]['file_name'] = $newname;
                                $attachment_array[$i]['file_type'] = $type;
                            }
                            if (!empty($attachment_array)) {
                                /* Insert file information into the database */
                                $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array, 'crm/editSaleOrder/' . $data['id']);
                            }
                        }
                        if ($data['id'] && $data['id'] != '') {
                            $result = $this->crm_model->delete_data('sale_order_priority', 'sale_order_id', $data['id']);
                        }
                        /* insert sale order priority */
                        $sale_order_priority_array = array();
                        $maxPriority = getMaxSaleOrderPriority();
                        $maxPriority = $maxPriority ? ($maxPriority + 1) : 1;
                        $j = 0;
                        while ($j < $products) {
                            $sale_order_priority_array[$j]['sale_order_id'] = $id;
                            $sale_order_priority_array[$j]['product_id'] = $_POST['product'][$j];
                            $sale_order_priority_array[$j]['quantity'] = $_POST['qty'][$j];
                            $sale_order_priority_array[$j]['uom'] = $_POST['uom'][$j];
                            $sale_order_priority_array[$j]['price'] = $_POST['price'][$j];
                            $sale_order_priority_array[$j]['individualTotal'] = $_POST['totals'][$j];
                            $sale_order_priority_array[$j]['individualTotalWithGst'] = $_POST['TotalWithGsts'][$j];
                            $sale_order_priority_array[$j]['priority'] = $maxPriority;
                            //$sale_order_priority_array[$j]['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                            $sale_order_priority_array[$j]['created_by_cid'] = $this->companyGroupId;
                            $j++;
                            $maxPriority++;
                        }
                        if (!empty($sale_order_priority_array)) {
                            $attachmentId = $this->crm_model->insertPriorityData('sale_order_priority', $sale_order_priority_array);
                        }
                        /* insert sale order priority */
                    }
                    redirect(base_url() . 'crm/sale_orders', 'refresh');
                }
            }
        }
    }
    // For QUOT to  PI , SO
    // For Editing Quot to PI
    public function convert_to_pi() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['piCreate'] = $this->crm_model->get_data_byId('quotation', 'id', $this->input->post('id'));
        $this->data['materials'] = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'proforma_invoice');
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->load->view('proforma_invoices/convert_to_pi', $this->data);
    }
    // For Saving Quot to PI
    public function savequot_to_pi() {
        if ($this->input->post()) {
            $required_fields = array('account_id', 'product');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $products = count($_POST['product']);
                $comp_id = $_POST['account_id'];
                if ($products > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product' => $_POST['product'][$i], 'description' => $_POST['description'][$i], 'quantity' => $_POST['qty'][$i], 'uom' => $_POST['uom'][$i], 'price' => $_POST['price'][$i], 'gst' => $_POST['gst'][$i], 'individualTotal' => $_POST['totals'][$i], 'individualTotalWithGst' => $_POST['TotalWithGsts'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['pi_code'] = $_POST['so_order'];
                $data['product'] = $product_array;
                $data['convrtd_frm_quot_to_pi'] = 1;
                #pre($data);
                $data['discount_offered'] = isset($data['discount_offered']) ? json_encode($data['discount_offered']) : '';
                $data['dispatch_documents'] = isset($data['dispatch_documents']) ? json_encode($data['dispatch_documents']) : '';
                #die;
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                $id = $data['id'];
                $converted_to_proinvc = array('converted_to_proinvc' => 1);
                $this->crm_model->update_after_save_saleorder('quotation', $converted_to_proinvc, 'id', $id);
                $id = $this->crm_model->insert_tbl_data('proforma_invoice', $data);
                if ($id) {
                    ComplogActivity($comp_id, 'Quotation Converted to Proforma Invoice', 'Proforma Invoice', $id);
                    $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 94));
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                /*  pushNotification(array('subject'=> 'Quotation is converted into Proforma invoice' , 'message' => 'Quotation is converted into Proforma invoice by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.' from lead id '.$data['id'], 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                pushNotification(array('subject' => 'Quotation is converted into Proforma invoice', 'message' => 'Quotation is converted into Proforma invoice by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'proforma_invoice_view', 'icon' => 'fa fa-shekel'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        /*pushNotification(array('subject'=> 'Quotation is converted into Proforma invoice' , 'message' => 'Quotation is converted into Proforma invoice by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.' from lead id '.$data['id'], 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                        pushNotification(array('subject' => 'Quotation is converted into Proforma invoice', 'message' => 'Quotation is converted into Proforma invoice by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'proforma_invoice_view', 'icon' => 'fa fa-shekel'));
                    }
                    logActivity('New Performa Invoice Created', 'Proforma Invoice', $id);
                    $this->session->set_flashdata('message', 'Proforma Invoice inserted successfully');
                }
                if ($id) {
                    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                        $attachment_array = array();
                        $certificateCount = count($_FILES['attachment']['name']);
                        for ($i = 0;$i < $certificateCount;$i++) {
                            $filename = $_FILES['attachment']['name'][$i];
                            $tmpname = $_FILES['attachment']['tmp_name'][$i];
                            $type = $_FILES['attachment']['type'][$i];
                            $error = $_FILES['attachment']['error'][$i];
                            $size = $_FILES['attachment']['size'][$i];
                            $exp = explode('.', $filename);
                            $ext = end($exp);
                            $newname = $exp[0] . '_' . time() . "." . $ext;
							$newname = str_replace(' ', '_', $newname);;
                            $config['upload_path'] = 'assets/modules/crm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $id;
                            $attachment_array[$i]['rel_type'] = 'proforma_invoice';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array, 'crm/editSaleOrder/' . $data['id']);
                        }
                    }
                }
                redirect(base_url() . 'crm/proforma_invoice', 'refresh');
            }
        }
    }
    // Adding Quot to SO
    public function convert_to_so() {
        if ($this->input->post('id')) {
            permissions_redirect('is_view');
        }
        $this->data['id'] = $this->input->post('id');
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['sale_order'] = $this->crm_model->get_data_byId('quotation', 'id', $this->input->post('id'));
        $this->data['sale_order_dispatch'] = $this->crm_model->get_dispatch_data('sale_order_dispatch', array('sale_order_id' => $this->input->post('id')));
        //$this->data['sale_order_dispatch'] = $this->crm_model->get_data('sale_order_dispatch',array('sale_order_id'=>  $this->input->post('id')));
        //$this->data['materials']  = $this->crm_model->get_data('material');
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'sale_order');
        $whereDispatchAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'sale_order_dispatch');
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->data['dispatch_attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereDispatchAttachment);
        $this->load->view('sale_orders/convert_to_so', $this->data);
    }
    // Saving Quot to SO
    public function savequot_to_so() {
        if ($this->input->post()) {
            $required_fields = array('product');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $products = count($_POST['product']);
                $comp_id = $_POST['account_id'];
                $sale_order_priority_array = array();
                if ($products > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product' => $_POST['product'][$i], 'description' => $_POST['description'][$i], 'quantity' => $_POST['qty'][$i], 'uom' => $_POST['uom'][$i], 'price' => $_POST['price'][$i], 'gst' => $_POST['gst'][$i], 'individualTotal' => $_POST['totals'][$i], 'individualTotalWithGst' => $_POST['TotalWithGsts'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //  $data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['product'] = $product_array;
                $data['discount_offered'] = isset($data['discount_offered']) ? json_encode($data['discount_offered']) : '';
                $data['dispatch_documents'] = isset($data['dispatch_documents']) ? json_encode($data['dispatch_documents']) : '';
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                $id = $data['id'];
                #pre($data); die;
                $data['pi_code'] = $_POST['so_order'];
                $converted_to_proinvc = array('converted_to_proinvc' => 1);
                $sale_ordr_converted = array('sale_ordr_converted' => 1);
                $this->crm_model->update_after_save_saleorder('quotation', $converted_to_proinvc, 'id', $id);
                $this->crm_model->update_after_save_saleorder('quotation', $sale_ordr_converted, 'id', $id);
                $id = $this->crm_model->insert_tbl_data('sale_order', $data);
                if ($id) {
                    if (!empty($arr)) {
                        foreach ($arr as $res) {
                            //$this->crm_model->update_single_value_data('material',array('sales_price'=>$res['price']), array('id'=> $res['product'],'created_by_cid'=>$_SESSION['loggedInUser']->c_id));
                            $this->crm_model->update_single_value_data('material', array('sales_price' => $res['price']), array('id' => $res['product'], 'created_by_cid' => $this->companyGroupId));
                        }
                    }
                    logActivity('New Sale Order Created', 'Sale Order', $id);
                    $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 94));
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                /*pushNotification(array('subject'=> 'Quotation is converted into Sale order' , 'message' => 'Quotation is converted into Sale order by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.' from lead id '.$data['id'], 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                pushNotification(array('subject' => 'Quotation is converted into Sale order', 'message' => 'Quotation is converted into Sale order' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        /*pushNotification(array('subject'=> 'Quotation is converted into Sale order' , 'message' => 'Quotation is converted into Sale order by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.' from lead id '.$data['id'], 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                        pushNotification(array('subject' => 'Quotation converted into Sale Order', 'message' => 'Quotation converted into Sale Order created by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                    }
                    ComplogActivity($comp_id, 'Quotation Converted to Sale Order', 'Sale Order', $id);
                    $this->session->set_flashdata('message', 'Sale Order inserted successfully');
                    if ($id) {
                        if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                            $attachment_array = array();
                            $certificateCount = count($_FILES['attachment']['name']);
                            for ($i = 0;$i < $certificateCount;$i++) {
                                $filename = $_FILES['attachment']['name'][$i];
                                $tmpname = $_FILES['attachment']['tmp_name'][$i];
                                $type = $_FILES['attachment']['type'][$i];
                                $error = $_FILES['attachment']['error'][$i];
                                $size = $_FILES['attachment']['size'][$i];
                                $exp = explode('.', $filename);
                                $ext = end($exp);
                                $newname = $exp[0] . '_' . time() . "." . $ext;
								$newname = str_replace(' ', '_', $newname);;
                                $config['upload_path'] = 'assets/modules/crm/uploads/';
                                $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                                $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                                $config['max_size'] = '2000000';
                                $config['file_name'] = $newname;
                                $this->load->library('upload', $config);
                                move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                                $attachment_array[$i]['rel_id'] = $id;
                                $attachment_array[$i]['rel_type'] = 'sale_order';
                                $attachment_array[$i]['file_name'] = $newname;
                                $attachment_array[$i]['file_type'] = $type;
                            }
                            if (!empty($attachment_array)) {
                                /* Insert file information into the database */
                                $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array, 'crm/editSaleOrder/' . $data['id']);
                            }
                        }
                        if ($data['id'] && $data['id'] != '') {
                            $result = $this->crm_model->delete_data('sale_order_priority', 'sale_order_id', $data['id']);
                        }
                        /* insert sale order priority */
                        $sale_order_priority_array = array();
                        $maxPriority = getMaxSaleOrderPriority();
                        $maxPriority = $maxPriority ? ($maxPriority + 1) : 1;
                        $j = 0;
                        while ($j < $products) {
                            $sale_order_priority_array[$j]['sale_order_id'] = $id;
                            $sale_order_priority_array[$j]['product_id'] = $_POST['product'][$j];
                            $sale_order_priority_array[$j]['quantity'] = $_POST['qty'][$j];
                            $sale_order_priority_array[$j]['uom'] = $_POST['uom'][$j];
                            $sale_order_priority_array[$j]['price'] = $_POST['price'][$j];
                            $sale_order_priority_array[$j]['individualTotal'] = $_POST['totals'][$j];
                            $sale_order_priority_array[$j]['individualTotalWithGst'] = $_POST['TotalWithGsts'][$j];
                            $sale_order_priority_array[$j]['priority'] = $maxPriority;
                            //$sale_order_priority_array[$j]['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                            $sale_order_priority_array[$j]['created_by_cid'] = $this->companyGroupId;
                            $j++;
                            $maxPriority++;
                        }
                        if (!empty($sale_order_priority_array)) {
                            $attachmentId = $this->crm_model->insertPriorityData('sale_order_priority', $sale_order_priority_array);
                        }
                        /* insert sale order priority */
                    }
                    redirect(base_url() . 'crm/sale_orders', 'refresh');
                }
            }
        }
    }
    // For Adding Similar Quot
    public function AddSimilarQuotedit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['quot'] = $this->crm_model->get_data_byId('quotation', 'id', $this->input->post('id'));
        $this->data['materials'] = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'quotation');
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->load->view('quotation/AddSimilarQuotedit', $this->data);
    }
    //For Saving Similar Quot
    public function savesimilarQuot() {
        if ($this->input->post()) {
            $required_fields = array('product', 'phone_no');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $products = count($_POST['product']);
                $comp_id = $_POST['account_id'];
                if ($products > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product' => $_POST['product'][$i], 'description' => $_POST['description'][$i], 'quantity' => $_POST['qty'][$i], 'uom' => $_POST['uom'][$i], 'price' => $_POST['price'][$i], 'gst' => $_POST['gst'][$i], 'total' => $_POST['totals'][$i], 'TotalWithGst' => $_POST['TotalWithGsts'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['product'] = $product_array;
                #pre($data);
                #die;
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                $id = $data['id'];
                $id = $this->crm_model->insert_tbl_data('quotation', $data);
                if ($id) {
                    ComplogActivity($comp_id, 'Similar Quotation Created', 'Quotation', $id);
                    logActivity('Similar Quotation Created', 'Quotation', $id);
                    $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 94));
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                /*pushNotification(array('subject'=> 'New quotation created' , 'message' => 'New quotation created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                pushNotification(array('subject' => 'New quotation created', 'message' => 'New Quotation created by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'quotation_view', 'icon' => 'fa fa-shekel'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        /*pushNotification(array('subject'=> 'New quotation created' , 'message' => 'New quotation created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                        pushNotification(array('subject' => 'New quotation created', 'message' => 'New Quotation created by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'quotation_view', 'icon' => 'fa fa-shekel'));
                    }
                    $this->session->set_flashdata('message', 'Quotation inserted successfully');
                }
                if ($id) {
                    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                        $attachment_array = array();
                        $certificateCount = count($_FILES['attachment']['name']);
                        for ($i = 0;$i < $certificateCount;$i++) {
                            $filename = $_FILES['attachment']['name'][$i];
                            $tmpname = $_FILES['attachment']['tmp_name'][$i];
                            $type = $_FILES['attachment']['type'][$i];
                            $error = $_FILES['attachment']['error'][$i];
                            $size = $_FILES['attachment']['size'][$i];
                            $exp = explode('.', $filename);
                            $ext = end($exp);
                            $newname = $exp[0] . '_' . time() . "." . $ext;
							$newname = str_replace(' ', '_', $newname);;
                            $config['upload_path'] = 'assets/modules/crm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $id;
                            $attachment_array[$i]['rel_type'] = 'proforma_invoice';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array, 'crm/editSaleOrder/' . $data['id']);
                        }
                    }
                }
                redirect(base_url() . 'crm/quotation', 'refresh');
            }
        }
    }
    // For Adding Similar PI
    public function AddSimilarPIedit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['pi'] = $this->crm_model->get_data_byId('proforma_invoice', 'id', $this->input->post('id'));
        $this->data['materials'] = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'proforma_invoice');
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->load->view('proforma_invoices/AddSimilarPIedit', $this->data);
    }
    // For Saving Similar PI
    public function saveSimilarPI() {
        if ($this->input->post()) {
            $required_fields = array('account_id', 'product', 'qty', 'uom', 'price', 'order_date', 'dispatch_date');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $products = count($_POST['product']);
                $comp_id = $_POST['account_id'];
                if ($products > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product' => $_POST['product'][$i], 'description' => $_POST['description'][$i], 'quantity' => $_POST['qty'][$i], 'uom' => $_POST['uom'][$i], 'price' => $_POST['price'][$i], 'gst' => $_POST['gst'][$i], 'individualTotal' => $_POST['totals'][$i], 'individualTotalWithGst' => $_POST['TotalWithGsts'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['product'] = $product_array;
                #pre($data);
                $data['pi_code'] = $_POST['piCode'];
                $data['discount_offered'] = isset($data['discount_offered']) ? json_encode($data['discount_offered']) : '';
                $data['dispatch_documents'] = isset($data['dispatch_documents']) ? json_encode($data['dispatch_documents']) : '';
                #die;
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                $id = $data['id'];
                $id = $this->crm_model->insert_tbl_data('proforma_invoice', $data);
                if ($id) {
                    ComplogActivity($comp_id, 'Similar Proforma Invoice Created', 'Proforma Invoice', $id);
                    logActivity('New Proforma Invoice Created', 'Proforma Invoice', $id);
                    $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 12));
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                /*pushNotification(array('subject'=> 'New proforma invoice created' , 'message' => 'New proforma invoice created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                //$userViewPermission['user_id']
                                pushNotification(array('subject' => 'Proforma Invoice created', 'message' => 'New Proforma Invoice created by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'proforma_invoice_view', 'icon' => 'fa fa-shekel'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        /*pushNotification(array('subject'=> 'Proforma Invoice created' , 'message' => 'New Proforma Invoice created by'.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id ,'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id,'class'=>'add_crm_tabs','icon'=>'fa fa-shekel'));*/
                        pushNotification(array('subject' => 'Proforma Invoice created', 'message' => 'New Proforma Invoice created by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'proforma_invoice_view', 'icon' => 'fa fa-shekel'));
                    }
                    $this->session->set_flashdata('message', 'Proforma Invoice inserted successfully');
                }
            }
            if ($id) {
                if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                    $attachment_array = array();
                    $certificateCount = count($_FILES['attachment']['name']);
                    for ($i = 0;$i < $certificateCount;$i++) {
                        $filename = $_FILES['attachment']['name'][$i];
                        $tmpname = $_FILES['attachment']['tmp_name'][$i];
                        $type = $_FILES['attachment']['type'][$i];
                        $error = $_FILES['attachment']['error'][$i];
                        $size = $_FILES['attachment']['size'][$i];
                        $exp = explode('.', $filename);
                        $ext = end($exp);
                        $newname = $exp[0] . '_' . time() . "." . $ext;
						$newname = str_replace(' ', '_', $newname);;
                        $config['upload_path'] = 'assets/modules/crm/uploads/';
                        $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                        $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                        $config['max_size'] = '2000000';
                        $config['file_name'] = $newname;
                        $this->load->library('upload', $config);
                        move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                        $attachment_array[$i]['rel_id'] = $id;
                        $attachment_array[$i]['rel_type'] = 'proforma_invoice';
                        $attachment_array[$i]['file_name'] = $newname;
                        $attachment_array[$i]['file_type'] = $type;
                    }
                    if (!empty($attachment_array)) {
                        /* Insert file information into the database */
                        $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array, 'crm/editSaleOrder/' . $data['id']);
                    }
                }
            }
            redirect(base_url() . 'crm/proforma_invoice', 'refresh');
        }
    }
    // For Adding Similar SO
    public function AddSimilarSOedit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['sale_order'] = $this->crm_model->get_data_byId('sale_order', 'id', $this->input->post('id'));
        //$this->data['materials']  = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'sale_order');
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->load->view('sale_orders/AddSimilarSOedit', $this->data);
    }
    // For Saving Similar SO
    public function saveSimilarSO() {
        if ($this->input->post()) {
            $required_fields = array('account_id', 'product', 'qty', 'uom', 'price', 'order_date');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $products = count($_POST['product']);
                $sale_order_priority_array = array();
                if ($products > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product' => $_POST['product'][$i], 'description' => $_POST['description'][$i], 'quantity' => $_POST['qty'][$i], 'uom' => $_POST['uom'][$i], 'price' => $_POST['price'][$i], 'gst' => $_POST['gst'][$i], 'individualTotal' => $_POST['totals'][$i], 'individualTotalWithGst' => $_POST['TotalWithGsts'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $comp_id = $_POST['account_id'];
                $data['so_order'] = $_POST['soCode'];
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['product'] = $product_array;
                $data['discount_offered'] = isset($data['discount_offered']) ? json_encode($data['discount_offered']) : '';
                $data['dispatch_documents'] = isset($data['dispatch_documents']) ? json_encode($data['dispatch_documents']) : '';
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                //  $data['payment_terms'] = json_encode($data['payment_terms']);
                $id = $data['id'];
                #pre($data); die;
                $id = $this->crm_model->insert_tbl_data('sale_order', $data);
                if ($id) {
                    if (!empty($arr)) {
                        foreach ($arr as $res) {
                            //$this->crm_model->update_single_value_data('material',array('sales_price'=>$res['price']), array('id'=> $res['product'],'created_by_cid'=>$_SESSION['loggedInUser']->c_id));
                            $this->crm_model->update_single_value_data('material', array('sales_price' => $res['price']), array('id' => $res['product'], 'created_by_cid' => $this->companyGroupId));
                        }
                    }
                    ComplogActivity($comp_id, 'Similar Sale Order Created', 'Sale Order', $id);
                    logActivity('New Sale Order Created', 'Sale Order', $id);
                    $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 9));
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                pushNotification(array('subject' => 'Sale order created', 'message' => 'New Sale order created by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        /*pushNotification(array('subject'=> 'New sale order created' , 'message' => 'New sale order created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                        pushNotification(array('subject' => 'Sale order created', 'message' => 'New Sale order created by' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                    }
                    $this->session->set_flashdata('message', 'Sale Order inserted successfully');
                }
                if ($id) {
                    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                        $attachment_array = array();
                        $certificateCount = count($_FILES['attachment']['name']);
                        for ($i = 0;$i < $certificateCount;$i++) {
                            $filename = $_FILES['attachment']['name'][$i];
                            $tmpname = $_FILES['attachment']['tmp_name'][$i];
                            $type = $_FILES['attachment']['type'][$i];
                            $error = $_FILES['attachment']['error'][$i];
                            $size = $_FILES['attachment']['size'][$i];
                            $exp = explode('.', $filename);
                            $ext = end($exp);
                            $newname = $exp[0] . '_' . time() . "." . $ext;
							$newname = str_replace(' ', '_', $newname);;
                            $config['upload_path'] = 'assets/modules/crm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $id;
                            $attachment_array[$i]['rel_type'] = 'sale_order';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->crm_model->insert_attachment_data('attachments', $attachment_array, 'crm/editSaleOrder/' . $data['id']);
                        }
                    }
                    if ($data['id'] && $data['id'] != '') {
                        $result = $this->crm_model->delete_data('sale_order_priority', 'sale_order_id', $data['id']);
                    }
                    /* insert sale order priority */
                    $sale_order_priority_array = array();
                    $maxPriority = getMaxSaleOrderPriority();
                    $maxPriority = $maxPriority ? ($maxPriority + 1) : 1;
                    $j = 0;
                    while ($j < $products) {
                        $sale_order_priority_array[$j]['sale_order_id'] = $id;
                        $sale_order_priority_array[$j]['product_id'] = $_POST['product'][$j];
                        $sale_order_priority_array[$j]['quantity'] = $_POST['qty'][$j];
                        $sale_order_priority_array[$j]['uom'] = $_POST['uom'][$j];
                        $sale_order_priority_array[$j]['price'] = $_POST['price'][$j];
                        $sale_order_priority_array[$j]['individualTotal'] = $_POST['totals'][$j];
                        $sale_order_priority_array[$j]['individualTotalWithGst'] = $_POST['TotalWithGsts'][$j];
                        $sale_order_priority_array[$j]['priority'] = $maxPriority;
                        //$sale_order_priority_array[$j]['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                        $sale_order_priority_array[$j]['created_by_cid'] = $this->companyGroupId;
                        $j++;
                        $maxPriority++;
                    }
                    if (!empty($sale_order_priority_array)) {
                        $attachmentId = $this->crm_model->insertPriorityData('sale_order_priority', $sale_order_priority_array);
                    }
                    /* insert sale order priority */
                }
                redirect(base_url() . 'crm/sale_orders', 'refresh');
            }
        }
    }
    // For Importing Contacts
    public function importContacts() {
        error_reporting(0);
        if (!empty($_FILES['uploadFile']['name']) != '') {
            $path = 'assets/modules/crm/excel_for_contacts/';
            require_once APPPATH . "/third_party/PHPExcel.php";
            $config['upload_path'] = $path;
            $config['allowed_types'] = "csv|xls|xlsx";
            $config['remove_spaces'] = true;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if (empty($error)) {
                if (!empty($data['upload_data']['file_name'])) {
                    $import_xls_file = $data['upload_data']['file_name'];
                } else {
                    $import_xls_file = 0;
                }
                $inputFileName = $path . $import_xls_file;
                //$tt = 'assets/modules/crm/excel_for_contacts/'.$data['uploadFile']['name'];
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    //echo count($allDataInSheet);die();
                    $flag = true;
                    $i = 0;
                    //pre($allDataInSheet);
                    foreach ($allDataInSheet as $value) {
                        if ($flag) {
                            $flag = false;
                            continue;
                        }
                        $insertdata[$i]['contact_owner'] = $this->companyGroupId;
                        $insertdata[$i]['first_name'] = !empty($value['B']) ? $value['B'] : '';
                        $insertdata[$i]['last_name'] = !empty($value['C']) ? $value['C'] : '';
                        $insertdata[$i]['phone'] = !empty($value['D']) ? $value['D'] : 0;
                        $insertdata[$i]['mobile'] = !empty($value['E']) ? $value['E'] : 0;
                        $insertdata[$i]['email'] = !empty($value['F']) ? $value['F'] : '';
                        $insertdata[$i]['account_id'] = !empty($value['G']) ? $value['G'] : 0;
                        $insertdata[$i]['title'] = !empty($value['H']) ? $value['H'] : '';
                        $insertdata[$i]['mailing_street'] = !empty($value['I']) ? $value['I'] : 0;
                        $insertdata[$i]['mailing_city'] = !empty($value['J']) ? $value['J'] : 0;
                        $insertdata[$i]['mailing_zipcode'] = !empty($value['K']) ? $value['K'] : 0;
                        $insertdata[$i]['mailing_state'] = !empty($value['L']) ? $value['L'] : 0;
                        $insertdata[$i]['mailing_country'] = !empty($value['M']) ? $value['M'] : 0;
                        $insertdata[$i]['other_street'] = !empty($value['N']) ? $value['N'] : 0;
                        $insertdata[$i]['other_city'] = !empty($value['O']) ? $value['O'] : 0;
                        $insertdata[$i]['other_zipcode'] = !empty($value['P']) ? $value['P'] : 0;
                        $insertdata[$i]['other_state'] = !empty($value['Q']) ? $value['Q'] : 0;
                        $insertdata[$i]['other_country'] = !empty($value['R']) ? $value['R'] : 0;
                        $insertdata[$i]['fax'] = !empty($value['S']) ? $value['S'] : 0;
                        $insertdata[$i]['home_phone'] = !empty($value['T']) ? $value['T'] : '';
                        $insertdata[$i]['other_phone'] = !empty($value['U']) ? $value['U'] : 0;
                        $insertdata[$i]['asst_phone'] = !empty($value['V']) ? $value['V'] : '';
                        $insertdata[$i]['assistant'] = !empty($value['W']) ? $value['W'] : '';
                        $insertdata[$i]['department'] = !empty($value['X']) ? $value['X'] : '';
                        $insertdata[$i]['lead_source'] = !empty($value['Y']) ? $value['Y'] : 0;
                        $insertdata[$i]['dob'] = !empty($value['Z']) ? $value['Z'] : '';
                        $insertdata[$i]['description'] = !empty($value['AA']) ? $value['AA'] : '';
                        $insertdata[$i]['company'] = !empty($value['AB']) ? $value['AB'] : '';
                        $insertdata[$i]['created_by'] = !empty($value['AC']) ? $value['AC'] : $_SESSION['loggedInUser']->u_id;
                        $insertdata[$i]['edited_by'] = !empty($value['AD']) ? $value['AD'] : 0;
                        $i++;
                    }
                    //die();
                    $result = $this->crm_model->importContacts($insertdata); //die();
                    if ($result) {
                        //echo "Imported successfully";
                        // die();

                    } else {
                        echo "ERROR !";
                    }
                }
                catch(Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                }
            } else {
                echo $error['error'];
            }
            $this->session->set_flashdata('message', 'Contacts Imported Successfully');
            redirect(base_url() . 'crm/contacts', 'refresh');
        }
        echo "<script>alert('Please Select the File to Upload')</script>";
        redirect(base_url() . 'crm/contacts', 'refresh');
    }
    // For Exporting Contacts
    public function exportContacts() {
        // create file name
        $fileName = 'data-' . time() . '.xlsx';
        // load excel library
        $this->load->library('excel');
        $empInfo = $this->crm_model->exportcontacts();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Contact Owner');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'First Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Last Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Phone No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Mobile');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Email ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Account ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Title');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Mailing Street');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Mailing City');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Mailing Zipcode');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Mailing State');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Mailing Country');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Other Street');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Other City');
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Other Zipcode');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Other State');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Other Country');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Fax');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Home Phone No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Other Phone No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Assit Phone No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Assistant');
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Department');
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Lead Source');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'DOB');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Descripitions');
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Company');
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Created By');
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Edited By');
        // set Row
        $rowCount = 2;
        foreach ($empInfo as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['contact_owner']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['first_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['last_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['mobile']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['account_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['title']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['mailing_street']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['mailing_city']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['mailing_zipcode']);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['mailing_state']);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['mailing_country']);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['other_street']);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $element['other_city']);
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $element['other_zipcode']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $element['other_state']);
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $element['other_country']);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $element['fax']);
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $element['home_phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $element['other_phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $element['asst_phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $element['assistant']);
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $element['department']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $element['lead_source']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $element['dob']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $element['description']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $element['company']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $element['created_by']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $element['edited_by']);
            $rowCount++;
        }
        // $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $object_writer = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=Exportcontacts.xlsx");
        ob_end_clean();
        $object_writer->save('php://output');
    }
    // For Importing Leads
     public function importLeads() {
        if (!empty($_FILES['uploadFile']['name']) != '') {
            $path = 'assets/modules/crm/uploads/';
            require_once APPPATH . "/third_party/PHPExcel.php";
            $config['upload_path'] = $path;
            $config['allowed_types'] = "csv|xls|xlsx";
            $config['remove_spaces'] = true;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if (empty($error)) {
                if (!empty($data['upload_data']['file_name'])) {
                    $import_xls_file = $data['upload_data']['file_name'];
                } else {
                    $import_xls_file = 0;
                }
                $inputFileName = $path . $import_xls_file;
                try {

                    $inputfiletype = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputfiletype);
                    $objReader->setReadDataOnly(true);//Get the area of data inserted
                    @$objPHPExcel = $objReader->load($inputFileName);
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestDataRow();
                    $highestColumn = $sheet->getHighestColumn();
                    // $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    // $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    // $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true, true);
                    $flag = true;
                    $i1 = 0;
                    $r = 0;
                    #pre($allDataInSheet);
                    #die;
                    foreach ($allDataInSheet as $value) {
                       # pre($value);
                        if ($flag) {
                             $flag = false;
                            continue;
                        }

                        if(!empty($value['B']) || !empty($value['C']) || !empty($value['D']) || !empty($value['E'])){
                            $insertdata[$i1]['contacts'] = '[{"first_name":"'.$value['B']. '","last_name":"' . $value['C']. '","email":"' . $value['D']. '","phone_no":"' .$value['E'].'"}]';
                            $insertdata[$i1]['company'] = !empty($value['A']) ? $value['A'] : '';
                            $tyu = getNameById('user_detail', !empty($value['F']) ? $value['F'] : '', 'name');
                            $insertdata[$i1]['lead_owner'] = !empty($tyu) ? $tyu->u_id : '';
                            $status = getNameById('lead_status', !empty($value['G']) ? $value['G'] : '', 'name');
                            $insertdata[$i1]['lead_status'] = !empty($status) ? $status->id : '';
                            $insertdata[$i1]['status_comment'] = !empty($value['H']) ? $value['H'] : '';
                            $insertdata[$i1]['lead_source'] = !empty($value['J']) ? $value['J'] : '';
                            $insertdata[$i1]['created_by'] = $_SESSION['loggedInUser']->u_id;
                            $insertdata[$i1]['created_by_cid'] = $this->companyGroupId;
                            $dty = [];
                                if(isset($value['I'])){
                                    $indstrydtl  = getNameById('add_industry', !empty($value['I']) ? $value['I'] : '', 'industry_detl');
                                    #pre($value);
                                   if(empty($indstrydtl)){
                                       $dty['industry_detl'] =  $value['I'];
                                       $dty['created_by']  = $_SESSION['loggedInUser']->u_id;
                                       $dty['active_inactive'] = '1';
                                       $dty['created_by_cid'] = $this->companyGroupId;
                                       $indstryid = $this->crm_model->insert_tbl_data('add_industry', $dty);
                                       $insertdata[$i1]['lead_industry'] = $indstryid;
                                   }
                                   else{
                                    $insertdata[$i1]['lead_industry'] = !empty($indstrydtl) ? $indstrydtl->id : '';
                                   }
                                }
                            #pre($insertdata[$i]['contacts'])    ;
                            $i1++;
                        }
                    }
                    // pre($insertdata);
                    // die;
                    $result = $this->crm_model->importlead($insertdata);
                    if ($result) {
                        //echo "Imported successfully";
                        // die();

                    } else {
                        echo "ERROR !";
                    }
                }
                catch(Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                }
            } else {
                echo $error['error'];
            }
           # die;
            $this->session->set_flashdata('message', 'Leads Imported Successfully');
            redirect(base_url() . 'crm/leads', 'refresh');
        }
        echo "<script>alert('Please Select the File to Upload')</script>";
        redirect(base_url() . 'crm/leads', 'refresh');
    }
    // for select all delete
    public function deleteall() {
        $tablename = $this->input->get_post('tablename');
        $checkValues = $this->input->get_post('checkValues');
        $datamsg = $this->input->get_post('datamsg');
        $ai = $this->input->get_post('ai');
        $str = implode(',', $ai);
        foreach ($checkValues as $key) {
            $this->crm_model->delete_data($tablename, 'id', $key);
            logActivity($datamsg . ' Deleted', $tablename, $key);
            echo $str;
            ComplogActivity($str, $datamsg . ' Deleted', $datamsg, $key);
        }
        $this->session->set_flashdata('message', $datamsg . ' Deleted Successfully');
        // redirect(base_url().'crm/leads', 'refresh');

    }
    public function markfavourite() {
        $id = $this->input->get_post('checkValues');
        $tablename = $this->input->get_post('tablename');
        $favourite = $this->input->get_post('favourite');
        $datamsg = $this->input->get_post('datamsg');
        $data = $favourite;
        $result = $this->crm_model->markfavour($tablename, $data, $id);
        if ($result == true) {
            foreach ($id as $ky) {
                logActivity($datamsg . ' Records marked favourite', $tablename, $ky);
            }
            $this->session->set_flashdata('message', $datamsg . ' Favourites');
            $result = array('msg' => 'Sale order approved', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/sale_orders');
            echo json_encode($result);
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    // For PipeLine Module Start//
    public function changeProcessType() {
        $data = $this->input->post();
        # pre($data);die;
        $data['lead_id'] = $data['processId'];
        $data['status'] = $data['processTypeId'];
        $data['start_date'] = date('Y-m-d');
        $data['created_by_cid'] = $this->companyGroupId;
        if ($data['processTypeId'] == 5) {
            $data['end_date'] = date('Y-m-d');
        } else {
            $data['end_date'] = "0000-00-00";
        }
        $this->crm_model->insert_tbl_data('leads_status_history', $data);
        $getdata = getNameById_leads('leads_status_history', $data['processId'], 'lead_id', $data['sourceId']);
        $this->crm_model->update_leads_history_enddates($getdata->maxid, date('Y-m-d'));
        $id = $data['processId'];
        $process_status = $this->crm_model->change_process_status($data, $id);
        $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 5));
        if (!empty($usersWithViewPermissions)) {
            foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                    pushNotification(array('subject' => 'Lead status updated', 'message' => 'Lead status updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'to status' => $data['processTypeId'], 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id));
                }
            }
        }
        if ($_SESSION['loggedInUser']->role != 1) {
            pushNotification(array('subject' => 'Lead status updated', 'message' => 'Lead status updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'to status' => $data['processTypeId'], 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id));
        }
        $this->_render_template('pipe_line/index', $process_status);
    }
    public function changeOrder() {
        $orders = $_POST['order'];
        //pre($orders);
        $process_order = $this->crm_model->change_process_order($orders);
        echo json_encode(array('msg' => 'error', 'status' => 'success', 'code' => 'C774'));
    }
    public function pipeline() {

        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('CRM', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Pipe Line', base_url() . 'crm/quotation');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Pipeline';
        //$where = array('c_id' => $_SESSION['loggedInUser']->c_id);
        #$where = array('c_id' => $this->companyGroupId);
        $this->data['user1'] = $this->crm_model->get_data_user_detail('user', array('user.c_id' => $this->companyGroupId, 'user.role' => 2, 'user.status' => 1));

        if (!empty($_POST['user_id'])!= 0) {
            $array = [];
            //$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id);
            $this->data['processType'] = $this->crm_model->get_data('lead_status');
            $i = 0;
            foreach ($this->data['processType'] as $ProcessType) {
                $where = array('lead_status' => $ProcessType['id'], 'lead_owner' => $_POST['user_id'], 'created_by_cid' => $this->companyGroupId);
                $process = $this->crm_model->get_data('leads', $where);
                $array[$i]['types'] = $ProcessType;
                $array[$i]['process'] = $process;
                $i++;
            }
            $this->data['processdata'] = $array;
            $this->_render_template('pipe_line/index', $this->data);
        } else {
            $array = [];
            //  $where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id);
            $this->data['processType'] = $this->crm_model->get_data('lead_status');
            $i = 0;
            foreach ($this->data['processType'] as $ProcessType) {
                $where = array('lead_status' => $ProcessType['id'], 'created_by_cid' => $this->companyGroupId);
                $process = $this->crm_model->get_data('leads', $where);
                $array[$i]['types'] = $ProcessType;
                $array[$i]['process'] = $process;
                $i++;
            }

            $this->data['processdata'] = $array;
            $this->_render_template('pipe_line/index', $this->data);
        }
    }

    // public function pipeline_byajax() {
    //     $this->data['can_edit'] = edit_permissions();
    //     $this->data['can_delete'] = delete_permissions();
    //     $this->data['can_add'] = add_permissions();
    //     $this->data['can_view'] = view_permissions();
    //     $this->breadcrumb->add('CRM', base_url() . 'crm/dashboard');
    //     $this->breadcrumb->add('Pipe Line', base_url() . 'crm/quotation');
    //     $this->settings['breadcrumbs'] = $this->breadcrumb->output();
    //     $this->settings['pageTitle'] = 'Pipeline';
    //     //$where = array('c_id' => $_SESSION['loggedInUser']->c_id);
    //     #$where = array('c_id' => $this->companyGroupId);
    //     $this->data['user1'] = $this->crm_model->get_data_user_detail('user', array('user.c_id' => $this->companyGroupId, 'user.role' => 2, 'user.status' => 1));
    //     if (isset($_POST['user_id'])) {
    //         $array = [];
    //         //$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id);
    //         $this->data['processType'] = $this->crm_model->get_data('lead_status');
    //         $i = 0;
    //         foreach ($this->data['processType'] as $ProcessType) {
    //             $where = array('lead_status' => $ProcessType['id'], 'lead_owner' => $_POST['user_id'], 'created_by_cid' => $this->companyGroupId);
    //             $process = $this->crm_model->get_data('leads', $where);
    //             $array[$i]['types'] = $ProcessType;
    //             $array[$i]['process'] = $process;
    //             $i++;
    //         }
    //         $this->data['processdata'] = $array;
    //         $this->_render_template('pipe_line/index', $this->data);

    //     }
    // }
    
    /* Types of Customers */
    /*Customer type index page*/
    public function customer_type() {

    $this->data['can_edit'] = edit_permissions();

    $this->data['can_delete'] = delete_permissions();

    $this->data['can_add'] = add_permissions();

    $this->data['can_view'] = view_permissions();

    $this->breadcrumb->add('CRM', base_url() . 'crm/dashboard');

    $this->breadcrumb->add('Customers Type', base_url() . 'crm/customer_type');

        $this->settings['breadcrumbs'] = $this->breadcrumb->output();

        $this->settings['pageTitle'] = 'Customers Type';

    //$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id);



    $where = array('created_by_cid' => $this->companyGroupId);

    $this->data['customerType']= $this->crm_model->get_data('types_of_customer',$where);

    $this->_render_template('settings/type_of_customer/index', $this->data);

    }
    /* Customer type Edit*/
    public function customerType_edit() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['customer_type'] = $this->crm_model->get_data_byId('types_of_customer', 'id', $id);
        $this->load->view('settings/type_of_customer/edit', $this->data);
    }
    /*Customer Type Save*/
    public function savecustomertype() {
        $data = $this->input->post();
		
        $where = array('type_of_customer' => $data['type_of_customer']);
        $id = $data['id'];
        $data2 = date("Y-m-d h:i:sa");
        $data1 = $this->companyGroupId;
        $data3 = $_SESSION['loggedInUser']->u_id;
        $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 13));
        $data['created_date'] = $data2;
        $data['created_by_cid'] = $data1;
        $data['created_by'] = $data3;
        $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 13));
        if ($id && $id != '') {

            $chkTypesOfCustomer = $this->crm_model->get_data('types_of_customer', $where);
            $beforeCustomer = $_POST['before_customer'];
            $chkCustomer = $chkTypesOfCustomer[0]['type_of_customer'];
            if(empty($chkTypesOfCustomer) || $beforeCustomer == $chkCustomer){
            $success = $this->crm_model->update_data('types_of_customer', $data, 'id', $id);
            if ($success) {
                $data['message'] = "Customer type  updated successfully";
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array('subject' => 'Customer type updated', 'message' => 'Customer type id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Customer type updated', 'message' => 'Customer type id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                }
                logActivity('Customer type Updated', 'process_type', $id);
                $this->session->set_flashdata('message', 'Customer type Updated successfully');
            }
            } else {
            $this->session->set_flashdata('error', 'ERROR !, Already Exist');
            }
            redirect(base_url() . 'crm/customer_type', 'refresh');
        } else {
			
            $chkTypesOfCustomer = $this->crm_model->get_data('types_of_customer', $where);
			// pre($data);
			// pre($chkTypesOfCustomer);
			
			// die();
           if(empty($chkTypesOfCustomer)){  
           unset($data['before_customer']);  
                         
            $id = $this->crm_model->insert_tbl_data('types_of_customer', $data);
            if ($id) {
                logActivity('Customer Type', 'customer_type', $id);
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array('subject' => 'Type of Customer created', 'message' => 'New types of  is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Type of Customer created', 'message' => 'New types of  is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                }
                $this->session->set_flashdata('message', 'Type of inserted successfully');
            }
        } else {
          $this->session->set_flashdata('error', 'ERROR !, Already Exist');
        }
         redirect(base_url() . 'crm/customer_type', 'refresh');
        }
    }
    public function price_upload(){

    $this->data['can_edit'] = edit_permissions();

    $this->data['can_delete'] = delete_permissions();

    $this->data['can_add'] = add_permissions();

    $this->data['can_view'] = view_permissions();

    $this->breadcrumb->add('CRM', base_url() . 'crm/dashboard');

    $this->breadcrumb->add('Price List', base_url() . 'crm/price_upload');

        $this->settings['breadcrumbs'] = $this->breadcrumb->output();

        $this->settings['pageTitle'] = 'Price Upload';

    //$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id);

    $where = array('created_by_cid' =>$this->companyGroupId , 'AND active_inactive = 1');

    $this->data['customerType']= $this->crm_model->get_data('types_of_customer',$where);

	$bb = "'";
	$cc = "'";
	$this->data['finish_goods'] = $this->crm_model->get_data('material','created_by_cid = '.$this->companyGroupId.' AND '.'`sale_purchase` ='.$bb.'["Sale"]'.$cc.'');
    #pre($this->data['finish_goods']);die;
    // $where = array('created_by_cid' => $this->companyGroupId);

    // $this->data['finish_goods']= $this->crm_model->get_data('finish_goods',$where);
    $this->_render_template('price_upload/index', $this->data);

    }
    // public function savePricelist() {
    //     #pre($_POST['ajaxDataArray']);die;
    //     // controller part code explanation
    //     $data = $_POST['ajaxDataArray'];
    //     // pre($data);
    //     if (!empty($data)) {
    //         foreach ($data as $dt) {
    //           #  pre($dt);
    //             $existMatId_CustomerType = $this->crm_model->record_exists('price_list', array('product_id' => $dt['product_id'], 'customer_type' => $dt['customer_type'], 'price' => $dt['price']));
    //             #echo $existMatId_CustomerType;
    //             #die;
    //             if (empty($existMatId_CustomerType)) {
    //                 echo 'value is' . $dt['price'] . '<br>';
    //                 $insertedid = $this->crm_model->insert_tbl_data('price_list', array('product_id' => $dt['product_id'], 'customer_type' => $dt['customer_type'], 'price' => $dt['price']));
    //                 //insert_tbl_data('proforma_invoice',$data)

    //             } else {
    //                 //$success = $this->crm_model->update_data('sale_order',$data, 'id', $id);
    //                 $updatedId = $this->crm_model->update_data('price_list', array('product_id' => $dt['product_id'], 'customer_type' => $dt['customer_type'], 'price' => $dt['price']), 'product_id', $dt['product_id'], 'customer_type', $dt['customer_type']);
    //             }
    //         }
    //     }
    // }
    public function updateoldrecords() {
        $this->data['quotation'] = $this->crm_model->get_data('quotation', array('created_by_cid' => $_SESSION['loggedInUser']->c_id));
        foreach ($this->data['quotation'] as $key) {
            $products = json_decode($key['product']);
            if (!empty($products)) {
                #   pre($products);
                $i = 0;
                $newProduct = array();
                foreach ($products as $product) {
                    $ww = getNameById('uom', $product->uom, 'ugc_code');
                    if (empty($ww)) {
                        $product->uom = "113";
                    } else {
                        $product->uom = $ww->id;
                    }
                    $newProduct[$i] = $product;
                    #$this->crm_model->updateRowWhere('leads',$aa,$data);
                    $i++;
                }
                $aa = array('id' => $key['id']);
                $data['product'] = json_encode($newProduct);
                #pre($data);
                $this->crm_model->updateRowWhere('quotation', $aa, $data);
            }
        }
    }
    /**********active inactive status ****************/
    public function change_status() {
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status = (isset($_POST['uomStatus']) && $_POST['uomStatus'] == 1) ? '1' : '0';
        $status_data = $this->crm_model->toggle_change_status($id, $status);
    }
    public function competitor_details() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('CRM', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Competitor Details', base_url() . 'crm/competitor_details');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Competitor Details';
        $where = 'competitor_details.account_owner = ' . $this->companyGroupId;
        if (isset($_GET['favourites']) && $_GET['favourites'] != '') {
            $where = "competitor_details.favourite_sts=1 and competitor_details.account_owner = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['favourites']) == '') {
            $where = "competitor_details.created_date>='" . $_GET['start'] . "' and competitor_details.created_date<='" . $_GET['end'] . "'and competitor_details.account_owner = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['favourites']) == '' && isset($_GET['ExportType']) == '') {
            $where = "competitor_details.created_date>='" . $_GET['start'] . "' and competitor_details.created_date<='" . $_GET['end'] . "'and competitor_details.account_owner = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['ExportType']) != '' && $_GET['favourites'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search'] == '' && $_GET['account_name'] == '') {
            $where = 'competitor_details.account_owner = ' . $this->companyGroupId;
        } elseif (isset($_GET['ExportType']) != '' && $_GET['favourites'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search'] == '' && $_GET['account_name'] == '') {
            $where = "competitor_details.favourite_sts=1 and competitor_details.account_owner = '" . $this->companyGroupId . "'";
        } elseif (isset($_GET['ExportType']) != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['favourites'] == '' && $_GET['search'] == '') {
            $where = "competitor_details.created_date>='" . $_GET['start'] . "' and competitor_details.created_date<='" . $_GET['end'] . "' and competitor_details.account_owner = '" . $this->companyGroupId . "'";
        }
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $where2 = "(competitor_details.id like'%" . $search_string . "%' or competitor_details.name like'%" . $search_string . "%')";
            redirect("crm/competitor_details/?search=$search_string");
        } else if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "(competitor_details.id like'%" . $_GET['search'] . "%' or competitor_details.name like'%" . $_GET['search'] . "%')";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "crm/competitor_details/";
        $config["total_rows"] = $this->crm_model->tot_rows('competitor_details', $where, $where2);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $config['anchor_class'] = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['competitor_details'] = $this->crm_model->get_data1('competitor_details', $where, $config["per_page"], $page, $where2, $order, $export_data);
        $this->_render_template('competitor_details/index', $this->data);
    }
    public function competitor_details_edit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['account'] = $this->crm_model->get_data_byId('competitor_details', 'id', $this->input->post('id'));
        #pre($this->data['account']);
        $this->load->view('competitor_details/edit', $this->data);
    }
    /*  Function to save/update Account */
    public function save_competitor_details() {
        #pre($_POST);
        if ($this->input->post()) {
            $required_fields = array('material_type_id','material_name');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $material_details = count($_POST['material_name']);
                if ($material_details > 0) {
                    $arr = [];
                    $j = 0;
                    while ($j < $material_details) {
                        $jsonArrayObject = (array('material_type_id' => $_POST['material_type_id'][$j], 'material_name_id' => $_POST['material_name'][$j], 'disc' => $_POST['disc'][$j], 'unit' => $_POST['uom_value'][$j], 'price' => $_POST['price'][$j]));
                        $arr[$j] = $jsonArrayObject;
                        $j++;
                    }
                    $materialDetail_array = json_encode($arr);
                } else {
                    $materialDetail_array = '';
                }
                $data = $this->input->post();
                $data['account_owner'] = $this->companyGroupId;
                $id = $data['id'];
                $data['product_detail'] = $materialDetail_array;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success = $this->crm_model->update_data('competitor_details', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Competitor Details updated successfully";
                        logActivity('Competitor Details Updated', 'competitor_details', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Company updated' , 'message' => 'Company updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Competitor Details updated', 'message' => 'Competitor Details updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*  pushNotification(array('subject'=> 'Company updated' , 'message' => 'Company updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));  */
                            pushNotification(array('subject' => 'Competitor Details updated', 'message' => 'Competitor Details updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'Competitor Details updatedsuccessfully');
                        redirect(base_url() . 'crm/competitor_details', 'refresh');
                    }
                } else {
                    $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                    $id = $this->crm_model->insert_tbl_data('competitor_details', $data);
                    if ($id) {
                        logActivity('New Competitor Details Created', 'competitor_details', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Company created' , 'message' => 'Company created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Competitor Details created', 'message' => 'New Competitor Details is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*pushNotification(array('subject'=> 'Company created' , 'message' => 'Company created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Competitor Details created', 'message' => 'New Competitor Details is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'New Competitor Details inserted successfully');
                        redirect(base_url() . 'crm/competitor_details', 'refresh');
                    }
                }
            }
        }
    }
    public function delete_competitor_details($id = '') {
        if (!$id) {
            redirect('crm/competitor_details', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->crm_model->delete_data('competitor_details', 'id', $id);
        if ($result) {
            logActivity('Competitor Details  Deleted', 'competitor_details', $id);
            $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Competitor Details deleted', 'message' => 'Competitor Details id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Competitor Details deleted', 'message' => 'Competitor Details id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
            }
            $this->session->set_flashdata('message', 'Competitor Details Deleted Successfully');
            $result = array('msg' => 'Competitor Details deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/competitor_details');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    /* Add Price */
    public function add_price_compt() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Add Price (Competitor)', base_url() . 'crm/add_price_compt');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Add Price (Competitor)';
        $where = 'comp_price.account_owner = ' . $this->companyGroupId;
        if (isset($_GET['favourites']) != '' && isset($_GET['ExportType']) == '') {
            $where = "comp_price.favourite_sts=1 and comp_price.account_owner = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['favourites']) == '' && isset($_GET['ExportType']) == '') {
            $where = "comp_price.created_date>='" . $_GET['start'] . "' and comp_price.created_date<='" . $_GET['end'] . "' and comp_price.account_owner = '" . $this->companyGroupId . "'";
        } elseif (isset($_GET['ExportType']) != '' && $_GET['favourites'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search'] == '') {
            $where = 'comp_price.account_owner = ' . $this->companyGroupId;
        } elseif (isset($_GET['ExportType']) != '' && $_GET['favourites'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search'] == '') {
            $where = "comp_price.favourite_sts=1 and comp_price.account_owner = '" . $this->companyGroupId . "'";
        } elseif (isset($_GET['ExportType']) != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['favourites'] == '' && $_GET['search'] == '') {
            $where = "comp_price.created_date>='" . $_GET['start'] . "' and comp_price.created_date<='" . $_GET['end'] . "' and comp_price.account_owner = '" . $this->companyGroupId . "' ";
        }
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $account = getNameById('competitor_details', $search_string, 'name');
            if (!empty($account)) {
                $where = "(comp_price.account_id = '" . $account->id . "' )";
            } else {
                $where2 = "(comp_price.id ='" . $search_string . "')";
            }
            redirect("crm/add_price_compt/?search=$search_string");
        } elseif (isset($_GET['search']) && $_GET['search'] != '') {
            $accountName = getNameBySearch('competitor_details', $_GET['search'], 'name');
            $where2 = array();
            foreach ($accountName as $name) { //pre($name['id']);
                $where2[] = "(comp_price.account_id ='" . $name['id'] . "')";
            }
            if (sizeof($where2) != '') {
                $where2 = implode("||", $where2);
            } else {
                $where = "(comp_price.id like'%" . $_GET['search'] . "%')";
            }
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "crm/add_price_compt/";
        $config["total_rows"] = $this->crm_model->tot_rows('comp_price', $where, $where2);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $config['anchor_class'] = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['competitor_details'] = $this->crm_model->get_data1('comp_price', $where, $config["per_page"], $page, $where2, $order, $export_data);
        $this->_render_template('add_price/index', $this->data);
    }
    public function addPrice_edit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['account'] = $this->crm_model->get_data_byId('comp_price', 'id', $this->input->post('id'));
        #pre($this->data['account']);
        $this->load->view('add_price/edit', $this->data);
    }
    /*  Function to save/update Account */
    public function save_add_price() {
        #pre($_POST);
        if ($this->input->post()) {
            $required_fields = array('account_id');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $material_details = count($_POST['material_name']);
                if ($material_details > 0) {
                    $arr = [];
                    $j = 0;
                    while ($j < $material_details) {
                        $jsonArrayObject = (array('material_type_id' => $_POST['material_type_id'][$j], 'material_name_id' => $_POST['material_name'][$j], 'disc' => $_POST['disc'][$j], 'unit' => $_POST['uom_value'][$j], 'price' => $_POST['price'][$j]));
                        $arr[$j] = $jsonArrayObject;
                        $j++;
                    }
                    $materialDetail_array = json_encode($arr);
                } else {
                    $materialDetail_array = '';
                }
                $data = $this->input->post();
                $data['account_owner'] = $this->companyGroupId;
                $id = $data['id'];
                $data['product_detail'] = $materialDetail_array;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    #pre($data);
                    #die;
                    $success = $this->crm_model->update_data('comp_price', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Competitor Price Details updated successfully";
                        logActivity('Competitor Price Details Updated', 'competitor_details', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Company updated' , 'message' => 'Company updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Competitor Details updated', 'message' => 'Competitor Details updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*  pushNotification(array('subject'=> 'Company updated' , 'message' => 'Company updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));  */
                            pushNotification(array('subject' => 'Competitor Price Details updated', 'message' => 'Competitor Price Details updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'Competitor Price Details updated successfully');
                        redirect(base_url() . 'crm/add_price_compt', 'refresh');
                    }
                } else {
                    $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                    $id = $this->crm_model->insert_tbl_data('comp_price', $data);
                    if ($id) {
                        logActivity('New Competitor Details Created', 'competitor_details', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Company created' , 'message' => 'Company created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Competitor Price Details created', 'message' => 'New Competitor Price Details is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*pushNotification(array('subject'=> 'Company created' , 'message' => 'Company created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Competitor Price Details created', 'message' => 'New Competitor Price Details is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'New Competitor Price Details inserted successfully');
                        redirect(base_url() . 'crm/add_price_compt', 'refresh');
                    }
                }
            }
        }
    }
    public function delete_add_price_compt($id = '') {
        if (!$id) {
            redirect('crm/competitor_details', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->crm_model->delete_data('comp_price', 'id', $id);
        if ($result) {
            logActivity('Competitor Price Details (Competitor vise)  Deleted', 'comp_price', $id);
            $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Competitor Price Details (Competitor vise)', 'message' => 'Competitor Price Details (Competitor vise) id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Competitor Price Details (Competitor vise)', 'message' => 'Competitor Price Details (Competitor vise) id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
            }
            $this->session->set_flashdata('message', 'Competitor Price Details (Competitor vise) Deleted Successfully');
            $result = array('msg' => 'Competitor Price Details (Competitor vise) deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/add_price_compt');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    public function getMat() {
        if ($_POST['id'] != '') {
            $account = $this->crm_model->get_data_byId('competitor_details', 'id', $_POST['id']);
            $tt = json_decode($account->product_detail);
            if (!empty($tt)) {
                $i = 0;
                $uu = "";
                $newProduct = array();
                foreach ($tt as $key) {
                    $ww = getNameById('material_type', $key->material_type_id, 'id');
                    $pp = getNameById('material', $key->material_name_id, 'id');
                    $cc = getNameById('uom', $key->unit, 'id');
                    $key->material_type_id = $ww->id;
                    $key->material_type = $ww->name;
                    $key->material_name_id = $pp->id;
                    $key->material_name = $pp->material_name;
                    $key->unit = $cc->id;
                    $key->unit_name = $cc->ugc_code;
                    $key->disc = $key->disc;
                    $key->price = $key->price;
                    $newProduct[$i] = $key;
                    $i++;
                }
                echo json_encode($newProduct);
            }
        }
    }
    public function add_price_prodct() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Add Price (Product)', base_url() . 'crm/add_price_prodct');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Add Price (Product)';
        $where = 'prodct_price.created_by_cid = ' . $this->companyGroupId;
        if (isset($_GET['favourites']) != '' && isset($_GET['ExportType']) == '') { //die('uh');
            $where = "prodct_price.favourite_sts=1 and prodct_price.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['favourites']) == '' && isset($_GET['ExportType']) == '') {
            $where = "prodct_price.created_date>='" . $_GET['start'] . "' and prodct_price.created_date<='" . $_GET['end'] . "' and prodct_price.created_by_cid = '" . $this->companyGroupId . "'";
        } else if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['favourites']) == '' && isset($_GET['ExportType']) != '') {
            $where = "prodct_price.created_date>='" . $_GET['start'] . "' and prodct_price.created_date<='" . $_GET['end'] . "' and prodct_price.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['ExportType']) != '' && $_GET['favourites'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search'] == '' && $_GET['account_name'] == '') {
            $where = 'prodct_price.created_by_cid = ' . $this->companyGroupId;
        } elseif (isset($_GET['ExportType']) != '' && $_GET['favourites'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search'] == '' && $_GET['account_name'] == '') {
            $where = "prodct_price.favourite_sts=1 and prodct_price.created_by_cid = '" . $this->companyGroupId . "'";
        } elseif (isset($_GET['ExportType']) != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['favourites'] == '' && $_GET['search'] == '' && $_GET['account_name'] == '') {
            $where = "prodct_price.created_date>='" . $_GET['start'] . "' and prodct_price.created_date<='" . $_GET['end'] . "' and prodct_price.created_by_cid = '" . $this->companyGroupId . "'";
        } elseif (isset($_GET['ExportType']) != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites'] == '' && $_GET['search'] != '') {
            $materialName = getNameById('material', $_GET['search'], 'material_name');
            $material_type_tt = getNameById('material_type', $_GET['search'], 'name');
            if ($material_type_tt->id != '') {
                $where = "prodct_price.material_type_id like '%" . $material_type_tt->id . "%'";
            } elseif ($materialName->id != '' && $material_type_tt->id == '') {
                $where = "prodct_price.material_name like '%" . $materialName->id . "%'";
            } else {
                $where = "(prodct_price.id like'%" . $_GET['search'] . "%')";
            }
        }
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $materialName = getNameById('material', $search_string, 'material_name');
            $material_type_tt = getNameById('material_type', $search_string, 'name');
            if ($material_type_tt['id'] != '') {
                $where = "prodct_price.material_type_id like '%" . $material_type_tt->id . "%'";
            } elseif ($materialName['id'] != '' && $material_type_tt->id == '') {
                $where = "prodct_price.material_name like '%" . $materialName->id . "%'";
            } else {
                $where = "(prodct_price.id like'%" . $search_string . "%')";
            }
            redirect("crm/add_price_prodct/?search=$search_string");
        } else if (isset($_GET['search']) && $_GET['search'] != '') {
            $materialName = getNameBySearch('material', $_GET['search'], 'material_name');
            $material_type_tt = getNameBySearch('material_type', $_GET['search'], 'name');
            $where2 = array();
            foreach ($materialName as $name) { //pre($name['id']);
                $where2[] = "prodct_price.material_name like '%" . $name['id'] . "%'";
            }
            foreach ($material_type_tt as $material_type) { //pre($name['id']);
                $where2[] = "prodct_price.material_type_id like '%" . $material_type['id'] . "%'";
            }
            if (sizeof($where2) != '') {
                $where2 = implode("||", $where2);
            } else {
                $where = "(prodct_price.id like'%" . $_GET['search'] . "%')";
            }
            /*if(isset($material_type_tt->id)!=''){
            $where = "prodct_price.material_type_id like '%" . $material_type_tt->id . "%'";
            }elseif(isset($materialName->id)!= '' && isset($material_type_tt->id)==''){
            $where = "prodct_price.material_name like '%" . $materialName->id . "%'" ;
            }else{
            $where = "(prodct_price.id like'%" . $_GET['search'] . "%')";
            }*/
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "crm/add_price_prodct/";
        $config["total_rows"] = $this->crm_model->tot_rows('prodct_price', $where, $where2);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $config['anchor_class'] = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['competitor_details'] = $this->crm_model->get_data1('prodct_price', $where, $config["per_page"], $page, $where2, $order, $export_data);
        //$this->data['competitor_details'] = $this->crm_model->get_data('prodct_price');
        $this->_render_template('add_price_prodct/index', $this->data);
    }
    public function add_price_prodct_edit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['account'] = $this->crm_model->get_data_byId('prodct_price', 'id', $this->input->post('id'));
        #pre($this->data['account']);
        $this->load->view('add_price_prodct/edit', $this->data);
    }
	public function viewcompetitorMat(){
		 if ($this->input->post('id') != '') {
            permissions_redirect('is_view');
        }
        $this->data['prdtl'] = $this->crm_model->get_data_byId('prodct_price', 'id', $this->input->post('id'));
        $this->load->view('add_price_prodct/viewMat', $this->data);
	}
    public function save_price_prodct() {
        if ($this->input->post()) {
            $required_fields = array('account_id');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $material_details = count($_POST['account_id']);
                if ($material_details > 0) {
                    $arr = [];
                    $j = 0;
                    while ($j < $material_details) {
                        $jsonArrayObject = (array('compt_id' => $_POST['account_id'][$j], 'disc' => $_POST['disc'][$j], 'price' => $_POST['price'][$j]));
                        $arr[$j] = $jsonArrayObject;
                        $j++;
                    }
                    $materialDetail_array = json_encode($arr);
                } else {
                    $materialDetail_array = '';
                }
                # pre($materialDetail_array);
                #die;
                $data = $this->input->post();
                $id = $data['id'];
                $data['comp_price_info'] = $materialDetail_array;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    #pre($data);
                    #die;
                    $success = $this->crm_model->update_data('prodct_price', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Competitor Price Details (Product vise) updated successfully";
                        logActivity('Competitor Price Details (Product vise)', 'competitor_details', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'Competitor Price Details (Product vise) updated', 'message' => 'Competitor Price Details (Product vise) updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'Competitor Price Details (Product vise) updated', 'message' => 'Competitor Price Details (Product vise) updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'Competitor Price Details (Product vise) updated successfully');
                        redirect(base_url() . 'crm/add_price_prodct', 'refresh');
                    }
                } else {
                    $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                    $id = $this->crm_model->insert_tbl_data('prodct_price', $data);
                    if ($id) {
                        logActivity('New Competitor Price Details (Product vise) Created', 'competitor_details', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'Competitor Price Details (Product vise) Created created', 'message' => 'New Competitor Price Details (Product vise) Created is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'Competitor Price Details (Product vise) Created', 'message' => 'New Competitor Price Details (Product vise) Created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'New Competitor Price Details (Product vise) inserted successfully');
                        redirect(base_url() . 'crm/add_price_prodct', 'refresh');
                    }
                }
            }
        }
    }
    /*delete supplier*/
    public function deleteProdctPrice($id = '') {
        if (!$id) {
            redirect('crm/add_price_prodct', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->crm_model->delete_data('prodct_price', 'id', $id);
        if ($result) {
            logActivity('record  Deleted', 'leads', $id);
            $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Company deleted', 'message' => 'Company id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Company deleted', 'message' => 'Company id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
            }
            $this->session->set_flashdata('message', 'Record Deleted Successfully');
            $result = array('msg' => 'Record Deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/add_price_prodct');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    public function getCompt() {
        if ($_POST['mat_type_id'] != '' && $_POST['mat_name_id'] != '') {
            $mat_typ_id = $_POST['mat_type_id'];
            $mat_nam_id = $_POST['mat_name_id'];
            $bb = "'";
            $cc = "'";
            $ty = $bb . '%[{"material_type_id":"' . $mat_typ_id . '","material_name_id":"' . $mat_nam_id . '"%' . $cc;
            $this->data['cptdet'] = $this->crm_model->get_data('competitor_details', 'account_owner = ' . $this->companyGroupId . ' AND ' . '`product_detail` LIKE ' . $ty . '');
            if (!empty($this->data['cptdet'])) {
                $i = 0;
                $newProduct = array();
                foreach ($this->data['cptdet'] as $key) {
                    $key['name'] = $key['name'];
                    $key['id'] = $key['id'];
                    $newProduct[$i] = $key;
                    $i++;
                }
                echo json_encode($newProduct);
            }
        }
    }
    public function convert_SO_to_Invoice() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['sale_order'] = $this->crm_model->get_data_byId('sale_order', 'id', $this->input->post('id'));
        //$this->data['materials']  = $this->crm_model->get_data('material');
        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'sale_order');
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->load->view('sale_orders/convt_invoices', $this->data);
    }
    public function selectMatrial() {
        if ($_REQUEST['id'] && $_REQUEST['id'] != '') {
            $data = $this->crm_model->get_matrial_data_byId('material', 'id', $_REQUEST['id']);
            $ww = getNameById('uom', $data->uom, 'id');
            $data->uom = $ww->ugc_code;
            $data->uomid = $ww->id;
            echo json_encode($data, true);
            die;
        }
    }
    public function add_comment() {
        // echo $_POST['id'];die();
        $data = array('status_comment' => $_POST['comment']);
        if ($_POST['status'] == 'Loose') {
            $this->crm_model->update_data_add_comment('leads', $data, 'id', $_POST['id']);
            redirect(base_url() . 'crm/leads');
        } else {
            $this->crm_model->update_data_add_comment('leads', $data, 'id', $_POST['id']);
            redirect(base_url() . 'crm/leads');
        }
    }
    public function leads_lost() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Leads Lost Report', base_url() . 'crm/leads_lost');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Leads Lost Report';

         $inProcessWhere = "leads.lead_status = 6 and leads.created_by_cid = '" . $this->companyGroupId . "'AND YEAR(updated_date) = YEAR(CURRENT_DATE()) AND MONTH(updated_date) = MONTH(CURRENT_DATE())";

        if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "leads.updated_date >='" . $_GET['start'] . "' and leads.updated_date<='" . $_GET['end'] . "' and leads.lead_status = 6 and leads.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "leads.updated_date >='" . $_GET['start'] . "' and leads.updated_date<='" . $_GET['end'] . "' and leads.lead_status = 6 and leads.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['ExportType']) != '' && isset($_GET['start']) && $_GET['start'] == '') {
           $inProcessWhere = "leads.lead_status = 6 and leads.created_by_cid = '" . $this->companyGroupId . "'AND YEAR(updated_date) = YEAR(CURRENT_DATE()) AND MONTH(updated_date) = MONTH(CURRENT_DATE())";
        }
        $this->data['leads_data'] = $this->crm_model->get_data('leads', $inProcessWhere);
        # pre($this->data['leads_data']);
        $this->_render_template('leads_lost_report/index', $this->data);
    }
	public function viewsaleorder_matView($id = '') {
       if ($this->input->post('id')) {
            permissions_redirect('is_view');
        }
        $this->data['id'] = $this->input->post('id');
        $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['sale_order'] = $this->crm_model->get_data_byId('sale_order', 'id', $this->input->post('id'));
        $this->data['sale_order_dispatch'] = $this->crm_model->get_dispatch_data('sale_order_dispatch', array('sale_order_id' => $this->input->post('id')));

        $whereAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'sale_order');
        $whereDispatchAttachment = array('rel_id' => $this->input->post('id'), 'rel_type' => 'sale_order_dispatch');
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->data['dispatch_attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereDispatchAttachment);

        $this->load->view('sale_orders/viewSaleOrder_matView', $this->data);
    }
    public function viewSaleOrderProgess($id = '') {
        if ($this->input->post('id')) {
            permissions_redirect('is_view');
        }
        $this->data['id'] = $this->input->post('id');
        $this->data['sale_order'] = $this->crm_model->get_data_byId('sale_order', 'id', $this->input->post('id'));
        $saleOrderId = $this->input->post('id');
        $bb = "'";
        $cc = "'";
        $this->data['production_data'] = $this->crm_model->get_data('production_data', 'created_by_cid = ' . $this->companyGroupId . ' AND ' . '`production_data` LIKE ' . $bb . '%"sale_order":["' . $saleOrderId . '"]%' . $cc . '');
        $this->load->view('sale_orders/progess_of_so', $this->data);
    }
    /*end of controller*/
    public function loadProcess() {
        $groups = array();
        $json = '[

       {

          "id":1,

          "text":"Group 1",

          "tags":{

             "info":"info text"

          },

          "children":[

             {

                "start":"2014-10-02",

                "end":"2014-10-04",

                "id":2,

                "text":"Subtask 1",

                "complete":Math.floor(Math.random() * 101) // 0 to 100

             },

             {

                "start":"2014-10-04",

                "end":"2014-10-07",

                "id":3,

                "text":"Subtask 2",

                "complete":Math.floor(Math.random() * 101) // 0 to 100

             },

             {

                "start":"2014-10-10",

                "id":4,

                "text":"Milestone 1",

                "type":"Milestone"

             }

          ]

       }

    ]';
        $result = json_decode($json);
        echo json_encode($result);
    }
    public function lead_report() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Lead Reports', base_url() . 'crm/lead_report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Lead Reports';
        $this->data['lead_reports'] = $this->crm_model->get_data('lead_report');
        #pre($this->data['lead_reports']);
        $this->_render_template('leads_reports/index', $this->data);
    }
    public function lead_by_source() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('lead_report', $data, 'id', '1');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Lead by Sources', base_url() . 'crm/lead_by_source');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Lead by Sources Report';
        $this->data['leadStatus'] = $this->crm_model->get_data('lead_status');
        $inProcessWhere = "lead_source != 0 and leads.created_by_cid = '" . $this->companyGroupId . "'AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and lead_source != 0 and leads.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and lead_source != 0 and leads.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['ExportType']) != '' && isset($_GET['start']) && $_GET['start'] == '') {
            $inProcessWhere = "lead_source != 0 and leads.created_by_cid = '" . $this->companyGroupId . "' AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";
        }
        $this->data['leads'] = $this->crm_model->get_data('leads', $inProcessWhere);
        $new_array = array();
        foreach ($this->data['leads'] as $source) {
            $new_array[$source['lead_source']][] = $source;
        }
        $this->data['lead_by_source'] = $new_array;
        # pre($new_array);
        #  die;
        $this->_render_template('leads_reports/leads_by_source', $this->data);
    }
    public function todays_lead() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('lead_report', $data, 'id', '2');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Today Leads', base_url() . 'crm/todays_lead');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = "Today's Leads";
        #$where = array('save_status' => 1, 'DATE(created_date)' => date('Y-m-d'), 'created_by_cid' => $this->companyGroupId);

        $inProcessWhere = "(save_status = 1 and DATE(created_date) = '".date('Y-m-d')."') and (leads.created_by_cid = '" . $this->companyGroupId . "')";


        if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {
            $inProcessWhere = "DATE (created_date) >='" . $_GET['start'] . "' and DATE (created_date)<='" . $_GET['end'] . "' and (leads.save_status = 1 and leads.created_by_cid = '" . $this->companyGroupId . "')";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {
           $inProcessWhere = "DATE (created_date) >='" . $_GET['start'] . "' and DATE (created_date)<='" . $_GET['end'] . "' and (leads.save_status = 1 and leads.created_by_cid = '" . $this->companyGroupId . "')";
        }
        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
           $inProcessWhere = "(save_status = 1 and DATE(created_date) = '".date('Y-m-d')."') and (leads.created_by_cid = '" . $this->companyGroupId . "')";
        } elseif (isset($_GET['ExportType']) && isset($_GET['start']) != '' && isset($_GET['end']) != '') {
             $inProcessWhere = "DATE (created_date) >='" . $_GET['start'] . "' and DATE (created_date)<='" . $_GET['end'] . "' and (leads.save_status = 1 and leads.created_by_cid = '" . $this->companyGroupId . "')";
        }
        $this->data['todays_leads'] = $this->crm_model->get_data('leads', $inProcessWhere);
        #pre($this->data['lead_by_source']);
        #pre($this->data['lead_by_source']);
        #die;
        $this->_render_template('leads_reports/todays_leads', $this->data);
    }
    public function converted_leads() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('lead_report', $data, 'id', '3');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Converted Leads', base_url() . 'crm/todays_lead');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = "Converted's Leads into Accounts/Contacts";
        #$this->data['leadStatus'] = $this->crm_model->get_data('lead_status');
        #$this->data['lead_owner'] = $this->crm_model->get_data('user_detail', array("c_id" => $this->companyGroupId));
        # $where = array('converted_to_account' => 1, 'converted_to_contact' => 1, 'created_by_cid' => $this->companyGroupId);
        $inProcessWhere = "(converted_to_account = 1 or converted_to_contact = 1) and (leads.created_by_cid = '" . $this->companyGroupId . "') AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {
            $inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and (converted_to_account = 1 or converted_to_contact = 1) and (leads.created_by_cid = '" . $this->companyGroupId . "')";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {
            $inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and (converted_to_account = 1 or converted_to_contact = 1) and (leads.created_by_cid = '" . $this->companyGroupId . "')";
        }
        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
            $inProcessWhere = "(converted_to_account = 1 or converted_to_contact = 1) and (leads.created_by_cid = '" . $this->companyGroupId . "') AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";
        } elseif (isset($_GET['ExportType']) && isset($_GET['start']) != '' && isset($_GET['end']) != '') {
            $inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and (converted_to_account = 1 or converted_to_contact = 1) and (leads.created_by_cid = '" . $this->companyGroupId . "')";
        }
        $this->data['converted_leads'] = $this->crm_model->get_data('leads', $inProcessWhere);
        $this->_render_template('leads_reports/converted_leads', $this->data);
    }
    public function lead_by_qwnership() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('lead_report', $data, 'id', '4');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Lead by Ownership', base_url() . 'crm/lead_by_ownership');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Lead by OwnerShip';
        $this->data['leadStatus'] = $this->crm_model->get_data('lead_status');
        $this->data['lead_owner'] = $this->crm_model->get_data('user_detail', array("c_id" => $this->companyGroupId));
        #pre($this->data['leads']);
        $inProcessWhere = " save_status = 1 and lead_owner != 0 and leads.created_by_cid = '" . $this->companyGroupId . "'AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";


        if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and save_status = 1 and lead_owner != 0 and leads.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and save_status = 1 and lead_owner != 0 and leads.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
           $inProcessWhere = " save_status = 1 and lead_owner != 0 and leads.created_by_cid = '" . $this->companyGroupId . "'AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";

        } elseif (isset($_GET['ExportType']) && isset($_GET['start']) != '' && isset($_GET['end']) != '') {
            $inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and save_status = 1 and lead_owner != 0 and leads.created_by_cid = '" . $this->companyGroupId . "'";
        }
        $this->data['leads'] = $this->crm_model->get_data('leads', $inProcessWhere);
        $new_array = array();
        foreach ($this->data['leads'] as $owner) {
            $new_array[$owner['lead_owner']][] = $owner;
        }
        $this->data['lead_by_owner'] = $new_array;
        //pre($new_array);
        //die;
        $this->data['leads'] = $this->crm_model->get_data('leads', $inProcessWhere);
        $this->_render_template('leads_reports/leads_by_owner', $this->data);
    }
    // public function lead_by_industries(){
    //     $data = array('created_date' => date('Y/m/d H:i:s'));
    //     $this->crm_model->update_data('lead_report', $data, 'id', '4');
    //     $this->load->library('pagination');
    //     $this->load->helper('url');
    //     $this->data['can_edit'] = edit_permissions();
    //     $this->data['can_view'] = view_permissions();
    //     $this->data['can_delete'] = delete_permissions();
    //     $this->data['can_add'] = add_permissions();
    //     $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
    //     $this->breadcrumb->add('Lead by Industries', base_url() . 'crm/lead_by_industries');
    //     $this->settings['breadcrumbs'] = $this->breadcrumb->output();
    //     $this->settings['pageTitle'] = 'Lead by Industries';
    //     $this->data['leadStatus'] = $this->crm_model->get_data('lead_status');
    //     $this->data['lead_owner'] = $this->crm_model->get_data('user_detail', array("c_id" => $this->companyGroupId));
    //         $where = array('save_status' => 1, 'created_by_cid' => $this->companyGroupId , 'lead_owner !=' =>0);
    //             $this->data['leads'] = $this->crm_model->get_data('leads',$where);
    //             #pre($this->data['leads']);
    //         $new_array= array();
    //        foreach($this->data['leads'] as $owner){
    //            $new_array[$owner['lead_owner']][] = $owner;
    //        }
    //        $this->data['lead_by_owner'] = $new_array;
    //       //pre($new_array);
    //        //die;
    //     $this->_render_template('leads_reports/leads_by_owner', $this->data);
    // }
    public function lead_by_status() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('lead_report', $data, 'id', '6');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Lead by Status', base_url() . 'crm/lead_by_staus');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Lead by Status';
        $inProcessWhere = "save_status = 1 AND lead_status IN ('1','2','3','4','5','6')" . ' AND created_by_cid = ' . $this->companyGroupId.' AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())';
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and save_status = 1 AND lead_status IN ('1','2','3','4','5','6') and leads.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and save_status = 1 AND lead_status IN ('1','2','3','4','5','6') and leads.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['ExportType']) != '' && isset($_GET['start']) && $_GET['start'] == '') {
            $inProcessWhere = "save_status = 1 AND lead_status IN ('1','2','3','4','5','6')" . ' AND created_by_cid = ' . $this->companyGroupId.' AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())';
        }
        #$where = "save_status = 1 AND lead_status IN ('1','2','3','4','5','6')".' AND created_by_cid = ' . $this->companyGroupId;
        $this->data['leads'] = $this->crm_model->get_data('leads', $inProcessWhere);
        $new_array = array();
        foreach ($this->data['leads'] as $leadStatus) {
            $new_array[$leadStatus['lead_status']][] = $leadStatus;
        }
        $this->data['lead_by_status'] = $new_array;
        //pre($new_array);
        //die;
        $this->_render_template('leads_reports/lead_by_status', $this->data);
    }
    public function activity_report() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Activity Reports', base_url() . 'crm/activity_report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Activity Reports';
        $this->data['activity_report'] = $this->crm_model->get_data('activity_reports');
        #pre($this->data['lead_reports']);
        $this->_render_template('activity_report/index', $this->data);
    }
    public function call_status_reports() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('activity_reports', $data, 'id', '1');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Call Status Reports', base_url() . 'crm/call_status_reports');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Call Status Reports';
        $this->data['leadStatus'] = $this->crm_model->get_data('lead_status');
        $this->data['lead_owner'] = $this->crm_model->get_data('user_detail', array("c_id" => $this->companyGroupId));

        //$inProcessWhere = "subject = 'Call' AND activity_type = 'New Task' OR activity_type = 'Call Log'" . ' AND created_by_cid = ' . $this->companyGroupId.' AND YEAR(due_date) = YEAR(CURRENT_DATE()) AND MONTH(due_date) = MONTH(CURRENT_DATE())';
        $inProcessWhere = "activity_type = 'New Task' OR activity_type = 'Call Log'" . ' AND created_by_cid = ' . $this->companyGroupId;

        $start = isset($_GET['start']) ? $_GET['start']:'';
	    $end = isset($_GET['end']) ? $_GET['end']:'';
        if ($start != '' && $end != '') {
            $inProcessWhere = "(lead_activity.created_date >='" . $start . "' and lead_activity.created_date<='" . $end . "') and (activity_type = 'New Task' OR activity_type = 'Call Log' and created_by_cid = '" . $this->companyGroupId . "')";
            # $where = "subject = 'Call' AND activity_type = 'New Task' OR activity_type = 'Call Log'" . ' AND created_by_cid = ' . $this->companyGroupId;
        }
        if ($start != '' && $end != '' && isset($_GET['ExportType']) != '') {
           $inProcessWhere = "(lead_activity.created_date >='" . $start . "' and lead_activity.created_date<='" . $end . "') and (activity_type = 'New Task' OR activity_type = 'Call Log' and created_by_cid = '" . $this->companyGroupId . "')";
        }
        if (isset($_GET['ExportType']) && $start == '' && $end == '') {
            $inProcessWhere = "activity_type = 'New Task' OR activity_type = 'Call Log'" . ' AND created_by_cid = ' . $this->companyGroupId;

        } elseif (isset($_GET['ExportType']) && $start != '' && $end != '') {
            $inProcessWhere = "(lead_activity.created_date >='" . $start . "' and lead_activity.created_date<='" . $end . "') and (activity_type = 'New Task' OR activity_type = 'Call Log' and created_by_cid = '" . $this->companyGroupId . "')";
        }
        $this->data['lead_frm_activity'] = $this->crm_model->get_data('lead_activity', $inProcessWhere);
        $this->_render_template('activity_report/call_status_reports', $this->data);
    }
    public function add_industry() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('CRM', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Add Industries', base_url() . 'crm/add_industry');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Add Industry';
        $where = array('created_by_cid' => $this->companyGroupId);
        $this->data['industry_data'] = $this->crm_model->get_data('add_industry', $where);
        $this->_render_template('add_industry/index', $this->data);
    }
    public function edit_industry() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        # $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['customer_type'] = $this->crm_model->get_data_byId('add_industry', 'id', $this->input->post('id'));
        #pre($this->data['account']);
        $this->load->view('add_industry/edit', $this->data);
    }
    /* Customer type Edit*/
    public function saveindustryname() {
        $data = $this->input->post();
        $id = $data['id'];
        $data['industry_detl'] = implode("", $data['process_name']);
        $data['modified_date'] = date("Y-m-d h:i:sa");
        //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
        $data['created_by_cid'] = $this->companyGroupId;
        $data['created_by'] = $_SESSION['loggedInUser']->u_id;
        $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 13));
        if ($id && $id != '') {
            $success = $this->crm_model->update_data('add_industry', $data, 'id', $id);
            if ($success) {
                $data['message'] = "Industry updated successfully";
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            /*pushNotification(array('subject'=> 'Customer type updated' , 'message' => 'Customer type updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Industry updated', 'message' => 'Industry id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Industry updated', 'message' => 'Industry id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                }
                logActivity('Industry Updated', 'add_industry', $id);
                $this->session->set_flashdata('message', 'Industry Updated successfully');
                redirect(base_url() . 'crm/add_industry', 'refresh');
            }
        } else {
            $counts = count($_POST['process_name']);
            //$id= $data['id'];
            $data2 = date("Y-m-d h:i:sa");
            //$data1 = $_SESSION['loggedInUser']->c_id ;
            $data1 = $this->companyGroupId;
            $data3 = $_SESSION['loggedInUser']->u_id;
            $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 13));
            $data = $this->input->post();
            $process_name_arr = array();
            $j = 0;
            while ($j < $counts) {
                $process_name_arr[$j]['industry_detl'] = $_POST['process_name'][$j];
                $process_name_arr[$j]['created_date'] = $data2;
                $process_name_arr[$j]['created_by_cid'] = $data1;
                $process_name_arr[$j]['created_by'] = $data3;
                $j++;
            }
			
			$where = array('industry_detl' => $data['process_name'][0]);
			$ChkIndustrName = $this->crm_model->get_DuplicateDATA('add_industry', $where);
			if($ChkIndustrName == 0){
				$id = $this->crm_model->insertcustomertype('add_industry', $process_name_arr);
				if ($id) {
					logActivity('Add Industry', 'add_industry', $id);
					if (!empty($usersWithViewPermissions)) {
						foreach ($usersWithViewPermissions as $userViewPermission) {
							if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
								/*pushNotification(array('subject'=> 'Type of Customer created' , 'message' => 'Type of Customer created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
								pushNotification(array('subject' => 'Industry added', 'message' => 'New industry is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
							}
						}
					}
					if ($_SESSION['loggedInUser']->role != 1) {
						pushNotification(array('subject' => 'Industry Added', 'message' => 'Industry added by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
					}
					$this->session->set_flashdata('message', 'Industry Added Successfully');
					redirect(base_url() . 'crm/add_industry', 'refresh');
				}
			}else{
				 $this->session->set_flashdata('message', 'Already Exist');
				redirect(base_url() . 'crm/add_industry', 'refresh');
				//$this->session->set_flashdata('error', 'ERROR !, Already Exist');
			}
        }
    }
    public function add_lead_source() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('CRM', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Add Leads Source', base_url() . 'crm/add_lead_source');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Add Leads Source';
        // $where = array('created_by_cid' => $this->companyGroupId);
        $where = 'created_by_cid ="'.$this->companyGroupId.'" OR created_by_cid = 0';
        $this->data['industry_data'] = $this->crm_model->get_data('add_lead_source', $where);
        # pre($this->data['industry_data']);
        $this->_render_template('add_leads_source/index', $this->data);
    }
    public function edit_lead_source() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        # $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['customer_type'] = $this->crm_model->get_data_byId('add_lead_source', 'id', $this->input->post('id'));
        #pre($this->data['account']);
        $this->load->view('add_leads_source/edit', $this->data);
    }
    public function saveleadsourcename() {
        $data = $this->input->post();
        $id = $data['id'];
        $data['leads_source_name'] = implode("", $data['process_name']);
        $data['modified_date'] = date("Y-m-d h:i:sa");
        //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
        $data['created_by_cid'] = $this->companyGroupId;
        $data['created_by'] = $_SESSION['loggedInUser']->u_id;
        $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 13));
        if ($id && $id != '') {
            $success = $this->crm_model->update_data('add_lead_source', $data, 'id', $id);
            if ($success) {
                $data['message'] = "Leads source updated successfully";
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            /*pushNotification(array('subject'=> 'Customer type updated' , 'message' => 'Customer type updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Leads source updated', 'message' => 'Leads source id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Leads source updated', 'message' => 'Leads source id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                }
                logActivity('Leads source Updated', 'add_industry', $id);
                $this->session->set_flashdata('message', 'Leads source Updated successfully');
                redirect(base_url() . 'crm/add_lead_source', 'refresh');
            }
        } else {
            $counts = count($_POST['process_name']);
            //$id= $data['id'];
            $data2 = date("Y-m-d h:i:sa");
            //$data1 = $_SESSION['loggedInUser']->c_id ;
            $data1 = $this->companyGroupId;
            $data3 = $_SESSION['loggedInUser']->u_id;
            $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 13));
            $data = $this->input->post();
            $process_name_arr = array();
            $j = 0;
            while ($j < $counts) {
                $process_name_arr[$j]['leads_source_name'] = $_POST['process_name'][$j];
                $process_name_arr[$j]['created_date'] = $data2;
                $process_name_arr[$j]['created_by_cid'] = $data1;
                $process_name_arr[$j]['created_by'] = $data3;
                $j++;
            }
            $id = $this->crm_model->insertcustomertype('add_lead_source', $process_name_arr);
            if ($id) {
                logActivity('Add Leads source', 'add_leads_source', $id);
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            /*pushNotification(array('subject'=> 'Type of Customer created' , 'message' => 'Type of Customer created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Leads source added', 'message' => 'New Leads source is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Leads source Added', 'message' => 'Leads source added by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                }
                $this->session->set_flashdata('message', 'Leads source Added Successfully');
                redirect(base_url() . 'crm/add_lead_source', 'refresh');
            }
        }
    }
    public function lead_by_industry() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('lead_report', $data, 'id', '5');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Lead by Industry', base_url() . 'crm/lead_by_ownership');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Lead by Industry';
        #$this->data['leadStatus'] = $this->crm_model->get_data('lead_status');
        #$this->data['lead_owner'] = $this->crm_model->get_data('user_detail', array("c_id" => $this->companyGroupId));
        # $where = array('save_status' => 1, 'created_by_cid' => $this->companyGroupId , 'lead_industry !=' =>0);
        #$this->data['leads'] = $this->crm_model->get_data('leads',$where);
        #pre($this->data['leads']);
        $inProcessWhere = " save_status = 1 and lead_industry != 0 and leads.created_by_cid = '" . $this->companyGroupId . "' AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";

        if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {
            $inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and save_status = 1 and lead_industry != 0 and leads.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {
            #echo "dede";
            $inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and save_status = 1 and lead_industry != 0 and leads.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
                $inProcessWhere = " save_status = 1 and lead_industry != 0 and leads.created_by_cid = '" . $this->companyGroupId . "' AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";

            } elseif (isset($_GET['ExportType']) && isset($_GET['start']) != '' && isset($_GET['end']) != '') {
               $inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and save_status = 1 and lead_industry != 0 and leads.created_by_cid = '" . $this->companyGroupId . "'";
            }

        $this->data['leads'] = $this->crm_model->get_data('leads', $inProcessWhere);
        $new_array = array();
        foreach ($this->data['leads'] as $owner) {
            $new_array[$owner['lead_industry']][] = $owner;
        }
        #pre($new_array);
        #die;
        $this->data['lead_by_owner'] = $new_array;
        $this->_render_template('leads_reports/lead_by_industry', $this->data);
    }
    public function update_lead_status() {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $this->crm_model->change_lead_status($id, $status, '');
        $data['lead_id'] = $_POST['id'];
        $data['status'] = $_POST['status'];
        $data['start_date'] = date('Y-m-d');
        $data['created_by_cid'] = $this->companyGroupId;
        if ($_POST['status'] == 5) {
            $data['end_date'] = date('Y-m-d');
        } else {
            $data['end_date'] = "0000-00-00";
        }
        $this->crm_model->insert_tbl_data('leads_status_history', $data);
        $getdata = getNameById_leads('leads_status_history', $_POST['id'], 'lead_id', $_POST['oldstatus1']);
        $this->crm_model->update_leads_history_enddates($getdata->maxid, date('Y-m-d'));
    }
    public function delete_register_opportunity($id = '') {
        if (!$id) {
            redirect('bid_management/register_opportunity', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->crm_model->delete_data('register_opportunity', 'id', $id);
        if ($result) {
            logActivity('Tender Records Deleted', 'leads', $id);
            $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 5));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Tender Record deleted', 'message' => 'Tender id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Tender deleted', 'message' => 'Lead id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
            }
            $this->session->set_flashdata('message', 'Tender Deleted Successfully');
            $result = array('msg' => 'Tender Deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/leads?tab=bid_mangment');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    public function todays_calls() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('activity_reports', $data, 'id', '3');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Todays Call Reports', base_url() . 'crm/todays_calls');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Todays Call Reports';
        #$where = array('subject' => "Call", 'created_by_cid' => $this->companyGroupId, 'due_date' => date('d-m-Y'));

		//$inProcessWhere = "(subject = 'Call' and due_date = '".date('d-m-Y')."') AND created_by_cid = ".$this->companyGroupId;
		$inProcessWhere = "(activity_type = 'New Task' and due_date = '".date('d-m-Y')."') AND created_by_cid = ".$this->companyGroupId;

           $start = isset($_GET['start']) ? date('d-m-Y',strtotime($_GET['start'])):'';
	       $end = isset($_GET['end']) ? date('d-m-Y',strtotime($_GET['end'])):'';
	       if ($start != '' && $end != '') {
	            # echo "jnjnjnjn";
	            $inProcessWhere = "(lead_activity.due_date >='" . $start . "' and lead_activity.due_date<='" . $end ."') AND (activity_type = 'New Task' and lead_activity.created_by_cid = '" . $this->companyGroupId . "')";
	        }
	        if ($start != '' && $end != '' && isset($_GET['ExportType']) != '') {
	            # echo "jnjnjnjn";
	           $inProcessWhere = "(lead_activity.due_date >='" . $start . "' and lead_activity.due_date<='" . $end ."') AND (activity_type = 'New Task' and lead_activity.created_by_cid = '" . $this->companyGroupId . "')";
	        }
	        if (isset($_GET['ExportType']) && $start == '' && $end == '') {
	            $inProcessWhere = "(subject = 'Call' and due_date = '".date('d-m-Y')."') AND created_by_cid = ".$this->companyGroupId;

	        } elseif (isset($_GET['ExportType']) && $start != '' && $end != '') {
	            $inProcessWhere = "(lead_activity.due_date >='" . $start . "' and lead_activity.due_date<='" . $end ."') AND (activity_type = 'New Task' and lead_activity.created_by_cid = '" . $this->companyGroupId . "')";
	        }

        $this->data['lead_activity'] = $this->crm_model->get_data('lead_activity', $inProcessWhere);
        #pre($this->data['lead_activity']);die;
        $new_array = array();
        foreach ($this->data['lead_activity'] as $leadactivity) {
            $new_array[$leadactivity['assigned_to']][] = $leadactivity;
        }
        $this->data['lead_frm_activity'] = $new_array;
        #  pre($this->data['lead_frm_activity']);
        # die;
        $this->_render_template('activity_report/todays_leads', $this->data);
    }
    public function sale_report() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Sale Reports', base_url() . 'crm/activity_report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Sale Reports';
        $this->data['sales_reports'] = $this->crm_model->get_data('sale_reports');
        #pre($this->data['lead_reports']);
        $this->_render_template('sale_reports/index', $this->data);
    }
    public function sale_orders_by_accounts() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('sale_reports', $data, 'id', '3');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Sale order by Accounts', base_url() . 'crm/sale_orders_by_accounts');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Sale order by Accounts';
         #$inProcessWhere = array('created_by_cid' => $this->companyGroupId, 'save_status' => '1');

         $inProcessWhere = " save_status = 1 and sale_order.created_by_cid = '" . $this->companyGroupId . "' AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";


        if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "sale_order.created_date >='" . $_GET['start'] . "' and sale_order.created_date<='" . $_GET['end'] . "' and save_status = 1 and sale_order.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "sale_order.created_date >='" . $_GET['start'] . "' and sale_order.created_date<='" . $_GET['end'] . "' and save_status = 1 and sale_order.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
             $inProcessWhere = " save_status = 1 and sale_order.created_by_cid = '" . $this->companyGroupId . "' AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";

        } elseif (isset($_GET['ExportType']) && isset($_GET['start']) != '' && isset($_GET['end']) != '') {
             $inProcessWhere = "sale_order.created_date >='" . $_GET['start'] . "' and sale_order.created_date<='" . $_GET['end'] . "' and save_status = 1 and sale_order.created_by_cid = '" . $this->companyGroupId . "'";
        }
          $this->data['sale_orders'] = $this->crm_model->get_data('sale_order', $inProcessWhere);
        $new_array = array();
        foreach ($this->data['sale_orders'] as $leadactivity) {
            $new_array[$leadactivity['account_id']][] = $leadactivity;
        }
        $this->data['saleorder'] = $new_array;

        $this->_render_template('sale_reports/sale_orders_by_accounts', $this->data);
    }

    public function sale_orders_and_owners() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('sale_reports', $data, 'id', '1');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Sale order by Owners', base_url() . 'crm/sale_orders_and_owners');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Sale order by Owners';
         $inProcessWhere = " save_status = 1 and sale_order.created_by_cid = '" . $this->companyGroupId . "' AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";


        if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "sale_order.created_date >='" . $_GET['start'] . "' and sale_order.created_date<='" . $_GET['end'] . "' and save_status = 1 and sale_order.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "sale_order.created_date >='" . $_GET['start'] . "' and sale_order.created_date<='" . $_GET['end'] . "' and save_status = 1 and sale_order.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
             $inProcessWhere = " save_status = 1 and sale_order.created_by_cid = '" . $this->companyGroupId . "' AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";

        } elseif (isset($_GET['ExportType']) && isset($_GET['start']) != '' && isset($_GET['end']) != '') {
             $inProcessWhere = "sale_order.created_date >='" . $_GET['start'] . "' and sale_order.created_date<='" . $_GET['end'] . "' and save_status = 1 and sale_order.created_by_cid = '" . $this->companyGroupId . "'";
        }
          $this->data['sale_orders'] = $this->crm_model->get_data('sale_order', $inProcessWhere);
        $new_array = array();
        foreach ($this->data['sale_orders'] as $leadactivity) {
            $new_array[$leadactivity['created_by']][] = $leadactivity;
        }
        $this->data['saleorder'] = $new_array;
        # pre($this->data['saleorder']);
        #die;
        $this->_render_template('sale_reports/sale_orders_and_owners', $this->data);
    }
    public function account_contact_report() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Accounts & Contacts Reports', base_url() . 'crm/account_contact_report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Accounts & Contacts Reports';
        $this->data['account_reports'] = $this->crm_model->get_data('accounts_company_reports');
        //pre($this->data['account_reports']);die;
        $this->_render_template('account_contact_report/index', $this->data);
    }
    public function contact_mailing_report() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('accounts_company_reports', $data, 'id', '1');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Contact Mailing Report', base_url() . 'crm/sale_orders_and_owners');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Contact Mailing Report';
       # $where = array('contact_owner' => $this->companyGroupId, 'save_status' => '1');

       # $inProcessWhere = array('contact_owner' => $this->companyGroupId, 'save_status' => '1');

         $inProcessWhere = " save_status = 1 and contacts.contact_owner = '" . $this->companyGroupId . "' AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";

        if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "(contacts.created_date >='" . $_GET['start'] . "' and contacts.created_date<='" . $_GET['end'] . "') and (save_status = 1 and contacts.contact_owner = '" . $this->companyGroupId . "')";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "(contacts.created_date >='" . $_GET['start'] . "' and contacts.created_date<='" . $_GET['end'] . "') and (save_status = 1 and contacts.contact_owner = '" . $this->companyGroupId . "')";
        }
        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {

            $inProcessWhere = " save_status = 1 and contacts.contact_owner = '" . $this->companyGroupId . "' AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";

        } elseif (isset($_GET['ExportType']) && isset($_GET['start']) != '' && isset($_GET['end']) != '') {
             $inProcessWhere = "(contacts.created_date >='" . $_GET['start'] . "' and contacts.created_date<='" . $_GET['end'] . "') and (save_status = 1 and contacts.contact_owner = '" . $this->companyGroupId . "')";
        }

        $this->data['contacts'] = $this->crm_model->get_data('contacts', $inProcessWhere);

        $new_array = array();
        foreach ($this->data['contacts'] as $leadactivity) {
            $new_array[$leadactivity['account_id']][] = $leadactivity;
        }
        $this->data['contactsgrp'] = $new_array;
        $this->_render_template('account_contact_report/contact_mailing', $this->data);
    }
    public function account_by_industry() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('accounts_company_reports', $data, 'id', '2');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Companies list by Industry', base_url() . 'crm/account_by_industry');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Companies list by Industry';

            $inProcessWhere = " save_status = 1 and industry != 0 and account.account_owner = '" . $this->companyGroupId . "' AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "(account.created_date >='" . $_GET['start'] . "' and account.created_date<='" . $_GET['end'] . "') and (save_status = 1 and industry != 0) and account.account_owner = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {
            # echo "jnjnjnjn";
            $inProcessWhere = "(account.created_date >='" . $_GET['start'] . "' and account.created_date<='" . $_GET['end'] . "') and (save_status = 1 and industry != 0) and account.account_owner = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
              $inProcessWhere = " save_status = 1 and industry != 0 and account.account_owner = '" . $this->companyGroupId . "' AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";

        } elseif (isset($_GET['ExportType']) && isset($_GET['start']) != '' && isset($_GET['end']) != '') {
              $inProcessWhere = "(account.created_date >='" . $_GET['start'] . "' and account.created_date<='" . $_GET['end'] . "') and (save_status = 1 and industry != 0) and account.account_owner = '" . $this->companyGroupId . "'";
        }

        $this->data['account'] = $this->crm_model->get_data('account', $inProcessWhere);

        $new_array = array();
        foreach ($this->data['account'] as $leadactivity) {
            $new_array[$leadactivity['industry']][] = $leadactivity;
        }
        $this->data['contactsgrp'] = $new_array;


        $this->_render_template('account_contact_report/account_by_industry', $this->data);
    }
    public function key_accounts() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('accounts_company_reports', $data, 'id', '2');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Key Leads', base_url() . 'crm/key_accounts');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Key Leads';


        $inProcessWhere = "YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE()) AND save_status = 1 AND created_by_cid = '" . $this->companyGroupId . "' ORDER BY grand_total DESC LIMIT 10";

        if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {

            $inProcessWhere = "(leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "') and save_status = 1 and leads.created_by_cid = '" . $this->companyGroupId . "' ORDER BY grand_total DESC LIMIT 10";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {

           $inProcessWhere = "(leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "') and save_status = 1 and leads.created_by_cid = '" . $this->companyGroupId . "' ORDER BY grand_total DESC LIMIT 10";
        }
        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
             $inProcessWhere = "YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE()) AND save_status = 1 AND created_by_cid = '" . $this->companyGroupId . "' ORDER BY grand_total DESC LIMIT 10";
        } elseif (isset($_GET['ExportType']) && isset($_GET['start']) != '' && isset($_GET['end']) != '') {
              $inProcessWhere = "(leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "') and save_status = 1 and leads.created_by_cid = '" . $this->companyGroupId . "' ORDER BY grand_total DESC LIMIT 10";
        }

          $this->data['key_leads'] = $this->crm_model->get_data('leads', $inProcessWhere);

        $this->_render_template('account_contact_report/key_leads', $this->data);
    }
    public function invoice_report() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Invoices Reports', base_url() . 'crm/invoice_report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Invoices Reports';
        $this->data['invoice_report'] = $this->crm_model->get_data('invoice_report');
        //pre($this->data['account_reports']);die;
        $this->_render_template('invoice_report/index', $this->data);
    }
    public function invoice_by_party() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('invoice_report', $data, 'id', '2');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Invoices by Party', base_url() . 'crm/invoice_by_party');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Invoices by Party';
        $inProcessWhere = "save_status = 1 AND created_by_cid = '" . $this->companyGroupId . "'AND YEAR(date_time_of_invoice_issue) = YEAR(CURRENT_DATE()) AND MONTH(date_time_of_invoice_issue) = MONTH(CURRENT_DATE())";


        if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {

            $inProcessWhere = "(invoice.date_time_of_invoice_issue >='" . $_GET['start'] . "' and invoice.date_time_of_invoice_issue<='" . $_GET['end'] . "') and save_status = 1 and invoice.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {

           $inProcessWhere = "(invoice.date_time_of_invoice_issue >='" . $_GET['start'] . "' and invoice.date_time_of_invoice_issue<='" . $_GET['end'] . "') and save_status = 1 and invoice.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
             $inProcessWhere = "save_status = 1 AND created_by_cid = '" . $this->companyGroupId . "'AND YEAR(date_time_of_invoice_issue) = YEAR(CURRENT_DATE()) AND MONTH(date_time_of_invoice_issue) = MONTH(CURRENT_DATE())";

        } elseif (isset($_GET['ExportType']) && isset($_GET['start']) != '' && isset($_GET['end']) != '') {
              $inProcessWhere = "(invoice.date_time_of_invoice_issue >='" . $_GET['start'] . "' and invoice.date_time_of_invoice_issue<='" . $_GET['end'] . "') and save_status = 1 and invoice.created_by_cid = '" . $this->companyGroupId . "'";
        }

        $this->data['invoices'] = $this->crm_model->get_data('invoice', $inProcessWhere);
        $new_array = array();
        foreach ($this->data['invoices'] as $leadactivity) {
            $new_array[$leadactivity['party_name']][] = $leadactivity;
        }
        $this->data['invoices11'] = $new_array;
        $this->_render_template('invoice_report/invoice_by_party', $this->data);
    }
    public function invoice_by_status() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('invoice_report', $data, 'id', '1');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Invoces by Status', base_url() . 'crm/invoice_by_status');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Invoices by Status';
        $inProcessWhere = "save_status = 1 AND created_by_cid = '" . $this->companyGroupId . "'AND YEAR(date_time_of_invoice_issue) = YEAR(CURRENT_DATE()) AND MONTH(date_time_of_invoice_issue) = MONTH(CURRENT_DATE())";


        if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {

            $inProcessWhere = "(invoice.date_time_of_invoice_issue >='" . $_GET['start'] . "' and invoice.date_time_of_invoice_issue<='" . $_GET['end'] . "') and save_status = 1 and invoice.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {

           $inProcessWhere = "(invoice.date_time_of_invoice_issue >='" . $_GET['start'] . "' and invoice.date_time_of_invoice_issue<='" . $_GET['end'] . "') and save_status = 1 and invoice.created_by_cid = '" . $this->companyGroupId . "'";
        }
        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
             $inProcessWhere = "save_status = 1 AND created_by_cid = '" . $this->companyGroupId . "'AND YEAR(date_time_of_invoice_issue) = YEAR(CURRENT_DATE()) AND MONTH(date_time_of_invoice_issue) = MONTH(CURRENT_DATE())";

        } elseif (isset($_GET['ExportType']) && isset($_GET['start']) != '' && isset($_GET['end']) != '') {
              $inProcessWhere = "(invoice.date_time_of_invoice_issue >='" . $_GET['start'] . "' and invoice.date_time_of_invoice_issue<='" . $_GET['end'] . "') and save_status = 1 and invoice.created_by_cid = '" . $this->companyGroupId . "'";
        }

        $this->data['invoices'] = $this->crm_model->get_data('invoice', $inProcessWhere);
        $new_array = array();
        foreach ($this->data['invoices'] as $leadactivity) {
            $new_array[$leadactivity['pay_or_not']][] = $leadactivity;
        }
        $this->data['invoices11'] = $new_array;
        $this->_render_template('invoice_report/invoice_by_status', $this->data);
    }
    public function sale_metrics_report() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Sale Metrics Reports', base_url() . 'crm/sale_metrics_report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Sale Metrics Reports';
        $this->data['sale_metrics'] = $this->crm_model->get_data('sale_metrics_report');
        //pre($this->data['account_reports']);die;
        $this->_render_template('sale_metrics_report/index', $this->data);
    }
    public function sale_cycle_deal_across_owners() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('sale_metrics_report', $data, 'id', '1');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Sale Cycle Deals across Owners', base_url() . 'crm/sale_cycle_deal_across_owners');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Average time taken for Potentials won, by Owner Deals';
        $where = "status = 5 AND end_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()" . ' AND created_by_cid = ' . $this->companyGroupId;

        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
             $where = "status = 5 AND end_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()" . ' AND created_by_cid = ' . $this->companyGroupId;

        }
        $uu = array();
        $i = 0;
        #$where = array('created_by_cid' => $this->companyGroupId, '');
        $this->data['led_dt'] = $this->crm_model->get_data('leads_status_history', $where);
        # pre($this->data['led_dt']);die;
        foreach ($this->data['led_dt'] as $tyty) {
            #$where2 = 'id = '.$tyty['lead_id'];
            $uu[$i] = getNameById('leads', $tyty['lead_id'], 'id');
            # $this->data['led_dt'] = $this->crm_model->get_data('leads',$where2);
            $i++;
        }
        $new_array = array();
        foreach ($uu as $leadactivity) {
            $new_array[$leadactivity->lead_owner][] = $leadactivity;
        }
        #pre($new_array);
        $this->data['invoices11'] = $new_array;
        # pre($this->data['invoices11']);
        # die;
        $this->_render_template('sale_metrics_report/sale_cycle_deal_across_owners', $this->data);
    }
    public function leads_conversions_counts_across_owners() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('sale_metrics_report', $data, 'id', '2');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Leads Conversion Counts across Owners', base_url() . 'crm/leads_conversions_counts_across_owners');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Total Number of leads converted by the past 6 months, by all owners';
        $where = "status = 5 AND end_date > curdate() - interval (dayofmonth(curdate()) - 1) day - interval 6 month" . ' AND created_by_cid = ' . $this->companyGroupId;
        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
             $where = "status = 5 AND end_date > curdate() - interval (dayofmonth(curdate()) - 1) day - interval 6 month" . ' AND created_by_cid = ' . $this->companyGroupId;
        }
        $uu = array();
        $i = 0;
        $this->data['led_dt'] = $this->crm_model->get_data('leads_status_history', $where);
        foreach ($this->data['led_dt'] as $tyty) {
            $uu[$i] = getNameById('leads', $tyty['lead_id'], 'id');
            $i++;
        }
        $new_array = array();
        foreach ($uu as $leadactivity) {
            $new_array[$leadactivity->lead_owner][] = $leadactivity;
        }
        $this->data['invoices11'] = $new_array;
        $this->_render_template('sale_metrics_report/leads_conversions_counts_across_owners', $this->data);
    }
    public function lead_conversion_across_owners() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('sale_metrics_report', $data, 'id', '3');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Lead Conversion across Owners', base_url() . 'crm/lead_conversion_across_owners');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Average Leads conversion time for the past 6 months, by owners';
        // select * from leads_status_history where end_date > curdate() - interval (dayofmonth(curdate()) - 1) day - interval 6 month
        $where = "status = 5 AND end_date > curdate() - interval (dayofmonth(curdate()) - 1) day - interval 6 month" . ' AND created_by_cid = ' . $this->companyGroupId;
        $uu = array();
        $i = 0;
       if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
             $where = "status = 5 AND end_date > curdate() - interval (dayofmonth(curdate()) - 1) day - interval 6 month" . ' AND created_by_cid = ' . $this->companyGroupId;

        }
        $this->data['led_dt'] = $this->crm_model->get_data('leads_status_history', $where);
        foreach ($this->data['led_dt'] as $tyty) {
            $uu[$i] = getNameById('leads', $tyty['lead_id'], 'id');
            $i++;
        }
        $new_array = array();
        foreach ($uu as $leadactivity) {
            $new_array[$leadactivity->lead_owner][] = $leadactivity;
        }
        $this->data['invoices11'] = $new_array;
        $this->_render_template('sale_metrics_report/lead_conversion_across_owners', $this->data);
    }
    public function overall_sales_duration_across_leads_sources() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('sale_metrics_report', $data, 'id', '5');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Overall Sales Duration Across Leads Sources', base_url() . 'crm/overall_sales_duration_across_leads_sources');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Average Number of Days taken for the Lead to be converted to Deal from various Leads Sources
		';

        $where = "status = 5 AND end_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()" . ' AND created_by_cid = ' . $this->companyGroupId;

        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
            $where = "status = 5 AND end_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()" . ' AND created_by_cid = ' . $this->companyGroupId;
        }

        $uu = array();
        $i = 0;
        $this->data['led_dt'] = $this->crm_model->get_data('leads_status_history', $where);
        foreach ($this->data['led_dt'] as $tyty) {
            $uu[$i] = getNameById('leads', $tyty['lead_id'], 'id');
            $i++;
        }
        $new_array = array();
        foreach ($uu as $leadactivity) {
            $new_array[$leadactivity->lead_source][] = $leadactivity;
        }
        $this->data['invoices11'] = $new_array;
        $this->_render_template('sale_metrics_report/overall_sales_duration_across_leads_sources', $this->data);
    }
    public function Sales_Cycle_Duration_across_Leads_Source() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('sale_metrics_report', $data, 'id', '7');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Sales Cycle Duration across Leads Source', base_url() . 'crm/Sales_Cycle_Duration_across_Leads_Source');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Average time taken for the deal to be won, by Leads Source';

        $where = "status = 5 AND end_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()" . ' AND created_by_cid = ' . $this->companyGroupId;

        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
             $where = "status = 5 AND end_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()" . ' AND created_by_cid = ' . $this->companyGroupId;
        }

        $uu = array();
        $i = 0;

        $this->data['led_dt'] = $this->crm_model->get_data('leads_status_history', $where);

        foreach ($this->data['led_dt'] as $tyty) {

            $uu[$i] = getNameById('leads', $tyty['lead_id'], 'id');
            $i++;
        }
        $new_array = array();
        foreach ($uu as $leadactivity) {
            $new_array[$leadactivity->lead_source][] = $leadactivity;
        }

        $this->data['invoices11'] = $new_array;

        $this->_render_template('sale_metrics_report/Sales_Cycle_Duration_across_Leads_Source', $this->data);
    }
    public function Leads_conversion_Across_Sources() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('sale_metrics_report', $data, 'id', '8');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Leads conversion Across Sources', base_url() . 'crm/Leads_conversion_Across_Sources');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Average time taken for the leads to be converted in the past 6 months, by Source';
        $where = "status = 5 AND end_date > curdate() - interval (dayofmonth(curdate()) - 1) day - interval 6 month" . ' AND created_by_cid = ' . $this->companyGroupId;
        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
             $where = "status = 5 AND end_date > curdate() - interval (dayofmonth(curdate()) - 1) day - interval 6 month" . ' AND created_by_cid = ' . $this->companyGroupId;

        }
        $uu = array();
        $i = 0;
        $this->data['led_dt'] = $this->crm_model->get_data('leads_status_history', $where);
        foreach ($this->data['led_dt'] as $tyty) {
            $uu[$i] = getNameById('leads', $tyty['lead_id'], 'id');
            $i++;
        }
        $new_array = array();
        foreach ($uu as $leadactivity) {
            $new_array[$leadactivity->lead_source][] = $leadactivity;
        }
        $this->data['invoices11'] = $new_array;
        $this->_render_template('sale_metrics_report/Leads_conversion_Across_Sources', $this->data);
    }
    public function Leads_Conversion_Across_Industries() {
        $data = array('created_date' => date('Y/m/d H:i:s'));
        $this->crm_model->update_data('sale_metrics_report', $data, 'id', '9');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Leads Conversion Across Industries', base_url() . 'crm/Leads_Conversion_Across_Industries');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Average time taken for the lead to be converted for the past 6 months, by industry';
        $where = "status = 5 AND end_date > curdate() - interval (dayofmonth(curdate()) - 1) day - interval 6 month" . ' AND created_by_cid = ' . $this->companyGroupId;

        if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {
             $where = "status = 5 AND end_date > curdate() - interval (dayofmonth(curdate()) - 1) day - interval 6 month" . ' AND created_by_cid = ' . $this->companyGroupId;

        }
        $uu = array();
        $i = 0;
        $this->data['led_dt'] = $this->crm_model->get_data('leads_status_history', $where);
        foreach ($this->data['led_dt'] as $tyty) {
            $uu[$i] = getNameById('leads', $tyty['lead_id'], 'id');
            $i++;
        }
        $new_array = array();
        foreach ($uu as $leadactivity) {
            $new_array[$leadactivity->lead_industry][] = $leadactivity;
        }
        $this->data['invoices11'] = $new_array;
        $this->_render_template('sale_metrics_report/Leads_Conversion_Across_Industries', $this->data);
    }
    /* Controller End */


    public function importprice() {
        if (!empty($_FILES['uploadFile']['name']) != '') {
            $path = 'assets/modules/crm/uploads/';
            require_once APPPATH . "/third_party/PHPExcel.php";
            $config['upload_path'] = $path;
            $config['allowed_types'] = "csv|xls|xlsx";
            $config['remove_spaces'] = true;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if (empty($error)) {
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
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true, true);
                    $flag = true;
                    $i = 0;
                    $r = 0;
                    #pre($allDataInSheet);
                    #die;
                    foreach ($allDataInSheet as $value) {
                       # pre($value);
                        if ($flag) {
                             $flag = false;
                            continue;
                        }
                        if(!empty($value['A']) || !empty($value['B']) || !empty($value['C']) || !empty($value['D']) || !empty($value['E']) || !empty($value['F']))
                        {
                        	#pre($value);
                        $tyu = getNameById('types_of_customer', !empty($value['B']) ? $value['B'] : '', 'type_of_customer');
                             $insertdata[$i]['product_sku'] = !empty($value['A']) ? $value['A'] : '';
                             $insertdata[$i]['customer_type'] = !empty($tyu) ? $tyu->id : '';
                             $insertdata[$i]['selling_price'] = !empty($value['C']) ? $value['C'] : '';
                             $insertdata[$i]['cost_price'] = !empty($value['D']) ? $value['D'] : '';
                             $insertdata[$i]['mou_price'] = !empty($value['E']) ? $value['E'] : '';
                             $insertdata[$i]['mrp_price'] = !empty($value['F']) ? $value['F'] : '';
                             $insertdata[$i]['from_date'] = !empty($_POST['from_date']) ? $_POST['from_date'] : '';
                             $insertdata[$i]['to_date'] = !empty($_POST['to_date']) ? $_POST['to_date'] : '';
                             $insertdata[$i]['created_by'] = $_SESSION['loggedInUser']->u_id;
                             $insertdata[$i]['created_by_cid'] = $this->companyGroupId;
                            #pre($insertdata[$i]['contacts'])    ;
                            $i++;
                        }
                    }

                    foreach($insertdata as $frt){
                    	$where = "product_sku = '".$frt['product_sku']."' AND customer_type = '".$frt['customer_type']."'";
                    	 $getdt = $this->crm_model->get_data('import_price_list',$where);
                    }

                    #pre($getdt);
                    #die;

                    foreach($getdt as $rrtgh){

                        pre($rrtgh);
                    }

                    #
                    $result = $this->crm_model->import_price_list($insertdata);
                    if ($result) {
                        //echo "Imported successfully";
                        // die();

                    } else {
                        echo "ERROR !";
                    }
                }
                catch(Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                }
            } else {
                echo $error['error'];
            }
            die;
            $this->session->set_flashdata('message', 'Price Imported Successfully');
            redirect(base_url() . 'crm/price_list', 'refresh');
        }
        echo "<script>alert('Please Select the File to Upload')</script>";
        redirect(base_url() . 'crm/price_upload', 'refresh');
    }


    public function price_list(){
    $this->data['can_edit'] = edit_permissions();
    $this->data['can_delete'] = delete_permissions();
    $this->data['can_add'] = add_permissions();
    $this->data['can_view'] = view_permissions();
    $this->breadcrumb->add('CRM', base_url() . 'crm/dashboard');
    $this->breadcrumb->add('Price List', base_url() . 'crm/price_upload');
    $this->settings['breadcrumbs'] = $this->breadcrumb->output();
    $this->settings['pageTitle'] = 'Price List';
    //$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id);
    #$where = array('created_by_cid' =>$this->companyGroupId , 'AND active_inactive = 1');
    #$this->data['customerType']= $this->crm_model->get_data('types_of_customer',$where);
    $bb = "'";
    $cc = "'";
    if(!empty($_POST['pro_sku']) || !empty($_POST['customer_type'])){

        $where = "product_sku = '".$_POST['pro_sku']."' OR customer_type ='".$_POST['customer_type']."' AND created_by_cid ='".$this->companyGroupId."'";

    }else{
       $where = "created_by_cid ='".$this->companyGroupId."'";
    }

    $this->data['price_list'] = $this->crm_model->get_data('import_price_list',$where);
    #pre($this->data['price_list']);
    // $where = array('created_by_cid' => $this->companyGroupId);

    // $this->data['finish_goods']= $this->crm_model->get_data('finish_goods',$where);
    $this->_render_template('price_list/index', $this->data);

    }


    public function getCustomerDataById() {
        if ($_POST['id'] != '') {
              $account = $this->crm_model->get_data_byId('account', 'id', $_POST['id']);
              $city = getNameById('city', $account->billing_city, 'city_id');
              $state = getNameById('state', $account->billing_state, 'state_id');
              $country = getNameById('country', $account->billing_country, 'country_id');
              $account->state = $state->state_name;
              $account->city  = $city->city_name;
              $account->country = $country->country_name;
            	echo json_encode($account);
            	#pre($account);
        }
    }

	 public function get_mat_status_price_list(){
       # pre($_POST);
        $ww = getNameById('material', $_POST['id'], 'id');
        $customer_type = getNameById('account', $_POST['selected_customer'], 'id');
        $date = date('Y-m-d');
        $where ="to_date <= '".$date."' and import_price_list.created_by_cid = '" . $_POST['login_user'] . "'and customer_type = '".$customer_type->type."'and mat_code = '".$ww->material_code."'";
        $itemdata = $this->crm_model->get_data('import_price_list',$where);
      //  pre($itemdata);
        if(!empty($itemdata)){
            $data['msg'] = 'true';
        }else{
            $data['msg'] = 'false';
        }
        echo json_encode($data);
    }



	 public function get_mat_price_list(){
        if ($_POST['id'] != ''){
             $ww = getNameById('material', $_POST['id'], 'id');
            $customer_type = getNameById('account', $_POST['selected_customer'], 'id');
            $date = date('Y-m-d');
            $where ="to_date >= '".$date."' and import_price_list.created_by_cid = '" . $_POST['login_user'] . "'and customer_type ='".$customer_type->type."'and mat_code = '".$ww->material_code."'";
            $itemdata = $this->crm_model->get_data('import_price_list',$where);
            if(!empty($itemdata)){
                foreach($itemdata as $wqa ){
                    $rt = getNameById('uom', $ww->uom, 'id');
                    $wqa['gst'] = !empty($ww->tax)? $ww->tax: '';
                    $wqa['uom'] =  !empty($rt->ugc_code)?$rt->ugc_code: '' ;
                    $wqa['uomid'] = !empty($ww->uom)? $ww->uom:'';
                    $wqa['price'] = $wqa['selling_price'];
                }
                echo json_encode($wqa);
            }
        }
    }




	/* import functionly */

    public function importCompanies() {
        error_reporting(0);
        if (!empty($_FILES['uploadFile']['name']) != '') {
            $path = 'assets/modules/crm/excel_for_contacts/';
            require_once APPPATH . "/third_party/PHPExcel.php";
            $config['upload_path'] = $path;
            $config['allowed_types'] = "csv|xls|xlsx";
            $config['remove_spaces'] = true;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if (empty($error)) {
                if (!empty($data['upload_data']['file_name'])) {
                    $import_xls_file = $data['upload_data']['file_name'];
                } else {
                    $import_xls_file = 0;
                }
                $inputFileName = $path . $import_xls_file;
                //$tt = 'assets/modules/crm/excel_for_contacts/'.$data['uploadFile']['name'];
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    //echo count($allDataInSheet);die();
                    $flag = true;
                    $i = 0;
                    //pre($allDataInSheet);
                    foreach ($allDataInSheet as $value) {
                        if ($flag) {
                            $flag = false;
                            continue;
                        }

                        if(  empty($value['A']) && empty($value['B']) && empty($value['C']) && empty($value['D']) ){
                            continue;
                        }

                        $insertdata[$i]['name'] = !empty($value['A']) ? $value['A'] : '';
                        $insertdata[$i]['phone'] = !empty($value['B']) ? $value['B'] : 0;
                        $insertdata[$i]['email'] = !empty($value['C']) ? $value['C'] : '';
                        $insertdata[$i]['gstin'] = !empty($value['D']) ? $value['D'] : 0;
                        $insertdata[$i]['created_by'] = !empty($value['E']) ? $value['E'] : $_SESSION['loggedInUser']->u_id;
                        $insertdata[$i]['edited_by'] = !empty($value['F']) ? $value['F'] : 0;
                        $insertdata[$i]['account_owner'] = $this->companyGroupId;
                        $i++;
                    }
                   // pre($insertdata);
                   // die();
                    $result = $this->crm_model->importCompanies($insertdata); //die();
                    if ($result) {
                        //echo "Imported successfully";
                        // die();

                    } else {
                        echo "ERROR !";
                    }
                }
                catch(Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                }
            } else {
                echo $error['error'];
            }
            $this->session->set_flashdata('message', 'Companies Imported Successfully');
            redirect(base_url() . 'crm/accounts', 'refresh');
        }
        echo "<script>alert('Please Select the File to Upload')</script>";
        redirect(base_url() . 'crm/accounts', 'refresh');
    }



	   public function delivery_setting() {
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status = (isset($_POST['crm_del_s']) && $_POST['crm_del_s'] == 1) ? '1' : '0';
        $status_data = $this->crm_model->crm_delivery($id, $status);
        echo true;
    }

	public function generalSetting(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('CRM Settings', base_url() . 'CRM Settings');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'CRM Settings';
		//$company_id = $_SESSION['loggedInUser']->c_id;
		$company_id = $this->companyGroupId;

		$this->data['update_CRM_setting']  = $this->crm_model->get_termconditions_details('company_detail','id',$this->companyGroupId);
		$this->_render_template('crm/settings/generalsetting/crmSetting', $this->data);
	}


	public function RawMaterialReportQtysaleorder(){
        $sale_order = $this->input->post('id');
        $saleOrderdata= getNameById('sale_order',$sale_order, 'id');
        $productdata=json_decode($saleOrderdata->product);
        $this->data['raw_material_report'] = $productdata;
        $this->load->view('sale_orders/raw_material_quantity', $this->data);
    }

    public function getPhoneNumber()
    {
    $account_id = $_POST['id'];
    $account_data = $this->crm_model->get_data_byId('account', 'id', $account_id);
    $data['phone'] =  $account_data->phone;
	$data['name'] =  $account_data->name;
	$data['type_of_customer'] =  $account_data->type_of_customer;
	
	echo  json_encode($data);
    }

    public function getvarientList()
    {
		  // pre($_POST);die();
    $product_id = $_POST['id'];
    $product_code = $_POST['product_code'];
    $where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id, 'status' => 1, 'product_code' => $product_id, 'non_inventry_material' => 0);
    $materials = $this->crm_model->get_data('material', $where);
    $variants = $this->crm_model->get_data_byId('material_variants', 'id', $product_id);
    $variants_data = !empty($variants->variants_data) ? json_decode($variants->variants_data, true):'';
    $variant_key = !empty($variants_data['variant_key']) ? $variants_data['variant_key']:array();
    $variantKeyCount = count($variant_key);

    $option_html = '<table  class="table table-striped table-bordered account_index">
    <thead>
    <tr>
    <th scope="col">Variant Types</th>
    <th scope="col">Variant Option</th>
    <th scope="col">Variant Option Image</th>
    </tr>
    </thead>
    <tbody>';
    $variant_option = array();
    foreach($materials as $material){
    $explodeArray = !empty($material['material_name']) ? explode('_', $material['material_name']):array(); 
	//pre($material);
    for($t=1; $t<=$variantKeyCount; $t++){
    $variant_option[] =  $explodeArray[1];
    }
    }
	//die();
    $variant_option_set = array_values(array_unique($variant_option));
    for($k=1; $k<=$variantKeyCount; $k++){
    $tableheader = !empty($variant_key[$k][0]) ? $variant_key[$k][0] : $k;
    if($k == 1){
    $click_event = 'onchange="getsecvarientList(event,this)"';
    } elseif($k == 2){
    $click_event = 'onchange="getthirdvarientList(event,this)"';
    } elseif($k == 3){
    $click_event = 'onchange="getfourvarientList(event,this)"';
    } elseif($k == 4){
    $click_event = 'onchange="getfivevarientList(event,this)"';
    } elseif($k == 5){
    $click_event = 'onchange="getsixvarientList(event,this)"';
    } else {
     $click_event = ''; 
    }
    if($k == 1){
    $class="first_optn";
    $main_class="first_row";
    }
    elseif($k == 2){
    $class="sec_optn";
    $main_class="sec_row";
    }elseif($k == 3){
    $class="third_optn";
    $main_class="third_row";
    }elseif($k == 4){
    $class="four_optn";
    $main_class="four_row";
    }elseif($k == 5){
    $class="five_optn";
    $main_class="five_row";
    }elseif($k == 6){
    $class="six_optn";
    $main_class="six_row";
    } else {
    $class= ''; 
    $main_class="";
    }
    $option_html .= '<tr>';
    $option_html .= '<td>'. ucfirst($tableheader) .'</td>';
    $option_html .= '<td><select '.$click_event.' class="form-control  dynamic '.$class.'" name="">';
    $option_html .= '<option value="">Select</option>';
    foreach ($variant_option_set as $key => $vo) {
    if($k == 1){
    $option_html .= !empty($vo) ? '<option product_code="'.$variants->temp_material_name.'" op_type="'. ucfirst($tableheader) .'" p_id="'.$product_id.'" value="'.$vo.'">'.$vo.'</option>' :'';
    }
    }     
    $option_html .= '</td>';
    $option_html .= '<td class="'.$main_class.'"></td>';
    $option_html .= '</tr>';
    }
    $option_html .= '</tbody>
    </table>';
    echo  $option_html;
    }

    public function getsecvarientList()
    {
		 // pre($_POST);
    $product_id = $_POST['pid'];
    $product_code = $_POST['product_code'];
    $sel_option = $_POST['id'];
    $op_type = $_POST['op_type'];

     // pre($product_id);
     // pre($product_code);
     // pre($sel_option);
     // pre($op_type);
	 
	 // die();
	 
    $where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id, 'status' => 1, 'product_code' => $product_id, 'non_inventry_material' => 0);
    $where2 = array('variant_type_name' => $op_type, 'option_name' => $sel_option);
    $variant_img_data = $this->crm_model->get_data('variant_options', $where2);
	
	// pre($variant_img_data);die(); 
    $img_path = $variant_img_data[0]['option_img_name'];
    $materials = $this->crm_model->get_data('material', $where);
  //  pre($materials);
    $variants = $this->crm_model->get_data_byId('material_variants', 'id', $product_id);
    $variants_data = !empty($variants->variants_data) ? json_decode($variants->variants_data, true):'';
    $variant_key = !empty($variants_data['variant_key']) ? $variants_data['variant_key']:array();
    $variantKeyCount = count($variant_key);

    $variant_option = array();
    foreach($materials as $material){
		$explodeArray = !empty($material['material_name']) ? explode('_', $material['material_name']):array(); 
		
		if(count($explodeArray) >= 3){
			for($t=1; $t<=$variantKeyCount; $t++){
				if($explodeArray[1] == $sel_option){
					$variant_option[] =  $explodeArray[2];
				}
			}
		}
    }
	//pre($variant_option);

    $variant_option_set = array_values(array_unique($variant_option));
	
	
	//die();
    $option_html ="";
    for($k=1; $k<=$variantKeyCount; $k++){
    $tableheader = !empty($variant_key['2'][0]) ? $variant_key['2'][0] : $k;
    if($k == 1){
    $option_html .= '<option value="">Select</option>';
    }
	 // pre($variant_option_set);
    foreach ($variant_option_set as $key => $vo) {
		// pre($vo);
    if($k == 1){
		
    $option_html .= !empty($vo) ? '<option product_code="'.$product_code.'" op_type="'. ucfirst($tableheader) .'" c_id="'.$sel_option.'" p_id="'.$product_id.'" value="'.$vo.'">'.$vo.'</option>' :'';
    }
    }     
    }
	
    $data['html'] = $option_html;

   // $mat_name = $product_code.'_'.$sel_option;
     $mat_name = $product_code.'_'.$sel_option.'_'.$vo;
    // $mat_name = $product_code;
	   // pre($product_code);
	   // pre($sel_option);
	$mat_name = trim($mat_name);
	   // pre($mat_name);
	  
	    // die();
    $mat_details = getNameById('material', $mat_name, 'material_name');
    // $mat_details = getNameById('material', $product_id, 'id');
	 // pre($mat_details); 
	 
	 // die('asdf');
	
    if(!empty($mat_details)){
    $mat_id = $mat_details->id;
    $mat_sales_price = $mat_details->sales_price;
    $mat_tax = $mat_details->tax;
    $standard_packing = $mat_details->standard_packing;
    $uom = $mat_details->uom;
    $uom_detail =  getNameById('uom', $uom,'id');
	// pre($uom_detail);die();
    $mat_uom = $uom_detail->ugc_code;    
    $attachments = $this->crm_model->get_image_by_materialId('attachments', 'rel_id', $mat_id);
    if(!empty($attachments)){
    $data['main_img_path'] = base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'];
    } else {
    $data['main_img_path'] = base_url().'assets/modules/crm/uploads/no_image.jpg';    
    }
    $data['mat_sales_price'] = $mat_sales_price;
    $data['mat_tax'] = $mat_tax;
    $data['standard_packing'] = $standard_packing;
    $data['mat_uom'] = $mat_uom;
    $data['uomid'] = $uom;
    $data['mat_id'] = $mat_id;
    } 
    if(!empty($mat_details->packing_data)){
    $packing_data = json_decode($mat_details->packing_data);
    $standard_packing = $mat_details->standard_packing;
    $cbf = $weight = 0;
	//pre($packing_data); die;
    foreach ($packing_data as $key => $packing_value) {
    $packing_qty = $packing_value->packing_qty;
    $packing_cbf = $packing_value->packing_cbf;
    $packing_weight = $packing_value->packing_weight;
    $cbf += (float)$packing_cbf*(int)$packing_qty;
    $weight += (float)$packing_weight*(int)$packing_qty;
    }
    if ($cbf > 0 && $standard_packing > 0 ){
    $total_cbf = round($cbf/$standard_packing, 2);    
    } else {
    $total_cbf = 0;    
    }
    if ($weight > 0 && $standard_packing > 0 ){
    $total_weight = round($weight/$standard_packing, 2);    
    } else {
    $total_weight = 0;    
    }
    } else {
    $total_cbf = $total_weight = 0;
    }
    $data['total_cbf'] = $total_cbf;
    $data['total_weight'] = $total_weight;
    $data['mat_name'] = $mat_name;
    $data['mat_sales_price'] = $mat_details->sales_price;
    if(!empty($img_path)){
    $data['img_path'] = base_url().'assets/modules/inventory/varient_opt_img/'.$img_path;
    } else {
    $data['img_path'] = base_url().'assets/modules/crm/uploads/no_image.jpg';    
    }
    echo  json_encode($data);
    }
    
    public function getthirdvarientList()
    {
    $product_id = $_POST['pid'];
    $product_code = $_POST['product_code'];
    $sel_option = $_POST['id'];
    $c_option = $_POST['c_id'];
    $op_type = $_POST['op_type'];
    $where2 = array('variant_type_name' => $op_type, 'option_name' => $sel_option);
    $variant_img_data = $this->crm_model->get_data('variant_options', $where2);
    $img_path = $variant_img_data[0]['option_img_name'];
    $where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id, 'status' => 1, 'product_code' => $product_id, 'non_inventry_material' => 0);
    $materials = $this->crm_model->get_data('material', $where);
	
    $variants = $this->crm_model->get_data_byId('material_variants', 'id', $product_id);
    $variants_data = !empty($variants->variants_data) ? json_decode($variants->variants_data, true):'';
    $variant_key = !empty($variants_data['variant_key']) ? $variants_data['variant_key']:array();
    $variantKeyCount = count($variant_key);

    $variant_option = array();
    foreach($materials as $material){
    $explodeArray = !empty($material['material_name']) ? explode('_', $material['material_name']):array();
    if(count($explodeArray) >= 4){ 
    for($t=1; $t<=$variantKeyCount; $t++){
    if($explodeArray[1] == $c_option && $explodeArray[2] == $sel_option){
    $variant_option[] =  $explodeArray[3];
    }
    }
    }
    }
    $variant_option_set = array_values(array_unique($variant_option));
    $option_html ="";
    for($k=1; $k<=$variantKeyCount; $k++){
    $tableheader = !empty($variant_key['3'][0]) ? $variant_key['3'][0] : $k;
    if($k == 1){
    $option_html .= '<option value="">Select</option>';
    }
    foreach ($variant_option_set as $key => $vo) {
    if($k == 1){
    $option_html .= !empty($vo) ? '<option product_code="'.$product_code.'" op_type="'. ucfirst($tableheader) .'"  f_id="'.$c_option.'" s_id="'.$sel_option.'" p_id="'.$product_id.'" value="'.$vo.'">'.$vo.'</option>' :'';
    }
    }     
    }
    $data['html'] = $option_html;
    $mat_name = $product_code.'_'.$c_option.'_'.$sel_option;
    $mat_details = getNameById('material', $mat_name, 'material_name');
	// $mat_details = getNameById('material', $product_id, 'id');
    if(!empty($mat_details)){
    $mat_id = $mat_details->id;
    $mat_sales_price = $mat_details->sales_price;
    $mat_tax = $mat_details->tax;
    $uom = $mat_details->uom;
	$standard_packing = $mat_details->standard_packing;
	
    $uom_detail =  getNameById('uom', $uom,'id');
    $mat_uom = $uom_detail->ugc_code;
    $attachments = $this->crm_model->get_image_by_materialId('attachments', 'rel_id', $mat_id);
    if(!empty($attachments)){
    $data['main_img_path'] = base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'];
    } else {
    $data['main_img_path'] = base_url().'assets/modules/crm/uploads/no_image.jpg';    
    }
    $data['mat_sales_price'] = $mat_sales_price;
    $data['mat_tax'] = $mat_tax;
    $data['mat_uom'] = $mat_uom;
	$data['uomid'] = $uom;
    $data['mat_id'] = $mat_id;
    $data['standard_packing'] = $standard_packing;
        
    }    
    if(!empty($mat_details->packing_data)){
    $packing_data = json_decode($mat_details->packing_data);
    $standard_packing = $mat_details->standard_packing;
    $cbf = $weight = 0;
    foreach ($packing_data as $key => $packing_value) {
		//
    $packing_qty = $packing_value->packing_qty;
    $packing_cbf = $packing_value->packing_cbf;
    $packing_weight = $packing_value->packing_weight;
    $cbf += (float)$packing_cbf*(float)$packing_qty;
    $weight += (float)$packing_weight*(float)$packing_qty;
	}

    if ($cbf > 0 && $standard_packing > 0 ){
		$total_cbf = round($cbf/$standard_packing, 2);    
    } else {
		$total_cbf = 0;    
    }
    if ($weight > 0 && $standard_packing > 0 ){
    $total_weight = round($weight/$standard_packing, 2);    
    } else {
    $total_weight = 0;    
    }
    } else {
    $total_cbf = $total_weight = 0;
    }
    $data['total_cbf'] = $total_cbf;
    $data['total_weight'] = $total_weight;
    $data['mat_name'] = $mat_name;
    if(!empty($img_path)){
    $data['img_path'] = base_url().'assets/modules/inventory/varient_opt_img/'.$img_path;
    } else {
    $data['img_path'] = base_url().'assets/modules/crm/uploads/no_image.jpg';    
    }
    echo  json_encode($data);
    }

    public function getfourvarientList()
    {
    $product_id = $_POST['pid'];
    $product_code = $_POST['product_code'];
    $sel_option = $_POST['id'];
    $f_option = $_POST['f_id'];
    $s_option = $_POST['s_id'];
    $op_type = $_POST['op_type'];
    $where2 = array('variant_type_name' => $op_type, 'option_name' => $sel_option);
    $variant_img_data = $this->crm_model->get_data('variant_options', $where2);
    $img_path = $variant_img_data[0]['option_img_name'];
    $where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id, 'status' => 1, 'product_code' => $product_id, 'non_inventry_material' => 0);
    $materials = $this->crm_model->get_data('material', $where);
    $variants = $this->crm_model->get_data_byId('material_variants', 'id', $product_id);
    $variants_data = !empty($variants->variants_data) ? json_decode($variants->variants_data, true):'';
    $variant_key = !empty($variants_data['variant_key']) ? $variants_data['variant_key']:array();
    $variantKeyCount = count($variant_key);

    $variant_option = array();
    foreach($materials as $material){
    $explodeArray = !empty($material['material_name']) ? explode('_', $material['material_name']):array(); 
    if(count($explodeArray) >= 5){ 
    for($t=1; $t<=$variantKeyCount; $t++){
    if($explodeArray[1] == $f_option && $explodeArray[2] == $s_option && $explodeArray[3] == $sel_option){
    $variant_option[] =  $explodeArray[4];
    }
    }
    }
    }
    $variant_option_set = array_values(array_unique($variant_option));
    $option_html ="";
    for($k=1; $k<=$variantKeyCount; $k++){
    $tableheader = !empty($variant_key['4'][0]) ? $variant_key['4'][0] : $k;
    if($k == 1){
    $option_html .= '<option value="">Select</option>';
    }
    foreach ($variant_option_set as $key => $vo) {
    if($k == 1){
    $option_html .= !empty($vo) ? '<option product_code="'.$product_code.'" op_type="'. ucfirst($tableheader) .'"  f_id="'.$f_option.'" s_id="'.$s_option.'" t_id="'.$sel_option.'" p_id="'.$product_id.'" value="'.$vo.'">'.$vo.'</option>' :'';
    }
    }     
    }
    $data['html'] = $option_html;
    $mat_name = $product_code.'_'.$f_option.'_'.$s_option.'_'.$sel_option;
    $mat_details = getNameById('material', $mat_name, 'material_name');
		// $mat_details = getNameById('material', $product_id, 'id');
	
    if(!empty($mat_details)){
    $mat_id = $mat_details->id;
    $mat_sales_price = $mat_details->sales_price;
    $mat_tax = $mat_details->tax;
    $standard_packing = $mat_details->standard_packing;
    $uom = $mat_details->uom;
    $uom_detail =  getNameById('uom', $uom,'id');
    $mat_uom = $uom_detail->ugc_code;
    $attachments = $this->crm_model->get_image_by_materialId('attachments', 'rel_id', $mat_id);
    if(!empty($attachments)){
    $data['main_img_path'] = base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'];
    } else {
    $data['main_img_path'] = base_url().'assets/modules/crm/uploads/no_image.jpg';    
    }
    $data['mat_sales_price'] = $mat_sales_price;
    $data['mat_tax'] = $mat_tax;
    $data['mat_uom'] = $mat_uom;
    $data['uomid'] = $uom;
    $data['mat_id'] = $mat_id;
    $data['standard_packing'] = $standard_packing;
    }
    if(!empty($mat_details->packing_data)){
    $packing_data = json_decode($mat_details->packing_data);
    $standard_packing = $mat_details->standard_packing;
    $cbf = $weight = 0;
    foreach ($packing_data as $key => $packing_value) {
    $packing_qty = $packing_value->packing_qty;
    $packing_cbf = $packing_value->packing_cbf;
    $packing_weight = $packing_value->packing_weight;
    $cbf += (float)$packing_cbf*(float)$packing_qty;
    $weight += (float)$packing_weight*(float)$packing_qty;
    }
    if ($cbf > 0 && $standard_packing > 0 ){
    $total_cbf = round($cbf/$standard_packing, 2);    
    } else {
    $total_cbf = 0;    
    }
    if ($weight > 0 && $standard_packing > 0 ){
    $total_weight = round($weight/$standard_packing, 2);    
    } else {
    $total_weight = 0;    
    }
    } else {
    $total_cbf = $total_weight = 0;
    }
    $data['total_cbf'] = $total_cbf;
    $data['total_weight'] = $total_weight;
    $data['mat_name'] = $mat_name;
    if(!empty($img_path)){
    $data['img_path'] = base_url().'assets/modules/inventory/varient_opt_img/'.$img_path;
    } else {
    $data['img_path'] = base_url().'assets/modules/crm/uploads/no_image.jpg';    
    }
	
	
    echo  json_encode($data);
    }

    public function getfivevarientList()
    {
    $product_id = $_POST['pid'];
    $product_code = $_POST['product_code'];
    $sel_option = $_POST['id'];
    $f_option = $_POST['f_id'];
    $s_option = $_POST['s_id'];
    $t_option = $_POST['t_id'];
    $op_type = $_POST['op_type'];
    $where2 = array('variant_type_name' => $op_type, 'option_name' => $sel_option);
    $variant_img_data = $this->crm_model->get_data('variant_options', $where2);
    $img_path = $variant_img_data[0]['option_img_name'];
    $where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id, 'status' => 1, 'product_code' => $product_id, 'non_inventry_material' => 0);
    $materials = $this->crm_model->get_data('material', $where);
    $variants = $this->crm_model->get_data_byId('material_variants', 'id', $product_id);
    $variants_data = !empty($variants->variants_data) ? json_decode($variants->variants_data, true):'';
    $variant_key = !empty($variants_data['variant_key']) ? $variants_data['variant_key']:array();
    $variantKeyCount = count($variant_key);

    $variant_option = array();
    foreach($materials as $material){
    $explodeArray = !empty($material['material_name']) ? explode('_', $material['material_name']):array(); 
    if(count($explodeArray) >= 6){ 
    for($t=1; $t<=$variantKeyCount; $t++){
    if($explodeArray[1] == $f_option && $explodeArray[2] == $s_option && $explodeArray[3] == $t_option && $explodeArray[4] == $sel_option){
    $variant_option[] =  $explodeArray[5];
    }
    }
    }
    }
    $variant_option_set = array_values(array_unique($variant_option));

    $option_html ="";
    for($k=1; $k<=$variantKeyCount; $k++){
    $tableheader = !empty($variant_key['5'][0]) ? $variant_key['5'][0] : $k;
    if($k == 1){
    $option_html .= '<option value="">Select</option>';
    }
    foreach ($variant_option_set as $key => $vo) {
    if($k == 1){
    $option_html .= !empty($vo) ? '<option product_code="'.$product_code.'" op_type="'. ucfirst($tableheader) .'"  f_id="'.$f_option.'" s_id="'.$s_option.'" t_id="'.$t_option.'" fr_id="'.$sel_option.'" p_id="'.$product_id.'" value="'.$vo.'">'.$vo.'</option>' :'';
    }
    }     
    }
    $data['html'] = $option_html;
    $mat_name = $product_code.'_'.$f_option.'_'.$s_option.'_'.$t_option.'_'.$sel_option;
    $mat_details = getNameById('material', $mat_name, 'material_name');
    // $mat_details = getNameById('material', $product_id, 'id');
    if(!empty($mat_details)){
    $mat_id = $mat_details->id;
    $mat_sales_price = $mat_details->sales_price;
    $mat_tax = $mat_details->tax;
    $uom = $mat_details->uom;
    $standard_packing = $mat_details->standard_packing;
    $uom_detail =  getNameById('uom', $uom,'id');
    $mat_uom = $uom_detail->ugc_code;
    $attachments = $this->crm_model->get_image_by_materialId('attachments', 'rel_id', $mat_id);
    if(!empty($attachments)){
    $data['main_img_path'] = base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'];
    } else {
    $data['main_img_path'] = base_url().'assets/modules/crm/uploads/no_image.jpg';    
    }
    $data['mat_sales_price'] = $mat_sales_price;
    $data['mat_tax'] = $mat_tax;
    $data['mat_uom'] = $mat_uom;
	$data['uomid'] = $uom;
    $data['mat_id'] = $mat_id;
    $data['standard_packing'] = $standard_packing;
    }
    if(!empty($mat_details->packing_data)){
    $packing_data = json_decode($mat_details->packing_data);
    $standard_packing = $mat_details->standard_packing;
    $cbf = $weight = 0;
    foreach ($packing_data as $key => $packing_value) {
    $packing_qty = $packing_value->packing_qty;
    $packing_cbf = $packing_value->packing_cbf;
    $packing_weight = $packing_value->packing_weight;
    $cbf += (float)$packing_cbf*(float)$packing_qty;
    $weight += (float)$packing_weight*(float)$packing_qty;
    }
    if ($cbf > 0 && $standard_packing > 0 ){
    $total_cbf = round($cbf/$standard_packing, 2);    
    } else {
    $total_cbf = 0;    
    }
    if ($weight > 0 && $standard_packing > 0 ){
    $total_weight = round($weight/$standard_packing, 2);    
    } else {
    $total_weight = 0;    
    }
    } else {
    $total_cbf = $total_weight = 0;
    }
    $data['total_cbf'] = $total_cbf;
    $data['total_weight'] = $total_weight;
    $data['mat_name'] = $mat_name;
    if(!empty($img_path)){
    $data['img_path'] = base_url().'assets/modules/inventory/varient_opt_img/'.$img_path;
    } else {
    $data['img_path'] = base_url().'assets/modules/crm/uploads/no_image.jpg';    
    }
    echo  json_encode($data);
    }

    public function getsixvarientList()
    {
    $product_id = $_POST['pid'];
    $product_code = $_POST['product_code'];
    $sel_option = $_POST['id'];
    $f_option = $_POST['f_id'];
    $s_option = $_POST['s_id'];
    $t_option = $_POST['t_id'];
    $fr_option = $_POST['fr_id'];
    $op_type = $_POST['op_type'];
    $where2 = array('variant_type_name' => $op_type, 'option_name' => $sel_option);
    $variant_img_data = $this->crm_model->get_data('variant_options', $where2);
    $img_path = $variant_img_data[0]['option_img_name'];
    $mat_name = $product_code.'_'.$f_option.'_'.$s_option.'_'.$t_option.'_'.$fr_option.'_'.$sel_option;
    $mat_details = getNameById('material', $mat_name, 'material_name');
    // $mat_details = getNameById('material', $product_id, 'id');
    if(!empty($mat_details)){
    $mat_id = $mat_details->id;
    $mat_sales_price = $mat_details->sales_price;
    $mat_tax = $mat_details->tax;
    $uom = $mat_details->uom;
    $standard_packing = $mat_details->standard_packing;
    $uom_detail =  getNameById('uom', $uom,'id');
    $mat_uom = $uom_detail->ugc_code;
    $attachments = $this->crm_model->get_image_by_materialId('attachments', 'rel_id', $mat_id);
    if(!empty($attachments)){
    $data['main_img_path'] = base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'];
    } else {
    $data['main_img_path'] = base_url().'assets/modules/crm/uploads/no_image.jpg';    
    }
    $data['mat_sales_price'] = $mat_sales_price;
    $data['mat_tax'] = $mat_tax;
    $data['mat_uom'] = $mat_uom;
	$data['uomid'] = $uom;
    $data['mat_id'] = $mat_id;
    $data['standard_packing'] = $standard_packing;
    }
    if(!empty($mat_details->packing_data)){
    $packing_data = json_decode($mat_details->packing_data);
    $standard_packing = $mat_details->standard_packing;
    $cbf = $weight = 0;
    foreach ($packing_data as $key => $packing_value) {
    $packing_qty = $packing_value->packing_qty;
    $packing_cbf = $packing_value->packing_cbf;
    $packing_weight = $packing_value->packing_weight;
    $cbf += (float)$packing_cbf*(float)$packing_qty;
    $weight += (float)$packing_weight*(float)$packing_qty;
    }
    if ($cbf > 0 && $standard_packing > 0 ){
    $total_cbf = round($cbf/$standard_packing, 2);    
    } else {
    $total_cbf = 0;    
    }
    if ($weight > 0 && $standard_packing > 0 ){
    $total_weight = round($weight/$standard_packing, 2);    
    } else {
    $total_weight = 0;    
    }
    } else {
    $total_cbf = $total_weight = 0;
    }
    $data['total_cbf'] = $total_cbf;
    $data['total_weight'] = $total_weight;
    $data['mat_name'] = $mat_name;
    if(!empty($img_path)){
    $data['img_path'] = base_url().'assets/modules/inventory/varient_opt_img/'.$img_path;
    } else {
    $data['img_path'] = base_url().'assets/modules/crm/uploads/no_image.jpg';    
    }
    echo  json_encode($data);
    }

    public function calcDiscount(){
		// 
		if(!empty($_POST['customerName'])){
			$calcDiscount_val = $_POST['calcDiscount_val'];
			$customerval = $_POST['customerName'];
			$account_data = $this->crm_model->get_data_byId('account', 'id', $customerval);
			//pre($account_data);die();
			$type_of_customer = $account_data->type_of_customer;
			$type_of_customer_data = $this->crm_model->get_data_byId('types_of_customer', 'id', $type_of_customer);
				echo $type_of_customer_data->$calcDiscount_val;
		}else{
			echo 0;
		}		
    }

     public function add_sales_area() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('CRM', base_url() . 'crm/dashboard');
        $this->breadcrumb->add('Add Sales Area', base_url() . 'crm/add_sales_area');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Add Sales Area';
        $where = array('created_by_cid' => $this->companyGroupId);
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $where2 = "(sales_area.sales_area like '%" . $search_string . "%' or sales_area.id like '%" . $search_string . "%')";
            redirect("crm/add_sales_area/?search=$search_string");
        } else if (isset($_GET['search'])) {
            $where2 = "(sales_area.sales_area like'%" . $_GET['search'] . "%' or sales_area.id like'%" . $_GET['search'] . "%')";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }

        $config = array();
        $config["base_url"] = base_url() . "crm/add_sales_area/";
        $config["total_rows"] = $this->crm_model->tot_rows('sales_area', $where, $where2);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $config['anchor_class'] = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['sales_area_data']=$this->crm_model->get_data1('sales_area', $where, $config["per_page"], $page, $where2, $order, $export_data);
       
        $this->_render_template('sales_area/index', $this->data);
    }

    public function edit_sales_area() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        # $this->data['users'] = $this->crm_model->get_data('user_detail');
        $this->data['sales_area_data'] = $this->crm_model->get_data_byId('sales_area', 'id', $this->input->post('id'));
        #pre($this->data['account']);
        $this->load->view('sales_area/edit', $this->data);
    }

    /* Customer type Edit*/
    public function savesalesarea() {
        $data = $this->input->post();
        //pre($_POST);die();
        $id = $data['id'];
        $data['sales_area'] = implode("",$data['process_name']);
        $data['modified_date'] = date("Y-m-d h:i:sa");
        //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
        $data['created_by_cid'] = $this->companyGroupId;
        $data['created_by'] = $_SESSION['loggedInUser']->u_id;
        $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 13));
        if ($id && $id != '') {

          #  pre($data) ;
            $success = $this->crm_model->update_data('sales_area', $data, 'id', $id);

           # die;
            if ($success) {
                $data['message'] = "Sales Area updated successfully";
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            /*pushNotification(array('subject'=> 'Customer type updated' , 'message' => 'Customer type updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Sales Area updated', 'message' => 'Sales Area id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Sales Area updated', 'message' => 'Sales Area id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                }
                logActivity('Sales Area Updated', 'sales_area', $id);
                $this->session->set_flashdata('message', 'Sales Area Updated successfully');
                redirect(base_url() . 'crm/add_sales_area', 'refresh');
            }
        } else {
            $counts = count($_POST['process_name']);
            //$id= $data['id'];
            $data2 = date("Y-m-d h:i:sa");
            //$data1 = $_SESSION['loggedInUser']->c_id ;
            $data1 = $this->companyGroupId;
            $data3 = $_SESSION['loggedInUser']->u_id;
            $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 13));
            $data = $this->input->post();
            $process_name_arr = array();
            $j = 0;
            while ($j < $counts) {
                $process_name_arr[$j]['sales_area'] = $_POST['process_name'][$j];
                $process_name_arr[$j]['created_date'] = $data2;
                $process_name_arr[$j]['created_by_cid'] = $data1;
                $process_name_arr[$j]['created_by'] = $data3;
                $j++;
            }
			
            $checkarea = $this->crm_model->area_exits($_POST['process_name'][0]);
			
        if (empty($checkarea)) {
			// pre($process_name_arr);die();
            $id = $this->crm_model->insertcustomertype('sales_area', $process_name_arr);
            if ($id) {
                logActivity('Add Sales Area', 'sales_area', $id);
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            /*pushNotification(array('subject'=> 'Type of Customer created' , 'message' => 'Type of Customer created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Sales Area added', 'message' => 'New Sales Area is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Add Sales Area Added', 'message' => 'Sales Area added by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                }
                $this->session->set_flashdata('message', 'Sales Area Added Successfully');
                redirect(base_url() . 'crm/add_sales_area', 'refresh');
            }
        }else{
                        $this->session->set_flashdata('message', 'Sales Area already exist');
                        redirect(base_url() . 'crm/add_sales_area', 'refresh');
                        die;
        }
        }
    }

     public function change_status_sales_area() {
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status = (isset($_POST['uomStatus']) && $_POST['uomStatus'] == 1) ? '1' : '0';
        $status_data = $this->crm_model->toggle_change_status_sales_area($id, $status);
        echo true;
    } 
	
	   public function change_statusleadSource() {
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
		// pre($_POST);die();
        $status = (isset($_POST['active_inactive']) && $_POST['active_inactive'] == 1) ? '1' : '0';
        $status_data = $this->crm_model->SaleAreaStatus($id, $status);
		echo true;
    }
	
	
	
	function share_pdf_using_email() {
        $share_email_address = $_REQUEST['share_email'];
        $order_id = $_REQUEST['order_id'];
        $email_message22 = $_REQUEST['email_msg_id'];
		
		$order_details = getNameById('proforma_invoice', $order_id, 'id');
		
        //$company_details = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
        $company_details = getNameById('company_detail', $this->companyGroupId, 'id');
        //$company_emails = getNameById('user',$_SESSION['loggedInUser']->c_id,'c_id');
        $company_emails = getNameById('user', $this->companyGroupId, 'c_id');
        $company_dtl = json_decode($company_details->address, true);
        $country_dtl = getNameById('country', $company_dtl[0]['country'], 'country_id');
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
                                                    <td align="center" class="masthead" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: white; background: #099a8c; margin: 0; padding: 30px 0;     border-radius: 4px 4px 0 0;" bgcolor="#099a8c"> <img src="assets/modules/crm/uploads/alfalogo.jpg" alt="logo" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; max-width: 20%; display: block; margin: 0 auto; padding: 0;" /></td>
                                                </tr>';
        $footer = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
                                        <td class="container" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">
                                            <!-- Message start -->
                                            <table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
                                            <tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
                                                <td class="content footer" align="center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white none; margin: 0; padding: 30px 35px;     border-radius: 0 0 4px 4px;" bgcolor="white">
                                                    <p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center"><a href="' . base_url() . '" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: #888; text-decoration: none; font-weight: bold; margin: 0; padding: 0;">ERP</a></p>
                                                    <p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Support: ' . $company_emails->email . '</p>
                                                    <p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">' . $company_dtl[0]['address'] . ',  ' . $namddd . ' </p>
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

						<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Message ' . $email_message22 . '</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>';
        
	
        $messageContent = $header . $email_message . $footer;
        //pre($messageContent);die();
        $order_numm = 'Proforma Invoice:- ' . $order_details->order_code;
        ini_set('memory_limit', '20M');
        $this->load->library('pdf');
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle("Proforma Invocie");
        $pdf->SetHeaderData('Proforma Invocie', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
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
        $pdf->SetFont('helvetica', '', 11);
        $this->load->library('email');
        $dataPdf['dataPdf'] = $this->crm_model->get_data_byId('proforma_invoice', 'id', $order_details->id);
        //pre($dataPdf);die('dfdf');
        //$dataPdf = $this->account_model->get_data_byId('invoice','id',$invoice_details->id);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->AddPage();
        // $html = $this->load->view('purchase_order/order_pdf_email', $dataPdf, true);
		$html = $this->load->view('proforma_invoices/proforma_invoices_pdf_email', $dataPdf, true);
      //pre($html);die();
		$pdf->WriteHTML($html);
		$pdf->lastPage();
        $pdfFilePath = FCPATH . "assets/modules/account/pdf_invoice/proformaInvocie.pdf";
		ob_clean();
        $pdf->Output($pdfFilePath, "F");
		
		$this->load->library('phpmailer_lib');
		// PHPMailer object
		$monthYearail = $this->phpmailer_lib->load();
		//Server settings
		$monthYearail->SMTPDebug = 0;
		$monthYearail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true)); // Enable verbose debug output
		
		//$monthYearail->Subject = 'Email Verification';
		$monthYearail->isSMTP(); // Send using SMTP
		$monthYearail->Host = 'email-smtp.ap-south-1.amazonaws.com'; // Set the SMTP server to send through
		$monthYearail->SMTPAuth = true; // Enable SMTP authentication
		$monthYearail->Username = 'AKIAZB4WVENVZ773ONVF'; // SMTP username
		$monthYearail->Password = 'BLDqOsL9LkOKnY6n4coXRFsrXNq66C9xLDlsaCzasGEG'; // SMTP password
		$monthYearail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		$monthYearail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
		//Recipients
		$monthYearail->setFrom('dev@lastingerp.com', 'Lasting ERP');
		$monthYearail->addAddress($share_email_address, ''); // Add a recipient
		// Content
		$monthYearail->isHTML(true);
		// Email body content
		$monthYearailContent = $messageContent;
		$monthYearail->Body = $monthYearailContent;
		// $monthYearail->attach($pdfFilePath);
		$monthYearail->addAttachment($pdfFilePath, 'Proforma Invoice');
		$monthYearail->Subject = 'Proforma Invoice';
		#$monthYearail->ClearAllRecipients();
		 // pre($monthYearail->send());die('asdfasdfasdf');
		if ($monthYearail->send()) {
            echo "sent";
            unlink($pdfFilePath);
        } else {
            echo "notsend";
        }
	}
	
	
	public function download_pdf($id = '') {
		$this->load->library('Pdf');
		$dataPdf = $this->crm_model->get_data_byId('proforma_invoice', 'id', $id);
		
		setlocale(LC_MONETARY, 'en_IN');
				$obj_pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
				$obj_pdf->SetCreator(PDF_CREATOR);  
				$obj_pdf->SetTitle("Proforma invoice");  
				$obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
				$obj_pdf->SetDefaultMonospacedFont('helvetica');  
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
				$obj_pdf->setPrintHeader(false);  
				$obj_pdf->setPrintFooter(false);  
				$obj_pdf->SetAutoPageBreak(TRUE, 10);  
				$obj_pdf->SetFont('helvetica', '', 11);
				//$obj_pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				$company_data = getNameById('company_detail',$dataPdf->created_by_cid,'id');
				$bank_info = json_decode($company_data->bank_details);
				$primarybnk  = $bank_info[0];

				$image = base_url().'assets/modules/crm/uploads/alfalogo.jpg';
				$obj_pdf->Image($image,2,4,10,10,'PNG');
				$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
				$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
				$obj_pdf->AddPage(); 	
				$content = ''; 
				$ci =& get_instance();
				if($company_data->address != ''){
						$companyAddress = json_decode($company_data->address);
						$companyAddress = 'Address: '.$companyAddress[0]->address.', Country: '.getNameById('country',$companyAddress[0]->country,'country_id')->country_name.', State: '.getNameById('state',$companyAddress[0]->state,'state_id')->state_name.', City: '.getNameById('city',$companyAddress[0]->city,'city_id')->city_name.', Pincode: '.$companyAddress[0]->postal_zipcode;
					}else{
						$companyAddress = '';
					}


					$accountData = getNameById('account',$dataPdf->account_id,'id');
					$contactData = getNameById('contacts',$dataPdf->contact_id,'id');	  
					$products =  json_decode($dataPdf->product);
					$max_val_chk = array();
					foreach($products as $product){
					$matData = getNameById('material', $product->product, 'id');
					$mat_name = $matData->material_name;
					$chunks = explode('_', $mat_name);
					$max_val_chk[] = count($chunks);	
					}
					$discount_offered = json_decode($dataPdf->discount_offered);
					$discount_offeredHtml = '';
					if(!empty($discount_offered)){
						foreach($discount_offered as $do){
							$discount_offeredHtml .=$do.',';	
						}	
							$discount_offeredHtml = substr_replace($discount_offeredHtml ,"", -1);
					}	
					$dispatch_documents = json_decode($dataPdf->dispatch_documents);
					$dispatch_documentsHtml = '';
					if(!empty($dispatch_documents)){
					foreach($dispatch_documents as $dd){
						$dispatch_documentsHtml .=$dd.',';	
					}	
						$dispatch_documentsHtml = substr_replace($dispatch_documentsHtml ,"", -1);
					}
					
					

				// Start Proforma Invoice number
				$last_id = getLastTableId('proforma_invoice');
				$rId = $last_id + 110;
				$piCode = 'PIR_' . rand(1, 1000000) . '_' . $rId;
				/************** Revised Purchase order generation ******************/
				$currentRevisedPIChar = 'A';
				$nextRevisedPIChar = chr(ord($currentRevisedPIChar) + 1);
				$revisedPOCode = '';
				$revisedPICode = '';
				if ($dataPdf && $dataPdf->save_status == 1) {
					if($dataPdf->pi_code == ''){
						echo " ";
					}else{
						$pi_code_array = explode('_', $dataPdf->pi_code, 4);
				//pre($pi_code_array);
				//	foreach ($pi_code_array as $key => $value) {
				//	echo "pi_code_array[".$key."] = ".$value."<br>";
				//	}
				// pre();

						// if($pi_code_array[2] == ''){
						if(count($pi_code_array) < 3){
							$currentRevisedPIChar = 'A';
							#$nextRevisedPOChar = chr(ord($currentRevisedPOChar) + 1);
							$revisedPICode = $dataPdf->pi_code.'_'.$currentRevisedPIChar.'(Revised)';
						}else if($pi_code_array[2] != ''){
							#echo $po_code_array[2];
							$orignalOrderCode = $pi_code_array[0].'_'.$pi_code_array[1].'_'.$pi_code_array[2];
							$currentRevisedPIChar = explode('(', $pi_code_array[2], 1);
							$nextRevisedPIChar = chr(ord($currentRevisedPIChar[0]) + 1);
							$revisedPICode = $orignalOrderCode.'_'.$nextRevisedPIChar.'(Revised)';
						}
					}
				}
				// echo $piCode;
				// die;
				// End Proforma Invoice number

				// Get terms and conditions
				$termsAndCondition = $ci->crm_model->get_data('termscond');
				// pre($termsAndCondition);die();
				// Get Variant Images
				$variantTypes =	$ci->crm_model->get_data('variant_types');
				$variantImages = $ci->crm_model->get_data('variant_options');
				$variantImages = $ci->crm_model->get_data('material_variants');
				$packing_data1 = 0;
				$matIDD = 0;
				foreach($variantImages as $mages ){
				if(!empty(json_decode($mages['packing_data']))){
				$packing_data = json_decode($mages['packing_data']);
				foreach($packing_data as $pp){
				$packing_data1 .= $pp->packing_mat;
				if(!empty($packing_data1)){
				$matIDD = $mages['id'];
				}
				}
				}
				}

				#echo $packing_data1;
				$accountdata = getNameById('account',$dataPdf->account_id,'id');
				$BuyerType = getNameById('types_of_customer',$accountdata->type_of_customer,'id');
				$billingdata = json_decode($accountdata->new_billing_address);  

				// pre($billingdata);
				// die();
				$content = '<table style="width: 100%;font-size: 10px;font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;color: #555;  border-spacing: 0;" border="1" cellpadding ="2" >

				<tr>
				<td colspan="9"><span style="font-size: 18px;margin-top: 5px;text-align:center;font-wight:bold;">'.$company_data->name.' Industries pvt ltd</span></td>
				<td border-left="0px"><img src="'.base_url().'/assets/modules/crm/uploads/alfalogo.jpg"  style="float: left;width: 80px;"></td>

				</tr>
				<tr>
				<th colspan="10">
				<strong>'.$companyAddress.'</strong>
				</th>
				</tr>
				<tr>
				<td style="text-align:center;">DATE</td>
				<td style="text-align:center;">'.$dataPdf->order_date.'</td>
				<td colspan="4" style="text-align:center;">Proforma invoice</td>
				<td style="text-align:center;">Expected Delivery Date</td>
				<td style="text-align:center;">'.date("d-m-Y", strtotime($dataPdf->dispatch_date)).'</td>
				<td>PI NO:</td>
				<td>'.$dataPdf->pi_code.'</td>
				</tr>
				<tr>
				<td colspan="4">TO</td>

				<th colspan="6">Bank Details</th>
				</tr>
				<tr>
				<td colspan="4">Buyer Name: '.$accountdata->name.'<br>
				Phone Number : '.$accountdata->phone.'<br>
				Address : '.$billingdata[0]->billing_street_1.'<br>
				State : '.$billingdata[0]->state_name.'<br>
				City : '.$billingdata[0]->city_name.'<br>
				Zipcode : '.$billingdata[0]->billing_zipcode_1.'</td>

				<td colspan="6" >Account Name: '.$company_data->name.'<br>
				Bank Name : '.$primarybnk->account_no.'<br>
				Account Number: '.$primarybnk->account_no.'<br>
				IFSC Code: '.$primarybnk->account_ifsc_code.'<br>
				Branch Name: '.$primarybnk->branch.'
				</td>
				</tr>
				<tr>
				<th style="vertical-align: middle; text-align: center;">SL.No</th>
				<th style="vertical-align: middle; text-align: center;">Product Code</th>
				<th style="vertical-align: middle; text-align: center;">Product Image</th>';
				$max_val_chk = array();
				foreach($products as $product){
				$matData = getNameById('material', $product->product, 'id');
				$mat_name = $matData->material_name;

				// $mat_name = $product->product;
				$chunks = explode('_', $mat_name);
				if(count($chunks) == 4){
				$colspan = '';
				} elseif(count($chunks) == 3){
				$colspan = '2';
				} elseif(count($chunks) == 2){
				$colspan = '3';
				} elseif(count($chunks) == 1){
				$colspan = '4';
				}
				$max_val_chk[] = count($chunks);	
				} 
				for ($i = 1; $i < max($max_val_chk); $i++) {
				$content .= '<th style="vertical-align: middle; text-align: center;">Variant '.$i.'</th>';
				}
				$content .= '<th style="vertical-align: middle; text-align: center;">Description</th>
				<th style="vertical-align: middle; text-align: center;">Quantity</th>';
				if($BuyerType->id !=2){
					$content .= '<th style="vertical-align: middle; text-align: center;">Box</th>';
				}
				$content .= '<th style="vertical-align: middle; text-align: center;">Price</th>
				<th colspan="'.$colspan.'"  style="vertical-align: middle; text-align: center;">Total</th>
				</tr>

				<tbody>
				';											   
				if(!empty($products)){
				$j =  1;
				$ck = $subtotal = $gst = $TotalPrdtQty = $TotalBox  = 0;
				$imagepath = '';
				foreach($products as $product){
					
				$subtotal += $product->individualTotal;
				$TotalBox += $product->box;
				$TotalPrdtQty += $product->quantity;
				$gst += $product->individualTotal*($product->gst/100);
				if(!empty($dataPdf)){
				$mat_type = json_decode($dataPdf->material_type_id);
				$material_type_id = getNameById('material_variants',$mat_type[$ck],'id');
				$materialItemCode = $material_type_id->item_code;
				$variantData = $material_type_id->variants_data;
				$variantDataValue = json_decode($variantData);
				}
				$content .=  '<tr>
				<td style="vertical-align: middle; text-align: center"><br><br><br>'.$j.'</td>
				<td style="vertical-align: middle; text-align: center"><br><br><br>'.$materialItemCode.'</td>
				<td style="vertical-align: middle; text-align: center">';

				$mat_name = $product->product;
				$mat_details = getNameById('material', $mat_name, 'id');
				$mat_id = $mat_details->id;
				$attachments = $ci->crm_model->get_image_by_materialId('attachments', 'rel_id', $product->product);

				if(!empty($attachments)){
					$content .=  '<img style="width: 50px; height: 50px;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
				}else{
					$content .=  '<img style="width: 50px; height: 50px;" src="">';
				}
				$content .= '</td>';
				 // pre($product);
				$matData = getNameById('material', $product->product, 'id');
				$mat_name = $matData->material_name;
				//$mat_name = $product->product;
				$chunks = explode('_', $mat_name);
				for ($i = 1; $i < max($max_val_chk); $i++) {
				$c =$i+1;
				if($c > count($chunks)){
				$content .= '<td style="vertical-align: middle; text-align: center"></td>';	
				} else {
				$variants = getNameById('material_variants', $chunks[0], 'temp_material_name');
				$variants_data = !empty($variants->variants_data) ? json_decode($variants->variants_data, true):'';
				$variant_key = !empty($variants_data['variant_key']) ? $variants_data['variant_key']:array();
				$variantKeyCount = count($variant_key);
				for($k=1; $k<=$variantKeyCount; $k++){
				$fieldname = $variant_key[$k][0];
				$variants = getNameById_withmulti('variant_options', $chunks[$i], 'option_name', $fieldname, 'variant_type_name');
				$variantOptionName = @$variants->option_name;
				if(!empty($variants)){
				$imagepath =  '<img style="width: 50px; height: 50px;" src="'.base_url().'/assets/modules/inventory/varient_opt_img/'.$variants->option_img_name.'">';
				$content .= '<td style="vertical-align: middle; text-align: center">'.$imagepath.'<br><span>'.$variantOptionName.'</span></td>';
				}
				}
				//echo $chunks[$i];   
					
				}

				}

					$content .= '<td style="vertical-align: middle; text-align: center"><br><br><br>'.$product->description.'</td>
					<td style="vertical-align: middle; text-align: center"><br><br><br>'.$product->quantity.'</td>';
					if($BuyerType->id != 2){
						$content .= '<td style="vertical-align: middle; text-align: center"><br><br><br>'.$product->box.'</td>';
					}
					$content .= '<td style="vertical-align: middle; text-align: center"><br><br><br>'.$product->price.'</td>
					<td colspan="'.$colspan.'"  style="vertical-align: middle; text-align: center"><br><br><br>'.$product->individualTotal.'</td>
					</tr>';
					$j++; $ck++; }
					}
					// die();
					if(!empty($dataPdf)){
		$account = getNameById('account',$dataPdf->account_id,'id');
		$type_of_customer = $account->type_of_customer;
		$type_of_customer_data = $ci->crm_model->get_data_byId('types_of_customer', 'id', $type_of_customer);
		$calcDiscount_val = $dataPdf->load_type;
		$pi_cbf = $dataPdf->pi_cbf;
		$pi_weight = $dataPdf->pi_weight;
		$pi_paymode = $dataPdf->pi_paymode;
		$pi_permitted = $dataPdf->pi_permitted;
		$special_discount = $dataPdf->special_discount;
		$freightCharges = $dataPdf->freightCharges;
		$advance_received = $dataPdf->advance_received;
		$extra_charges = $dataPdf->extra_charges;
		if(!empty($dataPdf->advance_received)){
			$advance_received = $dataPdf->advance_received;
		}else{
			$advance_received = 0;
		}
		 
			if($calcDiscount_val == 'none'){
				$discount_rate = 0;
			} else {
				$discount_rate = $type_of_customer_data->$calcDiscount_val;	
			}
		$discount_value = $subtotal*($discount_rate/100);
		$spd_value = $subtotal*($special_discount/100);
		$total = $subtotal - $discount_value - $spd_value;
		$gfc = $freightCharges*18/100;
		if($discount_value !=0){
			$AfterDiscount = $subtotal - $discount_value;
			$spd_value = $AfterDiscount*($special_discount/100);
			$total = $AfterDiscount - $spd_value;
			
			foreach($products as $getTax){
				$gst = $total*($getTax->gst/100);
				$grand_total = (float)$total+(float)$gst+(float)$freightCharges+(float)$gfc;
			}
			
			
		}
		
		$grand_total = $total+$gst+$freightCharges+$gfc;
		$remain_balance = $grand_total-$advance_received;
		$remain_balance = (int)$remain_balance + (int)$extra_charges;
	}
					
					

				$content .= '
				

				<tr>												
				<td colspan="7" rowspan="12">
				<table style="width:100%;"><tr>												
							<td style="border-bottom:1px solid #000;">Total Qty.</td>
							<td style="text-align: right;border-right:1px solid #000;border-bottom:1px solid #000;">'.$TotalPrdtQty.'</td>
							<td style="border-bottom:1px solid #000;">Total Box</td>
							<td style="text-align:right;border-bottom:1px solid #000;">'.$TotalBox.'</td></tr>';
					if($BuyerType->id !=2){
						$content .= ' <tr>
							<td>CBF </td>
							<td style="border-right:1px solid #000;text-align:right;">'.$pi_cbf.'</td>
							<td>Weight </td>
							<td style="text-align:right;">'.$pi_weight.'</td>
						   </tr>';
					}
					
				$content .= '<tr>
								<td  style="border-top:1px solid #000;" colspan="4">TERMS & CONDITION</td>
							</tr>
				</table>
				'.$termsAndCondition[0]['content'].'
				</td>
				<td colspan="2">Sub Total</td>
				<td colspan="1" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>   '.money_format('%!i',$subtotal).'</td>

				</tr>
				<tr>
				<td colspan="2" >Discount ('. $discount_rate .')</td>
				<td colspan="1" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  '.money_format('%!i',$discount_value).'</td>
				</tr>
				<tr>												
				<td colspan="2">Special Discount  </td>
				<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  '.money_format('%!i',$spd_value).'</td>
				</tr>
				<tr>												
				<td colspan="2">Total  </td>
				<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  '.money_format('%!i',$total).'</td>
				</tr>
				<tr>												
				<td colspan="2">Tax</td>
				<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  '.money_format('%!i',$gst).'</td>
				</tr>
				<tr>												
				<td colspan="2">Freight</td>
				<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  '.money_format('%!i',$freightCharges).'</td>
				</tr>
				<tr>												

				<td colspan="2">GST on the Freight</td>
				<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  '.money_format('%!i',$gfc).'</td>
				</tr>
				<tr>												

				<td colspan="2">TCS</td>
				<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>   0.00</td>
				</tr>
				<tr>												
				<td colspan="2">Grand Total</td>
				<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  '.money_format('%!i',$grand_total).'</td>
				</tr>
				<tr>												

				<td colspan="2">Advance</td>
				<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  '.money_format('%!i',$advance_received).'</td>
				</tr>
				<tr>												

				<td colspan="2">Extra charges</td>
				<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  '.money_format('%!i',$extra_charges).'</td>
				</tr>
				
				<tr>												

				<td colspan="2">Balance</td>
				<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  '.money_format('%!i',round($remain_balance)).'</td>
				</tr>
				
				<tr>												
				<td colspan="7">Thanking You,</td>
				<td colspan="3">For '.$company_data->name.' <br><br>Note:This is an electronic quote. Signature not requiers.</td>

				</tr>

				</tbody>	
				<!--
				<table border="1" cellpadding="2">
				<tr><td colspan="9"><h2 align="center" style="margin: 5px 0px;">Sale Order</h2></td></tr>
				<tr>
				<td colspan="3"><strong>Our Ref.</strong> &nbsp; '.$dataPdf->id.'<br> <strong>Dated</strong> &nbsp; '.date("j F , Y", strtotime($dataPdf->created_date)).'</td>
				<td colspan="6"><strong>Party Ref.</strong> &nbsp; '.$dataPdf->party_ref.'<br> <strong>Dated</strong> &nbsp;  '.date("j F , Y", strtotime($dataPdf->created_date)).'</td>
				</tr>		
				<tr>
				<td colspan="3">
				<strong>Consigner Address:</strong> <br>'.$company_data->name.'  <br> '.$companyAddress.'
				<br><strong>Phone :</strong> '.$company_data->phone.'<br><strong>GSTIN :</strong> '.$company_data->gstin.'<br>
				</td>
				<td colspan="6">
				<strong>Consignee Name:</strong><br>'.json_decode($accountData->new_billing_address)[0]->billing_company_1.'<br><strong>Address:</strong> '.json_decode($accountData->new_billing_address)[0]->billing_street_1.'<br><strong>City:</strong>  '.getNameById('city',json_decode($accountData->new_billing_address)[0]->billing_city_1,'city_id')->city_name.'<br><strong>Zipcode:</strong>  '.json_decode($accountData->new_billing_address)[0]->billing_zipcode_1.'<br><strong>State:</strong>  '.getNameById('state',json_decode($accountData->new_billing_address)[0]->billing_state_1,'state_id')->state_name.'<br><strong>Country:</strong>  '.getNameById('country',json_decode($accountData->new_billing_address)[0]->billing_country_1,'country_id')->country_name.' <br><strong>Email :</strong> '.$accountData->email.'
				<br><strong>Phone :</strong> '.json_decode($accountData->new_billing_address)[0]->billing_phone_addrs.'<br><strong>GSTIN :</strong> '.json_decode($accountData->new_billing_address)[0]->billing_gstin_1.'<br>
				</td>
				</tr>
				<tr>
				<th width="30px"><strong>S No.</strong></th>
				<th width="110px"><strong>Material <br>Description</strong></th>
				<th width="30px"><strong>QTY</strong></th>
				<th><strong>UOM</strong></th>
				<th><strong>Unit Price(Rs)</strong></th>
				<th width="30px"><strong>Tax Rate(%)</strong></th>
				<th><strong>Net <br>Amt.(Rs)</strong></th>
				<th><strong>Tax Amt.(Rs)</strong></th>
				<th width="83px"><strong>Total Amt.</strong></th>
				</tr>';
				$i = 0;
				foreach($products as $product){	
				$i++;
				// $material_id = $product->product;	
				$materialName = getNameById('material',$product->product,'id');					
				$matName = $materialName->material_name;
				$ww =  getNameById('uom', $product->uom,'id');
				$uom = !empty($ww)?$ww->ugc_code:'';
				$total_tax =  $product->individualTotal*$product->gst/100;
				$total_tax = floor($total_tax*100)/100;

				$content .= '<tr>
				<td>'.$i.'</td>
				<td><h5>'.$matName.'</h5><br>'.(array_key_exists("description",$product)?$product->description:'').'</td>
				<td>'.$product->quantity.'</td>
				<td>'.$uom.'</td>
				<td>'.$product->price.'</td>
				<td>'.$product->gst.'</td>
				<td>'.$product->individualTotal.'</td>
				<td>'.$total_tax.'</td>
				<td>'.$product->individualTotalWithGst.'</td>
				</tr>';
				}			
				$content .= '
				<tr>
				<td colspan="8" align="right"><strong>Total Amount </strong> </td>
				<td>Rs. '. $dataPdf->total.'</td>
				</tr>';
				if (!empty($dataPdf->agt)) {
				$content .=  
				'<tr>
				<td colspan="8" align="right">Other Taxes </td>
				<td>Rs. '. $dataPdf->agt.'</td>
				</tr>';
				}
				if (!empty($dataPdf->freightCharges)) {
				$content .=  
				' <tr>
				<td colspan="8" align="right">Freight Charges </td>
				<td>Rs.'. $dataPdf->freightCharges.'</td>
				</tr>';
				}
				if ($dataPdf->grandTotal) {
				$overAllTotal=$dataPdf->grandTotal+(float)$dataPdf->freightCharges??'';
				$content .=  
				'<tr>
				<td colspan="8" align="right"><strong>Grand Total</strong> </td>
				<td>Rs. '. $overAllTotal.'</td>
				</tr>';
				}
				if (!empty($dataPdf->advance_received)) {
				$content .=  
				'<tr>
				<td colspan="8" align="right"> Advance Received  </td>
				<td>Rs. '. $dataPdf->advance_received.'</td>
				</tr>';
				}
				if (!empty($overAllTotal)) {
				$overallremoveAdvamt=$overAllTotal-$dataPdf->advance_received;
				$content .=  
				'<tr>
				<td colspan="8" align="right"><strong>Total Payable Amount </strong> </td>
				<td>Rs. '. $overallremoveAdvamt.'</td>
				</tr>';
				}

				$content .=  
				'<tr>
				<td colspan="9"><strong>Guarantee/ Returnable Special Notes:</strong><br>'.$dataPdf->guarantee.'</td>
				</tr>		
				<tr>
				<td colspan="3">
				<strong>A/c Name:</strong> '.$company_data->account_name.' <br><strong>A/c No:</strong>  '.$company_data->account_no.' <br><strong>IFSC:</strong>  '.$company_data->account_ifsc_code.' 
				</td>
				<td colspan="6">
				<strong>Our Banker Address: </strong> <br> <strong>Bank :</strong>  '.$company_data->bank_name.' <br> <strong>Branch :</strong>  '.$company_data->branch.' 
				</td>
				</tr> 
				<tr>
				<th colspan="2"><strong>Dispatch Date</strong></th>  
				<th colspan="4"><strong>Payment Terms</strong></th> 
				<th colspan="4"><strong>Discount Offered</strong></th>
				</tr>
				<tr>
				<td colspan="2">'.date("j F , Y", strtotime($dataPdf->dispatch_date)).'</td>  
				<td colspan="4">'.$dataPdf->payment_terms.'</td> 
				<td colspan="4">'.$discount_offeredHtml.'</td>
				</tr>';
				$content .=  
				'<tr>
				<td colspan="4"><strong>Documents Dispatched : </strong> &nbsp; '.$dispatch_documentsHtml.'</td>
				<td colspan="5"><strong>Product Applications : </strong> &nbsp; '.$dataPdf->product_application.' </td>
				</tr>		
				<tr>
				<td colspan="4"><strong>Label Printing Express : </strong> &nbsp; '.$dataPdf->label_printing_express.'</td>
				<td colspan="5"><strong>Brand Label : </strong> &nbsp; '.$dataPdf->brand_label.' </td>
				</tr>
				<tr>
				<td colspan="9">For '.$company_data->name.' <br><br><br><br><br><br>(Authorized Signatory)</td>
				</tr>-->';  
				$content .= '</table>';  

				// echo $content;
				 // die();
				$obj_pdf->setPageOrientation('L');
				$obj_pdf->writeHTML($content);  
				ob_end_clean();	
				$rand_num = rand(5000000, 1500000);
				$filename = "Proforma_Invoice".$rand_num."" . ".pdf";
				// $obj_pdf->Output(FCPATH . 'assets/POUpload/'.$filename, 'F');
				$obj_pdf->Output($filename, 'D'); 
				//$pdfFilePath = FCPATH . 'assets/POUpload/'.$filename;
				$pdfFilePath = base_url() . 'assets/POUpload/'.$filename;
				$this->session->set_flashdata('message', 'Proforma Invoice Pdf Downloaded Successfully');
				redirect(base_url() . 'crm/proforma_invoice', 'refresh');
			}
	
	
	
	public function gstvalidation(){
		$gstnumber = $_REQUEST['GSTNO'];
		$token = $this->getAccessToken();
		  // pre($token);die();
		$url = "https://commonapi.mastersindia.co/commonapis/searchgstin?gstin=".$gstnumber;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$headers = array(
		   "Accept: application/json",
		   "client_id: GppguvaahNlTnZcgvl",
		   "Authorization: Bearer 3612940526d7044eab24073f34f4f9fa04c192bc",
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$resp = curl_exec($curl);
		
		$datajson = json_decode($resp);
		// curl_close($curl);
		if($datajson->data->tradeNam != ''){
			echo $reponse = $datajson->data->tradeNam;
		}else{
			echo $reponse = "Invalid GSTNO";
		}
		
		
	}
	
	
	public function getAccessToken(){
		$postData = array(
			'username' 		=> $this->config->item('bill_username'),
			'password' 		=> $this->config->item('bill_password'),
			'client_id' 	=> $this->config->item('bill_client_id'),
			'client_secret' => $this->config->item('bill_client_secret'),
			'grant_type' 	=> $this->config->item('bill_grant_type'),
		);
		$data_string = json_encode($postData);
		$ch = curl_init('https://clientbasic.mastersindia.co/oauth/access_token');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
		);
		$result = curl_exec($ch);
		curl_close($ch);
		$decodedResult = json_decode($result);
		if(!empty($decodedResult->access_token) ){
			$token = $decodedResult->access_token;
			return $token;
		} else {
			return false;
		}

	}
	
	
	
	
	

}//main
