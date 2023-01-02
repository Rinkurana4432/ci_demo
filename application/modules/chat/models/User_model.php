<?php

class User_model extends ERP_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($user_id){		
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		//echo $user_id;
		$company_id = $this->session->userdata('company_id');
        $dynamicdb->select();
        $dynamicdb->from('user_detail as user_detail');
        $dynamicdb->where('user_detail.u_id != ', $user_id);
        $dynamicdb->where('user_detail.u_id != 0');
        $dynamicdb->where('user_detail.c_id = ',$company_id);
      //  $this->db->get();
		// echo $this->db->last_query();die('asdf');
        return $dynamicdb->get();
    }

    public function getOne($id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('u_id', $id);
        return $dynamicdb->get('user_detail');
    }

    public function logged($user_id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $user_id);
        $dynamicdb->update('user_detail', ['is_logged_in' => 1, 'last_login' => date('Y-m-d')]);

        return 1;
    }
}