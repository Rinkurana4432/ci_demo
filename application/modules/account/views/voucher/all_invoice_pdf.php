<?php   
$content = '';
foreach($dataPdfs as $dataPdf){
	
	pre($dataPdf);
	
}
	die();
    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $obj_pdf->SetCreator(PDF_CREATOR);  
    $obj_pdf->SetTitle("TAX INVOICE");  
    $obj_pdf->SetHeaderData('TAX INVOICE', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $obj_pdf->SetDefaultMonospacedFont('helvetica');  
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $obj_pdf->setPrintHeader(false);  
    $obj_pdf->setPrintFooter(false);  
    $obj_pdf->SetAutoPageBreak(TRUE, 15);
	$obj_pdf->SetTopMargin(20);	
    $obj_pdf->SetFont('helvetica', '', 10);	  
	$company_data=getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
	$user_data=getNameById('user_detail',$_SESSION['loggedInUser']->u_id,'id');
	//pre($user_data);die();
	$image = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	$obj_pdf->Image($image,2,4,10,10,'PNG');
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
    $obj_pdf->AddPage(); 
	//$content = '';

	$sale_ledger = getNameById('ledger',$dataPdf->sale_ledger,'id');
	$party_ledger = getNameById('ledger',$dataPdf->party_name,'id');
	 
  
	
	$newDate = date("d-m-Y", strtotime($dataPdf->created_date));
	$mailing_state = getNameById('state',$sale_ledger->mailing_state,'state_id');
	$party_ledger_purchaser = getNameById('state',$party_ledger->mailing_state,'state_id');
	if($sale_ledger->mailing_state != ''){
		$statename = $mailing_state->state_name;
		$party_ledger_purchaser = $party_ledger_purchaser->state_name;
	}else{
		$statename = '';
		$party_ledger_purchaser = '';
	}
    $content .= '
		<table>
			<tr>
				<td colspan="1"><img src="'.$image.'" alt="test alt attribute" width="60" height="50" border="0" ></td>
				<td colspan="8"><div style="margin-top: 20%;"><h2 align="center">INVOICE</h2></div></td>
			</tr>
		</table>
		<table border="1" cellpadding="2">
			<tr>
				<td colspan="3" rowspan="4"><strong>Supplier Address</strong><br><strong>'.$sale_ledger->name.'</strong><br>'.$sale_ledger->mailing_address.'<br><strong>GSTIN:</strong>'.$sale_ledger->gstin.'<br>State Name: '.$statename.',<br>Contact: '.$sale_ledger->phone_no.','.$sale_ledger->mobile_no.'<br>Email:'.$sale_ledger->email.'<br>Website:'.$sale_ledger->website.'</td>
				<td colspan="3"><strong>Invoice No.:</strong> &nbsp;'.$dataPdf->id.'</td>
				<td colspan="3"><strong>Dated</strong> &nbsp;  '.$newDate.'</td>
			</tr>
			<tr>
				<td colspan="6"><strong>E-Way Bill No.</strong> &nbsp; '.$dataPdf->eway_bill_no.'</td>
			</tr>
			<tr>
				<td colspan="3"><strong>Delivery Note</strong> &nbsp; '.$dataPdf->message_for_email.'</td>
				<td colspan="3"><strong>Mode/Terms Of Payment</strong> &nbsp; '.$dataPdf->mode_of_payment.'</td>
			</tr>
			<tr>
				<td colspan="3"><strong>Supplier Ref.</strong> &nbsp; 16-Feb-2019&nbsp;12:20</td>
				<td colspan="3"><strong>Transport/Driver Tel No.</strong> &nbsp; '.$dataPdf->transport_driver_pno.'</td>
			</tr>
			<tr>';
			if($dataPdf->consignee_address != ''){
			$content .='<td colspan="3" rowspan="3"><strong>Consignee Address</strong>&nbsp;'.$dataPdf->consignee_address.' </td>';
			// $content .='<td colspan="3" rowspan="3">Hmm </td>';
			}else{
				$content .='<td colspan="3" rowspan="3"><strong>Consignee Address</strong><br><strong>'.$party_ledger->name.'</strong><br>'.$party_ledger->mailing_address.'<br>State Name: '.$party_ledger_purchaser.',<br>Contact: '.$party_ledger->phone_no.','.$party_ledger->mobile_no.'<br>Email:'.$party_ledger->email.'<br>Website:'.$party_ledger->website.'</td>';
				
				//$content .='<td colspan="3" rowspan="3"><strong>Consignee Address</strong> Accha</td>';
				
			}
			$content .='<td colspan="6"><strong>Buyers Order No:.</strong>&nbsp;'.$dataPdf->buyer_order_no.' </td>
			</tr>
			<tr>
				<td colspan="6"><strong>Dispatch Document No.</strong>&nbsp;'.$dataPdf->dispatch_document_no.'</td>
				
			</tr>
			<tr>
				<td colspan="3"><strong>Dispatched through:</strong> &nbsp;'.$dataPdf->transport.'</td>
				</tr>
			<tr>
				<td colspan="3" rowspan="4"><strong>Buyers Address</strong><br><strong>'.$party_ledger->name.'</strong><br>'.$party_ledger->mailing_address.'<br>State Name: '.$party_ledger_purchaser.',<br>Contact: '.$party_ledger->phone_no.','.$party_ledger->mobile_no.'<br>Email:'.$party_ledger->email.'<br>Website:'.$party_ledger->website.'</td>
				<td colspan="6"><strong>Invoice No.:</strong> &nbsp;'.$dataPdf->id.'</td>
				
			</tr>
			<tr>
				<td colspan="3"><strong>City/Port Of Loading</strong> &nbsp;'.$dataPdf->port_loading.'</td>
				<td colspan="3"><strong>City/Port Of Discharge</strong> &nbsp; '.$dataPdf->port_discharge.'</td>
			</tr>
			<tr>
				<td colspan="3"><strong>GR No.</strong> &nbsp; '.$dataPdf->gr_no.'</td>
				<td colspan="3"><strong>GR Date</strong> &nbsp; '.$dataPdf->gr_date.'</td>
			</tr>
			<tr>
				<td colspan="6"><strong>Terms Of Delivery :</strong> &nbsp;'.$dataPdf->terms_of_delivery.'</td>
			</tr>
			<tr>
				<th width="30px"><strong>S No.</strong></th>
				<th width="110px"><strong>Material <br>Description</strong></th>
				<th width="30px"><strong>QTY</strong></th>
				<th width="30px"><strong>UOM</strong></th>
				<th width="35px"><strong>Unit Price<br>(Rs)</strong></th>
				<th width="30px"><strong>Tax Rate(%)</strong></th>
				<th width="70px"><strong>Net <br>Amt.(Rs)</strong></th>
				<th width="76px"><strong>Tax Amt.(Rs)</strong></th>
				<th width="99px"><strong>Total Amt.</strong></th>
			</tr>';
			$materialDetail =  json_decode($dataPdf->descr_of_goods);																
			$subTotal=10;
			$no=1;
			foreach($materialDetail as $material_detail){
					$material_id=$material_detail->material_id;
					$materialName=getNameById('material',$material_id,'id');	
					$subtotal = $material_detail->rate * $material_detail->quantity;
			
			$content .= '<tr>
				<td>'.$no++.'</td>
				<td>'.$materialName->material_name.'</td>
				<td>'.$material_detail->quantity.'</td>
				<td>'.$material_detail->UOM.'</td>
				<td>'.$material_detail->rate.'</td>
				<td>'.$material_detail->tax.'</td>
				<td>'.$subtotal.'</td>
				<td>'.$material_detail->tax * $material_detail->rate.'</td>
				<td>'.$material_detail->amount.'</td>
			</tr>';
			}
			$invoice_amount_details =  json_decode($dataPdf->invoice_total_with_tax);			
				foreach($invoice_amount_details as $invoice_amount_detail){
			$content .= '<tr>
				<td colspan="8" align="right"><strong>Sub Total </strong> </td>
				<td>Rs. '.$invoice_amount_detail->total.'</td>
			</tr>
			<tr>
				<td colspan="8" align="right"><strong>TAX </strong> </td>
				<td>Rs. '.$invoice_amount_detail->totaltax.'</td>
			</tr>
			<tr>
				<td colspan="8" align="right"><strong>Grand Total </strong> </td>
				<td>Rs. '.$invoice_amount_detail->invoice_total_with_tax.'</td>
			</tr>';
				}
			
			$content .= '<tr>
				<td colspan="3">
					<strong>A/c Name:</strong>'.$sale_ledger->name.'<br><strong>A/c No.:</strong>'.$company_data->account_no.'<br><strong>IFSC:</strong>'.$company_data->account_ifsc_code.'
				</td>
				<td colspan="6">
					<strong>Our Banker Address:-</strong> <br> <strong>Bank :</strong>'.$company_data->bank_name.'<br> <strong>Branch :</strong>'.$company_data->branch.' 
				</td>
			</tr>
			<tr>
				<td colspan="2">Company GSTIN</td>
				<td colspan="7">'.$company_data->gstin.'</td>
			</tr>
			<tr>
				<td colspan="2">Company PAN Card</td>
				<td colspan="7">'.$company_data->company_pan.'</td>
			</tr>
			<tr style="height:2000px">
                <td colspan="6"><h2><u> Terms and conditions</u></h2>
					<p>'.$company_data->term_and_conditions.'</p>
				</td>
				<td class="align-bottom"  valign="bottom" colspan="3" style="text-align:right">'.$company_data->name.'<br><br><br><strong>Vishnu Gupta</strong><br>(Authorized Signatory)</td>
				
				<!------<td colspan="4">'.$company_data->name.'<br><br><img src="'.$imagesign.'" alt="test alt attribute" width="100" height="50" border="0" ><br><strong>Vishnu Gupta</strong><br>(Authorized Signatory)</td>------>
            </tr>';  
    
    $content .= '</table>'; 
	
	
	#pre($content);
	//ob_end_clean();	
	// $obj_pdf->writeHTML($content, true, false, true, false, '');
	 //$obj_pdf->writeHTML($content);
	// $obj_pdf->Output('sample.pdf', 'I');
    	
	//}
	$obj_pdf->writeHTML($content);
	 $obj_pdf->Output('export-to-pdf.pdf', 'D');
//die();	
	
 
 ?> 