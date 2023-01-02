<div class="x_content">
<?php // pre($user); ?>
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>						
	<?php if(!empty($user) ){ 	
		if(!empty($user->address1)){
		$permanentAddress = json_decode($user->address1);
		}
	if(!empty($user->address2)){
		$correspondanceAddress = json_decode($user->address2);
	}
	?>		
	<!-- ------------------------------------ User Profile View -------------------------------------------- -->

	
	<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
	  <div class="profile_img">
		<div id="crop-avatar">
		  <!-- Current avatar -->		 
		  <?php 
			if($user->user_profile != ''){
				$userImage = $user->user_profile;
			}else{
				$userImage = ($user->user_profile == '' && $user->gender =='Female')?'female_image_placeholder.jpg':'dummy.jpg';
			}
			?>
		
		<?php /*  <img class="img-responsive avatar-view" src="<?php echo base_url('assets/modules/users/uploads').'/'.(isset($user->user_profile) && $user->user_profile != '' ?$user->user_profile:"dummy.jpg");?>" alt="Avatar" title="Change the avatar" height="186px" width="186px">*/ ?>
		   <img class="img-responsive avatar-view" src="<?php echo base_url('assets/modules/users/uploads').'/'.$userImage;?>" alt="Avatar" title="Change the avatar" height="186px" width="186px">
		   <button type="button" class="btn btn-warning" id="upload_user_profile_image"><i class="fa fa-pencil-square-o"></i></button>
		  
		</div>
	  </div>
	  <h3><?php if(!empty($user)) echo $user->name; ?></h3>

	  <ul class="list-unstyled user_data">
		<li class="m-top-xs">
			<i class="fa fa-phone user-profile-icon"></i><?php if(!empty($user)) echo $user->contact_no; ?>
		</li>
		<li>
			<i class="fa fa-briefcase user-profile-icon"></i> <?php if(!empty($user)) echo $user->designation; ?>
		</li>
		<li>
			<i class="fa fa-envelope user-profile-icon"></i> <?php if(!empty($user)) echo $user->email; ?>
		</li>
	  </ul>
		
		<?php 
		//$disable = ($user->role != 1 && $_SESSION['loggedInUser']->id != $user->id)?'disabled':'';
		//$disable = ($user->role!=1 && $_SESSION['loggedInUser']->role == 1) ?'':'disabled';
		
		
		$disable = ($_SESSION['loggedInUser']->role == 1) ?'':($user->role !=1 && $_SESSION['loggedInUser']->id == $user->id?'':'disabled');
		
		
		//$disableClass = ($user->role != 1 && $_SESSION['loggedInUser']->id != $user->id)?'disableBtnClick':'';
		//$disableClass = ($user->role!=1 && $_SESSION['loggedInUser']->role == 1)?'':'disableBtnClick';
		$disableClass =  ($_SESSION['loggedInUser']->role == 1) ?'':($user->role !=1 && $_SESSION['loggedInUser']->id == $user->id?'':'disableBtnClick');
		echo '<button type="button" class="btn btn-warning  '.$disableClass.'" data-toggle="modal" data-target=".bs-example-modal-lg" '.$disable.'>Edit Profile</button><button type="button" class="btn btn-warning text-center  '.$disableClass.'" data-toggle="modal" data-target=".changePassword" '.$disable.'>Change Password</button>';
		?>
		 
		<div class="modal fade changePassword" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel">Change Password</h4>
					</div>
					<div class="modal-body">
						<form method="post"  class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>users/changePassword">										
						<input type="hidden" name="id" value="<?php if(!empty($user)) echo $user->id; ?>">
						<div class="item form-group">												
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Old Password<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">												
								<input class="form-control col-md-7 col-xs-12" data-validate-length-range="6"  name="old_password" placeholder="Enter the last password you remebered" required="required" type="password" value="">
							</div>											
						</div>											
						<div class="item form-group">												
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">New Password<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">												
								<input type="password" id="new_password" name="password" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter new Password" value="">
							</div>											
						</div>	
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="reset" class="btn btn-default">Reset</button>														
						<input type="submit" class="btn btn-warning" value="Save">	
					</div>
			</form>
				</div>
			</div>
		</div>
		 <?php if($user->role!=1 && $_SESSION['loggedInUser']->role == 1 ) { ?>
		<button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bs-example-modal-lg-permissions">Permissions</button>
		  <?php } ?>
	  <br />

	  <!-- start skills -->
	  <h4>Skills</h4>
	  <ul class="list-unstyled user_data">
	  <?php if(!empty($user) && $user->skill !=''){
				$skills = json_decode($user->skill);
				foreach($skills as $skill){
	  ?>
		<li>
		  <p><?php echo $skill->skill_name; ?></p>
		  <div class="progress progress_sm">
			<div class="progress-bar bg-orange" role="progressbar" data-transitiongoal="<?php echo $skill->skill_count; ?>"></div>
		  </div>
		</li>
		
		<?php } } else{ echo '<li>Skills Not Added</li>';}?>
				
	 </ul>
	<!-- end of skills -->
	<!-- Socila Profile -->
			<?php if(!empty($user)){ 
					if($user->facebook!='') echo '<a href="'.$user->facebook.'" target="_blank"><button type="button" class="btn btn-primary"><i class="fa fa-facebook"></i></button></a>';
					if($user->twitter!='') echo '<a href="'.$user->twitter.'" target="_blank"><button type="button" class="btn btn-info"><i class="fa fa-twitter"></i></button></a>';
					if($user->instagram!='') echo '<a href="'.$user->instagram.'" target="_blank"><button type="button" class="btn btn-danger"><i class="fa fa-instagram"></i></button></a>';
					if($user->linkedin!='') echo '<a href="'.$user->linkedin.'" target="_blank"><button type="button" class="btn btn-primary"><i class="fa fa-linkedin"></i></button></a>';
				} ?>
	</div>
	<div class="col-md-9 col-sm-9 col-xs-12">

	  <div class="profile_title">
		<div class="col-md-6">
		  <h2>User Activity Report</h2>
		</div>		
	  </div>
	  <!-- start of user-activity-graph -->
	  <div id="user_activity_graph_bar" style="width:100%; height:280px;"></div>
	  <!-- end of user-activity-graph -->

	  <div class="" role="tabpanel" data-example-id="togglable-tabs">
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
		  <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Recent Activity</a>
		  </li>
		  
		  <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Profile</a>
		  </li>
		</ul>
		<div id="myTabContent" class="tab-content">
		  <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

			<!-- start recent activity -->
			
			<ul class="messages" id="load_data"></ul>
			<div id="load_data_message"></div>
			
			<!-- end recent activity -->

		  </div>
	
		  <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
			<!-- <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui
			  photo booth letterpress, commodo enim craft beer mlkshk </p> -->
				<div class="col-md-6 col-sm-12 col-xs-12 form-group">
					<div class="panel panel-default">
						<div class="panel-heading"><h3 class="panel-title"><strong>About </strong></h3></div>
						<div class="panel-body">
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<div class="item form-group">													
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth</label>														
									<div class="col-md-6 col-sm-6 col-xs-12">														
										<p><?php if(!empty($user)) echo $user->age; ?></p>													
									</div>												
								</div>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<div class="item form-group">													
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Experience</label>														
									<div class="col-md-6 col-sm-6 col-xs-12">														
										<p><?php if(!empty($user)) echo $user->experience; ?>&nbsp;Years</p>													
									</div>												
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 form-group">
					<div class="panel panel-default">
						<div class="panel-heading"><h3 class="panel-title"><strong>Preference </strong></h3></div>
						<div class="panel-body">
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<div class="item form-group">													
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Designation</label>														
									<div class="col-md-6 col-sm-6 col-xs-12">														
										<p><?php if(!empty($user)) echo $user->designation; ?></p>													
									</div>												
								</div>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<div class="item form-group">													
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Joining</label>														
									<div class="col-md-6 col-sm-6 col-xs-12">														
										<p><?php if(!empty($user)) echo $user->date_joining; ?></p>													
									</div>												
								</div>
							</div>
						</div>
					</div>
				</div>
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">				
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title"><strong>Address </strong></h3></div>
					<div class="panel-body">
						<div class="col-md-6 col-sm-12 col-xs-12 form-group">
							<div class="item form-group">													
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Permanent Address<span class="required">*</span></label>
								<div class="col-md-9 col-sm-6 col-xs-12">														
									<p><?php if(!empty($user) && $user->address1 != '' && !empty($permanentAddress)) {
										
										
										echo $permanentAddress->address . '</br>';
										echo $permanentAddress->postal_zipcode . '</br>';
										if($permanentAddress->city != ''){
											echo getNameById('city',$permanentAddress->city,'city_id')->city_name . '</br>';
										}
										if($permanentAddress->state != ''){
											echo getNameById('state',$permanentAddress->state,'state_id')->state_name . '</br>';
										}
										if($permanentAddress->country != ''){
											echo getNameById('country',$permanentAddress->country,'country_id')->country_name . '</br>';
										}
									}
									//echo $permanentAdd.' , '.$permanentCity.' , '.$permanentState.' , '.$permanentCountry.' ,Zipcode / Postal Code: '.$permanentZipcode;
									?></p>													
								</div>												
							</div>
						</div>	
						<div class="col-md-6 col-sm-12 col-xs-12 form-group">
							<div class="item form-group">													
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address2">Correspondence Address</label>
								<div class="col-md-9 col-sm-6 col-xs-12">														
									<p><?php 
									if(!empty($user) && $user->address2 != '' && !empty($correspondanceAddress)) {
										echo $correspondanceAddress->address . '</br>';
										echo $correspondanceAddress->postal_zipcode . '</br>';
										if($correspondanceAddress->city != ''){
											echo getNameById('city',$correspondanceAddress->city,'city_id')->city_name . '</br>';
										}
										if($correspondanceAddress->state != ''){
											echo getNameById('state',$correspondanceAddress->state,'state_id')->state_name . '</br>';
										}
										if($correspondanceAddress->country != ''){
											echo getNameById('country',$correspondanceAddress->country,'country_id')->country_name . '</br>';
										}
									}
									//if(!empty($user)  && $user->address2 != '') echo $correspondanceAdd.' , '.$correspondanceCity.' , '.$correspondanceState.' , '.$correspondanceCountry.' ,Zipcode / Postal Code: '.$correspondanceZipcode; 
									
									?></p>
								</div>												
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			
		
		
		
							
			
			
			
			
			
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title"><strong>Qualification </strong></h3></div>
					<div class="panel-body">
						<div class="item form-group">													
							<div class="col-md-12 col-sm-6 col-xs-12">														
								<?php 
								
								if(!empty($user) && $user->qualification !=''){
												$qual = json_decode($user->qualification);
							
								
								if(!empty($qual)){ ?>
								<div class="x_content">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>S.No</th>
												<th>Qualification</th>
												<th>University</th>
												<th>Year</th>
												<th>marks</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$i =1;
												foreach($qual as $qu){
													if($qu->qualification !='' && $qu->university!='' && $qu->year !='' && $qu->marks!=''){
											?>					  
												<tr>
													<th scope="row"><?php echo $i; ?></th>
													<td><?php if(!empty($user)){ echo $qu->qualification;} ?></td>
													<td><?php if(!empty($user)){ echo $qu->university;} ?></td>
													<td><?php if(!empty($user)){ echo $qu->year;} ?></td>
													<td><?php if(!empty($user)){ echo $qu->marks;} ?>%</td>
												</tr>
											<?php $i++; }}?>									
										</tbody>
									</table>
								</div>
							<?php }
								}	?>
							</div>												
						</div>
					</div>
				</div>
			</div>  
			
			
			
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title"><strong> Work Experience </strong></h3></div>
					<div class="panel-body">
						<div class="item form-group">													
							<div class="col-md-12 col-sm-6 col-xs-12">														
								<?php 
								
								if(!empty($user) && $user->experience_detail !=''){
												$expDetail = json_decode($user->experience_detail);
							
								
								if(!empty($expDetail)){ ?>
								<div class="x_content">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>S.No</th>
												<th>Company Name</th>
												<th>Location</th>
												<th>Position</th>
												<th>Work Period</th>
												<th>Responsibility</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$j =1;
												foreach($expDetail as $ed){
													if($ed->companyName !='' && $ed->companyLocation !='' && $ed->position !='' && $ed->work_period !='' && $ed->responsibility!=''){
											?>					  
												<tr>
													<th scope="row"><?php echo $j; ?></th>
													<td><?php if(!empty($user)){ echo $ed->companyName;} ?></td>
													<td><?php if(!empty($user)){ echo $ed->companyLocation;} ?></td>
													<td><?php if(!empty($user)){ echo $ed->position;} ?></td>
													<td><?php if(!empty($user)){ echo $ed->work_period;} ?></td>
													<td><?php if(!empty($user)){ echo $ed->responsibility;} ?></td>
												</tr>
											<?php $j++; } }?>									
										</tbody>
									</table>
								</div>
							<?php }
								}	?>
							</div>												
						</div>
					</div>
				</div>
			</div> 
			
			
			
			
			
			
		</div>
		</div>
	  </div>
	</div>
	
	
	<!-- ------------------------------------------------ Edit Profile Modal -------------------------------------- -->
	<div class="modal fade bs-example-modal-lg" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-large">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Edit Profile</h4>
					<div class="project_progress">
						<div class="progress progress_sm">
							<div class="progress-bar bg-orange" role="progressbar" data-transitiongoal="<?php echo $profileComplete; ?>"></div>
						</div>
						<small>Profile <?php echo $profileComplete . ' % '; ?> Complete</small>
					</div>
				</div>
				<div class="modal-body">
					<div class="row">	
						<?php if($user->role!=1 && $_SESSION['loggedInUser']->role == 1 ) { ?>
						<?php }?>
						<form method="post" id="editUserForm" class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>users/save">
						<div class="col-md-6 col-sm-12 col-xs-12 form-group">
							<input type="hidden" name="id" value="<?php if(!empty($user)) echo $user->id; ?>">										
							<input type="hidden" name="u_id" value="<?php if(!empty($user)) echo $user->u_id; ?>">										
							<input type="hidden" name="c_id" value="<?php if(!empty($user)) echo $user->c_id; else echo $_SESSION['loggedInUser']->c_id;?>">
							<input type="hidden" name="save_status" value="1" class="save_status">							
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><strong>General </strong></h3></div>
								<div class="panel-body">
									<div class="item form-group">												
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">User Name<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6 col-xs-12">												
											<input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"  name="name" placeholder="both name(s) e.g Jon Doe" required="required" type="text" value="<?php if(!empty($user)) echo $user->name;?>">
										</div>											
									</div>											
									<div class="item form-group">												
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email<span class="required">*</span></label>
										  <div class="col-md-6 col-sm-6 col-xs-12">												
											<input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter email" <?php  if(!empty($user))  echo 'readonly'; ?> value="<?php  if(!empty($user))  echo $user->email; ?>">
										  </div>											
									</div>
									<div class="item form-group">		
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="gender">Gender <span class="required">*</span></label>
										<div class="col-md-6 col-sm-6 col-xs-12">	
											Male: <input type="radio" class="flat" name="gender" id="genderM" value="Male" <?php if(!empty($user) && $user->gender == 'Male')  echo 'checked'; ?> required /> 
											Female: <input type="radio" class="flat" name="gender" id="genderF" value="Female"  <?php if(!empty($user) && $user->gender == 'Female')  echo 'checked'; ?>/>										
										</div>
									  </div>
									<div class="item form-group">													
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone <span class="required">*</span> </label>
										<div class="col-md-6 col-sm-6 col-xs-12">														
											<input type="tel" id="phone" name="contact_no" required="required" data-validate-length-range="8,10" class="form-control col-md-7 col-xs-12" placeholder="Enter mobile number" value="<?php if(!empty($user))  echo $user->contact_no; ?>">
										</div>												
									</div>
									<div class="item form-group">													
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="age">Date of Birth<span class="required">*</span>	</label>
										<div class="col-md-6 col-sm-6 col-xs-12">														
											<input type="text" id="date" required="required" name="age" class="form-control col-md-7 col-xs-12 has-feedback-left" data-validation="date" value="<?php if(!empty($user)) echo $user->age; ?>" placeholder="Date Of Birth" aria-describedby="inputSuccess2Status4">
											<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
										</div>												
									</div>									
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12 form-group">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><strong>Profile </strong></h3></div>
								<div class="panel-body">
									<div class="item form-group">												
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="designation">Designation<span class="required">* </span></label>
										<div class="col-md-6 col-sm-6 col-xs-12">												
											<input type="text" id="designation" name="designation" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter designation" value="<?php if(!empty($user))  echo $user->designation; ?>">												
										</div>											
									</div>
									<div class="item form-group">													
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="experience">Experience</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="input-group">
												<input type="number" id="experience" name="experience" class="form-control col-md-7 col-xs-12" placeholder="Experience (in Years)" value="<?php  if(!empty($user)) echo $user->experience; ?>">	
												<span class="input-group-addon">Years</span>
											</div>
										</div>												
									</div>
									<div class="item form-group">													
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="joining">Date Of Joining<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6 col-xs-12">	
											<input type="text" id="date_join" required="required" name="date_joining" class="form-control col-md-7 col-xs-12 has-feedback-left" data-validation="date" value="<?php  if(!empty($user)) echo $user->date_joining; ?>" placeholder="Date Of Joining" aria-describedby="inputSuccess2Status4">
											<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
										</div>												
									</div>
									<?php /*<div class="item form-group">													
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="experience">Profile Pic</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											
											<input type="hidden" name="fileOldlogo" value="<?php echo isset($user->user_profile)?$user->user_profile: "";?>">											
											<div id="profile-holder" class="col-md-5">												
												<img src="<?php echo base_url('assets/modules/users/uploads').'/'.(isset($user->user_profile) && $user->user_profile != '' ?$user->user_profile:"user.png");?>" class="img-responsive">
											</div>										 													 
										</div>												
									</div> */?>
									
									
									<?php /*<div class="container">									
										<div class="panel panel-default">
											<div class="panel-heading">Select Profile Image</div>
												<div class="panel-body" align="center">
												<input type="file" name="user_profile" id="user_profileaaa" accept="image/*" />
												<input type="hidden" name="changed_user_profile" id="changed_user_profile" value=""/>
												<input type="hidden" name="fileOldlogo" value="<?php echo isset($user->user_profile)?$user->user_profile: "";?>">	
												<br />
												<div id="uploaded_image">
													<img src="<?php echo base_url('assets/modules/users/uploads').'/'.(isset($user->user_profile) && $user->user_profile != '' ?$user->user_profile:"user.png");?>" class="img-responsive">
												</div>
												</div>
										</div>
									</div> */?>
									
									
								</div>
							</div>
						</div>
					
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><strong>Permanent Address</strong></h3></div>
								<div class="panel-body address_wrapper">
										<div class="item form-group">
											<div class="col-md-12 input_permanent_address_wrap" id="chkIndex_0">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
													<textarea   name="permanent_address" class="form-control col-md-7 col-xs-12" placeholder="Address"><?php if(!empty($user) && !empty($permanentAddress)) echo $permanentAddress->address; ?></textarea>
												</div>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<div class="col-md-2 col-sm-12 col-xs-12 form-group">
														<input type="number" id="postal_zipcode" name="permanent_postal_zipcode" class="form-control col-md-1" placeholder="Postal/Zipcode" value="<?php if(!empty($user) && !empty($permanentAddress)) echo $permanentAddress->postal_zipcode; ?>">
													</div>
													<div class="item form-group col-md-3 col-sm-3 col-xs-12">
														<label class="control-label col-md-4 col-sm-4 col-xs-4" for="billing_country">Permanent Country</label>
														<div class="col-md-8 col-sm-8 col-xs-8">
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
													<div class="item form-group col-md-3 col-sm-3 col-xs-12">
														<label class="control-label col-md-4 col-sm-4 col-xs-4" for="permanent_state">Permanent State/Province</label>
														<div class="col-md-8 col-sm-8 col-xs-8">								
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
													<div class="item form-group col-md-3 col-sm-3 col-xs-12">
														<label class="control-label col-md-4 col-sm-4 col-xs-4" for="city">Permanent City</label>
														<div class="col-md-8 col-sm-8 col-xs-8">										
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
							
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><strong>Correspondance Address</strong></h3></div>
								<div class="panel-body address_wrapper">
								
										 
										 
										<div class="item form-group">
											<div class="col-md-12 input_correspondance_address_wrap" id="chkIndex_0">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
													<textarea  name="correspondance_address" class="form-control col-md-7 col-xs-12" placeholder="Address"><?php if(!empty($user) && !empty($correspondanceAddress)) echo $correspondanceAddress->address;?></textarea>
												</div>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<div class="col-md-2 col-sm-12 col-xs-12 form-group">
														<input type="number" name="correspondance_postal_zipcode" class="form-control col-md-1" placeholder="Postal/Zipcode" value="<?php if(!empty($user) && !empty($correspondanceAddress)) echo $correspondanceAddress->postal_zipcode;?>">
													</div>
														<div class="item form-group col-md-3 col-sm-3 col-xs-12">
														<label class="control-label col-md-4 col-sm-4 col-xs-4" for="billing_country">Correspondance Country</label>
														<div class="col-md-8 col-sm-8 col-xs-8">
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
												
												<div class="item form-group col-md-3 col-sm-3 col-xs-12">
													<label class="control-label col-md-4 col-sm-4 col-xs-4" for="correspondance_state">Correspondance State/Province</label>
													<div class="col-md-8 col-sm-8 col-xs-8">								
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
												
												<div class="item form-group col-md-3 col-sm-3 col-xs-12">
													<label class="control-label col-md-4 col-sm-4 col-xs-4" for="city">Correspondance City</label>
													<div class="col-md-8 col-sm-8 col-xs-8">										
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
						
							
						
						
						
						
						
						
						
						
						
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><strong>Qualification </strong></h3></div>
								
								
								
								
								
									<div class="panel-body quaification_wrapper">
								
								<?php if(!empty($user) && $user->qualification !='' && $user->qualification !='[""]'){
													$qual = json_decode($user->qualification);
													$i=0;												
													foreach($qual as $qu){
													if($i==0){
														$btn = '<button class="btn btn-warning add_qualification_button" type="button"><i class="fa fa-plus"></i></button>';
														$class = '';
													}else{
														$btn = '<button class="btn btn-danger remove_qualification_field" type="button"><i class="fa fa-minus"></i></button>';
														//$class = 'certificationWrapperLeftMargin';
													}
														if($qual != ''){
															echo '<div class="col-md-10 input_qualification_wrap"><div class="col-md-3 col-sm-12 col-xs-12 form-group">
														<input type="text" name="qualification[]" class="form-control col-md-1" placeholder="Qualification" value="'.$qu->qualification.'"></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text"  name="university[]" class="form-control col-md-1" placeholder="University" value="'.$qu->university.'"></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" name="year[]" class="form-control col-md-1 year" placeholder="Year of Passing" value="'.$qu->year.'"  readonly></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><div class="input-group"><input type="text" name="marks[]" class="form-control col-md-1" placeholder="Percentage" value="'.$qu->marks.'"><span class="input-group-addon">%</span></div></div>'.$btn.'</div>'; 
														}
														$i++;
													}
												}
												else{
													echo '<div class="col-md-3 col-sm-12 col-xs-12 form-group">	<input type="text" id="qualification" name="qualification[]" class="form-control col-md-1" placeholder="Qualification" value=""></div><div class="col-md-3 col-sm-12 col-xs-12 form-group">	<input type="text" id="university"  name="university[]" class="form-control col-md-1" placeholder="University" value=""></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" name="year[]" class="form-control col-md-1 year" placeholder="Year of Passing" value="" readonly="readonly"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><div class="input-group"><input type="number" id="marks" name="marks[]" class="form-control col-md-1" placeholder="%age" value=""><span class="input-group-addon">%</span></div></div><div class="input-group-append"><button class="btn btn-primary add_skill_button" type="button"><i class="fa fa-plus"></i></button></div></div></div>';
												}
												?>										
								</div>
							</div>
						</div>
						<?php } ?>	
						
						
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><strong>Work Experience</strong></h3></div>
								<div class="panel-body experience_wrapper">
								<?php if(!empty($user) && $user->experience_detail !='' && $user->experience_detail !='[""]'){
													$expDetail = json_decode($user->experience_detail);
													$j=0;												
													foreach($expDetail as $ed){
													if($j==0){
														$expBtn = '<button class="btn btn-warning add_experience_button" type="button"><i class="fa fa-plus"></i></button>';
														$class = '';
													}else{
														$expBtn = '<button class="btn btn-danger remove_experience_field" type="button"><i class="fa fa-minus"></i></button>';
														//$class = 'certificationWrapperLeftMargin';
													}
														if($expDetail != ''){
															echo '<div class="item form-group"><div class="col-md-12 input_experience_wrap"><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="companyName[]" class="form-control col-md-1" placeholder="Company Name" value="'.$ed->companyName.'"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="companyLocation[]" class="form-control col-md-1" placeholder="Location" value="'.$ed->companyLocation.'"></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><input type="text" name="position[]" class="form-control col-md-1" placeholder="Position" value="'.$ed->position.'"></div><div class="col-md-3 col-sm-12 col-xs-12"><fieldset><div class="control-group"><div class="control-group"><div class="controls"><div class="input-prepend input-group"><span class="add-on input-group-addon">Work Period</span><input type="text" style="width: 200px" name="work_period[]" class="form-control reservation" value="'.$ed->work_period.'" /></div></div></div></div></fieldset></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><textarea  name="responsibility[]" class="form-control col-md-7 col-xs-12" placeholder="Responsibilities">'.$ed->responsibility.'</textarea></div>'.$expBtn.'</div></div>';
															}
															$j++;
														}
														}else{ 
															echo '<div class="item form-group"><div class="col-md-12 input_experience_wrap"><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" id="companyName" name="companyName[]" class="form-control col-md-1" placeholder="Company Name" value=""></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" id="companyLocation"   name="companyLocation[]" class="form-control col-md-1" placeholder="Location" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><input type="text" id="position" name="position[]" class="form-control col-md-1" placeholder="Position" value=""></div><div class="col-md-3 col-sm-12 col-xs-12"><fieldset><div class="control-group"><div class="control-group"><div class="controls"><div class="input-prepend input-group"><span class="add-on input-group-addon">Work Period</span><input type="text" style="width: 200px" name="work_period[]" class="form-control reservation" value="01/01/2016 - 01/25/2016" /></div></div></div></div></fieldset></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><textarea id="responsibility" name="responsibility[]" class="form-control col-md-7 col-xs-12" placeholder="Responsibilities"></textarea></div><button class="btn btn-warning add_experience_button" type="button"><i class="fa fa-plus"></i></button></div></div>';
														} ?>
														</div>
													</div>
											</div>
						
						
						

						<div class="col-md-6 col-sm-12 col-xs-12 form-group">
							<input type="hidden" name="id" value="<?php if(!empty($user)) echo $user->id; ?>">										
							<input type="hidden" name="u_id" value="<?php if(!empty($user)) echo $user->u_id; ?>">										
							<input type="hidden" name="c_id" value="<?php if(!empty($user)) echo $user->c_id; else echo $_SESSION['loggedInUser']->c_id;?>">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><strong>Social Links </strong></h3></div>
								<div class="panel-body">
									<div class="item form-group">												
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Facebook</label>
										<div class="col-md-6 col-sm-6 col-xs-12">												
											<input type="url" id="facebook" class="form-control col-md-7 col-xs-12 optional" name="facebook" placeholder=""  value="<?php if(!empty($user)) echo $user->facebook;?>" >
										</div>											
									</div>											
									<div class="item form-group">												
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Twitter</label>
										  <div class="col-md-6 col-sm-6 col-xs-12">												
											<input type="url" id="twitter" name="twitter" class="form-control col-md-7 col-xs-12 optional" placeholder=""  value="<?php  if(!empty($user))  echo $user->twitter; ?>">
										  </div>											
									</div>
									<div class="item form-group">													
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Instagram</label>
										<div class="col-md-6 col-sm-6 col-xs-12">														
											<input type="url" id="instagram" name="instagram"  class="form-control col-md-7 col-xs-12 optional" placeholder="" value="<?php if(!empty($user))  echo $user->instagram; ?>">
										</div>												
									</div>
									<div class="item form-group">													
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="age">Linkedin</label>
										<div class="col-md-6 col-sm-6 col-xs-12">														
											<input type="url" id="linkedin" name="linkedin" class="form-control col-md-7 col-xs-12 optional" value="<?php if(!empty($user)) echo $user->linkedin; ?>" placeholder="">
											
										</div>												
									</div>									
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12 form-group">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><strong>Skills </strong></h3></div>
								<div class="panel-body skill_wrapper">
								
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
															echo '<div class="col-md-12 input_skill_wrap"><div class="col-md-8 col-sm-8 col-xs-12 form-group"><input type="text"  name="skill_name[]" class="form-control col-md-1" placeholder="Name" value="'.$skill->skill_name.'"></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="number"  name="skill_count[]" class="form-control col-md-1" placeholder="Count" value="'.$skill->skill_count.'"></div>'.$btn.'</div>'; 
														}
														$i++;
													}
												}
												else{
													echo '<div class="col-md-12 input_skill_wrap"><div class="col-md-8 col-sm-8 col-xs-12 form-group"><input type="text" name="skill_name[]" class="form-control col-md-1" placeholder="Name" value=""></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="number" name="skill_count[]" class="form-control col-md-1" placeholder="Count" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><div class="input-group-append"><button class="btn btn-primary add_skill_button" type="button"><i class="fa fa-plus"></i></button></div></div></div>';
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
						</form>
				</div>									
			</div>									
		</div>									
	</div>
	
	
	<!-- ------------------------------------------------- Permissions Modal -------------------------------------------- -->
	<div class="modal fade bs-example-modal-lg-permissions" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-large">
			<div class="modal-content">
			<form action="<?php echo base_url();?>users/save_permission" method="post" enctype="multipart/form-data" id="permissionForm">
							<input type="hidden" name="id" value="<?php if(!empty($user)) echo $user->id; ?>">			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Give Permissions</h4>
				</div>
				<div class="modal-body">
				<div class="tbl-header">
				<table class="table table-striped jambo_table bulk_action">											
					<thead>											
						<tr>											
							<th> Modules </th>											
							<th>Is_All</th>											
							<th>Is_Create</th>											
							<th>Is_Edit</th>											
							<th>Is_Delete</th>											
							<th>Is_View</th>
							<th>Is_Validate</th>									
						</tr>											
					</thead>											
					<tbody>
					</tbody>
				</table>
				</div>
					<!-- start accordion -->
					<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
					<?php if(!empty($permissionsArray)){
						$i = 0;
							foreach($permissionsArray as $pa){?>
								<div class="panel">
									<a class="panel-heading" role="tab" id="<?php echo $pa['id']; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $pa['id']; ?>" aria-expanded="true" aria-controls="collapseOne">
									  <h4 class="panel-title"><?php echo $pa['module_name']; ?></h4>
									</a>
									<div id="collapse_<?php echo $pa['id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php echo $pa['id']; ?>">
										<div class="panel-body">
												<table class="table table-striped jambo_table bulk_action" >																			
													<tbody>
													<?php if(!empty($pa['sub_module'])) {
															foreach($pa['sub_module'] as $pasm){
															?>													
																<tr>													  
																	<td width="15%"><strong><i><?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_name; ?></i></strong></td>
																	<td><input type="checkbox" class="all permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_all" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_all == 1) { echo 'checked';} ?>></td>
																	<td><input type="checkbox" class="add permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_add" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_add == 1) { echo 'checked';} ?>></td>
																	<td><input  type="checkbox" class="edit permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_edit" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_edit == 1) { echo 'checked';} ?> > </td>
																	<td><input type="checkbox" class="delete permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_delete" value="1"<?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_delete == 1) { echo 'checked';} ?>></td>
																	<td><input type="checkbox" class="view permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_view" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_view == 1) { echo 'checked';} ?>></td>
																	<td><input type="checkbox" class="validate permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_validate" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_validate == 1) { echo 'checked';} ?>></td>
																</tr>	
														<?php }} ?>														
													</tbody>										
												</table>
										</div>
									</div>
								</div>
						
						<?php $i++; }}?>	
					<!-- end of accordion -->
				</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="submit" value="save" class="btn btn-warning">	
				</div>	
				</form>
			</div>
		</div>
	</div>	
</div>

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
							<input type="file" name="user_profile" id="user_profile" accept="image/*" />
							<input type="hidden" name="changed_user_profile" id="changed_user_profile" value=""/>
							<input type="hidden" name="fileOldlogo" value="<?php echo isset($user->user_profile)?$user->user_profile: "";?>">	
							<br />
							<div id="uploaded_image">								
							</div>
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















