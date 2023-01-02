<?php
   $last_id = getLastTableId('purchase_order');
   $rId = $last_id + 1;
   $poCode = 'PUR_' . rand(1, 1000000) . '_' . $rId;
     
   
   // pre();
   // die();
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   ?>
<form method="post" class="form-horizontal" id="purchaseIndentForm" style="padding:2%;" action="<?php echo base_url(); ?>purchase/saveOrder" enctype="multipart/form-data">
   <?php
      //pre($order);
      
      /*<input type="hidden" name="id" value="<?php if ($order) {
         echo $order->id;
         } ?>">*/?>
          <input type="hidden" name="id" value="">
   <input type="hidden" name="pi_id" value="<?php if ($poCreate && !empty($poCreate)) {
      echo $poCreate->id;
      } ?>">
   <input type="hidden" name="save_status" value="1" class="save_status">
   <input type="hidden" name="ifbalance" value="1" >
   <input type="hidden" name="convert_PI_to_PO" value="convert_po" >
   <input type="hidden" name="rfq_to_po" value="1" >
   <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
   <h3 class="Material-head" style="margin-bottom: 30px;">
      Indent details
      <hr>
   </h3>
   <?php
      if (!empty($poCreate)) {
         $newDate = date("j F , Y", strtotime($poCreate->created_date));
         ?>
   <p><br />
   <center><b>Indent Number  : </b> <?php echo $poCreate->indent_code; ?> </center>
   </p>
   <center><b>Indent Created Date : </b> <?php echo $newDate; ?> </center>
   <br />
   <?php } 
      if(empty($poCreate)){
      ?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <?php }else{ ?>   
   <input type="hidden" name="created_by" value="<?php if($poCreate && !empty($poCreate)){ echo $poCreate->created_by;} ?>" >
   <?php } ?>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="code">Purchase Order No.<span class="required">*</span>
         </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input id="Purchase_code" class="form-control col-md-7 col-xs-12" name="order_code" placeholder="ABC239894" required="required" type="text" value="<?php echo $poCode; ?>" readonly>
         </div>
      </div>
      <?php 
         //$getUnitName = getNameById('company_address',$order->company_unit,'compny_branch_id');
         // pre($poCreate);
         
         ?>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="company_unit">Company Unit<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control  select2 address select2-width-imp" required="required" name="company_unit">
               <option value="">Select Option</option>
               <?php
                  if(!empty($poCreate)){
                     $getUnitName = getNameById('company_address',$poCreate->company_unit,'compny_branch_id');
                     //pre($getUnitName);
                     echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                     }
                  ?>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">OutSource Process </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="checkbox" name="is_outsource_process" value="1" id="outsource_btn" >
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="supplier_name">Supplier Name <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="supplierName form-control col-md-2 col-xs-12 select2 commanSelect2 select2-width-imp" id="rfq_po_supplier" required="required" name="supplier_name">
               <option value="">Select Supplier</option>
               <?php
                  if (!empty($suppliername)) {
                     foreach ($suppliername as $key => $value) { ?>
               <option value="<?= $value['id'] ?>" ><?= $value['name'] ?></option>
               <?php }
                  }
                  ?>
            </select>
         </div>
         <input type="hidden" value="" id="party_billing_state_id">
         <input type="hidden" value="<?php if(!empty($poCreate)){ echo $supplier_name_id->state; } ?>" id="sale_company_state_id">
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="address">Address</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea id="address" name="address" class="form-control col-md-7 col-xs-12" placeholder="Display when supplier is selected from above"></textarea>
            <span class="spanLeft control-label"></span>
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <!--<div class="heading">
      <h4>Material Details </h4>
      </div>-->
   <h3 class="Material-head" style="margin-bottom: 30px;">
      Material Details
      <hr>
   </h3>
   <div class="form-group" style="padding-bottom: 15px;">
      <div class="item form-group">
         <div class="goods_descr_wrapper">
            <div class="item form-group">
            </div>
            <div class="col-md-12 input_material middle-box ">
      
                     <div class="col-sm-12  col-md-12 label-box mobile-view2">
                        <label class="col-md-1 col-sm-12 col-xs-12">M.Type <span class="required">*</span></label>
                        <label class="col-md-1 col-sm-12 col-xs-12">M. Name <span class="required">*</span></label>
                        <label class="col-md-2 col-sm-12 col-xs-6 totl_amt">Description</label>
                        <label class="col-md-2 col-sm-6 col-xs-6" >Quantity&nbsp;&nbsp;&nbsp; /UOM</label>
                        <label class="col-md-1 col-sm-6 col-xs-6">price</label>
                        <label class="col-md-1 col-sm-6 col-xs-12">Sub Total</label>
                        <label class="col-md-1 col-sm-6 col-xs-12">GST</label>
                        <label class="col-md-1 col-sm-6 col-xs-12">Sub Tax</label>
                        <label class="col-md-2 col-sm-6 col-xs-6 totl_amt" >Total</label>
                        <label class="col-md-1 col-sm-6 col-xs-12 show_cls" style="display:none;">BOM No</label>
                        <label class="col-md-1 col-sm-6 col-xs-12 show_cls" style="border-right: 1px solid #c1c1c1 !important;display:none;">Process </label>
                     </div>
                     <div class="appendMaterialBySupplier">
                     </div>
                    <div class="col-sm-12 btn-row"><button class="btn plus-btn   edit-end-btn addButton" type="button"  disabled >Add</button></div>
            </div>
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="payment">Payment Mode</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="payment_terms" name="payment_terms" class="form-control col-md-7 col-xs-12" placeholder="Payment Terms" value="">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="material">Delivery Address</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control  address get_state_id select2-width-imp" name="delivery_address"  id="address">
               <option value="">Select Option</option>
               <?php
                  if (!empty($poCreate)) {
                     $brnch_name = getNameById_with_cid('company_address', $poCreate->delivery_address, 'id','created_by_cid',$this->companyGroupId);
                     echo '<option value="' . $poCreate->delivery_address . '" selected   data-id="' . $poCreate->delivery_address . '">' . $brnch_name->location . '</option>';
                  }
                  ?>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="pay">Payment Date</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="delivery_date" name="payment_date" class="form-control col-md-7 col-xs-12 delivery_date"  placeholder="Payment date" value="<?php //if(!empty($order)) echo $order->payment_date;?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="expected_Del">Expected Delivery Date </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="delivery_date" name="expected_delivery_date" class="form-control col-md-7 col-xs-12 delivery_date" placeholder="Expected Delivery Date" value="<?= $getRfqData->supplier_expected_deliv_date??'' ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="date">Order Date </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="current_date" name="date" class="form-control col-md-7 col-xs-12" placeholder="Display the Current Date" value="<?php //if($order && !empty($order)){ echo $order->date;} 
               ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Choose</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <p>
               FOR:
               <input type="radio" class="flat" name="terms_delivery" id="for" value="FORPrice" checked="" required />
               EX-To be paid by customer:
               <input type="radio" class="flat" name="terms_delivery" id="exFact" value="To be paid by customer" />
            </p>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-5 col-sm-12 col-xs-12" for="textarea">Purchase Conversation Complete</label>
         <div class="col-md-7 col-sm-12 col-xs-12">
            <input type="checkbox" name="purchaseComplete" value="1" id="outsource_btn">
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group" id="freight1">
         <label class="col-md-3 col-sm-12 col-xs-12" for="freight">Freight </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="freight" name="freight" class="form-control col-md-7 col-xs-12 key-up-event" placeholder="Freight" value="<?php if($order && !empty($order)){ echo $order->freight;} ?>" onkeyup="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)"> 
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="other_charges">Other Charges (Rs)</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="other_charges" name="other_charges" class="form-control col-md-7 col-xs-12 key-up-event" placeholder="Other Charges" value="" onkeyup="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="grand">Grand Total</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" class="form-control col-md-7 col-xs-12" id="subttot" readonly name="grand_total" placeholder="Grand Total" readonly value="<?php  if(!empty($poCreate)){echo $grand_total;} ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Terms and conditions </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea id="tnc" name="terms_conditions" class="form-control col-md-7 col-xs-12" placeholder="Terms And conditons"><?php //if($order && !empty($order)){ echo $order->terms_conditions;} 
               ?></textarea>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="proof">Document </label>
         <div class="col-md-6 col-sm-12 col-xs-12 fields_wrap" >
            <div class="col-md-9 col-sm-11 col-xs-12"style="margin-bottom: 3%;     padding-left: 0px;">
               <input type="file" class="form-control col-md-7 col-xs-12" name="docss[]" >
            </div>
            <button class="btn edit-end-btn  add_more_docs" style="margin-bottom: 3%;" type="button">Add</button>
         </div>
      </div>
      <?php if(!empty($docss)){
         ?>
      <div class="item form-group">
         <label class="col-md-3 col-sm-2 col-xs-12" for="proof"></label>
         <div class="col-md-6">
            <?php
               $img = "";
               $imageExist = ['jpg','gif','jpeg','png','ico','jfif'];
               $docsExist  = ['ods','doc','docx'];
               foreach($docss as $proofs){   
                $ext = pathinfo($proofs['file_name'], PATHINFO_EXTENSION);
               if(in_array($ext,$imageExist)){
                  $img = "assets/modules/purchase/uploads/{$proofs['file_name']}";
               }else if(in_array($ext,$docsExist)){
                  $img = "assets/images/docX.png";
               }else if($ext == 'pdf'){
                  $img = "assets/images/PDF.png";
               }else if($ext == 'xlsx'){
                  $img = "assets/images/excel.png";   
               }
               if( $img )
               echo '<div  class="col-md-4"><div class="image view view-first"><a download href="'.base_url().'assets/modules/purchase/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().$img.'" alt="image" height="100" width="100"/><i class="fa fa-download"></i></a>
                  <div class="mask">
                     <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'purchase/delete_doccs/'.$proofs['id'].'/'.$indents->id.'">
                     <i class="fa fa-trash"></i>
                     </a>
                 </div></div></div>';
               } 
               ?>
         </div>
      </div>
      <?php }
         $checkedExist = false;
              if( $purchase_type ){
                 $checkedExist = true;
              }
         
           ?>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="proof">Type</label>
         <div class="col-md-6 col-sm-12 col-xs-12" >
            <div class="col-md-9 col-sm-11 col-xs-12 purchase_type" style="margin-bottom: 3%;     padding-left: 0px; ">
               <input type="radio" class="validate" name="purchase_type" value="0" <?php if($checkedExist){ if(  !$purchase_type ){ echo "checked";  } }else{ echo "checked"; } ?>  > Domestic
               <input type="radio" class="validate"  name="purchase_type" value="1" <?php  if( $purchase_type ){ echo "checked";  }  ?>> Import
            </div>
         </div>
      </div>
   </div>
   </div>
   <hr>
   <div class="form-group">
      <div class="col-md-12 ">
         <center>
            <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
            <button type="reset" class="btn edit-end-btn ">Reset</button>
            <input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">
            <button id="send" type="submit" class="btn edit-end-btn">Submit</button>
         </center>
      </div>
   </div>
</form>
<!-------------------------------------Add quick material code------------------------------->
<div class="modal left fade" id="myModal_Add_matrial_details"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Material Details</h4>
            <span id="mssg34"></span>
         </div>
         <form name="insert_party_data" name="ins" id="insert_Matrial_data_id">
            <div class="modal-body">
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Material Name <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="material_name" name="material_name" required="required" class="form-control col-md-7 col-xs-12" value="">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <!--<div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Material Type <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                  <select name="material_type_id"  width="100%" id="material_type_id" class="form-control">
                  <option value="">Select Material Type </option>
                  </select>-->
               <input type="hidden" name="material_type_id" id="material_type_id" class="form-control" value="">
               <input type="hidden" name="prefix" id="prefix">
               <span class="spanLeft control-label"></span>
               <!--</div>
                  </div>-->
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="email">HSN Code </label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="hsn_code" name="hsn_code" class="form-control col-md-7 col-xs-12" value="">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="email">UOM</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="uom selectAjaxOption select2 form-control select2-width-imp" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php   echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0 AND active_inactive = 1">
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
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">Opening Balance</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="opening_balance_Sec" name="opening_balance" class="form-control col-md-7 col-xs-12" value="">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">Specification</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <!--input type="text" id="opening_balance_Sec" name="opening_balance" class="form-control col-md-7 col-xs-12" value=""-->
                     <textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification"></textarea>
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <input type="hidden" id="add_matrial_Data_onthe_spot">
               <button type="button" class="btn btn-default close_sec_model">Close</button>
               <button id="Add_matrial_details_on_button_click" type="button" class="btn edit-end-btn">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal left fade" id="myModal_Add_supplier"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Supplier</h4>
            <span id="mssg"></span>
         </div>
         <form name="insert_supplier_data" name="ins" id="insert_supplier_data_id">
            <div class="modal-body">
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Supplier Name <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="suppliername" name="name" required="required" class="form-control col-md-7 col-xs-12" value="" placeholder="Supplier Name ">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Account Group<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible acc_group_id select2-width-imp" required name="supp_account_group_id" data-id="account_group" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true"></select>
                     <span id="acc_grp_id"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">GSTIN</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="suppgstin" name="gstin" class="form-control col-md-7 col-xs-12" value=""  placeholder="GSTIN">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">Country <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id select2-width-imp" id='cntry' required name="country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this)"></select>
                     <span id="contry"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">State<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible state_id select2-width-imp" name="state" required width="100%" tabindex="-1" aria-hidden="true" onchange="getCity(event,this)"></select>
                     <span id="state1"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">City<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible city_id select2-width-imp" name="city" required width="100%" tabindex="-1" aria-hidden="true"></select>
                     <span id="city1"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="gstin">Address<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <textarea type="text" name="address" class="form-control col-md-7 col-xs-12" placeholder="Address" rows="4" id="supplieraddress"></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default close_sec_model">Close</button>
               <button id="add_suplier_btn_id" type="button" class="btn edit-end-btn">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>