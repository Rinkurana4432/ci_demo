<?php

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>

<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveInventoryListingAdjustment" enctype="multipart/form-data" id="inventory_listing" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if($inventoryListing && !empty($inventoryListing)){ echo $inventoryListing->id; }?>">
		<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
				<input type="hidden" name="material_name_id" value="" id="material_id">
				<input type="hidden" name="material_type_id" value="" id="material_type_id">
<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">		
		<div class="item form-group">
			<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="hidden"  name="action_type" class="form-control col-md-7 col-xs-12" id="Actiontype" readonly value="">
			</div>
		</div>				
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12">Half / Full Book</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div id="sale_purchase" class="btn-group" data-toggle="buttons">
					<p>
					<!--Half Book:
					<input type="radio" class="flat" name="half_full_book" id="sale" value="halfbook"  required /---> Full book:
					<input type="radio" class="flat" name="half_or_full_book" id="purchase" value="fullbook" checked />
					</p>
					</div>
				</div>
          </div>
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Party Name</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="party_name" name="party_name" required="required" class="form-control col-md-7 col-xs-12" placeholder="party name" value="">
				</div>
		</div>
</div>
<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Material Type</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text"  name="material_type" required="required" class="form-control col-md-7 col-xs-12 material_type" placeholder="Material type" value="" readonly>
				</div>
		</div>
		
</div>
<hr>
	<div class="bottom-bdr"></div>
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">				
			<div class="item form-group ">
                <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
					<div class=" panel-default">
						
						<h3 class="Material-head"><strong>Material Detail</strong><span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span><hr></h3>
						
							<div class="panel-body goods_descr_wrapper">
								<div class="item form-group">
								
							
							<div class="col-md-12 material_detail middle-box2">
								<div class="well" id="chkIndex_1" style="overflow:auto; border-top:1px solid #c1c1c1 !important;  border-right:1px solid #c1c1c1 !important; ">
									<div class="col-md-6 col-sm-6 col-xs-12 form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Material Name<span class="required">*</span></label>
										<input type="text" id="material_name" name="material_name" required="required" class="form-control col-md-7 col-xs-12 material_name" placeholder="Material name" value="" readonly>
									</div>
									
									<div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="Quantity">Quantity<span class="required">*</span></label>
										<input type="text" id="qty" name="quantity" class="form-control col-md-7 col-xs-12 keyup_check_qty"  placeholder="Qty.">
									</div>														
									<div class="col-md-3 col-sm-12 col-xs-12 form-group">	
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="Uom">Uom<span class="required">*</span></label>
										
										<select class="uom selectAjaxOption select2 form-control" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php 	echo $this->companyGroupId; ?> OR created_by_cid = 0">
							<option value="">Select Option</option>
								<?php 
			if(!empty($materials)){
			$materials = getNameById('uom',$materials->uom,'uom_quantity');
			echo '<option value="'.$material->id.'" selected>'.$material->uom_quantity.'</option>';
							 }
								?>
									</select>
									</div>		
								</div>			
							</div>
						</div>
					  </div>
					</div>
				</div>
			</div>
		</div>
<hr>
<div class="bottom-bdr"></div>		
<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Time Period</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="date" name="date" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo date('d-m-y');?>">
				</div>
		</div>
</div>
<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">		
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Description</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<textarea id="Description" name="reason"  class="form-control col-md-7 col-xs-12" placeholder="Description............."></textarea>
				</div>
		</div>
</div>
<hr>

		<div class="form-group">
			<div class="col-md-12 col-xs-12">
			   <center>
				<input type="reset" class="btn btn-default" value="Reset">
					<input type="submit" class="btn btn-warning check_mat_qty" value="submit">
						<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>inventory/inventory_listing_and_adjustment'">Cancel</a>
				</center>
			</div>
		</div>
			
</form>
<script>
		var measurementUnits = <?php echo json_encode(getUom()); ?>;		
	</script>
                  