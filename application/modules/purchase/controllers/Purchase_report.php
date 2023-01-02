<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Purchase_report extends ERP_Controller {

    function __construct(){
        parent::__construct();
        is_login();
        $this->load->library('pagination');
        $this->load->library(['form_validation','pagination']);
        $this->load->helper(['purchase/purchase','import','table_tr']);
        $this->load->model('purchase_model');
        $this->load->model('account/account_model');
        $this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
        $this->settings['css'][] = 'assets/plugins/morris.js/morris.css';
        $this->settings['css'][] = 'assets/modules/purchase/css/style.css';
        $this->scripts['js'][] = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->scripts['js'][] = 'assets/plugins/Chart.js/dist/Chart.min.js';
        $this->scripts['js'][] = 'assets/plugins/raphael/raphael.min.js';
        $this->scripts['js'][] = 'assets/plugins/morris.js/morris.min.js';
        $this->scripts['js'][] = 'assets/plugins/echarts/dist/echarts.min.js';
        $this->scripts['css'][] = 'assets/plugins/font-awesome/css/font-awesome.min.css';
        $this->scripts['js'][] = 'assets/plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js';
        $this->scripts['js'][] = 'assets/modules/purchase/js/script.js';
        $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
    }

    function reports(){
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Purchase Report';

        $this->data['purchaseReport'] = $this->purchase_model->getDataByWhere('purchase_reports',[]);
        $this->_render_template('report/reports', $this->data);
    }

    function save_report(){
        $data = [];
        if ($_POST['id'] != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }

        if( $_POST['updateSubmit'] ){
            if( !empty($_POST['id'] )){
                if($_POST['updateSubmit']){
                    $dataUpdate = ['report_name' => ucfirst($_POST['report_name']),'description' => $_POST['description'],'status' => $_POST['status'],'created_by_cid' => $this->companyGroupId
                    ];
                    $this->purchase_model->update_single_field('purchase_reports',$data,'id',$_POST['id']);
                }

                $data['Existreport'] = $this->purchase_model->getDataByWhere('purchase_reports',['id' => $_POST['id'] ]);
                if( $data['Existreport'] ){
                    $data['Existreport'] = $data['Existreport'][0];
                    $data['Existreport'] = $data['Existreport'] + ['updateSubmit' => 1];
                }
            }else{
                $reportUrl = checkUrlExist('purchase_reports','url',$_POST['url']);
                $data = ['report_name' => ucfirst($_POST['report_name']),'description' => $_POST['description'],'status' => $_POST['status'],'url' => $reportUrl,'created_by_cid' => $this->companyGroupId,'parent' => $_POST['parent']??0
                 ];
                if( isset($_POST['parent']) ){
                    if( $_POST['parent'] == 'Select' ){
                        $orderId = $this->purchase_model->getNumRowPDB();
                        $menuData = ['title' => ucfirst($_POST['report_name']),'slug' => $_POST['url'],
                                    'url' => "purchase/purchase_report/report_type/{$_POST['url']}",'status' => 1,'parent_id' => 375,
                                        'order' => $orderId ];
                        $this->purchase_model->insertAllDetails('menus',$menuData);
                    }
                }

                $this->purchase_model->insertAllDetails('purchase_reports',$data);
                $msg = "Successfully Insert";
                $this->session->set_flashdata('message',$msg);
                redirect('purchase/purchase_report/reports');

            }
        }
        
        $data['purchaseReport'] = $this->purchase_model->getDataByWhere('purchase_reports',['parent' => 0 ]);
        $this->load->view('report/create_reports',$data);
    }

    function report_type(){

        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $slugId = $this->purchase_model->getDataByWhere('purchase_reports',['url' => $this->uri->segment(4) ]);
		
		// pre($slugId);

        if( $slugId[0]['id'] ){
            $this->data['purchaseReportType'] = $this->purchase_model->getDataByWhere('purchase_reports',['parent' => $slugId[0]['id'] ]);   
            $this->settings['pageTitle'] = $slugId[0]['report_name'];
        }

        $this->_render_template('report/report_list_type', $this->data);   

    }

    function supplier_material(){
        $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';
        
        $where = "created_by_cid = {$this->companyGroupId} ";

        if( !empty($_GET['material_type']) ){
            $materialType = '"material_type_id":"'.$_GET['material_type'].'"';
            $where .= " AND material_name_id LIKE '%{$materialType}%'";            
        }
        if( !empty($_GET['material_name']) ){
            $materialName = '"material_name":"'.$_GET['material_name'].'"';
            $where .= " AND material_name_id LIKE '%{$materialName}%'";            
        }
        if( !empty($_GET['supplier']) ){
            $where .= " AND id = {$_GET['supplier']}";            
        }

        $supplier = $this->purchase_model->getDataByWhere('supplier',$where,['id','desc']);
        $reportData = [];
        foreach ($supplier as $supplierKey => $supplierValue) {
            $supplierMaterial = json_decode($supplierValue['material_name_id'],true);
            foreach ($supplierMaterial as $materialKey => $materialValue ) {
                if( isset($materialValue['material_type_id']) != ""  ){

                    if( !empty($_GET['material_type']) ){
                        if($materialValue['material_type_id'] != $_GET['material_type'] ){
                            continue;
                        }                        
                    }

                    if( !empty($_GET['material_name']) ){
                        if($materialValue['material_name'] != $_GET['material_name'] ){
                            continue;
                        }                        
                    }

                    $materialTypeName = getSingleAndWhere('name','material_type',['id' => $materialValue['material_type_id'] ]);
                    $materialName = getSingleAndWhere('material_name','material',['id' => $materialValue['material_name'] ]);
                    $supplierName = getSingleAndWhere('name','supplier',['id' => $supplierValue['id'] ]);
                    
                    $reportData[$materialValue['material_type_id']]['material_type'] = ['material_type_id' => $materialValue['material_type_id'],'material_type_name' => $materialTypeName ];

                    $reportData[$materialValue['material_type_id']]['material_name'][$materialValue['material_name']] = ['material_name_id' => $materialValue['material_name'],'material_name' => $materialName ];  

                    $reportData[$materialValue['material_type_id']]['supplier'][] = ['supplier_id' => $supplierValue['id'],'supplier_name' => $supplierName,'price' => $materialValue['price'],'supplier_material_name_id' => $materialValue['material_name'],'material_type_id' => $materialValue['material_type_id'],'material_type_name' => $materialTypeName,'material_name_id' => $materialValue['material_name'],'material_name' => $materialName ];
                }
                
            }
        }
        $this->data['supplierMaterialName'] = $reportData;
        $this->data['supplier'] = $this->getAllSupplier();
        $this->_render_template('report/supplier_master_list/supplier_material_with_price', $this->data);        
    }

    function indent_convert_report(){
        $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';

        $where = "created_by_cid = {$this->companyGroupId} AND mrn_or_not = 1 AND po_or_not = 1";


        $purchaseIndent = $this->purchase_model->getDataByWhere('purchase_indent',$where,['id','desc'],['id','indent_code']); 

        $IndentAllCompleteData = [];
        if( $purchaseIndent ){
            foreach ($purchaseIndent as $indentKey => $indentValue) {
                    $IndentAllCompleteData[$indentKey]['indentData'] = ['indentId' => $indentValue['id'],'indentCode' => $indentValue['indent_code'] ];
                    $purchaseOrder = $this->purchase_model->getDataByWhere('purchase_order',['pi_id' => $indentValue['id'] ],['id','desc'],['id','order_code']);
                    foreach ($purchaseOrder as $orderKey => $orderValue) {
                        $IndentAllCompleteData[$indentKey]['indentData']['order'][$orderKey] = ['orderId' => $orderValue['id'],'orderCode' => $orderValue['order_code'] ];
                        $whereGrn = ['po_id' => $orderValue['id'] ];
                        if( !empty($_GET['payment_status']) ){
                            $payment_status = 1;
                            if( $_GET['payment_status'] == 2 ){
                                $payment_status = 0;
                            }
                            $whereGrn = $whereGrn + ['pay_or_not' => $payment_status ];
                        }
                        $grn = $this->purchase_model->getDataByWhere('mrn_detail',$whereGrn,['id','desc'],['id','bill_no','pay_or_not']);
                        foreach ($grn as $grnKey => $grnValue) {
                            $IndentAllCompleteData[$indentKey]['indentData']['order'][$orderKey]['grn'][$grnKey] = ['grnId' => $grnValue['id'],'bill_no' => $grnValue['bill_no'],'Payment' => ( $grnValue['pay_or_not'] )?'Paid':'Pending' ];
                        }
                    }

            }
        }

        $this->data['IndentAllCompleteData'] = $IndentAllCompleteData;

        $this->_render_template('report/indent_report/indent_convert_report', $this->data); 
    }

    function purchase_order_analysis(){
        $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';

        $tableJoins = ['supplier as sp' => 'sp.id = mrn.supplier_name','purchase_order as po' => 'po.id = mrn.po_id'];
        $where      = "mrn.created_by_cid = {$this->companyGroupId} AND mrn.po_id > 0";

        if( $_GET['supplier'] ){
            $where  .= " AND mrn.supplier_name = {$_GET['supplier']}";            
        }

        if( isset($_GET['material']) ){
            if( !empty($_GET['material']) ){
                $materialId = $_GET['material'];
                $jsonData = '"material_name_id":"'.$materialId.'"';
                $where  .= " AND mrn.material_name LIKE '%{$jsonData}%'";            
            }
        }

        if( $_GET['start_date'] && $_GET['end_date'] ){
            $start   = date('d-m-Y',strtotime($_GET['start_date']));
            $end     = date('d-m-Y',strtotime($_GET['end_date']));
            $where  .= " AND mrn.date BETWEEN '{$start}' AND '{$end}' ";            
        }

        $selected   = 'mrn.id as mrnId,po.order_code as poNo,po.id as poId,sp.supplier_code,sp.id as spId,mrn.date as orderDate,po.expected_delivery_date,mrn.material_name';
        $grnData    = $this->purchase_model->joinTables($selected,'mrn_detail as mrn',$tableJoins,$where,['mrn.id','desc']);
        $poAnalysis = $this->joinMaterialByData($grnData,$materialId);

        $this->data['poAnalysis'] = $poAnalysis;
        $this->data['supplier']   = $this->getAllSupplier();
        $this->data['material']   = $this->getAllMaterial();
        $this->_render_template('report/purchase_order_report/purchase_order_analysis', $this->data);        
    }


    function purchase_order_display(){
        $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';
        $materialId = "";
        $where      = "po.created_by_cid = {$this->companyGroupId}";

        if( $_GET['supplier'] ){
            $where  .= " AND po.supplier_name = {$_GET['supplier']}";            
        }

        if( isset($_GET['material']) ){
            if( !empty($_GET['material']) ){
                $materialId = $_GET['material'];
                $jsonData = '"material_name_id":"'.$materialId.'"';
                $where  .= " AND po.material_name LIKE '%{$jsonData}%'";            
            }
        }

        if( !empty($_GET['start']) && !empty($_GET['end']) ){
            $start = date('Y-m-d 00:00:00',strtotime($_GET['start']));
            $end = date('Y-m-d 00:00:00',strtotime($_GET['end']));
            $where .= " AND po.created_date BETWEEN '{$start}' AND '{$end}'";
        }

        if( !empty($_GET['search']) ){
            $searchOC = $searchSupplier = "";
            $search = $_GET['search'];
            $searchSupplier = $this->purchase_model->joinTables('id','supplier',[],"supplier_code = '{$search}'");
            $searchOC = $this->purchase_model->joinTables('id','purchase_order',[],"order_code = '{$search}'");
            if( !empty($searchSupplier) && isset($searchSupplier[0]['id']) && !empty($searchOC) && isset($searchOC[0]['id']) ){
                $searchSupplier = $searchSupplier[0]['id'];
                $searchOC = $searchOC[0]['id'];
                $where .= " AND (po.supplier_name = {$searchSupplier} OR po.id = {$searchOC}) ";
            }elseif(!empty($searchSupplier) && isset($searchSupplier[0]['id']) && empty($searchOC)){
                $searchSupplier = $searchSupplier[0]['id'];
                $where .= " AND (po.supplier_name = {$searchSupplier})";
            }elseif( !empty($searchOC) && isset($searchOC[0]['id']) && empty($searchSupplier) ){
                $searchOC = $searchOC[0]['id'];
                $where .= " AND (po.id = {$searchOC})";

            }
        }
        
        $selected   = 'po.id as poId,po.order_code as poNo,sp.supplier_code,sp.id as spId,po.expected_delivery_date,po.material_name,po.created_by as buyer';

        $tableJoins = ['supplier as sp' => 'sp.id = po.supplier_name'];
        $poData    = $this->purchase_model->joinTables($selected,'purchase_order as po',$tableJoins,$where,['po.id','desc'],[],'po.id');
        
       $poAnalysis = $this->joinMaterialByData($poData,$materialId);

        
        $this->data['poAnalysis'] = $poAnalysis;
        $this->data['material']   = $this->getAllMaterial();

        $this->_render_template('report/purchase_order_report/purchase_order_display', $this->data);        
    }

    function goods_receipt_forecast_report(){
        $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';
        $materialId = "";
        $where      = "po.created_by_cid = {$this->companyGroupId}";

        if( $_GET['supplier'] ){
            $where  .= " AND mrn.supplier_name = {$_GET['supplier']}";            
        }

        if( !empty($_GET['start']) && !empty($_GET['end']) ){
            $start = date('Y-m-d 00:00:00',strtotime($_GET['start']));
            $end = date('Y-m-d 00:00:00',strtotime($_GET['end']));
            $where .= " AND mrn.created_date BETWEEN '{$start}' AND '{$end}'";
        }

        if( isset($_GET['material']) ){
            if( !empty($_GET['material']) ){
                $materialId = $_GET['material'];
                $jsonData = '"material_name_id":"'.$materialId.'"';
                $where  .= " AND mrn.material_name LIKE '%{$jsonData}%'";            
            }
        }

        $tableJoins = ['supplier as sp' => 'sp.id = mrn.supplier_name','purchase_order as po' => 'po.id = mrn.po_id'];
        $selected   = 'mrn.id as mrnId,po.order_code as poNo,po.id as poId,sp.supplier_code,sp.id as spId,mrn.date as orderDate,po.expected_delivery_date,mrn.material_name,mrn.created_by as buyer,mrn.received_date as mrnRDate';
        $grnData    = $this->purchase_model->joinTables($selected,'mrn_detail as mrn',$tableJoins,$where,['mrn.id','desc']);
        $poAnalysis = $this->joinMaterialByData($grnData);

        
        $this->data['poAnalysis'] = $poAnalysis;
        $this->data['buyer']      = $this->getAllBuyer();
        $this->data['material']   = $this->getAllMaterial();

        $this->_render_template('report/purchase_order_report/goods_receipt_forecast_report', $this->data);   
        
    }


    function monitor_supplier_confirmation_report(){
        $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';
        $buyerUri = $materialId = "";
        $where      = "sp.created_by_cid = {$this->companyGroupId}";
        $ratingSort = "";

        if( $_GET['supplier'] ){
            $where  .= " AND sp.id = {$_GET['supplier']}";            
        }

        if( $_GET['rating_sort'] ){
            $ratingSort = $_GET['rating_sort'];      
        }



        $selected   = 'sp.supplier_code,sp.id as spId,sp.name';
        $grnData    = $this->purchase_model->joinTables($selected,'supplier as sp',[],$where,['sp.id','desc']);
        $poAnalysis = $this->accordingToSuppliuer($grnData,$ratingSort);

        
        $this->data['poAnalysis'] = $poAnalysis;
        $this->data['supplier'] = $this->getAllSupplier();
        $this->_render_template('report/supplier_master_list/monitor_supplier_confirmation_report', $this->data);           
    }

    function indent_register(){
        $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';
        $data = ['approve_indent' => 'Approve Indent','pending_indent' => 'Pending Indent','convert_to_po' => 'Convert To PO',
                    'convert_to_grn' => 'Convert To Grn','convert_to_po_pending' => 'Convert To PO Pending','convert_to_grn_pending' => 'Convert To Grn Pending',
                    'complete_indent' => 'Complete Indent' ];
        
        $piStatus = $materialId = "";
        $wherePi = "pi.created_by_cid = {$this->companyGroupId}";

        if( !empty($_GET['start']) && !empty($_GET['end']) ){
            $start = date('Y-m-d 00:00:00',strtotime($_GET['start']));
            $end = date('Y-m-d 00:00:00',strtotime($_GET['end']));
            $wherePi .= " AND pi.created_date BETWEEN '{$start}' AND '{$end}'";
        }


        if( !empty($_GET['status_type']) ){
            switch ($_GET['status_type']) {
                case 'approve_indent':
                    $piStatus = " AND pi.approve = 1 AND pi.po_or_not = 0 AND pi.mrn_or_not = 0 ";    
                break;
                case 'pending_indent':
                    $piStatus = " AND pi.approve = 0 AND pi.mrn_or_not = 0 AND pi.po_or_not = 0 AND pi.ifbalance = 1 ";    
                break;
                /*case 'convert_to_po':
                    $piStatus = " AND pi.po_or_not = 1 AND po.mrn_or_not = 0 AND pi.ifbalance = 1";    
                break;*/
                case 'convert_to_po':
                    $piStatus = " AND pi.po_or_not = 1 AND pi.ifbalance = 1";    
                break;
                case 'convert_to_grn':
                    $piStatus = " AND po.mrn_or_not = 1 AND pi.approve = 1 AND pi.po_or_not = 1 AND pi.ifbalance = 1";    
                break;
                case 'convert_to_po_pending':
                    $piStatus = " AND pi.po_or_not = 0 AND pi.approve = 1";    
                break;
                case 'convert_to_grn_pending':
                    $piStatus = " AND po.mrn_or_not = 0 AND pi.po_or_not = 1 ";    
                break;
                case 'complete_indent':
                    $piStatus = " AND pi.ifbalance = 0 ";    
                break;
            }
        }

        if( !empty($piStatus) ){
            $wherePi .= $piStatus;
        }

        if( !empty($_GET['supplier']) ){
            $supplierId = $_GET['supplier'];
            $wherePi .= " AND pi.preffered_supplier = '{$supplierId}'";            
        }

        if( isset($_GET['material']) ){
            if( !empty($_GET['material']) ){
                $materialId = $_GET['material'];
                $jsonData   = '"material_name_id":"'.$materialId.'"';
                $wherePi   .= " AND pi.material_name LIKE '%{$jsonData}%'";            
            }
        }


        $sqlCase = "CASE 
                        WHEN pi.po_or_not = 1 AND  po.mrn_or_not = 0 AND pi.ifbalance = 1  THEN 'Indent Convert To PO'
                        WHEN pi.ifbalance = 1 AND pi.approve = 1 AND pi.po_or_not = 1 AND po.mrn_or_not = 1   THEN 'Indent Convert To GRN'
                        WHEN pi.approve = 1 AND pi.po_or_not = 0  AND pi.mrn_or_not = 0 THEN 'Indent Approve'
                        WHEN pi.ifbalance = 0 THEN 'Complete'
                        WHEN pi.approve = 0 THEN  'Approver pending' END AS status";
        $dateFormat   = 'DATE_FORMAT(pi.created_date,"%d %M %Y") as registerDate';
        $selectindent = "pi.pay_or_not,pi.po_or_not,pi.mrn_or_not,pi.approve,pi.id,pi.indent_code,sp.id as spId,sp.supplier_code,pi.material_name,pi.grand_total,pi.created_by as buyer,
                            po.mrn_or_not as poMrnStatus,pi.ifbalance,{$dateFormat},{$sqlCase}";
        $tableJoins   = ['supplier as sp' => 'sp.id = pi.preffered_supplier','purchase_order as po' => 'po.pi_id = pi.id'];
        $IndentData = $this->purchase_model->joinTables($selectindent,'purchase_indent as pi',$tableJoins,$wherePi,['pi.id','desc'],[],'pi.id');
        $indentAllData = $this->indentMaterialCodes($IndentData,$materialId);
        
        $this->data['poAnalysis']       = $indentAllData;
        $this->data['buyer']            = $this->getAllBuyer();
        $this->data['material']         = $this->getAllMaterial();
        $this->data['purchaseStatus']   = $this->purchaseStatus();

        $this->_render_template('report/indent_report/indent_register', $this->data);           
           
    }

    function pending_indent_analysis(){
        $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';

        $wherePi = "pi.created_by_cid = {$this->companyGroupId} AND pi.mrn_or_not = 0 AND pi.po_or_not = 0 AND pi.approve = 0";

        if( $_GET['company'] ){
            $wherePi .= " AND pi.company_unit = {$_GET['company']}";            
        }


        $dateFormat   = 'DATE_FORMAT(pi.created_date,"%d %M %Y") as registerDate';
        $selectindent = "pi.id,pi.indent_code,sp.id as spId,sp.supplier_code,pi.material_name,pi.grand_total,pi.created_by as buyer,{$dateFormat},pi.company_unit";
        $tableJoins   = ['supplier as sp' => 'sp.id = pi.preffered_supplier'];
        $IndentData = $this->purchase_model->joinTables($selectindent,'purchase_indent as pi',$tableJoins,$wherePi,['pi.id','desc']);
        $indentAllData = $this->indentMaterialCodes($IndentData);
        
        $this->data['poAnalysis'] = $indentAllData;
        $this->data['company']    = $this->getAllCompany();

        $this->_render_template('report/indent_report/pending_indent_analysis', $this->data);           
    }

    function quotations_listing(){
        $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';

        $wherePi = "pi.created_by_cid = {$this->companyGroupId} AND rfq_supp != '' ";

        $selectindent = "pi.id as piId,pi.indent_code,pi.material_name,pi.created_by as buyer,pi.rfq_supp";
        $IndentData = $this->purchase_model->joinTables($selectindent,'purchase_indent as pi',[],$wherePi,['pi.id','desc']);

        $qutationData = [];

        if( $IndentData ){
            $tableJoins   = ['supplier as sp' => 'sp.id = rfq.supplier_id'];
            $selectRfq    = "rfq.product_id as rfq_material_name_id,rfq.supplier_expected_deliv_date,sp.supplier_code,sp.id,
                                rfq.supplier_expected_amount";
            foreach ($IndentData as $IndentKey => $IndentValue) {
                $qutationData[$IndentValue['piId']] = $IndentValue;
                $rfqSupplier = json_decode($IndentValue['rfq_supp']);
                
                foreach ($rfqSupplier as $supplierKey => $supplierValue) {
                    if( isset($_GET['supplier']) && $_GET['supplier'] != '' ){
                        if( $_GET['supplier'] != $supplierValue )
                            continue;
                    }

                    $selectedSupplier = $this->purchase_model->joinTables("supplier_code,id",'supplier',[],"id = {$supplierValue}");
                    if( $selectedSupplier ){
                        $selectedSupplier = $selectedSupplier[0];
                        $qutationData[$IndentValue['piId']]['not_selected_supplier'][$supplierValue] = $selectedSupplier['supplier_code'];
                    }

                    $whereRqf   = "rfq.product_induction_id = {$IndentValue['piId']} AND rfq.supplier_id = {$supplierValue} 
                                    AND selected_status = 1";
                    $IndentRfqData = $this->purchase_model->joinTables($selectRfq,'purchase_rfq as rfq',$tableJoins,$whereRqf);
                    if( $IndentRfqData ){
                        $materialExpDate = $materialExpPrice = $materialByIndent = [];
                        
                        foreach ($IndentRfqData as $rfqKey => $rfqValue) {
                            if(  isset($_GET['material']) && $_GET['material'] !="" ){
                                if( $rfqValue['rfq_material_name_id'] != $_GET['material'] )
                                    continue;
                            }
                            
                            $qutationData[$IndentValue['piId']]['supplier'][$supplierValue] = ['supplierId' => $supplierValue,'supplier_code' => $rfqValue['supplier_code'] ];

                            unset($qutationData[$IndentValue['piId']]['not_selected_supplier'][$supplierValue]);

                            $materialNameId = $rfqValue['rfq_material_name_id'];
                            $materialByName = $this->purchase_model->getRowByWhere('material',['id' => $materialNameId ],['material_code']);
                            if( $materialByName ){
                                $materialByIndent[] =  "<a href='javascript:void(0)' id='{$materialNameId}' data-id='material_view' class='inventory_tabs'>{$materialByName['material_code'] }</a>";
                                $materialExpPrice[] = $rfqValue['supplier_expected_amount'];
                                $materialExpDate[]  =  $rfqValue['supplier_expected_deliv_date'];
                            }
                            if( $materialByIndent ){
                                $qutationData[$IndentValue['piId']]['supplier'][$supplierValue]['material_name'] = implode(' || ',$materialByIndent);
                                $qutationData[$IndentValue['piId']]['supplier'][$supplierValue]['exp_price']     = implode(' || ',$materialExpPrice);
                                $qutationData[$IndentValue['piId']]['supplier'][$supplierValue]['exp_delivery']  = implode(' || ',$materialExpDate);
                            }
                        }
                    }
                    
                }  
            }
        }
        $this->data['poAnalysis'] = $qutationData;
        $this->data['material'] = $this->getAllMaterial();
        $this->_render_template('report/indent_report/quotations_listing', $this->data);              
    }

    function grn_material_report(){
        $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';
        $where = "mrn.created_by_cid = {$this->companyGroupId}";

        if( !empty($_GET['start']) && !empty($_GET['end']) ){
            $start = date('Y-m-d 00:00:00',strtotime($_GET['start']));
            $end = date('Y-m-d 00:00:00',strtotime($_GET['end']));
            $where .= " AND created_date BETWEEN '{$start}' AND '{$end}'";
        }else{
            $start = date('Y-m-1 00:00:00'); $end = date('Y-m-t 00:00:00');
            $where .= " AND created_date BETWEEN '{$start}' AND '{$end}'";
        }

        if( !empty($_GET['material']) ){
            $materialName = '"material_name_id":"'.$_GET['material'].'"';
            $where .= " AND material_name LIKE '%{$materialName}%'";            
        }

        $selected   = 'mrn.material_name,mrn.received_date as mrnRDate,mrn.created_date';
        $grnData    = $this->purchase_model->joinTables($selected,'mrn_detail as mrn',[],$where,['mrn.id','desc']);

        $newMaterialData = [];
        if( $grnData ){
            $i = 0;

            foreach ($grnData as $grnKey => $grnValue) {
                $materialData = json_decode($grnValue['material_name'],true);
                foreach ($materialData as $materialKey => $materialValue) {
                    if( isset($materialValue['material_type_id']) && !empty($materialValue['material_type_id']) ){
                        $materialByType = $this->purchase_model->getRowByWhere('material_type',['id' => $materialValue['material_type_id'] ],['name']);
                        $materialByName = $this->purchase_model->getRowByWhere('material',['id' => $materialValue['material_name_id'] ],['material_code','material_name','cost_price']);
                        $grnUrl = base_url("/purchase/purchase_report/accordingByMaterialGrn/{$materialValue['material_name_id']}");
                        $uom = $this->purchase_model->getRowByWhere('uom',['id' => $materialValue['uom'] ],['uom_quantity']);
                        $newMaterialData[$i]["material_type"]  =  $materialByType['name'];
                        $newMaterialData[$i]["material_name"]  =  $materialByName['material_name'];
                        $newMaterialData[$i]["material_code"]  =  "<a href='{$grnUrl}' target='_blank'>{$materialByName['material_code']}</a>";    
                        $newMaterialData[$i]["uom"]            =  $uom['uom_quantity'];    
                        $newMaterialData[$i]["price"]          =  $materialByName['cost_price'];
                        $newMaterialData[$i]["create_date"]    =  date('d-M-Y',strtotime($grnValue['created_date']));

                    }
                $i++;
                }
            }
        }

        $mData = array_unique(array_column($newMaterialData,'material_code'));
        $mData = array_intersect_key($newMaterialData,$mData);
        $this->data['mData'] = $mData;
        $this->data['material'] = $this->getAllMaterial();


        $this->_render_template('report/grn_report/material', $this->data);                 
        
    }

    function grn_supplier_report(){
        $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';
        $materialId = "";
        $where      = "mrn.created_by_cid = {$this->companyGroupId}";

        if( $_GET['supplier'] ){
            $where  .= " AND mrn.supplier_name = {$_GET['supplier']}";            
        }

        if( !empty($_GET['start']) && !empty($_GET['end']) ){
            $start = date('Y-m-d 00:00:00',strtotime($_GET['start']));
            $end = date('Y-m-d 00:00:00',strtotime($_GET['end']));
            $where .= " AND mrn.created_date BETWEEN '{$start}' AND '{$end}'";
        }else{
            $start = date('Y-m-1 00:00:00'); $end = date('Y-m-t 00:00:00');
            $where .= " AND mrn.created_date BETWEEN '{$start}' AND '{$end}'";
        }

        $tableJoins  = ['supplier as sp' => 'sp.id = mrn.supplier_name'];
        $selected    = 'sp.name as supplier_name,sp.supplier_code,sp.id as spId,sp.gstin as gst';
        $grnData     = $this->purchase_model->joinTables($selected,'mrn_detail as mrn',$tableJoins,$where,['mrn.id','desc']);

        $grnSupplier     = array_unique(array_column($grnData,'supplier_code'));
        $uniqueSupplier  = array_intersect_key($grnData,$grnSupplier);
        $grnSupplierData = [];
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        if( $uniqueSupplier ){
            foreach ($uniqueSupplier as $sDataKey => $sDataValue) {
                /* Wrong amount is displaying Start 10-03-2022 */
                 $grnDataBySupplier = $this->purchase_model->getRowByWhere('mrn_detail',['supplier_name' => $sDataValue['spId'] ],
                 ['SUM(grand_total) as grand_total','COUNT(id) as totalOrder', 'material_name']);
                $grnSupplierData[$sDataKey] = $sDataValue + ['total_amount' => $grnDataBySupplier['grand_total'],'total_order' => $grnDataBySupplier['totalOrder'],'material_name' => $grnDataBySupplier['material_name'] ];
                /* Wrong amount is displaying End 10-03-2022 */
            }
        }
       
        $this->data['grnSupplier'] = $grnSupplierData;
        $this->data['supplier']   = $this->getAllSupplier();

        $this->_render_template('report/grn_report/supplier', $this->data);


    }

    function past_paymant_report(){
        $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';

        $where       = "po.created_by_cid = {$this->companyGroupId} AND po.mrn_or_not = 0 AND po.status != '' ";
        if( $_GET['supplier'] ){
            $where  .= " AND po.supplier_name = {$_GET['supplier']}";            
        }

        $tableJoins  = ['supplier as sp' => 'sp.id = po.supplier_name'];
        $selected    = 'sp.name as supplier_name,sp.supplier_code,sp.id as spId,po.status';
        $poData     = $this->purchase_model->joinTables($selected,'purchase_order as po',$tableJoins,$where,['po.id','desc']);

        $grnWhere       = "mrn.created_by_cid = {$this->companyGroupId} AND mrn.status != '' ";
        if( $_GET['supplier'] ){
            $grnWhere  .= " AND mrn.supplier_name = {$_GET['supplier']}";        }

        $grnTableJoins  = ['supplier as sp' => 'sp.id = mrn.supplier_name'];
        $grnSelected    = 'sp.name as supplier_name,sp.supplier_code,sp.id as spId,mrn.status,mrn.payment_terms';
        $grnData        = $this->purchase_model->joinTables($grnSelected,'mrn_detail as mrn',$grnTableJoins,$grnWhere,['mrn.id','desc']);

        $newPaymentData = mergeMultiDemArray($grnData,$poData);

        $paymentData = [];
        if( $newPaymentData ){
            foreach ($newPaymentData as $payKey => $payValue) {
                $paymentStatus = json_decode($payValue['status'],true);
                if( !empty($payValue['supplier_code']) && (!empty($paymentStatus['Payment']) && isset($paymentStatus['Payment']) ) ){
                    $paymentData[$payKey] = ['supplier_name' => $payValue['supplier_name'],'supplier_code' => $payValue['supplier_code'],'spId' => $payValue['spId'],
                                                'payment_terms' => $payValue['payment_terms'] ];
                    $totalAmount = 0;
                    foreach ($paymentStatus['Payment'] as $pStatusKey => $pStatusValue) {
                        $totalAmount += $pStatusValue['amount'];
                    }
                    $paymentData[$payKey]['amount'] = $totalAmount;
                    $paymentData[$payKey]['payment_send'] = $paymentStatus['Payment'][0]['required_date'];
                }
            }
        }


        if( $paymentData ){
            $newAmount = array_reduce($paymentData, function($result, $column) {
                    $result[$column['supplier_code']]['amount'] += $column['amount'];
                    $result[$column['supplier_code']]['supplier_code'] = $column['supplier_code'];
                    $result[$column['supplier_code']]['spId'] = $column['spId'];
                    $result[$column['supplier_code']]['supplier_name'] = $column['supplier_name'];
                    $result[$column['supplier_code']]['payment_terms'] = $column['payment_terms'];
                    $result[$column['supplier_code']]['payment_send'] = $column['payment_send'];
                    return $result;
            },[]);
        }
       
        $this->data['paymentData'] = $newAmount;
        $this->data['supplier']   = $this->getAllSupplier();
        $this->_render_template('report/payment_report/past', $this->data);
    }

    function payment_advance(){
        $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';

        $where       = "po.created_by_cid = {$this->companyGroupId} AND po.mrn_or_not = 0 AND po.status = '' AND ifbalance = 1 ";
        if( $_GET['supplier'] ){
            $where  .= " AND po.supplier_name = {$_GET['supplier']}";            
        }

        $tableJoins  = ['supplier as sp' => 'sp.id = po.supplier_name'];
        $selected    = 'sp.name as supplier_name,sp.supplier_code,sp.id as spId,po.grand_total as amount';
        $poData     = $this->purchase_model->joinTables($selected,'purchase_order as po',$tableJoins,$where,['po.id','desc']);

        $grnWhere       = "mrn.created_by_cid = {$this->companyGroupId} AND mrn.status = '' AND ifbalance = 1 ";
        if( $_GET['supplier'] ){
            $grnWhere  .= " AND mrn.supplier_name = {$_GET['supplier']}";        }

        $grnTableJoins  = ['supplier as sp' => 'sp.id = mrn.supplier_name'];
        $grnSelected    = 'sp.name as supplier_name,sp.supplier_code,sp.id as spId,mrn.grand_total as amount';
        $grnData        = $this->purchase_model->joinTables($grnSelected,'mrn_detail as mrn',$grnTableJoins,$grnWhere,['mrn.id','desc']);

        $newPaymentData = mergeMultiDemArray($grnData,$poData);
        if( $newPaymentData ){
            $supplierAmount = array_reduce($newPaymentData, function($result, $column) {
                    $result[$column['supplier_code']]['amount'] += $column['amount'];
                    $result[$column['supplier_code']]['supplier_code'] = $column['supplier_code'];
                    $result[$column['supplier_code']]['spId'] = $column['spId'];
                    $result[$column['supplier_code']]['supplier_name'] = $column['supplier_name'];
                    return $result;
            },[]);
        }

        $this->data['pendingAmount'] = $supplierAmount;
        $this->data['supplier']   = $this->getAllSupplier();
        $this->_render_template('report/payment_report/advance', $this->data);   
    }

    function damage_material_orders(){
         $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';
        $materialId  = "";
        $damage      = '"defected":1';
        $where      = "mrn.created_by_cid = {$this->companyGroupId} AND mrn.material_name LIKE '%{$damage}%'";

        if( $_GET['supplier'] ){
            $where  .= " AND mrn.supplier_name = {$_GET['supplier']}";            
        }

        if( isset($_GET['material']) ){
            if( !empty($_GET['material']) ){
                $materialId = $_GET['material'];
                $jsonData = '"material_name_id":"'.$materialId.'"';
                $where  .= " AND mrn.material_name LIKE '%{$jsonData}%'";            
            }
        }

        if( !empty($_GET['start']) && !empty($_GET['end']) ){
            $start = date('Y-m-d 00:00:00',strtotime($_GET['start']));
            $end = date('Y-m-d 00:00:00',strtotime($_GET['end']));
            $where .= " AND mrn.created_date BETWEEN '{$start}' AND '{$end}'";
        }

        if( !empty($_GET['search']) ){
            $searchOC = $searchSupplier = "";
            $search = $_GET['search'];
            $searchSupplier = $this->purchase_model->joinTables('id','supplier',[],"supplier_code = '{$search}'");
            $searchOC = $this->purchase_model->joinTables('id','purchase_order',[],"order_code = '{$search}'");
            if( !empty($searchSupplier) && isset($searchSupplier[0]['id']) && !empty($searchOC) && isset($searchOC[0]['id']) ){
                $searchSupplier = $searchSupplier[0]['id'];
                $searchOC = $searchOC[0]['id'];
                $where .= " AND (mrn.supplier_name = {$searchSupplier} OR mrn.po_id = {$searchOC}) ";
            }elseif(!empty($searchSupplier) && isset($searchSupplier[0]['id']) && empty($searchOC)){
                $searchSupplier = $searchSupplier[0]['id'];
                $where .= " AND (mrn.supplier_name = {$searchSupplier})";
            }elseif( !empty($searchOC) && isset($searchOC[0]['id']) && empty($searchSupplier) ){
                $searchOC = $searchOC[0]['id'];
                $where .= " AND (mrn.po_id = {$searchOC})";

            }
        }

        $selected   = 'po.id as poId,po.order_code as poNo,sp.supplier_code,sp.id as spId,mrn.material_name,mrn.bill_no,mrn.id as mrnId';

        $tableJoins = ['supplier as sp' => 'sp.id = mrn.supplier_name','purchase_order as po' => 'po.id = mrn.po_id'];
        $poData    = $this->purchase_model->joinTables($selected,'mrn_detail as mrn',$tableJoins,$where,['mrn.id','desc'],[]);

        
        $poAnalysis = $this->joinMaterialByData($poData,$materialId,true);
        
        $this->data['poAnalysis'] = $poAnalysis;
        $this->data['material']   = $this->getAllMaterial();

        $this->_render_template('report/damage_report/damage_material', $this->data);  

    }

    function cost_center_report(){
         $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = getSingleAndWhere('report_name','purchase_reports',['url' => $this->uri->segment(3)] )??'';
        $select = "pcc.cost_center_name,SUM(mrn.grand_total) as total_amount";
        $jointables = ['mrn_detail as mrn' => "mrn.cost_center = pcc.id"];

        $whereGrn = "";
        if(isset($_GET['start']) && isset($_GET['end'])){
            $start = date('Y-m-d',strtotime(str_replace('-', '/', $_GET['start'])));
            $end   = date('Y-m-d',strtotime(str_replace('-', '/', $_GET['end'])));
            //$whereGrn = " AND (mrn.created_date >= '{$start}' AND mrn.created_date <= '{$end}')";
            $whereGrn = " AND (mrn.created_date BETWEEN '{$start}' AND '{$end}')";
            $jointables = ['mrn_detail as mrn' => "mrn.cost_center = pcc.id {$whereGrn}"];
        }

        $where = "pcc.created_by_cid = {$this->companyGroupId}";
        $this->data['cost_center'] = $this->purchase_model->joinTables($select,'purchase_cost_center as pcc',$jointables,$where,['pcc.id','desc'],[],'pcc.id');
        $this->_render_template('report/grn_report/cost_center', $this->data);          
    }

    function accordingByMaterialGrn(){
        $this->data['can_edit']        = edit_permissions();
        $this->data['can_delete']      = delete_permissions();
        $this->data['can_add']         = add_permissions();
        $this->data['can_view']        = view_permissions();
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = "GRN By ".getSingleAndWhere('material_name','material',
                                        [ 'id' => $this->uri->segment(4) ] )." Material";

        $where = "mrn.created_by_cid = {$this->companyGroupId}";
        if( $this->uri->segment(4) ){
            $materialName = '"material_name_id":"'.$this->uri->segment(4).'"';
            $where .= " AND mrn.material_name LIKE '%{$materialName}%'";            
        }

        $tableJoins  = ['supplier as sp' => 'sp.id = mrn.supplier_name'];
        $selected    = 'sp.name as supplier_name,sp.supplier_code,sp.id as spId,mrn.bill_no as invoice_no,mrn.grand_total,mrn.payment_terms,mrn.id as mrnId';
        $grnData     = $this->purchase_model->joinTables($selected,'mrn_detail as mrn',$tableJoins,$where,['mrn.id','desc']);
        $this->data['grnData'] = $grnData;

        $this->_render_template('report/grn_report/grn_by_material', $this->data);

    }

    function indentMaterialCodes($IndentData,$materialId=""){
        $indentAllData = [];
        if( $IndentData ){
            $po_pending = 0;
            $grn_pending = 0;
            $in_progress = 0;
            $complete    = 0;
            foreach ( $IndentData as $IndentKey => $IndentValue ) {
                $indentAllData['po_pending'] = $po_pending;
                $indentAllData['grn_pending'] = $grn_pending;
                $indentAllData['in_progress'] = $in_progress;
                if( $IndentValue['ifbalance'] == 0   ){
                    $complete++;
                    $indentAllData['complete'] = $complete;
                }
                /*if( $IndentValue['po_or_not'] == 1 && $IndentValue['mrn_or_not'] == 1 && $IndentValue['pay_or_not'] == 0 ){
                    $in_progress++;
                    $indentAllData['in_progress'] = $in_progress;
                }*/
                if( $IndentValue['ifbalance'] == 1  ){
                    $in_progress++;
                    $indentAllData['in_progress'] = $in_progress;
                }
                if( $IndentValue['po_or_not'] == 1 && $IndentValue['ifbalance'] == 1 && $IndentValue['poMrnStatus'] == 0 ){
                    $indentAllData['conevrt_to_po'] += $IndentValue['po_or_not'];
                }
                if( $IndentValue['poMrnStatus'] == 1 && $IndentValue['ifbalance'] == 1 && $IndentValue['po_or_not'] == 1 ){
                    $indentAllData['conevrt_to_grn'] += $IndentValue['poMrnStatus'];
                }
                if( $IndentValue['id'] ){
                    $indentAllData['total'] = $IndentKey+1;
                }
                if( $IndentValue['approve'] == 1 && $IndentValue['po_or_not'] == 0 && $IndentValue['mrn_or_not'] == 0 && $IndentValue['ifbalance'] == 1 ){
                    $po_pending++;
                    $indentAllData['po_pending'] = $po_pending;
                }
                if( $IndentValue['approve'] == 1 && $IndentValue['po_or_not'] == 1 && $IndentValue['mrn_or_not'] == 0 && $IndentValue['ifbalance'] == 1 ){
                    $grn_pending++;
                    $indentAllData['grn_pending'] = $grn_pending;
                }
                $indentAllData[$IndentKey] = $IndentValue;
                unset($indentAllData[$IndentKey]['material_name']);
                $materialDetails = json_decode($IndentValue['material_name'],true);
                if( $materialDetails ){
                    $materialByIndent = [];
                    foreach ($materialDetails as $materialKey => $materialValue) {
                        if( !empty($materialId) ){
                            if( $materialValue['material_name_id'] != $materialId ){
                                continue;
                            }
                        }
                        $materialNameId = $materialValue['material_name_id'];
                        $materialByName = $this->purchase_model->getRowByWhere('material',['id' => $materialNameId ],['material_code']);
                        if( $materialByName ){
                            $materialByIndent[] =  "<a href='javascript:void(0)' id='{$materialNameId}' data-id='material_view' class='inventory_tabs'>{$materialByName['material_code'] }</a>";
                        }
                    }
                    if( $materialByIndent ){
                        $indentAllData[$IndentKey]['material_name'] = implode(' || ',$materialByIndent);
                    }
                }
            }
        }
        return $indentAllData;
    }


    function accordingToSuppliuer($data,$sort=""){
        $supplierRatingMaterial = [];
        $selected   = 'mrn.supplier_name,mrn.rating,mrn.id,mrn.material_name';
        if( $data ){
            foreach ($data as $SupplierKey => $supplierValue) {
                    $where = "supplier_name = {$supplierValue['spId']}";
                    $grnData    = $this->purchase_model->joinTables($selected,'mrn_detail as mrn',[],$where,['mrn.id','desc']);
                        $supplierRatingMaterial[$supplierValue['spId']] = ['spId' => $supplierValue['spId'],'supplier_code' => $supplierValue['supplier_code'],'supplier_name' => $supplierValue['name'] ];
                        if( $grnData ){
                            $i = 0;
                            $rating = 0;
                            foreach ($grnData as $grnKey => $grnValue) {
                                $materialData = json_decode($grnValue['material_name'],true);
                                $rating += $grnValue['rating'];
                                $i++;
                                foreach ($materialData as $materialKey => $materialValue) {
                                    $materialId = $materialValue['material_name_id'];
                                    $materialByName = $this->purchase_model->getRowByWhere('material',['id' => $materialId ],['material_code']);

                                    if( $materialByName['material_code'] ){
                                        $materialBySupplier = "<a href='javascript:void(0)' id='{$materialId}' data-id='material_view' class='inventory_tabs'>{$materialByName['material_code']}</a>";
                                        $supplierRatingMaterial[$supplierValue['spId']]['material_code'][] = $materialBySupplier;
                                    }
                                }
                            }
                            $supplierRatingMaterial[$supplierValue['spId']]['mrndetails']    = ['rating' => ($rating/$i),'order' => $i ];
                        }
            }
        }

        if( !empty($sort)){
            if( $sort == 'asc' ){
                $sortData = SORT_ASC;
            }else{
                $sortData = SORT_DESC;
            }
            array_multisort(array_map(function($element) {
                return $element['mrndetails']['rating'];
            }, $supplierRatingMaterial), $sortData, $supplierRatingMaterial);            
        }
        return $supplierRatingMaterial;
    }

    function joinMaterialByData($grnData,$materialNameFilter="",$onlyDefacted=false){
        $poAnalysis = [];
        $damage = 0;
        if( $grnData ){
            foreach ($grnData as $grnKey => $grnValue) {
               /* if( $grnValue['poNo']){*/
                    $materialData = json_decode($grnValue['material_name'],true);
                    unset( $grnValue['material_name'] );
                    $poAnalysis[$grnKey] = $grnValue;
                    if( !empty($materialData) ){
                        foreach ($materialData as $materialKey => $materialValue) {
                            if( $onlyDefacted ){
                                if($materialValue['defected'] == 0 || !isset($materialValue['defectedQty']) ){
                                    unset($poAnalysis[$grnKey]);
                                    continue;
                                }
                            }
                            if( !empty($materialNameFilter) ){
                                if( $materialNameFilter != $materialValue['material_name_id'] )
                                    continue;
                            }
                            $materialByName = $this->purchase_model->getRowByWhere('material',['id' => $materialValue['material_name_id']],['material_name','material_code','sales_price','cost_price']);
                            if( $materialValue['uom'] ){
                                $uom = $this->purchase_model->getRowByWhere('uom',['id' => $materialValue['uom']],['uom_quantity']);
                            }
                            if( isset($materialValue['defectedQty']) ){
                                if( !empty($materialValue['defectedQty']) ){
                                    $damage = $materialValue['defectedQty'];
                                }
                            }
                            $poAnalysis[$grnKey]['material_data'][$materialKey] = ['material_name' => $materialByName['material_name'],
                                                  'material_code' => $materialByName['material_code'],'material_name_id' => $materialValue['material_name_id'],'total_qty' => $materialValue['quantity'],'uom' => $uom['uom_quantity']??'',
                                                'qty_delivered' => (!empty($materialValue['received_quantity']))?$materialValue['received_quantity']:$materialValue['quantity'],
                                                'damage_qty' => $damage,'defected_reason' => $materialValue['defected_reason'],
                                                'sale_price' => (!empty($materialByName['material_sales_price']) && $materialByName['material_sales_price'] > 0)?$materialByName['material_sales_price']:$materialValue['price'],
                                                'cost_price' => (!empty($materialByName['material_cost_price']) && $materialByName['material_cost_price'] > 0)?$materialByName['material_cost_price']:$materialValue['price'],
                                                'order_price' => $materialValue['price']   ];

                            
                        }
                    }
                /*}*/

            }
        }
        return $poAnalysis;
    }

    function getAllBuyer(){
        $selected  = 'u_id,name';
        $where     = "c_id = {$this->companyGroupId}";
        $data      = $this->purchase_model->joinTables($selected,'user_detail',[],$where,['id','desc'],[]);
        $selected .= ',Select Buyer';
        return $this->optionHtml($data, explode(',',$selected) );        
    }

    function getAllMaterial(){
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $selected   = 'id,material_name,material_code';
        $where      = "created_by_cid = {$this->companyGroupId} AND material_name != ''";
        $data       = $this->purchase_model->joinTables($selected,'material',[],$where,['id','desc'],[]);
        $html       = "<option value=''>Select Material</option>";
        if( $data ){
            foreach ($data as $key => $value) {
                $html .= "<option value='{$value['id']}'>{$value['material_name']} ({$value['material_code']})</option>";
            }
        }
        return $html;    
    }

    function getAllCompany(){
        $selected   = 'compny_branch_id,company_unit';
        $where      = "created_by_cid = {$this->companyGroupId}";
        $data       = $this->purchase_model->joinTables($selected,'company_address',[],$where,['id','desc']);
        $selected .= ',Select Company';
        return $this->optionHtml($data,explode(',',$selected) );
    }

    function getAllSupplier(){
        $selected   = 'id,name';
        $where      = "created_by_cid = {$this->companyGroupId}";
        $data       = $this->purchase_model->joinTables($selected,'supplier',[],$where,['id','desc']);
        $selected .= ',Select Supplier';
        return $this->optionHtml($data,explode(',',$selected) );
    }

    function purchaseStatus(){
        $data = ['approve_indent' => 'Approve Indent','pending_indent' => 'Pending Indent','convert_to_po' => 'Convert To PO',
                    'convert_to_grn' => 'Convert To Grn','convert_to_po_pending' => 'Pending Convert to PO ',
                    'convert_to_grn_pending' => 'Pending Convert to GRN','complete_indent' => 'Complete Indent' ];
        $html = "<option value=''>Select Status</option>";
        if( $data ){
            foreach ($data as $key => $value) {
                $html .= "<option value='{$key}'>{$value}</option>";
            }
        }
        return $html;    
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
       $this->_render_template('report/aging_report/aging_report' );
    }
}
