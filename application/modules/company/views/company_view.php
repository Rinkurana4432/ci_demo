	<div class="x_content">
		<?php if($this->session->flashdata('message') != ''){
				echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
			}
		?>
		<!-- ------ VIEW PAGE ------- -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 image-opt">
							<?php if($_SESSION['loggedInUser']->role ==1){
							echo '<button type="button" class="btn btn-warning" id="cover-opt"><i class="fa fa-pencil-square-o"></i></a></button>';
						}?>
							<div id="covermenu" class="coverpicmenu">
								<a href="javascript:void(0)" data-href="<?php if(!empty($company)) { echo base_url().'company/deleteCoverPhoto/'.$company->id; }?>" class="btn btn-danger delete_listing"><i class="fa fa-trash"></i></a><br/>

								<?php if($_SESSION['loggedInUser']->role != 2){ ?><button type="button" class="btn btn-info" data-toggle="modal" data-target=".bs-example-modal-upload" id="coverpic"><i class="fa fa-upload"></i></a></button><?php } ?>
								<div id="UploadCoverImageModal" class="modal" role="dialog" >
								<!--<div class="modal fade bs-example-modal-upload" tabindex="-1" role="dialog" aria-hidden="true">-->
									<div class="modal-dialog" style="width:95%";>
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Upload & Crop Image</h4>
											</div>
											<div class="modal-body">
												<div class="container">
													<div class="panel panel-default">
														<div class="panel-heading">Select Cover Image</div>
															<div class="panel-body" align="center">
																<input type="file" name="cover_image" id="cover_crop_image" accept="image/*" />
																<input type="hidden" name="changed_user_cover" id="changed_user_cover" value=""/>
																<!--<input type="hidden" name="fileOldlogo" value="<?php //echo isset($user->user_profile)?$user->user_profile: "";?>">-->
																<br />
																<div id="uploaded_cover_image"></div>
															</div>
													</div>
												</div>
												<div class="row coverImage_section" style="display:none;">
													<div class="col-md-8 text-center">
														<div id="cover_image_demo" style="width:350px; margin-top:30px"></div>
													</div>
													<!--<div class="col-md-4" style="padding-top:30px;">
														<br />
														<br />
														<br/>
														<button class="btn btn-success crop_cover_image">Crop & Upload Image</button>
													</div>-->
												</div>
											</div>
											<div class="modal-footer">
											<button class="btn btn-success crop_cover_image">Crop & Upload Image</button>
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>




							</div>
						</div>
					</div>

					<?php	if(!empty($company) && $company->cover_photo!=''){
						#echo '<img src="'.base_url().'assets/modules/company/uploads/'.$company->cover_photo.'" alt="Company Cover Pic" class="img-responsive" style=" width:100%; height:50%;">';
						?>
						<img src="<?php echo base_url().'assets/modules/company/uploads/'.$company->cover_photo; ?>" alt="Company Cover Pic" class="img-responsive" style=" width:100%; height:50%;"  onerror="this.onerror=null;this.src='<?php echo base_url().'assets/images/company-logo.jpg' ?>';">
						<?php
					}else{  ?>
						<img src="<?php echo base_url().'assets/modules/company/uploads/companybg.png'; ?>" alt="Company Cover Pic" class="img-responsive" style="width:100%; height:50%;"  onerror="this.onerror=null;this.src='<?php echo base_url().'assets/images/company-logo.jpg' ?>';">
				<?php 	} ?>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 companyln">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 cdata">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 clogo">
							<img src="<?php echo base_url('assets/modules/company/uploads').'/'.(isset($company->logo) && $company->logo != '' ?$company->logo:"company_placeholder.png");?>" alt="Company logo" class="img-responsive"  onerror="this.onerror=null;this.src='<?php echo base_url().'assets/images/company-logo.jpg' ?>';">
						</div>
						<div class="col-lg-10 col-md-10 col-sm-8 col-xs-8 cviewname">
							<h2 class="cviewtitle"><?php if(!empty($company)) echo $company->name; ?></h2>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right text-right c-connect">
						<?php /*<button type="button" class="btn btn-primary messageCompany" data-toggle="modal" data-target=".bs-example-modal-message">Message</a></button>*/?>
						<?php /*<div class="modal fade bs-example-modal-message" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-md">
								<div class="modal-content">
									<div class="modal-body">
										<div class="row">
											<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>company/sendMessage" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
												<input type="hidden" value="<?php if(!empty($loggedInUser)) echo $_SESSION['loggedInUser']->c_id; ?>" name="created_by">
												<input type="hidden" value="<?php if(!empty($company)) echo $company->c_id; ?>" name="received_by">
												<div class="item form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="message">Message</label>
													<div class="col-md-8 col-sm-8 col-xs-12">
														<div class="col-md-12">
															<textarea id="chat_message" name="chat_message" class="form-control col-md-12 col-xs-12" placeholder="Type Your Message Here" required></textarea>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													<a href="http://busybanda.com/erp/#" title="Send this chat message" id="submit_message" class="btn btn-default btn-sm">Send</a>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div> */?>
						<?php /* <button type="button" class="btn btn-warning">Connect</button> */ ?>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-gear"></i></button>
						<!---------- Edit Profile Modal ---------------- -->
						<div class="modal fade bs-example-modal-lg text-left"  role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-lg modal-large">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
										</button>
										<h4 class="modal-title" id="myModalLabel">Company Edit</h4>
										<div class="project_progress">
											<div class="progress progress_sm">
												<div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo @$profileComplete; ?>"></div>
											</div>
											<small>Profile <?php echo @$profileComplete; ?>% Complete</small>
										</div>
									</div>
									<div class="modal-body">
										<div class="row">
											<?php if($_SESSION['loggedInUser']->role != 2){ ?>
												<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>company/save" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
													<div class="col-md-6 col-sm-12 col-xs-12 ">
														<input type="hidden" name="id" value="<?php if(!empty($company)) echo $company->id; ?>">
														<input type="hidden" name="u_id" value="<?php if(!empty($company)) echo $company->u_id; ?>">
														<input type="hidden" name="c_id" value="<?php if(!empty($company)) echo $company->c_id; ?>">
														<div class="panel-default">
															<h3 class="Material-head">Information <hr></h3>
															<div class="panel-body vertical-border">
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="name">Company Name<span class="required">*</span></label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" value="<?php if(!empty($company)) echo $company->name; ?>" name="name" placeholder="ex. John f. Kennedy" required="required" type="text" <?php if(!empty($company)) echo 'disabled'; ?>>
																	</div>
																</div>
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span></label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php if(!empty($company)) echo $company->email; ?>" <?php if(!empty($company)) echo 'disabled'; ?>>
																	</div>
																</div>
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="email">Phone <span class="required">*</span></label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<input type="tel" id="phone" name="phone" required="required" data-validate-length-range="8,10" class="form-control col-md-7 col-xs-12" placeholder="+91 9858468953" value="<?php if(!empty($company)) echo $company->phone; ?>">
																	</div>
																</div>
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="gstin">GSTIN<span class="required">*</span></label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<input type="text" id="designation" name="gstin" data-validate-length-range="8,20" required="required" class="form-control col-md-7 col-xs-12" placeholder="GSTIN number" value="<?php if(!empty($company)) echo $company->gstin; ?>" <?php if(!empty($company) && $company->gstin !='') echo 'readonly'; ?>>
																	</div>
																</div>
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="name">Company PAN<span class="required">*</span></label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<input id="companyPan" class="form-control col-md-7 col-xs-12 companyPan" value="<?php if(!empty($company)) echo $company->company_pan; ?>" name="company_pan" placeholder="ABCDFA87565B" required="required" type="text" onblur="fnValidatePAN(this);">
																	</div>
																</div>
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="gstin">Company Type</label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<input type="radio" class="flat" name="company_type" id="manufacturer" value="manufacturer" <?php if(!empty($company) && $company->company_type == 'manufacturer'){ echo 'checked'; } ?> required /> Manufacturer&nbsp;
																		<input type="radio" class="flat" name="company_type" id="trader" value="trader" <?php if(!empty($company) && $company->company_type == 'trader'){ echo 'checked'; } ?>/> Trader&nbsp;
																		<input type="radio" class="flat" name="company_type" id="wholesaler" value="wholesaler" <?php if(!empty($company) && $company->company_type == 'wholesaler'){ echo 'checked'; } ?>/> Wholesaler&nbsp;
																	</div>
																</div>
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="expierence">Company Logo</label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<div class="col-md-12">
																			<input type="hidden" name="fileOldlogo" class="logo_oldimaged" value="<?php echo isset($company->logo)?$company->logo: " ";?>">
																			<!--<input type="file" class="form-control col-md-7 col-xs-12" name="logo" id="logoSite">--->
																			<button type="button" class="btn" name="logo" id="logoSite">Upload Logo</button>
																		</div>
																		<div id="logo-holder" class="col-md-5">
																			<img src="<?php echo base_url('assets/modules/company/uploads').'/'.(isset($company->logo) && $company->logo != '' ?$company->logo:"company_placeholder.png ");?>" class="img-responsive imaged"  onerror="this.onerror=null;this.src='<?php echo base_url().'assets/images/company-logo.jpg' ?>';">																				<div class="mask">																				<a href="javascript:void(0)" class="remove_logo_dd btn btn-danger">																				<i class="fa fa-trash"></i>																				</a>																			 </div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-6 col-sm-12 col-xs-12 form-group">
														<div class="panel-default">
														    <h3 class="Material-head">About<hr></h3>

															<div class="panel-body vertical-border" ><!--style="overflow-y:scroll; height: 410px;"-->
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="establish">Year Of Est. <span class="required">*</span></label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<input type="text" id="year" name="year_of_establish" required="required" class="form-control col-md-7 col-xs-12 date-picker-year" placeholder="ex.2001" value="<?php if(!empty($company)) echo $company->year_of_establish; ?>">
																	</div>
																</div>
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="address2">Description <span class="required">*</span></label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<textarea id="description" required="required" name="description" class="form-control col-md-7 col-xs-12" row="6" placeholder="Description"><?php if(!empty($company)) echo $company->description; ?></textarea>
																	</div>
																</div>
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="employees">Employees</label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<input type="number" id="no_employees" name="no_of_employees" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($company)) echo $company->no_of_employees; ?>" placeholder="0">
																	</div>
																</div>
																<div class="item form-group keyPeopleWrap">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="employees">Key People</label>
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
																</div>*/ ?>
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="revenue">Revenue</label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<input type="text" id="range" value="<?php if(!empty($company)) echo $company->revenue; ?>" name="revenue" />
																	</div>
																</div>
															</div>
														</div>
													</div>
                                                     <hr>
                                                     <div class="bottom-bdr"></div>
													<?php /*   Bank details*/?>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<div class="panel-default">
						<h3 class="Material-head">Bank Account Details<hr></h3>
						<div class="panel-body">
						 <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="establish">Bank Account Name </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="account_name" name="account_name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($company)) echo $company->account_name; ?>">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="account_no">Account Number </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="account_no" name="account_no" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($company)) echo $company->account_no; ?>">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="account_ifsc_code">Bank IFSC Code</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="account_ifsc_code" name="account_ifsc_code" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($company)) echo $company->account_ifsc_code; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="bank_name">Bank Name</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="bank_name" value="<?php if(!empty($company)) echo $company->bank_name; ?>" name="bank_name" class="form-control col-md-7 col-xs-12"/>
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="branch">Bank Branch</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="branch" value="<?php if(!empty($company)) echo $company->branch; ?>" name="branch" class="form-control col-md-7 col-xs-12"/>
								</div>
							</div>
						</div>
						</div>
					</div>
				</div>
				 <hr>
				 <div class="bottom-bdr"></div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<div class="panel-default">
						 <h3 class="Material-head">Address<hr></h3>
						<div class="panel-body address_wrapper">
						<?php
						// 
							//echo $_SESSION['loggedInUser']->c_id;
							if(!empty($company) && $company->address !='' && $company->address !='[""]'){
								$addressDetail = json_decode($company->address);
								// pre($company->address);
								 $add= 	!empty($addressDetail)?count($addressDetail):'';
								echo '<input type="hidden" class="addressLength" value="'.$add.'">';
								$j=0;
							if(!empty($addressDetail)){
								foreach($addressDetail as $address){

									if($j==0){
										$addBtn = '<button class="btn btn-warning add_address_button" type="button"><i class="fa fa-plus"></i></button>';
									}else{
										$addBtn = '<button class="btn btn-danger remove_address_field" type="button"><i class="fa fa-minus"></i></button>';
									}
										if($addressDetail != ''){
										//if(!empty($address->compny_branch_name)){
										echo '<div class="item form-group well2 input_address_wrap" id="chkIndex_'.$j.'"><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"><label class="col-md-3 col-sm-3 col-xs-12">Company Branch Name</label><div class="col-md-6 col-sm-12 col-xs-12 form-group"><input type="text" id="compny_branch_name" name="compny_branch_name[]" class="form-control col-md-1" placeholder="Company Branch Name" value="'.$address->compny_branch_name.'"></div></div>';
									//	}

										echo '<div class="col-md-6 col-sm-12 col-xs-12 vertical-border"><label class="col-md-3 col-sm-3 col-xs-12">Company Address</label><div class="col-md-6 col-sm-12 col-xs-12 form-group"><textarea id="address"  name="address[]" class="form-control col-md-7 col-xs-12" placeholder="Address">'.$address->address.'</textarea></div></div><div class="col-md-12 " >';
							?>


							<div class="item form-group col-md-3 col-sm-3 col-xs-12">
								<label class="col-md-12 col-sm-4 col-xs-4 form-group" for="billing_country">Permanent Country</label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="country[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this)">
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
								<label class="col-md-12 col-sm-4 col-xs-4 form-group" for="permanent_state">Permanent State/Province</label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1 state_id" name="state[]"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)">
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
							<div class="item form-group col-md-2 col-sm-3 col-xs-12">
								<label class="form-groupcol-md-12 col-sm-4 col-xs-4" for="city">Permanent City<span class="required">*</span></label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1 city_id" name="city[]"  width="100%" tabindex="-1" aria-hidden="true">
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
							<label class="form-groupcol-md-12 col-sm-4 col-xs-4" for="city">Postal/Zipcode<span class="required">*</span></label>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<input type="text" id="postal_zipcode" name="postal_zipcode[]" class="form-control col-md-1" placeholder="Postal/Zipcode" value="<?php echo $address->postal_zipcode;?>">
								<input type="hidden" id="prefix_inv_num" name="prefix_inv_num[]" class="form-control col-md-1" placeholder="Postal/Zipcode" value="<?php if(!empty($address->prefix_inv_num)){echo $address->prefix_inv_num;} ?>">
								<?php #if(!empty($address->prefix_inv_num)){echo $address->prefix_inv_num;} ?>
							</div>
							</div>
							<div class="col-md-2 col-sm-12 col-xs-12 form-group">
								<label style="border-right: 1px solid #c1c1c1" class="form-groupcol-md-12 col-sm-4 col-xs-4" for="city">Company GSTIN<span class="required">*</span></label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<input style="border-right: 1px solid #c1c1c1" type="text" id="company_gstin" name="company_gstin[]" class="form-control col-md-1" placeholder="Company GSTIN" value="<?php if(!empty($address) && isset($address->company_gstin)){echo $address->company_gstin;}?>">
								</div>
							</div>


							<?php echo $addBtn; ?>

												</div>
											</div>
										<?php }
										
										$j++;
										}
										
									}

								}else{
								?>

								<div class="item form-group">
									<div class="col-md-12" >
									<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 form-group">
										<input type="text" id="compny_branch_name" name="compny_branch_name[]" class="form-control col-md-1" placeholder="Company Branch Name" value="">
									</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
											<textarea id="address" name="address[]" class="form-control col-md-7 col-xs-12" placeholder="Address"></textarea>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="item form-group col-md-3 col-sm-3 col-xs-12">
												<label class="control-label col-md-4 col-sm-4 col-xs-4" for="billing_country">Permanent Country</label>
												<div class="col-md-8 col-sm-8 col-xs-8">
													<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="country[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this)">
														<option value="">Select Option</option>
													</select>
												</div>
											</div>
											<div class="item form-group col-md-3 col-sm-3 col-xs-12">
												<label class="control-label col-md-4 col-sm-4 col-xs-4" for="permanent_state">Permanent State/Province</label>
												<div class="col-md-8 col-sm-8 col-xs-8">
													<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1 state_id" name="state[]"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)">
														<option value="">Select Option</option>
													</select>
												</div>
											</div>
											<div class="item form-group col-md-3 col-sm-3 col-xs-12">
												<label class="control-label col-md-4 col-sm-4 col-xs-4" for="city">Permanent City<span class="required">*</span></label>
												<div class="col-md-8 col-sm-8 col-xs-8">
													<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1 city_id" name="city[]"  width="100%" tabindex="-1" aria-hidden="true">
														<option value="">Select Option</option>
													</select>
												</div>
											</div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group">
												<input type="text" id="postal_zipcode" name="postal_zipcode[]" class="form-control col-md-1" placeholder="Postal/Zipcode" value="">
											</div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group">
												<input type="text" id="company_gstin" name="company_gstin[]" class="form-control col-md-1" placeholder="Company GSTIN" value="">
											</div>
											<div class="col-sm-12 btn-row"><button class="btn btn-warning add_address_button sdsd" type="button"><i class="fa fa-plus"></i></button></div>
										</div>
									</div>
								</div>


								<?php }
								?>

						</div>
					</div>
				</div>
				<hr>
                                                     <div class="bottom-bdr"></div>

													<div class="col-md-6 col-sm-12 col-xs-12 form-group">
														<div class=" panel-default">

															<h3 class="Material-head">Certifications<hr></h3>
															<div class="panel-body vertical-border">
																<div class="item form-group ">
																	<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Certification</label>
																	<div class="col-md-7 col-sm-6 col-xs-12 fields_wrap">
																		<input style="width: 86%;" type="file" class="form-control col-md-6 col-xs-12 certificationField" name="certification[]">
																		<button class="btn btn-warning field_button" type="button"><i class="fa fa-plus"></i></button>
																	</div>

																</div>
																<div class="item form-group certificationWrap">

																</div>
																<div class="item form-group">
																 <label class="col-md-3 col-sm-2 col-xs-12" for="certificate"></label>
																<?php if(!empty($companyCertificate)){?>

																		<div class="col-md-9 outline">
																			<?php foreach($companyCertificate as $compCer){
																						echo '<div class="img-wrap"><div class="col-md-3 img-outline"><a href="javascript:void(0)" class="delete_listing close-link cross" style="z-index:111;" data-href="'.base_url(). 'company/deleteCertificate/'.$compCer[ 'id']. '"><i class="fa fa-trash" style="color:#e60a03;"></i></a><img  src="'.base_url(). 'assets/modules/company/uploads/'.$compCer[ 'file_name']. '" alt="image" class="img-responsive"/></div></div>';
																			} ?>
																		</div>

																<?php } ?>
																</div>
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
													<div class="col-md-6 col-sm-12 col-xs-12 form-group">
														<div class="panel-default">

															 <h3 class="Material-head">Social Links <hr></h3>
															<div class="panel-body vertical-border">
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="textarea">Facebook</label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<input type="url" id="facebook" name="facebook" class="form-control col-md-7 col-xs-12 optional" placeholder="" value="<?php if(!empty($company)) echo $company->facebook; ?>">
																	</div>
																</div>
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="textarea">Twitter</label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<input type="url" id="twitter" name="twitter" class="form-control col-md-7 col-xs-12 optional" placeholder="" value="<?php if(!empty($company)) echo $company->twitter; ?>">
																	</div>
																</div>
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="textarea">Instagram</label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<input type="url" id="instagram" name="instagram" class="form-control col-md-7 col-xs-12 optional" placeholder="" value="<?php if(!empty($company)) echo $company->instagram; ?>">
																	</div>
																</div>
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="textarea">Linkedin</label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<input type="url" id="linkedin" name="linkedin" class="form-control col-md-7 col-xs-12 optional" placeholder="" value="<?php if(!empty($company)) echo $company->linkedin; ?>">
																	</div>
																</div>
																<div class="item form-group">
																	<label class="col-md-3 col-sm-3 col-xs-12" for="textarea">Google+</label>
																	<div class="col-md-6 col-sm-6 col-xs-12">
																		<input type="url" id="google_plus" name="google_plus" class="form-control col-md-7 col-xs-12 optional" placeholder="" value="<?php if(!empty($company)) echo $company->google_plus; ?>">
																	</div>
																</div>
															</div>
														</div>
													</div>
										<div class="modal-footer">
										   <Center>
											<input type="submit" class="btn btn-warning submitCompanyBtn" value="Submit">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="reset" class="btn btn-default">Reset</button>
                                           </center>
										</div>
												</form>
											<?php } ?>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 companyv">
			<ul class="nav nav-tabs col-md-2 col-sm-12 col-xs-12 check_cls" class="cpm">
				<li class="active"><a href="#home" data-toggle="tab"><i class="fa fa-home"></i> <span>Home</span></a></li>
				<li><a href="#product" data-toggle="tab"><i class="fa fa-cubes"></i> <span>Products</span></a></li>
				<li><a href="#about-us" data-toggle="tab"><i class="fa fa-info"></i> <span>About Us</span></a></li>
				<li><a href="#gallery" data-toggle="tab"><i class="fa fa-image"></i> <span>Gallery</span></a></li>
				<li><a href="#employees" data-toggle="tab"><i class="fa fa-users"></i> <span>Employees</span></a></li>
				<li><a href="#connections" data-toggle="tab"><i class="fa fa-suitcase"></i> <span>Connections</span></a></li>
				<li><a href="#contact" data-toggle="tab"><i class="fa fa-phone"></i> <span>Contact</span></a></li>
			</ul>
			<div class="tab-content col-md-10">
				<div class="tab-pane active" id="home">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
							<div class="home-category-info-header">
								<h2>News Feed</h2>
								<span class="home-category-info-header-line" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
							</div>
						</div>
						<?php  #pre($_SESSION['loggedInUser']); ?>
						<?php  $loggedInUser =  getNameById('user_detail',$_SESSION['loggedInUser']->u_id,'u_id');


							#	pre($_SESSION['loggedInUser']);
								if($loggedInUser->user_profile != ''){
									$LoggedInUserProfileImage = $loggedInUser->user_profile;
								}else{
									$LoggedInUserProfileImage = ($loggedInUser->user_profile == '' && $loggedInUser->gender =='Female')?'female_image_placeholder.jpg':'dummy.jpg';
								}

						?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft postfeed">
							<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
								<img src="<?php echo base_url('assets/modules/users/uploads').'/'.$LoggedInUserProfileImage ;?>" alt="Company logo" class="img-responsive" onerror="this.onerror=null;this.src='<?php echo base_url().'assets/modules/users/uploads'.$LoggedInUserProfileImage; ?>';">
							</div>
							<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11">
								<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>company/savePost" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
									<div class="item form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<textarea id="chat_message" name="description" class="form-control col-md-12 col-xs-12" placeholder="Type Your Message Here" required></textarea>
										</div>
									</div>
									<!--<div class="item form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<input type="file" class="form-control col-md-7 col-xs-12" name="image" id="image">

										</div>
									</div>0-->
									<div class="item form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<input type="hidden" class="form-control col-md-7 col-xs-12" name="image" id="image_post" value="">
											<button type="button" class="btn" name="image" id="post_image" value="">upload image</button>
											<div id="uploaded_image"></div>
										</div>
									</div>
									<button type="submit" class="btn btn-primary pull-right">Post</button>
								</form>
							</div>
						</div>
						<?php
						if(!empty($postCommentData)){
							foreach($postCommentData as $postComment){
								$postedByUserData = getNameById('user_detail',$postComment['post']['created_by'],'u_id');
								//$userProfileImage = (!empty($postedByUserData) && $postedByUserData->user_profile!='')?$postedByUserData->user_profile:'userp.png';

								if($postedByUserData->user_profile != ''){
									$userProfileImage = $postedByUserData->user_profile;
								}else{
									$userProfileImage = ($postedByUserData->user_profile == '' && $postedByUserData->gender =='Female')?'female_image_placeholder.jpg':'dummy.jpg';
								}


								$postCommentCount = (!empty($postComment['comments']))?count($postComment['comments']):0;

								?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft postfeed">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 brbtm">
								<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1 flex">
									<img src="<?php echo base_url('assets/modules/users/uploads').'/'.$userProfileImage;?>" alt="Company logo" class="img-responsive" onerror="this.onerror=null;this.src='<?php echo base_url().'assets/modules/users/uploads/'.$userProfileImage; ?>'">
								</div>
								<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11">
									<p><?php echo $postComment['post']['description']; ?></p>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 brbtm pt">
								<img src="<?php echo ($postComment['post']['image']!='')?base_url().'assets/modules/company/uploads/'.$postComment['post']['image']: base_url().'assets/modules/company/uploads/companybg.png';?>" alt="Company post Pic" class="img-responsive">
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 brbtm pt">
								<a data-toggle="collapse" href="#post_comment_<?php echo $postComment['post']['id']; ?>" aria-expanded="false"><i class="fa fa-comments-o"></i>&nbsp;Comments<sup><?php echo $postCommentCount; ?></sup></a>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt">
								<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
									<img src="<?php echo base_url('assets/modules/users/uploads').'/'.$userProfileImage ;?>" alt="Company logo" class="img-responsive" onerror="this.onerror=null;this.src='<?php echo base_url().'assets/modules/users/uploads/'.$userProfileImage; ?>'" >
								</div>
								<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11">
									<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>company/saveComment" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
										<input type="hidden" value="<?php if(!empty($loggedInUser)) echo $loggedInUser->u_id; ?>" name="created_by">
										<input type="hidden" value="<?php echo $postComment['post']['id']; ?>" name="post_id">
										<input type="hidden" value="comment" name="commentFilter">
										<div class="item form-group">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<textarea id="chat_message" name="comment" class="form-control col-md-12 col-xs-12" placeholder="Type Your Message Here" required></textarea>
											</div>
										</div>
										<button type="submit" class="btn btn-primary pull-right">Comment</button>
									</form>
								</div>
							</div>
							<?php  if(!empty($postComment['comments'])){ ?>
							<div class="collapse multi-collapse col-xs-12 col-sm-12 col-md-12 col-lg-12 comment-section" id="post_comment_<?php echo $postComment['post']['id']; ?>">

							<?php
								echo '<ul class="list-unstyled msg_list">';
								foreach($postComment['comments'] as $pc ){
									$commentedByUserData = getNameById('user_detail',$pc['created_by'],'u_id');
									$commentedByProfileImage = (!empty($commentedByUserData) && $commentedByUserData->user_profile!='')?$commentedByUserData->user_profile:'userp.png';
								?>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
									<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
										<img src="<?php echo base_url('assets/modules/users/uploads').'/'.$commentedByProfileImage;?>" alt="Company logo" class="img-responsive" >
									</div>
									<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11">
										<b><?php echo $commentedByUserData->name ;?></b>&nbsp;<sub><?php echo $pc['created_date'] ;?></sub>
										<p><?php echo $pc['comment']; ?></p>
									</div>
								</div>
								<?php }   ?>
							</div>
							 <?php } ?>
						</div>
						<?php }  } ?>
					</div>
				</div>
				<div class="tab-pane" id="product">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
						<div class="home-category-info-header">
							<h2>Our Products</h2>
							<span class="home-category-info-header-line" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<!-- product -->
							<?php if(!empty($products)){
										foreach($products as $product){
										$proImage  = $product['featured_image'] != ''?$product['featured_image']:"image-placeholder.png";
								  ?>
							<div class="product col-xs-12 col-sm-6 col-md-4 col-lg-3">
								<div class="product-img">
									<img src="<?php echo base_url().'assets/modules/inventory/uploads/'.$proImage; ?>" class="img-responsive" alt="">
								</div>
								<div class="product-body">
									<h3 class="product-name"><a href="#"><?php echo $product['material_name']; ?></a></h3>
									<div class="product-rating">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
									</div>
									<p class="product-category">By:<a href="<?php  echo base_url(); ?>home/contactSupplier?material_id=<?php echo $product['id'];  ?>&company_id=<?php echo $product['created_by_cid'];  ?>"><?php echo getNameById('company_detail',$product['created_by_cid'],'id')->name;  ?></a></p>
								</div>
								<div class="product-tags">
									<?php echo get_tags_html($product['id'],'material'); ?>
									<h4 class="product-price"> <i class="fa fa-inr"></i> <?php echo $product['sales_price'];  ?><font class="product-min-order"> Min. order of <?php echo $product['min_order']; ?> pieces.</font></h4>
								</div>
								<div class="product-body">
									<div class="product-btns">
										<button onclick="location.href='<?php  echo base_url(); ?>home/product_detail?material_id=<?php echo $product['id'];  ?>&company_id=<?php echo $product['created_by_cid'];  ?>';" data-toggle="tooltip" data-placement="top" data-custom-class="tooltip" title="Quick View"><i class="fa fa-eye"></i></button>
										<button onclick="location.href='<?php  echo base_url(); ?>home/contactSupplier?material_id=<?php echo $product['id'];  ?>&company_id=<?php echo $product['created_by_cid'];  ?>';" data-toggle="tooltip" data-placement="top" data-custom-class="tooltip" title="Contact Supplier"><i class="fa fa-phone"></i></button>
									</div>
								</div>
							</div>
							<?php }
							} else{
								echo '<div class="col-md-12">
										<h2><b>Empty Data.</b></h2>
									  </div>';
							}	?>
							<!-- /product -->
						</div>
					</div>
				</div>
				<div class="tab-pane" id="about-us">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
						<div class="home-category-info-header">
							<h2>About Us</h2>
							<span class="home-category-info-header-line" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<table class="table table-bordered">
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
														if(!empty($company)) {
															if($company->key_people != ''){
																$keyPeoples = json_decode($company->key_people);
																foreach($keyPeoples as $keyPeople){
																	if($keyPeople != ''){
																		echo $keyPeople. '<br>';
																	}
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
															if($company->address != ''){
																$addresses = json_decode($company->address);
																	foreach($addresses as $compAddress){
																		$cityName = ($compAddress->city!='')?(getNameById('city',$compAddress->city,'city_id')->city_name):'';
																		$stateName = ($compAddress->state!='')?(getNameById('state',$compAddress->state,'state_id')->state_name):'';
																		$countryName = ($compAddress->country!='')?(getNameById('country',$compAddress->country,'country_id')->country_name):'';
																		if($compAddress != ''){
																			echo '<li>'.$compAddress->address.' , '.$cityName.' , '.$stateName.' , '.$countryName.' , '.$compAddress->postal_zipcode.'</li>';
																		}
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
													<div class="form-group">
														<div class="col-md-12">
															<?php foreach($companyCertificate as $compCer){
																echo '<div class="col-md-2 img-outline">
																<img  src="'.base_url(). 'assets/modules/company/uploads/'.$compCer[ 'file_name']. '" alt="image" class="img-responsive"/>
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
				</div>
				<div class="tab-pane" id="gallery">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
						<div class="home-category-info-header">
							<h2>Our Gallery</h2>
							<span class="home-category-info-header-line" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
						</div>
					</div>
					<div class="row">
						<div class="x_content">
							<div class="row erp-gallerytop">
							<?php
							if(!empty($gallery)){
								foreach($gallery as $gal){ ?>
								<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 companygallery">
								<?php $loggedInUser =  getNameById('user_detail',$_SESSION['loggedInUser']->u_id,'u_id');  ?>
									<img src="<?php echo ($gal['post']['image']!='')?base_url().'assets/modules/company/uploads/'.$gal['post']['image']: base_url().'assets/modules/company/uploads/companybg.png';?>" class="avatar-view img-responsive" alt="Avatar"  onerror="this.onerror=null;this.src='<?php echo base_url().'assets/modules/inventory/uploads/image-placeholder.png' ?>';">
								</div>
								<?php } } ?>

							</div>
						</div>
						<ul class="nav navbar-right panel_toolbox">
							<li>
								<a href=""><button type="button" class="btn btn-primary pull-right">View More</i></button></a>
							</li>
						</ul>
					</div>
				</div>
				<div class="tab-pane" id="employees">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
						<div class="home-category-info-header">
							<h2>Our Employees</h2>
							<span class="home-category-info-header-line" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
						</div>
						<div class="x_content">
						<?php
						if(!empty($employees)){
								$employeeLength = count($employees);
								$employeeLength = $employeeLength - 11;
								$i = 0;
								foreach($employees as $employee){

								if($employee['user_profile'] != ''){
									$user_profile = $employee['user_profile'];
								}else{
									$user_profile = ($employee['user_profile'] == '' && $employee['gender'] =='Female')?'female_image_placeholder.jpg':'dummy.jpg';
								}
								if($i<11){




									//$user_profile  = (isset($employee['user_profile']) && $employee['user_profile'] != '') ?$employee['user_profile']:"male-user-placeholder.jpg";
									echo '<div class="col-lg-3 col-md-6 col-sm-3 col-xs-3 emp"><a href="'.base_url().'users/edit/'.$employee['u_id'].'"><img src="'.base_url().'assets/modules/users/uploads/'.$user_profile.'" data-toggle="tooltip" data-placement="bottom" title="'.$employee['name'].'" data-toggle="tooltip" data-placement="bottom" title="Employee1 Name" class="img-responsive gal" alt="img"></a></div>';
										$i++;
									}
								}
							if($employeeLength >0)
							echo $employeeLength.'<i class="fa fa-plus"></i> more employees work here';
							} else{
								echo 'No employees';
							}

							?>
					</div>
					<?php if(!empty($employees) && count($employees)>12){
					echo '<ul class="nav navbar-right panel_toolbox"><li><a href="'.base_url().'users"><button type="button" class="btn btn-primary pull-right">View More</i></button></a></li></ul>';
					 } ?>
					</div>
				</div>
				<div class="tab-pane" id="connections">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
						<div class="home-category-info-header">
							<h2>Connections</h2>
							<span class="home-category-info-header-line" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
						</div>
					</div>
					<div class="x_content">
					<?php if(!empty($connections)){
						foreach($connections as $connection){ ?>
						<div class="col-lg-3 col-md-6 col-sm-3 col-xs-3 con">
							<a href="<?php echo base_url().'company/view/'.$connection['id']; ?>">
								<img src="<?php echo base_url('assets/modules/company/uploads').'/'.($connection['logo'] != '' ?$connection['logo']:"company_placeholder.png");?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $connection['name']; ?>" class="img-responsive congal" alt="img">
							</a>
						</div>
						<?php }
						}else{
							echo '<div class="col-md-12">
									<h2><b>No connections available.</b></h2>
								  </div>';
						}	?>
					</div>
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<a href="<?php echo base_url().'company/connection_request'; ?>"><button type="button" class="btn btn-primary pull-right" href="<?php echo base_url().'company/connection_request'; ?>">View More</i></button></a>
						</li>
					</ul>
				</div>
				<div class="tab-pane" id="contact">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
						<div class="home-category-info-header">
							<h2>Contact Us</h2>
							<span class="home-category-info-header-line" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
						</div>
					</div>
					<div class="x_content">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
									<?php
									if(!empty($company)  && $company->mapiframe !=''){
											$iframe =  $company->mapiframe;
											echo '<iframe src="'.$iframe.'" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>';
									} ?>
						</div>
						<ul class="list-unstyled user_data">
							<?php if(!empty($company)){
								$addresses = json_decode($company->address);

							if($company->phone != ''){
								echo '<li><i class="fa fa-phone user-profile-icon"></i>&nbsp; Phone Number: '.$company->phone.'</li>';
							}
							 if($company->email != ''){
								echo '<li><i class="fa fa-envelope user-profile-icon"></i>&nbsp; Email '.$company->email.'</li>';
							}

							 if($company->website != ''){
								echo '<li class="m-top-xs"><i class="fa fa-external-link user-profile-icon"></i>Website <a href="http://'.$company->website.'" target="_blank">'.$company->website.'</a></li>';
							}
							 } ?>
						</ul>
					</div>
				</div>
			</div><!-- tab content -->
		</div>
		<!-- --------------------------- Right Sidebar -------------------- -->
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 postfeed">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
						<div class="home-category-info-header">
							<h2>Gallery</h2>
							<span class="home-category-info-header-line1" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft postfeed">
						<div id="gallerycarousel" class="carousel slide" data-ride="carousel">
						<?php
							if(!empty($gallery)){
								$i=0;
								?>
							<ol class="carousel-indicators">
							<?php foreach($gallery as $gal){ ?>
								<li data-target="#gallerycarousel" data-slide-to="<?php echo $i; ?>" class="<?php if($i==0) echo 'active'; else echo ''; ?>"></li>
								<?php $i++ ; } ?>
							</ol>
							<div class="carousel-inner">
							<?php $j = 0 ;
							foreach($gallery as $gal){ ?>
								<div class="item galleryitm <?php if($j==0) echo ' active'; else echo ''; ?>">
								  <img class="img-responsive gallerypic" src="<?php echo ($gal['post']['image']!='')?base_url().'assets/modules/company/uploads/'.$gal['post']['image']: base_url().'assets/modules/company/uploads/companybg.png';?>" alt="First slide" onerror="this.onerror=null;this.src='<?php echo base_url().'assets/modules/inventory/uploads/image-placeholder.png' ?>';">
								</div>
							<?php $j++ ; } ?>

							</div>
							<a class="carousel-control gallery-add-slider left gslider" href="#gallerycarousel" data-slide="prev">
								<span class="fa fa-chevron-left"></span>
							</a>
							<a class="carousel-control gallery-add-slider right gslider" href="#gallerycarousel" data-slide="next">
								<span class="fa fa-chevron-right"></span>
							</a>
							<?php }else{
									echo '<img class="img-responsive gallerypic" src="'.base_url().'assets/images/image-placeholder.png" alt="First slide" >';
							}	?>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-hidden-sm col-md-12 col-lg-12 postfeed">
					<div class="col-xs-12 col-md-12 col-lg-12 animated wow fadeInLeft">
						<div class="home-category-info-header">
							<h2>Our Products</h2>
							<span class="home-category-info-header-line1" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft" style="padding-right: 0px; overflow: hidden;">
						<div class="cproductSlider slider sliderm">
							<!-- product -->
							<?php if(!empty($products)){
										foreach($products as $product){
										$proImage  = $product['featured_image'] != ''?$product['featured_image']:"image-placeholder.png";
								  ?>


							<div class="cpproduct col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="cpproduct-img">
									<img src="<?php echo base_url().'assets/modules/inventory/uploads/'.$proImage; ?>" class="img-responsive" alt="">
								</div>
								<div class="cpproduct-body">
									<h3 class="cpproduct-name"><a href="#"><?php echo $product['material_name'];  ?></a></h3>

											<?php $countRating = getStarRatingCount('reviews',$product['id'],'material_id');
														//pre($countRating);
														if(!empty($countRating)){

														foreach($countRating as $average){
														    $printStar = $average['average'];
															?>
														<div class="cpproduct-rating">
															<?php for($i = 1; $i<=$printStar; $i++){
																	echo '<i class="fa fa-star" style="color:#2e2efd;"></i>';
																	}
																if(strpos($printStar,'.')){
																	echo '<i class="fa fa-star-half-empty" style="color:#2e2efd;"></i>';
																	$i++;
																}
																while($i<=5) {
																	echo '<i class="fa fa-star-o empty" style="color:#2e2efd;"></i>';$i++;
																}
															?>
														</div>
													<?php }}?>


									<p class="cpproduct-category">By:<a href="<?php  echo base_url(); ?>home/contactSupplier?material_id=<?php echo $product['id'];  ?>&company_id=<?php echo $product['created_by_cid'];  ?>"><?php echo getNameById('company_detail',$product['created_by_cid'],'id')->name;  ?></a></p>
								</div>

								<div class="cpproduct-tags">
									<?php echo get_tags_html($product['id'],'material'); ?>
									<h4 class="cpproduct-price"> <i class="fa fa-inr"></i> <?php echo $product['sales_price'];  ?><font class="product-min-order"> Min. order of <?php echo $product['min_order']; ?> pieces.</font></h4>
								</div>
								<div class="cpproduct-body">
									<div class="cpproduct-btns">
										<button onclick="location.href='<?php  echo base_url(); ?>home/product_detail?material_id=<?php echo $product['id'];  ?>&company_id=<?php echo $product['created_by_cid'];  ?>';" data-toggle="tooltip" data-placement="top" data-custom-class="tooltip" title="Quick View"><i class="fa fa-eye"></i></button>
										<button onclick="location.href='<?php  echo base_url(); ?>home/contactSupplier?material_id=<?php echo $product['id'];  ?>&company_id=<?php echo $product['created_by_cid'];  ?>';" data-toggle="tooltip" data-placement="top" data-custom-class="tooltip" title="Contact Supplier"><i class="fa fa-phone"></i></button>
									</div>
								</div>
							</div>
							<?php  }
							}else{
									echo '<img class="img-responsive gallerypic" src="'.base_url().'assets/images/image-placeholder.png" alt="First slide">';
							}	?>

						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-------------------------------------------------------------Company logo upload used cropmethod---------------------------------------------------------------->
<div id="imageModalUpload" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Upload & Crop Image</h4>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="panel panel-default">
						<div class="panel-heading">Select Profile Image</div>
							<div class="panel-body" align="center">
								<!--<input type="file" name="user_profile" id="user_profile" accept="image/*" />-->
								<input type="file" name="logo" id="logo" accept="image/*" />
								<input type="hidden" name="changed_user_profile" id="changed_user_profile" value=""/>
								<!--<input type="hidden" name="fileOldlogo" value="<?php //echo isset($user->user_profile)?$user->user_profile: "";?>">-->
								<br />
								<div id="uploaded_image"></div>
							</div>
					</div>
				</div>
				<div class="row crop_section" style="display:none;">
					<div class="col-md-8 text-center">
						<div id="image_demo" style="width:350px; margin-top:30px"></div>
					</div>
					<div class="col-md-4" style="padding-top:30px;">
						<br />
						<br />
						<br/>
						<button class="btn btn-success crop_image">Crop & Upload Image</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
    </div>
</div>




<!------------------------------------------------------------post upload used cropmethod---------------------------------------------------------------->

<div id="uploadimageModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Upload & Crop Image</h4>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="panel panel-default">
						<div class="panel-heading">Select Profile Image</div>
							<div class="panel-body" align="center">
								<input type="file" name="post_image" id="post_crop_image" accept="image/*" />
								<input type="hidden" name="changed_user_profile" id="changed_user_profile" value=""/>
								<!--<input type="hidden" name="fileOldlogo" value="<?php //echo isset($user->user_profile)?$user->user_profile: "";?>">-->
								<br />
								<div id="uploaded_image"></div>
							</div>
					</div>
				</div>
				<div class="row crop_section1" style="display:none;">
					<div class="col-md-8 text-center">
						<div id="image_demo1" style="width:350px; margin-top:30px"></div>
					</div>
					<div class="col-md-4" style="padding-top:30px;">
						<br />
						<br />
						<br/>
						<button class="btn btn-success crop_image1">Crop & Upload Image</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
    </div>
</div>
