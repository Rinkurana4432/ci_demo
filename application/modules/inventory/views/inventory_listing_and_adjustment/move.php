<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>

<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveMove"
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
    <h3 class="Material-head">Material Name:<b><span class="material_name" style="color:green;"></span></b>
        <hr>
    </h3>

    <?php if(!empty($inventoryListing)){  ?>
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <div class="item form-group">
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
							$locationName = getNameById('company_address',$source_Data['location_id'],'id');
							    $ww =  getNameById('uom',$source_Data['Qtyuom'],'id');
								$uom1 = !empty($ww)?$ww->ugc_code:'';
							?>

                    <tr id="Index_<?php echo $i; ?>">
                        <td>
                            <input type="radio" name="checkAddress" value="selectOne" class="getAddress" onclick="getAddressData(this,event)">
                            <input type="hidden" name="matLocId" id="matLocId" value="<?php echo $source_Data['id']; ?>">
                            <input type="hidden" name="" id="id" value="<?php echo !empty($source_Data['material_name_id']) ? $source_Data['material_name_id']:''; ?>">
                            <input type="hidden" name="" id="loggedUser" value="<?php 	echo $this->companyGroupId; ?>">
                        </td>    
                        <td>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input type="hidden" id="address22" name="address[]"
                                    class="form-control col-md-7 col-xs-12" placeholder="address"
                                    value="<?php  if(!empty($source_Data)){echo $source_Data['location_id']; } else{ echo "N/A";}?>">
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
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <div class="item form-group ">
            <div class="col-md-12 col-sm-12 col-xs-12 input_destination">
                <div class=" panel-default">
                    <h3 class="Material-head">Destination Address
                        <hr>
                    </h3></br>
                    <span id="message"
                        style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span>
                    <div class="panel-body  middle-box2">

                        <div class="well"
                            style="overflow:auto; border-top:1px solid #c1c1c1 !important;  border-right:1px solid #c1c1c1 !important; "
                            id="matIndex_1">
                            <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                <label class="col-md-12 col-sm-12 col-xs-12" for="srcAddress">Destination Address<span
                                        class="required">*</span></label>
                                <select
                                    class="location form-control selectAjaxOption select2 select2-hidden-accessible location"
                                    name="location[]" data-id="company_address" data-key="id" data-fieldname="location"
                                    width="100%" tabindex="-1" aria-hidden="true"
                                    onchange="getArea(event,this);getlot(event,this)"
                                    data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
                                    <option>Select Option</option>
                                </select>

                            </div>
                            <!--div class="col-md-2 col-sm-6 col-xs-12 form-group">
                                <label class="col-md-12 col-sm-12 col-xs-12" for="area">Area<span
                                        class="required">*</span></label>
                                <select class="area form-control" name="storage[]">
                                    <option>Select Option</option>
                                </select>

                            </div-->
                           
                            <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                <label class="col-md-12 col-sm-12 col-xs-12" for="Qty">Qty<span
                                        class="required">*</span></label>
                                <input type="text" id="qty" name="quantity[]" class="form-control col-md-7 col-xs-12"
                                    placeholder="qty" onkeyup="getQuantity(this,event)" required>

                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                <label class="col-md-12 col-sm-12 col-xs-12" for="uom">Uom<span
                                        class="required">*</span></label>
                                <select class="uom selectAjaxOption select2 form-control" name="uom" data-id="uom"
                                    data-key="id" data-fieldname="uom_quantity" width="100%" id="uom"
                                    data-where="created_by_cid = <?php 	echo $this->companyGroupId; ?> OR created_by_cid = 0">
                                    <option value="">Select Option</option>
                                    <?php 
									/*if(!empty($source_Data)){
    									$source_Data = getNameById('uom',$source_Data->uom,'uom_quantity');
    									echo '<option value="'.$source_Data->id.'" selected>'.$source_Data->uom_quantity.'</option>';
    							 	}*/
								?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="hidden" name="selctedAddrId[]" value="" id="selctedAddrId">
        <input type="hidden" name="selectedAddress[]" value="" id="selctedAddr">
        <input type="hidden" name="selectedArea[]" value="" id="selctedArea">
        <input type="hidden" name="selectedRack[]" value="" id="selectedRack">
        <input type="hidden" name="selectedLotNo[]" value="" id="selectedLotNo">
        <input type="hidden" name="selectedQty[]" value="" id="selectedQty">
        <input type="hidden" name="selectedUom[]" value="" id="selectedUom">
    </div>
    <div class="bottom-bdr"></div>
    <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
        <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Date</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="datepicker" name="date" class="form-control col-md-7 col-xs-12"
                    value="<?php echo date('d-m-Y');?>" />
            </div>
        </div>
    </div>
    <!--div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
					<span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span>
					<div class="item form-group">
						<label class="col-md-3 col-sm-3 col-xs-12" for="qty">Quantity</label>
							<div class="col-md-3 col-sm-6 col-xs-12">
							<input type="text" id="qty" name="quantity" required="required" class="form-control col-md-7 col-xs-12 keyup_check_qty " placeholder="quantity">
							</div>
							<div class="col-md-3 col-sm-6 col-xs-12">
							<select class="form-control uom" name="uom" required="required">
									<option>Unit of Measurement</option>
									<?php 
									/*$checked ='';			
										$uom = getUom();											  
										foreach($uom as $unit) {												 
											if((!empty($inventoryListing)) && ($inventoryListing->uom == $unit)){ $checked = 'selected';}else{$checked = '';  }				
											echo "<option value='".$unit."' ".$checked.">".$unit."</option>";												
											}	*/										
																			
									?>									
									</select>	
							</div>
					</div>
</div-->



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
</div>->

<div class="modal left fade" id="myModal_lotdetails" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Add Lot Details</h4>
                <span id="mssg343"></span>
            </div>
            <form name="insert_party_data" name="ins" id="insert_Matrial_data_id33">
                <div class="modal-body">
                    <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label col-md-10 col-sm-10 col-xs-12" for="name">Lot No.<span
                                class="required">*</span></label>
                        <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                            <input type="text" id="lotno" name="material_name" required="required"
                                class="form-control col-md-7 col-xs-12" value="">
                            <span class="spanLeft control-label"></span>
                        </div>
                    </div>
                    <!-- <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Material Type <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                  
                  <select name="material_type_id"  width="100%" id="material_type_id" class="form-control">
                  <option value="">Select Material Type </option>
                  
                  </select> -->
                    <input type="hidden" name="material_type_id" id="material_type_id22" class="form-control" value="">
                    <input type="hidden" name="material_name_id" id="material_name_id">

                    <span class="spanLeft control-label"></span>
                    <!--</div>
                  </div>-->
                    <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label col-md-10 col-sm-10 col-xs-12" for="email">MOU Price</label>
                        <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                            <input type="text" id="mou_price" name="hsn_code" class="form-control col-md-7 col-xs-12"
                                value="">
                            <span class="spanLeft control-label"></span>
                        </div>
                    </div>
                    <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label col-md-10 col-sm-10 col-xs-12" for="email">MRP Price</label>
                        <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                            <input type="text" id="mrp_price" name="hsn_code" class="form-control col-md-7 col-xs-12"
                                value="">
                            <span class="spanLeft control-label"></span>
                        </div>
                    </div>
                    <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label col-md-10 col-sm-10 col-xs-12" for="email">Date</label>
                        <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                            <input type="date" name="date" id="" class="form-control col-md-7 col-xs-12 req_date"
                                value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="add_matrial_Data_onthe_spot">
                    <button type="button" class="btn btn-default close_sec_model">Close</button>
                    <button id="Add_lot_details_on_button_click_mrn" type="button"
                        class="btn edit-end-btn ">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>