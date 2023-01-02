<?php          
   //$last_id = get_workOrder_number_count('work_order',$_SESSION['loggedInUser']->c_id ,'created_by_cid');
   //$work_id =  $last_id + 1;
   //$work_order_code  = sprintf("%04s", $work_id);
   //$work_order_code  = ($work_order && !empty($work_order))?$work_order->work_order_no:('WorkOrder_'.sprintf("%04s", $work_id));
   
   //PRE($Challan_id);
   /*$rId = $last_id + 1;
   $MachineCode = 'Mac'.rand(1, 1000000).'_'.$rId;    */ 
   // pre($sale_order_data);
   ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveWorkOrder" enctype="multipart/form-data" id="" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php //if($work_order && !empty($work_order)){ echo $work_order->id;} ?>">
   <input type="hidden" name="save_status" value="1" class="save_status">
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">   
   <input type="hidden" name="sale_order_id" value="<?php if($sale_order_data && !empty($sale_order_data)){ echo $sale_order_data->id;} ?>" id="">   
   <?php
      if(empty($sale_order_data)){

         // pre($sale_order_data);
      ?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <?php }else{ ?>   
   <input type="hidden" name="created_by" value="<?php if($sale_order_data && !empty($sale_order_data)){ echo $sale_order_data->created_by;} ?>" >
   <?php } ?>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12">Customer name</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <?php /*if(!empty($sale_order_data)){
               $customer_name  = getNameById('account',$sale_order_data->account_id,'id');
               //pre($customer_name);
               }*/ ?>
            <select class="itemName selectAjaxOption select2" name="customer_name_id" data-id="account" data-key="id" data-fieldname="name" data-where="account_owner = <?php echo $_SESSION['loggedInUser']->c_id; ?>" width="100%" id="account_id" readonly>
               <option value="">Select Option</option>
               <?php 
                  if(!empty($sale_order_data->account_id)){
                     $account = getNameById('account',$sale_order_data->account_id,'id');
                     echo '<option value="'.$account->id.'" selected>'.$account->name.'</option>';
                  }
                  ?>
            </select>
            <!--input id="customer_name" class="form-control col-md-7 col-xs-12" name="customer_name" placeholder="Customer Name" required="required" type="text" value="<?php //if(!empty($customer_name)){ echo $customer_name->name; }?>" >        
               <input id="customer_name" class="form-control col-md-7 col-xs-12" name="customer_name_id" placeholder="Customer Name" required="required" type="hidden" value="<?php //if(!empty($sale_order_data)){ echo $sale_order_data->account_id; }?>" -->         
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12">Sale Order Number</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="sale_order_no" class="form-control col-md-7 col-xs-12" name="sale_order_no" placeholder="Customer Order Number" required="required" type="text" value="<?php if($sale_order_data && !empty($sale_order_data)){ echo $sale_order_data->so_order;}?>"readonly>       
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="work_no">Work Order Number<span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <?php if($sale_order_data){
               $Order_no = get_workOrder_number_count('work_order',$_SESSION['loggedInUser']->c_id ,'created_by_cid');
               $work_order_no =  $Order_no->total_challan + 1;}
               ?>
            <input  id="work_order_no" class="form-control col-md-7 col-xs-12" name="work_order_no" placeholder="Work Order Number" type="text" value="<?php echo sprintf("WorkOrderNo_%04s", $work_order_no);  ?>" readonly >
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="date">Expected Date <span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <div class=" xdisplay_inputx form-group has-feedback">
               <input type="text" class="form-control has-feedback-left machinePurchaseDate" name="expected_delivery_date" id="expected_date" aria-describedby="inputSuccess2Status3"  value="<?php echo date('d-m-Y');?>" required>
               <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
               <span id="inputSuccess2Status3" class="sr-only">(success)</span>
            </div>
         </div>
      </div>
   </div>
      <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control col-md-7 col-xs-12 selectAjaxOption select2 compny_unit" required="required" name="company_branch_id" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
               <option value="">Select Unit</option>
            </select>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Department</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control  col-md-7 col-xs-12  selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="department_id"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid =<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = '<?php echo (!empty($work_order))?$work_order->company_branch_id:''; ?>'" >
               <option value="">Select Option</option>
            </select>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="work_no">Work Order Name<span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <input  id="workorder_name" class="form-control col-md-7 col-xs-12" name="workorder_name" placeholder="Work Order Name" type="text" value="" required >
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="work_no">Work Order Progress Status</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <?php $progress_status = array('0' => 'In Progress','1'=>'Complete' ); 
             //$checked_status = !empty($work_order->progress_status)?$work_order->progress_status:'0';

         ?>
            <select class="form-control col-md-2 col-xs-12" title="Prgress Status" name="progress_status" >
               <?php foreach ($progress_status as $key => $value) { ?>
               <option value="<?php echo $key;?>" <?php echo ($key ==  $sale_order_data->complete_status) ? ' selected="selected"' : '';?>><?php echo $value;?></option>
               <?php } ?>
            </select>
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <h3 class="Material-head">
      Material Details
      <hr>
   </h3>
   <?php  if(!empty($sale_order_data)){
      $product_detail = json_decode($sale_order_data->product);   
             $i =0;
         foreach($product_detail as $sale_order_product){
       $materialName = getNameById('material',$sale_order_product->product,'id');
         $pendingQty = getPendingQtyOfSalesOrder('work_order',$sale_order_data->id ,'sale_order_id');
     ?> 
   <!-- <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="material">Material Type </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
               <option value="">Select Option</option>
               <?php if(!empty($sale_order_data)){
                  $material_type_id = getNameById('material_type',$sale_order_product->material_type_id,'id');
                  echo '<option value="'.$sale_order_data->material_type_id.'" selected>'.$material_type_id->name.'</option>';
                  }?>
            </select>
         </div>
      </div>
   </div> -->
   <div class="item form-group ">
      <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
         <div class="item form-group">
            <div class="col-md-12 input_holder middle-box">
               
               <div class="well <?php if($i==0){ echo 'edit-row1';}else{ echo 'scend-tr mobile-view';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkIndex_<?php echo $i; ?>">

                 <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Material Type </label>
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
                           <option value="">Select Option</option>
                         <?php if(!empty($sale_order_data)){
                         $material_type_id = getNameById('material_type',$sale_order_product->material_type_id,'id');
                          echo '<option value="'.$sale_order_data->material_type_id.'" selected>'.$material_type_id->name.'</option>';
                          }?>
                    </select>
                  </div>

                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Material Name</label>
                     <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getUom(event,this);">
                        <option value="">Select Option</option>
                        <?php
                           echo '<option value="'.$sale_order_product->product.'" selected>'.$materialName->material_name.'</option>';
                           ?>
                     </select>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Required Qty&nbsp;&nbsp;&nbsp;<span id="qtyMessage" style="color:red;"></span></label>         <input type="number"  name="quantity[]" class="form-control col-md-7 col-xs-12  actual_qty"  placeholder="Required Qty" value="<?php echo $sale_order_product->quantity; ?>" onkeyup = "getQtyValue(event,this)"   onkeypress="getQtyValue(event,this)" readonly>
                  </div>
                  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                     <label>Pending Qty&nbsp;&nbsp;&nbsp;<span  style="color:red;"></span></label><input type="number" name="Pending_quantity[]" class="form-control col-md-7 col-xs-12 Pending_quantity"  placeholder="Pending Qty" value="<?php echo (isset($pendingQty[$i]->Pending_quantity)?$pendingQty[$i]->Pending_quantity:$sale_order_product->quantity); ?>"  readonly>
                     <input type="hidden" class="Pendingquantity" value="<?php echo (isset($pendingQty[$i]->Pending_quantity)?$pendingQty[$i]->Pending_quantity:$sale_order_product->quantity); ?>">
                  </div>
                  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                     <label>WorkOrder Qty&nbsp;&nbsp;&nbsp;<span  style="color:red;"></span></label><input type="number"  name="transfer_quantity[]" class="form-control col-md-7 col-xs-12 transfer_quantity"  placeholder="WorkOrder Qty" value="<?php echo (isset($sale_order_product->transfer_quantity)?$sale_order_product->transfer_quantity:0); ?>" onkeyup = "UpdatePendingQtyValue(event,this)"   onkeypress="UpdatePendingQtyValue(event,this)">
                     <span id="transferqtyMessage" style="color:red;"></span>
                  </div>
                  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                     <label>UOM</label>
                 <?php  $ww =  getNameById('uom', $sale_order_product->uom,'id');
                           $uom = !empty($ww)?$ww->ugc_code:'';
                ?>

                     <input type="text" class="form-control col-md-7 col-xs-12" placeholder="uom." value="<?php echo $uom; ?>" readonly>
                     <input type="hidden" name="uom[]" class="form-control col-md-7 col-xs-12  uom" value="<?php echo $sale_order_product->uom; ?>">
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <label>Bom and routing number</label>
                     <input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12  job_card" placeholder="Bom and routing number" value="" readonly>
                  </div>
               </div>
               <?php $i++;}} ?>
            </div>
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <?php /*<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">          
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="model">Job Card Number</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" id="job_card_no" name="job_card_no_id" class="form-control col-md-7 col-xs-12" placeholder="Job card number" value="<?php //if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->make_model; }?>"> 
   </div>
   </div>
   </div>*/ ?>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="note">Note</label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <textarea  id="specification" name="specification" class="form-control col-md-7 col-xs-12"   placeholder="" value="<?php //if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->placement; }?>"></textarea>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Select</label>
         <div id="" class="btn-group group-required" data-toggle="buttons">
            <p>         
            <h5>
            <strong>For Stock:
            <input type="radio" class="flat" name="stock_saleOrder" id="stock" value="stock" <?php //if(!empty($work_order->stock_saleOrder) && isset($work_order->stock_saleOrder)){ echo $work_order->stock_saleOrder == 'stock' ?  "checked" : "" ;  }?> disabled>
            For Sale order:
            <input type="radio" class="flat" name="stock_saleOrder" id="sale_order" value="sale_order" <?php //if(!empty($work_order->stock_saleOrder) && isset($work_order->stock_saleOrder)){ echo $work_order->stock_saleOrder == 'sale_order' ?  "checked" : "" ;  }?> checked>
            </p>
         </div>
      </div>
   </div>
   <hr>
   <div class="form-group">
      <div class="col-md-12 ">
         <center>
            <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
            <!-- <button type="reset" class="btn edit-end-btn">Reset</button>-->
            <?php //if((!empty($Addmachine) && $Addmachine->save_status !=1) || empty($Addmachine)){
               //echo '<input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft">'; 
               //}?> 
            <button id="send" type="submit" class="btn edit-end-btn enableOnInput" disabled='disabled'>Submit</button>
         </center>
      </div>
   </div>
</form>
<!-- /page content -->