<?php
	$material_name_id = getNameById('material', $material_name, 'id');
	
	


 ?>
<div class="well <?php if($i==1){ echo 'edit-row1 mobile-view  ';}else{ echo 'scend-tr mobile-view';}?>" id="chkWell_<?php echo $i; ?>" >
   <div class="col-md-1 col-sm-12 col-xs-6 form-group">
      <label class="col-md-2 col-sm-12 col-xs-12">Material Type</label>
      <select class="form-control selectAjaxOption select2 material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" 
      name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
         <?php
            if(!empty($material_type)){
            $material_type_id = getNameById('material_type',$material_type,'id');
            echo '<option value="'.$material_type.'" selected>'.$material_type_id->name.'</option>';
            }
            ?> 
      </select>
   </div>
   <div class="col-md-1 col-sm-12 col-xs-12 form-group">
      <label>M. Name <span class="required">*</span></label>
      <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $material_type;?> AND status=1">
         <?php
            echo '<option value="' . $material_name . '" selected>' . $material_name_id->material_name . '</option>';
            
            ?>
      </select>
   </div>
   <div class="col-md-2 col-sm-12 col-xs-12 form-group totl_amt">
      <label>Description</label>
      <textarea id="description" name="description[]" class="form-control col-md-7 col-xs-12 description"><?= $description??'' ?></textarea>         
   </div>
   <div class="col-md-2 col-sm-6 col-xs-12 form-group">
      <label style="float:left; width:100%">Quantity &nbsp; &nbsp; UOM</label>
      <input type="text" id="quantity" name="quantity[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" value="<?= $remaning_qty??'' ?>"  min="0" onkeypress="return float_validation(event, this.value)">
      <input type="hidden" value="1" name="po_or_not">
      <input type="text" id="uom" name="uom1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12 uom" value="<?php 
         $ww =  getNameById('uom', $uom,'id');
         $uom = !empty($ww)?$ww->ugc_code:'';
         echo $uom;
         ?>" readonly>
      <input type="hidden" name="uom[]" readonly value="<?php echo $uom; ?>">
   </div>
   <div class="col-md-1 col-sm-6 col-xs-12 form-group">
      <label>Price</label>
      <input type="text" id="amount" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)"  onchange="keyupFunction(event,this)" value="<?= $expected_amount??''  ?>" readonly  min="0" onkeypress="return float_validation(event, this.value)" required="required">
   </div>
   <div class="col-md-1 col-sm-6 col-xs-12 form-group">
      <label>Sub Total</label>
      <input type="text" name="sub_total[]" placeholder="sub total" class="form-control col-md-7 col-xs-12 key-up-event" id="sub_total" readonly value="<?= $sub_total??'' ?>"  min="0">
   </div>
   <div class="col-md-1 col-sm-6 col-xs-12 form-group">
      <label>GST</label>
      <input type="text" name="gst[]" placeholder="gst" class="form-control col-md-7 col-xs-12 key-up-event gst_tax" id="gst_tax" value="<?php if (!empty($material_name_id)) echo $material_name_id->tax; ?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"  min="0" onkeypress="return float_validation(event, this.value)">
   </div>
   <?php
      if(!empty($material_name_id) && $material_name_id->tax != ''   ){
         $subtax = $sub_total * $material_name_id->tax/100;
      }else{
         $subtax = 0;
      }
      $total = $sub_total + $subtax;
      $grand_total += $total;
      ?>
   <div class="col-md-1 col-sm-6 col-xs-12 form-group">
      <label>Sub Tax</label>
      <input type="text" name="sub_tax[]" id="sub_tax" placeholder="tax" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php echo $subtax; ?>"  min="0">
   </div>
   <div class="col-md-2 col-sm-6 col-xs-12 form-group totl_amt">
      <label style="border-right: 1px solid #c1c1c1 !important;">Total</label>
      <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="total[]" placeholder="total" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php echo $total; ?>"  min="0">
   </div>
   <?php if( $i > 1 ){ ?>
      <button style="margin-right:0px; margin-top: 0px;" class="btn   btn-danger plus-btn check_matt " type="button"> <i class="fa fa-minus "></i></button>
      <input type="hidden" value="" name="remove_mat[]" class="for_hide_val">
   <?php } ?>
</div>