<?php   	
    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $obj_pdf->SetCreator(PDF_CREATOR);  
    $obj_pdf->SetTitle("QUOTATION");  
    $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $obj_pdf->SetDefaultMonospacedFont('helvetica');  
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $obj_pdf->setPrintHeader(false);  
    $obj_pdf->setPrintFooter(false);  
    $obj_pdf->SetAutoPageBreak(TRUE, 10);  
    $obj_pdf->SetFont('helvetica', '', 11);
	$company_data = getNameById('company_detail',$dataPdf->created_by_cid,'id');

	$bank_info = json_decode($company_data->bank_details);
    $primarybnk  = $bank_info[0];
	$image = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	$obj_pdf->Image($image,2,4,10,10,'PNG');
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
    $obj_pdf->AddPage(); 	
    $content = ''; 
	if($company_data->address != ''){
			  $companyAddress = json_decode($company_data->address);
			  $companyAddress = 'Address: '.$companyAddress[0]->address.'<br>Country :'.getNameById('country',$companyAddress[0]->country,'country_id')->country_name.'<br>State :'.getNameById('state',$companyAddress[0]->state,'state_id')->state_name.'<br>City :'.getNameById('city',$companyAddress[0]->city,'city_id')->city_name.'<br>Pincode :'.$companyAddress[0]->postal_zipcode;
	}else{
		$companyAddress = '';
	}

	$accountData = getNameById('account',$dataPdf->account_id,'id');

	$contactData = getNameById('contacts',$dataPdf->contact_id,'id');	  
	$products =  json_decode($dataPdf->product);
	$discount_offered = json_decode($dataPdf->discount_offered);
	$discount_offeredHtml = '';
	if(!empty($discount_offered)){
		foreach($discount_offered as $do){
			$discount_offeredHtml .=$do.',';	
		}	
		$discount_offeredHtml = substr_replace($discount_offeredHtml ,"", -1);
	}	
	$dispatch_documents = json_decode($dataPdf->dispatch_documents);
	$dispatch_documentsHtml = '';
	if(!empty($dispatch_documents)){
		foreach($dispatch_documents as $dd){
			$dispatch_documentsHtml .=$dd.',';	
		}	
		$dispatch_documentsHtml = substr_replace($dispatch_documentsHtml ,"", -1);
	}
#!empty($primaryContact)?$primaryContact->phone_no:''
	$content .= '
	<table>
		<tr>
			<td align="center"><img src="'.$image.'" alt="test alt attribute" width="60" height="50" border="0" ></td></tr>
			<tr>
			<td colspan="8"><div style="margin-top: 20%;"><h2 align="center">QUOTATION</h2></div></td>
		</tr>
	</table>
	<table border="1" cellpadding="2">
		<tr>
			<td colspan="3"><strong>Our Ref.</strong> &nbsp; '.$dataPdf->id.'<br> <strong>Dated</strong> &nbsp; '.date("j F , Y", strtotime($dataPdf->created_date)).'</td>
			<td colspan="3"><strong>Party Ref.</strong> &nbsp; '.$dataPdf->party_ref.'<br> <strong>Dated</strong> &nbsp;  '.date("j F , Y", strtotime($dataPdf->created_date)).'</td>
		</tr>		
		<tr>
			<td colspan="3">
				<strong>Consigner Address:</strong> <br>  '.$company_data->name.'  <br> '.$companyAddress.'
			</td>
			<td colspan="3">
				<strong>Consignee Name:</strong><br>'.$accountData->name.'<br><strong>Address:</strong> '.$accountData->billing_street.'<br><strong>City:</strong>  '.getNameById('city',$accountData->billing_city,'city_id')->city_name.'<br><strong>Zipcode:</strong>  '.$accountData->billing_zipcode.'<br><strong>State:</strong>  '.getNameById('state',$accountData->billing_state,'state_id')->state_name.'<br><strong>Country:</strong>  '.getNameById('country',$accountData->billing_country,'country_id')->country_name.' <br><strong>Email :</strong> '.$accountData->email.'
				<br><strong>Phone :</strong> '.$accountData->phone.'<br><strong>GSTIN :</strong> '.$accountData->gstin.'<br>
			</td>
		</tr>


		<tr>
			<th width="30px"><strong>S No.</strong></th>
			<th width="230px"><strong>Material <br>Description</strong></th>
			<th width="30px"><strong>QTY</strong></th>
			<th width="100px"><strong>UOM</strong></th>
			<th><strong>Unit Price(Rs)</strong></th>
			<th width="36px"><strong>Tax Rate(%)</strong></th>
		</tr>';
		$i = 0;
		foreach($products as $product){	
			$i++;
			$material_id = $product->product;	
			$materialName = getNameById('material',$material_id,'id');					
			$matName = $materialName->material_name;

			$ww =  getNameById('uom', $product->uom,'id');
			$uom = !empty($ww)?$ww->ugc_code:'';

														
			$content .= '<tr>
				<td>'.$i.'</td>
				<td><h5>'.$matName.'</h5><br>'.(array_key_exists("description",$product)?$product->description:'').'</td>
				<td>'.$product->quantity.'</td>
				<td>'.$uom.'</td>
				<td>'.$product->price.'</td>
				<td>'.$product->gst.'</td>
			</tr>';
			}			
		$content .= '
		<tr>
			<td colspan="5" align="right"><strong>Total Amount Without Tax</strong> </td>
			<td><img src="http://busybanda.com/erp/assets/images/rs.jpg"  >Rs. '. $dataPdf->total.'</td>
		</tr>
		<tr>
			<td colspan="5" align="right"><strong>Total Payable Amount </strong> </td>
			<td><span></span>Rs. '. $dataPdf->grandTotal.'</td>
		</tr>		
		<tr>
			<td colspan="3">
				<strong>A/c Name:</strong> '.$primarybnk->account_name.' <br><strong>A/c No.:</strong>  '.$primarybnk->account_no.' <br><strong>IFSC:</strong>  '.$primarybnk->account_ifsc_code.' 
			</td>
			<td colspan="3">
				<strong>Our Banker Address: </strong> <br> <strong>Bank =</strong>  '.$primarybnk->bank_name.' <br> <strong>Branch =</strong>  '.$primarybnk->branch.' 
			</td>
		</tr>
		<tr>
			<th colspan="2" style="text-align:center"><strong>Payment Terms</strong></th>
			<th colspan="2" style="text-align:center"><strong>Advance Received</strong></th>
			<th colspan="2" style="text-align:center"><strong>Discount Offered</strong></th>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center">'.$dataPdf->payment_terms.'</td>
			<td colspan="2" style="text-align:center">'.$dataPdf->advance_received.'</td>
			<td colspan="2" style="text-align:center">'.$discount_offeredHtml.'</td>
		</tr>
		<tr>
			<td colspan="3" style="text-align:center">'.$dataPdf->terms_conditions.'</td>
			<td colspan="3">For '.$company_data->name.' <br><br><br><br><br><br>(Authorized Signatory)</td>
		</tr>';  
	$content .= '</table>';  
	$obj_pdf->writeHTML($content);  
	ob_end_clean();
	$obj_pdf->Output('Quotation.pdf', 'I');  
 ?>  
