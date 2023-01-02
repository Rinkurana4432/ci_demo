<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/save_job_application" enctype="multipart/form-data" id="JobApplication" novalidate="novalidate" style="">
<div class="col-md-12 col-sm-12 col-xs-12 ">				
				<div class="item form-group">
				<input type="hidden" id="id" name="id" value="<?php if(!empty($job_application)){echo $job_application->id;} ?>"/>
					<label class="col-md-3 col-sm-3 col-xs-12" >Name <span class="required">*</span>
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
			<input id="para" class="form-control col-md-7 col-xs-12" name="name" value="<?php if(!empty($job_application)){echo $job_application->name;} ?>" type="text" required>		
					</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" >Email</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input id="ins" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($job_application)){echo $job_application->email;} ?>" name="email" type="email" >
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" >Phone no</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control col-md-7 col-xs-12" name="phone_no" value="<?php if(!empty($job_application)){echo $job_application->phone_no;} ?>" type="number" >
						</div>
				</div>
						<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Resume Upload</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control col-md-7 col-xs-12" name="resume_upload" type="file"><?php if(!empty($job_application)){echo $job_application->resume_upload;} ?>
							<input name="resume_upload1" type="hidden" value="<?php if(!empty($job_application)){echo $job_application->resume_upload;} ?>">
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Reference</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control col-md-7 col-xs-12" name="reference" type="text" value="<?php if(!empty($job_application)){echo $job_application->reference;} ?>">
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Job Position<span class="required">*</span></label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						    <select class="form-control col-md-7 col-xs-12"  name="job_position_id" required>
						        <option>Select</option>
						    <?php foreach($job_position as $job){?>
						    <option value="<?php echo $job->id; ?>" <?php if(!empty($job_application)){ if($job_application->job_position_id== $job->id){echo 'selected';}}?>><?php echo $job->designation; ?></option>
					<?php }?>
					      </select> 
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Short Intro</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						    <textarea name="short_intro" class="form-control col-md-7 col-xs-12" rows="4" cols="12"><?php if(!empty($job_application)){echo $job_application->short_intro;} ?></textarea>
						</div>
				</div>	
					<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Expected Salary</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control col-md-7 col-xs-12" name="exp_salary" type="number" value="<?php if(!empty($job_application)){echo $job_application->exp_salary;} ?>">
						</div>
				</div>
	<center>
	    	<div class="modal-footer">
						  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>
						  <input type="submit" class="btn btn edit-end-btn " value="Submit">
						</div>
	</center>
	</form>

                        