<form method="post" class="form-horizontal" enctype="multipart/form-data" id="mrn-form" novalidate="novalidate" action="<?php echo base_url(); ?>purchase/saveMRN">
	<input type="hidden" name="id" value="<?php if ($mrn && !empty($mrn)) {
												echo $mrn->id;
											} ?>">
	<input type="hidden" name="po_id" value="<?php if ($mrn && !empty($mrn)) {
													echo $mrn->id;
												} else if ($mrn && !empty($mrn)) {
													echo $mrn->po_id;
												} ?>">
												
		<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

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
			<label class="col-md-3 col-sm-12 col-xs-12" for="Bill No">Invoice No.</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" name="bill_no" class="form-control col-md-7 col-xs-12" placeholder="Invoice No" value="<?php if ($mrn && !empty($mrn)) {echo $mrn->bill_no;} ?>" required="required">
			</div>
		</div>
		<div class=" item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="Bill No">Invoice Date.</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" name="bill_date" class="form-control col-md-7 col-xs-12 bill_datee" placeholder="Invoice Date" value="<?php if ($mrn && !empty($mrn)) {echo $mrn->bill_date;} ?>" required="required">
			</div>
		</div>
		<div class="item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="company_unit">Company Unit<span class="required">*</span></label>
			<div class="col-md-6 col-sm-12 col-xs-12">
			<select class="form-control col-md-2 col-xs-12 selectAjaxOption select2" required="required" name="company_unit" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
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
</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">		
		
		<div class="item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="supplier_name">Supplier Name <span class="required">*</span></label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<select class="supplierName form-control col-md-2 col-xs-12 selectAjaxOption select2 requrid_class add_more_Supplier" id="supplier_name" required="required" name="supplier_name" data-id="supplier" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status=1" onchange="getSupplierAddress(event,this)">
					<option value="">Select Supplier</option>
					<?php
					if (!empty($mrn)) {
						$supplier_name_id = getNameById('supplier', $mrn->supplier_name, 'id');
						echo '<option value="' . $mrn->supplier_name . '" selected  data-id="' . $supplier_name_id->address . '">' . $supplier_name_id->name . '</option>';
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
		<label class="col-md-3 col-sm-12 col-xs-12" for="quality">
        <input type="checkbox" name="quality_check"/>Quality Check</label>		
	</div>
</div>	
<hr>	
<div class="bottom-bdr"></div>


	<!--<div class="heading">
		<h4>Material Details </h4>
		<div class="totalBudget" style="color:red;"></div>
		<div class="budgetSpent" style="color:green;"></div>
	</div>-->
<h3 class="Material-head" style="margin-bottom: 30px;">Material Details<hr></h3>	
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">	
	<div class="item form-group">
		<label class="col-md-3 col-sm-12 col-xs-12" for="material">Material Type <span class="required">*</span></label>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
				<option value="">Select Option</option>
				<?php
				if (!empty($mrn)) {
					$material_type_id = getNameById('material_type', $mrn->material_type_id, 'id');
					echo '<option value="' . $mrn->material_type_id . '" selected>' . $material_type_id->name . '</option>';
				}
				?>
			</select>
		</div>
	</div>
</div>

	
		<div class="item form-group ">
			<div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
				<div class="">
					<div class=" goods_descr_wrapper">						
						<div class="col-md-12 input_material middle-box for-bdr ">
							<?php if (empty($mrn)) { ?>
                               <div class="col-sm-12  col-md-12 label-box mobile-view2">
							         <label class="col-md-1 col-sm-12 col-xs-6 ">M. Name <span class="required">*</span></label>
									 <label class="col-md-1 col-sm-12 col-xs-6">Description</label>
									 <label class="col-md-2 col-sm-6 col-xs-6" >Quantity&nbsp;&nbsp;&nbsp; UOM</label>
									 <label class="col-md-1 col-sm-6 col-xs-6">price</label>
									 <label class="col-md-1 col-sm-6 col-xs-12">GST</label>
									 <label class="col-md-1 col-sm-6 col-xs-6">Tax</label>
									 <label class="col-md-1 col-sm-6 col-xs-6">Rcv'd Qty</label>
									 <label class="col-md-1 col-sm-6 col-xs-12">Total</label>
									 <label class="col-md-1 col-sm-6 col-xs-6">Defected:</label>
									 <label class="col-md-2 col-sm-6 col-xs-6" style="border-right: 1px solid #c1c1c1 !important;">Def Reason</label>
							   </div>
								<div class="well mobile-view" id="chkIndex_1" style="overflow:auto; border: 1px solid #c1c1c1 !important;">
									<div class="col-md-1 col-sm-12 col-xs-6 form-group">
									<label>M. Name <span class="required">*</span></label>
										<select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)">
											<option value="">Select Option</option>

										</select>
									</div>
									<input type="hidden" value="1" name="mrn_or_not">
									<div class="col-md-1 col-sm-12 col-xs-6 form-group">
									<label>Description</label>
										<textarea id="description" rows="1" name="description[]" class="form-control col-md-7 col-xs-12 description"></textarea>					
									</div>	
									<div class="col-md-2 col-sm-6 col-xs-6 form-group">
									<label style="float:left; width:100%">Quantity&nbsp;&nbsp;&nbsp; UOM</label>
										<input type="text" id="quantity" name="quantity[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
										<input type="text" name="uom1[]" id="uom" placeholder="Uom" class="form-control col-md-7 col-xs-12 uom1" readonly value="">
										<input type="hidden" name="uom[]" readonly class="uom">
									</div>

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
									<div class="col-md-1 col-sm-6 col-xs-6 form-group">
									<label>Rcv'd Qty</label>
										<input type="text" name="received_quantity[]" placeholder="Received Quantity" class="form-control col-md-12 col-xs-12 key-up-event" onchange="keyupFunction(event,this)" onkeyup="keyupFunction(event,this)"  onkeypress="return float_validation(event, this.value)">
									</div>
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									<label>Total</label>
										<input type="text" name="total[]" placeholder="total" class="form-control col-md-12 col-xs-12 key-up-event" min="0" readonly>
										<input type="hidden" value="" name="amount_with_tax[]">
									</div>
									<div class="col-md-1 col-sm-6 col-xs-6 form-group">	
										<label class="col-md-12 ">Defected:</label>
										<input style="margin-left: 36px;margin-top: 15px;" type="checkbox" class="flat defected"/> 
										<input type="hidden" name="defected[]" class="defectedVal" value=""/> 
									</div>
									<div class="col-md-2 col-sm-6 col-xs-6 form-group defected_reason_div hideDiv">
									<label>Def Reason</label>
										<textarea  style="border-right: 1px solid #c1c1c1 !important;" name="defected_reason[]" rows="1" class="form-control col-md-7 col-xs-12 defected_reason" placeholder="Defected Reason" ></textarea>
									</div>
									<button style="margin-top:22px" class="btn plus-btn btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button>
								</div>
							<?php } ?>
							<div class="col-sm-12 btn-row"><button class="btn  addButton plus-btn  edit-end-btn" type="button" align="right">Add</button></div>
							<?php
							//if(!empty($mrnOrder) && $mrnOrder->material_name !='' && (array_key_exists("po_id",$mrnOrder)  &&  $mrnOrder->po_id !=0)){ 
							if (!empty($mrn) && $mrn->material_name != '') {
								echo " ";
								$OrderMaterialDetails = json_decode($mrn->material_name);
								if (!empty($OrderMaterialDetails)) {
									$i =  1;
									?>
									<div class="col-sm-12  col-md-12 label-box mobile-view2">
							         <label class="col-md-1 col-sm-12 col-xs-6 ">M. Name <span class="required">*</span></label>
									 <label class="col-md-1 col-sm-12 col-xs-6 ">Description</label>
									 <label class="col-md-2 col-sm-6 col-xs-6 " >Quantity&nbsp;&nbsp;&nbsp; UOM</label>
									 <label class="col-md-1 col-sm-6 col-xs-6 ">price</label>
									 <label class="col-md-1 col-sm-6 col-xs-12 ">GST</label>
									 <label class="col-md-1 col-sm-6 col-xs-6 ">Tax</label>
									 <label class="col-md-1 col-sm-6 col-xs-6 ">Rcv'd Qty</label>
									 <label class="col-md-1 col-sm-6 col-xs-12">Total</label>
									 <label class="col-md-1 col-sm-6 col-xs-6 ">Defected:</label>
									 <label class="col-md-2 col-sm-6 col-xs-6 " style="border-right: 1px solid #c1c1c1 !important;">Def Reason</label>
							   </div>
									<?php
									foreach ($OrderMaterialDetails as $OrderMaterialDetail) {
										//pre($OrderMaterialDetail);
										$material_id = $OrderMaterialDetail->material_name_id;
										$materialName = getNameById('material', $material_id, 'id');
										?>
										<div class="well  <?php if($i==1){ echo 'scend-tr mobile-view';}else{ echo 'scend-tr mobile-view';}?>" id="chkWell_<?php echo $i; ?>" style="overflow:auto;border-bottom: 1px solid #c1c1c1 !important;border-right: 1px solid #c1c1c1 !important;">
											<div class="col-md-1 col-sm-12 col-xs-6 form-group">
											<label>M. Name </label>
												<select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)"  data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $mrn->material_type_id;?> AND status=1"  readonly>
													<option value="">Select Option</option>
													<?php
													echo '<option value="' . $OrderMaterialDetail->material_name_id . '" selected>' . $materialName->material_name . '</option>';
													?>
												</select>
											</div>
											<div class="col-md-1 col-sm-12 col-xs-6 form-group">
											<label>Description</label>
												<textarea id="description" rows="1" name="description[]" class="form-control col-md-7 col-xs-12 description"><?php if ($mrn && !empty($mrn)) {echo $OrderMaterialDetail->description;} ?></textarea>					
											</div>	
											
											
											
											<div class="col-md-2 col-sm-6 col-xs-6 form-group">
											<label style="float:left; width:100%">Quantity&nbsp;&nbsp;&nbsp; UOM</label>
													<input type="text" id="quantity" name="quantity[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" value="<?php if ($mrn && !empty($mrn)) {echo $OrderMaterialDetail->quantity;} ?>">
													<input type="text" name="uom1[]" id="uom" placeholder="Uom" class="form-control col-md-7 col-xs-12 uom1" value="<?php //if ($mrn && !empty($mrn)) {echo $OrderMaterialDetail->uom;} 



												$ww =  getNameById('uom', $OrderMaterialDetail->uom,'id');
												$uom = !empty($ww)?$ww->ugc_code:'';

												echo $uom;

													?>" readonly>
													<input type="hidden" value="1" name="mrn_or_not">



													<input type="hidden" name="uom[]" readonly class="uom" value="<?php echo $OrderMaterialDetail->uom;  ?>">
											</div>
											
											
											<div class="col-md-1 col-sm-6 col-xs-6 form-group">
											<label>Price</label>
												<input type="text" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" value="<?php if ($mrn && !empty($mrn)) {	echo $OrderMaterialDetail->price;} ?>" min="0" onkeypress="return float_validation(event, this.value)">
											</div>
											
												<input type="hidden" name="sub_total[]" placeholder="sub total" class="form-control col-md-7 col-xs-12 key-up-event"value="<?php if ($mrn && !empty($mrn)) {echo $OrderMaterialDetail->sub_total;} ?>">
												<input type="hidden" value="" name="sub_total_amt_purchse_bill[]">
											
											<div class="col-md-1 col-sm-6 col-xs-12 form-group">
											<label>GST</label>
												<input type="text" name="gst[]" placeholder="gst" class="form-control col-md-7 col-xs-12 key-up-event gst_tax" id="gst_tax" value="<?php if (!empty($mrn)) { echo $OrderMaterialDetail->gst;} ?>" min="0" onkeypress="return float_validation(event, this.value)">
											</div>
											<div class="col-md-1 col-sm-6 col-xs-6 form-group">
											<label>Sub Tax</label>
												<input type="text" name="sub_tax[]" placeholder="tax" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php if ($mrn && !empty($mrn)) {echo $OrderMaterialDetail->sub_tax;} ?>" min="0">
											</div>
											<div class="col-md-1 col-sm-6 col-xs-6 form-group">
											<label>Rcv'd Qty</label>
												<input type="text" name="received_quantity[]" placeholder="Received Quantity" class="form-control col-md-12 col-xs-12 key-up-event"  onchange="keyupFunction(event,this)" onkeyup="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
											</div>
											<div class="col-md-1 col-sm-6 col-xs-12 form-group">
											<label>Total</label>
												<input type="text" name="total[]" placeholder="total" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php if ($mrn && !empty($mrn)) { echo $OrderMaterialDetail->total; } ?>" min="0">
												<input type="hidden" value="" name="amount_with_tax[]">
											</div>
											<div class="col-md-1 col-sm-6 col-xs-6 form-group">
																							
												<label style="float:left; width:100%">Defected:</label>
												<input style="margin-left: 36px;margin-top: 15px;" type="checkbox" class="flat defected" <?php if($OrderMaterialDetail->defected == 1){echo 'checked';} ?>/> 
												<input type="hidden" name="defected[]" class="defectedVal" value=""/> 
											</div>
											<div class="col-md-2 col-sm-6 col-xs-6 form-group <?php echo ($OrderMaterialDetail->defected == 1)?'':'hideDiv'; ?> defected_reason_div">
											<label>Def Reason</label>
												<textarea name="defected_reason[]" class="form-control col-md-7 col-xs-12 defected_reason" placeholder="Defected Reason"><?php echo $OrderMaterialDetail->defected_reason ; ?></textarea>
											</div>
											
												<button style="margin-top:22px" class="btn plus-btn btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button>
											
										</div>
										<?php $i++;
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
		<label class="col-md-3 col-sm-12 col-xs-12" for="material">Delivery Address</label>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<select class="form-control  address get_state_id" name="delivery_address"  id="address" tabindex="-1" aria-hidden="true">
				<option value="">Select Option</option>
				<?php
				//onchange="getAddress(event,this)"
				if (!empty($mrn)) {
					echo '<option value="' . $mrn->delivery_address . '" selected>' . $mrn->delivery_address . '</option>';
				}
				?>
			</select>
		</div>
	</div>
	<input type="hidden" value="" name="dilivery_add_state" id="state_id22">
	<div class="item form-group">
		<label class="col-md-3 col-sm-12 col-xs-12" for="expected_Del">Received Date</label>
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
			<input type="text" id="current_date" name="date" class="form-control col-md-7 col-xs-12" placeholder="Display the Current Date" <?php if (!empty($mrn)) echo 'readonly'; ?> value="<?php if (!empty($mrn)) {echo $mrn->date;} ?>"> </div>
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
			<?php /*	<div class="col-md-9 col-sm-9 col-xs-12 input_charges_wrap">
						<?php 
						 if(!empty($mrn)){
							
						?>
							<?php
						
						if($mrn->charges_added !=''){
							$charges_detail = json_decode($mrn->charges_added);
								if(!empty($charges_detail)){
								$kk = 0;
								foreach($charges_detail as $charges_details){
									// if($charges_details->particular_charges_name !='' && $charges_details->charges_added !='' && $charges_details->amt_with_tax !='' ){
							?>
						   <div class="col-md-12 input_charges_details charges_form"  >
						   	   <div class="testDh" style="padding-left: 11px;">
								<div class="col-md-2 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Particulars</label>
									<select class="itemName form-control selectAjaxOption select2 Add_charges_id" name="particular_charges[]" data-id="charges_lead" data-key="id" data-fieldname="particular_charges" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" width="100%">
									<option value="">Select</option>			
											<?php
											if(!empty($mrn)){												
													$charge_dtl = getNameById('charges_lead',$charges_details->particular_charges_name,'id');
													echo '<option value="'.$charge_dtl->id.'" selected>'.$charge_dtl->particular_charges.'</option>';
											} 
										?>  			
									</select> 	
								</div>	
								<div class="col-md-1 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Charges.</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly charges_added" name="charges_added[]" value="<?php echo $charges_details->charges_added; ?>" onkeypress="return float_validation(event, this.value)">
									<span class="aply_btn"></span>
									<input type="hidden" value="" id="total_tax_slab">
								</div>
								<?php 
									if($charges_details->sgst_amt !='' && $charges_details->cgst_amt !=''){ 
								?>	
								<div class="col-md-1 item form-group sgst_amt1">
									<label class="col-md-12 col-sm-12 col-xs-12" for="sgstamount">SGST</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly sgst_amt"  name="sgst_amt[]" value="<?php echo $charges_details->sgst_amt; ?>">
								</div>	
								<div class="col-md-1 item form-group cgst_amt1">
									<label class="col-md-12 col-sm-12 col-xs-12" for="cgst Amount">CGST</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly cgst_amt" name="cgst_amt[]" value="<?php echo $charges_details->cgst_amt; ?>" >
								</div>
									<?php }elseif($charges_details->igst_amt !=''){ ?>
								<div class="col-md-1 item form-group igst_amt1">
									<label class="col-md-12 col-sm-12 col-xs-12" for="igstamount">IGST</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly igst_amt" name="igst_amt[]"  value="<?php echo $charges_details->igst_amt; ?>" >
								</div>	
									<?php } ?>	
								<div class="col-md-2 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="addtaxamount">Amt. with Tax</label>
									<input type="text" class="form-control col-md-1 amt_with_tax ad_rm_readonly" name="amt_with_tax[]" value="<?php echo $charges_details->amt_with_tax; ?>">
								</div>
							</div>
						
							<?php if($kk==0){
												echo '<button class="btn edit-end-btn plus-btn1 add_charges_detail_button " type="button"><i class="fa fa-plus"></i></button>';
											}else{	
												echo '<button class="btn btn-danger remove_charges_field" type="button"> <i class="fa fa-minus"></i></button>';
											} 
										$kk++;
											//}
										}
									}
								}
			 }
			?>
					<?php
					if(empty($mrn)){
					?>
							<div class="col-md-12 input_charges_details charges_form">
								<div class="testDh" style="padding-left: 11px;">
									<div class="col-md-2 item form-group">
										<label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Particulars.</label>
										<select class="itemName form-control selectAjaxOption select2 Add_charges_id"   required="required" name="particular_charges[]" data-id="charges_lead" data-key="id" data-fieldname="particular_charges" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" width="100%">
											<option value="">Select</option>			
										</select> 	
									</div>	
									<div class="col-md-1 item form-group">
										<label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Charges.</label>
										<input type="text" class="form-control col-md-1 ad_rm_readonly charges_added" name="charges_added[]" value="" onkeypress="return float_validation(event, this.value)">
										<span class="aply_btn"></span>
										<input type="hidden" value="" id="total_tax_slab">
									</div>	
									<div class="col-md-1 item form-group sgst_amt1">
										<label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="sgstamount">SGST</label>
										<input type="text" class="form-control col-md-1 ad_rm_readonly sgst_amt"  name="sgst_amt[]" value="">
									</div>	
									<div class="col-md-1 item form-group cgst_amt1">
										<label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="cgst Amount">CGST</label>
										<input type="text" class="form-control col-md-1 ad_rm_readonly cgst_amt" name="cgst_amt[]" value="" >
									</div>
									<div class="col-md-1 item form-group igst_amt1">
										<label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="igstamount">IGST</label>
										<input type="text" class="form-control col-md-1 ad_rm_readonly igst_amt" name="igst_amt[]"  value="" >
									</div>		
									<div class="col-md-2 item form-group">
										<label class="col-md-12 col-sm-12 col-xs-12  for_discount_hide" for="addtaxamount">Amt. with Tax</label>
										<input type="text" class="form-control col-md-1 amt_with_tax ad_rm_readonly" name="amt_with_tax[]" value="">
									</div>
								<button class="btn edit-end-btn plus-btn1 add_charges_detail_button" type="button"><i class="fa fa-plus"></i></button>
							</div>
						</div>
					
				<?php } ?>			
					</div>
		
	</div>*/?>
			
	
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
		<label class="col-md-3 col-sm-12 col-xs-12" for="rating">Ratings</label>
		<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="star-rating">
			<?php 
				$countEmptyStar = 5-$mrn->rating;
				$i = 1;
				while($i<=$mrn->rating) {
					echo '<s class="active"></s>';
					$i++;
				}
				$j = 1;
				while($j<=$countEmptyStar) {
					echo '<s></s>';
					$j++;
				}?>
		</div>
			<!--<div class="show-result">No stars selected yet.</div>-->
			<input type="hidden" name="rating" id="hidden_rating" class="form-control col-md-7 col-xs-12" placeholder="Rating" value="">
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
	<div class="modal left fade" id="myModal_Add_matrial_details" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Add Material Details</h4>
					<span id="mssg34"></span>
			</div>
			<form name="insert_party_data" name="ins"  id="insert_Matrial_data_id">
                <div class="modal-body">
					 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-10 col-sm-10 col-xs-12" for="name">Material Name <span class="required">*</span></label>
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
					<input type="hidden" name="material_type_id" id="material_type_id"  class="form-control" value="">
					<input type="hidden" name="prefix"  id="prefix">
						<span class="spanLeft control-label"></span>
					<!--</div>
				</div>-->
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-10 col-sm-10 col-xs-12" for="email">HSN Code </label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="hsn_code" name="hsn_code" class="form-control col-md-7 col-xs-12" value="" >
							<span class="spanLeft control-label"></span>
						</div>
					</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-10 col-sm-10 col-xs-12" for="email">UOM</label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
					<select class="uom selectAjaxOption select2 form-control" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php 	echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0 AND active_inactive = 1">
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
						<label class="control-label col-md-10 col-sm-10 col-xs-12" for="gstin">Opening Balance</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="opening_balance_Sec" name="opening_balance" class="form-control col-md-7 col-xs-12" value="">
							<span class="spanLeft control-label"></span>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="specification">Specification</label>
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