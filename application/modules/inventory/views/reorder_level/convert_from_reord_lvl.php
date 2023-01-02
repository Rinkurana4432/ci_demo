<?php    
   $getcompanyName = getCompanyTableId('company_detail');
   $name = $getcompanyName->name;
   $CompanyName = substr($name , 0,6);
   $last_id = getLastTableId('purchase_indent');
   $rId = $last_id + 1;
   $indentCode = ('Indent_'.rand(1, 1000000).'_'.$CompanyName.'_'.$rId);
  // pre($indents);
   ?>
<?php
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
      ?> 
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/saveIndent" enctype="multipart/form-data" id="purchaseIndentForm" novalidate="novalidate">
   <input type="hidden" name="id" value="" >  
   <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
   <?php
      if(empty($indents)){
      ?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <?php }else{ ?>   
   <input type="hidden" name="created_by" value="<?php if($indents && !empty($indents)){ echo $indents->created_by;} ?>" >
   <?php } ?>
   <input type="hidden" name="save_status" value="1" class="save_status">
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="code">Purchase Indent No.</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input id="purchase_indent" class="form-control col-md-7 col-xs-12" name="indent_code" placeholder="ABC239894" type="text" value="<?php  echo $indentCode; ?>" readonly>
         </div>
      </div>
   </div>
   
   <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
      <div class="col-md-6 col-sm-6 col-xs-12">
         <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2" required="required" name="company_unit" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
            <option value="">Select Unit</option>
         </select>
         <!--select class="form-control  select2 get_location compny_unit" required="required" name="company_branch" onChange="getDept(event,this)">
            <option value="">Select Option</option>
               <?php
               /* f(!empty($Addmachine)){
                  echo '<option value="'.$Addmachine->company_branch.'" selected>'.$Addmachine->company_branch.'</option>';
                  } */
               ?>
            </select-->
      </div>
   </div>
   </div>   
   <hr>
   <div class="bottom-bdr"></div>
   <!--<div class="heading">
      <h4>Material Details </h4>
      <div style="color:red"; class="msg1"></div>
      <div style="color:green"; class="msg2"></div>
      </div>-->
   <h3 class="Material-head" style="margin-bottom: 30px;">
      Material Details
      <hr>
   </h3>
   <!-- <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="material">Material Type <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">  
            <span class="spanLeft control-label"></span>
         </div>
      </div>
   </div> -->
   <div class=" form-group">
      <div class="item form-group ">
         <div class=" input_fields_wrap">
            <div class=" goods_descr_wrapper">
               <div class="item form-group">
                  <div class=" input_holder middle-box col-md-12" >
                     <div class="col-sm-12  col-md-12 label-box mobile-view2">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Material Type</label>
                           <label class="col-md-3 col-sm-12 col-xs-12 ">Material Name</label> 
                           <label class="col-md-1 col-sm-12 col-xs-12 ">Description</label>  
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Quantity &nbsp;&nbsp; &nbsp;UOM</label>   
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Exp. Amount</label>
                           <label class="col-md-1 col-sm-12 col-xs-12 ">Purpose</label>
                           <label class="col-md-1 col-sm-12 col-xs-12 " style="border-right: 1px solid #c1c1c1 !important;">Sub Total</label>
                        </div>
                    <?php
                        if(!empty($report_data) && $report_data->inventory_items !=''){ 
                           $product_info = json_decode($report_data->inventory_items);
                           #pre($product_info);
                           ?>
                     <div class="  col-container">
                     </div>
                     <?php
                        if(!empty($product_info)){ 
                           $i =1;


                           ?>
                        
                     <?php
                        $grand_total = 0;
                        foreach($product_info as $productInfo){
                           $grand_total += $productInfo->sub_total;
                           $material_id = $productInfo->product_name;
                           $materialid = getNameById('material',$material_id,'material_name');?>
                     <div class="well <?php if($i==1){ echo 'edit-row1 mobile-view';}else{ echo 'scend-tr mobile-view';}?>" id="chkIndex_<?php echo $i; ?>">
                        <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12">Material Type</label>
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
                              <option value="">Select Option</option>  
                               <?php
                                    if(!empty($productInfo->type)){
                                       $material_type_id1 = getNameById('material_type',$productInfo->type,'id');
                                       echo '<option value="'.$productInfo->type.'" selected>'.$material_type_id1->name.'</option>';
                                    }
                               ?> 
                           </select>                               
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Material Name</label>                     
                           <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" name="material_name[]"  data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $productInfo->type;?> AND status=1" onchange="getTax(event,this)">
                              <option value="">Select Option</option>
                              <?php echo '<option value="'.$materialid->id.'" selected>'.$productInfo->product_name.'</option>';?>
                           </select>
                           <input type="hidden" name="mat_idd_name" id="matrial_Iddd"> 
                           <input type="hidden" name="matrial_name" id="matrial_name">   
                           <input type="hidden" id="serchd_val">                                   
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Description</label>
                           <textarea id="description" name="description[]" class="form-control col-md-7 col-xs-12 description" title=""></textarea>         
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Quantity &nbsp;&nbsp; &nbsp;UOM</label>
                           <input type="text" id="quantity" name="quantity[]"  class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunc(event,this)" value="<?php if(!empty($productInfo->reorder_quantity)) echo $productInfo->reorder_quantity; ?>" placeholder="Qty."  min="0" onkeypress="return float_validation(event, this.value)">

                           <input type="text" id="uom" name="uom1[]" class="form-control col-md-7 col-xs-12 uom1" readonly value="<?php
                              $ww =  getNameById('uom', $productInfo->uom,'id');
                              $uom = !empty($ww)?$ww->ugc_code:'';
                              echo $uom;
                              ?>">
                           <input type="hidden" name="uom[]" readonly class="uom" value="<?php echo $productInfo->uom; ?>">
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Exp. Amount</label>                          
                           <input type="text" id="amount" name="expected_amount[]" class="amount form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunc(event,this)"placeholder="expected amount" value="<?php if(!empty($productInfo->expected_amount)){ echo $productInfo->expected_amount;}?>"  min="0" onkeypress="return float_validation(event, this.value)"> 
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group"> 
                           <label class="col-md-2 col-sm-12 col-xs-12">Purpose</label>
                           <textarea id="purpose"  name="purpose[]" class="form-control col-md-1" placeholder="purpose"></textarea><br><br>
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 " style="border-right: 1px solid #c1c1c1 !important;">Sub Total</label>   
                           <input style="border-right: 1px solid #c1c1c1 !important;" id="sub_total"  name="sub_total[]" class="form-control col-md-1" placeholder="sub_total" value="<?php if(!empty($productInfo->sub_total)){ echo $productInfo->sub_total;}?>"  min="0" readonly><br><br>
                        </div>
                        <button style="margin-right: 0px;" class="btn btn-danger remove_field" type="button"> <i class="fa fa-minus"></i></button>
                     </div>

                     <?php $i++;
                        }
                        } }?>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
                     <div class="col-md-5 col-sm-5 col-xs-12 text-right" style="float: right;">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 22px;color: #2C3A61; border-bottom: 1px solid #2C3A61;">
                           <label class="col-md-5 col-sm-12 col-xs-12" for="grand">Grand Total :</label>
                           <div class="col-md-6 col-sm-12 col-xs-12 text-left">
                              <input type="text" class="form-control col-md-7 col-xs-12" id="grandTot"  name="grand_total" placeholder="Grand Total" value="<?php  if(!empty($grand_total)){echo $grand_total;}  ?>"  min="0" readonly>
                              <input type="hidden" value="1" name="ifbalance" id="ifblnce">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="pref_supplier">Preffered Supplier</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select  class="prefferedSupplier form-control col-md-2 col-xs-12 selectAjaxOption select2 add_more_Supplier" id="preffered_supplier"  name="preffered_supplier" data-id="supplier" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
               <option value="">Select Supplier</option>
               
            </select>
            <input type="hidden" id="preff_supp">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="purpose">Inductor</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="inductor" name="inductor" class="form-control col-md-7 col-xs-12" value="<?php if($_SESSION['loggedInUser']) echo $_SESSION['loggedInUser']->email; ?>" readonly>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12">Department</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" name="departments"  tabindex="-1" aria-hidden="true" sssssss>
               <option value="">Select Option</option>                   
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="req_date">Expected Delivery Date<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <span class="add-on input-group-addon req-date"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
            <input type="text" id="req_date" name="required_date" class="form-control col-md-7 col-xs-12 req_date" required="required" placeholder="Required date" value="" autocomplete="off">
         </div>
        
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="material">Delivery Address</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
           
			<select class="form-control  select2  address get_state_id" name="delivery_address"  id="delivery_address">
               <option value="">Select Option</option>
               
            </select>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="specification">Specification</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea  id="specfication" name="specification" class="form-control col-md-7 col-xs-12" placeholder="Specification"></textarea>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="others">Others</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea  id="other" name="other"  class="form-control col-md-7 col-xs-12" placeholder="other"></textarea>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="proof">Document </label>
         <div class="col-md-6 col-sm-12 col-xs-12 fields_wrap" >
            <div class="col-md-9 col-sm-11 col-xs-12"style="margin-bottom: 3%;     padding-left: 0px; ">
               <input type="file" class="form-control col-md-7 col-xs-12" name="docss[]" >
            </div>
            <button class="btn edit-end-btn  add_more_docs" style="margin-bottom: 3%;" type="button">Add</button>
         </div>
      </div>
      
   </div>
   <hr>
   <div class="form-group">
      <div class="col-md-12">
         <center>
            <!--a class="btn  btn-default" onclick="location.href='<?php //echo base_url();?>purchase/purchase_indent'">Close</a-->
            <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
            <button type="reset" class="btn edit-end-btn ">Reset</button>
            
            <input type="submit" value="submit" class="btn edit-end-btn">
         </center>
      </div>
   </div>
</form>
<!--------------Quick add material code original----------------------->
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
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="name">Material Name <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="material_name" name="material_name" required="required" class="form-control col-md-7 col-xs-12" value="">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <input type="hidden" name="material_type_id" id="material_type_id"  class="form-control" value="">
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
               <button type="button" class="btn btn-default close_sec_model" >Close</button>
               <button id="Add_matrial_details_on_button_click_purchase" type="button" class="btn edit-end-btn ">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-------------------------------------------------------------------Add quick material -->
<!--------------- Quick add preffered supplier -------------------->
<div class="modal left fade" id="myModal_Add_supplier"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Supplier</h4>
            <span id="mssg"></span>
         </div>
         <form name="insert_supplier_data" name="ins"  id="insert_supplier_data_id">
            <div class="modal-body">
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="name">Supplier Name <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="suppliername" name="name" required="required" class="form-control col-md-7 col-xs-12" value="" placeholder="Supplier Name ">                     
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="name">Account Group<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible acc_group_id"  required name="supp_account_group_id" data-id="account_group" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true" ></select>
                     <span id="acc_grp_id"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="gstin">GSTIN</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="suppgstin" name="gstin" class="form-control col-md-7 col-xs-12 gstin" onblur="fnValidateGSTIN(this)" value=""   placeholder="GSTIN">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="gstin">Country <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" id='cntry' required name="country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this)"></select>
                     <span id="contry"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="gstin">State<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible state_id" name="state" required  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)"></select>
                     <span id="state1"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="gstin">City<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible city_id" name="city" required width="100%" tabindex="-1" aria-hidden="true"></select>
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
               <button type="button" class="btn btn-default close_sec_model" >Close</button>
               <button id="add_suplier_btn_id" type="button" class="btn edit-end-btn">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>
<script>
   var measurementUnits = <?php echo json_encode(getUom()); ?>;      
</script>
<!-- /page content -->