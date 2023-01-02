<?php 
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

function getLastIdIncerment($table){
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$CI->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	$sql = "SELECT (id + 1) as id FROM {$table} WHERE created_by_cid = {$CI->companyGroupId} ORDER BY id DESC limit 1";
	$data = $dynamicdb->query($sql)->row_array();
	return $data['id'];
}

?>