<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>

<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveInventoryListing" enctype="multipart/form-data" id="inventory_listing" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if($inventoryListing && !empty($inventoryListing)){ echo $inventoryListing->id; }?>">
	<input type="hidden" name="material_name_id" value="" id="material_id">
		<input type="hidden" name="material_type_id" value="" id="material_type_id">
		<div class="item form-group">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="hidden" id="Actiontype" name="action_type" class="form-control col-md-7 col-xs-12"  value="" readonly>
			</div>
		</div>						
		<!--<div class="item form-group">
			<div style="font-size:20px;">Product Name:<b><span  class="material_name" ></span></b></div>
		</div>-->		
        <h3 class="Material-head">Product Name :<span  class="material_name" ></span><hr></h3>		
				
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
				<div class="item form-group" >
					<div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><strong>Source Address</strong></h3></div>
						<table id="datatable-buttons" class="table table-striped table-bordered jambo_table bulk_action"  data-id="user">
							<tr>
								<th>
								<div class="col-md-12 item form-group">
								<label class="col-md-12 col-sm-12 col-xs-12" for="srcAddress">Source Address<span class="required"></span></label>
								</div>
								</th>
								<th>
								<div class="col-md-12 item form-group">
								<label class="col-md-12 col-sm-12 col-xs-12" for="area">Area<span class="required"></span></label>
								</div>	
								</th>
								<th>
								<div class="col-md-12 item form-group">
								<label class="col-md-12 col-sm-12 col-xs-12" for="rack">Rack number<span class="required"></span></label>
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
									<input type="hidden" id="address" name="source_location[]" class="form-control col-md-7 col-xs-12" placeholder="address" value="<?php  if(!empty($locationName)){echo $locationName->location; } else{ echo "N/A";}?>">
										<span><?php  if(!empty($locationName)){echo $locationName->location; } else{ echo "N/A";} ?></span>
									</div>
									</td>
									<td>
									<div class="col-md-12 col-sm-6 col-xs-12">
									<input type="hidden" id="area" name="source_storage[]" class="form-control col-md-7 col-xs-12" placeholder="area" value="<?php if(!empty($source_Data)) echo $source_Data->Storage; ?>">
										<span><?php echo  $source_Data->Storage;  ?></span>
									</div>
									</td>
									<td>
									<div class="col-md-12 col-sm-6 col-xs-12">
									<input type="hidden" id="rack_number" name="source_rack_no[]" class="form-control col-md-7 col-xs-12" placeholder="rack_number" value="<?php if(!empty($source_Data)) echo $source_Data->RackNumber; ?>">
										<span><?php echo  $source_Data->RackNumber;?></span>
									</div>
									</td>
								</tr>
							</br>
							<?php $i++; }}}?>		
						</table>
					</div>
				</div>
			</div>
			
<hr>
<div class="bottom-bdr"></div>
			
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">				
				<div class="item form-group ">
					<div class="col-md-12 col-sm-12 col-xs-12 input_destination">
					
					    <h3 class="Material-head">Destination Address<hr></h3>	
						<!--<div class="panel-heading"><h3 class="panel-title"><strong>Destination Address</strong></h3></div>-->
							<div class="panel-body middle-box2">
								<!--<div class="item form-group" >
									<div class="col-md-12">
										<div class="col-md-5 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="srcAddress">Destination Address<span class="required">*</span></label>
										</div>
										<div class="col-md-3 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="area">Area</label>
										</div>	
										<div class="col-md-3 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="rack">Rack number</label>
										</div>	
									</div>
								</div>-->
							<div class="well"  style="overflow:auto; border: 1px solid #c1c1c1;" id="chkIndex_1">
								<div class="col-md-5 col-sm-6 col-xs-12 form-group">
								    <label class="col-md-12 col-sm-12 col-xs-12" for="srcAddress">Destination Address<span class="required">*</span></label>
									<select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="location_settings" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" onchange="getArea(event,this);" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>" required="required">
										<option>Select Option</option>
									</select>	
								</div>
							<div class="col-md-4 col-sm-6 col-xs-12 form-group">
							    <label class="col-md-12 col-sm-12 col-xs-12" for="area">Area</label>
								<select class="area form-control" name="storage[]">
											<option value="">Select Option</option>	
										</select>
							</div>
							<div class="col-md-3 col-sm-6 col-xs-12 form-group">
							    <label class="col-md-12 col-sm-12 col-xs-12" for="rack">Rack number</label>
								<input type="text" id="rack_number" name="RackNumber[]"  class="form-control col-md-7 col-xs-12" placeholder="rack_number">
							</div>
							
						</div>
						</div>
						
					</div>
				</div>
			</div>			
				
					<span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span>
					<div class="item form-group col-md-8 vertical-border">					
						<label class="col-md-3 col-sm-3 col-xs-12" for="qty">Quantity<span class="required">*</span></label>
							<div class="col-md-3 col-sm-6 col-xs-12">
							<input type="number" id="qty" name="quantity" required="required" class="form-control col-md-7 col-xs-12 keyup_check_qty " placeholder="quantity">
							</div>
							<div class="col-md-3 col-sm-6 col-xs-12">
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


                  