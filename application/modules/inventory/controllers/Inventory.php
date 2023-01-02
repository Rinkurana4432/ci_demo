<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Inventory extends ERP_Controller {
    public function __construct() {
        parent::__construct();
        is_login();
        /*$this->settings['parent_menu'] = 'setup';
         $this->settings['active_menu'] = 'setup';    */
        $this->load->library(array('form_validation'));
        $this->load->helper('inventory/inventory');
        $this->load->model('inventory_model');
        $this->load->model('production/production_model');
        $this->load->model('purchase/purchase_model');
        $this->settings['css'][] = 'assets/plugins/morris.js/morris.css';
        $this->settings['css'][] = 'assets/plugins/iCheck/skins/flat/green.css';
        $this->settings['css'][] = 'assets/plugins/bootstrap-tagmanager/tagmanager.css';
        $this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
        $this->settings['css'][] = 'assets/modules/inventory/css/style.css';
        $this->settings['css'][] = 'assets/plugins/switchery/dist/switchery.min.css';
        $this->scripts['js'][] = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->scripts['js'][] = 'assets/plugins/iCheck/icheck.min.js';
        $this->scripts['js'][] = 'assets/plugins/Chart.js/dist/Chart.min.js';
        $this->scripts['js'][] = 'assets/plugins/raphael/raphael.min.js';
        $this->scripts['js'][] = 'assets/plugins/morris.js/morris.min.js';
        $this->scripts['js'][] = 'assets/plugins/bootstrap-tagmanager/tagmanager.js';
        $this->scripts['js'][] = 'assets/plugins/bootstrap-taginput/tagsinput/bootstrap-tagsinput.js';
        $this->scripts['js'][] = 'assets/plugins/bootstrap-typehead/bootstrap3-typeahead.js';
        $this->scripts['js'][] = 'assets/plugins/switchery/dist/switchery.min.js"';
        $this->scripts['js'][] = 'assets/plugins/echarts/dist/echarts.min.js';
        $this->scripts['js'][] = 'assets/modules/inventory/js/script.js';
        $this->scripts['js'][] = 'assets/modules/inventory/js/scriptMultisaleOrder.js';
        $this->companyId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;

        //error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $CI =& get_instance();
        $CI->createTableColumn('work_in_process_material','npdm',"VARCHAR(255) NULL DEFAULT NULL AFTER  location");
        $CI->createTableColumn('work_in_process_material','machine_name',"VARCHAR(255) NULL DEFAULT NULL AFTER npdm");
        $CI->createTableColumn('work_in_process_material','required_quantity',"VARCHAR(255) NULL DEFAULT NULL AFTER machine_name");
        $CI->createTableColumn('work_in_process_material','issued_quantity',"VARCHAR(255) NULL DEFAULT NULL AFTER required_quantity");

        $CI->createTableColumn('work_in_process_material','Storage',"VARCHAR(255) NULL DEFAULT NULL AFTER location");
        $CI->createTableColumn('work_in_process_material','RackNumber',"VARCHAR(255) NULL DEFAULT NULL AFTER location");

        $CI->createTableColumn('work_in_process_material','lot_id',"INT(11) NOT NULL DEFAULT '0'  AFTER location");


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

    public function index() {
        $this->settings['module_title'] = 'Users';
        $this->data['materials'] = $this->inventory_model->get_data('material', array('created_by_cid' => $this->companyId));
        $this->_render_template('materials/index', $this->data);
    }
    /***********************************************************************  MATERIALDATA  **************************************/
    /* Main Function to fetch all the listing of material */
    public function materials() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('materials', base_url() . 'materials');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Materials';
			$staticCompanyID = 1;
        $whereMaterialType = "(created_by_cid ='" . $staticCompanyID . "' OR created_by_cid =0) AND status = 1";
        $this->data['mat_type'] = $this->inventory_model->get_filter_details('material_type', $whereMaterialType);
		
        /*******************date range filter********************/
        if (isset($_GET['start']) != '' && $_GET['end'] != '' && isset($_GET["ExportType"]) == '' && isset($_GET['favourites'])== '') {
            $whereActive = array('material.created_date >=' => $_GET['start'], 'material.created_date <=' => $_GET['end'], 'material.created_by_cid' => $staticCompanyID, 'non_inventry_material !=' => 1);
            $whereInactive = array('material.created_date >=' => $_GET['start'], 'material.created_date <=' => $_GET['end'], 'material.created_by_cid' => $staticCompanyID, 'status' => 0);
            $whereNonInvntry = array('material.created_date >=' => $_GET['start'], 'material.created_date <=' => $_GET['end'], 'material.created_by_cid' => $staticCompanyID, 'non_inventry_material' => 1);
        } elseif (!empty($_GET['material_type']) && $_GET['material_type'] != ''  && $_GET['sub_type'] != '' && isset($_GET['favourites'])== '') { //filter for dropdown select
            $whereActive = "created_by_cid = " . $staticCompanyID . " AND  (material_type_id ='" . $_GET['material_type'] . "' AND sub_type ='" . $_GET['sub_type'] . "' AND  status = '1' AND  non_inventry_material != 1)";
            $whereInactive = "created_by_cid = " . $staticCompanyID . " AND  (material_type_id ='" . $_GET['material_type'] . "' AND sub_type ='" . $_GET['sub_type'] . "' AND  status = '0')";
            $whereNonInvntry = "created_by_cid = " . $staticCompanyID . " AND  (material_type_id ='" . $_GET['material_type'] . "' AND sub_type ='" . $_GET['sub_type'] . "' AND  status = '1') AND non_inventry_material = 1";
        }
        /*based on export apply filter*/
        elseif (isset($_GET["ExportType"])!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['material_type']== '' && $_GET['favourites'] == '') {
            $whereActive = array('material.created_by_cid' => $staticCompanyID, 'non_inventry_material !=' => 1);
            $whereInactive = array('material.created_by_cid' => $staticCompanyID, 'status' => 0);
            $whereNonInvntry = array('material.created_by_cid' => $this->companyId, 'non_inventry_material' => 1);
        } elseif (isset($_GET["ExportType"])!='' && $_GET['start']!= '' && $_GET['end']!= '' && $_GET['material_type']== '' && $_GET['favourites'] == '') {
             $whereActive = array('material.created_date >=' => $_GET['start'], 'material.created_date <=' => $_GET['end'], 'material.created_by_cid' => $staticCompanyID, 'non_inventry_material !=' => 1);
            $whereInactive = array('material.created_date >=' => $_GET['start'], 'material.created_date <=' => $_GET['end'], 'material.created_by_cid' => $staticCompanyID, 'status' => 0);
            $whereNonInvntry = array('material.created_date >=' => $_GET['start'], 'material.created_date <=' => $_GET['end'], 'material.created_by_cid' => $staticCompanyID, 'non_inventry_material' => 1);
        } elseif (isset($_GET["ExportType"])!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['material_type'] == '' && $_GET['favourites'] != '') {
            $whereActive = array('created_by_cid' => $staticCompanyID, 'status' => 1, 'non_inventry_material!=' => 1, 'favourite_sts' => 1);
            $whereNonInvntry = array('created_by_cid' => $staticCompanyID, 'non_inventry_material' => 1, 'favourite_sts' => 1);
            $whereInactive = array('created_by_cid' => $staticCompanyID, 'status' => 0, 'favourite_sts' => 1);
           
        } elseif (isset($_GET["ExportType"])!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['material_type'] != '' && $_GET['sub_type'] != '' && $_GET['favourites'] == '') {
            $whereActive = "created_by_cid = " . $staticCompanyID . " AND  (material_type_id ='" . $_GET['material_type'] . "' AND sub_type ='" . $_GET['sub_type'] . "' AND  status = '1' AND  non_inventry_material != 1)";
            $whereInactive = "created_by_cid = " . $staticCompanyID . " AND  (material_type_id ='" . $_GET['material_type'] . "' AND sub_type ='" . $_GET['sub_type'] . "' AND  status = '0')";
            $whereNonInvntry = "created_by_cid = " . $staticCompanyID . " AND  (material_type_id ='" . $_GET['material_type'] . "' AND sub_type ='" . $_GET['sub_type'] . "' AND  status = '1') AND non_inventry_material = 1";
        } elseif(empty($_GET['tab'])) {
            $whereActive = array('created_by_cid' => $staticCompanyID, 'status' => 1, 'non_inventry_material!=' => 1);
            $whereInactive = array('created_by_cid' => $staticCompanyID, 'status' => 0);
            $whereNonInvntry = array('created_by_cid' => $staticCompanyID, 'non_inventry_material' => 1);
        } elseif(!empty($_GET['tab']) == 'active_mat') {
            $whereActive = array('created_by_cid' => $staticCompanyID, 'status' => 1, 'non_inventry_material!=' => 1);
            $whereInactive = array('created_by_cid' => $staticCompanyID, 'status' => 0);
            $whereNonInvntry = array('created_by_cid' => $staticCompanyID, 'non_inventry_material' => 1);
        } elseif(!empty($_GET['tab']) == 'inactive_mat') {
            $whereActive = array('created_by_cid' => $staticCompanyID, 'status' => 1, 'non_inventry_material!=' => 1);
            $whereInactive = array('created_by_cid' => $staticCompanyID, 'status' => 0);
            $whereNonInvntry = array('created_by_cid' => $staticCompanyID, 'non_inventry_material' => 1);
        } elseif (!empty($_GET['tab']) == 'noninvntry_mat') {
            $whereActive = array('created_by_cid' => $staticCompanyID, 'status' => 1, 'non_inventry_material!=' => 1);
            $whereInactive = array('created_by_cid' => $staticCompanyID, 'status' => 0);
            $whereNonInvntry = array('created_by_cid' => $staticCompanyID, 'non_inventry_material' => 1);
        }
        if (isset($_GET['favourites'])!='' && isset($_GET['ExportType'])=='') {
            if ($_GET['tab'] == 'active_mat') {
                $whereActive = array('created_by_cid' => $staticCompanyID, 'status' => 1, 'non_inventry_material!=' => 1, 'favourite_sts' => 1);
            } elseif ($_GET['tab'] == 'noninvntry_mat') { //echo 'inv';
                $whereNonInvntry = array('created_by_cid' => $staticCompanyID, 'non_inventry_material' => 1, 'favourite_sts' => 1);
            } elseif ($_GET['tab'] == 'inactive_mat') {
                $whereInactive = array('created_by_cid' => $staticCompanyID, 'status' => 0, 'favourite_sts' => 1);
            } else {
                $whereActive = array('created_by_cid' => $staticCompanyID, 'status' => 1, 'non_inventry_material!=' => 1, 'favourite_sts' => 1);
            }
            
        }
       //Search
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $materialName=getNameById('material',$search_string,'material_name');
            $material_type_tt = getNameById('material_type',$search_string,'name');
        if($material_type_tt->id !=''){
                $where2 = "material.material_type_id = '" . $material_type_tt->id . "'";
            }elseif($materialName->id != '' && $material_type_tt->id ==''){
                $where2 = "material.id= '" . $materialName->id . "'" ;
                //$where2="material.material_name Like '"%.$_GET['search'].%"'";
            }else{
            $where2 ="(material.mat_sku = '".$search_string ."' or material.id = '".$search_string ."' or material.material_code ='" . $search_string ."')";
            }
            redirect("inventory/materials/?search=$search_string");
        } elseif(isset($_GET['search']) && $_GET['search'] != '') {
            $where2=array();
            $material_type_tt = getNameBySearch('material_type',$_GET['search'],'name');
            foreach($material_type_tt as $materialtypedata){//pre($materialtypedata['id']);
               $where2[]="material.material_type_id ='".$materialtypedata['id']."'" ;
            }
            //print_r($where2);
            if(sizeof($where2)!=''){
            $where2=implode("||",$where2);
            }else{
            $where2 ="(material.mat_sku ='".$_GET['search']."' or material.material_code ='".$_GET['search']."' or material_name like '%".$_GET['search']."%' or material.id ='" . $_GET['search']."')";
            }
            /*if(isset($material_type_tt->id)!=''){
            $where2 = "material.material_type_id = '" . $material_type_tt->id . "'";
            }/*elseif(isset($materialName->id)!= '' && isset($material_type_tt->id)==''){
            echo    $where2="material.material_name Like '%'".$_GET['search']."'%'";
            //$where2 = "material.id= '" . $materialName->id . "'" ;
            }else{
            $where2 = "material.material_code ='".$_GET['search']."' or material.material_name Like '%".$_GET['search']."%' or material.id ='" . $_GET['search']."'";
            }*/
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //  pre($whereNonInvntry);
          if(@$_GET['tab'] == 'active_mat' && $_GET['tab']!= 'inactive_mat' && $_GET['tab']!= 'noninvntry_mat') {
            $rows = $this->inventory_model->num_rows('material', $whereActive, $where2);
        } elseif(@$_GET['tab']== 'inactive_mat' && $_GET['tab']!= 'active_mat' && $_GET['tab']!= 'noninvntry_mat') {
            $rows = $this->inventory_model->num_rows('material', $whereInactive, $where2);
        } elseif(@$_GET['tab'] == 'noninvntry_mat' && $_GET['tab']!= 'inactive_mat' && $_GET['tab']!= 'active_mat') {
            $rows = $this->inventory_model->num_rows('material', $whereNonInvntry, $where2);
        } else {
            $rows = $this->inventory_model->num_rows('material', $whereActive, $where2);
        }
        //$this->inventory_model->num_rows('material',$whereMaterialType,$where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "inventory/materials/";
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

        if (@$_GET['tab'] == 'active_mat' && $_GET['tab'] != 'inactive_mat' && $_GET['tab']!= 'noninvntry_mat') {
            $this->data['materials'] = $this->inventory_model->get_data1('material', $whereActive, $config["per_page"], $page, $where2, $order, $export_data);

        } elseif (@$_GET['tab'] == 'inactive_mat' && $_GET['tab'] != 'active_mat' && $_GET['tab']!= 'noninvntry_mat') {
            $this->data['inactive_material'] = $this->inventory_model->get_data1('material', $whereInactive, $config["per_page"], $page, $where2, $order, $export_data);
        } elseif (@$_GET['tab'] == 'noninvntry_mat' && $_GET['tab'] != 'active_mat' && $_GET['tab']!= 'inactive_mat') {
            $this->data['non_inventry_mat'] = $this->inventory_model->get_data1('material', $whereNonInvntry, $config["per_page"], $page, $where2, $order, $export_data);
        } else {
            $this->data['materials'] = $this->inventory_model->get_data1('material', $whereActive, $config["per_page"], $page, $where2, $order, $export_data);
            $this->data['inactive_material'] = $this->inventory_model->get_data1('material', $whereInactive, $config["per_page"], $page, $where2, $order, $export_data);
            $this->data['non_inventry_mat'] = $this->inventory_model->get_data1('material', $whereNonInvntry, $config["per_page"], $page, $where2, $order, $export_data);
        }
        if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }
        if($end>$config['total_rows'])
        {
        $total=$config['total_rows'];
        }else{
            $total=$end;
        }
        $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';

        $this->_render_template('materials/index', $this->data);
    }
    /*material_edit code*/
    public function material_edit() {
        $this->breadcrumb->add('Inventory', base_url() . 'Add Product');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $id = isset($_GET['id']) ? $_GET['id']:'';
        if ($id != '') {
            permissions_redirect('is_edit');
             $this->settings['pageTitle']   = 'Edit Products';
        } else {
            permissions_redirect('is_add');
             $this->settings['pageTitle']   = 'Add Products';
        }
        $this->data['materials_type'] = $this->inventory_model->get_data('material_type');
        $where = array('u_id' => $_SESSION['loggedInUser']->u_id);
        $this->data['company_address'] = $this->inventory_model->get_data('company_detail', $where);
        $this->data['tags_data'] = $this->inventory_model->get_tags_data('tags_in', 'rel_id', $id, 'rel_type'); //get tags values from tags table
		//$matProductId = $this->inventory_model->get_data_byId('material', 'id', $id);
		//$this->data['imageUpload'] = $this->inventory_model->get_image_by_materialId('attachments', 'rel_id', $matProductId->product_code);
		$this->data['imageUpload'] = $this->inventory_model->get_image_by_materialId('attachments', 'rel_id', $id);

		//get Multiple images based on id
		
		
		
		
		// $this->data['imageUpload'] = $this->inventory_model->get_image_by_materialId('attachments', 'rel_id', $id); //get Multiple images based on id
        $this->data['materials'] = $this->inventory_model->get_data_byId('material', 'id', $id);
        if (!empty($id)) {
          $this->data['locations'] = $this->inventory_model->get_data_byLocationId('mat_locations', 'material_name_id', $id);
         }else{
          $this->data['locations']="";
          }
        $this->data['order'] = $this->inventory_model->get_data_byId('purchase_order', 'id', $id);
        $this->data['sale_order'] = $this->inventory_model->get_data_byId('sale_order', 'id', $this->input->post('id'));
        $this->_render_template('materials/edit', $this->data);
    }
    /*material_view code*/
    public function material_view() {
        $id = $_POST['id'];
        $this->data['material_type'] = $this->inventory_model->get_data('material_type');
        $this->data['materialSalesPrice'] = $this->inventory_model->getSalePrice('material_old_price','material_type_id', $id);
        $this->data['imageUploads'] = $this->inventory_model->get_image_by_materialId('attachments', 'rel_id', $id); //get Multiple images based on id
        $this->data['materialView'] = $this->inventory_model->get_data_byId('material', 'id', $id);
         $this->data['locations'] = $this->inventory_model->get_data_byLocationId('mat_locations', 'material_name_id', $id);
        $this->data['materialhistory'] = $this->inventory_model->getMatrial_history($id);
        $this->load->view('materials/view', $this->data);
    }

    /* Function to SAVE  MATERIAL*/
   public function saveMaterial(){
	        // pre($_POST);die();
         $source_location = count($_POST['location']);
	   
        if ($source_location > 0) {
            $arr = [];
            $i = 0;
			//, 'lot_no' => $_POST['lotno'][$i]
            while ($i < $source_location) {
                $id_loc = !empty($_POST['id_loc'][$i]) ? $_POST['id_loc'][$i]:'';
                $jsonArrayObject = (array('id_loc' => $id_loc, 'location' => $_POST['location'][$i], 'Storage' => $_POST['storage'][$i], 'RackNumber' => isset($_POST['rackNumber'][$i]) ? $_POST['rackNumber'][$i]:0, 'quantity' => $_POST['quantityn'][$i], 'Qtyuom' => $_POST['uom']));
                $arr[] = $jsonArrayObject;
                $arr[$i] = $jsonArrayObject;
                $i++;
            }
            $sourceAdd_array = json_encode($arr);
        } else {
            $sourceAdd_array = '';
        }
			$sourceAddressArray = json_decode($sourceAdd_array);


		
        #sale purchase data in encoded format
        $route = ((!empty($_POST['route'])) ? json_encode($_POST['route']) : '');
        $sale_purchase = ((!empty($_POST['sale_purchase'])) ? json_encode($_POST['sale_purchase']) : '');

        if ($this->input->post()){
            $required_fields = array('material_name', 'material_code');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0){
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $aliasArray = '';
                if(!empty($_POST['detors_name']) && !empty($_POST['aliasName'])){
                    $alias = [];
                    for($al = 0; $al < count($_POST['detors_name']);$al++) {
                        $alias[] = ['customer_id' => $_POST['detors_name'][$al],'alias' => $_POST['aliasName'][$al] ];
                    }
                    $data['MatAliasName'] = json_encode($alias);
                }



                $id = $data['id'];
                $data['sale_purchase'] = $sale_purchase;    #sale purchase value
                if(isset($_POST['tags_data']) && !empty($_POST['tags_data'])){
                    $data['tags'] =  json_encode($_POST['tags_data']);
                }else{
                    $data['tags'] = '[]';
                }
                $data['route'] = $route;

                $data['created_by_cid'] = $this->companyId;
                $standard_packing = $_POST['standard_packing'];
                $counts = count($_POST['packing_mat']);
                $packing_arr = array();
                $j = 0;
                while ($j < $counts) {
                    $packing_arr[$j]['packing_mat'] = $_POST['packing_mat'][$j];
                    $packing_arr[$j]['packing_qty'] = $_POST['packing_qty'][$j];
                    $packing_arr[$j]['packing_weight'] = $_POST['packing_weight'][$j];
                    $packing_arr[$j]['packing_cbf'] = $_POST['packing_cbf'][$j];
                    $j++;
                }
                $data['standard_packing'] = $standard_packing;
                $data['packing_data'] = json_encode($packing_arr);
                $usersWithViewPermissions = $this->inventory_model->get_dataw('permissions', array('is_view' => 1, 'sub_module_id' => 7));
                if($id && $id != ''){
                    #Update material Data
                    // if( getSingleAndWhere('product_code','material',['id' => $id ]) != str_replace(" ","",$data['product_code']) ){
                        // if( findExistRow('material',['product_code' => str_replace(" ","",$data['product_code'])]) > 0 ){
                            // $this->session->set_flashdata('message','Product Code already exist');
                            // redirect("inventory/material_edit?id={$id}");
                        // }
                    // }
					
					// pre($data);die();
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $success = $this->inventory_model->update_data('material', $data, 'id', $id);
                     if($id){
                     $this->sellingPriceHistory($id, $_POST['sales_price']);

                    }
                    #if material is used anywhere in module it update the used Id status at the time of edit
                    if ($data['material_type_id'] != '') updateUsedIdStatus('material_type', $data['material_type_id']);

                    #Inventory Flow - Data update
                    foreach ($sourceAddressArray as $addArray){
                        $this->material_crud_inOut($_POST['id'], $_POST['material_type_id'], $addArray);
                    }
                    if($success){
                        $data['message'] = "Material updated successfully";
                        logActivity('Material Updated', 'material', $id);
                        if (!empty($usersWithViewPermissions)){
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'Material updated', 'message' => 'Material id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1){
                            pushNotification(array('subject' => 'Material updated', 'message' => 'Material id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                        }
                        $this->session->set_flashdata('message', 'Material Updated successfully');
                    }
                } else {
                    #Insert material Data
                    // if( findExistRow('material',['product_code' => str_replace(" ","",$data['product_code'])]) > 0 ){
                        // $this->session->set_flashdata('message','Product Code already exist');
                        // redirect('inventory/material_edit?id');
                    // }
					$data['closing_balance'] = $_POST['opening_balance'];
					$where = array('material_name' => $data['material_name']);
					$ChkMaterial = $this->inventory_model->get_data('material', $where);
				if(empty($ChkMaterial)){
                    $id = $this->inventory_model->insert_tbl_data('material', $data);
                    if($id){
						$this->sellingPriceHistory($id, $_POST['sales_price']);

                    }
                    $opening_balance = $data['opening_balance'];

                    if($opening_balance > 0){

                        if($data['inventory_loc'] == 1){
                            #Inventory Flow - Data saved
                            foreach ($sourceAddressArray as $addArray){
                                $this->material_crud_inOut($id, $_POST['material_type_id'], $addArray);
                            }
                        }else{
                            $compny_dtl =  $this->inventory_model->get_data('company_address',array('created_by_cid'=> $this->companyId));
                            $insertDatalocationloc = array();
                            $insertDatalocationloc['material_type_id'] = $_POST['material_type_id'];
                            $insertDatalocationloc['material_name_id'] = $id;
                            $insertDatalocationloc['location_id'] = $compny_dtl[0]['id'];
                            $insertDatalocationloc['Storage'] = 'N/A';
                            $insertDatalocationloc['RackNumber'] = '-';
                            $insertDatalocationloc['quantity'] = $data['opening_balance'];
                            $insertDatalocationloc['Qtyuom'] = $_POST['Qtyuom'];
                            $insertDatalocationloc['lot_no'] = '';
                            $insertDatalocationloc['balance'] = $data['opening_balance'];
                            $insertDatalocationloc['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                            //$id1 = $this->inventory_model->insert_tbl_data('mat_locations', $insertDatalocationloc);
                        }
                    }
					
					
					//die();

                    #if material is used anywhere in module it update the used Id status ath the time of insert
                    if ($data['material_type_id'] != '') updateUsedIdStatus('material_type', $data['material_type_id']);
                    if ($id){
                        $data['message'] = "Material inserted successfully";
                        logActivity('material inserted', 'material', $id);
                        if (!empty($usersWithViewPermissions)){
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'New Material created', 'message' => 'New material is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1){
                            pushNotification(array('subject' => 'New Material created', 'message' => 'New material is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                        }
                        $this->session->set_flashdata('message', 'Material inserted successfully');
                    }
					
				}else{
					
					$this->session->set_flashdata('message', 'Material Already  Added');
					redirect(base_url() . 'inventory/materials', 'refresh');
					
				}	
		}
                if($id){
                    #saved multiple images in attachment table
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
							$newname = str_replace(' ', '_', $newname);;
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
						// pre($image_array);die();
                        if (!empty($image_array)) {
                            #Insert multiple file information into the database
                            $material_image = $this->inventory_model->insert_attachment_data('attachments', $image_array, 'material');
                        }
                    }
                    #Manage tags data
                    /* if (!empty($_POST['tags'])) {
                        $tags = $_POST['tags'];
                        $data['tags'] = $_POST['tags'];
                        if(isset($data['tags']) && !empty($data['tags'])){
                            $res = $this->inventory_model->insert_tags_data($id, "material", $data['tags']);
                        }
                    } */
                    if ($_POST['inventory_listing_mat_side'] == ''){
						
                        redirect(base_url() . 'inventory/materials', 'refresh');
                        // redirect($_SERVER['HTTP_REFERER']);
                    } else {
						
                        redirect(base_url() . 'inventory/inventory_listing_and_adjustment', 'refresh');
                    }
                }
            }
        }
    }

    /*********************************************************************************/
    # Inventory material CRUD In-Out Common Function
    # Required Param.: Meterial Id, Material Type and addArray as Object/Array
    # Object keys:- {id_loc, location, Storage, RackNumber, quantity, Qtyuom, lot_no}
    # Note:- id_loc => mat_locations's exist id
    /********************************************************************************/
	public function material_crud_inOut($materialId, $material_type, $addArray){
		
		
		
		
		if(!empty($addArray)){
			$addArray = is_array($addArray) ? (object)$addArray:$addArray;
			$i = 0;
			$arr = array();
			$arr[] =  json_encode(array(array('location' => $addArray->location,'Storage' => $addArray->Storage , 'RackNumber' => $addArray->RackNumber , 'quantity' => $addArray->quantity , 'Qtyuom' => $addArray->Qtyuom)));
			
			$inventoryFlowDataArray = array();


			#Check storage location exist or not   
			if(!empty($addArray->id_loc)){
				$exist_location = $this->inventory_model->get_data('mat_locations', array('id' => $addArray->id_loc));
			}else{
				$exist_location = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $materialId, 'material_type_id' => $material_type, 'location_id' => $addArray->location));
			}
			
			$yu = getNameById_mat('mat_locations',$materialId,'material_name_id');
			
			$sum = 0;
			if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
			$closing_blnc = $sum+$addArray->quantity;
			
			
			if(!empty($exist_location)){
				foreach($exist_location as $eldate){	
					$updateDatalocation = $eldate;
					
					$existQty = $eldate['quantity'];					
					if($existQty != $addArray->quantity){

						#opening_blnc
						$inventoryFlowDataArray['opening_blnc'] = $sum;
								
						if($existQty > $addArray->quantity){
							$removeQuantity = $existQty - $addArray->quantity;
							$closing_blnc = $sum - $removeQuantity;
													
							#material_out
							$inventoryFlowDataArray['material_out'] = $removeQuantity;
							$updateDatalocation['quantity'] = $addArray->quantity; 
						}
						else{
							$addedQuantity = $addArray->quantity - $existQty;
							$closing_blnc = $sum + $addedQuantity;
							
							#material_in
							$inventoryFlowDataArray['material_in'] = $addedQuantity;
							$updateDatalocation['quantity'] = $addArray->quantity; 
						}	
						#inventoryFlowDataArray - Exist location and rack updated
						$inventoryFlowDataArray['closing_blnc'] = $closing_blnc;
						$inventoryFlowDataArray['ref_id'] = $updateDatalocation['id'];
						$inventoryFlowDataArray['through'] = 'Material Quantity Updated'; 
						$inventoryFlowDataArray['current_location'] = $arr[$i];							
					}	
					
					$updateDatalocation['location_id'] = $addArray->location;
					$updateDatalocation['Qtyuom'] = $addArray->Qtyuom; 
					// pre($updateDatalocation);die();
					$updateSuccess = $this->inventory_model->update_single_field('mat_locations', $updateDatalocation);
					//$this->purchase_model->updateMatLocationQtyifDuplicate($addArray->lot_no);
				}
			}
			
			#New location Added
			if(empty($exist_location))
			{           
				$insertDatalocation['material_type_id'] = $material_type;
				$insertDatalocation['material_name_id'] = $materialId;
				$insertDatalocation['location_id'] = $addArray->location;
				$insertDatalocation['Storage'] = $addArray->Storage;
				$insertDatalocation['RackNumber'] = $addArray->RackNumber;
				$insertDatalocation['quantity'] = $addArray->quantity;
				$insertDatalocation['lot_no'] = $addArray->lot_no;
				$insertDatalocation['Qtyuom'] = $addArray->Qtyuom;
				$insertDatalocation['created_by_cid'] = isset($_SESSION['loggedInUser']->c_id) ? $_SESSION['loggedInUser']->c_id:0;
				$insertSuccess = $this->inventory_model->insert_tbl_data('mat_locations', $insertDatalocation);
				
				#inventoryFlowDataArray - For new location
				$inventoryFlowDataArray['material_in'] = $addArray->quantity;
				$inventoryFlowDataArray['opening_blnc'] = $sum;
				$inventoryFlowDataArray['closing_blnc'] = $closing_blnc;
				$inventoryFlowDataArray['ref_id'] = $insertSuccess;  
				$inventoryFlowDataArray['through'] = 'New material Added';
				$inventoryFlowDataArray['new_location'] = $arr[$i]; 
			}
			$inventoryFlowDataArray['current_location'] = $arr[$i];	
			
			$inventoryFlowDataArray['material_type_id'] = $material_type;
			$inventoryFlowDataArray['material_id'] = $materialId;
			$inventoryFlowDataArray['uom'] = $addArray->Qtyuom;
			$inventoryFlowDataArray['created_by'] = isset($_SESSION['loggedInUser']->id) ? $_SESSION['loggedInUser']->id:0;
			$inventoryFlowDataArray['created_by_cid'] = $this->companyId; 
			
			// pre($inventoryFlowDataArray);die;
			if(isset($inventoryFlowDataArray['material_in']) != 0 || isset($inventoryFlowDataArray['material_out']) != 0){
				$this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);
			} 
			#Update lot balance materials
			$this->material_Lot_inOut($materialId);
            #Update closing balance
            $this->update_closing_balance($materialId);
		}
	}
	
	/**** Material Lot In-Out common function ****/
	public function material_Lot_inOut($materialId){
        //Lot wise quantity update
		$lotdetails = $this->inventory_model->get_data('lot_details', array('mat_id' => $materialId));
		if(!empty($lotdetails)){
			foreach($lotdetails as $lotdt){
				$lot_no = $lotdt['id'];
				$totalQty = 0;
				$mtlocdt = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $materialId, 'lot_no' => $lot_no));
				if(!empty($mtlocdt)){ 
					foreach($mtlocdt as $mld) {
						$totalQty += $mld['quantity'];
					}
				}                
				$lotdt['quantity'] = $totalQty;
				$this->inventory_model->update_single_field_lotdetails('lot_details', $lotdt, $lot_no);                
			}            
		}         
	}
   

    public function uploadFile($fielName) {
        $filename = $_FILES[$fielName]['name'];
        $tmpname = $_FILES[$fielName]['tmp_name'];
        $exp = explode('.', $filename);
        $ext = end($exp);
        $newname = $exp[0] . '_' . time() . "." . $ext;
		$newname = str_replace(' ', '_', $newname);;
        $config['upload_path'] = 'assets/modules/inventory/uploads/';
        $config['upload_url'] = base_url() . 'assets/modules/inventory/uploads/';
        $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
        $config['max_size'] = '2000000';
        $config['file_name'] = $newname;
        $this->load->library('upload', $config);
        move_uploaded_file($tmpname, "assets/modules/inventory/uploads/" . $newname);
        return $newname;
    }
    /* change status function when click on toggle in material listing*/
    public function change_status() {
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status = (isset($_POST['gstatus']) && $_POST['gstatus'] == 1) ? '1' : '0';
        $status_data = $this->inventory_model->change_status_toggle($id, $status);
        $usersWithViewPermissions = $this->inventory_model->get_dataw('permissions', array('is_view' => 1, 'sub_module_id' => 7));
        if (!empty($usersWithViewPermissions)){
        foreach ($usersWithViewPermissions as $userViewPermission) {
        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
        pushNotification(array('subject' => 'Material status', 'message' => 'Material status updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $userViewPermission['user_id'], 'to_id' => $userViewPermission['user_id'], 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
        }
        }
        }
        if ($_SESSION['loggedInUser']->role != 1){
        pushNotification(array('subject' => 'Material status', 'message' => 'Material status updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
        }
        pushNotification(array('subject' => 'Material status', 'message' => 'Material status updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));

        $email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
        <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
        <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi Test</p>
        <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Material status Updated.</p>
        <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>
        </td>
        </tr>
        </table>
        </td>
        </tr>';
        //send_mail_notification($_SESSION['loggedInUser']->email, 'Notification Email For Material status Updated', $email_message);
        if($_SESSION['loggedInUser']->c_id){
        $select = "email";
        $where = 'c_id='.$_SESSION['loggedInUser']->c_id.' AND role=1';

        $get_admin = $this->inventory_model->admin_email_data('user',$select, $where);
        foreach ($get_admin as $key => $value) {
        //send_mail_notification($value['email'], 'Notification Email For Material status Updated', $email_message);
        } }

        echo json_encode($status_data);
    }
    /*Delete functonality to delet the material which is not used any where */
    public function delete_material($id = '') {
        if (!$id) {
            redirect('inventory/materials', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->inventory_model->delete_data('material', 'id', $id);
        if ($result) {
            logActivity('Material Deleted', 'material', $id);
            $usersWithViewPermissions = $this->inventory_model->get_dataw('permissions', array('is_view' => 1, 'sub_module_id' => 7));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Materials deleted', 'message' => 'Material id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-paper-plane-o'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Materials deleted', 'message' => 'Material id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-paper-plane-o'));
            }
            $this->session->set_flashdata('message', 'Material Deleted Successfully');
            $result = array('msg' => 'Material Deleted Successfully', 'status' => 'success', 'code' => 'C281', 'url' => base_url() . 'inventory/materials');
            echo json_encode($result);
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    /*delet multiple add images of material*/
    public function delete_images($id = '', $materialId = '') {
        if (!$id) {
            redirect('materials', 'refresh');
        }
        $result = $this->inventory_model->delete_data('attachments', 'id', $id);
        if ($result) {
            logActivity('Images  Deleted', 'material', $id);
            $this->session->set_flashdata('message', 'Images Deleted Successfully');
            // $result = array('msg' => 'Images Deleted Successfully', 'status' => 'success', 'code' => 'C300', 'url' => base_url() . 'inventory/materials/edit/' . $materialId);
             $result = array('msg' => 'Images Deleted Successfully', 'status' => 'success', 'code' => 'C300', 'url' => base_url() . 'inventory/materials/');
            echo json_encode($result);
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C173'));
        }
    }
    /*get list of addresses in material add/edit page */
    function getLocationArea($id = '') {
        $id = $_POST['id'];
        //$Location_Area = $this->inventory_model->get_data_byLcoationArea('location_settings', $id);
        $Location_Area = $this->inventory_model->get_data_byLcoationArea('company_address', $id);
        //pre($Location_Area);die();
        $get_area = $Location_Area[0]['area'];
        $dataArray = json_decode($get_area);
        $AreaArray = array();
        $i = 0;
        if (!empty($dataArray)) {
            foreach ($dataArray as $areaName) {
                $AreaArray[$i]['id'] = $areaName->area;
                $i++;
            }
        }
       # pre($AreaArray);
       # die;

        echo json_encode($AreaArray);
    }
    /*chage prefix in edit/add of material through jquery*/
    public function getprefix_and_subType($id = '') {
        $id = $_POST['material_id'];
        $materialPrefix = $this->inventory_model->get_prefix_and_subType_data('material_type', $id);
        echo json_encode($materialPrefix);
    }
    /*****featured imaage add using crop functionality ***********/
    public function uploadImageByAjax() {
        if (isset($_POST["image"])) {
            $data = $_POST["image"];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $exp = explode('.', $_POST["uploaded_image_name"]);
            $imageName = $exp[0] . 'Material' . time() . "." . $exp[1];
            file_put_contents('assets/modules/inventory/uploads/' . $imageName, $data);
            $result = array('image' => $imageName, 'imageHtml' => '<img src="' . base_url() . 'assets/modules/inventory/uploads/' . $imageName . '" class="img-thumbnail" height="50px" width="50px"/>');
            echo json_encode($result);
        }
    }
    /********featured Image edit in material with crop**********/
    public function EditImageByAjax() {
        if (isset($_POST["image"])) {
            $data = $_POST["image"];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $exp = explode('.', $_POST["uploaded_image_name"]);
            $activityUserData = getNameById('material', $_POST["Id"], 'id');
            $nameChar = substr($activityUserData->material_name, 0, 3);
            $imageName = $exp[0] . 'Material' . time() . "." . $exp[1];
            file_put_contents('assets/modules/inventory/uploads/' . $imageName, $data);
            $result = array('image' => $imageName, 'imageHtml' => '<img src="' . base_url() . 'assets/modules/inventory/uploads/' . $imageName . '" class="img-thumbnail" />');
            echo json_encode($result);
        }
    }
    /******************************************************************************************inventory listing*******************************************************************/
    public function inventory_listing() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Inventory Listing', base_url() . 'inventory_listing');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Inventory Listing';
        // export data function
        if (isset($_POST["ExportType"])) {
            #$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id ,'status' => 1);
            $where = array('created_by_cid' => $this->companyId, 'status' => 1);
            $this->data['inventory_listing'] = $this->inventory_model->get_data('material', $where);
            $this->_render_template('inventory_listing/index', $this->data);
        }
        #$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id ,'status' => 1);
        $where = array('created_by_cid' => $this->companyId, 'status' => 1);
        $this->data['inventory_listing'] = $this->inventory_model->get_data('material', $where); //get inventory lisitng in lisitng tab
        #$where1 = array('created_by_cid' => $_SESSION['loggedInUser']->c_id );
        $where1 = array('created_by_cid' => $this->companyId);
        $this->data['material_issue'] = $this->inventory_model->get_data('work_in_process_material', $where1); //get WIP in Work in process Tab
        $this->_render_template('inventory_listing/index', $this->data);
    }
    /*inventory listing edit*/
    public function inventory_listing_edit() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['material_id'] = $id;
        $this->data['inventoryListing'] = $this->inventory_model->get_data_byLocationId('mat_locations', 'material_name_id', $id);
        //$this->data['inventoryListing'] = $this->inventory_model->get_data_byId('material','id',$id);
        $this->data['materials_type'] = $this->inventory_model->get_data('material_type'); //get material type at the time of edit
        $this->data['company_address'] = $this->inventory_model->get_data('company_detail'); // get company address at the time of edit
        //$this->load->view('inventory_listing/scrap', $this->data);
        $this->load->view('inventory_listing_and_adjustment/scrap', $this->data);
    }
    /*inventory listing stock check*/
    public function inventory_listing_stockCheck() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['inventoryListing'] = $this->inventory_model->get_data_byId('material', 'id', $id);
        $this->data['materials_type'] = $this->inventory_model->get_data('material_type');
        $this->data['company_address'] = $this->inventory_model->get_data('company_detail');
        // $this->load->view('inventory_listing/stock_check', $this->data);
        $this->load->view('inventory_listing_and_adjustment/stock_check', $this->data);
    }
    /*inventory listing consumed*/
    public function inventory_listing_consumed() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['material_id'] = $id;
        $this->data['inventoryListing'] = $this->inventory_model->get_data_byLocationId('mat_locations', 'material_name_id', $id);
        //$this->data['inventoryListing'] = $this->inventory_model->get_data_byId('material','id',$id);
        $this->data['materials_type'] = $this->inventory_model->get_data('material_type');
        $this->data['company_address'] = $this->inventory_model->get_data('company_detail');
        // $this->load->view('inventory_listing/consumed', $this->data);
        $this->load->view('inventory_listing_and_adjustment/consumed', $this->data);
    }
    /*inventory listing move*/
    public function inventory_listing_move() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['material_id'] = $id;
        $this->data['inventoryListing'] = $this->inventory_model->get_data_byLocationId('mat_locations', 'material_name_id', $id);
        //$this->data['inventoryListing'] = $this->inventory_model->get_data_byId('material','id',$id);
        $this->data['materials_type'] = $this->inventory_model->get_data('material_type');
        $where = array('u_id' => $_SESSION['loggedInUser']->u_id);
        $this->data['company_address'] = $this->inventory_model->get_data('company_detail', $where);
        // $this->load->view('inventory_listing/move', $this->data);
        $this->load->view('inventory_listing_and_adjustment/move', $this->data);
    }
    /*inventory listing half full book*/
    public function inventory_listing_halfBook() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['inventoryListing'] = $this->inventory_model->get_data_byId('material', 'id', $id);
        $this->data['materials_type'] = $this->inventory_model->get_data('material_type');
        // $this->load->view('inventory_listing/half_full_book', $this->data);
        $this->load->view('inventory_listing_and_adjustment/half_full_book', $this->data);
    }
    /*inventory listing material conversion*/
    public function inventory_listing_materialConversion(){
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['material_id'] = $id;
        $this->data['inventoryListing'] = $this->inventory_model->get_data_byLocationId('mat_locations', 'material_name_id', $id);
        #$this->data['inventoryListing'] = $this->inventory_model->get_data_byId('material', 'id', $id);
        $this->data['materials_type'] = $this->inventory_model->get_data('material_type');
        // $this->load->view('inventory_listing/material_conversion', $this->data);
        $this->load->view('inventory_listing_and_adjustment/material_conversion', $this->data);
    }

    /* Function to SAVE  inventory listing */
    public function saveInventoryListing() {
        $action_type = $_POST['action_type'];
        if ($this->input->post()) {
            $required_fields = array('uom');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                /************************************Move json data for location*******************************************/
                $source_array = '';
                $destination_array = '';
                if ($action_type == "move" || $action_type == "stock_check" || $action_type == "consumed" || $action_type == "material_conversion") {
                    $source = count($_POST['source_location']);
                    if ($source > 0) {
                        $arr1 = [];
                        $j = 0;
                        while ($j < $source) {
                            $jsonArrayObject1 = (array('source_location' => $_POST['source_location'][$j], 'source_storage' => $_POST['source_storage'][$j], 'source_rack_no' => $_POST['source_rack_no'][$j]));
                            $arr1[$j] = $jsonArrayObject1;
                            $j++;
                        }
                        $source_array = json_encode($arr1);
                    }
                }
                if ($action_type == "move" || $action_type == "material_conversion") {
                    $destination = count($_POST['location']);
                    if ($destination > 0) {
                        $arr = [];
                        $i = 0;
                        while ($i < $destination) {
                            $jsonArrayObject = (array('location' => $_POST['location'][$i], 'Storage' => $_POST['storage'][$i], 'RackNumber' => $_POST['RackNumber'][$i]));
                            $arr[$i] = $jsonArrayObject;
                            $i++;
                        }
                        $destination_array = json_encode($arr);
                    }
                }
                if ($action_type == "material_conversion") {
                    $convertedMaterial = count($_POST['converted_material_id']);
                    if ($convertedMaterial > 0) {
                        $arrConvertedMaterial = [];
                        $n = 0;
                        while ($n < $convertedMaterial) {
                            $jsonArrayMaterialConverted = (array('converted_material_id' => $_POST['converted_material_id'][$n], 'converted_quantity' => $_POST['quantity'][$n], 'converted_uom' => $_POST['converted_uom'][$n]));
                            $arrConvertedMaterial[$n] = $jsonArrayMaterialConverted;
                            $n++;
                        }
                        $materialConverted_array = json_encode($arrConvertedMaterial);
                    } else {
                        $materialConverted_array = '';
                    }
                }
                /***************************************************************** data inserted ***************************************************************************/
                $data = $this->input->post();
                $data['created_by'] = $_SESSION['loggedInUser']->id;
                #$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
                $data['created_by_cid'] = $this->companyId;
                $id = $data['id'];
                if ($action_type == 'consumed' || $action_type == 'stock_check') {
                    $data['source_location'] = $source_array;
                    $actionQty = $data['quantity'];
                } else if ($action_type == 'scrap') {
                    $actionQty = $data['quantity'];
                } else if ($action_type == 'move' || $action_type == 'material_conversion') {
                    $actionQty = $data['quantity'] != '' ? $data['quantity'] : 0;
                    $data['location'] = $destination_array;
                    $data['source_location'] = $source_array;
                    //$data['converted_material'] = $materialConverted_array!=''?$materialConverted_array:0;
                    $data['converted_material'] = (!empty($materialConverted_array)) ? $materialConverted_array : '';
                }
                /************************************************************Move insert data and update material******************************************************/
                if ($id && $id != '') {
                    /********************************************Scrap / consumed / Stock check insertion**********************************************************************/
                    if ($action_type == 'consumed' || $action_type == 'scrap' || $action_type == 'stock_check' || $action_type == 'move') {
                        if ($action_type == 'move') {
                            $data1 = array('location' => $data['location']);
                            /****************************update location in material table****************/
                            $success = $this->inventory_model->update_single_field('material', $data1, 'id', $id);
                        }
                        /*save condition for stock check*/
                        /*insert data in inventory adjustment*/
                        $insertedAdjustmentid = $this->inventory_model->insert_tbl_data('inventory_listing', $data);
                        if ($insertedAdjustmentid) {
                            $getMaterialData = $this->inventory_model->get_data_byId('material', 'id', $id);
                            if ($action_type == 'consumed') $quant = $getMaterialData->opening_balance;
                            if ($action_type == 'scrap' || $action_type == 'stock_check' || $action_type == 'move') $quant = $getMaterialData->closing_balance;
                            $conScrapStockMoveTotal = $quant - $actionQty;
                            /*update closing balance value  in material table*/
                            $updateQty = $this->inventory_model->update_qty_data('material', $conScrapStockMoveTotal, 'id', $id);
                        }
                    }
                    /****************************materialconversion insertion and updateion in material*************************************/
                    else if ($action_type == 'material_conversion') {
                        $insertedAdjustmentid = $this->inventory_model->insert_tbl_data('inventory_listing', $data);
                        //$converted_qty = $data['quantity']!=''?$data['quantity']:0;
                        $converted_qty = $data['quantity'] != '' ? $data['quantity'] : 0;
                        //pre($converted_qty);
                        $closing_balance = $data['closing_bal'] != '' ? $data['closing_bal'] : 0;
                        $ConvertedMaterial = $closing_balance - $converted_qty;
                        $dataConvert = array("closing_balance" => $ConvertedMaterial, "location" => $data['location']);
                        /***********************update location in material table****************/
                        $success = $this->inventory_model->update_material_data_after_conversion('material', $dataConvert, 'id', $id);
                    }
                    /***********************************************************************half/full book insertion*************************************************************/
                    else if ($action_type == 'half_full_book') {
                        $insertedAdjustmentid = $this->inventory_model->insert_tbl_data('inventory_listing', $data);
                    }
                    $data['message'] = "data inserted successfully";
                    logActivity('inventory listing Updated', 'material', $id);
                    $this->session->set_flashdata('message', 'data inserted successfully');
                    //redirect(base_url().'inventory/inventory_listing', 'refresh');
                    redirect(base_url() . 'inventory/inventory_listing_and_adjustment', 'refresh');
                }
            }
        }
    }
    /**************************************** inventory setting with location setting and material type ***********************************/
    /* index page of inventory setting */
    public function inventory_setting() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Inventory Setting', base_url() . 'Inventory Setting');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Inventory Setting';
        #$where = array('company_address.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where = array('company_address.created_by_cid' => $this->companyId);
        $this->data['location_setting'] = $this->inventory_model->get_data('company_address', $where); //get location data in location tab
       #pre($this->data['location_setting']);
        $where = array('daily_report_setting.created_by_cid' => $this->companyId);
        $this->data['daily_report_setting'] = $this->inventory_model->get_data('daily_report_setting', $where);

        $where = array('lot_details.created_by_cid' => $this->companyId, 'quantity >' => '0');
        $this->data['lot_details'] = $this->inventory_model->get_data('lot_details', $where);

        /** Get lots where stock 0 */
        $where = array('lot_details.created_by_cid' => $this->companyId, 'quantity <' => '1');
        $this->data['archived_lot_details'] = $this->inventory_model->get_data('lot_details', $where);        

        // $where12 = array('uom.created_by_cid' => $this->companyId);
		$where12 = "uom.created_by_cid ='" . $this->companyId . "' OR uom.created_by_cid =0";
        $this->data['uom_list1'] = $this->inventory_model->get_data('uom', $where12);

        $where12 = array('tag_types.created_by_cid' => $this->companyId);
        $this->data['tag_types'] = $this->inventory_model->get_data('tag_types', $where12);

        $where12 = array('tag_details.created_by_cid' => $this->companyId);
        $this->data['tag_details'] = $this->inventory_model->get_data('tag_details', $where12);

        #pre($this->data['location_setting']);
        /* $where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id);
         $this->data['location_setting']  = $this->inventory_model->get_data('location_settings',$where); */
        //get location data in location tab
        #$where1 = "created_by_cid ='".$_SESSION['loggedInUser']->c_id."' OR created_by_cid =0";
        $where1 = "created_by_cid ='" . $this->companyId . "' OR created_by_cid =0";
        $this->data['material_type'] = $this->inventory_model->get_data('material_type', $where1); //get material type data in materialtype tab
        $this->data['variant_type'] = $this->inventory_model->get_data('variant_types');
        $this->data['variant_options'] = $this->inventory_model->get_data('variant_options');
        $this->data['stock_permission'] = $this->inventory_model->get_data('stock_permission');

        $this->_render_template('inventory_setting/index', $this->data);
    }
    /*code to edit material type file*/
    public function material_type_edit() {
        $id = $_POST['id'];

        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['materialType'] = $this->inventory_model->get_data_byId('material_type', 'id', $id);
        $this->load->view('inventory_setting/edit_material_type', $this->data);
    }
    /*****************save material type*******************************/
    public function saveMaterialType() {
        $countSubtype = count($_POST['material_sub_type']);
        if ($countSubtype > 0) {
            $subtypeArr = [];
            $i = 0;
            while ($i < $countSubtype) {
                $SubType_jsonArray = (array('sub_type' => $_POST['material_sub_type'][$i]));
                $subtypeArr[$i] = $SubType_jsonArray;
                $i++;
            }
            $SubType_array = json_encode($subtypeArr);
        } else {
            $SubType_array = '';
        }
        if ($this->input->post()) {
            $required_fields = array('name');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $id = $data['id'];
                $data['sub_type'] = $SubType_array;
                #$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyId;
                $data['created_by'] = $data['createdBy'];
                if ($id && $id != '') {
                    $createdByCid = $_POST['createdId']; //get the createdby cid value
                    if ($createdByCid == 0) { //condition to check if created by cid = 0 (means by default set in database as 0)
                        $dataArray1 = array('name' => $_POST['name'], 'prefix' => $_POST['prefix'], 'sub_type' => $data['sub_type'], 'created_by_cid' => $createdByCid);
                        $success = $this->inventory_model->update_data('material_type', $dataArray1, 'id', $id); //update materila type and sub type With cid 0
                        if ($success) {
                            $data['message'] = "Material type updated successfully";
                            logActivity('Material type Updated', 'material_type', $id);
                            $this->session->set_flashdata('message', 'Material type Updated successfully');
                            redirect(base_url() . 'inventory/inventory_setting', 'refresh');
                        }
                    } else {
                        $dataArray2 = array('name' => $_POST['name'], 'prefix' => $_POST['prefix'], 'sub_type' => $SubType_array, 'created_by' => $data['createdBy'],
                        #'created_by_cid' => $_SESSION['loggedInUser']->c_id
                        'created_by_cid' => $this->companyId);
                        $success = $this->inventory_model->update_data('material_type', $dataArray2, 'id', $id); //update material type and sub type wiht cid of logged in user
                        if ($success) {
                            $data['message'] = "Material type updated successfully";
                            logActivity('Material type Updated', 'material_type', $id);
                            $this->session->set_flashdata('message', 'Material type Updated successfully');
                            redirect(base_url() . 'inventory/inventory_setting', 'refresh');
                        }
                    }
                } else {
					$where = array('name' => $data['name']);
					$ChkMatType = $this->inventory_model->get_data('material_type', $where);
					if(empty($ChkMatType)){
						$id = $this->inventory_model->insert_tbl_data('material_type', $data);
						if ($id) {
							logActivity('Material type inserted', 'material_type', $id);
							$this->session->set_flashdata('message', 'Material type inserted successfully');
							
						}
					}else{
						 $this->session->set_flashdata('error', 'ERROR !, Already Exist');
					}
						redirect(base_url() . 'inventory/inventory_setting', 'refresh');
                }
            }
        }
    }
    /*********************Delete User by status inactive******************/
    public function delete_materialType($id = '') {
        $id = $_POST['id'];
        $result = $this->inventory_model->delete_data('material_type', 'id', $id);
        $result1 = array('msg' => ' Deleted Successfully', 'status' => 'success', 'code' => 'C787', 'url' => base_url() . 'inventory/inventory_setting');
        echo json_encode($result1);
    }
    /*********************************location setting edit/save/delete****************************/
    /*location setting edit*/
    public function location_setting_edit() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['company_address'] = $this->inventory_model->get_data_byId('company_address', 'id', $id);
        $this->load->view('inventory_setting/edit_location_setting', $this->data);
    }

    /*view location setting*/
    public function location_setting_view() {
        $id = $_POST['id'];
        permissions_redirect('is_view');
        $this->data['location_setting_view'] = $this->inventory_model->get_data_byId('location_settings', 'id', $id);
        $this->load->view('inventory_setting/view_location_setting', $this->data);
    }
    /*save location setting*/
    /*public function saveLocationSetting(){
    $area_dataLength = count($_POST['area']);
    if($area_dataLength >0){
    $AreaArray = [];
        $i = 0;
            while($i < $area_dataLength) {
                 $AreaArrayObject =  (array('area' => $_POST['area'][$i]));
                 $AreaArray[$i] = $AreaArrayObject;
                $i++;
            }
        $AreaData_array = json_encode($AreaArray);
    }

    else{
    $AreaData_array = '';
    }
    if ($this->input->post()) {
    $required_fields = array('area');
    $is_valid = validate_fields($_POST, $required_fields);
    if (count($is_valid) > 0) {
    valid_fields($is_valid);
    }
    else{
    $data  = $this->input->post();

    $data['area'] = $AreaData_array;
    $id=$data['id'];
    $data['created_by'] = $_SESSION['loggedInUser']->id ;
    $data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
    if($id && $id != ''){
        $success = $this->inventory_model->update_data('location_settings',$data, 'id', $id);

        if ($success) {
                        $data['message'] = "Setting updated successfully";
                        logActivity('Setting Updated','location_setting',$id);
                        $this->session->set_flashdata('message', 'Setting Updated successfully');
            redirect(base_url().'inventory/inventory_setting', 'refresh');
                    }
    }
    }
    }
    }*/
    /*  public function saveLocationSetting(){
    //pre($_POST);die;
    $area_dataLength = count($_POST['area']);
    if($area_dataLength >0){
    $AreaArray = [];
        $i = 0;
            while($i < $area_dataLength) {
                 $AreaArrayObject =  (array('area' => $_POST['area'][$i]));
                 $AreaArray[$i] = $AreaArrayObject;
                $i++;
            }
        $AreaData_array = json_encode($AreaArray);
    }

    else{
    $AreaData_array = '';
    }
    if ($this->input->post()) {
    $required_fields = array('area');
    $is_valid = validate_fields($_POST, $required_fields);
    if (count($is_valid) > 0) {
    valid_fields($is_valid);
    }
    else{
    $data  = $this->input->post();
    $data['area'] = $AreaData_array;
    $id=$data['id'];
    $data['created_by'] = $_SESSION['loggedInUser']->id ;
    #$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
    $data['created_by_cid'] = $this->companyId ;
    #   if($id && $id != ''){
    /* if($data['location_id'] && $data['location_id'] != ''){
        $success = $this->inventory_model->update_data('location_settings',$data, 'id', $id);

        if ($success) {
                        $data['message'] = "Setting updated successfully";
                        logActivity('Setting Updated','location_setting',$id);
                        $this->session->set_flashdata('message', 'Setting Updated successfully');
            redirect(base_url().'inventory/inventory_setting', 'refresh');
                    }
    }else{ */
    /*$success = $this->inventory_model->insert_tbl_data('location_settings',$data);
        if ($success) {
                        $data['message'] = "Setting updated successfully";
                        logActivity('Setting Updated','location_setting',$id);
                        $this->session->set_flashdata('message', 'Setting Inserted successfully');
            redirect(base_url().'inventory/inventory_setting', 'refresh');
                    }
    #}
    }
    }
    } */

    public function saveLocationSetting() {
        $area_dataLength = count($_POST['area']);
        if ($area_dataLength > 0) {
            $AreaArray = [];
            $i = 0;
            while ($i < $area_dataLength) {
                $AreaArrayObject = (array('area' => $_POST['area'][$i]));
                $AreaArray[$i] = $AreaArrayObject;
                $i++;
            }
            $AreaData_array = json_encode($AreaArray);
        } else {
            $AreaData_array = '';
        }
        if ($this->input->post()) {
            $required_fields = array('area');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $data['area'] = $AreaData_array;
                $id = $data['id'];
                $data['created_by'] = $_SESSION['loggedInUser']->id;
                $data['created_by_cid'] = $this->companyId;
                #$success = $this->inventory_model->insert_tbl_data('location_settings',$data);
                $success = $this->inventory_model->update_data('company_address', $data, 'id', $id);
                if ($success) {
                    $data['message'] = "Settings updated successfully";
                    logActivity('Setting Updated', 'company_address', $id);
                    $this->session->set_flashdata('message', 'Settings updated successfully');
                    redirect(base_url() . 'inventory/inventory_setting', 'refresh');
                }
            }
        }
    }
    /*Delete location_setting*/
    public function delete_location($id = '') {
        if (!$id) {
            redirect('inventory/inventory_setting', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->inventory_model->delete_data('company_address', 'id', $id);
        #die;
        if ($result) {
            logActivity('location setting Deleted', 'material', $id);
            $this->session->set_flashdata('message', 'location setting Deleted Successfully');
            $result = array('msg' => 'location setting Deleted Successfully', 'status' => 'success', 'code' => 'C730', 'url' => base_url() . 'inventory/inventory_setting');
            echo json_encode($result);
             //redirect(base_url() . 'inventory/location_setting', 'refresh');
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }
    /*****************************************************************Index listing of inventory adjustments************************************************************/
    public function inventory_listing_view() {
        $id = $_POST['id'];
        permissions_redirect('is_view');
        $this->data['InventoryAdjustmentView'] = $this->inventory_model->get_data_byId('inventory_listing', 'id', $id); //$this->_render_template('materials/view', $this->data);
        $this->load->view('inventory_listing/view', $this->data);
    }
    /* Main Function to fetch all the listing of material */
    public function inventory_adjustments() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Inventory Adjustment', base_url() . 'Inventory Adjustment');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Inventory Adjustment';
        #$whereMaterialType = "(created_by_cid ='".$_SESSION['loggedInUser']->c_id."' OR created_by_cid =0) AND status = 1";
        $whereMaterialType = "(created_by_cid ='" . $this->companyId . "' OR created_by_cid =0) AND status = 1";
        $this->data['mat_type'] = $this->inventory_model->get_filter_details('material_type', $whereMaterialType);
        // date range filter conditions
        if (!empty($_POST) && isset($_POST['start']) && isset($_POST['end']) && @$_POST['ExportType'] == '') {
            #$where = array('inventory_listing.created_date >=' => $_POST['start'] , 'inventory_listing.created_date <=' => $_POST['end'],'inventory_listing.created_by_cid'=> $_SESSION['loggedInUser']->c_id );
            $where = array('inventory_listing.created_date >=' => $_POST['start'], 'inventory_listing.created_date <=' => $_POST['end'], 'inventory_listing.created_by_cid' => $this->companyId);
            $this->data['inventory_adjustment'] = $this->inventory_model->get_data('inventory_listing', $where);
            $this->_render_template('inventory_adjustment/index', $this->data);
        } elseif (!empty($_POST) && $_POST['action'] != '' && $_POST['material_type'] != '') {
            #$where = "created_by_cid = ".$_SESSION['loggedInUser']->c_id." AND  (material_type_id ='".$_POST['material_type']."' AND  action_type = '".$_POST['action']."')";
            $where = "created_by_cid = " . $this->companyId . " AND  (material_type_id ='" . $_POST['material_type'] . "' AND  action_type = '" . $_POST['action'] . "')";
            $this->data['inventory_adjustment'] = $this->inventory_model->get_data('inventory_listing', $where);
            $this->_render_template('inventory_adjustment/index', $this->data);
        } elseif (!empty($_POST) && $_POST['action'] != '' && $_POST['material_type'] == '') {
            #$where = "created_by_cid = ".$_SESSION['loggedInUser']->c_id." AND  (action_type = '".$_POST['action']."')";
            $where = "created_by_cid = " . $this->companyId . " AND  (action_type = '" . $_POST['action'] . "')";
            $this->data['inventory_adjustment'] = $this->inventory_model->get_data('inventory_listing', $where);
            $this->_render_template('inventory_adjustment/index', $this->data);
        } elseif (!empty($_POST) && $_POST['action'] == '' && $_POST['material_type'] != '') {
            #$where = "created_by_cid = ".$_SESSION['loggedInUser']->c_id." AND  (material_type_id ='".$_POST['material_type']."')";
            $where = "created_by_cid = " . $this->companyId . " AND  (material_type_id ='" . $_POST['material_type'] . "')";
            $this->data['inventory_adjustment'] = $this->inventory_model->get_data('inventory_listing', $where);
            $this->_render_template('inventory_adjustment/index', $this->data);
        }
        //export functionality after apply filter conditions //
        elseif (isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' && $_POST['action'] == '' && $_POST['material_type'] == '') {
            #$where = "created_by_cid = ".$_SESSION['loggedInUser']->c_id;
            $where = "created_by_cid = " . $this->companyId;
            $this->data['inventory_adjustment'] = $this->inventory_model->get_data('inventory_listing', $where);
            $this->_render_template('inventory_adjustment/index', $this->data);
        } elseif (isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' && $_POST['action'] != '' && $_POST['material_type'] == '') {
            #$where = "created_by_cid = ".$_SESSION['loggedInUser']->c_id." AND  (action_type = '".$_POST['action']."')";
            $where = "created_by_cid = " . $this->companyId . " AND  (action_type = '" . $_POST['action'] . "')";
            $this->data['inventory_adjustment'] = $this->inventory_model->get_data('inventory_listing', $where);
            $this->_render_template('inventory_adjustment/index', $this->data);
        } elseif (isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' && $_POST['action'] == '' && $_POST['material_type'] != '') {
            #$where = "created_by_cid = ".$_SESSION['loggedInUser']->c_id." AND  (material_type_id ='".$_POST['material_type']."')";
            $where = "created_by_cid = " . $this->companyId . " AND  (material_type_id ='" . $_POST['material_type'] . "')";
            $this->data['inventory_adjustment'] = $this->inventory_model->get_data('inventory_listing', $where);
            $this->_render_template('inventory_adjustment/index', $this->data);
        } elseif (isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' && $_POST['action'] != '' && $_POST['material_type'] != '') {
            #$where = "created_by_cid = ".$_SESSION['loggedInUser']->c_id." AND  (material_type_id ='".$_POST['material_type']."' AND  action_type = '".$_POST['action']."')";
            $where = "created_by_cid = " . $this->companyId . " AND  (material_type_id ='" . $_POST['material_type'] . "' AND  action_type = '" . $_POST['action'] . "')";
            $this->data['inventory_adjustment'] = $this->inventory_model->get_data('inventory_listing', $where);
            $this->_render_template('inventory_adjustment/index', $this->data);
        } elseif (isset($_POST["ExportType"]) && $_POST['start'] != '' && $_POST['end'] != '' && $_POST['action'] == '' && $_POST['material_type'] == '') {
            #$where = array('inventory_listing.created_date >=' => $_POST['start'] , 'inventory_listing.created_date <=' => $_POST['end'],'inventory_listing.created_by_cid'=> $_SESSION['loggedInUser']->c_id );
            $where = array('inventory_listing.created_date >=' => $_POST['start'], 'inventory_listing.created_date <=' => $_POST['end'], 'inventory_listing.created_by_cid' => $this->companyId);
            $this->data['inventory_adjustment'] = $this->inventory_model->get_data('inventory_listing', $where);
            $this->_render_template('inventory_adjustment/index', $this->data);
        } else {
            #$where = array('inventory_listing.created_by_cid' => $_SESSION['loggedInUser']->c_id );
            $where = array('inventory_listing.created_by_cid' => $this->companyId);
            $this->data['inventory_adjustment'] = $this->inventory_model->get_data('inventory_listing', $where);
            $this->_render_template('inventory_adjustment/index', $this->data);
        }
    }
    /************************************************************EXTRA code***********************************************************************************/
    /*function through ajax call  get material name when material type get selected in all sub modules*/
    public function get_material_name() {
        $this->data['material'] = $this->inventory_model->get_data('material', array('material_type' => $_POST['material_id']));
        echo json_encode($this->data['material']);
    }
    /*******************************************************************************************************************************************************************************************************************************************************Index of inventory evaluation***********************************************************************/
    #MAIN FUNCTION
    public function inventory_valuation() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Inventory Valuation', base_url() . 'Inventory Valuation');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Inventory Valuation';

        $segment =  $this->uri->segment(3)?$this->uri->segment(3):0;
        if( $segment > 3 ){
            redirect('inventory/inventory_valuation');
        }

        $this->data['checkRadio'] = $segment;
        $where = "material.created_by_cid = " . $this->companyId . " AND  material.cost_price != 0 AND material.sales_price !=0 AND material.status = 1";
        $where1 = "material.created_by_cid = " . $this->companyId . " AND  material.cost_price = 0 AND material.sales_price =0 AND material.status = 1";

        if( $segment > 0 ){
            $select = "material.id,material.material_code,material.cost_price,material.sales_price,material.opening_balance,
                        material.material_name,mt.name as material_type,mt.id as mtId";
            $table  = ['material_type as mt' => 'mt.id = material.material_type_id'];

            $inventory_valuation = $this->inventory_model->joinTables($select,'material',$table,$where,['material.id','desc']);
            switch ($segment) {
                case 2:
                    $getMaterialIdPrice = ['column' => 'descr_of_goods','table' => 'invoice','where' => 'material_id','jsonCloumn' => 'rate'];
                break;
                case 3:
                    $getMaterialIdPrice = ['column' => 'material_name','table' => 'mrn_detail','where' => 'material_name_id','jsonCloumn' => 'price'];
                break;
            }
            $this->data['inventory_valuation'] = $this->getLastPriceMaterial($inventory_valuation,$getMaterialIdPrice);

            $this->_render_template('inventory_valuation/lastprice', $this->data);
            /*if (!empty($_POST)) {
                $where = array('material.created_date >=' => $_POST['start'], 'material.created_date <=' => $_POST['end'], 'material.created_by_cid' => $this->companyId);
                $this->data['inventory_valuation'] = $this->inventory_model->get_evaluation_data('material', $where);
                $this->load->view('inventory_valuation/index', $this->data);
            } else {
            }*/
        }else{
            $this->data['inventory_valuation'] = $this->inventory_model->get_evaluation_data('material', $where);
            $this->data['valuationwith_zero'] = $this->inventory_model->get_evaluation_data('material', $where1);
            $this->_render_template('inventory_valuation/index', $this->data);
        }

    }

    function getLastPriceMaterial($inventory_valuation,$getMaterialIdPrice){
        $valuationLastPrice = [];
        foreach ($inventory_valuation as $ivKey => $ivValue) {
                $salePrice = getMaterialIdPrice($getMaterialIdPrice['column'],$getMaterialIdPrice['table'],[$getMaterialIdPrice['where'] => $ivValue['id'] ],
                                                    $getMaterialIdPrice['jsonCloumn']);
                $valuationLastPrice[$ivValue['mtId']][] = [ 'material_id' => $ivValue['id'],'material_code' => $ivValue['material_code'],'cost_price' => $ivValue['cost_price'],
                                                            'opening_balance'  => $ivValue['opening_balance'],'material_type'    => $ivValue['material_type'],'sale_price' => $salePrice,
                                                            'material_name' => "<a href='javascript:void(0)' id='{$ivValue['id']}' data-id='material_view' class='inventory_tabs'>{$ivValue['material_name']}</a>",'product_evaluation' => ($salePrice * $ivValue['opening_balance'])
                                                             ];
        }

        return $valuationLastPrice;
    }
    // save evaluation data
    public function saveValuation() {
        if (!empty($_POST['cp']) && !empty($_POST['sp'])) { // conditon to check if cp and sp are not empty
            $cost_price = $_POST['cp']; //get value of cp and sp
            $sales_price = $_POST['sp'];
            $mergedArray = array_merge($cost_price, $sales_price); //megred both cp and sp array into one
            $Combined_data = array();
            foreach ($mergedArray as $merged_Array) {
                $id = $merged_Array['id'];
                if (!isset($Combined_data[$id])) {
                    $Combined_data[$id] = array();
                }
                $Combined_data[$id] = array_merge($Combined_data[$id], $merged_Array); //combined  sp and sp value into one array value

            }
            $data = $this->inventory_model->updateMaterialData('material', $Combined_data);
        } elseif (!empty($_POST['cp']) && empty($_POST['sp'])) { //if sp i empty
            $cost_price = $_POST['cp'];
            $data = $this->inventory_model->updateMaterialData('material', $cost_price);
        } elseif (empty($_POST['cp']) && !empty($_POST['sp'])) { //if cp is empty
            $sales_price = $_POST['sp'];
            $data = $this->inventory_model->updateMaterialData('material', $sales_price);
        }
        $result = array('msg' => 'update', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'inventory/inventory_valuation');
        echo json_encode($result);
    }
    /***************************************************************dashboard *************************************************************************************/
    # Main Function to load dashboard
    public function dashboard(){
        if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
            redirect(base_url() . 'inventory/materials/', 'refresh');
        }
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'dashboard');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Dashboard';
        #$where = array('inventory_listing.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where = array('inventory_listing.created_by_cid' => $this->companyId);
        $this->data['materialMove'] = $this->inventory_model->get_data_Move('inventory_listing', $where);
        #$where = array('inventory_listing.created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where = array('inventory_listing.created_by_cid' => $this->companyId);
        $this->data['materialDonotMove'] = $this->inventory_model->get_data_Not_Move('material', $where);
        $this->data['user_dashboard'] = $this->inventory_model->get_data_dashboard('user_dashboard', array('user_id' => $_SESSION['loggedInUser']->id));
        $this->_render_template('dashboard/index', $this->data);
    }
    /*dashboard*/
    public function graphDashboardData() {
        if (!empty($_POST)) {
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
        } else {
            $startDate = $endDate = '';
        }
        $graphDashboardArray = array();
        $getMonthInventoryListingGraph = getMonthInventoryListingGraph($startDate, $endDate);
        $getStockSummary = getStockSummary($startDate, $endDate); //get stock related call function through helper
        $getScrappedDetail = getScrappedDetail($startDate, $endDate); //get scrapped related graph call function through helper
        $getDashboardCount = getDashboardCount($startDate, $endDate); //get dashboard count graph call function through helper
        $graphDashboardArray = array('getScrappedDetail' => $getScrappedDetail, 'getStockSummary' => $getStockSummary, 'getMonthInventoryListingGraph' => $getMonthInventoryListingGraph, 'getDashboardCount' => $getDashboardCount);
        echo json_encode($graphDashboardArray);
    }
    //code->when click on particular graph check box it will be displayed on main dashboard
    public function showDashboardOnRequirement() {
        $data = $_POST;
        pre($data);
        $data['user_id'] = $_SESSION['loggedInUser']->id;
        $user_dashboard = $this->inventory_model->get_data_dashboard('user_dashboard', array('user_id' => $_SESSION['loggedInUser']->id, 'graph_id' => $data['graph_id']));
        if (!empty($user_dashboard)) {
            $id = $this->inventory_model->update_data('user_dashboard', $data, 'id', $user_dashboard[0]['id']);
        } else {
            $id = $this->inventory_model->insert_tbl_data('user_dashboard', $data);
        }
        if ($id) {
            $result = array('msg' => 'Data for user set', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'inventory/dashboard');
            echo json_encode($result);
        }
    }
    /**************************************************************************************************************************************************************************************************************************************************WIP finish goods**************************************************************************************/
    /***************Work In Process**********************************************/
    public function work_in_process() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->data['can_validate'] = validate_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Material Issued List ', base_url() . 'Material Issued List');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Material Issued List';
        #$whereCompany = "(id ='".$_SESSION['loggedInUser']->c_id."')";
        $whereCompany = "(id ='" . $this->companyId . "')";
        $this->data['company_unit_adress'] = $this->inventory_model->get_filter_details('company_detail', $whereCompany);
        /*if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
         }else*/
		 
        $where= array('created_by_cid' => $this->companyId);
        if(!empty($_GET) && isset($_GET['start']) && isset($_GET['end']) && isset($_GET['company_unit'])== '') {
            $where = "created_by_cid = " . $this->companyId . " AND  (created_date >='" . $_GET['start'] . "' AND  created_date <='" . $_GET['end'] . "')";
        } elseif (!empty($_GET) && !empty($_GET['company_unit']) && $_GET['start'] != '' && $_GET['end'] != '') {
            $where = "created_by_cid = " . $this->companyId . " AND  (created_date >='" . $_GET['start'] . "' AND  created_date <='" . $_GET['end'] . "')";
        }

        if(isset($_GET['company_unit'])!='')
        {
            $json_dtl ='{"location" : "'.$_GET['company_unit'].'"}';
            // $where= "wip.mat_detail!='' && json_contains(`mat_detail`, '".$json_dtl."')" ;
            $where= " json_contains(`mat_detail`, '".$json_dtl."')" ;
        }
        if(isset($_GET['ExportType'])!='' && $_GET['start']=='' && $_GET['end']=='' && $_GET['company_unit']=='')
        {
            $where= array('created_by_cid' => $this->companyId);
        }
        elseif(isset($_GET['ExportType'])!='' && $_GET['start']!='' && $_GET['end']!='' && $_GET['company_unit']=='')
        {
          $where = "created_by_cid = " . $this->companyId . " AND  (created_date >='" . $_GET['start'] . "' AND  created_date <='" . $_GET['end'] . "')";
        }
        elseif(isset($_GET['ExportType'])!='' && $_GET['start']!='' && $_GET['end']!='' && $_GET['company_unit']!=''){
            $json_dtl ='{"location" : "'.$_GET['company_unit'].'"}';
            // $where= "wip.mat_detail!='' && json_contains(`mat_detail`, '".$json_dtl."')" ;
             $where= "json_contains(`mat_detail`, '".$json_dtl."')" ;
        }
        //Search
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            if(is_numeric($_POST['search'])){
               # echo "rfrfrfrfrfr";
                 $search_string = $_POST['search'];
                 $where2 = " wip.id = '" . $search_string . "'";
                #pre($where2);
            }
            else{
                # echo "hyhyhyyhyyh";
                $search_string = $_POST['search'];
                $materialName=getNameById('material',$search_string,'material_name');
                $material_type_tt = getNameById('material_type',$search_string,'name');


                    if($material_type_tt->id !=''){
                        $json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                        // $where2 = "wip.mat_detail!='' && json_contains(`material_type_id`, '".$json_dtl."')" ;
                        $where2 = "json_contains(`material_type_id`, '".$json_dtl."')" ;
                    }/*elseif($materialName->id != '' && $material_type_tt->id ==''){
                        $json_dtl ='{"material_id" : "'.$materialName->id.'"}';
                        $where2 = "wip.mat_detail!='' && json_contains(`material_id`, '".$json_dtl."')" ;
                    }*/else{
                    $where2 = " wip.id = '" . $search_string . "'";
                    }
            }
            #die;
            redirect("inventory/work_in_process/?search=$search_string");
        } elseif(isset($_GET['search']) && $_GET['search']!='') {
            $materialName=getNameBySearch('material',$_GET['search'],'material_name');
            $material_type_tt = getNameBySearch('material_type',$_GET['search'],'name');
            $materialName=getNameBySearch('material',$_GET['search'],'material_name');
            $material_type_tt = getNameBySearch('material_type',$_GET['search'],'name');
            $where2=array();

            if(is_numeric($_GET['search'])){
                //$where2="wip.id ='" . $_GET['search'] . "'";
            }else{
                foreach($materialName as $materialname){//pre($name['id']);
                    $json_dtl ='{"material_id" : "'.$materialname['id'].'"}';
                   // $where2[]="wip.mat_detail!='' && json_contains(`mat_detail`, '".$json_dtl."')" ;
                   $where2[]=" json_contains(`mat_detail`, '".$json_dtl."')" ;
                }
                foreach($material_type_tt as $materialtype){//pre($name['id']);
                    $json_dtl ='{"material_type_id" : "'.$materialtype['id'].'"}';
                   // $where2[]="wip.mat_detail!='' && json_contains(`mat_detail`, '".$json_dtl."')" ;
                   $where2[]="json_contains(`mat_detail`, '".$json_dtl."')" ;
                }

                if(sizeof($where2)!=''){
                    $where2=implode("||",$where2);
                }
            }
        /*if(isset($material_type_tt->id)!=''){
                $json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                $where2 = "wip.mat_detail!='' && json_contains(`mat_detail`, '".$json_dtl."')||wip.id ='" . $_GET['search'] . "'" ;
            }elseif(isset($materialName->id)!= '' && isset($material_type_tt->id)==''){
                $json_dtl ='{"material_id" : "'.$materialName->id.'"}';
                $where2 = "wip.mat_detail!='' && json_contains(`mat_detail`, '".$json_dtl."')||wip.id ='" . $_GET['search'] . "'" ;
            }else
            {
                $where2 = "wip.id ='" . $_GET['search'] . "'";
        }*/
		}
		// pre($where2);
		
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "inventory/work_in_process";
        $config["total_rows"] = $this->inventory_model->num_rows('wip',$where, $where2);
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
        $this->data['material_issue'] = $this->inventory_model->get_data1('wip_request', $where, $config["per_page"], $page, $where2, $order,$export_data); //get WIP in Work in process Tab
            if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }
        if($end>$config['total_rows'])
        {
        $total=$config['total_rows'];
        }else{
        $total=$end;
        }
        $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
        $this->_render_template('work_in_process/index', $this->data);
    }

    public function work_in_process_edit($product='')
    {
        $id  = $_POST['id'];
        $this->data['id'] = $id;
        if($id != ''){
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }

        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = add_permissions();
        $this->data['add_machine'] = $this->getAllSaleOrder();
        $this->data['product']=$product;
        $this->data['material_issue']  = $this->inventory_model->get_data_byId('work_in_process_material','id',$id);  //get WIP in Work in process Tab
        $this->load->view('work_in_process/edit', $this->data);
    }

    public function work_in_process_edit_one() {
        $this->data['id']  = $_POST['id'];  //get WIP in Work in process Tab
        $this->load->view('work_in_process/edit_one', $this->data);
    }

    public function work_in_processMatView() {
        //pre("sdsd");
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = add_permissions();
        $this->data['material_issue']  = $this->inventory_model->get_data_byId('wip','id',$id);  //get WIP in Work in process Tab
        $this->load->view('work_in_process/viewMat', $this->data);
    }

    public function work_in_processwork_in_processID() {
        $id = isset($_POST['id']) ? $_POST['id']:'';
        if($id != ''){
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = add_permissions();
        $this->data['material_issue']  = $this->inventory_model->get_data_byId('wip_request','id',$id);  //get WIP in Work in process Tab
        $this->load->view('work_in_process/viewwip_request', $this->data);
    }

    /*old one*/
    /*public function wip_and_finish_goods(){
    $this->data['can_edit'] = edit_permissions();
    $this->data['can_delete'] = delete_permissions();
    $this->data['can_add'] = add_permissions();
    $this->data['can_view'] = view_permissions();
    $this->breadcrumb->add('Material Issue ', base_url() . 'Material Issue');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Material Issue';
    $this->_render_template('wip_and_finish_goods/index', $this->data);
    }
    */

 public function saveWorkInProcessMaterial(){

        if ($this->input->post()) {
            $required_fields = array('material_type');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0){
                valid_fields($is_valid);
            } else {
                $process_input_arr=[];
                   $materialID=$this->input->post('material_name_1');
                      if (count($materialID) > 0){
                          foreach ($materialID as $key => $value) {
                                  $process_input_arr[]=['material_type_id'=>$this->input->post('material_type_id_1')[$key],
                                  'material_id'=>$value,
                                  'quantity'=>$this->input->post('qty_1')[$key],
                                  'uom'=>$this->input->post('uom_1')[$key],
                                  'location'=>$this->input->post('location_1')[$key],
                                  'work_order'=>$this->input->post('work_order_id_1')[$key],
                                  'sale_order_id'=>$this->input->post('sale_order_id_1')[$key],
                                  'npdm'=>$this->input->post('npdm_1')[$key],
                                  'machine_name'=>$this->input->post('machine_name_1')[$key] 
                                   ]; 
                                 
                            }

               /*************previous process***************/
                            if($process_input_arr){
                                $inventoryFlowDataArray = array();
                                foreach($process_input_arr as $productDetail){
                                    $whereCondition = array(
                                        'material_id'       => $productDetail['material_id'],
                                        'material_type_id'  => $productDetail['material_type_id']
                                    );
                                    $materialProcessDetails = $this->inventory_model->get_material_process_data('material_in_process_inventory_flow', $whereCondition);
                                    if($materialProcessDetails){
                                        $inventoryFlowDataArray['material_type_id'] = $productDetail['material_type_id'];
                                        $inventoryFlowDataArray['material_id']      = $productDetail['material_id'];
                                        $inventoryFlowDataArray['material_in']      = $productDetail['quantity'];
                                        $inventoryFlowDataArray['opening_blnc']     = $materialProcessDetails['closing_blnc'];
                                        $inventoryFlowDataArray['closing_blnc']     = $materialProcessDetails['closing_blnc'] + $productDetail['quantity'];
                                        $inventoryFlowDataArray['uom']              = $productDetail['uom'];
                                        $inventoryFlowDataArray['through']          = 'Issue RM Material';
                                        $inventoryFlowDataArray['ref_id']           = $productDetail['work_order_id'];
                                        $inventoryFlowDataArray['created_by']       = $_SESSION['loggedInUser']->id;
                                        $inventoryFlowDataArray['created_by_cid']   = $this->companyId;
                                        $this->inventory_model->insert_tbl_data('material_in_process_inventory_flow', $inventoryFlowDataArray);
                                    } else {
                                        $inventoryFlowDataArray['material_type_id'] = $productDetail['material_type_id'];
                                        $inventoryFlowDataArray['material_id']      = $productDetail['material_id'];
                                        $inventoryFlowDataArray['material_in']      = $productDetail['quantity'];
                                        $inventoryFlowDataArray['opening_blnc']     = $productDetail['quantity'];
                                        $inventoryFlowDataArray['closing_blnc']     = $productDetail['quantity'];
                                        $inventoryFlowDataArray['uom']              = $productDetail['uom'];
                                        $inventoryFlowDataArray['through']          = 'Issue RM Material';
                                        $inventoryFlowDataArray['ref_id']           = $productDetail['work_order_id'];
                                        $inventoryFlowDataArray['created_by']       = $_SESSION['loggedInUser']->id;
                                        $inventoryFlowDataArray['created_by_cid']   = $this->companyId;
                                        $this->inventory_model->insert_tbl_data('material_in_process_inventory_flow', $inventoryFlowDataArray);
                                    }
                                }
                            }
                            $insertedid = $this->inventory_model->insert_multiple_data('work_in_process_material', $process_input_arr); //insert multiple value each in single row using insert batch
                            $k = 0;
                            foreach ($process_input_arr as $mat_data) {
                                $material_name_id[] = $mat_data['material_id'];
                                $k++;
                            }
                            $material_Ids = implode(',', $material_name_id); //get material id with comma sepration
                            if($material_Ids != '') updateMultipleUsedIdStatus('material', $material_Ids);
                            #get material data based on multiple ids for updaation
                            #$material_data = $this->inventory_model->get_Materialtbl_data('material', $material_Ids);
                            /*************previous process***************/



                            /*************In-out material***************/
                            $inventoryFlowDataArray1 = array();
                            foreach($process_input_arr as $rr){
                                $getmatdata = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $rr['material_id'], 'material_type_id' => $rr['material_type_id'], 'location_id' => $rr['location']));

                                $j = 0;
                                $material_data1 = array();
                                $l = 0;
                                $rt = 0;
                                $arr = [];
                                $closingblcn = 0;
                                foreach($getmatdata as $key1){

                                    $yu = getNameById_mat('mat_locations',$rr['material_id'],'material_name_id');
                                    $sum = 0;
                                    if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                                    $closingblcn = ($sum >= $rr['quantity']) ? $sum - $rr['quantity']:$sum;

                                    if ($key1['material_name_id'] == $rr['material_id'] && $key1['location_id'] == $rr['location']){   //&& $key1['Storage'] == $rr['storage']

                                        #//update quanity in mat_location
                                        $material_data1 = $key1;
                                        $closing_bal = ($key1['quantity'] >= $rr['quantity']) ? $key1['quantity'] - $rr['quantity']:$key1['quantity'];
                                        $material_data1['quantity'] = $closing_bal;
                                        #pre($material_data1);
                                        $Update = $this->inventory_model->update_single_field('mat_locations', $material_data1);

                                        $arr[] =  json_encode(array(array('location' => $rr['location'],'Storage' => $key1['storage'] , 'RackNumber' => $key1['RackNumber'] , 'quantity' => $closing_bal , 'Qtyuom' => $rr['uom'])));
                                        $rt++;
                                        $inventoryFlowDataArray1['current_location'] = $arr[$l];
                                        $inventoryFlowDataArray1['material_id'] = $rr['material_id'];
                                        $inventoryFlowDataArray1['material_out'] = $rr['quantity'];
                                        $inventoryFlowDataArray1['uom'] = $rr['uom'];
                                        $inventoryFlowDataArray1['opening_blnc'] = $sum; //$key1['quantity'];
                                        $inventoryFlowDataArray1['material_type_id'] = $key1['material_type_id'];
                                        $inventoryFlowDataArray1['closing_blnc'] = $closingblcn;
                                        $inventoryFlowDataArray1['through'] = 'Alloted in WIP';
                                        $inventoryFlowDataArray1['ref_id'] = $insertedid;
                                        $inventoryFlowDataArray1['created_by'] = $_SESSION['loggedInUser']->id;
                                        $inventoryFlowDataArray1['created_by_cid'] = $this->companyId;
                                        #pre($inventoryFlowDataArray1);
                                        $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray1);

                                        #//Update lot materials
                                        $this->material_Lot_inOut($rr['material_id']);
                                        #Update closing balance
                                        $this->update_closing_balance($rr['material_id']);
                                    }
                                }
                                $j++;
                            }
                            /*************In-out material***************/

                            $material_input_dtl_array = json_encode($process_input_arr);
                        } else {
                            $material_input_dtl_array = '';
                        }

                        /* End Update Code For multiple Machine */
                        // pre($machine_details_array);
                        // $jsonArrayObject1 = (array(
                        //      'work_order_id_select' =>  $_POST['work_order_id_select'][$i],
                        //      'work_order_product' => $_POST['work_order_product'][$i],
                        //      'input_process' => $material_input_dtl_array
                        // ));

                      

                $wip_request_id = $_POST['wip_request_id'];
                $data['mat_detail'] = $material_input_dtl_array;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyId;
                $data['issued_status'] = '1';
                $data['issued_date'] = date('Y-m-d');
                $data['request_id'] = $_POST['request_id'];
 
                $success = $this->inventory_model->insert_tbl_data('wip', $data);
                $success1 = $this->inventory_model->insert_tbl_data('wip_request', $data);
                /* For Saving WIP in Json Format */

                $data['message'] = "Material issue inserted successfully";
                logActivity('Work in process', 'work__in_process_material', $success);
                $this->session->set_flashdata('message', 'Material issue inserted successfully');
                $usersWithViewPermissions = $this->inventory_model->get_dataw('permissions', array('is_view' => 1, 'sub_module_id' => 7));
                if (!empty($usersWithViewPermissions)){
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array('subject' => 'Material issue inserted', 'message' => 'Material issue Created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $userViewPermission['user_id'], 'to_id' => $userViewPermission['user_id'], 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1){
                    pushNotification(array('subject' => 'Material issue inserted', 'message' => 'Material issue Created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                }
                pushNotification(array('subject' => 'Material issue inserted', 'message' => 'Material issue Created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                $email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
                <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi Test</p>
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Material issue inserted successfully.</p>
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>
                </td>
                </tr>
                </table>
                </td>
                </tr>';
                //send_mail_notification($_SESSION['loggedInUser']->email, 'Notification Email For Material issue inserted', $email_message);
                if($_SESSION['loggedInUser']->c_id){
                    $select = "email";
                    $where = 'c_id='.$_SESSION['loggedInUser']->c_id.' AND role=1';
                    $get_admin = $this->inventory_model->admin_email_data('user',$select, $where);
                    foreach ($get_admin as $key => $value) {
                        //send_mail_notification($value['email'], 'Notification Email For Material issue inserted', $email_message);
                    }
                }

                redirect(base_url() . 'inventory/work_in_process', 'refresh');
            }
        }
    }


    /***********************************Material receipt********************************************************************/
    public function finish_goods() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Finish goods ', base_url() . 'finish_goods');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Finish Goods';
        /* $whereCompany = "(id ='".$_SESSION['loggedInUser']->c_id."')";
         $this->data['company_unit_adress']  = $this->inventory_model->get_filter_details('company_detail',$whereCompany); */
        //$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id );
        $where = array('created_by_cid' => $this->companyId);
        if(isset($_GET['start'])!='' && isset($_GET['end'])!=''){
			$where = array('created_date >=' => $_GET['start'], 'created_date <=' => $_GET['end'], 'created_by_cid' => $this->companyId);
        }
			if(isset($_GET['ExportType'])!='' && $_GET['start']=='' && $_GET['end']=='' ){
					$where = array('created_by_cid' => $this->companyId);
			}
        //Search
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $materialName=getNameById('material',$search_string,'material_name');
            $job_card = getNameById('job_card',$search_string,'job_card_product_name');
            if($materialName->id != ''){
                $json_dtl ='{"material_id" : "'.$materialName->id.'"}';
                $where2 = "job_card_detail!='' && job_card_detail!='' && json_contains(`job_card_detail`, '".$json_dtl."')" ;
            }elseif($job_card->id != ''){
                $json_dtl ='{"job_card_no" : "'.$job_card->id.'"}';
                $where2 = "job_card_detail!='' && job_card_detail!='' && json_contains(`job_card_detail`, '".$json_dtl."')" ;
            }else{
            $where2 = " finish_goods.id = '" . $search_string . "'";
            }
            redirect("inventory/finish_goods/?search=$search_string");
        } elseif(isset($_GET['search']) && $_GET['search']!='') {
            $materialName=getNameBySearch('material',$_GET['search'],'material_name');
            $job_card = getNameBySearch('job_card',$_GET['search'],'job_card_product_name');
             $where2=array();
            foreach($materialName as $materialname){//pre($name['id']);
                $json_dtl ='{"material_id" : "'.$materialname['id'].'"}';
               $where2[]="job_card_detail!='' && json_contains(`job_card_detail`, '".$json_dtl."')" ;
            }
            foreach($job_card as $card){//pre($name['id']);
                $json_dtl ='{"job_card_no" : "'.$card['id'].'"}';
               $where2[]="job_card_detail!='' && json_contains(`job_card_detail`, '".$json_dtl."')";
            }
            if(sizeof($where2)!=''){
            $where2=implode("||",$where2);
            }else{
            $where2 = "finish_goods.id ='" . $_GET['search'] . "'";
            }
            /*if(isset($materialName->id)!= ''){
                $json_dtl ='{"material_id" : "'.$materialName->id.'"}';
                $where2 = "job_card_detail!='' && json_contains(`job_card_detail`, '".$json_dtl."')" ;
            }elseif(isset($job_card->id)!= ''){
                $json_dtl ='{"job_card_no" : "'.$job_card->id.'"}';
                $where2 = "job_card_detail!='' && json_contains(`job_card_detail`,'".$json_dtl."')" ;
            }else{
                $where2 = "finish_goods.id ='" . $_GET['search'] . "'";
            }*/
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "inventory/finish_goods";
        $config["total_rows"] = $this->inventory_model->num_rows('finish_goods', $where, $where2);
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
        $this->data['finish_goods'] = $this->inventory_model->get_data1('finish_goods', $where, $config["per_page"], $page, $where2, $order,$export_data);

        #pre($this->data['finish_goods']);
            if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }
        if($end>$config['total_rows'])
        {
        $total=$config['total_rows'];
        }else{
        $total=$end;
        }
        $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
        $this->_render_template('finish_goods/index', $this->data);
    }
    public function finish_goods_edit() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = add_permissions();
        //$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id );
        //$where = array('created_by_cid' => $_SESSION['loggedInUser']->c_id);
        $where = array('created_by_cid' => $this->companyId);
        //$where = array('created_by_cid' => $this->companyId);
        $this->load->view('wip_and_finish_goods/finish_goods_edit', $this->data);
    }
    public function saveFinishGoods_bk() {
        /**********material detail json encode***************/
        $matcount = count($_POST['material_name_id']);
        if ($matcount > 0) {
            $arr = [];
            $m = 0;
            while ($m < $matcount) {
                $ArrayObject = (array('material_id' => $_POST['material_name_id'][$m], 'quantity' => $_POST['quantity'][$m], 'uom' => $_POST['uom'][$m], 'output' => $_POST['calculatedOutput'][$m]));
                $arr[$m] = $ArrayObject;
                $m++;
            }
        }
        /********job card add more in json format*******************/
        $job_card_count = count($_POST['job_card_no']);
        if ($job_card_count > 0) {
            $finish_goods_arr = [];
            $k = 0;
            while ($k < $job_card_count) {
                $jobCardArrayObject = (array('job_card_no' => $_POST['job_card_no'][$k], 'totalAmountQty' => $_POST['total_Qty_Amount'][$k], 'material_id' => $_POST['material_name_id'][$k], 'quantity' => $_POST['quantity'][$k], 'uom' => $_POST['uom'][$k], 'output' => $_POST['calculatedOutput'][$k]));
                $finish_goods_arr[$k] = $jobCardArrayObject;
                $k++;
            }
            $material_finish_goods_array = json_encode($finish_goods_arr);
        } else {
            $material_finish_goods_array = '';
        }
        //pre($material_finish_goods_array);die();
        if ($this->input->post()) {
            $required_fields = array('job_card_no');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $id = $data['id'];
                $data['job_card_detail'] = $material_finish_goods_array;
                $data['created_by'] = $_SESSION['loggedInUser']->id;
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
                $data['created_by_cid'] = $this->companyId;
                if ($data['material_scrap_id'] != '') updateUsedIdStatus('material', $data['material_scrap_id']); // update material at the time of insert
                #pre($data);
                #die;
                $success = $this->inventory_model->insert_tbl_data('finish_goods', $data);
                if ($success) {
                    $get_materialDetail_from_finish_goods = getNameById('finish_goods', $success, 'id');
                    $scrapQtyMatId = $get_materialDetail_from_finish_goods->material_scrap_id; // get scrap qty from finish goods
                    $scrapQty = $get_materialDetail_from_finish_goods->scrap_qty; // get scrap qty from finish goods
                    if ($get_materialDetail_from_finish_goods) {
                        $matData = json_decode($get_materialDetail_from_finish_goods->job_card_detail); //decode job_card detail
                        $material_Id_CombineArray = array(); // blank array defined
                        $material_id = array(); // blank array defined for material id
                        $jobCard = array(); // blank array defined  for job card
                        $mat_dta = array();
                        # pre($matData);
                        $ty = 0;
                        foreach ($matData as $material_data) {
                            $jobCard[] = $material_data->job_card_no;
                            $material_id[] = $material_data->material_id; //in array foramt
                            $mat_dta[$ty]['output'] = $material_data->output; //get material data
                            $mat_dta[$ty]['material_id'] = $material_data->material_id;
                            $ty++;
                        }
                        $JobCardIds = implode(',', $jobCard);
                        #  pre($JobCardIds);
                        if ($JobCardIds != '') updateMultipleUsedIdStatus('job_card', $JobCardIds); //update multiple job card ids at once
                        /*combine material id in one array*/
                        foreach ($material_id as $key => $value) {
                            $material_Id_CombineArray[] = $value;
                            // foreach ($value as $key1 => $value2) {
                            // $material_Id_CombineArray[] = $value2->material_id;
                            // }

                        }
                        //get comma seprated values of material id of finish goods/
                        $materialIds = implode(',', $material_Id_CombineArray);
                        # pre($materialIds);
                        /*get material issue datat based on comma separated id */
                        $getMaterialIssue_detail = $this->inventory_model->get_wip_mat_data('work_in_process_material', $materialIds);
                        //if($getMaterialIssue_detail != ''){
                        $result = array();
                        $i = 0;
                        # pre($getMaterialIssue_detail);
                        foreach ($getMaterialIssue_detail as $material_issue_data) { //each on Work in process data
                            $mat_issue_id = $material_issue_data['material_id']; // get material id
                            $mat_qty = $material_issue_data['quantity']; //get qty data
                            //pre($mat_qty);
                            #  pre($mat_dta);
                            foreach ($mat_dta as $mat_finish_Id) {
                                # pre($mat_finish_Id);
                                $mat_rcvd_id = $mat_finish_Id['material_id'];
                                $output_rcvd_id = $mat_finish_Id['output'];
                                //pre($output_rcvd_id );
                                if ($mat_issue_id == $mat_rcvd_id) {
                                    $result[$i]['material_id'] = $mat_issue_id;
                                    $result[$i]['result'] = $mat_qty - $output_rcvd_id;
                                    $result[$i]['output'] = $output_rcvd_id;
                                } /*else{
                                $result[$i]['material_id'] = '';
                                $result[$i]['result'] = '';
                                }   */
                            }
                            $i++;
                        }
                        //pre($result); die;
                        if (!empty($result)) {
                            /*update multiple ids at once */
                            $success = $this->inventory_model->update_mat_in_wip_data('work_in_process_material', $result, $materialIds);
                            # pre($success);
                            # die;
                            $getMaterialData = getNameById('material', $scrapQtyMatId, 'id'); //get material data based on scrap material id
                            if (!empty($getMaterialData)) {
                                $opening_balance_Qty = $getMaterialData->opening_balance; // get opening balance qty from material
                                $Amount_added_in_openingBalance = $scrapQty + $opening_balance_Qty;
                                $updateSinglefield = $this->inventory_model->update_single_column('material', $Amount_added_in_openingBalance, 'id', $scrapQtyMatId);
                            }
                        }
                    }
                    #die;
                    if ($success) {
                        $data['message'] = "Material receipt created  successfully";
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'New Material reciept created', 'message' => 'New material reciept  is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-paper-plane-o'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'New Material reciept created', 'message' => 'New material reciept  is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-paper-plane-o'));
                        }
                        logActivity('Material receipt created ', 'material', $id);
                        $this->session->set_flashdata('message', 'Material receipt created successfully');
                        redirect(base_url() . 'inventory/finish_goods', 'refresh');
                    }
                }
            }
        }
    }
     public function saveFinishGoods() {
        // pre($_POST); 
        // die;
        /********job card add more in json format*******************/
       # pre($this->input->post());die;
        $job_card_count = count($_POST['work_order_id']);
		
        if ($job_card_count > 0) {
            $finish_goods_arr = [];
            $k = 0;
            $dwsa = 0;
            $z = 0;
           # $val = 0;
            foreach ($_POST['work_order_id'] as $key => $val) { 
                 #pre($_POST['work_order_id']);
                /**********material detail json encode***************/
                $matcount = count($_POST['material_name_id'][$val]);
                if ($matcount > 0) {
                    $m = 0;
                    $dwsa = 0;
                    while ($m < $matcount) {
                        $lot = $_POST['batch'][$val][$m] . $_POST['subbatch'][$val][$m];
                        $lot = str_replace(' ', '', $lot);
                        // $lots_arr[] = $lot;

                        //create new lot
                        $new_lot[$z]['lot_number'] = $lot;
                        $new_lot[$z]['mat_id'] = $_POST['material_name_id'][$val][$m];
                        $new_lot[$z]['quantity'] =  $_POST['quantity'][$val][$m];
                        $new_lot[$z]['mat_type_id'] = getNameById('material', $_POST['material_name_id'][$val][$m], 'id')->material_type_id;
                       
                        // 'lot_no' => $lot,
                        $dwsa += $_POST['calculatedOutput'][$val][$m];
                        $jobCardArrayObject = (array('work_order_id' => $_POST['work_order_id'][$k], 'job_card_no' => $_POST['job_card_no'][$val][$m], 'totalAmountQty' => $_POST['total_Qty_Amount'][$k], 'material_id' => $_POST['material_name_id'][$val][$m], 'quantity' => $_POST['quantity'][$val][$m], 'uom' => $_POST['uom'][$val][$m], 'output' => $_POST['calculatedOutput'][$val][$m], 'totaloutput' => $dwsa));

                        $finish_goods_arr[] = $jobCardArrayObject;
                        $m++;
                        $z++;
                    }
                }
                $k++;
            }
            $material_finish_goods_array = json_encode($finish_goods_arr);
        } else {
            $material_finish_goods_array = '';
        }

        // foreach ($new_lot as $lot_to_add){
        //     $lot_to_add['active_inactive'] = 1;
        //     $lot_to_add['date'] = date('Y-m-d');
        //     $lot_to_add['created_by'] = $_SESSION['loggedInUser']->u_id;;
        //     $lot_to_add['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
        //     $success = $this->inventory_model->insert_tbl_data('lot_details', $lot_to_add);
        // }


        $scrap_material_arr = [];
        $scrapMaterialsData = count($_POST['scrap_material_name']);
		 
        if ($scrapMaterialsData > 0) {
            $x   = 0;
            while ($x < $scrapMaterialsData) {
                $jsonScrapArrayObject   = (array(
                    'material_type_id'  => $_POST['scrap_material_type_id'][$x],
                    'material_name_id'  => $_POST['scrap_material_name'][$x],
                    'quantity'          => $_POST['scrap_quantity'][$x],
                    'unit'              => $_POST['scrap_uom_value'][$x],
                    'work_order_id'     => $_POST['work_order_detail_id'][$x],
                ));
                $arrScrap[$x]         = $jsonScrapArrayObject;
                $x++;
            }
            $scrap_material_arr = $arrScrap;
            $materialScrapDetail_array = json_encode($arrScrap);
        } else {
            $materialScrapDetail_array = '';
        }

		
        $materialUsedArray = array();
        $companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
        $workOrderData = json_decode($material_finish_goods_array,true);
        $companyDetails = $this->production_model->get_data_single('company_detail', array('id' => $companyGroupId));
		
        if($companyDetails['material_conversion_on_off'] != 1){
            if($workOrderData){
                foreach($workOrderData as $workDataInfo){
                    $jobCardDetails = $this->production_model->get_data_single('job_card', array('id' => $workDataInfo['job_card_no']));
                    if($jobCardDetails){
                        $jobCardMaterialDetails = json_decode($jobCardDetails['material_details'],true);
                        if($jobCardMaterialDetails){
                            foreach($jobCardMaterialDetails as $materialDetail){
                                $detailQuan         = ($jobCardDetails['lot_qty'] != 0 ) ? $workDataInfo['output'] / $jobCardDetails['lot_qty'] : 0;
                                $deduction_quantity = ($detailQuan > 0 ) ? $detailQuan * $materialDetail['quantity'] : $materialDetail['quantity'];
                                $materialUsedArray[]        = array(
                                    'material_type_id'      =>  $materialDetail['material_type_id'],
                                    'material_name_id'      =>  $materialDetail['material_name_id'],
                                    'input_quantity'        =>  $materialDetail['quantity'],
                                    'uom'                   =>  $materialDetail['unit'],
                                    'output'                =>  $workDataInfo['output'],
                                    'job_card_no'           =>  $workDataInfo['job_card_no'],
                                    'work_order_id'         =>  $workDataInfo['work_order_id'],
                                    'lot_qty'               =>  $jobCardDetails['lot_qty'],
                                    'deduction_quantity'    =>  round($deduction_quantity,2),
                                );
                            }
                        }
                    }
                }
            }
        }

        #pre($material_finish_goods_array);
        #die;
        if ($this->input->post()) {
            $required_fields = array('work_order_id');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $id = $data['id'];
                $data['job_card_detail'] = $material_finish_goods_array;
                $data['scrap_material_detail'] = $materialScrapDetail_array;
                $data['created_by'] = $_SESSION['loggedInUser']->id;
                $data['created_by_cid'] = $this->companyId;
				
              $success = $this->inventory_model->insert_tbl_data('finish_goods', $data);
 
                $inventoryFlowDataArray = [];
                $inCount = 0;
                $i = 0;
                $arr = [];
                $rt = 0;
                $dataarray = array();
                $inventoryFlowDataArray1 = [];
                $inCount1 = 0;
                $i1 = 0;
                $arr1 = [];
                $rt1 = 0;
                $dataarray1 = array();
                $closingblcn = 0;
                $fr = 0;
                $rfg = 0;
                $result = array();
                foreach($finish_goods_arr as $dt){
                    #pre($dt['totaloutput']);

                    $wo = getNameById_mat('work_order',$dt['work_order_id'],'id');

                    #pre($wo);

                    foreach($wo as $rhj){
                        #pre($rhj['product_detail']);
                        if(!empty($rhj['product_detail'])){
                            $rcv = json_decode($rhj['product_detail']);
                            #pre($rcv);
                            foreach($rcv as $dew){
                                #pre($dew->Pending_quantity);
                                if($dt['totaloutput'] >= $dew->transfer_quantity){
                                    updatecompleteworkorder('work_order', $dt['work_order_id']);
                                }
                            }
                        }
                    }

                    /******************* Old Code **************************/

                    /*$mat_locations = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $dt['material_id']));
                        foreach($mat_locations as $loc1){
                                     $arr[] =  json_encode(array(array('location' => $loc1['location_id'],'Storage' => $loc1['Storage'] , 'RackNumber' => $loc1['RackNumber'] , 'quantity' => $dt['output']  , 'Qtyuom' => $dt['uom'])));
                                     $rt++;
                        }

                        $yu = getNameById_mat('mat_locations',$dt['material_id'],'material_name_id');
                        $sum = 0;
                        if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                        $closingblcn = $sum + $dt['output'];
                        $inventoryFlowDataArray['opening_blnc'] = $sum;
                        $inventoryFlowDataArray['closing_blnc'] = $closingblcn;
                        $inventoryFlowDataArray['current_location'] = $arr[$i];
                        $inventoryFlowDataArray['material_id'] = $dt['material_id'];
                        $inventoryFlowDataArray['material_in'] = $dt['output'];
                        $inventoryFlowDataArray['uom'] = $dt['uom'];
                        $inventoryFlowDataArray['material_type_id'] = $loc1['material_type_id'];
                        $inventoryFlowDataArray['through'] = 'FG Recived';
                        $inventoryFlowDataArray['ref_id'] = $success;
                        $inventoryFlowDataArray['created_by'] = $_SESSION['loggedInUser']->id;
                        $inventoryFlowDataArray['created_by_cid'] = $this->companyId;
                        $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);
                        $getAddres = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $dt['material_id']));
                        foreach($getAddres as & $values) {
                            if($values['material_name_id'] == $dt['material_id']) {
                                $updatedQty = $values['quantity'] + $dt['output'];
                                $values['quantity'] = $updatedQty;
                                $success = $this->inventory_model->update_single_field('mat_locations', $values, $dt['material_id']);
                                break;
                            }
                        }*/

					
					
                    if($data['location_id']){
                        $mat_location_single = $this->inventory_model->get_data_single('mat_locations', array('material_name_id' => $dt['material_id'],'location_id' => $data['location_id']));
						
						
                        if($mat_location_single){
                            $arr =  json_encode(array(array('location' => $mat_location_single['location_id'],'Storage' => $mat_location_single['Storage'] , 'RackNumber' => $mat_location_single['RackNumber'] , 'quantity' => $dt['output']  , 'Qtyuom' => $dt['uom'])));
                            $yu = getNameById_mat('mat_locations',$dt['material_id'],'material_name_id');
                            $sum = 0;
                            if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                            $closingblcn = $sum + $dt['output'];
                            $inventoryFlowDataArray['opening_blnc']     = $sum;
                            $inventoryFlowDataArray['closing_blnc']     = $closingblcn;
                            $inventoryFlowDataArray['current_location'] = $arr;
                            $inventoryFlowDataArray['material_id']      = $dt['material_id'];
                            $inventoryFlowDataArray['material_in']      = $dt['output'];
                            $inventoryFlowDataArray['uom']              = $dt['uom'];
                            $inventoryFlowDataArray['material_type_id'] = $mat_location_single['material_type_id'];
                            $inventoryFlowDataArray['through']          = 'FG Recived';
                            $inventoryFlowDataArray['ref_id']           = $success;
                            $inventoryFlowDataArray['created_by']       = $_SESSION['loggedInUser']->id;
                            $inventoryFlowDataArray['created_by_cid']   = $this->companyId;
							
							
                            $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);
                            $values = $this->inventory_model->get_data_single('mat_locations', array('material_name_id' => $dt['material_id'],'location_id' => $data['location_id']));
                            if($values){
                                if($values['material_name_id'] == $dt['material_id']) {
                                    $updatedQty = $values['quantity'] + $dt['output'];
                                    $values['quantity'] = $updatedQty;
                                    $success = $this->inventory_model->update_single_field('mat_locations', $values, $dt['material_id']);
                                }
                            }
                        } else {
						    $mat_locations = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $dt['material_id']));
                            foreach($mat_locations as $loc1){
                                $arr[] =  json_encode(array(array('location' => $loc1['location_id'],'Storage' => $loc1['Storage'] , 'RackNumber' => $loc1['RackNumber'] , 'quantity' => $dt['output']  , 'Qtyuom' => $dt['uom'])));
                                $rt++;
                            }

                            $yu = getNameById_mat('mat_locations',$dt['material_id'],'material_name_id');
                            $sum = 0;
                            if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                            $closingblcn = $sum + $dt['output'];
                            $inventoryFlowDataArray['opening_blnc'] = $sum;
                            $inventoryFlowDataArray['closing_blnc'] = $closingblcn;
                            $inventoryFlowDataArray['current_location'] = $arr[$i];
                            $inventoryFlowDataArray['material_id'] = $dt['material_id'];
                            $inventoryFlowDataArray['material_in'] = $dt['output'];
                            $inventoryFlowDataArray['uom'] = $dt['uom'];
                            $inventoryFlowDataArray['material_type_id'] = $loc1['material_type_id'];
                            $inventoryFlowDataArray['through'] = 'FG Recived';
                            $inventoryFlowDataArray['ref_id'] = $success;
                            $inventoryFlowDataArray['created_by'] = $_SESSION['loggedInUser']->id;
                            $inventoryFlowDataArray['created_by_cid'] = $this->companyId;
							
							
                            $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);
                            $getAddres = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $dt['material_id']));
                            foreach($getAddres as & $values) {
                                if($values['material_name_id'] == $dt['material_id']) {
                                    $updatedQty = $values['quantity'] + $dt['output'];
                                    $values['quantity'] = $updatedQty;
                                    $success = $this->inventory_model->update_single_field('mat_locations', $values, $dt['material_id']);
                                    break;
                                }
                            }

                        }
                    }
                }
                /********************** Old Code *********************************/
                /* Mat Transaction */
                    /*$mat_locations1 = $this->inventory_model->get_data('mat_locations', array('material_name_id' =>  $_POST['material_scrap_id']));
                    if(!empty($mat_locations1)){
                        foreach($mat_locations1 as $loc11){
                                 $arr1[] =  json_encode(array(array('location' => $loc11['location_id'],'Storage' => $loc11['Storage'] , 'RackNumber' => $loc11['RackNumber'] , 'quantity' => $_POST['scrap_qty'] , 'Qtyuom' => '')));
                                 $rt1++;
                             }
                            $inventoryFlowDataArray1['current_location'] = $arr1[$i1];
                            $inventoryFlowDataArray1['material_id'] = $_POST['material_scrap_id'];
                            $inventoryFlowDataArray1['material_in'] =  $_POST['scrap_qty'];
                            $inventoryFlowDataArray1['uom'] = '';
                             $inventoryFlowDataArray1['material_type_id'] = $loc11['material_type_id'];
                            $inventoryFlowDataArray1['through'] = 'Scrap (+)';
                            $inventoryFlowDataArray1['ref_id'] = 0;
                            $inventoryFlowDataArray1['created_by'] = $_SESSION['loggedInUser']->id;
                            $inventoryFlowDataArray1['created_by_cid'] = $this->companyId;
                            $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray1);
                    }*/
                    /* Mat Transaction */

               # die;
			  
                if($data['location_id']){
                    if($scrap_material_arr){
                        foreach($scrap_material_arr as $scrapData){
                            $mat_scrap_location_single = $this->inventory_model->get_data_single('mat_locations', array('material_name_id' => $scrapData['material_name_id'],'location_id' => $data['location_id']));
							
							
                            if($mat_scrap_location_single){
                                $arrScrap =  json_encode(array(array('location' => $mat_scrap_location_single['location_id'],'Storage' => $mat_scrap_location_single['Storage'] , 'RackNumber' => $mat_scrap_location_single['RackNumber'] , 'quantity' => $scrapData['quantity']  , 'Qtyuom' => $scrapData['unit'])));

                                $yu = getNameById_mat('mat_locations',$scrapData['material_name_id'],'material_name_id');
                                $sum = 0;
                                if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                                $closingblcn = $sum + $scrapData['quantity'];
                                $inventoryFlowDataArray1['opening_blnc']     = $sum;
                                $inventoryFlowDataArray1['closing_blnc']     = $closingblcn;
                                $inventoryFlowDataArray1['current_location'] = $arrScrap;
                                $inventoryFlowDataArray1['material_id']      = $scrapData['material_name_id'];
                                $inventoryFlowDataArray1['material_in']      = $scrapData['quantity'];
                                $inventoryFlowDataArray1['uom']              = $scrapData['unit'];
                                $inventoryFlowDataArray1['material_type_id'] = $scrapData['material_type_id'];
                                $inventoryFlowDataArray1['through']          = 'Scrap (+)';
                                $inventoryFlowDataArray1['ref_id']           = 0;
                                $inventoryFlowDataArray1['created_by']       = $_SESSION['loggedInUser']->id;
                                $inventoryFlowDataArray1['created_by_cid']   = $this->companyId;
                                $this->inventory_model->insert_tbl_data2('inventory_flow', $inventoryFlowDataArray1);
                                $values = $this->inventory_model->get_data_single('mat_locations', array('material_name_id' => $scrapData['material_name_id'],'location_id' => $data['location_id']));
                                if($values){
                                    if($values['material_name_id'] == $scrapData['material_name_id']) {
                                        $updatedQty = $values['quantity'] + $scrapData['quantity'];
                                        $values['quantity'] = $updatedQty;
                                        $success = $this->inventory_model->update_single_field('mat_locations', $values, $scrapData['material_name_id']);
                                    }
                                }
                            } else {
                                $arr1 = array();
                                $mat_locations1 = $this->inventory_model->get_data('mat_locations', array('material_name_id' =>  $scrapData['material_name_id']));
								
								
                                if(!empty($mat_locations1)){
                                    foreach($mat_locations1 as $loc11){
                                        $arr1[] =  json_encode(array(array('location' => $loc11['location_id'],'Storage' => $loc11['Storage'] , 'RackNumber' => $loc11['RackNumber'] , 'quantity' => $scrapData['quantity'] , 'Qtyuom' => '')));
                                        $rt1++;
                                    }
                                    $yu = getNameById_mat('mat_locations',$scrapData['material_name_id'],'material_name_id');
                                    $sum = 0;
                                    if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                                    $closingblcn = $sum + $scrapData['quantity'];
                                    $inventoryFlowDataArray1['opening_blnc']        =   $sum;
                                    $inventoryFlowDataArray1['closing_blnc']        =   $closingblcn;
                                    $inventoryFlowDataArray1['current_location']    =   $arr1[$i1];
                                    $inventoryFlowDataArray1['material_id']         =   $scrapData['material_name_id'];
                                    $inventoryFlowDataArray1['material_in']         =   $scrapData['quantity'];
                                    $inventoryFlowDataArray1['uom']                 =   '';
                                    $inventoryFlowDataArray1['material_type_id']    =   $scrapData['material_type_id'];
                                    $inventoryFlowDataArray1['through']             =   'Scrap (+)';
                                    $inventoryFlowDataArray1['ref_id']              =   0;
                                    $inventoryFlowDataArray1['created_by']          =   $_SESSION['loggedInUser']->id;
                                    $inventoryFlowDataArray1['created_by_cid']      =   $this->companyId;
									// 
									
                                    $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray1);
                                    $getAddres = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $scrapData['material_name_id']));
                                    foreach($getAddres as & $values) {
                                        if($values['material_name_id'] == $scrapData['material_name_id']) {
                                            $updatedQty = $values['quantity'] + $scrapData['quantity'];
                                            $values['quantity'] = $updatedQty;
                                            $success = $this->inventory_model->update_single_field('mat_locations', $values, $scrapData['material_name_id']);
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
               }
			  
               if($materialUsedArray){
                    foreach($materialUsedArray as $inputArrayData){
                        $quantity = $inputArrayData['deduction_quantity'];
                        $whereCondition = array(
                            'material_id'       => $inputArrayData['material_name_id'],
                            'material_type_id'  => $inputArrayData['material_type_id'],
                            'work_order_id'     => $inputArrayData['work_order_id'],
                        );
                        $materialProcessDetails = $this->inventory_model->get_material_process_data('material_in_process_inventory_flow', $whereCondition);
						
                        if($materialProcessDetails){
                            $inventoryFlowDataArray['material_type_id'] = $inputArrayData['material_type_id'];
                            $inventoryFlowDataArray['material_id']      = $inputArrayData['material_name_id'];
                            $inventoryFlowDataArray['material_in']      = 0;
                            $inventoryFlowDataArray['material_out']     = $quantity ;
                            $inventoryFlowDataArray['opening_blnc']     = $materialProcessDetails['closing_blnc'];
                            $inventoryFlowDataArray['closing_blnc']     = $materialProcessDetails['closing_blnc'] - $quantity;
                            $inventoryFlowDataArray['uom']              = $inputArrayData['uom'];
                            $inventoryFlowDataArray['through']          = 'Finish Goods Data Material';
                            $inventoryFlowDataArray['ref_id']           = $inputArrayData['work_order_id'];
                            $inventoryFlowDataArray['created_by']       = $_SESSION['loggedInUser']->id;
                            $inventoryFlowDataArray['created_by_cid']   = $this->companyId;
							 
							
                            $this->inventory_model->insert_tbl_data('material_in_process_inventory_flow', $inventoryFlowDataArray);
                        } else {
                            $inventoryFlowDataArray['material_type_id'] = $inputArrayData['material_type_id'];
                            $inventoryFlowDataArray['material_id']      = $inputArrayData['material_name_id'];
                            $inventoryFlowDataArray['material_in']      = 0;
                            $inventoryFlowDataArray['material_out']     = $quantity;
                            $inventoryFlowDataArray['opening_blnc']     = 0;
                            $inventoryFlowDataArray['closing_blnc']     = '-'.$quantity;
                            $inventoryFlowDataArray['uom']              = $inputArrayData['uom'];
                            $inventoryFlowDataArray['through']          = 'Finish Goods Data Material';
                            $inventoryFlowDataArray['ref_id']           = $inputArrayData['work_order_id'];
                            $inventoryFlowDataArray['created_by']       = $_SESSION['loggedInUser']->id;
                            $inventoryFlowDataArray['created_by_cid']   = $this->companyId;
                            $this->inventory_model->insert_tbl_data('material_in_process_inventory_flow', $inventoryFlowDataArray);
                        }
                        $workProcessData = $this->inventory_model->getMaterialInProcessDetails('work_in_process_material',$whereCondition);
                        if($workProcessData){
                            $updateData = array('output' =>  $quantity);
                            $updateWorkProcess = $this->inventory_model->updateWorkProcessData('work_in_process_material',$whereCondition,$updateData);
                        }
                    }
               }
                $inventoryFlowDataArray1 = array();

                            foreach($materialUsedArray as $rr){
                                $quantity = $rr['deduction_quantity'];
                        
                                $getmatdata = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $rr['material_name_id'], 'material_type_id' => $rr['material_type_id'], 'location_id' => $_POST['location_id']));

                                $j = 0;
                                $material_data1 = array();
                                $l = 0;
                                $rt = 0;
                                $arr = [];
                                $closingblcn = 0;
                                 foreach($getmatdata as $key1){

                                    $yu = getNameById_mat('mat_locations',$rr['material_name_id'],'material_name_id');
                                    $sum = 0;
                                    if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                                    $closingblcn = ($sum >= $quantity) ? $sum - $quantity:$sum;

                                    if ($key1['material_name_id'] == $rr['material_name_id'] && $key1['location_id'] == $_POST['location_id']){   //&& $key1['Storage'] == $rr['storage']

                                        #//update quanity in mat_location
                                        $material_data1 = $key1;
                                        $closing_bal = ($key1['quantity'] >= $quantity) ? $key1['quantity'] - $quantity:$key1['quantity'];
                                        $material_data1['quantity'] = $closing_bal;
										
										
                                         
                                        $Update = $this->inventory_model->update_single_field('mat_locations', $material_data1);

                                        $arr[] =  json_encode(array(array('location' => $_POST['location_id'], 'quantity' => $closing_bal , 'Qtyuom' => $rr['Qtyuom'])));
                                        $rt++;
                                        $inventoryFlowDataArray1['current_location'] = $arr[$l];
                                        $inventoryFlowDataArray1['material_id'] = $rr['material_name_id'];
                                        $inventoryFlowDataArray1['material_out'] = $quantity;
                                        $inventoryFlowDataArray1['uom'] = $rr['uom'];
                                        $inventoryFlowDataArray1['opening_blnc'] = $sum; //$key1['quantity'];
                                        $inventoryFlowDataArray1['material_type_id'] = $key1['material_type_id'];
                                        $inventoryFlowDataArray1['closing_blnc'] = $closingblcn;
                                        if($rr['work_order_id'] != '') {
                                            $msg = 'Alloted in Finish Goods'; 
                                        }else if($rr['npdm'] != ''){
                                            $msg = 'Alloted in NPDM'; 
                                        }else if($rr['machine_name'] != ''){
                                            $msg = 'Alloted For Maintaince'; 
                                        }else{
                                            $msg = 'Issued for RM request';
                                        }
                                        $inventoryFlowDataArray1['through'] = $msg;
                                        $inventoryFlowDataArray1['ref_id'] = $insertedid;
                                        $inventoryFlowDataArray1['created_by'] = $_SESSION['loggedInUser']->id;
                                        $inventoryFlowDataArray1['created_by_cid'] = $this->companyId;
										
										// pre($inventoryFlowDataArray1);die();
                                          
                                        $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray1);

                                        #//Update lot materials
                                        //$this->material_Lot_inOut($rr['material_name_id']);
                                        #Update closing balance
                                        $this->update_closing_balance($rr['material_name_id']);
                                    }
                                }
                                $j++;
                            }
                         
               $success1 =  $this->inventory_model->insert_tbl_data('quality_finish_goods', $data);
                if ($success1) {
                    #pre("kk");
                    logActivity('Material receipt created ', 'material', $id);
                    $this->session->set_flashdata('message', 'Material receipt created successfully');
                    $usersWithViewPermissions = $this->inventory_model->get_dataw('permissions', array('is_view' => 1, 'sub_module_id' => 7));
                    if (!empty($usersWithViewPermissions)){
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                    pushNotification(array('subject' => 'Material receipt Created', 'message' => 'Material receipt Created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $userViewPermission['user_id'], 'to_id' => $userViewPermission['user_id'], 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                    }
                    }
                    }
                    if ($_SESSION['loggedInUser']->role != 1){
                    pushNotification(array('subject' => 'Material receipt Created', 'message' => 'Material receipt Created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                    }
                    pushNotification(array('subject' => 'Material receipt Created', 'message' => 'Material receipt Created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                    $email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
                    <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
                    <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi Test</p>
                    <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Material receipt created successfully.</p>
                    <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>
                    </td>
                    </tr>
                    </table>
                    </td>
                    </tr>';
                    //send_mail_notification($_SESSION['loggedInUser']->email, 'Notification Email For Material receipt', $email_message);
                    if($_SESSION['loggedInUser']->c_id){
                    $select = "email";
                    $where = 'c_id='.$_SESSION['loggedInUser']->c_id.' AND role=1';
                    $get_admin = $this->inventory_model->admin_email_data('user',$select, $where);
                    foreach ($get_admin as $key => $value) {
                    //send_mail_notification($value['email'], 'Notification Email For Material receipt', $email_message);
                    } }

                    redirect(base_url() . 'inventory/finish_goods', 'refresh');
                }
            }
        }
    }

    /*get data of closing stock amnt in inventory to check condtion if data avaialbe or not in script*/
    public function get_closing_material_qty() {
        $matrial_id = $_POST['mat_id'];
        #check material quanity
        $yu = getNameById_mat('mat_locations', $matrial_id, 'material_name_id');
        $sum = 0;
         if (!empty($yu)) {
            foreach ($yu as $ert) {
                $sum+= $ert['quantity'];
            }
        }

        #check reserved quanity
        $yu1 = getNameById_mat('reserved_material', $matrial_id, 'mayerial_id');
        $reserved = 0;
        if (!empty($yu1)){
            foreach ($yu1 as $ert1) {
                $reserved += $ert1['quantity'];
            }
        }
        $total = $sum - $reserved;
        echo $total;
    }

    /*getuom from material table in WIP*/
    public function getMaterialUomById() {
        if ($_POST['id'] != '') {
            $material = $this->inventory_model->get_data_byId('material', 'id', $_POST['id']);
			
            $ww = getNameById('uom', $material->uom, 'id');
			  // pre($ww);die();
            if (!empty($ww)) {
                $material->uom = $ww->ugc_code;
                $material->uomid = $ww->id;
            }
          
            echo json_encode($material);
        }
    }
    /*********************************************code for material Finsihs goods script function ****************************************************************/
    /* function get job card data ***/
    /////
    public function getJobCardDetail() {
        $jobCardid = $_POST['id'];
        $jobCardDetail = $this->inventory_model->getDataByJobId('job_card', 'id', $jobCardid);
        echo json_encode($jobCardDetail);
    }
    /* function get material name based on id  ***/
    /////
    public function getMaterialNameById_check() {
        //  pre($_POST);die;
        $mat_name_id = $_POST['material_name_id'];
        $GetmaterialName = $this->inventory_model->getDataByMatId('material', 'id', $mat_name_id);
        // $ddt     = json_encode($GetmaterialName);
        foreach ($GetmaterialName as $new_mat) {
            $get_uom_name = getNameById('uom', $new_mat['uom'], 'id');
            array_push($new_mat, $new_mat['uom_name'] = $get_uom_name->ugc_code);
            $new_mat['job_card_no'] = "";
            if (!empty($new_mat['job_card'])) {
                $get_job_card_name = getNameById('job_card', $new_mat['job_card'], 'id');
                array_push($new_mat, $new_mat['job_card_no'] = $get_job_card_name->job_card_no);
            }
            //pre($new_mat);die;
            echo json_encode($new_mat);
        }
    }
    public function getMaterialNameById() {
        $mat_name_id = $_POST['material_name_id'];
        $GetmaterialName = $this->inventory_model->getDataByMatId('material', 'id', $mat_name_id);
        echo json_encode($GetmaterialName);
    }
    public function monthlyReport() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Montly Report ', base_url() . 'monthlyReport');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Monthly Report';
        $where = array('created_by_cid' => $this->companyId);

         $raw_data = $this->inventory_model->get_data('material_type',$where);
         $mydt = array();
         $i = 0;

        foreach($raw_data as $rawdata){


            $where1  = "`material_type_id` =".$rawdata['id']." AND YEAR(inventory_flow.created_date) = YEAR(CURRENT_DATE()) AND MONTH(inventory_flow.created_date) = MONTH(CURRENT_DATE()) AND inventory_flow.created_by_cid = '" . $this->companyId . "' AND (SELECT MAX( id ) FROM inventory_flow) ORDER BY id DESC LIMIT 1";

            if (isset($_GET['start']) != '' && isset($_GET['end']) != '') {

                $where1  = "`material_type_id` =".$rawdata['id']." AND inventory_flow.created_date >='" . $_GET['start'] . "' and inventory_flow.created_date<='" . $_GET['end'] . "' AND inventory_flow.created_by_cid = '" . $this->companyId . "' AND (SELECT MAX( id ) FROM inventory_flow) ORDER BY id DESC LIMIT 1";


               # $inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and save_status = 1 and lead_industry != 0 and leads.created_by_cid = '" . $this->companyGroupId . "'";
            }
            if (isset($_GET['start']) != '' && isset($_GET['end']) != '' && isset($_GET['ExportType']) != '') {
                #echo "dede";

                $where1  = "`material_type_id` =".$rawdata['id']." AND inventory_flow.created_date >='" . $_GET['start'] . "' and inventory_flow.created_date<='" . $_GET['end'] . "' AND inventory_flow.created_by_cid = '" . $this->companyId . "' AND (SELECT MAX( id ) FROM inventory_flow) ORDER BY id DESC LIMIT 1";


                #$inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and save_status = 1 and lead_industry != 0 and leads.created_by_cid = '" . $this->companyGroupId . "'";
            }
            if (isset($_GET['ExportType']) && $_GET['start'] == '' && $_GET['end'] == '') {

                $where1  = "`material_type_id` =".$rawdata['id']." AND YEAR(inventory_flow.created_date) = YEAR(CURRENT_DATE()) AND MONTH(inventory_flow.created_date) = MONTH(CURRENT_DATE()) AND inventory_flow.created_by_cid = '" . $this->companyId . "' AND (SELECT MAX( id ) FROM inventory_flow) ORDER BY id DESC LIMIT 1";


                #$inProcessWhere = " save_status = 1 and lead_industry != 0 and leads.created_by_cid = '" . $this->companyGroupId . "' AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND MONTH(created_date) = MONTH(CURRENT_DATE())";

            } elseif (isset($_GET['ExportType']) && isset($_GET['start']) != '' && isset($_GET['end']) != '') {

                 $where1  = "`material_type_id` =".$rawdata['id']." AND inventory_flow.created_date >='" . $_GET['start'] . "' and inventory_flow.created_date<='" . $_GET['end'] . "' AND inventory_flow.created_by_cid = '" . $this->companyId . "' AND (SELECT MAX( id ) FROM inventory_flow) ORDER BY id DESC LIMIT 1";


                #$inProcessWhere = "leads.created_date >='" . $_GET['start'] . "' and leads.created_date<='" . $_GET['end'] . "' and save_status = 1 and lead_industry != 0 and leads.created_by_cid = '" . $this->companyGroupId . "'";
            }

                 $inventyr_flow = $this->inventory_model->get_data('inventory_flow',$where1);
                #pre($inventyr_flow);
                 $yui = array();
                 foreach ($inventyr_flow as $key) {
                //  #pre($key);
                    $yui = $key;
                //  #$i++;
                 }
                 if(!empty($yui)){
                    $mydt[$i] = $yui;
                 }
                 $i++;
        }
          $this->data['monthlyReport'] = $mydt;
        $this->_render_template('monthlyReport/index', $this->data);
    }
    /*************************combine inventory listing and adjustment***********************************/
    public function inventory_listing_and_adjustment() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Inventory Listing', base_url() . 'inventory_listing');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Inventory Listing';
        if (!empty($_POST) && isset($_POST['start']) && isset($_POST['end']) && $_POST['company_unit'] == '') {
            $where = "material.created_by_cid = " . $this->companyId . " AND (material.save_status = 1 ) AND  (material.created_date >='" . $_POST['start'] . "' AND  material.created_date <='" . $_POST['end'] . "')";
            $this->data['listing'] = $this->inventory_model->get_data_fromMaterial('material', $where);
            $this->_render_template('inventory_listing_and_adjustment/index', $this->data);
        } elseif (!empty($_POST) && $_POST['company_unit'] != '' && $_POST['start'] != '' && $_POST['end'] != '') {
            $company_unit_id = $_POST['company_unit'];
            //$where  = "material.created_by_cid = ".$_SESSION['loggedInUser']->c_id." AND  (material.created_date >='".$_POST['start']."' AND  material.created_date <='".$_POST['end']."')";
            $where = "material.created_by_cid = " . $this->companyId . " AND  (material.created_date >='" . $_POST['start'] . "' AND  material.created_date <='" . $_POST['end'] . "')";
            $this->data['listing'] = $this->inventory_model->get_data_fromMaterial_basedOnloc('material', $where, $company_unit_id);
            $this->_render_template('inventory_listing_and_adjustment/index', $this->data);
        } elseif (!empty($_POST) && $_POST['company_unit'] != '' && $_POST['start'] == '' && $_POST['end'] == '') {
            $id = $this->input->get_post('value');
            $company_unit_id = $_POST['company_unit'];
            $where = "material.created_by_cid = " . $this->companyId;
            $this->data['listing'] = $this->inventory_model->get_data_fromMaterial_basedOnloc('material', $where, $company_unit_id);
            $where12 = "material_type.created_by_cid = " . $this->companyId . " OR material_type.created_by_cid = 0";
            $this->data['type2'] = $this->inventory_model->get_data('material_type', $where12);
            $this->_render_template('inventory_listing_and_adjustment/index', $this->data);
        }
        $where12 = "material_type.created_by_cid = " . $this->companyId . " OR material_type.created_by_cid = 0";
        $this->data['type2'] = $this->inventory_model->get_data('material_type', $where12);
        //$where_thrd_type = "thrd_party_invtry.created_by_cid = " . $this->companyId ;
        $where_thrd_type = 'thrd_party_invtry.created_by_cid = " '. $this->companyId . '" ORDER BY id DESC ';
        $this->data['third_invt_type_data'] = $this->inventory_model->get_data('thrd_party_invtry', $where_thrd_type);
        $idMat = $this->input->get_post('value');
        if (isset($idMat)) {
            $idMat = $this->input->get_post('value');
        } else {
            $idMat = "";
        }
        $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1, 'material.material_type_id' => $idMat, 'material.status' => 1);
        $this->data['listing'] = $this->inventory_model->get_data_fromMaterial('material', $where);
        $this->data['type'] = array_unique(array_column($this->data['listing'], 'material_type_id'));
        $type = array_unique(array_column($this->data['listing'], 'material_type_id'));
        $MaterailListingData = $this->inventory_model->get_data_fromMaterial('material', $where);
        $subTypeArray = array();
        foreach ($type as $type_material) {
            foreach ($MaterailListingData as $list_data) {
                if ($type_material == $list_data['material_type_id']) {
                    $subTypeArray[$list_data["material_type_id"]]["material_type_id"] = $list_data["material_type_id"];
                    $subTypeArray[$list_data["material_type_id"]]["material_detail"][] = array('sub_type' => $list_data["sub_type"], 'material_name' => $list_data["material_name"], 'material_name_id' => $list_data["material_name_id"], 'uom' => $list_data['uom'], 'location' => $list_data['location']);
                    #pre($list_data['location']);
                }
            }
        }
        $this->data['subTypeArray'] = $subTypeArray;
        if (!empty($_POST) && $_POST['ajax_var'] == 'via_ajax') {
            $a = $this->load->view('inventory_listing_and_adjustment/ajax_mat', $this->data);
            return $a;
        } elseif (!empty($_POST) && $_POST['ajax_var'] == 'via_ajaxwip') {
            $a = $this->load->view('inventory_listing_and_adjustment/ajax_matwip', $this->data);
            return $a;
        } else {
            $this->_render_template('inventory_listing_and_adjustment/index', $this->data);
        }
    }
    public function inventory_listing_and_adjustment_excel(){

        if (isset($_POST['third_party']) && $_POST['third_party'] == 'third_party_listing') {
            $filename = "Third Party Inventory";
            $where_thrd_type = 'thrd_party_invtry.created_by_cid = " '. $this->companyId . '" ORDER BY id DESC ';
            $this->data['third_invt_type_data'] = $this->inventory_model->get_data('thrd_party_invtry', $where_thrd_type);
            foreach($this->data['third_invt_type_data'] as $rows){
                $challan_number = sprintf("%04s", $rows['challan_number']);
                $material_id_datas = json_decode($rows['material_descr'],true);
                $quentity = '';
                foreach($material_id_datas as $materialData){
                    $ww =  getNameById('uom', $materialData['UOM'],'id');
                    $uom = !empty($ww)?$ww->ugc_code:'';
                    $quentity += $materialData['quantity'];
                }
                $party_name = getNameById('ledger',$rows['party_name'],'id');
                $output[] = array('Challan Number' => $challan_number, 'Party Name' => $party_name->name, 'Total Qty' => $quentity, 'UOM' => $uom, 'Total Amount' => $rows['challan_totl_amt']);
            }
        }else{
            $filename = "Inventory";
            $where12 = "material_type.created_by_cid = " . $this->companyId . " OR material_type.created_by_cid = 0";
            $this->data['type2'] = $this->inventory_model->get_data('material_type', $where12);
            $idMat = isset($_POST['mat_id']) ? $_POST['mat_id']:'';
            if (!empty($idMat)){
                $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1, 'material.material_type_id' => $idMat);
            } else {
                $where = "material.created_by_cid = '".$this->companyId."' and material.save_status = 1 and material.material_type_id != 0";
            }
            $this->data['listing'] = $this->inventory_model->get_data_fromMaterial('material', $where);
            $this->data['type'] = array_unique(array_column($this->data['listing'], 'material_type_id'));
            $type = array_unique(array_column($this->data['listing'], 'material_type_id'));
            $MaterailListingData = $this->inventory_model->get_data_fromMaterial('material', $where);
            $subTypeArray = array();
            foreach ($type as $type_material) {
                foreach ($MaterailListingData as $list_data) {
                    # pre($list_data);
                    if ($type_material == $list_data['material_type_id']) {
                        $subTypeArray[$list_data["material_type_id"]]["material_type_id"] = $list_data["material_type_id"];
                        $subTypeArray[$list_data["material_type_id"]]["material_detail"][] = array('sub_type' => $list_data["sub_type"], 'material_name' => $list_data["material_name"], 'material_name_id' => $list_data["material_name_id"], 'uom' => $list_data['uom'], 'location' => $list_data['location']);
                    }
                }
            }
            $this->data['subTypeArray'] = $subTypeArray;
            $i = 0;
            $mat_name = getNameById('material_type', $_POST['mat_id'], 'id');
            $mname = !empty($mat_name) ? $mat_name->name : '';
            if (!empty($subTypeArray)){
                foreach ($subTypeArray as $subType_listing) {
                    $materialTypeName = getNameById('material_type', $subType_listing['material_type_id'], 'id');
                    $subtypeArray = array();
                    $CombinedArray = array();
                    foreach ($subType_listing['material_detail'] as $key => $subType) {
                        $subtypeArray[] = $subType['sub_type'];
                        $uniqeArrayvalue = array_unique($subtypeArray);
                        foreach ($uniqeArrayvalue as $unique_value) {
                            if ($unique_value == $subType['sub_type']) {
                                $CombinedArray[$subType["sub_type"]]['sub_type'] = $subType["sub_type"];
                                $CombinedArray[$subType["sub_type"]]['material'][] = array('material_name' => $subType["material_name"], 'material_name_id' => $subType["material_name_id"], 'uom' => $subType['uom'], 'location' => $subType['location']);
                            }
                        }
                    }

                    $k = 0;
                    foreach ($CombinedArray as $combinedValue) {
                        if ($combinedValue['sub_type'] != '') {
                        } elseif ($combinedValue['sub_type'] == '') {
                        }
                        $j = 0;
                        foreach ($combinedValue['material'] as $key => $mat_detail) {
                            $ww = getNameById('uom', $mat_detail['uom'], 'id');
                            $uom = !empty($ww) ? $ww->ugc_code : '';
                            $sum = 0;
                            foreach ($mat_detail['location'] as $ert) {
                                $sum+= $ert['qty'];
                            }
                            if ($sum > 0 || $sum < 0) {
                                $output[] = array('Material Type' => $mname, 'Material Sub Type' => $combinedValue['sub_type'], 'Material Name' => $mat_detail['material_name'], 'Quantity' => $sum, 'UOM' => $uom,);
                                $n = 0;
                                foreach ($mat_detail['location'] as $key1 => $locationData) {
                                    $ww = getNameById('uom', $locationData['Qtyuom'], 'id');
                                    $uom = !empty($ww) ? $ww->ugc_code : '';
                                    $locationName = getNameById('company_address', $locationData['location'], 'id');
                                }
                                $n++;
                            }
                        }
                        $j++;
                        $k++;
                    }
                    $i++;
                }
                //pre($output);die;
            }
        }
        if (isset($output)) {
            $filename = $filename . ".xls";
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            ExportFile($output);
        } else {
            echo "<script>alert('No Data Found');</script>";
            redirect(base_url() . 'inventory/inventory_listing_and_adjustment', 'refresh');
        }
    }


    public function inventory_adjustmentListing_view(){
        $this->breadcrumb->add('Inventory', base_url() . 'Inventory Listing and Adjustment View');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Inventory Listing and Adjustment View';
        $id = $_GET['id'];
        permissions_redirect('is_view');

        $cYearDate = date('Y-04-01');
        $nYearDate = date('Y-03-30', strtotime('+1 year'));
        $where = "created_date >= '".$cYearDate."' AND created_date <= '".$nYearDate."' AND material_id = '".$id."' order by id desc";
        if(isset($_GET['start']) != '' && isset($_GET['end']) != ''){
            $where = "created_date >='".$_GET['start']."' AND created_date <= '" .$_GET['end']. "' AND material_id = '".$id."' order by id desc";
        }
        $this->data['mat_trans'] = $this->inventory_model->get_dataw('inventory_flow', $where);
        $this->_render_template('inventory_listing_and_adjustment/view', $this->data);
    }

    public function inventory_adjustmentListing_view_bydate() {
          $this->breadcrumb->add('Inventory', base_url() . 'Inventory Listing and Adjustment View');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Inventory Listing and Adjustment View';
        $date = $_GET['date'];
        $idmt = $_GET['mat_id'];
        permissions_redirect('is_view');

        $date2 = date_create($date);
        $rty =  date_format($date2,"Y-m-d");

        $where = "date(created_date) = date('".$rty."') AND material_id = '".$idmt."'";
        $this->data['mat_trans'] = $this->inventory_model->get_dataw('inventory_flow',$where);
        $this->_render_template('inventory_listing_and_adjustment/view_details', $this->data);
    }


    /* Function to SAVE movement of inventory listing */
    public function saveInventoryListingAdjustment(){
        $action_type = $_POST['action_type'];
        if ($this->input->post()) {
            $required_fields = array('uom');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $data['created_by'] = $_SESSION['loggedInUser']->id;
                #$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
                $data['created_by_cid'] = $this->companyId;
                $id = $data['id'];

                #*************Scrap / consumed  insertion***********#
                $selectedAddress_array = '';
                if($action_type == "consumed" || $action_type == "Rejected" || $action_type == "scrap"){
                    #**************Selected location data*********************#
                    $selectedAddress = count($_POST['selectedAddress']);
                    if ($selectedAddress > 0) {
                        $n = 0;
                        while ($n < $selectedAddress) {
                            $selectedAddArray = [];
                            $jsonArraySelected = (array('source_location' => isset($_POST['selectedAddress'][$n]) ? $_POST['selectedAddress'][$n] : '', 'source_storage' => isset($_POST['selectedArea'][$n]) ? $_POST['selectedArea'][$n] : '', 'source_rack_no' => isset($_POST['selectedRack'][$n]) ? $_POST['selectedRack'][$n] : '', 'source_lot_no' => isset($_POST['selectedLotNo'][$n]) ? $_POST['selectedLotNo'][$n]:'', 'source_quantity' => isset($_POST['selectedQty'][$n]) ? $_POST['selectedQty'][$n] : '', 'source_Qtyuom' => isset($_POST['selectedUom'][$n]) ? $_POST['selectedUom'][$n] : ''));
                            $selectedAddArray = $jsonArraySelected;
                            $n++;
                        }
                        $selectedAddress_array = json_encode($selectedAddArray);
                    }
                    $data['source_address'] = $selectedAddress_array;

                    #******** Selected location Id with Consumed/Scrap Quantity ************#
                    $selectedAddress1 = count($_POST['selectedAddress']);
                    if($selectedAddress1 > 0){
                        $arr = [];
                        $n = 0;
                        while ($n < $selectedAddress1) {
                            $selectedAddArray1 = [];
                            $id_loc = !empty($_POST['selctedAddrId'][$n]) ? $_POST['selctedAddrId'][$n]:'';
                            $jsonArraySelected1 = (array('id_loc' => $id_loc, 'location' => isset($_POST['selectedAddress'][$n]) ? $_POST['selectedAddress'][$n] : '', 'Storage' => isset($_POST['selectedArea'][$n]) ? $_POST['selectedArea'][$n] : '', 'RackNumber' => isset($_POST['selectedRack'][$n]) ? $_POST['selectedRack'][$n] : '', 'lot_no' => isset($_POST['selectedLotNo'][$n]) ? $_POST['selectedLotNo'][$n]:'', 'quantity' => $data['quantity'], 'Qtyuom' => isset($_POST['selectedUom'][$n]) ? $_POST['selectedUom'][$n] : ''));
                            $arr[] = $jsonArraySelected1;
                            $arr[$n] = $jsonArraySelected1;
                            $n++;
                        }
                        $selectedAddress_array1 = json_encode($arr);
                    } else {
                        $selectedAddress_array1 = '';
                    }
                    $sourceAddressArray = json_decode($selectedAddress_array1);
                }

                if($action_type == 'consumed')
                {
                    $insertedAdjustmentid = $this->inventory_model->insert_tbl_data('inventory_listing_adjustment', $data);

                    #Inventory In-Out Flow - Consumed
                    if(!empty($sourceAddressArray)){
                        foreach ($sourceAddressArray as $addArray){
                            $this->material_move_inOut($data['material_name_id'], $data['material_type_id'], $addArray, 'consumed');
                        }
                    }
                    $message = "Product consumed successfully";
                    logActivity($message, 'mat_locations & inventory_flow', $id);
                }
                else if($action_type == 'Rejected')
                {
                    //pre($data); die;
                    $insertedAdjustmentid = $this->inventory_model->insert_tbl_data('inventory_listing_adjustment', $data);

                    #Inventory In-Out Flow - Consumed
                    if(!empty($sourceAddressArray)){
                        foreach ($sourceAddressArray as $addArray){
                            $this->material_move_inOut($data['material_name_id'], $data['material_type_id'], $addArray, 'Rejected');
                        }
                    }
                    $message = "Quentity rejected successfully";
                    logActivity($message, 'mat_locations & inventory_flow', $id);
                }
                else if($action_type == 'scrap')
                {
					$data['material_name_id'] = $data['scrapIntoMaterial_id'];//  add Scrap into in Scrap Into ID
					
					
                    $insertedAdjustmentid = $this->inventory_model->insert_tbl_data('inventory_listing_adjustment', $data);

                    #Inventory Out Flow - Scrap
                    if(!empty($sourceAddressArray)){
                        foreach($sourceAddressArray as $addArray){
							// pre($addArray);
							// pre($data;
							
							// die();
                          // $this->material_move_inOut($data['material_name_id'], $data['material_type_id'], $addArray, 'scrap');
						  
                            $this->material_move_inOut($data['material_name_id'], 26, $addArray, 'scrap');
                        }
                    }
                    #Inventory in Flow - Scrap
                    if(isset($_POST['scrapIntoMaterial_id'])){
                        $n = 0;
                        $arr2 = [];
                        $scrapIntoMaterial_id = $_POST['scrapIntoMaterial_id'];
                        $getmaterialType = getNameById_mat('material', $scrapIntoMaterial_id, 'id');
                        $material_type_id = !empty($getmaterialType[0]['material_type_id']) ? $getmaterialType[0]['material_type_id']:0;
                        $checkData = getNameById_mat('mat_locations',$scrapIntoMaterial_id,'material_name_id');
                        if(!empty($checkData)){
                            foreach($checkData as $rows){
                                $jsonArraySelected1 = (array('location' => $rows['location_id'], 'Storage' => $rows['Storage'], 'RackNumber' => $rows['RackNumber'], 'lot_no' => $rows['lot_no'], 'quantity' => $data['quantity'], 'Qtyuom' => $rows['Qtyuom']));
                                $arr2[] = $jsonArraySelected1;
                                break;
                            }
                        }else{
                            if($selectedAddress1 > 0){                                                              ;
                                while ($n < $selectedAddress1) {
                                    $jsonArraySelected1 = (array('location' => isset($_POST['selectedAddress'][$n]) ? $_POST['selectedAddress'][$n] : '', 'Storage' => isset($_POST['selectedArea'][$n]) ? $_POST['selectedArea'][$n] : '', 'RackNumber' => isset($_POST['selectedRack'][$n]) ? $_POST['selectedRack'][$n] : '', 'lot_no' => isset($_POST['selectedLotNo'][$n]) ? $_POST['selectedLotNo'][$n]:'', 'quantity' => $data['quantity'], 'Qtyuom' => isset($_POST['selectedUom'][$n]) ? $_POST['selectedUom'][$n] : ''));
                                    $arr2[] = $jsonArraySelected1;
                                    break;
                                    $n++;
                                }
                            }
                        }
                        $selectedAddress_array2 = json_encode($arr2);
                        $sourceAddressArray1 = json_decode($selectedAddress_array2);
                        if(!empty($sourceAddressArray1)){
                            foreach($sourceAddressArray1 as $addArray1){
                                #scrap quantity move in scrap material
                                // $this->material_move_inOut($scrapIntoMaterial_id, $material_type_id, $addArray1, 'move');
                                $this->material_move_inOut($scrapIntoMaterial_id, 26, $addArray1, 'move');
                            }
                        }
                    }
                    $message = "Product scrap successfully";
                    logActivity($message, 'mat_locations & inventory_flow', $id);
                }
                #*************material_conversion insertion***********#
                else if($action_type == "material_conversion")
                {
                    $i = 0;
                    $arr = $arr1 = [];
                    $rt = $rt1 = 0;
                    $closingblcn = $closingblcn1 = 0;

                    $destination22 = count($_POST['material_type_id']);
                    if ($destination22 > 0) {
                        $arr22 = [];
                        $i22 = 0;
                        while ($i22 < $destination22) {
                            $jsonArrayObject22 = (array('id_loc' => $_POST['selctedAddrId'][$i], 'material_type_id' => $_POST['material_type_id'][$i22], 'converted_material_id' => $_POST['converted_material_id'][$i22], 'converted_qty' => $_POST['converted_qty'][$i22],'location' => $_POST['location'][$i22], 'storage' => $_POST['storage'][$i22], 'RackNumber' => $_POST['RackNumber'][$i22], 'uom' => $_POST['uom'][$i22]));
                            $arr22[] = $jsonArrayObject22;
                            $i22++;
                        }
                        $destination_array22 = json_encode($arr22);
                    }

                    $destinationdata = json_decode($destination_array22, true);
                    foreach($destinationdata as $data22){

                        $yu = getNameById_mat('mat_locations',$_POST['material_name_id'],'material_name_id');
                        $sum = 0;
                        if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                        $closingblcn = $sum - $data22['converted_qty'];

                        $yu1 = getNameById_mat('mat_locations',$data22['converted_material_id'],'material_name_id');
                        $sum1 = 0;
                        if(!empty($yu1)){ foreach ($yu1 as $ert1) {$sum1 += $ert1['quantity'];}}
                        $closingblcn1 = $sum1 + $data22['converted_qty'];

                        #************check source location where material conversion added***********#
                        $getAddres1 = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $data22['converted_material_id']));
                        if(!empty($getAddres1))
                        {
                            #************Remove from***********#
                            $getAddres = $this->inventory_model->get_data('mat_locations', array('id' => $data22['id_loc']));
                            if(!empty($getAddres))
                            {
                                $ref_id = 0;
                                $updatedQty = $data22['converted_qty'];
                                foreach($getAddres as $values){
                                    $ref_id = $values['id'];
                                    $updatedQty = intval($values['quantity']) - intval($data22['converted_qty']);
                                    $values['quantity'] = $updatedQty;
                                    #pre($values);
                                    $updateSuccess = $this->inventory_model->update_single_field('mat_locations', $values);
                                }

                                foreach($getAddres as $loc){
                                    $arr[$i] = json_encode(array(array('location' => $loc['location_id'],'Storage' => $loc['Storage'] , 'RackNumber' => $loc['RackNumber'] , 'quantity' => $updatedQty , 'Qtyuom' => $loc['Qtyuom'])));
                                    $rt++;
                                }

                                $inventoryFlowDataArray['current_location'] = $arr[$i];
                                $inventoryFlowDataArray['material_id'] = $_POST['material_name_id'];
                                $inventoryFlowDataArray['material_out'] = $data22['converted_qty'];
                                $inventoryFlowDataArray['uom'] = $loc['Qtyuom'];
                                $inventoryFlowDataArray['opening_blnc'] = $sum;
                                $inventoryFlowDataArray['closing_blnc'] = $closingblcn;
                                $inventoryFlowDataArray['material_type_id'] = $loc['material_type_id'];
                                $inventoryFlowDataArray['through'] = 'Material Conversion';
                                $inventoryFlowDataArray['ref_id'] = $ref_id;
                                $inventoryFlowDataArray['created_by'] = $_SESSION['loggedInUser']->id;
                                $inventoryFlowDataArray['created_by_cid'] = $this->companyId;
                                #pre($inventoryFlowDataArray);
                                $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);
                                #Update lot materials
                                $this->material_Lot_inOut($_POST['material_name_id']);
                            }


                            #************Added In***********#
                            $ref_id = 0;
                            $updatedQty1 = $data22['converted_qty'];
                            if($data22['RackNumber'] == ''){
                                $data22['RackNumber'] = 0;
                            }
                            foreach ($getAddres1 as $values1){
                                if($values1['location_id'] == $data22['location'] && $values1['Storage'] == $data22['storage'])
                                {
                                    $ref_id = $values1['id'];
                                    $updatedQty1 = intval($values1['quantity']) + intval($data22['converted_qty']);
                                    $values1['quantity'] = $updatedQty1;
                                    #pre($values1);
                                    $updateSuccess = $this->inventory_model->update_single_field('mat_locations', $values1);
                                }
                            }

                            $arr1[$i] =  json_encode(array(array('location' => $data22['location'],'Storage' => $data22['storage'] , 'RackNumber' => $data22['RackNumber'] , 'quantity' => $updatedQty1 , 'Qtyuom' => $data22['uom'])));
                            $inventoryFlowDataArray1['current_location'] = $arr1[$i];
                            $inventoryFlowDataArray1['material_id'] = $data22['converted_material_id'];
                            $inventoryFlowDataArray1['material_in'] = $data22['converted_qty'];
                            $inventoryFlowDataArray1['uom'] = $data22['uom'];
                            $inventoryFlowDataArray1['opening_blnc'] = $sum1;
                            $inventoryFlowDataArray1['material_type_id'] = $data22['material_type_id'];
                            $inventoryFlowDataArray1['closing_blnc'] = $closingblcn1;
                            $inventoryFlowDataArray1['through'] = 'Material Conversion';
                            $inventoryFlowDataArray1['ref_id'] = $ref_id;
                            $inventoryFlowDataArray1['created_by'] = $_SESSION['loggedInUser']->id;
                            $inventoryFlowDataArray1['created_by_cid'] = $this->companyId;
                            #pre($inventoryFlowDataArray1);
                            $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray1);
                            #Update lot materials
                            $this->material_Lot_inOut($data22['converted_material_id']);

                            $message = "Material Conversion successfully";
                            logActivity($message, 'mat_locations & inventory_flow', $id);
                            $i++;
                        }
                    }
                }
            }
            $data['message'] = "Data inserted successfully";
            $this->session->set_flashdata('message', 'Data inserted successfully');
            redirect(base_url() . 'inventory/inventory_listing_and_adjustment', 'refresh');
        }
    }


    /******* Move Material *******/
    public function saveMove(){
        $actionType = $_POST['action_type'];
        if ($this->input->post()) {
            $required_fields = array('uom');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $selectedAddress_array = '';
                $destination_array = '';
                $sourceAddressArray = '';
                #**************Selected location data*********************#
                $selectedAddress = count($_POST['selectedAddress']);
                if ($selectedAddress > 0){
                    $n = 0;
                    while ($n < $selectedAddress){
                        $selectedAddArray = [];
                        $jsonArraySelected = (array('source_location' => isset($_POST['selectedAddress'][$n]) ? $_POST['selectedAddress'][$n] : '', 'source_storage' => isset($_POST['selectedArea'][$n]) ? $_POST['selectedArea'][$n] : '', 'source_rack_no' => isset($_POST['selectedRack'][$n]) ? $_POST['selectedRack'][$n] : '', 'source_lot_no' => isset($_POST['selectedLotNo'][$n]) ? $_POST['selectedLotNo'][$n] : '', 'source_quantity' => isset($_POST['selectedQty'][$n]) ? $_POST['selectedQty'][$n] : '', 'source_Qtyuom' => isset($_POST['selectedUom'][$n]) ? $_POST['selectedUom'][$n] : ''));
                        $selectedAddArray = $jsonArraySelected;
                        $n++;
                    }
                    $selectedAddress_array = json_encode($selectedAddArray);
                }

                #*****************New address where material is moved***************#
                $destination = count($_POST['location']);
                if ($destination > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $destination) {
                        $jsonArrayObject = (array('location' => $_POST['location'][$i], 'Storage' => $_POST['storage'][$i], 'quantity' => $_POST['quantity'][$i], 'Qtyuom' => $_POST['uom']));
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $destination_array = json_encode($arr);
                }

                #******** Selected location Id with New location where material is moved ************#
                $source_location = count($_POST['location']);
                if ($source_location > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $source_location) {
                        $id_loc = !empty($_POST['selctedAddrId'][$i]) ? $_POST['selctedAddrId'][$i]:'';
                        $jsonArrayObject = (array('id_loc' => $id_loc, 'location' => $_POST['location'][$i], 'Storage' => $_POST['storage'][$i], 'quantity' => $_POST['quantity'][$i], 'Qtyuom' => $_POST['uom']));
                        $arr[] = $jsonArrayObject;
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $sourceAdd_array = json_encode($arr);
                } else {
                    $sourceAdd_array = '';
                }
                $sourceAddressArray = json_decode($sourceAdd_array);

                $id = $data['material_name_id'];
                #Inventory listing adjustment
                $data['source_address'] = $selectedAddress_array;
                $data['destination_address'] = $destination_array;
				
				// pre($data);
				
				// die();
				
                $iladata = array('destination_address' => $data['destination_address'], 'source_address' => $data['source_address'], 'action_type' => $data['action_type'], 'material_type_id' => $data['material_type_id'], 'material_name_id' => $data['material_name_id'], 'date' => $data['date']);
				
				
				
				
				
                $insertedAdjustmentid = $this->inventory_model->insert_tbl_data('inventory_listing_adjustment', $iladata);

                #Inventory In-Out Flow - Move
                if(!empty($sourceAddressArray)){
                    foreach($sourceAddressArray as $addArray){
                        $this->material_move_inOut($data['material_name_id'], $data['material_type_id'], $addArray, 'move');
                    }
                }

                $message = "Product Moved successfully";
                logActivity($message, 'mat_locations & inventory_flow', $id);
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'inventory/inventory_listing_and_adjustment', 'refresh');
            }
        }
    }

    /*********************************************************************************/
    # Material Move In-Out Common Function
    # Required Param.: Meterial Id, Material Type and addArray as Object/Array
    # Object keys:- {id_loc, location, Storage, RackNumber, quantity, Qtyuom, lot_no}
    # Note:- id_loc => mat_locations's exist id,
    #        quantity => Move, Consumed, Scrap Quantity
    /********************************************************************************/
    public function material_move_inOut($materialId, $material_type, $addArray, $action=''){
		
		
		
		 // pre($material_type);
		 // pre($addArray->location);
		// pre($action);
		
		
		 

        if(!empty($addArray)){
            $addArray = is_array($addArray) ? (object)$addArray:$addArray;
            $i = 0;
            $arr = array();
            $updateDatalocation = array();
            $inventoryFlowDataArray = array();

            #Get location wise material details (total quanity)
            $yu = getNameById_mat('mat_locations',$materialId,'material_name_id');
            $sum = 0;
            if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
            $closing_blnc = $sum + $addArray->quantity;

            #check data based on selected AddressId
            if(!empty($addArray->id_loc)){
                $existMatLocation = $this->inventory_model->get_data('mat_locations', array('id' => $addArray->id_loc));
            }
            if(!empty($existMatLocation)){
                foreach($existMatLocation as $elmdate){
                    $updateDatalocation = $elmdate;

                    #set opening balance
                    $inventoryFlowDataArray['opening_blnc'] = $sum;

                    $existQty = $elmdate['quantity'];
                    if($existQty >= $addArray->quantity){
                        $leftQuantity = $existQty - $addArray->quantity;
                        $closing_blnc = $sum - $addArray->quantity;
                        $updateDatalocation['quantity'] = $leftQuantity;
                    }

                    $arr[] =  json_encode(array(array('location' => $elmdate['location_id'], 'Storage' => $elmdate['Storage'] , 'RackNumber' => $elmdate['RackNumber'] , 'lot_no' => $elmdate['lot_no'] , 'quantity' => $leftQuantity , 'Qtyuom' => $elmdate['Qtyuom'])));

                    #inventoryFlowDataArray - Exist location with New Rack
                    $inventoryFlowDataArray['current_location'] = $arr[$i];
                    $inventoryFlowDataArray['material_out'] = $addArray->quantity;
                    $inventoryFlowDataArray['ref_id'] = $updateDatalocation['id'];

                    if($action == 'move'){
                        $inventoryFlowDataArray['through'] = 'Move, (-) Source Location';
                    }
                    if($action == 'consumed'){
                        $inventoryFlowDataArray['through'] = 'Consumed';
                    }
                    if($action == 'Rejected'){
                        $inventoryFlowDataArray['through'] = 'Rejected';
                    }
                    if($action == 'scrap'){
                        $inventoryFlowDataArray['through'] = 'Scrap (-)';
                    }
                    #Set closing balance
                    $inventoryFlowDataArray['closing_blnc'] = $closing_blnc;
                    #update mat location table
                    $updateSuccess = $this->inventory_model->update_single_field('mat_locations', $updateDatalocation);
                }

                $inventoryFlowDataArray['material_type_id'] = $material_type;
                $inventoryFlowDataArray['material_id'] = $materialId;
                $inventoryFlowDataArray['uom'] = $addArray->Qtyuom;
                $inventoryFlowDataArray['created_by'] = isset($_SESSION['loggedInUser']->id) ? $_SESSION['loggedInUser']->id:0;
                $inventoryFlowDataArray['created_by_cid'] = $this->companyId;
                $removeFlow = $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);
            }

            #Move material flow
            $arr1 = array();
            $updateDatalocation1 = array();
            $inventoryFlowDataArray1 = array();

            #Get location wise material details (total quanity)
            // $yu1 = getNameById_mat('mat_locations',$materialId,'material_name_id');
			 $yu1 = getNameById_matWithLoc('mat_locations',$materialId,'material_name_id','location_id',$addArray->location);
			

            $sum1 = 0;
            if(!empty($yu1)){ foreach ($yu1 as $ert1) {$sum1 += $ert1['quantity'];}}
            $closing_blnc1 = $sum1 + $addArray->quantity;
			
			
			
			
			if($action == 'scrap'){
				
				// pre();
				$matDetails = getNameBywitharray('material',$materialId,'id');
				 $matDetails[material_type_id] = 26;
				 $matDetails[created_by] = isset($_SESSION['loggedInUser']->id) ? $_SESSION['loggedInUser']->id:0;;
				 $matDetails[created_by_cid] = $this->companyId;
				 $matDetails[opening_balance] = $addArray->quantity;
				 $matDetails[location] = $addArray->location;
				 // pre($matDetails);die();
				 
				 
              $lastinsertID =  $this->inventory_model->insert_tbl_data('material', $matDetails);
				    $insertDatalocation['material_type_id'] = 26;
                    // $insertDatalocation['material_name_id'] = $materialId;
                    $insertDatalocation['material_name_id'] = $lastinsertID;
                    $insertDatalocation['location_id'] = $addArray->location;
                    $insertDatalocation['Storage'] = $addArray->Storage;
                    // $insertDatalocation['RackNumber'] = 0;
                    $insertDatalocation['quantity'] = $addArray->quantity;
                    $insertDatalocation['lot_no'] = $addArray->lot_no;
                    $insertDatalocation['Qtyuom'] = $addArray->Qtyuom;
                    $insertDatalocation['created_by_cid'] = isset($_SESSION['loggedInUser']->c_id) ? $_SESSION['loggedInUser']->c_id:0;
					
                    $insertSuccess = $this->inventory_model->insert_tbl_data('mat_locations', $insertDatalocation);

                    $inventoryFlowDataArray1['material_in'] = $addArray->quantity;
                    $inventoryFlowDataArray1['opening_blnc'] = $sum1;
                    $inventoryFlowDataArray1['closing_blnc'] = $closing_blnc1;
                    $inventoryFlowDataArray1['ref_id'] = $insertSuccess;
                    $inventoryFlowDataArray1['through'] = 'Scrap (-)';
                    $inventoryFlowDataArray1['new_location'] = $arr1[$i];
                

                $inventoryFlowDataArray1['material_type_id'] = $material_type;
                $inventoryFlowDataArray1['material_id'] = $materialId;
                $inventoryFlowDataArray1['uom'] = $addArray->Qtyuom;
                $inventoryFlowDataArray1['created_by'] = isset($_SESSION['loggedInUser']->id) ? $_SESSION['loggedInUser']->id:0;
                $inventoryFlowDataArray1['created_by_cid'] = $this->companyId;
                $addFlow = $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray1);
                
           }
			// die('df');

			/*if($action == 'scrap')
            {
                 
                    $insertDatalocation['material_type_id'] = 26;
                    $insertDatalocation['material_name_id'] = $materialId;
                    $insertDatalocation['location_id'] = $addArray->location;
                    $insertDatalocation['Storage'] = $addArray->Storage;
                    // $insertDatalocation['RackNumber'] = 0;
                    $insertDatalocation['quantity'] = $addArray->quantity;
                    $insertDatalocation['lot_no'] = $addArray->lot_no;
                    $insertDatalocation['Qtyuom'] = $addArray->Qtyuom;
                    $insertDatalocation['created_by_cid'] = isset($_SESSION['loggedInUser']->c_id) ? $_SESSION['loggedInUser']->c_id:0;
					
                    $insertSuccess = $this->inventory_model->insert_tbl_data('mat_locations', $insertDatalocation);

                    $inventoryFlowDataArray1['material_in'] = $addArray->quantity;
                    $inventoryFlowDataArray1['opening_blnc'] = $sum1;
                    $inventoryFlowDataArray1['closing_blnc'] = $closing_blnc1;
                    $inventoryFlowDataArray1['ref_id'] = $insertSuccess;
                    $inventoryFlowDataArray1['through'] = 'Scrap (-)';
                    $inventoryFlowDataArray1['new_location'] = $arr1[$i];
                

                $inventoryFlowDataArray1['material_type_id'] = $material_type;
                $inventoryFlowDataArray1['material_id'] = $materialId;
                $inventoryFlowDataArray1['uom'] = $addArray->Qtyuom;
                $inventoryFlowDataArray1['created_by'] = isset($_SESSION['loggedInUser']->id) ? $_SESSION['loggedInUser']->id:0;
                $inventoryFlowDataArray1['created_by_cid'] = $this->companyId;
                $addFlow = $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray1);
                
            }*/

            if($action == 'move')
            {
                // $exist_location = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $materialId, 'material_type_id' => $material_type, 'location_id' => $addArray->location,'Storage' => $addArray->Storage,'RackNumber' => $addArray->RackNumber));
				
                $exist_location = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $materialId, 'material_type_id' => $material_type, 'location_id' => $addArray->location));
				
				
				
                if(!empty($exist_location)){
                    foreach($exist_location as $eldate){
                        $updateDatalocation1 = $eldate;
						
						

                        #Set opening balance
                        $inventoryFlowDataArray1['opening_blnc'] = $sum1;

                        #Updation - Exist location and Rack
                        $existRackNumber1 = $eldate['RackNumber'];
                        if($existRackNumber1 == $addArray->RackNumber){
							
							// pre($eldate);
							// pre($addArray);
							// die('HMMM');

                            $addedQuantity = $eldate['quantity'] + $addArray->quantity;
							
							
                            $closing_blnc1 = $sum1 + $addArray->quantity;
                            $updateDatalocation1['quantity'] = $addedQuantity;
							
							
							

                            $arr1[] =  json_encode(array(array('location' => $eldate['location_id'], 'Storage' => $eldate['Storage'] , 'RackNumber' => $eldate['RackNumber'] , 'lot_no' => $eldate['lot_no'] , 'quantity' => $addedQuantity , 'Qtyuom' => $eldate['Qtyuom'])));

                            #inventoryFlowDataArray1 - Exist location and rack
                            $inventoryFlowDataArray1['current_location'] = $arr1[$i];
                            $inventoryFlowDataArray1['material_in'] = $addArray->quantity;
                            $inventoryFlowDataArray1['ref_id'] = $updateDatalocation1['id'];
                            $inventoryFlowDataArray1['through'] = 'Move, (+) Source Location';
                        }

                        #Added - Exist Location with New Rack
                        if($existRackNumber1 != $addArray->RackNumber){
							
							

                            $addedQuantity = $addArray->quantity;
                            $closing_blnc1 = $sum1 + $addedQuantity;
                            // $updateDatalocation1['quantity'] = $addedQuantity;
                            $updateDatalocation1['quantity'] = $eldate['quantity'] + $addArray->quantity;

                            $arr1[] =  json_encode(array(array('location' => $eldate['location_id'], 'Storage' => $eldate['Storage'] , 'RackNumber' => $eldate['RackNumber'] , 'lot_no' => $eldate['lot_no'] , 'quantity' => $addedQuantity , 'Qtyuom' => $eldate['Qtyuom'])));

                            #inventoryFlowDataArray1 - Exist location with New Rack
                            $inventoryFlowDataArray1['new_location'] = $arr1[$i];
                            $inventoryFlowDataArray1['material_in'] = $addedQuantity;
                            $inventoryFlowDataArray1['ref_id'] = $updateDatalocation1['id'];
                            $inventoryFlowDataArray1['through'] = 'Move, New Product Location Added';
                        }
                        #Set closing balance
                        $inventoryFlowDataArray1['closing_blnc'] = $closing_blnc1;
                        #update mat location table
						
						 // pre($updateDatalocation1);die('1');
                        $updateSuccess1 = $this->inventory_model->update_single_field('mat_locations', $updateDatalocation1);
                    }
                }

                #Added - New location with new rack
                $arr1[] =  json_encode(array(array('location' => $addArray->location,'Storage' => $addArray->Storage , 'RackNumber' => $addArray->RackNumber , 'quantity' => $addArray->quantity , 'Qtyuom' => $addArray->Qtyuom)));
                if(empty($exist_location))
                {
                    $insertDatalocation['material_type_id'] = $material_type;
                    $insertDatalocation['material_name_id'] = $materialId;
                    $insertDatalocation['location_id'] = $addArray->location;
                    $insertDatalocation['Storage'] = $addArray->Storage;
                    $insertDatalocation['RackNumber'] = $addArray->RackNumber;
                    $insertDatalocation['quantity'] = $addArray->quantity;
                    $insertDatalocation['lot_no'] = $addArray->lot_no;
                    $insertDatalocation['Qtyuom'] = $addArray->Qtyuom;
                    $insertDatalocation['created_by_cid'] = isset($_SESSION['loggedInUser']->c_id) ? $_SESSION['loggedInUser']->c_id:0;
					
					// die();
                    $insertSuccess = $this->inventory_model->insert_tbl_data('mat_locations', $insertDatalocation);

                    #inventoryFlowDataArray1 - New location and New Rack
                    $inventoryFlowDataArray1['material_in'] = $addArray->quantity;
                    $inventoryFlowDataArray1['opening_blnc'] = $sum1;
                    $inventoryFlowDataArray1['closing_blnc'] = $closing_blnc1;
                    $inventoryFlowDataArray1['ref_id'] = $insertSuccess;
                    $inventoryFlowDataArray1['through'] = 'Move, New Product Location Added';
                    $inventoryFlowDataArray1['new_location'] = $arr1[$i];
                }

                $inventoryFlowDataArray1['material_type_id'] = $material_type;
                $inventoryFlowDataArray1['material_id'] = $materialId;
                $inventoryFlowDataArray1['uom'] = $addArray->Qtyuom;
                $inventoryFlowDataArray1['created_by'] = isset($_SESSION['loggedInUser']->id) ? $_SESSION['loggedInUser']->id:0;
                $inventoryFlowDataArray1['created_by_cid'] = $this->companyId;
                $addFlow = $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray1);
            }
        }
        #Update lot materials
        $this->material_Lot_inOut($materialId);
		 $this->update_closing_balance($materialId);	
    }

    /**************************************** inventory setting with location setting and material type ***********************************/
    /*half full book listing in reporting*/
    public function half_full_book() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Full book', base_url() . 'Full Book');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Full Book';
        //$where = array('material.created_by_cid' => $_SESSION['loggedInUser']->c_id ,'material.save_status' => 1);
        $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1);
        $this->data['listing'] = $this->inventory_model->get_data_fromMaterial('material', $where);
        //$where2 = "inventory_listing_adjustment.created_by_cid ='".$_SESSION['loggedInUser']->c_id."' AND inventory_listing_adjustment.action_type = 'half_full_book'";
        $where2 = "inventory_listing_adjustment.created_by_cid ='" . $this->companyId . "' AND inventory_listing_adjustment.action_type = 'half_full_book'";
        $this->data['half_full_book'] = $this->inventory_model->get_data('inventory_listing_adjustment', $where2);
        /* $where = array('inventory_listing_adjustment.created_by_cid'=> $_SESSION['loggedInUser']->c_id , 'inventory_listing_adjustment.action_type' =>'half_full_book' );
         $this->data['full_book_listing'] = $this->inventory_model->get_data('inventory_listing_adjustment',$where); */
        $this->_render_template('half_full_book/half_full_book_index', $this->data);
    }
    /*********************quick add in conversion in listing************************/
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
        //pre($matrial_details);die('there');
        $data2 = $this->inventory_model->insert_on_spot_tbl_data('material', $matrial_details);
        if ($data2 > 0) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    /****************************** Delete on Select Record ***************************/
    public function deleteall() {
        $tablename = $this->input->get_post('tablename');
        $checkValues = $this->input->get_post('checkValues');
        $datamsg = $this->input->get_post('datamsg');
        foreach ($checkValues as $key) {
            $this->inventory_model->delete_data($tablename, 'id', $key);
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
        $data = $favourite;
        $result = $this->inventory_model->markfavour($tablename, $data, $id);
        if ($result == true) {
            foreach ($id as $ky) {
                logActivity($datamsg . ' Records marked favourite', $tablename, $ky);
            }
            $this->session->set_flashdata('message', $datamsg . ' Favourites');
            $result = array('msg' => 'Sale order approved', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'inventory/materials');
            echo json_encode($result);
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    /*******************************FAVOURITES IN PURCHASE ***************************/

    /*************************code for save stock check in inventory flow********************/
    public function inventoryFlow(){
        $materialId = $_POST['material_id'];
        $matLocId = $_POST['matLocId'];
        $locationId = $_POST['location_id'];
        $materialQty = $_POST['materialQty'];
        $physical_stock_value = $_POST['physical_stock'];
        $balance_value = $_POST['balance'];
        //print_r($_POST);die;
        //$getAddres = $this->inventory_model->get_data('mat_locations', array('id' => $matLocId));
        $getAddres = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $materialId));
        
        if ($materialQty > 0){
            $inventoryFlowDataArray = [];
            $i = 0;
            $arr = [];
            /**********update mat location table qty ******************************/
            foreach ($getAddres as $data){
                if($locationId == $data['location_id']){

                    $yu1 = getNameById_mat('mat_locations',$materialId,'material_name_id');
                    $sum1 = 0;
                    if(!empty($yu1)){ foreach ($yu1 as $ert1) {$sum1 += $ert1['quantity'];}}
                    $quantity = $data['quantity'] - $materialQty;
                    $closingblcn1 = $sum1 - $materialQty;

                    $arr[] =  json_encode(array(array('location' => $data['location_id'],'Storage' => $data['Storage'] , 'RackNumber' => $data['RackNumber'] , 'quantity' => $quantity , 'Qtyuom' => $data['Qtyuom'])));

                    $inventoryFlowDataArray['current_location'] = $arr[$i];
                    $inventoryFlowDataArray['opening_blnc'] = $sum1;
                    $inventoryFlowDataArray['closing_blnc'] = $closingblcn1;
                    $inventoryFlowDataArray['material_id'] = $materialId;
                    $inventoryFlowDataArray['material_out'] = $materialQty;
                    $inventoryFlowDataArray['material_type_id'] = $data['material_type_id'];
                    $inventoryFlowDataArray['uom'] = $data['Qtyuom'];
                    $inventoryFlowDataArray['through'] = 'Physical Stock';
                    $inventoryFlowDataArray['ref_id'] = $data['id'];
                    $inventoryFlowDataArray['created_by'] = $_SESSION['loggedInUser']->u_id;
                    $inventoryFlowDataArray['created_by_cid'] = $this->companyId;
                    //print_r($inventoryFlowDataArray);die;
                    $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);
                    //echo $this->db->last_query();die;    
                    //$data1['id'] = $materialId;
                    $data['quantity'] = $quantity;
                    $data['physical_stock'] = (int) filter_var($physical_stock_value, FILTER_SANITIZE_NUMBER_INT);
                    //$data1['physical_stock'] = $physical_stock_value;
                    $data['balance'] = $balance_value;
                }
                //print_r($data1);
                $success = $this->inventory_model->update_single_field_inventeory_flows('mat_locations', $data, $materialId);
                //$success = $this->inventory_model->update_single_field('mat_locations', $data1);
                //echo "Here";print_r($this->db->last_query());die;
            }
        } else {
            $inventoryFlowDataArray1 = [];
            $i1 = 0;
            $arr1 = [];
            $materialInQty = abs($_POST['materialQty']);
            foreach ($getAddres as & $data1) {
                if ($locationId == $data1['location_id']) {

                    $yu11 = getNameById_mat('mat_locations',$materialId,'material_name_id');
                    $sum11 = 0;
                    if(!empty($yu11)){ foreach ($yu11 as $ert11) {$sum11 += $ert11['quantity'];}}
                    $wqa = abs($materialQty);
                    $quantity1 = $data1['quantity'] + $wqa;
                    $closingblcn11 = $sum11 + $wqa;

                    $arr1[] =  json_encode(array(array('location' => $data1['location_id'],'Storage' => $data1['Storage'] , 'RackNumber' => $data1['RackNumber'] , 'quantity' => $quantity1 , 'Qtyuom' => '')));

                    $inventoryFlowDataArray1['opening_blnc'] = $sum11;
                    $inventoryFlowDataArray1['closing_blnc'] = $closingblcn11;
                    $inventoryFlowDataArray1['current_location'] = $arr1[$i1];
                    $inventoryFlowDataArray1['material_id'] = $materialId;
                    $inventoryFlowDataArray1['material_in'] = $wqa;
                    $inventoryFlowDataArray1['uom'] = $data1['Qtyuom'];
                    $inventoryFlowDataArray1['through'] = 'Physical Stock';
                    $inventoryFlowDataArray1['ref_id'] = $data1['id'];
                    $inventoryFlowDataArray1['created_by'] = $_SESSION['loggedInUser']->u_id;
                    $inventoryFlowDataArray1['created_by_cid'] = $this->companyId;
                    $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray1);

                    $data1['quantity'] = $quantity1;
                    $data1['physical_stock'] = $physical_stock_value;
                    $data1['balance'] = $balance_value;
                }
                $success = $this->inventory_model->update_single_field('mat_locations', $data1);
            }
        }
        if ($success) {
            #Update lot materials
            $this->material_Lot_inOut($materialId);
            $result = array('status' => 'success', 'code' => 'C296', 'url' => base_url() . 'inventory/inventory_listing_and_adjustment');
            echo json_encode($result);
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }

public function uom_list() {
    $this->load->library('pagination');
    $this->data['can_edit'] = edit_permissions();
    $this->data['can_delete'] = delete_permissions();
    $this->data['can_add'] = add_permissions();
    $this->data['can_view'] = view_permissions();
    $this->breadcrumb->add('UOM list', base_url() . 'inventory/dashboard');
    $this->breadcrumb->add('UOM list', base_url() . 'inventory/uom_list');
    $this->settings['breadcrumbs'] = $this->breadcrumb->output();
    $this->settings['pageTitle'] = 'UOM list';
    //$where12  = "uom.created_by_cid = ".$_SESSION['loggedInUser']->c_id." OR uom.created_by_cid = 0";
    //Search
    $where2 = '';
    $search_string = '';
    if (!empty($_POST['search'])) {
        $search_string = $_POST['search'];
        $where2 = "id like '%" . $search_string . "%' or uom_quantity like '%" . $search_string . "%' or uom_quantity_type like '%" . $search_string . "%'";
        redirect("inventory/uom_list/?search=$search_string");
    } else if (isset($_GET['search'])) {
        $where2 = "id like'%" . $_GET['search'] . "%' or uom_quantity like'%" . $_GET['search'] . "%' or uom_quantity_type like'%" . $_GET['search'] . "%'";
    }
    if (!empty($_POST['order'])) {
        $order = $_POST['order'];
    } else {
        $order = "desc";
    }
    $where12 = "(uom.created_by_cid = " . $this->companyId . " OR uom.created_by_cid = 0)";
    //Pagination
    $config = array();
    $config["base_url"] = base_url() . "inventory/uom_list/";
    $config["total_rows"] = $this->inventory_model->num_rows('uom', $where12, $where2);
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

    $this->data['uom_list1'] = $this->inventory_model->get_data1('uom', $where12, $config["per_page"], $page, $where2, $order,$export_data);
        if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }
        if($end>$config['total_rows'])
        {
        $total=$config['total_rows'];
        }else{
        $total=$end;
        }
        $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';

    $this->_render_template('uom_list/index', $this->data);
}
//  For Editing Terms & Conditions
public function uom_list_edit() {
    if ($this->input->post('id') != '') {
        permissions_redirect('is_edit');
    } else {
        permissions_redirect('is_add');
    }
    $this->data['uom_list1'] = $this->inventory_model->get_data_byIdpricelist('uom', 'id', $this->input->post('id'));
    //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
    $this->load->view('uom_list/edit', $this->data);
}
// For Saving Terms & Conditions
public function saveuomtype() {
    #pre($_POST);
    if ($this->input->post()) {
        $required_fields = array('uom_quantity', 'uom_quantity_type', 'ugc_code');
        $is_valid = validate_fields($_POST, $required_fields);
        if (count($is_valid) > 0) {
            valid_fields($is_valid);
        } else {
            $data = $this->input->post();
            $data['created_date'] = date("Y-m-d h:i:sa");
            $data['created_by'] = $_SESSION['loggedInUser']->id;
            //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
            $data['created_by_cid'] = $this->companyId;
            $id = $data['id'];
            $usersWithViewPermissions = $this->inventory_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 95));
            if ($id && $id != '') {
                $success = $this->inventory_model->update_data('uom', $data, 'id', $id);
                if ($success) {
                    $data['message'] = "UOM List updated successfully";
                    logActivity('UOM List updated', 'UOM List', $id);
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                pushNotification(array('subject' => 'UOM List  updated', 'message' => 'UOM List  updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        pushNotification(array('subject' => 'UOM List updated', 'message' => 'UOM List updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id));
                    }
                    $this->session->set_flashdata('message', 'UOM List updated successfully');
                }
            } else {
					$where = array('uom_quantity' => $data['uom_quantity']);
					$ChkUoName = $this->inventory_model->get_data('uom', $where);
				 if(empty($ChkUoName)){
                $id = $this->inventory_model->insert_tbl_data('uom', $data);
                if ($id) {
                    logActivity('New UOM List  Created', 'Terms & Conditions', $id);
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                pushNotification(array('subject' => 'UOM List created', 'message' => 'UOM List created by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        pushNotification(array('subject' => 'UOM List  created', 'message' => 'UOM List created by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id));
                    }
                    $this->session->set_flashdata('message', 'New UOM List Created', 'UOM List');
                }
				}else{
					$this->session->set_flashdata('error', 'ERROR !, Already Exist');
				}
            }
             redirect(base_url() . 'inventory/inventory_setting', 'refresh');
        }
    }
}
/**********active inactive status of UOM ****************/
public function change_status_uom() {
    $id = (isset($_POST['id'])) ? $_POST['id'] : '';
    $status = (isset($_POST['uomStatus']) && $_POST['uomStatus'] == 1) ? '1' : '0';
    $status_data = $this->inventory_model->toggle_change_status($id, $status);
    //$usersWithViewPermissions = $this->inventory_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 59));
    /*if(!empty($usersWithViewPermissions)){
        foreach($usersWithViewPermissions as $userViewPermission){
        if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
    /*pushNotification(array('subject'=> 'Worker status changed' , 'message' => 'Worker status changed by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
    /*          pushNotification(array('subject'=> 'Worker Status Changed' , 'message' => 'Worker Status id : #'.$id.' is changed by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id ,'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id,'icon'=>'fa fa-archive'));



        }
        }*/
    echo $status_data;
}
/* For updating materials in Inventory

    public function updateoldrecords(){

    $this->data['material'] = $this->inventory_model->get_data('material',array('created_by_cid'=> $_SESSION['loggedInUser']->c_id));

    foreach ($this->data['material'] as $key) {

/*$products = json_decode($key['uom']);

    foreach($products as $product){

        $ww =   getNameById('uom', $product->uom,'ugc_code');

        $product->uom = $ww->id;

        $product_array = "[".json_encode($product)."]";

        $data['product_detail'] = $product_array;

        pre($data['product_detail']);

        $aa = array('id' => $key['id']);

        $this->production_model->updateRowWhere('work_order',$aa,$data);

        //die();
*/
//echo $key['uom'].'<br>';
/*                  $ww =   getNameById('uom', $key['uom'],'ugc_code');

        $data['uom'] = $ww->id;

        pre($data['uom']);

             $aa = array('id' => $key['id']);

             $this->inventory_model->updateRowWhere('material',$aa,$data);

           //  die;

    }

    }

*/
/* For updating Finish Goods in Inventory

    public function updateoldrecords(){

    $this->data['finish_goods'] = $this->inventory_model->get_data('finish_goods',array('created_by_cid'=> $_SESSION['loggedInUser']->c_id));

    foreach ($this->data['finish_goods'] as $key) {

    $products = json_decode($key['job_card_detail']);

    foreach($products as $product){


    foreach($product->material_id as $mat_detail){

        $ww =   getNameById('uom', $mat_detail->uom,'ugc_code');

        $mat_detail->uom = $ww->id;

        $product_array = "[".json_encode($product)."]";

        $data['job_card_detail'] = $product_array;

        pre($data['job_card_detail']);

        $aa = array('id' => $key['id']);



        $this->inventory_model->updateRowWhere('finish_goods',$aa,$data);

        //die();


        }
    }

    }

    }*/
public function mrp() {
    $this->load->library('pagination');
    $this->data['can_edit'] = edit_permissions();
    $this->data['can_delete'] = delete_permissions();
    $this->data['can_add'] = add_permissions();
    $this->data['can_view'] = view_permissions();
    $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
    $this->breadcrumb->add('MRP', base_url() . 'inventory/mrp');
    $this->settings['breadcrumbs'] = $this->breadcrumb->output();
    $this->settings['pageTitle'] = 'Material Requirement Planning';
    $where = "mrp_details.created_by_cid = " . $this->companyId;
    if(isset($_GET['start']) != '' && isset($_GET['end'])!= '' ){
           $where = "created_by_cid = " . $this->companyId . " AND  (mrp_details.created_date >='" . $_GET['start'] . "' AND  mrp_details.created_date <='" . $_GET['end'] . "')";
    }
    if(isset($_GET["ExportType"])!='' && $_GET['start'] == '' && $_GET['end'] == '' )
    {
        $where = "mrp_details.created_by_cid = " . $this->companyId;
    }
    elseif(isset($_GET["ExportType"])!='' && $_GET['start'] != '' && $_GET['end'] != '' ) {
        $where = "created_by_cid = " . $this->companyId . " AND  (mrp_details.created_date >='" . $_GET['start'] . "' AND  mrp_details.created_date <='" . $_GET['end'] . "')";
    }
    //Search
    $where2 = '';
    $search_string = '';
    if(!empty($_POST['search'])){
        $search_string = $_POST['search'];
        if(is_numeric($search_string)){
            $dept_id = trim($search_string);
            $where2 = "mrp_details.id = '" .$dept_id. "'";
        }else{
            $dept_ids = getNameBySearch('department',$search_string,'name');
            $ids = array();
            if(!empty($dept_ids)){
                foreach($dept_ids as $rows){
                    $ids[] = $rows['id'];
                }
                $ids = implode(',', $ids);
            }
            $where2 = "FIND_IN_SET(`mrp_details`.`department_id`, '". $ids ."')";
        }
        redirect("inventory/mrp/?search=$search_string");
    } elseif(isset($_GET['search']) && $_GET['search']!=''){
        $search_string = $_GET['search'];
        if(is_numeric($search_string)){
            $dept_id = trim($search_string);
            $where2 = "mrp_details.id = '" .$dept_id. "'";
        }else{
            $dept_ids = getNameBySearch('department',$search_string,'name');
            $ids = array();
            if(!empty($dept_ids)){
                foreach($dept_ids as $rows){
                    $ids[] = $rows['id'];
                }
                $ids = implode(',', $ids);
            }
            //$where2 = "mrp_details.department_id IN('". $ids ."')";
            $where2 = "FIND_IN_SET(`mrp_details`.`department_id`, '". $ids ."')";
        }
    }
    if (!empty($_POST['order'])) {
        $order = $_POST['order'];
    } else {
        $order = "desc";
    }

    //Pagination
    $config = array();
    $config["base_url"] = base_url() . "inventory/mrp";
    $config["total_rows"] = $this->inventory_model->num_rows('mrp_details', $where,$where2);
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

    $this->data['mrp_details'] = $this->inventory_model->get_data1('mrp_details', $where, $config["per_page"], $page,$where2,$order,$export_data);
    //$this->data['mrp_details'] = $this->inventory_model->get_data('mrp_details', array('created_by_cid' => $this->companyId));
    #pre($this->data['work_ordr']);
    #die;
    if(!empty($this->uri->segment(3))){
        $frt = (int)$this->uri->segment(3) - 1;
        $start= $frt * $config['per_page']+1;
    }else{
        $start= (int)$this->uri->segment(3) * $config['per_page']+1;
    }

    if(!empty($this->uri->segment(3))){
        $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
    }else{
        $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
    }
    if($end>$config['total_rows'])
    {
        $total=$config['total_rows'];
    }else{
        $total=$end;
    }
    $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
    $this->_render_template('mrp_dtl/index', $this->data);
}
public function mrp_reportadd() {
    //pre($_POST);
    $id = $_POST['id'];
    if ($id != '') {
        permissions_redirect('is_edit');
    } else {
        permissions_redirect('is_add');
    }
    $this->data['production_report'] = $this->inventory_model->get_data_byId('production_report', 'id', $id);
    $where = "work_order.created_by_cid = " . $this->companyId . " AND work_order.progress_status=0 AND  year(STR_TO_DATE(`work_order`.`expected_delivery_date`,'%d-%m-%Y')) =  YEAR(CURDATE()) AND month(STR_TO_DATE(`work_order`.`expected_delivery_date`,'%d-%m-%Y')) =  MONTH(CURDATE())";
    $this->data['work_order'] = $this->inventory_model->get_data('work_order', $where);
    $this->load->view('mrp_dtl/add_monthly_mrp', $this->data);
}
public function convert_to_pi_through_MRP() {
    $description = '';
    $expected_amount = '';
    $purpose = '';
    $sub_total = '';
    $usersWithViewPermissions = $this->inventory_model->get_dataw('permissions', array('is_view' => 1, 'sub_module_id' => 7));
    // (array('material_name_id' => $_REQUEST['material_name_id'], 'description' => $description, 'quantity' => $quantity, 'uom' => $uom, 'expected_amount' => $expected_amount, 'purpose' => $purpose, 'sub_total' => $sub_total, 'remaning_qty' => $quantity));
    $rt = json_decode($_POST['jsondt']);
    #pre($rt);
    #die;
    $i = 0;
    foreach ($rt as $ty) {
        #pre($ty);
        $get_mat_type_id = getNameById('material', $ty->mat_idd, 'id');
        $jsonArrayObject = (array('material_type_id' => $get_mat_type_id->material_type_id, 'material_name_id' => $ty->mat_idd, 'description' => $description, 'quantity' => $ty->totl_ordr, 'uom' => $ty->uom_selected_id, 'expected_amount' => $expected_amount, 'purpose' => $purpose, 'sub_total' => $sub_total, 'remaning_qty' => '0'));
        $arr[$i] = $jsonArrayObject;
        $i++;
    }
    $material_array = json_encode($arr);
    #pre($material_array);
    $data['material_name'] = $material_array;
    $data['created_by_cid'] = $this->companyId;
    $data['created_by'] = $_SESSION['loggedInUser']->u_id;
    $data['po_or_not'] = 0;
    $data['mrn_or_not'] = 0;
    $data['pay_or_not'] = 0;
    $data['ifbalance'] = 1;
    $data['save_status'] = 0;
    $data['company_unit'] = $_POST['cmpid'];
    $data['departments'] = $_POST['dptid'];
    $getcompanyName = getCompanyTableId('company_detail');
    $name = $getcompanyName->name;
    $CompanyName = substr($name, 0, 6);
    $last_id = getLastTableId('purchase_indent');
    $rId = $last_id + 1;
    $indentCode = 'Indent_' . rand(1, 1000000) . '_' . $CompanyName . '_' . $rId;
    $data['indent_code'] = $indentCode;
    $datainsert = $this->inventory_model->insert_tbl_data('purchase_indent', $data);
    if ($datainsert > 0) {
        $this->session->set_flashdata('message', 'PI Created Successfully Please Check Purchase Module', 'MRP');
        if (!empty($usersWithViewPermissions)){
        foreach ($usersWithViewPermissions as $userViewPermission) {
        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
       pushNotification(array('subject' => 'PI Created', 'message' => 'PI Created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $userViewPermission['user_id'], 'to_id' => $userViewPermission['user_id'], 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
        }
        }
        }
        if ($_SESSION['loggedInUser']->role != 1){
        pushNotification(array('subject' => 'PI Created', 'message' => 'PI Created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
        }
        pushNotification(array('subject' => 'PI Created', 'message' => 'PI Created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
            $email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
            <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
            <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi Test</p>
            <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">PI Created Successfully Please Check Purchase Module.</p>
            <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>
            </td>
            </tr>
            </table>
            </td>
            </tr>';
            //send_mail_notification($_SESSION['loggedInUser']->email, 'Notification Email For PI Created', $email_message);
            if($_SESSION['loggedInUser']->c_id){
            $select = "email";
            $where = 'c_id='.$_SESSION['loggedInUser']->c_id.' AND role=1';
            $get_admin = $this->inventory_model->admin_email_data('user',$select, $where);
            foreach ($get_admin as $key => $value) {
            //send_mail_notification($value['email'], 'Notification Email For PI Created', $email_message);
            } }
        echo 'true';
    } else {
        echo 'false';
    }
}
/*Function to Import */
function Create_materialLoc_blankxls() {
    $fileName = 'Blank_material_location' . time() . '.xls';
    $this->load->library('excel');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);

    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'material_type_id');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'material_name_id');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'location_id');
    // $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'storage');
    // $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'rackNumber');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'quantity');
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Qtyuom');
    // $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'lot_no');
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $object_writer = new PHPExcel_Writer_Excel2007($objPHPExcel);
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=".$fileName."");
    ob_end_clean();
    $object_writer->save('php://output');
    exit;
}
function Create_materialsubType_blankxls(){
	$fileName = 'Blank_material_subtype_' . time() . '.xls';
    $this->load->library('excel');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'subtype_name');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'material_sub_type');
    // $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'material_name');
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $object_writer = new PHPExcel_Writer_Excel2007($objPHPExcel);
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=".$fileName."");
    ob_end_clean();
    $object_writer->save('php://output');
    exit;
	
	
}
function Create_material_blankxls() {
    $fileName = 'Blank_material_' . time() . '.xls';
    $this->load->library('excel');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'material_type_id');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'sub_type');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'material_name');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'customer_name');
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'alias_name');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'non_inventry_material');
    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'sales_price');
    // $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'job_card');
    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'cost_price');
    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'mat_sku');
   // $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'material_code');//
    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'specification');
    $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'uom');
    $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'alternateuom');
    $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'alternate_qty');
    $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'reorder_quantity');//Reorder quantity
    $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'min_inventory');
    $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'max_inventory');
    $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'tax');
    $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'hsn_code');
    $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'dimension_length');
    $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'dimension_width');//total_cbf Requried
    $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'dimension_height');
    $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'purchase');
    $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'sale');
   // $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'standard_packing');
  //  $objPHPExcel->getActiveSheet()->SetCellValue('Y1',  'item_code');
 //   $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'packing_mat');
  //  $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'packing_qty');
  //  $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'packing_weight');
  //  $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'customer_name');
    //$objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'alias_name');
	
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $object_writer = new PHPExcel_Writer_Excel2007($objPHPExcel);
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=".$fileName."");
    ob_end_clean();
    $object_writer->save('php://output');
    exit;
}
/*Function to Import invoices*/
	public function import_view_mat() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Import Data', base_url() . 'Import Data');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Import Data';
        $this->load->library('excel');
        if ($_FILES) {
            $created_by_id = $this->companyId;
            //$created_by_id  = $_SESSION['loggedInUser']->c_id;
            $path = 'assets/modules/import/uploads/';
            $this->load->library('excel');
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls';
            $config['max_size'] = '10000';
            $config['remove_spaces'] = TRUE;
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
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true;
                    $i = 0;
                    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                        $worksheetTitle = $worksheet->getTitle();
                        $highestRow = $worksheet->getHighestRow(); // e.g. 10
                        $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
                        $headings = $worksheet->rangeToArray('A1:' . $highestColumn . 1, NULL, TRUE, FALSE);
                    }
                    for ($row = 2;$row <= $highestRow;$row++) {
                        $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                        $rowData[0] = array_combine($headings[0], $rowData[0]);
                        //pre($rowData[0]);die();

                        $materialType = getNameByID('material_type',$rowData[0]['material_type_id'],'name');
                        $uom_id = getNameByID('uom',$rowData[0]['uom'],'uom_quantity');
                        if($uom_id == ''){
                            $uom_idd = '0';
                        }else{
                            $uom_idd = $uom_id->id;
                        }
						
						$Altuom_id = getNameByID('uom',$rowData[0]['alternateuom'],'uom_quantity');
                        if($Altuom_id == ''){
                            $Altuom_idVal = '0';
                        }else{
                            $Altuom_idVal = $Altuom_id->id;
                        }

                        if($materialType == ''){
                            $mat_type = '0';
                        }else{
                            $mat_type = $materialType->id;
                        }
                        //$uom_id_mat_location = getNameByID('uom',$rowData[0]['Qtyuom'],'uom_quantity');
						// echo $rowData[0]['non_inventry_material'];
						

                        if( strtolower(trim($rowData[0]['non_inventry_material'])) == 'inventory'){
						//	echo 'if';
                            $mat_inv_not_inv = 0;
                        }else{
							//echo 'else';
                            $mat_inv_not_inv = 1;
                        }
                       
					  
					  
					  $purchaseData =  strtolower($rowData[0]['purchase']);
					  $saleData =  strtolower($rowData[0]['sale']);
					   
					 
					   
                        if(!empty($rowData[0]['purchase'])){
                                
                                      $route = '["Purchase"]';
                               
						}
						 if(!empty($rowData[0]['sale'])){
								
                                    $sale_purchase = '["Sale"]';
                                
						 }
							
							
							// pre($sale_purchase);

                        $last_id = getLastTableId('material');
                        $rId = $last_id + $i;
                        $matCode = 'MAT_'.rand(1, 1000000).'_'.$rId;
                        $inserdata[$i]['material_code'] = $matCode;
                        if($rowData[0]['sub_type'] != '' || $rowData[0]['sub_type'] != 0){
                            // $result_replaced = preg_replace('/[ ,]+/', '-', $rowData[0]['sub_type']);
                            $result_replaced = $rowData[0]['sub_type'];
                        }else{
                            $result_replaced = '';
                        }
						 // if($sale_purchase == '["Purchase"]'){
							 // $routeData = $sale_purchase;
						 // }elseif($sale_purchase == '["Sale"]'){
							
							// $sale_purchase2 =  $sale_purchase;
						 // }
						 
						
						
						$getHSNNumber = getNameByID('hsn_sac_master',$rowData[0]['hsn_code'],'hsn_sac');
						 if($getHSNNumber == ''){
                            $getHSNNumberval = 0;
                        }else{
                            $getHSNNumberval = $getHSNNumber->id;
                        }
						
						
						$supplierid = getNameByID('supplier',$rowData[0]['customer_name'],'name');
						
						 if($supplierid == ''){
                            $MatAliasName = '0';
                        }else{
                            $MatAliasName = '[{"customer_id":"'.$supplierid->id.'","alias":"'.$rowData[0]['alias_name'].'"}]';
                        }
						
						$materialID = getNameByID('material',$rowData[0]['packing_mat'],'material_name');
						 if($materialID == ''){
                            $packing_data = '0';
                        }else{
                            $packing_data = '[{"packing_mat":"'.$materialID->id.'","packing_qty":"'.$rowData[0]['packing_qty'].'","packing_weight":"'.$rowData[0]['packing_weight'].'","packing_cbf":"'.$materialID->total_cbf.'"}]';
                        }
						
						if($rowData[0]['dimension_length'] != '' &&  $rowData[0]['dimension_width'] != '' && $rowData[0]['dimension_height'] != '' || $rowData[0]['dimension_length'] != 0 &&  $rowData[0]['dimension_width'] != 0  && $rowData[0]['dimension_height'] != 0 ){
							
								$total_val = $rowData[0]['dimension_length'] * $rowData[0]['dimension_width'] * $rowData[0]['dimension_height'];
								
								$cbf_val = $total_val/1728;
							    $cbf_val2 = 	floor($cbf_val*100)/100;

							
						}
						
						


                        //$inserdata[$i]['material_type_id'] = $rowData[0]['material_type_id'] ? $rowData[0]['material_type_id'] : '';
					$inserdata[$i]['material_type_id'] = $mat_type;
					$inserdata[$i]['material_name'] = (!empty($rowData[0]['material_name'])) ? $rowData[0]['material_name'] : '';
					$inserdata[$i]['MatAliasName'] = $MatAliasName;
					$inserdata[$i]['sub_type'] = $result_replaced;
					$inserdata[$i]['non_inventry_material'] = $mat_inv_not_inv;
					$inserdata[$i]['sales_price'] = (!empty($rowData[0]['sales_price'])) ? $rowData[0]['sales_price'] : '';
					$inserdata[$i]['cost_price'] = (!empty($rowData[0]['cost_price'])) ? $rowData[0]['cost_price'] : '';
					$inserdata[$i]['mat_sku'] = (!empty($rowData[0]['mat_sku'])) ? $rowData[0]['mat_sku'] : '';
					$inserdata[$i]['specification'] = (!empty($rowData[0]['specification'])) ? $rowData[0]['specification'] : '';
					$inserdata[$i]['uom'] = $uom_idd;
					$inserdata[$i]['alternateuom'] = $Altuom_idVal;
					$inserdata[$i]['alternate_qty'] = $rowData[0]['alternate_qty'] ? $rowData[0]['alternate_qty'] : '';
					$inserdata[$i]['min_inventory'] = (!empty($rowData[0]['reorder_quantity'])) ? $rowData[0]['reorder_quantity'] : '';
					$inserdata[$i]['min_order'] = (!empty($rowData[0]['min_inventory'])) ? $rowData[0]['min_inventory'] : '';
					$inserdata[$i]['max_inventory'] = (!empty($rowData[0]['max_inventory'])) ? $rowData[0]['max_inventory'] : '';
					$inserdata[$i]['tax'] = (!empty($rowData[0]['tax'])) ? $rowData[0]['tax'] : '';
					$inserdata[$i]['hsn_code'] = $getHSNNumberval;
					$inserdata[$i]['dimension_length'] = $rowData[0]['dimension_length'] ? $rowData[0]['dimension_length'] : '';
					$inserdata[$i]['dimension_width'] = $rowData[0]['dimension_width'] ? $rowData[0]['dimension_width'] : '';
					$inserdata[$i]['dimension_height'] = $rowData[0]['dimension_height'] ? $rowData[0]['dimension_height'] : '';
					$inserdata[$i]['total_cbf'] = $cbf_val2 ? $cbf_val2 : '';
					$inserdata[$i]['sale_purchase'] = $rowData[0]['sale'] ? '["Sale"]' : '';
					$inserdata[$i]['route'] = $rowData[0]['purchase'] ? '["Purchase"]' : '';
						
						
						
						
						
						
						
						
                      //  $inserdata[$i]['opening_balance'] = (!empty($rowData[0]['opening_balance'])) ? $rowData[0]['opening_balance'] : '';
                      //  $inserdata[$i]['closing_balance'] = (!empty($rowData[0]['closing_balance'])) ? $rowData[0]['closing_balance'] : '';
                        // $inserdata[$i]['lead_time'] = (!empty($rowData[0]['lead_time'])) ? $rowData[0]['lead_time'] : '';
                        // $inserdata[$i]['time_period'] = (!empty($rowData[0]['time_period'])) ? $rowData[0]['time_period'] : '';
                       
                        // $inserdata[$i]['cess'] = (!empty($rowData[0]['cess'])) ? $rowData[0]['cess'] : '';
                        // 
                        // $inserdata[$i]['packing_data'] = $packing_data;
						
						
						
                       
                        
					    
						
                       
                        
                       
                        
                        $inserdata[$i]['save_status'] = '1';
                        $inserdata[$i]['created_by'] = $_SESSION['loggedInUser']->u_id;
                        $inserdata[$i]['created_by_cid'] = $this->companyId;

                        $i++;
                    }

                      // pre($inserdata);

                  // die(); 
                    $result = $this->inventory_model->importdataMaterial('material', $inserdata);
                   // $result = $this->inventory_model->importdata('mat_locations', $mat_location);
                    if ($result) {
                        //echo "Imported successfully";
                        $this->session->set_flashdata('message', 'Imported successfully');
                    } else {
                        //  echo "ERROR !";
                        $this->session->set_flashdata('message', 'ERROR !');
                    }
                }
                catch(Exception $e) {
                    $this->session->set_flashdata('message', 'This Type File Not allowed for upload');
                   // redirect('inventory/materials', 'refresh');
                    redirect(base_url() . 'inventory/materials', 'refresh');
                }
            } else {
                $this->session->set_flashdata('message', $error['error']);
               // redirect('inventory/materials', 'refresh');
                redirect(base_url() . 'inventory/materials', 'refresh');
            }
        }
        //$this->load->view('import_ledger/index',$this->data);
        //$this->_render_template('inventory/materials');
        redirect('inventory/materials', 'refresh');
    }
    public function import_view_mat_location() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->breadcrumb->add('Import Data', base_url() . 'Import Data');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Import Data';
        $this->load->library('excel');
        if ($_FILES) {
            $created_by_id = $this->companyId;
            //$created_by_id  = $_SESSION['loggedInUser']->c_id;
            $path = 'assets/modules/import/uploads/';
            $this->load->library('excel');
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls';
            $config['remove_spaces'] = TRUE;
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
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true;
                    $i = 0;
                    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                        $worksheetTitle = $worksheet->getTitle();
                        $highestRow = $worksheet->getHighestRow(); // e.g. 10
                        $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
                        $headings = $worksheet->rangeToArray('A1:' . $highestColumn . 1, NULL, TRUE, FALSE);
                    }
                    //$mat_location = arr;
                    for ($row = 2;$row <= $highestRow;$row++) {
                        $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                        $rowData[0] = array_combine($headings[0], $rowData[0]);



                        $Location_id = getNameByID('company_address', $rowData[0]['location_id'],'location');

                        if($Location_id == ''){
                            $Loc_IDD = '0';
                        }else{
                            $Loc_IDD = $Location_id->id;
                        }
                        //pre($Loc_IDD);die();

                        $materialType = getNameByID('material_type',$rowData[0]['material_type_id'],'name');
                        if($materialType == ''){
                            $mat_type_IDD = '0';
                        }else{
                            $mat_type_IDD = $materialType->id;
                        }

                        $uom_id_mat_location = getNameByID('uom',$rowData[0]['Qtyuom'],'uom_quantity');

                        if($uom_id_mat_location == ''){
                            $uom_idd = '0';
                        }else{
                            $uom_idd = $uom_id_mat_location->id;
                        }
                        $material_id = getNameByID('material',$rowData[0]['material_name_id'],'material_name');

                        if($material_id == ''){
                            $mat_name_IDD = '0';
                        }else{
                            $mat_name_IDD = $material_id->id;
                        }
                        //$mat_Data = mat_last_id_GET('material',$this->companyId,'created_by_cid');
                        //$insert_mat_id = $mat_Data->AUTO_INCREMENT + $i;

                        $mat_location[$i]['location_id'] =  $Loc_IDD;
                        $mat_location[$i]['material_type_id'] =  $mat_type_IDD;
                        //$mat_location[$i]['material_name_id'] =  (!empty($rowData[0]['material_name_id'])) ? $rowData[0]['material_name_id'] : '';
                        $mat_location[$i]['material_name_id'] =  $mat_name_IDD;

                       // $mat_location[$i]['storage'] =  (!empty($rowData[0]['storage'])) ? $rowData[0]['storage'] : '';
                       // $mat_location[$i]['rackNumber'] =  (!empty($rowData[0]['rackNumber'])) ? $rowData[0]['rackNumber'] : '';
                        $mat_location[$i]['quantity'] =  (!empty($rowData[0]['quantity'])) ? $rowData[0]['quantity'] : '';
                      //  $mat_location[$i]['lot_no'] =  (!empty($rowData[0]['lot_no'])) ? $rowData[0]['lot_no'] : '';
                        $mat_location[$i]['Qtyuom'] =  $uom_idd;
                        //$mat_location[$i]['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                        //$mat_location[$i]['created_by'] = $_SESSION['loggedInUser']->u_id;
                        $mat_location[$i]['created_by_cid'] = $this->companyId;
                        $i++;
                    }

                     // pre($mat_location);
                   // die();
                    //$result = $this->inventory_model->importdata('material', $inserdata);
                     $result = $this->inventory_model->importdata('mat_locations', $mat_location);
                    if ($result) {
                      $this->session->set_flashdata('message', 'Locations Imported successfully');
                    } else {
                        //  echo "ERROR !";
                        $this->session->set_flashdata('message', 'ERROR !');
                    }
                }
                catch(Exception $e) {
                    $this->session->set_flashdata('message', 'This Type File Not allowed for upload');
                    // redirect('inventory/materials', 'refresh');
                    redirect(base_url() . 'inventory/materials', 'refresh');
                }
            } else {
                $this->session->set_flashdata('message', $error['error']);
                //redirect('inventory/materials', 'refresh');
                redirect(base_url() . 'inventory/materials', 'refresh');
            }
        }
        //$this->load->view('import_ledger/index',$this->data);
        //$this->_render_template('inventory/materials');
        redirect(base_url() . 'inventory/materials', 'refresh');
    }
	
	public function import_subTypeData() {
        
        $this->load->library('excel');
        if ($_FILES) {
            $created_by_id = $this->companyId;
            //$created_by_id  = $_SESSION['loggedInUser']->c_id;
            $path = 'assets/modules/import/uploads/';
            $this->load->library('excel');
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls';
            $config['max_size'] = '10000';
            $config['remove_spaces'] = TRUE;
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
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true;
                    $i = 0;
                    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                        $worksheetTitle = $worksheet->getTitle();
                        $highestRow = $worksheet->getHighestRow(); // e.g. 10
                        $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
                        $headings = $worksheet->rangeToArray('A1:' . $highestColumn . 1, NULL, TRUE, FALSE);
                    }
                    for ($row = 2;$row <= $highestRow;$row++) {
                        $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                        $rowData[0] = array_combine($headings[0], $rowData[0]);
                        $Array_material_sub_type = explode(',', $rowData[0]['material_sub_type']);
						$countSubtype = count($Array_material_sub_type);
						if ($countSubtype > 0) {
							$subtypeArr = [];
							$i = 0;
							while ($i < $countSubtype) {
								$SubType_jsonArray = (array('sub_type' => $Array_material_sub_type[$i]));
								$subtypeArr[$i] = $SubType_jsonArray;
								$i++;
							}
							$SubType_array = json_encode($subtypeArr);
						} else {
							$SubType_array = '';
						}
					
                       
                        $inserdata[$i]['name'] = (!empty($rowData[0]['subtype_name'])) ? $rowData[0]['subtype_name'] : '';
                        $inserdata[$i]['sub_type'] = $SubType_array;
                        $inserdata[$i]['prefix'] = strtoupper(substr($rowData[0]['subtype_name'], 0, 3));;
                        
                        // $inserdata[$i]['save_status'] = '1';
                        $inserdata[$i]['used_status'] = '1';
                        $inserdata[$i]['created_by'] = $_SESSION['loggedInUser']->u_id;
                        $inserdata[$i]['created_by_cid'] = $this->companyId;

                        $i++;
                    }

                     
                    $result = $this->inventory_model->importData('material_type', $inserdata);
                   // $result = $this->inventory_model->importdata('mat_locations', $mat_location);
                    if ($result) {
                        //echo "Imported successfully";
                        $this->session->set_flashdata('message', 'Imported successfully');
                    } else {
                        //  echo "ERROR !";
                        $this->session->set_flashdata('message', 'ERROR !');
                    }
                }
                catch(Exception $e) {
                    $this->session->set_flashdata('message', 'This Type File Not allowed for upload');
                   // redirect('inventory/materials', 'refresh');
                    redirect(base_url() . 'inventory/materials', 'refresh');
                }
            } else {
                $this->session->set_flashdata('message', $error['error']);
               // redirect('inventory/materials', 'refresh');
                redirect(base_url() . 'inventory/materials', 'refresh');
            }
        }
        //$this->load->view('import_ledger/index',$this->data);
        //$this->_render_template('inventory/materials');
        redirect('inventory/materials', 'refresh');
    }
	
	
	
	
	
	
	/*  Import Functionality End */
public function add_uom_detials_on_the_spot() {
    $uom_quantity = $_REQUEST['uom_quantity'];
    $uom_quantity_type = $_REQUEST['uom_quantity_type'];
    $ugc_code = $_REQUEST['ugc_code'];
    $created_by_cid = $_SESSION['loggedInUser']->c_id;
    $created_by_id = $_SESSION['loggedInUser']->u_id;
    $active_inactive = "1";
    $uom_details = array('uom_quantity' => $uom_quantity, 'uom_quantity_type' => $uom_quantity_type, 'ugc_code' => $ugc_code, 'active_inactive' => $active_inactive, 'created_by_cid' => $created_by_cid, 'created_by ' => $created_by_id);
    $data = $this->inventory_model->insert_on_spot_tbl_data('uom', $uom_details);
    if ($data > 0) {
        echo 'true';
    } else {
        echo 'false';
    }
}
public function aknowledge() {
    $this->data['materialissue'] = $this->inventory_model->get_data_byId('wip', 'id', $this->input->post('id'));
    $this->load->view('work_in_process/aknowledge', $this->data);
}
public function updateaknowledge() {
    $id = $this->input->post('id');
    $data = $this->input->post();
    #pre($data);
    # die;
    $data['material_status'] = "WIP";
    $data['created_by'] = $_SESSION['loggedInUser']->u_id;
    $data['created_by_cid'] = $this->companyId;
    if ($id != '') {
        //$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
        $success = $this->inventory_model->update_data('wip', $data, 'id', $id);
        if ($success) {
            $this->session->set_flashdata('message', 'Acknowledge Date Updated successfully');
            redirect(base_url() . 'inventory/work_in_process', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Acknowledge Date Not Updated successfully');
            redirect(base_url() . 'inventory/work_in_process', 'refresh');
        }
    }
}
public function fg_aknowledge() {
    $this->data['ackn_fg'] = $this->inventory_model->get_data_byId('finish_goods', 'id', $this->input->post('id'));
    $this->data['company_details'] = $this->inventory_model->get_data_byId('company_address', 'id', $this->data['ackn_fg']->location_id);
    $this->load->view('finish_goods/aknowledge', $this->data);
}
public function fg_view() {
    $this->data['ackn_fg'] = $this->inventory_model->get_data_byId('finish_goods', 'id', $this->input->post('id'));
    $this->data['company_details'] = $this->inventory_model->get_data_byId('company_address', 'id', $this->data['ackn_fg']->location_id);
    $this->load->view('finish_goods/view', $this->data);
}
public function fg_Matview() {
    $this->data['finish_good'] = $this->inventory_model->get_data_byId('finish_goods', 'id', $this->input->post('id'));
    $this->load->view('finish_goods/matview', $this->data);
}
public function fg_updateaknowledge() {
    $id = $this->input->post('id');
    $data = $this->input->post();
    $data['created_by'] = $_SESSION['loggedInUser']->u_id;
    $data['created_by_cid'] = $this->companyId;
   //  $fgData=json_decode($data['job_card_detail']);
   // $jobcardMaterial =$outputQuty=[];
   //  foreach ($fgData as $valueFG) {
   //       // this Code use in  Only Alfa Project 
   //       $job_cardData = getNameById('job_card',$valueFG->job_card_no,'id');
   //        $jobcardMaterial[]=$job_cardData;
   //       $outputQuty[]=$valueFG->output;
   // /// this Code use in  Only Alfa Project 
         
   //  }
    //     pre($jobcardMaterial);
    //     pre($outputQuty);


    // die; 
    $usersWithViewPermissions = $this->inventory_model->get_dataw('permissions', array('is_view' => 1, 'sub_module_id' => 7));
    if ($id != '') {
        //$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
        $success = $this->inventory_model->update_wip('finish_goods', $data, 'id', $id);
















 
//            if($success){
//              /*************In-out material***************/
 
// $process_input_arr=[];
// foreach ($jobcardMaterial as $keyIndex => $valueTest) {
//         $jobcardMarteial=json_decode($valueTest->material_details);
//         foreach ($jobcardMarteial as  $JobcarMaterialvalue) {
//             //pre($JobcarMaterialvalue);
//                  $useQty= ($outputQuty[$keyIndex])*($JobcarMaterialvalue->quantity)/$valueTest->lot_qty;
//                $process_input_arr[]=['material_id'=>$JobcarMaterialvalue->material_name_id,
//                                      'material_type_id'=>$JobcarMaterialvalue->material_type_id,
//                                      'quantity'=>$useQty];
//         }
// }
 
                          
//                     foreach($process_input_arr as $rr){
//                                 $getmatdata = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $rr['material_id'], 'material_type_id' => $rr['material_type_id']));
              
//                                 $j = 0;
//                                 $material_data1 = array();
//                                 $l = 0;
//                                 $rt = 0;
//                                 $arr = [];
//                                 $closingblcn = 0;
//                                 foreach($getmatdata as $key1){

//                                     $yu = getNameById_mat('mat_locations',$rr['material_id'],'material_name_id');
//                                     $sum = 0;
//                                     if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
//                                     $closingblcn = ($sum >= $rr['quantity']) ? $sum - $rr['quantity']:$sum;

//                                     if ($key1['material_name_id'] == $rr['material_id']){   //&& $key1['Storage'] == $rr['storage']

//                                         #//update quanity in mat_location
//                                         $material_data1 = $key1;
//                                         $closing_bal = ($key1['quantity'] >= $rr['quantity']) ? $key1['quantity'] - $rr['quantity']:$key1['quantity'];
//                                         $material_data1['quantity'] = $closing_bal;
//                                         #pre($material_data1);
//                                         $Update = $this->inventory_model->update_single_field('mat_locations', $material_data1);

//                                         $arr[] =  json_encode(array(array('location' => $key1['location'],'Storage' => $key1['storage'] , 'RackNumber' => $key1['RackNumber'] , 'quantity' => $closing_bal , 'Qtyuom' => $key1['uom'])));
//                                         $rt++;
//                                         $inventoryFlowDataArray1['current_location'] = $arr[$l];
//                                         $inventoryFlowDataArray1['material_id'] = $rr['material_id'];
//                                         $inventoryFlowDataArray1['material_out'] = $rr['quantity'];
//                                         $inventoryFlowDataArray1['uom'] = $rr['uom'];
//                                         $inventoryFlowDataArray1['opening_blnc'] = $sum; //$key1['quantity'];
//                                         $inventoryFlowDataArray1['material_type_id'] = $key1['material_type_id'];
//                                         $inventoryFlowDataArray1['closing_blnc'] = $closingblcn;
                                        
//                                             $msg = 'Issued for Finish request';
                                        
//                                         $inventoryFlowDataArray1['through'] = $msg;
//                                         $inventoryFlowDataArray1['ref_id'] = $insertedid;
//                                         $inventoryFlowDataArray1['created_by'] = $_SESSION['loggedInUser']->id;
//                                         $inventoryFlowDataArray1['created_by_cid'] = $this->companyId;
//                                         #pre($inventoryFlowDataArray1);
//                                         $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray1);

//                                         #//Update lot materials
//                                         $this->material_Lot_inOut($rr['material_id']);
//                                         #Update closing balance
//                                         $this->update_closing_balance($rr['material_id']);
//                                     }
//                                 }
//                                 $j++;
//                             }
//                             /*************In-out material***************/
//            }


 










        if ($success) {
            $this->session->set_flashdata('message', 'Acknowledge Date Updated successfully');
            if (!empty($usersWithViewPermissions)){
            foreach ($usersWithViewPermissions as $userViewPermission) {
            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
            pushNotification(array('subject' => 'Acknowledge Date', 'message' => 'Acknowledge Date Updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $userViewPermission['user_id'], 'to_id' => $userViewPermission['user_id'], 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
            }
            }
            }
            if ($_SESSION['loggedInUser']->role != 1){
            pushNotification(array('subject' => 'Acknowledge Date', 'message' => 'Acknowledge Date Updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
            }
            pushNotification(array('subject' => 'Acknowledge Date', 'message' => 'Acknowledge Date Updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
            $email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
            <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
            <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi Test</p>
            <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Acknowledge Date Updated successfully.</p>
            <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>
            </td>
            </tr>
            </table>
            </td>
            </tr>';
           // send_mail_notification($_SESSION['loggedInUser']->email, 'Notification Email For Acknowledge Date', $email_message);
            if($_SESSION['loggedInUser']->c_id){
            $select = "email";
            $where = 'c_id='.$_SESSION['loggedInUser']->c_id.' AND role=1';
            $get_admin = $this->inventory_model->admin_email_data('user',$select, $where);
            foreach ($get_admin as $key => $value) {
            //send_mail_notification($value['email'], 'Notification Email For Acknowledge Date', $email_message);
            } }

            redirect(base_url() . 'inventory/finish_goods', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Acknowledge Date Not Updated successfully');
            if (!empty($usersWithViewPermissions)){
            foreach ($usersWithViewPermissions as $userViewPermission) {
            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
            pushNotification(array('subject' => 'Acknowledge Date', 'message' => 'Acknowledge Date Not Updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $userViewPermission['user_id'], 'to_id' => $userViewPermission['user_id'], 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
            }
            }
            }
            if ($_SESSION['loggedInUser']->role != 1){
            pushNotification(array('subject' => 'Acknowledge Date', 'message' => 'Acknowledge Date Not Updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
            }
            pushNotification(array('subject' => 'Acknowledge Date', 'message' => 'Acknowledge Date Not Updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
            $email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
            <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
            <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi Test</p>
            <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Acknowledge Date Not Updated successfully.</p>
            <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>
            </td>
            </tr>
            </table>
            </td>
            </tr>';
            //send_mail_notification($_SESSION['loggedInUser']->email, 'Notification Email For Acknowledge Date', $email_message);
            if($_SESSION['loggedInUser']->c_id){
            $select = "email";
            $where = 'c_id='.$_SESSION['loggedInUser']->c_id.' AND role=1';
            $get_admin = $this->inventory_model->admin_email_data('user',$select, $where);
            foreach ($get_admin as $key => $value) {
            //send_mail_notification($value['email'], 'Notification Email For Acknowledge Date', $email_message);
            } }
            redirect(base_url() . 'inventory/finish_goods', 'refresh');
        }
    }
}
public function view_third_party_details() {
    if ($this->input->post()) {
        $this->data['id'] = $this->input->post('id');
        $this->data['delivery_data'] = $this->inventory_model->get_data_byId('thrd_party_invtry', 'id', $this->input->post('id'));
        $this->load->view('inventory_listing_and_adjustment/view_third_party', $this->data);
    }
}
public function create_third_party_inv_pdf($id = '') {
    $this->load->library('Pdf');
    $dataPdf['dataPdf'] = $this->inventory_model->get_data_byId('thrd_party_invtry', 'id', $id);
    $this->load->view('inventory_listing_and_adjustment/third_party_inv_pdf', $dataPdf); //$this->_render_template('purchase_order/view_pdf', $this->data);

}
public function getWorkOrderProductsData() {
    $work_order_id = $_POST['work_order_id'];
    $this->data['work_order_id'] = $work_order_id;
    $ProductsData = $this->inventory_model->get_data_byId('work_order', 'id', $work_order_id);
    $this->data['products_array'] = $ProductsData;
    //pre($this->data);die;
    $data = $this->load->view('wip_and_finish_goods/work_order_ajax', $this->data);
    echo $data;
}
/* function get job card data ***/
/////
public function getWorkOrderDetail() {
    $WorkOrderid = $_POST['id'];
    $WorkOrderDetail = $this->inventory_model->get_data_byId('work_order', 'id', $WorkOrderid);
    //pre($WorkOrderDetail);die;
    echo $WorkOrderDetail->product_detail;
}
public function reorder_level1() {
    $this->load->library('pagination');
    $this->data['can_edit'] = edit_permissions();
    $this->data['can_delete'] = delete_permissions();
    $this->data['can_add'] = add_permissions();
    $this->data['can_view'] = view_permissions();
    $this->breadcrumb->add('Reorder Level List', base_url() . 'inventory/dashboard');
    $this->breadcrumb->add('Reorder Level List', base_url() . 'inventory/reorder_level');
    $this->settings['breadcrumbs'] = $this->breadcrumb->output();
    $this->settings['pageTitle'] = 'Reorder Level List';
    $where2 = '';
    $search_string = '';
    if (!empty($_POST['search'])) {
        $search_string = $_POST['search'];
        $where2 = "id = '" . $search_string."'";
        redirect("inventory/reorder_level/?search=$search_string");
    } else if (isset($_GET['search'])) {
        $where2 = "id ='".$_GET['search']."'";
    }
    if (!empty($_POST['order'])) {
        $order = $_POST['order'];
    } else {
        $order = "desc";
    }
    $where12 = "reoder_level_report.created_by_cid = " . $this->companyId;
    //Pagination
    $config = array();
    $config["base_url"] = base_url() . "inventory/reorder_level/";
    $config["total_rows"] = $this->inventory_model->num_rows('reoder_level_report', $where12, $where2);
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

    $this->data['reorder_level'] = $this->inventory_model->get_data1('reoder_level_report', $where12, $config["per_page"], $page, $where2, $order,$export_data);
    $whereMaterialType = "(created_by_cid ='" . $this->companyId . "' OR created_by_cid =0) AND status = 1";
    $this->data['mat_type'] = $this->inventory_model->get_filter_details('material_type', $whereMaterialType);
        if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }
        if($end>$config['total_rows'])
        {
        $total=$config['total_rows'];
        }else{
        $total=$end;
        }
    $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
    $this->_render_template('reorder_level/index', $this->data);
}

public function generate_reorder_report() {
    $branch = !empty($_POST['branch_name']) ? $_POST['branch_name'] :'';
    $mattype = !empty($_POST['material_type_id']) ? $_POST['material_type_id'] :'';
    $matsubtype = !empty($_POST['sub_type']) ? trim($_POST['sub_type']) :'';
    if(!empty($matsubtype)){
        $this->data['materials'] = $this->inventory_model->get_data('material', array('material_type_id' => $mattype, 'sub_type' => $matsubtype, 'status' => 1, 'created_by_cid' => $this->companyId));
    }
    else{
        $this->data['materials'] = $this->inventory_model->get_data('material', array('material_type_id' => $mattype, 'status' => 1, 'created_by_cid' => $this->companyId));
    }
    $ij = 0;
    $gh = "";
    $uio = "";
    $val = array();

    foreach ($this->data['materials'] as $key){
        $yu = getNameById_mat('mat_locations', $key['id'], 'material_name_id');
        $sum = 0;
        if (!empty($yu)) {
            foreach ($yu as $ert) {
                $sum+= $ert['quantity'];
            }
        }
        $yu1 = getNameById_mat('mat_locations', $key['id'], 'material_name_id');
        if (!empty($yu1)) {
            foreach ($yu1 as $ert1) {
                if (empty($ert1['location_id'])) {
                    $gh = "";
                } else {
                    $gh = $ert1['location_id'];
                }
            }
        }

        if($key['min_inventory'] > $sum){
            $uio = $key['min_inventory'] * $key['cost_price'];
            $rry = array('product_code' => $key['material_code'], 'type' => $key['material_type_id'], 'sub_type' => $key['sub_type'], 'product_name' => $key['material_name'], 'location_id' => $gh, 'clossing_balance' => $sum, 'uom' => $key['uom'], 'last_ordered' => '', 'consumed_order_date' => '', 'net_qty' => '', 'reorder_quantity' => $key['min_inventory'], 'expected_amount' => $key['cost_price'], 'sub_total' => $uio);
            if(!empty($branch) && $gh == $branch){
                $rry = array('product_code' => $key['material_code'], 'type' => $key['material_type_id'], 'sub_type' => $key['sub_type'], 'product_name' => $key['material_name'], 'location_id' => $gh, 'clossing_balance' => $sum, 'uom' => $key['uom'], 'last_ordered' => '', 'consumed_order_date' => '', 'net_qty' => '', 'reorder_quantity' => $key['min_inventory'], 'expected_amount' => $key['cost_price'], 'sub_total' => $uio);
            }
            $val[$ij] = $rry;
            $ij++;
        }
    }
    $ty = !empty($val) ? json_encode($val) : '';
    $data['no_of_items'] = !empty($val) ? count($val) : '';
    $data['inventory_items'] = $ty;
    $data['created_by_cid'] = $this->companyId;
    $data['created_by'] = $_SESSION['loggedInUser']->u_id;
    if (!empty($data['inventory_items'])) {
        $id = $this->inventory_model->insert_tbl_data('reoder_level_report', $data);
    }
    if ($ty) {
        logActivity('Reorder Level Report Generated', 'reorder_level', $id);
        $this->session->set_flashdata('message', 'Material Reorder Report Generated Successfully');
        $usersWithViewPermissions = $this->inventory_model->get_dataw('permissions', array('is_view' => 1, 'sub_module_id' => 7));
        if (!empty($usersWithViewPermissions)){
        foreach ($usersWithViewPermissions as $userViewPermission) {
        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
        pushNotification(array('subject' => 'Material Reorder Report', 'message' => 'Material Reorder Report Generated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $userViewPermission['user_id'], 'to_id' => $userViewPermission['user_id'], 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
        }
        }
        }
        if ($_SESSION['loggedInUser']->role != 1){
        pushNotification(array('subject' => 'Material Reorder Report', 'message' => 'Material Reorder Report Generated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
        }
        pushNotification(array('subject' => 'Material Reorder Report', 'message' => 'Material Reorder Report Generated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
        $email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
        <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
        <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi Test</p>
        <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Material Reorder Report Generated Successfully.</p>
        <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>
        </td>
        </tr>
        </table>
        </td>
        </tr>';
        //send_mail_notification($_SESSION['loggedInUser']->email, 'Notification Email For Material Reorder Report', $email_message);
        if($_SESSION['loggedInUser']->c_id){
        $select = "email";
        $where = 'c_id='.$_SESSION['loggedInUser']->c_id.' AND role=1';
        $get_admin = $this->inventory_model->admin_email_data('user',$select, $where);
        foreach ($get_admin as $key => $value) {
        //send_mail_notification($value['email'], 'Notification Email For Material Reorder Report', $email_message);
        } }

        redirect(base_url() . 'inventory/reorder_level', 'refresh');
    } else {
        $this->session->set_flashdata('message', 'No Record Found, Report not Generated');
        redirect(base_url() . 'inventory/reorder_level', 'refresh');
    }
}

public function generate_reorder_level_report() {
    if ($this->input->post()) {
        //    (!empty($_POST['branch']))?$branch = $_POST['branch']:$branch = null;
        //    (!empty($_POST['material_type']))?$mattype = $_POST['material_type']:$mattype = null;
        //    (!empty($_POST['material_subtype']))?$matsubtype = $_POST['material_subtype']:$matsubtype = null;
        // #pre($_POST);
        // $this->data['branch'] = $branch;
        // $this->data['material_type'] = $mattype;
        // $this->data['material_subtype'] = $matsubtype;
        $this->data['id'] = $this->input->post('id');
        $this->data['report_data'] = $this->inventory_model->get_data_byId('reoder_level_report', 'id', $this->input->post('id'));
        $this->load->view('reorder_level/view', $this->data);
    }
}
public function create_pdf($id = '') {
    $this->load->library('Pdf');
    $dataPdf['dataPdf'] = $this->inventory_model->get_data_byId('reoder_level_report', 'id', $id);
    $this->load->view('reorder_level/view_pdf1', $dataPdf);
}
public function convert_to_purchase_indent($id = '') {
    $this->data['report_data'] = $this->inventory_model->get_data_byId('reoder_level_report', 'id', $this->input->post('id'));
    $this->load->view('reorder_level/convert_from_reord_lvl', $this->data);
}
public function getAddress() {
    $where = array('id' => $this->companyId);
    //pre($where);die();
    $data = $this->inventory_model->get_data_byAddress('company_detail', $where);
    $data1 = $data[0]['address'];
    $data2 = json_decode($data1);
    $addressArray = array();
    $i = 0;
    foreach ($data2 as $dt) {
        #pre($dt);
        $addressArray[$i]['id'] = $dt->add_id;
        $addressArray[$i]['text'] = $dt->address;
        $i++;
    }
   // pre($addressArray);die('HERE');
    echo json_encode($addressArray);
}
public function get_mrp_monthvise() {
    // POST data
    $postData = $this->input->post();
    /* pre($postData);
    die; */
    // Custom search filter
    $searchCompnyUnit = $postData['company'];
    $searchDepartment = $postData['department'];
    $searchMonth = $postData['selected_month'];
    ## Search
    $search_arr = array();
    $searchQuery = "";
    if ($searchCompnyUnit != '') {
        $search_arr[] = " company_branch_id='" . $searchCompnyUnit . "' ";
    }
    if ($searchDepartment != '') {
        $search_arr[] = " department_id='" . $searchDepartment . "'  AND work_order.progress_status=0";
    }
    if ($searchMonth != '') {
        #$search_arr[] = " name like '%" . $searchMonth . "%' ";
        $month_array = explode("-", $searchMonth);
        $search_arr[] = " work_order.created_by_cid = " . $_SESSION['loggedInUser']->c_id . " AND work_order.progress_status=0 AND year(STR_TO_DATE(`work_order`.`expected_delivery_date`,'%d-%m-%Y')) =  '" . @$month_array[0] . "' AND month(STR_TO_DATE(`work_order`.`expected_delivery_date`,'%d-%m-%Y')) =  '" . @$month_array[1] . "'";
    }
    if (count($search_arr) > 0) {
        $searchQuery = implode(" and ", $search_arr);
    }
    //pre(count($search_arr));die;
    $this->data['work_ordr'] = $this->inventory_model->getWorkOrderList($searchQuery);
    #pre($this->data['work_ordr']);
    $rt = $this->load->view('mrp_dtl/mrpexe', $this->data);
    //pre($rt);
    return $rt;
    #pre($data_response);
}
public function edit_monthly_mrp() {
    if ($this->input->post('id') != '') {
        permissions_redirect('is_edit');
    } else {
        permissions_redirect('is_add');
    }
    $this->data['mrpdt'] = $this->inventory_model->get_data_byIdpricelist('mrp_details', 'id', $this->input->post('id'));
    //$this->data['attachments']  = $this->crm_model->get_attachmets_by_saleOrderId('attachments', 'rel_id',$this->input->post('id'));
    $this->load->view('mrp_dtl/edit_monthly_mrp', $this->data);
}
public function savemrpdtl() {
    # pre($_POST['mat_idd']);
    #pre($this->input->post());die;
    if ($this->input->post()) {
        $required_fields = array('workOrderIDs');
        $usersWithViewPermissions = $this->inventory_model->get_dataw('permissions', array('is_view' => 1, 'sub_module_id' => 7));
        $is_valid = validate_fields($_POST, $required_fields);
        if (count($is_valid) > 0) {
            valid_fields($is_valid);
        } else {
            $data = $this->input->post();
            $workerids_count = count($_POST['mat_idd']);
            if ($workerids_count > 0) {
                $arr = [];
                $i = 0;
                // while ($i < $workerids_count) {
                foreach ($this->input->post('select_all1') as $val) {
                    @$jsonArrayObject = (array('mat_idd' => $_POST['mat_idd'][$val][0], 'totl_ordr' => $_POST['totl_ordr'][$val][0], 'uom_selected_id' => $_POST['uom_selected_id'][$val][0]));
                    $arr[$i] = $jsonArrayObject;
                    $i++;
                }
                #pre($arr);die;
                //remaning_qty ==> if remaning_qty is 0 means its complete PI
                $material_array = json_encode($arr);
            } else {
                $material_array = '';
            }
        }
        #pre($material_array);die;
        $data['mrp_data'] = $material_array;
        $data['created_by'] = $_SESSION['loggedInUser']->id;
        $data['created_by_cid'] = $this->companyId;
        $id = $data['id'];
        #pre($data);
        #pre($material_array);
        if ($id && $id != '') {
            $success = $this->inventory_model->update_data('mrp_details', $data, 'id', $id);
            if ($success) {
                $data['message'] = "MRP Details  updated successfully";
                logActivity('MRP Details  Updated', 'inventory', $id);
                $this->session->set_flashdata('message', 'MRP Details Updated successfully');
                if (!empty($usersWithViewPermissions)){
                foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                pushNotification(array('subject' => 'MRP Details Updated', 'message' => 'MRP Details Updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $userViewPermission['user_id'], 'to_id' => $userViewPermission['user_id'], 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                }
                }
                }
                if ($_SESSION['loggedInUser']->role != 1){
                pushNotification(array('subject' => 'MRP Details Updated', 'message' => 'MRP Details Updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                }
                pushNotification(array('subject' => 'MRP Details Updated', 'message' => 'MRP Details Updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                $email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
                <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi Test</p>
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">MRP Details Updated successfully.</p>
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>
                </td>
                </tr>
                </table>
                </td>
                </tr>';
                //send_mail_notification($_SESSION['loggedInUser']->email, 'Notification Email For MRP Dtails Updated', $email_message);
                if($_SESSION['loggedInUser']->c_id){
                $select = "email";
                $where = 'c_id='.$_SESSION['loggedInUser']->c_id.' AND role=1';
                $get_admin = $this->inventory_model->admin_email_data('user',$select, $where);
                foreach ($get_admin as $key => $value) {
                //send_mail_notification($value['email'], 'Notification Email For MRP Dtails Updated', $email_message);
                } }
            }
        } else {
            $id = $this->inventory_model->insert_tbl_data('mrp_details', $data);
            if ($id) {
                logActivity('MRP Details ', 'MRP Dtails Added successfully', $id);
                $this->session->set_flashdata('message', 'MRP Details Added successfully');
                if (!empty($usersWithViewPermissions)){
                foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                pushNotification(array('subject' => 'MRP Dtails Added', 'message' => 'MRP Dtails Added by ' . $_SESSION['loggedInUser']->name, 'from_id' => $userViewPermission['user_id'], 'to_id' => $userViewPermission['user_id'], 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                }
                }
                }
                if ($_SESSION['loggedInUser']->role != 1){
                pushNotification(array('subject' => 'MRP Details Added', 'message' => 'MRP Dtails Added by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                }
                pushNotification(array('subject' => 'MRP Details Added', 'message' => 'MRP Details Added by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' =>$_SESSION['loggedInCompany']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                $email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
                <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi Test</p>
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">MRP Details Added successfully.</p>
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>
                </td>
                </tr>
                </table>
                </td>
                </tr>';
                //send_mail_notification($_SESSION['loggedInUser']->email, 'Notification Email For MRP Details Added', $email_message);
                if($_SESSION['loggedInUser']->c_id){
                $select = "email";
                $where = 'c_id='.$_SESSION['loggedInUser']->c_id.' AND role=1';
                $get_admin = $this->inventory_model->admin_email_data('user',$select, $where);
                foreach ($get_admin as $key => $value) {
                //send_mail_notification($value['email'], 'Notification Email For MRP Details Added', $email_message);
                } }
            }
        }
       # die;
        redirect(base_url() . 'inventory/mrp', 'refresh');
    }
}
public function checkmonthlymrp() {
    // POST data
    $postData = $this->input->post();
    // Custom search filter
    $searchCompnyUnit = $postData['searchCompnyUnit'];
    $searchDepartment = $postData['searchDepartment'];
    $searchMonth = $postData['searchMonth'];
    $productionId = $postData['productionId'];
    if (empty($productionId)) {
        $where = "mrp_details.created_by_cid = " . $this->companyId . " AND mrp_details.company_branch=" . $searchCompnyUnit . " AND  mrp_details.department_id=" . $searchDepartment . " AND  mrp_details.month='" . $searchMonth . "'";
        $production_report = $this->production_model->get_data('production_report', $where);
        if (isset($production_report[0])) {
            $status = array('status' => 'success');
        } else {
            $status = array('status' => 'error');
        }
    } else {
        $status = array('status' => 'error');
    }
    echo json_encode($status);
}
public function view_mrp() {
    $id = $_POST['id'];
    $this->data['mrp_dtl'] = $this->inventory_model->get_data_byId('mrp_details', 'id', $id);
    $this->load->view('mrp_dtl/view', $this->data);
}
public function create_mrp_pdf($id = '') {
    $this->load->library('Pdf');
    $dataPdf['dataPdf'] = $this->inventory_model->get_data_byId('mrp_details', 'id', $id);
    $this->load->view('mrp_dtl/view1_pdf', $dataPdf);
}
public function importmaterial() {
    if (!empty($_FILES['uploadFile']['name']) != '') {
        $path = 'assets/modules/inventory/uploads/';
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
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(true, true, true, true, true);
                $flag = true;
                $i = 0;
                #pre($allDataInSheet);
                #die;
                $rt = 1;
                foreach ($allDataInSheet as $value) {
                    if ($flag) {
                        $flag = false;
                        continue;
                    }
                    if ($value['A'][$i] != '' || $value['B'][$i] != '' || $value['C'][$i] != '' || $value['D'][$i] != '' || $value['E'][$i] != '' || $value['F'][$i] != '' || $value['G'][$i] != '' || $value['H'][$i] != '') {
                        $last_id = getLastTableId('material');
                        $rId = $last_id + $rt;
                        $matCode = 'MAT_' . rand(1, 1000000) . '_' . $rId;
                        $insertdata[$i]['material_code'] = $matCode;
                        $insertdata[$i]['material_name'] = $value['A'];
                        $mt = getNameById('material_type', $value['B'], 'name');
                        $insertdata[$i]['material_type_id'] = !empty($mt) ? $mt->id : '';
                        $insertdata[$i]['hsn_code'] = $value['C'];
                        $insertdata[$i]['specification'] = $value['D'];
                        $insertdata[$i]['min_inventory'] = $value['E'];
                        $uom = getNameById('uom', $value['F'], 'ugc_code');
                        $insertdata[$i]['UOM'] = !empty($uom) ? $uom->id : '';
                        $insertdata[$i]['created_Date'] = $value['G'];
                        $insertdata[$i]['status'] = 1;
                        $insertdata[$i]['created_by'] = $_SESSION['loggedInUser']->u_id;
                        $insertdata[$i]['created_by_cid'] = $this->companyId;
                        $rt++;
                        $i++;
                    }
                }
                #pre($insertdata);
                #die;
                $result = $this->inventory_model->importmaterial($insertdata);
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
        $this->session->set_flashdata('message', 'Materials Imported Successfully');
        redirect(base_url() . 'inventory/materials', 'refresh');
    }
    echo "<script>alert('Please Select the File to Upload')</script>";
    redirect(base_url() . 'inventory/materials', 'refresh');
}
public function view_wip() {
    $this->data['materialissue'] = $this->inventory_model->get_data_byId('wip', 'id', $this->input->post('id'));
    $this->load->view('work_in_process/view', $this->data);
}
public function material_Locationview() {
    $this->data['mat_trans'] = $this->inventory_model->get_data_byId('inventory_flow', 'id', $this->input->post('id'));
    $this->load->view('mat_trans/viewmat', $this->data);
}
public function mat_trans() {
    $this->load->library('pagination');
    $this->data['can_edit'] = edit_permissions();
    $this->data['can_delete'] = delete_permissions();
    $this->data['can_add'] = add_permissions();
    $this->data['can_view'] = view_permissions();
    $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
    $this->breadcrumb->add('Material Transaction', base_url() . 'inventory/mat_trans');
    $this->settings['breadcrumbs'] = $this->breadcrumb->output();
    $this->settings['pageTitle'] = 'Material Transaction';
      $where= "inventory_flow.created_by_cid = " . $this->companyId;
    $where2 = '';
    $search_string = '';
    if (!empty($_POST['search'])) {
        $search_string = $_POST['search'];
            $materialName=getNameById('material',$search_string,'material_name');
            if($materialName->id != ''){
                $where2 = "inventory_flow.material_id='".$materialName->id."'";
            }else{
                $where2 = "id ='".$search_string."' OR ref_id='".$search_string."'";
            }
        redirect("inventory/mat_trans/?search=$search_string");
    } elseif(isset($_GET['search']) && $_GET['search']!='') {
        $materialName=getNameById('material',$_GET['search'],'material_name');
            if(isset($materialName->id)!= ''){
                $where2 = "inventory_flow.material_id='".$materialName->id."'";
            }else{
                $where2 = "id ='".$_GET['search']."' OR ref_id='" . $_GET['search']."'";
            }
    }
    if (!empty($_POST['order'])) {
        $order = $_POST['order'];
    } else {
        $order = "desc";
    }

    //Pagination
    @$config = array();
    $config["base_url"] = base_url() . "inventory/mat_trans/";
    $config["total_rows"] = $this->inventory_model->num_rows('inventory_flow', $where, $where2);
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
    $this->data['mat_trans'] = $this->inventory_model->get_data1('inventory_flow', $where, $config["per_page"], $page, $where2, $order,$export_data);
    $whereMaterialType = "(created_by_cid ='" . $this->companyId . "' OR created_by_cid =0) AND status = 1";
    #$this->data['mat_type'] = $this->inventory_model->get_filter_details('material_type', $whereMaterialType);
        if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }
        if($end>$config['total_rows'])
        {
        $total=$config['total_rows'];
        }else{
        $total=$end;
        }
    $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
    $this->_render_template('mat_trans/index', $this->data);
}

   public function saveinventoryreportsetting(){
       
        $this->load->library('Pdf');

        if ($this->input->post()) {
        $required_fields = array('report_name', 'material_type_id', 'frequency');
        $is_valid = validate_fields($_POST, $required_fields);
        //echo count($is_valid);die;
        if (count($is_valid) > 0) {
            echo count($is_valid);die;
            valid_fields($is_valid);
        } else {
            
            $data = $this->input->post();
            
            
            $data['created_date'] = date("Y-m-d h:i:sa");
            $data['created_by'] = $_SESSION['loggedInUser']->id;
            //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
            $data['created_by_cid'] = $this->companyId;
            $data['toEmail'] = json_encode($_POST['users']);
            print_r($data);die;
            if (isset($data['id'])) {
                 $id = $data['id'];
              $usersWithViewPermissions = $this->inventory_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 95));

             // pre($usersWithViewPermissions);
             //  die('here');
            if ($id && $id != '') {
                $success = $this->inventory_model->update_data('daily_report_setting', $data, 'id', $id);
                 if ($success) {
                    /*select all data in daily report */
                     $where = array('daily_report_setting.created_by_cid' => $this->companyId,'id'=>$id);
                     
                     $this->data['daily_report_setting'] = $this->inventory_model->get_data('daily_report_setting', $where);
                     
                      $report=$this->data['daily_report_setting'];
                      $report_name= $report[0]['report_name'];
                      $company_data = getNameById('company_detail',$report[0]['created_by_cid'],'id');
                     $material_type = getNameById('material_type',$report[0]['material_type_id'],'id');
                       /*close select all data in daily report */
                       $toEmail=json_decode($report[0]['toEmail']);
                       //pre($toEmail);die;
                       $user_list =$this->inventory_model->getUserAll('user', $toEmail);
                       //pre($user_list);die;
                         $user_email_data =array();
                              foreach ($user_list as $user_email) {
                              $user_email_data[] =  $user_email['email'];
                              }
                          $materialtype_id=$report[0]['material_type_id'];
                            $where1 = array( 'material_type_id'=>$materialtype_id);
                            $mat_trans = $this->inventory_model->get_data('inventory_flow', $where1);
                            //$her=$this->load->view('inventory_setting/pdfview',$mat_trans,true);
                            $content='';
                            $content.='<table border="1" style="border-collapse: collapse;" cellpadding="2">
                                     <thead>
                                          <tr>
                                            <td colspan="3"><strong></strong><br><br><strong> Company Name :</strong> '.$company_data->name.'<br> <strong>Branch :</strong> '.$company_data->branch.'<br> </td>
                                            <td colspan="3"><strong></strong><br><br><strong> Date :</strong> '.($report[0]['created_date']?date("j F , Y", strtotime($report[0]['created_date'])):'').'<br> <strong>Material Type :</strong> '.$material_type->name.'<br></td>
                                          </tr>
                                      <tr><td colspan="6"><b style="font-size:20px; text-align:center;">Material Description</b></td></tr>
                                     <tr>
                                          <th  rowspan="2" style="text-align:center;"><b>Material Name</b></th>
                                          <th  rowspan="2" style="text-align:center;"><b>UOM</b></th>
                                          <th  rowspan="2" style="text-align:center;"><b>Opening Stock</b></th>
                                          <th  rowspan="2" style="text-align:center;"><b>Inwards</b></th>
                                          <th  rowspan="2" style="text-align:center;"><b>Outwards</b></th>
                                          <th  rowspan="2" style="text-align:center;"><b>Closing Stock</b></th>

                                     </tr>
                                 </thead>
                                  <tbody>';
                                  if(!empty($mat_trans)){
                                   //pre($mat_trans);
                                    foreach($mat_trans as $mattrans){
                                        $moved = "";
                                       //$statusChecked = "";
                                       $action = '';
                                       if($mattrans['through'] == "Moved"){$moved = "(Material Moved from Current to new Location)";}
                                       $ww =  getNameById('material', $mattrans['material_id'],'id');
                                       $matname = !empty($ww)?$ww->material_name:'';
                                       #pre($mattrans['material_id']);
                                       $ww1 =  getNameById('uom', $mattrans['uom'],'id');
                                       $uom = !empty($ww1)?$ww1->ugc_code:'-';

                                       $matin = !empty($mattrans['material_in'])?$mattrans['material_in']:'-';
                                       $matout = !empty($mattrans['material_out'])?$mattrans['material_out']:'-';

                                       $ww2 =  getNameById('user_detail', $mattrans['created_by'],'u_id');
                                       $uname = !empty($ww2)?$ww2->name:'';

                                       $dt =  date("d-M-Y", strtotime($mattrans['created_date']));
                                       #$dt =  date("j F , Y", strtotime($mattrans['created_date']));
                                  $content.="<br><tr>
                                                 <td style='text-align:right;' data-label='Material Name:'>".$matname."</td>
                                                 <td style='text-align:right;' data-label='Material UOM:'>".$uom."</td>
                                                 <td style='text-align:right;' data-label='Opening Stock:'>".$mattrans['opening_blnc']."</td>
                                                 <td style='text-align:right;' data-label='Material in:'>".$matin."</td>
                                                 <td style='text-align:right;' data-label='Material out:'>".$matout."</td>
                                                 <td style='text-align:right;' data-label='Closing Stock:'>".$mattrans['closing_blnc']."</td>

                                           </tr>";
                                    }
                                 }
                                  $content.='</tbody>
                                  </table>';

                                  $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
                                    $pdf->SetCreator(PDF_CREATOR);
                                    $pdf->AddPage();
                                    $pdfFilePath = FCPATH . "assets/modules/inventory/daily_report/daily_report.pdf";
                                    $pdf->WriteHTML($content);
                                    $pdf->Output($pdfFilePath, "F");
                                    $this->sendEmail($pdfFilePath,$user_email_data,$report_name);


                          }
            } else {
                // pre($data);die();
                   $id = $this->inventory_model->insert_tbl_data('daily_report_setting', $data);
                  if ($id) {
                    /*select all data in daily report */
                     $where = array('daily_report_setting.created_by_cid' => $this->companyId,'id'=>$id);
                     $this->data['daily_report_setting'] = $this->inventory_model->get_data('daily_report_setting', $where);
                      $report=$this->data['daily_report_setting'];
                     $report_name= $report[0]['report_name'];

                      $company_data = getNameById('company_detail',$report[0]['created_by_cid'],'id');
                     $material_type = getNameById('material_type',$report[0]['material_type_id'],'id');
                       /*close select all data in daily report */
                       $toEmail=json_decode($report[0]['toEmail']);
                     
                       // $user_list =$this->inventory_model->getUserAll('user', $toEmail);
  
                         $user_email_data =array();
                              foreach ($toEmail as $user_email) {
                                    $where = array('user.c_id' => $this->companyId,'id'=>$user_email);
                                        $useremail = $this->inventory_model->get_data_byId('user', 'id', $user_email);
                                        $user_email_data[] =  $useremail->email;
                              }
                            
                            $materialtype_id=$report[0]['material_type_id'];
                            $where1 = array( 'material_type_id'=>$materialtype_id);
                            //$mat_trans = $this->inventory_model->get_data('inventory_flow', $where1);
                            /**** Code New By Dharamveer*********/
                            $getmatID = $this->inventory_model->get_data('material', $where1);
                            
                            
                            $mat_trans = [];
                            foreach($getmatID as $getmatdata){
                                // $where1 = array( 'material_id'=>$getmatdata['id']);
                                $where1 = "inventory_flow.material_id='".$getmatdata['id']."' ORDER BY id DESC LIMIT 1";
                                $mat_trans[] = $this->inventory_model->getDatabycheckid('inventory_flow', $where1);
                                
                            }
                            $mat_trans = array_filter($mat_trans);           
                            
                            
                            /**** Code New By Dharamveer*********/
                            
                            
                            
                            
                            // $her=$this->load->view('inventory_setting/pdfview',$mat_trans,true);
                            
                            $content='';
                            $content.='<table border="1" style="border-collapse: collapse;" cellpadding="2">
                                     <thead>
                                          <tr>
                                            <td colspan="3"><strong></strong><br><br><strong> Company Name :</strong> '.$company_data->name.'<br> <strong>Branch :</strong> '.$company_data->branch.'<br> </td>
                                            <td colspan="3"><strong></strong><br><br><strong> Date :</strong> '.($report[0]['created_date']?date("j F , Y", strtotime($report[0]['created_date'])):'').'<br> <strong>Material Type :</strong> '.$material_type->name.'<br></td>
                                          </tr>
                                      <tr><td colspan="6"><b style="font-size:20px; text-align:center;">Material Description</b></td></tr>
                                     <tr>
                                          <th  rowspan="2" style="text-align:center;"><b>Material Name</b></th>
                                          <th  rowspan="2" style="text-align:center;"><b>UOM</b></th>
                                          <th  rowspan="2" style="text-align:center;"><b>Opening Stock</b></th>
                                          <th  rowspan="2" style="text-align:center;"><b>Inwards</b></th>
                                          <th  rowspan="2" style="text-align:center;"><b>Outwards</b></th>
                                          <th  rowspan="2" style="text-align:center;"><b>Closing Stock</b></th>

                                     </tr>
                                 </thead>
                                  <tbody>';
                                  if(!empty($mat_trans)){
                                   //pre($mat_trans);
                                    foreach($mat_trans as $mattrans){
                                        $moved = "";
                                       //$statusChecked = "";
                                       $action = '';
                                       if($mattrans['through'] == "Moved"){
                                           $moved = "(Material Moved from Current to new Location)";
                                           }
                                       $ww =  getNameById('material', $mattrans['material_id'],'id');
                                       $matname = !empty($ww)?$ww->material_name:'';
                                       #pre($mattrans['material_id']);
                                       $ww1 =  getNameById('uom', $mattrans['uom'],'id');
                                       $uom = !empty($ww1)?$ww1->ugc_code:'-';

                                       $matin = !empty($mattrans['material_in'])?$mattrans['material_in']:'-';
                                       $matout = !empty($mattrans['material_out'])?$mattrans['material_out']:'-';

                                       $ww2 =  getNameById('user_detail', $mattrans['created_by'],'u_id');
                                       $uname = !empty($ww2)?$ww2->name:'';

                                       $dt =  date("d-M-Y", strtotime($mattrans['created_date']));
                                       #$dt =  date("j F , Y", strtotime($mattrans['created_date']));
                                       
                                       // pre($mattrans);
                                  $content.="<br><tr>
                                                 <td style='text-align:right;' data-label='Material Name:'>".$matname."</td>
                                                 <td style='text-align:right;' data-label='Material UOM:'>".$uom."</td>
                                                 <td style='text-align:right;' data-label='Opening Stock:'>".$mattrans['opening_blnc']."</td>
                                                 <td style='text-align:right;' data-label='Material in:'>".$matin."</td>
                                                 <td style='text-align:right;' data-label='Material out:'>".$matout."</td>
                                                 <td style='text-align:right;' data-label='Closing Stock:'>".$mattrans['closing_blnc']."</td>

                                           </tr>";
                                    }
                                    // die();
                                 }
                                  $content.='</tbody>
                                  </table>';

                                    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
                                    $pdf->SetCreator(PDF_CREATOR);
                                    $pdf->AddPage();
                                    $pdfFilePath = FCPATH . "assets/modules/inventory/daily_report/daily_report.pdf";
                                    $pdf->WriteHTML($content);
                                    ob_end_clean();
                                    $pdf->Output($pdfFilePath, "F");
                                     $this->sendEmail($pdfFilePath,$user_email_data,$report_name);


                          }
                      }
                  }
              $this->session->set_flashdata('message', 'Report Sand Successfully');

          }
       }
    }
     function sendEmail($pdfFilePath,$emails,$report_name){
         
        

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

        foreach($emails as $email)
        {
           $mail->addAddress($email, '');
            // $mail->addAddress('dharamveersingh@lastingerp.com', '');
        }
        //$mail->addAddress('princy@lastingerp.com','');
        // $mail->addAddress($emails,'');
        // while (list ($key, $val) = each($email)) {
        //     pre($val); die;
        //       $email->addAddress($val);
        //   }
        $mail->isHTML(true);
        $mail->Body = $report_name;
        $mail->Subject = $report_name;
        $mail->addAttachment($pdfFilePath,'Inventory Reports','base64','application/pdf');
        $mail->send();
        if($mail->send()){
            redirect(base_url() . 'inventory/inventory_setting', 'refresh');
            $this->session->set_flashdata('message', 'Report Sand Successfully');


        }else{
            echo 'Mailer error: ' . $mail->ErrorInfo;
        }
    }

    public function editinventoryreportsetting() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['report_data'] = $this->inventory_model->get_data_byId('daily_report_setting', 'id', $id);
        $this->load->view('inventory_setting/edit_report_Inventory_setting', $this->data);
    }

    public function editlotmanagement() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['report_data'] = $this->inventory_model->get_data_byId('lot_details', 'id', $id);
        $this->load->view('inventory_setting/editlotmanagement', $this->data);
    }

    public function delete_reports($id = '') {
        if (!$id) {
            redirect('inventory/inventory_setting', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->inventory_model->delete_data('daily_report_setting', 'id', $id);
        if ($result) {
            logActivity('Report setting Deleted', 'material', $id);
            $this->session->set_flashdata('message', 'Report setting Deleted Successfully');
            $result = array('msg' => 'Report setting Deleted Successfully', 'status' => 'success', 'code' => 'C730', 'url' => base_url() . 'inventory/inventory_setting');
            echo json_encode($result);
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }

     public function saveinventorylots(){
        if ($this->input->post()) {
        $required_fields = array('lot_num');
        $is_valid = validate_fields($_POST, $required_fields);
        if (count($is_valid) > 0) {
            valid_fields($is_valid);
        } else {
            $data = $this->input->post();
            $data['created_date'] = date("Y-m-d h:i:sa");
            $data['created_by'] = $_SESSION['loggedInUser']->id;
            //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
            $data['created_by_cid'] = $this->companyId;
            $id = $data['id'];
            $usersWithViewPermissions = $this->inventory_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 95));
            // pre($data);
            // die('here');
            if ($id && $id != '') {
                $success = $this->inventory_model->update_data('lot_details', $data, 'id', $id);
                if ($success) {
                    $data['message'] = "Inventory Lot No. Updated";
                    logActivity('Inventory Lot No. Updated', 'Inventory lot', $id);
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                pushNotification(array('subject' => 'Inventory Lot Updated', 'message' => 'Inventory Lot Updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        pushNotification(array('subject' => 'Inventory Lot Updated', 'message' => 'Inventory Lot Updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id));
                    }
                    $this->session->set_flashdata('message', 'Inventory Lot Updated successfully');
                }
            } else {
                $id = $this->inventory_model->insert_tbl_data('lot_details', $data);
                if ($id) {
                    logActivity('New inventory Lot No. Created', 'Inventory lot No.', $id);
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                pushNotification(array('subject' => 'Inventory Lot created', 'message' => 'Inventory Lot created by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        pushNotification(array('subject' => 'Inventory lot created', 'message' => 'Inventory Lot No.created by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id));
                    }
                    $this->session->set_flashdata('message', 'New Inventory Lot No. created successfully', 'Inventory Lot No.');
                }
            }

            redirect(base_url() . 'inventory/inventory_setting', 'refresh');
        }
     }
    }

    public function change_status_lot() {
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status = (isset($_POST['lotStatus']) && $_POST['lotStatus'] == 1) ? '1' : '0';
        $status_data = $this->inventory_model->toggle_change_status_lot('lot_details', $id, $status);
        echo $status_data;
    }

    public function change_status_rm() {
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status = (isset($_POST['lotStatus']) && $_POST['lotStatus'] == 1) ? '1' : '0';
        $status_data = $this->inventory_model->toggle_change_status_lot('reserved_material',$id, $status);
        echo $status_data;
    }


    public function receiveandissue_report(){
        //$this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Receive & Issue Report', base_url() . 'inventory/receiveandissue_report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Receive & Issue Report';
        if(!empty($_POST)){
            //pre();die();
            $this->data['get_report_data'] = $this->inventory_model->get_data_report('inventory_flow', 'material_type_id', $_POST['material_type_id']);
        }else{
            $this->data['get_report_data'] = '';
        }
        $this->_render_template('receiveandissue_mat/index', $this->data);
    }


     public function saveWorkInProcessMaterial_request() {
       //s pre($this->input->post());die;
        if ($this->input->post()) {
            $required_fields = array('material_name');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();

                /* For Saving WIP in Json Format */
                $work_order_id_select = count(@$_POST['work_order_id_select']);
                if ($work_order_id_select > 0) {
                    $arr1            = array();
                    $in              = 1;
                    $i               = 0;

                    $work_order_id = $_POST['work_order_id_select'];
                    foreach ($work_order_id as $val) {

                        $material_name = count($_POST['material_name_' . $in . '']);
                        if ($material_name > 0)
                        {
                            $arr               = array();
                            $process_input_arr = array();
                            $p                 = 0;

                            while ($p < $material_name) {
                                $jsonArrayObject_input = (array(
                                    'sale_order_id' => $_POST['sale_order_id_' . $in . ''][$p]??'',
                                    'work_order_id' => $_POST['work_order_id_' . $in . ''][$p]??'',
                                    'material_type_id' => $_POST['material_type_id_' . $in . ''][$p]??'',
                                    'material_type_id_name' => $_POST['material_type_id_name_' . $in . ''][$p]??'',
                                    'material_id' => $_POST['material_name_' . $in . ''][$p]??'',
                                    'material_name_id' => $_POST['material_name_id_' . $in . ''][$p]??'',
                                    'quantity' => $_POST['qty_' . $in . ''][$p]??'',
                                    'uom' => $_POST['uom_' . $in . ''][$p]??'',
                                    'location' => $_POST['location_' . $in . ''][$p]??'',
                                    'lotname' => $_POST['lotname_' . $in . ''][$p]??'',
                                    'npdm' => $_POST['npdm_' . $in . ''][$p]??'',
                                    'machine_name' => $_POST['machine_name_' . $in . ''][$p]??'',
                                    'lot_id' => $_POST['lotno_' . $in . ''][$p],
                                    'required_quantity' => $_POST['required_quantity_' . $in . ''][$p]??'',
                                    'issued_quantity' => $_POST['issued_quantity_' . $in . ''][$p] + $_POST['qty_' . $in . ''][$p]
                                ));
                                $process_input_arr[]   = $jsonArrayObject_input;
                                $p++;
                            }

                            $material_input_dtl_array = json_encode($process_input_arr);
                        } else {
                            $material_input_dtl_array = '';
                        }

                        /* End Update Code For multiple Machine */
                        //  pre($machine_details_array);
                        $jsonArrayObject1 = (array(
                             'work_order_id_select' =>  $_POST['work_order_id_select'][$i],
                             'work_order_product' => $_POST['work_order_product'][$i],
                            'input_process' => $material_input_dtl_array
                        ));

                        $arr1[$i]         = $jsonArrayObject1;
                        $in++;
                        $i++;
                    }

                    $product_array = json_encode($arr1);
                } else {
                    $product_array = '';
                }

                $overQuantityMaterialData = array();
                if($arr){
                    foreach($arr as $detail){
                        $materialId         = $detail['material_id'];
                        $lot_idId           = $detail['lot_id'];
                        $quantityReq        = $detail['quantity'];
                        $work_order_id      = $detail['work_order_id'];

                        $issuedQuantity     = issuedMaterialQuantity($work_order_id, $materialId);
                        $workOrderDetails   = workOrderDetails($table='work_order',$work_order_id);
                        $productWorkOrderData       =   array();
                        if($workOrderDetails){
                            $productDetails = json_decode($workOrderDetails['product_detail'],true);
                            foreach($productDetails as $workOrderProduct){
                                $productWorkOrderData[] = array(
                                    'transfer_quantity' => $workOrderProduct['transfer_quantity'],
                                    'job_card'          => $workOrderProduct['job_card'],
                                    'material_id'       => $materialId
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
                                        if($materialId == $jobCardDetail['material_name_id']){
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

                        $requiredQuantity = 0;
                        if($jobCardMaterialData){
                            //~ $reQuantity       =  $jobCardMaterialData['transfer_quantity'] / $jobCardMaterialData['lot_qty'];
                            //~ $requiredQuantity =  $reQuantity * $jobCardMaterialData['quantity'];

                            $reQuantity       =  ($jobCardMaterialData['lot_qty'] != 0 ) ? $jobCardMaterialData['transfer_quantity'] / $jobCardMaterialData['lot_qty'] : 0;
                            $requiredQuantity = ($reQuantity > 0 ) ? $reQuantity * $jobCardMaterialData['quantity'] : $jobCardMaterialData['quantity'];
                        }
                        $requiredQuantity = 0;
                        if($jobCardMaterialData){
                            $reQuantity       =  $jobCardMaterialData['transfer_quantity'] / $jobCardMaterialData['lot_qty'];
                            $requiredQuantity =  $reQuantity * $jobCardMaterialData['quantity'];
                        }
                        $assignedQuantities = $issuedQuantity + $quantityReq;
                        if($assignedQuantities > $requiredQuantity){
                            $materialDetail = $this->inventory_model->getMaterialInfo('material', 'id', $materialId);
                           // pre($materialDetail);
                            //$overQuantityMaterialData .= 'The required quanity for '.$materialDetail['material_name']. ' is '.$requiredQuantity.'. ';
                           $overQuantityMaterialData[] = array(
                                'material_name'     => $materialDetail['material_name'],
                                'material_id'       => $materialId,
                                'required_quantity' => $requiredQuantity,
                                'issued_quantity'   => $issuedQuantity,
                            );

                        }
                    }

                }
                //if($overQuantityMaterialData){
                    //$table = '<table class="table table-bordered"><thead><tr><th>Material Name</th><th>Required Quantity</th><th>Issued Quantity</th></tr></thead><tbody>';
                    //~ foreach($overQuantityMaterialData as $information){
                        //~ $table .='<tr><td>'.$information['material_name'].'</td><td>'.$information['required_quantity'].'</td><td>'.$information['issued_quantity'].'</td>';
                    //~ }
                    //~ $table .='</tbody></table>';
                    //echo $table; die();
                    //~ $output = ['data' => $overQuantityMaterialData,'status'=>true];
                    //~ echo json_encode($output);
                    //~ die();
                //~ }

                $data['mat_detail'] = $product_array;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyId;

                $success = $this->inventory_model->insert_tbl_data('wip_request', $data);
                /* For Saving WIP in Json Format */
                $data['message'] = "Material issue Request logged successfully";
                logActivity('Work in process request', 'work_in_process_material', $success);
                $this->session->set_flashdata('message', 'Material issue Request logged successfully');
                $usersWithViewPermissions = $this->inventory_model->get_dataw('permissions', array('is_view' => 1, 'sub_module_id' => 7));
                if (!empty($usersWithViewPermissions)){
                foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                 pushNotification(array('subject' => 'Material issue Request logged', 'message' => 'Material issue Request logged Created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $userViewPermission['user_id'], 'to_id' => $userViewPermission['user_id'], 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                }
                }
                }
                if ($_SESSION['loggedInUser']->role != 1){
                    pushNotification(array('subject' => 'Material issue Request logged', 'message' => 'Material issue Request logged Created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                }
                pushNotification(array('subject' => 'Material issue Request logged', 'message' => 'Material issue Request logged Created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'class' => 'inventory_tabs', 'data_id' => 'material_view', 'icon' => 'fa fa-paper-plane-o'));
                $email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
                <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi Test</p>
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Material issue Request logged successfully.</p>
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>
                </td>
                </tr>
                </table>
                </td>
                </tr>';
                //send_mail_notification($_SESSION['loggedInUser']->email, 'Notification Email For Material issue Request logged', $email_message);
                if($_SESSION['loggedInUser']->c_id){
                $select = "email";
                $where = 'c_id='.$_SESSION['loggedInUser']->c_id.' AND role=1';

                $get_admin = $this->inventory_model->admin_email_data('user',$select, $where);
                foreach ($get_admin as $key => $value) {
                //send_mail_notification($value['email'], 'Notification Email For Material issue Request logged', $email_message);
                }}

                $output = ['insert'=>true];
                json_encode($output);

                redirect(base_url() . 'inventory/work_in_process', 'refresh');
            }
        }
    }





     public function UpdateInProcessMaterial_request() {
           $id=$_POST['id'];
        if ($id) {
            $required_fields = array('material_type');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                /* For Saving WIP in Json Format */
               //  $products = count($_POST['material_name']);
               // if ($products > 0) {
               //      $arr = [];
               //      $i = 0;
               //      while ($i < $products) {
               //         $jsonArrayObject = array('sale_order_id' => $_POST['sale_order_id'][$i], 'work_order_id' => $_POST['work_order_id'][$i], 'material_type_id' => $_POST['material_type_id'][$i], 'material_type_id_name' => $_POST['material_type_id_name'][$i], 'material_status' => 'WIP', 'material_id' => $_POST['material_name'][$i], 'material_name_id' => $_POST['material_name_id'][$i], 'quantity' => $_POST['qty'][$i], 'uom' => $_POST['uom'][$i], 'location' => $_POST['location'][$i] ,'lotname' => $_POST['lotname'][$i] ,'npdm' => $_POST['npdm'][$i] ,'machine_name' => $_POST['machine_name'][$i] ,'lot_id' => $_POST['lotno'][$i],'lotname' => $_POST['lotname'][$i],'required_quantity' => $_POST['required_quantity'][$i],'issued_quantity' => $_POST['issued_quantity'][$i]);
               //          $arr[$i] = $jsonArrayObject;
               //          $i++;
               //      }
               //      $product_array = json_encode($arr);
               //  } else {
               //      $product_array = '';
               //  }

     $work_order_id_select = count(@$_POST['work_order_id_select']);
        if ($work_order_id_select > 0) {
            $arr1            = array();
            $in              = 1;
            $i               = 0;
             $work_order_id = $_POST['work_order_id_select'];

            foreach ($work_order_id as $val) {
                $material_name = count($_POST['material_name_' . $in . '']);

                  if ($material_name > 0) {
                    $arr               = array();
                    $process_input_arr = array();
                    $p                 = 0;
                  while ($p < $material_name) {
                        $jsonArrayObject_input = (array(
                            'sale_order_id' => $_POST['sale_order_id_' . $in . ''][$p],
                            'work_order_id' => $_POST['work_order_id_' . $in . ''][$p],
                            'material_type_id' => $_POST['material_type_id_' . $in . ''][$p],
                            'material_type_id_name' => $_POST['material_type_id_name_' . $in . ''][$p],
                            'material_id' => $_POST['material_name_' . $in . ''][$p],
                            'material_name_id' => $_POST['material_name_id_' . $in . ''][$p],
                            'quantity' => $_POST['qty_' . $in . ''][$p],
                            'uom' => $_POST['uom_' . $in . ''][$p],
                            'location' => $_POST['location_' . $in . ''][$p],
                            'lotname' => $_POST['lotname_' . $in . ''][$p],
                            'npdm' => $_POST['npdm_' . $in . ''][$p],
                            'machine_name' => $_POST['machine_name_' . $in . ''][$p],
                            'lot_id' => $_POST['lotno_' . $in . ''][$p],
                            'required_quantity' => $_POST['required_quantity_' . $in . ''][$p],
                            'issued_quantity' => $_POST['issued_quantity_' . $in . ''][$p]
                        ));
                        $process_input_arr[]   = $jsonArrayObject_input;
                        $p++;

                    }

                    $material_input_dtl_array = json_encode($process_input_arr);
                } else {
                    $material_input_dtl_array = '';
                }



                /* End Update Code For multiple Machine */
                //  pre($machine_details_array);
                $jsonArrayObject1 = (array(
                     'work_order_id_select' =>  $_POST['work_order_id_select'][$i],
                     'work_order_product' => $_POST['work_order_product'][$i],
                    'input_process' => $material_input_dtl_array
                ));

                $arr1[$i]         = $jsonArrayObject1;
                $in++;
                $i++;
            }

            $product_array = json_encode($arr1);
          } else {
            $product_array = '';
        }


                $overQuantityMaterialData = array();

                if($arr){
                    foreach($arr as $detail){

                        $materialId         = $detail['material_id'];
                        $lot_idId           = $detail['lot_id'];
                        $quantityReq        = $detail['quantity'];
                        $work_order_id      = $detail['work_order_id'];
                        $issuedQuantity     = issuedMaterialQuantity($work_order_id, $materialId);
                        $workOrderDetails   = workOrderDetails($table='work_order',$work_order_id);
                        $productWorkOrderData       =   array();
                        if($workOrderDetails){
                            $productDetails = json_decode($workOrderDetails['product_detail'],true);
                            foreach($productDetails as $workOrderProduct){
                                $productWorkOrderData[] = array(
                                    'transfer_quantity' => $workOrderProduct['transfer_quantity'],
                                    'job_card'          => $workOrderProduct['job_card'],
                                    'material_id'       => $materialId
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
                                        if($materialId == $jobCardDetail['material_name_id']){
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

                        $requiredQuantity = 0;
                        if($jobCardMaterialData){
                            //~ $reQuantity       =  $jobCardMaterialData['transfer_quantity'] / $jobCardMaterialData['lot_qty'];
                            //~ $requiredQuantity =  $reQuantity * $jobCardMaterialData['quantity'];

                            $reQuantity       =  ($jobCardMaterialData['lot_qty'] != 0 ) ? $jobCardMaterialData['transfer_quantity'] / $jobCardMaterialData['lot_qty'] : 0;
                            $requiredQuantity = ($reQuantity > 0 ) ? $reQuantity * $jobCardMaterialData['quantity'] : $jobCardMaterialData['quantity'];
                        }
                        $requiredQuantity = 0;
                        if($jobCardMaterialData){
                            $reQuantity       =  $jobCardMaterialData['transfer_quantity'] / $jobCardMaterialData['lot_qty'];
                            $requiredQuantity =  $reQuantity * $jobCardMaterialData['quantity'];
                        }
                        $assignedQuantities = $issuedQuantity + $quantityReq;
                        if($assignedQuantities > $requiredQuantity){
                            $materialDetail = $this->inventory_model->getMaterialInfo('material', 'id', $materialId);
                           // pre($materialDetail);
                            //$overQuantityMaterialData .= 'The required quanity for '.$materialDetail['material_name']. ' is '.$requiredQuantity.'. ';
                           $overQuantityMaterialData[] = array(
                                'material_name'     => $materialDetail['material_name'],
                                'material_id'       => $materialId,
                                'required_quantity' => $requiredQuantity,
                                'issued_quantity'   => $issuedQuantity,
                            );

                        }
                    }

                }

                $data['mat_detail'] = $product_array;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyId;

                  $success = $this->inventory_model->update_wip_request('wip_request', $data, 'id', $id);
                /* For Saving WIP in Json Format */
                $data['message'] = "Material issue Request logged successfully";
                logActivity('Work in process request', 'work_in_process_material', $success);
                $this->session->set_flashdata('message', 'Material issue Request logged successfully');
                $output = ['insert'=>true];
                json_encode($output);

                redirect(base_url() . 'inventory/work_in_process', 'refresh');
            }
        }
    }



    /*get address from mat_location through issue rm page */
    function getStorageArea(){
        $location_id = $_POST['location_id'];
        $material_type_id = $_POST['material_type_id'];
        $materialId = $_POST['materialId'];

        $getAreaRackNumber = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $materialId, 'material_type_id' => $material_type_id, 'location_id' => $location_id));

        $AreaArray = array();
        $i = 0;
        foreach($getAreaRackNumber as $area){
            $AreaArray[$i]['id'] = $area['Storage'];
            $i++;
        }
        $AreaArray = array_values( array_unique($AreaArray, SORT_REGULAR ) );
        echo json_encode($AreaArray);
    }

    /*get rackNumber from mat_location through issue rm page */
    function getRackNumber() {
        $location_id = $_POST['location_id'];
        $material_type_id = $_POST['material_type_id'];
        $materialId = $_POST['materialId'];
        $storage = $_POST['storage'];

        $getAreaRackNumber = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $materialId, 'material_type_id' => $material_type_id, 'location_id' => $location_id,'Storage' => $storage));

        $rackArray = array();
        $j = 0;
        if(!empty($storage)){
            foreach($getAreaRackNumber as $rack){
                $rackArray[$j]['rack'] = $rack['RackNumber'];
                $j++;
            }
        }
        $rackArray = array_values( array_unique($rackArray, SORT_REGULAR ) );
        echo json_encode($rackArray);
    }

    public function issue_rm_material() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('RM Request List', base_url() . 'RM Request List');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'RM Request List';
        #$whereCompany = "(id ='".$_SESSION['loggedInUser']->c_id."')";
        $whereCompany = "(id ='" . $this->companyId . "')";
        $this->data['company_unit_adress'] = $this->inventory_model->get_filter_details('company_detail', $whereCompany);
        /*if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '') {
         }else*/
         $where= array('created_by_cid' => $this->companyId);
         if(!empty($_GET) && isset($_GET['start']) && isset($_GET['end']) && isset($_GET['company_unit'])== '') {
           $where = "created_by_cid = " . $this->companyId . " AND  (created_date >='" . $_GET['start'] . "' AND  created_date <='" . $_GET['end'] . "')";
        } elseif (!empty($_GET) && !empty($_GET['company_unit']) && $_GET['start'] != '' && $_GET['end'] != '') {
            $where = "created_by_cid = " . $this->companyId . " AND  (created_date >='" . $_GET['start'] . "' AND  created_date <='" . $_GET['end'] . "')";
        }

        if(isset($_GET['company_unit'])!='')
        {
            $json_dtl ='{"location" : "'.$_GET['company_unit'].'"}';
            $where= "wip_request.mat_detail!='' && json_contains(`mat_detail`, '".$json_dtl."')" ;
        }
        if(isset($_GET['ExportType'])!='' && $_GET['start']=='' && $_GET['end']=='' && $_GET['company_unit']=='')
        {$where= array('created_by_cid' => $this->companyId);
    }elseif(isset($_GET['ExportType'])!='' && $_GET['start']!='' && $_GET['end']!='' && $_GET['company_unit']=='')
    {
          $where = "created_by_cid = " . $this->companyId . " AND  (created_date >='" . $_GET['start'] . "' AND  created_date <='" . $_GET['end'] . "')";
    }elseif(isset($_GET['ExportType'])!='' && $_GET['start']!='' && $_GET['end']!='' && $_GET['company_unit']!=''){
        $json_dtl ='{"location" : "'.$_GET['company_unit'].'"}';
            $where= "wip_request.mat_detail!='' && json_contains(`mat_detail`, '".$json_dtl."')" ;
    }
        //Search
        $where2 = '';
        $search_string = '';
        if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $materialName=getNameById('material',$search_string,'material_name');
            $material_type_tt = getNameById('material_type',$search_string,'name');
        if($material_type_tt->id !=''){
                $json_dtl ='{"material_type_id" : "'.$material_type_tt->id.'"}';
                $where2 = "wip_request.mat_detail!='' && json_contains(`material_type_id`, '".$json_dtl."')" ;
            }elseif($materialName->id != '' && $material_type_tt->id ==''){
                $json_dtl ='{"material_id" : "'.$materialName->id.'"}';
                $where2 = "wip_request.mat_detail!='' && json_contains(`material_id`, '".$json_dtl."')" ;
            }else{
            $where2 = " wip_request.id = '" . $search_string . "'";
            }
            redirect("inventory/work_in_process/?search=$search_string");
        } elseif(isset($_GET['search']) && $_GET['search']!='') {
            $materialName=getNameBySearch('material',$_GET['search'],'material_name');
            $material_type_tt = getNameBySearch('material_type',$_GET['search'],'name');
             $where2=array("wip_request.id ='" . $_GET['search'] . "'");
            foreach($materialName as $materialname){//pre($name['id']);
                $json_dtl ='{"material_id" : "'.$materialname['id'].'"}';
               $where2[]="wip_request.mat_detail!='' && json_contains(`mat_detail`, '".$json_dtl."')" ;
            }
            foreach($material_type_tt as $materialtype){//pre($name['id']);
                $json_dtl ='{"material_type_id" : "'.$materialtype['id'].'"}';
               $where2[]="wip_request.mat_detail!='' && json_contains(`mat_detail`, '".$json_dtl."')" ;
            }
            //pre($where2);
            if(sizeof($where2) !=''){
            $where2=implode("||",$where2);
            }else{
            $where2="wip_request.id ='" . $_GET['search'] . "'";
            }
            //pre($where2);
            /*if(isset($material_type_tt['id'])!=''){
                foreach($material_type_tt as $name){
                $json_dtl ='{"material_type_id" : "'.$name['id'].'"}';
                $where2 = "wip_request.mat_detail!='' && json_contains(`mat_detail`, '".$json_dtl."') || wip_request.id ='" . $_GET['search'] . "'" ;
                }}else{
                $where2="wip_request.id ='" . $_GET['search'] . "'";
            }*/
            }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "inventory/issue_rm_material";
        $config["total_rows"] = $this->inventory_model->num_rows('wip_request',$where, $where2);
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
        $this->data['material_issue'] = $this->inventory_model->get_data1('wip_request', $where, $config["per_page"], $page, $where2, $order,$export_data); //get WIP in Work in process Tab
            if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }

       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
       }
        if($end>$config['total_rows'])
        {
        $total=$config['total_rows'];
        }else{
        $total=$end;
        }
        $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
        $this->_render_template('wip_request/index', $this->data);
    }

    public function wip_dispatch() {
        $this->data['materialissue'] = $this->inventory_model->get_data_byId('wip_request', 'id', $this->input->post('id'));
        $this->load->view('wip_request/issued_wip', $this->data);
    }
    public function wip_requestMatDetail() {
    $this->data['materialissue'] = $this->inventory_model->get_data_byId('wip_request', 'id', $this->input->post('id'));
    $this->load->view('wip_request/viewMat', $this->data);
    }

    public function lot_report(){
        //$this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Lot Report', base_url() . 'inventory/lot_report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Lot Report';
        $where = array('lot_details.created_by_cid' => $this->companyId);
        $this->data['lot_details'] = $this->inventory_model->get_data('lot_details', $where);
        $this->_render_template('lot_report/index', $this->data);
    }

    public function view_lot_report(){
        //$this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Lot Report', base_url() . 'inventory/lot_report');
        $id = $_GET['id'];
        permissions_redirect('is_view');
        $where = "mat_id = '".$id."' AND lot_details.created_by_cid =".$this->companyId;
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Lot Report';
        #$where = array('lot_details.created_by_cid' => $this->companyId);
        $this->data['lot_details'] = $this->inventory_model->get_data('lot_details', $where);
        $this->_render_template('inventory_listing_and_adjustment/view_lot_report', $this->data);
    }

    public function reserved_material(){
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Reserved Material', base_url() . 'inventory/Reserved Material');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Reserved Material';
        $where = array('reserved_material.created_by_cid' => $this->companyId);
        $this->data['reserved_material'] = $this->inventory_model->get_data('reserved_material', $where);
        $this->_render_template('reserved_material/index', $this->data);
    }
    public function edit_reservedmaterial() {
        $id = isset($_POST['id']) ? $_POST['id']:'';
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['reserved_mat'] = $this->inventory_model->get_data_byId('reserved_material', 'id', $id);
        $this->load->view('reserved_material/edit', $this->data);
    }

    public function save_reserved_material(){
        $data = $this->input->post();
        $id = $data['id'];
        $data['customer_id'] = implode("", $data['customer_type']);
        $data['material_type'] = implode("", $data['material_type_id']);
        $data['mayerial_id'] = implode("", $data['material_name']);
        $data['quantity'] = implode("", $data['quantityn']);
        $data['created_by_cid'] = $this->companyId;
        $data['created_by'] = $_SESSION['loggedInUser']->u_id;
        $usersWithViewPermissions = $this->inventory_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 13));
        if ($id && $id != '') {
            $success = $this->inventory_model->update_data('reserved_material', $data, 'id', $id);
            if ($success) {
                $data['message'] = "Material Reserved updated successfully";
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            /*pushNotification(array('subject'=> 'Customer type updated' , 'message' => 'Customer type updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Material Reserved updated', 'message' => 'Material Reserved id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $userViewPermission['user_id'], 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Material Reserved updated', 'message' => 'Material Reserved id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
               }
               pushNotification(array('subject' => 'Material Reserved updated', 'message' => 'Material Reserved id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));

                #die;
                $email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
                <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi Test</p>
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Material Reserved Updated successfully.</p>
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>
                </td>
                </tr>
                </table>
                </td>
                </tr>';
                //send_mail_notification($_SESSION['loggedInUser']->email, 'Notification Email For Material Reserved', $email_message);
                if($_SESSION['loggedInUser']->c_id){
                $select = "email";
                $where = 'c_id='.$_SESSION['loggedInUser']->c_id.' AND role=1';
                $get_admin = $this->inventory_model->admin_email_data('user',$select, $where);
                foreach ($get_admin as $key => $value) {
                //send_mail_notification($value['email'], 'Notification Email For Material Reserved', $email_message);
                } }
                logActivity('Reserved Material Updated', 'process_type', $id);
                $this->session->set_flashdata('message', 'Material Reserved Updated successfully');
                redirect(base_url() . 'inventory/reserved_material', 'refresh');
            }
        } else {
            $counts = count($_POST['customer_type']);
            //$id= $data['id'];
            $data2 = date("Y-m-d h:i:sa");
            //$data1 = $_SESSION['loggedInUser']->c_id ;
            $data1 = $this->companyId;
            $data3 = $_SESSION['loggedInUser']->u_id;
            $usersWithViewPermissions = $this->inventory_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 13));
            $data = $this->input->post();
            $process_name_arr = array();
            $j = 0;
            while ($j < $counts) {
                $process_name_arr[$j]['customer_id'] = $_POST['customer_type'][$j];
                $process_name_arr[$j]['material_type'] = $_POST['material_type_id'][$j];
                $process_name_arr[$j]['mayerial_id'] = $_POST['material_name'][$j];
                $process_name_arr[$j]['quantity'] = $_POST['quantityn'][$j];
                $process_name_arr[$j]['created_by'] = $_SESSION['loggedInUser']->u_id;
                $process_name_arr[$j]['created_by_cid'] = $this->companyId;
                $j++;
            }
            $id = $this->inventory_model->insertcustomertype('reserved_material', $process_name_arr);
            if($id){
               logActivity('Reserved material Inserted', 'reserved_material', $id);
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array('subject' => 'Material reserved Inserted', 'message' => 'New material is reserved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $userViewPermission['user_id'], 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Material reserved Inserted', 'message' => 'New material is reserved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                }
                pushNotification(array('subject' => 'Material reserved Inserted', 'message' => 'New material is reserved by ' . $_SESSION['loggedInUser']->name, 'from_id' =>$_SESSION['loggedInCompany']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'icon' => 'fa fa-shekel'));
                $email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
                <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi Test</p>
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Material Reserved inserted successfully.</p>
                <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>
                </td>
                </tr>
                </table>
                </td>
                </tr>';
                //send_mail_notification($_SESSION['loggedInUser']->email, 'Notification Email For Material Reserved', $email_message);
                if($_SESSION['loggedInUser']->c_id){
                $select = "email";
                $where = 'c_id='.$_SESSION['loggedInUser']->c_id.' AND role=1';
                $get_admin = $this->inventory_model->admin_email_data('user',$select, $where);
                foreach ($get_admin as $key => $value) {
                //send_mail_notification($value['email'], 'Notification Email For Material Reserved', $email_message);
                } }
                $this->session->set_flashdata('message', 'Material Reserved inserted successfully');
                redirect(base_url() . 'inventory/reserved_material', 'refresh');
            }
        }
    }

    public function mat_availbility(){
            //$this->load->library('pagination');
            $this->data['can_edit'] = edit_permissions();
            $this->data['can_delete'] = delete_permissions();
            $this->data['can_add'] = add_permissions();
            $this->data['can_view'] = view_permissions();
            $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
            $this->breadcrumb->add('Material Availability', base_url() . 'inventory/lot_report');
            $id = $_GET['id'];
            permissions_redirect('is_view');
            $where = "mayerial_id = '".$id."' AND reserved_material.created_by_cid =".$this->companyId;
            $this->settings['breadcrumbs'] = $this->breadcrumb->output();
            $this->settings['pageTitle'] = 'Material Availability';
            $this->data['reserved_material'] = $this->inventory_model->get_data('reserved_material', $where);
            $this->_render_template('inventory_listing_and_adjustment/mat_availability', $this->data);
    }

    public function change_status_mat_loc() {
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status = (isset($_POST['gstatus']) && $_POST['gstatus'] == 1) ? '1' : '0';
        $status_data = $this->inventory_model->change_status_mat_loc($id, $status);
        echo json_encode($status_data);
    }

    public function single_line_report(){
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Inventory Report', base_url() . 'inventory/Stock Report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Report';
        $where = 'material.created_by_cid = " '. $this->companyId . '" ORDER BY id DESC ';
        #$where = array('material.created_by_cid' => $this->companyId);
        $this->data['materials'] = $this->inventory_model->get_data('material', $where);
        $this->_render_template('single_line_report/index', $this->data);
    }

    public function view_loc_report(){
            //$this->load->library('pagination');
            $this->data['can_edit'] = edit_permissions();
            $this->data['can_delete'] = delete_permissions();
            $this->data['can_add'] = add_permissions();
            $this->data['can_view'] = view_permissions();
            $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
            $this->breadcrumb->add('Location vise Report', base_url() . 'inventory/view_loc_report');
            $id = $_GET['id'];
            permissions_redirect('is_view');
            $where = "material_name_id = '".$id."' AND mat_locations.created_by_cid =".$this->companyId;
            $this->settings['breadcrumbs'] = $this->breadcrumb->output();
            $this->settings['pageTitle'] = 'Material Availability';
            $this->data['loc_reports'] = $this->inventory_model->get_data('mat_locations', $where);
           # pre($this->data['reserved_material']);die;
            $this->_render_template('single_line_report/view_report', $this->data);
    }

    public function getMaterialDataBysku() {
        if ($_POST['sku'] != '') {
            #pre($_POST['sku']);
            $material = $this->inventory_model->get_data_byId('material', 'mat_sku', $_POST['sku']);
            //pre($material);
            if(!empty($material)){
            $ww = getNameById('uom', $material->uom, 'id');
            $material->uom = $ww->ugc_code;
            $mt1 = getNameById('material_type', $material->material_type_id, 'id');
            $material->material_type_name = $mt1->name;

            echo json_encode($material);
            }else{
            }
        }
    }

    // public function change_status_uom() {
    //     $id = (isset($_POST['id'])) ? $_POST['id'] : '';
    //     $status = (isset($_POST['gstatus']) && $_POST['gstatus'] == 1) ? '1' : '0';
    //     $status_data = $this->inventory_model->change_status_toggle($id, $status);
    //     echo json_encode($status_data);
    // }

    public function stock_report(){
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Reserved Material', base_url() . 'inventory/Stock Report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Stock In Hand';
        $where = array('material.created_by_cid' => $this->companyId);
        $this->data['materials'] = $this->inventory_model->get_data('material', $where);
        $this->_render_template('stock_report/index', $this->data);
    }

    public function savetagtypes() {
        $data = $this->input->post();
        $id = $data['id'];
        $data['tag_types'] = implode("", $data['tag_types']);
        //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
        $data['created_by_cid'] = $this->companyId;
        $data['created_by'] = $_SESSION['loggedInUser']->u_id;
        if ($id && $id != '') {
            $success = $this->inventory_model->update_data('tag_types', $data, 'id', $id);
            if ($success) {
                $data['message'] = "Tag Type Updated successfully";
                logActivity('Tag Type Updated', 'tag_type', $id);
                $this->session->set_flashdata('message', 'Tag Type Updated successfully');
                redirect(base_url() . 'inventory/inventory_setting', 'refresh');
            }
        } else {
            $counts = count($_POST['tag_types']);
            //$id= $data['id'];
            $data2 = date("Y-m-d h:i:sa");
            //$data1 = $_SESSION['loggedInUser']->c_id ;
            $data1 = $this->companyId;
            $data3 = $_SESSION['loggedInUser']->u_id;
            $data = $this->input->post();
            $process_name_arr = array();
            $j = 0;
            while ($j < $counts) {
                $process_name_arr[$j]['tag_types'] = $_POST['tag_types'][$j];
                $process_name_arr[$j]['created_date'] = $data2;
                $process_name_arr[$j]['created_by_cid'] = $data1;
                $process_name_arr[$j]['created_by'] = $data3;
                $j++;
            }
            $id = $this->inventory_model->insertcustomertype('tag_types', $process_name_arr);
            if ($id) {
                $this->session->set_flashdata('message', 'Industry Added Successfully');
                redirect(base_url() . 'inventory/inventory_setting', 'refresh');
            }
        }
    }

    public function tag_type_edit(){

        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['tag_types'] = $this->inventory_model->get_data_byId('tag_types', 'id', $this->input->post('id'));
        #pre($this->data['account']);
        $this->load->view('inventory_setting/tag_type_edit', $this->data);

    }

    public function change_status_tag_types() {
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status = (isset($_POST['uomStatus']) && $_POST['uomStatus'] == 1) ? '1' : '0';
        $status_data = $this->inventory_model->toggle_change_tagtypes_status($id, $status);
        echo $status_data;
    }

    public function savetag() {
        $data = $this->input->post();
        $id = $data['id'];
        $data['tag_name'] = implode("", $data['tag_names']);
        $data['tag_id'] = $_POST['tag_id'];
        //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
        $data['created_by_cid'] = $this->companyId;
        $data['created_by'] = $_SESSION['loggedInUser']->u_id;
        if ($id && $id != '') {
            $success = $this->inventory_model->update_data('tag_details', $data, 'id', $id);
            if ($success) {
                $data['message'] = "Tag Details Updated successfully";
                logActivity('Tag Details Updated', 'tag_details', $id);
                $this->session->set_flashdata('message', 'Tag Details Updated successfully');
                redirect(base_url() . 'inventory/inventory_setting', 'refresh');
            }
        } else {
            $counts = count($_POST['tag_names']);
            //$id= $data['id'];
            $data2 = date("Y-m-d h:i:sa");
            //$data1 = $_SESSION['loggedInUser']->c_id ;
            $data1 = $this->companyId;
            $data3 = $_SESSION['loggedInUser']->u_id;
            $data = $this->input->post();
            $process_name_arr = array();
            $j = 0;
            while ($j < $counts) {
                $process_name_arr[$j]['tag_id'] = $data['tag_id'];
                $process_name_arr[$j]['tag_name'] = $_POST['tag_names'][$j];
                $process_name_arr[$j]['created_date'] = $data2;
                $process_name_arr[$j]['created_by_cid'] = $data1;
                $process_name_arr[$j]['created_by'] = $data3;
                $j++;
            }
            $id = $this->inventory_model->insertcustomertype('tag_details', $process_name_arr);
           # die;
            if ($id) {
                $this->session->set_flashdata('message', 'Tag Details Successfully');
                redirect(base_url() . 'inventory/inventory_setting', 'refresh');
            }
        }
    }

    public function change_status_tag_details() {
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status = (isset($_POST['uomStatus']) && $_POST['uomStatus'] == 1) ? '1' : '0';
        $status_data = $this->inventory_model->toggle_change_tagdetails_status($id, $status);
        echo $status_data;
    }

    public function tag_details_edit(){

        if ($this->input->post('id') != ''){
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['tag_types'] = $this->inventory_model->get_data_byId('tag_types', 'id', $this->input->post('id'));
        #pre($this->data['account']);
        $this->load->view('inventory_setting/tag_details_edit', $this->data);

    }

    /*delete mat location records*/
    public function deleteMatLocation()
    {
        if($_POST['id'] && $_POST['id'] != ''){
            $result = $this->inventory_model->get_data('mat_locations', array('id' => $_POST['id']));
            if(!empty($result)){
                $inventoryFlowDataArray = array();
                foreach($result as $rows){
                    $materialId = $rows['material_name_id'];
                    $material_type = $rows['material_type_id'];
                    $quantity = $rows['quantity'];

                    $yu = getNameById_mat('mat_locations',$materialId,'material_name_id');
                    $sum = 0;
                    if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                    $closing_blnc = $sum - $quantity;

                    $arr =  json_encode(array(array('location' => $rows['location_id'],'Storage' => $rows['Storage'], 'RackNumber' => $rows['RackNumber'], 'quantity' => $rows['quantity'], 'Qtyuom' => $rows['Qtyuom'])));
                    $inventoryFlowDataArray['material_out'] = $quantity;
                    $inventoryFlowDataArray['opening_blnc'] = $sum;
                    $inventoryFlowDataArray['closing_blnc'] = $closing_blnc;
                    $inventoryFlowDataArray['ref_id'] = $rows['id'];
                    $inventoryFlowDataArray['through'] = 'Location Deleted - Edit Material';
                    $inventoryFlowDataArray['current_location'] = $arr;
                    $inventoryFlowDataArray['material_type_id'] = $material_type;
                    $inventoryFlowDataArray['material_id'] = $materialId;
                    $inventoryFlowDataArray['uom'] = $rows['Qtyuom'];
                    $inventoryFlowDataArray['created_by'] = isset($_SESSION['loggedInUser']->id) ? $_SESSION['loggedInUser']->id:0;
                    $inventoryFlowDataArray['created_by_cid'] = $this->companyId;
                    $insert = $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);

                    #Update lot materials
                    $this->material_Lot_inOut($materialId);
                }
            }
            $success = $this->inventory_model->delete_data('mat_locations', 'id', $_POST['id']);
            if($success){
                $msg = 'Location deleted successfully';
                logActivity($msg, 'mat_locations', $_POST['id']);
                $this->session->set_flashdata('message', $msg);
                echo json_encode(array(
                    'msg' => $msg,
                    'status' => 'success',
                ));
                die;
            } else {
                echo json_encode(array(
                    'msg' => 'error',
                    'status' => 'error',
                ));
            }
        }
    }

    /* New Inventory Listing and adjustment */
	public function inventory_listing_and_adjustment_new(){

        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Inventory Listing', base_url() . 'inventory_listing');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'New inventory listing and adjustment';

       
         $where_mt = "material_type.created_by_cid = " . $this->companyId . " OR material_type.created_by_cid = 0";
        // $this->data['type2'] = $this->inventory_model->get_data('material_type', $where_mt);

        $where_thrd_type = 'thrd_party_invtry.created_by_cid = " '. $this->companyId . '" ORDER BY id DESC ';
        $this->data['third_invt_type_data'] = $this->inventory_model->get_data('thrd_party_invtry', $where_thrd_type);

       

		#==============================New Inventory Listing Part===================================
		# Company address (location)
		$where_ca = "company_address.created_by_cid = " . $this->companyId . " OR company_address.created_by_cid = 0";
        $this->data['company_address'] = $this->inventory_model->get_data('company_address', $where_ca);
		
		
		 

		$where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1, 'material.status' => 1);
		# Ajax - Location based search query
		if(!empty($_POST['location_id'])){
			$location_id = $_POST['location_id'];
			$where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1,'material.status' => 1, 'mat_locations.location_id' => $location_id);
			if($location_id == 0){
				$where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1, 'material.status' => 1);
			}
		}
		
		
		# Ajax - Date based search query
		if(!empty($_POST['sdate'])){
			$date = date('Y-m-d', strtotime($_POST['sdate']));
			$where = "material.created_by_cid = " . $this->companyId . " AND material.save_status = 1 AND material.status = 1 AND  material.created_date BETWEEN '" . $date . " 00:00:01' and '".$date." 23:59:59'";
			if(!empty($_POST['location_id']) && $_POST['location_id'] != 0){
				$where .= " and mat_locations.location_id = '".$_POST['location_id']."'";
			}
		}
		$MaterailListingData = $this->inventory_model->get_data_fromMaterial('material', $where);
// pre($MaterailListingData);die('sdf');
		# Ajax - Location based data filteration
		$MaterailListingData_new = array();
		if(!empty($_POST['location_id']) && $_POST['location_id'] != 0){
			foreach($MaterailListingData as $mid => $mld){
				$temp = array();
				if(!empty($mld['location'])){
					$MaterailListingData_new[$mid] = $mld;
					foreach($mld['location'] as $loc){
						if($loc['location'] == $_POST['location_id']){
							$temp[] = $loc;
							$MaterailListingData_new[$mid]['location'] = $temp;
						}
					}
				}
			}
		}
		$this->data['materailListingData'] = !empty($MaterailListingData_new) ? $MaterailListingData_new : $MaterailListingData;

		# Export
		if(isset($_POST['export']) && $_POST['export'] == 'exportInventoryList'){
			$output = [];
			if(!empty($MaterailListingData)){
				foreach($MaterailListingData as $rows){
					$getuom = getNameById('uom', $rows['uom'], 'id');
					$uom = !empty($getuom) ? $getuom->ugc_code : '';
					$sum = 0;
					foreach ($rows['location'] as $ert) {
						$sum+= $ert['qty'];
					}
					$output[] = array('Material Name' => $rows['material_name'], 'Material Type' => $rows['material_type_name'], 'Material Sub Type' => $rows['sub_type'], 'Quantity' => $sum, 'UOM' => $uom);
				}
			}
			if(!empty($output)){
				$filename = "Inventory_List.xls";
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				ExportFile($output);
			}
		}

		# Redirect view
        if (!empty($_POST['ajax_var']) && $_POST['ajax_var'] == 'via_ajax'){
            $a = $this->load->view('inventory_listing_and_adjustment/new_inventory_listing', $this->data);
            return $a;
        } elseif (!empty($_POST['ajax_var']) && $_POST['ajax_var'] == 'via_ajaxwip'){
            $a = $this->load->view('inventory_listing_and_adjustment/ajax_matwip', $this->data);
            return $a;
        } else {
            $this->_render_template('inventory_listing_and_adjustment/new_index', $this->data);
        }
    }
	public function inventory_listing_and_adjustment_newbakup15072022(){

        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Inventory Listing', base_url() . 'inventory_listing');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'New inventory listing and adjustment';

        /* if (!empty($_POST) && isset($_POST['start']) && isset($_POST['end']) && $_POST['company_unit'] == '') {
            $where = "material.created_by_cid = " . $this->companyId . " AND (material.save_status = 1 ) AND  (material.created_date >='" . $_POST['start'] . "' AND  material.created_date <='" . $_POST['end'] . "')";
            $this->data['listing'] = $this->inventory_model->get_data_fromMaterial('material', $where);
            $this->_render_template('inventory_listing_and_adjustment/index', $this->data);
        } elseif (!empty($_POST['company_unit']) && $_POST['company_unit'] != '' && $_POST['start'] != '' && $_POST['end'] != '') {
            $company_unit_id = $_POST['company_unit'];
            $where = "material.created_by_cid = " . $this->companyId . " AND  (material.created_date >='" . $_POST['start'] . "' AND  material.created_date <='" . $_POST['end'] . "')";
            $this->data['listing'] = $this->inventory_model->get_data_fromMaterial_basedOnloc('material', $where, $company_unit_id);
            $this->_render_template('inventory_listing_and_adjustment/index', $this->data);
        } elseif (!empty($_POST['company_unit']) && $_POST['company_unit'] != '' && $_POST['start'] == '' && $_POST['end'] == '') {
            $id = $this->input->get_post('value');
            $company_unit_id = $_POST['company_unit'];
            $where = "material.created_by_cid = " . $this->companyId;
            $this->data['listing'] = $this->inventory_model->get_data_fromMaterial_basedOnloc('material', $where, $company_unit_id);
            $where12 = "material_type.created_by_cid = " . $this->companyId . " OR material_type.created_by_cid = 0";
            $this->data['type2'] = $this->inventory_model->get_data('material_type', $where12);
            $this->_render_template('inventory_listing_and_adjustment/index', $this->data);
        } */
        $where_mt = "material_type.created_by_cid = " . $this->companyId . " OR material_type.created_by_cid = 0";
        $this->data['type2'] = $this->inventory_model->get_data('material_type', $where_mt);

        $where_thrd_type = 'thrd_party_invtry.created_by_cid = " '. $this->companyId . '" ORDER BY id DESC ';
        $this->data['third_invt_type_data'] = $this->inventory_model->get_data('thrd_party_invtry', $where_thrd_type);

        /* $idMat = $this->input->get_post('value');
        if (isset($idMat)){
            $idMat = $this->input->get_post('value');
        } else {
            $idMat = "";
        }
        $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1, 'material.material_type_id' => $idMat, 'material.status' => 1);
        $this->data['listing'] = $this->inventory_model->get_data_fromMaterial('material', $where);
        $this->data['type'] = array_unique(array_column($this->data['listing'], 'material_type_id'));
        $type = array_unique(array_column($this->data['listing'], 'material_type_id'));
        $MaterailListingData = $this->inventory_model->get_data_fromMaterial('material', $where);
        $subTypeArray = array();
        foreach ($type as $type_material) {
            foreach ($MaterailListingData as $list_data) {
                if ($type_material == $list_data['material_type_id']) {
                    $subTypeArray[$list_data["material_type_id"]]["material_type_id"] = $list_data["material_type_id"];
                    $subTypeArray[$list_data["material_type_id"]]["material_detail"][] = array('sub_type' => $list_data["sub_type"], 'material_name' => $list_data["material_name"], 'material_name_id' => $list_data["material_name_id"], 'uom' => $list_data['uom'], 'location' => $list_data['location']);
                }
            }
        }
        $this->data['subTypeArray'] = $subTypeArray;  */

        #==============================New Inventory Listing Part===================================
        # Company address (location)
        $where_ca = "company_address.created_by_cid = " . $this->companyId . " OR company_address.created_by_cid = 0";
        $this->data['company_address'] = $this->inventory_model->get_data('company_address', $where_ca);

        $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1, 'material.status' => 1);
        # Ajax - Location based search query
        if(!empty($_POST['location_id'])){
            $location_id = $_POST['location_id'];
            $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1,'material.status' => 1, 'mat_locations.location_id' => $location_id);
            if($location_id == 0){
                $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1, 'material.status' => 1);
            }
        }
        # Ajax - Date based search query
         
        if(!empty($_POST['sdate'])){
            $date = date('Y-m-d', strtotime($_POST['sdate']));
             //$where = "t.created_by_cid = " . $this->companyId . " AND material.save_status = 1 AND material.status = 1 AND  t.created_date BETWEEN '" . $date . " 00:00:01' and '".$date." 23:59:59'";
             //$where = "t.created_by_cid = " . $this->companyId . " AND material.save_status = 1 AND material.status = 1 AND  t.created_date BETWEEN '" . $date . " 00:00:01' and '".$date." 23:59:59'";
             //  $where = 't.`created_date`LIKE "'."%{$date}".'%" AND material.save_status = 1 AND material.status = 1  AND t.`created_by_cid` = "'."{$this->companyId}".'"';
          $quary = "select b.* from inventory_flow b WHERE created_date IN (SELECT MAX(created_date) as max_date FROM inventory_flow b where created_date BETWEEN '" . $date . " 00:00:01' and '".$date." 23:59:59' GROUP BY material_id) ORDER BY material_id ASC , created_date DESC";
            // if(!empty($_POST['location_id']) && $_POST['location_id'] != 0){
            //     $where .= " and mat_locations.location_id = '".$_POST['location_id']."'";
            // }
        }
            
        $MaterailListingData = $this->inventory_model->get_data_fromMaterial_new($quary);

        # Ajax - Location based data filteration
        $MaterailListingData_new = array();
        if(!empty($_POST['location_id']) && $_POST['location_id'] != 0){
            foreach($MaterailListingData as $mid => $mld){
                $temp = array();
                if(!empty($mld['location'])){
                    $MaterailListingData_new[$mid] = $mld;
                    foreach($mld['location'] as $loc){
                        if($loc['location'] == $_POST['location_id']){
                            $temp[] = $loc;
                            $MaterailListingData_new[$mid]['location'] = $temp;
                        }
                    }
                }
            }
        }
        $this->data['materailListingData'] = !empty($MaterailListingData_new) ? $MaterailListingData_new : $MaterailListingData;

        # Export
        if(isset($_POST['export']) && $_POST['export'] == 'exportInventoryList'){
            $output = [];
            if(!empty($MaterailListingData)){
                foreach($MaterailListingData as $rows){
                    $getuom = getNameById('uom', $rows['uom'], 'id');
                    $uom = !empty($getuom) ? $getuom->ugc_code : '';
                    $sum = 0;
                    foreach ($rows['location'] as $ert) {
                        $sum+= $ert['qty'];
                    }
                    $output[] = array('Material Name' => $rows['material_name'], 'Material Type' => $rows['material_type_name'], 'Material Sub Type' => $rows['sub_type'], 'Quantity' => $sum, 'UOM' => $uom);
                }
            }
            if(!empty($output)){
                $filename = "Inventory_List.xls";
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                ExportFile($output);
            }
        }

        # Redirect view
        if (!empty($_POST['ajax_var']) && $_POST['ajax_var'] == 'via_ajax'){
            $a = $this->load->view('inventory_listing_and_adjustment/new_inventory_listing', $this->data);
            return $a;
        } elseif (!empty($_POST['ajax_var']) && $_POST['ajax_var'] == 'via_ajaxwip'){
            $a = $this->load->view('inventory_listing_and_adjustment/ajax_matwip', $this->data);
            return $a;
        } else {
            $this->_render_template('inventory_listing_and_adjustment/new_index', $this->data);
        }
    }
    public function inventory_listing_and_adjustment_new_bakup(){

        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Inventory Listing', base_url() . 'inventory_listing');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'New inventory listing and adjustment';

        /* if (!empty($_POST) && isset($_POST['start']) && isset($_POST['end']) && $_POST['company_unit'] == '') {
            $where = "material.created_by_cid = " . $this->companyId . " AND (material.save_status = 1 ) AND  (material.created_date >='" . $_POST['start'] . "' AND  material.created_date <='" . $_POST['end'] . "')";
            $this->data['listing'] = $this->inventory_model->get_data_fromMaterial('material', $where);
            $this->_render_template('inventory_listing_and_adjustment/index', $this->data);
        } elseif (!empty($_POST['company_unit']) && $_POST['company_unit'] != '' && $_POST['start'] != '' && $_POST['end'] != '') {
            $company_unit_id = $_POST['company_unit'];
            $where = "material.created_by_cid = " . $this->companyId . " AND  (material.created_date >='" . $_POST['start'] . "' AND  material.created_date <='" . $_POST['end'] . "')";
            $this->data['listing'] = $this->inventory_model->get_data_fromMaterial_basedOnloc('material', $where, $company_unit_id);
            $this->_render_template('inventory_listing_and_adjustment/index', $this->data);
        } elseif (!empty($_POST['company_unit']) && $_POST['company_unit'] != '' && $_POST['start'] == '' && $_POST['end'] == '') {
            $id = $this->input->get_post('value');
            $company_unit_id = $_POST['company_unit'];
            $where = "material.created_by_cid = " . $this->companyId;
            $this->data['listing'] = $this->inventory_model->get_data_fromMaterial_basedOnloc('material', $where, $company_unit_id);
            $where12 = "material_type.created_by_cid = " . $this->companyId . " OR material_type.created_by_cid = 0";
            $this->data['type2'] = $this->inventory_model->get_data('material_type', $where12);
            $this->_render_template('inventory_listing_and_adjustment/index', $this->data);
        } */
        $where_mt = "material_type.created_by_cid = " . $this->companyId . " OR material_type.created_by_cid = 0";
        $this->data['type2'] = $this->inventory_model->get_data('material_type', $where_mt);

        $where_thrd_type = 'thrd_party_invtry.created_by_cid = " '. $this->companyId . '" ORDER BY id DESC ';
        $this->data['third_invt_type_data'] = $this->inventory_model->get_data('thrd_party_invtry', $where_thrd_type);

        /* $idMat = $this->input->get_post('value');
        if (isset($idMat)){
            $idMat = $this->input->get_post('value');
        } else {
            $idMat = "";
        }
        $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1, 'material.material_type_id' => $idMat, 'material.status' => 1);
        $this->data['listing'] = $this->inventory_model->get_data_fromMaterial('material', $where);
        $this->data['type'] = array_unique(array_column($this->data['listing'], 'material_type_id'));
        $type = array_unique(array_column($this->data['listing'], 'material_type_id'));
        $MaterailListingData = $this->inventory_model->get_data_fromMaterial('material', $where);
        $subTypeArray = array();
        foreach ($type as $type_material) {
            foreach ($MaterailListingData as $list_data) {
                if ($type_material == $list_data['material_type_id']) {
                    $subTypeArray[$list_data["material_type_id"]]["material_type_id"] = $list_data["material_type_id"];
                    $subTypeArray[$list_data["material_type_id"]]["material_detail"][] = array('sub_type' => $list_data["sub_type"], 'material_name' => $list_data["material_name"], 'material_name_id' => $list_data["material_name_id"], 'uom' => $list_data['uom'], 'location' => $list_data['location']);
                }
            }
        }
        $this->data['subTypeArray'] = $subTypeArray;  */

        #==============================New Inventory Listing Part===================================
        # Company address (location)
        $where_ca = "company_address.created_by_cid = " . $this->companyId . " OR company_address.created_by_cid = 0";
        $this->data['company_address'] = $this->inventory_model->get_data('company_address', $where_ca);

        $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1, 'material.status' => 1);
        # Ajax - Location based search query
        if(!empty($_POST['location_id'])){
            $location_id = $_POST['location_id'];
            $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1,'material.status' => 1, 'mat_locations.location_id' => $location_id);
            if($location_id == 0){
                $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1, 'material.status' => 1);
            }
        }
        # Ajax - Date based search query
        if(!empty($_POST['sdate'])){
            $date = date('Y-m-d', strtotime($_POST['sdate']));
            $where = "material.created_by_cid = " . $this->companyId . " AND material.save_status = 1 AND material.status = 1 AND  material.created_date BETWEEN '" . $date . " 00:00:01' and '".$date." 23:59:59'";
            if(!empty($_POST['location_id']) && $_POST['location_id'] != 0){
                $where .= " and mat_locations.location_id = '".$_POST['location_id']."'";
            }
        }
        $MaterailListingData = $this->inventory_model->get_data_fromMaterial('material', $where);

        # Ajax - Location based data filteration
        $MaterailListingData_new = array();
        if(!empty($_POST['location_id']) && $_POST['location_id'] != 0){
            foreach($MaterailListingData as $mid => $mld){
                $temp = array();
                if(!empty($mld['location'])){
                    $MaterailListingData_new[$mid] = $mld;
                    foreach($mld['location'] as $loc){
                        if($loc['location'] == $_POST['location_id']){
                            $temp[] = $loc;
                            $MaterailListingData_new[$mid]['location'] = $temp;
                        }
                    }
                }
            }
        }
        $this->data['materailListingData'] = !empty($MaterailListingData_new) ? $MaterailListingData_new : $MaterailListingData;

        # Export
        if(isset($_POST['export']) && $_POST['export'] == 'exportInventoryList'){
            $output = [];
            if(!empty($MaterailListingData)){
                foreach($MaterailListingData as $rows){
                    $getuom = getNameById('uom', $rows['uom'], 'id');
                    $uom = !empty($getuom) ? $getuom->ugc_code : '';
                    $sum = 0;
                    foreach ($rows['location'] as $ert) {
                        $sum+= $ert['qty'];
                    }
                    $output[] = array('Material Name' => $rows['material_name'], 'Material Type' => $rows['material_type_name'], 'Material Sub Type' => $rows['sub_type'], 'Quantity' => $sum, 'UOM' => $uom);
                }
            }
            if(!empty($output)){
                $filename = "Inventory_List.xls";
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                ExportFile($output);
            }
        }

        # Redirect view
        if (!empty($_POST['ajax_var']) && $_POST['ajax_var'] == 'via_ajax'){
            $a = $this->load->view('inventory_listing_and_adjustment/new_inventory_listing', $this->data);
            return $a;
        } elseif (!empty($_POST['ajax_var']) && $_POST['ajax_var'] == 'via_ajaxwip'){
            $a = $this->load->view('inventory_listing_and_adjustment/ajax_matwip', $this->data);
            return $a;
        } else {
            $this->_render_template('inventory_listing_and_adjustment/new_index', $this->data);
        }
    }


    /* view Inventory adjustment history */
    public function view_inventory_adjustmentHistory_old(){
        $this->breadcrumb->add('Inventory', base_url() . 'Inventory Listing and Adjustment View');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Inventory Listing and Adjustment View';
        permissions_redirect('is_view');
        $where_ca = "company_address.created_by_cid = " . $this->companyId . " OR company_address.created_by_cid = 0";
        $this->data['company_address'] = $this->inventory_model->get_data('company_address', $where_ca);

        if(isset($_GET['id'])){
            $material_id = $_GET['id'];
            # Transacation history
            $where = "material_id = '".$material_id."' order by created_date desc";
            $this->data['mat_trans'] = $this->inventory_model->get_dataw('inventory_flow',$where);

            # Month wise transacation
            $this->data['monthwise_trans'] = $this->inventory_model->get_data_monthwise($material_id);

            # Lot listing
            $lotwhere = "mat_id = '".$material_id."' AND lot_details.created_by_cid =".$this->companyId;
            $this->data['lot_details'] = $this->inventory_model->get_data('lot_details', $lotwhere);

            # Material Availability
            $where_ma = "mayerial_id = '".$material_id."' AND reserved_material.created_by_cid =".$this->companyId;
            $this->data['reserved_material'] = $this->inventory_model->get_data('reserved_material', $where_ma);

            if(!empty($_GET['my'])){
                $year = substr($_GET['my'], 0, 4);
                $month = substr($_GET['my'], 4, 2);
                $month = str_pad($month, 2, "0", STR_PAD_LEFT);
                $startDateOfMonth = (!empty($year) && !empty($month)) ? $year.'-'.$month.'-01':'';
                $lastDateOfMonth = (!empty($startDateOfMonth)) ? date("Y-m-t", strtotime($startDateOfMonth)):'';
                $where = "created_date >='".$startDateOfMonth."' AND created_date <= '".$lastDateOfMonth."' AND material_id = '".$material_id."' order by created_date desc";
                $this->data['mat_trans'] = $this->inventory_model->get_dataw('inventory_flow',$where);
                $this->data['monthwise_trans'] = $this->inventory_model->get_dataw('inventory_flow', $where);
            }

            if(isset($_GET['start']) != '' && isset($_GET['end']) != '') {
              $where = "created_date >='".$_GET['start']."' AND created_date <= '" .$_GET['end']. "' AND material_id = '".$material_id."' order by created_date desc";
              $this->data['mat_trans'] = $this->inventory_model->get_dataw('inventory_flow',$where);
              $this->data['monthwise_trans'] = $this->inventory_model->get_dataw('inventory_flow', $where);
            }

            /*$cYearDate = date('Y-04-01');
            $nYearDate = date('Y-03-30', strtotime('+1 year'));
            $where = "created_date >= '".$cYearDate."' AND created_date <= '".$nYearDate."' AND material_id = '".$material_id."' order by created_date desc"; */
        }
        $this->_render_template('inventory_listing_and_adjustment/view_adjustment_history', $this->data);
    }


     public function getQuantityDetails() {
        if ($this->input->post()) {
            $detail = $this->input->post();
            $materialId         =  $detail['material_id'];
            $lot_idId           = $detail['lot_id'];
            $quantityReq        = $detail['quantity'];
            $work_order_id      = $detail['work_order_id'];
            $issuedQuantity     = issuedMaterialQuantity($work_order_id, $materialId);
            $workOrderDetails   = workOrderDetails($table='work_order',$work_order_id);
            $productWorkOrderData  = array();
            if($workOrderDetails){
                $productDetails = json_decode($workOrderDetails['product_detail'],true);
                foreach($productDetails as $workOrderProduct){
                    $productWorkOrderData[] = array(
                        'transfer_quantity' => $workOrderProduct['transfer_quantity'],
                        'job_card'          => $workOrderProduct['job_card'],
                        'material_id'       => $materialId
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
                            if($materialId == $jobCardDetail['material_name_id']){
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

            $requiredQuantity = 0;
            if($jobCardMaterialData){
                //~ $reQuantity       =  $jobCardMaterialData['transfer_quantity'] / $jobCardMaterialData['lot_qty'];
                //~ $requiredQuantity =  $reQuantity * $jobCardMaterialData['quantity'];

                $reQuantity       =  ($jobCardMaterialData['lot_qty'] != 0 ) ? $jobCardMaterialData['transfer_quantity'] / $jobCardMaterialData['lot_qty'] : 0;
                $requiredQuantity = ($reQuantity > 0 ) ? $reQuantity * $jobCardMaterialData['quantity'] : $jobCardMaterialData['quantity'];
            }
            // $assignedQuantities = $issuedQuantity + $quantityReq;
            // if($assignedQuantities > $requiredQuantity){
            //     $materialDetail = $this->inventory_model->getMaterialInfo('material', 'id', $materialId);
            //     // pre($materialDetail);
            //     //$overQuantityMaterialData .= 'The required quanity for '.$materialDetail['material_name']. ' is '.$requiredQuantity.'. ';
            //     $overQuantityMaterialData[] = array(
            //         'material_name'     => $materialDetail['material_name'],
            //         'material_id'       => $materialId,
            //         'required_quantity' => $requiredQuantity,
            //         'issued_quantity'   => $issuedQuantity,
            //     );

            // }
            $overQuantityMaterialData = array();
            $materialDetail = $this->inventory_model->getMaterialInfo('material', 'id', $materialId);
            $overQuantityMaterialData   = array(
                'material_name'         => $materialDetail['material_name'],
                'material_id'           => $materialId,
                'required_quantity'     => $requiredQuantity,
                'issued_quantity'       => $issuedQuantity,
            );

            if($overQuantityMaterialData){
                $output = ['data' => $overQuantityMaterialData,'status'=>true];
                echo json_encode($output);
                die();
            } else {
                $output = ['data' => $overQuantityMaterialData,'status'=>false];
                echo json_encode($output);
                die();
            }
        }
    }

    function save_inventory_setting(){
        $where = ['id' => $this->companyId];
        $data  = [$this->input->post('inputName') => $this->input->post('checkValue') ];
        $this->inventory_model->updateRowData('company_detail',$where,$data);
    }

    function getAllSaleOrder($sale_id = ""){
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $selected   = 'id,machine_name';
        $where      = "created_by_cid = {$this->companyId}";
        $data       = $this->inventory_model->joinTables($selected,'add_machine',[],$where,['id','desc'],[]);
        $html       = "<option value=''>Select Machine</option>";
        if($data){
            foreach ($data as $key => $value) {
                $html .= "<option  value='{$value['id']}'>{$value['machine_name']}</option>";
            }
        }
        return $html;
    }


    public function GetSaleOrderID($WorkOrderID = ''){
        $WorkOrderID  =  $_POST['id'];
        if(!empty($WorkOrderID)){
            $getWorkOrdersdd = $this->inventory_model->getSaleOrderID('work_order',$WorkOrderID);

            if (!empty($getWorkOrdersdd)) {
                $product_detail=array();
                $work_order_id=array();
                foreach ($getWorkOrdersdd as  $getWorkOrderIdiD) {
                    $getWorkOrder =  json_decode($getWorkOrderIdiD['product_detail']);
                    foreach ($getWorkOrder as  $getWorkOrdervalue) {
                        $work_order_id[] =$getWorkOrdervalue->job_card;
                        $product  =$getWorkOrdervalue->product;
                        $product_detail[] =  getNameById('material', $product,'id');
                    }
                }
                $html  = "<option value=''>Select Material</option>";

                foreach ($product_detail as $key => $value) {
                    $html .= "<option value='{$value->id}'>{$value->material_name}</option>";
                }
                echo json_encode(['html' => $html,true  ]);
            }
        }
    }


    public function Getjobcardvalue(){
        $WorkOrderID  =  $_POST['workOrderIds'];
        $productId  =  $_POST['productId'];
        $noofrow  =  $_POST['noofrow'];

        if(!empty($WorkOrderID)){
            $getWorkOrdersdd = $this->inventory_model->getSaleOrderID('work_order',$WorkOrderID);

            if (!empty($getWorkOrdersdd)){
                $product_detail=array();
                $work_order_id=array();
                foreach ($getWorkOrdersdd as $getWorkOrderIdiD) {
                    $getWorkOrder = json_decode($getWorkOrderIdiD['product_detail']);
                    foreach ($getWorkOrder as $getWorkOrdervalue) {
                        if ($productId==$getWorkOrdervalue->product) {
                           $work_order_id[] =$getWorkOrdervalue->job_card;
                        }
                    }
                }
                $this->data['sale_order_data'] = $this->inventory_model->getSaleOrderData('job_card', $work_order_id);
                $this->data['WorkOrderID'] = $WorkOrderID;
                $this->data['noofrow'] = $noofrow;
                $this->data['productId'] = $productId;
                echo json_encode(['html' => $this->load->view('work_in_process/work_order_edit', $this->data,true) ]);
            }
        }
    }
      public function delete_mat_info() {
        $id = $this->uri->segment('3');
        if ($id == '') {

            redirect(base_url() . 'inventory/inventory_setting', 'refresh');
        }
        $this->inventory_model->delete_data('material_type', 'id', $id);
        $this->session->set_flashdata('message', ' Deleted Successfully');
        redirect(base_url() . 'inventory/inventory_setting', 'refresh');
    }

    public function get_matrial_type() {
        if(isset($_POST['mat_id'])) {
            $get_data = $this->inventory_model->get_data_material_type('material_type', 'id', $_POST['mat_id']);
            return json_encode($get_data, true);
        }
    }

    function getMatAliasByCust(){
        if( isset($_POST) ){
            /*pre($_POST)*/
            if( $_POST['matId'] && $_POST['custId'] ){
                $ledgerId = getSingleAndWhere('ledger_id','account',['id' => $_POST['custId'] ]);
                $aliasName = getSingleAndWhere('MatAliasName','material',['id' => $_POST['matId'] ]);
                $html = "";
                if( $aliasName ){
                    $aliasName = json_decode($aliasName,true);
                    foreach($aliasName as $key => $value ){
                        if( $ledgerId == $value['customer_id'] ){
                            $html .= "<option value='{$value['alias']}'>
                            {$value['alias']}</option>";
                        }
                    }
                }
                echo json_encode(['html' => $html ]);
            }
        }
    }


    /**** Get total lot quantity function ****/
    public function getTotalLotQuantity($material_id){
        $lotdetails = $this->inventory_model->get_data('lot_details', array('mat_id' => $material_id));
        $totalLotQty = 0;
        if(!empty($lotdetails)){
            foreach($lotdetails as $lotdt){
                $totalLotQty += $lotdt['quantity'];
            }
        }
        return $totalLotQty;
    }

    /**** Material update closing balance common function ****/
    public function update_closing_balance($materialId){
		$yu = getNameById_mat('mat_locations', $materialId, 'material_name_id');
        $totalLotQty = 0;
         if (!empty($yu)) {
            foreach ($yu as $ert) {
                $totalLotQty+= $ert['quantity'];
            }
        }
		// pre($totalLotQty);die();
		

        // $totalLotQty = $this->getTotalLotQuantity($materialId);
        $this->inventory_model->updateRowData('material',array('id' => $materialId), array('closing_balance' => $totalLotQty));
    }


    /* New Inventory Listing and adjustment */
	public function stock(){

        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Inventory Listing', base_url() . 'inventory_listing');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'New inventory listing and adjustment';

        $where_mt = "material_type.created_by_cid = " . $this->companyId . " OR material_type.created_by_cid = 0";
        $this->data['type2'] = $this->inventory_model->get_data('material_type', $where_mt);

        $where_thrd_type = 'thrd_party_invtry.created_by_cid = " '. $this->companyId . '" ORDER BY id DESC ';
        $this->data['third_invt_type_data'] = $this->inventory_model->get_data('thrd_party_invtry', $where_thrd_type);

        #==============================New Inventory Listing Part===================================
        # Company address (location)
        $where_ca = "company_address.created_by_cid = " . $this->companyId . " OR company_address.created_by_cid = 0";
        $this->data['company_address'] = $this->inventory_model->get_data('company_address', $where_ca);

        $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1, 'material.status' => 1);
        $where2 = "material.created_by_cid = " . $this->companyId . " AND material.save_status = 1 AND material.status = 1 AND  t.created_date <= '" . date('Y-m-d') . " 23:59:00'";

        # Ajax - Location based search query
        if(!empty($_POST['location_id'])){
            $location_id = $_POST['location_id'];
            $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1,'material.status' => 1);      #'mat_locations.location_id' => $location_id
            if($location_id == 0){
                $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1, 'material.status' => 1);
            }
        }
        
       
  $quary = 'select b.* from inventory_flow b join(SELECT b.id, MAX(id) as max_id FROM inventory_flow b GROUP BY material_id) a on b.id=a.max_id WHERE b.created_by_cid = "'.$this->companyId.'" order by b.id ';
        
  $MaterailListingData = $this->inventory_model->get_data_fromMaterial_new($quary);
  
         # Ajax - Location based data filteration
        $MaterailListingData_new = array();
        $MaterailListingData_tilldate_new = array();
        if(!empty($_POST['location_id']) && $_POST['location_id'] != 0){
            foreach($MaterailListingData as $mid => $mld){
                $temp = array();
                if(!empty($mld['location'])){
                    $MaterailListingData_new[$mid] = $mld;
                    foreach($mld['location'] as $loc){
                        if($loc['location'] == $_POST['location_id']){
                            $temp[] = $loc;
                            $MaterailListingData_new[$mid]['location'] = $temp;
                        }
                    }
                }
            }            
            foreach($MaterailListingData_tilldate as $mid2 => $mld2){
                $temp2 = array();
                if(!empty($mld2['location'])){                                        
                    foreach($mld2['location'] as $loc2){                        
                        if($loc2['location'] == $_POST['location_id']){                            
                            $MaterailListingData_tilldate_new[$mid2] = $mld2;
                            $temp2[] = $loc2;
                            $MaterailListingData_tilldate_new[$mid2]['location'] = $temp2;
                        }
                    }                    
                }
            }                 
        }
        
        $this->data['materailListingData'] = !empty($MaterailListingData_new) ? $MaterailListingData_new : $MaterailListingData;
        //pre($this->data['materailListingData']); die;
        $this->data['materailListingData_Tilldate'] = !empty($MaterailListingData_tilldate_new) ? $MaterailListingData_tilldate_new : $MaterailListingData_tilldate;

        # Export
        if(isset($_POST['export']) && $_POST['export'] == 'exportInventoryList'){
            $output = [];
            if(!empty($MaterailListingData)){   
                $overAllclosing_balance = $totalSalePrice =  $subTotalSalePriceClosingBall = $totalCostPrice= $subTotalcostPriceClosingBall=0;
                foreach($MaterailListingData as $rows){
                    $materialId = getNameById('material', $rows['materialId'], 'id');
                    $getuom = getNameById('uom', $rows['uom'], 'id');
                    $uom = !empty($getuom) ? $getuom->ugc_code : '';
                    
                    $sum = 0;
                    foreach ($rows['location'] as $ert) {
                        $sum+= $ert['qty'];
                    }
                    $closing_balance = $rows['closing_balance']; 
                    $rsvQty = 0;
                    if($sum > 0){
                       //$totalSalePrice +=$materialId->sales_price;
                        if(!empty($rows['reserved_material'])){
                            $tempArr = array_unique(array_column($rows['reserved_material'], 'id'));
                            $reserved_material = array_intersect_key($rows['reserved_material'], $tempArr);                     
                            foreach($reserved_material as $rqty) {
                                $rsvQty += !empty($rqty['quantity']) ? $rqty['quantity']:0;
                            }
                        }
                    
                        $overAllclosing_balance +=$sum;
                        $avaible_balance = $closing_balance - $rsvQty; 
                        $subtotal = ($materialId->sales_price * $rows['closing_balance']);
                        $subTotalSalePriceClosingBall += ($materialId->sales_price * $rows['closing_balance']);
                        $subTotalcostPriceClosingBall += ($materialId->cost_price * $rows['closing_balance']);
                        $subTotalcost = ($materialId->cost_price * $rows['closing_balance']);
                    
                        $totalSalePrice1  =$materialId->sales_price;
                        $totalSalePrice  +=$totalSalePrice1;
                        $totalSalePrice  +=$totalSalePrice1;
                        $totalCostPrice +=$materialId->cost_price;
                                      
                        $output[] = array('Material Code' => $materialId->material_code,'Material Name' => $rows['material_name'], 'Material Type' => $rows['material_type_name'], 'Material Sub Type' => $materialId->sub_type, 'closing_balance' => $rows['closing_balance'], 'UOM' => $uom ,'Purchase Price' => $materialId->cost_price,'Sub Total (Sale Price And Closing Balance' => $subtotal,'Sub Total (Purchase Price And Closing Balance' => $subTotalcost);
                        #'sale Price ' => $materialId->sales_price,                 
                    }
                    
                }
                // $totaloutput[] = array('Total Price'=>$totalSalePrice);
                // // pre($subTotalSalePriceClosingBall - 80124552.53); 
                //$totaloutput[] = array('Closing Balance'=> $overAllclosing_balance,'sale Price'=>$totalSalePrice,'Cost Price'=>$totalCostPrice,'Total sale Price closing Balance'=>$subTotalSalePriceClosingBall,'Total Cost Price closing Balance'=>$subTotalcostPriceClosingBall);

                $totaloutput[] = array('Closing Balance'=> $overAllclosing_balance,'Total Purchase Price closing Balance'=>$subTotalcostPriceClosingBall);
                #'Total sale Price closing Balance'=>$subTotalSalePriceClosingBall,                                     
            }
                        
            if(!empty($output)){
                $filename = "Inventory_List.xls";
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                ExportFile($output, $totaloutput);
            }
        }

        # Redirect view
        if (!empty($_POST['ajax_var']) && $_POST['ajax_var'] == 'via_ajax'){            
            $a = $this->load->view('inventory_listing_and_adjustment/new_inventory_listing', $this->data);
            return $a;
        } elseif (!empty($_POST['ajax_var']) && $_POST['ajax_var'] == 'via_ajaxwip'){
            $a = $this->load->view('inventory_listing_and_adjustment/ajax_matwip', $this->data);
            return $a;
        } else {
            $this->_render_template('inventory_listing_and_adjustment/new_index', $this->data);
        }
    }
    public function stock_bakup(){

        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Inventory Listing', base_url() . 'inventory_listing');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'New inventory listing and adjustment';

        $where_mt = "material_type.created_by_cid = " . $this->companyId . " OR material_type.created_by_cid = 0";
        $this->data['type2'] = $this->inventory_model->get_data('material_type', $where_mt);

        $where_thrd_type = 'thrd_party_invtry.created_by_cid = " '. $this->companyId . '" ORDER BY id DESC ';
        $this->data['third_invt_type_data'] = $this->inventory_model->get_data('thrd_party_invtry', $where_thrd_type);

        #==============================New Inventory Listing Part===================================
        # Company address (location)
        $where_ca = "company_address.created_by_cid = " . $this->companyId . " OR company_address.created_by_cid = 0";
        $this->data['company_address'] = $this->inventory_model->get_data('company_address', $where_ca);

        $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1, 'material.status' => 1);
        # Ajax - Location based search query
        if(!empty($_POST['location_id'])){
            $location_id = $_POST['location_id'];
            $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1,'material.status' => 1, 'mat_locations.location_id' => $location_id);
            if($location_id == 0){
                $where = array('material.created_by_cid' => $this->companyId, 'material.save_status' => 1, 'material.status' => 1);
            }
        }
        # Ajax - Date based search query
        if(!empty($_POST['sdate'])){
            $date = date('Y-m-d', strtotime($_POST['sdate']));
            $where = "material.created_by_cid = " . $this->companyId . " AND material.save_status = 1 AND material.status = 1 AND  material.created_date BETWEEN '" . $date . " 00:00:01' and '".$date." 23:59:59'";
            if(!empty($_POST['location_id']) && $_POST['location_id'] != 0){
                $where .= " and mat_locations.location_id = '".$_POST['location_id']."'";
            }
        }
        $MaterailListingData = $this->inventory_model->get_data_fromMaterial('material', $where);

        # Ajax - Location based data filteration
        $MaterailListingData_new = array();
        if(!empty($_POST['location_id']) && $_POST['location_id'] != 0){
            foreach($MaterailListingData as $mid => $mld){
                $temp = array();
                if(!empty($mld['location'])){
                    $MaterailListingData_new[$mid] = $mld;
                    foreach($mld['location'] as $loc){
                        if($loc['location'] == $_POST['location_id']){
                            $temp[] = $loc;
                            $MaterailListingData_new[$mid]['location'] = $temp;
                        }
                    }
                }
            }
        }
        $this->data['materailListingData'] = !empty($MaterailListingData_new) ? $MaterailListingData_new : $MaterailListingData;

        # Export
        if(isset($_POST['export']) && $_POST['export'] == 'exportInventoryList'){
            $output = [];
            if(!empty($MaterailListingData)){
                foreach($MaterailListingData as $rows){
                    $getuom = getNameById('uom', $rows['uom'], 'id');
                    $uom = !empty($getuom) ? $getuom->ugc_code : '';
                    $sum = 0;
                    foreach ($rows['location'] as $ert) {
                        $sum+= $ert['qty'];
                    }
                    $output[] = array('Material Name' => $rows['material_name'], 'Material Type' => $rows['material_type_name'], 'Material Sub Type' => $rows['sub_type'], 'Quantity' => $sum, 'UOM' => $uom);
                }
            }
            if(!empty($output)){
                $filename = "Inventory_List.xls";
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                ExportFile($output);
            }
        }

        # Redirect view
        if (!empty($_POST['ajax_var']) && $_POST['ajax_var'] == 'via_ajax'){
            $a = $this->load->view('inventory_listing_and_adjustment/new_inventory_listing', $this->data);
            return $a;
        } elseif (!empty($_POST['ajax_var']) && $_POST['ajax_var'] == 'via_ajaxwip'){
            $a = $this->load->view('inventory_listing_and_adjustment/ajax_matwip', $this->data);
            return $a;
        } else {
            $this->_render_template('inventory_listing_and_adjustment/new_index', $this->data);
        }
    }

    /* view Inventory adjustment history */
    public function view_inventory_adjustmentHistory(){
        $this->breadcrumb->add('Inventory', base_url() . 'Inventory Listing and Adjustment View');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Inventory Listing and Adjustment View';
        permissions_redirect('is_view');
        $where_ca = "company_address.created_by_cid = " . $this->companyId . " OR company_address.created_by_cid = 0";
        $this->data['company_address'] = $this->inventory_model->get_data('company_address', $where_ca);

        if(isset($_GET['id'])){
            $material_id = $_GET['id'];
            # Transacation history
            $where = "material_id = '".$material_id."' order by created_date desc";
            $this->data['mat_trans'] = $this->inventory_model->get_dataw('inventory_flow',$where);

            # Month wise transacation
            #//$this->data['monthwise_trans'] = $this->inventory_model->get_data_monthwise($material_id);
            $dataa = array();
            foreach($this->data['mat_trans'] as $rows){
                $month =  !empty($rows['created_date']) ? date("Ym", strtotime($rows['created_date'])):'';
                $dataa[$month][] = $rows;
            }
            $this->data['monthwise_trans'] = $dataa;

            # Lot listing
            $lotwhere = "mat_id = '".$material_id."' AND lot_details.created_by_cid =".$this->companyId;
            $this->data['lot_details'] = $this->inventory_model->get_data('lot_details', $lotwhere);

            # Material Availability
            $where_ma = "mayerial_id = '".$material_id."' AND reserved_material.created_by_cid =".$this->companyId;
            $this->data['reserved_material'] = $this->inventory_model->get_data('reserved_material', $where_ma);

            if(!empty($_GET['my'])){
                $year = substr($_GET['my'], 0, 4);
                $month = substr($_GET['my'], 4, 2);
                $month = str_pad($month, 2, "0", STR_PAD_LEFT);
                $startDateOfMonth = (!empty($year) && !empty($month)) ? $year.'-'.$month.'-01':'';
                $lastDateOfMonth = (!empty($startDateOfMonth)) ? date("Y-m-t", strtotime($startDateOfMonth)):'';
                $where = "created_date >='".$startDateOfMonth."' AND created_date <= '".$lastDateOfMonth."' AND material_id = '".$material_id."' order by created_date desc";
                $this->data['mat_trans'] = $this->inventory_model->get_dataw('inventory_flow',$where);
                $this->data['monthwise_trans'] = $this->inventory_model->get_dataw('inventory_flow', $where);
            }

            if(isset($_GET['start']) != '' && isset($_GET['end']) != '') {
              $where = "created_date >='".$_GET['start']."' AND created_date <= '" .$_GET['end']. "' AND material_id = '".$material_id."' order by created_date desc";
              $this->data['mat_trans'] = $this->inventory_model->get_dataw('inventory_flow',$where);
              $this->data['monthwise_trans'] = $this->inventory_model->get_dataw('inventory_flow', $where);
            }

            /*$cYearDate = date('Y-04-01');
            $nYearDate = date('Y-03-30', strtotime('+1 year'));
            $where = "created_date >= '".$cYearDate."' AND created_date <= '".$nYearDate."' AND material_id = '".$material_id."' order by created_date desc"; */
        }
        $this->_render_template('inventory_listing_and_adjustment/view_adjustment_history', $this->data);
    }
    
    
    
    
    
    
        /*HSN ADD CODE*/
    public function addHsnNumberDtails(){
        $this->load->view('materials/addhsn');
    }



    public function add_HSNNUMBER(){
	 $hsndata['hsn_sac']        = $_REQUEST['name'];
	 $hsndata['short_name'] = $_REQUEST['shortName'];
	 $hsndata['igst']    = $_REQUEST['igst_keyup'];
	 $hsndata['sgst']    = $_REQUEST['sgst_keyup'];
	 $hsndata['cgst'] = $_REQUEST['cgst_hsnmaster'];
	 $hsndata['type']        = $_REQUEST['hsnType'];
	 $hsndata['created_by_cid'] = $this->companyId;
	   $where = array('hsn_sac' => $hsndata['hsn_sac']);
	   $ChkHSNNumber = $this->inventory_model->get_HSNSACMASTERDATA('hsn_sac_master', $where);
         if(empty($ChkHSNNumber)){ 
				$addedData = $this->inventory_model->insert_on_spot_tbl_data('hsn_sac_master',$hsndata);
				if($addedData > 0){
					echo 'true';
				}else{
					echo 'false';
				}
		 }else{
			 echo 'alreadyAdded';
		 }		
   }
    /*HSN ADD CODE*/
    
    
    
    /*Product Matrix Code Start hear*/
    

    /*********************************************************************************/
     ######################## Start - Variants Based Inventory ######################
    /********************************************************************************/
    // public function newproductmat(){
    //     $this->data['can_edit'] = edit_permissions();
    //     $this->data['can_delete'] = delete_permissions();
    //     $this->data['can_add'] = add_permissions();
    //     $this->data['can_view'] = view_permissions();
    //     $this->breadcrumb->add('Inventory', base_url() . 'inventory/New Product Matrix');
    //     $this->settings['breadcrumbs'] = $this->breadcrumb->output();
    //     $this->settings['pageTitle'] = 'New Product Matrix';
    //     $this->data['material_variants'] = $this->inventory_model->get_filter_details('material_variants', array('status' => 1));
    //     $this->_render_template('newproductmat/index', $this->data);
    // } 
     public function newproductmat(){
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/New Product Matrix');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'New Product Matrix';
        $this->data['material_variants'] = $this->inventory_model->get_filter_details('material_variants', array('status' => 1));
        $this->_render_template('newproductmat/index', $this->data);
     }
     
    //Generate materix - Add material 
    public function generate_matrix(){
        $material_name = isset($_POST['materialName']) ? trim($_POST['materialName']):'';
        $variantKey = !empty($_POST['variant_key']) ? $_POST['variant_key'] :array();
        $variantKeyCount = count($variantKey);
        $variantValue = !empty($_POST['variant_value']) ? $_POST['variant_value'] :array();
        $variantValueCount = count($variantValue);
        
        $variantsData = array('variant_key' => $variantKey, 'variant_value' => $variantValue);
        $encodedData = json_encode($variantsData);
        
        if($variantKeyCount >= 1){
            
            # Create Table header
            $table .= "<table border='1' id='updateSale_price_updatde'><thead><tr>";
            for($k=1; $k<=$variantKeyCount; $k++){
                $tableheader = !empty($variantKey[$k][0]) ? $variantKey[$k][0] : $k;
                $table .= "<th>". ucfirst($tableheader) ."</th>";
            }
            $table .= "<th>Variant code / SKU</th>
                      <th>Default sales price</th>
                      <th></th>";
            $table .= "</tr></thead>";
            
        
            # Create variants matrix array
            $variants = $this->variations($variantValue);
            
            if(!empty($variants))
            {
                # Sort a Multidimensional Array by value - ascending order
                $datas = [];
                foreach ($variants as $key => $row) {
                    $datas[$key]  = $row[0];
                }
                array_multisort($datas, SORT_ASC, $variants);
                
                # Create Table Body
                $rid = 1;
                $table .= "<tbody>";
                $table .= "<input type='hidden' id='variants_data' name='variants_data' value='".$encodedData."'>";
                foreach($variants as $key3 => $rows){
                    $table .= "<tr id='".$rid."'>";
					
                    $tempname = '';
                    $className = '';
                    foreach($rows as $key1 => $row){
						$PUDATA = substr($row, 0, 2);
				// pre($PUDATA);
						// if($key1 == 3){
						if($PUDATA == 'PU'){
						   $cls = 'addcls';	
						   $cls2 = 'addcls2';
						   $puCls = $row;	
						}else{
							$cls = '';
							$cls2 = '';	
							$puCls = '';
						}
						$className = $row;
                        $table .= "<td class='".$cls."' data-idVal='".$puCls."'>".$row."</td>";
                        $tempname .= $row.'_';
                        
                    }
					
					
                    $materialName = $material_name.'_'.$tempname;       //concate all variants into material name (first element is material name)
                    $materialName = substr($materialName, 0, -1);
                    $table .= '<td><input type="hidden" id="material_name_'.$rid.'" name="material_name[]" class="form-control" value="'.$materialName.'">
                                 <input type="text" id="variant_sku_'.$rid.'" name="variant_sku[]" class="form-control col-md-7 col-xs-12 sku" onkeyup="checksku(this)" placeholder="E.g. P-1, M-1">
                                 <p style="color:red;float:left;"></p></td>
                                <td><input type="text" id="sales_price_'.$rid.'" name="sales_price[]" class="form-control col-md-7 col-xs-12 change_PriceVal '.$cls2.'" data-idd="'.$className.'" placeholder="Type sales price"></td> 
                                <td><button type="button" id="remove_'.$rid.'" onclick="return deleteMaterial(this);"><i class="fa fa-trash"></i></button></td>';
                    $table .= "</tr>";
                    $rid++;
                }
                $table .= "</tbody>";
            }
            echo $table .= "</table>";
            return $table;
        }
    }
    
    //Generate materix - Edit material
    public function generate_matrix_edit(){
        $id = isset($_POST['mvid']) ? trim($_POST['mvid']):'';
        $material_name = isset($_POST['materialName']) ? trim($_POST['materialName']):'';
        $variantKey = !empty($_POST['variant_key']) ? $_POST['variant_key'] :array();
        $variantKeyCount = count($variantKey);
        $variantValue = !empty($_POST['variant_value']) ? $_POST['variant_value'] :array();
        $variantValueCount = count($variantValue);
		// pre($_POST['variant_key']);
		// die();
        
        $variantsData = array('variant_key' => $variantKey, 'variant_value' => $variantValue);
        $encodedData = json_encode($variantsData);
		
		
		// pre($encodedData);die();
        
        //Edit variants
        if(!empty($id)){
            $updatevariants = $this->inventory_model->updateRowData('material_variants',array('id' => $id), array('variants_data' => $encodedData));
            $variants = $this->inventory_model->get_data_byId('material_variants', 'id', $id);  
            $where = array('created_by_cid' => $this->companyId, 'status' => 1, 'product_code' => $id);
            $materials = $this->inventory_model->get_data('material', $where);
        }
        
        if($variantKeyCount >= 1){
            
            # Create Table header
            $table .= "<table border='1' id='updateSale_price_updatde'><thead><tr>";
            for($k=1; $k<=$variantKeyCount; $k++){
                $tableheader = !empty($variantKey[$k][0]) ? $variantKey[$k][0] : $k;
                $table .= "<th>". ucfirst($tableheader) ."</th>";
            }
            $table .= "<th>Variant code / SKU</th>
                       <th>Default sales Price</th>
                       <th></th>";
            $table .= "</tr></thead>";
            
            
            $table .= "<tbody>";
            if(!empty($materials))
            {
                $i = 1;
                foreach($materials as $k => $material){
                    
                    $table .= '<tr id="'.$i.'">';
                    
                    $specification = $material['specification'];
                    $explodeArray = !empty($material['material_name']) ? explode('_', $material['material_name']):array();
                    
                    #Show coloums according to variants type [Exist/Saved variants] 
                    if(!empty($explodeArray)){
                        for($t=1; $t<=$variantKeyCount; $t++){
                            $fieldname = $variantKey[$t][0];
                            $selectedOption = !empty($explodeArray[$t]) ? '<option value="'.$explodeArray[$t].'" selected>'.$explodeArray[$t].'</option>' :'';
                            $table .= '<td><select id="'.$fieldname.'_'.$i.'" class="form-control dynamic" name="'.$fieldname.'['.$material['id'].']" data-id="material_variants" data-fieldname="variants_data" data-where="id='.$id.'" data-key="'.$t.'">
                                         <option value="">Select</option>'.$selectedOption.'</select>
                                      </td>';
                        }
                    }
                    
                    #Show more coloums according to variants type [New variants]
                    $explodeArrCount = count($explodeArray);
                    $afterSkipFirst = $explodeArrCount - 1;    //Skip first element from array (first element is main material name)
                    $extraColumn = '';
                    if($variantKeyCount < $afterSkipFirst){
                        $extraColumn = $variantKeyCount - $afterSkipFirst;
                        $sameArrayCount = $variantKeyCount - $extraColumn;
                        for($t=1; $t<=$variantKeyCount; $t++){
                            if($t > $sameArrayCount){
                                $fieldname = $variantKey[$t][0];
                                $table .= '<td><select id="'.$fieldname.'_'.$i.'" class="form-control dynamic" name="'.$fieldname.'['.$material['id'].']" data-id="material_variants" data-fieldname="variants_data" data-where="id='.$id.'" data-key="'.$t.'">
                                                <option value="">Select</option></select> 
                                           </td>';
                            }
                        }
                    }
                    
                    $table .= '<td><input type="hidden" id="material_id_'.$i.'" name="material_id['.$i.']" class="form-control" value="'.$material['id'].'">
                                 <input type="hidden" id="material_name_'.$i.'" name="material_name['.$material['id'].']" class="form-control" value="'.$material['material_name'].'">
                                 <input type="text" id="variant_sku_'.$i.'" name="variant_sku['.$material['id'].']" class="form-control col-md-7 col-xs-12 sku" value="'.$material['mat_sku'].'" onkeyup="checksku(this)" placeholder="E.g. P-1, M-1">
                                 <p style="color:red;float:left;"></p></td>
                                <td><input type="text" id="sales_price_'.$i.'" name="sales_price['.$material['id'].']" class="form-control col-md-7 col-xs-12 change_PriceVal" value="'.$material['sales_price'].'" placeholder="Type sales price"></td>
                                <td><button type="button" id="remove_'.$i.'" onclick="return deleteMaterial(this);"><i class="fa fa-trash"></i></button></td>';
                                
                    $table .= '</tr>';            
                    $i++;             
                }
            }
            echo $table .= '</tbody>';
            return $table;
        }
    }
    
    
    function variations($array){
        if (empty($array)) {
            return [];
        }    
        //Go through entire array and transform elements that are arrays into elements, collect keys
        $keys = [];
        $size = 1;    
        foreach ($array as $key => $elems) {
            if (is_array($elems)) {
                $rr = [];
                foreach ($elems as $ind => $elem) {
                    $rr[] = $elem;
                }
 
                $array[$key] = $rr;
                $size *= count($rr);
            }
            $keys[] = $key;
        }
    
        //Go through all new elems and make variations
        $rez = [];
        for ($i = 0; $i < $size; $i++) {
            $rez[$i] = [];    
            foreach ($array as $key => $value) {
                $current = current($array[$key]);
                $rez[$i][$key] = $current;
            }
    
            foreach ($keys as $key) {
                if (!next($array[$key])) {
                    reset($array[$key]);
                } else {
                    break;
                }
            }
        }
        return $rez;
    }
    
    
    //Get select2 data, based on query by ajax
    public function newAjaxSelect2search(){
        $json = [];
        if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
            $this->db->select($this->input->get("fieldname").' as text');    
            $this->db->from($this->input->get("table"));        
            if(!empty($this->input->get("q"))){     
                $table_field_name = $this->input->get("fieldname"); 
                $this->db->like(($table_field_name), $this->input->get("q"));
            }
            if($this->input->get("fieldwhere")!=''){
                $whereCondition = $this->input->get("fieldwhere");
                $this->db->order_by('name','ASC');
                $this->db->where('('.$whereCondition.')');
                if($tablename == 'ledger'){
                    $this->db->order_by('name','ASC');
                }else{
                    $this->db->order_by('id','DESC');
                }
            }
            $qry = $this->db->get();  
        }else{
            $dynamicdb = $this->load->database('dynamicdb', TRUE);  
            $dynamicdb->select($this->input->get("fieldname").' as text');    
            $dynamicdb->from($this->input->get("table"));
            $tablename = $this->input->get("table");    
            if(!empty($this->input->get("q"))){     
            $table_field_name = $this->input->get("fieldname"); 
                $dynamicdb->like(($table_field_name), $this->input->get("q"));
            }
            if($this->input->get("fieldwhere")!=''){
                $whereCondition = $this->input->get("fieldwhere");
                $dynamicdb->where('('.$whereCondition.')');
                if($tablename == 'ledger'){
                    $dynamicdb->order_by('name','ASC'); 
                }else{
                    $dynamicdb->order_by('id','DESC');
                }
            }
            $qry = $dynamicdb->get(); 
        }
        if(!empty($qry)){
            $result = $qry->result();
            $field = $this->input->get("field");
            $text = !empty($result[0]->text) ? json_decode($result[0]->text, true):'';
            $values = !empty($text) ? array_column($text, $field):'';
            echo json_encode($values[1]);
        }           
    }
    
    
    /* Save material according to variants */
    function save_variant_materials(){
       
        $data = $this->input->post();
		$item_code = $data['item_code'];
        $temp_material_name = $data['temp_material_name'];
        $standard_packing = $data['standard_packing'];
        $tempMaterialData = [
          'material_type_id' => $data['material_type_id'],
          'sub_type' => $data['sub_type'],
          'uom_type' => $data['uom_type'],
          'hsn_code' => $data['hsn_code'],
          'standard_packing' => $standard_packing,
          'tax' => $data['tax'],
        ];
        $counts = count($_POST['packing_mat']);
        $packing_arr = array();
        $j = 0;
        while ($j < $counts) {
            $packing_arr[$j]['packing_mat'] = $_POST['packing_mat'][$j];
            $packing_arr[$j]['packing_qty'] = $_POST['packing_qty'][$j];
            $packing_arr[$j]['stand_pack'] = $_POST['stand_pack'][$j];
            $packing_arr[$j]['packing_weight'] = $_POST['packing_weight'][$j];
            $packing_arr[$j]['packing_cbf'] = $_POST['packing_cbf'][$j];
            $j++;
        }
        $variants_data = !empty($data['variants_data']) ? $data['variants_data']:'';
        
        $variants = [
                'item_code' => $item_code,
                'temp_material_name' => $temp_material_name,
                'temp_material_data' => json_encode($tempMaterialData),
                'packing_data' => json_encode($packing_arr),
                'variants_data' => $variants_data,
            ];      
         $where = array('status' => 1, 'item_code' => $item_code);
        $checkVariants = $this->inventory_model->get_data('material_variants', $where); 

        if(empty($checkVariants)){                          
            $id = $this->inventory_model->insertData('material_variants', $variants);
          if (!empty($_FILES['materialImage']['name']) && $_FILES['materialImage']['name'] != '') {
                            $filename = $_FILES['materialImage']['name'];
                            $tmpname = $_FILES['materialImage']['tmp_name'];
                            $type = $_FILES['materialImage']['type'];
                            $error = $_FILES['materialImage']['error'];
                            $size = $_FILES['materialImage']['size'];
                            // $exp = explode('.', $filename);
                            // $ext = end($exp);
                            // $newname = $exp[0] . '_' . time() . "." . $ext;
							$filename = str_replace(' ', '_', $filename);;
                            $config['upload_path'] = 'assets/modules/inventory/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/inventory/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $filename;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/inventory/uploads/" . $filename);
                            $image_array1['rel_id'] = $id;
                            $image_array1['rel_type'] = 'material';
                            $image_array1['file_name'] = $filename;
                            $image_array1['file_type'] = $type;
                          if (!empty($image_array1)) {
                            #Insert multiple file information into the database
                            // $material_image = $this->inventory_model->insert_single_attachment_data('attachments', $image_array1, 'material');
                        }
                    }
            #save materials according to variants
            $totalproduct = count($data['material_name']);
			// pre($totalproduct);
            if($totalproduct >= 1){
                
                $material_type = $data['material_type_id'];
                $sub_type = '';
                if(!empty($data['sub_type'])){
                    //$sub_type = preg_replace('/[ ,]+/', '-', $data['sub_type']);
                    $sub_type = $data['sub_type'];
                }
                $uom = $data['uom_type'];
                $sale_pur = array('Sale');
                $sale_purchase = json_encode($sale_pur);
                $hsn_code = $data['hsn_code'];
                $image_array = array();
				$j=1;
                for($i=0; $i < $totalproduct; $i++){
					
					//pre($j);
					
                    $last_id = getLastTableId('material');
					$rId = $last_id + $j;
					                    
                    if (!empty($_FILES['materialImage']['name']) && $_FILES['materialImage']['name'] != '') {
                            $filename = $_FILES['materialImage']['name'];
                            $tmpname = $_FILES['materialImage']['tmp_name'];
                            $type = $_FILES['materialImage']['type'];
                            $error = $_FILES['materialImage']['error'];
                            $size = $_FILES['materialImage']['size'];
                            // $exp = explode('.', $filename);
                            // $ext = end($exp);
                            // $newname = $exp[0] . '_' . time() . "." . $ext;
							$filename = str_replace(' ', '_', $filename);;
                            $config['upload_path'] = 'assets/modules/inventory/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/inventory/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $filename;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/inventory/uploads/" . $filename);
                            $image_array[$i]['rel_id'] = $rId;
                            $image_array[$i]['rel_type'] = 'material';
                            $image_array[$i]['file_name'] = $filename;
                            $image_array[$i]['file_type'] = $type;
                    }
                    $matCode = 'MAT_'.rand(1, 1000000).'_'.$rId; 

                    $inserdata[$i]['material_code'] = $matCode;   
                    $inserdata[$i]['product_code'] = $id;                       
                    $inserdata[$i]['material_type_id'] = $material_type;
                    $inserdata[$i]['material_name'] = $data['material_name'][$i];
                    $inserdata[$i]['MatAliasName'] = $temp_material_name;
                    $inserdata[$i]['mat_sku'] = $data['variant_sku'][$i];
                    $inserdata[$i]['uom'] = $uom;
                    $inserdata[$i]['sub_type'] = $sub_type;
                    $inserdata[$i]['standard_packing'] = $data['standard_packing'];
                    $inserdata[$i]['item_code'] = $data['item_code'];
                    $inserdata[$i]['non_inventry_material'] = '0';
                    $inserdata[$i]['packing_data'] = json_encode($packing_arr);
                    $inserdata[$i]['sales_price'] = !empty($data['sales_price'][$i]) ? $data['sales_price'][$i] : '';                            
                    #$inserdata[$i]['cost_price'] = !empty($data['cost_price'][$i]) ? $data['cost_price'][$i] : '';
                    $inserdata[$i]['sale_purchase'] = $sale_purchase;
                    $inserdata[$i]['specification'] = !empty($data['specification']) ? $data['specification'] : '';
                    $inserdata[$i]['hsn_code'] = $hsn_code;
                    #$inserdata[$i]['opening_balance'] = !empty($data['quantity'][$i]) ? $data['quantity'][$i] : '';
                    #$inserdata[$i]['closing_balance'] = !empty($data['quantity'][$i]) ? $data['quantity'][$i] : '';                                                        
                    $inserdata[$i]['tax'] = !empty($data['tax']) ? $data['tax'] : '';
                    $inserdata[$i]['save_status'] = '1';
                    $inserdata[$i]['created_by'] = $_SESSION['loggedInUser']->u_id;
                    $inserdata[$i]['created_by_cid'] = $this->companyId;    
                    
                    #Generate barcode and save material accordingly             
                    $bar_code_text = 'V0'.$item_code.$i;          #Barcode  
                    $size = '10';
                    $orientation = "horizontal";
                    $code_type = "code128";
                    $print = "true";
                    $sizefactor = "1";    
                    $filepath = "assets/modules/inventory/barcode_img/".$bar_code_text.".png";                                    
                    $barCode = $this->barcode( $filepath, $bar_code_text, $size, $orientation, $code_type, $print, $sizefactor );
                    $inserdata[$i]['bar_code'] = $bar_code_text;

				$j++;			
                }
				//die();
				 
				
				// pre($image_array);die();
				
				
				 
                $result = $this->inventory_model->importDataProductMatrix('material', $inserdata,$_POST['location']);
				
			
                if (!empty($image_array)) {
                #Insert multiple file information into the database
                $material_image = $this->inventory_model->insert_attachment_data('attachments', $image_array, 'material');
                } 
                                   
                if($result){                                                
                    $this->session->set_flashdata('message', 'Product created successfully');
                } else {                        
                    $this->session->set_flashdata('error', 'ERROR !');
                }
            }
        }else{            
            $this->session->set_flashdata('error', 'ERROR !, Already Exist');
        }   
        redirect("inventory/newproductmat");
    } 
    
    /*Remove variants material - Temporary (change status as inactive) */
    public function common_function_change_status() {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $table = isset($_POST['source']) ? $_POST['source']:'';
        $status = isset($_POST['status']) ? $_POST['status']:'';  //0 = Inactive
        $status_data = $this->inventory_model->updateRowData($table, array('id' => $id), array('status' => $status));
        echo json_encode($status_data);
    }
    
    /*Check material sku is exist or not */
    public function check_material_sku() {
        $sku = isset($_POST['sku']) ? $_POST['sku'] : '';
        //$checkVariants = $this->inventory_model->get_data_byId('material', 'mat_sku', $sku);
        $checkVariants = $this->inventory_model->get_filter_details('material', array('mat_sku' => $sku, 'status' => 1));
        echo !empty($checkVariants) ? '1':'0';
    }
    
    /*Remove variant with materials - Temporary (change status as inactive) */
    public function delete_variant(){
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $status = '0';  //0 = Inactive
            $where = array('product_code' => $id);
            $materials = $this->inventory_model->get_data('material', $where);
            if(!empty($materials)){
                foreach($materials as $material){
                    $mat_id = $material['id'];
                    $done = $this->inventory_model->updateRowData('material', array('id' => $mat_id), array('status' => $status));
                }
            }
            echo $success = $this->inventory_model->updateRowData('material_variants', array('id' => $id), array('status' => $status));
            return $success;
        }
    }
    
    /* Update material according to variants */
    function update_variant_materials(){
       
        $data = $this->input->post();
        $item_code = $data['item_code'];
        $temp_material_name = $data['temp_material_name'];
        $material_type = $data['material_type_id'];
        $sub_type = '';
        if(!empty($data['sub_type'])){
            $sub_type = preg_replace('/[ ,]+/', '-', $data['sub_type']);
        }
        $uom = $data['uom_type'];
        $hsn_code = $data['hsn_code'];
        $standard_packing = $data['standard_packing'];
        $tax = !empty($data['tax']) ? $data['tax'] : '';
        
        $tempMaterialData = [
          'material_type_id' => $material_type,
          'sub_type' => $sub_type,
          'uom_type' => $uom,
          'hsn_code' => $hsn_code,
          'standard_packing' => $standard_packing,
          'tax' => $tax,
        ];
        $counts = count($_POST['packing_mat']);
        $packing_arr = array();
        $j = 0;
        while ($j < $counts) {
            $packing_arr[$j]['packing_mat'] = $_POST['packing_mat'][$j];
            $packing_arr[$j]['packing_qty'] = $_POST['packing_qty'][$j];
            $packing_arr[$j]['stand_pack'] = $_POST['stand_pack'][$j];
            $packing_arr[$j]['packing_weight'] = $_POST['packing_weight'][$j];
            $packing_arr[$j]['packing_cbf'] = $_POST['packing_cbf'][$j];
            $j++;
        }
        $variants['item_code'] = $item_code;
        $variants['temp_material_name'] = $temp_material_name;
        $variants['temp_material_data'] = json_encode($tempMaterialData);
        $variants['packing_data'] = json_encode($packing_arr);
		
		
		// pre($variants);die();
		
        if(!empty($data['id']))
        {
            #Check exist materials based on item code 
            $checkMaterials = $this->inventory_model->get_filter_details('material', array('material_code' => $item_code));
            $totalExists = !empty($checkMaterials) ? count($checkMaterials):0;

            #Check material's barcode saved or blank
            $material = $this->inventory_model->get_data_byId('material', 'id', $item_code);
            $bar_code = !empty($material) ? $material->bar_code:'';

            #Get variants data
            $variantsData = $this->inventory_model->get_data_byId('material_variants', 'id', $data['id']);
            $encoded = !empty($variantsData->variants_data) ? json_decode($variantsData->variants_data, true):'';
            $variant_key = !empty($encoded['variant_key']) ? $encoded['variant_key']:array();
            $variantKeyCount = count($variant_key);
            
            # Save new materials according to variants
            $sale_pur = array('Sale');
            $sale_purchase = json_encode($sale_pur);
            $i = 0; 
            foreach($data['new_material'] as $key => $temp)
            {
                $last_id = getLastTableId('material');
                $rId = $last_id + $i;
                $matCode = 'MAT_'.rand(1, 1000000).'_'.$rId;
                
                $tempname = '';
                for($t=0; $t<=$variantKeyCount; $t++){
                    $variantKey = $variant_key[$t][0];
                    $variantValue = !empty($data[$variantKey][$key]) ? $data[$variantKey][$key] : '';
                    $tempname .= $variantValue.'_';
                }
                $material_name = $temp_material_name.'_'.$tempname;
                $materialName = rtrim($material_name,"_");
				
				

                ############### Material Array ################
                $inserdata[$i]['item_code'] = $item_code;
                $inserdata[$i]['material_code'] = $matCode;   
                $inserdata[$i]['product_code'] = $data['id'];                                   
                $inserdata[$i]['material_type_id'] = $material_type;
                $inserdata[$i]['material_name'] = $materialName;
                $inserdata[$i]['MatAliasName'] = $temp_material_name;
                $inserdata[$i]['mat_sku'] = $data['variant_sku'][$key];
                $inserdata[$i]['uom'] = $uom;
                $inserdata[$i]['sub_type'] = $sub_type;
                $inserdata[$i]['non_inventry_material'] = '0';
                $inserdata[$i]['sales_price'] = !empty($data['sales_price'][$key]) ? $data['sales_price'][$key] : '';                            
                $inserdata[$i]['sale_purchase'] = $sale_purchase;
                $inserdata[$i]['specification'] = !empty($data['specification']) ? $data['specification'] : '';
                $inserdata[$i]['hsn_code'] = $hsn_code;
                $inserdata[$i]['tax'] = $tax;
                $inserdata[$i]['save_status'] = '1';
                $inserdata[$i]['created_by'] = $_SESSION['loggedInUser']->u_id;
                $inserdata[$i]['created_by_cid'] = $this->companyId;

                #Generate barcode and save material accordingly                    
                $bar_code_text = 'V0'.$item_code.$totalExists;     #Barcode
                $size = '10';
                $orientation = "horizontal";
                $code_type = "code128";
                $print = "true";
                $sizefactor = "1";    
                $filepath = "assets/modules/inventory/barcode_img/".$bar_code_text.".png";                                    
                $barCode = $this->barcode( $filepath, $bar_code_text, $size, $orientation, $code_type, $print, $sizefactor );
                $inserdata[$i]['bar_code'] = $bar_code_text;       
                ####################################
                $i++;
            }
			
            $inserted = $this->inventory_model->importdata('material', $inserdata); 
              # Exist materials update
            $image_array = array();
            $img = 0;
            foreach($data['material_id'] as $trId => $matId)
            {    
                
                $material = $this->inventory_model->get_data_byId('material', 'id', $matId);
                $bar_code = !empty($material) ? $material->bar_code:'';

                $materialName = $data['material_name'][$matId];
                $explodeArray = !empty($materialName) ? explode('_', $materialName):array();
                
                # save coloums according to variants type 
                if(!empty($explodeArray)){
                    $tempname = '';
                    for($t=1; $t<=$variantKeyCount; $t++){
                        $variantKey = $variant_key[$t][0];
                        $existVariant = $explodeArray[$t];
                        $variantValue = !empty($data[$variantKey][$matId]) ? $data[$variantKey][$matId] : $existVariant;    //if variant value change then changed value otherwise saved value
                        $tempname .= $variantValue.'_';
                    }
                    $material_name = $temp_material_name.'_'.$tempname;
                    $materialName = rtrim($material_name,"_");
                }
                
                # save more coloums values according to variants type (after update variants)
                $explodeArrCount = count($explodeArray);
                $afterSkipFirst = ($explodeArrCount > 1) ? $explodeArrCount - 1:'';   //Skip first element from array (first element is main material name)
                if($variantKeyCount < $afterSkipFirst){
                    $extraColumn = $variantKeyCount - $afterSkipFirst;
                    $sameArrayCount = $variantKeyCount - $extraColumn;
                    $tempname = '';
                    for($t=1; $t<=$variantKeyCount; $t++){
                        if($t > $sameArrayCount){
                            $variantKey = $variant_key[$t][0];
                            $variantValue = $data[$variantKey][$matId];
                            $tempname .= $variantValue.'_';
                        }
                    }
                    $material_name = $temp_material_name.'_'.$tempname;
                    //$materialName = substr($material_name, 0, -1);
                    $materialName = rtrim($material_name,"_");
                }
                $material_name = $materialName; 
                                
                ############### Material Array ################
                $updatem['product_code'] = $data['id'];   
                $updatem['material_type_id'] = $material_type;
                $updatem['material_name'] = $material_name;
                $updatem['MatAliasName'] = $temp_material_name;
                $updatem['mat_sku'] = $data['variant_sku'][$matId];
                $updatem['uom'] = $uom;
                $updatem['sub_type'] = $sub_type;
                $updatem['sales_price'] = !empty($data['sales_price'][$matId]) ? $data['sales_price'][$matId] : '';                            
                $updatem['specification'] = !empty($data['specification']) ? $data['specification'] : '';
                $updatem['hsn_code'] = $hsn_code;
                $updatem['tax'] = $tax; 
                $updatem['standard_packing'] = $standard_packing;
                $updatem['packing_data'] = json_encode($packing_arr); 
                $updatem['item_code'] = $item_code;
                #Generate barcode and update according to material, if barcode not saved           
                if(empty($bar_code)){
                    $bar_code_text = 'V0'.$item_code.$matId;      #Barcode
                    $size = '10';
                    $orientation = "horizontal";
                    $code_type = "code128";
                    $print = "true";
                    $sizefactor = "1";    
                    $filepath = "assets/modules/inventory/barcode_img/".$bar_code_text.".png";                                    
                    $barCode = $this->barcode( $filepath, $bar_code_text, $size, $orientation, $code_type, $print, $sizefactor ); 
                    $updatem['bar_code'] = $bar_code_text;
                }   



			
                $updated = $this->inventory_model->updateRowData('material',array('id' => $matId), $updatem);
				$this->sellingPriceHistory($matId, $updatem['sales_price']);
                #pre($updatem);
                if (!empty($_FILES['materialImage']['name']) && $_FILES['materialImage']['name'] != '') {
                            $filename = $_FILES['materialImage']['name'];
                            $tmpname = $_FILES['materialImage']['tmp_name'];
                            $type = $_FILES['materialImage']['type'];
                            $error = $_FILES['materialImage']['error'];
                            $size = $_FILES['materialImage']['size'];
                            // $exp = explode('.', $filename);
                            // $ext = end($exp);
                            // $newname = $exp[0] . '_' . time() . "." . $ext;
							$filename = str_replace(' ', '_', $filename);;
                            $config['upload_path'] = 'assets/modules/inventory/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/inventory/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $filename;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/inventory/uploads/" . $filename);
                            $image_array[$img]['rel_id'] = $matId;
                            $image_array[$img]['rel_type'] = 'material';
                            $image_array[$img]['file_name'] = $filename;
                            $image_array[$img]['file_type'] = $type;
                    }
            $img++; }
			
			// die('dfw');	
        if (!empty($image_array)) {
        #Insert multiple file information into the database
			$material_image = $this->inventory_model->update_attachment_data('attachments', $image_array, 'material');
        } 
		
		
	// pre($variants);	
 // die();		
            $updatevariants = $this->inventory_model->updateRowData('material_variants',array('id' => $data['id']), $variants);

            if (!empty($_FILES['materialImage']['name']) && $_FILES['materialImage']['name'] != '') {
                            $filename = $_FILES['materialImage']['name'];
                            $tmpname = $_FILES['materialImage']['tmp_name'];
                            $type = $_FILES['materialImage']['type'];
                            $error = $_FILES['materialImage']['error'];
                            $size = $_FILES['materialImage']['size'];
                            // $exp = explode('.', $filename);
                            // $ext = end($exp);
                            // $newname = $exp[0] . '_' . time() . "." . $ext;
							$filename = str_replace(' ', '_', $filename);;
                            $config['upload_path'] = 'assets/modules/inventory/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/inventory/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $filename;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/inventory/uploads/" . $filename);
                            $image_array1['rel_id'] = $data['id'];
                            $image_array1['rel_type'] = 'material';
                            $image_array1['file_name'] = $filename;
                            $image_array1['file_type'] = $type;
                          if (!empty($image_array1)) {
                            #Insert multiple file information into the database
                           // $material_image = $this->inventory_model->insert_single_attachment_data('attachments', $image_array1, 'material');
                        }
                    } 
					$this->session->set_flashdata('message', 'Product successfully updated');
					// pre($updated);
					// pre($inserted);
					// die();
					// if($updated || $inserted){ 
						// $this->session->set_flashdata('message', 'Product successfully updated');
					// } else {                        
						// $this->session->set_flashdata('error', 'ERROR !');
					// }
			}
				redirect("inventory/newproductmat");        
		} 
    
    // Add/Edit/View Material 
    public function variantmat(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $this->settings['pageTitle'] = 'Edit variant product';
            $this->data['variants'] = $this->inventory_model->get_data_byId('material_variants', 'id', $id);    
            $where = array('created_by_cid' => $this->companyId, 'status' => 1, 'product_code' => $id, 'non_inventry_material' => 0);
			
            $this->data['materials'] = $this->inventory_model->get_data('material', $where);
            $view = 'newproductmat/edit';
        } 
        elseif(isset($_GET['view'])){
            $id = $_GET['view'];
            $this->data['variants'] = $this->inventory_model->get_data_byId('material_variants', 'id', $id);    
            $where = array('created_by_cid' => $this->companyId, 'status' => 1, 'product_code' => $id, 'non_inventry_material' => 0);
            $this->data['materials'] = $this->inventory_model->get_data('material', $where);
            $view = 'newproductmat/view';
        }else{
            $this->settings['pageTitle'] = 'Add new variant product';
            $view = 'newproductmat/add';
        }                   
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();   
        $this->_render_template($view, $this->data);
    } 
    
    # Create Barcode function
    function barcode($filepath="", $text="0", $size="20", $orientation="horizontal", $code_type="code128", $print=false, $SizeFactor=1 ){       
        $code_string = "";
        // Translate the $text into barcode the correct $code_type
        if ( in_array(strtolower($code_type), array("code128", "code128b")) ) {
            $chksum = 104;
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","\`"=>"111422","a"=>"121124","b"=>"121421","c"=>"141122","d"=>"141221","e"=>"112214","f"=>"112412","g"=>"122114","h"=>"122411","i"=>"142112","j"=>"142211","k"=>"241211","l"=>"221114","m"=>"413111","n"=>"241112","o"=>"134111","p"=>"111242","q"=>"121142","r"=>"121241","s"=>"114212","t"=>"124112","u"=>"124211","v"=>"411212","w"=>"421112","x"=>"421211","y"=>"212141","z"=>"214121","{"=>"412121","|"=>"111143","}"=>"111341","~"=>"131141","DEL"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","FNC 4"=>"114131","CODE A"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ( $X = 1; $X <= strlen($text); $X++ ) {
                $activeKey = substr( $text, ($X-1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum=($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];
    
            $code_string = "211214" . $code_string . "2331112";
        } elseif ( strtolower($code_type) == "code128a" ) {
            $chksum = 103;
            $text = strtoupper($text); // Code 128A doesn't support lower case
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","NUL"=>"111422","SOH"=>"121124","STX"=>"121421","ETX"=>"141122","EOT"=>"141221","ENQ"=>"112214","ACK"=>"112412","BEL"=>"122114","BS"=>"122411","HT"=>"142112","LF"=>"142211","VT"=>"241211","FF"=>"221114","CR"=>"413111","SO"=>"241112","SI"=>"134111","DLE"=>"111242","DC1"=>"121142","DC2"=>"121241","DC3"=>"114212","DC4"=>"124112","NAK"=>"124211","SYN"=>"411212","ETB"=>"421112","CAN"=>"421211","EM"=>"212141","SUB"=>"214121","ESC"=>"412121","FS"=>"111143","GS"=>"111341","RS"=>"131141","US"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","CODE B"=>"114131","FNC 4"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ( $X = 1; $X <= strlen($text); $X++ ) {
                $activeKey = substr( $text, ($X-1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum=($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];
    
            $code_string = "211412" . $code_string . "2331112";
        } elseif ( strtolower($code_type) == "code39" ) {
            $code_array = array("0"=>"111221211","1"=>"211211112","2"=>"112211112","3"=>"212211111","4"=>"111221112","5"=>"211221111","6"=>"112221111","7"=>"111211212","8"=>"211211211","9"=>"112211211","A"=>"211112112","B"=>"112112112","C"=>"212112111","D"=>"111122112","E"=>"211122111","F"=>"112122111","G"=>"111112212","H"=>"211112211","I"=>"112112211","J"=>"111122211","K"=>"211111122","L"=>"112111122","M"=>"212111121","N"=>"111121122","O"=>"211121121","P"=>"112121121","Q"=>"111111222","R"=>"211111221","S"=>"112111221","T"=>"111121221","U"=>"221111112","V"=>"122111112","W"=>"222111111","X"=>"121121112","Y"=>"221121111","Z"=>"122121111","-"=>"121111212","."=>"221111211"," "=>"122111211","$"=>"121212111","/"=>"121211121","+"=>"121112121","%"=>"111212121","*"=>"121121211");
    
            // Convert to uppercase
            $upper_text = strtoupper($text);
    
            for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
                $code_string .= $code_array[substr( $upper_text, ($X-1), 1)] . "1";
            }
    
            $code_string = "1211212111" . $code_string . "121121211";
        } elseif ( strtolower($code_type) == "code25" ) {
            $code_array1 = array("1","2","3","4","5","6","7","8","9","0");
            $code_array2 = array("3-1-1-1-3","1-3-1-1-3","3-3-1-1-1","1-1-3-1-3","3-1-3-1-1","1-3-3-1-1","1-1-1-3-3","3-1-1-3-1","1-3-1-3-1","1-1-3-3-1");
    
            for ( $X = 1; $X <= strlen($text); $X++ ) {
                for ( $Y = 0; $Y < count($code_array1); $Y++ ) {
                    if ( substr($text, ($X-1), 1) == $code_array1[$Y] )
                        $temp[$X] = $code_array2[$Y];
                }
            }
    
            for ( $X=1; $X<=strlen($text); $X+=2 ) {
                if ( isset($temp[$X]) && isset($temp[($X + 1)]) ) {
                    $temp1 = explode( "-", $temp[$X] );
                    $temp2 = explode( "-", $temp[($X + 1)] );
                    for ( $Y = 0; $Y < count($temp1); $Y++ )
                        $code_string .= $temp1[$Y] . $temp2[$Y];
                }
            }
    
            $code_string = "1111" . $code_string . "311";
        } elseif ( strtolower($code_type) == "codabar" ) {
            $code_array1 = array("1","2","3","4","5","6","7","8","9","0","-","$",":","/",".","+","A","B","C","D");
            $code_array2 = array("1111221","1112112","2211111","1121121","2111121","1211112","1211211","1221111","2112111","1111122","1112211","1122111","2111212","2121112","2121211","1121212","1122121","1212112","1112122","1112221");
    
            // Convert to uppercase
            $upper_text = strtoupper($text);    
            for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
                for ( $Y = 0; $Y<count($code_array1); $Y++ ) {
                    if ( substr($upper_text, ($X-1), 1) == $code_array1[$Y] )
                        $code_string .= $code_array2[$Y] . "1";
                }
            }
            $code_string = "11221211" . $code_string . "1122121";
        }
    
        // Pad the edges of the barcode
        $code_length = 20;
        if ($print) {
            $text_height = 30;
        } else {
            $text_height = 0;
        }
        
        for ( $i=1; $i <= strlen($code_string); $i++ ){
            $code_length = $code_length + (integer)(substr($code_string,($i-1),1));
            }
    
        if ( strtolower($orientation) == "horizontal" ) {
            $img_width = $code_length*$SizeFactor;
            $img_height = $size;
        } else {
            $img_width = $size;
            $img_height = $code_length*$SizeFactor;
        }
    
        $image = imagecreate($img_width, $img_height + $text_height);
        $black = imagecolorallocate ($image, 0, 0, 0);
        $white = imagecolorallocate ($image, 255, 255, 255);
    
        imagefill( $image, 0, 0, $white );
        if ($print){
            imagestring($image, 5, 31, $img_height, $text, $black );
        }
    
        $location = 10;
        for ( $position = 1 ; $position <= strlen($code_string); $position++ ) {
            $cur_size = $location + ( substr($code_string, ($position-1), 1) );
            if ( strtolower($orientation) == "horizontal" )
                imagefilledrectangle( $image, $location*$SizeFactor, 0, $cur_size*$SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black) );
            else
                imagefilledrectangle( $image, 0, $location*$SizeFactor, $img_width, $cur_size*$SizeFactor, ($position % 2 == 0 ? $white : $black) );
            $location = $cur_size;
        }
        
        // Draw barcode to the screen or save in a file        
        //pre($filepath);        
        // die();            
        if ($filepath=="" ){
            header ('Content-type: image/png');
            imagepng($image);
            imagedestroy($image);
        } else {
            imagepng($image,$filepath);
            imagedestroy($image);    
            echo 'success';                
        }        
    }

    #Finish Good Sticker Code start hear
    public function viewSticker(){
        $this->data['StickerData'] = $this->inventory_model->get_data_byId('finish_goods', 'id', $this->input->post('id'));
        $this->load->view('finish_goods/finishGoodSticker',$this->data);
    }        
    /*********************************************************************************/
     ######################### End - Variants Based Inventory #######################
    /********************************************************************************/    

    
     /*inventory listing Rejected*/
    public function inventoryRejected() {
        $id = $_POST['id'];
   
        $this->data['material_id'] = $id;
        $this->data['material_uom'] = $_POST['uom'];
        $this->data['inventoryListing'] = $this->inventory_model->get_data_byLocationId('mat_locations', 'material_name_id', $id);
       //$this->data['inventoryListing'] = $this->inventory_model->get_data_byId('material','id',$id);
        $this->data['materials_type'] = $this->inventory_model->get_data('material_type'); //get material type at the time of edit
        $this->data['company_address'] = $this->inventory_model->get_data('company_detail');
        $this->load->view('inventory_listing_and_adjustment/Rejected', $this->data);
    }
    /*inventory listingRejected*/
    
    
    public function rejectedQtyReport() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Rejected Quantity ', base_url() . 'rejectedQtyReport');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Rejected Quantity';
        $where = array(
            'created_by_cid' => $this->companyId,
            'action_type' => 'Rejected'
        );
        $this->data['rejectedQtyReport'] = $this->inventory_model->get_data('inventory_listing_adjustment',$where);
        $this->_render_template('rejectedQtyReport/index', $this->data);
    }
    
    
    /***Save Variant Types***/
    public function saveVariantType(){
     $data = $this->input->post();
     $where = array('varient_name' => $data['variant_type']);
     $variant = [
      'varient_name' => $data['variant_type']
     ];
     if(!empty($data['id'])){
        $success = $this->inventory_model->update_data('variant_types', $variant, 'id', $data['id']);
        if ($success) {
            $this->session->set_flashdata('message', 'Variant Type updated successfully');
        }
     } else {
        $chkVariantType = $this->inventory_model->get_data('variant_types', $where);
        if(empty($chkVariantType)){                          
          $this->inventory_model->insertData('variant_types', $variant);
          $this->session->set_flashdata('message', 'Variant Type Added successfully');
        } else {
          $this->session->set_flashdata('error', 'ERROR !, Already Exist');
        }   
     }
      
    redirect("inventory/inventory_setting");
    }   
    /***Save Variant Types***/
    
    /***Edit Variant Types***/
    public function editVariantType() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['variant_type'] = $this->inventory_model->get_data_byId('variant_types', 'id', $id);
        $this->load->view('inventory_setting/edit_varient_type', $this->data);
    }
    /***Edit Variant Types***/

    /***Save Variant Option***/
    public function saveVariantOption(){
    
    $data = $this->input->post();
    $filename                = $_FILES['varient_option_img']['name'];
    $tmpname                 = $_FILES['varient_option_img']['tmp_name'];
    $type                    = $_FILES['varient_option_img']['type'];
    $error                   = $_FILES['varient_option_img']['error'];
    $size                    = $_FILES['varient_option_img']['size'];
    $config['upload_path']   = 'assets/modules/inventory/varient_opt_img';
    $config['upload_url']    = base_url() . 'assets/modules/inventory/varient_opt_img';
    $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
    $config['max_size']      = '2000000';
	$filename = str_replace(' ', '_', $filename);;
    $config['file_name']     = $filename;
    $this->load->library('upload', $config);
    $variant_type = getNameById('variant_types',$data['variant_type'],'id');
    $where = array('variant_type_id' => $data['variant_type'], 'option_name' => $data['variant_option']);
	if(!empty($_POST['variant_opt_img_old']) && !empty($_FILES)){
				$filename = $_POST['variant_opt_img_old'];
		
	}
	
	
	// pre($_FILES);
	
	 
		 $variant = [
		  'variant_type_id' => $data['variant_type'],
		  'variant_type_name' => $variant_type->varient_name,
		  'option_name' => $data['variant_option'],
		  'option_img_name' => $filename
		 ];
	
	 
     if(!empty($data['id'])){
		   
		   
		    if($_FILES['varient_option_img']['name'] == ''){
				//die('if');
				move_uploaded_file($tmpname, "assets/modules/inventory/varient_opt_img/" . $filename);
				$success = $this->inventory_model->update_data('variant_options', $variant, 'id', $data['id']);
			}else{
				
				$variant = [
			  'variant_type_id' => $data['variant_type'],
			  'variant_type_name' => $variant_type->varient_name,
			  'option_name' => $data['variant_option'],
			  'option_img_name' => $_FILES['varient_option_img']['name']
			 ];
			 
			 
				move_uploaded_file($tmpname, "assets/modules/inventory/varient_opt_img/" . $_FILES['varient_option_img']['name']);
				$success = $this->inventory_model->update_data('variant_options', $variant, 'id', $data['id']);
			}
		  
        
        if ($success) {
            $this->session->set_flashdata('message', 'Variant Option updated successfully');
        }
     } else {
         $chkVariantOptions = $this->inventory_model->get_data('variant_options', $where);
         if(empty($chkVariantOptions)){                          
          $this->inventory_model->insertData('variant_options', $variant);
          $this->session->set_flashdata('message', 'Variant Option Added successfully');
         move_uploaded_file($tmpname, "assets/modules/inventory/varient_opt_img/" . $filename);
        } else {
          $this->session->set_flashdata('error', 'ERROR !, Already Exist');
        }   
     }
      
    redirect("inventory/inventory_setting");
    }
    /***Save Variant Option***/

    /***Edit Variant Option***/
    public function editVariantOption() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['variant_options'] = $this->inventory_model->get_data_byId('variant_options', 'id', $id);
        $this->load->view('inventory_setting/edit_varient_option', $this->data);
    }
    /***Edit Variant Option***/

    /***Save Stock Permission***/
    public function saveStockPermission(){
     $this->inventory_model->truncate_table('stock_permission');
     $data['stock_permission']= json_encode($_POST['stock_permission']);
     $this->inventory_model->insertData('stock_permission', $data);
     $this->session->set_flashdata('message', 'Stock Permission updated Successfully');
     redirect("inventory/inventory_setting");
    }   
    /***Save Stock Permission***/


     public function getcbf() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $mat_data = $this->inventory_model->get_data_byId('material', 'id', $id);
        echo $mat_data->total_cbf;
    }
	public function getvariants() {
        $varient_type_id = $_REQUEST['varient_type_id'];
        $variant = $this->inventory_model->getNameByIdVAriant('variant_options', $varient_type_id ,'variant_type_name' );
		 echo json_encode($variant,true);
    }

    /***Edit Variant Option***/
    public function convertToInventory() {
        $id = $_POST['id'];
        $this->data['convert_inventory'] = $this->inventory_model->get_data_byId('inventory_listing_adjustment', 'id', $id);
        $this->load->view('rejectedQtyReport/convert_inventory', $this->data);
    }
    /***Edit Variant Option***/
    /* Function to SAVE movement of inventory listing */
    public function updateRejInventory(){
         if ($this->input->post()) {
                $data = $this->input->post();
                $data['created_by'] = $_SESSION['loggedInUser']->id;
                $data['created_by_cid'] = $this->companyId;
                
                $id_loc = !empty($_POST['id_loc']) ? $_POST['id_loc']:'';
                // $yu = getNameById_mat('mat_locations',$data['material_name_id'],'material_name_id');
                 $yu = getNameById_matWithLoc('mat_locations',$data['material_name_id'],'material_name_id','location_id',$data['location']);
				
				
				
            $sum = 0;
            if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
            $closing_blnc = $sum + $data['quantityn'];
			
			
			
            // $updateDatalocation = (array('id' => $id_loc, 'location_id' => isset($_POST['location']) ? $_POST['location'] : '', 'Storage' => isset($_POST['storage']) ? $_POST['storage'] : '', 'RackNumber' => isset($_POST['rackNumber']) ? $_POST['rackNumber'] : '', 'lot_no' => isset($_POST['lotno']) ? $_POST['lotno']:'', 'quantity' => $closing_blnc, 'created_by_cid' => $this->companyId, 'material_type_id' => $data['material_type_id'], 'material_name_id' => $data['material_name_id']));
            $updateDatalocation = (array('id' => $id_loc, 'location_id' => isset($_POST['location']) ? $_POST['location'] : '', 'quantity' => $closing_blnc, 'created_by_cid' => $this->companyId, 'material_type_id' => $data['material_type_id'], 'material_name_id' => $data['material_name_id']));
            
            $convert_inventory[] = $this->inventory_model->get_data_byId('inventory_listing_adjustment', 'id', $data['inventory_id']);
            
            foreach($convert_inventory as  $forminusVal){
                
                
            
                $qqtty = $forminusVal->quantity  - $data['quantityn'];
                $adjmntData = array(
                                'id' => $forminusVal->id,
                                'material_type_id' => $forminusVal->material_type_id,
                                'material_name_id' => $forminusVal->material_name_id,
                                'date' => $forminusVal->date,
                                'action_type' => $forminusVal->action_type,
                                'quantity' => $qqtty,
                                'converted_material_id' => $forminusVal->converted_material_id,
                                'uom' => $forminusVal->uom,
                                'source_address' => $forminusVal->source_address,
                                'destination_address' => $forminusVal->destination_address,
                                'reason' => $forminusVal->reason,
                                'scrapIntoMaterial_id' => $forminusVal->scrapIntoMaterial_id,
                                'ScrapUom' => $forminusVal->ScrapUom,
                                'party_name' => $forminusVal->party_name,
                                'half_or_full_book' => $forminusVal->half_or_full_book,
                                'location_id' => $forminusVal->location_id,
                                'physical_stock_check' => $forminusVal->physical_stock_check,
                                'created_date' => $forminusVal->created_date,
                                'modified_date' => $forminusVal->modified_date,
                                'created_by_cid' => $this->companyId,
                            );
                            
                             
            }
			// pre($updateDatalocation);
			
			// die();
                if($adjmntData['quantity'] == 0){
                    $this->inventory_model->delete_rejected_inv('inventory_listing_adjustment', 'id', $adjmntData['id']);
                }
            
            // $convert_inventory->quantity - $data['quantityn'];
            $adjustment_data = json_decode(json_encode($adjmntData), true);
              
               
            

            $result = $this->inventory_model->get_data('mat_locations', array('material_name_id' => $data['material_name_id'],'location_id'=>$data['location']));
			
			
            
            if(!empty($result)){
                $inventoryFlowDataArray = array();
                foreach($result as $rows){
                    $materialId = $rows['material_name_id'];
                    $material_type = $rows['material_type_id'];
                    $quantity = $rows['quantity'];
					
									
					$yu = getNameById_matWithLoc('mat_locations',$rows['material_name_id'],'material_name_id','location_id',$rows['location']);
                    $sum = 0;
                    if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                    $closing_blnc = $sum - $quantity;

                    $arr =  json_encode(array(array('location' => $rows['location_id'],'Storage' => $rows['Storage'], 'RackNumber' => $rows['RackNumber'], 'quantity' => $rows['quantity'], 'Qtyuom' => $rows['Qtyuom'])));
                    $inventoryFlowDataArray['material_id'] = $materialId;
                    $inventoryFlowDataArray['material_in'] = $data['quantityn'];
                    $inventoryFlowDataArray['closing_blnc'] = $data['quantityn'] + $quantity;
                    $inventoryFlowDataArray['opening_blnc'] = $quantity ;
                    $inventoryFlowDataArray['uom'] = $rows['Qtyuom'];
                    $inventoryFlowDataArray['through'] = 'From Rejected Mat.';
                    $inventoryFlowDataArray['ref_id'] = $rows['id'];
                    $inventoryFlowDataArray['created_by'] = $_SESSION['loggedInUser']->id;
                    $inventoryFlowDataArray['created_by_cid'] = $this->companyId;
                    
                       // pre($inventoryFlowDataArray);
                    $insert = $this->inventory_model->insert_tbl_data('inventory_flow', $inventoryFlowDataArray);
                }
            }   






            
              // die();
            $this->inventory_model->update_single_field_adj('inventory_listing_adjustment', $adjustment_data, $data['material_name_id'], $data['inventory_id']);
            $updateSuccess = $this->inventory_model->update_single_field_mat('mat_locations', $updateDatalocation, $data['material_name_id'], $id_loc);
            $this->session->set_flashdata('message', 'Data inserted successfully');
            redirect(base_url() . 'inventory/rejectedQtyReport', 'refresh');
        }
    }






    // Selling Price History
     public function sellingPriceHistory($id, $salesPrice){
        $material_type_id = $id;
		
		// pre($salesPrice);
		// pre($id);
		
		
		// die();

        $existSalesPrice = $this->inventory_model->getSalePrice('material_old_price','material_type_id',$material_type_id);

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
            $insertSalesPrice = $this->inventory_model->insert_tbl_data('material_old_price', $data);
            return $insertSalesPrice;
                      }
               }
        }else{
            $data['material_type_id']=$id;
            $data['old_sales_price']=$salesPrice;
            $data['new_sales_price']=$salesPrice;
            $data['created_by']=$_SESSION['loggedInUser']->id;
			
			
             
            $insertSalesPrice = $this->inventory_model->insert_tbl_data('material_old_price', $data);
            return $insertSalesPrice;
            
        }
        //     if($id && $id != ''){
        //     $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
        //     $updateSalesPrice = $this->inventory_model->update_data('material_old_price', $data, 'id', $id);
        //     return $updateSalesPrice;
        // }else{
            
        // }
        
    }

    public function sale_price_updation() {
    $this->data['can_edit'] = edit_permissions();
    $this->data['can_delete'] = delete_permissions();
    $this->data['can_add'] = add_permissions();
    $this->breadcrumb->add('Create', base_url() . 'Create');
    $this->settings['breadcrumbs'] = $this->breadcrumb->output();
    $this->settings['pageTitle'] = 'Sale Price Updation Percentage';
    $a = '["Sale"]';
    $wheretask = "`sale_purchase`='{$a}' AND `created_by_cid` = '{$this->companyId}' ORDER BY `id` DESC";
    $this->data['materialSale'] = $this->inventory_model->get_worker_data('material', $wheretask);
    $this->_render_template('sale_price_updation/index', $this->data);
}
    public function saveSalePriceUpdation() {
            $matarray = array();
            foreach($_POST as $key => $val){
                $matarray = $val;
            } 
            foreach($matarray as $matkey => $matPriceval){
                    $updateData = array('sales_price' => $matPriceval);
                    $update = $this->inventory_model->update_materialPrice('material', $updateData, 'id',$matkey);
					$this->sellingPriceHistory($matkey, $matPriceval);
                }
            $this->session->set_flashdata('message', 'Price Change successful');
            redirect(base_url() . 'inventory/sale_price_updation', 'refresh');
    }
    
    
    
    public function reorder_level() {
    $this->load->library('pagination');
    $this->data['can_edit'] = edit_permissions();
    $this->data['can_delete'] = delete_permissions();
    $this->data['can_add'] = add_permissions();
    $this->data['can_view'] = view_permissions();
    $this->breadcrumb->add('Reorder Level List', base_url() . 'inventory/dashboard');
    $this->breadcrumb->add('Reorder Level List', base_url() . 'inventory/reorder_level');
    $this->settings['breadcrumbs'] = $this->breadcrumb->output();
    $this->settings['pageTitle'] = 'Reorder Level List';
    $where2 = '';
    $search_string = '';
    if (!empty($_POST['search'])) {
            $search_string = $_POST['search'];
            $materialName=getNameById('material',$search_string,'material_name');
            $material_type_tt = getNameById('material_type',$search_string,'name');
        if($material_type_tt->id !=''){
                $where2 = "material.material_type_id = '" . $material_type_tt->id . "'";    
            }elseif($materialName->id != '' && $material_type_tt->id ==''){
                $where2 = "material.id= '" . $materialName->id . "'" ;
                //$where2="material.material_name Like '"%.$_GET['search'].%"'";
            }else{
            $where2 ="(material.id = '".$search_string ."' or material.material_code ='" . $search_string ."')";
            }
            redirect("inventory/reorder_level/?search=$search_string");
        } elseif(isset($_GET['search']) && $_GET['search'] != '') {
            $where2=array();
            $material_type_tt = getNameBySearch('material_type',$_GET['search'],'name');
            foreach($material_type_tt as $materialtypedata){//pre($materialtypedata['id']);
               $where2[]="material.material_type_id ='".$materialtypedata['id']."'" ;
            }
            //print_r($where2);
            if(sizeof($where2)!=''){
            $where2=implode("||",$where2);
            }else{
            $where2 ="(material.material_code ='".$_GET['search']."' or material_name like '%".$_GET['search']."%' or material.id ='" . $_GET['search']."')";
            }
}

    if (!empty($_POST['order'])) {
        $order = $_POST['order'];
    } else {
        $order = "desc";
    }
    $where12 = "material.created_by_cid = '". $this->companyId."' and material.status=1 AND material.closing_balance < material.min_inventory";
    // pre($where12);

    if(isset($_GET['ExportType'])!='' OR isset($_GET['search'])==''){
            $where12 = "material.created_by_cid = '". $this->companyId."'and material.status=1 and material.non_inventry_material=0 AND material.closing_balance < material.min_inventory";
    }

    //Pagination
    $config = array();
    $config["base_url"] = base_url() . "inventory/reorder_level/";
    $config["total_rows"] = $this->inventory_model->num_rows('material', $where12, $where2);
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
 
    $reorder_lvl = $this->inventory_model->get_data1('material', $where12, $config["per_page"], $page, $where2, $order,$export_data);
    
    // pre($reorder_lvl);
    $m = 0;
    foreach($reorder_lvl as $lvl){
        $where_type = "id = " . $lvl['material_type_id'];
        $temp_type = $this->inventory_model->get_one_field('material_type', 'name', $where_type);
        $reorder_lvl[$m]['product_type'] = $temp_type[0]->name;
        $m++;
    }
   // pre($reorder_lvl); 

    $whereMaterialType = "(created_by_cid ='" . $this->companyId . "' OR created_by_cid =0) AND mrn_or_not = 0";
    $purchaseIndant = $this->inventory_model->get_filter_details('purchase_indent', $whereMaterialType);
$materialQty=[];
foreach ($purchaseIndant as $key => $purchaseIndantvalue) {
     $material_name=json_decode($purchaseIndantvalue['material_name']);
   
     foreach($material_name as $material_namevl){
           
          $materialQty[$material_namevl->material_name_id][]=$material_namevl; 
     }
}
     
    $this->data['reorder_level'] = $reorder_lvl;
    $this->data['reordepurchase'] = $materialQty;
    
    $whereMaterialType = "(created_by_cid ='" . $this->companyId . "' OR created_by_cid =0) AND status = 1";
    $this->data['mat_type'] = $this->inventory_model->get_filter_details('material_type', $whereMaterialType);
        if(!empty($this->uri->segment(3))){
            $frt = (int)$this->uri->segment(3) - 1;
            $start= $frt * $config['per_page']+1;
          }else{
           $start= (int)$this->uri->segment(3) * $config['per_page']+1;
        }
       
       if(!empty($this->uri->segment(3))){
           $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
       }else{
          $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
       }
        if($end>$config['total_rows'])
        {
        $total=$config['total_rows'];   
        }else{
        $total=$end;        
        }
    $this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';        
    $this->_render_template('reorder_level/index', $this->data);
}
    
    
    
    
    /*Create Indent */
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
        $workorder  = $this->inventory_model->get_worker_data('work_order',$where);
         $proDetail=  json_decode($workorder[0]['product_detail']);

           $job_card =[];
          foreach ($proDetail as  $revalue) {
              // $jobcard[] =$revalue->job_card;
                $where="'{$revalue->job_card}'";
                $jobCardDetails         =  $this->inventory_model->get_worker_dataIN('job_card','job_card_no',$where);
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
        $this->_render_template('reorder_level/reorder_purchaseIndent', $this->data);

        }else{
        $this->load->view('reorder_level/reorder_purchaseIndent', $this->data);
    }
    }

    public function saveIndent() {
        $approved = "";
        
        // $work_order_id=$_POST['sale_order_id'];
        // $successss = $this->purchase_model->update_data('work_order', ['work_order_material_status' => '3' ], 'id', $work_order_id);

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
                $jsonArrayObject = (array('material_type_id' => $_POST['material_type_id'][$i],'material_name_id' => $_POST['material_name'][$i],'hsnCode' => $_POST['hsnCode'][$i], 'description' => $str_descr, 'quantity' => $_POST['quantity'][$i], 'uom' => $_POST['uom'][$i], 'expected_amount' => $_POST['price'][$i], 'purpose' => $_POST['purpose'][$i], 'sub_total' => $_POST['total'][$i], 'remaning_qty' => $_POST['quantity'][$i],'aliasname' => $_POST['aliasname'][$i]));
				
				
				
				
                $arr[$i] = $jsonArrayObject;
                $i++;
            }
            //remaning_qty ==> if remaning_qty is 0 means its complete PI
            $material_array = json_encode($arr);
        } else {
            $material_array = '';
        }

        if ($this->input->post()) {
            $required_fields = array('material_name');
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
                    // $work_order_id=$_POST['work_order_id'];
        // $successss = $this->purchase_model->update_data('work_order',['work_order_material_status' => '3' ], 'id', $work_order_id);

                    if( !empty($approved) ){
                        $data = array_merge($data,['approve' => 1]);
                    }
                    // pre($data);die();
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
							$newname = str_replace(' ', '_', $newname);;
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
                redirect(base_url() . 'inventory/reorder_level', 'refresh');
            }
        }
    }
    /*Create Indent */
    
    
    
    
    public function qualityFormatType(){
         $data = [];
         if( $_POST['type'] == 'createFromat' ){
             $select = "crm.*,crm.id as crmId,material.material_name,material.id as matId";
             $joinTables      = ['material' => 'material.id = crm.report_for'];
             $where = ['report_for' => $this->input->post('matId') ];
             $data['result'] = $this->inventory_model->joinTables($select,'quality_control as crm',$joinTables,$where);
             if( $data ){
                 $data['result'] = $data['result'][0];
                 $data['parameterData'] = $this->inventory_model->joinTables('quality_control_trans.*,quality_control_trans.id as crtId','quality_control_trans',[],['report_id' => $data['result']['crmId'] ]);
                 if( !isset($data['result']['matId']) ){
                     $data['result'] = ['matId' => $this->input->post('matId'),
                        'material_name' => getSingleAndWhere('material_name','material',['id' => $this->input->post('matId')]),
                    ];
                 }
             }
             echo $this->load->view('quality/add_report',$data);
         }else{
             $result = $this->inventory_model->joinTables($select,'quality_control as qty',[],[]);
             $matId = $_POST['matId'];
             if( $result ){
                $formBaseUrl = base_url('inventory/inventoryQualityReportLink');
                $table =  "<form action='{$formBaseUrl}' method='POST'><div>";
                $table .= "<input type='hidden' value='{$matId}' name='matId' />";
                $table .= '<table class="table">';
                $table .= '<thead>';
                $table .= '<tr>
                            <th>Report Name</th>
                            <th>Select</th>
                            </tr>
                            </thead>';
                $table .= '<tbody>';
                foreach ($result as $key => $value) {
                        $table .= "<tr>
                        <td>{$value['report_name']}</td>
                        <td><input type='radio' name='selectedReportId' value='{$value['id']}' /></td>
                        </tr>";
                }
                $table .= '</tbody>';
                $table .= '</table>';
                $table .= '</div>';
                $table .= '<div>';
                $table .= '<input type="submit" value="Submit" class="btn btn-success">';
                $table .= '</form></div>';

             }
             echo $table;
         }
     }

     public function inventoryQualityReport(){

         $data = ['report_name' => $_POST['report_name'],'observations' => $_POST['observations'],
         'per_lot_of' => $_POST['per_lot_of'],'uom' => $_POST['uom'],'type' => $_POST['report_chk'],
         'report_for' => $_POST['matId'],'created_by_cid' => $_SESSION['loggedInUser']->c_id,'created_by' => $_SESSION['loggedInUser']->u_id ];
         if( !empty($_POST['reportId']) ){
             $this->inventory_model->updateRowData('quality_control',['id' => $_POST['reportId'] ],$data);
             $insertId = $_POST['reportId'];
             $setFlashMsg = "Updated";
         }else{
             $insertId = $this->inventory_model->insertData('quality_control',$data);
             $setFlashMsg = "Insert";
         }

         if( !empty($_POST['report']) ){
             $this->inventory_model->delete_data('quality_control_trans','report_id',$_POST['reportId']);
             foreach ($_POST['report'] as $key => $value) {
                 $value = $value + ['report_id' => $insertId ];
                 $this->inventory_model->insertData('quality_control_trans',$value);
             }
         }
         $this->session->set_flashdata('message',"Quality Format Successfully {$setFlashMsg}");
         redirect("inventory/material_edit?id={$_POST['matId']}");
     }

     public function inventoryQualityReportLink(){
         $qId = getSingleAndWhere('id','quality_control',['report_for' => $_POST['matId']]);
         $this->inventory_model->delete_data('quality_control','report_for',$_POST['matId']);
         $this->inventory_model->delete_data('quality_control_trans','report_id',$qId);

         $select = "quality_control.*,quality_control.id as qtcId";
         $data = $this->inventory_model->joinTables($select,'quality_control',[],['id' => $this->input->post('selectedReportId') ]);
         if( $data ){
             $parameterData = $this->inventory_model->joinTables('quality_control_trans.*,quality_control_trans.id as crtId','quality_control_trans',[],['report_id' => $this->input->post('selectedReportId') ]);
         }
         unset($data[0]['id'],$data[0]['created_date'],$data[0]['created_by_cid'],
         $data[0]['created_by'],$data[0]['qtcId'],$data[0]['report_name'],$data[0]['report_for']);

          $rand = rand(1000,100000);
          $data = $data[0] + ['report_for' => $_POST['matId'],'report_name' => "Report_{$rand}",
                                'created_by_cid' => $_SESSION['loggedInUser']->c_id,
                                'created_by' => $_SESSION['loggedInUser']->u_id];
          $insertId = $this->inventory_model->insertData('quality_control',$data);
          if( $insertId ){
              foreach ($parameterData as $key => $value) {
                  unset($value['id'],$value['report_id'],$value['crtId']);
                  $value = $value + ['report_id' => $insertId ];
                  $this->inventory_model->insertData('quality_control_trans',$value);
              }
          }
          $this->session->set_flashdata('message',"Quality Format Successfully Create");
          redirect("inventory/material_edit?id={$_POST['matId']}");
     }
    
    
		public function inventory_debit_note(){
			$this->data['can_edit'] = edit_permissions();
			$this->data['can_delete'] = delete_permissions();
			$this->data['can_add'] = add_permissions();
			$this->data['can_view'] = view_permissions();
			$this->breadcrumb->add('Inventory DebitNote', base_url() . 'inventory/dashboard');
			$this->breadcrumb->add('Inventory DebitNote', base_url() . 'inventory/inventory_debit_note');
			$this->settings['breadcrumbs'] = $this->breadcrumb->output();
			$this->settings['pageTitle'] = 'Inventory DebitNote';
			
			$this->_render_template('rejectedQtyReport/DebitNote', $this->data);
		}
		
		public function inventory_purchasereturnDN(){
			$this->data['can_edit'] = edit_permissions();
			$this->data['can_delete'] = delete_permissions();
			$this->data['can_add'] = add_permissions();
			$this->data['can_view'] = view_permissions();
			$this->breadcrumb->add('Inventory Purchase Return', base_url() . 'inventory/dashboard');
			$this->breadcrumb->add('Inventory Purchase Return', base_url() . 'inventory/inventory_purchasereturnDN');
			$this->settings['breadcrumbs'] = $this->breadcrumb->output();
			$this->settings['pageTitle'] = 'Inventory Purchase Return';
			$this->_render_template('rejectedQtyReport/inventoryPurchase_Return', $this->data);
		}
    
    
    public function get_buyerstate(){
		 if(!empty($_REQUEST['buyerstate'])){
			
			$partyData = $this->inventory_model->get_ledger_data('ledger',array('id'=> $_REQUEST['buyerstate']));
			$data =  json_decode($partyData['mailing_address'],true);
			if(!empty($data)){
				echo $data[0]['mailing_state'];
			}else{
				echo '0';
			}	
		}
	}
    
    
    
    

} //main
