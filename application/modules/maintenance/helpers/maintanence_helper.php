<?php
/**
Get Department data for Datatable Listing
*/

function getCompanyTableId($table = '')
{
    $CI =& get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', TRUE);
    $query     = $dynamicdb->query("SELECT  name  FROM $table WHERE u_id = '" . $_SESSION['loggedInUser']->u_id . "'");
    $result    = $query->row();
    return $result;
    /*if(!empty($result))	
    return $result->u_id;
    else return false;*/
}
/*
function leadStatus()
{
    $leadStatus = array(
        'New',
        'Contacted',
        'Qualified',
        'Unqualified',
        'Win',
        'Loose'
    );
    return $leadStatus;
}
function switch_db_dinamico($name_db)
{
    $config_app['hostname']     = 'localhost';
    $config_app['username']     = 'ERP_root';
    $config_app['password']     = '#Lh{a@I~VQ6I';
    $config_app['database']     = $name_db;
    $config_app['dbdriver']     = 'mysqli';
    $config_app['dbprefix']     = '';
    $config_app['pconnect']     = FALSE;
    $config_app['db_debug']     = (ENVIRONMENT !== 'production');
    $config_app['save_queries'] = true;
    return $config_app;
}

function leadSource()
{
    $leadSource = array(
        'Advertisement',
        'Employee Referral',
        'External Referral',
        'Other',
        'Social',
        'Trade Show',
        'Web',
        'Word of mouth',
        'Alibaba RFQ',
        'Alibaba Message Inbox',
        'Indiamart Enquiry',
        'Google Search',
        'Export Data',
        'Website - www.azukaropes.com'
    );
    return $leadSource;
}

function leadActivityStatus()
{
    $leadActivityStatus = array(
        'Call',
        'Send Letter',
        'Send Quote',
        'Other'
    );
    return $leadActivityStatus;
}


function accountType()
{
    $accountTypes = array(
        'Analyst',
        'Competitor',
        'Customer',
        'Integrator',
        'Investor',
        'Partner',
        'Press',
        'Prospect',
        'Reseller',
        'Other'
    );
    return $accountTypes;
}

function industries()
{
    $industries = array(
        'Agriculture',
        'Apparel',
        'Banking',
        'Biotechnology',
        'Chemicals',
        'Communications',
        'Construction',
        'Consulting',
        'Education',
        'Electronics',
        'Energy',
        'Engineering',
        'Entertainment',
        'Environmental',
        'Finance',
        'Food',
        'Government',
        'Healthcare',
        'Hospitality',
        'Insurance',
        'Machinery',
        'Manufacturing',
        'Media',
        'Not For Profit',
        'Recreation',
        'Retail',
        'Shipping',
        'Technology',
        'Telecommunications',
        'Transportation',
        'Utilities',
        'Other'
    );
    return $industries;
}
*/
function getNameById($table = '', $id = '', $field = '')
{
    $qry = "select * from $table where $field='$id'";
    $CI =& get_instance();
    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
        $qryy = $CI->db->query($qry);
    } else {
        $dynamicdb = $CI->load->database('dynamicdb', TRUE);
        $qryy      = $dynamicdb->query($qry);
    }
    $result = $qryy->row();
    return $result;
}

function getAttachmentsById($table = '', $id = '', $rel_type = '')
{
    $qry = "select * from $table where rel_id='$id' AND rel_type='$rel_type'";
    $CI =& get_instance();
    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
        $qryy = $CI->db->query($qry);
    } else {
        $dynamicdb = $CI->load->database('dynamicdb', TRUE);
        $qryy      = $dynamicdb->query($qry);
    }
    $result = $qryy->result_array();
    return $result;
}


function updateUsedIdStatus($table = '', $id = '')
{
    $sql = "UPDATE $table SET  used_status = 1 where id = $id";
    $CI =& get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', TRUE);
    $qry       = $dynamicdb->query($sql);
}
function updateMultipleUsedIdStatus($table = '', $whereIds = '')
{
    $sql = "UPDATE $table SET  used_status = 1 where id IN($whereIds)";
    $CI =& get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', TRUE);
    $qry       = $dynamicdb->query($sql);
}


/*function measurementUnits(){
$measurementUnits = array('Meter/Metre','Millimeter','Centimeter','Decimeter','Kilometer','Inch','Foot','Yard','Square meter','Square inches','Square feet','Cubic meter','Liter','Milliliter','Centiliter','Deciliter','Hectoliter','Cubic Inch','Quart','Gallon','Grams','Kilogram','Grain','Ounce','Pound','Ton','Tonne');
return $measurementUnits;
}*/



function paymentTerms()
{
    $paymentTerms = array(
        'Advance',
        'Credit',
        '30 Days',
        '45 Days',
        '60 Days',
        '90 Days',
        'Against PDC'
    );
    return $paymentTerms;
}

function documentSubmitedWithDispatch()
{
    $documentSubmitedWithDispatch = array(
        'Orignal Invoice',
        'Duplicate Invoice',
        'Packing List',
        'Insurance',
        'Test Certificate',
        'Test Report',
        'Way Bill',
        'AGT Receipt',
        'GR Copy',
        "Customer's PO Copy"
    );
    return $documentSubmitedWithDispatch;
}

function discountOffered()
{
    $discountOffered = array(
        'Cash Discount',
        'UOM Rate',
        'Quantity Discount',
        'Annual Ternover Discount'
    );
    return $discountOffered;
}

function create_pdf($dataPdf = array(), $page = '')
{
    $CI =& get_instance();
    $CI->load->library('Pdf');
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'UTF-8', false);
    $pdf->AddPage();
    //include(APPPATH . '/purchase_order/' . $module_nm . '/views/view_pdf.php');
    //include(APPPATH .'modules/crm/views/proforma_invoices/view_pdf.php');
    //include(APPPATH .'modules/crm/views/proforma_invoices/view_pdf1.php');
    include(APPPATH . $page);
    $pdf->Output();
}



/*production data */
function getPoductionDataListingGraph($startDate = '', $endDate = '')
{
    $companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
    if ($_SESSION['loggedInUser']->role == 2) {
        $where = ' AND production_data.created_by=' . $_SESSION['loggedInUser']->u_id;
    } else {
        #$where = ' AND production_data.created_by_cid='.$_SESSION['loggedInUser']->c_id;			
        $where = ' AND production_data.created_by_cid=' . $companyGroupId;
    }
    $btwQuery = '';
    if ($startDate != '' && $endDate != '') {
        $btwQuery = ' AND production_data.created_date >="' . $startDate . '" AND production_data.created_date <="' . $endDate . '"';
    }
    
    $qry = "SELECT  substring(
			concat('  January'
				  ,' February'
				  ,'    March'
				  ,'    April'
				  ,'      May'
				  ,'     June'
				  ,'     July'
				  ,'   August'
				  ,'September'
				  ,'  October'
				  ,' November'
				  ,' December'
				  )
			 , m*9 - 8
			 , 9 ) as period , production_data FROM 
	(
		SELECT 1 as m 
		UNION SELECT 2 as m 
		UNION SELECT 3 as m 
		UNION SELECT 4 as m 
		UNION SELECT 5 as m 
		UNION SELECT 6 as m 
		UNION SELECT 7 as m 
		UNION SELECT 8 as m 
		UNION SELECT 9 as m 
		UNION SELECT 10 as m 
		UNION SELECT 11 as m 
		UNION SELECT 12 as m
	) as Months
	LEFT JOIN production_data  on Months.m = MONTH(production_data.created_date) $where AND DATE_FORMAT(production_data.created_date, '%Y') = YEAR (CURDATE()) $btwQuery 
	ORDER By Months.m";
    $CI =& get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', TRUE);
    $qryy      = $dynamicdb->query($qry);
    //pre($dynamicdb->last_query());
    $result    = $qryy->result_array();
    $sumArray  = array();
    $i         = 0;
    foreach ($result as $key => $res) {
        //pre( $res);
        $sumArray[$i]['month'] = $res['period'];
        $productionData        = json_decode($res['production_data']);
        
        //$sumConsumed = 0;
        //$sumWastage = 0;
        //$sumElectricity = 0;
        $sumOutput = 0;
        $output    = 0;
        //$sumCosting = 0;
        //$sumDowntime = 0;
        if (!empty($productionData)) {
            foreach ($productionData as $pd) {
                //pre($pd);
                //$pd->material_consumed = $pd->material_consumed?$pd->material_consumed:0;
                //$pd->wastage = $pd->wastage?$pd->wastage:0;
                //$pd->electricity = ($pd->electricity && $pd->electricity !='')?$pd->electricity:0;
                //$electricity = (int)($pd->electricity && $pd->electricity !='')?$pd->electricity:0;
                //pre(gettype($electricity));
                //$pd->output = ($pd->output && $pd->output !='')?$pd->output:0;
                if (empty($pd->output)) {
                    foreach ($pd->output as $op) {
                        
                        $output = ($op && $op != "") ? ($op) : 0;
                    }
                }
                
                foreach ($pd->output as $out) {
                    //pre($out);
                    $output = ($out && $out != "") ? ($out) : 0;
                }
                //$output = $pd->output;
                #$output = ($pd->output && $pd->output !="")?($pd->output):0;
                //$pd->costing = $pd->costing?$pd->costing:0;
                //$pd->downtime = $pd->downtime?$pd->downtime:0;
                //$sumConsumed += $pd->material_consumed;						
                //$sumWastage += $pd->wastage;						
                //$sumElectricity += (int)$pd->electricity !="" ?$pd->electricity:0;
                //$sumElectricity += ($electricity && $electricity !='')?($electricity):0;
                //$sumElectricity += $pd->electricity;
                
                $sumOutput += $output;
                //$sumCosting += $pd->costing;						
                //$sumDowntime += $pd->downtime;						
            }
        }
        
        //$sumArray[$i]['sumConsumed'] = $sumConsumed;	
        //$sumArray[$i]['sumWastage'] = $sumWastage;	
        //$sumArray[$i]['sumElectricity'] = $sumElectricity;	
        $sumArray[$i]['sumOutput'] = $sumOutput;
        //$sumArray[$i]['sumCosting'] = $sumCosting;	
        //	$sumArray[$i]['sumDowntime'] = $sumDowntime;	
        $i++;
    }
    
    $CombinedArray = array();
    $k             = 0;
    foreach ($sumArray as $sum_Array) {
        if (array_key_exists($sum_Array['month'], $CombinedArray)) {
            //$CombinedArray[$sum_Array['month']]['sumConsumed'] += $sum_Array['sumConsumed'];
            //$CombinedArray[$sum_Array['month']]['sumWastage'] += $sum_Array['sumWastage'];
            //$CombinedArray[$sum_Array['month']]['sumElectricity'] += $sum_Array['sumElectricity'];
            $CombinedArray[$sum_Array['month']]['sumOutput'] += $sum_Array['sumOutput'];
            //$CombinedArray[$sum_Array['month']]['sumCosting'] += $sum_Array['sumCosting'];
            //	$CombinedArray[$sum_Array['month']]['sumDowntime'] += $sum_Array['sumDowntime'];
            $CombinedArray[$sum_Array['month']]['month'] = $sum_Array['month'];
        } else {
            $CombinedArray[$sum_Array['month']] = $sum_Array;
        }
        
        $merged = array();
        foreach ($CombinedArray as $month => $data) {
            $merged[] = $data;
        }
    }
    return $merged;
}



/*production planning*/
function getProductionPlanning($startDate = '', $endDate = '')
{
    $companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
    if ($_SESSION['loggedInUser']->role == 2) {
        $where = ' AND production_planning.created_by=' . $_SESSION['loggedInUser']->u_id;
    } else {
        #$where = ' AND production_planning.created_by_cid='.$_SESSION['loggedInUser']->c_id;			
        $where = ' AND production_planning.created_by_cid=' . $companyGroupId;
    }
    $btwQuery = '';
    if ($startDate != '' && $endDate != '') {
        $btwQuery = ' AND production_planning.created_date >="' . $startDate . '" AND production_planning.created_date <="' . $endDate . '"';
    }
    $qry = "SELECT  substring(
			concat('  January'
				  ,' February'
				  ,'    March'
				  ,'    April'
				  ,'      May'
				  ,'     June'
				  ,'     July'
				  ,'   August'
				  ,'September'
				  ,'  October'
				  ,' November'
				  ,' December'
				  )
			 , m*9 - 8
			 , 9 ) as period , planning_data FROM 
	(
		SELECT 1 as m 
		UNION SELECT 2 as m 
		UNION SELECT 3 as m 
		UNION SELECT 4 as m 
		UNION SELECT 5 as m 
		UNION SELECT 6 as m 
		UNION SELECT 7 as m 
		UNION SELECT 8 as m 
		UNION SELECT 9 as m 
		UNION SELECT 10 as m 
		UNION SELECT 11 as m 
		UNION SELECT 12 as m
	) as Months
	LEFT JOIN production_planning  on Months.m = MONTH(production_planning.created_date) $where AND DATE_FORMAT(production_planning.created_date, '%Y') = YEAR (CURDATE()) $btwQuery 
	ORDER By Months.m";
    $CI =& get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', TRUE);
    $qry       = $dynamicdb->query($qry);
    $result    = $qry->result_array();
    $PlanArray = array();
    $j         = 0;
    foreach ($result as $key => $plan) {
        $PlanArray[$j]['month'] = $plan['period'];
        $prodPlan               = json_decode($plan['planning_data']);
        $sumOutput              = 0;
        if (!empty($prodPlan)) {
            foreach ($prodPlan as $prod_plan) {
                #$sumOutput += $prod_plan->output?$prod_plan->output:0;
                $sumOutput += $prod_plan->output[0] ? $prod_plan->output[0] : 0;
            }
        }
        $PlanArray[$j]['sumOutput'] = $sumOutput;
        $j++;
    }
    $planCombinedArray = array();
    foreach ($PlanArray as $plan_Array) {
        if (array_key_exists($plan_Array['month'], $planCombinedArray)) {
            $planCombinedArray[$plan_Array['month']]['sumOutput'] += $plan_Array['sumOutput'];
            $planCombinedArray[$plan_Array['month']]['month'] = $plan_Array['month'];
        } else {
            $planCombinedArray[$plan_Array['month']] = $plan_Array;
        }
        
        $mergedData = array();
        foreach ($planCombinedArray as $month => $Plandata) {
            $mergedData[] = $Plandata;
        }
    }
    return $mergedData;
    
}



function getLeadStatusGraph($startDate = '', $endDate = '')
{
    
    $ci =& get_instance();
    
    $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
    
    $getPermissionsForDashboard = getPermissionsForDashboard(array(
        'permissions.user_id' => $_SESSION['loggedInUser']->id,
        'modules.id' => 5,
        'permissions.is_view' => 1
    ));
    $crm_leads_key              = array_search('leads', array_column($getPermissionsForDashboard, 'sub_module_name'));
    if ((gettype($crm_leads_key) != 'boolean' || $crm_leads_key != '') && $_SESSION['loggedInUser']->role == 2) {
        //$where = ' leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;
        
        $where = ' leads.created_by_cid=' . $ci->companyGroupId;
    } else if ($_SESSION['loggedInUser']->role == 1) {
        //$where = ' leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;
        
        $where = ' leads.created_by_cid=' . $ci->companyGroupId;
    } else {
        $where = ' leads.created_by=' . $_SESSION['loggedInUser']->u_id;
    }
    
    /*if($_SESSION['loggedInUser']->role == 2){ 
    $where = ' leads.created_by='.$_SESSION['loggedInUser']->u_id;
    }else{
    $where = ' leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;
    }	*/
    if ($startDate != '' && $endDate != '') {
        $btwQuery = ' AND leads.created_date >="' . $startDate . '" AND leads.created_date <="' . $endDate . '"';
    } else {
        $btwQuery = ' AND DATE_FORMAT(leads.created_date, "%Y") = YEAR (CURDATE())';
    }
    $qry = "SELECT COUNT(IF(leads.lead_status=1,1, NULL)) AS New , COUNT(IF(leads.lead_status=2,1, NULL)) AS Contacted , COUNT(IF(leads.lead_status=3,1, NULL)) AS Qualified, COUNT(IF(leads.lead_status=4,1, NULL)) AS Unqualified, COUNT(IF(leads.lead_status=5,1, NULL)) AS Win, COUNT(IF(leads.lead_status=6,1, NULL)) AS Loose FROM leads WHERE $where   $btwQuery";
    $CI =& get_instance();
    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
        $qryy = $CI->db->query($qry);
    } else {
        $dynamicdb = $CI->load->database('dynamicdb', TRUE);
        $qryy      = $dynamicdb->query($qry);
    }
    $result = $qryy->result_array();
    return $result;
}


function getWinLeadVsTotalGraph($startDate = '', $endDate = '')
{
    
    $ci =& get_instance();
    
    $ci->companyGroupId         = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
    $getPermissionsForDashboard = getPermissionsForDashboard(array(
        'permissions.user_id' => $_SESSION['loggedInUser']->id,
        'modules.id' => 5,
        'permissions.is_view' => 1
    ));
    $crm_leads_key              = array_search('leads', array_column($getPermissionsForDashboard, 'sub_module_name'));
    if ((gettype($crm_leads_key) != 'boolean' || $crm_leads_key != '') && $_SESSION['loggedInUser']->role == 2) {
        //$where = ' leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;
        
        $where = ' leads.created_by_cid=' . $ci->companyGroupId;
    } else if ($_SESSION['loggedInUser']->role == 1) {
        //$where = ' leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;
        
        $where = ' leads.created_by_cid=' . $ci->companyGroupId;
    } else {
        $where = ' leads.created_by=' . $_SESSION['loggedInUser']->u_id;
    }
    
    /*if($_SESSION['loggedInUser']->role == 2){ 
    $where = ' leads.created_by='.$_SESSION['loggedInUser']->u_id;
    }else{
    $where = ' leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;
    }	*/
    if ($startDate != '' && $endDate != '') {
        $btwQuery = ' AND leads.created_date >="' . $startDate . '" AND leads.created_date <="' . $endDate . '"';
    } else {
        $btwQuery = ' AND DATE_FORMAT(leads.created_date, "%Y") = YEAR (CURDATE())';
    }
    $qry = "SELECT COUNT(IF(leads.lead_status=5,1, NULL)) AS Win, COUNT(leads.lead_status) AS Total FROM leads WHERE $where   $btwQuery";
    $CI =& get_instance();
    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
        $qryy = $CI->db->query($qry);
    } else {
        $dynamicdb = $CI->load->database('dynamicdb', TRUE);
        $qryy      = $dynamicdb->query($qry);
    }
    $result = $qryy->result_array();
    return $result;
}

function getDashboardCount($startDate = '', $endDate = '')
{
    $ci =& get_instance();
    $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
    if ($_SESSION['loggedInUser']->role == 2) {
        $where                   = ' created_by=' . $_SESSION['loggedInUser']->u_id;
        $accountWhere            = ' created_by=' . $_SESSION['loggedInUser']->u_id;
        $BreakDownCompeltedWhere = ' created_by=' . $_SESSION['loggedInUser']->u_id . ' AND request_status=1';
    } else {        
        $where                   = ' created_by_cid=' . $ci->companyGroupId;
        $accountWhere            = ' account_owner=' . $ci->companyGroupId;
        $BreakDownCompeltedWhere = ' created_by=' . $_SESSION['loggedInUser']->u_id . ' AND request_status=1';
        
    }
    if ($startDate != '' && $endDate != '') {
        $btwQuery = ' AND created_date >="' . $startDate . '" AND created_date <="' . $endDate . '"';
    } else {
        $btwQuery = ' AND DATE_FORMAT(created_date, "%Y") = YEAR (CURDATE())';
    }
    $qry = "SELECT 'BreakDown' as name, 'Total BreakDown Created.' as description , 'fa fa-line-chart' as icon , COUNT(*) as totalCount FROM add_bd_request WHERE $where   $btwQuery
	UNION
	SELECT 'Compeleted BreakDown' as name, 'Total BreakDown Completed.' as description , 'fa fa-mobile-phone' as icon , COUNT(*) as totalCount FROM add_bd_request WHERE $BreakDownCompeltedWhere $btwQuery
	UNION
	SELECT 'Preventive' as name, 'Total Preventive created.' as description , 'fa fa-user' as icon , COUNT(*) as totalCount FROM add_preventive_data WHERE $where $btwQuery
	UNION
	SELECT  'Set Preventive' as name, 'Total sale order created.' as description , 'fa fa-cart-plus' as icon , COUNT(*) as totalCount FROM add_preventive_data WHERE $where   $btwQuery";
    $CI =& get_instance();
    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
        $qryy = $CI->db->query($qry);
    } else {
        $dynamicdb = $CI->load->database('dynamicdb', TRUE);
        $qryy      = $dynamicdb->query($qry);
    }
    $result = $qryy->result_array();
    return $result;
}
function change_new_task_status($table = '', $whereField = '', $whereValue = "")
{
    $sql = "UPDATE $table SET new_task_status = 1 WHERE $whereField = $whereField AND activity_type='New Task'";
    $CI =& get_instance();
    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
        $qryy = $CI->db->query($sql);
    } else {
        $dynamicdb = $CI->load->database('dynamicdb', TRUE);
        $qryy      = $dynamicdb->query($sql);
    }
    return $qryy;
}


function getMaxSaleOrderPriority()
{
    $ci =& get_instance();
    $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
    //$sql = "SELECT MAX(priority) as max_priority FROM sale_order_priority where created_by_cid = ".$_SESSION['loggedInUser']->c_id;
    $CI =& get_instance();
    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
        $CI->db->select('MAX(priority) as max_priority');
        $CI->db->from('sale_order_priority');
        //$CI->db->where('created_by_cid', $_SESSION['loggedInUser']->c_id);
        
        $CI->db->where('created_by_cid', $ci->companyGroupId);
        $qry = $CI->db->get();
    } else {
        $dynamicdb = $CI->load->database('dynamicdb', TRUE);
        $dynamicdb->select('MAX(priority) as max_priority');
        $dynamicdb->from('sale_order_priority');
        //$dynamicdb->where('created_by_cid', $_SESSION['loggedInUser']->c_id);
        
        $dynamicdb->where('created_by_cid', $ci->companyGroupId);
        $qry = $dynamicdb->get();
    }
    $result = $qry->row();
    return $result->max_priority;
    //return $qryy; 
}


function getSaleTargetByMonth($userId)
{
    $CI =& get_instance();
    $sql = "SELECT start_date, sum(sale_target) as saleTarget , sum(lead_generation_target) as leadGenerationTarget, sum(payment_target) as paymentTarget FROM `user_sale_target` WHERE user_id in( $userId ) group by start_date order by start_date desc";
    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
        $result = $CI->db->query($sql);
    } else {
        $dynamicdb = $CI->load->database('dynamicdb', TRUE);
        $result    = $dynamicdb->query($sql);
    }
    $saleTargetResult = $result->result_array();
    return $saleTargetResult;
}

/*function getSaleTargetEditDataByMonth($start_date = ''){
$CI =& get_instance();
$sql = "SELECT user_detail.u_id , user_detail.name, user_sale_target .* FROM `user_detail` left JOIN user_sale_target on user_detail.u_id = user_sale_target.user_id and user_sale_target.start_date = '$start_date'  WHERE user_detail.c_id = 2";
echo $sql;
$result = $CI->db->query($sql);
$saleTargetResult = $result->result_array();
return $saleTargetResult;
}*/

function getPermissionsForDashboard($where = array())
{
    $CI =& get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', TRUE);
    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
        $CI->db->select('permissions.*,sub_module.sub_module_name,sub_module.slug,modules.id as moduleId');
        $CI->db->from('permissions');
        $CI->db->join('sub_module', 'permissions.sub_module_id = sub_module.id', 'left');
        $CI->db->join('modules', 'modules.id = sub_module.modules_id', 'left');
        $CI->db->where($where);
        $query = $CI->db->get();
    } else {
        $dynamicdb->select('permissions.*,sub_module.sub_module_name,sub_module.slug,modules.id as moduleId');
        $dynamicdb->from('permissions');
        $dynamicdb->join('sub_module', 'permissions.sub_module_id = sub_module.id', 'left');
        $dynamicdb->join('modules', 'modules.id = sub_module.modules_id', 'left');
        $dynamicdb->where($where);
        $query = $dynamicdb->get();
    }
    $result = $query->result_array();
    return $result;
}
/**************************************export data**********************************/


function export_csv_excel($data3 = array())
{
    
    if (!empty($_POST['ExportType'])) {
        // pre($_POST);
        ob_end_clean();
        switch ($_POST["ExportType"]) {
            case "export-to-excel":
                // Submission from
                //$filename = $_POST["ExportType"] . ".xlsx";       
                //header("Content-Type: application/vnd.ms-excel");
                //header("Content-Disposition: attachment; filename=\"$filename\"");
                exportquotationexcle($data3);
                //$_POST["ExportType"] = '';
                exit();
            
            case "export-to-csv":
                // Submission from
                $filename = $_POST["ExportType"] . ".csv";
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Content-type: text/csv");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                header("Expires: 0");
                ExportCSVFile($data3);
                //$_POST["ExportType"] = '';
                exit();
            
            default:
                die("Unknown action : " . $_POST["action"]);
                break;
        }
    }
}




//  Helper For Exporting Quotation
function export_csv_excel_quot($data3 = array())
{
    if (!empty($_POST['ExportType'])) {
        // pre($_POST);
        ob_end_clean();
        switch ($_POST["ExportType"]) {
            case "export-to-excel":
                exportquotation($data3);
                exit();
            
            default:
                die("Unknown action : " . $_POST["action"]);
                break;
        }
    }
}


// Helper For Exporting PI
function export_csv_excel_pi($data3 = array())
{
    if (!empty($_POST['ExportType'])) {
        // pre($_POST);
        ob_end_clean();
        switch ($_POST["ExportType"]) {
            case "export-to-excel":
                exportpi($data3);
                exit();
            
            default:
                die("Unknown action : " . $_POST["action"]);
                break;
        }
    }
}


// Helper for Exporting SO

function export_csv_excel_so($data3 = array())
{
    if (!empty($_POST['ExportType'])) {
        // pre($_POST);
        ob_end_clean();
        switch ($_POST["ExportType"]) {
            case "export-to-excel":
                exportso($data3);
                exit();
            
            default:
                die("Unknown action : " . $_POST["action"]);
                break;
        }
    }
}






function export_csv_excel_blank($data_blank3 = array())
{
    if (!empty($_POST['ExportType_blank'])) {
        // pre($_POST);
        ob_end_clean();
        switch ($_POST["ExportType_blank"]) {
            case "export-to-blank-excel":
                // Submission from
                $filename = $_POST["ExportType_blank"] . ".xlsx";
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                ExportFile_blank($data_blank3);
                //$_POST["ExportType"] = '';
                exit();
            
            default:
                die("Unknown action : " . $_POST["action"]);
                break;
        }
    }
}

function ExportCSVFile($records)
{
    // create a file pointer connected to the output stream
    $fh      = fopen('php://output', 'w');
    $heading = false;
    if (!empty($records))
        ob_end_clean();
    foreach ($records as $row) {
        if (!$heading) {
            // output the column headings
            fputcsv($fh, array_keys($row));
            $heading = true;
        }
        // loop over the rows, outputting them
        fputcsv($fh, array_values($row));
        
    }
    fclose($fh);
}

function exportquotation($records)
{
    // $heading = false;
    if (!empty($records))
    //ob_end_clean();
        
    //create file name
        
    // $fileName = 'data-'.time().'.xlsx';  
        
    // load excel library
        $CI =& get_instance();
    $CI->load->library('excel');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    // set Header
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ID');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Purchase Id');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Machine Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Breakdown Couses');
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Machine Type');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Priority');
    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Request User');
    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Expacted Date');
    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Acknowledge By');
    // set Row
    $rowCount = 2;
    foreach ($records as $element) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['ID']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['Purchase Id']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['Machine Name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['Breakdown Couses']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['Machine Type']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['Priority']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['Request User']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['Expacted Date']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['Acknowledge By']);
        
        
        $rowCount++;
    }
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    
    $object_writer = new PHPExcel_Writer_Excel2007($objPHPExcel);
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=Export_Quotation.xlsx");
    ob_end_clean();
    $object_writer->save('php://output');
    
    
}



function exportquotationexcle($records)
{
    // $heading = false;
    if (!empty($records))
    //ob_end_clean();
        
    //create file name
        
    // $fileName = 'data-'.time().'.xlsx';  
        
    // load excel library
        $CI =& get_instance();
    $CI->load->library('excel');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    // set Header
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Machine ID');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Machine Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Preventive Maintenance');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Machine Parameter');
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Machine UOM');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Processes Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Make & Model');
    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Date of Purchase');
    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Placement');
    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Created Date');
    // set Row
    $rowCount = 2;
    foreach ($records as $element) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['Machine ID']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['Machine Name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['Preventive Maintenance']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['Machine Parameter']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['Machine UOM']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['Processes Name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['Make & Model']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['Date of Purchase']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['Placement']);
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['Created Date']);
        
        
        $rowCount++;
    }
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    
    $object_writer = new PHPExcel_Writer_Excel2007($objPHPExcel);
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=Export_Quotation.xlsx");
    ob_end_clean();
    $object_writer->save('php://output');
    
    
}

function exportpi($records)
{
    // $heading = false;
    if (!empty($records))
    //ob_end_clean();
        
    //create file name
        
    // $fileName = 'data-'.time().'.xlsx';  
        
    // load excel library
        $CI =& get_instance();
    $CI->load->library('excel');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    // set Header
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Proforma Invoice ID');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Account Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Contact Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Order Date');
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Dispatch Date');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Sub Total');
    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Total');
    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Payment Terms');
    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Created By');
    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Created Date');
    // set Row
    $rowCount = 2;
    foreach ($records as $element) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['Proforma Invoice']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['Account Name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['Contact Name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['Order Date']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['Dispatch Date']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['Sub Total']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['Total']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['Payment Terms']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['Created By']);
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['Created Date']);
        
        
        $rowCount++;
    }
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    
    $object_writer = new PHPExcel_Writer_Excel2007($objPHPExcel);
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=ExportPI.xlsx");
    ob_end_clean();
    $object_writer->save('php://output');
    
    
}


function exportso($records)
{
    // $heading = false;
    if (!empty($records))
    //ob_end_clean();
        
    //create file name
        
    // $fileName = 'data-'.time().'.xlsx';  
        
    // load excel library
        $CI =& get_instance();
    $CI->load->library('excel');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    // set Header
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sale Order No.');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Account Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Contact Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Order Date');
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Dispatch Date');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Sub Total');
    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Total');
    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Payment Terms');
    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Created By');
    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Created Date');
    // set Row
    $rowCount = 2;
    foreach ($records as $element) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['Sale Order No']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['Account Name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['Contact Name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['Order Date']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['Dispatch Date']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['Sub Total']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['Total']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['Payment Terms']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['Created By']);
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['Created Date']);
        
        
        $rowCount++;
    }
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    
    $object_writer = new PHPExcel_Writer_Excel2007($objPHPExcel);
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=ExportSO.xlsx");
    ob_end_clean();
    $object_writer->save('php://output');
    
    
}
function ExportFile_blank($records)
{
    
    $heading = false;
    if (!empty($records))
    //ob_end_clean();
        foreach ($records as $row) {
            if (!$heading) {
                // display field/column names as a first row
                echo implode("\t", array_keys($row)) . "\n";
                $heading = true;
            }
            echo implode("\t", array_values($row)) . "\n";
        }
    exit;
}

function getLastTableId($table = '')
{
    $CI =& get_instance();
    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3) {
        $query = $CI->db->query("SELECT * FROM $table ORDER BY id DESC LIMIT 1");
    } else {
        $dynamicdb = $CI->load->database('dynamicdb', TRUE);
        $query     = $dynamicdb->query("SELECT * FROM $table ORDER BY id DESC LIMIT 1");
    }
    $result = $query->row();
    if (!empty($result))
        return $result->id;
    else
        return false;
}
function getBreakDownTargetVSActualListingGraph($startDate = '', $endDate = ''){	
	$companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
    if ($_SESSION['loggedInUser']->role == 2) {
        $where = ' AND add_bd_request.created_by=' . $_SESSION['loggedInUser']->u_id;
    } else {
        $where = ' AND add_bd_request.created_by_cid=' . $companyGroupId;
    }
	$btwQuery = '';
    if ($startDate != '' && $endDate != '') {
        $btwQuery = ' AND add_bd_request.created_date >="' . $startDate . '" AND add_bd_request.created_date <="' . $endDate . '"';
    }
	$query="SELECT substring( concat('January' ,' February' ,' March' ,' April' ,' May' ,' June' ,' July' ,' August' ,'September' ,' October' ,' November' ,' December' ) , m*9 - 8 , 9 ) as period ,COUNT(IF(add_bd_request.request_status=1,1, 0)) AS compeleted , COUNT(IF(add_bd_request.request_status=0,1, 0)) AS breakdown FROM ( SELECT 1 as m UNION SELECT 2 as m UNION SELECT 3 as m UNION SELECT 4 as m UNION SELECT 5 as m UNION SELECT 6 as m UNION SELECT 7 as m UNION SELECT 8 as m UNION SELECT 9 as m UNION SELECT 10 as m UNION SELECT 11 as m UNION SELECT 12 as m ) as Months LEFT JOIN add_bd_request on Months.m = MONTH(add_bd_request.created_date) $where AND DATE_FORMAT(add_bd_request.created_date, '%Y') = YEAR (CURDATE()) $btwQuery GROUP BY Months.m";
	$CI =& get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', TRUE);
    $query      = $dynamicdb->query($query);
	$result    = $query->result_array();
	$labels = array("Jan", "Feb", "March", "April", "May", "June", "July","Aug","Sept","Oct","Nov","Dec");
		foreach ($result as $res) {
			   $data['compeleted'][] = $res['compeleted'];
			   $data['breakdown'][] = $res['breakdown'];
		}

	 $datasets[] = array('label'=>"compeleted",'backgroundColor'=> "#26B99A",'data'=> $data['compeleted']);
	$datasets[] = array('label'=>"breakdown",'backgroundColor'=> "#03586A",'data'=> $data['breakdown']);
	$data_array = array('labels'=>$labels,'datasets'=> $datasets);
	return $data_array;	
	//echo json_encode($data);
}
function getBreakDownPurchanseGraph($startDate = '', $endDate = ''){	
	$CI =& get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
    if ($_SESSION['loggedInUser']->role == 2) {
        $where = ' AND add_bd_request.created_by=' . $_SESSION['loggedInUser']->u_id;
    } else {
        $where = ' AND add_bd_request.created_by_cid=' . $companyGroupId;
    }
			$btwQuery = '';
			if ($startDate != '' && $endDate != '') {
			$btwQuery = ' AND purchase_indent.created_date >="'.$startDate . '" AND purchase_indent.created_date <="' .$endDate . '"' ;

			}
			$whereCompletePI = ' purchase_indent.created_by_cid='.$companyGroupId.' AND purchase_indent.save_status=1 AND purchase_indent.mrn_or_not = 1 AND purchase_indent.po_or_not = 1 AND purchase_indent.pay_or_not=1 AND purchase_indent.ifbalance = 0';

		$piAmountSql="SELECT date_format(purchase_indent.created_date,'%c') as month, sum(purchase_indent.grand_total) as total  FROM add_bd_request LEFT JOIN purchase_indent ON add_bd_request.purchase_id = purchase_indent.id where $whereCompletePI $btwQuery group by year(purchase_indent.created_date), month(purchase_indent.created_date)";
		 $piAmountSql      = $dynamicdb->query($piAmountSql);
         $result    = $piAmountSql->result_array();
		$labels = array("Jan", "Feb", "March", "April", "May", "June", "July","Aug","Sept","Oct","Nov","Dec");

		

			for($i = 1; $i <= 12; $i++)
			{ 
				$key = array_search($i, array_column($result, 'month'));
				if(is_numeric($key)){
				$data['breakdown'][] = !empty($result[$key]['total'])?$result[$key]['total']:0;
				}else{
				$data['breakdown'][] = 0;	
				}
			}
	$datasets[] = array('label'=>"breakdown",'backgroundColor'=> "#e78484",'data'=> $data['breakdown']);
	$data_array = array('labels'=>$labels,'datasets'=> $datasets);
	return $data_array;	
}
?>
