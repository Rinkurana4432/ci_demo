<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveProcessType" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
	 <input type="hidden" name="id" value="<?php if($process_type && !empty($process_type)){ echo $process_type->id;} ?>">
	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class="control-label col-md-2 col-sm-2 col-xs-4" for="process_type">Process Type<span class="required">*</span> </label>
		<div class="col-md-10 col-sm-10 col-xs-8">
			<input type="text" id="process_type" name="process_type" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($process_type) && $process_type){ echo $process_type->process_type; }?>" required="required">
		</div>
	</div>
  
	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class="control-label col-md-2 col-sm-2 col-xs-4" for="description">Description</label>
		<div class="col-md-10 col-sm-10 col-xs-8">
			<textarea type="text" id="description" name="description" class="form-control col-md-7 col-xs-12"><?php if(!empty($process_type) && $process_type){ echo $process_type->description; }?></textarea>
		</div>
	</div>
	
	<div class="modal-footer">
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							  
	  <input type="submit" class="btn btn-warning" value="Submit">
	</div>
</form>