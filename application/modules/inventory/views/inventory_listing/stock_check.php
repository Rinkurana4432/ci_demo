<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveInventoryListing" enctype="multipart/form-data" id="inventory_listing" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if($inventoryListing && !empty($inventoryListing)){ echo $inventoryListing->id; }?>">
		<input type="hidden" name="material_name_id" value="" id="material_id">
		<input type="hidden" name="material_type_id" value="" id="material_type_id">
			
			<div class="item form-group">
					<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="hidden" id="Actiontype" name="action_type"  class="form-control col-md-7 col-xs-12"  value="" readonly>
					</div>
			</div>	
			
			<!--<div class="item form-group">
				<div style="font-size:20px;" class="mat_name">Product Name:<b><span  id="material_name" style="color:green;"></span></b></div>
			</div>-->	
			 
            <h3 class="Material-head mat_name">Product Name:<b><span  id="material_name" style="color:green;"></span><hr></h3>
			 
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">				
				<div class="item form-group ">
					<div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
						<div class="panel panel-default">
							<div class="panel-heading"><h3 class="panel-title"><strong>Source Address</strong></h3></div>
								<table id="datatable-buttons" class="table table-striped table-bordered jambo_table bulk_action"  data-id="user">
									
										<tr>
											<th>
												<div class="col-md-12 item form-group">
													<label class="col-md-12 col-sm-12 col-xs-12" for="srcAddress">Source Address<span class="required">*</span></label>
												</div>
											</th>
											<th>
												<div class="col-md-12 item form-group">
													<label class="col-md-12 col-sm-12 col-xs-12" for="area">Area</label>
												</div>
											</th>
											<th>											
												<div class="col-md-12 item form-group">
													<label class="col-md-12 col-sm-12 col-xs-12" for="rack">Rack number</label>
												</div>	
											</th>
										</tr>
										
									<?php 
									if(!empty($inventoryListing) && $inventoryListing->location !=''){ 
										$sourceData = json_decode($inventoryListing->location);
											if(!empty($sourceData)){ 
												$i =  1;
												foreach($sourceData as $source_Data){
													$locationName=getNameById('location_settings',$source_Data->location,'id');	
										
										?>
										<tr>
										<td>
											<div class="col-md-12 col-sm-6 col-xs-12">
											<input type="hidden" id="address" name="source_location[]" class="form-control col-md-7 col-xs-12" placeholder="address" value="<?php  if(!empty($locationName)) {echo $locationName->location; } else{ echo "N/A" ;} ?>">
												<span><?php if(!empty($locationName)) { echo $locationName->location; } else{ echo "N/A" ;} ?></span>
											</div>
										</td>
										<td>
											<div class="col-md-12 col-sm-6 col-xs-12">
											<input type="hidden" id="area" name="source_storage[]" class="form-control col-md-7 col-xs-12" placeholder="area" value="<?php if(!empty($source_Data)) echo $source_Data->Storage; ?>">
											<?php if(!empty($source_Data)) echo $source_Data->Storage; ?>
											</div>
										</td>
										<td>
											<div class="col-md-12 col-sm-6 col-xs-12">
											<input type="hidden" id="rack_number" name="source_rack_no[]" class="form-control col-md-7 col-xs-12" placeholder="rack_number" value="<?php if(!empty($source_Data)) echo $source_Data->RackNumber; ?>">
											<?php if(!empty($source_Data)) echo $source_Data->RackNumber; ?>
											</div>
										</td>
										
										</tr>
										<?php $i++; }}}?>
										
									
								</table>
						</div>
					</div>
				</div>
			</div>		
		
			<div class=" vertical-border col-md-8" style="clear: both;">
			<div class="item form-group">
				<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Total Value<span class="required">*</span></label>
					<div class="col-md-8 col-sm-6 col-xs-12">
					<input type="number" id="value" name="total_qty" required="required" class="form-control col-md-7 col-xs-12" placeholder="i.e;3000" value="<?php if($inventoryListing && !empty($inventoryListing)){ echo $inventoryListing->closing_balance;} ?>">
					</div>
			</div>
			<div class="item form-group">
				<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Stock check value<span class="required">*</span></label>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<input type="number" id="stock_value" name="quantity" required="required" class="form-control col-md-7 col-xs-12" placeholder="i.e;3000" value="">
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<select class="form-control uom" name="uom" required="required">
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
			
          </div>			
			
			<hr>
				<div class="form-group">
					<div class="col-md-12 col-xs-12">
					   <center>
						<input type="reset" class="btn btn-default" value="Reset">
						<input type="submit" class="btn btn-warning" value="submit">
						<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>inventory/inventory_listing'">Cancel</a>
					   </center>
					</div>
				</div>	
</form>
						<!--</div>->


                  