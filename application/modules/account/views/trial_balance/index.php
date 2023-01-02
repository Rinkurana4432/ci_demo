<div class="x_content">
    <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	        <div class="col-md-4">
				<fieldset>
					<div class="control-group">
					  <div class="controls">
						<div class="input-prepend input-group">
						  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/trial_balance"/>
						</div>
					  </div>
					</div>
					<form action="<?php echo base_url(); ?>account/trial_balance" method="get" id="date_range" >	
					   <input type="hidden" value='' class='start_date' name='start'/>
					  <input type="hidden" value='' class='end_date' name='end'/>
					</form>	
			</fieldset>
	    </div>
	  </div>
	</div>

	<?php

		if($this->session->flashdata('message') != ''){
			echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
		}
		
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		$Login_user_id = $this->companyGroupId;
		$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');
	?>
	<?php
	if($company_brnaches->multi_loc_on_off == 1){
		if(!empty($company_brnaches)){
	?>
	<form action="<?php echo site_url(); ?>account/trial_balance" method="get" id="select_from_brnch">
		<div class="required item form-group company_brnch_div" >
			<label class="col-md-8 col-sm-8 col-xs-12 required control-label col-md-3 col-sm-2 col-xs-4" for="company_branch">Company Branch</label>
			<div class="col-md-3 col-sm-3 col-xs-12">
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
			<input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
			<input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
			<!--button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
			<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="create_excel">Create Excel</button-->
			<input type="submit" value="Filter" class="btn btn-info">
		</div>
	</form>	
	<?php 
	} 
	}
	?>


	<div class="item form-group">
		<div class="item form-group" >		
		<div class="row hidde_cls ">
			<div class="col-md-12 export_div">
				
					<div class="btn-group"  role="group" aria-label="Basic example">
						<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
						<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
						<form action="<?php echo base_url(); ?>account/trial_balance" method="get" id="date_range56" >
							<input type="hidden" name="create_excel" value="checkk">
							<input type="hidden" name="On_selected_Branch_idd" value="<?php echo $_GET['selected_branch_idd']; ?>" id="selected_branch_id">
							<input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
							<input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="create_excel">Create Excel</button>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="create_pdf">Create PDF</button>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" onclick="window.location.href='<?php echo site_url(); ?>account/trial_balance'">Reset</button>

						</form>
						<form action="<?php echo base_url(); ?>account/trial_balance" method="get" id="date_range556" >
							<input type="hidden" name="create_PDF" value="checkk_pdf">
							
							<input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
							<input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
						</form>
							
					</div>
				
			</div>
		</div>
		<div id="print_div_content"><!--id="datatable-buttons"-->
		
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
						$second_date = date('Y-m-d', strtotime($second_date22));
					}
				}
					
					    $first_date_con = date("d-M-Y", strtotime($first_date));
					    $second_date_con = date("d-M-Y", strtotime($second_date));
				$ddate = 	'('. $first_date_con .' to '. $second_date_con  .')';
			}
			//This Code is used to show Financial Year date and Filter Date showing
			
		?>
		<center><table style="display:none;" class="comp_name"> <tr><td><b style="font-size:18px;"><?php echo $company_brnaches->name; ?></b> <br/><br/><b> Trial Balance<br/><br/><?php echo $ddate;?></b></td></tr></table></center> <br/>
		
		<table  id="day_book_id" class="table table-striped table-bordered" border="1"  style="margin-top:40px !important;">
			<?php
					setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
				 $aDecode = $ledger_Data;
			     $account_group_id = array_unique(array_column($aDecode, 'account_group_id'));
				 $parent_group_id = array_unique(array_column($aDecode, 'parent_group_id'));
				 $acc = array_unique(array_column($aDecode, 'ledgerid'));
				 $data_acc_group = array_intersect_key($aDecode, $account_group_id);
				 $data_acc = array_intersect_key($aDecode, $acc);
				 $p_idd = array_intersect_key($aDecode, $parent_group_id);
				 
				
	     echo '<thead>';
		 
						$debit_amount_for_grand_ttl	 = 0;
						$credit_amount_for_grand_ttl = 0;
						if($opening_Stock == ''){
							$opening_Stock = '0';
						}
						
						
						$totalOpeningStock = 0;
						$opening_Stock1 = "(inventory_flow.created_date <='".$first_date."') AND inventory_flow.created_by_cid = '".$this->companyGroupId."'";//opening Stock
						$closing_Stock1 = "(inventory_flow.created_date <='".$second_date."') AND inventory_flow.created_by_cid = '".$this->companyGroupId."'";//closing Stock
						$opening_Stock  = $this->account_model->getClosingBalance($opening_Stock1);
						$closing_Stock  = $this->account_model->getClosingBalance($closing_Stock1);
						
						$totalOpeningStock += $opening_Stock;
						if($opening_Stock == ''){
										$opening_Stock = '0';
									}

						echo '<tr><th>Opening Stock</th><th style="float: right;">'.$totalOpeningStock.'</th></tr>';
						echo '<tr><td> Opening Stock </td><td>'.$opening_Stock.'</td></tr>';
						
						
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
					
					// if($closing_bal !=''){
						// pre();
						
					// }
					
			// if($debit_amount != 0	 ||  $credit_amount != ''){
				
				echo '<tr style="background-color:#ddd;text-transform: capitalize;;"><th>';					
					foreach($p_idd as $get_parent_name){
						if($get_parent_name['account_group_id'] == $agid && $get_parent_name['parent_group_id'] != 0){
							$parent_name = getNameById('account_group',$get_parent_name['parent_group_id'],'id');
							echo '<span style="font-size: 14px;">'.$parent_name->name.'</span></br>';	
					}		
				}		
				echo '<span style="font-size: 14px;">'.$account_group_name->name.'</span></th>';
			
				echo '<th>Debit '. money_format('%!i',$debit_amount).'</th>';
				echo '<th>Credit '. money_format('%!i',$credit_amount).'</th></tr></thead><tbody>';
	//	}
				foreach($data_acc as $account){
					if($account['account_group_id'] == $agid){
										
						if($account['ledger_id'] != ''){
							$ledger_name = getNameById('ledger',$account['ledgerid'],'id');
						}else{
							$ledger_name = getNameById('ledger',$account['id'],'id');
						}

						
							// echo $account['ledgerid'].'<br/>';
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
										echo '<tr>';
										// echo '<td width="500px"><a href="javascript:void(0)" id="'. $account['ledgerid'] . '" data-id="ledger_view" class="add_account_tabs">'.$account['name'].'</a></td>';
										echo '<td width="500px" style="font-size: 12px;"><a href="javascript:void(0)" class="lager_rp_name" data-id='.$account['ledgerid'].' >'. $account['name'] .'</a></td>';
									
									if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										
											 echo '<td >' .money_format('%!i',$closing_bal).'</td>';//Debit
											 echo '<td></td>'; 
										
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										
											echo '<td></td>';
											echo '<td >'.money_format('%!i', $closing_bal).'</td>';//Credit
										
									}
								}	
							'</tr>';
								echo '<tr style="display:none;"><td>'.$get_parent_name['created_date'].'</td></tr>';	
							
						}
					}
			 
			}					
		 
		
			
	?>
	<tr><td colspan="4"></td></tr>
	<tr><td colspan="4"></td></tr>
	<tr>
			<th width="90px" style="text-align: center;  width:69%;">Grand Total</th>
			<td width="90px" style="text-align: center;"> <?php echo money_format('%!i', $debit_amount_for_grand_ttl); ?></td>
			<td width="90px" style="text-align: center;"> <?php  echo money_format('%!i', $credit_amount_for_grand_ttl);  ?></td>
		</tr>
		</tbody>
		
	</table>
		
	</div>
	</div>
</div>
</div>
<?php $this->load->view('common_modal'); ?>