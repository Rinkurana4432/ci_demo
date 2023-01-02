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
       $bankDetails = getNameById('user_detail',$user->id,'u_id');  
       
      if(!empty($bankDetails->bankDetails)){
      $bankDetails = json_decode($bankDetails->bankDetails);
      }
      $paymentMode = getNameById('user_detail',$user->id,'u_id');  
      if(!empty($paymentMode->paymentMode)){
      $paymentMode = json_decode($paymentMode->paymentMode);
      }
      
  /*  pre($paymentMode);die;*/
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
	     //pre($_SESSION);
         // $disable_user = ($_SESSION['loggedInUser']->role == 1) ? 'disabled': '';
         // $disable = ($_SESSION['loggedInUser']->role == 1) ?'':($user->role !=1 && $_SESSION['loggedInUser']->id == $user->id?'':'disabled');
         // $disableClass =  ($_SESSION['loggedInUser']->role == 1) ?'':($user->role !=1 && $_SESSION['loggedInUser']->id == $user->id?'':'disableBtnClick');
		 
		  $loginuserDtl =  getNameById('user',$_SESSION['loggedInUser']->id,'id');
			
		
		 
		 $disable = ($_SESSION['loggedInUser']->role == 1 || ($loginuserDtl->hr_permissions == 1)) ?'':(($loginuserDtl->hr_permissions == 1) || $user->role !=1 && $_SESSION['loggedInUser']->id == $user->id?'':'disabled');
         $disableClass =  ($_SESSION['loggedInUser']->role == 1 || ($loginuserDtl->hr_permissions == 1)) ?'':(($loginuserDtl->hr_permissions == 1) || $user->role !=1 && $_SESSION['loggedInUser']->id == $user->id?'':'disableBtnClick');
		 
		 
		 
         echo '<button  type="button" class="btn user_edit btn-warning  '.$disableClass.'" data-toggle="modal" data-target=".bs-example-modal-lg" '.$disable.'>Edit Profile</button><button type="button" class="btn btn-warning text-center  '.$disableClass.'" data-toggle="modal" data-target=".changePassword" '.$disable.'>Change Password</button>';
         ?>
         <div class="modal fade changePassword" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                     </button>
                     <h4 class="modal-title" id="myModalLabel">Change Passwordx</h4>
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
      <?php if($user->role!=1 && $_SESSION['loggedInUser']->role == 1 ) { ?>
      <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bs-example-modal-lg-permissions">Permissions</button>
      <?php } ?>

      <?php 
      #pre($user);
      if($user->role!=1 && $_SESSION['loggedInUser']->role == 1) { ?>
      <button type="button" class="btn btn-warning resendbtn" data-id = "<?php echo $user->id; ?>" data-email = "<?php echo $user->email; ?>">Resend Verification Link</button>
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
                                 }  ?>
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
                                 }  ?>
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
               <div class="col-md-12 col-sm-12 col-xs-12">
                  <?php if($user->role!=1 && $_SESSION['loggedInUser']->role == 1 ) { ?>
                  <?php }?>
                  <form method="post" id="editUserForm" class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>hrm/saveUser">
                     <h3 class="Material-head" style="margin-bottom: 30px;">
                        General Profile
                        <hr>
                     </h3>
                     <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                        <input type="hidden" name="id" value="<?php if(!empty($user)) echo $user->id; ?>">                             
                        <input type="hidden" name="u_id" value="<?php if(!empty($user)) echo $user->u_id; ?>">                            
                        <input type="hidden" name="c_id" value="<?php if(!empty($user)) echo $user->c_id; else echo $this->companyGroupId; ?>">
                        <input type="hidden" name="save_status" value="1" class="save_status">                    
                        <div class=" panel-default">
                           <div class="panel-body vertical-border">
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="name">User Name<span class="required">*</span></label>
                                 <div class="col-md-6 col-sm-6 col-xs-12">                                  
                                    <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"  name="name" placeholder="both name(s) e.g Jon Doe" required="required" type="text" value="<?php if(!empty($user)) echo $user->name;?>">
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
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="age">Date of Birth<span class="required">*</span>  </label>
                                 <div class="col-md-6 col-sm-6 col-xs-12">                                        
                                    <input type="text" id="date" required="required" name="age" class="form-control col-md-7 col-xs-12 has-feedback-left" data-validation="date" value="<?php if(!empty($user)) echo $user->age; ?>" placeholder="Date Of Birth" aria-describedby="inputSuccess2Status4">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                 </div>
                              </div>
                              <?php    if($_SESSION['loggedInUser']->role == 1){   ?>
                               <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">Company Name</label>
        <div class="col-md-6 col-sm-12 col-xs-12">
      <select name="company_id" class="itemName form-control" >
                     <?php  
        if($_SESSION['loggedInUser']->role == 2 || $_SESSION['loggedInUser']->role == 3){
                     $companies1 = getcompany_for_users();
                     
                     $selected1 = '';
                     if(!empty($companies1)){
                        foreach($companies1 as $cg1){
                           if($cg1["id"] == $_SESSION['loggedInUser']->c_id){
                              if(!isset($_SESSION['companyGroupSessionId'])){
                                 $selected1 = 'selected';
                              }
                              echo '<option  value="'.$cg1["comp_id"].'" '.$selected1.'>'.$cg1["name"].'</option>';
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
                    echo '<option value="'.$cg2["id"].'" '.$selected2.'>'.$cg2["name"].'</option>';
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
    <?php  }  ?>
         <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12">Reporting Manager <span class="required">*</span> </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2" id="manager_id"  required="required" name="manager_id"  tabindex="-1" aria-hidden="true" data-id="user_detail" data-key="id" data-fieldname="name" data-where="c_id=<?php echo $_SESSION['loggedInUser']->c_id;?> and is_activated=1" >
               <option value="">Select Option</option>
               <?php
                  if(!empty($user)){
                     $userData = getNameById('user_detail',$user->manager_id,'id');
                     if(!empty($userData)){
                        echo '<option value="'.$userData->id.'" selected>'.$userData->name.'</option>';
                     }
                  }
                  ?>                      
            </select>
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
                                    <input type="text" id="date_joining" required="required" name="date_joining" class="form-control col-md-7 col-xs-12 has-feedback-left" data-validation="date" value="<?php  if(!empty($user)) echo $user->date_joining; ?>" placeholder="Date Of Joining" aria-describedby="inputSuccess2Status4">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                 </div>
                              </div>
                       
                       
                        <div class="item form-group">
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="joining">Probation Period<span class="required">*</span></label>
                                 <div class="col-md-6 col-sm-6 col-xs-12">  <?php  $biometric_id = getNameById('user_detail',$user->id,'u_id'); ?>
                                    <input type="text" id="probation_period" required="required"  name="probation_period" class="form-control col-md-7 col-xs-12 has-feedback-left"  value="<?php   if(!empty($biometric_id)) echo $biometric_id->probation_period; ?>" placeholder="Probation Period" aria-describedby="inputSuccess2Status4">
                                 </div>
                              </div>
                    <div class="item form-group">
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="joining">Confirmation Date<span class="required">*</span></label>
                                 <div class="col-md-6 col-sm-6 col-xs-12"> 
                                    <input type="text" id="confirmation_date" name="confirmation_date" required="required"   class="form-control col-md-7 col-xs-12 has-feedback-left" value="<?php  if(!empty($biometric_id)) echo @ $biometric_id->confirmation_date;  ?>"   placeholder="Confirmation Date" aria-describedby="inputSuccess2Status4">
                                 </div>
                              </div>
                  <div class="item form-group">
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="joining">Biometric ID<span class="required">*</span></label>
                                 <div class="col-md-6 col-sm-6 col-xs-12"> 
                              
                                    <input type="text" id="biometric_id" required="required" name="biometric_id" class="form-control col-md-7 col-xs-12 has-feedback-left"  value="<?php  if(!empty($biometric_id))  print_r($biometric_id->biometric_id); ?>" placeholder="Biometric ID" aria-describedby="inputSuccess2Status4">
                                     
                                 </div>
                              </div>
                      <div class="item form-group">
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="joining">User ID<span class="required">*</span></label>
                                 <div class="col-md-6 col-sm-6 col-xs-12"> 
                               <?php  $biometric_id = getNameById('user_detail',$user->id,'u_id'); ?>
                                    <input type="text" readonly id="biometric_id"  class="form-control col-md-7 col-xs-12 has-feedback-left"  value="<?php  if(!empty($user->id))  print_r($user->id); ?>" placeholder="User ID" aria-describedby="inputSuccess2Status4">
                                     
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="bottom-bdr"></div>
                     <div class="container">
                        <ul class="nav tab-3 nav-tabs tab-3">
                           <li class="active"><a data-toggle="tab" href="#Permanent-Address">Permanent Address</a></li>
                           <li><a data-toggle="tab" href="#Address">Correspondance Address</a></li>
                           <li><a data-toggle="tab" href="#bank_details"> PF , ESI & LWF</a></li>
                           <li><a data-toggle="tab" href="#payment_mode">Payment Mode</a></li>
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
                           <div id="bank_details" class="tab-pane fade in ">
                              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                 <div class="panel-default">
                                    <div class="panel-body address_wrapper">
                                       <div class="item form-group">
                                          <div class="col-md-12 input_correspondance_address_wrap" id="chkIndex_0">
                                             <div class="col-md-6 vertical-border">
                                                <div class="item form-group">
                                                   <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">Pan Number</label>
                                                   <div class="col-md-6 col-sm-8 col-xs-8">
                                                      <input type="text"  name="pan_number"  class="form-control col-md-7 col-xs-12" placeholder="Pan Number" value="<?php  if(!empty($bankDetails->pan_number)){ echo $bankDetails->pan_number; } ?>">
                                                   </div>
                                                </div>
                                                <div class="item form-group">
                                                   <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">Include PF</label>
                                                   <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                      <input <?php if(!empty($bankDetails->include_pf)){ echo "checked";}  ?> type="checkbox" value="include_pf" name="include_pf" id="include_pf" value="include_pf" class="iCheck-helper" >
                                                   </div>
                                                   <div style="display:none" class="hide_if_no_pf col-md-6 col-sm-12 col-xs-12 ">
                                                      <input placeholder="PF Number" type="text" name="pf_number" value="<?php  if(!empty($bankDetails->pf_number)){ echo $bankDetails->pf_number; } ?>" class="form-control" > <br>
                                                      <input placeholder="UAN Number" type="text" name="uan_number" value="<?php  if(!empty($bankDetails->uan_number)){ echo $bankDetails->uan_number; } ?>" class="form-control" >
                                                   </div>
                                                </div>
                                              <div style="display:none" class="hide_if_no_pf item form-group">
                                                   <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">PF Excess Contribution</label>
                                                   <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                      <input <?php if(!empty($bankDetails->pf18000)){ echo "checked";}  ?> type="checkbox" name="pf18000" value="1800" class="iCheck-helper" ><span>   &nbsp;&nbsp;Employee & Employer contribution - 12% with in wage ceiling (Max Rs.1800)<span><br>
                                                      <input <?php if(!empty($bankDetails->pfgreaterthan1800)){ echo "checked";}  ?>  type="checkbox" name="pfgreaterthan1800" value="greater1800" class="iCheck-helper" ><span>&nbsp;&nbsp; Employee contribution - 12% over and above wage ceiling (In excess to Rs.1800)</span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6 vertical-border">
                                                <div class="item form-group">
                                                   <div class="item form-group ">
                                                      <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country"> Include ESI</label>
                                                       <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                          <input <?php if(!empty($bankDetails->include_esi)){ echo "checked";}  ?>  type="checkbox" name="include_esi" id="include_esi" value="include_esi" class="iCheck-helper" >
                                                          <input style="display:none"   placeholder="ESI Number" type="text" name="include_esi" id="include_esi" value="<?php  if(!empty($bankDetails->include_esi)){ echo $bankDetails->include_esi; } ?>" class="hide_if_no_esi form-control" >
                                                       </div>
                                                   </div>
                                                   <div class="item form-group ">
                                                      <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country"> Include LWF</label>
                                                   <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                      <input type="checkbox" name="include_lwf" value="Include LWF" class="iCheck-helper" >
                                                      
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
                        <!-- </?php pre($paymentMode); ?>-->
                           <div id="payment_mode" class="tab-pane fade in ">
                              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                 <div class="panel-default">
                                    <div class="panel-body address_wrapper">
                                       <div class="item form-group">
                                          <div class="col-md-12 input_correspondance_address_wrap" id="chkIndex_0">
                                             <div class="col-md-6 vertical-border">
                                                <div class="item form-group">
                                                   <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">Cash</label>
                                                   <div class="col-md-6 col-sm-8 col-xs-8">
                                                      <input  <?php if(!empty($paymentMode->payment_mode)){if($paymentMode->payment_mode == 'cash'){ echo "checked"; }}  ?> type="radio" id="cash" name="payment_mode" value="cash">
                                                   </div>
                                                </div>
                                                <div class="item form-group">
                                                   <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">Bank Transfer</label>
                                                   <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                   <input <?php  if(!empty($paymentMode->payment_mode)){if ( $paymentMode->payment_mode=='bank_transfer' ){ echo "checked"; }} ?> type="radio" name="payment_mode" id="bank_transfer" value="bank_transfer"> 
                                                   </div>
                                                   <div  style="xdisplay:none" class="hide_if_bank_transfer col-md-6 col-sm-12 col-xs-12 "><br>
                                                        <input type="text" placeholder="Bank Name" name="bank_name" class="form-control" value="<?php if ( !empty($paymentMode->bank_name)){ echo $paymentMode->bank_name; }?>" ><br>
                                                        <input type="text" placeholder="Branch Name" name="branch_name" class="form-control" value="<?php if ( !empty($paymentMode->branch_name)){ echo $paymentMode->branch_name; }?> "><br>
                                                        <input type="text" placeholder="Account Number" name="account_no" class="form-control" value="<?php if ( !empty($paymentMode->account_no)){ echo $paymentMode->account_no; }?> "> 
                                                        </div>
                                                </div>
                                              
                                             </div>
                                             <div class="col-md-6 vertical-border">
                                                <div class="item form-group">
                                                   <div class="item form-group ">
                                                      <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country"> Cheque</label>
                                                       <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                         <input <?php if(!empty($paymentMode->payment_mode)){if ($paymentMode->payment_mode == 'cheque'){ echo "checked"; }} ?>  type="radio" id="cheque" name="payment_mode"  value="cheque">
                                                        </div>
                                                   </div>
                                                   <div class="item form-group ">
                                                      <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">Demand Draft</label>
                                                   <div class="col-md-6 col-sm-12 col-xs-12 "> 
                                                    <input <?php if(!empty($paymentMode->payment_mode)){if ($paymentMode->payment_mode == 'demand_draft'){ echo "checked"; }} ?> type="radio"name="payment_mode"  id="demand_draft" value="demand_draft"> <br>
                                                    <input style="xdisplay:none" type="text" placeholder="Bank Branch" class= "hide_if_demand_draft form-control" name="bank_branch" value="<?php if ( !empty($paymentMode->bank_branch)){ echo $paymentMode->bank_branch; }?>"  ><br>
                                                    <input style="xdisplay:none" type="text" placeholder="DD Payable At" class="hide_if_demand_draft form-control"  name="dd_payable_at" value="<?php if ( !empty($paymentMode->dd_payable_at)){ echo $paymentMode->dd_payable_at; }?>"  >                                                   
                                                      
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
                     <hr>
                     <div class="bottom-bdr"></div>
                     <h3 class="Material-head" style="margin-bottom: 30px;">
                        Qualification
                        <hr>
                     </h3>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
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
                                 echo '<div class="col-md-3 col-sm-12 col-xs-12 form-group"> <input type="text" id="qualification" name="qualification[]" class="form-control col-md-1" placeholder="Qualification" value=""></div><div class="col-md-3 col-sm-12 col-xs-12 form-group">  <input type="text" id="university"  name="university[]" class="form-control col-md-1" placeholder="University" value=""></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" name="year[]" class="form-control col-md-1 year" placeholder="Year of Passing" value="" readonly="readonly"></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><div class="input-group form-group"><input type="number" id="marks" name="marks[]" class="form-control col-md-1" placeholder="%age" value=""><span class="input-group-addon">%</span></div></div><div class="input-group-append"><button class="btn btn-primary add_skill_button" type="button"><i class="fa fa-plus"></i></button></div></div></div>';
                                 }
                                 ?>
                              <div class="col-md-12 btn-row"><button class="btn btn-warning add_qualification_button" type="button">Add</button></div>
                           </div>
                        </div>
                     </div>
                     <?php } ?>                    
                     <hr>
                     <div class="bottom-bdr"></div>
                     <h3 class="Material-head" style="margin-bottom: 30px;">
                        Work Experience
                        <hr>
                     </h3>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
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
                     <hr>
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
                     <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                        <div class=" panel-default">
                           <h3 class="Material-head" style="margin-bottom: 30px;">
                              Documents
                              <hr>
                           </h3>
                           <div class="panel-body image_wrapper">
                              <div class="col-md-12 input_image_wrap item vertical-border">
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="name">Document Upload </label>               
                                 <div class="col-md-6 col-sm-12 col-xs-12">
                                    <input type="file" class="form-control col-md-7 col-xs-12" name="doc_upload[]">
                                 </div>
                                 <button class="btn btn-primary add_images_button" type="button"><i class="fa fa-plus"></i></button>                              
                              </div>
                           </div>
                           <?php //
                              if(!empty($attachments)){ ?>
                           <div class="item form-group">
                              <label class="control-label col-md-3 col-sm-2 col-xs-12" for="proof"></label>
                              <div class="col-md-7">        
                                 <?php 
                                    foreach($attachments as $proofs){   
                                    //pre($proofs);die;
                                        $ext = pathinfo($proofs['file_name'], PATHINFO_EXTENSION);
                                       if($ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg' || $ext == 'png' || $ext == 'ico'){
                                          echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'" alt="image" height="80" width="80"/><i class="fa fa-download"></i> 
                                          <div class="mask">
                                                <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'hrm/delete_doc/'.$proofs['id'].'/'.$user->id.'">
                                                <i class="fa fa-trash"></i>
                                                </a>
                                             </div></div></div>';       
                                       }else if($ext == 'ods' || $ext ==  'doc' || $ext ==  'docx' ){
                                          echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/docX.png"  height="80" width="80"/><i class="fa fa-download"></i> 
                                          <div class="mask">
                                                <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'hrm/delete_doc/'.$proofs['id'].'/'.$user->id.'">
                                                <i class="fa fa-trash"></i>
                                                </a>
                                             </div></div></div>'; 
                                       }else if($ext == 'pdf'){
                                          echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/PDF.png"  height="80" width="80"/><i class="fa fa-download"></i> 
                                          <div class="mask">
                                                <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'hrm/delete_doc/'.$proofs['id'].'/'.$user->id.'">
                                                <i class="fa fa-trash"></i>
                                                </a>
                                             </div></div></div>'; 
                                       }else if($ext == 'xlsx'){
                                          echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/excel.png"  height="80" width="80"/><i class="fa fa-download"></i> 
                                          <div class="mask">
                                                <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'hrm/delete_doc/'.$proofs['id'].'/'.$user->id.'">
                                                <i class="fa fa-trash"></i>
                                                </a>
                                          </div></div></div>'; 
                                       }
                                    }
                                    
                                    ?>          
                              </div>
                           </div>
                           <?php } ?>
                        </div>
                     </div>
         <div class="modal-footer">
                <center>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="reset" class="btn btn-default">Reset</button>
                  <?php if(!empty($user) && $user->save_status !=1){
                     echo '<input type="submit" class="btn btn-warning add_users_dataaa draftBtn" value="Save as draft">'; 
                     }?> 
                  <input type="submit" class="btn btn-warning" value="Save"> 
                  </form>
                </center>
            </div>   
               </div>
            </div>
                                    
                                    
         </div>
      </div>
   </div>
   <!-- ------------------------------------------------- Permissions Modal -------------------------------------------- -->
   <div class="modal fade bs-example-modal-lg-permissions" tabindex="-1" role="dialog" aria-hidden="true">
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
                              <th width="14%"> Modules </th>
                              <th width="14%">Is_All</th>
                              <th width="14%">Is_Create</th>
                              <th width="14%">Is_Edit</th>
                              <th width="14%">Is_Delete</th>
                              <th width="14%">Is_View</th>
                              <th width="14%">Is_Validate</th>
                             <!-- <th width="15%">Is_Validate_Purchase_Budget_Limit</th>-->
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
                  <div class="btn4"><span>Make an Admin<input type="checkbox" class="selectAll" name=""></span></div>
                                 

                  <!-- start accordion -->
                  <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                   <?php $ij= 0;
                    #pre($groupofCompany); 
                    if(!empty($groupofCompany)){
                     # pre($groupofCompany);
                       
                             #pre($gcp);
                   ?>
                    <a class="panel-heading" role="tab" id="<?php #echo $pa['id']; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapse_23<?php #echo $pa['id']; ?>" aria-expanded="true" aria-controls="collapseOne">
                              <h4 class="panel-title"><?php #echo $pa['module_name']; ?>Group of Companies</h4>
                           </a>
                    <div id="collapse_23<?php #echo $pa['id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php #echo $pa['id']; ?>">
                        <div class="panel-body">
                           <table class="table table-striped jambo_table bulk_action" >
                               <tr>
                                      <td width="15%">Select All</td>
                                      <td width="15%">
                                          <input type="checkbox" class="selectAll23" />
                                      </td>
                                      
                                  </tr>
                                <!--  <tr>
                                    <td width="15%">Select all Company</td>
                                    <td><input type="checkbox" class="permissions_cls"/></td>
                                 </tr> -->
                                 <?php       
                                    $i = 0; 
                                       foreach($groupofCompany as $gcp){
                                    ?>
                                    <?php if(!empty($gcp['name'])) { ?>
                                       <tr>
                                          <td width="15%"><strong><i><?php echo $gcp['name']; ?></i></strong></td>                                       
                                          <td width="15%"><input type="checkbox" class="add permissions_cls" name="<?php echo $gcp['id']; ?>_status"  value="1" <?php if(!empty($gcp['comp_permission']) && $gcp['comp_permission'][0]->status == 1) { echo 'checked';} ?>/> </td>
                                       <tr>
                                    <?php }#} ?>   
                                     <?php $ij++; }}?>                                      
                           </table> 
                        </div>   
                     </div>
                    
                     <?php if(!empty($permissionsArray)){
                       # pre($);
                        $i = 0; 
                           foreach($permissionsArray as $pa){?>
                     <div class="panel  my-div-cs">

                        <a class="panel-heading" role="tab" id="<?php echo $pa['id']; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $pa['id']; ?>" aria-expanded="true" aria-controls="collapseOne">
                           <h4 class="panel-title"><?php echo ucwords($pa['module_name']); 
                           ?></h4>
                        </a>

                        <div id="collapse_<?php echo $pa['id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php echo $pa['id']; ?>">
                           <div class="panel-body">
                              <table class="table table-striped jambo_table bulk_action" >
                                
                                <tr>
                                      <td width="15%">Select All</td>
                                      <td width="15%">
                                          <input type="checkbox" class="selectAll23" />
                                      </td>
                                      
                                  </tr>
                                    <?php if(!empty($pa['sub_module'])) {
                                       foreach($pa['sub_module'] as $pasm){
                                       #pre($pasm['permissions']);
                                       ?>                                     
                                    <tr>
                                       <td width="15%"><strong><i><?php if(!empty($pasm['permissions'])) echo ucwords($pasm['permissions'][0]->sub_module_name);  ?></i></strong></td>
                                       <td><input type="checkbox" class="all permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_all" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_all == 1) { echo 'checked';} ?>></td>
                                       <td><input type="checkbox" class="add permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_add" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_add == 1) { echo 'checked';} ?>></td>
                                       <td><input  type="checkbox" class="edit permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_edit" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_edit == 1) { echo 'checked';} ?> > </td>
                                       <td><input type="checkbox" class="delete permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_delete" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_delete == 1) { echo 'checked';} ?>></td>
                                       <td><input type="checkbox" class="view permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_view" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_view == 1) { echo 'checked';} ?>></td>
                                       <td><input type="checkbox" class="validate permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_validate" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_validate == 1) { echo 'checked';} ?>></td>
                                     <!--  <td><input type="checkbox" class="validate_purchase_budget_limit permissions_cls" name="<?php if(!empty($pasm['permissions'])) echo $pasm['permissions'][0]->sub_module_id; ?>_validate_purchase_budget_limit" value="1" <?php if(!empty($pasm['permissions']) && $pasm['permissions'][0]->is_validate_purchase_budget_limit == 1) { echo 'checked';} ?>></td>-->
                                    </tr>
                                    <?php }} ?>                                        
                                
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