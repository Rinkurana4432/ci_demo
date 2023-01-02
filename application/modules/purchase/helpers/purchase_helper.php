<?php 

function taxList(){
	$taxes = array(0,0.1,5,12,18,28);
	return $taxes;
}

/*function measurementUnits(){
	$measurementUnits = array('Kgs','Tons','Grams','Meters','Inches','CentiMeters');
	return $measurementUnits;
}*/
/*function getUom(){
		//$uom = array('Mtr.','Mm','Cm','Dm','Km','Inch','Ft','Yd','Sq.mtr','Sq.inch','Sq.ft','Cb.mtr','Ltr','Mltr','Centi.ltr','Dec.ltr','Hectltr','Cub. Inch','Qrt','Gallon','Gr','kg','Grain','Ounce','Pound','Ton','Tonne','Pc','coil');
		$uom = array('ACRES','BAG','BUSHELS','BKT','BUNDLE','BOWL','BOX','BLOCK','BOARD','BTL','BULK','CAN','COIL','CARTIDGE','CARD','COVER','CM','CS','CTN','CF','CUBE','CARAT','DG','DL','DM','DOZEN','DG','FT','GAL','GROSS','GR','HD','HERTZ','HECTARE','INCH','KIT','KG','KM','KHTZ','LTR','LOT','MTR','MM','NOS','OZ','OHMS','PC','Pound','PK','PAIR','QRT','RACK','RL','SET','SQ.INCH','SQ.FT','SHEET','SQ.MTR','YD','TUBE','Ton','Tonne','UNITS','VOLTS','WATT','MGHTZ',);
		return $uom;
}
*/

function checkGateEnable(){
	$CI->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	$qry="select gate_entry_status from company_detail where id={$CI->companyGroupId}";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
	$qryy = $dynamicdb->query($qry);
	$result = $qryy->row_array();
	return $result['gate_entry_status'];
}
function getNameById($table='',$id='',$field=''){
	$qry="select * from $table where $field='$id'";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
	$qryy = $dynamicdb->query($qry);
	$result = $qryy->row();
	return $result;
}

function getSingleAndWhere($select,$table,$where){
	$ci =& get_instance();
	$dynamicdb = $ci->load->database('dynamicdb', TRUE);
	$data = $dynamicdb->select($select)
			->where($where)->get($table)->row_array();
			// echo $ci->last_query
	return $data[$select];
}

function getSingleNameById($select,$table='',$id='',$field=''){
	$qry="select {$select} from $table where $field='$id'";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
	$qryy = $dynamicdb->query($qry);
	$result = $qryy->row_array();
	return $result[$select];
}

function getNameByIdLIKE($table='',$id='',$field=''){
	//echo "select * from $table where $field LIKE '%$id%'";die();
	$qry="select * from $table where $field LIKE '%$id%' ORDER BY id DESC";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
	$qryy = $dynamicdb->query($qry);
	$result = $qryy->row();
	return $result;
}
function getNameById_with_cid($table='',$id='',$field='',$company_field , $cid){
	$qry="select * from $table where $field='$id' AND $company_field = '$cid'";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$qryy = $dynamicdb->query($qry);
	//$qryy = $CI->db->query($qry);
	$result = $qryy->row();
	return $result;
}

function getLastTableId($table=''){
	$CI =& get_instance();
	$masterDb = $CI->load->database('dynamicdb', TRUE);	
	$masterDbQuery =$CI->db->query("SELECT * FROM $table ORDER BY id DESC LIMIT 1");
	$masterDbResult = $masterDbQuery->row();
	
	
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
	$query =$dynamicdb->query("SELECT * FROM $table ORDER BY id DESC LIMIT 1");
	$result = $query->row();
	#pre($result); die;
	if(!empty($result))	
		return $result->id;
	elseif(empty($result)){
		return $masterDbResult->id;
	}
	else return false;
}

	function getCompanyTableId($table=''){
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
		$query = $dynamicdb->query("SELECT  name  FROM $table WHERE u_id = '".$_SESSION['loggedInUser']->u_id."'");
		$result = $query->row();
		return $result;
		/*if(!empty($result))	
			return $result->u_id;
		else return false;*/
	}



	function create_pdf($dataPdf = array()){
		$CI =& get_instance();
		$CI->load->library('Pdf');
        $pdf=new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'UTF-8', false);
        $pdf->AddPage();
		include(APPPATH .'modules/purchase/views/purchase_order/view_pdf.php');
		$pdf->Output();    
	}
	function getMonthApprovetatusGraph($startDate = '', $endDate = ''){
		$CI->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		/*if($_SESSION['loggedInUser']->role == 2){ 
			$where = ' AND purchase_indent.created_by='.$_SESSION['loggedInUser']->u_id.' AND purchase_indent.save_status=1';
		}else{*/
			$where = ' AND purchase_indent.created_by_cid='.$CI->companyGroupId.' AND purchase_indent.save_status=1';
		#}		
		$btwQuery = '' ;
		if($startDate != '' && $endDate != ''){ 
			$btwQuery = ' AND purchase_indent.created_date >="'.$startDate . '" AND purchase_indent.created_date <="' .$endDate . '"' ;
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
			 , 9 ) as period , COUNT(IF(purchase_indent.approve=1,1, NULL)) AS Approve , COUNT(IF(purchase_indent.disapprove=1,1, NULL)) AS disapprove   , SUM(IFNULL(purchase_indent.`grand_total`, 0)) AS Amount FROM 
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
	LEFT JOIN purchase_indent  on Months.m = MONTH(purchase_indent.created_date) $where AND DATE_FORMAT(purchase_indent.created_date, '%Y') = YEAR (CURDATE()) $btwQuery 
	GROUP BY
		Months.m";	
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
		$qryy = $dynamicdb->query($qry);
		$result = $qryy->result_array();	
		return $result;	
}

/*********** Top section counts on dashboard ***********/
function getDashboardCount($startDate = '', $endDate = ''){
	$CI->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id;
	/*if($_SESSION['loggedInUser']->role == 2){ // If logged in by company owner
		$where = ' created_by='.$_SESSION['loggedInUser']->u_id.' AND save_status=1';	
	}else{*/
		$where = ' created_by_cid='.$CI->companyGroupId.' AND save_status=1';
	#}		
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND created_date >="'.$startDate . '" AND created_date <="' .$endDate . '"' ;
	}else{
		$btwQuery = ' AND DATE_FORMAT(created_date, "%Y") = YEAR (CURDATE())' ;
	}
	$qry="SELECT 'Purchase indent' as name, 'Total purchase indent created.' as description , 'fa fa-caret-square-o-right' as icon , COUNT(*) as totalCount, 'purchase_indent' as url, 'purchase_indent' as tableName FROM purchase_indent WHERE $where   $btwQuery
	UNION
	SELECT 'Purchase order' as name, 'Total purchase order created.' as description , 'fa fa-sort-amount-desc' as icon , COUNT(*) as totalCount, 'purchase_order' as url, 'purchase_order' as tableName FROM purchase_order WHERE $where $btwQuery
	UNION
	SELECT 'Suppliers' as name, 'Total suppliers created.' as description , 'fa fa-comments-o' as icon , COUNT(*) as totalCount, 'suppliers' as url, 'supplier' as tableName FROM supplier WHERE $where $btwQuery
	UNION
	SELECT  'GRN' as name, 'Total GRN order created.' as description , 'fa fa-check-square-o' as icon , COUNT(*) as totalCount, 'mrn' as url, 'mrn_detail' as tableName FROM mrn_detail WHERE $where   $btwQuery";
	
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
	$qryy = $dynamicdb->query($qry);
	$result = $qryy->result_array();	
	return $result;	
}

function getIndentStatusGraph($startDate = '', $endDate = ''){
	$CI->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	/*if($_SESSION['loggedInUser']->role == 2){ // If logged in user is not company admin
		$where = ' purchase_indent.created_by='.$_SESSION['loggedInUser']->u_id.' AND purchase_indent.save_status=1 AND (purchase_indent.po_or_not = 0 OR purchase_indent.mrn_or_not =0 OR purchase_indent.pay_or_not =0) ';
	}else{ //  logged in user is company owner*/
		#$where = ' purchase_indent.created_by_cid='.$_SESSION['loggedInUser']->c_id.' AND purchase_indent.save_status=1 AND (purchase_indent.po_or_not = 0 OR purchase_indent.mrn_or_not =0 OR purchase_indent.pay_or_not =0) ';
		$where = ' purchase_indent.created_by_cid='.$CI->companyGroupId.' AND purchase_indent.save_status=1 ';
	#}		
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND purchase_indent.created_date >="'.$startDate . '" AND purchase_indent.created_date <="' .$endDate . '"' ;
	}else{
		$btwQuery = ' AND DATE_FORMAT(purchase_indent.created_date, "%Y") = YEAR (CURDATE())' ;
	}
	#$qry="SELECT COUNT(IF(purchase_indent.approve=1,1, NULL)) AS Approved , COUNT(IF(purchase_indent.disapprove=1,1, NULL)) AS Dissaproved, COUNT((IF(IsNull(purchase_indent.disapprove),1,0) AND IF(IsNull(purchase_indent.approve),1,0)) OR ((IF(purchase_indent.disapprove=0,1, NULL) AND IF(purchase_indent.approve=0,1, NULL)))) AS Pending FROM purchase_indent WHERE $where   $btwQuery";	
	$qry="SELECT COUNT(IF(purchase_indent.approve=1,1, NULL)) AS Approved , COUNT(IF(purchase_indent.disapprove=1,1, NULL)) AS Dissaproved, COUNT((IF(IsNull(purchase_indent.disapprove),1,0) AND IF(IsNull(purchase_indent.approve),1,0)) OR ((IF(purchase_indent.disapprove=0,1, NULL) AND IF(purchase_indent.approve=0,1, NULL)))) AS Pending FROM purchase_indent WHERE $where   $btwQuery";	
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$qryy = $dynamicdb->query($qry);
	$result = $qryy->result_array();	
	return $result;	
}	

function getMrnStarRating($startDate = '', $endDate = ''){
	$CI->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	/*if($_SESSION['loggedInUser']->role == 2){ 
		$where = ' mrn_detail.created_by='.$_SESSION['loggedInUser']->u_id.' AND mrn_detail.save_status=1';
	}else{*/
		$where = ' mrn_detail.created_by_cid='.$CI->companyGroupId.' AND mrn_detail.save_status=1';
	#}		
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND mrn_detail.created_date >="'.$startDate . '" AND mrn_detail.created_date <="' .$endDate . '"' ;
	}else{
		$btwQuery = ' AND DATE_FORMAT(mrn_detail.created_date, "%Y") = YEAR (CURDATE())' ;
	}
	$qry="SELECT  COUNT(IF(mrn_detail.rating=1,1, NULL)) AS onestar, COUNT(IF(mrn_detail.rating=2,1, NULL)) AS twostar, COUNT(IF(mrn_detail.rating=3,1, NULL)) AS threestar, COUNT(IF(mrn_detail.rating=4,1, NULL)) AS fourstar, COUNT(IF(mrn_detail.rating=5,1, NULL)) AS fivestar,   COUNT(mrn_detail.rating) AS Total FROM mrn_detail WHERE $where   $btwQuery";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$qryy = $dynamicdb->query($qry);
	$result = $qryy->result_array();	
	return $result;	
}

function getPItoPoConversion($startDate = '', $endDate = ''){
	$CI->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	/*if($_SESSION['loggedInUser']->role == 2){ 
		$where = ' purchase_indent.created_by='.$_SESSION['loggedInUser']->u_id.' AND purchase_indent.save_status=1';
	}else{*/
		$where = ' purchase_indent.created_by_cid='.$CI->companyGroupId.' AND purchase_indent.save_status=1';
	#}		
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND purchase_indent.created_date >="'.$startDate . '" AND purchase_indent.created_date <="' .$endDate . '"' ;
	}else{
		$btwQuery = ' AND DATE_FORMAT(purchase_indent.created_date, "%Y") = YEAR (CURDATE())' ;
	}
	#$qry="SELECT COUNT(IF(purchase_indent.poCreate=1,1, NULL)) AS poCreate, COUNT(*) AS total FROM purchase_indent WHERE $where   $btwQuery";	
	$qry="SELECT COUNT(IF(purchase_indent.po_or_not=1,1, NULL)) AS poCreate, COUNT(IF(purchase_indent.po_or_not=0,1, NULL)) AS pi_not_converted FROM purchase_indent WHERE $where   $btwQuery";	
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$qryy = $dynamicdb->query($qry);
	#echo $CI->db->last_query();
	$result = $qryy->result_array();	
	return $result;	
}

function getPOtoMRNConversion($startDate = '', $endDate = ''){
	$CI->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	/*if($_SESSION['loggedInUser']->role == 2){ 
		$where = ' purchase_order.created_by='.$_SESSION['loggedInUser']->u_id.' AND purchase_order.save_status=1';
	}else{*/
		$where = ' purchase_order.created_by_cid='.$CI->companyGroupId.' AND purchase_order.save_status=1';
	#}		
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND purchase_order.created_date >="'.$startDate . '" AND purchase_order.created_date <="' .$endDate . '"' ;
	}else{
		$btwQuery = ' AND DATE_FORMAT(purchase_order.created_date, "%Y") = YEAR (CURDATE())' ;
	}
	#$qry="SELECT COUNT(IF(purchase_order.mrn_or_not=1,1, NULL)) AS MRNCreated, COUNT(*) AS total FROM purchase_order WHERE $where $btwQuery";	
	$qry="SELECT COUNT(IF(purchase_order.mrn_or_not=1,1, NULL)) AS po_converted_to_mrn, COUNT(IF(purchase_order.mrn_or_not=0,1, NULL)) AS po_not_converted_to_mrn FROM purchase_order WHERE $where $btwQuery";	
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$qryy = $dynamicdb->query($qry);
	$result = $qryy->result_array();	
	return $result;	
}
/*function PoAmountTotalWithMaterial($startDate = '', $endDate = ''){
	if($_SESSION['loggedInUser']->role == 2){ 
		$where = ' purchase_order.created_by='.$_SESSION['loggedInUser']->u_id.' AND purchase_order.save_status=1';
	}else{
		$where = ' purchase_order.created_by_cid='.$_SESSION['loggedInUser']->c_id.' AND purchase_order.save_status=1';
	}		
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND purchase_order.created_date >="'.$startDate . '" AND purchase_order.created_date <="' .$endDate . '"' ;
	}else{
		$btwQuery = ' AND DATE_FORMAT(purchase_order.created_date, "%Y") = YEAR (CURDATE())' ;
	}
	$qry="SELECT COUNT(IF(purchase_order.material_type_id=1,1, NULL)) AS RawMaterial, COUNT(IF(purchase_order.material_type_id=2,1, NULL)) AS Consumed, COUNT(IF(purchase_order.material_type_id=3,1, NULL)) AS Packaged, COUNT(IF(purchase_order.material_type_id=4,1, NULL)) AS Maintenance, COUNT(IF(purchase_order.material_type_id=5,1, NULL)) AS Others FROM purchase_order WHERE $where   $btwQuery";	
	
	$CI =& get_instance();
	$CountMaterialQry = $CI->db->query($qry);
	#echo $CI->db->last_query(); 
	$CountMaterialResult = $CountMaterialQry->result_array();
	 
	$qry2="SELECT material_type.name as Name, ROUND(SUM(grand_total)) as total FROM material_type LEFT JOIN purchase_order ON material_type.id = material_type_id  GROUP BY material_type.id";
	
	$CI =& get_instance();
	$MaterialAmountActivityQry = $CI->db->query($qry2);
	#echo $CI->db->last_query(); 
	$MaterialAmountActivityResult = $MaterialAmountActivityQry->result_array();	
	$AmountArray = array();
	$AmountArray = array('CountMaterial' => $CountMaterialResult , 'AmountMaterial' => $MaterialAmountActivityResult);
	
	
	return $AmountArray;	
		
}*/

function array_except($array, $keys) {
  return array_diff_key($array, array_flip((array) $keys));   
}  
function PoAmountTotalWithMaterial($startDate = '', $endDate = '', $status_value2 = ''){
$CI->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;	
	/*if($_SESSION['loggedInUser']->role == 2){ 
		$where = ' purchase_order.created_by='.$_SESSION['loggedInUser']->u_id.' AND purchase_order.save_status=1';
	}else{*/
		$where = ' purchase_order.created_by_cid='.$CI->companyGroupId.' AND purchase_order.save_status=1';
		$whereCompletePO = ' purchase_order.created_by_cid='.$CI->companyGroupId.' AND purchase_order.save_status=1 AND mrn_or_not = 1 AND pay_or_not=1 AND ifbalance = 0';
		$whereIncompletePO = ' purchase_order.created_by_cid='.$CI->companyGroupId.' AND purchase_order.save_status=1 AND (mrn_or_not = 0 OR pay_or_not=0 OR ifbalance = 1)';
	#}		
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND purchase_order.created_date >="'.$startDate . '" AND purchase_order.created_date <="' .$endDate . '"' ;
	}elseif($status_value2 != ''){
		if($status_value2 == 'mrn_or_not'){
			$btwQuery = " AND purchase_order.mrn_or_not ='0'";
		}elseif($status_value2 == 'pay_or_not'){
			$btwQuery = " AND purchase_order.pay_or_not ='0'";
		}
	}else{
		$btwQuery = ' AND DATE_FORMAT(purchase_order.created_date, "%Y") = YEAR (CURDATE())' ;
	}
	$materialTypeSql = "SELECT * FROM material_type where (created_by_cid = ".$CI->companyGroupId." OR created_by_cid =0) AND status = 1";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$materialTypeQry = $dynamicdb->query($materialTypeSql);
	$materialTypeResult = $materialTypeQry->result_array();	
	$materialArray = array();
	if(!empty($materialTypeResult)){
		$i =0;
		foreach($materialTypeResult as $matType){	
			/************ Query for fetching purchase order created according to material type ************/		
			$poSql = "SELECT COUNT(IF(purchase_order.material_type_id=".$matType['id'].",1, NULL)) as poCount FROM purchase_order WHERE $where   $btwQuery";
			//die();
			#$CI =& get_instance();
			$poQry = $dynamicdb->query($poSql);
			$poResult = $poQry->row();
			$materialArray['poCountData'][$i]['count'] = $poResult->poCount;	
			$materialArray['poCountData'][$i]['material_type_name'] = $matType['name'];
			$materialArray['poCountData'][$i]['material_type_id'] = $matType['id'];		
			/************ Query for fetching purchase order amount according to material type **************/
			$poAmountSql="SELECT material_type.id , material_type.name as material_type_name, ROUND(SUM(grand_total)) as totalAmount FROM material_type LEFT JOIN purchase_order ON material_type.id = material_type_id where purchase_order.material_type_id = ".$matType['id']." AND $where  $btwQuery";
			#$CI =& get_instance();
			$poAmountQry = $dynamicdb->query($poAmountSql);			
			$poAmountResult = $poAmountQry->row();	
			$materialArray['poAmountData'][$i] = $poAmountResult;	
			$i++;			
		}		
	}
	$poCompleteSql = "SELECT COUNT(*) as completePO FROM purchase_order WHERE $whereCompletePO   $btwQuery";
	$poCompleteQry = $CI->db->query($poCompleteSql);
	$poCompleteResult = $poCompleteQry->row();
	$poIncompleteSql = "SELECT COUNT(*) as incompletePO FROM purchase_order WHERE $whereIncompletePO   $btwQuery";
	$poIncomplteQry = $CI->db->query($poIncompleteSql);
	$poIncomplteResult = $poIncomplteQry->row();
	
	$materialArray['po_complete'] = $poCompleteResult->completePO;
	$materialArray['po_incomplete'] = $poIncomplteResult->incompletePO;
	return $materialArray;	
}
function MRNAmountTotalWithMaterial($startDate = '', $endDate = ''){
	$CI->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	if($_SESSION['loggedInUser']->role == 2){ 
		$where = ' mrn_detail.created_by='.$_SESSION['loggedInUser']->u_id.' AND mrn_detail.save_status=1';
	}else{
		$where = ' mrn_detail.created_by_cid='.$CI->companyGroupId.' AND mrn_detail.save_status=1';
	}		
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND mrn_detail.created_date >="'.$startDate . '" AND mrn_detail.created_date <="' .$endDate . '"' ;
	}else{
		$btwQuery = ' AND DATE_FORMAT(mrn_detail.created_date, "%Y") = YEAR (CURDATE())' ;
	}
	$materialTypeSql = "SELECT * FROM material_type where (created_by_cid = ".$CI->companyGroupId." OR created_by_cid =0) AND status = 1";
	$CI =& get_instance();
	$materialTypeQry = $CI->db->query($materialTypeSql);
	$materialTypeResult = $materialTypeQry->result_array();	
	$material_Array = array();
	if(!empty($materialTypeResult)){
		$i =0;
		foreach($materialTypeResult as $matType){	
			/************ Query for fetching purchase order created according to material type ************/		
			$mrnSql = "SELECT COUNT(IF(mrn_detail.material_type_id=".$matType['id'].",1, NULL)) as poCount FROM mrn_detail WHERE $where   $btwQuery";
			$CI =& get_instance();
			$MRNQry = $CI->db->query($mrnSql);
			$MRNResult = $MRNQry->row();
			$material_Array['MRNCountData'][$i]['count'] = $MRNResult->poCount;	
			$material_Array['MRNCountData'][$i]['material_type_name'] = $matType['name'];
			$material_Array['MRNCountData'][$i]['material_type_id'] = $matType['id'];		
			/************ Query for fetching purchase order amount according to material type **************/
			$poAmountSql="SELECT material_type.id,material_type.name as material_type_name, ROUND(SUM(grand_total)) as totalAmount FROM material_type LEFT JOIN mrn_detail ON material_type.id = material_type_id where mrn_detail.material_type_id = ".$matType['id']." AND $where  $btwQuery";
			$CI =& get_instance();
			$MRNAmountQry = $CI->db->query($poAmountSql);			
			$MRnAmountResult = $MRNAmountQry->row();	
			$material_Array['MRNAmountData'][$i] = $MRnAmountResult;
			$i++;			
		}		
	}
	$mrnCompleteIncompleteSql = "SELECT COUNT(IF(mrn_detail.pay_or_not=1,1, NULL)) as completeMRN , COUNT(IF(mrn_detail.pay_or_not=0,1, NULL)) as incompleteMRN FROM mrn_detail WHERE $where   $btwQuery";
	$mrnCompleteIncomplteQry = $CI->db->query($mrnCompleteIncompleteSql);
	$mrnCompleteIncomplteResult = $mrnCompleteIncomplteQry->row();
	
	$material_Array['mrn_complete'] = $mrnCompleteIncomplteResult->completeMRN;
	$material_Array['mrn_incomplete'] = $mrnCompleteIncomplteResult->incompleteMRN;
	
	#pre($material_Array);
		return $material_Array;	
}
//$data_balnk = array()


function export_csv_excel($data3 = array()){
	//pre($data3);die();
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

function export_csv_excel_blank($data_blank3 = array()){
	 if(!empty($_GET['ExportType_blank'])){
		// pre($_POST);
		 ob_end_clean();
		switch($_GET["ExportType_blank"])
		{
			case "export-to-blank-excel" :
				// Submission from
				$filename = $_GET["ExportType_blank"] . ".xlsx";       
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				ExportFile_blank($data_blank3);
				//$_POST["ExportType"] = '';
            exit();			
			
			default :
				die("Unknown action : ".$_GET["action"]);
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
 
function ExportFile($records) {
	//pre($records);die();
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


function updateUsedIdStatus($table='',$id=''){
	$sql = "UPDATE $table SET  used_status = 1 where id = $id";	
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$qry = $dynamicdb->query($sql);
}

function updateMultipleUsedIdStatus($table='',$whereIds=''){
	$sql = "UPDATE $table SET  used_status = 1 where id IN($whereIds)";	
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$qry = $dynamicdb->query($sql);
	// echo $dynamicdb->last_query();
	// die;
}


function piCompleteStatusAmountTotalWithMaterial($startDate = '', $endDate = '' , $status_value2 = ''){

$CI->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;	
	/*if($_SESSION['loggedInUser']->role == 2){ 
		$where = ' purchase_indent.created_by='.$_SESSION['loggedInUser']->u_id.' AND purchase_indent.save_status=1';
	}else{*/
		$where = ' purchase_indent.created_by_cid='.$CI->companyGroupId.' AND purchase_indent.save_status=1';
		$whereCompletePI = ' purchase_indent.created_by_cid='.$CI->companyGroupId.' AND purchase_indent.save_status=1 AND purchase_indent.mrn_or_not = 1 AND purchase_indent.po_or_not = 1 AND purchase_indent.pay_or_not=1 AND purchase_indent.ifbalance = 0';
		$whereIncompletePI = ' purchase_indent.created_by_cid='.$CI->companyGroupId.' AND purchase_indent.save_status=1 AND (purchase_indent.mrn_or_not = 0 OR purchase_indent.pay_or_not=0 OR purchase_indent.ifbalance = 1)';
	#}
	if($startDate != '' && $endDate != ''){ 
		$btwQuery = ' AND purchase_indent.created_date >="'.$startDate . '" AND purchase_indent.created_date <="' .$endDate . '"' ;
	}elseif($status_value2 != ''){
		if($status_value2 == 'mrn_or_not'){
			$btwQuery = " AND purchase_indent.mrn_or_not ='0'";
		}elseif($status_value2 == 'po_or_not'){
			$btwQuery = " AND purchase_indent.po_or_not ='0'";
		}elseif($status_value2 == 'approval_pending'){
			$btwQuery = " AND purchase_indent.approve is NULL AND purchase_indent.disapprove is NULL";
		}
	}else{
		$btwQuery = ' AND DATE_FORMAT(purchase_indent.created_date, "%Y") = YEAR (CURDATE())' ;
	}
	$materialTypeSql = "SELECT * FROM material_type where (created_by_cid = ".$CI->companyGroupId." OR created_by_cid =0) AND status = 1";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$materialTypeQry = $dynamicdb->query($materialTypeSql);
	$materialTypeResult = $materialTypeQry->result_array();
	$materialArray = array();
	if(!empty($materialTypeResult)){
		$i =0;
		foreach($materialTypeResult as $matType){	
			/************ Query for fetching purchase order created according to material type ************/		
			$poSql = "SELECT COUNT(IF(purchase_indent.material_type_id=".$matType['id'].",1, NULL)) as piCount FROM purchase_indent WHERE $where   $btwQuery";
			$CI =& get_instance();
			$piQry = $CI->db->query($poSql);
			$piResult = $piQry->row();
			$piAmountLike = '"Complete":{"name":"Complete","value":1}';
			
			$piMaterialArray['piCountData'][$i]['count'] = $piResult->piCount;	
			$piMaterialArray['piCountData'][$i]['material_type_name'] = $matType['name'];
			$piMaterialArray['piCountData'][$i]['material_type_id'] = $matType['id'];		
			/************ Query for fetching purchase order amount according to material type **************/
			$piAmountSql="SELECT material_type.id,material_type.name as material_type_name, ROUND(SUM(grand_total)) as totalAmount FROM material_type LEFT JOIN purchase_indent ON material_type.id = material_type_id where purchase_indent.material_type_id = ".$matType['id']." AND (purchase_indent.status like '%".$piAmountLike."%' OR purchase_indent.pay_or_not=1) AND $where  $btwQuery";
			#$CI =& get_instance();
			$piAmountQry = $dynamicdb->query($piAmountSql);			
			$piAmountResult = $piAmountQry->row();	
			$piMaterialArray['piAmountData'][$i] = $piAmountResult;
			$i++;			
		}		
	}
	
	$piCompleteSql = "SELECT COUNT(*) as completePI FROM purchase_indent WHERE $whereCompletePI   $btwQuery";
	$piCompleteQry = $CI->db->query($piCompleteSql);
	$piCompleteResult = $piCompleteQry->row();
	$piIncompleteSql = "SELECT COUNT(*) as incompletePI FROM purchase_indent WHERE $whereIncompletePI   $btwQuery";
	$piIncomplteQry = $CI->db->query($piIncompleteSql);
	$piIncomplteResult = $piIncomplteQry->row();
	
	$piMaterialArray['pi_complete'] = $piCompleteResult->completePI;
	$piMaterialArray['pi_incomplete'] = $piIncomplteResult->incompletePI;
	#pre($piMaterialArray);
		return $piMaterialArray;	
}
function GetExpectedPriceOFSupplier($table,$product_induction_id,$supplier_id,$product_id){
	$qry="select * from $table where product_induction_id='$product_induction_id' AND supplier_id = '$supplier_id' AND product_id = '$product_id'";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
	$qryy = $dynamicdb->query($qry);
	$result = $qryy->row();
	return $result;
}
function GetMinExpectedPrice($table,$product_induction_id,$product_id){
	$qry1="select * from $table where product_induction_id='$product_induction_id' AND product_id = '$product_id' AND selected_status ='1'";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
	$qryz = $dynamicdb->query($qry1);
	$result1 = $qryz->row();
    if(!empty($result1)){
		$price =$result1->supplier_expected_amount;
	}else{
		$qry="select MIN(trim(supplier_expected_amount))  AS minprice from $table where product_induction_id='$product_induction_id' AND product_id = '$product_id' AND supplier_expected_amount != ''";
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
		$qryy = $dynamicdb->query($qry);
		$result = $qryy->row();
		$price =$result->minprice;
			//pre($result);

	}
	return $price;
}
function GetRFQSupplier($table,$product_induction_id,$supplier_id){
	$qry="select * from $table where product_induction_id='$product_induction_id' AND supplier_id = '$supplier_id'";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
	$qryy = $dynamicdb->query($qry);
	$result = $qryy->row();
	return $result;
	
}
function GetPrefferedSupplier($table,$product_induction_id,$product_id){
	$qry="select supplier_id from $table where product_induction_id='$product_induction_id' AND product_id = '$product_id' AND selected_status ='1'";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
	$qryy = $dynamicdb->query($qry);
	$result = $qryy->row();
	return $result;
	
}
function get_challan_number_count($table='',$id='',$field=''){
			$qry= "SELECT count(*) as total_challan FROM ".$table." where ".$field." = ".$id." ORDER BY id DESC LIMIT 1";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);	
			$result = $qryy->row();
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
function getNameById_matWithLoc($table='',$id='',$field='',$id2='',$field2=''){
//	echo "select * from $table where $field='$id' AND $field2='$id2' ";die();
	$qry="select * from $table where $field='$id' AND $field2='$id2' ";
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


/* money format function  */

if ( ! function_exists( 'money_format' ) ) {

function money_format($format, $number)
{
    $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
              '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
    if (setlocale(LC_MONETARY, 0) == 'C') {
        setlocale(LC_MONETARY, '');
    }
    $locale = localeconv();
    preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
    foreach ($matches as $fmatch) {
        $value = floatval($number);
        $flags = array(
            'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
                           $match[1] : ' ',
            'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
            'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                           $match[0] : '+',
            'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
            'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
        );
        $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
        $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
        $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
        $conversion = $fmatch[5];

        $positive = true;
        if ($value < 0) {
            $positive = false;
            $value  *= -1;
        }
        $letter = $positive ? 'p' : 'n';

        $prefix = $suffix = $cprefix = $csuffix = $signal = '';

        $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
        switch (true) {
            case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                $prefix = $signal;
                break;
            case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                $suffix = $signal;
                break;
            case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                $cprefix = $signal;
                break;
            case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                $csuffix = $signal;
                break;
            case $flags['usesignal'] == '(':
            case $locale["{$letter}_sign_posn"] == 0:
                $prefix = '(';
                $suffix = ')';
                break;
        }
        if (!$flags['nosimbol']) {
            $currency = $cprefix .
                        ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                        $csuffix;
        } else {
            $currency = '';
        }
        $space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

        $value = number_format($value, $right, $locale['mon_decimal_point'],
                 $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
        $value = @explode($locale['mon_decimal_point'], $value);

        $n = strlen($prefix) + strlen($currency) + strlen($value[0]);
        if ($left > 0 && $left > $n) {
            $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
        }
        $value = implode($locale['mon_decimal_point'], $value);
        if ($locale["{$letter}_cs_precedes"]) {
            $value = $prefix . $currency . $space . $value . $suffix;
        } else {
            $value = $prefix . $value . $space . $currency . $suffix;
        }
        if ($width > 0) {
            $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                     STR_PAD_RIGHT : STR_PAD_LEFT);
        }

        $format = str_replace($fmatch[0], $value, $format);
    }
    return $format;
  }
}

  function convertDataArray($rfqData){
  		foreach ($rfqData as $key => $value) {
  			foreach ($value as $mKey => $mValue) {
  					$data[] = $mValue;
  			}
  		}
  		return $data;
  }

  function checkMaterialConvert($material,$rfq,$indentId){
	$checkComplete = true;
	if( $rfq ){

		foreach ($material as $mKey => $mValue) {
			foreach ($rfq as $key => $value) {
				if( $value['product_induction_id'] == $indentId && $value['product_id'] == $mValue->material_name_id ){
					if( $mValue->remaning_qty == 0 ){
						$checkComplete = false;
					}else{
						$checkComplete = true;
						goto end;
					}
				}
			}
		}
	}
	end:
	return $checkComplete;
	}

	function checkMaterialQty($data){
		$newData = [];
		if( $data ){
			$data = json_decode($data);
			foreach ($data as $key => $value) {
				if( $value['quantity'] > 0 && $value['quantity'] != "" ){
					foreach ($value as $childKey => $childValue) {
						$newData[$key][$childKey] = $childValue;
					}	
				}
				 
			}
		}
		return $newData;
	}

	function checkApproveByUser(){
			$CI =& get_instance();
			$whereLow = ['budget_type' => 'lowBudget','created_by_cid' => $CI->companyGroupId ];
            $whereHigh = ['budget_type' => 'highBudget','created_by_cid' => $CI->companyGroupId ];
            $rowStatus = $CI->purchase_model->getDataByWhereId('purchase_budget_limit',$whereLow);
            $approve = [];
            if( $rowStatus[0]['users'] ){
                $users = json_decode($rowStatus[0]['users']);
                foreach ($users as $key => $value) {
                    if( $value == $_SESSION['loggedInUser']->u_id ){
                        $approve['lowBudget']   = true;
                        $approve['budgetLimit'] = $rowStatus[0]['budget_limit'];
                    }
                }
            }
            
            $rowStatus = $CI->purchase_model->getDataByWhereId('purchase_budget_limit',$whereHigh);
            if( !empty($rowStatus[0]['users']) ){
                $users = json_decode($rowStatus[0]['users']);
                if( $users ){
                	$approve = [];
                	foreach ($users as $key => $value) {
	                    if( $value == $_SESSION['loggedInUser']->u_id ){
	                        $approve['highBudget']   = true;
	                        $approve['budgetLimit'] = $rowStatus[0]['budget_limit'];
	                    }
                	}	
                }
            }
            return $approve;
	}

	function checkUrlExist($table,$url,$checkUrl){
		$CI =& get_instance();
		$countUrl = $CI->db->where($url,$checkUrl)->count_all_results($table);
		if( $countUrl > 0 ){
			return $checkUrl.'_'.$countUrl;
		}else{
			return $checkUrl;
		}
	}

	function varibaleBr(){
		pre(func_get_args());

	}

	function queryError($sql){
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$db_debug = $dynamicdb->db_debug;
		$dynamicdb->db_debug = FALSE;
		if ( ! $dynamicdb->simple_query($sql)) {
    			$error = $dynamicdb->error(); // Has keys 'code' and 'message'
    			pre($error);
				$dynamicdb->db_debug = $db_debug;
				die;
		}
	}
	
	function paginationAttr($base_url,$rows){
    $config = array();
    $config["base_url"] = base_url() . $base_url;
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
    return $config;
}


function mergeMultiDemArray($array1,$array2){
    $data = [];
    $i = 0;
    foreach ($array1 as $key => $value) {
        $data[] = $value;
        $i++;
    }
    if( count($array1) == $i ){
        foreach ($array2 as $key => $value) {
            $data[$i] = $value;
            $i++;
        }
    }

   return $data;


}


	function multiObjectToArray($data){
    $arrayData = [];
    if( !empty($data) ){
        foreach ($data as $key => $value) {
            foreach ($value as $mkey => $mvalue) {
               $arrayData[$key][$mkey] = $mvalue;                   
            }             
        }       
    }
    return $arrayData;
}


	function getMaterialUpdateInvntry($select,$table,$where){
		  $ci =& get_instance();
			$dynamicdb = $ci->load->database('dynamicdb', TRUE);
			$data = $dynamicdb->select($select)->where($where)->order_by('id','desc')
									->get($table)->row_array();
			if( $data[$select] ){
					return json_decode($data[$select],true);
			}
			return false;	
	}

	function getMaterialUpdateAddress($select,$table,$where){
			$ci =& get_instance();
			$dynamicdb = $ci->load->database('dynamicdb', TRUE);
			$data = $dynamicdb->select($select)->where($where)->order_by('id','desc')
									->get($table)->row_array();
			if( $data[$select] ){
					return json_decode($data[$select],true);
			}
			return false;		
	}

	function multiArrayUnique($array1,$array2){
		  $returnNewArray = [];
      $oldMaterialCount = count($array1);
      $newMaterialCount = count($array2);
      $uniqueDataExist     = false;
      if( $newMaterialCount > $oldMaterialCount ){
          $graterMaterialArray = $array2; // newArray
          $lessMaterialArray   = $array1;
          $uniqueDataExist     = true;     //oldArray
      }elseif( $newMaterialCount < $oldMaterialCount ){
          $graterMaterialArray = $array1;
          $lessMaterialArray   = $array2;
          $uniqueDataExist     = true;
      }

      if( $uniqueDataExist ){
	      foreach($graterMaterialArray as $key => $value){
	          if( isset($lessMaterialArray[$key]) ){
	               $returnNewArray[] = (object)$value;   
	          }
	      }
	      return $returnNewArray;
      }else{
      	return $array2;
      }

	}

	function companyGroupId(){
		return (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id;
	}

	function checkPurchaseDisApprove(){
			$checkPODisapproveStatus = getNameById('company_detail',companyGroupId(),'id');
			if( $checkPODisapproveStatus->po_disapprove_status ){
					if( $checkPOapproveStatus->po_disapprove_status > 0 && !empty($checkPOapproveStatus->po_disapprove_status)  ){
								return true;
					}
			}
			return false;
	}

	function checkPurchaseApprove(){
			$checkPOapproveStatus = getNameById('company_detail',companyGroupId(),'id');
			if( $checkPOapproveStatus->po_approve_status ){
					if( $checkPOapproveStatus->po_approve_level > 0 && !empty($checkPOapproveStatus->po_approve_level)  ){
							$approveUsers = json_decode($checkPOapproveStatus->po_approve_users,true);
							if( count($approveUsers) > 0 ){
								return true;
							}
					}
			}
			return false;
	}

	function checkSetComplete($poId){
			/*$approveUsers = getSingleAndWhere('po_approve_users','company_detail',['id' => companyGroupId() ]);
			$approveUsers = json_decode($approveUsers,true);*/

			$approveUsers = getSingleAndWhere('selectApproveUsers','purchase_order',['id' => $poId ]);
			$approveUsers = json_decode($approveUsers,true);

			$poApproveByUser = getSingleAndWhere('approve_user_detail','purchase_order',['id' => $poId ]);
			$poApproveByUser = json_decode($poApproveByUser,true);
			$data = [];
			$approveStatus = [];

			if( $approveUsers ){
					foreach($approveUsers as $poKey => $poValue){
							$setpCount = $poKey + 1;
							/*if( in_array($poValue,$poApproveByUser['userId']) ){
									pre($poApproveByUser);
									$poStatus  = ucfirst($poApproveByUser['status'][$poValue]);
									$approveStatus['stepShow'][$poKey] = "Step {$setpCount}: {$poStatus}";
									$approveStatus['userId'][$poKey]   = $poValue;
									$approveStatus['poStatus'][$poKey] = $poStatus;
							}else{
									$approveStatus['stepShow'][$poKey] = "Step {$setpCount}: Pending";
									$approveStatus['userId'][$poKey]   = $poValue;
									$approveStatus['poStatus'][$poKey] = 'Pending';
							}*/
							if( $poValue == $poApproveByUser['userId'][$poKey] ){
									$poStatus  = ucfirst($poApproveByUser['status'][$poKey][$poValue]);
									$approveStatus['stepShow'][$poKey] = "Step {$setpCount}: {$poStatus}";
									$approveStatus['userId'][$poKey]   = $poValue;
									$approveStatus['poStatus'][$poKey] = $poStatus;
							}else{
									$approveStatus['stepShow'][$poKey] = "Step {$setpCount}: Pending";
									$approveStatus['userId'][$poKey]   = $poValue;
									$approveStatus['poStatus'][$poKey] = 'Pending';
							}
					}
			}
			return $approveStatus;

	}

	function showApproveBtnInPo($userAprData){
			$showBtnApprove = false;
			foreach($userAprData as $aprKey => $aprValue){
         if( $_SESSION['loggedInUser']->u_id == $aprValue ){
            $showBtnApprove = true;
         }
      }
      return $showBtnApprove;

	}

	function checkUserSendStatus($POST){

		$approveUsersCompany = getSingleAndWhere('selectApproveUsers','purchase_order',['id' => $POST['id'] ]);
		$approveUsersCompany = json_decode($approveUsersCompany,true);

		$approveUsersOrder = getSingleAndWhere('approve_user_detail','purchase_order',['id' => $POST['id'] ]);
		$approveUsersOrder = json_decode($approveUsersOrder,true);

		$countUserOrder = 0;
		$checkUserPosition = 0;
		$orderApproveReturnData = [$_SESSION['loggedInUser']->u_id];
		$orderApproveReturnStatus = [[$_SESSION['loggedInUser']->u_id => $POST['approveStatus'][0]] ];
		if( !empty($approveUsersOrder['userId']) ){
			$countUserOrder = count($approveUsersOrder['userId']);
			$orderApproveReturnData = $approveUsersOrder['userId'] + [$countUserOrder => $_SESSION['loggedInUser']->u_id];
			$orderApproveReturnStatus = mergeMultiDemArray($approveUsersOrder['status'],[[$_SESSION['loggedInUser']->u_id => $POST['approveStatus'][0] ]]);
		}


		if( count($approveUsersCompany) > $countUserOrder ){
			  			foreach($approveUsersCompany as $uIdKey => $uIdValue){
			  				if( $uIdValue == $_SESSION['loggedInUser']->u_id ){
			  						if( $POST['stepNo'] == $countUserOrder ){
				  							return ['data' => $orderApproveReturnData,'msg' => 0,'status' => $orderApproveReturnStatus ];			
				  					}else{
				  						  return ['data' => 0,'msg' => 'Your Previous Step is not complete'];
				  					}
			  				}
			  			}
		}
		return false;

	}

	function approvePoView($orders){
			$selectOption = "";
	      $i = 1;
	      $selectApproveUsers = [];
	      if( isset($orders->selectApproveUsers) ){
	         $poUserApprove = json_decode($orders->approve_user_detail,true);
	         $selectApproveUsers = json_decode($orders->selectApproveUsers,true);
	         $statusIcon = '<i class="fa fa-clock-o" aria-hidden="true"></i>';
	         foreach($selectApproveUsers as $appKey => $appValue){
	            if( in_array($appValue,$poUserApprove) ){
	                     switch($poUserApprove['status'][$appValue]){
	                           case 'approved':
	                                 $statusIcon = '<i class="fa fa-check" aria-hidden="true"></i>';
	                           break;
	                           case 'disapproved':
	                                 $statusIcon = '<i class="fa fa-times-circle"></i>';
	                           break;
	                     }
	                     

	            }else{
	               
	            }
	            $selectOption .= '<div class="col-md-12 col-sm-12 col-xs-12 form-group">';
	            $selectOption .= "<label for='material'>Aprrove Step {$i}<span class='required'>*</span></label>";
	            $selectOption .= '<div class="col-md-7 col-sm-7 col-xs-6">';
	            $selectOption .= getSingleAndWhere('name','user_detail',['u_id' => $appValue]).' '.$statusIcon ;
	            $selectOption .= '</div>';
	            $selectOption .= '</div>';
	         $i++;
	         }
	      }

	      return $selectOption;
	}

	function getPCode($material_name_id){
		 $pCode = "";
	   if( $pCode = getSingleAndWhere('material_code','material',['id' => $material_name_id ]) ){
	      $pCode = $pCode . ' / ';
	   }
	   return $pCode;
	}

	