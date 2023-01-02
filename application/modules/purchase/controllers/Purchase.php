<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Purchase extends ERP_Controller {
    public function __construct() {
        parent::__construct();
        is_login();
        /*$this->settings['parent_menu'] = 'setup';
         $this->settings['active_menu'] = 'setup';      */
        $this->load->library('pagination');
        $this->load->library(['form_validation','pagination']);
        $this->load->helper(['purchase/purchase','import','table_tr']);
        $this->load->model('purchase_model');
        $this->load->model('account/account_model');
        #$this->scripts['js'][] = 'assets/modules/users/js/datatable.js';
        #$this->settings['css'][] = 'assets/css/style.css';
        $this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
        $this->settings['css'][] = 'assets/plugins/morris.js/morris.css';
        $this->settings['css'][] = 'assets/modules/purchase/css/style.css';
        //$this->settings['css'][] = 'assets/modules/inventory/css/style.css';
       // $this->settings['css'][] = 'assets/css/new-style.css';
        $this->scripts['js'][] = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->scripts['js'][] = 'assets/plugins/Chart.js/dist/Chart.min.js';
        $this->scripts['js'][] = 'assets/plugins/raphael/raphael.min.js';
        $this->scripts['js'][] = 'assets/plugins/morris.js/morris.min.js';
        $this->scripts['js'][] = 'assets/plugins/echarts/dist/echarts.min.js';
        $this->scripts['css'][] = 'assets/plugins/font-awesome/css/font-awesome.min.css';
        // for Print JS
        //$this->scripts['js'][] = 'assets/modules/crm/js/print.js';
        //$this->scripts['js'][] = 'assets/modules/purchase/js/graph.js';
        $this->scripts['js'][] = 'assets/plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js';
       # $this->scripts['js'][] = 'assets/modules/inventory/js/script.js';
        $this->scripts['js'][] = 'assets/modules/purchase/js/script.js';
        $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
        #   pre($_SESSION);
        $CI =& get_instance();

        /* child table columns add */

        $CI->createTableColumn('company_detail','po_approve_status',"INT(11) NOT NULL DEFAULT '0' COMMENT '0 = off 1 = on'  AFTER gate_entry_status");
        $CI->createTableColumn('company_detail','po_disapprove_status',"INT(11) NOT NULL DEFAULT '0' COMMENT '0 = off 1 = on'  AFTER gate_entry_status");
        $CI->createTableColumn('company_detail','po_approve_level',"INT(11) NOT NULL DEFAULT '0'  AFTER gate_entry_status");
        $CI->createTableColumn('company_detail','po_approve_users',"TEXT NULL AFTER gate_entry_status");

        $CI->createTableColumn('purchase_order','approve_user_detail',"TEXT NULL AFTER purchase_type");
        $CI->createTableColumn('purchase_order','selectApproveUsers',"TEXT NULL AFTER purchase_type");

        $CI->createTableColumn('mrn_detail','cost_center',"INT(11) NOT NULL DEFAULT '0'  AFTER purchase_type");

        $CI->createTableColumn('purchase_order','open_purchase_from',"VARCHAR(255) NULL DEFAULT NULL  AFTER purchase_type");
        $CI->createTableColumn('purchase_order','open_purchase_to',"VARCHAR(255) NULL DEFAULT NULL  AFTER open_purchase_from");
        $CI->createTableColumn('purchase_order','is_purchase_date',"VARCHAR(255) NULL DEFAULT NULL  AFTER open_purchase_to");
        $CI->createTableColumn('mrn_detail','due_days',"VARCHAR(255) NULL DEFAULT NULL  AFTER cost_center");




        /* parent table columns add */

        $CI->createTableColumnInParent('company_detail','po_approve_status',"INT(11) NOT NULL DEFAULT '0' COMMENT '0 = off 1 = on'  AFTER gate_entry_status");
        $CI->createTableColumnInParent('company_detail','po_disapprove_status',"INT(11) NOT NULL DEFAULT '0' COMMENT '0 = off 1 = on'  AFTER gate_entry_status");
        $CI->createTableColumnInParent('company_detail','po_approve_level',"INT(11) NOT NULL DEFAULT '0'  AFTER gate_entry_status");
        $CI->createTableColumnInParent('company_detail','po_approve_users',"TEXT NULL AFTER gate_entry_status");

        $CI->createTableColumnInParent('purchase_order','approve_user_detail',"TEXT NULL AFTER purchase_type");
        $CI->createTableColumnInParent('purchase_order','selectApproveUsers',"TEXT NULL AFTER purchase_type");

        $CI->createTableColumnInParent('mrn_detail','cost_center',"INT(11) NOT NULL DEFAULT '0'  AFTER purchase_type");
		$CI->createTableColumnInParent('purchase_order','open_purchase_from',"VARCHAR(255) NULL DEFAULT NULL  AFTER purchase_type");
        $CI->createTableColumnInParent('purchase_order','open_purchase_to',"VARCHAR(255) NULL DEFAULT NULL  AFTER open_purchase_from");
		$CI->createTableColumnInParent('purchase_order','is_purchase_date',"VARCHAR(255) NULL DEFAULT NULL  AFTER open_purchase_to");
		$CI->createTableColumnInParent('mrn_detail','due_days',"VARCHAR(255) NULL DEFAULT NULL  AFTER cost_center");
    }

    /*.0*/

    public function createTableColumnInParent($table,$column,$defineColumType){
        $ci =& get_instance();
        //$dynamicdb = $ci->load->database('dynamicdb', TRUE);
        $data = $ci->db->query("SHOW COLUMNS FROM  {$table} LIKE '{$column}'")->row_array();
        if( empty($data) ){
            $ci->db->query("ALTER TABLE {$table}  ADD {$column} {$defineColumType}");
        }
    }

    public function createTableColumn($table,$column,$defineColumType){
        $ci =& get_instance();
        $dynamicdb = $ci->load->database('dynamicdb', TRUE);
        $data = $dynamicdb->query("SHOW COLUMNS FROM  {$table} LIKE '{$column}'")->row_array();
        if( empty($data) ){
            $dynamicdb->query("ALTER TABLE {$table}  ADD {$column} {$defineColumType}");
        }
    }

    public function index() {
        echo $_SERVER['HTTP_HOST'];
        $this->suppliers();
    }
    /***************************************************************Purchase Setting*******************************************************/
    /* fucntion of purchase setting*/
    /* fucntion of purchase setting*/
    public function purchase_setting() {
      /*$this->load->library('pagination');*/
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Purchase setting', base_url() . 'purchase_setting');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Purchase Setting';
        /*$this->load->library('pagination');*/



        if($_GET['start'] != '' && $_GET['end'] != '' ) {
            $where = "(created_by_cid = {$this->companyGroupId} OR material_type.created_by_cid='0') AND material_type.created_date Between '{$_GET['start']}' AND '{$_GET['end']}'";
        }
      if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search']=='') {
            $where = 'material_type.created_by_cid = ' . $this->companyGroupId . ' OR material_type.created_by_cid=0';
        } elseif(isset($_GET["ExportType"])=='' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['search']=='') {
            $where = "(created_by_cid = {$this->companyGroupId} OR material_type.created_by_cid='0') AND material_type.created_date Between '{$_GET['start']}' AND '{$_GET['end']}'";

        } elseif(isset($_GET["ExportType"])!='' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['search']=='') {//echo 'ddfg';die();
            $where = "created_by_cid = " . $this->companyGroupId . " OR material_type.created_by_cid='0' AND  (material_type.created_date >='" . $_GET['start'] . "' AND  material_type.created_date <='" . $_GET['end'] . "') '";

        } elseif(isset($_GET["ExportType"])!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search']!='') {
             $material_type_tt = getNameById('material_type',$_GET['search'],'name');

            if($material_type_tt->id ==''){
                    $where = "material_type.id like '%" . $_GET['search'] . "%'";
            }elseif($material_type_tt->id !=''){
                    $where = "material_type.id like '%" . $material_type_tt->id . "%'";
            }else{
                $where = "material_type.id like '%" . $material_type_tt->id . "%'"; }
        }elseif(isset($_GET["ExportType"])=='' && $_GET['start']== '' && $_GET['end']== '' && $_GET['search']!='') {
                $where = '(material_type.created_by_cid = '.$this->companyGroupId.'  OR material_type.created_by_cid =0)';
        }
        if(empty($_GET)){
                $where = 'material_type.created_by_cid = ' . $this->companyGroupId . ' OR material_type.created_by_cid =0';
        }elseif(!empty($_GET['tab']=='purchase_setting')){
            $where = 'material_type.created_by_cid = ' . $this->companyGroupId . ' OR material_type.created_by_cid =0';
        }elseif(!empty($_GET['tab']=='purchase_budget')){
            $where = 'material_type.created_by_cid = ' . $this->companyGroupId . ' OR material_type.created_by_cid =0';
        }



        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $material_type_tt = getNameById('material_type',$_POST['search'],'name');
            if($material_type_tt->id ==''){
                $where2 = "material_type.id like '%" . $_POST['search'] . "%'";
            }elseif($material_type_tt->id !=''){
                $where2 = "material_type.id like '%" . $material_type_tt->id . "%'";
            }else
            {
                $where2 = "material_type.id like '%" . $material_type_tt->id . "%'";
            }
            redirect("purchase/purchase_setting/?search=$search_string");
        }
        else if(isset($_GET['search'])){
                    $material_type_tt = getNameById('material_type',$_GET['search'],'name');
            if($material_type_tt->id ==''){
                $where2 = "material_type.id like '%" . $_GET['search'] . "%'";
            }elseif($material_type_tt->id !=''){
                $where2 = "material_type.id like '%" . $material_type_tt->id . "%'";
            }else
            {
                $where2 = "material_type.id like '%" . $material_type_tt->id . "%'";
            }
            }

        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = "desc";
        }



        if($_GET['tab']=='purchase_setting' && $_GET['tab']!='purchase_budget'){

            $rows=$this->purchase_model->tot_rows('material_type', $where,$where2);
        }elseif($_GET['tab']=='purchase_budget' && $_GET['tab']!='purchase_setting'){


            $this->data['users'] = $this->purchase_model->twoJoinTables(false,'user.id,user_detail.name','user','user_detail','user_detail.u_id = user.id',"user.c_id = {$this->companyGroupId} AND user.email_status = 'verified'");

            $whereLowBudget = ['budget_type'  => 'lowBudget','created_by_cid'  => $this->companyGroupId ];
            $whereHighBudget = ['budget_type' => 'highBudget','created_by_cid' => $this->companyGroupId ];

            $this->data['lowBudgetUsers']  = $this->purchase_model->getDataByWhereId('purchase_budget_limit',$whereLowBudget);
            $this->data['highBudgetUsers'] = $this->purchase_model->getDataByWhereId('purchase_budget_limit',$whereHighBudget);

        }elseif($_GET['tab']=='purchase_flow_setting'){

            $this->data['notApprovedMaterial'] = $this->purchase_model->approvedMaterial(0);
            $this->data['approvedmaterial'] = $this->purchase_model->approvedMaterial(1);
            $this->data['gateEntry']        = getSingleAndWhere('gate_entry_status','company_detail',['id' => $this->companyGroupId]);

            $po_approve_details  = $this->purchase_model->joinTables('po_disapprove_status,po_approve_status,po_approve_level,po_approve_users','company_detail',[],['id' => $this->companyGroupId]);

             $userSelected  = 'u_id,name';
             $userWhere     = "c_id = {$this->companyGroupId}";
             $this->data['allUsersData'] = $this->purchase_model->joinTables($userSelected,'user_detail',[],$userWhere,['id','desc'],[]);

            if( $po_approve_details ){
                $this->data['po_approve_details'] = $po_approve_details[0];
            }

        }elseif($_GET['tab'] == 'purchase_cost_center'){

            $selectCost = "pcost.*,u.name";
            $whereCost  = "created_by_cid = {$this->companyGroupId}";
            $joinTableCost  = ['user_detail as u' => 'u.u_id = pcost.created_by'];
            $this->data['costCenter'] = $this->purchase_model->joinTables($selectCost,'purchase_cost_center as pcost',$joinTableCost,$whereCost,['id','desc'],[]);
        }elseif($_GET['tab']=='terms_conditions'){
            $this->data['notApprovedMaterial'] = $this->purchase_model->approvedMaterial(0);
            $this->data['approvedmaterial'] = $this->purchase_model->approvedMaterial(1);
            $this->data['gateEntry']        = getSingleAndWhere('gate_entry_status','company_detail',['id' => $this->companyGroupId]);
        }else{
            $rows=$this->purchase_model->tot_rows('material_type', $where,$where2);
        }

        //Pagination

        $config = paginationAttr("purchase/purchase_setting",$rows);
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if(!empty($_GET['ExportType'])){
            $export_data = 1;
        }else{
            $export_data = 0;
        }

        if( $_GET['tab'] != 'purchase_flow_setting' && $_GET['tab'] != 'purchase_cost_center'  && $_GET['tab'] != 'terms_conditions'){

            $this->data['material_type'] = $this->purchase_model->get_data_listing('material_type', $where, $config['per_page'], $page, $where2, $order,$export_data);
            $where2 = " purchase_budget_limit.budget_limit like '%" .$_GET['search'] . "%'";
            $this->data['purchase_budget_limits'] = $this->purchase_model->get_data_listing('purchase_budget_limit', array('created_by_cid' => $this->companyGroupId), $config['per_page'], $page, $where2, $order,$export_data);
        }
        $this->data['update_purchase_setting']  = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId);

        $this->_render_template('purchase_setting/index', $this->data);
    }

    function add_cost_center(){
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        if( $_POST['id'] ){
            $costCenter = $this->purchase_model->joinTables('cost_center_name,id','purchase_cost_center',[],['id' => $_POST['id']]);
            if($costCenter){
                $this->data['costCenter'] = $costCenter[0];
            }
        }
        $this->load->view('purchase_setting/add_cost_center',$this->data);
    }

    function save_cost_center(){
        $data = ['created_by_cid' => $this->companyGroupId,'created_by' => $_SESSION['loggedInUser']->u_id ];
        if( !empty($this->input->post('id')) ){
            $data = $data + ['cost_center_name' => $this->post->input('costCenterName') ];
            $update = $this->purchase_model->updateRowWhere('purchase_cost_center',$data,['id' => $this->input->post('id') ]);
            if($update){
                $this->session->set_flashdata('message','Cost Center Update Successfuly');
            }else{
                $this->session->set_flashdata('message','Something whats wrong.Please try again');
            }
        }else{
            if( count($this->input->post('costCenterName')) > 0 ){
                foreach($this->input->post('costCenterName') as $key => $value){
                    $data = ['cost_center_name' => $value ] + $data;
                    $this->purchase_model->insertData('purchase_cost_center',$data);
                }
                $this->session->set_flashdata('message','Cost Center Add Successfuly');
            }
        }
        redirect('purchase/purchase_setting?tab=purchase_cost_center');
    }

    function deleteCostCenter(){
        $id = $this->uri->segment(2);
        $this->purchase_model->delete_data('purchase_cost_center','id',$id);
        $this->session->set_flashdata('message','Cost Center Delete Successfuly');
        logActivity('delete cost center', 'supplier', $id);
    }

    function userBudgetLimit(){
        if( $_POST['budgetType'] ){
            $setMsg = "";
            $where = ['budget_type' => $_POST['budgetType'],'created_by_cid' => $this->companyGroupId ];
            $rowStatus = $this->purchase_model->getDataByWhereId('purchase_budget_limit',$where);
            $data = [   'budget_type' => $_POST['budgetType'],'budget_limit' => $_POST['bPrice'],
                        'edited_by'    => $_SESSION['loggedInUser']->u_id,'modified_date'  => date('Y-m-d h:s:i') ];
            if( !empty($rowStatus) ){
                $users = [];
                if( $rowStatus[0]['users'] ){
                    $users  = json_decode($rowStatus[0]['users']);
                    $i = count($users);
                }
                foreach ($_POST['bUsers'] as $key => $value) {
                      if( !in_array($value,$users) ){
                        $users = $users + [$i => $value];
                        $i++;
                      }
                }
                $data = $data + [ 'users' => json_encode($users) ];
                $msg = $this->purchase_model->updateRowWhere('purchase_budget_limit',$where,$data);
                if( $msg ){
                    $setMsg = 'Low Budget has been successfuly updated';
                }
            }else{
                $data = $data + [ 'users' => json_encode($_POST['bUsers']),'created_by' => $_SESSION['loggedInUser']->u_id,
                                  'created_by_cid' => $this->companyGroupId ];
                $this->purchase_model->insertData('purchase_budget_limit',$data);
                $setMsg = 'Low Budget has been successfuly inserted';
            }
        }
        if( $setMsg ){
            $this->session->set_flashdata('message',$setMsg);
        }
        echo true;
    }

    function deleteBudgetUser(){
        //pre($_POST);die;
        if( $_POST['id'] ){
            $setMsg = "";
            $where  = ['budget_type' => $_POST['budgetType'],'created_by_cid' => $this->companyGroupId ];
            $rowStatus = $this->purchase_model->getDataByWhereId('purchase_budget_limit',$where);
            if( $rowStatus ){
                $modiUsers = [];
                $users  = json_decode($rowStatus[0]['users']);
                foreach ($users as $key => $value) {
                      if( $value != $_POST['id'] ){
                        $modiUsers[]  = $value;
                      }
                }
                $msg = $this->purchase_model->updateRowWhere('purchase_budget_limit',$where,[ 'users' => json_encode($modiUsers) ] );
                if( $msg ){
                    $setMsg = 'Low Budget User has been successfuly remove';
                }
            }
        }
    }


    public function edit_purchase_budget() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['purchase_budget'] = $this->purchase_model->get_data_byId('material_type', 'id', $id);
        $this->load->view('purchase_setting/edit', $this->data);
    }
    /*save electricyt unit**************/
    public function save_purchase_budget() {
        //pre($_POST);die;
        if ($this->input->post()) {
            $required_fields = array('budget');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $id = $data['id'];
                $data['created_by_cid'] = $this->companyGroupId;
                //$data['created_by'] = $_SESSION['loggedInUser']->u_id ;
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success = $this->purchase_model->update_data('material_type', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Purchase Budget updated successfully";
                        logActivity('Purchase Budget  Updated', 'purchase_budget', $id);
                        $this->session->set_flashdata('message', 'Purchase Budget  Updated successfully');
                        redirect(base_url() . 'purchase/purchase_setting', 'refresh');
                    }
                } /*else{
                $id = $this->purchase_model->insert_tbl_data('purchase_budget',$data);
                if ($id) {
                        logActivity('Purchase Budget  inserted','purchase_budget',$id);
                        $this->session->set_flashdata('message', 'Purchase Budget  inserted successfully');
                redirect(base_url().'purchase/purchase_setting', 'refresh');
                    }  */
            }
        }
    }
    //}
    /*production setting delete*/
    public function delete_budget($id = '') {
        if (!$id) {
            redirect('purchase/purchase_setting', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->purchase_model->delete_data('purchase_budget', 'id', $id);
        if ($result) {
            logActivity('Budget Deleted', 'purchase_budget', $id);
            $this->session->set_flashdata('message', 'Budget Deleted Successfully');
            $result = array('msg' => 'Budget Deleted Successfully', 'status' => 'success', 'code' => 'C142', 'url' => base_url() . 'purchase/purchase_setting');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C2090'));
        }
    }
    public function getBudgetByMaterialTypeId() {
        $id = $_POST['id'];
        $this->data['materialTypeBudget'] = $this->purchase_model->get_budget_accrdng_materialType('material_type', $id);
        echo json_encode($this->data['materialTypeBudget']);
    }
    /*Main fucntion of suppplier listing*/
    public function suppliers() {
         $this->load->helper('url');
         $this->data['can_edit'] = edit_permissions();
         $this->data['can_delete'] = delete_permissions();
         $this->data['can_add'] = add_permissions();
         $this->data['can_view'] = view_permissions();
         $this->breadcrumb->add('Purchase', base_url() . 'purchase/dashboard');
         $this->breadcrumb->add('Dashboard', base_url() . 'purchase/dashboard');
         $this->breadcrumb->add('Supplier', base_url() . 'Suppliers');
         $this->settings['breadcrumbs'] = $this->breadcrumb->output();
         $this->settings['pageTitle'] = 'Suppliers';

          $where = "supplier.created_by_cid = $this->companyGroupId ";
          if( $_GET['favourites'] != "" ){
             $where .= "AND supplier.favourite_sts = 1";
          }
          if( $_GET['start'] != '' && $_GET['end'] != '' ){
            $startDate = date('Y-m-d h:i:s',strtotime($_GET['start']));
            $endDate   = date('Y-m-d h:i:s',strtotime($_GET['end']));
            $where .= "AND (supplier.created_date Between '{$startDate}' AND '{$endDate}') ";
          }
          // if( $_GET['material_type'] ){
             // $searchMetrialType = '"material_type_id":"'.$_GET['material_type'].'"';
             // $where .= " AND supplier.material_name_id LIKE '%$searchMetrialType%'";
          // }
          if( $_GET['material_name'] ){
                $searchMetrialName = '"material_name":"'.$_GET['material_name'].'"';
                $where .= " AND supplier.material_name_id LIKE '%$searchMetrialName%'";
          }
          if( $_GET['search'] ){
            $search = $_GET['search'];
            $where .= " AND (supplier.id = '{$search}' OR supplier.name LIKE '{$search}%' )";
          }
         if (!empty($_GET['order'])) {
            $order = $_GET['order'];
         } else  {
            $order ='desc';
         }

			// pre($where);
			
            $config = paginationAttr("purchase/suppliers",$this->purchase_model->tot_rows('supplier', $where, $where2));
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) :1;

           if(!empty($_GET['ExportType'])){
                $export_data = 1;
            }else{
                $export_data = 0;
            }
            //echo $export_data;die();
           $this->data['suppliers'] = $this->purchase_model->get_data_listing('supplier', $where, $config['per_page'], $page, $where2, $order,$export_data);


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

           $this->_render_template('suppliers/index', $this->data);
    }

    /*suuplier add/edit code*/
    public function supplier_edit() {
        $this->scripts['js'][] = 'assets/modules/purchase/js/test.js';
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['materialsname'] = $this->purchase_model->get_data('material');
        $this->data['idproof'] = $this->purchase_model->get_idproof_by_supplierId('attachments', 'rel_id', $id);
        $this->data['suppliers'] = $this->purchase_model->get_data_byId('supplier', 'id', $id);
        $this->load->view('suppliers/edit', $this->data);
    }
    /*suuplier view code*/
    public function supplier_view() {
        permissions_redirect('is_view');
        $id = $_POST['id'];
        $this->data['idproof'] = $this->purchase_model->get_idproof_by_supplierId('attachments', 'rel_id', $id);
        $this->data['supplier'] = $this->purchase_model->get_data_byId('supplier', 'id', $id);
        $this->load->view('suppliers/view', $this->data);
    }
    public function supplier_mat_view() {
        permissions_redirect('is_view');
        $id = $_POST['id'];
        $this->data['idproofs'] = $this->purchase_model->get_idproof_by_supplierId('attachments', 'rel_id', $id);
        $this->data['supplier'] = $this->purchase_model->get_data_byId('supplier', 'id', $id);
        $this->load->view('suppliers/mat_view', $this->data);
    }
    /*fucntion to save supplier data*/
    public function saveSupplier() {
        if ($this->input->post()) {
            $required_fields = array('name', 'supp_account_group_id', 'mailing_name');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $supplierMaterialDetails = [];
                foreach ($data['supplierMetrial'] as $materialKey => $materialValue) {
                    $supplierMaterialDetails[] = $materialValue;
                }
                $supplierMdata = json_encode($supplierMaterialDetails);

                $data = array_merge($data,['material_name_id' => $supplierMdata]);
                $nameLength = count($_POST['contact_detail']);
                if ($nameLength > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $nameLength) {
                        $jsonArrayObject = (array('contact_detail' => $_POST['contact_detail'][$i], 'email' => $_POST['email'][$i], 'designation' => $_POST['designation'][$i], 'mobile' => $_POST['mobile'][$i]));
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $name_array = json_encode($arr);
                } else {
                    $name_array = '';
                }
                $data['created_by_cid'] = $this->companyGroupId;
                $data['contact_detail'] = $name_array;
                //$data['material_name_id'] = $material_array;
                $id = $data['id'];
                $ledger_id = $_POST['id'];
                $data_for_ledger['supp_id'] = $id;
                $data_for_ledger['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data_for_ledger['created_by_cid'] = $this->companyGroupId;
                $data_for_ledger['name'] = $_POST['name'];
                $data_for_ledger['website'] = $_POST['website'];
                $adress_Data = array('mailing_name' => $_POST['mailing_name'], 'mailing_country' => $_POST['country'], 'mailing_state' => $_POST['state'], 'mailing_city' => $_POST['city'],'mailing_address' => $_POST['address']);
                $for_json = array($adress_Data);
                $descr_of_ldgr_array = json_encode($for_json);
                $data_for_ledger['mailing_address'] = $descr_of_ldgr_array;
                $data_for_ledger['website'] = $_POST['website'];
                $data_for_ledger['gstin'] = $_POST['gstin'];
                $data_for_ledger['account_group_id'] = $_POST['supp_account_group_id'];
                $created_by_id = $_SESSION['loggedInUser']->u_id;
                $dd = $this->purchase_model->get_ledger_account_grp_Dtl('account_group', $created_by_id, $_POST['supp_account_group_id']);
                $data_for_ledger['parent_group_id'] = $dd[0]['parent_group_id'];
                $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 3));
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $checkGstin = $this->purchase_model->gstinExist($_POST['gstin'], 'update');
                    $success = $this->purchase_model->update_data('supplier', $data, 'id', $id);
								$this->purchase_model->update_ledger_data('ledger', $data_for_ledger, 'id', $ledger_id);
                    foreach ($data['supplierMetrial'] as $materialKey => $materialValue) {
                        if ($materialValue['material_type_id'] != '') updateUsedIdStatus('material_type', $materialValue['material_type_id']);
                        if ($materialValue['material_name'] != "") updateMultipleUsedIdStatus('material', $materialValue['material_name']);
                    }
                    if ($data['supp_account_group_id'] != '') updateUsedIdStatus('account_group', $data['supp_account_group_id']);
                    $data['message'] = "Supplier updated successfully";
                    logActivity('supplier Updated', 'supplier', $id);
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                pushNotification(array('subject' => 'Supplier Updated', 'message' => 'Supplier id : #' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'SupplierView', 'icon' => 'fa-shopping-cart'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        pushNotification(array('subject' => 'Supplier Updated', 'message' => 'Supplier id : #' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'SupplierView', 'icon' => 'fa-shopping-cart'));
                    }
                    $this->session->set_flashdata('message', 'Supplier Updated successfully');
                } else {
                    if ($_POST['gstin'] != '') {
                        $checkGstin = $this->purchase_model->gstinExist($_POST['gstin']);
                        $id = $this->purchase_model->insert_tbl_data('supplier', $data);
                        if ($id) {
                            foreach ($data['supplierMetrial'] as $materialKey => $materialValue) {
                                if ($materialValue['material_type_id'] != '') updateUsedIdStatus('material_type', $materialValue['material_type_id']);
                                if ($materialValue['material_name'] != "") updateMultipleUsedIdStatus('material', $materialValue['material_name']);
                            }
                            if ($data['supp_account_group_id'] != '') updateUsedIdStatus('account_group', $data['supp_account_group_id']);
                            $ledger_id = $id;
                            $data_for_ledger['supp_id'] = $ledger_id;
                            $ledgerid = $this->purchase_model->insert_tbl_data('ledger', $data_for_ledger);
                            logActivity('supplier inserted', 'supplier', $id);
                            $this->session->set_flashdata('message', 'Supplier inserted successfully');
                        }
                    } else {
                        $id = $this->purchase_model->insert_tbl_data('supplier', $data);
                        $data_for_ledger['supp_id'] = $id;
                        $ledgerid = $this->purchase_model->insert_tbl_data('ledger', $data_for_ledger);
                        if ($id) {
                            logActivity('supplier inserted', 'supplier', $id);
                            $this->session->set_flashdata('message', 'Supplier inserted successfully');
                        }
                    }
                    if ($id) {
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'New supplier created', 'message' => 'New supplier is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'SupplierView', 'icon' => 'fa-shopping-cart'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'New supplier created', 'message' => 'New supplier is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'SupplierView', 'icon' => 'fa-shopping-cart'));
                        }
                    }
                }
                if ($id) {
                    //echo "heel".$id;die;
                    if (!empty($_FILES['idproof']['name']) && $_FILES['idproof']['name'][0] != '') {
                        $proof_array = array();
                        $proofCount = count($_FILES['idproof']['name']);
                        for ($i = 0;$i < $proofCount;$i++) {
                            $filename = $_FILES['idproof']['name'][$i];
                            $tmpname = $_FILES['idproof']['tmp_name'][$i];
                            $type = $_FILES['idproof']['type'][$i];
                            $error = $_FILES['idproof']['error'][$i];
                            $size = $_FILES['idproof']['size'][$i];
                            $exp = explode('.', $filename);
                            $ext = end($exp);
                            $newname = $exp[0] . '_' . time() . "." . $ext;
                            $config['upload_path'] = 'assets/modules/purchase/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/purchase/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/purchase/uploads/" . $newname);
                            $proof_array[$i]['rel_id'] = $id;
                            $proof_array[$i]['rel_type'] = 'supplier';
                            $proof_array[$i]['file_name'] = $newname;
                            $proof_array[$i]['file_type'] = $type;
                        }
                        if (!empty($proof_array)) {
                            /* Insert file information into the database */
                            $proofId = $this->purchase_model->insert_attachment_data('attachments', $proof_array, 'supplier');
                        }
                    }
                    redirect(base_url() . 'purchase/suppliers', 'refresh');
                }
            }
        }
    }
    /*delete supplier*/
    public function delete_supplier($id = '') {
        //pre($id); die;
        if (!$id) {
            redirect('purchase/suppliers', 'refresh');
        }
        permissions_redirect('is_delete');
        //$result = $this->purchase_model->delete_data('supplier','id',$id);
        $result = $this->purchase_model->delete_data_from_supplierLedger('supplier', 'id', $id);
        $result = $this->purchase_model->delete_data_from_supplierLedger('ledger', 'supp_id', $id);
        if ($result) {
            logActivity('supplier Deleted', 'supplier', $id);
            $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 3));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Supplier deleted', 'message' => 'Supplier id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Supplier deleted', 'message' => 'Supplier id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
            }
            $this->session->set_flashdata('message', 'supplier Deleted Successfully');
            $result = array('msg' => 'supplier Deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'purchase/suppliers');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    public function delete_idproof($id = '', $supplierId = '') {
        if (!$id) {
            redirect('purchase/suppliers', 'refresh');
        }
        $result = $this->purchase_model->delete_data('attachments', 'id', $id);
        if ($result) {
            //logActivity('Supplier Id Proof Deleted', 'supplier', $id);
            $this->session->set_flashdata('message', 'Proof Deleted Successfully');
            // $result = array('msg' => 'Id Proof Deleted Successfully', 'status' => 'success', 'code' => 'C174', 'url' => base_url() . 'purchase/suppliers/supplier_edit/' . $supplierId);
             $result = array('msg' => 'Id Proof Deleted Successfully', 'status' => 'success', 'code' => 'C174', 'url' => base_url() . 'purchase/suppliers/');
            echo json_encode($result);
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }
    /*  /***********************************************************purchase indent**************************************************************/

    /***********************************************************purchase indent**************************************************************/
     public function purchase_indent() {
        /*$this->load->library('pagination');*/
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_validate'] = validate_permissions();
        $this->data['can_validate_purchase_budget_limit'] = validate_purchase_budget_limit_permissions();
        $this->breadcrumb->add('Purchase', base_url() . 'purchase/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'purchase/dashboard');
        $this->breadcrumb->add('Purchase Indent', base_url() . 'purchase_indent');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Purchase Indent';
        $whereMaterialType = "(created_by_cid ='" . $this->companyGroupId . "' OR created_by_cid =0) AND status = 1";
        $this->data['mat_type_ss'] = $this->purchase_model->get_filter_details('material_type', $whereMaterialType);
        $whereCompany = "(id ='" . $this->companyGroupId . "')";
        $this->data['company_unit_adress'] = $this->purchase_model->get_filter_details('company_detail', $whereCompany);
        $material_type_tt = getNameById('material_type',$_GET['search'],'name');
        $searchMetrialType = '"material_type_id":"'.$_GET['material_type'].'"';


        if (isset($_GET['favourites'])) {
            $whereInProcess = "(purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "' AND purchase_indent.favourite_sts = '1'";

            $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.favourite_sts' => 1);
        }
        if ($_GET['dashboard'] == 'dashboard' && $_GET['start'] != '' && $_GET['end'] != '') {
            if ($_GET['label'] == 'Approved') {
                $whereInProcess = " purchase_indent.created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND ( purchase_indent.approve ='1')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
            } elseif ($_GET['label'] == 'Disapproved') {
                $whereInProcess = " purchase_indent.created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND ( purchase_indent.disapprove ='1')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
            } elseif ($_GET['label'] == 'Pending') {
                $whereInProcess = " purchase_indent.created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND ( purchase_indent.approve ='0' AND purchase_indent.disapprove='0')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
            } elseif (isset($_GET['material_type_id']) && $_GET['material_type_id'] != '') {
                $whereInProcess = " purchase_indent.created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND ( purchase_indent.material_type_id = " . $_GET['material_type_id'] . " )";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'material_type_id' => $_GET['material_type_id']);
            } elseif ($_GET['label'] == 'Complete PI' || $_GET['label'] == 'Incomplete PI') {
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' )";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
            } elseif ($_GET['label'] == 'Purchase Indent not converted') {
                $whereInProcess = " purchase_indent.created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND purchase_indent.save_status=1 AND purchase_indent.po_or_not=0";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.save_status' => 1);

            } elseif ($_GET['label'] == 'PoCreated') {
                $whereInProcess = " purchase_indent.created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND purchase_indent.save_status=1 AND purchase_indent.po_or_not=1";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.save_status' => 1);
            }
        } else {

            if (!empty($_GET) && isset($_GET['start']) && isset($_GET['end']) && $_GET["ExportType"] == '' && $_GET["favourites"] == '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND (purchase_indent.created_by_cid = '" . $this->companyGroupId . "' ) AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' )";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } else if (!empty($_GET) && isset($_GET['start']) && isset($_GET['end']) && $_GET["ExportType"]=='' && $_GET["favourites"] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '') {
               $whereInProcess = "(purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "' AND purchase_indent.favourite_sts = '1'";

            $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.favourite_sts' => 1);

            } else if (!empty($_GET) && isset($_GET['start']) && isset($_GET['end']) && $_GET["ExportType"]!='' && $_GET["favourites"] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '') {
               $whereInProcess = "(purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "' AND purchase_indent.favourite_sts = '1'";

            $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.favourite_sts' => 1);

            }
            elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '' && $_GET['start'] != '' && $_GET['end'] != '') {
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%' AND  departments = '" . $_GET['departments'] . "') AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' )AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '' && $_GET['start'] == '' && $_GET['end'] == '') {
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%' AND  departments = '" . $_GET['departments'] . "') AND  ( pay_or_not ='0' AND mrn_or_not = '0' AND po_or_not ='0' ) ";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '' && $_GET['start'] != '' && $_GET['end'] != '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (departments = '" . $_GET['departments'] . "') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '' && $_GET['start'] == '' && $_GET['end'] == '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (departments = '" . $_GET['departments'] . "') AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' )";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } elseif (!empty($_GET) && $_GET['material_type'] != '' && $_GET['departments'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '' && $_GET['start'] != '' && $_GET['end'] != '') {
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' ) AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } elseif (!empty($_GET) && $_GET['material_type'] != '' && $_GET['departments'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '' && $_GET['start'] == '' && $_GET['end'] == '') {
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND  ( pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' )";

                $whereComplete = array('purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
            }
            //Start From Here Status Check
            elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0' AND purchase_indent.approve is NOT NULL AND purchase_indent.disapprove is NOT NULL  AND purchase_indent.save_status ='1') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "' AND purchase_indent.disapprove='0'";

                    $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);

                } elseif ($_GET['status_check'] == 'mrn_or_not') {

                    $whereInProcess = "( purchase_indent.mrn_or_not ='0' AND purchase_indent.po_or_not ='1'  AND purchase_indent.save_status ='1') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1 );
                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "(purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
                if ($_GET['status_check'] == 'po_or_not') {

                    $whereInProcess = "( purchase_indent.po_or_not ='0' AND purchase_indent.approve is NOT NULL AND purchase_indent.disapprove is NOT NULL  AND purchase_indent.save_status ='1') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'AND purchase_indent.disapprove='0'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);

                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0' AND purchase_indent.save_status ='1' AND purchase_indent.approve is NOT NULL AND purchase_indent.disapprove is NOT NULL) AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'AND purchase_indent.disapprove='0'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);

                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);
                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'AND purchase_indent.disapprove='0'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1);

                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] != '' && $_GET['departments'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);

                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] != '' && $_GET['departments'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);
                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] != '' && $_GET['departments'] != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] != '') {
                if ($_GET['status_check'] == 'po_or_not') {

                    $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%')AND  (departments = '" . $_GET['departments'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);

                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND  (departments = '" . $_GET['departments'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND (company_unit ='" . $_GET['company_unit'] . "')  AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] != '' && $_GET['departments'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                //echo "12";
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%')AND  (departments = '" . $_GET['departments'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);
                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND  (departments = '" . $_GET['departments'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);
                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND (company_unit ='" . $_GET['company_unit'] . "') AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] == '' && $_GET['departments'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0')  AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1);
                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);
                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL )  AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] == '' && $_GET['departments'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] != '') {
                if ($_GET['status_check'] == 'po_or_not') {

                    $whereInProcess = "( purchase_indent.po_or_not ='0')  AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);

                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL )  AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] == '' && $_GET['departments'] != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] != '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0')  AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (departments = '" . $_GET['departments'] . "')AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);
                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (departments = '" . $_GET['departments'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL )  AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  (departments = '" . $_GET['departments'] . "') AND  purchase_indent.created_date <='" . $_GET['end'] . "')AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] == '' && $_GET['departments'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0')   AND  (departments = '" . $_GET['departments'] . "')AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);
                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND  (departments = '" . $_GET['departments'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL )   AND  (departments = '" . $_GET['departments'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";
                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] != '' && $_GET['departments'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0')  AND  (departments = '" . $_GET['departments'] . "') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);
                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND  (departments = '" . $_GET['departments'] . "') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);
                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%')  AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            }
            //END Here Status Check
            // start here company unit code///
            elseif (!empty($_GET) && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] == '' && $_GET['end'] == '') {
                //pre($_GET);die();
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "')";

                $whereComplete = array('purchase_indent.company_unit ' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);



            } elseif (!empty($_GET) && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] != '' && $_GET['end'] != '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit ' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] == '' && $_GET['end'] == '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND  (departments ='" . $_GET['departments'] . "') ";

                $whereComplete = array('purchase_indent.company_unit ' => $_GET['company_unit'], 'purchase_indent.departments ' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] != '' && $_GET['end'] != '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND (departments ='" . $_GET['departments'] . "') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit ' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.departments ' => $_GET['departments']);

            } elseif (!empty($_GET) && $_GET['departments'] == '' && $_GET['material_type'] != '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] != '' && $_GET['end'] != '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.company_unit ' => $_GET['company_unit']);

            } elseif (!empty($_GET) && $_GET['departments'] == '' && $_GET['material_type'] != '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] == '' && $_GET['end'] == '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') ";

                $whereComplete = array('purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.company_unit ' => $_GET['company_unit']);

            } elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] == '' && $_GET['end'] == '') {

                 $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND (departments ='" . $_GET['departments'] . "')";

                $whereComplete = array('purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.departments ' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.company_unit ' => $_GET['company_unit']);

            } elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] != '' && $_GET['end'] != '') {

                 $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND (departments ='" . $_GET['departments'] . "') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.departments ' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.company_unit ' => $_GET['company_unit']);

            } elseif (empty($_GET['tab'])) {

                $whereInProcess = "( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' AND purchase_indent.mrn_or_not = '0' OR  purchase_indent.pay_or_not ='0' OR  purchase_indent.mrn_or_not = '0' ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                 $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            }elseif (!empty($_GET['search'])) {

                    $s = $_GET['search'];
 /*                   $materialName=getNameById('material',$_GET['search'],'material_name');
                    $material_type_tt = getNameById('material_type',$_GET['search'],'name');*/
                /*$materialName->id = "";$material_type_tt->id ='';
                if($materialName->id == '' && $material_type_tt->id ==''){
                    $where_serach = "CONCAT(purchase_indent.id, purchase_indent.indent_code) like '%" . $_GET['search'] . "%'";
                }elseif($materialName->id != '' && $material_type_tt->id ==''){
                    $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                    $where_serach = "json_contains(`material_name`, '".$json_dtl."')" ;
                }elseif($material_type_tt->id !=''){
                    $json_dtl ='{"material_type_id" : "'.$materialName->id.'"}';
                    $where_serach = "json_contains(`material_name`, '".$json_dtl."')" ;
                }*/

                    $where_serach = " (purchase_indent.id LIKE '%{$s}%' OR purchase_indent.indent_code LIKE '%{$s}%') ";
                    $whereComplete = array($where_serach,'purchase_indent.created_by_cid' =>$this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

                  $whereInProcess = $where_serach." AND ( purchase_indent.pay_or_not ='0' OR purchase_indent.mrn_or_not = '0' OR purchase_indent.mrn_or_not = '0'  ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                 /* pre($whereComplete);
                  pre($whereInProcess);
                  die('lkjlkj');*/

            }elseif (!empty($_GET['tab'] == 'complete')) {

                $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
            }elseif (!empty($_GET['tab'] == 'inprocess')) {


                $whereInProcess = "( purchase_indent.pay_or_not ='0' OR purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";
            }
              if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit']!= '' && $_GET['material_type'] == '' && $_GET['search'] == '' && $_GET['favourites'] == '' && $_GET['status_check'] == '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') ";

                $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId,   'purchase_indent.company_unit ' => $_GET['company_unit']);
            }
                if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['search'] == '' && $_GET['favourites'] == '' && $_GET['status_check'] == ''&& $_GET['company_unit']== '' ) {


              if($_GET['tab'] == 'complete'){
                 $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
              }else {

                 $whereInProcess = "( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0'  AND purchase_indent.po_or_not = '0' ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";
              }
              //die('fdf');
             } elseif (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['search'] == ''&& $_GET['favourites'] == '' && $_GET['status_check'] == '') {

                if($_GET['tab'] == 'complete'){
                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
                }else{
                    $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (departments = '" . $_GET['departments'] . "') AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' AND purchase_indent.po_or_not = '0')";
                }
            } elseif (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] != '' && $_GET['search'] == ''&& $_GET['favourites'] == '' && $_GET['status_check'] == '') {


            if($_GET['tab'] == 'complete'){

                    $whereComplete = array('purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
                 }else{

                    $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' AND purchase_indent.po_or_not ='0' )";
                }//die();
            } elseif (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['search'] == ''&& $_GET['favourites'] == '' && $_GET['status_check'] == '') {

                if($_GET['tab'] =='complete'){
                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%", 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
                }else{
                    //echo 'there';die();
                    $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%' AND  departments = '" . $_GET['departments'] . "') AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0'  AND purchase_indent.po_or_not = '0' )";
                }
            } elseif (isset($_GET["ExportType"]) && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['search'] == ''&& $_GET['favourites'] == '' && $_GET['status_check'] == '') {

                 $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND (purchase_indent.created_by_cid = '" . $this->companyGroupId . "' ) AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0'  AND purchase_indent.po_or_not ='0' )";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            }elseif (isset($_GET["ExportType"])!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['search'] == ''&& $_GET['favourites'] == '' && $_GET['status_check'] != '') {

            }elseif (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['search'] != ''&& $_GET['favourites'] == '' && $_GET['status_check'] == '') {
                $s = $_GET['search'];

                $materialName=getNameById('material',$_GET['search'],'material_name');
                $material_type_tt = getNameById('material_type',$_GET['search'],'name');

                //if($materialName->id == '' && $material_type_tt->id ==''){
                    //$where_serach = "CONCAT(purchase_indent.id, purchase_indent.indent_code) like '%" . $_GET['search'] . "%'";
                /*}elseif($materialName->id != '' && $material_type_tt->id ==''){
                    $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                    $where_serach = "json_contains(`material_name`, '".$json_dtl."')" ;
                }elseif($material_type_tt->id !=''){
                    $json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                    $where_serach = "json_contains(`material_name`, '".$json_dtl."')" ;
                }*/
                $s = $_GET['search'];
                $where_search = " (purchase_indent.id LIKE '%{$s}%' OR purchase_indent.indent_code LIKE '%{$s}%') ";
                if($_GET['tab'] =='complete'){
                    $whereComplete = array($where_search,'purchase_indent.created_by_cid' =>$this->companyGroupId);
                }else{
                    $whereInProcess = " ".$where_search." AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";
                    //pre($whereInProcess);
                }

            }elseif ($_GET["ExportType"]=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['search'] != ''&& $_GET['favourites'] == '' && $_GET['status_check'] == '') {

                /*$materialName=getNameById('material',$_GET['search'],'material_name');
                $material_type_tt = getNameById('material_type',$_GET['search'],'name');*/

                /*if($materialName->id == '' && $material_type_tt->id ==''){*/

                    //$where_serach = "CONCAT(purchase_indent.id, purchase_indent.indent_code) like '%" . $_GET['search'] . "%'";
                /*}elseif($materialName->id != '' && $material_type_tt->id ==''){
                    $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                    $where_serach = "json_contains(`material_name`, '".$json_dtl."')" ;
                }elseif($material_type_tt->id !=''){
                    $json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                    $where_serach = "json_contains(`material_name`, '".$json_dtl."')" ;
                }*/

                $s = $_GET['search'];
                $where_search = " purchase_indent.id LIKE '%{$s}%' OR purchase_indent.indent_code LIKE '%{$s}%' ";
                if($_GET['tab'] =='complete'){
                  $whereComplete = array($where_search,'purchase_indent.created_by_cid' =>$this->companyGroupId,'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
                }else{
                  $whereInProcess = " ".$where_search." AND ( purchase_indent.pay_or_not ='0' OR purchase_indent.mrn_or_not = '0'  OR purchase_indent.po_or_not = '0' ) OR purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";
                }
            }
        }
        //Search
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            //$materialName=getNameById('material',$search_string,'material_name');
            /*if($materialName->id == ''){
                $s = $_GET['search'];
                $where2 = " purchase_indent.id LIKE '%{$s}%' OR purchase_indent.indent_code LIKE '%{$s}%' ";*/
                //$where2 = 'CONCAT(purchase_indent.id, purchase_indent.indent_code) like "%' . $search_string . '%"' ;
            /*}elseif($materialName->id != ''){
                $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                $where2 = "json_contains(`material_name`, '".$json_dtl."')" ;
            }elseif($material_type_tt->id !=''){
                $json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                $where2 = "json_contains(`material_name`, '".$json_dtl."')" ;
            }*/
            $s = $_GET['search'];
            $where2 = " purchase_indent.id LIKE '%{$s}%' OR purchase_indent.indent_code LIKE '%{$s}%' ";
            redirect("purchase/purchase_indent/?search=$search_string");
        }else if($_GET['search'] != ''){
            $materialName=getNameByIdLIKE('material',$_GET['search'],'material_name');
            $material_type_tt = getNameByIdLIKE('material_type',$_GET['search'],'name');

            //if($materialName->id == '' && $material_type_tt->id ==''){
              /*  $json_dtl_mname ='{"material_name_id" : "'.$materialName->id.'"}';
                $mname = "json_contains(`material_name`, '".$json_dtl_mname."')" ;
                $json_dtltype ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                $mnametype = "json_contains(`material_name`, '".$json_dtltype."')" ;*/
                //$where2 = "CONCAT(purchase_indent.id, purchase_indent.indent_code) like '%" . $_GET['search'] . "%' OR ".$mname." OR ".$mnametype." ";

                 /*$mat_name  = '%"material_name_id":"'.$materialName->id.'"%';
                 $mat_type_name  = '%"material_type_id":"'.$material_type_tt->id.'"%'; */

                $s = $_GET['search'];
                $where2 = " purchase_indent.id LIKE '%{$s}%' OR purchase_indent.indent_code LIKE '%{$s}%'";
/*
                 $where2 = "CONCAT(purchase_indent.id, purchase_indent.indent_code) like '%" . $_GET['search'] . "%' OR `material_name` LIKE  '". $mat_name ."' OR `material_name` LIKE  '". $mat_type_name ."'";*/


            //}elseif($materialName->id != '' && $material_type_tt->id ==''){
                //$json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                //$where2 = "json_contains(`material_name`, '".$json_dtl."')" ;
            //}elseif($material_type_tt->id !=''){
                //$json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                //$where2 = "json_contains(`material_name`, '".$json_dtl."')" ;
            //}
        }
        //
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = "desc";
        }

        if( !empty($_GET['purchase_type']) ){
            if( $_GET['purchase_type'] == 2 ){
                $_GET['purchase_type'] = 0;
            }
            if( $whereInProcess ){
              $whereInProcess  = str_replace("AND  (purchase_indent.created_date >='' AND  purchase_indent.created_date <='')", "",$whereInProcess);
              $whereInProcess .= " AND purchase_indent.purchase_type = {$_GET['purchase_type']}";
            }
            if( $whereComplete ){
                foreach ($whereComplete as $key => $value) {
                    if( !empty($whereComplete[$key]) ){
                        $whereComplete[$key] = $value;
                    }else{
                        unset($whereComplete[$key]);
                    }
                }
                $whereComplete = array_merge($whereComplete,['purchase_indent.purchase_type' => $_GET['purchase_type'] ]);
            }
        }

        if( $_GET['tab']=='complete' ){
            $rows=$this->purchase_model->tot_rows('purchase_indent', $whereComplete, $where2);
        }

        if($_GET['tab']=='complete' && $_GET['tab']!='inprocess'){
        }elseif($_GET['tab']=='inprocess' && $_GET['tab']!='complete'){
            /*pre($whereInProcess);
            pre($where2);*/
            $rows=$this->purchase_model->tot_rows('purchase_indent', $whereInProcess, $where2);
        }else{
            $rows=$this->purchase_model->tot_rows('purchase_indent', $whereInProcess, $where2);
            //$rows=$this->purchase_model->tot_rows('purchase_indent', $whereInProcess, $where2);
        }

        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "purchase/purchase_indent";
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
        //$where2 = " purchase_indent.id like '%" .$_GET['search']. "%'";
        //$where2 = "CONCAT(purchase_indent.id, purchase_indent.indent_code) like '%" . $_GET['search'] . "%'";


        if(!empty($_GET['ExportType'])){
            $export_data = 1;
        }else{
            $export_data = 0;
        }

/*        if( $_GET['tab']=='complete' ){
            $dataBySelection = $whereComplete;
            $dataArrayType = "indent";
        }elseif($_GET['tab']=='inprocess'){
            $dataBySelection = $whereInProcess;
            $dataArrayType = "purchase_indent_inProcess";
        }else{
            redirect('purchase/purchase_indent?tab=inprocess');
        }*/
      /*  $this->data[$dataArrayType] = $this->purchase_model->get_data_listing('purchase_indent',$dataBySelection, $config["per_page"], $page, $where2, $order,$export_data);*/



       if($_GET['tab']=='complete' && $_GET['tab'] !='inprocess'){
            $this->data['indent'] = $this->purchase_model->get_data_listing('purchase_indent', $whereComplete, $config["per_page"], $page, $where2, $order,$export_data);
        }elseif($_GET['tab']=='inprocess' && $_GET['tab'] !='complete'){


            $this->data['purchase_indent_inProcess'] = $this->purchase_model->get_data_listing('purchase_indent', $whereInProcess, $config["per_page"], $page, $where2, $order,$export_data);
            //pre($this->data['purchase_indent_inProcess']);die();
        }
        else{
            //pre($_GET);die('else');
            $this->data['indent'] = $this->purchase_model->get_data_listing('purchase_indent', $whereComplete, $config["per_page"], $page, $where2, $order,$export_data);

            $this->data['purchase_indent_inProcess'] = $this->purchase_model->get_data_listing('purchase_indent', $whereInProcess, $config["per_page"], $page, $where2, $order,$export_data);
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

        $this->_render_template('purchase_indent/index', $this->data);
    }


    /*function to add/edit data*/
    function getWorkOrder(){
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $selected   = 'id,work_order_no';
        $where      = "created_by_cid = {$this->companyGroupId} AND material_name != ''";
        $data       = $this->purchase_model->joinTables($selected,'work_order',[],$where,['id','desc'],[]);
        $html       = "<option value=''>Select work_order</option>";
        if( $data ){
            foreach ($data as $key => $value) {
                $html .= "<option value='{$value['id']}'>{$value['workorder_name']} ({$value['work_order_no']})</option>";
            }
        }
        return $html;
    }
    public function indent_edit() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $data_get_for_docss = array('purchase_indent.id' => $id, 'purchase_indent.save_status' => 1);
        $docs_data = $this->purchase_model->get_data('purchase_indent', $data_get_for_docss);
        if ($docs_data[0]['pi_id'] != 0) {
            $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $docs_data[0]['pi_id']);
            //For Document Attachment fetch
        } else {
            $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $id); //For Document Attachment fetch

        }

        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['indents'] = $this->purchase_model->get_data_byId('purchase_indent', 'id', $id);

        if (!empty($this->data['indents'])) $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material', 'material_type_id', $this->data['indents']->material_type_id);

        $this->data['sale_order'] = $this->getAllSaleOrder($this->data['indents']->sale_order_id);

        $this->load->view('purchase_indent/edit', $this->data);
    }
    /* Delete Docs function*/
    public function delete_doccs($id = '', $docsId = '') {
        if (!$id) {
            redirect('purchase/purchase_indent', 'refresh');
        }
        $result = $this->purchase_model->delete_data('attachments', 'id', $id);
        if ($result) {
            logActivity('Document Deleted Successfully', 'PI_PO_MRN', $id);
            $this->session->set_flashdata('message', 'Document Deleted Successfully');
            echo json_encode(array('msg' => 'success', 'status' => 'success', 'code' => 'C1004','url' => ""));
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }
    /*function to view data*/
    public function indent_view() {
        $id = $_POST['id'];
        permissions_redirect('is_view');
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['indents'] = $this->purchase_model->get_data_byId('purchase_indent', 'id', $id);
        $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $id);
        /*if(!empty($this->data['indents']))
         $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material' ,'material_type', $this->data['indents']->material_type);*/
        //Code For Change Status*/
        $this->data['indents'] = $this->purchase_model->get_data_byId('purchase_indent', 'id', $id);
        $wherePo = array('purchase_order.pi_id' => $id, 'purchase_order.save_status' => 1);
        $this->data['po'] = $this->purchase_model->get_data('purchase_order', $wherePo);
        $get_po_or_pi_id = array('purchase_order.pi_id' => $id, 'purchase_order.save_status' => 1);
        $get_po_data = $this->purchase_model->get_data('purchase_order', $get_po_or_pi_id);
        if (!empty($get_po_data)) {
            $whereMrn = array('mrn_detail.po_id' => $get_po_data[0]['id'], 'mrn_detail.save_status' => 1);
        } else {
            $whereMrn = array('mrn_detail.pi_id' => $id, 'mrn_detail.save_status' => 1);
        }
        $this->data['mrn'] = $this->purchase_model->get_data('mrn_detail', $whereMrn);
        //Code For Change Status*/
        $this->load->view('purchase_indent/view', $this->data);
    }
     public function indent_Material_view() {
        $id = $_POST['id'];
        permissions_redirect('is_view');
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['indents'] = $this->purchase_model->get_data_byId('purchase_indent', 'id', $id);
        $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $id);
        /*if(!empty($this->data['indents']))
         $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material' ,'material_type', $this->data['indents']->material_type);*/
        //Code For Change Status*/
        $this->data['indents'] = $this->purchase_model->get_data_byId('purchase_indent', 'id', $id);
        $wherePo = array('purchase_order.pi_id' => $id, 'purchase_order.save_status' => 1);
        $this->data['po'] = $this->purchase_model->get_data('purchase_order', $wherePo);
        $get_po_or_pi_id = array('purchase_order.pi_id' => $id, 'purchase_order.save_status' => 1);
        $get_po_data = $this->purchase_model->get_data('purchase_order', $get_po_or_pi_id);
        if (!empty($get_po_data)) {
            $whereMrn = array('mrn_detail.po_id' => $get_po_data[0]['id'], 'mrn_detail.save_status' => 1);
        } else {
            $whereMrn = array('mrn_detail.pi_id' => $id, 'mrn_detail.save_status' => 1);
        }
        $this->data['mrn'] = $this->purchase_model->get_data('mrn_detail', $whereMrn);
        //Code For Change Status*/
        $this->load->view('purchase_indent/mat_view', $this->data);
    }
    /*fucntion to save indent data*/
    public function saveIndent() {

        $approved = "";
        $work_order_id=$_POST['sale_order_id'];
        $successss = $this->purchase_model->update_data('work_order', ['work_order_material_status' => '3' ], 'id', $work_order_id);


        $material_count = count($_POST['material_name']);
        $matApproveData = [];
        if ($material_count > 0 && $_POST['material_name'][0] != '') {
            $arr = [];
            $i = 0;
            while ($i < $material_count) {

                $str_descr = '""'.$_POST['description'][$i].'""';
                $str_descr = str_replace('"', '', $str_descr);
                if( !empty($_POST['material_type_id'][$i]) ){
                    $matApproveData[] = $_POST['material_type_id'][$i];
                }
                $jsonArrayObject = (array('material_type_id' => $_POST['material_type_id'][$i],'material_name_id' => $_POST['material_name'][$i],'hsnCode' => $_POST['hsnCode'][$i],'hsnId' => $_POST['hsnId'][$i],'discount' => $_POST['discount'][$i],'description' => $str_descr, 'quantity' => $_POST['quantity'][$i], 'uom' => $_POST['uom'][$i], 'expected_amount' => $_POST['expected_amount'][$i], 'purpose' => $_POST['purpose'][$i], 'sub_total' => $_POST['sub_total'][$i],'remaning_qty' => $_POST['quantity'][$i],'aliasname' => $_POST['aliasname'][$i]));
                $arr[$i] = $jsonArrayObject;
                $i++;
            }
            //remaning_qty ==> if remaning_qty is 0 means its complete PI
            $material_array = json_encode($arr);
        } else {
            $material_array = '';
        }

        /*pre($arr);die*/

        if( count($matApproveData ) > 0 ){
            if($this->purchase_model->checkApprovematerial(array_filter($matApproveData))){
                 $approved = 1;
            }
        }

        if ($this->input->post()) {
            $required_fields = array('required_date', 'material_name');
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
                $data['created_by_cid'] = $this->companyGroupId;
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
                    $work_order_id=$_POST['sale_order_id'];
        $successss = $this->purchase_model->update_data('work_order',['work_order_material_status' => '3' ], 'id', $work_order_id);

                    if( !empty($approved) ){
                        $data = array_merge($data,['approve' => 1]);
                    }
                    $id = $this->purchase_model->insert_tbl_data('purchase_indent', $data);
                    if ($id) {
                        if (!empty($arr)) {
                            foreach ($arr as $res) {
                                $this->purchase_model->update_single_value_data('material', array('cost_price' => $res['expected_amount']), array('id' => $res['material_name_id'], 'created_by_cid' => $this->companyGroupId));
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
                            /* Insert file information into the database */
                            $proofId = $this->purchase_model->insert_attachment_data('attachments', $proof_array, 'PI_PO_MRN');
                        }
                    }
                }
                redirect(base_url() . 'purchase/purchase_indent', 'refresh');
            }
        }
    }
    /*delete indent*/
    public function delete_indent($id = '') {
        if (!$id) {
            redirect('purchase/purchase_indent', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->purchase_model->delete_data('purchase_indent', 'id', $id);
        if ($result) {
            logActivity('indent Deleted', 'purchase_indent', $id);
            $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Purchase indent deleted', 'message' => 'Purchase indent id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Purchase indent deleted', 'message' => 'Purchase indent id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
            }
            $this->session->set_flashdata('message', 'indent Deleted Successfully');
            $result = array('msg' => 'indent Deleted Successfully', 'status' => 'success', 'code' => 'C142', 'url' => base_url() . 'purchase/purchase_indent');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }
    /************************************************************other code*********************************************************************/
    /*GEt Material type*/
    public function Get_matrial_type() {
        //pre($_POST['user_id']);
        if ($_POST['mat_id'] != '') {
            $get_data = $this->purchase_model->get_data_material_type('material_type', 'id', $_POST['mat_id']);
            echo json_encode($get_data, true);
            die;
        }
    }
    public function add_matrial_Details_onthe_spot() {


        $material_name    = $_REQUEST['material_name'];
        $hsn_code         = $_REQUEST['hsn_code'];
        //$product_code     = str_replace(" ","",$_REQUEST['product_code']);
        $uom              = $_REQUEST['uom'];
        $specification    = $_REQUEST['specification'];
        $opening_balance  = $_REQUEST['opening_balance'];
        $material_type_id = $_REQUEST['material_type_id'];
        $prefix           = $_REQUEST['prefix'];
        $created_by_id    = $_SESSION['loggedInUser']->u_id;
        $tax              = $_REQUEST['tax'];
        $created_by_cid   = $this->companyGroupId;
        $last_id          = getLastTableId('material');
        $rId              = $last_id + 1;
        $matCode          = 'MAT_' . rand(1, 1000000) . '_' . $rId;
        $matrial_details  = array('material_name' => $material_name, 'hsn_code' => $hsn_code, 'uom' => $uom, 'specification ' => $specification,
                                    'created_by ' => $created_by_id,'opening_balance ' => $opening_balance, 'material_type_id ' => $material_type_id,
                                    'prefix ' => $prefix, 'material_code ' => $matCode, 'created_by ' => $created_by_id,
                                    'created_by_cid ' => $created_by_cid,'tax' => $tax);
        $data2 = $this->purchase_model->insert_on_spot_tbl_data('material', $matrial_details);
        if ($data2 > 0) {
            $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 4));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'New material created', 'message' => 'New material is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $data2, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa-paper-plane-o'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'New material created', 'message' => 'New material is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $data2, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa-paper-plane-o'));
            }
            echo 'true';
        } else {
            echo 'false';
        }
    }

      public function add_lot_Details_onthe_spot() {
        #pre($_SESSION);
        $lotno = $_REQUEST['lotno'];
        $material_type = $_REQUEST['material_type'];
        $material_name = $_REQUEST['material_name'];
        $mou_price = $_REQUEST['mou_price'];
        $mrp_price = $_REQUEST['mrp_price'];
        $date = $_REQUEST['date'];
        $created_by_id = $_SESSION['loggedInUser']->u_id;
        $created_by_cid = $this->companyGroupId;

        $matrial_details = array('lot_number' => $lotno, 'mat_type_id' => $material_type, 'mat_id' => $material_name, 'mou_price ' => $mou_price, 'created_by ' => $created_by_id,'mrp_price ' => $mrp_price, 'date ' => $date,'created_by_cid ' => $created_by_cid);

        $data2 = $this->purchase_model->insert_on_spot_tbl_data('lot_details', $matrial_details);
        if ($data2 > 0) {
            $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 4));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        #pushNotification(array('subject'=> 'New material created' , 'message' => 'New material is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id ,'to_id' => $userViewPermission['user_id'], 'ref_id'=> $data2, 'class'=>'inventory_tabs','data_id' => 'material_view','icon'=>'fa-paper-plane-o'));
                        #pushNotification(array('subject'=> 'New material created' , 'message' => 'New material is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->id ,'to_id' => $userViewPermission['user_id'], 'ref_id'=> $data2, 'class'=>'inventory_tabs','data_id' => 'material_view','icon'=>'fa-paper-plane-o'));
                       pushNotification(array('subject' => 'Inventory Lot Updated', 'message' => 'Inventory Lot Updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $data2 . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $data2));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Inventory Lot Updated', 'message' => 'Inventory Lot Updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $data2 . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $data2));
            }
            echo 'true';
        } else {
            echo 'false';
        }
    }


    /*function through ajax call*/
    public function get_material_name() {
        $this->data['material'] = $this->purchase_model->get_data('material', array('material_type_id' => $_POST['material_id']));
        echo json_encode($this->data['material']);
    }
    /*Function for datatable pagination    */
    public function pagination_data() {
        echo json_encode(user_tbl_data());
        die;
    }
    // Approve Indent Order by Select record
    public function approveIndentOrderbyselectrecord() {
        if ($_POST['nameAttributeId'] && $_POST['nameAttributeId'] != '') {
            $id = $this->input->get_post('id');
            $approve = $this->input->get_post('approve');
            $validated_by = $this->input->get_post('validated_by');
            $disapprove_reason = "";
            $disapprove = "0";
            $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));
            foreach ($id as $key) {
                $data = array('id' => $key, 'approve' => $_POST['approve'], 'validated_by' => $_POST['validated_by'], 'disapprove_reason' => '', 'disapprove' => 0);
                $result = $this->purchase_model->approveSaleOrder($data);
                logActivity('Purchase indent approved', 'purchase_indent', $key);
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array('subject' => 'Purchase indent approved', 'message' => 'Purchase indent is approved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'indentView', 'icon' => 'fa-shopping-cart'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Purchase indent approved', 'message' => 'Purchase indent is approved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'indentView', 'icon' => 'fa-shopping-cart'));
                }
            }
            if ($result) {
                logActivity('Purchase indent approved', 'purchase_indent', $key);
                $this->session->set_flashdata('message', 'Purchase indent approved');
                $result = array('msg' => 'Sale order approved', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'purchase/purchase_indent');
                echo json_encode($result);
                die;
            } else {
                echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
            }
        }
    }
    /*approve indent*/
    public function approveIndentOrder() {
        if ($_POST['id'] && $_POST['id'] != '') {
            $data = array('approve' => $_POST['approve'], 'validated_by' => $_POST['validated_by'], 'disapprove_reason' => '', 'disapprove' => 0);
            $result = $this->purchase_model->approveSaleOrder($_POST);
            if ($result) {
                logActivity('Indent order approved', 'purchase_indent', $_POST['id']);
                $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array('subject' => 'Purchase indent approved', 'message' => 'Purchase indent id :# ' . $_POST["id"] . ' is approved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $_POST['id'], 'class' => 'add_purchase_tabs', 'data_id' => 'indentView', 'icon' => 'fa-shopping-cart'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Purchase indent approved', 'message' => 'Purchase indent id :# ' . $_POST["id"] . ' is approved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $_POST['id'], 'class' => 'add_purchase_tabs', 'data_id' => 'indentView', 'icon' => 'fa-shopping-cart'));
                }
                $this->session->set_flashdata('message', 'Indent approved');
                $result = array('msg' => 'Indent approved', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'purchase/purchase_indent');
                echo json_encode($result);
                die;
            } else {
                echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
            }
        }
    }
	/* Approve Purchase Order*/
	 public function approvePurchaseOrder() {
        if ($_POST['id'] && $_POST['id'] != '') {
            $data = array('approve' => $_POST['approve'], 'validated_by' => $_POST['validated_by'], 'disapprove_reason' => '', 'disapprove' => 0);
            $result = $this->purchase_model->approvePurchaseOrder($_POST);
            if ($result) {
                logActivity('Purchase order approved', 'purchase_order', $_POST['id']);
                $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array('subject' => 'Purchase order approved', 'message' => 'Purchase order id :# ' . $_POST["id"] . ' is approved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $_POST['id'], 'class' => 'add_purchase_tabs', 'data_id' => 'OrderView', 'icon' => 'fa-shopping-cart'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Purchase order approved', 'message' => 'Purchase order id :# ' . $_POST["id"] . ' is approved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $_POST['id'], 'class' => 'add_purchase_tabs', 'data_id' => 'OrderView', 'icon' => 'fa-shopping-cart'));
                }
                $this->session->set_flashdata('message', 'order approved');
                $result = array('msg' => 'order approved', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'purchase/purchase_order');
                echo json_encode($result);
                die;
            } else {
                echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
            }
        }
    }
	public function disApprovePorder() {
        if ($this->input->post()) {
            $required_fields = array('disapprove_reason');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $idss1 = $_POST['id'];
                $id = explode(",", $idss1);
                $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));
                foreach ($id as $key) {
                    $data = array('id' => $key, 'validated_by' => $_POST['validated_by'], 'disapprove' => $_POST['disapprove'], 'approve' => $_POST['approve'], 'disapprove_reason' => $_POST['disapprove_reason']);
                    $success = $this->purchase_model->disApprovePurchaseOrder($data);
                    logActivity('Purchase Order Disapproved', 'purchase_order', $key);
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                pushNotification(array('subject' => 'Purchase Order disapproved', 'message' => 'Purchase Order id :# ' . $key . ' is disapproved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $key, 'class' => 'add_purchase_tabs', 'data_id' => 'OrderView', 'icon' => 'fa-shopping-cart'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        pushNotification(array('subject' => 'Purchase Order disapproved', 'message' => 'Purchase Order id :# ' . $key . ' is disapproved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $key, 'class' => 'add_purchase_tabs', 'data_id' => 'OrderView', 'icon' => 'fa-shopping-cart'));
                    }
                }
                if ($success) {
                    $data['message'] = "Purchase Order Disapproved";
                    $this->session->set_flashdata('message', 'Purchase Order Disapproved successfully');
                    redirect(base_url() . 'purchase/purchase_order', 'refresh');
                }
            }
        }
    }
	
	
	
	
	
	
	/* Approve Purchase Order*/
	
	
	
    /* disapprove rfq*/
     public function disApproveRFQ() {
        if ($this->input->post()) {
            $required_fields = array('disapprove_reason');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $idss1 = $_POST['id'];
                $id = explode(",", $idss1);
                $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));
                foreach ($id as $key) {
                    $data = array('id' => $key, 'validated_by' => $_POST['validated_by'], 'disapprove' => $_POST['disapprove'], 'approve' => $_POST['approve'], 'disapprove_reason' => $_POST['disapprove_reason']);
                    $success = $this->purchase_model->disApproveSaleOrder($data);
                    logActivity('Indent Disapproved', 'purchasE_rfq', $key);
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                pushNotification(array('subject' => 'Purchase indent disapproved', 'message' => 'Purchase indent id :# ' . $key . ' is disapproved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $key, 'class' => 'add_purchase_tabs', 'data_id' => 'indentView', 'icon' => 'fa-shopping-cart'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        pushNotification(array('subject' => 'Purchase rfq disapproved', 'message' => 'Purchase rfq id :# ' . $key . ' is disapproved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $key, 'class' => 'add_purchase_tabs', 'data_id' => 'indentView', 'icon' => 'fa-shopping-cart'));
                    }
                }
                if ($success) {
                    $data['message'] = "RFQ Disapproved";
                    //  logActivity('Idnent Disapproved','purchasE_indent',$id);
                    //pushNotification(array('subject'=> 'Purchase indent disapproved' , 'message' => 'Purchase indent disapproved by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'ref_id'=> $id));
                    $this->session->set_flashdata('message', 'RFQ Disapproved successfully');
                    redirect(base_url() . 'purchase/purchase_rfq', 'refresh');
                }
            }
        }
    }
    /*disarppove indent*/
    public function disApproveIndent() {
        if ($this->input->post()) {
            $required_fields = array('disapprove_reason');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $idss1 = $_POST['id'];
                $id = explode(",", $idss1);
                $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));
                foreach ($id as $key) {
                    $data = array('id' => $key, 'validated_by' => $_POST['validated_by'], 'disapprove' => $_POST['disapprove'], 'approve' => $_POST['approve'], 'disapprove_reason' => $_POST['disapprove_reason']);
                    $success = $this->purchase_model->disApproveSaleOrder($data);
                    logActivity('Indent Disapproved', 'purchasE_indent', $key);
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                pushNotification(array('subject' => 'Purchase indent disapproved', 'message' => 'Purchase indent id :# ' . $key . ' is disapproved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $key, 'class' => 'add_purchase_tabs', 'data_id' => 'indentView', 'icon' => 'fa-shopping-cart'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        pushNotification(array('subject' => 'Purchase indent disapproved', 'message' => 'Purchase indent id :# ' . $key . ' is disapproved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $key, 'class' => 'add_purchase_tabs', 'data_id' => 'indentView', 'icon' => 'fa-shopping-cart'));
                    }
                }
                if ($success) {
                    $data['message'] = "Indent Disapproved";
                    //  logActivity('Idnent Disapproved','purchasE_indent',$id);
                    //pushNotification(array('subject'=> 'Purchase indent disapproved' , 'message' => 'Purchase indent disapproved by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'ref_id'=> $id));
                    $this->session->set_flashdata('message', 'Indent Disapproved successfully');
                    redirect(base_url() . 'purchase/purchase_indent', 'refresh');
                }
            }
        }
    }
    /*create PDF*/
    public function create_pdf($id = '') {
        $this->load->library('Pdf');
        //$dataPdf = $this->purchase_model->get_data_byId('purchase_order','id',$id);
        $dataPdf['dataPdf'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);
        //pre($dataPdf['dataPdf']); die;
         //$this->_render_template('purchase_order/view_pdf', $this->data);
         $this->load->view('purchase_order/view_pdf', $dataPdf);

    }
	
	
	public function download_pdf($id = '') {
		$this->load->library('Pdf');
		$dataPdf = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);
		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 
	  
		$obj_pdf->SetCreator(PDF_CREATOR);  
		$obj_pdf->SetTitle("PURCHASE ORDER");  
		$obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
		$obj_pdf->SetDefaultMonospacedFont('helvetica');  
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
		$obj_pdf->setPrintHeader(false);  
		$obj_pdf->setPrintFooter(false);   
		$obj_pdf->SetAutoPageBreak(TRUE, 10);  
		$obj_pdf->SetFont('helvetica', '', 9);
// pre($dataPdf);
// die();	
	#$company_data = getNameById('company_detail',$dataPdf->created_by,'id');
	$company_data = getNameById('company_detail',$this->companyGroupId,'id'); 

	$get_company_unit = json_decode($company_data->address,true);
	$company_GSTNO='';
	foreach($get_company_unit as $get_comp_gst){
		 
		if($get_comp_gst['add_id'] == $dataPdf->company_unit){
			$company_GSTNO = $get_comp_gst['company_gstin'];

		}
	}

	$companyLogo = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	// pre($companyLogo);die();
	$obj_pdf->Image($companyLogo,2,4,10,10,'PNG');
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
						
    $supplierName=getNameById('supplier',$dataPdf->supplier_name,'id');	
    $state= getNameById('state',$supplierName->state,'state_id');
    $obj_pdf->AddPage(); 
  	setlocale(LC_MONETARY, 'en_IN');
    $content = ''; 
	#echo $companyLogo; die;
	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	$brnch_name = getNameById_with_cid('company_address', $dataPdf->delivery_address, 'id','created_by_cid',$this->companyGroupId);
	$materialDetail =  json_decode($dataPdf->material_name);

	$subTotal=0;
	 $content .= '';
	$count=0;
	$mat_count = '';	//$material_detail
	$data2 = array();
	 
             	foreach($materialDetail as $material_detail){
					
					 // pre($material_detail);
             		 
                $data2[$count]['material_type_id_'.$count] =  $material_detail->material_type_id ;
				$data2[$count]['material_name_id_'.$count] =  $material_detail->material_name_id ;
				$data2[$count]['description_'.$count] =  $material_detail->description ;
				$data2[$count]['uom_'.$count] =  $material_detail->uom ;				
				$data2[$count]['hsnCode'.$count] =  $material_detail->hsnCode ;				
				$data2[$count]['hsnId_'.$count] =  $material_detail->hsnId ;				
				$data2[$count]['quantity_'.$count] =  $material_detail->quantity ;				 				
				$data2[$count]['price_'.$count] =  $material_detail->price ;				
				$data2[$count]['discount_'.$count] =  $material_detail->discount ;				
				$data2[$count]['sub_tax_'.$count] =  $material_detail->sub_tax ;				
				$data2[$count]['sub_total_'.$count] =  $material_detail->sub_total;				
				$data2[$count]['gst_'.$count] =  $material_detail->gst ;				
				$data2[$count]['total_'.$count] =  $material_detail->total ;				
				$data2[$count]['remove_mat_id_'.$count] =  $material_detail->remove_mat_id ;				
				$data2[$count]['remaning_qty_'.$count] =  $material_detail->remaning_qty ;				
				$data2[$count]['description_check_'.$count] =  $material_detail->description_check ;	
				$data2[$count]['bom_number_'.$count] =  $material_detail->bom_number;				
				$data2[$count]['process_name_'.$count] =  $material_detail->process_name ;	
				$data2[$count]['aliasname_'.$count] =  $material_detail->aliasname ;	
						
				$count++;
                     
             	}
				
				// die();
   
             	$divide = $count/45; 
		      $after_divide =  round($divide);
		       if($after_divide <=  1){
			    $after_divide = 1;
		     }
		     
           if ( $count >= 0 ){  //If there are more than 0 terms
			$k =0;
			$sno = 1;
             for ($j = 0; $j < $after_divide; $j++){
             
			 $content .= '<table>
			        <tr>
			        	<td  align="center" ><img src="'.$companyLogo.'" alt="test alt attribute" width="60" height="20" border="0" style="padding:0px !important; margin-bottom:-30px !important;"></td>
			        </tr>
					<tr>
						<td colspan="1" > <h2 align="center">PURCHASE ORDER</h2> </td>
					</tr>
			
				</table>
				<table>
					 <tr>
					      <td colspan="8"><strong>GST :</strong> '.$company_GSTNO.'  </td>
		    			  <td colspan="8" style="text-align:center;"></td>
		            </tr>
	           </table>
	    	<table border="1" cellpadding="2">
	        <tr>
	             <td colspan="6"><strong>Order Date :</strong> &nbsp;'.($dataPdf->date?date("j F , Y", strtotime($dataPdf->date)):'').'</td>
				 <td colspan="8"><strong>PO Number :</strong>&nbsp; '.$dataPdf->order_code.'</td>
			    </tr>
			    <tr>
		         <td colspan="6"><strong>Bill From :</strong><br><br><strong> Vendor Name :</strong> '.$company_data->name.'<br> <strong>Address :</strong> '.$brnch_name->location.'<br> <strong>Contact :</strong> '.$company_data->phone.'<br> <strong>GST No :</strong> '.$company_GSTNO.'<br> </td>
				
				<td colspan="5"><strong> </strong><br><br><strong> Supplier  Name :</strong> '.$supplierName->name.'<br> <strong>Supplier Address :</strong> '.$supplierName->address.'<br> <strong>State :</strong>'.$state->state_name.' <br> <strong>GST No :</strong> '.$supplierName->gstin.'</td>
				<td colspan="5"><strong>Expected Delivery Date  :</strong><br> '.($dataPdf->expected_delivery_date?date("j F , Y", strtotime($dataPdf->expected_delivery_date)):'').'<br><strong> Mode / Terms Of Payment :</strong> &nbsp;<br>'.$dataPdf->payment_terms.'<br><strong> Payment Date :</strong> &nbsp;<br>'.($dataPdf->payment_date?(date("j F , Y", strtotime($dataPdf->payment_date))):'').'<br><strong> Terms Of Delivery :</strong> &nbsp;<br>'.$dataPdf->terms_delivery.'</td>
		      </tr>';
              $content .= '<tr><td colspan="16"><b style="font-size:12px; text-align:center;">Product Description</b></td></tr>
			   <tr>
					<th rowspan="1" style="text-align:center;"><strong>S No.</strong></th>
				
					<th rowspan="1" style="text-align:center;width:130px;" colspan="5"><strong>Material Name</strong></th>
					<th rowspan="1" style="text-align:center;width:30px;"><strong>Img</strong></th>
					<th rowspan="1" style="text-align:center;"><strong>Alias</strong></th>
					<th rowspan="1" style="text-align:center;width:70px;"><strong>HSN/SAC Code</strong></th>
					<th rowspan="1"  style="text-align:center;"><strong>QTY</strong></th>
					<th rowspan="1" style="text-align:center;"><strong>UOM</strong></th>
					<th rowspan="1"  style="text-align:center;width:76px;"><strong>Unit Price </strong></th>
					
					<th rowspan="1"  style="text-align:center;width:90px;"><strong>Price in RS</strong></th>
				
					
					<th rowspan="1"  style="text-align:center;width:145px;"><strong>Total Amt.</strong></th>
			 </tr>';
			 /*
			 <th rowspan="1"  style="text-align:center;"><strong>CGST %</strong></th>
					<th rowspan="1"  style="text-align:center;"><strong>SGST %</strong></th>
					<th rowspan="1"  style="text-align:center;"><strong>IGST (%)</strong></th>
			*/		
			 for($i = 0 ;$i<=3;$i++){
			 	if(!empty($data2[$k]['material_name_id_'.$k])){
                                                                 
					$materialtypr=getNameById('material_type',$data2[$k]['material_type_id_'.$k],'id');

					$subTotal += $data2[$k]['sub_total_'.$k];
					$subTotal_TAX += $data2[$k]['sub_tax_'.$k];
					$Total+=$data2[$k]['total_'.$k];	
						$material_id=$data2[$k]['material_name_id_'.$k];
						$materialName=getNameById('material',$material_id,'id');	
						$ww =  getNameById('uom', $data2[$k]['uom_'.$k],'id');
						$uom = !empty($ww)?$ww->ugc_code:'';
						$cccc= $data2[$k]['price_'.$k];
						
					    $dis=$data2[$k]['discount_'.$k];
					      $disbmnsbndbcountrate=$cccc*$dis/100;
					      $discountrate=$cccc-$disbmnsbndbcountrate;
					     $discoutretsub=$data2[$k]['quantity_'.$k]*$discountrate;
					   
                       if (!empty($supplierName->gstin)) {
                                   $code=$supplierName->gstin;
					               $supplevalue=substr($code,0,2);
		                           $buyarv=$company_GSTNO;
							       $valer=substr($buyarv,0,2);
								   
								   
								   
							    if ($supplevalue==$valer) 
							  {
		                	         $sgg=$data2[$k]['gst_'.$k]/2;
		                	        $gsti= $sgg.' '. '%';
		                      }else{
		                	         $gsti=  ' -- ';
		                       }
		                       if ($supplevalue!=$valer) {
                	               $vbcv=$data2[$k]['gst_'.$k];
                	               $gstis=$vbcv.' '. '%';
                               }else{
                	               $gstis=  ' -- ';
                                }
                           }elseif(empty($supplierName->gstin)){
                                $gstis= $data2[$k]['gst_'.$k];
                              
                           } 

                           if ($dataPdf->is_purchase_date==1) {
                             $qut='open';
                           }else{
                              $qut= $data2[$k]['quantity_'.$k];
                           }
                   //pre($material_detail);
				   $attachments = $this->purchase_model->get_image_by_materialId('attachments', 'rel_id', $data2[$k]['material_name_id_'.$k]);
					if(!empty($attachments)){
						$imgcode = '<img style="width: 50px; height: 37px; " src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
					}else{
						$imgcode =  '<img style="width: 50px; height: 37px;" src="'.base_url().'assets/uplodimg/noimage.jpg">';
					}
					
					// pre($imgcode);die();
			          $content .= '<tr>
										<td>'.$sno++.' </td>
									
										<td style="width:130px;" colspan="5"><h5>'.getPCode($material_id).'  ' .$materialName->material_name.'</h5><br>'.$data2[$k]['description_'.$k].'</td>
                                         <td style="width:30px;">'.$imgcode.'</td>										
                                         <td>'.$data2[$k]['aliasname_'.$k].'</td>										
										<td>'.$data2[$k]['hsnCode'.$k].'</td>
										<td>'.$qut.' </td>
										<td>'.$uom.'</td>
										<td>'.$pricedf = money_format('%!i', $data2[$k]['price_'.$k]).'</td>
										
										<td>'.$discoutretsub.'</td>
										
										
										<td style="text-align:right;">'.$totaldf = money_format('%!i',$data2[$k]['total_'.$k]).'</td>
								</tr>';

								$k++;
							 
						}
					}
					//die();
					$sno = $sno-1;
					$number = $dataPdf->grand_total;
				   $no = round($number);
				   $point = round($number - $no, 2) * 100;
				   $hundred = null;
				   $digits_1 = strlen($no);
				   $i = 0;
				   $str = array();
				   $words = array('0' => '', '1' => 'One', '2' => 'Two',
					'3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
					'7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
					'10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
					'13' => 'Thirteen', '14' => 'Fourteen',
					'15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
					'18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
					'30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
					'60' => 'Sixty', '70' => 'Seventy',
					'80' => 'Eighty', '90' => 'Ninety');
				   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
				   while ($i < $digits_1) {
					 $divider = ($i == 2) ? 10 : 100;
					 $number = floor($no % $divider);
					 $no = floor($no / $divider);
					 $i += ($divider == 10) ? 1 : 2;
					 if ($number) {
						$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
						$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
						$str [] = ($number < 21) ? $words[$number] .
							" " . $digits[$counter] . $plural . " " . $hundred
							:
							$words[floor($number / 10) * 10]
							. " " . $words[$number % 10] . " "
							. $digits[$counter] . $plural . " " . $hundred;
					 } else $str[] = null;
				  }
				  $str = array_reverse($str);
				  $result = implode('', $str);
				  $points = ($point) ?
					"." . $words[$point / 10] . " " . 
						  $words[$point = $point % 10] : '';
						  if ($company_data->purchase_term_conditions=='') {
						  	 $terms_condition_dataPdf=$dataPdf->terms_conditions;
						  }elseif ($company_data->purchase_term_conditions!='') {
						  	  $terms_condition=$company_data->purchase_term_conditions;
						  } 
					if($j == $after_divide-1){

                          $subTotala = money_format('%!i', $subTotal);
				$content .= '<tr>
				            <td colspan="13" align="right"><strong>Sub Total  </strong> </td>
				            <td  style="text-align:right;">Rs.'.$subTotala.'</td>
			                </tr>';
					
			    $subTotal_TAXa = money_format('%!i', $subTotal_TAX);
				 $Totala = money_format('%!i', $Total);
				 if (!empty($supplierName->gstin)) {
                                   $code=$supplierName->gstin;
					               $supplevalue=substr($code,0,2);
		                           $buyarv=$company_GSTNO;
							       $valer=substr($buyarv,0,2);
						if ($supplevalue==$valer){
		                	$sgg=$subTotal_TAXa/2;
							$content .= '<tr>
									<td colspan="13" align="right"><strong>SGST</strong> </td>
									<td style="text-align:right;" >Rs.'.$sgg.'</td>
								</tr>';
							$content .= '<tr>
									<td colspan="13" align="right"><strong>CGST</strong> </td>
									<td style="text-align:right;" >Rs.'.$sgg.'</td>
								</tr>';	
		              }
					   if ($supplevalue!=$valer) {
						  
						  $content .= '<tr>
								<td colspan="13" align="right"><strong>IGST</strong> </td>
								<td style="text-align:right;" >Rs.'.$subTotal_TAXa.'</td>
							</tr>'; 
					   }
                }
			  
			           $content .= '<tr>
				            <td colspan="13" align="right"><strong>Total Amount </strong> </td>
				          <td  style="text-align:right;">Rs.'.$Totala.'</td>
				             </tr>';
				$freights = money_format('%!i', $dataPdf->freight);
		 	if($dataPdf->terms_delivery == 'To be paid by customer'){
				$content .= '<tr>
					<td colspan="13" align="right"><strong>Freight(If Any)</strong> </td>
					<td  style="text-align:right;">Rs.'.($freights?$freights:0).'</td>
				</tr>';
			}
			$preparedBy = getNameById('user_detail',$dataPdf->created_by,'u_id'); 
			$CheckedBy = getNameById('user_detail',$dataPdf->validated_by,'u_id'); 
			
			if(empty($CheckedBy)){
				$checkebyname = 'Pending For Approval';
			}else{
				$checkebyname = $CheckedBy->name;
			}
			
			

		
				$grand_totals = money_format('%!i', $dataPdf->grand_total);
			   $otherCharge = money_format('%!i', $dataPdf->other_charges);
				$content .= '<tr>
							<td colspan="13" align="right"><strong>Other Charges(If Any)</strong> </td>
							<td style="text-align:right;">Rs.'.($otherCharge?$otherCharge:0).'</td>
							</tr>
							 <tr>
								<td colspan="13" align="right"><strong>Grand Total </strong> </td>
								<td  style="text-align:right;">Rs. '. $grand_totals.'</td>
						    </tr>';
			   }
           	  $content .= '<tr><td colspan="14">Amount Chargeable(in Words) : <b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;'. $result . "Only".'</b></td></tr>';
				 
				 $content .=' <tr>
				             <td colspan="6"><h5>Terms & Conditions</h5> <p>'.$dataPdf->terms_conditions.'</p> </td>
						   	 <td colspan="4"><h5>Prepared By</h5>   <br/> '.$preparedBy->name.'</td>
						   	 <td colspan="4"><h5>Checked By</h5><br/>'.$checkebyname.'</td>
						   	 
							</tr>';  
			     $content .= '</table>';
			   $content .='<table ><br><br><br><br> <tr rowspan="2"><td  align="center"> This is computer generated Purchase Order does not require signature </td></tr></table> ' ;

	  
	   $sno++;
	}
  
   }
   // pre($content);die();
	$obj_pdf->setPageOrientation('L');
	$obj_pdf->writeHTML($content);  
	ob_end_clean();	
		$rand_num = rand(5000000, 1500000);
		$filename = "Purchase_order_".$rand_num."" . ".pdf";
		// $obj_pdf->Output(FCPATH . 'assets/POUpload/'.$filename, 'F');
		$obj_pdf->Output($filename, 'D'); 
       	//$pdfFilePath = FCPATH . 'assets/POUpload/'.$filename;
       	$pdfFilePath = base_url() . 'assets/POUpload/'.$filename;
		$this->session->set_flashdata('message', 'Purchase Order Pdf Downloaded Successfully');
        redirect(base_url() . 'purchase/purchase_order', 'refresh');

    }

    /*get material data*/
    public function getMaterialDataById() {
        if ($_POST['id'] != '') {
			
            $supplierPrice = $this->checkSupplierPrice($_POST);
			
            $material = $this->purchase_model->get_data_byId('material', 'id', $_POST['id']);
			
			 $matAliasName = json_decode($material->MatAliasName);
			 $aliasName = '';
			foreach($matAliasName as $matval){
				
				 if($matval->customer_id == $_POST['supplierId']){
					 //$matval->customer_id;
					$aliasName =  $matval->alias;
				 }
			}		
	
			$attachments = $this->purchase_model->get_image_by_materialId('attachments', 'rel_id', $material->id);
			if($attachments[0]['file_name'] != ''){
				$matImage = '<img style="width: 50px; height: 37px; margin-left:32px;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'] .'">';
			}else{
				$matImage = '<img style="width: 50px; height: 37px; margin-left:32px;" src="'.base_url().'assets/uplodimg/noimage.jpg">';
			}
			
            $hsnCode  = getSingleAndWhere('hsn_sac','hsn_sac_master',['id' => $material->hsn_code]);
            $ww = getNameById('uom', $material->uom, 'id');
            $material->uom = $ww->ugc_code;
            $material->uomid = $ww->id;
            $material->hsnCode = $hsnCode;
            $material->supplierPrice = $supplierPrice;
            $material->aliasName = $aliasName;
            $material->matimg = $matImage;
            $material->matimgname = $attachments[0]['file_name'];
            echo json_encode($material);
        }
    }

    public function checkSupplierPrice($POST){
		// pre($POST);die();
        $supplierPrice = 0;
        if( $POST['supplierId'] ){
            $suppliers = $this->purchase_model->get_data_byId('supplier', 'id', $POST['supplierId']);
			
            if( !empty($suppliers->material_name_id) ){
                $supplierMatData = json_decode($suppliers->material_name_id);
                foreach ($supplierMatData as $key => $value) {
				//	pre($value);
                    $value->supplierDeliveryDate;
                    $supplierDate = explode(' ~ ',$value->supplierDeliveryDate);
                    $currentDate = strtotime(date("d-m-Y"));
                    $startDate = strtotime(date($supplierDate[0]));
                    $endDate = strtotime(date($supplierDate[1]));
                    if( isset($value->material_type_id) && isset($value->material_name) ){
                       // if( ($value->material_type_id == $POST['materialTypeId'] && $value->material_name == $POST['id']) &&
                           //  ( $startDate <= $currentDate && $endDate >= $currentDate ) ){
						 if( ($value->material_type_id == $POST['materialTypeId'] && $value->material_name == $POST['id']) ){	   
                              $supplierPrice = $value->price;
                        }
                    }

                }
				// die();
            }
        }
        return $supplierPrice;
    }

    function findSupplierMaterialPrice(){
        $priceData = [];
        if( !empty($_POST['material']) ){
            foreach ($_POST['material'] as $key => $value) {
                $POST['supplierId'] = $_POST['supplierId'];
                $POST['materialTypeId'] = $value[1];
                $POST['id'] = $value[2];
                $supplierPrice = $this->checkSupplierPrice($POST);
                if( $supplierPrice > 0 ){
                    $priceData[]   = ['checkRow' => $value[0],'supplierPrice' => $supplierPrice ];
                }else{
                    $supplierPrice = getSingleAndWhere('cost_price','material',['id' => $POST['id']]);
                    $priceData[]   = ['checkRow' => $value[0],'supplierPrice' => $supplierPrice ];
                }
            }
        }
        echo json_encode($priceData);
    }

    /*get address supplier*/
    public function getSupplierAddressId() {
        //pre($_POST);die;
        if ($_POST['id'] != '') {
            $supplierAddress = $this->purchase_model->get_data_byId('supplier', 'id', $_POST['id']);
            //  pre($supplierAddress);die;
            echo json_encode($supplierAddress);
        }
    }
    /*get company address in order and mrn **/
    /*get multiple addresses in material*/
    function getAddress() {
        $where = array('created_by_cid' => $this->companyGroupId);
        $data = $this->purchase_model->get_data_byAddress('company_address', $where);
        //pre($data);die;
        //$data1 = $data[0]['address'];
        //$data2 = json_decode($data1);
        $addressArray = array();
        $i = 0;
        //pre($data2);die;
        foreach ($data as $dt) {
            $addressArray[$i]['id'] = $dt['id'];
            $addressArray[$i]['text'] = $dt['location'];
            $i++;
        }
        //pre($addressArray);
        echo json_encode($addressArray);
    }
    function get_state_on_dilivery_add() {
        if ($_REQUEST['seelected_val_Address'] != '') {
            $where = array('id' => $this->companyGroupId);
            $data = $this->purchase_model->get_data_byAddress('company_detail', $where);
           # pre($data);
            $data1 = $data[0]['address'];
            $data2 = json_decode($data1);
            foreach ($data2 as $key => $value) {
                if ($_REQUEST['seelected_val_Address'] == $value->address) {
                    echo $value->state;
                }
            }
        }
    }
    /*********************************************************purchase order********************************************************/
    /*main fucntion of purchase order listing*/
    /* public function purchase_order() {
    $this->data['can_edit'] = edit_permissions();
    $this->data['can_delete'] = delete_permissions();
    $this->data['can_add'] = add_permissions();
    $this->data['can_view'] = view_permissions();
    $this->breadcrumb->add('Purchase', base_url() . 'purchase/dashboard');
    $this->breadcrumb->add('Dashboard', base_url() . 'purchase/dashboard');
    $this->breadcrumb->add('Purchase Order', base_url() . 'purchase_order');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Purchase Order';
    //pre($_POST);die();
    /*For Filter*/
    /*$where1 = "(created_by_cid ='".$this->companyGroupId."' OR created_by_cid =0) AND status = 1";
    $this->data['mat_type_ss']  = $this->purchase_model->get_filter_details('material_type',$where1);
    $this->data['supplier_data']  = $this->purchase_model->get_filter_details('supplier',array('created_by_cid'=> $this->companyGroupId));
    $whereCompany = "(id ='".$this->companyGroupId."')";
    $this->data['company_unit_adress']  = $this->purchase_model->get_filter_details('company_detail',$whereCompany);




    if($_POST['dashboard'] == 'dashboard' && $_POST['start'] != '' && $_POST['end'] != ''){

    if(isset($_POST['material_type_id']) && $_POST['material_type_id']!=''){
        $whereInProcess = "purchase_order.created_by_cid = ".$this->companyGroupId." AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."') AND (purchase_order.created_by_cid = '".$this->companyGroupId."' ) AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )  AND ( purchase_order.material_type_id = ".$_POST['material_type_id']." )";
        $whereComplete = "created_by_cid = ".$this->companyGroupId." AND  pay_or_not = '1' AND mrn_or_not = '1'  AND ( purchase_order.material_type_id = ".$_POST['material_type_id']." )";
    }elseif($_POST['label'] == 'Complete PO' || $_POST['label'] == 'Incomplete PO'){
        $whereInProcess = "purchase_order.created_by_cid = ".$this->companyGroupId." AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."') AND ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";
        $whereComplete = "created_by_cid = ".$this->companyGroupId." AND  pay_or_not = '1' AND mrn_or_not = '1' AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."')";
    }elseif($_POST['label'] == 'PO Pending For MRN'){
        $whereInProcess = "purchase_order.created_by_cid = ".$this->companyGroupId." AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."') AND purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0'  AND purchase_order.save_status = 1";
        $whereComplete = "created_by_cid = ".$this->companyGroupId." AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1' AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."'  AND purchase_order.save_status = 1)";
    }   elseif($_POST['label'] == 'PO Converted To MRN'){
        $whereInProcess = "purchase_order.created_by_cid = ".$this->companyGroupId." AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."') AND ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1') AND purchase_order.save_status = 1";
        $whereComplete = "purchase_order.created_by_cid = ".$this->companyGroupId." AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1' AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."'  AND purchase_order.save_status = 1)";
    }
    }else{

    /*For Filter*/
    /*******************************date range filter with select box *****************************/
    /*if(!empty($_POST) && isset($_POST['start']) &&  isset($_POST['end']) && $_POST['departments']=='' &&  $_POST['material_type'] == '' && $_POST['company_unit'] == '' ){
        //echo "1";
        $whereInProcess = "purchase_order.created_by_cid = ".$this->companyGroupId." AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."') AND (purchase_order.created_by_cid = '".$this->companyGroupId."' ) AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

        //$whereComplete = "created_by_cid = ".$_SESSION['loggedInUser']->c_id." AND  pay_or_not = '1' AND mrn_or_not = '1'";
        $whereComplete = "purchase_order.created_by_cid = ".$this->companyGroupId." AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."') AND (purchase_order.created_by_cid = '".$this->companyGroupId."' ) AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '1' OR pay_or_not ='1' AND mrn_or_not = '1' )";

    }else if(!empty($_POST) && $_POST['departments']!='' &&  $_POST['material_type'] !='' && $_POST['start'] !='' && $_POST['end'] !='' && $_POST['company_unit'] != ''){
    // echo "2";
        $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."' AND  supplier_name = '".$_POST['departments']."') AND  (company_unit ='".$_POST['company_unit']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."')";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."' AND  supplier_name = '".$_POST['departments']."') AND  (company_unit ='".$_POST['company_unit']."') AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."') AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }else if(!empty($_POST) && $_POST['departments']!='' &&  $_POST['material_type'] !='' && $_POST['start'] !='' && $_POST['end'] !='' && $_POST['company_unit'] == ''){

        $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."' AND  supplier_name = '".$_POST['departments']."')  AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."')";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."' AND  supplier_name = '".$_POST['departments']."')  AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."') AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }else if(!empty($_POST) && $_POST['departments']!='' &&  $_POST['material_type'] !='' && $_POST['start'] =='' && $_POST['end'] =='' && $_POST['company_unit'] == ''){
        //echo "3";
        $whereInProcess =  "created_by_cid = ".$this->companyGroupId."  AND  (material_type_id ='".$_POST['material_type']."' AND  supplier_name = '".$_POST['departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."' AND  supplier_name = '".$_POST['departments']."') AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }else if(!empty($_POST) && $_POST['departments']!='' &&  $_POST['material_type'] !='' && $_POST['start'] =='' && $_POST['end'] =='' && $_POST['company_unit'] != ''){
        //echo "new 1";
        $whereInProcess =  "created_by_cid = ".$this->companyGroupId."  AND  (company_unit ='".$_POST['company_unit']."') AND  (material_type_id ='".$_POST['material_type']."' AND  supplier_name = '".$_POST['departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."' AND  supplier_name = '".$_POST['departments']."') AND  (company_unit ='".$_POST['company_unit']."') AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }else if(!empty($_POST) && $_POST['departments']!='' &&  $_POST['material_type'] =='' &&  $_POST['company_unit'] =='' && $_POST['start'] !='' && $_POST['end'] !=''){
        //echo "4";
        $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (supplier_name = '".$_POST['departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."')";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (supplier_name = '".$_POST['departments']."') AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."') AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }else if(!empty($_POST) && $_POST['departments']!='' &&  $_POST['material_type'] =='' &&  $_POST['company_unit'] =='' && $_POST['start'] =='' && $_POST['end'] ==''){
        //echo "4";
        $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (supplier_name = '".$_POST['departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (supplier_name = '".$_POST['departments']."')  AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }else if(!empty($_POST) && $_POST['departments']!='' &&  $_POST['material_type'] =='' && $_POST['start'] =='' && $_POST['end'] =='' && $_POST['company_unit'] != ''){
        //echo "5";
        $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (supplier_name = '".$_POST['departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) AND  (company_unit ='".$_POST['company_unit']."')";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_POST['company_unit']."') AND  (supplier_name = '".$_POST['departments']."') AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }else if(!empty($_POST) && $_POST['material_type']!='' &&  $_POST['departments'] =='' && $_POST['start'] !='' && $_POST['end'] !='' && $_POST['company_unit'] != ''){
        //echo "6";
        $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."') AND  (company_unit ='".$_POST['company_unit']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."')";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."') AND  (purchase_order.created_date >='".$_POST['start']."' AND  (company_unit ='".$_POST['company_unit']."') AND  purchase_order.created_date <='".$_POST['end']."') AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }else if(!empty($_POST) && $_POST['material_type']!='' &&  $_POST['departments'] =='' && $_POST['start'] =='' && $_POST['end'] =='' && $_POST['company_unit'] == ''){
        //echo "7";
        $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) ";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."')  AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }else if(!empty($_POST) && $_POST['material_type']=='' &&  $_POST['departments'] =='' && $_POST['start'] !='' && $_POST['end'] !='' && $_POST['company_unit'] != ''){
        //echo "8";
        $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_POST['company_unit']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."') ";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_POST['company_unit']."') AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."') AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }else if(!empty($_POST) && $_POST['material_type']!='' &&  $_POST['departments'] =='' && $_POST['start'] !='' && $_POST['end'] !='' && $_POST['company_unit'] == ''){
        //echo "8";
        $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."') ";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."') AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."') AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }else if(!empty($_POST) && $_POST['material_type']!='' &&  $_POST['departments'] =='' && $_POST['start'] =='' && $_POST['end'] =='' && $_POST['company_unit'] != ''){
        //echo "8";
        $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_POST['company_unit']."') AND  (material_type_id ='".$_POST['material_type']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) ";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_POST['company_unit']."') AND  (material_type_id ='".$_POST['material_type']."')";

    }else if(!empty($_POST) && $_POST['material_type']=='' &&  $_POST['departments'] =='' && $_POST['start'] =='' && $_POST['end'] =='' && $_POST['company_unit'] != ''){
        //echo "8";
        $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_POST['company_unit']."')  AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) ";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_POST['company_unit']."') ";

    }else{
        $whereInProcess = "( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) AND purchase_order.created_by_cid = '".$this->companyGroupId."'";

        $whereComplete = array('purchase_order.created_by_cid' => $this->companyGroupId,'pay_or_not' => '1','mrn_or_not' => '1');
    }



    if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' && $_POST['departments'] == '' && $_POST['material_type'] == ''  ) {

            $whereInProcess = "( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) AND purchase_order.created_by_cid = '".$this->companyGroupId."'";
            $whereComplete = array('purchase_order.created_by_cid' => $this->companyGroupId,'pay_or_not' => '1','mrn_or_not' => '1');

    }elseif(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' && $_POST['departments'] != '' && $_POST['material_type'] == ''  ) {

        $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (supplier_name = '".$_POST['departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";
        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (supplier_name = '".$_POST['departments']."') AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }elseif(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' && $_POST['departments'] == '' && $_POST['material_type'] != ''  ) {

        $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."') AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }elseif(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' && $_POST['departments'] != '' && $_POST['material_type'] != ''  ) {

        $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."' AND  supplier_name = '".$_POST['departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

        $whereComplete ="created_by_cid = ".$this->companyGroupId." AND  (material_type_id ='".$_POST['material_type']."' AND  supplier_name = '".$_POST['departments']."') AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }elseif(isset($_POST["ExportType"]) && $_POST['start'] != '' && $_POST['end'] != '' && $_POST['departments'] == '' && $_POST['material_type'] == ''  ) {

        $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (purchase_order.created_date >='".$_POST['start']."' AND  purchase_order.created_date <='".$_POST['end']."') AND (purchase_order.created_by_cid = '".$this->companyGroupId."' ) AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

        $whereComplete = "created_by_cid = ".$this->companyGroupId." AND  pay_or_not = '1' AND mrn_or_not = '1'";

    }




    }

    if (isset($_POST['favourites']) ){
    $whereInProcess = "( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) AND purchase_order.created_by_cid = '".$this->companyGroupId."' AND favourite_sts = '1'";
    $whereComplete = array('purchase_order.created_by_cid' => $this->companyGroupId,'pay_or_not' => '1','mrn_or_not' => '1' , 'favourite_sts' => '1');
    $this->data['purchase_order_inProcess']  = $this->purchase_model->get_data('purchase_order',$whereInProcess);
    $this->data['purchase_order']  = $this->purchase_model->get_data('purchase_order',$whereComplete);
    if(!empty($_POST)){
        $this->_render_template('purchase_order/index', $this->data);
    }else{
        $this->_render_template('purchase_order/index', $this->data);
    }
    }else{
    $this->data['purchase_order_inProcess']  = $this->purchase_model->get_data('purchase_order',$whereInProcess);
    $this->data['purchase_order']  = $this->purchase_model->get_data('purchase_order',$whereComplete);
    if(!empty($_POST)){
        $this->_render_template('purchase_order/index', $this->data);
    }else{
        $this->_render_template('purchase_order/index', $this->data);
    }
    }
    } */
    /*********************************************************purchase order********************************************************/
    /*main fucntion of purchase order listing*/
    public function purchase_order() {
        /*$this->load->library('pagination');*/
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Purchase', base_url() . 'purchase/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'purchase/dashboard');
        $this->breadcrumb->add('Purchase Order', base_url() . 'purchase_order');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Purchase Order';
        /*For Filter*/
		
		
		// pre($_GET);die();

       $where1 = "(created_by_cid ='" . $this->companyGroupId . "' OR created_by_cid =0) AND status = 1";
        $this->data['mat_type_ss'] = $this->purchase_model->get_filter_details('material_type', $where1);
        $this->data['supplier_data'] = $this->purchase_model->get_filter_details('supplier', array('created_by_cid' => $this->companyGroupId));
        $whereCompany = "(id ='" . $this->companyGroupId . "')";
        $this->data['company_unit_adress'] = $this->purchase_model->get_filter_details('company_detail', $whereCompany);
        $searchMetrialType = '"material_type_id":"'.$_GET['material_type'].'"';
         if (isset($_GET['favourites'])) {
            $whereInProcess = "( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' ) AND purchase_order.created_by_cid = '" . $this->companyGroupId . "' AND purchase_order.favourite_sts = '1'";
            $whereComplete = array('purchase_order.created_by_cid' => $this->companyGroupId, 'purchase_order.pay_or_not' => '1', 'purchase_order.mrn_or_not' => '1', 'purchase_order.favourite_sts' => '1');
        }
        if ($_GET['dashboard'] == 'dashboard' && $_GET['start'] != '' && $_GET['end'] != '') {
            if (isset($_GET['material_type_id']) && $_GET['material_type_id'] != '') {
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') AND (purchase_order.created_by_cid = '" . $this->companyGroupId . "' ) AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' )  AND ( purchase_order.material_type_id = " . $_GET['material_type_id'] . " )";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'  AND ( purchase_order.material_type_id = " . $_GET['material_type_id'] . " )";
            } elseif ($_GET['label'] == 'Complete PO' || $_GET['label'] == 'Incomplete PO') {
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') AND ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' )";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1' AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "')";
            } elseif ($_GET['label'] == 'PO Pending For MRN') {
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') AND purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0'  AND purchase_order.save_status = 1";
                $whereComplete = "created_by_cid = " . $this->companyGroupId . " AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1' AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "'  AND purchase_order.save_status = 1)";
            } elseif ($_GET['label'] == 'PO Converted To MRN') {
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') AND ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1') AND purchase_order.save_status = 1";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1' AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "'  AND purchase_order.save_status = 1)";
            }
        } else {
            /*For Filter*/
            /*******************************date range filter with select box *****************************/
            if ( isset($_GET['start']) && isset($_GET['end']) && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '') {

                       $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') AND (purchase_order.created_by_cid = '" . $this->companyGroupId . "' )";

                    $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') AND (purchase_order.created_by_cid = '" . $this->companyGroupId . "' )";


                //$whereComplete = "created_by_cid = ".$_SESSION['loggedInUser']->c_id." AND  pay_or_not = '1' AND mrn_or_not = '1'";

           } else if (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] != '') {
                 //echo "2";
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND ( purchase_order.material_name LIKE '%" . $searchMetrialType . "%' AND  supplier_name = '" . $_GET['departments'] . "') AND  (company_unit ='" . $_GET['company_unit'] . "') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' )AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "')";
                $whereComplete = "created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%' AND  supplier_name = '" . $_GET['departments'] . "') AND  (company_unit ='" . $_GET['company_unit'] . "') AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";
            } else if (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%' AND  supplier_name = '" . $_GET['departments'] . "')  AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' )AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "')";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%' AND  supplier_name = '" . $_GET['departments'] . "')  AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";
            } else if (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {
                //echo "3";
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . "  AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%' AND  supplier_name = '" . $_GET['departments'] . "') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' )";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%' AND  supplier_name = '" . $_GET['departments'] . "') AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";
            } else if (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                //echo "new 1";
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . "  AND  (purchase_order.company_unit ='" . $_GET['company_unit'] . "') AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%' AND  purchase_order.supplier_name = '" . $_GET['departments'] . "') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' )";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%' AND  purchase_order.supplier_name = '" . $_GET['departments'] . "') AND  (company_unit ='" . $_GET['company_unit'] . "') AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";
            } else if (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' && $_GET['start'] != '' && $_GET['end'] != '') {
                //echo "4";
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.supplier_name = '" . $_GET['departments'] . "') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' ) AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "')";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.supplier_name = '" . $_GET['departments'] . "') AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";
            } else if (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' && $_GET['start'] == '' && $_GET['end'] == '') {
                //echo "4";
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.supplier_name = '" . $_GET['departments'] . "') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' )";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.supplier_name = '" . $_GET['departments'] . "')  AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";
            } else if (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                //echo "5";
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (supplier_name = '" . $_GET['departments'] . "') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR pay_or_not ='0' AND purchase_order.mrn_or_not = '1' ) AND  (purchase_order.company_unit ='" . $_GET['company_unit'] . "')";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.company_unit ='" . $_GET['company_unit'] . "') AND  (purchase_order.supplier_name = '" . $_GET['departments'] . "') AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";
            } else if (!empty($_GET) && $_GET['material_type'] != '' && $_GET['departments'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] != '') {
                //echo "6";
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%') AND  (purchase_order.company_unit ='" . $_GET['company_unit'] . "') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' ) AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "')";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%') AND  (purchase_order.date >='" . $_GET['start'] . "' AND  (purchase_order.company_unit ='" . $_GET['company_unit'] . "') AND  purchase_order.date <='" . $_GET['end'] . "') AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";
            } else if (!empty($_GET) && $_GET['material_type'] != '' && $_GET['departments'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {

                /*$whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_type_id ='" . $_GET['material_type'] . "') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' ) ";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_type_id ='" . $_GET['material_type'] . "')  AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";*/
                $searchMetrialType = '"material_type_id":"'.$_GET['material_type'].'"';
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' ) ";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%')  AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";

            } else if (!empty($_GET) && $_GET['material_type'] == '' && $_GET['departments'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] != '') {
                //echo "8";
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' )AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') ";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.company_unit ='" . $_GET['company_unit'] . "') AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";
            } else if (!empty($_GET) && $_GET['material_type'] != '' && $_GET['departments'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
                //echo "8";
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' )AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') ";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%') AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";
            } else if (!empty($_GET) && $_GET['material_type'] != '' && $_GET['departments'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                //echo "8";
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.company_unit ='" . $_GET['company_unit'] . "') AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' ) ";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.company_unit ='" . $_GET['company_unit'] . "') AND  (purchase_order.material_name LIKE '%" . $searchMetrialType . "%')";
            } else if (!empty($_GET) && $_GET['material_type'] == '' && $_GET['departments'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
               //echo "8";
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.company_unit ='" . $_GET['company_unit'] . "') ";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.company_unit ='" . $_GET['company_unit'] . "') ";
            } elseif(empty($_GET['tab'])) {
                $whereInProcess = "( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' ) AND purchase_order.created_by_cid = '" . $this->companyGroupId . "'";
                $whereComplete = array('purchase_order.created_by_cid' => $this->companyGroupId, 'purchase_order.pay_or_not' => '1', 'purchase_order.mrn_or_not' => '1');
            }
            elseif(!empty($_GET['search'])) {
                $materialName=getNameById('material',$_GET['search'],'material_name');
                $material_type_tt = getNameById('material_type',$_GET['search'],'name');
                if($materialName->id == '' && $material_type_tt->id ==''){
                    $wheresearch = "CONCAT(purchase_order.id, purchase_order.order_code) like '%" . $_GET['search'] . "%'";
                }elseif($materialName->id != '' && $material_type_tt->id ==''){
                    $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                    $wheresearch = "json_contains(`material_name`, '".$json_dtl."')" ;
                }elseif($material_type_tt->id !=''){
                     $wheresearch = "CONCAT(purchase_order.material_type_id) like '" . $material_type_tt->id . "'";
                }
                $whereInProcess = $wheresearch ." AND ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' ) AND purchase_order.created_by_cid = '" . $this->companyGroupId . "'";
                $whereComplete = array($wheresearch,'purchase_order.created_by_cid' => $this->companyGroupId, 'purchase_order.pay_or_not' => '1', 'purchase_order.mrn_or_not' => '1');
            }
            elseif(!empty($_GET['tab'])=='complete') {
                $whereInProcess = "( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' ) AND purchase_order.created_by_cid = '" . $this->companyGroupId . "'";
                $whereComplete = array('purchase_order.created_by_cid' => $this->companyGroupId, 'purchase_order.pay_or_not' => '1', 'purchase_order.mrn_or_not' => '1');
            }
            elseif(!empty($_GET['tab'])=='inprocess') {
                $whereInProcess = "( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' ) AND purchase_order.created_by_cid = '" . $this->companyGroupId . "'";
                $whereComplete = array('purchase_order.created_by_cid' => $this->companyGroupId, 'purchase_order.pay_or_not' => '1', 'purchase_order.mrn_or_not' => '1');
            }
            if (isset($_GET["ExportType"]) && $_GET["favourites"]=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] == ''&& $_GET['company_unit'] == '') {
                 $whereInProcess = "( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' ) AND purchase_order.created_by_cid = '" . $this->companyGroupId . "'";
                $whereComplete = array('purchase_order.created_by_cid' => $this->companyGroupId, 'purchase_order.pay_or_not' => '1', 'purchase_order.mrn_or_not' => '1');
         }
            else if (isset($_GET["ExportType"])=='' && $_GET["favourites"]!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] == ''&& $_GET['company_unit'] == '') {
                  $whereInProcess = "( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' ) AND purchase_order.created_by_cid = '" . $this->companyGroupId . "' AND purchase_order.favourite_sts = '1'";
            $whereComplete = array('purchase_order.created_by_cid' => $this->companyGroupId, 'purchase_order.pay_or_not' => '1', 'purchase_order.mrn_or_not' => '1', 'purchase_order.favourite_sts' => '1');
            }else if (isset($_GET["ExportType"]) && $_GET["favourites"]=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] == ''&& $_GET['company_unit']!= '') {
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.company_unit ='" . $_GET['company_unit'] . "') ";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.company_unit ='" . $_GET['company_unit'] . "') ";
            }else if (isset($_GET["ExportType"])!='' && $_GET["favourites"]!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] == ''&& $_GET['company_unit'] == '') {
                  $whereInProcess = "( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' ) AND purchase_order.created_by_cid = '" . $this->companyGroupId . "' AND purchase_order.favourite_sts = '1'";
            $whereComplete = array('purchase_order.created_by_cid' => $this->companyGroupId, 'purchase_order.pay_or_not' => '1', 'purchase_order.mrn_or_not' => '1', 'purchase_order.favourite_sts' => '1');
            } elseif (isset($_GET["ExportType"]) && $_GET["favourites"]=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] != '' && $_GET['material_type'] == ''&& $_GET['company_unit'] == '') {
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.supplier_name = '" . $_GET['departments'] . "') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' )";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.supplier_name = '" . $_GET['departments'] . "') AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";
            } elseif (isset($_GET["ExportType"]) && $_GET["favourites"]=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] != '' && $_GET['search'] == ''&& $_GET['company_unit'] == '') {
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_type_id ='" . $_GET['material_type'] . "') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' )";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_type_id ='" . $_GET['material_type'] . "') AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";
            } elseif (isset($_GET["ExportType"]) && $_GET["favourites"]=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['search'] == ''&& $_GET['company_unit'] == '') {
                $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (material_type_id ='" . $_GET['material_type'] . "' AND  supplier_name = '" . $_GET['departments'] . "') AND  ( purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='1' AND purchase_order.mrn_or_not = '0' OR purchase_order.pay_or_not ='0' AND purchase_order.mrn_or_not = '1' )";
                $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.material_type_id ='" . $_GET['material_type'] . "' AND  purchase_order.supplier_name = '" . $_GET['departments'] . "') AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";
            } elseif (isset($_GET["ExportType"]) && $_GET["favourites"]=='' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['search'] == '') {



                    // $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') AND  ( purchase_order.pay_or_not ='0' OR purchase_order.pay_or_not ='0' OR purchase_order.mrn_or_not = '0' )";
                   // $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . "  AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "')  AND  purchase_order.pay_or_not = '1' AND purchase_order.mrn_or_not = '1'";
                   if($_GET['tab']=='complete'){
                       $whereComplete = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') AND (purchase_order.created_by_cid = '" . $this->companyGroupId . "' ) ";
                       }else{
                 $whereInProcess = "purchase_order.created_by_cid = " . $this->companyGroupId . " AND  (purchase_order.date >='" . $_GET['start'] . "' AND  purchase_order.date <='" . $_GET['end'] . "') AND (purchase_order.created_by_cid = '" . $this->companyGroupId . "' )";

                       }




            }
        }

        //Search
        $where2 = '';
             $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $materialName=getNameById('material',$search_string,'material_name');
            $material_type_tt = getNameById('material_type',$search_string,'name');
                if($materialName->id == '' && $material_type_tt->id ==''){

                    $where2 = "(purchase_order.id like '%" . $search_string . "%' or purchase_order.order_code like '%" . $search_string . "%')";
                }elseif($materialName->id != '' && $material_type_tt->id ==''){
                    $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                    $where2 = "purchase_order.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                }elseif($material_type_tt->id !=''){
                        $json_dtl ='{"material_name_id" : "'.$material_type_tt->id.'"}';
                    $where2 = "purchase_order.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                }
            redirect("purchase/purchase_order/?search=$search_string");
        }else if($_GET['search']!=''){
            $materialName=getNameById('material',$_GET['search'],'material_name');
            $material_type_tt = getNameById('material_type',$_GET['search'],'name');
                if($materialName->id == '' && $material_type_tt->id ==''){
                   $where2 = "(purchase_order.id like '%" .$_GET['search']. "%' OR purchase_order.order_code like '%" . $_GET['search'] . "%')";
                }elseif($materialName->id != '' && $material_type_tt->id ==''){
                    $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                    $where2 = "purchase_order.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                }elseif($material_type_tt->id !=''){
                $json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                    $where2 = "purchase_order.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                }
        }
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = "desc";
        }

        if( !empty($_GET['purchase_type']) ){
            if( $_GET['purchase_type'] == 2 ){
                $_GET['purchase_type'] = 0;
            }
            if( $whereInProcess ){
              $whereInProcess  = str_replace("AND  (purchase_order.date >='' AND  purchase_order.date <='')", "",$whereInProcess);
              $whereInProcess .= " AND purchase_order.purchase_type = {$_GET['purchase_type']}";
            }
            if( $whereComplete ){
                $whereComplete  = str_replace("AND  (purchase_order.date >='' AND  purchase_order.date <='')", "",$whereInProcess);
                $whereComplete .= " AND purchase_order.purchase_type = {$_GET['purchase_type']}";
            }
        }

        if($_GET['tab']=='complete' && $_GET['tab']!='inprocess'){
            $rows=$this->purchase_model->tot_rows('purchase_order', $whereComplete, $where2);
        }elseif($_GET['tab']=='inprocess' && $_GET['tab']!='complete'){
            $rows=$this->purchase_model->tot_rows('purchase_order', $whereInProcess, $where2);
        }else{
            $rows=$this->purchase_model->tot_rows('purchase_order', $whereInProcess, $where2);
        }


        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "purchase/purchase_order";
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

        if(!empty($_GET['ExportType'])){
            $export_data = 1;
        }else{
            $export_data = 0;
        }

        if($_GET['tab']=='complete' && $_GET['tab']!='inprocess'){
            $this->data['purchase_order'] = $this->purchase_model->get_data_listing('purchase_order', $whereComplete, $config["per_page"], $page, $where2, $order,$export_data);
        }elseif($_GET['tab']=='inprocess' && $_GET['tab']!='complete'){
            $this->data['purchase_order_inProcess'] = $this->purchase_model->get_data_listing('purchase_order', $whereInProcess, $config["per_page"], $page, $where2, $order,$export_data);
        }
        else{
            $this->data['purchase_order'] = $this->purchase_model->get_data_listing('purchase_order', $whereComplete, $config["per_page"], $page, $where2, $order,$export_data);
            $this->data['purchase_order_inProcess'] = $this->purchase_model->get_data_listing('purchase_order', $whereInProcess, $config["per_page"], $page, $where2, $order,$export_data);
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

         $this->_render_template('purchase_order/index', $this->data);
    }

    /*purchase order add/edit*/
    #public function order_edit(){
    public function convert_to_po() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['materialName'] = $this->purchase_model->get_data('material');
        $this->data['poCreate'] = $this->purchase_model->get_data_byId('purchase_indent', 'id', $id);
        $this->data['purchase_type'] = $this->data['poCreate']->purchase_type;
        $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $id);
        $this->data['order'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);

        $options = [];
        if( checkPurchaseApprove() ){
            $companyApproveUsers = json_decode(getSingleAndWhere('po_approve_users','company_detail',
                                        ['id' => $this->companyGroupId ]),true );
            if( $companyApproveUsers ){
                foreach($companyApproveUsers as $cAppKey => $cAppValue){
                    foreach($cAppValue as $userKey => $userValue){
                        $options[$cAppKey][] = ['id' => $userValue,'name' => getSingleAndWhere('name','user_detail',
                                            ['u_id' => $userValue ])  ];
                    }
                }
            }
        }

        $this->data['approveUsers'] = $options;

        $this->data['order'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);

        if (!empty($this->data['poCreate']))
            $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material', 'material_type_id', $this->data['poCreate']->material_type_id);
        if (!empty($this->data['order']))
            $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material', 'material_type_id', $this->data['order']->material_type_id);
        $this->load->view('purchase_order/convert_to_po', $this->data);
    }
    #public function order_edit(){
    public function rfq_convert_to_po() {
        $id = $_POST['id'];
		
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }

        $this->data['materialType'] = $this->purchase_model->get_data('material_type');

        $this->data['getRfqData'] = $this->purchase_model->getDataByWhereId('purchase_rfq',['product_induction_id' => $id,'selected_status' => 1 ]);
		

        $supplierId = [];
        foreach ($this->data['getRfqData'] as $key => $value) {
            $supplierId[] =  $value['supplier_id'];
        }
        if($supplierId){
            $this->data['suppliername'] = $this->purchase_model->getDataWhereIn('supplier','id',$supplierId,['id','name']);
        }

        $this->data['materialName'] = $this->purchase_model->get_data('material');
        $this->data['poCreate'] = $this->purchase_model->get_data_byId('purchase_indent', 'id', $id);
        $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $id); //For Document Attachment fetch
        $this->data['order'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);
        if (!empty($this->data['poCreate'])) $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material', 'material_type_id', $this->data['poCreate']->material_type_id);
        if (!empty($this->data['order'])) $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material', 'material_type_id', $this->data['order']->material_type_id);
        $this->load->view('rfq_details/convert_to_po', $this->data);
    }

    function materialSelectedBySupplier(){
        $indentId = $_POST['indent_id'];
        $supplierId = $_POST['supplier_id'];

        $this->data['getRfqData'] = $this->purchase_model->getDataByWhereId('purchase_rfq',['product_induction_id' => $indentId,'selected_status' => 1,
                    'supplier_id' => $supplierId ]);
        $this->data['poCreate'] = $this->purchase_model->get_data_byId('purchase_indent', 'id',$indentId);

        $materialData = json_decode($this->data['poCreate']->material_name);

        $newMaterialData = [];
        if( $this->data['getRfqData'] ){
            foreach ($this->data['getRfqData'] as $key => $value) {
                foreach ($materialData as $materialKey => $materialValue) {
                    if( $materialValue->remaning_qty > 0 ){
                            if($value['product_id'] == $materialValue->material_name_id ){
                            $newMaterialData[$key]['material_type'] =  $materialValue->material_type_id;
                            $newMaterialData[$key]['material_name'] =  $materialValue->material_name_id;
                            $newMaterialData[$key]['description'] =  $materialValue->description;
                            $newMaterialData[$key]['quantity'] =  $materialValue->quantity;
                            $newMaterialData[$key]['uom'] =  $materialValue->uom;
                            $newMaterialData[$key]['expected_amount'] =  $value['supplier_expected_amount'];
                            $newMaterialData[$key]['purpose'] =  $materialValue->purpose;
                            $newMaterialData[$key]['sub_total'] =  ($materialValue->quantity * $value['supplier_expected_amount']);
                            $newMaterialData[$key]['remaning_qty'] = $materialValue->remaning_qty;
                        }
                    }
                }
            }
        }

        if( $newMaterialData ){
            $i = 1;
            $j['i'] = $i;
            $grand_total = ['grand_total' => 0];
            foreach ($newMaterialData as $key => $value) {
                $value = $value + ['i' => $key+1 ] + $grand_total;
                echo $this->load->view('rfq_details/supplierMaterial',$value);
            }
        }

    }

    /*purchase order add/edit*/
    public function po_edit() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $get_id_for_docss = array('purchase_order.id' => $_POST['id'], 'purchase_order.save_status' => 1);
        $get_docss_data = $this->purchase_model->get_data('purchase_order', $get_id_for_docss);
        if ($get_docss_data[0]['pi_id'] != 0) {
            $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $get_docss_data[0]['pi_id']); //For Document Attachment fetch

        } else {
            $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $id); //For Document Attachment fetch

        }

        $options = [];
        if( checkPurchaseApprove() ){
            $companyApproveUsers = json_decode(getSingleAndWhere('po_approve_users','company_detail',
                                        ['id' => $this->companyGroupId ]),true );
            if( $companyApproveUsers ){
                foreach($companyApproveUsers as $cAppKey => $cAppValue){
                    foreach($cAppValue as $userKey => $userValue){
                        $options[$cAppKey][] = ['id' => $userValue,'name' => getSingleAndWhere('name','user_detail',
                                            ['u_id' => $userValue ])  ];
                    }
                }
            }
        }

        $this->data['approveUsers'] = $options;

        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['materialName'] = $this->purchase_model->get_data('material');
        $this->data['order'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);
        if (!empty($this->data['poCreate'])) $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material', 'material_type_id', $this->data['poCreate']->material_type_id);
        if (!empty($this->data['order'])) $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material', 'material_type_id', $this->data['order']->material_type_id);
        $this->load->view('purchase_order/edit', $this->data);
    }
    /*purchase order add/edit*/
    public function order_view() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_view');
        }
        $data_get_for_docss = array('purchase_order.id' => $id, 'purchase_order.save_status' => 1);
        $docs_data = $this->purchase_model->get_data('purchase_order', $data_get_for_docss);

        if ($docs_data[0]['pi_id'] != 0) {
            $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $docs_data[0]['pi_id']); //For Document Attachment fetch

        } else {
            $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $id); //For Document Attachment fetch

        }
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['orders'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);
        //Code For Change Status*/
        $this->data['orders'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);
        $wherePo = array('purchase_order.id' => $id, 'purchase_order.save_status' => 1);
        $this->data['po'] = $this->purchase_model->get_data('purchase_order', $wherePo);
        $whereMrn = array('mrn_detail.pi_id' => $id, 'mrn_detail.save_status' => 1);
        $whereMrn = array('mrn_detail.po_id' => $id, 'mrn_detail.save_status' => 1);
        $this->data['mrn'] = $this->purchase_model->get_data('mrn_detail', $whereMrn);
        //Code For Change Status*/
        $this->load->view('purchase_order/view', $this->data);
    }
    public function Purchase_order_Mat_View() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_view');
        }
        $data_get_for_docss = array('purchase_order.id' => $id, 'purchase_order.save_status' => 1);
        $docs_data = $this->purchase_model->get_data('purchase_order', $data_get_for_docss);
        if ($docs_data[0]['pi_id'] != 0) {
            $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $docs_data[0]['pi_id']); //For Document Attachment fetch

        } else {
            $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $id); //For Document Attachment fetch

        }
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['orders'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);
        //Code For Change Status*/
        $this->data['orders'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);
        $wherePo = array('purchase_order.id' => $id, 'purchase_order.save_status' => 1);
        $this->data['po'] = $this->purchase_model->get_data('purchase_order', $wherePo);
        $whereMrn = array('mrn_detail.pi_id' => $id, 'mrn_detail.save_status' => 1);
        $whereMrn = array('mrn_detail.po_id' => $id, 'mrn_detail.save_status' => 1);
        $this->data['mrn'] = $this->purchase_model->get_data('mrn_detail', $whereMrn);
        //Code For Change Status*/
        $this->load->view('purchase_order/mat_view', $this->data);
    }
    /*save purchase order*/
    public function saveOrder() {
		 // 

        $itemLength = count($_POST['material_name']);
        $newItemArray = "";
        $item_array = '';
        $item_array_challan = '';
       if ($itemLength > 0 && $_POST['material_name'][0] != '') {
            $arr = [];
            $i = 0;
            $price_sum = '';
            while ($i < $itemLength) {
                $material_id = $_POST['material_name'][$i];
                $this->purchase_model->update_single_value_data('material', array('cost_price' => $_POST['price'][$i]), array('id' => $material_id, 'created_by_cid' => $this->companyGroupId));
				
                $jsonArrayObject = (array('material_type_id' => $_POST['material_type_id'][$i],'material_name_id' => $_POST['material_name'][$i], 'description' => $_POST['description'][$i], 'uom' => $_POST['uom'][$i],'hsnCode' => $_POST['hsnCode'][$i],'hsnId' => $_POST['hsnId'][$i],
                 'quantity' => $_POST['quantity'][$i], 'price' => $_POST['price'][$i], 'discount' => $_POST['discount'][$i], 'sub_tax' => $_POST['sub_tax'][$i], 'sub_total' => $_POST['sub_total'][$i], 'gst' => $_POST['gst'][$i], 'total' => $_POST['total'][$i], 'remove_mat_id' => $_POST['remove_mat'][$i], 'remaning_qty' => $_POST['quantity'][$i], 'description_check' => $_POST['description_check'][$i],'bom_number' => $_POST['bom_number'][$i],'process_name' => $_POST['process_name'][$i],'aliasname' => $_POST['aliasname'][$i]));
                $arr[$i] = $jsonArrayObject;

                if($_POST['is_outsource_process'] == 1){
                    $jsonArrayObject_dilivery_challan = (array('material_id' =>$_POST['material_name'][$i],'discount' => $_POST['discount'][$i],'descr_of_goods' => $_POST['description'][$i],'hsnsac' => $_POST['hsnsac'][$i],'hsnCode' => $_POST['hsnCode'][$i],'hsnId' => $_POST['hsnId'][$i],'quantity' => $_POST['quantity'][$i], 'rate' => $_POST['price'][$i],'UOM' => $_POST['uom'][$i],'amount'=>$_POST['sub_total'][$i],'bom_number'=>$_POST['bom_number'][$i],'process_name'=>$_POST['process_name'][$i],'aliasname' => $_POST['aliasname'][$i]));
                    $arr_dilivery[$i] = $jsonArrayObject_dilivery_challan;
                    $price_sum += $_POST['sub_total'][$i];
                }
				
				
			 $i++;
           }
		 
		   foreach($arr as  $matPrice){
				$dataupdate = array('cost_price'=>$matPrice['price']); 
			    $this->purchase_model->update_material('material', $dataupdate, 'id', $matPrice['material_name_id']);
			}
		    $newItemArray = $arr;
            $item_array = json_encode($arr);
            $item_array_challan = json_encode($arr_dilivery);
        }
		
		
		

        $purchase_indent_id = $_POST['pi_id'];
        $where = array('id' => $purchase_indent_id);
        $pI_data = $this->purchase_model->get_data('purchase_indent', $where);
        $matrial_jsonString = $pI_data[0]['material_name'];
        //Code For add for Multiple Supplier and material quantity End
        $pi_data1 = json_decode($matrial_jsonString, TRUE);
        $po_data = json_decode($item_array, TRUE);



        $updated_data_for_pi = array();
        $array_for_pi = array();
        $count1 = 0;
        /*pre($po_data);
        pre($pi_data1);die;*/

        foreach ($po_data as $key => $po_item) {
            foreach ($pi_data1 as $key => $pi_item) {
                //pre($pi_item);die();
                #if(    $po_item['material_name_id'] == $pi_item['material_name_id'] && $pi_item['remaning_qty'] != '0'){
                if ($po_item['material_name_id'] == $pi_item['material_name_id'] && $pi_item['remaning_qty'] != '0' && ($po_item['description_check'] == $pi_item['description'])) {
                    if( $pi_item['remaning_qty'] < $po_item['quantity'] ){
                        $remaing_mat_qty = 0;
                    }else{
                        $remaing_mat_qty = $pi_item['remaning_qty'] - $po_item['quantity'];
                    }
                    $array_for_pi[] = array('material_type_id'=>$pi_item['material_type_id'],'material_name_id' => $pi_item['material_name_id'], 'description' => $pi_item['description'],'hsnCode' => $pi_item['hsnCode'],'hsnId' => $pi_item['hsnId'], 'quantity' => $pi_item['quantity'], 'uom' => $pi_item['uom'], 'expected_amount' => $pi_item['expected_amount'], 'purpose' => $pi_item['purpose'], 'sub_total' => $pi_item['sub_total'], 'remaning_qty' => $remaing_mat_qty,'aliasname' => $pi_item['aliasname']);
                    $count1++;
                } elseif ($po_item['material_name_id'] == '' && $po_item['remove_mat_id'] == $pi_item['material_name_id']) {
                    $array_for_pi[] = array('material_type_id'=>$pi_item['material_type_id'],'material_name_id' => $pi_item['material_name_id'], 'description' => $pi_item['description'],'hsnCode' => $pi_item['hsnCode'],'hsnId' => $pi_item['hsnId'], 'quantity' => $pi_item['quantity'], 'uom' => $pi_item['uom'], 'expected_amount' => $pi_item['expected_amount'], 'purpose' => $pi_item['purpose'], 'sub_total' => $pi_item['sub_total'], 'remaning_qty' => $pi_item['remaning_qty'],'aliasname' => $pi_item['aliasname']);
                    $count1++;
                } elseif ($pi_item['remaning_qty'] == '0') {
                    //echo '3';
                    $array_for_pi[] = array('material_type_id'=>$pi_item['material_type_id'],'material_name_id' => $pi_item['material_name_id'], 'description' => $pi_item['description'],'hsnCode' => $pi_item['hsnCode'],'hsnId' => $pi_item['hsnId'], 'quantity' => $pi_item['quantity'], 'uom' => $pi_item['uom'], 'expected_amount' => $pi_item['expected_amount'], 'purpose' => $pi_item['purpose'], 'sub_total' => $pi_item['sub_total'], 'remaning_qty' => $pi_item['remaning_qty'],'aliasname' => $pi_item['aliasname']);
                    $count1++;
                }
            }
        }

        if( checkPurchaseDisApprove() ){
            $this->purchase_model->updateWhere('purchase_order',['approve_user_detail' => ''],['id' => $_POST['id']]);
        }

        if( $_POST['rfq_to_po'] ){
            $i = 0;
            $uniqueData = [];
            foreach ($pi_data1 as $key => $value) {
                    if( !isset($array_for_pi[$i]['material_type_id']) ){
                        $uniqueData[$i]['material_type_id'] = $value['material_type_id'];
                        $uniqueData[$i]['material_name_id'] = $value['material_name_id'];
                        $uniqueData[$i]['hsnCode'] = $value['hsnCode']??'';
                        $uniqueData[$i]['hsnId'] = $value['hsnId']??'';
                        $uniqueData[$i]['description'] = $value['description'];
                        $uniqueData[$i]['quantity'] = $value['quantity'];
                        $uniqueData[$i]['uom'] = $value['uom'];
                        $uniqueData[$i]['expected_amount'] = $value['expected_amount'];
                        $uniqueData[$i]['remaning_qty'] = $value['remaning_qty'];
                        $uniqueData[$i]['sub_total'] = $value['quantity']  * $value['expected_amount'];
                        $uniqueData[$i]['purpose'] = $value['purpose'];
                        $uniqueData[$i]['aliasname'] = $value['aliasname'];
                        // $uniqueData[$i]['lastpurchaseprce'] = $value['lastpurchaseprce'];
                    }
               $i++;
            }
        }

        $updated_data_for_pi = $array_for_pi;
        $afterdata_sort = array_unique($updated_data_for_pi, SORT_REGULAR);

        if (isset($_POST['convert_PI_to_PO'])) { //when only purchase order update
            if( $_POST['rfq_to_po'] ) { $afterdata_sort = mergeMultiDemArray($afterdata_sort,$uniqueData); }
            $remaning_data = json_encode($afterdata_sort);
            $indentUpdated = $this->purchase_model->update_pI_material_data('purchase_indent', $purchase_indent_id, $remaning_data);
            /*  change PO status in PI start   */
            if ($indentUpdated) {
                if (!empty($pI_data) && $pI_data[0]['status'] == '') {
                    $piArray = array();
                    $piArray['PO'] = array('name' => 'PO', 'po_or_verbal' => 'po_code');
                    $piJsonArray = JSON_encode($piArray);
                    $statusArray = array('status' => $piJsonArray);
                    $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $pI_data[0]['id']);
                    $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_order', $statusArray, 'pi_id', $pI_data[0]['id']);
                } else {
                    $piArray = $this->objectToArray(json_decode($pI_data[0]['status']));
                    $piArray['PO'] = array('name' => 'PO', 'po_or_verbal' => 'po_code');
                    $piJsonArray = JSON_encode($piArray);
                    $statusArray = array('status' => $piJsonArray);
                    $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $pI_data[0]['id']);
                    $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_order', $statusArray, 'pi_id', $pI_data[0]['id']);
                }
            }
            /*  change PO status in PI  end*/
            /* Code used for when Purchase Indent Complete*/
            $pi_data_to_check_rem_qty = json_decode($matrial_jsonString, TRUE);
            $rem_qty = 0;
            $rm_QTY = array_count_values(array_column($afterdata_sort, 'remaning_qty')) [$rem_qty];
            $count22 = 0;
            foreach ($pi_data_to_check_rem_qty as $type) {
                $count22 += count($type['remaning_qty']);
            }

            if(isset($_POST['purchaseComplete'])){
                if( $_POST['purchaseComplete'] == 1 ){
                    //$this->purchase_model->update_po_single_data('purchase_indent', $_POST['pi_id']); //MRN_or_not
                    $this->purchase_model->update_pI_single_data('purchase_indent', $_POST['pi_id']);
                }
            }



            if ($rm_QTY == $count22) { //this Count Check material count is equal to material  qty
                //$this->purchase_model->update_po_single_data('purchase_indent', $_POST['pi_id']); //MRN_or_not
                $this->purchase_model->update_pI_single_data('purchase_indent', $_POST['pi_id']);
            }
            /* Code used for when Purchase Indent Complete*/
        }
		
            $required_fields = array('supplier_name');
        if ($this->input->post()) {
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
                $this->session->set_flashdata('message', 'Please check Required Fields');
                redirect(base_url() . 'purchase/purchase_order', 'refresh');
            } else {
                $data = $this->input->post();
                $data['order_code'] = ($data['revised_po_code'] != '') ? $data['revised_po_code'] : $data['order_code'];
                $materialUpdateIds = implode("','", $data['material_name']);
                $materialUpdateIds = "'" . $materialUpdateIds . "'";
                $materialTypeUpdateIds = implode("','", $data['material_type_id']);
                $materialTypeUpdateIds = "'" . $materialTypeUpdateIds . "'";
                $data['created_by_cid'] = $this->companyGroupId;
                $data['selectApproveUsers'] = json_encode($_POST['selectApproveUsers']);

                if( $data['convert_po_to_mrn'] ){
                    $mData = json_encode(checkMaterialQty($newItemArray));
                }else{
                    $mData = $item_array;
                }

                $data['material_name'] = $mData;
                $data['date'] = $_POST['date'];
                #$data['charges_added'] = $json_charg_lead_total_array;
                $data['pi_id'] = $data['pi_id'];

                $id = $data['id'];
                $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 2));
                //pre($data);die('There new issue');
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    //pre($data); die;
                    $success = $this->purchase_model->update_data('purchase_order', $data, 'id', $id);
                    if ($success) {
                        /* update cost price of material to fetch last cost price of material  */
                        if (!empty($arr)) {
                            /*foreach ($arr as $res) {
                                $this->purchase_model->update_single_value_data('material', array('cost_price' => $res['price']), array('id' => $res['material_name_id'], 'created_by_cid' => $this->companyGroupId));
                            }
							*/                     
						}
					/* Supplier Update Price functionality */
					 $supplierId=$data['supplier_name'];
                     $supplierMaterialData = getNameById('supplier',$supplierId,'id');
                     $supplierMaterialDataDecode =  json_decode($supplierMaterialData->material_name_id,true);
                     $materialIdSupp=$materialId=$materialvalue= $newarraySuppleyer= $newarraySuppleyer2=$materialIdAllData=[];
					   foreach ($supplierMaterialDataDecode as $value) {
								 $materialIdSupp[]= $value['material_name']; 
								 $materialIdAllData[]=$value;
							  }
						 foreach ($newItemArray as $value1) {
						   $materialId[]=$value1['material_name_id'];
						   $materialvalue[]=$value1;
						 }  
							$arrayDiff=array_diff($materialIdSupp,$materialId);
                            foreach ($materialIdAllData as $key02 => $valuenew) {
                                  foreach ($arrayDiff as $keyabc => $abcvalue) {
                                      if($keyabc==$key02 && $abcvalue==$valuenew['material_name']){
                                         $newarraySuppleyer[]= $valuenew;
                                       }
                                  }
                             }
						 foreach($materialId as $key => $newmat){
							if(in_array($newmat, $materialIdSupp)){
							   
								 if($materialvalue[$key]['material_name_id']==$newmat){
									 $uomDtl = getNameById('uom',$materialvalue[$key]['uom'],'id');
									
										$newarraySuppleyer[]=[
													 'material_type_id'=>$materialvalue[$key]['material_type_id'],
													 'material_name'=>$materialvalue[$key]['material_name_id'],
													 // 'uom'=>$materialvalue[$key]['uom'], 
													 'uom'=>$uomDtl->uom_quantity, 
													 'price'=>$materialvalue[$key]['price']
													];
								  }
							}else{
								
							   if($materialvalue[$key]['material_name_id']==$newmat){
								     $uomDtl = getNameById('uom',$materialvalue[$key]['uom'],'id');
											 $newarraySuppleyer[]=[
													 'material_type_id'=>$materialvalue[$key]['material_type_id'],
													 'material_name'=>$materialvalue[$key]['material_name_id'],
													 // 'uom'=>$materialvalue[$key]['uom'], 
													 'uom'=>$uomDtl->uom_quantity, 
													 'price'=>$materialvalue[$key]['price']
													];
								  }
							  }
						 }
								
						$updateData = array('material_name_id' => json_encode($newarraySuppleyer));
						$update = $this->purchase_model->update_material('supplier', $updateData, 'id', $supplierId);					
					/* Supplier Update Price functionality */	

                       if ($materialTypeUpdateIds != "''") updateMultipleUsedIdStatus('material_type', $materialTypeUpdateIds);
                        if ($materialUpdateIds != "''") updateMultipleUsedIdStatus('material', $materialUpdateIds);
                        if ($data['supplier_name'] != "") updateUsedIdStatus('supplier', $data['supplier_name']);
                        $data['message'] = "Purchase order updated successfully";
                        logActivity('purchase order Updated', 'purchase_order', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'Purchase order updated', 'message' => 'Purchase order id : #' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'OrderView', 'icon' => 'fa-shopping-cart'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'Purchase order updated', 'message' => 'Purchase order id : #' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'OrderView', 'icon' => 'fa-shopping-cart'));
                        }
                        $this->session->set_flashdata('message', 'Purchase order Updated successfully');
                        //redirect(base_url().'purchase/purchase_order', 'refresh');

                    }
                } else {
                    $data['created_by'] = $_SESSION['loggedInUser']->u_id;
					
					
					$success = $this->purchase_model->insert_tbl_data('purchase_order', $data);
					/*Supplier Price Update Functionality*/
					 $supplierId=$data['supplier_name'];
					   $supplierMaterialData = getNameById('supplier',$supplierId,'id');
					   $supplierMaterialDataDecode =  json_decode($supplierMaterialData->material_name_id,true);
					   $materialIdSupp=$materialId=$materialvalue= $newarraySuppleyer= $newarraySuppleyer2=$materialIdAllData=[];
					   foreach ($supplierMaterialDataDecode as $value) {
							 $materialIdSupp[]= $value['material_name']; 
							 $materialIdAllData[]=$value;
						  }
						 foreach ($newItemArray as $value1) {
						   $materialId[]=$value1['material_name_id'];
						   $materialvalue[]=$value1;
						 }  
						 $arrayDiff=array_diff($materialIdSupp,$materialId);
							foreach ($materialIdAllData as $key02 => $valuenew) {
								  foreach ($arrayDiff as $keyabc => $abcvalue) {
									  if($keyabc==$key02 && $abcvalue==$valuenew['material_name']){
										 $newarraySuppleyer[]= $valuenew;
									   }
								  }
							 }
						foreach($materialId as $key => $newmat){
								if(in_array($newmat, $materialIdSupp)){
							if($materialvalue[$key]['material_name_id']==$newmat){
								$uomDtl = getNameById('uom',$materialvalue[$key]['uom'],'id');
									$newarraySuppleyer[]=[
                                         'material_type_id'=>$materialvalue[$key]['material_type_id'],
                                         'material_name'=>$materialvalue[$key]['material_name_id'],
                                         // 'uom1'=>$materialvalue[$key]['uom'],
											'uom'=>$uomDtl->uom_quantity, 										 
                                         'price'=>$materialvalue[$key]['price']
                                        ];
								}
							}else{
                                 if($materialvalue[$key]['material_name_id']==$newmat){
									 $uomDtl = getNameById('uom',$materialvalue[$key]['uom'],'id');
										$newarraySuppleyer[]=[
											'material_type_id'=>$materialvalue[$key]['material_type_id'],
											'material_name'=>$materialvalue[$key]['material_name_id'],
											// 'uom1'=>$materialvalue[$key]['uom'],
												'uom'=>$uomDtl->uom_quantity, 											
												'price'=>$materialvalue[$key]['price']
											];
									}
							}
					}  
                $updateData = array('material_name_id' => json_encode($newarraySuppleyer));
				$update = $this->purchase_model->update_material('supplier', $updateData, 'id', $supplierId);
				/*Supplier Price Update Functionality*/	
					
                    if($_POST['is_outsource_process'] == 1){
                        $p_Data = get_challan_number_count('challan_dilivery',$this->companyGroupId ,'created_by_cid');
                        $Challan_id =  $p_Data->total_challan + 1;
                        $data_challan_diliv_tbl['descr_of_goods'] = $item_array_challan;
                        $data_challan_diliv_tbl['party_name'] = $data['supplier_name'];
                        $data_challan_diliv_tbl['puo_id'] = $success;
                        $data_challan_diliv_tbl['auto_entry_po'] = 1;
                        $data_challan_diliv_tbl['challan_type'] = 0;
                        $data_challan_diliv_tbl['challan_num'] = sprintf("%04s", $Challan_id);
                        $data_challan_diliv_tbl['challan_total_amt'] = $price_sum;
                        $data_challan_diliv_tbl['created_by_cid'] = $this->companyGroupId;
                        $data_challan_diliv_tbl['created_by'] = $_SESSION['loggedInUser']->u_id;
                        $this->purchase_model->insert_tbl_data('challan_dilivery', $data_challan_diliv_tbl);
                    }


                     if ($materialTypeUpdateIds != "''") updateMultipleUsedIdStatus('material_type', $materialTypeUpdateIds);
                    if ($materialUpdateIds != "''") updateMultipleUsedIdStatus('material', $materialUpdateIds);
                    if ($data['supplier_name'] != "") updateUsedIdStatus('supplier', $data['supplier_name']);
                    if ($data['pi_id'] != "") updateUsedIdStatus('purchase_indent', $data['pi_id']);
                    $pi_id = $data['pi_id'];
                    if ($success) {
                        /* update cost price of material to fetch last cost price of material  */
                        if (!empty($arr)) {
                            /*foreach ($arr as $res) {
                                $this->purchase_model->update_single_value_data('material', array('cost_price' => $res['price']), array('id' => $res['material_name_id'], 'created_by_cid' => $this->companyGroupId));
                            }
*/                        }

                        logActivity('purchase order inserted', 'purchase_order', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'New purchase order created', 'message' => 'New purchase order is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $success, 'class' => 'add_purchase_tabs', 'data_id' => 'OrderView', 'icon' => 'fa-shopping-cart'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'New purchase order created', 'message' => 'New purchase order is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $success, 'class' => 'add_purchase_tabs', 'data_id' => 'OrderView', 'icon' => 'fa-shopping-cart'));
                        }
                        $this->session->set_flashdata('message', 'Purchase order inserted successfully');
                        //redirect(base_url().'purchase/purchase_order', 'refresh');

                    }
                }
                if ($_POST['pi_id'] != 0 && $_POST['pi_id'] != '') {
                    $doc_id = $_POST['pi_id'];
                    //echo '1';

                } else if ($_POST['pi_id'] == 0) {
                    $doc_id = $_POST['id'];
                    //echo '2';

                } else {
                    $doc_id = $success;
                }
                // pre($doc_id);
                // pre($_POST);
                // die();
                if ($doc_id) {
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
                            $proof_array[$i]['rel_id'] = $doc_id;
                            $proof_array[$i]['rel_type'] = 'PI_PO_MRN';
                            $proof_array[$i]['file_name'] = $newname;
                            $proof_array[$i]['file_type'] = $type;
                        }
                        //pre($proof_array);die('dfdfdfdfdf');
                        if (!empty($proof_array)) {
                            /* Insert file information into the database */
                            $proofId = $this->purchase_model->insert_attachment_data('attachments', $proof_array, 'PI_PO_MRN');
                        }
                    }
                }
                redirect(base_url() . 'purchase/purchase_order', 'refresh');
            }
        }
    }
    /*save purchase order*/
    public function saveRFQOrder() {
         //pre($_POST);die;
        $itemLength = count($_POST['material_name']);
        $supplier_array = array();
           if ($itemLength > 0 && $_POST['material_name'][0] != '') {
               $arr = [];
              $i = 0;
               while ($i < $itemLength) {
                    $material_id = $_POST['material_name'][$i];
                    $pro_id="pro_id_".$material_id;
                    $selected_pro =  explode("_",$_POST[$pro_id]);
                    $supplier_details = $_POST['supplier_details'];
                    foreach($supplier_details as $key=>$val){
                        if($key == $selected_pro[0]){
                            $supplierUpdateIds[] = $selected_pro[0];
                            $supplier_array[$key][] = $selected_pro[1];
                        }
                    }
                    $jsonArrayObject = (array('material_name_id' => $_POST['material_name'][$i], 'description' => $_POST['description'][$i], 'uom' => $_POST['uom'][$i], 'quantity' => $_POST['quantity'][$i], 'price' => $_POST['price'][$i], 'sub_tax' => $_POST['sub_tax'][$i], 'sub_total' => $_POST['sub_total'][$i], 'gst' => $_POST['gst'][$i], 'total' => $_POST['total'][$i], 'remove_mat_id' => $_POST['remove_mat'][$i], 'remaning_qty' => $_POST['quantity'][$i], 'description_check' => $_POST['description_check'][$i]));
                    $arr[$i] = $jsonArrayObject;
                    $i++;
               }
               $item_array = json_encode($arr);
        $supplierUpdateIds = array_unique($supplierUpdateIds);

          }else {
            $item_array = '';
        }
        //  pre($_POST);pre($supplier_array);



    //  Compare of MATERIAL indent and Order
             $purchase_indent_id = $_POST['pi_id'];
            $where = array('id' => $purchase_indent_id);
            $pI_data = $this->purchase_model->get_data('purchase_indent', $where);
            $matrial_jsonString = $pI_data[0]['material_name'];
            //Code For add for Multiple Supplier and material quantity End
            $pi_data1 = json_decode($matrial_jsonString, TRUE);
            $po_data = json_decode($item_array, TRUE);
            $updated_data_for_pi = array();
            $array_for_pi = array();
            $count1 = 0;
            foreach ($po_data as $key => $po_item) {
                foreach ($pi_data1 as $key => $pi_item) {
                    #if(    $po_item['material_name_id'] == $pi_item['material_name_id'] && $pi_item['remaning_qty'] != '0'){
                    if ($po_item['material_name_id'] == $pi_item['material_name_id'] && $pi_item['remaning_qty'] != '0' && ($po_item['description_check'] == $pi_item['description'])) {
                        //echo '1';
                        $remaing_mat_qty = $pi_item['remaning_qty'] - $po_item['quantity'];
                        $array_for_pi[] = array('material_name_id' => $pi_item['material_name_id'], 'description' => $pi_item['description'], 'quantity' => $pi_item['quantity'], 'uom' => $pi_item['uom'], 'expected_amount' => $pi_item['expected_amount'], 'purpose' => $pi_item['purpose'], 'sub_total' => $pi_item['sub_total'], 'remaning_qty' => $remaing_mat_qty);
                        $count1++;
                    } elseif ($po_item['material_name_id'] == '' && $po_item['remove_mat_id'] == $pi_item['material_name_id']) {
                        //echo '2';
                        $array_for_pi[] = array('material_name_id' => $pi_item['material_name_id'], 'description' => $pi_item['description'], 'quantity' => $pi_item['quantity'], 'uom' => $pi_item['uom'], 'expected_amount' => $pi_item['expected_amount'], 'purpose' => $pi_item['purpose'], 'sub_total' => $pi_item['sub_total'], 'remaning_qty' => $pi_item['remaning_qty'],);
                        $count1++;
                    } elseif ($pi_item['remaning_qty'] == '0') {
                        //echo '3';
                        $array_for_pi[] = array('material_name_id' => $pi_item['material_name_id'], 'description' => $pi_item['description'], 'quantity' => $pi_item['quantity'], 'uom' => $pi_item['uom'], 'expected_amount' => $pi_item['expected_amount'], 'purpose' => $pi_item['purpose'], 'sub_total' => $pi_item['sub_total'], 'remaning_qty' => $pi_item['remaning_qty'],);
                        $count1++;
                    }
                }
            }
         $updated_data_for_pi = $array_for_pi;
        $afterdata_sort = array_unique($updated_data_for_pi, SORT_REGULAR);
        if (isset($_POST['convert_RFQ_to_PO'])) {
            //when only purchase order update
            $remaning_data = json_encode($afterdata_sort);
            $indentUpdated = $this->purchase_model->update_pI_material_data('purchase_indent', $purchase_indent_id, $remaning_data);
            /*  change PO status in PI start   */
            if ($indentUpdated) {
                if (!empty($pI_data) && $pI_data[0]['status'] == '') {
                    $piArray = array();
                    $piArray['PO'] = array('name' => 'PO', 'po_or_verbal' => 'po_code');
                    $piJsonArray = JSON_encode($piArray);
                    $statusArray = array('status' => $piJsonArray);
                    $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $pI_data[0]['id']);
                    $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_order', $statusArray, 'pi_id', $pI_data[0]['id']);
                } else {
                    $piArray = $this->objectToArray(json_decode($pI_data[0]['status']));
                    $piArray['PO'] = array('name' => 'PO', 'po_or_verbal' => 'po_code');
                    $piJsonArray = JSON_encode($piArray);
                    $statusArray = array('status' => $piJsonArray);
                    $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $pI_data[0]['id']);
                    $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_order', $statusArray, 'pi_id', $pI_data[0]['id']);
                }
            }
            /*  change PO status in PI  end*/
            /* Code used for when Purchase Indent Complete*/
            $pi_data_to_check_rem_qty = json_decode($matrial_jsonString, TRUE);
            $rem_qty = 0;
            $rm_QTY = array_count_values(array_column($afterdata_sort, 'remaning_qty')) [$rem_qty];
            $count22 = 0;
            foreach ($pi_data_to_check_rem_qty as $type) {
                $count22+= count($type['remaning_qty']);
            }
            if ($rm_QTY == $count22) { //this Count Check material count is equal to material  qty
                $this->purchase_model->update_po_single_data('purchase_indent', $_POST['pi_id']); //MRN_or_not
                $this->purchase_model->update_pI_single_data('purchase_indent', $_POST['pi_id']);
            }
            /* Code used for when Purchase Indent Complete*/
        }
        if ($this->input->post()) {
            $required_fields = array('supplier_name', 'material_type_id');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
                $this->session->set_flashdata('message', 'Please check Required Fields');
                redirect(base_url() . 'purchase/purchase_order', 'refresh');
            } else {
                $data = $this->input->post();
                $materialUpdateIds = implode("','", $data['material_name']);
                 if ($supplierUpdateIds != "")  $supplierUpdateIds = implode("','", $supplierUpdateIds);
                $materialUpdateIds = "'" . $materialUpdateIds . "'";
                 $supplierUpdateIds = "'" . $supplierUpdateIds . "'";

                $data['created_by_cid'] = $this->companyGroupId;
                $data['date'] = $_POST['date'];
                #$data['charges_added'] = $json_charg_lead_total_array;
                $data['pi_id'] = $data['pi_id'];
                $id = $data['id'];
                $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 2));
                //pre($data);die('There new issue');
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    //pre($data); die;
                    foreach($supplier_array as $supp_key=>$pro_val){
                           //  Array of MATERIAL based on Supplier
                            $itemLength = count($pro_val);
                            if ($itemLength > 0 && $pro_val[0] != '') {
                            $material_ids = $this->input->post('material_name');
                            $materialarr = [];
                            $i = 0;
                            while ($i < $itemLength) {
                                $material_id = $pro_val[$i];
                                        //pre($_POST['material_name']);die;
                                $key = array_search($material_id, $material_ids); // $key = 2;
                                $materialjsonArrayObject = (array('material_name_id' => $_POST['material_name'][$key], 'description' => $_POST['description'][$key], 'uom' => $_POST['uom'][$key], 'quantity' => $_POST['quantity'][$key], 'price' => $_POST['price'][$key], 'sub_tax' => $_POST['sub_tax'][$key], 'sub_total' => $_POST['sub_total'][$key], 'gst' => $_POST['gst'][$key], 'total' => $_POST['total'][$key], 'remove_mat_id' => $_POST['remove_mat'][$key], 'remaning_qty' => $_POST['quantity'][$key], 'description_check' => $_POST['description_check'][$key]));
                                $materialarr[$i] = $materialjsonArrayObject;
                                $i++;
                            }
                            $material_item_array = json_encode($materialarr);
                        } else {
                            $material_item_array = '';
                        }
                     $data['material_name'] = $material_item_array;
                     $data['supplier_name'] = $supp_key;
                        $last_id = $this->purchase_model->getLastTableId('purchase_order');
                      $data['order_code'] = ($data['revised_po_code'] != '') ? $data['revised_po_code'] : $data['order_code'];
                    $success = $this->purchase_model->update_data('purchase_order', $data, 'id', $id);

                    }
                    if ($success) {
                        /* update cost price of material to fetch last cost price of material  */
                        if (!empty($arr)) {
                            /*foreach ($arr as $res) {
                                $this->purchase_model->update_single_value_data('material', array('cost_price' => $res['price']), array('id' => $res['material_name_id'], 'created_by_cid' => $this->companyGroupId));
                            }*/
                        }
                        if ($data['material_type_id'] != '') updateUsedIdStatus('material_type', $data['material_type_id']);
                        if ($materialUpdateIds != "''") updateMultipleUsedIdStatus('material', $materialUpdateIds);
                        if ($data['supplier_name'] != "") updateUsedIdStatus('supplier', $data['supplier_name']);
                        if ($supplierUpdateIds != "") updateMultipleUsedIdStatus('supplier', $supplierUpdateIds);

                        $data['message'] = "Purchase order updated successfully";
                        logActivity('purchase order Updated', 'purchase_order', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'Purchase order updated', 'message' => 'Purchase order id : #' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'OrderView', 'icon' => 'fa-shopping-cart'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'Purchase order updated', 'message' => 'Purchase order id : #' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'OrderView', 'icon' => 'fa-shopping-cart'));
                        }
                        $this->session->set_flashdata('message', 'Purchase order Updated successfully');
                        //redirect(base_url().'purchase/purchase_order', 'refresh');

                    }
                } else {
					
                    $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                     // Add Order Selected Supplier Based
                    foreach($supplier_array as $supp_key=>$pro_val){
                           //  Array of MATERIAL based on Supplier
                            $itemLength = count($pro_val);
                            if ($itemLength > 0 && $pro_val[0] != '') {
                            $material_ids = $this->input->post('material_name');
                            $materialarr = [];
                            $i = 0;
                            while ($i < $itemLength) {
                                $material_id = $pro_val[$i];
                                        //pre($_POST['material_name']);die;
                                $key = array_search($material_id, $material_ids); // $key = 2;
                                $materialjsonArrayObject = (array('material_name_id' => $_POST['material_name'][$key], 'description' => $_POST['description'][$key], 'uom' => $_POST['uom'][$key], 'quantity' => $_POST['quantity'][$key], 'price' => $_POST['price'][$key], 'sub_tax' => $_POST['sub_tax'][$key], 'sub_total' => $_POST['sub_total'][$key], 'gst' => $_POST['gst'][$key], 'total' => $_POST['total'][$key], 'remove_mat_id' => $_POST['remove_mat'][$key], 'remaning_qty' => $_POST['quantity'][$key], 'description_check' => $_POST['description_check'][$key]));
                                $materialarr[$i] = $materialjsonArrayObject;
                                $i++;
                            }
                            $material_item_array = json_encode($materialarr);
                        } else {
                            $material_item_array = '';
                        }
                        $data['supplier_name'] = $supp_key;
                     $data['material_name'] = $material_item_array;
                        $last_id = $this->purchase_model->getLastTableId('purchase_order');
                        $rId = $last_id + 1;
                        $poCode = 'PUR_' . rand(1, 1000000) . '_' . $rId;
                       $data['order_code'] =$poCode ;

                      $success = $this->purchase_model->insert_tbl_data('purchase_order', $data);

                    }
                    if ($data['material_type_id'] != '') updateUsedIdStatus('material_type', $data['material_type_id']);
                    if ($materialUpdateIds != "''") updateMultipleUsedIdStatus('material', $materialUpdateIds);
                    if ($data['supplier_name'] != "") updateUsedIdStatus('supplier', $data['supplier_name']);
                    if ($supplierUpdateIds != "") updateMultipleUsedIdStatus('supplier', $supplierUpdateIds);

                    if ($data['pi_id'] != "") updateUsedIdStatus('purchase_indent', $data['pi_id']);
                    $pi_id = $data['pi_id'];
                    if ($success) {
                        /* update cost price of material to fetch last cost price of material  */
                        if (!empty($arr)) {
                            /*foreach ($arr as $res) {
                                $this->purchase_model->update_single_value_data('material', array('cost_price' => $res['price']), array('id' => $res['material_name_id'], 'created_by_cid' => $this->companyGroupId));
                            }*/
                        }
                        logActivity('purchase order inserted', 'purchase_order', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'New purchase order created', 'message' => 'New purchase order is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $success, 'class' => 'add_purchase_tabs', 'data_id' => 'OrderView', 'icon' => 'fa-shopping-cart'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'New purchase order created', 'message' => 'New purchase order is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $success, 'class' => 'add_purchase_tabs', 'data_id' => 'OrderView', 'icon' => 'fa-shopping-cart'));
                        }
                        $this->session->set_flashdata('message', 'Purchase order inserted successfully');
                        //redirect(base_url().'purchase/purchase_order', 'refresh');

                    }
                }
                if ($_POST['pi_id'] != 0 && $_POST['pi_id'] != '') {
                    $doc_id = $_POST['pi_id'];
                    //echo '1';

                } else if ($_POST['pi_id'] == 0) {
                    $doc_id = $_POST['id'];
                    //echo '2';

                } else {
                    echo '3';
                    $doc_id = $success;
                }
                // pre($doc_id);
                // pre($_POST);
                // die();
                if ($doc_id) {
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
                            $proof_array[$i]['rel_id'] = $doc_id;
                            $proof_array[$i]['rel_type'] = 'PI_PO_MRN';
                            $proof_array[$i]['file_name'] = $newname;
                            $proof_array[$i]['file_type'] = $type;
                        }
                        //pre($proof_array);die('dfdfdfdfdf');
                        if (!empty($proof_array)) {
                            /* Insert file information into the database */
                            $proofId = $this->purchase_model->insert_attachment_data('attachments', $proof_array, 'PI_PO_MRN');
                        }
                    }
                }
                redirect(base_url() . 'purchase/purchase_order', 'refresh');
            }
        }
    }
    /*purchase order delete*/
    public function delete_order($id = '') {
        if (!$id) {
            redirect('purchase/purchase_order', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->purchase_model->delete_data('purchase_order', 'id', $id);
        if ($result) {
            logActivity('order Deleted', 'purchase_order', $id);
            $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 2));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Purchase order deleted', 'message' => 'Purchase order id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Purchase order deleted', 'message' => 'Purchase order id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
            }
            $this->session->set_flashdata('message', 'Order Deleted Successfully');
            $result = array('msg' => 'Order Deleted Successfully', 'status' => 'success', 'code' => 'C142', 'url' => base_url() . 'purchase/purchase_order');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }
    /********************************************************MATERIAL RECEIPT NOTE*******************************************************/
    /*main function mrn listing*/
    public function mrn() {
        /*$this->load->library('pagination');*/
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Purchase', base_url() . 'purchase/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'purchase/dashboard');
        $this->breadcrumb->add('GRN', base_url() . 'purchase/mrn');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Goods Receipt Note';
        $whereCompany = "(id ='" . $this->companyGroupId . "')";
        $this->data['company_unit_adress'] = $this->purchase_model->get_filter_details('company_detail', $whereCompany);
        /*$json_dtl ='{"material_type_id" : "'.$_GET['material_type'].'"}';
        $JSONSearch ="json_contains(`material_name`,'".$json_dtl."')";*/

        $json_dtl ='"material_type_id":"'.$_GET['material_type'].'"';
        $JSONSearch ="material_name LIKE '%{$json_dtl}%'";

        if ($_GET['dashboard'] == 'dashboard' && $_GET['start'] != '' && $_GET['end'] != '') {
            if (isset($_GET['material_type_id']) && $_GET['material_type_id'] != '') {
                $where = "mrn_detail.created_by_cid ='".$this->companyGroupId."' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) AND ( mrn_detail.material_type_id = " . $_GET['material_type_id'] . " )";
                $complete_where = "mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.created_by_cid = '" . $this->companyGroupId . "' ) AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1)  AND ( mrn_detail.material_type_id = " . $_GET['material_type_id'] . " )";
            } elseif ($_GET['label'] == 'Complete GRN' || $_GET['label'] == 'Incomplete GRN') {
                $where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                $complete_where = "mrn_detail.created_by_cid ='".$this->companyGroupId."'AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='".$_GET['end']."') AND (mrn_detail.created_by_cid = '" . $this->companyGroupId . "' ) AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
            }
        } else {

                if (!empty($_GET) && isset($_GET['start']) && isset($_GET['end']) && $_GET['supplier_name'] == '' && $_GET['material_type'] == '' && $_GET["ExportType"] == '' && $_GET["favourites"] == '' && $_GET['company_unit'] == '') {
                    $where = "mrn_detail.created_by_cid = '" . $this->companyGroupId ."' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.created_by_cid = '" . $this->companyGroupId . "' ) AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = "mrn_detail.created_by_cid = '".$this->companyGroupId ."' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.created_by_cid = '" . $this->companyGroupId . "' ) AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } else if (!empty($_GET) && $_GET['supplier_name'] != '' && $_GET['material_type'] != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
                    //echo "2";
                    $where = $JSONSearch ." AND ( mrn_detail.created_by_cid = " . $this->companyGroupId . "  AND  mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = $JSONSearch . " AND ( mrn_detail.created_by_cid = " . $this->companyGroupId . "  AND  mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } else if (!empty($_GET) && $_GET['supplier_name'] != '' && $_GET['material_type'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {

                    $where = $JSONSearch ." AND ( mrn_detail.created_by_cid = '".$this->companyGroupId ."'  AND  mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = $JSONSearch ." AND ( mrn_detail.created_by_cid = " . $this->companyGroupId . "  AND  mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } else if (!empty($_GET) && $_GET['supplier_name'] != '' && $_GET['material_type'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {
                    //echo "4";
                    $where = "mrn_detail.created_by_cid = '".$this->companyGroupId."' AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = "mrn_detail.created_by_cid = '".$this->companyGroupId."' AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } else if (!empty($_GET) && $_GET['supplier_name'] != '' && $_GET['material_type'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
                    //echo "4";
                    $where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "')  AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = "mrn_detail.created_by_cid = '" . $this->companyGroupId ."' AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "')  AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } else if (!empty($_GET) && $_GET['material_type'] != '' && $_GET['supplier_name'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {

                    $where = $JSONSearch. " AND mrn_detail.created_by_cid = '".$this->companyGroupId ."' AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = $JSONSearch. " AND mrn_detail.created_by_cid = '".$this->companyGroupId."' AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } else if (!empty($_GET) && $_GET['material_type'] != '' && $_GET['supplier_name'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
                    $where = $JSONSearch ." AND mrn_detail.created_by_cid = '".$this->companyGroupId."' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = $JSONSearch ." AND mrn_detail.created_by_cid ='".$this->companyGroupId."' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } else if (!empty($_GET) && $_GET['material_type'] == '' && $_GET['supplier_name'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                    $where = "mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "')  ";
                    $complete_where = "mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "')  ";
                } else if (!empty($_GET) && $_GET['material_type'] != '' && $_GET['supplier_name'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                    $where = $JSONSearch ." AND mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "')  ";
                    $complete_where = $JSONSearch ." AND mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "')  ";
                } else if (!empty($_GET) && $_GET['material_type'] != '' && $_GET['supplier_name'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                    $where = $JSONSearch ." AND mrn_detail.created_by_cid = " . $this->companyGroupId . "  AND  (company_unit ='" . $_GET['company_unit'] . "' ) AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "')  ";
                    $complete_where = $JSONSearch ." AND mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "' ) AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "')  ";
                } else {
                    #$where = array('mrn_detail.created_by_cid' => $_SESSION['loggedInUser']->c_id, 'mrn_detail.ifbalance' => 1 , 'mrn_detail.pay_or_not' => 0);
                    $where = "mrn_detail.created_by_cid = '".$this->companyGroupId."' AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = array('mrn_detail.created_by_cid' => $this->companyGroupId, 'mrn_detail.ifbalance' => 0, 'mrn_detail.pay_or_not' => 1);
                }
                /*******************export filter **********************************************/
                if(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] == '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' &&  $_GET['search'] == '') {
                    $where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";

                    $complete_where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                }else if(isset($_GET["ExportType"])=='' && $_GET['favourites']!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] == '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' &&  $_GET['search'] == '') {
                  $where = "mrn_detail.created_by_cid = '".$this->companyGroupId."' AND mrn_detail.favourite_sts = 1";
                $complete_where = array('mrn_detail.created_by_cid' => $this->companyGroupId, 'mrn_detail.ifbalance' => 0, 'mrn_detail.pay_or_not' => 1, 'mrn_detail.favourite_sts' => 1);
                }

                else if(isset($_GET["ExportType"])!='' && $_GET['favourites']!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] == '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' &&  $_GET['search'] == '') {
                   $where = "mrn_detail.created_by_cid = '".$this->companyGroupId."' AND mrn_detail.favourite_sts = 1";
                $complete_where = array('mrn_detail.created_by_cid' => $this->companyGroupId, 'mrn_detail.ifbalance' => 0, 'mrn_detail.pay_or_not' => 1, 'mrn_detail.favourite_sts' => 1);
                }
                 elseif(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] != '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' &&  $_GET['search'] == '') {
                    $where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } elseif(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] == '' && $_GET['material_type'] != '' && $_GET['company_unit'] == '' &&  $_GET['search'] == '') {
                    $where = $JSONSearch ." AND mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = $JSONSearch ." AND mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } elseif(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] == '' && $_GET['material_type'] == '' && $_GET['company_unit']!= '' &&  $_GET['search'] == ''){
                $where = "mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "')  ";
                    $complete_where = "mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "')  ";
        }elseif(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] != '' && $_GET['material_type'] != '' && $_GET['company_unit'] == '' &&  $_GET['search'] == '') {
                    $where = $JSONSearch ." AND ( mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND  mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = $JSONSearch ." AND ( mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND  mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } elseif(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' &&  $_GET['search'] == '') {

                    if($_GET['tab']=='complete'){
                    $complete_where = "mrn_detail.created_by_cid = '".$this->companyGroupId ."' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.created_by_cid = '" . $this->companyGroupId . "' ) AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                    }else{
                         $where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.created_by_cid = '" . $this->companyGroupId . "' ) AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                         }

                }
             elseif(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] == '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' &&  $_GET['search'] != '') {
            $materialName=getNameById('material',$_GET['search'],'material_name');
            $material_type_tt = getNameById('material_type',$_GET['search'],'name');
                if($materialName->id == '' && $material_type_tt->id ==''){
                    $wheresearch = "(mrn_detail.id like '%" . $_GET['search']. "%' OR mrn_detail.bill_no like '%" . $_GET['search'] . "%')";
                }elseif($materialName->id != '' && $material_type_tt->id ==''){
                    $json_dtl ='"material_name_id" : "'.$_GET['material_type'].'"';
                    $wheresearch = "mrn_detail.material_name!='' AND material_name LIKE '%{$json_dtl}%')" ;
                }elseif($material_type_tt->id !=''){
                    //$json_dtl ='{"material_name_id" : "'.$_GET['material_type'].'"}';
                    $json_dtl ='"material_name_id" : "'.$_GET['material_type'].'"';
                    //$wheresearch = "mrn_detail.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                    $wheresearch = "mrn_detail.material_name!='' AND material_name LIKE '%{$json_dtl}%')" ;
                }

                     $complete_where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) AND ".$wheresearch;
             $where = "mrn_detail.created_by_cid ='".$this->companyGroupId."' AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) AND ".$wheresearch;

            }
              elseif(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] == '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' &&  $_GET['search'] != '') {
             $where = "mrn_detail.created_by_cid ='".$this->companyGroupId."' AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0)";
             $complete_where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1)";
                }

        }
        //Search
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
           $search_string = $_POST['search'];
           $materialName=getNameById('material',$search_string,'material_name');
            $material_type_tt = getNameById('material_type',$search_string,'name');
                if($materialName->id == '' && $material_type_tt->id ==''){
                    $where2 = "(mrn_detail.id like '%" . $search_string . "%' OR mrn_detail.bill_no like '%" . $search_string . "%')";
                }elseif($materialName->id != '' && $material_type_tt->id ==''){
                    $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                    $where2 = "mrn_detail.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                }elseif($material_type_tt->id !=''){
                    $json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                    $where2 = "mrn_detail.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                }
                redirect("purchase/mrn/?search=$search_string");
        }else if($_GET['search']!=''){
            $materialName=getNameById('material',$_GET['search'],'material_name');
            $material_type_tt = getNameById('material_type',$_GET['search'],'name');
                if($materialName->id == '' && $material_type_tt->id ==''){
                    $where2 = "(mrn_detail.id like '%" . $_GET['search']. "%' OR mrn_detail.bill_no like '%" . $_GET['search'] . "%')";
                }elseif($materialName->id != '' && $material_type_tt->id ==''){
                    $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                    $where2 = "mrn_detail.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                }elseif($material_type_tt->id !=''){
                    $json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                    $where2 = "mrn_detail.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                }
            }

        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = "desc";
        }

        if( !empty($_GET['purchase_type']) ){
            if( $_GET['purchase_type'] == 2 ){
                $_GET['purchase_type'] = 0;
            }
            if( $where ){
              $where  = str_replace("AND  (mrn_detail.created_date >='' AND  mrn_detail.created_date <='')", "",$where);
              $where .= " AND mrn_detail.purchase_type = {$_GET['purchase_type']}";
            }
            if( $whereComplete ){
                $complete_where  = str_replace("AND  (mrn_detail.created_date >='' AND  mrn_detail.created_date <='')", "",$complete_where);
                $complete_where .= " AND mrn_detail.purchase_type = {$_GET['purchase_type']}";
            }
        }

        if( !empty( $_GET['report_type'] ) ){
            $status = ($_GET['report_type'] == 'pass')?0:1;
            $clause = '"defected":'.$status;
            $defWhere .= " AND mrn_detail.material_name LIKE '%".$clause."%' ";

            if( $where ){
              $where  = str_replace("AND  (mrn_detail.created_date >='' AND  mrn_detail.created_date <='')", "",$where);
              $where .= $defWhere;
            }
            if( $whereComplete ){
                $complete_where  = str_replace("AND  (mrn_detail.created_date >='' AND  mrn_detail.created_date <='')", "",$complete_where);
                $complete_where .= $defWhere;
            }
        }

        if($_GET['tab']=='complete'){
            $rows=$this->purchase_model->tot_rows('mrn_detail', $complete_where, $where2);
        }elseif($_GET['tab']=='inprocess'){
            $rows=$this->purchase_model->tot_rows('mrn_detail', $where, $where2);
        }else{
            $rows=$this->purchase_model->tot_rows('mrn_detail', $where, $where2);
        }


        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "purchase/mrn";
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
        if(!empty($_GET['ExportType'])){
            $export_data = 1;
        }else{
            $export_data = 0;
        }

        if($_GET['tab']=='complete'){
            $this->data['mrn_complete'] = $this->purchase_model->get_data_listing('mrn_detail', $complete_where, $config["per_page"], $page, $where2, $order,$export_data);
        }elseif($_GET['tab']=='inprocess'){
             $this->data['mrn'] = $this->purchase_model->get_data_listing('mrn_detail', $where, $config["per_page"], $page, $where2, $order,$export_data);
        }else{
        $this->data['mrn_complete'] = $this->purchase_model->get_data_listing('mrn_detail', $complete_where, $config["per_page"], $page, $where2, $order,$export_data);
         $this->data['mrn'] = $this->purchase_model->get_data_listing('mrn_detail', $where, $config["per_page"], $page, $where2, $order,$export_data);
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

         $this->_render_template('mrn/index', $this->data);
    }
    /*function to add/edit*/
    public function convert_to_mrn_through_pi() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $get_id_for_docss = array('purchase_order.id' => $_POST['id'], 'purchase_order.save_status' => 1);
        $get_docss_data = $this->purchase_model->get_data('purchase_order', $get_id_for_docss);
        $docsId = $id;
        if ($get_docss_data[0]['pi_id'] != 0) {
            $docsId = $get_docss_data[0]['pi_id'];
        }
        $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $docsId); //For Document Attachment fetch
        $this->data['mrnOrder'] = $this->purchase_model->get_data_byId('purchase_indent', 'id', $id);
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['mrn'] = $this->purchase_model->get_data_byId('mrn_detail', 'id', $id);
        $this->load->view('mrn/convert_to_mrn_through_pi', $this->data);
    }
    public function convert_to_mrn() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $get_id_for_docss = array('purchase_order.id' => $_POST['id'], 'purchase_order.save_status' => 1);
        $docsId = $id;
        $get_docss_data = $this->purchase_model->get_data('purchase_order', $get_id_for_docss);
        if ($get_docss_data[0]['pi_id'] != 0) {
            $docsId = $get_docss_data[0]['pi_id'];
        }
        $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $docsId);
        $this->data['mrnOrder'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        //$this->data['mrn'] = $this->purchase_model->get_data_byId('mrn_detail', 'id', $id);
        if( $_POST['gateId'] != ""){
            $this->data['gateEnteryData'] = $this->purchase_model->getGateEntryIndexData($_POST['gateId'],'pge.id');

        }
        $this->load->view('mrn/convert_to_mrn', $this->data);
    }
    /*function to add/edit*/
    public function mrn_edit() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['mrn'] = $this->purchase_model->get_data_byId('mrn_detail', 'id', $id);
        $this->data['mrnOrder'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);
        if( $this->data['mrnOrder']->pi_id != "" ){
            $docId = $this->data['mrnOrder']->pi_id;
        }elseif($this->data['mrn']->pi_id){
            $docId = $this->data['mrn']->pi_id;
        }else{
            $docId = $this->data['mrn']->id;
        }
        $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $docId);
        if( $_POST['gateId'] != ""){
            $this->data['gateEnteryData'] = $this->purchase_model->getGateEntryIndexData($_POST['gateId'],'pge.id');
        }
        $this->load->view('mrn/edit', $this->data);
        // $this->load->view('mrn/test_mrn', $this->data);

    }
    /*function to view mrn*/
    public function mrn_view() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_view');
        }
        $this->data['mrnView'] = $this->purchase_model->get_data_byId('mrn_detail', 'id', $id);
        $this->data['mrnOrder'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);
        if( $this->data['mrnOrder']->pi_id != "" ){
            $docId = $this->data['mrnOrder']->pi_id;
        }elseif($this->data['mrn']->pi_id){
            $docId = $this->data['mrnView']->pi_id;
        }else{
            $docId = $this->data['mrnView']->id;
        }

        $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $docId);
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $data_get_for_docss = array('mrn_detail.id' => $_POST['id'], 'mrn_detail.save_status' => 1);
        $docs_data = $this->purchase_model->get_data('mrn_detail', $data_get_for_docss);

        if ($docs_data[0]['pi_id'] != 0) {
            $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $docs_data[0]['pi_id']); //For Document Attachment fetch

        }
        if ($docs_data[0]['po_id'] != 0) {
            $get_purchase_order_Data = array('purchase_order.id' => $docs_data[0]['po_id'], 'purchase_order.save_status' => 1);
            $PO_data = $this->purchase_model->get_data('purchase_order', $get_purchase_order_Data);
            $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $this->data['mrnView']->id); //For Document
            //Attachment fetch
        }
        //Code For Change Status*/
        $wherePo = array('mrn_detail.id' => $id, 'mrn_detail.save_status' => 1);
        $this->data['po'] = $this->purchase_model->get_data('mrn_detail', $wherePo);
        $whereMrn = array('mrn_detail.id' => $id, 'mrn_detail.save_status' => 1);
        //$whereMrn = array('mrn_detail.po_id' => $id, 'mrn_detail.save_status'=> 1);
        $this->data['mrn'] = $this->purchase_model->get_data('mrn_detail', $whereMrn);

        $this->load->view('mrn/view', $this->data);
    }
    /*save MRN*/
    public function mrn_view_mat() {
          $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_view');
        }
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['mrnView'] = $this->purchase_model->get_data_byId('mrn_detail', 'id', $id);
        $data_get_for_docss = array('mrn_detail.id' => $_POST['id'], 'mrn_detail.save_status' => 1);
        $docs_data = $this->purchase_model->get_data('mrn_detail', $data_get_for_docss);
        if ($docs_data[0]['pi_id'] != 0) {
            $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $docs_data[0]['pi_id']); //For Document Attachment fetch

        }
        if ($docs_data[0]['po_id'] != 0) {
            $get_purchase_order_Data = array('purchase_order.id' => $docs_data[0]['po_id'], 'purchase_order.save_status' => 1);
            $PO_data = $this->purchase_model->get_data('purchase_order', $get_purchase_order_Data);
            $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $PO_data[0]['pi_id']); //For Document Attachment fetch

        }
        //Code For Change Status*/
        $wherePo = array('mrn_detail.id' => $id, 'mrn_detail.save_status' => 1);
        $this->data['po'] = $this->purchase_model->get_data('mrn_detail', $wherePo);
        $whereMrn = array('mrn_detail.id' => $id, 'mrn_detail.save_status' => 1);
        //$whereMrn = array('mrn_detail.po_id' => $id, 'mrn_detail.save_status'=> 1);
        $this->data['mrn'] = $this->purchase_model->get_data('mrn_detail', $whereMrn);
        //Code For Change Status*/
        $this->load->view('mrn/mat_view', $this->data);
    }
    public function saveMRN() {
		
		
		 //pre($_POST);die(); 
		

        $matLength = count($_POST['material_name']);
        $mat_array = ''; $mat_array_for_purchase_bill = '';
        if ($matLength > 0) {
            $arr = [];
            $i = $j = $k =0;
            while ($i < $matLength) {
				
				$this->sellingPriceHistory($_POST['material_name'][$i], $_POST['price'][$i]);
            $jsonArrayObject_for_quality_check = (array('material_name_id' => $_POST['material_name'][$k]));
            $arr1[$k] = $jsonArrayObject_for_quality_check;
                $k++;

			$debitNoteAmount =  ['debitNoteAmount' => ( ( $_POST['price'][$i] * $_POST['invoice_quantity'][$i] ) - ( ($_POST['received_quantity'][$i] - $_POST['defectedQty'][$i]  ) * $_POST['price'][$i] ) ) ];
			
			$jsonArrayObject = (array('material_type_id' => $_POST['material_type_id'][$i],'material_name_id' => $_POST['material_name'][$i], 'description' => $_POST['description'][$i], 'uom' => $_POST['uom'][$i], 'quantity' => $_POST['quantity'][$i], 'price' => $_POST['price'][$i], 'sub_tax' => $_POST['sub_tax'][$i], 'sub_total' => $_POST['sub_total'][$i], 'gst' => $_POST['gst'][$i], 'total' => $_POST['total'][$i], 'defected' => ($_POST['defected'][$i] == 1 ? 1 : 0), 'defected_reason' => $_POST['defected_reason'][$i], 'defectedQty' => $_POST['defectedQty'][$i], 'received_quantity' => $_POST['received_quantity'][$i], 'remove_mat_id' => $_POST['remove_mat'][$i] , 'lotno' => $_POST['lotno'][$i],'invoice_quantity' => $_POST['invoice_quantity'][$i],'aliasname' => $_POST['aliasname'][$i] ) ) + $debitNoteAmount;
			
                $arr[$i] = $jsonArrayObject;
                $i++;
                $jsonArrayObject_for_purchase_bill = (array('descr_of_bills' => 'From MRN', 'product_details' => $_POST['material_name'][$j], 'UOM' => $_POST['uom'][$j], 'qty' => $_POST['received_quantity'][$j], 'rate' => $_POST['price'][$j], 'tax' => $_POST['gst'][$j], 'amountwittax' => $_POST['total'][$j], 'subtotal' => $_POST['sub_total'][$j], 'received_quantity' => $_POST['received_quantity'][$j], 'remove_mat_id' => $_POST['remove_mat'][$i] )) + $debitNoteAmount ;
                $arra[$j] = $jsonArrayObject_for_purchase_bill;
                $j++;
            }
            $mat_array = json_encode($arr);
            $mat_array_for_purchase_bill = json_encode($arra);
            $quality_chk=json_encode($arr1);

        }
        /*Code For Multiple MRN*/

        $mrn_data2 = json_decode($mat_array, TRUE);
		// pre($mrn_data2);
        $this->addSupplierMaterialPriceByGRN($mrn_data2,$_POST['supplier_name']);
        if (isset($_POST['convert_mrn_thgu_pi'])) { //When We convert PI to MRN
            $purchase_indent_id = $_POST['pi_id'];
            $where = array('id' => $purchase_indent_id);
            $pI_data = $this->purchase_model->get_data('purchase_indent', $where);
            $matrial_jsonString = $pI_data[0]['material_name'];
            $pi_data1 = json_decode($matrial_jsonString, TRUE);
            $updated_data_for_pi = array();
            $array_for_pi = array();
            $count1 = 0;
            foreach ($mrn_data2 as $key => $mrn2_item) {
				
                foreach ($pi_data1 as $key => $pi_item) {
                $pidebitNoteAmount = ['debitNoteAmount' => ( ( $pi_item['expected_amount'] * $mrn2_item['invoice_quantity'] ) - ($mrn2_item['received_quantity'] - $mrn2_item['defectedQty']  ) * $pi_item['expected_amount'] ) ];
                    if ($mrn2_item['material_name_id'] == $pi_item['material_name_id'] && $pi_item['remaning_qty'] != '0' && ($mrn2_item['description'] == $pi_item['description'])) {
                        $defectedPiece = 0;

                        if($mrn2_item['defectedQty']){ $defectedPiece = $mrn2_item['defectedQty']; }
                        $remaing_mat_qty = ($pi_item['remaning_qty'] - $mrn2_item['received_quantity']) + $defectedPiece;

                        $array_for_pi[] = array('material_type_id' => $pi_item['material_type_id'],'material_name_id' => $pi_item['material_name_id'], 'description' => $pi_item['description'], 'quantity' => $pi_item['quantity'], 'uom' => $pi_item['uom'], 'expected_amount' => $pi_item['expected_amount'], 'purpose' => $pi_item['purpose'], 'sub_total' => $pi_item['sub_total'], 'remaning_qty' => $remaing_mat_qty,'invoice_quantity' => $mrn2_item['invoice_quantity'],'received_quantity' => $mrn2_item['received_quantity'],'defectedQty' => $mrn2_item['defectedQty'],'aliasname' => $mrn2_item['aliasname'])
                              + $pidebitNoteAmount;
                        $count1++;
                    } elseif ($mrn2_item['material_name_id'] == '' && $mrn2_item['remove_mat_id'] == $pi_item['material_name_id']) {
                        //echo '2';
                        $array_for_pi[] = array('material_type_id' => $pi_item['material_type_id'],'material_name_id' => $pi_item['material_name_id'], 'description' => $pi_item['description'], 'quantity' => $pi_item['quantity'], 'uom' => $pi_item['uom'], 'expected_amount' => $pi_item['expected_amount'], 'purpose' => $pi_item['purpose'], 'sub_total' => $pi_item['sub_total'], 'remaning_qty' => $pi_item['remaning_qty'],'invoice_quantity' => $mrn2_item['invoice_quantity'],'received_quantity' => $mrn2_item['received_quantity'],'defectedQty' => $mrn2_item['defectedQty'],'aliasname' => $mrn2_item['aliasname'] ) + $pidebitNoteAmount ;
                        $count1++;
                    } elseif ($pi_item['remaning_qty'] == '0') {
                        //echo '3';
                        $array_for_pi[] = array('material_type_id' => $pi_item['material_type_id'],'material_name_id' => $pi_item['material_name_id'], 'description' => $pi_item['description'], 'quantity' => $pi_item['quantity'], 'uom' => $pi_item['uom'], 'expected_amount' => $pi_item['expected_amount'], 'purpose' => $pi_item['purpose'], 'sub_total' => $pi_item['sub_total'], 'remaning_qty' => $pi_item['remaning_qty'],'invoice_quantity' => $mrn2_item['invoice_quantity'],'received_quantity' => $mrn2_item['received_quantity'],'defectedQty' => $mrn2_item['defectedQty'],'aliasname' => $mrn2_item['aliasname'] ) + $pidebitNoteAmount ;
                        $count1++;
                    }
                }
            }

            $updated_data_for_pi = $array_for_pi;

            $afterdata_sort = array_unique($updated_data_for_pi, SORT_REGULAR);
            $remaning_data = json_encode($afterdata_sort);


            $this->purchase_model->update_pI_material_data('purchase_indent', $purchase_indent_id, $remaning_data); //When we create MRN through PI
            /* Code used for when Purchase Indent Complete*/
            $pi_data_to_check_rem_qty = json_decode($matrial_jsonString, TRUE);
			// pre($pi_data_to_check_rem_qty);die();
            $rem_qty = 0;
            $rm_QTY = array_count_values(array_column($afterdata_sort, 'remaning_qty')) [$rem_qty];
            $count22 = 0;
            foreach ($pi_data_to_check_rem_qty as $type) {
                $count22+= count($type['remaning_qty']);
            }

            if( $_POST['purchaseComplete'] ){
                $this->purchase_model->update_po_single_data('purchase_indent', $_POST['pi_id']);
                $this->purchase_model->update_pI_single_data('purchase_indent', $_POST['pi_id']);
            }

            if ($rm_QTY == $count22) { //this Count Check material count is equal to material  qty
                $this->purchase_model->update_po_single_data('purchase_indent', $_POST['pi_id']); //MRN_or_not
                $this->purchase_model->update_pI_single_data('purchase_indent', $_POST['pi_id']);
            }

            /* debit Note Auto entry */

            if($this->checkWrongInvoiceEntry($updated_data_for_pi)){
                 $this->autoDebitNote($updated_data_for_pi,$_POST);
            }

            /* debit Note Auto entry end */


        } elseif (isset($_POST['convert_po_to_mrn'])) { //When We convert PO to MRN
					
            $purchase_order_id = $_POST['po_id'];
            $where = array('id' => $purchase_order_id);
            $PO_data = $this->purchase_model->get_data('purchase_order', $where);
            $matrial_jsonString = $PO_data[0]['material_name'];
            $po_data1 = json_decode($matrial_jsonString, TRUE);
            $updated_data_for_po = array();
            $array_for_po = array();
            $countPo1 = 0;
            foreach ($mrn_data2 as $key => $mrn2_item) {
				

                foreach ($po_data1 as $key => $po_item) {
                    $poMrn = ['debitNoteAmount' => ( ($pi_item['expected_amount'] * $mrn2_item['invoice_quantity'] ) - ($mrn2_item['received_quantity'] * $pi_item['expected_amount'] ) ) ];
                    if ($mrn2_item['material_name_id'] == $po_item['material_name_id'] && $po_item['remaning_qty'] != '0' && ($mrn2_item['description'] == $po_item['description'])) {
                        $defectedPiece = 0;
                        if($mrn2_item['defectedQty']){ $defectedPiece = $mrn2_item['defectedQty']; }
                        // echo '1';
						// pre($po_item['remaning_qty']);
						
                        $remaing_mat_qty = ($po_item['remaning_qty'] - $mrn2_item['received_quantity']) + $defectedPiece;
                        $array_for_po[] = array('material_type_id' => $po_item['material_type_id'],'material_name_id' => $po_item['material_name_id'], 'description' => $po_item['description'], 'uom' => $po_item['uom'], 'quantity' => $po_item['quantity'], 'price' => $po_item['price'], 'sub_tax' => $po_item['sub_tax'], 'sub_total' => $po_item['sub_total'], 'gst' => $po_item['gst'], 'total' => $po_item['total'], 'remaning_qty' => $remaing_mat_qty,'invoice_quantity' => $mrn2_item['invoice_quantity'],'aliasname' => $mrn2_item['aliasname'],'received_quantity' => $mrn2_item['received_quantity'],'debitNoteAmount' => ( ($pi_item['expected_amount'] * $mrn2_item['invoice_quantity'] ) - ($mrn2_item['received_quantity'] * $pi_item['expected_amount'] ) ) );
                        $countPo1++;
                    } elseif ($mrn2_item['material_name_id'] == '' && $mrn2_item['remove_mat_id'] == $po_item['material_name_id']) {
                         // echo '2';
                        $array_for_po[] = array('material_type_id' => $po_item['material_type_id'],'material_name_id' => $po_item['material_name_id'], 'description' => $po_item['description'], 'uom' => $po_item['uom'], 'quantity' => $po_item['quantity'], 'price' => $po_item['price'], 'sub_tax' => $po_item['sub_tax'], 'sub_total' => $po_item['sub_total'], 'gst' => $po_item['gst'], 'total' => $po_item['total'], 'remaning_qty' => $po_item['remaning_qty'], 'invoice_quantity' => $mrn2_item['invoice_quantity'],'aliasname' => $mrn2_item['aliasname'],'received_quantity' => $mrn2_item['received_quantity'], 'debitNoteAmount' => ( ($pi_item['expected_amount'] * $mrn2_item['invoice_quantity'] ) - ($mrn2_item['received_quantity'] * $pi_item['expected_amount'] ) ) );
                        $countPo1++;
                    } elseif ($po_item['remaning_qty'] == '0') {
						 //echo '3';
                        $array_for_po[] = array('material_type_id' => $po_item['material_type_id'],'material_name_id' => $po_item['material_name_id'], 'description' => $po_item['description'], 'uom' => $po_item['uom'], 'quantity' => $po_item['quantity'], 'price' => $po_item['price'], 'sub_tax' => $po_item['sub_tax'], 'sub_total' => $po_item['sub_total'], 'gst' => $po_item['gst'], 'total' => $po_item['total'], 'remaning_qty' => $po_item['remaning_qty'],'aliasname' => $mrn2_item['aliasname'], 'invoice_quantity' => $mrn2_item['invoice_quantity']??'','received_quantity' => $mrn2_item['received_quantity']??'','debitNoteAmount' => ( ($pi_item['expected_amount'] * $mrn2_item['invoice_quantity'] ) - ($mrn2_item['received_quantity'] * $pi_item['expected_amount'] ) ) );
                        $countPo1++;
                    }
                }
            }
			
			
			
            $updated_data_for_po = $array_for_po;

            /* add supplier material price */


            $afterdata_sort_po = array_unique($updated_data_for_po, SORT_REGULAR);
			
            $remaning_data_po = json_encode($afterdata_sort_po);
            $this->purchase_model->update_pI_material_data('purchase_order', $purchase_order_id, $remaning_data_po); //When we create MRN through PI
            /* Code used for when Purchase Indent Complete*/
            $po_data_to_check_rem_qty = json_decode($matrial_jsonString, TRUE);
            $rem_qty1 = 0;
			
            $rm_QTY1 = array_count_values(array_column($afterdata_sort_po, 'remaning_qty')) [$rem_qty1];
			
			
            $count221 = 0;
            foreach ($po_data_to_check_rem_qty as $type) {
                $count221+= count($type['remaning_qty']);
            }
			
		

            if( isset($_POST['purchaseComplete']) && $_POST['purchaseComplete'] == 1 ){
			//die('first if');
                $this->purchase_model->update_po_single_data('purchase_order', $purchase_order_id);
            }
            if ($rm_QTY1 == $count221) { //this Count Check material count is equal to material  qty
			//die('Second if');
                $this->purchase_model->update_po_single_data('purchase_order', $purchase_order_id);//MRN_or_not
                $piId = getSingleAndWhere('pi_id','purchase_order',['id' => $purchase_order_id ]);
                $this->purchase_model->update_po_single_data('purchase_indent', $piId); //MRN_or_not

            }
        }
		
        /*Code For Multiple MRN*/
        if ($this->input->post()) {
            $required_fields = array('supplier_name');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {

                $data = $this->input->post();
                $materialUpdateIds = implode("','", $data['material_name']);
                $materialUpdateIds = "'" . $materialUpdateIds . "'";
                $materialtypeUpdateIds = implode("','", $data['material_type_id']);
                $materialtypeUpdateIds = "'" . $materialtypeUpdateIds . "'";
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['material_name'] = $mat_array;
                #$data['charges_added'] = $json_charg_lead_total_array;
                $supplier_Data = $this->purchase_model->get_data_byId('supplier', 'id', $_POST['supplier_name']);
                $datae = json_decode($supplier_Data->contact_detail);
                if ($supplier_Data->state != $_POST['dilivery_add_state']) {
                    $IGST = $_POST['total_tax'];
                } else {
                    $divide_cgst_sgst = $_POST['total_tax'] / 2;
                    $CGST = $divide_cgst_sgst;
                    $SGST = $divide_cgst_sgst;
                }

                $get_ledger_iddd = $this->purchase_model->get_ledger_Data('ledger', 'supp_id', $_POST['supplier_name']); //For Get Ledger Table ID
                //$id = $data['id'];
                //For Add Update In Purchase_bill Table
                $id = "";
                if( isset($_POST['id']) ){
                    if( $_POST['id'] ){
                        $id = $_POST['id'];
                    }
                }
                $purchase_bill_id = $_POST['id'];
                $data_for_purchase_bill['descr_of_bills'] = $mat_array_for_purchase_bill;
                $data_for_purchase_bill['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data_for_purchase_bill['created_by_cid'] = $this->companyGroupId;
                $data_for_purchase_bill['supplier_name'] = $get_ledger_iddd->id;
                $data_for_purchase_bill['date'] = $_POST['date'];
                $data_for_purchase_bill['gstin'] = $supplier_Data->gstin;
                $data_for_purchase_bill['p_email'] = $datae[0]->email??'';
                $data_for_purchase_bill['total_amount'] = $_POST['grand_total'];
                $data_for_purchase_bill['grand_total'] = $_POST['grand_total'];
                $data_for_purchase_bill['totaltax_total'] = $_POST['total_tax'];
                $data_for_purchase_bill['charges_added'] = $json_charg_lead_total_array;
                $data_for_purchase_bill['auto_entry'] = '1';
                $data_for_purchase_bill['is_quality_check'] = '1';
                $data_for_purchase_bill['IGST'] = $IGST;
                $data_for_purchase_bill['CGST'] = $CGST;
                $data_for_purchase_bill['SGST'] = $SGST;
                $total = $_POST['grand_total'] - $_POST['total_tax'];
                $subtotal_tax_withtax = array(array('total' => $total, 'totaltax' => $_POST['total_tax'], 'invoice_total_with_tax' => $_POST['grand_total']));
                $totoaal_tax_data = json_encode($subtotal_tax_withtax);
                $data_for_purchase_bill['invoice_total_with_tax'] = $totoaal_tax_data;
                if ($_POST['pi_id'] != '') {
                    $data_for_purchase_bill['throu_pi_or_not'] = $data['pi_id'];
                }
                //For Add Update In Purchase_bill Table
                //Calculation for Debit note
                $qty = $_POST['quantity'];
                $reciv_qty = $_POST['received_quantity'];
                function identical_values($qty, $reciv_qty) {
                    sort($qty);
                    sort($reciv_qty);
                    return $qty == $reciv_qty;
                }
                $result = identical_values($qty, $reciv_qty);
                if ($_POST['received_quantity'] == '') {
                    $detail_prodct = json_decode($mat_array, true);
                    $remaing_MRN_qty = 0;
                    foreach ($detail_prodct as $get_amount) {
                        $price_without_tax = $get_amount['received_quantity'] * $get_amount['price'] . '<br/>';
                        $tax = $price_without_tax * $get_amount['gst'] / 100;
                        $recived_matrial_amount_with_tax+= $price_without_tax + $tax;
                    }
                    $jsonArrayObject = array(array('credit_debit_party_dtl' => $_POST['supplier_name'], 'credit_1' => '', 'debit_1' => "$recived_matrial_amount_with_tax", 'cr_dr' => 'debit'));
                    $voucher_details = JSON_encode($jsonArrayObject);
                    $add_debit_note = array('voucher_name' => 6, 'type' => '1', 'credit_debit_party_dtl' => $voucher_details,
                    // 'narration' => $_POST['defected_reason'],
                    'total' => $recived_matrial_amount_with_tax, 'save_status' => $_POST['save_status'], 'auto_entry' => '1', 'created_by' => $_SESSION['loggedInUser']->u_id, 'created_by_cid' => $this->companyGroupId,);
                    $insert_ID = $this->purchase_model->insert_tbl_data('voucher', $add_debit_note);
                    $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 7));
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                pushNotification(array('subject' => 'Debit Note created', 'message' => 'Debit Note is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $insert_ID, 'class' => 'add_voucher_details_tabs', 'data_id' => 'voucher_dtl_add', 'icon' => 'fa-shopping-cart'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        pushNotification(array('subject' => 'New GRN created', 'message' => 'Debit Note is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $insert_ID, 'class' => 'add_voucher_details_tabs', 'data_id' => 'voucher_dtl_add', 'icon' => 'fa-shopping-cart'));
                    }
                }
                //Calculation for Debit note
                if ($_POST['pi_id'] == '') {
                    // $data['po_id']=$data['po_id'];
                    // $this->purchase_model->update_po_single_data('purchase_order',$data['po_id']);

                } else {
                    /*  change PO status in PI start   */
                    $pI_data = $this->purchase_model->get_data('purchase_indent', array('id' => $data['pi_id']));
                    if (!empty($pI_data) && $pI_data[0]['status'] == '') {
                        $piArray = array();
                        $piArray['PO'] = array('name' => 'PO', 'po_or_verbal' => 'verbal');
                        $piArray['MRN'] = array('name' => 'MRN', 'mrn_or_without_form' => 'mrn_code');
                        $piJsonArray = JSON_encode($piArray);
                        $statusArray = array('status' => $piJsonArray);
                        $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $pI_data[0]['id']);
                    } else {
                        $piArray = $this->objectToArray(json_decode($pI_data[0]['status']));
                        $piArray['MRN'] = array('name' => 'MRN', 'mrn_or_without_form' => 'mrn_code');
                        $piJsonArray = JSON_encode($piArray);
                        $statusArray = array('status' => $piJsonArray);
                        $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $pI_data[0]['id']);
                    }
                    /*  change PO status in PI  end*/
                }
                // if($_POST['purchase_indent_id'] !='' ||  $_POST['pi_id'] !=''){
                // $data['po_id']=$data['po_id'];
                // $this->purchase_model->update_pI_single_data('purchase_indent',$_POST['pi_id']);
                // $this->purchase_model->update_po_single_data('purchase_indent',$_POST['pi_id']);
                // }
                $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 7));
                if ($id && $id != '') {
                    /* MRN Update Inventory Flow */

                        if (!empty($data) && $data['material_name'] != '' && $_POST['save_status'] != 0) {

                            $inventoryFlowData = json_decode($data['material_name']);
                            $OldAddress = getMaterialUpdateAddress('delivery_address','mrn_detail',['id' => $id]);
                            $inventoryFlowData = json_decode($data['material_name']);
                            $existData = ['column' => 'material_name','table' => 'mrn_detail','where' => ['id' => $id],'through' => 'GRN Update','goType' => 'in' ];
                            $newAddress = false;
                            if( $OldAddress != $_POST['delivery_address'] ){
                                $newAddress = $_POST['delivery_address'];
                            }else{
                                $OldAddress = $_POST['delivery_address'];
                            }

                            $this->addMoreMeterialInOutInvantry($inventoryFlowData,$_POST['delivery_address'],$id,$existData);

                            /* unique  array */
                            $getMaterial = getMaterialUpdateInvntry($existData['column'],$existData['table'],$existData['where']);
                            $inventoryFlowData = multiArrayUnique($getMaterial,$inventoryFlowData);

                            $this->updateInvantryMaterialInOut($inventoryFlowData,$OldAddress,$id,$existData,$newAddress);
                        }


                    /* MRN Update Inventory Flow */

                    /* mrn all data save */

                    if ($data['po_id'] != "") updateUsedIdStatus('purchase_order', $data['po_id']);
                    $success = $this->purchase_model->update_data('mrn_detail', $data, 'id', $id);
                    $material_name_data = multiObjectToArray(json_decode($data['material_name']));
                    if($this->checkWrongInvoiceEntry($material_name_data)){
                         $this->autoDebitNote($material_name_data,$_POST,$success);
                    }


                    /* Lot No. */
                            $mrn_data22 = json_decode($mat_array, TRUE);
                            foreach ($mrn_data22 as $key2) {
                                $lotdetails = $this->purchase_model->get_data('lot_details', array('id' => $key2['lotno']));
                                foreach($lotdetails as $ree){
                                    if ($ree['id'] ==  $key2['lotno']) {
                                        $updatedQty = $ree['quantity'] + $key2['received_quantity'];
                                        $ree['quantity'] = $updatedQty;
                                        $success = $this->purchase_model->update_single_field_lotdetails('lot_details', $ree,$ree['id']);
                                    }
                                }
                            }
                    /* ,Lot No. */
                    if ($materialtypeUpdateIds != "''") updateMultipleUsedIdStatus('material_type', $materialtypeUpdateIds);
                    if ($materialUpdateIds != "''") updateMultipleUsedIdStatus('material', $materialUpdateIds);
                    if ($data['supplier_name'] != "") updateUsedIdStatus('supplier', $data['supplier_name']);
							$this->purchase_model->update_data('purchase_bill', $data_for_purchase_bill, 'id', $purchase_bill_id);
                    if ($success) {
                        /* update cost price of material to fetch last cost price of material  */
                        if (!empty($arr)) {
                            /*foreach ($arr as $res) {
                                $this->purchase_model->update_single_value_data('material', array('cost_price' => $res['price']), array('id' => $res['material_name_id'], 'created_by_cid' => $this->companyGroupId));
                            }*/
                        }
                        $data['message'] = "GRN Order updated successfully";
                        logActivity('GRN Updated', 'mrn_detail', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'GRN updated', 'message' => 'GRN id :#' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'MrnView', 'icon' => 'fa-shopping-cart'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'GRN updated', 'message' => 'GRN id :#' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'MrnView', 'icon' => 'fa-shopping-cart'));
                        }
                        $this->session->set_flashdata('message', 'GRN Updated successfully');
                        //redirect(base_url().'purchase/mrn', 'refresh');

                    }
                } else {
					 $material_name_data = multiObjectToArray(json_decode($data['material_name']));
					 // pre($data);die();	
                     $id = $this->purchase_model->insert_tbl_data('mrn_detail',$data);
                       if ($id) {
                            $a = '%"defected":1%';
                            $where = "id={$id} AND material_name LIKE '{$a}'";

                                   // $defected_Order=$this->purchase_model->defected_Order('mrn_detail', $where);

                                   // if ($defected_Order) {
                                       // $this->mailsand($defected_Order);
                                   // }




                        if( !empty($data['gate_id']) ){
                            $this->purchase_model->updateWhere('purchase_gateEntry',['convert_grn' => 1 ],['id' => $data['gate_id'] ]);
                        }
                       
                       // if($this->checkWrongInvoiceEntry($material_name_data)){
							// pre($material_name_data);die('upper');
                            $this->autoDebitNote($material_name_data,$_POST,$id);
                       // }
                    }

                    #$id = 1;
                    if($data_for_purchase_bill['is_quality_check'] = '1'){
                        $val=json_decode($quality_chk,true);
                        foreach($val as $val1){
                           $data['saleorder']='grn';
                           $data['grn_id']=$id;
                           $data['report_name']=$this->input->post('bill_no');
                           $data['final_report']=1;
                           $data['material_id']=$val1['material_name_id'];
                           $data['created_by']= $_SESSION['loggedInUser']->id;
                           $data['created_by_cid']=$this->companyGroupId;
                           $data['created_date']=date("Y-m-d H:i:s");
                           $this->purchase_model->insert_tbl_data('controlled_report_master',$data);
                       }
                }
                    if ($materialtypeUpdateIds != "''") updateMultipleUsedIdStatus('material_type', $materialtypeUpdateIds);
                    if ($materialUpdateIds != "''") updateMultipleUsedIdStatus('material', $materialUpdateIds);
                    if ($data['supplier_name'] != "") updateUsedIdStatus('supplier', $data['supplier_name']);
                    $this->purchase_model->insert_tbl_data('purchase_bill', $data_for_purchase_bill);
                    //pre($data_for_purchase_bill);die();
                    if ($data['po_id'] != "") updateUsedIdStatus('purchase_order', $data['po_id']);
                    if ($id) {
                        #echo "frfrfrrfrfrfrf";
                        /* update cost price of material to fetch last cost price of material  */
                        if (!empty($arr)) {
                            /*foreach ($arr as $res) {
                                $this->purchase_model->update_single_value_data('material', array('cost_price' => $res['price']), array('id' => $res['material_name_id'], 'created_by_cid' => $this->companyGroupId));
                            }
*/                        }
                        /*****************inventory add flow  **************************/
                        if (!empty($data) && $data['material_name'] != '' && $_POST['save_status'] != 0) {

                          $inventoryFlowData = json_decode($data['material_name']);

// pre($third_party_invdata);die();
                          $this->invantryOutInMaterial($inventoryFlowData,$_POST['delivery_address'],$id,'in','GRN');

                             // $yu = getNameById_mat('mat_locations',$materialView->id,'material_name_id');
                             //    $sum = 0;
                             //    if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}



                            /* Code to minus received quantity in Third Party Inventory */
                                $third_party_invdata = getNameById('thrd_party_invtry', $_POST['po_id'], 'challa_pur_ordr_no');
								
								
                                if(!empty($third_party_invdata)){
                                    $thrd_party_data = json_decode($third_party_invdata->material_descr,true);
                                    $recived_qty = json_decode($data['material_name'],true);
                                    $i=0;
                                    $rcivd_qty = array();
                                        foreach($recived_qty as $recvi_vals){
                                            $rcivd_qty = $recvi_vals['received_quantity'];
                                            foreach($thrd_party_data as $valss){
                                                if ($valss['material_id'] == $recvi_vals['material_name_id']){
                                                     $m_qty = $valss['quantity'] - $recvi_vals['received_quantity'];
                                                    $thrd_party_dd[] = array('material_id' => $valss['material_id'], 'descr_of_goods' => $valss['description'], 'hsnsac' => $valss['hsnsac'], 'quantity' => $m_qty, 'rate' => $valss['rate'], 'UOM' => $valss['UOM'], 'amount' => $valss['amount'], 'bom_number' => $valss['bom_number'], 'process_name' => $valss['process_name']);
                                                }
                                            }
                                        }
                                        $encoded_data = json_encode($thrd_party_dd);
                                        if(!empty($third_party_invdata)){
                                            $this->purchase_model->update_single_auto_entry($encoded_data,'thrd_party_invtry',$_POST['po_id'],$third_party_invdata->id);
                                        }
                                }
                            /* Code to minus received quantity in Third Party Inventory */
                            $mrn_data22 = json_decode($mat_array, TRUE);
                            foreach ($mrn_data22 as $key2) {
                                $lotdetails = $this->purchase_model->get_data('lot_details', array('id' => $key2['lotno']));
                                foreach($lotdetails as $ree){
                                    if ($ree['id'] ==  $key2['lotno']) {
                                        $updatedQty = $ree['quantity'] + $key2['received_quantity'];
                                        $ree['quantity'] = $updatedQty;
                                        $success = $this->purchase_model->update_single_field_lotdetails('lot_details', $ree,$ree['id']);
                                    }
                                }
                            }
                        } //pre($data);
                        logActivity('GRN inserted', 'purchase_bill', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'New GRN created', 'message' => 'New GRN is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'MrnView', 'icon' => 'fa-shopping-cart'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'New GRN created', 'message' => 'New GRN is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'MrnView', 'icon' => 'fa-shopping-cart'));
                        }
                        $this->session->set_flashdata('message', 'GRN  inserted successfully');
                        // redirect(base_url().'purchase/mrn', 'refresh');

                    }
                }
				// pre($_POST);
                if ($_POST['po_id'] != '' && $_POST['purchase_indent_id'] != '0' && $_POST['purchase_indent_id'] != '') { //when we create po to mrn
                    $doc_id = $_POST['purchase_indent_id'];
                } elseif ($_POST['pi_id'] != '' && $_POST['purchase_indent_id'] == '') { //when we create mrn through pi
                    $doc_id = $_POST['pi_id'];
                } //else {
					//pre($data);
                   // $doc_id = $id; //when we create direct mrn
                    //$data['po_id'] = $data['po_id'];
                   // $this->purchase_model->update_po_single_data('purchase_order', $data['po_id']);
               // }
				//die();
                if ($doc_id) {
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
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico|pdf|docs|jfif";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/purchase/uploads/" . $newname);
                            $proof_array[$i]['rel_id'] = $doc_id;
                            $proof_array[$i]['rel_type'] = 'PI_PO_MRN';
                            $proof_array[$i]['file_name'] = $newname;
                            $proof_array[$i]['file_type'] = $type;
                        }
                        if (!empty($proof_array)) {
                            $proofId = $this->purchase_model->insert_attachment_data('attachments', $proof_array, 'PI_PO_MRN');
                        }
                    }
                }
                //die;
                redirect(base_url() . 'purchase/mrn', 'refresh');
            }
        }
    }


    function addMoreMeterialInOutInvantry($invet_calculation,$address,$id,$existMaterial){
        $getMaterial = getMaterialUpdateInvntry($existMaterial['column'],$existMaterial['table'],$existMaterial['where']);
        $oldMaterialCount = count($getMaterial);
        $newMaterialCount = count($invet_calculation);
        if( $newMaterialCount > $oldMaterialCount ){
            $graterMaterialArray = $invet_calculation; // newArray
            $lessMaterialArray   = $getMaterial;      //oldArray
            $goType              = 'in';
        }elseif( $newMaterialCount < $oldMaterialCount ){
            $graterMaterialArray = $getMaterial;
            $lessMaterialArray   = $invet_calculation;
            $goType              = 'out';
        }

        foreach($graterMaterialArray as $key => $value){
            if( !isset($lessMaterialArray[$key]) ){
                 $returnNewArray[] = (object)$value;
            }
        }

        if( $returnNewArray ){
            $this->invantryOutInMaterial($returnNewArray,$address,$id,$goType,'GRN Update');
        }
    }

    function invantryOutInMaterial($invet_calculation,$address,$id,$goType,$through = ""){
		
        if( $invet_calculation ){
            foreach($invet_calculation as $icKey => $item){
				
                /* address not exist in material start */
                $checkMatLoc = $this->purchase_model->get_data('mat_locations',['material_name_id' => $item->material_name_id,
                                   'location_id' => $address ]);
                if( empty($checkMatLoc) ){

                     $ifData = [    'material_type_id' => $item->material_type_id,'material_name_id' => $item->material_name_id,
                                    'location_id' => $address,'Storage' => '','RackNumber' => '',
                                    'quantity' => 0,'lot_no' => '','Qtyuom' => $item->uom,
                                    'created_by_cid' => $this->companyGroupId
                                ];
                    // $this->purchase_model->insertData('mat_locations',$ifData);
                }



                /* address not exist in material end */

                $checkQtyAddress = getSingleAndWhere('location_id','mat_locations',['material_name_id' => $item->material_name_id,'quantity >= ' => $item->received_quantity ]);
				
                if( empty($address) ){
                    $address = $checkQtyAddress;
                }else{
                    $checkQty = getSingleAndWhere('quantity','mat_locations',['material_name_id' => $item->material_name_id,'location_id' => $address ]);
                    if( $goType == 'out' ){
                        if( $checkQty < $item->received_quantity ){
                            $address = $checkQtyAddress;
                        }
                    }
                }

                $material_type_id  = getSingleAndWhere('material_type_id','material',['id' => $item->material_name_id ]);
                $mat_locations = $this->account_model->get_data('mat_locations', array('material_name_id' =>$item->material_name_id));
                foreach($mat_locations as $loc1){
                    if( $loc1['location_id'] == $address ){
                        $arr =  json_encode(array(array('location' => $loc1['location_id'],'Storage' => $loc1['Storage'] , 'RackNumber' => $loc1['RackNumber'] ,
                                'quantity' => $item->received_quantity , 'Qtyuom' => $item->UOM)));
                    }
                }
                // $yu = getNameById_mat('mat_locations',$item->material_name_id,'material_name_id');
				$yu = getNameById_matWithLoc('mat_locations',$item->material_name_id,'material_name_id',$address,'location_id');
                $sum = 0;
				//pre($item);
				
                if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];
				//pre($ert['quantity']);
				}}
                if( $goType == 'out' ){
                    $closingblcn = $sum - $item->received_quantity;
                    $inventoryFlowDataNew = ['material_out' => $item->received_quantity];
				}else{
					$defectedQTTY = $item->received_quantity - $item->defectedQty;
					 // pre($defectedQTTY);
                    // $closingblcn = $sum + $item->received_quantity;
                    $closingblcn = $sum + $defectedQTTY;
                    // $inventoryFlowDataNew = ['material_in' => $item->received_quantity];
                    $inventoryFlowDataNew = ['material_in' => $defectedQTTY];
                }
				  // pre($closingblcn);
				  // pre($inventoryFlowDataNew);
 // die();
                $inventoryFlowDataArray = ['current_location' => $arr ,'material_id' => $item->material_name_id,
                                            'opening_blnc' => $sum,'material_type_id' => $material_type_id,'closing_blnc' => $closingblcn,
                                            'uom' => $item->uom,'through' => $through,'ref_id' => $id,
                                            'created_by' => $_SESSION['loggedInUser']->id,'created_by_cid' => $this->companyGroupId ];

                $inventoryFlowDataArray = $inventoryFlowDataArray + $inventoryFlowDataNew;

                // $this->saveInvantryFlowData($inventoryFlowDataArray,$item->material_name_id,$item->received_quantity,$address,$goType);
                $this->saveInvantryFlowData($inventoryFlowDataArray,$item->material_name_id,$closingblcn,$address,$goType);

            }
        }

    }

    function getOpeningBalance($mat_locations,$address,$item){
		
        foreach($mat_locations as $loc1){
                    if( $loc1['location_id'] == $address ){
                        $arr =  json_encode(array(array('location' => $loc1['location_id'],'Storage' => $loc1['Storage'] , 'RackNumber' => $loc1['RackNumber'],'quantity' => $item->received_quantity , 'Qtyuom' => $item->uom??'')));
                    }
                }
                // $yu = getNameById_mat('mat_locations',$item->material_name_id,'material_name_id');
                $yu = getNameById_matWithLoc('mat_locations',$item->material_name_id,'material_name_id',$address,'location_id');
                $sum = 0;
                if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                return $sum;
    }

    function updateInvantryMaterialInOut($invet_calculation,$address,$id,$existMaterial,$newAddress = ""){
		
		
            foreach ($invet_calculation as $key => $item) {
                $checkQtyAddress = getSingleAndWhere('location_id','mat_locations',['material_name_id' => $item->material_name_id,'quantity >= ' => $item->received_quantity ]);
                if( empty($address) ){
                    $address = $checkQtyAddress;
                }else{
                    $checkQty = getSingleAndWhere('quantity','mat_locations',['material_name_id' => $item->material_name_id,'location_id' => $address ]);
                    if( $existMaterial['goType'] == 'out' ){
                        if( $checkQty <= $item->received_quantity ){
                            $address = $checkQtyAddress;
                        }
                    }
                }

                if( empty($address) ){
                    continue;
                }

                $material_type_id  = getSingleAndWhere('material_type_id','material',['id' => $item->material_name_id ]);
                $mat_locations = $this->account_model->get_data('mat_locations', array('material_name_id' => $item->material_name_id));

                $sum = $this->getOpeningBalance($mat_locations,$address,$item);
				
				// 
				

                $getMaterial = getMaterialUpdateInvntry($existMaterial['column'],$existMaterial['table'],$existMaterial['where']);
				
				

                $notUpdateInvantry = false;
				
				

                 $closingblcn = 0;
                 if( $getMaterial ){
                    foreach( $getMaterial as $gmKey => $gmValue ){
                        if( $gmValue['material_name_id'] == $item->material_name_id ){
                            if( $gmValue['received_quantity'] < $item->received_quantity ){
                                $notUpdateInvantry = true;
								  
                                $qtyUpdate = ($item->received_quantity - $gmValue['received_quantity']);
                                // use gotype according to inward or outward
                                if( $existMaterial['goType'] == 'in' ){
                                    $closingblcn = $sum + $qtyUpdate;
                                    $inventoryFlowDataArrayNew = ['material_in' => $qtyUpdate];
                                    $goType = 'in';
                                }else{
                                    $closingblcn = $sum - $qtyUpdate;
                                    $inventoryFlowDataArrayNew = ['material_out' => $qtyUpdate];
                                    $goType = 'out';
                                }

                            }elseif( $gmValue['received_quantity'] > $item->received_quantity ){
                                $notUpdateInvantry = true;
                                $qtyUpdate = ($gmValue['received_quantity'] - $item->received_quantity);

                                // use gotype according to inward or outward

                                if( $existMaterial['goType'] == 'in' ){
                                    $closingblcn = $sum - $qtyUpdate;
                                    $inventoryFlowDataArrayNew = ['material_out' => $qtyUpdate];
                                    $goType = 'out';
                                }else{
                                    $closingblcn = $sum +  $qtyUpdate;
                                    $inventoryFlowDataArrayNew = ['material_in' => $qtyUpdate];
                                    $goType = 'in';

                                }

                            }
                        }
                    }
                 }
				
                if( $notUpdateInvantry ){
                    $this->account_model->updateRowWhere('material', ['id' => $ifValue['material_name_id'] ],['closing_balance' => $closingblcn ]);
                    $inventoryFlowDataArray = ['current_location' => $arr ,'material_id' => $item->material_name_id,
                            'opening_blnc' => $sum,'material_type_id' => $material_type_id,'closing_blnc' => $closingblcn,
                            'uom' => $item->uom??'','through' => $existMaterial['through'],'ref_id' => $id,
                            'created_by' => $_SESSION['loggedInUser']->id,'created_by_cid' => $this->companyGroupId ];
                    $inventoryFlowDataArray = $inventoryFlowDataArray + $inventoryFlowDataArrayNew;
					
pre($qtyUpdate);die('cHK');
                    $this->saveInvantryFlowData($inventoryFlowDataArray,$item->material_name_id,$qtyUpdate,$address,$goType);

                    # change address function start
                }

                if( $closingblcn == 0 ){
                    $closingblcn = $sum;
                }

                if($newAddress){

                    $checkMatLoc = $this->purchase_model->get_data('mat_locations',['material_name_id' => $item->material_name_id,
                                   'location_id' => $newAddress ]);

                    if( empty($checkMatLoc) ){
                         $ifData = [    'material_type_id' => $item->material_type_id,'material_name_id' => $item->material_name_id,
                                        'location_id' => $_POST['delivery_address'],'Storage' => '','RackNumber' => '',
                                        'quantity' => 0,'lot_no' => '','Qtyuom' => $item->uom,
                                        'created_by_cid' => $this->companyGroupId
                                    ];
                        $this->purchase_model->insertData('mat_locations',$ifData);
                    }

                    $mat_locations = $this->account_model->get_data('mat_locations', array('material_name_id' =>$item->material_name_id));
                    foreach($mat_locations as $loc1){
                        if( $loc1['location_id'] == $newAddress ){
                            $newArr =  json_encode(array(array('location' => $loc1['location_id'],'Storage' => $loc1['Storage'] , 'RackNumber' => $loc1['RackNumber'] ,
                                    'quantity' => $item->received_quantity, 'Qtyuom' => $item->uom??'')));
                        }
                    }

                    if( $newArr ){
                        $inventoryFlowDataArray = ['current_location' => $arr ,'material_id' => $item->material_name_id,
                            'opening_blnc' => $sum,'material_type_id' => $material_type_id,'closing_blnc' => $closingblcn,
                            'uom' => $item->uom??'','through' => $existMaterial['through'] . ' Address','ref_id' => $id,
                            'created_by' => $_SESSION['loggedInUser']->id,'created_by_cid' => $this->companyGroupId ];
                        if( $existMaterial['goType'] == 'in' ){
                            $updateDeliveryNewInventry =  ['material_in' => $item->received_quantity,'through' => 'GRN Update Address','new_location' => $newArr ];
                        }
                    }
                    $inventoryFlowDataArray = $inventoryFlowDataArray + $updateDeliveryNewInventry;

                    $this->materialInvantryUpdateAddress($inventoryFlowDataArray,$item->material_name_id,$item->received_quantity,$address,$newAddress,$existMaterial['goType']);

                }

                    # change address function end
            }
    }

    function materialInvantryUpdateAddress($inventoryFlowDataArray,$material_id,$quantity,$oldAddress,$newAddress,$goType){
		
		
        $getAddres = $this->account_model->get_data('mat_locations', array('material_name_id' => $material_id));
        foreach ($getAddres as & $values) {
            if ($values['material_name_id'] == $material_id) {
				
                if( $values['location_id'] == $oldAddress ){
                    if( $goType == 'in' ){
                        $updatedQty = $values['quantity'] - $quantity;
                    }else{
                        $updatedQty = $values['quantity'] + $quantity;
                    }
                    $values['quantity'] = $updatedQty;
                    $success = $this->account_model->update_single_field_mat('mat_locations', $values,$material_id);
                }

                if( $values['location_id'] == $newAddress ){
					
                    if( $goType == 'in' ){
                        $updatedQty = $values['quantity'] + $quantity;
                    }else{
                        $updatedQty = $values['quantity'] - $quantity;
                    }
                    $values['quantity'] = $updatedQty;
                    $success = $this->account_model->update_single_field_mat('mat_locations', $values,$material_id);
                }
            }

        }
        $this->account_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);
    }

    function saveInvantryFlowData($inventoryFlowDataArray,$material_id,$quantity,$address,$goType){
		 // pre($quantity);die('HMM');
		
		 $yu = getNameById_matWithLoc('mat_locations',$material_id,'material_name_id',$address,'location_id');
                $closing_balance = 0;
                if(!empty($yu)){ foreach ($yu as $ert) {$closing_balance += $ert['quantity'];}}
                $closing_balance;
		 
		
        // $closing_balance = getSingleAndWhere('closing_balance','material',['id' => $material_id ]);
		
        if( $goType == 'out' ){
            $update = ['closing_balance' => ($closing_balance - $quantity) ];
        }else{
            $update = ['closing_balance' => ($closing_balance + $quantity) ];
        }
		
        $this->account_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);
        $getAddres = $this->account_model->get_data('mat_locations', array('material_name_id' => $material_id,'location_id' => $address));
		
        $this->account_model->updateRowWhere('material', ['id' => $material_id ],$update);



        foreach ($getAddres as & $values) {
		
            if ($values['material_name_id'] == $material_id && $values['location_id'] == $address) {
                if( $goType == 'out' ){
                    $updatedQty = $values['quantity'] - $quantity;
                }else{
					// $updatedQty = $values['quantity'] + $quantity;
					 $updatedQty =  $quantity;
                }
				
		
                $values['quantity'] = $updatedQty;
				
				
		
                $success = $this->purchase_model->update_single_field_mat('mat_locations', $values,$material_id);
            }
        }
		// die();
    }

    public function addSupplierMaterialPriceByGRN($materialDetails,$supplier){
        $grnMaterialData = [];
        $supplierData = $this->purchase_model->getRowArray('material_name_id','supplier',['id' => $supplier ]);
        $supplierMaterial = json_decode($supplierData['material_name_id']);
        $supplierDeliveryDate = date('01-m-Y').' ~ '.date('t-m-Y');
        if($materialDetails){
            foreach ($materialDetails as $materialKey => $materialValue) {
                    $uom = getSingleAndWhere('uom_quantity','uom',['id' => $materialValue['uom'] ]);
                    $grnMaterialData[] = ['material_type_id' => $materialValue['material_type_id'],'material_name' => $materialValue['material_name_id'],
                                            'uom' => $uom,'supplierDeliveryDate' => $supplierDeliveryDate,'price' => $materialValue['price'] ];
            }
        }
        if( $supplierMaterial ){
            foreach ($supplierMaterial as $smKey => $smValue) {
                $grnMaterialData[] = ['material_type_id' => $smValue->material_type_id,'material_name' => $smValue->material_name,
                                            'uom' => $smValue->uom,'supplierDeliveryDate' => $supplierDeliveryDate,'price' => $smValue->price ];
            }

        }
        $getCoumnValue = array_unique(array_column($grnMaterialData, 'material_name'));
        $supplierUniqueMaterial = array_intersect_key($grnMaterialData, $getCoumnValue);
        $this->purchase_model->updateWhere('supplier',['material_name_id' => json_encode($supplierUniqueMaterial)],['id' => $supplier]);
    }

    public function checkWrongInvoiceEntry($materialData){
		
            $checkInvoice = false;
            foreach ($materialData as $key => $value) {
                    if( !empty($value['invoice_quantity']) ){
                        if( ($value['invoice_quantity'] != $value['received_quantity']) ){
                            $checkInvoice = true;
                        }
                    }
            }
            return $checkInvoice;
    }
	
	public function autoDebitNote($materialData,$convertData,$mrnid){
		
		
		
        if( !empty($materialData) ){
                $materialNewData = [];
                $remaningAmmount = 0;
                foreach ($materialData as $key => $value) {
					// pre($value);
					
                   $data = [
                    'material_type_id' => $value['material_type_id'],
                    'material_name_id' => $value['material_name_id'],
                    'date' => date('Y-m-d',strtotime($convertData['bill_date'])),
                    'action_type' => 'Rejected',
                    'quantity'    => $value['defectedQty'],
                    'uom' => $value['uom'],
                    'reason' => 'Reject in GRN',
                    'created_by_cid' => $this->companyGroupId,
                    'rejectedMrnID' => $mrnid
                ];
                $this->purchase_model->insertData('inventory_listing_adjustment',$data);
                }
				
				//die();
                // $data = [
                    // 'debitNoteNo' => strtotime(date('Y-m-d h:i:s')),
                    // 'date'            => date('Y-m-d',strtotime($convertData['bill_date'])),
                    // 'supplier_id' => $convertData['supplier_name'],
                    // 'PurchaseBill_no' => $convertData['bill_no'],
                    // 'buyerID'        => 195,
                    // 'PurchaseReturn_DN_ornot' => 0,
                    // 'debitAMt'  => $remaningAmmount,
                    // 'created_by' => 13,
                    // 'created_by_cid' => $this->companyGroupId,
                    // 'productDtl'     => json_encode($materialNewData)

                // ];
                // $this->purchase_model->insertData('debitnote_tbl',$data);
        }


    }

    public function autoDebitNotew($materialData,$convertData){
        if( !empty($materialData) ){
                $materialNewData = [];
                $remaningAmmount = 0;
                foreach ($materialData as $key => $value) {
                    if( !empty($value['invoice_quantity']) ){
                        $remaningAmmount += $value['debitNoteAmount'];
                        foreach ($value as $mKey => $mValue) {
                             $materialNewData[$key][$mKey] = $mValue;
                         }
                    }
                }
                $data = [
                    'debitNoteNo' => strtotime(date('Y-m-d h:i:s')),
                    'date'            => date('Y-m-d',strtotime($convertData['bill_date'])),
                    'supplier_id' => $convertData['supplier_name'],
                    'PurchaseBill_no' => $convertData['bill_no'],
                    'buyerID'        => 195,
                    'PurchaseReturn_DN_ornot' => 0,
                    'debitAMt'  => $remaningAmmount,
                    'created_by' => 13,
                    'created_by_cid' => $this->companyGroupId,
                    'productDtl'     => json_encode($materialNewData)

                ];
                $this->purchase_model->insertData('debitnote_tbl',$data);
        }


    }

    public function convertPoToGate(){
        $this->data = [];
        $this->data['convert_to_gate'] = 0;
        if( $_POST['convert_to_gate'] ){

            $data = [
                'po_id' => $_POST['po_id'],
                'gate_no' => $_POST['gate_no'],
                'invoice_no' => $_POST['invoice_no'],
                'supplier'   => $_POST['supplier'],
                'created_by_cid' => $_POST['logged_in_user'],
                'created_at'   => date('Y-m-d 00:00:00',strtotime(str_replace('/', '-', $_POST['currentDate'])) )
            ];


            if( $_POST['gateId'] ){
                $this->purchase_model->updateRowWhere('purchase_gateEntry',['id' => $_POST['gateId']],$data);
                logActivity('Update gate entry', 'purchase_gateEntry', $id);
                $this->session->set_flashdata('message','Update Gate Entry');
            }else{
                if($this->purchase_model->insertData('purchase_gateEntry',$data)){
                    $this->purchase_model->updateRowWhere('purchase_order',['id' => $_POST['po_id']],['gate_or_not' => 1,'used_status' => 1]);
                    $this->session->set_flashdata('message','Purchase order convert into Gate entry successfuly');
                }
            }
            redirect('purchase/gateEntryIndex');
        }else{
                $this->data['convert_to_gate'] = 1;
                $where = array('supplier.created_by_cid' => $this->companyGroupId);
                $this->data['suppliers']    = $this->purchase_model->get_data('supplier', $where);
                $this->data['gateEntryNo']  = $this->purchase_model->getLastIdWithInc('purchase_gateEntry','gate_no');
            if( $_POST['id'] != "addGateEntry" ){
                $this->data['mrnOrder']     = $this->purchase_model->get_data_byId('purchase_order', 'id', $_POST['id']);
                $this->data['editData'] = $this->purchase_model->getGateEntryIndexData($_POST['id'],'pge.id');
                $this->data['po_id']        = $_POST['id'];
            }
            $this->load->view('gate/convert_to_gate',$this->data);
        }

    }

    function gateEntryIndex(){
        permissions_redirect('is_view');
        /*$this->load->library('pagination');*/
        if( !checkGateEnable() ){
            redirect('purchase/dashboard');
        }
        $where = ['created_by_cid' => $this->companyGroupId];
        $rows=$this->purchase_model->tot_rows('purchase_gateEntry',['created_by_cid' => $this->companyGroupId],[]);

        $config = paginationAttr("purchase/gateEntryIndex",$rows);
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        /*pre($this->data['gateEnteryData']);die;*/
        $this->data['gateEnteryData'] = $this->purchase_model->getGateEntryIndex($config["per_page"],$page);
        $this->_render_template('gate/index',$this->data);
    }

    function gateView(){
        $this->data['gateEnteryData'] = $this->purchase_model->getGateEntryIndexData($_POST['id'],'pge.id');
        $this->load->view('gate/view',$this->data);
    }

    function delete_gate($id = ''){
        if (!$id) {
            redirect('purchase/gateEntryIndex', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->purchase_model->delete_data('purchase_gateEntry', 'id', $id);
        if ($result) {
            logActivity('Gate Entry Deleted', 'purchase_gateEntry', $id);
            $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 7));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Gate Entry deleted', 'message' => 'gate Entry id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Gate Entry deleted', 'message' => 'Gate Entry id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
            }
            $this->session->set_flashdata('message', 'Gate Entry Deleted Successfully');
            $result = array('msg' => 'Gate Entry Deleted Successfully', 'status' => 'success', 'code' => 'C142', 'url' => base_url() . 'purchase/gateEntryIndex');
            echo json_encode($result);
        }else{
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C664'));
        }
        //redirect('purchase/gateEntryIndex', 'refresh');
    }

    /*delete MRN*/
    public function delete_mrn($id = '') {
        if (!$id) {
            redirect('purchase/mrn', 'refresh');
        }
        permissions_redirect('is_delete');
        $mrn_detail = $this->purchase_model->get_data_byId('mrn_detail', 'id', $id);
        if (!empty($mrn_detail)) {
            $delivery_address = $mrn_detail->delivery_address;
            $inventoryFlowData = json_decode($mrn_detail->material_name);
            $this->invantryOutInMaterial($inventoryFlowData,$delivery_address,$id,'out','GRN Removed');
        }
        $result = $this->purchase_model->delete_data('mrn_detail', 'id', $id);
        if ($result) {
            logActivity('GRN Deleted', 'mrn_detail', $id);
            $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 7));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'GRN deleted', 'message' => 'GRN id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'GRN deleted', 'message' => 'GRN id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
            }
            $this->session->set_flashdata('message', 'GRN Deleted Successfully');
            $result = array('msg' => 'GRN Deleted Successfully', 'status' => 'success', 'code' => 'C142', 'url' => base_url() . 'purchase/mrn');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C664'));
        }
    }
    /**************************Dashboard data********************************************************************/
    public function dashboard() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Purchase', base_url() . 'purchase/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'purchase/dashboard');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Dashboard';
        $where = array('supplier.created_by_cid' => $this->companyGroupId);
        $this->data['suppliers'] = $this->purchase_model->get_data('supplier', $where);
        $where = array('purchase_order.created_by_cid' => $this->companyGroupId);
        $this->data['purchase_order'] = $this->purchase_model->get_data('purchase_order', $where);
        $where = array('purchase_indent.created_by_cid' => $this->companyGroupId);
        $this->data['indent'] = $this->purchase_model->get_data('purchase_indent', $where);
        $where = array('mrn_detail.created_by_cid' => $this->companyGroupId);
        $this->data['mrn'] = $this->purchase_model->get_data('mrn_detail', $where);
        $this->data['user_dashboard'] = $this->purchase_model->get_data_dashboard('user_dashboard', array('user_id' => $_SESSION['loggedInUser']->id));
        $this->_render_template('dashboard/index', $this->data);
    }
    public function graphDashboardData() {
        if (!empty($_POST)) {
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
        } else {
            $startDate = $endDate = '';
        }
        $graphDashboardArray = array();
        $getMonthApprovetatusGraph = getMonthApprovetatusGraph($startDate, $endDate);
        $getPItoPoConversion = getPItoPoConversion($startDate, $endDate);
        $getPOtoMRNConversion = getPOtoMRNConversion($startDate, $endDate);
        $PoAmountTotalWithMaterial = PoAmountTotalWithMaterial($startDate, $endDate);
        $MRNAmountTotalWithMaterial = MRNAmountTotalWithMaterial($startDate, $endDate);
        $piCompleteStatusAmountTotalWithMaterial = piCompleteStatusAmountTotalWithMaterial($startDate, $endDate);
        $getIndentStatusGraph = getIndentStatusGraph($startDate, $endDate);
        $getMrnStarRating = getMrnStarRating($startDate, $endDate);
        $getDashboardCount = getDashboardCount($startDate, $endDate);
        /*$graphDashboardArray = array('monthLeadStatusGraph' => $monthLeadStatusGraph , 'monthLeadTargetGraph' => $monthLeadTargetGraph,'monthSaleOrderGraph' => $monthSaleOrderGraph,'getLeadStatusGraph'=> $getLeadStatusGraph,'getWinLeadVsTotalGraph'=>$getWinLeadVsTotalGraph,'getDashboardCount'=>$getDashboardCount);*/
        $graphDashboardArray = array('getDashboardCount' => $getDashboardCount, 'getIndentStatusGraph' => $getIndentStatusGraph, 'getMonthApprovetatusGraph' => $getMonthApprovetatusGraph, 'getMrnStarRating' => $getMrnStarRating, 'getPItoPoConversion' => $getPItoPoConversion, 'getPOtoMRNConversion' => $getPOtoMRNConversion, 'PoAmountTotalWithMaterial' => $PoAmountTotalWithMaterial, 'piCompleteStatusAmountTotalWithMaterial' => $piCompleteStatusAmountTotalWithMaterial, 'MRNAmountTotalWithMaterial' => $MRNAmountTotalWithMaterial);
        echo json_encode($graphDashboardArray);
    }
    /*dashboard code to display on main dashboard*/
    public function showDashboardOnRequirement() {
        $data = $_POST;
        $data['user_id'] = $_SESSION['loggedInUser']->id;
        $user_dashboard = $this->purchase_model->get_data_dashboard('user_dashboard', array('user_id' => $_SESSION['loggedInUser']->id, 'graph_id' => $data['graph_id']));
        //pre($user_dashboard); die;
        if (!empty($user_dashboard)) {
            //$id = $this->purchase_model->update_data('user_dashboard',$data,'id',$user_dashboard[0]['id']);
            $id = $this->purchase_model->update_user_graph_data('user_dashboard', $data);
        } else {
            $id = $this->purchase_model->insert_tbl_data('user_dashboard', $data);
        }
        if ($id) {
            $result = array('msg' => 'Data for user set', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'purchase/dashbaord');
            echo json_encode($result);
            die;
        }
    }
    public function Get_Ledgers_according_toParent() {
        $created_id = $_SESSION['loggedInUser']->u_id;
        $dded = $this->purchase_model->get_data_new('account_group', $created_id);
        $paret_idd = [];
        foreach ($dded as $get_data) {
            $paret_idd[] = $get_data['parent_group_id'];
        }
        $data_parent = implode(", ", $paret_idd);
        $dded_check = $this->purchase_model->get_data_Accrding_toparent_id($data_parent, $created_id);
        echo json_encode($dded_check);
    }
    //Add more Supplier On the Spot
    public function add_suppliers_detials_on_the_spot() {
        $supplier_name = $_REQUEST['name'];
        $address = $_REQUEST['address'];
        $gstin = $_REQUEST['gstin'];
        $country = $_REQUEST['country'];
        $state = $_REQUEST['state'];
        $city_id = $_REQUEST['city_id'];
        $acc_group_id = $_REQUEST['acc_group_id'];
        $created_by_cid = $this->companyGroupId;
        $created_by_id = $_SESSION['loggedInUser']->u_id;
        $last_id = getLastTableId('supplier');
        $rId = $last_id + 1;
        $supCode = 'SUPP_' . rand(1, 1000000) . '_' . $rId;
        $supplier_details = array('supplier_code' => $supCode, 'name' => $supplier_name, 'address' => $address, 'gstin' => $gstin, 'country' => $country, 'state' => $state, 'city' => $city_id, 'supp_account_group_id' => $acc_group_id, 'created_by_cid' => $created_by_cid, 'created_by ' => $created_by_id);
        $dd = $this->purchase_model->get_ledger_account_grp_Dtl('account_group', $created_by_id, $_REQUEST['acc_group_id']);
        $data_for_ledger['parent_group_id'] = $dd[0]['parent_group_id'];
        $mailing_addressLength = count($_REQUEST['country']);
        if ($mailing_addressLength > 0) {
            $supp_dttl = [];
            $i = 0;
            while ($i < $mailing_addressLength) {
                $jsonArrayObject = (array('mailing_country' => $country[$i], 'mailing_state' => $state[$i], 'mailing_city' => $city_id[$i]));
                $supp_dttl[$i] = $jsonArrayObject;
                $i++;
            }
            $descr_of_ldgr_array = json_encode($supp_dttl);
        } else {
            $descr_of_ldgr_array = '';
        }
        $Last_id = $this->purchase_model->insert_on_spot_tbl_data('supplier', $supplier_details);
        $supplier_details_ledger_tbl = array('name' => $supplier_name, 'supp_id' => $Last_id, 'gstin' => $gstin, 'mailing_address' => $descr_of_ldgr_array, 'account_group_id' => $_REQUEST['acc_group_id'], 'parent_group_id' => $data_for_ledger['parent_group_id'], 'created_by_cid' => $created_by_cid, 'created_by ' => $created_by_id);
        $data = $this->purchase_model->insert_on_spot_tbl_data('ledger', $supplier_details_ledger_tbl);
        if ($data > 0) {
            $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 3));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'New supplier created', 'message' => 'New supplier is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $data, 'class' => 'add_purchase_tabs', 'data_id' => 'SupplierView', 'icon' => 'fa-shopping-cart'));
                    }
                }
            }
            echo 'true';
        } else {
            echo 'false';
        }
    }
    //Add more Supplier On the Spot
    Public function purchase_settings() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['search_string'] = '';
        $search_string = $this->input->post('search');
        $where = array('created_by_cid' => $this->companyGroupId, 'charges_for' => 1);
        $config = ['base_url' => base_url() . 'purchase/purchase_settings', 'per_page' => 10, 'total_rows' => $this->purchase_model->num_rows('charges_lead', $where, $search_string), "uri_segment" => 3, "use_page_numbers" => TRUE, 'full_tag_open' => '<ul class="pagination">', 'full_tag_close' => '</ul>', 'first_link' => '&laquo; First', 'first_tag_open' => '<li class="prev page">', 'first_tag_close' => '</li>', 'last_link' => 'Last &raquo;', 'last_tag_open' => '<li class="next page">', 'last_tag_close' => '</li>', 'next_link' => 'Next &rarr;', 'next_tag_open' => '<li class="next page">', 'next_tag_close' => '</li>', 'prev_link' => '&larr; Previous', 'prev_tag_open' => '<li class="prev page">', 'prev_tag_close' => '</li>', 'cur_tag_open' => '<li class="active"><a href="">', 'cur_tag_close' => '</a></li>', 'num_tag_open' => '<li class="page">', 'num_tag_close' => '</li>', ];
        $this->data['sort_cols'] = array('id' => 'Id', 'name' => 'Name', 'material_type_id' => 'Material Type',);
        $config["uri_segment"] = 5;
        $this->data['sort_by'] = $this->uri->segment(3, 'id');
        $orderBy = $this->uri->segment(4, "desc");
        if ($orderBy == "asc") $this->data['sort_order'] = "desc";
        else $this->data['sort_order'] = "asc";
        $config["base_url"] = base_url() . 'purchase/purchase_settings/' . $this->data['sort_by'] . '/' . $orderBy . '/' . $search_string . '/';
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        if (isset($page) && is_numeric($page) && $page != 0) $page = ($page - 1) * 10;
        if (!empty($search_string)) {
            $this->uri->segment(6, $this->uri->segment(5, 1));
            $this->data['search_string'] = $this->uri->segment(5, $search_string);
        } elseif ($this->uri->segment(5) != null && !empty($this->uri->segment(5)) && $this->uri->segment(6) != null) {
            $this->data['search_string'] = $this->uri->segment(5);
        }
        $page_uri = 5;
        if (!empty($this->data['search_string'])) $page_uri = 6;
        $config["uri_segment"] = $page_uri;
        $config["total_rows"] = $this->purchase_model->num_rows('charges_lead', $where, $this->data['search_string']);
        $data['page'] = $this->uri->segment($page_uri, 1);
        $this->pagination->initialize($config);
        $this->data['other_charges'] = $this->purchase_model->get_charges_Datatt('charges_lead', $where, $config['per_page'], $page, $this->data['sort_by'], $orderBy, $this->data['search_string']);
        $this->_render_template('setting/index', $this->data);
        #$this->data['other_charges']  = $this->purchase_model->get_charges_Datatt('charges_lead',array('created_by_cid'=> $this->companyGroupId,'charges_for'=>1));

    }
    public function editcharges() {
        if ($this->input->post()) {
            $this->data['id'] = $this->input->post('id');
            $this->data['other_charges'] = $this->purchase_model->get_data_byId('charges_lead', 'id', $this->input->post('id'));
            $this->load->view('setting/edit', $this->data);
        }
    }
    public function savecharges() {
        if ($this->input->post()) {
            $required_fields = array('particular_charges');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $data['created_by_uid'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $id = $data['id'];
                //pre($data);die();
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success = $this->purchase_model->update_data('charges_lead', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Charges updated successfully";
                        logActivity('Charges  Updated', 'charges_lead', $id);
                        $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 87));
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'Charges updated', 'message' => 'Charges of id : #' . $id . ' are updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'Charges updated', 'message' => 'Charges of id : #' . $id . ' are updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
                        }
                        $this->session->set_flashdata('message', 'Charges  Updated successfully');
                        redirect(base_url() . 'purchase/purchase_settings', 'refresh');
                    }
                } else {
                    $id = $this->purchase_model->insert_tbl_data('charges_lead', $data);
                    if ($id) {
                        logActivity('New Charges Created', 'charges_lead', $id);
                        pushNotification(array('subject' => 'Charges created', 'message' => 'Charges created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
                        $this->session->set_flashdata('message', 'Charges  inserted successfully');
                        redirect(base_url() . 'purchase/purchase_settings', 'refresh');
                    }
                }
            }
        }
    }
    public function deleteCharges_leads($id = '') {
        if (!$id) {
            redirect('purchase/purchase_settings', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('charges_lead', 'id', $id);
        if ($result) {
            logActivity('Charge  Deleted', 'charges_lead', $id);
            $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 87));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Charges deleted', 'message' => 'Charges of id: # ' . $id . ' are deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Charges deleted', 'message' => 'Charges of id: # ' . $id . ' are deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'icon' => 'fa-shopping-cart'));
            }
            $this->session->set_flashdata('message', 'Charge Deleted Successfully');
            $result = array('msg' => 'Charge Deleted Successfully', 'status' => 'success', 'code' => 'C264', 'url' => base_url() . 'purchase/purchase_settings');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
    }
    /*function to add/edit data*/
    public function indent_edit_new() {

        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['indents'] = $this->purchase_model->get_data_byId('purchase_indent', 'id', $id);
        if (!empty($this->data['indents'])) $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material', 'material_type_id', $this->data['indents']->material_type_id);
        $this->load->view('purchase_indent/edit_new', $this->data);
    }
    /*function to view data*/
    public function indent_view_new() {
        $id = $_POST['id'];
        permissions_redirect('is_view');
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['indents'] = $this->purchase_model->get_data_byId('purchase_indent', 'id', $id);
        /*if(!empty($this->data['indents']))
         $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material' ,'material_type', $this->data['indents']->material_type);*/
        $this->load->view('purchase_indent/view_new', $this->data);
    }
    public function po_edit_new() {

        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['materialName'] = $this->purchase_model->get_data('material');
        $this->data['order'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);
        if (!empty($this->data['poCreate'])) $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material', 'material_type_id', $this->data['poCreate']->material_type_id);
        if (!empty($this->data['order'])) $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material', 'material_type_id', $this->data['order']->material_type_id);
        $this->load->view('purchase_order/edit_new', $this->data);
    }
    public function order_view_new() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_view');
        }
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['orders'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $id);
        $this->load->view('purchase_order/view_new', $this->data);
    }
    //Upload Supplier Data through Excel//
    // public function uploadsupplier_data(){
    // $this->data['can_edit'] = edit_permissions();
    // $this->data['can_delete'] = delete_permissions();
    // $this->data['can_add'] = add_permissions();
    // $this->data['can_view'] = view_permissions();
    // $this->data['can_validate'] = validate_permissions();
    // $this->breadcrumb->add('Upload', base_url() . 'supplier');
    // $this->settings['breadcrumbs'] = $this->breadcrumb->output();
    // $this->settings['pageTitle'] = 'Supplier Upload';
    // $this->_render_template('suppliers/upload', $this->data);
    // }
    public function import_view() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Import Data', base_url() . 'Import Data');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Import Data';
        $this->load->library('excel');
        $importData = importExcelFile($_FILES,'excelFile','assets/import');
        if( !empty($importData['data']) ){
            array_shift($importData['data']);

            $i = 1;
            $supplierSheet = [];
            foreach($importData['data'] as $key => $value){
                if(  empty($value['A']) && empty($value['B']) && empty($value['C']) && empty($value['D']) && empty($value['E']) ){
                    continue;
                }

                $accountGroupId = $this->purchase_model->getIdByName('id','account_group','name',$value['B']);


                if( empty($value['E']) ){
                    $arrayKey = $i;
                }else{
                    $arrayKey = $value['E'];
                }
                $supplierSheet[$arrayKey]['name']                   = ucfirst($value['A']);
                $supplierSheet[$arrayKey]['supp_account_group_id']  = $accountGroupId;
                $supplierSheet[$arrayKey]['gstin']                  = $value['E'];
                $supplierSheet[$arrayKey]['save_status']            = 1;
                $supplierSheet[$arrayKey]['used_status']            = 0;
                $supplierSheet[$arrayKey]['created_by']             = $_SESSION['loggedInUser']->u_id;
                $supplierSheet[$arrayKey]['created_by_cid']         = $this->companyGroupId;
                if( !empty($value['C']) || !empty($value['D'])  ){
                        $supplierSheet[$arrayKey]['material_name'][] = [ 'material_type_id' => getSingleAndWhere('id','material_type',['name' => $value['C'] ]),
                                                'material_name' => getSingleAndWhere('id','material',['material_name' => $value['D'] ]),
                                                'price'         => 0,
                                                'uom'           => getSingleAndWhere('uom','material',['material_name' => $value['D'] ]),
                                                'supplierDeliveryDate' => ''
                                                 ];
                }

                if( isset($supplierSheet[$arrayKey]['material_name']) ){
                    if( $supplierSheet[$arrayKey]['material_name'] ){
                        $matData = json_encode($supplierSheet[$arrayKey]['material_name']);
                        $supplierSheet[$arrayKey]['material_name_id'] = $matData;
                    }
                }
                $i++;
            }

            if( !empty($supplierSheet) ){
                $i = 1;
                foreach($supplierSheet as $ssKey => $ssValue){
                    $last_id = getLastTableId('supplier');
                    $rId = $last_id + $i;
                    $supCode = 'SUPP_' . rand(1, 1000000) . '_' . $rId;
                    unset($ssValue['material_name']);
                    $ssValue = $ssValue + ['supplier_code' => $supCode ];
                    $id = $this->purchase_model->insert_tbl_data('supplier', $ssValue);
                    $data_for_ledger['supp_id'] = $id;
                    $ledgerid = $this->purchase_model->insert_tbl_data('ledger', $data_for_ledger);
                    if ($id) {
                        logActivity('supplier inserted', 'supplier', $id);
                        $this->session->set_flashdata('message', "{$i} Supplier inserted successfully");
                    }
                    $i++;
                }
            }
        }


        redirect('purchase/suppliers');
    }
    //Upload Supplier Data through Excel//
    /*function to change to status of Purchase Indent */
    public function pi_change_status() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['indents'] = $this->purchase_model->get_data_byId('purchase_indent', 'id', $id);
        $wherePo = array('purchase_order.pi_id' => $id, 'purchase_order.save_status' => 1);
        $this->data['po'] = $this->purchase_model->get_data('purchase_order', $wherePo);
        $whereMrn = array('mrn_detail.pi_id' => $id, 'mrn_detail.save_status' => 1);
        $this->data['mrn'] = $this->purchase_model->get_data('mrn_detail', $whereMrn);
        $this->load->view('purchase_indent/change_status', $this->data);
    }
    /* Function to change the status of purchase indent */
    public function saveStatusPI() {
        if ($_POST['check_payment_complete'] == 'complete_payment') {
            $ifBalance = 0; //Payment Complete
            date_default_timezone_set('Asia/Kolkata');
            $complete_Date = date('Y-m-d H:i');
        } else {
            $ifBalance = 1; //Payment Not Complete

        }
        $piArray = array();
        if (array_key_exists("0", $_POST['pi_status'])) $piArray['PO'] = array('name' => 'PO', 'po_or_verbal' => $_POST['po_or_verbal'], 'po_code' => $_POST['po_code']);
        if (array_key_exists("1", $_POST['pi_status'])) $piArray['MRN'] = array('name' => 'MRN', 'mrn_or_without_form' => $_POST['mrn_or_without_form'], 'mrn_code' => $_POST['mrn_code'], 'invoice_no' => $_POST['invoice_no'], 'invoice_date' => $_POST['invoice_date']);
        if (in_array("payment", $_POST['pi_status'])) {
            $piArray['Payment'] = array();
            $piPreviousPaymentData = array();
            $paymentData = $_POST['amount'] != '' ? array('name' => 'Payment', 'amount' => $_POST['amount'], 'balance' => $ifBalance, 'required_date' => $_POST['required_date'], 'description' => $_POST['description']) : array();
            $piArray['Payment'][0] = $paymentData;
            //For Previous added Data
            if ($_POST['previousPaymentData'] != '' && $_POST['indent_grand_totl'] != 0 && $_POST['amount'] != '') {
                $piPreviousPaymentData = json_decode($_POST['previousPaymentData']);
                $i = $piArray['Payment'][0] == array() ? 0 : 1;
                foreach ($piPreviousPaymentData as $paymentVal) {
                    $piArray['Payment'][$i] = $paymentVal;
                    $i++;
                }
            } elseif ($_POST['indent_grand_totl'] != 0 && $_POST['amount'] == '') { //New Data
                $j = 0;
                foreach ($_POST['edit_amount'] as $new_amt) {
                    $jsonArrayObject = array('name' => 'Payment', 'amount' => $new_amt, 'balance' => $ifBalance[$j], 'required_date' => $_POST['edit_required_date'][$j], 'description' => $_POST['edit_description'][$j]);
                    $piArray['Payment'][$j] = $jsonArrayObject;
                    $j++;
                }
            } else {
                $j = 0;
                foreach ($_POST['edit_amount'] as $new_amt) { //For Edited Data
                    $jsonArrayObject = array('name' => 'Payment', 'amount' => $new_amt, 'balance' => $ifBalance[$j], 'required_date' => $_POST['edit_required_date'][$j], 'description' => $_POST['edit_description'][$j]);
                    $piArray['Payment'][$j] = $jsonArrayObject;
                    $j++;
                }
            }
        }
        if (in_array("po", $_POST['pi_status']) && in_array("payment", $_POST['pi_status']) && in_array("mrn", $_POST['pi_status']) && in_array("complete", $_POST['pi_status']) && $ifBalance != 0) {
            $piArray['Complete'] = array('name' => 'Complete', 'value' => 1);
            $update_data = array('mrn_or_not' => '1', 'po_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("po", $_POST['pi_status']) && in_array("payment", $_POST['pi_status']) && in_array("mrn", $_POST['pi_status']) && in_array("complete", $_POST['pi_status']) && $ifBalance == 0) {
            $piArray['Complete'] = array('name' => 'Complete', 'value' => 1);
            $update_data = array('pay_or_not' => '1', 'mrn_or_not' => '1', 'po_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("po", $_POST['pi_status']) && in_array("payment", $_POST['pi_status']) && $ifBalance == 0 && in_array("complete", $_POST['pi_status'])) {
            $update_data = array('pay_or_not' => '1', 'po_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("mrn", $_POST['pi_status']) && in_array("payment", $_POST['pi_status']) && $ifBalance == 0 && in_array("complete", $_POST['pi_status'])) {
            $update_data = array('pay_or_not' => '1', 'mrn_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance == 0 && in_array("complete", $_POST['pi_status'])) {
            $update_data = array('pay_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance != 0 && in_array("mrn", $_POST['pi_status']) && in_array("po", $_POST['pi_status'])) {
            $update_data = array('mrn_or_not' => '1', 'po_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance != 0 && in_array("mrn", $_POST['pi_status'])) {
            $update_data = array('mrn_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance != 0 && in_array("po", $_POST['pi_status'])) {
            $update_data = array('po_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance == 0 && in_array("po", $_POST['pi_status']) && in_array("mrn", $_POST['pi_status'])) {
            $piArray['Complete'] = array('name' => 'Complete', 'value' => 1);
            $update_data = array('po_or_not' => '1', 'mrn_or_not' => '1', 'pay_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance == 0 && !in_array("po", $_POST['pi_status'])) {
            $update_data = array('pay_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance == 0 && in_array("po", $_POST['pi_status'])) {
            $update_data = array('po_or_not' => '1', 'pay_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("mrn", $_POST['pi_status']) && in_array("po", $_POST['pi_status'])) {
            $update_data = array('mrn_or_not' => '1', 'po_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (!in_array("payment", $_POST['pi_status']) && $ifBalance != 0 && in_array("po", $_POST['pi_status'])) {
            $update_data = array('po_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (!in_array("payment", $_POST['pi_status']) && $ifBalance != 0 && in_array("mrn", $_POST['pi_status'])) {
            $update_data = array('mrn_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance != 0) {
            $update_data = array('ifbalance' => $ifBalance);
        }
        $piJsonArray = JSON_encode($piArray);
        $statusArray = array('status' => $piJsonArray);
        if ($_POST['frm_mrn_data'] == 'mrn_Data') { //Conditions for MRN Module
            $where_pi = array('mrn_detail.id' => $_POST['id']);
            $get_mrn_Data_Start = $this->purchase_model->get_data('mrn_detail', $where_pi);
            /*Quieries for Purchase order Table*/
            if ($get_mrn_Data_Start[0]['pi_id'] != 0) {
                $this->purchase_model->change_status_complete_or_not('purchase_indent', $update_data, $get_mrn_Data_Start[0]['pi_id'], 'id');
                $this->purchase_model->update_balance_status_chng('purchase_indent', $ifBalance, 'ifbalance', $get_mrn_Data_Start[0]['pi_id'], 'id');
                $this->purchase_model->update_balance_status_chng('purchase_indent', $complete_Date, 'complete_date', $get_mrn_Data_Start[0]['pi_id'], 'id');
                $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $get_mrn_Data_Start[0]['pi_id']);
            }
            /*Quieries for Purchase order  Table*/
            /*Quieries for Purchase indent Table*/
            if ($get_mrn_Data_Start[0]['po_id'] != 0) {
                unset($update_data['po_or_not']);
                $this->purchase_model->change_status_complete_or_not('purchase_order', $update_data, $get_mrn_Data_Start[0]['po_id'], 'id');
                $this->purchase_model->update_balance_status_chng('purchase_order', $ifBalance, 'ifbalance', $get_mrn_Data_Start[0]['po_id'], 'id');
                $this->purchase_model->update_balance_status_chng('purchase_order', $complete_Date, 'complete_date', $get_mrn_Data_Start[0]['po_id'], 'id');
                $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_order', $statusArray, 'id', $get_mrn_Data_Start[0]['po_id']);
                $where_pi_Data = array('purchase_order.id' => $get_mrn_Data_Start[0]['po_id']);
                $get_PO_Data = $this->purchase_model->get_data('purchase_order', $where_pi_Data);
                if ($get_PO_Data[0]['pi_id'] != 0) {
                    $this->purchase_model->change_status_complete_or_not('purchase_indent', $update_data, $get_PO_Data[0]['pi_id'], 'id');
                    $this->purchase_model->update_balance_status_chng('purchase_indent', $ifBalance, 'ifbalance', $get_PO_Data[0]['pi_id'], 'id');
                    $this->purchase_model->update_balance_status_chng('purchase_indent', $complete_Date, 'complete_date', $get_PO_Data[0]['pi_id'], 'id');
                    $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $get_PO_Data[0]['pi_id']);
                }
            }
            if ($ifBalance == 0) {
                $update_data212 = array('pay_or_not' => '1', 'ifbalance' => $ifBalance);
                $this->purchase_model->change_status_complete_or_not('mrn_detail', $update_data212, $_POST['id'], 'id');
            }
            $this->purchase_model->update_balance_status_chng('mrn_detail', $ifBalance, 'ifbalance', $_POST['id'], 'id');
            $this->purchase_model->update_balance_status_chng('mrn_detail', $complete_Date, 'complete_date', $_POST['id'], 'id');
            $this->data['piStatus'] = $this->purchase_model->changePiStatus('mrn_detail', $statusArray, 'id', $_POST['id']);
            redirect(base_url() . 'purchase/mrn', 'refresh');
        }
        //die('here');
        if ($_POST['Purch_indent_Data'] == 'Purch_indent') { //conditions for Purchase Indent Table
            $this->purchase_model->change_status_complete_or_not('purchase_indent', $update_data, $_POST['id'], 'id');
            $this->purchase_model->update_balance_status_chng('purchase_indent', $ifBalance, 'ifbalance', $_POST['id'], 'id');
            $this->purchase_model->update_balance_status_chng('purchase_indent', $complete_Date, 'complete_date', $_POST['id'], 'id');
            $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $_POST['id']);
            $where_pi = array('purchase_order.pi_id' => $_POST['id']);
            $get_PO = $this->purchase_model->get_data('purchase_order', $where_pi);
            $po_id = $get_PO[0]['id'];
            /* Quieries for PO Tables*/
            $where_pi_Data = array('purchase_order.id' => $po_id);
            $check_if_piData = $this->purchase_model->get_data('purchase_order', $where_pi_Data);
            if ($check_if_piData) {
                unset($update_data['po_or_not']);
                foreach ($get_PO as $po_val) {
                    $this->purchase_model->change_status_complete_or_not('purchase_order', $update_data, $po_val['id'], 'id');
                    $this->purchase_model->update_balance_status_chng('purchase_order', $ifBalance, 'ifbalance', $po_val['id'], 'id');
                    $this->purchase_model->update_balance_status_chng('purchase_order', $complete_Date, 'complete_date', $po_val['id'], 'id');
                    $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_order', $statusArray, 'id', $po_val['id']);
                }
            }
            /* Quieries for PO Tables*/
            /* Quieries for MRN  Tables*/
            $where_mrn_Data = array('mrn_detail.po_id' => $get_PO[0]['id']);
            $check_if_mrnData = $this->purchase_model->get_data('mrn_detail', $where_mrn_Data);
            if ($check_if_mrnData) {
                $mrn_id = $check_if_mrnData[0]['id'];
                if ($ifBalance == 0) {
                    $update_data2 = array('pay_or_not' => '1', 'ifbalance' => $ifBalance);
                    $this->purchase_model->change_status_complete_or_not('mrn_detail', $update_data2, $mrn_id, 'id');
                }
                $this->purchase_model->update_balance_status_chng('mrn_detail', $ifBalance, 'ifbalance', $mrn_id, 'id');
                $this->purchase_model->update_balance_status_chng('mrn_detail', $complete_Date, 'complete_date', $mrn_id, 'id');
                $this->data['piStatus'] = $this->purchase_model->changePiStatus('mrn_detail', $statusArray, 'id', $mrn_id);
            } else {
                $where_data = array('mrn_detail.pi_id' => $_POST['id']);
                $get_mrn_val = $this->purchase_model->get_data('mrn_detail', $where_data);
                if ($ifBalance == 0) {
                    $update_data2 = array('pay_or_not' => '1', 'ifbalance' => $ifBalance);
                    $this->purchase_model->change_status_complete_or_not('mrn_detail', $update_data2, $get_mrn_val[0]['id'], 'id');
                }
                $this->purchase_model->update_balance_status_chng('mrn_detail', $ifBalance, 'ifbalance', $get_mrn_val[0]['id'], 'id');
                $this->purchase_model->update_balance_status_chng('mrn_detail', $complete_Date, 'complete_date', $get_mrn_val[0]['id'], 'id');
                $this->data['piStatus'] = $this->purchase_model->changePiStatus('mrn_detail', $statusArray, 'id', $get_mrn_val[0]['id']);
            }
            /*******  Inventory flow *************/
            $get_PI_data = $this->purchase_model->get_data('purchase_indent', array('purchase_indent.id' => $_POST['id']));
            if (!empty($get_PI_data) && $get_PI_data[0]['material_name'] != '' && (in_array("payment", $_POST['pi_status']) && $ifBalance == 0 && in_array("po", $_POST['pi_status']) && in_array("mrn", $_POST['pi_status']))) {
                $inventoryFlowData = json_decode($get_PI_data[0]['material_name']);
                $inventoryFlowDataArray = [];
                $inCount = 0;
                foreach ($inventoryFlowData as $key => $item) {
                    $inventoryFlowDataArray['material_id'] = $item->material_name_id;
                    $inventoryFlowDataArray['material_in'] = $item->quantity;
                    $inventoryFlowDataArray['uom'] = $item->uom;
                    $inventoryFlowDataArray['through'] = 'Purchase Indent';
                    $inventoryFlowDataArray['ref_id'] = $_POST['id'];
                    $inventoryFlowDataArray['created_by'] = $_SESSION['loggedInUser']->id;
                    $inventoryFlowDataArray['created_by_cid'] = $this->companyGroupId;
                    $this->purchase_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);
                    $inCount++;
                }
            }
            /* Quieries for MRN Tables*/
            redirect(base_url() . 'purchase/purchase_indent', 'refresh');
        }
        if ($_POST['frm_pruch_ordr'] == 'Purch_order') {
            $where_pi = array('purchase_order.id' => $_POST['id']);
            $get_PO = $this->purchase_model->get_data('purchase_order', $where_pi);
            $po_id = $get_PO[0]['pi_id'];
            /* Quieries for PI Tables*/
            $where_pi_Data = array('purchase_indent.id' => $po_id);
            $check_if_piData = $this->purchase_model->get_data('purchase_indent', $where_pi_Data);
            if ($check_if_piData) {
                $this->purchase_model->change_status_complete_or_not('purchase_indent', $update_data, $po_id, 'id');
                $this->purchase_model->update_balance_status_chng('purchase_indent', $ifBalance, 'ifbalance', $po_id, 'id');
                $this->purchase_model->update_balance_status_chng('purchase_indent', $complete_Date, 'complete_date', $po_id, 'id');
                $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $po_id);
            }
            /* Quieries for PI Tables*/
            /* Quieries for MRN  Tables*/
            $where_mrn_Data = array('mrn_detail.po_id' => $get_PO[0]['id']);
            $check_if_mrnData = $this->purchase_model->get_data('mrn_detail', $where_mrn_Data);
            if ($check_if_mrnData) {
                $mrn_id = $check_if_mrnData[0]['id'];
                if ($ifBalance == 0) {
                    $update_data21 = array('pay_or_not' => '1', 'ifbalance' => $ifBalance);
                    $this->purchase_model->change_status_complete_or_not('mrn_detail', $update_data21, $mrn_id, 'id');
                }
                $this->purchase_model->update_balance_status_chng('mrn_detail', $ifBalance, 'ifbalance', $mrn_id, 'id');
                $this->purchase_model->update_balance_status_chng('mrn_detail', $complete_Date, 'complete_date', $mrn_id, 'id');
                $this->data['piStatus'] = $this->purchase_model->changePiStatus('mrn_detail', $statusArray, 'id', $mrn_id);
            }
            /* Quieries for MRN Tables*/
            /* Quieries for PO Tables*/
            unset($update_data['po_or_not']);
            $this->purchase_model->change_status_complete_or_not('purchase_order', $update_data, $_POST['id'], 'id');
            $this->purchase_model->update_balance_status_chng('purchase_order', $ifBalance, 'ifbalance', $_POST['id'], 'id');
            $this->purchase_model->update_balance_status_chng('purchase_order', $complete_Date, 'complete_date', $_POST['id'], 'id');
            $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_order', $statusArray, 'id', $_POST['id']);
            /*******  Inventory flow *************/
            // if (!empty($get_PO) && $get_PO[0]['material_name'] != '' && in_array("po", $_POST['pi_status']) && in_array("payment", $_POST['pi_status']) && in_array("mrn", $_POST['pi_status']) && in_array("complete", $_POST['pi_status']) && $ifBalance == 0) {
            //     $inventoryFlowPOData = json_decode($get_PO[0]['material_name']);
            //     $inventoryFlowPODataArray = [];
            //     $inPOCount = 0;
            //     foreach ($inventoryFlowPOData as $key => $item) {
            //         $inventoryFlowPODataArray['material_id'] = $item->material_name_id;
            //         $inventoryFlowPODataArray['material_in'] = $item->quantity;
            //         $inventoryFlowPODataArray['uom'] = $item->uom;
            //         $inventoryFlowPODataArray['through'] = 'Purchase Order';
            //         $inventoryFlowPODataArray['ref_id'] = $_POST['id'];
            //         $inventoryFlowPODataArray['created_by'] = $_SESSION['loggedInUser']->id;
            //         $inventoryFlowPODataArray['created_by_cid'] = $this->companyGroupId;
            //         $this->purchase_model->insert_tbl_data('inventory_flow', $inventoryFlowPODataArray);
            //         $inPOCount++;
            //     }
            // }
            /* Quieries for PO Tables*/
            redirect(base_url() . 'purchase/purchase_order', 'refresh');
        }
    }
    public function oldsaveStatusPI() {
        $getPoId = getSingleAndWhere('po_id','mrn_detail',['id' => $_POST['id']]);
        $getPiId = getSingleAndWhere('pi_id','mrn_detail',['id' => $_POST['id']]);
        if ($_POST['check_payment_complete'] == 'complete_payment') {
            $ifBalance = 0; //Payment Complete
            date_default_timezone_set('Asia/Kolkata');
            $complete_Date = date('Y-m-d H:i');
        } else {
            $ifBalance = 1; //Payment Not Complete

        }
        $piArray = array();
        if (array_key_exists("0", $_POST['pi_status'])) $piArray['PO'] = array('name' => 'PO', 'po_or_verbal' => $_POST['po_or_verbal'], 'po_code' => $_POST['po_code']);
        if (array_key_exists("1", $_POST['pi_status'])) $piArray['MRN'] = array('name' => 'MRN', 'mrn_or_without_form' => $_POST['mrn_or_without_form'], 'mrn_code' => $_POST['mrn_code'], 'invoice_no' => $_POST['invoice_no'], 'invoice_date' => $_POST['invoice_date']);
        if (in_array("payment", $_POST['pi_status'])) {
            $piArray['Payment'] = array();
            $piPreviousPaymentData = array();
            $paymentData = $_POST['amount'] != '' ? array('name' => 'Payment', 'amount' => $_POST['amount'], 'balance' => $ifBalance, 'required_date' => $_POST['required_date'], 'description' => $_POST['description']) : array();
            $piArray['Payment'][0] = $paymentData;
            //For Previous added Data
            if ($_POST['previousPaymentData'] != '' && $_POST['indent_grand_totl'] != 0 && $_POST['amount'] != '') {
                $piPreviousPaymentData = json_decode($_POST['previousPaymentData']);
                $i = $piArray['Payment'][0] == array() ? 0 : 1;
                foreach ($piPreviousPaymentData as $paymentVal) {
                    $piArray['Payment'][$i] = $paymentVal;
                    $i++;
                }
            } elseif ($_POST['indent_grand_totl'] != 0 && $_POST['amount'] == '') { //New Data
                $j = 0;
                foreach ($_POST['edit_amount'] as $new_amt) {
                    $jsonArrayObject = array('name' => 'Payment', 'amount' => $new_amt, 'balance' => $ifBalance[$j], 'required_date' => $_POST['edit_required_date'][$j], 'description' => $_POST['edit_description'][$j]);
                    $piArray['Payment'][$j] = $jsonArrayObject;
                    $j++;
                }
            } else {
                $j = 0;
                foreach ($_POST['edit_amount'] as $new_amt) { //For Edited Data
                    $jsonArrayObject = array('name' => 'Payment', 'amount' => $new_amt, 'balance' => $ifBalance[$j], 'required_date' => $_POST['edit_required_date'][$j], 'description' => $_POST['edit_description'][$j]);
                    $piArray['Payment'][$j] = $jsonArrayObject;
                    $j++;
                }
            }
        }
        if (in_array("po", $_POST['pi_status']) && in_array("payment", $_POST['pi_status']) && in_array("mrn", $_POST['pi_status']) && in_array("complete", $_POST['pi_status']) && $ifBalance != 0) {
            $piArray['Complete'] = array('name' => 'Complete', 'value' => 1);
            $update_data = array('mrn_or_not' => '1', 'po_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("po", $_POST['pi_status']) && in_array("payment", $_POST['pi_status']) && in_array("mrn", $_POST['pi_status']) && in_array("complete", $_POST['pi_status']) && $ifBalance == 0) {
            $piArray['Complete'] = array('name' => 'Complete', 'value' => 1);
            $update_data = array('pay_or_not' => '1', 'mrn_or_not' => '1', 'po_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("po", $_POST['pi_status']) && in_array("payment", $_POST['pi_status']) && $ifBalance == 0 && in_array("complete", $_POST['pi_status'])) {
            $update_data = array('pay_or_not' => '1', 'po_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("mrn", $_POST['pi_status']) && in_array("payment", $_POST['pi_status']) && $ifBalance == 0 && in_array("complete", $_POST['pi_status'])) {
            $update_data = array('pay_or_not' => '1', 'mrn_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance == 0 && in_array("complete", $_POST['pi_status'])) {
            $update_data = array('pay_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance != 0 && in_array("mrn", $_POST['pi_status']) && in_array("po", $_POST['pi_status'])) {
            $update_data = array('mrn_or_not' => '1', 'po_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance != 0 && in_array("mrn", $_POST['pi_status'])) {
            $update_data = array('mrn_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance != 0 && in_array("po", $_POST['pi_status'])) {
            $update_data = array('po_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance == 0 && in_array("po", $_POST['pi_status']) && in_array("mrn", $_POST['pi_status'])) {
            $piArray['Complete'] = array('name' => 'Complete', 'value' => 1);
            $update_data = array('po_or_not' => '1', 'mrn_or_not' => '1', 'pay_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance == 0 && !in_array("po", $_POST['pi_status'])) {
            $update_data = array('pay_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance == 0 && in_array("po", $_POST['pi_status'])) {
            $update_data = array('po_or_not' => '1', 'pay_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("mrn", $_POST['pi_status']) && in_array("po", $_POST['pi_status'])) {
            $update_data = array('mrn_or_not' => '1', 'po_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (!in_array("payment", $_POST['pi_status']) && $ifBalance != 0 && in_array("po", $_POST['pi_status'])) {
            $update_data = array('po_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (!in_array("payment", $_POST['pi_status']) && $ifBalance != 0 && in_array("mrn", $_POST['pi_status'])) {
            $update_data = array('mrn_or_not' => '1', 'ifbalance' => $ifBalance);
        } elseif (in_array("payment", $_POST['pi_status']) && $ifBalance != 0) {
            $update_data = array('ifbalance' => $ifBalance);
        }
        $piJsonArray = JSON_encode($piArray);
        $statusArray = array('status' => $piJsonArray);
        if ($_POST['frm_mrn_data'] == 'mrn_Data') { //Conditions for MRN Module
            $where_pi = array('mrn_detail.id' => $_POST['id']);
            $get_mrn_Data_Start = $this->purchase_model->get_data('mrn_detail', $where_pi);
            /*Quieries for Purchase order Table*/
            if ($get_mrn_Data_Start[0]['pi_id'] != 0) {
                /*$this->purchase_model->change_status_complete_or_not('purchase_indent', $update_data, $get_mrn_Data_Start[0]['pi_id'], 'id');
                $this->purchase_model->update_balance_status_chng('purchase_indent', $ifBalance, 'ifbalance', $get_mrn_Data_Start[0]['pi_id'], 'id');
                $this->purchase_model->update_balance_status_chng('purchase_indent', $complete_Date, 'complete_date', $get_mrn_Data_Start[0]['pi_id'], 'id');
                $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $get_mrn_Data_Start[0]['pi_id']);*/
                $this->purchase_model->change_status_complete_or_not('purchase_indent', $update_data, $getPiId, 'id');
                $this->purchase_model->update_balance_status_chng('purchase_indent', $ifBalance, 'ifbalance', $getPiId, 'id');
                $this->purchase_model->update_balance_status_chng('purchase_indent', $complete_Date, 'complete_date', $getPiId, 'id');
                $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $getPiId);
            }
            /*Quieries for Purchase order  Table*/
            /*Quieries for Purchase indent Table*/
            if ($get_mrn_Data_Start[0]['po_id'] != 0) {
                unset($update_data['po_or_not']);
                $this->purchase_model->change_status_complete_or_not('purchase_order', $update_data, $getPoId, 'id');
                $this->purchase_model->update_balance_status_chng('purchase_order', $ifBalance, 'ifbalance', $getPoId, 'id');
                $this->purchase_model->update_balance_status_chng('purchase_order', $complete_Date, 'complete_date', $getPoId, 'id');
                $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_order', $statusArray, 'id', $get_mrn_Data_Start[0]['po_id']);
                $where_pi_Data = array('purchase_order.id' => $getPoId);
                $get_PO_Data = $this->purchase_model->get_data('purchase_order', $where_pi_Data);
                if ($get_PO_Data[0]['pi_id'] != 0) {
                    $this->purchase_model->change_status_complete_or_not('purchase_indent', $update_data, $getPiId, 'id');
                    $this->purchase_model->update_balance_status_chng('purchase_indent', $ifBalance, 'ifbalance', $getPiId, 'id');
                    $this->purchase_model->update_balance_status_chng('purchase_indent', $complete_Date, 'complete_date', $getPiId, 'id');
                    $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $getPiId);
                }
            }
            if ($ifBalance == 0) {
                $update_data212 = array('pay_or_not' => '1', 'ifbalance' => $ifBalance);
                $this->purchase_model->change_status_complete_or_not('mrn_detail', $update_data212, $_POST['id'], 'id');
            }
            $this->purchase_model->update_balance_status_chng('mrn_detail', $ifBalance, 'ifbalance', $_POST['id'], 'id');
            $this->purchase_model->update_balance_status_chng('mrn_detail', $complete_Date, 'complete_date', $_POST['id'], 'id');
            $this->data['piStatus'] = $this->purchase_model->changePiStatus('mrn_detail', $statusArray, 'id', $_POST['id']);
            redirect(base_url() . 'purchase/mrn', 'refresh');
        }
        //die('here');
        if ($_POST['Purch_indent_Data'] == 'Purch_indent') { //conditions for Purchase Indent Table
            $this->purchase_model->change_status_complete_or_not('purchase_indent', $update_data, $getPiId, 'id');
            $this->purchase_model->update_balance_status_chng('purchase_indent', $ifBalance, 'ifbalance', $getPiId, 'id');
            $this->purchase_model->update_balance_status_chng('purchase_indent', $complete_Date, 'complete_date', $getPiId, 'id');
            $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $getPiId);
            $where_pi = array('purchase_order.pi_id' => $getPiId);
            $get_PO = $this->purchase_model->get_data('purchase_order', $where_pi);
            $po_id = $getPoId;
            /* Quieries for PO Tables*/
            $where_pi_Data = array('purchase_order.id' => $po_id);
            $check_if_piData = $this->purchase_model->get_data('purchase_order', $where_pi_Data);
            if ($check_if_piData) {
                unset($update_data['po_or_not']);
                foreach ($get_PO as $po_val) {
                    $this->purchase_model->change_status_complete_or_not('purchase_order', $update_data, $getPoId, 'id');
                    $this->purchase_model->update_balance_status_chng('purchase_order', $ifBalance, 'ifbalance', $getPoId, 'id');
                    $this->purchase_model->update_balance_status_chng('purchase_order', $complete_Date, 'complete_date', $getPoId, 'id');
                    $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_order', $statusArray, 'id', $getPoId);
                }
            }
            /* Quieries for PO Tables*/
            /* Quieries for MRN  Tables*/
            $where_mrn_Data = array('mrn_detail.po_id' => $get_PO[0]['id']);
            $check_if_mrnData = $this->purchase_model->get_data('mrn_detail', $where_mrn_Data);
            if ($check_if_mrnData) {
                $mrn_id = $check_if_mrnData[0]['id'];
                if ($ifBalance == 0) {
                    $update_data2 = array('pay_or_not' => '1', 'ifbalance' => $ifBalance);
                    $this->purchase_model->change_status_complete_or_not('mrn_detail', $update_data2, $mrn_id, 'id');
                }
                $this->purchase_model->update_balance_status_chng('mrn_detail', $ifBalance, 'ifbalance', $mrn_id, 'id');
                $this->purchase_model->update_balance_status_chng('mrn_detail', $complete_Date, 'complete_date', $mrn_id, 'id');
                $this->data['piStatus'] = $this->purchase_model->changePiStatus('mrn_detail', $statusArray, 'id', $mrn_id);
            } else {
                $where_data = array('mrn_detail.pi_id' => $_POST['id']);
                $get_mrn_val = $this->purchase_model->get_data('mrn_detail', $where_data);
                if ($ifBalance == 0) {
                    $update_data2 = array('pay_or_not' => '1', 'ifbalance' => $ifBalance);
                    $this->purchase_model->change_status_complete_or_not('mrn_detail', $update_data2, $get_mrn_val[0]['id'], 'id');
                }
                $this->purchase_model->update_balance_status_chng('mrn_detail', $ifBalance, 'ifbalance', $get_mrn_val[0]['id'], 'id');
                $this->purchase_model->update_balance_status_chng('mrn_detail', $complete_Date, 'complete_date', $get_mrn_val[0]['id'], 'id');
                $this->data['piStatus'] = $this->purchase_model->changePiStatus('mrn_detail', $statusArray, 'id', $get_mrn_val[0]['id']);
            }
            /*******  Inventory flow *************/
            $get_PI_data = $this->purchase_model->get_data('purchase_indent', array('purchase_indent.id' => $_POST['id']));
            if (!empty($get_PI_data) && $get_PI_data[0]['material_name'] != '' && (in_array("payment", $_POST['pi_status']) && $ifBalance == 0 && in_array("po", $_POST['pi_status']) && in_array("mrn", $_POST['pi_status']))) {
                $inventoryFlowData = json_decode($get_PI_data[0]['material_name']);
                $inventoryFlowDataArray = [];
                $inCount = 0;
                foreach ($inventoryFlowData as $key => $item) {
                    $inventoryFlowDataArray['material_id'] = $item->material_name_id;
                    $inventoryFlowDataArray['material_in'] = $item->quantity;
                    $inventoryFlowDataArray['uom'] = $item->uom;
                    $inventoryFlowDataArray['through'] = 'Purchase Indent';
                    $inventoryFlowDataArray['ref_id'] = $_POST['id'];
                    $inventoryFlowDataArray['created_by'] = $_SESSION['loggedInUser']->id;
                    $inventoryFlowDataArray['created_by_cid'] = $this->companyGroupId;
                    $this->purchase_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);
                    $inCount++;
                }
            }
            /* Quieries for MRN Tables*/
            redirect(base_url() . 'purchase/purchase_indent', 'refresh');
        }
        if ($_POST['frm_pruch_ordr'] == 'Purch_order') {
            $where_pi = array('purchase_order.id' => $getPoId);
            $get_PO = $this->purchase_model->get_data('purchase_order', $where_pi);
            $po_id = $getPiId;
            /* Quieries for PI Tables*/
            $where_pi_Data = array('purchase_indent.id' => $po_id);
            $check_if_piData = $this->purchase_model->get_data('purchase_indent', $where_pi_Data);
            if ($check_if_piData) {
                $this->purchase_model->change_status_complete_or_not('purchase_indent', $update_data, $po_id, 'id');
                $this->purchase_model->update_balance_status_chng('purchase_indent', $ifBalance, 'ifbalance', $po_id, 'id');
                $this->purchase_model->update_balance_status_chng('purchase_indent', $complete_Date, 'complete_date', $po_id, 'id');
                $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_indent', $statusArray, 'id', $po_id);
            }
            /* Quieries for PI Tables*/
            /* Quieries for MRN  Tables*/
            $where_mrn_Data = array('mrn_detail.po_id' => $getPiId);
            $check_if_mrnData = $this->purchase_model->get_data('mrn_detail', $where_mrn_Data);
            if ($check_if_mrnData) {
                $mrn_id = $check_if_mrnData[0]['id'];
                if ($ifBalance == 0) {
                    $update_data21 = array('pay_or_not' => '1', 'ifbalance' => $ifBalance);
                    $this->purchase_model->change_status_complete_or_not('mrn_detail', $update_data21, $mrn_id, 'id');
                }
                $this->purchase_model->update_balance_status_chng('mrn_detail', $ifBalance, 'ifbalance', $mrn_id, 'id');
                $this->purchase_model->update_balance_status_chng('mrn_detail', $complete_Date, 'complete_date', $mrn_id, 'id');
                $this->data['piStatus'] = $this->purchase_model->changePiStatus('mrn_detail', $statusArray, 'id', $mrn_id);
            }
            /* Quieries for MRN Tables*/
            /* Quieries for PO Tables*/
            unset($update_data['po_or_not']);
            $this->purchase_model->change_status_complete_or_not('purchase_order', $update_data, $getPoId, 'id');
            $this->purchase_model->update_balance_status_chng('purchase_order', $ifBalance, 'ifbalance', $getPoId, 'id');
            $this->purchase_model->update_balance_status_chng('purchase_order', $complete_Date, 'complete_date', $getPoId, 'id');
            $this->data['piStatus'] = $this->purchase_model->changePiStatus('purchase_order', $statusArray, 'id', $getPoId);
            /*******  Inventory flow *************/
            // if (!empty($get_PO) && $get_PO[0]['material_name'] != '' && in_array("po", $_POST['pi_status']) && in_array("payment", $_POST['pi_status']) && in_array("mrn", $_POST['pi_status']) && in_array("complete", $_POST['pi_status']) && $ifBalance == 0) {
            //     $inventoryFlowPOData = json_decode($get_PO[0]['material_name']);
            //     $inventoryFlowPODataArray = [];
            //     $inPOCount = 0;
            //     foreach ($inventoryFlowPOData as $key => $item) {
            //         $inventoryFlowPODataArray['material_id'] = $item->material_name_id;
            //         $inventoryFlowPODataArray['material_in'] = $item->quantity;
            //         $inventoryFlowPODataArray['uom'] = $item->uom;
            //         $inventoryFlowPODataArray['through'] = 'Purchase Order';
            //         $inventoryFlowPODataArray['ref_id'] = $_POST['id'];
            //         $inventoryFlowPODataArray['created_by'] = $_SESSION['loggedInUser']->id;
            //         $inventoryFlowPODataArray['created_by_cid'] = $this->companyGroupId;
            //         $this->purchase_model->insert_tbl_data('inventory_flow', $inventoryFlowPODataArray);
            //         $inPOCount++;
            //     }
            // }
            /* Quieries for PO Tables*/
            redirect(base_url() . 'purchase/purchase_order', 'refresh');
        }
    }
    /**
     * Convert multidimensional stdClass object(s) to array
     *
     * @param $object
     * @return array
     */
    private function objectToArray($object) {
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        if (is_array($object)) {
            return array_map(array($this, 'objectToArray'), $object);
        } else {
            return $object;
        }
    }
    public function abc() {
        $curl = curl_init();
        curl_setopt_array($curl, array(CURLOPT_URL => "https://www.knowyourgst.com/developers/gstincall/?gstin=06AAMFN3764A1ZE", CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "GET", CURLOPT_HTTPHEADER => array("passthrough: cWF6eHN3ZWRjdjE2MjQ4MTUyOTY"),));
        $response = curl_exec($curl);
        pre($response);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
    /* Share code Via Email */
    function share_pdf_using_email() {
        $share_email_address = $_REQUEST['share_email'];
        $order_id = $_REQUEST['order_id'];
        $email_message22 = $_REQUEST['email_msg_id'];
        $order_details = getNameById('purchase_order', $order_id, 'id');
        $company_details = getNameById('company_detail', $this->companyGroupId, 'id');
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
                                                    <td align="center" class="masthead" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: white; background: #099a8c; margin: 0; padding: 30px 0;     border-radius: 4px 4px 0 0;" bgcolor="#099a8c"> <img src="' . base_url() . 'assets/modules/company/uploads/' . $_SESSION['loggedInCompany']->logo . '" alt="logo" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; max-width: 20%; display: block; margin: 0 auto; padding: 0;" /></td>
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
        //$invoice_details->message_for_email
        $messageContent = $header . $email_message . $footer;
        //pre($messageContent);die();
        $order_numm = 'Order No:- ' . $order_details->order_code;
        ini_set('memory_limit', '20M');
        $this->load->library('pdf');
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle("Purchase Order");
        $pdf->SetHeaderData('Purchase Order', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
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
        $dataPdf['dataPdf'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $order_details->id);
        //pre($dataPdf);die('dfdf');
        //$dataPdf = $this->account_model->get_data_byId('invoice','id',$invoice_details->id);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->AddPage();
        // $html = $this->load->view('purchase_order/order_pdf_email', $dataPdf, true);
		$html = $this->load->view('purchase_order/email_pdf', $dataPdf, true);
        // pre($html);die();
        $pdf->WriteHTML($html);
        // $pdf->writeHTML($html, true, 0, true, 0);
        $pdf->lastPage();
        // $pdf->WriteHTML(0, $html, '', 0, 'L', true, 0, false, false, 0);
        
		$pdfFilePath = FCPATH . "assets/modules/account/pdf_invoice/order_pdf.pdf";
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
		$monthYearail->addAttachment($pdfFilePath, 'Purchase Order');
		$monthYearail->Subject = 'Purchase Order';
		#$monthYearail->ClearAllRecipients();
		
		if ($monthYearail->send()) {
            echo "sent";
            unlink($pdfFilePath);
        } else {
            echo "notsend";
        }
    }
    /* Share code Via Email */
    /****************************** Delete on Select Record ***************************/
    public function deleteall() {
        $tablename = $this->input->get_post('tablename');
        $checkValues = $this->input->get_post('checkValues');
        $datamsg = $this->input->get_post('datamsg');
        foreach ($checkValues as $key) {
            $this->purchase_model->delete_data($tablename, 'id', $key);
            logActivity($datamsg . ' Deleted', $tablename, $key);
        }
        $this->session->set_flashdata('message', $datamsg . ' Deleted Successfully');
        // redirect(base_url().'crm/leads', 'refresh');

    }
    /****************************** Delete on Select Record ***************************/
    /*******************************FAVOURITES IN PURCHASE ***************************/
    public function markfavourite() {
        $id = $this->input->get_post('checkValues');
        $tablename = $this->input->get_post('tablename');
        $favourite = $this->input->get_post('favourite');
        $datamsg = $this->input->get_post('datamsg');
        $data = (int) $favourite;
        $result = $this->purchase_model->markfavour($tablename, $data, $id);
        if ($result == true) {
            foreach ($id as $ky) {
                logActivity($datamsg . ' Records marked favourite', $tablename, $ky);
            }
            $this->session->set_flashdata('message', $datamsg . ' Favourites');
            $result = array('msg' => 'Sale order approved', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'purchase/suppliers');
            echo json_encode($result);
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    /*******************************FAVOURITES IN PURCHASE ***************************/
    /*Create Supplier Blank Excels*/
    /*Function to Import invoices*/
    function Create_suppliers_blankxls() {
        $fileName = 'Blank_suppliers' . time() . '.xls';
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'supplier_code');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'supp_account_group_id');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'address');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'mailing_name');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'state');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'country');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'city');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'gstin');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'material_type_id');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'material_name_id');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'bank_name');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'branch_name');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'account_no');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'ifsc_code');
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'other');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'pan');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        redirect(site_url() . $fileName);
        redirect(base_url() . 'account/invoices', 'refresh');
    }
    /*Function to Import invoices*/
    public function updateoldrecords() {
        $this->data['mrn_detail'] = $this->purchase_model->get_data('mrn_detail', array('created_by_cid' => $this->companyGroupId));
        foreach ($this->data['mrn_detail'] as $key) {
            $products = json_decode($key['material_name']);
            foreach ($products as $product) {
                $ww = getNameById('uom', $product->uom, 'ugc_code');
                $product->uom = $ww->id;
                $product_array = "[" . json_encode($product) . "]";
                $data['material_name'] = $product_array;
                pre($data['material_name']);
                $aa = array('id' => $key['id']);
                $this->purchase_model->updateRowWhere('mrn_detail', $aa, $data);
                //die();

            }
        }
    }
    /* Add edit page for setting purchjase budget limits in purchase settings */
    public function edit_purchase_budget_limit() {
       $id = $_POST['id'];

        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['purchase_budget'] = $this->purchase_model->get_data_byId('purchase_budget_limit', 'id', $id);
        $this->load->view('purchase_setting/set_budget', $this->data);
    }
    public function savePurchaseBudgetLimit() {
        #pre($_POST); die;
        if ($this->input->post()) {
            $required_fields = array('budget_limit');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $id = $data['id'];
                $data['created_by_cid'] = $this->companyGroupId;
                #$usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 21));
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    #pre($data); die;
                    $success = $this->purchase_model->update_data('purchase_budget_limit', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Purchase Budget limit updated successfully";
                        logActivity('Purchase Budget limit  Updated', 'machine_group', $id);
                        /*      if(!empty($usersWithViewPermissions)){
                        foreach($usersWithViewPermissions as $userViewPermission){
                        if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
                        pushNotification(array('subject'=> 'Machine Group updated' , 'message' => 'Machine Group id : #: '.$id.' is updated by '.$_SESSION['loggedInUser']->name , 'from_id'=>$_SESSION['loggedInUser']->u_id ,'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id,'icon'=>'fa fa-archive'));
                        }
                        }
                        }
                        if($_SESSION['loggedInUser']->role !=1){
                        pushNotification(array('subject'=> 'Machine Group updated' , 'message' => 'Machine Group id : #: '.$id.' is updated by '.$_SESSION['loggedInUser']->name , 'from_id'=>$_SESSION['loggedInUser']->u_id ,'to_id' =>  $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id,'icon'=>'fa fa-archive'));
                        }    */
                        $this->session->set_flashdata('message', 'Purchase Budget limit  Updated successfully');
                        redirect(base_url() . 'purchase/purchase_setting', 'refresh');
                    }
                } else {
                    $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                    $dataArray = array();
                    /* $machineGroupCount = count($_POST['budget_limit']);
                    for($i=0; $i < $machineGroupCount; $i++) {
                    $dataArray[$i] = array('budget_limit'=>  isset($_POST['budget_limit'][$i])?$_POST['budget_limit'][$i]:'', 'created_by_cid' => $this->companyGroupId );
                    } */
                    //pre($dataArray);
                    $insertedid = $this->purchase_model->insert_tbl_data('purchase_budget_limit', $data);
                    #$insertedid = $this->purchase_model->insert_multiple_data('purchase_budget_limit', $dataArray);
                    logActivity('Purchase Budget limit inserted', 'purchase_budget_limit', $id);
                    /* if(!empty($usersWithViewPermissions)){
                    foreach($usersWithViewPermissions as $userViewPermission){
                    if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
                    pushNotification(array('subject'=> 'Machine Group created' , 'message' => 'Machine group is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $data2 ,'icon'=>'fa fa-archive'));
                    }
                    }
                    }
                    if($_SESSION['loggedInUser']->role !=1){
                    pushNotification(array('subject'=> 'Machine Group created' , 'message' => 'Machine group is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' =>  $_SESSION['loggedInCompany']->u_id , 'ref_id'=> $data2 ,'icon'=>'fa fa-archive'));
                    } */
                    $this->session->set_flashdata('message', 'Purchase Budget limit inserted successfully');
                    redirect(base_url() . 'purchase/purchase_setting', 'refresh');
                }
            }
        }
    }
    /*Main fucntion of suppplier listing*/
    public function test_page() {
        $this->load->library('pagination');
        $this->load->helper('url');
        #pre($url);
        $where = array('supplier.created_by_cid' => $this->companyGroupId);
        $config = ['base_url' => base_url() . 'purchase/test_page', 'per_page' => 10, 'total_rows' => $this->purchase_model->num_rows('supplier', $where), "uri_segment" => 3, "use_page_numbers" => TRUE, 'full_tag_open' => '<ul class="pagination">', 'full_tag_close' => '</ul>', 'first_link' => '&laquo; First', 'first_tag_open' => '<li class="prev page">', 'first_tag_close' => '</li>', 'last_link' => 'Last &raquo;', 'last_tag_open' => '<li class="next page">', 'last_tag_close' => '</li>', 'next_link' => 'Next &rarr;', 'next_tag_open' => '<li class="next page">', 'next_tag_close' => '</li>', 'prev_link' => '&larr; Previous', 'prev_tag_open' => '<li class="prev page">', 'prev_tag_close' => '</li>', 'cur_tag_open' => '<li class="active"><a href="">', 'cur_tag_close' => '</a></li>', 'num_tag_open' => '<li class="page">', 'num_tag_close' => '</li>', ];
        $this->data['sort_cols'] = array('id' => 'Id', 'name' => 'name', 'material_type_id' => 'Material Type',);
        $config["uri_segment"] = 5;
        $this->data['sort_by'] = $this->uri->segment(3, 'id');
        $orderBy = $this->uri->segment(4, "desc");
        if ($orderBy == "asc") $this->data['sort_order'] = "desc";
        else $this->data['sort_order'] = "asc";
        #$config["base_url"] = base_url().'purchase/test_page/'.$this->data['sort_by'].'/'.$orderBy.'/';
        $search_string = $this->input->post('search');
        $config["base_url"] = base_url() . 'purchase/test_page/' . $this->data['sort_by'] . '/' . $orderBy . '/' . $search_string . '/';
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        if (isset($page) && is_numeric($page) && $page != 0) $page = ($page - 1) * 10;
        $data['search_string'] = '';
        if (!empty($search_string)) {
            $this->uri->segment(6, $this->uri->segment(5, 1));
            $data['search_string'] = $this->uri->segment(5, $search_string);
        } elseif ($this->uri->segment(5) != null && !empty($this->uri->segment(5)) && $this->uri->segment(6) != null) {
            $data['search_string'] = $this->uri->segment(5);
        }
        //set default page uri
        $page_uri = 5;
        if (!empty($data['search_string'])) $page_uri = 6;
        $config["uri_segment"] = $page_uri;
        $config["total_rows"] = $this->purchase_model->num_rows('supplier', $where, $data['search_string']);
        $data['page'] = $this->uri->segment($page_uri, 1);
        # $config["base_url"] = base_url().'purchase/test_page/'.$data['sort_by'].'/'.$orderBy.'/'.$data['search_string'];
        #$data["data"] = $this->employee->get_employees($config["per_page"], $offset, $data['sort_by'], $data['sort_order'], $data['search_string']);
        $this->data['search_string'] = $data['search_string'];
        #$this->data['suppliers'] = $this->purchase_model->supplier_list('supplier', $where , $config['per_page'] , $page,  $this->data['sort_by'], $orderBy);
        #$this->data['suppliers'] = $this->purchase_model->supplier_list('supplier', $where , $config['per_page'] , $data['page'],  $this->data['sort_by'], $orderBy, $data['search_string']);
        $this->data['suppliers'] = $this->purchase_model->supplier_list('supplier', $where, $config['per_page'], $page, $this->data['sort_by'], $orderBy, $data['search_string']);
        #pre($this->data['suppliers']);
        $this->pagination->initialize($config);
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Purchase', base_url() . 'purchase/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'purchase/dashboard');
        $this->breadcrumb->add('Supplier', base_url() . 'Suppliers');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Suppliers';
        $this->_render_template('suppliers/test_page', $this->data);
        /*
        if (isset($_POST['favourites']) ){
        $where = array('supplier.created_by_cid' => $this->companyGroupId , 'supplier.favourite_sts' =>1);
        $this->data['suppliers']  = $this->purchase_model->get_data('supplier',$where);
        $this->_render_template('suppliers/index', $this->data);
        }else{
        if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
        $where = array('supplier.created_by_cid' => $this->companyGroupId);
        $this->data['suppliers']  = $this->purchase_model->get_data('supplier',$where);
        $this->_render_template('suppliers/index', $this->data);
        }elseif($_POST['start'] !='' &&  $_POST['end'] !=''){
        $where = array('supplier.created_date >=' => $_POST['start'] , 'supplier.created_date <=' => $_POST['end'],'supplier.created_by_cid'=> $this->companyGroupId);
        $this->data['suppliers']  = $this->purchase_model->get_data('supplier',$where);
        $this->_render_template('suppliers/index', $this->data);
        }else{
        $where = array('supplier.created_by_cid' => $this->companyGroupId);
        $this->data['suppliers']  = $this->purchase_model->get_data('supplier',$where);
        $this->_render_template('suppliers/index', $this->data);
        }
        } */
    }
    /****************************************************/
    // Function Name: purchase_rfq
    // Created: Aman Phull
    /****************************************************/



    public function purchase_rfq() {
        $this->load->library('pagination');
        // pre($_GET); die;
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_validate'] = validate_permissions();
        $this->breadcrumb->add('Purchase', base_url() . 'purchase/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'purchase/dashboard');
        $this->breadcrumb->add('Purchase RFQ', base_url() . 'purchase_rfq');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Purchase RFQ';
        $whereMaterialType = "(created_by_cid ='".$this->companyGroupId."' OR created_by_cid =0) AND status = 1";
        $this->data['mat_type_ss']  = $this->purchase_model->get_filter_details('material_type',$whereMaterialType);
        $whereCompany = "(id ='".$this->companyGroupId."')";
        $this->data['company_unit_adress']  = $this->purchase_model->get_filter_details('company_detail',$whereCompany);
        $searchMetrialType = '"material_type_id":"'.$_GET['material_type'].'"';

      // pre($_GET);die();
         if (isset($_GET['favourites'])){
                    $whereInProcess = "(pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' AND approve ='1' AND save_status = '1'  AND po_or_not = '0') AND purchase_indent.created_by_cid = '".$this->companyGroupId."' AND purchase_indent.favourite_sts = '1'";

                    $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1 , 'purchase_indent.favourite_sts' => 1);

         }
        if($_GET['dashboard'] == 'dashboard' && $_GET['start'] != '' && $_GET['end'] != ''){
            if($_GET['label'] == 'Approved'){
                //pre($_GET);die();
                $whereInProcess = " purchase_indent.created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND ( purchase_indent.approve ='1')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);

            }elseif($_GET['label'] == 'Disapproved'){
                $whereInProcess = " purchase_indent.created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND ( purchase_indent.disapprove ='1')";
                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);
            }elseif($_GET['label'] == 'Pending'){
                $whereInProcess = " purchase_indent.created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND ( purchase_indent.approve ='0' AND purchase_indent.disapprove='0')";
                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);
            }elseif(isset($_GET['material_type_id']) && $_GET['material_type_id']!=''){
                $whereInProcess = " purchase_indent.created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND ( purchase_indent.material_name LIKE '%" . $searchMetrialType . "%' )";
                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1,'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%");
            }elseif($_GET['label'] == 'Complete PI' || $_GET['label'] == 'Incomplete PI'){
                $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";
                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);
            }elseif($_GET['label'] == 'Purchase Indent not converted'){
                $whereInProcess = " purchase_indent.created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND purchase_indent.save_status=1 AND purchase_indent.po_or_not=0";
                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1 ,'purchase_indent.save_status' => 1);
            }elseif($_GET['label'] == 'PoCreated'){
                $whereInProcess = " purchase_indent.created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND purchase_indent.save_status=1 AND purchase_indent.po_or_not=1";
                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1 ,'purchase_indent.save_status' => 1);
            }
        }else{
            if(!empty($_GET) && isset($_GET['start']) &&  isset($_GET['end']) && $_GET["ExportType"] =='' && $_GET["favourites"] =='' && $_GET['departments']=='' &&  $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == ''){
            $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND (purchase_indent.created_by_cid = '".$this->companyGroupId."' ) AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";
            $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);
        }elseif(!empty($_GET) && $_GET['departments']!='' &&  $_GET['material_type'] !=''&&  $_GET['status_check'] =='' &&  $_GET['company_unit'] == ''&& $_GET['start'] !='' && $_GET['end'] !='' ){
            $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%' AND  departments = '".$_GET['departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."')";
            $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.departments' => $_GET['departments'] , 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);

        }elseif(!empty($_GET) && $_GET['departments']!='' &&  $_GET['material_type'] !='' &&  $_GET['status_check'] =='' && $_GET['company_unit'] == '' && $_GET['start'] =='' && $_GET['end'] ==''){
            $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%' AND  departments = '".$_GET['departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) ";

            $whereComplete = array('purchase_indent.departments' => $_GET['departments'] , 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);

        }elseif(!empty($_GET) && $_GET['departments']!='' &&  $_GET['material_type'] =='' &&  $_GET['status_check'] =='' && $_GET['company_unit'] == '' && $_GET['start'] !='' && $_GET['end'] !=''){

            $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (departments = '".$_GET['departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."')";

            $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.departments' => $_GET['departments'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);


        }elseif (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['search'] == ''&& $_GET['favourites'] == '' && $_GET['status_check'] != '') {
            if($_GET['status_check'] == 'po_or_not'){
                $whereInProcess = "(purchase_indent.po_or_not ='0' AND purchase_indent.approve='1' AND purchase_indent.save_status='1' AND purchase_indent.rfq_status=1 AND purchase_indent.rfq_supp!='') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1);
            }elseif($_GET['status_check'] == 'approval_pending'){

               $whereInProcess = "purchase_indent.rfq_status ='0' AND (purchase_indent.approve='0' OR purchase_indent.approve IS NULL) AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId ,'purchase_indent.approve' =>1);
            }
            }elseif(!empty($_GET) && $_GET['departments']!='' &&  $_GET['material_type'] =='' &&  $_GET['status_check'] =='' && $_GET['company_unit'] == '' && $_GET['start'] =='' && $_GET['end'] ==''){

            $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (departments = '".$_GET[    'departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

            $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);


        }elseif(!empty($_GET) && $_GET['material_type']!=''&&  $_GET['departments']=='' &&  $_GET['status_check'] =='' && $_GET['company_unit'] == '' && $_GET['start'] !='' && $_GET['end'] !=''){

            $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."')";


            $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);

        }elseif(!empty($_GET) && $_GET['material_type']!=''&&  $_GET['departments']=='' &&  $_GET['status_check'] =='' && $_GET['company_unit'] == '' && $_GET['start'] =='' && $_GET['end'] ==''){

            $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";


            $whereComplete = array('purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);
        }
        //Start From Here Status Check
        elseif(!empty($_GET) && $_GET['status_check']!=''&&  $_GET['departments']=='' &&  $_GET['material_type']=='' && $_GET['start'] =='' && $_GET['end'] =='' && $_GET['company_unit'] =='' && isset($_GET['ExportType'])==''){//echo "8";
            if($_GET['status_check'] == 'po_or_not'){
                $whereInProcess = "(purchase_indent.po_or_not ='0' AND purchase_indent.approve='1' AND purchase_indent.save_status='1' AND purchase_indent.rfq_status=1 AND purchase_indent.rfq_supp!='') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1);
            }elseif($_GET['status_check'] == 'approval_pending'){

               $whereInProcess = "purchase_indent.rfq_status ='0' AND (purchase_indent.approve='0' OR purchase_indent.approve IS NULL) AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId ,'purchase_indent.approve' =>1);
            }

        }elseif(!empty($_GET) && $_GET['status_check']!=''&&  $_GET['departments']=='' &&  $_GET['material_type']=='' && $_GET['start'] !='' && $_GET['end'] !='' && $_GET['company_unit'] ==''){
            if($_GET['status_check'] == 'po_or_not'){
                $whereInProcess = "( purchase_indent.po_or_not ='0' AND purchase_indent.approve='1' AND purchase_indent.save_status='1' AND purchase_indent.rfq_status=1 AND purchase_indent.rfq_supp!='') AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1);
            }elseif($_GET['status_check'] == 'mrn_or_not'){
                $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not'=> 1);

            }elseif($_GET['status_check'] == 'approval_pending'){

                 $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.created_by_cid' => $this->companyGroupId ,'purchase_indent.approve' =>1);
            }

        }elseif(!empty($_GET) && $_GET['status_check']!=''&&  $_GET['departments']!='' &&  $_GET['material_type']=='' && $_GET['start'] !='' && $_GET['end'] !='' && $_GET['company_unit'] ==''){

            if($_GET['status_check'] == 'po_or_not'){

                $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND  (departments = '".$_GET['departments']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.departments' => $_GET['departments'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1);

            }elseif($_GET['status_check'] == 'mrn_or_not'){

                $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND  (departments = '".$_GET['departments']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.departments' => $_GET['departments'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not'=> 1);

            }elseif($_GET['status_check'] == 'approval_pending'){
                $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND  (departments = '".$_GET['departments']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.departments' => $_GET['departments'],'purchase_indent.created_by_cid' => $this->companyGroupId,'purchase_indent.approve' =>1);

            }

        }elseif(!empty($_GET) && $_GET['status_check']!=''&&  $_GET['departments']!='' &&  $_GET['material_type']=='' && $_GET['start'] =='' && $_GET['end'] =='' && $_GET['company_unit'] ==''){

            if($_GET['status_check'] == 'po_or_not'){

                $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (departments = '".$_GET['departments']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1);

            }elseif($_GET['status_check'] == 'mrn_or_not'){

                $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (departments = '".$_GET['departments']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not'=> 1);

            }elseif($_GET['status_check'] == 'approval_pending'){
                $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (departments = '".$_GET['departments']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.created_by_cid' => $this->companyGroupId,'purchase_indent.approve' =>1);

            }

        }elseif(!empty($_GET) && $_GET['status_check']!='' &&  $_GET['material_type']!='' &&  $_GET['departments'] =='' && $_GET['start'] !='' && $_GET['end'] !=''&& $_GET['company_unit'] ==''){

            if($_GET['status_check'] == 'po_or_not'){

                $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1);

            }elseif($_GET['status_check'] == 'mrn_or_not'){

                $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not'=> 1);

            }elseif($_GET['status_check'] == 'approval_pending'){

                $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid' => $this->companyGroupId,'purchase_indent.approve' =>1);
            }

        }elseif(!empty($_GET) && $_GET['status_check']!='' &&  $_GET['material_type']!='' &&  $_GET['departments'] =='' && $_GET['start'] =='' && $_GET['end'] =='' && $_GET['company_unit'] ==''){

            if($_GET['status_check'] == 'po_or_not'){

                $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1);

            }elseif($_GET['status_check'] == 'mrn_or_not'){

                $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not'=> 1);

            }elseif($_GET['status_check'] == 'approval_pending'){

                $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid' => $this->companyGroupId,'purchase_indent.approve' =>1);
            }

        }elseif(!empty($_GET) && $_GET['status_check']!='' &&  $_GET['material_type']!='' &&  $_GET['departments'] !='' && $_GET['start'] !='' && $_GET['end'] !='' && $_GET['company_unit'] !=''){

            if($_GET['status_check'] == 'po_or_not'){

                $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%')AND  (departments = '".$_GET['departments']."') AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.departments' => $_GET['departments'],'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1);

            }elseif($_GET['status_check'] == 'mrn_or_not'){

                $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND  (departments = '".$_GET['departments']."') AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.departments' => $_GET['departments'],'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not'=> 1);

            }elseif($_GET['status_check'] == 'approval_pending'){

                $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND (company_unit ='".$_GET['company_unit']."')  AND  (departments = '".$_GET['departments']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.departments' => $_GET['departments'],'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid' => $this->companyGroupId,'purchase_indent.approve' =>1);
            }

        }elseif(!empty($_GET) && $_GET['status_check']!='' &&  $_GET['material_type']!='' &&  $_GET['departments'] !='' && $_GET['start'] =='' && $_GET['end'] =='' && $_GET['company_unit'] !=''){
        //echo "12";
            if($_GET['status_check'] == 'po_or_not'){

                $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%')AND  (departments = '".$_GET['departments']."') AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1);

            }elseif($_GET['status_check'] == 'mrn_or_not'){

                $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND  (departments = '".$_GET['departments']."') AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not'=> 1);

            }elseif($_GET['status_check'] == 'approval_pending'){

                $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND (company_unit ='".$_GET['company_unit']."') AND  (departments = '".$_GET['departments']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId,'purchase_indent.approve' =>1);
            }

        }elseif(!empty($_GET) && $_GET['status_check']!='' &&  $_GET['material_type']=='' &&  $_GET['departments'] =='' && $_GET['start'] =='' && $_GET['end'] =='' && $_GET['company_unit'] !=''){

            if($_GET['status_check'] == 'po_or_not'){

                $whereInProcess = "( purchase_indent.po_or_not ='0')  AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1);

            }elseif($_GET['status_check'] == 'mrn_or_not'){

                $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not'=> 1);

            }elseif($_GET['status_check'] == 'approval_pending'){

                $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL )  AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId,'purchase_indent.approve' =>1);
            }

        }elseif(!empty($_GET) && $_GET['status_check']!='' &&  $_GET['material_type']=='' &&  $_GET['departments'] =='' && $_GET['start'] !='' && $_GET['end'] !='' && $_GET['company_unit'] !=''){

            if($_GET['status_check'] == 'po_or_not'){

                $whereInProcess = "( purchase_indent.po_or_not ='0')  AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1);

            }elseif($_GET['status_check'] == 'mrn_or_not'){

                $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not'=> 1);

            }elseif($_GET['status_check'] == 'approval_pending'){

                $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL )  AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."')AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId,'purchase_indent.approve' =>1);
            }

        }elseif(!empty($_GET) && $_GET['status_check']!='' &&  $_GET['material_type']=='' &&  $_GET['departments'] !='' && $_GET['start'] !='' && $_GET['end'] !='' && $_GET['company_unit'] !=''){

            if($_GET['status_check'] == 'po_or_not'){

                $whereInProcess = "( purchase_indent.po_or_not ='0')  AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND  (departments = '".$_GET['departments']."')AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1);

            }elseif($_GET['status_check'] == 'mrn_or_not'){

                $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND  (departments = '".$_GET['departments']."') AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not'=> 1);

            }elseif($_GET['status_check'] == 'approval_pending'){

                $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL )  AND  (purchase_indent.created_date >='".$_GET['start']."' AND  (departments = '".$_GET['departments']."') AND  purchase_indent.created_date <='".$_GET['end']."')AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId,'purchase_indent.approve' =>1);
            }

        }elseif(!empty($_GET) && $_GET['status_check']!='' &&  $_GET['material_type']=='' &&  $_GET['departments'] !='' && $_GET['start'] =='' && $_GET['end'] =='' && $_GET['company_unit'] !=''){
        //echo "dddd";
            if($_GET['status_check'] == 'po_or_not'){

                $whereInProcess = "( purchase_indent.po_or_not ='0')   AND  (departments = '".$_GET['departments']."')AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1);

            }elseif($_GET['status_check'] == 'mrn_or_not'){

                $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND  (departments = '".$_GET['departments']."') AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not'=> 1);

            }elseif($_GET['status_check'] == 'approval_pending'){

                $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL )   AND  (departments = '".$_GET['departments']."') AND (company_unit ='".$_GET['company_unit']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.company_unit' => $_GET['company_unit'],'purchase_indent.created_by_cid' => $this->companyGroupId,'purchase_indent.approve' =>1);
            }

        }elseif(!empty($_GET) && $_GET['status_check']!='' &&  $_GET['material_type']!='' &&  $_GET['departments'] !='' && $_GET['start'] =='' && $_GET['end'] =='' && $_GET['company_unit'] ==''){

            if($_GET['status_check'] == 'po_or_not'){

                $whereInProcess = "( purchase_indent.po_or_not ='0')  AND  (departments = '".$_GET['departments']."') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1);

            }elseif($_GET['status_check'] == 'mrn_or_not'){

                $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND  (departments = '".$_GET['departments']."') AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not'=> 1);

            }elseif($_GET['status_check'] == 'approval_pending'){

                $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%')  AND  (departments = '".$_GET['departments']."') AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid' => $this->companyGroupId,'purchase_indent.approve' =>1);
            }

        }
        //END Here Status Check
        // start here company unit code///
        elseif(!empty($_GET) && $_GET['departments']=='' &&  $_GET['material_type'] ==''&&  $_GET['status_check'] =='' &&  $_GET['company_unit'] != ''&& $_GET['start'] =='' && $_GET['end'] =='' ){

            $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_GET['company_unit']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

            $whereComplete = array('purchase_indent.company_unit ' => $_GET['company_unit'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);

        }elseif(!empty($_GET) && $_GET['departments']=='' &&  $_GET['material_type'] ==''&&  $_GET['status_check'] =='' &&  $_GET['company_unit'] != ''&& $_GET['start'] !='' && $_GET['end'] !='' ){

            $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_GET['company_unit']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."')";

            $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit ' => $_GET['company_unit'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);

        }elseif(!empty($_GET) && $_GET['departments']!='' &&  $_GET['material_type'] ==''&&  $_GET['status_check'] =='' &&  $_GET['company_unit'] != ''&& $_GET['start'] =='' && $_GET['end'] =='' ){

            $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_GET['company_unit']."') AND  (departments ='".$_GET['departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

            $whereComplete = array('purchase_indent.company_unit ' => $_GET['company_unit'],'purchase_indent.departments ' => $_GET['departments'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);

        }elseif(!empty($_GET) && $_GET['departments']!='' &&  $_GET['material_type'] ==''&&  $_GET['status_check'] =='' &&  $_GET['company_unit'] != ''&& $_GET['start'] !='' && $_GET['end'] !='' ){

            $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_GET['company_unit']."') AND (departments ='".$_GET['departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."')";

            $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit ' => $_GET['company_unit'],'purchase_indent.created_by_cid'=> $this->companyGroupId, 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1,'purchase_indent.departments ' => $_GET['departments']);

        }elseif(!empty($_GET) && $_GET['departments']=='' &&  $_GET['material_type'] !=''&&  $_GET['status_check'] =='' &&  $_GET['company_unit'] != ''&& $_GET['start'] !='' && $_GET['end'] !='' ){

            $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_GET['company_unit']."') AND (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."')";

            $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1,'purchase_indent.company_unit ' => $_GET['company_unit']);

        }elseif(!empty($_GET) && $_GET['departments']=='' &&  $_GET['material_type'] !=''&&  $_GET['status_check'] =='' &&  $_GET['company_unit'] != ''&& $_GET['start'] =='' && $_GET['end'] =='' ){

            $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_GET['company_unit']."') AND (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

            $whereComplete = array('purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1,'purchase_indent.company_unit ' => $_GET['company_unit']);

        }elseif(!empty($_GET) && $_GET['departments']!='' &&  $_GET['material_type'] !=''&&  $_GET['status_check'] =='' &&  $_GET['company_unit'] != ''&& $_GET['start'] =='' && $_GET['end'] =='' ){

            $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_GET['company_unit']."') AND (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND (departments ='".$_GET['departments']."')AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

            $whereComplete = array('purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.departments ' => $_GET['departments'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1,'purchase_indent.company_unit ' => $_GET['company_unit']);

        }elseif(!empty($_GET) && $_GET['departments']!='' &&  $_GET['material_type'] !=''&&  $_GET['status_check'] =='' &&  $_GET['company_unit'] != ''&& $_GET['start'] !='' && $_GET['end'] !='' ){

            $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (company_unit ='".$_GET['company_unit']."') AND (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND (departments ='".$_GET['departments']."')AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."')";

            $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.departments ' => $_GET['departments'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1,'purchase_indent.company_unit ' => $_GET['company_unit']);

        }
        elseif(empty($_GET['tab'])){
        $whereInProcess = "( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";
        $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);
        }
        elseif(!empty($_GET['search'])){


            /*$materialName=getNameById('material',$_GET['search'],'material_name');


            $material_type_tt = getNameById('material_type',$_GET['search'],'name');*/


            //die('555');

          /*  if($materialName->id == '' && $material_type_tt->id ==''){
                $wheresearch = "CONCAT(purchase_indent.id, purchase_indent.indent_code) like '%" . $_GET['search'] . "%'";
            }elseif($materialName->id != '' && $material_type_tt->id ==''){
                $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                $wheresearch = "json_contains(`material_name`, '".$json_dtl."')" ;
            }elseif($material_type_tt->id !=''){
                 $wheresearch = "CONCAT(purchase_indent.material_type_id) like '" . $material_type_tt->id . "'";
            }
            $whereComplete = array($wheresearch,'purchase_indent.created_by_cid' =>$this->companyGroupId);

            $whereInProcess = " ".$wheresearch." AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'"; */


            //$whereComplete =array("created_by_cid"=>$this->companyGroupId);

            //$whereInProcess = "created_by_cid = ".$this->companyGroupId."  AND ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";
        }
        elseif($_GET['tab'] == 'complete'){
            $whereInProcess = "( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

            $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);
        }
        elseif($_GET['tab'] == 'inprocess'){

            $whereInProcess = "( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) AND purchase_indent.created_by_cid = '".$this->companyGroupId."'";

            $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);
        }

        if(isset($_GET["ExportType"]) && $_GET["favourites"]=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['search'] == '' && $_GET['status_check']== '' && $_GET['company_unit'] == '') {

             if($_GET['tab'] == 'complete'){
                 $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
              }else {

                 $whereInProcess = "( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' AND purchase_indent.mrn_or_not = '0' ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                 //pre($whereInProcess);die();
              }
        }elseif(isset($_GET["ExportType"]) && $_GET["favourites"]=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] != '' && $_GET['material_type'] == ''  && $_GET['search'] == '' && $_GET['status_check']== '' && $_GET['company_unit'] == '') {

            $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (departments = '".$_GET['departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

            $whereComplete = array('purchase_indent.departments' => $_GET['departments'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);
        }else if ($_GET['start'] == '' && $_GET['end'] == '' && $_GET["ExportType"]=='' && $_GET["favourites"] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '') {

                    $whereInProcess = "(pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' AND approve ='1' AND save_status = '1'  AND po_or_not = '0') AND purchase_indent.created_by_cid = '".$this->companyGroupId."' AND purchase_indent.favourite_sts = '1'";

                    $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1 , 'purchase_indent.favourite_sts' => 1);

            } elseif ($_GET['start'] == '' && $_GET['end'] == ''  && $_GET["ExportType"]!='' && $_GET["favourites"] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '') {
                $whereInProcess = "(pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' AND approve ='1' AND save_status = '1'  AND po_or_not = '0') AND purchase_indent.created_by_cid = '".$this->companyGroupId."' AND purchase_indent.favourite_sts = '1'";

                    $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1 , 'purchase_indent.favourite_sts' => 1);
            }elseif(isset($_GET["ExportType"]) && $_GET["favourites"]=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] != ''  && $_GET['search'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '') {

            $whereInProcess =  "created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

            $whereComplete = array('purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);

        }elseif(isset($_GET["ExportType"]) && $_GET["favourites"]=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] != '' && $_GET['material_type'] != ''  && $_GET['search'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '') {

            $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.material_name LIKE '%" . $searchMetrialType . "%' AND  departments = '".$_GET['departments']."') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

            $whereComplete = array('purchase_indent.departments' => $_GET['departments'] , 'purchase_indent.material_name LIKE' => "%{$searchMetrialType}%",'purchase_indent.created_by_cid'=> $this->companyGroupId, 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);

        }elseif(isset($_GET["ExportType"]) && $_GET["favourites"]=='' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['search'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '') {
            $whereInProcess = "created_by_cid = ".$this->companyGroupId." AND  (purchase_indent.created_date >='".$_GET['start']."' AND  purchase_indent.created_date <='".$_GET['end']."') AND (purchase_indent.created_by_cid = '".$this->companyGroupId."' ) AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";


            $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'] , 'purchase_indent.created_date <=' => $_GET['end'],'purchase_indent.created_by_cid'=> $this->companyGroupId , 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1);

        }elseif(isset($_GET["ExportType"]) && $_GET["favourites"]=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] == ''  && $_GET['search'] !='' && $_GET['status_check'] == '' && $_GET['company_unit'] == '') {


            $materialName=getNameById('material',$_GET['search'],'material_name');
            $material_type_tt = getNameById('material_type',$_GET['search'],'name');

            /*if($materialName->id == '' && $material_type_tt->id ==''){
                $wheresearch = "CONCAT(purchase_indent.id, purchase_indent.indent_code) like '%" . $_GET['search'] . "%'";
            }elseif($materialName->id != '' && $material_type_tt->id ==''){
                $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                $wheresearch = "json_contains(`material_name`, '".$json_dtl."')" ;
            }elseif($material_type_tt->id !=''){
                $wheresearch = "CONCAT(purchase_indent.material_type_id) like '%" . $material_type_tt->id . "%'";
            }*/

            $s = $_GET['search'];
            $wheresearch = " purchase_indent.id LIKE '%{$s}%' OR purchase_indent.indent_code LIKE '%{$s}%' ";

            // $whereInProcess = "created_by_cid = ".$this->companyGroupId."  AND ".$wheresearch." AND ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )";

            // $whereComplete = array('purchase_indent.created_by_cid'=> $this->companyGroupId, 'purchase_indent.po_or_not'=> 1,'purchase_indent.mrn_or_not'=> 1,'purchase_indent.pay_or_not'=> 1,$wheresearch);

            $whereComplete = array($wheresearch,'purchase_indent.created_by_cid' =>$this->companyGroupId);
            $whereInProcess = " ".$wheresearch." AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

            // pre($whereInProcess);


            // die();

        }

        }

        $where2 = '';
          $search_string = '';
        if (!empty($_POST['search'])) {
                $search_string=$_POST['search'];
                $materialName=getNameById('material',$search_string,'material_name');
                $material_type_tt = getNameById('material_type',$search_string,'name');
            /*if($materialName->id == '' && $material_type_tt->id ==''){
                $where2 = "CONCAT(purchase_indent.id, purchase_indent.indent_code) = '" . $search_string. "'";
            }elseif($materialName->id != '' && $material_type_tt->id ==''){
                $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                $where2 = "json_contains(`material_name`, '".$json_dtl."')" ;
            }elseif($material_type_tt->id !=''){
                $where2 = "CONCAT(purchase_indent.material_type_id) = '" . $material_type_tt->id . "'";
            }*/
            $s = $_GET['search'];
            $where2 = " purchase_indent.id LIKE '%{$s}%' OR purchase_indent.indent_code LIKE '%{$s}%' ";
                redirect("purchase/purchase_rfq/?search=$search_string");
        }else if($_GET['search'] != ''){
            /*$materialName=getNameById('material',$_GET['search'],'material_name');
            $material_type_tt = getNameById('material_type',$_GET['search'],'name');
            if($materialName->id == '' && $material_type_tt->id ==''){
                $where2 = " purchase_indent.id LIKE '%{$_GET['search']}%'  OR  purchase_indent.indent_code LIKE '%{$_GET['search']}%'";
                $where2 = "CONCAT(purchase_indent.id, purchase_indent.indent_code) ='" . $_GET['search'] ."'";
            }elseif($materialName->id != '' && $material_type_tt->id ==''){
                $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                $where2 = "json_contains(`material_name`, '".$json_dtl."')" ;
            }elseif($material_type_tt->id !=''){
                $where2 = "CONCAT(purchase_indent.material_type_id) = '" . $material_type_tt->id . "'";
            }*/
            $s = $_GET['search'];
            $where2 = " purchase_indent.id LIKE '%{$s}%' OR purchase_indent.indent_code LIKE '%{$s}%' ";
        }

        if(!empty($_GET['order'])) {
            $order = $_GET['order'];
        }else{
            $order ='desc';
        }

        if( !empty($_GET['purchase_type']) ){
            if( $_GET['purchase_type'] == 2 ){
                $_GET['purchase_type'] = 0;
            }
            if( $whereInProcess ){
              $whereInProcess  = str_replace("AND  (purchase_indent.created_date >='' AND  purchase_indent.created_date <='')", "",$whereInProcess);
              $whereInProcess .= " AND purchase_indent.purchase_type = {$_GET['purchase_type']}";
            }
            if( $whereComplete ){
                foreach ($whereComplete as $key => $value) {
                    if( !empty($whereComplete[$key]) ){
                        $whereComplete[$key] = $value;
                    }else{
                        unset($whereComplete[$key]);
                    }
                }
                $whereComplete = array_merge($whereComplete,['purchase_indent.purchase_type' => $_GET['purchase_type'] ]);
            }
        }

        if($_GET['tab']=='complete'){
            $rows=$this->purchase_model->tot_rows('purchase_indent', $whereComplete, $where2);
        }elseif($_GET['tab']=='inprocess'){
            $rows=$this->purchase_model->tot_rows('purchase_indent', $whereInProcess, $where2);
        }else{
            $rows=$this->purchase_model->tot_rows('purchase_indent', $whereInProcess, $where2);
        }

        $config = array();
        $config["base_url"] = base_url() . "purchase/purchase_rfq";
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
          if(!empty($_GET['ExportType'])){
                $export_data = 1;
            }else{
                $export_data = 0;
            }

        if($_GET['tab']=='complete' && $_GET['tab']!='inprocess'){
            $this->data['indent'] = $this->purchase_model->get_data_listing('purchase_indent', $whereComplete, $config["per_page"], $page, $where2, $order,$export_data);
        }
        elseif($_GET['tab']=='inprocess' && $_GET['tab']!='complete'){
             $this->data['purchase_indent_inProcess'] = $this->purchase_model->get_data_listing('purchase_indent', $whereInProcess, $config["per_page"], $page, $where2, $order,$export_data);
        }
        else{
            $this->data['indent'] = $this->purchase_model->get_data_listing('purchase_indent', $whereComplete, $config["per_page"], $page, $where2, $order,$export_data);
         $this->data['purchase_indent_inProcess'] = $this->purchase_model->get_data_listing('purchase_indent', $whereInProcess, $config["per_page"], $page, $where2, $order,$export_data);
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

        //$rfqData = [];
        foreach ($this->data['purchase_indent_inProcess'] as $key => $value) {
                $materialData = json_decode($value['material_name']);
                $data = $this->data['rfq_indent'] = $this->purchase_model->getDataByWhereId('purchase_rfq',['product_induction_id' => $value['id'],'selected_status' => 1],['product_id','product_induction_id']);
            if( $data ){
                $rfqData[] = $data;
            }
        }

        $this->data['rfqMaterial'] = convertDataArray($rfqData);



        $this->_render_template('rfq_details/index', $this->data);
    }

    public function rfq_details_edit() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $data_get_for_docss = array('purchase_indent.id' => $id, 'purchase_indent.save_status' => 1);
        $docs_data = $this->purchase_model->get_data('purchase_indent', $data_get_for_docss);
        if ($docs_data[0]['pi_id'] != 0) {
            $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $docs_data[0]['pi_id']); //For Document Attachment fetch

        } else {
            $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $id); //For Document Attachment fetch

        }
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['indents'] = $this->purchase_model->get_data_byId('purchase_indent', 'id', $id);
        if (!empty($this->data['indents'])) $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material', 'material_type_id', $this->data['indents']->material_type_id);
        $this->load->view('rfq_details/edit', $this->data);
    }
        /*function to view data*/
    public function rfq_view() {

        $id = $_POST['id'];
        permissions_redirect('is_view');
        $this->data['suppliername'] = $this->purchase_model->get_data('supplier');
        $this->data['materialType'] = $this->purchase_model->get_data('material_type');
        $this->data['indents'] = $this->purchase_model->get_data_byId('purchase_indent', 'id', $id);
        $this->data['docss'] = $this->purchase_model->get_docs_in_PI_PO_MRN('attachments', 'rel_id', $id);
        /*if(!empty($this->data['indents']))
         $this->data['materials'] = $this->purchase_model->get_tbl_data_byId('material' ,'material_type', $this->data['indents']->material_type);*/
        //Code For Change Status*/
        $this->data['indents'] = $this->purchase_model->get_data_byId('purchase_indent', 'id', $id);
        $wherePo = array('purchase_order.pi_id' => $id, 'purchase_order.save_status' => 1);
        $this->data['po'] = $this->purchase_model->get_data('purchase_order', $wherePo);
        $get_po_or_pi_id = array('purchase_order.pi_id' => $id, 'purchase_order.save_status' => 1);
        $get_po_data = $this->purchase_model->get_data('purchase_order', $get_po_or_pi_id);
        if (!empty($get_po_data)) {
            $whereMrn = array('mrn_detail.po_id' => $get_po_data[0]['id'], 'mrn_detail.save_status' => 1);
        } else {
            $whereMrn = array('mrn_detail.pi_id' => $id, 'mrn_detail.save_status' => 1);
        }
        $this->data['mrn'] = $this->purchase_model->get_data('mrn_detail', $whereMrn);
        //Code For Change Status*/
        $this->load->view('rfq_details/view', $this->data);
    }
    /*  Function to save/update Account */
     public function saveRfq() {

        if ($this->input->post()) {
            //pre($_POST);die();
            $required_fields = array('rfq_supp');

            $is_valid = validate_fields($_POST, $required_fields);

            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $purchaseIndentId = $this->input->post('id');
               // $usersWithViewPermissions = $this->purchase_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));

                if ($purchaseIndentId && $purchaseIndentId != '') {
                     $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                     $purchase_indent = $this->purchase_model->get_data_byId('purchase_indent','id',$purchaseIndentId);
                     $arry_rfq = array();
                    // pre( $purchase_indent->rfq_supp);
                     if($purchase_indent->rfq_supp == 'null' || empty($purchase_indent->rfq_supp)){
                         $data['rfq_supp'] = json_encode($this->input->post('rfq_supp'));
                     }else{
                         $data['rfq_supp'] = json_encode(array_merge(json_decode($purchase_indent->rfq_supp),$this->input->post('rfq_supp')));
                     }
                     $success = $this->purchase_model->update_single_field('purchase_indent', $data, 'id', $purchaseIndentId);
                    if ($this->share_pdf_Rfq($purchaseIndentId,$this->input->post('rfq_supp'),$this->input->post('delivery_date'))) {
                        /* update cost price of material to fetch last cost price of material  */

                        if ($data['preffered_supplier'] != "") updateUsedIdStatus('supplier', $data['preffered_supplier']);
                        $data['message'] = "Purchase indent updated successfully";
                        logActivity('purchase indent Updated', 'purchase_indent', $purchaseIndentId);
                        $this->session->set_flashdata('message', 'RFQ Email Send To Selected Supplier successfully');

                    }else{
                         $this->session->set_flashdata('message', 'RFQ Email not Sent');
                    }
                }

                redirect(base_url() . 'purchase/purchase_rfq', 'refresh');
            }
        }
    }

    function share_pdf_Rfq($purchaseIndentId,$rfq_supp_ids,$expected_deliv_date){

        $order_details = getNameById('purchase_indent', $purchaseIndentId, 'id');
        $company_data = getNameById('company_detail', $this->companyGroupId, 'id');
        $company_emails = getNameById('user', $order_details->created_by_cid, 'c_id');
        $company_dtl = json_decode($company_data->address, true);
        $country_dtl = getNameById('country', $company_dtl[0]['country'], 'country_id');
        //$rfq_supp_ids = json_decode($order_details->rfq_supp, true);
        $company_data = getNameById('company_detail',$order_details->created_by_cid,'id');

        $materialDetail =  json_decode($order_details->material_name);
        // pre($materialDetail);exit;
        foreach($material_detail as $matname){

            $materialName=getNameById('material',$matname->material_name_id,'id');
            $listOfItems_array[] = $materialName->material_name;
        }
        $listOfItems = implode(",",$listOfItems_array);

        //pre($listOfItems);die;
        for($i=0;$i<count($rfq_supp_ids);$i++){


             /* Save Expected Delivery Date  in loop*/

            foreach($materialDetail as $matname){
                $datax['supplier_id'] = $rfq_supp_ids[$i];
                $datax['supplier_expected_deliv_date'] = $expected_deliv_date[$i];
                $datax['product_induction_id'] = $purchaseIndentId;
                $datax['created_by'] = $_SESSION['loggedInUser']->u_id ;
                $datax['product_id']=$matname->material_name_id;
                $this->purchase_model->insert_tbl_data('purchase_rfq', $datax);

         }


            $supplier = getNameById('supplier', $rfq_supp_ids[$i], 'id');

            $namddd = $country_dtl->country_name . ' - ' . $company_dtl[0]['postal_zipcode'];
            $email_message22 = "We at ".$company_data->name." would be grateful if you would provide us QUOTATION. <br/><br/>Please Find the attachment for more Details of Item.<br/><br/>Please feel free to call me if you need any further information in order to provide us with a firm price.<br/><br/>We look forward to hearing from you.<br/>Sincerely,<br/>".$company_data->name."<br/>".$company_data->phone;

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
                                 <td align="center" class="masthead" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: white; background: #099a8c; margin: 0; padding: 30px 0;     border-radius: 4px 4px 0 0;" bgcolor="#099a8c"> <img src="' . base_url() . 'assets/modules/company/uploads/' . $company_data->logo . '" alt="logo" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; max-width: 20%; display: block; margin: 0 auto; padding: 0;" /></td>
                              </tr>
                              ';
                              $footer = '
                              <tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
                                 <td class="container" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">
                                    <!-- Message start -->
                                    <table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
                                       <tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
                                          <td class="content footer" align="center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white none; margin: 0; padding: 30px 35px;     border-radius: 0 0 4px 4px;" bgcolor="white">
                                             <p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center"><a href="' . base_url() . '" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: #888; text-decoration: none; font-weight: bold; margin: 0; padding: 0;">ERP</a></p>
                                             <p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Support: ' . $company_emails->company_group_email . '</p>
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
                    <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi '.$supplier->name.',</p>
                    <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">' . $email_message22 . '</p>
                </td>
                </tr>
                </table>
            </td>
            </tr>';
            //$invoice_details->message_for_email
            $messageContent = $header . $email_message . $footer;
            //pre($messageContent);
            $order_numm = 'RFQ No:- ' . $order_details->indent_code;
            ini_set('memory_limit', '20M');
            $this->load->library('Pdf');
            $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $obj_pdf->SetCreator(PDF_CREATOR);
            $obj_pdf->SetTitle("REQUEST FOR QUOTATION");
            $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
            $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $obj_pdf->SetDefaultMonospacedFont('helvetica');
            $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
            $obj_pdf->setPrintHeader(false);
            $obj_pdf->setPrintFooter(false);
            $obj_pdf->SetAutoPageBreak(TRUE, 10);
            $obj_pdf->SetFont('helvetica', '', 9);
            $companyLogo = base_url().'assets/modules/company/uploads/'.$company_data->logo;
            $obj_pdf->Image($companyLogo,2,4,10,10,'PNG');
            $imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
            $obj_pdf->Image($imagesign,2,4,10,10,'PNG');
            //$supplierName=getNameById('supplier',$order_details->supplier_name,'id');
            $state= getNameById('state',$supplier->state,'state_id');
            $obj_pdf->AddPage();
            $content = '';
            $brnch_name = getNameById_with_cid('company_address', $order_details->delivery_address, 'compny_branch_id','created_by_cid',$company_data->id);
                    //  pre($brnch_name);die;

            // pre($dataPdf);
            // die();
            $content .= '
            <table>
               <tr>
                  <td  align="center"><img src="'.$companyLogo.'" alt="test alt attribute" width="60" height="50" border="0" ></td>
               </tr>
               <tr>
                  <td colspan="1">
                     <div style="margin-top: 15%;">
                        <h2 align="center">REQUEST FOR QUOTATION</h2>
                     </div>
                  </td>
               </tr>
            </table>
            <table border="1" cellpadding="2">
               <tr>
                  <td colspan="3" rowspan="2">
                     <strong>Buyer :</strong> '.$company_data->name.'<br>
                     <strong>Delivery Address :</strong>'.$brnch_name->location.'<br>
                     <strong>Contact :</strong>'.$company_data->phone.'<br>
                     <strong>Website :</strong>'.$company_data->website.'<br>
                     <strong>Email :</strong>'.$company_data->company_group_email.'
                  </td>
                  <td colspan="6"><strong>RFQ No :</strong> &nbsp;'.$order_details->indent_code.'<br/><strong>RFQ Issue Date :</strong> &nbsp; '.($order_details->created_date?date("j F , Y"):'').'<br/><strong>RFQ Expected Delivery Date :</strong> &nbsp; '.($order_details->required_date?date("j F , Y", strtotime($order_details->required_date)):'').'</td>
               </tr>
               <tr>
                  <td colspan="6"><strong>Supplier Name :</strong> '.$supplier->name.' <br><br><strong>Supplier Address:</strong> '.$supplier->address.' <br><br><strong>State :</strong>'.$state->state_name.'</td>
               </tr>

               <tr>
                  <td colspan="10"><b style="font-size:12px;">Product Description</b></td>
               </tr>
               <tr>
                  <th colspan="1" style="text-align:center;"><strong>S No.</strong></th>
                  <th colspan="2"  style="text-align:center;"><strong>Material Name</strong></th>
                  <th colspan="1"  style="text-align:center;"><strong>UOM</strong></th>
                  <th colspan="2"  style="text-align:center;"><strong>Description</strong></th>
                  <th colspan="1"  style="text-align:center;"><strong>Quantity Request</strong></th>
               </tr>
               ';
               $no=1;
               $subTotal=0;
               setlocale(LC_MONETARY, 'en_IN');
               foreach($materialDetail as $material_detail){
                    if(!empty($material_detail->material_name_id)){
                             $material_id=$material_detail->material_name_id;
                             $materialName=getNameById('material',$material_id,'id');
                             $ww =  getNameById('uom', $materialName->uom,'id');
                             $uom = !empty($ww)?$ww->ugc_code:'';
                             $content .= '<tr >
                                            <td colspan="1">'.$no++.'</td><td colspan="2" ><h5>'.$materialName->material_name.'</h5></td>
                                            <td colspan="1" >'.$uom.'</td>
                                            <td colspan="2" >'.$material_detail->description.'</td>
                                           <td colspan="1" >'.$material_detail->quantity.'</td>
                                         </tr>';
                    }
                }
               $content .= '<tr>
                                <td colspan="2">Buyer GSTIN</td>
                                <td colspan="7">'.$company_data->gstin.'</td>
                           </tr>
                           <tr>
                              <td colspan="2">Supplier GSTIN</td>
                              <td colspan="7">'.$supplier->gstin.'</td>
                          </tr>
                            <tr>
                              <td colspan="2">Buyer PAN Card No.</td>
                              <td colspan="7">'.$company_data->company_pan.'</td>
                            </tr>
                           <tr style="height:2000px">
                              <td colspan="4">
                                 <h2>Terms & Conditions</h2>
                                 <p>'.$company_data->term_and_conditions.'</p>
                              </td>
                              <td class="align-bottom"  valign="bottom" colspan="6" style="text-align:right;">
                                 for '.$company_data->name.'<br><br><br>(Authorized Signatory)
                              </td>
                           </tr>
                           ';
                           $content .= '
                        </table>
                        ';
                        $content .='
                        <table>
                           <br><br>
                           <tr rowspan="2">
                              <td  align="center"> This is computer generated Purchase RFQ does not require signature </td>
                           </tr>
                        </table>';
            $obj_pdf->writeHTML($content);
            ob_end_clean();
            $contact_detail = json_decode($supplier->contact_detail);
            $pdfFilePath = FCPATH . "assets/modules/account/pdf_invoice/purchaseRfq.pdf";
            $obj_pdf->Output($pdfFilePath, 'F');
            $this->load->library('email');
            $config = array('mailtype' => 'html', 'charset' => 'utf-8', 'priority' => '1');
            $this->email->initialize($config);
            $this->email->to(trim($contact_detail[0]->email));
            $this->email->from('dev@lastingerp.com');
            $this->email->subject($order_numm);
            $this->email->message($messageContent);
            $this->email->attach($pdfFilePath);
            $this->email->send();
            unlink($pdfFilePath);
        }
    }
   function SetRFQData(){
          $data = $this->input->post();
          //pre($data);die;
            $newDataArray = [];
            $i = 0;
            foreach ($data['data'] as $key => $value) {
                $newKey         = substr($value['name'],14,1);
                $testFilterName = str_replace("supplierPrice[$newKey][","",$value['name']);
                $testFilterName = str_replace("]","",$testFilterName);
                $newDataArray[$newKey][$testFilterName] = $value['value'];
            }

            $newData = [];
            foreach ($newDataArray as $key => $value) {
                if( $value['supplier_expected_amount'] > 0  ){
                    $newData[] = $value;
                }

            }
            /*if ($id && $id != '') {
              $success = $this->purchase_model->update_data('purchase_rfq', $data, 'id', $id);
            }else{*/
              foreach ($newData as $key => $value) {
                $newValue = $value + ['created_by' => $_SESSION['loggedInUser']->u_id];
                if( $value['rfq_id'] ){
                    $success = $this->purchase_model->update_data('purchase_rfq', $newValue, 'id',$value['rfq_id']);
                }else{
                    $success  = $this->purchase_model->insert_tbl_data('purchase_rfq', $newValue);
                }
              }
            if($success){
                echo json_encode(array("statusCode"=>200));die;
            }else{
                echo json_encode(array("statusCode"=>201));die;
            }
    }
    function RFQapproveIndentOrder(){
          $data = $this->input->post();
            $id = $data['id'];
            if ($this->input->post('id')){
                  $success = $this->purchase_model->update_single_field('purchase_indent', $data, 'id', $id);
            }
            if($success){

             if($data['rfq_status'] == 1){
                $this->session->set_flashdata('message', 'RFQ Approved');
               $result = array('msg' => 'RFQ approved', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'purchase/purchase_rfq');
             }else{
                $this->session->set_flashdata('message', 'RFQ Disapproved');

             $result = array('msg' => 'RFQ Disapproved', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'purchase/purchase_rfq');

             }
                echo json_encode($result);
                die;
            } else {
                echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
            }
    }
    //For Dilivery Challan
    public function get_process_type(){
         if($_REQUEST['jobcard_id'] && $_REQUEST['jobcard_id'] != ''){
            $data = $this->purchase_model->get_process_data_byId('job_card','id',$_REQUEST['jobcard_id']);
            $dataprocess = json_decode($data->machine_details,true);
             //$html .='<option value="">Select Option</option>';
            foreach($dataprocess as $process_dtl){
                $process_name_id = getNameById('add_process',$process_dtl['processess'],'id');
                 $html .= '<option value="'.$process_name_id->id.'">'.$process_name_id->process_name.'</option>';
            }
            echo $html;
         }
    }



    /** quality check **/
      public function grn_quality_chk()
    {
        $id   = $this->uri->segment(3);
        $data['mrn_detail'] = $this->purchase_model->get_data_byId('mrn_detail', 'id', $id);
        $val                     = json_decode($data['mrn_detail']->material_name, true);
        foreach ($val as $data1) {
            $data['grn_id']   = $data['mrn_detail']->id;
            $data['report_name']    = $data['mrn_detail']->bill_no;
            $data['final_report']   = 1;
            $data['saleorder']      = 'grn';
            $data['material_id']    = $data1['material_name_id'];
            $data['created_by']     = $_SESSION['loggedInUser']->id;
            $data['created_by_cid'] = $this->companyGroupId;
            $data['created_date']   = date("Y-m-d H:i:s");
            //pre($data);die();
            $this->purchase_model->insert_tbl_data('controlled_report_master', $data);
        }
        //die();
        $this->purchase_model->updateRowWhere('mrn_detail', array(
            'id' => $id
        ), array(
            'is_quality_check' => 1
        ));
        $this->session->set_flashdata('message', 'Added to Quality Check successfully');
        redirect(base_url() . 'purchase/mrn', 'refresh');
    }


    public function purchase_indent_new() {
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_validate'] = validate_permissions();
        $this->data['can_validate_purchase_budget_limit'] = validate_purchase_budget_limit_permissions();
        $this->breadcrumb->add('Purchase', base_url() . 'purchase/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'purchase/dashboard');
        $this->breadcrumb->add('Purchase Indent', base_url() . 'purchase_indent');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Purchase Indent';
        $whereMaterialType = "(created_by_cid ='" . $this->companyGroupId . "' OR created_by_cid =0) AND status = 1";
        $this->data['mat_type_ss'] = $this->purchase_model->get_filter_details('material_type', $whereMaterialType);
        $whereCompany = "(id ='" . $this->companyGroupId . "')";
        $this->data['company_unit_adress'] = $this->purchase_model->get_filter_details('company_detail', $whereCompany);
        $material_type_tt = getNameById('material_type',$_GET['search'],'name');


        if (isset($_GET['favourites'])) {
            $whereInProcess = "(purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "' AND purchase_indent.favourite_sts = '1'";

            $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.favourite_sts' => 1);
        }
        if ($_GET['dashboard'] == 'dashboard' && $_GET['start'] != '' && $_GET['end'] != '') {
            if ($_GET['label'] == 'Approved') {
                $whereInProcess = " purchase_indent.created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND ( purchase_indent.approve ='1')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
            } elseif ($_GET['label'] == 'Disapproved') {
                $whereInProcess = " purchase_indent.created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND ( purchase_indent.disapprove ='1')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
            } elseif ($_GET['label'] == 'Pending') {
                $whereInProcess = " purchase_indent.created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND ( purchase_indent.approve ='0' AND purchase_indent.disapprove='0')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
            } elseif (isset($_GET['material_type_id']) && $_GET['material_type_id'] != '') {
                $whereInProcess = " purchase_indent.created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND ( purchase_indent.material_type_id = " . $_GET['material_type_id'] . " )";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'material_type_id' => $_GET['material_type_id']);
            } elseif ($_GET['label'] == 'Complete PI' || $_GET['label'] == 'Incomplete PI') {
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' )";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
            } elseif ($_GET['label'] == 'Purchase Indent not converted') {
                $whereInProcess = " purchase_indent.created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND purchase_indent.save_status=1 AND purchase_indent.po_or_not=0";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.save_status' => 1);

            } elseif ($_GET['label'] == 'PoCreated') {
                $whereInProcess = " purchase_indent.created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND purchase_indent.save_status=1 AND purchase_indent.po_or_not=1";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.save_status' => 1);
            }
        } else {
            if (!empty($_GET) && isset($_GET['start']) && isset($_GET['end']) && $_GET["ExportType"] == '' && $_GET["favourites"] == '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '') {
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND (purchase_indent.created_by_cid = '" . $this->companyGroupId . "' ) AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' )";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } else if (!empty($_GET) && isset($_GET['start']) && isset($_GET['end']) && $_GET["ExportType"]=='' && $_GET["favourites"] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '') {
               $whereInProcess = "(purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "' AND purchase_indent.favourite_sts = '1'";

            $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.favourite_sts' => 1);

            } else if (!empty($_GET) && isset($_GET['start']) && isset($_GET['end']) && $_GET["ExportType"]!='' && $_GET["favourites"] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '') {
               $whereInProcess = "(purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "' AND purchase_indent.favourite_sts = '1'";

            $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.favourite_sts' => 1);

            }
            elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '' && $_GET['start'] != '' && $_GET['end'] != '') {
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (material_type_id ='" . $_GET['material_type'] . "' AND  departments = '" . $_GET['departments'] . "') AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' )AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '' && $_GET['start'] == '' && $_GET['end'] == '') {
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (material_type_id ='" . $_GET['material_type'] . "' AND  departments = '" . $_GET['departments'] . "') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' ) ";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '' && $_GET['start'] != '' && $_GET['end'] != '') {
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (departments = '" . $_GET['departments'] . "') AND  ( pay_or_not ='0' AND mrn_or_not = '0' OR pay_or_not ='1' AND mrn_or_not = '0' OR pay_or_not ='0' AND mrn_or_not = '1' )AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '' && $_GET['start'] == '' && $_GET['end'] == '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (departments = '" . $_GET['departments'] . "') AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' )";

                $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } elseif (!empty($_GET) && $_GET['material_type'] != '' && $_GET['departments'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '' && $_GET['start'] != '' && $_GET['end'] != '') {
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (material_type_id ='" . $_GET['material_type'] . "') AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' ) AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } elseif (!empty($_GET) && $_GET['material_type'] != '' && $_GET['departments'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] == '' && $_GET['start'] == '' && $_GET['end'] == '') {
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (material_type_id ='" . $_GET['material_type'] . "') AND  ( pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' )";

                $whereComplete = array('purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
            }
            //Start From Here Status Check
            elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0' AND purchase_indent.approve is NOT NULL AND purchase_indent.disapprove is NOT NULL  AND purchase_indent.save_status ='1') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "' AND purchase_indent.disapprove='0'";

                    $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);

                } elseif ($_GET['status_check'] == 'mrn_or_not') {

                    $whereInProcess = "( purchase_indent.mrn_or_not ='0' AND purchase_indent.po_or_not ='1'  AND purchase_indent.save_status ='1') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1 );
                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "(purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
                if ($_GET['status_check'] == 'po_or_not') {

                    $whereInProcess = "( purchase_indent.po_or_not ='0' AND purchase_indent.approve is NOT NULL AND purchase_indent.disapprove is NOT NULL  AND purchase_indent.save_status ='1') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'AND purchase_indent.disapprove='0'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);

                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0' AND purchase_indent.save_status ='1' AND purchase_indent.approve is NOT NULL AND purchase_indent.disapprove is NOT NULL) AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'AND purchase_indent.disapprove='0'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);

                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);
                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'AND purchase_indent.disapprove='0'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1);

                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] != '' && $_GET['departments'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (material_type_id ='" . $_GET['material_type'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);

                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (material_type_id ='" . $_GET['material_type'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (material_type_id ='" . $_GET['material_type'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] != '' && $_GET['departments'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (material_type_id ='" . $_GET['material_type'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);
                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (material_type_id ='" . $_GET['material_type'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (material_type_id ='" . $_GET['material_type'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] != '' && $_GET['departments'] != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] != '') {
                if ($_GET['status_check'] == 'po_or_not') {

                    $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (material_type_id ='" . $_GET['material_type'] . "')AND  (departments = '" . $_GET['departments'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);

                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (material_type_id ='" . $_GET['material_type'] . "') AND  (departments = '" . $_GET['departments'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (material_type_id ='" . $_GET['material_type'] . "') AND (company_unit ='" . $_GET['company_unit'] . "')  AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.departments' => $_GET['departments'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] != '' && $_GET['departments'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                //echo "12";
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0') AND  (material_type_id ='" . $_GET['material_type'] . "')AND  (departments = '" . $_GET['departments'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);
                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0') AND  (material_type_id ='" . $_GET['material_type'] . "') AND  (departments = '" . $_GET['departments'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);
                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (material_type_id ='" . $_GET['material_type'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] == '' && $_GET['departments'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0')  AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1);
                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);
                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL )  AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] == '' && $_GET['departments'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] != '') {
                if ($_GET['status_check'] == 'po_or_not') {

                    $whereInProcess = "( purchase_indent.po_or_not ='0')  AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);

                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL )  AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] == '' && $_GET['departments'] != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] != '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0')  AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (departments = '" . $_GET['departments'] . "')AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);
                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND  (departments = '" . $_GET['departments'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL )  AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  (departments = '" . $_GET['departments'] . "') AND  purchase_indent.created_date <='" . $_GET['end'] . "')AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] == '' && $_GET['departments'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0')   AND  (departments = '" . $_GET['departments'] . "')AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);
                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND  (departments = '" . $_GET['departments'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);

                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL )   AND  (departments = '" . $_GET['departments'] . "') AND (company_unit ='" . $_GET['company_unit'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";
                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.company_unit' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            } elseif (!empty($_GET) && $_GET['status_check'] != '' && $_GET['material_type'] != '' && $_GET['departments'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {
                if ($_GET['status_check'] == 'po_or_not') {
                    $whereInProcess = "( purchase_indent.po_or_not ='0')  AND  (departments = '" . $_GET['departments'] . "') AND  (material_type_id ='" . $_GET['material_type'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";
                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1,'purchase_indent.disapprove'=>0);
                } elseif ($_GET['status_check'] == 'mrn_or_not') {
                    $whereInProcess = "( purchase_indent.mrn_or_not ='0')  AND  (departments = '" . $_GET['departments'] . "') AND  (material_type_id ='" . $_GET['material_type'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";
                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.mrn_or_not' => 1);
                } elseif ($_GET['status_check'] == 'approval_pending') {

                    $whereInProcess = "( purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL ) AND  (material_type_id ='" . $_GET['material_type'] . "')  AND  (departments = '" . $_GET['departments'] . "') AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";
                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.approve' => 1);
                }
            }
            //END Here Status Check
            // start here company unit code///
            elseif (!empty($_GET) && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] == '' && $_GET['end'] == '') {
                //pre($_GET);die();
                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "')";

                $whereComplete = array('purchase_indent.company_unit ' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);



            } elseif (!empty($_GET) && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] != '' && $_GET['end'] != '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit ' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] == '' && $_GET['end'] == '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND  (departments ='" . $_GET['departments'] . "') ";

                $whereComplete = array('purchase_indent.company_unit ' => $_GET['company_unit'], 'purchase_indent.departments ' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            } elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] != '' && $_GET['end'] != '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND (departments ='" . $_GET['departments'] . "') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.company_unit ' => $_GET['company_unit'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.departments ' => $_GET['departments']);

            } elseif (!empty($_GET) && $_GET['departments'] == '' && $_GET['material_type'] != '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] != '' && $_GET['end'] != '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND (material_type_id ='" . $_GET['material_type'] . "') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.company_unit ' => $_GET['company_unit']);

            } elseif (!empty($_GET) && $_GET['departments'] == '' && $_GET['material_type'] != '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] == '' && $_GET['end'] == '') {

                $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND (material_type_id ='" . $_GET['material_type'] . "') ";

                $whereComplete = array('purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.company_unit ' => $_GET['company_unit']);

            } elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] == '' && $_GET['end'] == '') {

                 $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND (material_type_id ='" . $_GET['material_type'] . "') AND (departments ='" . $_GET['departments'] . "')";

                $whereComplete = array('purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.departments ' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.company_unit ' => $_GET['company_unit']);

            } elseif (!empty($_GET) && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['status_check'] == '' && $_GET['company_unit'] != '' && $_GET['start'] != '' && $_GET['end'] != '') {

                 $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') AND (material_type_id ='" . $_GET['material_type'] . "') AND (departments ='" . $_GET['departments'] . "') AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "')";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.departments ' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1, 'purchase_indent.company_unit ' => $_GET['company_unit']);
            } elseif (empty($_GET['tab'])) {

                $whereInProcess = "( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' OR purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                 $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
            }elseif (!empty($_GET['search'])) {
                    $materialName=getNameById('material',$_GET['search'],'material_name');
                $material_type_tt = getNameById('material_type',$_GET['search'],'name');

                if($materialName->id == '' && $material_type_tt->id ==''){
                    $where_serach = "CONCAT(purchase_indent.id, purchase_indent.indent_code) like '%" . $_GET['search'] . "%'";
                }elseif($materialName->id != '' && $material_type_tt->id ==''){
                    $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                    $where_serach = "json_contains(`material_name`, '".$json_dtl."')" ;
                }elseif($material_type_tt->id !=''){
                    $json_dtl ='{"material_type_id" : "'.$materialName->id.'"}';
                    $where_serach = "json_contains(`material_name`, '".$json_dtl."')" ;
                }

                    $whereComplete = array($where_serach,'purchase_indent.created_by_cid' =>$this->companyGroupId);

                  $whereInProcess = $where_serach." AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";
            }elseif (!empty($_GET['tab'] == 'complete')) {

                $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
            }elseif (!empty($_GET['tab'] == 'inprocess')) {
                $whereInProcess = "( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' OR purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";
            }
              if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit']!= '' && $_GET['material_type'] == '' && $_GET['search'] == '' && $_GET['favourites'] == '' && $_GET['status_check'] == '') {

             $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "') ";

                $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId,   'purchase_indent.company_unit ' => $_GET['company_unit']);
        //die();
        }
            if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['search'] == '' && $_GET['favourites'] == '' && $_GET['status_check'] == ''&& $_GET['company_unit']== '' ) {


              if($_GET['tab'] == 'complete'){
                 $whereComplete = array('purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
              }else {

                 $whereInProcess = "( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' OR purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' ) AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";
              }
              //die('fdf');
             } elseif (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] != '' && $_GET['material_type'] == '' && $_GET['search'] == ''&& $_GET['favourites'] == '' && $_GET['status_check'] == '') {

                if($_GET['tab'] == 'complete'){
                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
                }else{
                    $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (departments = '" . $_GET['departments'] . "') AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0')";
                }
            } elseif (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] != '' && $_GET['search'] == ''&& $_GET['favourites'] == '' && $_GET['status_check'] == '') {


            if($_GET['tab'] == 'complete'){

                    $whereComplete = array('purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
                 }else{
                    // echo 'dfff';die();
                    $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (material_type_id ='" . $_GET['material_type'] . "') AND  ( pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' )";
                }//die();
            } elseif (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] != '' && $_GET['material_type'] != '' && $_GET['search'] == ''&& $_GET['favourites'] == '' && $_GET['status_check'] == '') {

                if($_GET['tab'] =='complete'){
                    $whereComplete = array('purchase_indent.departments' => $_GET['departments'], 'purchase_indent.material_type_id ' => $_GET['material_type'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);
                }else{
                    //echo 'there';die();
                    $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (material_type_id ='" . $_GET['material_type'] . "' AND  departments = '" . $_GET['departments'] . "') AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '1' )";
                }
            } elseif (isset($_GET["ExportType"]) && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['search'] == ''&& $_GET['favourites'] == '' && $_GET['status_check'] == '') {

                 $whereInProcess = "created_by_cid = " . $this->companyGroupId . " AND  (purchase_indent.created_date >='" . $_GET['start'] . "' AND  purchase_indent.created_date <='" . $_GET['end'] . "') AND (purchase_indent.created_by_cid = '" . $this->companyGroupId . "' ) AND  ( purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='1' AND purchase_indent.mrn_or_not = '0' OR purchase_indent.pay_or_not ='0' AND purchase_indent.mrn_or_not = '1' )";

                $whereComplete = array('purchase_indent.created_date >=' => $_GET['start'], 'purchase_indent.created_date <=' => $_GET['end'], 'purchase_indent.created_by_cid' => $this->companyGroupId, 'purchase_indent.po_or_not' => 1, 'purchase_indent.mrn_or_not' => 1, 'purchase_indent.pay_or_not' => 1);

            }elseif (isset($_GET["ExportType"])!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['search'] == ''&& $_GET['favourites'] == '' && $_GET['status_check'] != '') {
            echo 'dgdfg';
            }elseif (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['search'] != ''&& $_GET['favourites'] == '' && $_GET['status_check'] == '') {

                $materialName=getNameById('material',$_GET['search'],'material_name');
                $material_type_tt = getNameById('material_type',$_GET['search'],'name');

                if($materialName->id == '' && $material_type_tt->id ==''){
                    $where_serach = "CONCAT(purchase_indent.id, purchase_indent.indent_code) like '%" . $_GET['search'] . "%'";
                }elseif($materialName->id != '' && $material_type_tt->id ==''){
                    $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                    $where_serach = "json_contains(`material_name`, '".$json_dtl."')" ;
                }elseif($material_type_tt->id !=''){
                    $json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                    $where_serach = "json_contains(`material_name`, '".$json_dtl."')" ;
                }

                    $whereComplete = array($where_serach,'purchase_indent.created_by_cid' =>$this->companyGroupId);

                  $whereInProcess = " ".$where_serach." AND purchase_indent.created_by_cid = '" . $this->companyGroupId . "'";

                //die();
            }
        }

    //pre($_POST);
    // pre($_GET);
    // die();
        //Search
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $materialName=getNameById('material',$search_string,'material_name');
            if($materialName->id == ''){
                $where2 = 'CONCAT(purchase_indent.id, purchase_indent.indent_code) like "%' . $search_string . '%"' ;
            }elseif($materialName->id != ''){
                $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                $where2 = "json_contains(`material_name`, '".$json_dtl."')" ;
            }elseif($material_type_tt->id !=''){
                $json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                $where2 = "json_contains(`material_name`, '".$json_dtl."')" ;
            }
            redirect("purchase/purchase_indent/?search=$search_string");
        }else if($_GET['search']!=''){
            $materialName=getNameById('material',$_GET['search'],'material_name');
            $material_type_tt = getNameById('material_type',$_GET['search'],'name');

            if($materialName->id == '' && $material_type_tt->id ==''){
                $where2 = "CONCAT(purchase_indent.id, purchase_indent.indent_code) like '%" . $_GET['search'] . "%'";
            }elseif($materialName->id != '' && $material_type_tt->id ==''){
                $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                $where2 = "json_contains(`material_name`, '".$json_dtl."')" ;
            }elseif($material_type_tt->id !=''){
                $json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                $where2 = "json_contains(`material_name`, '".$json_dtl."')" ;
            }
        }
        //
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = "desc";
        }
            //pre($whereComplete);
        //pre($_GET);die();
        if($_GET['tab']=='complete' && $_GET['tab']!='inprocess'){
            $rows=$this->purchase_model->tot_rows('purchase_indent', $whereComplete, $where2);
        }elseif($_GET['tab']=='inprocess' && $_GET['tab']!='complete'){
            $rows=$this->purchase_model->tot_rows('purchase_indent', $whereInProcess, $where2);
        }else{

            $rows=$this->purchase_model->tot_rows('purchase_indent', $whereInProcess, $where2);
            //$rows=$this->purchase_model->tot_rows('purchase_indent', $whereInProcess, $where2);

        }

        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "purchase/purchase_indent";
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
        //$where2 = " purchase_indent.id like '%" .$_GET['search']. "%'";
        //$where2 = "CONCAT(purchase_indent.id, purchase_indent.indent_code) like '%" . $_GET['search'] . "%'";


        if(!empty($_GET['ExportType'])){
            $export_data = 1;
        }else{
            $export_data = 0;
        }


        if($_GET['tab']=='complete' && $_GET['tab'] !='inprocess'){

            $this->data['indent'] = $this->purchase_model->get_data_listing('purchase_indent', $whereComplete, $config["per_page"], $page, $where2, $order,$export_data);
        }elseif($_GET['tab']=='inprocess' && $_GET['tab'] !='complete'){


            $this->data['purchase_indent_inProcess'] = $this->purchase_model->get_data_listing('purchase_indent', $whereInProcess, $config["per_page"], $page, $where2, $order,$export_data);
            //pre($this->data['purchase_indent_inProcess']);die();
        }
        else{
            //pre($_GET);die('else');
            $this->data['indent'] = $this->purchase_model->get_data_listing('purchase_indent', $whereComplete, $config["per_page"], $page, $where2, $order,$export_data);

            $this->data['purchase_indent_inProcess'] = $this->purchase_model->get_data_listing('purchase_indent', $whereInProcess, $config["per_page"], $page, $where2, $order,$export_data);
        }


        $where21 = " purchase_budget_limit.id like '%" .$_GET['search'] . "%'";
        $purchase_budget_limit = $this->purchase_model->get_data1('purchase_budget_limit', array('created_by_cid' => $this->companyGroupId), $config["per_page"], $page, $where21, $order);
        $this->data['purchase_budget_limit'] = (!empty($purchase_budget_limit) ? $purchase_budget_limit[0]['budget_limit'] : '');

        //pre($this->data);
        $this->_render_template('purchase_indent/test2', $this->data);
    }

    function SetMinPriceRFQ(){
        if( $_POST['id'] ){
            $this->purchase_model->updateWhere('purchase_rfq',['selected_status' => 0 ],['product_id' => $_POST['product_id']]);
            $this->purchase_model->updateWhere('purchase_rfq',['selected_status' => 1 ],['id' => $_POST['id']]);
            echo json_encode(['statusCode' => 200]);
        }

    }

    function destroyMrnDocs($id){
        if($this->purchase_model->delete_data('attachments','id',$id)){
            echo json_encode(['status' => 'success','url' => '']);
        }else{
            echo json_encode(['status' => 'failed','url' => '']);
        }
    }

    function approvedMaterial(){
        if( $_POST['approved'] ){
            $result = $this->purchase_model->updateByWhereIn('material_type',['approved' => $_POST['approveStatus']],'id',$_POST['approved']);
            if( $_POST['approveStatus'] ){
                $msg = "Material Type is approved";
            }else{
                $msg = "Material Type is Unapproved";
            }
            $this->session->set_flashdata('message',$msg);
            echo $result;
        }
    }

    function gateEntryStatus(){
        $checked = 0;
        $msg = "OFF";
        if( $_POST['checked'] ){
            $checked = 1;
            $msg = "ON";
        }
        $this->purchase_model->updateWhere('company_detail',['gate_entry_status' => $checked ],['id' => $this->companyGroupId]);
        $this->db->update('menus',['status' => $checked ],['id' => 374]);
        $this->session->set_flashdata('message',"Gate Entry {$msg}");
        echo json_encode(['refresh' => 'refresh']);
    }

/*    function order_report(){
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $where = "( mrn.created_by_cid = {$this->companyGroupId} OR mrn.created_by_cid = 0) ";
        if( !empty($_GET['start']) && !empty($_GET['end']) ){
            $startDate = date("Y-m-d h:i:s",strtotime($_GET['start']));
            $endDate   =   date("Y-m-d h:i:s",strtotime($_GET['end']));
            $where .= " AND (mrn.created_date Between '{$_GET['start']}' AND '{$endDate}' ) ";
        }
        if( !empty( $_GET['report_type'] ) ){
            $status = ($_GET['report_type'] == 'pass')?0:1;
            $clause = '"defected":'.$status;
            $where .= " AND mrn.material_name LIKE '%".$clause."%' ";

        }
        $reportDataNum = $this->purchase_model->twoJoinTables(true,'mrn.*','mrn_detail as mrn','supplier as s','s.id = mrn.supplier_name',
                                                $where);
        $config = paginationAttr("purchase/order_report",$reportDataNum);
        $this->pagination->initialize($config);
        $start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        $this->data['reportData'] = $this->purchase_model
                      ->twoJoinTables(false,'mrn.*,s.name as sName','mrn_detail as mrn','supplier as s','s.id = mrn.supplier_name',
                        $where,'id DESC',$start,$config['per_page']);
        $this->_render_template('report/index', $this->data);
    }*/

    function purchase_order_analysis(){
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $where = "( mrn.created_by_cid = {$this->companyGroupId} OR mrn.created_by_cid = 0) ";

        $reportDataNum = $this->purchase_model->twoJoinTables(true,'mrn.*','mrn_detail as mrn','supplier as s','s.id = mrn.supplier_name',
                                                $where);
        $config = paginationAttr("purchase/purchase_order_analysis",$reportDataNum);

        $this->pagination->initialize($config);

        $start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        $this->data['reportData'] = $this->purchase_model
                      ->twoJoinTables(false,'mrn.*,s.name as sName','mrn_detail as mrn','supplier as s','s.id = mrn.supplier_name',
                        $where,'id DESC',$start,$config['per_page']);
        $this->_render_template('report/purchase_order_analysis', $this->data);
    }

    function checkCompanyBugget(){
        if( $_POST['materialTypeId'] ){
            $materialBudget = $this->purchase_model->getDataByWhereId('material_type',['id' => $_POST['materialTypeId'] ],['name','budget']);
            $mId = $_POST['materialTypeId'];
            $materialId = '"material_type_id":'.'"'.$mId.'"';

            $where = " material_name LIKE '%{$materialId}%' AND created_by_cid = {$this->companyGroupId}
                        AND (MONTH(created_date) = MONTH(now()) AND YEAR(created_date) = YEAR(now()) )";
            $materialData = $this->purchase_model->getDataByWhereId('purchase_indent',$where,['material_name']);
            $totalIndentAmount = 0;
            foreach ($materialData as $key => $value) {
                $mData = json_decode($value['material_name']);
                foreach ($mData as $key => $value) {
                    if( $value->material_type_id == $mId ){
                        $totalIndentAmount += (int)$value->sub_total;
                    }
                }
            }
            if( $materialBudget ){
                if( !empty($materialBudget[0]['budget']) && $materialBudget[0]['budget'] < $totalIndentAmount ){
                    echo json_encode(['budget' => $materialBudget[0]['budget'],'material_name' => $materialBudget[0]['name'],
                                        'createdIndent' => $totalIndentAmount ]);
                }
            }
        }
    }

    function getAllSaleOrder($sale_id = ""){
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $selected   = 'id,sale_order_no';
        $where      = "created_by_cid = {$this->companyGroupId}";
        $data       = $this->purchase_model->joinTables($selected,'work_order',[],$where,['id','desc'],[]);
        $html       = "<option value=''>Select Sale Order</option>";
        if( $data ){
            foreach ($data as $key => $value) {
                // if( $sale_id ){
                //     echo "<option value="'.$sale_id->sale_order_no.'" selected>'.$value->sale_order_no.'</option>";
                // }
                $html .= "<option  value='{$value['id']}'>{$value['sale_order_no']}</option>";
            }
        }
        return $html;
    }

    function onOffStatusUpdate(){
        $checked = 0;

        $setMsg = "Purchase Order Approve Level";
        if( !empty($_POST['msg'] )){
            $setMsg = $_POST['msg'];
        }

        $msg = "OFF";
        if( $_POST['value'] && empty($_POST['msg']) ){
            $checked = 1;
            $msg = "ON";
            $setMsg = $setMsg." ".$msg;
        }
        $this->purchase_model->updateWhere($_POST['table'],[$_POST['column'] => $checked ],$_POST['where']);
        $this->session->set_flashdata('message',"{$setMsg}");
        echo json_encode(['refresh' => 'refresh']);
    }

    function updateSingleValue(){
        $value = 0;
        if( $_POST['value'] ){
            $value = $_POST['value'];
            $msg = "updated";
        }

        if( $_POST['column'] == 'po_approve_level' ){
            $poApproveDetail = getSingleAndWhere('po_approve_users',$_POST['table'],$_POST['where']);
            $userDetail = json_decode($poApproveDetail,true);
            if(  empty($value) || $value == 0 ){
                $this->purchase_model->updateWhere($_POST['table'],['po_approve_users' => '' ],$_POST['where']);
            }else{
                $newUserData = [];
                $j = 0;
                for ( $i=1; $i <= $value; $i++) {
                    if( isset($userDetail[$j]) ){
                        $newUserData[] = $userDetail[$j];
                        $j++;
                    }
                }
                $this->purchase_model->updateWhere($_POST['table'],['po_approve_users' => json_encode($newUserData) ],$_POST['where']);
            }
        }

        $this->purchase_model->updateWhere($_POST['table'],[$_POST['column'] => $value ],$_POST['where']);
        $this->session->set_flashdata('message',"Purchase Order Approve Level {$msg}");
        echo json_encode(['refresh' => 'refresh']);
    }

    function purchase_order_approve_user(){
        if( !empty($_POST['po_aprove_users']) ){
            $poUser = json_encode($_POST['po_aprove_users']);
            // pre($poUser);die;
            $this->purchase_model->updateWhere('company_detail',['po_approve_users' => $poUser ],['id' => $this->companyGroupId]);
            $this->session->set_flashdata('message',"Purchase order user for approval update successfully");
            redirect('purchase/purchase_setting?tab=purchase_flow_setting');
        }
    }

    function purchaseApprovePopup(){
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['selectApproveUsers'] = json_decode(getSingleAndWhere('selectApproveUsers','purchase_order',['id' => $_POST['id'] ]));

        $this->data['poApprovedata'] = json_decode(getSingleAndWhere('approve_user_detail',
                                                    'purchase_order',['id' => $_POST['id'] ]),true);
        $this->data['order_id'] = $_POST['id'];
        $this->load->view('purchase_order/approve_order',$this->data);
    }

    function orderApproveByUser(){
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();


        if( isset($_POST['approveStatus'][0]) ){
            if( empty($_POST['approveStatus'][0]) ){
               $this->session->set_flashdata('message','Fields required');
               redirect('purchase/purchase_order');
            }
        }

        $approveResult = checkUserSendStatus($_POST);
        extract($_POST);

        $companyPoApproveUser = json_decode(getSingleAndWhere('po_approve_users',
                                                    'company_detail',['id' => $this->companyGroupId]));



        if( $approveResult['msg'] ){
            $this->session->set_flashdata('message',$approveResult['msg']);
        }else{
            if( $approveResult['data'] ){
                $data = json_encode(['userId' => $approveResult['data'],'status' => $approveResult['status'] ]);
                $this->purchase_model->updateWhere('purchase_order',['approve_user_detail' => $data ],['id' => $id]);

                $currentUser   = getSingleAndWhere('name','user_detail',['id' => $_SESSION['loggedInUser']->u_id ]);
                pushNotification(array('subject' => "Purchase order Approve By {$currentUser}", 'message' => 'Purchase order id : #' . $id . ' is by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'class' => 'add_purchase_tabs', 'data_id' => 'OrderView', 'icon' => 'fa-shopping-cart'));

                if( $companyPoApproveUser ){
                    if($keyName = array_search($_SESSION['loggedInUser']->u_id,$companyPoApproveUser)){
                        $nextUser = $keyName + 1;
                        if( isset($companyPoApproveUser[$nextUser] )){
                            $nextUserEmail = getSingleAndWhere('email','user',['id' => $companyPoApproveUser[$nextUser] ]);
                            $ancher        = base_url("purchase/purchase_order?search={$id}");
                            $emailBody     = "{$currentUser} Approve Purchase Order <a href='{$ancher}'>Order Link</a>";
                            $this->sendEmail($emailBody,$nextUser);
                        }
                    }
                }
                $this->session->set_flashdata('message','Approve Status Successfully Submit');
            }
        }
        redirect('purchase/purchase_order');
    }

    function sendEmail($body,$email,$subject='Reorder level'){
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
        $mail->SMTPDebug = 0;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
        $mail->isSMTP();
        $mail->Host       = 'email-smtp.ap-south-1.amazonaws.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'AKIAZB4WVENVZ773ONVF';
        $mail->Password   = 'BLDqOsL9LkOKnY6n4coXRFsrXNq66C9xLDlsaCzasGEG';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->setFrom('dev@lastingerp.com','lerp');
        //$mail->addAddress('princy@lastingerp.com','');
        $mail->addAddress($email,'');
        $mail->isHTML(true);
        $mail->isHTML(true);
        $mail->Body = $body;
        $mail->Subject = $subject;
        //$mail->addAttachment($pdfFilePath,'Reorder Level Report','base64','application/pdf');
        $mail->send();
        /*if($mail->send()){
            echo 'sent';
        }else{
            echo 'Mailer error: ' . $mail->ErrorInfo;
        }*/
    }

    function getAllBuyer(){
        $selected  = 'u_id,name';
        $where     = "c_id = {$this->companyGroupId}";
        $data      = $this->purchase_model->joinTables($selected,'user_detail',[],$where,['id','desc'],[]);
        $selected .= ',Select User';
        return $this->optionHtml($data, explode(',',$selected) );
    }

    function optionHtml($data,$optionData){
        $html = "<option value=''>{$optionData[2]}</option>";
        if( $data ){
            foreach ($data as $key => $value) {
                $html .= "<option value='{$value[$optionData[0]]}'>{$value[$optionData[1]]}</option>";
            }
        }
        return $html;
    }

    function checkProductCodeExist(){
        if( $_POST ){
            $productCode = getSingleAndWhere('product_code','material',['product_code' => str_replace(" ","",$_POST['product_code']) ] );
            if( !empty($productCode) ){
                echo 1;
            }else{
                echo 0;
            }
        }
    }
       public function purchase_term_condi(){

          if ($this->input->post()) {
            $data  = $this->input->post();
			
			
			

            $data['id'] = $_SESSION['loggedInUser']->id;
            $id = $data['id'];

            if($id && $id != ''){
                $success = $this->purchase_model->update_data('company_detail',$data, 'u_id', $_SESSION['loggedInUser']->id);
                    if ($success) {
                        $data['message'] = "Terms and Conditions Added successfully";
                        logActivity('Terms and Conditions Added','company_detail',$id);
                        $this->session->set_flashdata('message', 'Terms and Conditions Added successfully');
                        redirect(base_url().'purchase/purchase_setting', 'refresh');
                    }
                 }
            }
        }
          function aging_report(){
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Purchase Ageing Report', base_url() . ' Purchase Ageing Report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = ' Purchase Ageing Report ';
        $whereCompany = "(id ='" . $this->companyGroupId . "')";
        $this->data['company_unit_adress'] = $this->purchase_model->get_filter_details('company_detail', $whereCompany);
        $json_dtl ='{"material_type_id" : "'.$_GET['material_type'].'"}';
        $JSONSearch ="json_contains(`material_name`,'".$json_dtl."')";
        if ($_GET['dashboard'] == 'dashboard' && $_GET['start'] != '' && $_GET['end'] != '') {
            if (isset($_GET['material_type_id']) && $_GET['material_type_id'] != '') {
                $where = "mrn_detail.created_by_cid ='".$this->companyGroupId."' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) AND ( mrn_detail.material_type_id = " . $_GET['material_type_id'] . " )";
                $complete_where = "mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.created_by_cid = '" . $this->companyGroupId . "' ) AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1)  AND ( mrn_detail.material_type_id = " . $_GET['material_type_id'] . " )";
            } elseif ($_GET['label'] == 'Complete GRN' || $_GET['label'] == 'Incomplete GRN') {
                $where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                $complete_where = "mrn_detail.created_by_cid ='".$this->companyGroupId."'AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='".$_GET['end']."') AND (mrn_detail.created_by_cid = '" . $this->companyGroupId . "' ) AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
            }
        } else {

                if (!empty($_GET) && isset($_GET['start']) && isset($_GET['end']) && $_GET['supplier_name'] == '' && $_GET['material_type'] == '' && $_GET["ExportType"] == '' && $_GET["favourites"] == '' && $_GET['company_unit'] == '') {
                    $where = "mrn_detail.created_by_cid = '" . $this->companyGroupId ."' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.created_by_cid = '" . $this->companyGroupId . "' ) AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = "mrn_detail.created_by_cid = '".$this->companyGroupId ."' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.created_by_cid = '" . $this->companyGroupId . "' ) AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } else if (!empty($_GET) && $_GET['supplier_name'] != '' && $_GET['material_type'] != '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
                    //echo "2";
                    $where = $JSONSearch ." AND ( mrn_detail.created_by_cid = " . $this->companyGroupId . "  AND  mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = $JSONSearch . " AND ( mrn_detail.created_by_cid = " . $this->companyGroupId . "  AND  mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } else if (!empty($_GET) && $_GET['supplier_name'] != '' && $_GET['material_type'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {

                    $where = $JSONSearch ." AND ( mrn_detail.created_by_cid = '".$this->companyGroupId ."'  AND  mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = $JSONSearch ." AND ( mrn_detail.created_by_cid = " . $this->companyGroupId . "  AND  mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } else if (!empty($_GET) && $_GET['supplier_name'] != '' && $_GET['material_type'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {
                    //echo "4";
                    $where = "mrn_detail.created_by_cid = '".$this->companyGroupId."' AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = "mrn_detail.created_by_cid = '".$this->companyGroupId."' AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } else if (!empty($_GET) && $_GET['supplier_name'] != '' && $_GET['material_type'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
                    //echo "4";
                    $where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "')  AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = "mrn_detail.created_by_cid = '" . $this->companyGroupId ."' AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "')  AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } else if (!empty($_GET) && $_GET['material_type'] != '' && $_GET['supplier_name'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '') {

                    $where = $JSONSearch. " AND mrn_detail.created_by_cid = '".$this->companyGroupId ."' AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = $JSONSearch. " AND mrn_detail.created_by_cid = '".$this->companyGroupId."' AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } else if (!empty($_GET) && $_GET['material_type'] != '' && $_GET['supplier_name'] == '' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
                    $where = $JSONSearch ." AND mrn_detail.created_by_cid = '".$this->companyGroupId."' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = $JSONSearch ." AND mrn_detail.created_by_cid ='".$this->companyGroupId."' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } else if (!empty($_GET) && $_GET['material_type'] == '' && $_GET['supplier_name'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                    $where = "mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "')  ";
                    $complete_where = "mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "')  ";
                } else if (!empty($_GET) && $_GET['material_type'] != '' && $_GET['supplier_name'] == '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                    $where = $JSONSearch ." AND mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "')  ";
                    $complete_where = $JSONSearch ." AND mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "')  ";
                } else if (!empty($_GET) && $_GET['material_type'] != '' && $_GET['supplier_name'] != '' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] != '') {
                    $where = $JSONSearch ." AND mrn_detail.created_by_cid = " . $this->companyGroupId . "  AND  (company_unit ='" . $_GET['company_unit'] . "' ) AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "')  ";
                    $complete_where = $JSONSearch ." AND mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "' ) AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "')  ";
                } else {
                    #$where = array('mrn_detail.created_by_cid' => $_SESSION['loggedInUser']->c_id, 'mrn_detail.ifbalance' => 1 , 'mrn_detail.pay_or_not' => 0);
                    $where = "mrn_detail.created_by_cid = '".$this->companyGroupId."' AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = array('mrn_detail.created_by_cid' => $this->companyGroupId, 'mrn_detail.ifbalance' => 0, 'mrn_detail.pay_or_not' => 1);
                }
                /*******************export filter **********************************************/
                if(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] == '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' &&  $_GET['search'] == '') {
                    $where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";

                    $complete_where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                }else if(isset($_GET["ExportType"])=='' && $_GET['favourites']!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] == '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' &&  $_GET['search'] == '') {
                  $where = "mrn_detail.created_by_cid = '".$this->companyGroupId."' AND mrn_detail.favourite_sts = 1";
                $complete_where = array('mrn_detail.created_by_cid' => $this->companyGroupId, 'mrn_detail.ifbalance' => 0, 'mrn_detail.pay_or_not' => 1, 'mrn_detail.favourite_sts' => 1);
                }

                else if(isset($_GET["ExportType"])!='' && $_GET['favourites']!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] == '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' &&  $_GET['search'] == '') {
                   $where = "mrn_detail.created_by_cid = '".$this->companyGroupId."' AND mrn_detail.favourite_sts = 1";
                $complete_where = array('mrn_detail.created_by_cid' => $this->companyGroupId, 'mrn_detail.ifbalance' => 0, 'mrn_detail.pay_or_not' => 1, 'mrn_detail.favourite_sts' => 1);
                }
                 elseif(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] != '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' &&  $_GET['search'] == '') {
                    $where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND  (mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } elseif(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] == '' && $_GET['material_type'] != '' && $_GET['company_unit'] == '' &&  $_GET['search'] == '') {
                    $where = $JSONSearch ." AND mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = $JSONSearch ." AND mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } elseif(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] == '' && $_GET['material_type'] == '' && $_GET['company_unit']!= '' &&  $_GET['search'] == ''){
                $where = "mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "')  ";
                    $complete_where = "mrn_detail.created_by_cid = " . $this->companyGroupId . " AND  (company_unit ='" . $_GET['company_unit'] . "')  ";
        }elseif(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] != '' && $_GET['material_type'] != '' && $_GET['company_unit'] == '' &&  $_GET['search'] == '') {
                    $where = $JSONSearch ." AND ( mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND  mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                    $complete_where = $JSONSearch ." AND ( mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND  mrn_detail.supplier_name = '" . $_GET['supplier_name'] . "') AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                } elseif(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['departments'] == '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' &&  $_GET['search'] == '') {

                    if($_GET['tab']=='complete'){
                    $complete_where = "mrn_detail.created_by_cid = '".$this->companyGroupId ."' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.created_by_cid = '" . $this->companyGroupId . "' ) AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) ";
                    }else{
                         $where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND  (mrn_detail.created_date >='" . $_GET['start'] . "' AND  mrn_detail.created_date <='" . $_GET['end'] . "') AND (mrn_detail.created_by_cid = '" . $this->companyGroupId . "' ) AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) ";
                         }

                }
             elseif(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] == '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' &&  $_GET['search'] != '') {
            $materialName=getNameById('material',$_GET['search'],'material_name');
            $material_type_tt = getNameById('material_type',$_GET['search'],'name');
                if($materialName->id == '' && $material_type_tt->id ==''){
                    $wheresearch = "(mrn_detail.id like '%" . $_GET['search']. "%' OR mrn_detail.bill_no like '%" . $_GET['search'] . "%')";
                }elseif($materialName->id != '' && $material_type_tt->id ==''){
                    $json_dtl ='{"material_name_id" : "'.$_GET['material_type'].'"}';
                    $wheresearch = "mrn_detail.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                }elseif($material_type_tt->id !=''){
                    $json_dtl ='{"material_name_id" : "'.$_GET['material_type'].'"}';
                    $wheresearch = "mrn_detail.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                }

                     $complete_where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1) AND ".$wheresearch;
             $where = "mrn_detail.created_by_cid ='".$this->companyGroupId."' AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0) AND ".$wheresearch;

            }
              elseif(isset($_GET["ExportType"]) && $_GET['favourites']=='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['supplier_name'] == '' && $_GET['material_type'] == '' && $_GET['company_unit'] == '' &&  $_GET['search'] != '') {
             $where = "mrn_detail.created_by_cid ='".$this->companyGroupId."' AND (mrn_detail.ifbalance = 1 OR mrn_detail.pay_or_not = 0)";
             $complete_where = "mrn_detail.created_by_cid = '" . $this->companyGroupId . "' AND (mrn_detail.ifbalance = 0 AND mrn_detail.pay_or_not = 1)";
                }

        }
        //Search
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
           $search_string = $_POST['search'];
           $materialName=getNameById('material',$search_string,'material_name');
            $material_type_tt = getNameById('material_type',$search_string,'name');
                if($materialName->id == '' && $material_type_tt->id ==''){
                    $where2 = "(mrn_detail.id like '%" . $search_string . "%' OR mrn_detail.bill_no like '%" . $search_string . "%')";
                }elseif($materialName->id != '' && $material_type_tt->id ==''){
                    $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                    $where2 = "mrn_detail.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                }elseif($material_type_tt->id !=''){
                    $json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                    $where2 = "mrn_detail.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                }
                redirect("purchase/aging_report/?search=$search_string");
        }else if($_GET['search']!=''){
            $materialName=getNameById('material',$_GET['search'],'material_name');
            $material_type_tt = getNameById('material_type',$_GET['search'],'name');
                if($materialName->id == '' && $material_type_tt->id ==''){
                    $where2 = "(mrn_detail.id like '%" . $_GET['search']. "%' OR mrn_detail.bill_no like '%" . $_GET['search'] . "%')";
                }elseif($materialName->id != '' && $material_type_tt->id ==''){
                    $json_dtl ='{"material_name_id" : "'.$materialName->id.'"}';
                    $where2 = "mrn_detail.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                }elseif($material_type_tt->id !=''){
                    $json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                    $where2 = "mrn_detail.material_name!='' AND json_contains(`material_name`, '".$json_dtl."')" ;
                }
            }

        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = "desc";
        }

        if( !empty($_GET['purchase_type']) ){
            if( $_GET['purchase_type'] == 2 ){
                $_GET['purchase_type'] = 0;
            }
            if( $where ){
              $where  = str_replace("AND  (mrn_detail.created_date >='' AND  mrn_detail.created_date <='')", "",$where);
              $where .= " AND mrn_detail.purchase_type = {$_GET['purchase_type']}";
            }
            if( $whereComplete ){
                $complete_where  = str_replace("AND  (mrn_detail.created_date >='' AND  mrn_detail.created_date <='')", "",$complete_where);
                $complete_where .= " AND mrn_detail.purchase_type = {$_GET['purchase_type']}";
            }
        }

        if( !empty( $_GET['report_type'] ) ){
            $status = ($_GET['report_type'] == 'pass')?0:1;
            $clause = '"defected":'.$status;
            $defWhere .= " AND mrn_detail.material_name LIKE '%".$clause."%' ";

            if( $where ){
              $where  = str_replace("AND  (mrn_detail.created_date >='' AND  mrn_detail.created_date <='')", "",$where);
              $where .= $defWhere;
            }
            if( $whereComplete ){
                $complete_where  = str_replace("AND  (mrn_detail.created_date >='' AND  mrn_detail.created_date <='')", "",$complete_where);
                $complete_where .= $defWhere;
            }
        }


        if($_GET['tab']=='complete'){
            $rows=$this->purchase_model->tot_rows('mrn_detail', $complete_where, $where2);
        }elseif($_GET['tab']=='inprocess'){
            $rows=$this->purchase_model->tot_rows('mrn_detail', $where, $where2);
        }else{
            $rows=$this->purchase_model->tot_rows('mrn_detail', $where, $where2);
        }
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "purchase/aging_report";
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
        if(!empty($_GET['ExportType'])){
            $export_data = 1;
        }else{
            $export_data = 0;
        }

        if($_GET['tab']=='complete'){
            $this->data['mrn_complete'] = $this->purchase_model->get_data_listing('mrn_detail', $complete_where, $config["per_page"], $page, $where2, $order,$export_data);
        }elseif($_GET['tab']=='inprocess'){
             $this->data['mrn'] = $this->purchase_model->get_data_listing('mrn_detail', $where, $config["per_page"], $page, $where2, $order,$export_data);
        }else{
        $this->data['mrn_complete'] = $this->purchase_model->get_data_listing('mrn_detail', $complete_where, $config["per_page"], $page, $where2, $order,$export_data);
         $this->data['mrn'] = $this->purchase_model->get_data_listing('mrn_detail', $where, $config["per_page"], $page, $where2, $order,$export_data);
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
       $this->_render_template('report/aging_report/aging_report' );
    }
    function mailsand($defected_Order=''){

              $this->load->library('Pdf');
             $supplier = getNameById('supplier', $defected_Order->supplier_name, 'id');
             $contact_detail= json_decode($supplier->contact_detail);
             $supplieremail= $contact_detail[0]->email;

              $dataPdf=$defected_Order;
              $company_data = getNameById('company_detail',$dataPdf->created_by_cid,'id');


    $image = base_url().'assets/modules/company/uploads/'.$company_data->logo;
               $getUnitName = getNameById('company_address',$dataPdf->created_by_cid,'created_by_cid');
    $compnm = !empty($getUnitName)?$getUnitName->company_unit:'';

    $createdby = ($dataPdf->created_by!=0)?(getNameById('user_detail',$dataPdf->created_by,'u_id')->name):'';
#!empty($primaryContact)?$primaryContact->phone_no:''

$products= json_decode($dataPdf->material_name);

    $content.='';

    $content .= '
    <table>
        <tr>
            <td align="center"><img src="'.$image.'" alt="test alt attribute" width="60" height="50" border="0" ></td></tr>
            <tr>
            <td colspan="8"><div style="margin-top: 20%;"><h2 align="center">Material Defected Report</h2></div></td>
        </tr>
    </table>
    <table border="1" cellpadding="2">
        <tr>
            <td colspan="4"><strong>Invoice number.</strong> &nbsp; '.$dataPdf->bill_no.'</td>
            <td colspan="3"><strong>Invocie Date.</strong> &nbsp; '.date("d/M/Y", strtotime($dataPdf->bill_date)).'</td>
        </tr>
        <tr>
            <td>S No.</td>
            <td>Material Type</td>
            <td>Material Name</td>
            <td>Recived Qut</td>
            <td>Invoice Qut</td>
            <td>Defected  Qut</td>
            <td>Reason</td>
        </tr>';
        $i = 0;
        foreach($products as $product){
            if($product->defected==1){

                $i++;
                       $ww=getNameById('material_type',$product->material_type_id,'id');
                    $ee = getNameById('material',$product->material_name_id,'id');
                     $mat_name = !empty($ee)?$ee->material_name:'';
                     $uom = getNameById('uom',$product->uom_selected_id,'id');
                     $uom_name = !empty($uom)?$uom:'';
            $content .= '<tr>
                <td>'.$i.'</td>
                <td>'.$mat_name.'</td>
                <td>'.$ww->name.'</td>
                <td>'.$product->received_quantity.'</td>
                <td>'.$product->invoice_quantity.'</td>
                <td>'.$product->defectedQty.'</td>
                <td>'.$product->defected_reason.' </td>
            </tr>';
            }}
       $content .= '</table>';


               $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
               $pdf->SetCreator(PDF_CREATOR);
               $pdf->AddPage();
               $pdfFilePath = FCPATH ."assets/modules/purchase/defected_report/defected_report.pdf";
               $pdf->WriteHTML($content);
               $pdf->Output($pdfFilePath, "F");
              $this->sendEmaildefected($pdfFilePath,$supplieremail);

    }
     function sendEmaildefected($pdfFilePath,$emails){

        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
        $mail->SMTPDebug = 0;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
        $mail->isSMTP();
        $mail->Host       = 'email-smtp.ap-south-1.amazonaws.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'AKIAZB4WVENVZ773ONVF';
        $mail->Password   = 'BLDqOsL9LkOKnY6n4coXRFsrXNq66C9xLDlsaCzasGEG';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->setFrom('dev@lastingerp.com','lerp');

        // foreach($emails as $email)
        // {
        //     pre($email); die;
        //    $mail->addAddress($email, '');
        // }
        //$mail->addAddress('princy@lastingerp.com','');
        $mail->addAddress($emails,'');
        $mail->isHTML(true);
        $mail->isHTML(true);
        $mail->Body = 'Material Defected Report';
        $mail->Subject = 'Material Defected Report';
        $mail->addAttachment($pdfFilePath,'Inventory Reports','base64','application/pdf');
        $mail->send();
        if($mail->send()){
            // redirect(base_url() . 'inventory/inventory_setting', 'refresh');
            // $this->session->set_flashdata('message', 'Report Sand Successfully');
           // echo'ok'; die;
       }else{
            echo 'Mailer error: ' . $mail->ErrorInfo;

        }
    }



	public function sellingPriceHistory($id, $salesPrice){
		 $material_type_id = $id;

        $existSalesPrice = $this->purchase_model->getSalePrice('material_old_price','material_type_id',$material_type_id);

        if(!empty($existSalesPrice)){
               foreach ($existSalesPrice as  $existSalesPricevalue) {
                      $salePriceNew = $existSalesPricevalue['new_sales_price'];
                      if($salePriceNew==$salesPrice){
                  return $insertSalesPrice='';
        
                      }else{
						$data['material_type_id']=$id;
						$data['old_sales_price']=$salePriceNew;
						$data['new_sales_price']=$salesPrice;
						$data['created_by']=$_SESSION['loggedInUser']->id;
						// pre($data);die();
                        $insertSalesPrice = $this->purchase_model->insert_tbl_data('material_old_price', $data);
						return $insertSalesPrice;
                      }
               }
        }else{
            $data['material_type_id']=$id;
            $data['old_sales_price']=$salesPrice;
            $data['new_sales_price']=$salesPrice;
            $data['created_by']=$_SESSION['loggedInUser']->id;
             // pre($data);die('w');
            $insertSalesPrice = $this->purchase_model->insert_tbl_data('material_old_price', $data);
            return $insertSalesPrice;
		
		
		
    }
    }



} //Main
