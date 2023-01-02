<?php
/**
 * Format invoice status
 * Save the entries in payments after payment with paypal 
 * @return boolean
 */
function success($postData){
	$CI =& get_instance();
	$CI->load->model('modules/viewinvoice_model');	
	$data['invoiceid'] = $postData['item_number'];
	$data['transactionid'] = $postData['txn_id'];
	$data['paymentmode'] = $postData['custom'];
	$data['paymentmethod'] = $postData['payment_type'];
	$data['amount'] = $postData['mc_gross'];
	$data['daterecorded'] = $postData['payment_date'];
	if (array_key_exists("item_name",$postData)){
		$data['note'] = $postData['item_name'];
	}
	$data['date'] = $postData['payment_date'];
	$data['payment_status'] = $postData['payment_status'];
	$paymentid = $CI->viewinvoice_model->insert_tbl_data('invoicepaymentrecords',$data);
	if($paymentid){
		$value=array('status'=>2 , 'paidamount' => $data['amount']);
		$CI->db->where('id',$data['invoiceid']);
		$invoiceid = $CI->db->update('invoices',$value);
	}		
	return true;
}

/* Payment cancel  */
function cancel($postData){
	$CI =& get_instance();
	$CI->load->model('modules/viewinvoice_model');	
	$data['invoiceid'] = $postData['item_number'];
	$data['transactionid'] = $postData['txn_id'];
	$data['paymentmode'] = 21;
	$data['paymentmethod'] = $postData['payment_type'];
	$data['amount'] = $postData['mc_gross'];
	$data['daterecorded'] = $postData['payment_date'];
	if (array_key_exists("item_name",$postData)){
		$data['note'] = $postData['item_name'];
	}
	$data['date'] = $postData['payment_date'];
	$data['payment_status'] = $postData['payment_status'];
	$paymentid = $CI->viewinvoice_model->insert_tbl_data('invoicepaymentrecords',$data);
	if($paymentid){
		$value=array('status'=>5);
		$CI->db->where('id',$data['invoiceid']);
		$invoiceid = $CI->db->update('invoices',$value);
	}	
	return true;
}

function ipn(){
	
}
?>