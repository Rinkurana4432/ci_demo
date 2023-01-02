<?php
$last_id = getLastTableId('sale_order');
$rId = $last_id + 110;
$soCode = 'SOR_' . rand(1, 1000000) . '_' . $rId;
/************** Revised Purchase order generation ******************/
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
$currentRevisedPIChar = 'A';
$nextRevisedPIChar = chr(ord($currentRevisedPIChar) + 1);
$revisedPOCode = '';
$revisedPICode = '';
if ($pi && $pi->save_status == 1) {
	if($pi->pi_code == ''){
		echo " ";
	}else{
	$pi_code_array = explode('_', $pi->pi_code, 4);
	
		// if($pi_code_array[2] == ''){
		 if(count($pi_code_array) < 2){
		$currentRevisedPIChar = 'A';
		#$nextRevisedPOChar = chr(ord($currentRevisedPOChar) + 1);
		$revisedPICode = $pi->pi_code.'_'.$currentRevisedPIChar.'(Revised)';
	//}else if($pi_code_array[2] != ''){
	}else if(count($pi_code_array) > 2){
		#echo $po_code_array[2];
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
<?php /*
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right" style="margin: 10px 0;">
	<?php  if(!empty($pi) && $pi->save_status == 1) { echo '<a href="'.base_url().'crm/create_pdf/'.$pi->id.'"><button class="btn edit-end-btn btn-sm">Generate PDF</button></a>'; } ?>
</div>
*/ ?>

<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>crm/convertPIIntoSaleOrdersave" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">

	<input type="hidden" name="id" value="<?php if(!empty($pi)){ echo $pi->id; }?>">
	<input type="hidden" name="save_status" value="1" class="save_status">
	<input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">

	<input type="hidden" name="revised_po_code" value="<?php  echo $revisedPICode;  ?>" class="revised_po_code">
	<input type="hidden" value="<?php  echo $deliverySetting->crm_delivery_setting;  ?>" id="crm_delivery_setting">

<h3 class="Material-head" style="margin-bottom: 30px;">Proforma Invoice Details<hr></h3>
	<?php
	if (!empty($pi)) {
		$newDate = date("j F , Y", strtotime($pi->created_date));
		?>
		<p><br />
			<center><b>Proforma Invoice No.  : </b> <?php echo $pi->pi_code; ?> </center>
		</p>
		<center><b>Proforma Invoice Created Date : </b> <?php echo $newDate; ?> </center><br />
	<?php }  ?>





									<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
									<div class=" item form-group form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label class="col-md-3 col-sm-12 col-xs-12" for="code">Sale Order No.</label>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<input id="Purchase_code" class="form-control col-md-7 col-xs-12" name="so_order" type="text" value="<?php echo $soCode; ?>" readonly>
										</div>
									</div>
									<div class=" item form-group form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Order Date<span class="required">*</span></label>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<input type="text" class="form-control has-feedback-left datePicker" name="order_date" id="order_date" value="<?php if(!empty($pi) && $pi->order_date!=''){ echo $pi->order_date; }else {echo date("d-m-Y");}?>" required="required">
											<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
											<span id="inputSuccess2Status3" class="sr-only">(success)</span>
										</div>
									</div>
									<div class=" item form-group form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<label class="col-md-3 col-sm-12 col-xs-12" for="freight">Type</label>
													<div class="col-md-6 col-sm-12 col-xs-12" style="top: 5px;">
														Part Load:<input type="radio" class="flat calcDiscount" name="load_type" id="genderM" value="part_load" <?php if(!empty($pi->load_type) && $pi->load_type == "part_load"){ echo "checked=checked"; } ?>>
														Full Load:<input type="radio" class="flat calcDiscount" name="load_type" id="genderF" value="full_load" <?php if(!empty($pi->load_type) && $pi->load_type == "full_load"){ echo "checked=checked"; } ?>>
														None:<input type="radio" class="flat calcDiscount" name="load_type" id="genderF" value="none" <?php if(!empty($pi->load_type) && $pi->load_type == "none"){ echo "checked=checked"; } ?>>
													</div>
												</div>
									</div>
									<div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
									     <div class=" item form-group form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									               <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Buyer  Name<span class="required">*</span></label>
															<div class="col-md-6 col-sm-12 col-xs-12">
																<select class="customerName selectAjaxOption select2 form-control" name="account_id" data-id="account" data-key="id" data-fieldname="name" width="100%" id="account_id" data-where="account_owner = <?php 	echo $this->companyGroupId; ?> AND save_status = 1" id="account_id" required="required" onchange="getPhoneNumber(event,this);">
																	<option value="">Select Option</option>
																	<?php
																		if(!empty($pi)){
																			$account = getNameById('account',$pi->account_id,'id');
																			echo '<option value="'.$account->id.'" selected>'.$account->name.'</option>';
																		}
																	?>
																</select>
																<input type="hidden" name="accountid" id="account_id">
																<input type="hidden" id="serched_val">
															</div>
											</div>
											<div class="item form-group form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Unit<span class="required">*</span></label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<select class="form-control  select2 address" required="required" name="company_unit">
					<option value="">Select Option</option>
						<?php
							if(!empty($pi)){
								echo '<option value="'.$pi->company_unit.'" selected>'.$pi->company_unit.'</option>';
							}
							?>
				</select>
			</div>
		</div>
															<div class=" item form-group form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<label class="col-md-3 col-sm-12 col-xs-12" for="city">Phone Number</label>															
															<div class="col-md-6 col-sm-12 col-xs-12">
																<input type="text" class="phn_number form-control discount_offered" name="advance_received" id="advance_received" value="<?php
																		if(!empty($pi)){
																			$account = getNameById('account',$pi->account_id,'id');
																		echo $account->phone;
																		}
																	?>" placeholder="Enter Phone Number">
															</div>
														</div>
														
									</div>
									
									
								<hr>
								<div class="bottom-bdr"></div>









							<!--------start Detail tab --------------------->
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
	  <div class="item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="Addresses">Choose Address<!-- <span class="required">*</span> --></label>
								<div class="col-md-6 col-sm-12 col-xs-12">
								   <select name="party_state_id" id="c_address" class=" form-control c_address121">
								   <option value="">Select Address</option>
								   <?php  
								   	if(!empty($pi)){
								   	$account = getNameById('account',$pi->account_id,'id');
								   	if(!empty($account->new_billing_address)){
										$new_billing_address = json_decode($account->new_billing_address);
										$cc=1;
										foreach ($new_billing_address as $key => $billing_address) {
										if($cc == 1){
										$sel = 'selected';
										} else {
										$sel ="";
										}
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
										echo '<option '.$sel.' data-address="'.$billing_company_1.''.PHP_EOL.''.$billing_street_1.''.PHP_EOL.''.$billing_city_1.''.PHP_EOL.''.$billing_state_1.''.PHP_EOL.''.$billing_country_1.''.PHP_EOL.''.$billing_zipcode_1.'" value="'.$billing_street_1.'" data-gst="'.$billing_gstin_1.'">'.$billing_address->billing_company_1.'</option>';
										$cc++;
										}
										}
								 		}
								 		?>										   
											   </select>
			        </div>
		</div>
	  
	    
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
								<input type="text" id="gstin" name="gstin" class="form-control col-md-7 col-xs-12 gstin" value="<?php if(!empty($pi) && !empty($account)) echo $billing_gstin_1; ?>" onblur="fnValidateGSTIN(this)">
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="col-md-3 col-sm-12 col-xs-12" for="email">Email</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<input type="email" id="email" name="email" class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php if(!empty($pi) && !empty($account)) echo $account->email; ?>">
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
								<input type="text" id="contact_name" name="contact_id" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($pi) && !empty($account)) echo $account->contact_name; ?>">
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
     <!-- <div class="item form-group col-md-6 col-sm-12 col-xs-12 vertical-border">
		<label class="col-md-3 col-sm-12 col-xs-12" for="material">Material Type <span class="required">*</span></label>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" id="material_type_id" name="material_type_id" id="" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
				<option value="">Select Option</option>
				<?php
				if(!empty($pi) && $pi->material_type_id!=0){
					$material_type_id = getNameById('material_type',$pi->material_type_id,'id');
					echo '<option value="'.$pi->material_type_id.'" selected>'.$material_type_id->name.'</option>';
					}
				?>
			</select>
			<span class="spanLeft control-label"></span>
		</div>
	</div> -->
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
	<div class="panel">
			<div class="">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group input_productre middle-box">
				<?php if(empty($pi)){ ?>
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
						 <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" id="material_type_id" name="material_type_id[]" data-id="material_variants" data-key="id" data-fieldname="item_code" data-where="status=1" tabindex="-1" aria-hidden="true" onchange="getvarientList(event,this)" id="material_type">
								<option value="">Select Option</option>
							</select> 
						</div>
						<div class="col-md-2 col-sm-12 col-xs-12 item form-group">
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
						<div class="col-md-1 col-sm-12 col-xs-12 item form-group">
							<label class="col-md-12">Description</label>
							<textarea name="description[]" placeholder="Description of material" class="form-control col-md-7 col-xs-12" class="description"></textarea>
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
						$products = json_decode($pi->product);
						?>
						
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
								   <!--div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">GST Total2</label></div-->
								</div>
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
											<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" id="material_type_id" name="material_type_id[]" id="" data-id="material_variants" data-key="id" data-fieldname="item_code" data-where="status=1" tabindex="-1" aria-hidden="true" onchange="getvarientList(event,this)" id="material_type">
												<option value="">Select Option</option>
												<?php
												if(!empty($pi)){
													$mat_type = json_decode($pi->material_type_id);
													$material_type_id = getNameById('material_variants',$mat_type[$ck],'id');
													echo '<option value="'.$material_type_id->id.'" selected>'.$material_type_id->item_code.'</option>';
													}
												?>
											</select>
									 
										</div>
										<div class="col-md-2 col-sm-12 col-xs-12 item form-group">
											<label>Material Name<span class="required">*</span></label>
											<select class="materialNameId  form-control selectAjaxOption select2 Add_mat_onthe_spot set_mat_name" required="required" name="product[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid = <?php echo $this->companyGroupId; ?>" width="100%" onchange="getTax(event,this)" id="material">
												<option value="">Select Option</option>
												<?php
													if(!empty($product)){
														$material = getNameById('material',$product->product,'id');
														//pre();
														echo '<option value="'.$product->product.'" selected>'.$material->material_name.'</option>';
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
									    $mat_details = getNameById('material', $mat_name, 'id');
									    // $mat_id = $mat_details->id;
											if(!empty($mat_details->packing_data)){
											$packing_data = json_decode($mat_details->packing_data);
											$standard_packing = $mat_details->standard_packing;
											$cbf = $weight = 0;
											foreach ($packing_data as $key => $packing_value) {
											$packing_qty = $packing_value->packing_qty;
											$packing_cbf = $packing_value->packing_cbf;
											$packing_weight = $packing_value->packing_weight;
											@$cbf += $packing_cbf*$packing_qty;
											@$weight += $packing_weight*$packing_qty;
											}
											@$total_cbf = round($cbf/$standard_packing, 2);
											@$total_weight = round($weight/$standard_packing, 2);
											} else {
											@$total_cbf = $total_weight = 0;
											}
											$qty = $product->quantity;
											@$total_cbf_set += $qty*$total_cbf;
											@$total_weight_set += $qty*$total_weight;
									    $attachments = $this->crm_model->get_image_by_materialId('attachments', 'rel_id', $mat_name);
										
										if(!empty($attachments)){
											echo '<img style="width: 50px; height: 50px;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
										} else {
									  		echo '<img style="width: 50px!important; height: 50px!important;" src="'.base_url().'assets/modules/crm/uploads/no_image.jpg"><input type="hidden" name="pro_img[]" value="'.base_url().'assets/modules/crm/uploads/no_image.jpg">';
									  	}
											?>
											</div>
										</div>
										<div class="col-md-1 col-sm-12 col-xs-12 item form-group">
											<label>Description</label>
											<textarea name="description[]" placeholder="Description of material" class="form-control col-md-7 col-xs-12" class="description"><?php echo $product->description ; ?></textarea>
										</div>
										<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										    <label>Quantity</label>
											<input type="text" name="qty[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12 quantity" value="<?php echo $product->quantity ;?>" onkeyup="keyupFunction(event,this)"  onchange="keyupFunction(event,this)">
										</div>
										<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										    <label>UOM</label>
											<input type="text" name="uom[]"  placeholder="uom" class="form-control col-md-7 col-xs-12 uom mat_uom" value="<?php
											
											$ww =  getNameById('uom', $product->uom,'id');
												echo $uom = !empty($ww)?$ww->ugc_code:'';
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
										<!--div class="col-md-1 col-sm-6 col-xs-12 form-group">
										    <label>GST Total</label>
											<input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="<?php //echo $product->individualTotalWithGst ;?>" readonly>

										</div-->


											<button class="btn btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button>

									</div>
					<?php $i++; $ck++; }
					}
				}?>
				<div class="col-sm-12 btn-row"><button class="btn addProductButtonre edit-end-btn" type="button">Add</button></div>
				</div>
               
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
										
										if(!empty($pi->advance_received)){
											$advance_received = $pi->advance_received;
										}else{
											$advance_received =  0;
										}
										if($calcDiscount_val == 'none'){
										$discount_rate = "0";
										} else {
											if(!empty($type_of_customer_data->$calcDiscount_val)){
												$discount_rate = $type_of_customer_data->$calcDiscount_val;	
											}else{
												$discount_rate = 0;
											}
											// $discount_rate = $type_of_customer_data->$calcDiscount_val;	
										}
										$discount_value = $subtotal*($discount_rate/100);
										$spd_value = $subtotal*($special_discount/100);
										$total = $subtotal - $discount_value - $spd_value;
										$gfc = $freightCharges*18/100;
										$grand_total = $total+$gst+$freightCharges+$gfc;
										$remain_balance = $grand_total-$advance_received;
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
            <select name="ship_state_id" id="sc_address" class="itemName form-control requiredData c_addressChoose121">
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
      <div class="item form-group">
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
   <!--div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	        <div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="col-md-3 col-sm-12 col-xs-12" for="email">Phone No.</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
						   <input type="tel" id="phone_no" name="phone_no" class="form-control col-md-7 col-xs-12" value="" readonly=""></div>
</div>
</div-->
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
							<input id="discount_rate" class="form-control col-md-7 col-xs-12" name="discount_rate" type="text" value="<?php echo $discount_rate; ?>" readonly="">
						</div>
					</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-3 col-sm-12 col-xs-12" for="discount_offered">CBF</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<input id="pi_cbf" class="form-control col-md-7 col-xs-12" name="pi_cbf" type="text" value="<?php /*echo $total_cbf_set; */ if(!empty($pi)) { echo $pi->pi_cbf; } else { echo '0'; }  ?>" readonly="">
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-3 col-sm-12 col-xs-12" for="discount_offered">Weight</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<input id="pi_weight" class="form-control col-md-7 col-xs-12" name="pi_weight" type="text" value="<?php /* echo $total_weight_set;*/ if(!empty($pi)) { echo $pi->pi_weight; } else { echo '0'; }  ?>" readonly="">
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
								?>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Cash" name="pi_paymode[]" <?php if(!empty($pi_paymode) && $pi_paymode !='null'){if(in_array('Cash', $pi_paymode)){ echo "checked";} }?>>Cash</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Debit Card" name="pi_paymode[]" <?php if(!empty($pi_paymode) && $pi_paymode !='null'){if(in_array('Debit Card', $pi_paymode)){ echo "checked";} }?>>Debit Card</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Credit Card" name="pi_paymode[]" <?php if(!empty($pi_paymode) && $pi_paymode !='null'){ if(in_array('Credit Card', $pi_paymode)){ echo "checked";} }?>>Credit Card</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Cheque" name="pi_paymode[]" <?php if(!empty($pi_paymode) && $pi_paymode !='null'){ if(in_array('Cheque', $pi_paymode)){ echo "checked";} }?>>Cheque</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Online Transfer" name="pi_paymode[]" <?php if(!empty($pi_paymode) && $pi_paymode !='null'){ if(in_array('Online Transfer', $pi_paymode)){ echo "checked";} } ?>>Online Transfer</label>
							<label><input onchange="showPermittedBy();" type="checkbox" class="flat" value="Credit" name="pi_paymode[]" <?php if(!empty($pi_paymode) && $pi_paymode !='null'){ if(in_array('Credit', $pi_paymode)){ echo "checked";}  }?>>Credit</label>
						</div>
						</div>
					</div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="permitted_by" style="display:none";>
						<label class="col-md-3 col-sm-12 col-xs-12" for="city">Permitted By</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<input type="text" class="form-control discount_offered" name="pi_permitted" id="advance_received" value="<?php if(!empty($pi)) { echo $pi->pi_permitted; }  ?>" placeholder="Permitted By">
						</div>
					</div> 
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="remarks_by" style="display:none;">
						<label class="col-md-3 col-sm-12 col-xs-12" for="city">Remark</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<input type="text" class="form-control discount_offered" name="pi_remarks" value="<?php if(!empty($pi)) { echo $pi->pi_remarks; }  ?>" placeholder="Remark">
						</div>
					</div> 					
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-3 col-sm-12 col-xs-12" for="city">Advance Payment</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<input onkeyup="AdvancePayment(event,this)" type="text" class="form-control discount_offered" name="advance_received" id="advance_received" value="<?php if(!empty($pi)) echo $pi->advance_received; ?>" placeholder="Advance received in Rs">
						</div>
					</div>
					

				</div>
				<div class="item form-group col-md-6 col-sm-12 col-xs-12 vertical-border">
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-3 col-sm-12 col-xs-12" for="freight">Special Discount(%)</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
						<input onkeyup="SpecialDiscount(event,this)" type="text" class="form-control special_discount" name="special_discount" id="special_discount" value="<?php if(!empty($pi)) { echo $pi->special_discount; } else { echo '0'; }  ?>">
							
						</div>
					</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12" id="sda_by" style="display:none;">
						<label class="col-md-3 col-sm-12 col-xs-12" for="freight">Special Discount Authorized</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
						<input  type="text" class="form-control special_discount" name="special_discount_authorized" id="sda_by_discount" value="<?php if(!empty($pi)) { echo $pi->special_discount_authorized; } else { echo ''; }  ?>">
							
						</div>
					</div>	
				<div class="form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-3 col-sm-12 col-xs-12" for="freight">Freight</label>
						<div class="col-md-6 col-sm-12 col-xs-12" style="top: 5px;">
							ActualBasis:<input type="radio" class="flat" name="freight" id="genderM" value="FOR price" <?php if(!empty($pi) && $pi->freight == 'FOR price') echo 'checked'; else echo 'checked'; ?>  />
							Fixed Amount:<input type="radio" class="flat" name="freight" id="genderF" value="To be paid by customer" <?php if(!empty($pi) && $pi->freight == 'To be paid by customer') echo 'checked'; ?>/>
						</div>
					</div>
				  <div class="col-md-12 col-sm-12 col-xs-12 item form-group" id="freight1">
					<label class="col-md-3 col-sm-12 col-xs-12" for="purpose">Freight (Rs)</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
					  <input type="text" id="freight" name="freightCharges" class="form-control col-md-7 col-xs-12 key-up-event freight_charges" placeholder="Freight"  value="<?php  if (!empty($pi->freightCharges)) {	echo $pi->freightCharges;	} ?>"   min="0">
					</div> 
				  </div>
					<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
						<label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Estimated Dispatch Date</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<input type="text" class="form-control has-feedback-left " name="dispatch_date" value="<?php if(!empty($pi) && $pi->dispatch_date!=''){ echo $pi->dispatch_date; }else {echo date("d-m-Y");}?>" id="dispatch_date">
							<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
							<span id="inputSuccess2Status3" class="sr-only">(success)</span>
						</div>
					</div>
					
					
				</div>
			</div>
		</div>
	</div>
	
	<div class="clearfix"></div>
<hr>
<div class="boxSec mb-3 mb-md-0 borderLable purchaseInfo col-md-4" style="float: right;">
				 				
				   <ul class="laserAddress space">
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Subtotal:-</div>
							<div class="col-md-7 text-right addColenAfter"><span class="blueColor text-nowrap divSubTotal"><?php echo $subtotal; ?></span></div>
						 </div>
					  </li>
					  <li>
						 <div class="row">
							<div class="col-md-5 pr-0 text-nowrap">Discount value:-</div>
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
							<div class="col-md-5 pr-0 text-nowrap">Balance:-</div>
							<div class="col-md-7 text-right  addColenAfter"><span class="blueColor text-nowrap divBalance"><?php echo $remain_balance; ?></span></div>
						 </div>
					  </li>

				   </ul>
				</div>
				
	<div class="form-group">
		<div class="col-md-12">
		<center>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button id="send" type="submit" class="btn edit-end-btn">Submit</button>
			</center>
		</div>
	</div>



</div>


</div>

</form>

<!--------------Quick add material code original----------------------->
	<div class="modal left fade lead_modal prfoma-pop" id="myModal_Add_matrial_details" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
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
								<input type="hidden" name="material_type_id" id="materialtypeid"  class="form-control" value="">
								<input type="hidden" name="prefix"  id="prefix" value="">
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
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="gst">GST</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="gst_tax" name="gst_tax" class="form-control col-md-7 col-xs-12" value="" onkeypress="return float_validation(event, this.value)">
								<span class="spanLeft control-label"></span>
							</div>
						</div>

						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">UOM</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<select class="uom selectAjaxOption select2 form-control" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php 	echo $this->companyGroupId; ?> OR created_by_cid = 0 AND active_inactive = 1">
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
						<label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">Opening Balance</label>
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
						<button id="Add_matrial_details_on_button_click" type="button" class="btn edit-end-btn ">Submit</button>
					</div>
				</form>
			</div>
        </div>
    </div>


<!--------------Quick add customer code original----------------------->
	<div class="modal left fade lead_modal prfoma-pop add-customer" id="myModal_Add_customer_details" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content abc">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Add Customer Details</h4>
					<span id="message"></span>
				</div>
				<form name="insert_party_data" name="ins"  id="insert_customer_data_id">
					<div class="modal-body">
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="name">Buyer  Name<span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="customer_name" name="customer_name" required="required" class="form-control col-md-7 col-xs-12" value="">
								<span class="spanLeft control-label"></span>
							</div>
						</div>

						<span class="spanLeft control-label"></span>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="gsstin">GSTIN</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="gstin_value" name="gstin" class="form-control col-md-7 col-xs-12 gstin" value="" onblur="fnValidateGSTIN(this)">
								<span class="spanLeft control-label"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="number">Phone Number</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="phone_number" name="phone_number" class="form-control col-md-7 col-xs-12" value="" Placeholder="phonenumber">
								<span class="spanLeft control-label"></span>
							</div>
						</div>



						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="billing_street">Billing Street</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<textarea id="billing_street" rows="6" name="billing_street" class="form-control col-md-7 col-xs-12" placeholder=""></textarea>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="billing_zipcode">Billing Zip/Postal Code</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="number" id="billing_zipcode" name="billing_zipcode" class="form-control col-md-7 col-xs-12" value="">
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="billing_country">Billing Country</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="billing_country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this,'billing')" id="country_id">
									<option value="">Select Option</option>

								</select>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="billing_state">Billing State&nbsp;/ &nbsp;Province</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible billing state_id" name="billing_state"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this,'billing')" id="state_id">
									<option value="">Select Option</option>

								</select>
							</div>
						</div>

						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="city">Billing City</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible billing city_id" name="billing_city"  width="100%" tabindex="-1" aria-hidden="true" id="city_id">
									<option value="">Select Option</option>

								</select>
							</div>
						</div>


					<div class="modal-footer">
						<input type="hidden" id="add_customer_Data_onthe_spot">
						<button type="button" class="btn btn-default close_sec_model" >Close</button>
						<button id="Add_customer_details_on_button_click" type="button" class="btn edit-end-btn ">Submit</button>
					</div>
				</form>
			</div>
        </div>
    </div>
    </div>


		<!--------------Quick add contact code original----------------------->
	<div class="modal left fade lead_modal prfoma-pop" id="myModal_Add_contactPerson_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="">Add Contact Details</h4>
					<span id="message_contact"></span>
				</div>
				<form name="insert_party_data1" name="ins"  id="insert_contact_data_id">
					<div class="modal-body">
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="name">Contact Name <span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="contact_name" name="contact_name" required="required" class="form-control col-md-7 col-xs-12" value="">
								<span class="spanLeft control-label"></span>
							</div>
							<input type="hidden" name="accountid" id="accountId"  class="form-control" value="">
						</div>

						<span class="spanLeft control-label"></span>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">Email</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="email_id" name="email" class="form-control col-md-7 col-xs-12 email" value="" o>
								<span class="spanLeft control-label"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="number">Phone Number</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="ph_no" name="phone_number" class="form-control col-md-7 col-xs-12" value="" Placeholder="phone number">
								<span class="spanLeft control-label"></span>
							</div>
						</div>
					<div class="modal-footer">
						<input type="hidden" id="add_contactPerson_Data_onthe_spot">
						<button type="button" class="btn btn-default close_contact_model" >Close</button>
						<button id="Add_contact_details_on_button_click" type="button" class="btn edit-end-btn ">Submit</button>
					</div>
				</form>
			</div>
        </div>
    </div>
    </div>
