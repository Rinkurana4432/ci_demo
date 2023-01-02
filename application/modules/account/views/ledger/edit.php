<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saveLedger" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
		<?php
			$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		?>
	<div class="col-md-12 col-sm-12 col-xs-12 form-group kapil">
	    <h3 class="Material-head">Contact Details <hr></h3>
	    <div class="col-md-6 col-xs-12 col-sm-6 vertical-border">
	         <div class="panel-default">						
			<div class="panel-body">
				<div class="item form-group">
					<label class=" col-md-3 col-sm-12 col-xs-12" for="name">Name<span class="required">*</span></label>
					<div class="item form-group col-md-6 col-sm-12 col-xs-12">
						<input type="text" id="name" name="name" required="required" data-validate-length-range="16"  class="form-control col-md-7 col-xs-12" placeholder="Ledger Name" value="<?php if(!empty($ledger)) echo $ledger->name; ?>">
					</div>
				</div>
				<div class="required item form-group">
					<label class="col-md-3 col-sm-12 col-xs-4" for="parent_ledger">Connected Company</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<input type="hidden" value="<?php echo $this->companyGroupId; ?>" id="getlogin_company_ids">
						<select  class="form-control cls_add_select2 connected_company_data" name="conn_comp_id">	             
							<option value="">Select Connected Company</option>
								<?php
									if(!empty($ledger) && $ledger->conn_comp_id!=0){
										$company_dtl = getNameById('company_detail',$ledger->conn_comp_id,'id');  
										// pre($company_dtl);
										echo '<option value="'.$company_dtl->id.'" selected>'.$company_dtl->name.'</option>';
										}
				 			    ?>
						</select> 
					</div>
				</div>
				<div class="required item form-group">
					<label class="col-md-3 col-sm-12 col-xs-4" for="account_group_id">Account Group <span class="required">*</span></label>
						<div class="col-md-6 col-sm-12 col-xs-12 item form-group">
							<input type="hidden" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="getlogin_ids">
							<select class="itemName form-control selectAjaxOption_account_group_accordingly select2 cls_add_select2 opt_Data get_acc_id get_parent_idd" id="select2Opt" required="required" name="account_group_id">
							<option value="">Select Type And Begin</option>
								<?php
									if(!empty($ledger) && $ledger->account_group_id!=0){
										$account_group_id = getNameById('account_group',$ledger->account_group_id,'id');    
										echo '<option value="'.$account_group_id->id.'" selected>'.$account_group_id->name.'</option>';
									}
									?>
							</select>  
						</div>
					<input type="hidden" value="<?php if(!empty($ledger)) echo $ledger->parent_group_id; ?>" class="parent_group_iddd" name="parent_group_id" id="parent_group_id">
					
					<input type="hidden" value="<?php if(!empty($ledger)) echo $ledger->customer_id; ?>" class="customer_id" name="customer_id" >
				</div> 
					<?php
					$multilocation_onoff = getNameById('company_detail',$this->companyGroupId,'id');  
					//&& $multilocation_onoff->multi_loc_on_off == '1'
					if(!empty($ledger) && $ledger->account_group_id == '7'  ){
						$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');
						if(!empty($company_brnaches)  && !empty($company_brnaches)){
					?>
				<div class="required item form-group">
					<label class="col-md-3 col-sm-12 col-xs-4" for="company_branch">Company Branch <span class="required">*</span></label>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<select class="itemName form-control select_company_branch" required="required" name="compny_branch_id">
							<option>Select Type And Begin</option>
							 <!--option value="<?php //echo $brnch_name['add_id'];  ?>"<?php //if($ledger->compny_branch_id == $brnch_name['add_id']) { ?> selected="selected"<?php // } ?>><?php //echo $brnch_name['compny_branch_name']; ?></option-->
							   <?php
							   $branch_add = getNameById('company_detail',$this->companyGroupId,'id');  
							   $data =  json_decode($branch_add->address,true);
							  foreach($data as $brnch_name){
								$selected = ($ledger->compny_branch_id == $brnch_name['add_id']) ? ' selected="selected"' : '';
								echo '<option value="'.$brnch_name['add_id'].'"  "'.$selected.'" data-gst="'.$brnch_name['company_gstin'].'">'.$brnch_name['compny_branch_name'].'</option>';
							  } ?>
						</select>  
					</div>
				</div> 
					<?php } 
					} else{
				?>
				<div class="required item form-group company_brnch_div" style="display:none;" >
					<label class="col-md-3 col-sm-12 col-xs-4" for="company_branch">Company Branch  <span class="required">*</span></label>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<select class="itemName form-control select_company_branch" required="required" name="compny_branch_id">
							<option>Select Type And Begin</option>
							<!--option value="<?php //echo $brnch_name['add_id'];  ?>"><?php// echo $brnch_name['compny_branch_name']; ?></option-->
							   <?php
								$branch_add = getNameById('company_detail',$this->companyGroupId,'id');				
								$data =  json_decode($branch_add->address,true);
									foreach($data as $brnch_name){
								echo '<option value="'.$brnch_name['add_id'].'"  data-gst="'.$brnch_name['company_gstin'].'">'.$brnch_name['compny_branch_name'].'</option>';		
								?>
							 
							 <?php } ?>
						</select>  
					</div>
				</div> 
				<?php  }
					if(!empty($ledger) && $ledger->compny_branch_id != '0' && $multilocation_onoff->multi_loc_on_off == '0'){//0 Location Off And 1 Location ON
						echo '<input type="hidden" value="'.$ledger->compny_branch_id.'" name="compny_branch_id">';
					}
				?>
				<div class="item form-group">
					<label class=" col-md-3 col-sm-12 col-xs-12" for="open_bal">Opening Balance</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="number" class="form-control col-md-7 col-xs-12" name="opening_balance" id="opening_balance" value="<?php if(!empty($ledger)) echo $ledger->opening_balance; ?>" /> 
					</div>
				</div>
				<div class="item form-group">
					<label class=" col-md-3 col-sm-12 col-xs-12" for="open_bal">Opening Balance CR/DR</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
							<input type="radio" id="radio_id_btn" name="openingbalc_cr_dr" value="1" <?php echo ($ledger->openingbalc_cr_dr == '1') ?  "checked" : "" ;  ?> ><!-- 1 means Credit Opening Balance -->
							<label for="defaultRadio">Credit</label>
							<input type="radio" id="radio_id_btn" name="openingbalc_cr_dr" value="0"  <?php echo ($ledger->openingbalc_cr_dr == '0') ?  "checked" : "" ;  ?>><!-- 0 means Debit Opening Balance -->
							<label for="defaultRadio">Debit</label>
					</div>
				</div>
				<?php 
				$limitOnOff = getNameById('company_detail',$this->companyGroupId,'id');
				 if($limitOnOff->ledger_crdit_limtOnOff == 1){
				?>
				<div class="item form-group ">
					 <label class="col-md-3 col-sm-12 col-xs-12" for="opening">Limit </label>
					 <div class="col-md-6 col-sm-2 col-xs-12">
						<input type="text" name="purchaseLimit" id="purchaseLimitID" class="form-control col-md-7 col-xs-12" placeholder="Limit" value="<?php if(!empty($ledger)) echo $ledger->purchaseLimit; ?>" onkeypress="return check(event,value)" > 
					</div>
				</div>
				<div class="item form-group ">
					 <label class="col-md-3 col-sm-12 col-xs-12" for="opening">Temp Credit Limit</label>
					 <div class="col-md-3 col-sm-2 col-xs-12">
						<input type="text" name="temp_credit_limit" id="temp_credit_limitID" class="form-control col-md-7 col-xs-12" placeholder="Credit Limit" value="<?php if(!empty($ledger)) echo $ledger->temp_credit_limit; ?>" onkeypress="return check(event,value)" > 
					</div>
					 <div class="col-md-3 col-sm-2 col-xs-12">
						<input type="text" name="temp_crlimitDate" id="crlimitDateID" class="form-control col-md-7 col-xs-12" placeholder="Limit Date" value="<?php if(!empty($ledger) && $ledger->temp_crlimitDate != '' && $ledger->temp_crlimitDate != '0000-00-00 00:00:00' ){
							echo date("d-m-Y", strtotime($ledger->temp_crlimitDate));}else{ echo '';} ?>" > 
					</div>
				</div>
				 <?php } ?>	
				<div class="item form-group ">
					 <label class="col-md-3 col-sm-12 col-xs-12" for="opening">Customer Type</label>
					 <div class="col-md-6 col-sm-2 col-xs-12">
					 <!--select name="delarType" class="form-control col-md-7 col-xs-12" >
							<option value="">Select Dealer Type</option>
							<option value="WHOLESALER" <?php //if(!empty($ledger)){  if($ledger->delarType == 'WHOLESALER'){ ?> selected="selected" <?php //} }?>>WHOLESALER</option>
							
							<option value="RETAILER" <?php //if(!empty($ledger)){  if($ledger->delarType == 'RETAILER'){ ?> selected="selected" <?php //} }?>>RETAILER</option>
					</select-->
					 <select  class="itemName form-control selectAjaxOption select2 select2-hidden-accessible"   name="delarType"  data-id="types_of_customer" data-key="id" data-fieldname="type_of_customer"  aria-hidden="true" data-where="created_by_cid = <?php echo $this->companyGroupId; ?> AND active_inactive = 1">
					 <option value="">Select Option</option>
						<?php
						if(!empty($ledger)){												
							$delar = getNameById('types_of_customer',$ledger->delarType,'id');
							if(!empty($delar)){
								echo '<option value="'.$delar->id.'" selected>'.$delar->type_of_customer.'</option>';
							}
						}
						?>
					 </select>
					</div>
				</div>
							
							<!--div class="item form-group">
								<label class=" col-md-3 col-sm-12 col-xs-12">Sales Person</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="sales_person" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php //echo $this->companyGroupId; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">
											<option value="">Select Option</option>
											<?php
											// if(!empty($ledger)){												
												// $sales_person = getNameById('user_detail',$ledger->sales_person,'u_id');
												// if(!empty($sales_person)){
													// echo '<option value="'.$ledger->sales_person.'" selected>'.$sales_person->name.'</option>';
												// }
											// }
											?>
										</select> 	
								</div>
							</div-->
						</div>
					</div>
			 
			 </div>	 
		     <div class="col-sm-6 col-sm-6 col-xs-12 vertical-border">
			      <div class=" panel-default">
					<div class="panel-body">							
						<div class="item form-group">
							<label class=" col-md-3 col-sm-12 col-xs-12" for="contact_person">Contact Person</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<input id="contact_person" class="form-control col-md-7 col-xs-12" data-validate-length-range="3" value="<?php if(!empty($ledger)) echo $ledger->contact_person; ?>" name="contact_person" placeholder="ex. John f. Kennedy"  type="text"> 
							</div>
						</div>
						<div class="item form-group">
							<label class=" col-md-3 col-sm-12 col-xs-12" for="phone_no">Phone Number </label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<input id="phone_no" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($ledger)) echo $ledger->phone_no; ?>" name="phone_no" placeholder="0172 2658943"  type="phone" > 
							</div>
						</div>
						<div class="item form-group">
							<label class=" col-md-3 col-sm-12 col-xs-12" for="mobile_no">Mobile Number<span class="required">*</span></label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<input id="contact_person" class="form-control col-md-7 col-xs-12" data-validate-length-range="10"  value="<?php if(!empty($ledger)) echo $ledger->mobile_no; ?>" name="mobile_no" placeholder="+91 6598745694"  type="text" required> 
							</div>
						</div>
						<div class="item form-group">
							<label class=" col-md-3 col-sm-12 col-xs-12" for="email">Email</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<input type="email" id="email" name="email"  class="form-control col-md-7 col-xs-12" placeholder="example@exp.com" value="<?php if(!empty($ledger)) echo $ledger->email; ?>">
							</div>
						</div>	
						<div class="item form-group">
							<label class=" col-md-3 col-sm-12 col-xs-12" for="open_bal">Enable / Disable RCM</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="radio" id="enble_disbl_rcm_id" name="enble_disbl_rcm" value="1" <?php echo ($ledger->enble_disbl_rcm == '1') ?  "checked" : "" ;  ?> ><!-- 1 Means RCM Enable -->
									<label for="defaultRadio">Enable</label>
									<input type="radio" id="enble_disbl_rcm_id" name="enble_disbl_rcm" value="0"  <?php echo ($ledger->enble_disbl_rcm == '0') ?  "checked" : "" ;  ?>><!-- 0 Means RCM Disable -->
									<label for="defaultRadio">Disable</label>
							</div>
						</div>
						<?php 
							$tcs_settings = getNameById('company_detail',$this->companyGroupId,'id');  
							 if($tcs_settings->tcs_onOff == 1){ 
						?>
						<div class="item form-group">
							<label class=" col-md-3 col-sm-12 col-xs-12" for="open_bal">TCS On/Off</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="radio" id="tcs_onOffID" name="tcs_onOff" value="1" <?php echo ($ledger->tcs_onOff == '1') ?  "checked" : "" ;  ?> ><!-- 1 Means TCS ON -->
									<label for="defaultRadio">ON</label>
									<input type="radio" id="tcs_onOffID" name="tcs_onOff" value="0"  <?php echo ($ledger->tcs_onOff == '0') ?  "checked" : "" ;  ?>><!-- 0 Means TCS OFF -->
									<label for="defaultRadio">OFF</label>
							</div>
						</div>
						<?php } ?>
						<div class="item form-group">
							<label class="col-md-3 col-sm-12 col-xs-12" for="name">Due Days </label>
							<div class="col-md-6 col-sm-12 col-xs-12"><!-- required="required" -->
								<select name="due_days" class="form-control col-md-7 col-xs-12" >
									<option value="">Select Due days</option>
									<?php
										for ($i=0; $i<=90; $i++){
											//$selected = ($ledger->compny_branch_id == $brnch_name['add_id']) ? ' selected="selected"' : '';
											?>
												<option value="<?php echo $i;?>" <?php if(!empty($ledger)){  if($ledger->due_days == $i){ ?> selected="selected" <?php } }?>><?php echo $i;?></option>
											<?php
										}
									?>
									</select>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-md-3 col-sm-12 col-xs-12" for="name">Sales Persons </label>
							<div class="col-md-6 col-sm-12 col-xs-12"><!-- required="required" -->
							 <select multiple class="itemName form-control selectAjaxOption select2 select2-hidden-accessible"   name="salesPersons[]"  data-id="user_detail" data-key="u_id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="c_id = <?php echo $this->companyGroupId; ?>">
							 <?php
							 if(!empty($ledger)){
								 $salesData = json_decode($ledger->salesPersons);
								foreach($salesData as $saleval){
									$sales_person = getNameById('user_detail',$saleval,'u_id');
									if(!empty($sales_person)){
										echo '<option value="'.$saleval.'" selected>'.$sales_person->name.'</option>';
									}
								}	
							}
							?>
							</select>	
							</div>
						</div>
						<div class="item form-group ">
							 <label class="col-md-3 col-sm-12 col-xs-12" for="opening">Lead Source</label>
							 <div class="col-md-6 col-sm-2 col-xs-12">
								<!--input type="text" name="areastation" id="areastationID" class="form-control col-md-7 col-xs-12" placeholder="Area Station" value="<?php //if(!empty($ledger)) echo $ledger->areastation; ?>" --> 
								 <select  class="itemName form-control selectAjaxOption select2 select2-hidden-accessible"   name="areastation"  data-id="add_lead_source" data-key="id" data-fieldname="leads_source_name"  aria-hidden="true" data-where="created_by_cid = <?php echo $this->companyGroupId; ?> AND active_inactive = 1">
							 <?php
							 if(!empty($ledger)){
								 $areastation = getNameById('add_lead_source',$ledger->areastation,'id');
								if(!empty($areastation)){
									echo '<option value="'.$ledger->areastation.'" selected>'.$areastation->	leads_source_name.'</option>';
								}	
							}
							?>
							</select>
							</div>
							
						</div>							
					</div>
				</div>
			 </div>
		
		</div>
<hr>
<div class="bottom-bdr"></div>		
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
			<input type="hidden" name="id" value="<?php if(!empty($ledger)) echo $ledger->id; ?>">
			<!--input type="hidden" name="parent_group_id" value="" id="parent_group_id"-->
			<input type="hidden" name="compny_branch_id" value="" id="acc_selected_value">
			<input type="hidden" name="save_status" value="1" class="save_status">
				<div class="panel-default">
						<h3 class="Material-head">Mailing Details<hr></h3>
						<div class="add_more_ledgers_addss middle-box panel-body label-box" style="padding-bottom: 30px;">
						<?php  if(empty($ledger)){?>
						<div class="mailing-box" >
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_name">Mailing Name </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<input type="text" id="mailing_name" name="mailing_name[]"  class="form-control col-md-7 col-xs-12" placeholder="Mailing Name" value="">
								</div>
							</div>							
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class="col-md-3 col-sm-12 col-xs-12" for="mailing_address">Mailing Address</label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<textarea id="mailing_address"  name="mailing_address[]" class="form-control col-md-7 col-xs-12" placeholder="Mailing Address"><?php if(!empty($ledger)) echo $ledger->mailing_address; ?></textarea>
								</div>
							</div>
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_country">Mailing Country </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">

									<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="mailing_country[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this)">
												<option value="">Select Option</option>
												 <?php
													if(!empty($ledger)){
														$ledger2 = getNameById('country',$ledger->mailing_country,'country_id');
														echo '<option value="'.$ledger2->country_id.'" selected>'.$ledger2->country_name.'</option>';
													}
												?>
									</select>
								</div>
							</div>
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_state">Mailing State </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<select  class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1 state_id" name="mailing_state[]"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)" required>
											<option value="">Select Option</option>
											 <?php
											 
												if(!empty($ledger)){
													$state = getNameById('state',$ledger->mailing_state,'state_id');
													echo '<option value="'.$ledger->mailing_state.'" selected>'.$state->state_name.'</option>';
												}
											?>
									</select>
								</div>
							</div>
							<div class="item form-group col-md-1 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_city">Mailing City </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<select   class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1  city_id" name="mailing_city[]"  width="100%" tabindex="-1" aria-hidden="true">
											<option value="">Select Option</option>
											 <?php
												if(!empty($ledger)){
													$city = getNameById('city',$ledger->mailing_city,'city_id');
													echo '<option value="'.$ledger->mailing_city.'" selected>'.$city->city_name.'</option>';
												}
											?>
										</select>
								</div>
							</div>
							
							<div class="item form-group col-md-1 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_pincode"style="border-right: 1px solid #c1c1c1;">Pincode </label>
								<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
									<input type="text" id="mailing_pincode" name="mailing_pincode[]"  class="form-control col-md-7 col-xs-12" placeholder="Pincode" value="" >
								</div>
							</div>
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_pincode"style="border-right: 1px solid #c1c1c1;">GSTIN </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<input type="text" id="gstin_no" name="gstin_no[]"  class="form-control col-md-7 col-xs-12" placeholder="GSTIN" value="">
								</div>
							</div>
						</div>
						  <div class="col-sm-12 btn-row"><button class="btn btn-primary add_multi_address_button" type="button">Add</button></div>
						<?php } 
						if(!empty($ledger)){
									$ledger_addrss_dtl = json_decode($ledger->mailing_address);	
									// pre($ledger->mailing_address);
									// pre($ledger_addrss_dtl);
									if(!empty($ledger_addrss_dtl)){
									$i = 0;
									foreach($ledger_addrss_dtl as $addr_dtl){
									
						?>
						<div class=" <?php if($i==0){ echo 'edit-row1 mailing-box';}else{ echo 'scend-tr mobile-view mailing-box';}?>" >
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_name"> Mailing Name </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<input type="text" id="mailing_name" name="mailing_name[]"  class="form-control col-md-7 col-xs-12" placeholder="Mailing Name" value="<?php if(!empty($addr_dtl)) echo $addr_dtl->mailing_name; ?>">
								</div>
							</div>							
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class="col-md-3 col-sm-12 col-xs-12" for="mailing_address">Mailing Address </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<textarea id="mailing_address"  name="mailing_address[]" class="form-control col-md-7 col-xs-12" placeholder="Mailing Address"><?php if(!empty($addr_dtl)) echo $addr_dtl->mailing_address; ?></textarea>
								</div>
							</div>
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_country">Mailing Country </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="mailing_country[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this)">
												<option value="">Select Option</option>
												 <?php
													if(!empty($addr_dtl)){
														$ledger2 = getNameById('country',$addr_dtl->mailing_country,'country_id');
														echo '<option value="'.$ledger2->country_id.'" selected>'.$ledger2->country_name.'</option>';
													}
												?>
									</select>
								</div>
							</div>
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_state">Mailing State </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<!--select  class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1 state_id" name="mailing_state[]"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)"-->
								<select  class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1 state_id" name="mailing_state[]"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)" data-id="state" data-key="state_id" data-fieldname="state_name" data-where= "country_id = '<?php echo (!empty($addr_dtl))?$addr_dtl->mailing_country:''; ?>'" required>
											<option value="">Select Option</option>
											 <?php
											 
												if(!empty($addr_dtl)){
													$state = getNameById('state',$addr_dtl->mailing_state,'state_id');
													echo '<option value="'.$addr_dtl->mailing_state.'" selected>'.$state->state_name.'</option>';
												}
											?>
									</select>
								</div>
							</div>
							<div class="item form-group col-md-1 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_city">Mailing City </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<select   class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1  city_id" name="mailing_city[]"  width="100%" tabindex="-1" aria-hidden="true" data-id="city" data-key="city_id" data-fieldname="city_name" data-where= "state_id = '<?php echo (!empty($addr_dtl))?$addr_dtl->mailing_state:''; ?>'" >
											<option value="">Select Option</option>
											 <?php
												if(!empty($addr_dtl)){
													$city = getNameById('city',$addr_dtl->mailing_city,'city_id');
													echo '<option value="'.$addr_dtl->mailing_city.'" selected>'.$city->city_name.'</option>';
												}
											?>
										</select>
								</div>
							</div>
							<div class="item form-group col-md-1 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_pincode">Pincode </label>
								<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
									<input type="text" id="mailing_pincode" name="mailing_pincode[]"  class="form-control col-md-7 col-xs-12" placeholder="Pincode" value="<?php if(!empty($addr_dtl)) echo $addr_dtl->mailing_pincode; ?>" required="required">
								</div>
							</div>
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_pincode"style="border-right: 1px solid #c1c1c1;">GSTIN </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<input type="text" id="gstin_no" name="gstin_no[]"  class="form-control col-md-7 col-xs-12" placeholder="GSTIN" value="<?php if(!empty($addr_dtl)) echo $addr_dtl->gstin_no; ?>">
								</div>
							</div>
							<?php 
							if($i==0){
								echo '<div class="col-sm-12 btn-row"><button class="btn btn-primary add_multi_address_button" type="button">Add</button></div>';
							}else{	
								echo '<button class="btn btn-danger remove_ledger_add_field" type="button"> <i class="fa fa-minus"></i></button>';
							}
							$i++;
						?>
						</div>
						<?php }
						} else{ ?>
							<div class="mailing-box" >
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_name">Mailing Name </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<input type="text" id="mailing_name" name="mailing_name[]"  class="form-control col-md-7 col-xs-12" placeholder="Mailing Name" value="">
								</div>
							</div>							
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class="col-md-3 col-sm-12 col-xs-12" for="mailing_address">Mailing Address</label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<textarea id="mailing_address"  name="mailing_address[]" class="form-control col-md-7 col-xs-12" placeholder="Mailing Address"><?php if(!empty($ledger)) echo $ledger->mailing_address; ?></textarea>
								</div>
							</div>
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_country">Mailing Country </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">

									<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="mailing_country[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this)">
												<option value="">Select Option</option>
												 <?php
													if(!empty($ledger)){
														$ledger2 = getNameById('country',$ledger->mailing_country,'country_id');
														echo '<option value="'.$ledger2->country_id.'" selected>'.$ledger2->country_name.'</option>';
													}
												?>
									</select>
								</div>
							</div>
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_state">Mailing State </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<select  class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1 state_id" name="mailing_state[]"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)">
											<option value="">Select Option</option>
											 <?php
											 
												if(!empty($ledger)){
													$state = getNameById('state',$ledger->mailing_state,'state_id');
													echo '<option value="'.$ledger->mailing_state.'" selected>'.$state->state_name.'</option>';
												}
											?>
									</select>
								</div>
							</div>
							<div class="item form-group col-md-1 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_city">Mailing City </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<select   class="itemName form-control selectAjaxOption select2 select2-hidden-accessible address1  city_id" name="mailing_city[]"  width="100%" tabindex="-1" aria-hidden="true">
											<option value="">Select Option</option>
											 <?php
												if(!empty($ledger)){
													$city = getNameById('city',$ledger->mailing_city,'city_id');
													echo '<option value="'.$ledger->mailing_city.'" selected>'.$city->city_name.'</option>';
												}
											?>
										</select>
								</div>
							</div>
							
							<div class="item form-group col-md-1 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_pincode"style="border-right: 1px solid #c1c1c1;">Pincode </label>
								<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
									<input type="text" id="mailing_pincode" name="mailing_pincode[]"  class="form-control col-md-7 col-xs-12" placeholder="Pincode" value="" required="required">
								</div>
							</div>
							<div class="item form-group col-md-2 col-sm-12 col-xs-12">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_pincode"style="border-right: 1px solid #c1c1c1;">GSTIN </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<input type="text" id="gstin_no" name="gstin_no[]"  class="form-control col-md-7 col-xs-12" placeholder="GSTIN" value="">
								</div>
							</div>
						</div>
						  <div class="col-sm-12 btn-row"><button class="btn btn-primary add_multi_address_button" type="button">Add</button></div>
						<?php }
					} 
				?>
			</div>
		</div>
	</div>
<hr>
	<div class="bottom-bdr"></div>					
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
			<div class=" panel-default">
		    <h3 class="Material-head">Company Details <hr></h3>
			<div class="panel-body">
				<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">						
					<div class="item form-group">
						<label class=" col-md-3 col-sm-3 col-xs-12" for="website">Website</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="url" id="website" name="website" data-validate-length-range="8,10"  class="form-control col-md-7 col-xs-12" placeholder="www.companyname.com" value="<?php if(!empty($ledger)) echo $ledger->website; ?>">
						</div>
					</div>
					<div class="item form-group">
						<label class=" col-md-3 col-sm-3 col-xs-12" for="registration_type">Registration Type</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="registration_type" name="registration_type" data-validate-length-range="8,20"  class="form-control col-md-7 col-xs-12" placeholder="Registration Type" value="<?php if(!empty($ledger)) echo $ledger->registration_type; ?>">
							</div>
					</div>
				</div>
				<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">	
					<!--div class="item form-group">
						<label class=" col-md-3 col-sm-3 col-xs-12" for="gstin">GSTIN</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" id="gstin" name="gstin"  class="form-control col-md-7 col-xs-12" placeholder="GSTIN number" value="<?php //if(!empty($ledger)) echo $ledger->gstin; ?>" >
						</div>
					</div-->
					<div class="item form-group">
						<label class=" col-md-3 col-sm-3 col-xs-12" for="pan">Company PAN</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input id="pan" class="form-control col-md-7 col-xs-12" data-validate-length-range="10"  value="<?php if(!empty($ledger)) echo $ledger->pan; ?>" name="pan" placeholder="ABCDFA87565B" type="text"> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		<div class="form-group">
			<div class="modal-footer">
				<center>
				<?php
				if($_SERVER['REQUEST_URI'] != '/account/ledger_create'){
					echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
				} 
				?>	   
				<button type="reset" class="btn btn-default">Reset</button>
				<?php
				if((!empty($ledger) && $ledger->save_status !=1) || empty($ledger)){
					echo '<input type="submit" class="btn btn-warning draftBtn" value="Save as draft">'; 
				}
				?> 
				<!--input type="submit" class="btn btn-warning add_edit_account" value="Submit"-->
				<button id="send" type="submit" class="btn btn-warning add_edit_account">Submit</button>
				</center>
			</div>
		</div>
	</form>
	</div>
			
			
			
			