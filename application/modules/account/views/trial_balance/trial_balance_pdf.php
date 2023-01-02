	<?php
	$this->load->library('Pdf');
	$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$obj_pdf->SetCreator(PDF_CREATOR);  
    $obj_pdf->SetTitle("Trial Balance");  
    $obj_pdf->SetHeaderData('Trial Balance', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $obj_pdf->SetDefaultMonospacedFont('helvetica');  
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $obj_pdf->setPrintHeader(false);  
    $obj_pdf->setPrintFooter(false);  
    $obj_pdf->SetAutoPageBreak(TRUE, 2);
	
	$obj_pdf->SetTopMargin(1);	
    $obj_pdf->SetFont('helvetica', '', 9);
	$obj_pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
	$obj_pdf->SetCreator(PDF_CREATOR);
	$obj_pdf->AddPage();
	
	$content = '';
	
	
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		$Login_user_id = $this->companyGroupId;
		if(!empty($_GET['start'])  &&  !empty($_GET['end'])){
				$startDate = date("d-M-Y", strtotime($_GET['start']));
				$EndDate = date("d-M-Y", strtotime($_GET['end']));
				$ddate = 	'('. $startDate .' to '. $EndDate  .')';
			}else{
				$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$company_id);//Fetch Data to Company Table
					$date_fcal = json_decode($date_fun->financial_year_date,true);
					
					if(empty($date_fcal)){
						
					if (date('m') <= 4) {//Upto June 2014-2015
						$mydate = date('Y-04-01',strtotime("-1 year"));     
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $second_date =  date('Y-03-31');
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', strtotime($second_date22));
					}
				}
					
					$first_date_con = date("d-M-Y", strtotime($first_date));
					$second_date_con = date("d-M-Y", strtotime($second_date));
				$ddate = 	'('. $first_date_con .' to '. $second_date_con  .')';
			}
		
	?>

		<?php
		
			
				 setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
				 $aDecode = $ledger_Data;
			     $account_group_id = array_unique(array_column($aDecode, 'account_group_id'));
				 $parent_group_id = array_unique(array_column($aDecode, 'parent_group_id'));
				 $acc = array_unique(array_column($aDecode, 'ledgerid'));
				 $data_acc_group = array_intersect_key($aDecode, $account_group_id);
				 $data_acc = array_intersect_key($aDecode, $acc);
				 $p_idd = array_intersect_key($aDecode, $parent_group_id);
				 $company_brnaches = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
			
	      $content .='<table  id="jobs"  border="1" style="width:100%;"  cellpadding="3">
			<tr align="center">
				<td></td>
				<td>
					<b style="font-size:18px;">'.$company_brnaches->name.'</b> <br/><br/><b> Trial Balance<br/><br/>'.$ddate.'</b>
				</td>
				<td></td>
			</tr>';
						$debit_amount_for_grand_ttl	 = 0;
						$credit_amount_for_grand_ttl = 0;
						
						
						foreach($account_group_id as $agid){ 
						$account_group_name = getNameById('account_group',$agid,'id');
						$debit_amount = $credit_amount = $IGST_amt = $CGST_amt = $SGST_amt = $sum = 0;
						foreach($data_acc as $account_gd){
							
							if($account_gd['account_group_id'] == $agid){
								$amount_totalgd = get_total_user_amount_debit('transaction_dtl',$account_gd['ledgerid'],$Login_user_id);
								$amount_total_credit = get_total_user_amount_crdt('transaction_dtl',$account_gd['ledgerid'],$Login_user_id);
								$ledger_detailsGD = get_closing_balance($account_gd['ledgerid'],$Login_user_id);
								foreach($ledger_detailsGD as $ledger_dtlsgd){
									if($ledger_dtlsgd['openingbalc_cr_dr'] == 1 ){
										 	$leger_debit_ttl = $amount_totalgd['sum(debit_dtl)'];
											$opening_balance =  $ledger_dtlsgd['opening_balance'];
											$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
									    	$ledger_amt_aftr_calcu_cr = $leger_credit_ttl + $opening_balance;
											$ledger_amt_aftr_calcu_dr = $leger_debit_ttl;
										}
									if($ledger_dtlsgd['openingbalc_cr_dr'] == 0 ){
										$leger_debit_ttl = $amount_totalgd['sum(debit_dtl)'];
										$opening_balance =  $ledger_dtlsgd['opening_balance'];
										$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
										$ledger_amt_aftr_calcu_dr = $leger_debit_ttl + $opening_balance;
										$ledger_amt_aftr_calcu_cr = $leger_credit_ttl;
									}
								}	
									if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										$debit_amount += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										$debit_amount_for_grand_ttl += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										$credit_amount += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										$credit_amount_for_grand_ttl += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									}
								
							}	
					}
					
			
				
				//$content .= '<tr style="background-color:#ddd;text-transform: capitalize;"><th>';					
					foreach($p_idd as $get_parent_name){
						if($get_parent_name['account_group_id'] == $agid && $get_parent_name['parent_group_id'] != 0){
							$parent_name = getNameById('account_group',$get_parent_name['parent_group_id'],'id');
							//$content .= '<span style="font-size: 14px;float:left;">'.$parent_name->name.'</span></br></br>';	
					}		
				}		
					$content .= '<tr><th><span style="font-size: 12px; float:left;">'.$account_group_name->name.'</span></th>';
					$content .= '<th>Debit '. money_format('%!i',$debit_amount).'</th>';
					$content .= '<th>Credit '. money_format('%!i',$credit_amount).'</th></tr>';
				
				foreach($data_acc as $account){
					if($account['account_group_id'] == $agid){
						
							// 
							//'1','Means credit opening balance','0','means debit opening balance'
						
							$amount_total = get_total_user_amount_debit('transaction_dtl',$account['ledgerid'],$Login_user_id);
							$amount_total_credit = get_total_user_amount_crdt('transaction_dtl',$account['ledgerid'],$Login_user_id);
							$ledger_details = get_closing_balance($account['ledgerid'],$Login_user_id);
							
								foreach($ledger_details as $ledger_dtls){
									if($ledger_dtls['openingbalc_cr_dr'] == 1 ){
										 	$leger_debit_ttl = $amount_total['sum(debit_dtl)'];
											$opening_balance =  $ledger_dtls['opening_balance'];
											$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
									    	$ledger_amt_aftr_calcu_cr = $leger_credit_ttl + $opening_balance;
											$ledger_amt_aftr_calcu_dr = $leger_debit_ttl;
										}
									if($ledger_dtls['openingbalc_cr_dr'] == 0 ){
										$leger_debit_ttl = $amount_total['sum(debit_dtl)'];
										$opening_balance =  $ledger_dtls['opening_balance'];
										$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
										$ledger_amt_aftr_calcu_dr = $leger_debit_ttl + $opening_balance;
										$ledger_amt_aftr_calcu_cr = $leger_credit_ttl;
									}
								}	
								if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										$closing_bal_chk = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										$closing_bal_chk = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									}

									//echo $ledger_amt_aftr_calcu_dr;
								if($ledger_amt_aftr_calcu_cr != '' || $ledger_amt_aftr_calcu_cr != 0 || $ledger_amt_aftr_calcu_dr != '' || $ledger_amt_aftr_calcu_dr != 0){
									
										// echo '<td width="500px"><a href="javascript:void(0)" id="'. $account['ledgerid'] . '" data-id="ledger_view" class="add_account_tabs">'.$account['name'].'</a></td>';
										$content .= '<tr><td  style="font-size: 12px;"><a href="javascript:void(0)" class="lager_rp_name" data-id='.$account['ledgerid'].' >'. $account['name'] .'</a></td>';
									
									if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										
											$content .= '<td >' .money_format('%!i',$closing_bal).'</td>';//Debit
											$content .= '<td></td>'; 
										
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										
											$content .= '<td></td>';
											$content .= '<td >'.money_format('%!i', $closing_bal).'</td>';//Credit
										
									}
									$content .= '</tr>';
								}	
							
								//$content .= '<tr style="display:none;"><td>'.$get_parent_name['created_date'].'</td></tr>';	
							
						}
					}
					
			 
			}					
		 
			
	//$content .='<tr><td colspan="4"></td></tr>';
	//$content .='<tr><td colspan="4"></td></tr>';
	$content .='<tr>
			<td colspan="1">Grand Total</td>
			<td style="text-align: center;">'.money_format('%!i', $debit_amount_for_grand_ttl).'</td>
			<td  style="text-align: center;">'.money_format('%!i', $credit_amount_for_grand_ttl).'</td></tr>';
		$content .='</table>';
		$obj_pdf->writeHTML($content);
		ob_end_clean(); 	
		$obj_pdf->Output('sample.pdf', 'I');   

		
	
		
	