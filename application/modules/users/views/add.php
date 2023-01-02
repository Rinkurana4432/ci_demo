<div class="x_content">	
    <form method="post" id="editUserForm" class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>users/save">										
        <input type="hidden" name="id" value="">										
		<input type="hidden" name="u_id" value="">										
		<input type="hidden" name="c_id" value="<?php  echo $_SESSION['loggedInUser']->c_id;?>">										
		<div class="item form-group">												
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">User Name <span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">												
                <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"  name="name" placeholder="both name(s) e.g Jon Doe" required="required" type="text" value="">
            </div>											
        </div>											
		<div class="item form-group">												
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email<span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">												
				<input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter email" value="">
			</div>											
		</div>											
        <div class="item form-group">												
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="designation">Designation<span class="required">* </span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">												
				<input type="text" id="designation" name="designation" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter designation" value="">												
			</div>											
        </div>												
		<div class="item form-group">													
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Telephone <span class="required">*</span> </label>
			<div class="col-md-6 col-sm-6 col-xs-12">														
				<input type="tel" id="telephone" name="contact_no" required="required" data-validate-length-range="8,10" class="form-control col-md-7 col-xs-12" placeholder="Enter mobile number" value="">													
			</div>												
		</div>												
		<div class="item form-group">													
			<label class="control-label col-md-3 col-sm-3 col-xs-12">State</label>														
			<div class="col-md-6 col-sm-6 col-xs-12">														
				<select class="form-control" name="state">	
					<option>Select State</option>
				  <?php 
					  $states = getStates();
					  foreach($states as $state) {	
						echo "<option value='".$state."'>".$state."</option>";	
					  }
					?>														
				</select>													
			</div>												
		</div>												
		<div class="item form-group">													
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="expierence">Expierence(in Years)<span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">														
				<input type="number" id="expierence" required="required" name="experience" class="form-control col-md-7 col-xs-12" placeholder="Expierence" value="">													
			</div>												
		</div>												
		<div class="item form-group">													
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="age">Date of Birth<span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">														
				<input type="text" id="date" required="required" name="age" class="form-control col-md-7 col-xs-12 has-feedback-left" data-validation="date" value="" placeholder="Date Of Birth" aria-describedby="inputSuccess2Status4">
				<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>													
			</div>												
		</div>					  												
		<div class="item form-group">													
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="qualification">Qualification<span class="required">*</span></label>	
			<div class="col-md-6 input_fields_wrap">														
				<div class="col-md-3 col-sm-12 col-xs-12 form-group">															
					<input type="text" id="qualification" required="required" name="qualification[]" class="form-control col-md-1" placeholder="Qualification" value="">														
				</div>														
				<div class="col-md-3 col-sm-12 col-xs-12 form-group">															
					<input type="text" id="university"  required="required" name="university[]" class="form-control col-md-1" placeholder="University" value="">
				</div>														
				<div class="col-md-3 col-sm-12 col-xs-12 form-group">															
					<input type="text"  required="required" name="year[]" class="form-control col-md-1 year" placeholder="Year of Passing" value="">
				</div>														
				<div class="col-md-2 col-sm-12 col-xs-12 form-group">															
					<input type="number" id="marks"  required="required" name="marks[]" class="form-control col-md-1" placeholder="Percentage" value="">
				</div>														
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">															
					<div class="input-group-append">															
						<button class="btn btn-primary add_field_button" type="button"><i class="fa fa-plus"></i></button>
					</div>														
				</div>	
			</div>	  
		</div>																
		<div class="item form-group">													
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Permanent Address<span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">														
				<textarea id="address1" required="required" name="address1" class="form-control col-md-7 col-xs-12" placeholder="Permanent Address"></textarea>
			</div>												
		</div>												
		<div class="item form-group">													
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address2">Correspondence Address</label>													
			<div class="col-md-6 col-sm-6 col-xs-12">														
				<textarea id="address2"  name="address2" class="form-control col-md-7 col-xs-12" placeholder="Correspondence Address"></textarea>
			</div>												
		</div>												
		<div class="item form-group">													
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="expierence">Profile</label>													
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div id="profile-holder">
					<input type="hidden" name="fileOldlogo" value="">
					<img src="<?php echo base_url('assets/modules/users/uploads').'/user.png';?>" height="100px" width="100px">
				</div>													 													 
				<input type="file" class="form-control col-md-7 col-xs-12" name="user_profile" id="profile_img"> 													
			</div>												
		</div>												 												
		<div class="item form-group">													
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="joining">Date Of Joining<span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">	
				<input type="text" id="date_join" required="required" name="date_joining" class="form-control col-md-7 col-xs-12 has-feedback-left" data-validation="date" value="" placeholder="Date Of Joining" aria-describedby="inputSuccess2Status4">
				<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
			</div>												
		</div> 																		
		<div class="ln_solid"></div>												
		<div class="form-group">													
			<div class="col-md-6 col-md-offset-3">														
				<button type="reset" class="btn btn-default">Reset</button>	
					<input type="button" class="btn btn-primary btn-cons btn-quirk draft" value="Save as draft">
				
				<input type="submit" class="btn btn-warning" value="Save">													
			</div>												
		</div>										
    </form>						
</div>