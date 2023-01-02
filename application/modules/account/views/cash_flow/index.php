<div class="col-md-12 item offset-md-8" >
		<input type="hidden" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="login_user_id">
		
		<p class="text-muted font-13 m-b-30"></p>  
	<?php	
		setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');
	?>
		
		<!--div class="col-md-12 datePick">
			Date Range Picker                      
			  <fieldset>
				<div class="control-group">
				  <div class="controls">
					<div class="input-prepend input-group">
					  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
					  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/cash_flow" readonly>
					</div>
				  </div>
				</div>
			  </fieldset>
				<form action="<?php //echo base_url(); ?>account/cash_flow" method="post" id="date_range">	
				   <input type="hidden" value='' class='start_date' name='start'/>
				  <input type="hidden" value='' class='end_date' name='end'/>
				</form>	
		</div-->
		<?php
	if($company_brnaches->multi_loc_on_off == 1){
		if(!empty($company_brnaches)){
	?>
	<form action="<?php echo site_url(); ?>account/cash_flow" method="post" id="select_from_brnch">
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
			<input type="submit" value="Filter" class="btn btn-info">
		</div>
	</form>	
	<?php 
	} 
	}
	?>
			<div class="export_div">
			<div class="btn-group"  role="group" aria-label="Basic example">
					<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
					<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
					<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" onclick="window.location.href='<?php echo site_url(); ?>account/cash_flow'">Reset</button>
					<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
						<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
							<ul class="dropdown-menu" role="menu" id="export-menu">
								<li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
								<li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
							</ul>
					</div>
				</div>
			</div>
			<form action="<?php echo site_url(); ?>account/cash_flow" method="get" id="export-form">
					<input type="hidden" value='' id='hidden-type' name='ExportType'/>
					<input type="hidden" value='' class='start_date' name='start'/>
					<input type="hidden" value='' class='end_date' name='end'/>
				</form>
	 <div id="print_div_content">
		<center><table style="display:none;" class="comp_name"> <tr><td><b style="font-size:18px;"><?php echo $company_brnaches->name; ?></b> <br/><br/><b> Cash Flow</b></td></tr></table></center>
		<table  class="table table-striped table-bordered action-icons"  style="width:100%; margin-top:40px;" border="1" cellpadding="3">
			<thead>
				<tr>
					<th scope="col">S.No</th>
					<th scope="col">Particulars</th>
					<th scope="col">Inflow</th>
					<th scope="col">Outflow</th>
					<th scope="col">Net Flow</th>
				</tr>
			</thead>	
				<?php
				$parent_group_id = array_unique(array_column($cash_flow_val, 'parent_group_id'));
				// pre($parent_group_id);die();
				setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
				$unique_months = array_unique(array_map(function($elem){return $elem['period'];}, $cash_flow_val));
				
				$i = 0;
				$paymentReceivedArray = array();
				$paymentToArray = array();
				foreach($unique_months as $um){
					foreach($cash_flow_val as $res){
						//pre($res);
						$paymentReceivedArray[$i]['month'] = $um;
						if($res['parent_group_id'] == 6 && $res['account_group_id'] ==54){
						
						if($um == $res['period']){
							//pre($res);
							
						
						if($res['debit_amount'] != ''){
							
								$paymentReceivedArray[$i]['amount_recived'] += $res['debit_amount'];//Credit is show in In flow
								
							}
							if($res['credit_amount'] != ''){
								$paymentReceivedArray[$i]['amount_to'] += $res['credit_amount'];//Credit is show in out flow
							}
						}
						
						}	
					 
					}
					$i++;
				}
				
			
				$sno = 1;
					foreach($paymentReceivedArray as $chk_day){
						
						// if($chk_day['amount_recived'] !=0){
							// $recived_amount = $chk_day['amount_recived'];
						// }elseif($chk_day['amount_recived'] ==0){
							// $recived_amount = 0;
						// }elseif($chk_day['amount_to'] !=0){
							// $amount_to = $chk_day['amount_to'];
						// }elseif($chk_day['amount_to'] ==0){
							// $amount_to = 0;
						// }
						$dataa = $chk_day['amount_to'] -  $chk_day['amount_recived'];
						echo '<tr><td data-label="s.no:">'.$sno.'</td><td data-label="Particulars:">'.$chk_day['month'].'</td>';
						echo '<td data-label="inflow:">'.money_format('%!i',$chk_day['amount_recived']).'</td>';
						echo '<td data-label="outflow:">'.money_format('%!i',$chk_day['amount_to']).'</td>';
						echo '<td data-label="net flow:">'.money_format('%!i',abs($dataa)).'</td></tr>';
						
						
						
						$sno++;
						
					$output[] = array(
							   'Month' => $chk_day['month'],
							   'In Flow' => money_format('%!i',$chk_day['amount_recived']),
							   'Out Flow' => money_format('%!i',$chk_day['amount_to']),
							   'Net Flow' => money_format('%!i',abs($dataa))
							 );		
						
				}
				 $data3  = $output;
				export_csv_excel($data3);
				?>
				
			
			<tbody>
				
			</tbody>  
        </table>
		</div>
</div>


<?php
$this->load->view('common_modal');
?>