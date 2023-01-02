<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveInventoryListingAdjustment"
    enctype="multipart/form-data" id="inventory_listing" novalidate="novalidate">
    <input type="hidden" name="id" value="<?php //if($inventoryListing && !empty($inventoryListing)){ echo $inventoryListing->id; }?>">
    <input type="hidden" name="material_name_id" value="" id="material_id">
    <input type="hidden" name="material_type_id" value="" id="material_type_id">
    <input type="hidden" value="<?php echo $material_id; ?>" id="materialId">

    <div class="item form-group">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="hidden" id="Actiontype" name="action_type" class="form-control col-md-7 col-xs-12" value=""
                readonly>
        </div>
    </div>
    
    <h3 class="Material-head">Material Name:<b><span id="material_name" style="color:green;"></span></b>
        <hr>
    </h3>
    
    <?php if(!empty($inventoryListing)){ 	?>
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <div class="item form-group ">
            <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Source Address</strong></h3>
                    </div>
                    <table id="datatable-buttons" class="table table-striped table-bordered jambo_table bulk_action"
                        data-id="user">

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
								$ww =  getNameById('uom',$source_Data['Qtyuom'],'id');
								$uom1 = !empty($ww)?$ww->ugc_code:'';
								$locationName = getNameById('company_address',$source_Data['location_id'],'id');
	                    ?>
                        <tr id="Index_<?php echo $i; ?>">
                            <td>
                                <input type="radio" name="checkAddress" value="selectOne" class="getAddress" onclick="getAddressData(this,event)">
                            	<input type="hidden" name="" id="matLocId" value="<?php echo $source_Data['id']; ?>">
                            </td>
                            <td>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <input type="hidden" id="address22" name="source_location[]"
                                        class="form-control col-md-7 col-xs-12" placeholder="address"
                                        value="<?php if(!empty($source_Data)) echo $source_Data['location_id']; ?>">

                                    <span><?php  if(!empty($locationName)){ echo $locationName->location;} else {echo "N/A";} ?></span>
                                </div>
                            </td>
                            
                            
                            <td>
                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    <input type="hidden" id="quantity" name="sourceQty[]"
                                        class="form-control col-md-7 col-xs-12 qty" placeholder="qty"
                                        value="<?php if(!empty($source_Data)) echo $source_Data['quantity']; ?>">
                                    <?php if(!empty($source_Data)) echo $source_Data['quantity']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <input type="hidden" id="Qtyuom" name="sourceQtyuom[]"
                                        class="form-control col-md-7 col-xs-12 " placeholder="Uom"
                                        value="<?php if(!empty($source_Data)) echo $source_Data['Qtyuom']; ?>">
                                    <?php echo $uom1 ; ?>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; }?>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span>

    <div id="message" style="color:red; text-align:center;"></div>
    <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
        <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Consumed Qty</label>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <input type="text" id="qty" name="quantity" required="required" class="form-control col-md-7 col-xs-12"
                    placeholder="Consumed Qty" value="<?php //echo $inventoryAdjustment['uom']; ?>"
                    onkeyup="getQuantity(this,event)">
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">

                <?php $ww =  getNameById('uom',$source_Data['Qtyuom'],'id');
													$uom1 = !empty($ww)?$ww->ugc_code:''; ?>

                <input type="text" name="uom1" class="form-control col-md-7 col-xs-12" placeholder="Uom"
                    value="<?php echo $uom1; ?>" style="width:100%;" readonly>


                <input type="hidden" name="uom" value="<?php if(!empty($source_Data)) echo $source_Data['Qtyuom']; ?>"
                    style="width:100%;" readonly>
                <!--select class="form-control uom" name="uom" required="required">
						<option>Unit of Measurement</option>
						<?php 
						/* checked ='';			
							$uom = getUom();											  
							foreach($uom as $unit) {												 
								if((!empty($inventoryListing)) && ($inventoryListing->uom == $unit)){ $checked = 'selected';}else{$checked = '';  }				
								echo "<option value='".$unit."' ".$checked.">".$unit."</option>";												
								}		 */									
																
						?>									
					</select-->
            </div>
        </div>
        <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Date</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="datepicker" name="date" required="required"
                    class="form-control col-md-7 col-xs-12" value="<?php echo date('d-m-Y');?>" />
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
        <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Reason</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea id="reason" name="reason" class="form-control col-md-7 col-xs-12"
                    placeholder="Reason"></textarea>
            </div>
        </div>

    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="hidden" name="selctedAddrId[]" value="" id="selctedAddrId">
        <input type="hidden" name="selectedAddress[]" value="" id="selctedAddr">
        <input type="hidden" name="selectedArea[]" value="" id="selctedArea">
        <input type="hidden" name="selectedRack[]" value="" id="selectedRack">
        <input type="hidden" name="selectedLotNo[]" value="" id="selectedLotNo">
        <input type="hidden" name="selectedQty[]" value="" id="selectedQty">
        <input type="hidden" name="selectedUom[]" value="" id="selectedUom">
    </div>


    <hr>
    <div class="form-group">
        <div class="col-md-12 col-xs-12">
            <center>
                <input type="reset" class="btn btn-default" value="Reset">
                <input type="submit" class="btn btn-warning check_mat_qty" value="submit">
                <a class="btn btn-danger"
                    onclick="location.href='<?php echo base_url();?>inventory/inventory_listing_and_adjustment'">Cancel</a>
            </center>
        </div>
    </div>

</form>
<!--</div>->