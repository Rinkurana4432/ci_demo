<?php #pre($pi); ?>
<?php
$last_id = getLastTableId('proforma_invoice');
$rId = $last_id + 110;
$piCode = 'PIR_' . rand(1, 1000000) . '_' . $rId;
/************** Revised Purchase order generation ******************/
$currentRevisedPIChar = 'A';
$nextRevisedPIChar = chr(ord($currentRevisedPIChar) + 1);
$revisedPOCode = '';
$revisedPICode = '';
if ($pi && $pi->save_status == 1) {
	if($pi->pi_code == ''){
		echo " ";
	}else{
	$pi_code_array = explode('_', $pi->pi_code, 4);
	 if(!empty($pi_code_array[2]) && $pi_code_array[2] == ''){
		$currentRevisedPIChar = 'A';
		$revisedPICode = $pi->pi_code.'_'.$currentRevisedPIChar.'(Revised)';
	}else if(!empty($pi_code_array[2]) && $pi_code_array[2] != ''){
		$orignalOrderCode = $pi_code_array[0].'_'.$pi_code_array[1].'_'.$pi_code_array[2];
		$currentRevisedPIChar = explode('(', $pi_code_array[2], 1);
		$nextRevisedPIChar = chr(ord($currentRevisedPIChar[0]) + 1);
		$revisedPICode = $orignalOrderCode.'_'.$nextRevisedPIChar.'(Revised)';
	}
	}
}
/************** Revised Proforma Invoice generation ******************/

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


$deliverySetting =  getNameById('company_detail',$this->companyGroupId,'id');

?>
<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <div id="wizard" class="form_wizard wizard_horizontal  status-1">

		      	<ul class="wizard_steps status" style="margin: 0 100px 20px; width: 65%;">
                       
						<?php //This conditions is check po created or not 
						
							if(!empty($pi)  && $pi->save_status == 1 && $pi->convrtd_frm_quot_to_pi == 1)
							{

						?>
                        <li> 
                          <a href="javascript:void(0);">
                            <span class="dsgn_cls"><p>Proforma Invoice</p><i class="fa fa-file-text"></i></span>
                            <span class="step_descr"><small></small></span>
                          </a>
                        </li>
					<?php }

					else { 

						?>
						<li>
                          <a href="javascript:void(0);">
                            <span class="not_value"><p>Proforma Invoice</p><i class="fa fa-file-text"></i></span>
                            <span class="step_descr"><small></small></span>
                          </a>
                        </li>
					<?php } 
					if(!empty($pi) && $pi->save_status == 1 && $pi->convrtd_frm_quot_to_so == 1)
							{

						?>
                        <li>
                         <a href="javascript:void(0);">
						  <!-- not_value -->
                            <span class="dsgn_cls"><p>Sale Order</p><i class="fa fa-cart-plus"></i></span>
                            <span class="step_descr"><small></small></span>
                        </a>
                        </li>
					<?php } else { ?>  
						<li>
                         <a href="javascript:void(0);">
						    <span class="not_value"><p>Sale Order</p><i class="fa fa-cart-plus"></i></span>
                            <span class="step_descr"><small></small></span>
                        </a>
                        </li>
					<?php }


					?>
                    </ul>
				</div>

						</div>

									</div>

												</div>


<div id="print_divv" class="col-md-12 col-sm-12 col-xs-12"  style="padding:0px;"> 
	<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class=" item form-group form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="code">Performa Invoice No.</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div><?php if((!empty($pi))){ echo $pi->pi_code;}  ?></div>
			</div>
		</div>
		<div class=" item form-group form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Order Date<span class="required">*</span></label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<span><?php if(!empty($pi) && $pi->order_date!=''){ echo $pi->order_date; }else {echo date("d-m-Y");}?></span>
			</div>
		</div>
		<div class=" item form-group form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="freight">Type</label>
			<div class="col-md-6 col-sm-12 col-xs-12" style="top: 5px;">
				Part Load:<input type="radio" class="flat calcDiscount" name="load_type" id="genderM" value="part_load" <?php if(!empty($pi->load_type) && $pi->load_type == "part_load"){ echo "checked=checked"; } ?> disabled>
				Full Load:<input type="radio" class="flat calcDiscount" name="load_type" id="genderF" value="full_load" <?php if(!empty($pi->load_type) && $pi->load_type == "full_load"){ echo "checked=checked"; } ?> disabled>
				None:<input type="radio" class="flat calcDiscount" name="load_type" id="genderF" value="none" <?php if(!empty($pi->load_type) && $pi->load_type == "none"){ echo "checked=checked"; } ?> disabled>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
		<div class=" item form-group form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Buyer  Name<span class="required">*</span></label>
				<div class="col-md-6 col-sm-12 col-xs-12">
					
						<?php
							if(!empty($pi)){
								$account = getNameById('account',$pi->account_id,'id');
								echo $account->name;
							}
						?>
					
				</div>
		</div>
		<div class=" item form-group form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="city">Phone Number</label>															
			<div class="col-md-6 col-sm-12 col-xs-12">
				<?php
						if(!empty($pi)){
							$account = getNameById('account',$pi->account_id,'id');
						echo $account->phone;
						}
					?>
			</div>
		</div>
	</div>

<hr>
<div class="bottom-bdr"></div>
<div class="container mt-3">

  <!-- Nav tabs -->
  <ul class="nav tab-3 nav-tabs">
    <li class="nav-item active">
      <a class="nav-link " data-toggle="tab" href="#Material-Details">Material Details</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#Customer-Details">Customer-Details </a>
  </li>
  <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#Shipping-Details" aria-expanded="true">Shipping-Details<!-- <span class="required">*</span>  --></a>
    </li>
  </ul>
 <div class="tab-content tab-to-mrgn">
 <div id="Customer-Details" class="container tab-pane ">
      <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="col-md-3 col-sm-12 col-xs-12" for="address">Customer Address</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<?php  
								   	if(!empty($pi)){
								   	$account = getNameById('account',$pi->account_id,'id');
								   	if(!empty($account->new_billing_address)){
										$new_billing_address = json_decode($account->new_billing_address);
										$cc=1;
										foreach ($new_billing_address as $key => $billing_address) {
										if($cc == 1){
										$billing_company_1 = $billing_address->billing_company_1;
										$billing_street_1 = $billing_address->billing_street_1;
										$billing_zipcode_1 = $billing_address->billing_zipcode_1;
										$billing_phone_addrs = $billing_address->billing_phone_addrs;
										$billing_gstin_1 = $billing_address->billing_gstin_1;
										$city = getNameById('city', $billing_address->billing_city_1,'city_id');
										$state = getNameById('state',$billing_address->billing_state_1,'state_id');
										$country = getNameById('country',$billing_address->billing_country_1,'country_id');
										$billing_city_1 = !empty($city)?$city->city_name:'';
										$billing_state_1 = !empty($state)?$state->state_name:'';
										$billing_country_1 = !empty($country)?$country->country_name:'';
										echo '<textarea id="address" rows="6" name="address" class="form-control col-md-7 col-xs-12 customer_address_dtl" placeholder="" readonly>'.$billing_company_1.''.PHP_EOL.''.$billing_street_1.''.PHP_EOL.''.$billing_city_1.''.PHP_EOL.''.$billing_state_1.''.PHP_EOL.''.$billing_country_1.''.PHP_EOL.''.$billing_zipcode_1.'</textarea>';
										}
										$cc++;
										}
										}
								 		} else {
								 		echo '<textarea id="address" rows="6" name="address" class="form-control col-md-7 col-xs-12 customer_address_dtl" placeholder="" readonly></textarea>';
								 		}
								 		?>
								</div>
						</div>
						 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="col-md-3 col-sm-12 col-xs-12" for="gstin">GSTIN</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<input type="text" id="gstin" name="gstin" class="form-control col-md-7 col-xs-12 gstin" value="<?php if(!empty($pi) && !empty($account)) echo $billing_gstin_1; ?>" onblur="fnValidateGSTIN(this)" readonly="readonly">
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="col-md-3 col-sm-12 col-xs-12" for="email">Email</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<input type="email" id="email" name="email" class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php if(!empty($pi) && !empty($account)) echo $account->email; ?>" readonly="readonly">
							</div>
						</div>

	  </div>
	  <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	        <div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-12 col-xs-12" for="email">Phone No.</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="tel" id="phone_no" name="phone_no"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($pi) && !empty($account)) echo $account->phone; ?>" readonly>
				</div>
			</div>
			<div class="item form-group col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-3 col-sm-12 col-xs-12" for="contact_person">Contact Person</label>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" id="contact_name" name="contact_id" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($pi) && !empty($account)) echo $account->contact_name; ?>" readonly="readonly">
					</div>
			</div>
			<div class="item form-group col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-3 col-sm-12 col-xs-12" for="contact_phone_no">Contact No.</label>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" id="contact_phone_no" name="contact_phone_no"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($pi)) echo $billing_phone_addrs; ?>" readonly>
				</div>
			</div>
	  </div>
 </div>
  <div id="Material-Details" class="container tab-pane active">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
	<div class="panel">
			<div class="">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group input_productre middle-box">
				<?php if(empty($pi)){ ?>
				    <div class="col-sm-12  col-md-12 label-box mobile-view_2">
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Product Code<span class="required">*</span></label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Special Requirement</label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name<span class="required">*</span></label></div> 
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Pro-Image</label></div>
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
						 <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" id="material_type_id" name="material_type_id[]" data-id="material_variants" data-key="id" data-fieldname="item_code" data-where="status=1" tabindex="-1" aria-hidden="true" onchange="getvarientList(event,this)" id="material_type">
								<option value="">Select Option</option>
							</select> 
						</div>
						<div class="col-md-1 col-sm-12 col-xs-12 item form-group">
							<label class="col-md-12">Special Requirement</label>
							<textarea name="description[]" placeholder="Special Requirement" class="form-control col-md-7 col-xs-12" class="description"></textarea>
						</div>
						<div class="col-md-2 col-sm-12 col-xs-12 item form-group" style="overflow-y: scroll;">
					        <label class="col-md-12" terial Name>Material Name  <span class="required">*</span></label>
						 
							<select class="form-control selectAjaxOption select2 set_mat_name materialNameId Add_mat_onthe_spot" required="required" name="product[]" width="100%" onchange="getTax(event,this)" id="material">
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
								</div>
								
					</div>
                    
					<?php } else{
						$products = json_decode($pi->product);
						?>
						
						<div class="col-sm-12  col-md-12 label-box mobile-view_2">
							<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Type<span class="required">*</span></label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Special Requirement</label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name<span class="required">*</span></label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Pro-Image</label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Quantity</label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label >UOM</label></div>
                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Price</label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>GST</label></div>
                                    <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Total</label></div>
								   <!--div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">GST Total2</label></div-->
								</div>
						<?php
						if(!empty($products)){
								$i =  1;
								$ck = 0;
								$subtotal = 0;
								$gst = 0;
								foreach($products as $product){
									
								$subtotal += $product->individualTotal;
								$gst += $product->individualTotal*($product->gst/100);
								
								?>
									<div class="well <?php if($i==1){ echo 'edit-row1 scend-tr mobile-view';}else{ echo 'scend-tr mobile-view';}?>"  id="chkWell_<?php echo $i; ?>" style="overflow:auto; ">
										<div class="col-md-2 col-sm-12 col-xs-12 item form-group">
											<label>Material Type<span class="required">*</span></label>
											<div class="form-control" readonly="readonly">
												<?php
												if(!empty($pi)){
													$mat_type = json_decode($pi->material_type_id);
													$material_type_id = getNameById('material_variants',$mat_type[$ck],'id');
													echo @$material_type_id->item_code;
													}
												?>
											</div>
										</div>
										<div class="col-md-1 col-sm-12 col-xs-12 item form-group">
											<label>Special Requirement</label>
											<div class="form-control col-md-7 col-xs-12" class="description" readonly="readonly"><?php echo $product->description ; ?></div>
										</div>
										<div class="col-md-2 col-sm-12 col-xs-12 item form-group">
											<label>Material Name<span class="required">*</span></label>
											<div class="form-control" readonly="readonly" style="word-wrap: break-word;overflow-y: scroll;">
												<?php
													if(!empty($product)){
														$material = getNameById('material',$product->product,'id');
														echo $material->material_name;
													}
												?>
											</div>
										</div>
                                         <div class="col-md-1 col-sm-12 col-xs-12 item form-group">
											<label>Pro-Image</label>
											<div class="Product_Image col-xs-12" readonly="readonly">
											<?php
											$mat_name = $product->product;
									    $mat_details = getNameById('material', $mat_name, 'id');
									    $mat_id = $mat_details->id;
									    $attachments = $this->crm_model->get_image_by_materialId('attachments', 'rel_id', $product->product);
									    if(!empty($attachments)){
									    echo '<img style="width: 50px; height: 50px;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
									  	} else {
									  		echo '<img style="width: 50px!important; height: 50px!important;" src="'.base_url().'assets/modules/crm/uploads/no_image.jpg"><input type="hidden" name="pro_img[]" value="'.base_url().'assets/modules/crm/uploads/no_image.jpg">';
									  	}
											?>
											</div>
										</div>
										<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										    <label>Quantity</label>
											<div class="form-control col-md-7 col-xs-12 quantity" readonly="readonly"><?php echo $product->quantity ;?></div>
										</div>
										<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										    <label>UOM</label>
											<div class="form-control col-md-7 col-xs-12 uom mat_uom" readonly><?php
											$ww =  getNameById('uom', $product->uom,'id');
												echo $uom = !empty($ww)?$ww->ugc_code:'';
											?> </div>
										</div>
										<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										     <label>Price</label>
											<div class="form-control mat_sales_price" readonly="readonly"><?php echo $product->price ;?></div>

										</div>
										<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										    <label>GST</label>
											<div class="form-control col-md-7 col-xs-12 gst mat_tax" readonly="readonly"> <?php echo chop($product->gst,"%") ;?><?php echo $product->individualTotal*($product->gst/100); ?></div>
										</div>
										<div class="col-md-2 col-sm-6 col-xs-12 form-group">
										    <label>Total</label>
											<input type="text" name="totals[]" class="form-control col-md-7 col-xs-12 total" value="<?php echo $product->individualTotal ;?>" readonly>

										</div>
									</div>
					<?php $i++; $ck++; }
					}
				}?>
				</div>
              <?php  
								   	if(!empty($pi)){
								   	$account = getNameById('account',$pi->account_id,'id');
								   	$type_of_customer = $account->type_of_customer;
										$type_of_customer_data = $this->crm_model->get_data_byId('types_of_customer', 'id', $type_of_customer);
										$calcDiscount_val = $pi->load_type;
										if($calcDiscount_val == 'none'){
										$discount_rate = "0";
										} else {
										@$discount_rate = $type_of_customer_data->$calcDiscount_val;	
										}
										$discount_value = $subtotal*($discount_rate/100);
										}
										?>  
				<!--<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">


							<div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 18px;color: #2C3A61; ">
						<div class="col-md-7 col-sm-5 col-xs-6 text-right">
						  <input type="hidden"  name="total" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($pi)) echo $pi->total; ?>">
							<strong>Total:</strong>&nbsp;&nbsp;
							</div>
							<div class="col-md-5 col-sm-5 col-xs-6 text-left">
							      <span class="fa fa-rupee divSubTotal"><?php if(!empty($pi)){ echo $pi->total ; } else{ echo 0; }?></span>
							</div>

						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 18px;color: #2C3A61; border-top: 1px solid #2C3A61;">
						<div class="col-md-7 col-sm-5 col-xs-6 text-right">
						  <input type="hidden"  name="grandTotal" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($pi)) echo $pi->grandTotal; ?>">
							<strong>Grand Total:</strong>&nbsp;
							</div>
							<div class="col-md-5 col-sm-5 col-xs-6 text-left">
							     <span class="fa fa-rupee divTotal"><?php if(!empty($pi)){ echo $pi->grandTotal ; } else{ echo 0; }?></span>
							</div>

						</div>
					</div>


				</div>-->


			</div>
		</div>
	</div>
  </div>
  
  <div id="Shipping-Details" class="container tab-pane">
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="Addresses">
            Choose Address<!-- <span class="required">*</span> -->
         </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select name="ship_state_id" id="sc_address" class="itemName form-control requiredData c_addressChoose121" disabled >
               <option value="">Select Address</option>
               <?php  
					if(!empty($pi)){
					$account = getNameById('account',$pi->account_id,'id');
					if(!empty($account->new_shipping_address)){
						$new_billing_address = json_decode($account->new_billing_address);	
						$same_ship_array = array();
						foreach ($new_billing_address as $key => $billing_address) {
						if(!empty($billing_address->same_shipping) && $billing_address->same_shipping == 1){
						$same_ship_array[$key]['shipping_company_1'] = $billing_address->billing_company_1;
						$same_ship_array[$key]['shipping_street_1'] = $billing_address->billing_street_1;
						$same_ship_array[$key]['shipping_country_1'] = $billing_address->billing_country_1;
						$same_ship_array[$key]['shipping_state_1'] = $billing_address->billing_state_1;
						$same_ship_array[$key]['shipping_city_1'] = $billing_address->billing_city_1;
						$same_ship_array[$key]['shipping_zipcode_1'] = $billing_address->billing_zipcode_1;
						$same_ship_array[$key]['shipping_phone_addrs'] = $billing_address->billing_phone_addrs;
						$same_ship_array[$key]['same_shipping'] = $billing_address->same_shipping;
						}
						}
						$new_shipping_address = json_decode($account->new_shipping_address, true);	
						$new_ship_cmArray = array_merge($same_ship_array, $new_shipping_address);
						$cs = 1;
						foreach ($new_ship_cmArray as $key => $shipping_address) {
						if($cs == 1){
						$sel = 'selected';
						} else {
						$sel = '';
						}
						$shipping_company_1 = $shipping_address['shipping_company_1'];
						$shipping_street_1 = $shipping_address['shipping_street_1'];
						$shipping_zipcode_1 = $shipping_address['shipping_zipcode_1'];
						$city = getNameById('city', $shipping_address['shipping_city_1'],'city_id');
						$state = getNameById('state',$shipping_address['shipping_state_1'],'state_id');
						$country = getNameById('country',$shipping_address['shipping_country_1'],'country_id');
						$shipping_city_1 = !empty($city)?$city->city_name:'';
						$shipping_state_1 = !empty($state)?$state->state_name:'';
						$shipping_country_1 = !empty($country)?$country->country_name:'';
						echo '<option '.$sel.' data-address="'.$shipping_company_1.''.PHP_EOL.''.$shipping_street_1.''.PHP_EOL.''.$shipping_city_1.''.PHP_EOL.''.$shipping_state_1.''.PHP_EOL.''.$shipping_country_1.''.PHP_EOL.''.$shipping_zipcode_1.'" value="'.$shipping_address['shipping_company_1'].'">'.$shipping_address['shipping_company_1'].'</option>';
						$cs++;
						}
						}
						}
					?>
            </select>
         </div>
      </div>
      <div class="item form-group"><br><br>
         <label class="col-md-3 col-sm-12 col-xs-12" for="address">Shipping Address </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
         	<?php  
			   	if(!empty($pi)){
			   	$account = getNameById('account',$pi->account_id,'id');
			   	if(!empty($account->new_shipping_address)){
					$new_billing_address = json_decode($account->new_billing_address);	
					$same_ship_array = array();
					foreach ($new_billing_address as $key => $billing_address) {
					if(!empty($billing_address->same_shipping) && $billing_address->same_shipping == 1){
					$same_ship_array[$key]['shipping_company_1'] = $billing_address->billing_company_1;
					$same_ship_array[$key]['shipping_street_1'] = $billing_address->billing_street_1;
					$same_ship_array[$key]['shipping_country_1'] = $billing_address->billing_country_1;
					$same_ship_array[$key]['shipping_state_1'] = $billing_address->billing_state_1;
					$same_ship_array[$key]['shipping_city_1'] = $billing_address->billing_city_1;
					$same_ship_array[$key]['shipping_zipcode_1'] = $billing_address->billing_zipcode_1;
					$same_ship_array[$key]['shipping_phone_addrs'] = $billing_address->billing_phone_addrs;
					$same_ship_array[$key]['same_shipping'] = $billing_address->same_shipping;
					}
					}
					$new_shipping_address = json_decode($account->new_shipping_address, true);	
					$new_ship_cmArray = array_merge($same_ship_array, $new_shipping_address);
					$cd = 1;
					foreach ($new_ship_cmArray as $key => $shipping_address) {
					if($cd == 1){
					$shipping_company_1 = $shipping_address['shipping_company_1'];
					$shipping_street_1 = $shipping_address['shipping_street_1'];
					$shipping_zipcode_1 = $shipping_address['shipping_zipcode_1'];
					$city = getNameById('city', $shipping_address['shipping_city_1'],'city_id');
					$state = getNameById('state',$shipping_address['shipping_state_1'],'state_id');
					$country = getNameById('country',$shipping_address['shipping_country_1'],'country_id');
					$shipping_city_1 = !empty($city)?$city->city_name:'';
					$shipping_state_1 = !empty($state)?$state->state_name:'';
					$shipping_country_1 = !empty($country)?$country->country_name:'';
					echo '<textarea id="saddress" rows="6" name="ship_address" class="form-control col-md-7 col-xs-12 shipping_address_dtl" placeholder="" readonly>'.$shipping_company_1.''.PHP_EOL.''.$shipping_street_1.''.PHP_EOL.''.$shipping_city_1.''.PHP_EOL.''.$shipping_state_1.''.PHP_EOL.''.$shipping_country_1.''.PHP_EOL.''.$shipping_zipcode_1.'</textarea>';
					}					
					$cd++;
					}
					}
			 		} else {
			 		echo '<textarea id="saddress" rows="6" name="ship_address" class="form-control col-md-7 col-xs-12 shipping_address_dtl" placeholder="" readonly></textarea>';
			 		}
			 		?>	
         </div>
      </div>
   </div>
</div>
<hr>
<div class="bottom-bdr"></div>
<h3 class="Material-head">Other Details<hr></h3>


	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
		<div class=" ">
			<div>
				<div class="item form-group col-md-6 col-sm-12 col-xs-12 vertical-border">
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-3 col-sm-12 col-xs-12" for="discount_offered">Discount Rate</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<?php echo $discount_rate; ?>
						</div>
					</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-3 col-sm-12 col-xs-12" for="discount_offered">CBF</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<?php if(!empty($pi)) { echo $pi->pi_cbf; } else { echo '0'; }  ?>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-3 col-sm-12 col-xs-12" for="discount_offered">Weight</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<?php if(!empty($pi)) { echo $pi->pi_weight; } else { echo '0'; }  ?>
						</div>
					</div>
					
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-3 col-sm-12 col-xs-12" for="discount_offered">Payment Mode</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="checkbox pi_paymode_list">
								<?php
								if(!empty($pi)) {
								 $pi_paymode = json_decode($pi->pi_paymode, true); 
								}
								if(!empty($pi_paymode)){ ?>
									<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Cash" name="pi_paymode[]" <?php if(in_array('Cash', $pi_paymode)){ echo "checked";} ?> disabled>Cash</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Debit Card" name="pi_paymode[]" <?php if(in_array('Debit Card', $pi_paymode)){ echo "checked";} ?> disabled>Debit Card</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Credit Card" name="pi_paymode[]" <?php if(in_array('Credit Card', $pi_paymode)){ echo "checked";} ?> disabled>Credit Card</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Cheque" name="pi_paymode[]" <?php if(in_array('Cheque', $pi_paymode)){ echo "checked";} ?> disabled>Cheque</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Online Transfer" name="pi_paymode[]" <?php if(in_array('Online Transfer', $pi_paymode)){ echo "checked";} ?> disabled>Online Transfer</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Credit" name="pi_paymode[]" <?php if(in_array('Credit', $pi_paymode)){ echo "checked";} ?> disabled>Credit</label>
								<?php } else { ?>
									<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Cash" name="pi_paymode[]" disabled>Cash</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Debit Card" name="pi_paymode[]" disabled>Debit Card</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Credit Card" name="pi_paymode[]" disabled>Credit Card</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Cheque" name="pi_paymode[]" disabled>Cheque</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Online Transfer" name="pi_paymode[]" disabled>Online Transfer</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Credit" name="pi_paymode[]"  disabled>Credit</label>
								<?php }	?>
						</div>
						</div>
					</div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="permitted_by">
						<label class="col-md-3 col-sm-12 col-xs-12" for="city">Permitted By</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<?php if(!empty($pi)) { echo $pi->pi_permitted; }  ?>
						</div>
					</div> 
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="remarks_by">
						<label class="col-md-3 col-sm-12 col-xs-12" for="city">Remark</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<?php if(!empty($pi)) { echo $pi->pi_remarks; }  ?>
						</div>
					</div>  
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-3 col-sm-12 col-xs-12" for="city">Advance Payment</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<?php if(!empty($pi)) echo $pi->advance_received; ?>
						</div>
					</div>
				</div>
				<div class="item form-group col-md-6 col-sm-12 col-xs-12 vertical-border">
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-3 col-sm-12 col-xs-12" for="freight">Special Discount(%)</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
						<?php if(!empty($pi)) { echo $pi->special_discount; } else { echo '0'; }  ?>
							
						</div>
					</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12" id="sda_by">
						<label class="col-md-3 col-sm-12 col-xs-12" for="freight">Special Discount Authorized</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
						<?php if(!empty($pi)) { echo $pi->special_discount_authorized; } else { echo ''; }  ?>
							
						</div>
					</div>
				<div class="form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-3 col-sm-12 col-xs-12" for="freight">Freight</label>
						<div class="col-md-6 col-sm-12 col-xs-12" style="top: 5px;">
							ActualBasis:<input type="radio" class="flat" name="freight" id="genderM" value="FOR price" <?php if(!empty($pi) && $pi->freight == 'FOR price') echo 'checked'; else echo 'checked'; ?>  disabled/>
							Fixed Amount:<input type="radio" class="flat" name="freight" id="genderF" value="To be paid by customer" <?php if(!empty($pi) && $pi->freight == 'To be paid by customer') echo 'checked'; ?> disabled/>
						</div>
					</div>
				  <div class="col-md-12 col-sm-12 col-xs-12 item form-group" id="freight1">
					<label class="col-md-3 col-sm-12 col-xs-12" for="purpose">Freight (Rs)</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
					  <?php  if (!empty($pi->freightCharges)) {	echo $pi->freightCharges;	} ?>
					</div> 
				  </div>
					<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
						<label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Estimated Dispatch Date</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<?php if(!empty($pi) && $pi->dispatch_date!=''){ echo $pi->dispatch_date; }else {echo date("d-m-Y");}?>
						</div>
					</div>
					
					
				</div>
			</div>
		</div>
	</div>
	<div class="boxSec mb-3 mb-md-0 borderLable purchaseInfo col-md-4" style="float: right;">
				 					<?php  
								   	if(!empty($pi)){
								   	$account = getNameById('account',$pi->account_id,'id');
								   	$type_of_customer = $account->type_of_customer;
										$type_of_customer_data = $this->crm_model->get_data_byId('types_of_customer', 'id', $type_of_customer);
										
										$calcDiscount_val = $pi->load_type;
										$pi_cbf = $pi->pi_cbf;
										$pi_weight = $pi->pi_weight;
										$pi_paymode = $pi->pi_paymode;
										$pi_permitted = $pi->pi_permitted;
										$special_discount = $pi->special_discount;
										$freightCharges = $pi->freightCharges;
										$advance_received = $pi->advance_received;
										$extra_charges = $pi->extra_charges;
										
										 
										if($calcDiscount_val == 'none'){
										$discount_rate = "0";
										} else {
										@$discount_rate = $type_of_customer_data->$calcDiscount_val;	
										}
										$discount_value = $subtotal*($discount_rate/100);
										$spd_value = $subtotal*($special_discount/100);
										$total = $subtotal - $discount_value - $spd_value;
										$gfc = $freightCharges*18/100;
										if($discount_value !=0){
											$spd_value = $discount_value*($special_discount/100);
											$total = $discount_value - $spd_value;
											
											foreach($products as $getTax){
												$gst = $total*($getTax->gst/100);
												$grand_total = (float)$total+(float)$gst+(float)$freightCharges+(float)$gfc;
											}
											
											
										}
										$remain_balance = (float)$grand_total-(float)$advance_received;
										 $remain_balance = (int)$remain_balance + (int)$extra_charges;
									
										// pre($remain_balance);
										
										
									}
										?>
				   <ul class="laserAddress space">
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Subtotal:-</div>
							<div class="col-md-7 text-right addColenAfter"><span class="blueColor text-nowrap divSubTotal"><?php echo $subtotal; ?></span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Discount value (<?php echo $discount_rate; ?>) :-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divDiscountValue">
							<?php
							echo $discount_value;
							?>
							</span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Special Discount value:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divSpecialDiscount"><?php
							echo $spd_value;
							?></span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Total:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divTotal"><?php echo $total; ?></span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Tax:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divTax"><?php echo $gst; ?></span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Freight Charge:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divFreightCharge"><?php echo $freightCharges; ?></span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">GST on the Freight:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divGSTFreight"><?php echo $gfc; ?></span></div>
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
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divGrandTotal"><?php echo $grand_total; ?></span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Advance Paid amount:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divAdvancePaid"><?php echo $advance_received; ?></span></div>
						 </div>
					  </li>
					   <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Extra Charges :-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap extraChargesVal"><?php if(!empty($extra_charges)) { echo $extra_charges; } ?></span></div>
							
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Balance:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divBalance"><?php echo $remain_balance; ?></span></div>
						 </div>
					  </li>

				   </ul>
				</div>
</div>
<center>
	<!-- <button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button> -->
	<?php  if(!empty($pi) && $pi->save_status == 1) { ?>
	<a href=" <?php echo base_url().'crm/create_pdf/'.$pi->id; ?>" target="_blank"><button class="btn edit-end-btn ">Generate PDF</button></a>
	
	<button class="btn edit-end-btn sharevia_email_cls ">Share Via Email</button>
	<a href="<?php echo base_url(); ?>crm/download_pdf/<?php echo $pi->id; ?>"><button class="btn edit-end-btn">Share via Whatsapp</button></a>

	<?php } ?>
</center>
	
	
<div id="activity" class="col-md-12 col-sm-12 col-xs-12 tab-pane active" style="display:none;">
	<div class="Activities" >	
  <h3 class="Material-head">Recent Comment<hr></h3>
	<ul class="messages activityMessage col-md-12 col-sm-12 col-xs-12">
		 <?php  if(!empty($account_activities)){ 
			foreach($account_activities as $activity){?>
                         
                                
			
	<li>                <div class="col-md-12 col-xs-12 head">
	<div class="col-md-4 col-xs-12">
	<span><img src="/assets/images/chat-icon.png"></span>
	<div class="message_wrapper">
	<h5 class="heading"><?php echo $activity['rel_type'];  ?></h5>
	</div>
	</div>
	<div class="message_date col-md-4">
	<?php echo $activity['date']; ?>
	</div>
	</div>
	<div class="col-md-12 col-xs-12 " style="text-align: left;">
	<p class="message">  
	<?php echo $activity['apply_comment']; 


	$item = 'Sale Order Deleted'; 

	$item1 = 'Quotation Deleted';




	$item2 = 'Proforma Invoice Deleted';
	if($item == $activity['apply_comment'] || $item1 == $activity['apply_comment'] || $item2 == $activity['apply_comment'] ){ 
	echo " "; 
	} 
	else{ 

	$state2 = getNameById('proforma_invoice',$activity["rel_id"],'id');

	$state3 = getNameById('quotation',$activity["rel_id"],'id');

	$state4 = getNameById('sale_order',$activity["rel_id"],'id');


	} 


	?>
	</p>

	</div>

	</li>
                             
<?php }



}else
{
	echo '<div class="oops"><img src="http://busybanda.com/assets/images/no-activityes.jpg"></div>';					 
} 

?>
                            </ul>

	

	
	</div>
</div>


<div class="modal fade" id="myModal_share_email" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="myModalLabel">Share</h4>
<span id="mssg"></span>
</div>
<form name="form_share_viaEmail" name="share_form"  id="form_share_viaEmail_id">
<div class="modal-body">
<div class="item form-group col-md-12 col-sm-12 col-xs-12">
<input type="hidden" class="order_id" value='<?php echo $pi->id; ?>' name="order_id" >
<label class="col-md-2 col-sm-2 col-xs-4" for="name">Email<span class="required">*</span></label>
<div class="col-md-10 col-sm-10 col-xs-8 form-group">
<input type="text" name="email_name" id="email_name" required="required" class="form-control col-md-7 col-xs-12" value="">
<span class="spanLeft control-label"></span>  
</div>
</div>
<div class="item form-group col-md-12 col-sm-12 col-xs-12">
<label class="col-md-2 col-sm-2 col-xs-4" for="name">Message</label>
<div class="col-md-10 col-sm-10 col-xs-8 form-group">
<textarea id="email_msg_id" name="email_msg"  class="form-control col-md-7 col-xs-12" placeholder="Message ..." ></textarea>
<span class="spanLeft control-label"></span>
</div>
</div>

<div class="modal-footer">
<input type="hidden" id="sale_ledger_data">
<button type="button" class="btn btn-default close_sec_model" >Close</button>
<button id="share_via_Email" type="button" class="btn btn-warning">Submit</button>
</div>
</form>
</div>
</div>
</div>
	

					