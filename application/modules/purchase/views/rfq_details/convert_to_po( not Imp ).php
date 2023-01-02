<?php
   $last_id = getLastTableId('purchase_order');
   $rId = $last_id + 1;
   $poCode = 'PUR_' . rand(1, 1000000) . '_' . $rId;
   
   
   /*    pre($poCreate);  
   die(); */
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   ?>
<form method="post" class="form-horizontal" id="purchaseIndentForm" style="padding:2%;" action="<?php echo base_url(); ?>purchase/saveRFQOrder" enctype="multipart/form-data" novalidate="novalidate">
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
   <input type="hidden" name="convert_RFQ_to_PO" value="convert_po" >
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
            <input  id="Purchase_code" class="form-control col-md-7 col-xs-12" name="order_code" placeholder="ABC239894" required="required" type="text" value="<?php echo $poCode; ?>" readonly>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="company_unit">Company Unit<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select disabled class="form-control  select2 address" required="required" name="company_unit">
               <option value="">Select Option</option>
               <?php
                  if(!empty($poCreate)){
                  	$getUnitName = getNameById('company_address',$poCreate->company_unit,'compny_branch_id');
                  	//pre($getUnitName);
                  	echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                  	}
                  ?>
            </select>
			<input type="hidden" name="company_unit" value="<?php echo $getUnitName->compny_branch_id; ?>">

         </div>
      </div>
   </div>
  <!--  <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
     <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="supplier_name">Supplier Name <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select disabled class="supplierName form-control col-md-2 col-xs-12 selectAjaxOption select2 add_more_Supplier" id="supplier_name" required="required" name="supplier_name" data-id="supplier" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onchange="getSupplierAddress(event,this)">
               <option value="">Select Supplier</option>
               <?php
                  if (!empty($poCreate)) {
                  	$supplier_name_id = getNameById('supplier', $poCreate->preffered_supplier, 'id');
                  
                  	echo '<option value="' . $poCreate->preffered_supplier . '" selected  data-id="' . $supplier_name_id->address . '">' . $supplier_name_id->name . '</option>';
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
            <textarea  readonly name="address" class="form-control col-md-7 col-xs-12 requrid_class" placeholder="Display when supplier is selected from above"><?php if ($poCreate && !empty($poCreate) && !empty($poCreate)) {$supplier_name_id = getNameById('supplier', $poCreate->supplier_name, 'id');
               echo $supplier_name_id->address;} ?></textarea>
            <span class="spanLeft control-label"></span>
         </div>
      </div>
   </div>-->
   <hr>
   <div class="bottom-bdr"></div>
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
               <?php if (empty($order) && empty($poCreate)) { 
                  ?>
               <div class="col-sm-12  col-md-12 label-box mobile-view2">
			      <label class="col-md-1 col-sm-12 col-xs-12">M.Type <span class="required">*</span></label>
                  <label class="col-md-1 col-sm-12 col-xs-12">M. Name <span class="required">*</span></label>
                  <label class="col-md-2 col-sm-12 col-xs-6">Description</label>
                  <label class="col-md-2 col-sm-6 col-xs-6" >Quantity&nbsp;&nbsp;&nbsp; /UOM</label>
                  <label class="col-md-1 col-sm-6 col-xs-6">price</label>
                  <label class="col-md-1 col-sm-6 col-xs-12">Sub Total</label>
                <label class="col-md-1 col-sm-6 col-xs-12">GST</label>
                  <label class="col-md-1 col-sm-6 col-xs-12">Sub Tax</label>
                  <label class="col-md-2 col-sm-6 col-xs-6" style="border-right: 1px solid #c1c1c1 !important;">Total</label>
               </div>
               <div class="well mobile-view" id="chkIndex_1">
			   <div class="col-md-1 col-sm-12 col-xs-12 form-group">
			   <label>MAT.Type<span class="required">*</span></label>
					   <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
						  <option value="">Select Option</option>   
					   </select>
				</div>
                  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                     <label>M. Name <span class="required">*</span></label>
                     <select disabled class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)">
                        <option value="">Select Option</option>
                     </select>
                  </div>
                  <input type="hidden" value="1" name="po_or_not">
                  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                     <label>Description</label>
                     <textarea readonly id="description" name="description[]" class="form-control col-md-7 col-xs-12 description"></textarea>					
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                     <label style="float:left; width:100%">Quantity &nbsp; &nbsp; UOM</label>
                     <input readonly type="text" name="quantity[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
                     <input type="text" id="uom" name="uom[]" placeholder="Uom" class="form-control col-md-7 col-xs-12 uom" readonly>
                  </div>
                  <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>Price</label>
                     <input readonly type="text" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" required="required">
                  </div>
                  <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>Sub Total</label>
                     <input readonly type="text" name="sub_total[]" placeholder="sub total" class="form-control col-md-7 col-xs-12 key-up-event" min="0" readonly>
                  </div>
               <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>GST</label>
                     <input readonly type="text" name="gst[]" placeholder="gst" class="form-control col-md-7 col-xs-12 key-up-event gst_tax" id="gst_tax" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"  min="0" onkeypress="return float_validation(event, this.value)">
                  </div>
                  <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>Sub Tax</label>
                     <input readonly type="text" name="sub_tax[]" placeholder="tax" class="form-control col-md-7 col-xs-12 key-up-event" min="0" readonly>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                     <label>Total</label>
                     <input readonly style="border-right: 1px solid #c1c1c1 !important;" type="text" name="total[]" placeholder="total" class="form-control col-md-7 col-xs-12 key-up-event"  min="0" readonly>
                  </div>
                  <button style="margin-right:0px; margin-top: 0px;" class="btn   btn-danger plus-btn check_matt " type="button"> <i class="fa fa-minus "></i></button>
               </div>
               <div class="col-sm-12 btn-row"><button class="btn edit-end-btn addButton col-md-1 col-sm-12 col-xs-12 form-group" type="button" align="right"><i class="fa fa-plus"></i></button></div>
               <?php } else if (!empty($poCreate) && $poCreate->material_name != '') {
                  $poCreateDataDetail = json_decode($poCreate->material_name);
                  
                  if (!empty($poCreateDataDetail)) {
                  	$i =  1;
                  	?>
               <div class="col-sm-12  col-md-12 label-box mobile-view2">
			      <label class="col-md-1 col-sm-12 col-xs-12">M.Type <span class="required">*</span></label>
                  <label class="col-md-1 col-sm-12 col-xs-12">M. Name <span class="required">*</span></label>
                  <label class="col-md-2 col-sm-12 col-xs-6">Description</label>
                  <label class="col-md-2 col-sm-6 col-xs-6" >Quantity&nbsp;&nbsp;&nbsp; /UOM</label>
                  <label class="col-md-1 col-sm-6 col-xs-6">Piece Price</label>
                  <label class="col-md-1 col-sm-6 col-xs-12">Sub Total</label>
               <label class="col-md-1 col-sm-6 col-xs-12">GST</label>
                  <label class="col-md-1 col-sm-6 col-xs-12">Sub Tax</label>
                  <label class="col-md-2 col-sm-6 col-xs-6" style="border-right: 1px solid #c1c1c1 !important;">Total</label>
               </div>
               <?php
                  foreach ($poCreateDataDetail as $poCreate_Data_Details) {
                  	if($poCreate_Data_Details->remaning_qty != 0){
                  	$material_name_id = getNameById('material', $poCreate_Data_Details->material_name_id, 'id');
                  	
                  	///pre($material_name_id);
                  	?>
               <div class="well <?php if($i==1){ echo 'edit-row1 mobile-view scend-tr ';}else{ echo 'scend-tr mobile-view';}?>" id="chkWell_<?php echo $i; ?>" >
			   <div class="col-md-1 col-sm-12 col-xs-6 form-group">
				   <label class="col-md-2 col-sm-12 col-xs-12">Material Type</label>
				   <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
					  <option value="">Select Option</option>  
					   <?php
						 if(!empty($poCreate_Data_Details->material_type_id)){
							$material_type_id1 = getNameById('material_type',$poCreate_Data_Details->material_type_id,'id');
							echo '<option value="'.$poCreate_Data_Details->material_type_id.'" selected>'.$material_type_id1->name.'</option>';
							}
						 ?> 
				   </select>                               
				</div>
                  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                     <label>M. Name <span class="required">*</span></label>
                     <select disabled class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $poCreate->material_type_id;?> AND status=1">
                        <option value="">Select Option</option>
                        <?php
                           echo '<option value="' . $poCreate_Data_Details->material_name_id . '" selected>' . $material_name_id->material_name . '</option>';
                           
                           ?>
                     </select>
					   <input type="hidden" name="material_name[]" value="<?php echo $poCreate_Data_Details->material_name_id; ?>">
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Description</label>
                     <textarea readonly id="description" name="description[]" class="form-control col-md-7 col-xs-12 description"><?php if ($poCreate && !empty($poCreate)) {	echo $poCreate_Data_Details->description;	} ?></textarea>			
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                     <label style="float:left; width:100%">Quantity &nbsp; &nbsp; UOM</label>
                     <input readonly type="text" id="quantity_<?php echo $poCreate_Data_Details->material_name_id;?>" name="quantity[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event quantity" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" value="<?php if ($poCreate && !empty($poCreate)) { echo $poCreate_Data_Details->remaning_qty;} ?>"  min="0" onkeypress="return float_validation(event, this.value)">
                     <input type="hidden" value="1" name="po_or_not">
                     <input readonly type="text" id="uom" name="uom1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12 uom" value="<?php 
                        if ($poCreate && !empty($poCreate)) {
                        $ww =  getNameById('uom', $poCreate_Data_Details->uom,'id');
                        $uom = !empty($ww)?$ww->ugc_code:'';
                        echo $uom;
                        }?>" readonly>
                     <input type="hidden" name="uom[]" readonly value="<?php echo $poCreate_Data_Details->uom; ?>">
                     <input type="hidden" id="description_check" name="description_check[]" placeholder="description_check" class="form-control col-md-7 col-xs-12" value="<?php if ($poCreate && !empty($poCreate)) { echo $poCreate_Data_Details->description;} ?>" readonly>
                  </div>
                  <?php $quantity =0;
                     $quantity =  $poCreate_Data_Details->remaning_qty;
						$minprice = GetMinExpectedPrice('purchase_rfq',$poCreate->id,$poCreate_Data_Details->material_name_id);
                     $sub_total = $minprice*$quantity;
                     	//pre($ExpectedAmount);
                                        ?>
                  <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>Piece Price</label>
                     <input readonly type="text" name="price[]" id="price_<?php echo $poCreate_Data_Details->material_name_id;?>"  placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" value="<?php if($poCreate && !empty($poCreate)){ echo $minprice;} ?>"  min="0" onkeypress="return float_validation(event, this.value)" required="required">
                  </div>
                  <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>Sub Total</label>
                     <input readonly type="text" name="sub_total[]" id="sub_total_<?php echo $poCreate_Data_Details->material_name_id;?>" placeholder="sub total" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php if($poCreate && !empty($poCreate)){ echo  $sub_total ;} ?>"  min="0">
                  </div>
                  <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>GST</label>
                     <input type="text" name="gst[]" placeholder="gst" class="form-control col-md-7 col-xs-12 key-up-event gst_tax" id="gst_tax" value="<?php if (!empty($material_name_id)) echo $material_name_id->tax; ?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"  min="0" onkeypress="return float_validation(event, this.value)">
                  </div>
                  <?php
                     if(!empty($material_name_id) && $material_name_id->tax != ''   ){
                     	$subtax = $sub_total * $material_name_id->tax/100;
                     }else{
                     	$subtax = 0;
                     }
                     
                     $total = $sub_total + $subtax;
                     
                     ?>
                  <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>Sub Tax</label>
                     <input readonly type="text" name="sub_tax[]" placeholder="tax" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php echo $subtax; ?>"  min="0">
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                     <label style="border-right: 1px solid #c1c1c1 !important;">Total</label>
                     <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="total[]" placeholder="total" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php echo $total; ?>"  min="0">
                  </div>
                  <button style="margin-right:0px; margin-top: 0px;" class="btn   btn-danger plus-btn check_matt " type="button"> <i class="fa fa-minus "></i></button>
                  <input type="hidden" value="" name="remove_mat[]" class="for_hide_val">
               </div>
               <?php $i++;
                  }elseif($poCreate_Data_Details->remaning_qty == 0){ ?>
               <input type="hidden" value="<?php echo $poCreate_Data_Details->material_name_id;?>" name="remove_mat" >
               <?php	}
                  }
                  }
                  }
                  
                  ?>
               <div class="col-sm-12 btn-row"><button class="btn plus-btn   edit-end-btn addButton" type="button"  disabled >Add</button></div>
            </div>
         </div>
      </div>
   </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <h3 class="Material-head" style="margin-bottom: 30px;">
      Selected Supplier (By RFQ)
      <hr>
   </h3>
   <div class="item form-group">
      <div class=" input_holder middle-box col-md-12" >
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Supplier Name</th>
                  <th>GSTIN</th>
                  <th>Contact person</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Delivery Date</th>
               </tr>
            </thead>
            <tbody id="table_data1">
               <?php if(!empty($poCreate->rfq_supp)){
                  $rfq_supp_ids = json_decode($poCreate->rfq_supp, true);	
                  
                  for($i=0;$i<count($rfq_supp_ids);$i++){
                    $supplier = getNameById('supplier', $rfq_supp_ids[$i],'id'); 
                    $supplierContactDetail =json_decode($supplier->contact_detail);
                  $GetRFQSupplier = GetRFQSupplier('purchase_rfq',$poCreate->id,$supplier->id);
                    echo '<tr class="parent"  style="background-color:#ffe7db" title="Click to expand/collapse"  id="row_'.$supplier->id.'" style="cursor: pointer;">
                     <td class="details-control"><i class="fa fa-plus fa-clickable"></i></td>
                  <td>'.$supplier->name.'</td>
                  <td>'.$supplier->gstin.'</td>	
                  <td>'.$supplierContactDetail[0]->contact_detail.'</td>	
                  <td>'.$supplierContactDetail[0]->email.'</td>							
                  <td>'.$supplier->address.'</td>
                  <td>'.$GetRFQSupplier->supplier_expected_deliv_date.'</td>
                  <input type="hidden" name="supplier_details['.$supplier->id.']" value="" id="supplier_details_'.$supplier->id.'">
                    </tr>';
                     echo '<tr id="ProTable_'.$supplier->id.'" class="child-row_'.$supplier->id.'"  >
                  <td colspan="6">
                  <table class="table table-bordered" style="padding-left:50px;">
                  	<thead>
                  	   <tr>
                  <th></th>
                  		  <th>Material Type</th>
                  		  <th>Material Name</th>
                  		  <th>Description</th>
                  		  <th>Quantity</th>
                  		  <th>UOM</th>
                  		  <th>Expected Amount</th> 
                  	   </tr>
                  	</thead>
                  	<tbody>';
                   if(!empty($poCreate) && $poCreate->material_name !=''){ 
                  		$product_info = json_decode($poCreate->material_name);
                  		if(!empty($product_info)){
                  			foreach($product_info as $productInfo){
								 $mat_type_id=getNameById('material_type',$productInfo->material_type_id,'id'); 
				                 if (!empty($mat_type_id)) { $mattype_name = $mat_type_id->name;	}else{ $mattype_name =  $matriealtype_name; }
                  				$material_id = $productInfo->material_name_id;
                  				$materialName = getNameById('material',$material_id,'id');
                  				$ww =  getNameById('uom', $productInfo->uom,'id');
                  				$uom = !empty($ww)?$ww->ugc_code:'';
                  				$ExpectedAmount = GetExpectedPriceOFSupplier('purchase_rfq',$poCreate->id,$supplier->id,$material_id);
                  if(!empty($ExpectedAmount->supplier_expected_amount)){
                  $arrayOfPrices[$material_id][] = $ExpectedAmount->supplier_expected_amount;
                  $min_price= min($arrayOfPrices[$material_id]);
                  $checked = ($min_price == $ExpectedAmount->supplier_expected_amount) ? 'checked' : '';
                                  $setchecked = "";
                                  if($ExpectedAmount->selected_status == 1){	
                  $Matarray[] =  $ExpectedAmount->product_id;
                  $setchecked =  'checked';
                  
                  
                  }
                  if(in_array($ExpectedAmount->product_id,$Matarray)){
                                       $checked  = '';
                  }
                  echo '<tr>
                  <td><input disabled type="radio" class="pro_id" name="pro_id_'.$material_id.'" value="'.$supplier->id.'_'.$material_id.'_'.$ExpectedAmount->supplier_expected_amount.'_'.$ExpectedAmount->id.'" '.(!empty($setchecked)?$setchecked:$checked).'></td>
                  						<td>'.$mattype_name.'</td>
                  						<td>'.$materialName->material_name.'</td>
                  						<td>'.$productInfo->description.'</td>	
                  						<td>'.$productInfo->quantity.'</td>	
                  						<td>'.$uom.'</td>
                  						<td>'.$ExpectedAmount->supplier_expected_amount.'</td>
				'.((!empty($setchecked) || !empty($checked))?'<input type="hidden" name="pro_id_'.$material_id.'" value="'.$supplier->id.'_'.$material_id.'_'.$ExpectedAmount->supplier_expected_amount.'_'.$ExpectedAmount->id.'">':'').'
			
                  					</tr>';
                  }
                  			 }									 
                  		}
                  	 }
                  	echo '</tbody> 
                    </table></td></tr>';
                              } 
                  } ?>
            </tbody>
         </table>
      </div>

   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="payment">Payment Mode</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="payment_terms" name="payment_terms" class="form-control col-md-7 col-xs-12" placeholder="Payment Terms" value="">
            <?php /*<select class=" form-control" name="payment_terms">
               <option>-- Payment --</option>
               <option value="Advance">Advance
               </option>
               <option value="Credit">Credit </option>
               <option value="30days">30days </option>
               <option value="45days">45days </option>
               <option value="60days">60days </option>
               <option value="90days">90days </option>
               <option value="Against_PDC">Against_PDC </option>
               </select>*/?>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="material">Delivery Address</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select  class="form-control  address get_state_id" name="delivery_address"  >
               <option value="">Select Option</option>
               <!-- onchange="getAddress(event,this)"-->
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
            <input type="text" id="delivery_date" name="expected_delivery_date" class="form-control col-md-7 col-xs-12 delivery_date" placeholder="Expected Delivery Date" value="<?php if($poCreate && !empty($poCreate) ){ echo $poCreate->required_date;} ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="date">Order Date </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="current_date" name="date" class="form-control col-md-7 col-xs-12" placeholder="Display the Current Date" value="<?php //if($poCreate && !empty($poCreate)){ echo $order->date;} 
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
         <?php /*<div class="col-md-9 col-sm-9 col-xs-12 input_charges_wrap">
            <div class="col-md-12 input_charges_details charges_form"  >
            	<div class="testDh" style="padding-left: 22px;">
            		<div class="col-md-2 item form-group">
            			<label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Particulars.</label>
            			<select class="itemName form-control selectAjaxOption select2 Add_charges_id" name="particular_charges[]" data-id="charges_lead" data-key="id" data-fieldname="particular_charges" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND charges_for = 1" width="100%">
         <option value="">Select</option>
         </select> 	
      </div>
      <div class="col-md-1 item form-group">
         <label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Charges.</label>
         <input type="text" class="form-control col-md-1 ad_rm_readonly charges_added" name="charges_added[]" value="" >
         <span class="aply_btn"></span>
         <input type="hidden" value="" id="total_tax_slab">
      </div>
      <div class="col-md-1 item form-group sgst_amt1">
         <label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="sgstamount">SGST</label>
         <input type="text" class="form-control col-md-1 ad_rm_readonly sgst_amt"  name="sgst_amt[]" value="" readonly>
      </div>
      <div class="col-md-1 item form-group cgst_amt1">
         <label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="cgst Amount">CGST </label>
         <input type="text" class="form-control col-md-1 ad_rm_readonly cgst_amt" name="cgst_amt[]" value="" readonly>
      </div>
      <div class="col-md-1 item form-group igst_amt1">
         <label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="igstamount">IGST </label>
         <input type="text" class="form-control col-md-1 ad_rm_readonly igst_amt" name="igst_amt[]"  value="" readonly >
      </div>
      <div class="col-md-2 item form-group">
         <label class="col-md-12 col-sm-12 col-xs-12  for_discount_hide" for="addtaxamount">Amt. with Tax</label>
         <input type="text" class="form-control col-md-1 amt_with_tax ad_rm_readonly" name="amt_with_tax[]" value="" readonly>
      </div>
      <button class="btn edit-end-btn add_charges_detail_button plus-btn1" type="button"><i class="fa fa-plus"></i></button>
   </div>
   </div>
   </div>*/?>
   </div>
   <div class="item form-group">
      <label class="col-md-3 col-sm-12 col-xs-12" for="grand">Grand Total</label>
      <div class="col-md-6 col-sm-12 col-xs-12">
         <input type="text" class="form-control col-md-7 col-xs-12" id="subttot" readonly name="grand_total" placeholder="Grand Total" readonly value="0">
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
            echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/purchase/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().$img.'" alt="image" height="100" width="100"/><i class="fa fa-download"></i></a>
               <div class="mask">
                  <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'purchase/delete_doccs/'.$proofs['id'].'/'.$indents->id.'">
                  <i class="fa fa-trash"></i>
                  </a>
              </div></div></div>';
            }
            ?>
      </div>
   </div>
   <?php } ?>
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
                  <!--<select name="material_type_id"  width="100%" id="material_type_id" class="form-control">
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
                     <select  class="uom selectAjaxOption select2 form-control" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php 	echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0 AND active_inactive = 1">
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
                     <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible acc_group_id" required name="supp_account_group_id" data-id="account_group" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true"></select>
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
                     <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" id='cntry' required name="country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this)"></select>
                     <span id="contry"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">State<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible state_id" name="state" required width="100%" tabindex="-1" aria-hidden="true" onchange="getCity(event,this)"></select>
                     <span id="state1"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">City<span class="required">*</span></label>
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
               <button type="button" class="btn btn-default close_sec_model">Close</button>
               <button id="add_suplier_btn_id" type="button" class="btn edit-end-btn">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>
<script></script>