<?php
$path = getcwd();

				$rand_num = rand(5000000, 1500000);
				$filename = "Trial_balance_".$rand_num."" . ".xls"; 
				
				// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
				// header("Content-Type: application/vnd.ms-excel");
				// header("Content-Disposition: attachment; filename=\"$filename\"");
				
				 
				 $fd = fopen (FCPATH."assets/modules/account/trial_balance/".$filename, "w");

		
		// $Login_user_id = $_SESSION['loggedInUser']->c_id;
		// $company_brnaches = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
		
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		$Login_user_id = $this->companyGroupId;
		$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');

	
		//This Code is used to show Financial Year date and Filter Date showing
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
			//This Code is used to show Financial Year date and Filter Date showing
			
		
		
		$content .='<table  id="jobs"  border="1" style="width:100%;" >
			<tr align="center">
				<td></td>
				<td>
					<b style="font-size:18px;">'.$company_brnaches->name.'</b> <br/><br/><b> Trial Balance<br/><br/>'.$ddate.'</b>
				</td>
				<td></td>
			</tr><thead>';
			
				setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
			
				 $aDecode = $ledger_Data;
				 $account_group_id = array_unique(array_column($aDecode, 'account_group_id'));
				 $parent_group_id = array_unique(array_column($aDecode, 'parent_group_id'));
				 $acc = array_unique(array_column($aDecode, 'ledgerid'));
				 $data_acc_group = array_intersect_key($aDecode, $account_group_id);
				 $data_acc = array_intersect_key($aDecode, $acc);
				 $p_idd = array_intersect_key($aDecode, $parent_group_id);
				
			 
				
				
				
					
							
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
					
					
					
			if($debit_amount != 0	 ||  $credit_amount != ''){
				
				$content .='<tr style="background-color:#ddd;text-transform: capitalize;"><th style="text-align:left!important;">';					
			foreach($p_idd as $get_parent_name){
				if($get_parent_name['account_group_id'] == $agid && $get_parent_name['parent_group_id'] != 0){
				   $parent_name = getNameById('account_group',$get_parent_name['parent_group_id'],'id');
					$content .=' <span style="font-size: 14px;">'.$parent_name->name.'</span></br>';	
				
				}		
			}		
	
		$content .='<span style="font-size: 12px; text-align:left;">'.$account_group_name->name.'</span></th>';
			
				$content .='<th>Debit     '. money_format('%!i',$debit_amount).'</th>';
				$content .='<th>Credit    '. money_format('%!i',$credit_amount).'</th>';
			$content .='</tr>';
	
				$content .='</thead>';
				$content .='<tbody>';
 }				
			
				foreach($data_acc as $account){
					
					if($account['account_group_id'] == $agid){
						
						
						if($account['ledger_id'] != ''){
							$ledger_name = getNameById('ledger',$account['ledgerid'],'id');
						}else{
							$ledger_name = getNameById('ledger',$account['id'],'id');
						}

						
							
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
								if($ledger_amt_aftr_calcu_cr != '' || $ledger_amt_aftr_calcu_cr != 0 || $ledger_amt_aftr_calcu_dr != '' || $ledger_amt_aftr_calcu_dr != 0){
										$content .= '<tr>';
										// echo '<td width="500px"><a href="javascript:void(0)" id="'. $account['ledgerid'] . '" data-id="ledger_view" class="add_account_tabs">'.$account['name'].'</a></td>';
										$content .= '<td width="500px" style="font-size: 12px;">'. $account['name'] .'</td>';
									
									if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										
											 $content .=  '<td style="text-align:center;">' .money_format('%!i',$closing_bal).'</td>';//Debit
											 $content .=  '<td></td>'; 
										
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										
											$content .=  '<td></td>';
											$content .=  '<td style="text-align:center;">'.money_format('%!i', $closing_bal).'</td>';//Credit
										
									}
								}	
							'</tr>';
								
							
						}
					}
			 
			}					
		 
		
			
	
	$content .='<tr><td colspan="4" style="display:none;"></td></tr>
	<tr><td colspan="4" style="display:none;"></td></tr>
	<tr>
			<th  width="90px" style="text-align: center;  width:69%;">Grand Total</th>
			<td width="90px" style="text-align: center;"> '.money_format('%!i', $debit_amount_for_grand_ttl).'</td>
			<td width="90px" style="text-align: center;">'. money_format('%!i', $credit_amount_for_grand_ttl).'</td>
		</tr>
		</tbody></table>';
		
		// pre($content);die();
fputs($fd, $content);
fclose($fd);

