 
<div class="well <?php if($i==1){ echo 'edit-row1 mobile-view';}else{ echo 'scend-tr mobile-view';}?>" id="chkWell_<?php echo $i; ?>" style="overflow:auto; border-bottom: 1px solid #c1c1c1 !important; border-right: 1px solid #c1c1c1 !important;">
   <input type="hidden" id="description" name="description[]" class="form-control col-md-7 col-xs-12 description" value="<?php if ($mrnOrder && !empty($mrnOrder)) {echo $OrderMaterialDetail->description;} ?>">
   <!-- <div class="col-md-1 col-sm-12 col-xs-12 form-group">
      <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
      <?php
         if (!empty($OrderMaterialDetail)) {
            $material_type_id = getNameById('material_type', $OrderMaterialDetail->material_type_id, 'id');
            echo '<option value="' . $OrderMaterialDetail->material_type_id . '" selected>' . $material_type_id->name . '</option>';
         }
         ?> 
      </select>
   </div> -->
   <select class="appendMaterialTypeIdByMat material_type_id" style="width:0;height: 0;position: absolute;" name="material_type_id[]">
    <option value="<?= $OrderMaterialDetail->material_type_id ?>"><?= $OrderMaterialDetail->material_type_id ?></option>
   </select>
   <div class="col-md-2 col-sm-12 col-xs-12 form-group">
      <label>M. Name</label>
      <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getTaxPOrder(event,this);getlot(event,this)" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>  AND status=1" readonly >
         <option value="">Select Option</option>
         <?php
            echo '<option value="' . $OrderMaterialDetail->material_name_id . '" selected>' . getPCode($OrderMaterialDetail->material_name_id).$materialName->material_name . '</option>';
            ?>
      </select>
   </div>
   <div class="col-md-1 col-sm-12 col-xs-6 form-group">
   
      <span class="totl_amt33">
                   <?php 
					$attachments = $this->purchase_model->get_image_by_materialId('attachments', 'rel_id', $OrderMaterialDetail->material_name_id);
					if(!empty($attachments)){
						echo '<img style="width: 50px; height: 37px; margin-left:34px;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
					}else{
						echo '<img style="width: 50px; height: 37px; margin-left:34px;" src="'.base_url().'assets/uplodimg/noimage.jpg">';
					}
					?>
					</span>
					<div class="MatImage col-xs-12"></div>
					<input type="hidden" name="matimg[]" value="" class="matimgcls">
   </div>
   
   <div class="col-md-1 col-sm-6 col-xs-12 form-group">
      <label>Alias</label>
       <input  name="aliasname[]" class="form-control col-md-7 col-xs-12 aliasname" value="<?php if ($mrnOrder && !empty($mrnOrder)) { echo $OrderMaterialDetail->aliasname;} ?>" readonly> 
   </div>
   <div class="col-md-1 col-sm-6 col-xs-12 form-group">
      <label style="float: left;width: 100%;">Quantity &nbsp; &nbsp; UOM</label>
       
      <input type="text" id="quantity" name="quantity[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)"   value="<?php if ($mrnOrder && !empty($mrnOrder)) {

                        switch($typeGrn){
                           case 'convert_pi_to_mrn':
                              echo $OrderMaterialDetail->remaning_qty;
                           break;
                           case 'editGrn':
                              echo $OrderMaterialDetail->quantity;
                           break;
                           case 'convert_po_to_grn':
                              echo $OrderMaterialDetail->remaning_qty;
                           break;      
                        }
                  } ?>">

      <input type="hidden" value="0" name="mrn_or_not">
      <input type="hidden" value="1" name="ifbalance">
      <input type="text" id="uom" name="uom1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12 uom1" value="<?php 
         //if ($mrnOrder && !empty($mrnOrder)) {echo $OrderMaterialDetail->uom;} 
         $ww =  getNameById('uom', $OrderMaterialDetail->uom,'id');
         $uom = !empty($ww)?$ww->ugc_code:'';
         echo $uom;
         ?>" readonly>
      <input type="hidden" name="uom[]" readonly class="uom" value="<?php echo $OrderMaterialDetail->uom; ?>">                            
   </div>
   <div class="col-md-1 col-sm-6 col-xs-12 form-group">
      <label>Price</label>
      <input type="text" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" value="<?php 
         if ($mrnOrder && !empty($mrnOrder)) {
            if( $OrderMaterialDetail->price ){
                  echo $OrderMaterialDetail->price;      
            }else{
               echo $OrderMaterialDetail->expected_amount;    
            }
         } ?>" readonly>
   </div>
   <input type="hidden" name="sub_total[]" placeholder="sub total" class="form-control col-md-7 col-xs-12 key-up-event"value="<?php if ($mrnOrder && !empty($mrnOrder)) {echo $OrderMaterialDetail->sub_total;} ?>">
   <input type="hidden" value="<?php if ($mrnOrder && !empty($mrnOrder)) {echo $OrderMaterialDetail->sub_total;} ?>" name="sub_total_amt_purchse_bill[]">
   <div class="col-md-1 col-sm-6 col-xs-12 form-group">
      <label>GST</label>
      <input type="text" name="gst[]" placeholder="gst" class="form-control col-md-7 col-xs-12 key-up-event gst_tax" id="gst_tax" value="<?php if (!empty($mrnOrder)) { echo $OrderMaterialDetail->gst; } ?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)">
   </div>
   <div class="col-md-1 col-sm-6 col-xs-12 form-group">
      <label>Tax</label>
      <input type="text" name="sub_tax[]" placeholder="tax" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php 
         if ($mrnOrder && !empty($mrnOrder)) {echo $OrderMaterialDetail->sub_tax;
         } ?>">
   </div>
   <div class="col-md-1 col-sm-6 col-xs-12 form-group" style="display: inline-flex;">
      <label>Rcv'd Qty</label>
      <input type="text" name="received_quantity[]" placeholder="Received Quantity" class="form-control col-md-12 col-xs-12 key-up-event"  onchange="keyupFunction(event,this)" onkeyup="keyupFunction(event,this)" required="required" value="<?php if ($mrnOrder && !empty($mrnOrder)) {
            if( $mrnEdit ){
                  echo $OrderMaterialDetail->received_quantity;   
            }else{
               echo $OrderMaterialDetail->remaning_qty;   
            }
         } ?>" >
      <input type="text" name="invoice_quantity[]" placeholder="Invoice Quantity" class="form-control col-md-12 col-xs-12" onkeypress="return float_validation(event, this.value)" value="<?php if( $mrnEdit ){ echo $OrderMaterialDetail->invoice_quantity; } ?>" >
   </div>
    <input type="hidden" value="0" name="discount[]" id="discount">
   <div class="col-md-1 col-sm-6 col-xs-12 form-group">
      <label>Total</label>
      <!-- <input type="text" name="total[]" placeholder="total" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php if ($mrnOrder && !empty($mrnOrder)) { echo $OrderMaterialDetail->total; } ?>"> -->
      <input type="text" name="total[]" placeholder="total" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php if ($mrnOrder && !empty($mrnOrder)) { if( $mrnEdit ){ echo $OrderMaterialDetail->total; }else{ echo ($OrderMaterialDetail->remaning_qty * $OrderMaterialDetail->price)  + $OrderMaterialDetail->sub_tax; } } ?>">
      <input type="hidden" value="<?php if ($mrnOrder && !empty($mrnOrder)) { echo $OrderMaterialDetail->total; } ?>" name="amount_with_tax[]">
   </div>
   <div class="col-md-2 col-sm-6 col-xs-12 form-group">
      <div class="defectedContainer displayFlex">
         <div class="defCheck">
            <input type="checkbox" class="flat defected" <?php if( $mrnEdit ){ if($OrderMaterialDetail->defected == 1){echo 'checked';} } ?> /> 
            <input type="hidden" name="defected[]" class="defectedVal" value="<?php if( $mrnEdit ){ echo $OrderMaterialDetail->defected ; } ?>"/> 
         </div>
         <div class="defRession <?php  echo ($OrderMaterialDetail->defected == 1)?'':'hideDiv'; ?> defected_reason_div" >
            <div class="defectedQtyRes displayFlex">
               <input type="text" name="defectedQty[]" class="form-control" value="<?php if( $mrnEdit ){ echo $OrderMaterialDetail->defectedQty; } ?>" onkeypress="return float_validation(event, this.value)" onkeyup="keyupFunction(event,this)" /> 
               <textarea name="defected_reason[]" class="form-control col-md-7 col-xs-12 defected_reason" placeholder="Defected Reason">
                  <?php if( $mrnEdit ){ echo $OrderMaterialDetail->defected_reason; } ?>
               </textarea>                                    
            </div>
         </div>
      </div>
   </div>
   <?php if( $i > 1 ){ ?>
      <button class="btn btn-danger" type="button" style="position: absolute;right: 0;bottom: 14px;" > <i class="fa fa-minus check_matt"></i></button>
      <input type="hidden"  name="remove_mat[]" class="for_hide_val">
   <?php } ?>
</div>