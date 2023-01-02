	<div class="modal-body">
		<div class="row">	

			<?php if($_SESSION['loggedInUser']->role != 2){ ?>						  
				<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>company/save_company_group" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
					<div class="col-md-6 col-sm-12 col-xs-12 ">
					<input type="hidden" name="id" value="<?php if(!empty($comapny_group_details)) echo $comapny_group_details->id; ?>">
					
						<div class="panel-default">
							<h3 class="Material-head">Information <hr></h3>
							<div class="panel-body vertical-border">							
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Company Name<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input id="name" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($comapny_group_details)) echo $comapny_group_details->name; ?>" name="name" placeholder="ex. John f. Kennedy" required="required" type="text" <?php //if(!empty($comapny_group_details)) echo 'disabled'; ?>> 
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="email">Email </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="email" id="email" name="company_group_email"  class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php if(!empty($comapny_group_details)) echo @$comapny_group_details->company_group_email; ?>" <?php if(!empty($comapny_group_details)) ; ?>>
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="email">Phone <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="tel" id="phone" name="phone" required="required" data-validate-length-range="8,10" class="form-control col-md-7 col-xs-12" placeholder="+91 9858468953" value="<?php if(!empty($comapny_group_details)) echo $comapny_group_details->phone; ?>">
								</div>
							</div>
							
							
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="expierence">Company Logo</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<?php
									if($comapny_group_details == ''){		
									?>
									<div class="col-md-12">
									
										<input type="file" name="fileOldlogo" value="<?php echo isset($comapny_group_details->logo)?$comapny_group_details->logo: " ";?>">
										<!--input type="hidden" name="fileOldlogo" value="<?php //echo isset($comapny_group_details->logo)?$comapny_group_details->logo: " ";?>">
										
										<!--button type="button" class="btn" name="logo" id="logoSite22">Upload Logo</button-->
										          
									</div>
									<?php }else{ 
									
									//pre($comapny_group_details);
									?>
									<div id="logo-holder" class="col-md-5">
										<img src="<?php echo base_url('assets/modules/company/uploads').'/'.(isset($comapny_group_details->logo) && $comapny_group_details->logo != '' ?$comapny_group_details->logo:"company_placeholder.png ");?>" class="img-responsive loogo"  onerror="this.onerror=null;this.src='<?php echo base_url().'assets/images/company-logo.jpg' ?>';">
										<input type="hidden" name="fileOldlogo" class="old_image" value="<?php echo isset($comapny_group_details->logo)?$comapny_group_details->logo: " ";?>">
										<?php 
										if($comapny_group_details->logo != ''){
										?>
										<div class="mask">
										<?php 
										//ata-href="'.base_url().'company/delete_doccs/'.$comapny_group_details->id.'"
                                                echo '<a href="javascript:void(0)" class="delete_logo2 btn btn-danger" >
                                                <i class="fa fa-trash dlt_btn"></i>
                                                </a>';
										?>		
                                            </div>
										<?php } ?>
										<button type="button" class="btn" name="logo" id="logoSite22">Upload Logo</button>
									</div>
									<?php } ?> 
							    										
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
										<input type="text" id="year" name="year_of_establish" required="required" class="form-control col-md-7 col-xs-12 date-picker-year" placeholder="ex.2001" value="<?php if(!empty($comapny_group_details)) echo $comapny_group_details->year_of_establish; ?>"> 
									</div>
								</div>
								
								<div class="item form-group">
									<label class="col-md-3 col-sm-3 col-xs-12" for="employees">Employees</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="number" id="no_employees" name="no_of_employees" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($comapny_group_details)) echo $comapny_group_details->no_of_employees; ?>" placeholder="0">
									</div>
								</div>
								<div class="item form-group">
									<label class="col-md-3 col-sm-3 col-xs-12" for="gstin">GSTIN<span class="required">*</span></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" id="designation" name="gstin" data-validate-length-range="8,20" required="required" class="form-control col-md-7 col-xs-12" placeholder="GSTIN number" value="<?php if(!empty($comapny_group_details)) echo $comapny_group_details->gstin; ?>" <?php if(!empty($comapny_group_details) && $comapny_group_details->gstin !='') echo 'readonly'; ?>>
									</div>
								</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Company PAN<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<?php /* <input id="companyPan" class="form-control col-md-7 col-xs-12 companyPan" value="<?php if(!empty($comapny_group_details)) echo $comapny_group_details->pan_no; ?>" name="pan_no" placeholder="ABCDFA87565B" required="required" type="text" onblur="fnValidatePAN(this);"> */  ?>
									<input id="companyPan" class="form-control col-md-7 col-xs-12 companyPan" value="<?php if(!empty($comapny_group_details)) echo $comapny_group_details->company_pan; ?>" name="company_pan" placeholder="ABCDFA87565B" required="required" type="text" onblur="fnValidatePAN(this);"> 
								</div>
							</div>
							
						
					</div>
			</div>
		</div>	
    <hr>													
        <div class="bottom-bdr"></div>
        <?php #pre($comapny_group_details);?>
			<div class="col-md-12 col-sm-12 col-xs-12 form-group bank_wrraper middle-box">	
				<?php if(empty($comapny_group_details->bank_details)){ ?>
							<div class="well scend-tr mobile-view"   id="chkIndex_1">
							<div class="col-md-4 col-sm-12 col-xs-12 item form-group">	
						        <label class="col-md-12" terial Name>Account Name<span class="required">*</span></label>						
								<input type="text" id="account_name" name="account_name[]" class="form-control col-md-7 col-xs-12" value="">
							</div>
							<div class="col-md-2 col-sm-12 col-xs-12 item form-group">	
						        <label class="col-md-12" terial Name>Account Number<span class="required">*</span></label>						
								<input type="text" id="account_no" name="account_no[]" class="form-control col-md-7 col-xs-12" value="">
							</div>
							<div class="col-md-2 col-sm-12 col-xs-12 item form-group">
								<label class="col-md-12">Bank IFSC Code</label>						
							<input type="text" id="account_ifsc_code" name="account_ifsc_code[]" class="form-control col-md-7 col-xs-12" value="">
							</div>
							<div class="col-md-2 col-sm-6 col-xs-12 form-group">
							<label class="col-md-12" >Bank Name</label>
								<input type="text" id="bank_name" value="" name="bank_name[]" class="form-control col-md-7 col-xs-12"/> 
							</div>
							<div class="col-md-2 col-sm-6 col-xs-12 form-group">
							<label class="col-md-12">Bank Branch</label>
								<input type="text" id="branch" value="" name="branch[]" class="form-control col-md-7 col-xs-12"/> 
							</div>
							<!--button class="btn btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button-->						
							</div>
                    				
				<?php } else{ 
						$bankdetails = json_decode($comapny_group_details->bank_details);
						?>
						<?php
						if(!empty($bankdetails)){ 
								$i =  1;
								foreach($bankdetails as $bnkdtls){

									#pre($bnkdtls);
								?>
									<div class="well <?php if($i==1){ echo 'edit-row1 scend-tr mobile-view';}else{ echo 'scend-tr mobile-view';}?>"  id="chkWell_<?php echo $i; ?>" style="overflow:auto; ">
										<div class="col-md-4 col-sm-12 col-xs-12 item form-group">	
									      <label class="col-md-12" terial Name>Account Name<span class="required">*</span></label>		
											<input type="text" id="account_no" name="account_name[]" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($bnkdtls->account_name)){echo $bnkdtls->account_name;} ?>">
										</div>
										<div class="col-md-2 col-sm-12 col-xs-12 item form-group">	
									      <label class="col-md-12" terial Name>Account Number<span class="required">*</span></label>		
											<input type="text" id="account_no" name="account_no[]" class="form-control col-md-7 col-xs-12" value="<?php  if(!empty($bnkdtls->account_no)){echo $bnkdtls->account_no;} ?>">
										</div>
										<div class="col-md-2 col-sm-12 col-xs-12 item form-group">
										<label class="col-md-12">Bank IFSC Code</label>						
										<input type="text" id="account_ifsc_code" name="account_ifsc_code[]" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($bnkdtls->account_ifsc_code)){echo $bnkdtls->account_ifsc_code;} ?>">
										</div>
										<div class="col-md-2 col-sm-6 col-xs-12 form-group">
										<label class="col-md-12" >Bank Name</label>
										<input type="text" id="bank_name" value="<?php if(!empty($bnkdtls->bank_name)){echo $bnkdtls->bank_name;} ?>" name="bank_name[]" class="form-control col-md-7 col-xs-12"/> 
										</div>
										<div class="col-md-2 col-sm-6 col-xs-12 form-group">
										<label class="col-md-12">Bank Branch</label>
										<input type="text" id="branch" value="<?php if(!empty($bnkdtls->branch)){echo $bnkdtls->branch;} ?>" name="branch[]" class="form-control col-md-7 col-xs-12"/> 
										</div>		
										</div>
					<?php $i++; }
					}
				}?>	

			</div>	
						<!--div class="col-sm-12 btn-row">
							<button class="btn add_bank_address_button edit-end-btn" type="button" align="right">Add</button>
						</div-->	




				<hr>													
                    <div class="bottom-bdr"></div>	
				<div class="col-md-12 col-sm-12 col-xs-12 form-group" style="display:none">
				<div class="panel-default">
				 <h3 class="Material-head">Address<hr></h3>
				<div class="panel-body address_wrapper">
					<?php
					//echo $_SESSION['loggedInUser']->c_id;
				#	pre($comapny_group_details->address);
					if(!empty($comapny_group_details) && $comapny_group_details->address !='' && $comapny_group_details->address !='[""]'){
					   #echo  'hfhfhfhfhf';
						#pre($company->address);
						$addressDetail = json_decode($comapny_group_details->address);
						#pre($addressDetail);
					    $add= 	!empty($addressDetail)?count($addressDetail):'';
						echo '<input type="hidden" class="addressLength" value="'.$add.'">';
						$j=0;
						if(!empty($addressDetail)){
						 foreach($addressDetail as $address){
							
							if($j==0){
								#$addBtn = '<button class="btn btn-warning add_address_button" type="button"><i class="fa fa-plus"></i></button>';
								$addBtn = '<button class="btn btn-warning add_company_address_button" type="button"><i class="fa fa-plus"></i></button>';
							}else{
								$addBtn = '<button class="btn btn-danger remove_address_field" type="button"><i class="fa fa-minus"></i></button>';
							}
								if($addressDetail != ''){
								//if(!empty($address->compny_branch_name)){
								echo '<div class="item form-group well2 input_address_wrap id="chkIndex_'.$j.'" "><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"><label class="col-md-3 col-sm-3 col-xs-12">Company Branch Name</label><div class="col-md-6 col-sm-12 col-xs-12 form-group"><input type="text" id="compny_branch_name" name="compny_branch_name[]" class="form-control col-md-1" placeholder="Company Branch Name" value="'.$address->compny_branch_name.'"></div></div>';
							//	}			
								
								echo '<div class="col-md-6 col-sm-12 col-xs-12 vertical-border"><label class="col-md-3 col-sm-3 col-xs-12">Company Address</label><div class="col-md-6 col-sm-12 col-xs-12 form-group"><textarea id="address"  name="address[]" class="form-control col-md-7 col-xs-12" placeholder="Address">'.$address->address.'</textarea></div></div><div class="col-md-12" >'; 
									?>
									
									
					<div class="item form-group col-md-3 col-sm-3 col-xs-12">
						<label class="col-md-12 col-sm-4 col-xs-4 form-group" for="billing_country">Country</label>
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
						<label class="col-md-12 col-sm-4 col-xs-4 form-group" for="permanent_state">State/Province</label>
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
						<label class="form-groupcol-md-12 col-sm-4 col-xs-4" for="city">City<span class="required">*</span></label>
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
					
					</div>
					</div>
					<div class="col-md-2 col-sm-12 col-xs-12 form-group">
						<label style="border-right: 1px solid #c1c1c1" class="form-groupcol-md-12 col-sm-4 col-xs-4" for="city">GSTIN<span class="required">*</span></label>
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
								<div class="col-md-12 input_address_wrap" id="chkIndex_0">
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 form-group">
									<input type="text" id="compny_branch_name" name="compny_branch_name[]" class="form-control col-md-1" placeholder="Company Branch Name" value="">
								</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
										<textarea id="address" name="address[]" class="form-control col-md-7 col-xs-12" placeholder="Address"></textarea>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">						
										<div class="item form-group col-md-3 col-sm-3 col-xs-12">
											<label class="control-label col-md-4 col-sm-4 col-xs-4" for="billing_country">Country</label>
											<div class="col-md-8 col-sm-8 col-xs-8">
												<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="country[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this)">
													<option value="">Select Option</option>
												</select>
											</div>
										</div>											
										<div class="item form-group col-md-3 col-sm-3 col-xs-12">
											<label class="control-label col-md-4 col-sm-4 col-xs-4" for="permanent_state">State/Province</label>
											<div class="col-md-8 col-sm-8 col-xs-8">								
												<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1 state_id" name="state[]"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)">
													<option value="">Select Option</option>		
												</select>
											</div>
										</div>	
										<div class="item form-group col-md-3 col-sm-3 col-xs-12">
											<label class="control-label col-md-4 col-sm-4 col-xs-4" for="city">City<span class="required">*</span></label>
											<div class="col-md-8 col-sm-8 col-xs-8">										
												<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1 city_id" name="city[]"  width="100%" tabindex="-1" aria-hidden="true">
													<option value="">Select Option</option>
												</select>
											</div>
										</div>																
										<div class="col-md-2 col-sm-12 col-xs-12 form-group">
										<label class="form-groupcol-md-4 col-sm-4 col-xs-4" for="city">Postal/Zipcode<span class="required">*</span></label>
											<input type="text" id="postal_zipcode" name="postal_zipcode[]" class="form-control col-md-1" placeholder="Postal/Zipcode" value="">
										</div>
										<div class="col-md-2 col-sm-12 col-xs-12 form-group">
										<label class="form-groupcol-md-4 col-sm-4 col-xs-4" for="city">GSTIN<span class="required">*</span></label>
											<input type="text" id="company_gstin" name="company_gstin[]" class="form-control col-md-1" placeholder="Company GSTIN" value="">
										</div>
										<div class="col-sm-12 btn-row">
										<button class="btn btn-warning add_company_address_button" type="button"><i class="fa fa-plus"></i></button></div>
									</div>
								</div>
							</div>
						<?php } 
						?>
					
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
			
<!--------------------------------------Company logo upload used cropmethod---------------------------------------------------------------->
<div id="imageModalUpload22" class="modal" role="dialog">
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
						<button class="btn btn-success " id="crop_image22ddd">Crop & Upload Image</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
    </div>
</div>




<!---------------------------------------------post upload used cropmethod---------------------------------------------------------------->			
			
			