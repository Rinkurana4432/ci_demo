<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>crm/saveSaleOrder" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
		<input type="hidden" name="id" value="<?php if(!empty($sale_order)){ echo $sale_order->id; }?>">
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Order Date<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" class="form-control has-feedback-left" name="order_date" id="order_date" value="<?php if(!empty($sale_order)){ echo $sale_order->order_date; }else {echo date("m/d/Y");}?>" readonly>
					<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
				</div>						
		</div>
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="product detail">Customer Details<span class="required">*</span></label>	
			<div class="col-md-6 col-sm-6 col-xs-12 form-group input_holder">
					<div class="well" id="chkIndex_1">
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-2 col-sm-2 col-xs-4" for="parent_account">Customer Name<span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8">
								<select class="itemName selectAjaxOption select2" name="account_id" data-id="account" data-key="id" data-fieldname="name" data-where="account_owner = <?php echo $_SESSION['loggedInUser']->c_id; ?>" width="100%" id="account_id" required="required">
									<option value="">Select Option</option>
									<?php 
										if(!empty($sale_order)){
											$account = getNameById('account',$sale_order->account_id,'id');
											echo '<option value="'.$account->id.'" selected>'.$account->name.'</option>';
										}
									?>
								</select>
							</div>
						</div>						
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-2 col-sm-2 col-xs-4" for="address">Customer Address</label>
							<div class="col-md-10 col-sm-10 col-xs-8">
							
							 
							<?php if(!empty($sale_order)){
								$city = getNameById('city',$account->billing_city,'city_id');
								$state = getNameById('state',$account->billing_state,'state_id');
								$country = getNameById('country',$account->billing_country,'country_id');
								}
							?>
								<textarea id="address" rows="6" name="address" class="form-control col-md-7 col-xs-12" placeholder="" readonly><?php if(!empty($account)){ echo $account->billing_street . PHP_EOL . $city->city_name  . PHP_EOL . $account->billing_zipcode  . PHP_EOL . $state->state_name  . PHP_EOL . $country->country_name ; }?></textarea>
							</div>
					   </div>						
						<div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="gstin">GSTIN</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="gstin" name="gstin" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($sale_order)) echo $account->gstin; ?>"> 
							</div>
						</div>  
						<div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="email" id="email" name="email" class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php if(!empty($sale_order)) echo $account->email; ?>"> 
							</div>
						</div>  						
						<div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Phone No.</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="tel" id="phone_no" name="phone_no"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($sale_order)) echo $account->phone; ?>" readonly>
							</div>
						</div>						
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-2 col-sm-2 col-xs-4" for="contact_person">Contact Person</label>
						<div class="col-md-10 col-sm-10 col-xs-8">
							<select class="itemName selectAjaxOption select2" name="contact_id" data-id="contacts" data-key="id" data-fieldname="first_name" width="100%" id="contact_id">							
								<option value="">Select Option</option>
								<?php 
									if(!empty($sale_order)){
										$contact = getNameById('contacts',$sale_order->contact_id,'id');
										echo '<option value="'.$contact->id.'" selected>'.$contact->first_name. ' '.$contact->last_name.'</option>';
									}
								?>
							</select>
						</div>
						</div>						
						<div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="contact_phone_no">Contact Phone No.</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="contact_phone_no" name="contact_phone_no"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($sale_order) && !empty($contact)) echo $contact->phone; ?>" readonly>
							</div>
						</div>
					</div>	
					
			</div>									
		</div>	
		<div class="col-md-12 col-sm-12 col-xs-12 form-group input_product">	
		<?php if(empty($sale_order)){ ?>		
				<div class="well"  style="overflow:auto;" id="chkIndex_1">
					<div class="col-md-2 col-sm-12 col-xs-12 form-group">
						<select class="itemName form-control selectAjaxOption select2" required="required" name="product[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid = <?php echo $_SESSION['loggedInUser']->c_id; ?>" width="100%" onchange="getTax(event,this)" id="material">
							<option value="">Select Option</option>
						</select>
					</div>
					<div class="col-md-1 col-sm-6 col-xs-12 form-group">
						<input type="number" name="quantity[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12" class="quantity" onkeyup="poPriceCalculation(event,this)"  onchange="poPriceCalculation(event,this)">
					</div>
					<div class="col-md-2 col-sm-6 col-xs-12 form-group">
						<input type="text" name="uom1[]"  placeholder="uom" class="form-control col-md-7 col-xs-12" class="uom" readonly>
						
						<input type="hidden" name="uom[]" readonly class="uom">
						<?php /*<select class="form-control uom" name="uom[]" class="uom">
							<option>Select UOM</option>
							<?php 
								$measurementUnits = measurementUnits();
								foreach($measurementUnits as $mu){ 
									echo '<option value="'.$mu.'">'.$mu.'</option>';
								}
							?>
						</select> */?>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-12 form-group">
						<input type="number" name="price[]"  placeholder="Price" class="form-control col-md-7 col-xs-12" onkeyup="poPriceCalculation(event,this)" onchange="poPriceCalculation(event,this)">
					</div>
					<div class="col-md-1 col-sm-6 col-xs-12 form-group">
						<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="" placeholder="gst" readonly>
					</div>			
					<div class="col-md-2 col-sm-6 col-xs-12 form-group">
						<input type="text" name="individualTotal[]" class="form-control col-md-7 col-xs-12 individualTotal" value="" readonly>
					</div>	
					<div class="col-md-2 col-sm-6 col-xs-12 form-group">
						<input type="text" name="individualTotalWithGst[]" class="form-control col-md-7 col-xs-12 individualTotalWithGst" value="" readonly>
					</div>		
					<div class="input-group-append">
						<button class="btn btn-primary addProductButton" type="button" align="right"><i class="fa fa-plus"></i></button>
					</div>						
				</div>	
		<?php } else{ 
					$products = json_decode($sale_order->product);
					if(!empty($products)){ 
						$i =  1;
						foreach($products as $product){
						?>
							<div class="well"  id="chkWell_<?php echo $i; ?>" style="overflow:auto;">
								<div class="col-md-2 col-sm-12 col-xs-12 form-group">	
									<select class="itemName form-control selectAjaxOption select2" required="required" name="product[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid = <?php echo $_SESSION['loggedInUser']->c_id; ?>" width="100%" onchange="getTax(event,this)" id="material">
										<option value="">Select Option</option>
										<?php 
											if(!empty($product)){
												$material = getNameById('material',$product->product,'id');
												echo '<option value="'.$material->id.'" selected>'.$material->material_name.'</option>';
											}
										?>
									</select>
								</div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									<input type="number" name="quantity[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12 quantity" value="<?php echo $product->quantity ;?>" onkeyup="poPriceCalculation(event,this)" onchange="poPriceCalculation(event,this)">
								</div>
								<div class="col-md-2 col-sm-6 col-xs-12 form-group">
									<input type="text" name="uom1[]" placeholder="uom" class="form-control col-md-7 col-xs-12 uom" value="<?php 


												$ww =  getNameById('uom', $product->uom,'id');
												$uom = !empty($ww)?$ww->ugc_code:'';

												echo $uom;


											 ?>" readonly>

											<input type="hidden" name="uom[]" readonly value="<?php echo  $product->uom; ?>">

									
								</div>
								<div class="col-md-2 col-sm-6 col-xs-12 form-group">
									<input type="number" name="price[]"  placeholder="Price" class="form-control col-md-7 col-xs-12 price" value="<?php echo $product->price ;?>" onkeyup="poPriceCalculation(event,this)" onchange="poPriceCalculation(event,this)">
								</div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="<?php echo $product->gst ;?>" placeholder="gst" readonly>
								</div>	
								<div class="col-md-2 col-sm-6 col-xs-12 form-group">
									<input type="text" name="individualTotal[]" class="form-control col-md-7 col-xs-12 individualTotal" value="<?php echo $product->individualTotal ;?>" readonly>
								</div>	
								<div class="col-md-2 col-sm-6 col-xs-12 form-group">
									<input type="text" name="individualTotalWithGst[]" class="form-control col-md-7 col-xs-12 individualTotalWithGst" value="<?php echo $product->individualTotalWithGst ;?>" readonly>
								</div>									
								
									<?php if($i==1){
									echo '<button class="btn btn-primary addProductButton" type="button"><i class="fa fa-plus"></i></button>';
									}else{	
									echo '<button class="btn btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button>';
									} ?>	
								
			</div>	
<?php $i++; }}}?>	
</div>	
<input type="hidden" class="form-control has-feedback-left" name="total" id="total" value="<?php if(!empty($sale_order)) echo $sale_order->total; ?>">
<input type="hidden" class="form-control has-feedback-left" name="grandTotal" id="grandTotal" value="<?php if(!empty($sale_order)) echo $sale_order->grandTotal; ?>">
<span>Rs</span><div class="divSubTotal"><?php if(!empty($sale_order)){ echo $sale_order->total ; } else{ echo 0; }?></div>
<span>Rs</span><div class="divTotal"><?php if(!empty($sale_order)){ echo $sale_order->grandTotal ; } else{ echo 0; }?></div>
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Dispatch Date<span class="required">*</span></label>
			<fieldset>
				<div class="control-group">
					<div class="controls">
					  <div class="col-md-11 xdisplay_inputx form-group has-feedback">
						<input type="text" class="form-control has-feedback-left datePicker" name="dispatch_date" id="single_cal3" aria-describedby="inputSuccess2Status3" value="<?php if(!empty($sale_order)) echo $sale_order->dispatch_date; ?>" required="required">
						<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
						<span id="inputSuccess2Status3" class="sr-only">(success)</span>
					  </div>
					</div>
				</div>
			</fieldset>										
		</div>
		
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">A.G.T. / Other taxes<span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" class="form-control has-feedback-left" name="agt" id="agt" value="<?php if(!empty($sale_order)) echo $sale_order->agt; ?>" required="required">
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="freight">Freight<span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<p>
				FOR price:<input type="radio" class="flat" name="freight" id="genderM" value="FOR price" <?php if(!empty($sale_order) && $sale_order->freight == 'FOR price') echo 'checked'; else echo 'checked'; ?> required /> 
                To be paid by customer:<input type="radio" class="flat" name="freight" id="genderF" value="To be paid by customer" <?php if(!empty($sale_order) && $sale_order->freight == 'To be paid by customer') echo 'checked'; ?>/>
            </p>
			
			
			</div>
		</div>						
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="freight">Payment Terms<span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<?php  /*<select required class="form-control payment_terms" name="payment_terms[]" id="payment_terms" >*/?>
				<select required class="form-control payment_terms" name="payment_terms" id="payment_terms" >
					<?php 
						$paymentTerms = paymentTerms();
						
						//echo '<option value="">Select Payment Term</option>';
						foreach($paymentTerms as $paymentTerm){ 
						$paymentTermSelect = '';
						if(!empty($sale_order) && $sale_order->payment_terms == $paymentTerm){
							$paymentTermSelect = 'selected';
						}else{
							$paymentTermSelect = '';
						}
							echo '<option value="'.$paymentTerm.'"'. $paymentTermSelect.'>'.$paymentTerm.'</option>';
						}
					?>
				</select>
			</div>
		</div>		
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Payment Date<span class="required">*</span></label>
			<fieldset>
				<div class="control-group">
					<div class="controls">
					  <div class="col-md-11 xdisplay_inputx form-group has-feedback">
						<input type="text" class="form-control has-feedback-left datePicker" name="payment_date" id="single_cal3" aria-describedby="inputSuccess2Status3" value="<?php if(!empty($sale_order)) echo $sale_order->payment_date; ?>" required="required">
						<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
						<span id="inputSuccess2Status3" class="sr-only">(success)</span>
					  </div>
					</div>
				</div>
			</fieldset>										
		</div>		
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="advance_received">Advance Received</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" class="form-control has-feedback-left discount_offered" name="advance_received" id="advance_received" value="<?php if(!empty($sale_order)) echo $sale_order->advance_received; ?>">
			</div>
		</div>					
		
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="control-label col-md-2 col-sm-2 col-xs-4" for="discount_offered">Discount Offered</label>
			<div class="col-md-10 col-sm-10 col-xs-8">
				<div class="checkbox">				
					<?php 					
						$discountOffered = discountOffered();
						foreach($discountOffered as $do){ 
										
						?>
							<label><input type="checkbox" class="flat" value="<?php echo $do ;?>" name="discount_offered[]" <?php if (!empty($sale_order)  && ($sale_order->discount_offered != 'null' )){							
								if(in_array($do,json_decode($sale_order->discount_offered), TRUE)){
									echo "checked";
									}  	
							}?>><?php echo $do;?></label>
						<?php }
					?>
					
				</div>
			
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="control-label col-md-2 col-sm-2 col-xs-4" for="label_printing_express">Label Printing Express </label>
			<div class="col-md-10 col-sm-10 col-xs-8">
				<input type="text" class="form-control has-feedback-left" name="label_printing_express" id="label_printing_express" value="<?php if(!empty($sale_order)) echo $sale_order->label_printing_express; ?>">
			</div>
		</div>				   
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="control-label col-md-2 col-sm-2 col-xs-4" for="brand_label">Brand / Label</label>
			<div class="col-md-10 col-sm-10 col-xs-8">
				<input type="text" class="form-control has-feedback-left" name="brand_label" id="brand_label" value="<?php if(!empty($sale_order)) echo $sale_order->brand_label; ?>">
			</div>
		</div>				   
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="control-label col-md-2 col-sm-2 col-xs-4" for="dispatch_documents">Documents to submit with dispatch </label>
			<div class="col-md-10 col-sm-10 col-xs-8">
				<div class="checkbox" name="dispatch_documents">
					<?php 					
						$documentSubmitedWithDispatch = documentSubmitedWithDispatch();
						foreach($documentSubmitedWithDispatch as $dswd){ ?>
							<label><input type="checkbox" class="flat" value="<?php echo $dswd ;?>" name="dispatch_documents[]" 
							<?php if (!empty($sale_order)  && ($sale_order->dispatch_documents != 'null' )){							
								if(in_array($dswd,json_decode($sale_order->dispatch_documents), TRUE)){
									echo "checked";
									}  	
							}  ?>><?php echo $dswd;?></label>
						<?php }
					?>
			  </div>
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="control-label col-md-2 col-sm-2 col-xs-4" for="product_application">Product Application</label>
			<div class="col-md-10 col-sm-10 col-xs-8">
				<input type="text" class="form-control has-feedback-left" name="product_application" id="product_application" value="<?php if(!empty($sale_order)) echo $sale_order->product_application; ?>">
			</div>
		</div>   
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gaurantee">Guarantee/ Returnable Special Notes</label>
			<div class="col-md-10 col-sm-10 col-xs-8">
				<textarea id="gaurantee" rows="6" name="guarantee" class="form-control col-md-7 col-xs-12"><?php if(!empty($sale_order)) echo $sale_order->guarantee; ?></textarea>
			</div>
		</div>
		
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="certificate">Attachments</label>
						<div class="col-md-6 col-sm-6 col-xs-12 fields_wrap">
							<input type="file" class="form-control col-md-7 col-xs-12" name="attachment[]"> </div>
						<button class="btn btn-warning field_button" type="button"><i class="fa fa-plus"></i></button>
				</div>
				
				
					<?php if(!empty($attachments)){?>
							<div class="item form-group">
								<div class="col-md-12 outline">
									<?php foreach($attachments as $attachment){
												echo '<div class="img-wrap"><div class="col-md-1 img-outline"><a href="javascript:void(0)" class="delete_listing close-link cross" style="z-index:111;" data-href="'.base_url(). 'crm/deleteAttachment/'.$attachment[ 'id']. '"><i class="fa fa-trash" style="color:#e60a03;"></i></a><a href="'.base_url(). 'assets/modules/crm/uploads/'.$attachment[ 'file_name']. '" download><img style="height:50px;" src="'.base_url(). 'assets/modules/crm/uploads/'.$attachment[ 'file_name']. '" alt="image" class="img-responsive"/></a></div></div>';
									} ?>
								</div>
							</div>
						<?php } ?>
				
				
				
		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-6 col-md-offset-3">
				<button type="reset" class="btn btn-default">Reset</button>
				<input type="submit" class="btn btn-warning" value="Submit">
			</div>
		</div>
	</form>	
	
