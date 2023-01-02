<?php 
$typeCustomer =  getNameById('types_of_customer',$account->type_of_customer,'id');
// $accountdata =  getNameById('account',$account->parent_account,'id');

?>

<div id="print_divv" class="col-md-12 col-sm-12 col-xs-12"  style="padding:0px;"> 
		<div class="table-responsive"> 
		        <h3 class="Material-head">Company Owner : <?php if(!empty($account) && ($account->account_owner !=0 || $account->account_owner != '')) {									
					$companyUserId =  getNameById('company_detail',$account->account_owner,'id')->u_id;										
					if($companyUserId > 0){										
					$accountOwnerName =  getNameById('user_detail',$companyUserId,'u_id')->name;
					echo $accountOwnerName;
					}
			}
			
			
			?><hr></h3>
			<div class="col-md-6 col-xs-12 col-sm-6 label-left ">
                       <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Buyer Name</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group" style="float: left; width: 58.33333333%;">
										<div><?php if(!empty($account)) echo $account->name; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-xs-12 col-sm-6 label-left ">
                                    <label for="material" style="float: left;width: 140px;">Phone</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group" style="float: left;width: 50%;">
										<div><?php if(!empty($account)) echo $account->phone; ?></div>
									</div>
						</div>
						<!--<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">parent Account</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account) && $account->parent_account != 0) echo getNameById('account',$account->parent_account,'id')->name; ?></div>
									</div>
						</div>-->
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Email</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group" style="float: left;width: 58.33333333%;">
										<div><?php if(!empty($account)) echo $account->email; ?></div>
									</div>
						</div>
						
						<!--<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Account Type</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->type; ?></div>
									</div>
						</div>-->
						
            </div>
			
			
           <div class="col-md-6 col-xs-12 col-sm-6 label-left ">
		   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Buyer Type</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group" style="float: left;width: 58.33333333%;">
										<div><?php 
										 // $typeCustomer =  getNameById('type_of_customer',$account->type_of_customer,'id');
										// pre($typeCustomer);
										if(!empty($account)) echo $typeCustomer->type_of_customer;

										?></div>
									</div>
						</div>
                        <!--div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Contact Name</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->employee; ?></div>
									</div>
						</div>
						<<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Industry</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->industry; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Revenue</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($account)) echo $account->revenue; ?></div>
									</div>
						</div>-->
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Description</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group" style="float: left;width: 58.33333333%;">
										<div><?php if(!empty($account)) echo $account->description; ?></div>
									</div>
						</div>
						
            </div>
			
<hr>
<div class="bottom-bdr"></div>			
 <h3 class="Material-head">Billing Address<hr></h3>	
<?php
$bilAddress = json_decode($account->new_billing_address);
$shipAddress = json_decode($account->new_shipping_address);
 
?>		
			
				<div class="col-md-6 col-xs-12 col-sm-6 label-left">
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							 <label for="material">Billing Street</label>
							<div class="col-md-7 col-sm-12 col-xs-12 form-group" style="float: left;width: 58.33333333%;">
								<div><?php if(!empty($bilAddress[0]->billing_street_1)) echo $bilAddress[0]->billing_street_1; ?></div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							 <label for="material">Billing City</label>
							<div class="col-md-7 col-sm-12 col-xs-12 form-group" style="float: left;width: 58.33333333%;">
								<div><?php if(!empty($bilAddress[0]->billing_city_1)) echo getNameById('city',$bilAddress[0]->billing_city_1,'city_id')->city_name; ?></div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							 <label for="material">Billing Zipcode / Postalcode</label>
							<div class="col-md-7 col-sm-12 col-xs-12 form-group" style="float: left;width: 58.33333333%;">
								<div><?php if(!empty($bilAddress[0]->billing_zipcode_1)) echo $bilAddress[0]->billing_zipcode_1; ?></div>
							</div>
						</div>
				</div>
						<?php #echo "<h1Billing State></h1>".$bilAddress[0]->billing_state_1;?>
<div class="col-md-6 col-xs-12 col-sm-6 label-left">						
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Billing State/Province</label>
									<div class="col-md-7 col-sm-12 col-xs-12 form-group" style="float: left;width: 58.33333333%;">
										<div><?php if(!empty($bilAddress[0]->billing_state_1))
										echo getNameById('state',$bilAddress[0]->billing_state_1,'state_id')->state_name;
										
										?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Billing Country</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group" style="float: left;width: 58.33333333%;">
										<div><?php if(!empty($bilAddress[0]->billing_country_1)) echo getNameById('country',$bilAddress[0]->billing_country_1,'country_id')->country_name; ?></div>
									</div>
						</div>
</div>
<hr>
<div class="bottom-bdr"></div>
 <h3 class="Material-head">Shipping Address<hr></h3>
<?php 
  if(!empty($shipAddress)){
?> 
			<div class="col-md-6 col-xs-12 col-sm-6 label-left">
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
						 <label for="material">Shipping Street</label>
						<div class="col-md-6 col-sm-12 col-xs-12 form-group" style="float: left;width: 58.33333333%;">
							<div ><?php if(!empty($shipAddress[0]->shipping_street_1)) {echo $shipAddress[0]->shipping_street_1;} ?></div>
						</div>
					</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							 <label for="material">Shipping City</label>
							<div class="col-md-6 col-sm-12 col-xs-12 form-group" style="float: left;width: 58.33333333%;">
								<div ><?php if(!empty($shipAddress->shipping_city_1)){ echo getNameById('city',$shipAddress[0]->shipping_city_1,'city_id')->city_name; }?></div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							 <label for="material">Shipping Zipcode / Postalcode</label>
							<div class="col-md-6 col-sm-12 col-xs-12 form-group" style="float: left;width: 58.33333333%;">
								<div><?php if(!empty($shipAddress[0]->shipping_zipcode_1)) echo $shipAddress[0]->shipping_zipcode_1; ?></div>
							</div>
						</div>
			</div>
			<div class="col-md-6 col-xs-12 col-sm-6 label-left">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					 <label for="material">shipping State/Province</label>
					<div class="col-md-6 col-sm-12 col-xs-12 form-group" style="float: left;width: 58.33333333%;">
						<div><?php if(!empty($shipAddress[0]->shipping_state_1)) echo getNameById('state',$shipAddress[0]->shipping_state_1,'state_id')->state_name; ?></div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					 <label for="material">Shipping Country:</label>
					<div class="col-md-6 col-sm-12 col-xs-12 form-group" style="float: left;width: 58.33333333%;">
						<div><?php if(!empty($shipAddress[0]->shipping_country_1)) echo getNameById('country',$shipAddress[0]->shipping_country_1,'country_id')->country_name; ?></div>
					</div>
				</div>
            </div>			
<?php 
  }

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
		$i=1;
		foreach ($new_ship_cmArray as $key => $shipping_address) {  
	if($shipping_address['shipping_company_1']){
		
?>
					<div class="col-md-6 col-xs-12 col-sm-6 label-left">
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
						 <label for="material">Shipping Street</label>
						<div class="col-md-6 col-sm-12 col-xs-12 form-group">
							<div ><?php if(!empty($shipping_address['shipping_street_1'])) {echo $shipping_address['shipping_street_1'];} ?></div>
						</div>
					</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							 <label for="material">Shipping City</label>
							<div class="col-md-6 col-sm-12 col-xs-12 form-group">
								<div ><?php if(!empty($shipping_address['shipping_city_1'])){ echo getNameById('city',$shipping_address['shipping_city_1'],'city_id')->city_name; }?></div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							 <label for="material">Shipping Zipcode / Postalcode</label>
							<div class="col-md-6 col-sm-12 col-xs-12 form-group">
								<div><?php if(!empty($shipping_address['shipping_zipcode_1'])) echo $shipping_address['shipping_zipcode_1']; ?></div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xs-12 col-sm-6 label-left">
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							 <label for="material">shipping State/Province</label>
							<div class="col-md-6 col-sm-12 col-xs-12 form-group">
								<div><?php if(!empty($shipping_address['shipping_state_1'])) echo getNameById('state',$shipping_address['shipping_state_1'],'state_id')->state_name; ?></div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							 <label for="material">Shipping Country:</label>
							<div class="col-md-6 col-sm-12 col-xs-12 form-group">
								<div><?php if(!empty($shipping_address['shipping_country_1'])) echo getNameById('country',$shipping_address['shipping_country_1'],'country_id')->country_name; ?></div>
							</div>
						</div>
					</div>






	<?php $i++; } }} ?>		
		</div>
	</div>

												
                  
					
	<center>
		<button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
	</center>