
<?php if( isset($suppliers->id) && !empty($suppliers->material_name_id)  ){
      $data = json_decode($suppliers->material_name_id);
      if( !empty($data) ){
         $i = 1;
         $wellClass = "edit-row1";
         foreach ($data as $key => $value) {
            if( $i > 1 ){
               $wellClass = "scend-tr";
            }
          ?>
            <div class="well <?= $wellClass; ?>  mobile-view" id="chkIndex_1" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">
               <div class="col-md-3 col-sm-12 col-xs-6 form-group">
                  <label class="col-md-2 col-sm-12 col-xs-12">Material Type</label>
                  <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" name="supplierMetrial[chkIndex_<?= $i; ?>][material_type_id]" data-id="material_type" data-key="id" data-fieldname="name" data-where="(created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0)" onchange="getMaterialName(event,this)" id = "material_type">
                     <option value="">Select Option</option>
                        <?php
                           if(!empty($suppliers)){
                           $material_type_id = getNameById('material_type',$value->material_type_id,'id');
                           echo '<option value="'.$value->material_type_id.'" selected>'.$material_type_id->name.'</option>';
                           }
                        ?>
                  </select>

               </div>
               <div class="col-md-3 col-sm-12 col-xs-6 form-group">
                  <label class="col-md-2 col-sm-12 col-xs-12">Material Name</label>
                  <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name Add_mat_onthe_spot" id="mat_name" required="required" name="supplierMetrial[chkIndex_<?= $i; ?>][material_name]" onchange="getTax(event,this)"  data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> 
                     AND material_type_id = <?php echo $value->material_type_id;?> AND status=1">
                     <option value="">Select Option</option>
                     <?php 
                        $materialname = getNameById('material',$value->material_name,'id');
                        echo '<option value="'.$value->material_name.'" selected>'.$materialname->material_name.'</option>';
                     ?>
                  </select>
               </div>
               <div class="col-md-2 col-sm-12 col-xs-6 form-group">                    
                  <input type="text" id="uom" value="<?= $value->uom??'N\A' ?>" name="supplierMetrial[chkIndex_<?= $i; ?>][uom]" class="form-control uomSupplier uom1" readonly style="width: 100%;">                                  
               </div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                  <fieldset>
                     <div class="control-group">
                        <div class="controls">
                           <div class="input-prepend input-group">
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              <input type="text" name="supplierMetrial[chkIndex_<?= $i; ?>][supplierDeliveryDate]" value="<?= $value->supplierDeliveryDate ?>" class="form-control daterange" />
                           </div>
                        </div>
                     </div>
                  </fieldset>
               </div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                  <label class="col-md-2 col-sm-12 col-xs-12 ">Price</label>
                  <input style="border-right: 1px solid #c1c1c1 !important;" type="text" id="price"  name="supplierMetrial[chkIndex_<?= $i; ?>][price]" class="form-control" value="<?= $value->price ?>" placeholder="Price"  min="0">
               </div>
               <button class="btn btn-danger remove_btn plus-btn" type="button"><i class="fa fa-minus"></i></button>
            </div>
              
   <?php $i++; }
      }
} else { ?>
      <div class="well mobile-view" id="chkIndex_1" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">
         <div class="col-md-3 col-sm-12 col-xs-6 form-group">
            <label class="col-md-2 col-sm-12 col-xs-12">Material Type</label>
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" name="supplierMetrial[chkIndex_1][material_type_id]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
               <option value="">Select Option</option>
            </select>
         </div>
         <div class="col-md-3 col-sm-12 col-xs-6 form-group">
            <label class="col-md-2 col-sm-12 col-xs-12">Material Name</label>
            <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name Add_mat_onthe_spot" id="mat_name" required="required" name="supplierMetrial[chkIndex_1][material_name]" onchange="getTax(event,this)">
               <option value="">Select Option</option>
            </select>
         </div>
         <div class="col-md-2 col-sm-12 col-xs-6 form-group">                    
            <input type="text" id="uom" name="supplierMetrial[chkIndex_1][uom]" class="form-control uomSupplier uom1" readonly style="width: 100%;">                                  
         </div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" name="supplierMetrial[chkIndex_1][supplierDeliveryDate]" value="" class="form-control daterange" />
                     </div>
                  </div>
               </div>
            </fieldset>
         </div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <label class="col-md-2 col-sm-12 col-xs-12 ">Price</label>
            <input style="border-right: 1px solid #c1c1c1 !important;" type="text" id="price"  name="supplierMetrial[chkIndex_1][price]" class="form-control" placeholder="Price"  min="0">
         </div>
         <button style="margin-right: 0px;" class="btn btn-danger remove_field" type="button"> <i class="fa fa-minus"></i></button>
      </div>

<?php } ?>
