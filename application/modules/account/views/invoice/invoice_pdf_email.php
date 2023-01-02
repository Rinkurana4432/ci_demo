<!DOCTYPE html>
<html lang="en">
  <head>


  <?php
  $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	$sale_ledger = getNameById('ledger',$dataPdf->sale_ledger,'id');
	$sale_ledger_data = json_decode($sale_ledger->mailing_address,true);
	$mailing_city_for_jurdictions = getNameById('city',$sale_ledger_data[0]['mailing_city'],'city_id');
	$party_ledger = getNameById('ledger',$dataPdf->party_name,'id');
	$party_add = json_decode($party_ledger->mailing_address,true);
   
	   foreach ($party_add as $key => $detaild) {
			if ($detaild['mailing_state'] == $dataPdf->party_state_id) {
				$mailing_address11 = $detaild['mailing_address'];
				$parrty_country_id = $detaild['mailing_country'];
				$mailing_city_id = $detaild['mailing_city'];
			}
	   }
	  
	
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
	
	
	if($sale_ledger_data[0]['mailing_state'] != '' || $sale_ledger_data[0]['mailing_country'] != '' || $sale_ledger_data[0]['mailing_city'] !=''){
		$mailing_state = getNameById('state',$sale_ledger_data[0]['mailing_state'],'state_id');
		$mailing_country = getNameById('country',$sale_ledger_data[0]['mailing_country'],'country_id');
		$mailing_city = getNameById('city',$sale_ledger_data[0]['mailing_city'],'city_id');
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

	$company_data=getNameById('company_detail',$this->companyGroupId,'id');
	
	$companyLogo = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$image = base_url().'assets/modules/company/uploads/'.$company_data->logo;
  ?>
    <meta charset="utf-8">
    <title><?php echo 'Invoice No : ' . $dataPdf->id;  ?></title>
  </head>
  <body>
		<header class="clearfix">
			<div id="logo">
				<table>
					<tr>
						<td colspan="1"><img src="<?php echo $companyLogo; ?> " alt="test alt attribute" width="60" height="50" border="0" ></td>
					</tr>
				</table>
			</div>
		</header>
    <main>
      <table cellpadding="2">
			<tr>
				<td colspan="8"><div><h4 align="center">Tax Invoice</h4></div></td>
			</tr>
			<tr>
				<td colspan="4" rowspan="4" style="border:1px solid #000; padding:3px;"><br><strong><?php echo $sale_ledger_data[0]['mailing_name']; ?></strong><br><?php echo $sale_ledger_data[0]['mailing_address'];?><br><strong>GSTIN:</strong><?php echo $sale_ledger->gstin; ?> <br>Country Name: <?php echo $countryname; ?>,<br>State Name: <?php echo $statename; ?> <br>City Name: <?php echo $mailingcity; ?> <br>Contact:  <?php echo $sale_ledger->phone_no.','.$sale_ledger->mobile_no; ?> <br>Email:  <?php echo $sale_ledger->email; ?><br>Website:  <?php echo $sale_ledger->website; ?></td>
				<td colspan="2" style="border:1px solid #000; padding:3px;"><?php echo $content1; ?> <strong><br>Invoice No:  </strong> &nbsp;<br/><?php echo $dataPdf->invoice_num; ?></td>
				<td colspan="2" style="border:1px solid #000; padding:3px;"><strong>Dated</strong> &nbsp;<br/><?php echo $datetime_issue_invoice; ?> </td>
			</tr>
			<tr> </tr>
			<tr>
				<td colspan="2" style="border:1px solid #000; padding:3px;"><strong>Buyers Order No</strong> &nbsp;<br> <?php echo $dataPdf->buyer_order_no; ?></td>
				<td colspan="2" style="border:1px solid #000; padding:3px;"><strong>Dated:</strong> &nbsp;<br> <?php echo $buyer_order_date; ?></td>
			</tr>
			<tr>
				<td colspan="2" style="border:1px solid #000; padding:3px;"><strong>Dispatch Document No.</strong> &nbsp;<br/><?php echo $dataPdf->dispatch_document_no; ?></td>
				<td colspan="2" style="border:1px solid #000; padding:3px;"><strong>Delivery Note Date.</strong> &nbsp; <?php echo $dispatch_document_date; ?> </td>
			</tr>
			<tr>
			<?php
				if($dataPdf->consignee_address != ''){
			?>
			  <td colspan="4" rowspan="3" style="border:1px solid #000; padding:3px;"><strong>Consignee Address:</strong>&nbsp;<br/><?php echo $dataPdf->consignee_address;?></td>
			<?php
				}else{
			?> 
			<td colspan="4" rowspan="3" style="border:1px solid #000; padding:3px;"><strong>Consignee Address : </strong><br><strong><?php echo $party_ledger->name; ?></strong><br><?php echo $mailing_address11; ?><br><strong>GSTIN:</strong>'<?php echo $party_ledger->gstin; ?><br>Country Name : <?php echo  $parrty_country_idd->country_name;?>,<br/>State Name :<?php echo $party_ledger_purchaser11;?>,<br/>City :<?php echo  $parrty_city_idd->city_name?>,<br>Contact : <?php echo $party_ledger->phone_no.','.$party_ledger->mobile_no; ?><br>Email :  <?php echo $party_ledger->email;?> <br>Website :  <?php echo $party_ledger->website;?></td>
			<?php } ?>
			<td colspan="2" style="border:1px solid #000; padding:3px;"><strong>Transport</strong>&nbsp;<br/><?php echo $dataPdf->transport;?> </td>
			<td colspan="2" style="border:1px solid #000; padding:3px;"><strong>Driver Mobile No.</strong>&nbsp;<br/><?php echo $dataPdf->transport_driver_pno;?> </td>
			</tr>
			<tr>
				<td colspan="2" style="border:1px solid #000; padding:3px;"><strong>GR No & Date</strong>&nbsp;<?php echo $dataPdf->gr_date; ?></td>
				<td colspan="2" style="border:1px solid #000; padding:3px;"><strong>Motor Vehicle No.</strong>&nbsp;<br/><?php echo $dataPdf->vehicle_reg_no;?></td>
				
			</tr>
			<tr>
				<td colspan="2" style="border:1px solid #000; padding:3px;"><strong>Date Time Issue of Invoice</strong> &nbsp;<br><?php echo $datetime_issue_invoice; ?></td>
				<td colspan="2" style="border:1px solid #000; padding:3px;"><strong>Date Time Removal of Goods</strong> &nbsp;<br><?php echo $datetime_removal_goods; ?></td>
			</tr>
			<tr>
				<td colspan="4" rowspan="1" style="border:1px solid #000; padding:3px;"><strong>Consignee Address : </strong><br><strong><?php echo $party_ledger->name;?> </strong><br><?php echo $mailing_address11;?> <br><strong>GSTIN:</strong><?php echo $party_ledger->gstin;?> <br>Country Name : <?php echo $parrty_country_idd->country_name;?>,<br/>State Name :<?php echo $party_ledger_purchaser11;?> ,<br/>City :  <?php echo $parrty_city_idd->city_name; ?> <br>Contact : <?php echo $party_ledger->phone_no.','.$party_ledger->mobile_no;?> <br>Email :  <?php echo $party_ledger->email; ?><br>Website :  <?php echo $party_ledger->website;?> </td>
				<td colspan="6" style="border:1px solid #000; padding:3px;"><strong>Terms Of Delivery </strong> &nbsp;<br><?php echo $dataPdf->terms_of_delivery;?> </td>
		   </tr>
		   <tr style="border:1px solid #000; padding:3px;">
				<th width="30px" style="border:1px solid #000; padding:3px;"><strong>Sl No.</strong></th>
				<th width="110px" style="border:1px solid #000; padding:3px;"><strong>Description of Goods</strong></th>
				<th width="70px" style="border:1px solid #000; padding:3px;"><strong>HSN/SAC</strong></th>
				<th width="70px" style="border:1px solid #000; padding:3px;"><strong>QTY</strong></th>
				<th width="75px" style="border:1px solid #000; padding:3px;"><strong>Rate</strong></th>
				<th width="70px" style="border:1px solid #000; padding:3px;"><strong>Per</strong></th>
				<th width="86px" style="border:1px solid #000; padding:3px;"><strong>Total Amt.</strong></th>
			</tr>
		<?php
			$materialDetail =  json_decode($dataPdf->descr_of_goods);																
			$subTotal=10;
			$no=1;
			foreach($materialDetail as $material_detail){
					$material_id=$material_detail->material_id;
					$materialName=getNameById('material',$material_id,'id');	
					$subtotal = $material_detail->rate * $material_detail->quantity;
					$uomname = getNameById('uom',$material_detail->UOM,'id');
				 	$totalBasePrice+=$material_detail->quantity * $material_detail->rate;

		?>			
			<tr>
					<td  width="30px" style="border:1px solid #000; padding:3px;"><?php echo $no++;?></td>
					<td width="110px" style="border:1px solid #000; padding:3px;" ><?php echo $materialName->material_name;?> <br/><span style="font-size:8px;margin-lefft:20px;">
					<?php echo $material_detail->descr_of_goods;?> </span></td>
					<td width="70px" style="border:1px solid #000; padding:3px;"><?php echo $material_detail->hsnsac; ?> </td>
					<td width="70px" style="border:1px solid #000; padding:3px;"><?php echo $material_detail->quantity;?></td>
					<td width="75px" style="border:1px solid #000; padding:3px;"><?php echo $material_detail->rate;?></td>
					<td width="70px" style="border:1px solid #000; padding:3px;"><span style="font-size:11px !important;"><?php echo $uomname->ugc_code; ?> </span></td>
					<td width="86px" style="border:1px solid #000; padding:3px;"><?php echo	money_format('%!i',$material_detail->quantity * $material_detail->rate); ?></td>
				</tr>
		<?php	}
				$invoice_amount_details =  json_decode($dataPdf->invoice_total_with_tax);
				$data_charges_for_taxes = json_decode($dataPdf->charges_added,true);
				$ttotal_Amount_with_charges = 0;
				$carges_taxx_igst = 0;
				$grand_total_with_tax = array();
				$grand_total_charges_invoice_tax_half = array();
				foreach($data_charges_for_taxes as $tax_val){
					$charge_name_val = getNameById('charges_lead',$tax_val['particular_charges_name'],'id');?>
						<tr>
					<td  width="30px" style="border:1px solid #000; padding:3px;"><?php echo $no++;?></td>
					<td width="110px" style="border:1px solid #000; padding:3px;" ><?php echo $charge_name_val->particular_charges;?> <br/></td>
					<td width="70px" style="border:1px solid #000; padding:3px;"><?php echo $charge_name_val->hsnsac; ?> </td>
					<td width="70px" style="border:1px solid #000; padding:3px;"><?php echo 1;?></td>
					<td width="75px" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$tax_val['charges_added']);?></td>
					<td width="70px" style="border:1px solid #000; padding:3px;"><span style="font-size:11px !important;"><?php echo money_format('%!i',$tax_val['charges_added']);?></span></td>
					<td width="86px" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$tax_val['charges_added']);?></td>
				</tr><?php
					if($charge_name_val->type_charges == 'plus' && $tax_val['sgst_amt'] == '' && $tax_val['cgst_amt'] == ''){
						//IGST
						$ttotal_Amount_with_charges +=  $tax_val['charges_added'];
						 $Charges_tax = $tax_val['amt_with_tax'] - $tax_val['charges_added'];
						 
						 $carges_taxx_igst += $Charges_tax;
					}else if($charge_name_val->type_charges == 'plus' && $tax_val['sgst_amt'] != '' && $tax_val['cgst_amt'] != ''){//CGST SGST
						 $ttotal_Amount_with_charges += $tax_val['charges_added'];
						$carges_taxx = $tax_val['amt_with_tax'] - $tax_val['charges_added'];
						$grand_total_charges_invoice_tax += $carges_taxx;
						 $grand_total_with_tax =  $ttotal_Amount_with_charges + $carges_taxx;
						//echo '<br/>';
					}
				}?>

				
			<?php	/* Calculation For CGST and SGST*/
					$invoice_total_tax_cgst_sgst = $dataPdf->CGST + $dataPdf->SGST;
				    $totalTax22 = $grand_total_charges_invoice_tax + $invoice_total_tax_cgst_sgst;
				    $grand_total_charges_invoice_tax_half = $totalTax22/2;

					/* Calculation For CGST and SGST*/ 
					//die();
						if(!empty($data_charges_for_taxes)){ //when charges added
						 $subtotal_with_charges = $ttotal_Amount_with_charges + $invoice_amount_details[0]->total;
						if($dataPdf->CGST == 0 &&  $dataPdf->CGST == 0){
						?>	
						<tr>
							<td colspan="6" align="right" style="border:1px solid #000; padding:3px;" ><strong>Total </strong> </td>
							<td style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',($ttotal_Amount_with_charges + $totalBasePrice ));?></td>
						</tr>
							<tr>						
								<td colspan="6" align="right" style="border:1px solid #000; padding:3px;"><strong>Sub Total </strong> </td>
								<td style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$subtotal_with_charges); ?> </td>
							</tr>
						<?php 	
							$invoice_tax = $dataPdf->IGST;
							$total_igst = $carges_taxx_igst + $invoice_tax;
						?>	
							<tr>
								<td colspan="6" align="right" style="border:1px solid #000; padding:3px;"><strong>IGST </strong> </td>
								<td style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$total_igst); ?></td>
							</tr>
						<?php 	
							if($invoice_amount_details[0]->cess_all_total != '' || $invoice_amount_details[0]->cess_all_total != 0){
						?>		
								<tr>
								<td colspan="6" align="right" style="border:1px solid #000; padding:3px;"><strong>CESS </strong> </td>
								<td style="border:1px solid #000; padding:3px;"> <?php echo money_format('%!i',$invoice_amount_details[0]->cess_all_total);?></td>
							</tr>';
						<?php
						}
						$Total_amount_sum = $subtotal_with_charges + $total_igst + $invoice_amount_details[0]->cess_all_total;
						?>
						<tr>
							<td colspan="6" align="right" style="border:1px solid #000; padding:3px;"><strong>Grand Total </strong> </td>
							<td style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$Total_amount_sum);?></td>
						</tr>
								
					<?php 			
						}else{
							
						?>
						<tr>
							<td colspan="6" align="right" style="border:1px solid #000; padding:3px;" ><strong>Total </strong> </td>
							<td style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',($ttotal_Amount_with_charges + $totalBasePrice ));?></td>
						</tr>
						<tr>
							<td colspan="6" align="right" style="border:1px solid #000; padding:3px;" ><strong>Sub Total </strong> </td>
							<td style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$subtotal_with_charges);?></td>
						</tr>
						<tr>
							<td colspan="6" align="right" style="border:1px solid #000; padding:3px;"><strong>CGST </strong> </td>
							<td style="border:1px solid #000; padding:3px;"<?php echo money_format('%!i',$grand_total_charges_invoice_tax_half);?></td>
						</tr>
						<tr>
							<td colspan="6" align="right" style="border:1px solid #000; padding:3px;"><strong>SGST </strong> </td>
							<td style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$grand_total_charges_invoice_tax_half);?> </td>
						</tr>
						<?php 
							if($invoice_amount_details[0]->cess_all_total != '' || $invoice_amount_details[0]->cess_all_total != 0){
						?>		
						<tr>
							<td colspan="6" align="right" style="border:1px solid #000; padding:3px;"><strong>CESS </strong> </td>
							<td style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$invoice_amount_details[0]->cess_all_total);?></td>
						</tr>
						<?php
						}
							$Total_amount_sum = $subtotal_with_charges + $totalTax22 + $invoice_amount_details[0]->cess_all_total;
						?>	
						<tr>
							<td colspan="6" align="right" style="border:1px solid #000; padding:3px;"><strong>Grand Total </strong> </td>
							<td style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$Total_amount_sum);?></td>
						</tr>
					<?php					
					}
					}else{//when Charges not added
					?>
					<tr>						
						<td colspan="6" align="right" style="border:1px solid #000; padding:3px;"><strong>Sub Total </strong> </td>
						<td style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$invoice_amount_details[0]->total); ?></td>
					</tr>
					<?php 
						if($dataPdf->CGST == 0 &&  $dataPdf->CGST == 0){
					?>	
						<tr>
							<td colspan="6" align="right" style="border:1px solid #000; padding:3px;"><strong>IGST </strong> </td>
							<td style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$dataPdf->IGST);?></td>
						</tr>
					<?php 
					}else{
					?>	
						<tr>
							<td colspan="6" align="right" style="border:1px solid #000; padding:3px;"><strong>CGST </strong> </td>
							<td style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$dataPdf->CGST);?></td>
						</tr>
							<tr>
							<td colspan="6" align="right" style="border:1px solid #000; padding:3px;"><strong>SGST </strong> </td>
							<td style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$dataPdf->SGST); ?></td>
						</tr>
				<?php } ?>
					<tr>
						<td colspan="6" align="right" style="border:1px solid #000; padding:3px;"><strong>Grand Total </strong> </td>
						<td style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$invoice_amount_details[0]->invoice_total_with_tax);?></td>
					</tr>
			<?php } 
			
			$sno = $sno-1; 
				/* Calculation amount in words */
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
			?>
			
				<tr><td colspan="7" style="border:1px solid #000; padding:3px;">Amount Chargeable(in Words)<br><b><?php echo  $result;?> Only</b></td></tr>
			<?php 	
				if($dataPdf->CGST != 0 &&  $dataPdf->CGST != 0){
			?>	
				<tr>
					<td align="center"  width="12%" style="border:1px solid #000; padding:3px;">HSN/SAC</td>
					<td align="center"  width="15.2%" style="border:1px solid #000; padding:3px;">Taxable value</td>
					<td align="center" colspan="2" style="border:1px solid #000; padding:3px;">Central Tax <br/>
					<table border = "1"><tr><td>Rate</td><td>Amount</td></tr></table></td><td align="center" colspan="2">State Tax <br/>
					<table border = "1"><tr><td>Rate</td><td>Amount</td></tr></table></td><td align="center">Total Tax Amount</td>
					</tr>
					<tr>
			<?php 
				}else{
			?>		
				<tr>
				<td colspan="3" align="center" style="border:1px solid #000; padding:3px;">HSN/SAC</td>
				<td align="center" style="border:1px solid #000; padding:3px;">Taxable <br> value</td>
				<td colspan="2" align="center" style="border:1px solid #000; padding:3px;">Integrated Tax <br/>
					<table border = "1"><tr><td>Rate</td><td>Amount</td></tr>
					</table>
				</td>
				<td align="center" style="border:1px solid #000; padding:3px;">Total Tax Amount</td></tr>
			<tr>
		<?php	}

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
			?>			
				<tr>
						<td colspan="1" align="center" style="border:1px solid #000; padding:3px;"><?php echo $hsnsac_code; ?></td>
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$taxable_val); ?></td>
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $cgst_sgst_tax; ?>%</td>  
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$cgst_sgst); ?></td>
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo$cgst_sgst_tax; ?> %</td>  
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$cgst_sgst); ?> </td>
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$total_tax_amount);?></td>
						</tr>
				<?php 		
						$taxable_sum+= $taxable_val;
						$total_tax_sum+= $total_ttax;
					}else{
				?>		
					<tr>
						<td colspan="3" align="center" style="border:1px solid #000; padding:3px;"><?php echo $hsnsac_code; ?></td>
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$taxable_val); ?></td>
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $mat_tax; ?> %</td>  
						<td align="center" style="border:1px solid #000; padding:3px;" ><?php echo money_format('%!i',$total_ttax);?></td>
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$total_ttax);?></td></tr>
				<?php 		
					$taxable_sum += $taxable_val;
					$total_tax_sum += $total_ttax;
			}
		}
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
					?>	
						<tr>
						<td colspan="1" align="center" style="border:1px solid #000; padding:3px;"><?php echo $charge_name_Data->hsnsac; ?></td>
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $get_charge_data['charges_added']; ?></td>
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $get_charge_data['sgst_amt']; ?>%</td>  
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$freight_taxable_amt/2);?></td>
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $get_charge_data['cgst_amt'];?>%</td>  
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$freight_taxable_amt/2); ?></td>
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$freight_taxable_amt); ?></td></tr>
				<?php	
					}else if($charge_name_val->type_charges == 'plus' && $get_charge_data['sgst_amt'] == '' &&  $get_charge_data['cgst_amt'] == ''){
						$charge_name_Data = getNameById('charges_lead',$get_charge_data['particular_charges_name'],'id');
					    $freight_taxable_amt = $get_charge_data['amt_with_tax'] - $get_charge_data['charges_added'];
						
						$total_charges_amt += $get_charge_data['charges_added'];
					?>	
							<tr>
							<td colspan="3" align="center" style="border:1px solid #000; padding:3px;"><?php echo $charge_name_Data->hsnsac; ?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $get_charge_data['charges_added']; ?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $get_charge_data['igst_amt']; ?>%</td>  
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$freight_taxable_amt);?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$freight_taxable_amt);  ?></td></tr>
				<?php 			
							 $freaight_tax_sum += $freight_taxable_amt;
					}
				}
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
			?>	
			</tr>
			<?php
				if($dataPdf->CGST != 0 &&  $dataPdf->CGST != 0){
			?>		
				<tr>
					<td colspan="1" align="Right" style="border:1px solid #000; padding:3px;">Total</td>
					<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$taxable_sum + $total_charges_amt); ?> </td>
					<td align="center" style="border:1px solid #000; padding:3px;"></td>
					<td align="center" colspan="1" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$Taxamount_total  + $charges_freight_total);?></td>
					<td align="center" style="border:1px solid #000; padding:3px;"></td>
					<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$Taxamount_total + $charges_freight_total); ?></td>
					<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$total_tax_sum + $freaight_tax_sum);?></td>
				</tr>
					<tr><td colspan="7" style="border:1px solid #000; padding:3px;">Tax Amount (in Words)<br><b><?php echo $resulttax; ?> Only </b></td></tr>		
			<?php	
				}else{
			?>		
					<tr>
						<td colspan="3" align="Right" style="border:1px solid #000; padding:3px;">Total</td>
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$taxable_sum + $total_charges_amt);?> </td>
						<td align="center" style="border:1px solid #000; padding:3px;"></td>
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$total_tax_sum + $freaight_tax_sum);?></td>
						<td align="center" style="border:1px solid #000; padding:3px;"><?php echo money_format('%!i',$total_tax_sum + $freaight_tax_sum);?></td>
					</tr>
					<tr><td colspan="7" style="border:1px solid #000; padding:3px;">Tax Amount (in Words)<br><b><?php echo $resulttax; ?> Only</b></td></tr>			
			<?php } ?>
			<tr>
				<td colspan="2" style="border:1px solid #000; padding:3px;">Company PAN Card</td>
				<td colspan="5" style="border:1px solid #000; padding:3px;"><?php echo $company_data->company_pan; ?></td>
			</tr>
			<tr style="height:2000px">
                <td colspan="4" style="border:1px solid #000; padding:3px;"><h2><u> Declarations</u></h2>
					<p><?php echo $termandCondi; ?></p>
				</td>
					<td class="align-bottom"  valign="bottom" colspan="3" style="border:1px solid #000; padding:3px;">
						<table>
							<tr>
								<td>
								Company`s Bank Details <br/>
								Bank Name           :  <strong><?php echo $company_data->bank_name;?> <br></strong>
								A/c No              : <strong><?php echo $company_data->account_no; ?><br></strong>
								Branch & IFS Code   : <strong><?php echo $company_data->account_ifsc_code; ?><br></strong> 
								
								</td>
							</tr>
						</table>
						<td class="align-bottom"  valign="bottom" colspan="3" style="text-align:right;border:1px solid #ddd;">for<?php echo $company_data->name;?><br><br><br>(Authorized Signatory)</td>
					</td>
						
			</tr>	  
		</table>
		<table><tr rowspan="2"><td  align="center"> <br>SUBJECT TO <b style="text-transform:uppercase!important;"><?php echo  $mailing_city_for_jurdictions->city_name; ?></b> JURISDICTION <br> This is Computer Generated Invoice </td></tr></table>
		
		</main>
    <footer>
    </footer>
  </body>
</html>
