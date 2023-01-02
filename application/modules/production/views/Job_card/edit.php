<style>
#infodiv{
    pointer-events: none;
    /*opacity: 0.4;*/
}
</style>


<?php
    if( !isset($jobcard_material) ){
        $jobcard_material = "";
    }
   $getcompanyName = getNameById('company_detail',$_SESSION['loggedInUser']->c_id ,'id');
   $name = $getcompanyName->name;
   $CompanyName = substr($name , 0,6);
   $last_id = getLastTableId('job_card');
   $rId = $last_id + 1;
   $jobCode = (isset($JobCard) && !empty($JobCard))?$JobCard->job_card_no:('JC_'.rand(1, 1000000).'_'.$CompanyName.'_'.$rId);
   //error_reporting(0);
  // die('dsfdsfd');
   ?>

<div class="container">
   <ul class="nav tab-3 nav-tabs">
      <li class="active"><a data-toggle="tab" href="#info" aria-expanded="true">Info</a></li>
      <li class=""><a data-toggle="tab" href="#Address2" aria-expanded="false">Bom</a></li>
      <li class=""><a data-toggle="tab" href="#Details2" aria-expanded="true">Routing</a></li>
   </ul>

<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveJobCard" enctype="multipart/form-data" id="jobCardDetail" novalidate="novalidate" style="">
   <div class="tab-content">

   <div id="info" class="tab-pane fade active in" style="padding:20px; ">
	<div id="infodiv">
         <?php
            $last_id = getLastTableId('material');
            $rId = $last_id + 1;
            $matCode = 'MAT_'.rand(1, 1000000).'_'.$rId;
            $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
         ?>
         <input type="hidden" name="" id="mat_id_funcs" value="<?php if(!empty($rId)) echo $rId; ?>">
         <input type="hidden" id="id" value="<?php if(!empty($rId)) echo $rId; ?>">
         <input type="hidden" name="job_card_material_id" value="<?php if(isset($jobcard_material) && !empty($jobcard_material)){ echo $jobcard_material->id;} ?>">
         <input type="hidden" name="inventory_save_status" value="1" class="save_status1">
         <input type="hidden" name="prefix" class="matPrefix" value="<?php if(isset($jobcard_material) && !empty($jobcard_material)){ echo $jobcard_material->prefix;} ?>">
         <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
         <input type="hidden" name="inventory_listing_mat_side" value="" id="inventory_listing_mat_side">

         <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
            <div class="item form-group">
               <label class="col-md-3 col-sm-3 col-xs-12" for="code">Material Code</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="material_code" class="form-control col-md-7 col-xs-12" name="material_code" placeholder="both name(s) e.g Jon Doe" type="text" value="<?php if(!empty($jobcard_material)) echo $jobcard_material->material_code; else echo $matCode; ?>" readonly>
               </div>
            </div>
            <div class="item form-group">
               <label class="col-md-3 col-sm-3 col-xs-12" for="materail_type">Material Type<span class="required" style="color:red;">*</span></label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control selectAjaxOption select2 select2-hidden-accessible materialTypeId" required="required" name="inventory_material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" id="material_typewsws" onchange="ChangePrefix_and_subType();">
                     <option value="">Select Option</option>
                     <?php if(!empty($jobcard_material)){
                     $material_type_id = getNameById('material_type',$jobcard_material->material_type_id,'id');
                     echo '<option value="'.$jobcard_material->material_type_id.'" material_type_prefix="'.$material_type_id->prefix.'" selected >'.$material_type_id->name.'</option>';
                     }?>
                  </select>
               </div>
            </div>
            <span id="selectedMaterialSubType" style="display:none;"><?php if(!empty($jobcard_material)){ echo $jobcard_material->sub_type; } ?></span>
            <div class="item form-group">
               <label class="col-md-3 col-sm-3 col-xs-12" for="materail_type">Material Sub Type</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="subtype form-control" name="inventory_sub_type" id="subtype1">
                     <?php if(!empty($jobcard_material)){
                        echo '<option value="'.$jobcard_material->sub_type.'" selected>'.$jobcard_material->sub_type.'</option>';
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
                           $sale_purchase = ((!empty($jobcard_material) && $jobcard_material->sale_purchase != '')?json_decode($jobcard_material->sale_purchase):'');
                           ?> Sale:
                           <input type="checkbox" class="flat" name="sale_purchase[]" id="sale" value="Sale" <?php if(!empty($jobcard_material) && $sale_purchase !='' && in_array( "Sale", $sale_purchase)) echo 'checked';?> />
                           <!--Purchase:
                           <input type="checkbox" class="flat" name="sale_purchase[]" id="purchase" value="Purchase" <?php if(!empty($jobcard_material)  &&  $sale_purchase != ''  && in_array("Purchase", $sale_purchase)) echo 'checked';?> />-->
                           <?php
                           $route = ((!empty($jobcard_material) && $jobcard_material->route != '')?json_decode($jobcard_material->route):'');?> Purchase:
                           <input type="checkbox" class="flat" name="route[]" id="purchase" value="Purchase" <?php if(!empty($jobcard_material) && $route !='' && in_array( "Purchase", $route)) echo 'checked';?> /> Manufacture:
                           <input type="checkbox" class="flat" name="route[]" id="manufacture" value="Manufacture" <?php if(!empty($jobcard_material) && $route !='' && in_array( "Manufacture", $route)) echo 'checked';?> onclick="showJobCardForManufactureMaterial(this);"/>
                        </p>
                     </div>
                  </div>
               </div>

               <!--<div class="item form-group jobCardDiv">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="img">Job Card</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible job_card_no" name="job_card" width="100%" tabindex="-1" aria-hidden="true" data-id="job_card" data-key="id" data-fieldname="job_card_no" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php // echo $this->companyGroupId; ?> AND save_status = 1">
                        <option value="">Select Option</option>
                        <?php /* if(!empty($materials) && ($materials->job_card !='' && $materials->job_card !=0)){
                        $jobCard = getNameById('job_card',$materials->job_card,'id');
                        echo '<option value="'.$jobCard->id.'" selected>'.$jobCard->job_card_no.'</option>';
                           } */
                        ?>
                           <?php  //echo '<option value="'.$job_cardId.'" selected>'.$jobcard_data->job_card_no.'</option>'; ?>
                     </select>
                  </div>
               </div>-->

               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="non_inventry_material">Inventory Type </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="radio" class="flat" name="non_inventry_material" id="genderM" value="0" <?php if(!empty($jobcard_material) && $jobcard_material->non_inventry_material == '0') { echo 'checked';} ?> /> Inventory
                     <input type="radio" class="flat" name="non_inventry_material" id="genderF" value="1" <?php if(!empty($jobcard_material) && $jobcard_material->non_inventry_material == '1') { echo 'checked';} if(empty($jobcard_material)){ echo 'checked';} ?> />Non-Inventory </div>
               </div>

               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="material_name">Product Name <span style="color:red;">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="text" id="material_name" name="inventory_material_name" required="required" class="form-control col-md-7 col-xs-12 has-feedback-left" placeholder="Material name" value="<?php if(!empty($jobcard_material)) echo $jobcard_material->material_name; ?>"> <span class="form-control-feedback left prefix" aria-hidden="true"><?php if($jobcard_material && !empty($jobcard_material)){ echo $jobcard_material->prefix;} ?></span> </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="mat_sku">Product SKU</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="text"  name="mat_sku" class="form-control col-md-7 col-xs-12" placeholder="Product SKU" value="<?php if(!empty($jobcard_material)) echo $jobcard_material->mat_sku; ?>"> </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="sale">Sale price</label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                     <input type="number" id="sale_price" name="sales_price" class="form-control col-md-7 col-xs-12" placeholder="Sale price" value="<?php if($jobcard_material && !empty($jobcard_material)){ echo $jobcard_material->sales_price;} ?>">
                  </div>
                  <div class="item form-group">
                     <label class="control-label col-md-2 col-sm-3 col-xs-12" for="cost">Cost price</label>
                     <div class="col-md-2 col-sm-2 col-xs-12">
                        <input type="text" id="cost_price" name="cost_price" class="form-control col-md-7 col-xs-12" placeholder="Cost price" value="<?php if($jobcard_material && !empty($jobcard_material)){ echo $jobcard_material->cost_price;} ?>">
                     </div>
                  </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="hsn_code">HSN Code</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="text" id="hsn_code" name="hsn_code" class="form-control col-md-7 col-xs-12 hsn" placeholder="Valid Hsn_code" value="<?php if(!empty($jobcard_material)) echo $jobcard_material->hsn_code; ?>"> </div>
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
                     <input type="text" name="opening_balance" id="opening_bal" class="form-control col-md-7 col-xs-12" placeholder="Opening Balance" value="<?php if(!empty($jobcard_material)) echo $jobcard_material->opening_balance; ?>" <?php echo $rdonly; ?> required="required">
                  </div>
                  <div class="col-md-3 col-sm-2 col-xs-12">
                     <select class="selectAjaxOption select2 form-control" id="uomid" name="inventory_material_uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" data-where="(created_by_cid = <?php   echo $this->companyGroupId; ?> OR created_by_cid = 0) AND (active_inactive = 1)" required="required">
                        <option value="">Select Option</option>
                        <?php if(!empty($jobcard_material->uom)){
                           $material_type_id = getNameById('uom',$jobcard_material->uom,'id');
                           #pre($material_type_id);
                           echo '<option value="'.$jobcard_material->uom.'"selected >'.$material_type_id->uom_quantity.'</option>';
                           }?>
                     </select>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="lead">Lead Time</label>
                  <div class="col-md-3 col-sm-6 col-xs-12">
                     <input type="text" id="lead" name="lead_time" class="form-control col-md-7 col-xs-12" placeholder="Lead Time" value="<?php if($jobcard_material && !empty($jobcard_material)){ echo $jobcard_material->lead_time;} ?>"> </div>
                  <div class="col-md-3 col-sm-6 col-xs-12">
                     <select class="form-control" name="time_period" id="tmpp">
                        <option value="">Select</option>
                        <option value="hours" <?php if(!empty($jobcard_material) && $jobcard_material->time_period == 'hours'){ echo 'selected'; }?>>Hours</option>
                        <option value="days" <?php if(!empty($jobcard_material) && $jobcard_material->time_period == 'days'){ echo 'selected'; }?>>Days</option>
                        <option value="weeks" <?php if(!empty($jobcard_material) && $jobcard_material->time_period == 'weeks'){ echo 'selected'; }?>>Weeks</option>
                        <option value="month" <?php if(!empty($jobcard_material) && $jobcard_material->time_period == 'month'){ echo 'selected'; }?>>Months</option>
                     </select>
                  </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="tax">Tax</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <select class="form-control" name="tax">
                        <option value="">Select Tax</option>
                        <?php
                           $taxes = taxList();
                              foreach($taxes as $tax){
                                 $taxSelected = '';
                                 if(!empty($jobcard_material) && $jobcard_material->tax == $tax){
                                 $taxSelected =  'selected';
                                 }
                              echo '<option value="'.$tax.'" '.$taxSelected.'>'.$tax.' %</option>';
                              }
                           ?>
                     </select>
                  </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="lead">Cess</label>
                  <div class="col-md-3 col-sm-6 col-xs-12">
                     <select class="form-control" name="cess">
                        <option value="">Select Cess </option>
                        <?php
                           $taxes = taxList();
                              foreach($taxes as $tax){
                                 $taxSelected = '';
                                    if(!empty($jobcard_material) && $jobcard_material->cess == $tax){
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
                        <option value="based_on_qty" <?php if(!empty($jobcard_material) && $jobcard_material->valuation_type == 'based_on_qty'){ echo 'selected'; }?>>Based on Quantity</option>
                        <option value="based_on_value" <?php if(!empty($jobcard_material) && $jobcard_material->valuation_type == 'based_on_value'){ echo 'selected'; }?>>Based on Value</option>
                        <option value="based_on_qty_value" <?php if(!empty($jobcard_material) && $jobcard_material->valuation_type == 'based_on_val_qty'){ echo 'selected'; }?>>Based on Value & Qty.</option>
                     </select>
                  </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="specification">Specification</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification">
                        <?php if(!empty($jobcard_material)) echo $jobcard_material->specification; ?>
                     </textarea>
                  </div>
               </div>
              <?php /* <div class="form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="tags">Material Tags</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker"  name="tags_data[]" data-id="tag_details" data-key="id" data-fieldname="tag_name" width="100%" tabindex="-1"  data-where="created_by_cid=<?php echo $this->companyGroupId;?> AND active_inactive = 1">
                        <option>Select Option</option>
                     </select>
                  </div>
               </div> */ ?>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="min_order">Minimum Order</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="text" id="min.order" name="min_order" class="form-control col-md-7 col-xs-12" placeholder="Minimum order" value="<?php if(!empty($jobcard_material))  echo $jobcard_material->min_order ;?>" min="1">
                  </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="min_inventory">Reorder Level</label>
                  <div class="col-md-3 col-sm-2 col-xs-12">
                     <input type="text" id="min.inventory" name="min_inventory" class="form-control col-md-7 col-xs-12" placeholder="Minimum inventory" value="<?php if(!empty($jobcard_material)) echo $jobcard_material->min_inventory; ?>">
                  </div>
               </div>
            </div>
            <hr>


            <div class="bottom-bdr" style="display: <?php echo $display; ?>"></div>
			 <div class="col-md-12 col-sm-6 col-xs-12 form-group add_multiple_location middle-box2" style="display: <?php echo $display; ?>">
               <?php if(empty($locations)){
                     #pre($locations);
                     //if(empty($locations)){ ?>
                  <div class="well " style="overflow:auto; border-top: 1px solid #c1c1c1 ; border-right: 1px solid #c1c1c1 ;" id="chkIndex_1">
                     <input type="hidden" name="id_loc[]" value="">
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <label> Address</label>
                        <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" onchange="getArea(event,this);getlot(event,this)" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
                           <option value="">Select Option</option>
                        </select>
                                             <!--select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="location_settings" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true"  data-where="created_by_cid=<?php //echo $_SESSION['loggedInUser']->c_id; ?>"  onchange="getArea(event,this);">
                           <option value="">Select Option</option>
                           </select-->
                     </div>
                     <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                        <label>Storage</label>
                        <select class="area form-control" name="storage[]">
                           <option value="">Area</option>
                        </select>
                     </div>
                     <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                        <label>Rack number</label>
                        <input type="text" id="rack" name="rackNumber[]" class="form-control col-md-7 col-xs-12" placeholder="Rack number"> </div>
                     <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                        <label>Lot No.</label>
                        <select class="lotno lotno22 form-control col-md-2 col-xs-12 select2" id="mat_name"  name="lotno[]">
                           <option value="">Select Option</option>
                        </select>
                     </div>
                     <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                        <label style=" border-right: 1px solid #c1c1c1 !important;">Quantity</label>
                        <input style=" border-right: 1px solid #c1c1c1 !important;" type="text" id="qty" name="quantityn[]" class="form-control col-md-7 col-xs-12" placeholder="Quantity" onkeyup="getQtyValue(event,this)"> </div>
                     <div class="col-md-4 col-sm-6 col-xs-12 form-group" style="display: none;">
                        <label style=" border-right: 1px solid #c1c1c1 !important;">Uom</label>
                        <select class="uom selectAjaxOption select2 form-control" name="Qtyuom[]" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uomid" data-where="(created_by_cid = <?php  echo $this->companyGroupId; ?> OR created_by_cid = 0) AND (active_inactive = 1)" required="required">
                           <option value="">Select Option</option>
                        </select>
                     </div>
                      <div class="btn-row">
                       <button class="btn plus-btn edit-end-btn add_More_btn" type="button">Add</button>
                       </div>
                  </div>
                  <?php } else{
                           #if(!empty($locations)){
                              $i =  1;
                              #pre($locations);
                              foreach($locations as $source_Data){
                                 $locationAddress = getNameById('company_address',$source_Data['location_id'],'id');
                           ?>
                     <div class="well <?php if($i==1){ echo 'edit-row1';}else{ echo 'mobile-view scend-tr';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 ;" id="chkIndex_<?php echo $i; ?>">
                        <input type="hidden" name="id_loc[]" value="<?php echo $source_Data['id']; ?>">
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
                                                <?php
                              //pre($source_Data);
                              ?>
                           <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                              <label>Storage</label>
                              <select class="area form-control" name="storage[]">
                                 <option value="">Select Option</option>
                                 <?php
                                    echo '<option value="'.$source_Data['Storage'].'" selected>'.$source_Data['Storage'].'</option>';
                                 ?>
                              </select>
                           </div>
                           <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                              <label> Rack Number</label>
                              <input type="text" id="rack" name="rackNumber[]" class="form-control col-md-7 col-xs-12" placeholder="Rack number" value="<?php if(!empty($source_Data)) echo $source_Data['RackNumber']; ?>">
                           </div>
                           <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                              <label>Lot No.</label>
                              <select class="lotno lotno22 form-control col-md-2 col-xs-12 select2" id="mat_name"
                                 name="lotno[]" data-id="lot_details" data-key="id" data-fieldname="lot_number"
                                 data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND mat_id = <?php echo $materials->id;?> AND active_inactive=1">
                                 <option value="">Select Option</option>
                                 <?php
                                       if (!empty($source_Data && $source_Data['lot_no'])) {
                                       $lot_details = getNameById('lot_details',$source_Data['lot_no'],'id');
                                       echo '<option value="' .$source_Data['lot_no'] . '" selected>' .  $lot_details->lot_number. '</option>';
                                       }
                                    ?>
                              </select>
                           </div>

                           <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                              <label style=" border-right: 1px solid #c1c1c1 !important;">Quantity</label>
                              <input style=" border-right: 1px solid #c1c1c1 !important;" type="text" id="qty" name="quantityn[]" class="form-control col-md-7 col-xs-12" placeholder="Quantity" value="<?php if(!empty($source_Data) && isset($source_Data['quantity']))  echo $source_Data['quantity']; ?>" onkeyup="getQtyValue(event,this)"> </div>
                           <div class="col-md-3 col-sm-6 col-xs-12 form-group" style="display: none;">
                              <label style=" border-right: 1px solid #c1c1c1 !important;">Uom</label>
                              <select class="uom selectAjaxOption select2 form-control" name="Qtyuom[]" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php    echo $this->companyGroupId; ?> OR created_by_cid = 0 AND active_inactive = 1">
                                 <option value="">Select Option</option>
                                 <?php if(!empty($jobcard_material)){
                                          $material_type_id = getNameById('uom',$source_Data['Qtyuom'],'id');
                                          echo '<option value="'.$jobcard_material->uom.'"selected >'.$material_type_id->uom_quantity.'</option>';
                                          }?>
                              </select>
                           </div>
                           <?php if($i==1){
                                    echo '<div class="btn-row"><button class="btn  plus-btn edit-end-btn add_More_btn" type="button">Add</button></div>';
                                    }else{

                                       echo '<button style="margin-right: 0px;" class="btn btn-danger" type="button" id="'.$source_Data['id'].'" onclick="delete_location(this.id)"> <i class="fa fa-minus"></i></button>';
                                    }
                           ?>
                      </div>
                     <?php $i++;}}?>
            </div>
				<input type="hidden" name="material_type_id" id="material_type_id22" class="form-control" value="">
				<input type="hidden" name="material_name_id" id="material_name_id">
            <hr>
            <div class="bottom-bdr"></div>
            <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="img">Featured Image </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="hidden" class="form-control col-md-7 col-xs-12 hiddenImage" name="featured_image" id="hiddenImage" value="<?php echo isset($jobcard_material->featured_image)?$jobcard_material->featured_image: " ";?>">
                     <button type="button" class="btn" name="featured_image" id="image">Upload featured_image</button>
                  </div>
               </div>
               <div class="item form-group">
                  <label class="col-md-3 col-sm-3 col-xs-12" for="img"></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <div id="uploaded_image_Add"></div>
                  </div>
               </div>
               <?php if(!empty($jobcard_material)){
      ?>
                  <div class="item form-group">
                     <label class="col-md-3 col-sm-3 col-xs-12" for="proof"></label>
                     <div class="col-md-6">
                        <?php    if(!empty($jobcard_material->featured_image)){
      echo '
      <div class="col-md-55">
         <div class="image view view-first">
            <div id="uploaded_image"><img style="width: 100%; display: block;" src="'.base_url().'assets/modules/inventory/uploads/'.$jobcard_material->featured_image.'" alt="image" class="undo" id="uploaded_image"/></div>
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
                  <label class="col-md-3 col-sm-3 col-xs-12" for="proof">Material Image </label>
                  <div class="col-md-6 col-sm-6 col-xs-12 ">
                     <input type="file" class="form-control col-md-7 col-xs-12" name="materialImage[]"> </div>
                  <button class="btn btn-warning add_images" type="button"><i class="fa fa-plus"></i></button>
               </div>
               <div class="item form-group image_box"> </div>
               <?php if(!empty($imageUpload)){ ?>
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
                     <?php /* if((!empty($materials) && $materials->save_status == 0) || empty($materials) ){
						echo '<input type="submit" class="btn edit-end-btn draftBtn1" value="Save as draft">';
						} */ ?>
                        <input type="submit" class="btn btn-warning signUpBtn add_mat_btn_submit" value="submit">
                        <button type="button" class="btn btn-default close_modal2" onclick="location.href='<?php echo base_url();?>production/bom_routing'">Close</button>
                  </center>
               </div>
            </div>
         </div>
         </div>



				<!-- Save Material Function -->
		<div id="Address2" class="tab-pane fade " style="padding:20px;">
	          <!--job card details-->
			    <input type="hidden" name="id" value="<?php if(!empty($JobCard)) echo $JobCard->id; ?>">
				  <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">
				  <input type="hidden" name="save_status" value="1" class="save_status">
				  <?php
				  if(empty($JobCard)){
				  ?>
					 <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>">
					 <?php }else{ ?>
						<input type="hidden" name="created_by" value="<?php if($JobCard && !empty($JobCard)){ echo $JobCard->created_by;} ?>">
						<?php } ?>
				   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
					  <div class="item form-group">
						 <label class="col-md-3 col-sm-3 col-xs-12" for="card_no">BOM Routing No<span class="required">*</span> </label>
						 <div class="col-md-6 col-sm-6 col-xs-12">
							<!--<input id="job_card_no" class="form-control col-md-7 col-xs-12" name="job_card_no" placeholder="JC0487" required="required" type="text" value="<?php //if(!empty($JobCard)) echo $JobCard->job_card_no; else{ echo $jobCode;} ?>" readonly>-->
							<input id="job_card_no" class="form-control col-md-7 col-xs-12" name="job_card_no" placeholder="JC0487" required="required" type="text" value="<?php  echo $jobCode; ?>" readonly> </div>
					  </div>
					  
					  <div class="item form-group">
						 <label class="col-md-3 col-sm-3 col-xs-12" for="party_name">BOM Routing Product Name<span class="required">*</span></label>
						 <div class="col-md-6 col-sm-6 col-xs-12">
						<?php 
							if(empty($jobcard_material->material_name)){
						?>	
							<input class="form-control col-md-7 col-xs-12" name="job_card_product_name" placeholder="Job Card Product Name" required="required" type="text" value="<?php if(!empty($JobCard)) echo $JobCard->job_card_product_name; ?>">
							<?php } else{ ?>
							<input class="form-control col-md-7 col-xs-12" name="job_card_product_name" placeholder="Job Card Product Name" required="required" type="text" value="<?php if(!empty($jobcard_material->material_name)) echo $jobcard_material->material_name; ?>">

							
							<?php } ?>

							</div>
					  </div>
					  <div class="item form-group">
						 <label class="col-md-3 col-sm-3 col-xs-12" for="party_name">Party Code</label>
						 <div class="col-md-6 col-sm-6 col-xs-12">
							<input class="form-control col-md-7 col-xs-12" name="party_code" placeholder="party code" type="text" value="<?php if(!empty($JobCard)) echo $JobCard->party_code; ?>"> </div>
					  </div>
					  <div class="item form-group">
						 <label class="col-md-3 col-sm-3 col-xs-12" for="requirement">Party Requirements</label>
						 <div class="col-md-6 col-sm-6 col-xs-12">
							<textarea id="party_requirement" class="form-control col-md-7 col-xs-12" name="party_requirement" placeholder="party requirement">
							   <?php if(!empty($JobCard)) echo $JobCard->party_requirement; ?>
							</textarea>
						 </div>
					  </div>
				   </div>
               <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                  <div class="item form-group">
                     <label class="col-md-3 col-sm-3 col-xs-12" for="usedproduct">Product Specification</label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea id="product_specification" class="form-control col-md-7 col-xs-12" name="product_specification" placeholder="Enter Product Specification detail.....">
                           <?php if(!empty($JobCard)) echo $JobCard->product_specification; ?>
                        </textarea>
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-md-3 col-sm-3 col-xs-12" for="certification">Test Certification</label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea id="certification" name="test_certificate" class="form-control col-md-7 col-xs-12" placeholder="Required/Not required">
                           <?php if(!empty($JobCard)) echo $JobCard->test_certificate; ?>
                        </textarea>
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-md-3 col-sm-3 col-xs-12" for="lot">Lot Quantity</label>
                     <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" id="lot" name="lot_qty" class="form-control col-md-7 col-xs-12" placeholder="" value="<?php if(!empty($JobCard)) echo $JobCard->lot_qty; ?>" onkeypress="return float_validation(event, this.value)"> </div>
                     <div class="col-md-3 col-sm-6 col-xs-12">
                        <!--<select class="form-control uom" name="lot_uom" id="uom">
               <option>Select UOM</option>
               <?php $checked ='';
                  $uom = getUom();
                  foreach($uom as $unit) {

                  if((!empty($JobCard)) && ($JobCard->lot_uom == $unit)){ $checked = 'selected';}else{$checked = '';  }
                  echo "<option value='".$unit."' ".$checked.">".$unit."</option>";
                  }
                  ?>
               </select> -->
               <?php if(!empty($jobcard_material->uom)){ ?>
                        <select class=" selectAjaxOption select2 form-control" name="lot_uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" data-where="created_by_cid = <?php  echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0 AND active_inactive = 1" disabled>
                           <option value="">Select Option</option>
                           <?php                           
                           $material_type_id = getNameById('uom',$jobcard_material->uom,'id');
                           echo '<option value="'.$jobcard_material->uom.'"selected>'.$material_type_id->uom_quantity.'</option>'; 
                        ?>
                        </select>
               <?php } else { ?>
                  <select class=" selectAjaxOption select2 form-control" name="lot_uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" data-where="created_by_cid = <?php  echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0 AND active_inactive = 1">
                           <option value="">Select Option</option>
                           <?php                           
                           if(!empty($JobCard)){
                        $lotuom = getNameById('uom',$JobCard->lot_uom,'id');
                        echo '<option value="'.$lotuom->id.'" selected>'.$lotuom->uom_quantity.'</option>';
                               }
                        ?>
                        </select>
              <?php  } ?>
                     </div>
                  </div>
               </div>
               <hr>
               <div class="bottom-bdr"></div>
               <h3 class="Material-head">
				  Material Details
				  <span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span>
				  <hr>
			   </h3>
               <div class="col-md-6 col-sm-12 col-xs-12 vertical-border"></div>
               <div class="item form-group ">
                  <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
                     <div class="item form-group">
                        <table class="input_holder table table-bordered" style="width: 100%;border: 1px solid #c1c1c1;">
                           <tr>
                               <th><label>Material Type</label></th>
                               <th> <label>Material Name</label></th>
                               <th><label>Quantity</label></th>
                               <th><label>UOM</label></th>
                               <th><label>Price</label></th>
                               <th><label >Total</label></th>
                               <th><label>Sub-BOM</label></th>
                                 <th><label>Action</label></th>
                           </tr>
                           <?php if(empty($JobCard)){  ?>
                              <tr class="jc_well first_index" id="chkIndex_1">
                                 <td>
                                    <div style="display: flex;">
                                    <div class="expand_dropwon form-group">
                                 <span class="up_arrow" style="display: none;"><i style="font-size: 20px;font-weight: bold;"  onclick="expandBom(event,this);" jc_number="" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span><span style="display: none;" class="down_arrow"><i onclick="expandBom(event,this);" jc_number="" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                    </div>
                                    <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
                                       <option value="">Select Option</option>
                                       <?php
                                       if(!empty($JobCard)){
                                          $material_type_id = getNameById('material_type',$JobCard->material_type_id,'id');
                                          echo '<option value="'.$JobCard->material_type_id.'" selected>'.$material_type_id->name.'</option>';
                                          }
                                       ?>
                                    </select>
                                 </div>
                                 </td>
                                 <td>
                                   
                                    <select class="materialNameId_chkIndex_1 materialNameId  form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_name[]" onchange="getUom(event,this); getsubBom(event,this);" id="mat_name">
                                       <option value="">Select Option</option>
                                       <input type="hidden" name="mat_idd_name" id="matrial_Iddd">
                                  <input type="hidden" name="matrial_name" id="matrial_name">
                                 <input type="hidden" id="serchd_val">
                                    </select>
                                 </td>
                                 <input type="hidden" name="dmdata[]" class="dmdata" value="">
                                 <td>
                                    
                                    <input type="text" name="quantity[]" id="material_qty" class="material_qty_chkIndex_1 form-control col-md-7 col-xs-12  qty actual_qty keyup_event" placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"> </td>







                                   <td>
                                    
                                    <input type="text" name="uom_value1[]" class="form-control col-md-7 col-xs-12  uom" placeholder="uom." value="" >
                                    <input type="hidden" name="uom_value[]" class="uomid" readonly value="">
                                 </td>
                            <!--    <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                    <label>Qty Including Scrap</label>
                                    <input type="text" name="qtyincludescrap[]" class="form-control col-md-7 col-xs-12 qtyincludescrap " placeholder="Qty Including Scrap." readonly="readonly">

                                 </div> -->
                                  <td>
                                    
                                    <input type="text" name="price[]" class="form-control col-md-7 col-xs-12 priceValue" placeholder="Price" value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"> </td>
                                 <td>
                                    
                                    <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="total[]" class="form-control col-md-7 col-xs-12  total" placeholder="Total Amount" value="" readonly> </td>
                               <td>
                              
                              <input style="border-right: 1px solid #c1c1c1 !important;" type="text" id="sub_bom" class="form-control col-md-7 col-xs-12  total" placeholder="Sub-BOM" value="" readonly> 
                              </td>  

                              </tr>
                              <!--div class="col-sm-12 btn-row">
                                 <div class="input-group-append">
                                    <button class="btn edit-end-btn addmaterial" type="button">Add</button>
                                 </div>
                              </div-->
                              <?php }
                  else{
                  if(!empty($JobCard) && $JobCard->material_details !=''){
                  $material_info = json_decode($JobCard->material_details);

                  if(!empty($material_info)){

                  $i =1;
                  $m_total_sum = 0;
                     foreach($material_info as $materialInfo){
                     $material_id = $materialInfo->material_name_id;
                     $materialName = getNameById('material',$material_id,'id');

                  ?>
                                 <tr class="jc_well first_index" style="border-top: 1px solid #c1c1c1 !important;" id="chkIndex_<?php echo $i; ?>">
                                    <td>
                                       <div style="display: flex;">
                                       <div class="expand_dropwon form-group">
                                    <?php 
                                    $material_data = getNameById('material', $materialInfo->material_name_id,'id');
                                    $job_data = getNameById('job_card', $material_data->job_card,'id');
                                    if(!empty($material_data) && $material_data->job_card!=0 && !empty($job_data)){ ?>
                                     <span class="up_arrow" style="display: none;"><i style="font-size: 20px;font-weight: bold;"  onclick="expandBom(event,this);" jc_exqty='1' jc_number="<?php echo $job_data->job_card_no;  ?>" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span><span class="down_arrow"><i onclick="expandBom(event,this);" jc_exqty='1' jc_number="<?php echo $job_data->job_card_no;  ?>" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                    <?php } else { ?>
                                    <span class="up_arrow" style="display: none;"><i style="font-size: 20px;font-weight: bold;"  onclick="expandBom(event,this);" jc_exqty='1' jc_number="<?php echo $job_data->job_card_no;  ?>" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span><span class="down_arrow" style="display: none;"><i onclick="expandBom(event,this);" jc_exqty='1' jc_number="<?php echo $job_data->job_card_no;  ?>" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                    <?php } ?> 
                                    </div>
                                       <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
                                          <option value="">Select Option</option>
                                          <?php
                           if(!empty($materialInfo) && isset($materialInfo->material_type_id)){
                              $material_type_id = getNameById('material_type',$materialInfo->material_type_id,'id');
                              echo '<option value="'.$materialInfo->material_type_id.'" selected>'.$material_type_id->name.'</option>';
                           }
                           ?>
                                       </select>
                                       </div>
                                    </td>
                                    <td>
                                       
                                       <select class="materialNameId_chkIndex_<?php echo $i; ?> materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_name[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $JobCard->material_type_id;?>  AND status=1" onchange="getUom(event,this); getsubBom(event,this);">
                                          <option value="">Select Option</option>
                                          <?php
                           echo '<option value="'.$materialInfo->material_name_id.'" selected>'.$materialName->material_name.'</option>';
                           ?>
                                       </select>
                                    </td>
                                    <td>
                                       
                                       <input type="number" name="quantity[]" id="material_qty" class="material_qty_chkIndex_<?php echo $i; ?> form-control col-md-7 col-xs-12 qty actual_qty" placeholder="Enter Quantity" value="<?php if(!empty($JobCard)) echo $materialInfo->quantity; ?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"> </td>
                                    <td>
                                       
                                       <?php
                                        $ww =  getNameById('uom', $materialInfo->unit,'id');
                                            $uom = !empty($ww)?$ww->uom_quantity:'';//$ww->ugc_code:'';
                                                 ?>
                                          <input type="text" name="uom_value1[]" class="form-control col-md-7 col-xs-12  uom" placeholder="uom." value="<?php echo $uom; ?>" >
                                          <input type="hidden" name="uom_value[]" class="uomid" readonly value="<?php if(!empty($JobCard)) echo $materialInfo->unit; ?>">
                                       </td>


<!--

                                 <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                    <label>Qty Including Scrap</label>
                                    <input type="text" name="qtyincludescrap[]" class="form-control col-md-7 col-xs-12 qtyincludescrap" placeholder="Qty Including Scrap." value="<?php if(!empty($JobCard)) echo $materialInfo->qtyincludescrap; ?>" readonly>

                                 </div> -->


                                    <td>
                                       
                                       <input type="text" name="price[]" class="form-control col-md-7 col-xs-12 priceValue" placeholder="Price" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" value="<?php if(!empty($JobCard)){ echo $materialInfo->price; }?>" onkeypress="return float_validation(event, this.value)"> </td>
                                    <td>
                                      
                                       <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="total[]" class="form-control col-md-7 col-xs-12  total" placeholder="Total Amount" value="<?php if(!empty($JobCard)){ echo $materialInfo->total; $m_total_sum += (int)$materialInfo->total; }?>" readonly> </td>
                                    <td>
                                      
                                       <?php
                                      $material_data = getNameById('material', $materialInfo->material_name_id,'id');
                                      $job_data = getNameById('job_card', $material_data->job_card,'id');
                                       ?>
                                       <input style="border-right: 1px solid #c1c1c1 !important;" type="text" id="sub_bom" class="form-control col-md-7 col-xs-12  total" placeholder="Sub-BOM" value="<?php if(!empty($material_data) && $material_data->job_card!=0 && !empty($job_data)){
                                         echo $job_data->job_card_no;
                                       } else {  echo "N/A";  } ?>" readonly> </td>
                                       <td><?php if($i != 1){ ?><button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button><?php } ?></td>
                                    
                                 </tr>
                                

                                 <?php
                  $i++;
                        }}}}?>
                         <div class="col-sm-12 btn-row" style="bottom: 44px;">
                                    <button class="btn edit-end-btn  addmaterial" type="button">Add</button>
                                 </div>
                        </table>
                        <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
                           <div class="col-md-5 col-sm-5 col-xs-12 text-right" style="float: right;">
                              <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 17px;color: #2C3A61; border-bottom: 1px solid #2C3A61;font-weight: normal; padding-bottom: 10px;">
                                 <label class="col-md-5 col-sm-12 col-xs-12" for="total">Material Costing :</label>
                                 <div class="col-md-6 col-sm-12 col-xs-12 text-left">
                                    <input disabled type="text" id="material_costing" name="material_costing" class="form-control col-md-7 col-xs-12" placeholder="material_costing" value="<?php if(!empty($JobCard) && !empty($JobCard->lot_qty)){ echo $m_total_sum/$JobCard->lot_qty; //echo $JobCard->material_costing; 
                                    }?>"> </div>
                              </div>
                           </div>     
                        </div>
                     </div>
                  </div>
               </div>


































    <div class="bottom-bdr"></div>
               <?php /*
               <h3 class="Material-head">Scrap Details<span id="scrap_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span><hr></h3>
               <div class="col-md-6 col-sm-12 col-xs-12 vertical-border"></div> 
               <div class="item form-group assembly_scrap" >
                  <div class="col-md-12 col-sm-12 col-xs-12 scrap_input_fields_wrap">
                     <div class="item form-group">

                        <div class="col-md-12 input_scrap_holder middle-box">
                           <?php  if(empty($JobCard)){  ?>
                              <div class="well firstScrapIndex" id="chkScrapIndex_1" style=" overflow:auto;">
                              	<div class="col-md-4 col-sm-12 col-xs-12 form-group"> <label>Select Scrap Type</label>
                                    <select class="form-control" name="scrap_typeinpre[]" id="scrap_typeinpre">
                                       <option value="">Select Scrap Type</option>
                                       <option value="assembly_scrap">Assembly Scrap </option>
                                       <option value="component_scrap">Component Scrap</option>
                                       <option value="operating_scrap">Operating Scrap</option>
                                    </select>
                                 </div>


                                 <div class="col-md-8 col-sm-12 col-xs-12 form-group" id="assembly_scrap" style="display: block;">
                                    <label style="border-right: 1px solid #c1c1c1 !important;"> Scrap (%)</label>
                                    <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="assembly_scrap_value[]" id="" class="form-control col-md-7 col-xs-12 operating_screp"  placeholder=" Scrap (%)." value="">

                                 </div>

                               <div class="col-md-8 col-sm-12 col-xs-12 form-group " id="operating_scrap" style="display: none;">
                                 <label style="border-right: 1px solid #c1c1c1 !important;"> Process   </label>
                                <input style="border-right: 1px solid #c1c1c1 !important;" type="text"    class="form-control col-md-7 col-xs-12 process_name"  placeholder="Please Select Product Name  " readonly>
                            </div>
                               <div id="scrapProcessBy"></div>

                             <div class="col-md-8 col-sm-12 col-xs-12 form-group " id="component_scrap" style="display: none;">
                                 <div class="col-md-6 col-sm-12 col-xs-12 form-group " >
                                  <label>Material Name</label>
                                  <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="scrap_material_name[]" onchange="getUom(event,this);" id="mat_name">
                                 <option value="">Select Option</option>
                                  </select>
                                 </div>

                                 <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label style="border-right: 1px solid #c1c1c1 !important;"> Scrap (%)</label>
                                    <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="component_scrap[]" id="component_scrap" class="form-control col-md-7 col-xs-12 component_scrap"  placeholder=" Component Scrap (%)." value="">

                                 </div>
                              </div>
                                   </div>
                                    <div class="col-sm-12 btn-row">
                                 <div class="input-group-append">
                                    <button class="btn edit-end-btn addScrapButtonn" type="button">Add</button>
                                 </div>
                              </div>
                          <?php }else{  ?>
                               <?php  if(!empty($JobCard) && $JobCard->assembly_scrap !=''){

                                          $assembly_scrap = json_decode($JobCard->assembly_scrap);
                                        if(!empty($assembly_scrap)){
                                             $i =1;

                                             foreach($assembly_scrap as $assembly_scrapsasa){

                                             $material_id = $materialInfo->material_name_id;
                                                $materialName = getNameById('material',$material_id,'id');
                              ?>
                                 <div class="well <?php if($i==1){ echo 'edit-row1 firstScrapIndex';}else{ echo 'scend-tr mobile-view';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkScrapIndex_<?php echo $i; ?>">


                                 	<div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                 		<label>Select Scrap Type</label>
                                     <select class="form-control" name="scrap_typeinpre[]" id="scrap_typeinpre">
                                       <option value="">Select Scrap Type</option>
                                       <option  <?php  if($assembly_scrapsasa->assembly_scrap_select == 'assembly_scrap_select'){ echo 'selected'; } else {  echo '';  }     ?> value="assembly_scrap">Assembly Scrap </option>
                                        <option <?php  if($material_info->scrap_typeinpre == 'component_scrap'){ echo 'selected'; } else {  echo '';  }     ?> value="component_scrap">Component Scrap</option>
                                       <option <?php  if($material_info->scrap_typeinpre == 'operating_scrap'){ echo 'selected'; } else {  echo '';  }     ?> value="operating_scrap">Operating Scrap</option>

                                    </select>
                                 </div>
                                <div class="col-md-8 col-sm-12 col-xs-12 form-group" id="assembly_scrap" style="display: block;">
                                    <label style="border-right: 1px solid #c1c1c1 !important;"> Scrap (%)</label>
                                    <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="assembly_scrap_value[]" id="" class="form-control col-md-7 col-xs-12 operating_screp"  placeholder=" Scrap (%)." value="<?php if(!empty($assembly_scrapsasa)){ echo $assembly_scrapsasa->assembly_scrap_value; }?>">
                                   </div>
                                  <button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>
                                 </div>
 <?php   $i++;  }  }  } ?>
                                  <?php  if(!empty($JobCard) && $JobCard->component_scrap !=''){
                                             $component_scrap = json_decode($JobCard->component_scrap);
                                             if(!empty($component_scrap)){
                                             $js =1;
                                              foreach($component_scrap as $component_scrapsghdvsa){

                                             $material_id = $component_scrapsghdvsa->scrap_material_name;
                                                $materialName = getNameById('material',$material_id,'id');

                              ?>
                                 <div class="well <?php if($js==1){ echo 'edit-row1 firstScrapIndex';}else{ echo 'scend-tr mobile-view';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkScrapIndex_<?php echo $js; ?>">


                                  <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                    <label>Select Scrap Type</label>
                                     <select class="form-control" name="scrap_typeinpre[]" id="scrap_typeinpre">
                                       <option value="">Select Scrap Type</option>
                                       <option  <?php  if($assembly_scrapsasa->assembly_scrap_select == 'assembly_scrap_select'){ echo 'selected'; } else {  echo '';  }     ?> value="assembly_scrap">Assembly Scrap </option>
                                        <option <?php  if($component_scrapsghdvsa->component_scrap_select == 'component_scrap_select'){ echo 'selected'; } else {  echo '';  }     ?> value="component_scrap">Component Scrap</option>component_scrap
                                       <option <?php  if($material_info->scrap_typeinpre == 'operating_scrap'){ echo 'selected'; } else {  echo '';  }     ?> value="operating_scrap">Operating Scrap</option>

                                    </select>
                                 </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12 form-group">

                                  <div class="col-md-6 form-group">
                                <label style="border-right: 1px solid #c1c1c1 !important;"> Process Name</label>
                                 <input style="border-right: 1px solid #c1c1c1 !important;" type="text"   name="process_name[]" id="process_name" class="form-control col-md-7 col-xs-12 process_name"  placeholder="Process Name." value="<?php if(!empty($component_scrapsghdvsa)) echo $materialName->material_name; ?>" > </div>
                                 <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label style="border-right: 1px solid #c1c1c1 !important;"> Process Scrap (%)</label>
                                    <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="component_scrap[]" id="component_scrap" class="form-control col-md-7 col-xs-12 component_scrap"  placeholder=" Component Scrap (%)." value="<?php if(!empty($component_scrapsghdvsa)) echo $component_scrapsghdvsa->component_scrap; ?>">

                                 </div>

                              </div>

                                  <button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>
                                 </div>
 <?php   $js++;  }  }  } ?>  <?php  if(!empty($JobCard) && $JobCard->operating_scrap !=''){
                                             $operating_scrap = json_decode($JobCard->operating_scrap);
                                             if(!empty($operating_scrap)){
                                             $jsd =1;
                                              foreach($operating_scrap as $operating_scrapjhsjah){

                                                 $material_id = $operating_scrapjhsjah->scrap_material_name;
                                                $materialName = getNameById('material',$material_id,'id');

                              ?>
                                 <div class="well <?php if($jsd==1){ echo 'edit-row1 firstScrapIndex';}else{ echo 'scend-tr mobile-view';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkScrapIndex_<?php echo $jsd; ?>">


                                  <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                    <label>Select Scrap Type</label>
                                     <select class="form-control" name="scrap_typeinpre[]" id="scrap_typeinpre">
                                       <option value="">Select Scrap Type</option>
                                       <option  <?php  if($assembly_scrapsasa->assembly_scrap_select == 'assembly_scrap_select'){ echo 'selected'; } else {  echo '';  }     ?> value="assembly_scrap">Assembly Scrap </option>
                                        <option <?php  if($component_scrapsghdvsa->component_scrap_select == 'component_scrap_select'){ echo 'selected'; } else {  echo '';  }     ?> value="component_scrap">Component Scrap</option>component_scrap
                                       <option <?php  if($operating_scrapjhsjah->operating_scrap_select == 'operating_scrap_select'){ echo 'selected'; } else {  echo '';  }     ?> value="operating_scrap">Operating Scrap</option>

                                    </select>
                                 </div>

                                <div class="col-md-8 col-sm-12 col-xs-12 form-group " >
                                 <label style="border-right: 1px solid #c1c1c1 !important;"> Process   </label>


                               <div class="col-md-6 form-group">
                              <input style="border-right: 1px solid #c1c1c1 !important;" type="text" value="<?php if(!empty($operating_scrapjhsjah)) echo $operating_scrapjhsjah->process_name; ?>" name="process_name[]" id="process_name" class="form-control col-md-7 col-xs-12 process_name"  redonly> </div>
                            <div class="col-md-6 form-group">
                               <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="operating_scrap[]" id="operating_scrap" class="form-control col-md-7 col-xs-12 operating_scrap"    value="<?php if(!empty($operating_scrapjhsjah)) echo $operating_scrapjhsjah->operating_scrap; ?>">
                           </div>

                         </div>


                                  <button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>
                                 </div>
 <?php   $jsd++;  }  }  } ?>



                                 <div class="col-sm-12 btn-row">
                                    <button class="btn edit-end-btn  addScrapButtonn" type="button">Add</button>
                                 </div>

                             <?php } ?>
                         </div>
                     </div>
                  </div>
               </div> */ ?>

































      <a  href="javascript:void(0);" class="btn edit-end-btn continue" style="float: right;margin-top: 40px;">Continue  <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
	 </div>


	 <div id="Details2" class="tab-pane fade">
			<h3 class="Material-head">Process Details<hr></h3>
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                  <div class="item form-group">
                     <label class="col-md-3 col-sm-12 col-xs-12" for="product detail">Product Name<span class="required">*</span></label>
                     <div class="col-md-6 col-sm-12 col-xs-12">
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible processType_id select2" name="process_type" data-id="process_type" data-key="id" data-fieldname="process_type" tabindex="-1" aria-hidden="true" onchange="getProcess(event,this)" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
                           <option value="">Select Option</option>
                           <?php  if(!empty($JobCard) && $JobCard->process_type !=''){
                  $processType = getNameById('process_type',$JobCard->process_type,'id');
                  echo '<option value="'.$JobCard->process_type.'" selected>'.$processType->process_type.'</option>';
                  }
                  ?>
                        </select>
                     </div>
                  </div>
               </div>


<br><br><br><br>

<!-- new routing -->

<?php if(!empty($JobCard)){ ?>

<div class="well col-container " style="display:table; clear:both; border-bottom:1px solid #c1c1c1;">
<input type="hidden" id="jobid" value="<?php if(!empty($JobCard)) echo $JobCard->id; ?>">
<div class="insert_process">
<?php
$final_process = json_decode($JobCard->final_process, true);
$Detailinfo = json_decode($JobCard->machine_details);
$j =1;
if(!empty($Detailinfo)){
foreach($Detailinfo as $detail_info){
$parmeterName = $detail_info->parameter??'';
$uom = $detail_info->uom??'';
$values = $detail_info->value??'';
$document = (!empty($detail_info->doc) && isset($detail_info->doc))?$detail_info->doc:'';
$machine_paramenters = !empty($detail_info->machine_details)?json_decode($detail_info->machine_details):'';
?>
<div class="process_set_<?php echo $detail_info->processess; ?> wellsel total_process_list <?php if($j==1){ echo 'firstIndex edit-row1';}else{ echo 'mobile-view scend-tr';}?>"  id="chckIndex_<?php echo $j; ?>" data-id="frst_div_<?php echo $j; ?>">
<input type="hidden" name="process_set_data[<?php echo $detail_info->processess; ?>]" value='<?php echo $detail_info->process_set_data; ?>' class="process_detail_set">
<div class="item form-group col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Process name</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<div class="col-md-12 col-sm-6 col-xs-12 form-group machine_name_dispaly">
<select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id select2" name="process_name[]" tabindex="-1" aria-hidden="true" onchange="getMachineName(event,this),updateInputProcess(event,this)" data-id="add_process" data-key="id" data-fieldname="process_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND process_type_id = <?php echo $JobCard->process_type;?>">
<option value="">Select Option</option>
<?php
$processName = getNameById('add_process',$detail_info->processess,'id');
echo '<option value="'.$detail_info->processess.'" selected>'.$processName->process_name.'</option>';
?>
</select>
</div>
</div>
</div>

<?php  if(!empty($machine_paramenters)){
$mach = 1;
$cc = 0;
foreach($machine_paramenters as $value){
foreach ($value->machine_id as $key => $value1) {
if($mach == 1){
?>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Setup Time</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="text" readonly="readonly" class="form-control col-md-7 col-xs-12" style="width: 33%;" placeholder="HR" value="<?php if(!empty($value->hr_set->$value1)) echo $value->hr_set->$value1; ?>">
      <select disabled="disabled" class="form-control col-md-7 col-xs-12" style="width: 33%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option value="<?php echo sprintf("%02d", $i); ?>" <?php if(!empty($value->mm_set->$value1) && $value->mm_set->$value1 == $i ) echo "selected"; ?>><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
      <select disabled="disabled" class="form-control col-md-7 col-xs-12" style="width: 34%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option <?php if(!empty($value->sec_set->$value1) && $value->sec_set->$value1 == $i ) echo "selected"; ?> value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
      <!--input type="time" name="setup_min[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 60%;" placeholder="MIN:SEC"-->
        <br>
        <br> </div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Machining Time</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="text" readonly="readonly" class="form-control col-md-7 col-xs-12" style="width: 33%;" placeholder="HR" value="<?php if(!empty($value->mt_hr_set->$value1)) echo $value->mt_hr_set->$value1; ?>">
      <select disabled="disabled" class="form-control col-md-7 col-xs-12" style="width: 33%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option value="<?php echo sprintf("%02d", $i); ?>" <?php if(!empty($value->mt_mm_set->$value1) && $value->mt_mm_set->$value1 == $i ) echo "selected"; ?>><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
      <select  disabled="disabled" class="form-control col-md-7 col-xs-12" style="width: 34%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option <?php if(!empty($value->mt_sec_set->$value1) && $value->mt_sec_set->$value1 == $i ) echo "selected"; ?> value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
        <br>
        <br> </div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Labour Cost</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input readonly="readonly" type="text"  value="<?php echo $value->per_unit_cost->$value1; ?>" class="form-control col-md-7 col-xs-12 per_unit_cost" placeholder="Per Unit Cost">
        <br>
        <br> </div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Final Process</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<input type="radio" name="final_process[<?php echo $detail_info->processess; ?>]" value="yes" class="final_process form-control col-md-7 col-xs-12" style="height: 17px;" <?php if($final_process[$detail_info->processess] == "yes"){ echo "checked=checked";} ?>>
        <br>
        <br> </div>
</div>

<?php } $mach++; $cc++; } } } else { ?>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Setup Time</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
 </div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Machining Time</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">

        <br> </div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Labour Cost</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
</div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Final Process</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<input type="radio" name="final_process[<?php echo $detail_info->processess; ?>]" value="yes" class="final_process form-control col-md-7 col-xs-12" style="height: 17px;">
        <br>
        <br> </div>
</div>
<?php } ?>

<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Action</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
<a href="javascript:void(0)" class="btn btn-edit btn-xs productionTab set_process_id" data-id="routingEdit" data-title="<?php echo $processName->process_name; ?>" data-tooltip="Edit" data-toggle="modal" id="<?php echo $JobCard->id.' ~ '.$detail_info->processess.' ~ '.$j; ?>" data-chkval="<?php echo $JobCard->id; ?>" data-index-id="<?php echo $j; ?>"><i class="fa fa-pencil"></i></a>
<?php if($j!=1){ ?>
<a href="javascript:void(0)" class="RemoveProcesstype btn-xs btn btn-delete" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
<?php } ?>
</div>
</div>
</div>

<?php $j++; } }  else {
$j = 1;
?> 
<div class="process_set_ wellsel total_process_list <?php if($j==1){ echo 'firstIndex edit-row1';}else{ echo 'mobile-view scend-tr';}?>"  id="chckIndex_<?php echo $j; ?>" data-id="frst_div_<?php echo $j; ?>">
<input type="hidden" value=""  name="process_set_data[]" class="process_detail_set">
<div class="item form-group col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Process name</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<div class="col-md-12 col-sm-6 col-xs-12 form-group machine_name_dispaly">
<select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id select2" name="process_name[]" tabindex="-1" aria-hidden="true" onchange="getMachineName(event,this),updateInputProcess(event,this)" data-id="add_process" data-key="id" data-fieldname="process_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND process_type_id = <?php echo $JobCard->process_type;?>">
<option value="">Select Option</option>
</select>
</div>
</div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Setup Time</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<input type="text" name="production_shift[]" class="form-control col-md-7 col-xs-12 production_shift" placeholder="production per Shift">
<br>
<br> </div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Machining Time</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<input type="text" name="production_shift[]" class="form-control col-md-7 col-xs-12 production_shift" placeholder="production per Shift">
<br>
<br> </div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Labour Cost</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<input type="text" name="workers[]" class="form-control col-md-7 col-xs-12 workers" placeholder="workers">
<br>
<br> </div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Final Process</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<input type="radio" name="final_process[<?php echo $detail_info->processess; ?>]" value="yes" class="final_process form-control col-md-7 col-xs-12" style="height: 17px;">
        <br>
        <br> </div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Action</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
<a style="display:none;" href="javascript:void(0)" class="btn btn-edit btn-xs productionTab set_process_id" data-id="routingEdit" data-title="" data-tooltip="Edit" data-toggle="modal" id="<?php echo $JobCard->id.' ~ '.$detail_info->processess.' ~ '.$j; ?>" data-chkval="<?php echo $JobCard->id; ?>" data-index-id="<?php echo $j; ?>"><i class="fa fa-pencil"></i></a>
<?php if($j!=1){ ?>
<a href="javascript:void(0)" class="RemoveProcesstype btn-xs btn btn-delete" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
<?php } ?>
</div>
</div>
</div>
<?php } ?>
</div>
</div> 

<?php } else { ?>
<div class="well col-container " style="display:table; clear:both; border-bottom:1px solid #c1c1c1;">
<input type="hidden" id="jobid" value="<?php if(!empty($JobCard)) echo $JobCard->id; ?>">
<div class="insert_process">
<?php 
$j = 1;
?> 
<div class="process_set_ wellsel total_process_list <?php if($j==1){ echo 'firstIndex edit-row1';}else{ echo 'mobile-view scend-tr';}?>"  id="chckIndex_<?php echo $j; ?>" data-id="frst_div_<?php echo $j; ?>">
<input type="hidden" value=""  name="process_set_data[]" class="process_detail_set">
<div class="item form-group col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Process name</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<div class="col-md-12 col-sm-6 col-xs-12 form-group machine_name_dispaly">
<select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id select2" name="process_name[]" tabindex="-1" aria-hidden="true" onchange="getMachineName(event,this),updateInputProcess(event,this)" data-id="add_process" data-key="id" data-fieldname="process_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND process_type_id = <?php echo $JobCard->process_type;?>">
<option value="">Select Option</option>
</select>
</div>
</div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Setup Time</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<input type="text" name="production_shift[]" class="form-control col-md-7 col-xs-12 production_shift" placeholder="production per Shift">
<br>
<br> </div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Machining Time</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<input type="text" name="production_shift[]" class="form-control col-md-7 col-xs-12 production_shift" placeholder="production per Shift">
<br>
<br> </div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Labour Cost</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<input type="text" name="workers[]" class="form-control col-md-7 col-xs-12 workers" placeholder="workers">
<br>
<br> </div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Final Process</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<input type="radio" name="final_process[]" value="yes" class="final_process form-control col-md-7 col-xs-12" style="height: 17px;">
        <br>
        <br> </div>
</div>
<div class="item form-group  col-md-1 col-xs-12">
<div <?php if($j==1){ echo 'class="col"'; } else { echo 'class="col1"  style="
    border: 1px solid #c1c1c1;"'; } ?> >
<label>Action</label>
</div>
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
<a style="display:none;" href="javascript:void(0)" class="btn btn-edit btn-xs productionTab set_process_id" data-id="routingEdit" data-title="" data-tooltip="Edit" data-toggle="modal" id="<?php echo $JobCard->id.' ~ '.$detail_info->processess.' ~ '.$j; ?>" data-chkval="<?php echo $JobCard->id; ?>" data-index-id="<?php echo $j; ?>"><i class="fa fa-pencil"></i></a>
<?php if($j!=1){ ?>
<a href="javascript:void(0)" class="RemoveProcesstype btn-xs btn btn-delete" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
<?php } ?>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="item form-group" style="right: 0; position: absolute; margin-top: 1%;">
<button class="btn edit-end-btn  addProcesstype" style="margin-top: 1%;float: right;" type="button"><i class="fa fa-plus"></i></button>
</div></div>








    <!-- old routing -->
<br><br><br><br>




   <?php /*
	        <div class="item form-group ">
                  <h3 class="Material-head">
                  Material Linked with BOM
                  <hr>
               </h3>
                  <div class="col-md-8 col-sm-12 col-xs-12 input_fields_wrap11">
                     <div class="item form-group">
                        <div class="col-md-6 input_holder11 middle-box">
                           <?php  if(empty($JobCard)){  ?>
                              <div class="well " id="chkIndex_1">
                                 <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label>Material Type</label>
                                    <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="material_type_id11[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
                                       <option value="">Select Option</option>
                                    </select>
                                 </div>
                                 <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label>Material Name</label>
                                    <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_name11[]" id="mat_name">
                                       <option value="">Select Option</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-12 btn-row">
                                 <div class="input-group-append">
                                    <button class="btn edit-end-btn addmaterial11" type="button">Add</button>
                                 </div>
                              </div>
                              <?php }
                  else{
                  if(!empty($JobCard) && $JobCard->linked_material_details !=''){
                  $material_info = json_decode($JobCard->linked_material_details);

                  if(!empty($material_info)){

                  $i =1;
                     foreach($material_info as $materialInfo){
                     $material_id = $materialInfo->material_name_id;
                     $materialName = getNameById('material',$material_id,'id');

                  ?>
                                 <div class="well <?php if($i==1){ echo 'edit-row1';}else{ echo 'scend-tr mobile-view';}?>" style="border-top: 1px solid #c1c1c1 !important;" id="chkIndex_<?php echo $i; ?>">
                                    <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                       <label>Material Type</label>
                                       <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="material_type_id11[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
                                          <option value="">Select Option</option>
                                          <?php
                           if(!empty($materialInfo) && isset($materialInfo->material_type_id)){
                              $material_type_id = getNameById('material_type',$materialInfo->material_type_id,'id');
                              echo '<option value="'.$materialInfo->material_type_id.'" selected>'.$material_type_id->name.'</option>';
                           }
                           ?>
                                       </select>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                       <label>Material Name</label>
                                       <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_name11[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $JobCard->material_type_id;?>  AND status=1">
                                          <option value="">Select Option</option>
                                          <?php
                           echo '<option value="'.$materialInfo->material_name_id.'" selected>'.$materialName->material_name.'</option>';
                           ?>
                                       </select>
                                    </div>
                                    <button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>
                                 </div>
                                 <div class="col-sm-12 btn-row">
                                    <button class="btn edit-end-btn  addmaterial11" type="button">Add</button>
                                 </div>
                                 <!--</?php if($i==1){
                  echo '<div class="col-sm-12 btn-row"><button class="btn edit-end-btn  addmaterial" type="button">Add</button></div>';
                     }else{
                  echo '<button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>';
                  } ?>-->
                                 <?php
                  $i++;
                        }}}}?>
                        </div>
                     </div>
                  </div>
               </div> */ ?>
	       <div class="form-group">
                  <div class="col-md-12 col-xs-12">
                     <center>
						<button type="button" class="btn edit-end-btn back" ><i class="fa fa-arrow-left" aria-hidden="true"></i>  Go Back</button>
                        <!--button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button-->
                        <button type="reset" class="btn edit-end-btn ">Reset</button>
                        <?php if((!empty($JobCard) && $JobCard->save_status !=1) || empty($JobCard)){
               echo '<input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft">';
               }?>
                           <button id="send" type="submit" class="btn edit-end-btn __formSubmit">Submit</button>
                     </center>
                  </div>
               </div>
</div>
	  </div>

</div>

</form>
</div>





   <!--------------Quick add material code original----------------------->





   <!--  Add Lot Management Code Start HEre -->
     <div class="modal left fade" id="myModal_lotdetails" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel">Add Lot Details</h4> <span id="mssg343"></span> </div>
                           <form name="insert_party_data" name="ins" id="insert_Matrial_data_id33">
                              <div class="modal-body">
                                 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                                    <label class="control-label col-md-10 col-sm-10 col-xs-12" for="name">Lot No.<span class="required">*</span></label>
                                    <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                                       <input type="text" id="lotno" name="material_name" required="required" class="form-control col-md-7 col-xs-12" value=""> <span class="spanLeft control-label"></span> </div>
                                 </div>

                                 <input type="hidden" name="material_type_id" id="material_type_id22" class="form-control" value="">
                                 <input type="hidden" name="material_name_id" id="material_name_id">

								 <span class="spanLeft control-label"></span>

                                 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                                    <label class="control-label col-md-10 col-sm-10 col-xs-12" for="email">MOU Price</label>
                                    <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                                       <input type="text" id="mou_price" name="hsn_code" class="form-control col-md-7 col-xs-12" value=""> <span class="spanLeft control-label"></span> </div>
                                 </div>
                                 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                                    <label class="control-label col-md-10 col-sm-10 col-xs-12" for="email">MRP Price</label>
                                    <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                                       <input type="text" id="mrp_price" name="hsn_code" class="form-control col-md-7 col-xs-12" value=""> <span class="spanLeft control-label"></span> </div>
                                 </div>
                                 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                                    <label class="control-label col-md-10 col-sm-10 col-xs-12" for="email">Date</label>
                                    <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                                       <input type="date" name="date" id="" class="form-control col-md-7 col-xs-12 req_date" value=""> </div>
                                 </div>
                              </div>
                              <div class="modal-footer">
                                 <input type="hidden" id="add_matrial_Data_onthe_spot">
                                 <button type="button" class="btn btn-default close_sec_model">Close</button>
                                 <button id="Add_lot_details_on_button_click_mrn" type="button" class="btn edit-end-btn ">Submit</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
   <!--  Add Lot Management Code Start HEre*/-->
  <!-------------fetaured image upload used crop method---------------------->
<div id="imageModalUpload" class="modal modal1" role="dialog" style="position:fixed !important;">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss-modal="modal" id="closemodal">&times;</button>
            <h4 class="modal-title">Upload & Crop Image</h4> </div>
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


<div class="modal left fade" id="myModal_Add_matrial_details" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Material Details</h4>
            <span id="mssg34"></span>
         </div>
         <form name="insert_party_data" name="ins"  id="insert_Matrial_data_id">
            <div class="modal-body">
			   <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-4 col-sm-4 col-xs-4" for="name">Material Type <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                    <select class="selectAjaxOption select2 form-control" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" width="100%" id="material_type_idQadd" data-where="created_by_cid = <?php 	echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0">
                        <option value="">Select Option</option>

                     </select>
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="name">Material Name  <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="material_namebb" name="material_name" required="required" class="form-control col-md-7 col-xs-12" value="">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <input type="hidden" name="material_type_id" id="material_type_id"  class="form-control" value="">
               <input type="hidden" name="prefix"  id="prefix">
               <span class="spanLeft control-label"></span>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">HSN Code </label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="hsn_codet" name="hsn_code" class="form-control col-md-7 col-xs-12" value="" >
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">UOM</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="uom selectAjaxOption select2 form-control" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php   echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0 AND active_inactive = 1" tabindex="-1" aria-hidden="true">
                        <option value="">Select Option</option>
                     </select>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-12 col-sm-2 col-xs-4" for="gstin">Opening Balance</label>
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
               <button type="button" class="btn btn-default close_sec_modelMateriyas" >Close</button>
               <button id="Add_matrial_details_on_button_click_purchase" type="button" class="btn edit-end-btn ">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div id="production_modal_edit" class="modal fade in"  role="dialog" >
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content" style="display:table;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">BOM Routing Edit</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>