<style type="text/css">
   .purchase_type input {
       margin: 10px;
   }
   .middle-box .well label {
    margin: 0px;
    padding: 8px 10px;
    text-align: center;
    border-left: 1px solid #c1c1c1;
    border-bottom: 1px solid #c1c1c1;
    background-color: #f5f5f5;
    width: 100%;
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
  // pre($indentCode);
   ?>
<?php



   $this->companyId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   
      ?> 
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveIndent" enctype="multipart/form-data" id="purchaseIndentForm" novalidate="novalidate">
    <!---------breakdown---------->
   <input type="hidden" name="save_status" value="1" class="save_status">
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">  
   <input type="hidden" name="aknowlwdge_by" value="<?php echo $_SESSION['loggedInUser']->name; ?>" >
   <input type="hidden" name="work_order_id" value="<?php echo $work_order; ?>" id="work_order_id">   
   <!------------Breakdown---------------->  
   <input type="hidden" name="id" value="<?php if($indents && !empty($indents)){ echo $indents->id;} ?>" >  
   <input type="hidden" name="logged_in_user" value="<?php echo $this->companyId; ?>" id="loggedUser">
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
         <label class="col-md-3 col-sm-12 col-xs-12" for="pref_supplier">Preferred Supplier</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
		 
		  
            <select  class="prefferedSupplier form-control col-md-2 col-xs-12 select2 add_more_Supplier selectAjaxOption" id="preffered_supplier"  name="preffered_supplier" data-id="supplier" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
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
	  <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
   <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
      <div class="col-md-6 col-sm-6 col-xs-12">
         <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2" required="required" name="company_unit" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
            <option value="">Select Unit</option>
            
         </select>
      </div>
   </div> 
   </div> 
   
   

   <hr> 
   <div class="bottom-bdr"></div>
   <h3 class="Material-head" style="margin-bottom: 30px;">
      Material Details
      <hr>
   </h3>
    <div id="div_result"> 
      <div class="item form-group ">
         <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
            <div class="item form-group">
               <div class="col-md-12 input_holder middle-box" id="div_result">
                  <?php
				
				
                  if(!empty($data_set)){
                  $data_exp = explode(',', $data_set);
                  $total = 0;
				  $i=1; 
				  $image = '';
                  foreach ($data_exp as $key => $data_value) {
					  
					 
					  
                 
                  $materialName = getNameById('material',$data_value,'id');
                  $hsnsacmaster = getNameById('hsn_sac_master',$materialName->hsn_code,'id');
				  
				  $attachments = $this->purchase_model->get_image_by_materialId('attachments', 'rel_id', $materialName->product_code);
				  
				  		    if(!empty($attachments)){
								$image = '<img style="width: 50px; height: 37px; margin-left: 32px;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
							}else{
								$image =  '<img style="width: 50px; height: 37px; margin-left:32px;" src="'.base_url().'assets/uplodimg/noimage.jpg">';
							}
				  
				   // pre($materialName);
				 
				  $material_type = $materialName->material_type_id;
                  $cost_price = $materialName->cost_price;
                  $uom = $materialName->uom;
                  $min_order = $materialName->min_order;
                  if($min_order > $mat_shotage){
                  $qty = $min_order;
                  } else {
                  $qty = $mat_shotage;   
                  }
                  $sub_total = $qty*$cost_price;
                  $total += $sub_total;
                  ?>
                  <div class="well <?php if($i==1){ echo 'edit-row1';}else{ echo 'scend-tr mobile-view';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkIndex_<?php echo $i; ?>">

                       <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                        <label>Mat. Type</label>
                         <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
                              <option value="">Select Option</option>
                             <?php 
                         $material_type_id = getNameById('material_type',$material_type,'id');
                         echo '<option value="'.$material_type.'" selected>'.$material_type_id->name.'</option>';
                           ?>
                        </select>
                       </div>

                     <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                        <label>Mat. Name</label>
                        <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_name[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>  AND status=1" onchange="getUom(event,this);">
                           <option value="">Select Option</option>
                           <?php
                              echo '<option value="'.$data_value.'" selected>'.$materialName->material_name.'</option>';
                              ?>
                        </select>
                     </div>
					 <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                        <label>HSN <span class="required">*</span></label>       
                        <input name="hsnCode[]" class="form-control col-md-7 col-xs-12 hsnCode" value="<?php echo $hsnsacmaster->hsn_sac; ?>" readonly>
					   <input type="hidden" name="hsnId[]" class="form-control col-md-7 col-xs-12 hsnId" value="<?php echo $materialName->hsn_code; ?>" readonly>
                     </div>
					 <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                        <label>Alias<span class="required">*</span></label>       
                          <input name="aliasname[]" class="form-control col-md-7 col-xs-12 aliasname " title="<?php  echo $productInfo->aliasname;?>" readonly> 
                     </div>
					 <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                        <label>Img<span class="required">*</span></label>       
                      <div class="MatImage col-xs-12"><?php echo $image; ?></div>
						  <input type="hidden" name="matimg[]" value="<?php echo $attachments[0]['file_name']; ?>" class="matimgcls">
                     </div>
                      <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                        <label>Description&nbsp;&nbsp;&nbsp;<span id="qtyMessage" style="color:red;"></span></label>       
                        <textarea id="description" name="description[]" class="form-control col-md-7 col-xs-12 description"  > </textarea>   
                     </div>
                    <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Quantity &nbsp;&nbsp;  UOM</label>
                           <input type="text" id="quantity" name="quantity[]"  class="  form-control col-md-7 col-xs-12 qty " onkeyup="keyupFunctionreorderPI(event,this)" onchange="keyupFunctionreorderPI(event,this)" onkeypress="return float_validation(event, this.value)" value="<?php echo $qty; ?>" placeholder="Qty."  min="0" required="required"> 
                            <input type="text" id="uom" name="uom1[]" class="form-control col-md-7 col-xs-12 uom" readonly value="<?php
                              $ww =  getNameById('uom', $uom,'id');
                              $uom_name = !empty($ww)?$ww->ugc_code:'';
                              echo $uom_name;
                              ?>">
                           <input type="hidden" name="uom[]" readonly class="uom1" value="<?php echo $uom; ?>">
                      </div>
                     <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                        <label>Exp. Amt<span  style="color:red;"></span></label>
                         <input type="text" id="amount" name="price[]" class="form-control col-md-7 col-xs-12 key-up-event amount" keyup="keyupFunctionreorderPI(event,this)" onchange="keyupFunctionreorderPI(event,this)" placeholder="Exp Amt" min="0" onkeypress="return float_validation(event, this.value)" value="<?php echo $cost_price; ?>">
                        
                     </div> 
                     <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                        <label>Purpose</label>
                           <textarea id="purpose" rows="1" name="purpose[]" class="form-control col-md-1" placeholder="purpose"></textarea><br><br>
                         
                     </div>
                         <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Sub Total</label>
                           <input style="border-right: 1px solid #c1c1c1 !important;" type="text" id="total"  name="total[]" class="form-control col-md-1 total" placeholder="sub_total"  min="0" value="<?php echo $sub_total; ?>" readonly><br><br>
                        </div>
                  <button style="margin-right: 0px;" class="btn btn-danger remove_field" type="button"> <i class="fa fa-minus"></i></button>
                </div>
                  <?php $i++; } }?>
                
               <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
                     <div class="col-md-5 col-sm-5 col-xs-12 text-right" style="float: right;">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 22px;color: #2C3A61; border-bottom: 1px solid #2C3A61;">
                           <label class="col-md-5 col-sm-12 col-xs-12" for="grand">Grand Total :</label>
                           <div class="col-md-6 col-sm-12 col-xs-12 text-left">
                            <input type="text" value="<?php echo $total; ?>" class="form-control col-md-7 col-xs-12"    name="grand_total" placeholder="Grand Total" id="grandTotal"  min="0" readonly>
                             
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
           <!--  <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" name="departments"  tabindex="-1" aria-hidden="true" > -->
              <select  class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" id="departments"  name="departments" data-id="department" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
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
         <label class="col-md-3 col-sm-12 col-xs-12" for="req_date">Expected Delivery Date<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <span class="add-on input-group-addon req-date"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
            <input type="text" id="req_date" name="required_date" class="form-control col-md-7 col-xs-12 req_date" required="required" placeholder="Required date" value="<?php if(!empty($indents)) echo $indents->required_date;?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="material">Delivery Address</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
           <!--  <select class="form-control  select2  address get_state_id" name="delivery_address"  id="delivery_address"> -->
              <select  class="form-control selectAjaxOption select2 select2-hidden-accessible select2  address get_state_id" id="delivery_address"  name="delivery_address" data-id="company_address" data-key="id" data-fieldname="location" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
               <option value="" required>Select Option</option>
               <?php
                  if (!empty($indents)) {
                     $brnch_name = getNameById_with_cid('company_address', $indents->delivery_address, 'id','created_by_cid',$this->companyId);
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
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="proof">Document </label>
         <div class="col-md-6 col-sm-12 col-xs-12 fields_wrap" >
            <div class="col-md-9 col-sm-11 col-xs-12"style="margin-bottom: 3%;     padding-left: 0px; ">
               <input type="file" class="form-control col-md-7 col-xs-12" name="docss[]" >
            </div>
         </div>
      </div>
      <?php
         if(!empty($docss)){
                
                  ?>
      <div class="item form-group">
         <label class="control-label col-md-3 col-sm-2 col-xs-12" for="proof"></label>
         <div class="col-md-7">
           
            <?php
            $img = "";
            $imageExist = ['jpg','gif','jpeg','png','ico','jfif'];
            $docsExist  = ['ods','doc','docx'];
            foreach($docss as $proofs){   
             $ext = pathinfo($proofs['file_name'], PATHINFO_EXTENSION);
            if(in_array($ext,$imageExist)){
               $img = "assets/modules/purchase/uploads/{$proofs['file_name']}";
            }elseif(in_array($ext,$docsExist)){
               $img = "assets/images/docX.png";
            }elseif($ext == 'pdf'){
               $img = "assets/images/PDF.png";
            }elseif($ext == 'xlsx'){
               $img = "assets/images/excel.png";   
            }
             if( $img ){
                     echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/purchase/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().$img.'" alt="image" height="100" width="100"/><i class="fa fa-download"></i></a>
                  <div class="mask">
                     <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'purchase/delete_doccs/'.$proofs['id'].'/'.$mrnOrder->id.'">
                     <i class="fa fa-trash"></i>
                     </a>
                 </div></div></div>';  
               }
            } 
            ?>
         </div>
      </div>
      <?php } 
         $checkedExist = false;
         if( $indents->purchase_type ){
            $checkedExist = true;
         }

      ?>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="proof">Type</label>
         <div class="col-md-6 col-sm-12 col-xs-12" >
            <div class="col-md-9 col-sm-11 col-xs-12 purchase_type" style="margin-bottom: 3%;     padding-left: 0px; ">
               <input type="radio" class="validate" name="purchase_type" value="0" <?php if($checkedExist){ if(  !$indents->purchase_type ){ echo "checked";  } }else{ echo "checked"; } ?>  > Domestic
               <input type="radio" class="validate"  name="purchase_type" value="1" <?php  if( $indents->purchase_type ){ echo "checked";  }  ?>> Import
            </div>
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
<!--------------Quick add material code original----------------------->

<?php //echo $this->load->view('mrn/addQuickmaterial'); ?>

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
                     <select class="uom selectAjaxOption select2 form-control" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php   //echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0 AND active_inactive = 1" tabindex="-1" aria-hidden="true">
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