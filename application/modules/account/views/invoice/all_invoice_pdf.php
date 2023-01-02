<?php   
$content = '';
foreach($dataPdfs as $dataPdf){
	
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
    $obj_pdf->setPrintFooter(true);  
   $obj_pdf->SetAutoPageBreak(TRUE, 15);
	$obj_pdf->SetTopMargin(15);	
    $obj_pdf->SetFont('helvetica', '', 10);	
	$company_data=getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
	$user_data=getNameById('user_detail',$_SESSION['loggedInUser']->u_id,'id');
	//pre($user_data);die();
	// $image = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	// $obj_pdf->Image($image,2,4,10,10,'PNG');
	// $imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	// $obj_pdf->Image($imagesign,2,4,10,10,'PNG');
    $obj_pdf->AddPage(); 
	//$content = '';
	$content1 = '';
	$sale_ledger = getNameById('ledger',$dataPdf->sale_ledger,'id');
	
	$sale_ledger_data = json_decode($sale_ledger->mailing_address,true);
	
	$party_ledger = getNameById('ledger',$dataPdf->party_name,'id');
	 
  $party_add = json_decode($party_ledger->mailing_address,true);
   
	   foreach ($party_add as $key => $detaild) {
			if ($detaild['mailing_state'] == $dataPdf->party_state_id) {
				$mailing_address11 = $detaild['mailing_address'];
				
			}
	   }
	
	$newDate = date("d-M-Y", strtotime($dataPdf->created_date));
	$datetime_issue_invoice = date("d-M-Y H:i", strtotime($dataPdf->date_time_of_invoice_issue));
	$datetime_removal_goods = date("d/m/Y", strtotime($dataPdf->date_time_removel_of_goods));
	$mailing_state = getNameById('state',$sale_ledger_data[0]['mailing_state'],'state_id');
	$party_ledger_purchaser = getNameById('state',$dataPdf->party_state_id,'state_id');
	if($sale_ledger_data[0]['mailing_state'] != ''){
		$statename = $mailing_state->state_name;
		$party_ledger_purchaser = $party_ledger_purchaser->state_name;
	}else{
		$statename = '';
		$party_ledger_purchaser = '';
	}
	if($dataPdf->eway_bill_no != '' && $dataPdf->eway_bill_no != '0' ){
		$content1 .='<span>e-Way bill No.'.$dataPdf->eway_bill_no.'</span>';
	}
	
	if($company_data->term_and_conditions == ''){
		$termandCondi = 'N/A';
	}else{
		$termandCondi = $company_data->term_and_conditions;
	}
	
	
    $content .= '
		<table>
			<tr>
				
				<td colspan="8"><div><h2 align="center">Tax Invoice</h2></div></td>
			</tr>
		</table>
		<table border="1" cellpadding="2">
			<tr>
				<td colspan="4" rowspan="4"><br><strong>'.$sale_ledger->name.'</strong><br>'.$sale_ledger_data[0]['mailing_address'].'<br><strong>GSTIN:</strong>'.$sale_ledger->gstin.'<br>State Name: '.$statename.',<br>Contact:  '.$sale_ledger->phone_no.','.$sale_ledger->mobile_no.'<br>Email:  '.$sale_ledger->email.'<br>Website:  '.$sale_ledger->website.'</td>
				<td colspan="2">'.$content1.'<strong><br>Invoice No:  </strong> &nbsp;<br/>'.$dataPdf->invoice_num.'</td>
				<td colspan="2"><strong>Dated</strong> &nbsp;<br/>'.$newDate.'</td>
			</tr>
			<tr>
				
			</tr>
			<tr>
				<td colspan="2"><strong>Buyers Order No</strong> &nbsp;<br> '.$dataPdf->buyer_order_no.'</td>
				<td colspan="2"><strong>Dated:</strong> &nbsp;<br> '.$newDate.'</td>
			</tr>
			<tr>
				<td colspan="2"><strong>Despatch Document No.</strong> &nbsp;<br/>'.$dataPdf->dispatch_document_no.'</td>
				<td colspan="2"><strong>Delivery Note Date.</strong> &nbsp; '.$newDate.'</td>
			</tr>
			<tr>';
			if($dataPdf->consignee_address != ''){
			$content .='<td colspan="4" rowspan="3"><strong>Consignee Address:</strong>&nbsp;'.$dataPdf->consignee_address.' </td>';
			}else{
				$content .='<td colspan="4" rowspan="3"><strong>Consignee Address : </strong><br><strong>'.$party_ledger->name.'</strong><br>'.$mailing_address11.'<br>State Name :  '.$party_ledger_purchaser.',<br>Contact :  '.$party_ledger->phone_no.','.$party_ledger->mobile_no.'<br>Email :  '.$party_ledger->email.'<br>Website :  '.$party_ledger->website.'</td>';
			}
			$content .='<td colspan="2"><strong>Transport</strong>&nbsp;<br/>'.$dataPdf->transport.' </td>
						<td colspan="2"><strong>Driver Mobile No.</strong>&nbsp;<br/>'.$dataPdf->transport_driver_pno.' </td>
			</tr>
			<tr>
				<td colspan="2"><strong>GR No & Date</strong>&nbsp;'.$dataPdf->gr_date.'</td>
				<td colspan="2"><strong>Motar Vehicle No.</strong>&nbsp;<br/>'.$dataPdf->vehicle_reg_no.' </td>
				
			</tr>
			<tr>
				<td colspan="2"><strong>Date Time Issue of Invoice</strong> &nbsp;<br>'.$datetime_issue_invoice.'</td>
				<td colspan="2"><strong>Date Time Removal of Goods</strong> &nbsp;<br>'.$datetime_removal_goods.'</td>
			</tr>
			<tr>
				<td colspan="4" rowspan="1"><strong>Buyers Address</strong><br><strong>'.$party_ledger->name.'</strong><br>'.$mailing_address11.'<br>State Name: '.$party_ledger_purchaser.',<br>Contact: '.$party_ledger->phone_no.','.$party_ledger->mobile_no.'<br>Email:'.$party_ledger->email.'<br>Website:'.$party_ledger->website.'</td>
				<td colspan="6"><strong>Terms Of Delivery </strong> &nbsp;<br>'.$dataPdf->terms_of_delivery.'</td>
				</tr>
			
			
			<tr>
				<th width="30px"><strong>Sl No.</strong></th>
				<th width="110px"><strong>Description of Goods</strong></th>
				<th width="70px"><strong>HSN/SAC</strong></th>
				<th width="70px"><strong>QTY</strong></th>
				<th width="75px"><strong>Rate</strong></th>
				<th width="70px"><strong>Per</strong></th>
				<th width="86px"><strong>Total Amt.</strong></th>
			</tr>';
			//$materialDetail =  json_decode($dataPdf->descr_of_goods);
				$materialDetail =  json_decode($dataPdf->descr_of_goods,true);	
				$data_charges_json = json_decode($dataPdf->charges_added,true);	
				$array_mrg = array_merge((array)$materialDetail,(array)$data_charges_json);				
			$subTotal=10;
			$no=1;
			foreach($array_mrg as $material_detail){
					$material_id=$material_detail['material_id'];
					$materialName=getNameById('material',$material_id,'id');	
					$subtotal = $material_detail['rate'] * $material_detail['quantity'];
					
			if($material_detail['material_id'] != ''){
			$content .= '<tr>
				<td>'.$no++.'</td>
				<td>'.$materialName->material_name.'<br/><span style="font-size:8px;margin-lefft:20px;">'.$material_detail['descr_of_goods'].'</span></td>
				<td>'.$material_detail['hsnsac'].'</td>
				<td>'.$material_detail['quantity'].' '.$material_detail['UOM'].'</td>
				<td>'.$material_detail['rate'].'</td>
				<td>'.$material_detail['UOM'].'</td>
				<td>'.number_format($subtotal).'</td>

			</tr>';
			}
			if($material_detail['particular_charges_name'] != ''){
				$charge_name = getNameById('charges_lead',$material_detail['particular_charges_name'],'id');
					$charges_added_without_tax = $material_detail['charges_added'];
				$content .= '<tr>
					<td  width="30px">'.$no++.'</td>
					<td width="110px" >'.$charge_name->particular_charges.'</td>
					<td width="70px">'.$charge_name->hsnsac.'</td>
					<td width="70px">N/A</td>
					<td width="75px">N/A</td>
					<td width="70px">N/A</td>
					<td width="86px">'.number_format($charges_added_without_tax).'</td>
				</tr>';
				
				
				
			}
		}	
	
			$invoice_amount_details =  json_decode($dataPdf->invoice_total_with_tax);
			$data_charges_for_taxes = json_decode($dataPdf->charges_added,true);
				$ttotal_Amount_with_charges = 0;
				$carges_taxx_igst = 0;
				$grand_total_with_tax = array();
				$$grand_total_charges_invoice_tax_half = array();
				foreach($data_charges_for_taxes as $tax_val){
					$charge_name_val = getNameById('charges_lead',$tax_val['particular_charges_name'],'id');
					if($charge_name_val->type_charges == 'plus' && $tax_val['sgst_amt'] == '' && $tax_val['cgst_amt'] == ''){
						//IGST
						
						
						$ttotal_Amount_with_charges +=  $tax_val['charges_added'];
						
						
						$carges_taxx_igst = $tax_val['amt_with_tax'] - $tax_val['charges_added'];
						$grand_total_with_tax  = $ttotal_Amount_with_charges + $total_igst; 
						
					}else if($charge_name_val->type_charges == 'plus' && $tax_val['sgst_amt'] != '' && $tax_val['cgst_amt'] != ''){//CGST SGST
						$ttotal_Amount_with_charges += $tax_val['charges_added'];
						$carges_taxx = $tax_val['amt_with_tax'] - $tax_val['charges_added'];
						$grand_total_charges_invoice_tax += $carges_taxx;
						$grand_total_with_tax =  $ttotal_Amount_with_charges + $carges_taxx;
					}
				}
				
				
				 
					/* Calculation For CGST and SGST*/
					 $invoice_total_tax_cgst_sgst = $dataPdf->CGST + $dataPdf->SGST;
				     $totalTax22 = $grand_total_charges_invoice_tax + $invoice_total_tax_cgst_sgst;
				     $grand_total_charges_invoice_tax_half = $totalTax22/2;
					/* Calculation For CGST and SGST*/ 
			
						if(!empty($data_charges_for_taxes)){ //when charges added
					
						 $subtotal_with_charges = $ttotal_Amount_with_charges + $invoice_amount_details[0]->total;
						  
						if($dataPdf->CGST == 0 &&  $dataPdf->CGST == 0){
							$content .= '<tr>						
								<td colspan="6" align="right"><strong>Sub Total </strong> </td>
								<td>'.number_format($subtotal_with_charges).'</td>
							</tr>';	
							$invoice_tax = $dataPdf->IGST;
							$total_igst = $carges_taxx_igst + $invoice_tax;
							$content .='<tr>
								<td colspan="6" align="right"><strong>IGST </strong> </td>
								<td>'.number_format($total_igst).'</td>
							</tr>';
							$Total_amount_sum = $subtotal_with_charges + $total_igst;
							$content .='<tr>
									<td colspan="6" align="right"><strong>Grand Total </strong> </td>
									<td>'.number_format($Total_amount_sum).'</td>
								</tr>';
						}else{
							
							$content .= '<tr>						
							<td colspan="6" align="right"><strong>Sub Total </strong> </td>
							<td>'.number_format($subtotal_with_charges).'</td>
							</tr>';
							
							$content .='<tr>
							<td colspan="6" align="right"><strong>CGST </strong> </td>
							<td>'.number_format($grand_total_charges_invoice_tax_half).'</td></tr>
							<tr><td colspan="6" align="right"><strong>SGST </strong> </td>
							<td>'.number_format($grand_total_charges_invoice_tax_half).'</td>
							</tr>';
							$Total_amount_sum = $subtotal_with_charges + $totalTax22;
							$content .='<tr>
									<td colspan="6" align="right"><strong>Grand Total </strong> </td>
									<td>'.number_format($Total_amount_sum).'</td>
								</tr>';
						}
						
						
				}else{//when Charges not added
					$content .= '<tr>						
						<td colspan="6" align="right"><strong>Sub Total </strong> </td>
						<td>'.number_format($invoice_amount_details[0]->total).'</td>
					</tr>';
					
					if($dataPdf->CGST == 0 &&  $dataPdf->CGST == 0){
						$content .='<tr>
							<td colspan="6" align="right"><strong>IGST </strong> </td>
							<td>'.number_format($dataPdf->IGST).'</td>
						</tr>';
					}else{
							$content .='<tr>
							<td colspan="6" align="right"><strong>CGST </strong> </td>
							<td>'.number_format($dataPdf->CGST).'</td></tr>
							<tr><td colspan="6" align="right"><strong>SGST </strong> </td>
							<td>'.number_format($dataPdf->SGST).'</td>
						</tr>';
					}
					$content .='<tr>
						<td colspan="6" align="right"><strong>Grand Total </strong> </td>
						<td>'.number_format($invoice_amount_details[0]->invoice_total_with_tax).'</td>
					</tr>';
				 }
		
					$number = $Total_amount_sum;
				   $no = round($number);
				   $point = round($number - $no, 2) * 100;
				   $hundred = null;
				   $digits_1 = strlen($no);
				   $i = 0;
				   $str = array();
				   $words = array('0' => '', '1' => 'One', '2' => 'Two',
					'3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
					'7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
					'10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
					'13' => 'Thirteen', '14' => 'Fourteen',
					'15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
					'18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
					'30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
					'60' => 'Sixty', '70' => 'Seventy',
					'80' => 'Eighty', '90' => 'Ninety');
				   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
				   while ($i < $digits_1) {
					 $divider = ($i == 2) ? 10 : 100;
					 $number = floor($no % $divider);
					 $no = floor($no / $divider);
					 $i += ($divider == 10) ? 1 : 2;
					 if ($number) {
						$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
						$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
						$str [] = ($number < 21) ? $words[$number] .
							" " . $digits[$counter] . $plural . " " . $hundred
							:
							$words[floor($number / 10) * 10]
							. " " . $words[$number % 10] . " "
							. $digits[$counter] . $plural . " " . $hundred;
					 } else $str[] = null;
				  }
				  $str = array_reverse($str);
				  $result = implode('', $str);
				  $points = ($point) ?
					"." . $words[$point / 10] . " " . 
						  $words[$point = $point % 10] : '';
			/* Calculation amount in words */
			$content .= '<tr><td colspan="7">Amount Chargeable(in Words)<br><b>'. $result . "Only".'</b></td></tr>';
			if($dataPdf->CGST != 0 &&  $dataPdf->CGST != 0){
			$content .= '<tr>
					<td align="center"  width="12%">HSN/SAC</td>
					<td align="center"  width="15.2%">Taxable value</td>
					<td align="center" colspan="2">Central Tax <br/>
					<table border = "1"><tr><td>Rate</td><td>Amount</td></tr></table></td><td align="center" colspan="2">State Tax <br/>
					<table border = "1"><tr><td>Rate</td><td>Amount</td></tr></table></td><td align="center">Total Tax Amount</td></tr>
					<tr>';
			}else{
				$content .= '<tr><td colspan="3" align="center">HSN/SAC</td><td align="center">Taxable <br> value</td>
			<td colspan="2" align="center">Integrated Tax <br/><table border = "1"><tr><td>Rate</td><td>Amount</td></tr></table></td><td align="center">Total Tax Amount</td></tr>
			<tr>';
			}
		$hsnsac_code = array();
			$taxable_sum1 = 0;
			$taxable_sum = 0;
			$total_tax_sum = 0;
			$total_tax_sum1 = 0;
			$Taxamount_total = 0;
			
			
			$materialDetaileee =  json_decode($dataPdf->descr_of_goods);
					foreach($materialDetaileee as $mat_val){
						
						$hsnsac_code = $mat_val->hsnsac;
						$mat_qty = $mat_val->quantity;
						$mat_rate = $mat_val->rate;
						$taxable_val = $mat_qty *  $mat_rate;
						$mat_tax = $mat_val->tax;
					    $total_ttax = $taxable_val * $mat_tax/100;
						$cgst_sgst = $total_ttax / 2;
						$cgst_sgst_tax = $mat_tax / 2;
						$total_tax_amount = $cgst_sgst * 2;
						$Taxamount_total += $cgst_sgst;
						
				if($dataPdf->CGST != 0 &&  $dataPdf->CGST != 0){	
						$content .='<tr>
						<td colspan="1" align="center">'.$hsnsac_code.'</td>
						<td align="center">'.number_format($taxable_val).'</td>
						<td align="center">'.$cgst_sgst_tax.'%</td>  
						<td align="center">'.number_format($cgst_sgst).'</td>
						<td align="center">'.$cgst_sgst_tax.'%</td>  
						<td align="center">'.number_format($cgst_sgst).'</td>
						<td align="center">'.number_format($total_tax_amount).'</td></tr>';
						
						$taxable_sum+= $taxable_val;
						$total_tax_sum+= $total_ttax;
					}else{
						
						$content .='<tr>
						<td colspan="3" align="center">'.$hsnsac_code.'</td>
						<td align="center">'.number_format($taxable_val).'</td>
						<td align="center">'.$mat_tax.'%</td>  
						<td align="center">'.number_format($total_ttax).'</td>
						<td align="center">'.number_format($total_ttax).'</td></tr>';
						
						$taxable_sum += $taxable_val;
						
					    $total_tax_sum += $total_ttax;
						
					}	
						
				}

				//For charges Details
				$data_charges_data = json_decode($dataPdf->charges_added,true);	
				$freight_taxable_amt = array();
				$total_charges_amt = 0;
				$freaight_tax_sum = 0;
				
				foreach($data_charges_data as $get_charge_data){
					$charge_name_val = getNameById('charges_lead',$get_charge_data['particular_charges_name'],'id');
					if($charge_name_val->type_charges == 'plus' && $get_charge_data['sgst_amt'] != '' &&  $get_charge_data['cgst_amt'] != ''){
						$charge_name_Data = getNameById('charges_lead',$get_charge_data['particular_charges_name'],'id');
					    $freight_taxable_amt = $get_charge_data['amt_with_tax'] - $get_charge_data['charges_added'];
						  $freight_amount_half += $freight_taxable_amt/2;
						  $freaight_tax_sum += $freight_taxable_amt;
						
						$total_charges_amt += $get_charge_data['charges_added'];
						$content .='<tr>
						<td colspan="1" align="center">'.$charge_name_Data->hsnsac.'</td>
						<td align="center">'.$get_charge_data['charges_added'].'</td>
						<td align="center">'.$get_charge_data['sgst_amt'].'%</td>  
						<td align="center">'.number_format($freight_taxable_amt/2).'</td>
						<td align="center">'.$get_charge_data['cgst_amt'].'%</td>  
						<td align="center">'.number_format($freight_taxable_amt/2).'</td>
						<td align="center">'.number_format($freight_taxable_amt).'</td></tr>';
					
					}else if($charge_name_val->type_charges == 'plus' && $get_charge_data['sgst_amt'] == '' &&  $get_charge_data['cgst_amt'] == ''){
						$charge_name_Data = getNameById('charges_lead',$get_charge_data['particular_charges_name'],'id');
					    $freight_taxable_amt = $get_charge_data['amt_with_tax'] - $get_charge_data['charges_added'];
						
						$total_charges_amt += $get_charge_data['charges_added'];
						$content .='<tr>
							<td colspan="3" align="center">'.$charge_name_Data->hsnsac.'</td>
							<td align="center">'.$get_charge_data['charges_added'].'</td>
							<td align="center">'.$get_charge_data['igst_amt'].'%</td>  
							<td align="center">'.number_format($freight_taxable_amt).'</td>
							<td align="center">'.number_format($freight_taxable_amt).'</td></tr>';
							
							 $freaight_tax_sum += $freight_taxable_amt;
							
						
					}
				}
		//die();	

				//condition if charges not Added
				if($freaight_tax_sum !=''){
					$freaight_tax_sum;
				}else{
					$freaight_tax_sum = 0;
				}
				
				if(!empty($freight_taxable_amt)){
					$charges_freight_total = $freight_amount_half;
				}else{
					$charges_freight_total = 0;
				}
				
				if(!empty($total_charges_amt)){
					$total_charges_amt;
				}else{
					$total_charges_amt = 0;
				}
				
				//condition if charges not Added
				
				
				
				
				//For charges Details 
			
			$content .='
				</tr>';
				if($dataPdf->CGST != 0 &&  $dataPdf->CGST != 0){
					
					$content .='<tr>
								<td colspan="1" align="Right">Total</td>
								<td align="center">'.number_format($taxable_sum + $total_charges_amt).'</td>
								<td align="center"></td>
								<td align="center" colspan="1">'.number_format($Taxamount_total  + $charges_freight_total).'</td>
								<td align="center"></td>
								<td align="center">'.number_format($Taxamount_total + $charges_freight_total).'</td>
								<td align="center">'.number_format($total_tax_sum + $freaight_tax_sum).'</td>
							</tr>';
				}else{
					$content .='<tr>
								<td colspan="3" align="Right">Total</td>
								<td align="center">'.number_format($taxable_sum + $total_charges_amt).'</td>
								<td align="center"></td>
								<td align="center">'.number_format($total_tax_sum + $freaight_tax_sum).'</td>
								<td align="center">'.number_format($total_tax_sum + $freaight_tax_sum).'</td>
							</tr>';

				}
			

					
				/* Calculation amount in words */
				/* Calculation amount in words */
				$number = $total_tax_sum + $freaight_tax_sum;
				   $no = round($number);
				   $point = round($number - $no, 2) * 100;
				   $hundred = null;
				   $digits_1 = strlen($no);
				   $i = 0;
				   $str = array();
				   $words = array('0' => '', '1' => 'One', '2' => 'Two',
					'3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
					'7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
					'10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
					'13' => 'Thirteen', '14' => 'Fourteen',
					'15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
					'18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
					'30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
					'60' => 'Sixty', '70' => 'Seventy',
					'80' => 'Eighty', '90' => 'Ninety');
				   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
				   while ($i < $digits_1) {
					 $divider = ($i == 2) ? 10 : 100;
					 $number = floor($no % $divider);
					 $no = floor($no / $divider);
					 $i += ($divider == 10) ? 1 : 2;
					 if ($number) {
						$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
						$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
						$str [] = ($number < 21) ? $words[$number] .
							" " . $digits[$counter] . $plural . " " . $hundred
							:
							$words[floor($number / 10) * 10]
							. " " . $words[$number % 10] . " "
							. $digits[$counter] . $plural . " " . $hundred;
					 } else $str[] = null;
				  }
				  $str = array_reverse($str);
				  $resulttax = implode('', $str);
				  $points = ($point) ?
					"." . $words[$point / 10] . " " . 
						  $words[$point = $point % 10] : '';
			/* Calculation amount in words */
			/* Calculation amount in words */
	
	
	
	
	
	
	
	
	
	
	
			$content .='<tr><td colspan="7">Tax Amount (in Words)<br><b>'. $resulttax . "Only".'</b></td></tr>
			
			<tr>
				<td colspan="2">Company PAN Card</td>
				<td colspan="5">'.$company_data->company_pan.'</td>
			</tr>
			<tr style="height:2000px">
                <td colspan="4"><h2><u> Declarations</u></h2>
					<p>'.$termandCondi.'</p>
				</td>
					<td class="align-bottom"  valign="bottom" colspan="3">
						<table>
							<tr>
								<td>
								Company`s Bank Details <br/>
								Bank Name           :  <strong>'.$company_data->bank_name.'<br></strong>
								A/c No              : <strong>'.$company_data->account_no.'<br></strong>
								Branch & IFS Code   : <strong>'.$company_data->account_ifsc_code.'<br></strong> 
								
								</td>
							</tr>
						</table>
						<td class="align-bottom"  valign="bottom" colspan="3" style="text-align:right;border:1px solid #ddd;">
				for '.$company_data->name.'<br><br><br><br><br>(Authorized Signatory)</td>
					</td>
						
			</tr>';
				
    
    $content .= '</table>'; 
//pre($content);die();
    	
	}

	$obj_pdf->writeHTML($content); 
	ob_end_clean();			
	 
	$obj_pdf->Output('sample.pdf', 'I');  
	
 
 ?> 