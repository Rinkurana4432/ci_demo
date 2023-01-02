<style>
.label-for-laptop label {float: unset;}
</style>

<form method="post" class="form-horizontal grnFormPurchase" enctype="multipart/form-data" id="mrn-form" novalidate="novalidate" action="<?php echo base_url(); ?>purchase/saveMRN">
   <input type="hidden" name="gate_id" value="<?= $gateEnteryData[0]['pgeId']??'' ?>">
   <input type="hidden" name="id" value="<?php if ($mrn && !empty($mrn)) {
      echo $mrn->id;
      } ?>">
   <input type="hidden" name="po_id" value="<?php if ($mrn && !empty($mrn)) {
      echo $mrn->id;
      } else if ($mrn && !empty($mrn)) {
      echo $mrn->po_id;
      } ?>">
   <?php $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>											
   <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
   <input type="hidden" name="save_status" value="1" class="save_status">
   <input type="hidden" name="ifbalance" value="1" >
   <?php if ($mrn && !empty($mrn) && $mrn->po_id != '' ) {
      $purchaseOrderData=getNameById('purchase_order',$mrn->po_id,'id');
      if(!empty($purchaseOrderData)){ echo '<center><b>Purchase Order Number : </b>'.$purchaseOrderData->order_code.'</center>'; 
      echo '<center><b>Order Created Date : </b>'.date("j F , Y", strtotime($purchaseOrderData->created_date)).'</center><br />';
      }
      }?>	
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="Bill No">Invoice No. 
            <span class="required">*</span>
         </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" name="bill_no" class="form-control col-md-7 col-xs-12" placeholder="Invoice No" value="<?php if( $gateEnteryData[0]['invoice_no'] ){ echo $gateEnteryData[0]['invoice_no']; }else{if ($mrn && !empty($mrn)) {echo $mrn->bill_no;}} ?>" required="required">
         </div>
      </div>
      <div class=" item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="Bill No">Invoice Date.
            <span class="required">*</span>
         </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" name="bill_date" class="form-control col-md-7 col-xs-12 bill_datee" placeholder="Invoice Date" value="<?php if ($mrn && !empty($mrn)) {echo $mrn->bill_date;} ?>" required="required">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="company_unit">Company Unit<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 select2-width-imp" required="required" name="company_unit" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
               <option value="">Select Unit</option>
               <?php
                  if(!empty($mrn)){
                  	$getUnitName = getNameById('company_address',$mrn->company_unit,'compny_branch_id');
                  	echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                  }
                  ?>
            </select>
            <!--select class="form-control  select2 address" required="required" name="company_unit">
               <option value="">Select Option</option>
               	<?php
                  /*if(!empty($mrn)){
                  	echo '<option value="'.$mrn->company_unit.'" selected>'.$mrn->company_unit.'</option>';
                  	}*/
                  ?>
               </select-->
         </div>
      </div>
      <div class="item form-group" style="display:none;">
            <label class="col-md-3 col-sm-12 col-xs-12" for="company_unit">Cost Center</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 select2-hidden-accessible select2-width-imp" 
               name="cost_center" data-id="purchase_cost_center" data-key="id" data-fieldname="cost_center_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?= $_SESSION['loggedInUser']->c_id ?> AND status=1" placeholder="Select Cost Center">
                  <option value="">Select Cost Center</option>
                  <?php
                     if(!empty($mrn)){
                        $costName = getNameById('purchase_cost_center',$mrn->cost_center,'id');
                        
                        echo '<option value="'.$costName->id.'" selected>'.$costName->cost_center_name.'</option>';
                        }
                        
                     ?>
               </select>
            </div>
         </div>

      
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="supplier_name">Supplier Name <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="supplierName form-control col-md-2 col-xs-12 selectAjaxOption select2 requrid_class add_more_Supplier select2-width-imp" id="supplier_name" required="required" name="supplier_name" data-id="supplier" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status=1" onchange="getSupplierAddress(event,this)">
               <option value="">Select Supplier</option>
               <?php
                  if( $gateEnteryData[0]['supplier'] ){
                           $supplier_name_id = getNameById('supplier', $gateEnteryData[0]['supplier'], 'id');
                           echo '<option value="' . $gateEnteryData[0]['supplier'] . '" selected  data-id="' . $supplier_name_id->address . '">' . $supplier_name_id->name . '</option>';   
                     }else{
                     if (!empty($mrn)) {
                     $supplier_name_id = getNameById('supplier', $mrn->supplier_name, 'id');
                     echo '<option value="' . $mrn->supplier_name . '" selected  data-id="' . $supplier_name_id->address . '">' . $supplier_name_id->name . '</option>';
                     }  
                  }
                  ?>
            </select>
            <span class="spanLeft control-label"></span>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="address">Address</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea id="address" name="address" class="form-control col-md-7 col-xs-12" placeholder="Display when supplier is selected from above"><?php if ($mrn  && !empty($mrn)) {	$supplier_name_id = getNameById('supplier', $mrn->supplier_name, 'id');echo $supplier_name_id->address;} ?></textarea>
         </div>
      </div>
      <div class="item form-group">
         <label>
         <input type="checkbox" name="is_quality_check" value="1" <?php  if(!empty($mrn)) {if($mrn->is_quality_check==1){echo 'checked';}	}?>/>Quality Check</label>		
      </div>
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
   <div class="item form-group ">
      <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
         <div class="">
            <div class=" goods_descr_wrapper">
               <div class="col-md-12 input_material middle-box for-bdr ">
                  <?php if (empty($mrn)) { ?>
                  <div class="col-sm-12  col-md-12 label-box mobile-view2 label-for-laptop">
                     <label class="col-md-2 col-sm-12 col-xs-6 ">M. Name <span class="required">*</span></label>
                     <label class="col-md-1 col-sm-12 col-xs-6 ">Img.</label>
                     <label class="col-md-1 col-sm-12 col-xs-6 ">Alias</label>
                     <label class="col-md-1 col-sm-6 col-xs-6 textStart" >Qty&nbsp; &nbsp; &nbsp; UOM</label>
                     <label class="col-md-1 col-sm-6 col-xs-6 ">price</label>
                     <label class="col-md-1 col-sm-6 col-xs-12 ">GST</label>
                     <label class="col-md-1 col-sm-6 col-xs-6 ">Tax</label>
                     <label class="col-md-1 col-sm-6 col-xs-6 ">Rcv'd <span class="required">*</span> | Invoice Oty</label>
                     <label class="col-md-1 col-sm-6 col-xs-12">Total</label>
                     <label class="col-md-2 col-sm-6 col-xs-6 textStart">Defected &nbsp; &nbsp;  &nbsp; Qty  &nbsp; &nbsp; &nbsp; Reason:</label>
                  </div>
                  <div class="well mobile-view" id="chkIndex_1" style="overflow:auto; border: 1px solid #c1c1c1 !important;">
				   <!-- <div class="col-md-1 col-sm-12 col-xs-6 form-group">
				     <label>M. Type <span class="required">*</span></label>
				    <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
					   <option value="">Select Option</option>
					   <?php
						  if (!empty($mrn)) {
							$material_type_id = getNameById('material_type', $mrn->material_type_id, 'id');
							echo '<option value="' . $mrn->material_type_id . '" selected>' . $material_type_id->name . '</option>';
						  }
						  ?>
					</select>
				    </div> -->
                <select class="appendMaterialTypeIdByMat material_type_id" style="width:0;height: 0;position: absolute;" name="material_type_id[]">
                   <option value="<?= $mrn->material_type_id ?>"><?= $mrn->material_type_id ?></option>
               </select>
                     <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                        <label>M. Name <span class="required">*</span></label>
                        <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 select2-width-imp" id="mat_name" required="required" name="material_name[]" onchange="getTaxPOrder(event,this);getlot(event,this)" data-where="created_by_cid=<?= $_SESSION['loggedInUser']->c_id ?> AND status=1" data-id="material" data-key="id" data-fieldname="material_name">
                           <option value="">Select Option</option>
                        </select>
                     </div>

                    <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                        <div class="col-md-1 col-sm-12 col-xs-6 form-group"><label>Img</label> 
						<div class="MatImage col-xs-12"></div><input type="hidden" name="matimg[]" value="" class="matimgcls">
						</div>         
                     </div>
                      <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12 ">Alias</label>
                            <input  name="aliasname[]" class="form-control col-md-7 col-xs-12 aliasname" value="" readonly>                           
                        </div>
                     <input type="hidden" value="1" name="mrn_or_not">
                     <!-- <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                        <label>Description</label>
                        <textarea id="description" rows="1" name="description[]" class="form-control col-md-7 col-xs-12 description"></textarea>					
                     </div> -->
                     <div class="col-md-1 col-sm-6 col-xs-6 form-group">
                        <label style="float:left; width:100%">Quantity&nbsp;&nbsp;&nbsp; UOM</label>
                        <input type="text" id="quantity" name="quantity[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
                        <input type="text" name="uom1[]" id="uom" placeholder="Uom" class="form-control col-md-7 col-xs-12 uom1" readonly value="">
                        <input type="hidden" name="uom[]" readonly class="uom">
                     </div>
                     <input type="hidden" name="discount[]" id="discount" value="0">
                     <div class="col-md-1 col-sm-6 col-xs-6 form-group">
                        <label>price</label>
                        <input type="text" name="price[]" placeholder="pp" class="form-control col-md-12 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
                     </div>
                     <input type="hidden" name="sub_total[]" placeholder="sub total" class="key-up-event">
                     <input type="hidden" value="" name="sub_total_amt_purchse_bill[]">
                     <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                        <label>GST</label>
                        <input type="text" name="gst[]" placeholder="gst" class="form-control col-md-7 col-xs-12 key-up-event gst_tax" id="gst_tax" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
                     </div>
                     <div class="col-md-1 col-sm-6 col-xs-6 form-group">
                        <label>Tax</label>
                        <input type="text" name="sub_tax[]" placeholder="tax" class="form-control col-md-7 col-xs-12 key-up-event"  min="0" readonly>
                     </div>
                     <div class="col-md-1 col-sm-6 col-xs-6 form-group" style="display: inline-flex;">
                        <label>Rcv'd Qty</label>
                        <input type="text" name="received_quantity[]" placeholder="Received Quantity" class="form-control col-md-12 col-xs-12 key-up-event" onchange="keyupFunction(event,this)" onkeyup="keyupFunction(event,this)"  onkeypress="return float_validation(event, this.value)">
                        <input type="text" name="invoice_quantity[]" placeholder="Invoice Quantity" class="form-control col-md-12 col-xs-12" onkeypress="return float_validation(event, this.value)">
                     </div>
                     <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                        <label>Total</label>
                        <input type="text" name="total[]" placeholder="total" class="form-control col-md-12 col-xs-12 key-up-event" min="0" readonly>
                        <input type="hidden" value="" name="amount_with_tax[]">
                     </div>
                     <div class="col-md-2 col-sm-6 col-xs-12 form-group">  
                        <div class="defectedContainer displayFlex">
                           <div class="defCheck">
                              <input type="checkbox" class="flat defected"/> 
                              <input type="hidden" name="defected[]" class="defectedVal" value=""/> 
                           </div>
                           <div class="defRession hideDiv defected_reason_div" >
                              <div class="defectedQtyRes displayFlex">
                                    <input type="text" name="defectedQty[]" class="form-control" value="" onkeypress="return float_validation(event, this.value)" onkeyup="keyupFunction(event,this)" /> 
                                    <textarea name="defected_reason[]" class="form-control col-md-7 col-xs-12 defected_reason" placeholder="Defected Reason"></textarea>                                    
                              </div>
   
                           </div>
                        </div>
                     </div>
                     <button style="margin-top:22px" class="btn plus-btn btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button>
                  </div>
                  <?php } ?>
                  <div class="col-sm-12 btn-row"><button class="btn  addButton plus-btn  edit-end-btn" type="button" align="right">Add</button></div>
                  <?php
                     //if(!empty($mrnOrder) && $mrnOrder->material_name !='' && (array_key_exists("po_id",$mrnOrder)  &&  $mrnOrder->po_id !=0)){ 
                     if (!empty($mrn) && $mrn->material_name != '') {
                     	$OrderMaterialDetails = json_decode($mrn->material_name);
                     	if (!empty($OrderMaterialDetails)) {
                     		$i =  1;


                     		?>


                  <div class="col-sm-12  col-md-12 label-box mobile-view2 label-for-laptop">
                     <label class="col-md-2 col-sm-12 col-xs-6 ">M. Name <span class="required">*</span></label>
                     <label class="col-md-1 col-sm-12 col-xs-6 ">Img.</label>
                     <label class="col-md-1 col-sm-12 col-xs-6 ">Alias</label>
                     <!-- <label class="col-md-1 col-sm-12 col-xs-6 ">Description</label> -->
                     <label class="col-md-1 col-sm-6 col-xs-6 textStart" >Qty&nbsp; &nbsp; &nbsp; UOM</label>
                     <label class="col-md-1 col-sm-6 col-xs-6 ">Price</label>
                     <label class="col-md-1 col-sm-6 col-xs-12 ">GST</label>
                     <label class="col-md-1 col-sm-6 col-xs-6 ">Tax</label>
                     <!-- <label class="col-md-1 col-sm-6 col-xs-6">Total Tax</label> -->
                     <label class="col-md-1 col-sm-6 col-xs-6 ">Rcv'd <span class="required">*</span> | Invoice Oty</label>
                     <label class="col-md-1 col-sm-6 col-xs-12">Total</label>
                     <!-- <label class="col-md-1 col-sm-6 col-xs-6 ">Defected:</label> -->
                     <label class="col-md-2 col-sm-6 col-xs-6 textStart">Defected &nbsp; &nbsp;  &nbsp; Qty  &nbsp; &nbsp; &nbsp; Reason:</label>
                  </div>
                  <?php
                     foreach ($OrderMaterialDetails as $OrderMaterialDetail) {
                     	//pre($OrderMaterialDetail);
                     	$material_id = $OrderMaterialDetail->material_name_id;
                     	$materialName = getNameById('material', $material_id, 'id');
                     	     
                        $allData = ['mrnOrder' => $mrn,'OrderMaterialDetail' => $OrderMaterialDetail,'materialName' => $materialName,'i' => $i,'mrnEdit' => true,'typeGrn' => 'editGrn'];
                              echo $this->load->view('materialData',$allData);

                         $i++;
                     }
                     }
                     } ?>
                  <div class="col-sm-12 btn-row"><button style="margin-top:22px" class="btn  addButton plus-btn  edit-end-btn" type="button">Add</button></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="payment">Due Days</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select name="due_days" class="form-control col-md-7 col-xs-12 select2-width-imp" >
                           <option value="">Select Due days</option>
                           <?php
                              for ($i=0; $i<=90; $i++){
                                 //$selected = ($ledger->compny_branch_id == $brnch_name['add_id']) ? ' selected="selected"' : '';
                                 ?>
                                    <option value="<?php echo $i;?>" <?php if(!empty($mrn)){  if($mrn->due_days == $i){ ?> selected="selected" <?php } }?>><?php echo $i;?></option>
                                 <?php
                              }
                           ?>
                           </select>
            
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="payment">Payment Mode</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="payment_terms" name="payment_terms" class="form-control col-md-7 col-xs-12" placeholder="Payment Terms" value="<?php if(!empty($mrn)) echo $mrn->payment_terms;?>">
            <?php /*<select class="form-control" name="payment_terms" <?php if (!empty($mrn)) echo 'readonly'; ?>>
            <option>-- Payment --</option>
            <option value="Advance" <?php if (!empty($mrn) && $mrn->payment_terms == 'Advance') { echo 'selected';} ?>>Advance </option>
            <option value="Credit" <?php if (!empty($mrn) && $mrn->payment_terms == 'Credit') {echo 'selected';} ?>>Credit </option>
            <option value="30days" <?php if (!empty($mrn) && $mrn->payment_terms == '30days') {echo 'selected';} ?>>30days </option>
            <option value="45days" <?php if (!empty($mrn) && $mrn->payment_terms == '45days') {echo 'selected';} ?>>45days </option>
            <option value="60days" <?php if (!empty($mrn) && $mrn->payment_terms == '60days') {echo 'selected';} ?>>60days </option>
            <option value="90days" <?php if (!empty($mrn) && $mrn->payment_terms == '90days') {echo 'selected';} ?>>90days </option>
            <option value="Against_PDC" <?php if (!empty($mrn) && $mrn->payment_terms == 'Against_PDC') {echo 'selected';} ?>>Against_PDC </option>
            </select>*/?>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="material">Delivery Address <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control  address get_state_id select2-width-imp" name="delivery_address"  id="address" tabindex="-1" aria-hidden="true" required="required">
               <option value="">Select Option</option>
               <?php
                  if (!empty($mrn)) {
                     $brnch_name = getNameById_with_cid('company_address', $mrn->delivery_address, 'id','created_by_cid',$this->companyGroupId);
                  	echo '<option value="' . $mrn->delivery_address . '" selected>' . $brnch_name->location . '</option>';
                  }
                  ?>
            </select>
         </div>
      </div>
      <input type="hidden" value="" name="dilivery_add_state" id="state_id22">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="expected_Del">Received Date
            <span class="required">*</span>
         </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="expected_delivery" name="received_date" class="form-control col-md-7 col-xs-12 delivery_date" placeholder="Received Date"  value="<?php if ($mrn && !empty($mrn)) {echo $mrn->received_date;} ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="pay">Payment Date</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="payment_date" name="payment_date" class="form-control col-md-7 col-xs-12 delivery_date" placeholder="Payment date" value="<?php if (!empty($mrn)) { echo $mrn->payment_date; } ?>" readonly>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="date">Order Date</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="current_date" name="date" class="form-control col-md-7 col-xs-12" placeholder="Display the Current Date" <?php if (!empty($mrn)) echo 'readonly'; ?> value="<?php if (!empty($mrn)) {echo $mrn->date;} ?>"> 
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Choose</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <p>
               FOR:
               <input type="radio" class="flat" name="terms_delivery" id="for" value="FORPrice" checked="" required <?php if (!empty($mrn) && $mrn->terms_delivery == 'FORPrice') echo 'checked';
               else echo 'checked'; ?> />
               To be paid by customer:
               <input type="radio" class="flat" name="terms_delivery" id="exFact" value="To be paid by customer" <?php if (!empty($mrn) && $mrn->terms_delivery == 'To be paid by customer') echo 'checked'; ?> />
            </p>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group" id="freight1">
         <label class="col-md-3 col-sm-12 col-xs-12" for="freight">Freight</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="freight" name="freight" class="form-control col-md-7 col-xs-12 key-up-event" placeholder="Freight"  value="<?php if (!empty($mrn)) {echo $mrn->freight;} ?>" onkeyup="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="other_charges">Other Charges (Rs)</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="other_charges" name="other_charges" class="form-control col-md-7 col-xs-12 key-up-event" placeholder="Other Charges" <?php //if (!empty($mrn)) echo 'readonly'; ?> value="<?php  if (!empty($mrn)) {	echo $mrn->other_charges;	} ?>" onkeyup="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
         </div>
   </div>
   <div class="item form-group">
      <label class="col-md-3 col-sm-12 col-xs-12" for="grand">Grand Total</label>
      <div class="col-md-6 col-sm-12 col-xs-12">
         <input type="text" class="form-control col-md-7 col-xs-12" id="subttot" name="grand_total" placeholder="Grand Total" value="<?php if (!empty($mrn)) {
            echo $mrn->grand_total;
            } else if (!empty($mrn)) {
            echo $mrn->grand_total;
            } ?>" <?php if (!empty($mrn)) echo 'readonly'; ?> onkeypress="return float_validation(event, this.value)">
         <input type="hidden" name="total_amount_purchase" id="total_amount_purchase">
         <input type="hidden" name="total_tax" id="total_tax">
      </div>
   </div>
   <div class="item form-group">
      <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Terms and conditions </label>
      <div class="col-md-6 col-sm-12 col-xs-12">
         <textarea id="tnc" name="terms_conditions" class="form-control col-md-7 col-xs-12" placeholder="Terms And conditons" <?php if (!empty($mrn)) echo 'readonly'; ?>><?php if (!empty($mrn)) { echo $mrn->terms_conditions;} ?></textarea>
      </div>
   </div>
   <div class="item form-group">
      <label class="col-md-3 col-sm-12 col-xs-12" for="proof">Document</label>
      <div class="col-md-6 col-sm-12 col-xs-12 fields_wrap" >
         <div class="col-md-9 col-sm-11 col-xs-12"style="margin-bottom: 3%;     padding-left: 0px;">
            <input type="file" class="form-control col-md-7 col-xs-12" name="docss[]" >
         </div>
         <button class="btn edit-end-btn  add_more_docs" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
      </div>
       <?php 
       //pre($docss);

       if(!empty($docss)){ ?>
                    <div class="item form-group">
                        <label class="col-md-3 col-sm-12 col-xs-12" for="proof"></label>
                     <div class="col-md-7">
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
                                       if( $img ){
                                          echo '<div  class="col-md-4"><div class="image view view-first"><a download href="'.base_url().'assets/modules/purchase/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().$img.'" alt="image" height="100" width="100"/><i class="fa fa-download"></i></a> 
                                          <div class="mask">
                                             <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'purchase/destroyMrnDocs/'.$proofs['id'].'">
                                             <i class="fa fa-trash"></i>
                                             </a>
                                         </div></div></div>';   
                                       }
                                    }

                                  ?>
                            </div>
                    </div>
            <?php }  ?>

   </div>
   <?php
   $checkedExist = false;
         if( $mrn->purchase_type ){
            $checkedExist = true;
         }

      ?>

      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Type</label>
         <div class="col-md-6 col-sm-12 col-xs-12" >
            <div class="col-md-9 col-sm-11 col-xs-12 purchase_type" style="margin-bottom: 3%;     padding-left: 0px; ">
               <input type="radio" class="validate" name="purchase_type" value="0" <?php if($checkedExist){ if(  !$mrn->purchase_type ){ echo "checked";  } }else{ echo "checked"; } ?>  > Domestic
               <input type="radio" class="validate"  name="purchase_type" value="1" <?php  if( $mrn->purchase_type ){ echo "checked";  }  ?>> Import
            </div>
         </div>
      </div>
         <div class="item form-group">
      <label class="col-md-3 col-sm-12 col-xs-12" for="rating">Ratings</label>
      <div class="col-md-6 col-sm-12 col-xs-12">
         <div class="star-rating"><!-- <s></s> -->
              <?php 
               $countEmptyStar = 5-$mrn->rating;
               $i = 1;
               for ($i=1; $i <= 5 ; $i++) { 
                     if( $i <= $mrn->rating ){
                        echo '<s class="active"></s>';      
                     }else{
                        echo '<s></s>';
                     }
               }?> 
         </div>
         <!--<div class="show-result">No stars selected yet.</div>-->
         <input type="hidden" name="rating" id="hidden_rating" class="form-control col-md-7 col-xs-12" placeholder="Rating" value="<?= $mrn->rating??0 ?>">
      </div>
   </div>
   <div class="item form-group">
      <label class="col-md-3 col-sm-12 col-xs-12" for="rating"></label>
      <div class="col-md-6 col-sm-12 col-xs-12">
         <input type="hidden" name="rate" id="hide_rat" class="form-control col-md-7 col-xs-12" placeholder="Rating" value="<?php if(!empty($mrn)) { echo "selected &nbsp;&nbsp;".$mrn->rating."&nbsp; &nbsp; Stars"; }  ?>">
      </div>
   </div>
   <div class="item form-group">
      <label class="col-md-3 col-sm-12 col-xs-12" for="comment">Comments</label>
      <div class="col-md-6 col-sm-12 col-xs-12">
         <!--<textarea id="comment" name="comments" class="form-control col-md-7 col-xs-12" placeholder="comments"><?php //if(!empty($mrn)){ echo $mrn->comments;}
            ?></textarea>-->
         <textarea id="comment" name="comments" class="form-control col-md-7 col-xs-12" placeholder="comments"><?php if(!empty($mrn)) {echo $mrn->comments; } 
            ?></textarea>
      </div>
   </div>



   </div>
</div>
</div>
   </div>
   
   </div>
   <hr>
   <div class="form-group">
      <div class="col-md-12 col-xs-12">
         <center>
            <!--a class="btn  btn-default" onclick="location.href='<?php //echo //base_url(); ?>purchase/mrn'">Close</a-->
            <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
            <button type="reset" class="btn edit-end-btn ">Reset</button>
            <input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">
            <button id="send" type="submit" class="btn edit-end-btn">Submit</button>
         </center>
      </div>
   </div>
</form>
<!-- /page content -->
<!---------------------------------------------------Add quick material code----------------------------------------------->

<?php //$this->load->view('addQuickMaterial',$materials); ?>
<!-- Quick add supplier -->
<?php $this->load->view('addQuickSupplier') ?>
<!-- Quick add lot  -->
<?php $this->load->view('addQuickLot') ?>