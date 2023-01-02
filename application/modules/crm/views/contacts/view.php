<div id="print_divv" class="col-md-12 col-sm-12 col-xs-12"  style="padding:0px;"> 
		<div class="table-responsive">
		<h3 class="Material-head">Contact Owner:<?php if(!empty($contact) && $contact->contact_owner!=0) echo getNameById('user_detail',$contact->contact_owner,'c_id')->name; ?><hr></h3>
		      <div class="col-md-6 col-xs-12 col-sm-6 label-left " >
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Company</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div ><?php if(!empty($contact) && $contact->account_id!=0 ) echo getNameById('account',$contact->account_id,'id')->name; ?></div>
									</div>
								</div> 
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Name</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->first_name. ' '.$contact->last_name; ?></div>
									</div>
								</div> 
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Phone No.</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->phone; ?></div>
									</div>
								</div> 
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Mobile</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->mobile; ?></div>
									</div>
								</div> 
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Email</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->email; ?></div>
									</div>
								</div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Title</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->title; ?></div>
									</div>
								</div> 
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Edited By</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact) && $contact->edited_by!=0) echo getNameById('user_detail',$contact->edited_by,'u_id')->name; ?></div>
									</div>
								</div>
																
			  </div>
			  
			     <div class="col-md-6 col-xs-12 col-sm-6 label-left ">
			                    
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Created By</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)  && $contact->created_by!=0) echo getNameById('user_detail',$contact->created_by,'u_id')->name; ?></div>
									</div>
								</div> 
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Assistant Phone</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->asst_phone; ?></div>
									</div>
								</div> 
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Assistant</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->assistant; ?></div>
									</div>
								</div> 
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Department</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->department; ?></div>
									</div>
								</div> 
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Lead Source</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact) && $contact->lead_source !='' && $contact->lead_source !=0) { 
										$contact_source = getNameById('lead_source',$contact->lead_source,'id'); 
										echo $contact_source->source_name; 
										}
									?></div>
									</div>
								</div> 
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">DOB</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->dob; ?></div>
									</div>
								</div> 
																
			  </div>
<hr>
<div class="bottom-bdr"></div>
<h3 class="Material-head">Address Details<hr></h3>				  
			  <div class="col-md-6 col-xs-12 col-sm-6 label-left ">
			                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Mailing Zipcode / Postalcode</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->mailing_zipcode; ?></div>
									</div>
								</div> 
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Mailing State/Province:</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact) && $contact->mailing_state !=0) echo getNameById('state',$contact->mailing_state,'state_id')->state_name; ?></div>
									</div>
								</div> 
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Mailing City</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact) && $contact->mailing_city !=0) echo getNameById('city',$contact->mailing_city,'city_id')->city_name; ?></div>
									</div>
								</div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Mailing Country</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact) && $contact->mailing_country !=0) echo getNameById('country',$contact->mailing_country,'country_id')->country_name; ?></div>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Other Street</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->other_street; ?></div>
									</div>
								</div> 
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Other City</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact) && $contact->other_city !=0) echo getNameById('city',$contact->other_city,'city_id')->city_name; ?></div>
									</div>
								</div>
								
																
			  </div>
			  
			  <div class="col-md-6 col-xs-12 col-sm-6 label-left ">
			                     
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Other Zipcode / Postalcode</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->other_zipcode; ?></div>
									</div>
								</div> 
			                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Other State/Province</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)  && $contact->other_state !=0) echo getNameById('state',$contact->other_state,'state_id')->state_name; ?></div>
									</div>
								</div> 
			                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Other Country</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)  && $contact->other_country !=0) echo getNameById('country',$contact->other_country,'country_id')->country_name; ?></div>
									</div>
								</div>
                               <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Home Phone</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->home_phone; ?></div>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Other Phone</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->other_phone; ?></div>
									</div>
								</div> 
								
								<!--
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Company</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($contact)) echo $contact->company; ?></div>
									</div>
								</div>  -->
			  </div>


										
                    <!--<table class="fixed data table table-bordered  no-margin">												
						<thead>													
							<tbody>
								<tr>														
									<th>Contact Owner:</th>											
									<td><?php if(!empty($contact) && $contact->contact_owner!=0) echo getNameById('user_detail',$contact->contact_owner,'c_id')->name; ?></td>									
																				
								</tr>	
								<tr>														
																	
									<th>Account:</th>														
									<td><?php if(!empty($contact) && $contact->account_id!=0 ) echo getNameById('account',$contact->account_id,'id')->name; ?></td>													
								</tr>	
								<tr>														
									<th>Name:</th>													
									<td><?php if(!empty($contact)) echo $contact->first_name. ' '.$contact->last_name; ?></td>									
																						
								</tr>									
								<tr>														
																	
									<th>Phone No. :</th>													
									<td><?php if(!empty($contact)) echo $contact->phone; ?></td>														
								</tr>									
								<tr>			
									<th>Mobile:</th>														
									<td><?php if(!empty($contact)) echo $contact->mobile; ?></td>									
																	
																					
								</tr>	
								<tr>			
																
									<th>Email:</th>														
									<td><?php if(!empty($contact)) echo $contact->email; ?></td>									
																					
								</tr>	
								<tr>			
									<th>Title:</th>														
									<td><?php if(!empty($contact)) echo $contact->title; ?></td>									
																				
								</tr>										
								<tr>			
																	
									<th>Edited By:</th>														
									<td><?php if(!empty($contact) && $contact->edited_by!=0) echo getNameById('user_detail',$contact->edited_by,'u_id')->name; ?></td>									
																					
								</tr>										
								<tr>			
																
									<th>Created By:</th>														
									<td><?php if(!empty($contact)  && $contact->created_by!=0) echo getNameById('user_detail',$contact->created_by,'u_id')->name; ?></td>													
								</tr>										
								<tr>														
									<th>Mailing Zipcode / Postalcode</th>														
									<td><?php if(!empty($contact)) echo $contact->mailing_zipcode; ?></td>														
																			
								</tr>													
								<tr>														
																					
									<th>Mailing State/Province:</th>														
									<td><?php if(!empty($contact) && $contact->mailing_state !=0) echo getNameById('state',$contact->mailing_state,'state_id')->state_name; ?></td>
																						
								</tr>													
								<tr>														
																					
								
									<th>Mailing City:</th>														
									<td><?php if(!empty($contact) && $contact->mailing_city !=0) echo getNameById('city',$contact->mailing_city,'city_id')->city_name; ?></td>												
								</tr>													
								<tr>														
									<th>Mailing Country:</th>	
									<td><?php if(!empty($contact) && $contact->mailing_country !=0) echo getNameById('country',$contact->mailing_country,'country_id')->country_name; ?></td>								
																			
								</tr>	
								<tr>														
																	
									<th>Other Street:</th>														
									<td><?php if(!empty($contact)) echo $contact->other_street; ?></td>													
								</tr>	

								<tr>								
									<th>Other City:</th>														
									<td><?php if(!empty($contact) && $contact->other_city !=0) echo getNameById('city',$contact->other_city,'city_id')->city_name; ?></td>	
																			
								</tr>													
								<tr>								
										
									<th>Other Zipcode / Postalcode</th>														
									<td><?php if(!empty($contact)) echo $contact->other_zipcode; ?></td>										
								</tr>													
								<tr>														
																						
									<th>Other State/Province:</th>														
									<td><?php if(!empty($contact)  && $contact->other_state !=0) echo getNameById('state',$contact->other_state,'state_id')->state_name; ?></td>		
																					
								</tr>
								<tr>														
																						
									
									<th>Other Country:</th>	
									<td><?php if(!empty($contact)  && $contact->other_country !=0) echo getNameById('country',$contact->other_country,'country_id')->country_name; ?></td>												
								</tr>
								<tr>												
									
									<th>Home Phone:</th>	
									<td><?php if(!empty($contact)) echo $contact->home_phone; ?></td>												
								</tr>
								<tr>														
									<th>Other Phone: </th>														
									<td><?php if(!empty($contact)) echo $contact->other_phone; ?></td> 		
																	
								</tr>	
								<tr>														
									
									<th>Assistant Phone: </th>														
									<td><?php if(!empty($contact)) echo $contact->asst_phone; ?></td> 											
								</tr>	
								<tr>														
									<th>Assistant: </th>														
									<td><?php if(!empty($contact)) echo $contact->assistant; ?></td> 		
																				
								</tr>	
								<tr>														
										
									<th>Department: </th>														
									<td><?php if(!empty($contact)) echo $contact->department; ?></td> 											
								</tr>	
								<tr>														
									<th>Lead Source: </th>														
									<td>
									<?php if(!empty($contact) && $contact->lead_source !='' && $contact->lead_source !=0) { 
										$contact_source = getNameById('lead_source',$contact->lead_source,'id'); 
										echo $contact_source->source_name; 
										}
									?></td> 		
																				
								</tr>	
								<tr>														
									 		
									<th>DOB: </th>														
									<td><?php if(!empty($contact)) echo $contact->dob; ?></td> 											
								</tr>	
								 <tr>														
									<th>Company: </th>														
									<td><?php if(!empty($contact)) echo $contact->company; ?></td> 		
																				
								</tr>
								<tr>   
									<?php /*if(!empty($contact) && $contact->contacts!=''){ 
										$contacts = json_decode($contact->contacts);
									?>
										<th>contacts	: </th>	
										<td></td>
										<div class="x_content">
											<table class="table table-striped">
												<thead>
													<tr>
														<th>S.No</th>
														<th>Name</th>
														<th>Email</th>
														<th>Phone</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$i =1;
														foreach($contacts as $contact){
															
													?>					  
														<tr>
															<th scope="row"><?php echo $i; ?></th>
															<td><?php echo $contact->first_name . ' '.$contact->last_name ; ?></td>
															<td><?php echo $contact->email; ?></td>
															<td><?php echo $contact->phone_no; ?></td>
														</tr>
													<?php $i++;}?>									
												</tbody>
											</table>
										</div>
									<?php } */?>
								</tr>						
							</tbody>												
						</thead>												
                    </table>-->
					
					<center>
	<button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
	
</center>