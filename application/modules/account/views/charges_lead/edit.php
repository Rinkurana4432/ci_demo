	<?php //if($_SESSION['loggedInUser']->role != 2){ ?>	   					  
			<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/savecharges" enctype="multipart/form-data" id="savecharges" novalidate="novalidate">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<input type="hidden" name="id" value="<?php if(!empty($charge_lead_Datas)) echo $charge_lead_Datas->id; ?>">
					
					
						 <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Charges Heading<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="particular_charges" name="particular_charges" required="required" data-validate-length-range="4"  class="form-control col-md-7 col-xs-12" placeholder="Charges Headings" value="<?php if(!empty($charge_lead_Datas)) echo $charge_lead_Datas->particular_charges; ?>">
								</div>
							</div>
							<div class="item form-group"> 
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Ledger Name<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="itemName form-control selectAjaxOption select2 add_option party_name_ledger_id_onchange" id="get_add_more_btn" required="required" name="ledger_id" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $this->companyGroupId; ?>) AND activ_status = 1"  width="100%"> 
										<option value="">Select And Begin Typing</option>
										<?php 
										
											if(!empty($charge_lead_Datas) && $charge_lead_Datas->ledger_id!=0){
												
												$ledger_name = getNameById('ledger',$charge_lead_Datas->ledger_id,'id');
												echo '<option value="'.$ledger_name->id.'" selected>'.$ledger_name->name.'</option>';
											}
										 ?>
									</select>    
								</div>
							</div>
														
							
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Type of Charges<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									 <p>
										Plus:
										<input type="radio" class="flat" name="type_charges"  value="plus" <?php echo ($charge_lead_Datas->type_charges == 'plus') ?  "checked" : "" ;  ?> required  /> Minus:
										<input type="radio" class="flat" name="type_charges"  value="minus" <?php echo ($charge_lead_Datas->type_charges == 'minus') ?  "checked" : "" ;  ?> />
									  </p>
								</div>
							</div>
						</div>
						
						<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">	
							 <div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12">Amount of charges to be fed as <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <p>
									Absolute Amount:
									
									<input type="radio" class="flat" name="amount_of_charges"  value="absoluteamount" <?php echo ($charge_lead_Datas->amount_of_charges == 'absoluteamount') ?  "checked" : "" ;  ?>  autofocus required  /><br/> Percentage:
									<input type="radio" class="flat" name="amount_of_charges"  value="percentage" <?php echo ($charge_lead_Datas->amount_of_charges == 'percentage') ?  "checked" : "" ;  ?>  /><br/>
									
								  </p>
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Tax<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select name="tax_slab" class="form-control itemName select2" required="required">
										<option name="" value="0">Select Tax Slab</option>
										<option value="0"  <?php if($charge_lead_Datas->tax_slab == '0'){echo 'selected';} ?> >0  % </option>
										<option value="5"  <?php if($charge_lead_Datas->tax_slab == '5'){echo 'selected';} ?> >05 % </option>
										<option value="12" <?php if($charge_lead_Datas->tax_slab == '12'){echo 'selected';} ?>>12 % </option>
										<option value="18" <?php if($charge_lead_Datas->tax_slab == '18'){echo 'selected';} ?>>18 %</option>
										<option value="28" <?php if($charge_lead_Datas->tax_slab == '28'){echo 'selected';} ?>>28 % </option>
									</select>
								</div>
							</div>
						</div>
					
 				
		<?php //} ?>	
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<div class="form-group">
						<div class="modal-footer">
						<center>
							<button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
							<button type="reset" class="btn btn-default">Reset</button>
							<input type="submit" class="btn btn-warning" value="Submit">
							<!--button id="send" type="submit" class="btn btn-warning">Submit</button-->
						</center>
						</div>
					</div>
				</form>
			</div>
<!-- Add Party Modal-->

    <div class="modal left fade" id="myModal_Add_party" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
			<div class="modal-header">
		
                <h4 class="modal-title" id="myModalLabel">Add Ledger</h4>
				<span id="mssg"></span>
			</div>
			<form name="insert_party_data" name="ins"  id="insert_party_data_id">
                 <div class="modal-body">
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="name">Party Name <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" id="partyname" name="name" required="required" class="form-control col-md-7 col-xs-12" value="">
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="email">Email </label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="email" id="partyemail" name="email" class="form-control col-md-7 col-xs-12" value="" >
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="name">Account Group<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible acc_group_id"  required name="account_group_id" data-id="account_group" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true" ></select>
				
						<span id="acc_grp_id"></span>
					</div>
				</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-4" for="gstin">GSTIN</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="partygstin" name="gstin" class="form-control col-md-7 col-xs-12" value="">
							<span class="spanLeft control-label"></span>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="gstin">Country <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" id='cntry' required name="country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this)"></select>
						<span id="contry"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="gstin">State<span class="required">*</span></label>  
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible state_id" name="state" required  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)"></select>
						<span id="state1"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="gstin">City<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						 <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible city_id" name="city" required width="100%" tabindex="-1" aria-hidden="true"></select>
						<span id="city1"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="gstin">Address<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						  <textarea id="mailing_address" required="required" name="mailing_address" class="form-control col-md-7 col-xs-12" placeholder="Mailing Address"></textarea>
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				<input type="hidden" value="" class="select_company_branch">
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-4" for="opening_balances">Opening Balance </label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="opening_balance" name="opening_balance" class="form-control col-md-7 col-xs-12" value=""  >
							<span class="spanLeft control-label"></span>
						</div>
					</div>
				</div>
                <div class="modal-footer">
				<input type="hidden" id="sale_ledger_data">
				    <button type="button" class="btn btn-default close_sec_model" >Close</button>
					<button id="bbttn" type="button" class="btn btn-warning">Submit</button>
                </div>
				</form>
            </div>
        </div>
    </div>
<!-- Add Party Modal-->			