<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saveAccountFreeze" enctype="multipart/form-data" id="AccountGroupForm" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($get_account_freeze)) echo $get_account_freeze->id; ?>">





	<div class="item form-group">
		<label class="required control-label col-md-2 col-sm-2 col-xs-4" for="freze">Freeze select date<span class="required">*</span></label>
			<div class="col-md-8 col-sm-6 col-xs-12">
                <input type="text" id="freeze_date" name="freeze_date" class="form-control col-md-7 col-xs-12 delivery_date" placeholder="Select date" value="<?php if(!empty($get_account_freeze)){ echo $get_account_freeze->freeze_date; }?>">
            </div>
	</div> 
	
	<div class="ln_solid"></div>
	<div class="form-group">
		<div class="col-md-6 col-md-offset-3">
			<button type="reset" class="btn btn-default">Reset</button>
			<input type="submit" class="btn btn-warning" value="Submit"> </div>
	</div>
</form>