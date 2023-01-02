<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/savePipeLineDetails" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
	 <input type="hidden" name="id" value="<?php if(!empty($task_list_data)){ echo $task_list_data->id;} ?>">
	 <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
  
	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="work_detail">  Name</label>
		<div class="col-md-7 col-sm-10 col-xs-8">
			<?php if(!empty($task_list_data)){ echo $task_list_data->name;} ?>
		</div>
	</div>		
</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class="col-md-3 col-sm-3 col-xs-12" for="name">Status<span class="required">*</span></label>
		<div class="col-md-7 col-sm-9 col-xs-12">
		 <?php  $selected_1 ="";
		         $selected_0 ="";
   if(!empty($task_list_data)){
		       
		  if($task_list_data->status == '1'){
		     $selected_1 ="ON";
		  }
		  if($task_list_data->status == '0'){
		      $selected_0 ="OFF";
		  }
		  }
		 echo $selected_1;  echo $selected_0; ?>
			
		</div>
	</div>

<div  class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="description">  Mark Task Done </label>
		<div class="col-md-7 col-sm-10 col-xs-8">
		     <?php   $td_1 ="";
		         $td_0 ="";
if(!empty($task_list_data)){
		  if($task_list_data->task_done == '1'){
		     $td_1 ="Yes";
		  }
		  if($task_list_data->task_done == '0'){
		      $td_0 ="No";
		  }
  }
		  echo $td_1;  echo $td_0; ?> 
		  
 		</div>
	</div>							
</div>
</form>