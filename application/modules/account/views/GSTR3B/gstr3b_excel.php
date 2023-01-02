<?php
 //ob_end_clean(); 

$filename = "gstr3b" . ".xls"; 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");

?>
<div class="x_content">
<?php
	setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
	
	?>
	
	<p class="text-muted font-13 m-b-30"></p> 
	
   

 <div id="print_div_content" style="margin-top:40px;">
 <?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ; 
	$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');
	
	$company_dtls = getNameById('company_detail',$this->companyGroupId,'id');
	?>
	<center><table class="comp_name"> <tr><td><b style="font-size:18px;"><?php echo $company_brnaches->name; ?></b> <br/><br/><b> GSTR 3B</b></td></tr></table></center>
	<center><b>FORMGSTR-3B</b><br/>[see rule 61 (5) ]</center><br/>
	        <table class="table table-striped table-bordered" border="1" cellpadding="3" style="width:100%">
			     <tr><th>1</th><th>GSTIN</th><th><?php echo $company_dtls->gstin; ?></th><td>Year	</td><td></td></tr>
			     <tr><th>2</th><th>Legal Name of the registered person</th><th><?php echo $company_dtls->name; ?></th><td>Month</td><td></td></tr>
			     
			</table>
			<br/>
			<b>3.1 Details of Outward supplies and inward supplies liable to reverse charge.</b>
	

<br/><br/>
		<?php 
		$SaleTaxableValueTotal = $SaleTax =  $taxCGST = $taxSGST = $SaleTaxableValueTotalZero = $taxCGSTZero = $SaleTaxZero = $taxSGSTZero = $totalCessAmtZero = 0;
		foreach($Sale_Data as $getdat){
			if($getdat['totaltax_total'] != '0.00'){ // Other Than Nil Rated
				$SaleTaxableValue = json_decode($getdat['invoice_total_with_tax']);
				$SaleTaxableValueTotal += $SaleTaxableValue[0]->total;
				if($getdat['CGST'] == '0.00' &&  $getdat['CGST'] == '0.00'){
					$SaleTax += $getdat['IGST'];
				}else{
					$taxCGST += $getdat['CGST'];
					$taxSGST += $getdat['SGST'];
				}
				$CessAmountdata = json_decode($getdat['descr_of_goods']);
				$totalCessAmt = 0;
				foreach($CessAmountdata as $cessAmt){
					$totalCessAmt += $cessAmt->cess;
				}
			}
			if($getdat['totaltax_total'] == '0.00'){ // Zero  Rated
				$SaleTaxableValuezero = json_decode($getdat['invoice_total_with_tax']);
				$SaleTaxableValueTotalZero += $SaleTaxableValuezero[0]->total;
				if($getdat['CGST'] == '0.00' &&  $getdat['CGST'] == '0.00'){
					$SaleTaxZero += $getdat['IGST'];
				}else{
					$taxCGSTZero += $getdat['CGST'];
					$taxSGSTZero += $getdat['SGST'];
				}
				$CessAmountdataZero = json_decode($getdat['descr_of_goods']);
				$totalCessAmtZero = 0;
				foreach($CessAmountdataZero as $cessAmtzero){
					$totalCessAmtZero += $cessAmtzero->cess;
				}
			}
	}
	
	
	//Voucher RCM DATA
	foreach($voucher_data as $voucherDATA){
		$RCMDATA = json_decode($voucherDATA['credit_debit_party_dtl']);
		
		foreach($RCMDATA as $vald){
			$LedgerDtl = getNameById('ledger',$vald->credit_debit_party_dtl,'id');
				if($LedgerDtl->enble_disbl_rcm == 1){
					$datatt = json_decode($voucherDATA['credit_debit_party_dtl']);
					$taxx = 0;
					foreach($datatt as $datavoucher){
						$LedgerDtltt = getNameById('ledger',$datavoucher->credit_debit_party_dtl,'id');
						if($datavoucher->credit_debit_party_dtl <=50){
							$taxx +=  $datavoucher->debit_1 + $datavoucher->credit_1;
						}
						
					}
					$mailing_addressdata = json_decode($LedgerDtl->mailing_address);
					
					$RCM_ledger_State_id = $mailing_addressdata[0]->mailing_state;
					$companyStateID = $voucherDATA->company_state_id;
					
					if($RCM_ledger_State_id != $companyStateID){
						$TotalTax = $taxx;
					}else{
						$TotalTaxCGSTSGST = $taxx/2;
					}
				
					 $taxableValue += (int)$datavoucher->credit_1  -  (int)$taxx;
					
				}
		}
		
	}
		
		?>
			
			 <table class="table table-striped table-bordered" border="1" id="sec_tbl"cellpadding="3" style="width:100%">
			 <thead>
			    <tr>
					<th class="text-center">Nature of supplies</th>
					<th class="text-center">Total Tax Value</th>
					<th class="text-center">Integrated Tax</th>
					<th class="text-center">Central Tax</th>
					<th class="text-center">State/UT Tax</th>
					<th class="text-center">Cess</th>
				</tr>

				</thead>
				<tbody> 
				<tr>
				  <td>(a) Outward Taxable supplies(other than zero rated,nil rated and exempted)</td>
				  <td class="text-center"><?php echo money_format('%!i',$SaleTaxableValueTotal); ?></td>
				  <td class="text-center"><?php echo money_format('%!i',$SaleTax); ?></td>
				  <td class="text-center"><?php echo money_format('%!i',$taxCGST);  ?></td>
				  <td class="text-center"><?php echo money_format('%!i',$taxSGST);  ?></td>
				  <td class="text-center"><?php echo money_format('%!i',$totalCessAmt);  ?></td>
				</tr>
				<tr>
					<td>(b) Outward taxable supplies (Zero rated)</td>
					<td class="text-center"><?php echo money_format('%!i',$SaleTaxableValueTotalZero); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$SaleTaxZero); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$taxCGSTZero); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$taxSGSTZero); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$totalCessAmtZero); ?></td>
				</tr>
			    <tr>
					<td>(c) Other Outward supplies(Nil rated exempted)</td>
					<td class="text-center">0.00</td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
				</tr>
				<tr>
					<td>(d) In word supplies (liable to reverse charge)</td>
					<td class="text-center"><?php echo money_format('%!i',$taxableValue); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$TotalTax); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$TotalTaxCGSTSGST); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$TotalTaxCGSTSGST); ?></td>
					<td class="text-center">0.00</td>
				</tr>
				<tr>
					<td>(e) Non-GST outward supplies </td>
					<td class="text-center"><?php echo money_format('%!i',$total_amountof_supplies); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$integrated_tax_sumof_supplies); ?></td>
					<td class="text-center"><?php echo money_format('%!i',@$divide_cgst_sgstof_sums); ?></td>
					<td class="text-center"><?php echo money_format('%!i',@$divide_cgst_sgstof_sums); ?></td>
					<td class="text-center"></td>
				</tr>
				</tbody> 
			 </table>
			 <br/><br/><br/><br/><br/><br/>
			 <b>3.2 Of the Supplies shown in 3.1 above,details of inter-state supplies made to unregistered persons,composition taxable persons and UIN holders</b>
			  <table class="table table-striped table-bordered" border="1" cellpadding="3"   style="width:100%">
			   <thead>
			    <tr>
				    <th></th>
					<th class="text-center">Place of Supply (State/UT)</th>
					<th class="text-center">Total Taxable Value</th>
					<th class="text-center">Amount of Integrated Tax</th>
				</tr>
				</thead>
				<tbody> 
				
			 <?php 
				$taxxableVal = $taxTotalCoposiition =  $taxxableValCoposiition = $taxTotal = 0;
				
					foreach($Sale_Data as $getdatunrigisted){
						$LedgerDtlun = getNameById('ledger',$getdatunrigisted['party_name'],'id');
						$ledgerstateID = json_decode($LedgerDtlun->mailing_address);
						 if($getdatunrigisted['gstin'] == '' && $getdatunrigisted['IGST'] != '0.00'){
							$taxxableVal += (float)$getdatunrigisted['total_amount'] - (float)$getdatunrigisted['totaltax_total'];
							$taxTotal += (float)$getdatunrigisted['totaltax_total'];
						 }
						 if($getdatunrigisted['gstin'] != '' && $getdatunrigisted['IGST'] != '0.00'){
							$taxxableValCoposiition += (float)$getdatunrigisted['total_amount'] - (float)$getdatunrigisted['totaltax_total'];
							$taxTotalCoposiition += (float)$getdatunrigisted['totaltax_total'];
						 }
					}	
				?>
					<tr>
					  <td>Supplies made to Unregistered Persons</td>
					  <td class="text-center"><?php //echo $party_state_name->state_name; ?></td>
					  <td class="text-center"><?php echo money_format('%!i',$taxxableVal); ?></td>
					  <td class="text-center"><?php echo money_format('%!i',$taxTotal); ?></td>
				 	</tr>
					 
				
				<tr>
					  <td>Supplies made to Composition Taxable Persons</td>
					  <td class="text-center"></td>
					  <td class="text-center"><?php echo money_format('%!i',$taxxableValCoposiition); ?></td>
					  <td class="text-center"><?php echo money_format('%!i',$taxTotalCoposiition); ?></td>
				 	</tr>
					<tr>
					  <td>Supplies made to UIN holders</td>
					  <td class="text-center"></td>
					  <td class="text-center"></td>
					  <td class="text-center"></td>
				 	</tr>
				</tbody> 
			 </table>
			 <br></br/>
			 <!-- For Eligible ITC -->
			 <?php 
					$totalIGST = $totalCGSTSGST = $TOTALIGST11 = $TOTALCGST = $TOTALSGST = 0;
					foreach($Purchase_Data as $get_elgible_itc){//For Purchase DATA 
						$PurLedgerDtl = getNameById('ledger',$get_elgible_itc['supplier_name'],'id');	
						$ledgerCountry = json_decode($PurLedgerDtl->mailing_address);
						if($ledgerCountry[0]->mailing_country != '101'){
							$totalIGST = $get_elgible_itc['totaltax_total'];
							$totalcess = json_decode($get_elgible_itc['descr_of_bills']);
							$totalGrdCSS = 0;
							foreach($totalcess as $ttlcss){
								$totalGrdCSS += $ttlcss->cess;
								
							}
						}else{
							if($get_elgible_itc['party_billing_state_id'] != $get_elgible_itc['sale_company_state_id'] ){
								$TOTALIGST11 += $get_elgible_itc['IGST'];
							}else{
								$TOTALCGST += $get_elgible_itc['CGST'];
								$TOTALSGST += $get_elgible_itc['SGST'];
							}	
						}	
						
								
						
						
					}
			
			$igstTax = $CGSTTAX = $SGSTTAX = 0;
			foreach($tdsServices as $tdsval){
					if($tdsval['IGST'] !=''){
						$igstTax += $tdsval['IGST'];
					}elseif($tdsval['CGST'] !='' && $tdsval['SGST'] !=''){
						$CGSTTAX += $tdsval['CGST'];
						$SGSTTAX += $tdsval['SGST'];
					}
					
				}				
							
			$totalAMINUSB = 	$totalIGST + $igstTax + $TotalTax + $TOTALIGST11;	
			$totalAMINUSB_2 = 	$totalCGSTSGST + $CGSTTAX + $TotalTaxCGSTSGST + $TOTALCGST;
			$totalAMINUSB_3 =   $totalCGSTSGST + $SGSTTAX + $TotalTaxCGSTSGST + $TOTALSGST;
			 ?>
			 <!-- For Eligible ITC -->
			 
			 <b>4 Eligible ITC</b>
			 <table class="table table-striped table-bordered" border="1" cellpadding="3" id="tbl_forth" style="width:100%">
			  <thead>
			   
			    <tr>
				    <th class="text-center">Details</th>
					<th class="text-center">Integrated Tax</th>
					<th class="text-center">Central Tax</th>
					<th class="text-center">State/UT Tax</th>
					<th class="text-center">CESS</th>
				</tr>
			 </thead>
              <tbody> 			 
				<tr>
					<th class="text-center">1</th>
					<th class="text-center">2</th>
					<th class="text-center">3</th>
					<th class="text-center">4</th>
					<th class="text-center">5</th>
				</tr>
				<tr>
				  <td>(A) ITC Available (whether in full or part)</td>
				  <td class="text-center"></td>
				  <td class="text-center"></td>
				  <td class="text-center"></td>
				  <td class="text-center"></td>
				</tr>
				
				<tr>
					<td>(1) Import of goods</td>
					<td class="text-center"><?php echo money_format('%!i',$totalIGST); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$totalCGSTSGST); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$totalCGSTSGST); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$totalGrdCSS); ?></td>
				</tr>
			    <tr>
					<td>(2) Import of services</td>
					<td class="text-center"><?php echo money_format('%!i',$igstTax); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$CGSTTAX); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$SGSTTAX); ?></td>
					<td class="text-center">0.00</td>
				</tr>
				<tr>
					<td>(3) Inward supplies liable to reverse charge (other than 1 & 2 above)</td>
					<td class="text-center"><?php echo money_format('%!i',$TotalTax); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$TotalTaxCGSTSGST); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$TotalTaxCGSTSGST); ?></td>
					<td class="text-center">0.00</td>
				</tr>
				<tr>
					<td>(4) Inward supplies form ISD</td>
					<td class="text-center">0.00</td>
					<td class="text-center">0.00</td>
					<td class="text-center">0.00</td>
					<td class="text-center">0.00</td>
				</tr>
				<tr>
					<td>(5) All other ITC</td>
					<td class="text-center"><?php echo money_format('%!i',$TOTALIGST11); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$TOTALCGST); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$TOTALSGST); ?></td>
					<td class="text-center">0.00</td>
				</tr>
				<tr>
					<td>(B) ITC Reversed</td>
					<td class="text-center"></td>
					<td class="text-center" ></td>
					<td class="text-center" ></td>
					<td class="text-center" ></td>
				</tr>
				<tr>
					<td>(1) As per rules 42 & 43 of CGST Rules </td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
				</tr>
				<tr>
					<td>(2) Others  </td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
				</tr>
				<tr>
					<td>(c) Net ITC Available (A) - (B) </td>
					<td class="text-center"><?php echo money_format('%!i',$totalAMINUSB); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$totalAMINUSB_2); ?></td>
					<td class="text-center"><?php echo money_format('%!i',$totalAMINUSB_3); ?></td>
					<td class="text-center" >0.00</td>
				</tr>
				<tr>
					<td>(D) Ineligible  ITC</td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
				</tr>
				<tr>
					<td>(1) As per section 17(5)  </td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
				</tr>
				<tr>
					<td>(2) Others</td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
					<td class="text-center" >0.00</td>
				</tr>
			</tbody> 	
			 </table>
			  </br></br>
			  <?php
				$totalIGSTDATA = $totalCGSTDATA = 0;
				foreach($Purchase_Data as $valueexmpt){//For Purchase DATA
					if($valueexmpt['totaltax_total'] == '0.00'){
						if($valueexmpt['party_billing_state_id'] != $valueexmpt['sale_company_state_id']){
						 $totalIGSTDATA += $valueexmpt['total_amount'];
						}else{
						 $totalCGSTDATA += $valueexmpt['total_amount'];
						}
					}
					
				}
					
					


			  ?>
			  </br></br></br>
			  <b>5. Value of exempt, nil-rated and non GST inward supplies</b>
			<table class="table table-striped table-bordered" border="1" cellpadding="3" style="width:100%" id="tbl_fifth">
			    <thead>
					<tr>
						<th class="text-center">Nature of supplies</th>
						<th class="text-center">Inter-State Supplies </th>
						<th class="text-center">Intra-State Supplies</th>
					</tr>
				</thead>
				<tbody>	
					<!--tr>
						<th class="text-center">1</th>
						<th class="text-center">2</th>
						<th class="text-center">3</th>
					</tr-->
					<tr>
					  <td>Form a Supplies under compositions scheme, Exempt and Nil rated Supply</td>
					  <td class="text-center" ><?php echo money_format('%!i',$totalIGSTDATA); ?></td>
					  <td class="text-center" ><?php echo money_format('%!i',$totalCGSTDATA); ?></td>
					</tr>
					<tr>
						<td>Non GST Supply</td>
						<td class="text-center" ><?php echo '0.00'; ?></td>
						<td class="text-center" ><?php echo '0.00'?></td>
					</tr>
				</tbody>	
			</table>
		 <br></br/>
			  <b>5.1 Interest and Late Fee</b>
			<table class="table table-striped table-bordered" border="1" cellpadding="3" style="width:100%">
					<tr>
						<th class="text-center">Details</th>
						<th class="text-center">Integrated Tax</th>
						<th class="text-center">Central Tax</th>
						<th class="text-center">State /UT Tax</th>
						<th class="text-center">CESS</th>
					</tr>
					<tr>
					  <td >Interest</td>
					  <td class="text-center" >0.00</td>
					  <td class="text-center" >0.00</td>
					  <td class="text-center" >0.00</td>
					  <td class="text-center" >0.00</td>
					</tr>
					<tr>
						<td>Late Fees</td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >0.00</td>
					</tr>
			</table>
			<br></br/>
			 <b>6.1 Payment of tax</b>
			<table class="table table-striped table-bordered" border="1" cellpadding="3" style="width:100%">
					<tr>
						<th>Description</th>
						<th class="text-center">Total Tax Payable</th>
						<th>
						<table border="1">
							<tr>
								<td colspan="4" class="text-center">Tax Paid through ITC</td>
							</tr>
						<tr>
							<td class="text-center">Integrated Tax</td>
							<td class="text-center">Central Tax</td>
							<td class="text-center">State/UT Tax</td>
							<td class="text-center">Cess</td>
						</tr>
						</table>
						</th>
						<th class="text-center">Tax Paid in Cash</th>
						<th class="text-center">Interest Paid in Cash</th>
						<th class="text-center">Late Fee Paid in Cash</th>
					</tr>
					<tr>
					  <td colspan="7">(A) Other than reverse charge</td>
					  
					</tr>
					<?php 
					
					$TOTalINTEGrated += $totalIGST  + $igstTax + $TOTALIGST11;
					$TOTalcentralcgstGrated += $totalCGSTSGST + $CGSTTAX + $TOTALCGST;
					$TOTalcentralsgstGrated += $totalCGSTSGST + $SGSTTAX + $TOTALSGST;
											   
					$TaxpaidInCash	= $SaleTax - $TOTalINTEGrated; 
					$TotalTaxpaidCentral = $taxCGST - $TOTalcentralcgstGrated;
					$TotalTaxpaidstateuttax = $taxSGST - $TOTalcentralsgstGrated;
											   
											   //
					
					?>
					<tr>
						<td>Integrated Tax</td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >
						<table>
						<tr>
							<td class="text-center"><?php echo money_format('%!i',$TOTalINTEGrated); ?></td>
							<td class="text-center">0.00</td>
							<td class="text-center">0.00</td>
							<td class="text-center">-</td>
						</tr>
						</table>
						
						</td>
						<td class="text-center" ><?php echo money_format('%!i',$TaxpaidInCash); ?></td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >0.00</td>
					</tr>
					<tr>
						<td>Central Tax</td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >
							<table>
								<tr>
									<td class="text-center">0.00</td>
									<td class="text-center"><?php echo money_format('%!i',$TOTalcentralcgstGrated); ?></td>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
								</tr>
							</table>
						</td>
						<td class="text-center" ><?php echo money_format('%!i',$TotalTaxpaidCentral); ?></td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >0.00</td>
					</tr>
					<tr>
						<td>State/UT Tax</td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >
						<table>
								<tr>
									<td class="text-center">0.00</td>
									<td class="text-center">-</td>
									<td class="text-center"><?php echo money_format('%!i',$TOTalcentralsgstGrated); ?></td>
									<td class="text-center">-</td>
								</tr>
							</table>
						</td>
						<td class="text-center" ><?php echo money_format('%!i',$TotalTaxpaidstateuttax); ?></td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >0.00</td>
					</tr>
					<tr>
						<td>Cess</td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >
						<table>
								<tr>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
									<td class="text-center">0.00</td>
								</tr>
							</table>
						</td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >-</td>
					</tr>
					<tr>
					  <td colspan="7">(B) Reverse charge</td>
					</tr>
					<tr>
						<td>Integrated Tax</td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >
						<table>
								<tr>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
								</tr>
							</table>
						</td>
						<td class="text-center" ><?php echo money_format('%!i',$TotalTax); ?></td>
						<td class="text-center" >-</td>
						<td class="text-center" >-</td>
					</tr>
					<tr>
						<td>Central Tax</td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >
						<table>
								<tr>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
								</tr>
							</table>
						
						</td>
						<td class="text-center" ><?php echo money_format('%!i',$TotalTaxCGSTSGST); ?></td>
						<td class="text-center" >-</td>
						<td class="text-center" >-</td>
					</tr>
					<tr>
						<td>State/UT Tax</td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >
						<table>
								<tr>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
								</tr>
							</table>
						</td>
						<td class="text-center" ><?php echo money_format('%!i',$TotalTaxCGSTSGST); ?></td>
						<td class="text-center" >-</td>
						<td class="text-center" >-</td>
					</tr>
					<tr>
						<td>Cess</td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >
						<table>
								<tr>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
									<td class="text-center">-</td>
								</tr>
							</table>
						</td>
						<td class="text-center" >0.00</td>
						<td class="text-center" >-</td>
						<td class="text-center" >-</td>
					</tr>
			</table>
			
	</div>	
</div>
