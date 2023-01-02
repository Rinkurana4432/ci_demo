				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<input type="hidden" name="id" value="<?php if(!empty($ledger)) echo $ledger->id; ?>">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<div class=" panel-default">
								<h3 class="Material-head"><?php if(!empty($ledger)) echo $ledger->name; ?><hr></h3>
								
							
										<div class="x_content">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">
												<!--<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
													<li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Information</a>
													</li>
													<li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Mailing Details</a>
													</li>
													
													<li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Company Details</a>
													</li>
													<li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Contact Person Details</a>
													</li>
												</ul>-->
												<div id="myTabContent" class="tab-content">
													<div role="tabpanel" class="tab-pane fade active in ledger-2" id="tab_content1" aria-labelledby="home-tab">
													  <!--<h3 class="Material-head">Contact Details <hr></h3>-->
														<div class="col-md-6 col-xs-12 col-sm-12 vertical-border ">
															
																	<!--tr>
																	  <th scope="row">Parent Ledger</th>
																	  <td><?php //if(!empty($ledger)) echo $ledger->type; ?></td>
																	</tr-->
																	<?php
																	
																
																		$group = getNameById('account_group',$ledger->account_group_id,'id')->name;
																		
																	?>
																	<div class="item form-group">
																	  <label class=" col-md-3 col-sm-3 col-xs-5" scope="row">Account Group </label>
																	  <div class="col-md-6 col-sm-6 col-xs-7"><?php if(!empty($ledger)) echo $group; ?></div>
																	</div>
																	
																	<div class="item form-group">
																	  <label class=" col-md-3 col-sm-3 col-xs-5" scope="row">Opening Balance</label>
																	  <div class="col-md-6 col-sm-6 col-xs-7"><?php if(!empty($ledger)) echo money_format('%!i',$ledger->opening_balance); ?></div>
																	</div>
																
																	<div class="item form-group">
																	  <label class=" col-md-3 col-sm-3 col-xs-5" scope="row">Website</label>
																	  <div class="col-md-6 col-sm-6 col-xs-7"><?php if(!empty($ledger->website)){ echo $ledger->website; }else{echo 'N/A';} ?></div>
																	</div>
																	<div class="item form-group">
																	  <label class=" col-md-3 col-sm-3 col-xs-5" scope="row">Registration Type</label>
																	  <div class="col-md-6 col-sm-6 col-xs-7"><?php if(!empty($ledger->registration_type)){echo $ledger->registration_type;}else{echo 'N/A';} ?></div>
																	</div>
																	<!--<div class="item form-group">
																	  <label class=" col-md-3 col-sm-3 col-xs-12" scope="row">GSTIN</label>
																	  <div class="col-md-6 col-sm-6 col-xs-12"></?php if(!empty($ledger->gstin)){ echo $ledger->gstin;}else{echo 'N/A';}; ?></div>
																	</div>-->
																	<div class="item form-group">
																	  <label class=" col-md-3 col-sm-3 col-xs-5" scope="row">Company PAN</label>
																	  <div class="col-md-6 col-sm-6 col-xs-7"><?php if(!empty($ledger->pan)){echo $ledger->pan;}else{echo 'N/A';} ?></div>
																	</div>
																 
														</div>
														
														<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
															
																	<div class="item form-group">
																	  <label class=" col-md-3 col-sm-3 col-xs-5" scope="row">Contact Person</label>
																	 <div class="col-md-6 col-sm-6 col-xs-7"><?php if(!empty($ledger)) echo $ledger->contact_person; ?></div>
																	</div>
																	<div class="item form-group">
																	  <label class=" col-md-3 col-sm-3 col-xs-5" scope="row">Phone</label>
																	  <div class="col-md-6 col-sm-6 col-xs-7"><?php if(!empty($ledger)) echo $ledger->phone_no; ?></div>
																	</div>
																	<div class="item form-group">
																	  <label class=" col-md-3 col-sm-3 col-xs-5" scope="row">Mobile</label>
																	  <div class="col-md-6 col-sm-6 col-xs-7"><?php if(!empty($ledger)) echo $ledger->mobile_no; ?></div>
																	</div>
																	<!--<div class="item form-group">
																	  <label class=" col-md-3 col-sm-3 col-xs-12" scope="row">Email</label>
																	  <div class="col-md-6 col-sm-6 col-xs-12"></?php if(!empty($ledger->email)){echo $ledger->email;}else{echo 'N/A';} ?></div>
																	</div>-->
																	<div class="item form-group">	
																	<label class="col-md-3 col-sm-3 col-xs-5">Email</label>														
																	<div class="col-md-6 col-sm-6 col-xs-7">	
																	<p><?php 
																		setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
																		if(!empty($ledger)) echo $ledger->email;
																		$datat =  json_decode($ledger->mailing_address,true);
																		
																		?></p>													
																	</div>												
																</div>
																 
														</div>
													</div>
													<hr>
													<div class="bottom-bdr"></div>
													<div role="tabpanel" class="tab-pane fade active in ledger-2" id="tab_content2" aria-labelledby="profile-tab">
														<div class="col-md-12 col-sm-6 col-xs-12">
														   
														   <h3 class="Material-head">Mailing Details<hr></h3>
														       <div class="label-box mobile-view3">
															         <div class="item form-group col-md-2 col-xs-12 col-sm-12"><label class="col-md-12 col-sm-3 col-xs-12">Mailing Address</label></div>
															         <div class="item form-group col-md-2 col-xs-12 col-sm-12"> <label class="col-md-12 col-sm-3 col-xs-12">Mailing Country</label></div>
															         <div class="item form-group col-md-2 col-xs-12 col-sm-12"><label class="col-md-12 col-sm-3 col-xs-12">Mailing State</label></div>
															         <div class="item form-group col-md-2 col-xs-12 col-sm-12"><label class="col-md-12 col-sm-3 col-xs-12">Mailing City</label></div>
															         <div class="item form-group col-md-2 col-xs-12 col-sm-12"><label class="col-md-12 col-sm-3 col-xs-12">Mailing Pincode</label></div>
															         <div class="item form-group col-md-2 col-xs-12 col-sm-12"><label class="col-md-12 col-sm-3 col-xs-12">GSTIN</label></div>
															         
															   </div>
														   <?php
															$address_dtl = json_decode($ledger->mailing_address,true);
															foreach($address_dtl as $new_dtl){
																 $state_name = getNameById('state',$new_dtl['mailing_state'],'state_id')->state_name;
																$city_name = getNameById('city',$new_dtl['mailing_city'],'city_id')->city_name;
																$country_name = getNameById('country',$new_dtl['mailing_country'],'country_id')->country_name;
																
														   ?>
														       <div class="row-padding col-container mobile-view view-page-mobile-view">
														         <div class="item form-group col-md-2 col-xs-12 col-sm-12" style="border-left:1px solid #c1c1c1 !important;">
																	  <label class="col-md-12 col-sm-3 col-xs-12">Mailing Address</label>
																	 <div class="col-md-12 col-sm-6 col-xs-12"><?php if(!empty($ledger)) echo $new_dtl['mailing_address']; ?></div>
																	</div>
																	<div class="item form-group col-md-2 col-xs-12 col-sm-12">
																	  <label class="col-md-12 col-sm-3 col-xs-12">Mailing Country</label>
																	  <div class="col-md-12 col-sm-6 col-xs-12"><?php if(!empty($ledger)) echo $country_name;  ?></div>									
																	</div>
																	<div class="item form-group col-md-2 col-xs-12 col-sm-12">
																	  <label class="col-md-12 col-sm-3 col-xs-12">Mailing State</label>
																	  <div class="col-md-12 col-sm-6 col-xs-12"><?php if(!empty($ledger)) echo $state_name; ?></div>
																	</div>
																	<div class="item form-group col-md-2 col-xs-12 col-sm-12">
																	  <label class="col-md-12 col-sm-3 col-xs-12">Mailing City</label>
																	  <div class="col-md-12 col-sm-6 col-xs-12"><?php if(!empty($ledger)) echo $city_name; ?></div>
																	</div>
																	
																	<div class="item form-group col-md-2 col-xs-12 col-sm-12">
																	  <label class="col-md-12 col-sm-3 col-xs-12">Mailing Pincode</label>
																	  <div class="col-md-12 col-sm-6 col-xs-12"><?php if(!empty($ledger)) echo $new_dtl['mailing_pincode']; ?></div>
																	</div>
																	<div class="item form-group col-md-2 col-xs-12 col-sm-12">	
																	   <label class="col-md-12 col-sm-3 col-xs-12">GSTIN</label>	
																	   <div class="col-md-12 col-sm-6 col-xs-12">	
																			<p><?php if(!empty($ledger)) echo $new_dtl['gstin_no'] ?></p>
																		</div>												
										                            </div>
																 </div>
															<?php } ?>	 
															</div>														
													</div>
													
												
													
													
													<div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab4">
														<div class="col-md-6 col-sm-6 col-xs-12">
															<table class="table table-striped">
																<tbody>
																	<tr>
																	  <th scope="row">Contact Person</th>
																	  <td><?php if(!empty($ledger)) echo $ledger->contact_person; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Phone</th>
																	  <td><?php if(!empty($ledger)) echo $ledger->phone_no; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Mobile</th>
																	  <td><?php if(!empty($ledger)) echo $ledger->mobile_no; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Email</th>
																	  <td><?php if(!empty($ledger->email)){echo $ledger->email;}else{echo 'N/A';} ?></td>
																	</tr>
																 </tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
																			
								</div>
							</div>
						</div>
					</div>
		
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<div class="form-group">
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>