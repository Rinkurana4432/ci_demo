<style>
#print_div_content table th:last-child {width:auto;}
</style>

<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	       <div class="col-md-4">
			                 
			<fieldset>
					<div class="control-group">
					  <div class="controls">
						<div class="input-prepend input-group">
						  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/balance_sheet"/>
						</div>
					  </div>
					</div>
					<form action="<?php echo base_url(); ?>account/balance_sheet" method="post" id="date_range">	
					   <input type="hidden" value='' class='start_date' name='start'/>
					  <input type="hidden" value='' class='end_date' name='end'/>
					</form>	
			</fieldset>
		</div>
	  </div>
</div>
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	} 
	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	//$Login_user_id = $_SESSION['loggedInUser']->c_id;
	$Login_user_id = $this->companyGroupId;
	

	
	?>
</div>
<!-- Branch Wise Balance Sheet -->
<?php
				$aDecode1 = $profit_loss_data;
				
				$account_group_id1 = array_unique(array_column($aDecode1, 'ledgerid'));
				$parent_group_id = array_unique(array_column($aDecode1, 'parent_group_id'));
				$acc = array_unique(array_column($aDecode1, 'name'));
				$data_acc_group = array_intersect_key($aDecod1e, $account_group_id1);
				$data_acc1 = array_intersect_key($aDecode1, $acc);
				$p_idd = array_intersect_key($aDecode1, $parent_group_id);
				
						
			
						foreach($account_group_id1 as $agid){
							
							$account_group_name = getNameById('account_group',$agid,'id');
							if($agid != 0){
								if( $agid == 8 || $agid == 10){
									$Grand_closing_bal21 = 0;
									foreach($data_acc1 as $account){//Grand total Code Start Here
									
										if($account['parent_group_id'] == $agid){
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
											$Grand_closing_bal21 += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
											}
										}
									}//Grand total Code End Here
								$All_total_libility2211 += $Grand_closing_bal21;
							}


						if($agid == 7 ){
							$Grand_closing_bal2232 = 0;
							foreach($data_acc1 as $account){//Grand total Code Start Here
								if($account['account_group_id'] == $agid){
									if( $agid == 7 ){
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
										$Grand_closing_bal2232 += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									}
								}
							}
							$parent_group_id2 = getNameById('account_group',$agid,'id');
							$All_total_sale += $Grand_closing_bal2232;
							
						}
						
						if($agid == 9){
							$Grand_closing_bal2232 = 0;
							foreach($data_acc1 as $account){//Grand total Code Start Here
								if($account['parent_group_id'] == $agid){
									if( $agid == 9 ){
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
										$Grand_closing_bal2232 += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									}
								}
							}
							$parent_group_id2 = getNameById('account_group',$agid,'id');
							$All_total_sale += $Grand_closing_bal2232;
						}
						
					}
				}
						

					 $direct_expense_total = $All_total_libility + $opening_Stock;
     				 $sale_and_other_total = $All_total_sale + $closing_Stock;
					if($direct_expense_total > $sale_and_other_total){
							$grossloss = $direct_expense_total - $sale_and_other_total;
						}else{
							$grossprofit = $sale_and_other_total - $direct_expense_total;
						}
						foreach($account_group_id1 as $agid){
							$account_group_name = getNameById('account_group',$agid,'id');
							if($agid != 0){
								if( $agid == 12){
									
									$Grand_closing_bal21 = 0;
									foreach($data_acc1 as $account){//Grand total Code Start Here
									//pre($account['parent_group_id']);
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
											$Grand_closing_bal21 += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										}
								}
							}//Grand total Code End Here



							$All_total_libility2211 += $Grand_closing_bal21;
						}


						if($agid == 11 ){

							$Grand_closing_bal2232 = 0;
							foreach($data_acc1 as $account){//Grand total Code Start Here
								if($account['parent_group_id'] == $agid){
									if( $agid == 11 ){
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
										// if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										 // $Grand_closing_bal22 += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										// }else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										 // $Grand_closing_bal22 += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										// }
										
										$Grand_closing_bal22 += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;

									}
								}
							}//Grand total Code End Here

							$parent_group_id2 = getNameById('account_group',$agid,'id');
							$All_total_sale2211 += $Grand_closing_bal22;
							
							
						}
					}
					
						
				}
						//$Indrct_expnsis .= '<tr><th> Gross Profit c/o </th><th style="float: right;">'.$grossloss.'</th></tr>';
						//$indirect_income .= '<tr><td> Closing Stock </td><td>'.$closing_Stock.'</td></tr>';
						
						

						 $indirect_expense_total = $All_total_libility2211 + $grossloss;

						 $indirect_income_sale = $All_total_sale2211 + $grossprofit; 
					

						if($indirect_expense_total > $indirect_income_sale){
								$TotalLossPrft = $indirect_income_sale - $indirect_expense_total;
							}else{
								$TotalLossPrft = $indirect_income_sale + $indirect_expense_total;
							}
					
			?>			
	

	<!-- Branch Wise Balance Sheet -->
	<div class="col-md-12 item form-group">
		<div class="col-md-12 item form-group">
		<div class="col-md-12 export_div">
		
		
					<div class="btn-group"  role="group" aria-label="Basic example">
						<form action="<?php echo base_url(); ?>account/balance_sheet" method="post" id="date_range56" >
						<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
						<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
						<input type="hidden" name="create_excel" value="checkk">
						<input type="hidden" name="On_selected_Branch_idd" value="<?php echo $_POST['selected_branch_idd']; ?>" id="selected_branch_id">
						<input type="hidden" value='<?php echo $_POST['start']; ?>' class='start_date' name='start'/>
			            <input type="hidden" value='<?php echo $_POST['end']; ?>' class='end_date' name='end'/>
						<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="create_excel">Create Excel</button>
						<!--button type="button" class="btn btn-default" data-toggle="collapse" data-target="#Branch">Company Branch</button-->
						<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" onclick="window.location.href='<?php echo site_url(); ?>account/balance_sheet'">Reset</button>
					</form>
							
					
					
  <div id="Branch" class="collapse">
   <?php
	setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
		$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');
	?>
	<?php
	if($company_brnaches->multi_loc_on_off == 1){
		if(!empty($company_brnaches)){
	?>
	<form action="<?php echo site_url(); ?>account/balance_sheet" method="post" id="select_from_brnch">
		<div class="required item form-group company_brnch_div" >
			
			<div class="col-md-12 col-sm-3 col-xs-12">
			<select class="itemName form-control Get_data_accoriding_tobranch" name="selected_branch_idd" required="required" 
				name="compny_branch_id" width="100%">
				<option value=""> Select Company Branch </option>
				<option >All</option>
				<?php
					 $branch_Add = json_decode($company_brnaches->address);
					 foreach($branch_Add as $val_branch){ ?>
					<option <?php if($val_branch->add_id == $_POST['selected_branch_idd']){ ?> selected="selected" <?php }?> value="<?php echo $val_branch->add_id; ?>"><?php echo $val_branch->compny_branch_name; $_POST['compny_branch_id']; ?> </option>
					
				</option>
			<?php } ?>
			</select>		
						
			</div>
			<input type="submit" value="Filter" class="btn btn-info">
		</div>
	</form>	
	<?php 
	} 
	}
	?>
  </div>
  <div class="col-md-4"></div>
</div>			
		</div>
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
						 $second_date = date('Y-m-d', $second_date22);
					}
				}
					
					$first_date_con = date("d-M-Y", strtotime($first_date));
					$second_date_con = date("d-M-Y", strtotime($second_date));
				$ddate = 	'('. $first_date_con .' to '. $second_date_con  .')';
			}
			//This Code is used to show Financial Year date and Filter Date showing
			
		?>
		<div id="print_div_content" style="margin-top:40px;">
		<center><table style="display:none;" class="comp_name"> <tr><td><b style="font-size:18px;"><?php echo $company_brnaches->name; ?></b> <br/><br/><b> Balance Sheet<br/><br/><?php echo $ddate;?></b></td></tr></table></center> <br/>
		<table   class="table table-striped table-bordered" border="1" >
			<?php
						setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
						
						
						
				$aDecode = $trial_balance_data; 
				
				
				$account_group_id = array_unique(array_column($aDecode, 'account_group_id'));
				
				$parent_group_id = array_unique(array_column($aDecode, 'parent_group_id'));
				$acc = array_unique(array_column($aDecode, 'name'));
				
				$data_acc_group = array_intersect_key($aDecode, $account_group_id);
				$data_acc = array_intersect_key($aDecode, $acc);
				$p_idd = array_intersect_key($aDecode, $parent_group_id);
				
				//pre($p_idd);
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
					$libTr .= '<td><table    class="table table-striped table-bordered" border="1" style="width: 100%">';
					$assTr .= '<td><table    class="table table-striped table-bordered" border="1" style="width: 100%">';
					
				
				
					$closing_bal2 = 0;
						foreach($account_group_id as $agid){
							
							 $parentID = getNameById('account_group',$agid,'id');
							 
							
								
							if($agid != 0){

								if( $agid == 1 || $parentID->parent_group_id == 2 || $agid == 3 || $agid == 17 || $agid == 55 || $agid == 13 || $parentID->parent_group_id == 3){
									$Grand_closing_bal2 = 0;
									foreach($data_acc as $account){//Grand total Code Start Here
										if($account['account_group_id'] == $agid){
											if($agid == 1 || $parentID->parent_group_id == 2 || $agid == 3 || $agid == 55 || $account['account_group_id'] == 17 || $agid == 13 || $parentID->parent_group_id == 3){
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
											// if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
												// $Grand_closing_bal2 += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
												// }else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
												  // $Grand_closing_bal2 += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
												// }	
												$Grand_closing_bal2 += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										}
										
										
									}
								}//Grand total Code End Here
									
							$parent_name = getNameById('account_group',$agid,'id');
							
							$All_total_libility += $Grand_closing_bal2;
							if($Grand_closing_bal2 != ''){
								if($agid == 13 ){
								
									if($indirect_expense_total > $indirect_income_sale){
										
										$TotalLossPrftchk = $indirect_expense_total - $indirect_income_sale;
										
										$totalSurplsAndGrnd =   $Grand_closing_bal2 - $TotalLossPrftchk;
									}else{
										
										$TotalLossPrftchk = $indirect_income_sale - $indirect_expense_total;
										
										$totalSurplsAndGrnd = $TotalLossPrftchk + $Grand_closing_bal2;
									}
									
									$libTr .= '<tr><th style="text-transform: capitalize;"> '. $parent_name->name.'</th><th style="float: right;"> '.money_format('%!i', $totalSurplsAndGrnd).'</th></tr>';
								}else{
									
									$libTr .= '<tr><th style="text-transform: capitalize;"> '. $parent_name->name.'</th><th style="float: right;">'.money_format('%!i', $Grand_closing_bal2).'</th></tr>';
								}	
							}
						}  
						// pre($agid);
						if( $agid == 4 || $agid == 5 || $parentID->parent_group_id == 6 ||  $agid == 54 ||  $agid == 48 ){
							$Grand_closing_bal = 0;
							foreach($data_acc as $account){//Grand total Code Start Here
								if($account['account_group_id'] == $agid){
									if($agid == 4 || $agid == 5 ||  $parentID->parent_group_id == 6  ||  $agid == 54 ||  $agid == 48 ){
										
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
											// if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
											// $Grand_closing_bal += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
											// }else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
											  // $Grand_closing_bal += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
											// }	
											
											$Grand_closing_bal += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										}
									}
							}//Grand total Code End Here
					
							$parent_group_id2 = getNameById('account_group',$agid,'id');
							
							$All_total_Ass += $Grand_closing_bal;
							if($Grand_closing_bal != ''){
								
								$assTr .= '<tr><th style="text-transform: capitalize;">'. $parent_group_id2->name.'</th><th style="float: right;">'.money_format('%!i', $Grand_closing_bal).'</th></tr>';
							}
						}
				}            
						$closing_bal = 0;
						
						foreach($data_acc as $account){
							
							
							if($account['account_group_id'] == $agid){
								$parentID = getNameById('account_group',$agid,'id');
								
									
								if($agid == 1 || $parentID->parent_group_id == 2 || $agid == 3 || $agid == 55  || $account['account_group_id'] == 17 || $agid == 13 || $parentID->parent_group_id == 3){
								
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
							
								// if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
									// $closing_bal2 = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
									// }else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
									  // $closing_bal2 = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									// }
									$closing_bal2 = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									
									$Acccount_group_name = getNameById('ledger',$account['ledgerid'],'id');
									
									if($ledger_amt_aftr_calcu_dr != '' || $ledger_amt_aftr_calcu_cr != '' ){
										$libTr .= '<tr><td style="text-transform: capitalize;">'.$Acccount_group_name->name.'</td><td>'.money_format('%!i', $closing_bal2).'</td></tr>'; 
									}
									if($agid == 13){
																		
										if($indirect_expense_total > $indirect_income_sale){
											$TotalLossPrft2 = $indirect_expense_total - $indirect_income_sale;
											 $libTr .=   '<tr><td style="text-transform: capitalize;"> Net Loss  </td><td align="">   '.money_format('%!i',   $TotalLossPrft2  ).'</td></tr>';
										}else{
											pre($indirect_expense_total);
											$TotalLossPrft3 = $indirect_income_sale - $indirect_expense_total;
											 $libTr .=   '<tr><td style="text-transform: capitalize;"> Net Profit  </td><td align="">   '.money_format('%!i',   $TotalLossPrft3  ).'</td></tr>';
										}
					
									}
								}
								
								if($agid == 4 || $agid == 5 ||  $parentID->parent_group_id == 6 ||  $agid == 54  ||  $agid == 48 ){
									
								
								
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
									
									
										// if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
											// $closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										// }else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										    // $closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										// }
										
										 $closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										//$Acccount_group_name = getNameById('account_group',$account['account_group_id'],'id');
										
										$Acccount_group_name1 = getNameById('ledger',$account['ledgerid'],'id');
										
										if($ledger_amt_aftr_calcu_dr != '' || $ledger_amt_aftr_calcu_cr != '' ){
											$assTr .= '<tr><td style="text-transform: capitalize;">'.$Acccount_group_name1->name.'</td><td>'.money_format('%!i', $closing_bal).'</td></tr>';
										}
								}
								
								
								
							}	
						}	
					}
					
					
			//$libOpBGrand_total = $grand_total_for_capital_acc_TOTAL+$libAmtTot;	
							$asstTotal = $closing_Stock + $All_total_Ass;
							
						
							
							if($indirect_expense_total > $indirect_income_sale){
								$TotalLossPrftchk1 = $indirect_expense_total - $indirect_income_sale;
								$allTotalWithprftLoss =   $All_total_libility - $TotalLossPrftchk1;
							}else{
								$TotalLossPrftchk1 = $indirect_income_sale - $indirect_expense_total;
								$allTotalWithprftLoss = $TotalLossPrftchk1 + $All_total_libility;
							}
							// $allTotalWithprftLoss  = $TotalLossPrft + $All_total_libility;
				
					$libTr .= '</td></table><table width="600"><tr><td align="center"><b>Total </b> </td><td align="right"><b>'.money_format('%!i', $allTotalWithprftLoss).'</b></td></tr></table>';
					echo $libTr;
					$assTr .= '</td></table><table class="table table-striped table-bordered" border="1" style="width: 100%"><tr><td style="text-transform: capitalize; font-weight:bold;">Closing Stock</td><td>'.$closing_Stock .'</td></tr></table><table width="900"><tr><td align="center"><b>Total </b> </td><td align="right"><b>' .money_format('%!i', $asstTotal) . '</b></td></tr></table>';
					echo $assTr;
				?>
		</tbody>
	</table>
	
	</div>
	</div>
</div>

