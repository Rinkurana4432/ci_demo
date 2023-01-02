<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/savePipeLineDetails" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
	 <input type="hidden" name="id" value="<?php if(!empty($task_list_data)){ echo $task_list_data->id;} ?>">
	 <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
  
	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="work_detail">  Name<span class="required">*</span> </label>
		<div class="col-md-7 col-sm-10 col-xs-8">
			<input type="text" id="" name="name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($task_list_data)){ echo $task_list_data->name;} ?>" required="required">
		</div>
	</div>
  
 
					
</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
     
 

	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			
		<label class="col-md-3 col-sm-3 col-xs-12" for="name">Status<span class="required">*</span></label>
		<div class="col-md-7 col-sm-9 col-xs-12">
		 <?php 
		          $selected_1 ="";
		         $selected_0 ="";
   if(!empty($task_list_data)){
		       
		  if($task_list_data->status == '1'){
		     $selected_1 ="selected";
		  }
		  if($task_list_data->status == '0'){
		      $selected_0 ="selected";
		  }
		  }
		  ?>
			<select required class="form-control" name="status">
		<option value="">Select Option</option>
		 <option <?php echo $selected_1; ?> value="1"> ON</option>
		 <option <?php echo $selected_0; ?> value="0"> OFF</option>
			</select>
		</div>
	</div>

<div  class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="description">  Mark Task Done <span class="required">*</span></label>
		<div class="col-md-7 col-sm-10 col-xs-8">
		     <?php   $td_1 ="";
		         $td_0 ="";
if(!empty($task_list_data)){
		  if($task_list_data->task_done == '1'){
		     $td_1 ="selected";
		  }
		  if($task_list_data->task_done == '0'){
		      $td_0 ="selected";
		  }
  }
		  ?>
          <select required class="form-control" name="task_done">
		<option value="">Select Option</option>
	 <option <?php echo $td_1; ?> value="1"> Yes</option>
		 <option <?php echo $td_0; ?> value="0">No</option>
				</select>
		  
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