<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/save_job_position" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
			<!--job card details-->
<div class="col-md-12 col-sm-12 col-xs-12 ">				
				<div class="item form-group">
				    <input type="hidden" id="id" name="id" value="<?php if(!empty($job_position)){echo $job_position->id;} ?>"/>
					<label class="col-md-3 col-sm-3 col-xs-12" for="designation">Designation <span class="required">*</span>
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
				<input class="form-control col-md-7 col-xs-12" name="designation" required="required" type="text" value="<?php if(!empty($job_position)){echo $job_position->designation;} ?>">		
					</div>
					<label class="col-md-1 col-sm-3 col-xs-12" for="instrument">Department</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input id="ins" class="form-control col-md-7 col-xs-12" name="department" type="text" value="<?php if(!empty($job_position)){echo $job_position->department;} ?>">
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">HR Responsible</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control col-md-7 col-xs-12" name="hr_responsible" type="text" value="<?php if(!empty($job_position)){echo $job_position->hr_responsible;} ?>">
						</div>
							<label class="col-md-1 col-sm-3 col-xs-12">Website</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control col-md-7 col-xs-12" name="website" type="url" value="<?php if(!empty($job_position)){echo $job_position->website;} ?>">
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Location</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control col-md-7 col-xs-12" name="location" type="text" value="<?php if(!empty($job_position)){echo $job_position->location;} ?>">
						</div>
							<label class="col-md-1 col-sm-3 col-xs-12">Expected new employees</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control col-md-7 col-xs-12" name="expected_new_employee" type="number" value="<?php if(!empty($job_position)){echo $job_position->expected_new_employee;} ?>">
						</div>
				</div>
				
</div>
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
	<center>
	   <div class="modal-footer">
		 <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
		 <input type="submit" class="btn btn edit-end-btn " value="Submit">
		</div>
	</center>

	</form>
                        