<?php 	
/**
 Get Department data for Datatable Listing
*/
function user_tbl_data(){
	$can_edit = true ; //edit_permissions();
	$can_delete = true ; //delete_permissions();	
	$where  =  array();
	$join  =  array();
	$filter =  array();		
	$aColumns = array('user.id as id',
					  'user.firstname as name',	
					  'user.user_profile as user_profile',	
					  'company.email as email',	
					  'user.designation as designation',	
					  'user.age as age',	
					  'user.contact_no as contact_no',	
					  'user.experience as experience',	
					  'user.date_joining as date_joining',	
					);			

	$join = array('LEFT JOIN company on company.id = user.company_id',				
			);					
	$result = data_tables_init($aColumns , 'id', 'user', $join, $where, array());	
	$output  = $result['output'];
	$rResult = $result['rResult'];
	if(!empty($rResult)){
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
			if($can_edit){
				$options .=  '<a href="javascript:void(0)" id="'. $aRow['id'] . '" data-id="'.$aRow['id'].'" class="add_departments btn btn-primary" id="' . $aRow['id'] . '"><i class="fa fa-pencil"></i></a>';
			}
			if($can_delete) {
				$options .=  '<a href="javascript:void(0)" class="delete_listing_without btn btn-danger" data-href="'.base_url().'departments/delete/' .$aRow['id']. '"><i class="fa fa-trash"></i></a>';  
			}		 
			$row['action'] = $options;	 
			$hook =  array(
				'output' => $row,
				'row' => $aRow
			);
			$row = $hook['output'];
			$options = '';
			$output['data'][] = $row;	
		}
	}
		return $output;
}

function getStates(){
		$states = array('Andhra Pradesh','Arunachal Pardesh','Assam','Bihar','CHANDIAGRH','CHATTISGARH','DADRA & NAGAR HAVELI','DAMAN AND DIU','DELHI','GOA','GUJARAT','HARAYANA','HIMACHAL PARDESH','JAMMU & KASHMIR','JHARKHAND','KARANATAKA','KERALA','LAKSHDWEEP','MADHYA PARDESH','MAHARSAHTRA','MANIPUR','MEGHAYLYA','MIZORAM','NAGALAND','ODISHA','PUDUCHEERY','PUNJAB','RAJASTHAN','SIKIM','TAMILNADU','TELANGANA','TRIPURA','UTTARPARDESH','UTTARAKHAND','WESTBENGAL');
		return $states;
}

/* Get the record from db by any key value pair */
function getNameById($table='',$id='',$field=''){
		$qry="select * from $table where $field='$id'";
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);	
		$result = $qryy->row();	
		return $result;	
}
	
	
	
		/* Get the record from db by any key value pair */
function getPaymentByCompanyId($table='',$id='',$field=''){
		$qry="select * from $table where $field='$id'";
		$CI =& get_instance();
		#$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $CI->db->query($qry);	
		#echo $CI->db->last_query();
		$result = $qryy->row();	
		
		return $result;	
	}
	
function getActivityLogGraphData($userId){
	$qry = "SELECT  AAA.date_field , COUNT(IF(al.userid=".$userId.",1, NULL)) 'userId' 
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
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);	
			$result = $qryy->result_array();	
			return $result;		

}



	?>