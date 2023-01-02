<?php

function taxList(){
	$taxes = array(0,0.1,5,12,18,28);
	return $taxes;
}

function updateUsedIdStatus($table='',$id=''){
	$sql = "UPDATE $table SET  used_status = 1 where id = $id";
	$CI =& get_instance();
	$qry = $CI->db->query($sql);
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3){
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$dynamicdb->query($sql);
	}
}

function updatecompleteworkorder($table='',$id=''){
	$sql = "UPDATE $table SET  inprocess_complete = 1 where id = $id";
	$CI =& get_instance();
	$qry = $CI->db->query($sql);
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3){
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$dynamicdb->query($sql);
	}
}

function updateMultipleUsedIdStatus($table='',$whereIds=''){
	$sql = "UPDATE $table SET  used_status = 1 where id IN($whereIds)";
	$CI =& get_instance();
	$qry = $CI->db->query($sql);
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3){
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$dynamicdb->query($sql);
	}

}
function getStates(){
		$states = array('Andhra Pradesh','Arunachal Pardesh','Assam','Bihar','CHANDIAGRH','CHATTISGARH','DADRA & NAGAR HAVELI','DAMAN AND DIU','DELHI','GOA','GUJARAT','HARAYANA','HIMACHAL PARDESH','JAMMU & KASHMIR','JHARKHAND','KARANATAKA','KERALA','LAKSHDWEEP','MADHYA PARDESH','MAHARSAHTRA','MANIPUR','MEGHAYLYA','MIZORAM','NAGALAND','ODISHA','PUDUCHEERY','PUNJAB','RAJASTHAN','SIKIM','TAMILNADU','TELANGANA','TRIPURA','UTTARPARDESH','UTTARAKHAND','WESTBENGAL');
		return $states;
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
function getNameBywitharray($table='',$id='',$field=''){
	 $qry="select * from $table where $field='$id'";
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryy = $CI->db->query($qry);
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
	}
	$result = $qryy->row_array();
	return $result;

}

function getNameBySearch($table='',$id='',$field=''){
    $qry="select * from $table where $field Like '%$id%'";
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

function getNameById_mat($table='',$id='',$field=''){
	// echo "select * from $table where $field='$id'";;die();
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
function getNameById_matWithLoc($table='',$id='',$field='',$secField = '',$LocID=''){
	// echo ;die();
	$qry="select * from $table where $field='$id' AND $secField = '$LocID'";
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

 function get_mat_data($table = '' , $id='',$field='') {
	 $qry="select * from $table where $field='$id' AND job_card != 0";
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
	function getCompanyTableId($table=''){
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$query = $dynamicdb->query("SELECT  name  FROM $table WHERE u_id = '".$_SESSION['loggedInCompany']->u_id."'");
		$result = $query->row();
		return $result;
		/*if(!empty($result))
			return $result->u_id;
		else return false;*/
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

	function create_pdf($dataPdf = array()){

		$CI =& get_instance();

		/*$CI->load->library('Pdf');

		$CI->data['pdfData'] = $CI->purchase_model->get_data_byId('purchase_order','id',$id);
		pre($CI->data['pdfData']);
		$CI->load->view('purchase_order/view_pdf');*/

		$CI->load->library('Pdf');
        $pdf=new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'UTF-8', false);

        $pdf->AddPage();
		//include(APPPATH . '/purchase_order/' . $module_nm . '/views/view_pdf.php');
		include(APPPATH .'modules/purchase/views/purchase_order/view_pdf.php');
		$pdf->Output();

	}

	function getDashboardCount($startDate = '', $endDate = ''){

		$ci = & get_instance();

	 $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;



		if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3){
			if($_SESSION['loggedInUser']->role == 2){
				$where = ' created_by='.$_SESSION['loggedInUser']->u_id;
				$accountWhere = ' created_by='.$_SESSION['loggedInUser']->u_id;
				$contactWhere = ' created_by='.$_SESSION['loggedInUser']->u_id;
			}else{
				$where = ' created_by_cid='.$ci->companyId;
			}
			if($startDate != '' && $endDate != ''){
				$btwQuery = ' AND created_date >="'.$startDate . '" AND created_date <="' .$endDate . '"' ;
			}else{
				$btwQuery = ' AND DATE_FORMAT(created_date, "%Y") = YEAR (CURDATE())' ;
			}
			$qry="SELECT 'Material' as name,'Total Product Available.' as description, Count(material_type_id) as total, 'fa fa-caret-square-o-right' as icon   FROM material WHERE status = 1 AND $where   $btwQuery
			UNION
			SELECT 'Work In Process' as name,'Total work in process product.' as description, COUNT(material_type_id) as total, 'fa fa-area-chart' as icon FROM work_in_process_material WHERE $where $btwQuery";

			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);

			$result = $qryy->result_array();
			return $result;
		}
	}


	function getMonthInventoryListingGraph($startDate = '', $endDate = ''){

		$ci = & get_instance();

	 $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

		if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3){
			if($_SESSION['loggedInUser']->role == 2){
				$where = ' AND inventory_listing.created_by='.$_SESSION['loggedInUser']->u_id;
			}else{
				$where = ' AND inventory_listing.created_by_cid='.$ci->companyId;

			}

			$btwQuery = '' ;
			if($startDate != '' && $endDate != ''){
				$btwQuery = ' AND inventory_listing.created_date >="'.$startDate . '" AND inventory_listing.created_date <="' .$endDate . '"' ;
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
				 , 9 ) as period ,

				  SUM(CASE WHEN inventory_listing.action_type = 'move' THEN quantity ELSE 0 END) moveQty,  SUM(CASE WHEN inventory_listing.action_type = 'scrap' THEN quantity ELSE 0 END) scrapQty,  SUM(CASE WHEN inventory_listing.action_type = 'consumed' THEN quantity ELSE 0 END) consumedQty , SUM(CASE WHEN inventory_listing.action_type = 'half_full_book' THEN quantity ELSE 0 END) halfBookQty , SUM(CASE WHEN inventory_listing.action_type = 'stock_check' THEN quantity ELSE 0 END) stockCheckQty  FROM
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
		LEFT JOIN inventory_listing  on Months.m = MONTH(inventory_listing.created_date) $where AND DATE_FORMAT(inventory_listing.created_date, '%Y') = YEAR (CURDATE()) $btwQuery
		GROUP BY
			Months.m";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->result_array();
			return $result;
		}
	}


	function getStockSummary($startDate = '', $endDate = ''){

		$ci = & get_instance();

	 $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

		if($_SESSION['loggedInUser']->role == 2){

			$where = ' material.created_by_cid='.$_SESSION['loggedInUser']->u_id ;
		}else{
			$where = ' material.created_by_cid='.$ci->companyId ;
		}
		if($startDate != '' && $endDate != ''){
			$btwQuery = ' AND material.created_date >="'.$startDate . '" AND material.created_date <="' .$endDate . '"' ;
		}else{
			$btwQuery = ' AND DATE_FORMAT(material.created_date, "%Y") = YEAR (CURDATE())' ;
		}
		$qry2="SELECT material_type.name as Name, ROUND(SUM(cost_price)) as total FROM material_type LEFT JOIN material ON material_type.id = material_type_id where $where GROUP BY material_type.id ";

		$CI =& get_instance();
		if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){

			$MaterialAmountActivityQry = $CI->db->query($qry2);
		}else{
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$MaterialAmountActivityQry = $dynamicdb->query($qry2);
		}
		$MaterialAmountActivityResult = $MaterialAmountActivityQry->result_array();
		return $MaterialAmountActivityResult;

	}

	function getScrappedDetail($startDate = '', $endDate = ''){

		$ci = & get_instance();

	 $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


		if($_SESSION['loggedInUser']->role == 2){
			$where = ' inventory_listing.created_by='.$_SESSION['loggedInUser']->u_id;
		}else{
			$where = ' inventory_listing.created_by_cid='.$ci->companyId;
		}
		if($startDate != '' && $endDate != ''){
			$btwQuery = ' AND inventory_listing.created_date >="'.$startDate . '" AND inventory_listing.created_date <="' .$endDate . '"' ;
		}else{
			$btwQuery = ' AND DATE_FORMAT(inventory_listing.created_date, "%Y") = YEAR (CURDATE())' ;
		}
		$qry= "select material.id, material_type.name, inventory_listing.uom, inventory_listing.material_name_id, sum(inventory_listing.quantity) as sum from inventory_listing left join material
		on  inventory_listing.material_name_id = material.id
			LEFT JOIN material_type
				on material_type.id = material.material_type_id
				where action_type = 'scrap'
				group by material.material_type_id";

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




	function getPermissionsForDashboard($where = array()){
		if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3){
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$dynamicdb->select('permissions.*,sub_module.sub_module_name,sub_module.slug,modules.id as moduleId');
			$dynamicdb->from('permissions');
			$dynamicdb->join('sub_module', 'permissions.sub_module_id = sub_module.id', 'left');
			$dynamicdb->join('modules', 'modules.id = sub_module.modules_id', 'left');
			$dynamicdb->where($where);
			$query = $dynamicdb->get();
			$result = $query->result_array();
			return $result;
		}
}






/* Exprot Code */

function export_csv_excel($data3 = array()){
 // pre($data3);die();
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
				// pre($data3);die();
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
				$filename = $_GET["ExportType"] . ".xls";
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
        switch($_GET["ExportType_blank"]){
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
   $heading = false;
   if(!empty($records))
        ob_end_clean();
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

/************ closing balance calculation   *************/
function getClosingBalance($material_id ='' , $dateOn = ''){

	$ci = & get_instance();

	 $ci->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


	//pre($material_id);
	$dateOn = $dateOn !=''?$dateOn:date("Y-m-d h:i:s");
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){

		$CI->db->select('material_id,sum(material_in) as sum_material_in ,sum(material_out) as sum_material_out');
		$CI->db->from('inventory_flow');
		//$CI->db->where(array('material_id'=> $material_id , 'created_by_cid'=> $ci->companyId , 'created_date <=' => $dateOn ));
		$CI->db->where(array('material_id'=> $material_id , 'created_by_cid'=> $ci->companyId));
		$query = $CI->db->get();
		$CI->db->select('opening_balance');
		//$CI->db->select('id,opening_balance');
		$CI->db->from('material');
		$CI->db->where(array('id'=> $material_id , 'created_by_cid'=> $ci->companyId ));
		//$CI->db->where('opening_balance!=',0);
		$materialQuery = $CI->db->get();

	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$dynamicdb->select('material_id,sum(material_in) as sum_material_in ,sum(material_out) as sum_material_out');
		$dynamicdb->from('inventory_flow');
		//$dynamicdb->where(array('material_id'=> $material_id , 'created_by_cid'=> $ci->companyId , 'created_date <=' => $dateOn ));
		$dynamicdb->where(array('material_id'=> $material_id , 'created_by_cid'=> $ci->companyId));
		$query = $dynamicdb->get();
		#pre($dynamicdb->last_query());
		$dynamicdb->select('opening_balance');
		//$dynamicdb->select('id,opening_balance');
		$dynamicdb->from('material');
		$dynamicdb->where(array('id'=> $material_id , 'created_by_cid'=> $ci->companyId));
		//$dynamicdb->where('opening_balance!=',0);
		$materialQuery = $dynamicdb->get();
		//pre($dynamicdb->last_query());
	}
	$result = $query->row();
//pre($result);
	$materialResult = $materialQuery->row();

		$openingBalance = !empty($materialResult->opening_balance)?$materialResult->opening_balance:0;

	if(!empty($result)){

		$openingBalance = $openingBalance + $result->sum_material_in;
		$openingBalance  = $openingBalance - $result->sum_material_out;

	}

	return  $openingBalance;
}

function updateclosing_balace($value,$id,$created_by_cid){
	$sql = "UPDATE material SET closing_balance = $value where id = $id AND created_by_cid = $created_by_cid";
	$CI =& get_instance();
	$qry = $CI->db->query($sql);
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3){
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$dynamicdb->query($sql);
		#echo $dynamicdb->last_query();
	}
}


function discountOffered(){
	$discountOffered = array('Cash Discount','UOM Rate','Quantity Discount','Annual Ternover Discount');
	return $discountOffered;
}

function documentSubmitedWithDispatch(){
	$documentSubmitedWithDispatch = array('Orignal Invoice','Duplicate Invoice','Packing List','Insurance','Test Certificate','Test Report','Way Bill','AGT Receipt','GR Copy' ,"Customer's PO Copy");
	return $documentSubmitedWithDispatch;
}
/************ closing balance calculation   *************/
/* function getClosingOpeningBalance($material_id ='' , $dateFrom = '',$dateTo = ''){
	$dateFrom = $dateFrom !=''?$dateFrom:date("Y-m-d 00:00:00");
	$dateTo = $dateTo !=''?$dateTo:date("Y-m-d 23:59:59");
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$CI->db->select('material_id,sum(material_in) as sum_material_in ,sum(material_out) as sum_material_out');
		$CI->db->from('inventory_flow');
		$CI->db->where(array('material_id'=> $material_id , 'created_by_cid'=> $ci->companyId , 'created_date <=' => $dateFrom ));
		$queryOpening = $CI->db->get();
		$resultOpening = $queryOpening->row();

		$CI->db->select('material_id,sum(material_in) as sum_material_in ,sum(material_out) as sum_material_out');
		$CI->db->from('inventory_flow');
		$CI->db->where(array('material_id'=> $material_id , 'created_by_cid'=> $_SESSION['loggedInUser']->c_id , 'created_date <=' => $dateTo ));
		$queryClosing = $CI->db->get();
		$resultClosing = $queryClosing->row();


	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$dynamicdb->select('material_id,sum(material_in) as sum_material_in ,sum(material_out) as sum_material_out');
		$dynamicdb->from('inventory_flow');
		$dynamicdb->where(array('material_id'=> $material_id , 'created_by_cid'=> $ci->companyId , 'created_date <=' => $dateFrom ));
		$queryOpening = $dynamicdb->get();
		$resultOpening = $queryOpening->row();

		$dynamicdb->select('material_id,sum(material_in) as sum_material_in ,sum(material_out) as sum_material_out');
		$dynamicdb->from('inventory_flow');
		$dynamicdb->where(array('material_id'=> $material_id , 'created_by_cid'=> $_SESSION['loggedInUser']->c_id , 'created_date <=' => $dateTo ));
		$queryClosing = $dynamicdb->get();
		$resultClosing = $queryClosing->row();

	}

	$openingBalance = 0;
	$closingBalance = 0;
	if(!empty($resultOpening)){
		$openingBalance  = $resultOpening->sum_material_in - $resultOpening->sum_material_out;

	}
	if(!empty($resultClosing)){
		$closingBalance  = $resultClosing->sum_material_in - $resultClosing->sum_material_out;

	}
	#pre();
	return array('openingBalance' => $openingBalance,'closingBalance' => $closingBalance);
} */
	function getclosingbb($mat_id){

	$yu = getNameById_mat('mat_locations',$mat_id,'material_name_id');
	$sum = 0;
	 if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
	 else{ $sum = 0;}
	 return $sum;
	}


	function getclosingbbtype($mat_id){

	$yu = getNameById_mat('mat_locations',$mat_id,'material_type_id');
	$sum = 0;
	 if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
	 else{ $sum = 0;}
	 return $sum;
	}



	function issuedMaterialQuantity($work_order_id, $material_id){
		$CI =& get_instance();
		$workOrderId = '"'.$work_order_id.'"';
		$materialId  = '"'.$material_id.'"';
		$columnName = '{"work_order_id":'.$workOrderId.',"material_id":'.$materialId.'}';
		$where = "JSON_CONTAINS(mat_detail, '$columnName')";
		$table = 'wip_request';
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,');
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		//$dynamicdb->where('issued_status',1);
		$qry = $dynamicdb->get();
		 //echo $dynamicdb->last_query().'<br/>'; die;

		 if($qry !== FALSE && $qry->num_rows() > 0){
               foreach ( $result = $qry->result_array() as $row) {
          $data[] = $row;
        }
      }
		$totalQuantity = 0;
		if($result){

			$materialData = array();
			foreach($result as $info){
				$materialDetails = json_decode($info['mat_detail'],true);
				if($materialDetails){
					foreach($materialDetails as $materialInfo){
						if($material_id == $materialInfo['material_id'] ){
							$materialData[] = $materialInfo;
						}
					}
				}
			}
			//pre($materialData);
			if($materialData){
				foreach($materialData as $information){
					$totalQuantity += $information['quantity'];
				}

			}
		}
		return $totalQuantity;
	}






	function workOrderDetails($table,$workOrderId){
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,');
		$dynamicdb->from($table);
		$dynamicdb->where('id',$workOrderId);
		$qry = $dynamicdb->get();
		$result = $qry->row_array();
		return $result;
	}

	function getSingleAndWhere($select,$table,$where){
		$ci =& get_instance();
		$dynamicdb = $ci->load->database('dynamicdb', TRUE);
		$data = $dynamicdb->select($select)
				->where($where)->get($table)->row_array();
		return $data[$select];
	}

	function getMaterialIdPrice($select,$table,$where,$jsonCoulmn){
		$whereKey       = array_keys($where);
		$whereMaterial  =  '"'.$whereKey[0].'":'.'"'.$where[$whereKey[0]].'"';
		$whereLike      = "$select LIKE '%{$whereMaterial}%'";
		$ci =& get_instance();
		$dynamicdb = $ci->load->database('dynamicdb',TRUE);
		$data 	   = $dynamicdb->select($select)
					->where($whereLike)->order_by('id','desc')
					->get($table)->row_array();
		if( $data ){
			$mat = json_decode($data[$select],true);
			if( $mat ){
				foreach ($mat as $key => $value) {
					if( $where[$whereKey[0]] == $value[$whereKey[0]] ){
						return $value[$jsonCoulmn];
					}
				}
			}
		}
		return 0;
	}

	function findExistRow($table,$where){
		$ci =& get_instance();
		$dynamicdb = $ci->load->database('dynamicdb', TRUE);
		return $dynamicdb->where($where)->get($table)->num_rows();
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

	function getTotalResivQty($where){
		$ci =& get_instance();
		$companyGroupId = (isset($_SESSION['companyGroupSessionId']) &&
								$_SESSION['companyGroupSessionId']!=''&& $_SESSION['companyGroupSessionId'] != 0)?
								$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id;
		$dynamicdb = $ci->load->database('dynamicdb', TRUE);

		$where = $where + ['created_by_cid' => $companyGroupId];
		$data = $dynamicdb->select('SUM(quantity) as resivQty')->where($where)->get('reserved_material')->row_array();
		if( isset($data['resivQty']) ){
			if( !empty($data['resivQty']) ){
				return $data['resivQty'];
			}
		}
		return 0;

	}
function get_available_mat_quantity($mat_id) {
        #check material quanity
        $yu = getNameById_mat('mat_locations', $mat_id, 'material_name_id');
        $sum = 0;
         if (!empty($yu)) {
            foreach ($yu as $ert) {
                $sum+= $ert['quantity'];
            }
        }

        #check reserved quanity
        $yu1 = getNameById_mat('reserved_material', $mat_id, 'mayerial_id');
        $reserved = 0;
        if (!empty($yu1)){
            foreach ($yu1 as $ert1) { $reserved += $ert1['quantity']; }
        }
        $total = $sum - $reserved;
        return $total;
    }
	
	
		function getDbitcrditNoteNumber($table='',$id='',$field='',$debitnotetyp){
			//echo "SELECT id FROM ".$table." where ".$field." = ".$id." AND `PurchaseReturn_DN_ornot` = ".$debitnotetyp." ORDER BY id DESC LIMIT 1";
			$qry= "SELECT id FROM ".$table." where ".$field." = ".$id." AND `PurchaseReturn_DN_ornot` = ".$debitnotetyp." ORDER BY id DESC LIMIT 1";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->row();
			return $result;
		}
	
	function lastRefrenceNo($select,$table){
		$ci =& get_instance();
		$dynamicdb = $ci->load->database('dynamicdb', TRUE);
		$data = $dynamicdb->select($select)->order_by('id','desc')->get($table)->row_array();
		if( $data[$select] ) {
			return $data[$select];
		}
		return 'N/A';
	}
	

	


	?>
