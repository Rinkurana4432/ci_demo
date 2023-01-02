<style>
.mobile-view label{display:block !important; border-top: 1px solid #c1c1c1;} 
</style>
<?php


$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

?>

<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>crm/saveDispatchSaleOrder" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
		<input type="hidden" name="id" value="">
		<input type="hidden" name="sale_order_id" value="<?php if(!empty($sale_order)){ echo $sale_order->id; }?>">
		<input type="hidden" name="save_status" value="1" class="save_status">	
		<input type="hidden" name="account_id" value="<?php if(!empty($sale_order) && isset($sale_order->account_id)) echo $sale_order->account_id; ?>">	
		<input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
		<div class="item form-group">
			<!-- <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product detail">Customer Details<span class="required">*</span></label>	 -->
			
		
		<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-2 col-xs-12" for="agt">Account Name. </label>
			<div class="col-md-7 col-sm-10 col-xs-12">
				<?php  if(!empty($sale_order) && $sale_order->account_id !=0){
							$accountData = getNameById('account',$sale_order->account_id,'id');
							if(!empty($accountData)) echo $accountData->name;
						}
					?>
			</div>
		</div>
		
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-2 col-xs-12" for="agt">Invoice No.</label>
			<div class="col-md-7 col-sm-10 col-xs-12">
				<input type="text" class="form-control has-feedback-left" name="invoice_no" id="invoice_no" value="<?php if(!empty($sale_order) && isset($sale_order->invoice_no)) echo $sale_order->invoice_no; ?>">
			</div>
		</div>
		
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-2 col-xs-12" for="agt">Transport Tel. No.</label>
			<div class="col-md-7 col-sm-10 col-xs-12">
				<input type="text" class="form-control has-feedback-left" name="transport_tel_no" id="transport_tel_no" value="<?php if(!empty($sale_order) && isset($sale_order->transport_tel_no)) echo $sale_order->transport_tel_no; ?>" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-2 col-xs-12" for="agt">Vehicle No.</label>
			<div class="col-md-7 col-sm-10 col-xs-12">
				<input type="text" class="form-control has-feedback-left" name="vehicle_no" id="vehicle_no" value="<?php if(!empty($sale_order) && isset($sale_order->vehicle_no)) echo $sale_order->vehicle_no; ?>">
			</div>
		</div>
		</div>
<hr>
<div class="bottom-bdr"></div>
<h3 class="Material-head">Dispatch history<hr></h3>	
		
		
		<?php if(!empty($sale_order_dispatch)){
			echo '<div class="col-md-12 col-sm-12 col-xs-12 item form-group">			
			<div class="col-md-12 col-sm-10 col-xs-12">';
					echo '<div class="x_content">
							<table class="table table-bordered">								
								<thead>
									<tr>
										<th>Invoice No</th>
										<th>Transport Tel No</th>
										<th>Vehicle No</th>
										<th>Material</th>
										<th>Description</th>
										<th>Quantity</th>
										<th>UOM</th>
										<th>Dispatch Date</th>
										<th>Date</th>
										<th>Comments</th>
									</tr>
								</thead>
							<tbody>';
					foreach($sale_order_dispatch as $sod){
						if($sod['product'] !=''){
							$productData = JSON_decode($sod['product']);
							if(!empty($productData)){
								#pre($productData);
								foreach($productData as $pd){
									$material = getNameById('material',$pd->product,'id');
									$material_name	=	!empty($material)? $material->material_name:"";

									$ww =  getNameById('uom', $pd->uom,'id');
									$uom = !empty($ww)?$ww->ugc_code:'';

									echo '<tr>
										<td>'.$sod["invoice_no"].'</td>
										<td>'.$sod["transport_tel_no"].'</td>
										<td>'.$sod["vehicle_no"].'</td>
										<td>'.$material_name.'</td>
										<td>'.$pd->description.'</td>
										<td>'.$pd->quantity.'</td>
										<td>'.$uom.'</td>
										<td>'.$sod['dispatch_date'].'</td>
										<td>'.$sod['created_date'].'</td>
										<td>'.$sod['comments'].'</td>
									</tr>';
								}
							
							}
						}
						
					}
					echo '</tbody>
					</table></div></div></div>';
					
			 } ?>
				
	<hr>
<div class="bottom-bdr"></div>
	
<h3 class="Material-head">Material Details<hr></h3>	
<!-- 09-03 Start Testing issue -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
<div class="panel">
        <div class="">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group input_productre middle-box">
				<?php if(empty($sale_order)){ ?>
				    <div class="col-sm-12  col-md-12 label-box mobile-view2">
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Product Code<span class="required">*</span></label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name<span class="required">*</span></label></div> 
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Pro-Image</label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Description</label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Quantity</label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label >UOM</label></div>
                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Price</label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>GST</label></div>
                                    <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Total</label></div>
								   <!--div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">GST Total1</label></div-->
								</div>
					<div class="well scend-tr mobile-view"   id="chkIndex_1">
                       <div class="col-md-2 col-sm-12 col-xs-12 item form-group">
					        <label class="col-md-12">Product Code  <span class="required">*</span></label>
						 <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" id="material_type_id" name="material_type_id[]" data-id="material_variants" data-key="id" data-fieldname="item_code" data-where="status=1" tabindex="-1" aria-hidden="true" onchange="getvarientList(event,this)" id="material_type" disabled="disabled">
								<option value="">Select Option</option>
							</select> 
						</div>
						<div class="col-md-2 col-sm-12 col-xs-12 item form-group">
					        <label class="col-md-12" terial Name>Material Name  <span class="required">*</span></label>
						 
							<select class="form-control selectAjaxOption select2 set_mat_name materialNameId Add_mat_onthe_spot" required="required" name="product[]" width="100%" onchange="getTax(event,this)" id="material" >
								<option value="">Select Option</option>
							</select>
							<input type="hidden" name="mat_idd_name" id="matrial_Iddd">
							<input type="hidden" name="matrial_name" id="matrial_name">
							<input type="hidden" id="serchd_val">
						</div>
						 <div class="col-md-1 col-sm-12 col-xs-12 item form-group">
											<label>Pro-Image</label>
											<div class="Product_Image col-xs-12">
											   
											</div>
										</div>
						<div class="col-md-1 col-sm-12 col-xs-12 item form-group">
							<label class="col-md-12">Description</label>
							<textarea name="description[]" placeholder="Description of material" class="form-control col-md-7 col-xs-12" class="description" readonly="readonly"></textarea>
						</div>
						<div class="col-md-1 col-sm-6 col-xs-12 form-group">
						<label class="col-md-12" >Quantity</label>
							<input type="text" name="qty[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12 quantity" onkeyup="keyupFunction(event,this)"  onchange="keyupFunction(event,this)" required="required">
						</div>
						<div class="col-md-1 col-sm-6 col-xs-12 form-group">
						<label class="col-md-12">UOM</label>
							<input type="text" name="uom1[]"  placeholder="uom" class="form-control col-md-7 col-xs-12 uom mat_uom" readonly>
							<input type="hidden" name="uom[]" readonly>
						</div>
						<div class="col-md-1 col-sm-6 col-xs-12 form-group">
						<label class="col-md-12">Price</label>
							<input readonly type="text" name="price[]"  placeholder="Price" class="form-control col-md-7 col-xs-12 mat_sales_price" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" required="required">
						</div>

						<div class="col-md-1 col-sm-6 col-xs-12 form-group">
					<label  class="col-md-12">GST </label>
						<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst mat_tax" value="" placeholder="gst" readonly>
						<input type="hidden" class="gst_val" value="">
					</div>
					<div class="col-md-2 col-sm-6 col-xs-12 form-group">
								<label>	Total	</label>
									<input type="text" name="totals[]" class="form-control col-md-7 col-xs-12 total" value="" readonly>
									<input type="hidden" class="total_cbf" value="">
									<input type="hidden" class="total_weight" value="">
								</div>
								<!--div class="col-md-1 col-sm-6 col-xs-12 form-group">
								<label style="border-right: 1px solid #c1c1c1 !important;">	GST	Total</label>
									<input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="" readonly>
								</div-->
						<button class="btn btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button>
					</div>
                    <div class="col-sm-12 btn-row">
							<button class="btn addProductButtonre edit-end-btn" type="button" align="right">Add</button>
						</div>
					<?php } else{
						$products = json_decode($sale_order->product);
						?>
						
						
						<?php
						if(!empty($products)){
								$i =  1;
								$ck = 0;
								$subtotal = 0;
								$gst = 0;
								$total_cbf_set = $total_weight_set = 0;
								foreach($products as $product){
								$subtotal += $product->individualTotal;
								$gst += $product->individualTotal*($product->gst/100);
								
								?>
									<div class="well <?php if($i==1){ echo 'edit-row1 scend-tr mobile-view';}else{ echo 'scend-tr mobile-view';}?>"  id="chkWell_<?php echo $i; ?>" style="overflow:auto; ">
										<div class="col-md-2 col-sm-12 col-xs-12 item form-group">
											<label>Product Code<span class="required">*</span></label>
											<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" id="material_type_id" name="material_type_id[]" id="" data-id="material_variants" data-key="id" data-fieldname="item_code" data-where="status=1" tabindex="-1" aria-hidden="true" onchange="getvarientList(event,this)" id="material_type" disabled="disabled">
												<option value="">Select Option</option>
												<?php
												if(!empty($sale_order)){
													$mat_type = json_decode($sale_order->material_type_id);
													$material_type_id = getNameById('material_variants',$mat_type[$ck],'id');
													echo '<option value="'.$material_type_id->id.'" selected>'.$material_type_id->item_code.'</option>';
													}
												?>
											</select>
									 
										</div>
										<div class="col-md-2 col-sm-12 col-xs-12 item form-group">
											<label>Material Name<span class="required">*</span></label>
											<select class="materialNameId  form-control selectAjaxOption select2 Add_mat_onthe_spot set_mat_name" required="required" name="product[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid = <?php echo $this->companyGroupId; ?>" width="100%" onchange="getTax(event,this)" id="material" >
												<option value="">Select Option</option>
												<?php
													if(!empty($product)){
														//$material = getNameById('material',$product->product,'id');
														echo '<option value="'.$product->product.'" selected>'.$product->product.'</option>';
													}
												?>
											</select>
											<input type="hidden" name="mat_idd_name" id="matrial_Iddd">
											<input type="hidden" name="matrial_name" id="matrial_name">
											<input type="hidden" id="serchd_val">
										</div>
                                         <div class="col-md-1 col-sm-12 col-xs-12 item form-group">
											<label>Pro-Image</label>
											<div class="Product_Image col-xs-12">
											<?php
											
											$mat_name = $product->product;
									    $mat_details = getNameById('material', $product->product, 'id');
										
										// pre($mat_details);
										
									    $mat_id = $product->product;
											if(!empty($mat_details->packing_data)){
											$packing_data = json_decode($mat_details->packing_data);
											$standard_packing = $mat_details->standard_packing;
											$cbf = $weight = 0;
											foreach ($packing_data as $key => $packing_value) {
											$packing_qty = $packing_value->packing_qty;
											$packing_cbf = $packing_value->packing_cbf;
											$packing_weight = $packing_value->packing_weight;
											$cbf += $packing_cbf*$packing_qty;
											$weight += $packing_weight*$packing_qty;
											}
											@$total_cbf = round($cbf/$standard_packing, 2);
											@$total_weight = round($weight/$standard_packing, 2);
											} else {
											@$total_cbf = $total_weight = 0;
											}
											$qty = $product->quantity;
											$total_cbf_set += $qty*$total_cbf;
											$total_weight_set += $qty*$total_weight;
									    $attachments = $this->crm_model->get_image_by_materialId('attachments', 'rel_id', $mat_id);
									    echo '<img style="width: 50px; height: 50px;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
											?>
											</div>
										</div>
										<div class="col-md-1 col-sm-12 col-xs-12 item form-group">
											<label>Description</label>
											<textarea name="description[]" placeholder="Description of material" class="form-control col-md-7 col-xs-12" class="description" readonly="readonly"><?php echo $product->description ; ?></textarea>
										</div>
										<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										    <label>Quantity</label>
											<input type="text" name="qty[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12 quantity" value="<?php echo $product->quantity ;?>" onkeyup="keyupFunction(event,this)"  onchange="keyupFunction(event,this)">
										</div>
										<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										    <label>UOM</label>
											<input type="text" name="uom[]"  placeholder="uom" class="form-control col-md-7 col-xs-12 uom mat_uom" value="<?php
											$ww =  getNameById('uom', $product->uom,'id');
												$uom = !empty($ww)?$ww->ugc_code:'';
											?>" readonly>

											<input type="hidden" name="uom[]" readonly value="<?php echo $product->uom;  ?>">
										</div>
										<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										     <label>Price</label>
											<input readonly type="text" name="price[]" id="inputSuccess2" placeholder="Price" class="form-control mat_sales_price" value="<?php echo $product->price ;?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)">

										</div>
										<?php /*
										<div class="col-md-2 col-sm-6 col-xs-12 form-group">
											<input type="number" name="price[]"  placeholder="Price" class="form-control col-md-7 col-xs-12" value="<?php echo $product->price ;?>" onkeyup="poPriceCalculation(event,this)"  onchange="poPriceCalculation(event,this)">
										</div> */ ?>
										<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										    <label>GST</label>
											<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst mat_tax" value="<?php echo chop($product->gst,"%") ;?>" placeholder="gst%" readonly>
											<input type="hidden" class="gst_val" value="<?php echo $product->individualTotal*($product->gst/100); ?>">
										</div>
										<div class="col-md-2 col-sm-6 col-xs-12 form-group">
										    <label>Total</label>
											<input type="text" name="totals[]" class="form-control col-md-7 col-xs-12 total" value="<?php echo $product->individualTotal ;?>" readonly>
											<input type="hidden" class="total_cbf" value="<?php echo $total_cbf; ?>">
											<input type="hidden" class="total_weight" value="<?php echo $total_weight; ?>">
										</div>
										<div class="col-md-1 col-sm-6 col-xs-12 form-group" style="display:none;">
										    <label>GST Total</label>
											<input style="border-right: 1px solid #c1c1c1 !important;" type="hidden" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="<?php echo $product->individualTotalWithGst ;?>" readonly>
										</div
									</div>
					<?php $i++; $ck++; }
					}
				}?>
				
				</div>
                <div class="boxSec mb-3 mb-md-0 borderLable purchaseInfo col-md-4" style="float: right; margin-top: 2%;">
				 					<?php  
								   	if(!empty($sale_order)){
								   	$account = getNameById('account',$sale_order->account_id,'id');
									   /* 08-03-2022 Start Resolve issue  */
								   	$type_of_customer = (int)$account->type_of_customer;
									   /* 08-03-2022 End Resolve issue  */
										$type_of_customer_data = $this->crm_model->get_data_byId('types_of_customer', 'id', $type_of_customer);
										/* 08-03-2022 Start Resolve issue  */
										$calcDiscount_val = (int)$sale_order->load_type;
										/* 08-03-2022 End Resolve issue  */
										$sale_order_cbf = $sale_order->pi_cbf;
										$sale_order_weight = $sale_order->pi_weight;
										$sale_order_paymode = $sale_order->pi_paymode;
										$sale_order_permitted = $sale_order->pi_permitted;
										$special_discount = $sale_order->special_discount;
										$freightCharges = $sale_order->freightCharges;
										$advance_received = $sale_order->advance_received;
										if($calcDiscount_val == 'none'){
										$discount_rate = "0";
										} else {
											/* 08-03-2022 Start Resolve issue  */
										$discount_rate = (int)$type_of_customer_data-(int)$calcDiscount_val;/* 08-03-2022 End Resolve issue  */	
										}
										$discount_value = $subtotal*($discount_rate/100);
										$spd_value = $subtotal*($special_discount/100);
										$total = $subtotal - $discount_value - $spd_value;
										$gfc = $freightCharges*28/100;
										$grand_total = $total+$gst+$freightCharges+$gfc;
										/* 08-03-2022 Start Resolve issue  */
										$remain_balance = (int)$grand_total-(int)$advance_received;
										/* 08-03-2022 End Resolve issue  */
									}
										?>
				   <ul class="laserAddress space">
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Subtotal:-</div>
							<div class="col-md-7 text-right addColenAfter"><span class="blueColor text-nowrap divSubTotal"><?php echo !empty($subtotal)?$subtotal:''; ?></span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Discount value:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divDiscountValue">
							<?php
							echo !empty($discount_value)?$discount_value:'';
							?>
							</span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Special Discount value:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divSpecialDiscount"><?php
							echo !empty($spd_value)?$spd_value:'';
							?></span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Total:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divTotal"><?php echo !empty($total)?$total:''; ?></span></div>
							<input type="hidden" name="total" class="total" value="<?php echo !empty($total)?$total:''; ?>">
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Tax:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divTax"><?php echo !empty($gst)?$gst:''; ?></span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Freight Charge:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divFreightCharge"><?php echo !empty($freightCharges)?$freightCharges:''; ?></span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">GST on the Freight:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divGSTFreight"><?php echo !empty($gfc)?$gfc:''; ?></span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">TCS:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap">0.00</span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Grand Total:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divGrandTotal"><?php echo !empty($grand_total)?$grand_total:''; ?></span></div>
							<input type="hidden" name="grandTotal" class="grandTotal" value="<?php echo !empty($grand_total)?$grand_total:''; ?>">
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Advance Paid amount:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divAdvancePaid"><?php echo !empty($advance_received)?$advance_received:''; ?></span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Balance:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divBalance"><?php echo !empty($remain_balance)?$remain_balance:''; ?></span></div>
						 </div>
					  </li>

				   </ul>
				</div>
				<!--<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">


							<div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 18px;color: #2C3A61; ">
						<div class="col-md-7 col-sm-5 col-xs-6 text-right">
						  <input type="hidden"  name="total" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($sale_order)) echo $sale_order->total; ?>">
							<strong>Total:</strong>&nbsp;&nbsp;
							</div>
							<div class="col-md-5 col-sm-5 col-xs-6 text-left">
							      <span class="fa fa-rupee divSubTotal"><?php if(!empty($sale_order)){ echo $sale_order->total ; } else{ echo 0; }?></span>
							</div>

						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 18px;color: #2C3A61; border-top: 1px solid #2C3A61;">
						<div class="col-md-7 col-sm-5 col-xs-6 text-right">
						  <input type="hidden"  name="grandTotal" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($sale_order)) echo $sale_order->grandTotal; ?>">
							<strong>Grand Total:</strong>&nbsp;
							</div>
							<div class="col-md-5 col-sm-5 col-xs-6 text-left">
							     <span class="fa fa-rupee divTotal"><?php if(!empty($sale_order)){ echo $sale_order->grandTotal ; } else{ echo 0; }?></span>
							</div>

						</div>
					</div>


				</div>-->
			</div>
        </div>
    </div>
<!-- 09-03 End Testing issue -->	
<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
						
					
						<!-- 09-03 Start Testing issue -->
						<!-- <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 18px;color: #2C3A61; ">
						<div class="col-md-7 col-sm-5 col-xs-6 text-right">
						  <input type="hidden" class="form-control has-feedback-left" name="total" id="total" value="<?php //if(!empty($sale_order)) echo $sale_order->total; ?>"> 
							<strong>Total:</strong>&nbsp;&nbsp;
							</div>
							<div class="col-md-5 col-sm-5 col-xs-6 text-left">
							      <span class="divSubTotal fa fa-rupee">  <?php //if(!empty($sale_order)){ echo '  '.$sale_order->total ; } else{ echo 0; }?></span>
							</div>
							 
						</div> -->
					<!-- 	<div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 18px;color: #2C3A61; border-top: 1px solid #2C3A61;">
						<div class="col-md-7 col-sm-5 col-xs-6 text-right">
						  <input type="hidden" class="form-control has-feedback-left" name="grandTotal" id="grandTotal" value="  <?php //if(!empty($sale_order)) echo $sale_order->grandTotal; ?>">
							<strong>Grand Total:</strong>&nbsp;
							</div>
							<div class="col-md-5 col-sm-5 col-xs-6 text-left">
							     <span class="fa fa-rupee divTotal"><?php //if(!empty($sale_order)){ echo '  '.$sale_order->grandTotal ; } else{ echo 0; }?></span>
							</div>
							 
						</div> -->
						<!-- 09-03 End Testing issue -->
					</div>
				
			
</div>

<hr>
<div class="bottom-bdr"></div>
	
<h3 class="Material-head">Dispatch Details<hr></h3>
     <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
			<label class=" col-md-3 col-sm-2 col-xs-12" for="textarea">Dispatch Date</label>
			<div class="col-md-7 col-sm-10 col-xs-12">
			<fieldset>
				<div class="control-group">
					<div class="controls">
					  <div class="xdisplay_inputx form-group has-feedback">
						<input type="text" class="form-control has-feedback-left" id="dispatch_date"  name="dispatch_date" id="single_cal3" aria-describedby="inputSuccess2Status3" value="<?php if(!empty($sale_order) && $sale_order->dispatch_date!=''){ echo $sale_order->dispatch_date; }else {echo date("d-m-Y");}?>">
						<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
						<span id="inputSuccess2Status3" class="sr-only">(success)</span>
					  </div>
					</div>
				</div>
			</fieldset>		
          </div>			
		</div>
					   
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-4" for="dispatch_documents">Documents to submit with dispatch </label>
			<div class="col-md-7 col-sm-10 col-xs-8">
				<div class="checkbox" name="dispatch_documents">
					<?php 					
						$documentSubmitedWithDispatch = documentSubmitedWithDispatch();
						foreach($documentSubmitedWithDispatch as $dswd){ ?>
							<label><input type="checkbox" class="flat" value="<?php echo $dswd ;?>" name="dispatch_documents[]" 
							<?php
							if (!empty($sale_order)  && ($sale_order->dispatch_documents != 'null' ) && ($sale_order->dispatch_documents !=='')){							
								if(in_array($dswd,json_decode($sale_order->dispatch_documents), TRUE)){
									echo "checked";
									}  	
							}
						?>><?php echo $dswd;?></label>
						<?php } ?>
			  </div>
			</div>
		</div>
   </div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">   
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-4" for="comments">Comments</label>
			<div class="col-md-7 col-sm-10 col-xs-8">
				<textarea id="comments" rows="6" name="comments" class="form-control col-md-7 col-xs-12"><?php if(!empty($sale_order) && isset($sale_order->comments)) echo $sale_order->comments; ?></textarea>
			</div>
		</div>
</div>	
			
			<?php 
				if(!empty($sale_order)){
					$disableCompleteCheck = (!empty($sale_order) && $sale_order->complete_status ==1 )?'disabled':'';
					$completeChecked = (!empty($sale_order) && $sale_order->complete_status ==1 )?'checked':'';
					echo '<div class="x_content">';
						echo 'Sale Order Complete <input type="checkbox" name="sale_order_complete" id="sale_order_complete" value="" data-sale-order-ai="'.$sale_order->account_id.'" data-sale-order-id="'.$sale_order->id.'" data-loggedInUserId="'.$_SESSION['loggedInUser']->id.'" '.$disableCompleteCheck.' '. $completeChecked. '  >';					
					echo '</div>';
					}else{
					echo '<p>Not Dispatched</p>';
					}?>
			
				<?php /*<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-2 col-sm-2 col-xs-12" for="certificate">Attachments</label>
					<div class="col-md-9 col-sm-9 col-xs-12 fields_wrap">
						<input type="file" class="form-control" name="attachment[]"> 
					</div>
					<button class="btn edit-end-btn field_button" type="button"><i class="fa fa-plus"></i></button>
				</div>
				
				
					<?php /*if(!empty($attachments)){?>
							<div class="item form-group">
								<div class="col-md-12 outline">
									<?php foreach($attachments as $attachment){
												echo '<div class="img-wrap"><div class="col-md-1 img-outline"><a href="javascript:void(0)" class="delete_listing close-link cross" style="z-index:111;" data-href="'.base_url(). 'crm/deleteAttachment/'.$attachment[ 'id']. '"><i class="fa fa-trash" style="color:#e60a03;"></i></a><a href="'.base_url(). 'assets/modules/crm/uploads/'.$attachment[ 'file_name']. '" download><img style="height:50px;" src="'.base_url(). 'assets/modules/crm/uploads/'.$attachment[ 'file_name']. '" alt="image" class="img-responsive"/></a></div></div>';
									} ?>
								</div>
							</div>
						<?php } */?>
				
				
			<div class="clearfix"></div>	
		<div class="ln_solid"></div>
		
			<div class="col-md-12 ">
			<center>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="reset" class="btn btn-default">Reset</button>
				<?php if((!empty($sale_order) && $sale_order->save_status !=1) || empty($sale_order)){
						echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
					}?> 
				<input type="submit" class="btn edit-end-btn" value="Submit">
				</center>
			</div>
		
	</form>	


