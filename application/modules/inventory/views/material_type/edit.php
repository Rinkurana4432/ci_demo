<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveMaterialType" enctype="multipart/form-data" id="materialForm" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($materialType)) echo $materialType->id; ?>">
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">Material Type</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="material_type" class="form-control col-md-7 col-xs-12" name="name" placeholder="Material type" type="text" value="<?php if(!empty($materialType)) echo $materialType->name;?>" id="material_type" >
					
				</div>
		</div>
	
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">Material Type</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="prefix" class="form-control col-md-7 col-xs-12" name="prefix" placeholder="Prefix" type="text" value="<?php if(!empty($materialType)) echo $materialType->prefix;?>" id="prefix" readonly>
				</div>
		</div>
	
	
	
	<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-6 col-md-offset-3">
				<input type="reset" class="btn btn-default" value="Reset">
					<input type="submit" class="btn btn-warning signUpBtn" value="submit">
						<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>inventory/material_type'">Cancel</a>
			</div>
		</div>
</form>					
		