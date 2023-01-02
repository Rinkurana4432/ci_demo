<?php
/*
Database global functions
*/

/* Modules Listing */
function modules_listing() {
	$CI = &get_instance();
    $CI->db->select('*');    
	$CI->db->from('modules');	
	$qry = $CI->db->get();			
	$result = $qry->result_array();	
	return $result;
}

/* User Groups Listing */
function Group_listing() {
	$CI = &get_instance();
    $CI->db->select('*');    
	$CI->db->from('groups');	
	$CI->db->where('name != "contacts"');	
	$qry = $CI->db->get();			
	$result = $qry->result_array();	
	return $result;
}

/* User Groups */
function current_user_group() {
	$uid = get_staff_user_id();
	$CI = &get_instance();
    $user_groups = $CI->ion_auth->get_users_groups($uid)->row();
	$group = (!empty($user_groups))?$user_groups->id:0;
	return $group;
}



/* Add Tracking */
function add_views_tracking($rel_type, $rel_id)
{
	$CI = &get_instance();
    $CI->db->insert('viewstracking', array(
    'rel_id' => $rel_id,
    'rel_type' => $rel_type,
    'date' => date('Y-m-d H:i:s'),
    'view_ip' => $CI->input->ip_address(),
    ));
	return true;
}

/* Get Tracking by Relation Type and ID */
function get_views_tracking($rel_type, $rel_id)
{
    $CI =& get_instance();
    $CI->db->where('rel_id', $rel_id);
    $CI->db->where('rel_type', $rel_type);
    $CI->db->order_by('date', 'DESC');

    return $CI->db->get('viewstracking')->result_array();
}

/**
 * Check if field is used in table
 * @param  string  $field column
 * @param  string  $table table name to check
 * @param  integer  $id   ID used
 * @return boolean
 */
function is_reference_in_table($field, $table, $id){
    $CI =& get_instance();
    $CI->db->where($field, $id);
    $row = $CI->db->get($table)->row();
    if ($row) {
        return true;
    }
    return false;
}

/*  Activity log Insertion */
function logActivity($description = '', $rel_type = '', $rel_id = null){
    $CI =& get_instance();
	$userId = (!empty($_SESSION) && !empty($_SESSION['loggedInUser']))? $_SESSION['loggedInUser']->id:'';
    $log = array(
        'description' => $description,
        'date' => date('Y-m-d H:i:s'),
        //'userid' => (!empty($_SESSION) && !empty($_SESSION['loggedInUser']))? $_SESSION['loggedInUser']->id, //get_staff_user_id(),
        'userid' => $userId,
        'rel_id' => $rel_id,
        'rel_type' => $rel_type,
        ); 
    $CI->db->insert('activity_log', $log);
}

/* Save User Notifications */
function save_notifications($fromid = 0, $toid = 0, $msg = '', $url = ''){
	$CI =& get_instance();
    $data = array(
        'fromid' => $fromid,
        'toid' => $toid,
        'isread' => 0,
        'msg' => $msg,
        'url' => $url,
        'date' => date('Y-m-d H:i:s') 
        ); 
    $CI->db->insert('notifications', $data);
}

/* Get User Notifications */
function get_notifications($limit = 0, $start = 0){
	$CI =& get_instance();   
	$user_id = $CI->session->userdata('user_id');
    $CI->db->where("toid", $user_id);
	$CI->db->order_by("id", "desc");
    $CI->db->limit($limit, $start);    
    $row = $CI->db->get('notifications')->result_array();	
	return $row;
}

/* Get User Notifications */
function get_userinformation($uid){
	$CI =& get_instance();   
    $CI->db->where("id", $uid);
    $row = $CI->db->get('users')->row();	
	return $row;
}

/* Get User Notifications */
function readNotifications(){
	$CI =& get_instance();   
	$user_id = $CI->session->userdata('user_id');
    $CI->db->where('toid', $user_id);
	$data = array('isread' => 1);  
	$CI->db->update('notifications', $data );		
	return true;
}

/* Get User task */
function user_tasks(){
	$CI =& get_instance();
	$user_id = $CI->session->userdata('user_id');
    $CI->db->select("sa.*,st.name");
    $CI->db->from("stafftaskassignees sa");
    $CI->db->join("stafftasks st","sa.taskid = st.id","inner");
    $CI->db->where(array("staffid" => $user_id));
    $result = $CI->db->get()->result_array();
	return $result;
}

/* Save Timer Data */
function save_timer_data($taskid = 0, $timer_note = ''){
	$CI =& get_instance();
	$user_id = $CI->session->userdata('user_id');
	$time = time();
    $data = array(
        'task_id' => $taskid,
        'start_time' => $time,
        'staff_id' => $user_id,
        'note' => $timer_note
        ); 
    $CI->db->insert('taskstimers', $data);	
	return true;
}

/* Get User timers */
function task_timer(){
	$CI =& get_instance();
	$user_id = $CI->session->userdata('user_id');
    $CI->db->select("*");
    $CI->db->from("taskstimers");
    $CI->db->where(array("staff_id" => $user_id, "end_time" => null));
	$CI->db->order_by("id", "desc");
    $result = $CI->db->get()->row();
	return $result;
}

/* Stop Timer */
function stop_timer(){
	$CI =& get_instance();   
	$user_id = $CI->session->userdata('user_id');
    $CI->db->where(array('staff_id' => $user_id, 'end_time' => null));
	$data = array('end_time' => time());  
	$CI->db->update('taskstimers', $data );		
	return true;
}

/* check related tables  */
function relation_check($main_tbl_name, $id){
	$CI =& get_instance();
	$flag = true;
	switch ($main_tbl_name) {
    case "clients":	  
	    $tbl_array = array(
		                   'notes'     => array("rel_id "=>$id, "rel_type"=>"clients"),
		                   'invoices'  => array("clientid"=>$id),
		                   'proposals' => array("rel_id "=>$id, "rel_type"=>"clients"),
		                   'estimates' => array("clientid"=>$id),
		                   'projects'  => array("clientid"=>$id)		                   
		                  );
        foreach($tbl_array as $tblname => $wherecon){						  
           if(!get_data($tblname, $wherecon, $CI)){
			   $flag = false;
		     }
		   }
		 return $flag;		 
        break;
    case "stafftasks":
        $tbl_array = array(
		                   'stafftasks'=> array("rel_id !="=>0, "rel_type != "=>'','id'=>$id)		                   
		                  );
        foreach($tbl_array as $tblname => $wherecon){						  
           if(!get_data($tblname, $wherecon, $CI)){
			   $flag = false;
		     }
		   }
		 return $flag;
        break;
    case "tickets":
        $tbl_array = array(
		                   'stafftasks'=> array("rel_id"=>$id, "rel_type"=>'ticket')		                   
		                  );
        foreach($tbl_array as $tblname => $wherecon){						  
           if(!get_data($tblname, $wherecon, $CI)){
			   $flag = false;
		     }
		   }
		 return $flag;
        break;
    default:
        echo "Your favorite color is neither red, blue, nor green!";
    }	
}

/* get data fucntion */
function get_data($tal_name, $wherecon, $CI){	
    $CI->db->select("*");
    $CI->db->from("$tal_name");
    $CI->db->where($wherecon); 
    $result = $CI->db->get()->row();
	#echo '<pre>'; print_r($result); echo '</pre>';
	#echo $CI->db->last_query();
	return (!empty($result) ? false : true);	  
}

/* delete multiple rows */
function delete_rows($tbl, $del_id, $where_key){    
	$CI =& get_instance();
	$CI->db->where_in($where_key,$del_id);
	$CI->db->delete($tbl);
	#echo $CI->db->last_query();
	return $CI->db->affected_rows();
	
  }	
  
  function ComplogActivity($comp_id,$subject = '', $activity_type = '', $p_id = null){
    $CI =& get_instance();
    $userId = (!empty($_SESSION) && !empty($_SESSION['loggedInUser']))? $_SESSION['loggedInUser']->id:'';
    $log = array(
        'comp_id' => $comp_id,
        'subject' => $subject,
        'created_date' => date('Y-m-d H:i:s'),
        //'userid' => (!empty($_SESSION) && !empty($_SESSION['loggedInUser']))? $_SESSION['loggedInUser']->id, //get_staff_user_id(),
        'created_by' => $userId,
        'p_id' => $p_id,
        'activity_type' => $activity_type,
        ); 
    $CI->db->insert('company_act_log', $log);
    $dynamicdb = $CI->load->database('dynamicdb', TRUE);
    $dynamicdb->insert('company_act_log', $log);
    
}
?>