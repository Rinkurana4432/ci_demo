<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Maintenance extends ERP_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->library(array(
            'form_validation'
        ));
        $this->load->helper('maintenance/maintanence');
        $this->load->model('maintenance_model');
        $this->settings['css'][] = 'assets/plugins/google-code-prettify/bin/prettify.min.css';
        $this->settings['css'][] = 'assets/modules/maintenance/css/style.css';
        $this->scripts['js'][]   = 'assets/plugins/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js';
        $this->scripts['js'][]   = 'assets/plugins/jquery.hotkeys/jquery.hotkeys.js';
        $this->scripts['js'][]   = 'assets/plugins/google-code-prettify/src/prettify.js';
        $this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
        $this->scripts['js'][]   = 'assets/plugins/switchery/dist/switchery.min.js';
        # for Graph
        $this->scripts['js'][]   = 'assets/plugins/fastclick/lib/fastclick.js';
        $this->scripts['js'][]   = 'assets/plugins/nprogress/nprogress.js';
        $this->scripts['js'][]   = 'assets/plugins/raphael/raphael.min.js';
        $this->scripts['js'][]   = 'assets/plugins/morris.js/morris.min.js';
        $this->scripts['js'][]   = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->scripts['js'][]   = 'assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js';
        $this->scripts['js'][]   = 'assets/modules/maintenance/js/script.js';
       // $this->scripts['js'][]   = 'assets/modules/maintenance/js/scriptpurchase.js';
        $this->load->library('CSVReader'); //load PHPExcel library 
        //$this->load->model('upload_model');//To Upload file in a directory
        $this->load->model('maintenance_model');
        
        
        $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
        
        $this->companyId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
        
        
    }
    
    public function index()
    {
        
        
    }
    
    public function dashboard()
    {
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->breadcrumb->add('Maintenance', base_url() . 'dashboard');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Dashboard';
        $this->data['user_dashboard']  = $this->maintenance_model->get_data_dashboard('user_dashboard');
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
        $getBreakDownTargetVSActualListingGraph = getBreakDownTargetVSActualListingGraph($startDate, $endDate);
        $getBreakDownPurchanseGraph = getBreakDownPurchanseGraph($startDate, $endDate);
        //re($getPoductionDataListingGraph);
        $getProductionPlanning        = getProductionPlanning($startDate, $endDate);
        //$getComparison = getComparison($startDate, $endDate);
        
        $getDashboardCount = getDashboardCount($startDate, $endDate);
        $graphDashboardArray = array(
           // 'getProductionPlanning' => $getProductionPlanning,
            'getDashboardCount' => $getDashboardCount,
			'getBreakDownTargetVSActualListingGraph' => $getBreakDownTargetVSActualListingGraph,
			'getBreakDownPurchanseGraph' => $getBreakDownPurchanseGraph,

        );
        
        //pre($graphDashboardArray);die;
        
        
        echo json_encode($graphDashboardArray);
    }
    
    
    
    
    /*breakdown data list*/
    
    public function breakdown()
    {
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->breadcrumb->add('Maintenance', base_url() . 'maintenance');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Breakdown Maintenance List';
        
        $where         = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $where         = "add_bd_request.machine_name like'%" . $search_string . "%' or add_bd_request.machine_type like'%" . $search_string . "%' or add_bd_request.id like'%" . $search_string . "%'";
        }
        
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
            
        } else {
            $order = "desc";
        }
        
        $array                        = array();
        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "production/process/";
        $config["total_rows"]         = $this->maintenance_model->num_rows('process_type', array(
            'created_by_cid' => $this->companyId
        ), $where);
        $config["per_page"]           = 100;
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
            
            #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'add_machine.favourite_sts' => 1);
            $where                        = array(
                'add_bd_request.created_by_cid' => $this->companyId,
                'add_bd_request.favourite_sts' => 1,
                'request_status' => 0
            );
            #$where = array('add_machine.created_by_cid' => (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id , 'add_machine.favourite_sts' => 1);
            $this->data['user_breakdown'] = $this->maintenance_model->get_data_breakdown('add_bd_request', $where, $config["per_page"], $page);
            $this->_render_template('addmaintenance/index', $this->data);
            
        } else {
            
            
            if (isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
                
                $where = array(
                    'created_by_cid' => $this->companyId
                );
                
                $this->data['user_breakdown'] = $this->maintenance_model->get_data_breakdown('add_bd_request', $where, $config["per_page"], $page);
                $this->_render_template('addmaintenance/index', $this->data);
            }
            
            if (!empty($_POST['search'])) {
                $search_string                = $_POST['search'];
                $where                        = "add_bd_request.machine_name like'%" . $search_string . "%' or add_bd_request.machine_type like'%" . $search_string . "%' or add_bd_request.id like'%" . $search_string . "%'";
                $this->data['user_breakdown'] = $this->maintenance_model->get_data_breakdown('add_bd_request', $where, $config["per_page"], $page);
                $this->_render_template('addmaintenance/index', $this->data);
            }
            
            if (!empty($_POST['start'])) {
                #
                $where                        = array(
                    'add_bd_request.created_date >=' => $_POST['start'],
                    'add_bd_request.created_date <=' => $_POST['end'],
                    'add_bd_request.created_by_cid' => $this->companyId
                );
                $this->data['user_breakdown'] = $this->maintenance_model->get_data_breakdown('add_bd_request', $where, $config["per_page"], $page);
                $this->_render_template('addmaintenance/index', $this->data);
                
            } else {
                
                $where                        = array(
                    'created_by_cid' => $this->companyId,
                    'request_status' => 0
                );
                $this->data['user_breakdown'] = $this->maintenance_model->get_data_breakdown('add_bd_request', $where, $config["per_page"]);
                //$this->_render_template('addmaintenance/index', $this->data);
                
                if (isset($_POST['favourites'])) {
                    #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'add_machine.favourite_sts' => 1);
                    $where                                 = array(
                        'add_bd_request.created_by_cid' => $this->companyId,
                        'add_bd_request.favourite_sts' => 1,
                        'request_status' => 1
                    );
                    #$where = array('add_machine.created_by_cid' => (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id , 'add_machine.favourite_sts' => 1);
                    //$where = array('created_by_cid' => $this->companyId, 'request_status' =>1);
                    $this->data['user_breakdown_complete'] = $this->maintenance_model->get_data_breakdown('add_bd_request', $where, $config["per_page"]);
                    $this->_render_template('addmaintenance/index', $this->data);
                } else {
                    $where                                 = array(
                        'created_by_cid' => $this->companyId,
                        'request_status' => 1
                    );
                    $this->data['user_breakdown_complete'] = $this->maintenance_model->get_data_breakdown('add_bd_request', $where, $config["per_page"]);
					//pre($this->data);die;
                    $this->_render_template('addmaintenance/index', $this->data);
                    
                }

            }
            
        }
        
    }
    
    
    
    
    /*add mantance*/
    public function addmaintenance()
    {
        
        $this->data['machinename']    = $this->maintenance_model->get_machine_data('add_machine', array(
            'created_by' => $_SESSION['loggedInUser']->id
        ));
        $this->data['user_breakdown'] = $this->maintenance_model->get_data_breakdown('add_bd_request', array(
            'created_by' => $_SESSION['loggedInUser']->id
        ));
        $this->load->view('addmaintenance/addmaintenance', $this->data);
    }
    
    /* simoller data  */
    public function addsimiller()
    {
        $this->data['machinename']    = $this->maintenance_model->get_machine_data('add_machine', array(
            'created_by' => $_SESSION['loggedInUser']->id
        ));
        $this->data['addsimilerdata'] = $this->maintenance_model->get_data_byId('add_bd_request', 'id', $this->input->post('id'));
        $this->load->view('addmaintenance/addsimiller', $this->data);
    }
    
    
    
    
    public function savebreakdown()
    {
        $data                   = $this->input->post();
        $data['created_by']     = $_SESSION['loggedInUser']->u_id;
        $data['created_by_cid'] = $this->companyGroupId;
        $data['created_date']   = date('Y-m-d h:i:s');
        $data['work_status']    = 1;
        $insertdata             = $this->maintenance_model->insert_bd_data('add_bd_request', $data);
        
        if ($insertdata == true) {
            $this->session->set_flashdata('message', 'Breakdown Request inserted successfully');
            redirect(base_url() . 'maintenance/breakdown', 'refresh');
        } else {
            
            $this->session->set_flashdata('error', 'Breakdown Request Not inserted successfully');
            redirect(base_url() . 'maintenance/breakdown', 'refresh');
            
        }
        
    }
    
    public function editmaintenance()
    {
        
        $this->data['machinename'] = $this->maintenance_model->get_machine_data('add_machine', array(
            'created_by' => $_SESSION['loggedInUser']->id
        ));
        
        $this->data['editbddata'] = $this->maintenance_model->get_data_byId('add_bd_request', 'id', $this->input->post('id'));
        
        $this->data['user_breakdown'] = $this->maintenance_model->get_data_breakdown('add_bd_request', array(
            'created_by' => $_SESSION['loggedInUser']->id
        ));
        
        $this->load->view('addmaintenance/editmaintenance', $this->data);
    }
    
    
    
    /*Breakdown Complete*/
    public function complete()
    {
        
        
        $this->data['viewbreakdowncom'] = $this->maintenance_model->get_data_byId('add_bd_request', 'id', $this->input->post('id'));
        $this->data['user_breakdown']   = $this->maintenance_model->get_data_breakdown('add_bd_request', array(
            'created_by' => $_SESSION['loggedInUser']->id
        ));
        $this->load->view('addmaintenance/complete', $this->data);
    }
    
    
    public function completeview()
    {
        
        
        $this->data['viewbreakdown']  = $this->maintenance_model->get_data_byId('add_bd_request', 'id', $this->input->post('id'));
        $this->data['user_breakdown'] = $this->maintenance_model->get_data_breakdown('add_bd_request', array(
            'created_by' => $_SESSION['loggedInUser']->id
        ));
        $this->load->view('addmaintenance/completeview', $this->data);
    }
    
    public function updatebreakdown()
    {
        
        $id                     = $this->input->post('id');
        $data                   = $this->input->post();
        $data['created_by']     = $_SESSION['loggedInUser']->u_id;
        $data['created_by_cid'] = $this->companyGroupId;
        $data['created_date']   = date('Y-m-d h:i:s');
        $data['work_status']    = 1;
        if ($id != '') {
            
            //$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
            $success = $this->maintenance_model->update_bd_data('add_bd_request', $data, 'id', $id);
            
            if ($success) {
                
                $this->session->set_flashdata('message', 'Breakdown Request Updated successfully');
                redirect(base_url() . 'maintenance/breakdown', 'refresh');
                
            } else {
                
                $this->session->set_flashdata('error', 'Breakdown Request Not Updated successfully');
                redirect(base_url() . 'maintenance/breakdown', 'refresh');
                
            }
        }
        
    }
    
    
    public function viewmaintenance()
    {
        
        $this->data['viewbreakdown'] = $this->maintenance_model->get_data_byId('add_bd_request', 'id', $this->input->post('id'));
        $this->load->view('addmaintenance/viewmaintenance', $this->data);
        
        if ($this->input->post('id') != '') {
            permissions_redirect('is_view');
        }
        
    }
    
    
    public function deletemaintenance($id = '')
    {
        if (!$id) {
            redirect('maintenance/breakdown', 'refresh');
        }
        //permissions_redirect('is_delete');
        $result = $this->maintenance_model->delete_bd_data('add_bd_request', 'id', $id);
        if ($result) {
            
            $this->session->set_flashdata('message', 'Breakdown Request Delete successfully');
            redirect(base_url() . 'maintenance/breakdown', 'refresh');
            
        } else {
            
            $this->session->set_flashdata('error', 'Breakdown Request Not Delete successfully');
            redirect(base_url() . 'maintenance/breakdown', 'refresh');
            
        }
        
    }
    
    
    
    /*add aknowledge*/
    public function aknowledge()
    {
        
        $this->data['viewbreakdown']  = $this->maintenance_model->get_data_byId('add_bd_request', 'id', $this->input->post('id'));
        $this->data['user_breakdown'] = $this->maintenance_model->get_data_breakdown('add_bd_request', array(
            'created_by' => $_SESSION['loggedInUser']->id
        ));
        $this->data['get_worker']     = $this->maintenance_model->get_worker_data('worker', array(
            'department' => 'maintenance'
        ));
        $this->load->view('addmaintenance/aknowledge', $this->data);
    }
    
    public function updateaknowledge()
    {
        
        $id                     = $this->input->post('id');
        //$acknowledgedate  = date_create($this->input->post('acknowledge'));
        //$acknowledge = date("Y-m-d", $this->input->post('acknowledge'));
        $data                   = $this->input->post();
        $data['created_by']     = $_SESSION['loggedInUser']->u_id;
        $data['created_by_cid'] = $this->companyGroupId;
        //$data['acknowledge'] = date("Y-m-d", $this->input->post('acknowledge'));
        
        if ($id != '') {
            
            //$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
            $success = $this->maintenance_model->update_bd_data('add_bd_request', $data, 'id', $id);
            
            if ($success) {
            #    pre($data);die;
                $this->session->set_flashdata('message', 'Acknowledge Date Updated successfully');
                redirect(base_url() . 'maintenance/breakdown', 'refresh');
                
            } else {
                
                $this->session->set_flashdata('error', 'Acknowledge Date Not Updated successfully');
                redirect(base_url() . 'maintenance/breakdown', 'refresh');
                
            }
        }
        
    }
    
    
    /*add purchese*/
    public function purchase()
    {
        
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        
        
        $data_get_for_docss = array(
            'purchase_indent.id' => $id,
            'purchase_indent.save_status' => 1
        );
        
        $docs_data = $this->maintenance_model->get_data('purchase_indent', $data_get_for_docss);
        
        
        //if($docs_data[0]['pi_id'] != 0){
        
        //	$this->data[0]['docss']  = $this->maintenance_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id',$docs_data['pi_id']);//For Document Attachment fetch
        //}else{
        
        //$this->data['docss']  = $this->maintenance_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id',$id);//For Document Attachment fetch
        //}
        $this->data['purchasbreakdown'] = $this->maintenance_model->get_data_byId('add_bd_request', 'id', $this->input->post('id'));
        $this->data['suppliername']     = $this->maintenance_model->get_data('supplier');
        $this->data['materialType']     = $this->maintenance_model->get_data('material_type');
        $this->data['indents']          = $this->maintenance_model->get_data_byId('purchase_indent', 'id', $id);
        if (!empty($this->data['indents']))
            $this->data['materials'] = $this->maintenance_model->get_tbl_data_byId('material', 'material_type_id', $this->data['indents']->material_type_id);
        $this->load->view('addmaintenance/purchase', $this->data);
    }
    
    
    /*fucntion to save indent data*/
    public function saveIndent()
    {
        
        $material_count = count($_POST['material_name']);
        if ($material_count > 0 && $_POST['material_name'][0] != '') {
            $arr = array();
            $i   = 0;
            while ($i < $material_count) {
                $jsonArrayObject = (array(
                    'material_name_id' => $_POST['material_name'][$i],
                    'description' => $_POST['description'][$i],
                    'quantity' => $_POST['quantity'][$i],
                    'uom' => $_POST['uom'][$i],
                    'expected_amount' => $_POST['expected_amount'][$i],
                    'purpose' => $_POST['purpose'][$i],
                    'sub_total' => $_POST['sub_total'][$i],
                    'remaning_qty' => $_POST['quantity'][$i]
                ));
                
                $arr[$i] = $jsonArrayObject;
                $i++;
            }
            //remaning_qty ==> if remaning_qty is 0 means its complete PI 
            $material_array = json_encode($arr);
        } else {
            $material_array = '';
        }
        
        //pre($material_array);die();
        if ($this->input->post()) {
            $required_fields = array(
                'required_date',
                'material_type_id',
                'material_name'
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data                     = $this->input->post();
                $materialUpdateIds        = implode("','", $data['material_name']);
                $materialUpdateIds        = "'" . $materialUpdateIds . "'";
                $data['material_name']    = $material_array;
                $data['created_by_cid']   = $this->companyGroupId;
                $id                       = $data['id'];
                $usersWithViewPermissions = $this->maintenance_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 1
                ));
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success           = $this->maintenance_model->update_data('purchase_indent', $data, 'id', $id);
                    if ($success) {
                        /* update cost price of material to fetch last cost price of material  */
                        if (!empty($arr)) {
                            foreach ($arr as $res) {
                                $this->maintenance_model->update_single_value_data('material', array(
                                    'cost_price' => $res['expected_amount']
                                ), array(
                                    'id' => $res['material_name_id'],
                                    'created_by_cid' => $this->companyGroupId
                                ));
                            }
                        }
                        if ($data['material_type_id'] != '')
                            updateUsedIdStatus('material_type', $data['material_type_id']);
                        if ($materialUpdateIds != "''")
                            updateMultipleUsedIdStatus('material', $materialUpdateIds);
                        if ($data['preffered_supplier'] != "")
                            updateUsedIdStatus('supplier', $data['preffered_supplier']);
                        $data['message'] = "Purchase maintenance updated successfully";
                        logActivity('purchase maintenance Updated', 'purchase_indent', $id);
                        
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array(
                                        'subject' => 'Purchase indent updated',
                                        'message' => 'Purchase indent id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $userViewPermission['user_id'],
                                        'ref_id' => $id,
                                        'class' => 'add_purchase_tabs',
                                        'data_id' => 'indentView',
                                        'icon' => 'fa-shopping-cart'
                                    ));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array(
                                'subject' => 'Purchase indent updated',
                                'message' => 'Purchase indent id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInUser']->u_id,
                                'ref_id' => $id,
                                'class' => 'add_purchase_tabs',
                                'data_id' => 'indentView',
                                'icon' => 'fa-shopping-cart'
                            ));
                        }
                        
                        $this->session->set_flashdata('message', 'Purchase maintenance Updated successfully');
                        //redirect(base_url().'purchase/purchase_indent', 'refresh');
                    }
                } else {
                    //$data['created_by'] = $_SESSION['loggedInUser']->u_id;
                    $id = $this->maintenance_model->insert_bd_data('purchase_indent', $data);
                    
                    $insert_id           = $this->db->insert_id();
                    $breakdown_id        = $this->input->post('breakdownid');
                    $data['purchase_id'] = $insert_id;
                    $this->maintenance_model->update_bd_data('add_bd_request', $data, 'id', $breakdown_id);
                    
                    if ($id) {
                        /* update cost price of material to fetch last cost price of material  */
                        if (!empty($arr)) {
                            foreach ($arr as $res) {
                                $this->maintenance_model->update_single_value_data('material', array(
                                    'cost_price' => $res['expected_amount']
                                ), array(
                                    'id' => $res['material_name_id'],
                                    'created_by_cid' => $this->companyGroupId
                                ));
                            }
                        }
                        if ($data['material_type_id'] != '')
                            updateUsedIdStatus('material_type', $data['material_type_id']);
                        if ($materialUpdateIds != "''")
                            updateMultipleUsedIdStatus('material', $materialUpdateIds);
                        if ($data['preffered_supplier'] != "")
                            updateUsedIdStatus('supplier', $data['preffered_supplier']);
                        logActivity('Purchase indent inserted', 'purchase_indent', $id);
                        
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array(
                                        'subject' => 'New purchase indent created',
                                        'message' => 'New purchase indent is created by ' . $_SESSION['loggedInUser']->name,
                                        'from_id' => $_SESSION['loggedInUser']->u_id,
                                        'to_id' => $userViewPermission['user_id'],
                                        'ref_id' => $id,
                                        'class' => 'add_purchase_tabs',
                                        'data_id' => 'indentView',
                                        'icon' => 'fa-shopping-cart'
                                    ));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array(
                                'subject' => 'New purchase indent created',
                                'message' => 'New purchase indent is created by ' . $_SESSION['loggedInUser']->name,
                                'from_id' => $_SESSION['loggedInUser']->u_id,
                                'to_id' => $_SESSION['loggedInUser']->u_id,
                                'ref_id' => $id,
                                'class' => 'add_purchase_tabs',
                                'data_id' => 'indentView',
                                'icon' => 'fa-shopping-cart'
                            ));
                        }
                        
                        $this->session->set_flashdata('message', 'Purchase material inserted successfully');
                        
                    }
                }
                // pre($_FILES);
                
                // echo '==>'.$id;
                // die();
                if ($id) {
                    if (!empty($_FILES['docss']['name']) && $_FILES['docss']['name'][0] != '') {
                        $proof_array = array();
                        $proofCount  = count($_FILES['docss']['name']);
                        for ($i = 0; $i < $proofCount; $i++) {
                            $filename                = $_FILES['docss']['name'][$i];
                            $tmpname                 = $_FILES['docss']['tmp_name'][$i];
                            $type                    = $_FILES['docss']['type'][$i];
                            $error                   = $_FILES['docss']['error'][$i];
                            $size                    = $_FILES['docss']['size'][$i];
                            $exp                     = explode('.', $filename);
                            $ext                     = end($exp);
                            $newname                 = $exp[0] . '_' . time() . "." . $ext;
                            $config['upload_path']   = 'assets/modules/maintenance/uploads/';
                            $config['upload_url']    = base_url() . 'assets/modules/maintenance/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico|pdf|docs";
                            $config['max_size']      = '2000000';
                            $config['file_name']     = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/maintenance/uploads/" . $newname);
                            $proof_array[$i]['rel_id']    = $id;
                            $proof_array[$i]['rel_type']  = 'PI_PO_MRN';
                            $proof_array[$i]['file_name'] = $newname;
                            $proof_array[$i]['file_type'] = $type;
                        }
                        
                        
                        if (!empty($proof_array)) {
                            
                            /* Insert file information into the database */
                            $proofId = $this->maintenance_model->insert_attachment_data('attachments', $proof_array, 'PI_PO_MRN');
                        }
                    }
                    
                }
                redirect(base_url() . 'maintenance/breakdown', 'refresh');
            }
        }
    }
    
    
    /* Insert attachment Data */
    public function insert_attachment_data($table, $data = array(), $type)
    {
        if (!empty($data)) {
            foreach ($data as $dt) {
                $fieldData = $this->get_field_type_data($dt, $table);
                $this->db->insert($table, $fieldData);
                $insertedid = $this->db->insert_id();
                if ($insertedid) {
                    $dynamicdb         = $this->load->database('dynamicdb', TRUE);
                    $fieldData['id']   = $insertedid;
                    $dynamicInsertedid = $dynamicdb->insert($table, $fieldData);
                }
                
            }
            return $insertedid;
        }
    }
    
    
    
    
    
    
    /*view purchase product*/
    
    public function viewpurchase()
    {
        
        $id = $_POST['id'];
        permissions_redirect('is_view');
        $this->data['suppliername'] = $this->maintenance_model->get_data('supplier');
        $this->data['materialType'] = $this->maintenance_model->get_data('material_type');
        $this->data['indents']      = $this->maintenance_model->get_data_byId('purchase_indent', 'id', $id);
        $this->data['docss']        = $this->maintenance_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $id);
        /*if(!empty($this->data['indents']))
        $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material' ,'material_type', $this->data['indents']->material_type);*/
        //Code For Change Status*/
        $this->data['indents']      = $this->maintenance_model->get_data_byId('purchase_indent', 'id', $id);
        $wherePo                    = array(
            'purchase_order.pi_id' => $id,
            'purchase_order.save_status' => 1
        );
        $this->data['po']           = $this->maintenance_model->get_data('purchase_order', $wherePo);
        
        
        $get_po_or_pi_id = array(
            'purchase_order.pi_id' => $id,
            'purchase_order.save_status' => 1
        );
        $get_po_data     = $this->maintenance_model->get_data('purchase_order', $get_po_or_pi_id);
        
        if (!empty($get_po_data)) {
            $whereMrn = array(
                'mrn_detail.po_id' => $get_po_data[0]['id'],
                'mrn_detail.save_status' => 1
            );
        } else {
            $whereMrn = array(
                'mrn_detail.pi_id' => $id,
                'mrn_detail.save_status' => 1
            );
        }
        $this->data['mrn'] = $this->maintenance_model->get_data('mrn_detail', $whereMrn);
        
        $this->load->view('addmaintenance/viewpurchase', $this->data);
    }
    
    
    /*************************** Preventive ******************************/
    
    /*****************************************************Add machine code index****************************************/
    public function preventive()
    {
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Machine', base_url() . 'preventive');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Machine';
        /* if(isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!=''){
        $_SESSION['loggedInUser']->c_id = $_SESSION['companyGroupSessionId'];
        } */
        //Search
        $where2                        = '';
        $search_string                 = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $where2        = "add_machine.machine_name like'%" . $search_string . "%' or add_machine.machine_code like'%" . $search_string . "%' or add_machine.id like'%" . $search_string . "%'";
        }
        
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
            
        } else {
            $order = "desc";
        }
        
        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "maintenance/preventive/";
        $config["total_rows"]         = $this->maintenance_model->num_rows('add_machine', array(
            'created_by_cid' => $this->companyId
        ), $where2);
        $config["per_page"]           = 100;
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
            //$getbreakdown = $this->maintenance_model->get_data('add_bd_request');
            //for ($x = 0; $x < count($getbreakdown); $x++) {
            #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'add_machine.favourite_sts' => 1);
            //$where = array('add_machine.created_by_cid' => $this->companyId , 'add_machine.favourite_sts' => 1, 'add_machine.id' => $getbreakdown[$x]['machine_id']);
            //}
            
            $where                    = array(
                'add_machine.created_by_cid' => $this->companyId,
                'add_machine.favourite_sts' => 1
            );
            #$where = array('add_machine.created_by_cid' => (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id , 'add_machine.favourite_sts' => 1);
            $this->data['AddMachine'] = $this->maintenance_model->get_data1('add_machine', $where, $config["per_page"], $page, $where2, $order);
            
            $this->_render_template('preventive/index', $this->data);
            
        } else {
            
            
            if (isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
                //$getbreakdown = $this->maintenance_model->get_data('add_bd_request');
                //for ($x = 0; $x < count($getbreakdown); $x++) {
                #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id);
                //$where = array('add_machine.created_by_cid' => $this->companyId, 'add_machine.id' => $getbreakdown[$x]['machine_id']);
                //}
                
                $where                    = array(
                    'add_machine.created_by_cid' => $this->companyId
                );
                #$where = array('add_machine.created_by_cid' => (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id);
                $this->data['AddMachine'] = $this->maintenance_model->get_data1('add_machine', $where, $config["per_page"], $page, $where2, $order);
                
                $this->_render_template('preventive/index', $this->data);
            }
            if (!empty($_POST['start'])) {
                
                //$getbreakdown = $this->maintenance_model->get_data('add_bd_request');
                //for ($x = 0; $x < count($getbreakdown); $x++) {
                #$where = array('add_machine.created_date >=' => $_POST['start'] , 'add_machine.created_date <=' => $_POST['end'],'add_machine.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                //$where = array('add_machine.created_date >=' => $_POST['start'] , 'add_machine.created_date <=' => $_POST['end'],'add_machine.created_by_cid'=> $this->companyId, 'add_machine.id' => $getbreakdown[$x]['machine_id']);
                //}
                
                $where                    = array(
                    'add_machine.created_date >=' => $_POST['start'],
                    'add_machine.created_date <=' => $_POST['end'],
                    'add_machine.created_by_cid' => $this->companyId
                );
                #$where = array('add_machine.created_date >=' => $_POST['start'] , 'add_machine.created_date <=' => $_POST['end'],'add_machine.created_by_cid'=> (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id);
                $this->data['AddMachine'] = $this->maintenance_model->get_data1('add_machine', $where, $config["per_page"], $page, $where2, $order);
                
                $this->_render_template('preventive/index', $this->data);
            } else {
                //$getbreakdown = $this->maintenance_model->get_data('add_bd_request');
                //for ($x = 0; $x < count($getbreakdown); $x++) {
                //pre($getbreakdown[$x]['machine_id']);
                #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id);
                //$where = array('add_machine.created_by_cid' => $this->companyId, 'add_machine.id' => $getbreakdown[$x]['machine_id']);
                //}
                $where                    = array(
                    'add_machine.created_by_cid' => $this->companyId
                );
                #$where = array('add_machine.created_by_cid' => (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id);
                $this->data['AddMachine'] = $this->maintenance_model->get_data1('add_machine', $where, $config["per_page"], $page, $where2, $order);
                
                
                $this->_render_template('preventive/index', $this->data);
                
            }
            
        }
        /*if(!empty($_POST)){
        $this->load->view('Add_machine/index', $this->data);
        }else{
        $this->_render_template('Add_machine/index', $this->data);
        }*/
    }
    
    
    /******************* Set Preventive **********************/
    
    public function setpreventive()
    {
        
        $id                          = $_POST['id'];
        $this->data['AddMachine']    = $this->maintenance_model->get_data_byId('add_machine', 'id', $id);
        $this->data['Macpreventive'] = $this->maintenance_model->get_data_byId('add_preventive_data', 'machine_id', $id);
        $this->load->view('preventive/setpreventive', $this->data);
    }
    
    public function addsetpreventive()
    {
        $data                   = $this->input->post();
        $data['created_by']     = $_SESSION['loggedInUser']->u_id;
        $data['created_by_cid'] = $this->companyGroupId;
        $data['machine_id']     = $this->input->post('add_machine_id');
        $data['work_status']    = 0;
        $material_frequency = count($_POST['frequency_data']);
        if ($material_frequency > 0) {
            $aray = array();
            $k    = 0;
            while ($k < $material_frequency) {
                $jsonArrayObject = (array(
                    'frequency_data' => $_POST['frequency_data'][$k]
                ));
                $aray[$k]        = $jsonArrayObject;
                $k++;
            }
            $material_frequency_array = json_encode($aray);
            
        } else {
            $material_frequency_array = '';
        }
        
        $data['frequency'] = $material_frequency_array;
        
        $material_startdate = count($_POST['start_date']);
        
        if ($material_startdate > 0) {
            $aray = array();
            $k    = 0;
            while ($k < $material_startdate) {
                $jsonArrayObject = (array(
                    'startdate' => $_POST['start_date'][$k],
                    'frequency' => $_POST['frequency_data'][$k]
                ));
                $aray[$k]        = $jsonArrayObject;
                $k++;
            }
            
            $material_startdate_array = json_encode($aray);
            
        } else {
            $material_startdate_array = '';
        }
        
        $data['start_date'] = $material_startdate_array;
        
        
        
        $update = json_decode($material_startdate_array);
        
        for ($m = 0; $m < count($update); $m++) {
            $updateup = $update[$m]->startdate;
            
            if ($update[$m]->frequency == 'daily') {
                
                $upcomming_date = date('Y-m-d', strtotime($updateup . ' + 1 days'));
                //pre($upcomming_date);
            } else if ($update[$m]->frequency == 'weekly') {
                
                $upcomming_date = date('Y-m-d', strtotime($updateup . ' + 7 days'));
                //pre($upcomming_date);
            } else if ($update[$m]->frequency == 'monthly') {
                
                $upcomming_date = date('Y-m-d', strtotime($updateup . ' + 30 days'));
                // pre($upcomming_date);
            } else {
                
                $upcomming_date = date('Y-m-d', strtotime($updateup . ' + 365 days'));
                
            }
            
            $datesup[] = $upcomming_date;
            
        }
        
        $upcoming_date = count($datesup);
        $machine_id    = $this->input->post('add_machine_id');
        if ($upcoming_date > 0) {
            $araydate = array();
            $l        = 0;
            while ($l < $upcoming_date) {
                $jsonArrayObject = (array(
                    'machine_id' => $machine_id,
                    'upcomingdate' => $datesup[$l],
                    'frequency' => $_POST['frequency_data'][$l]
                ));
                $araydate[$l]    = $jsonArrayObject;
                
                $l++;
            }
            
            $material_upcoming_date = json_encode($araydate);
            
        } else {
            $material_upcoming_date = '';
        }
        
        $data['upcomming_date'] = $material_upcoming_date;
        
        $material_checklist = count($_POST['check_list_data']);
        
        if ($material_checklist > 0) {
            $arr = array();
            $j   = 0;
            while ($j < $material_checklist) {
                $jsonArrayObject = (array(
                    'check_list_data' => $_POST['check_list_data'][$j]
                ));
                $arr[$j]         = $jsonArrayObject;
                $j++;
            }
            $material_checklist_array = json_encode($arr);
            
        } else {
            $material_checklist_array = '';
        }
        
        $data['check_list'] = $material_checklist_array;
        
        $material_details = count($_POST['material_type']);
        if ($material_details > 0) {
            $arry = array();
            $i    = 0;
            while ($i < $material_details) {
                $jsonArrayObject = (array(
                    'material_name' => $_POST['material_name'][$i],
                    'material_type' => $_POST['material_type'][$i],
                    'quantity' => $_POST['quantity'][$i]
                ));
                $arry[$i]        = $jsonArrayObject;
                $i++;
            }
            
            $materialDetail_array = json_encode($arry);
        } else {
            $materialDetail_array = '';
        }
        $data['material_detail'] = $materialDetail_array;
        
        
        $material_all = count($_POST['frequency_data']);
        
        if ($material_all > 0) {
            $aray = array();
            $k    = 0;
            while ($k < $material_all) {
                $jsonArrayObject = (array(
                    'frequency_data' => $_POST['frequency_data'][$k],
                    'startdate' => $_POST['start_date'][$k],
                    'checklist' => array(
                        'check_list_data' => $_POST['check_list_data'][$k]
                    ),
                    'materiallist' => array(
                        'material_name' => $_POST['material_name'][$k],
                        'material_type' => $_POST['material_type'][$k],
                        'quantity' => $_POST['quantity'][$k]
                    )
                ));
                $aray[$k]        = $jsonArrayObject;
                $k++;
            }
            
            
            $preventiv_all_data = json_encode($aray);
        } else {
            $preventiv_all_data = '';
        }
        
        //$arry_preventive = (array('frequency' => $material_frequency_array, 'startdate' => $material_startdate_array, 'checklist' => $material_checklist_array, 'material' => $materialDetail_array));
        //$preventiv_all_data = json_encode($arry_preventive);
        
        $data['preventiv_all_data'] = $preventiv_all_data;
        
        if (empty($this->input->post('machine_id'))) {
            
            $insertdata = $this->maintenance_model->insert_bd_data('add_preventive_data', $data);
            
            $insert_id             = $this->db->insert_id();
            $set_unset             = $this->input->post('set_unset');
            $machine_id            = $this->input->post('add_machine_id');
            $data['set_unset']     = $set_unset;
            $data['preventive_id'] = $insert_id;
            
            $this->maintenance_model->update_bd_data('add_machine', $data, 'id', $machine_id);
            
            if ($insertdata == true) {
                $this->session->set_flashdata('message', 'Preventive inserted successfully');
                redirect(base_url() . 'maintenance/preventive', 'refresh');
            } else {
                
                $this->session->set_flashdata('error', 'Preventive Not inserted successfully');
                redirect(base_url() . 'maintenance/preventive', 'refresh');
                
            }
        } else {
            
            $machine_id = $this->input->post('add_machine_id');
            $insertdata = $this->maintenance_model->update_bd_data('add_preventive_data', $data, 'machine_id', $machine_id);
            
            if ($insertdata == true) {
                $this->session->set_flashdata('message', 'Preventive Update successfully');
                redirect(base_url() . 'maintenance/preventive', 'refresh');
            } else {
                
                $this->session->set_flashdata('error', 'Preventive Not Update successfully');
                redirect(base_url() . 'maintenance/preventive', 'refresh');
                
            }
            
            
        }
        
        
    }
    
    public function viewpreventive()
    {
        
        $id                            = $_POST['id'];
        $this->data['AddMachine']      = $this->maintenance_model->get_data_byId('add_machine', 'id', $id);
        $this->data['setperiventdmac'] = $this->maintenance_model->get_data_byId('add_preventive_data', 'machine_id', $id);
        
        $this->data['machine_history'] = $this->maintenance_model->get_data_byId('add_bd_request', 'machine_id', $id);
        $this->load->view('preventive/viewpreventive', $this->data);
    }
    public function viewpreventivedtl(){
        $id                            = $_POST['id'];
	
        $this->data['AddMachine']      = $this->maintenance_model->get_data_byId('add_machine', 'id', $id);
        $this->data['setperiventdmac'] = $this->maintenance_model->get_data_byId('add_preventive_data', 'machine_id', $id);
        
        $this->data['machine_history'] = $this->maintenance_model->get_data_byId('add_bd_request', 'machine_id', $id);
        $this->load->view('preventive/viewmat', $this->data);
    }
    public function editpreventive()
    {
        
        $id                       = $_POST['id'];
        $this->data['AddMachine'] = $this->maintenance_model->get_data_byId('add_machine', 'id', $id);
        $this->load->view('preventive/editpreventive', $this->data);
    }
    
    
    public function getMaterialDataById()
    {
        if (isset($_REQUEST) && !empty($_REQUEST) && (isset($_REQUEST['id']) && $_REQUEST['id'] != '')) {
            $id       = $_REQUEST['id'];
            $material = $this->maintenance_model->get_data_byId_fromMaterial('material', 'id', $id);
            if ($material->uom != '') {
                $ww              = getNameById('uom', $material->uom, 'id');
                $material->uom   = $ww->ugc_code;
                $material->uomid = $ww->id;
            }
            //$material = $this->production_model->get_data_byId('material','id',$id);
            echo json_encode($material);
        }
    }
    
    
    
    
    /*********************Pipeline**************************/
    
    
    public function pipeline()
    {
        
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Maintenance', base_url() . 'maintenance/');
        $this->breadcrumb->add('Pipeline', base_url() . 'maintenance/pipeline');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Pipeline';
        $where                         = array(
            'c_id' => $this->companyGroupId
        );
        $this->data['user1']           = $this->maintenance_model->get_data('user_detail', $where);
        if (isset($_POST['user_id'])) {
            $array                     = array();
            $where                     = array(
                'type' => 'breakdown'
            );
            $this->data['processType'] = $this->maintenance_model->get_data('pipeline_work_staus', $where);
            $i                         = 0;
            foreach ($this->data['processType'] as $ProcessType) {
                $where                = array(
                    'work_status' => $ProcessType['Id'],
                    'created_by_cid' => $this->companyGroupId, 

                );
                $process              = $this->maintenance_model->get_data('add_bd_request', $where);
                $array[$i]['types']   = $ProcessType;
                $array[$i]['process'] = $process;
                $i++;
            }
            $this->data['processdata'] = $array;
            $this->_render_template('pipeline/index', $this->data);
        } else {
            $array                     = array();
            $where                     = array(
                'type' => 'breakdown',
                
            );
            $this->data['processType'] = $this->maintenance_model->get_data('pipeline_work_staus', $where);
            $i                         = 0;
            foreach ($this->data['processType'] as $ProcessType) {
                //pre($ProcessType);
                $where                = array(
                    'work_status' => $ProcessType['Id'],
                    'created_by_cid' => $this->companyGroupId
                );
                $process              = $this->maintenance_model->get_data('add_bd_request', $where);
                $array[$i]['types']   = $ProcessType;
                $array[$i]['process'] = $process;
                $i++;
            }
            $this->data['processdata'] = $array;
            
            
            /*******preventive data*******/
            
            $arry                         = array();
            $where                        = array(
                'type' => 'preventive'
            );
            $this->data['preventiveType'] = $this->maintenance_model->get_data('pipeline_work_staus', $where);
            $j                            = 0;
            foreach ($this->data['preventiveType'] as $preventiveType) {
                //pre($ProcessType);
                $where = array(
                    'work_status' => $preventiveType['Id'],
                    'created_by_cid' => $this->companyGroupId
                );
                
                $prventiveprocess             = $this->maintenance_model->get_data('add_preventive_data', $where);
                $arry[$j]['preventivetypes']  = $preventiveType;
                $arry[$j]['prventiveprocess'] = $prventiveprocess;
                $j++;
            }
            $this->data['preventivedata'] = $arry;
       $this->_render_template('pipeline/index', $this->data);
            
            /******prevwntivw data end ******/
        }
        
        
    }
    
    
    public function editpipline()
    {
        
        
        $this->data['machinename'] = $this->maintenance_model->get_machine_data('add_machine', array(
            'created_by' => $_SESSION['loggedInUser']->id
        ));
        
        $this->data['editbdpipeline'] = $this->maintenance_model->get_data_byId('add_bd_request', 'id', $this->input->post('id'));
        
        $this->data['user_breakdown'] = $this->maintenance_model->get_data_breakdown('add_bd_request', array(
            'created_by' => $_SESSION['loggedInUser']->id
        ));
        
        $this->load->view('pipeline/editpipline', $this->data);
        
    }
    
    // For PipeLine Module Start//
    public function changeProcessType()
    {
        $data                     = $this->input->post();
        $id                       = $data['processId'];
        $process_status           = $this->maintenance_model->change_process_status($data, $id);
        $usersWithViewPermissions = $this->maintenance_model->get_data('permissions', array(
            'is_view' => 1,
            'sub_module_id' => 5
        ));
        if (!empty($usersWithViewPermissions)) {
            foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                    pushNotification(array(
                        'subject' => 'breakdown status updated',
                        'message' => 'breakdown status updated by' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id,
                        'status' => $data['processTypeId'],
                        'to_id' => $userViewPermission['user_id'],
                        'ref_id' => $id
                    ));
                }
            }
        }
        if ($_SESSION['loggedInUser']->role != 1) {
            pushNotification(array(
                'subject' => 'breakdown status updated',
                'message' => 'breakdown status updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id,
                'status' => $data['processTypeId'],
                'to_id' => $_SESSION['loggedInCompany']->u_id,
                'ref_id' => $id
            ));
        }
        $this->_render_template('pipeline/index', $process_status);
    }
    
    public function changeProcessTypepre()
    {
        
        $data                     = $this->input->post();
        $id                       = $data['processId'];
        $process_status           = $this->maintenance_model->change_process_status_pre($data, $id);
        $usersWithViewPermissions = $this->maintenance_model->get_data('permissions', array(
            'is_view' => 1,
            'sub_module_id' => 5
        ));
        if (!empty($usersWithViewPermissions)) {
            foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                    pushNotification(array(
                        'subject' => 'breakdown status updated',
                        'message' => 'breakdown status updated by' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id,
                        'status' => $data['processTypeId'],
                        'to_id' => $userViewPermission['user_id'],
                        'ref_id' => $id
                    ));
                }
            }
        }
        if ($_SESSION['loggedInUser']->role != 1) {
            pushNotification(array(
                'subject' => 'breakdown status updated',
                'message' => 'breakdown status updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id,
                'status' => $data['processTypeId'],
                'to_id' => $_SESSION['loggedInCompany']->u_id,
                'ref_id' => $id
            ));
        }
        $this->_render_template('pipeline/index', $process_status);
        
    }
    
    
    public function updatebdpipeline()
    {
        
        $id                     = $this->input->post('id');
        $data                   = $this->input->post();
        $data['created_by']     = $_SESSION['loggedInUser']->u_id;
        $data['created_by_cid'] = $this->companyGroupId;
        $data['created_date']   = date('Y-m-d h:i:s');
        if ($id != '') {
            
            //$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
            $success = $this->maintenance_model->update_bd_data('add_bd_request', $data, 'id', $id);
            
            if ($success) {
                
                $this->session->set_flashdata('message', 'Breakdown Pipeline Request Updated successfully');
                redirect(base_url() . 'maintenance/pipeline', 'refresh');
                
            } else {
                
                $this->session->set_flashdata('error', 'Breakdown Pipeline Request Not Updated successfully');
                redirect(base_url() . 'maintenance/pipeline', 'refresh');
                
            }
        }
        
    }
    
    /***********Pre Pipeline**************/
    
    public function prepipeline()
    {
        
        
        $this->data['preventivepipeline'] = $this->maintenance_model->get_data_byId('add_preventive_data', 'id', $this->input->post('id'));
        
        $this->load->view('pipeline/prepipeline', $this->data);
        
    }
    
    public function prepipelinesedule()
    {
        
        $this->data['preventivepipeline'] = $this->maintenance_model->get_data_byId('add_preventive_data', 'id', $this->input->post('id'));
        
        $this->data['prepipelinesedule'] = $this->maintenance_model->get_data_byId('add_preventive_data', 'id', $this->input->post('id'));
        
        $this->data['get_worker'] = $this->maintenance_model->get_worker_data('worker', array(
            'department' => 'maintenance'
        ));
        
        $this->load->view('pipeline/prepipelinesedule', $this->data);
        
    }
    
    public function pipelinedone()
    {
        
        
        $this->data['pipelinedone'] = $this->maintenance_model->get_data_byId('add_preventive_data', 'id', $this->input->post('id'));
        
        $this->load->view('pipeline/pipelinedone', $this->data);
        
    }
    
    public function setschedule()
    {
        
        
        $this->data['get_worker'] = $this->maintenance_model->get_worker_data('worker', array(
            'department' => 'maintenance'
        ));
        
        $this->load->view('pipeline/setschedule', $this->data);
        
    }
    
    public function updateprepipeline()
    {
        
        $id                     = $this->input->post('id');
        $data                   = $this->input->post();
        $data['created_by']     = $_SESSION['loggedInUser']->u_id;
        $data['created_by_cid'] = $this->companyGroupId;
        $data['created_date']   = date('Y-m-d h:i:s');
        
        $material_checklist = count($_POST['chekeddata']);
        
        if ($material_checklist > 0) {
            $arr = array();
            $j   = 0;
            while ($j < $material_checklist) {
                $jsonArrayObject = (array(
                    'chekeddata' => $_POST['chekeddata'][$j],
                    'chekeddataname' => $_POST['chekeddataname'][$j],
                    'remark' => $_POST['remark']
                ));
                $arr[$j]         = $jsonArrayObject;
                $j++;
            }
            $material_checklist_array = json_encode($arr);
        } else {
            $material_checklist_array = '';
        }
        
        $data['pre_completed'] = $material_checklist_array;
        
        if ($id != '') {
            
            //$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
            $success = $this->maintenance_model->update_bd_data('add_preventive_data', $data, 'id', $id);
            
            if ($success) {
                
                $this->session->set_flashdata('message', 'preventive Pipeline Request Updated successfully');
                redirect(base_url() . 'maintenance/pipeline', 'refresh');
                
            } else {
                
                $this->session->set_flashdata('error', 'preventive Pipeline Request Not Updated successfully');
                redirect(base_url() . 'maintenance/pipeline', 'refresh');
                
            }
        }
        
    }
    
    
    
    
    
    public function set_sed_preventive_maintenance()
    {
        
        $date            = date('y-m-d h:i:s');
        $preventive_data = $this->maintenance_model->get_data('add_preventive_data');
        
        foreach ($preventive_data as $preventive_datas) {
            $upcomingdata = json_decode($preventive_datas['upcomming_date']);
            
            if (is_array($upcomingdata)) {
                
                foreach ($upcomingdata as $key => $upcomingdatas) {
                    if ($upcomingdatas->upcomingdate == date('Y-m-d')) {
                        
                        if ($upcomingdatas->frequency == 'daily') {
                            $where           = array(
                                'machine_id' => $upcomingdatas->machine_id
                            );
                            $preventive_data = $this->maintenance_model->get_data('add_preventive_data', $where);
                            if (!empty($preventive_data)) {
                                
                                foreach ($preventive_data as $schedule_data) {
                                    //pre($schedule_data);
                                    $data_id = $schedule_data['id'];
                                    
                                    $staus['work_status']        = 4;
                                    $staus['created_by']         = $_SESSION['loggedInUser']->u_id;
                                    $staus['created_by_cid']     = $this->companyGroupId;
                                    $staus['created_date']       = date('Y-m-d h:i:s');
                                    $staus['preventive_id']      = $schedule_data['id'];
                                    $staus['machine_id']         = $schedule_data['machine_id'];
                                    $staus['material']           = $schedule_data['material_detail'];
                                    $staus['check_list']         = $schedule_data['check_list'];
                                    $staus['frequency']          = $schedule_data['frequency'];
                                    $staus['start_date']         = $schedule_data['start_date'];
                                    $staus['upcomming_date']     = $schedule_data['upcomming_date'];
                                    $staus['material_detail']    = $schedule_data['material_detail'];
                                    $staus['preventiv_all_data'] = $schedule_data['preventiv_all_data'];
                                    
                                    $data['created_by']     = $_SESSION['loggedInUser']->u_id;
                                    $data['created_by_cid'] = $this->companyGroupId;
                                    $data['created_date']   = date('Y-m-d h:i:s');
                                    $data['preventive_id']  = $schedule_data['id'];
                                    $data['machine_id']     = $schedule_data['machine_id'];
                                    $data['material']       = $schedule_data['material_detail'];
                                    $data['check_list']     = $schedule_data['check_list'];
                                    $data['frequency']      = $upcomingdatas->frequency;
                                    $data['work_status']    = date('Y-m-d h:i:s');
                                    
                                    $date            = date('y-m-d h:i:s');
                                    $currendateins   = date('Y-m-d', strtotime('+1 days', strtotime($date)));
                                    $upcomingdateins = (array(
                                        'machine_id' => $schedule_data['machine_id'],
                                        'upcomingdate' => $currendateins,
                                        'frequency' => 'daily'
                                    ));
                                    $arraydata[]     = $upcomingdateins;
                                    $upcomins        = json_encode($arraydata);
                                    
                                    $stausinsert['work_status']        = 0;
                                    $stausinsert['created_by']         = $_SESSION['loggedInUser']->u_id;
                                    $stausinsert['created_by_cid']     = $this->companyGroupId;
                                    $stausinsert['created_date']       = date('Y-m-d h:i:s');
                                    $stausinsert['preventive_id']      = $schedule_data['id'];
                                    $stausinsert['machine_id']         = $schedule_data['machine_id'];
                                    $stausinsert['material']           = $schedule_data['material_detail'];
                                    $stausinsert['check_list']         = $schedule_data['check_list'];
                                    $stausinsert['frequency']          = $schedule_data['frequency'];
                                    $stausinsert['start_date']         = $schedule_data['start_date'];
                                    $stausinsert['upcomming_date']     = $upcomins;
                                    $stausinsert['material_detail']    = $schedule_data['material_detail'];
                                    $stausinsert['preventiv_all_data'] = $schedule_data['preventiv_all_data'];
                                    
                                    
                                    
                                }
                                
                                $updatedata = $this->maintenance_model->update_bd_data('add_preventive_data', $staus, 'id', $data_id);
                                
                                //$insertdata = $this->maintenance_model->insert_bd_data('schedule_mentaince',$data);
                                
                                $insertpredata = $this->maintenance_model->insert_bd_data('add_preventive_data', $stausinsert);
                                
                            }
                            
                            
                        }
                        
                    } else if ($upcomingdatas->upcomingdate == date('Y-m-d')) {
                        
                        if ($upcomingdatas->frequency == 'weekly') {
                            
                            $where           = array(
                                'machine_id' => $upcomingdatas->machine_id
                            );
                            $preventive_data = $this->maintenance_model->get_data('add_preventive_data', $where);
                            if (!empty($preventive_data)) {
                                
                                foreach ($preventive_data as $schedule_data) {
                                    //pre($schedule_data);
                                    
                                    $data_id = $schedule_data['id'];
                                    
                                    $staus['work_status']        = 4;
                                    $staus['created_by']         = $_SESSION['loggedInUser']->u_id;
                                    $staus['created_by_cid']     = $this->companyGroupId;
                                    $staus['created_date']       = date('Y-m-d h:i:s');
                                    $staus['preventive_id']      = $schedule_data['id'];
                                    $staus['machine_id']         = $schedule_data['machine_id'];
                                    $staus['material']           = $schedule_data['material_detail'];
                                    $staus['check_list']         = $schedule_data['check_list'];
                                    $staus['frequency']          = $schedule_data['frequency'];
                                    $staus['start_date']         = $schedule_data['start_date'];
                                    $staus['upcomming_date']     = $schedule_data['upcomming_date'];
                                    $staus['material_detail']    = $schedule_data['material_detail'];
                                    $staus['preventiv_all_data'] = $schedule_data['preventiv_all_data'];
                                    
                                    $data['created_by']     = $_SESSION['loggedInUser']->u_id;
                                    $data['created_by_cid'] = $this->companyGroupId;
                                    $data['created_date']   = date('Y-m-d h:i:s');
                                    $data['preventive_id']  = $schedule_data['id'];
                                    $data['machine_id']     = $schedule_data['machine_id'];
                                    $data['material']       = $schedule_data['material_detail'];
                                    $data['check_list']     = $schedule_data['check_list'];
                                    $data['frequency']      = $upcomingdatas->frequency;
                                    $data['work_status']    = date('Y-m-d h:i:s');
                                    
                                    $date            = date('y-m-d h:i:s');
                                    $currendateins   = date('Y-m-d', strtotime('+7 days', strtotime($date)));
                                    $upcomingdateins = (array(
                                        'machine_id' => $schedule_data['machine_id'],
                                        'upcomingdate' => $currendateins,
                                        'frequency' => 'weekly'
                                    ));
                                    $arraydata[]     = $upcomingdateins;
                                    $upcomins        = json_encode($arraydata);
                                    
                                    $stausinsert['work_status']        = 0;
                                    $stausinsert['created_by']         = $_SESSION['loggedInUser']->u_id;
                                    $stausinsert['created_by_cid']     = $this->companyGroupId;
                                    $stausinsert['created_date']       = date('Y-m-d h:i:s');
                                    $stausinsert['preventive_id']      = $schedule_data['id'];
                                    $stausinsert['machine_id']         = $schedule_data['machine_id'];
                                    $stausinsert['material']           = $schedule_data['material_detail'];
                                    $stausinsert['check_list']         = $schedule_data['check_list'];
                                    $stausinsert['frequency']          = $schedule_data['frequency'];
                                    $stausinsert['start_date']         = $schedule_data['start_date'];
                                    $stausinsert['upcomming_date']     = $upcomins;
                                    $stausinsert['material_detail']    = $schedule_data['material_detail'];
                                    $stausinsert['preventiv_all_data'] = $schedule_data['preventiv_all_data'];
                                    
                                    
                                    
                                }
                                
                                $updatedata = $this->maintenance_model->update_bd_data('add_preventive_data', $staus, 'id', $data_id);
                                
                                //$insertdata = $this->maintenance_model->insert_bd_data('schedule_mentaince',$data);
                                
                                $insertpredata = $this->maintenance_model->insert_bd_data('add_preventive_data', $stausinsert);
                                
                            }
                            
                            
                            
                            
                        }
                        
                    } else if ($upcomingdatas->upcomingdate == date('Y-m-d')) {
                        
                        if ($upcomingdatas->frequency == 'monthly') {
                            
                            $where           = array(
                                'machine_id' => $upcomingdatas->machine_id
                            );
                            $preventive_data = $this->maintenance_model->get_data('add_preventive_data', $where);
                            if (!empty($preventive_data)) {
                                
                                foreach ($preventive_data as $schedule_data) {
                                    //pre($schedule_data);
                                    
                                    $data_id = $schedule_data['id'];
                                    
                                    $staus['work_status']        = 4;
                                    $staus['created_by']         = $_SESSION['loggedInUser']->u_id;
                                    $staus['created_by_cid']     = $this->companyGroupId;
                                    $staus['created_date']       = date('Y-m-d h:i:s');
                                    $staus['preventive_id']      = $schedule_data['id'];
                                    $staus['machine_id']         = $schedule_data['machine_id'];
                                    $staus['material']           = $schedule_data['material_detail'];
                                    $staus['check_list']         = $schedule_data['check_list'];
                                    $staus['frequency']          = $schedule_data['frequency'];
                                    $staus['start_date']         = $schedule_data['start_date'];
                                    $staus['upcomming_date']     = $schedule_data['upcomming_date'];
                                    $staus['material_detail']    = $schedule_data['material_detail'];
                                    $staus['preventiv_all_data'] = $schedule_data['preventiv_all_data'];
                                    
                                    $data['created_by']     = $_SESSION['loggedInUser']->u_id;
                                    $data['created_by_cid'] = $this->companyGroupId;
                                    $data['created_date']   = date('Y-m-d h:i:s');
                                    $data['preventive_id']  = $schedule_data['id'];
                                    $data['machine_id']     = $schedule_data['machine_id'];
                                    $data['material']       = $schedule_data['material_detail'];
                                    $data['check_list']     = $schedule_data['check_list'];
                                    $data['frequency']      = $upcomingdatas->frequency;
                                    $data['work_status']    = date('Y-m-d h:i:s');
                                    
                                    $date            = date('y-m-d h:i:s');
                                    $currendateins   = date('Y-m-d', strtotime('+30 days', strtotime($date)));
                                    $upcomingdateins = (array(
                                        'machine_id' => $schedule_data['machine_id'],
                                        'upcomingdate' => $currendateins,
                                        'frequency' => 'monthly'
                                    ));
                                    $arraydata[]     = $upcomingdateins;
                                    $upcomins        = json_encode($arraydata);
                                    
                                    $stausinsert['work_status']        = 0;
                                    $stausinsert['created_by']         = $_SESSION['loggedInUser']->u_id;
                                    $stausinsert['created_by_cid']     = $this->companyGroupId;
                                    $stausinsert['created_date']       = date('Y-m-d h:i:s');
                                    $stausinsert['preventive_id']      = $schedule_data['id'];
                                    $stausinsert['machine_id']         = $schedule_data['machine_id'];
                                    $stausinsert['material']           = $schedule_data['material_detail'];
                                    $stausinsert['check_list']         = $schedule_data['check_list'];
                                    $stausinsert['frequency']          = $schedule_data['frequency'];
                                    $stausinsert['start_date']         = $schedule_data['start_date'];
                                    $stausinsert['upcomming_date']     = $upcomins;
                                    $stausinsert['material_detail']    = $schedule_data['material_detail'];
                                    $stausinsert['preventiv_all_data'] = $schedule_data['preventiv_all_data'];
                                    
                                    
                                    
                                }
                                
                                $updatedata = $this->maintenance_model->update_bd_data('add_preventive_data', $staus, 'id', $data_id);
                                
                                //$insertdata = $this->maintenance_model->insert_bd_data('schedule_mentaince',$data);
                                
                                $insertpredata = $this->maintenance_model->insert_bd_data('add_preventive_data', $stausinsert);
                                
                            }
                            
                            
                            
                            
                        }
                        
                    } else if ($upcomingdatas->upcomingdate == date('Y-m-d')) {
                        
                        if ($upcomingdatas->frequency == 'yearly') {
                            
                            $where           = array(
                                'machine_id' => $upcomingdatas->machine_id
                            );
                            $preventive_data = $this->maintenance_model->get_data('add_preventive_data', $where);
                            if (!empty($preventive_data)) {
                                
                                foreach ($preventive_data as $schedule_data) {
                                    //pre($schedule_data);
                                    
                                    $data_id = $schedule_data['id'];
                                    
                                    $staus['work_status']        = 4;
                                    $staus['created_by']         = $_SESSION['loggedInUser']->u_id;
                                    $staus['created_by_cid']     = $this->companyGroupId;
                                    $staus['created_date']       = date('Y-m-d h:i:s');
                                    $staus['preventive_id']      = $schedule_data['id'];
                                    $staus['machine_id']         = $schedule_data['machine_id'];
                                    $staus['material']           = $schedule_data['material_detail'];
                                    $staus['check_list']         = $schedule_data['check_list'];
                                    $staus['frequency']          = $schedule_data['frequency'];
                                    $staus['start_date']         = $schedule_data['start_date'];
                                    $staus['upcomming_date']     = $schedule_data['upcomming_date'];
                                    $staus['material_detail']    = $schedule_data['material_detail'];
                                    $staus['preventiv_all_data'] = $schedule_data['preventiv_all_data'];
                                    
                                    $data['created_by']     = $_SESSION['loggedInUser']->u_id;
                                    $data['created_by_cid'] = $this->companyGroupId;
                                    $data['created_date']   = date('Y-m-d h:i:s');
                                    $data['preventive_id']  = $schedule_data['id'];
                                    $data['machine_id']     = $schedule_data['machine_id'];
                                    $data['material']       = $schedule_data['material_detail'];
                                    $data['check_list']     = $schedule_data['check_list'];
                                    $data['frequency']      = $upcomingdatas->frequency;
                                    $data['work_status']    = date('Y-m-d h:i:s');
                                    
                                    $date            = date('y-m-d h:i:s');
                                    $currendateins   = date('Y-m-d', strtotime('+365 days', strtotime($date)));
                                    $upcomingdateins = (array(
                                        'machine_id' => $schedule_data['machine_id'],
                                        'upcomingdate' => $currendateins,
                                        'frequency' => 'yearly'
                                    ));
                                    $arraydata[]     = $upcomingdateins;
                                    $upcomins        = json_encode($arraydata);
                                    
                                    $stausinsert['work_status']        = 0;
                                    $stausinsert['created_by']         = $_SESSION['loggedInUser']->u_id;
                                    $stausinsert['created_by_cid']     = $this->companyGroupId;
                                    $stausinsert['created_date']       = date('Y-m-d h:i:s');
                                    $stausinsert['preventive_id']      = $schedule_data['id'];
                                    $stausinsert['machine_id']         = $schedule_data['machine_id'];
                                    $stausinsert['material']           = $schedule_data['material_detail'];
                                    $stausinsert['check_list']         = $schedule_data['check_list'];
                                    $stausinsert['frequency']          = $schedule_data['frequency'];
                                    $stausinsert['start_date']         = $schedule_data['start_date'];
                                    $stausinsert['upcomming_date']     = $upcomins;
                                    $stausinsert['material_detail']    = $schedule_data['material_detail'];
                                    $stausinsert['preventiv_all_data'] = $schedule_data['preventiv_all_data'];
                                    
                                    
                                    
                                }
                                
                                $updatedata = $this->maintenance_model->update_bd_data('add_preventive_data', $staus, 'id', $data_id);
                                
                                //$insertdata = $this->maintenance_model->insert_bd_data('schedule_mentaince',$data);
                                
                                $insertpredata = $this->maintenance_model->insert_bd_data('add_preventive_data', $stausinsert);
                                
                            }
                            
                        }
                        
                    }
                }
                
            }
            
        }
        
    }
    
    
    
    /****************Schedule data*************/
    
    public function schedule()
    {
        
        $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->breadcrumb->add('Machine', base_url() . 'schedule');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Machine';
        /* if(isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!=''){
        $_SESSION['loggedInUser']->c_id = $_SESSION['companyGroupSessionId'];
        } */
        //Search
        $where2                        = '';
        $search_string                 = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $where2        = "schedule_mentaince.machine_name like'%" . $search_string . "%' or schedule_mentaince.machine_code like'%" . $search_string . "%' or schedule_mentaince.id like'%" . $search_string . "%'";
        }
        
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
            
        } else {
            $order = "desc";
        }
        
        //Pagination
        $config                       = array();
        $config["base_url"]           = base_url() . "maintenance/schedule/";
        $config["total_rows"]         = $this->maintenance_model->num_rows('schedule_mentaince', array(
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
            
            #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id , 'add_machine.favourite_sts' => 1);
            $where                     = array(
                'schedule_mentaince.created_by_cid' => $this->companyId,
                'schedule_mentaince.favourite_sts' => 1
            );
            #$where = array('add_machine.created_by_cid' => (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id , 'add_machine.favourite_sts' => 1);
            $this->data['getschedule'] = $this->maintenance_model->get_data1('schedule_mentaince', $where, $config["per_page"], $page, $where2, $order);
            $this->_render_template('schedule/index', $this->data);
            
        } else {
            
            
            if (isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
                #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id);
                $where                     = array(
                    'schedule_mentaince.created_by_cid' => $this->companyId
                );
                #$where = array('add_machine.created_by_cid' => (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id);
                $this->data['getschedule'] = $this->maintenance_model->get_data1('schedule_mentaince', $where, $config["per_page"], $page, $where2, $order);
                $this->_render_template('schedule/index', $this->data);
            }
            if (!empty($_POST['start'])) {
                #$where = array('add_machine.created_date >=' => $_POST['start'] , 'add_machine.created_date <=' => $_POST['end'],'add_machine.created_by_cid'=> $_SESSION['loggedInUser']->c_id);
                $where                     = array(
                    'schedule_mentaince.created_date >=' => $_POST['start'],
                    'add_machine.created_date <=' => $_POST['end'],
                    'schedule_mentaince.created_by_cid' => $this->companyId
                );
                #$where = array('add_machine.created_date >=' => $_POST['start'] , 'add_machine.created_date <=' => $_POST['end'],'add_machine.created_by_cid'=> (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id);
                $this->data['getschedule'] = $this->maintenance_model->get_data1('schedule_mentaince', $where, $config["per_page"], $page, $where2, $order);
                $this->_render_template('schedule/index', $this->data);
            } else {
                #$where = array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id);
                $where                     = array(
                    'schedule_mentaince.created_by_cid' => $this->companyId
                );
                #$where = array('add_machine.created_by_cid' => (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id);
                $this->data['getschedule'] = $this->maintenance_model->get_data1('schedule_mentaince', $where, $config["per_page"], $page, $where2, $order);
                $this->_render_template('schedule/index', $this->data);
            }
            
        }
        /*if(!empty($_POST)){
        $this->load->view('Add_machine/index', $this->data);
        }else{
        $this->_render_template('Add_machine/index', $this->data);
        }*/
    }
    
    
    /****************Schedule data*************/
    
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
        redirect(base_url() . 'maintenance/breakdown', 'refresh');
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
        $result    = $this->maintenance_model->markfavour($tablename, $data, $id);
        if ($result == true) {
            foreach ($id as $ky) {
                logActivity($datamsg . ' Records marked favourite', $tablename, $ky);
            }
            $this->session->set_flashdata('message', $datamsg . ' Favourites');
            $result = array(
                'msg' => 'Sale order approved',
                'status' => 'success',
                'code' => 'C296',
                'url' => base_url() . 'maintenance/breakdown'
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
}