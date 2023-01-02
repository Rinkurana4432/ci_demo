<?php 	
/**
 Get Department data for Datatable Listing
*/

function leadStatus(){
	$leadStatus = array('New','Contacted','Qualified','Unqualified','Win','Loose');
	return $leadStatus;
}

function leadSource(){
	$leadSource = array('Advertisement','Employee Referral','External Referral','Other','Social','Trade Show','Web','Word of mouth','Alibaba RFQ','Alibaba Message Inbox','Indiamart Enquiry','Google Search','Export Data','Website - www.azukaropes.com');
	return $leadSource;
}

function leadActivityStatus(){
	$leadActivityStatus = array('Call','Send Letter','Send Quote','Other');
	return $leadActivityStatus;
}


function accountType(){
	$accountTypes = array('Analyst','Competitor','Customer','Integrator','Investor','Partner','Press','Prospect','Reseller','Other');
	return $accountTypes;
}

function industries(){
	$industries = array('Agriculture','Apparel','Banking','Biotechnology','Chemicals','Communications','Construction','Consulting','Education','Electronics','Energy','Engineering','Entertainment','Environmental','Finance','Food','Government','Healthcare','Hospitality','Insurance','Machinery','Manufacturing','Media','Not For Profit','Recreation','Retail','Shipping','Technology','Telecommunications','Transportation','Utilities','Other');
	return $industries;
}

function getNameById($table='',$id='',$field=''){	
	$qry="select * from $table where $field='$id'";
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryy = $CI->db->query($qry);
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
	}		
	$result = $qryy->row();	
	return $result;	
}

function getAttachmentsById($table='',$id='',$rel_type=''){
	$qry="select * from $table where rel_id='$id' AND rel_type='$rel_type'";
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryy = $CI->db->query($qry);
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);	
	}
	$result = $qryy->result_array();	
	return $result;	
}



/*function measurementUnits(){
	$measurementUnits = array('Meter/Metre','Millimeter','Centimeter','Decimeter','Kilometer','Inch','Foot','Yard','Square meter','Square inches','Square feet','Cubic meter','Liter','Milliliter','Centiliter','Deciliter','Hectoliter','Cubic Inch','Quart','Gallon','Grams','Kilogram','Grain','Ounce','Pound','Ton','Tonne');
	return $measurementUnits;
}*/



function paymentTerms(){
	$paymentTerms = array('Advance','Credit','30 Days','45 Days','60 Days','90 Days','Against PDC');
	return $paymentTerms;
}

function documentSubmitedWithDispatch(){        
	$documentSubmitedWithDispatch = array('Orignal Invoice','Duplicate Invoice','Packing List','Insurance','Test Certificate','Test Report','Way Bill','AGT Receipt','GR Copy' ,"Customer's PO Copy");
	return $documentSubmitedWithDispatch;
}

function discountOffered(){  
	$discountOffered = array('Cash Discount','UOM Rate','Quantity Discount','Annual Ternover Discount');
	return $discountOffered;
}

	function create_pdf($dataPdf = array(), $page = ''){		
		$CI =& get_instance();
		$CI->load->library('Pdf');
        $pdf=new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'UTF-8', false);		
        $pdf->AddPage();
		//include(APPPATH . '/purchase_order/' . $module_nm . '/views/view_pdf.php');
		//include(APPPATH .'modules/crm/views/proforma_invoices/view_pdf.php');
		//include(APPPATH .'modules/crm/views/proforma_invoices/view_pdf1.php');
		include(APPPATH .$page);
		$pdf->Output(); 
	}
	
	
	
function monthLeadStatusGraph($startDate = '', $endDate = ''){

	$ci = & get_instance();

	 $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


	$getPermissionsForDashboard = getPermissionsForDashboard(array('permissions.user_id' => $_SESSION['loggedInUser']->id,'modules.id'=>5,'permissions.is_view'=>1));
	$crm_leads_key = array_search('register_opportunity', array_column($getPermissionsForDashboard, 'sub_module_name'));
	if( (gettype($crm_leads_key) != 'boolean' || $crm_leads_key != '')  && $_SESSION['loggedInUser']->role == 2){	
		$where = ' AND register_opportunity.created_by_cid='.$this->companyGroupId;
	}else if( $_SESSION['loggedInUser']->role == 1){
		$where = ' AND register_opportunity.created_by_cid='.$ci->companyGroupId;
	}else{
		$where = ' AND register_opportunity.created_by='.$_SESSION['loggedInUser']->u_id;
	}
	
	
	/*if($_SESSION['loggedInUser']->role == 2 ){ 
		$where = ' AND leads.created_by='.$_SESSION['loggedInUser']->u_id;
	}else{
		$where = ' AND leads.created_by_cid='.$ci->companyGroupId;
	}*/
	
	$btwQuery = '' ;
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND register_opportunity.created_date >="'.$startDate . '" AND register_opportunity.created_date <="' .$endDate . '"' ;
	}
	
	$qry="SELECT  substring(
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
         , 9 ) as period , COUNT(IF(register_opportunity.tender_status=1,1, NULL)) AS New , COUNT(IF(register_opportunity.tender_status=2,1, NULL)) AS Qualified , COUNT(IF(register_opportunity.tender_status=3,1, NULL)) AS Unqualified, COUNT(IF(register_opportunity.tender_status=4,1, NULL)) AS Submited , COUNT(IF(register_opportunity.tender_status=5,1, NULL)) AS Lost, COUNT(IF(register_opportunity.tender_status=6,1, NULL)) AS Awarded,  COUNT(IF(register_opportunity.tender_status=7,1, NULL)) AS Emo_Pending, COUNT(IF(register_opportunity.tender_status=8,1, NULL)) AS Closed FROM 
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
LEFT JOIN register_opportunity  on Months.m = MONTH(register_opportunity.created_date) $where AND DATE_FORMAT(register_opportunity.created_date, '%Y') = YEAR (CURDATE()) $btwQuery 
GROUP BY
    Months.m";	
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryy = $CI->db->query($qry);	
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);	
	}
	
	$result = $qryy->result_array();	
	return $result;	
}

function monthLeadTargetGraph($startDate = '', $endDate = ''){	

	$ci = & get_instance();

	 $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


	$getPermissionsForDashboard = getPermissionsForDashboard(array('permissions.user_id' => $_SESSION['loggedInUser']->id,'modules.id'=>5,'permissions.is_view'=>1));
	$crm_sale_target_key = array_search('sale target', array_column($getPermissionsForDashboard, 'sub_module_name'));
	if( (gettype($crm_sale_target_key) != 'boolean' || $crm_sale_target_key != '')  && $_SESSION['loggedInUser']->role == 2){	
		$whereTarget = 'AND user_sale_target.user_id='.$ci->companyGroupId;
		$whereAchieved = 'AND leads.created_by_cid='.$ci->companyGroupId;
	}else if( $_SESSION['loggedInUser']->role == 1){
			$whereTarget = 'AND user_sale_target.user_id='.$ci->companyGroupId;
		$whereAchieved = 'AND leads.created_by_cid='.$ci->companyGroupId;
	}else{
		$whereTarget = 'AND user_sale_target.user_id='.$_SESSION['loggedInUser']->u_id;
		$whereAchieved = 'AND leads.created_by='.$_SESSION['loggedInUser']->u_id;
	}
	



	/*if($_SESSION['loggedInUser']->role == 2){ 
		$whereTarget = 'AND user_sale_target.user_id='.$_SESSION['loggedInUser']->u_id;
		$whereAchieved = 'AND leads.created_by='.$_SESSION['loggedInUser']->u_id;
	}else{
		$whereTarget = 'AND user_sale_target.user_id='.$ci->companyGroupId;
		$whereAchieved = 'AND leads.created_by_cid='.$ci->companyGroupId;
	}*/
	
	//$btwQuery = '' ;
	//$btwLeadQuery = '' ;
	if($startDate != '' && $endDate != ''){ 
		$dateQuery = ' AND user_sale_target.created_date >="'.$startDate . '" AND user_sale_target.created_date <="' .$endDate . '"' ;
		$dateLeadQuery = ' AND leads.created_date >="'.$startDate . '" AND leads.created_date <="' .$endDate . '"' ;
	}else{
		$dateQuery = ' AND DATE_FORMAT(user_sale_target.created_date, "%Y") = YEAR (CURDATE())' ;
		$dateLeadQuery = ' AND DATE_FORMAT(leads.created_date, "%Y") = YEAR (CURDATE())' ;
	}
	
$qry = "SELECT SUM(user_sale_target.lead_generation_target)  AS leadTarget FROM 
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
LEFT JOIN user_sale_target  on Months.m = MONTH(user_sale_target.start_date)  $whereTarget AND DATE_FORMAT(user_sale_target.start_date, '%Y') = YEAR (CURDATE()) $dateQuery   
GROUP BY
    Months.m";
	$CI =& get_instance();	
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryy = $CI->db->query($qry);
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
	}	
	$result = $qryy->result_array();
	$leadTargetArray = array();
	foreach($result as $res){
		$leadTargetArray[] = $res['leadTarget'];
	}
	
	$sqlAcheived = "SELECT  COUNT(IF(leads.lead_status=5,1, NULL)) AS acheived FROM 
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
LEFT JOIN leads  on Months.m = MONTH(leads.created_date)  $whereAchieved AND DATE_FORMAT(leads.created_date, '%Y') = YEAR (CURDATE()) $dateLeadQuery
GROUP BY
    Months.m";
	
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryyAcheived = $CI->db->query($sqlAcheived);	
	}else{
		$qryyAcheived = $dynamicdb->query($sqlAcheived);	
		
	}
	$resultAcheived = $qryyAcheived->result_array();
	$leadAcheivedArray = array();
	foreach($resultAcheived as $resAcheived){
		$leadAcheivedArray[] = $resAcheived['acheived'];
	}
	
	
	return array('leadTarget'=>$leadTargetArray , 'leadAcheived'=> $leadAcheivedArray);;	
	}
	
	
	
function monthSaleOrderGraph($startDate = '', $endDate = ''){

	$ci = & get_instance();

	 $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


	$getPermissionsForDashboard = getPermissionsForDashboard(array('permissions.user_id' => $_SESSION['loggedInUser']->id,'modules.id'=>5,'permissions.is_view'=>1));
	$crm_sale_order_key = array_search('sale orders', array_column($getPermissionsForDashboard, 'sub_module_name'));
	if( (gettype($crm_sale_order_key) != 'boolean' || $crm_sale_order_key != '')  && $_SESSION['loggedInUser']->role == 2){	
			$where = ' AND sale_order.created_by_cid='.$ci->companyGroupId;
	}else if( $_SESSION['loggedInUser']->role == 1){
			$where = ' AND sale_order.created_by_cid='.$ci->companyGroupId;
	}else{
			$where = ' AND sale_order.created_by='.$_SESSION['loggedInUser']->id;
	}
	/*if($_SESSION['loggedInUser']->role == 2){ 
		//$where = ' AND sale_order.created_by='.$_SESSION['loggedInUser']->u_id;
		$where = ' AND sale_order.created_by_cid='.$ci->companyGroupId;
	}else{
		$where = ' AND sale_order.created_by_cid='.$ci->companyGroupId;
	}*/
	
	
	if($startDate != '' && $endDate != ''){ 
		$dateQuery = ' AND sale_order.created_date >="'.$startDate . '" AND sale_order.created_date <="' .$endDate . '"' ;
	}else{ 
		$dateQuery = ' AND DATE_FORMAT(sale_order.created_date, "%Y") = YEAR (CURDATE())' ;
		}
	
/*	$qry="SELECT  substring(
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
         , 9 ) as period , COUNT(IF(sale_order.approve=1,1, NULL)) AS Approve , COUNT(IF(sale_order.disapprove=1,1, NULL)) AS Disapprove FROM 
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
LEFT JOIN sale_order  on Months.m = MONTH(sale_order.created_date) $where $dateQuery 
GROUP BY
    Months.m";	 */
	
	$qry="SELECT  substring(
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
         , 9 ) as period ,COUNT(IF(sale_order.approve=1,1, NULL)) AS Approve , COUNT(IF(sale_order.disapprove=1,1, NULL)) AS Disapprove  , SUM(sale_order.`grandTotal`) as Amount  FROM 
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
LEFT JOIN sale_order  on Months.m = MONTH(sale_order.created_date) $where $dateQuery 
GROUP BY
    Months.m";	
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryy = $CI->db->query($qry);
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
		
	}
	$result = $qryy->result_array();	
	return $result;	
}



function getLeadStatusGraph($startDate = '', $endDate = ''){

	$ci = & get_instance();

	 $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


	$getPermissionsForDashboard = getPermissionsForDashboard(array('permissions.user_id' => $_SESSION['loggedInUser']->id,'modules.id'=>5,'permissions.is_view'=>1));
	$crm_leads_key = array_search('leads', array_column($getPermissionsForDashboard, 'sub_module_name'));
	if( (gettype($crm_leads_key) != 'boolean' || $crm_leads_key != '')  && $_SESSION['loggedInUser']->role == 2){	
				$where = ' leads.created_by_cid='.$ci->companyGroupId;
	}else if( $_SESSION['loggedInUser']->role == 1){
		$where = ' leads.created_by_cid='.$ci->companyGroupId;
	}else{
		$where = ' leads.created_by='.$_SESSION['loggedInUser']->u_id;
	}

	/*if($_SESSION['loggedInUser']->role == 2){ 
		$where = ' leads.created_by='.$_SESSION['loggedInUser']->u_id;
	}else{
		$where = ' leads.created_by_cid='.$ci->companyGroupId;
	}	*/	
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND leads.created_date >="'.$startDate . '" AND leads.created_date <="' .$endDate . '"' ;
	}else{
		$btwQuery = ' AND DATE_FORMAT(leads.created_date, "%Y") = YEAR (CURDATE())' ;
	}
	$qry="SELECT COUNT(IF(leads.lead_status=1,1, NULL)) AS New , COUNT(IF(leads.lead_status=2,1, NULL)) AS Contacted , COUNT(IF(leads.lead_status=3,1, NULL)) AS Qualified, COUNT(IF(leads.lead_status=4,1, NULL)) AS Unqualified, COUNT(IF(leads.lead_status=5,1, NULL)) AS Win, COUNT(IF(leads.lead_status=6,1, NULL)) AS Loose FROM leads WHERE $where   $btwQuery";	
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryy = $CI->db->query($qry);		
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
	}
	$result = $qryy->result_array();	
	return $result;	
}


function getWinLeadVsTotalGraph($startDate = '', $endDate = ''){	

	$ci = & get_instance();

	 $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

	$getPermissionsForDashboard = getPermissionsForDashboard(array('permissions.user_id' => $_SESSION['loggedInUser']->id,'modules.id'=>5,'permissions.is_view'=>1));
	$crm_leads_key = array_search('register_opportunity', array_column($getPermissionsForDashboard, 'sub_module_name'));
	if( (gettype($crm_leads_key) != 'boolean' || $crm_leads_key != '')  && $_SESSION['loggedInUser']->role == 2){	
				$where = ' register_opportunity.created_by_cid='.$ci->companyGroupId;
	}else if( $_SESSION['loggedInUser']->role == 1){
		$where = ' register_opportunity.created_by_cid='.$ci->companyGroupId;
	}else{
		$where = ' register_opportunity.created_by='.$_SESSION['loggedInUser']->u_id;
	}

	/*if($_SESSION['loggedInUser']->role == 2){ 
		$where = ' leads.created_by='.$_SESSION['loggedInUser']->u_id;
	}else{
		$where = ' leads.created_by_cid='.$ci->companyGroupId;
	}	*/	
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND register_opportunity.created_date >="'.$startDate . '" AND register_opportunity.created_date <="' .$endDate . '"' ;
	}else{
		$btwQuery = ' AND DATE_FORMAT(register_opportunity.created_date, "%Y") = YEAR (CURDATE())' ;
	}
	$qry="SELECT COUNT(IF(register_opportunity.tender_status=6,1, NULL)) AS Win, COUNT(register_opportunity.tender_status) AS Total FROM register_opportunity WHERE $where   $btwQuery";	
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryy = $CI->db->query($qry);
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
	}
	$result = $qryy->result_array();	
	return $result;	
}

function getDashboardCount($startDate = '', $endDate = ''){

	$ci = & get_instance();

	 $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


	if($_SESSION['loggedInUser']->role == 2){ 
		$where = ' created_by='.$_SESSION['loggedInUser']->u_id;		
		$accountWhere = ' created_by='.$_SESSION['loggedInUser']->u_id;
		$contactWhere = ' created_by='.$_SESSION['loggedInUser']->u_id;
		
	}else{
		$where = ' created_by_cid='.$ci->companyGroupId;
		$accountWhere = ' account_owner='.$ci->companyGroupId;
		$contactWhere = ' contact_owner='.$ci->companyGroupId;
	}		
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND created_date >="'.$startDate . '" AND created_date <="' .$endDate . '"' ;
	}else{
		$btwQuery = ' AND DATE_FORMAT(created_date, "%Y") = YEAR (CURDATE())' ;
	}
	$qry="SELECT 'Bids' as name, 'Total Bids created.' as description , 'fa fa-line-chart' as icon , COUNT(*) as totalCount FROM register_opportunity WHERE $where   $btwQuery";
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryy = $CI->db->query($qry);
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
	}
	$result = $qryy->result_array();	
	return $result;	
}
	
	
function recentActivitiesDashboardData($startDate = '', $endDate = ''){

	$ci = & get_instance();

	 $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


	if($_SESSION['loggedInUser']->role == 2){ 
		$where = ' lead_activity.created_by='.$_SESSION['loggedInUser']->u_id .' AND lead_activity.activity_type="New Task" AND lead_activity.new_task_status = 0' ;
		$accountWhere = ' account_activity.created_by='.$_SESSION['loggedInUser']->u_id;
		//$saleOrderWhere = ' sale_order.created_by='.$_SESSION['loggedInUser']->u_id;
		$saleOrderWhere = ' sale_order.created_by_cid='.$ci->companyGroupId;
	}else{
		$where = ' lead_activity.created_by_cid='.$ci->companyGroupId .' AND lead_activity.activity_type="New Task" AND lead_activity.new_task_status = 0' ;
		$accountWhere = ' account_activity.created_by_cid='.$ci->companyGroupId;
		$saleOrderWhere = ' sale_order.created_by_cid='.$ci->companyGroupId;
	}		
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND lead_activity.created_date >="'.$startDate . '" AND lead_activity.created_date <="' .$endDate . '"' ;
		$accountBtwQuery = ' AND account_activity.created_date >="'.$startDate . '" AND account_activity.created_date <="' .$endDate . '"' ;
		$saleOrderBtwQuery = ' AND sale_order.payment_date >="'.$startDate . '" AND sale_order.payment_date <="' .$endDate . '" AND payment_status = 0' ;
	}else{
		$btwQuery = ' AND DATE_FORMAT(lead_activity.created_date, "%Y") = YEAR (CURDATE())' ;
		$accountBtwQuery = ' AND DATE_FORMAT(account_activity.created_date, "%Y") = YEAR (CURDATE())' ;
		$saleOrderBtwQuery = ' AND YEAR(sale_order.payment_date) = YEAR(CURRENT_DATE()) AND MONTH(sale_order.payment_date) = MONTH(CURRENT_DATE()) AND sale_order.payment_status = 0' ;
	} 
	  
	$leadActivitySql="SELECT lead_activity.*, leads.company,user_detail.name from lead_activity LEFT JOIN leads ON lead_activity.lead_id = leads.id LEFt JOIN user_detail ON lead_activity.assigned_to = user_detail.u_id WHERE $where $btwQuery ORDER BY lead_activity.due_date desc";	
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$leadActivityQry = $CI->db->query($leadActivitySql);
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
		$leadActivityQry = $dynamicdb->query($leadActivitySql);
	}
	$leadActivityResult = $leadActivityQry->result_array();		
	$accountActivitySql="SELECT account_activity.*, user_detail.name from account_activity LEFT JOIN account ON account_activity.account_id = account.id LEFt JOIN user_detail ON account_activity.assigned_to = user_detail.u_id WHERE $accountWhere $accountBtwQuery ORDER BY account_activity.due_date desc";
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$accountActivityQry = $CI->db->query($accountActivitySql);
	}else{
		$accountActivityQry = $dynamicdb->query($accountActivitySql);
	}
	$accountActivityResult = $accountActivityQry->result_array();		
	$saleOrderActivitySql="SELECT sale_order.*,account.name , contacts.first_name, contacts.last_name from sale_order LEFT JOIN account ON account.id = sale_order.account_id LEFT JOIN contacts ON contacts.id = sale_order.contact_id   WHERE $saleOrderWhere $saleOrderBtwQuery ORDER BY sale_order.payment_date asc";	
	$saleOrderActivityQry = $CI->db->query($saleOrderActivitySql);
	$saleOrderActivityResult = $saleOrderActivityQry->result_array();	
	$activityArray = array();
	$activityArray = array('leadActivity' => $leadActivityResult , 'accountActivity' => $accountActivityResult , 'saleOrderActivity' => $saleOrderActivityResult);	
	return $activityArray;	
}

function getCrmTableData($startDate = '', $endDate = ''){

	$ci = & get_instance();

	 $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


	if($_SESSION['loggedInUser']->role == 2){ 
		$leadWhere = ' created_by='.$_SESSION['loggedInUser']->u_id ;
		$accountWhere = ' created_by='.$_SESSION['loggedInUser']->u_id;
	}else{
		$leadWhere = ' created_by_cid='.$ci->companyGroupId ;
		$accountWhere = ' account_owner='.$ci->companyGroupId;
	}		
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND created_date >="'.$startDate . '" AND created_date <="' .$endDate . '"' ;
		$accountBtwQuery = ' AND created_date >="'.$startDate . '" AND created_date <="' .$endDate . '"' ;
	}else{
		$btwQuery = ' AND DATE_FORMAT(created_date, "%Y") = YEAR (CURDATE())' ;
		$accountBtwQuery = ' AND DATE_FORMAT(created_date, "%Y") = YEAR (CURDATE())' ;
	}
	
	
	$leadTblSql="SELECT * from leads WHERE $leadWhere $btwQuery ORDER BY created_date desc limit 10";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
	$leadTblQry = $dynamicdb->query($leadTblSql);
	$leadTblResult = $leadTblQry->result_array();		
	$accountTblSql="SELECT * from account WHERE $accountWhere $accountBtwQuery ORDER BY created_date desc limit 10";
	#$CI =& get_instance();
	$accountTblQry = $dynamicdb->query($accountTblSql);
	$accountTblResult = $accountTblQry->result_array();	
	$activityArray = array();
	$activityArray = array('leadTbl' => $leadTblResult , 'accountTbl' => $accountTblResult);	
	return $activityArray;	
}

function change_new_task_status($table = '' ,$whereField = '' , $whereValue=""){	
	$sql = "UPDATE $table SET new_task_status = 1 WHERE $whereField = $whereField AND activity_type='New Task'";
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryy = $CI->db->query($sql);
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
		$qryy = $dynamicdb->query($sql);
	}		
	return $qryy;
}


function getMaxSaleOrderPriority(){

	$ci = & get_instance();

	 $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


	 
	//$sql = "SELECT MAX(priority) as max_priority FROM sale_order_priority where created_by_cid = ".$ci->companyGroupId;
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$CI->db->select('MAX(priority) as max_priority');   
		$CI->db->from('sale_order_priority');
		$CI->db->where('created_by_cid', $ci->companyGroupId);
		$qry = $CI->db->get();	
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('MAX(priority) as max_priority');   
		$dynamicdb->from('sale_order_priority');
		$dynamicdb->where('created_by_cid', $ci->companyGroupId);
		$qry = $dynamicdb->get();	
	}
	$result  = $qry->row();
	return $result->max_priority;	
	//return $qryy; 
}


function getSaleTargetByMonth($userId){
	$CI =& get_instance();	
	$sql = "SELECT start_date, sum(sale_target) as saleTarget , sum(lead_generation_target) as leadGenerationTarget, sum(payment_target) as paymentTarget FROM `user_sale_target` WHERE user_id in( $userId ) group by start_date order by start_date desc";
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$result = $CI->db->query($sql);
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
		$result = $dynamicdb->query($sql);
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

function getAcheivedPaymentTargetByUserIdAndDate($userId = '' , $created_date = '' ){
	$CI =& get_instance();
	$sql = "SELECT SUM(grandTotal) as acheivedPaymentTarget FROM `sale_order` WHERE created_by = $userId AND created_date like('$created_date%')";
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$result = $CI->db->query($sql);
	}else{	
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
		$result = $dynamicdb->query($sql);
	}
	$acheivedPaymentTarget = $result->result_array();
	return $acheivedPaymentTarget;
}
function getPermissionsForDashboard($where = array()){ 
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
		if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
			$CI->db->select('permissions.*,sub_module.sub_module_name,sub_module.slug,modules.id as moduleId');
			$CI->db->from('permissions');
			$CI->db->join('sub_module', 'permissions.sub_module_id = sub_module.id', 'left');
			$CI->db->join('modules', 'modules.id = sub_module.modules_id', 'left');
			$CI->db->where($where);
			$query = $CI->db->get();
		}else{
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


function export_csv_excel($data3 = array()){
	 if(!empty($_POST['ExportType'])){
		 ob_end_clean();
		switch($_POST["ExportType"])
		{
			case "export-to-excel" :
				// Submission from
				$filename = $_POST["ExportType"] . ".xls"; 
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				ExportFile($data3);
				exit();
			case "export-to-csv" :
				// Submission from
				$filename = $_POST["ExportType"] . ".csv";            
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-type: text/csv");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				header("Expires: 0");
				ExportCSVFile($data3);
				//$_POST["ExportType"] = '';
				exit();
			case "export-to-blank-excel" :
				// Submission from
				$filename = $_POST["ExportType"] . ".xlsx";       
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				ExportFile_blank($data3);
				//$_POST["ExportType"] = '';
            exit();			
			
			default :
				die("Unknown action : ".$_POST["action"]);
				break;
		}
	 }
}


function ExportFile($records) {
	
	$heading = false;
    if(!empty($records))
		//ob_end_clean();
      foreach($records as $row) {
        if(!$heading) {
          // display field/column names as a first row
          echo implode("\t", array_keys($row)) . "\n";
          $heading = true;
        }
        echo implode("\t", array_values($row)) . "\n";
      }
    exit;
}


//  Helper For Exporting Quotation
function export_csv_excel_quot($data3 = array()){
	 if(!empty($_POST['ExportType'])){
		// pre($_POST);
		 ob_end_clean();
		switch($_POST["ExportType"])
		{
			case "export-to-excel" :
				exportquotation($data3);
				exit();	
			
			default :
				die("Unknown action : ".$_POST["action"]);
				break;
		}
	 }
}


// Helper For Exporting PI
function export_csv_excel_pi($data3 = array()){
	 if(!empty($_POST['ExportType'])){
		// pre($_POST);
		 ob_end_clean();
		switch($_POST["ExportType"])
		{
			case "export-to-excel" :
				exportpi($data3);
				exit();	
			
			default :
				die("Unknown action : ".$_POST["action"]);
				break;
		}
	 }
}


// Helper for Exporting SO








function export_csv_excel_blank($data_blank3 = array()){
	 if(!empty($_POST['ExportType_blank'])){
		// pre($_POST);
		 ob_end_clean();
		switch($_POST["ExportType_blank"])
		{
			case "export-to-blank-excel" :
				// Submission from
				$filename = $_POST["ExportType_blank"] . ".xlsx";       
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				ExportFile_blank($data_blank3);
				//$_POST["ExportType"] = '';
            exit();			
			
			default :
				die("Unknown action : ".$_POST["action"]);
				break;
		}
	 }
}
 
function ExportCSVFile($records) {
    // create a file pointer connected to the output stream
    $fh = fopen( 'php://output', 'w' );
    $heading = false;
        if(!empty($records))
			ob_end_clean();
          foreach($records as $row) {
            if(!$heading) {
              // output the column headings
              fputcsv($fh, array_keys($row));
              $heading = true;
            }
            // loop over the rows, outputting them
             fputcsv($fh, array_values($row));
              
          }
          fclose($fh);
}
 
function exporttender($records) {
   // $heading = false;
    if(!empty($records))
		//ob_end_clean();

 //create file name
       // $fileName = 'data-'.time().'.xlsx';  
    // load excel library
    	$CI =& get_instance();
        $CI->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Tender Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Tender Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Issue Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Bid Clossing Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'EMD Amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Tender Amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Tender Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Status Comment');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Filling Date');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Location');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Department');
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Bid id');
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Item Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Qty');
        // set Row
        $rowCount = 2;
        foreach ($records as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['Tender Number']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['Tender Type']);
              $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['Issue Date']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['Bid Clossing Date']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['EMD Amount']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['Tender Amount']);
           $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['Tender Status']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['Status Comment']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['Filling Date']);
 			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['Location']);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['Department']);
			$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['Bid id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['Item Name']);
			$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['Qty']);
            $rowCount++;
        }

      //$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 

		$object_writer = new PHPExcel_Writer_Excel2007($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
	    header("Content-Disposition: attachment;filename=Export_Tender.xlsx");
		ob_end_clean();
		$object_writer->save('php://output');

    
}

function exportpi($records) {
   // $heading = false;
    if(!empty($records))
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


function exportso($records) {
   // $heading = false;
    if(!empty($records))
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
function ExportFile_blank($records) {
	
    $heading = false;
    if(!empty($records))
		//ob_end_clean();
      foreach($records as $row) {
        if(!$heading) {
          // display field/column names as a first row
          echo implode("\t", array_keys($row)) . "\n";
          $heading = true;
        }
        echo implode("\t", array_values($row)) . "\n";
      }
    exit;
}

function getLastTableId($table=''){
		$CI =& get_instance();
		if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
			$query = $CI->db->query("SELECT * FROM $table ORDER BY id DESC LIMIT 1");
		}else{
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$query = $dynamicdb->query("SELECT * FROM $table ORDER BY id DESC LIMIT 1");
		}
		$result = $query->row();
		if(!empty($result))	
			return $result->id;
		else return false;
	}

	?>
