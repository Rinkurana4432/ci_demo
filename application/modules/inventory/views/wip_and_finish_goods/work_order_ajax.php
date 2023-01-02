<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
   <div class="item form-group">
      <label class="col-md-3 col-sm-12 col-xs-12" for="material">Material Type </label>
      <div class="col-md-6 col-sm-12 col-xs-12" >
         <select class="form-control selectAjaxOption select2  material_type_id select2" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="false" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
            <option value="">Select Option</option>
            <?php 	if(!empty($products_array)){
               $material_type_id = getNameById('material_type',$products_array->material_type_id,'id');
               echo '<option value="'.$products_array->material_type_id.'" selected>'.$material_type_id->name.'</option>';
               }?>
         </select>
      </div>
   </div>
</div>
<div class="col-md-12 middle-box2">
   <div class="well" id="chkIndex_1" style="overflow:auto;" >
      <input  class="sale_order_id" name="sale_order_id" type="hidden" value="<?php if(!empty($products_array)){ echo $products_array->sale_order_id; }?>" >			
      <div class="item form-group ">
         <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
            <div class="item form-group">
               <div class="col-md-12 input_holder middle-box">
                  <?php
                     if(!empty($products_array)){
                       $product_detail = json_decode($products_array->product_detail);
                        $i =0;
                       foreach($product_detail as $work_order_product){
                       $materialName = getNameById('material',$work_order_product->product,'id');
                       //$pendingQty = getPendingQtyOfSalesOrder('work_order',$sale_order_id ,'sale_order_id');
                       ?>
                  <div class="well <?php if($i==0){ echo 'edit-row1';}else{ echo 'scend-tr mobile-view';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkIndex_<?php echo $i; ?>">
                     <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                        <label>Material Name</label>
                        <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getUom(event,this);">
                           <option value="">Select Option</option>
                           <?php
                              echo '<option value="'.$work_order_product->product.'" selected>'.$materialName->material_name.'</option>';
                              ?>
                        </select>
                     </div>
                     <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                        <label>WorkOrder Qty&nbsp;&nbsp;&nbsp;<span  style="color:red;"></span></label><input type="number"  name="transfer_quantity[]" class="form-control col-md-7 col-xs-12 transfer_quantity"  placeholder="WorkOrder Qty" value="<?php echo (isset($work_order_product->transfer_quantity)?$work_order_product->transfer_quantity:0); ?>" onkeyup = "UpdatePendingQtyValue(event,this)"   onkeypress="UpdatePendingQtyValue(event,this)">
                        <span id="transferqtyMessage" style="color:red;"></span>
                     </div>
                     <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                        <label>UOM</label>
                        <?php	$ww =  getNameById('uom', $work_order_product->uom,'id');
                           $uom = !empty($ww)?$ww->ugc_code:'';
                           ?>
                        <input type="text" class="form-control col-md-7 col-xs-12" placeholder="uom." value="<?php echo $uom; ?>" readonly>
                        <input type="hidden" name="uom[]" class="form-control col-md-7 col-xs-12  uom" value="<?php echo $work_order_product->uom; ?>">
                     </div>
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <label>Job card</label>
                        <input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12  job_card" placeholder="Job card" value="<?php echo $work_order_product->job_card; ?>" readonly>
                     </div>
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <label>Output</label>
                        <input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12 " placeholder="Output" value="" >
                     </div>
                  </div>
                  <?php $i++;}} ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>