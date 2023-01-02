<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sendsms extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public	function index(){
			$this->load->library('twilio');	
			$from = '+19037040199';
			$to = '+918130802532';
			$message = 'This is a test...';
			$response = $this->twilio->sms($from, $to, $message);
			if($response->IsError)
				echo 'Error: ' . $response->ErrorMessage;
			else
				echo 'Sent message to ' . $to;
	}
}
/* End of file twilio_demo.php */