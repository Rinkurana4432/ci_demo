<?php

$discountColumn = false;
foreach($productData as $val){
   if( isset($val->after_desc_amt) ){
      $discountColumn = true;
      goto end;
   }
}
end:


?>

<div class="col-md-12 input_descr_wrap label-box mobile-view2 row_head">
   <div class="col-md-1 item form-group">
      <label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Material Name</label>
   </div>
   <div class="col-md-2 item form-group">
      <label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>
   </div>
   <div class="col-md-1 item form-group">
      <label class="col-md-12 col-sm-12 col-xs-12" for="HSN/SAC">HSN/SAC</label>
   </div>
   <div class="col-md-1 item form-group">
      <label class="col-md-12 col-sm-12 col-xs-12" for="Quantity">Quantity</label>
   </div>
   <div class="col-md-1 item form-group">
      <label class="col-md-12 col-sm-12 col-xs-12" for="Rate">Rate</label>
   </div>
   <?php
      if($discountColumn){
         echo    '<div class="col-md-1 item form-group">
                     <label class="col-md-12 col-sm-12 col-xs-12" for="Rate">Disc. Type</label>
                  </div>
                  <div class="col-md-1 item form-group">
                     <label class="col-md-12 col-sm-12 col-xs-12" for="Rate">Disc. Amt.</label>
                  </div>
                  <div class="col-md-1 item form-group">
                     <label class="col-md-12 col-sm-12 col-xs-12" for="Rate">Amt. After Desc.</label>
                  </div>';
      }

   ?>
   <div class="col-md-1 item form-group">
      <label class="col-md-12 col-sm-12 col-xs-12" for="Tax">Tax</label>
   </div>
   <div class="col-md-1 item form-group">
      <label class="col-md-12 col-sm-12 col-xs-12" for="UOM">UOM</label>
   </div>
   <div class="col-md-1 item form-group" style="border-right: 1px solid #c1c1c1;">
      <label class="col-md-12 col-sm-12 col-xs-12" for="Amount with Tax">Amount with Tax</label>
   </div >
</div>
<?php
   foreach($productData as $val){
   $basicAmt = $val->rate * $val->qty;
   if( isset($val->after_desc_amt) && !empty($val->after_desc_amt) ){
      $basicAmt = $val->after_desc_amt;
   }
   $material_name = getNameById('material',$val->product_details,'id');
   $uom_name = getNameById('uom',$val->UOM,'id');
?>
   <div class="add_more_credit_note_row scend-tr mailing-box col-md-12" >
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="hidden" class="itemName form-control"   name="material_id[]" value="<?= $val->product_details ?>"  >
            <input type="text" class="itemName form-control"  required="required" name="material_name[]" value="<?= $material_name->material_name ?>" readonly >
         </div>
      </div>
      <div class="item form-group col-md-2 col-sm-12 col-xs-12">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" name="descr_of_goods[]"  class="form-control col-md-1 goods_descr_section" placeholder="Description Of Goods" value="<?= $val->descr_of_goods ?>" readonly>
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" name="hsnsac[]" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC" value="<?= $val->hsnsac ?>" readonly >
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text"  required="required" name="quantity[]" class="form-control col-md-1 year goods_descr_section keyup_event_crnote" placeholder="Quantity" value="<?= $val->qty ?>">
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" name="rate[]" class="form-control col-md-1 goods_descr_section keyup_event_crnote" placeholder="Rate" value="<?= $val->rate ?>" readonly>
            <input type="hidden" name="basic_Amt[]" class="form-control col-md-1 goods_descr_section" placeholder="Rate" value="<?= $basicAmt ?>">
            <input type="hidden" name="cess_tax_calculation[]" class="form-control col-md-1 goods_descr_section" placeholder="Rate" value="<?= $val->cess_tax_calculation ?>">
            <input type="hidden" name="cess[]" class="form-control col-md-1 goods_descr_section" placeholder="Rate" value="<?= $val->cess ?>">
            <input type="hidden" name="old_sale_amount[]" class="form-control col-md-1 goods_descr_section" placeholder="Rate" value="<?= $val->old_sale_amount ?>">
         </div>
      </div>

      <?php
      if($discountColumn){ ?>

      <div class="col-md-1 col-sm-12 col-xs-12 form-group">
         <div class="checktr">
            <input type="text" name="disctype[]" class="form-control col-md-1 goods_descr_section disc_type_cls"  value="<?= ($val->disctype == 'disc_precnt' )?'disc_precnt':'disc_value'; ?>" readonly >
         </div>
      </div>

      <div class="col-md-1 col-sm-12 col-xs-12 form-group">
         <!-- <label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Amount">Disc. Amt.</label>                            -->
         <div class="checktr">
            <input type="text" name="discamt[]" class="form-control col-md-1 goods_descr_section added_discount_amt" readonly="" placeholder="Disc Amt" value="<?= $val->discamt ?>">
         </div>
      </div>

      <div class="col-md-1 col-sm-12 col-xs-12 form-group">
         <!-- <label class="col-md-12 col-sm-12 col-xs-12" for="Amount after desc">Amt. After Desc.</label> -->
         <div class="checktr">
            <input type="text" name="after_desc_amt[]" class="form-control col-md-1 goods_descr_section" readonly="" placeholder="After Disc Amt" value="<?= $val->after_desc_amt ?>">
         </div>
      </div>
      <?php } ?>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" name="tax[]" class="form-control col-md-1 goods_descr_section tax"   placeholder="Tax" value="<?= $val->tax ?>" readonly>
            <input type="hidden" value="<?= $val->added_tax_Row_val ?>" name="added_tax_Row_val[]" >
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" name="UOM1[]" class="form-control col-md-1 goods_descr_section " readonly value="<?= $uom_name->uom_quantity ?>">
            <input type="hidden" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly value="<?= $val->UOM ?>">
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" id="amount"   name="amount[]" class="form-control col-md-1 goods_descr_section AMunt" readonly placeholder="Amount" value="<?= $val->amountwittax ?>" >
         </div>
      </div>
      <button class="btn btn-danger remove_cradd_add_field" type="button"><i class="fa fa-minus"></i></button>
   </div>
<?php } ?>
