<form method="post" class="form-horizontal" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
   <!--job card details-->
   <div class="col-md-12 col-sm-12 col-xs-12 ">
      <div class="item form-group">
         <input type="hidden" id="id" name="id" value="<?php if(!empty($job_position)){echo $job_position->id;} ?>"/>
         <label class="col-md-3 col-sm-3 col-xs-12" for="designation">Job title / Designation  <span class="required">*</span>
         </label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($job_position)){echo $job_position->designation;} ?>		
         </div>
         <label class="col-md-1 col-sm-3 col-xs-12" for="instrument">Requesting Department</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($job_position)){echo $job_position->department;} ?>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12">No.Positions Requested</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($job_position)){echo $job_position->no_position;} ?>
         </div>
         <label class="col-md-1 col-sm-3 col-xs-12">Employement Status</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($job_position)){
               $emp_type = "";
               if($job_position->emp_type=='full_time'){
               $emp_type = "Full Time";
               }elseif($job_position->emp_type=='contract'){
               $emp_type = "Contract";
               }elseif($job_position->emp_type=='other'){
               $emp_type = "Other";
               }
               echo $emp_type; 
               } ?>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12">HR Responsible</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($job_position)){echo $job_position->hr_responsible;} ?>
         </div>
         <label class="col-md-1 col-sm-3 col-xs-12">Website</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($job_position)){echo $job_position->website;} ?>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12">Work Location</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($job_position)){echo $job_position->location;} ?>
         </div>
         <label class="col-md-1 col-sm-3 col-xs-12">Salary Grade</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($job_position)){echo $job_position->expected_new_employee;} ?>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12">Position Reports to Designation</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($job_position)){echo $job_position->report;} ?>
         </div>
         <label class="col-md-1 col-sm-3 col-xs-12">Position Supervises</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($job_position)){echo $job_position->supervises;} ?>
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
      <div class="col-md-9 col-sm-9 col-xs-6"> <label for="qualification_detials" class="">
         <?php if(!empty($job_position)){
            $qualification_detials = "";
            if($job_position->qualification_detials=='diploma'){
            $qualification_detials = "Diploma";
            }elseif($job_position->qualification_detials=='graduation'){
            $qualification_detials = "Graduation";
            }elseif($job_position->qualification_detials=='post_graduation'){
            $qualification_detials = "Post Graduation";
            }
            echo $qualification_detials; 
            } ?></label> 
         <label for="qualification_detials" class="">Other</label> 
         <?php if(!empty($job_position)){echo $job_position->other_qualification;} ?>
      </div>
   </div>
   <div class="item form-group">
      <label class="col-md-2 col-sm-3 col-xs-12" for="designation">Experience Requirement 
      </label>
      <div class="col-md-5 col-sm-3 col-xs-6">
         <div class="col-md-12 item form-group">
            <label class="col-md-4">No of Years</label>  
            <div class="col-md-8"><?php if(!empty($job_position)){echo $job_position->exp_year;} ?>
            </div>
            <div class="col-md-12 item form-group">
               <label class="col-md-4" for="instrument">Specific fields</label>
               <div class="col-md-8"><?php if(!empty($job_position)){echo $job_position->specific_field;} ?></div>
            </div>
            <div class="col-md-12 item form-group">
               <label class="col-md-4" for="exp_details">Experience Details</label>
               <div class="col-md-8">
                  <?php if(!empty($job_position)){echo $job_position->exp_details;} ?>
               </div>
            </div>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12">Job Summary</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($job_position)){echo $job_position->job_summary;} ?>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12">Other Specfications, If any (Safety hazards etc)</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($job_position)){echo $job_position->other_specfications;} ?>
         </div>
      </div>
   </div>
   <hr />
   <div class="bottom-bdr"></div>
   <h3>Job Description</h3>
   <div id="print_div_content">
      <table id="example" class="table table-striped table-bordered" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
         <thead>
            <tr>
               <th>Sno.</th>
               <th>Responsiblities</th>
               <th>Skills</th>
               <th>Additional Skills</th>
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
               <td><?php echo $values->res;?> </td>
               <td><?php echo $values->skills;?></td>
               <td><?php echo $values->add_skills;?></td>
            </tr>
            <?php $i++;}}?>
         </tbody>
      </table>
   </div>
   <div class="bottom-bdr"></div>
   <h3>Headcount Requirements</h3>
   <p>(Kindly provide  details in applicable field)</p>
   <div class="col-md-12 col-sm-12 col-xs-12 ">
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12" for="expansion">Expansion/Growth</label>
         <div class="col-md-9 col-sm-9 col-xs-6">
            <label for="expansion" class="">
            <?php if(!empty($job_position)){
               $expansion = "";
               if($job_position->expansion=='yes'){
               $expansion = "Yes";
               }elseif($job_position->expansion=='no'){
               $expansion = "No";
               }
               echo $expansion; 
               } ?></label> 
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12" for="designation">Replacement of 
         </label>
         <div class="col-md-5 col-sm-3 col-xs-6">
            <div class="col-md-12 item form-group">
               <label class="col-md-4">Name</label>  
               <div class="col-md-8"><?php if(!empty($job_position)){echo $job_position->person_name;} ?></div>
            </div>
            <div class="col-md-12 item form-group">
               <label class="col-md-4" for="instrument">Designation</label>
               <div class="col-md-8"><?php if(!empty($job_position)){echo $job_position->person_designation;} ?></div>
            </div>
            <div class="col-md-12 item form-group">
               <label class="col-md-4" for="separation">Date of Separation</label>
               <div class="col-md-8">
                  <?php if(!empty($job_position)){echo $job_position->date_separation;} ?>
               </div>
            </div>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12">Other</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($job_position)){echo $job_position->headcount_other;} ?>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-2 col-sm-3 col-xs-12" for="headcount_AOP">Headcount AOP Approved</label>
         <div class="col-md-9 col-sm-9 col-xs-6">
            <?php if(!empty($job_position)){
               $headcount_AOP = "";
               if($job_position->headcount_AOP=='yes'){
               $headcount_AOP = "Yes";
               }elseif($job_position->headcount_AOP=='no'){
               $headcount_AOP = "No";
               }
               echo $headcount_AOP; 
               } ?>
         </div>
      </div>
   </div>
   <center>
      <div class="modal-footer">
         <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
      </div>
   </center>
</form>