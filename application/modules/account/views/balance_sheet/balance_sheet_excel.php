<?php
 //ob_end_clean(); 
$filename = "balance_Sheet" . ".xls"; 
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
	?>
		<div class="x_content">
	<?php

		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		$Login_user_id = $this->companyGroupId;
		//$Login_user_id = $_SESSION['loggedInUser']->c_id;
		$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');
	?>
	
	<?php
		//This Code is used to show Financial Year date and Filter Date showing
			if(!empty($_POST['start'])  &&  !empty($_POST['end'])){
				$startDate = date("d-M-Y", strtotime($_POST['start']));
				$EndDate = date("d-M-Y", strtotime($_POST['end']));
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
						$lastyear = strtotime("-1 year", strtotime($mydate));
						$first_date = date("Y-m-d", $lastyear);
						$date = date(date('Y-03-31'));
						$second_date = date('Y-m-d', strtotime("$date"));
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
						$second_date = date('Y-m-d', strtotime("$date"));
					}
				}
					
					$first_date_con = date("d-M-Y", strtotime($first_date));
					$second_date_con = date("d-M-Y", strtotime($second_date));
				$ddate = 	'('. $first_date_con .' to '. $second_date_con  .')';
			}
			//This Code is used to show Financial Year date and Filter Date showing
			
		?>
		
		<table  id="jobs"  border="1" style="width:100%;" >
	<tr align="center"><td><b style="font-size:18px;"><?php echo $company_brnaches->name; ?></b> <br/><br/><b>Balance Balance<br/><br/><?php echo $ddate;?></b></td></tr>
			<?php
						setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
						
						
						
				$aDecode = $trial_balance_data; 
				
				$account_group_id = array_unique(array_column($aDecode, 'account_group_id'));
				$parent_group_id = array_unique(array_column($aDecode, 'parent_group_id'));
				$acc = array_unique(array_column($aDecode, 'name'));
				
				$data_acc_group = array_intersect_key($aDecode, $account_group_id);
				$data_acc = array_intersect_key($aDecode, $acc);
				$p_idd = array_intersect_key($aDecode, $parent_group_id);
				
			?>	 
				
				
			<thead>
				<tr>
					<th style="text-align: center;font-size: 15px;">Liabilities</th>
					<th style="text-align: center;font-size: 15px;">Assets</th>
				</tr>
			</thead>
			<tbody>				      
					 <?php
					$libTr = '';
					$assTr = '';
					$libTr .= '<td><table  id="datatable-buttons"  class="table table-striped table-bordered" border="1" style="width: 100%">';
					$assTr .= '<td><table  id="datatable-buttons"  class="table table-striped table-bordered" border="1" style="width: 100%">';
					
					
				
					$closing_bal2 = 0;
						foreach($account_group_id as $agid){
							
							if($agid != 0){
								if( $agid == 1 || $agid == 2 || $agid == 3 || $agid == 17 || $agid == 55){
									$Grand_closing_bal2 = 0;
									foreach($data_acc as $account){//Grand total Code Start Here
										if($account['account_group_id'] == $agid){
											if($agid == 1 || $agid == 2 || $agid == 3 || $agid == 55 || $account['account_group_id'] == 17){
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
												$Grand_closing_bal2 += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
												}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
												  $Grand_closing_bal2 += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
												}	
										}
									}
								}//Grand total Code End Here			
							$parent_name = getNameById('account_group',$agid,'id');
							
							$All_total_libility += $Grand_closing_bal2;
							if($Grand_closing_bal2 != ''){
								$libTr .= '<tr><th style="text-transform: capitalize;">'. $parent_name->name.'</th><th style="float: right;">'.money_format('%!i', $Grand_closing_bal2).'</th></tr>';
							}
						}  
						if( $agid == 4 || $agid == 5 || $agid == 6 ||  $agid == 54 ||  $agid == 48 || $agid == 7){
							$Grand_closing_bal = 0;
							foreach($data_acc as $account){//Grand total Code Start Here
								if($account['account_group_id'] == $agid){
									if($agid == 4 || $agid == 5 ||  $agid == 6  ||  $agid == 54 ||  $agid == 48 || $agid == 7){
										
											$amount_total_Ass = get_total_user_amount_debit('transaction_dtl',$account['ledgerid'],$Login_user_id);
									$amount_total_credit_ASS = get_total_user_amount_crdt('transaction_dtl',$account['ledgerid'],$Login_user_id);
									$ledger_details = get_closing_balance($account['ledgerid'],$Login_user_id);
								
										foreach($ledger_details as $ledger_dtls){
												if($ledger_dtls['openingbalc_cr_dr'] == 1 ){
														$leger_debit_ttl = $amount_total_Ass['sum(debit_dtl)'];
														$opening_balance =  $ledger_dtls['opening_balance'];
														$leger_credit_ttl = $amount_total_credit_ASS['sum(credit_dtl)'];
														$ledger_amt_aftr_calcu_cr = $leger_credit_ttl + $opening_balance;
														$ledger_amt_aftr_calcu_dr = $leger_debit_ttl;
													}
												if($ledger_dtls['openingbalc_cr_dr'] == 0 ){
													$leger_debit_ttl = $amount_total_Ass['sum(debit_dtl)'];
													$opening_balance =  $ledger_dtls['opening_balance'];
													$leger_credit_ttl = $amount_total_credit_ASS['sum(credit_dtl)'];
													$ledger_amt_aftr_calcu_dr = $leger_debit_ttl + $opening_balance;
													$ledger_amt_aftr_calcu_cr = $leger_credit_ttl;
												}
											}	
											if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
											$Grand_closing_bal += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
											}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
											  $Grand_closing_bal += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
											}	
										}
									}
							}//Grand total Code End Here
					
							$parent_group_id2 = getNameById('account_group',$agid,'id');
							// if($parent_group_id2->parent_group_id != '' && $parent_group_id2->parent_group_id != 0){
								// $parent_name_Account = getNameById('account_group',$parent_group_id2->parent_group_id,'id');
								// $parent_name = $parent_name_Account->name;
							// }
						
							$All_total_Ass += $Grand_closing_bal;
							if($Grand_closing_bal != ''){
								
								$assTr .= '<tr><th style="text-transform: capitalize;">'. $parent_group_id2->name.'</th><th style="float: right;">'.money_format('%!i', $Grand_closing_bal).'</th></tr>';
							}
						}
				}            
						$closing_bal = 0;
						
						foreach($data_acc as $account){
							
							
							if($account['account_group_id'] == $agid){
								
									
								if($agid == 1 || $agid == 2 || $agid == 3 || $agid == 55  || $account['account_group_id'] == 17){
								
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
									$closing_bal2 = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
									  $closing_bal2 = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									}
									
									$Acccount_group_name = getNameById('ledger',$account['ledgerid'],'id');
									if($ledger_amt_aftr_calcu_dr != '' || $ledger_amt_aftr_calcu_cr != '' ){
										$libTr .= '<tr><td style="text-transform: capitalize;">'.$Acccount_group_name->name.'</td><td>'.money_format('%!i', $closing_bal2).'</td></tr>';
									}
								}
								
								if($agid == 4 || $agid == 5 ||  $agid == 6 ||  $agid == 54  ||  $agid == 48 || $agid == 7){
									
								
								
									$amount_total_Ass = get_total_user_amount_debit('transaction_dtl',$account['ledgerid'],$Login_user_id);
									$amount_total_credit_ASS = get_total_user_amount_crdt('transaction_dtl',$account['ledgerid'],$Login_user_id);
									$ledger_details = get_closing_balance($account['ledgerid'],$Login_user_id);
									
									
									
								
								foreach($ledger_details as $ledger_dtls){
										if($ledger_dtls['openingbalc_cr_dr'] == 1 ){
												$leger_debit_ttl = $amount_total_Ass['sum(debit_dtl)'];
												$opening_balance =  $ledger_dtls['opening_balance'];
												$leger_credit_ttl = $amount_total_credit_ASS['sum(credit_dtl)'];
												$ledger_amt_aftr_calcu_cr = $leger_credit_ttl + $opening_balance;
												$ledger_amt_aftr_calcu_dr = $leger_debit_ttl;
											}
										if($ledger_dtls['openingbalc_cr_dr'] == 0 ){
											$leger_debit_ttl = $amount_total_Ass['sum(debit_dtl)'];
											$opening_balance =  $ledger_dtls['opening_balance'];
											$leger_credit_ttl = $amount_total_credit_ASS['sum(credit_dtl)'];
											$ledger_amt_aftr_calcu_dr = $leger_debit_ttl + $opening_balance;
											$ledger_amt_aftr_calcu_cr = $leger_credit_ttl;
										}
									}	
									
									
										if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										  $closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										}
										//$Acccount_group_name = getNameById('account_group',$account['account_group_id'],'id');
										
										$Acccount_group_name1 = getNameById('ledger',$account['ledgerid'],'id');
										//pre($account['ledgerid']);
										if($ledger_amt_aftr_calcu_dr != '' || $ledger_amt_aftr_calcu_cr != '' ){
											$assTr .= '<tr><td style="text-transform: capitalize;">'.$Acccount_group_name1->name.'</td><td>'.money_format('%!i', $closing_bal).'</td></tr>';
										}
								}
							}	
						}	
					}
					
			//$libOpBGrand_total = $grand_total_for_capital_acc_TOTAL+$libAmtTot;			
				
					$libTr .= '</td></table><table width="600"><tr><td align="center"><b>Total </b> </td><td align="right"><b>'.money_format('%!i', $All_total_libility).'</b></td></tr></table>';
					echo $libTr;
					$assTr .= '</td></table><table width="900"><tr><td align="center"><b>Total </b> </td><td align="right"><b>' .money_format('%!i', $All_total_Ass) . '</b></td></tr></table>';
					echo $assTr;
				?>
		</tbody>
	</table>
</div>
