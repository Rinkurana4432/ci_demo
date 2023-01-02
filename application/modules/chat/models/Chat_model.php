<?php

class Chat_model extends ERP_Model {
    /**
     * Chat_model Constructor
     * 
     * chats = ['id', 'topic', 'user_id', 'created_at']
     * chats_messages = ['id', 'chat_id', 'user_id', 'content', 'created_at']
     * created_at auto timestamp (currentdate)
     */
    public function __construct(){
        parent::__construct();
    }

    public function create($first_id, $second_id){
        $data['topic'] = $first_id . $second_id;		
        $chat = $this->db->insert('chats', $data);
		$data['id']	 = $this->db->insert_id();
        if ($chat) {
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->insert('chats', $data);
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Description
     * @param int $chat_id 
     * @param int $user_id 
     * @param text $content 
     * @return array
     */
    public function add_chat_message($chat_id, $user_id, $content) {
        $query = "INSERT INTO chats_messages (chat_id, user_id, content) VALUES (?, ?, ?)";		
        $result =  $this->db->query($query, array($chat_id, $user_id, $content));
		$insertedId = $this->db->insert_id();
		if($result){			
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$query = "INSERT INTO chats_messages (chat_id, user_id, content,id) VALUES (?, ?, ?,?)";		
			$dynamicdb->query($query, array($chat_id, $user_id, $content,$insertedId));
		}
		return $result;
    }

    public function get_chats_messages($chat_id, $last_chat_message_id = 0){
		//echo 'dddd';die();
        // $query = "SELECT
                    // cm.id,
                    // cm.user_id,
                    // cm.content,
                    // DATE_FORMAT(cm.created_at, '%D of %M %Y at %H:%i:%s') AS timestamp,
                    // cm.is_image,
                    // cm.is_doc,
                    // u.username,
                    // u.first_name,
                    // u.last_name
                // FROM
                    // chats_messages AS cm
                // JOIN
                    // users AS u
                // ON
                    // cm.user_id = u.id
                // WHERE 
                    // cm.chat_id = ?
                // AND 
                    // cm.id > ?
                // ORDER BY
                    // cm.id
                // ASC";
				
			$query = "SELECT
                    cm.id,
                    cm.user_id,
                    cm.content,
                    DATE_FORMAT(cm.created_at, '%D of %M %Y at %H:%i:%s') AS timestamp,
                    cm.is_image,
                    cm.is_doc,
                    u.name
                FROM
                    chats_messages AS cm
                JOIN
                    user_detail AS u
                ON
                    cm.user_id = u.u_id  
                WHERE 
                    cm.chat_id = ?
                AND 
                    cm.id > ?
                ORDER BY
                    cm.id
                ASC";
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
        $result = $dynamicdb->query($query, [$chat_id, $last_chat_message_id]);
		//echo $this->db->last_query();die();
        return $result;
    }

    public function getOne($id) {	
		$dynamicdb = $this->load->database('dynamicdb', TRUE);	
        return $dynamicdb->get_where('chats', ['id' => $id]);
    }

    public function get(){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('chats.*, user_detail.name');
        $dynamicdb->from('chats as chats, user_detail as user_detail');
        $dynamicdb->where('chats.user_id = user_detail.u_id'); 		
        return $dynamicdb->get();
    }

    public function obtain($topic){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
        return $dynamicdb->get_where('chats', ['topic' => $topic]);
    }

}
