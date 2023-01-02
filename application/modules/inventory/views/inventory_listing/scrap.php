<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveInventoryListing" enctype="multipart/form-data" id="inventory_listing" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if($inventoryListing && !empty($inventoryListing)){ echo $inventoryListing->id; }?>">
	<input type="hidden" name="material_name_id" value="" id="material_id">
	<input type="hidden" name="material_type_id" value="" id="material_type_id">
	
	
		<div class="item form-group">			
			<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="hidden"  name="action_type" class="form-control col-md-7 col-xs-12" id="Actiontype" readonly>
			</div>
		</div>
		<h3 class="Material-head">Product Name:<b><span  id="material_name" style="color:green;"></span><hr></h3>
		
		<!--<div class="item form-group">
			<div style="font-size:20px;" class="scrap_mat_name">Product Name:<b><span  id="material_name" style="color:green;"></span></b></div>
		</div>-->
		
		<span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span>
<div class="vertical-border">
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="mat_name">Scrap Value<span class="required">*</span></label>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<input type="number" id="qty" name="quantity" required="required" class="form-control col-md-7 col-xs-12 keyup_check_qty qty" placeholder="">
				</div>
					
				<div class="col-md-3 col-sm-6 col-xs-12">
					<select class="form-control uom" name="uom" required="required" id="uom">
						<option>Unit of Measurement</option>
							<?php 
							$checked ='';			
							$uom = getUom();											  
								foreach($uom as $unit) {												 
									if((!empty($inventoryListing)) && ($inventoryListing->uom == $unit)){ $checked = 'selected';}else{$checked = '';  }				
									echo "<option value='".$unit."' ".$checked.">".$unit."</option>";												
								}											
							?>									
					</select>	
				</div>
		</div>		
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="mat_name">Reason<span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<textarea id="reason" name="reason" required="required" class="form-control col-md-7 col-xs-12" placeholder="reason for scrap"></textarea>
				</div>
		</div>
</div>				
<hr>
			<div class="form-group">
				<div class="col-md-12 col-xs-12">
				   <center>
					<input type="reset" class="btn btn-default" value="Reset">
					<input type="submit" class="btn btn-warning check_mat_qty" value="submit">
					<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>inventory/inventory_listing'">Cancel</a>
					</center>
				</div>
			</div>	
</form>
						<!--</div>->


                  