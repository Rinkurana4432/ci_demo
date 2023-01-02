<?php   
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   
   ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>bid_management/save_competitor_details" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php if(!empty($account)){ echo $account->id;   }?>">
   <input type="hidden" id="loggedUser" value="<?php echo $this->companyGroupId; ?>">
   <input type="hidden" name="created_by" value="<?php if(!empty($account)){ echo $account->created_by;   }?>">
   <input type="hidden" name="save_status" value="1" class="save_status">	
   <h3 class="Material-head" style="margin-bottom: 30px;">
      Competitor Information
      <hr>
   </h3>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group col-md-12 col-sm-12 col-xs-12">
         <label class="col-md-3 col-sm-2 col-xs-12" for="name">Company Name </label>
         <div class="col-md-6 col-sm-10 col-xs-12">
          <?php if(!empty($account)) echo $account->name ;?>
         </div>
      </div>
      <div class="item form-group col-md-12 col-sm-12 col-xs-12">
         <label class="col-md-3 col-sm-2 col-xs-12" for="gstin">GSTIN </label>
         <div class="col-md-6 col-sm-10 col-xs-12">
           <?php if(!empty($account)) echo $account->gstin ;?>
         </div>
      </div>
      <div class="item form-group col-md-12 col-sm-12 col-xs-12">
         <label class="col-md-3 col-sm-2 col-xs-12" for="email">Email </label>
         <div class="col-md-6 col-sm-10 col-xs-12">
           <?php if(!empty($account)) echo $account->email ;?>
         </div>
      </div>
      <div class="item form-group col-md-12 col-sm-12 col-xs-12">
         <label class="col-md-3 col-sm-2 col-xs-12" for="phone">Phone <span class="required">*</span></label>
         <div class="col-md-6 col-sm-10 col-xs-12">
           <?php if(!empty($account)) echo $account->phone ;?>
         </div>
      </div>
      
      <?php /*<div class="item form-group col-md-6 col-sm-6 col-xs-12">
         <label class="control-label col-md-2 col-sm-2 col-xs-4" for="phone">Fax</label>
         <div class="col-md-10 col-sm-10 col-xs-8">
         	<input type="number" id="fax" name="fax" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($account)) echo $account->fax ;?>">
   </div>
   </div>*/?>
   <div class="item form-group col-md-12 col-sm-12 col-xs-12">
      <label class=" col-md-3 col-sm-2 col-xs-12" for="website">Website</label>
      <div class="col-md-6 col-sm-10 col-xs-12">
        <?php if(!empty($account)) echo $account->website ;?>
      </div>
   </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group col-md-12 col-sm-12 col-xs-12">
         <label class="col-md-3 col-sm-2 col-xs-12" for="employee">Employees</label>
         <div class="col-md-6 col-sm-10 col-xs-12">
        <?php if(!empty($account)) echo $account->employee ;?>
         </div>
      </div>
      <div class="item form-group col-md-12 col-sm-12 col-xs-12">
         <label class="col-md-3 col-sm-2 col-xs-12" for="phone">Industry</label>
         <div class="col-md-6 col-sm-10 col-xs-12">
            <select class="form-control" name="industry" disabled>
               <option value="">Select</option>
               <?php 
                  $selectedIndustry = '';
                  $industries = industries();
                  foreach($industries as $industry) {
                  	if($industry == $account->industry){
                  		$selectedIndustry = 'selected';
                  	}else{
                  		$selectedIndustry = '';
                  	}						
                  	echo "<option value='".$industry."' ".$selectedIndustry.">".$industry."</option>";	
                  }
                  ?>														
            </select>
         </div>
      </div>
      <div class="item form-group col-md-12 col-sm-12 col-xs-12">
         <label class="col-md-3 col-sm-2 col-xs-12" for="revenue">Annual Revenue</label>
         <div class="col-md-6 col-sm-10 col-xs-12">
           <?php if(!empty($account)) echo $account->revenue ;?>
         </div>
      </div>
      <div class="item form-group col-md-12 col-sm-12 col-xs-12">
         <label class="col-md-3 col-sm-2 col-xs-12" for="description">Description</label>
         <div class="col-md-6 col-sm-10 col-xs-12">
            <?php if(!empty($account)) echo $account->description ;?>
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <!-- <div class="ln_solid"></div> -->
   <h3 class="Material-head">
      Material Details
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
                     <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name[]" onchange="getUomCA(event,this);" disabled>
                        <option value="">Select Option</option>
                     </select>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Description</label>								
                     <input type="text" id="qty" name="disc[]" class="form-control col-md-7 col-xs-12"  placeholder="Disc." value="" disabled>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>UOM</label>
                     <input type="text" name="uom_value1[]" class="form-control col-md-7 col-xs-12  uom" value="" readonly>
                     <input type="hidden" name="uom_value[]" class="uom1" readonly value="">						
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Price</label>	
                     <input type="text" name="price[]" class="form-control col-md-7 col-xs-12 priceValue" placeholder="Price" value="" readonly>	
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
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" onchange="getMaterialNameCA(event,this)" id="material_type" disabled>
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
                     <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND material_type_id = <?php echo $product->material_type_id;?>  AND status=1" onchange="getUomCA(event,this);" disabled>
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
                     <input type="text" id="qty" name="disc[]"  class="form-control col-md-7 col-xs-12" placeholder="Enter Quantity" value="<?php if(!empty($product)) echo $product->disc; ?>" readonly>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>UOM</label>
                     <?php
                        $ww =  getNameById('uom', $product->unit,'id');
                        $uom = !empty($ww)?$ww->ugc_code:'';
                        ?>
                     <input type="text" name="uom_value1[]" class="form-control col-md-7 col-xs-12 uom" value="<?php echo $uom; ?>" readonly>														
                     <input type="hidden" name="uom_value[]" class="uom1" readonly value="<?php if(!empty($product)) echo $product->unit; ?>" readonly>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Price</label>
                     <input type="text" name="price[]" class="form-control col-md-7 col-xs-12 priceValue" placeholder="Price" value="<?php if(!empty($product)) echo $product->price; ?>" readonly>	
                  </div>
                  <button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>
               </div>
              
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
  
</form>