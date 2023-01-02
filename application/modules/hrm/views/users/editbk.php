<div class="x_content">
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
   <!--------- User Profile View ---------->
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
            <img class="img-responsive avatar-view" src="<?php echo base_url('assets/modules/hrm/uploads').'/'.$userImage;?>" alt="Avatar" title="Change the avatar" height="186px" width="186px">
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
         $disable = ($_SESSION['loggedInUser']->role == 1) ?'':($user->role !=1 && $_SESSION['loggedInUser']->id == $user->id?'':'disabled');
         $disableClass =  ($_SESSION['loggedInUser']->role == 1) ?'':($user->role !=1 && $_SESSION['loggedInUser']->id == $user->id?'':'disableBtnClick');
         echo '<button type="button" class="btn btn-warning hrmTab '.$disableClass.'" data-toggle="modal" id="'.$user->id.'" data-id="editprofile" '.$disable.'>Edit Profile</button><button type="button" class="btn btn-warning text-center  '.$disableClass.'" data-toggle="modal" data-target=".changePassword" '.$disable.'>Change Password</button>';
         ?>
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
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h3 class="panel-title"><strong>About </strong></h3>
                     </div>
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
                     <div class="panel-heading">
                        <h3 class="panel-title"><strong>Preference </strong></h3>
                     </div>
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
                     <div class="panel-heading">
                        <h3 class="panel-title"><strong>Address </strong></h3>
                     </div>
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
                                    } ?>
                                 </p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h3 class="panel-title"><strong>Qualification </strong></h3>
                     </div>
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
                     <div class="panel-heading">
                        <h3 class="panel-title"><strong> Work Experience </strong></h3>
                     </div>
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
   <?php } ?>	
</div>
<!------ Change Password Modal ------>
<div class="modal fade changePassword" tabindex="-1" role="dialog" aria-hidden="true">
 <div class="modal-dialog modal-lg">
	<div class="modal-content">
	   <div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
		  </button>
		  <h4 class="modal-title" id="myModalLabel">Change Password</h4>
	   </div>
	   <div class="modal-body">
		  <form method="post"  class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>hrm/changePassword">
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
<!------ Edit Profile Modal ------>
<div class="modal fade bs-example-modal-lg"  id="hrm_modal"  role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-large">
          <div class="modal-body-content modal-content" style="padding: 0% 0% !important; margin: 0% 0% !important;"></div>
	</div>
</div>
<!----Permissions Modal ----- -->
<div class="modal fade bs-example-modal-lg-permissions" tabindex="-1" role="dialog" aria-hidden="true">
<!----Image Upload Modal ----- -->
<div class="modal-dialog modal-lg modal-large">
      <div class="modal-content">
         <form action="<?php echo base_url();?>hrm/save_permission" method="post" enctype="multipart/form-data" id="permissionForm">
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
                           <th>Is_Validate_Purchase_Budget_Limit</th>
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
                  <div class="panel  my-div-cs">
                     <a class="panel-heading" role="tab" id="<?php echo $pa['id']; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $pa['id']; ?>" aria-expanded="true" aria-controls="collapseOne">
                        <h4 class="panel-title"><?php echo $pa['module_name']; ?></h4>
                     </a>
                     <div id="collapse_<?php echo $pa['id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php echo $pa['id']; ?>">
                        <div class="panel-body">
                           <table class="table table-striped jambo_table bulk_action" >
                              <tbody>
                                 <?php if(!empty($pa['sub_module'])) {
                                    foreach($pa['sub_module'] as $pasm){
                                    #pre($pasm['permissions']);
                                    ?>													
                                 <tr>
                                    <td width="15%"><strong><i><?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_name; ?></i></strong></td>
                                    <td><input type="checkbox" class="all permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_all" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_all == 1) { echo 'checked';} ?>></td>
                                    <td><input type="checkbox" class="add permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_add" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_add == 1) { echo 'checked';} ?>></td>
                                    <td><input  type="checkbox" class="edit permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_edit" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_edit == 1) { echo 'checked';} ?> > </td>
                                    <td><input type="checkbox" class="delete permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_delete" value="1"<?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_delete == 1) { echo 'checked';} ?>></td>
                                    <td><input type="checkbox" class="view permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_view" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_view == 1) { echo 'checked';} ?>></td>
                                    <td><input type="checkbox" class="validate permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_validate" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_validate == 1) { echo 'checked';} ?>></td>
                                    <td><input type="checkbox" class="validate_purchase_budget_limit permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_validate_purchase_budget_limit" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_validate_purchase_budget_limit == 1) { echo 'checked';} ?>></td>
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