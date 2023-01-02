<?php

class User_model extends ERP_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($user_id)
    {
		//echo $user_id;
		$company_id = $this->session->userdata('company_id');
        $this->db->select();
        $this->db->from('user_detail as user_detail');
        $this->db->where('user_detail.u_id != ', $user_id);
        $this->db->where('user_detail.u_id != 0');
        $this->db->where('user_detail.c_id = ',$company_id);
      //  $this->db->get();
		// echo $this->db->last_query();die('asdf');
        return $this->db->get();
    }

    public function getOne($id)
    {
        $this->db->where('u_id', $id);
        return $this->db->get('user_detail');
    }

    public function logged($user_id)
    {
        $this->db->where('id', $user_id);
        $this->db->update('user_detail', ['is_logged_in' => 1, 'last_login' => date('Y-m-d')]);

        return 1;
    }
}