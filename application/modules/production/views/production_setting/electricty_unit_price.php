

<div class="x_content">				
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/save_electricity_unit" enctype="multipart/form-data" id="myform"" novalidate="novalidate">
        <input type="hidden" name="id" value="<?php  if($unit_price && !empty($unit_price)){ echo $unit_price->id;} ?>">
		<div class="item form-group">
				<label class="control-label col-md-2 col-sm-2 col-xs-12">Electricity Unit Price</label>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<input id="electr_unit_price" class="form-control col-md-7 col-xs-12" name="electr_unit_price" placeholder="electrcity unit price"  type="number" value="<?php if(!empty($unit_price)){echo $unit_price->electr_unit_price;}?>" >	
				</div>
			</div>
		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-6 col-md-offset-3">
				<button type="reset" class="btn btn-default">Reset</button>
				<button id="send" type="submit" class="btn btn-warning">Submit</button>
				<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>production/production_setting'">Cancel</a>
			</div>
		</div>
    </form>
	
</div>