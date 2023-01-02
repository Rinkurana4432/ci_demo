<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/saveRoleDetails" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
	 <input type="hidden" name="id" value="<?php if(!empty($task_list_role_data)){ echo $task_list_role_data->id;} ?>">
	  <input type="hidden" value="<?php  echo $this->companyGroupId; ?>" id="loggedUser">
	 <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
  
	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="work_detail">  Name<span class="required">*</span> </label>
		<div class="col-md-7 col-sm-10 col-xs-8">
			<input type="text" id="" name="name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($task_list_role_data)){ echo $task_list_role_data->name;} ?>" required="required">
		</div>
	</div>
  
     
</div>
	
	<div class="modal-footer">
	<center>
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							  
	  <input type="submit" class="btn btn-warning" value="Submit">
	 </center>
	</div>
</form>