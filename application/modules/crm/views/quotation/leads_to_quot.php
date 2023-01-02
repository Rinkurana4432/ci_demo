<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right" style="margin: 10px 0;">



</div>

<?php

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

?>
									
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>crm/saveLeads_to_quot" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($leads)){ echo $leads->id; }?>">
	<input type="hidden" name="save_status" value="1" class="save_status">	
	<input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">	
	
	
	<div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
	  <div class="item form-group ">
	      <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Customer Name<span class="required">*</span></label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<select class="customerName selectAjaxOption select2 form-control" name="account_id" data-id="account" data-key="id" data-fieldname="name" width="100%" id="account_id" data-where="account_owner = <?php 	echo $this->companyGroupId; ?> AND save_status = 1" id="account_id" required="required">
									<option value="">Select Option</option>
									<?php 
										if(!empty($leads)){
											$account = getNameById('account',$leads->lead_owner,'id');
											echo '<option value="'.$account->id.'" selected>'.$account->name.'</option>';
										}
									?>
								</select>
								<input type="hidden" name="accountid" id="account_id">				
								<input type="hidden" id="serched_val">	
							</div>
							
		</div>					
		<div class="item form-group ">
							<label class="col-md-3 col-sm-12 col-xs-12" for="address">Customer Address</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<?php if(!empty($leads) && !empty($leads)){
										$city = getNameById('city',$leads->city,'city_id');
										$state = getNameById('state',$leads->state,'state_id');
										$country = getNameById('country',$leads->country,'country_id');
										$cityName = !empty($city)?$city->city_name:'';
										$stateName = !empty($state)?$state->state_name:'';
										$countryName = !empty($country)?$country->country_name:'';
										}
									?>
								<textarea id="address" rows="6" name="address" class="form-control col-md-7 col-xs-12" placeholder=""><?php if(!empty($account)){ echo $account->billing_street . PHP_EOL . $cityName  . PHP_EOL . $account->billing_zipcode  . PHP_EOL . $stateName  . PHP_EOL . $countryName ; }?></textarea>
							</div>
						</div>
	</div>

	
	<div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">

      <div class="item form-group">	
		<label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Order Date<span class="required">*</span></label>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<input type="text" class="form-control has-feedback-left datePicker" name="order_date" id="order_date" value="<?php echo date("d-m-Y");?>" required="required">
			<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
			<span id="inputSuccess2Status3" class="sr-only">(success)</span>
		</div>
      </div>		
	



		<div class="item form-group"> 												
		<label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Valid Till<span class="required">*</span></label>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<input type="text" class="form-control has-feedback-left datePicker" name="valid_date" id="valid_date" value="<?php echo date("d-m-Y");?>" required="required">
			<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
			<span id="inputSuccess2Status3" class="sr-only">(success)</span>
		</div>						

      </div>


	


		<div class="item form-group">											
		<label class="col-md-3 col-sm-12 col-xs-12" for="email">Phone No<span class="required">*</span></label>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<input type="tel" id="phone_no" name="phone_no" required="required" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($leads) && !empty($account)) echo $account->phone; ?>">
		</div>
      </div>		
	</div>

<hr>	
<div class="bottom-bdr"></div>	
<div class="container mt-3">
<h3 class="Material-head">Material Details<hr></h3>
  <!-- Nav tabs 
  <ul class="nav tab-3 nav-tabs">
    <li class="nav-item active">
      <a class="nav-link " data-toggle="tab" href="#Material-Details">Material Details</a>
    </li>

   <!--

    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#Customer-Details">Customer-Details </a>
  

  </li>

-->
  <!--</ul>-->


  <!--
 <div class="tab-content tab-to-mrgn">	
 <div id="Customer-Details" class="container tab-pane "> 
      <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	     <div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="col-md-3 col-sm-12 col-xs-12" for="gstin">GSTIN</label>
							<div class="col-md-6 col-sm-12 col-xs-12">								
								<input type="text" id="gstin" name="gstin" class="form-control col-md-7 col-xs-12 gstin" value="<?php if(!empty($leads) && !empty($account)) echo $account->gstin; ?>" onblur="fnValidateGSTIN(this)"> 
							</div>
						</div>  					
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="col-md-3 col-sm-12 col-xs-12" for="address">Customer Address</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<?php if(!empty($leads) && !empty($account)){
										$city = getNameById('city',$account->billing_city,'city_id');
										$state = getNameById('state',$account->billing_state,'state_id');
										$country = getNameById('country',$account->billing_country,'country_id');
										$cityName = !empty($city)?$city->city_name:'';
										$stateName = !empty($state)?$state->state_name:'';
										$countryName = !empty($country)?$country->country_name:'';
										}
									?>
								<textarea id="address" rows="6" name="address" class="form-control col-md-7 col-xs-12" placeholder="" readonly><?php if(!empty($account)){ echo $account->billing_street . PHP_EOL . $cityName  . PHP_EOL . $account->billing_zipcode  . PHP_EOL . $stateName  . PHP_EOL . $countryName ; }?></textarea>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="col-md-3 col-sm-12 col-xs-12" for="email">Email</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<input type="email" id="email" name="email" class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php if(!empty($leads) && !empty($account)) echo $account->email; ?>"> 
							</div>
						</div> 
	           
	  </div>
	  
	  <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	        <div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="col-md-3 col-sm-12 col-xs-12" for="email">Phone No.</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<input type="tel" id="phone_no" name="phone_no"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($leads) && !empty($account)) echo $account->phone; ?>" readonly>
							</div>
						</div>						
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="col-md-3 col-sm-12 col-xs-12" for="contact_person">Contact Person</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<select class="contactPerson form-control" name="contact_id" data-id="contacts" data-key="id" data-fieldname="first_name" width="100%" id="contact_id" data-where="save_status = 1 AND account_id = <?php echo $leads->account_id ;?>">							
									<option value="">Select Option</option>
									<?php 
										if(!empty($leads)){
											$contact_id = $leads->contact_id;
											if($contact_id != 0){
											$contact = getNameById('contacts',$leads->contact_id,'id');
											echo '<option value="'.$contact->id.'" selected>'.$contact->first_name. ' '.$contact->last_name.'</option>';
											}
										}
									?>
								</select>
							</div>
						</div>						
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="col-md-3 col-sm-12 col-xs-12" for="contact_phone_no">Contact No.</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<input type="text" id="contact_phone_no" name="contact_phone_no"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($leads) && !empty($contact)) echo $contact->phone; ?>" readonly>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="col-md-3 col-sm-12 col-xs-12" for="party_ref">Party Reference </label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<input type="text" id="party_ref" name="party_ref"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($leads)) echo $leads->party_ref; ?>">
							</div>
						</div>
	  </div>
 </div>

-->
  <div id="Material-Details" class="container tab-pane active"> 
     <div class="item form-group col-md-6 col-sm-12 col-xs-12 vertical-border">	
		<label class="col-md-3 col-sm-12 col-xs-12" for="material">Material Type <span class="required">*</span></label>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" id="material_type_id" name="material_type_id" id="" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
				<option value="">Select Option</option>
				<?php
				if(!empty($leads) && $leads->material_type_id!=0){
					$material_type_id = getNameById('material_type',$leads->material_type_id,'id');
					echo '<option value="'.$leads->material_type_id.'" selected>'.$material_type_id->name.'</option>';
					}
				?>	
			</select>
			<span class="spanLeft control-label"></span>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
	<div class="panel">
			<div class="">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group input_productre middle-box">	
				<?php if(empty($leads)){ ?>
				    <div class="col-sm-12  col-md-12 label-box mobile-view2">
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name<span class="required">*</span></label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Quantity</label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label >UOM</label></div>
                                   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Price</label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>GST</label></div>
                                    					   
								</div>
					<div class="well scend-tr mobile-view"   id="chkIndex_1">
					
						<div class="col-md-2 col-sm-12 col-xs-12 item form-group">	
					        <label class="col-md-12" terial Name>Material Name  <span class="required">*</span></label>						
							<?php /*<select class="form-control selectAjaxOption select2 materialNameId Add_mat_onthe_spot" required="required" name="product[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid = <?php echo $this->companyGroupId; ?> AND status = 1" width="100%" onchange="getTax(event,this)" id="material">*/?>
							<select class="form-control selectAjaxOption select2 materialNameId Add_mat_onthe_spot" required="required" name="product[]" width="100%" onchange="getTax(event,this)" id="material">
								<option value="">Select Option</option>
							</select>
							<input type="hidden" name="mat_idd_name" id="matrial_Iddd">	
							<input type="hidden" name="matrial_name" id="matrial_name">	  
							<input type="hidden" id="serchd_val">	    
						</div>
						<div class="col-md-2 col-sm-12 col-xs-12 item form-group">
							<label class="col-md-12">Description</label>						
							<textarea name="description[]" placeholder="Description of material" class="form-control col-md-7 col-xs-12" class="description"></textarea> 
						</div>
						<div class="col-md-2 col-sm-6 col-xs-12 form-group">
						<label class="col-md-12" >Quantity</label>
							<input type="text" name="qty[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12" class="quantity" onkeyup="keyupFunction(event,this)"  onchange="keyupFunction(event,this)" required="required">
						</div>
						<div class="col-md-2 col-sm-6 col-xs-12 form-group">
						<label class="col-md-12">UOM</label>
							<input type="text" name="uom1[]"  placeholder="uom" class="form-control col-md-7 col-xs-12" class="uom" readonly>

							<input type="hidden" name="uom[]" readonly>
						</div>
						<div class="col-md-2 col-sm-6 col-xs-12 form-group">
						<label class="col-md-12">Price</label>
							<input type="text" name="price[]"  placeholder="Price" class="form-control col-md-7 col-xs-12" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" required="required">
						</div>
											
						<div class="col-md-2 col-sm-6 col-xs-12 form-group">
					<label  class="col-md-12">GST </label>
						<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="" placeholder="gst" readonly>
					</div>			
					
									<input type="hidden" name="totals[]" class="form-control col-md-7 col-xs-12 total" value="" readonly>
								
									<input  type="hidden" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="" readonly>
								
						<button class="btn btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button>						
					</div>
                    <div class="col-sm-12 btn-row">
							<button class="btn addProductButtonre edit-end-btn" type="button" align="right">Add</button>
						</div>					
					<?php } else{ 
						$products = json_decode($leads->product_detail);
						?>
						<div class="col-sm-12  col-md-12 label-box mobile-view2">
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name<span class="required">*</span></label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Quantity</label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label >UOM</label></div>
                                   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Price</label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style="border-right: 1px solid #c1c1c1 !important;">GST</label></div>
                                  							   
								</div>
						<?php
						if(!empty($products)){ 
								$i =  1;
								foreach($products as $product){
								?>
									<div class="well <?php if($i==1){ echo 'edit-row1 scend-tr mobile-view';}else{ echo 'scend-tr mobile-view';}?>"  id="chkWell_<?php echo $i; ?>" style="overflow:auto; ">
										<div class="col-md-2 col-sm-12 col-xs-12 item form-group">	
											<label>Material Name<span class="required">*</span></label>		
											<select class="materialNameId  form-control selectAjaxOption select2 Add_mat_onthe_spot" required="required" name="product[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid = <?php echo $this->companyGroupId; ?>" width="100%" onchange="getTax(event,this)" id="material">
												<option value="">Select Option</option>
												<?php 
													if(!empty($product)){
														$material = getNameById('material',$product->material_name_id,'id');
														echo '<option value="'.$material->id.'" selected>'.$material->material_name.'</option>';
													}
												?>
											</select>
											<input type="hidden" name="mat_idd_name" id="matrial_Iddd">	
											<input type="hidden" name="matrial_name" id="matrial_name">	  
											<input type="hidden" id="serchd_val">	
										</div>
										
										<div class="col-md-2 col-sm-12 col-xs-12 item form-group">
											<label>Description</label>
											<textarea name="description[]" placeholder="Description of material" class="form-control col-md-7 col-xs-12" class="description"><?php echo $product->description ; ?></textarea> 
										</div>
										<div class="col-md-2 col-sm-6 col-xs-12 form-group">
										    <label>Quantity</label>
											<input type="text" name="qty[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12" class="quantity" value="<?php echo $product->qty ;?>" onkeyup="keyupFunction(event,this)"  onchange="keyupFunction(event,this)">
										</div>
										<div class="col-md-2 col-sm-6 col-xs-12 form-group">
										    <label>UOM</label>
											<input type="text" name="uom1[]" placeholder="uom" class="form-control col-md-7 col-xs-12" class="uom" value="<?php 

												$ww =  getNameById('uom', $product->uom_material,'id');
												$uom = !empty($ww)?$ww->ugc_code:'';

												echo $uom;
											 ?>" readonly>

											<input type="hidden" name="uom[]" readonly value="<?php echo  $product->uom_material; ?>">

										</div>
										<div class="col-md-2 col-sm-6 col-xs-12 form-group">
										     <label>Price</label>
											<input type="text" name="price[]" id="inputSuccess2" placeholder="Price" class="form-control" value="<?php if(!empty($product) && isset($product->price)) echo $product->price;?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)">
											
										</div>
									
										<?php /*
										<div class="col-md-2 col-sm-6 col-xs-12 form-group">
											<input type="number" name="price[]"  placeholder="Price" class="form-control col-md-7 col-xs-12" value="<?php echo $product->price ;?>" onkeyup="poPriceCalculation(event,this)"  onchange="poPriceCalculation(event,this)">
										</div> */ ?>
										<div class="col-md-2 col-sm-6 col-xs-12 form-group">
										    <label>GST</label>
											<input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="<?php if(!empty($product) && isset($product->gst)) echo chop($product->gst,"%");?>" placeholder="gst%" readonly>
										</div>
										
										
											<input type="hidden" name="totals[]" class="form-control col-md-7 col-xs-12 total" value="<?php if(!empty($product) && isset($product->total)) echo $product->total;?>" readonly>
											
										
										
											<input  type="hidden" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="<?php if(!empty($product) && isset($product->TotalWithGst)) echo $product->TotalWithGst;?>" readonly>
											
																	
										
											
											<button class="btn btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button>
										
									</div>	
					<?php $i++; }
					}
				}?>	
				<div class="col-sm-12 btn-row"><button class="btn addProductButtonre edit-end-btn" type="button">Add</button></div>
				</div>
				
				<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
						
					
							<div class="col-md-12 col-sm-12 col-xs-12 text-right" >
						<div class="col-md-7 col-sm-5 col-xs-6 text-right">
						  <input type="hidden"  name="total" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($leads)) echo $leads->totalwithoutgst; ?>"> 
							<strong>Total:</strong>&nbsp;&nbsp;
							</div>
							<div class="col-md-5 col-sm-5 col-xs-6 text-left">
							      <span class="fa fa-rupee divSubTotal"><?php if(!empty($leads)){ echo $leads->totalwithoutgst ; } else{ echo 0; }?></span>
							</div>
							 
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2" >
						<div class="col-md-7 col-sm-5 col-xs-6 text-right form-group">
						  <input type="hidden"  name="grandTotal" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($leads)) echo $leads->grand_total; ?>"> 
							<strong>Grand Total:</strong>&nbsp;
							</div>
							<div class="col-md-5 col-sm-5 col-xs-6 text-left form-group">
							     <span class="fa fa-rupee divTotal"><?php if(!empty($leads)){ echo $leads->grand_otal ; } else{ echo 0; }?></span>
							</div>
							 
						</div>
					</div>
				
			
				</div>

				
			</div>
		</div>
	</div>
  </div>
</div>
</div>	




<div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
<div class=" item form-group">													
		<label class="col-md-3 col-sm-12 col-xs-12" for="email">Payment Terms</label>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<input type="tel" id="payment_terms" name="payment_terms"  class="form-control col-md-7 col-xs-12" value="">
		</div>						
	</div>




<div class=" item form-group">													
		<label class="col-md-3 col-sm-12 col-xs-12" for="email">Cash Discount</label>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<input type="tel" id="cash_discount" name="cash_discount"  class="form-control col-md-7 col-xs-12" value="">
		</div>						
	</div>

</div>


<div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
<div class="item form-group ">
							<label class="col-md-3 col-sm-12 col-xs-12" for="address">Terms and Conditions</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								
		<select class="terms_conditions selectAjaxOption select2 form-control" name="terms_conditions" data-id="termscond" data-key="content" data-fieldname="terms_tittle" width="100%" id="termscond" data-where="created_by_cid = <?php 	echo $this->companyGroupId; ?> AND save_status = 1">
							<option value="">Select Option</option>
								<?php 
			if(!empty($quotation)){
			$quotation = getNameById('termscond',$quotation->termscond,'content');
			echo '<option value="'.$quotation->content.'">'.$quotation->tittle.'</option>';
							 }
								?>
									</select>
							</div>
						</div>

</div>




<hr>

<hr>
	<div class="form-group">
		<div class="col-md-12 col-xs-12">
		  <center>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="reset" class="btn btn-default">Reset</button>
			
			<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">
			 
			<input type="submit" class="btn edit-end-btn " value="Submit">
			</center>
		</div>
	</div>
</form>	

<!--------------Quick add material code original----------------------->
	<div class="modal left fade lead_modal prfoma-pop" id="myModal_Add_matrial_details" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Add Material Details</h4>
					<span id="mssg3"></span>
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
						<button type="button" class="btn btn-default close_sec_model2" >Close</button>
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
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="name">Customer Name <span class="required">*</span></label>
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
					<span id="mssg34"></span>
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
