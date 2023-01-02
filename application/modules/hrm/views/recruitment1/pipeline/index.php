
<?php if($this->session->flashdata('message') != ''){?>                        
    <div class="alert alert-success col-md-6">                            
      <?php echo $this->session->flashdata('message');?>
    </div>                        
<?php }?>
<div class="x_content" style="overflow:auto;">
<p class="text-muted font-13 m-b-30"></p>    
<div class="container-fluid" style="">
    	 <form method="post" action="<?php echo base_url() ?>quality_control/job_position_pipeline/">
<div class="col-md-6 col-sm-6 col-xs-6 ">
	<div class="item form-group">
					<label class="col-md-1 col-sm-1 col-xs-1">Job Position</label>
						<div class="col-md-2 col-sm-2 col-xs-2">
						    <select class="form-control col-md-4 col-xs-8"  name="job_position_id">
						        <option>Select</option>
						    <?php foreach($job_position as $job){?>
						    <option value="<?php echo $job->id; ?>" ><?php echo $job->designation; ?></option>
					<?php }?>
					      </select> 
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2">
			 <input type="submit" class="btn" value="Search"></div>
				</div>			
			</div>	
		</form> <br>
<div class="dragg">
    <div id="sortableKanbanBoards" class="row">
<?php 
  if(!empty($processdata)){
    $i= 0;
  foreach($processdata as $process_data){ ?>
  <input type="hidden" name="status" id="status" value="<?php echo $process_data['types']['status'];?>"/>
            <div class="panel panel-primary kanban-col" id="leadStyatus_<?php  echo $i; ?>" data-name="<?php echo $process_data['types']['status'];?>">
                <div class="panel-heading">
            <?php echo $process_data['types']['status'];?><span style="text-align:  left;" class="total11">
            </span>
            <i class="fa fa-2 fa-chevron-up pull-right process"></i>
                </div>
                <div class="panel-body" style="height: 100px;" >
                    <div id="<?php echo $process_data['types']['id'];?>" class="kanban-centered">
                         <?php  foreach($process_data['process'] as $pd){?>
                        <article class="kanban-entry grab process" id="<?php echo $pd['id'];?>" draggable="true" data-id="<?php //echo $pd['order_id'];?>">
                            <div class="kanban-entry-inner">
                    <div class="kanban-label" style="cursor: -webkit-grab;">
                    <h2>
                      <button type="button" data-id="viewJobApplication" data-tooltip="View" data-id="<?php echo $pd["id"]; ?>" class="btn btn-edit btn-xs qualityTab pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-pencil"></i></button>
                     </h2>
                    <p><?php echo $pd['name'];?>
                    <?php if($process_data['types']['status']=='Contract proposal'){
                    $chk=$this->hrm_model->chk_usr('user','email',$pd['email']);
                  if($chk=='1'){?>
           <button type="button" class="btn btn-warning">Converted</button>
                    <?php }else {?>
       <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bs-example-modal-lg">Convert to User</button>
						 <?php }}?>
                    </p>
                      </div>
                            </div>
                        </article>
        <?php }?>     
                    </div>
                  
                </div>
                <div class="panel-footer"> <a href="#"></a>
                </div>
            </div>
    <?php 
$i++;
  } 
} ?>   
 </div>
    </div>
</div>  
</div>
  
   <div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-refresh fa-5x fa-spin"></i>
                        <h4>Processing...</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
						<h3 class="Material-head" style="margin-bottom: 30px;">General Profile<hr></h3>
						<div class="col-md-6 col-sm-12 col-xs-12 form-group">
						 <input type="hidden" name="id" value="">										
							<input type="hidden" name="u_id" value="">	
							<input type="hidden" name="c_id" value="<?php  echo $_SESSION['loggedInUser']->c_id;?>">
							<input type="hidden" name="save_status" value="1" class="save_status">	
							<div class=" panel-default">
								<div class="panel-body vertical-border">
									<div class="item form-group">												
										<label class="col-md-3 col-sm-3 col-xs-12" for="name">User Name<span class="required">*</span></label>
										<div class="col-md-6 col-sm-5 col-xs-12">												
					<input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"  name="name" placeholder="both name(s) e.g Jon Doe" required="required" type="text" value="<?php $this->hrm_model->get_name('job_application',$pd['name'],'name');?>
">
										</div>											
									</div>											
									<div class="item form-group">												
										<label class="col-md-3 col-sm-3 col-xs-12" for="email">Email<span class="required">*</span></label>
										  <div class="col-md-6 col-sm-5 col-xs-12">												
											<input type="email" id="email" required="required" name="email"  class="form-control col-md-7 col-xs-12" placeholder="Enter email" value="<?php $this->hrm_model->get_name('job_application',$pd['name'],'email');?>">
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
											<input type="tel" id="telephone" name="contact_no" required="required" data-validate-length-range="8,10" class="form-control col-md-7 col-xs-12" placeholder="Enter mobile number" value="<?php $this->hrm_model->get_name('job_application',$pd['name'],'phone_no');?>">
										</div>												
									</div>
									<div class="item form-group">													
										<label class="col-md-3 col-sm-3 col-xs-12" for="age">Date of Birth<span class="required">*</span>	</label>
										<div class="col-md-6 col-sm-5 col-xs-12">														
											<input type="text" id="date" required="required" name="age" class="form-control col-md-7 col-xs-12 has-feedback-left" data-validation="date" value="" placeholder="Date Of Birth" aria-describedby="inputSuccess2Status4">
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
													<div class="col-md-6 col-sm-12 col-xs-12 form-group">
													<textarea id="address" name="correspondance_address" class="form-control col-md-7 col-xs-12" placeholder="Address"></textarea>
													</div>
												 </div>
												 <div class="item form-group">
												     <label class="col-md-3 col-sm-4 col-xs-4" for="billing_country">zipcode</label>
												      <div class="col-md-6 col-sm-12 col-xs-12 form-group">
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
<hr>
<div class="bottom-bdr"></div>		
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">											
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						<h3 class="Material-head" style="margin-bottom: 30px;">Qualification<hr></h3>
							<div class=" panel-default">								
								<div class="panel-body quaification_wrapper">
								  <div class="col-sm-12  col-md-12 label-box mobile-view2">
									   <label class="col-md-3 col-sm-12 col-xs-12 ">Qualification</label>
									   <label class="col-md-3 col-sm-12 col-xs-12 ">University</label>
									   <label class="col-md-3 col-sm-12 col-xs-12 ">Year of Passing</label>
									   <label style=" border-right: 1px solid #c1c1c1 !important;" class="col-md-3 col-sm-12 col-xs-12">Percentage</label>
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
									   <label class="col-md-2 col-sm-12 col-xs-12 ">Company Name</label>
									   <label class="col-md-2 col-sm-12 col-xs-12 ">Location</label>
									   <label class="col-md-2 col-sm-12 col-xs-12 ">Position</label>
									   <label class="col-md-3 col-sm-12 col-xs-12 ">Work Period</label>
									   <label style=" border-right: 1px solid #c1c1c1 !important;" class="col-md-3 col-sm-12 col-xs-12">Responsibilities</label>
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
										<div class="col-md-5 col-sm-8 col-xs-12 form-group">
											<input type="text"  name="skill_name[]" class="form-control col-md-7 skill_section" placeholder="Name" value="">
										</div>
										<div class="col-md-3 col-sm-12 col-xs-12 form-group">
											<input type="number"  name="skill_count[]" class="form-control col-md-1 skill_section" placeholder="Count" value="">
										</div>										
											<button class="btn btn-primary add_skill_button" type="button"><i class="fa fa-plus"></i></button>										
									</div>
								</div>
							</div>
						</div>	
						<div class="bottom-bdr"></div>
							<div class="col-md-6 col-sm-12 col-xs-12 form-group">
							<div class=" panel-default">
								<h3 class="Material-head" style="margin-bottom: 30px;">Documents<hr></h3>
								<div class="panel-body image_wrapper">
									<div class="col-md-12 input_image_wrap item vertical-border">
                                        <label class="col-md-3 col-sm-3 col-xs-12" for="name">Document Upload </label>									
										<div class="col-md-5 col-sm-8 col-xs-12 form-group">
												<input type="file" class="form-control col-md-7 col-xs-12" name="doc_upload[]">
										</div>										
											<button class="btn btn-primary add_images_button" type="button"><i class="fa fa-plus"></i></button>										
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

<div id="quality_modal" class="modal fade in"  role="dialog">
  <div class="modal-dialog modal-lg modal-large">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title nxt_cls" id="myModalLabel">Job Details</h4>
      </div>
      <div class="modal-body-content"></div>
    </div>
  </div>
</div>