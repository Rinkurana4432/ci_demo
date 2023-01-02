<?php
 //ob_end_clean(); 
$filename = "profit_and_loss" . ".xls"; 
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
	?>

	<div class="x_content">
<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
$Login_user_id = $this->companyGroupId;
				 $aDecode = $profit_loss_data;
				 $account_group_id = array_unique(array_column($aDecode, 'account_group_id'));
				$parent_group_id = array_unique(array_column($aDecode, 'parent_group_id'));
				$acc = array_unique(array_column($aDecode, 'name'));
				$data_acc_group = array_intersect_key($aDecode, $account_group_id);
				$data_acc = array_intersect_key($aDecode, $acc);
				$p_idd = array_intersect_key($aDecode, $parent_group_id);
				
				
		$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');	
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
						$mydate = date(date('Y-04-01'));
						$lastyear = strtotime("-1 year", strtotime($mydate));
						$first_date = date("Y-m-d", $lastyear); 
						$date = date(date('Y-03-31'));
						$second_date = date('Y-m-d', strtotime("$date"));
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
			<table    border="1" style="width:100%;" >
			<tr align="center"><td><b style="font-size:18px;"><?php echo $company_brnaches->name; ?></b> <br/><br/><b> Profit And Loss<br/><br/><?php echo $ddate;?></b></td></tr>
			 <thead align="center">
				 <tr>
					  <th  style="text-align: center;">Direct Expenses</th>
					  <th  style="text-align: center;">Sale and Other Income</th>
				</tr>
			</thead>
			<tbody>	
			<?php
			
			$drct_expnsis = '';
			$sale_and_other = '';
				$drct_expnsis .= '<td style="width: 50%;"><table  class="table table-striped table-bordered" border="1" style="width: 100%;">';
				$sale_and_other .= '<td><table class="table table-striped table-bordered" border="1" style="width: 100%;">';
				$closing_bal2 = 0;
							$drct_expnsis .= '<tr><th>Opening Stock</th><th style="float: right;">'.$opening_Stock.'</th></tr>';
							$drct_expnsis .= '<tr><td> Opening Stock </td><td>'.$opening_Stock.'</td></tr>';
						foreach($account_group_id as $agid){
							$account_group_name = getNameById('account_group',$agid,'id');
							if($agid != 0){
								if( $agid == 8 || $agid == 10){
									$Grand_closing_bal2 = 0;
									foreach($data_acc as $account){//Grand total Code Start Here
									
										if($account['account_group_id'] == $agid){
											if( $agid == 8 || $agid == 10){
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
							
							$drct_expnsis .= '<tr><th>'. $parent_name->name.'</th><th style="float: right;">'.money_format('%!i', $Grand_closing_bal2).'</th></tr>';
						}
						
						
						if($agid == 7 || $agid == 9){
							
							$Grand_closing_bal = 0;
							foreach($data_acc as $account){//Grand total Code Start Here
								if($account['account_group_id'] == $agid){
									if( $agid == 7 || $agid == 9 ){
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
							$All_total_sale += $Grand_closing_bal;
							$sale_and_other .= '<tr><th>'. $parent_group_id2->name.'</th><th style="float: right;">'.money_format('%!i', $Grand_closing_bal).'</th></tr>';
							
						}
				}            
						$closing_bal = 0;
						
						
						foreach($data_acc as $account){
							
							if($account['account_group_id'] == $agid){
								if( $agid == 8 || $agid == 10){
						
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
								$Acccount_group_name = getNameById('ledger',$account['ledgerid'],'id');
								if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
									$closing_bal2 = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										$drct_expnsis .= '<tr><td>'.$Acccount_group_name->name.'</td><td>'.money_format('%!i', $closing_bal2).'</td></tr>';
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
									  $closing_bal2 = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									 $drct_expnsis .= '<tr><td>'.$Acccount_group_name->name.'</td><td>'.money_format('%!i', $closing_bal2).'</td></tr>';
									}
									
									
									//pre($Acccount_group_name);
									
								}
								if($agid == 7 || $agid == 9){
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
									$Acccount_group_name = getNameById('ledger',$account['ledgerid'],'id');
										if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										 $closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
											$sale_and_other .= '<tr><td>'.$Acccount_group_name->name.'</td><td>'.money_format('%!i', $closing_bal).'</td></tr>';
										}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										 $closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
											$sale_and_other .= '<tr><td>'.$Acccount_group_name->name.'</td><td>'.money_format('%!i', $closing_bal).'</td></tr>';
										}
										  // $branch_add = getNameById('company_detail',$_SESSION['loggedInUser']->u_id,'u_id');
										  // $data =  json_decode($branch_add->address,true);
										
										 // foreach($data as $company_data){
												// if($account['compny_branch_id'] == $company_data['add_id']) {
													// $brnch_name = $company_data['compny_branch_name']; 
												// } 
										 // }
										//$sale_and_other .= '<tr><td>'.$brnch_name.'</td><td>'.money_format('%!i', $closing_bal).'</td></tr>';
										
										
										 //pre($Acccount_group_name);
										//$Acccount_group_name = getNameById('account_group',$account['account_group_id'],'id');
										
									}
									
								}	
							}	
						}
						$sale_and_other .= '<tr><th>Closing Stock</th><th style="float: right;">'.$closing_Stock.'</th></tr>';
						$sale_and_other .= '<tr><td> Closing Stock </td><td>'.$closing_Stock.'</td></tr>';
						
						 $direct_expense_total = $All_total_libility + $opening_Stock;
						
						 $sale_and_other_total = $All_total_sale + $closing_Stock;
						
						
						
						$drct_expnsis .= '<tr><td align="right"> <b>Total</b> </td><td align="right">'.money_format('%!i', $direct_expense_total ).'</td></tr>';
						
						$sale_and_other .= '<tr><td align="right"> <b> Total </b> </td><td align="right">'.money_format('%!i', $sale_and_other_total ).'</td></tr>';
						
						if($direct_expense_total > $sale_and_other_total){
							$grossloss = $direct_expense_total - $sale_and_other_total;
							 $sale_and_other .=   '<tr><td align="center"><b> Gross Loss b/f    </b></td><td align="right">   '.money_format('%!i',   $grossloss  ).'</td></tr> 
							  <tr><td align="right"><b> Total </b></td><td align="right">   '.money_format('%!i',   $grossloss + $sale_and_other_total  ).'</td></tr>';
						}else{
							$grossprofit = $sale_and_other_total - $direct_expense_total;
							 $drct_expnsis .=   '<tr><td align="center"><b> Gross Profit c/o  </b></td><td align="right">   '.money_format('%!i',   $grossprofit  ).'</td></tr>
								<tr><td align="right"><b> Total  </b></td><td align="right">   '.money_format('%!i',   $grossprofit + $direct_expense_total  ).'</td></tr>';
						}
					$drct_expnsis .= '</table>';
					$sale_and_other .= '</table>';
					
					echo $drct_expnsis;
					echo $sale_and_other;
				?>
		
			</tbody>	
			</table>
			<table border="1" style="width: 100%" >
			<tbody>	
			<?php
			/*Indirect Expenses Indirect Income*/
				$Indrct_expnsis = '';
				$indirect_income = '';
				$Indrct_expnsis .= '<td style="width: 50%;"><table  class="table table-striped table-bordered" border="1" style="width: 100%;">';
				$indirect_income .= '<td><table class="table table-striped table-bordered" border="1" style="width: 100%;">';
				$closing_bal2 = 0;
							if($grossloss != 0 && $grossloss != ''){
								$Indrct_expnsis .= '<tr><th> Gross Loss c/o </th><th style="float: right;">'.money_format('%!i',$grossloss).'</th></tr>';
							}
							if($grossprofit != 0 && $grossprofit != ''){
								$indirect_income .= '<tr><th>Gross Profit c/o </th><th style="float: right;">'.money_format('%!i',$grossprofit).'</th></tr>';
							}	
							//$Indrct_expnsis .= '<tr><td> Opening Stock </td><td>'.$opening_Stock.'</td></tr>';
						foreach($account_group_id as $agid){
							$account_group_name = getNameById('account_group',$agid,'id');
							if($agid != 0){
								if( $agid == 12){
									$Grand_closing_bal21 = 0;
									foreach($data_acc as $account){//Grand total Code Start Here
									
										if($account['account_group_id'] == $agid){
											if( $agid == 12){
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
											$Grand_closing_bal21 += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
											
											}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
											  $Grand_closing_bal21 += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
											 
											}
										}
									}
								}//Grand total Code End Here

								
									
								
																
							$parent_name = getNameById('account_group',$agid,'id');
							$All_total_libility22 += $Grand_closing_bal21;
							
							$Indrct_expnsis .= '<tr><th>'. $parent_name->name.'</th><th style="float: right;">'.money_format('%!i', $Grand_closing_bal21).'</th></tr>';
						}
						
						
						if($agid == 11){
							
							$Grand_closing_bal = 0;
							foreach($data_acc as $account){//Grand total Code Start Here
								if($account['account_group_id'] == $agid){
									if( $agid == 11){
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
										 $Grand_closing_bal22 += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										 $Grand_closing_bal22 += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										}								
											
								}
							}
					}//Grand total Code End Here
					
							$parent_group_id2 = getNameById('account_group',$agid,'id');
							$All_total_sale22 += $Grand_closing_bal22;
							$indirect_income .= '<tr><th>'. $parent_group_id2->name.'</th><th style="float: right;">'.money_format('%!i', $Grand_closing_bal22).'</th></tr>';
							
						}
				}            
						$closing_bal = 0;
						
						
						foreach($data_acc as $account){
							
							if($account['account_group_id'] == $agid){
								if( $account['account_group_id'] == 12){
						
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
								$Acccount_group_name = getNameById('ledger',$account['ledgerid'],'id');
								if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
									$closing_bal2 = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										$Indrct_expnsis .= '<tr><td>'.$Acccount_group_name->name.'</td><td>'.money_format('%!i', $closing_bal2).'</td></tr>';
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
									  $closing_bal2 = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									 $Indrct_expnsis .= '<tr><td>'.$Acccount_group_name->name.'</td><td>'.money_format('%!i', $closing_bal2).'</td></tr>';
									}
									
									
									//pre($Acccount_group_name);
									
								}
								if($agid == 11){
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
									$Acccount_group_name = getNameById('ledger',$account['ledgerid'],'id');
										if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										 $closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
											$indirect_income .= '<tr><td>'.$Acccount_group_name->name.'</td><td>'.money_format('%!i', $closing_bal).'</td></tr>';
										}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										 $closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
											$indirect_income .= '<tr><td>'.$Acccount_group_name->name.'</td><td>'.money_format('%!i', $closing_bal).'</td></tr>';
										}
										  
										
									}
									
								}	
							}	
						}
						//$Indrct_expnsis .= '<tr><th> Gross Profit c/o </th><th style="float: right;">'.$grossloss.'</th></tr>';
						//$indirect_income .= '<tr><td> Closing Stock </td><td>'.$closing_Stock.'</td></tr>';
						
						 $indirect_expense_total = $All_total_libility22 + $grossloss;
						
						 $indirect_income_sale = $All_total_sale22 + $grossprofit;
						
						
						
						$Indrct_expnsis .= '<tr><td align="right"> <b>Total</b> </td><td align="right">'.money_format('%!i', $indirect_expense_total ).'</td></tr>';
						
						$indirect_income .= '<tr><td align="right"> <b> Total </b> </td><td align="right">'.money_format('%!i', $indirect_income_sale ).'</td></tr>';
						
						if($indirect_expense_total > $indirect_income_sale){
							$grossloss22 = $indirect_expense_total - $indirect_income_sale;
							 $indirect_income .=   '<tr><td align="center"><b> Net Loss  </b></td><td align="right">   '.money_format('%!i',   $grossloss22  ).'</td></tr> 
							  <tr><td align="right"><b> Total </b></td><td align="right">   '.money_format('%!i',   $grossloss22 + $indirect_income_sale  ).'</td></tr>';
						}else{
							$grossprofit22 = $indirect_income_sale - $indirect_expense_total;
							 $Indrct_expnsis .=   '<tr><td align="center"><b> Net Profit  </b></td><td align="right">   '.money_format('%!i',   $grossprofit22  ).'</td></tr>
								<tr><td align="right"><b> Total  </b></td><td align="right">   '.money_format('%!i',   $grossprofit22 + $indirect_expense_total  ).'</td></tr>';
						}
					$Indrct_expnsis .= '</table>';
					$indirect_income .= '</table>';
					
					echo $Indrct_expnsis;
					echo $indirect_income;	
					?>
				</tbody>			
			</table>
		
</div>	