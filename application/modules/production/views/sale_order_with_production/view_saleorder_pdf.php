<?php  
	//pre($dataPdf); die("dd");
    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $obj_pdf->SetCreator(PDF_CREATOR);  
    $obj_pdf->SetTitle("SALE ORDER");  
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
	
	$image = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	$obj_pdf->Image($image,2,4,10,10,'PNG');
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
    $obj_pdf->AddPage(); 	
    $content = ''; 
	if($company_data->address != ''){
			  $companyAddress = json_decode($company_data->address);
			  $companyAddress = '<strong>Address: </strong>'.$companyAddress[0]->address.'<br><strong>Country :</strong>'.getNameById('country',$companyAddress[0]->country,'country_id')->country_name.'<br><strong>State :</strong>'.getNameById('state',$companyAddress[0]->state,'state_id')->state_name.'<br><strong>City :</strong>'.getNameById('city',$companyAddress[0]->city,'city_id')->city_name.'<br><strong>Pincode :</strong>'.$companyAddress[0]->postal_zipcode;
	}else{
		$companyAddress = '';
	}
	
	
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
	$accountData = getNameById('account',$dataPdf->account_id,'id');
	if(!empty($accountData)){
		$accountDataHtml = '<strong>Consignee Name:</strong> <br>'.((!empty($accountData))?$accountData->name:"").'<br><strong>Address:</strong> '.((!empty($accountData))?$accountData->billing_street:"").',<br><strong>Email :</strong> '.$accountData->email.'
				<br><strong>Phone : </strong>'.$accountData->phone.'<br><strong>GSTIN : </strong>'.(!empty($accountData)?$accountData->gstin:"").'<br><strong>Contact Person : </strong>'.(!empty($contactData)?$contactData->first_name:"").'<br><strong>Contact Person Email : </strong>'.(!empty($contactData)?$contactData->email:"").'<br><strong>Contact Person Phone : </strong>'.(!empty($contactData)?$contactData->phone:"");
	}else{
		$accountDataHtml = '';
	}	
	$content .= '
	<table>
		<tr>
			<td align="center"><img src="'.$image.'" alt="test alt attribute" width="60" height="50" border="0" ></td></tr>
			<tr>
			<td colspan="6"><div style="margin-top: 20%;"><h2 align="center">SALE ORDER</h2></div></td>
		</tr>
	</table>
	<table border="1" cellpadding="2">
		<tr>
			<td colspan="3"><strong>Our Ref.</strong> &nbsp; '.$dataPdf->id.'<br><strong>Dated</strong> &nbsp; '.date("j F , Y", strtotime($dataPdf->created_date)).'</td>
			<td colspan="3"><strong>Party Ref.</strong> &nbsp; '.$dataPdf->party_ref.'<br><strong>Dated</strong> &nbsp;  '.date("j F , Y", strtotime($dataPdf->created_date)).'</td>
		</tr>		
		<tr>
			<td colspan="3">
				<strong>Consigner Address:</strong><br>'.$company_data->name.'<br>'.$companyAddress.'
			</td>
			<td colspan="3">'.$accountDataHtml.'</td>
		</tr>
		<tr>
			<th ><strong>S No.</strong></th>
			<th ><strong>Material  </strong></th>
			<th colspan="2"><strong> Description</strong></th>
			<th ><strong>QTY</strong></th>
			<th><strong>UOM</strong></th>
			
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
				<td><h5>'.$matName.'</h5> </td>
				<td colspan="2"> '.(array_key_exists("description",$product)?$product->description:'').'</td>
				<td >'.$product->quantity.'</td>
				<td>'.$uom.'</td>
				 
			</tr>';
			}			
		$content .= '
		
		<tr>
			<td colspan="6"><strong>Guarantee/ Returnable Special Notes:</strong><br>'.$dataPdf->guarantee.'</td>
		</tr>		
		<tr>
			<td colspan="3">
				<strong>A/c Name:</strong> '.(!empty($company_data)?$company_data->account_name:"").' <br><strong>A/c No.:</strong>  '.(!empty($company_data)?$company_data->account_no:"").' <br><strong>IFSC:</strong>  '.(!empty($company_data)?$company_data->account_ifsc_code:"").' 
			</td>
			<td colspan="3">
				<strong>Our Banker Address: </strong> <br> <strong>Bank =</strong>  '.(!empty($company_data)?$company_data->bank_name:"").' <br> <strong>Branch =</strong>  '.(!empty($company_data)?$company_data->branch:"").' 
			</td>
		</tr>
		<tr>
			<th ><strong>Dispatch Date</strong></th>
			<th ><strong>Other Taxes</strong></th>
			<th ><strong>Freight</strong></th>
			<th><strong>Payment Terms</strong></th>
			<th><strong>Advance Received</strong></th>
			<th><strong>Discount Offered</strong></th>
		</tr>
		<tr>
			<td>'.date("j F , Y", strtotime($dataPdf->dispatch_date)).'</td>
			<td>'.$dataPdf->agt.'</td>
			<td >'.$dataPdf->freight.'</td>
			<td>'.$dataPdf->payment_terms.'</td>
			<td>'.$dataPdf->advance_received.'</td>
			<td>'.$discount_offeredHtml.'</td>
		</tr>
		<tr>
			<td colspan="2"><strong>Documents Dispatched : </strong> &nbsp; '.$dispatch_documentsHtml.'</td>
			<td colspan="4"><strong>Product Applications : </strong> &nbsp; '.$dataPdf->product_application.' </td>
		</tr>		
		<tr>
			<td colspan="2"><strong>Label Printing Express : </strong> &nbsp; '.$dataPdf->label_printing_express.'</td>
			<td colspan="4"><strong>Brand Label : </strong> &nbsp; '.$dataPdf->brand_label.' </td>
		</tr>
		<tr>
			<td colspan="6">For '.$company_data->name.' <br><br><br><br><br><br>(Authorized Signatory)</td>
		</tr>';  
	$content .= '</table>';  
	 $obj_pdf->writeHTML($content); 
	
	
	$obj_pdf->Output('sale_order.pdf', 'I');  
 ?>  
