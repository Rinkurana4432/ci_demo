<?php 
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $obj_pdf->SetCreator(PDF_CREATOR);  
    $obj_pdf->SetTitle("Ledger Report");  
    $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $obj_pdf->SetDefaultMonospacedFont('helvetica');  
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $obj_pdf->setPrintHeader(false);  
    $obj_pdf->setPrintFooter(false);  
    $obj_pdf->SetAutoPageBreak(TRUE, 10);  
    $obj_pdf->SetFont('helvetica', '', 9);	  
	#$company_data = getNameById('company_detail',$dataPdf->created_by,'id');
	$company_data = getNameById('company_detail',$this->companyGroupId,'id');
	$ldgerid = $this->uri->segment(3);
	$ledger_Data = getNameById('ledger',$ldgerid,'id');
	
	if($ledger_Data->openingbalc_cr_dr == 1){
		$opng_balnce_cr = $ledger_Data->opening_balance;
	}else if($ledger_Data->openingbalc_cr_dr == 0){
		 $opng_balnce_dr =  $ledger_Data->opening_balance;
	}	
	
	
	$debitTotal = 0; $creditTotal = 0;
	
			foreach($ledger_rpt_data2 as $open_balance){
				
				
				$debitTotal += $open_balance->debit_dtl;
				$creditTotal += $open_balance->credit_dtl;
			}
			if($ledger_Data->openingbalc_cr_dr == 1){ //opening Balance is in Credit
				
					$openg_balance = floor($ledger_Data->opening_balance);
					$after_add_opening_bal_credit  = $openg_balance + $creditTotal;
					$bbl = $debitTotal - $after_add_opening_bal_credit;
				}else if($ledger_Data->openingbalc_cr_dr == 0){
					$openg_balance = floor($ledger_Data->opening_balance);
					$after_add_opening_bal_debit  = $debitTotal + $openg_balance;
					$bbl = $creditTotal - $after_add_opening_bal_debit;
				}
			  
				$closingBalan = abs($bbl);  
			
	
	$companyLogo = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	
	$obj_pdf->Image($companyLogo,2,4,10,10,'PNG');
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
    //$state= getNameById('state',$supplierName->state,'state_id');
	
	//'1','Means credit opening balance','0','means debit opening balance'
    $obj_pdf->AddPage(); 
    $content = ''; 
	$content .= '
		<table>
			<tr>
				<td colspan="1"><div style="margin-top: 15%;"><h2 align="center">'.$company_data->name.'</h2></div></td>
			</tr>
			<tr>
				<td colspan="1"><div><h3 align="center">'.$ledger_Data->name.'</h3><br/><center><h4> Ledger Report  </h4></center></div></td>
				
			</tr>
			
		</table>';
$content .= '<table border="1" cellpadding="2">
	<tr>
		<th>S.no</th>
		<th>Date</th>
		<th>Particular</th>
		<th>Voucher Number</th>
		<th>Voucher Type</th>
		<th>Credit</th>
		<th>Debit</th>
	</tr>';
    $content .= '<tr>
				<td></td>		
				<td></td><td></td><td></td><td><b>Opening Balance</b></td>';
	if($debitTotal == 0 && $creditTotal == 0){			
		$content .= '<td>'.money_format('%!i',$opng_balnce_cr).'</td>';
		$content .= '<td>'.money_format('%!i',$opng_balnce_dr).'</td>';
	}else{
		if($closingBalan > floor($ledger_Data->opening_balance)){
				$content .= '<td></td>';
				$content .= '<td>'.money_format('%!i',$closingBalan).'</td>';
				}else{
				$content .= '<td>'.money_format('%!i',$closingBalan).'</td>';
				$content .= '<td></td>';
			 }
		
		
	}
	$content .=	'</tr>';
	if(!empty($ledger_rpt_data)){
		
					$sno = 1;
					$credit_total = 0;
					$debit_total = 0;
					 foreach($ledger_rpt_data as $dtl){
						
							if($dtl->narration == ''){
								 $narrationn = 'N/A';
								}else{
								  $narrationn = $dtl->narration;
							}
							$added_invoice_id = '';
							if($dtl->type == 'purchase_bill_payment_recive'){
								$get_payment_details_from_payment_tbl	= getNameById('payment',$dtl->type_id,'id');
									$data_json	= JSON_DECODE($get_payment_details_from_payment_tbl->payment_detail); 
								
								foreach($data_json as $detail){
									
									$inovoice_detail['bill_id'] = $detail->bill_id;
									   $added_invoice_id .= $inovoice_detail['bill_id'];
									}
								}else if($dtl->type == 'Payment Receive'){
									$get_payment_details_from_payment_tbl	= getNameById('payment',$dtl->type_id,'id');
									$data_json_invoice_payment_recive = JSON_DECODE($get_payment_details_from_payment_tbl->payment_detail); 
									foreach($data_json_invoice_payment_recive as $detail_invoice){
										$inovoice_detail['invoice_id'] = $detail_invoice->invoice_id;
										$added_invoice_id .= $inovoice_detail['invoice_id'];
									}
									
								}else if($dtl->type == 'invoice'){
									$get_invoice_number = getNameById('invoice',$dtl->type_id,'id');
									$added_invoice_id .= $get_invoice_number->invoice_num;	
								}else if($dtl->type == 'purchase_bill'){
									 $added_invoice_id .= $dtl->type_id;
								}else{
									$added_invoice_id .= $dtl->type_id;
									
								}
						if($dtl->type == 'invoice'){
								$vcher_type = 'Invoice';
								$get_invoice_dtl = getNameById('invoice',$dtl->type_id,'id');
								$ledger_data = getNameById('ledger',$get_invoice_dtl->party_name,'id');
								$namee = $ledger_data->name; 
								$newDate = date("j F , Y", strtotime($get_invoice_dtl->date_time_of_invoice_issue));
								$ledger_data = getNameById('ledger',$get_invoice_dtl->party_name,'id');
								$namee = $ledger_data->name; 
							}else if($dtl->type == 'purchase_bill'){
								$vcher_type = 'Purchase Bill';
								$get_purchase_bill_dtl = getNameById('purchase_bill',$dtl->type_id,'id');
								
								 $ledger_data = getNameById('ledger',$get_purchase_bill_dtl->supplier_name,'id');
								 //pre($ledger_data->name);
								 $namee = $ledger_data->name;
								$newDate = date("j F , Y", strtotime($get_purchase_bill_dtl->date));
								$ledger_data = getNameById('ledger',$get_invoice_dtl->party_name,'id');
								$namee = $ledger_data->name;
							}else if($dtl->type == 'Payment Receive'){
								$vcher_type = 'Payment Receive';
								$get_payment_recive_dtl = getNameById('payment',$dtl->type_id,'id');
								$ledger_data = getNameById('ledger',$get_payment_recive_dtl->party_id,'id');
								$namee = $ledger_data->name; 
								$newDate = date("j F , Y", strtotime($get_payment_recive_dtl->payment_date));
							}else if($dtl->type == 'purchase_bill_payment_recive'){
								$vcher_type = 'Payment Done';
								$newDate = date("j F , Y", strtotime($dtl->created_date));
								$get_payment_payment_done_dtl = getNameById('payment',$dtl->type_id,'id');
								//pre($get_payment_payment_done_dtl->party_id);
								$ledger_data = getNameById('ledger',$get_payment_payment_done_dtl->party_id,'id');
								$namee = $ledger_data->name; 
							}else{
								$get_vaoucher_id = getNameById('voucher',$dtl->type_id,'id');
								$get_vaoucher_name = getNameById('voucher_type',$get_vaoucher_id->voucher_name,'id');
								$vcher_type = $get_vaoucher_name->voucher_name;
								$newDate = date("j F , Y", strtotime($get_vaoucher_id->voucher_date));
							}				
						
						$credit_total += $dtl->credit_dtl;
						$debit_total += $dtl->debit_dtl;
					
					
					$content .= '<tr>
									<td>'.$sno.'</td>
									<td>'. date("j F , Y", strtotime($dtl->add_date)).'</td>
									<td>'.$narrationn.'</td>
									<td>'.$added_invoice_id .'</td>
									<td>'.$vcher_type .'</td>
									<td>'. money_format('%!i',$dtl->credit_dtl) .'</td>
									<td>'. money_format('%!i',$dtl->debit_dtl) .'</td>
								</tr>';
								  $sno++;
								  
								  
								  
						//$opening_balance = 		  
						//pre( $dtl->debit_dtl);	 
					 }
					 
					 // pre($credit_total);
					   // pre($debit_total);
					 // die();
					
							$amount_total = get_total_user_amount_debit('transaction_dtl',$dtl->ledger_id,$this->companyGroupId);
							
							$amount_total_credit = get_total_user_amount_crdt('transaction_dtl',$dtl->ledger_id,$this->companyGroupId);
							$ledger_details = get_closing_balance($dtl->ledger_id,$this->companyGroupId);
							// foreach($ledger_details as $ledger_dtls){
									// if($ledger_dtls['openingbalc_cr_dr'] == 1 ){
										 	// $leger_debit_ttl = $amount_total['sum(debit_dtl)'];
											// $opening_balance =  $ledger_dtls['opening_balance'];
											// $leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
									    	// $ledger_amt_aftr_calcu_cr = $leger_credit_ttl + $opening_balance;
											// $ledger_amt_aftr_calcu_dr = $leger_debit_ttl;
										// }
									// if($ledger_dtls['openingbalc_cr_dr'] == 0 ){
										// $leger_debit_ttl = $amount_total['sum(debit_dtl)'];
										// $opening_balance =  $ledger_dtls['opening_balance'];
										// $leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
										// $ledger_amt_aftr_calcu_dr = $leger_debit_ttl + $opening_balance;
										// $ledger_amt_aftr_calcu_cr = $leger_credit_ttl;
									// }
								// }	
						if($debitTotal == 0 && $creditTotal == 0){		
								if($ledger_Data->openingbalc_cr_dr == 1){
									$leger_debit_ttl = $debit_total;
									$opening_balance =  $ledger_Data->opening_balance;
									$leger_credit_ttl = $credit_total;
									$ledger_amt_aftr_calcu_cr = $leger_credit_ttl + $opening_balance;
									$ledger_amt_aftr_calcu_dr = $leger_debit_ttl;
									
								}else if($ledger_Data->openingbalc_cr_dr == 0){
									$leger_debit_ttl = $debit_total;
									$opening_balance =  $ledger_Data->opening_balance;
									$leger_credit_ttl = $credit_total;
									$ledger_amt_aftr_calcu_dr = $leger_debit_ttl + $opening_balance;
									$ledger_amt_aftr_calcu_cr = $leger_credit_ttl;
								}	
								
							
								
									if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
											$content .= '<tr>
												<td colspan="4"></td>
												<td>Closing Balance</td>
												
												<td>'.money_format('%!i',$closing_bal).'</td>
												<td>0.00</td>
												
												</tr>';		//Debit
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
													$content .= '<tr>
														<td colspan="4"></td>
															<td>Closing Balance</td>
															<td>0.00</td>
															<td>'.money_format('%!i',$closing_bal).'</td>
															
														</tr>';
									}
						}else{
									if($closingBalan > floor($ledger_Data->opening_balance)){
											$content .= '<tr>
												<td colspan="4"></td>
												<td>Closing Balance</td>
												
												<td>'.money_format('%!i',$closingBalan).'</td>
												<td>0.00</td>
												
												</tr>';	
											}else{
											$content .= '<tr>
														<td colspan="4"></td>
															<td>Closing Balance</td>
															<td>0.00</td>
															<td>'.money_format('%!i',$closingBalan).'</td>
															
														</tr>';
										 }
						}
					
					 
				}	 
				if($ledger_Data->openingbalc_cr_dr == 1){
					$opng_balnce_crdit = $ledger_Data->opening_balance;
				}else if($ledger_Data->openingbalc_cr_dr == 0){
					 $opng_balnce_debit =  $ledger_Data->opening_balance;
				}	
				
				$crdt_total = $credit_total + $opng_balnce_crdit;
				$drdt_total = $debit_total + $opng_balnce_debit;
				if($crdt_total <  $drdt_total){
					$total_crdit = $crdt_total + $closing_bal;
					$total_debit = $drdt_total;
				}else if($crdt_total >  $drdt_total){
					$total_debit = $drdt_total + $closing_bal;
					$total_crdit = $crdt_total;
				}


if($debitTotal == 0 && $creditTotal == 0){		
		$content .= '<tr><td></td><td></td><td></td><td></td><td>Total  </td><td style="float:right">'. money_format('%!i',$total_crdit).'</td><td >'.money_format('%!i',$total_debit).'</td></tr>';
}else{
	if($closingBalan > floor($ledger_Data->opening_balance)){
		$content .= '<tr><td></td><td></td><td></td><td></td><td>Total  </td><td style="float:right">'. money_format('%!i',$closingBalan).'</td><td >'.money_format('%!i',$closingBalan).'</td></tr>';
	}else{
		$content .= '<tr><td></td><td></td><td></td><td></td><td>Total  </td><td style="float:right">'. money_format('%!i',$closingBalan).'</td><td >'.money_format('%!i',$closingBalan).'</td></tr>';
	}
}
$content .= '</table>';



//pre($content);die();
  $obj_pdf->writeHTML($content); 
	ob_end_clean();	
  $obj_pdf->Output('ledger_report.pdf', 'I');   