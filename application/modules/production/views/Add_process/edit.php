<div class="x_content">				
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveAddProcess" enctype="multipart/form-data" id="myform" novalidate="novalidate">
        <input type="hidden" name="id" value="<?php if($Addprocess && !empty($Addprocess)){ echo $Addprocess->id;} ?>">
		<div class="item form-group">								
			<div class="col-md-3 col-sm-6 col-xs-12 col-md-offset-2">
				<select class="form-control" name="process_type_id">
					<option>Select Process Type</option>
					<?php if(!empty($processType)){
							foreach($processType as $process_type){ ?>
								<option value="<?php echo $process_type['id']; ?>" <?php if(!empty($Addprocess) && $Addprocess->process_type_id == $process_type['id']) echo 'selected';?>><?php echo $process_type['process_type_id']; ?></option>
							<?php }
						} ?>
				</select>
			</div>
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="material_name">Material Name <span class="required">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">
				<input type="text" id="addProcess" name="Add_Process" required="required" class="form-control col-md-7 col-xs-12" placeholder="Material name" value="<?php if(!empty($Addprocess)) echo $Addprocess->Add_Process; ?>">
			</div>
		</div>	
		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-6 col-md-offset-3">
				<button type="reset" class="btn btn-default">Reset</button>
				<button id="send" type="submit" class="btn btn-warning">Submit</button>
				<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>production/Add Process'">Cancel</a>
			</div>
		</div>
    </form>
	<table id="datatable-buttons" class="table table-striped table-bordered account_index" data-id="account">
		<thead>
			<tr>
				<th>id</th>
				<th>Process Type</th>
				<th>Process</th>
			</tr>
		</thead>
		<tbody>
			<?php if(!empty($addProcess)){
					foreach($addProcess as $add_process){    ?>
						<tr>
							<th><?php echo $add_process['id']; ?></th>
							<th><?php echo $add_process['process_type_id']; ?></th>
							<th><?php echo $add_process['Add_Process']; ?></th>
						</tr>
			<?php 	}
			}?>
		</tbody>                               
	</table>
</div>