<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Visitings {
    
    public function log_activity() {
        
        $CI =& get_instance();
 
        $data = array();
        $data['section'] = $CI->router->class;
        $data['action'] = $CI->router->method;   
        $data['date'] = date("Y-m-d H:i:s");
        $data['uri'] = uri_string();
        
        $query = $CI->db->get('menus');
        $urls = array();
        foreach ($query->result() as $row)
        {
            $urls[] = $row->url;
        }
 
        // write it to the database
		if(!empty($_SESSION['loggedInUser'])){
		    $data['user_id'] = $_SESSION['loggedInUser']->u_id;   //$CI->session->userdata('user_id');
		    
		    if(in_array($data['uri'], $urls)){
    		    //Master db
    			$qryy = $CI->db->insert('visiting_log', $data);
    			
    			//Client db
    			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
    			$qryy = $dynamicdb->insert('visiting_log', $data);
		    }
		}
    }
    
}