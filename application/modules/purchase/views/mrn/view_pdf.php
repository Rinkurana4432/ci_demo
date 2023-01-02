<?php   

    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $obj_pdf->SetCreator(PDF_CREATOR);  
    $obj_pdf->SetTitle("Reorder Level Report");  
    $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $obj_pdf->SetDefaultMonospacedFont('helvetica');  
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $obj_pdf->setPrintHeader(false);  
    $obj_pdf->setPrintFooter(false);  
    $obj_pdf->SetAutoPageBreak(TRUE);  
    $obj_pdf->SetFont('helvetica', '', 11);
	$company_data = getNameById('company_detail',$dataPdf->created_by_cid,'id');
	 
	#$bank_info = json_decode($company_data->bank_details);
   # $primarybnk  = $bank_info[0];
	$image = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	$obj_pdf->Image($image,2,4,10,10,'PNG');
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
    $obj_pdf->AddPage(); 	
    $content = ''; 
    $products =  json_decode($dataPdf->mrp_data);
    $getUnitName = getNameById('company_address',$dataPdf->created_by_cid,'created_by_cid');
    $compnm = !empty($getUnitName)?$getUnitName->company_unit:'';
     
    $createdby = ($dataPdf->created_by!=0)?(getNameById('user_detail',$dataPdf->created_by,'u_id')->name):'';
#!empty($primaryContact)?$primaryContact->phone_no:''
  
$products= json_decode($dataPdf->material_name);
    $content.='';
               
	$content .= '
	<table>
		<tr>
			<td align="center"><img src="'.$image.'" alt="test alt attribute" width="60" height="50" border="0" ></td></tr>
			<tr>
			<td colspan="8"><div style="margin-top: 20%;"><h2 align="center">Material Defected Report</h2></div></td>
		</tr>
	</table>
	<table border="1" cellpadding="2">
		<tr>
			<td colspan="4"><strong>Company Name.</strong> &nbsp; '.$compnm.'</td>
			<td colspan="4"><strong>Report Month.</strong> &nbsp; '.date("F, Y", strtotime($dataPdf->month)).'</td>
		</tr>		
		<tr>
            <td>S No.</td>
            <td>Material Type</td>
			<td>Alias</td>
            <td>Material Name</td>
            <td>Qut</td>
            <td>Prece</td>
			<td>Last purchase Price</td>
            <td>Recived Qut</td>
            <td>Invoice Qut</td>	
            <td>Reason</td>
		</tr>';
		$i = 0;
		foreach($products as $product){
			if($product->defected==1){
               
				$i++;
				       $ww=getNameById('material_type',$product->material_type_id,'id');
			 		$ee = getNameById('material',$product->material_name_id,'id');
			 		 $mat_name = !empty($ee)?$ee->material_name:'';
                     $uom = getNameById('uom',$product->uom_selected_id,'id');
                     $uom_name = !empty($uom)?$uom:'';											
			$content .= '<tr>
				<td>'.$i.'</td>
				<td>'.$mat_name.'</td>
				<td>'N/A'</td>
				<td>'.$ww->name.'</td>
				<td>'.$uom->uom_quantity.'</td>
				<td>'.$product->quantity.'</td> 
				<td>'N/A'</td> 
				<td>'.$product->received_quantity.'</td>
				<td>'.$product->invoice_quantity.'</td>
				<td>'.$product->description.' </td>
			</tr>';
			}}  		
 	  $content .= '</table>';  
    // die;
	$obj_pdf->writeHTML($content);  
	ob_end_clean();
	$obj_pdf->Output('defected.pdf', 'I');  
 ?>  
