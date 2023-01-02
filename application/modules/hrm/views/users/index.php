 
<div class="x_content">
   <?php if($this->session->flashdata('message') != ''){
      echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
      }?> 
   <div class="pull-left"><button type="button" class="btn btn-warning user_edit" data-toggle="modal" data-target=".bs-example-modal-lg">Add User</button></div>
   
   <div class="dropdown btn btn-warning pull-left export ">
		<button class="btn btn-warning dropdown-toggle btn-default" type="button" data-toggle="dropdown" style="margin: 0px; font-size: 14px;">Export<span class="caret"></span></button>
		   <ul class="dropdown-menu" role="menu" id="export-menu">
			  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
			  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
		  </ul>
	</div>
				<form action="<?php echo site_url(); ?>hrm/users" method="get" id="export-form">
					<input type="hidden" value='' id='hidden-type' name='ExportType'/>
					
				</form>
   
   <div class="pull-right">
      <i class="fa fa-th-list" data-toggle="tooltip" data-placement="bottom" title="List View" onclick="showListView();"></i>&nbsp;
      <i class="fa fa-th" data-toggle="tooltip" data-placement="bottom" title="Grid View" onclick="showGridView();"></i>
   </div>
   <!-- ------------------------------------------------ Edit Profile Modal -------------------------------------- -->
   <div class="modal fade bs-example-modal-lg"  role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title" id="myModalLabel">Add User</h4>
            </div>
            <div class="modal-body">
               <div class="col-md-12 col-sm-12 col-xs-12">
                  <form method="post" id="editUserForm" class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>hrm/saveUser">
                     <h3 class="Material-head" style="margin-bottom: 30px;">
                        General Profile
                        <hr>
                     </h3>
                     <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                        <input type="hidden" name="id" value="">                    
                        <input type="hidden" name="u_id" value="">  
                        <input type="hidden" name="c_id" value="<?php  echo $this->companyGroupId;?>">
                        <input type="hidden" name="save_status" value="1" class="save_status">  
                        <div class="panel-default">
                           <div class="panel-body vertical-border">
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="name">User Name<span class="required">*</span></label>
                                 <div class="col-md-6 col-sm-5 col-xs-12">                        
                                    <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"  name="name" placeholder="both name(s) e.g Jon Doe" required="required" type="text" value="<?php if(!empty($edit)) echo $edit->name;?>">
                                 </div>
                              </div>
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="email">Email<span class="required">*</span></label>
                                 <div class="col-md-6 col-sm-5 col-xs-12">                        
                                    <input type="email" id="email" required="required" name="email"  class="form-control col-md-7 col-xs-12" placeholder="Enter email" value="">
                                 </div>
                              </div>
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="gender">Gender <span class="required">*</span></label>
                                 <div class="col-md-6 col-sm-6 col-xs-12">  
                                    Male: <input type="radio" class="flat" name="gender" id="genderM" value="Male" checked="" required /> 
                                    Female: <input type="radio" class="flat" name="gender" id="genderF" value="Female" />                   
                                 </div>
                              </div>
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="phone">Phone <span class="required">*</span> </label>
                                 <div class="col-md-6 col-sm-5 col-xs-12">                            
                                    <input type="tel" id="telephone" name="contact_no" required="required" data-validate-length-range="8,10" class="form-control col-md-7 col-xs-12" placeholder="Enter mobile number" value="">
                                 </div>
                              </div>
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="age">Date of Birth<span class="required">*</span>  </label>
                                 <div class="col-md-6 col-sm-5 col-xs-12">                            
                                    <input type="text" id="date" required="required" name="age" class="form-control col-md-7 col-xs-12 has-feedback-left" data-validation="date" value="" placeholder="Date Of Birth" aria-describedby="inputSuccess2Status4" onchange="validate_date(this.value)">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                        <div class=" panel-default">
                           <div class="panel-body vertical-border">
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="designation">Designation<span class="required">* </span></label>
                                 <div class="col-md-6 col-sm-5 col-xs-12">                        
                                    <input type="text" id="designation" name="designation" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter designation" value="">                        
                                 </div>
                              </div>
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="experience">Experience</label>
                                 <div class="col-md-6 col-sm-5 col-xs-12">
                                    <div class="input-group">
                                       <input type="number" id="experience"  name="experience" class="form-control col-md-7 col-xs-12" placeholder="Experience" value="">                         
                                       <span class="input-group-addon">Years</span>
                                    </div>
                                 </div>
                              </div>
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-3 col-xs-12" for="joining">Date Of Joining<span class="required">*</span></label>
                                 <div class="col-md-6 col-sm-5 col-xs-12">  
                                    <input type="text" id="date_join" required="required" name="date_joining" class="form-control col-md-7 col-xs-12 has-feedback-left" data-validation="date" value="" placeholder="Date Of Joining" aria-describedby="inputSuccess2Status4">
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
                    echo '<option value="'.$cg1["comp_id"].'" '.$selected1.'>'.$cg1["name"].'</option>';
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
                     <hr>
                     <div class="bottom-bdr"></div>
                     <div class="container">
                        <ul class="nav tab-3 nav-tabs tab-3">
                           <li class="active"><a data-toggle="tab" href="#Permanent-Address">Permanent Address</a></li>
                           <li><a data-toggle="tab" href="#Address">Correspondance Address</a></li>
                        </ul>
                        <div class="tab-content">
                           <div id="Permanent-Address" class="tab-pane fade in active">
                              <div class="panel-default">
                                 <div class="panel-body address_wrapper">
                                    <div class="item form-group">
                                       <div class="col-md-12 input_permanent_address_wrap" id="chkIndex_0">
                                          <div class="col-md-6 vertical-border">
                                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                                <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">Permanent address</label>
                                                <div class="col-md-6 col-sm-8 col-xs-8">
                                                   <textarea id="address"  name="permanent_address" class="form-control col-md-7 col-xs-12" placeholder="Address"></textarea>
                                                </div>
                                             </div>
                                             <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">Zipcode</label>
                                                <div class="col-md-6 col-sm-8 col-xs-8">
                                                   <input type="number"  name="permanent_postal_zipcode" class="form-control col-md-1" placeholder="Postal/Zipcode" value="">
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-6 vertical-border">
                                             <div class="item form-group ">
                                                <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">Permanent Country</label>
                                                <div class="col-md-6 col-sm-8 col-xs-8">
                                                   <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="permanent_country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this,'permanent')">
                                                      <option value="">Select Option</option>
                                                      <?php
                                                         if(!empty($user)){
                                                          $country = getNameById('country',$user->permanent_country,'country_id');
                                                          echo '<option value="'.$user->permanent_country.'" selected>'.$country->country_name.'</option>';
                                                         }
                                                         ?>
                                                   </select>
                                                </div>
                                             </div>
                                             <div class="item form-group ">
                                                <label class="col-md-3 col-sm-4 col-xs-4" for="permanent_state">Permanent State/Province</label>
                                                <div class="col-md-6 col-sm-8 col-xs-8">
                                                   <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible permanent state_id" name="permanent_state"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this,'permanent')">
                                                      <option value="">Select Option</option>
                                                      <?php
                                                         if(!empty($user)){
                                                          $state = getNameById('state',$user->permanent_state,'state_id');
                                                          echo '<option value="'.$user->permanent_state.'" selected>'.$state->state_name.'</option>';
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
                                                         if(!empty($user)){
                                                          $city = getNameById('city',$user->permanent_city,'city_id');
                                                          echo '<option value="'.$user->permanent_city.'" selected>'.$city->city_name.'</option>';
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
                           <div id="Address" class="tab-pane fade in ">
                              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                 <div class="panel-default">
                                    <div class="panel-body address_wrapper">
                                       <div class="item form-group">
                                          <div class="col-md-12 input_correspondance_address_wrap" id="chkIndex_0">
                                             <div class="col-md-6 vertical-border">
                                                <div class="item form-group">
                                                   <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">Correspondance address</label>
                                                   <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                      <textarea id="address" name="correspondance_address" class="form-control col-md-7 col-xs-12" placeholder="Address"></textarea>
                                                   </div>
                                                </div>
                                                <div class="item form-group">
                                                   <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">zipcode</label>
                                                   <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                      <input type="number" name="correspondance_postal_zipcode" class="form-control col-md-1" placeholder="Postal/Zipcode" value="">
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6 vertical-border">
                                                <div class="item form-group ">
                                                   <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">Correspondance Country</label>
                                                   <div class="col-md-6 col-sm-8 col-xs-8">
                                                      <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="correspondance_country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this,'correspondance')">
                                                         <option value="">Select Option</option>
                                                         <?php
                                                            if(!empty($user)){
                                                              $country = getNameById('country',$user->correspondance_country,'country_id');
                                                              echo '<option value="'.$user->correspondance_country.'" selected>'.$country->country_name.'</option>';
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
                                                            if(!empty($user)){
                                                              $state = getNameById('state',$user->correspondance_state,'state_id');
                                                              echo '<option value="'.$user->correspondance_state.'" selected>'.$state->state_name.'</option>';
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
                                                            if(!empty($user)){
                                                              $city = getNameById('city',$user->correspondance_city,'city_id');
                                                              echo '<option value="'.$user->correspondance_city.'" selected>'.$city->city_name.'</option>';
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
               <hr>
               <div class="bottom-bdr"></div>   
               <div class="col-md-12 col-sm-12 col-xs-12 form-group">                     
               <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <h3 class="Material-head" style="margin-bottom: 30px;">Qualification<hr></h3>
               <div class=" panel-default">               
               <div class="panel-body quaification_wrapper">
               <div class="col-sm-12  col-md-12 label-box mobile-view2">
               <div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label >Qualification</label></div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label>University</label></div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label>Year of Passing</label></div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label style=" border-right: 1px solid #c1c1c1 !important;" >Percentage</label></div>
               </div>
               <div class="item form-group">
               <div class="col-md-12 input_quaification_wrap middle-box">                           
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">                              
               <input type="text" id="qualification"  name="qualification[]" class="form-control col-md-1 qualification_section" placeholder="Qualification" value="">                        
               </div>                           
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">                              
               <input type="text" id="university"  name="university[]" class="form-control col-md-1 qualification_section" placeholder="University" value="">                           
               </div>                           
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">                              
               <input type="text"   name="year[]" class="form-control col-md-1 year qualification_section" placeholder="Year of Passing" value="">                            
               </div>                           
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">  
               <div class="input-group">
               <input type="number" id="marks"   name="marks[]" class="form-control col-md-1 qualification_section" placeholder="%age" value="">
               <span class="input-group-addon">%</span>
               </div>
               </div>       
               </div>
               <div class="col-md-12 btn-row"><button class="btn btn-primary add_qualification_button" type="button">Add</button></div>
               </div>
               </div>
               </div>
               </div>
               <hr>
               <div class="bottom-bdr"></div>
               <!-- -------------------------------- New Field For Experience Added here ------------------------------------------ -->
               <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <h3 class="Material-head" style="margin-bottom: 30px;">Work Experience<hr></h3>
               <div class=" panel-default">               
               <div class="panel-body experience_wrapper">
               <div class="col-sm-12  col-md-12 label-box mobile-view2">
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"> <label >Company Name</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Location</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Position</label></div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Work Period</label></div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;" >Responsibilities</label></div>
               </div>
               <div class="item form-group">
               <div class="col-md-12 col-sm-12 col-xs-12 input_experience_wrap middle-box">                           
               <div class="col-md-2 col-sm-12 col-xs-12 form-group">                              
               <input type="text" id="companyName"  name="companyName[]" class="form-control col-md-1 work_experience_section" placeholder="Company Name" value="">                           
               </div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group">                              
               <input type="text" id="companyLocation"   name="companyLocation[]" class="form-control col-md-1 work_experience_section" placeholder="Location" value="">                            
               </div> 
               <div class="col-md-2 col-sm-12 col-xs-12 form-group">                              
               <input type="text" id="position"   name="position[]" class="form-control col-md-1 work_experience_section" placeholder="Position" value="">                            
               </div> 
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">
               <!-- Period Of Work -->                        
               <fieldset>
               <div class="control-group">
               <div class="control-group">
               <div class="controls">
               <div class="input-prepend input-group">
               <span class="add-on input-group-addon">Work Period</span>
               <input type="text" name="work_period[]" id="reservation" class="form-control work_experience_section" value="01/01/2016 - 01/25/2016" />
               </div>
               </div>
               </div>
               </div>
               </fieldset>                        
               </div>                           
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">                              
               <textarea style="border-right:1px solid #c1c1c1 !important;" id="responsibility"  name="responsibility[]" class="form-control col-md-7 col-xs-12 work_experience_section" placeholder="Responsibilities"></textarea> 
               </div>                                                     
               </div> 
               <div class="col-md-12 btn-row"><button class="btn btn-primary add_experience_button" type="button">Add</button></div>
               </div>
               </div>
               </div>
               </div> 
               <hr>
               <div class="bottom-bdr"></div>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
               <div class=" panel-default">
               <h3 class="Material-head" style="margin-bottom: 30px;">Social Links<hr></h3>
               <div class="panel-body vertical-border">
               <div class="item form-group col-md-12">                        
               <label class="col-md-3 col-sm-3 col-xs-12" for="name">Facebook</label>
               <div class="col-md-6 col-sm-9 col-xs-12">                        
               <input id="facebook" class="form-control col-md-7 col-xs-12 optional" name="facebook" placeholder="" type="url" value="">
               </div>                     
               </div>                     
               <div class="item form-group col-md-12">                        
               <label class="col-md-3 col-sm-3 col-xs-12" for="email">Twitter</label>
               <div class="col-md-6 col-sm-9 col-xs-12">                        
               <input type="url" id="twitter" name="twitter" class="form-control col-md-7 col-xs-12 optional" placeholder="" value="">
               </div>                     
               </div>
               <div class="item form-group col-md-12">                          
               <label class="col-md-3 col-sm-3 col-xs-12" for="phone">Instagram</label>
               <div class="col-md-6 col-sm-9 col-xs-12">                            
               <input type="url" id="instagram" name="instagram"  class="form-control col-md-7 col-xs-12 optional" placeholder="" value="">
               </div>                       
               </div>
               <div class="item form-group col-md-12">                          
               <label class="col-md-3 col-sm-3 col-xs-12" for="age">Linkedin</label>
               <div class="col-md-6 col-sm-9 col-xs-12">                            
               <input type="url" id="linkedin" name="linkedin" class="form-control col-md-7 col-xs-12 optional" value="" placeholder="">
               </div>                       
               </div>                 
               </div>
               </div>
               </div>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
               <div class=" panel-default">
               <h3 class="Material-head" style="margin-bottom: 30px;">Skills<hr></h3>
               <div class="panel-body skill_wrapper">
               <div class="col-md-12 input_skill_wrap item vertical-border">
               <label class="col-md-3 col-sm-3 col-xs-12" for="name">Name</label>                 
               <div class="col-md-5 col-sm-8 col-xs-12 ">
               <input type="text"  name="skill_name[]" class="form-control col-md-7 skill_section" placeholder="Name" value="">
               </div>
               <div class="col-md-3 col-sm-12 col-xs-12 ">
               <input type="number"  name="skill_count[]" class="form-control col-md-1 skill_section" placeholder="Count" value="">
               </div>                   
               <button class="btn btn-primary add_skill_button" type="button"><i class="fa fa-plus"></i></button>                   
               </div>
               </div>
               </div>
               </div> 
               </div>                         
            </div>
            <div class="modal-footer col-md-12 col-xs-12">
            <center>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <input type="submit" class="btn btn-warning add_users_dataaa draftBtn" value="Save as draft"> 
            <input type="submit" class="btn btn-warning add_users_dataaa" value="Save"> 
            </center>
            </div>    
            </form>         
         </div>
      </div>
   </div>
</div>
</div>
<!-----------------------------------------------------list view display------------------------------------------------------>
<div id="listview" style="display:none">
   <div role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a href="#users_active" data-select='users' id="usersActiveTab" role="tab" data-toggle="tab" aria-expanded="true">Active</a></li>
         <li role="presentation" class=""><a href="#users_inactive" data-select='users' id="usersInactiveTab" role="tab" data-toggle="tab" aria-expanded="true">Inactive</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <!---------------------------------Active user tab------------------------------------------------------------->
         <div role="tabpanel" class="tab-pane fade active in" id="users_active" aria-labelledby="usersActiveTab">
            <p class="text-muted font-13 m-b-30"></p>
            <table id="datatable-buttons" class="table table-striped table-bordered"  data-id="user" cellspacing="0" width="100%">
               <thead>
                  <tr>
                     <th>Id</th>
                     <th>Name</th>
                     <th>Image</th>
                     <th>User Email</th>
                     <th>Designation</th>
                     <th>DOB</th>
                     <th>Contact No.</th>
                     <th>Experience (Years)</th>
                     <th>Joining Date</th>
                     <th>Status</th>
                     <!-- <th>Make HR Permissions</th> -->
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php if(!empty($users)){
                     foreach($users as $user){
                     $disable = ($user['status'] != 1)?'disabled':'';
                     $disableClass = ($user['status'] != 1)?'disableBtnClick':'';
                     $user['user_profile'] = $user['user_profile']!=''?$user['user_profile']:'dummy.jpg';
                     $statusChecked = $user['status']==1?'checked':'';
                     $hr_permissionsChecked = $user['hr_permissions']==1?'checked':''; 
                     // <td>
                     // <label class='switchChange'>           
                     //  <input type='checkbox' class='js-switch change_status ".$disableClass."' value='".$user['hr_permissions']."' data-value='".$user['id']."' ". $hr_permissionsChecked ." data-switchery='true' style='display: none;' ".$disable."/>
                     // </label>
                     // </td>
                     echo "<tr>
                     <td>".$user['id']."</td>
                     <td>".$user['name']."</td>
                     <td><img class='avatar' src='".base_url()."assets/modules/hrm/uploads/".$user['user_profile']."'></td>
                     <td>".$user['email']."</td>
                     <td>".$user['designation']."</td>
                     <td>".$user['age']."</td>
                     <td>".$user['contact_no']."</td>
                     <td>".$user['experience']."</td>
                     <td>".$user['date_joining']."</td>
                     <td>
                     <label class='switchChange'>           
                      <input type='checkbox' class='js-switch change_status ".$disableClass."' value='".$user['status']."' data-value='".$user['id']."' ". $statusChecked ." data-switchery='true' style='display: none;' ".$disable."/>
                     </label>
                     </td>
                     
                     <td>
                     <a href='".base_url()."hrm/editUser/".$user['id']."' class='btn btn-primary btn-xs'><i class='fa fa-folder'></i> View </a>                      
                     <a href='javascript:void(0)' class='delete_listing btn btn-danger btn-xs ".$disableClass."' data-href='".base_url()."hrm/deleteUser/".$user['id']."'".$disable."><i class='fa fa-trash-o'></i> Delete </a>           
                     </td>
                     </tr>";
                     }
                     } ?>
               </tbody>
            </table>
         </div>
         <!-------------------------------------------End of active user tab------------------------------------------->
         <!--------------------------------------Inactive tab Start---------------------------------------------->
         <div role="tabpanel" class="tab-pane fade" id="users_inactive" aria-labelledby="usersInactiveTab">
            <p class="text-muted font-13 m-b-30"></p>
            <table id="datatable-buttons" class="table table-striped table-bordered"  data-id="user" cellspacing="0" width="100%">
               <thead>
                  <tr>
                     <th>Id</th>
                     <th>Name</th>
                     <th>Image</th>
                     <th>User Email</th>
                     <th>Designation</th>
                     <th>DOB</th>
                     <th>Contact No.</th>
                     <th>Experience (Years)</th>
                     <th>Joining Date</th>
                     <th>Status</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php if(!empty($inactive_user)){
                     foreach($inactive_user as $inactive){
                     $disable = ($inactive['status'] != 1)?'disabled':'';
                     $disableClass = ($inactive['status'] != 1)?'disableBtnClick':'';
                     $inactive['user_profile'] = $inactive['user_profile']!=''?$inactive['user_profile']:'dummy.jpg';
                     $statusChecked = $inactive['status']==1?'checked':'';
                     echo "<tr>
                     <td>".$inactive['id']."</td>
                     <td>".$inactive['name']."</td>
                     <td><img class='avatar' src='".base_url()."assets/modules/hrm/uploads/".$inactive['user_profile']."'></td>
                     <td>".$inactive['email']."</td>
                     <td>".$inactive['designation']."</td>
                     <td>".$inactive['age']."</td>
                     <td>".$inactive['contact_no']."</td>
                     <td>".$inactive['experience']."</td>
                     <td>".$inactive['date_joining']."</td>
                     <td>
                     <label class='switchChange'>           
                      <input type='checkbox' class='js-switch change_status ".$disableClass."' value='".$inactive['status']."' data-value='".$inactive['id']."' ". $statusChecked ." data-switchery='true' style='display: none;' />
                     </label>
                     </td>
                     <td>
                     <a href='".base_url()."hrm/editUser/".$inactive['id']."' class='btn btn-primary btn-xs'><i class='fa fa-folder'></i> View </a>                      
                     <a href='javascript:void(0)' class='delete_listing btn btn-danger btn-xs ".$disableClass."' data-href='".base_url()."users/delete/".$inactive['id']."'".$disable."><i class='fa fa-trash-o'></i> Delete </a>           
                     </td>
                     </tr>";
                     }
                     } ?>
               </tbody>
            </table>
         </div>
         <!-------------------------------------------End of inactive tab--------------------------------------------->
      </div>
   </div>
</div>
<!-- ----------------------------------- Grid View -------------------------------------- -->
<div id="gridview">
   <div role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a href="#user_grid_active" data-select='user_grid' id="userGridActiveTab" role="tab" data-toggle="tab" aria-expanded="true">Active</a></li>
         <li role="presentation" class=""><a href="#user_grid_inactive" data-select='user_grid' id="userGridInactiveTab" role="tab" data-toggle="tab" aria-expanded="true">Inactive</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <!----------------------------------Start of active grid tab------------------------------------------->
         <div role="tabpanel" class="tab-pane fade active in" id="user_grid_active" aria-labelledby="userGridActiveTab">
            <div class="x_content">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12 text-center"></div>
                  <div class="clearfix"></div>
                  <?php if(!empty($users)){       
                     foreach($users as $user){
						 $disable = ($_SESSION['loggedInUser']->role == 1) ?'':($user['role'] !=1 && $_SESSION['loggedInUser']->id == $user['id']?'':'disabled');
						 $disableClass = ($_SESSION['loggedInUser']->role == 1) ?'':($user['role'] !=1 && $_SESSION['loggedInUser']->id == $user['id']?'':'disableBtnClick');
						 $statusChecked = $user['status']==1?'checked':'';    
						 $hr_permissionsChecked = $user['hr_permissions']==1?'checked':''; 
						 if($user['user_profile'] != ''){
						  $user['user_profile'] = $user['user_profile'];
						 }else{
						  $user['user_profile'] = ($user['user_profile'] == '' && $user['gender'] =='Female')?'female_image_placeholder.jpg':'dummy.jpg';
						 }
                     // <h4 class="brief">Make HR Permissions: &nbsp;<label class="switchChange">            
                        //  <input type="checkbox" class="js-switch change_hr_permissions '.$disableClass.'" value="'.$user['hr_permissions'].'" data-value="'.$user['id'].'"'. $hr_permissionsChecked .' data-switchery="true" style="display: none;" '.$disable.'>
                        //</label> 
                       // </h4>
                     echo '<div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                     <div class="well profile_view">
                      <div class="col-sm-12">
                        <div class="left col-xs-7">
                        <h4 class="brief">Status: &nbsp;<label class="switchChange">            
                          <input type="checkbox" class="js-switch change_status '.$disableClass.'" value="'.$user['status'].'" data-value="'.$user['id'].'"'. $statusChecked .' data-switchery="true" style="display: none;" '.$disable.'>
                        </label> 
                        </h4>
                        
                        <h2>'.$user['name'].'</h2>
                        <p>'.$user['designation'].'</p>
                        <ul class="list-unstyled">
                          <li><strong>Email Id</strong>&nbsp;'.$user['email'].'</li>
                          <li><strong>Contact</strong>&nbsp;'.$user['contact_no'].'</li>
                          <li><strong>DOB</strong>&nbsp;'.$user['age'].'</li>
                          <li><strong>Experience</strong>&nbsp;'.$user['experience'].'</li>
                        </ul>
                        </div>
                        <div class="right col-xs-5">
                          <img src="'.base_url().'assets/modules/hrm/uploads/'.$user['user_profile'].'" alt="" class="img-circle img-responsive">
                        </div>
                      </div>
                      <div class="col-xs-12 bottom text-center">
                        <div class="col-xs-12 col-sm-6 emphasis">
                          <strong>Joining Date:</strong>&nbsp;'.$user["date_joining"].'
                        </div>
                        <div class="col-xs-12 col-sm-6 emphasis">
                          <a href="javascript:void(0)" class="delete_listing btn btn-danger btn-xs '.$disableClass.'" data-href="'.base_url().'users/delete/'.$user['id'].'" '.$disable.'><i class="fa fa-trash-o"></i> Delete </a>
                          <a href="'.base_url().'hrm/editUser/'.$user['id'].'" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a> 
                        </div>
                      </div> 
                     </div>
                     </div>';
				
				$output[] = array(
                        'Name' => $user['name'],
                        'Email' => $user['email'],
                        'Mobile number' => $user['contact_no'],
                        'Experience' => $user['experience'],
                        'Date of Joining' =>  date('d-m-Y',strtotime($user["date_joining"])),
                        'Designation' =>  $user["designation"],
                        'Gender' =>  $user["gender"],
                        'Email Status' =>  $user["email_status"],
                     );		 
					 
					 
			}
			
			
			$data3  = $output;
		
			export_csv_excel($data3);	
        }   ?>
               </div>
            </div>
         </div>
         <!-----------------------------end of active grid tab ------------------------------------------------->
         <!-------------------------------start of inactive tab----------------------------------------------->
         <div role="tabpanel" class="tab-pane fade" id="user_grid_inactive" aria-labelledby="userGridInactiveTab">
            <div class="x_content">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12 text-center"></div>
                  <div class="clearfix"></div>
                  <?php if(!empty($inactive_user)){       
                     foreach($inactive_user as $inactive){
                     $disable = ($_SESSION['loggedInUser']->role == 1) ?'':($inactive['role'] !=1 && $_SESSION['loggedInUser']->id == $inactive['id']?'':'disabled');
                     $disableClass = ($_SESSION['loggedInUser']->role == 1) ?'':($inactive['role'] !=1 && $_SESSION['loggedInUser']->id == $inactive['id']?'':'disableBtnClick');
                     $statusChecked = $inactive['status']==1?'checked':'';    
                     if($inactive['user_profile'] != ''){
                      $inactive['user_profile'] = $inactive['user_profile'];
                     }else{
                      $inactive['user_profile'] = ($inactive['user_profile'] == '' && $inactive['gender'] =='Female')?'female_image_placeholder.jpg':'dummy.jpg';
                     }                  
                     echo '<div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                      <div class="well profile_view">
                      <div class="col-sm-12">
                        <div class="left col-xs-7">
                        <h4 class="brief">Status: &nbsp;<label class="switchChange">            
                          <input type="checkbox" class="js-switch change_status '.$disableClass.'" value="'.$inactive['status'].'" data-value="'.$inactive['id'].'"'. $statusChecked .' data-switchery="true" style="display: none;" '.$disable.'>
                          </label>
                        </h4>
                        <h2>'.$inactive['name'].'</h2>
                        <p>'.$inactive['designation'].'</p>
                        <ul class="list-unstyled">
                          <li><strong>Email Id</strong>&nbsp;'.$inactive['email'].'</li>
                          <li><strong>Contact</strong>&nbsp;'.$inactive['contact_no'].'</li>
                          <li><strong>DOB</strong>&nbsp;'.$inactive['age'].'</li>
                          <li><strong>Experience</strong>&nbsp;'.$inactive['experience'].'</li>
                        </ul>
                        </div>
                        <div class="right col-xs-5">
                          <img src="'.base_url().'assets/modules/hrm/uploads/'.$inactive['user_profile'].'" alt="" class="img-circle img-responsive">
                        </div>
                      </div>
                      <div class="col-xs-12 bottom text-center">
                        <div class="col-xs-12 col-sm-6 emphasis">
                          <strong>Joining Date:</strong>&nbsp;'.$inactive["date_joining"].'
                        </div>
                        <div class="col-xs-12 col-sm-6 emphasis">
                          <a href="javascript:void(0)" class="delete_listing btn btn-danger btn-xs '.$disableClass.'" data-href="'.base_url().'users/delete/'.$inactive['id'].'" '.$disable.'><i class="fa fa-trash-o"></i> Delete </a>
                          <a href="'.base_url().'users/edit/'.$inactive['id'].'" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a> 
                        </div>
                      </div> 
                     </div>
                     </div>';
                     }
                     }   ?>             
               </div>
            </div>
         </div>
         <!-----------------------------------end of active tab------------------------------------------------->
      </div>
   </div>
</div>
</div>
<script>
   var country = '<?php echo json_encode($country); ?>';  
</script>