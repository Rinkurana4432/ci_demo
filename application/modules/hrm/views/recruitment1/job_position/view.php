<form method="post" class="form-horizontal" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
			<!--job card details-->
<div class="col-md-12 col-sm-12 col-xs-12 ">				
				<div class="item form-group">
				    <input type="hidden" id="id" name="id" value="<?php if(!empty($job_position)){echo $job_position->id;} ?>"/>
					<label class="col-md-3 col-sm-3 col-xs-12" for="designation">Designation <span class="required">*</span>
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
			<?php if(!empty($job_position)){echo $job_position->designation;} ?>		
					</div>
					<label class="col-md-1 col-sm-3 col-xs-12" for="instrument">Department</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					<?php if(!empty($job_position)){echo $job_position->department;} ?>
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
					<label class="col-md-3 col-sm-3 col-xs-12">Location</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					<?php if(!empty($job_position)){echo $job_position->location;} ?>
						</div>
							<label class="col-md-1 col-sm-3 col-xs-12">Expected new employees</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					<?php if(!empty($job_position)){echo $job_position->expected_new_employee;} ?>
						</div>
				</div>
</div>
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
	<center>
	   <div class="modal-footer">
		 <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
		</div>
	</center>
	</form>
                        