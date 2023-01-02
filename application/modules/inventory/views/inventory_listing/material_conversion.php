<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>


<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveInventoryListing" enctype="multipart/form-data" id="materialForm" novalidate="novalidate">
	
	<input type="hidden" name="id" value="<?php if($inventoryListing && !empty($inventoryListing)){ echo $inventoryListing->id; }?>">
	<input type="hidden" name="material_name_id" value="" id="material_id">
		<input type="hidden" name="material_type_id" value="" id="material_type_id">
	<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
	<div class=" vertical-border col-md-6" >					
	<div class="item form-group">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="hidden" id="Actiontype" name="action_type" class="form-control col-md-7 col-xs-12"  value="" readonly>
		</div>
	</div>	
	
	<div class="item form-group">
		<label class="col-md-3 col-sm-3 col-xs-12">Select Product Type</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text"  name="material_type_name" required="required" class="form-control col-md-7 col-xs-12 material_type" placeholder="Material type" value="" readonly>
			</div>
	</div>	
		
	
	<div class="item form-group">
		<label class="col-md-3 col-sm-3 col-xs-12" for="material_name">Product Name </label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="material_name" name="material_name" required="required" class="form-control col-md-7 col-xs-12 has-feedback-left material_name" placeholder="Material name" value="" readonly>
				
			</div>
	</div>														
</div>		
<div class=" vertical-border col-md-6" >	
							
	
		
	<div class="item form-group">
		<label class="col-md-3 col-sm-3 col-xs-12" for="qty">Quantity</label>
			<div class="col-md-4 col-sm-2 col-xs-12">
				<input type="number" id="qty" name="closing_bal" class="form-control col-md-7 col-xs-12 qty" placeholder="quantity" value="<?php if($inventoryListing && !empty($inventoryListing)){ echo $inventoryListing->closing_balance;} ?>">
			</div>
			
			<div class="col-md-4 col-sm-2 col-xs-12">
				<select class="form-control uom " name="uom" id="uom">
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
<div class="bottom-bdr"></div>

	<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
		<div class="item form-group" >
			<div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title" style="text-align: center;"><strong>Source Address</strong></h3></div>
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
							<div class="col-md-4 col-sm-6 col-xs-12">
							<input type="hidden" id="address" name="source_location[]" class="form-control col-md-7 col-xs-12" placeholder="address" value="<?php  if(!empty($locationName)) { echo $locationName->location;} else{ echo "N/A";} ?>">
								<span><?php  if(!empty($locationName)) { echo $locationName->location;} else{ echo "N/A";} ?></span>
							</div>
							</td>
							<td>
							<div class="col-md-4 col-sm-6 col-xs-12">
							<input type="hidden" id="area" name="source_storage[]" class="form-control col-md-7 col-xs-12" placeholder="area" value="<?php if(!empty($source_Data)) echo $source_Data->Storage; ?>">
								<span><?php echo  $source_Data->Storage;  ?></span>
							</div>
							</td>
							<td>
							<div class="col-md-4 col-sm-6 col-xs-12">
							<input type="hidden" id="rack_number" name="source_rack_no[]" class="form-control col-md-7 col-xs-12" placeholder="rack_number" value="<?php if(!empty($source_Data)) echo $source_Data->RackNumber; ?>">
								<span><?php echo  $source_Data->RackNumber;?></span>
							</div>
						</td>
					</tr>
					<?php $i++; }}}?>		
				</table>
			</div>
		</div>
	</div>
	
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
	<div class="item form-group">
		<div class=" panel-default middle-box2">
		<h3 class="Material-head mat_name">Converted material<hr></h3>
			
				<div class="col-md-12 col-sm-7 col-xs-12 input_Material">
					<div class="well" style="overflow:auto; border: 1px solid #c1c1c1;" id="chkIndex_1">
						<div class="col-md-6 col-sm-8 col-xs-12 input-group" style="float:left;">
							<label>Material Name</label>
								<select  class="form-control col-md-2 col-xs-12 selectAjaxOption select2" name="converted_material_id" data-id="material" data-key="id" data-fieldname="material_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
									<option value="">Select Option</option> 
								</select>
						</div>
						<div class="col-md-3 col-sm-2 col-xs-12 form-group">
							<label>Quantity</label>
								<input type="text" id="qty" name="quantity" class="form-control col-md-7 col-xs-12 qty">
						</div>
						<div class="col-md-3 col-sm-2 col-xs-12 form-group">
							<label>UOM</label>
								<select class="form-control uom " name="converted_uom" id="uom">
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
			
		</div>
	</div>
	</div>
	
	
	<!--<div class="item form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="qty">To be converted</label>
			<div class="col-md-3 col-sm-3 col-xs-12">
				<input type="number" id="converted" name="quantity"  class="form-control col-md-7 col-xs-12 hsn" placeholder="Converted Quantity"  value="">
			</div>
	
	<div class="col-md-3 col-sm-2 col-xs-12">
		<select class="form-control uom " name="uom" id="uom">
		<option>Unit of Measurement</option>
			<?php/* 
				$checked ='';			
				$uom = getUom();											  
					foreach($uom as $unit) {												 
						if((!empty($inventoryListing)) && ($inventoryListing->uom == $unit)){ $checked = 'selected';}else{$checked = '';  }				
							echo "<option value='".$unit."' ".$checked.">".$unit."</option>";												
						}											
					*/?>									
		</select>	
	</div>
	</div>
	-->
	
	
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">				
		<div class="item form-group ">
			<div class="col-md-12 col-sm-12 col-xs-12 add_destination">
				<div class="panel-default middle-box2">
					
					<h3 class="Material-head mat_name">Destination Address<hr></h3>
						
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
								<div class="col-md-6 col-sm-6 col-xs-12 form-group">
								    <label class="col-md-12 col-sm-12 col-xs-12" for="srcAddress">Destination Address<span class="required">*</span></label>
									<select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="location_settings" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getArea(event,this);" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
											<option value="">Select Option</option>
												
										</select>	
								</div>
								<div class="col-md-3 col-sm-6 col-xs-12 form-group">
								    <label class="col-md-12 col-sm-12 col-xs-12" for="area">Area</label>
									<select class="area form-control" name="storage[]">
												<option value="">Select Option</option>	
											</select>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-12 form-group">
								  <label class="col-md-12 col-sm-12 col-xs-12" for="rack">Rack number</label>
									<input type="text" id="rack_number" name="RackNumber[]"  class="form-control col-md-7 col-xs-12" placeholder="rack_number">
								</div>
								<!--<div class="input-group-append">
									<button class="btn btn-primary add_More_DestinationAddress" type="button" align="right"><i class="fa fa-plus"></i></button>
								</div>	-->
							</div>
						
				</div>
			</div>
		</div>
	</div>
				
					
				
<hr>
		<div class="form-group">
		<div class="col-md-12 colxs-12">
		<center>
		<input type="reset" class="btn btn-default" value="Reset">
		<input type="submit" class="btn btn-warning signUpBtn" value="submit">
		<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>inventory/inventory_listing'">Cancel</a>
		</center>
		</div>
	</div>
</form>
						
	<script type="text/javascript">
	<?php /*//var company_address = '<?php echo $addd->address; ?>'; */?>
	
	</script>