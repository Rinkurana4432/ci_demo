
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/save_job_position" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
   <!--job Identification details-->
   <h3>Job Identification </h3>
   <div class="col-md-12 col-sm-12 col-xs-12 ">
      <div class="item form-group">
         <input type="hidden" id="id" name="id" value="<?php if(!empty($job_position)){echo $job_position->id;} ?>"/>
         <label class="col-md-2 col-sm-3 col-xs-12" for="designation">Job title / Designation <span class="required">*</span>
         </label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input class="form-control col-md-7 col-xs-12" name="designation" required="required" type="text" value="<?php if(!empty($job_position)){echo $job_position->designation;} ?>">		
         </div>
         <label class="col-md-2 col-sm-3 col-xs-12" for="instrument">Requesting Department</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input id="ins" class="form-control col-md-7 col-xs-12" name="department" type="text" value="<?php if(!empty($job_position)){echo $job_position->department;} ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12" for="No.Positions Requested">No.Positions Requested</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input class="form-control col-md-7 col-xs-12" name="no_position" type="text" value="<?php if(!empty($job_position)){echo $job_position->no_position;} ?>">
         </div>
         <label class="col-md-2 col-sm-3 col-xs-12" for="Employement Status">Employement Status</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input  name="emp_type" type="radio" class="" <?php  if(!empty($job_position)){ if($job_position->emp_type=='full_time') echo "checked='checked'"; } ?> value="full_time" <?php echo $this->form_validation->set_radio('emp_type', 'full_time'); ?> />
            <label for="emp_type" class="">Full Time</label>
            <input  name="emp_type" type="radio" class="" <?php  if(!empty($job_position)){ if($job_position->emp_type=='contract') echo "checked='checked'"; } ?> value="contract" <?php echo $this->form_validation->set_radio('emp_type', 'contract'); ?> />
            <label for="emp_type" class="">Contract</label>
            <input  name="emp_type" type="radio" class="" <?php  if(!empty($job_position)){ if($job_position->emp_type=='other') echo "checked='checked'"; } ?> value="other" <?php echo $this->form_validation->set_radio('emp_type', 'other'); ?> />
            <label for="emp_type" class="">Others</label>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12">HR Responsible</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input class="form-control col-md-7 col-xs-12" name="hr_responsible" type="text" value="<?php if(!empty($job_position)){echo $job_position->hr_responsible;} ?>">
         </div>
         <label class="col-md-2 col-sm-3 col-xs-12">Website</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input class="form-control col-md-7 col-xs-12" name="website" type="url" value="<?php if(!empty($job_position)){echo $job_position->website;} ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12">Work Location</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input class="form-control col-md-7 col-xs-12" name="location" type="text" value="<?php if(!empty($job_position)){echo $job_position->location;} ?>">
         </div>
         <label class="col-md-2 col-sm-3 col-xs-12">Salary Grade</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input class="form-control col-md-7 col-xs-12" name="expected_new_employee" type="number" value="<?php if(!empty($job_position)){echo $job_position->expected_new_employee;} ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12">Position Reports to Designation</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input class="form-control col-md-7 col-xs-12" name="report" type="text" value="<?php if(!empty($job_position)){echo $job_position->report;} ?>">
         </div>
         <label class="col-md-2 col-sm-3 col-xs-12">Position Supervises</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input class="form-control col-md-7 col-xs-12" name="supervises" type="text" value="<?php if(!empty($job_position)){echo $job_position->supervises;} ?>">
         </div>
      </div>
   </div>
   <hr />
   <div class="bottom-bdr"></div>
   <!--Postion Requirements details-->
   <h3>Postion Requirements </h3>
   <div class="col-md-12 col-sm-12 col-xs-12 ">
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12" for="qualification_detials">Qualification Detials</label>
         <div class="col-md-9 col-sm-9 col-xs-6">
            <input  name="qualification_detials" type="radio" class="" <?php  if(!empty($job_position)){ if($job_position->qualification_detials=='diploma') echo "checked='checked'"; } ?> value="diploma" <?php echo $this->form_validation->set_radio('qualification_detials', 'diploma'); ?> />
            <label for="qualification_detials" class="">Diploma</label>
            <input  name="qualification_detials" type="radio" class="" <?php  if(!empty($job_position)){ if($job_position->qualification_detials=='graduation') echo "checked='checked'"; } ?> value="graduation" <?php echo $this->form_validation->set_radio('qualification_detials', 'graduation'); ?> />
            <label for="qualification_detials" class="">Graduation</label>
            <input name="qualification_detials" type="radio" class="" <?php  if(!empty($job_position)){ if($job_position->qualification_detials=='post_graduation') echo "checked='checked'"; } ?> value="post_graduation" <?php echo $this->form_validation->set_radio('qualification_detials', 'post_graduation'); ?> />
            <label for="qualification_detials" class="">Post Graduation</label>      
            <label for="qualification_detials" class="">Other</label>  
            <input class="" name="other_qualification"  type="text" value="<?php if(!empty($job_position)){echo $job_position->other_qualification;} ?>">		
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12" for="designation">Experience Requirement 
         </label>
         <div class="col-md-5 col-sm-3 col-xs-6">
            <div class="col-md-12 item form-group">
               <label class="col-md-4">No of Years</label>  
               <div class="col-md-8"><input class="form-control col-md-7 col-xs-12" name="exp_year" type="text" value="<?php if(!empty($job_position)){echo $job_position->exp_year;} ?>"></div>
            </div>
            <div class="col-md-12 item form-group">
               <label class="col-md-4" for="instrument">Specific fields</label>
               <div class="col-md-8"><input  class="form-control col-md-7 col-xs-12" name="specific_field" type="text" value="<?php if(!empty($job_position)){echo $job_position->specific_field;} ?>"></div>
            </div>
            <div class="col-md-12 item form-group">
               <label class="col-md-4" for="exp_details">Experience Details</label>
               <div class="col-md-8">
                  <textarea name='exp_details' class="form-control col-md-7 col-xs-12"><?php if(!empty($job_position)){echo $job_position->exp_details;} ?></textarea>
               </div>
            </div>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12">Job Summary</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <textarea name='job_summary' class="form-control col-md-7 col-xs-12"><?php if(!empty($job_position)){echo $job_position->job_summary;} ?></textarea>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12">Other Specfications, If any (Safety hazards etc)</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <textarea name='other_specfications' class="form-control col-md-7 col-xs-12"><?php if(!empty($job_position)){echo $job_position->other_specfications;} ?></textarea>
         </div>
      </div>
   </div>
   <hr />
   <div class="bottom-bdr"></div>
   <h3>Job Description</h3>
   <button type="button" class="btn btn-primary" onclick="add_row();">Add Row</button>
   <div id="print_div_content">
      <table id="example" class="table table-striped table-bordered" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
         <thead>
            <tr>
               <th>Sno.</th>
               <th>Responsiblities</th>
               <th>Skills</th>
               <th>Additional Skills</th>
               <th></th>
            </tr>
         </thead>
         <tbody id="table_data">
            <?php if(!empty($job_position)){
               $val=json_decode($job_position->job_description);}
               if(!empty($val)){
                $i=1;
                foreach($val as $values){?>
            <tr>
               <td class="sno"><?php echo $i;?></td>
               <td><input type="text" name="res[]" value="<?php echo $values->res;?>"> </td>
               <td><input type="text" name="skills[]" value="<?php echo $values->skills;?>"> </td>
               <td><input type="text" name="add_skills[]" value="<?php echo $values->add_skills;?>"> </td>
               <td><button type="button" onclick="remove_row1(this);">X</button></td>
            </tr>
            <?php $i++;}}else{?>
            <?php }?>
         </tbody>
      </table>
   </div>
   <hr />
   <div class="bottom-bdr"></div>
   <h3>Headcount Requirements</h3>
   <p>(Kindly provide  details in applicable field)</p>
   <div class="col-md-12 col-sm-12 col-xs-12 ">
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12" for="expansion">Expansion/Growth</label>
         <div class="col-md-9 col-sm-9 col-xs-6">
            <input name="expansion" type="radio" class="" <?php  if(!empty($job_position)){ if($job_position->expansion=='yes') echo "checked='checked'"; } ?> value="yes" <?php echo $this->form_validation->set_radio('expansion', 'yes'); ?> />
            <label for="expansion" class="">Yes</label>
            <input name="expansion" type="radio" class="" <?php  if(!empty($job_position)){ if($job_position->expansion=='no') echo "checked='checked'"; } ?> value="no" <?php echo $this->form_validation->set_radio('expansion', 'no'); ?> />
            <label for="expansion" class="">No</label>	
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12" for="designation">Replacement of 
         </label>
         <div class="col-md-5 col-sm-3 col-xs-6">
            <div class="col-md-12 item form-group">
               <label class="col-md-4">Name</label>  
               <div class="col-md-8"><input class="form-control col-md-7 col-xs-12" name="person_name" type="text" value="<?php if(!empty($job_position)){echo $job_position->person_name;} ?>"></div>
            </div>
            <div class="col-md-12 item form-group">
               <label class="col-md-4" for="instrument">Designation</label>
               <div class="col-md-8"><input  class="form-control col-md-7 col-xs-12" name="person_designation" type="text" value="<?php if(!empty($job_position)){echo $job_position->person_designation;} ?>"></div>
            </div>
            <div class="col-md-12 item form-group">
               <label class="col-md-4" for="separation">Date of Separation</label>
          		<div class="col-md-8 col-sm-8 col-xs-12">           
					<div class="input-group date" data-provide="datepicker">
						<input type="text" class="form-control" name="date_separation" value="<?php if(!empty($job_position)){echo $job_position->date_separation;} ?>" placeholder="Date Of Separation">
						<div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
						  </div>
					</div>         
				</div>
            </div>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12">Other</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input class="form-control col-md-7 col-xs-12" name="headcount_other" type="text" value="<?php if(!empty($job_position)){echo $job_position->headcount_other;} ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12" for="expansion">Headcount AOP Approved</label>
         <div class="col-md-9 col-sm-9 col-xs-6">
            <input name="headcount_AOP" type="radio" class="" <?php  if(!empty($job_position)){ if($job_position->headcount_AOP=='yes') echo "checked='checked'"; } ?> value="yes" <?php echo $this->form_validation->set_radio('headcount_AOP', 'yes'); ?> />
            <label for="headcount_AOP" class="">Yes</label>
            <input name="headcount_AOP" type="radio" class="" <?php  if(!empty($job_position)){ if($job_position->headcount_AOP=='no') echo "checked='checked'"; } ?> value="no" <?php echo $this->form_validation->set_radio('headcount_AOP', 'no'); ?> />
            <label for="headcount_AOP" class="">No</label>	
         </div>
      </div>
   </div>
   <center>
      <div class="modal-footer">
         <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>
         <input type="submit" class="btn btn edit-end-btn" value="Submit">
      </div>
   </center>
</form>
