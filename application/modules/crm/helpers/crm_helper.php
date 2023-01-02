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

		#echo $dynamicdb->last_query();
	}		
	$result = $qryy->row();	
	return $result;	
}
function getNameBySearch($table='',$id='',$field=''){
	$qry="select * from $table where $field like '%$id%'";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$qryy = $dynamicdb->query($qry);	
	$result = $qryy->result_array();	
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
	$crm_leads_key = array_search('leads', array_column($getPermissionsForDashboard, 'sub_module_name'));
	if( (gettype($crm_leads_key) != 'boolean' || $crm_leads_key != '')  && $_SESSION['loggedInUser']->role == 2){	
		
		//$where = ' AND leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;

		$where = ' AND leads.created_by_cid='.$ci->companyGroupId;
	
	}else if( $_SESSION['loggedInUser']->role == 1){
	
		//$where = ' AND leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;

			$where = ' AND leads.created_by_cid='.$ci->companyGroupId;
	
	}else{
		$where = ' AND leads.created_by='.$_SESSION['loggedInUser']->u_id;
	}
	
	
	/*if($_SESSION['loggedInUser']->role == 2 ){ 
		$where = ' AND leads.created_by='.$_SESSION['loggedInUser']->u_id;
	}else{
		$where = ' AND leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;
	}*/
	
	$btwQuery = '' ;
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND leads.created_date >="'.$startDate . '" AND leads.created_date <="' .$endDate . '"' ;
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
         , 9 ) as period , COUNT(IF(leads.lead_status=1,1, NULL)) AS New , COUNT(IF(leads.lead_status=2,1, NULL)) AS Contacted , COUNT(IF(leads.lead_status=3,1, NULL)) AS Qualified, COUNT(IF(leads.lead_status=4,1, NULL)) AS Unqualified, COUNT(IF(leads.lead_status=5,1, NULL)) AS Win, COUNT(IF(leads.lead_status=6,1, NULL)) AS Loose FROM 
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
LEFT JOIN leads  on Months.m = MONTH(leads.created_date) $where AND DATE_FORMAT(leads.created_date, '%Y') = YEAR (CURDATE()) $btwQuery 
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
		
		//$whereTarget = 'AND user_sale_target.user_id='.$_SESSION['loggedInUser']->c_id;

		$whereTarget = 'AND user_sale_target.user_id='.$ci->companyGroupId;
		
		//$whereAchieved = 'AND leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;

		$whereAchieved = 'AND leads.created_by_cid='.$ci->companyGroupId;
	
	}else if( $_SESSION['loggedInUser']->role == 1){
			
			//$whereTarget = 'AND user_sale_target.user_id='.$_SESSION['loggedInUser']->c_id;

			$whereTarget = 'AND user_sale_target.user_id='.$ci->companyGroupId;
		

		//$whereAchieved = 'AND leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;

		$whereAchieved = 'AND leads.created_by_cid='.$ci->companyGroupId;
	

	}else{
		$whereTarget = 'AND user_sale_target.user_id='.$_SESSION['loggedInUser']->u_id;
		$whereAchieved = 'AND leads.created_by='.$_SESSION['loggedInUser']->u_id;
	}
	



	/*if($_SESSION['loggedInUser']->role == 2){ 
		$whereTarget = 'AND user_sale_target.user_id='.$_SESSION['loggedInUser']->u_id;
		$whereAchieved = 'AND leads.created_by='.$_SESSION['loggedInUser']->u_id;
	}else{
		$whereTarget = 'AND user_sale_target.user_id='.$_SESSION['loggedInUser']->c_id;
		$whereAchieved = 'AND leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;
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
			//$where = ' AND sale_order.created_by_cid='.$_SESSION['loggedInUser']->c_id;

			$where = ' AND sale_order.created_by_cid='.$ci->companyGroupId;
	}else if( $_SESSION['loggedInUser']->role == 1){
			//$where = ' AND sale_order.created_by_cid='.$_SESSION['loggedInUser']->c_id;

			$where = ' AND sale_order.created_by_cid='.$ci->companyGroupId;
	}else{
			$where = ' AND sale_order.created_by='.$_SESSION['loggedInUser']->id;
	}
	/*if($_SESSION['loggedInUser']->role == 2){ 
		//$where = ' AND sale_order.created_by='.$_SESSION['loggedInUser']->u_id;
		$where = ' AND sale_order.created_by_cid='.$_SESSION['loggedInUser']->c_id;
	}else{
		$where = ' AND sale_order.created_by_cid='.$_SESSION['loggedInUser']->c_id;
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
				//$where = ' leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;

				$where = ' leads.created_by_cid='.$ci->companyGroupId;
	}else if( $_SESSION['loggedInUser']->role == 1){
		//$where = ' leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;

		$where = ' leads.created_by_cid='.$ci->companyGroupId;
	}else{
		$where = ' leads.created_by='.$_SESSION['loggedInUser']->u_id;
	}

	/*if($_SESSION['loggedInUser']->role == 2){ 
		$where = ' leads.created_by='.$_SESSION['loggedInUser']->u_id;
	}else{
		$where = ' leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;
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
	$crm_leads_key = array_search('leads', array_column($getPermissionsForDashboard, 'sub_module_name'));
	if( (gettype($crm_leads_key) != 'boolean' || $crm_leads_key != '')  && $_SESSION['loggedInUser']->role == 2){	
				//$where = ' leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;

				$where = ' leads.created_by_cid='.$ci->companyGroupId;
	}else if( $_SESSION['loggedInUser']->role == 1){
		//$where = ' leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;

		$where = ' leads.created_by_cid='.$ci->companyGroupId;
	}else{
		$where = ' leads.created_by='.$_SESSION['loggedInUser']->u_id;
	}

	/*if($_SESSION['loggedInUser']->role == 2){ 
		$where = ' leads.created_by='.$_SESSION['loggedInUser']->u_id;
	}else{
		$where = ' leads.created_by_cid='.$_SESSION['loggedInUser']->c_id;
	}	*/	
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND leads.created_date >="'.$startDate . '" AND leads.created_date <="' .$endDate . '"' ;
	}else{
		$btwQuery = ' AND DATE_FORMAT(leads.created_date, "%Y") = YEAR (CURDATE())' ;
	}
	$qry="SELECT COUNT(IF(leads.lead_status=5,1, NULL)) AS Win, COUNT(leads.lead_status) AS Total FROM leads WHERE $where   $btwQuery";	
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
		/*$where = ' created_by_cid='.$_SESSION['loggedInUser']->c_id;
		$accountWhere = ' account_owner='.$_SESSION['loggedInUser']->c_id;
		$contactWhere = ' contact_owner='.$_SESSION['loggedInUser']->c_id; */


		$where = ' created_by_cid='.$ci->companyGroupId;
		$accountWhere = ' account_owner='.$ci->companyGroupId;
		$contactWhere = ' contact_owner='.$ci->companyGroupId;
	}		
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND created_date >="'.$startDate . '" AND created_date <="' .$endDate . '"' ;
	}else{
		$btwQuery = ' AND DATE_FORMAT(created_date, "%Y") = YEAR (CURDATE())' ;
	}
	$qry="SELECT 'Accounts' as name, 'Total buyers created.' as description , 'fa fa-user' as icon , COUNT(*) as totalCount FROM account WHERE $accountWhere $btwQuery
	UNION
	SELECT  'proforma Invoice' as name, 'Total proforma invoice created.' as description , 'fa fa-file-text' as icon , COUNT(*) as totalCount FROM proforma_invoice WHERE $where   $btwQuery
	UNION
	SELECT  'Sale Orders' as name, 'Total sale order created.' as description , 'fa fa-cart-plus' as icon , COUNT(*) as totalCount FROM sale_order WHERE $where   $btwQuery";

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
		//$saleOrderWhere = ' sale_order.created_by_cid='.$_SESSION['loggedInUser']->c_id;

		$saleOrderWhere = ' sale_order.created_by_cid='.$ci->companyGroupId;
	}else{
		//$where = ' lead_activity.created_by_cid='.$_SESSION['loggedInUser']->c_id .' AND lead_activity.activity_type="New Task" AND lead_activity.new_task_status = 0' ;

		$where = ' lead_activity.created_by_cid='.$ci->companyGroupId .' AND lead_activity.activity_type="New Task" AND lead_activity.new_task_status = 0' ;
		//$accountWhere = ' account_activity.created_by_cid='.$_SESSION['loggedInUser']->c_id;
		//$saleOrderWhere = ' sale_order.created_by_cid='.$_SESSION['loggedInUser']->c_id;


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
		//$leadWhere = ' created_by_cid='.$_SESSION['loggedInUser']->c_id ;
		//$accountWhere = ' account_owner='.$_SESSION['loggedInUser']->c_id;

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
	//$sql = "SELECT MAX(priority) as max_priority FROM sale_order_priority where created_by_cid = ".$_SESSION['loggedInUser']->c_id;
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$CI->db->select('MAX(priority) as max_priority');   
		$CI->db->from('sale_order_priority');
		//$CI->db->where('created_by_cid', $_SESSION['loggedInUser']->c_id);

		$CI->db->where('created_by_cid', $ci->companyGroupId);
		$qry = $CI->db->get();	
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('MAX(priority) as max_priority');   
		$dynamicdb->from('sale_order_priority');
		//$dynamicdb->where('created_by_cid', $_SESSION['loggedInUser']->c_id);

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
	 if(!empty($_GET['ExportType'])){
		 ob_end_clean();
		switch($_GET["ExportType"])
		{
			case "export-to-excel" :
				// Submission from
				$filename = $_GET["ExportType"] . ".xls"; 
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				ExportFile($data3);
				//$_POST["ExportType"] = '';
				exit();
			case "export-to-csv" :
				// Submission from
				$filename = $_GET["ExportType"] . ".csv";            
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-type: text/csv");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				header("Expires: 0");
				ExportCSVFile($data3);
				//$_POST["ExportType"] = '';
				exit();
			case "export-to-blank-excel" :
				// Submission from
				$filename = $_GET["ExportType"] . ".xlsx";       
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				ExportFile_blank($data3);
				//$_POST["ExportType"] = '';
            exit();			
			
			default :
				die("Unknown action : ".$_GET["action"]);
				break;
		}
	 }
}


//  Helper For Exporting Quotation
function export_csv_excel_quot($data3 = array()){
	 if(!empty($_GET['ExportType'])){
		// pre($_POST);
		 ob_end_clean();
		switch($_GET["ExportType"])
		{
			case "export-to-excel" :
				exportquotation($data3);
				exit();	
			
			default :
				die("Unknown action : ".$_GET["action"]);
				break;
		}
	 }
}


// Helper For Exporting PI
function export_csv_excel_pi($data3 = array()){
	 if(!empty($_GET['ExportType'])){
		// pre($_POST);
		 ob_end_clean();
		switch($_GET["ExportType"])
		{
			case "export-to-excel" :
				exportpi($data3);
				exit();	
			
			default :
				die("Unknown action : ".$_GET["action"]);
				break;
		}
	 }
}


// Helper for Exporting SO

function export_csv_excel_so($data3 = array()){
	 if(!empty($_GET['ExportType'])){
		// pre($_POST);
		 ob_end_clean();
		switch($_GET["ExportType"])
		{
			case "export-to-excel" :
				exportso($data3);
				exit();	
			
			default :
				die("Unknown action : ".$_GET["action"]);
				break;
		}
	 }
}






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
 
function exportquotation($records) {
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
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Account Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Contact Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Order Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Valid Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Sub Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Payment Terms');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Created By');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Created Date');
        // set Row
        $rowCount = 2;
        foreach ($records as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['Account Name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['Contact Name']);
              $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['Order Date']);
               $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['Valid Date']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['Sub Total']);
                 $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['Total']);
                  $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['Payment Terms']);
                   $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['Created By']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['Created Date']);


            $rowCount++;
        }

       $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 

			$object_writer = new PHPExcel_Writer_Excel2007($objPHPExcel);
			        header('Content-Type: application/vnd.ms-excel');
			       header("Content-Disposition: attachment;filename=Export_Quotation.xlsx");
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
			       // header('Content-Type: application/vnd.ms-excel');
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


	function getNameById_bywith_ledgers($table='',$id='',$field=''){
				$qry="select * from $table where $field='$id' AND account_group_id = 7 ";
				$CI =& get_instance();
				$dynamicdb = $CI->load->database('dynamicdb', TRUE);
				$qryy = $dynamicdb->query($qry);	
				$result = $qryy->row();	
				return $result;	
			}
	function switch_db_dinamico($name_db){ 
		$config_app['hostname'] = 'localhost';
		$config_app['username'] = 'alfa';
		$config_app['password'] = 'IaPzsDyNg][K';
		$config_app['database'] = $name_db;
		$config_app['dbdriver'] = 'mysqli';
		$config_app['dbprefix'] = '';
		$config_app['pconnect'] = FALSE;
		$config_app['db_debug'] = (ENVIRONMENT !== 'production'); 
		$config_app['save_queries'] = true;
		return $config_app;
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


function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function getNameById_leads($table='',$id='',$field='' ,$status){
	$qry="select max(id) as `maxid` from $table where $field='$id' and status = '$status'"; 
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryy = $CI->db->query($qry);
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
		#echo $dynamicdb->last_query();
	}		
	$result =  $qryy->row();	
	return $result;	
}


function getNameById_mat($table='',$id='',$field=''){
	$qry="select * from $table where $field='$id'";
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


function getLastTableId_dynamic($table='',$config){
			$CI =& get_instance();
				$dynamicdb = $CI->load->database($config, TRUE);
				$query = $dynamicdb->query("SELECT * FROM $table ORDER BY id DESC LIMIT 1");
			$result = $query->row();
			if(!empty($result))
				return $result->id;
			else return false;
		}
		
		
		
	function email_send($to = '', $subject = '', $message = '') {
	$CI =& get_instance();
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
								<td align="center" class="masthead" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: white; background: #099a8c; margin: 0; padding: 30px 0;     border-radius: 4px 4px 0 0;" bgcolor="#099a8c"> <img src="'.base_url().'assets/images/logo.png" alt="logo" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; max-width: 100%; display: block; margin: 0 auto; padding: 0;" /></td>
							</tr>';
			$footer = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
					<td class="container" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">
						<!-- Message start -->
						<table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
							<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
								<td class="content footer" align="center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white none; margin: 0; padding: 30px 35px;     border-radius: 0 0 4px 4px;" bgcolor="white">
									<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center"><a href="'. base_url() .'" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: #888; text-decoration: none; font-weight: bold; margin: 0; padding: 0;">ERP</a></p>
									<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Support: dev@lastingerp.com</p>
									<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Phase 1 Industrial Area Panchkula Plot No 39, India - 134109</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</body>
	</html>';
$messageContent = $header.$message.$footer;

	$CI->load->library('phpmailer_lib');
    // PHPMailer object
    $mail = $CI->phpmailer_lib->load();
    //Server settings
    $mail->SMTPDebug = false;
    $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
    $mail->Subject     = 'Email Verification';
    $mail->isSMTP(); // Send using SMTP
    $mail->Host       = 'email-smtp.ap-south-1.amazonaws.com'; // Set the SMTP server to send through
    $mail->SMTPAuth   = true; // Enable SMTP authentication
    $mail->Username = 'AKIAZB4WVENVZ773ONVF'; // SMTP username
    $mail->Password = 'BLDqOsL9LkOKnY6n4coXRFsrXNq66C9xLDlsaCzasGEG'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    //Recipients
    $mail->setFrom('dev@lastingerp.com', 'lerp');
    $mail->addAddress($to,''); // Add a recipient
    // Content
    $mail->isHTML(true);
    // Email body content
    $mail->Body    = $messageContent;
  //  $mail->Subject = 'test';
    return $mail->send();
 }	
		
function getNameById_withmulti($table='',$id='',$field='',$id1='',$field1=''){	
	$qry="select * from $table where $field1='$id1' && $field='$id'";
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryy = $CI->db->query($qry);
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);

		#echo $dynamicdb->last_query();
	}		
	$result = $qryy->row();	
	return $result;	
}	
		
		
		
		
		
		
		
		
		
		
	?>
