<form method="post" class="form-horizontal" enctype="multipart/form-data" id="JobApplication" novalidate="novalidate" style="">
<div class="col-md-12 col-sm-12 col-xs-12 ">				
				<div class="item form-group">
			
					<label class="col-md-3 col-sm-3 col-xs-12" >Name <span class="required">*</span>
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
		<?php if(!empty($job_application)){echo $job_application->name;} ?>	
					</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" >Email</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					<?php if(!empty($job_application)){echo $job_application->email;} ?>
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" >Phone no</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					<?php if(!empty($job_application)){echo $job_application->phone_no;} ?>
						</div>
				</div>
						<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Resume Upload</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
				  <?php if(!empty($job_application)){echo $job_application->resume_upload;} ?>
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Reference</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					<?php if(!empty($job_application)){echo $job_application->reference;} ?>
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Job Position</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						    <?php foreach($job_position as $job){?>
						   <?php if(!empty($job_application)){ if($job_application->job_position_id== $job->id){echo $job->designation;}}?>
					<?php }?>
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Short Intro</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						    <?php if(!empty($job_application)){echo $job_application->short_intro;} ?>
						</div>
</div>
<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Expected Salary</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					<?php if(!empty($job_application)){echo $job_application->exp_salary;} ?>
						</div>
				</div>
	<center>
	    	<div class="modal-footer">
						  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
						</div>
	</center>
	</form>

                        