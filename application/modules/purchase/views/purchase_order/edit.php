<style>
.label-for-laptop label {
    display: table-cell;
    vertical-align: middle;
    float: unset;
}
</style>
<?php
   $last_id = getLastTableId('purchase_order');
   $rId = $last_id + 1;
   $poCode = 'PUR_' . rand(1, 1000000) . '_' . $rId;
   /************** Revised Purchase order generation ******************/
   $currentRevisedPOChar = 'A';
   $nextRevisedPOChar = chr(ord($currentRevisedPOChar) + 1); 
   $revisedPOCode = '';
   if ($order && $order->save_status ==1) {
    $po_code_array = explode('_', $order->order_code, 4); 
    if($po_code_array[3] == ''){
      $currentRevisedPOChar = 'A';
      #$nextRevisedPOChar = chr(ord($currentRevisedPOChar) + 1); 
      $revisedPOCode = $order->order_code.'_'.$currentRevisedPOChar.'(Revised)';
    }else if($po_code_array[3] != ''){
      #echo $po_code_array[2];
      $orignalOrderCode = $po_code_array[0].'_'.$po_code_array[1].'_'.$po_code_array[2];
      $currentRevisedPOChar = explode('(', $po_code_array[3], 2);
      $nextRevisedPOChar = chr(ord($currentRevisedPOChar[0]) + 1); 
      $revisedPOCode = $orignalOrderCode.'_'.$nextRevisedPOChar.'(Revised)';
    } 
   } 
   /************** Revised Purchase order generation ******************/
   ?>
<form method="post" class="form-horizontal" id="purchaseIndentForm" action="<?php echo base_url(); ?>purchase/saveOrder" enctype="multipart/form-data" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php if ($order) { echo $order->id;} ?>">
   <input type="hidden" name="pi_id" value="<?php if ($order && !empty($order)) { echo $order->pi_id; } ?>">
   <input type="hidden" name="save_status" value="1" class="save_status">
   <input type="hidden" name="ifbalance" value="1" >
   <input type="hidden" name="revised_po_code" value="<?php if ($order && !empty($order)) { echo $revisedPOCode; } ?>" class="revised_po_code">
   <?php 
      $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
      
      /*<input type="hidden" name="created_by" value="<?php if($order && (!empty($order))){ echo $order->created_by;} else { echo $_SESSION['loggedInUser']->u_id; } ?>"> */?>
    
    
   <input type="hidden" name="created_by" value="<?php if($order && (!empty($order))){ echo $order->created_by;}  ?>"> 
   <input type="hidden" value="<?php  echo $this->companyGroupId; ?>" id="loggedUser">
   <?php if ($order && !empty($order) && $order->pi_id != '' ) {
      $purchaseIndentData=getNameById('purchase_indent',$order->pi_id,'id');
      if(!empty($purchaseIndentData)){ echo '<center><b>Purchase Order Number : </b>'.$purchaseIndentData->indent_code.'</center>'; 
      echo '<center><b>Order Created Date : </b>'.date("j F , Y", strtotime($purchaseIndentData->created_date)).'</center><br />';
      }
      }?>   
   <?php
   
      if(empty($order)){
      ?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <?php }else{ ?>  
   <input type="hidden" name="created_by" value="<?php if($order && !empty($order)){ echo $order->created_by;} ?>" >
   <?php } ?>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="code">Purchase Order No.</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input id="Purchase_code" class="form-control col-md-7 col-xs-12" name="order_code" placeholder="ABC239894"  type="text" value="<?php if($order && (!empty($order))){ echo $order->order_code;} else { echo $poCode; } ?>" readonly>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Unit<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <!--select class="form-control  select2 address" required="required" name="company_unit">
               <option value="">Select Option</option>
                <?php
                  /*if(!empty($order)){
                    echo '<option value="'.$order->company_unit.'" selected>'.$order->company_unit.'</option>';
                    }*/
          
                  ?>
               </select-->
            <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 select2-width-imp" required="required" name="company_unit" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
               <option value="">Select Unit</option>
               <?php
                  if(!empty($order)){
                    $getUnitName = getNameById('company_address',$order->company_unit,'compny_branch_id');
                    
                    echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                  }
          
                  ?>
            </select>
         </div>
    </div>
    <!--<div class="item form-group">
      <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">OutSource Process </label>
       <div class="col-md-6 col-sm-12 col-xs-12">
           <input type="checkbox" name="is_outsource_process" value="1" id="outsource_btn" </?php 
         if(!empty($order)){ 
         if($order->is_outsource_process == 1){
           echo "checked";
           }
         }
         if(!empty($order)){if($order->is_outsource_process == 0){ echo 'disabled'; }}?> >
       </div>
        </div>-->

         <?php
      $selectOption = "";
      if( $approveUsers ){
         $i = 1;
         $selectApproveUsers = [];
         if( isset($order->selectApproveUsers) ){
            $selectApproveUsers = json_decode($order->selectApproveUsers,true);
         }
         foreach($approveUsers as $appKey => $appValue){
            $selectOption .= '<div class="col-md-6 col-sm-12 col-xs-12">';
            $selectOption .= '<div class="item form-group">';
            $selectOption .= "<label class='col-md-6 col-sm-12 col-xs-12' for='supplier_name'>Approve Step {$i} <span class='required'>*</span></label>";
            $selectOption .= '<div class="col-md-6 col-sm-12 col-xs-12">';
            $selectOption .= '<select class="commanSelect2 form-control" name="selectApproveUsers[]" required>';
            $selectOption .= "<option value=''>Select User</option>";
            foreach($appValue as $userKey => $userValue){
                  if( in_array($userValue['id'],$selectApproveUsers) ){
                     $selected = "selected";
                  }else{
                     $selected = "";
                  }
                  $selectOption .= "<option value='{$userValue['id']}' {$selected} >{$userValue['name']}</option>";
            }
            $selectOption .= "</select>";
            $selectOption .= "</div>";
            $selectOption .= "</div>";
            $selectOption .= "</div>";
         $i++;
         }
      }
      echo $selectOption;
    ?>


   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="supplier_name">Supplier Name <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="supplierName form-control col-md-2 col-xs-12 selectAjaxOption select2 add_more_Supplier prefferedSupplier select2-width-imp" id="supplier_name" required="required" name="supplier_name" data-id="supplier" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status  =1" onchange="getSupplierAddress(event,this)">
               <option value="">Select Supplier</option>
               <?php
                  if (!empty($order)) {
                    $supplier_name_id = getNameById('supplier', $order->supplier_name, 'id');
                    echo '<option value="' . $order->supplier_name . '" selected  data-id="' . $supplier_name_id->address . '">' . $supplier_name_id->name . '</option>';
                  }
                  ?>
            </select>
         </div>
      </div>
      <input type="hidden" value="<?php if(!empty($order)){ echo $order->party_billing_state_id; } ?>" id="party_billing_state_id" name="party_billing_state_id">
      <input type="hidden" value="<?php if(!empty($order)){ echo $supplier_name_id->state; } ?>" id="sale_company_state_id">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="address">Address</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea id="address" name="address" class="form-control col-md-7 col-xs-12 requrid_class" placeholder="Display when supplier is selected from above"><?php if ($order && !empty($order) && !empty($order)) {$supplier_name_id = getNameById('supplier', $order->supplier_name, 'id');
               echo $supplier_name_id->address;} ?></textarea>
            <span class="spanLeft control-label"></span>
         </div>
      </div>
      

    <script>
  var dateToday = new Date();
  var dates = $("#from, #to").datepicker({
    defaultDate: "+1w",
    changeMonth: true,
    numberOfMonths: 1,
    minDate: dateToday,
    onSelect: function(selectedDate) {
        var option = this.id == "from" ? "minDate" : "maxDate",
            instance = $(this).data("datepicker"),
            date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
        dates.not(this).datepicker("option", option, date);
    }
});
   </script>

      <?php if (empty($order->open_purchase_from)){ ?>
          <div class="item form-group show_cls1" style="display: none;" >
             <label class="col-md-3 col-sm-2 col-xs-12" for="from">From Date</label>
             <div class="col-md-3 col-sm-12 col-xs-12">
             <div class="input-group date"  >
                 <input type="text" class="form-control" id="from" name="open_purchase_from" /> 
              </div>
          </div>

          <label class="col-md-3 col-sm-2 col-xs-12" for="to">To Date</label>
             <div class="col-md-3 col-sm-12 col-xs-12">
             <div class="input-group date"  >
                 <input type="text" class="form-control" id="to" name="open_purchase_to" /> 
              </div>
          </div>

      </div>
      <?php }elseif (!empty($order->open_purchase_from)) { ?>
          
           <div class="item form-group show_cls1"   >
             <label class="col-md-3 col-sm-2 col-xs-12" for="from">From Date</label>
             <div class="col-md-3 col-sm-12 col-xs-12">
             <div class="input-group date"  >
                 <input type="text" class="form-control" id="from" name="open_purchase_from" value="<?=$order->open_purchase_from;?>" /> 
              </div>
          </div>

          <label class="col-md-3 col-sm-2 col-xs-12" for="to">To Date</label>
             <div class="col-md-3 col-sm-12 col-xs-12">
             <div class="input-group date"  >
                 <input type="text" class="form-control" id="to" name="open_purchase_to" value="<?=$order->open_purchase_to;?>" /> 
              </div>
          </div>

      </div> 
    <?php   } ?>
       

      
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <!--<div class="heading">
      <h4>Material Details </h4>
      <div class="totalBudget" style="color:red;"></div>
      <div class="budgetSpent" style="color:green;"></div>
      </div>-->
   <h3 class="Material-head" style="margin-bottom: 30px;">
      Material Details
      <hr>
   </h3>
   <!--div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="material">Material Type <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php //echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
      
               <option value="">Select Option</option>
               <?php
                  // if (!empty($order)) {
                    // $material_type_id = getNameById('material_type', $order->material_type_id, 'id');
                    // echo '<option value="' . $order->material_type_id . '" selected>' . $material_type_id->name . '</option>';
                  // }
                  ?>
            </select>
         </div>
      </div>
   </div-->
   <div class="form-group" style="margin-bottom: 25px;">
      <div>
         <div class=" ">
            <div class=" goods_descr_wrapper">
               
               <div class="col-md-12 input_material middle-box">
                  <?php if (empty($order) || $order->material_name =='') {  ?>
                  <div class="col-sm-12  col-md-12 label-box mobile-view2">
                     <!-- <label class="col-md-1 col-sm-12 col-xs-6 ">MAT. Type<span class="required">*</span></label> -->
                     <label class="col-md-1 col-sm-12 col-xs-6 ">MAT.  Name<span class="required">*</span></label>
					  <label class="col-md-1 col-sm-12 col-xs-6 ">HSN/SAC</label>
                     <label class="col-md-1 col-sm-12 col-xs-6 ">Alias<span class="required">*</span></label>
                     <label class="col-md-1 col-sm-12 col-xs-6 ">Img</label>
                    
                     <label class="col-md-2 col-sm-12 col-xs-6">Special Description</label>
                     <label class="col-md-1 col-sm-6 col-xs-6 ">Quantity &nbsp;&nbsp; &nbsp;UOM</label>
                     <label class="col-md-1 col-sm-6 col-xs-6 ">Price</label>
                   
                     <label class="col-md-1 col-sm-6 col-xs-12 ">Sub Total</label>
                     <label class="col-md-1 col-sm-6 col-xs-12 ">GST (%)</label>
                     <label class="col-md-1 col-sm-6 col-xs-6 ">Sub Tax</label>
                     <label class="col-md-1 col-sm-6 col-xs-6 " >Total</label>
					 <label class="col-md-1 col-sm-6 col-xs-12 show_cls" style="display:none;">BOM No</label>
					 <label class="col-md-1 col-sm-6 col-xs-12 show_cls" style="border-right: 1px solid #c1c1c1 !important;display:none;">Process </label>                  
                  </div>
                  <div class="well  mobile-view" id="chkIndex_1" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">
          <!-- <div class="col-md-1 col-sm-12 col-xs-6 form-group">
              <label>MAT.Type<span class="required">*</span></label>
             <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
              <option value="">Select Option</option>   
             </select>
          </div> -->
                     <select class="appendMaterialTypeIdByMat material_type_id" style="width:0;height: 0;position: absolute;" name="material_type_id[]">
                         <option value="<?= $poCreate_Data_Details->material_type_id ?>"><?= $poCreate_Data_Details->material_type_id ?></option>
                     </select>
                     <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                        <label>MAT. Name<span class="required">*</span></label>
                        <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot select2-width-imp" id="mat_name" required="required" name="material_name[]" onchange="getTaxPOrder(event,this)" data-where="created_by_cid=<?= $_SESSION['loggedInUser']->c_id ?> AND status=1" data-id="material" data-key="id" data-fieldname="material_name">
                           <option value="">Select Option</option>
                        </select>
                     </div>
                     <input type="hidden" value="1" name="po_or_not">
					  <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                        <label>HSN/SAC</label>
                        <input  name="hsnCode[]" class="form-control col-md-7 col-xs-12 hsnCode" value="" readonly>
                        <input type="hidden" name="hsnId[]" class="hsnId" value="" class="form-control col-md-7 col-xs-12">         
                     </div>
					 <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                        <label>Alias</label>
                        <input type="text" name="aliasname[]"  value="" class="form-control col-md-7 col-xs-12 aliasname">         
                     </div>
					 <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                        <div class="col-md-1 col-sm-12 col-xs-6 form-group"><label>Img</label> 
						<div class="MatImage col-xs-12"></div><input type="hidden" name="matimg[]" value="" class="matimgcls">
						</div>         
                     </div>
                    
                     <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                        <label>Description</label>
                        <textarea id="description" name="description[]" rows="1" class="form-control col-md-7 col-xs-12 description"></textarea>               
                     </div>
                     <div class="col-md-1 col-sm-6 col-xs-6 form-group">
                        <label>Quantity &nbsp;&nbsp; &nbsp;UOM</label>
                        <input type="text" id="quantity" name="quantity[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event checkBugget" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
                        <input type="text" id="uom" name="uom1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12 uom1" readonly>
                        <input type="hidden" name="uom[]" readonly class="uom">
                     </div>
                     <div class="col-md-1 col-sm-6 col-xs-6 form-group">
                        <label>Price</label>
                        <input type="text" id="amount" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
                     </div>
                      
                        
                        <input type="hidden" id="discount" value="0" name="discount[]" placeholder="Discount %" class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" readonly>
                    
                     <div class="col-md-1 col-sm-6 col-xs-6 form-group">
                        <label>Sub Total</label>
                        <input type="text" id="sub_total" name="sub_total[]" placeholder="sub total" class="form-control col-md-7 col-xs-12 key-up-event" min="0" readonly>
                     </div>
                    
                         
                     <div class="col-md-1 col-sm-6 col-xs-6 form-group">
                        <!--<input type="number" name="gst[]"  placeholder="gst" class="form-control col-md-7 col-xs-12 key-up-event gst_tax"  id="gst_tax">--->
                        <label>GST</label>
                        <input type="text" name="gst[]" placeholder="gst" class="form-control col-md-7 col-xs-12 key-up-event gst_tax" id="gst_tax" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
                     </div>
                     <div class="col-md-1 col-sm-6 col-xs-6 form-group">
                        <label>Sub Tax</label>
                        <input type="text" name="sub_tax[]" placeholder="tax" class="form-control col-md-7 col-xs-12 key-up-event" min="0" readonly>
                     </div>

                     <div class="col-md-1 col-sm-6 col-xs-6 form-group">
                        <label>Total</label>
                        <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="total[]" placeholder="total" class="form-control col-md-7 col-xs-12 key-up-event" min="0" readonly>
                     </div>
           <div class="col-md-1 col-sm-12 col-xs-12 form-group show_cls" style="display:none;">
            
              <select class="itemName  form-control selectAjaxOption select2 goods_descr_section get_process_name select2-width-imp" name="bom_number[]" data-id="job_card" data-key="id" data-fieldname="job_card_no" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status=1" width="100%"><option value="">Select</option>       
              </select>
          </div>
          <div class="col-md-1 col-sm-12 col-xs-12 form-group show_cls" style="display:none;">
             
            <select class="form-control process_name_id  goods_descr_section" required="required" name="process_name[]" tabindex="-1" aria-hidden="true" required="required"  id="process_name_id">
                 <option value="">Select Option</option>
            </select>
          </div>
                     <button  class="btn  btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button>
                  </div>
                  <div class="col-sm-12 btn-row"><button style="margin-top: 22px;" class="btn edit-end-btn addButton " type="button" align="right">Add</button></div>
                  <?php } else if (!empty($order) && $order->material_name != '') {
                     $orderMaterialDetails = json_decode($order->material_name);
                      
                     
                     if (!empty($orderMaterialDetails)) {
                      $i =  1;
          
                      ?>
                  <div class="col-sm-12  col-md-12 label-box mobile-view2 label-for-laptop">
                 <!-- <label class="col-md-1 col-sm-12 col-xs-6 ">MAT. Type<span class="required">*</span></label> -->
                     <label class="col-md-1 col-sm-12 col-xs-6 " style="float: left;">MAT. Name<span class="required">*</span></label>
                     <label class="col-md-1 col-sm-12 col-xs-6 " style="float: left;">HSN/SAC</label>
                     <label class="col-md-1 col-sm-12 col-xs-6 " style="float: left;">Alias</label>
                     <label class="col-md-1 col-sm-12 col-xs-6 " style="float: left;">Img</label>
                     <label class="col-md-2 col-sm-12 col-xs-6 " style="float: left;">Special Description</label>
                     <label class="col-md-1 col-sm-6 col-xs-6 " style="float: left;">Quantity &nbsp;&nbsp; &nbsp;UOM</label>
                     <label class="<?php if($order->is_outsource_process == 1){ echo 'col-md-1';}else{ echo 'col-md-1';} ?> col-sm-6 col-xs-6" style="float: left;">Price</label>
                     
                     <label class="col-md-1 col-sm-6 col-xs-12 " style="float: left;">Sub Total</label>
                     <label class="col-md-1 col-sm-6 col-xs-12 " style="float: left;">GST(%)</label>
                     <label class="col-md-1 col-sm-6 col-xs-6 " style="float: left;">Sub Tax</label>
                     <label class="col-md-1 col-sm-6 col-xs-6 " style="float: left;" >Total</label>
           <label class="col-md-1 col-sm-6 col-xs-12 <?php if($order->is_outsource_process == 1){ echo 'show_cls';} else{ echo 'hid_cls';}?>" style="float: left;">BOM No</label>
           <label class="col-md-1 col-sm-6 col-xs-12 <?php if($order->is_outsource_process == 1){ echo 'show_cls';} else{ echo 'hid_cls';}?>" style="border-right: 1px solid #c1c1c1 !important;" style="float: left;">Process </label>                  
                  </div>
         <?php //echo ($_GET['page'] == 'about.php')? 'current' : 'normal'; ?>
                  <?php
          // 
                     foreach ($orderMaterialDetails as $orderMaterialDetail) {
						 
					 if(!empty($orderMaterialDetail->material_name_id)){
                      
                      $material_name_id = getNameById('material', $orderMaterialDetail->material_name_id, 'id');
                     
                      ?>
                  <div class="well <?php if($i==1){ echo 'edit-row1 mobile-view ';}else{ echo 'scend-tr mobile-view';}?>" id="chkWell_<?php echo $i; ?>" style="overflow:auto;  ">
                    <!-- <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12">Material Type</label>
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
                              <option value="">Select Option</option>  
                               <?php
                                 if(!empty($orderMaterialDetail->material_type_id)){
                  $material_type_id1 = getNameById('material_type',$orderMaterialDetail->material_type_id,'id');
                                    echo '<option value="'.$orderMaterialDetail->material_type_id.'" selected>'.$material_type_id1->name.'</option>';
                                    }
                                 ?> 
                           </select>                               
                        </div> -->
                     <select class="appendMaterialTypeIdByMat material_type_id" style="width:0;height: 0;position: absolute;" name="material_type_id[]">
                         <option value="<?= $orderMaterialDetail->material_type_id ?>"><?= $orderMaterialDetail->material_type_id ?></option>
                     </select>
                     <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                        <label>Material Name<span class="required">*</span></label>                     
                        <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 select2-width-imp" id="mat_name" required="required" name="material_name[]" onchange="getTaxPOrder(event,this)"  data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $orderMaterialDetail->material_type_id;?> AND status=1">
                           <option value="">Select Option</option>
                           <?php
                              echo '<option value="' . $orderMaterialDetail->material_name_id . '" selected>' . $material_name_id->material_name . '</option>';?>
                        </select>
                     </div>
					 
					
                     <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                     <label>HSN/SAC</label>
                     <input  name="hsnCode[]" class="form-control col-md-7 col-xs-12 hsnCode" value="<?php if ($order && !empty($order)) { echo $orderMaterialDetail->hsnCode; } ?>" readonly>
                     <input type="hidden" name="hsnId[]" class="hsnId" value="<?php if ($order && !empty($order)) { echo $orderMaterialDetail->hsnId; } ?>" class="form-control col-md-7 col-xs-12">         
                  </div>
				  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                     <label>Alias</label>
                     <input  name="aliasname[]" class="form-control col-md-7 col-xs-12 aliasname" value="<?php if ($order && !empty($order)) { echo $orderMaterialDetail->aliasname; } ?>" readonly>         
                  </div>
				   <div class="col-md-1 col-sm-12 col-xs-12 form-group totl_amt">
				  <span class="totl_amt33">
                   <?php 
					$attachments = $this->purchase_model->get_image_by_materialId('attachments', 'rel_id', $orderMaterialDetail->material_name_id);
					
					if(!empty($attachments)){
						echo '<img style="width: 50px; height: 37px; margin-left:34px;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
					}else{
						echo '<img style="width: 50px; height: 37px; margin-left:34px;" src="'.base_url().'assets/uplodimg/noimage.jpg">';
					}
					?>
					</span>
					<div class="MatImage col-xs-12"></div>
					<input type="hidden" name="matimg[]" value="" class="matimgcls">
                         
                  </div>

                     <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                        <label>Description</label>
                        <textarea id="description" name="description[]" rows="1" class="form-control col-md-7 col-xs-12 description"><?php if ($order && !empty($order)) {  echo $orderMaterialDetail->description; } ?></textarea>     
                     </div>
                     <?php /*<div class="col-md-1 col-sm-6 col-xs-12 form-group">
                        <label>UOM</label>
                          <input type="text" name="uom[]" placeholder="Uom" class="form-control col-md-7 col-xs-12 uom" value="<?php if ($order && !empty($order)) {  echo $orderMaterialDetail->uom;} ?>">
                  </div>
                  <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>Quantity</label>
                     <input type="text" name="quantity[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" value="<?php if ($order && !empty($order)) { echo $orderMaterialDetail->quantity;  } ?>" min="0" onkeypress="return float_validation(event, this.value)">
                     <input type="hidden" value="1" name="po_or_not">
                  </div>
                  */?>
                  <div class="col-md-1 col-sm-6 col-xs-6 form-group">
                     <label>Quantity &nbsp;&nbsp; &nbsp;UOM</label>
                     <input type="text" id="quantity" name="quantity[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event checkBugget" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" value="<?php if ($order && !empty($order)) { echo $orderMaterialDetail->quantity;  } ?>">
                     <input type="text" id="uom" name="uom1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12 uom1" value="<?php //if ($order && !empty($order)) {  echo ;} 
                        $ww =  getNameById('uom', $orderMaterialDetail->uom,'id');
                        $uom = !empty($ww)?$ww->ugc_code:'';
                        echo $uom;
                        ?>" readonly>
                     <input type="hidden" name="uom[]" readonly class="uom" value="<?php echo $orderMaterialDetail->uom; ?>">
                     <input type="hidden" value="1" name="po_or_not">
                  </div>
                  <div class="<?php if($order->is_outsource_process == 1){ echo 'col-md-1';}else{ echo 'col-md-1';} ?> col-sm-6 col-xs-6 form-group">
                     <label>Price</label>
                     <input type="text" id="amount" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" value="<?php if($order && !empty($order)){ echo $orderMaterialDetail->price;} ?>" min="0" onkeypress="return float_validation(event, this.value)">
                  </div>
                   
                       
                        <input type="hidden" id="discount" name="discount[]" placeholder="Discount %" class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" value="<?php if($order && !empty($order)){ echo $orderMaterialDetail->discount;} ?>" min="0" onkeypress="return float_validation(event, this.value)" readonly >
                    
                  
                  <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>Sub Total</label>
                     <input type="text" id="sub_total" name="sub_total[]" placeholder="sub total" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php if($order && !empty($order)){ echo $orderMaterialDetail->sub_total;} ?>" min="0">
                  </div>
                  <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>GST</label>
                     <input type="text" name="gst[]" placeholder="gst" class="form-control col-md-7 col-xs-12 key-up-event gst_tax" id="gst_tax" value="<?php if (!empty($orderMaterialDetail)) echo $orderMaterialDetail->gst; ?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
                  </div>
                  <div class="col-md-1 col-sm-6 col-xs-6 form-group">
                     <label>Sub Tax</label>
                     <input type="text" name="sub_tax[]" placeholder="tax" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php if($order && !empty($order)){ echo $orderMaterialDetail->sub_tax;} ?>" min="0" >
                  </div>
                  <div class="col-md-1 col-sm-6 col-xs-6 form-group">
                     <label>Total</label>
                     <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="total[]" placeholder="total" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php if($order && !empty($order)){ echo $orderMaterialDetail->total;} ?>" min="0">
                  </div>
          
          <div class="col-md-1 col-sm-12 col-xs-12 form-group <?php if($order->is_outsource_process == 1){ echo 'show_cls';} else{ echo 'hid_cls';}?>">
             <label class="col-md-12 col-sm-12 col-xs-12" for="rate">BOM Number</label>
               <select class="itemName  form-control selectAjaxOption select2 goods_descr_section get_process_name select2-width-imp" name="bom_number[]" data-id="job_card" data-key="id" data-fieldname="job_card_no" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status=1" width="100%">                    
              <option value="">Select</option>        
              <?php
              if(!empty($order)){
                 $meterial_data = getNameById('job_card',$orderMaterialDetail->bom_number,'id');
                // pre($order);
                 echo '<option value="'.$orderMaterialDetail->bom_number.'" selected>'.$meterial_data->job_card_no.'</option>';
                 

              } 
              ?>    
            </select>
        </div>
        <div class="col-md-1 col-sm-12 col-xs-12 form-group <?php if($order->is_outsource_process == 1){ echo 'show_cls';} else{ echo 'hid_cls';}?>">
           <label class="col-md-12 col-sm-12 col-xs-12" for="rate">Process Name</label>
            <select class="form-control process_name_id  goods_descr_section select2-width-imp"  name="process_name[]" tabindex="-1" aria-hidden="true"   id="process_name_id">
               <option value="">Select Option</option>
               <?php
               
                if(!empty($order)){
                $process_data = getNameById('add_process',$orderMaterialDetail->process_name,'id');
                //pre($process_data);
                //echo '<option value="'.$orderMaterialDetail->process_name_id.'" selected>'.$process_data->process_name.'</option>';
                 echo '<option value="'.$orderMaterialDetail->process_name.'" selected>'.$process_data->process_name.'</option>';
                }
                ?>
            </select>
          
        </div>
                  <button  class="btn  btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button>
               </div>
               <?php $i++;
			}
                  }
                  }
                  }
                  ?>
               <div class="col-sm-12 btn-row"><button style="margin-top:22px" class="btn  edit-end-btn addButton" type="button" <?= $disablePlusButton ?>>Add</button></div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
               <div class="col-md-5 col-sm-5 col-xs-12 text-right" style="float: right;">
                  <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 22px;color: #2C3A61; border-bottom: 1px solid #2C3A61;">
                     <label class="col-md-5 col-sm-12 col-xs-12" for="grand">Grand Total :</label>
                     <div class="col-md-6 col-sm-12 col-xs-12 text-left">
                        <input type="text" class="form-control col-md-7 col-xs-12" id="subttot" readonly name="grand_total" placeholder="Grand Total" readonly value="<?php if($order && (!empty($order))){ echo $order->grand_total; } ?>" >
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
         <label class="col-md-3 col-sm-12 col-xs-12" for="payment">Payment Mode</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="payment_terms" name="payment_terms" class="form-control col-md-7 col-xs-12" placeholder="Payment Terms" value="<?php if(!empty($order)) echo $order->payment_terms;?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="material">Delivery Address</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            
            <!-- <select class="form-control  select2  address get_state_id" name="delivery_address"  id="address">
               <option value="">Select Option</option>
               <?php
                  //onchange="getAddress()"
                  // if (!empty($order)) {
                  //  $brnch_name = getNameById_with_cid('company_address', $order->delivery_address, 'compny_branch_id','created_by_cid',$this->companyGroupId);
                  //  //pre($brnch_name);
                  //  echo '<option value="' . $order->delivery_address . '" selected>' . $brnch_name->location . '</option>';
                  // }
                  ?>
            </select> -->
            <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location select2-width-imp" name="delivery_address" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
               <option>Select Option</option>
               <?php 
                  if(!empty($order)){
                      $locationAddress = getNameById('company_address',$order->delivery_address,'id');   
                     echo '<option value="'.$locationAddress->id.'" selected>'.$locationAddress->location.'</option>';         
                  }
               ?>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="pay">Payment Date</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="delivery_date" name="payment_date" class="form-control col-md-7 col-xs-12 delivery_date" placeholder="Payment date" value="<?php if(!empty($order)) echo $order->payment_date;?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="expected_Del">Expected Received Date: </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="delivery_date" name="expected_delivery_date" class="form-control col-md-7 col-xs-12 delivery_date" placeholder="Expected Received Date" value="<?php if($order && !empty($order) ){ echo $order->expected_delivery_date;} ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="date">Order Date </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="current_date" name="date" class="form-control col-md-7 col-xs-12" placeholder="Display the Current Date" value="<?php if($order && !empty($order)){ echo $order->date;} ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Choose</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <p>
               FOR:
               <input type="radio" class="flat" name="terms_delivery" id="for" value="FORPrice" checked <?php if(!empty($order) && $order->terms_delivery == 'FORPrice'){ echo 'selected'; } ?> required />
               EX-To be paid by customer:
               <input type="radio" class="flat" name="terms_delivery" id="exFact" value="To be paid by customer" <?php if(!empty($order) && $order->terms_delivery == 'To be paid by customer'){ echo 'checked'; } ?>/> 
            </p>
         </div>
      </div>


   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group" id="freight1">
         <label class="col-md-3 col-sm-12 col-xs-12" for="purpose">Freight (Rs)</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="freight" name="freight" class="form-control col-md-7 col-xs-12 key-up-event" placeholder="Freight" <?php // if (!empty($order)) echo 'readonly'; ?> value="<?php  if (!empty($order)) {  echo $order->freight; } ?>" onkeyup="keyupFunction(event,this)" min="0">
         </div>
   </div>
  
   <div class="item form-group">
      <label class="col-md-3 col-sm-12 col-xs-12" for="purpose">Other Charges (Rs)</label>
      <div class="col-md-6 col-sm-12 col-xs-12">
         <input type="text" id="other_charges" name="other_charges" class="form-control col-md-7 col-xs-12 key-up-event" placeholder="Other Charges" <?php // if (!empty($order)) echo 'readonly'; ?> value="<?php  if (!empty($order)) { echo $order->other_charges; } ?>" onkeyup="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
      </div>
   </div>
   <?php
	$company_data = getNameById('company_detail',$this->companyGroupId,'id');

   ?>
   <div class="item form-group">
      <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Terms and conditions </label>
      <div class="col-md-6 col-sm-12 col-xs-12">
         <textarea id="tnc" name="terms_conditions" class="form-control col-md-7 col-xs-12" placeholder="Terms And conditons"><?php if($order && !empty($order)){ echo $order->terms_conditions;}else{ echo  $company_data->purchase_term_conditions;} ?></textarea>
      </div>
   </div>
  
   </div>

   <hr>
   <div class="form-group">
      <center>
         <div class="col-md-12">
            <!--a class="btn  btn-default" onclick="location.href='<?php //echo base_url(); ?>purchase/purchase_order'">Close</a-->
            <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
            <button type="reset" class="btn edit-end-btn ">Reset</button>
            <?php 
               $checkApprove = 0;
               if((!empty($order) && $order->save_status !=1) || empty($order)){
                  echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
               }
               
               if( checkPurchaseApprove() ){
                  $checkApprove = 1;
               }
               if(!empty($order) && $order->save_status ==1) { echo '<button id="send" type="submit" class="btn edit-end-btn editPurchaseOrder" data-checkApprove="'.$checkApprove.'" >Revise PO</button>';  }else{ echo '<button id="send" type="submit" class="btn edit-end-btn">Submit</button>'; } ?>               
         </div>
      </center>
   </div>
</form>
<!-----------------------------Add quick material code----------------------->
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
                     <input type="text" id="suppliername" name="name" required="required" class="form-control col-md-7 col-xs-12 prefferedSupplier" value="" placeholder="Supplier Name ">
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
                     <input type="text" id="suppgstin" name="gstin" class="form-control col-md-7 col-xs-12 gstin" value=""  placeholder="GSTIN" onblur="fnValidateGSTIN(this)" >
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
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">Address<span class="required">*</span></label>
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