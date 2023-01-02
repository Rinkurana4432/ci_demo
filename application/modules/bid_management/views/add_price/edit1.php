<?php   
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   
   ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>crm/save_add_price" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php if(!empty($account)){ echo $account->id;   }?>">
   <input type="hidden" id="loggedUser" value="<?php echo $this->companyGroupId; ?>">
   <input type="hidden" name="created_by" value="<?php if(!empty($account)){ echo $account->created_by;   }?>">
   <input type="hidden" name="save_status" value="1" class="save_status">	
   <h3 class="Material-head" style="margin-bottom: 30px;">
      Competitor Price Information
      <hr>
   </h3>
   <div class="required item form-group col-md-12 col-sm-12 col-xs-12">
         <label class="required col-md-3 col-sm-12 col-xs-12" for="account_id">Compitetor Name </label>
         <div class="required col-md-6 col-sm-12 col-xs-12">
            <select class="itemName form-control selectAjaxOption select2" id="account_id" name="account_id" data-id="competitor_details" data-key="id" data-fieldname="name" data-where="account_owner = <?php echo /*$_SESSION['loggedInUser']->c_id*/ $this->companyGroupId ; ?> AND save_status = 1" width="100%">
               <option value="">Select Option</option>
               <?php 
                 /* if(!empty($account)){
                     $account = getNameById('competitor_details',$account->id,'id');
                     echo '<option value="'.$account->id.'" selected>'.$account->name.'</option>';
                  }*/
               ?>
            </select>
         </div>
      </div>


   <hr>
   <div class="bottom-bdr"></div>
   <!-- <div class="ln_solid"></div> -->
   <h3 class="Material-head">
      Product Details
      <hr>
   </h3>
   <div class="item form-group ">
      <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
         <div class="item form-group">
            <div class="col-md-12 input_holder middle-box">
               <?php  if(empty($account->product_detail)){  ?>
               <div class="well " id="chkIndex_1" style=" overflow:auto;">
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <label>Material Type</label>
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialNameCA(event,this)" id="material_type">
                        <option value="">Select Option</option>
                        <?php
                           if(!empty($product_detail)){
                           	$material_type_id = getNameById('material_type',$product_detail->material_type_id,'id');
                           	echo '<option value="'.$product_detail->material_type_id.'" selected>'.$material_type_id->name.'</option>';
                           	}
                           ?>	
                     </select>
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <label>Material Name</label>
                     <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name[]" onchange="getUomCA(event,this);">
                        <option value="">Select Option</option>
                     </select>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Discription</label>								
                     <input type="text" id="qty" name="disc[]" class="form-control col-md-7 col-xs-12"  placeholder="Disc." value="">
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>UOM</label>
                     <input type="text" name="uom_value1[]" class="form-control col-md-7 col-xs-12  uom" value="" readonly>
                     <input type="hidden" name="uom_value[]" class="uom1" readonly value="">						
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Price</label>	
                     <input type="text" name="price[]" class="form-control col-md-7 col-xs-12 priceValue" placeholder="Price" value="">	
                  </div>
               </div>
               <div class="col-sm-12 btn-row">
                  <div class="input-group-append">
                     <button class="btn edit-end-btn addmaterial" type="button">Add</button>
                  </div>
               </div>
               
               <?php }
                  else{ 
                  # pre($account->product_detail);  
                  $products = json_decode($account->product_detail);
                  if(!empty($products)){ 
                        $i =  1;
                        foreach($products as $product){
                  
                  ?>
               <div class="well <?php if($i==1){ echo 'edit-row1';}else{ echo 'scend-tr mobile-view';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkIndex_<?php echo $i; ?>">
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <label>Material Type</label>
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" onchange="getMaterialNameCA(event,this)" id="material_type">
                        <option value="">Select Option</option>
                        <?php
                           if(!empty($product) && isset($product->material_type_id)){
                           	$material_type_id = getNameById('material_type',$product->material_type_id,'id');
                           	echo '<option value="'.$product->material_type_id.'" selected>'.$material_type_id->name.'</option>';
                           }
                           ?>	
                     </select>
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <label>Material Name</label>
                     <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND material_type_id = <?php echo $product->material_type_id;?>  AND status=1" onchange="getUomCA(event,this);">
                        <option value="">Select Option</option>
                        <?php 
                                       if(!empty($product)){
                                          $material = getNameById('material',$product->material_name_id,'id');
                                          echo '<option value="'.$material->id.'" selected>'.$material->material_name.'</option>';
                                       }
                                    ?>
                     </select>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                     <label>Discription</label>
                     <input type="text" id="qty" name="disc[]"  class="form-control col-md-7 col-xs-12" placeholder="Enter Quantity" value="<?php if(!empty($product)) echo $product->disc; ?>">
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>UOM</label>
                     <?php
                        $ww =  getNameById('uom', $product->unit,'id');
                        $uom = !empty($ww)?$ww->ugc_code:'';
                        ?>
                     <input type="text" name="uom_value1[]" class="form-control col-md-7 col-xs-12 uom" value="<?php echo $uom; ?>" readonly>														
                     <input type="hidden" name="uom_value[]" class="uom1" readonly value="<?php if(!empty($product)) echo $product->unit; ?>">
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Price</label>
                     <input type="text" name="price[]" class="form-control col-md-7 col-xs-12 priceValue" placeholder="Price" value="<?php if(!empty($product)) echo $product->price; ?>">	
                  </div>
                  <button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>
               </div>
               <div class="col-sm-12 btn-row"><button class="btn edit-end-btn  addmaterial" type="button">Add</button></div>
               <!--</?php if($i==1){
                  echo '<div class="col-sm-12 btn-row"><button class="btn edit-end-btn  addmaterial" type="button">Add</button></div>';
                  	}else{	
                  echo '<button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>';
                  } ?>-->
               <?php 
                  $i++;
                  		}}}?>
            </div>
         </div>
      </div>
   </div>
   <div class="form-group" style="text-align:center;">
      <div class="col-md-12 col-xs-12">
         <center>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <?php if((!empty($account) && $account->save_status !=1) || empty($account)){
               echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
               }?> 
            <input type="submit" class="btn edit-end-btn" value="Submit">
         </center>
      </div>
   </div>
</form>