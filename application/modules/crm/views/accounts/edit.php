<?php
	if(!empty($account)) { echo '<span class="section" style="text-align: left;"><img src="/assets/images/crown-icon.png"/>'.$account->name.'</span>'; ?>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<ul class="stats-overview acc-name">
			<li>
				<span class="name"> Contact Name </span>
				<span class="value text-success"> <?php echo $account->website; ?> </span>
			</li>
			<li class="hidden-phone">
				<span class="name">Phone </span>
				<span class="value text-success"><?php echo $account->phone; ?> </span>
			</li>
			<li class="hidden-phone">
			    <span class="name"> Company Owner </span>
			    <span class="value text-success"> 
				<?php
					$accountOwner =  getNameById('user_detail',$account->account_owner,'u_id');
					if(!empty($accountOwner)) echo $accountOwner->name; 
				?> 
				</span>
			</li>
		</ul>
	</div>
	<div class="bottom-bdr"></div>
	<br/><br/>
	<?php } ?>


	<?php 

	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


	?>
	<!--    Tabs Start      -->
    <?php if(!empty($account)) { ?>
	<div class="col-md-12 col-sm-12 col-xs-12">
	<ul class="nav nav-tabs bar_tabs tab-2" role="tablist" id="myTab">
        <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
		<li><a href="#detail" data-toggle="tab">Detail</a></li>
    </ul>
    <div class="tab-content" id="account-main">
        	<div class="tab-content col-xs-12" style="border: 1px solid #807e7e;overflow: hidden;padding: 18px; ">
			<div class="tab-pane" id="detail"> <?php } ?>
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>crm/saveAccount" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
		<input type="hidden" name="id" value="<?php if(!empty($account)){ echo $account->id;   }?>">
		<input type="hidden" name="ledger_id" value="<?php if(!empty($account)){ echo $account->ledger_id;   }?>">
		
		
			<input type="hidden" name="created_by" value="<?php if(!empty($account)){ echo $account->created_by;   }?>">
		<input type="hidden" name="save_status" value="1" class="save_status">	
		
		<h3 class="Material-head" style="margin-bottom: 30px;">Information<hr></h3>
		 <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class="form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-4" for="first-name">Buyer Owner</label>
			<div class="col-md-6 col-sm-10 col-xs-8"> 
			
				 <span class="com-name"><?php if(!empty($_SESSION['loggedInUser'])) echo $_SESSION['loggedInUser']->name ;?></span> 
			</div>
		</div>
		
		
		
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="name">Buyer Name </label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="text" id="name" name="name"  class="form-control col-md-7 col-xs-12 BuyerNameCls" value="<?php if(!empty($account)) echo $account->name ;?>" required="required">
			</div>
		</div>
		
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="type">Buyer Type</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<select class="form-control selectAjaxOption select2 variantoptId select2-hidden-accessible" required="required" name="type_of_customer" data-id="types_of_customer" data-key="id" data-fieldname="type_of_customer" tabindex="-1" aria-hidden="true" required="">
            <option value="">Select Option</option>
            <?php
			if(!empty($account)){
				$type_of_customer = getNameById('types_of_customer', $account->type_of_customer, 'id');
				echo '<option value="'.$account->type_of_customer.'" selected>'.$type_of_customer->type_of_customer.'</option>';
			}
            ?>
            </select>
				<?php /*
				<select class="form-control" name="type">	
					<option value="">Select</option>
					<?php 
						$accountTypes = accountType();
						$selectedType = '';
						foreach($accountTypes as $accountType) {
							if($accountType == $account->type){
								$selectedType = 'selected';
							}else{
								$selectedType = '';
							}
							echo "<option value='".$accountType."' ".$selectedType.">".$accountType."</option>";	
						}
					?>														
				</select> */ ?>
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="email">Email </label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="email" id="email" name="email" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($account)) echo $account->email ;?>" >
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12" style="display:none;">
			<label class="col-md-3 col-sm-2 col-xs-12" for="type">Sales Area</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<select class="form-control selectAjaxOption select2 variantoptId select2-hidden-accessible"  name="sales_area" data-id="sales_area" data-key="id" data-fieldname="sales_area" tabindex="-1" aria-hidden="true">
            <option value="">Select Option</option>
            <?php
            $sales_area_customer = getNameById('sales_area', $account->sales_area, 'id');
            echo '<option value="'.$account->sales_area.'" selected>'.$sales_area_customer->sales_area.'</option>';
            ?>
            </select>
			</div>
		</div>
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
			
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="description">Description</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<textarea id="description" rows="6" name="description" class="form-control col-md-7 col-xs-12" placeholder=""><?php if(!empty($account)) echo $account->description ;?></textarea>
			</div>
	   </div>
	   <div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="contact_name">Contact Name </label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="text" id="contact_name" name="contact_name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($account)) echo $account->contact_name ;?>">
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="ph_number">Phone Number </label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "10" id="ph_number" name="phone" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($account)) echo $account->phone ;?>" required=""  >
			</div>
		</div>
	<?php  /*
				$limitOnOff = getNameById('company_detail',$this->companyGroupId,'id');
				
				 if(@$limitOnOff->ledger_crdit_limtOnOff == 1){
				?>
				<div class="item form-group ">
					 <label class="col-md-3 col-sm-12 col-xs-12" for="opening">Limit </label>
					 <div class="col-md-6 col-sm-2 col-xs-12">
						<input type="text" name="purchaseLimit" id="purchaseLimitID" class="form-control col-md-7 col-xs-12" placeholder="Limit" value="<?php if(!empty($account)) echo $account->purchaseLimit; ?>"  > 
					</div>
				</div>
				<div class="item form-group ">
					 <label class="col-md-3 col-sm-12 col-xs-12" for="opening">Temp Credit Limit</label>
					 <div class="col-md-3 col-sm-2 col-xs-12">
						<input type="text" name="temp_credit_limit" id="temp_credit_limitID" class="form-control col-md-7 col-xs-12" placeholder="Credit Limit" value="<?php if(!empty($account)) echo $account->temp_credit_limit; ?>" > 
					</div>
					 <div class="col-md-3 col-sm-2 col-xs-12">
						<input type="text" name="temp_crlimitDate" id="crlimitDateID2" class="form-control col-md-7 col-xs-12" placeholder="Limit Date" value="<?php if(!empty($account) && $account->temp_crlimitDate != '' && $account->temp_crlimitDate != '0000-00-00 00:00:00' ){
							echo date("d-m-Y", strtotime($account->temp_crlimitDate));}else{ echo '';} ?>" > 
					</div>
				</div>
				 <?php } */ ?>	
	   
		</div>
		<hr>
		<div class="bottom-bdr"></div>
<div class="container mt-3">

  <!-- Nav tabs -->
  <ul class="nav tab-3 nav-tabs">
	   <li class="nav-item active">
		  <a class="nav-link " data-toggle="tab" href="#Address">Billing Address</a>
		</li>
		<li class="nav-item ">
		  <a class="nav-link" data-toggle="tab" href="#Shipping">Shipping Address</a>
		</li>
	</ul>
<div class="tab-content">

 <div id="Address" class="container tab-pane active" style="margin-top: 25px;">
<div class="add_more_billing_addsss middle-box panel-body label-box" style="padding-bottom: 30px;position: relative;">
	<?php
	
	if(!empty($account->new_billing_address)){
	$new_billing_address = json_decode($account->new_billing_address);	
	$i=1;
	
	foreach ($new_billing_address as $key => $billing_address) {
		
		
		
		
	?>
	<div class="first_added_rows mailing-box">
    <div class="item form-group col-md-2 col-sm-12 col-xs-12">
    	<?php if($i == 1){ ?>
         <label class=" col-md-2 col-sm-3 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">Mailing Name</label>
      <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" id="billing_company_1" name="billing_company_1[]" class="form-control col-md-7 col-xs-12 billing_companyCls" placeholder="Company" value="<?php echo $billing_address->billing_company_1; ?>">
         </div>
      </div> 
      <div class="item form-group col-md-2 col-sm-12 col-xs-12">
      	<?php if($i == 1){ ?>
         <label class="col-md-3 col-sm-12 col-xs-12" for="mailing_address">Address</label>
         <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <textarea id="billing_street_1" rows="6" name="billing_street_1[]" class="form-control col-md-7 col-xs-12" placeholder="Address" required=""><?php echo $billing_address->billing_street_1; ?></textarea>
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
      	<?php if($i == 1){ ?>
         <label class=" col-md-2 col-sm-3 col-xs-12" for="mailing_country">Country </label>
         <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <select id="billing<?php echo $i; ?>" class="itemName form-control selectAjaxOption select2 country_id select2-hidden-accessible" name="billing_country_1[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this, this.id)" required="">
               <option value="">Select Option</option>
               <?php
               $country = getNameById('country', $billing_address->billing_country_1,'country_id');
					echo '<option value="'.$billing_address->billing_country_1.'" selected>'.$country->country_name.'</option>';
               ?>
            </select>
           
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
      	<?php if($i == 1){ ?>
         <label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_state">State </label>
         <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <select id="billingC<?php echo $i; ?>" class="itemName form-control selectAjaxOption select2 billing<?php echo $i; ?> state_id select2-hidden-accessible" name="billing_state_1[]" width="100%" tabindex="-1" aria-hidden="true" onchange="getCity(event,this, this.id)" required="">
               <option value="">Select Option</option>
               <?php 
               $state = getNameById('state', $billing_address->billing_state_1,'state_id');
					echo '<option value="'.$billing_address->billing_state_1.'" selected>'.$state->state_name.'</option>';
              ?>
            </select>
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
      	<?php if($i == 1){ ?>
         <label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_city">City </label>
         <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <select class="itemName form-control selectAjaxOption select2 billingC<?php echo $i; ?> city_id select2-hidden-accessible" name="billing_city_1[]" width="100%" tabindex="-1" aria-hidden="true" required="">
               <option value="">Select Option</option>
               <?php
	               $city = getNameById('city', $billing_address->billing_city_1,'city_id');
						echo '<option value="'.$billing_address->billing_city_1.'" selected>'.$city->city_name.'</option>';
               ?>
            </select>
            
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
      	<?php if($i == 1){ ?>
         <label class=" col-md-3 col-sm-2 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">Pincode </label>
         <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 item form-group">
            <input type="number" id="billing_zipcode_1" name="billing_zipcode_1[]" class="form-control col-md-7 col-xs-12" value="<?php echo $billing_address->billing_zipcode_1; ?>" required="" placeholder="Pincode">
         </div>
      </div>
     
      <div class="item form-group col-md-2 col-sm-12 col-xs-12">
      	<?php if($i == 1){ ?>
         <label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">GSTIN </label>
         <?php } ?>
		 <!-- onblur="fnValidateGSTIN(this)" -->
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" id="billing_gstin_1" name="billing_gstin_1[]" class="form-control col-md-7 col-xs-12 GSTValidORNOT" placeholder="GSTIN" value="<?php echo $billing_address->billing_gstin_1; ?>" >
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
      	<?php if($i == 1){ ?>
         <label class=" col-md-3 col-sm-3 col-xs-12" for="billing_phone_addrs" style="border-right: 1px solid #c1c1c1;">Phone no</label>
         <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" id="billing_phone_addrs" name="billing_phone_addrs[]" class="form-control col-md-7 col-xs-12" placeholder="Phone no." value="<?php echo $billing_address->billing_phone_addrs; ?>">
         </div>
      </div>
	  <div class="item form-group col-md-1 col-sm-12 col-xs-12" style="width: 35px;">
	  	<?php if($i == 1){ ?>
         <label class=" col-md-3 col-sm-3 col-xs-12" for="phone_addrs" style="border-right: 1px solid #c1c1c1;   height: 37px;"></label>
         <?php } ?>
         <div class="Product_Image col-xs-12" style="border-right: 1px solid #c1c1c1;   height: 38px;">
       <input type="checkbox" class="flat" data-tooltip="Please Check if you have Same Shipping Address" value="1" name="same_shipping[]" <?php if(!empty($billing_address->same_shipping) && $billing_address->same_shipping == 1){ echo "checked=checked"; } ?>>
         </div>
      </div>
   </div>
	<?php $i++; } } else { ?>
	<div class="first_added_rows mailing-box">
    <div class="item form-group col-md-2 col-sm-12 col-xs-12">
         <label class=" col-md-2 col-sm-3 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">Mailing Name</label>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" id="billing_company_1" name="billing_company_1[]" class="form-control col-md-7 col-xs-12 billing_companyCls" placeholder="Company" value="">
         </div>
      </div>
      <div class="item form-group col-md-2 col-sm-12 col-xs-12">
         <label class="col-md-3 col-sm-12 col-xs-12" for="mailing_address">Address</label>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <textarea id="billing_street_1" rows="6" name="billing_street_1[]" class="form-control col-md-7 col-xs-12" placeholder="Address" required=""></textarea>
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <label class=" col-md-2 col-sm-3 col-xs-12" for="mailing_country">Country </label>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <select class="itemName form-control selectAjaxOption select2 country_id select2-hidden-accessible" name="billing_country_1[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this,'billing1')" required="">
               <option value="">Select Option</option>
            </select>
           
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_state">State </label>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <select class="itemName form-control selectAjaxOption select2 billing1 state_id select2-hidden-accessible" name="billing_state_1[]" width="100%" tabindex="-1" aria-hidden="true" onchange="getCity(event,this,'billingC1')" required="">
               <option value="">Select Option</option>
            </select>
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_city">City </label>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <select class="itemName form-control selectAjaxOption select2 billingC1 city_id select2-hidden-accessible" name="billing_city_1[]" width="100%" tabindex="-1" aria-hidden="true" required="">
               <option value="">Select Option</option>
            </select>
            
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <label class=" col-md-3 col-sm-2 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">Pincode </label>
         <div class="col-md-12 col-sm-12 col-xs-12 item form-group">
            <input type="number" id="billing_zipcode_1" name="billing_zipcode_1[]" class="form-control col-md-7 col-xs-12" value="" required="" placeholder="Pincode">
         </div>
      </div>
     
      <div class="item form-group col-md-2 col-sm-12 col-xs-12">
         <label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">GSTIN </label>
		 <!-- onblur="fnValidateGSTIN(this)"  -->
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" id="billing_gstin_1" name="billing_gstin_1[]" class="form-control col-md-7 col-xs-12 gstin GSTValidORNOT " placeholder="GSTIN" value="" onblur="fnValidateGSTIN(this)"  > 
			<span class="Gstmsg" style="text-align: center;display: block;color: red;"></span>
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <label class=" col-md-3 col-sm-3 col-xs-12" for="billing_phone_addrs" style="border-right: 1px solid #c1c1c1;">Phone no</label>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" id="billing_phone_addrs" name="billing_phone_addrs[]" class="form-control col-md-7 col-xs-12" placeholder="Phone no." value="">
         </div>
      </div>
	  <div class="item form-group col-md-1 col-sm-12 col-xs-12" style="width: 35px;">
         <label class=" col-md-3 col-sm-3 col-xs-12" for="phone_addrs" style="border-right: 1px solid #c1c1c1;   height: 37px;"></label>
         <div class="Product_Image col-xs-12" style="border-right: 1px solid #c1c1c1;   height: 38px;">
       <input type="checkbox" class="flat" data-tooltip="Please Check if you have Same Shipping Address" value="1" name="same_shipping[]" checked="checked">
         </div>
      </div>
   </div>
	<?php } ?>
   
   <div class="col-sm-12 btn-row"><button class="btn btn-primary add_billing_multi_address_1" type="button">Add</button></div>
</div>
</div>

 <div id="Shipping" class="container tab-pane " >
<div class="add_more_shipping_addsss middle-box panel-body label-box" style="padding-bottom: 30px;position: relative;">
	<?php
	 // pre($account);
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
	$same_ship_array[$key]['shipping_gstin_1'] = $billing_address->billing_gstin_1;
	$same_ship_array[$key]['shipping_phone_addrs'] = $billing_address->billing_phone_addrs;
	$same_ship_array[$key]['same_shipping'] = $billing_address->same_shipping;
	}
	}
	$new_shipping_address = json_decode($account->new_shipping_address, true);	
	$new_ship_cmArray = array_merge($same_ship_array, $new_shipping_address);
	$i=1;
	foreach ($new_ship_cmArray as $key => $shipping_address) {  
if($shipping_address['shipping_company_1']){

	?>
	<div class="first_added_rows mailing-box">
    <div class="item form-group col-md-2 col-sm-12 col-xs-12">
    	<?php if($i == 1){ ?>
         <label class=" col-md-2 col-sm-3 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">Mailing Name</label>
      <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" id="shipping_company_1" <?php if (array_key_exists("same_shipping",$shipping_address)){} else {  echo "name=shipping_company_1[]"; }  ?> class="form-control col-md-7 col-xs-12" placeholder="Company" value="<?php echo $shipping_address['shipping_company_1']; ?>">
         </div>
      </div>
      <div class="item form-group col-md-2 col-sm-12 col-xs-12">
      	<?php if($i == 1){ ?>
         <label class="col-md-3 col-sm-12 col-xs-12" for="mailing_address">Address</label>
         <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <textarea id="shipping_street_1" rows="6" <?php if (array_key_exists("same_shipping",$shipping_address)){} else {  echo "name=shipping_street_1[]"; }  ?> class="form-control col-md-7 col-xs-12" placeholder="Address" required=""><?php echo $shipping_address['shipping_street_1']; ?></textarea>
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
      	<?php if($i == 1){ ?>
         <label class=" col-md-2 col-sm-3 col-xs-12" for="mailing_country">Country </label>
         <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <select id="shipping<?php echo $i; ?>" class="itemName form-control selectAjaxOption select2 country_id select2-hidden-accessible" <?php if (array_key_exists("same_shipping",$shipping_address)){} else {  echo "name=shipping_country_1[]"; }  ?> data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this, this.id)" required="">
               <option value="">Select Option</option>
               <?php
               $country = getNameById('country', $shipping_address['shipping_country_1'],'country_id');
               echo '<option value="'.$shipping_address['shipping_country_1'].'" selected>'.$country->country_name.'</option>';
               ?>
            </select>
           
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
      	<?php if($i == 1){ ?>
         <label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_state">State </label>
         <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <select id="shippingC<?php echo $i; ?>" class="itemName form-control selectAjaxOption select2 shipping<?php echo $i; ?> state_id select2-hidden-accessible" <?php if (array_key_exists("same_shipping",$shipping_address)){} else {  echo "name=shipping_state_1[]"; }  ?> width="100%" tabindex="-1" aria-hidden="true" onchange="getCity(event,this, this.id)" required="">
               <option value="">Select Option</option>
               <?php 
               $state = getNameById('state', $shipping_address['shipping_state_1'],'state_id');
               echo '<option value="'.$shipping_address['shipping_state_1'].'" selected>'.$state->state_name.'</option>';
              ?>
            </select>
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
      	<?php if($i == 1){ ?>
         <label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_city">City </label>
         <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <select class="itemName form-control selectAjaxOption select2 shippingC<?php echo $i; ?> city_id select2-hidden-accessible" <?php if (array_key_exists("same_shipping",$shipping_address)){} else {  echo "name=shipping_city_1[]"; }  ?> width="100%" tabindex="-1" aria-hidden="true" required="">
               <option value="">Select Option</option>
               <?php
                  $city = getNameById('city', $shipping_address['shipping_city_1'],'city_id');
                  echo '<option value="'.$shipping_address['shipping_city_1'].'" selected>'.$city->city_name.'</option>';
               ?>
            </select>
            
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
      	<?php if($i == 1){ ?>
         <label class=" col-md-3 col-sm-2 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">Pincode </label>
         <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 item form-group">
            <input type="number" id="shipping_zipcode_1" <?php if (array_key_exists("same_shipping",$shipping_address)){} else {  echo "name=shipping_zipcode_1[]"; }  ?> class="form-control col-md-7 col-xs-12" value="<?php echo $shipping_address['shipping_zipcode_1']; ?>" required="" placeholder="Pincode">
         </div>
      </div>
	   <div class="item form-group col-md-2 col-sm-12 col-xs-12">
      	<?php if($i == 1){ ?>
         <label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_city">GSTIN </label>
         <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" id="shipping_gstin_1" name="shipping_gstin_1[]" class="form-control col-md-7 col-xs-12 gstin " placeholder="GSTIN" value="<?php echo $shipping_address['shipping_gstin_1']; ?>" onblur="fnValidateGSTIN(this)"  > 
            </select>
            
         </div>
      </div>
     
      <div class="item form-group col-md-2 col-sm-12 col-xs-12">
      	<?php if($i == 1){ ?>
         <label class=" col-md-3 col-sm-3 col-xs-12" for="shipping_phone_addrs" style="border-right: 1px solid #c1c1c1;">Phone no</label>
         <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" id="shipping_phone_addrs" <?php if (array_key_exists("same_shipping",$shipping_address)){} else {  echo "name=shipping_phone_addrs[]"; }  ?> class="form-control col-md-7 col-xs-12" placeholder="Phone no." value="<?php echo $shipping_address['shipping_phone_addrs']; ?>">
         </div>
      </div>
   </div>
	<?php $i++; } }} else { ?>
	<div class="first_added_rows mailing-box">
    <div class="item form-group col-md-2 col-sm-12 col-xs-12">
         <label class=" col-md-2 col-sm-3 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">Mailing Name</label>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" id="shipping_company_1" name="shipping_company_1[]" class="form-control col-md-7 col-xs-12" placeholder="Company" value="">
         </div>
      </div>
      <div class="item form-group col-md-2 col-sm-12 col-xs-12">
         <label class="col-md-3 col-sm-12 col-xs-12" for="mailing_address">Address</label>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <textarea id="shipping_street_1" rows="6" name="shipping_street_1[]" class="form-control col-md-7 col-xs-12" placeholder="Address" required=""></textarea>
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <label class=" col-md-2 col-sm-3 col-xs-12" for="mailing_country">Country </label>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <select class="itemName form-control selectAjaxOption select2 country_id select2-hidden-accessible" name="shipping_country_1[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this,'shipping1')" required="">
               <option value="">Select Option</option>
            </select>
           
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_state">State </label>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <select class="itemName form-control selectAjaxOption select2 shipping1 state_id select2-hidden-accessible" name="shipping_state_1[]" width="100%" tabindex="-1" aria-hidden="true" onchange="getCity(event,this,'shipping1C1')" required="">
               <option value="">Select Option</option>
            </select>
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_city">City </label>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <select class="itemName form-control selectAjaxOption select2 shipping1C1 city_id select2-hidden-accessible" name="shipping_city_1[]" width="100%" tabindex="-1" aria-hidden="true" required="">
               <option value="">Select Option</option>
            </select>
            
         </div>
      </div>
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <label class=" col-md-3 col-sm-2 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">Pincode </label>
         <div class="col-md-12 col-sm-12 col-xs-12 item form-group">
            <input type="number" id="shipping_zipcode_1" name="shipping_zipcode_1[]" class="form-control col-md-7 col-xs-12" value="" required="" placeholder="Pincode">
         </div>
      </div>
	  <div class="item form-group col-md-2 col-sm-12 col-xs-12">
            <label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_city">GSTIN </label>
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" id="shipping_gstin_1" name="shipping_gstin_1[]" class="form-control col-md-7 col-xs-12 gstin " placeholder="GSTIN" value="" onblur="fnValidateGSTIN(this)"  > 
            </select>
        </div>
      </div>
     
      <div class="item form-group col-md-1 col-sm-12 col-xs-12">
         <label class=" col-md-3 col-sm-3 col-xs-12" for="shipping_phone_addrs" style="border-right: 1px solid #c1c1c1;">Phone no</label>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" id="shipping_phone_addrs" name="shipping_phone_addrs[]" class="form-control col-md-7 col-xs-12" placeholder="Phone no." value="">
         </div>
      </div>
   </div>
	<?php } ?>
   
   <div class="col-sm-12 btn-row"><button class="btn btn-primary add_shipping_multi_address_1" type="button">Add</button></div>
</div>
 </div>
</div>




</div>		
	   
		
		
	   
	 
	  <!-- <div class="ln_solid"></div> -->
	  <div class="form-group" style="text-align:center;">
			<div class="col-md-12 col-xs-12">
			       <center>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					
					<?php if((!empty($account) && $account->save_status !=1) || empty($account)){
						echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
					}?> 
				   <input type="submit" class="btn edit-end-btn signUpBtn" value="Submit">
				   </center>
			</div>
		</div>

	</form>
<?php if(!empty($account)) 
{
	?> </div>
			
	<div id="activity" class="col-md-12 col-sm-12 col-xs-12 tab-pane active">
	<!-- <div class="x_title">	 -->
	<div class="Activities" >	
                          <h3 class="Material-head">Recent Activities<hr></h3>
						  
						  <div class="col-md-3 export_div">
											
					<div class="control-group ">
					  <div class="controls">
						<div class="input-prepend input-group">
						  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						  <input type="text"  name="activityDateRange" id="activityDateRange" class="form-control"/>
						  <input type="hidden" name="activityRelId" value="<?php if(!empty($account)){ echo $account->id;   }?>">
						  <input type="hidden" name="activityRelTable" value="account_activity">
						</div>
					  </div>
					</div>						
						</div>
						 <div class="col-md-4 title_right">
						     
								<div class="col-md-12 col-sm-12 col-xs-12 form-group pull-right top_search">
								  <div class="input-group">
									<input type="text" class="form-control" placeholder="Search activities">
									<span class="input-group-btn">
									  <button class="btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i>
                                  </button>
									</span>
								  </div>
								</div>
                              
						</div> 
		
						  <!-- <div class="clearfix"></div> -->
						  
	<ul class="messages activityMessage col-md-12 col-sm-12 col-xs-12">
		 <?php if(!empty($account_activities)){ 
			foreach($account_activities as $activity){?>
                         
                                
			
			<li>                <div class="col-md-12 col-xs-12 head">
			                    <div class="col-md-4 col-xs-12">
			                     <!--<i class="fa </?php if($activity['activity_type'] == 'New Task'){ echo 'fa-tasks';} else if($activity['activity_type'] == 'Call Log'){ echo 'fa-phone';} else{ echo 'fa-wechat'; } ?>"></i>-->
                                <span><img src="/assets/images/chat-icon.png"></span>
                                <div class="message_wrapper">
                                	<h5 class="heading"><?php echo $activity['activity_type'];  ?></h5>
								   

								  </div>
								  </div>
								  <div class="message_date col-md-4">
                                  <?php echo $activity['created_date']; ?>
								</div>
								</div>
								<div class="col-md-12 col-xs-12 " style="text-align: left;">
								<p class="message">  
									<?php echo $activity['subject']; 


									$item = 'Sale Order Deleted'; 

									$item1 = 'Quotation Deleted';




									$item2 = 'Proforma Invoice Deleted';
									if($item == $activity['subject'] || $item1 == $activity['subject'] || $item2 == $activity['subject'] ){ 
									    echo " "; 
									} 
									else{ 
									        
									   $state2 = getNameById('proforma_invoice',$activity["p_id"],'id');
									   
									    $state3 = getNameById('quotation',$activity["p_id"],'id');

									     $state4 = getNameById('sale_order',$activity["p_id"],'id');

									   if($state2 == true || $state3 == true || $state4 == true)
									   {
									   echo ' <a href="javascript:void(0)" id="'. $activity["p_id"] . '" data-id="'. $activity["activity_type"] . '" class="quotpisoview btn btn-view   btn-xs" data-tooltip="View" style="cursor"><i class="fa fa-eye"></i>  </a>'; 
										}
										else{

										echo ' <a href="javascript:void(0)" id="" data-id="" class=" btn btn-view   btn-xs" data-tooltip="Deleted" style="cursor" disabled="disabled"><i class="fa fa-eye"></i>  </a>'; 	
										}

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
	<?php 


		
						
} 



	?>
	

	
	</div>
</div>
	
</div>
</div>



	
            <!-- /page content -->