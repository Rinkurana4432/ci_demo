<?php

/*
Generate PDF file
*/
function generate_pdf($id, $item_rel_type, $type, $result = array()){	
	$CI =& get_instance();
	$module_nm = $CI->router->fetch_class();
	$logoimg = (isset($CI->settings['logo']))?$CI->settings['logo']:'';
	
	$items_data = get_data_byTbl("items_in",array("items_in.rel_id" => $id, "items_in.rel_type" => $item_rel_type));	
	
	$font_size = 'sans-serif';
	$CI->load->library('Pdf');
		$pdf=new Pdf();
		$pdf->AddPage();
	
	if($type == 'print') {
		$js = 'print(true);';
        $pdf->IncludeJS($js);
	}
	
	include(APPPATH . '/modules/' . $module_nm . '/views/pdf.php');
	$pdf->Output();	
	die;	
}

/*Function to fetch Data*/
	function get_data_byTbl($tbl_nm , $where = array()) {
		$CI =& get_instance();
		$CI->db->select('*');    
		$CI->db->from($tbl_nm);
		if($tbl_nm == 'items_in') {
			$CI->db->join("itemstax","items_in.id = itemstax.itemid","left");				
		}
		$CI->db->where($where);	
		$qry = $CI->db->get();			
		$result = $qry->result_array();	
		return $result;
	}


function payments_pdf($id, $type){	
	$CI =& get_instance();
	$CI->load->model('modules/payments_model');
	$payments = $CI->payments_model->get_data_byId($id);
	//$invoice = $CI->payments_model->get_invoice_list_data($id);	
	$font_size = 'sans-serif';
	$CI->load->library('Pdf');
		$pdf=new Pdf();
		$pdf->AddPage();
	
	if($type == 'print') {
		$js = 'print(true);';
        $pdf->IncludeJS($js);
	}
	
	include(APPPATH . 'views/payments/paymentspdf.php');
	$pdf->Output();	
	die;	
}

?>