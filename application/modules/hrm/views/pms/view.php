<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv"  style="padding:0px;"> 
		<div class="table-responsive" >
		      <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
			       <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Company Unit :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($workerView)){ 
												$getUnitName= getNameById('company_address',$workerView->company_unit,'compny_branch_id');
												if(!empty($getUnitName)){
													echo $getUnitName->company_unit;
												}												
											} ?>
										</div>
									</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Worker Name :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($workerView)){ echo $workerView->name; } ?></div>
									</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Address :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($workerView)){ echo $workerView->address; } ?></div>
									</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Mobile number :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($workerView)){ echo $workerView->mobile_number; } ?></div>
									</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Country :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php 
															if(!empty($workerView)){
																$country = getNameById('country',$workerView->country,'country_id');
																if(!empty($country)){echo $country ->country_name; } else {echo "" ;}
															}
															?></div>
									</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">IFSC Code :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($workerView)){ echo $workerView->ifsc_code; } ?></div>
									</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Salary :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($workerView)){ echo $workerView->salary; } ?></div>
									</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Date Of joining :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($workerView)){ echo $workerView->date_of_joining; } ?></div>
									</div>
				</div>
		      </div>
			  <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
			       <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">State :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php 
															if(!empty($workerView)){
																$state = getNameById('state',$workerView->state,'state_id');
																if(!empty($state)){echo $state ->state_name;} else {echo "";}
															}
															?></div>
									</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">City :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php 
																if(!empty($workerView)){
																	$city = getNameById('city',$workerView->city,'city_id');
																	if(!empty($city)){echo $city ->city_name;} else{echo "";}
																}
																?></div>
									</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Bank Name :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php  if(!empty($workerView)){
															$bankName = getNameById('bank_name',$workerView->bank_name,'bankid');
															if(!empty($bankName)){echo $bankName ->bank_name;} else{ echo "";}
														}?></div>
									</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Branch Name :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($workerView)){ echo $workerView->branch_name; } ?></div>
									</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Account Number :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($workerView)){ echo $workerView->account_no; } ?></div>
									</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Date Of Relieving :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($workerView)){ echo $workerView->date_of_relieving; } ?></div>
									</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Other :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($workerView)){ echo $workerView->other; } ?></div>
									</div>
				</div>
		      </div>
			 
		</div>
</div>		


<!--<table class="fixed data table table-bordered no-margin" style="width:100%" id="print_divv" border="1" cellpadding="2">												
	<thead>													
		<tbody>	
			<tr>					
				<th>Company Unit :</th>						
				<td><?php if(!empty($workerView)){ echo $workerView->company_unit; } ?></td>						
			</tr>
			<tr>					
				<th>Worker Name:</th>						
				<td><?php if(!empty($workerView)){ echo $workerView->name; } ?></td>						
			</tr>
			<tr>						
				<th>Address</th>						
				<td><?php if(!empty($workerView)){ echo $workerView->address; } ?></td>	
			</tr>
			<tr>					
				<th>Mobile number:</th>						
				<td><?php if(!empty($workerView)){ echo $workerView->mobile_number; } ?></td>					
			</tr>
			<tr>						
				<th>Country:</th>						
				<td><?php 
					if(!empty($workerView)){
						$country = getNameById('country',$workerView->country,'country_id');
						if(!empty($country)){echo $country ->country_name; } else {echo "" ;}
					}
					?>
				</td>
			</tr>
			<tr>				
				<th>State:</th>						
				<td><?php 
					if(!empty($workerView)){
						$state = getNameById('state',$workerView->state,'state_id');
						if(!empty($state)){echo $state ->state_name;} else {echo "";}
					}
					?>
				</td>							
			</tr>
			<tr>						
				<th>City:</th>						
				<td><?php 
					if(!empty($workerView)){
						$city = getNameById('city',$workerView->city,'city_id');
						if(!empty($city)){echo $city ->city_name;} else{echo "";}
					}
					?>
				</td>
			</tr>
				
			<tr>						
				<th>Bank Name:</th>						
				<td><?php  if(!empty($workerView)){
						$bankName = getNameById('bank_name',$workerView->bank_name,'bankid');
						if(!empty($bankName)){echo $bankName ->bank_name;} else{ echo "";}
					}?>
				</td>
			</tr>
			<tr>				
				<th>Branch Name:</th>						
				<td><?php if(!empty($workerView)){ echo $workerView->branch_name; } ?></td>
			</tr>					
			<tr>						
				<th>Account Number:</th>						
				<td><?php if(!empty($workerView)){ echo $workerView->account_no; } ?></td>
			</tr>	
			<tr>
				<th>IFSC Code:</th>						
				<td><?php if(!empty($workerView)){ echo $workerView->ifsc_code; } ?></td>
			</tr>
			<tr>
				<th>Salary:</th>						
				<td><?php if(!empty($workerView)){ echo $workerView->salary; } ?></td>
			</tr>
			<tr>
				<th>Date Of joining:</th>						
				<td><?php if(!empty($workerView)){ echo $workerView->date_of_joining; } ?></td>
			</tr>	
			<tr>
				<th>Date Of Relieving:</th>						
				<td><?php if(!empty($workerView)){ echo $workerView->date_of_relieving; } ?></td>
			</tr>
			
			<tr>
				<th>Other:</th>						
				<td><?php if(!empty($workerView)){ echo $workerView->other; } ?></td>
			</tr>	
			
			
					
		</tbody>												
	</thead>												
</table>-->
<center>
	<button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
</center>