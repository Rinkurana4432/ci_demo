<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saveParentGroup" enctype="multipart/form-data" id="AccountGroupForm" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($parent_groups)) echo $parent_groups->id; ?>">
	<div class="item form-group">

		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Parent Account Name<span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"  value="<?php if(!empty($parent_groups)) echo $parent_groups->name; ?>" name="name" required="required" type="text"> </div>
	</div>	
	
	<div class="ln_solid"></div>
	<div class="form-group">
		<div class="col-md-6 col-md-offset-3">
			<button type="reset" class="btn btn-default">Reset</button>
			<input type="submit" class="btn btn-warning" value="Submit"> </div>
	</div>
</form>