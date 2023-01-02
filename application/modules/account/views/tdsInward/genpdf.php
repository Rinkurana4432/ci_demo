<?php

   
//for($prnt = 1;$prnt<=2;$prnt++){
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// pre($obj_pdf);
// }
setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format

    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// $obj_pdf = new \TCPDF('P', 'pt', 'A4', true, 'UTF-8');	
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
    $obj_pdf->SetAutoPageBreak(TRUE, 2);
	// $obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$obj_pdf->SetTopMargin(1);	
    $obj_pdf->SetFont('helvetica', '', 9);
	
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	$company_data=getNameById('company_detail',$this->companyGroupId,'id');
	
	 
	$bank_info = json_decode($company_data->bank_details);
    $primarybnk  = $bank_info[0];
	
	
	$user_data=getNameById('user_detail',$_SESSION['loggedInUser']->u_id,'id');
	
	 $image = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	// $obj_pdf->Image($image,2,4,10,10,'PNG');
	// $imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	// $obj_pdf->Image($imagesign,2,4,10,10,'PNG');
//pre($company_data);die();
if($company_data->invoice_num_of_copies == 0){
	$print_no_copies = 3;
}else{
	$print_no_copies = $company_data->invoice_num_of_copies;
}
for($prnt = 1;$prnt<=$print_no_copies;$prnt++){
	
	
         if($prnt == 1){
			 $no_copies = '( ORIGINAL FOR RECIPIENT )';
		 }
		 if($prnt == 2){
			 $no_copies = '( DUPLICATE FOR TRANSPORTER )';
		 }
		 if($prnt == 3){
			 $no_copies = '( TRIPLICATE FOR SUPPLIER )';
		 }	 

    $obj_pdf->AddPage(); 
	 
	$content = '';
	$content1 = '';

	
	
	
	$party_ledger = getNameById('ledger',$dataPdf->party_name,'id');
	
	
	 
   $party_add = json_decode($party_ledger->mailing_address,true);
   
  
   
	   foreach ($party_add as $key => $detaild) {
		
			//if ($detaild['mailing_state'] == $dataPdf->party_state_id) {
			
				$mailing_address11 = $detaild['mailing_address'];
				$parrty_country_id = $detaild['mailing_country'];
				$mailing_city_id = $detaild['mailing_city'];
				$gstin_no = $detaild['gstin_no'];
			//}
	   }
	   
	 //die();
	
	$newDate = date("d-M-Y", strtotime($dataPdf->created_date));
	$buyer_order_date = date("d-M-Y", strtotime($dataPdf->buyer_order_date));
	if($buyer_order_date == '01-Jan-1970'){
		$buyer_order_date = '';
	}
	$dispatch_document_date = date("d-M-Y", strtotime($dataPdf->dispatch_document_date));
	if($dispatch_document_date == '01-Jan-1970'){
		$dispatch_document_date = '';
	}
	$datetime_issue_invoice = date("d-M-Y", strtotime($dataPdf->date_time_of_invoice_issue));
	$datetime_removal_goods = date("d/m/Y", strtotime($dataPdf->date_time_removel_of_goods));
	
	
	$party_ledger_purchaser = getNameById('state',$dataPdf->party_state_id,'state_id');
	$parrty_country_idd = getNameById('country',$parrty_country_id,'country_id');
	$parrty_city_idd = getNameById('city',$mailing_city_id,'city_id');
	
	$party_ledger_purchaser11 = $party_ledger_purchaser->state_name;
	
	
	
	
	$sale_address_details = json_decode($company_data->address,true);
	
	// pre($dataPdf);
	// die();
	foreach ($sale_address_details as $comapny_sale_address_ldger) {
		 
			if ($comapny_sale_address_ldger['add_id'] == $dataPdf->sale_lger_brnch_id) {
				$saleaddress = $comapny_sale_address_ldger['address'];
				$compny_branch_name = $comapny_sale_address_ldger['compny_branch_name'];
				$sale_country_id = $comapny_sale_address_ldger['country'];
				$parrty_state_id = $comapny_sale_address_ldger['state'];
				$sale_city_id = $comapny_sale_address_ldger['city'];
				$company_gstin = $comapny_sale_address_ldger['company_gstin'];
			
			}
	   }
	
	//echo $compny_branch_name;die();
	
	
	
	$mailing_city_for_jurdictions = getNameById('city',$sale_city_id,'city_id');
	
	$sale_ledger = getNameById('ledger',$dataPdf->sale_ledger,'id');
	
	if($sale_address_details != '' ){
		$mailing_state = getNameById('state',$parrty_state_id,'state_id');
		$mailing_country = getNameById('country',$sale_country_id,'country_id');
		$mailing_city = getNameById('city',$sale_city_id,'city_id');
		$statename = $mailing_state->state_name;
		$countryname = $mailing_country->country_name;
		$mailingcity = $mailing_city->city_name;
		
	}else{
		$statename = '';
		$countryname = '';
		$mailingcity = '';
		
	}
	
	
	
	
	if($dataPdf->eway_bill_no != '' && $dataPdf->eway_bill_no != '0' ){
		$content1 .='<span>e-Way bill No.'.$dataPdf->eway_bill_no.'</span>';
	}
	
	
	if($company_data->term_and_conditions == ''){
		$termandCondi = 'N/A';
	}else{
		$termandCondi = $company_data->term_and_conditions;
	}
	//Material Data into Array
	$materialDetail =  json_decode($dataPdf->descr_of_goods,true);	
	$data_charges_json = json_decode($dataPdf->charges_added,true);	
	
	$array_mrg = array_merge((array)$materialDetail,(array)$data_charges_json);
	
	
	
			$subTotal=0;
			$count=0;
			$mat_count = '';
			
		
		$divide = $count/4;
			
		
		// pre($sale_ledger_data);
		// die('fgf');  
		
		$after_divide =  round($divide);
		if($after_divide <=  1){
			$after_divide = 1;
		}
		
		if ( $count >= 0 ){  //If there are more than 0 terms
	
			$k =0;
			$sno = 1;
             for ($j = 0; $j < $after_divide; $j++){
				
	//$sale_ledger->name // Convert name Mailing Name by Maninder 
	//Header Content
	
    $content .= '<table>
				
					<tr>
						<td colspan="1"><img src="'.$image.'" alt="test alt attribute" width="60" height="50" border="0" ></td>
						<td colspan="10"><div><h4 align="center">Tax Invoice</h4><span style="text-align:right; font-size:7px;">'.$no_copies.'</span></div></td>
					</tr>
			</table>
		<table border="1" cellpadding="2">
			<tr>
				<td colspan="4" rowspan="4"><br><strong>'.$compny_branch_name.'</strong><br>'.$saleaddress.'<br><strong>GSTIN:</strong>'.$company_gstin.'<br>Country Name: '.$countryname.',<br>State Name: '.$statename.'<br>City Name: '.$mailingcity.'<br>Contact:  '.$sale_ledger->phone_no.','.$sale_ledger->mobile_no.'<br>Email:  '.$sale_ledger->email.'<br>Website:  '.$sale_ledger->website.'</td>
				<td colspan="2">'.$content1.'<strong><br>Invoice No:  </strong> &nbsp;<br/>'.$dataPdf->invoice_num.'</td>
				<td colspan="2"><strong>Dated</strong> &nbsp;<br/>'.$datetime_issue_invoice.'</td>
			</tr>
			<tr>
				
			</tr>
			<tr>
				<td colspan="2"><strong>Buyers Order No</strong> &nbsp;<br> '.$dataPdf->buyer_order_no.'</td>
				<td colspan="2"><strong>Date Time Issue of Invoice:</strong> &nbsp;<br> '.$datetime_issue_invoice.'</td>
			</tr>
			<tr>
				<td colspan="2"><strong>Dispatch Document No.</strong> &nbsp;<br/>'.$dataPdf->dispatch_document_no.'</td>
				<td colspan="2"><strong>Delivery Note Date.</strong> &nbsp; '.$dispatch_document_date.'</td>
			</tr>
			<tr>';
			
				$content .='<td colspan="4" rowspan="3"><strong>(Buyer bill to): </strong><br><strong>'.$party_ledger->name.'</strong><br>'.$mailing_address11.'<br><strong>GSTIN:</strong>'.$gstin_no.'<br>Country Name :  '.$parrty_country_idd->country_name.',<br/>State Name :  '.$party_ledger_purchaser11.',<br/>City :  '.$parrty_city_idd->city_name.'<br>Contact :  '.$party_ledger->phone_no.','.$party_ledger->mobile_no.'<br>Email :  '.$party_ledger->email.'<br>Website :  '.$party_ledger->website.'</td>';
			
			$content .='<td colspan="2"><strong>Transport</strong>&nbsp;<br/>'.$dataPdf->transport.' </td>
						<td colspan="2"><strong>Driver Mobile No.</strong>&nbsp;<br/>'.$dataPdf->transport_driver_pno.' </td>
			</tr>
			<tr>
				<td colspan="2"><strong>GR No & Date</strong>&nbsp;'.$dataPdf->gr_date.'</td>
				<td colspan="2"><strong>Motor Vehicle No.</strong>&nbsp;<br/>'.$dataPdf->vehicle_reg_no.' </td>
				
			</tr>
			<tr>
				<td colspan="4"><strong>Terms of Delivery</strong> &nbsp;<br>'.$dataPdf->message.'</td>
				
				
			</tr>
			
			
			
			<tr>
				<th width="30px"><strong>Sl No.</strong></th>
				<th width="110px"><strong>Particulars</strong></th>
				<th width="70px"><strong>HSN/SAC</strong></th>
				<th width="70px"><strong>QTY</strong></th>
				<th width="75px"><strong>Rate</strong></th>
				<th width="70px"><strong>Per</strong></th>
				<th width="86px"><strong>Total Amt.</strong></th>
			</tr></table>';
			
			
			//Items Details
			
			$materialDetail =  json_decode($dataPdf->descr_of_goods);																
			$subTotal=0;
			$no=1;
			$total_hsnsac_code_count = 0;
			$content .='<table border="1" cellpadding="2">';
				
				
				
			
		
				
				$content .= '<tr>
					<td  width="30px">'.$sno++.'</td>
					<td width="110px" >'.$sale_ledger->name.'</td>
					<td width="70px">'.$dataPdf->hsn_code.'</td>
					<td width="70px"></td>
					<td width="75px"></td>
					<td width="70px"></td>
					<td width="86px">'.	$dataPdf->added_amt.'</td>
				</tr>';
				$k++;
			
				
		
				
				 
					
				if($j == $after_divide-1){
					
					if(!empty($dataPdf)){ //when charges added
					
						  
						if($dataPdf->CGST == 0 &&  $dataPdf->CGST == 0){
							$content .= '<tr>						
								<td colspan="6" align="right"><strong>Sub Total  </strong> </td>
								<td>'.$dataPdf->added_amt.'</td>
							</tr>';	
							
							$content .='<tr>
								<td colspan="6" align="right"><strong>IGST </strong> </td>
								<td>'.$dataPdf->IGST.'</td>
							</tr>';
							
								$content .='<tr>
									<td colspan="6" align="right"><strong>Grand Total </strong> </td>
									<td>'.round($dataPdf->TotalWithTax).'</td>
								</tr>';
						}else{
							
							$content .= '<tr>						
							<td colspan="6" align="right"><strong>Sub Total </strong> </td>
							<td>'.$dataPdf->added_amt.'</td>
							</tr>';
						$content .='<tr>
							<td colspan="6" align="right"><strong>CGST </strong> </td>
							<td>'.$dataPdf->CGST.'</td></tr>
							<tr><td colspan="6" align="right"><strong>SGST </strong> </td>
							<td>'.$dataPdf->SGST.'</td>
							</tr>';
												
					
							
							$content .='<tr>
									<td colspan="6" align="right"><strong>Grand Total </strong> </td>
									<td>'.round($dataPdf->TotalWithTax).'</td>
								</tr>';
									
						}
						
						
				}else{//when Charges not added
					$content .= '<tr>						
						<td colspan="6" align="right"><strong>Sub Total </strong> </td>
						<td>'.$dataPdf->added_amt.'</td>
					</tr>';
					
					if($dataPdf->CGST == 0 &&  $dataPdf->CGST == 0){
						$content .='<tr>
							<td colspan="6" align="right"><strong>IGST </strong> </td>
							<td>'.$dataPdf->IGST.'</td>
						</tr>';
					}else{
							$content .='<tr>
							<td colspan="6" align="right"><strong>CGST </strong> </td>
							<td>'.$dataPdf->CGST.'</td></tr>
							<tr><td colspan="6" align="right"><strong>SGST </strong> </td>
							<td>'.$dataPdf->SGST.'</td>
						</tr>';
					}
				
					
					$content .='<tr>
							<td colspan="6" align="right"><strong>Grand Total </strong> </td>
							<td>'.round($dataPdf->TotalWithTax).'</td>
						</tr>';
						
						
				 }
			}	
				
				$sno = $sno-1; 
				/* Calculation amount in words */
				$number = $dataPdf->TotalWithTax;
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
			//<td colspan="2" align="center">Integrated Tax <br/><table border = "1"><tr><td>Rate</td><td>Amount</td></tr></table></td><td align="center">Total Tax Amount</td>
		if($j == $after_divide-1){
					
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
			
			
			
						$cgst_sgst_tax = $dataPdf->taxvalue / 2;
				if($dataPdf->CGST != 0 &&  $dataPdf->CGST != 0){	
						$content .='<tr>
						<td colspan="1" align="center">'.$dataPdf->hsn_code.'</td>
						<td align="center">'.$dataPdf->added_amt.'</td>
						<td align="center">'.$cgst_sgst_tax.'%</td>  
						<td align="center">'.$dataPdf->CGST.'</td>
						<td align="center">'.$cgst_sgst_tax.'%</td>  
						<td align="center">'.$dataPdf->CGST.'</td>
						<td align="center">'.$dataPdf->totaltaxAMT.'</td></tr>';
						
						$taxable_sum+= $dataPdf->added_amt;
						$total_tax_sum+= $total_ttax;
					}else{
						
						$content .='<tr>
						<td colspan="3" align="center">'.$dataPdf->hsn_code.'</td>
						<td align="center">'.$dataPdf->added_amt.'</td>
						<td align="center">'.$dataPdf->taxvalue.'%</td>  
						<td align="center">'.$dataPdf->totaltaxAMT.'</td>
						<td align="center">'.$dataPdf->totaltaxAMT.'</td></tr>';
						
						$taxable_sum += $dataPdf->added_amt;
						
					    $total_tax_sum += $dataPdf->totaltaxAMT;
						
					}
						
						

				$number = $total_tax_sum;
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
				
				
				
				
				//For charges Details 
			
			$content .='
				</tr>';
				if($dataPdf->CGST != 0 &&  $dataPdf->CGST != 0){
					
					$content .='<tr>
								<td colspan="1" align="Right">Total</td>
								<td align="center">'.$taxable_sum + $total_charges_amt.'</td>
								<td align="center"></td>
								<td align="center" colspan="1">'.$Taxamount_total  + $charges_freight_total.'</td>
								<td align="center"></td>
								<td align="center">'.$Taxamount_total + $charges_freight_total.'</td>
								<td align="center">'.$total_tax_sum + $freaight_tax_sum.'</td>
							</tr>';
					$content .='<tr><td colspan="7">Tax Amount (in Words)<br><b>'. $resulttax . "Only".'</b></td></tr>';		
				}else{
					$content .='<tr>
								<td colspan="3" align="Right">Total</td>
								<td align="center">'.$taxable_sum + $total_charges_amt.'</td>
								<td align="center"></td>
								<td align="center">'.$total_tax_sum + $freaight_tax_sum.'</td>
								<td align="center">'.$total_tax_sum + $freaight_tax_sum.'</td>
							</tr>';
				$content .='<tr><td colspan="7">Tax Amount (in Words)<br><b>'. $resulttax . "Only".'</b></td></tr>';			

				}
			
	}
	
		$content .='<tr>
				<td colspan="2">Company PAN Card</td>
				<td colspan="7">'.$company_data->company_pan.'</td>
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
				for '.$company_data->name.'<br><br><br>(Authorized Signatory)</td>
					</td>
						
			</tr>';
				
    
    $content .= '</table>';
	$content .='<table><tr rowspan="2"><td  align="center"> <br>SUBJECT TO <b style="text-transform:uppercase!important;">'.$mailing_city_for_jurdictions->city_name.'</b> JURISDICTION <br> This is Computer Generated Invoice </td></tr></table>';
	if($j != $after_divide-1){
		$content .='<table><tr><td colspan="6" align="right" >Continued.......</td></tr><tr><td style="display: block; page-break-before: always;" ></td></tr></table>';
	}
	$sno++;
	}	
}	
//$obj_pdf->writeHTML($content,'<tcpdf method="AddPage" />', true, 0, true, 0);
 $obj_pdf->writeHTML($content); 

}

    //$obj_pdf->writeHTML($content); 
	ob_end_clean();			
	// pre($content);
// die(); 
	$obj_pdf->Output('sample.pdf', 'I');   
	
 ?> 