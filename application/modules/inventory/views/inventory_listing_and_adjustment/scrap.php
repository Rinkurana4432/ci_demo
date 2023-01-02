<?php

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>

<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveInventoryListingAdjustment" enctype="multipart/form-data" id="inventory_listing" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php //if($inventoryListing && !empty($inventoryListing)){ echo $inventoryListing->id; }?>">		<?php 			$getMAtType_name = getNameById('material', $material_id, 'id');					?>
	<input type="hidden" name="material_name_id" value="" id="material_id">
	<input type="hidden" name="material_type_id" value="" id="material_type_id">
	<input type="hidden" value="<?php echo $material_id; ?>" id="materialId">
	
		<div class="item form-group">			
			<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="hidden"  name="action_type"  class="form-control col-md-7 col-xs-12" id="Actiontype" readonly>
			</div>
		</div>
		
		


<h3 class="Material-head scrap_mat_name">Material Name:<b><span  id="material_name" style="color:green;"></span></b><hr></h3>	
		<span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span>
		<?php if(!empty($inventoryListing)){ 	?>	
	 <div class="col-md-12 col-sm-12 col-xs-12 form-group">				
			<div class="item form-group ">
				<div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
					<div class="panel panel-default">
						<div class="panel-heading"><h3 class="panel-title"><strong>Source Address</strong></h3></div>
						  <table id="datatable-buttons" class="table table-striped table-bordered jambo_table bulk_action"  data-id="user">
							
								<tr>
								<th>
								<div class="col-md-1 item form-group">
								<label class="col-md-12 col-sm-12 col-xs-12" for="check">Check Address</label>
								</div>
								</th>

								<th>
								<div class="col-md-3 item form-group">
								<label class="col-md-12 col-sm-12 col-xs-12" for="srcAddress">Source Address</span></label>
								</div>
								</th>
								
								<!--th>
								<div class="col-md-2 item form-group">
								<label class="col-md-12 col-sm-12 col-xs-12" for="area">Area</span></label>
								</div>	
								</th-->
								
								
								
								
								
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
										$ww =  getNameById('uom',$source_Data['Qtyuom'],'id');
										$uom1 = !empty($ww)?$ww->ugc_code:'';
									    $locationName = getNameById('company_address',$source_Data['location_id'],'id');
									?>
								<tr id="Index_<?php echo $i; ?>">
									<td>
									    <input type="radio" name="checkAddress" value="selectOne" class="getAddress" onclick= "getAddressData(this,event)">
									    <input type="hidden" name="" id="matLocId" value="<?php echo $source_Data['id']; ?>">
									</td>
									<td>
										<div class="col-md-3 col-sm-6 col-xs-12">
										<input type ="hidden" id="address22" name="source_location[]" class="form-control col-md-7 col-xs-12" placeholder="address" value="<?php  if(!empty($source_Data)){echo $source_Data['location_id']; } else {echo "N/A";}?>">
										 <span><?php  if(!empty($locationName)){ echo $locationName->location;} else {echo "N/A";} ?></span> 
										</div>
									</td>
									

									<!--td>
    									<input type="hidden" id="rack_number" name="source_lotno[]"  class="form-control col-md-7 col-xs-12" placeholder="rack_number" value="<?php //if(!empty($source_Data)) echo $source_Data['lot_no']; ?>">
    									<span>
										<?php 
									    // if(!empty($source_Data && $source_Data['lot_no']) ){ 
										    // if (!empty($source_Data && $source_Data['lot_no'])) {
					                             // $lot_details = getNameById('lot_details',$source_Data['lot_no'],'id');    
					                             // echo $lot_details->lot_number;
					                       // }
									    // }
									    ?>
    									</span> 
									</td-->

									<td>
										<div class="col-md-1 col-sm-6 col-xs-12">
										<input type="hidden" id="quantity" name="sourceQty[]"  class="form-control col-md-7 col-xs-12 qty" placeholder="qty" value="<?php if(!empty($source_Data)) echo $source_Data['quantity']; ?>">
										<?php if(!empty($source_Data)) echo $source_Data['quantity']; ?>
										</div>
									</td>
									<td>
										<div class="col-md-1 col-sm-6 col-xs-12">
										<input type="hidden" id="Qtyuom" name="sourceQtyuom[]"  class="form-control col-md-7 col-xs-12 " placeholder="Uom" value="<?php if(!empty($source_Data)) echo $source_Data['Qtyuom']; ?>">
										<?php echo $uom1 ; ?>
										</div>
									</td>
								</tr>
								<?php $i++; } ?>
						</table>
					</div>
				</div>
			</div>
		</div>	
		<?php } ?>
		
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
<input type="hidden" name="selctedAddrId[]" value="" id="selctedAddrId">
<input type="hidden" name="selectedAddress[]" value="" id="selctedAddr">	
<input type="hidden" name="selectedArea[]" value="" id="selctedArea">

<input type="hidden" name="selectedQty[]" value="" id="selectedQty">
<input type="hidden" name="selectedUom[]" value="" id="selectedUom">
</div>	
		
<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">		
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Scrap Into</label>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<!--select class="form-control scrapMateirlaName"  name="scrapIntoMaterial_id" data-id="material" data-key="id" data-fieldname="material_name"  aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND material_type_id= <?php //echo $getMAtType_name->material_type_id; ?>" onchange="getUomInInventoryListing(event,this)" id="scrapMateirlaName" -->
					
					<select class="form-control scrapMateirlaName"  name="scrapIntoMaterial_id" data-id="material" data-key="id" data-fieldname="material_name"  aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND material_type_id= 26" onchange="getUomInInventoryListing(event,this)" id="scrapMateirlaName" >
						<option value="">Select Option</option>
					</select>
					<input type="hidden" name="mat_idd_name" id="matrial_Iddd" value="6">	
					<input type="hidden" name="matrial_name" id="matrial_name">	  
					<input type="hidden" id="serchd_val">	  
				</div>				<div class="col-md-4 col-sm-6 col-xs-12">					<input  style="width:100%;" type="text" id="uom" name="uom"  class="form-control col-md-7 col-xs-12 uomScrap" value = "" readonly />										<input  style="width:100%;" type="hidden" id="uomid" name="uomid"  value = "" readonly />				</div>
		</div>		
		
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Scrap Qty</label>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<input  type="number" id="qty" name="quantity" required="required" class="form-control col-md-7 col-xs-12 keyup_check_qty qty" placeholder="">
				</div>
					
				<div class="col-md-4 col-sm-6 col-xs-12">
						<input style="width:100%;" type="text" id="uom" name="uom"  class="form-control col-md-7 col-xs-12 uomScrap" value = "" readonly />
					<!--select class="form-control" name="uom" required="required" id="uom">
						<option>Unit of Measurement</option>
							<?php 
							/* $checked ='';			
							$uom = getUom();											  
								foreach($uom as $unit) {												 
									//if((!empty($inventoryListing)) && ($inventoryListing->uom == $unit)){ $checked = 'selected';}else{$checked = '';  }				
									echo "<option value='".$unit."' ".$checked.">".$unit."</option>";												
																				
								}	 */										
							?>									
					</select-->
				</div>
		</div>	
</div>
<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">	
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Reason</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<textarea id="reason" name="reason"  class="form-control col-md-7 col-xs-12" placeholder="reason for scrap"></textarea>
				</div>
		</div>
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Date</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input  type="text" id="datepicker" name="date"  class="form-control col-md-7 col-xs-12" value = "<?php echo date('d-m-Y'); ?>"/>
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
	<!-------------------------------------------------quick add material --------------------------------------------------------------------------->
<div class="modal left fade" id="myModal_Add_scrapMatrial_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Add Material Details</h4>
					<span id="mssg34"></span>
				</div>
				<form name="insert_party_data" name="ins"  id="insert_Matrial_data_id">
					<div class="modal-body">
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="name">Material Name <span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="materialName" name="material_name" required="required" class="form-control col-md-7 col-xs-12" value="">
								<span class="spanLeft control-label"></span>
							</div>
						</div> 
						<input type="hidden" name="material_type_id" id="materialtypeid"  class="form-control" value="6">
						<input type="hidden" name="prefix"  id="prefix" value="SCA">
						<span class="spanLeft control-label"></span>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">HSN Code </label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="hsn_code" name="hsn_code" class="form-control col-md-7 col-xs-12" value="" >
								<span class="spanLeft control-label"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">UOM</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<select name="uom" id="uom_id"  class="form-control col-md-1">
									<option value="">Select</option>
									<?php $uom = getUom();	
									foreach($uom as $unit) { ?>		
										<option value="<?php echo $unit; ?>"><?php echo $unit; ?></option>	
									<?php }	?>
								</select>
								<span class="spanLeft control-label"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">Opening Balance</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="opening_balance_Sec" name="opening_balance" class="form-control col-md-7 col-xs-12" value="">
							<span class="spanLeft control-label"></span>
						</div>
					</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="gstin">Specification</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification"></textarea>
								<span class="spanLeft control-label"></span>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" id="add_scarp_matrial_Data_onthe_spot">
						<button type="button" class="btn btn-default close_model" >Close</button>
						<button id="Add_scrap_matrial_details_on_button_click" type="button" class="btn edit-end-btn ">Submit</button>
					</div>
				</form>
			</div>
        </div>
    </div>
						<!--</div>->


                  