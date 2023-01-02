<?php 
class Group_model extends CI_Model{
    public function __construct()    {
        parent::__construct();
    }

    public function all(){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('group.*, chats.*');
        $dynamicdb->from('groups_chats as group, chats as chats');
        $dynamicdb->where('group.chat_id = chats.id');
        return $dynamicdb->get();
    }

    public function check($user_id, $chat_id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
        $check = $dynamicdb->get_where('groups_members', ['chat_id' => $chat_id, 'user_id' => $user_id]);
        if ($check->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}