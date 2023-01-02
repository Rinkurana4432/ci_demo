<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/updateRejInventory" enctype="multipart/form-data" novalidate="novalidate">
   <?php //pre($convert_inventory); ?>
   <input type="hidden" name="material_name_id" value="<?php echo $convert_inventory->material_name_id; ?>" id="material_id">
   <input type="hidden" name="material_type_id" value="<?php echo $convert_inventory->material_type_id; ?>" id="material_type_id">
   <input type="hidden" name="inventory_id" value="<?php echo $convert_inventory->id; ?>">
   <?php $source_address = json_decode($convert_inventory->source_address);
   $locationAddress = getNameById('company_address',$source_address->source_location,'id');
   $lot_details = getNameById('lot_details',$source_address->source_lot_no,'id');
   $locations = $this->inventory_model->get_data_byLocationId('mat_locations', 'material_name_id', $convert_inventory->material_name_id);
    ?>
   <div class="col-md-7 col-xs-12 col-sm-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="supp_code">Quantity</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
         <input type="text" readonly="readonly" class="form-control col-md-12 col-xs-12 alreadyQTY" placeholder="Quantity" value="<?php echo $convert_inventory->quantity; ?>" style="border-right: 1px solid #c1c1c1 !important;">
         </div>
      </div>
   </div>


<div class="well " style="overflow:auto; border-top: 1px solid #c1c1c1 ; border-right: 1px solid #c1c1c1 ;" id="chkIndex_1">
<input type="hidden" name="id_loc" value="<?php echo $locations[0]['id'] ?>">
<div class="col-md-4 col-sm-12 col-xs-12 form-group">
<label> Address</label>
<select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" onchange="getArea(event,this);getlot(event,this)" data-where="created_by_cid=<?php echo $_SESSION['loggedInCompany']->u_id; ?>">
<option value="">Select Option</option>
<option value="<?php echo $locationAddress->id; ?>" <?php if(!empty($locationAddress->location)){echo 'selected'; } ?>><?php echo $locationAddress->location; ?></option>
</select>
</div>
<!--div class="col-md-4 col-sm-6 col-xs-12 form-group">
<label>Storage</label>
<select class="area form-control" name="storage">
<option value="">Select Option</option>
<option value="</?php echo $source_address->source_storage; ?>" </?php if(!empty($source_address->source_storage)){echo 'selected'; } ?>></?php echo $source_address->source_storage; ?></option>
</select>
</div>
<div class="col-md-2 col-sm-6 col-xs-12 form-group">
<label>Rack number</label>
<input type="text" id="rack" value="</?php echo $source_address->source_rack_no; ?>" name="rackNumber" class="form-control col-md-7 col-xs-12" placeholder="Rack number"> 
</div>
<div class="col-md-2 col-sm-6 col-xs-12 form-group">
<label>Lot No.</label>
<select class="lotno lotno22 form-control col-md-2 col-xs-12 select2" name="lotno">
<option value="">Select Option</option>
<option value="</?php echo $source_address->source_lot_no; ?>" </?php if(!empty($source_address->source_lot_no)){echo 'selected'; } ?>></?php echo $lot_details->lot_number; ?></option>
</select>
</div-->
<div class="col-md-4 col-sm-6 col-xs-12 form-group">
<label style=" border-right: 1px solid #c1c1c1 !important;">Quantity</label>
<input style=" border-right: 1px solid #c1c1c1 !important;" type="text" id="qty" name="quantityn" data-qty="<?php echo $convert_inventory->quantity; ?>" value="" class="form-control col-md-7 col-xs-12 rej_qty_chk" placeholder="Quantity" onkeyup="getQtyValue(event,this)">
</div>
</div>


   <div class="col-md-12 " style="margin: 20px 0px;">
      <center>
         <!--button type="reset" class="btn btn-default">Reset</button-->
         <button id="send" type="submit" class="btn btn-warning">Submit</button> <a class="btn btn-danger" data-dismiss="modal">Cancel</a> 
      </center>
   </div>
</form>