

<div class="x_content">				
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/save_purchase_budget" enctype="multipart/form-data" id="myform"" novalidate="novalidate">
        <input type="hidden" name="id" value="<?php if(!empty($purchase_budget)){echo $purchase_budget->id; }?>">
		<!--<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="materail_type">Material Type<span class="required" style="color:red;">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<select class="form-control selectAjaxOption select2 select2-hidden-accessible" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php //echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0"  id="material_type">
						<option value="">Select Option</option>
							<?php /*if(!empty($materials)){
									$material_type_id = getNameById('material_type',$materials->material_type_id,'id');
									echo '<option value="'.$materials->material_type_id.'" material_type_prefix="'.$material_type_id->prefix.'" selected >'.$material_type_id->name.'</option>';
							}*/?>
					</select>
				</div>
		</div>-->
		
		
		
		
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Budget">Budget</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="budget" class="form-control col-md-7 col-xs-12" name="budget" placeholder="budget"  type="text" value="<?php if(!empty($purchase_budget)){echo $purchase_budget->budget; }?>" >	
				</div>
		</div>
		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-6 col-md-offset-3">
				<button type="reset" class="btn btn-default">Reset</button>
				<button id="send" type="submit" class="btn btn-warning">Submit</button>
				<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>purchase/purchase_setting'">Cancel</a>
			</div>
		</div>
    </form>
	
</div>