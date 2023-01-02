<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>

<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveInventoryListingAdjustment"
	enctype="multipart/form-data" id="inventory_listing" novalidate="novalidate">	
	<input type="hidden" name="id" value="<?php //if($inventoryListing && !empty($inventoryListing)){ echo $inventoryListing->id; }?>">
	<input type="hidden" name="material_name_id" value="" id="material_id">
	<input type="hidden" name="material_type_id" value="" id="material_type_id">
	<input type="hidden" value="<?php echo $material_id; ?>" id="materialId">

	<div class="item form-group">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="hidden" id="Actiontype" name="action_type" class="form-control col-md-7 col-xs-12" value="" readonly>
		</div>
	</div>
	<h3 class="Material-head">Material Name:<b><span class="material_name" style="color:green;"></span></b><hr></h3>

	<?php if(!empty($inventoryListing)){ ?>
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		<div class="item form-group">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Source Address</strong></h3>
				</div>

				<table id="datatable-buttons" class="table table-striped table-bordered jambo_table bulk_action" data-id="user">
					<tr>
						<th>
							<div class="col-md-1 item form-group">
								<label class="col-md-12 col-sm-12 col-xs-12" for="check">Check Address</label>
							</div>
						</th>

						<th>
							<div class="col-md-3 item form-group">
								<label class="col-md-12 col-sm-12 col-xs-12" for="srcAddress">Source
									Address</span></label>
							</div>
						</th>

						

						<th>
							<div class="col-md-1 item form-group">
								<label class="col-md-12 col-sm-12 col-xs-12" for="qty">Quantity</span></label>
							</div>
						</th>

						<th>
							<div class="col-md-1 item form-group">
								<label class="col-md-12 col-sm-12 col-xs-12" for="qty">Uom</span></label>
							</div>
						</th>
					</tr>

					<?php 
					$i =  1;
					foreach($inventoryListing as $source_Data){
						$locationName = getNameById('company_address',$source_Data['location_id'],'id');
						$ww =  getNameById('uom',$source_Data['Qtyuom'],'id');
						$uom1 = !empty($ww)?$ww->ugc_code:'';													
					?>

					<tr id="Index_<?php echo $i; ?>">
						<td>
							<input type="radio" name="checkAddress" value="selectOne" class="getAddress" onclick="getAddressData(this,event)">
							<input type="hidden" name="matLocId" id="matLocId" value="<?php echo $source_Data['id']; ?>">
							<input type="hidden" name="" id="id" value="<?php echo !empty($source_Data['material_name_id']) ? $source_Data['material_name_id']:''; ?>">
							<input type="hidden" name="" id="loggedUser" value="<?php echo $this->companyGroupId; ?>">							
						</td>												
						<td>
							<div class="col-md-3 col-sm-6 col-xs-12">
								<input type="hidden" id="address22" name="address[]"
									class="form-control col-md-7 col-xs-12" placeholder="area"
									value="<?php if(!empty($source_Data)) echo $source_Data['location_id']; ?>">
								<span><?php  if(!empty($locationName)){echo $locationName->location; } else{ echo "N/A";} ?></span>
							</div>
						</td>
						
						<td>
							<div class="col-md-1 col-sm-6 col-xs-12">
								<input type="hidden" id="quantity" name="sourceQty[]"
									class="form-control col-md-7 col-xs-12" placeholder="quantity"
									value="<?php if(!empty($source_Data)) {echo $source_Data['quantity'];} ?>">
								<div><?php if(!empty($source_Data)) { echo $source_Data['quantity']; }?></div>
							</div>
						</td>
						<td>
							<div class="col-md-1 col-sm-6 col-xs-12">
								<input type="hidden" id="Qtyuom" name="sourceQtyuom[]"
									class="form-control col-md-7 col-xs-12" placeholder="Uom"
									value="<?php if(!empty($source_Data)) echo $source_Data['Qtyuom']; ?>">
								<span><?php echo $uom1  ;?></span>
							</div>
						</td>
					</tr>

					<?php $i++; } ?>

				</table>
			</div>
		</div>
	</div>
	<?php } ?>
	
	<hr>
	<div class="bottom-bdr"></div>
	
	<div class="middle-box2">
		<div class="item form-group">
			<span id="message" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span>
			<div class="col-md-12 col-sm-7 col-xs-12 input_Material input_productre1">
				<div class="well" style="overflow:auto; border-top:1px solid #c1c1c1 !important; border-right:1px solid #c1c1c1 !important;" id="chkIndex_1">
					<div class="col-md-2 col-sm-7 col-xs-12 form-group">
						<label>Output Material Type</label>
						<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name"  aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type_id">
							<option value="">Select Option</option>
						</select>
					</div>
					<div class="col-md-2 col-sm-8 col-xs-12 form-group" style="float:left;">
						<label>Output Material Name</label>
						<select class="materialNameId form-control col-md-2 col-xs-12  mat_name Add_mat_onthe_spot" id="mat_name" required="required" name="converted_material_id[]" onchange="getUOMinmaterialconvrs(event,this)">
							<option>Select Option</option>
						</select>							
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12 form-group">
						<label>Destination Address</label>
						<select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" onchange="getArea(event,this);getlot(event,this)" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
							<option>Select Option</option>
						</select>
					</div>
					
					<div class="col-md-2 col-sm-2 col-xs-12 form-group">
						<label>Output Quantity</label>
							<input type="text" id="qty" name="converted_qty[]" onblur="getQuantityinconversion(event,this);" class="form-control col-md-7 col-xs-12 qty22">
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12 form-group hideshow" style="display: none;">
							<label>Per Quantity</label>
							<input type="text" name="per_qty[]" onblur="getQuantityinconversion(event,this);"  class="form-control col-md-7 col-xs-12">
					</div>
					<div class="col-md-4 col-sm-2 col-xs-12 form-group">
						<label>Output UOM</label>
						<input type="text"  name="uom1[]"  class="form-control col-md-7 col-xs-12  uom" placeholder="UOM" value="" readonly>
						<input type="hidden"  name="uom[]"  class="form-control col-md-7 col-xs-12  uomid" placeholder="UOM" value="" readonly>
					</div>	
				</div>
				<div class="col-sm-12 btn-row" style=" bottom: -37px;"><button class="btn edit-end-btn addProductButtonre1" style="float: left;" type="button">Add</button></div>
			</div>
		</div>
	</div>	
	<hr>
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		<input type="hidden" name="selctedAddrId[]" value="" id="selctedAddrId">
		<input type="hidden" name="selectedAddress[]" value="" id="selctedAddr">
		<!--input type="hidden" name="selectedArea[]" value="" id="selctedArea">
		<input type="hidden" name="selectedRack[]" value="" id="selectedRack">
		<input type="hidden" name="selectedLotNo[]" value="" id="selectedLotNo"-->
		<input type="hidden" name="selectedQty[]" value="" id="selectedQty">
		<input type="hidden" name="selectedUom[]" value="" id="selectedUom" class="getUom">
	</div>

	<div class="ln_solid"></div>
		<div class="form-group">
		<div class="col-md-12 col-xs-12">
		<center>
		<input type="reset" class="btn btn-default" value="Reset">
		<input type="submit" class="btn btn-warning signUpBtn" value="submit">
		<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>inventory/inventory_listing_and_adjustment'">Cancel</a>
		</center>
		</div>
	</div>
</form>
	<script type="text/javascript">
	<?php /*//var company_address = '<?php echo $addd->address; ?>'; */?>
	
	</script>