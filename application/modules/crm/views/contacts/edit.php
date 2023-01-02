<?php   

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

?>


<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>crm/saveContact" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
		<input type="hidden" name="id" value="<?php if(!empty($contact)){ echo $contact->id;   }?>">
		<input type="hidden" name="save_status" value="1" class="save_status">	
		
		<div class="container mt-3">
<h3 class="Material-head" style="margin-bottom: 30px;">Contact Details<hr></h3>
  <!-- Nav tabs -->
  <ul class="nav tab-3 nav-tabs">
    <li class="nav-item active">
      <a class="nav-link " data-toggle="tab" href="#Contact-Information">Contact Information</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#Shipping">Additional  Information</a>
  

  </li></ul>
  <div class="tab-content">	
 <div id="Contact-Information" class="container tab-pane active"> 
      <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	       <div class="form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-4" for="first-name">Contact Owner</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<span><?php if(!empty($_SESSION['loggedInUser'])) echo $_SESSION['loggedInUser']->name ;?></span>
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="phone">Phone<span class="required">*</span></label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="tel" id="phone" name="phone" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($contact)) echo $contact->phone ;?>" required="required">
			</div>
		</div>
		
				
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="first_name">First Name </label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" id="first_name" name="first_name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($contact)) echo $contact->first_name ;?>" data-validate-length-range="6">
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="first_name">Last Name </label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" id="last_name" name="last_name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($contact)) echo $contact->last_name ;?>">
			</div>
		</div>
	  </div>
      <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	        <div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="phone">Mobile</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="tel" id="mobile" name="mobile" class="form-control col-md-7 col-xs-12 optional" value="<?php if(!empty($contact)) echo $contact->mobile ;?>">
			</div>
		</div>
		
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="first_name">Email </label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="email" id="email" name="email" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($contact)) echo $contact->email ;?>">
			</div>
		</div>
		<div class="required item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="required col-md-3 col-sm-12 col-xs-12" for="account_id">Account Name </label>
			<div class="required col-md-6 col-sm-12 col-xs-12">
				<select class="itemName form-control selectAjaxOption select2" name="account_id" data-id="account" data-key="id" data-fieldname="name" data-where="account_owner = <?php echo /*$_SESSION['loggedInUser']->c_id*/ $this->companyGroupId ; ?> AND save_status = 1" width="100%">
					<option value="">Select Option</option>
					<?php 
						if(!empty($contact)){
							$account = getNameById('account',$contact->account_id,'id');
							echo '<option value="'.$account->id.'" selected>'.$account->name.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="website">Title</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" id="title" name="title" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($contact)) echo $contact->title ;?>">
			</div>
		</div>
	  </div>
 </div>	
<div id="Shipping" class="container tab-pane "> 
    <div class="col-md-6 col-sm-6 col-xs-12">
					
					<select class="form-control col-md-2 col-xs-12 selectAjaxOption select2" required="required" name="company_unit" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo /*$_SESSION['loggedInUser']->c_id*/ $this->companyGroupId; ?>" onChange="getDept(event,this)">
						<option value="">Select Unit</option>
						<?php
						if(!empty($contact)){
							$getUnitName = getNameById('company_address',$contact->company_unit,'compny_branch_id');
							echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
						}
					?>
					</select>
					
					<!--select class="form-control  select2 get_location compny_unit" required="required" name="company_branch" onChange="getDept(event,this)">
						<option value="">Select Option</option>
							<?php
								/* f(!empty($Addmachine)){
									echo '<option value="'.$Addmachine->company_branch.'" selected>'.$Addmachine->company_branch.'</option>';
									} */
								?>
					</select-->
				</div>


				<div class="col-md-6 col-sm-6 col-xs-12">
					<?php /*<select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="abc" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name='unit 2'" tabindex="-1" aria-hidden="true" >
							<option value="">Select Option</option>										
					</select>
					*/?>
						<select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" name="departments"  tabindex="-1" aria-hidden="true">
								<option value="">Select Option</option>	
								<?php
									if(!empty($contact)){
										$departmentData = getNameById('department',$contact->department,'id');
										if(!empty($departmentData)){
											echo '<option value="'.$departmentData->id.'" selected>'.$departmentData->name.'</option>';
										}
									}
								?>								
						</select>
				</div>
			</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="home_phone">Home Phone</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="tel" id="home_phone" name="home_phone" class="form-control col-md-7 col-xs-12 optional" value="<?php if(!empty($contact)) echo $contact->home_phone ;?>">
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="type">Lead Source</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="lead_source" data-id="lead_source" data-key="id" data-fieldname="source_name" width="100%" tabindex="-1" aria-hidden="true">
									<option value="">Select Option</option>
									 <?php
										if(!empty($contact)){
											$status = getNameById('lead_source',$contact->lead_source,'id');
											echo '<option value="'.$contact->lead_source.'" selected>'.$status->source_name.'</option>';
										}
									?>
								</select>	
				
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="employee">Other Phone</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="tel" id="other_phone" name="other_phone" class="form-control col-md-7 col-xs-12 optional" value="<?php if(!empty($contact)) echo $contact->other_phone ;?>">
			</div>
		</div>
	 </div>
	 <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	       <div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="employee">Date Of Birth</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
			<fieldset>
				<div class="control-group ">
					<div class="controls">
						<div class=" xdisplay_inputx form-group has-feedback">
							<input type="text" class="form-control has-feedback-left" name="dob" id="dob" aria-describedby="inputSuccess2Status3" value="<?php if(!empty($contact)) echo $contact->dob ;?>">
							<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
							<span id="inputSuccess2Status3" class="sr-only">(success)</span>
						</div>
					</div>
				</div>
			</fieldset>	</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="asst_phone">Assistant Phone</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="tel" id="asst_phone" name="asst_phone" class="form-control col-md-7 col-xs-12 optional" value="<?php if(!empty($contact)) echo $contact->asst_phone ;?>">
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="asst_phone">Assistant</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" id="assistant" name="assistant" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($contact)) echo $contact->assistant ;?>">
			</div>
		</div>
	 </div>
</div> 
</div>
</div>
<hr>  
<div class="bottom-bdr"></div>		
		
		<?php /*<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="control-label col-md-2 col-sm-2 col-xs-4" for="account_id">Report To</label>
			<div class="col-md-10 col-sm-10 col-xs-8">
				<select class="itemName selectAjaxOption select2" name="report_to" data-id="contacts" data-key="id" data-fieldname="first_name" width="100%">
					<option value="">Select Option</option>
					<?php 
						if(!empty($contact)){
							$reportTo = getNameById('contacts',$contact->report_to,'id');

							echo '<option value="'.$contact->report_to.'" selected>'.$reportTo->first_name.'</option>';
						}
					?>
				</select>
			</div>
		</div> */?>
	
				
				
<div class="container mt-3">
<h3 class="Material-head" style="margin-bottom: 30px;">Address Details<hr></h3>
  <!-- Nav tabs -->
  <ul class="nav tab-3 nav-tabs">
    <li class="nav-item active">
      <a class="nav-link " data-toggle="tab" href="#Mailing-Address">Mailing Address</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#Other-Address">Other Address</a>
  

  </li></ul>
<div class="tab-content">
<div class="item form-group col-md-6 col-xs-12 vertical-border" style="margin:15px 0px;margin-bottom: 0px;padding-bottom: 20px;">
		    <label class="col-md-3 col-sm-12 col-xs-12" for="city"></label>
			<div class="col-md-7 col-sm-12 col-xs-12">										
				<input type="checkbox" id="same_address" name="same_address" value="same_address" <?php if(!empty($contact) && $contact->other_city == $contact->mailing_city && $contact->other_city != 0 && $contact->mailing_city !=0 ){echo 'checked';} ?>  >
					<label for="subscribeNews">Please Check if you have same address</label>
			</div>
		</div>
 	
		 <div id="Mailing-Address" class="container tab-pane active"> 
              <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
			<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="mailing_street">Mailing Street</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<textarea id="mailing_street" rows="6" name="mailing_street" class="form-control col-md-7 col-xs-12" placeholder=""><?php if(!empty($contact)) echo $contact->mailing_street ;?></textarea>
			</div>
		  </div>

		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-2" for="mailing_zipcode">Mailing Zip/Postal Code</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="number" id="mailing_zipcode" name="mailing_zipcode" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($contact)) echo $contact->mailing_zipcode ;?>">
			</div>
		</div>   
              </div>
         <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		       <div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="mailing_country">Mailing Country</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="mailing_country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getState(event,this,'mailing')">
					<option value="">Select Option</option>
					 <?php
						if(!empty($contact)){
							$country = getNameById('country',$contact->mailing_country,'country_id');
							echo '<option value="'.$contact->mailing_country.'" selected>'.$country->country_name.'</option>';
						}
					?>
				</select>
			</div>
		</div>			
		
			
			<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="city">Mailing State / Province<span class="required">*</span></label>
			<div class="col-md-6 col-sm-12 col-xs-12">								
				<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible mailing state_id" name="mailing_state"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this,'mailing')" required>
					<option value="">Select Option</option>
					 <?php
						if(!empty($contact)){
							$state = getNameById('state',$contact->mailing_state,'state_id');
							echo '<option value="'.$contact->mailing_state.'" selected>'.$state->state_name.'</option>';
						}
					?>
				</select>
			</div>
		</div>				
			
			
		
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="city">Mailing City<span class="required">*</span></label>
			<div class="col-md-6 col-sm-12 col-xs-12">										
				<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible mailing city_id" name="mailing_city"  width="100%" tabindex="-1" aria-hidden="true" required="required">
					<option value="">Select Option</option>
					 <?php
						if(!empty($contact)){
							$city = getNameById('city',$contact->mailing_city,'city_id');
							echo '<option value="'.$contact->mailing_city.'" selected>'.$city->city_name.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		
          </div>		 
		 </div>
		  <div id="Other-Address" class="container tab-pane ">
		       <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
			            
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="other_street">Other Street</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<textarea id="other_street" rows="6" name="other_street" class="form-control col-md-7 col-xs-12" placeholder=""><?php if(!empty($contact)) echo $contact->other_street ;?></textarea>
			</div>
			</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="phone">Other Zip/Postal Code</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" id="other_zipcode" name="other_zipcode" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($contact)) echo $contact->other_zipcode ;?>">
			</div>
		</div>
		
			    </div>
		       <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
			<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="other_country">Other Country</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="other_country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this,'other')">
					<option value="">Select Option</option>
					 <?php
						if(!empty($contact)){
							$country = getNameById('country',$contact->other_country,'country_id');
							echo '<option value="'.$contact->other_country.'" selected>'.$country->country_name.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="city">Other State / Province<span class="required">*</span></label>
			<div class="col-md-6 col-sm-12 col-xs-12">								
				<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible other state_id" name="other_state"  width="100%" tabindex="-1" aria-hidden="true" onchange="getCity(event,this,'other')">
					<option value="">Select Option</option>
					 <?php
						if(!empty($contact)){
							$state = getNameById('state',$contact->other_state,'state_id');
							echo '<option value="'.$contact->other_state.'" selected>'.$state->state_name.'</option>';
						}
					?>
				</select>
			</div>
		</div>	
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="city">Other City<span class="required">*</span></label>
			<div class="col-md-6 col-sm-12 col-xs-12">										
				<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible other city_id" name="other_city"  width="100%" tabindex="-1" aria-hidden="true" >
					<option value="">Select Option</option>
					 <?php
						if(!empty($contact)){
							$city = getNameById('city',$contact->other_city,'city_id');
							echo '<option value="'.$contact->other_city.'" selected>'.$city->city_name.'</option>';
						}
					?>
				</select>
			</div>
		</div>
			   </div>
			   
		  </div>
</div> 
</div>	
<hr>  
<div class="bottom-bdr"></div>
		
		<h3 class="Material-head" style="margin-bottom: 30px;">Other Description<hr></h3>

		<div class="item form-group col-md-6 col-sm-12 col-xs-12  vertical-border">
			<label class="col-md-3 col-sm-12 col-xs-12" for="description">Description</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<textarea id="description" rows="6" name="description" class="form-control col-md-7 col-xs-12" placeholder=""><?php if(!empty($contact)) echo $contact->description ;?></textarea>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="ln_solid"></div>
		<div class="form-group">
				<div class="col-md-12 col-xs-12">
				<center>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="reset" class="btn btn-default">Reset</button>
				<?php if((!empty($contact) && $contact->save_status !=1) || empty($contact)){
						echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
					}?> 
				<input type="submit" class="btn edit-end-btn" value="Submit">
				</center>
				</div>
		</div>
	</form>