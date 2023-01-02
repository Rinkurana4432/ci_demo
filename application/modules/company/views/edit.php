<div class="x_content">
	<?php if($this->session->flashdata('message') != ''){
			echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
		}
		//if(!empty($company)){
			if($_SESSION['loggedInUser']->role != 2){
					echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Edit</button>';
			}
		//}				
	?>
	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-large">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Company Edit</h4>
					<div class="project_progress">
						<div class="progress progress_sm">
							<div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo $profileComplete; ?>"></div>
						</div>
						<small>Profile <?php echo $profileComplete; ?>% Complete</small>
					</div>
				</div>
				<div class="modal-body">
					<div class="row">	
						<?php if($_SESSION['loggedInUser']->role != 2){ ?>						  
							<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>company/save" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
								<div class="col-md-6 col-sm-12 col-xs-12 form-group">
									<?php /*<input type="hidden" name="id" value="<?php if(!empty($company)) echo $company->c_id; ?>">
									<input type="hidden" name="u_id" value="<?php if(!empty($company)) echo $company->u_id; ?>">*/?>
									<input type="hidden" name="id" value="<?php if(!empty($company)) echo $company->id; ?>">									
									<input type="hidden" name="u_id" value="<?php if(!empty($company)) echo $company->u_id; ?>">
									<input type="hidden" name="c_id" value="<?php if(!empty($company)) echo $company->c_id; ?>">
									<div class="panel panel-default">
										<div class="panel-heading"><h3 class="panel-title"><strong>Information </strong></h3></div>
										<div class="panel-body">							
											<div class="item form-group">
												<label class="control-label col-md-2 col-sm-3 col-xs-12" for="name">Company Name<span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" value="<?php if(!empty($company)) echo $company->name; ?>" name="name" placeholder="ex. John f. Kennedy" required="required" type="text" <?php if(!empty($company)) echo 'disabled'; ?>> 
												</div>
											</div>
											<div class="item form-group">
												<label class="control-label col-md-2 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php if(!empty($company)) echo $company->email; ?>" <?php if(!empty($company)) echo 'disabled'; ?>>
												</div>
											</div>
											<div class="item form-group">
												<label class="control-label col-md-2 col-sm-3 col-xs-12" for="email">Phone <span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="tel" id="phone" name="phone" required="required" data-validate-length-range="8,10" class="form-control col-md-7 col-xs-12" placeholder="+91 9858468953" value="<?php if(!empty($company)) echo $company->phone; ?>">
												</div>
											</div>
											<div class="item form-group">
												<label class="control-label col-md-2 col-sm-3 col-xs-12" for="gstin">GSTIN<span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" id="designation" name="gstin" data-validate-length-range="8,20" required="required" class="form-control col-md-7 col-xs-12" placeholder="GSTIN number" value="<?php if(!empty($company)) echo $company->gstin; ?>" <?php if(!empty($company)) echo 'disabled'; ?>>
												</div>
											</div>
											<div class="item form-group">
												<label class="control-label col-md-2 col-sm-3 col-xs-12" for="name">Company PAN<span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input id="companyPan" class="form-control col-md-7 col-xs-12 companyPan" value="<?php if(!empty($company)) echo $company->company_pan; ?>" name="company_pan" placeholder="ABCDFA87565B" required="required" type="text" onblur="fnValidatePAN(this);"> 
												</div>
											</div>
											<div class="item form-group">
												<label class="control-label col-md-2 col-sm-3 col-xs-12" for="gstin">Company Type</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="radio" class="flat" name="company_type" id="manufacturer" value="manufacturer" <?php if(!empty($company) && $company->company_type == 'manufacturer'){ echo 'checked'; } ?> required /> Manufacturer&nbsp;
													<input type="radio" class="flat" name="company_type" id="trader" value="trader" <?php if(!empty($company) && $company->company_type == 'trader'){ echo 'checked'; } ?>/> Trader&nbsp;
													<input type="radio" class="flat" name="company_type" id="wholesaler" value="wholesaler" <?php if(!empty($company) && $company->company_type == 'wholesaler'){ echo 'checked'; } ?>/> Wholesaler&nbsp;
												</div>
											</div>
											<?php /*<div class="item form-group">
												<label class="control-label col-md-2 col-sm-3 col-xs-12" for="expierence">Company Logo</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="col-md-12">
														<input type="hidden" name="fileOldlogo" value="<?php /*echo isset($company->logo)?$company->logo: " ";?>">
														<!--<input type="file" class="form-control col-md-7 col-xs-12" name="logo" id="logoSite">--->
														<button type="button" class="btn btn-default" name="logo" id="logoSite">Upload Logo</button>
														
													</div>
													<div id="logo-holder" class="col-md-5">
														<img src="<?php echo base_url('assets/modules/company/uploads').'/'.(isset($company->logo) && $company->logo != '' ?$company->logo:"company-logo.jpg ");?>" class="img-responsive">
													</div>											
												</div>
											</div>*/?>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12 form-group">
									<div class="panel panel-default">
										<div class="panel-heading"><h3 class="panel-title"><strong>About </strong></h3></div>
										<div class="panel-body" style="overflow-y:scroll; height: 410px;">						 
											<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="establish">Year Of Est. <span class="required">*</span></label>
												<div class="col-md-5 col-sm-6 col-xs-12">
													<input type="text" id="year" name="year_of_establish" required="required" class="form-control col-md-7 col-xs-12 date-picker-year" placeholder="ex.2001" value="<?php if(!empty($company)) echo $company->year_of_establish; ?>"> 
												</div>
											</div>
											<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address2">Description <span class="required">*</span></label>
												<div class="col-md-5 col-sm-6 col-xs-12">
													<textarea id="description" required="required" name="description" class="form-control col-md-7 col-xs-12" row="6" placeholder="Description"><?php if(!empty($company)) echo $company->description; ?></textarea>
												</div>
											</div>
											<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="employees">Employees</label>
												<div class="col-md-5 col-sm-6 col-xs-12">
													<input type="number" id="no_employees" name="no_of_employees" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($company)) echo $company->no_of_employees; ?>" placeholder="0">
												</div>
											</div>
											<div class="item form-group keyPeopleWrap">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="employees">Key People</label>
												<?php if(!empty($company) && $company->key_people !=''  && $company->key_people !='[""]'){
														$keyPeoples = json_decode($company->key_people);
														$i=0;												
														foreach($keyPeoples as $keyPeople){
														if($i==0){
															$btn = '<button class="btn btn-warning add_field_button" type="button"><i class="fa fa-plus"></i></button>';
															$class = '';
														}else{
															$btn = '<button class="btn btn-danger remove_field" type="button"><i class="fa fa-minus"></i></button>';
															$class = 'wrapperLeftMargin';
														}
															if($keyPeople != ''){
																echo '<div class="col-md-6 col-sm-5 col-xs-12 input_fields_wrap '.$class.'">
																<input type="text" id="key_people" name="key_people[]" class="form-control col-md-7 col-xs-12 fieldAdd" placeholder="Mr.john" value="'.$keyPeople.'">'.$btn.'
																
																</div>'; 
															}
															$i++;
														}
													}else{
														echo '<div class="col-md-6 col-sm-5 col-xs-12 input_fields_wrap">
																<input type="text" id="key_people" name="key_people[]" class="form-control col-md-7 col-xs-12 fieldAdd" placeholder="Mr.john" value=""><button class="btn btn-warning add_field_button" type="button"><i class="fa fa-plus"></i></button></div>';
													}
													?>										
											</div>
											
											<?php /*<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Website</label>
												<div class="col-md-5 col-sm-6 col-xs-12">
													<input type="url" id="website" name="website" class="form-control col-md-7 col-xs-12 optional" placeholder="http://www.website.com" value="<?php if(!empty($company)) echo $company->website; ?>"> 
												</div>
											</div> */?>
											<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="revenue">Revenue</label>
												<div class="col-md-5 col-sm-6 col-xs-12">
													<input type="text" id="range" value="<?php if(!empty($company)) echo $company->revenue; ?>" name="revenue" /> 
												</div>
											</div>
										</div>
									</div>
								</div>		

								<?php /*   Bank details*/?>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<div class="panel panel-default">
										<div class="panel-heading"><h3 class="panel-title"><strong>Bank Account Details </strong></h3></div>
										<div class="panel-body">						 
											<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="establish">Bank Account Name <span class="required">*</span></label>
												<div class="col-md-5 col-sm-6 col-xs-12">
													<input type="text" id="account_name" name="account_name" required="required" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($company)) echo $company->account_name; ?>"> 
												</div>
											</div>
											<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="account_no">Account Number <span class="required">*</span></label>
												<div class="col-md-5 col-sm-6 col-xs-12">
													<input type="text" id="account_no" name="account_no" required="required" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($company)) echo $company->account_no; ?>"> 
												</div>
											</div>
											<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="account_ifsc_code">Bank IFSC Code</label>
												<div class="col-md-5 col-sm-6 col-xs-12">
													<input type="text" id="account_ifsc_code" name="account_ifsc_code" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($company)) echo $company->account_ifsc_code; ?>">
												</div>
											</div>											
											<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank_name">Bank Name</label>
												<div class="col-md-5 col-sm-6 col-xs-12">
													<input type="text" id="bank_name" value="<?php if(!empty($company)) echo $company->bank_name; ?>" name="bank_name" class="form-control col-md-7 col-xs-12"/> 
												</div>
											</div>
											<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="branch">Bank Branch</label>
												<div class="col-md-5 col-sm-6 col-xs-12">
													<input type="text" id="branch" value="<?php if(!empty($company)) echo $company->branch; ?>" name="branch" class="form-control col-md-7 col-xs-12"/> 
												</div>
											</div>
										</div>
									</div>
								</div>	

								<?php /*   Bank details*/?>
									
									
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<div class="panel panel-default">
										<div class="panel-heading"><h3 class="panel-title"><strong>Address</strong></h3></div>
										<div class="panel-body address_wrapper">
											<?php if(!empty($company) && $company->address !='' && $company->address !='[""]'){
												$addressDetail = json_decode($company->address);
												echo '<input type="hidden" class="addressLength" value="'.count($addressDetail).'">';
												$j=0;												
												foreach($addressDetail as $address){
												//	echo '<input type="hidden" class="country_id" value="'.$address->country.'" closestDiv="chkIndex_'.$j.'" state_data="'.$address->state.'">';
													//echo '<input type="hidden" class="state_id" value="'.$address->state.'" closestDiv="chkIndex_'.$j.'" city_data="'.$address->city.'">';
													//echo '<input type="hidden" class="city_id" value="'.$address->city.'" closestDiv="chkIndex_'.$j.'">';
													
													if($j==0){
														$addBtn = '<button class="btn btn-warning add_address_button" type="button"><i class="fa fa-plus"></i></button>';
													}else{
														$addBtn = '<button class="btn btn-danger remove_address_field" type="button"><i class="fa fa-minus"></i></button>';
													}
														if($addressDetail != ''){	
														
														/*	echo '<div class="item form-group"><div class="col-md-12 input_address_wrap" id="chkIndex_'.$j.'"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group"><textarea id="address" required="required" name="address[]" class="form-control col-md-7 col-xs-12" placeholder="Address">'.$address->address.'</textarea></div><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="col-md-3 col-sm-12 col-xs-12 form-group"> <select name="country[]" id="country" class="form-control input-lg company-drop country" onchange="getState(event,this)"><option value="">Select Country</option>';
															$chkCountry = '';
															foreach($country as $cntry){
																if($cntry->country_id == $address->country){
																	$chkCountry = 'selected';
																}else{
																	$chkCountry = '';
																}
																echo '<option value="'.$cntry->country_id.'"' .$chkCountry.'>'.$cntry->country_name.'</option>';
															}
															echo '</select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"> <select name="state[]" id="state" class="form-control input-lg company-drop state" onchange="getCity(event,this)"><option value="">Select State</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><select name="city[]" id="city" class="form-control input-lg company-drop city"><option value="">Select City</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" id="postal_zipcode" name="postal_zipcode[]" class="form-control col-md-1" placeholder="Postal/Zipcode" value="'.$address->postal_zipcode.'"></div>'.$addBtn.'</div></div></div>'; */
															
															
															echo '<div class="item form-group"><div class="col-md-12 input_address_wrap" id="chkIndex_'.$j.'"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group"><textarea id="address" required="required" name="address[]" class="form-control col-md-7 col-xs-12" placeholder="Address">'.$address->address.'</textarea></div>';
															?>
															
															
																<div class="item form-group col-md-3 col-sm-3 col-xs-12">
																	<label class="control-label col-md-4 col-sm-4 col-xs-4" for="billing_country">Permanent Country</label>
																	<div class="col-md-8 col-sm-8 col-xs-8">
																		<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="country[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getState(event,this)">
																			<option value="">Select Option</option>
																			 <?php
																				if(!empty($address)){
																					$country = getNameById('country',$address->country,'country_id');
																					echo '<option value="'.$address->country.'" selected>'.$country->country_name.'</option>';
																				}
																			?>
																		</select>
																	</div>
																</div>											
																<div class="item form-group col-md-3 col-sm-3 col-xs-12">
																	<label class="control-label col-md-4 col-sm-4 col-xs-4" for="permanent_state">Permanent State/Province<span class="required">*</span></label>
																	<div class="col-md-8 col-sm-8 col-xs-8">								
																		<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1 state_id" name="state[]"  width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getCity(event,this)">
																			<option value="">Select Option</option>
																			 <?php
																				if(!empty($address)){
																					$state = getNameById('state',$address->state,'state_id');
																					echo '<option value="'.$address->state.'" selected>'.$state->state_name.'</option>';
																				} 
																			?>
																		</select>
																	</div>
																</div>	
																<div class="item form-group col-md-3 col-sm-3 col-xs-12">
																	<label class="control-label col-md-4 col-sm-4 col-xs-4" for="city">Permanent City<span class="required">*</span></label>
																	<div class="col-md-8 col-sm-8 col-xs-8">										
																		<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1 city_id" name="city[]"  width="100%" tabindex="-1" aria-hidden="true" required="required">
																			<option value="">Select Option</option>
																			 <?php
																				if(!empty($address)){
																					$city = getNameById('city',$address->city,'city_id');
																					echo '<option value="'.$address->city.'" selected>'.$city->city_name.'</option>';
																				}
																			?>
																		</select>
																	</div>
																</div>
																<div class="col-md-2 col-sm-12 col-xs-12 form-group">
																	<input type="text" id="postal_zipcode" name="postal_zipcode[]" class="form-control col-md-1" placeholder="Postal/Zipcode" value="<?php echo $address->postal_zipcode;?>">
																</div><?php echo $addBtn; ?>
																
																</div>
															</div>
															
															
															
															
															
															
														<?php }
														$j++;
													}
												}else{ 
												/*	echo '<div class="item form-group"><div class="col-md-12 input_address_wrap" id="chkIndex_0"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group"><textarea id="address" required="required" name="address[]" class="form-control col-md-7 col-xs-12" placeholder="Address"></textarea></div><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="col-md-3 col-sm-12 col-xs-12 form-group"> <select name="country[]" id="country" class="form-control input-lg company-drop country" onchange="getState(event,this)"><option value="">Select Country</option>';
													foreach($country as $cntry){
													 echo '<option value="'.$cntry->country_id.'">'.$cntry->country_name.'</option>';
													}
													echo '</select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"> <select name="state[]" id="state" class="form-control input-lg company-drop state" onchange="getCity(event,this)"><option value="">Select State</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><select name="city[]" id="city" class="form-control input-lg company-drop city"><option value="">Select City</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" id="postal_zipcode" name="postal_zipcode[]" class="form-control col-md-1" placeholder="Postal/Zipcode" value=""></div><button class="btn btn-warning add_address_button sdsd" type="button"><i class="fa fa-plus"></i></button></div></div></div>'; */ ?>
													
													<div class="item form-group">
														<div class="col-md-12 input_address_wrap" id="chkIndex_0">
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
																<textarea id="address" required="required" name="address[]" class="form-control col-md-7 col-xs-12" placeholder="Address"></textarea>
															</div>
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<?php /*	<div class="col-md-3 col-sm-12 col-xs-12 form-group"> 
																	<select name="country[]" id="country" class="form-control input-lg company-drop country" onchange="getState(event,this)">
																		<option value="">Select Country</option>																	
																	</select>
																</div>
																<div class="col-md-3 col-sm-12 col-xs-12 form-group">
																	<select name="state[]" id="state" class="form-control input-lg company-drop state" onchange="getCity(event,this)"><option value="">Select State</option></select>
																</div>
																<div class="col-md-3 col-sm-12 col-xs-12 form-group">
																	<select name="city[]" id="city" class="form-control input-lg company-drop city">
																		<option value="">Select City</option>
																	</select>
																</div> */?>
																
																<div class="item form-group col-md-3 col-sm-3 col-xs-12">
																	<label class="control-label col-md-4 col-sm-4 col-xs-4" for="billing_country">Permanent Country</label>
																	<div class="col-md-8 col-sm-8 col-xs-8">
																		<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="country[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getState(event,this)">
																			<option value="">Select Option</option>
																			 <?php
																				/*if(!empty($user)){
																					$country = getNameById('country',$user->permanent_country,'country_id');
																					echo '<option value="'.$user->permanent_country.'" selected>'.$country->country_name.'</option>';
																				}*/
																			?>
																		</select>
																	</div>
																</div>											
																<div class="item form-group col-md-3 col-sm-3 col-xs-12">
																	<label class="control-label col-md-4 col-sm-4 col-xs-4" for="permanent_state">Permanent State/Province<span class="required">*</span></label>
																	<div class="col-md-8 col-sm-8 col-xs-8">								
																		<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1 state_id" name="state[]"  width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getCity(event,this)">
																			<option value="">Select Option</option>
																			 <?php
																				/*if(!empty($company)){
																					$state = getNameById('state',$company->permanent_state,'state_id');
																					echo '<option value="'.$company->permanent_state.'" selected>'.$state->state_name.'</option>';
																				} */
																			?>
																		</select>
																	</div>
																</div>	
																<div class="item form-group col-md-3 col-sm-3 col-xs-12">
																	<label class="control-label col-md-4 col-sm-4 col-xs-4" for="city">Permanent City<span class="required">*</span></label>
																	<div class="col-md-8 col-sm-8 col-xs-8">										
																		<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1 city_id" name="city[]"  width="100%" tabindex="-1" aria-hidden="true" required="required">
																			<option value="">Select Option</option>
																			 <?php
																				/*if(!empty($company)){
																					$city = getNameById('city',$company->permanent_city,'city_id');
																					echo '<option value="'.$company->permanent_city.'" selected>'.$city->city_name.'</option>';
																				} */
																			?>
																		</select>
																	</div>
																</div>																
																<div class="col-md-2 col-sm-12 col-xs-12 form-group">
																	<input type="text" id="postal_zipcode" name="postal_zipcode[]" class="form-control col-md-1" placeholder="Postal/Zipcode" value="">
																</div>
																<button class="btn btn-warning add_address_button sdsd" type="button"><i class="fa fa-plus"></i></button>
															</div>
														</div>
													</div>
													
													
												<?php } 
												?>
											
										</div>
									</div>
								</div>
								
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<div class="panel panel-default">
										<div class="panel-heading"><h3 class="panel-title"><strong>Certifications </strong></h3></div>
										<div class="panel-body">	
											<div class="item form-group certificationWrap">
												<label class="control-label col-md-1 col-sm-2 col-xs-12" for="certificate">Certification</label>
												<div class="col-md-11 col-sm-6 col-xs-12 fields_wrap">
													<input type="file" class="form-control col-md-7 col-xs-12 certificationField" name="certification[]">
													<button class="btn btn-warning field_button" type="button"><i class="fa fa-plus"></i></button>
												</div>
												
											</div>
											<?php if(!empty($companyCertificate)){?>
												<div class="item form-group">
													<div class="col-md-12 outline">
														<?php foreach($companyCertificate as $compCer){
																	echo '<div class="img-wrap"><div class="col-md-1 img-outline"><a href="javascript:void(0)" class="delete_listing close-link cross" style="z-index:111;" data-href="'.base_url(). 'company/deleteCertificate/'.$compCer[ 'id']. '"><i class="fa fa-trash" style="color:#e60a03;"></i></a><img style="height:50px;" src="'.base_url(). 'assets/modules/company/uploads/'.$compCer[ 'file_name']. '" alt="image" class="img-responsive"/></div></div>';
														} ?>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
								
								<?php /*<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<div class="panel panel-default">
										<div class="panel-heading"><h3 class="panel-title"><strong>Your Google Map Location </strong></h3></div>
										<div class="panel-body">	
											<div class="item form-group">
												<label class="control-label col-md-2 col-sm-3 col-xs-12" for="name">Company Location Iframe</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input id="mapiframe" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($company)) echo $company->mapiframe; ?>" name="mapiframe" placeholder="Embed Your Location From Google Map & Paste It Here" type="text"> 
												</div>
											</div>
										</div>
									</div>
								</div> */ ?>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<div class="panel panel-default">
										<div class="panel-heading"><h3 class="panel-title"><strong>Social Links </strong></h3></div>
										<div class="panel-body">
											<div class="item form-group">
												<label class="control-label col-md-2 col-sm-3 col-xs-12" for="textarea">Facebook</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="url" id="facebook" name="facebook" class="form-control col-md-7 col-xs-12 optional" placeholder="" value="<?php if(!empty($company)) echo $company->facebook; ?>"> 
												</div>
											</div>
											<div class="item form-group">
												<label class="control-label col-md-2 col-sm-3 col-xs-12" for="textarea">Twitter</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="url" id="twitter" name="twitter" class="form-control col-md-7 col-xs-12 optional" placeholder="" value="<?php if(!empty($company)) echo $company->twitter; ?>"> 
												</div>
											</div>
											<div class="item form-group">
												<label class="control-label col-md-2 col-sm-3 col-xs-12" for="textarea">Instagram</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="url" id="instagram" name="instagram" class="form-control col-md-7 col-xs-12 optional" placeholder="" value="<?php if(!empty($company)) echo $company->instagram; ?>"> 
												</div>
											</div>
											<div class="item form-group">
												<label class="control-label col-md-2 col-sm-3 col-xs-12" for="textarea">Linkedin</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="url" id="linkedin" name="linkedin" class="form-control col-md-7 col-xs-12 optional" placeholder="" value="<?php if(!empty($company)) echo $company->linkedin; ?>"> 
												</div>
											</div>
											<div class="item form-group">
												<label class="control-label col-md-2 col-sm-3 col-xs-12" for="textarea">Google+</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="url" id="google_plus" name="google_plus" class="form-control col-md-7 col-xs-12 optional" placeholder="" value="<?php if(!empty($company)) echo $company->google_plus; ?>"> 
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
										<input type="submit" class="btn btn-warning submitCompanyBtn" value="Submit"> 
									</div>
								</div>
								
							</form>
						<?php } ?>	
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="reset" class="btn btn-default">Reset</button>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- ------ VIEW PAGE ------- -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">			
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 image-opt">
				<button type="button" class="btn btn-warning" id="cover-opt"><i class="fa fa-pencil-square-o"></i></a></button>
				<div id="covermenu" class="coverpicmenu">
					<a href="javascript:void(0)" data-href="<?php if(!empty($company)) { echo base_url().'company/deleteCoverPhoto/'.$company->id; }?>" class="btn btn-danger delete_listing"><i class="fa fa-trash"></i></a><br/>
					
					<?php if($_SESSION['loggedInUser']->role != 2){ ?><button type="button" class="btn btn-info" data-toggle="modal" data-target=".bs-example-modal-upload"><i class="fa fa-upload"></i></a></button><?php } ?>
					<div class="modal fade bs-example-modal-upload" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-md">
							<div class="modal-content">
								<div class="modal-body">
									<form method="post" class="form-horizontal" action="<?php //echo base_url(); ?>company/saveCoverPhoto" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
										<div class="row">	
											<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Cover Pic</label>
												<div class="col-md-9 col-sm-9 col-xs-12">
													<div class="col-md-12">
														<input type="hidden" name="fileOldCoverPhoto" value="<?php echo isset($company->id)?$company->cover_photo: " ";?>">
													<?php /*	<input type="hidden" name="id" value="<?php if(!empty($company)) echo $company->c_id; ?>">
														<input type="hidden" name="u_id" value="<?php if(!empty($company)) echo $company->u_id; ?>">*/?>
														<input type="file" class="form-control col-md-7 col-xs-12" name="cover_photo" id="cover_photo">
														<input type="hidden" name="id" value="<?php if(!empty($company)) echo $company->id; ?>">
														<input type="hidden" name="u_id" value="<?php if(!empty($company)) echo $company->u_id; ?>">
														<input type="hidden" name="c_id" value="<?php if(!empty($company)) echo $company->c_id; ?>">
													</div>
												</div>
											</div>
										</div>
										<!-- <div class="row">	
											<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Remove Cover Pic</label>
												<div class="col-md-9 col-sm-9 col-xs-12">
													<a href="<?php /*if(!empty($company)) { echo base_url().'company/deleteCoverPhoto/'.$company->id; } */?>"><button type="button" class="btn btn-danger delete_listing close-link"><i class="fa fa-trash"></i></a></button></a>
												</div>
											</div>
										</div>	-->								
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<input type="submit" class="btn btn-warning" value="Submit"> 
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
			<?php	if(!empty($company) && $company->cover_photo!=''){
						echo '<img src="'.base_url().'assets/modules/company/uploads/'.$company->cover_photo.'" alt="Company Cover Pic" class="img-responsive" style="max-height:310px; width:100%">';
					}else{ 
						echo '<img src="'.base_url().'assets/modules/company/uploads/companybg.png" alt="Company Cover Pic" class="img-responsive" style="max-height:310px; width:100%">'; 
					} ?>
	</div> 
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<!-- Social Profile -->
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 erp-socialtop">
				<?php if(!empty($company)){
					echo $company->facebook != ""?'<a href="'.$company->facebook.'"><button type="button" class="btn btn-primary"><i class="fa fa-facebook"></i></button></a>':'';
					echo $company->google_plus != ""?'<a href="'.$company->google_plus.'"><button type="button" class="btn btn-danger"><i class="fa fa-google-plus"></i></button></a>':'';
					echo $company->twitter != ""?'<a href="'.$company->twitter.'"><button type="button" class="btn btn-info"><i class="fa fa-twitter"></i></button></a>':'';
					echo $company->instagram != ""?'<a href="'.$company->instagram.'"><button type="button" class="btn btn-danger"><i class="fa fa-instagram"></i></button></a>':'';
					echo $company->linkedin != ""?'<a href="'.$company->linkedin.'"><button type="button" class="btn btn-primary"><i class="fa fa-linkedin"></i></button></a>':'';
				} ?>
			</div>
			<!-- Comapany Logo -->
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col-md-offset-1 company-dp">
				<img class="img-circle img-responsive comp-logo" src="<?php echo base_url('assets/modules/company/uploads').'/'.(isset($company->logo) && $company->logo != '' ?$company->logo:"company-logo.jpg");?>" alt="Company Logo" title="Logo Of Company">
				
				<h2><?php if(!empty($company)) echo $company->name; ?></h2>
			</div>
			<!-- Connect -->
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 erp-socialtop">
				<?php /*<button type="button" class="btn btn-warning pull-right connectBtn">Connect</i></button>			
				<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target=".bs-example-modal-message">Message</a></button>			*/?>	
				<div class="modal fade bs-example-modal-message" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-md">
						<div class="modal-content">
							<div class="modal-body">
								<div class="row">	
								<?php if($_SESSION['loggedInUser']->role != 2){ ?>						  
									<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>company/save" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
										<div class="item form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="expierence">Message</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<div class="col-md-12">
													<textarea id="message" name="message[]" class="form-control col-md-12 col-xs-12 fieldAdd" placeholder="Type Your Message Here"></textarea>
												</div>
											</div>
										</div>																		
									<?php } ?>							
								</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<input type="submit" class="btn btn-warning" value="Submit"> 
							</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</div> 
	<!-- --------------------------- Left Sidebar -------------------- -->
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<!-- --------------------------- About Section (Left Side) -------------------- -->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>About Us</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<p class="text-justify"><?php if(!empty($company) && $company->description != ''){ echo $company->description; }?></p>
					</div>
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<button type="button" class="btn btn-primary pull-right hidden-sm hidden-xs" id="about-more">View More</i></button>
							<button type="button" class="btn btn-primary pull-right hidden-lg hidden-md" id="about-more1">View More</i></button>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 about-phone hidden-lg hidden-md" id="about-detail1">
				<div class="x_panel">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
						<table class="table table-bordered">
							<!-- <thead>
								<tr>
									<th>Row</th>
									<th>Bill</th>
								</tr>
							</thead> -->
							<tbody>
								<tr class="success">
									<th colspan="2"><h2>Information</h2></th>
								</tr>
								<tr>
									<th>GSTIN</th>
									<th><?php if(!empty($company)) echo $company->gstin; ?></th>
								</tr>
								<tr>
									<th>PAN</th>
									<th><?php if(!empty($company)) echo $company->company_pan; ?></th>
								</tr>
								<tr>
									<th>Company Type</th>
									<th><?php if(!empty($company)) echo $company->company_type; ?></th>
								</tr>
								<tr class="success">
									<th colspan="2"><h2>About</h2></th>
								</tr>
								<tr>
									<th>Year Of Establishment</th>
									<th><?php //if(!empty($company)) echo $company->year_of_establish; ?></th>
								</tr>
								<tr>
									<th>Employees</th>
									<th><?php if(!empty($company)) echo $company->no_of_employees; ?></th>
								</tr>
								<tr>
									<th>Key People</th>
									<th>
												<?php 
												if(!empty($company)) {
														$keyPeoples = json_decode($company->key_people);
														foreach($keyPeoples as $keyPeople){
															if($keyPeople != ''){
																echo $keyPeople. '<br>'; 
															}
														}
													} ?>
									</th>
								</tr>
								<tr>
									<th>Revenue</th>
									<th><?php if(!empty($company)) echo $company->revenue; ?></th>
								</tr>
								<tr class="success">
									<th colspan="2"><h2>Address</h2></th>
								</tr>
								<tr>
									<th colspan="2"> 
										<ul>
											<?php 
												if(!empty($company)) {
														$addresses = json_decode($company->address);
														foreach($addresses as $compAddress){	
															$city = getNameById('city',$compAddress->city,'city_id');
															$state = getNameById('state',$compAddress->state,'state_id');
															$country = getNameById('country',$compAddress->country,'country_id');
															if($compAddress != ''){
																echo '<li>'.$compAddress->address.' , '.$city->city_name.' , '.$state->state_name.' , '.$country->country_name.' , '.$compAddress->postal_zipcode.'</li>'; 
															}
														}
													} ?>
										
											
										</ul>
									</th>
								</tr>
								
								
								
								
								<tr class="success">
									<th colspan="2"><h2>Certifications</h2></th>
								</tr>
								<tr>
									<th colspan="2">
										<?php if(!empty($companyCertificate)){?>
											<div class="item form-group">
												<div class="col-md-12">
													<?php foreach($companyCertificate as $compCer){
														echo '<div class="col-md-2 img-outline">
														<img style="height:50px;" src="'.base_url(). 'assets/modules/company/uploads/'.$compCer[ 'file_name']. '" alt="image" class="img-responsive"/>
														</div>';
													} ?>
												</div>
											</div>
										<?php } ?>	
									</th>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- --------------------------- Employees -------------------- -->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Employees</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<?php 
							if(!empty($users)){
								$userLength = count($users);
								$userLength = $userLength - 11;
								$i = 0;
								foreach($users as $user){
								if($i<11){
								$user_profile  = (isset($user['user_profile']) && $user['user_profile'] != '') ?$user['user_profile']:"userp.png";
									echo '<div class="col-lg-3 col-md-6 col-sm-3 col-xs-3"><a href="'.base_url().'users/edit/'.$user['id'].'">
										<img src="'.base_url().'assets/modules/users/uploads/'.$user_profile.'" data-toggle="tooltip" data-placement="bottom" title="'.$user['name'].'" data-toggle="tooltip" data-placement="bottom" title="Employee1 Name" class="img-responsive" alt="img">
										</a></div>';
										$i++;
									}
								} 
							} 
							if($userLength >0)
							echo $userLength.'<i class="fa fa-plus"></i> more employees work here';
							?>						
					</div>
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<a href="<?php echo base_url().'users'; ?>"><button type="button" class="btn btn-primary pull-right">View More</i></button></a>
						</li>
					</ul>
				</div>
			</div>
			<!-- --------------------------- Gallery -------------------- -->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-12">
						<div class="x_panel">
							<div class="x_title">
								<h2>Media Gallery</h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<div class="row erp-gallerytop">
								
								<?php
									if(!empty($postCommentData)){
										foreach($postCommentData as $postComment){?>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<img src="<?php echo ($postComment['post']['image']!='')?base_url().'assets/modules/company/uploads/'.$postComment['post']['image']: base_url().'assets/modules/company/uploads/companybg.png';?>" class="avatar-view img-responsive" alt="Avatar">
									</div>										
										<?php }	}?> 
								</div>
								
																
							</div>
							<?php /*<ul class="nav navbar-right panel_toolbox">
								<li>
									<a href=""><button type="button" class="btn btn-primary pull-right">View More</i></button></a>
								</li>
							</ul>*/?>
						</div>
					</div>
				</div>
			</div>
			<!-- --------------------------- Products -------------------- -->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-12">
						<div class="x_panel">
							<div class="x_title">
								<h2>Our Products</h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">							
								<div class="row erp-gallerytop">
								<?php if(!empty($products)){
										foreach($products as $product){ 
										$proImage  = (isset($product['file_name']) && $product['file_name'] != '') ?$product['file_name']:"userp.png";
											echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
												<img src="'.base_url().'assets/modules/inventory/uploads/'.$proImage.'" data-toggle="tooltip" data-placement="bottom" title="'.$product['material_name'].'" class="avatar-view img-responsive" alt="Avatar">
											</div>';
								 } } ?>
								</div>				
							</div>
							<ul class="nav navbar-right panel_toolbox">
								<li>
									<a href="<?php echo base_url(); ?>inventory/materials"><button type="button" class="btn btn-primary pull-right">View More</i></button></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- --------------------------- News Feeds -------------------- -->
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">		
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 about-phone hidden-sm hidden-xs" id="about-detail">
				<div class="x_panel">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
						<table class="table table-bordered">
							<!-- <thead>
								<tr>
									<th>Row</th>
									<th>Bill</th>
								</tr>
							</thead> -->
							<tbody>
								<tr class="success">
									<th colspan="2"><h2>Information</h2></th>
								</tr>
								<tr>
									<th>GSTIN</th>
									<th><?php if(!empty($company)) echo $company->gstin; ?></th>
								</tr>
								<tr>
									<th>PAN</th>
									<th><?php if(!empty($company)) echo $company->company_pan; ?></th>
								</tr>
								<tr>
									<th>Company Type</th>
									<th><?php if(!empty($company)) echo $company->company_type; ?></th>
								</tr>
								<tr class="success">
									<th colspan="2"><h2>About</h2></th>
								</tr>
								<tr>
									<th>Year Of Establishment</th>
									<th><?php if(!empty($company)) echo $company->year_of_establish; ?></th>
								</tr>
								<tr>
									<th>Employees</th>
									<th><?php if(!empty($company)) echo $company->no_of_employees; ?></th>
								</tr>
								<tr>
									<th>Key People</th>
									<th>
									<?php 
												if(!empty($company) && $company->key_people !='') {
														$keyPeoples = json_decode($company->key_people);
														foreach($keyPeoples as $keyPeople){
															if($keyPeople != ''){
																echo $keyPeople. '<br>'; 
															}
														}
													} ?>
									</th>
								</tr>
								<tr>
									<th>Revenue</th>
									<th><?php if(!empty($company)) echo $company->revenue; ?></th>
								</tr>
								<tr class="success">
									<th colspan="2"><h2>Address</h2></th>
								</tr>
								<tr>
									<th colspan="2"> 
										<ul>
										<?php 
												if(!empty($company) && $company->address !='') {
														$addresses = json_decode($company->address);
														foreach($addresses as $compAddress){	
															$city = getNameById('city',$compAddress->city,'city_id');
															$state = getNameById('state',$compAddress->state,'state_id');
															$country = getNameById('country',$compAddress->country,'country_id');
															if($compAddress != ''){
																echo '<li>'.$compAddress->address.' , '.$city->city_name.' , '.$state->state_name.' , '.$country->country_name.' , '.$compAddress->postal_zipcode.'</li>'; 
															}
														}
													} ?>
										
											
										</ul>
									</th>
								</tr>
								
								
								
								<tr class="success">
									<th colspan="2"><h2>Bank Account Information</h2></th>
								</tr>
								<tr>
									<th>Account Name</th>
									<th><?php if(!empty($company)) echo $company->account_name; ?></th>
								</tr>
								<tr>
									<th>Account Number</th>
									<th><?php if(!empty($company)) echo $company->account_no; ?></th>
								</tr>
								<tr>
									<th>IFSC Code</th>
									<th><?php if(!empty($company)) echo $company->account_ifsc_code; ?></th>
								</tr>
								<tr>
									<th>Bank</th>
									<th><?php if(!empty($company)) echo $company->bank_name; ?></th>
								</tr>
								<tr>
									<th>Branch</th>
									<th><?php if(!empty($company)) echo $company->branch; ?></th>
								</tr>
								
								
								
								<tr class="success">
									<th colspan="2"><h2>Certifications</h2></th>
								</tr>
								<tr>
									<th colspan="2">
										<?php if(!empty($companyCertificate)){?>
											<div class="item form-group">
												<div class="col-md-12">
													<?php foreach($companyCertificate as $compCer){
														echo '<div class="col-md-2 img-outline">
														<img style="height:50px;" src="'.base_url(). 'assets/modules/company/uploads/'.$compCer[ 'file_name']. '" alt="image" class="img-responsive"/>
														</div>';
													} ?>
												</div>
											</div>
										<?php } ?>	
									</th>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			
			<button type="button" class="col-lg-12 btn btn-warning" id="newsfeedmore"><i class="fa fa-newspaper-o"></i>&nbsp;View News Feed</a></button>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 about-phone" id="newsfeed">
				<?php /*     Post       */?>			
					<ul class="list-unstyled msg_list">
						<li>							
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="x_panel"><h5>CREATE POST</h5></div>
								<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>company/savePost" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
									<span class="message">
										<textarea class="form-control" name="description" rows="3" placeholder="Write text here..." required></textarea>
									</span>
									<br/>
									<div class="col-md-12">
										<input type="file" class="form-control col-md-7 col-xs-12" name="image" id="image">
									</div><br/>
									<button type="submit" class="btn btn-primary btn-xs pull-right">Submit Post</i></button>
								</form>
							</div>								
						</li>
					</ul>
					
			<?php
			if(!empty($postCommentData)){
				foreach($postCommentData as $postComment){?>
				<div class="x_panel">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
					<?php $postedByUserData = getNameById('user_detail',$postComment['post']['created_by'],'u_id');
						$userProfileImage = (!empty($postedByUserData) && $postedByUserData->user_profile!='')?$postedByUserData->user_profile:'userp.png';
						?>
						<img src="<?php echo base_url('assets/modules/users/uploads').'/'.$userProfileImage;?>" data-toggle="tooltip" data-placement="bottom" title="User Name" alt="..." style="width:80%;">
					</div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
						<div class="x_title">						
							<h5 class="text-justify"><?php echo $postComment['post']['description']; ?></h5>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="x_content">						
						<img src="<?php echo ($postComment['post']['image']!='')?base_url().'assets/modules/company/uploads/'.$postComment['post']['image']: base_url().'assets/modules/company/uploads/companybg.png';?>" alt="Company Cover Pic" class="img-responsive">						
					</div>
					<div class="col-xs-12 text-center erp-like">
						<div class="col-xs-12 col-sm-6 col-md-offset-3">
							<button type="button" class="btn btn-success btn-xs"> 
								<i class="fa fa-thumbs-up"></i> Like
							</button>
							<a class="btn btn-primary btn-xs" data-toggle="collapse" href="#<?php echo $postComment['post']['id']; ?>" role="button" aria-expanded="false" aria-controls="<?php echo $postComment['post']['id']; ?>"><i class="fa fa-comments-o"> </i> View Comments</a> 
						</div>
					</div>
						<ul class="list-unstyled msg_list">
								<li>
									<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
										<span class="image">
										  <img src="<?php echo base_url('assets/modules/users/uploads').'/'.($user['user_profile'] != '' ?$user['user_profile']:"userp.png");?>" alt="Company Logo" title="Logo Of Company" class="img-responsive">
										</span>
									</div>
									<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
									<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>company/saveComment" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
										<input type="hidden" value="<?php echo $user['id']; ?>" name="created_by"> 
										<input type="hidden" value="<?php echo $postComment['post']['id']; ?>" name="post_id"> 
										<span>
										  <span>John Smith</span>								  
										</span>
										<span class="message">
											<textarea class="form-control" rows="3" name="comment" placeholder="Post Your Comment" required></textarea>
										</span>
										<span>
										<br/>
										<button type="submit" class="btn btn-primary btn-xs pull-right">Post Comment</i></button>
									</form>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
										<span class="time"><?php echo $postComment['post']['created_date']; ?></span>
									</div>										
								</li>
							</ul>	
					<div class="collapse multi-collapse" id="<?php echo $postComment['post']['id']; ?>">
						<div class="x_content" style="overflow-y: scroll; height: 350px;">
						<?php  if(!empty($postComment['comments'])){
								echo '<ul class="list-unstyled msg_list">';
								foreach($postComment['comments'] as $pc ){
									$commentedByUserData = getNameById('user_detail',$pc['created_by'],'u_id');
									$commentedByProfileImage = (!empty($commentedByUserData) && $commentedByUserData->user_profile!='')?$commentedByUserData->user_profile:'userp.png';
								?>			
								<li>
									<a>
										<span class="image">
										  <img src="<?php echo base_url('assets/modules/users/uploads').'/'.$commentedByProfileImage;?>" alt="img" class="img-responsive"/>
										</span>
										<span>
										  <span><?php echo $commentedByUserData->name ;?></span>
										  <span class="time"><?php echo $pc['created_date'] ;?></span>
										</span>
										<span class="message"><?php echo $pc['comment']; ?></span>
									</a>
								</li> 
								<?php  }
								echo '</ul>'; 
								} ?>
						</div>
					</div>								
				<?php }	}?> 
				</div>
			</div>
			<?php /*   Post  Section Ends     */    ?>
			
			
		</div>
		<!-- --------------------------- Right Sidebar -------------------- -->
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<!-- --------------------------- Contact -------------------- -->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php /* <img src="<?php echo (!empty($company) && $company->cover_photo!='')?base_url().'assets/modules/company/uploads/'.$company->cover_photo: base_url().'assets/modules/company/uploads/companybg.png';?>"" alt="Company Cover Pic" class="img-responsive">*/ ?>
					<?php if(!empty($company)  && $company->mapiframe !=''){
									$iframe =  $company->mapiframe;
									preg_match_all( '@src="([^"]+)"@' , $iframe, $match );
									$src = array_pop($match);
									echo '<iframe src="'.$src[0].'" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>';
					}	?>
				
				<div class="x_panel">
					<div class="x_title">
						<h2>Contact Us</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<ul class="list-unstyled user_data">
							<?php if(!empty($company)){
								$addresses = json_decode($company->address);								
							
							if($company->phone != ''){ 
								echo '<li><i class="fa fa-phone user-profile-icon"></i>&nbsp; '.$company->phone.'</li>';
							}
							 if($company->email != ''){ 
								echo '<li><i class="fa fa-envelope user-profile-icon"></i>&nbsp; '.$company->email.'</li>';
							}
							
							 if($company->website != ''){ 
								echo '<li class="m-top-xs"><i class="fa fa-external-link user-profile-icon"></i><a href="'.$company->website.'" target="_blank">&nbsp; '.$company->website.'</a></li>';
							}
							 } ?>
						</ul>
					</div>
				</div>
			</div>
			<!-- --------------------------- Connections -------------------- -->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">			
				<div class="x_panel">
					<div class="x_title">
						<h2>Connections</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
					<?php if(!empty($connections)){
					//pre($connections);
						foreach($connections as $connection){ ?>
						<div class="col-lg-3 col-md-6 col-sm-3 col-xs-3">
							<a href="#1">
								<img src="<?php echo base_url('assets/modules/company/uploads').'/'.($connection['logo'] != '' ?$connection['logo']:"company_placeholder.png");?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $connection['name']; ?>" class="img-responsive" alt="img">
							</a>
						</div>
				
						<?php } } ?>
						<?php 							
							$where = ' AND connection.requested_by ='.$_SESSION['loggedInUser']->c_id.' or connection.requested_to ='.$_SESSION['loggedInUser']->c_id.' AND connection.status = 1';	
							echo total_rows('connection','connection.status=1 '.$where);
							 /*?><i class="fa fa-plus"></i> more */?>
							 connections they have
					</div>
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<a href="<?php echo base_url().'company/connection_request'; ?>"><button type="button" class="btn btn-primary pull-right" href="<?php echo base_url().'company/connection_request'; ?>">View More</i></button></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<script>
	var country = '<?php echo json_encode($country); ?>';	
	</script>

</div>


	
<div class="col-md-12 connectSearchBtn" style="display:none;">
	<?php /*<form class="form-horizontal" method="POST" action="<?php echo base_url().'company/searchCompanyList' ;?>" >*/?>
		<input type="text" class="form-control searchCompanyList" name="company_name" placeholder="SEARCH COMPANY TO CONNECT...">
		<?php /*<span class="input-group-btn">								
			<button type="submit" class="btn btn-primary btn btn-primary btnerp-stylefull searchCompanyList"><i class="fa fa-search"></i></button>
		</span>
	</form>*/?>
	<div class="companyList"></div>
	<div class="companyProfile"></div>
	
</div>