<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class production extends ERP_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->library(array(
            'form_validation'
        ));
        $this->load->helper('production/production');
        $this->load->model('production_model');
         $this->load->model('inventory/inventory_model');
         $this->load->model('purchase/purchase_model');
        $this->scripts['js'][]   = 'assets/modules/users/js/datatable.js';
        $this->settings['css'][] = 'assets/plugins/morris.js/morris.css';
        $this->settings['css'][] = 'assets/plugins/switchery/dist/switchery.min.css';
        $this->settings['css'][] = 'assets/plugins/iCheck/skins/flat/green.css';
        $this->settings['css'][] = 'assets/plugins/bootstrap-taginput/tagsinput/bootstrap-tagsinput.css';
        $this->settings['css'][] = 'assets/plugins/jquery-ui/jquery-ui.css';
        $this->settings['css'][] = 'assets/plugins/bootstrap-tagmanager/tagmanager.css';
        $this->settings['css'][] = 'assets/modules/production/css/style.css';
        $this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
        $this->settings['css'][] = 'assets/plugins/editable_datatable/DataTables-1.10.18/css/jquery.dataTables.min.css';
        $this->settings['css'][] = 'assets/plugins/editable_datatable/Buttons-1.5.4/css/buttons.dataTables.css';
        $this->settings['css'][] = 'assets/plugins/editable_datatable/Select-1.2.6/css/select.dataTables.css';
        $this->scripts['js'][]   = 'assets/plugins/editable_datatable/Buttons-1.5.4/js/dataTables.buttons.min.js';
        $this->scripts['js'][]   = 'assets/plugins/editable_datatable/Select-1.2.6/js/dataTables.select.js';
        $this->scripts['js'][]   = 'assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js';
        $this->scripts['js'][]   = 'assets/plugins/bootstrap-tagmanager/tagmanager.js';
        $this->scripts['js'][]   = 'assets/plugins/bootstrap-taginput/tagsinput/bootstrap-tagsinput.js';
        $this->scripts['js'][]   = 'assets/plugins/bootstrap-typehead/bootstrap3-typeahead.js';
        $this->scripts['js'][]   = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->scripts['js'][]   = 'assets/plugins/Chart.js/dist/Chart.min.js';
        $this->scripts['js'][]   = 'assets/plugins/raphael/raphael.min.js';
        $this->scripts['js'][]   = 'assets/plugins/morris.js/morris.min.js';
        $this->scripts['js'][]   = 'assets/plugins/echarts/dist/echarts.min.js';
        $this->scripts['js'][]   = 'assets/plugins/switchery/dist/switchery.min.js';
        $this->scripts['js'][]   = 'assets/plugins/iCheck/icheck.min.js';
        $this->scripts['js'][]   = 'assets/plugins/jquery-ui/jquery-ui.js';
        $this->scripts['js'][]   = 'assets/plugins/autosize/dist/autosize.js';
        $this->scripts['js'][]   = 'assets/modules/production/js/script.js';
        $this->scripts['js'][]   = 'assets/plugins/daypilot/daypilot-all.min.js';
        $this->companyId         = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
        // error_reporting(E_ALL ^ (E_WARNING));
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $CI =& get_instance();
        $CI->createTableColumn('reserved_material','saleorder_product',"INT(11) NULL  AFTER job_card_id");
    }

     public function createTableColumn($table,$column,$defineColumType){
        $ci =& get_instance();
        $dynamicdb = $ci->load->database('dynamicdb', TRUE);
        $dataChild = $dynamicdb->query("SHOW COLUMNS FROM  {$table} LIKE '{$column}'")->row_array();
        if( empty($dataChild) ){
            $dynamicdb->query("ALTER TABLE {$table}  ADD {$column} {$defineColumType}");
        }

        $data = $ci->db->query("SHOW COLUMNS FROM  {$table} LIKE '{$column}'")->row_array();
        if( empty($data) ){
            $ci->db->query("ALTER TABLE {$table}  ADD {$column} {$defineColumType}");
        }
    }



    /**************************************process****************************************************/
    public function index()
    {
        //pre("testing");die;
        $this->settings['module_title'] = 'Users';
        $this->data['can_edit']         = edit_permissions();
        $this->data['can_delete']       = delete_permissions();
        $this->data['can_add']          = add_permissions();
        $this->data['can_view']         = view_permissions();
        $this->breadcrumb->add('Process', base_url() . 'process');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Process';
        $array                         = array();
        #$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id);
        #$companyId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
        $where                         = array(
            'created_by_cid' => $this->companyId
        );

        $this->data['processType'] = $this->production_model->get_data('process_type', $where);
        $i                         = 0;
        foreach ($this->data['processType'] as $ProcessType) {
            $where                = array(
                'process_type_id' => $ProcessType['id']
            );
            $process              = $this->production_model->get_data('add_process', $where);
            $array[$i]['types']   = $ProcessType;
            $array[$i]['process'] = $process;
            $i++;
        }
        $this->data['processdata'] = $array;
        $this->_render_template('process/index', $this->data);
    }

    /* Index Page of process*/
    public function process()
    {
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Process', base_url() . 'process');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Process';
        $array                         = array();

        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "production/process/";
        $config["total_rows"]         = $this->production_model->num_rows('process_type', array(
            'created_by_cid' => $this->companyId
        ), '');
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page                      = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        #$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id);
        #$companyId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
        $where                     = array(
            'created_by_cid' => $this->companyId
        );
        $this->data['processType'] = $this->production_model->get_data('process_type', $where, $config["per_page"], $page);
        $i                         = 0;
        foreach ($this->data['processType'] as $ProcessType) {
            $where                = array(
                'process_type_id' => $ProcessType['id']
            );
            $process              = $this->production_model->get_data('add_process', $where, $config["per_page"], $page);
            $array[$i]['types']   = $ProcessType;
            $array[$i]['process'] = $process;
            $i++;
        }
        $this->data['processdata'] = $array;
        $this->_render_template('process/index', $this->data);
    }

    /*process type index page*/
    public function process_type()
    {
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Porcess type', base_url() . 'process_type');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Process Type';

        #$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id);
        #$companyId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
        $where                         = array(
            'created_by_cid' => $this->companyId
        );
        if(isset($_GET['search']) && $_GET['search']!=''){
        $where2='process_type.process_type LIKE "%'.$_GET['search'].'%" or process_type.id="'.$_GET['search'].'"';
        }
        $config = array();
        $config["base_url"] = base_url() . "production/process_type";
        $config["total_rows"] =$this->production_model->num_rows('process_type',$where,$where2);
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
        if(!empty($_GET['ExportType'])){
            $export_data = 1;
        }else{
            $export_data = 0;
        }
        $this->data['processType'] = $this->production_model->get_data1('process_type', $where, $config["per_page"], $page, $where2, $order,$export_data);
        $this->_render_template('process/process_type', $this->data);
    }

    /* edit process type*/
    public function processType_edit()
    {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['process_type'] = $this->production_model->get_data_byId('process_type', 'id', $id);
        $this->load->view('process/processTypeEdit', $this->data);
    }

    /*save process type */
    public function saveProcessType()
    {
        if ($this->input->post()) {
            $required_fields = array(
                'process_type'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data                     = $this->input->post();
                $id                       = $data['id'];
                #$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
                $data['created_by_cid']   = $this->companyId;
                #$data['created_by_cid'] = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
                $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 13
                ));
                if ($id && $id != '') {
                    $processType = $this->production_model->processTypeExist($_POST['process_type'], 'update');
                    if ($processType) {
                        logActivity('Cannot Update Process! Already exist', 'process_type', $id);
                        $this->session->set_flashdata('message', 'Cannot Update Process! Already exist');
                        redirect(base_url() . 'production/process_type', 'refresh');
                    } else {
                        $success = $this->production_model->update_data('process_type', $data, 'id', $id);
                        if ($success) {
                            $data['message'] = "Process type  updated successfully";
                            if (!empty($usersWithViewPermissions)) {
                                foreach ($usersWithViewPermissions as $userViewPermission) {
                                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                        pushNotification(array(
                                            'subject' => 'Process type updated',
                                            'message' => 'Process type updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '',
                                            'from_id' => $_SESSION['loggedInUser']->u_id,
                                            'to_id' => $userViewPermission['user_id'],
                                            'ref_id' => $id
                                        ));
                                    }
                                }
                            }
                            if ($_SESSION['loggedInUser']->role != 1) {
                                pushNotification(array(
                                    'subject' => 'Process type updated',
                                    'message' => 'Process type updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '',
                                    'from_id' => $_SESSION['loggedInUser']->u_id,
                                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                                    'ref_id' => $id
                                ));
                            }

                            logActivity('Process type Updated', 'process_type', $id);
                            $this->session->set_flashdata('message', 'Process type Updated successfully');
                            redirect(base_url() . 'production/process_type', 'refresh');
                        }
                    }
                } else {
                    $processType = $this->production_model->processTypeExist($_POST['process_type']);
                    if ($processType) {
                        logActivity('Process already exist ', 'process_type', $id);
                        $this->session->set_flashdata('message', 'Process already exist');
                        redirect(base_url() . 'production/process_type', 'refresh');
                    } else {
                        $id = $this->production_model->insert_tbl_data('process_type', $data);
                        if ($id) {
                            logActivity('Type of process inserted', 'process_type', $id);
                            if (!empty($usersWithViewPermissions)) {
                                foreach ($usersWithViewPermissions as $userViewPermission) {
                                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                        pushNotification(array(
                                            'subject' => 'Process type created',
                                            'message' => 'Process type created by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '',
                                            'from_id' => $_SESSION['loggedInUser']->u_id,
                                            'to_id' => $userViewPermission['user_id'],
                                            'ref_id' => $id
                                        ));
                                    }
                                }
                            }
                            if ($_SESSION['loggedInUser']->role != 1) {
                                pushNotification(array(
                                    'subject' => 'Process type created',
                                    'message' => 'Process type created by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '',
                                    'from_id' => $_SESSION['loggedInUser']->u_id,
                                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                                    'ref_id' => $id
                                ));
                            }
                            $this->session->set_flashdata('message', 'proces type inserted successfully');
                            redirect(base_url() . 'production/process', 'refresh');
                        }
                    }
                }
            }
        }
    }

    /*delete process type*/
    public function deleteProcessType($id = '')
    {
        if (!$id) {
            redirect('production/process_type', 'refresh');
        }
        $result = $this->production_model->delete_data('process_type', 'id', $id);
        if ($result) {
            logActivity('process  Deleted', 'process_type', $id);

            $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                'is_view' => 1,
                'sub_module_id' => 13
            ));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array(
                            'subject' => 'Process type deleted',
                            'message' => 'Process type deleted by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '',
                            'from_id' => $_SESSION['loggedInUser']->u_id,
                            'to_id' => $userViewPermission['user_id'],
                            'ref_id' => $id
                        ));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array(
                    'subject' => 'Process type deleted',
                    'message' => 'Process type deleted by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '',
                    'from_id' => $_SESSION['loggedInUser']->u_id,
                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                    'ref_id' => $id
                ));
            }

            $this->session->set_flashdata('message', 'process Deleted Successfully');
            $result = array(
                'msg' => 'process Deleted Successfully',
                'status' => 'success',
                'code' => 'C142',
                'url' => base_url() . 'production/process_type'
            );
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array(
                'msg' => 'error',
                'status' => 'error',
                'code' => 'C1004'
            ));
        }
    }

    /*delete process */
    public function deleteProcess($id = '')
    {
        if (!$id) {
            redirect('production/process', 'refresh');
        }
        $result = $this->production_model->delete_data('add_process', 'id', $id);
        if ($result) {
            logActivity('process  Deleted', 'process', $id);

            $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                'is_view' => 1,
                'sub_module_id' => 13
            ));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array(
                            'subject' => 'Process deleted',
                            'message' => 'Process deleted by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '',
                            'from_id' => $_SESSION['loggedInUser']->u_id,
                            'to_id' => $userViewPermission['user_id'],
                            'ref_id' => $id
                        ));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array(
                    'subject' => 'Process deleted',
                    'message' => 'Process deleted by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '',
                    'from_id' => $_SESSION['loggedInUser']->u_id,
                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                    'ref_id' => $id
                ));
            }

            $this->session->set_flashdata('message', 'process Deleted Successfully');
            $result = array(
                'msg' => 'process Deleted Successfully',
                'status' => 'success',
                'code' => 'C142',
                'url' => base_url() . 'production/process'
            );
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array(
                'msg' => 'error',
                'status' => 'error',
                'code' => 'C1004'
            ));
        }
    }
    /*process name save function
    public function saveAddProcess(){
    if ($this->input->post()) {
    $required_fields = array('process_name');
    $is_valid = validate_fields($_POST, $required_fields);
    if (count($is_valid) > 0) {
    valid_fields($is_valid);
    }
    else{
    $data  = $this->input->post();
    $id=$data['id'];
    $data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
    if($id && $id != ''){
    $success = $this->production_model->update_data('add_process',$data, 'id', $id);
    if ($success) {
    $data['message'] = "Processes updated successfully";
    logActivity('Processess Updated','add_process',$id);
    $this->session->set_flashdata('message', 'Processess Updated successfully');
    redirect(base_url().'production/process', 'refresh');
    }
    }else{
    /*$processArray = array();
    if(!empty($data['process_name'])){
    $i = 0;
    foreach($data['process_name'] as $processName){
    $processArray[$i]['id'] = $id;
    $processArray[$i]['process_type_id'] = $data['process_type_id'];
    $processArray[$i]['process_name'] = $processName;
    $processArray[$i]['created_by_cid'] = $data['created_by_cid'];
    $i++;
    }
    }

    #$id = $this->production_model->insert_tbl_data('add_process',$data);
    $id = $this->production_model->insert_multiple_data('add_process',$processArray);


    $this->session->set_flashdata('message', 'processes inserted successfully');
    redirect(base_url().'production/process', 'refresh');
    /*if ($id) {
    logActivity('processess inserted','add_process',$id);
    $this->session->set_flashdata('message', 'processes inserted successfully');
    redirect(base_url().'production/process', 'refresh');
    }
    }

    }
    }
    }*/

    /*process name save function*/
    public function saveAddProcess()
    {
        if ($this->input->post()) {
            $required_fields = array(
                'process_name'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data                     = $this->input->post();
                $id                       = $data['id'];
                $data['created_by_cid']   = $this->companyId;
                 $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 13
                ));
                if ($id && $id != '') {
                    $success = $this->production_model->update_data('add_process', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Processes updated successfully";
                        logActivity('Processess Updated', 'add_process', $id);

                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array(
                                        'subject' => 'Process updated',
                                        'message' => 'Process updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '',
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $userViewPermission['user_id'],
                                        'ref_id' => $id
                                    ));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array(
                                'subject' => 'Process created',
                                'message' => 'Process created by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '',
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'ref_id' => $id
                            ));
                        }


                        $this->session->set_flashdata('message', 'Processess Updated successfully');
                        redirect(base_url() . 'production/process', 'refresh');
                    }
                } else {
                $process_update_array = array();
                foreach ($_POST['process_name'] as $key => $process_name) {
                $process_nameExist = $this->production_model->process_nameExist('add_process', $_POST['process_type_id'], $process_name);
                if(empty($process_nameExist)){
                $process_update_array[] = $process_name;
                }
                }
                
                    $processArray  = array();
                    $process_count = count($process_update_array);
                    if ($process_count > 0 && $process_update_array[0] != '') {
                        $i = 0;
                        while ($i < $process_count) {
                            $jsonArrayObject  = array(
                                'process_name' => $process_update_array[$i],
                                'description' => $_POST['description'][$i],
                                'process_type_id' => $_POST['process_type_id'],
                                'created_by_cid' => $data['created_by_cid']
                            );
                            $processArray[$i] = $jsonArrayObject;
                            $i++;
                        }
                    }
                    $id = $this->production_model->insert_multiple_data('add_process', $processArray);
                    $this->session->set_flashdata('message', ''.$process_count.' processes inserted successfully');
                    redirect(base_url() . 'production/process', 'refresh');
                }
            }
        }
    }




    /* add process edit*/
    public function Add_Process_edit()
    {
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['processType'] = $this->production_model->get_data('process_type');
        $this->data['addProcess']  = $this->production_model->get_data('add_process');

        $this->load->view('process/index', $this->data);
    }
    /* Function to change the process group on drag */
    public function changeProcessType()
    {
        $processData = getNameById('add_process', $_POST['processId'], 'id');
        $process_nameExist = $this->production_model->process_nameExist('add_process', $_POST['processTypeId'], $processData->process_name);
        if(!empty($process_nameExist)){
        $this->session->set_flashdata('message', 'Process name already exits in this product type');
        $result = array(
        'status'=> 'success',
        'url' => 'process'
        ); 
        echo json_encode($result);
        //header('Location: '.base_url().'production/process/');
        } else {

        $data           = $this->input->post();
        $id             = $data['processId'];
        $process_status = $this->production_model->change_process_status($data, $id);
        $this->_render_template('process/index', $process_status);
        }
    }

    /*****************************************************Add machine code index****************************************/
    public function Add_machine()
    {$this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Work Station', base_url() . 'add_machine');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Work Station';
        /* if(isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!=''){
        $_SESSION['loggedInUser']->c_id = $_SESSION['companyGroupSessionId'];
        } */
         $where                    = array(
                    'add_machine.created_by_cid' => $this->companyId
                );
         if (isset($_GET['favourites'])) {
           #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'add_machine.favourite_sts' => 1);
            $where                    = array(
                'add_machine.created_by_cid' => $this->companyId,
                'add_machine.favourite_sts' => 1
            );
         }

         if( !isset($_GET['favourites'] )  ){
             //$_GET['favourites'] = '';
         }

          if ($_GET['favourites']!='' && isset($_GET["ExportType"])&& $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search']=='') {
          #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'add_machine.favourite_sts' => 1);
            $where                    = array(
                'add_machine.created_by_cid' => $this->companyId,
                'add_machine.favourite_sts' => 1
            );
         }elseif (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search']=='') {
           #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id);
                $where                    = array(
                    'add_machine.created_by_cid' => $this->companyId
                );
          }  elseif (isset($_GET["ExportType"])!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search']!='') {
                #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id);
                $where                    = array(
                    'add_machine.created_by_cid' => $this->companyId
                );
          }
           if (!empty($_GET['start']) && !empty($_GET['end'])&& isset($_GET["ExportType"])) {
                #$where = array('add_machine.created_date >=' => $_GET['start'] , 'add_machine.created_date <=' => $_GET['end'],'add_machine.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                 $where                    = array(
                    'add_machine.created_date >=' => $_GET['start'],
                    'add_machine.created_date <=' => $_GET['end'],
                    'add_machine.created_by_cid' => $this->companyId
                );//die();
           }elseif (!empty($_GET['start']) && !empty($_GET['end'])&& isset($_GET["ExportType"])=='') {
                #$where = array('add_machine.created_date >=' => $_GET['start'] , 'add_machine.created_date <=' => $_GET['end'],'add_machine.created_by_cid'=> $_SESSION['loggedInUser']->c_id);

                $where                    = array(
                    'add_machine.created_date >=' => $_GET['start'],
                    'add_machine.created_date <=' => $_GET['end'],
                    'add_machine.created_by_cid' => $this->companyId
                );
           }
        //Search
        $where2                        = '';
        $search_string                 = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $where2        = "(add_machine.machine_name like'%" . $search_string . "%' or add_machine.machine_code like'%" . $search_string . "%' or add_machine.id like'%" . $search_string . "%')";
            redirect("production/Add_machine/?search=$search_string");
        } else if (isset($_GET['search'])) {
            $where2 = "(add_machine.machine_name like'%" . $_GET['search'] . "%' or add_machine.machine_code like'%" . $_GET['search'] . "%' or add_machine.id like'%" . $_GET['search'] . "%')";
        }


        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }

        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "production/Add_machine/";
        $config["total_rows"]         = $this->production_model->num_rows('add_machine',$where, $where2);
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if(!empty($_GET['ExportType'])){
            $export_data = 1;
        }else{
            $export_data = 0;
        }

              $this->data['AddMachine'] = $this->production_model->get_data1('add_machine', $where, $config["per_page"], $page, $where2, $order,$export_data);
                $this->_render_template('Add_machine/index', $this->data);
        }
        /*if(!empty($_POST)){
        $this->load->view('Add_machine/index', $this->data);
        }else{
        $this->_render_template('Add_machine/index', $this->data);
        }*/
    public function workorder_quality_chk()
    {
        $id                      = $this->uri->segment(3);
        $data['work_order_data'] = $this->production_model->get_data_byId('work_order', 'id', $id);
        $val                     = json_decode($data['work_order_data']->product_detail, true);
        foreach ($val as $data1) {
            $data['workorder_id']   = $data['work_order_data']->id;
            $data['report_name']    = $data['work_order_data']->work_order_no;
            $data['final_report']   = 1;
            $data['saleorder']      = 'pid';
            $data['material_id']    = $data1['product'];
            $data['created_by']     = $_SESSION['loggedInUser']->id;
            $data['created_by_cid'] = $this->companyId;
            $data['created_date']   = date("Y-m-d H:i:s");
            //pre($data);die();
            $this->production_model->insert_tbl_data('controlled_report_master', $data);
        }
        $this->production_model->updateRowWhere('work_order', array(
            'id' => $id
        ), array(
            'quality_check' => 1
        ));
        $this->session->set_flashdata('message', 'Added to Quality Check successfully');
        redirect(base_url() . 'production/work_order', 'refresh');
    }
    /* production planning quality_check*/
    public function plan_quality_chk()
    {
        $id                               = $this->uri->segment(3);
        $data['production_planning_data'] = $this->production_model->get_data_byId('production_planning', 'id', $id);
        $val                              = json_decode($data['production_planning_data']->planning_data, true);
        $count                            = count($val);
        foreach ($val as $data1) {
            for ($i = 0; $i < $count; $i++) {
                if ($data1['work_order'][$i] != '') {
                    $data['workorder_id']   = $data1['work_order'][$i];
                    $data['report_name']    = $data['production_planning_data']->id;
                    $data['final_report']   = 1;
                    $job_nam                = getNameById('job_card', $data1['job_card_product_id'][$i], 'id');
                    $data['job_card']       = $job_nam->job_card_no;
                    $data['process_id']     = $data1['process_name'][$i];
                    $data['created_by']     = $_SESSION['loggedInUser']->id;
                    $data['created_by_cid'] = $this->companyId;
                    $data['created_date']   = date("Y-m-d H:i:s");
                    $this->production_model->insert_tbl_data('inspection_report_master', $data);
                    // pre($data);//die();
                }
            }
        } //die();
        //
        $this->production_model->updateRowWhere('production_planning', array(
            'id' => $id
        ), array(
            'quality_check' => 1
        ));
        $this->session->set_flashdata('message', 'Added to Quality Check successfully');
        redirect(base_url() . 'production/production_planning', 'refresh');
    }
    /* add machine edit*/
    public function Add_machine_edit()
    {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['addProcess'] = $this->production_model->get_data('add_process');
        $this->data['Addmachine'] = $this->production_model->get_data_byId('add_machine', 'id', $id);
        $this->load->view('Add_machine/edit', $this->data);
    }
    /* add machine edit New*/
    public function Add_machine_edit_new()
    {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['addProcess'] = $this->production_model->get_data('add_process');
        $this->data['Addmachine'] = $this->production_model->get_data_byId('add_machine', 'id', $id);
        $this->load->view('Add_machine/edit_new', $this->data);
    }


    /* Add , update and add similar machine   */
    public function saveAddMachine()
    {
        $machine_parameter = count($_POST['machine_parameter']);
        if ($machine_parameter > 0 && $_POST['machine_parameter'][0] != '') {
            $arr = array();
            $i   = 0;
            while ($i < $machine_parameter) {
                $jsonArrayObject = (array(
                    'machine_parameter' => $_POST['machine_parameter'][$i],
                    'uom' => $_POST['uom'][$i]
                ));
                $arr[$i]         = $jsonArrayObject;
                $i++;
            }
            $machine_parameter_array = json_encode($arr);
        } else {
            $machine_parameter_array = '';
        }
        $process_type = count($_POST['process_type']);
        if ($process_type > 0 && $_POST['process_type'][0] != '') {
            $processArr = array();
            $i          = 0;
            while ($i < $process_type) {
                //$jsonArrayObject = (array('process_type' => $_POST['process_type'][$i], 'process' => $_POST['process_name'][$i]));
                $jsonArrayObject = (array(
                    'process_type' => isset($_POST['process_type'][$i]) ? $_POST['process_type'][$i] : '',
                    'process' => isset($_POST['process_name'][$i]) ? $_POST['process_name'][$i] : ''
                ));
                $processArr[$i]  = $jsonArrayObject;
                $i++;
            }

            $machine_process_array = json_encode($processArr);
        } else {
            $machine_process_array = '';
        }

        //pre($machine_process_array); die;
        if ($this->input->post()) {
            $required_fields = array(
                'machine_name',
                'machine_code',
                'year_purchase'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();

                $data['machine_parameter'] = $machine_parameter_array;
                $data['process']           = $machine_process_array;
                #$data['created_by_cid'] = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
                $data['created_by_cid']    = $this->companyId;

                $processTypeUpdateIds = implode("','", $data['process_type']);
                $processTypeUpdateIds = "'" . $processTypeUpdateIds . "'";

                if (!empty($_POST['process_name'])) {
                    $processNameUpdateIds = implode("','", $data['process_name']);
                    $processNameUpdateIds = "'" . $processNameUpdateIds . "'";
                } else {
                    $processNameUpdateIds = '';
                }

                $id                       = $data['id'];
                $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 19
                ));
                if ($id && $id != '') {
                    /*****************************Update machine******************/
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success           = $this->production_model->update_data('add_machine', $data, 'id', $id);
                    /****************update used status if it is used in machine******************/
                    if ($processTypeUpdateIds != "''")
                        updateMultipleUsedIdStatus('process_type', $processTypeUpdateIds);
                    //if($processNameUpdateIds !="''" )  updateMultipleUsedIdStatus('add_process',$processNameUpdateIds);
                    if ($data['department'] != '')
                        updateUsedIdStatus('department', $data['department']);
                    if ($data['machine_group_id'] != '')
                        updateUsedIdStatus('machine_group', $data['machine_group_id']);

                    if ($success) {
                        $data['message'] = "machine updated successfully";
                        logActivity('machine Updated', 'add_machine', $id);


                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {

                                    pushNotification(array(
                                        'subject' => 'Machine Updated',
                                        'message' => 'Machine id : #' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $userViewPermission['user_id'],
                                        'ref_id' => $id,
                                        'class' => 'productionTab',
                                        'data_id' => 'machineView',
                                        'icon' => 'fa fa-archive'
                                    ));

                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array(
                                'subject' => 'Machine Updated',
                                'message' => 'Machine id : #' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'ref_id' => $id,
                                'class' => 'productionTab',
                                'data_id' => 'machineView',
                                'icon' => 'fa fa-archive'
                            ));

                        }

                        $this->session->set_flashdata('message', 'machine Updated successfully');
                        redirect(base_url() . 'production/Add_machine', 'refresh');
                    }
                } else {
                    /*******************Create new and similar machine***************/
                    $id = $this->production_model->insert_tbl_data('add_machine', $data);
                    /****************update used status if it is used in machine******************/
                    if ($processTypeUpdateIds != "''")
                        updateMultipleUsedIdStatus('process_type', $processTypeUpdateIds);
                    //if($processNameUpdateIds !="''")  updateMultipleUsedIdStatus('add_process',$processNameUpdateIds);
                    if ($data['machine_group_id'] != '')
                        updateUsedIdStatus('machine_group', $data['machine_group_id']);
                    if ($data['department'] != '') {
                        updateUsedIdStatus('department', $data['department']);
                    }
                    if ($id) {
                        logActivity('machine Added ', 'add_machine', $id);

                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array(
                                        'subject' => 'Machine created',
                                        'message' => 'New Machine is created by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $userViewPermission['user_id'],
                                        'ref_id' => $id,
                                        'class' => 'productionTab',
                                        'data_id' => 'machineView',
                                        'icon' => 'fa fa-archive'
                                    ));

                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array(
                                'subject' => 'Machine created',
                                'message' => 'New Machine is created by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'ref_id' => $id,
                                'class' => 'productionTab',
                                'data_id' => 'machineView',
                                'icon' => 'fa fa-archive'
                            ));
                        }
                        $this->session->set_flashdata('message', 'Machine Added successfully');
                        redirect(base_url() . 'production/Add_machine', 'refresh');
                    }
                }
            }
        }
    }

    /*delete machine*/
    public function deleteAddMachine($id = '')
    {
        if (!$id) {
            redirect('production/Add_machine', 'refresh');
        }
        //permissions_redirect('is_delete');
        $result = $this->production_model->delete_data('add_machine', 'id', $id);
        if ($result) {
            logActivity('machine  Deleted', 'add_machine', $id);

            $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                'is_view' => 1,
                'sub_module_id' => 19
            ));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array(
                            'subject' => 'Machine deleted',
                            'message' => 'Machine id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                            'from_id' => $_SESSION['loggedInUser']->u_id,
                            'to_id' => $userViewPermission['user_id'],
                            'ref_id' => $id,
                            'icon' => 'fa fa-archive'
                        ));


                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {

                pushNotification(array(
                    'subject' => 'Machine deleted',
                    'message' => 'Machine id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                    'from_id' => $_SESSION['loggedInUser']->u_id,
                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                    'ref_id' => $id,
                    'icon' => 'fa fa-archive'
                ));
            }

            $this->session->set_flashdata('message', 'machine Deleted Successfully');
            $result = array(
                'msg' => 'Machine Deleted Successfully',
                'status' => 'success',
                'code' => 'C142',
                'url' => base_url() . 'production/Add_machine'
            );
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array(
                'msg' => 'error',
                'status' => 'error',
                'code' => 'C1004'
            ));
        }
    }
    /* add machine edit*/
    public function Add_SimilarMachine_edit()
    {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['addProcess'] = $this->production_model->get_data('add_process');
        $this->data['Addmachine'] = $this->production_model->get_data_byId('add_machine', 'id', $id);
        $this->load->view('Add_machine/add_similar_machine', $this->data);
    }

    /*Add machine view code*/
    public function Add_machine_view()
    {
        $id                       = $_POST['id'];
        $this->data['AddMachine'] = $this->production_model->get_data_byId('add_machine', 'id', $id);
        $this->load->view('Add_machine/view', $this->data);
    }

    /*Add machine view code*/
    public function Add_machine_view_new()
    {
        $id                       = $_POST['id'];
        $this->data['AddMachine'] = $this->production_model->get_data_byId('add_machine', 'id', $id);
        $this->load->view('Add_machine/view_new', $this->data);
    }

    public function editProcess()
    {
        if ($this->input->post()) {
            $this->data['id']          = $this->input->post('id');
            $this->data['processType'] = $this->production_model->get_data('process_type');
            $this->data['process']     = $this->production_model->get_data_byId('add_process', 'id', $this->input->post('id'));
            $this->load->view('process/edit', $this->data);
        }
    }
    /******************quck add machine group worker ***********************/
    public function add_machine_group_onthe_spot()
    {
        $machine_group_name = $_REQUEST['machine_group_name'];
        //$created_by_id  = $_SESSION['loggedInUser']->u_id;
        #$created_by_cid  = $_SESSION['loggedInUser']->c_id;
        $group_details      = array(
            'machine_group_name' => $machine_group_name,
            #'created_by_cid '=>$created_by_cid,
            'created_by_cid ' => $this->companyId
        );
        $data2              = $this->production_model->insert_on_spot_tbl_data('machine_group', $group_details);

        $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
            'is_view' => 1,
            'sub_module_id' => 21
        ));
        if (!empty($usersWithViewPermissions)) {
            foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {

                    /*pushNotification(array('subject'=> 'Machine group created' , 'message' => 'Machine group created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$data2.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $data2));*/
                    pushNotification(array(
                        'subject' => 'Machine group created',
                        'message' => 'Machine group is created by ' . $_SESSION['loggedInUser']->name,
                        'from_id' => $_SESSION['loggedInUser']->u_id,
                        'to_id' => $userViewPermission['user_id'],
                        'ref_id' => $data2,
                        'icon' => 'fa fa-archive'
                    ));
                }
            }
        }
        if ($_SESSION['loggedInUser']->role != 1) {
            pushNotification(array(
                'subject' => 'Machine group created',
                'message' => 'Machine group is created by ' . $_SESSION['loggedInUser']->name,
                'from_id' => $_SESSION['loggedInUser']->u_id,
                'to_id' => $_SESSION['loggedInCompany']->u_id,
                'ref_id' => $data2,
                'icon' => 'fa fa-archive'
            ));
        }
        if ($data2 > 0) {
            echo 'true';
        } else {
            echo 'false';
        }
    }



    /**************************************Job card ************************************************************./
    /*job card index */
    public function bom_routing(){
     $this->load->library('pagination');
        $this->data['can_edit']     = edit_permissions();
        $this->data['can_delete']   = delete_permissions();
        $this->data['can_add']      = add_permissions();
        $this->data['can_view']     = view_permissions();
        $this->data['can_validate'] = validate_permissions();
        $this->breadcrumb->add('BOM Routing', base_url() . 'job_card');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'BOM Routing';
          $where = array('job_card.created_by_cid' => $this->companyId );
         // pre($_GET);
           if (isset($_GET['favourites'])!='' && $_GET['ExportType']=='') {
            #$where = array('job_card.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'job_card.favourite_sts' => 1);
            $where                  = array(
                'job_card.created_by_cid' => $this->companyId,
                'job_card.favourite_sts' => 1
            );
                 }
        if( isset($_GET['start']) && isset($_GET['end']) ){
            if ($_GET['start'] != '' && $_GET['end'] != '') {
                    #$where = array('job_card.created_date >=' => $_GET['start'] , 'job_card.created_date <=' => $_GET['end'],'job_card.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                    $where                  = array(
                        'job_card.created_date >=' => $_GET['start'],
                        'job_card.created_date <=' => $_GET['end'],
                        'job_card.created_by_cid' => $this->companyId
                    );
            }
        }

   if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites']=='') {
                #$where = array('job_card.created_by_cid' => $_SESSION['loggedInUser']->c_id);
                $where                  = array(
                    'job_card.created_by_cid' => $this->companyId
                );
        }
        elseif (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end']== '' && $_GET['favourites']!='') {
                #$where = array('job_card.created_date >=' => $_GET['start'] , 'job_card.created_date <=' => $_GET['end'],'job_card.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where                  = array(
                'job_card.created_by_cid' => $this->companyId,
                'job_card.favourite_sts' => 1
            );
        } elseif (isset($_GET["ExportType"]) && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['favourites']=='') {
                #$where = array('job_card.created_date >=' => $_GET['start'] , 'job_card.created_date <=' => $_GET['end'],'job_card.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where                  = array(
                    'job_card.created_date >=' => $_GET['start'],
                    'job_card.created_date <=' => $_GET['end'],
                    'job_card.created_by_cid' => $this->companyId
                );
        }

        //Search
        $where2                        = '';
        $search_string                 = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $where2        = "(job_card.job_card_no like'%" . $search_string . "%' or job_card.job_card_product_name like'%" . $search_string . "%' or job_card.id like'%" . $search_string . "%')";
            redirect("production/bom_routing/?search=$search_string");
        } elseif(isset($_GET['search'])&& $_GET['search']!='') {
          $where2        = "(job_card.job_card_no like'%" .$_GET['search']. "%' or job_card.job_card_product_name like'%" .$_GET['search']. "%' or job_card.id like'%" .$_GET['search']. "%')";
        }


        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = "desc";
        }
        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "production/bom_routing/";
        $config["total_rows"]         = $this->production_model->num_rows('job_card',$where, $where2);
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        #$companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
         if(!empty($_GET['ExportType'])){
                $export_data = 1;
            }else{
                $export_data = 0;
            }

        $this->data['created_by_cid'] = $this->companyId;
        $this->data['job_Card'] = $this->production_model->get_data1('job_card', $where, $config["per_page"], $page, $where2, $order,$export_data);
       $this->_render_template('Job_card/index', $this->data);
    }

    /* Job card edit*/
    /*public function job_card_edit(){
        $PostID = $this->uri->segment(3);
        if(!empty($_POST) || $PostID != ''){
        $id                         = $_POST['id'];
        $this->data['materialType'] = $this->production_model->get_data('material_type');
        $this->data['processType']  = $this->production_model->get_data('process_type');
        $this->data['JobCard']      = $this->production_model->get_data_byId('job_card', 'id', $PostID);
        if (!empty($this->data['JobCard']))
            $this->data['materials'] = $this->production_model->get_tbl_data_byId('material', 'material_type_id', $this->data['JobCard']->material_type_id);
        //$this->load->view('Job_card/edit', $this->data);
        $this->_render_template('Job_card/edit', $this->data);
        }else{
          $this->_render_template('Job_card/edit', $this->data);
        }
    }*/


    public function job_card_edit(){
        $material_id = isset($_POST['material_id']) ? $_POST['material_id']:'';
        if(!empty($material_id) ){
            $materialsData = $this->inventory_model->get_data_byId('material', 'id', $material_id);
            $this->data['jobcard_material'] = $materialsData;
            $this->data['tags_data'] = $this->inventory_model->get_tags_data('tags_in', 'rel_id', $materialsData->id, 'rel_type'); //get tags values from tags table
            $this->data['imageUpload'] = $this->inventory_model->get_image_by_materialId('attachments', 'rel_id', $materialsData->id); //get Multiple images based on id
            $this->data['locations'] = $this->inventory_model->get_data_byLocationId('mat_locations', 'material_name_id', $materialsData->id);

            $this->data['materialType'] = $this->production_model->get_data('material_type');
            $this->data['processType']  = $this->production_model->get_data('process_type');
            $this->data['JobCard']      = $this->production_model->get_data_byId('job_card', 'id', $materialsData->job_card);
            if (!empty($this->data['JobCard']))
            $this->data['materials'] = $this->production_model->get_tbl_data_byId('material', 'material_type_id', $this->data['JobCard']->material_type_id);
            if(empty($this->data['JobCard'])){
                //$this->session->set_flashdata('message', 'No BOM Routing found.');
                //redirect(base_url() . 'production/bom_routing', 'refresh');
                //$this->_render_template('Job_card/edit', $this->data);
            }
            $this->_render_template('Job_card/edit', $this->data);
        } else {
            $PostID = $this->uri->segment(3);
            if(!empty($_POST) || $PostID != ''){
                $id                         = $_POST['id']??'';
                $this->data['materialType'] = $this->production_model->get_data('material_type');
                $this->data['processType']  = $this->production_model->get_data('process_type');
                $this->data['JobCard']      = $this->production_model->get_data_byId('job_card', 'id', $PostID);
                if (!empty($this->data['JobCard']))
                    $this->data['materials'] = $this->production_model->get_tbl_data_byId('material', 'material_type_id', $this->data['JobCard']->material_type_id);
                //$this->load->view('Job_card/edit', $this->data);
                //pre(count($this->data['materials'])); die();
                // echo $PostID;
                $materialsData = $this->inventory_model->get_data_byId('material', 'job_card', $PostID);
                //pre($materialsData); die('info');
                $this->data['jobcard_material'] = $materialsData;


                $this->data['tags_data'] = $this->inventory_model->get_tags_data('tags_in', 'rel_id', $materialsData->id, 'rel_type'); //get tags values from tags table
                $this->data['imageUpload'] = $this->inventory_model->get_image_by_materialId('attachments', 'rel_id', $materialsData->id); //get Multiple images based on id

                $this->data['locations'] = $this->inventory_model->get_data_byLocationId('mat_locations', 'material_name_id', $materialsData->id);

                $this->_render_template('Job_card/edit', $this->data);
            }else{


                $this->_render_template('Job_card/edit', $this->data);
            }

        }

    }



    /*Add job card view code*/
    public function job_card_view()
    {
        $id                         = $_POST['id'];
        $this->data['materialType'] = $this->production_model->get_data('material');
        $this->data['addProcess']   = $this->production_model->get_data('add_process');
        $this->data['jobView']      = $this->production_model->get_data_byId('job_card', 'id', $id);
        $this->load->view('Job_card/view', $this->data);
    }
    /* Job card edit new*/
    public function job_card_edit_new()
    {
        $id                         = $_POST['id'];
        $this->data['materialType'] = $this->production_model->get_data('material_type');
        $this->data['processType']  = $this->production_model->get_data('process_type');
        $this->data['JobCard']      = $this->production_model->get_data_byId('job_card', 'id', $id);
        if (!empty($this->data['JobCard']))
            $this->data['materials'] = $this->production_model->get_tbl_data_byId('material', 'material_type_id', $this->data['JobCard']->material_type_id);
        $this->load->view('Job_card/edit_new', $this->data);
    }
    /*Add job card view code new*/
    public function job_card_view_new()
    {
        $id                         = $_POST['id'];
        $this->data['materialType'] = $this->production_model->get_data('material');
        $this->data['addProcess']   = $this->production_model->get_data('add_process');
        $this->data['jobView']      = $this->production_model->get_data_byId('job_card', 'id', $id);
        $this->load->view('Job_card/view_new', $this->data);
    }

    /*save job card*/
    /*save job card*/
    public function saveJobCard(){
        $material_details = count($_POST['material_name']);
        if ($material_details > 0) {
            $arr = array();
            $j   = 0;
            while ($j < $material_details) {
                $jsonArrayObject = (array(
                    'material_type_id' => $_POST['material_type_id'][$j],
                    'material_name_id' => $_POST['material_name'][$j],
                    'quantity' => $_POST['quantity'][$j],
                    'unit' => $_POST['uom_value'][$j],
                    'price' => $_POST['price'][$j],
                    'total' => $_POST['total'][$j]
                ));
                $arr[$j]         = $jsonArrayObject;
                $j++;
            }
            $materialDetail_array = json_encode($arr);
        } else {
            $materialDetail_array = '';
        }
       foreach ($_POST['scrap_typeinpre'] as $key => $value) {
        /*pre($value); continue;*/
                if ($value== 'assembly_scrap' ) {
               $assembly_scrap = count($_POST['assembly_scrap']);

               if ($assembly_scrap > 0) {
            $assembly_scrapsssa = array();
            $c   = 0;
            while ($c < $assembly_scrap) {
                $assembly_scraparray   = (array(
                    'assembly_scrap_select'=>'assembly_scrap_select',
                    'assembly_scrap'    => $_POST['assembly_scrap'][$c]

                ));
                $assembly_scrapsssa[$c]         = $assembly_scraparray;
                $c++;
            }
            $assembly_scrapmulty = json_encode($assembly_scrapsssa);

        } else {
            $assembly_scrapmulty = '';

       }

     }elseif ($value== 'component_scrap') {
         $scrap_material_name = count($_POST['scrap_material_name']);
         //pre($scrap_material_name);
        if ($scrap_material_name > 0) {
            $scrap_material_namecount = array();
            $ds   = 0;
            while ($ds  < $scrap_material_name) {
                $assembly_scraparray   = (array(
                    'component_scrap_select'=>'component_scrap_select',
                    'scrap_material_name'    => $_POST['scrap_material_name'][$ds],
                    'component_scrap'    => $_POST['component_scrap'][$ds]

                ));
                $scrap_material_namecount[$ds]         = $assembly_scraparray;
                $ds++;
            }
            $scrap_material_namereso = json_encode($scrap_material_namecount);

        } else {
            $scrap_material_namereso = '';

       }

     }elseif ($value== 'operating_scrap') {
          $process_name = count($_POST['process_name']);
             //echo $process_name;
        if ($process_name > 0) {
            $operating_scraparrayin = array();
            $dss   = 0;
            while ($dss  < $process_name) {
                $assembly_scraparray   = (array(
                    'operating_scrap_select'=>'operating_scrap_select',
                    'process_name'    => $_POST['process_name'][$dss],
                    'operating_scrap'    => $_POST['operating_scrap'][$dss]

                ));
                $operating_scraparrayin[$dss]         = $assembly_scraparray;
                $dss++;
            }
            $operating_scrap_arreyinamer = json_encode($operating_scraparrayin);

        } else {
            $operating_scrap_arreyinamer = '';

       }

     }
    }


        //    $scrap_process = count($_POST['process_name']);
        // if ($scrap_process > 0) {
        //     $arrScrapc = array();
        //     $c   = 0;
        //     while ($c < $scrap_process) {
        //         $jsonScrapArrayObjectProcess   = (array(
        //             'scrap_typeinpre'    => $_POST['scrap_typeinpre'][$c],
        //             'material_type_id'  => $_POST['scrap_material_type_id'][$c],
        //             'material_name_id'  => $_POST['scrap_material_name'][$c],
        //             'unit'              => $_POST['scrap_uom_value'][$c],
        //             'assembly_scrap'    => $_POST['assembly_scrap'][$c],
        //             'process_name'      => $_POST['process_name'][$c],
        //             'operating_scrap'     => $_POST['operating_scrap'][$c],
        //             'component_scrap'   => $_POST['component_scrap'][$c],

        //         ));
        //         $arrScrapc[$c]         = $jsonScrapArrayObjectProcess;
        //         $c++;
        //     }
        //     $materialScrapDetail_arrayProcess = json_encode($arrScrapc);

        // } else {
        //     $materialScrapDetail_arrayProcess = '';

        // }


        /* JSON for Linked Material */
            if(!empty($_POST['material_type_id11'])){
             $material_details11 = count($_POST['material_type_id11']);
         } else {
        $material_details11 = 0;    
         }
            if ($material_details11 > 0) {
                $arr11 = array();
                $j11   = 0;
                while ($j11 < $material_details11) {
                    $jsonArrayObject11 = (array(
                        'material_type_id' => $_POST['material_type_id11'][$j11],
                        'material_name_id' => $_POST['material_name11'][$j11]
                    ));
                    $arr11[$j11]         = $jsonArrayObject11;
                    $j11++;
                }
                $materialDetail_array11 = json_encode($arr11);
            } else {
                $materialDetail_array11 = '';
            }
        /* JSON for Linked Material */

        // pre($_POST);
       //  die('testone');


        /***Old Machine Data Start 

        $process_count = count(@$_POST['process_name']);
        if ($process_count > 0) {
            $arr1            = array();
            $i               = 0;
            $k               = 1;
            $in              = 1;
            $ot              = 1;
            $process_details = $_POST['process_name'];
            foreach ($process_details as $val) {
                if (isset($_FILES['documentsAttach_frst_div_' . $k . ''])) {
                    if (!empty($_FILES['documentsAttach_frst_div_' . $k . '']['name']) && $_FILES['documentsAttach_frst_div_' . $k . '']['name'][0] != '') {
                        $proof_array = array();
                        $proofCount  = count($_FILES['documentsAttach_frst_div_' . $k . '']['name']);
                        for ($j = 0; $j < $proofCount; $j++) {
                            $filename                = $_FILES['documentsAttach_frst_div_' . $k . '']['name'][$j];
                            $tmpname                 = $_FILES['documentsAttach_frst_div_' . $k . '']['tmp_name'][$j];
                            $type                    = $_FILES['documentsAttach_frst_div_' . $k . '']['type'][$j];
                            $error                   = $_FILES['documentsAttach_frst_div_' . $k . '']['error'][$j];
                            $size                    = $_FILES['documentsAttach_frst_div_' . $k . '']['size'][$j];
                             $config['upload_path']   = 'assets/modules/production/uploads/';
                            $config['upload_url']    = base_url() . 'assets/modules/production/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size']      = '2000000';
                            $config['file_name']     = $filename;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/production/uploads/" . $filename);
                        }
                    }
                    if ($_FILES['documentsAttach_frst_div_' . $k . '']['name'][0] == '' && $_POST['old_doc_' . $k . ''] != '') {
                         $doc[$i] = $oldDoc;
                     } elseif ($_FILES['documentsAttach_frst_div_' . $k . '']['name'][0] != '' && $_POST['old_doc_' . $k . ''] == '') {
                        $doc[$i] = $_FILES['documentsAttach_frst_div_' . $k . '']['name'];
                    } else if ($_FILES['documentsAttach_frst_div_' . $k . '']['name'][0] != '' && $_POST['old_doc_' . $k . ''] != '') {
                        $doc[$i] = array_merge($oldDoc, $_FILES['documentsAttach_frst_div_' . $k . '']['name']);
                    }

                }
                  if ($_POST['old_doc_' . $k . ''] != '') {
                    $oldDoc = json_decode($_POST['old_doc_' . $k . '']);
                }

                $material_input_dtl = count($_POST['material_type_input_id_' . $in . '']);

                if ($material_input_dtl > 0) {
                    $arr               = array();
                    $process_input_arr = array();
                    $p                 = 0;
                    while ($p < $material_input_dtl) {
                        $jsonArrayObject_input = (array(
                            'material_type_input_id' => $_POST['material_type_input_id_' . $in . ''][$p],
                            'material_input_name' => $_POST['material_input_name_' . $in . ''][$p],
                            'quantity_input' => $_POST['quantity_input_' . $in . ''][$p],
                            'uom_value_input1' => $_POST['uom_value_input1_' . $in . ''][$p],
                            'uom_value_input' => $_POST['uom_value_input_' . $in . ''][$p]
                        ));
                        $process_input_arr[]   = $jsonArrayObject_input;
                        $p++;

                    }

                    $material_input_dtl_array = json_encode($process_input_arr);
                } else {
                    $material_input_dtl_array = '';
                }


                $material_output_dtl = count($_POST['material_type_output_id_' . $ot . '']);
                if ($material_output_dtl > 0) {
                    $arr                = array();
                    $process_output_arr = array();
                    $u                  = 0;
                    while ($u < $material_output_dtl) {
                        $jsonArrayObject_output = (array(
                            'material_type_output_id' => $_POST['material_type_output_id_' . $ot . ''][$u],
                            'material_output_name' => $_POST['material_output_name_' . $ot . ''][$u],
                            'quantity_output' => $_POST['quantity_output_' . $ot . ''][$u],
                            'uom_value_output1' => $_POST['uom_value_output1_' . $ot . ''][$u],
                            'uom_value_output' => $_POST['uom_value_output_' . $ot . ''][$u]
                        ));
                        $process_output_arr[]   = $jsonArrayObject_output;
                        $u++;
                    }

                    $material_output_dtl_array = json_encode($process_output_arr);
                } else {
                    $material_output_dtl_array = '';
                }

                $machine_details_array = array();

                if (isset($_POST['machine_name'][$val])) {
                    $processwise_machine_details = count(@$_POST['machine_name'][$val]);

                    if ($processwise_machine_details > 0) {
                        $machine_details = array_unique($_POST['machine_name'][$val]);


                        foreach ($machine_details as $mach_val) {
                            $paramentere_details_array = array();
                            $parameters                = array_unique($_POST['parameter'][$val][$mach_val]);

                          foreach ($parameters as $Key => $paramenter) {
                                $paramentere_details_array[] = (array(
                                    'parameter_name' => $paramenter,
                                    'parameter_uom' => $_POST['uom'][$val][$mach_val][$Key],
                                    'uom_value' => $_POST['value'][$val][$mach_val][$Key]
                                ));
                            }
                            $machine_details_array[] = (array(
                                'machine_id' => $mach_val,
                                'production_shift' => $_POST['production_shift'][$val][$mach_val],
                                'workers' => $_POST['workers'][$val][$mach_val],
                                'parameter_detials' => $paramentere_details_array,
                                'avg_salary' => $_POST['avg_salary'][$val][$mach_val],
                                'total_cost' => $_POST['total_cost'][$val][$mach_val],
                                'per_unit_cost' => $_POST['per_unit_cost'][$val][$mach_val]
                            ));
                        }
                    }
                }
                
                 $jsonArrayObject1 = (array(
                    'processess' => isset($_POST['process_name'][$i]) ? $_POST['process_name'][$i] : '',
                    'dos' => trim(@$_POST['dos'][$i]),
                    'donts' => trim($_POST['donts'][$i]),
                    'description' => isset($_POST['description'][$i]) ? trim($_POST['description'][$i]) : '',
                    'doc' => isset($doc[$i]) ? $doc[$i] : '',
                    'machine_details' => json_encode($machine_details_array),
                    'input_process' => $material_input_dtl_array,
                    'output_process' => $material_output_dtl_array
                ));
                $arr1[$i]         = $jsonArrayObject1;
                $i++;
                $k++;
                $in++;
                $ot++;
            }
             $machineDetail_array = json_encode($arr1);
        } else {
            $machineDetail_array = '';
        }

        Old Machine Data End***/

        /****New Machine Data Start***/
        //pre($_POST); die;
        $process_count = count(@$_POST['process_set_data']);
        if ($process_count > 0) {
            $arr1            = array();
            $i               = 0;
            $k               = 1;
            $in              = 1;
            $ot              = 1;
            $process_details = $_POST['process_set_data'];
            $final_array = array();
            foreach ($process_details as $key => $process_details_data) {
            $process_details_decode = json_decode($process_details_data);
            foreach ($process_details_decode as $key1 => $value) {
            // if($value->name == "selected_mid"){
            // $key_array[] = $value->value;
            // }
            $final_array[$key][$value->name] = $value->value;
            }
            }
            // pre($final_array);
            // die;
            $key_array = array();
                foreach ($final_array as $key => $val) {
                foreach ($val as $key2 => $v) {
                if (is_numeric($key2)) {
                 $key_array[] = $key2;
                }
                if (strpos($key2, 'machine_name') !== false) {
                $machine_array[] =  $v;
                }
                }
            }
               
                foreach ($final_array as $key => $val) {
                $incf = 1;
                $iii = 0;
                $doc = array();
                foreach (array_keys($val) as $val_file) {
                if(!empty($val['documentsAttach['.$incf.']'])){
                $doc[$iii] = $val['documentsAttach['.$incf.']'];
                }
                $incf++;$iii++;
                }
                
                
                /*
                if (isset($_FILES['documentsAttach_frst_div_' . $k . ''])) {
                    if (!empty($_FILES['documentsAttach_frst_div_' . $k . '']['name']) && $_FILES['documentsAttach_frst_div_' . $k . '']['name'][0] != '') {
                        $proof_array = array();
                        $proofCount  = count($_FILES['documentsAttach_frst_div_' . $k . '']['name']);
                        //pre($proofCount);
                        for ($j = 0; $j < $proofCount; $j++) {
                            $filename                = $_FILES['documentsAttach_frst_div_' . $k . '']['name'][$j];
                            $tmpname                 = $_FILES['documentsAttach_frst_div_' . $k . '']['tmp_name'][$j];
                            $type                    = $_FILES['documentsAttach_frst_div_' . $k . '']['type'][$j];
                            $error                   = $_FILES['documentsAttach_frst_div_' . $k . '']['error'][$j];
                            $size                    = $_FILES['documentsAttach_frst_div_' . $k . '']['size'][$j];
                            /*$exp=explode('.', $filename);
                            $ext=end($exp);
                            $newname=  $exp[0].'_'.time().".".$ext; */
                            /*
                            $config['upload_path']   = 'assets/modules/production/uploads/';
                            $config['upload_url']    = base_url() . 'assets/modules/production/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size']      = '2000000';
                            $config['file_name']     = $filename;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/production/uploads/" . $filename);
                            //$proof_array[$j]['file_name'] = $newname;
                        }
                    }
                    if ($_FILES['documentsAttach_frst_div_' . $k . '']['name'][0] == '' && $_POST['old_doc_' . $k . ''] != '') {
                        //echo 'in if con==>>>';
                        $doc[$i] = $oldDoc;
                        //$doc[$i] = $doc = array_merge($oldDoc,$_FILES['documentsAttach_frst_div_'.$k.'']['name']);
                        ///pre($doc);
                    } elseif ($_FILES['documentsAttach_frst_div_' . $k . '']['name'][0] != '' && $_POST['old_doc_' . $k . ''] == '') {
                        //echo 'in else if con 1==>>>';
                        $doc[$i] = $_FILES['documentsAttach_frst_div_' . $k . '']['name'];
                    } else if ($_FILES['documentsAttach_frst_div_' . $k . '']['name'][0] != '' && $_POST['old_doc_' . $k . ''] != '') {
                        //echo 'in else if con 2==>>>';
                        $doc[$i] = array_merge($oldDoc, $_FILES['documentsAttach_frst_div_' . $k . '']['name']);
                        //$doc[$i] = $_FILES['documentsAttach_frst_div_'.$k.'']['name'];
                    }

                }
                  if ($_POST['old_doc_' . $k . ''] != '') {
                    //pre($_POST['old_doc_'.$k.'']);
                    $oldDoc = json_decode($_POST['old_doc_' . $k . '']);
                    //pre($oldDoc);
                } */

                $inc = 1;
                $process_input_arr = array();
                $process_output_arr = array();
                foreach (array_keys($val) as $val_in) {
                if(!empty($val['material_type_input_id['.$inc.']'])){
                $jsonArrayObject_input = (array(
                            'material_type_input_id' => $val['material_type_input_id['.$inc.']'],
                            'material_input_name' => $val['material_input_name['.$inc.']'],
                            'quantity_input' => $val['quantity_input['.$inc.']'],
                            'uom_value_input1' => $val['uom_value_input1['.$inc.']'],
                            'uom_value_input' => $val['uom_value_input['.$inc.']']
                        ));
                        $process_input_arr[]   = $jsonArrayObject_input;  
                }

                 if(!empty($val['material_type_output_id['.$inc.']'])){
                $jsonArrayObject_output = (array(
                            'material_type_output_id' => $val['material_type_output_id['.$inc.']'],
                            'material_output_name' => $val['material_output_name['.$inc.']'],
                            'quantity_output' => $val['quantity_output['.$inc.']'],
                            'uom_value_output1' => $val['uom_value_output1['.$inc.']'],
                            'uom_value_output' => $val['uom_value_output['.$inc.']']
                        ));
                        $process_output_arr[]   = $jsonArrayObject_output;  
                }
                         $inc++;

                
                // if(!empty($val[$val_in])){
                // echo $val[$val_in];    
                // }

                }

                $material_input_dtl_array = json_encode($process_input_arr);
                $material_output_dtl_array = json_encode($process_output_arr);
               
                $processwise_machine_details = @$final_array[$key]['total_rows_set'];
                if ($processwise_machine_details > 0) {
                    $arr                = array();
                    $machine_output_arr = array();
                    $u                  = 0;
                    //while ($u < $processwise_machine_details) {
                     $paramentere_details_array=$production_shift_array=$hr_array=$mm_array=$sec_array=$mt_hr_array=$mt_mm_array=$mt_sec_array=$machine_time=$workers_array=$avg_salary_array=$total_cost_array=$per_unit_cost=$machine_id = array();
                    $ck = 1;
                   $mp = 0;
                    foreach ($key_array as $keyvalue) {
                    if(!empty($val['machine_name['.$ck.']'])){
                    $machine_id[$val['machine_name['.$ck.']']] = $val['machine_name['.$ck.']'];
                    }
                    //if(!empty($val['parameter['.$keyvalue.']['.$u.']'])){
                    $cc = 0;
                    for ($mc=1; $mc <= $final_array[$key]['mp_length['.$keyvalue.'][0]']; $mc++) { 
                    //echo $keyvalue; echo '<br>';
                    if(!empty($val['parameter['.$keyvalue.'][0]['.$cc.']'])){
                    $paramentere_details_array[$keyvalue][$cc] = (array(
                    'parameter_name' => $val['parameter['.$keyvalue.'][0]['.$cc.']'],
                    'parameter_uom' => $val['uom['.$keyvalue.'][0]['.$cc.']'],
                    'uom_value' => $val['value['.$keyvalue.'][0]['.$cc.']']
                    ));
                    $cc++;
                    }
                    }                  
                    //pre($paramentere_details_array);
                    //}
                    if(!empty($val['production_shift['.$ck.']'])){
                    $production_shift_array[$val['machine_name['.$ck.']']] = $val['production_shift['.$ck.']'];
                    }
                    if(!empty($val['setup_hr['.$ck.']'])){
                    $hr_array[$val['machine_name['.$ck.']']] = $val['setup_hr['.$ck.']'];
                    }
                    if(!empty($val['setup_min['.$ck.']'])){
                    $mm_array[$val['machine_name['.$ck.']']] = $val['setup_min['.$ck.']'];
                    }
                    if(!empty($val['setup_sec['.$ck.']'])){
                    $sec_array[$val['machine_name['.$ck.']']] = $val['setup_sec['.$ck.']'];
                    }
                    if(!empty($val['machine_time_hr['.$ck.']'])){
                    $mt_hr_array[$val['machine_name['.$ck.']']] = $val['machine_time_hr['.$ck.']'];
                    }
                    if(!empty($val['machine_time_min['.$ck.']'])){
                    $mt_mm_array[$val['machine_name['.$ck.']']] = $val['machine_time_min['.$ck.']'];
                    }
                    if(!empty($val['machine_time_sec['.$ck.']'])){
                    $mt_sec_array[$val['machine_name['.$ck.']']] = $val['machine_time_sec['.$ck.']'];
                    }
                    // if(!empty($val['machine_time['.$ck.']'])){
                    // $machine_time_array[$val['machine_name['.$ck.']']] = $val['machine_time['.$ck.']'];
                    // }
                    //pre($val);
                    if(!empty($val['workers['.$ck.']'])){
                    $workers_array[$val['machine_name['.$ck.']']] = $val['workers['.$ck.']'];
                    }
                    if(!empty($val['avg_salary['.$ck.']'])){
                    $avg_salary_array[$val['machine_name['.$ck.']']] = $val['avg_salary['.$ck.']'];
                    }
                    if(!empty($val['total_cost['.$ck.']'])){
                    $total_cost_array[$val['machine_name['.$ck.']']] = $val['total_cost['.$ck.']'];
                    }
                    if(!empty($val['per_unit_cost['.$ck.']'])){
                    $per_unit_cost[$val['machine_name['.$ck.']']] = $val['per_unit_cost['.$ck.']'];
                    }
                    $ck++; $mp++;
                    }
                    $jsonArrayObject_machine = (array(
                            'machine_id' => $machine_id,
                            'production_shift' => $production_shift_array,
                            'hr_set' => $hr_array,
                            'mm_set' => $mm_array,
                            'sec_set' => $sec_array,
                            'mt_hr_set' => $mt_hr_array,
                            'mt_mm_set' => $mt_mm_array,
                            'mt_sec_set' => $mt_sec_array,
                            //'machine_time' => $machine_time_array,
                            'workers' => $workers_array,
                            'parameter_detials' => $paramentere_details_array,
                            'avg_salary' => $avg_salary_array,
                            'total_cost' => $total_cost_array,
                            'per_unit_cost' => $per_unit_cost
                        ));
                        $machine_output_arr[]   = $jsonArrayObject_machine;
                        $u++;
                    //}
                //pre($jsonArrayObject_machine);

                    $machine_details_array = json_encode($machine_output_arr);
                } else {
                    $machine_details_array = '';
                }

                //}
                // pre($machine_details_array);die;
                /* End Update Code For multiple Machine */
                //  pre($machine_details_array);
                $jsonArrayObject1 = (array(
                    'processess' => isset($_POST['process_name'][$i]) ? $_POST['process_name'][$i] : '',
                    /*                     'machine_name' => isset($_POST['machine_name'][$i]) ? $_POST['machine_name'][$i] : '',
                    'parameter' => @$_POST['parameter_frst_div_' . $k . ''],
                    'uom' => @$_POST['uom_frst_div_' . $k . ''],
                    'value' => @$_POST['value_frst_div_' . $k . ''],
                    'production_shift' => $_POST['production_shift'][$i],
                    'workers' => $_POST['workers'][$i],
                    */
                    'dos' => trim(@$final_array[$key]['dos']),
                    'donts' => trim($final_array[$key]['donts']),
                    'description' => isset($final_array[$key]['description']) ? trim($final_array[$key]['description']) : '',
                    'doc' => json_encode($doc),
                    'machine_details' => $machine_details_array,
                    'input_process' => $material_input_dtl_array,
                    'output_process' => $material_output_dtl_array,
                    'process_set_data' => $_POST['process_set_data'][$key]
                )); 
                // pre($jsonArrayObject1);die;
                $arr1[$i]         = $jsonArrayObject1;
                $i++;
                $k++;
                $in++;
                $ot++;
            }

             // pre($arr1);
             // die;
            $machineDetail_array = json_encode($arr1);
        } else {
            $machineDetail_array = '';
        }

        /****New Machine Data End***/
        //die;

        // pre($machineDetail_array);
//die;
         // die('testttt');
        if ($this->input->post()) {
            $required_fields = array(
                'job_card_no'
            );
            $is_valid        = validate_fields($_POST, $required_fields);

            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {



                $data                     = $this->input->post();
                $data['final_process'] = json_encode($_POST['final_process']);
                $data['material_details'] = $materialDetail_array;
                $data['assembly_scrap'] =  $assembly_scrapmulty;
                $data['component_scrap'] = $scrap_material_namereso;
                $data['operating_scrap'] = $operating_scrap_arreyinamer;
                $data['machine_details']  = $machineDetail_array;
                $materialUpdateIds        = implode("','", $data['material_name']);
                $materialUpdateIds        = "'" . $materialUpdateIds . "'";
                if (isset($data['machine_name']) && !empty($data['machine_name'])) {
                    // $machineUpdateIds = implode("','", $data['machine_name']);
                } else {
                    $machineUpdateIds = '';
                }
                if (isset($data['process_name']) && !empty($data['process_name'])) {
                    $procesNameUpdateIds = implode("','", $data['process_name']);
                } else {
                    $procesNameUpdateIds = '';
                }

                #$companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id ;
                $data['created_by_cid']   = $this->companyId;

                $data['linked_material_details'] = $materialDetail_array11;
                $id                       = $data['id'];
                $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 21
                ));
                // pre($machineUpdateIds);

                // die();
                if ($id && $id != '') {

                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;

                   // $success           = $this->production_model->update_data('job_card', $data, 'id', $id);
                    $updateMaterialId   = $this->updateMaterialData($data);
                    $success            = $this->production_model->update_data('job_card', $data, 'id', $id);
                    $updateData = array('job_card' => $id);
                    $update = $this->production_model->update_material_job_card('material', $updateData, 'id', $updateMaterialId);
                    /* For Linking Material with Job Card */
                    $destinationdata11 = json_decode($materialDetail_array11, true);
                    foreach ($destinationdata11 as $data22) {
                         $getAddres = $this->production_model->get_data('material', array('id' => $data22['material_name_id']));
                         foreach ($getAddres as & $values) {
                            if ($values['id'] == $data22['material_name_id']) {
                                $jobcard = $id;
                                $values['job_card'] = $jobcard;
                                $this->production_model->update_data('material', $values, 'id', $data22['material_name_id']);
                            }

                        }
                     }
                      /* For Linking Material with Job Card */
                    //if($machineUpdateIds !="''")  updateMultipleUsedIdStatus('add_machine',$machineUpdateIds);
                    //if($procesNameUpdateIds !="''")  updateMultipleUsedIdStatus('add_process',$procesNameUpdateIds);
                    if ($materialUpdateIds != "''")

                        updateMultipleUsedIdStatus('material', $materialUpdateIds);
                    if ($data['process_type'] != '')
                        updateUsedIdStatus('process_type', $data['process_type']);

                    if ($success) {
                        $data['message'] = "Job card updated successfully";
                        logActivity('Job card Updated', 'job_card', $id);


                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*  pushNotification(array('subject'=> 'Job card updated' , 'message' => 'Job card updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id)); */
                                    pushNotification(array(
                                        'subject' => 'Job Card updated',
                                        'message' => 'Job Card updated by id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $userViewPermission['user_id'],
                                        'ref_id' => $id,
                                        'class' => 'productionTab',
                                        'data_id' => 'jobCardView',
                                        'icon' => 'fa fa-archive'
                                    ));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*pushNotification(array('subject'=> 'Job card updated' , 'message' => 'Job card updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array(
                                'subject' => 'Job Card updated',
                                'message' => 'Job Card updated by id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'ref_id' => $id,
                                'class' => 'productionTab',
                                'data_id' => 'jobCardView',
                                'icon' => 'fa fa-archive'
                            ));
                        }
                        $this->session->set_flashdata('message', 'BOM Routing Updated successfully');
                        #die;
                        redirect(base_url() . 'production/bom_routing', 'refresh');
                    }
                } else {

                    // pre($data);die('Insert Job card');
                    //$id                               = $this->production_model->insert_tbl_data('job_card', $data);
                     if($data['job_card_material_id'] == ''){
                        $materialId =  $this->saveMaterialData($data);
                    } else {
                        $materialId =  $this->updateMaterialData($data);
                    }

                    $id = $this->production_model->insert_tbl_data('job_card', $data);
                    $updateData = array('job_card' => $id);

                    $update = $this->production_model->update_material_job_card('material', $updateData, 'id', $materialId);

                    $get_materialDetail_from_job_card = getNameById('job_card', $id, 'id');

                     /* For Linking Material with Job Card */
                     $destinationdata = json_decode($materialDetail_array11, true);
                    foreach ($destinationdata as $data22) {
                         $getAddres = $this->production_model->get_data('material', array('id' => $data22['material_name_id']));
                         foreach ($getAddres as & $values) {
                            if ($values['id'] == $data22['material_name_id']) {
                                $jobcard = $id;
                                $values['job_card'] = $jobcard;
                                $this->production_model->update_data('material', $values, 'id', $data22['material_name_id']);
                            }

                        }
                     }
                    /* For Linking Material with Job Card */
                    #die;
                    if (!empty($get_materialDetail_from_job_card)) {
                        $matData = json_decode($get_materialDetail_from_job_card->machine_details);

                        #pre($matData);
                        $mtdt       = array();
                        $rtdt       = array();
                        $data_merge = array();
                        $jy         = 0;
                        foreach ($matData as $dt) {
                            $mtdt = json_decode($dt->input_process);
                            $rtdt = json_decode($dt->output_process);
                            #$mtdt = json_decode($dt->output_process);
                        }
                    }

                    # pre($mtdt);
                    # pre($rtdt);

                    $material_Id_CombineArray = array();
                    foreach ($mtdt as $ky) {

                        $material_Id_CombineArray[] = $ky->material_input_name;

                    }

                    $materialIds = implode(',', $material_Id_CombineArray);
                    if($materialIds){
                    $getMaterialIssue_detail = $this->production_model->get_wip_mat_data('work_in_process_material', $materialIds);
                    }
                    $result                  = array();
                    $i                       = 0;
                    #pre($getMaterialIssue_detail);

                    foreach ($getMaterialIssue_detail as $material_issue_data) { //each on Work in process data
                        $mat_issue_id = $material_issue_data['material_id']; // get material id
                        $mat_qty      = $material_issue_data['quantity']; //get qty data

                        foreach ($mtdt as $mat_finish_Id) {
                            foreach ($rtdt as $kl) {

                                $mat_rcvd_id    = $mat_finish_Id->material_input_name;
                                $output_rcvd_id = $kl->quantity_output;

                                if ($mat_issue_id == $mat_rcvd_id) {
                                    $result[$i]['material_id'] = $mat_issue_id;
                                    $result[$i]['result']      = $mat_qty - $output_rcvd_id;
                                    $result[$i]['output']      = $output_rcvd_id;
                                }
                            }
                        }
                        $i++;
                    }

                    if (!empty($result)) {

                        /*update multiple ids at once */
                        $success = $this->production_model->update_mat_in_wip_data('work_in_process_material', $result, $materialIds);
                        # pre($success);
                        # die;
                    }

                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {

                                /*  pushNotification(array('subject'=> 'Job card created' , 'message' => 'Job card created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id)); */
                                pushNotification(array(
                                    'subject' => 'New Job Card created',
                                    'message' => 'New Job Card is created by ' . $_SESSION['loggedInUser']->name,
                                    'from_id' => $_SESSION['loggedInUser']->u_id,
                                    'to_id' => $userViewPermission['user_id'],
                                    'ref_id' => $id,
                                    'class' => 'productionTab',
                                    'data_id' => 'jobCardView',
                                    'icon' => 'fa fa-archive'
                                ));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        /*  pushNotification(array('subject'=> 'Job card created' , 'message' => 'Job card created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));        */
                        pushNotification(array(
                            'subject' => 'New Job Card created',
                            'message' => 'New Job Card is created by ' . $_SESSION['loggedInUser']->name,
                            'from_id' => $_SESSION['loggedInUser']->u_id,
                            'to_id' => $_SESSION['loggedInCompany']->u_id,
                            'ref_id' => $id,
                            'class' => 'productionTab',
                            'data_id' => 'jobCardView',
                            'icon' => 'fa fa-archive'
                        ));
                    }
                    //if($machineUpdateIds !="''" )  updateMultipleUsedIdStatus('add_machine',$machineUpdateIds);
                    //if($procesNameUpdateIds !="''")  updateMultipleUsedIdStatus('add_process',$procesNameUpdateIds);


                    if ($id) {
                        logActivity('Job card Added ', 'job_card', $id);
                        $this->session->set_flashdata('message', 'BOM Routing Added successfully');
                        #die;
                        redirect(base_url() . 'production/bom_routing', 'refresh');
                    }
                }
            }
        }
    }




    public function saveMaterialData($inventoryData){
       //pre($inventoryData); die;
        $materialData   = array();
        $sale_purchase  = ((!empty($inventoryData['sale_purchase'])) ? json_encode($inventoryData['sale_purchase']) : '');
        $route          = ((!empty($inventoryData['route'])) ? json_encode($inventoryData['route']) : '');
        $materialData['inventory_listing_mat_side'] = $inventoryData['inventory_listing_mat_side'];
        $materialData['material_code']              = $inventoryData['material_code'];
        $materialData['material_type_id']           = $inventoryData['inventory_material_type_id'];
        $materialData['sub_type']                   = $inventoryData['inventory_sub_type'];
        $materialData['sale_purchase']              = $inventoryData['sale_purchase'];
        $materialData['non_inventry_material']      = $inventoryData['non_inventry_material'];
        $materialData['material_name']              = $inventoryData['inventory_material_name'];
        $materialData['mat_sku']                    = $inventoryData['mat_sku'];
        $materialData['sales_price']                = $inventoryData['sales_price'];
        $materialData['cost_price']                 = $inventoryData['cost_price'];
        $materialData['hsn_code']                   = $inventoryData['hsn_code'];
        $materialData['inventory_loc']              = $inventoryData['inventory_loc'];
        $materialData['opening_balance']            = $inventoryData['opening_balance'];
        $materialData['uom']                        = $inventoryData['inventory_material_uom'];
        $materialData['lead_time']                  = $inventoryData['lead_time'];
        $materialData['time_period']                = $inventoryData['time_period'];
        $materialData['tax']                        = $inventoryData['tax'];
        $materialData['cess']                       = $inventoryData['cess'];
        $materialData['valuation_type']             = $inventoryData['valuation_type'];
        $materialData['specification']              = $inventoryData['specification'];
        $materialData['min_order']                  = $inventoryData['min_order'];
        $materialData['min_inventory']              = $inventoryData['min_inventory'];
        $materialData['id_loc']                     = $inventoryData['id_loc'];
        $materialData['location']                   = $inventoryData['location'];
        $materialData['storage']                    = $inventoryData['storage'];
        $materialData['rackNumber']                 = $inventoryData['rackNumber'];
        $materialData['lotno']                      = $inventoryData['lotno'];
        $materialData['quantityn']                  = $inventoryData['quantityn'];
        $materialData['Qtyuom']                     = $inventoryData['Qtyuom'];
        $materialData['featured_image']             = $inventoryData['featured_image'];
        $materialData['sale_purchase']              = $sale_purchase;
        $materialData['save_status']                = $inventoryData['inventory_save_status'];
        $materialData['created_by']                 = $inventoryData['created_by'];
        if(isset($inventoryData['tags_data']) && !empty($inventoryData['tags_data'])){
            $materialData['tags'] =   json_encode($inventoryData['tags_data']);
        }else{
          $materialData['tags'] = '[]';
        }
        $materialData['route'] = $route;
        $materialData['created_by_cid'] = $this->companyId;
        $required_fields    = array('material_code');
        $is_valid           = validate_fields($materialData, $required_fields);
        if (count($is_valid) > 0) {
            valid_fields($is_valid);
        } else {
            $source_location = count($materialData['location']);
            if ($source_location > 0) {
                $arr = [];
                $i = 0;
                while ($i < $source_location) {
                    $id_loc = !empty($materialData['id_loc'][$i]) ? $materialData['id_loc'][$i]:'';
                    $jsonArrayObject = (array('id_loc' => $id_loc, 'location' => $materialData['location'][$i], 'Storage' => $materialData['storage'][$i], 'RackNumber' => $materialData['rackNumber'][$i], 'quantity' => $materialData['quantityn'][$i], 'Qtyuom' => $materialData['Qtyuom'][$i] , 'lot_no' => $materialData['lotno'][$i]));
                    $arr[] = $jsonArrayObject;
                    $arr[$i] = $jsonArrayObject;
                    $i++;
                }
                $sourceAdd_array = json_encode($arr);
            } else {
                $sourceAdd_array = '';
            }
            $sourceAddressArray = json_decode($sourceAdd_array);

            $id = $this->inventory_model->insert_tbl_data('material', $materialData);
            $dataInventortFlow = array('current_location' => $sourceAdd_array, 'new_location' => '', 'material_id' => $id, 'material_in' => $materialData['opening_balance'], 'uom' => $materialData['uom'], 'through' => 'New material Added', 'ref_id' => $id, 'created_by' => $materialData['created_by'], 'created_by_cid' => $materialData['created_by_cid'],'opening_blnc' => $materialData['opening_balance'], 'closing_blnc' => $materialData['opening_balance'], 'material_type_id' => $materialData['material_type_id']);
            $success = $this->inventory_model->insert_tbl_data('inventory_flow', $dataInventortFlow);
            $j = 0;
            $opening_balance = $materialData['opening_balance'];
            if ($opening_balance > 0) {
                if($materialData['inventory_loc'] == 1){
                    $insertDatalocation = array();
                    foreach ($sourceAddressArray as $addArray) {
                        $insertDatalocation[$j]['location_id']  = $addArray->location ? $addArray->location : '';
                        $insertDatalocation[$j]['Storage']      = $addArray->Storage ? $addArray->Storage : '';
                        $insertDatalocation[$j]['RackNumber']   = $addArray->RackNumber ? $addArray->RackNumber : '';
                        $insertDatalocation[$j]['quantity']     = $addArray->quantity ? $addArray->quantity : '';
                        $insertDatalocation[$j]['Qtyuom']       = $addArray->Qtyuom ? $addArray->Qtyuom : '';
                        $insertDatalocation[$j]['lot_no']       = $addArray->lot_no ? $addArray->lot_no : '';
                        $insertDatalocation[$j]['material_type_id'] = $materialData['material_type_id'];
                        $insertDatalocation[$j]['material_name_id'] = $id;
                        $insertDatalocation[$j]['created_by_cid']   = $_SESSION['loggedInUser']->c_id;
                        $j++;
                        $lotdetails = $this->inventory_model->get_data('lot_details', array('id' => $addArray->lot_no));
                        foreach($lotdetails as $ree){
                            if ($ree['id'] ==  $addArray->lot_no) {
                                $updatedQty         =   $ree['quantity'] + $addArray->quantity;
                                $ree['quantity']    =   $updatedQty;
                                $success            =   $this->inventory_model->update_single_field_lotdetails('lot_details', $ree,$ree['id']);
                            }
                        }
                    }
                    $id1 = $this->inventory_model->insert_multiple_data_mtloc('mat_locations', $insertDatalocation);
                } else {
                    $compny_dtl =   $this->inventory_model->get_data('company_address',array('created_by_cid'=> $this->companyId));
                    $insertDatalocationloc = array();
                    $insertDatalocationloc['location_id']       = $compny_dtl[0]['id'];
                    $insertDatalocationloc['Storage']           = 'N/A';
                    $insertDatalocationloc['RackNumber']        = '-';
                    $insertDatalocationloc['quantity']          = $materialData['opening_balance'];
                    $insertDatalocationloc['Qtyuom']            = $materialData['Qtyuom'];
                    $insertDatalocationloc['lot_no']            = '';
                    $insertDatalocationloc['material_type_id']  = $materialData['material_type_id'];
                    $insertDatalocationloc['material_name_id']  = $id;
                    $insertDatalocationloc['created_by_cid']    = $_SESSION['loggedInUser']->c_id;
                    $id1 = $this->inventory_model->insert_tbl_data('mat_locations', $insertDatalocationloc);
                }
            }
            if ($materialData['material_type_id'] != '') updateUsedIdStatus('material_type', $materialData['material_type_id']);
            $usersWithViewPermissions  = $this->inventory_model->get_dataw('permissions', array('is_view' => 1, 'sub_module_id' => 7));
            if ($id) {
                logActivity('material inserted', 'material', $id);
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array('subject' => 'New Material created', 'message' => 'New material is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'New Material created', 'message' => 'New material is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                }
                // $this->session->set_flashdata('message', 'material inserted successfully');
            }
            if ($id) {
                if (!empty($_FILES['materialImage']['name']) && $_FILES['materialImage']['name'][0] != '') {
                    $image_array = array();
                    $imageCount = count($_FILES['materialImage']['name']);
                    for ($i = 0;$i < $imageCount;$i++) {
                        $filename = $_FILES['materialImage']['name'][$i];
                        $tmpname = $_FILES['materialImage']['tmp_name'][$i];
                        $type = $_FILES['materialImage']['type'][$i];
                        $error = $_FILES['materialImage']['error'][$i];
                        $size = $_FILES['materialImage']['size'][$i];
                        $exp = explode('.', $filename);
                        $ext = end($exp);
                        $newname = $exp[0] . '_' . time() . "." . $ext;
                        $config['upload_path'] = 'assets/modules/inventory/uploads/';
                        $config['upload_url'] = base_url() . 'assets/modules/inventory/uploads/';
                        $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                        $config['max_size'] = '2000000';
                        $config['file_name'] = $newname;
                        $this->load->library('upload', $config);
                        move_uploaded_file($tmpname, "assets/modules/inventory/uploads/" . $newname);
                        $image_array[$i]['rel_id'] = $id;
                        $image_array[$i]['rel_type'] = 'material';
                        $image_array[$i]['file_name'] = $newname;
                        $image_array[$i]['file_type'] = $type;
                    }
                    if (!empty($image_array)) {
                        $material_image = $this->inventory_model->insert_attachment_data('attachments', $image_array, 'material');
                    }
                }
            }
            if($id){
                return $id;
            }
        }
    }


    public function updateMaterialData($inventoryData){

        $materialData   = array();
        $sale_purchase  = ((!empty($inventoryData['sale_purchase'])) ? json_encode($inventoryData['sale_purchase']) : '');
        $route          = ((!empty($inventoryData['route'])) ? json_encode($inventoryData['route']) : '');
        $materialData['inventory_listing_mat_side'] = $inventoryData['inventory_listing_mat_side'];
        $materialData['material_code']              = $inventoryData['material_code'];
        $materialData['material_type_id']           = $inventoryData['inventory_material_type_id'];
        $materialData['sub_type']                   = $inventoryData['inventory_sub_type'];
        $materialData['sale_purchase']              = $inventoryData['sale_purchase'];
        $materialData['non_inventry_material']      = $inventoryData['non_inventry_material'];
        $materialData['material_name']              = $inventoryData['inventory_material_name'];
        $materialData['mat_sku']                    = $inventoryData['mat_sku'];
        $materialData['sales_price']                = $inventoryData['sales_price'];
        $materialData['cost_price']                 = $inventoryData['cost_price'];
        $materialData['hsn_code']                   = $inventoryData['hsn_code'];
        $materialData['inventory_loc']              = $inventoryData['inventory_loc'];
        $materialData['opening_balance']            = $inventoryData['opening_balance'];
        $materialData['uom']                        = $inventoryData['inventory_material_uom'];
        $materialData['lead_time']                  = $inventoryData['lead_time'];
        $materialData['time_period']                = $inventoryData['time_period'];
        $materialData['tax']                        = $inventoryData['tax'];
        $materialData['cess']                       = $inventoryData['cess'];
        $materialData['valuation_type']             = $inventoryData['valuation_type'];
        $materialData['specification']              = $inventoryData['specification'];
        $materialData['min_order']                  = $inventoryData['min_order'];
        $materialData['min_inventory']              = $inventoryData['min_inventory'];
        $materialData['id_loc']                     = $inventoryData['id_loc'];
        $materialData['location']                   = $inventoryData['location'];
        $materialData['storage']                    = $inventoryData['storage'];
        $materialData['rackNumber']                 = $inventoryData['rackNumber'];
        $materialData['lotno']                      = $inventoryData['lotno'];
        $materialData['quantityn']                  = $inventoryData['quantityn'];
        $materialData['Qtyuom']                     = $inventoryData['Qtyuom'];
        $materialData['featured_image']             = $inventoryData['featured_image'];
        $materialData['sale_purchase']              = $sale_purchase;
        $materialData['save_status']                = 1;
        $updateId                                   = $inventoryData['job_card_material_id'];
        if(isset($inventoryData['tags_data']) && !empty($inventoryData['tags_data'])){
            $materialData['tags'] =   json_encode($inventoryData['tags_data']);
        }else{
          $materialData['tags'] = '[]';
        }
        $materialData['route'] = $route;
        $materialData['created_by_cid'] = $this->companyId;
        $materialData['created_by']     = $inventoryData['created_by'];
        $materialData['edited_by']      = $_SESSION['loggedInUser']->u_id;
        $required_fields    = array('material_code');
        $is_valid           = validate_fields($materialData, $required_fields);
        if (count($is_valid) > 0) {
            valid_fields($is_valid);
        } else {
            $source_location = count($materialData['location']);
            if ($source_location > 0) {
                $arr = [];
                $i = 0;
                while ($i < $source_location) {
                    $id_loc = !empty($materialData['id_loc'][$i]) ? $materialData['id_loc'][$i]:'';
                    $jsonArrayObject = (array('id_loc' => $id_loc, 'location' => $materialData['location'][$i], 'Storage' => $materialData['storage'][$i], 'RackNumber' => $materialData['rackNumber'][$i], 'quantity' => $materialData['quantityn'][$i], 'Qtyuom' => $materialData['Qtyuom'][$i] , 'lot_no' => $materialData['lotno'][$i]));
                    $arr[] = $jsonArrayObject;
                    $arr[$i] = $jsonArrayObject;
                    $i++;
                }
                $sourceAdd_array = json_encode($arr);
            } else {
                $sourceAdd_array = '';
            }

            $sourceAddressArray = json_decode($sourceAdd_array);

            $success = $this->inventory_model->update_data('material', $materialData, 'id', $updateId);
            if ($materialData['material_type_id'] != '') updateUsedIdStatus('material_type', $materialData['material_type_id']);
            $getLcoationId = $this->inventory_model->get_data('mat_locations', array('created_by_cid' => $this->companyId, 'material_name_id' => $updateId));

            if (!empty($getLcoationId)) {
                foreach ($getLcoationId as $getmatId) {
                    $materialId[]   = $getmatId['material_name_id'];
                    $rr[]           = $getmatId['location_id'];
                    $added_id[]     = $getmatId['id'];
                }
                $getUniqueId            = array_unique($materialId);
                $getStringMaterialId    = implode(' , ', $getUniqueId);
                $j = 0;
                $k = 0;
                $material_data1 = array();
                $dtdt = array();
                $inCount = 0;
                $i = 0;
                $rt = 0;
                $arr = [];
                $closingblcn = 0;
                $ty = 0;
                $yj = 0;
                if ($getStringMaterialId == $updateId) {
                    $j = 0;
                    $insertDatalocation = array();
                    $updateDatalocation = array();
                    foreach ($sourceAddressArray as $addArray) {
                        //pre($addArray);
                        $mat_loc_Id = $addArray->id_loc;
                        $checkMatLocData = $this->inventory_model->get_data_byLocationId('mat_locations', 'id', $mat_loc_Id);
                        //pre($checkMatLocData);
                        if(empty($checkMatLocData)){
                            $insertDatalocation[] = array('location_id' => $addArray->location ? $addArray->location : '', 'Storage' => $addArray->Storage ? $addArray->Storage : '', 'RackNumber' => $addArray->RackNumber ? $addArray->RackNumber : '', 'quantity' => $addArray->quantity ? $addArray->quantity : '', 'Qtyuom' => $addArray->Qtyuom ? $addArray->Qtyuom : '', 'material_type_id' => $materialData['material_type_id'], 'material_name_id' => $updateId,'lot_no' => $addArray->lot_no ? $addArray->lot_no : '', 'created_by_cid' => $this->companyId);
                        }else{
                            $updateDatalocation[] = array('id' => $mat_loc_Id, 'location_id' => $addArray->location, 'Storage' => $addArray->Storage, 'RackNumber' => $addArray->RackNumber, 'quantity' => $addArray->quantity, 'Qtyuom' => $addArray->Qtyuom, 'material_type_id' => $materialData['material_type_id'], 'material_name_id' => $updateId,'lot_no' => $addArray->lot_no, 'created_by_cid' => $this->companyId);
                        }
                        $j++;

                        $lotdetails = $this->inventory_model->get_data('lot_details', array('id' => $addArray->lot_no));
                        foreach($lotdetails as $ree){
                            if ($ree['id'] ==  $addArray->lot_no) {

                                $updatedQty =  $addArray->quantity;
                                $ree['quantity'] = $updatedQty;
                                $success22 = $this->inventory_model->update_single_field_lotdetails('lot_details', $ree,$ree['id']);
                            }
                        }
                    }
                    $yu = getNameById_mat('mat_locations',$data['id'],'material_name_id');
                    $sum = 0;
                    if(!empty($yu)){
                        foreach ($yu as $ert) {
                            $sum += $ert['quantity'];
                        }
                    }
                    $closingblcn = $addArray->quantity;
                    if($sum >= $closingblcn){
                        $ty = $sum - $addArray->quantity;
                        $inventoryFlowDataArray['material_out'] = $ty;
                    } else {
                        $yj = $addArray->quantity - $sum;
                        $inventoryFlowDataArray['material_in'] = $yj;
                    }
                    $arr[] =  json_encode(array(array('location' => $addArray->location ? $addArray->location : '','Storage' => $addArray->Storage ? $addArray->Storage : '', 'RackNumber' => $addArray->RackNumber ? $addArray->RackNumber : '', 'quantity' => $addArray->quantity ? $addArray->quantity : '', 'Qtyuom' => $addArray->Qtyuom ? $addArray->Qtyuom : '')));
                    $rt++;
                    $inventoryFlowDataArray['current_location']         = $arr[$i];
                    $inventoryFlowDataArray['material_id']              = $updateId;
                    $inventoryFlowDataArray['uom']                      = $addArray->Qtyuom ? $addArray->Qtyuom : '';
                    $inventoryFlowDataArray['opening_blnc']             = $sum;
                    $inventoryFlowDataArray['material_type_id']         = $materialData['material_type_id'];
                    $inventoryFlowDataArray['closing_blnc']             = $closingblcn;
                    $inventoryFlowDataArray['through']                  = 'Material Quantity Updated';
                    $inventoryFlowDataArray['created_by']               = $_SESSION['loggedInUser']->id;
                    $inventoryFlowDataArray['created_by_cid']           = $this->companyId;
                    $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);

                    if(!empty($insertDatalocation)){
                        $this->inventory_model->insert_multiple_data_mtloc('mat_locations', $insertDatalocation);
                    }
                    $success = $this->inventory_model->update_Locationdata_multiple('mat_locations', $updateDatalocation);
                } else {
                    $jk = 0;
                    $insertDatalocation1 = array();
                    foreach ($sourceAddressArray as $addArray1) {
                        $insertDatalocation1[$jk]['location_id']        = $addArray1->location ? $addArray1->location : '';
                        $insertDatalocation1[$jk]['Storage']            = $addArray1->Storage ? $addArray1->Storage : '';
                        $insertDatalocation1[$jk]['RackNumber']         = $addArray1->RackNumber ? $addArray1->RackNumber : '';
                        $insertDatalocation1[$jk]['quantity']           = $addArray1->quantity ? $addArray1->quantity : '';
                        $insertDatalocation1[$jk]['Qtyuom']             = $addArray1->Qtyuom ? $addArray1->Qtyuom : '';
                        $insertDatalocation1[$jk]['lot_no']             = $addArray1->lot_no ? $addArray1->lot_no : '';
                        $insertDatalocation1[$jk]['material_type_id']   = $materialData['material_type_id'];
                        $insertDatalocation1[$jk]['material_name_id']   = $updateId;
                        $insertDatalocation1[$jk]['created_by_cid']     = $this->companyId;
                        $jk++;
                        $lotdetails = $this->inventory_model->get_data('lot_details', array('id' => $addArray->lot_no));
                        foreach($lotdetails as $ree){
                            if ($ree['id'] ==  $addArray->lot_no) {
                                    $updatedQty = $ree['quantity'] + $addArray->quantity;
                                    $ree['quantity'] = $updatedQty;
                                    $success22 = $this->inventory_model->update_single_field_lotdetails('lot_details', $ree,$ree['id']);
                            }
                        }
                    }
                    $id1 = $this->inventory_model->insert_multiple_data_mtloc('mat_locations', $insertDatalocation1);
                }
            } else {
                $jk = 0;
                $insertDatalocation1 = array();
                foreach ($sourceAddressArray as $addArray1) {
                    $insertDatalocation1[$jk]['location_id']        = $addArray1->location ? $addArray1->location : '';
                    $insertDatalocation1[$jk]['Storage']            = $addArray1->Storage ? $addArray1->Storage : '';
                    $insertDatalocation1[$jk]['RackNumber']         = $addArray1->RackNumber ? $addArray1->RackNumber : '';
                    $insertDatalocation1[$jk]['quantity']           = $addArray1->quantity ? $addArray1->quantity : '';
                    $insertDatalocation1[$jk]['lot_no']             = $addArray1->lot_no ? $addArray1->lot_no : '';
                    $insertDatalocation1[$jk]['Qtyuom']             = $addArray1->Qtyuom ? $addArray1->Qtyuom : '';
                    $insertDatalocation1[$jk]['material_type_id']   = $materialData['material_type_id'];
                    $insertDatalocation1[$jk]['material_name_id']   = $updateId;
                    $insertDatalocation1[$jk]['created_by_cid']     = $this->companyId;
                    $jk++;

                    $lotdetails = $this->inventory_model->get_data('lot_details', array('id' => $addArray1->lot_no));
                    foreach($lotdetails as $ree){
                        if ($ree['id'] ==  $addArray1->lot_no) {
                                $updatedQty = $ree['quantity'] + $addArray1->quantity;
                                $ree['quantity'] = $updatedQty;
                                $success22 = $this->inventory_model->update_single_field_lotdetails('lot_details', $ree,$ree['id']);
                        }
                    }
                }
                $id1 = $this->inventory_model->insert_multiple_data_mtloc('mat_locations', $insertDatalocation1);
            }
            $usersWithViewPermissions  = $this->inventory_model->get_dataw('permissions', array('is_view' => 1, 'sub_module_id' => 7));
            if ($success) {
                //$data['message'] = "Material updated successfully";
                logActivity('Material Updated', 'material', $updateId);
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array('subject' => 'Material updated', 'message' => 'Material id : #: ' . $updateId . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $updateId, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Material updated', 'message' => 'Material id : #: ' . $updateId . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $updateId, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                }
               // $this->session->set_flashdata('message', 'Material Updated successfully');
            }
            if ($updateId) {
                if (!empty($_FILES['materialImage']['name']) && $_FILES['materialImage']['name'][0] != '') {
                    $image_array = array();
                    $imageCount = count($_FILES['materialImage']['name']);
                    for ($i = 0;$i < $imageCount;$i++) {
                        $filename = $_FILES['materialImage']['name'][$i];
                        $tmpname = $_FILES['materialImage']['tmp_name'][$i];
                        $type = $_FILES['materialImage']['type'][$i];
                        $error = $_FILES['materialImage']['error'][$i];
                        $size = $_FILES['materialImage']['size'][$i];
                        $exp = explode('.', $filename);
                        $ext = end($exp);
                        $newname = $exp[0] . '_' . time() . "." . $ext;
                        $config['upload_path'] = 'assets/modules/inventory/uploads/';
                        $config['upload_url'] = base_url() . 'assets/modules/inventory/uploads/';
                        $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                        $config['max_size'] = '2000000';
                        $config['file_name'] = $newname;
                        $this->load->library('upload', $config);
                        move_uploaded_file($tmpname, "assets/modules/inventory/uploads/" . $newname);
                        $image_array[$i]['rel_id'] = $updateId;
                        $image_array[$i]['rel_type'] = 'material';
                        $image_array[$i]['file_name'] = $newname;
                        $image_array[$i]['file_type'] = $type;
                    }
                    if (!empty($image_array)) {
                        $material_image = $this->inventory_model->insert_attachment_data('attachments', $image_array, 'material');
                    }
                }
            }
            if($updateId){
                return $updateId;
            }
        }
    }




    /**********similar jonb card********************/
    public function Add_SimilarJob_card()
    {
        $id                         = $_POST['id'];
        $this->data['materialType'] = $this->production_model->get_data('material_type');
        $this->data['processType']  = $this->production_model->get_data('process_type');
        $this->data['JobCard']      = $this->production_model->get_data_byId('job_card', 'id', $id);
        if (!empty($this->data['JobCard']))
            $this->data['materials'] = $this->production_model->get_tbl_data_byId('material', 'material_type_id', $this->data['JobCard']->material_type_id);

        $materialsData = $this->inventory_model->get_data_byId('material', 'job_card', $id);
        //pre($materialsData);
        $this->data['jobcard_material'] = $materialsData;
        $this->data['tags_data'] = $this->inventory_model->get_tags_data('tags_in', 'rel_id', $materialsData->id, 'rel_type'); //get tags values from tags table
        $this->data['imageUpload'] = $this->inventory_model->get_image_by_materialId('attachments', 'rel_id', $materialsData->id); //get Multiple images based on id
        $this->data['locations'] = $this->inventory_model->get_data_byLocationId('mat_locations', 'material_name_id', $materialsData->id);
        $this->data['created_by_cid'] = $this->companyId;
        if(isset($_POST['existing'])){
            $this->data['existing'] = $_POST['existing'];
        }
        $this->load->view('Job_card/similar_job_card', $this->data);
    }




    /**********similar jonb card********************/
    /*public function Add_SimilarJob_card()
    {
        $id                         = $_POST['id'];
        $this->data['materialType'] = $this->production_model->get_data('material_type');
        $this->data['processType']  = $this->production_model->get_data('process_type');
        $this->data['JobCard']      = $this->production_model->get_data_byId('job_card', 'id', $id);
        if (!empty($this->data['JobCard']))
            $this->data['materials'] = $this->production_model->get_tbl_data_byId('material', 'material_type_id', $this->data['JobCard']->material_type_id);
        $this->load->view('Job_card/similar_job_card', $this->data);
    }*/



    /*delete job card*/
    public function deleteJobcard($id = '')
    {
        if (!$id) {
            redirect('production/bom_routing', 'refresh');
        }
        //permissions_redirect('is_delete');
        $result = $this->production_model->delete_data('job_card', 'id', $id);
        if ($result) {
            logActivity('job card  Deleted', 'job_card', $id);

            $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                'is_view' => 1,
                'sub_module_id' => 20
            ));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {

                        /*pushNotification(array('subject'=> 'Job card deleted' , 'message' => 'Job card deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                        pushNotification(array(
                            'subject' => 'Job Card deleted',
                            'message' => 'Job Card id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                            'from_id' => $_SESSION['loggedInUser']->u_id,
                            'to_id' => $userViewPermission['user_id'],
                            'ref_id' => $id,
                            'icon' => 'fa fa-archive'
                        ));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                /*pushNotification(array('subject'=> 'Job card deleted' , 'message' => 'Job card deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                pushNotification(array(
                    'subject' => 'Job Card deleted',
                    'message' => 'Job Card id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                    'from_id' => $_SESSION['loggedInUser']->u_id,
                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                    'ref_id' => $id,
                    'icon' => 'fa fa-archive'
                ));
            }

            $this->session->set_flashdata('message', 'job card Deleted Successfully');
            $result = array(
                'msg' => 'job card Deleted Successfully',
                'status' => 'success',
                'code' => 'C142',
                'url' => base_url() . 'production/bom_routing'
            );
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array(
                'msg' => 'error',
                'status' => 'error',
                'code' => 'C1004'
            ));
        }
    }

    public function getMaterialDataById()
    {
        if (isset($_REQUEST) && !empty($_REQUEST) && (isset($_REQUEST['id']) && $_REQUEST['id'] != '')) {
            $id       = $_REQUEST['id'];
            $material = $this->production_model->get_data_byId_fromMaterial('material', 'id', $id);
            if ($material->uom != '') {
                $ww              = getNameById('uom', $material->uom, 'id');
                $material->uom   = $ww->uom_quantity;//$ww->ugc_code;
                $material->uomid = $ww->id;
            }
            //$material = $this->production_model->get_data_byId('material','id',$id);
            echo json_encode($material);
        }
    }
    /*function through ajax call*/
    public function get_material_name()
    {
        $this->data['material'] = $this->production_model->get_data('material', array(
            'material_type_id' => $_POST['material_id']
        ));
        echo json_encode($this->data['material']);
    }

    /*function through ajax call*/
    public function get_machine_parameter()
    {
        $id                 = $_POST['machineId'];
        $data_machine_param = $this->production_model->get_data_parameter('add_machine', 'id', $id);
        #pre($data_machine_param);
        // $data_machine_param->machine_parameter;

          $products = json_decode($data_machine_param->machine_parameter);
          #pre($products);
            foreach($products as $erty){
            $i = 0;
               $newProduct = array();
                foreach ($products as $product) {
                    #pre($product->uom);
                    $ww = getNameById('uom', $product->uom, 'id');
                    if (empty($ww)) {
                        $product->uom = "113";
                    } else {
                        $product->uomnme = $ww->ugc_code;
                    }
                    $newProduct[$i] = $product;
                    #$this->crm_model->updateRowWhere('leads',$aa,$data);
                    $i++;
                }
                // $aa = array('id' => $key['id']);
                $eds = json_encode($newProduct);
                #pre($data);
            }
           echo $eds;
            // if ($material->uom != '') {
            //     $ww              = getNameById('uom', $material->uom, 'id');
            //     $material->uom   = $ww->uom_quantity;//$ww->ugc_code;
            //     $material->uomid = $ww->id;
            // }
    }


    /*************************production data code index*****************************************************/
    public function production_data()
    {
        //pre("IN");die;
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Production Data', base_url() . 'production_data');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Production Data';
           $where      = array( 'production_data.created_by_cid' => $this->companyId);
         if (isset($_GET['favourites'])!='' && isset($_GET["ExportType"])=='') {
            #$where = array('production_data.created_by_cid' => $_SESSION['loggedInUser']->c_id, 'production_data.favourite_sts' => 1);
            $where = array(  'production_data.created_by_cid' => $this->companyId,  'production_data.favourite_sts' => 1 );
         }
         if (!empty($_GET['start']) && !empty($_GET['end']) && $_GET['favourites']=='') {
                #$where = array('production_data.created_date >=' => $_POST['start'] , 'production_data.created_date <=' => $_POST['end'],'production_data.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where       = array(
                    'production_data.created_date >=' => $_GET['start'],
                    'production_data.created_date <=' => $_GET['end'],
                    'production_data.created_by_cid' => $this->companyId
                );

                //$this->_render_template('production_data/index', $this->data);
            }
            if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites']=='' && $_GET['search']=='') {
                #$where = array('production_data.created_by_cid' => $_SESSION['loggedInUser']->c_id);
                $where                        = array(
                    'production_data.created_by_cid' => $this->companyId
                );
              }
            elseif (isset($_GET["ExportType"]) && $_GET['start']=='' && $_GET['end']=='' && $_GET['favourites']!='' && $_GET['search']=='') {
                #$where = array('production_data.created_date >=' => $_POST['start'] , 'production_data.created_date <=' => $_POST['end'],'production_data.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
            $where = array(  'production_data.created_by_cid' => $this->companyId,  'production_data.favourite_sts' => 1 );

                //$this->_render_template('production_data/index', $this->data);
            }  elseif (isset($_GET["ExportType"])=='' && !empty($_GET['start']) && !empty($_GET['end']) && $_GET['favourites']=='' && $_GET['search']=='') {
                #$where = array('production_data.created_date >=' => $_POST['start'] , 'production_data.created_date <=' => $_POST['end'],'production_data.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where                        = array(
                    'production_data.created_date >=' => $_GET['start'],
                    'production_data.created_date <=' => $_GET['end'],
                    'production_data.created_by_cid' => $this->companyId
                );

                //$this->_render_template('production_data/index', $this->data);
            }
        //Search
        $where2                        = '';
        $search_string                 = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $machineName=getNameById('add_machine',$search_string,'machine_name');
                if(!empty($machineName->id)){
                    $json_dtl ='{"machine_name_id" : "'.$machineName->id.'"}';
                    $where2 = "json_contains(`production_data`, '".$json_dtl."')" ;
                }else{
                    $where2 = "production_data.id like'%" . $search_string . "%'";
                }
            redirect("production/production_data/?search=$search_string");
        } else if (isset($_GET['search'])&& $_GET['search']!='') {
            $machineName=getNameById('add_machine',$_GET['search'],'machine_name');
                if(!empty($machineName->id)){
                    $json_dtl ='{"machine_name_id" : "'.$machineName->id.'"}';
                    $where2 = "json_contains(`production_data`, '".$json_dtl."')" ;
                }else{
                    $where2 = " production_data.id like'%" . $_GET['search'] . "%'";
                }
        }

        if (!empty($_POST['order'])) {
            $order = $_POST['order'];

        } else {
            $order = "desc";
        }

        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "production/production_data/";
        $config["total_rows"]         = $this->production_model->num_rows('production_data',$where, $where2);
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if(!empty($_GET['ExportType'])){
                $export_data = 1;
            }else{
                $export_data = 0;
            }
                $this->data['productionData'] = $this->production_model->get_data1('production_data', $where, $config["per_page"], $page, $where2, $order,$export_data);
                //$this->_render_template('production_data/index', $this->data);
            //pre($this->data);die;
            if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }

        $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';

            $this->_render_template('production_data/index', $this->data);

        // if(!empty($_POST)){
        // $this->load->view('production_data/index', $this->data);
        // }else{
        // $this->_render_template('production_data/index', $this->data);
        // }
    }

    public function production_data_edit()
    {   $this->breadcrumb->add('Production Data', base_url() . 'production_data');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Production Data';
        $id = $_GET['id'];
        #echo "id=".$id;
       # die;
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where                           = array(
            'add_machine.created_by_cid' => $this->companyId
        );
        #$machineWhere = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id,'add_machine.save_status' => 1);
        $machineWhere                    = array(
            'add_machine.created_by_cid' => $this->companyId,
            'add_machine.save_status' => 1
        );
        $this->data['machineName']       = $this->production_model->get_data('add_machine', $machineWhere);


        $this->data['production_data']   = $this->production_model->get_data_byId('production_data', 'id', $id);
        #$productionSettingWhere = array('production_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $productionSettingWhere          = array(
            'production_setting.created_by_cid' => $this->companyId
        );
        $this->data['productionSetting'] = $this->production_model->get_data('production_setting', $productionSettingWhere);
          #$productionSettingWageswhere = array('wages_perpiece_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $productionSettingWageswhere          = array(
            'wages_perpiece_setting.created_by_cid' => $this->companyId
        );
        $this->data['productionSettingWages'] = $this->production_model->get_data('wages_perpiece_setting', $productionSettingWageswhere);

        #$where1 = array('wages_perpiece_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where1                       = array(
            'wages_perpiece_setting.created_by_cid' => $this->companyId
        );
        $this->data['wages_perpiece'] = $this->production_model->get_data('wages_perpiece_setting', $where1);

       /* pre($this->data);
        die;*/

        $this->_render_template('production_data/edit', $this->data);
    }
    public function get_production_data_according_toDeprtment()
    {

        #if($_REQUEST['selected_department_idd'] !=''){
        $combined_array = array();
        if ($_REQUEST['selected_department_idd'] != '' && $_REQUEST['date'] != '' && $_REQUEST['shift'] != '') {
            if ($_REQUEST['table'] == 'production_data') {
                $createdDateShift = $this->production_model->dateAndShiftExist('production_data', $_REQUEST['date'], $_REQUEST['shift'], $_REQUEST['selected_department_idd']);
                if ($createdDateShift) {
                    echo 'Data of this date and shift already exist';
                } else {
                    #$machineWhere = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id,'add_machine.save_status' => 1,'add_machine.department'=> $_REQUEST['selected_department_idd']);
                    $machineWhere              = array(
                        'add_machine.created_by_cid' => $this->companyId,
                        'add_machine.save_status' => 1,
                        'add_machine.department' => $_REQUEST['selected_department_idd']
                    );
                    $get_machine_data          = $this->production_model->get_data('add_machine', $machineWhere);
                    #$Where = array('wages_perpiece_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id,'wages_perpiece_setting.department'=> $_REQUEST['selected_department_idd']);
                    $Where                     = array(
                        'wages_perpiece_setting.created_by_cid' => $this->companyId,
                        'wages_perpiece_setting.department' => $_REQUEST['selected_department_idd']
                    );
                    $get_wages_data            = $this->production_model->get_data('wages_perpiece_setting', $Where);
                    $combined_array['Machine'] = $get_machine_data;
                    $combined_array['wages']   = $get_wages_data;
                    //$combined_array['msg'] = $createdDateShift;
                    //$data = json_encode($get_machine_data);
                    //echo $combined_array;
                    $data                      = json_encode($combined_array);
                    echo $data;
                }
            }
            if ($_REQUEST['table'] == 'production_planning') {
                $createdDateShift_planning = $this->production_model->dateAndShiftExist('production_planning', $_REQUEST['date'], $_REQUEST['shift'], $_REQUEST['selected_department_idd']);
                if ($createdDateShift_planning) {
                    echo 'Data of this date and shift already exist';
                } else {
                    #$machineWhere = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id,'add_machine.save_status' => 1,'add_machine.department'=> $_REQUEST['selected_department_idd']);
                    $machineWhere              = array(
                        'add_machine.created_by_cid' => $this->companyId,
                        'add_machine.save_status' => 1,
                        'add_machine.department' => $_REQUEST['selected_department_idd']
                    );
                    $get_machine_data          = $this->production_model->get_data('add_machine', $machineWhere);
                    #$Where = array('wages_perpiece_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id,'wages_perpiece_setting.department'=> $_REQUEST['selected_department_idd']);
                    $Where                     = array(
                        'wages_perpiece_setting.created_by_cid' => $this->companyId,
                        'wages_perpiece_setting.department' => $_REQUEST['selected_department_idd']
                    );
                    $get_wages_data            = $this->production_model->get_data('wages_perpiece_setting', $Where);
                    $combined_array['Machine'] = $get_machine_data;
                    $combined_array['wages']   = $get_wages_data;
                    //$combined_array['msg'] = $createdDateShift;
                    //$data = json_encode($get_machine_data);
                    //echo $combined_array;
                    $data                      = json_encode($combined_array);
                    echo $data;
                }
            }
        }
    }
    /*public function get_production_data_according_toDeprtment(){
    #if($_REQUEST['selected_department_idd'] !=''){
    $combined_array = array();
    if($_REQUEST['selected_department_idd'] !='' && $_REQUEST['date'] !='' && $_REQUEST['shift'] !=''){
    $createdDateShift = $this->production_model->dateAndShiftExist('production_data',$_REQUEST['date'],$_REQUEST['shift'],$_REQUEST['selected_department_idd']);
    //pre($createdDateShift);
    $createdDateShift_planning = $this->production_model->dateAndShiftExist('production_planning',$_REQUEST['date'],$_REQUEST['shift'],$_REQUEST['selected_department_idd']);
    if($createdDateShift || $createdDateShift_planning){
    //if($createdDateShift){
    echo 'Data of this date and shift already exist';
    }else{
    $machineWhere = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id,'add_machine.save_status' => 1,'add_machine.department'=> $_REQUEST['selected_department_idd']);
    $get_machine_data = $this->production_model->get_data('add_machine',$machineWhere);

    $Where = array('wages_perpiece_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id,'wages_perpiece_setting.department'=> $_REQUEST['selected_department_idd']);
    $get_wages_data = $this->production_model->get_data('wages_perpiece_setting',$Where);

    $combined_array['Machine'] = $get_machine_data;
    $combined_array['wages'] = $get_wages_data;
    //$combined_array['msg'] = $createdDateShift;
    //$data = json_encode($get_machine_data);
    //echo $combined_array;
    $data = json_encode($combined_array);
    echo $data;
    }
    }
    }*/

    /*save production data*/
    /*Status('department',$data['department_id']);
    if($data['shift'] != '') updateUsedIdStatus('production_setting',$data['sme'])){
    foreach($_POST['worker_name'] as $workerIds){
    foreach($workerIds as $get_worker_id){
    $workerArrayId[] = $get_worker_id;
    }
    }
    }
    $workerIdsUpdate = implode("','",$workerArrayId);
    $workerIdsUpdate = "'".$workerIdsUpdate."'";

    //pre($productionData_array);die;
    if ($this->input->post()) {
    $required_fields = array('machine_name_id');
    $is_valid = validate_fields($_POST, $required_fields);
    if (count($is_valid) > 0) {
    valid_fields($is_valid);
    }else{
    $data  = $this->input->post();
    $machineNameUpdateIds = implode("','", $data['machine_name_id']);
    $machineNameUpdateIds = "'".$machineNameUpdateIds."'";

    $jobCardUpdateIds = implode("','", $data['job_card_product_id']);
    $jobCardUpdateIds = "'".$jobCardUpdateIds."'";

    $data['production_data'] = $productionData_array;
    $data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
    //$data['created_by'] = $_SESSION['loggedInUser']->u_id ;
    $id=$data['id'];
    if($id && $id != ''){
    $data['edited_by'] = $_SESSION['loggedInUser']->u_id ;
    $success = $this->production_model->update_data('production_data',$data, 'id', $id);
    if($machineNameUpdateIds !="''")  updateMultipleUsedIdStatus('add_machine',$machineNameUpdateIds);
    if($workerIdsUpdate !="''")  updateMultipleUsedIdStatus('worker',$workerIdsUpdate);
    if($jobCardUpdateIds !="''")  updateMultipleUsedIdStatus('job_card',$jobCardUpdateIds);
    if($data['department_id'] != '') updateUsedIdStatus('department',$data['department_id']);
    if($data['shift'] != '') updateUsedIdStatus('production_setting',$data['sme'])){
    foreach($_POST['worker_name'] as $workerIds){
    foreach($workerIds as $get_worker_id){
    $workerArrayId[] = $get_worker_id;
    }
    }
    }
    $workerIdsUpdate = implode("','",$workerArrayId);
    $workerIdsUpdate = "'".$workerIdsUpdate."'";

    //pre($productionData_array);die;
    if ($this->input->post()) {
    $required_fields = array('machine_name_id');
    $is_valid = validate_fields($_POST, $required_fields);
    if (count($is_valid) > 0) {
    valid_fields($is_valid);
    }else{
    $data  = $this->input->post();
    $machineNameUpdateIds = implode("','", $data['machine_name_id']);
    $machineNameUpdateIds = "'".$machineNameUpdateIds."'";

    $jobCardUpdateIds = implode("','", $data['job_card_product_id']);
    $jobCardUpdateIds = "'".$jobCardUpdateIds."'";

    $data['production_data'] = $productionData_array;
    $data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
    //$data['created_by'] = $_SESSION['loggedInUser']->u_id ;
    $id=$data['id'];
    if($id && $id != ''){
    $data['edited_by'] = $_SESSION['loggedInUser']->u_id ;
    $success = $this->production_model->update_data('production_data',$data, 'id', $id);
    if($machineNameUpdateIds !="''")  updateMultipleUsedIdStatus('add_machine',$machineNameUpdateIds);
    if($workerIdsUpdate !="''")  updateMultipleUsedIdStatus('worker',$workerIdsUpdate);
    if($jobCardUpdateIds !="''")  updateMultipleUsedIdStatus('job_card',$jobCardUpdateIds);
    if($data['department_id'] != '') updateUsedIdStatus('department',$data['department_id']);
    if($data['shift'] != '') updateUsedIdStatus('production_setting',$data['shift']);
    if ($success) {
    $data['message'] = "production data updated successfully";
    logActivity('production data Updated','production_data',$id);
    $this->session->set_flashdata('message', 'production data Updated successfully');
    redirect(base_url().'production/production_data', 'refresh');
    }
    }else{
    // if($data['planning_id'] != ''){
    //
    // }

    $createdDateShift = $this->production_model->dateAndShiftExist('production_data',$_POST['date'],$_POST['shift'], 'update');
    if($createdDateShift){
    $this->session->set_flashdata('message', 'Production Data Already exist');
    redirect(base_url().'production/production_data', 'refresh');
    }else{
    if($machineNameUpdateIds !="''")  updateMultipleUsedIdStatus('add_machine',$machineNameUpdateIds);
    if($machineNameUpdateIds !="''")  updateMultipleUsedIdStatus('add_machine',$machineNameUpdateIds);
    if($jobCardUpdateIds !="''")  updateMultipleUsedIdStatus('job_card',$jobCardUpdateIds);
    if($workerIdsUpdate !="''")  updateMultipleUsedIdStatus('worker',$workerIdsUpdate);
    if($data['department_id'] != '') updateUsedIdStatus('department',$data['department_id']);
    if($data['shift'] != '') updateUsedIdStatus('production_setting',$data['shift']);
    $id = $this->production_model->insert_tbl_data('production_data',$data);
    /*if($data['planning_id'] !=''){
    $this->production_model->update_prodData_single_data('production_planning','id',$data['planning_id']);
    }*/
    /*if ($id) {

    logActivity('production data Added ','production_data',$id);
    $this->session->set_flashdata('message', 'production data Added successfully');
    redirect(base_url().'production/production_data', 'refresh');
    }
    }
    }

    }
    }
    }
    */


    /*save production data*/
    public function saveProductiondata(){
    // pre($_POST['input']);
       //pre($_POST);die;
        $production_dataLength = count($_POST['machine_name_id']);
        //pre($production_dataLength);
        if ($production_dataLength > 0) {
            $productionArray = array();
            $i               = 0;

            while ($i < $production_dataLength) {

                //pre($_POST['input'][$i]);
                $productionArrayObject = (array(
                    'wages_or_per_piece' => isset($_POST['wages_or_per_piece'][$i]) ? $_POST['wages_or_per_piece'][$i] : '',
                    'machine_name_id' => isset($_POST['machine_name_id'][$i]) ? $_POST['machine_name_id'][$i] : '',
                    'machine_grp' => isset($_POST['machine_grp'][$i]) ? $_POST['machine_grp'][$i] : '',
                    'sale_order' => isset($_POST['sale_order'][$i]) ? $_POST['sale_order'][$i] : '',
                    'work_order' => isset($_POST['work_order'][$i]) ? $_POST['work_order'][$i] : '',
                    'job_card_product_id' => isset($_POST['job_card_product_id'][$i]) ? $_POST['job_card_product_id'][$i] : '',
                    'process_name' => isset($_POST['process_name'][$i]) ? $_POST['process_name'][$i] : '',
                    'party_code' => isset($_POST['product_name'][$i]) ? $_POST['product_name'][$i] : '',
                    'npdm' => isset($_POST['npdm_name'][$i]) ? $_POST['npdm_name'][$i] : '',
                    'worker_id' => isset($_POST['worker_name'][$i]) ? $_POST['worker_name'][$i] : '',
                    'working_hrs' => isset($_POST['working_hrs'][$i]) ? $_POST['working_hrs'][$i] : '',
                    'totalsalary' => isset($_POST['totalsalary'][$i]) ? $_POST['totalsalary'][$i] : '',
                    'input' => isset($_POST['input'][$i]) ? $_POST['input'][$i] : '',
                    'output' => isset($_POST['output'][$i]) ? $_POST['output'][$i] : '',
                    'planing_output' => isset($_POST['planing_output'][$i]) ? $_POST['planing_output'][$i] : '',
                    'wastage' => isset($_POST['wastage'][$i]) ? $_POST['wastage'][$i] : '',
                    'labour_costing' => isset($_POST['labour_costing'][$i]) ? $_POST['labour_costing'][$i] : '',
                    'remarks' => isset($_POST['remarks'][$i]) ? $_POST['remarks'][$i] : ''
                ));
                $productionArray[$i]   = $productionArrayObject;
                //$productionArray[$i] = array_values($productionArrayObject);
                $i++;
                #$k++;
            }


            if (!empty($productionArray)) {
                foreach ($productionArray as $key => $pa) {
                    if (!empty($pa)) {
                        foreach ($pa as $paKey => $paValue) {
                            $i  = 0;
                            $aa = array();
                            if (!empty($paValue) && count($paValue) > 1) {
                                foreach ($paValue as $v) {
                                    #echo $i;
                                    $aa[$i] = $v;
                                    $i++;
                                }
                            } else {
                                $aa = $paValue;
                            }
                            $paValue    = $aa;
                            $pa[$paKey] = $paValue;
                        }
                    }
                    $productionArray[$key] = $pa;
                }
            }

            $productionData_array = json_encode($productionArray);
        } else {
            $productionData_array = '';
        }

        $workerArrayId = array();
        if (!empty($_POST['worker_name'])) {
            foreach ($_POST['worker_name'] as $workerIds) {
                foreach ($workerIds as $get_worker_id) {
                    foreach ($get_worker_id as $worker_id) {

                        $workerArrayId[] = $worker_id;
                    }
                }
            }
        }


        $workerIdsUpdate = implode("','", $workerArrayId);
        $workerIdsUpdate = "'" . $workerIdsUpdate . "'";


        #$productionData_array = json_encode($productionArray);
        if ($this->input->post()) {
            $required_fields = array(
                'machine_name_id'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data                    = $this->input->post();
                $data['production_data'] = $productionData_array;
                $data['no_of_dys']       = $_POST['no_of_dys'];
                #$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
                $data['created_by_cid']  = $this->companyId;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id ;
                $id                      = $data['id'];
               # pre($data);die;
                $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 23
                ));

                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;

                    $success = $this->production_model->update_data('production_data', $data, 'id', $id);
                    if ($workerIdsUpdate != "''")
                        updateMultipleUsedIdStatus('worker', $workerIdsUpdate);
                    if ($success) {

                        $production_data = $this->production_model->get_data_byId('production_data', 'id', $id);
                        $production_detail = json_decode($production_data->production_data);
                        if(!empty($production_detail)){                     
                        $k=0;
                        $out = 0;
                        foreach($production_detail as $productionDetail){

                        if(!empty($productionDetail)){
                        $wagesLength = isset($productionDetail->wages_or_per_piece)?(count($productionDetail->wages_or_per_piece)):0;
                        //$process_sch_output = array();
                        for($i=0; $i<$wagesLength; $i++){
                        //pre($productionDetail->output);
                        $material_qty = $productionDetail->output[$i][$i];
                        $jobCardData = isset($productionDetail->job_card_product_id[$i])?(getNameById('job_card',$productionDetail->job_card_product_id[$i],'id')):''; 
                     
                       $process = isset($productionDetail->process_name[$i])?getNameById('add_process',$productionDetail->process_name[$i],'id'):'';
                        $machine_details = json_decode($jobCardData->machine_details);
                         // pre($jobCardData);
                        $jcb_id = $jobCardData->id;
                         if($process->id != 0){
                          $key = array_search($process->id, array_column($machine_details, 'processess'));
                          if($key === 0 || $key >= 1){
                          $detail_info = $machine_details[$key];
                        $output_process_dtl = (!empty($detail_info->output_process) && isset($detail_info->output_process))?$detail_info->output_process:'';
                            $output_process_dtl = trim($output_process_dtl,'"');
                           $process_sch_output = json_decode($output_process_dtl,true);
                          
                         
                       foreach($process_sch_output as $val_output_sech){
                        $material_data = getNameById('material', $val_output_sech['material_output_name'],'id');
                        $job_data = getNameById('job_card', $material_data->job_card,'id');
                        $sub_job =  $job_data->job_card_no;  
                        $sub_job_data = $this->production_model->get_data_byId('job_card', 'job_card_no', $sub_job);
                        $material_info = json_decode($sub_job_data->material_details);
                        //pre($sub_job_data);
                        if(!empty($material_info)){
                         foreach($material_info as $key=> $materialInfo){
                             $quantity = $materialInfo->quantity;
                             $per_unit = $sub_job_data->lot_qty/$quantity;
                             $set_output = round($material_qty/$per_unit, 2);
                           $remain_output = $quantity-$set_output;
                           $material_info[$key]->quantity =  $remain_output;

                     }
                        $sub_job_data->material_details = json_encode($material_info);
                        //pre($sub_job_data);
                        $jobarray = json_decode(json_encode($sub_job_data), true);
                       $this->production_model->update_data('job_card', $jobarray, 'job_card_no', $sub_job);
                    }
                        //  $remain_output = $val_output_sech['quantity_output']-$productionDetail->output[$i][$out];
                        //  $process_sch_output[$out]["quantity_output"]=$remain_output;   
                        //  $process_sch_output = stripslashes(json_encode($process_sch_output));
                        //  $detail_info->output_process = stripslashes(json_encode($process_sch_output));
                        //  //pre($detail_info);
                        //  $jobCardData->machine_details = stripslashes(json_encode($detail_info));
                        //  $jobCardData->machine_details = json_encode($machine_details);
                        //  //pre($jobCardData);
                        //  $jobarray = json_decode(json_encode($jobCardData), true);
                        // // pre($jobarray);
                        // //echo $jcb_id;
                        //  //$this->production_model->update_data('job_card', $jobarray, 'id', $jcb_id);
                           
                          }
                          }
                          }  
                        

                        }
                        }
                        $out++; }
                        }
                       //die;
                        $data['message'] = "production data updated successfully";


                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {

                                    /*  pushNotification(array('subject'=> 'Production data updated' , 'message' => 'Production data updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id)); */
                                    pushNotification(array(
                                        'subject' => 'Production data updated',
                                        'message' => 'Production Data id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $userViewPermission['user_id'],
                                        'ref_id' => $id,
                                        'class' => 'productionTab',
                                        'data_id' => 'productView',
                                        'icon' => 'fa fa-archive'
                                    ));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {

                            /*pushNotification(array('subject'=> 'Production data updated' , 'message' => 'Production data updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/

                            pushNotification(array(
                                'subject' => 'Production data updated',
                                'message' => 'Production Data id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'class' => 'productionTab',
                                'data_id' => 'productView',
                                'icon' => 'fa fa-archive'
                            ));
                        }


                        logActivity('production data Updated', 'production_data', $id);
                        $this->session->set_flashdata('message', 'production data Updated successfully');
                        redirect(base_url() . 'production/production_data', 'refresh');
                    }
                } else {
                    $createdDateShift = $this->production_model->dateAndShiftExist('production_data', $_POST['date'], $_POST['shift'], 'update');
                    if ($createdDateShift) {
                        $this->session->set_flashdata('message', 'Production Data Already exist');
                        redirect(base_url() . 'production/production_data', 'refresh');
                    } else {
                        /*********************** Process Scheduling **********************/
                        /************************Inventory WIP (-) and WIP output (+) functionality********************************/
                        $out_val = array();
                        $out     = 0;
                        foreach ($_POST['output'] as $vaData) {
                            foreach ($vaData as $outputt) {
                                if (!empty($outputt)) {
                                    $out_val[$out]['output'] = $outputt;
                                    $out++;
                                }
                            }
                        }
                        foreach ($_POST['inpt_outpt_process'] as $valddata) {

                            foreach ($valddata as $mat_ids_qty) {
                                $data_mat = (json_decode($mat_ids_qty, true));
                                if (is_array($data_mat) || is_object($data_mat)) {
                                    $k         = 0;
                                    $input_val = array();
                                    foreach ($data_mat as $final_val) {
                                       # pre($final_val);
                                        $input_val[$k]['material_input_name'] = @$final_val['material_input_name'];
                                        $input_val[$k]['quantity_input']      = @$final_val['quantity_input'];
                                        $divdnt                               = '';
                                       foreach ($out_val as $outputfinal_val) {
                                            if (@$outputfinal_val['output'][$k] == 0 || @$final_val['quantity_output'] == 0) {
                                                // don't divide by zero, handle special case
                                            } else {
                                                $divdnt = (@$outputfinal_val['output'][$k]) / (@$final_val['quantity_output']);
                                               $totalvalue =  ($outputfinal_val['output'][$k] + @$final_val['quantity_output']);
                                                 $inventoryFlowDataArray = [];
                                                     $i = 0;
                                                    $arr = [];
                                                         $rt = 0;
                                                    $dataarray = array();
                                                     $mat_locations = $this->production_model->get_data('mat_locations', array('material_name_id' =>$final_val['material_output_name']));
                                                    $this->production_model->update_process_sechduling_plus_output($totalvalue, $final_val['material_output_name'], 'work_in_process_material');
                                                        foreach($mat_locations as $loc1){
                                                            $arr[] =  json_encode(array(array('location' => $loc1['location_id'],'Storage' => $loc1['Storage'] , 'RackNumber' => $loc1['RackNumber'] , 'quantity' => $totalvalue , 'Qtyuom' => $loc1['Qtyuom'])));
                                                               $rt++;
                                                        }
                                                        $inventoryFlowDataArray['current_location'] = $arr[$i];
                                                        $inventoryFlowDataArray['comment'] = implode("",$_POST['remarks'][$i]);
                                                        $inventoryFlowDataArray['material_id'] = $final_val['material_output_name'];
                                                        $inventoryFlowDataArray['material_in'] = $totalvalue;
                                                        $inventoryFlowDataArray['uom'] = $loc1['Qtyuom'];
                                                         $inventoryFlowDataArray['material_type_id'] = $loc1['material_type_id'];
                                                        $inventoryFlowDataArray['through'] = 'Production output (+) in WIP';
                                                        $inventoryFlowDataArray['ref_id'] = "0";
                                                        $inventoryFlowDataArray['created_by'] = $_SESSION['loggedInUser']->u_id;
                                                        $inventoryFlowDataArray['created_by_cid'] = $this->companyId;
                                                        #pre($inventoryFlowDataArray);
                                                        $this->production_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);
                                            }
                                         }
                                        $k++;
                                    }
                                }
                            }
                        }

                        foreach ($input_val as $in_Data){
                            if ($in_Data['material_input_name'] != '' && $in_Data['quantity_input'] != '') {
                                $getWIP = $this->production_model->get_data('work_in_process_material', array(
                                    'material_id' => $in_Data['material_input_name']
                                ));
                                foreach ($getWIP as &$values){
                                   # pre($values);
                                    if ($values['material_id'] == $in_Data['material_input_name']) {
                                        $mulidata           = $in_Data['quantity_input'] * $divdnt;
                                        $updatedQty         = $values['quantity'] - $mulidata;
                                          $this->production_model->update_process_sechduling_Data_minus_wipinput($updatedQty, $in_Data['material_input_name'], 'work_in_process_material');
                                       // break;
                                                    $inventoryFlowDataArray1 = [];
                                                     $i1 = 0;
                                                    $arr1 = [];
                                                         $rt1 = 0;
                                                    $dataarray1 = array();
                                                     $mat_locations1 = $this->production_model->get_data('mat_locations', array('material_name_id' =>$in_Data['material_input_name']));
                                                        foreach($mat_locations1 as $loc11){
                                                            $arr1[] =  json_encode(array(array('location' => $loc11['location_id'],'Storage' => $loc11['Storage'] , 'RackNumber' => $loc11['RackNumber'] , 'quantity' => $updatedQty , 'Qtyuom' => $loc11['Qtyuom'])));
                                                               $rt1++;
                                                        }
                                                        $inventoryFlowDataArray1['current_location'] = $arr1[$i1];
                                                        $inventoryFlowDataArray1['comment'] = implode("",$_POST['remarks'][$i1]);
                                                        $inventoryFlowDataArray1['material_id'] = $in_Data['material_input_name'];
                                                        $inventoryFlowDataArray1['material_out'] = $totalvalue;
                                                        $inventoryFlowDataArray1['material_type_id'] = $loc11['material_type_id'];
                                                        $inventoryFlowDataArray1['uom'] = $loc1['Qtyuom'];
                                                        $inventoryFlowDataArray1['through'] = 'Production Input (-) in WIP';
                                                        $inventoryFlowDataArray1['ref_id'] = "0";
                                                        $inventoryFlowDataArray1['created_by'] = $_SESSION['loggedInUser']->u_id;
                                                        $inventoryFlowDataArray1['created_by_cid'] = $this->companyId;
                                                        //pre($inventoryFlowDataArray);die();
                                                        $this->production_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray1);
                                    }
                                }
                            }
                        }
                       # die;
                        /************************Inventory WIP (-) and WIP output (+) functionality*********************************/
                        /*********************** Process Scheduling **********************/
                         // echo $_SESSION['loggedInUser']->u_id;
                       // pre($data);die;
                        $id = $this->production_model->insert_tbl_data('production_data', $data);
                        if ($workerIdsUpdate != "''")
                            updateMultipleUsedIdStatus('worker', $workerIdsUpdate);
                        /*if($data['planning_id'] !=''){
                        $this->production_model->update_prodData_single_data('production_planning','id',$data['planning_id']);
                        }*/
                        if ($id) {
                            logActivity('production data Added ', 'production_data', $id);
                            if (!empty($usersWithViewPermissions)) {
                                foreach ($usersWithViewPermissions as $userViewPermission) {
                                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {

                                        /*pushNotification(array('subject'=> 'Production data created' , 'message' => 'Production data created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                        pushNotification(array(
                                            'subject' => 'Production Data created',
                                            'message' => 'New Production Data is created by ' . $_SESSION['loggedInUser']->name,
                                            'from_id' => $_SESSION['loggedInUser']->u_id,
                                            'to_id' => $userViewPermission['user_id'],
                                            'ref_id' => $id,
                                            'class' => 'productionTab',
                                            'data_id' => 'productView',
                                            'icon' => 'fa fa-archive'
                                        ));
                                    }
                                }
                            }
                            if ($_SESSION['loggedInUser']->role != 1) {
                                /*pushNotification(array('subject'=> 'Production data created' , 'message' => 'Production data created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                                pushNotification(array(
                                    'subject' => 'Production Data created',
                                    'message' => 'New Production Data is created by ' . $_SESSION['loggedInUser']->name,
                                    'from_id' => $_SESSION['loggedInUser']->u_id,
                                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                                    'ref_id' => $id,
                                    'class' => 'productionTab',
                                    'data_id' => 'productView',
                                    'icon' => 'fa fa-archive'
                                ));
                            }
                            #die;
                            $this->session->set_flashdata('message', 'production data Added successfully');
                            redirect(base_url() . 'production/production_data', 'refresh');
                        }
                    }
                }
            }
        }
    }

    public function BomRoutingView_dtls()
    {
        $id                     = $_POST['id'];
        $this->data['bom_View'] = $this->production_model->get_data_byId('job_card', 'id', $id);
        $this->load->view('Job_card/bom_dtl', $this->data);
    }
    public function bomroutingview_onclick()
    {
        $material_id        = $_POST['mat_id'];
        $mat_detail         = $this->production_model->get_data_byId('material', 'id', $material_id);
        $mat_jobcard        = $mat_detail->job_card;
        $jobcard_details    = $this->production_model->get_data_byId('job_card', 'id', $mat_jobcard);
        $input_process_dtls = json_decode($jobcard_details->machine_details);
        $html               = '';
        foreach ($input_process_dtls as $processDetail) {
            if ($processDetail->input_process != '') {
                $inp_process2 = json_decode($processDetail->input_process, true);

                foreach ($inp_process2 as $in_val2) {
                    $mat_type_name = getNameById('material_type', $in_val2['material_type_input_id'], 'id');
                    $mat_name      = getNameById('material', $in_val2['material_input_name'], 'id');
                    if (empty($in_val2)) {
                        $mat_namee_type = '';
                    } else {
                        $mat_namee_type = $mat_type_name->name;
                    }
                    if (empty($in_val2)) {
                        $matreal_name = '';
                    } else {
                        $matreal_name = $mat_name->material_name;
                    }
                    $qty_and_val = $in_val2['quantity_input'] . ' / ' . $in_val2['uom_value_input'];
                    $cost_in     = $in_val2['quantity_input'] * $mat_name->cost_price;
                    $sum += $cost_in;
                    $html = '<div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <div style="border-left:1px solid #c1c1c1 !important;" class="tab-div">' . $mat_namee_type . '</div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <div style="border-left:1px solid #c1c1c1 !important;" class="tab-div get_mat_data_id_cls" data-id="' . $mat_name->id . '">' . $matreal_name . '</div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <div  class="tab-div">' . $qty_and_val . '</div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <div  class="tab-div">' . $cost_in . '</div>
                        <input type="hidden" value="' . $cost_in . '" class="cost_cls">
                    </div>';

                }
            }
        }
        echo $html;


    }














    public function production_data_delete($id = '')
    {
        if (!$id) {
            redirect('production/production_data', 'refresh');
        }
        //permissions_redirect('is_delete');
        $result = $this->production_model->delete_data('production_data', 'id', $id);
        if ($result) {
            logActivity('Production Data  Deleted', 'production_data', $id);
            $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                'is_view' => 1,
                'sub_module_id' => 23
            ));

            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        /*pushNotification(array('subject'=> 'Production data deleted' , 'message' => 'Production data deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                        pushNotification(array(
                            'subject' => 'Production Data deleted',
                            'message' => 'Production Data  id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                            'from_id' => $_SESSION['loggedInUser']->u_id,
                            'to_id' => $userViewPermission['user_id'],
                            'ref_id' => $id,
                            'icon' => 'fa fa-archive'
                        ));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                /*  pushNotification(array('subject'=> 'Production data deleted' , 'message' => 'Production data deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                pushNotification(array(
                    'subject' => 'Production Data deleted',
                    'message' => 'Production Data  id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                    'from_id' => $_SESSION['loggedInUser']->u_id,
                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                    'ref_id' => $id,
                    'icon' => 'fa fa-archive'
                ));
            }
            $this->session->set_flashdata('message', 'Production Data Deleted Successfully');
            $result = array(
                'msg' => 'Production Data Deleted Successfully',
                'status' => 'success',
                'code' => 'C142',
                'url' => base_url() . 'production/production_data'
            );
            echo json_encode($result);
        } else {
            echo json_encode(array(
                'msg' => 'error',
                'status' => 'error',
                'code' => 'C1004'
            ));
        }
    }

    public function filterProductionData()
    {
        $activityResult      = $this->production_model->productionFilter($_POST['fromDate'], $_POST['toDate'], 'production_data');
        $activityArray       = array();
        $activityResultCount = count($activityResult);
        for ($i = 0; $i < $activityResultCount; $i++) {
            $activityArray[$i] = $activityResult[$i];
        }
        echo json_encode($activityArray);
    }

    public function production_data_view()
    {
        $id                           = $_POST['id'];
        $this->data['productionView'] = $this->production_model->get_data_byId('production_data', 'id', $id);
        $this->load->view('production_data/view', $this->data);
    }
    /* edit similar production data*/
    public function Add_SimilarProdData_edit()
    {
        $this->breadcrumb->add('Production Data', base_url() . 'production_data');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Simillar Production Data';
        $id = $_GET['id'];
        #$id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where                                = array(
            'add_machine.created_by_cid' => $this->companyId
        );
        #$machineWhere = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id,'add_machine.save_status' => 1);
        $machineWhere                         = array(
            'add_machine.created_by_cid' => $this->companyId,
            'add_machine.save_status' => 1
        );
        $this->data['machineName']            = $this->production_model->get_data('add_machine', $machineWhere);
        //$this->data['production_data'] = $this->production_model->get_data_byId('production_data','id',$id);
        $this->data['production_data']        = $this->production_model->get_dataWithProdSetting_byId('production_data', 'id', $id);
        #$where = array('production_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where                                = array(
            'production_setting.created_by_cid' => $this->companyId
        );
        $this->data['productionSetting']      = $this->production_model->get_data('production_setting', $where);
        #$productionSettingWageswhere = array('wages_perpiece_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $productionSettingWageswhere          = array(
            'wages_perpiece_setting.created_by_cid' => $this->companyId
        );
        $this->data['productionSettingWages'] = $this->production_model->get_data('wages_perpiece_setting', $productionSettingWageswhere);
        #$where1 = array('electricity_unit.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where1                               = array(
            'electricity_unit.created_by_cid' => $this->companyId
        );
        $this->data['electr_unit_price']      = $this->production_model->get_data('electricity_unit', $where1);
       $this->_render_template('production_data/add_similar_prod_data', $this->data);
    }

    /* edit similar production data*/
    public function Add_SimilarPlanning_edit()
    {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where                           = array(
            'add_machine.created_by_cid' => $this->companyId
        );
        #$machineWhere = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id,'add_machine.save_status' => 1);
        $machineWhere                    = array(
            'add_machine.created_by_cid' => $this->companyId,
            'add_machine.save_status' => 1
        );
        $this->data['machineName']       = $this->production_model->get_data('add_machine', $machineWhere);
        $this->data['production_data']   = $this->production_model->get_data_byId('production_data', 'id', $id);
        #$where = array('production_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where                           = array(
            'production_setting.created_by_cid' => $this->companyId
        );
        $this->data['productionSetting'] = $this->production_model->get_data('production_setting', $where);
        $this->load->view('production_data/add_similar_planning', $this->data);
    }

    /* convert to  production data from production planning */
    public function convert_to_production()
    {
        $this->breadcrumb->add('Production Data', base_url() . 'production_planning');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Convert to production Data';
        $id = $_GET['id'];
       # $id                                = $_POST['id'];
        #$where = array('production_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where                             = array(
            'production_setting.created_by_cid' => $this->companyId
        );
        $this->data['productionSetting']   = $this->production_model->get_data('production_setting', $where);
        #$machineWhere = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id,'add_machine.save_status' => 1 );
        $machineWhere                      = array(
            'add_machine.created_by_cid' => $this->companyId,
            'add_machine.save_status' => 1
        );
        $this->data['machineName']         = $this->production_model->get_data('add_machine', $machineWhere);
        //$this->data['convert_to_prodData'] = $this->production_model->get_data_byId('production_planning','id',$id);
        $this->data['convert_to_prodData'] = $this->production_model->get_dataIn_ProdConversion_byId('production_planning', 'id', $id);
        #$where1 = array('wages_perpiece_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where1                            = array(
            'wages_perpiece_setting.created_by_cid' => $this->companyId
        );
        $this->data['wages_perpiece']      = $this->production_model->get_data('wages_perpiece_setting', $where1);
        // $where1 = array('electricity_unit.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        // $this->data['electr_unit_price'] = $this->production_model->get_data('electricity_unit',$where1);
        $this->_render_template('production_planning/convert_to_prod_data', $this->data);
    }
    /***********************************************production planning******************************************/
    public function production_planning()
    {
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Production Planning', base_url() . 'production_planning');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Production Planning';
        $where   = array('production_planning.created_by_cid' => $this->companyId);
         if (isset($_GET['favourites'])!='' && isset($_GET['ExportType'])=='') {
            #$where = array('production_planning.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'production_planning.favourite_sts' =>1);
            $where   = array('production_planning.created_by_cid' => $this->companyId,
                'production_planning.favourite_sts' => 1 );

        }
         if ($_GET['start']!= '' && $_GET['end']!= '' && $_GET['favourites']=='' ) {
                #$where = array('production_planning.created_by_cid' => $_SESSION['loggedInUser']->c_id);
                $where                        = array(
                    'production_planning.created_date >=' => $_GET['start'],
                    'production_planning.created_date <=' => $_GET['end'],
                    'production_planning.created_by_cid' => $this->companyId
                );
                }

            if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites']=='' ) {
                #$where = array('production_planning.created_by_cid' => $_SESSION['loggedInUser']->c_id);
                $where  = array('production_planning.created_by_cid' => $this->companyId );
                }
                else if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites']!='' ) {
                #$where = array('production_planning.created_by_cid' => $_SESSION['loggedInUser']->c_id);
                 $where   = array('production_planning.created_by_cid' => $this->companyId,
                'production_planning.favourite_sts' => 1 );
                }
                else if (isset($_GET["ExportType"]) && $_GET['start']!= '' && $_GET['end']!= '' && $_GET['favourites']=='' ) {
                #$where = array('production_planning.created_by_cid' => $_SESSION['loggedInUser']->c_id);
                $where                        = array(
                    'production_planning.created_date >=' => $_GET['start'],
                    'production_planning.created_date <=' => $_GET['end'],
                    'production_planning.created_by_cid' => $this->companyId
                );
                }



        //Search
        $where2                        = '';
        $search_string                 = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $machineName=getNameById('add_machine',$search_string,'machine_name');
                if(!empty($machineName->id)){
                    $json_dtl ='{"machine_name_id" : "'.$machineName->id.'"}';
                    $where2 = "json_contains(`planning_data`, '".$json_dtl."') group by id" ;
                }else{
            $where2        = "(production_planning.id like'%" . $search_string . "%' or production_planning.supervisor_name like'%" . $search_string . "%')";
                }
            redirect("production/production_planning/?search=$search_string");
        } else if (isset($_GET['search'])&& $_GET['search']!='') {
            $machineName=getNameById('add_machine',$_GET['search'],'machine_name');
                if(!empty($machineName->id)){
                    $json_dtl ='{"machine_name_id" : "'.$machineName->id.'"}';
                    $where2 = "json_contains(`planning_data`, '".$json_dtl."')  group by id" ;
                }else{
            $where2 = "(production_planning.supervisor_name like'%" . $_GET['search'] . "%' or production_planning.id like'%" . $_GET['search'] . "%')";
                }
        }

        if (!empty($_GET['order'])) {
            $order = $_GET['order'];

        } else {
            $order = "desc";
        }
        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "production/production_planning/";
        $config["total_rows"]         = $this->production_model->num_rows('production_planning', $where, $where2);
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
         if(!empty($_GET['ExportType'])){
            $export_data = 1;
        }else{
            $export_data = 0;
        }
        $this->data['productionPlan'] = $this->production_model->get_data1('production_planning', $where, $config["per_page"], $page, $where2, $order,$export_data);
        if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }

        $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';

        $this->_render_template('production_planning/index', $this->data);

            /*if(!empty($_GET)){
            $this->load->view('production_planning/index', $this->data);
            }else{
            $this->_render_template('production_planning/index', $this->data);
            }   */

    }

    public function production_planning_edit(){
        $this->breadcrumb->add('Production Planning', base_url() . 'production_planning');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Production Planning';
        $id = $_GET['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->breadcrumb->add('Production', base_url() . 'production/production_planning');
        $this->breadcrumb->add($id ? 'Edit' : 'Add', base_url() . 'production_planning/' . $id ? 'Edit' : 'Add');
        $this->settings['breadcrumbs']   = $this->breadcrumb->output();
        $this->settings['pageTitle']     = $id ? 'Production planning Edit' : 'Production planning Add';
        #$where = array('production_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where                           = array(
            'production_setting.created_by_cid' => $this->companyId
        );
        $this->data['productionSetting'] = $this->production_model->get_data('production_setting', $where);
        #$machineWhere = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id,'add_machine.save_status' => 1 );
        $machineWhere                    = array(
            'add_machine.created_by_cid' => $this->companyId,
            'add_machine.save_status' => 1
        );
        $this->data['machineName']       = $this->production_model->get_data('add_machine', $machineWhere);
        $this->data['production_plan']   = $this->production_model->get_data_byId('production_planning', 'id', $id);
        $this->_render_template('production_planning/edit', $this->data);
    }

    /*save production data*/
    /*public function saveProductionPlanning(){
    $productionPlan_dataLength = (isset($_POST['machine_name_id']))?count($_POST['machine_name_id']):0;
    #pre($productionPlan_dataLength); die;
    if($productionPlan_dataLength >0){
    $planningArray = [];
    $j = 0;
    while($j < $productionPlan_dataLength) {
    // $PlanningArrayObject = (array('machine_name_id' => isset($_POST['machine_name_id'][$j])?$_POST['machine_name_id'][$j]:'' , 'job_card_product_name' => isset($_POST['job_card_product_name'][$j])?$_POST['job_card_product_name'][$j]:'','specification' => isset($_POST['specification'])?$_POST['specification']:'', 'worker' => isset($_POST['worker_name'][$j])?$_POST['worker_name'][$j]:'' ,'output' => isset($_POST['output'][$j])?$_POST['output'][$j]:''));
    $PlanningArrayObject = (array('machine_name_id' => isset($_POST['machine_name_id'][$j])?$_POST['machine_name_id'][$j]:'' , 'machine_grp' => isset($_POST['machine_grp'][$j])?$_POST['machine_grp'][$j]:'' ,'job_card_product_name' => isset($_POST['job_card_product_name'][$j])?$_POST['job_card_product_name'][$j]:'','specification' => isset($_POST['specification'][$j])?$_POST['specification'][$j]:'', 'worker' => isset($_POST['worker_name'][$j])?$_POST['worker_name'][$j]:'' ,'output' => isset($_POST['output'][$j])?$_POST['output'][$j]:''));


    $planningArray[$j] = $PlanningArrayObject;
    $j++;
    }
    $productionPlan_array = json_encode($planningArray);
    }else{
    $productionPlan_array = '';
    /*$this->session->set_flashdata('message', 'Machine name is required');
    redirect(base_url().'production/production_planning', 'refresh');
    return;*/
    //}
    //pre($productionPlan_array);
    #pre($planningArray);
    #die;
    /*$workerArrayId =array();
    if(!empty($_POST['worker_name'])){
    foreach($_POST['worker_name'] as $workerIds){
    foreach($workerIds as $get_worker_id){
    $workerArrayId[] = $get_worker_id;
    }
    }
    }
    $workerIdsUpdate = implode("','",$workerArrayId);
    $workerIdsUpdate = "'".$workerIdsUpdate."'";*/

    //pre($_POST); die;
    /*planning',$_POST['date'],$_POST['shift'], 'update');
    if($createdDateShift){
    $this->session->set_flashdata('message', 'Production Planning Already exist');
    redirect(base_url().'production/production_planning', 'refresh');
    }else{
    $id = $this->production_model->insert_tbl_data('production_planning',$data);
    if($machineNameUpdateIds !="''")  updateMultipleUsedIdStatus('add_machine',$machineNameUpdateIds);
    if($jobCardUpdateIds !="''"  && $jobCardUpdateIds != '')  updateMultipleUsedIdStatus('job_card',$jobCardUpdateIds);
    //if($workerIdsUpdate !="''")  updateMultipleUsedIdStatus('wodateIds."'";

    if(isset($data['job_card_product_name']) && !empty($data['job_card_product_name'])){
    $jobCardUpdateIds = implode("','", $data['job_card_product_name']);
    $jobCardUpdateIds = "'".$jobCardUpdateIds."'";
    }else{
    $jobCardUpdateIds = '';
    }


    if($id && $id != ''){
    $data['edited_by'] =$_SESSION['loggedInUser']->u_id;
    $success = $this->production_model->update_data('production_planning',$data, 'id', $id);
    if($machineNameUpdateIds !="''")  updateMultipleUsedIdStatus('add_machine',$machineNameUpdateIds);


    if($jobCardUpdateIds !="''"  && $jobCardUpdateIds != '')  updateMultipleUsedIdStatus('job_card',$jobCardUpdateIds);
    //if($workerIdsUpdate !="''")  updateMultipleUsedIdStatus('worker',$workerIdsUpdate);
    if($data['department_id'] != '') updateUsedIdStatus('department',$data['department_id']);
    if($data['shift'] != '') updateUsedIdStatus('production_setting',$data['shift']);

    if ($success) {
    $data['message'] = "production Planning updated successfully";
    logActivity('production data Updated','production_planning',$id);
    $this->session->set_flashdata('message', 'Production Planning Updated successfully');
    redirect(base_url().'production/production_planning', 'refresh');
    }
    }else{
    $createdDateShift = $this->production_model->dateAndShiftExist('production_planning',$_POST['date'],$_POST['shift'], 'update');
    if($createdDateShift){
    $this->session->set_flashdata('message', 'Production Planning Already exist');
    redirect(base_url().'production/production_planning', 'refresh');
    }else{
    $id = $this->production_model->insert_tbl_data('production_planning',$data);
    if($machineNameUpdateIds !="''")  updateMultipleUsedIdStatus('add_machine',$machineNameUpdateIds);
    if($jobCardUpdateIds !="''"  && $jobCardUpdateIds != '')  updateMultipleUsedIdStatus('job_card',$jobCardUpdateIds);
    //if($workerIdsUpdate !="''")  updateMultipleUsedIdStatus('worker',$workerIdsUpdate);
    if($data['department_id'] != '') updateUsedIdStatus('department',$data['department_id']);
    if($data['shift'] != '') updateUsedIdStatus('production_setting',$data['shift']);
    if ($id) {
    logActivity('production data Added ','production_planning',$id);
    $this->session->set_flashdata('message', 'Production Planning Added successfully');
    redirect(base_url().'production/production_planning', 'refresh');
    }
    }
    }
    }
    }
    }
    */
    /*save production data*/
    public function saveProductionPlanning()
    {
       // pre($_POST); die;
        $productionPlan_dataLength = (isset($_POST['machine_name_id'])) ? count($_POST['machine_name_id']) : 0;
        #pre($productionPlan_dataLength); die;
        //pre($_POST['work_order']);pre($_POST['product_name']);die;
        if ($productionPlan_dataLength > 0) {
            $planningArray = array();
            $j             = 0;
            while ($j < $productionPlan_dataLength) {
                // $PlanningArrayObject = (array('machine_name_id' => isset($_POST['machine_name_id'][$j])?$_POST['machine_name_id'][$j]:'' , 'job_card_product_name' => isset($_POST['job_card_product_name'][$j])?$_POST['job_card_product_name'][$j]:'','specification' => isset($_POST['specification'])?$_POST['specification']:'', 'worker' => isset($_POST['worker_name'][$j])?$_POST['worker_name'][$j]:'' ,'output' => isset($_POST['output'][$j])?$_POST['output'][$j]:''));
                $PlanningArrayObject = (array(
                    'machine_name_id' => isset($_POST['machine_name_id'][$j]) ? $_POST['machine_name_id'][$j] : '',
                    'machine_grp' => isset($_POST['machine_grp'][$j]) ? $_POST['machine_grp'][$j] : '',
                    'sale_order' => isset($_POST['sale_order'][$j]) ? $_POST['sale_order'][$j] : '',
                    'work_order' => isset($_POST['work_order'][$j]) ? $_POST['work_order'][$j] : '',
                    'product_name' => isset($_POST['product_name'][$j]) ? $_POST['product_name'][$j] : '',
                    'job_card_product_id' => isset($_POST['job_card_product_id'][$j]) ? $_POST['job_card_product_id'][$j] : '',
                    'process_name' => isset($_POST['process_name'][$j]) ? $_POST['process_name'][$j] : '',
                    'npdm' => isset($_POST['npdm_name'][$j]) ? $_POST['npdm_name'][$j] : '',
                    'specification' => isset($_POST['specification'][$j]) ? $_POST['specification'][$j] : '',
                    'worker' => isset($_POST['worker_name'][$j]) ? $_POST['worker_name'][$j] : '',
                    'output' => isset($_POST['output'][$j]) ? $_POST['output'][$j] : ''
                ));


                $planningArray[$j] = $PlanningArrayObject;
                $j++;
            }
            //$productionPlan_array = json_encode($planningArray);
            if (!empty($planningArray)) {
                foreach ($planningArray as $key => $pa) {
                    if (!empty($pa)) {
                        foreach ($pa as $paKey => $paValue) {
                            $i  = 0;
                            $aa = array();
                            if (!empty($paValue) && count($paValue) > 1) {
                                foreach ($paValue as $v) {
                                    //echo $i;
                                    $aa[$i] = $v;
                                    $i++;
                                }
                            } else {
                                $aa = $paValue;
                            }
                            $paValue    = $aa;
                            $pa[$paKey] = $paValue;
                        }
                    }
                    $planningArray[$key] = $pa;
                }
            }
            //pre($planningArray);die;
            $productionPlan_array = json_encode($planningArray);
        } else {
            $productionPlan_array = '';
        }
        $workerArrayId = array();
        if (!empty($_POST['worker_name'])) {
            foreach ($_POST['worker_name'] as $workerIds) {
                foreach ($workerIds as $get_worker_id) {
                    foreach ($get_worker_id as $worker_id) {

                        $workerArrayId[] = $worker_id;
                    }
                }
            }
        }


        $workerIdsUpdate = implode("','", $workerArrayId);
        $workerIdsUpdate = "'" . $workerIdsUpdate . "'";

        if ($this->input->post()) {
            $required_fields = array(
                'machine_name_id'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();

                #pre($productionPlan_array);
                #die;

                $data['planning_data']  = $productionPlan_array;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id ;
                $data['created_by_cid'] = $this->companyId;
                $id                     = $data['id'];

                //$machineNameUpdateIds = implode("','", $data['machine_name_id']);
                //$machineNameUpdateIds = "'".$machineNameUpdateIds."'";
                // $jobCardUpdateIds = implode("','", $data['job_card_product_name']);
                // $jobCardUpdateIds = "'".$jobCardUpdateIds."'";

                /*if(isset($data['job_card_product_name']) && !empty($data['job_card_product_name'])){
                $jobCardUpdateIds = implode("','", $data['job_card_product_name']);
                $jobCardUpdateIds = "'".$jobCardUpdateIds."'";
                }else{
                $jobCardUpdateIds = '';
                }*/
                $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 22
                ));

                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success           = $this->production_model->update_data('production_planning', $data, 'id', $id);
                    //if($machineNameUpdateIds !="''")  updateMultipleUsedIdStatus('add_machine',$machineNameUpdateIds);


                    //if($jobCardUpdateIds !="''"  && $jobCardUpdateIds != '')  updateMultipleUsedIdStatus('job_card',$jobCardUpdateIds);
                    if ($workerIdsUpdate != "''")
                        updateMultipleUsedIdStatus('worker', $workerIdsUpdate);
                    if ($data['department_id'] != '')
                        updateUsedIdStatus('department', $data['department_id']);
                    if ($data['shift'] != '')
                        updateUsedIdStatus('production_setting', $data['shift']);

                    if ($success) {
                        $data['message'] = "production Planning updated successfully";
                        logActivity('production planning Updated', 'production_planning', $id);


                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {

                                    /*pushNotification(array('subject'=> 'Production planning updated' , 'message' => 'Production planning updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/


                                    pushNotification(array(
                                        'subject' => 'Production Planning updated',
                                        'message' => 'Production Planning id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $_SESSION['loggedInCompany']->u_id,
                                        'ref_id' => $id,
                                        'class' => 'productionTab',
                                        'data_id' => 'productionPlanView',
                                        'icon' => 'fa fa-archive'
                                    ));


                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {

                            /*pushNotification(array('subject'=> 'Production planning updated' , 'message' => 'Production planning updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/


                            pushNotification(array(
                                'subject' => 'Production Planning updated',
                                'message' => 'Production Planning id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'ref_id' => $id,
                                'class' => 'productionTab',
                                'data_id' => 'productionPlanView',
                                'icon' => 'fa fa-archive'
                            ));

                        }




                        $this->session->set_flashdata('message', 'Production Planning Updated successfully');
                        redirect(base_url() . 'production/production_planning', 'refresh');
                    }
                } else {
                    $createdDateShift = $this->production_model->dateAndShiftExist('production_planning', $_POST['date'], $_POST['shift'], 'update');
                    if ($createdDateShift) {
                        $this->session->set_flashdata('message', 'Production Planning Already exist');
                        redirect(base_url() . 'production/production_planning', 'refresh');
                    } else {

                        $id = $this->production_model->insert_tbl_data('production_planning', $data);
                        //if($machineNameUpdateIds !="''")  updateMultipleUsedIdStatus('add_machine',$machineNameUpdateIds);
                        //if($jobCardUpdateIds !="''"  && $jobCardUpdateIds != '')  updateMultipleUsedIdStatus('job_card',$jobCardUpdateIds);
                        if ($workerIdsUpdate != "''")
                            updateMultipleUsedIdStatus('worker', $workerIdsUpdate);
                        if ($data['department_id'] != '')
                            updateUsedIdStatus('department', $data['department_id']);
                        if ($data['shift'] != '')
                            updateUsedIdStatus('production_setting', $data['shift']);
                        if ($id) {
                            logActivity('production planning Added ', 'production_planning', $id);
                            if (!empty($usersWithViewPermissions)) {
                                foreach ($usersWithViewPermissions as $userViewPermission) {
                                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                        /*pushNotification(array('subject'=> 'Production planning created' , 'message' => 'Production planning created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                        pushNotification(array(
                                            'subject' => 'Production Planning created',
                                            'message' => 'New Production Planning is created by ' . $_SESSION['loggedInUser']->name,
                                            'from_id' => $_SESSION['loggedInUser']->u_id,
                                            'to_id' => $userViewPermission['user_id'],
                                            'ref_id' => $id,
                                            'class' => 'productionTab',
                                            'data_id' => 'productionPlanView',
                                            'icon' => 'fa fa-archive'
                                        ));
                                    }
                                }
                            }

                            if ($_SESSION['loggedInUser']->role != 1) {
                                /*pushNotification(array('subject'=> 'Production planning created' , 'message' => 'Production planning created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                                pushNotification(array(
                                    'subject' => 'Production Planning created',
                                    'message' => 'New Production Planning is created by ' . $_SESSION['loggedInUser']->name,
                                    'from_id' => $_SESSION['loggedInUser']->u_id,
                                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                                    'ref_id' => $id,
                                    'class' => 'productionTab',
                                    'data_id' => 'productionPlanView',
                                    'icon' => 'fa fa-archive'
                                ));
                            }
                            $this->session->set_flashdata('message', 'Production Planning Added successfully');
                            redirect(base_url() . 'production/production_planning', 'refresh');
                        }
                    }
                }
            }
        }
    }

    /*delete planning */
    public function deleteProductionplanning($id = '')
    {
        if (!$id) {
            redirect('production/production_planning', 'refresh');
        }
        //permissions_redirect('is_delete');
        $result = $this->production_model->delete_data('production_planning', 'id', $id);
        if ($result) {
            logActivity('Production Planning  Deleted', 'production_planning', $id);
            $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                'is_view' => 1,
                'sub_module_id' => 22
            ));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        /*pushNotification(array('subject'=> 'Production planning deleted' , 'message' => 'Production planning deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                        pushNotification(array(
                            'subject' => 'Production Planning deleted',
                            'message' => 'Production Planning id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                            'from_id' => $_SESSION['loggedInUser']->u_id,
                            'to_id' => $userViewPermission['user_id'],
                            'ref_id' => $id,
                            'icon' => 'fa fa-archive'
                        ));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                /*pushNotification(array('subject'=> 'Production planning deleted' , 'message' => 'Production planning deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                pushNotification(array(
                    'subject' => 'Production Planning deleted',
                    'message' => 'Production Planning id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                    'from_id' => $_SESSION['loggedInUser']->u_id,
                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                    'ref_id' => $id,
                    'icon' => 'fa fa-archive'
                ));
            }
            $this->session->set_flashdata('message', 'Production Planning Deleted Successfully');
            $result = array(
                'msg' => 'Production Planning Deleted Successfully',
                'status' => 'success',
                'code' => 'C142',
                'url' => base_url() . 'production/production_planning'
            );
            echo json_encode($result);
        } else {
            echo json_encode(array(
                'msg' => 'error',
                'status' => 'error',
                'code' => 'C1004'
            ));
        }
    }

    public function production_planning_view()
    {
        $id                         = $_POST['id'];
        $this->data['planningView'] = $this->production_model->get_data_byId('production_planning', 'id', $id);
        $this->load->view('production_planning/view', $this->data);
    }

    public function productionPlanViewmachineview(){

        $id                         = $_POST['id'];
        $this->data['planningView'] = $this->production_model->get_data_byId('production_planning', 'id', $id);
        $this->load->view('production_planning/machineview', $this->data);
    }
    public function filterProductionPlanning()
    {
        $activityResult      = $this->production_model->productionFilter($_POST['fromDate'], $_POST['toDate'], 'production_planning');
        $activityArray       = array();
        $activityResultCount = count($activityResult);
        for ($i = 0; $i < $activityResultCount; $i++) {
            $activityArray[$i] = $activityResult[$i];
            /*$attachments  = getAttachmentsById('attachments',$activityResult[$i]['id'],$_POST['table']);
            $activityArray[$i]['attachment']     = $attachments;*/
        }
        echo json_encode($activityArray);
    }

    public function Add_SimilarProdPlan_edit()
    {
        #$this->breadcrumb->add('Production Planning', base_url() . 'production_planning');
       # $this->settings['breadcrumbs'] = $this->breadcrumb->output();
       #$this->settings['pageTitle']   = 'Production Planning';
        $id = $_GET['id'];
        #$id = $_POST['id'];
        //pre($id);
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->breadcrumb->add('Production', base_url() . 'production/production_planning');
        $this->breadcrumb->add($id ? 'Edit' : 'Add', base_url() . 'production_planning/' . $id ? 'Edit' : 'Add');
        $this->settings['breadcrumbs']   = $this->breadcrumb->output();
        $this->settings['pageTitle']     = $id ? 'Production planning Edit' : 'Similar Production planning Add';
        #$where = array('production_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where                           = array(
            'production_setting.created_by_cid' => $this->companyId
        );
        $this->data['productionSetting'] = $this->production_model->get_data('production_setting', $where);
        #$machineWhere = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id,'add_machine.save_status' => 1 );
        $machineWhere                    = array(
            'add_machine.created_by_cid' => $this->companyId,
            'add_machine.save_status' => 1
        );
        $this->data['machineName']       = $this->production_model->get_data('add_machine', $machineWhere);
        $this->data['production_plan']   = $this->production_model->get_data_byId('production_planning', 'id', $id);
        $this->_render_template('production_planning/add_similar_prod_plan', $this->data);
    }


    /*production setting*/
    public function production_setting()
    {
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Production setting', base_url() . 'production_setting');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Production Setting';
        //$where = array('production_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        #$companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
        //Search
        $where1                        = '';
        $where2                        = '';
        $where3                        = '';
        $where4                        = '';
        $where5                        = '';
        $search_string                 = '';

        if( !isset($_GET['tab']) ){
            $_GET['tab'] = '';
        }

        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            if($_GET['tab']=='shift_setting1')
            {
                $dept=getNameById('department',$search_string,'name');
                if($dept->id == ''){
                    $where1 = "(production_setting.id = '" . $search_string . "' OR production_setting.shift_name like '%" . $search_string . "%')";
                }elseif($dept->id != ''){
                    $where1 = "(production_setting.department like '%" .$dept->id . "%')";
                }
        }
        if($_GET['tab']=='department_setting1')
            {
                $where2 = "(department.id = '" .$_GET['search']. "' OR department.name like '%" .$_GET['search']. "%' OR department.unit_name like '%" .$_GET['search']. "%')";
        }
        if($_GET['tab']=='machinegrouping1'){
            $where3        = "(machine_group.id = '%".$search_string."%' OR machine_group.machine_group_name like '%".$search_string. "%')";
        }
            $where4        = "add_machine.id = '" . $search_string . "'";
        if($_GET['tab']=='wages_per_pice'){
                 $dept=getNameById('department',$search_string,'name');
                if($dept->id == ''){
                    $where5 ="(wages_perpiece_setting.id = '" .$search_string. "' OR wages_perpiece_setting.wages_perpiece like '%" .$search_string. "%')";
                }elseif($dept->id != ''){
                    $where5 = "(wages_perpiece_setting.department like '%" .$dept->id. "%')";
                }
             }
            redirect("production/production_setting?tab=".$_GET['tab']."&&search=$search_string");
        }
        else if (isset($_GET['search'])) {
                if($_GET['tab']=='shift_setting1' || $_GET['tab']=='' && $_GET['tab']!='department_setting1' && $_GET['tab']!='machinegrouping1' && $_GET['tab']!='wages_per_pice')
            {
                $dept=getNameById('department',$_GET['search'],'name');
                if($dept->id == ''){
                    $where1 ="(production_setting.id = '" . $_GET['search']  . "' OR production_setting.shift_name ='" .$_GET['search'] . "')";
                }elseif($dept->id != ''){
                    $where1 = "(production_setting.department = '" .$dept->id. "')";
                }
        }
        if($_GET['tab']=='department_setting1' && $_GET['tab']!='shift_setting1' && $_GET['tab']!='machinegrouping1' && $_GET['tab']!='wages_per_pice')
            {
          $where2 = "(department.id = '" .$_GET['search']. "' OR department.name like '%" .$_GET['search']. "%' OR department.unit_name like '%" .$_GET['search']. "%')";
        }
            if($_GET['tab']=='machinegrouping1' && $_GET['tab']!='shift_setting1' && $_GET['tab']!='department_setting1' && $_GET['tab']!='wages_per_pice'){
            $where3        = "(machine_group.id = '".$_GET['search']."' OR machine_group.machine_group_name like '%".$_GET['search']. "%')";
        }
           // $where4 = "(add_machine.id = '" . $_GET['search'] . "')";
             if($_GET['tab']=='wages_per_pice' && $_GET['tab']!='shift_setting1' && $_GET['tab']!='department_setting1' && $_GET['tab']!='machinegrouping1'){
                 $dept=getNameById('department',$_GET['search'],'name');
                if($dept->id == ''){
                    $where5 ="(wages_perpiece_setting.id = '" . $_GET['search'] . "' OR wages_perpiece_setting.wages_perpiece like '%" . $_GET['search'] . "%')";
                }elseif($dept->id != ''){
                    $where5 = "(wages_perpiece_setting.department like '%" .$dept->id. "%')";
                }
             }
        }

        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        if ($_GET['tab'] == 'shift_setting1'&& $_GET['tab']!='department_setting1' && $_GET['tab']!='machinegrouping1' && $_GET['tab']!='wages_per_pice') {
            $rows = $this->production_model->num_rows('production_setting', array(
                'production_setting.created_by_cid' => $this->companyId
            ), $where1);
        } elseif ($_GET['tab'] == 'department_setting1'&& $_GET['tab']!='shift_setting1' && $_GET['tab']!='machinegrouping1' && $_GET['tab']!='wages_per_pice') {
            $rows = $this->production_model->num_rows('department', array(
                'department.created_by_cid' => $this->companyId
            ), $where2);
        } elseif ($_GET['tab'] == 'machinegrouping1'&& $_GET['tab']!='shift_setting1' && $_GET['tab']!='department_setting1' && $_GET['tab']!='wages_per_pice') {
            $rows = $this->production_model->num_rows('machine_group', array(
                'machine_group.created_by_cid' => $this->companyId
            ), $where3);
        } elseif ($_GET['tab'] == 'wages_per_pice' && $_GET['tab']!='shift_setting1' && $_GET['tab']!='machinegrouping1' && $_GET['tab']!='department_setting1') {
            $rows = $this->production_model->num_rows('wages_perpiece_setting', array(
                'wages_perpiece_setting.created_by_cid' => $this->companyId
            ), $where5);
        } else {
            $rows = $this->production_model->num_rows('production_setting', array(
                'production_setting.created_by_cid' => $this->companyId
            ), '');
        }


        //$this->production_model->num_rows('production_setting',array('production_setting.created_by_cid' => $this->companyId),$where2);
        if(empty($_GET['tab'])) {
        $parts = explode("=", $_SERVER['HTTP_REFERER']);
        $data = array('tab'=>end($parts));
        $queryString =  http_build_query($data);
        header('Location: '.base_url().'production/production_setting?'.$queryString.'');
        }
        $config                       = array();
        $config["base_url"]           = base_url() . "production/production_setting/";
        $config["total_rows"]         = $rows;
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['suffix'] = '?tab='.$_GET['tab'].'';
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
         if(!empty($_GET['ExportType'])){
            $export_data = 1;
        }else{
            $export_data = 0;
        }

        $where                        = array(
            'production_setting.created_by_cid' => $this->companyId
        );
        #$this->data['company_branch']= $this->production_model->get_company_branch('company_detail',array('id' => $_SESSION['loggedInUser']->c_id));
        $this->data['company_branch'] = $this->production_model->get_company_branch('company_detail', array(
            'id' => $this->companyId
        ));

        $this->data['productionSetting']      = $this->production_model->get_data1('production_setting', $where, $config["per_page"], $page, $where1, $order,$export_data);
        #$this->data['production_departments']= $this->production_model->get_data('department',array('department.created_by_cid' => $_SESSION['loggedInUser']->c_id));
        $this->data['production_departments'] = $this->production_model->get_data1('department', array(
            'department.created_by_cid' => $this->companyId
        ), $config["per_page"], $page, $where2, $order,$export_data);
        #$this->data['machine_group']= $this->production_model->get_data('machine_group',array('machine_group.created_by_cid' => $_SESSION['loggedInUser']->c_id));
        $this->data['machine_group']          = $this->production_model->get_data1('machine_group', array( 'machine_group.created_by_cid' => $this->companyId), $config["per_page"], $page, $where3, $order,$export_data);
        #$this->data['machine_order']  = $this->production_model->get_data('add_machine',array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id));
        $this->data['machine_order']          = $this->production_model->get_data1('add_machine', array(
            'add_machine.created_by_cid' => $this->companyId
        ), $config["per_page"], $page, $where4, $order,$export_data);
        #$this->data['unit_price']= $this->production_model->get_data('electricity_unit',array('electricity_unit.created_by_cid' => $_SESSION['loggedInUser']->c_id));
        $this->data['unit_price']             = $this->production_model->get_data1('electricity_unit', array(
            'electricity_unit.created_by_cid' => $this->companyId
        ), $config["per_page"], $page, '', $order,$export_data);
        #$this->data['wages_perpiece']= $this->production_model->get_data('wages_perpiece_setting',array('wages_perpiece_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id));
        $this->data['wages_perpiece']         = $this->production_model->get_data1('wages_perpiece_setting', array(
            'wages_perpiece_setting.created_by_cid' => $this->companyId
        ), $config["per_page"], $page, $where5, $order,$export_data);
        if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }

        $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';

        $this->_render_template('production_setting/index', $this->data);
    }
    /*production setting edit*/
    public function production_setting_edit()
    {
        $id = $_POST['id'];

        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->breadcrumb->add('Production', base_url() . 'production/production_setting');
        $this->breadcrumb->add($id ? 'Edit' : 'Add', base_url() . 'production_setting/' . $id ? 'Edit' : 'Add');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = $id ? 'Production planning Edit' : 'Production planning Add';
        $this->data['machineName']     = $this->production_model->get_data('add_machine');
        $this->data['prodSetting']     = $this->production_model->get_data_byId('production_setting', 'id', $id);
        $this->load->view('production_setting/edit', $this->data);
    }

    /*save production setting*/
    public function saveProductionSetting()
    {
        $weekDay_length = (isset($_POST['week_off'])) ? count($_POST['week_off']) : 0;
        if ($weekDay_length > 0) {
            $arr = array();
            $i   = 0;
            foreach ($_POST['week_off'] as $wo) {
                $arr[$i] = $wo;
                $i++;
            }
            $weekDayOff_array = json_encode($arr);
        } else {
            $weekDayOff_array = '';
        }
        $shift_name_length = (isset($_POST['shift_name'])) ? count($_POST['shift_name']) : 0;
        if ($shift_name_length > 0) {
            $arr = array();
            $i   = 0;
            foreach ($_POST['shift_name'] as $wo) {
                $arr[$i] = $wo;
                $i++;
            }
            $shift_name_array = json_encode($arr);
        } else {
            $shift_name_array = '';
        }
        $shift_duration_length = (isset($_POST['shift_duration'])) ? count($_POST['shift_duration']) : 0;
        if ($shift_duration_length > 0) {
            $arr = array();
            $i   = 0;
            foreach ($_POST['shift_duration'] as $wo) {
                $arr[$i] = $wo;
                $i++;
            }
            $shift_duration_array = json_encode($arr);
        } else {
            $shift_duration_array = '';
        }
        $shift_start_length = (isset($_POST['shift_start'])) ? count($_POST['shift_start']) : 0;
        if ($shift_start_length > 0) {
            $arr = array();
            $i   = 0;
            foreach ($_POST['shift_start'] as $wo) {
                $arr[$i] = $wo;
                $i++;
            }
            $shift_start_array = json_encode($arr);
        } else {
            $shift_start_array = '';
        }
        $shift_end_length = (isset($_POST['shift_end'])) ? count($_POST['shift_end']) : 0;
        if ($shift_end_length > 0) {
            $arr = array();
            $i   = 0;
            foreach ($_POST['shift_end'] as $wo) {
                $arr[$i] = $wo;
                $i++;
            }
            $shift_end_array = json_encode($arr);
        } else {
            $shift_end_array = '';
        }
        if ($this->input->post()) {
            $required_fields = array(
                'shift_name'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data                     = $this->input->post();
                $id                       = $data['id'];
                $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 21
                ));
                $data['week_off']         = $weekDayOff_array;
                $data['shift_name']         = $shift_name_array;
                $data['shift_duration']         = $shift_duration_array;
                $data['shift_start']         = $shift_start_array;
                $data['shift_end']         = $shift_end_array;
                //$data['created_by'] = $_SESSION['loggedInUser']->u_id ;
                #$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
                $data['created_by_cid']   = $this->companyId;
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success           = $this->production_model->update_data('production_setting', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "production setting updated successfully";
                        logActivity('production setting Updated', 'production_setting', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Production setting updated' , 'message' => 'Production setting updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array(
                                        'subject' => 'Production Setting updated',
                                        'message' => 'Production Setting id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $_SESSION['loggedInCompany']->u_id,
                                        'ref_id' => $id,
                                        'class' => 'productionTab',
                                        'data_id' => 'prodSettingView',
                                        'icon' => 'fa fa-archive'
                                    ));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*pushNotification(array('subject'=> 'Production setting updated' , 'message' => 'Production setting updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array(
                                'subject' => 'Production Setting updated',
                                'message' => 'Production Setting id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'ref_id' => $id,
                                'class' => 'productionTab',
                                'data_id' => 'prodSettingView',
                                'icon' => 'fa fa-archive'
                            ));
                        }
                        $this->session->set_flashdata('message', 'production settings Updated successfully');
                        redirect(base_url() . 'production/production_setting', 'refresh');
                    }
                } else {
                    $id = $this->production_model->insert_tbl_data('production_setting', $data);
                    if ($id) {
                        logActivity('production setting inserted', 'production_setting', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Production setting created' , 'message' => 'Production setting created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array(
                                        'subject' => 'Production Setting created',
                                        'message' => 'New Production Setting is created by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $userViewPermission['user_id'],
                                        'ref_id' => $id,
                                        'class' => 'productionTab',
                                        'data_id' => 'prodSettingView',
                                        'icon' => 'fa fa-archive'
                                    ));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*pushNotification(array('subject'=> 'Production setting created' , 'message' => 'Production setting created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array(
                                'subject' => 'Production Setting created',
                                'message' => 'New Production Setting is created by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'ref_id' => $id,
                                'class' => 'productionTab',
                                'data_id' => 'prodSettingView',
                                'icon' => 'fa fa-archive'
                            ));
                        }
                        $this->session->set_flashdata('message', 'production setting inserted successfully');
                        redirect(base_url() . 'production/production_setting', 'refresh');
                    }
                }
            }
        }
    }
    /*production setting delete*/
    public function deleteProductionSetting($id = '')
    {
        if (!$id) {
            redirect('production/production_setting', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->production_model->delete_data('production_setting', 'id', $id);
        if ($result) {
            logActivity('prodcution setting Deleted', 'production_setting', $id);
            $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                'is_view' => 1,
                'sub_module_id' => 21
            ));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        /*  pushNotification(array('subject'=> 'Production setting deleted' , 'message' => 'Production setting deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                        pushNotification(array(
                            'subject' => 'Production Setting deleted',
                            'message' => 'Production Setting id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                            'from_id' => $_SESSION['loggedInUser']->u_id,
                            'to_id' => $userViewPermission['user_id'],
                            'ref_id' => $id,
                            'icon' => 'fa fa-archive'
                        ));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                /*pushNotification(array('subject'=> 'Production setting deleted' , 'message' => 'Production setting deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                pushNotification(array(
                    'subject' => 'Production Setting deleted',
                    'message' => 'Production Setting id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                    'from_id' => $_SESSION['loggedInUser']->u_id,
                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                    'ref_id' => $id,
                    'icon' => 'fa fa-archive'
                ));
            }
            $this->session->set_flashdata('message', 'production setting Deleted Successfully');
            $result = array(
                'msg' => 'production setting Deleted Successfully',
                'status' => 'success',
                'code' => 'C142',
                'url' => base_url() . 'production/production_setting'
            );
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array(
                'msg' => 'error',
                'status' => 'error',
                'code' => 'C774'
            ));
        }
    }

    public function production_setting_view()
    {
        $id                        = $_POST['id'];
        $this->data['settingView'] = $this->production_model->get_data_byId('production_setting', 'id', $id);
        $this->load->view('production_setting/view', $this->data);
    }

    /*production group */
    public function production_group_edit()
    {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['machine_group'] = $this->production_model->get_data_byId('machine_group', 'id', $id);
        //pre($this->data['machine_group']);die;
        $this->load->view('production_setting/machine_group_edit', $this->data);
    }
    public function save_machine_group_name()
    {   
        if(is_array($_POST['machine_group_name'])){
        $name = $_POST['machine_group_name']['0'];
        } else {
        $name = $_POST['machine_group_name'];
        } 
        $groupExist = $this->production_model->groupExist('machine_group', $name);
        if(!empty($groupExist)){
        $this->session->set_flashdata('message', 'Machine Group Name already exits');
        header('Location: '.base_url().'production/production_setting?tab=machinegrouping1');
        }  else {
        if ($this->input->post()) {
            $required_fields = array(
                'machine_group_name'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data                     = $this->input->post();
                $id                       = $data['id'];
                $data['created_by_cid']   = $this->companyId;
                $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 21
                ));
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success           = $this->production_model->update_data('machine_group', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Machine group updated successfully";
                        logActivity('Machine group Updated', 'machine_group', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                     pushNotification(array(
                                        'subject' => 'Machine Group updated',
                                        'message' => 'Machine Group id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $userViewPermission['user_id'],
                                        'ref_id' => $id,
                                        'icon' => 'fa fa-archive'
                                    ));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array(
                                'subject' => 'Machine Group updated',
                                'message' => 'Machine Group id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'ref_id' => $id,
                                'icon' => 'fa fa-archive'
                            ));
                        }
                        $this->session->set_flashdata('message', 'Machine group Updated successfully');
                        redirect(base_url() . 'production/production_setting', 'refresh');
                    }
                } else {
                    $dataArray         = array();
                    $machineGroupCount = count($_POST['machine_group_name']);
                    for ($i = 0; $i < $machineGroupCount; $i++) {
                        $dataArray[$i] = array(
                            'machine_group_name' => isset($_POST['machine_group_name'][$i]) ? $_POST['machine_group_name'][$i] : '',
                            'created_by_cid' => $this->companyId
                        );
                    }
                    $insertedid = $this->production_model->insert_multiple_data('machine_group', $dataArray);
                    logActivity('Machine group  inserted', 'machine_group', $id);
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                               pushNotification(array(
                                    'subject' => 'Machine Group created',
                                    'message' => 'Machine group is created by ' . $_SESSION['loggedInUser']->name,
                                    'from_id' => $_SESSION['loggedInUser']->u_id,
                                    'to_id' => $userViewPermission['user_id'],
                                    'ref_id' => $id,
                                    'icon' => 'fa fa-archive'
                                ));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                         pushNotification(array(
                            'subject' => 'Machine Group created',
                            'message' => 'Machine group is created by ' . $_SESSION['loggedInUser']->name,
                            'from_id' => $_SESSION['loggedInUser']->u_id,
                            'to_id' => $_SESSION['loggedInCompany']->u_id,
                            'ref_id' => $id,
                            'icon' => 'fa fa-archive'
                        ));
                    }
                    $this->session->set_flashdata('message', 'Machine group  inserted successfully');
                    redirect(base_url() . 'production/production_setting', 'refresh');                    
                }
            }
        }
    }
    }
    /*production setting delete*/
    public function deleteMachineGroup($id = '')
    {
        if (!$id) {
            redirect('production/production_setting', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->production_model->delete_data('machine_group', 'id', $id);
        if ($result) {
            logActivity('machine group  Deleted', 'machine_group', $id);

            $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                'is_view' => 1,
                'sub_module_id' => 21
            ));

            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        /*  pushNotification(array('subject'=> 'Machine group deleted' , 'message' => 'Machine group deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                        pushNotification(array(
                            'subject' => 'Machine group deleted',
                            'message' => 'Machine group id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                            'from_id' => $_SESSION['loggedInUser']->u_id,
                            'to_id' => $userViewPermission['user_id'],
                            'ref_id' => $id,
                            'icon' => 'fa fa-archive'
                        ));

                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                /*pushNotification(array('subject'=> 'Machine group deleted' , 'message' => 'Machine group deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                pushNotification(array(
                    'subject' => 'Machine group deleted',
                    'message' => 'Machine group id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                    'from_id' => $_SESSION['loggedInUser']->u_id,
                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                    'ref_id' => $id,
                    'icon' => 'fa fa-archive'
                ));
            }
            $this->session->set_flashdata('message', 'machine group Deleted Successfully');
            $result = array(
                'msg' => 'machine group  Deleted Successfully',
                'status' => 'success',
                'code' => 'C142',
                'url' => base_url() . 'production/production_setting'
            );
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array(
                'msg' => 'error',
                'status' => 'error',
                'code' => 'C774'
            ));
        }
    }



    /*get department accoridng to branch in machine orering tab*/
    public function getDepartmentInOrdering()
    {
        $branchName = $_POST['branch_name'];
        $result     = $this->production_model->get_department_data('department', 'unit_name', $branchName);
        //pre($result);die();
        echo json_encode($result);
    }

    /*append machine accroding to department************/
    public function getDepartementMachine()
    {
        $deptId = $_POST['deptId'];
        $result = $this->production_model->get_departmentMachine_data('add_machine', 'department', $deptId);
        foreach ($result as $key => $value) {
        $machine_grpinfo = getNameById('machine_group', $value['machine_group_id'],'id');
        $result[$key]['machine_group_name'] = $machine_grpinfo->machine_group_name;
        };
        echo json_encode($result);
    }

    public function user_data()
    {
        $query  = isset($_POST['query']);
        #$where = array('user_detail.c_id' => $_SESSION['loggedInUser']->c_id);
        $where  = array(
            'user_detail.c_id' => $this->companyId
        );
        $result = $this->production_model->get_user_data('user_detail', $_POST['query'], $where);
        echo json_encode($result);
        //$this->_render_template('production_data/edit', $this->data);
    }

    public function get_machine_data()
    {
        $id     = $_POST['id'];
        //pre($id); die;
        $result = $this->production_model->get_machine_data('add_machine', 'id', $id);
        //$this->load->view('production_data/edit', $result);
        //$this->_render_template('production_data/edit', $result);
        echo json_encode($result);
    }
    /*  change sorting order in database of process type*/
    public function changeOrder()
    {
        $orders        = $_POST['order'];
        //pre($orders);
        $process_order = $this->production_model->change_process_order($orders);
        echo json_encode(array(
            'msg' => 'error',
            'status' => 'success',
            'code' => 'C774'
        ));
    }


    /*production scheduling code index*/
    public function add_production_scheduling()
    {
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('production Scheduling', base_url() . 'production_scheduling');
        $this->settings['breadcrumbs']   = $this->breadcrumb->output();
        $this->settings['pageTitle']     = 'Production Scheduling';
        #$where = array('production_scheduling.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where                           = array(
            'production_scheduling.created_by_cid' => $this->companyId
        );
        $this->data['prod_schedule']     = $this->production_model->get_data('production_scheduling', $where);
        #$whereMachine = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id, 'add_machine.save_status' => 1);
        $whereMachine                    = array(
            'add_machine.created_by_cid' => $this->companyId,
            'add_machine.save_status' => 1
        );
        #$wherejobCard = array('job_card.created_by_cid' => $_SESSION['loggedInUser']->c_id, 'job_card.save_status' => 1);
        $wherejobCard                    = array(
            'job_card.created_by_cid' => $this->companyId,
            'job_card.save_status' => 1
        );
        $this->data['machineName']       = $this->production_model->get_data('add_machine', $whereMachine);
        $this->data['machines']          = $this->production_model->get_data('add_machine', $whereMachine);
        $this->data['jobCards']          = $this->production_model->get_data('job_card', $wherejobCard);
        //$this->data['approveSaleOrder']= $this->production_model->get_sales_count('sale_order');
        #$where = array('production_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where                           = array(
            'production_setting.created_by_cid' => $this->companyId
        );
        $this->data['productionSetting'] = $this->production_model->get_data('production_setting', $where);
        #$saleOrderWhere = array('sale_order_priority.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'sale_order.approve'=>1);
        $saleOrderWhere                  = array(
            'sale_order_priority.created_by_cid' => $this->companyId,
            'sale_order.approve' => 1
        );

        $this->data['sale_orders'] = $this->production_model->get_data('sale_order_priority', $saleOrderWhere);
        $this->_render_template('production_scheduling/add', $this->data);
    }


    /*save production scheduling*/

    public function saveProductionScheduling()
    {
        $prodData = $this->input->post();
        $a        = array();
        //for($i=1;$i<=4;$i++){
        for ($i = 1; $i <= count($prodData['prodSch']); $i++) {
            $a[] = $prodData['prodSch'][$i];
        }
        //$prodData['data']  = json_encode($prodData['prodSch']);
        $prodData['data']           = json_encode($a);
        //$prodData['month']  = $prodData['month'];
        $prodData['date']           = $prodData['date'];
        //$data['created_by'] =$_SESSION['loggedInUser']->u_id;
        $data['created_by']         = $prodData['created_by'];
        #$prodData['created_by_cid']  = $_SESSION['loggedInUser']->c_id;
        $prodData['created_by_cid'] = $this->companyId;
        $id                         = $this->production_model->insert_tbl_data('production_scheduling', $prodData);
        if ($id) {
            echo 'Data inserted successfully';
        } else {
            echo 'Data Of this month already inserted.';
        }
        die;

    }

    public function updateProductionScheduling()
    {
        $prodData = $this->input->post();
        $a        = array();
        //for($i=1;$i<=4;$i++){
        for ($i = 1; $i <= count($prodData['prodSch']); $i++) {
            $a[] = $prodData['prodSch'][$i];
        }
        //$prodData['data']  = json_encode($prodData['prodSch']);
        $prodData['data']           = json_encode($a);
        //$prodData['month']  = $prodData['month'];
        $prodData['date']           = $prodData['date'];
        //$prodData['created_by']  = $_SESSION['loggedInUser']->u_id;
        #$prodData['created_by_cid']  = $_SESSION['loggedInUser']->c_id;
        $prodData['created_by_cid'] = $this->companyId;
        //$prodData['edited_by']  = $_SESSION['loggedInUser']->u_id;
        $prodData['edited_by']      = $prodData['edited_by'];
        //$id = $this->production_model->insert_tbl_data('production_scheduling',$prodData);
        $id                         = $this->production_model->update_data('production_scheduling', $prodData, 'id', $prodData['id']);
        if ($id) {
            echo 'Data updated successfully';
        }
        die;

    }

    //public function getProdctionSchedulingByMonth(){
    public function editProductionScheduling($id = '')
    {
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('production Scheduling', base_url() . 'production_scheduling');
        $this->settings['breadcrumbs']      = $this->breadcrumb->output();
        $this->settings['pageTitle']        = 'Production Scheduling';
        #$where = array('production_scheduling.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where                              = array(
            'production_scheduling.created_by_cid' => $this->companyId
        );
        $this->data['prod_schedule']        = $this->production_model->get_data('production_scheduling', $where);
        #$whereMachine = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id,'add_machine.save_status' => 1);
        $whereMachine                       = array(
            'add_machine.created_by_cid' => $this->companyId,
            'add_machine.save_status' => 1
        );
        #$wherejobCard = array('job_card.created_by_cid' => $_SESSION['loggedInUser']->c_id,'job_card.save_status' => 1);
        $wherejobCard                       = array(
            'job_card.created_by_cid' => $this->companyId,
            'job_card.save_status' => 1
        );
        $this->data['machineName']          = $this->production_model->get_data('add_machine', $whereMachine);
        $this->data['machines']             = $this->production_model->get_data('add_machine', $whereMachine);
        $this->data['jobCards']             = $this->production_model->get_data('job_card', $wherejobCard);
        //$this->data['approveSaleOrder']= $this->production_model->get_sales_count('sale_order');
        #$where = array('production_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where                              = array(
            'production_setting.created_by_cid' => $this->companyId
        );
        $this->data['productionSetting']    = $this->production_model->get_data('production_setting', $where);
        $this->data['productionScheduling'] = $prodSchedulingData = $this->production_model->get_data_byId('production_scheduling', 'id', $id);

        #$saleOrderWhere = array('sale_order_priority.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'sale_order.approve'=>1);
        $saleOrderWhere            = array(
            'sale_order_priority.created_by_cid' => $this->companyId,
            'sale_order.approve' => 1
        );
        $this->data['sale_orders'] = $this->production_model->get_data('sale_order_priority', $saleOrderWhere);
        $this->_render_template('production_scheduling/edit', $this->data);
    }


    public function production_scheduling()
    {
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('production Scheduling', base_url() . 'production_scheduling');
        $this->settings['breadcrumbs']      = $this->breadcrumb->output();
        $this->settings['pageTitle']        = 'Production Scheduling';
        #$where = array('production_scheduling.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where                              = array(
            'production_scheduling.created_by_cid' => $this->companyId
        );
        $this->data['productionScheduling'] = $prodSchedulingData = $this->production_model->get_data('production_scheduling', $where);
        $this->_render_template('production_scheduling/index', $this->data);
    }



    /* Main Function to fetch all the listing of departments */
    public function sale_orders()
    {
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Crm', base_url() . 'Production');
        $this->breadcrumb->add('Sale Order', base_url() . 'production/sale_orders');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Sale Orders';
        if (!empty($_POST)) {
            #$where = array('created_date >=' => $_POST['start'] , 'created_date <=' => $_POST['end'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id,'approve'=>1);
            $where = array(
                'created_date >=' => $_POST['start'],
                'created_date <=' => $_POST['end'],
                'created_by_cid' => $this->companyId,
                'approve' => 1
            );
        } else
        #$where = array('created_by_cid'=> $_SESSION['loggedInUser']->c_id,'approve'=>1);
            $where = array(
                'created_by_cid' => $this->companyId,
                'approve' => 1
            );
        $this->data['sale_orders'] = $this->production_model->get_data('sale_order', $where);
        if (!empty($_POST)) {
            $this->load->view('sale_orders/index', $this->data);
        } else {
            $this->_render_template('sale_orders/index', $this->data);
        }

    }

    public function viewSaleOrder($id = '')
    {
        if ($this->input->post('id')) {
            permissions_redirect('is_view');
        }
        $this->load->model('crm/crm_model');
        $this->data['id']          = $this->input->post('id');
        $this->data['users']       = $this->production_model->get_data('user_detail');
        $this->data['sale_order']  = $this->production_model->get_data_byId('sale_order', 'id', $this->input->post('id'));
        $this->data['materials']   = $this->production_model->get_data('material');
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id', $this->input->post('id'));
        $whereAttachment           = array(
            'rel_id' => $this->input->post('id'),
            'rel_type' => 'sale_order'
        );
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->load->view('sale_orders/view', $this->data);
    }


    public function dispatchSaleOrder($id = '')
    {
        /*if($this->input->post('id')){
        permissions_redirect('is_view');
        }*/
        $this->load->model('crm/crm_model');
        $this->data['id']          = $this->input->post('id');
        $this->data['users']       = $this->production_model->get_data('user_detail');
        $this->data['sale_order']  = $this->production_model->get_data_byId('sale_order', 'id', $this->input->post('id'));
        $this->data['materials']   = $this->production_model->get_data('material');
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id', $this->input->post('id'));
        $whereAttachment           = array(
            'rel_id' => $this->input->post('id'),
            'rel_type' => 'sale_order'
        );
        $this->data['attachments'] = $this->crm_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->load->view('sale_orders/dispatch', $this->data);
    }

    /*public function saveDispatchSaleOrder(){
    if ($this->input->post()) {
    //$required_fields = array('product','quantity','uom','dispatched_date');
    $required_fields = array('dispatched_date');
    $is_valid = validate_fields($_POST, $required_fields);
    if (count($is_valid) > 0) {
    valid_fields($is_valid);
    }
    else{
    $data  = $this->input->post();
    $products = count($_POST['product']);
    if($products >0){
    $arr = [];
    $i = 0;
    while($i < $products) {
    $jsonArrayObject = array('product' => $_POST['product'][$i], 'quantity' => $_POST['quantity'][$i], 'uom' => $_POST['uom'][$i]);
    $arr[$i] = $jsonArrayObject;
    $i++;
    }
    $dispatch_product_array = json_encode($arr);
    }else{
    $dispatch_product_array = '';
    }
    $data['dispatch_product'] = $dispatch_product_array ;
    $id = $data['id'];
    if($id && $id != ''){
    $success = $this->production_model->update_data('sale_order',$data, 'id', $id);
    if ($success) {
    $data['message'] = "Sale Order updated successfully";
    logActivity('Sale Order Updated','sale order',$id);
    $this->session->set_flashdata('message', 'Sale Order Updated successfully');

    }
    }
    redirect(base_url().'production_model/sale_orders', 'refresh');

    }
    }
    }*/

    /*  change priority of sale order in production scheduling in database
    public function changeSaleOrderPriority(){
    $orders = $_POST['order'];
    $sale_order_priority = $this->production_model->changeSaleOrderPriority($orders);
    $result = array('msg' => 'production priority set successfully', 'status' => 'success', 'code' => 'C142','url' => '');
    echo json_encode($result);
    die;
    }*/

    /*  change priority of sale order in production scheduling in database */
    public function changeSaleOrderPriority()
    {
        $sale_orders = $_POST['order'];

        $record = array();
        $name   = array();
        foreach ($sale_orders as $key => $value) {
            if (!in_array($value['id'], $name)) {
                $name[]       = $value['id'];
                $record[$key] = $value;
            }

        }

        $sale_order_priority = $this->production_model->changeSaleOrderPriority($record);
        /*$orders = $_POST['order'];
        $sale_order_priority = $this->production_model->changeSaleOrderPriority($orders);   */
        $result              = array(
            'msg' => 'production priority set successfully',
            'status' => 'success',
            'code' => 'C142',
            'url' => ''
        );
        echo json_encode($result);
        die;
    }

    public function changeWorkOrderPriority()
    {
        $sale_orders = $_POST['order'];
        
        $record = array();
        $name   = array();
        foreach ($sale_orders as $key => $value) {
            if (!in_array($value['id'], $name)) {
                $name[]       = $value['id'];
                $record[$key] = $value;
            }

        }

        $sale_order_priority = $this->production_model->changeWorkOrderPriority($record);
        $result              = array(
            'msg' => 'production priority set successfully',
            'status' => 'success',
            'code' => 'C142',
            'url' => ''
        );
        echo json_encode($result);
        die;
    }

    # Main Function to load dashboard
    /*public function dashboard(){
    $this->data['can_edit'] = edit_permissions();
    $this->data['can_delete'] = delete_permissions();
    $this->data['can_add'] = add_permissions();
    $this->breadcrumb->add('Production', base_url() . 'dashboard');
    $this->settings['breadcrumbs'] = $this->breadcrumb->output();
    $this->settings['pageTitle'] = 'Dashboard';
    $this->_render_template('dashboard/index', $this->data);
    }*/
    public function dashboard()
    {
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->breadcrumb->add('Production', base_url() . 'dashboard');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Dashboard';
        $this->data['user_dashboard']  = $this->production_model->get_data_dashboard('user_dashboard', array(
            'user_id' => $_SESSION['loggedInUser']->id
        ));
        $where  = "work_order.inprocess_complete = 0 AND work_order.active_inactive = 1 AND work_order.created_by_cid = " . $this->companyId;
        $this->data['work_order'] = $this->production_model->get_data_wo_bypriorty('work_order', $where);
        $this->_render_template('dashboard/index', $this->data);
    }

    /*dashboard*/
    public function graphDashboardData()
    {
        if (!empty($_POST)) {
            $startDate = $_POST['startDate'];
            $endDate   = $_POST['endDate'];
        } else {
            $startDate = $endDate = '';
        }
        $graphDashboardArray          = array();
        $getPoductionDataListingGraph = getPoductionDataListingGraph($startDate, $endDate);
        //re($getPoductionDataListingGraph);
        $getProductionPlanning        = getProductionPlanning($startDate, $endDate);
        //$getComparison = getComparison($startDate, $endDate);

        //$getDashboardCount = getDashboardCount($startDate, $endDate);
        $graphDashboardArray = array(
            'getPoductionDataListingGraph' => $getPoductionDataListingGraph,
            'getProductionPlanning' => $getProductionPlanning
        );

        //pre($graphDashboardArray);die;


        echo json_encode($graphDashboardArray);
    }

    /*process name save function*/
    public function save_production_department()
    { 
        if(is_array($_POST['name'])){
        $name = $_POST['name']['0'];
        } else {
        $name = $_POST['name'];
        } 
        $departmentExist = $this->production_model->departmentExist('department', $_POST['created_by'], $_POST['unit_name'], $name);
        if(!empty($departmentExist)){
        $this->session->set_flashdata('message', 'Department of this unit already exits');
        header('Location: '.base_url().'production/production_setting?tab=department_setting1');
        } else {
        if ($this->input->post()) {
            $required_fields = array(
                'unit_name',
                'name'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data                   = $this->input->post();
                $id                     = $data['id'];
                #$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
                $data['created_by_cid'] = $this->companyId;
                $data['created_by']     = $_SESSION['loggedInUser']->u_id;
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success           = $this->production_model->update_data('department', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Department updated successfully";
                        logActivity('Department Updated', 'update_production_department', $id);
                        $this->session->set_flashdata('message', 'Department Updated successfully');
                        redirect(base_url() . 'production/production_setting', 'refresh');
                    }
                } else {                  

                    $departmentArray = array();
                    if (!empty($data['name'])) {
                        $i = 0;
                        foreach ($data['name'] as $departmentName) {
                            $departmentArray[$i]['id']             = $id;
                            $departmentArray[$i]['unit_name']      = $data['unit_name'];
                            $departmentArray[$i]['name']           = $departmentName;
                            $departmentArray[$i]['created_by_cid'] = $data['created_by_cid'];
                            $departmentArray[$i]['created_by']     = $data['created_by'];
                            $i++;
                        }
                    }
                    $id = $this->production_model->insert_multiple_data('department', $departmentArray);
                    $this->session->set_flashdata('message', 'Department inserted successfully');
                    redirect(base_url() . 'production/production_setting', 'refresh');

                }

            }
        }
    }
    }
    /* add / edit department page */
    public function edit_department()
    {
        if ($this->input->post('id') != '')
            permissions_redirect('is_edit');
        else
            permissions_redirect('is_add');

        $this->data['department'] = $this->production_model->get_data_byId('department', 'id', $this->input->post('id'));
        $this->load->view('production_setting/edit_department', $this->data);
    }
    /*production setting delete*/
    public function deleteDepartmentSetting($id = '')
    {
        if (!$id) {
            redirect('production/production_setting', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->production_model->delete_data('department', 'id', $id);
        if ($result) {
            logActivity('Department setting Deleted', 'department', $id);

            $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                'is_view' => 1,
                'sub_module_id' => 21
            ));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array(
                            'subject' => 'Department Setting deleted',
                            'message' => 'Department Setting id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                            'from_id' => $_SESSION['loggedInUser']->u_id,
                            'to_id' => $userViewPermission['user_id'],
                            'ref_id' => $id,
                            'icon' => 'fa fa-archive'
                        ));

                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array(
                    'subject' => 'Department Setting deleted',
                    'message' => 'Department Setting id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                    'from_id' => $_SESSION['loggedInUser']->u_id,
                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                    'ref_id' => $id,
                    'icon' => 'fa fa-archive'
                ));
            }
            $this->session->set_flashdata('message', 'Department setting Deleted Successfully');
            $result = array(
                'msg' => 'Department setting Deleted Successfully',
                'status' => 'success',
                'code' => 'C142',
                'url' => base_url() . 'production/production_setting'
            );
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array(
                'msg' => 'error',
                'status' => 'error',
                'code' => 'C774'
            ));
        }
    }


    /*get material from materil issue(WIP) qty and uom based on material select in job card*/
    public function getQtyUom()
    {
        //if($_POST['mat_id'] !=''){
        $mat_id                = $_REQUEST['mat_id'];
        $material_related_data = $this->production_model->get_QtyUom_byId('work_in_process_material', 'id', $mat_id);
        echo json_encode($material_related_data);
        //}
    }
    public function company_department()
    {
        if ($_POST['unit_name'] != '') {
            $unit_name          = $_POST['unit_name'];
            #$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id,'unit_name'=>$unit_name);
            $where              = array(
                'created_by_cid' => $this->companyId,
                'unit_name' => $unit_name
            );
            $selected_unit_name = $this->production_model->get_data_byAddress('department', $where);
            echo json_encode($selected_unit_name);
        }

    }

    public function get_party_jobcard()
    {
        $tt = array();
        if ($_POST['party_code_id'] != '') {
            $party_code_id      = $_POST['party_code_id'];
            #$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id,'id'=>$party_code_id);
            $where              = array(
                'created_by_cid' => $this->companyId,
                'id' => $party_code_id
            );
            $selected_unit_name = $this->production_model->get_data_byAddress('material', $where);

            foreach ($selected_unit_name as $value1) {
                if ($value1['job_card'] != 0) {
                    $ss                = getNameById('job_card', $value1['job_card'], 'id');
                    $tt['id']          = $ss->id;
                    $tt['job_card_no'] = $ss->job_card_no;
                }

            }

            echo "[" . json_encode($tt) . "]";
        }

    }
    public function get_processtype_jobcard()
    {
        if ($_POST['job_card_noo'] != '') {
            $job_card_noo = $_POST['job_card_noo'];
            $where            = array(
                'created_by_cid' => $this->companyId,
                'id' => $job_card_noo
            );
            $get_job_card_dtl = $this->production_model->get_process_namebyadd('job_card', $where);
            foreach ($get_job_card_dtl as $val) {
                $processdata = json_decode($val['machine_details']);
            } 
            $html = '';
            $html .= '<option value=""> Select </option>';
            foreach ($processdata as $process_namee) {
                $proc_nam   = getNameById('add_process', $process_namee->processess, 'id');
                $input_data = $process_namee->input_process;
                $merger = json_encode(json_decode(trim($process_namee->output_process,'"'), true));

                // $in_decode = json_decode($merger);
                // foreach($in_decode as $val){
                // pre($val);
                // }


                $html .= '<option value="' . $process_namee->processess . '" data-in=' . $merger . ' >' . $proc_nam->process_name . '</option>';

            }
            //die();
            echo $html;
        }
    }



    /*get material from materil issue(WIP)*/
    public function getMaterial_IssueDetail($materialType_id = '')
    {
        $materialType_id = $_POST['id'];
        $getMaterialType = $this->production_model->getMatType_ById('work_in_process_material', $materialType_id, 'id');
        //pre($getMaterialType);die;
        echo json_encode($getMaterialType);
    }

    function getcompany_unit()
    {
        //$where = array('u_id' => $_SESSION['loggedInUser']->u_id);
        #$where = array('id' => $_SESSION['loggedInUser']->c_id);
        $where        = array(
            'id' => $this->companyId
        );
        $data         = $this->production_model->get_data_byAddress('company_detail', $where);
        $data1        = $data[0]['address'];
        $data2        = json_decode($data1);
        $addressArray = array();
        $i            = 0;
        foreach ($data2 as $dt) {
            $addressArray[$i]['id']   = $dt->compny_branch_name;
            $addressArray[$i]['text'] = $dt->compny_branch_name;
            $i++;
        }
        echo json_encode($addressArray);
    }

    /**********get data thru location settings**************/
    function get_companyunit()
    {
        #$where = array('c_id' => $_SESSION['loggedInUser']->c_id);
        $where        = array(
            'c_id' => $this->companyId
        );
        $data         = $this->production_model->get_data_byCid('location_settings', $where);
        $addressArray = array();
        $i            = 0;
        foreach ($data as $companyDetail) {
            $addressArray[$i]['id']   = $companyDetail['compny_branch_id'];
            $addressArray[$i]['text'] = $companyDetail['company_unit'];
            $i++;
        }

        echo json_encode($addressArray);
    }
    /*********************************************************Worker information*************************************************/
    /*Main fucntion of worker listing*/
    public function workers()
    {
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('worker', base_url() . 'worker');
        $this->settings['breadcrumbs']     = $this->breadcrumb->output();
        #$whereCompany = "(id ='".$_SESSION['loggedInUser']->c_id."')";
        $whereCompany                      = "(id ='" . $this->companyId . "')";
        $this->data['company_unit_adress'] = $this->production_model->get_filter_details('company_detail', $whereCompany);
        if (isset($_POST['favourites'])) {
            #$whereActive = array('worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id ,'worker.active_inactive' =>1 , 'worker.favourite_sts' =>1);
            $whereActive                    = array(
                'worker.created_by_cid' => $this->companyId,
                'worker.active_inactive' => 1,
                'worker.favourite_sts' => 1
            );
            $this->data['active_workers']   = $this->production_model->get_data('worker', $whereActive);
            #$whereInactive = array('worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id ,'worker.active_inactive' =>0 , 'worker.favourite_sts' =>1);
            $whereInactive                  = array(
                'worker.created_by_cid' => $this->companyId,
                'worker.active_inactive' => 0,
                'worker.favourite_sts' => 1
            );
            $this->data['inactive_workers'] = $this->production_model->get_data('worker', $whereInactive);
            $this->_render_template('workers/index', $this->data);
        } else {
            if (!empty($_POST) && isset($_POST['start']) && isset($_POST['end']) && $_POST['company_unit'] == '' && $_POST['ExportType'] == '') {
                #$whereActive = array('worker.created_date >=' => $_POST['start'] , 'worker.created_date <=' => $_POST['end'],'worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'worker.active_inactive' => 1 );
                $whereActive                    = array(
                    'worker.created_date >=' => $_POST['start'],
                    'worker.created_date <=' => $_POST['end'],
                    'worker.created_by_cid' => $this->companyId,
                    'worker.active_inactive' => 1
                );
                $this->data['active_workers']   = $this->production_model->get_data('worker', $whereActive);
                #$whereInactive = array('worker.created_date >=' => $_POST['start'] , 'worker.created_date <=' => $_POST['end'],'worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'worker.active_inactive' => 0  );
                $whereInactive                  = array(
                    'worker.created_date >=' => $_POST['start'],
                    'worker.created_date <=' => $_POST['end'],
                    'worker.created_by_cid' => $this->companyId,
                    'worker.active_inactive' => 0
                );
                $this->data['inactive_workers'] = $this->production_model->get_data('worker', $whereInactive);
            } elseif (!empty($_POST) && $_POST['start'] == '' && $_POST['end'] == '' && $_POST['company_unit'] != '') {
                #$whereActive = array('worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id ,'worker.active_inactive' => 1 ,'worker.company_unit' => $_POST['company_unit']);
                $whereActive                    = array(
                    'worker.created_by_cid' => $this->companyId,
                    'worker.active_inactive' => 1,
                    'worker.company_unit' => $_POST['company_unit']
                );
                $this->data['active_workers']   = $this->production_model->get_data('worker', $whereActive);
                #$whereInactive = array('worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'worker.active_inactive' => 0  ,'worker.company_unit' => $_POST['company_unit']);
                $whereInactive                  = array(
                    'worker.created_by_cid' => $this->companyId,
                    'worker.active_inactive' => 0,
                    'worker.company_unit' => $_POST['company_unit']
                );
                $this->data['inactive_workers'] = $this->production_model->get_data('worker', $whereInactive);
            } elseif (!empty($_POST) && $_POST['start'] != '' && $_POST['end'] != '' && $_POST['company_unit'] != '') {
                #$whereActive = array('worker.created_date >=' => $_POST['start'] , 'worker.created_date <=' => $_POST['end'],'worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id ,'worker.active_inactive' => 1 ,'worker.company_unit' => $_POST['company_unit']);
                $whereActive                    = array(
                    'worker.created_date >=' => $_POST['start'],
                    'worker.created_date <=' => $_POST['end'],
                    'worker.created_by_cid' => $this->companyId,
                    'worker.active_inactive' => 1,
                    'worker.company_unit' => $_POST['company_unit']
                );
                $this->data['active_workers']   = $this->production_model->get_data('worker', $whereActive);
                #$whereInactive = array('worker.created_date >=' => $_POST['start'] , 'worker.created_date <=' => $_POST['end'],'worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'worker.active_inactive' => 0  ,'worker.company_unit' => $_POST['company_unit']);
                $whereInactive                  = array(
                    'worker.created_date >=' => $_POST['start'],
                    'worker.created_date <=' => $_POST['end'],
                    'worker.created_by_cid' => $this->companyId,
                    'worker.active_inactive' => 0,
                    'worker.company_unit' => $_POST['company_unit']
                );
                $this->data['inactive_workers'] = $this->production_model->get_data('worker', $whereInactive);
            } else {
                #$whereActive = array('worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id ,'worker.active_inactive' =>1);
                $whereActive                    = array(
                    'worker.created_by_cid' => $this->companyId,
                    'worker.active_inactive' => 1
                );
                $this->data['active_workers']   = $this->production_model->get_data('worker', $whereActive);
                #$whereInactive = array('worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id ,'worker.active_inactive' =>0);
                $whereInactive                  = array(
                    'worker.created_by_cid' => $this->companyId,
                    'worker.active_inactive' => 0
                );
                $this->data['inactive_workers'] = $this->production_model->get_data('worker', $whereInactive);
            }
            if (isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' && $_POST['company_unit'] == '') {
                #$whereActive = array('worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id ,'worker.active_inactive' => 1 );
                $whereActive                    = array(
                    'worker.created_by_cid' => $this->companyId,
                    'worker.active_inactive' => 1
                );
                $this->data['active_workers']   = $this->production_model->get_data('worker', $whereActive);
                #$whereInactive = array('worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'worker.active_inactive' => 0  );
                $whereInactive                  = array(
                    'worker.created_by_cid' => $this->companyId,
                    'worker.active_inactive' => 0
                );
                $this->data['inactive_workers'] = $this->production_model->get_data('worker', $whereInactive);
            } elseif (isset($_POST["ExportType"]) && $_POST['start'] != '' && $_POST['end'] != '' && $_POST['company_unit'] == '') {
                #$whereActive = array('worker.created_date >=' => $_POST['start'] , 'worker.created_date <=' => $_POST['end'],'worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id ,'worker.active_inactive' => 1);
                $whereActive                    = array(
                    'worker.created_date >=' => $_POST['start'],
                    'worker.created_date <=' => $_POST['end'],
                    'worker.created_by_cid' => $this->companyId,
                    'worker.active_inactive' => 1
                );
                $this->data['active_workers']   = $this->production_model->get_data('worker', $whereActive);
                #$whereInactive = array('worker.created_date >=' => $_POST['start'] , 'worker.created_date <=' => $_POST['end'],'worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id ,'worker.active_inactive' => 0);
                $whereInactive                  = array(
                    'worker.created_date >=' => $_POST['start'],
                    'worker.created_date <=' => $_POST['end'],
                    'worker.created_by_cid' => $this->companyId,
                    'worker.active_inactive' => 0
                );
                $this->data['inactive_workers'] = $this->production_model->get_data('worker', $whereInactive);
            } elseif (isset($_POST["ExportType"]) && $_POST['start'] != '' && $_POST['end'] != '' && $_POST['company_unit'] != '') {
                #$whereActive = array('worker.created_date >=' => $_POST['start'] , 'worker.created_date <=' => $_POST['end'],'worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id ,'worker.active_inactive' => 1,'worker.company_unit' => $_POST['company_unit']);
                $whereActive                    = array(
                    'worker.created_date >=' => $_POST['start'],
                    'worker.created_date <=' => $_POST['end'],
                    'worker.created_by_cid' => $this->companyId,
                    'worker.active_inactive' => 1,
                    'worker.company_unit' => $_POST['company_unit']
                );
                $this->data['active_workers']   = $this->production_model->get_data('worker', $whereActive);
                #$whereInactive = array('worker.created_date >=' => $_POST['start'] , 'worker.created_date <=' => $_POST['end'],'worker.created_by_cid'=> $_SESSION['loggedInUser']->c_id ,'worker.active_inactive' => 0,'worker.company_unit' => $_POST['company_unit']);
                $whereInactive                  = array(
                    'worker.created_date >=' => $_POST['start'],
                    'worker.created_date <=' => $_POST['end'],
                    'worker.created_by_cid' => $this->companyId,
                    'worker.active_inactive' => 0,
                    'worker.company_unit' => $_POST['company_unit']
                );
                $this->data['inactive_workers'] = $this->production_model->get_data('worker', $whereInactive);
            }



            /*if((isset($_POST["ExportType"]) && $_POST['start'] != '' && $_POST['end'] != ''  && $_POST['company_unit'] =='') || (isset($_POST["ExportType"]) && $_POST['start'] != '' && $_POST['end'] != ''  && $_POST['company_unit'] !='')){
            $this->load->view('workers/index', $this->data);
            }else{*/
            $this->_render_template('workers/index', $this->data);

        }
        //  }
    }

    /*worker add/edit code*/
    public function worker_edit()
    {
        $this->scripts['js'][] = 'assets/modules/purchase/js/test.js';
        $id                    = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['workers'] = $this->production_model->get_data_byId('worker', 'id', $id);
        $this->load->view('workers/edit', $this->data);
    }
    public function saveWorker()
    {
        //pre($_POST); die;
        if ($this->input->post()) {
            $required_fields = array(
                'name'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data                     = $this->input->post();
                #$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
                $data['created_by_cid']   = $this->companyId;
                $id                       = $data['id'];
                $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 59
                ));

                if ($id && $id != '') {
                    //pre($data);die;
                    // Update workers
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success           = $this->production_model->update_data('worker', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Worker Info updated successfully";
                        logActivity('Worker Info Updated', 'worker', $id);

                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Worker updated' , 'message' => 'Worker updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/



                                    pushNotification(array(
                                        'subject' => 'Worker updated',
                                        'message' => 'Worker id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $userViewPermission['user_id'],
                                        'ref_id' => $id,
                                        'class' => 'productionTab',
                                        'data_id' => 'workerView',
                                        'icon' => 'fa fa-archive'
                                    ));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*pushNotification(array('subject'=> 'Worker updated' , 'message' => 'Worker updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/



                            pushNotification(array(
                                'subject' => 'Worker updated',
                                'message' => 'Worker id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'ref_id' => $id,
                                'class' => 'productionTab',
                                'data_id' => 'workerView',
                                'icon' => 'fa fa-archive'
                            ));


                        }
                        $this->session->set_flashdata('message', 'Worker info  Updated successfully');
                        redirect(base_url() . 'production/workers', 'refresh');
                    }
                } else {
                    $id = $this->production_model->insert_tbl_data('worker', $data);
                    if ($id) {
                        logActivity('Worker Info Added ', 'worker', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {

                                    /*pushNotification(array('subject'=> 'Worker created' , 'message' => 'Worker created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/

                                    pushNotification(array(
                                        'subject' => 'Worker Created',
                                        'message' => 'New Worker is created by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $userViewPermission['user_id'],
                                        'ref_id' => $id,
                                        'class' => 'productionTab',
                                        'data_id' => 'workerView',
                                        'icon' => 'fa fa-archive'
                                    ));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array(
                                'subject' => 'Worker Created',
                                'message' => 'New Worker is created by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'ref_id' => $id,
                                'class' => 'productionTab',
                                'data_id' => 'workerView',
                                'icon' => 'fa fa-archive'
                            ));
                        }
                        $this->session->set_flashdata('message', 'Worker Info Added successfully');
                        redirect(base_url() . 'production/workers', 'refresh');
                    }
                }
            }
        }
    }
    /*Worker view code*/
    public function worker_view()
    {
        permissions_redirect('is_view');
        $id                       = $_POST['id'];
        $this->data['workerView'] = $this->production_model->get_data_byId('worker', 'id', $id);
        $this->load->view('workers/view', $this->data);
    }
    /*delete worker*/
    public function deleteWorker($id = '')
    {
        if (!$id) {
            redirect('production/workers', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->production_model->delete_data('worker', 'id', $id);
        if ($result) {
            logActivity('Worker  Deleted', 'worker', $id);
            $this->session->set_flashdata('message', 'worker Deleted Successfully');
            $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                'is_view' => 1,
                'sub_module_id' => 59
            ));

            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array(
                            'subject' => 'Worker deleted',
                            'message' => 'Worker id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                            'from_id' => $_SESSION['loggedInUser']->u_id,
                            'to_id' => $userViewPermission['user_id'],
                            'ref_id' => $id,
                            'icon' => 'fa fa-archive'
                        ));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array(
                    'subject' => 'Worker deleted',
                    'message' => 'Worker id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                    'from_id' => $_SESSION['loggedInUser']->u_id,
                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                    'ref_id' => $id,
                    'icon' => 'fa fa-archive'
                ));
            }
            $result = array(
                'msg' => 'Worker Deleted Successfully',
                'status' => 'success',
                'code' => 'C142',
                'url' => base_url() . 'production/workers'
            );
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array(
                'msg' => 'error',
                'status' => 'error',
                'code' => 'C1004'
            ));
        }
    }


    /**********active inactive status of worker ****************/
    public function change_status_worker()
    {
        $id                       = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status                   = (isset($_POST['workerStatus']) && $_POST['workerStatus'] == 1) ? '1' : '0';
        $status_data              = $this->production_model->toggle_change_status($id, $status);
        $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
            'is_view' => 1,
            'sub_module_id' => 59
        ));
        if (!empty($usersWithViewPermissions)) {
            foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {

                    pushNotification(array(
                        'subject' => 'Worker Status Changed',
                        'message' => 'Worker Status id : #' . $id . ' is changed by ' . $_SESSION['loggedInUser']->name,
                        'from_id' => $_SESSION['loggedInUser']->u_id,
                        'to_id' => $userViewPermission['user_id'],
                        'ref_id' => $id,
                        'icon' => 'fa fa-archive'
                    ));
                }
            }
        }
        if ($_SESSION['loggedInUser']->role != 1) {
            pushNotification(array(
                'subject' => 'Worker Status Changed',
                'message' => 'Worker Status id : #' . $id . ' is changed by ' . $_SESSION['loggedInUser']->name,
                'from_id' => $_SESSION['loggedInUser']->u_id,
                'to_id' => $_SESSION['loggedInCompany']->u_id,
                'ref_id' => $id,
                'icon' => 'fa fa-archive'
            ));
        }

        echo json_encode($status_data);
    }
    /******************quck add save worker ***********************/
    public function add_worker_Details_onthe_spot()
    {
        $worker_name    = $_REQUEST['name'];
        $mobile_number  = $_REQUEST['mobile_number'];
        $salary         = $_REQUEST['salary'];
        $created_by_id  = $_SESSION['loggedInUser']->u_id;
        #$created_by_cid  = $_SESSION['loggedInUser']->c_id;
        $created_by_cid = $this->companyId;
        // $last_id = getLastTableId('material');
        // $rId = $last_id + 1;
        // $matCode = 'MAT_'.rand(1, 1000000).'_'.$rId;

        $worker_details = array(
            'name' => $worker_name,
            'mobile_number' => $mobile_number,
            'salary' => $salary,
            'created_by ' => $created_by_id,
            'created_by_cid ' => $created_by_cid
        );

        //pre($matrial_details);die('there');
        $data2                    = $this->production_model->insert_on_spot_tbl_data('worker', $worker_details);
        $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
            'is_view' => 1,
            'sub_module_id' => 59
        ));
        if (!empty($usersWithViewPermissions)) {
            foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                    pushNotification(array(
                        'subject' => 'Worker Created',
                        'message' => 'New Worker is created by ' . $_SESSION['loggedInUser']->name,
                        'from_id' => $_SESSION['loggedInUser']->u_id,
                        'to_id' => $userViewPermission['user_id'],
                        'ref_id' => $data2,
                        'class' => 'productionTab',
                        'data_id' => 'workerView',
                        'icon' => 'fa fa-archive'
                    ));
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array(
                    'subject' => 'Worker Created',
                    'message' => 'New Worker is created by ' . $_SESSION['loggedInUser']->name,
                    'from_id' => $_SESSION['loggedInUser']->u_id,
                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                    'ref_id' => $id,
                    'class' => 'productionTab',
                    'data_id' => 'workerView',
                    'icon' => 'fa fa-archive'
                ));
            }
            if ($data2 > 0) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }

    /*************************************************Machine ordering****************************************************************/
    /*Main fucntion of machine ordering*/
    /*public function machine_ordering() {
    $this->data['can_edit'] = edit_permissions();
    $this->data['can_delete'] = delete_permissions();
    $this->data['can_add'] = add_permissions();
    $this->data['can_view'] = view_permissions();
    $this->breadcrumb->add('Machine Ordering', base_url() . 'Machine Ordering');
    $this->settings['breadcrumbs'] = $this->breadcrumb->output();
    $this->settings['pageTitle'] = 'Machine Ordering';
    if(!empty($_POST)){
    $where = array('add_machine.created_date >=' => $_POST['start'] , 'add_machine.created_date <=' => $_POST['end'],'add_machine.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
    $this->data['machine_order']  = $this->production_model->get_data('add_machine',$where);
    $this->load->view('machine_ordering/index', $this->data);
    }else{
    $where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id);
    $this->data['machine_order']  = $this->production_model->get_data('add_machine',$where);
    $this->_render_template('machine_ordering/index', $this->data);
    }
    }*/



    /*change orering of machine and update in database*/
    public function changeMachineOrderPriority()
    {
        $machine_orders         = $_POST['order'];
        $machine_order_priority = $this->production_model->changeMachineOrderPriority($machine_orders);
        $result                 = array(
            'msg' => 'Machine Order set successfully',
            'status' => 'success',
            'code' => 'C142',
            'url' => ''
        );
        echo json_encode($result);
        die;
    }


    /*approve indent*/
    public function approveJobCard()
    {
        if ($_POST['id'] && $_POST['id'] != '') {
            $data   = array(
                'approve' => $_POST['approve'],
                'validated_by' => $_POST['validated_by'],
                'disapprove_reason' => '',
                'disapprove' => 0
            );
            $result = $this->production_model->approveJobCard($_POST);
            if ($result) {
                logActivity('Bom Routing Approved', 'job_card', $_POST['id']);
                $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 20
                ));
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array(
                                'subject' => 'Bom Routing Approved',
                                'message' => 'Bom Routing id : #' . $id . ' is approved by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $userViewPermission['user_id'],
                                'ref_id' => $_POST['id'],
                                'icon' => 'fa fa-archive'
                            ));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array(
                        'subject' => 'Bom Routing Approved',
                        'message' => 'Bom Routing id : #' . $id . ' is approved by ' . $_SESSION['loggedInUser']->name,
                        'from_id' => $_SESSION['loggedInUser']->u_id,
                        'to_id' => $_SESSION['loggedInCompany']->u_id,
                        'ref_id' => $_POST['id'],
                        'icon' => 'fa fa-archive'
                    ));
                }
                $this->session->set_flashdata('message', 'Bom Routing approved');
                $result = array(
                    'msg' => 'Bom Routing approved',
                    'status' => 'success',
                    'code' => 'C296',
                    'url' => base_url() . 'production/bom_routing'
                );
                echo json_encode($result);
                die;
            } else {
                echo json_encode(array(
                    'msg' => 'error',
                    'status' => 'error',
                    'code' => 'C301'
                ));
            }
        }
    }

    public function approveJobCardSelectAll()
    {
        if ($_POST['id'] && $_POST['id'] != '') {
            $id                = $this->input->get_post('id');
            $approve           = $this->input->get_post('approve');
            $validated_by      = $this->input->get_post('validated_by');
            $disapprove_reason = "";
            $disapprove        = "0";
            foreach ($id as $key) {
                $data   = array(
                    'id' => $key,
                    'approve' => $_POST['approve'],
                    'validated_by' => $_POST['validated_by'],
                    'disapprove_reason' => '',
                    'disapprove' => 0
                );
                $result = $this->production_model->approveJobCard($data);
                logActivity('Job Card Approved', 'job_card', $key);
            }
            if ($result) {
                $this->session->set_flashdata('message', 'Job card approved');
                $result = array(
                    'msg' => 'Job card approved',
                    'status' => 'success',
                    'code' => 'C296',
                    'url' => base_url() . 'production/bom_routing'
                );
                echo json_encode($result);
                die;
            } else {
                echo json_encode(array(
                    'msg' => 'error',
                    'status' => 'error',
                    'code' => 'C301'
                ));
            }
        }
    }



    /*disarppove indent*/
    public function disApproveJobCard()
    {
        if ($this->input->post()) {
            $required_fields = array(
                'disapprove_reason'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $idss = $_POST['id'];
                $id   = explode(",", $idss);
                foreach ($id as $key) {
                    $data    = array(
                        'id' => $key,
                        'validated_by' => $_POST['validated_by'],
                        'disapprove' => $_POST['disapprove'],
                        'approve' => $_POST['approve'],
                        'disapprove_reason' => $_POST['disapprove_reason']
                    );
                    $success = $this->production_model->disApproveJobCard($data);
                    logActivity('Job Card Disapproved', 'job_card', $key);
                }
                if ($success) {
                    $data['message'] = "Indent Disapproved";
                    $this->session->set_flashdata('message', 'Job Card Disapproved successfully');
                    redirect(base_url() . 'production/bom_routing', 'refresh');
                }
            }
        }
    }

    /**************electricyt unit price**********************/
    /*public function electr_unit_price_edit(){
    //pre("hello"); die;
    $id=$_POST['id'];

    if($id != ''){
    permissions_redirect('is_edit');
    }else{
    permissions_redirect('is_add');
    }

    $this->data['unit_price']= $this->production_model->get_data_byId('electricity_unit','id',$id);
    // $ddt = $this->production_model->get_data_byId('electricity_unit','id',$id);
    // pre($ddt);die();

    //pre($this->data['machine_group']);die;
    $this->load->view('production_setting/electricty_unit_price', $this->data);
    //$this->_render_template('production_setting/electricty_unit_price', $this->data);
    }

    /*save electricyt unit**************/
    /*public function save_electricity_unit(){
    //pre($_POST);die;
    if ($this->input->post()) {
    $required_fields = array('electr_unit_price');
    $is_valid = validate_fields($_POST, $required_fields);
    if (count($is_valid) > 0) {
    valid_fields($is_valid);
    }
    else{
    $data  = $this->input->post();
    $id=$data['id'];
    $data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
    if($id && $id != ''){
    $data['edited_by'] = $_SESSION['loggedInUser']->u_id ;
    $success = $this->production_model->update_data('electricity_unit',$data, 'id', $id);
    if ($success) {
    $data['message'] = "Machine group updated successfully";
    logActivity('Electricity Unit Price Updated','electricity_unit',$id);
    $this->session->set_flashdata('message', 'Electricity Unit Price Updated successfully');
    redirect(base_url().'production/production_setting', 'refresh');
    }
    }else{
    $id = $this->production_model->insert_tbl_data('electricity_unit',$data);
    if ($id) {
    logActivity('Electricity Unit Price  inserted','electricity_unit',$id);
    $this->session->set_flashdata('message', 'Electricity Unit Price inserted successfully');
    redirect(base_url().'production/production_setting', 'refresh');
    }
    }

    }
    }
    }*/
    /*production setting delete*/
    /*public function deleteElectricityUnit($id = ''){
    if (!$id) {
    redirect('production/production_setting', 'refresh');
    }
    permissions_redirect('is_delete');
    $result = $this->production_model->delete_data('electricity_unit','id',$id);
    if($result) {
    logActivity('Deleted','electricity_unit',$id);
    $this->session->set_flashdata('message', 'Deleted Successfully');
    $result = array('msg' => 'Deleted Successfully', 'status' => 'success', 'code' => 'C142','url' => base_url() . 'production/production_setting');
    echo json_encode($result);
    die;
    }
    else {
    echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C2090'));
    }
    }
    */
    public function getWorkerSalaryData()
    {
        $a          = implode(',', $_POST['data']);
        $get_salary = $this->production_model->get_worker_salary('worker', $a);

        echo json_encode($get_salary);
    }

    /****************wages or perpeiece***************************/
    public function prodWages_perPiece_edit()
    {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['wages_perpiece'] = $this->production_model->get_data_byId('wages_perpiece_setting', 'id', $id);
        $this->load->view('production_setting/wages_perpiece_edit', $this->data);
        //$this->_render_template('production_setting/wages_perpiece_edit', $this->data);
    }

    /*****************************save wages******************************/
    public function saveWages_perpiece()
    {
        if ($this->input->post()) {
            $required_fields = array(
                'wages_perPiece'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data                     = $this->input->post();
                $id                       = $data['id'];
                #$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
                $data['created_by_cid']   = $this->companyId;
                $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 21
                ));
                //if($data['company_unit'] && $data['department']){
                //}
                //if($departAndCompany){
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success           = $this->production_model->update_data('wages_perpiece_setting', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "updated successfully";
                        logActivity('Updated', 'wages_unit_setting', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array(
                                        'subject' => 'Wages/per piece setting updated',
                                        'message' => 'Wages/per piece setting updated id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $userViewPermission['user_id'],
                                        'ref_id' => $id,
                                        'icon' => 'fa fa-archive'
                                    ));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array(
                                'subject' => 'Wages/per piece setting updated',
                                'message' => 'Wages/per piece setting updated id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'ref_id' => $id,
                                'icon' => 'fa fa-archive'
                            ));
                        }
                        $this->session->set_flashdata('message', 'Updated successfully');
                        redirect(base_url() . 'production/production_setting', 'refresh');
                    }
                } else {
                    $departAndCompany = $this->production_model->compAndDepartExist('wages_perpiece_setting', $data['company_unit'], $data['department']);
                    if ($departAndCompany) {
                        $this->session->set_flashdata('message', 'Already Exist');
                        redirect(base_url() . 'production/production_setting', 'refresh');
                    } else {
                        $id = $this->production_model->insert_tbl_data('wages_perpiece_setting', $data);
                        if ($id) {
                            logActivity('inserted', 'wages_unit_setting', $id);
                            if (!empty($usersWithViewPermissions)) {
                                foreach ($usersWithViewPermissions as $userViewPermission) {
                                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                        pushNotification(array(
                                            'subject' => 'Wages/per piece setting created',
                                            'message' => 'Wages/per piece setting created by ' . $_SESSION['loggedInUser']->name,
                                            'from_id' => $_SESSION['loggedInUser']->u_id,
                                            'to_id' => $userViewPermission['user_id'],
                                            'ref_id' => $id,
                                            'icon' => 'fa fa-archive'
                                        ));
                                    }
                                }
                            }
                            if ($_SESSION['loggedInUser']->role != 1) {
                                pushNotification(array(
                                    'subject' => 'Wages/per piece setting created',
                                    'message' => 'Wages/per piece setting created by ' . $_SESSION['loggedInUser']->name,
                                    'from_id' => $_SESSION['loggedInUser']->u_id,
                                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                                    'ref_id' => $id,
                                    'icon' => 'fa fa-archive'
                                ));
                            }
                            $this->session->set_flashdata('message', 'inserted successfully');
                            redirect(base_url() . 'production/production_setting', 'refresh');
                        }
                    }
                }
            }
        }
    }
    public function deleteWagesSetting($id = '')
    {
        if (!$id) {
            redirect('production/production_setting', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->production_model->delete_data('wages_perpiece_setting', 'id', $id);
        if ($result) {
            logActivity('Deleted', 'wages_perpiece_setting', $id);
            $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                'is_view' => 1,
                'sub_module_id' => 19
            ));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array(
                            'subject' => 'Wages/per piece setting deleted',
                            'message' => 'Wages/per piece setting deleted id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                            'from_id' => $_SESSION['loggedInUser']->u_id,
                            'to_id' => $userViewPermission['user_id'],
                            'ref_id' => $id,
                            'icon' => 'fa fa-archive'
                        ));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array(
                    'subject' => 'Wages/per piece setting deleted',
                    'message' => 'Wages/per piece setting deleted id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                    'from_id' => $_SESSION['loggedInUser']->u_id,
                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                    'ref_id' => $id,
                    'icon' => 'fa fa-archive'
                ));
            }
            $this->session->set_flashdata('message', 'Deleted Successfully');
            $result = array(
                'msg' => 'Deleted Successfully',
                'status' => 'success',
                'code' => 'C142',
                'url' => base_url() . 'production/production_setting'
            );
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array(
                'msg' => 'error',
                'status' => 'error',
                'code' => 'C2090'
            ));
        }
    }

    /*dashboard code to display on main dashboard*/
    public function showDashboardOnRequirement()
    {
        $data            = $_POST;
        $data['user_id'] = $_SESSION['loggedInUser']->id;
        $user_dashboard  = $this->production_model->get_data_dashboard('user_dashboard', array(
            'user_id' => $_SESSION['loggedInUser']->id,
            'graph_id' => $data['graph_id']
        ));
        if (!empty($user_dashboard)) {
            //$id = $this->production_model->update_data('user_dashboard',$data,'id',$user_dashboard[0]['id']);
            $id = $this->production_model->update_user_graph_data('user_dashboard', $data);
        } else {
            $id = $this->production_model->insert_tbl_data('user_dashboard', $data);
        }
        if ($id) {
            $result = array(
                'msg' => 'Data for user set',
                'status' => 'success',
                'code' => 'C296',
                'url' => base_url() . 'production_model/dashboard'
            );
            echo json_encode($result);
            die;
        }
    }
    /****************function to check if same date data exist in productiondata at conversion from planning***/
    public function getData_fromProd_basedOnDate()
    {
        if (isset($_POST['selected_date'])) {
            $result = $this->production_model->get_data_accrdingToDate('production_data', 'date', $_POST['selected_date']);
        } else if (isset($_POST['selected_planning_date'])) {
            $result = $this->production_model->get_data_accrdingToDate('production_planning', 'date', $_POST['selected_planning_date']);
        }
        if ($result) {
            echo json_encode($result);
        } else {
            echo "No Data Of This Data Exist";
        }
    }


    /*******************************************************************************************************************************************************Sale order dipstahc functionality in production*********************************/
    /**********************dispatched sales order which are approved********************/
    public function sale_order_with_production()
    {
         $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Sale order', base_url() . 'sale_order_with_production');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Sale Order';
         $where = "sale_order.created_by_cid = " . $this->companyId . " AND sale_order.approve = 1   AND sale_order.complete_status= 0";
               #$completedSaleOrderWhere = array('sale_order.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'sale_order.complete_status' => 1);
         $completedSaleOrderWhere = array(
                    'sale_order.created_by_cid' => $this->companyId,
                    'sale_order.complete_status' => 1
                );

                #$saleOrderWhere = array('sale_order.created_by_cid'=>$_SESSION['loggedInUser']->c_id,'sale_order.approve'=>1);
        $saleOrderWhere = array(
                    'sale_order.created_by_cid' => $this->companyId,
                    'sale_order.approve' => 1
                );
                  #$saleOrderPriority = array('sale_order.created_by_cid'=>$_SESSION['loggedInUser']->c_id,'sale_order.approve'=>1,'sale_order.complete_status' => 0);
        $saleOrderPriority                  = array(
                    'sale_order.created_by_cid' => $this->companyId,
                    'sale_order.approve' => 1,
                    'sale_order.complete_status' => 0
                );
           if (isset($_GET['favourites'])!='' && isset($_GET['ExportType'])=='') {
            #$where = "sale_order.created_by_cid = ".$_SESSION['loggedInUser']->c_id." AND sale_order.approve = 1   AND sale_order.complete_status= 0 AND sale_order.favourite_sts = 1";
            $where                             = "sale_order.created_by_cid = " . $this->companyId . " AND sale_order.approve = 1   AND sale_order.complete_status= 0 AND sale_order.favourite_sts = 1";
            #$completedSaleOrderWhere = array('sale_order.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'sale_order.complete_status' => 1 , 'sale_order.favourite_sts' => 1);
            $completedSaleOrderWhere           = array(
                'sale_order.created_by_cid' => $this->companyId,
                'sale_order.complete_status' => 1,
                'sale_order.favourite_sts' => 1
            );
            #$saleOrderWhere = array('sale_order.created_by_cid'=>$_SESSION['loggedInUser']->c_id,'sale_order.approve'=>1 , 'sale_order.favourite_sts' =>1);
            $saleOrderWhere = array(
                'sale_order.created_by_cid' => $this->companyId,
                'sale_order.approve' => 1,
                'sale_order.favourite_sts' => 1
            );

            #$saleOrderPriority = array('sale_order.created_by_cid'=>$_SESSION['loggedInUser']->c_id,'sale_order.approve'=>1,'sale_order.complete_status' => 0);
            $saleOrderPriority                  = array(
                'sale_order.created_by_cid' => $this->companyId,
                'sale_order.approve' => 1,
                'sale_order.complete_status' => 0
            );
}

        if (isset($_GET['start'] ) && $_GET['start']!=''&& $_GET['end'] != ''&& $_GET['favourites']=='') {
                #$where = array('sale_order.created_date >=' => $_GET['start'] , 'sale_order.created_date <=' => $_GET['end'],'sale_order.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'sale_order.approve' => 1  , 'sale_order.complete_status'=> 0);
                $where                             = array(
                    'sale_order.created_date >=' => $_GET['start'],
                    'sale_order.created_date <=' => $_GET['end'],
                    'sale_order.created_by_cid' => $this->companyId,
                    'sale_order.approve' => 1,
                    'sale_order.complete_status' => 0
                );

                #$completedSaleOrderWhere = array('sale_order.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'sale_order.complete_status' => 1);
                $completedSaleOrderWhere           = array(
                    'sale_order.created_by_cid' => $this->companyId,
                    'sale_order.complete_status' => 1,
                     'sale_order.created_date >=' => $_GET['start'],
                    'sale_order.created_date <=' => $_GET['end'],
                );

                #$saleOrderWhere = array('sale_order.created_by_cid'=>$_SESSION['loggedInUser']->c_id,'sale_order.approve'=>1);
                $saleOrderWhere            = array(
                    'sale_order.created_by_cid' => $this->companyId,
                    'sale_order.approve' => 1,
                     'sale_order.created_date >=' => $_GET['start'],
                    'sale_order.created_date <=' => $_GET['end'],
                );


                #$saleOrderPriority = array('sale_order.created_by_cid'=>$_SESSION['loggedInUser']->c_id,'sale_order.approve'=>1,'sale_order.complete_status' => 0);
                $saleOrderPriority                  = array(
                    'sale_order.created_by_cid' => $this->companyId,
                    'sale_order.approve' => 1,
                    'sale_order.complete_status' => 0
                );
             }

            if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == ''&& $_GET['favourites']=='') {

                if(isset($_GET['tab'] ) && $_GET['tab']=='complete')
            {

                $completedSaleOrderWhere           = array(
                    'sale_order.created_by_cid' => $this->companyId,
                    'sale_order.complete_status' => 1
                );
            }else{

                $saleOrderWhere            = array(
                    'sale_order.created_by_cid' => $this->companyId,
                    'sale_order.approve' => 1
                );
            }
      }elseif(isset($_GET["ExportType"]) && $_GET['start']!=''&& $_GET['end'] != ''&& $_GET['favourites']=='') {
              #$completedSaleOrderWhere = array('sale_order.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'sale_order.complete_status' => 1);
                $where                             = array(
                    'sale_order.created_date >=' => $_GET['start'],
                    'sale_order.created_date <=' => $_GET['end'],
                    'sale_order.created_by_cid' => $this->companyId,
                    'sale_order.approve' => 1,
                    'sale_order.complete_status' => 0
                );

                #$completedSaleOrderWhere = array('sale_order.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'sale_order.complete_status' => 1);
                $completedSaleOrderWhere           = array(
                    'sale_order.created_by_cid' => $this->companyId,
                    'sale_order.complete_status' => 1,
                     'sale_order.created_date >=' => $_GET['start'],
                    'sale_order.created_date <=' => $_GET['end'],
                );

                #$saleOrderWhere = array('sale_order.created_by_cid'=>$_SESSION['loggedInUser']->c_id,'sale_order.approve'=>1);
                $saleOrderWhere            = array(
                    'sale_order.created_by_cid' => $this->companyId,
                    'sale_order.approve' => 1,
                     'sale_order.created_date >=' => $_GET['start'],
                    'sale_order.created_date <=' => $_GET['end'],
                );


                #$saleOrderPriority = array('sale_order.created_by_cid'=>$_SESSION['loggedInUser']->c_id,'sale_order.approve'=>1,'sale_order.complete_status' => 0);
                $saleOrderPriority                  = array(
                    'sale_order.created_by_cid' => $this->companyId,
                    'sale_order.approve' => 1,
                    'sale_order.complete_status' => 0
                );

             }elseif (isset($_GET["ExportType"]) && $_GET['start']==''&& $_GET['end']== ''&& $_GET['favourites']!='') {
            if(isset($_GET['tab']) && $_GET['tab']=='complete')
            {
            $completedSaleOrderWhere           = array(
                'sale_order.created_by_cid' => $this->companyId,
                'sale_order.complete_status' => 1,
                'sale_order.favourite_sts' => 1
            );
            }else{
            #$saleOrderWhere = array('sale_order.created_by_cid'=>$_SESSION['loggedInUser']->c_id,'sale_order.approve'=>1 , 'sale_order.favourite_sts' =>1);
            $saleOrderWhere = array(
                'sale_order.created_by_cid' => $this->companyId,
                'sale_order.approve' => 1,
                'sale_order.favourite_sts' => 1
            );
            }
        }

        //Search
        $where2                        = '';
        $search_string                 = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $materialName=getNameById('material',$search_string,'material_name');
            $accountName=getNameById('account',$search_string,'name');
        if($materialName->id !=''){
                $json_dtl ='{"product" : "'.$materialName->id.'"}';
                $where2 = "sale_order.product!='' && json_contains(`product`, '".$json_dtl."')" ;
            }elseif($accountName->id!=''){
                 $where2 = "sale_order.account_id ='%" .$accountName->id. "%'";
                }else{
                 $where2 = "sale_order.id ='%" . $search_string . "%'";
            }
           redirect("production/sale_order_with_production/?search=$search_string");
        } elseif (isset($_GET['search']) && $_GET['search']!='') {
           $materialName=getNameById('material',$_GET['search'],'material_name');
            $accountName=getNameById('account',$_GET['search'],'name');
        if($materialName->id !=''){
                $json_dtl ='{"product" : "'.$materialName->id.'"}';
                $where2 = "sale_order.product!='' && json_contains(`product`, '".$json_dtl."')" ;
            }elseif($accountName->id!=''){
                 $where2 = "sale_order.account_id='" .$accountName->id. "'";
                }else{
                 $where2 = "sale_order.id ='" .$_GET['search']. "'";
        }
        }
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = "desc";
        }
        //Pagination
        // 1 for complete sale order
        // 1 for approve sale order

        if (isset($_GET['tab']) && $_GET['tab'] == 'inprocess' && $_GET['tab'] != 'complete') {
            $rows = $this->production_model->num_rows('sale_order', $saleOrderWhere, $where2);
        } elseif (isset($_GET['tab']) && $_GET['tab'] == 'complete' && $_GET['tab']!= 'inprocess') {
            $rows = $this->production_model->num_rows('sale_order',$completedSaleOrderWhere, $where2);
        } else {
            $rows = $this->production_model->num_rows('sale_order',$saleOrderWhere, $where2);
        }
        //$this->production_model->num_rows('sale_order',array('sale_order.created_by_cid'=> $this->companyId ,'sale_order.approve'=>1,'sale_order.complete_status' => 0),$where2);
        $config                       = array();
        $config["base_url"]           = base_url() . "production/sale_order_with_production/";
        $config["total_rows"]         = $rows;
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if(!empty($_GET['ExportType'])){
            $export_data = 1;
        }else{
            $export_data = 0;
        }

        if( !isset($_GET['tab']) ){
            $_GET['tab'] = "";
        }

        if (isset($_GET['tab']) && $_GET['tab'] == 'complete' && $_GET['tab']!= 'inprocess') {
        $this->data['complete_sale_order'] = $this->production_model->get_data1('sale_order', $completedSaleOrderWhere, $config["per_page"], $page, $where2, $order,$export_data);
        }else if ($_GET['tab'] == 'inprocess' && $_GET['tab'] != 'complete') {
        $this->data['sale_order_approved'] = $this->production_model->get_data1('sale_order',$saleOrderWhere, $config["per_page"], $page, $where2, $order,$export_data);
        }else{
        $this->data['sale_order_approved'] = $this->production_model->get_data1('sale_order',$saleOrderWhere, $config["per_page"], $page, $where2, $order,$export_data);
        $this->data['complete_sale_order'] = $this->production_model->get_data1('sale_order', $completedSaleOrderWhere, $config["per_page"], $page, $where2, $order,$export_data);
        $this->data['sale_orders_priority'] = $this->production_model->get_data1('sale_order', $saleOrderPriority, $config["per_page"], $page, $where2, $order,$export_data);
            }
            if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }
        $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
        $this->_render_template('sale_order_with_production/index', $this->data);
            }


        /*if(!empty($_POST)){
        $this->load->view('sale_order_with_production/index', $this->data);
        }else{
        $this->_render_template('sale_order_with_production/index', $this->data);
        }*/


    public function dispatched_sale_order()
    {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->production_model->get_data('user_detail');

        /*$dispatchData = $this->crm_model->get_data_byId('sale_order_dispatch','sale_order_id',$this->input->post('id'));
        if(!empty($dispatchData)){
        $this->data['sale_order'] = $dispatchData;
        }else{*/
        $this->data['sale_order'] = $this->production_model->get_data_byId('sale_order', 'id', $this->input->post('id'));
        //}

        $this->data['sale_order_dispatch'] = $this->production_model->get_data('sale_order_dispatch', array(
            'sale_order_id' => $this->input->post('id')
        ));
        //$this->data['materials']  = $this->crm_model->get_data('material');
        $whereAttachment                   = array(
            'rel_id' => $this->input->post('id'),
            'rel_type' => 'sale_order'
        );
        $this->data['attachments']         = $this->production_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
        $this->load->view('sale_order_with_production/dispatched_saleOrder', $this->data);
    }
    public function saveDispatchSaleOrder()
    {
        if ($this->input->post()) {
            $required_fields = array(
                'account_id',
                'product',
                'quantity',
                'uom',
                'price'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data                      = $this->input->post();
                $products                  = count($_POST['product']);
                $sale_order_priority_array = array();
                if ($products > 0) {
                    $arr = array();
                    $i   = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array(
                            'product' => $_POST['product'][$i],
                            'description' => $_POST['description'][$i],
                            'quantity' => $_POST['quantity'][$i],
                            'uom' => $_POST['uom'][$i],
                            'price' => $_POST['price'][$i],
                            'gst' => $_POST['gst'][$i],
                            'individualTotal' => $_POST['individualTotal'][$i],
                            'individualTotalWithGst' => $_POST['individualTotalWithGst'][$i]
                        );
                        $arr[$i]         = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $data['created_by']         = $_SESSION['loggedInUser']->id;
                #$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid']     = $this->companyId;
                $data['product']            = $product_array;
                $data['dispatch_documents'] = isset($data['dispatch_documents']) ? json_encode($data['dispatch_documents']) : '';
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                //  $data['payment_terms'] = json_encode($data['payment_terms']);
                $id                         = $data['id'];
                #pre($data); die;


                if ($id && $id != '') {
                    $success = $this->production_model->update_data('sale_order_dispatch', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Sale Order dispatch updated successfully";
                        logActivity('Sale Order dispatch Updated', 'lead', $id);


                        $this->session->set_flashdata('message', 'Sale Order dispatch Updated successfully');
                    }
                } else {
                    $id = $this->production_model->insert_tbl_data('sale_order_dispatch', $data);
                    if ($id) {
                        logActivity('Sale Order Dispatched', 'Sale Order Dispatched', $id);
                        $this->session->set_flashdata('message', 'Sale Order Dispatched successfully');
                    }
                }
                if ($id) {
                    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                        $attachment_array = array();
                        $certificateCount = count($_FILES['attachment']['name']);
                        for ($i = 0; $i < $certificateCount; $i++) {
                            $filename                = $_FILES['attachment']['name'][$i];
                            $tmpname                 = $_FILES['attachment']['tmp_name'][$i];
                            $type                    = $_FILES['attachment']['type'][$i];
                            $error                   = $_FILES['attachment']['error'][$i];
                            $size                    = $_FILES['attachment']['size'][$i];
                            $exp                     = explode('.', $filename);
                            $ext                     = end($exp);
                            $newname                 = $exp[0] . '_' . time() . "." . $ext;
                            $config['upload_path']   = 'assets/modules/crm/uploads/';
                            $config['upload_url']    = base_url() . 'assets/modules/crm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size']      = '2000000';
                            $config['file_name']     = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id']    = $id;
                            $attachment_array[$i]['rel_type']  = 'sale_order_dispatch';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->production_model->insert_attachment_data('attachments', $attachment_array, 'crm/editSaleOrder/' . $data['id']);
                        }
                    }


                    /* insert sale order priority */
                }
                redirect(base_url() . 'production/sale_order_with_production', 'refresh');
            }
        }
    }
    public function completeSaleOrder()
    {
        if ($_POST['id'] && $_POST['id'] != '') {
            #$data = array('complete_status' => $_POST['complete_status'] , 'completed_by' => $_POST['completed_by']);
            $result = $this->production_model->completeSaleOrder($_POST);
            if ($result) {
                logActivity('Sale order dispatched completely', 'sale_order', $_POST['id']);
                $this->session->set_flashdata('message', 'Sale order dispatched compeltely');
                $result = array(
                    'msg' => 'Sale order  dispatched compltely',
                    'status' => 'success',
                    'code' => 'C296',
                    'url' => base_url() . 'production/sale_order_with_production'
                );
                echo json_encode($result);
                die;
            } else {
                echo json_encode(array(
                    'msg' => 'error',
                    'status' => 'error',
                    'code' => 'C301'
                ));
            }
        }
    }
    public function dispatched_sale_order_view($id = '')
    {
        if ($this->input->post('id')) {
            permissions_redirect('is_view');
        }
        $this->data['id']          = $this->input->post('id');
        $this->data['users']       = $this->production_model->get_data('user_detail');
        $this->data['sale_order']  = $this->production_model->get_data_byId('sale_order', 'id', $this->input->post('id'));
        $this->data['work_orders'] = $this->production_model->get_data('work_order', array(
            'sale_order_id' => $this->input->post('id')
        ));

        $this->data['sale_order_dispatch']  = $this->production_model->get_dispatch_data('sale_order_dispatch', array(
            'sale_order_id' => $this->input->post('id')
        ));
        $whereAttachment                    = array(
            'rel_id' => $this->input->post('id'),
            'rel_type' => 'sale_order'
        );
        $whereDispatchAttachment            = array(
            'rel_id' => $this->input->post('id'),
            'rel_type' => 'sale_order_dispatch'
        );
        $this->data['attachments']          = $this->production_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->data['dispatch_attachments'] = $this->production_model->get_attachmets_by_saleOrderId('attachments', $whereDispatchAttachment);
        $this->load->view('sale_order_with_production/view', $this->data);

    }
     public function dispatched_sale_order_matview($id = ''){
        if ($this->input->post('id')) {
            permissions_redirect('is_view');
        }
        $this->data['id']          = $this->input->post('id');
        $this->data['users']       = $this->production_model->get_data('user_detail');
        $this->data['sale_order']  = $this->production_model->get_data_byId('sale_order', 'id', $this->input->post('id'));
        $this->data['work_orders'] = $this->production_model->get_data('work_order', array(
            'sale_order_id' => $this->input->post('id')
        ));

        $this->data['sale_order_dispatch']  = $this->production_model->get_dispatch_data('sale_order_dispatch', array(
            'sale_order_id' => $this->input->post('id')
        ));
        $whereAttachment                    = array(
            'rel_id' => $this->input->post('id'),
            'rel_type' => 'sale_order'
        );
        $whereDispatchAttachment            = array(
            'rel_id' => $this->input->post('id'),
            'rel_type' => 'sale_order_dispatch'
        );
        $this->data['attachments']          = $this->production_model->get_attachmets_by_saleOrderId('attachments', $whereAttachment);
        $this->data['dispatch_attachments'] = $this->production_model->get_attachmets_by_saleOrderId('attachments', $whereDispatchAttachment);
        $this->load->view('sale_order_with_production/matview', $this->data);

    }
    public function set_dispatch_Date()
    {
        $id                              = $_POST['id'];
        /*if($id != ''){
        permissions_redirect('is_edit');
        }else{
        permissions_redirect('is_add');
        }*/
        $this->data['set_dispatch_date'] = $this->production_model->get_data_byId('sale_order', 'id', $id);

        $this->load->view('sale_order_with_production/set_dispatch_date', $this->data);
    }
    public function saveDispatchDate()
    {
        //pre($_POST); die;
        $dispatch_date = count($_POST['production_dispatch_date']);
        if ($dispatch_date > 0 && $_POST['production_dispatch_date'][0] != '') {
            $arr = array();
            $i   = 0;
            while ($i < $dispatch_date) {
                $jsonArrayObject = (array(
                    'dispatch_date' => $_POST['production_dispatch_date'][$i],
                    'approveby' => $_POST['approveby'][$i]
                ));
                $arr[$i]         = $jsonArrayObject;
                $i++;
            }
            $date_parameter_array = json_encode($arr);
        } else {
            $date_parameter_array = '';
        }
        ///pre($date_parameter_array); die;
        if ($this->input->post()) {
            $data                             = $this->input->post();
            $json                             = (array(
                'dispatch_date' => $_POST['production_dispatch_date'],
                 'approveby' => $_POST['approveby']
            ));
            //pre($json);
            //$data['production_dispatch_date'] = isset($data['production_dispatch_date'])?json_encode($data['production_dispatch_date']):'';
            $data['production_dispatch_date'] = isset($data['production_dispatch_date']) ? json_encode($json) : '';
            //pre($data['production_dispatch_date']);die;
            $id                               = $data['id'];
            if ($id && $id != '') {
                $success = $this->production_model->update_singleField_data('sale_order_dispatch', $data['production_dispatch_date'], 'sale_order_id', $id);
                $success = $this->production_model->update_singleField_data('sale_order', $data['production_dispatch_date'], 'id', $id);
                if ($success) {
                    $data['message'] = "Sale Order dispatch Date updated successfully";
                    logActivity('Sale Order dispatch Date Updated', 'lead', $id);
                    $this->session->set_flashdata('message', 'Sale Order dispatch Date Updated successfully');
                }
            }
            redirect(base_url() . 'production/sale_order_with_production', 'refresh');
        }
    }
    public function machine_viewmat(){
        $id                       = $_POST['id'];
        $this->data['AddMachine'] = $this->production_model->get_data_byId('add_machine', 'id', $id);
        $this->load->view('Add_machine/viewmat', $this->data);
    }

    public function work_order_viewmat($id = '')
    {
        if ($this->input->post('id')) {
            permissions_redirect('is_view');
        }
        $this->data['id']         = $this->input->post('id');
        $this->data['work_order'] = $this->production_model->get_data_byId('work_order', 'id', $this->input->post('id'));
        $this->load->view('work_order/viewmat', $this->data);

    }


    /******************create sale order pdf********************************/
    public function create_sale_order_pdf($id = '')
    {
        $this->load->library('Pdf');
        $dataPdf = $this->production_model->get_data_byId('sale_order', 'id', $id);
        create_pdf($dataPdf, 'modules/production/views/sale_order_with_production/view_saleorder_pdf.php');
        $this->load->view('sale_orders/view_saleOrder_pdf');
    }

    /******************get shift data accrdng to department selected in prod data and planning******************************************/
    public function getShiftAccrdngToDept()
    {
        $company_unit = $_POST['company_unit'];
        $dept         = $_POST['department'];
        $shiftData    = $this->production_model->get_shiftdata_withDept('production_setting', $company_unit, $dept);
        if ($shiftData) {
            echo json_encode($shiftData);
        } else {
            echo 'gg';

        }
    }
    /**************************************work order *************************************************************************************/
    public function work_order()
    {
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Work Order', base_url() . 'work_order');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Work Order';
        //pre($_GET['tab']);
        $where  = '';
        // $where22  = '';
        // $where33  = '';
         if($_GET['tab'] == 'inprocess_tab' && $_GET['tab'] != 'complete_tab' && $_GET['tab'] == 'inactive_tab' && $_GET['tab'] != 'priority_tab'){
            $where  = "work_order.inprocess_complete = 0 AND work_order.active_inactive = 1 AND work_order.created_by_cid = " . $this->companyId;
         }elseif($_GET['tab'] == 'complete_tab' && $_GET['tab'] != 'inprocess_tab' && $_GET['tab'] != 'inactive_tab' && $_GET['tab'] != 'priority_tab'){
            $where  = "work_order.inprocess_complete = 1 AND work_order.active_inactive = 1 AND work_order.created_by_cid = " . $this->companyId;
         }elseif($_GET['tab'] == 'inactive_tab' && $_GET['tab'] != 'inprocess_tab' && $_GET['tab'] != 'complete_tab' && $_GET['tab'] != 'priority_tab'){
            $where  = "work_order.active_inactive = 0 AND work_order.created_by_cid = " . $this->companyId;
         }elseif($_GET['tab'] == 'priority_tab' && $_GET['tab'] != 'inprocess_tab' && $_GET['tab'] != 'complete_tab' && $_GET['tab'] != 'inactive_tab'){
            $where  = "work_order.inprocess_complete = 0 AND work_order.active_inactive = 1 AND work_order.created_by_cid = " . $this->companyId;
         }else{
             $where  = "work_order.inprocess_complete = 0 AND work_order.active_inactive = 1 AND work_order.created_by_cid = " . $this->companyId;
         }

        if(isset($_GET['material_status']) && $_GET['material_status']){
            $where                    = array(
                'work_order.created_by_cid' => $this->companyId,
                'work_order.active_inactive' => 1,
                'work_order.inprocess_complete' => 0,
                'work_order.work_order_material_status' => $_GET['material_status']
            );
        }

        if(isset($_GET['production_status'])){
            $where                    = array(
                'work_order.created_by_cid' => $this->companyId,
                'work_order.active_inactive' => 1,
                'work_order.inprocess_complete' => 0,
                'work_order.work_order_production_status' => $_GET['production_status']
            );
        }


         if (isset($_GET['favourites']) && $_GET['favourites']!='' && $_GET['start'] == '' && $_GET['end'] == '' ) {


            $where                    = array(
                'work_order.created_by_cid' => $this->companyId,
                'work_order.favourite_sts' => 1,
                'work_order.inprocess_complete' => 0
            );

            // $where2 = array(
            //     'work_order.created_by_cid' => $this->companyId,
            //     'work_order.favourite_sts' => 1);
         }

           if (isset($_GET['start'])!='' && isset($_GET['end'])!=''&& $_GET['favourites']=='') {
                #$where = array('work_order.created_date >=' => $_GET['start'] , 'work_order.created_date <=' => $_GET['end'],'work_order.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where                    = array(
                    'work_order.created_date >=' => $_GET['start'],
                    'work_order.created_date <=' => $_GET['end'],
                    'work_order.created_by_cid' => $this->companyId,
                    'work_order.inprocess_complete' => 0
                );
            }

            if (isset($_GET["company_branch_id"]) && $_GET['company_branch_id'] != '' && $_GET['department_id'] != '') {
               $where                    = array(
                'work_order.company_branch_id' => $_GET["company_branch_id"],
                'work_order.department_id' => $_GET['department_id'],
                'work_order.active_inactive' => 1,
            );
            }

            if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites']=='') {
                #$where = array('work_order.created_date >=' => $_GET['start'] , 'work_order.created_date <=' => $_GET['end'],'work_order.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
               $where                    = array(
                'work_order.created_by_cid' => $this->companyId,
                'work_order.inprocess_complete' => 0
            );
            }
           elseif (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites']!='') {
                #$where = array('work_order.created_date >=' => $_GET['start'] , 'work_order.created_date <=' => $_GET['end'],'work_order.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where                    = array(
                'work_order.created_by_cid' => $this->companyId,
                'work_order.favourite_sts' => 1,
                'work_order.inprocess_complete' => 0
            );
            }
            elseif (isset($_GET["ExportType"]) && $_GET['start']!= '' && $_GET['end']!= '' && $_GET['favourites']=='') {
                #$where = array('work_order.created_date >=' => $_GET['start'] , 'work_order.created_date <=' => $_GET['end'],'work_order.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where                    = array(
                    'work_order.created_date >=' => $_GET['start'],
                    'work_order.created_date <=' => $_GET['end'],
                    'work_order.created_by_cid' => $this->companyId,
                    'work_order.inprocess_complete' => 0
                );
            }

        //Search
        $where2                        = '';
        $search_string                 = '';
        #pre($_GET);
        if(!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $materialName=getNameById('material',$search_string,'material_name');
            if($materialName->id != ''){
            $json_dtl ='{"product" : "'.$materialName->id.'"}';
             $where2 = "(work_order.product_detail!='' && json_contains(`product_detail`, '".$json_dtl."'))" ;
            }else{
             $where2  = "(work_order.id ='".$search_string."' or work_order.sale_order_no ='". $_GET['search']."')";
            }
            redirect("production/work_order/?search=$search_string");
        } elseif(isset($_GET['search']) && $_GET['search']!='') {
            $accountName   = $this->production_model->get_data_byId('account', 'name', $_GET['search']);
            $materialName=getNameById('material',$_GET['search'],'material_name');
            if($materialName->id != ''){
                $json_dtl ='{"product" : "'.$materialName->id.'"}';
                 $where2 = "(work_order.product_detail!='' && json_contains(`product_detail`, '".$json_dtl."'))" ;
            }else{
             $where2    = "(work_order.id ='".$_GET['search']."' or work_order.sale_order_no ='". $_GET['search']."' or work_order.workorder_name ='". $_GET['search']."' or work_order.customer_name_id ='". $accountName->id."')";
             #$where3 =
            }
          }

        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
         } else {
            $order = "desc";
        }
        // $cc = $this->production_model->num_rows('work_order',$where, $where2);

        // pre($cc);die();

        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "production/work_order/";
        $config["total_rows"]         = $this->production_model->num_rows('work_order',$where, $where2);
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if(!empty($_GET['ExportType'])){
            $export_data = 1;
        }else{
            $export_data = 0;
        }
        //pre($where);
        $this->data['work_order'] = $this->production_model->get_data1('work_order', $where, $config["per_page"], $page, $where2, $order,$export_data);

        $this->data['work_order_complete'] = $this->production_model->get_data1('work_order', $where, $config["per_page"], $page, $where2, $order,$export_data);

        $this->data['active_inactive'] = $this->production_model->get_data1('work_order', $where, $config["per_page"], $page, $where2, $order,$export_data);

        $this->data['work_orders_priority'] = $this->production_model->get_data1('work_order', $where, $config["per_page"], $page, $where2, $order,$export_data);

        // $this->data['inactive_material'] = $this->production_model->get_data1('work_order', $whereInactive, $config["per_page"], $page, $where2, $order, $export_data);

        // $this->data['non_inventry_mat'] = $this->production_model->get_data1('work_order', $whereNonInvntry, $config["per_page"], $page, $where2, $order, $export_data);



        $this->_render_template('work_order/index', $this->data);
        }



    public function work_order_create()
    {
          $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['work_order']      = $this->production_model->get_data_byId('work_order', 'sale_order_id', $id);

        $this->data['sale_order_data'] = $this->production_model->get_data_byId('sale_order', 'id', $id);
         //pre($this->data['sale_order_data']);
        $this->load->view('work_order/edit', $this->data);
    }

    public function work_order_edit()
    {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['work_order'] = $this->production_model->get_data_byId('work_order', 'id', $id);
        //$this->data['sale_order_data']= $this->production_model->get_data_byId('sale_order','id', $id);
        $this->load->view('work_order/edit_work_order', $this->data);
    }
	public function getProductHtml(){
		permissions_redirect('is_add');
        $data = $this->load->view('work_order/add_ajax_html');
        // echo $data;
    }
	
	
    public function saveWorkOrder()
    {
        if ($this->input->post()) {
            $required_fields = array(
                'work_order_no'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data                      = $this->input->post();
                $data['material_type_id']  = json_encode($this->input->post('material_type_id'));
                $products                  = count($_POST['material_name']);
                $sale_order_priority_array = array();
                if ($products > 0) {
                    $arr = array();
                    $i   = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array(
                            'material_type_id' => $_POST['material_type_id'][$i],
                            'product' => $_POST['material_name'][$i],
                            'quantity' => $_POST['quantity'][$i],
                            'Pending_quantity' => $_POST['Pending_quantity'][$i],
                            'transfer_quantity' => $_POST['transfer_quantity'][$i],
                            'available_quantity' => $_POST['available_quantity'][$i],
                            'uom' => $_POST['uom'][$i],
                            'job_card' => $_POST['job_card'][$i]
                        );
                        $arr[$i]         = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $data['created_by']     = $_SESSION['loggedInUser']->id;
                #$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyId;
                $data['product_detail'] = $product_array;

                $id = $data['id'];
                $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 98
                ));

                if ($id && $id != '') {
                    $success = $this->production_model->update_data('work_order', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Work order  updated successfully";
                        logActivity('Work order  Updated', 'lead', $id);

                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array(
                                        'subject' => 'Work Order updated',
                                        'message' => 'Work Order id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $userViewPermission['user_id'],
                                        'ref_id' => $id,
                                        'class' => 'productionTab',
                                        'data_id' => 'work_order_view',
                                        'icon' => 'fa fa-archive'
                                    ));

                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array(
                                'subject' => 'Work Order updated',
                                'message' => 'Work Order id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'ref_id' => $id,
                                'class' => 'productionTab',
                                'data_id' => 'work_order_view',
                                'icon' => 'fa fa-archive'
                            ));
                        }
                        $this->session->set_flashdata('message', 'Work order  Updated successfully');
                    }
                } else {
                    $id = $this->production_model->insert_tbl_data('work_order', $data);
                    if ($id) {
                        logActivity('Work order ', 'Work order ', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {

                                    pushNotification(array(
                                        'subject' => 'New Work order created',
                                        'message' => 'Work order created by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $userViewPermission['user_id'],
                                        'ref_id' => $id,
                                        'class' => 'productionTab',
                                        'data_id' => 'work_order_view',
                                        'icon' => 'fa fa-archive'
                                    ));

                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {

                            pushNotification(array(
                                'subject' => 'New Work order created',
                                'message' => 'Work order created by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'ref_id' => $id,
                                'class' => 'productionTab',
                                'data_id' => 'work_order_view',
                                'icon' => 'fa fa-archive'
                            ));
                        }
                        $this->session->set_flashdata('message', 'Work order  successfully');
                    }
                }
                redirect(base_url() . 'production/work_order', 'refresh');
            }
        }
    }
    public function work_order_view($id = '')
    {
        if ($this->input->post('id')) {
            permissions_redirect('is_view');
        }
        $this->data['id']         = $this->input->post('id');
        $this->data['work_order'] = $this->production_model->get_data_byId('work_order', 'id', $this->input->post('id'));
        $production_data          = $this->production_model->get_production_data('production_data', 'work_order', $this->input->post('id'));
        $getProductionVal = array();
        if($production_data){
            foreach($production_data as $k => $productionValue){
                $getProductionVal[] = json_decode($productionValue['production_data'],true);
                $getProductionVal[$k]['date'] = $productionValue['date'];
            }
        }

        $mainData = array();
        if($getProductionVal){
            foreach($getProductionVal as  $newData){
                foreach($newData as  $lastData){
                    if( is_array($lastData) ){
                         foreach($lastData['work_order'] as $key => $details){
                            if($details == $this->input->post('id')){
                                $mainData[]                 =  array(
                                    'machine_name_id'       => $lastData['machine_name_id'][$key]??'',
                                    'work_order'            => $lastData['work_order'][$key]??'',
                                    'wages_or_per_piece'    => $lastData['wages_or_per_piece'][$key]??'',
                                    'process_name'          => $lastData['process_name'][$key]??'',
                                    'party_code'            => $lastData['party_code'][$key]??'',
                                    'totalsalary'           => $lastData['totalsalary'][$key]??'',
                                    'per_unit_cost'         => $lastData['labour_costing'][$key]??'',
                                    'output_quantity'       => $lastData['output'][$key]??'',
                                    'worker_id'             => $lastData['worker_id'][$key]??'',
                                    'job_card_product_id'   => $lastData['job_card_product_id'][$key]??'',
                                    'date'                  => $newData['date']??'',
                                );
                            }
                        }

                    }


                }
            }
        }
        $aSortedArray = array();
        if($mainData){
            foreach ($mainData as $keyVal => $aArray) {
                $bSet = false;
                foreach ($aSortedArray as $iPos => $aTempSortedArray) {
                    if( $aTempSortedArray['process_name'] == $aArray['process_name'] && $aTempSortedArray['party_code'] == $aArray['party_code']) {
                        $aSortedArray[$iPos]['per_unit_cost']       .=  $aArray['per_unit_cost'];
                        $aSortedArray[$iPos]['output_quantity']     .=  $aArray['output_quantity'];
                        if($aArray['totalsalary'][$iPos]){
                            array_push($aSortedArray[$iPos]['totalsalary'], $aArray['totalsalary'][$iPos]);
                        }
                        $bSet = true;
                    }
                }
                if(!$bSet) {
                    $aSortedArray[]             =   array(
                        'work_order'            =>  $aArray['work_order'],
                        'process_name'          =>  $aArray['process_name'],
                        'party_code'            =>  $aArray['party_code'],
                        'wages_or_per_piece'    =>  $aArray['wages_or_per_piece'],
                        'per_unit_cost'         =>  $aArray['per_unit_cost'],
                        'output_quantity'       =>  $aArray['output_quantity'],
                        'job_card_product_id'   =>  $aArray['job_card_product_id'],
                        'totalsalary'           =>  $aArray['totalsalary']
                    );
                }
            }
        }
        $materialRequestDetails             = $this->production_model->get_material_approved_data('wip_request', 'work_order_id_select', $this->input->post('id'));
         $materialsData = array();
        if($materialRequestDetails){
            foreach($materialRequestDetails as $materialKey => $materialDetails){
                $materialsData[] = json_decode($materialDetails['mat_detail'],true);
                $materialsData[$materialKey]['date'] = date('d-m-Y',strtotime($materialDetails['issued_date']));
            }
        }
       $materialDetailsArray = array();
        if($materialsData){
            foreach($materialsData as $mkeyEnd => $materialListData){
                foreach($materialListData as $list){
                   // echo $list['material_id'].'<br/>';
                    if( is_array($list) ){

                    $new_rmissue = json_decode($list['input_process'], true);
               
                    if($list['work_order_id_select'] == $this->input->post('id')){
                        $lotDetails                 =   getNameById('lot_details',$list['lot_id'],'id');
                        $whereCondition             =   array('id' => $this->input->post('id'),'product_id' => $list['material_id']);
                        $workOrderDetails           =   $this->production_model->get_work_order_by_material('work_order','product', $whereCondition);
                        $productWorkOrderData       =   array();
                        if($workOrderDetails){
                            $productDetails = json_decode($workOrderDetails['product_detail'],true);
                            foreach($productDetails as $workOrderProduct){
                                $productWorkOrderData[] = array(
                                    'transfer_quantity' => $workOrderProduct['transfer_quantity'],
                                    'job_card'          => $workOrderProduct['job_card'],
                                    'material_id'       => $list['material_id']
                                );
                            }
                        }
                        $jobCardMaterialData       =   array();
                        if($productWorkOrderData){
                            foreach($productWorkOrderData as $productWorkOrderItem){
                                $whereConditionJobCard  =   array('job_card_no' => $productWorkOrderItem['job_card'],'material_id' => $productWorkOrderItem['material_id']);
                                $jobCardData =  $this->production_model->get_job_card_data('job_card','material_name_id', $whereConditionJobCard);
                                if($jobCardData){
                                    $jobCardDetails = json_decode($jobCardData['material_details'],true);
                                    foreach($jobCardDetails as $jobCardDetail){
                                        if($list['material_id'] == $jobCardDetail['material_name_id']){
                                            $jobCardMaterialData = array(
                                                'lot_qty'           => $jobCardData['lot_qty'],
                                                'quantity'          => $jobCardDetail['quantity'],
                                                'transfer_quantity' => $productWorkOrderItem['transfer_quantity'],
                                                'material_id'       => $jobCardDetail['material_name_id']
                                            );
                                        }
                                    }
                                }
                            }

                        }
                        $reQuantity = $requiredQuantity = 0;
                        if($jobCardMaterialData){
                            if( $jobCardMaterialData['transfer_quantity'] > 0 ){
                                $reQuantity       =  (float)$jobCardMaterialData['transfer_quantity'] / (float)$jobCardMaterialData['lot_qty'];
                                $requiredQuantity =  $reQuantity * $jobCardMaterialData['quantity'];

                            }
                        }
                       // echo '<pre>'; print_r($jobCardMaterialData);
                        $materialDetailsArray[]     =   array(
                            'work_order_id'         =>  $list['work_order_id'],
                            'material_type_id'      =>  $list['material_type_id'],
                            'material_id'           =>  $list['material_id'],
                            'quantity'              =>  $list['quantity'],
                            'date'                  =>  $materialListData['date'],
                            'lot_id'                =>  $list['lot_id'],
                            'uom'                   =>  $list['uom'],
                            'lot_number'            =>  $lotDetails ? $lotDetails->lot_number : '',
                            'unit_price'            =>  $lotDetails ? $lotDetails->mou_price : '0',
                            'required_quantity'     =>  $requiredQuantity
                        );
                      }
                    }
                }
            }
        }
        $materialTotalArray = array();
        if($materialDetailsArray){
            foreach ($materialDetailsArray as $newKeyVal => $aMaterialArray) {
                $mSet = false;
                $uomStatus = false;
                foreach ($materialTotalArray as $mKeyPos => $aMaterialSortedArray) {
                    if( $aMaterialSortedArray['material_id'] == $aMaterialArray['material_id'] && $aMaterialSortedArray['lot_id'] == $aMaterialArray['lot_id']) {
                        $materialTotalArray[$mKeyPos]['quantity']       +=  $aMaterialArray['quantity'];
                        $mSet = true;
                    }
                }
                if(!$mSet) {
                    $materialTotalArray[]               =   array(
                        'material_type_id'              =>  $aMaterialArray['material_type_id'],
                        'material_id'                   =>  $aMaterialArray['material_id'],
                        'quantity'                      =>  $aMaterialArray['quantity'],
                        'unit_price'                    =>  $aMaterialArray['unit_price'],
                        'lot_id'                        =>  $aMaterialArray['lot_id'],
                        'lot_number'                    =>  $aMaterialArray['lot_number'],
                        'uom'                           =>  $aMaterialArray['uom'],
                        'required_quantity'             =>  $aMaterialArray['required_quantity'],
                    );
                }
            }
        }
        $fgRequestDetails             = $this->production_model->get_fg_approved_data('finish_goods', 'work_order_id', $this->input->post('id'));
        $scrap_data_report = json_decode($fgRequestDetails[0]['scrap_material_detail'], true);
        $this->data['labour_costing']           = $mainData;
        $this->data['process_wise_report']      = $aSortedArray;
        $this->data['material_issue_report']    = $materialDetailsArray;
        $this->data['material_total_report']    = $materialTotalArray;
        $this->data['new_rmissue']    = $new_rmissue;
        $this->data['scrap_data_report']    = $scrap_data_report;
        $this->load->view('work_order/view', $this->data);

    }


    public function raw_material_by_uom(){
        $work_order = $this->input->post('id');
        $materialRequestDetails             = $this->production_model->get_material_approved_data('wip_request', 'work_order_id', $work_order);
        $materialsData = array();
        if($materialRequestDetails){
            foreach($materialRequestDetails as $materialKey => $materialDetails){
                $materialsData[] = json_decode($materialDetails['mat_detail'],true);
            }
        }
        $materialDetailsArray = array();
        if($materialsData){
            foreach($materialsData as $mkeyEnd => $materialListData){
                foreach($materialListData as $list){
                    if($list['work_order_id'] == $work_order){
                        $materialDetailsArray[]     =   array(
                            'work_order_id'         =>  $list['work_order_id'],
                            'material_type_id'      =>  $list['material_type_id'],
                            'material_id'           =>  $list['material_id'],
                            'quantity'              =>  $list['quantity'],
                            'lot_id'                =>  $list['lot_id'],
                            'uom'                   =>  $list['uom'],
                            'lot_number'            =>  $lotDetails ? $lotDetails->lot_number : '',
                            'unit_price'            =>  $lotDetails ? $lotDetails->mou_price : '0',
                        );
                    }
                }
            }
        }
        $materialTotalArray = array();
        if($materialDetailsArray){
            foreach ($materialDetailsArray as $newKeyVal => $aMaterialArray) {
                $mSet = false;
                foreach ($materialTotalArray as $mKeyPos => $aMaterialSortedArray) {
                    if( $aMaterialSortedArray['uom'] == $aMaterialArray['uom']) {
                        $materialTotalArray[$mKeyPos]['quantity']   +=  $aMaterialArray['quantity'];
                        $mSet = true;
                    }
                }
                if(!$mSet) {
                    $materialTotalArray[]              =   array(
                        'quantity'                      =>  $aMaterialArray['quantity'],
                        'uom'                           =>  $aMaterialArray['uom'],
                    );
                }
            }
        }
        $this->data['raw_material_report'] = $materialTotalArray;
        $this->load->view('work_order/raw_material_quantity', $this->data);

    }


    public function getSaleOrderProductDetail()
    {
        $sale_order_id = $_POST['sale_order_id'];
        $saleOrder     = $this->production_model->get_saleOrder_productDetail('sale_order', $sale_order_id);
        echo json_encode($saleOrder);
    }
    public function getJobCardFromMaterial()
    {
        $material_ids = $_POST['material_ids'];
        $materialId   = array();

        foreach ($material_ids as $material_id) {
            $materialId[] = $material_id;

            //$materialJobCard  = $this->production_model->get_job_card_based_onMaterialId('material',$material_id);

            //echo  json_encode($materialJobCard);

        }
        $getMultiplematerialId = implode(',', $materialId);
        $materialJobCard       = $this->production_model->get_job_card_based_onMaterialId('material', $getMultiplematerialId);

        echo json_encode($materialJobCard);
        //$saleOrder  = $this->production_model->get_saleOrder_productDetail('sale_order',$sale_order_id);

    }

    public function create_pdf($id = '')
    {
        $this->load->library('Pdf');
        //$dataPdf = $this->purchase_model->get_data_byId('purchase_order','id',$id);
        $dataPdf['dataPdf'] = $this->production_model->get_data_byId('job_card', 'id', $id);
        //create_pdf($dataPdf);
        $this->load->view('Job_card/view_job_card_pdf', $dataPdf); //$this->_render_template('purchase_order/view_pdf', $this->data);
    }

    /****************************** Delete on Select Record ***************************/

    public function deleteall()
    {
        $tablename   = $this->input->get_post('tablename');
        $checkValues = $this->input->get_post('checkValues');
        $datamsg     = $this->input->get_post('datamsg');
        foreach ($checkValues as $key) {
            $this->production_model->delete_data($tablename, 'id', $key);
            logActivity($datamsg . ' Deleted', $tablename, $key);
        }
        $this->session->set_flashdata('message', $datamsg . ' Deleted Successfully');
        // redirect(base_url().'crm/leads', 'refresh');
    }

    /****************************** Delete on Select Record ***************************/

    /*******************************FAVOURITES IN PURCHASE ***************************/

    public function markfavourite()
    {
        $id        = $this->input->get_post('checkValues');
        $tablename = $this->input->get_post('tablename');
        $favourite = $this->input->get_post('favourite');
        $datamsg   = $this->input->get_post('datamsg');
        $data      = $favourite;
        $result    = $this->production_model->markfavour($tablename, $data, $id);
        if ($result == true) {
            foreach ($id as $ky) {
                logActivity($datamsg . ' Records marked favourite', $tablename, $ky);
            }
            $this->session->set_flashdata('message', $datamsg . ' Favourites');
            $result = array(
                'msg' => 'Sale order approved',
                'status' => 'success',
                'code' => 'C296',
                'url' => base_url() . 'production/add_machine'
            );
            echo json_encode($result);
        } else {
            echo json_encode(array(
                'msg' => 'error',
                'status' => 'error',
                'code' => 'C301'
            ));
        }

    }
    /*******************************FAVOURITES IN PURCHASE ***************************/

    /*public function updateoldrecords(){

    #$this->data['work_order'] = $this->production_model->get_data('work_order',array('created_by_cid'=> $_SESSION['loggedInUser']->c_id));
    $this->data['work_order'] = $this->production_model->get_data('job_card',array('created_by_cid'=> $this->companyId));

    foreach ($this->data['work_order'] as $key) {

    $products = json_decode($key['product_detail']);

    foreach($products as $product){

    $ww =   getNameById('uom', $product->uom,'ugc_code');

    $product->uom = $ww->id;

    $product_array = "[".json_encode($product)."]";

    $data['product_detail'] = $product_array;

    pre($data['product_detail']);

    $aa = array('id' => $key['id']);

    $this->production_model->updateRowWhere('work_order',$aa,$data);

    //die();
    }

    }
    }*/




    /*public function updatejson(){
    $this->data['job_card'] = $this->production_model->get_data('job_card',array('created_by_cid'=> $_SESSION['loggedInUser']->c_id));
    foreach ($this->data['job_card'] as $key) {
    $products = json_decode($key['material_details']);
    if(!empty($products)){
    #   pre($products);
    $i = 0;
    $newProduct = array();
    foreach($products as $product){
    $ww =   getNameById('material', $product->material_name_id,'id');
    if(empty($ww)){
    $product->material_type_id = "0";
    }
    else{
    $product->material_type_id = $ww->material_type_id;
    }
    $newProduct[$i] = $product;

    #$this->crm_model->updateRowWhere('leads',$aa,$data);
    $i++;
    }
    $aa = array('id' => $key['id']);
    $data['material_details'] =  json_encode($newProduct);
    pre($data);
    $this->production_model->updateRowWhere('job_card',$aa,$data);
    }
    }


    }*/


    //For Update Machine COde
    /*  public function machineadd(){
    $this->data['add_machine'] = $this->production_model->get_data('add_machine',array('created_by_cid'=> $_SESSION['loggedInUser']->c_id));
    foreach ($this->data['add_machine'] as $key) {
    $rID =  $key['id'];
    $MachineCode = 'Mac'.rand(1, 1000000).'_'.$rID;
    echo $MachineCode."<br>";
    $data['machine_code'] = $MachineCode;
    $aa = array('id' => $key['id'], 'created_by_cid'=> $_SESSION['loggedInUser']->c_id);
    $this->production_model->updateRowWhere('add_machine',$aa,$data);
    #die();
    }

    }*/

    /****************************************************/
    // Function Name: planned_vs_actual
    // Created: Aman Phull
    /****************************************************/

    public function planned_vs_actual()
    {
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Planned VS Actual', base_url() . 'planned_vs_actual');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Report';
          $where = array('production_data.created_by_cid' => $this->companyId );
          $where1 = array('production_planning.created_by_cid' => $this->companyId );
         if (isset($_GET['favourites'])!='' && isset($_GET["ExportType"])=='') {
            $where                        = array(
                'production_data.created_by_cid' => $this->companyId,
                'production_data.favourite_sts' => 1
            );
        }
        if ($_GET['start']!= '' && $_GET['end']!= '' && $_GET['favourites']=='') {
                 $where                        = array(
                    'production_data.created_date >=' => $_GET['start'],
                    'production_data.created_date <=' => $_GET['end'],
                    'production_data.created_by_cid' => $this->companyId
                );
            }
         if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == ''&& $_GET['favourites']=='') {
                $where                        = array(
                    'production_data.created_by_cid' => $this->companyId
                );

            }else if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == ''&& $_GET['favourites']!='') {
                 $where                        = array(
                'production_data.created_by_cid' => $this->companyId,
                'production_data.favourite_sts' => 1
            );

            }
           else if (isset($_GET["ExportType"]) && $_GET['start']!= '' && $_GET['end']!= ''&& $_GET['favourites']=='') {
                 $where                        = array(
                    'production_data.created_date >=' => $_GET['start'],
                    'production_data.created_date <=' => $_GET['end'],
                    'production_data.created_by_cid' => $this->companyId
                );
            }
            //Search
        $where2                        = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $where2        = "(id like'%" . $search_string . "%')";
            redirect("production/planned_vs_actual/?search=$search_string");
        } else if (isset($_GET['search'])) {
            $where2 = "(id like'%" . $_GET['search'] . "%')";

        }
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];

        } else {
            $order = "desc";
        }
        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "production/planned_vs_actual/";
        $config["total_rows"]         = $this->production_model->num_rows('production_data',$where, $where2);
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
         if(!empty($_GET['ExportType'])){
            $export_data = 1;
        }else{
            $export_data = 0;
        }
         $this->data['productionData'] = $this->production_model->get_data1('production_data', $where, $config["per_page"], $page, $where2, $order,$export_data);
          //  $this->data['productionPlanning'] = $this->production_model->get_data1('production_planning', $where1, $config["per_page"], $page, $where2, $order,$export_data);
            if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }

        $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';




        #pre($this->data);
        #die;
          $this->_render_template('planned_vs_actual/index', $this->data);



    }


    /****************************************************/
    // EOF: planned_vs_actual
    /****************************************************/
    public function planned_vs_actual_view()
    {
        $id                           = $_POST['id'];
        $this->data['productionView'] = $this->production_model->get_data_byId('production_data', 'id', $id);
        $this->load->view('planned_vs_actual/view', $this->data);
    }

    public function uploadImageByAjax()
    {
        if (isset($_POST["image"])) {
            $data          = $_POST["image"];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data          = base64_decode($image_array_2[1]);
            $exp           = explode('.', $_POST["uploaded_image_name"]);
            $imageName     = $exp[0] . 'Material' . time() . "." . $exp[1];
            file_put_contents('assets/modules/production/uploads/' . $imageName, $data);
            $result = array(
                'image' => $imageName,
                'imageHtml' => '<img src="' . base_url() . 'assets/modules/production/uploads/' . $imageName . '" class="img-thumbnail" height="50px" width="50px"/>'
            );
            echo json_encode($result);
        }
    }

    public function EditImageByAjax()
    {
        if (isset($_POST["image"])) {
            $data             = $_POST["image"];
            $image_array_1    = explode(";", $data);
            $image_array_2    = explode(",", $image_array_1[1]);
            $data             = base64_decode($image_array_2[1]);
            $exp              = explode('.', $_POST["uploaded_image_name"]);
            $activityUserData = getNameById('material', $_POST["Id"], 'id');
            $nameChar         = substr($activityUserData->material_name, 0, 3);
            $imageName        = $exp[0] . 'Material' . time() . "." . $exp[1];
            file_put_contents('assets/modules/production/uploads/' . $imageName, $data);
            $result = array(
                'image' => $imageName,
                'imageHtml' => '<img src="' . base_url() . 'assets/modules/production/uploads/' . $imageName . '" class="img-thumbnail" />'
            );
            echo json_encode($result);
        }
    }
    /*get SalesOder Based On WorkOder*/
    public function GetSaleOrderID($WorkOrderID = '')
    {
        $WorkOrderID  = $_POST['id'];
        $getWorkOrder = $this->production_model->get_data_byId('work_order', 'id', $WorkOrderID);
        echo json_encode($getWorkOrder);
    }
    public function getSaleOrderProductsData(){
        $sale_order_id                = $_POST['sale_order_id'];
        $this->data['sale_order_id']  = $sale_order_id;
        $ProductsData                 = $this->production_model->get_data_byId('sale_order', 'id', $sale_order_id);
        $this->data['products_array'] = $ProductsData;
        $data                         = $this->load->view('work_order/work_order_ajax', $this->data);
        echo $data;
    }
	
    /********Monthly production Taget Report*************/
    public function production_taget()
    {
       $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Production Monthly Target', base_url() . 'production_taget');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Production Monthly Target';
          $where = array( 'production_report.created_by_cid' => $this->companyId);

          if ($_GET['start']!= '' && $_GET['end']!= '') {
                #$where = array('work_order.created_date >=' => $_GET['start'] , 'work_order.created_date <=' => $_GET['end'],'work_order.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where                           = array(
                    'production_report.created_date >=' => $_GET['start'],
                    'production_report.created_date <=' => $_GET['end'],
                    'production_report.created_by_cid' => $this->companyId
                );

            }
            if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' ) {
                #$where = array('work_order.created_date >=' => $_GET['start'] , 'work_order.created_date <=' => $_GET['end'],'work_order.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
               $where                           = array(
                'production_report.created_by_cid' => $this->companyId
            );
            } elseif (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['favourites']!='') {
                #$where = array('work_order.created_date >=' => $_GET['start'] , 'work_order.created_date <=' => $_GET['end'],'work_order.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                  $where                           = array(
                'production_report.created_by_cid' => $this->companyId,
                'production_report.favourite_sts' => 1
            );
            }elseif (isset($_GET["ExportType"]) && $_GET['start']!= '' && $_GET['end']!= '' && $_GET['favourites']=='') {
                #$where = array('work_order.created_date >=' => $_GET['start'] , 'work_order.created_date <=' => $_GET['end'],'work_order.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                   $where                           = array(
                    'production_report.created_date >=' => $_GET['start'],
                    'production_report.created_date <=' => $_GET['end'],
                    'production_report.created_by_cid' => $this->companyId
                );
            }


        //Search
        $where2        = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
                $deptName=getNameById('department',$search_string,'name');

            if($deptName->id!= ''){
                $where2 = "production_report.department_id =".$deptName->id;
            }else{
            $where2        = "production_report.id like'%" . $search_string . "%'";
            }
            redirect("production/production_taget/?search=$search_string");
        } else if (isset($_GET['search'])) {
            $deptName=getNameById('department',$_GET['search'],'name');

            if($deptName->id!= ''){
                $where2 = "production_report.department_id =".$deptName->id;
            }else{
            $where2 = "production_report.id like'%" . $_GET['search'] . "%'";
        }}

        if (!empty($_GET['order'])) {
            $order = $_GET['order'];

        } else {
            $order = "desc";
        }


        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "production/production_taget/";
        $config["total_rows"]         = $this->production_model->num_rows('production_report',$where, $where2);
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if(!empty($_GET['ExportType'])){
                $export_data = 1;
            }else{
                $export_data = 0;
            }
     $this->data['production_report'] = $this->production_model->get_data1('production_report', $where, $config["per_page"], $page, $where2, $order,$export_data);
      if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }

        $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
        $this->_render_template('production_monthly_taget/production_taget', $this->data);

    }
    public function monthly_target()
    {
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Production Monthly Target', base_url() . 'monthly_target');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Production Monthly Target';
        //Search
        $where2                        = '';
        $search_string                 = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $where2        = "work_order.id like'%" . $search_string . "%'";
            redirect("production/work_order/?search=$search_string");
        } else if (isset($_GET['search'])) {
            $where2 = "work_order.id like'%" . $_GET['search'] . "%'";
        }

        if (!empty($_POST['order'])) {
            $order = $_POST['order'];

        } else {
            $order = "desc";
        }


        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "production/monthly_target/";
        $config["total_rows"]         = $this->production_model->num_rows('work_order', array(
            'created_by_cid' => $this->companyId
        ), $where2);
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if (isset($_POST['favourites'])) {
            # $where = array('work_order.created_by_cid'=> $_SESSION['loggedInUser']->c_id, 'work_order.favourite_sts' =>1);
            $where                    = array(
                'work_order.created_by_cid' => $this->companyId,
                'work_order.favourite_sts' => 1
            );
            $this->data['work_order'] = $this->production_model->get_data1('work_order', $where, $config["per_page"], $page, $where2, $order,$export_data);
            $this->_render_template('production_monthly_taget/index', $this->data);

        } else {
            if (isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
                #$where = array('work_order.created_date >=' => $_POST['start'] , 'work_order.created_date <=' => $_POST['end'],'work_order.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where                    = array(
                    'work_order.created_date >=' => $_POST['start'],
                    'work_order.created_date <=' => $_POST['end'],
                    'work_order.created_by_cid' => $this->companyId
                );
                $this->data['work_order'] = $this->production_model->get_data1('work_order', $where, $config["per_page"], $page, $where2, $order,$export_data);
                $this->_render_template('production_monthly_taget/index', $this->data);
            }
            if (!empty($_POST['start'])) {
                #$where = array('work_order.created_date >=' => $_POST['start'] , 'work_order.created_date <=' => $_POST['end'],'work_order.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where                    = array(
                    'work_order.created_date >=' => $_POST['start'],
                    'work_order.created_date <=' => $_POST['end'],
                    'work_order.created_by_cid' => $this->companyId
                );
                $this->data['work_order'] = $this->production_model->get_data1('work_order', $where, $config["per_page"], $page, $where2, $order,$export_data);
                $this->_render_template('production_monthly_taget/index', $this->data);
            } else {
                //$where = arra('sale_order.created_by_cid' => $_SESSION['loggedInUser']->c_id AND'sale_order.approve'=>1);
                #$where = "work_order.created_by_cid = ".$_SESSION['loggedInUser']->c_id ;
                $where = "work_order.created_by_cid = " . $this->companyId . " AND work_order.progress_status=0 AND  year(STR_TO_DATE(`work_order`.`expected_delivery_date`,'%d-%m-%Y')) =  YEAR(CURDATE()) AND month(STR_TO_DATE(`work_order`.`expected_delivery_date`,'%d-%m-%Y')) =  MONTH(CURDATE())";

                $this->data['work_order'] = $this->production_model->get_data1('work_order', $where, $config["per_page"], $page, $where2, $order,$export_data);
                $this->_render_template('production_monthly_taget/index', $this->data);
            }
        }

    }
    public function MontlyProductionList()
    {
        // POST data
        $postData = $this->input->post();
        // Get data
        $response = array();

        ## Read value
        $draw            = $postData['draw'];
        $start           = $postData['start'];
        $rowperpage      = $postData['length']; // Rows display per page
        $columnIndex     = $postData['order'][0]['column']; // Column index
        $columnName      = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue     = $postData['search']['value']; // Search value

        // Custom search filter
        $searchCompnyUnit = $postData['searchCompnyUnit'];
        $searchDepartment = $postData['searchDepartment'];
        $searchMonth      = $postData['searchMonth'];
        $productionId     = $postData['productionId'];

        ## Search
        $search_arr  = array();
        $searchQuery = "";
        if ($searchValue != '') {
            /*  $search_arr[] = " (name like '%" . $searchValue . "%' or
            email like '%" . $searchValue . "%' or
            CompnyUnit like'%" . $searchValue . "%' ) "; */
        }
        if ($searchCompnyUnit != '') {
            $search_arr[] = " company_branch_id='" . $searchCompnyUnit . "' ";
        }
        if ($searchDepartment != '') {
            $search_arr[] = " department_id='" . $searchDepartment . "'  AND work_order.progress_status=0";
        }
        if ($searchMonth != '') {
            //$search_arr[] = " name like '%" . $searchMonth . "%' ";
            //$month_array = explode("-", $searchMonth);
            //$search_arr[] = " work_order.created_by_cid = " . $_SESSION['loggedInUser']->c_id . " AND work_order.progress_status=0 AND year(STR_TO_DATE(`work_order`.`expected_delivery_date`,'%d-%m-%Y')) =  '".$month_array[0]."' AND month(STR_TO_DATE(`work_order`.`expected_delivery_date`,'%d-%m-%Y')) =  '".$month_array[1]."'";
        }
        if (count($search_arr) > 0) {
            $searchQuery = implode(" and ", $search_arr);
        }
        //pre(count($search_arr));die;
        $data_response = $this->production_model->getWorkOrderList($searchQuery);
        $data          = $workorder_ids = array();
        $order         = 1;
        if ($productionId) {
            $production_report = $this->production_model->get_data_byId('production_report', 'id', $productionId);
            $workorder_ids     = json_decode($production_report->workorder_ids, true);

        } else {
            /*  if (count($search_arr) > 0) {
            $where = "production_report.created_by_cid = " . $this->companyId . " AND production_report.company_branch=" . $searchCompnyUnit . " AND  production_report.department_id=" . $searchDepartment . " AND  production_report.month='" . $searchMonth . "'";
            $production_report = $this->production_model->get_data('production_report', $where);
            if(isset($production_report[0])){
            $workorder_ids =   json_decode($production_report[0]['workorder_ids'],true);
            }
            }        */
        }
        foreach ($data_response['records'] as $record) {
            $accountName   = $this->production_model->get_data_byId('account', 'id', $record->customer_name_id);
            $createdByData = $this->production_model->get_data_byId('user_detail', 'u_id', $record->created_by);
            /* $transfer_quantity = array();
            if(isset($record->product_detail)){
            $WorkorderProductDetail = json_decode($record->product_detail);
            foreach($WorkorderProductDetail as $qtyfatch){
            $transfer_quantity[] = $qtyfatch->transfer_quantity;
            }
            } */
            $check_value   = 0;
            if (in_array($record->id, $workorder_ids)) {
                $check_value = 'checked="checked"';
            }
            $data[] = array(
                "priority_order" => $order,
                "id" => $record->id,
                "name" => '<a href="javascript:void(0)" id="' . $record->id . '" data-id="work_order_view" class="productionTab btn btn-warning btn-xs" > ' . $record->workorder_name . ' </a>',
                "sale_order" => '<a href="javascript:void(0)" id="' . $record->sale_order_no . '" data-id="dispatched_order_view" data-tooltip="View" class="productionTab btn btn-view btn-xs">' . $record->sale_order_no . '</a>',
                "customer_name" => (!empty($accountName)) ? $accountName->name : $record->customer_name,
                "checkbox_status" => '<input type="checkbox" name="workorder_ids[]"  class="workOrderIDscheckbox"   value="' . $record->id . '"  ' . $check_value . '>'
            );
            $order++;
        }


        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $data_response['totalRecords'],
            "iTotalDisplayRecords" => $data_response['totalRecordwithFilter'],
            "aaData" => $data
        );
        // pre($response);die;
        echo json_encode($response);
    }
    public function ChangePriority()
    {
        //pre($_POST);
        foreach ($_POST['serialsDict'] as $rowId) {
            $data['priority_order'] = $rowId['priority_order'];
            $where                  = array(
                'id' => $rowId['id']
            );
            $this->production_model->updateRowWhere('work_order', $where, $data);
        }
        $result = array(
            'msg' => 'Update Priority Order Successfully',
            'status' => 'success',
            'code' => 'C142',
            'url' => base_url() . 'production/monthly_target'
        );
        echo json_encode($result);

    }
    public function monthly_target_add()
    {
        //pre($_POST);
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['production_report'] = $this->production_model->get_data_byId('production_report', 'id', $id);
        $where                           = "work_order.created_by_cid = " . $this->companyId . " AND work_order.progress_status=0 AND  year(STR_TO_DATE(`work_order`.`expected_delivery_date`,'%d-%m-%Y')) =  YEAR(CURDATE()) AND month(STR_TO_DATE(`work_order`.`expected_delivery_date`,'%d-%m-%Y')) =  MONTH(CURDATE())";
        $this->data['work_order']        = $this->production_model->get_data('work_order', $where);
        $this->load->view('production_monthly_taget/monthly_target_add', $this->data);
    }
    public function saveMonthlyProuction()
    {
        //  pre($this->input->post());die;
        if ($this->input->post()) {
            $required_fields = array(
                'workOrderIDs'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data                      = $this->input->post();
                $workOrderIDscount         = count($_POST['workorder_ids']);
                $data['workorder_count']   = $workOrderIDscount;
                $sale_order_priority_array = array();
                if ($workOrderIDscount > 0) {
                    $workOrder_array = json_encode($_POST['workorder_ids']);
                } else {
                    $workOrder_array = '';
                }
                $data['created_by']     = $_SESSION['loggedInUser']->id;
                $data['created_by_cid'] = $this->companyId;
                $data['workorder_ids']  = $workOrder_array;
                $id                     = $data['id'];

                $where             = "production_report.created_by_cid = " . $this->companyId . " AND production_report.company_branch=" . $this->input->post('company_branch') . " AND  production_report.department_id=" . $this->input->post('department_id') . " AND  production_report.month='" . $this->input->post('month') . "'";
                $production_report = $this->production_model->get_data('production_report', $where);
                if (isset($production_report[0])) {
                    $id = $production_report[0]['id'];

                }

                if ($id && $id != '') {
                    $success = $this->production_model->update_data('production_report', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Monthly Production  updated successfully";
                        logActivity('Monthly Production  Updated', 'lead', $id);
                        $this->session->set_flashdata('message', 'Work order  Updated successfully');
                    }
                } else {

                    $id = $this->production_model->insert_tbl_data('production_report', $data);
                    if ($id) {
                        logActivity('Monthly Production ', 'Added Monthly Production  successfully', $id);
                        $this->session->set_flashdata('message', 'Added Monthly Production  successfully');
                    }
                }
                redirect(base_url() . 'production/production_taget', 'refresh');
            }
        }
    }
    public function getWorkOrderTotalQty()
    {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['production_report'] = $this->production_model->get_data_byId('production_report', 'id', $id);
        $this->load->view('production_monthly_taget/production_taget_quantity', $this->data);

    }
    /**********Check Monthly ProductionExist Or NOt ****************/
    public function CheckMonthlyProductionRecordExist()
    {
        // POST data
        $postData         = $this->input->post();
        // Custom search filter
        $searchCompnyUnit = $postData['searchCompnyUnit'];
        $searchDepartment = $postData['searchDepartment'];
        $searchMonth      = $postData['searchMonth'];
        $productionId     = $postData['productionId'];
        if (empty($productionId)) {
            $where             = "production_report.created_by_cid = " . $this->companyId . " AND production_report.company_branch=" . $searchCompnyUnit . " AND  production_report.department_id=" . $searchDepartment . " AND  production_report.month='" . $searchMonth . "'";
            $production_report = $this->production_model->get_data('production_report', $where);
            if (isset($production_report[0])) {
                $status = array(
                    'status' => 'success'
                );
            } else {
                $status = array(
                    'status' => 'error'
                );
            }
        } else {
            $status = array(
                'status' => 'error'
            );

        }
        echo json_encode($status);
    }
    public function monthly_target_view($id = '')
    {
        if ($this->input->post('id')) {
            permissions_redirect('is_view');
        }
        $this->data['id']                = $this->input->post('id');
        $this->data['production_report'] = $this->production_model->get_data_byId('production_report', 'id', $this->input->post('id'));
        //pre( $this->data);die;
        $this->load->view('production_monthly_taget/view', $this->data);

    }
    /*get material from materil issue(WIP)*/
    public function get_workOrder_input_qty()
    {
        $WorkOrder      = $this->production_model->get_data_byId('work_order', 'id', $this->input->post('WorkOrderId'));
        $Work_order_qty = "";
        if (!empty($WorkOrder->product_detail)) {
            $product_detail = json_decode($WorkOrder->product_detail);
            foreach ($product_detail as $pro) {
                if ($pro->product == $this->input->post('MaterialId')) {
                    $Work_order_qty = $pro->transfer_quantity;
                }
            }
        }
        echo $Work_order_qty;
        die;
    }
    function monthly_planned_vs_actual()
    {
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Monthly Production Planned Vs Actual', base_url() . 'monthly_planned_vs_actual');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Production Monthly Target';
          $where = "production_report.created_by_cid = " . $this->companyId . " AND production_report.status=0";
        if ($_GET['start']!= '' && $_GET['end']!= '') {
                #$where = array('work_order.created_date >=' => $_POST['start'] , 'work_order.created_date <=' => $_POST['end'],'work_order.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where                           = array(
                    'production_report.created_date >=' => $_GET['start'],
                    'production_report.created_date <=' => $_GET['end'],
                    'production_report.created_by_cid' => $this->companyId
                );
            }
            if (isset($_GET["ExportType"]) && $_GET['start']=='' && $_GET['end']== '') {
                #$where = array('production_report.created_date >=' => $_POST['start'] , 'production_report.created_date <=' => $_POST['end'],'production_report.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                 $where = "production_report.created_by_cid = " . $this->companyId . " AND production_report.status=0";
            }
            elseif (isset($_GET["ExportType"]) && $_GET['start']!='' && $_GET['end']!= '') {
                #$where = array('production_report.created_date >=' => $_POST['start'] , 'production_report.created_date <=' => $_POST['end'],'production_report.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where                           = array(
                    'production_report.created_date >=' => $_GET['start'],
                    'production_report.created_date <=' => $_GET['end'],
                    'production_report.created_by_cid' => $this->companyId
                );
            }
        //Search
        $where2        = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $deptName=getNameById('department',$search_string,'name');

            if($deptName->id!= ''){
                $where2 = "production_report.department_id =".$deptName->id;
            }else{
                $where2 = "production_report.id like'%" . $search_string . "%'";
            }
            redirect("production/monthly_planned_vs_actual/?search=$search_string");
        } else if (isset($_GET['search'])) {
            $deptName=getNameById('department',$_GET['search'],'name');
            if($deptName->id!= ''){
                $where2 = "production_report.department_id =".$deptName->id;
            }else{
            $where2 = "production_report.id like'%" . $_GET['search'] . "%'";
        }

        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];

        } else {
            $order = "desc";
        }


        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "production/monthly_planned_vs_actual/";
        $config["total_rows"]         = $this->production_model->num_rows('production_report',$where, $where2);
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
         if(!empty($_GET['ExportType'])){
                $export_data = 1;
            }else{
                $export_data = 0;
            }
            $this->data['production_report'] = $this->production_model->get_data1('production_report', $where, $config["per_page"], $page, $where2, $order,$export_data);
              if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }

        $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
        $this->_render_template('monthly_planned_vs_actual/index', $this->data);
    }

    public function monthly_planned_vs_actual_view($id = '')
    {
        if ($this->input->post('id')) {
            permissions_redirect('is_view');
        }
        $this->data['id']                = $this->input->post('id');
        $this->data['production_report'] = $this->production_model->get_data_byId('production_report', 'id', $this->input->post('id'));
        //pre( $this->data);die;
        $this->load->view('monthly_planned_vs_actual/view', $this->data);

    }
    public function getMonthlyPlannedVsActualQtyReport()
    {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['production_report'] = $this->production_model->get_data_byId('production_report', 'id', $id);
        $this->load->view('monthly_planned_vs_actual/quantity_report', $this->data);

    }
    public function getProductionOutputReport()
    {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['work_order'] = $this->production_model->get_data_byId('work_order', 'id', $id);
        $this->load->view('monthly_planned_vs_actual/output_report', $this->data);

    }
    public function ProgessOfProduction($id = '')
    {

        if ($this->input->post('id')) {
            permissions_redirect('is_view');
        }
        $this->data['id']        = $this->input->post('id');
        $production_report       = $this->production_model->get_data_byId('production_report', 'id', $this->input->post('id'));
        $machineWhere            = array(
            'add_machine.created_by_cid' => $this->companyId,
            'add_machine.save_status' => 1,
            'add_machine.department' => $production_report->department_id
        );
        $get_machine_data        = $this->production_model->get_data('add_machine', $machineWhere);
        $production_settingWhere = array(
            '
        production_setting.created_by_cid' => $this->companyId,
            'production_setting.department' => $production_report->department_id
        );
        $production_setting_data = $this->production_model->get_data('production_setting', $production_settingWhere);

        $this->data['machine_data']      = $get_machine_data;
        $this->data['production_report'] = $production_report;
        $this->data['Company_shift']     = $production_setting_data;
        //pre( $this->data);die;
        $this->load->view('monthly_planned_vs_actual/progess_of_so', $this->data);

    }
    public function backend_resources($id = '')
    {
        $production_report = $this->production_model->get_data_byId('production_report', 'id', $id);

        $machineWhere     = array(
            'add_machine.created_by_cid' => $this->companyId,
            'add_machine.save_status' => 1,
            'add_machine.department' => $production_report->department_id
        );
        $scheduler_groups = $this->production_model->get_data('add_machine', $machineWhere);
        $groups           = array();

        foreach ($scheduler_groups as $group) {
            $g               = new stdClass;
            $g->id           = "group_" . $group['id'];
            $g->name         = $group['machine_name'];
            $g->tags['info'] = $group['id'];
            $g->expanded     = true;
            $g->children     = array();
            //  $g->eventHeight = 20;
            $groups[]        = $g;
            /*
            $scheduler_resources = loadResources($group['id']);

            foreach($scheduler_resources as $resource) {
            $r = new Resource();
            $r->id = $resource['id'];
            $r->name = $resource['name'];
            $g->children[] = $r;
            } */
        }
        //pre($groups);
        echo json_encode($groups);

    }
    public function loadEvents($id)
    {
        $production_report       = $this->production_model->get_data_byId('production_report', 'id', $id);
        $production_settingWhere = array(
            'production_setting.created_by_cid' => $this->companyId,
            'production_setting.department' => $production_report->department_id
        );
        $Company_shift           = $this->production_model->get_data('production_setting', $production_settingWhere);
        $shift_start_column      = array_column($Company_shift, 'shift_start');
        array_multisort($shift_start_column, SORT_ASC, $Company_shift);
        $i = 0;
        foreach ($Company_shift as $shift) {
            $total_shift[] = $shift['shift_name'];
            $shift_start[] = $shift['shift_start'];
            $shift_end[]   = $shift['shift_end'];
            $time1 = strtotime($shift_start[$i]);
            $time2 = strtotime($shift_end[$i]);
            if (!empty($time2)) {
                $noOfhours[] = round(abs($time2 - $time1) / 3600);
            } else {
                $noOfhours[] = date('H', $time1);
            }
            $i++;
        }
        //pre( $noOfhours);die;
        $shiftcount = 1;
        $total_hours = array_sum($noOfhours);
        $shiftcount  = count($total_shift);
        /*  if ($shiftcount > 0) {
        $noOfhours = 24 / $shiftcount;
        } */
        $result      = json_decode($production_report->workorder_ids, true);
        $events      = array();
        $start_date  = $production_report->month . '-01';
        $start_date  = date('Y-m-d H:i:s', strtotime($start_date));
        $i = 1;
        $j = 1;
        $x          = 0;
        $mach_array = array();
        $k          = 0;
        $pre_k      = 0;
        foreach ($result as $workOrderId) {
            $color     = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
            $workOrder = getNameById('work_order', $workOrderId, 'id');
            $products  = json_decode($workOrder->product_detail);

            foreach ($products as $product) {
                $bomRouting_detail = get_data_byId_fromMaterial('material', 'id', $product->product);
                $process_details   = json_decode($bomRouting_detail->machine_details, true);
                $alotQty           = $bomRouting_detail->lot_qty;
                $requiredQty       = $product->transfer_quantity;

                foreach ($process_details as $process) {
                    //
                    $machine_details    = json_decode($process['machine_details'], true);
                    $per_process_output = json_decode($process['output_process'], true);
                    $outputsum          = array_sum(array_column($per_process_output, 'quantity_output'));
                    $process_req_qty    = round(($outputsum / $alotQty) * $requiredQty);
                    $last_id            = "";
                    $total_mach         = count($machine_details);
                    $m                  = 0;

                    foreach ($machine_details as $mach) {
                        $total_days           = 0;
                        $total_end_hours      = 0;
                        $per_shift_production = $mach['production_shift'];
                        $RequiredShifts       = round($process_req_qty / $per_shift_production);
                        if ($RequiredShifts == 0 || is_infinite($RequiredShifts)) {
                            $RequiredShifts = 0;
                        } else {
                        }
                        $total_days = round($RequiredShifts / $shiftcount);
                        $total_working_hours = $total_days*$total_hours;
                        $prev_val   = array();
                        $prev_val   = $events[(count($events) - 1)];

                        if (!empty($prev_val->start)) {
                            $start_date    = (strtotime($prev_val->start) > strtotime(date("Y-m-d", strtotime($prev_val->start)) . " " . $prev_val->next_shift . ":00")) ? date("Y-m-d 00:00:00", strtotime("+1 day", strtotime($prev_val->start))) : $prev_val->start;
                            $start_date    = date("Y-m-d", strtotime($start_date)) . " " . $prev_val->next_shift . ":00";
                            $current_shift = $prev_val->next_shift;
                        } else {
                            $start_date    = date("Y-m-d", strtotime($start_date)) . " " . $shift_start[$x] . ":00";
                            $current_shift = $shift_start[$x];

                        }

                        $add_process = $this->production_model->get_data_byId('add_process', 'id', $process['processess']);
                        $start_date_same_mach = "";
                        if ($k == $pre_k) {
                            if (array_key_exists($mach['machine_id'], $mach_array)) {
                                $end_date_pre_mach = $mach_array[$mach['machine_id']];
                                // Compare the timestamp date
                                if ($end_date_pre_mach < $start_date) {

                                    $start_date_same_mach = $start_date;
                                } else {
                                    //$end_date_pre_mach = (strtotime($end_date_pre_mach)>strtotime(date("Y-m-d",  strtotime($end_date_pre_mach))." ".$shift_start[$x].":00"))?date("Y-m-d 00:00:00", strtotime("+1 day", strtotime($end_date_pre_mach))):$end_date_pre_mach;

                                    if (strtotime($end_date_pre_mach) > strtotime(date("Y-m-d", strtotime($end_date_pre_mach)) . " " . $prev_val->next_shift . ":00")) {
                                        $start_date_same_mach = date("Y-m-d", strtotime($end_date_pre_mach)) . " " . $prev_val->current_shift . ":00";
                                        $current_shift        = $prev_val->current_shift;
                                    } else {
                                        $start_date_same_mach = date("Y-m-d", strtotime($end_date_pre_mach)) . " " . $prev_val->next_shift . ":00";
                                        $current_shift        = $prev_val->next_shift;

                                    }
                                }

                                //$end_date = date('Y-m-d H:i:s', strtotime($start_date_same_mach . '+ ' . $total_days . ' days'));
                                $end_date = date("Y-m-d H:i:s", strtotime('+' . $total_working_hours . ' hours', strtotime($start_date_same_mach)));


                            } else {
                               // $end_date = date('Y-m-d H:i:s', strtotime($start_date . '+ ' . $total_days . ' days'));
                             $end_date = date("Y-m-d H:i:s", strtotime('+' . $total_working_hours . ' hours', strtotime($start_date)));


                            }
                        } else {
                            if (array_key_exists($mach['machine_id'], $mach_array)) {
                                $start_date_same_mach = $mach_array[$mach['machine_id']];
                                $current_shift = $shift_start[$x];
                                //$end_date = date('Y-m-d H:i:s', strtotime($start_date . '+ ' . $total_days . ' days'));
                                $end_date = date("Y-m-d H:i:s", strtotime('+' . $total_working_hours . ' hours', strtotime($start_date)));


                            }
                        }
                        $shift_index = array_search($current_shift, $shift_start);

                        if ($shift_index == $shiftcount - 1) {
                            $next_shift = $shift_start[0];
                        } else {
                            $next_shift = $shift_start[$shift_index + 1];
                        }

                        $e                = new stdClass;
                        $e->id            = $i . "_" . $workOrder->id;
                        $e->text          = $workOrder->workorder_name . " (" . $add_process->process_name . ")";
                        $e->start         = ($start_date_same_mach) ? $start_date_same_mach : $start_date;
                        $e->end           = $end_date;
                        $e->resource      = "group_" . $mach['machine_id'];
                        $e->color         = $color;
                        $e->join          = $prev_val->id;
                        $e->hasNext       = $prev_val->id;
                        $e->current_shift = $current_shift;
                        $e->next_shift    = $next_shift; // $key = 2;
                        ;
                        $events[] = $e;
                        $last_id  = $i . "_" . $workOrder->id;
                        $i++;
                        $mach_array[$mach['machine_id']] = $end_date;
                        if ($total_mach > $m) {
                        }
                        $m++;

                    }

                    if ($x >= $shiftcount - 1) {
                        $x = 0;
                    } else {
                        $pre_x = $x;
                        $x++;
                    }
                    $pre_k = $k;
                }
                $start_date = $end_date;
                $j++;
                $k++;
            }

        }
    //pre($events);die;
       echo json_encode($events);
    }

    public function change_status() {
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status = (isset($_POST['gstatus']) && $_POST['gstatus'] == 1) ? '1' : '0';
        $status_data = $this->production_model->change_status_toggle($id, $status);
        echo json_encode($status_data);
    }



    public function change_work_order_production_status(){
        if($_POST['work_order_id']){
            $where = array('id' => $_POST['work_order_id']);
        }
        if($_POST['status']){
            $updateData = array('work_order_production_status' => $_POST['status']);
        }
        if($_POST['status'] && $_POST['work_order_id']){
            $status_data = $this->production_model->update_work_order_production_status('work_order',$where,$updateData);
            $this->session->set_flashdata('message', 'Status updated successfully.');
            echo json_encode($status_data);
        } else {
            $this->session->set_flashdata('message', 'Status not updated. Please try again.');
            return false;
        }

    }


    public function change_work_order_material_status(){
        if($_POST['work_order_id']){
            $where = array('id' => $_POST['work_order_id']);
        }
        if($_POST['status']){
            $updateData = array('work_order_material_status' => $_POST['status']);
        }
        if($_POST['status'] && $_POST['work_order_id']){
            $status_data = $this->production_model->update_work_order_production_status('work_order',$where,$updateData);
            $this->session->set_flashdata('message', 'Status updated successfully.');
            echo json_encode($status_data);
        } else {
            $this->session->set_flashdata('message', 'Status not updated. Please try again.');
            return false;
        }
    }



     public function scrapProcessBy(){

          $id     = $_POST['id'];
         $JobCard      = $this->production_model->get_data_process('add_process',['process_type_id' => $id]);
               echo'<div class="col-md-4 col-sm-12 col-xs-12 form-group"></div><div class="col-md-8 col-sm-12 col-xs-12 form-group">

                      <div class="col-md-6 form-group">
                       <label style="border-right: 1px solid #c1c1c1 !important;"> Process Name</label>
                       </div>
                     <div class="col-md-6 form-group">
                      <label style="border-right: 1px solid #c1c1c1 !important;"> Process Scrap % </label>
                      </div>
                </div>';


        foreach ($JobCard as $key => $value) {
            echo'<div class="col-md-4 col-sm-12 col-xs-12 form-group"></div><div class="col-md-8 col-sm-12 col-xs-12 form-group">

                      <div class="col-md-6 form-group">

                     <input style="border-right: 1px solid #c1c1c1 !important;" type="text" value="'.$value['process_name'].'" name="process_name[]" id="process_name" class="form-control col-md-7 col-xs-12 process_name"  redonly> </div>
                     <div class="col-md-6 form-group">

                     <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="operating_scrap[]" id="operating_scrap" class="form-control col-md-7 col-xs-12 operating_scrap"    value=""> </div>
                </div>';

        }

    }




public function add_matrial_Details_onthe_spot() {

        $material_name = $_REQUEST['material_name'];
        $hsn_code = $_REQUEST['hsn_code'];
        $uom = $_REQUEST['uom'];
        $specification = $_REQUEST['specification'];
        //$closing_balance = $_REQUEST['closing_balance'];
        $opening_balance = $_REQUEST['opening_balance'];
        $material_type_id = $_REQUEST['material_type_id'];
        $prefix = $_REQUEST['prefix'];
        $created_by_id = $_SESSION['loggedInUser']->u_id;
        //$created_by_cid  = $_SESSION['loggedInUser']->c_id;
        $created_by_cid = $this->companyId;
        $last_id = getLastTableId('material');
        $rId = $last_id + 1;
        $matCode = 'MAT_' . rand(1, 1000000) . '_' . $rId;
        $matrial_details = array('material_name' => $material_name, 'hsn_code' => $hsn_code, 'uom' => $uom, 'specification ' => $specification, 'created_by ' => $created_by_id,
        //'closing_balance '=>$closing_balance,
        'opening_balance ' => $opening_balance, 'material_type_id ' => $material_type_id, 'prefix ' => $prefix, 'material_code ' => $matCode, 'created_by ' => $created_by_id, 'created_by_cid ' => $created_by_cid,);
         // pre($matrial_details);die('there');
        $data2 = $this->production_model->insert_on_spot_tbl_data('material', $matrial_details);
        if ($data2 > 0) {
            echo 'true';
        } else {
            echo 'false';
        }
}


///add Report

    function production_material_order_report($per_page = 0 ){
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Production Material Order Report', base_url() . 'production_material_order_report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Production Material Report';

        $where2        = '';
        $search_string = '';
        if (!empty($_GET['search'])) {
            $search_string = "'".$_GET['search']."'";
            $where2 = "work_order.work_order_no = ".$search_string;
        }

        $where = "work_order.created_by_cid = " . $this->companyId ." and work_order.active_inactive = 1" ;
        if ($_GET['start']!= '' && $_GET['end']!= '') {
            $where                           = array(
                'work_order.created_date >=' => $_GET['start'],
                'work_order.created_date <=' => $_GET['end'],
                'work_order.created_by_cid'  => $this->companyId,
                'work_order.active_inactive' => 1
            );
        }
        if (isset($_GET["ExportType"]) && $_GET['start']=='' && $_GET['end']== '') {
            $where = "work_order.created_by_cid = " . $this->companyId." and work_order.active_inactive = 1" ;
        }
        elseif (isset($_GET["ExportType"]) && $_GET['start']!='' && $_GET['end']!= '') {
            $where                           = array(
                'work_order.created_date >=' => $_GET['start'],
                'work_order.created_date <=' => $_GET['end'],
                'work_order.created_by_cid' => $this->companyId,
                'work_order.active_inactive' => 1
            );
        }
        $order = '';
        $work_order_materials = array();
        if (isset($_GET["sort"])){
           $order = "work_order_no ".$_GET["sort"];
        }
        $workOrders = $this->production_model->get_work_order_material_data('work_order', $where, '', '', $where2, $order);
        if($workOrders){
            $i = 1;
            foreach($workOrders as $work_order_data){
                $productDetails = json_decode($work_order_data['product_detail'],true);
                if($productDetails){
                    $produced_quantity = 0;
                    foreach($productDetails as $k => $materialInfo){
                        $whereConditionColumns      = array('column_name_job' => 'job_card_detail','column_name_material' => 'job_card_detail');
                        $whereConditionJsonKeys     = array('json_column_key_work' => 'work_order_id','json_column_key_material' => 'material_id');
                        $whereConditionData         = array('work_order_id' => $work_order_data['id'],'material_id' => $materialInfo['product']);
                        $produced_quantity          = get_finish_quantity_data('finish_goods',$whereConditionColumns, $whereConditionJsonKeys, $whereConditionData);
                        $work_order_materials[] = array(
                            'id'                 =>  $i,
                            'material_id'        =>  $materialInfo['product'],
                            'quantity'           =>  $materialInfo['quantity'],
                            'pending_quantity'   =>  $materialInfo['Pending_quantity'],
                            'transfer_quantity'  =>  $materialInfo['transfer_quantity'],
                            'available_quantity' =>  $materialInfo['available_quantity'],
                            'uom'                =>  $materialInfo['uom'],
                            'job_card'           =>  $materialInfo['job_card'],
                            'work_order_no'      =>  $work_order_data['work_order_no'],
                            'workorder_name'     =>  $work_order_data['workorder_name'],
                            'company_branch_id'  =>  $work_order_data['company_branch_id'],
                            'work_order_id'      =>  $work_order_data['id'],
                            'created_date'       =>  $work_order_data['created_date'],
                            'produced_quantity'  =>  $produced_quantity,
                        );
                        $i++;
                    }
                }
            }
        }

        if(isset($_GET["ExportType"])){
            $output = [];
            if(!empty($work_order_materials)){
                foreach($work_order_materials as $rows){
                    $materialName   = getNameById('material',$rows['material_id'],'id');
                    $companyDetail  = getNameById('company_address',$rows['company_branch_id'],'compny_branch_id');
                    $output[] = array('Material Name' => $materialName->material_name, 'Work Order Number' => $rows['work_order_no'], 'Required Quantity' => $rows['transfer_quantity'], 'Produced Quantity' => 0, 'Plant' => $companyDetail->company_unit, 'Created Date' => date("j F , Y", strtotime($rows['created_date'])) );
                }
            }
            if(!empty($output)){
                export_csv_excel($output);
            }
        }

        $config                       = array();
        $config["base_url"]           = site_url('production/production_material_order_report');
        $config['total_rows']         = count($work_order_materials);
        $config['reuse_query_string']  = true;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $this->data['pagination_links'] = $this->pagination->create_links();
        $this->data['work_order_materials'] = array_chunk($work_order_materials, 10)[$per_page / 10];
        $this->_render_template('production_order_information/index', $this->data);
    }
    /// new Function

     function production_order_cost_analysis(){
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Production Order Cost Analysis', base_url() . 'production_order_cost_analysis');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Production Order Cost Analysis';


        $where2        = '';
        $search_string = '';
        if (!empty($_GET['search'])) {
            $search_string = "'".$_GET['search']."'";
            $where2 = "work_order.work_order_no = ".$search_string;
        }

        $where = "work_order.created_by_cid = " . $this->companyId ." and work_order.active_inactive = 1" ;
        if ($_GET['start']!= '' && $_GET['end']!= '') {
            $where                           = array(
                'work_order.created_date >=' => $_GET['start'],
                'work_order.created_date <=' => $_GET['end'],
                'work_order.created_by_cid'  => $this->companyId,
                'work_order.active_inactive' => 1
            );
        }
        if (isset($_GET["ExportType"]) && $_GET['start']=='' && $_GET['end']== '') {
            $where = "work_order.created_by_cid = " . $this->companyId." and work_order.active_inactive = 1" ;
        }
        elseif (isset($_GET["ExportType"]) && $_GET['start']!='' && $_GET['end']!= '') {
            $where                           = array(
                'work_order.created_date >=' => $_GET['start'],
                'work_order.created_date <=' => $_GET['end'],
                'work_order.created_by_cid' => $this->companyId,
                'work_order.active_inactive' => 1
            );
        }
        $order = '';
        $work_order_materials = array();
        if (isset($_GET["sort_by"]) && isset($_GET["order_by"]) ){
            $order = $_GET["sort_by"] ." ".$_GET["order_by"];
        }

        $config                       = array();
        $config["base_url"]           = base_url() . "production/production_order_cost_analysis/";
        $config["total_rows"]         = $this->production_model->num_rows('work_order',$where, $where2);
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;

        if(isset($_GET['ExportType'])){
            $work_orders = $this->production_model->get_work_order_material_data('work_order', $where, '', '', $where2, $order);
        }else{
            $work_orders = $this->production_model->get_work_order_material_data('work_order', $where, $config["per_page"], $page, $where2, $order);
        }

        if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
        }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }

        $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';

        $this->data['production_cost_analysis'] = array();

        if($work_orders){
            foreach($work_orders as $workorder){
                $quantity                   = 0;
                $totalCost                  = 0;
                $materialPlannedCost        = 0;
                $materialActualCost         = 0;
                $totalMaterialCosting       = 0;
                $materialActualCostQuantity = 0;
                $plannedLabourCost          = 0;
                $actualLabourCost           = 0;
                $productWorkOrderItems = json_decode($workorder['product_detail'],true);
                if( $productWorkOrderItems){
                    foreach($productWorkOrderItems as $productWorkOrderItem){
                        if($productWorkOrderItem['job_card']){
                            $whereConditionJobCard  =   array('job_card_no' => $productWorkOrderItem['job_card'],'material_id' => '');
                            $jobCardData            =   $this->production_model->get_job_card_data('job_card','material_name_id', $whereConditionJobCard);
                            if($jobCardData){
                                $jobCardDetails = json_decode($jobCardData['material_details'],true);
                                if($jobCardDetails){
                                    foreach($jobCardDetails as $jobCardDetail){
                                        $totalCost += $jobCardDetail['total'];
                                        $quantity += $jobCardDetail['quantity'];
                                        $materialPlannedCost +=  ($totalCost && $quantity) ? round( $totalCost/$quantity,2) : 0;
                                    }
                                }
                                $jobCardMachineDetails = json_decode($jobCardData['machine_details'],true);
                                if($jobCardMachineDetails){
                                    foreach($jobCardMachineDetails as $processMachineDetails){
                                        $machineDetails = json_decode($processMachineDetails['machine_details'],true);
                                        if($machineDetails){
                                            foreach($machineDetails as $machineDetail){
                                                $plannedLabourCost += (isset($machineDetail['total_cost'])) ? $machineDetail['total_cost'] : 0;
                                            }
                                        }
                                    }

                                }
                            }
                        }
                    }
                }
                $materialRequestDetails  = $this->production_model->get_material_approved_data('wip_request', 'work_order_id', $workorder['id']);
                if($materialRequestDetails){
                    foreach($materialRequestDetails as $materialKey => $materialDetails){
                        $materialsData = json_decode($materialDetails['mat_detail'],true);
                        if($materialsData){
                            foreach($materialsData as $list){
                                if($list['work_order_id'] == $workorder['id']){
                                    $lotDetails =   getNameById('lot_details',$list['lot_id'],'id');
                                    //$materialActualCost += $lotDetails ? $lotDetails->mou_price : '0';
                                    $materialCost = $lotDetails ? $lotDetails->mou_price : '0';
                                    $totalMaterialCosting += $materialCost * $list['quantity'];
                                    $materialActualCostQuantity += $list['quantity'];
                                    $materialActualCost = round($totalMaterialCosting/$materialActualCostQuantity,2);
                                }
                            }
                        }
                    }
                }
                $productionInformation          = $this->production_model->get_production_data('production_data', 'work_order', $workorder['id']);

                if($productionInformation){
                    foreach($productionInformation as $productInfo){
                        $production_data_info = json_decode($productInfo['production_data'],true);
                        if($production_data_info){
                           foreach($production_data_info as $productionDetails){
                                if($productionDetails['work_order']){
                                    foreach($productionDetails['work_order'] as $key => $details){
                                        // pre($productionDetails['work_order']);
                                        // pre($productionDetails['totalsalary']);
                                        if($details == $workorder['id']){
                                            if($productionDetails['totalsalary']){
                                                foreach($productionDetails['totalsalary'][$key] as $labourSalary){
                                                    $actualLabourCost += $labourSalary;
                                                }
                                            }
                                        }
                                    }
                                }
                           }
                        }
                    }
                }
                $this->data['production_cost_analysis'][] = array(
                    'id'                    => $workorder['id'],
                    'workorder_name'        => $workorder['workorder_name'],
                    'work_order_no'         => $workorder['work_order_no'],
                    'material_planned_cost' => $materialPlannedCost,
                    'material_actual_cost'  => $materialActualCost,
                    'planned_labour_cost'   => $plannedLabourCost,
                    'actual_labour_cost'    => $actualLabourCost,
                    'company_branch_id'     => $workorder['company_branch_id'],
                    'created_date'          => $workorder['created_date'],
                );
            }
        }

        if(isset($_GET["ExportType"])){
            if(!empty( $this->data['production_cost_analysis'])){
                export_csv_excel( $this->data['production_cost_analysis']);
            }
        }

        $this->_render_template('production_cost_analysis/index', $this->data);
    }
    // public function work_order_material_details(){
        // $this->data['can_edit'] = edit_permissions();
        // $this->data['can_delete'] = delete_permissions();
        // $this->data['can_add'] = add_permissions();
        // $this->data['can_view'] = view_permissions();
        // $this->breadcrumb->add('Work Order Material Details', base_url() . 'work_order_material_details');
        // $id = $_GET['id'];
        // permissions_redirect('is_view');
        // $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        // $this->settings['pageTitle'] = 'Material Availability';
        // $workOrder = $this->production_model->get_data_byId('work_order', 'id', $id);
       // if(empty($workOrder)){
            // show_404();
        // }
        // $workOrderProductDetails    = json_decode($workOrder->product_detail,true);
        // $expectedMaterialData       = array();
        // if($workOrderProductDetails){
            // foreach($workOrderProductDetails as $keyVal => $workOrderProductDetail){
                // $whereConditionJobCard  =  array('job_card_no' => $workOrderProductDetail['job_card'],'material_id' => '');
                // $jobCardDetails         =  $this->production_model->get_job_card_data('job_card','material_name_id', $whereConditionJobCard);
                // if($jobCardDetails){
                    // $jobCardMaterials  = json_decode($jobCardDetails['material_details'],true);
                    // if($jobCardMaterials){
                        // foreach($jobCardMaterials as $jobCardMaterial){
                            // if($jobCardMaterial['material_name_id']){
                                // $newQuantityValue = ($jobCardDetails['lot_qty'] != 0 ) ? $workOrderProductDetail['transfer_quantity'] / $jobCardDetails['lot_qty'] : 0;
                                // $expectedQuantity = ( $newQuantityValue > 0) ? $jobCardMaterial['quantity'] * $newQuantityValue : $jobCardMaterial['quantity'];
                                // $where = "reserved_material.mayerial_id = '".$jobCardMaterial['material_name_id']."' AND reserved_material.created_by_cid ='".$this->companyId."' AND reserved_material.work_order_id ='".$id."' AND reserved_material.job_card_id =".$jobCardDetails['id'];
                                // $reservedData = $this->production_model->get_data_single('reserved_material', $where);
                                // $reserved_quantity = $reservedData ? $reservedData['quantity'] : 0;
                                // $yu = getNameById_mat('mat_locations',$jobCardMaterial['material_name_id'],'material_name_id');
                                // $sum = 0;
                                // if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                                // $expectedMaterialData[]     = array(
                                    // 'material_type_id'      => $jobCardMaterial['material_type_id'],
                                    // 'material_name_id'      => $jobCardMaterial['material_name_id'],
                                    // 'unit'                  => $jobCardMaterial['unit'],
                                    // 'quantity_required'     => round($expectedQuantity,2),
                                    // 'reserved_quantity'     => $reserved_quantity,
                                    // 'available_quantity'    => $sum - $reserved_quantity,
                                    // 'job_card_id'           => $jobCardDetails['id'],
                                    // 'work_orer_id'          => $id,
                                // );
                            // }
                        // }
                    // }
                // }
            // }
        // }
        // $this->data['work_order']       = $workOrder;
        // $this->data['materials_data']   = $expectedMaterialData;
        // $this->_render_template('material_availability/view', $this->data);
    // }

     public function work_order_material_details(){
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Work Order Material Details', base_url() . 'work_order_material_details');
        $id = $_GET['id'];
        permissions_redirect('is_view');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Material Availability';
        $workOrder = $this->production_model->get_data_byId('work_order', 'id', $id);
        //pre($workOrder);die;
          $this->data['work_order']       = $workOrder;
        $this->_render_template('material_availability/view', $this->data);
    }
    function status_change_active(){
        $id                      = $this->uri->segment(3);

        $this->production_model->updateRowWhere('work_order', array(
            'id' => $id
        ), array(
            'active_inactive' => 1
        ));
        $this->session->set_flashdata('message', 'Work Order Active  successfully');
        redirect(base_url() . 'production/work_order', 'refresh');
    }
     function status_change(){
        $id                      = $this->uri->segment(3);

        $this->production_model->updateRowWhere('work_order', array(
            'id' => $id
        ), array(
            'active_inactive' => 0
        ));
        $this->session->set_flashdata('message', 'Work Order In Active  successfully');
        redirect(base_url() . 'production/work_order', 'refresh');
    }
    public function add_reserve_quantity(){
        $data                   = $this->input->post();
        $data['created_by']     = $_SESSION['loggedInUser']->id;
        $data['created_by_cid'] = $this->companyId;
        //$get_data = $this->production_model->get_data_byId('reserved_material', 'work_order_id', $data['work_order_id']);
        $where = "reserved_material.material_type = '".$data['material_type']."' AND reserved_material.mayerial_id = '".$data['mayerial_id']."' AND reserved_material.created_by_cid ='".$this->companyId."' AND reserved_material.work_order_id ='".$data['work_order_id']."' AND reserved_material.job_card_id =".$data['job_card_id'];
        $get_data = $this->production_model->get_data_single('reserved_material', $where);
        if($data['mat_action'] == "Unreserve Material"){
        $data['quantity']=$get_data['quantity']-$data['unreserve_qty'];
        $data['unreserve_qty'] = $get_data['unreserve_qty']+$data['unreserve_qty'];
        $message = "Quantity UnReserved Successfully.";
        } else {
        $data['unreserve_qty'] = $get_data['unreserve_qty']-$data['quantity'];
        $data['quantity']=$get_data['quantity']+$data['quantity'];
        $message = "Quantity Reserved Successfully.";
        }
        if(empty($get_data)){
        $addData = $this->production_model->insert_tbl_data('reserved_material',$data);
        } else {
        $addData = $this->production_model->update_data_res('reserved_material', $data, $where);
        }
        if($addData){
            $this->session->set_flashdata('message', $message);
             echo "true";
        } else {
            $this->session->set_flashdata('message', 'Quantity not reserved. Please try again.');
             return false;
        }
        //redirect("production/work_order_material_details?id={$data['work_order_id']}");
    }
    public function change_material_conversion_status(){
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status = (isset($_POST['gstatus']) && $_POST['gstatus'] == 1) ? '1' : '0';
        $status_data = $this->production_model->change_status_material_conversion($id, $status);
        echo json_encode($status_data);
    }
     public function get_Work_oreder_Status(){
        if ($_POST['job_cardname'] != '') {
            $job_cardname = $_POST['job_cardname'];
            $work_order_id = $_POST['work_order_id'];

            $where = array(
                'created_by_cid' => $this->companyId
            );
            $a = '"job_card":"'.$job_cardname.'"';
            $where = "id={$work_order_id} AND product_detail LIKE '%{$a}%'";
            $defected_Order=$this->production_model->Work_order_and_jobCart_value('work_order', $where);
            echo $defected_Order->work_order_production_status;
        }
    }
    function deviation_report(){
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Deviation Report', base_url() . 'deviation_report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Deviation Report';
          $where = "production_data.created_by_cid = " . $this->companyId . " ";
        if ($_GET['start']!= '' && $_GET['end']!= '') {
                #$where = array('work_order.created_date >=' => $_POST['start'] , 'work_order.created_date <=' => $_POST['end'],'work_order.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where                           = array(
                    'production_data.created_date >=' => $_GET['start'],
                    'production_data.created_date <=' => $_GET['end'],
                    'production_data.created_by_cid' => $this->companyId
                );
            }
            if (isset($_GET["ExportType"]) && $_GET['start']=='' && $_GET['end']== '') {
                #$where = array('production_report.created_date >=' => $_POST['start'] , 'production_report.created_date <=' => $_POST['end'],'production_report.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                 $where = "production_data.created_by_cid = " . $this->companyId . "  ";
            }
            elseif (isset($_GET["ExportType"]) && $_GET['start']!='' && $_GET['end']!= '') {
                #$where = array('production_report.created_date >=' => $_POST['start'] , 'production_report.created_date <=' => $_POST['end'],'production_report.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where                           = array(
                    'production_data.created_date >=' => $_GET['start'],
                    'production_data.created_date <=' => $_GET['end'],
                    'production_data.created_by_cid' => $this->companyId
                );
            }
        //Search
        $where2        = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $deptName=getNameById('department',$search_string,'name');

            if($deptName->id!= ''){
                $where2 = "production_data.department_id =".$deptName->id;
            }else{
                $where2 = "production_data.id like'%" . $search_string . "%'";
            }
            redirect("production/deviation_report/?search=$search_string");
        } else if (isset($_GET['search'])) {
            $deptName=getNameById('department',$_GET['search'],'name');
            if($deptName->id!= ''){
                $where2 = "production_data.department_id =".$deptName->id;
            }else{
            $where2 = "production_data.id like'%" . $_GET['search'] . "%'";
        }

        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];

        } else {
            $order = "desc";
        }


        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "production/deviation_report/";
        $config["total_rows"]         = $this->production_model->num_rows('production_data',$where, $where2);
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
         if(!empty($_GET['ExportType'])){
                $export_data = 1;
            }else{
                $export_data = 0;
            }
            $this->data['deviation_report'] = $this->production_model->get_data1('production_data', $where, $config["per_page"], $page, $where2, $order,$export_data);
            // pre( $this->data['deviation_report']); die;
              if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }

        $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
        $this->_render_template('deviation_report/index', $this->data);
    }
    public function deviation_report_view(){
         $id = $_POST['id'];
        $this->data['productionView'] = $this->production_model->get_data_byId('production_data', 'id', $id);
        $this->load->view('deviation_report/view', $this->data);
    }


      public function RawMaterialReportQtysaleorder(){
        $sale_order = $this->input->post('id');
        $saleOrderdata= getNameById('sale_order',$sale_order, 'id');
        $productdata=json_decode($saleOrderdata->product);

        $this->data['raw_material_report'] = $productdata;
        $this->load->view('sale_order_with_production/raw_material_quantity', $this->data);

    }

    public function getjcDataById()
    {
        if (isset($_REQUEST) && !empty($_REQUEST) && (isset($_REQUEST['id']) && $_REQUEST['id'] != '')) {
            //pre($_REQUEST);
            $id       = $_REQUEST['id'];
            $num_row       = $_REQUEST['num_row']+1;
            $lot       = $_REQUEST['lot'];
            $jc_exqty       = $_REQUEST['jc_exqty'];
            $set_out       = $_REQUEST['set_out'];
            if($set_out == "for_output" ){
            $set_act = "expandOutputMat";
            } else {
            $set_act = "expandBom";
            }
            $job_card = $this->production_model->get_data_byId('job_card', 'job_card_no', $id);
            //pre($_REQUEST); die;
             $material_info = json_decode($job_card->material_details);
             if(!empty($material_info)){
             $i = $num_row;
             $j = 1;
             $class_set = $send_html = "";
             foreach($material_info as $materialInfo){
             $material_qty = $_REQUEST['material_qty'];
             $quantity = $materialInfo->quantity;
             $per_unit = $job_card->lot_qty/$quantity;
             $material_id = $materialInfo->material_name_id;
             $materialName = getNameById('material',$material_id,'id');
             if($j==1){
              $class_set = 'edit-row1 firstIndex';
              $style_set = 'display:block!important;';
             } else{
             $class_set = 'scend-tr mobile-view';
              $style_set = '';
             }
             $span_html = '';
            for ($jci=1; $jci <= $jc_exqty; $jci++) { 
            $span_html .= '<span class="k-icon k-i-none"></span>';
            }
            $next_jc_exqty = $jc_exqty+1;
             $send_html .= '<tr class="output_cls appended_trs jc_well chk_idd_output" id="chkIndex_'.$i.'">'; 
            $material_data = getNameById('material', $materialInfo->material_name_id,'id');
            $job_data = getNameById('job_card', $material_data->job_card,'id');
            $sub_job =  $job_data->job_card_no;
            $send_html .= '<td><div style="display: flex;">'.$span_html.'
            <div class="expand_dropwon form-group">';
             if(!empty($material_data) && $material_data->job_card!=0){
            $send_html .= '<span class="up_arrow" style="display: none;"><i style="font-size: 20px;font-weight: bold;"  onclick="'.$set_act.'(event,this);" jc_exqty="'.$next_jc_exqty.'" jc_number="'.$job_data->job_card_no.'" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span><span class="down_arrow"><i onclick="'.$set_act.'(event,this);" jc_exqty="'.$next_jc_exqty.'" jc_number="'.$job_data->job_card_no.'" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span>';
            }
            
                                    $send_html .= '</div>
                   <select disabled class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid='.$_SESSION['loggedInUser']->c_id.' OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
                    <option value="">Select Option</option>';
            if(!empty($materialInfo) && isset($materialInfo->material_type_id)){
            $material_type_id = getNameById('material_type',$materialInfo->material_type_id,'id');
            $send_html .= '<option value="'.$materialInfo->material_type_id.'" selected>'.$material_type_id->name.'</option>';
            }
            $send_html .= '</select>
            </div></td>
                                    <td>
                                        <select disabled class="materialNameId_chkIndex_'.$i.' materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid='.$_SESSION['loggedInUser']->c_id.' AND material_type_id = '.$job_card->material_type_id.'  AND status=1" onchange="getUom(event,this); getsubBom(event,this);">
                                          <option value="">Select Option</option>';
            $send_html .= '<option value="'.$materialInfo->material_name_id.'" selected>'.$materialName->material_name.'</option>';
            $send_html .= '</select>
                                    </td>
                                    <td>
                                       <input readonly type="number" id="material_qty" class="material_qty_chkIndex_'.$i.' form-control col-md-7 col-xs-12 qty actual_qty qty_output" placeholder="Enter Quantity" value="'.round($material_qty/$per_unit, 2).'" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"> </td>
                                    <td>
                                       ';
           $ww =  getNameById('uom', $materialInfo->unit,'id');
                $uom = !empty($ww)?$ww->uom_quantity:'';
            $send_html .= '<input readonly type="text" class="form-control col-md-7 col-xs-12  uom" placeholder="uom." value="'.$uom.'" >
                                          <input type="hidden" name="uom_value[]" class="uomid" readonly value="'.$materialInfo->unit.'">
                                       </td>
                                    <td>
                                      <input readonly type="text" class="form-control col-md-7 col-xs-12 priceValue" placeholder="Price" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" value="'.$materialInfo->price.'" onkeypress="return float_validation(event, this.value)"> </td>
                                    <td>
                                        <input style="border-right: 1px solid #c1c1c1 !important;" type="text" class="form-control col-md-7 col-xs-12  total" placeholder="Total Amount" value="'.$materialInfo->total.'" readonly> </td>
                                    <td>';
                                      $material_data = getNameById('material', $materialInfo->material_name_id,'id');
                                     if(!empty($material_data) && $material_data->job_card==0){
                                      $sub_job = "N/A";
                                       } else {
                                        $job_data = getNameById('job_card', $material_data->job_card,'id');
                                    $sub_job =  $job_data->job_card_no; }
                                    $send_html .= '<input style="border-right: 1px solid #c1c1c1 !important;" type="text" id="sub_bom" class="form-control col-md-7 col-xs-12  total" placeholder="Sub-BOM" value="'.$sub_job.'" readonly> </div></td><td></td>
                                 </tr>';
                  $i++;$j++;
                        }
                    echo $send_html;
                    }
        }
    }

    public function routingEdit()
    {
    $expload_ids = explode(' ~ ', $_POST['id']);
    $job_card_id = $expload_ids['0'];
    $process_id = $expload_ids['1'];
    $index_id = $expload_ids['2'];
    $job_card_data = $this->production_model->get_data_byId('job_card', 'id', $job_card_id);
    $machine_details = json_decode($job_card_data->machine_details);
    if($process_id != 0 && !empty($machine_details)){
    $key = array_search($process_id, array_column($machine_details, 'processess'));
    if($key === 0 || $key >= 1){
    $this->data['machine_detail_data'] = $machine_details[$key];
    }
    }
    $this->data['process_type_id'] = $job_card_data->process_type;
    //$this->data['JobCard']      = $this->production_model->get_data_byId('job_card', 'id', $job_card_id);
    $this->data['jobcard_id']      = $job_card_id;
    $this->data['process_id']      =$process_id;
    $this->data['index_id']      =$index_id;
    $this->data['JobCard'] =  $job_card_data;
    $this->load->view('Job_card/routingedit', $this->data);
    }

    public function get_outputPP()
    {
    $job_card_id = $_POST['jobid'];
    $process_id = $_POST['id'];
    //$exp_count = explode('process_name_', $_POST['count']);
    $job_card_data = $this->production_model->get_data_byId('job_card', 'job_card_no', $job_card_id);
    $machine_details = json_decode($job_card_data->machine_details);
    if($process_id != 0){
    $key = array_search($process_id, array_column($machine_details, 'processess'));
    if($key === 0 || $key >= 1){
    $machine_detail_data = $machine_details[$key];
    }
    }
    $output_process_dtl = (!empty($machine_detail_data->output_process) && isset($machine_detail_data->output_process))?$machine_detail_data->output_process:'';
    $process_sch_output = json_decode(trim($output_process_dtl,'"'));
    $out = 0;
    foreach($process_sch_output as $val_output_sech){
    $name_ck = $_POST['count'].'['.$out.']';
    $material_id_output = $val_output_sech->material_output_name;
    $materialName_output = getNameById('material',$material_id_output,'id');
    echo '<input style="width:50%; float:left;" class="form-control col-md-7 col-xs-12" type="text" value="'.$materialName_output->material_name.'" readonly="">
    <input style="width:50%; float:left;" id="output" class="form-control col-md-7 col-xs-12 output" name="'.$name_ck.'" placeholder="output"  type="text" value="" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)">';
    $out++; }
    }

    public function routingView()
    {
    $expload_ids = explode(' ~ ', $_POST['id']);
    $job_card_id = $expload_ids['0'];
    $process_id = $expload_ids['1'];
    $index_id = $expload_ids['2'];
    $job_card_data = $this->production_model->get_data_byId('job_card', 'id', $job_card_id);
    $machine_details = json_decode($job_card_data->machine_details);
    if($process_id != 0){
    $key = array_search($process_id, array_column($machine_details, 'processess'));
    if($key === 0 || $key >= 1){
    $this->data['machine_detail_data'] = $machine_details[$key];
    }
    }
    $this->data['process_type_id'] = $job_card_data->process_type;
    //$this->data['JobCard']      = $this->production_model->get_data_byId('job_card', 'id', $job_card_id);
    $this->data['process_id']      =$process_id;
    $this->data['index_id']      =$index_id;
    $this->data['JobCard'] =  $job_card_data;
    $this->load->view('Job_card/routingview', $this->data);
    }

    public function reservedMat()
    {
     $expload_ids = explode('~', $_POST['id']);
     $res_detail_array = array(
    'material_type' => $expload_ids['0'],
    'material_id' => $expload_ids['1'],
    'work_order_id' => $expload_ids['2'],
    'job_card_id' => $expload_ids['3'],
    'sale_order_product_id' => $expload_ids['4'],
    'quantity_required' => $expload_ids['5'],
    'available_quantity' => $expload_ids['6'],
    'reserved_quantity' => $expload_ids['7'],
    );
     $this->data['mat_data'] = $res_detail_array;
     $this->load->view('material_availability/reservedmat', $this->data);
    }
    

    /** Auto Production Plan **/
    public function auto_production_plan()
    {
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Auto Production Plan', base_url() . 'auto_production_plan');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Auto Production Plan';

        $where   = array('auto_production_plan.created_by_cid' => $this->companyId);
         if ($_GET['company_branch_id'] != '' && $_GET['department_id'] != '' && $_GET['shift_id'] != '') {
               $where = array(
                'auto_production_plan.company_branch' => $_GET["company_branch_id"],
                'auto_production_plan.department_id' => $_GET['department_id'],
                'auto_production_plan.shift_name' => $_GET['shift_id'],
            );
        } elseif ($_GET['company_branch_id'] != '' && $_GET['department_id'] == '' && $_GET['shift_id'] == '') {
               $where = array(
                'auto_production_plan.company_branch' => $_GET["company_branch_id"],
            );
        } elseif ($_GET['company_branch_id'] == '' && $_GET['department_id'] != '' && $_GET['shift_id'] == '') {
               $where = array(
                'auto_production_plan.department_id' => $_GET['department_id'],
            );
        } elseif ($_GET['company_branch_id'] == '' && $_GET['department_id'] == '' && $_GET['shift_id'] != '') {
               $where = array(
                'auto_production_plan.shift_name' => $_GET['shift_id'],
            );
        } elseif ($_GET['company_branch_id'] != '' && $_GET['department_id'] != '' && $_GET['shift_id'] == '') {
               $where = array(
                'auto_production_plan.company_branch' => $_GET["company_branch_id"],
                'auto_production_plan.department_id' => $_GET['department_id'],
            );
        } elseif ($_GET['company_branch_id'] != '' && $_GET['department_id'] == '' && $_GET['shift_id'] != '') {
               $where = array(
                'auto_production_plan.company_branch' => $_GET["company_branch_id"],
                'auto_production_plan.shift_name' => $_GET['shift_id'],
            );
        } elseif ($_GET['company_branch_id'] == '' && $_GET['department_id'] != '' && $_GET['shift_id'] != '') {
               $where = array(
                'auto_production_plan.department_id' => $_GET['department_id'],
                'auto_production_plan.shift_name' => $_GET['shift_id'],
            );
        }

        $where2 = '';        

        if (!empty($_GET['order'])) {
            $order = $_GET['order'];

        } else {
            $order = "desc";
        }
        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "production/auto_production_plan/";
        $config["total_rows"]         = $this->production_model->num_rows('auto_production_plan', $where, $where2);
        $config["per_page"]           = 10;
        $config["uri_segment"]        = 3;
        $config['reuse_query_string'] = true;
        $config["use_page_numbers"]   = TRUE;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul><!--pagination-->';
        $config['first_link']         = '&laquo; First';
        $config['first_tag_open']     = '<li class="prev page">';
        $config['first_tag_close']    = '</li>';
        $config['last_link']          = 'Last &raquo;';
        $config['last_tag_open']      = '<li class="next page">';
        $config['last_tag_close']     = '</li>';
        $config['next_link']          = 'Next &rarr;';
        $config['next_tag_open']      = '<li class="next page">';
        $config['next_tag_close']     = '</li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&larr; Previous';
        $config['prev_tag_open']      = '<li class="prev page">';
        $config['prev_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="active"><a href="">';
        $config['cur_tag_close']      = '</a></li>';
        $config['num_tag_open']       = '<li class="page">';
        $config['num_tag_close']      = '</li>';
        $config['anchor_class']       = 'follow_link';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
         if(!empty($_GET['ExportType'])){
            $export_data = 1;
        }else{
            $export_data = 0;
        }
        $this->data['autoproductionPlan'] = $this->production_model->get_data1('auto_production_plan', $where, $config["per_page"], $page, $where2, $order,$export_data);
        if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }
       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }
     $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
        
        $this->_render_template('auto_production_plan/index', $this->data);
    }

    public function auto_production_plan_edit()
    {
       $this->breadcrumb->add('Auto Production Plan', base_url() . 'auto_production_plan');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Auto Production Plan';
        $id = $_GET['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->breadcrumb->add('Auto Production Plan', base_url() . 'auto_production_plan');
        $this->breadcrumb->add($id ? 'Edit' : 'Add', base_url() . 'auto_production_plan/' . $id ? 'Edit' : 'Add');
        $this->settings['breadcrumbs']   = $this->breadcrumb->output();
        $this->settings['pageTitle']     = $id ? 'Auto Production Plan Edit' : 'Auto Production Plan Add';

        $where                           = array(
            'production_setting.created_by_cid' => $this->companyId
        );
        $this->data['productionSetting'] = $this->production_model->get_data('production_setting', $where);
         $machineWhere                    = array(
            'add_machine.created_by_cid' => $this->companyId,
            'add_machine.save_status' => 1
        );
        $this->data['machineName']       = $this->production_model->get_data('add_machine', $machineWhere);
        $this->data['production_plan']   = $this->production_model->get_data_byId('auto_production_plan', 'id', $id);

        
       $this->_render_template('auto_production_plan/edit', $this->data);
    }

    public function auto_production_data_according_toDeprtment()
    {
         $combined_array  = array(); $mct_array = array();
        if ($_REQUEST['selected_department_idd'] != '' && $_REQUEST['date'] != '' && $_REQUEST['shift'] != '') {
        if ($_REQUEST['table'] == 'auto_production_plan') {
                $createdDateShift_planning = $this->production_model->dateAndShiftExist('auto_production_plan', $_REQUEST['date'], $_REQUEST['shift'], $_REQUEST['selected_department_idd']);
                if ($createdDateShift_planning) {
                    echo 'Data of this date and shift already exist';
                } else {
                    $machineWhere              = array(
                        'add_machine.created_by_cid' => $this->companyId,
                        'add_machine.save_status' => 1,
                        'add_machine.department' => $_REQUEST['selected_department_idd']
                    );
                    $get_machine_data          = $this->production_model->get_data('add_machine', $machineWhere);
                    $Where                     = array(
                        'wages_perpiece_setting.created_by_cid' => $this->companyId,
                        'wages_perpiece_setting.department' => $_REQUEST['selected_department_idd']
                    );
                    $get_wages_data            = $this->production_model->get_data('wages_perpiece_setting', $Where);

                    $where_wo  = "work_order.inprocess_complete = 0 AND work_order.active_inactive = 1 AND work_order.created_by_cid = " . $this->companyId;
                    $work_order = $this->production_model->get_data_wo_bypriorty('work_order', $where_wo);
                    $where_pset = array(
                    'company_branch' => $_REQUEST['compny_unit'],
                    'department_id' => $_REQUEST['selected_department_idd'],
                    );
                   $production_data = $this->production_model->get_data('production_data', $where_pset);
                    $production_planning = $this->production_model->get_data('production_planning', $where_pset);
                    
                    /*****Get Work Order data******/
                    foreach ($work_order as $key => $work_order_data) {
                    /*****Work Order Name******/
                    $workorder_id = $work_order_data['id'];
                    $workorder_name = $work_order_data['workorder_name'];

                    /*****Work Order Product Details******/
                    $product_detail = json_decode($work_order_data['product_detail']);
                    foreach ($product_detail as $p_key => $product_data) {
                    $whereConditionJobCard  =  array('job_card_no' => $product_data->job_card,'material_id' => '');
                    $jobCardDetails         =  $this->production_model->get_job_card_data('job_card','material_name_id', $whereConditionJobCard);
                    if($jobCardDetails){
                    $alljobcardqty[$jobCardDetails['id']]=$jobCardDetails;
                    $alljobcardqty[$jobCardDetails['id']]['transfer_quantity'] = $product_data->transfer_quantity;
                    }

                    $status = $material_type = $material_name_detail = $available_quantity = $quantity_required = $reserved_quantity = $uom = "";
                    foreach($alljobcardqty as $jobkey => $materialInfo12){
                    $jobCardMaterialss  = json_decode($materialInfo12['material_details'],true);
                    $cck = 1;
                    $material_array = array();
                    foreach ($jobCardMaterialss as $key => $materialInfo) {
                    //if($cck == 1){
                    $newQuantityValuert = ($materialInfo12['lot_qty'] != 0 ) ? $materialInfo['quantity'] / $materialInfo12['lot_qty'] : 0;
                    $newQuantityValue= $newQuantityValuert * $materialInfo12['transfer_quantity'];
                    $expectedQuantity = ( $newQuantityValue > 0) ? $materialInfo['quantity'] * $newQuantityValue : $materialInfo['quantity'];
                    $where = "reserved_material.mayerial_id = '".$materialInfo['material_name_id']."' AND reserved_material.created_by_cid ='".$this->companyId."' AND reserved_material.work_order_id ='".$work_order_data['id']."' AND reserved_material.job_card_id =".$materialInfo12['id']; 
                    $reservedData = $this->production_model->get_data_single('reserved_material', $where);
                    $reserved_quantitym = $reservedData ? $reservedData['quantity'] : 0;
                    $yu = getNameById_mat('mat_locations',$materialInfo['material_name_id'],'material_name_id');
                    $sum = 0;
                    if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                    $unit = $materialInfo['unit'];
                    $materialName     = getNameById('material',$materialInfo['material_name_id'],'id');
                    $ww =  getNameById('uom', $materialName->uom,'id');
                    $uom = !empty($ww)?$ww->uom_quantity:'N/A';
                    $productDetails   = getNameById('material_type',$materialInfo['material_type_id'],'id');
                    $material_type = $productDetails->name;
                    $material_name_detail = $materialName->material_name;
                    $quantity_required = round($newQuantityValue,2);
                    $reserved_quantity = $reserved_quantitym;
                    $available_quantity = $sum - $reserved_quantitym;
                    if($quantity_required > $available_quantity){ 
                    $status = "Not Available";
                    } else if($available_quantity >= $quantity_required){
                    $status = "In Stock";
                    } else if($reserved_quantity == $quantity_required){ 
                    $status = "Reserved";
                    }
                    //}
                    $material_array[] = array(
                    'material_type' => $material_type,
                    'material_name_detail' => $material_name_detail, 
                    'available_quantity' => $available_quantity,
                    'quantity_required' => $quantity_required,
                    'reserved_quantity' => $reserved_quantity,
                    'uom' => $uom,
                    );
                    $cck++;
                    }
                    }
                    //pre($material_array);
                     /**material_data start**/
                    $material_data = getNameById('material', $product_data->product,'id');
                    $material_id = $material_data->id;
                    $material_name = $material_data->material_name;
                    $job_card = $product_data->job_card;
                    $jobCardData = getNameById('job_card',$job_card,'job_card_no');
                    $job_id = $jobCardData->id;
                    /**material_data end**/
                    
                    /**machine_details data start**/
                    $machine_details = json_decode($jobCardData->machine_details);
                    $process_name = array();
                    foreach ($machine_details as $key_mac => $machine_details_data) {

                    /**production_data start**/
                    foreach ($production_data as $p_key => $data_val) {
                    $decode_data = json_decode($data_val['production_data'], true);
                    foreach ($decode_data as $key => $data_chk) {
                    if($jobCardData->id == $data_chk['job_card_product_id'][0] && $machine_details_data->processess == $data_chk['process_name'][0]){
                    $pd_val = array();
                    //$sum_com = 0;
                    foreach ($data_chk['output'] as $key_ot => $value) {
                    foreach ($value as $key => $value1) {
                    $pd_val[$machine_details_data->processess][] = $value1;    
                    }
                    }
                    }
                    }
                    } 
                    // if(empty($production_data)){
                    // $pd_val = "0";
                    // } else {
                    // $pd_val = $sum_com;
                    // }
                    /**production_data end**/
                    /**production_planning start**/
                    foreach ($production_planning as $p_key => $data_val) {
                    $decode_data = json_decode($data_val['planning_data'], true);
                    foreach ($decode_data as $key => $data_chk) {
                    if($jobCardData->id == $data_chk['job_card_product_id'][0] && $machine_details_data->processess == $data_chk['process_name'][0]){
                    //$sum_pp = 0;
                    $pp_val = array();
                    foreach ($data_chk['output'] as $key_ot => $value) {
                    foreach ($value as $key => $value1) {
                    $pp_val[$machine_details_data->processess][] = $value1; 
                    }
                    
                    }
                    }
                    }
                    }
                    // if(empty($production_planning)){
                    // $pp_val = "0";
                    // } else {
                    // $pp_val = $sum_pp;
                    // }
                    /**production_planning end**/


                    $processess = getNameById('add_process',$machine_details_data->processess,'id');
                    $process_id = $processess->id;
                    $process_name = $processess->process_name;
                    $output_process =   json_decode($machine_details_data->output_process,true);
                    $machine_paramenters = json_decode($machine_details_data->machine_details,true);
                    $hr_set_array =$mm_set_array =$sec_set_array =$mt_hr_array =$mt_mm_array =$mt_sec_array = $machine_name_array = array();
                    foreach($machine_paramenters as $value){
                    foreach ($value['machine_id'] as $key => $value1) {
                    $machine_info = getNameById('add_machine',$value['machine_id'][$value1],'id');
                    $machine_grpinfo = getNameById('machine_group',$machine_info->machine_group_id,'id');
                    $machine_name_array[] = array(
                    'machine_id' => $machine_info->id,
                    'machine_name' => $machine_info->machine_name,
                    'machine_group_id' => $machine_info->machine_group_id,
                    'priority_order' => $machine_info->priority_order,
                    'machine_group_name' => $machine_grpinfo->machine_group_name
                    );
                    $hr_set_array[] = $value['hr_set'][$value1];
                    $mm_set_array[] = $value['mm_set'][$value1];
                    $sec_set_array[] = $value['sec_set'][$value1];
                    $mt_hr_array[] = $value['mt_hr_set'][$value1];
                    $mt_mm_array[] = $value['mt_mm_set'][$value1];
                    $mt_sec_array[] = $value['mt_sec_set'][$value1];
                    }
                    $hr_set[$machine_details_data->processess] = $hr_set_array;
                    $mm_set[$machine_details_data->processess] = $mm_set_array;
                    $sec_set[$machine_details_data->processess] = $sec_set_array;
                    $mt_hr_set[$machine_details_data->processess] = $mt_hr_array;
                    $mt_mm_set[$machine_details_data->processess] = $mt_mm_array;
                    $mt_sec_set[$machine_details_data->processess] = $mt_sec_array;
                    $machine_name_set[$machine_details_data->processess] = $machine_name_array;
                    }

                    //$machine_name = 
                    $machine_id_set =  "";
                    $machine_order_set =  "";
                    $machine_name_id = array();
                    $setup_time  = $machine_time = 0;
                    $setup_time_array = $machine_time_array = array();
                    $setup_machine_array = array();
                    foreach ($machine_name_set[$machine_details_data->processess] as $keycc => $value) {
                    $machine_id_set .= $machine_name_set[$machine_details_data->processess][$keycc]['machine_id'].',';
                    $machine_order_set .= $machine_name_set[$machine_details_data->processess][$keycc]['priority_order'].',';
                    $machine_id = $machine_name_set[$machine_details_data->processess][$keycc]['machine_id'];
                    $machine_name = $machine_name_set[$machine_details_data->processess][$keycc]['machine_name'];
                    $machine_group_id = $machine_name_set[$machine_details_data->processess][$keycc]['machine_group_id'];
                    $machine_grpinfo = getNameById('machine_group',$machine_group_id,'id');
                    $machine_name_id[] = array(
                    'id'=>$machine_id,
                    'name'=>$machine_name,
                    'machine_group_id'=>$machine_group_id,
                    'machine_group_name'=>$machine_grpinfo->machine_group_name
                    );
                    }

                    foreach ($machine_name_set[$machine_details_data->processess] as $keycc => $value) {

                    $hhs = $hr_set[$machine_details_data->processess][$keycc];  
                    $mms = $mm_set[$machine_details_data->processess][$keycc];    
                    $sss = $sec_set[$machine_details_data->processess][$keycc];
                    $setup_time += timeToSeconds($hhs.':'.$mms.':'.$sss);
                    $setup_time_array[$machine_details_data->processess][] = timeToSeconds($hhs.':'.$mms.':'.$sss);
                    $hhm = $mt_hr_set[$machine_details_data->processess][$keycc];    
                    $mmm = $mt_mm_set[$machine_details_data->processess][$keycc]; 
                    $ssm = $mt_sec_set[$machine_details_data->processess][$keycc];
                    $machine_time += timeToSeconds($hhm.':'.$mmm.':'.$ssm);
                    $machine_time_array[$machine_details_data->processess][] = timeToSeconds($hhm.':'.$mmm.':'.$ssm);
                    $setup_machine_array[$machine_details_data->processess][] = array(
                    'setup_time'=>timeToSeconds($hhs.':'.$mms.':'.$sss),
                    'machine_time'=>timeToSeconds($hhm.':'.$mmm.':'.$ssm)
                    );
                    break;
                    }

                    //$req_output = $process_output_qty =$process_output_qty_get = "";
                    $process_output_array = array();
                    $ii = 0;
                    foreach($output_process as $output_process_info){
                    $process_output_qty = $output_process_info['quantity_output'];
                    $material_id_output = $output_process_info['material_output_name'];
                    $materialName_output = getNameById('material',$material_id_output,'id');
                    $process_output_material_name = $materialName_output->material_name;
                    $lot_qty = $jobCardData->lot_qty;
                    $wo_qty = $product_data->transfer_quantity;
                    $req_output = $wo_qty*$process_output_qty/$lot_qty;
                    $remain_qty = $req_output-$pd_val[$machine_details_data->processess][$ii]-$pp_val[$machine_details_data->processess][$ii];
                    $remain_time=$total_time =$process_time ="";
                    $machine_time1 = $setup_time1 = $remain_time1 = array();
                    foreach ($setup_machine_array as $key_main => $setup_machine_val) {
                    //foreach ($setup_machine_val as $key_set => $setup_machine_data) {
                    $setup_time = $setup_machine_val[0]['setup_time'];
                    $setup_time1[] = $setup_machine_val[0]['setup_time'];
                    $machine_time1[] = $setup_machine_val[0]['machine_time'];
                    $machine_time = $setup_machine_val[0]['machine_time'];
                    if($remain_qty == $req_output){
                    $seconds =  $setup_time + ($remain_qty/$process_output_qty*$machine_time);
                    $remain_time .= sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60).'<br>';
                    $remain_time1[] = sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60);
                    $total_time .= sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60).'<br>';
                    } elseif($remain_qty < $req_output){
                    $seconds = $remain_qty/$process_output_qty*$machine_time;
                    $remain_time .=  sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60).'<br>';
                    $remain_time1[] =  sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60);
                    $process_time .=  sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60).'<br>';
                    } elseif($remain_qty <= 0){
                    $remain_time =  '00:00:00';
                    $remain_time1 =  '00:00:00';
                    }
                    
                    

                    //}
                    }
                    $process_output_array[] = array(
                    'remain_time' => $remain_time1[0],
                    'remain_qty' => $remain_qty,
                    'req_output' => $req_output,
                    'complete_qty' => $pd_val[$machine_details_data->processess][$ii],
                    'progress_qty' => $pp_val[$machine_details_data->processess][$ii],
                    'setup_time' => $setup_time1[0],
                    'machine_time' => $machine_time1[0],
                    'shift_duration' => $_REQUEST['shift_duration'],
                    'quantity_output' => $output_process_info['quantity_output'],
                    'output_material_name' => $process_output_material_name
                    );

                    
                    $ii++; 
                    }
                    //pre($process_output_array);
                    //pre($material_array);
                    $combined_array[] = array(
                    'machine_id' => rtrim($machine_id_set, ','),
                    'machine_order_set' => rtrim($machine_order_set, ','),
                    'machine_name_id' => $machine_name_id,
                    'workorder_id' => $workorder_id,
                    'workorder_name' => $workorder_name,
                    'status' => $status,
                    'material_type' => $material_type,
                    'material_name_detail' => $material_name_detail, 
                    'job_card' => $job_card,
                    'job_card_id' => $job_id,
                    'material_name' => $material_name,
                    'material_id' => $material_id,
                    'available_quantity' => $available_quantity,
                    'quantity_required' => $quantity_required,
                    'reserved_quantity' => $reserved_quantity,
                    'uom' => $uom,
                    'process_name' => $process_name,
                    'process_id' => $process_id,                    
                    'remain_time' => rtrim($remain_time, '<br>'),
                    'output_array' => $process_output_array,
                    'material_array' => $material_array
                    );
                    
                   foreach ($machine_name_set[$machine_details_data->processess] as $keycc => $value) {
                    $machine_id = $machine_name_set[$machine_details_data->processess][$keycc]['machine_id'];
                    $machine_priority_order = $machine_name_set[$machine_details_data->processess][$keycc]['priority_order'];
                    $machine_name = $machine_name_set[$machine_details_data->processess][$keycc]['machine_name'];
                    $machine_group_id = $machine_name_set[$machine_details_data->processess][$keycc]['machine_group_id'];
                    $machine_group_name = $machine_name_set[$machine_details_data->processess][$keycc]['machine_group_name'];
                    $mct_array[] = array(
                    'machine_id' => $machine_id,
                    'machine_order_set' => $machine_priority_order,
                    'machine_name' => $machine_name,
                    'machine_group_id' => $machine_group_id,
                    'machine_group_name' => $machine_group_name,
                    'workorder_id' => $workorder_id,
                    'workorder_name' => $workorder_name,
                    'status' => $status,
                    'material_type' => $material_type,
                    'material_name_detail' => $material_name_detail, 
                    'job_card' => $job_card,
                    'job_card_id' => $job_id,
                    'material_name' => $material_name,
                    'material_id' => $material_id,
                    'available_quantity' => $available_quantity,
                    'quantity_required' => $quantity_required,
                    'reserved_quantity' => $reserved_quantity,
                    'uom' => $uom,
                    'process_name' => $process_name,
                    'process_id' => $process_id,                    
                    'remain_time' => rtrim($remain_time, '<br>'),
                    'output_array' => $process_output_array,
                    'material_array' => $material_array
                    );
                    
                    // $machine_name_id[] = array(
                    // 'id'=>$machine_id,
                    // 'name'=>$machine_name
                    // );
                    }


                    }
                    /**machine_details data end**/
                    }
                    /**Work Order Product end**/
                    }
                    /**Work Order end**/
                    

                    //pre($mct_array);
                    $data_sheet_show = array_orderby($mct_array, 'machine_id', SORT_DESC, 'machine_name', SORT_ASC); 
                    usort($data_sheet_show, function($a,$b) {
                    if($a['machine_order_set'] == $b['machine_order_set']) return 0;
                    return ($a['machine_order_set'] < $b['machine_order_set']) ? -1 : 1;
                    });
                   //  pre($data_sheet_show);
                   // die;
                   // $combined_array['Machine'] = $get_machine_data;
                    // $combined_array['wages']   = $get_wages_data;
                    $send_data = array(
                    'proceed_data'=> $combined_array,
                    'show_data' => $data_sheet_show
                    );
                    $data = json_encode($send_data);
                    echo $data;
                }
            }
        }
    }


      public function auto_production_plan_data()
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $combined_array = array();
        if ($_REQUEST['selected_department_idd'] != '' && $_REQUEST['date'] != '' && $_REQUEST['shift'] != '') {
            if ($_REQUEST['table'] == 'auto_production_plan') {
                $createdDateShift_planning = $this->production_model->dateAndShiftExist('auto_production_plan', $_REQUEST['date'], $_REQUEST['shift'], $_REQUEST['selected_department_idd']);
                if ($createdDateShift_planning) {
                    echo 'Data of this date and shift already exist';
                } else {
                     $machineWhere              = array(
                        'add_machine.created_by_cid' => $this->companyId,
                        'add_machine.save_status' => 1,
                        'add_machine.department' => $_REQUEST['selected_department_idd']
                    );
                    $get_machine_data          = $this->production_model->get_data('add_machine', $machineWhere);
                     $Where                     = array(
                        'wages_perpiece_setting.created_by_cid' => $this->companyId,
                        'wages_perpiece_setting.department' => $_REQUEST['selected_department_idd']
                    );
                    $get_wages_data            = $this->production_model->get_data('wages_perpiece_setting', $Where);
                    $data_sheet = json_decode($_REQUEST['data_sheet'], true);
                    $process_array = array();
                    foreach ($data_sheet['proceed_data'] as $key => $data_sheet_value) {
                    $ids = explode(',', $data_sheet_value['machine_id']);
                    //$machine_names = explode('<br>', $data_sheet_value['machine_name']);
                    $remain_time = explode('<br>', $data_sheet_value['remain_time']);
                    if($data_sheet_value['status'] == "In Stock" && !empty($data_sheet_value['remain_time'])){
                    $cc_chk = 0;
                    $appaned_data = array();
                    $balance_time = '';
                    foreach ($get_machine_data as $key_mc => $get_machine_value) {
                    $machine_grpinfo = getNameById('machine_group',$get_machine_value['machine_group_id'],'id');
                    $machine_group_name = $machine_grpinfo->machine_group_name;
                    $get_machine_data[$key_mc]['machine_group_name'] = $machine_group_name;
                    $machine_id = $get_machine_value['id'];
                      if(in_array($get_machine_value['id'], $ids) && empty($get_machine_value['job_card'])){
                    if(!empty($data_sheet_value['output_array'])){
                    $output_val = array();
                    foreach ($data_sheet_value['output_array'] as $key => $output_array_val) {
                    $str_time = $output_array_val['remain_time'];
                    $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
                    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $remain_time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                    $mt_time = $output_array_val['shift_duration'].':00';
                    $mt_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $mt_time);
                    sscanf($mt_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $mt_time_seconds = $hours * 3600 + $minutes * 60 + $seconds;


                    if($output_array_val['remain_qty'] == $output_array_val['req_output'] && $remain_time_seconds >= $mt_time_seconds){
                    $cal_time= $mt_time_seconds - $output_array_val['setup_time'];
                    $cal_time1 = $output_array_val['machine_time'] * $output_array_val['quantity_output'];
                    $output = $cal_time / $cal_time1;
                    //$output = ($mt_time_seconds-$output_array_val['setup_time'])/$output_array_val['machine_time']*$output_array_val['quantity_output'];
                    } elseif($output_array_val['remain_qty'] < $output_array_val['req_output'] && $remain_time_seconds >= $mt_time_seconds){
                    @$cal_time= $mt_time_seconds / $output_array_val['setup_time'];
                    $cal_time1 = $output_array_val['quantity_output'];
                    $output = $cal_time * $cal_time1;
                    //$output = ($mt_time_seconds/$output_array_val['machine_time'])*$output_array_val['quantity_output'];
                    } elseif($output_array_val['remain_qty'] == $output_array_val['req_output'] && $remain_time_seconds < $mt_time_seconds){
                    $cal_time= $remain_time_seconds - $output_array_val['setup_time'];
                    @$cal_time1 = $output_array_val['machine_time'] * $output_array_val['quantity_output'];
                    @$output = $cal_time / $cal_time1;
                    //echo $output = (is_numeric($remain_time_seconds)-is_numeric($output_array_val['setup_time']))/is_numeric($output_array_val['machine_time'])*is_numeric($output_array_val['quantity_output']);
                        $balance_time = (int)$mt_time_seconds-(int)$remain_time_seconds;
                    } elseif($output_array_val['remain_qty'] < $output_array_val['req_output'] && $remain_time_seconds < $mt_time_seconds){
                    $cal_time= $remain_time_seconds / $output_array_val['machine_time'];
                    $cal_time1 = $output_array_val['quantity_output'];
                    $output = $cal_time / $cal_time1;
                    //$output = ($remain_time_seconds/$output_array_val['machine_time'])*$output_array_val['quantity_output'];
                    $balance_time = (int)$mt_time_seconds-(int)$remain_time_seconds;
                    }
                    if(is_infinite($output) || is_nan($output)){
                    $output_val[str_replace(array( '(', ')', '/' ), '', $output_array_val['output_material_name'])] = '0';    
                } else {
                    $output_val[str_replace(array( '(', ')', '/' ), '', $output_array_val['output_material_name'])] = round($output, 3);   
                }
                    $req_output = $output_array_val['req_output']; 
                    $remain_qty = $output_array_val['remain_qty'];                
                    
                    }
                    //pre($output_val); die;
                    $appaned_data[$machine_id][] = array(
                    'workorder_name' => $data_sheet_value['workorder_name'],
                    'workorder_id' => $data_sheet_value['workorder_id'],
                    'material_name' => $data_sheet_value['material_name'],
                    'material_id' => $data_sheet_value['material_id'],
                    'job_card' => $data_sheet_value['job_card'],
                    'job_card_id' => $data_sheet_value['job_card_id'],
                    'process_name_sec' => $data_sheet_value['process_name'],
                    'process_id_sec' => $data_sheet_value['process_id'],
                    'output_data' => $output_val,
                    'balance_time' => $balance_time,
                    'req_output' => $req_output,
                    'shift_duration' => $mt_time_seconds,
                    'remain_qty' => $remain_qty
                    );
                    $get_machine_data[$key_mc]['job_card'] = $data_sheet_value['job_card'];
                    $get_machine_data[$key_mc]['set_process_id'] = $data_sheet_value['process_id'];
                    $get_machine_data[$key_mc]['appaned_data'] = $appaned_data;
                    
                   // $get_machine_data[$key_mc]['process_output_material_name'] = $process_output_material_name;
                    $process_array[] =  $data_sheet_value['process_id'];
                    
                    break;
                    }
                    } elseif(in_array($get_machine_value['id'], $ids) && !empty($get_machine_value['job_card']) && !empty($get_machine_value['appaned_data'][$machine_id][array_key_last($get_machine_value['appaned_data'][$machine_id])]['balance_time'])){
                    if(!empty($data_sheet_value['output_array'])){
                    $output_val = array();
                    foreach ($data_sheet_value['output_array'] as $key => $output_array_val) {
                    $str_time = $output_array_val['remain_time'];
                    $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
                    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $remain_time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                    $mt_time_seconds = $get_machine_value['appaned_data'][$machine_id][array_key_last($get_machine_value['appaned_data'][$machine_id])]['balance_time'];
                    
                    if($output_array_val['remain_qty'] == $output_array_val['req_output'] && $remain_time_seconds >= $mt_time_seconds){
                    $cal_time= $mt_time_seconds - $output_array_val['setup_time'];
                    $cal_time1 = $output_array_val['machine_time'] * $output_array_val['quantity_output'];
                    $output = $cal_time / $cal_time1;
                    //$output = ($mt_time_seconds-$output_array_val['setup_time'])/$output_array_val['machine_time']*$output_array_val['quantity_output'];
                    $balance_time = "";
                    } elseif($output_array_val['remain_qty'] < $output_array_val['req_output'] && $remain_time_seconds >= $mt_time_seconds){
                    $cal_time= $mt_time_seconds - $output_array_val['machine_time'];
                    $cal_time1 = $output_array_val['quantity_output'];
                    $output = $cal_time / $cal_time1;
                    //$output = ($mt_time_seconds/$output_array_val['machine_time'])*$output_array_val['quantity_output'];
                    } elseif($output_array_val['remain_qty'] == $output_array_val['req_output'] && $remain_time_seconds < $mt_time_seconds){
                    $cal_time= $remain_time_seconds - $output_array_val['setup_time'];
                    @$cal_time1 = $output_array_val['machine_time'] * $output_array_val['quantity_output'];
                    @$output = $cal_time / $cal_time1;
                    $balance_time = (int)$mt_time_seconds-(int)$remain_time_seconds;
                    } elseif($output_array_val['remain_qty'] < $output_array_val['req_output'] && $remain_time_seconds < $mt_time_seconds){
                    $cal_time= $remain_time_seconds / $output_array_val['machine_time'];
                    $cal_time1 = $output_array_val['quantity_output'];
                    $output = $cal_time / $cal_time1;
                    //$output = ($remain_time_seconds/$output_array_val['machine_time'])*$output_array_val['quantity_output'];
                    $balance_time = (int)$mt_time_seconds-(int)$remain_time_seconds;
                    }
                    if(is_infinite($output) || is_nan($output)){
                    $output_val[str_replace(array( '(', ')', '/' ), '', $output_array_val['output_material_name'])] = '0';    
                } else {
                    $output_val[str_replace(array( '(', ')', '/' ), '', $output_array_val['output_material_name'])] = round($output, 3);   
                }                  
                    $req_output = $output_array_val['req_output']; 
                    $remain_qty = $output_array_val['remain_qty'];                
                    
                    }

                    
                    
                    $get_machine_data[$key_mc]['appaned_data'][$machine_id][] = array(
                    'workorder_name' => $data_sheet_value['workorder_name'],
                    'workorder_id' => $data_sheet_value['workorder_id'],
                    'material_name' => $data_sheet_value['material_name'],
                    'material_id' => $data_sheet_value['material_id'],
                    'job_card' => $data_sheet_value['job_card'],
                    'job_card_id' => $data_sheet_value['job_card_id'],
                    'process_name_sec' => $data_sheet_value['process_name'],
                    'process_id_sec' => $data_sheet_value['process_id'],
                    'output_data' => $output_val,
                    'balance_time' => $balance_time,
                    'req_output' => $req_output,
                    'shift_duration' => $mt_time_seconds,
                    'remain_qty' => $remain_qty
                    );
                    $get_machine_data[$key_mc]['job_card'] = $data_sheet_value['job_card'];
                    $get_machine_data[$key_mc]['set_process_id'] = $data_sheet_value['process_id'];
                    $process_array[] =  $data_sheet_value['process_id'];
                    //$get_machine_data[$key_mc]['appaned_data'] = $appaned_data;
                    break;
                    }   
                    }
                    $cc_chk++;
                    }
                    }
                     }
                    //pre($data_sheet);
                    usort($get_machine_data, function($a,$b) {
                    if($a['priority_order'] == $b['priority_order']) return 0;
                    return ($a['priority_order'] < $b['priority_order']) ? -1 : 1;
                    });
                      // pre($get_machine_data);
                      // die;
                    //  sort($process_array);
                    //  $new_mcarray = array();
                    //  foreach ($process_array as $key => $value) {
                    //     foreach ($get_machine_data as $key => $value1) {
                    //  if(in_array($value, $value1)){
                    //     $new_mcarray[] = $value1;
                    //  }
                    //  }
                    // }
                     // pre($new_mcarray);
                     // die;
                    //$combined_array['Machine'] = array_reverse($get_machine_data);
                    $combined_array['Machine'] = $get_machine_data;
                    $combined_array['wages']   = $get_wages_data;
                    $data                      = json_encode($combined_array);

                    echo $data;
                }
            }
        }
    }

    public function saveAutoProductionPlan()
    {
        //pre($_POST); die;
        $productionPlan_dataLength = (isset($_POST['machine_name_id'])) ? count($_POST['machine_name_id']) : 0;
        if ($productionPlan_dataLength > 0) {
            $planningArray = array();
            $j             = 0;
            $machine_name_idarray = array_values(array_filter($_POST['machine_name_id']));
            $machine_grparray = array_values(array_filter($_POST['machine_grp']));
            while ($j < $productionPlan_dataLength) {
                 $PlanningArrayObject = (array(
                    'machine_name_id' => $machine_name_idarray[$j],
                    'machine_grp' => $machine_grparray[$j],
                    'sale_order' => isset(array_values($_POST['sale_order'])[$j]) ? array_values($_POST['sale_order'])[$j] : '',
                    'work_order' => isset(array_values($_POST['work_order'])[$j]) ? array_values($_POST['work_order'])[$j] : '',
                    'product_name' => isset(array_values($_POST['product_name'])[$j]) ? array_values($_POST['product_name'])[$j] : '',
                    'job_card_product_id' => isset(array_values($_POST['job_card_product_id'])[$j]) ? array_values($_POST['job_card_product_id'])[$j] : '',
                    'process_name' => isset(array_values($_POST['process_name'])[$j]) ? array_values($_POST['process_name'])[$j] : '',
                    'npdm' => isset(array_values($_POST['npdm_name'])[$j]) ? array_values($_POST['npdm_name'])[$j] : '',
                    'specification' => isset(array_values($_POST['specification'])[$j]) ? array_values($_POST['specification'])[$j] : '',
                    'worker' => isset(array_values($_POST['worker_name'])[$j]) ? array_values($_POST['worker_name'])[$j] : '',
                    'output' => isset(array_values($_POST['output'])[$j]) ? array_values($_POST['output'])[$j] : ''
                ));


                $planningArray[$j] = $PlanningArrayObject;
                $j++;
            }
            //pre($planningArray); die;
            if (!empty($planningArray)) {
                foreach ($planningArray as $key => $pa) {
                    if (!empty($pa)) {
                        foreach ($pa as $paKey => $paValue) {
                            $i  = 0;
                            $aa = array();
                            if (!empty($paValue) && count($paValue) > 1) {
                                foreach ($paValue as $v) {
                                    //echo $i;
                                    $aa[$i] = $v;
                                    $i++;
                                }
                            } else {
                                $aa = $paValue;
                            }
                            $paValue    = $aa;
                            $pa[$paKey] = $paValue;
                        }
                    }
                    $planningArray[$key] = $pa;
                }
            }
            //pre($planningArray); die;
            $productionPlan_array = json_encode($planningArray);
        } else {
            $productionPlan_array = '';
        }
        $workerArrayId = array();
        if (!empty($_POST['worker_name'])) {
            foreach ($_POST['worker_name'] as $workerIds) {
                foreach ($workerIds as $get_worker_id) {
                    foreach ($get_worker_id as $worker_id) {

                        $workerArrayId[] = $worker_id;
                    }
                }
            }
        }


        $workerIdsUpdate = implode("','", $workerArrayId);
        $workerIdsUpdate = "'" . $workerIdsUpdate . "'";

        if ($this->input->post()) {
            $required_fields = array(
                'machine_name_id'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $data['planning_data']  = $productionPlan_array;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id ;
                $data['created_by_cid'] = $this->companyId;
                $id                     = $data['id'];
                $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 22
                ));

                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success           = $this->production_model->update_data('auto_production_plan', $data, 'id', $id);
                    if ($workerIdsUpdate != "''")
                        updateMultipleUsedIdStatus('worker', $workerIdsUpdate);
                    if ($data['department_id'] != '')
                        updateUsedIdStatus('department', $data['department_id']);
                    if ($data['shift'] != '')
                        updateUsedIdStatus('production_setting', $data['shift']);
                    if ($success) {
                        $data['message'] = "Auto production plan updated successfully";
                        logActivity('Auto production plan Updated', 'auto_production_plan', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                 pushNotification(array(
                                        'subject' => 'Auto Production Plan updated',
                                        'message' => 'Auto Production Plan id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $_SESSION['loggedInCompany']->u_id,
                                        'ref_id' => $id,
                                        'class' => 'productionTab',
                                        'data_id' => 'productionPlanView',
                                        'icon' => 'fa fa-archive'
                                    ));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array(
                                'subject' => 'Auto Production Plan updated',
                                'message' => 'Auto Production Plan id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInCompany']->u_id,
                                'ref_id' => $id,
                                'class' => 'productionTab',
                                'data_id' => 'productionPlanView',
                                'icon' => 'fa fa-archive'
                            ));
                        }
                        $this->session->set_flashdata('message', 'Auto Production Plan Updated successfully');
                        redirect(base_url() . 'production/auto_production_plan', 'refresh');
                    }
                } else {
                    $createdDateShift = $this->production_model->dateAndShiftExist('auto_production_plan', $_POST['date'], $_POST['shift'], 'update');
                    if ($createdDateShift) {
                        $this->session->set_flashdata('message', 'Auto Production Plan Already exist');
                        redirect(base_url() . 'production/auto_production_plan', 'refresh');
                    } else {
                        //pre($data); die;
                        $id = $this->production_model->insert_tbl_data('auto_production_plan', $data);
                        if ($workerIdsUpdate != "''")
                            updateMultipleUsedIdStatus('worker', $workerIdsUpdate);
                        if ($data['department_id'] != '')
                            updateUsedIdStatus('department', $data['department_id']);
                        if ($data['shift'] != '')
                            updateUsedIdStatus('production_setting', $data['shift']);
                        if ($id) {
                            logActivity('Auto production plan Added ', 'auto_production_plan', $id);
                            if (!empty($usersWithViewPermissions)) {
                                foreach ($usersWithViewPermissions as $userViewPermission) {
                                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                        pushNotification(array(
                                            'subject' => 'Auto Production Plan created',
                                            'message' => 'New Auto Production Plan is created by ' . $_SESSION['loggedInUser']->name,
                                            'from_id' => $_SESSION['loggedInUser']->u_id,
                                            'to_id' => $userViewPermission['user_id'],
                                            'ref_id' => $id,
                                            'class' => 'productionTab',
                                            'data_id' => 'productionPlanView',
                                            'icon' => 'fa fa-archive'
                                        ));
                                    }
                                }
                            }
                            if ($_SESSION['loggedInUser']->role != 1) {
                                pushNotification(array(
                                    'subject' => 'Auto Production Plan created',
                                    'message' => 'New Auto Production Plan is created by ' . $_SESSION['loggedInUser']->name,
                                    'from_id' => $_SESSION['loggedInUser']->u_id,
                                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                                    'ref_id' => $id,
                                    'class' => 'productionTab',
                                    'data_id' => 'productionPlanView',
                                    'icon' => 'fa fa-archive'
                                ));
                            }
                            $this->session->set_flashdata('message', 'Auto Production Plan Added successfully');
                            redirect(base_url() . 'production/auto_production_plan', 'refresh');
                        }
                    }
                }
            }
        }
    }

    public function autoproduction_planning_view()
    {
        $id                         = $_POST['id'];
        $this->data['planningView'] = $this->production_model->get_data_byId('auto_production_plan', 'id', $id);
        $this->load->view('auto_production_plan/view', $this->data);
    }

    public function deleteAutoProductionplan($id = '')
    {
        if (!$id) {
            redirect('production/auto_production_plan', 'refresh');
        }
        //permissions_redirect('is_delete');
        $result = $this->production_model->delete_data('auto_production_plan', 'id', $id);
        if ($result) {
            logActivity('Auto Production Plan Deleted', 'auto_production_plan', $id);
            $usersWithViewPermissions = $this->production_model->get_data('permissions', array(
                'is_view' => 1,
                'sub_module_id' => 22
            ));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                       pushNotification(array(
                            'subject' => 'Auto Production Plan deleted',
                            'message' => 'Auto Production Plan id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                            'from_id' => $_SESSION['loggedInUser']->u_id,
                            'to_id' => $userViewPermission['user_id'],
                            'ref_id' => $id,
                            'icon' => 'fa fa-archive'
                        ));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                 pushNotification(array(
                    'subject' => 'Auto Production Plan deleted',
                    'message' => 'Auto Production Plan id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name,
                    'from_id' => $_SESSION['loggedInUser']->u_id,
                    'to_id' => $_SESSION['loggedInCompany']->u_id,
                    'ref_id' => $id,
                    'icon' => 'fa fa-archive'
                ));
            }
            $this->session->set_flashdata('message', 'Auto Production Plan Deleted Successfully');
            $result = array(
                'msg' => 'Auto Production Plan Deleted Successfully',
                'status' => 'success',
                'code' => 'C142',
                'url' => base_url() . 'production/auto_production_plan'
            );
            echo json_encode($result);
        } else {
            echo json_encode(array(
                'msg' => 'error',
                'status' => 'error',
                'code' => 'C1004'
            ));
        }
    }

    public function auto_plan_qualitychk()
    {
        $id                               = $this->uri->segment(3);
        $data['production_planning_data'] = $this->production_model->get_data_byId('auto_production_plan', 'id', $id);
        $val                              = json_decode($data['production_planning_data']->planning_data, true);
        $count                            = count($val);
        foreach ($val as $data1) {
            for ($i = 0; $i < $count; $i++) {
                if ($data1['work_order'][$i] != '') {
                    $data['workorder_id']   = $data1['work_order'][$i];
                    $data['report_name']    = $data['production_planning_data']->id;
                    $data['final_report']   = 1;
                    $job_nam                = getNameById('job_card', $data1['job_card_product_id'][$i], 'id');
                    $data['job_card']       = $job_nam->job_card_no;
                    $data['process_id']     = $data1['process_name'][$i];
                    $data['created_by']     = $_SESSION['loggedInUser']->id;
                    $data['created_by_cid'] = $this->companyId;
                    $data['created_date']   = date("Y-m-d H:i:s");
                    $this->production_model->insert_tbl_data('inspection_report_master', $data);
                }
            }
        }
        $this->production_model->updateRowWhere('auto_production_plan', array(
            'id' => $id
        ), array(
            'quality_check' => 1
        ));
        $this->session->set_flashdata('message', 'Added to Quality Check successfully');
        redirect(base_url() . 'production/auto_production_plan', 'refresh');
    }

    /* convert to  production plan from auto production planning */
   public function auto_convert_to_production()
    {
       $this->breadcrumb->add('Auto Production Planning', base_url() . 'auto_production_plan');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Auto Production Planning';
        $id = $_GET['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->breadcrumb->add('Production', base_url() . 'production/auto_production_plan');
        $this->breadcrumb->add($id ? 'Edit' : 'Add', base_url() . 'auto_production_plan/' . $id ? 'Edit' : 'Add');
        $this->settings['breadcrumbs']   = $this->breadcrumb->output();
        $this->settings['pageTitle']     = $id ? 'Auto Production planning' : 'Production planning Add';
        #$where = array('production_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where                           = array(
            'production_setting.created_by_cid' => $this->companyId
        );
        $this->data['productionSetting'] = $this->production_model->get_data('production_setting', $where);
        $machineWhere                    = array(
            'add_machine.created_by_cid' => $this->companyId,
            'add_machine.save_status' => 1
        );
        $this->data['machineName']       = $this->production_model->get_data('add_machine', $machineWhere);
        $this->data['production_plan']   = $this->production_model->get_data_byId('auto_production_plan', 'id', $id);
        $this->_render_template('auto_production_plan/convert_to_prod_plan', $this->data);
    }

    public function uploaddocsByAjax() {
        if (isset($_POST["image"])) {
            $data = $_POST["image"];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $exp = explode('.', $_POST["uploaded_image_name"]);
            $imageName = $exp[0] . 'Job' . time() . "." . $exp[1];
            file_put_contents('assets/modules/production/uploads/' . $imageName, $data);
            $result = array('image' => $imageName);
            echo json_encode($result);
        }
    }


public function getinputMatDataById()
{
$send_html = '<div class=" col-md-12 well_Sech_input" style="padding: 0px;margin-bottom: 0;"><div class="col-md-12 input_cls chk_idd_input" id="sechIndexinput_'.$j.'" style="padding:0px;"><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label class="col col-md-12 col-xs-12 col-sm-12">Material Type</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 material_type" name="material_type_input_id['.$j.']" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid='.$_SESSION['loggedInUser']->c_id.' OR created_by_cid=0" onchange="getMaterialName(event,this)" ><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label class="col col-md-12 col-xs-12 col-sm-12">Material Name</label><select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot material_input_name_1" name="material_input_name[1]" id="material_input_name_1" onchange="getUom_input(event,this);"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label class="col col-md-12 col-xs-12 col-sm-12">Quantity</label><input type="text" name="quantity_input[1]" id="quantity_input_1" class="form-control col-md-7 col-xs-12  qty_input actual_qty quantity_input_1" placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"> </div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col col-md-12 col-xs-12 col-sm-12">UOM</label><input type="text" name="uom_value_input1[1]" id="uom_value_input1_1" class="form-control col-md-7 col-xs-12  uom_input uom_value_input1_1" placeholder="uom." value="" readonly><input type="hidden" name="uom_value_input[1]" id="uom_value_input_1" class="uom_input_val uom_value_input_1" readonly value=""> </div><div class="col-md-1 col-xs-12 col-sm-12 form-group" style="text-align: center;border-bottom: 1px solid #aaa;"><label class="col col-md-12 col-xs-12 col-sm-12" style="padding: 17px 6px;"></label><button class="btn edit-end-btn  add_moreinputss" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button></div></div></div>'; 
echo $send_html;
}
public function getwojcDataById()
    {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        if (isset($_REQUEST) && !empty($_REQUEST) && (isset($_REQUEST['id']) && $_REQUEST['id'] != '')) {
            $id       = $_REQUEST['id'];
            $num_row       = $_REQUEST['num_row']+1;
            $lot       = $_REQUEST['lot'];
            $wo_exqty       = $_REQUEST['wo_exqty'];
            if(!empty($_REQUEST['wo_parent'])){
            $wo_parent = $_REQUEST['wo_parent'];
            } else {
            $wo_parent = '';
            }
            $wo_id       = $_REQUEST['wo_id'];
            $jobkey       = $_REQUEST['jobkey'];
            $transfer_quantity       = $_REQUEST['transfer_quantity'];
            $fst_qty       = $_REQUEST['fst_qty'];
            $material_qty       = $_REQUEST['material_qty'];
            $job_card = $this->production_model->get_data_byId('job_card', 'job_card_no', $id);
            $jobCardMaterialss = json_decode($job_card->material_details, true);
               $res_detail_array="";
               $i =$num_row; 
               $j=1;
                         foreach ($jobCardMaterialss as $key => $materialInfo) {
                    $lot_qty_setjc = $job_card->lot_qty;
                    $quantity_setjc = $materialInfo['quantity'];
                    $quantity_required = round($fst_qty*($quantity_setjc/$lot_qty_setjc),4);
                    $newQuantityValuert = ($job_card->lot_qty != 0 ) ? $materialInfo['quantity'] / $job_card->lot_qty : 0;
                        $newQuantityValue= $newQuantityValuert * $transfer_quantity;
                        $expectedQuantity = ( $newQuantityValue > 0) ? $materialInfo['quantity'] * $newQuantityValue : $materialInfo['quantity'];
                          $where = "reserved_material.mayerial_id = '".$materialInfo['material_name_id']."' AND reserved_material.created_by_cid ='".$this->companyId."' AND reserved_material.work_order_id ='".$wo_id."' AND reserved_material.job_card_id =".$jobkey;
                        $reservedData = $this->production_model->get_data_single('reserved_material', $where);
                        $reserved_quantitym = $reservedData ? $reservedData['quantity'] : 0;
                        $yu = getNameById_mat('mat_locations',$materialInfo['material_name_id'],'material_name_id');
                        $sum = 0;
                        if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                                $unit = $materialInfo['unit'];
                           // $quantity_required = round($newQuantityValue,2);
                             $reserved_quantity = $reserved_quantitym;
                             $available_quantity = $sum - $reserved_quantitym;
                             //pre($materialInfo12['Pending_quantity']);
          $materialName     = getNameById('material',$materialInfo['material_name_id'],'id');
           $productDetails   = getNameById('material_type',$materialInfo['material_type_id'],'id');
          $quantity_order   = getNameById('purchase_indent',$wo_id,'work_order_id');
            $materiyalData  = json_decode($quantity_order->material_name??'',true);
          $sale_order_product_id = getNameById('material', $jobkey, 'job_card');
        if($quantity_required < $available_quantity){
        $material_shortage = '0';
        } else if($quantity_required >= $available_quantity) {
        $material_shortage = $quantity_required - $available_quantity;
        }

          if($j==1){
              //$class_set = 'edit-row1 firstIndex';
            $class_set = 'scend-tr mobile-view';
              $style_set = 'display:block!important;';
             } else{
             $class_set = 'scend-tr mobile-view';
              $style_set = '';
             }
        $span_html = '';
        for ($woi=1; $woi <= $wo_exqty; $woi++) { 
        $span_html .= '<span class="k-icon k-i-none"></span>';
        }
        $next_wo_exqty = $wo_exqty+1;
        $send_html = '<tr class="wo_well appended_trs '.$wo_parent.'" id="wochkIndex_'.$i.'" style="border-top: 1px solid #c1c1c1 !important; background-color: rgba(0,0,0,.04);">';
        $indent_array = $materialInfo['material_type_id'].'~'.$materialInfo['material_name_id'].'~'.$wo_id.'~'.$jobkey.'~'.$material_shortage;
        $res_detail_array = $materialInfo['material_type_id'].'~'.$materialInfo['material_name_id'].'~'.$wo_id.'~'.$jobkey.'~'.$sale_order_product_id->id.'~'.$quantity_required.'~'.$available_quantity.'~'.$reserved_quantity;
        if($quantity_required > $available_quantity  && $materialName->job_card==0 ) {
        $send_html .= '<td>
               <input type="checkbox" class="indent_create" value="'.$indent_array.'" checked></td>';
        } else {
		$send_html .= '<td></td>';
		}
        $send_html .= '<td><div style="display: flex;">'.$span_html.'';
         if(!empty($materialName)){ $material_name = $materialName->material_name; }else{$material_name =  "N/A";}
        $send_html .= '<div class="expand_dropwon form-group">';
        $material_data = getNameById('material', $materialInfo['material_name_id'],'id');
         $job_data = getNameById('job_card', $material_data->job_card,'id');
       if(!empty($material_data) && $material_data->job_card!=0 && !empty($job_data)){
        $send_html .= '<span class="up_arrow" style="display: none;"><i style="font-size: 20px;font-weight: bold;"  onclick="expandWoBom(event,this);" wo_exqty="'.$next_wo_exqty.'" jc_number="'.$job_data->job_card_no.'" lot_qty="'.$job_data->lot_qty.'" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span><span class="down_arrow"><i onclick="expandWoBom(event,this);" wo_exqty="'.$next_wo_exqty.'" jc_number="'.$job_data->job_card_no.'" lot_qty="'.$job_data->lot_qty.'" wo_id="'.$wo_id.'" jobkey="'.$job_data->id.'" transfer_quantity="'.$transfer_quantity.'" fst_qty="'.$quantity_required.'" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span>';
        } else { 
       $send_html .= '<span class="up_arrow" style="display: none;"><i style="font-size: 20px;font-weight: bold;"  onclick="expandWoBom(event,this);" wo_exqty="1" jc_number="" lot_qty=""  wo_id="" jobkey="" transfer_quantity="" fst_qty="" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span><span class="down_arrow" style="display: none;"><i onclick="expandWoBom(event,this);" wo_exqty="1" jc_number="" lot_qty="" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span>';
        }
        $send_html .= '</div>'.$material_name.'</div></td>
               <td>';
       
		if(!empty($productDetails)){ $product_name = $productDetails->name; }else{ $product_name =  "N/A";}
        $send_html .= ''.$product_name.'</td>
               <td class="__availableQuantity">
               <span class="material_qty_wochkIndex_'.$i.'">'.$available_quantity.'</span>
               </td>
               <td class="__uom ">';
        $ww =  getNameById('uom', $materialName->uom,'id');
        $uom = !empty($ww)?$ww->uom_quantity:'N/A';
        $send_html .= ''.$uom.'</td>
               <td class="__quantityRequired">'.$quantity_required.'</td>';
               if($quantity_required < $available_quantity){
               $material_shortage = '0';
               } else if($quantity_required >= $available_quantity) {
               $material_shortage = $quantity_required - $available_quantity;
               }
               $send_html .= '<td>'.$material_shortage.'</td><td>'.$reserved_quantity.'</td>
                <td>
               <a id="'.$res_detail_array.'" data-toggle="modal" data-id="material_availability_page" data-title="Reserve Material" data-tooltip="Reserved" class="btn btn-view btn-xs productionTab reservedPopup"><i class="fa fa-plus"></i></a> <a id="'.$res_detail_array.'" data-toggle="modal" data-id="material_availability_page" data-title="Unreserve Material" data-tooltip="UnReserved" class="btn btn-view btn-xs productionTab reservedPopup"><i class="fa fa-minus"></i></a>
              </td>
               <td>';
             if(!empty($materialName) && $materialName->job_card==0){
              $job_card_no = "N/A";
               } else { $job_data = getNameById('job_card', $materialName->job_card,'id'); $job_card_no = $job_data->job_card_no; }
        $send_html .= ''.$job_card_no.'</td>
               <td>
               <select name="action" class="action_materials form-control" style="border-left: none!important;border-bottom: none!important;background-color: transparent;color: #73879C;">';
               if($quantity_required > $available_quantity){
                $send_html .= '<option selected>Not Available</option>';
                } else if($available_quantity >= $quantity_required){
                $send_html .= '<option selected>In Stock</option>';
                } else if($reserved_quantity == $quantity_required){
                $send_html .= '<option selected>Reserved</option>';
                }
                $send_html .= '</select>
               </td>
               <td>';
                if($quantity_required > $available_quantity  && $materialName->job_card==0 ) {
                $send_html .= '<span>Create Indent</span>';
                }elseif($quantity_required > $available_quantity  && $materialName->job_card!=0) {
                $send_html .= '<span>Initiate Work Order</span>';
                }elseif($available_quantity > $quantity_required || $reserved_quantity == $quantity_required) {
                $send_html .= '<span>Issue material</span>';
                } 
               $send_html .= '</td>
            
            </tr>';

        $i++; $j++;
        echo $send_html;
        }

    }
    }

    public function indent_edit($id='') {

    $where='';
    if ($this->uri->segment(3)) {
       $id=  $this->uri->segment(3);
        $where .="id='{$id}'";
     }else{
        $id = $_POST['id'];
        $data_set = $_POST['data_set'];
        $where .="id='{$id}'";
     }
        $workorder  = $this->production_model->get_worker_data('work_order',$where);
         $proDetail=  json_decode($workorder[0]['product_detail']);

           $job_card =[];
          foreach ($proDetail as  $revalue) {
              // $jobcard[] =$revalue->job_card;
                $where="'{$revalue->job_card}'";
                $jobCardDetails         =  $this->production_model->get_worker_dataIN('job_card','job_card_no',$where);
                $job_card[$jobCardDetails[0]['id']]= $jobCardDetails;
                $job_card[$jobCardDetails[0]['id']]['transfer_quantity']  = $revalue->transfer_quantity;
                $job_card[$jobCardDetails[0]['id']]['jobid']  = $jobCardDetails[0]['id'];
              // $job_card[$jobCardDetails[0]['id']]['jobid']  =  $job_ids;
          }
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
       $this->data['JobCard']=$job_card;
       $this->data['data_set']=$data_set;

        $this->data['work_order_id']=$_POST['id'];
        if ($this->uri->segment(3)) {
        $this->_render_template('work_order/work_order_Purchase', $this->data);

        }else{
        $this->load->view('work_order/work_order_Purchase', $this->data);
    }
    }

    public function saveIndent() {
        $approved = "";
        $work_order_id=$_POST['sale_order_id'];
        $successss = $this->purchase_model->update_data('work_order', ['work_order_material_status' => '3' ], 'id', $work_order_id);

        if( count($_POST['material_type_id'] ) > 0 ){
            if($this->purchase_model->checkApprovematerial($_POST['material_type_id'])){
                 $approved = 1;
            }
        }
        $material_count = count($_POST['material_name']);
        if ($material_count > 0 && $_POST['material_name'][0] != '') {
            $arr = [];
            $i = 0;
            while ($i < $material_count) {

                $str_descr = '""'.$_POST['description'][$i].'""';
                $str_descr = str_replace('"', '', $str_descr);
                $jsonArrayObject = (array('material_type_id' => $_POST['material_type_id'][$i],'material_name_id' => $_POST['material_name'][$i], 'description' => $str_descr, 'quantity' => $_POST['quantity'][$i], 'uom' => $_POST['uom'][$i], 'expected_amount' => $_POST['price'][$i], 'purpose' => $_POST['purpose'][$i], 'sub_total' => $_POST['total'][$i], 'remaning_qty' => $_POST['quantity'][$i]));
                $arr[$i] = $jsonArrayObject;
                $i++;
            }
            //remaning_qty ==> if remaning_qty is 0 means its complete PI
            $material_array = json_encode($arr);
        } else {
            $material_array = '';
        }

        if ($this->input->post()) {
            $required_fields = array('required_date','material_type_id', 'material_name');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $materialUpdateIds = implode("','", $data['material_name']);
                $materialUpdateIds = "'" . $materialUpdateIds . "'";

                $materialtypeUpdateIds = implode("','", $data['material_type_id']);
                $materialtypeUpdateIds = "'" . $materialtypeUpdateIds . "'";
                $data['material_name'] = $material_array;
                $data['created_by_cid'] = $this->companyId;
                $id = $data['id'];
                $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    if( !empty($approved) ){
                        $data = $data + ['approve' => 1];
                    }
                    $success = $this->purchase_model->update_data('purchase_indent', $data, 'id', $id);
                    if ($success) {
                        if ($materialtypeUpdateIds != "''") updateMultipleUsedIdStatus('material_type', $materialtypeUpdateIds);
                        if ($materialUpdateIds != "''") updateMultipleUsedIdStatus('material', $materialUpdateIds);
                        if ($data['preffered_supplier'] != "") updateUsedIdStatus('supplier', $data['preffered_supplier']);
                        $data['message'] = "Purchase indent updated successfully";
                        logActivity('purchase indent Updated', 'purchase_indent', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'Purchase indent updated', 'message' => 'Purchase indent id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'indentView', 'icon' => 'fa-shopping-cart'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'Purchase indent updated', 'message' => 'Purchase indent id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'indentView', 'icon' => 'fa-shopping-cart'));
                        }
                        $this->session->set_flashdata('message', 'Purchase indent Updated successfully');

                    }
                } else {
                    $work_order_id=$_POST['work_order_id'];
        $successss = $this->purchase_model->update_data('work_order',['work_order_material_status' => '3' ], 'id', $work_order_id);

                    if( !empty($approved) ){
                        $data = array_merge($data,['approve' => 1]);
                    }
                    $id = $this->purchase_model->insert_tbl_data('purchase_indent', $data);
                    if ($id) {
                        if (!empty($arr)) {
                            foreach ($arr as $res) {
                                $this->purchase_model->update_single_value_data('material', array('cost_price' => $res['expected_amount']), array('id' => $res['material_name_id'], 'created_by_cid' => $this->companyId));
                            }
                        }
                       if ($materialtypeUpdateIds != "''") updateMultipleUsedIdStatus('material_type', $materialtypeUpdateIds);
                        if ($materialUpdateIds != "''") updateMultipleUsedIdStatus('material', $materialUpdateIds);
                        if ($data['preffered_supplier'] != "") updateUsedIdStatus('supplier', $data['preffered_supplier']);
                        logActivity('Purchase indent inserted', 'purchase_indent', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'New purchase indent created', 'message' => 'New purchase indent is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'indentView', 'icon' => 'fa-shopping-cart'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'New purchase indent created', 'message' => 'New purchase indent is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'indentView', 'icon' => 'fa-shopping-cart'));
                        }
                        $this->session->set_flashdata('message', 'Purchase indent inserted successfully');

                    }
                }

                if ($id) {

                    if (!empty($_FILES['docss']['name']) && $_FILES['docss']['name'][0] != '') {
                        $proof_array = array();
                        $proofCount = count($_FILES['docss']['name']);
                        for ($i = 0;$i < $proofCount;$i++) {
                            $filename = $_FILES['docss']['name'][$i];
                            $tmpname = $_FILES['docss']['tmp_name'][$i];
                            $type = $_FILES['docss']['type'][$i];
                            $error = $_FILES['docss']['error'][$i];
                            $size = $_FILES['docss']['size'][$i];
                            $exp = explode('.', $filename);
                            $ext = end($exp);
                            $newname = $exp[0] . '_' . time() . "." . $ext;
                            $config['upload_path'] = 'assets/modules/purchase/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/purchase/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico|pdf|docs";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/purchase/uploads/" . $newname);
                            $proof_array[$i]['rel_id'] = $id;
                            $proof_array[$i]['rel_type'] = 'PI_PO_MRN';
                            $proof_array[$i]['file_name'] = $newname;
                            $proof_array[$i]['file_type'] = $type;
                        }
                        if (!empty($proof_array)) {

                            $proofId = $this->inventory_model->insert_attachment_data('attachments', $proof_array, 'PI_PO_MRN');
                        }
                    }
                }
                redirect(base_url() . 'production/work_order', 'refresh');
            }
        }
    }

    public function machineAvailability()
    {
     $expload_ids = explode('~~', $_POST['id']);
     $mc_detail_array = array(
    'job_card_id' => $expload_ids['0'],
    'process_name' => $expload_ids['1'],
    'process_id' => $expload_ids['2'],
    'machnine_nams' => $expload_ids['3'],
    'machnine_ids' => $expload_ids['4'],
    'department_id' => $expload_ids['5'],
    'compny_id' => $expload_ids['6'],
    'req_output' => $expload_ids['7'],
    'wo_name' => $expload_ids['8'],
    'wo_id' => $expload_ids['9'],
    'jc_name' => $expload_ids['10'],
    'material_name' => $expload_ids['11'],
    'material_id' => $expload_ids['12'],
    'machnine_grp_id' => $expload_ids['13'],
    'output' => $expload_ids['14'],
    'shift_duration' => $expload_ids['15'],
    'remain_qty' => $expload_ids['16'],
    );
     $this->data['mca_data'] = $mc_detail_array;
     $this->load->view('auto_production_plan/machine_availability', $this->data);
    }


    public function chkShiftData()
    {
    $department_id = $_POST['id'];
    $company_id = $_POST['company_id'];
    $where = array(
    'production_setting.created_by_cid' => $this->companyId,
    'production_setting.company_unit' => $department_id,
    'production_setting.department' => $company_id
    );
    $where = "production_setting.created_by_cid = '".$this->companyId."' AND production_setting.company_unit ='".$company_id."' AND production_setting.department =".$department_id;
    $shift_data = $this->production_model->get_data_single('production_setting', $where);
    if(!empty($shift_data)){
    echo "true";
    } else {
    echo "false";
    }
    }
    
    public function autoReserveMaterial(){
    $expload_ids = explode('~', $_POST['id']);
    $data = array(
    'material_type' => $expload_ids['0'],
    'mayerial_id' => $expload_ids['1'],
    'work_order_id' => $expload_ids['2'],
    'job_card_id' => $expload_ids['3'],
    'saleorder_product' => $expload_ids['4'],
    'quantity' => $expload_ids['5'],
    'available_quantity' => $expload_ids['6'],
    'reserved_quantity' => $expload_ids['7'],
    );
    $data['created_by']     = $_SESSION['loggedInUser']->id;
    $data['created_by_cid'] = $this->companyId;
    $where = "reserved_material.material_type = '".$data['material_type']."' AND reserved_material.mayerial_id = '".$data['mayerial_id']."' AND reserved_material.created_by_cid ='".$this->companyId."' AND reserved_material.work_order_id ='".$data['work_order_id']."' AND reserved_material.job_card_id =".$data['job_card_id'];
    $get_data = $this->production_model->get_data_single('reserved_material', $where);
    if($data['available_quantity'] != 0 && $data['available_quantity'] >= $data['quantity']){
    if(empty($get_data)){
    $data['unreserve_qty'] = '0'-$data['quantity'];
    $data['quantity']= '0'+$data['quantity'];
    $data['available_quantity']= $data['available_quantity']-$data['quantity'];
    $addData = $this->production_model->insert_tbl_data('reserved_material',$data);
    } else {
    $data['unreserve_qty'] = $get_data['unreserve_qty']-$data['quantity'];
    $data['quantity']=$get_data['quantity']+$data['quantity'];
    $data['available_quantity']= $data['available_quantity']-$data['quantity'];
    $addData = $this->production_model->update_data_res('reserved_material', $data, $where);
    }
    }
    echo $data['quantity'];
    }
    
}//main
