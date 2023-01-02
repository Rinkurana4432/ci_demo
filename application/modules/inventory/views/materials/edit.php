<style>
   .set_dimension {
   clear: both;
   }
   input.ädding_dimension {
   margin-right: 10px;
   width: 20px;
   height: 15px;
   }
</style>
<?php
   // pre($materials);die;
   // pre($materials);die;
   if(!empty($materials) && $materials->save_status == 1) {
   
   $last_id = getLastTableId('material');
     $rId = $last_id + 1;
     $matCode = 'MAT_'.rand(1, 1000000).'_'.$rId;
     $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
     
     
      // pre($materials);
   
   
     ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveMaterial" enctype="multipart/form-data" id="materialForm" novalidate="novalidate">
   <input type="hidden" id="id" value="<?php if(!empty($rId)) echo $rId; ?>">
   <input type="hidden" id="materialId" name="id" value="<?php if(!empty($materials)) echo $materials->id; ?>">
   <input type="hidden" id="product_code" name="product_code" value="<?php if(!empty($materials)) echo $materials->product_code; ?>">
   <input type="hidden" id="mat_id_funcs" value="<?php if(!empty($materials)) echo $materials->id; ?>">
   <input type="hidden" name="save_status" value="1" class="save_status rtr">
   <input type="hidden" name="prefix" class="matPrefix" value="<?php if($materials && !empty($materials)){ echo $materials->prefix;} ?>">
   <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
   <input type="hidden" name="inventory_listing_mat_side" value="" id="inventory_listing_mat_side">
   <?php
      $get_discount_details = getNameById('company_detail',$this->companyGroupId,'id');
      if($get_discount_details->invnt_loc_on_off == 1){
         $display = "block";
         $rdonly = "readonly";
      }
      else{
         $display = "none";
         $rdonly = "";
      }
      ?>
   <?php
      if(empty($materials)){
      ?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>">
   <?php }else{ ?>
   <input type="hidden" name="created_by" value="<?php if($materials && !empty($materials)){ echo $materials->created_by;} ?>">
   <?php } ?>
   <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="code">Material Code</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="material_code" class="form-control col-md-7 col-xs-12" name="material_code" placeholder="both name(s) e.g Jon Doe" type="text" value="<?php if(!empty($materials)) echo $materials->material_code; else echo $matCode; ?>" readonly> 
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="materail_type">Material Type<span class="required" style="color:red;">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible materialTypeId" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" id="material_typewsws" onchange="ChangePrefix_and_subType();">
               <option value="">Select Option</option>
               <?php if(!empty($materials)){
                  $material_type_id = getNameById('material_type',$materials->material_type_id,'id');
                  echo '<option value="'.$materials->material_type_id.'" material_type_prefix="'.$material_type_id->prefix.'" selected >'.$material_type_id->name.'</option>';
                  }?>
            </select>
         </div>
      </div>
      <span id="selectedMaterialSubType" style="display:none;"><?php if(!empty($materials)){ echo $materials->sub_type; } ?></span>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="materail_type">Material Sub Type</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <select class="subtype form-control" name="sub_type">
               <?php if(!empty($materials)){
                  echo '<option value="'.$materials->sub_type.'" selected>'.$materials->sub_type.'</option>';
                  }?>
               <option value="">Select Sub type</option>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12">Route</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <div id="sale_purchase" class="btn-group group-required" data-toggle="buttons">
               <p>
                  <?php
                     $sale_purchase = ((!empty($materials) && $materials->sale_purchase != '')?json_decode($materials->sale_purchase):'');
                     ?> Sale:
                  <input type="checkbox" class="flat1" name="sale_purchase[]" id="sale" value="Sale" <?php if(!empty($materials) && $sale_purchase !='' && in_array( "Sale", $sale_purchase)) echo 'checked';?> />
                  <?php
                     // pre($materials->sale_purchase);
                                          $route = ((!empty($materials) && $materials->route != '')?json_decode($materials->route):'');
                                          ?> Purchase:
                  <input type="checkbox" class="flat1" name="route[]" id="purchase" value="Purchase" <?php if(!empty($materials) && $route !='' && in_array( "Purchase", $route)) echo 'checked';?> /> 
				  <!--
				  Manufacture:
                  <input type="checkbox" class="flat1" name="route[]" id="manufacture" value="Manufacture" <?php //if(!empty($materials) && $route !='' && in_array( "Manufacture", $route)) echo 'checked';?> onclick="showJobCardForManufactureMaterial(this);"/>
-->				  
               </p>
            </div>
         </div>
      </div>
      <div class="item form-group jobCardDiv" style="display:none;">
         <label class="col-md-3 col-sm-3 col-xs-12" for="img">Job Card</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible job_card_no" name="job_card" width="100%" tabindex="-1" aria-hidden="true" data-id="job_card" data-key="id" data-fieldname="job_card_no" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND save_status = 1">
               <option value="">Select Option</option>
               <?php if(!empty($materials) && ($materials->job_card !='' && $materials->job_card !=0)){
                  $jobCard = getNameById('job_card',$materials->job_card,'id');
                  echo '<option value="'.$jobCard->id.'" selected>'.$jobCard->job_card_no.'</option>';
                    }
                  ?>
               <?php  //echo '<option value="'.$job_cardId.'" selected>'.$jobcard_data->job_card_no.'</option>'; ?>
            </select>
         </div>
      </div>
      <!--div class="item form-group">
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12" for="non_inventry_material">Inventory Type </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="radio" class="flat" name="non_inventry_material" id="genderM" value="0" <?php //if(!empty($materials) && $materials->non_inventry_material == '0') { echo 'checked';} ?> /> Inventory
               <input type="radio" class="flat" name="non_inventry_material" id="genderF" value="1" <?php //if(!empty($materials) && $materials->non_inventry_material == '1') { echo 'checked';} if(empty($materials)){ echo 'checked';} ?> />Non-Inventory </div>
         </div>
         </div-->
      <div class="item form-group">
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12" for="non_inventry_material">Inventory Type </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="radio" class="tt" name="non_inventry_material" id="genderM" value="0" <?php if(!empty($materials) && $materials->non_inventry_material == '0') { echo 'checked';} if(empty($materials)){ echo 'checked';} ?> /> Inventory
               <input type="radio" class="tt" name="non_inventry_material" id="genderF" value="1" <?php if(!empty($materials) && $materials->non_inventry_material == '1') { echo 'checked';}  ?> />Non-Inventory 
            </div>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="material_name">Product Name <span style="color:red;">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" id="material_name" name="material_name" required="required" class="form-control col-md-7 col-xs-12 has-feedback-left" placeholder="Material name" value="<?php if(!empty($materials)) echo $materials->material_name; ?>"> <span class="form-control-feedback left prefix" aria-hidden="true"><?php if($materials && !empty($materials)){ echo $materials->prefix;} ?></span> 
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="mat_sku">Product SKU</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text"  name="mat_sku" class="form-control col-md-7 col-xs-12" placeholder="Product SKU" value="<?php if(!empty($materials)) echo $materials->mat_sku; ?>"> 
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="sale">Sale price</label>
         <div class="col-md-2 col-sm-2 col-xs-12">
            <input type="number" id="sale_price" name="sales_price" class="form-control col-md-7 col-xs-12 zindex" placeholder="Sale price" value="<?php if($materials && !empty($materials)){ echo $materials->sales_price;} ?>"> 
         </div>
         <div class="item form-group">
            <label class="control-label col-md-2 col-sm-3 col-xs-12" for="cost">Cost price</label>
            <div class="col-md-2 col-sm-2 col-xs-12">
               <input type="text" id="cost_price" name="cost_price" class="form-control col-md-7 col-xs-12" placeholder="Cost price" value="<?php if($materials && !empty($materials)){ echo $materials->cost_price;} ?>"> 
            </div>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="hsn_code">HSN Code</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <select class="select2 form-control" id="HSNSacMasterID" name="hsn_code"  style="font-size:17px;">
               <option value="">Select Option</option>
               <?php
                  //pre($materials->hsn_code);
                   $whereCompany = "(created_by_cid ='" . $this->companyId . "')";
                   $hsnmasterData = $this->inventory_model->get_filter_details('hsn_sac_master', $whereCompany);
                  foreach($hsnmasterData as $hsnval){
                     $totalVal = $hsnval['sgst'] + $hsnval['cgst'];
                     $showVal = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$hsnval['sgst']. '  + ' . $hsnval['cgst']. '  + ' . $totalVal.'  G ';
                  
                     $valt = $hsnval['hsn_sac'].'   '.$showVal;
                      $SelectedVal = '';
                        if($materials->hsn_code == $hsnval['id']){
                           $SelectedVal =  'selected';
                        }
                     echo '<option value="'.$hsnval['id'].'" '.$SelectedVal.' data-id="'.$totalVal.'" >'.$valt.'</option>';
                  }
                  ?>
            </select>
         </div>
         <a href="javascript:void(0)"  data-id="HSNADD_view" class="hsnMAt_mat_view ">Add More</a>
      </div>
      <div class="item form-group select-blog">
         <label class="col-md-3 col-sm-3 col-xs-12" for="opening">Opening Balance</label>
         <div class="col-md-3 col-sm-2 col-xs-12">
            <!-- id="opening_bal" -->
            <input type="text" name="opening_balance" id="opening_bal" class="form-control col-md-7 col-xs-12" placeholder="Opening Balance" value="<?php if(!empty($materials)) echo $materials->opening_balance; ?>" <?php echo $rdonly; ?>  > 
         </div>
         <div class="col-md-3 col-xs-12 col-sm-12">
            <select class="uom selectAjaxOption select2 form-control" id="uomid" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" data-where="(created_by_cid = <?php   echo $this->companyGroupId; ?> OR created_by_cid = 0) AND (active_inactive = 1)"  >
               <option value="">Select Option</option>
               <?php if(!empty($materials->uom)){
                  $material_type_id = getNameById('uom',$materials->uom,'id');
                  #pre($material_type_id);
                  echo '<option value="'.$materials->uom.'"selected >'.$material_type_id->uom_quantity.'</option>';
                  }?>
            </select>
         </div>
      </div>
      <div class="item form-group select-blog">
         <label class="col-md-3 col-sm-3 col-xs-12" for="opening">Alternate UOM Qty</label>
         <div class="col-md-3 col-sm-2 col-xs-12">
            <input type="text" name="alternate_qty" id="alternate_qty" class="form-control col-md-7 col-xs-12" placeholder="Alternate UOM" value="<?php echo !empty($materials->alternate_qty) ? $materials->alternate_qty:''; ?>">
         </div>
         <div class="col-md-3 col-sm-2 col-xs-12">
            <select class="uom selectAjaxOption select2 form-control" id="uomidalternate" name="alternateuom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" data-where="(created_by_cid = <?php   echo $this->companyGroupId; ?> OR created_by_cid = 0) AND (active_inactive = 1)"  >
               <option value="">Select Option</option>
               <?php
                  if(!empty($materials->alternateuom)){
                     $material_type_id = getNameById('uom',$materials->alternateuom,'id');
                     echo '<option value="'.$materials->alternateuom.'"selected >'.$material_type_id->uom_quantity.'</option>';
                  }
                  ?>
            </select>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
      <!--div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="lead">Lead Time</label>
         <div class="col-md-3 col-sm-6 col-xs-12">
            <input type="text" id="lead" name="lead_time" class="form-control col-md-7 col-xs-12" placeholder="Lead Time" value="<?php if($materials && !empty($materials)){ echo $materials->lead_time;} ?>"> </div>
         <div class="col-md-3 col-sm-6 col-xs-12">
            <select class="form-control" name="time_period">
               <option value="">Select</option>
               <option value="hours" <?php if(!empty($materials) && $materials->time_period == 'hours'){ echo 'selected'; }?>>Hours</option>
               <option value="days" <?php if(!empty($materials) && $materials->time_period == 'days'){ echo 'selected'; }?>>Days</option>
               <option value="weeks" <?php if(!empty($materials) && $materials->time_period == 'weeks'){ echo 'selected'; }?>>Weeks</option>
               <option value="month" <?php if(!empty($materials) && $materials->time_period == 'month'){ echo 'selected'; }?>>Months</option>
            </select>
         </div>
         </div>-->
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="tax">Tax</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="tax" value="<?php if(!empty($materials)) echo $materials->tax; ?>" class="form-control tacClass" readonly>
         </div>
      </div>
      <!-- <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="lead">Cess</label>
         <div class="col-md-3 col-sm-6 col-xs-12">
            <select class="form-control" name="cess">
               <option value="">Select Cess </option>
               <?php
            $taxes = taxList();
               foreach($taxes as $tax){
                  $taxSelected = '';
                     if(!empty($materials) && $materials->cess == $tax){
                     $taxSelected =  'selected';
                     }
               echo '<option value="'.$tax.'" '.$taxSelected.'>'.$tax.' %</option>';
               }
            ?>
            </select>
         </div>
         <div class="col-md-3 col-sm-6 col-xs-12">
            <select class="form-control" name="valuation_type">
               <option value="">Select Valuation</option>
               <option value="based_on_qty" <?php if(!empty($materials) && $materials->valuation_type == 'based_on_qty'){ echo 'selected'; }?>>Based on Quantity</option>
               <option value="based_on_value" <?php if(!empty($materials) && $materials->valuation_type == 'based_on_value'){ echo 'selected'; }?>>Based on Value</option>
               <option value="based_on_qty_value" <?php if(!empty($materials) && $materials->valuation_type == 'based_on_val_qty'){ echo 'selected'; }?>>Based on Value & Qty.</option>
            </select>
         </div>
         </div>-->
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="specification">Specification</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification">
            <?php if(!empty($materials)) echo $materials->specification; ?>
            </textarea>
         </div>
      </div>
      <!--<div class="form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="tags">Material Tags</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker"  name="tags_data[]" data-id="tag_details" data-key="id" data-fieldname="tag_name" width="100%" tabindex="-1"  data-where="created_by_cid=<?php echo $this->companyGroupId;?> AND active_inactive = 1">
         <option>Select Option</option>
         
         </select>
         
         </div>
         </div>-->
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="min_order">Minimum Order</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" id="min.order" name="min_order" class="form-control col-md-7 col-xs-12" placeholder="Minimum order" value="<?php if(!empty($materials))  echo $materials->min_order ;?>" min="1"> 
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="min_inventory">Reorder Level</label>
         <div class="col-md-3 col-sm-2 col-xs-12">
            <input type="text" id="min.inventory" name="min_inventory" class="form-control col-md-7 col-xs-12" placeholder="Minimum inventory" value="<?php if(!empty($materials)) echo $materials->min_inventory; ?>"> 
         </div>
      </div>
      <!-- quality check  start -->
      <?php //if(getSingleAndWhere('quality_check_on_off','company_detail',['id' => $this->companyGroupId])){ ?>
      <div class="item form-group">
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12" for="non_inventry_material">Quality Check  </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="radio" class=" quality_check" name="quality_check" value="1" <?php if(!empty($materials) && $materials->quality_check) { echo 'checked';} ?> /> Required
               <input type="radio" class="quality_check" name="quality_check" value="0" <?php if(!empty($materials) && !$materials->quality_check) { echo 'checked';} if(empty($materials)){ echo 'checked';} ?> />Not Required 
            </div>
            <div class="item form-group" id="qualityCheckLink" style="margin-top:50px; <?= (!empty($materials) && $materials->quality_check == 0)?'display:none':''; ?>" >
               <label style="visibility: hidden;" class="col-md-3 col-sm-3 col-xs-12" for="non_inventry_material">
               Quality Check </label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                  <button type="button" class="btn btn-success createQualityFormat" matId="<?= $materials->id ?>" formatType="createFromat">Create Format</button>
                  <button type="button" class="btn btn-success createQualityFormat" matId="<?= $materials->id ?>" formatType="linkFromat">Link of format</button>
                  <!--input type="radio" class="flat" name="quality_check_type" id="quality_check_type" value="1" <?php //if(!empty($materials) && $materials->quality_check_type == 1 ){ echo 'checked'; }elseif( empty($materials) ){ echo 'checked'; } ?>  /> Create Format
                     <input type="radio" class="flat" name="quality_check_type" id="quality_check_ntype" value="2" <?php //if(!empty($materials) && $materials->quality_check_type == 2 ) { echo 'checked';} ?> /-->  
               </div>
            </div>
         </div>
      </div>
      <?php //} ?>
      <!-- quality check  end -->
      <!-- start-Supplier Eliase  24-02-2022 -->    
      <div class="item form-group">
         <?php 
            if(!empty($materials)){
               $supplieDetails = json_decode($materials->MatAliasName);
            // pre($materials);
               if(!empty($supplieDetails)){
               $supplierId = 0;
               $aliasName = '';
               foreach($supplieDetails as $supplierDetailId){
                  $aliasName = $supplierDetailId->alias;
                  $supplierId = getNameById('supplier',$supplierDetailId->customer_id,'id');
            ?>
         <div id="mainSupplierAlias" class="addMoreFunCss mainSupplierAlias">
            <div class="SupplierNameAlias row" id="SupplierNameAlias" style="margin-top:10px;">
               <label class="col-md-3 col-sm-3 col-xs-12" for="lead">Supplier Name </label>
               <div class="col-md-3 col-sm-6 col-xs-12">
                  <select class="customerSelect form-control col-md-2 col-xs-12 selectAjaxOption select2 requrid_class add_more_Supplier select2-width-imp"   name="detors_name[]" id="supplier_name" data-id="supplier" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status=1" style="width: 100% !important;" onchange="getSupplierAddress(event,this)">
                     <option value="">Select Option</option>
                     <option value="<?php echo $supplierId->id; ?>"selected ><?php echo $supplierId->name; ?></option>
                  </select>
               </div>
               <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="text" id="aliasName" name="aliasName[]" class="form-control col-md-7 col-xs-12" placeholder="Alias" value="<?php echo $aliasName; ?>">
               </div>
               <div class="col-md-3 col-sm-6 col-xs-12">
               </div>
               <button class="btn  btn-danger remove_field" style="display:none;" type="button"><i class="fa fa-minus"></i></button>
            </div>
            <div class="my-btn">
               <button style="float:right;margin:5px;" class="btn edit-end-btn addMoreSupplierAlias" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
               <input type="hidden" id="countCustRow" value="1">
            </div>
         </div>
         <?php
            }
            }
            }
            ?>
      </div>
      <!-- End-Supplier Eliase  -->
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="min_order">Adding The Dimension</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <label>
            <input <?php if(!empty($materials->dimension_length) && !empty($materials->dimension_width) && !empty($materials->dimension_height) && !empty($materials->total_cbf)){ echo "checked=checked"; } ?> class="ädding_dimension" type="checkbox" name="">Yes</label>
            <!--input type="text" name="ch_for[]" value="" placeholder="L*W*H"  class="form-control set_dimension hide"-->
            <div class="set_dimension hide">
               <div class="dimension_lay">
                  <div class="col-md-3"><input type="text" name="dimension_length" value="<?php if(!empty($materials->dimension_length) && !empty($materials->dimension_width) && !empty($materials->dimension_height) && !empty($materials->total_cbf)){ echo $materials->dimension_length; } ?>" placeholder="L"  class="form-control"></div>
                  <div class="col-md-3"><input type="text" name="dimension_width" value="<?php if(!empty($materials->dimension_length) && !empty($materials->dimension_width) && !empty($materials->dimension_height) && !empty($materials->total_cbf)){ echo $materials->dimension_width; } ?>" placeholder="W"  class="form-control"></div>
                  <div class="col-md-3"><input type="text" name="dimension_height" value="<?php if(!empty($materials->dimension_length) && !empty($materials->dimension_width) && !empty($materials->dimension_height) && !empty($materials->total_cbf)){ echo $materials->dimension_height; } ?>" placeholder="H"  class="form-control"></div>
               </div>
               <div class="col-md-3"><input type="text" name="total_cbf" value="<?php if(!empty($materials->dimension_length) && !empty($materials->dimension_width) && !empty($materials->dimension_height) && !empty($materials->total_cbf)){ echo $materials->total_cbf; } ?>" placeholder="CBF"  class="form-control cbf_val"></div>
            </div>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="min_inventory">Standard Packing</label>
         <div class="col-md-3 col-sm-2 col-xs-12">
            <input type="text" id="standard_packing" name="standard_packing" class="form-control col-md-7 col-xs-12" placeholder="Standard Packing" value="<?php if(!empty($materials)) echo $materials->standard_packing; ?>"> 
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="min_inventory">Item Code</label>
         <div class="col-md-3 col-sm-2 col-xs-12">
            <input type="text" id="item_code" name="item_code" class="form-control col-md-7 col-xs-12" placeholder="Item Code" value="<?php if(!empty($materials)) echo $materials->item_code; ?>"> 
         </div>
      </div>
   </div>
   <hr class="packingSection" style="display: none;">
   <div class="bottom-bdr packingSection" style="display: none;"></div>
   <h3 class="Material-head packingSection" style="display: none;">
      Packaging
      <hr>
   </h3>
   <div style="display: none;" class="packingSection col-md-8 col-sm-6 col-xs-12 form-group middle-box2" style="margin: 0px auto;display: table;float: unset;">
      <div class="well   pk edit-row1" style="overflow:auto; border-top: 1px solid #c1c1c1;" id="chkIndex_1">
         <?php
            $packing_data = !empty($materials->packing_data) ? json_decode($materials->packing_data):'';
            if(!empty($packing_data)){
            $j = 1;
            foreach ($packing_data as $key => $packing_value) {
            $material = getNameById('material',$packing_value->packing_mat,'id');
            ?>
         <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?php if($j == 1){ ?>
            <label>Name</label>
            <?php } ?>
            <select class="location form-control selectAjaxOption select2 location select2-hidden-accessible" name="packing_mat[]" data-id="material" data-key="id" data-fieldname="material_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getcbf(event,this);" data-where="dimension_length !='' && dimension_width !='' && dimension_height !='' && total_cbf != ''">
               <option>Select Option</option>
               <option selected value="<?php echo $material->id; ?>"><?php echo $material->material_name; ?></option>
            </select>
         </div>
         <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <?php if($j == 1){ ?>
            <label>Quantity</label>
            <?php } ?>
            <input type="text" id="Quantity" class="form-control col-md-7 col-xs-12" placeholder="Quantity" value="<?php echo $packing_value->packing_qty; ?>" name="packing_qty[]">
         </div>
         <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <?php if($j == 1){ ?>
            <label>Weight</label>
            <?php } ?>
            <input type="text" id="rack" class="form-control col-md-7 col-xs-12" placeholder="Weight" value="<?php echo $packing_value->packing_weight; ?>" name="packing_weight[]"> 
         </div>
         <div class="cbf_set col-md-3 col-sm-6 col-xs-12 form-group" style="border-right:1px solid #c1c1c1 !important">
            <?php if($j == 1){ ?>
            <label>CBF</label>
            <?php } ?>
            <input type="text" class="packing_cbf form-control col-md-7 col-xs-12" placeholder="CBF" value="<?php echo $packing_value->packing_cbf; ?>" readonly  name="packing_cbf[]"> 
         </div>
         <?php $j++; } ?>
         <?php } else { ?>
         <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <label>Name</label>
            <select class="location form-control selectAjaxOption select2 location select2-hidden-accessible" name="packing_mat[]" data-id="material" data-key="id" data-fieldname="material_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getcbf(event,this);" data-where="dimension_length !='' && dimension_width !='' && dimension_height !='' && total_cbf != ''">
               <option>Select Option</option>
            </select>
         </div>
         <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <label>Quantity</label>
            <input type="text" id="Quantity" name="packing_qty[]" class="form-control col-md-7 col-xs-12" placeholder="Quantity" value="">
         </div>
         <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <label>Weight</label>
            <input type="text" id="rack" name="packing_weight[]" class="form-control col-md-7 col-xs-12" placeholder="Weight" value=""> 
         </div>
         <div class="cbf_set col-md-3 col-sm-6 col-xs-12 form-group" style="border-right:1px solid #c1c1c1 !important">
            <label>CBF</label>
            <input type="text" id="rack" name="packing_cbf[]" class="packing_cbf form-control col-md-7 col-xs-12" placeholder="CBF" value=""> 
         </div>
         <button class="btn btn-danger delete_btn" type="button"><i class="fa fa-minus"></i></button>
         <?php } ?>
         <div id="multiple_packing"></div>
         <div class="btn-row"><button class="btn  plus-btn edit-end-btn" onclick="addPRow(event,this)" type="button">Add</button></div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr" style="display: <?php echo $display; ?>"></div>
   <div class="col-md-12 col-sm-6 col-xs-12 form-group add_multiple_location middle-box2" style="display: <?php echo $display; ?>">
      <?php if(empty($locations)){ ?>
      <div class="well " style="overflow:auto; border-top: 1px solid #c1c1c1 ; border-right: 1px solid #c1c1c1 ;" id="chkIndex_1">
         <input type="hidden" name="id_loc[]" value="" class="empty" >
         <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <label> Address</label>
            <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" onchange="getArea(event,this);getlot(event,this)" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
               <option value="">Select Option</option>
            </select>
         </div>
         <div class="col-md-6 col-sm-6 col-xs-12 form-group">
            <label style=" border-right: 1px solid #c1c1c1 !important;">Quantity</label>
            <input style=" border-right: 1px solid #c1c1c1 !important;" type="text" id="qty" name="quantityn[]" class="form-control col-md-7 col-xs-12" placeholder="Quantity" onkeyup="getQtyValue(event,this)">
         </div>
         <div class="col-md-4 col-sm-6 col-xs-12 form-group" style="display: none;">
            <label style=" border-right: 1px solid #c1c1c1 !important;">Uom</label>
            <select class="uom selectAjaxOption select2 form-control" name="Qtyuom[]" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uomid" data-where="created_by_cid = <?php  echo $this->companyGroupId; ?> OR created_by_cid = 0 AND active_inactive = 1" required="required">
               <option value="">Select Option</option>
            </select>
         </div>
         <!--div class="btn-row"><button class="btn plus-btn edit-end-btn add_More_btn" type="button">Add</div-->
      </div>
      <?php } else{
         $i =  1;
         foreach($locations as $source_Data){
         
            $locationAddress = getNameById('company_address',$source_Data['location_id'],'id');
         
         
         ?>
      <div class="well <?php if($i==1){ echo 'edit-row1';}else{ echo 'mobile-view scend-tr';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1;" id="chkIndex_<?php echo $i; ?>">
         <input type="hidden" class="idLOC" name="id_loc[]" value="<?php echo $source_Data['id']; ?>">
         <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <label> Address</label>
            <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" onchange="getArea(event,this);getlot(event,this)" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
               <option>Select Option</option>
               <?php
                  if(!empty($locationAddress)){
                     echo '<option value="'.$locationAddress->id.'" selected>'.$locationAddress->location.'</option>';
                  }
                  ?>
            </select>
         </div>
         <div class="col-md-6 col-sm-6 col-xs-12 form-group">
            <label style=" border-right: 1px solid #c1c1c1 !important;">Quantity</label>
            <input style=" border-right: 1px solid #c1c1c1 !important;" type="text" id="qty" name="quantityn[]" class="form-control col-md-7 col-xs-12" placeholder="Quantity" value="<?php   echo abs($source_Data['quantity']);   ?>" onkeyup="getQtyValue(event,this)"> 
         </div>
         <div class="col-md-3 col-sm-6 col-xs-12 form-group" style="display: none;">
            <label style=" border-right: 1px solid #c1c1c1 !important;">Uom</label>
            <select class="uom selectAjaxOption select2 form-control" name="Qtyuom[]" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php    echo $this->companyGroupId; ?> OR created_by_cid = 0 AND active_inactive = 1">
               <option value="">Select Option</option>
               <?php if(!empty($materials)){
                  $material_type_id = getNameById('uom',$source_Data['Qtyuom'],'id');
                  echo '<option value="'.$materials->uom.'"selected >'.$material_type_id->uom_quantity.'</option>';
                  }?>
            </select>
         </div>
         <?php if($i==1){
            echo '<div class="btn-row"><button class="btn  plus-btn edit-end-btn add_More_btn" type="button">Add</button></div>';
            }else{
            //echo '<button style="margin-right: 0px;" class="btn btn-danger delete_btn" type="button"> <i class="fa fa-minus"></i></button>';
            echo '<button style="margin-right: 0px;" class="btn btn-danger" type="button" id="'.$source_Data['id'].'" onclick="delete_location(this.id)"> <i class="fa fa-minus"></i></button>';
            }
            ?>
      </div>
      <?php $i++;
         }}
         ?>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="img">Featured Image </label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="hidden" class="form-control col-md-7 col-xs-12 hiddenImage" name="featured_image" id="hiddenImage" value="<?php echo isset($materials->featured_image)?$materials->featured_image: " ";?>">
            <button type="button" class="btn" name="featured_image" id="image">Upload featured_image</button>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="img"></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <div id="uploaded_image_Add"></div>
         </div>
      </div>
      <?php if(!empty($materials)){
         ?>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="proof"></label>
         <div class="col-md-6">
            <?php    if(!empty($materials->featured_image)){
               echo '
               <div class="col-md-55">
                  <div class="image view view-first">
                     <div id="uploaded_image"><img style="width: 100%; display: block;" src="'.base_url().'assets/modules/inventory/uploads/'.$materials->featured_image.'" alt="image" class="undo" id="uploaded_image"/></div>
                  </div>
               </div>'; }else{
                  echo ' <div class="col-md-55">
                  <div class="image view view-first">
                     <div id="uploaded_image"><img style="width: 100%; display: block;" src="'.base_url().'assets/modules/inventory/uploads/product.png" alt="image" class="undo" id="uploaded_image"/></div>
                  </div>
               </div>';
               }
               ?> 
         </div>
      </div>
      <?php } ?>
   </div>
   <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="proof">Material Image  </label>
         <div class="col-md-6 col-sm-6 col-xs-12 ">
            <input type="file" class="form-control col-md-7 col-xs-12" name="materialImage[]"> 
         </div>
         <button class="btn btn-warning add_images" type="button"><i class="fa fa-plus"></i></button>
      </div>
      <div class="item form-group image_box"> </div>
      <?php 
	  // 
		
		// die();
	  if(!empty($imageUpload)){
		 //pre($imageUpload);die();
         ?>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="proof"></label>
         <div class="col-md-8">
            <?php
               foreach($imageUpload as $image_upload){
				  
                  echo '<div class="col-md-4">';
               
                        $ext = pathinfo($image_upload['file_name'], PATHINFO_EXTENSION);
                        if($ext == 'ods' || $ext ==  'doc' || $ext ==  'docx' || $ext ==  'xls'){
                        //echo'<div class="image view view-first"><a download="'.$image_upload['file_name'].'" href="'.base_url().'assets/modules/inventory/uploads/'.$image_upload['file_name'].'"><img style="width: 100%; display: block;" src="'.base_url().'assets/images/file-icon.png" alt="image" class="undo" height="50px" /><i class="fa fa-download"></i>
                           echo'<div class="image view view-first"><a download="'.$image_upload['file_name'].'" href="'.base_url().'assets/modules/inventory/uploads/'.$image_upload['file_name'].'"><img style="width: 100%; display: block;" src="'.base_url().'assets/modules/inventory/uploads/'.$image_upload['file_name'].'" alt="image" class="undo" height="50px" /><i class="fa fa-download"></i>
                           <div class="mask">
                              <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'inventory/delete_images/'.$image_upload['id'].'/'.$materials->id.'">
                                 <i class="fa fa-trash"></i>
                              </a>
                           </div></div>';
                        }else if($ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg' || $ext == 'png' || $ext == 'ico' || $ext == 'jfif'){
                           //echo'<div class="image view view-first"><a download="'.$image_upload['file_name'].'" href="'.base_url().'assets/modules/inventory/uploads/'.$image_upload['file_name'].'"><img style="width: 100%; display: block;" src="'.base_url().'assets/images/uplod-icon.png" alt="image" class="undo" height="50px" /><i class="fa fa-download"></i>
                           echo'<div class="image view view-first"><a download="'.$image_upload['file_name'].'" href="'.base_url().'assets/modules/inventory/uploads/'.$image_upload['file_name'].'"><img style="width: 100%; display: block;" src="'.base_url().'assets/modules/inventory/uploads/'.$image_upload['file_name'].'" alt="image" class="undo" height="50px" /><i class="fa fa-download"></i>
                           <div class="mask">
                              <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'inventory/delete_images/'.$image_upload['id'].'/'.$materials->id.'">
                                 <i class="fa fa-trash"></i>
                              </a>
                           </div></div>';
               
               
                        }
                        echo'
                                                  </div>';
               }
               ?> 
         </div>
      </div>
      <?php } ?>
   </div>
   <hr>
   <div class="form-group">
      <div class="col-md-12 col-xs-12">
         <center>
            <input type="reset" class="btn btn-default" value="Reset">
            <input type="submit" class="btn btn-warning signUpBtn add_mat_btn_submit" value="submit">
            <button type="button" class="btn btn-default close_modal2" onclick="location.href='<?php echo base_url();?>inventory/materials'">Close</button>
         </center>
      </div>
   </div>
</form>
<?php
   }else{
      // pre($materials);
      $last_id = getLastTableId('material');
      $rId = $last_id + 1;
      $matCode = 'MAT_'.rand(1, 1000000).'_'.$rId;
   
      $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   
      ?>
<div class="" role="tabpanel" data-example-id="togglable-tabs">
   <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
      <li role="presentation" class="active"><a href="#Product_detail" id="pd_dtl" role="tab" data-toggle="tab" aria-expanded="true" onClick="actve_mat_form()">Add Product Detail</a> </li>
      <!--li role="presentation" class=""><a href="#purch_ordr" role="tab" id="pord_tab" data-toggle="tab" aria-expanded="false" onClick="noninvtry_mat_form()">Add Purchase Order</a> </li>
         <li role="presentation" class=""><a href="#sale_ordr" role="tab" id="sale_ordrsssss" data-toggle="tab" aria-expanded="false" onClick="inactve_mat_form()">Add Sale Order</a> </li-->
      <!--  <li role="presentation" class=""><a href="#transctions" role="tab" id="" data-toggle="tab" aria-expanded="false" onClick="inactve_mat_form()">Transactions</a>
         <li role="presentation" class=""><a href="#attachmnt" role="tab" id="" data-toggle="tab" aria-expanded="false" onClick="inactve_mat_form()">Attachments</a>
         </li> -->
   </ul>
   <div id="myTabContent" class="tab-content">
      <div role="tabpanel" class="tab-pane fade active in" id="Product_detail" aria-labelledby="pd_dtl">
         <form method="post" class="form-horizontal sadfsdafasf" action="<?php echo base_url(); ?>inventory/saveMaterial" enctype="multipart/form-data" id="materialForm" novalidate="novalidate">
            <input type="hidden" id="materialId" name="id" value="<?php if(!empty($materials)) echo $materials->id; ?>">
            <input type="hidden" id="mat_id_funcs" value="<?php if(!empty($rId)) echo $rId; ?>">
            <input type="hidden" id="id" value="<?php if(!empty($rId)) echo $rId; ?>">
            <input type="hidden" name="save_status" value="1" class="save_status1">
            <input type="hidden" name="prefix" class="matPrefix" value="<?php if($materials && !empty($materials)){ echo $materials->prefix;} ?>">
            <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
            <input type="hidden" name="inventory_listing_mat_side" value="" id="inventory_listing_mat_side">
            <?php
               if(empty($materials)){
               
               ?>
            <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>">
            <?php }else{ ?>
            <input type="hidden" name="created_by" value="<?php if($materials && !empty($materials)){ echo $materials->created_by;} ?>">
            <?php } ?>
            <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
               <!-- <div class="item form-group">
                  <div class="item form-group">
                     <label class="col-md-3 col-sm-3 col-xs-12" for="non_inventry_material">Material Conversion</label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="radio" class="tt" name="non_inventry_material" id="genderM" value=""/> Yes
                        <input type="radio" class="tt" name="non_inventry_material" id="genderF" value=""/> No</div>
                  </div>
                  </div>
                  <div style="display: none;" class="box1">
                  <div class="item form-group">
                  <div class="item form-group">
                     <label class="col-md-3 col-sm-3 col-xs-12" for="non_inventry_material">Parent SKU</label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="parent_mat_sku" class="form-control col-md-7 col-xs-12" placeholder="Product SKU" value="">
                     </div>
                  </div>
                  </div>
                  </div> -->
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="code">Material Code</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <input id="material_code" class="form-control col-md-7 col-xs-12" name="material_code" placeholder="both name(s) e.g Jon Doe" type="text" value="<?php if(!empty($materials)) echo $materials->material_code; else echo $matCode; ?>" readonly> 
                  </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="materail_type">Material Type<span class="required" style="color:red;">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible materialTypeId" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" id="material_typewsws" onchange="ChangePrefix_and_subType();">
                        <option value="">Select Option</option>
                        <?php if(!empty($materials)){
                           $material_type_id = getNameById('material_type',$materials->material_type_id,'id');
                           echo '<option value="'.$materials->material_type_id.'" material_type_prefix="'.$material_type_id->prefix.'" selected >'.$material_type_id->name.'</option>';
                           }?>
                     </select>
                  </div>
               </div>
               <span id="selectedMaterialSubType" style="display:none;"><?php if(!empty($materials)){ echo $materials->sub_type; } ?></span>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="materail_type">Material Sub Type</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <select class="subtype form-control" name="sub_type" id="subtype1">
                        <?php if(!empty($materials)){
                           echo '<option value="'.$materials->sub_type.'" selected>'.$materials->sub_type.'</option>';
                           }?>
                        <option value="">Select Sub type</option>
                     </select>
                  </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12">Route</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <div id="sale_purchase" class="btn-group group-required" data-toggle="buttons">
                        <p>
                           <?php
                              $sale_purchase = ((!empty($materials) && $materials->sale_purchase != '')?json_decode($materials->sale_purchase):'');
                              ?> Sale:
                           <input type="checkbox" class="flat1" name="sale_purchase[]" id="sale" value="Sale" <?php if(!empty($materials) && $sale_purchase !='' && in_array( "Sale", $sale_purchase)) echo 'checked';?> checked />
                           <!--Purchase:
                              <input type="checkbox" class="flat" name="sale_purchase[]" id="purchase" value="Purchase" <?php if(!empty($materials)  &&  $sale_purchase != ''  && in_array("Purchase", $sale_purchase)) echo 'checked';?> />-->
                           <?php
                              $route = ((!empty($materials) && $materials->route != '')?json_decode($materials->route):'');
                              ?> Purchase:
                           <input type="checkbox" class="flat1" name="route[]" id="purchase" value="Purchase" <?php if(!empty($materials) && $route !='' && in_array( "Purchase", $route)) echo 'checked';?> checked />
                           <?php /* 
                              Manufacture:
                                                               <input type="checkbox" class="flat1" name="route[]" id="manufacture" value="Manufacture" <?php if(!empty($materials) && $route !='' && in_array( "Manufacture", $route)) echo 'checked';?> onclick="showJobCardForManufactureMaterial(this);"/> 
                        </p>
                        */?>
                     </div>
                  </div>
               </div>
               <div class="item form-group jobCardDiv" style="display:none;">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="img">Job Card</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible job_card_no" name="job_card" width="100%" tabindex="-1" aria-hidden="true" data-id="job_card" data-key="id" data-fieldname="job_card_no" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND save_status = 1">
                        <option value="">Select Option</option>
                        <?php if(!empty($materials) && ($materials->job_card !='' && $materials->job_card !=0)){
                           $jobCard = getNameById('job_card',$materials->job_card,'id');
                           echo '<option value="'.$jobCard->id.'" selected>'.$jobCard->job_card_no.'</option>';
                             }
                           ?>
                        <?php  //echo '<option value="'.$job_cardId.'" selected>'.$jobcard_data->job_card_no.'</option>'; ?>
                     </select>
                  </div>
               </div>
               <div class="item form-group">
                  <!--label class="col-md-3 col-sm-3 col-xs-12">Non-Inventory</label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <div id="non-inventory" class="btn-group group-required" data-toggle="buttons">
                           <p>
                           Non-Inventory:
                              <input type="checkbox" class="flat" name="non_inventry_material" id="non_inventory" value="1" <?php //if(!empty($materials) && $materials->non_inventry_material == 1) echo 'checked';?> />
                           </p>
                     
                        </div>
                     </div-->
                  <div class="item form-group">
                     <label class="col-md-3 col-sm-3 col-xs-12" for="non_inventry_material">Inventory Type </label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="radio" class="flat" name="non_inventry_material" id="genderM" value="0" <?php if(!empty($materials) && $materials->non_inventry_material == '0') { echo 'checked';}  if(empty($materials)){ echo 'checked';} ?> /> Inventory
                        <input type="radio" class="flat" name="non_inventry_material" id="genderF" value="1" <?php if(!empty($materials) && $materials->non_inventry_material == '1') { echo 'checked';} ?> />Non-Inventory 
                     </div>
                  </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="material_name">Product Name <span style="color:red;">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="text" id="material_name" name="material_name" required="required" class="form-control col-md-7 col-xs-12 has-feedback-left" placeholder="Material name" value="<?php if(!empty($materials)) echo $materials->material_name; ?>"> <span class="form-control-feedback left prefix" aria-hidden="true"><?php if($materials && !empty($materials)){ echo $materials->prefix;} ?></span> 
                  </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="mat_sku">Product SKU</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="text"  name="mat_sku" class="form-control col-md-7 col-xs-12" placeholder="Product SKU" value="<?php if(!empty($materials)) echo $materials->mat_sku; ?>"> 
                  </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="sale">Sale price</label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                     <input type="number" id="sale_price" name="sales_price" class="form-control col-md-7 col-xs-12 zindex" placeholder="Sale price" value="<?php if($materials && !empty($materials)){ echo $materials->sales_price;} ?>"> 
                  </div>
                  <div class="item form-group">
                     <label class="control-label col-md-2 col-sm-3 col-xs-12" for="cost">Cost price</label>
                     <div class="col-md-2 col-sm-2 col-xs-12">
                        <input type="text" id="cost_price" name="cost_price" class="form-control col-md-7 col-xs-12" placeholder="Cost price" value="<?php if($materials && !empty($materials)){ echo $materials->cost_price;} ?>"> 
                     </div>
                  </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="hsn_code">HSN Code</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <!--input type="text" id="hsn_code" name="hsn_code" class="form-control col-md-7 col-xs-12 hsn" placeholder="Valid Hsn_code" value="<?php //if(!empty($materials)) echo $materials->hsn_code; ?>"-->
                     <select class="select2 form-control" id="HSNSacMasterID" name="hsn_code" style="font-size:17px;">
                        <option value="">Select Option</option>
                        <?php
                           $whereCompany = "(created_by_cid ='" . $this->companyId . "')";
                           $hsnmasterData = $this->inventory_model->get_filter_details('hsn_sac_master', $whereCompany);
                           foreach($hsnmasterData as $hsnval){
                             $totalVal = $hsnval['sgst'] + $hsnval['cgst'];
                             $showVal = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$hsnval['sgst']. '  + ' . $hsnval['cgst']. '  + ' . $totalVal.'  G ';
                           
                             $valt = $hsnval['hsn_sac'].'   '.$showVal;
                             echo '<option value="'.$hsnval['id'].'" data-id="'.$totalVal.'">'.$valt.'</option>';
                           }
                           
                           ?>
                     </select>
                  </div>
                  <a href="javascript:void(0)"  data-id="HSNADD_view" class="hsnMAt_mat_view btn  edit-end-btn"><i class="fa fa-plus" aria-hidden="true"></i></a>
               </div>
               <?php
                  $get_discount_details = getNameById('company_detail',$this->companyGroupId,'id');
                  if($get_discount_details->invnt_loc_on_off == 1){
                     $display = "block";
                     $rdonly = "readonly"; ?>
               <input type="hidden" name="inventory_loc" value="1">
               <?php      }
                  else{
                     $display = "none";
                     $rdonly = ""; ?>
               <input type="hidden" name="inventory_loc" value="0">
               <?php
                  }
                  ?>
               <div class="item form-group select-blog">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="opening">Opening Balance</label>
                  <div class="col-md-3 col-sm-2 col-xs-12">
                     <!-- id="opening_bal" -->
                     <input type="text" name="opening_balance" id="opening_bal" class="form-control col-md-7 col-xs-12" placeholder="Opening Balance" value="<?php if(!empty($materials)) echo $materials->opening_balance; ?>" <?php echo $rdonly; ?>   > 
                  </div>
                  <div class="col-md-3 col-sm-2 col-xs-12">
                     <select class="uom selectAjaxOption select2 form-control" id="uomid" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" data-where="(created_by_cid = <?php   echo $this->companyGroupId; ?> OR created_by_cid = 0) AND (active_inactive = 1)" >
                        <option value="">Select Option</option>
                        <?php if(!empty($materials->uom)){
                           $material_type_id = getNameById('uom',$materials->uom,'id');
                           #pre($material_type_id);
                           echo '<option value="'.$materials->uom.'"selected >'.$material_type_id->uom_quantity.'</option>';
                           }?>
                     </select>
                  </div>
               </div>
               <div class="item form-group select-blog">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="opening">Alternate UOM Qty</label>
                  <div class="col-md-3 col-sm-2 col-xs-12">
                     <input type="text" name="alternate_qty" id="alternate_qty" class="form-control col-md-7 col-xs-12" placeholder="Alternate UOM" value="<?php if(!empty($materials)) echo $materials->alternate_qty; ?>" >
                  </div>
                  <div class="col-md-3 col-sm-2 col-xs-12">
                     <select class="uom selectAjaxOption select2 form-control" id="uomidalternate" name="alternateuom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" data-where="(created_by_cid = <?php   echo $this->companyGroupId; ?> OR created_by_cid = 0) AND (active_inactive = 1)" >
                        <option value="">Select Option</option>
                        <?php
                           if(!empty($materials->alternateuom)){
                              $material_type_id = getNameById('uom',$materials->alternateuom,'id');
                              echo '<option value="'.$materials->alternateuom.'"selected >'.$material_type_id->uom_quantity.'</option>';
                           }
                           ?>
                     </select>
                  </div>
               </div>
            </div>
            <!--div class="item form-group">
               <label class="col-md-3 col-sm-3 col-xs-12" for="opening">Closing Balance<span style="color:red;">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="text" id="closing_balance" name="closing_balance"  class="form-control col-md-7 col-xs-12 hsn" placeholder="Closing balance"  value="<?php //if(!empty($materials)) echo $materials->closing_balance; ?>" required="required">
                  </div>
               </div-->
            <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
               <!--<div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="lead">Lead Time</label>
                  <div class="col-md-3 col-sm-6 col-xs-12">
                     <input type="text" id="lead" name="lead_time" class="form-control col-md-7 col-xs-12" placeholder="Lead Time" value="</?php if($materials && !empty($materials)){ echo $materials->lead_time;} ?>"> </div>
                  <div class="col-md-3 col-sm-6 col-xs-12">
                     <select class="form-control" name="time_period" id="tmpp">
                        <option value="">Select</option>
                        <option value="hours" </?php if(!empty($materials) && $materials->time_period == 'hours'){ echo 'selected'; }?>>Hours</option>
                        <option value="days" </?php if(!empty($materials) && $materials->time_period == 'days'){ echo 'selected'; }?>>Days</option>
                        <option value="weeks" </?php if(!empty($materials) && $materials->time_period == 'weeks'){ echo 'selected'; }?>>Weeks</option>
                        <option value="month" </?php if(!empty($materials) && $materials->time_period == 'month'){ echo 'selected'; }?>>Months</option>
                     </select>
                  </div>
                  </div>-->
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="tax">Tax</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="text" value="" class="form-control tacClass" name="tax" readonly >
                  </div>
               </div>
               <!--<div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="lead">Cess</label>
                  <div class="col-md-3 col-sm-6 col-xs-12">
                     <select class="form-control" name="cess">
                        <option value="">Select Cess </option>
                        <?php
                     $taxes = taxList();
                        foreach($taxes as $tax){
                           $taxSelected = '';
                              if(!empty($materials) && $materials->cess == $tax){
                              $taxSelected =  'selected';
                              }
                        echo '<option value="'.$tax.'" '.$taxSelected.'>'.$tax.' %</option>';
                        }
                     ?>
                     </select>
                  </div>
                  <div class="col-md-3 col-sm-6 col-xs-12">
                     <select class="form-control" name="valuation_type">
                        <option value="">Select Valuation</option>
                        <option value="based_on_qty" <?php if(!empty($materials) && $materials->valuation_type == 'based_on_qty'){ echo 'selected'; }?>>Based on Quantity</option>
                        <option value="based_on_value" <?php if(!empty($materials) && $materials->valuation_type == 'based_on_value'){ echo 'selected'; }?>>Based on Value</option>
                        <option value="based_on_qty_value" <?php if(!empty($materials) && $materials->valuation_type == 'based_on_val_qty'){ echo 'selected'; }?>>Based on Value & Qty.</option>
                     </select>
                  </div>
                  </div>-->
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="specification">Specification</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification">
                     <?php if(!empty($materials)) echo $materials->specification; ?>
                     </textarea>
                  </div>
               </div>
               <!--<div class="form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="tags">Material Tags</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker"  name="tags_data[]" data-id="tag_details" data-key="id" data-fieldname="tag_name" width="100%" tabindex="-1"  data-where="created_by_cid=</?php echo $this->companyGroupId;?> AND active_inactive = 1">
                  <option>Select Option</option>
                  
                  </select>
                     <!-- <select class="tags-field form-control col-md-7 col-xs-12" name="tags[]" data-tags="true" data-placeholder="Type-Press-Enter" multiple="multiple">
                        </?php
                  // //if(!empty($materials)){
                  //    if(!empty($tags_data)){
                  //          //pre($tags_data);
                  //       foreach($tags_data as $tag){
                  //          echo '<option value="'.$tag['TagId'].'" selected>'.$tag['tagname'].'</option>';
                  //       }
                  //    }
                  //}
                  ?>
                     </select> -->
               <!--</div>
                  </div>-->
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="min_order">Minimum Order</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="text" id="min.order" name="min_order" class="form-control col-md-7 col-xs-12" placeholder="Minimum order" value="<?php if(!empty($materials))  echo $materials->min_order ;?>" min="1"> 
                  </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="min_inventory">Reorder Level</label>
                  <div class="col-md-3 col-sm-2 col-xs-12">
                     <input type="text" id="min.inventory" name="min_inventory" class="form-control col-md-7 col-xs-12" placeholder="Minimum inventory" value="<?php if(!empty($materials)) echo $materials->min_inventory; ?>"> 
                  </div>
                  <!--<div class="col-md-3 col-sm-2 col-xs-12">
                     <select class="uom selectAjaxOption select2 form-control" name="uom55" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php    echo $this->companyGroupId; ?> OR created_by_cid = 0 AND active_inactive = 1">
                     <option value="">Select Option</option>
                              <?php if(!empty($materials)){
                        $material_type_id = getNameById('uom',$materials->uom,'id');
                        echo '<option value="'.$materials->uom.'"selected >'.$material_type_id->uom_quantity.'</option>';
                        }?>
                           </select>
                     </div>-->
               </div>
               <?php /*<div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="max_inventory">Maximum Inventory</label>
                     <div class="col-md-3 col-sm-2 col-xs-12">
                        <input type="text" id="max_inventory" name="max_inventory"  class="form-control col-md-7 col-xs-12" placeholder="Maximum Inventory" value="<?php if($materials && !empty($materials)){ echo $materials->max_inventory;} ?>"> 
            </div>
            <div class="col-md-3 col-sm-2 col-xs-12">
               <select class="form-control auto_uom" name="max_uom" readonly>
                  <option value="">Unit of Measurement</option>
                  <?php
                     $checked ='';
                     $uom = getUom();
                     foreach($uom as $unit) {
                        if((!empty($materials)) && ($materials->max_uom == $unit)){ $checked = 'selected';}else{$checked = '';  }
                        echo "<option value='".$unit."' ".$checked.">".$unit."</option>";
                     }
                     ?>
               </select>
            </div>
      </div>
      */ ?>
      <!-- Start Quality Check -->
      <div class="item form-group">
      <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12" for="non_inventry_material">Quality Check </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="radio" class=" quality_check beforeInsertQuality" name="quality_check" value="1" <?php if(!empty($materials) && $materials->quality_check) { echo 'checked';} ?> /> Required
      <input type="radio" class="quality_check" name="quality_check" value="0" <?php if(!empty($materials) && !$materials->quality_check) { echo 'checked';} if(empty($materials)){ echo 'checked';} ?> />Not Required </div>
      <div class="item form-group" id="qualityCheckLink" style="margin-top:50px; display:none" >
      <label style="visibility: hidden;" class="col-md-3 col-sm-3 col-xs-12" for="non_inventry_material">
      Quality Check </label>
      <!--div class="col-md-6 col-sm-6 col-xs-12">
         <input type="radio" class="flat" name="quality_check_type" id="quality_check_type" value="1" <?php //if(!empty($materials) && $materials->quality_check_type == 1 ){ echo 'checked'; }elseif( empty($materials) ){ echo 'checked'; } ?>  /> Create Format
         <input type="radio" class="flat" name="quality_check_type" id="quality_check_ntype" value="2" <?php //if(!empty($materials) && $materials->quality_check_type == 2 ) { echo 'checked';} ?> /> Link of format </div>
         </div-->
      </div>
      </div>
      <!-- End Quality Check -->
      <!--  customer Eliase  -->
      <!--<div class="item form-group">
         <div id="mainCustomerAlias" class="addMoreFunCss">
            <div class="cuatomerNameAlias row" id="cuatomerNameAlias" style="margin-top:10px;">
               <label class="col-md-3 col-sm-3 col-xs-12" for="lead">Customer Name</label>
               <div class="col-md-3 col-sm-6 col-xs-12">
                  <select class="customerSelect form-control selectAjaxOption select2 select2-hidden-accessible commanSelect2"   name="detors_name[]"  data-id="ledger" data-key="id" data-fieldname="name" placeholder="Select Customer" tabindex="-1" aria-hidden="true" data-where="created_by_cid = </?php echo $this->companyGroupId; ?> AND account_group_id = 54 AND activ_status = 1" style="width: 100% !important;">
                  </select>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="text" id="aliasName" name="aliasName[]" class="form-control col-md-7 col-xs-12" placeholder="Alias" value="">
                </div>
                <div class="col-md-1 col-sm-6 col-xs-12">
         <button class="btn  btn-danger remove_field" style="display:none;" type="button"><i class="fa fa-minus"></i></button>
                </div>
                
            </div>
         </div>
         
         <div class="my-btn">
            <button style="float:right;margin:5px;" class="btn edit-end-btn addMoreCustAlias" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
            <input type="hidden" id="countCustRow" value="1">
         </div>
         </div>-->
      <!-- End-customer Eliase  --> 
      <!-- start-Supplier Eliase  24-02-2022 -->      
      <div class="item form-group">
      <div id="mainSupplierAlias" class="addMoreFunCss mainSupplierAlias">
      <div class="SupplierNameAlias row" id="SupplierNameAlias" style="margin-top:10px;">
      <label class="col-md-3 col-sm-3 col-xs-12" for="lead">Supplier Name </label>
      <div class="col-md-3 col-sm-6 col-xs-12">
      <select class="customerSelect form-control col-md-2 col-xs-12 selectAjaxOption select2 requrid_class add_more_Supplier select2-width-imp"   name="detors_name[]" id="supplier_name" data-id="supplier" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status=1" style="width: 100% !important;" onchange="getSupplierAddress(event,this)">
      <option value="">Select Option</option>
      <?php if(!empty($materials)){
         $supplieDetails = json_decode($materials->MatAliasName);
         $supplierId = 0;
         $aliasName = '';
         foreach($supplieDetails as $supplierDetailId){
            $aliasName = $supplierDetailId->alias;
            $supplierId = getNameById('supplier',$supplierDetailId->customer_id,'id');
         }
         echo '<option value="'.$supplierId->id.'"selected >'.$supplierId->name.'</option>';
         }?>
      </select>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
      <input type="text" id="aliasName" name="aliasName[]" class="form-control col-md-7 col-xs-12" placeholder="Alias" value="">
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
      </div>
      <button class="btn  btn-danger remove_field" style="display:none;" type="button"><i class="fa fa-minus"></i></button>
      </div>
      </div> 
      <div class="my-btn">
      <button style="float:right;margin:5px;" class="btn edit-end-btn addMoreSupplierAlias" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
      <input type="hidden" id="countCustRow" value="1">
      </div>
      </div>
      <!-- End-Supplier Eliase  --> 
      <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12" for="min_order">Adding The Dimension</label>
      <div class="col-md-6 col-sm-6 col-xs-12">
      <label><input class="ädding_dimension" type="checkbox" name="">Yes</label>
      <!--input type="text" name="ch_for[]" value="" placeholder="L*W*H"  class="form-control set_dimension hide"-->
      <div class="set_dimension hide">
      <div class="dimension_lay">
      <div class="col-md-3"><input type="text" name="dimension_length" value="" placeholder="L"  class="form-control"></div>
      <div class="col-md-3"><input type="text" name="dimension_width" value="" placeholder="W"  class="form-control"></div>
      <div class="col-md-3"><input type="text" name="dimension_height" value="" placeholder="H"  class="form-control"></div>
      </div>
      <div class="col-md-3"><input type="text" name="total_cbf" value="" placeholder="CBF"  class="form-control cbf_val"></div>
      </div>
      </div>
      </div> 
      <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12" for="min_inventory">Standard Packing</label>
      <div class="col-md-3 col-sm-2 col-xs-12">
      <input type="text" id="standard_packing" name="standard_packing" class="form-control col-md-7 col-xs-12" placeholder="Standard Packing" value=""> </div>
      </div>
      <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12" for="min_inventory">Item Code</label>
      <div class="col-md-3 col-sm-2 col-xs-12">
      <input type="text" id="standard_packing" name="item_code" class="form-control col-md-7 col-xs-12" placeholder="Item Code" value=""> </div>
      </div>         
      </div>
   </div>
   <hr class="packingSection" style="display: none;">
   <div class="bottom-bdr packingSection" style="display: none;"></div>
   <h3 class="Material-head packingSection" style="display: none;">
   Packaging
   <hr>
   </h3>
   <div style="display: none;" class="packingSection col-md-8 col-sm-6 col-xs-12 form-group middle-box2" style="margin: 0px auto;display: table;float: unset;">
   <div class="well  pk edit-row1" style="overflow:auto; border-top: 1px solid #c1c1c1;" id="chkIndex_1">
   <div class="col-md-3 col-sm-6 col-xs-12 form-group">
   <label>Name</label>
   <select class="location form-control selectAjaxOption select2 location select2-hidden-accessible" name="packing_mat[]" data-id="material" data-key="id" data-fieldname="material_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getcbf(event,this);" data-where="dimension_length !='' && dimension_width !='' && dimension_height !='' && total_cbf != ''">
   <option>Select Option</option>
   </select>
   </div>
   <div class="col-md-3 col-sm-6 col-xs-12 form-group">
   <label>Quantity</label>
   <input type="text" id="Quantity" class="form-control col-md-7 col-xs-12" placeholder="Quantity" value="" name="packing_qty[]">
   </div>
   <div class="col-md-3 col-sm-6 col-xs-12 form-group">
   <label>Weight</label>
   <input type="text" id="rack" class="form-control col-md-7 col-xs-12" placeholder="Weight" value="" name="packing_weight[]"> 
   </div>
   <div class="cbf_set col-md-3 col-sm-6 col-xs-12 form-group" style="border-right:1px solid #c1c1c1 !important">
   <label>CBF</label>  
   <input type="text" class="packing_cbf form-control col-md-7 col-xs-12" placeholder="CBF" value="" readonly  name="packing_cbf[]"> 
   </div>
   <div id="multiple_packing"></div>
   <div class="btn-row"><button class="btn  plus-btn edit-end-btn" onclick="addPRow(event,this)" type="button">Add</button></div>
   </div>
   </div>
   <hr>
   <div class="bottom-bdr" style="display: <?php echo $display; ?>"></div>
   <div class="col-md-12 col-sm-6 col-xs-12 form-group add_multiple_location middle-box2" style="display: <?php echo $display; ?>">
   <?php 
      if(empty($locations)){
                     #
                     //if(empty($locations)){ ?>
   <div class="well " style="overflow:auto; border-top: 1px solid #c1c1c1 ; border-right: 1px solid #c1c1c1 ;" id="chkIndex_1">
   <input type="hidden" name="id_loc[]" value="" >
   <div class="col-md-6 col-sm-12 col-xs-12 form-group">
   <label> Address</label>
   <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" onchange="getArea(event,this);getlot(event,this)" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
   <option value="">Select Option</option>
   </select>
   </div>
   <div class="col-md-6 col-sm-6 col-xs-12 form-group">
   <label style=" border-right: 1px solid #c1c1c1 !important;">Quantity</label>
   <input style=" border-right: 1px solid #c1c1c1 !important;" type="text" id="qty" name="quantityn[]" class="form-control col-md-7 col-xs-12" placeholder="Quantity" onkeyup="getQtyValue(event,this)"> </div>
   <div class="col-md-4 col-sm-6 col-xs-12 form-group" style="display: none;">
   <label style=" border-right: 1px solid #c1c1c1 !important;">Uom</label>
   <select class="uom selectAjaxOption select2 form-control" name="Qtyuom[]" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uomid" data-where="(created_by_cid = <?php  echo $this->companyGroupId; ?> OR created_by_cid = 0) AND (active_inactive = 1)" required="required">
   <option value="">Select Option</option>
   </select>
   </div>
   <div class="btn-row">
   <button class="btn plus-btn edit-end-btn add_More_btn" type="button">Add</div>
   </div>
   <?php } else{
      #if(!empty($locations)){
         $i =  1;
         #
         foreach($locations as $source_Data){
      
      
            $locationAddress = getNameById('company_address',$source_Data['location_id'],'id');
      ?>
   <div class="well <?php if($i==1){ echo 'edit-row1';}else{ echo 'mobile-view scend-tr';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 ;" id="chkIndex_<?php echo $i; ?>">
   <input type="hidden" name="id_loc[]" value="<?php echo $source_Data['id']; ?>" >
   <div class="col-md-3 col-sm-12 col-xs-12 form-group">
   <label> Address</label>
   <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" onchange="getArea(event,this);" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
   <option>Select Option</option>
   <?php
      if(!empty($locationAddress)){
         //pre($locationAddress);
         echo '<option value="'.$locationAddress->id.'" selected>'.$locationAddress->location.'</option>';
      
      }
      ?>
   </select>
   </div>
   <div class="col-md-3 col-sm-6 col-xs-12 form-group">
   <label>Storage</label>
   <select class="area form-control" name="storage[]">
   <?php
      echo '<option value="'.$source_Data['Storage'].'" selected>'.$source_Data['Storage'].'</option>';
      ?>
   <option value="">Area</option>
   </select>
   </div>
   <div class="col-md-3 col-sm-6 col-xs-12 form-group">
   <label> Rack Number</label>
   <input type="text" id="rack" name="rackNumber[]" class="form-control col-md-7 col-xs-12" placeholder="Rack number" value="<?php if(!empty($source_Data)) echo $source_Data['RackNumber']; ?>"> </div>
   <div class="col-md-3 col-sm-6 col-xs-12 form-group">
   <label style=" border-right: 1px solid #c1c1c1 !important;">Quantity</label>
   <input style=" border-right: 1px solid #c1c1c1 !important;" type="text" id="qty" name="quantityn[]" class="form-control col-md-7 col-xs-12" placeholder="Quantity" value="<?php if(!empty($source_Data) && isset($source_Data['quantity']))  echo $source_Data['quantity']; ?>" onkeyup="getQtyValue(event,this)"> </div>
   <div class="col-md-3 col-sm-6 col-xs-12 form-group" style="display: none;">
   <label style=" border-right: 1px solid #c1c1c1 !important;">Uom</label>
   <select class="uom selectAjaxOption select2 form-control" name="Qtyuom[]" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php    echo $this->companyGroupId; ?> OR created_by_cid = 0 AND active_inactive = 1">
   <option value="">Select Option</option>
   <?php if(!empty($materials)){
      $material_type_id = getNameById('uom',$source_Data['Qtyuom'],'id');
      echo '<option value="'.$materials->uom.'"selected >'.$material_type_id->uom_quantity.'</option>';
      }?>
   </select>
   </div>
   <?php if($i==1){
      echo '<div class="btn-row"><button class="btn  plus-btn edit-end-btn add_More_btn" type="button">Add</button></div>';
      }else{
      
      //echo '<button style="margin-right: 0px;" class="btn btn-danger delete_btn" type="button"> <i class="fa fa-minus"></i></button>';
      }
      ?>
   </div>
   <?php $i++;}}?>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
   <div class="item form-group">
   <label class="col-md-3 col-sm-3 col-xs-12" for="img">Featured Image </label>
   <div class="col-md-6 col-sm-6 col-xs-12">
   <input type="hidden" class="form-control col-md-7 col-xs-12 hiddenImage" name="featured_image" id="hiddenImage" value="<?php echo isset($materials->featured_image)?$materials->featured_image: " ";?>">
   <button type="button" class="btn" name="featured_image" id="image">Upload featured_image</button>
   </div>
   </div>
   <div class="item form-group">
   <label class="col-md-3 col-sm-3 col-xs-12" for="img"></label>
   <div class="col-md-6 col-sm-6 col-xs-12">
   <div id="uploaded_image_Add"></div>
   </div>
   </div>
   <?php if(!empty($materials)){
      ?>
   <div class="item form-group">
   <label class="col-md-3 col-sm-3 col-xs-12" for="proof"></label>
   <div class="col-md-6">
   <?php    if(!empty($materials->featured_image)){
      echo '
      <div class="col-md-55">
         <div class="image view view-first">
            <div id="uploaded_image"><img style="width: 100%; display: block;" src="'.base_url().'assets/modules/inventory/uploads/'.$materials->featured_image.'" alt="image" class="undo" id="uploaded_image"/></div>
         </div>
      </div>'; }else{
         echo ' <div class="col-md-55">
         <div class="image view view-first">
            <div id="uploaded_image"><img style="width: 100%; display: block;" src="'.base_url().'assets/modules/inventory/uploads/product.png" alt="image" class="undo" id="uploaded_image"/></div>
         </div>
      </div>';
      }
      ?> </div>
   </div>
   <?php } ?>
   </div>
   <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
   <div class="item form-group">
   <label class="col-md-3 col-sm-3 col-xs-12" for="proof">Material Image  </label>
   <div class="col-md-6 col-sm-6 col-xs-12 ">
   <input type="file" class="form-control col-md-7 col-xs-12" name="materialImage[]"> </div>
   <button class="btn btn-warning add_images" type="button"><i class="fa fa-plus"></i></button>
   </div>
   <div class="item form-group image_box"> </div>
   <?php if(!empty($imageUpload)){
      ?>
   <div class="item form-group">
   <label class="col-md-3 col-sm-3 col-xs-12" for="proof"></label>
   <div class="col-md-8">
   <?php
      foreach($imageUpload as $image_upload){
         echo '<div class="col-md-4">';
      
               $ext = pathinfo($image_upload['file_name'], PATHINFO_EXTENSION);
               if($ext == 'ods' || $ext ==  'doc' || $ext ==  'docx' || $ext ==  'xls'){
               echo'<div class="image view view-first"><a download="'.$image_upload['file_name'].'" href="'.base_url().'assets/modules/inventory/uploads/'.$image_upload['file_name'].'"><img style="width: 100%; display: block;" src="'.base_url().'assets/images/file-icon.png" alt="image" class="undo" height="50px" /><i class="fa fa-download"></i>
                  <div class="mask">
                     <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'inventory/delete_images/'.$image_upload['id'].'/'.$materials->id.'">
                        <i class="fa fa-trash"></i>
                     </a>
                  </div></div>';
               }else if($ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg' || $ext == 'png' || $ext == 'ico'){
                  echo'<div class="image view view-first"><a download="'.$image_upload['file_name'].'" href="'.base_url().'assets/modules/inventory/uploads/'.$image_upload['file_name'].'"><img style="width: 100%; display: block;" src="'.base_url().'assets/images/uplod-icon.png" alt="image" class="undo" height="50px" /><i class="fa fa-download"></i>
                  <div class="mask">
                     <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'inventory/delete_images/'.$image_upload['id'].'/'.$materials->id.'">
                        <i class="fa fa-trash"></i>
                     </a>
                  </div></div>';
      
      
               }
               echo'
                                         </div>';
      }
      ?> </div>
   </div>
   <?php } ?>
   </div>
   <hr>
   <div class="form-group">
   <div class="col-md-12 col-xs-12">
   <center>
   <input type="reset" class="btn btn-default" value="Reset">
   <?php if((!empty($materials) && $materials->save_status == 0) || empty($materials) ){
      echo '<input type="submit" class="btn edit-end-btn draftBtn1" value="Save as draft">';
      } ?>
   <input type="submit" class="btn btn-warning signUpBtn add_mat_btn_submit" value="submit">
   <button type="button" class="btn btn-default close_modal2" onclick="location.href='<?php echo base_url();?>inventory/materials'">Close</button>
   </center>
   </div>
   </div>
   </form>
</div>
<?php
   }
   ?>
<!-----------------------------------------------------fetaured image upload used crop method---------------------------------------------------------------->
<div id="imageModalUpload" class="modal modal1" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss-modal="modal" id="closemodal">&times;</button>
            <h4 class="modal-title">Upload & Crop Image</h4>
         </div>
         <div class="modal-body">
            <div class="container">
               <div class="panel panel-default">
                  <div class="panel-heading">Select featured Image</div>
                  <div class="panel-body" align="center">
                     <!--<input type="file" name="user_profile" id="user_profile" accept="image/*" />-->
                     <input type="file" name="featured_image" id="featured_image" accept="image/*" />
                     <input type="hidden" name="changed_featured_image" id="changed_featured_image" value="" />
                     <input type="hidden" name="fileOldlogo" value="<?php echo isset($materials->featured_image)?$materials->featured_image: " ";?>">
                     <br />
                     <div id="uploaded_image"></div>
                  </div>
               </div>
            </div>
            <div class="row crop_section" style="display:none;">
               <div class="col-md-8 text-center">
                  <div id="image_demo" style="width:350px; margin-top:30px"></div>
               </div>
               <div class="col-md-4" style="padding-top:30px;">
                  <br />
                  <br />
                  <br/>
                  <button class="btn btn-success crop_image">Crop & Upload Image</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal left fade" id="myModal_Add_uom1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add UOM</h4>
            <span id="mssg"></span> 
         </div>
         <form name="insert_supplier_data" name="ins" id="insert_uom_data_id">
            <div class="modal-body">
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">UOM Quantity<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="uom_quantity" name="uom_quantity" required="required" class="form-control col-md-12 col-xs-12" placeholder="UOM Quantity" value="" style="border-right: 1px solid #c1c1c1 !important;">
                     <input type="hidden" value="" id="fetch_sname"> <span class="spanLeft control-label"></span> 
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">UOM Type<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="uom_quantity_type" name="uom_quantity_type" required="required" class="form-control col-md-12 col-xs-12" placeholder="UOM Type" value="<?php if(!empty($uom_list1)) echo $uom_list1->uom_quantity_type; ?>" style="border-right: 1px solid #c1c1c1 !important;"> <span id="acc_grp_id"></span> 
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="col-md-2 col-sm-2 col-xs-4" for="gstin">UQC Code</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="ugc_code" name="ugc_code" required="required" class="form-control col-md-12 col-xs-12" placeholder="UQC Code" value="" style="border-right: 1px solid #c1c1c1 !important;">
                     <!--span class="spanLeft control-label"></span-->
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default close_sec_model">Close</button>
               <button id="add_uom_btn_id" type="button" class="btn btn-warning">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal left fade myModal_lotdetails" id="myModal_lotdetails" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Lot Details</h4>
            <span id="mssg343"></span> 
         </div>
         <form name="insert_party_data" name="ins" id="insert_Matrial_data_id33">
            <div class="modal-body">
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-12" for="name">Lot No.<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="lotno" name="material_name" required="required" class="form-control col-md-7 col-xs-12" value=""> <span class="spanLeft control-label"></span> 
                  </div>
               </div>
               <!--<div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Material Type <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                  
                  <!--<select name="material_type_id"  width="100%" id="material_type_id" class="form-control">
                  <option value="">Select Material Type </option>
                  
                  </select>-->
               <input type="hidden" name="material_type_id" id="material_type_id22" class="form-control" value="">
               <input type="hidden" name="material_name_id" id="material_name_id"> <span class="spanLeft control-label"></span>
               <!--</div>
                  </div>-->
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-12" for="email">MOU Price</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="mou_price" name="hsn_code" class="form-control col-md-7 col-xs-12" value=""> <span class="spanLeft control-label"></span> 
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-12" for="email">MRP Price</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="mrp_price" name="hsn_code" class="form-control col-md-7 col-xs-12" value=""> <span class="spanLeft control-label"></span> 
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-12" for="email">Date</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="date" name="date" id="" class="form-control col-md-7 col-xs-12 req_date" value=""> 
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <input type="hidden" id="add_matrial_Data_onthe_spot">
               <!--button type="button" class="btn btn-default close_sec_model">Close</button-->
               <button type="button" class="btn btn-default close_add_lot_modal">Close</button>
               <button id="Add_lot_details_on_button_click_mrn" type="button" class="btn edit-end-btn ">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal left fade add-modl" id="myModal_Add_matrial_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Material Details</h4>
            <span id="mssg34"></span>
         </div>
         <form name="insert_party_data" name="ins"  id="insert_Matrial_data_id">
            <div class="modal-body">
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="name">Material Name<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="material_name" name="material_name" required="required" class="form-control col-md-7 col-xs-12" value="">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <input type="hidden" name="material_type_id" id="materialtypeid"  class="form-control" value="">
               <input type="hidden" name="prefix"  id="prefix">
               <span class="spanLeft control-label"></span>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">HSN Code </label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="hsn_code" name="hsn_code" class="form-control col-md-7 col-xs-12" value="" >
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="gst">GST</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="gst_tax" name="gst_tax" class="form-control col-md-7 col-xs-12" value="" onkeypress="return float_validation(event, this.value)">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">UOM</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="uom selectAjaxOption select2 form-control" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php   echo $this->companyGroupId; ?> OR created_by_cid = 0 AND active_inactive = 1">
                        <option value="">Select Option</option>
                        <?php
                           if(!empty($materials)){
                           $materials = getNameById('uom',$materials->uom,'uom_quantity');
                           echo '<option value="'.$material->id.'" selected>'.$material->uom_quantity.'</option>';
                           }
                           ?>
                     </select>
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">Opening Balance</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="opening_balance_Sec" name="opening_balance" class="form-control col-md-7 col-xs-12" value="">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="gstin">Specification</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification"></textarea>
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <input type="hidden" id="add_matrial_Data_onthe_spot">
               <button type="button" class="btn btn-default close_sec_model" >Close</button>
               <button id="Add_matrial_details_on_button_click" type="button" class="btn edit-end-btn ">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-------------------------------------------------------------------------Multiple image upload used crop method---------------------------------------------------------------->
<!--<div id="MultipleImageModalUpload" class="modal modal1" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close"  data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Upload & Crop Image</h4>
         </div>
         <div class="modal-body">
            <div class="container">
               <div class="panel panel-default">
                  <div class="panel-heading">Select Profile Image</div>
                     <div class="panel-body" align="center">
                        <!--<input type="file" name="user_profile" id="user_profile" accept="image/*" />-->
<!--<input type="file" name="materialImage[]" id="multiple_image" accept="image/*" />
   <input type="hidden" name="changed_user_profile" id="changed_user_profile" value=""/>
   <input type="hidden" name="fileOldlogo" value="<?php //echo isset($user->user_profile)?$user->user_profile: "";?>">
   <br />
   <div id="uploaded_image_multiple"></div>
   </div>
   </div>
   </div>
   <div class="row crop_section_multiple" style="display:none;">
   <div class="col-md-8 text-center">
   <div id="image_demo_multiple" style="width:350px; margin-top:30px"></div>
   </div>
   <div class="col-md-4" style="padding-top:30px;">
   <br />
   <br />
   <br/>
   <button class="btn btn-success crop_image_multiple">Crop & Upload Image</button>
   </div>
   </div>
   </div>
   <div class="modal-footer">
   <button type="button" class="btn btn-default fatimes" data-dismiss="modal">Close</button>
   <input  type="reset" class="btn btn-default reset" value="reset">
   </div>
   </div>
   </div>
   </div>-->
<div id="myDivty" class="lodar-main" style="display: none;">
   <div class="lodar-ineer"><i class="fa fa-refresh fa-5x fa-spin"></i></div>
   <div class="blck">
   </div>
</div>
<div id="wrngmdl" class="lodar-main" style="display: none;">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <h4>No Parent SKU Found !</h4>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary close_sec_model">Close</button>
         </div>
      </div>
   </div>
</div>
<div id="HSNMODAL_modal" class="modal fade in"  role="dialog">
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add HSN Number</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
<script type="text/javascript">
   function addPRow(evt , t){
   var logged_user = ''; //$('#loggedUser').val();     
    var x;
    var lastid = $(".pk:last").attr("id");
    if(lastid != '' && typeof(lastid) != 'undefined'){
        var lastIdVal= lastid.split('_');       
        x = parseInt(lastIdVal[1]);     
    }   
                        
    var maximum = 15;   //maximum input boxes allowed
    if(x < maximum){    //max input box allowed
        x++; 
        $("#multiple_packing").append(packingRowHtml(x,logged_user));
    }                               
    
    $(".add_multiple_Variant").on("click",".remove_variant", function(e){ //user click on remove text
        e.preventDefault(); 
        var removeId = $(this).attr('id');
        if(removeId != '' && typeof(removeId) != 'undefined'){
            var delIdVal= removeId.split('_');      
            var rv = parseInt(delIdVal[1]); 
            if(rv != 1){    //delete row, except first row
                $("#variant_"+rv).remove(); 
            }
            x--;
        }   
    }); 
    init_select2();
   
   $(".delete_btn").on("click", function() {
   
   $(this).parent('div').remove();
   });
   
   }
   
   
   
   
   
   function packingRowHtml(x,logged_user){
    return Html = `<div class="well scend-tr pk" style="overflow:auto;border-right: 1px solid #c1c1c1;" id="variant_${x}">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
   <select class="location form-control selectAjaxOption select2 location select2-hidden-accessible" name="packing_mat[]" data-id="material" data-key="id" data-fieldname="material_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getcbf(event,this);" data-where="dimension_length !='' && dimension_width !='' && dimension_height !='' && total_cbf != ''">
   <option>Select Option</option>
   </select>
   </div>
   <div class="col-md-3 col-sm-6 col-xs-12 form-group">
   <input type="text" id="Quantity" class="form-control col-md-7 col-xs-12" placeholder="Quantity" value="" name="packing_qty[]">
   </div>
   <div class="col-md-3 col-sm-6 col-xs-12 form-group">
   <input type="text" id="rack" class="form-control col-md-7 col-xs-12" placeholder="Weight" value="" name="packing_weight[]"> 
   </div>
   <div class="cbf_set col-md-3 col-sm-6 col-xs-12 form-group" style="border-right:1px solid #c1c1c1 !important">
   <input type="text" class="packing_cbf form-control col-md-7 col-xs-12" placeholder="CBF" value=""  name="packing_cbf[]" readonly> 
   </div> <button class="btn btn-danger delete_btn" type="button" style="top: 17px;right: -15px;"><i class="fa fa-minus"></i></button>  
                </div>`;
   }
</script>
<div id="myDivty" class="lodar-main" style="display: none;">
   <div class="lodar-ineer"><i class="fa fa-refresh fa-5x fa-spin"></i></div>
   <div class="blck">
   </div>
</div>
<div id="wrngmdl" class="lodar-main" style="display: none;">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <h4>No Parent SKU Found !</h4>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary close_sec_model">Close</button>
         </div>
      </div>
   </div>
</div>
<div id="quality_modal" class="modal fade in"  role="dialog" >
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content" style="display:table;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Report Details</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>