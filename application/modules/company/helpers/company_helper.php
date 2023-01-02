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

/*-----------------   Function to get the records from table by a key value match  --------------------*/
function getNameById($table='',$id='',$field=''){
	if($table == 'company_address' ){
		$companyId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		// echo "select * from $table where $field='$id' and created_by_cid='$companyId'";die();
		$qry = "select * from $table where $field='$id' and created_by_cid='$companyId'";
	}else{
		$qry = "select * from $table where $field='$id'";
	}
		//$qry="select * from $table where $field='$id'";
		$CI =& get_instance();		
		$qryy = $CI->db->query($qry);	
		$result = $qryy->row();	
		return $result;	
	}

	/*-----------------   Function to Search the company on typing in company module   --------------------*/
function searchCompanyList($companyName = ''){
	$loggedInCompanyId =  	isset($_SESSION)?$_SESSION['loggedInUser']->c_id:0;
	$qry="select * from company_detail where name like('%$companyName%') and id != $loggedInCompanyId";
	$CI =& get_instance();
	$qryy = $CI->db->query($qry);	
	$result = $qryy->result_array();	
	return $result;	
}

/*-----------------   Function to fetch connected companies list  --------------------*/
function connectedCompany($id= '',$editPage =''){
	
	//$loggedInCompanyId =  	$_SESSION['loggedInUser']->c_id;
	//$qry="select cd.*,u.email from company_detail  as cd inner join connection on (connection.requested_to = cd.id or connection.requested_by = cd.id) inner join user as u on (cd.u_id = u.id ) where cd.id != $loggedInCompanyId and  connection.status = 1";
	
	$qry="select cd.*,u.email from company_detail  as cd inner join connection as conn on (conn.requested_to = cd.id or conn.requested_by = cd.id) inner join user as u on (cd.u_id = u.id ) where (conn.requested_to = $id OR conn.requested_by = $id) and conn.status = 1";

	$CI =& get_instance();
	$qryy = $CI->db->query($qry);	
	$result = $qryy->result_array();
	$result =  array_map("unserialize", array_unique(array_map("serialize", $result)));		
	$filterBy = $id; // or Finance etc.
	$connectedCompanyArray = array_filter($result, function ($var) use ($filterBy) {
		return ($var['id'] != $filterBy);
	});
	//return $result;	
	#pre($connectedCompanyArray);
	#die;
	return $connectedCompanyArray;	
}




function companyConnectionData($id= '',$cid = ''){
	//$loggedInCompanyId =  	$_SESSION['loggedInUser']->c_id;
	//$qry="select cd.*,u.email from company_detail  as cd inner join connection on (connection.requested_to = cd.id or connection.requested_by = cd.id) inner join user as u on (cd.u_id = u.id ) where cd.id != $loggedInCompanyId and  connection.status = 1";
	#$qry="select cd.*,u.email from company_detail  as cd inner join connection on (connection.requested_to = cd.id or connection.requested_by = cd.id) inner join user as u on (cd.u_id = u.id ) where cd.id != $id and  connection.status = 1";
	$qry="select cd.*,u.email,conn.status from company_detail  as cd inner join connection as conn on (conn.requested_to = cd.id or conn.requested_by = cd.id) inner join user as u on (cd.u_id = u.id ) where (conn.requested_to = $id AND conn.requested_by = $cid) OR (conn.requested_by = $id AND conn.requested_to = $cid)";
	$CI =& get_instance();
	$qryy = $CI->db->query($qry);	
	$result = $qryy->result_array();
	$result =  array_map("unserialize", array_unique(array_map("serialize", $result)));		
	$filterBy = $id; // or Finance etc.
	$connectedCompanyArray = array_filter($result, function ($var) use ($filterBy) {
		return ($var['id'] != $filterBy);
	});
	//return $result;	
	#pre($connectedCompanyArray);
	#die;
	return $connectedCompanyArray;	
}




/*
function nonConnectedCompany($connectedIds = ''){
	$loggedInCompanyId =  	$_SESSION['loggedInUser']->c_id;
	$qry="select cd.*,u.email from company_detail as cd inner join user as u on (cd.u_id = u.id ) where cd.id != $loggedInCompanyId and cd.id NOT IN ($connectedIds)";
	//echo $qry; die;
	$CI =& get_instance();
	$qryy = $CI->db->query($qry);	
	$result = $qryy->result_array();
	return $result;	
}*/

/*-----------------   Function to fetch non connected companies   --------------------*/
function nonConnectedCompany($connectedIds = ''){
	if($connectedIds != ''){
		$loggedInCompanyId =  	$_SESSION['loggedInUser']->c_id;
		#pre($loggedInCompanyId);
		$qry="select cd.*,u.email from company_detail as cd inner join user as u on (cd.u_id = u.id ) where cd.id != $loggedInCompanyId and cd.id NOT IN ($connectedIds)";	
		$CI =& get_instance();
		$qryy = $CI->db->query($qry);	
		$result = $qryy->result_array();
		#pre($result); die;
		$nonConnectedCompanyId = '';
		foreach($result as $nonConnectedComp){
			$nonConnectedCompanyId .= $nonConnectedComp['id'].',';					
		}	
		$nonConnectedCompanyId = rtrim($nonConnectedCompanyId,',');
		#$query = "SELECT * FROM inter_comm_uri_segments AS uri WHERE (first in($nonConnectedCompanyId) AND second = 2 ) OR (second in($nonConnectedCompanyId) AND first = 2 ) ORDER BY uri.id DESC";	
		#$query = "SELECT * FROM inter_comm_uri_segments AS uri WHERE (first in($nonConnectedCompanyId) AND second = $loggedInCompanyId ) OR (second in($nonConnectedCompanyId) AND first = $loggedInCompanyId ) ORDER BY uri.id DESC";	
		$query = "SELECT * FROM inter_comm_uri_segments AS uri inner join inter_comm_chats_messages as iccm on uri.chat_id = iccm.chat_id WHERE ((first in($nonConnectedCompanyId) AND second = $loggedInCompanyId ) OR (second in($nonConnectedCompanyId) AND first = $loggedInCompanyId )) ORDER BY uri.id DESC";	
		
		
		$qryyNonConnectedChatSegment  =  $CI->db->query($query);	
		$qryyNonConnectedChatSegmentResult = $qryyNonConnectedChatSegment->result_array();
		#pre($qryyNonConnectedChatSegmentResult); die;
		$nonConnectedCompanyId  = array();
		if(!empty($qryyNonConnectedChatSegmentResult)){
			foreach($qryyNonConnectedChatSegmentResult as $nccs){
				$nonConnectedCompanyId[] = $nccs['first'];
				$nonConnectedCompanyId[] = $nccs['second'];
			}
		}
		if(!empty($nonConnectedCompanyId)){
			$nonConnectedCompanyIdArray = array_unique($nonConnectedCompanyId);		
			$nonConnectedCompanyIds = array_diff( $nonConnectedCompanyIdArray, [$loggedInCompanyId] ) ;
			$nonConnectedCompanyIds = implode(",",$nonConnectedCompanyIds);
			$nonConnectedQry = "select cd.*,u.email from company_detail as cd inner join user as u on (cd.u_id = u.id ) where cd.id IN($nonConnectedCompanyIds)";
			$nonConnectedRes =  $CI->db->query($nonConnectedQry);	
			$nonConnectedResResult = $nonConnectedRes->result_array();
			#pre($nonConnectedResResult); die;
			return $nonConnectedResResult;	
		}else{
			return false;
		}
	}else{
			return false;
		}
}

/* Fetch Star Rating counts of products on the bases of Starts */
function getStarRatingCount($table='',$id='',$field=''){
	$qry="SELECT COUNT(IF(reviews.rating=5,1, NULL)) AS fivestar, COUNT(IF(reviews.rating=4,1, NULL)) AS fourstar, COUNT(IF(reviews.rating=3,1, NULL)) AS threestar, COUNT(IF(reviews.rating=2,1, NULL)) AS twostar, COUNT(IF(reviews.rating=1,1, NULL)) AS onestar , ROUND(AVG(reviews.rating),1) as average FROM $table WHERE $field='$id'";	
	$CI =& get_instance();
	$qryy = $CI->db->query($qry);
	$result = $qryy->result_array();
	return $result;	
}


/**
 * List files in a specific folder
 * @param  string $dir directory to list files
 * @return array
 */
function list_files($dir){
    $ignored = array(
        '.',
        '..',
        '.svn',
        '.htaccess',
        'index.html',
    );
    $files   = array();	
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) {	
            continue;
        }	
		if($_SESSION['loggedInUser']->company_db_name !=''){			
			$comapnyDbName = $_SESSION['loggedInUser']->company_db_name;
			if(startsWith($file,$comapnyDbName)) {
					$files[$file] = filectime($dir . '/' . $file);
			}
		}
    }
    arsort($files);
    $files = array_keys($files);
    return ($files) ? $files : array();
}


// Function to check string starting 
// with given substring 
function startsWith ($string, $startString){ 
    $len = strlen($startString); 
    return (substr($string, 0, $len) === $startString); 
} 





/**
 * Convert bytes of files to readable seize
 * @param  string $path file path
 * @param  string $filesize file path
 * @return mixed
 */
function bytesToSize($path, $filesize = ''){
    if (!is_numeric($filesize)) {
        $bytes = sprintf('%u', filesize($path));
    } else {
        $bytes = $filesize;
    }
    if ($bytes > 0) {
        $unit  = intval(log($bytes, 1024));
        $units = array(
            'B',
            'KB',
            'MB',
            'GB',
        );
        if (array_key_exists($unit, $units) === true) {
            return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
        }
    }
    return $bytes;
}


function get_product_saleType($table = '', $createdByCid= ''){
	$likeSalePur = '["Sale","Purchase"]';
	$likeSale = '["Sale"]';
	$qry="select * from $table where created_by_cid = $createdByCid AND status=1 and (sale_purchase = '$likeSalePur' or sale_purchase = '$likeSale')";	
	$CI =& get_instance();
	$qryy = $CI->db->query($qry);	
	$result = $qryy->result_array();
	return $result;
}


function get_location_settings_dtl($table='',$id='',$field=''){
	 	$qry="select * from $table where $field='$id'";
		$CI =& get_instance();		
		$qryy = $CI->db->query($qry);
			// echo 	$CI->db->last_query();die();	
		$result = $qryy->result_array();	
		return $result;	
	}
	?>