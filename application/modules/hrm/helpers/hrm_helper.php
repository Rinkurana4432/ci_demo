<?php
/**
 Get Department data for Datatable Listing
 */
function user_tbl_data() {
    $can_edit = true; //edit_permissions();
    $can_delete = true; //delete_permissions();
    $where = array();
    $join = array();
    $filter = array();
    $aColumns = array('user.id as id', 'user.firstname as name', 'user.user_profile as user_profile', 'company.email as email', 'user.designation as designation', 'user.age as age', 'user.contact_no as contact_no', 'user.experience as experience', 'user.date_joining as date_joining',);
    $join = array('LEFT JOIN company on company.id = user.company_id',);
    $result = data_tables_init($aColumns, 'id', 'user', $join, $where, array());
    $output = $result['output'];
    $rResult = $result['rResult'];
    if (!empty($rResult)) {
        foreach ($rResult as $aRow) {
            $row = array();
            $row['id'] = $aRow['id'];
            $row['name'] = ucfirst($aRow['name']);
            $row['user_profile'] = ucfirst($aRow['user_profile']);
            $row['email'] = $aRow['email'];
            $row['designation'] = $aRow['designation'];
            $row['age'] = $aRow['age'];
            $row['contact_no'] = $aRow['contact_no'];
            $row['experience'] = $aRow['experience'];
            $row['date_joining'] = $aRow['date_joining'];
            $options = '';
            if ($can_edit) {
                $options.= '<a href="javascript:void(0)" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" class="add_departments btn btn-primary" id="' . $aRow['id'] . '"><i class="fa fa-pencil"></i></a>';
            }
            if ($can_delete) {
                $options.= '<a href="javascript:void(0)" class="delete_listing_without btn btn-danger" data-href="' . base_url() . 'departments/delete/' . $aRow['id'] . '"><i class="fa fa-trash"></i></a>';
            }
            $row['action'] = $options;
            $hook = array('output' => $row, 'row' => $aRow);
            $row = $hook['output'];
            $options = '';
            $output['data'][] = $row;
        }
    }
    return $output;
}
function getStates() {
    $states = array('Andhra Pradesh', 'Arunachal Pardesh', 'Assam', 'Bihar', 'CHANDIAGRH', 'CHATTISGARH', 'DADRA & NAGAR HAVELI', 'DAMAN AND DIU', 'DELHI', 'GOA', 'GUJARAT', 'HARAYANA', 'HIMACHAL PARDESH', 'JAMMU & KASHMIR', 'JHARKHAND', 'KARANATAKA', 'KERALA', 'LAKSHDWEEP', 'MADHYA PARDESH', 'MAHARSAHTRA', 'MANIPUR', 'MEGHAYLYA', 'MIZORAM', 'NAGALAND', 'ODISHA', 'PUDUCHEERY', 'PUNJAB', 'RAJASTHAN', 'SIKIM', 'TAMILNADU', 'TELANGANA', 'TRIPURA', 'UTTARPARDESH', 'UTTARAKHAND', 'WESTBENGAL');
    return $states;
}
/* Get the record from db by any key value pair */
function getNameById($table = '', $id = '', $field = '') {
    $qry = "select * from $table where $field='$id'";
    $CI = & get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', true);
    $qryy = $dynamicdb->query($qry);
	//echo  $dynamicdb->last_query();//die;
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

function getCommentById($table = '', $id = '', $field = '') {
    $qry = "select * from $table where $field='$id' order by id desc";
    $CI = & get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', true);
    $qryy = $dynamicdb->query($qry);
    //echo  $dynamicdb->last_query();die;
    $result = $qryy->result();
    return $result;
}

/* Get the record from db by any key value pair */
function getPaymentByCompanyId($table = '', $id = '', $field = '') {
    $qry = "select * from $table where $field='$id'";
    $CI = & get_instance();
    #$dynamicdb = $CI->load->database('dynamicdb', TRUE);
    $qryy = $CI->db->query($qry);
    #echo $CI->db->last_query();
    $result = $qryy->row();
    return $result;
}
function getActivityLogGraphData($userId) {
    $qry = "SELECT  AAA.date_field , COUNT(IF(al.userid=" . $userId . ",1, NULL)) 'userId' 
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
			) AAA LEFT JOIN activity_log as al on AAA.date_field = DATE_FORMAT(al.date, '%Y/%m/%d') 
			Group BY date_field";
    $CI = & get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', true);
    $qryy = $dynamicdb->query($qry);
    $result = $qryy->result_array();
    return $result;
}
function export_csv_excel($data3 = array()) {
    if (!empty($_GET['ExportType'])) {
        ob_end_clean();
        switch ($_GET["ExportType"]) {
            case "export-to-excel":
                // Submission from
                $filename = $_GET["ExportType"] . ".xls";
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                ExportFile($data3);
                //$_POST["ExportType"] = '';
                exit();
            case "export-to-csv":
                // Submission from
                $filename = $_GET["ExportType"] . ".csv";
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Content-type: text/csv");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                header("Expires: 0");
                ExportCSVFile($data3);
                //$_POST["ExportType"] = '';
                exit();
            case "export-to-blank-excel":
                // Submission from
                $filename = $_GET["ExportType"] . ".xls";
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                ExportFile_blank($data3);
                //$_POST["ExportType"] = '';
                exit();
            default:
                die("Unknown action : " . $_GET["action"]);
            break;
        }
    }
}
function ExportFile($records) {
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
function ExportFile_blank($records) {
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
function filter_array($array, $worker_id) {
    $matches = array();
    foreach ($array as $a) {
        $workercount = !empty($a->worker_id) ? (count($a->worker_id)) : 0;
        for ($i = 0;$i < $workercount;$i++) {
            if (isset($a->worker_id[$i])) {
                if (in_array($worker_id, $a->worker_id[$i])) $matches[] = $a;
            }
        }
    }
    return $matches;
}
function filter_array1($array = ARRAY(), $worker_id) {
    $matches = array();
    //PRE($ARRAY);
    foreach ($array as $a) {
        $workercount = !empty($a->worker_id) ? (count($a->worker_id)) : 0;
        for ($i = 0;$i < $workercount;$i++) {
            if (isset($a->worker_id[$i])) {
                if (in_array($worker_id, $a->worker_id[$i])) $matches[] = $a;
            }
        }
    }
    return $matches;
}
/****************************************************/
// Function Name: percentageOfOutput
// Function Details :Calculate percetage between the production_data and planned_data
// Created: Aman Phull
/****************************************************/
function percentageOfOutput($production_data, $production_planning, $worker_id, $decimals = 2) {
    $TargetOutputsum = 0;
    $ActualOutputsum = 0;
    //pre( $production_planning);
    $production_array = filter_array1($production_data, $worker_id);
    if (!empty($production_array)) {
        $k = 0;
        foreach ($production_array as $pwd) {
            $output = !empty($pwd->output) ? (count($pwd->output)) : 0;
            for ($i = 0;$i < $output;$i++) {
                if (isset($pwd->output)) {
                    $ActualOutputsum+= is_numeric($pwd->output[$i]) ? $pwd->output[$i] : 0;
                    $TargetOutputsum+= isset($production_planning) ? (is_numeric($production_planning[$k]->output[$i]) ? $production_planning[$k]->output[$i] : 0) : 0;
                }
            }
            $k++;
        }
    }
    $percentage = 0;
    // $percentage = ($ActualOutputsum / $TargetOutputsum) * 100; 
    if ($TargetOutputsum == 0) {
        $percentage = $ActualOutputsum;
    } elseif ($ActualOutputsum < $TargetOutputsum) {
        $percentage = (($TargetOutputsum - $ActualOutputsum) / $TargetOutputsum) * 100;
    } else {
        $percentage = ($ActualOutputsum / $TargetOutputsum) * 100;
    }
    return round($percentage);
}



// calculate emp Absent or present
function getAttendanceById_Date($table = '', $id = '', $field = '',$idTwo ='', $fieldTwo='',$c_id){
    $qry = "select * from $table where $field='$id' and $fieldTwo='$idTwo' and created_by_cid = '$c_id';    ";
    

    $CI = & get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', true);
    $qryy = $dynamicdb->query($qry);
 //  echo  $dynamicdb->last_query();die;
    $result = $qryy->row();
    return $result;
}
function getCommonAttendanceById_Date($table = '', $id = '', $field = '',$idTwo ='', $fieldTwo=''){
    $qry = "select * from $table where $field='$id' and $fieldTwo='$idTwo'   ";
    

    $CI = & get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', true);
    $qryy = $dynamicdb->query($qry);
 //  echo  $dynamicdb->last_query();die;
    $result = $qryy->result();
    return $result;
}
 function getAttendanceById_twoDate($table = '', $id = '', $start_date = '',$end_date = '',$c_id ){
    $qry = "select status,emp_id,atten_date  from $table where  $id  >= '$start_date' and $id <= '$end_date' and created_by_cid = '$c_id';     ";
    
     
    $CI = & get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', true);
    $qryy = $dynamicdb->query($qry);
     # echo  $dynamicdb->last_query();die;
    $result = $qryy->result();
    return $result;
}

 
function getEmpLeave( $table ='',$id = '', $current_Date = ''){
    $qry = "select * from emp_leave where em_id='$id' and '$current_Date' >= start_date and '$current_Date' <= end_date;  ";
    $CI = & get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', true);
    $qryy = $dynamicdb->query($qry);
   // echo  $dynamicdb->last_query();die;
    $result = $qryy->row();
    return $result;
}
 
function getEmpHoliday( $table ='', $current_Date = ''){
    $qry = "select * from emp_leave where '$current_Date' >= start_date and '$current_Date' <= end_date;  ";
    $CI = & get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', true);
    $qryy = $dynamicdb->query($qry);
   // echo  $dynamicdb->last_query();die;
    $result = $qryy->result();
    return $result;
}
/*   valiadation during insertion of attendance  */
 
function getEmpHoliday_check(  $current_Date = '',$c_id){
    $qry = "select * from holiday  where   from_date  <= '$current_Date' and   to_date >=  '$current_Date'   and created_by_cid = '$c_id'  ";
    $CI = & get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', true);
    $qryy = $dynamicdb->query($qry);
   #echo  $dynamicdb->last_query();die;
    $result = $qryy->num_rows();
    return $result;
}

 function getEmpLeave_check( $table ='',$id = '', $current_Date = '', $c_id){
    $qry = "select * from emp_leave where em_id='$id' and   start_date  <= '$current_Date' and   end_date>=  '$current_Date'   and leave_status = 'Approve'  and created_by_cid = '$c_id'  ;  ";
   
    $CI = & get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', true);
    $qryy = $dynamicdb->query($qry);
   // echo  $dynamicdb->last_query();die;
    $result = $qryy->num_rows();
    return $result;
} 

function getEmpWeekoff_check($day_to,$c_id){
   
#pre($day_to);die;
    $qry = "select day from employee_weekoff where day= '$day_to' and created_by_cid = '$c_id'  ;  ";
    $CI = & get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', true);
    $qryy = $dynamicdb->query($qry);
     # echo  $dynamicdb->last_query();die;
    $result = $qryy->num_rows();
    return $result;
} 

function global_variable_hrm(){
   
    $result = array(
     'start_date' =>'2021-01-01' ,  
     'end_date' =>'2021-12-31' ,  
        ); 
    return $result;
} 


 /* valiadation during insertion of attendance  ends */

 function getSingleAndWhere($select,$table,$where){
    $ci =& get_instance();
    $dynamicdb = $ci->load->database('dynamicdb', TRUE);
    $data = $dynamicdb->select($select)
            ->where($where)->get($table)->row_array();
    return $data[$select];
}
 

    function checkPurchaseApprove(){
            $checkPOapproveStatus = getNameById('company_detail',companyGroupId(),'id');
            if( $checkPOapproveStatus->hrm_worker_data ){
                    if( $checkPOapproveStatus->hrm_multi_lever_approve > 0 && !empty($checkPOapproveStatus->hrm_multi_lever_approve)  ){
                            $approveUsers = json_decode($checkPOapproveStatus->hrm_approve_users,true);
                            if( count($approveUsers) > 0 ){
                                return true;
                            }
                    }
            }
            return false;
    }
    function companyGroupId(){
        return (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id;
    }
?>
