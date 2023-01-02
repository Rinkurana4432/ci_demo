<div id="print_divv" class="col-md-12 col-sm-12 col-xs-12"  style="padding:0px;"> 
		<div class="table-responsive"> 
		        <h3 class="Material-head">Company Owner : <?php if(!empty($account) && ($account->account_owner !=0 || $account->account_owner != '')) {									
										$companyUserId =  getNameById('company_detail',$account->account_owner,'id')->u_id;										
										$accountOwnerName =  getNameById('user_detail',$companyUserId,'u_id')->name;
										echo $accountOwnerName;
										
									}?><hr></h3>
			<div class="col-md-6 col-xs-12 col-sm-6 label-left ">
                       <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Name</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->name; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-xs-12 col-sm-6 label-left ">
                                     <label for="material">Phone</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->phone; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">parent Account</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account) && $account->parent_account != 0) echo getNameById('account',$account->parent_account,'id')->name; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Website</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->website; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Account Type</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->type; ?></div>
									</div>
						</div>
						
            </div>
			
			
           <div class="col-md-6 col-xs-12 col-sm-6 label-left ">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Employee</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->employee; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Industry</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->industry; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Revenue</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->revenue; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Description</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->description; ?></div>
									</div>
						</div>
						
            </div>
			
<hr>
<div class="bottom-bdr"></div>			
 <h3 class="Material-head">Billing Address<hr></h3>			
			
<div class="col-md-6 col-xs-12 col-sm-6 label-left">
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Billing Street</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->billing_street; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Billing City</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account) && $account->billing_city != 0) echo getNameById('city',$account->billing_city,'city_id')->city_name; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Billing Zipcode / Postalcode</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->billing_zipcode; ?></div>
									</div>
						</div>
						</div>
<div class="col-md-6 col-xs-12 col-sm-6 label-left">						
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Billing State/Province</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account) && $account->billing_state != 0) echo getNameById('state',$account->billing_state,'state_id')->state_name; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Billing Country</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account) && $account->billing_country != 0) echo getNameById('country',$account->billing_country,'country_id')->country_name; ?></div>
									</div>
						</div>
</div>
<hr>
<div class="bottom-bdr"></div>
 <h3 class="Material-head">Shipping Address<hr></h3>	
<div class="col-md-6 col-xs-12 col-sm-6 label-left">
                       
						
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Shipping Street</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div ><?php if(!empty($account)) echo $account->shipping_street; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Shipping City</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div ><?php if(!empty($account)  && $account->shipping_city != 0) echo getNameById('city',$account->shipping_city,'city_id')->city_name; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Shipping Zipcode / Postalcode</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->shipping_zipcode; ?></div>
									</div>
						</div>
						</div>
						<div class="col-md-6 col-xs-12 col-sm-6 label-left">
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">shipping State/Province</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account) && $account->shipping_state != 0) echo getNameById('state',$account->shipping_state,'state_id')->state_name; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Shipping Country:</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)  && $account->shipping_country != 0) echo getNameById('country',$account->shipping_country,'country_id')->country_name; ?></div>
									</div>
						</div>
            </div>			
			
		</div>
</div>


												
                    <!--<table class="fixed data table table-bordered no-margin">												
						<thead>													
							<tbody>
								<tr>														
									<th>Account Owner:</th>													
									<td><?php if(!empty($account) && ($account->account_owner !=0 || $account->account_owner != '')) {									
										$companyUserId =  getNameById('company_detail',$account->account_owner,'id')->u_id;										
										$accountOwnerName =  getNameById('user_detail',$companyUserId,'u_id')->name;
										echo $accountOwnerName;
										
									}?></td>									
																					
								</tr>
								<tr>														
																		
									<th>Name:</th>														
									<td><?php if(!empty($account)) echo $account->name; ?></td>													
								</tr>		
								<tr>														
									<th>Phone:</th>													
									<td><?php if(!empty($account)) echo $account->phone; ?></td>												
								</tr>									
								<tr>			
									<th>parent Account:</th>														
									<td><?php if(!empty($account) && $account->parent_account != 0) echo getNameById('account',$account->parent_account,'id')->name; ?></td>											
								</tr>	
								<tr>			
									<th>Website:</th>														
									<td><?php if(!empty($account)) echo $account->website; ?></td>																						
								</tr>
								<tr>			
									<th>Account Type:</th>														
									<td><?php if(!empty($account)) echo $account->type; ?></td>									
																	
																					
								</tr>	
								<tr>			
																	
									<th>Employee:</th>														
									<td><?php if(!empty($account)) echo $account->employee; ?></td>									
																					
								</tr>
								<tr>			
									<th>Industry:</th>														
									<td><?php if(!empty($account)) echo $account->industry; ?></td>									
																		
																					
								</tr>	
								<tr>			
																	
									<th>Revenue:</th>														
									<td><?php if(!empty($account)) echo $account->revenue; ?></td>									
																					
								</tr>
								<tr>			
									<th>Description:</th>														
									<td><?php if(!empty($account)) echo $account->description; ?></td>	
								</tr>
								<tr>														
									<th>Billing Street</th>														
									<td><?php if(!empty($account)) echo $account->billing_street; ?></td>														
																	
								</tr>	
								<tr>														
																					
									<th>Billing City:</th>														
									<td><?php if(!empty($account) && $account->billing_city != 0) echo getNameById('city',$account->billing_city,'city_id')->city_name; ?></td>									
								</tr>							
								<tr>														
									<th>Billing Zipcode / Postalcode</th>														
									<td><?php if(!empty($account)) echo $account->billing_zipcode; ?></td>														
																		
								</tr>													
								<tr>														
																						
									<th>Billing State/Province:</th>	
									<td><?php if(!empty($account) && $account->billing_state != 0) echo getNameById('state',$account->billing_state,'state_id')->state_name; ?></td>									
								</tr>													
								<tr>														
									<th>Billing Country:</th>											
									<td><?php if(!empty($account) && $account->billing_country != 0) echo getNameById('country',$account->billing_country,'country_id')->country_name; ?></td>									
																					
								</tr>	
								<tr>														
																		
									<th>Shipping Street:</th>														
									<td><?php if(!empty($account)) echo $account->shipping_street; ?></td>													
								</tr>	

								<tr>								
									<th>Shipping City:</th>	
									<td><?php if(!empty($account)  && $account->shipping_city != 0) echo getNameById('city',$account->shipping_city,'city_id')->city_name; ?></td>
																			
								</tr>													
								<tr>								
								
									<th>Shipping Zipcode / Postalcode</th>														
									<td><?php if(!empty($account)) echo $account->shipping_zipcode; ?></td>										
								</tr>													
								<tr>														
																						
									<th>Shipping State/Province:</th>
									<td><?php if(!empty($account) && $account->shipping_state != 0) echo getNameById('state',$account->shipping_state,'state_id')->state_name; ?></td>											
																
								</tr>
								<tr>														
																						
																			
									<th>Shipping Country:</th>		
									<td><?php if(!empty($account)  && $account->shipping_country != 0) echo getNameById('country',$account->shipping_country,'country_id')->country_name; ?></td>									
								</tr>
								
							</tbody>												
						</thead>												
                    </table>-->	
					
					<center>
	<button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
	
</center>