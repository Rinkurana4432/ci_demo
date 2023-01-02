<?php 

// pre($dataPdf);die();  
    $obj_pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
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
	$bank_info = json_decode($company_data->bank_details);
    $primarybnk  = $bank_info[0];
	$image = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	$obj_pdf->Image($image,2,4,10,10,'PNG');
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
    $obj_pdf->AddPage(); 	
    $content = ''; 
	$ci =& get_instance();
	if($company_data->address != ''){
			  $companyAddress = json_decode($company_data->address);
			  $companyAddress = 'Address: '.$companyAddress[0]->address.', Country: '.getNameById('country',$companyAddress[0]->country,'country_id')->country_name.', State: '.getNameById('state',$companyAddress[0]->state,'state_id')->state_name.', City: '.getNameById('city',$companyAddress[0]->city,'city_id')->city_name.', Pincode: '.$companyAddress[0]->postal_zipcode;
	}else{
		$companyAddress = '';
	}
		
	
	$accountData = getNameById('account',$dataPdf->account_id,'id');
	$accountAdd = json_decode($accountData->new_billing_address);
	// pre($accountData);
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

	// Start Sale Order number
	$last_id = getNameById('sale_order',$dataPdf->id,'id');
	$rId = $last_id->so_order;
	$piCode = $rId;
	/************** Revised Purchase order generation ******************/
	$currentRevisedPIChar = 'A';
	$nextRevisedPIChar = chr(ord($currentRevisedPIChar) + 1);
	$revisedPOCode = '';
	$revisedPICode = '';
	if ($dataPdf && $dataPdf->save_status == 1) {
		if(@$dataPdf->pi_code == ''){
			echo " ";
		}else{
		$pi_code_array = explode('_', $dataPdf->pi_code, 4);
		//pre($pi_code_array);
		//	foreach ($pi_code_array as $key => $value) {
		//	echo "pi_code_array[".$key."] = ".$value."<br>";
	//	}
			//pre($pi_code_array);

		if($pi_code_array[2] == ''){
			$currentRevisedPIChar = 'A';
			#$nextRevisedPOChar = chr(ord($currentRevisedPOChar) + 1);
			$revisedPICode = $pi->pi_code.'_'.$currentRevisedPIChar.'(Revised)';
		}else if($pi_code_array[2] != ''){
			#echo $po_code_array[2];
			$orignalOrderCode = $pi_code_array[0].'_'.$pi_code_array[1].'_'.$pi_code_array[2];
			$currentRevisedPIChar = explode('(', $pi_code_array[2], 1);
			$nextRevisedPIChar = chr(ord($currentRevisedPIChar[0]) + 1);
			$revisedPICode = $orignalOrderCode.'_'.$nextRevisedPIChar.'(Revised)';
		}
		}
	}
	// echo $piCode;
	// die;
	// End Proforma Invoice number

	// Get terms and conditions
	$termsAndCondition = $ci->crm_model->get_data('termscond');
	// Get Variant Images
	$variantTypes =	$ci->crm_model->get_data('variant_types');
	$variantImages = $ci->crm_model->get_data('variant_options');
	$variantImages = $ci->crm_model->get_data('material_variants');
	$packing_data1 = 0;
	$matIDD = 0;
	
	// foreach($variantImages as $mages ){
		
		// $packing_data = json_decode($mages['packing_data']);
		
		 // foreach($packing_data as $pp){
			 
			 // $packing_data1 .= $pp->packing_mat;
			 
			 // if(!empty($packing_data1)){
				// $matIDD = $mages['id'];
				
			 // }
			
		 // }
	// }
	// pre($matIDD);
	// die();
	#echo $packing_data1;


	$accountdata = getNameById('account',$dataPdf->account_id,'id');
    $billingdata = json_decode($accountdata->new_billing_address);
	
	$content = '<table style="width: 100%;font-size: 10px;font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;color: #555;  border-spacing: 0;" border="1" cellpadding ="2" >
											
											   <tr>
												       <td colspan="9"><span style="font-size: 18px;margin-top: 5px;text-align:center;font-wight:bold;">'.$company_data->name.' Industries pvt ltd</span></td>
													   <td border-left="0px"><img src="'.base_url().'/assets/modules/crm/uploads/alfalogo.jpg"  style="float: left;width: 80px;"></td>
													   
											   </tr>
											   <tr>
											       <th colspan="10">
												       <strong>'.$companyAddress.'</strong>
												   </th>
											   </tr>
											   <tr>
											    <td>DATE</td>
											    <td>'.$dataPdf->order_date.'</td>
											    <td colspan="6" style="text-align:center;">SALE ORDER</td>
											    <td>SO NO:</td>
											    <td>'.$piCode.'</td>
											   </tr>
											   <tr>
											    <td colspan="4">TO</td>
											    
											    <th colspan="6">Bank Details</th>
											   </tr>
											   <tr>
											    <td colspan="4">Buyer Name: '.$accountdata->name.'<br>
													Phone Number : '.$accountdata->phone.'<br>
													Address : '.$billingdata[0]->billing_street_1.'<br>
													State : '.$billingdata[0]->state_name.'<br>
													City : '.$billingdata[0]->city_name.'<br>
													Zipcode : '.$billingdata[0]->billing_zipcode_1.'</td>
											    
											    <td colspan="6" >Account Name: '.$company_data->name.' Industries Pvt Ltd<br>
													 Bank Name : '.$company_data->bank_name.'<br>
													 Account Number: '.$company_data->account_no.'<br>
													 IFSC Code: '.$company_data->account_ifsc_code.'<br>
													 Branch Name: '.$company_data->branch.'
												  </td>
											   </tr>
												<tr>
													<th style="vertical-align: middle; text-align: center;">SL.No</th>
													<th style="vertical-align: middle; text-align: center;">Product Code</th>
													<th style="vertical-align: middle; text-align: center;">Product Image</th>';
													$max_val_chk = array();
													foreach($products as $product){
													 $matData = getNameById('material', $product->product, 'id');
													$mat_name = $matData->material_name;
													
													// $mat_name = $product->product;
													$chunks = explode('_', $mat_name);
													if(count($chunks) == 4){
													$colspan = '';
													} elseif(count($chunks) == 3){
													$colspan = '2';
													} elseif(count($chunks) == 2){
													$colspan = '3';
													} elseif(count($chunks) == 1){
													$colspan = '4';
													}
													$max_val_chk[] = count($chunks);	
													} 
													for ($i = 1; $i < max($max_val_chk); $i++) {
														$content .= '<th style="vertical-align: middle; text-align: center;">Variant '.$i.'</th>';
													}
													$content .= '<th style="vertical-align: middle; text-align: center;">Description</th>
													<th style="vertical-align: middle; text-align: center;">Quantity</th>
													<th style="vertical-align: middle; text-align: center;">Price</th>
													<th colspan="'.$colspan.'" style="vertical-align: middle; text-align: center;">Total</th>
												</tr>
											
											<tbody>';											   
												if(!empty($products)){
														$i =  1;
														$ck = 0;
														$subtotal = 0;
														$gst = 0;
														$imagepath = '';
														foreach($products as $product){
														$subtotal += $product->individualTotal;
														$gst += $product->individualTotal*($product->gst/100);
														if(!empty($dataPdf)){
															$mat_type = json_decode($dataPdf->material_type_id);
															
															$material_type_id = getNameById('material_variants',$mat_type[$ck],'id');
															
															$materialItemCode = $material_type_id->item_code;
															$variantData = $material_type_id->variants_data;
															$variantDataValue = json_decode($variantData);
															}
												$content .=  '<tr>
													<td style="vertical-align: middle; text-align: center" ><br><br><br>1</td>
													<td style="vertical-align: middle; text-align: center"><br><br><br>'.$materialItemCode.'</td>
													<td style="vertical-align: middle; text-align: center">';
													
													$mat_name = $product->product;
													$mat_details = getNameById('material', $mat_name, 'id');
													
													$mat_id = $mat_details->id;
													
													$attachments = $ci->crm_model->get_image_by_materialId('attachments', 'rel_id', $product->product);
													$content .=  '<img style="width: 50px; height: 50px;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
													$content .= '</td>';
													
													$matData = getNameById('material', $product->product, 'id');
													$mat_name = $matData->material_name;
													//$mat_name = $product->product;
													$chunks = explode('_', $mat_name);
													for ($i = 1; $i < max($max_val_chk); $i++) {
													$c =$i+1;
													if($c > count($chunks)){
													$content .= '<td style="vertical-align: middle; text-align: center"></td>';	
													} else {
													$variants = getNameById('material_variants', $chunks[0], 'temp_material_name');
													$variants_data = !empty($variants->variants_data) ? json_decode($variants->variants_data, true):'';
													$variant_key = !empty($variants_data['variant_key']) ? $variants_data['variant_key']:array();
													$variantKeyCount = count($variant_key);
													for($k=1; $k<=$variantKeyCount; $k++){
													$fieldname = $variant_key[$k][0];
													$variants = getNameById_withmulti('variant_options', $chunks[$i], 'option_name', $fieldname, 'variant_type_name');
													$variantOptionName = $variants->option_name;
													if(!empty($variants)){
													$imagepath =  '<img style="width: 50px; height: 50px;" src="'.base_url().'/assets/modules/inventory/varient_opt_img/'.$variants->option_img_name.'">';
													$content .= '<td style="vertical-align: middle; text-align: center">'.$imagepath.'<br><span>'.$variantOptionName.'</span></td>';
													}
													}	
													

													}
													
													}
													
													$content .= '<td style="vertical-align: middle; text-align: center"><br><br><br>'.$product->description.'</td>
													<td style="vertical-align: middle; text-align: center"><br><br><br>'.$product->quantity.'</td>
													<td style="vertical-align: middle; text-align: center"><br><br><br>'.$product->price.'</td>
													<td colspan="'.$colspan.'" style="vertical-align: middle; text-align: center"><br><br><br>'.$product->individualTotal.'</td>
												</tr>';
												 $i++; $ck++; }
													}
													if(!empty($dataPdf)){
														// $account = getNameById('account',$dataPdf->account_id,'id');
														// $type_of_customer = $account->type_of_customer;
														 // $type_of_customer_data = $ci->crm_model->get_data_byId('types_of_customer', 'id', $type_of_customer);
														 // $calcDiscount_val = $dataPdf->load_type;
														 // $pi_cbf = $dataPdf->pi_cbf;
														 // $pi_weight = $dataPdf->pi_weight;
														 // $pi_paymode = $dataPdf->pi_paymode;
														 // $pi_permitted = $dataPdf->pi_permitted;
														 // $special_discount = $dataPdf->special_discount;
														 // $freightCharges = $dataPdf->freightCharges;
														 // if(!empty($dataPdf->advance_received)){
															// $advance_received = $dataPdf->advance_received;
														 // }else{
															// $advance_received = 0;
														 // }
														 // if($calcDiscount_val == 'none'){
														 // $discount_rate = "0";
														 // } else {
														 // $discount_rate = $type_of_customer_data->$calcDiscount_val;	
														 // }
														 // $discount_value = $subtotal*($discount_rate/100);
														 // $spd_value = $subtotal*($special_discount/100);
														 // $total = $subtotal - $discount_value - $spd_value;
														 // $gfc = $freightCharges*28/100;
														 // $grand_total = $total+$gst+$freightCharges+$gfc;
														
														
														 // $remain_balance = $grand_total-$advance_received;
														
															
								   	$account = getNameById('account',$dataPdf->account_id,'id');
								   	$type_of_customer = (int)$account->type_of_customer;
										$type_of_customer_data = $ci->crm_model->get_data_byId('types_of_customer', 'id', $type_of_customer);
										$calcDiscount_val = $dataPdf->load_type;
										$sale_order_cbf = $dataPdf->pi_cbf;
										$sale_order_weight = $dataPdf->pi_weight;
										$sale_order_paymode = $dataPdf->pi_paymode;
										$sale_order_permitted = $dataPdf->pi_permitted;
										$special_discount = $dataPdf->special_discount;
										$freightCharges = $dataPdf->freightCharges;
										$advance_received = $dataPdf->advance_received;
										
										
										
										if($calcDiscount_val == 'none'){
											$discount_rate = 0;
										} else {
											if(!empty($type_of_customer_data->$calcDiscount_val)){
												$discount_rate = $type_of_customer_data->$calcDiscount_val;	
											}else{
												$discount_rate = 0;
											}
										}
										
										$discount_value = $subtotal*($discount_rate/100);
										$spd_value = $subtotal*($special_discount/100);
										$total = $subtotal - $discount_value - $spd_value;
										$gfc = $freightCharges*18/100;
										$grand_total = $total+$gst+$freightCharges+$gfc;
										$remain_balance = (int)$grand_total-(int)$advance_received;
													 }
													$content .= '
												<tr>												
													<td colspan="7">TERMS & CONDITION</td>												
													<td colspan="2">Sub Total</td>
													<td>'.$subtotal.'</td>
												</tr>
												<tr>												
													<td colspan="7" rowspan="10">1.'.$termsAndCondition[0]['content'].'
													 </td>
													<td colspan="2">Discount</td>
													<td>'.$discount_value.'</td>
												</tr>
												<tr>												
													<td colspan="2">Special Discount  </td>
													<td>'.$spd_value.'</td>
												</tr>
												<tr>												
													<td colspan="2">Total  </td>
													<td>'.$total.'</td>
												</tr>
                                                <tr>												
													<td colspan="2">Tax</td>
													<td>'.$gst.'</td>
												</tr>
                                                <tr>												
													<td colspan="2">Freight</td>
													<td>'.$freightCharges.'</td>
												</tr>
												<tr>												
													
													<td colspan="2">GST on the Freight</td>
													<td>'.$gfc.'</td>
												</tr>
												<tr>												
												
													<td colspan="2">TCS</td>
													<td>0.00</td>
												</tr>
												<tr>												
													<td colspan="2">Grand Total</td>
													<td>'.$grand_total.'</td>
												</tr>
												<tr>												
													
													<td colspan="2">Advance</td>
													<td>'.$advance_received.'</td>
												</tr>
												<tr>												
													
													<td colspan="2">Balance</td>
													<td>'.$remain_balance.'</td>
												</tr>
                                                 <tr>												
													<td colspan="10">Note:This is an electonic quote. Signature not requiers.</td>
												
												</tr>
                                                <tr>												
													<td colspan="7">Thanking You,</td>
													<td colspan="3">For '.$company_data->name.' Industries PVT Ltd<br><br>Authoriesd Signature</td>
												
												</tr>
                                                 												
											</tbody>											
										
										
	
	
	
	
	
	
	
	
	
	
	
	
	
	<!--
	<table border="1" cellpadding="2">
	   <tr><td colspan="9"><h2 align="center" style="margin: 5px 0px;">Sale Order</h2></td></tr>
		<tr>
			<td colspan="3"><strong>Our Ref.</strong> &nbsp; '.$dataPdf->id.'<br> <strong>Dated</strong> &nbsp; '.date("j F , Y", strtotime($dataPdf->created_date)).'</td>
			<td colspan="6"><strong>Party Ref.</strong> &nbsp; '.$dataPdf->party_ref.'<br> <strong>Dated</strong> &nbsp;  '.date("j F , Y", strtotime($dataPdf->created_date)).'</td>
		</tr>		
		<tr>
			<td colspan="3">
				<strong>Consigner Address:</strong> <br>'.$company_data->name.'  <br> '.$companyAddress.'
				<br><strong>Phone :</strong> '.$company_data->phone.'<br><strong>GSTIN :</strong> '.$company_data->gstin.'<br>
			</td>
			
			<td colspan="6">
				<strong>Consignee Name:</strong><br>'.$accountAdd[0]->billing_company_1.'<br><strong>Address:</strong> '.$accountAdd[0]->billing_street_1.'<br><strong>City:</strong>  '.getNameById('city',$accountAdd[0]->billing_city_1,'city_id')->city_name.'<br><strong>Zipcode:</strong>  '.$accountAdd[0]->billing_zipcode_1.'<br><strong>State:</strong>  '.getNameById('state',$accountAdd[0]->billing_state_1,'state_id')->state_name.'<br><strong>Country:</strong>  '.getNameById('country',$accountAdd[0]->billing_country_1,'country_id')->country_name.' <br><strong>Email :</strong> '.$accountData->email.'
				<br><strong>Phone :</strong> '.$accountData->phone.'<br><strong>GSTIN :</strong> '.$accountData->gstin.'<br>
			</td>
		</tr>
		<tr>
			<th width="30px"><strong>S No.</strong></th>
			<th width="110px"><strong>Material <br>Description</strong></th>
			<th width="30px"><strong>QTY</strong></th>
			<th><strong>UOM</strong></th>
			<th><strong>Unit Price(Rs)</strong></th>
			<th width="30px"><strong>Tax Rate(%)</strong></th>
			<th><strong>Net <br>Amt.(Rs)</strong></th>
			<th><strong>Tax Amt.(Rs)</strong></th>
			<th width="83px"><strong>Total Amt.</strong></th>
		</tr>';
		$i = 0;
		foreach($products as $product){	
			$i++;
			$material_id = $product->product;	
			$materialName = getNameById('material',$material_id,'id');					
			$matName = $materialName->material_name;
			$ww =  getNameById('uom', $product->uom,'id');
			$uom = !empty($ww)?$ww->ugc_code:'';
			$total_tax =  $product->individualTotal*$product->gst/100;
				$total_tax = floor($total_tax*100)/100;

			$content .= '<tr>
				<td>'.$i.'</td>
				<td><h5>'.$matName.'</h5><br>'.(array_key_exists("description",$product)?$product->description:'').'</td>
				<td>'.$product->quantity.'</td>
				<td>'.$uom.'</td>
				<td>'.$product->price.'</td>
				<td>'.$product->gst.'</td>
				<td>'.$product->individualTotal.'</td>
				<td>'.$total_tax.'</td>
				<td>'.$product->individualTotalWithGst.'</td>
			</tr>';
			}			
		$content .= '
		<tr>
			<td colspan="8" align="right"><strong>Total Amount </strong> </td>
			<td>Rs. '. $dataPdf->total.'</td>
	   </tr>';
if (!empty($dataPdf->agt)) {
	 $content .=  
	     '<tr>
			<td colspan="8" align="right">Other Taxes </td>
			<td>Rs. '. $dataPdf->agt.'</td>
		</tr>';
	}
   if (!empty($dataPdf->freightCharges)) {
      $content .=  
	     ' <tr>
			<td colspan="8" align="right">Freight Charges </td>
			<td>Rs.'. $dataPdf->freightCharges.'</td>
		</tr>';
   }
	if ($dataPdf->grandTotal) {
		 $overAllTotal=$dataPdf->grandTotal+(float)$dataPdf->freightCharges??'';
		$content .=  
	     '<tr>
			<td colspan="8" align="right"><strong>Grand Total</strong> </td>
			<td>Rs. '. $overAllTotal.'</td>
		 </tr>';
	 }
	 if(!empty($dataPdf->advance_received)){
			$advance_received = $dataPdf->advance_received;
		 }else{
			$advance_received = 0;
		 }
	 if (!empty($dataPdf->advance_received)) {
		$content .=  
	     '<tr>
			<td colspan="8" align="right"> Advance Received  </td>
			<td>Rs. '. $advance_received.'</td>
		 </tr>';
	}
	if (!empty($overAllTotal)) {
		$overallremoveAdvamt=$overAllTotal-$advance_received;
		$content .=  
	     '<tr>
			<td colspan="8" align="right"><strong>Total Payable Amount </strong> </td>
			<td>Rs. '. $overallremoveAdvamt.'</td>
		 </tr>';
	}

		$content .=  
	     '<tr>
			<td colspan="9"><strong>Guarantee/ Returnable Special Notes:</strong><br>'.$dataPdf->guarantee.'</td>
		</tr>		
		<tr>
			<td colspan="3">
				<strong>A/c Name:</strong> '.$company_data->account_name.' <br><strong>A/c No:</strong>  '.$company_data->account_no.' <br><strong>IFSC:</strong>  '.$company_data->account_ifsc_code.' 
			</td>
			<td colspan="6">
				<strong>Our Banker Address: </strong> <br> <strong>Bank :</strong>  '.$company_data->bank_name.' <br> <strong>Branch :</strong>  '.$company_data->branch.' 
			</td>
		</tr> 
		<tr>
			<th colspan="2"><strong>Dispatch Date</strong></th>  
			<th colspan="4"><strong>Payment Terms</strong></th> 
			<th colspan="4"><strong>Discount Offered</strong></th>
		</tr>
		<tr>
			<td colspan="2">'.date("j F , Y", strtotime($dataPdf->dispatch_date)).'</td>  
			<td colspan="4">'.$dataPdf->payment_terms.'</td> 
			<td colspan="4">'.$discount_offeredHtml.'</td>
		</tr>';
		$content .=  
	      '<tr>
			<td colspan="4"><strong>Documents Dispatched : </strong> &nbsp; '.$dispatch_documentsHtml.'</td>
			<td colspan="5"><strong>Product Applications : </strong> &nbsp; '.$dataPdf->product_application.' </td>
		 </tr>		
		<tr>
			<td colspan="4"><strong>Label Printing Express : </strong> &nbsp; '.$dataPdf->label_printing_express.'</td>
			<td colspan="5"><strong>Brand Label : </strong> &nbsp; '.$dataPdf->brand_label.' </td>
		</tr>
		<tr>
			<td colspan="9">For '.$company_data->name.' <br><br><br><br><br><br>(Authorized Signatory)</td>
		</tr>-->';  
	$content .= '</table>';  

	// echo $content;
	// die();
	$obj_pdf->writeHTML($content);  
	ob_end_clean();
	$obj_pdf->Output('proforma_invoice.pdf', 'I');  
 ?>  
