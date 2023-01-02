<style type="text/css">
   .purchase_type input {
       margin: 10px;
   }
</style>
<?php 	
 //pre($indents);die();
   $getcompanyName = getCompanyTableId('company_detail');
   $name = $getcompanyName->name;
   $CompanyName = substr($name , 0,6);
   $last_id = getLastTableId('purchase_indent'); 
   $rId = $last_id + 1;
   $indentCode = ($indents && !empty($indents))?$indents->indent_code:('Indent_'.rand(1, 1000000).'_'.$CompanyName.'_'.$rId);
  // pre($indents);
   ?>
<?php



   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   
   	?>	
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/saveIndent" enctype="multipart/form-data" id="purchaseIndentForm" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php if($indents && !empty($indents)){ echo $indents->id;} ?>" >	
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
	  <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
      <div class="col-md-6 col-sm-6 col-xs-12">
         <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 select2-width-imp" required="required" name="company_unit" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
            <option value="">Select Unit</option>
            <?php
               if(!empty($indents)){
                  $getUnitName = getNameById('company_address',$indents->company_unit,'compny_branch_id');
                  echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
               }
               ?>
         </select>
      </div>
   </div>
   </div>
    
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	<?php /* ?>   
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12">Sale Order Number</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            
            <select class="form-control dis commanSelect2 select2-width-imp" name="sale_order_id" id="sale_order_id" >
               
               <?php
               if(!empty($indents)){

                  $getUnitName = getNameById('work_order',$indents->sale_order_id,'id');
             echo '<option value="'.$getUnitName->id.'" selected>'.$getUnitName->sale_order_no.'</option>';
               }else{
                  echo $sale_order; 
               }
               ?>
            </select>
                 
         </div>
        </div>
		<?php */ ?>
		<div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="pref_supplier">Preferred Supplier <span class="required">*</span> </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select  class="prefferedSupplier form-control col-md-2 col-xs-12 select2 add_more_Supplier select2-width-imp" id="preffered_supplier" required="required"  name="preffered_supplier" data-id="supplier" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status  =1">
               <option value="">Select Supplier</option>
               <?php
                  $supplier_name_id = getNameById('supplier',$indents->preffered_supplier,'id');
                  if(!empty($indents) && $supplier_name_id !=''){
                  echo '<option value="'.$indents->preffered_supplier.'" selected>'.$supplier_name_id->name.'</option>';
                  }
                  
                  ?>	
            </select>
            <input type="hidden" id="preff_supp">
         </div>
      </div>
      
   </div>	
      <!-- <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="code">Work Order Number</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input id="work_order_id" class="form-control col-md-7 col-xs-12" name="work_order_id" placeholder="WorkOrderNo." type="text" value="" readonly>
         </div>
      </div> -->

   <hr> 
   <div class="bottom-bdr"></div>
   <h3 class="Material-head" style="margin-bottom: 30px;">
      Material Details
      <hr>
   </h3>
   <div class=" form-group">
      <div >
         <div class=" input_fields_wrap">
            <div class=" goods_descr_wrapper">
               <div >
                  <div class=" input_holder middle-box col-md-12" >
                     <?php  if(empty($indents) || (!empty($indents) && $indents->material_name =='')){ ?>
                     <div class="col-sm-12  col-md-12 label-box mobile-view2">
                        <!-- <label class="col-md-2 col-sm-12 col-xs-12 ">Material Type <span class="required">*</span></label> -->
                        <label class="col-md-2 col-sm-12 col-xs-12 ">Material Name <span class="required">*</span></label>
                        <label class="col-md-1 col-sm-12 col-xs-12 ">HSN <span class="required">*</span></label>
                        <label class="col-md-1 col-sm-12 col-xs-12 ">Alias</label>						
                        <label class="col-md-1 col-sm-12 col-xs-12 ">Img</label>						
                        <label class="col-md-2 col-sm-12 col-xs-12 ">Special Description</label>	
                        <label class="col-md-2 col-sm-12 col-xs-12 ">Quantity <span class="required">*</span> &nbsp;&nbsp; &nbsp;UOM</label>	
                        <label class="col-md-1 col-sm-12 col-xs-12 ">Exp. Amount <span class="required">*</span></label>
                        <label class="col-md-1 col-sm-12 col-xs-12 ">Purpose</label>
					
                        <label class="col-md-1 col-sm-12 col-xs-12 " style="border-right: 1px solid #c1c1c1 !important;">Sub Total</label>
                     </div>
                     <div class="well mobile-view" id="chkIndex_1" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">

                        <!-- <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12">Material Type</label>
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0 " tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
                              <option value="">Select Option</option>   
                           </select>
                        </div> -->
                        <select class="appendMaterialTypeIdByMat material_type_id" style="width:0;height: 0;position: absolute;" name="material_type_id[]">
                        </select>

                        <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12">Material Name</label>
                           <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name Add_mat_onthe_spot select2-width-imp" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)">
                              <option value="">Select Option</option>
                           </select>
                           <input type="hidden" name="mat_idd_name" id="matrial_Iddd">	
                           <input type="hidden" name="matrial_name" id="matrial_name">	  
                           <input type="hidden" id="serchd_val">	  
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">HSN</label>
                           <input name="hsnCode[]" class="form-control col-md-7 col-xs-12 hsnCode" title="<?php  echo $productInfo->hsnCode; ?>" readonly>
                           <input type="hidden" name="hsnId[]" class="form-control col-md-7 col-xs-12 hsnId" title="<?php  echo $productInfo->hsnId; ?>" readonly>
                        </div>
						<div class="col-md-1 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-1 col-sm-12 col-xs-12 ">Alias</label>
                           <input name="aliasname[]" class="form-control col-md-7 col-xs-12 aliasname " title="<?php  echo $productInfo->aliasname;?>" readonly>                          
                        </div>
						<div class="col-md-1 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-1 col-sm-12 col-xs-12 ">Img.</label>
						  <div class="MatImage col-xs-12"></div>
						  <input type="hidden" name="matimg[]" value="" class="matimgcls">
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Description</label>
                           <textarea id="description" rows="1" name="description[]" class="form-control col-md-7 col-xs-12 description" title="<?php  echo $productInfo->description; ?>"></textarea>					
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Quantity &nbsp;&nbsp; &nbsp;UOM</label>								
                           <input type="text" id="quantity" name="quantity[]" class="form-control col-md-7 col-xs-12 key-up-event checkBugget" onkeyup="keyupFunc(event,this)" placeholder="Qty."  min="0" onkeypress="return float_validation(event, this.value)" required="required">
                           <input type="text" id="uom" name="uom1[]" class="form-control col-md-7 col-xs-12 uom1" readonly>	
                           <input type="hidden" name="uom[]" readonly class="uom">											
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-6 form-group">	
                           <label class="col-md-2 col-sm-12 col-xs-12">Expected Amount</label>
                           <input type="text" id="amount" name="expected_amount[]" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunc(event,this)" placeholder="Exp Amt" min="0" onkeypress="return float_validation(event, this.value)">	
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Purpose</label>
                           <textarea id="purpose" rows="1" name="purpose[]" class="form-control col-md-1" placeholder="purpose"></textarea><br><br>
                        </div>
						<!--div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Last Purchase Price</label>
                           <input name="lastpurchaseprce[]" class="form-control col-md-7 col-xs-12 lastpurchaseprce" title="#" 
                             readonly>                           
                        </div-->
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Sub Total</label>
                           <input style="border-right: 1px solid #c1c1c1 !important;" type="text" id="sub_total"  name="sub_total[]" class="form-control col-md-1" placeholder="sub_total"  min="0" readonly><br><br>
                        </div>
                        <button style="margin-right: 0px;" class="btn btn-danger remove_field" type="button"> <i class="fa fa-minus"></i></button>
                     </div>
                     <div class="col-sm-12 btn-row"><button class="btn edit-end-btn addMorefileds" style="margin-top: 23px;"type="button">Add</button>
                     </div>
                     <?php } 
                        if(!empty($indents) && $indents->material_name !=''){ 
                        	$product_info = json_decode($indents->material_name);
                        	?>
                     <div class="  col-container">
                     </div>
                     <?php
                        if(!empty($product_info)){ 
                        	$i =1;
                        	?>
                     <div class="col-sm-12  col-md-12 label-box mobile-view2">
                        <!-- <label class="col-md-2 col-sm-12 col-xs-12 ">Material Type <span class="required">*</span></label> -->
                        <label class="col-md-2 col-sm-12 col-xs-12 ">Material Name <span class="required">*</span></label> 
                        <label class="col-md-1 col-sm-12 col-xs-12 ">HSN <span class="required">*</span></label> 
                        <label class="col-md-1 col-sm-12 col-xs-12 ">Alias</label> 
                        <label class="col-md-1 col-sm-12 col-xs-12 ">Img.</label> 
                        <label class="col-md-2 col-sm-12 col-xs-12 ">Special Description</label>  
                        <label class="col-md-2 col-sm-12 col-xs-12 ">Quantity <span class="required">*</span> &nbsp;&nbsp; &nbsp;UOM</label>   
                        <label class="col-md-1 col-sm-12 col-xs-12 ">Exp. Amount <span class="required">*</span></label>
                        <label class="col-md-1 col-sm-12 col-xs-12 ">Purpose</label>
                      
                        <label class="col-md-1 col-sm-12 col-xs-12 " style="border-right: 1px solid #c1c1c1 !important;">Sub Total</label>					 
                     </div>
                     <?php
                        foreach($product_info as $productInfo){
                        	$material_id = $productInfo->material_name_id;
                        	$materialName = getNameById('material',$material_id,'id');?>
                     <div class="well <?php if($i==1){ echo 'edit-row1 mobile-view';}else{ echo 'scend-tr mobile-view';}?>" id="chkIndex_<?php echo $i; ?>"  >
                        <!-- <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12">Material Type</label>
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
                              <option value="">Select Option</option>  
                               <?php
                                 if(!empty($productInfo->material_type_id)){
                                    $material_type_id1 = getNameById('material_type',$productInfo->material_type_id,'id');
                                    echo '<option value="'.$productInfo->material_type_id.'" selected>'.$material_type_id1->name.'</option>';
                                    }
                                 ?> 
                           </select>                               
                        </div> -->

                        <select class="appendMaterialTypeIdByMat material_type_id" style="width:0;height: 0;position: absolute;" name="material_type_id[]">
                           <option value="<?= $productInfo->material_type_id ?>" selected><?= $productInfo->material_type_id ?></option>
                        </select>

                        <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Material Name</label>							
                           <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name select2-width-imp" required="required" name="material_name[]"  data-id="material" data-key="id" data-fieldname="material_name" 
                           data-where="material_type_id = <?= $productInfo->material_type_id ?> AND created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND status=1" onchange="getTax(event,this)">
                              <option value="">Select Option</option>
                              <?php echo '<option value="'.$productInfo->material_name_id.'" selected>'.getPCode($productInfo->material_name_id).$materialName->material_name.'</option>';?>
                           </select>
                           <input type="hidden" name="mat_idd_name" id="matrial_Iddd">	
                           <input type="hidden" name="matrial_name" id="matrial_name">	  
                           <input type="hidden" id="serchd_val">	  											
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">HSN</label>
                           <input name="hsnCode[]" class="form-control col-md-7 col-xs-12 hsnCode" title="<?php  echo $productInfo->hsnCode; ?>" 
                              value="<?= $productInfo->hsnCode; ?>" readonly>
                           <input type="hidden" name="hsnId[]" class="form-control col-md-7 col-xs-12 hsnId" title="<?php  echo $productInfo->hsnId; ?>"
                           value="<?= $productInfo->hsnId; ?>" readonly>
                        </div>
						
						<div class="col-md-1 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-1 col-sm-12 col-xs-12 ">Alias</label>
                           <input name="aliasname[]" class="form-control col-md-7 col-xs-12 aliasname" value="<?php   if(!empty($indents)) echo $productInfo->aliasname; ?>" readonly>
                        </div>
						<div class="col-md-1 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-1 col-sm-12 col-xs-12 ">Img.</label>
                           <?php 
						  
						   $attachments = $this->purchase_model->get_image_by_materialId('attachments', 'rel_id', $productInfo->material_name_id);
						    if(!empty($attachments)){
							echo '<img style="width: 50px; height: 37px; margin-left: 32px;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
							}else{
								echo '<img style="width: 50px; height: 37px; margin-left:32px;" src="'.base_url().'assets/uplodimg/noimage.jpg">';
							}
						   ?>
						    <input type="hidden" class="matimgcls" name="matimg[]" value="<?php echo $attachments[0]['file_name']; ?>">
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Description</label>
                           <textarea id="description" name="description[]" class="form-control col-md-7 col-xs-12 description" title="<?php  echo $productInfo->description; ?>"><?php if(!empty($indents)) echo $productInfo->description; ?></textarea>			
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Quantity &nbsp;&nbsp; &nbsp;UOM</label>
                           <input type="text" id="quantity" name="quantity[]"  class="form-control col-md-7 col-xs-12 key-up-event checkBugget" onkeyup="keyupFunc(event,this)" value="<?php if(!empty($indents)) echo $productInfo->quantity; ?>" placeholder="Qty."  min="0" onkeypress="return float_validation(event, this.value)" required="required">
                           <input type="text" id="uom" name="uom1[]" class="form-control col-md-7 col-xs-12 uom1" readonly value="<?php
                              $ww =  getNameById('uom', $productInfo->uom,'id');
                              $uom = !empty($ww)?$ww->ugc_code:'';
                              echo $uom;
                              ?>">
                           <input type="hidden" name="uom[]" readonly class="uom" value="<?php echo $productInfo->uom; ?>">
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Exp. Amount</label>									
                           <input type="text" id="amount" name="expected_amount[]" class="amount form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunc(event,this)" placeholder="expected amount" value="<?php if(!empty($indents)) echo $productInfo->expected_amount; ?>"  min="0" onkeypress="return float_validation(event, this.value)">	
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">	
                           <label class="col-md-2 col-sm-12 col-xs-12">Purpose</label>
                           <textarea id="purpose"  name="purpose[]" class="form-control col-md-1" placeholder="purpose"><?php if(!empty($indents)) echo $productInfo->purpose; ?></textarea><br><br>
                        </div>
						<!--div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Last Purchase Price</label>
                           <input name="lastpurchaseprce[]" class="form-control col-md-7 col-xs-12 lastpurchaseprce" value ="<?php  //if(!empty($indents)) echo $productInfo->lastpurchaseprce; ?>"readonly> 
                        </div-->
						
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 " style="border-right: 1px solid #c1c1c1 !important;">Sub Total</label>	
                           <input type="text" style="border-right: 1px solid #c1c1c1 !important;" id="sub_total"  name="sub_total[]" class="form-control col-md-1"  value="<?php if(!empty($indents)) echo $productInfo->sub_total; ?>"  min="0" readonly><br><br>
                        
                        </div>
                        <button style="margin-right: 0px;" class="btn btn-danger remove_field" type="button"> <i class="fa fa-minus"></i></button>
                     </div>
                     <?php $i++;
                        }
                        }
                        } ?>
                     <div class="col-sm-12 btn-row"><button class="btn  plus-btn edit-end-btn addMorefileds" type="button">Add</button></div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
                     <div class="col-md-5 col-sm-5 col-xs-12 text-right" style="float: right;">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 22px;color: #2C3A61; border-bottom: 1px solid #2C3A61;">
                           <label class="col-md-5 col-sm-12 col-xs-12" for="grand">Grand Total :</label>
                           <div class="col-md-6 col-sm-12 col-xs-12 text-left">
                              <input type="text" class="form-control col-md-7 col-xs-12" id="grandTot"  name="grand_total" placeholder="Grand Total" id="grandTotal" value="<?php if(!empty($indents)) echo $indents->grand_total;?>"  min="0" readonly>
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
         <label class="col-md-3 col-sm-12 col-xs-12" for="purpose">Inductor</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="inductor" name="inductor" class="form-control col-md-7 col-xs-12" value="<?php if($_SESSION['loggedInUser']) echo $_SESSION['loggedInUser']->email; ?>" readonly>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12">Department</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department select2-width-imp" name="departments"  tabindex="-1" aria-hidden="true">
               <option value="">Select Option</option>
               <?php
                  if(!empty($indents)){
                  	$departmentData = getNameById('department',$indents->departments,'id');
                  	if(!empty($departmentData)){
                  		echo '<option value="'.$departmentData->id.'" selected>'.$departmentData->name.'</option>';
                  	}
                  }
                  ?>								
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="req_date">Expected Received Date<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <span class="add-on input-group-addon req-date"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
            <input type="text" id="req_date" name="required_date" class="form-control col-md-7 col-xs-12 req_date" required="required" placeholder="Received date" value="<?php if(!empty($indents)) echo $indents->required_date;?>">
         </div>
      </div>
	   <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="material">Delivery Address</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control  select2  address get_state_id select2-width-imp" name="delivery_address"  id="delivery_address">
               <option value="" required>Select Option</option>
               <?php
                  if (!empty($indents)) {
                  	$brnch_name = getNameById_with_cid('company_address', $indents->delivery_address, 'id','created_by_cid',$this->companyGroupId);
                  	echo '<option value="' . $indents->delivery_address . '" selected   data-id="' . $indents->delivery_address . '">' . $brnch_name->location . '</option>';
                  }
                  ?>
            </select>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="specification">Specification</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea  id="specfication" name="specification" class="form-control col-md-7 col-xs-12" placeholder="Specification"><?php if(!empty($indents)) echo $indents->specification;?></textarea>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="others">Others</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea  id="other" name="other"  class="form-control col-md-7 col-xs-12" placeholder="other"><?php if(!empty($indents)) echo $indents->other; ?></textarea>
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
            <?php if((!empty($indents) && $indents->save_status !=1) || empty($indents)){
               echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
               }?> 
            <input type="submit" value="submit" class="btn edit-end-btn">
         </center>
      </div>
   </div>
</form>

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
                     <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible acc_group_id select2-width-imp"  required name="supp_account_group_id" data-id="account_group" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true" ></select>
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
                     <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id select2-width-imp" id='cntry' required name="country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this)"></select>
                     <span id="contry"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="gstin">State<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible state_id select2-width-imp" name="state" required  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)"></select>
                     <span id="state1"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="gstin">City<span class="required">*</span></label>
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