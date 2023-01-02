<div class="x_content">				
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/save_machine_group_name" enctype="multipart/form-data" id="myform" novalidate="novalidate">
        <input type="hidden" name="id" value="<?php  if($machine_group && !empty($machine_group)){ echo $machine_group->id;} ?>">
		
		<div class="col-md-6 col-sm-12 col-xs-12 vertical-border ">
			<label class="col-md-3 col-sm-3 col-xs-12" for="machine_group_name">Machine Group Name<span class="required">*</span></label>
			<?php if(empty($machine_group)){?>
			<div>
			<div class="col-md-9 col-sm-6 col-xs-12 add_more_group">
				<div class="col-md-7 col-sm-6 col-xs-12 ">
					<input type="text"  class="form-control col-md-7 col-xs-12" name="machine_group_name[]" required value="<?php //if($machine_group && !empty($machine_group)){ echo $machine_group->machine_group_name;} ?>">	
				</div>
				<!--button class="btn edit-end-btn addMoreMachineGroupBtn plus-btn plus-btn" type="button"><i class="fa fa-plus"></i></button-->
			</div>
			</div>
			<?php } else{?>
				<div class="col-md-9 col-sm-6 col-xs-12 add_more_group">
				<div class="col-md-7 col-sm-6 col-xs-12 ">
					<input type="text"  class="form-control col-md-7 col-xs-12" name="machine_group_name" required value="<?php if($machine_group && !empty($machine_group)){ echo $machine_group->machine_group_name;} ?>">	
				</div>
				
			</div>
			<?php }?>
		</div>
		
		<hr>
		<div class="bottom-bdr"></div>
		<div class="form-group">
			<div class="col-md-6 col-md-offset-3">
				<button type="reset" class="btn btn-default">Reset</button>
				<button id="send" type="submit" class="btn btn-warning">Submit</button>
				<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>production/production_setting'">Cancel</a>
			</div>
		</div>
    </form>
	
</div>