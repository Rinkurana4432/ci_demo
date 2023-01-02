<form method="post" id="editUserForm" class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>hrm/saveUser">
<div class="modal-body">
   <div class="col-md-12 col-sm-12 col-xs-12">
	  General Profile
	  <hr />
	  <div class="col-md-6 col-sm-12 col-xs-12 form-group">
		 <input type="hidden" name="id" value="<?php if(!empty($user)) echo $user->id; ?>">										
		 <input type="hidden" name="u_id" value="<?php if(!empty($user)) echo $user->u_id; ?>">										
		 <input type="hidden" name="c_id" value="<?php if(!empty($user)) echo $user->c_id; else echo $this->companyGroupId;?>">
		 <input type="hidden" name="save_status" value="1" class="save_status">							
		 <div class=" panel-default">
			<div class="panel-body vertical-border">
			   <div class="item form-group">
				  <label class="col-md-3 col-sm-3 col-xs-12" for="name">User Name<span class="required">*</span></label>
				  <div class="col-md-6 col-sm-6 col-xs-12">												
					 <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"  name="name" placeholder="both name(s) e.g Jon Doe" required="required" type="text" value="<?php if(!empty($edit)) echo $edit->name;?>">
				  </div>
			   </div>
			   <div class="item form-group">
				  <label class="col-md-3 col-sm-3 col-xs-12" for="email">Email<span class="required">*</span></label>
				  <div class="col-md-6 col-sm-6 col-xs-12">												
					 <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter email" <?php  if(!empty($user))  echo 'readonly'; ?> value="<?php  if(!empty($user))  echo $user->email; ?>">
				  </div>
			   </div>
			   <div class="item form-group">
				  <label class="col-md-3 col-sm-3 col-xs-12" for="gender">Gender <span class="required">*</span></label>
				  <div class="col-md-6 col-sm-6 col-xs-12">	
					 Male: <input type="radio" class="flat" name="gender" id="genderM" value="Male" <?php if(!empty($user) && $user->gender == 'Male')  echo 'checked'; ?> required /> 
					 Female: <input type="radio" class="flat" name="gender" id="genderF" value="Female"  <?php if(!empty($user) && $user->gender == 'Female')  echo 'checked'; ?>/>										
				  </div>
			   </div>
			   <div class="item form-group">
				  <label class="col-md-3 col-sm-3 col-xs-12" for="phone">Phone <span class="required">*</span> </label>
				  <div class="col-md-6 col-sm-6 col-xs-12">														
					 <input type="tel" id="phone" name="contact_no" required="required" data-validate-length-range="8,10" class="form-control col-md-7 col-xs-12" placeholder="Enter mobile number" value="<?php if(!empty($user))  echo $user->contact_no; ?>">
				  </div>
			   </div>
			   <div class="item form-group">
				  <label class="col-md-3 col-sm-3 col-xs-12" for="age">Date of Birth<span class="required">*</span>	</label>
				  <div class="col-md-6 col-sm-6 col-xs-12">														
					 <input type="text" id="date" required="required" name="age" class="form-control col-md-7 col-xs-12 has-feedback-left" data-validation="date" value="<?php if(!empty($user)) echo $user->age; ?>" placeholder="Date Of Birth" aria-describedby="inputSuccess2Status4">
					 <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
				  </div>
			   </div>
			</div>
		 </div>
	  </div>
	  <div class="col-md-6 col-sm-12 col-xs-12 form-group ">
		 <div class=" panel-default">
			<div class="panel-body vertical-border">
			   <div class="item form-group">
				  <label class="col-md-3 col-sm-3 col-xs-12" for="designation">Designation<span class="required">* </span></label>
				  <div class="col-md-6 col-sm-6 col-xs-12">												
					 <input type="text" id="designation" name="designation" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter designation" value="<?php if(!empty($user))  echo $user->designation; ?>">												
				  </div>
			   </div>
			   <div class="item form-group">
				  <label class="col-md-3 col-sm-3 col-xs-12" for="experience">Experience</label>
				  <div class="col-md-6 col-sm-6 col-xs-12">
					 <div class="input-group">
						<input type="number" id="experience" name="experience" class="form-control col-md-7 col-xs-12" placeholder="Experience (in Years)" value="<?php  if(!empty($user)) echo $user->experience; ?>">	
						<span class="input-group-addon">Years</span>
					 </div>
				  </div>
			   </div>
			   <div class="item form-group">
				  <label class="col-md-3 col-sm-3 col-xs-12" for="joining">Date Of Joining<span class="required">*</span></label>
				  <div class="col-md-6 col-sm-6 col-xs-12">	
					 <input type="text" id="date_join" required="required" name="date_joining" class="form-control col-md-7 col-xs-12 has-feedback-left" data-validation="date" value="<?php  if(!empty($user)) echo $user->date_joining; ?>" placeholder="Date Of Joining" aria-describedby="inputSuccess2Status4">
					 <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
				  </div>
			   </div>
                    <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">Company Name</label>
        <div class="col-md-6 col-sm-12 col-xs-12">
      <select name="company_id" class="itemName form-control" >
							<?php  
        if($_SESSION['loggedInUser']->role == 2 || $_SESSION['loggedInUser']->role == 3){
							$companies1 = getcompany_for_users();
							 //pre($companies1);
							$selected1 = '';
							if(!empty($companies1)){
								foreach($companies1 as $cg1){

                 

									if($cg1["id"] == $_SESSION['loggedInUser']->c_id){
										if(!isset($_SESSION['companyGroupSessionId'])){
											$selected1 = 'selected';
										}
										echo '<option value="0" '.$selected1.'>'.$cg1["name"].'</option>';
									}else{
										$selected1 = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] !='' && $_SESSION['companyGroupSessionId'] == $cg1["comp_id"])?'selected':'';
										echo '<option value="'.$cg1["comp_id"].'" '.$selected1.'>'.$cg1["name"].'</option>';
									}
								}
							}
          }
          else{
            $companies2 = getCompaniesOfGroup();
              $selected2 = '';
              if(!empty($companies2)){
                foreach($companies2 as $cg2){

                   # pre($cg2);

                  if($cg2["id"] == $_SESSION['loggedInUser']->c_id){
                    if(!isset($_SESSION['companyGroupSessionId'])){
                      $selected2 = 'selected';
                    }
                    echo '<option value="0" '.$selected2.'>'.$cg2["name"].'</option>';
                  }else{
                    $selected2 = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] !='' && $_SESSION['companyGroupSessionId'] == $cg2["id"])?'selected':'';
                    echo '<option value="'.$cg2["id"].'" '.$selected2.'>'.$cg2["name"].'</option>';
                  }
                }
              } 
          }
              ?>
						</select>
        </div>
    </div>
                       <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">Department Name</label>
        <div class="col-md-6 col-sm-12 col-xs-12">
       <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible selectedEmployeeID" name="dept_id" data-id="department" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true" required="required">
											<option value=''>Select department</option>
										</select>
         </div>
    </div>
			</div>
		 </div>
	  </div>
	  <hr />
	  <div class="bottom-bdr"></div>
	  <div class="container">
		 <ul class="nav tab-3 nav-tabs tab-3">
			<li class="active"><a data-toggle="tab" href="#Permanent-Address">Permanent Address</a></li>
			<li><a data-toggle="tab" href="#Address">Correspondance Address</a></li>
		 </ul>
		 <div class="tab-content">
			<div id="Permanent-Address" class="tab-pane fade in active">
			   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
				  <div class="panel-default">
					 <div class="panel-body address_wrapper">
						<div class="item form-group">
						   <div class="col-md-12 input_permanent_address_wrap" id="chkIndex_0">
							  <div class="col-md-6 vertical-border">
								 <div class="item form-group">
									<label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">Permanent Address</label>
									<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 ">
									   <textarea   name="permanent_address" class="form-control col-md-7 col-xs-12" placeholder="Address"><?php if(!empty($user) && !empty($permanentAddress)) echo $permanentAddress->address; ?></textarea>
									</div>
								 </div>
								 <div class="item form-group">
									<label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">zipcode</label>
									<div class="col-md-6 col-sm-12 col-xs-12 ">
									   <input type="number" id="postal_zipcode" name="permanent_postal_zipcode" class="form-control col-md-1" placeholder="Postal/Zipcode" value="<?php if(!empty($user) && !empty($permanentAddress)) echo $permanentAddress->postal_zipcode; ?>">
									</div>
								 </div>
							  </div>
							  <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
								 <div class="item form-group ">
									<label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">Permanent Country</label>
									<div class="col-md-6 col-sm-8 col-xs-8">
									   <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="permanent_country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this,'permanent')">
										  <option value="">Select Option</option>
										  <?php
											 if(!empty($user) && !empty($permanentAddress)){
											 $country = getNameById('country',$permanentAddress->country,'country_id');
											 echo '<option value="'.$permanentAddress->country.'" selected>'.$country->country_name.'</option>';
											 }
											 ?>
									   </select>
									</div>
								 </div>
								 <div class="item form-group ">
									<label class="col-md-3 col-sm-4 col-xs-4" for="permanent_state">Permanent State/Province</label>
									<div class="col-md-6 col-sm-8 col-xs-8">
									   <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible permanent state_id" name="permanent_state"  width="100%" tabindex="-1" aria-hidden="true" onchange="getCity(event,this,'permanent')">
										  <option value="">Select Option</option>
										  <?php
											 if(!empty($user) && !empty($permanentAddress) && $permanentAddress->state !=''){
											 $state = getNameById('state',$permanentAddress->state,'state_id');
											 echo '<option value="'.$permanentAddress->state.'" selected>'.$state->state_name.'</option>';
											 }
											 ?>
									   </select>
									</div>
								 </div>
								 <div class="item form-group ">
									<label class="col-md-3 col-sm-4 col-xs-4" for="city">Permanent City</label>
									<div class="col-md-6 col-sm-8 col-xs-8">
									   <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible permanent city_id" name="permanent_city"  width="100%" tabindex="-1" aria-hidden="true" >
										  <option value="">Select Option</option>
										  <?php
											 if(!empty($user) && !empty($permanentAddress)){
											 $city = getNameById('city',$permanentAddress->city,'city_id');
											 echo '<option value="'.$permanentAddress->city.'" selected>'.$city->city_name.'</option>';
											 }
											 ?>
									   </select>
									</div>
								 </div>
							  </div>
						   </div>
						</div>
					 </div>
				  </div>
			   </div>
			</div>
			<div id="Address" class="tab-pane fade in ">
			   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
				  <div class="panel-default">
					 <div class="panel-body address_wrapper">
						<div class="item form-group">
						   <div class="col-md-12 input_correspondance_address_wrap" id="chkIndex_0">
							  <div class="col-md-6 vertical-border">
								 <div class="item form-group">
									<label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">Correspondance Address</label>
									<div class="col-md-6 col-sm-8 col-xs-8">
									   <textarea  name="correspondance_address" class="form-control col-md-7 col-xs-12" placeholder="Address"><?php if(!empty($user) && !empty($correspondanceAddress)) echo $correspondanceAddress->address;?></textarea>
									</div>
								 </div>
								 <div class="item form-group">
									<label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">zipcode</label>
									<div class="col-md-6 col-sm-12 col-xs-12 ">
									   <input type="number" name="correspondance_postal_zipcode" class="form-control col-md-1" placeholder="Postal/Zipcode" value="<?php if(!empty($user) && !empty($correspondanceAddress)) echo $correspondanceAddress->postal_zipcode;?>">
									</div>
								 </div>
							  </div>
							  <div class="col-md-6 vertical-border">
								 <div class="item form-group">
									<div class="item form-group ">
									   <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">Correspondance Country</label>
									   <div class="col-md-6 col-sm-8 col-xs-8">
										  <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="correspondance_country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this,'correspondance')">
											 <option value="">Select Option</option>
											 <?php
												if(!empty($user) && !empty($correspondanceAddress)){
													$country = getNameById('country',$correspondanceAddress->country,'country_id');
													echo '<option value="'.$correspondanceAddress->country.'" selected>'.$country->country_name.'</option>';
												}
												?>
										  </select>
									   </div>
									</div>
									<div class="item form-group ">
									   <label class="col-md-3 col-sm-4 col-xs-4" for="correspondance_state">Correspondance State/Province</label>
									   <div class="col-md-6 col-sm-8 col-xs-8">
										  <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible correspondance state_id" name="correspondance_state"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this,'correspondance')">
											 <option value="">Select Option</option>
											 <?php
												if(!empty($user) && !empty($correspondanceAddress)){
													$state = getNameById('state',$correspondanceAddress->state,'state_id');
													echo '<option value="'.$correspondanceAddress->state.'" selected>'.$state->state_name.'</option>';
												}
												?>
										  </select>
									   </div>
									</div>
									<div class="item form-group ">
									   <label class="col-md-3 col-sm-4 col-xs-4" for="city">Correspondance City</label>
									   <div class="col-md-6 col-sm-8 col-xs-8">
										  <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible correspondance city_id" name="correspondance_city"  width="100%" tabindex="-1" aria-hidden="true" >
											 <option value="">Select Option</option>
											 <?php
												if(!empty($user) && !empty($correspondanceAddress)){
													$city = getNameById('city',$correspondanceAddress->city,'city_id');
													echo '<option value="'.$correspondanceAddress->city.'" selected>'.$city->city_name.'</option>';
												}
												?>
										  </select>
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
		 </div>
	  </div>
	  <hr />
	  <div class="bottom-bdr"></div>
	  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
		 <h3 class="Material-head" style="margin-bottom: 30px;">
			Qualification
			<hr />
		 </h3>
		 <div class=" panel-default">
			<div class="panel-body quaification_wrapper">
			   <div class="col-sm-12  col-md-12 label-box mobile-view2">
				  <div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label >Qualification</label></div>
				  <div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label>University</label></div>
				  <div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label>Year of Passing</label></div>
				  <div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label style=" border-right: 1px solid #c1c1c1 !important;" >Percentage</label></div>
			   </div>
			   <?php if(!empty($user) && $user->qualification !='' && $user->qualification !='[""]'){
				  $qual = json_decode($user->qualification);
				  $i=0;												
				  foreach($qual as $qu){
				  if($i==0){
				  $btn = '';
				  $class = '';
				  }else{
				  $btn = '<button class="btn btn-danger remove_qualification_field" type="button"><i class="fa fa-minus"></i></button>';
				  //$class = 'certificationWrapperLeftMargin';
				  }
				  if($qual != ''){
				  echo '<div class="col-md-12 input_qualification_wrap middle-box"><div class="col-md-3 col-sm-12 col-xs-12 form-group">
				  <input type="text" name="qualification[]" class="form-control col-md-1" placeholder="Qualification" value="'.$qu->qualification.'"></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text"  name="university[]" class="form-control col-md-1" placeholder="University" value="'.$qu->university.'"></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" name="year[]" class="form-control col-md-1 year" placeholder="Year of Passing" value="'.$qu->year.'"  readonly></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><div class="input-group form-group"><input type="text" name="marks[]" class="form-control col-md-1" placeholder="Percentage" value="'.$qu->marks.'"><span class="input-group-addon">%</span></div></div>'.$btn.'</div>'; 
				  }
				  $i++;
				  }
				  }
				  else{
				  echo '<div class="col-md-3 col-sm-12 col-xs-12 form-group">	<input type="text" id="qualification" name="qualification[]" class="form-control col-md-1" placeholder="Qualification" value=""></div><div class="col-md-3 col-sm-12 col-xs-12 form-group">	<input type="text" id="university"  name="university[]" class="form-control col-md-1" placeholder="University" value=""></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" name="year[]" class="form-control col-md-1 year" placeholder="Year of Passing" value="" readonly="readonly"></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><div class="input-group form-group"><input type="number" id="marks" name="marks[]" class="form-control col-md-1" placeholder="%age" value=""><span class="input-group-addon">%</span></div><div class="input-group-append"><button class="btn btn-primary add_skill_button" type="button"><i class="fa fa-plus"></i></button></div></div>';
				  }
				  ?>
			   <div class="col-md-12 btn-row"><button class="btn btn-warning add_qualification_button" type="button">Add</button></div>
			</div>
		 </div>
	  </div>
	  <hr />
	  <div class="bottom-bdr"></div>
	  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
		 <h3 class="Material-head" style="margin-bottom: 30px;">
			Work Experience
			<hr />
		 </h3>
		 <div class=" panel-default">
			<div class="panel-body experience_wrapper">
			   <div class="col-sm-12  col-md-12 label-box mobile-view2">
				  <div class="col-md-2 col-sm-12 col-xs-12 form-group"> <label >Company Name</label></div>
				  <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Location</label></div>
				  <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Position</label></div>
				  <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Work Period</label></div>
				  <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;" >Responsibilities</label></div>
			   </div>
			   <?php if(!empty($user) && $user->experience_detail !='' && $user->experience_detail !='[""]'){
				  $expDetail = json_decode($user->experience_detail);
				  $j=0;												
				  foreach($expDetail as $ed){
				  if($j==0){
				  $expBtn = '';
				  $class = '';
				  }else{
				  $expBtn = '<button class="btn btn-danger remove_experience_field" type="button"><i class="fa fa-minus"></i></button>';
				  }
				  if($expDetail != ''){
				  echo '<div class="col-md-12 input_experience_wrap middle-box"><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="companyName[]" class="form-control col-md-1" placeholder="Company Name" value="'.$ed->companyName.'"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="companyLocation[]" class="form-control col-md-1" placeholder="Location" value="'.$ed->companyLocation.'"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="position[]" class="form-control col-md-1" placeholder="Position" value="'.$ed->position.'"></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><fieldset><div class="control-group"><div class="control-group"><div class="controls"><div class="input-prepend input-group"><span class="add-on input-group-addon">Work Period</span><input type="text"  name="work_period[]" class="form-control reservation" value="'.$ed->work_period.'" /></div></div></div></div></fieldset></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><textarea style="border-right:1px solid #c1c1c1 !important;" name="responsibility[]" class="form-control col-md-7 col-xs-12" placeholder="Responsibilities">'.$ed->responsibility.'</textarea></div>'.$expBtn.'</div>';
				  }
				  $j++;
				  }
				  }else{ 
				  echo '<div class="col-md-12 input_experience_wrap middle-box"><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" id="companyName" name="companyName[]" class="form-control col-md-1" placeholder="Company Name" value=""></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" id="companyLocation"   name="companyLocation[]" class="form-control col-md-1" placeholder="Location" value=""></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" id="position" name="position[]" class="form-control col-md-1" placeholder="Position" value=""></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><fieldset><div class="control-group"><div class="control-group"><div class="controls"><div class="input-prepend input-group"><span class="add-on input-group-addon">Work Period</span><input type="text"  name="work_period[]" class="form-control reservation" value="01/01/2016 - 01/25/2016" /></div></div></div></div></fieldset></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><textarea style="border-right:1px solid #c1c1c1 !important;" id="responsibility" name="responsibility[]" class="form-control col-md-7 col-xs-12" placeholder="Responsibilities"></textarea></div><button class="btn btn-warning add_experience_button" type="button"><i class="fa fa-plus"></i></button></div>';
				  } ?>
			   <div class="col-md-12 btn-row"><button class="btn btn-warning add_experience_button" type="button">Add</button> </div>
			</div>
		 </div>
	  </div>
	  <hr />
	  <div class="bottom-bdr"></div>
	  <div class="col-md-6 col-sm-12 col-xs-12 form-group">
		 <input type="hidden" name="id" value="<?php if(!empty($user)) echo $user->id; ?>">										
		 <input type="hidden" name="u_id" value="<?php if(!empty($user)) echo $user->u_id; ?>">										
		 <input type="hidden" name="c_id" value="<?php if(!empty($user)) echo $user->c_id; else echo $this->companyGroupId;?>">
		 <div class=" panel-default">
			<h3 class="Material-head" style="margin-bottom: 30px;">
			   Social Links
			   <hr>
			</h3>
			<div class="panel-body  vertical-border">
			   <div class="item form-group">
				  <label class="col-md-3 col-sm-3 col-xs-12" for="name">Facebook</label>
				  <div class="col-md-6 col-sm-6 col-xs-12">												
					 <input type="url" id="facebook" class="form-control col-md-7 col-xs-12 optional" name="facebook" placeholder=""  value="<?php if(!empty($user)) echo $user->facebook;?>" >
				  </div>
			   </div>
			   <div class="item form-group">
				  <label class="col-md-3 col-sm-3 col-xs-12" for="email">Twitter</label>
				  <div class="col-md-6 col-sm-6 col-xs-12">												
					 <input type="url" id="twitter" name="twitter" class="form-control col-md-7 col-xs-12 optional" placeholder=""  value="<?php  if(!empty($user))  echo $user->twitter; ?>">
				  </div>
			   </div>
			   <div class="item form-group">
				  <label class="col-md-3 col-sm-3 col-xs-12" for="phone">Instagram</label>
				  <div class="col-md-6 col-sm-6 col-xs-12">														
					 <input type="url" id="instagram" name="instagram"  class="form-control col-md-7 col-xs-12 optional" placeholder="" value="<?php if(!empty($user))  echo $user->instagram; ?>">
				  </div>
			   </div>
			   <div class="item form-group">
				  <label class="col-md-3 col-sm-3 col-xs-12" for="age">Linkedin</label>
				  <div class="col-md-6 col-sm-6 col-xs-12">														
					 <input type="url" id="linkedin" name="linkedin" class="form-control col-md-7 col-xs-12 optional" value="<?php if(!empty($user)) echo $user->linkedin; ?>" placeholder="">
				  </div>
			   </div>
			</div>
		 </div>
	  </div>
	  <div class="col-md-6 col-sm-12 col-xs-12 form-group">
		 <div class="panel-default">
			<h3 class="Material-head" style="margin-bottom: 30px;">
			   Skills
			   <hr>
			</h3>
			<div class="panel-body skill_wrapper ">
			   <?php if(!empty($user) && $user->skill !='' && $user->skill !='[""]'){
				  $skills = json_decode($user->skill);
				  $i=0;												
				  foreach($skills as $skill){
				  if($i==0){
				  $btn = '<button class="btn btn-warning add_skill_button" type="button"><i class="fa fa-plus"></i></button>';
				  $class = '';
				  }else{
				  $btn = '<button class="btn btn-danger remove_skill_field" type="button"><i class="fa fa-minus"></i></button>';
				  $class = 'certificationWrapperLeftMargin';
				  }
				  if($skill != ''){
				  echo '<div class="col-md-12 input_skill_wrap vertical-border"><label class="col-md-3 col-sm-3 col-xs-12" for="name">Name</label><div class="col-md-5 col-sm-8 col-xs-12 "><input type="text"  name="skill_name[]" class="form-control col-md-1" placeholder="Name" value="'.$skill->skill_name.'"></div><div class="col-md-3 col-sm-12 col-xs-12 "><input type="number"  name="skill_count[]" class="form-control col-md-1" placeholder="Count" value="'.$skill->skill_count.'"></div>'.$btn.'</div>'; 
				  }
				  $i++;
				  }
				  }
				  else{
				  echo '<div class="col-md-12 input_skill_wrap vertical-border"><label class="col-md-3 col-sm-3 col-xs-12" for="name">Name</label><div class="col-md-5 col-sm-8 col-xs-12 "><input type="text" name="skill_name[]" class="form-control col-md-1" placeholder="Name" value=""></div><div class="col-md-3 col-sm-12 col-xs-12 "><input type="number" name="skill_count[]" class="form-control col-md-1" placeholder="Count" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><div class="input-group-append"><button class="btn btn-primary add_skill_button" type="button"><i class="fa fa-plus"></i></button></div></div></div>';
				  }
				  ?>
			</div>
		 </div>
	  </div>
   </div>
</div>
<div class="modal-footer">
   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   <button type="reset" class="btn btn-default">Reset</button>
   <?php if(!empty($user) && $user->save_status !=1){
	  echo '<input type="submit" class="btn btn-warning add_users_dataaa draftBtn" value="Save as draft">'; 
	  }?> 
   <input type="submit" class="btn btn-warning" value="Save"> 
</div>
</form>
