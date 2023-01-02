<?php
function taxList(){
	$taxes = array(0,0.1,5,12,18,28);
	return $taxes;
}
function updateUsedIdStatus($table='',$id=''){
	$sql = "UPDATE $table SET  used_status = 1 where id = $id";
	$CI =& get_instance();
	$qry = $CI->db->query($sql);
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$qry = $dynamicdb->query($sql);
}

function updateMultipleUsedIdStatus($table='',$whereIds=''){
	$sql = "UPDATE $table SET  used_status = 1 where id IN($whereIds)";
	$CI =& get_instance();
	$qry = $CI->db->query($sql);
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$qry = $dynamicdb->query($sql);
}


function getNameById($table='',$id='',$field=''){
	$qry="select * from $table where $field='$id'";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$qryy = $dynamicdb->query($qry);
	//echo 	$dynamicdb->last_query();
	$result = $qryy->row();
	return $result;
}

function getMaxByField($table='',$field=''){
	$qry="SELECT MAX(`$field`) AS `$field` FROM `$table`";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$qryy = $dynamicdb->query($qry);
	//echo 	$dynamicdb->last_query();
	$result = $qryy->result();
	return $result[0]->priority_order;
}

function documentSubmitedWithDispatch(){
	$documentSubmitedWithDispatch = array('Orignal Invoice','Duplicate Invoice','Packing List','Insurance','Test Certificate','Test Report','Way Bill','AGT Receipt','GR Copy' ,"Customer's PO Copy");
	return $documentSubmitedWithDispatch;
}

/*function getLastTableId($table=''){
	$CI =& get_instance();
	$query = $CI->db->query("SELECT * FROM $table ORDER BY id DESC LIMIT 1");
	$result = $query->row();
	return $result->id;
}
*/
function getLastTableId($table=''){
	$CI =& get_instance();

	$masterDb = $CI->load->database('dynamicdb', TRUE);
	$masterDbQuery =$CI->db->query("SELECT * FROM $table ORDER BY id DESC LIMIT 1");
	$masterDbResult = $masterDbQuery->row();

	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$query = $dynamicdb->query("SELECT * FROM $table ORDER BY id DESC LIMIT 1");
	$result = $query->row();
	if(!empty($result))
		return $result->id;
	elseif(empty($result)){

		return $masterDbResult->id;
	}
	else return false;
}

function getWeekdays(){
		$weeks = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		return $weeks;
}


function getMonth(){
		$month = array('January ','Feburary','March','April','May','June','July','August','September','October','November','December');
		return $month;
}


function getDashboardCount($startDate = '', $endDate = ''){
		$companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		if($_SESSION['loggedInUser']->role == 2){
			$where = ' created_by='.$_SESSION['loggedInUser']->u_id;
			$accountWhere = ' created_by='.$_SESSION['loggedInUser']->u_id;
			$contactWhere = ' created_by='.$_SESSION['loggedInUser']->u_id;

		}else{
			/* $where = ' created_by_cid='.$_SESSION['loggedInUser']->c_id;
			$accountWhere = ' account_owner='.$_SESSION['loggedInUser']->c_id;
			$contactWhere = ' contact_owner='.$_SESSION['loggedInUser']->c_id; */
			$where = ' created_by_cid='.$companyGroupId;
			$accountWhere = ' account_owner='.$companyGroupId;
			$contactWhere = ' contact_owner='.$companyGroupId;
		}
		if($startDate != '' && $endDate != ''){
			$btwQuery = ' AND created_date >="'.$startDate . '" AND created_date <="' .$endDate . '"' ;
		}else{
			$btwQuery = ' AND DATE_FORMAT(created_date, "%Y") = YEAR (CURDATE())' ;
		}
		//$qry="SELECT 'Material' as name, 'Total material created.' as description , 'fa fa-caret-square-o-right' as icon , COUNT(cost_price) as totalCount FROM material WHERE $where   $btwQuery";
		$qry="SELECT 'Material' as name, SUM(opening_balance) as totalAmount, 'fa fa-caret-square-o-right' as icon   FROM material WHERE $where   $btwQuery";
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
		$result = $qryy->result_array();
		return $result;
	}

	/*production data */
	function getPoductionDataListingGraph($startDate = '', $endDate = ''){
		$companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		if($_SESSION['loggedInUser']->role == 2){
			$where = ' AND production_data.created_by='.$_SESSION['loggedInUser']->u_id;
		}else{
			#$where = ' AND production_data.created_by_cid='.$_SESSION['loggedInUser']->c_id;
			$where = ' AND production_data.created_by_cid='.$companyGroupId;
		}
		$btwQuery = '' ;
		if($startDate != '' && $endDate != ''){
			$btwQuery = ' AND production_data.created_date >="'.$startDate . '" AND production_data.created_date <="' .$endDate . '"' ;
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
		$qryy = $dynamicdb->query($qry);
		//pre($dynamicdb->last_query());
		$result = $qryy->result_array();
		$sumArray = array();
		$i = 0;
			foreach($result as $key => $res){
				//pre( $res);
				$sumArray[$i]['month'] =  $res['period'];
				$productionData  = json_decode($res['production_data']);

				//$sumConsumed = 0;
				//$sumWastage = 0;
				//$sumElectricity = 0;
				$sumOutput = 0;
				$output = 0;
				//$sumCosting = 0;
				//$sumDowntime = 0;
					if(!empty($productionData)){
						foreach($productionData as $pd){
						//pre($pd);
							//$pd->material_consumed = $pd->material_consumed?$pd->material_consumed:0;
							//$pd->wastage = $pd->wastage?$pd->wastage:0;
							//$pd->electricity = ($pd->electricity && $pd->electricity !='')?$pd->electricity:0;
							//$electricity = (int)($pd->electricity && $pd->electricity !='')?$pd->electricity:0;
							//pre(gettype($electricity));
							//$pd->output = ($pd->output && $pd->output !='')?$pd->output:0;
							if(empty($pd->output)){
								foreach($pd->output as $op){

									$output = ($op && $op !="")?($op):0;
								}
							}

							foreach($pd->output as $out){
									//pre($out);
									$output = ($out && $out !="")?($out):0;
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
			$k=0;
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

					$merged = [];
							foreach ($CombinedArray as $month => $data) {
							  $merged[] = $data;
							}
				}
		return $merged;
	}



	/*production planning*/
	function getProductionPlanning($startDate = '', $endDate = ''){
		$companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		if($_SESSION['loggedInUser']->role == 2){
			$where = ' AND production_planning.created_by='.$_SESSION['loggedInUser']->u_id;
		}else{
			#$where = ' AND production_planning.created_by_cid='.$_SESSION['loggedInUser']->c_id;
			$where = ' AND production_planning.created_by_cid='.$companyGroupId;
		}
		$btwQuery = '' ;
		if($startDate != '' && $endDate != ''){
			$btwQuery = ' AND production_planning.created_date >="'.$startDate . '" AND production_planning.created_date <="' .$endDate . '"' ;
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
		$qry = $dynamicdb->query($qry);
		$result = $qry->result_array();
		$PlanArray = array();
		$j =0;
			foreach($result as $key => $plan){
				$PlanArray[$j]['month'] =  $plan['period'];
				$prodPlan = json_decode($plan['planning_data']);
				$sumOutput = 0;
				if(!empty($prodPlan)){
					foreach($prodPlan as $prod_plan){
						#$sumOutput += $prod_plan->output?$prod_plan->output:0;
						$sumOutput += $prod_plan->output[0]?$prod_plan->output[0]:0;
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

					$mergedData = [];
							foreach ($planCombinedArray as $month => $Plandata) {
							  $mergedData[] = $Plandata;
							}
				}
		return $mergedData;

	}


	/*comparison chart
	function getComparison($startDate = '', $endDate = ''){
		if($_SESSION['loggedInUser']->role == 2){
			$where = ' AND production_data.created_by='.$_SESSION['loggedInUser']->u_id;
		}else{
			$where = ' AND production_data.created_by_cid='.$_SESSION['loggedInUser']->c_id;
		}

		$btwQuery = '' ;
		if($startDate != '' && $endDate != ''){
			$btwQuery = ' AND production_data.created_date >="'.$startDate . '" AND production_data.created_date <="' .$endDate . '"' ;
		}
		$qry="SELECT  AAA.date_field , pd.shift , pd.production_data ,ps.data
			FROM
			(
				SELECT date_field
					FROM
					(
						SELECT MAKEDATE(YEAR(NOW()),1) +
						INTERVAL (MONTH(NOW())-1) MONTH +
						INTERVAL daynum DAY date_field
						FROM
						(
							SELECT t*10+u daynum FROM
							(SELECT 0 t UNION SELECT 1 UNION SELECT 2 UNION SELECT 3) A,
							(SELECT 0 u UNION SELECT 1 UNION SELECT 2 UNION SELECT 3
							UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
							UNION SELECT 8 UNION SELECT 9) B ORDER BY daynum
						) AA
					) AA WHERE MONTH(date_field) = MONTH(NOW())
			) AAA LEFT JOIN production_data as pd on AAA.date_field = pd.date
				LEFT JOIN production_scheduling as ps on AAA.date_field = pd.date
			Group BY date_field";
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qry = $dynamicdb->query($qry);
		//pre($dynamicdb->last_query());
		$result = $qry->result_array();
		//pre($result);
		$compareArray = array();
		$j =0;
			foreach($result as $key => $compare){
				$compareArray[$j]['date'] =  $compare['date_field'];
				$compareData = json_decode($compare['production_data']);
				$sumOutput = 0;
				if(!empty($compareData)){
					foreach($compareData as $compare_data){
						//pre($compare_data);
						$sumOutput += $compare_data->output;
					}
				}
				$compareData2 = json_decode($compare['data']);

					//pre($compareData2);
				$compareArray[$j]['sumOutput'] = $sumOutput;
				$j++;
			}
		return $compareArray;


	}*/

 //LEFT JOIN production_scheduling as ps on AAA.date_field = ps.date

 function export_csv_excel($data3 = array()){

	 if(!empty($_GET['ExportType'])){

	// pre($_GET['ExportType']);
 	// die;
		 ob_end_clean();
		switch($_GET["ExportType"]){
			case "export-to-excel" :
				// Submission from
				$filename = $_GET["ExportType"] . ".xls";
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
	/**
	 * Calculate percetage between the numbers
	 */

	function percentageOfOutput( $production_data, $production_planning, $decimals = 2 ){

		$TargetOutputsum = 0;
		$ActualOutputsum = 0;
		if (!empty($production_planning))
		{
			foreach ($production_planning as $pwd)
			{
				if (!empty($pwd))
				{
				//	pre($pwd);die;
					$wagesLength = !empty($pwd->machine_name_id) ? (count($pwd->machine_name_id)) : 0;

					for ($i = 0;$i < $wagesLength;$i++)
					{
						if (isset($pwd->output))
						{
							if( $pwd->output[$i] && isset($pwd->output[$i]) ){
								 $TargetOutputsum += isset($pwd->output[$i]) ? (int)$pwd->output[$i] : (int)$pwd->output;
							}
						}

					}

				}

			}

		}

		if (!empty($production_data))
		{

			foreach ($production_data as $pwd)
			{
				if (!empty($pwd))
				{
					$wagesLength = !empty($pwd->wages_or_per_piece) ? (count($pwd->wages_or_per_piece)) : 0;

					for ($i = 0;$i < $wagesLength;$i++)
					{
						if (isset($pwd->output))
						{
							$ActualOutputsum += is_numeric($pwd->output[$i]) ? $pwd->output[$i] : 0;
						}

					}

				}

			}
		}
		$TargetOutputsum = ($TargetOutputsum == 0) ? 100 : $TargetOutputsum;
	    // echo "ActualOutputsum=".$ActualOutputsum;	     echo " TargetOutputsum=".$TargetOutputsum;
		 $percentage = ($ActualOutputsum/$TargetOutputsum)*100;
		//if($ActualOutputsum >= $TargetOutputsum){ $percentage = ($ActualOutputsum/$TargetOutputsum)*100; }else{
			//			 $percentage =  ($TargetOutputsum - $ActualOutputsum/$TargetOutputsum)*100; }
		return round( $percentage , $decimals );
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

	function get_workOrder_number_count($table='',$id='',$field=''){
		$qry= "SELECT count(*) as total_challan FROM ".$table." where ".$field." = ".$id." ORDER BY id DESC LIMIT 1";
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
		$result = $qryy->row();
		return $result;
	}
	function getPendingQtyOfSalesOrder($table='',$id='',$field=''){
		$qry= "SELECT id,product_detail FROM ".$table." where ".$field." = ".$id." ORDER BY id DESC LIMIT 1";
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
		$result = $qryy->row();
			$Pending_quantity = array();
		if(ISSET($result->product_detail)){
		$lastWorkorderDetail = json_decode($result->product_detail);
		 $Pending_quantity = $lastWorkorderDetail;
		}
		return $Pending_quantity;

	}
	function getWorkOrderTotalQty($table='',$id='',$field=''){
		$qry= "SELECT id,product_detail FROM ".$table." where ".$field." = ".$id;
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
		$result = $qryy->row();
		$Pending_quantity = array();
		if(ISSET($result->product_detail)){
			$Pending_quantity = json_decode($result->product_detail);
		}
		return $Pending_quantity;
	}

	 function get_data_byId_fromMaterial($table ,$field, $id){
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$dynamicdb->select('job_card.*');
		$dynamicdb->from($table);
		$dynamicdb->join('job_card', $table.'.job_card = job_card.id', 'LEFT');
		$dynamicdb->where($table.'.'.$field, $id);
		$qry = $dynamicdb->get();
		$result = $qry->row();
		return $result;
	}
 	function get_production_data($id){
		$qry = "SELECT * FROM `production_data` WHERE JSON_SEARCH(`production_data`, 'all', '".$id."', NULL, '$[*].work_order[*]') IS NOT NULL";
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
		$result = $qryy->result();
		//pre($result);die;
		return $result;
	}
	function get_finishgoods_data($id){
		//$qry = "SELECT `job_card_detail`,JSON_SEARCH(`job_card_detail`, 'all', '".$id."', '', '$[*].work_order_id') as job_card_detail FROM `finish_goods`";$qry = "SELECT `job_card_detail`,JSON_SEARCH(`job_card_detail`, 'all', '".$id."', '', '$[*].work_order_id') as job_card_detail FROM `finish_goods`";
			$comma = "'";
		 $qry = 'SELECT `job_card_detail` FROM `finish_goods` Where `job_card_detail` LIKE '.$comma.'%"work_order_id":"'.$id.'"%'.$comma.'';
		//'`production_data` LIKE '.$bb.'%"npdm":["'.$a.'"]%'.$cc.''
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
		$result = $qryy->result();
		//pre($result);die;
		return $result;
	}

	 // Function to convert array into
	// stdClass object
	function ToObject($Array) {

		// Create new stdClass object
		$object = new stdClass();
		// Use loop to convert array into
		// stdClass object
		foreach ($Array as $key => $value) {
			if (is_array($value)) {
				$value = ToObject($value);
			}
			$object->$key = $value;
		}
		return $object;
	}
	function minutes($time){
		$time = explode(':', $time);
		return ($time[0]*60) + ($time[1]) + ($time[2]/60);
	}

	function getDay($week_off){
    $dowMap = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		foreach($week_off as $dayNo){
		$dow_numeric[] = date('w',strtotime($dayNo));
		}
        return $dow_numeric;

    }

    function getRequiredQuantityForProcess($table,$job_card_id,$column_name,$process_id){
		$processId 		= '"'.$process_id.'"';
		$columnName 	= '{'.'"'.$column_name.'"'.':'.$processId.'}';
		$where 			= "JSON_CONTAINS(machine_details, '$columnName')";
		$CI 		=	& get_instance();
		$dynamicdb 	= 	$CI->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,');
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$dynamicdb->where('id',$job_card_id);
		$qry = $dynamicdb->get();
		$result 	= 	$qry->row_array();
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

	function get_finish_scrap_data($table, $whereConditionColumns, $whereConditionJsonKeys, $whereConditionData) {
		$CI =& get_instance();
		$workOrderId 			= '"'.$whereConditionData['work_order_id'].'"';
		$jsonColumnNameFirst 	= '{'.'"'.$whereConditionJsonKeys['json_column_key_work'].'"'.':'.$workOrderId.'}';
		$columnNameFirst 		= $whereConditionColumns['column_name_job'];
		$materialId 			= '"'.$whereConditionData['material_name_id'].'"';
		$jsonColumnNameSecond 	= '{'.'"'.$whereConditionJsonKeys['json_column_key_material'].'"'.':'.$materialId.'}';
		$columnNameSecond 		= $whereConditionColumns['column_name_scrap'];
		$where = "JSON_CONTAINS($columnNameFirst, '$jsonColumnNameFirst') and JSON_CONTAINS($columnNameSecond, '$jsonColumnNameSecond')";
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,');
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		//echo $dynamicdb->last_query().'<br/>';
		$result = $qry->result_array();
		$quantity = 0;
		if($result){
			foreach($result as $scrapInfo){
				$scrapMaterials = json_decode($scrapInfo['scrap_material_detail'],true);
				if($scrapMaterials){
					foreach($scrapMaterials as $scrapMaterial){
						if($scrapMaterial['material_name_id'] == $whereConditionData['material_name_id'] && $scrapMaterial['work_order_id'] == $whereConditionData['work_order_id']){
							$quantity += $scrapMaterial['quantity'];
						}
					}
				}
			}
		}
		return $quantity;
    }


    function get_finish_quantity_data($table, $whereConditionColumns, $whereConditionJsonKeys, $whereConditionData) {
		$CI =& get_instance();
		$workOrderId 			= '"'.$whereConditionData['work_order_id'].'"';
		$jsonColumnNameFirst 	= '{'.'"'.$whereConditionJsonKeys['json_column_key_work'].'"'.':'.$workOrderId.'}';
		$columnNameFirst 		= $whereConditionColumns['column_name_job'];
		$materialId 			= '"'.$whereConditionData['material_id'].'"';
		$jsonColumnNameSecond 	= '{'.'"'.$whereConditionJsonKeys['json_column_key_material'].'"'.':'.$materialId.'}';
		$columnNameSecond 		= $whereConditionColumns['column_name_material'];
		$where = "JSON_CONTAINS($columnNameFirst, '$jsonColumnNameFirst') and JSON_CONTAINS($columnNameSecond, '$jsonColumnNameSecond')";
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$dynamicdb->select($table.'.*,');
		$dynamicdb->from($table);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		$result = $qry->result_array();
		$quantity = 0;
		if($result){
			foreach($result as $dataInfo){
				$materialData = json_decode($dataInfo['job_card_detail'],true);
				if($materialData){
					foreach($materialData as $materialInfo){
						if($materialInfo['material_id'] == $whereConditionData['material_id'] && $materialInfo['work_order_id'] == $whereConditionData['work_order_id']){
							$quantity += $materialInfo['output'];
						}
					}
				}
			}
		}
		return $quantity;
    }

   function timeToSeconds(string $time): int
{
    $arr = explode(':', $time);
    if (count($arr) == 3) {
        return (int)$arr[0] * 3600 + (int)$arr[1] * 60 + (int)$arr[2];
    } else {
        return (int)$arr[0] * 60 + (int)$arr[1];
    }
}
function array_orderby()
{
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
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
?>
