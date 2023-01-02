
<?php
	if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}
	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
	<div class="alert alert-info" id="message_Sucess" style="display:none;"></div>				  
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
			<input type="hidden" name="id" value="<?php //if(!empty($voucher)) echo $voucher->id; ?>">
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<div class="panel panel-default">
				<!--div class="panel-heading"><h3 class="panel-title"><strong><?php //if(!empty($voucher)) echo $voucher->voucher_name; ?> </strong></h3></div-->
				<div class="panel-body">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_content">
						<div class="settin-tab" role="tabpanel" data-example-id="togglable-tabs">
						<!--<h3 class="Material-head">Information<hr></h3>-->
						<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class="firstt active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Information</a></li>
							<li role="presentation" class="secc "><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Invoice Setting</a></li>
							<li role="presentation" class="thirdd "><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Ageing Email Settings</a></li>
													<!--li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Invoice Print Settings</a>
													</li>
													<li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Discount ON/OFF</a>
													</li>
													<li role="presentation" class=""><a href="#tab_content6" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Multi Location ON/OFF</a>
													</li>
													<li role="presentation" class=""><a href="#tab_content7" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Item Code ON/OFF</a>
													</li>
													<li role="presentation" class=""><a href="#tab_content8" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Invoice Cancel/Restore</a>
													</li>-->
						</ul>
				<div id="myTabContent" class="tab-content list-vies-2" style="clear: both;">
					<div role="tabpanel" class="col-md-8 col-sm-12 col-xs-12 vertical-border tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab" style="clear: both;"> 
					<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom:20px;">
						<div class="item form-group">
							<label class="col-md-3 col-sm-3 col-xs-12" for="type">Term And conditions<span class="required">*</span></label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saveInvoice_settings" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
							 <textarea id="field" onkeyup="countChar(this)" col="160" rows="10" name="term_and_conditions" required="required" class="form-control col-md-7 col-xs-12" placeholder="Term And conditions"><?php if(!empty($update_invoice_setting->term_and_conditions)) echo $update_invoice_setting->term_and_conditions; ?></textarea>
						<div id="charNum"></div>
						<p class="text-muted font-13 m-b-30"></p>
							<input type="submit" class="btn btn-warning pull-right" value="Submit">
						</form> 
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
		   <label class="col-md-3 col-sm-3 col-xs-12" for="type">Invoice Number Setting<span class="required">*</span></label>
			<div class="col-md-9 col-sm-6 col-xs-12">
			<form name="save_invoice_prefix" method="post" action="<?php echo base_url(); ?>account/save_invoice_num_prefix" enctype="multipart/form-data">
			<table class="table table-striped">
				<tbody>
					<tr>
						<th> Company Branch</th>
						<th> Invoice Number</th>
					</tr>
						<?php
						//echo $_SESSION['loggedInUser']->c_id;
							$company_brnaches = $this->account_model->get_data('company_detail',array('id'=> $this->companyGroupId));
							
						if(!empty($company_brnaches)){ 
							$comp_Add = array();
							foreach($company_brnaches as $cm_brnch){
								$comp_Add = $cm_brnch['address'];
							}
							
							$company_addresss = json_decode($comp_Add,true);
							
							foreach($company_addresss as $get_brnch_name_add){
								//pre($get_brnch_name_add);
						?>
						<tr>
							<th scope="row" style="text-transform:capitalize;"><?php echo $get_brnch_name_add['compny_branch_name'];?></th>
							<td>
							<input class="form-control col-md-7 col-xs-12" type="text" value="<?php  echo $get_brnch_name_add['prefix_inv_num']; ?>" name="prefix_inv_num[]" Placeholder="Invoice Number"></td>
							
							<input type="hidden" value="<?php echo $get_brnch_name_add['address']; ?>" name="address[]">
							<input type="hidden" value="<?php echo $get_brnch_name_add['country']; ?>" name="country[]">
							<input type="hidden" value="<?php echo $get_brnch_name_add['state']; ?>" name="state[]">
							<input type="hidden" value="<?php echo $get_brnch_name_add['city']; ?>" name="city[]">
							<input type="hidden" value="<?php echo $get_brnch_name_add['postal_zipcode']; ?>" name="postal_zipcode[]">
							<input type="hidden" value="<?php echo $get_brnch_name_add['company_gstin']; ?>" name="company_gstin[]">
							<input type="hidden" value="<?php echo $get_brnch_name_add['compny_branch_name']; ?>" name="compny_branch_name[]">
						</tr>
					<?php } ?>	
				</tbody>
				<tr><td></td><td><input type="submit" class="btn btn-warning pull-right" value="Submit"></td></tr>
			</form>
			<?php } ?>
		</table>
	</div>														
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <label class="col-md-3 col-sm-3 col-xs-12" for="type">Invoice Print Settings<span class="required">*</span></label>
	<div class="col-md-9 col-sm-6 col-xs-12">
		<table class="table table-striped">
			<tbody>
			<form id="form_print_settings" method="post" action="<?php echo base_url(); ?>account/save_invoice_num_prefix" enctype="multipart/form-data">
				<tr>
				<?php
				//invoice_num_of_copies	
				$company_dtl = $this->account_model->get_data('company_detail',array('id'=> $this->companyGroupId));
				
			?>
				  <th scope="row">Number of copies</th>
				  <td><input type="number" class="form-control col-md-2 col-xs-12" value="<?php if($company_dtl[0]['invoice_num_of_copies'] != ''){echo $company_dtl[0]['invoice_num_of_copies'];} ?>" name="invoice_num_of_copies" min="1" max="10" Placeholder="Invoice Number of Copies" /> </td>
				</tr>
				 <tr><td></td><td><input type="submit" class="btn btn-warning pull-right" value="Submit"></td></tr>
			</form>
			 </tbody>
		</table>
	</div>
</div>
</div>
<div role="tabpanel" class="col-md-8 col-sm-12 col-xs-12 vertical-border tab-pane fade " id="tab_content2" aria-labelledby="profile-tab2" style="clear: both;"> 
	<div  class="col-md-12 col-sm-12 col-xs-12">
	  <label class="col-md-3 col-sm-3 col-xs-12" for="type">Invoice Email Settings<span class="required">*</span></label>
		<div class="col-md-9 col-sm-6 col-xs-12">
				<table class="table table-striped">
					<tbody>
						<tr>
						  <th scope="row">Invoice Email Settings</th>
						<td>
							<form id="form_email_Send_settings" method="post" action="<?php echo base_url(); ?>account/save_invoice_num_prefix" enctype="multipart/form-data">
								<input type="hidden" value="" name="email_send_setting" id="email_send_setting" >
								<?php
								   $company_email_Settings = $this->account_model->get_data('company_detail',array('id'=> $this->companyGroupId));
									if($company_email_Settings[0]['email_send_setting'] == 'email_send'){		
								?>
								<input type="checkbox" class="js-switch change_status_2"  data-switchery="true" value="" checked>
									<label for="subscribeNews">Email Send</label>
								<?php } else { ?>
								<input type="checkbox" class="js-switch change_status_2"  data-switchery="true" value="" >
								<label for="subscribeNews">Email not Send</label>
							<?php } ?>
							</form>
						</td>
					</tr>
			</tbody>
		</table>
	</div>
</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-3 col-xs-12" for="type">Discount ON/OFF <span class="required">*</span></label>
				<div class="col-md-9 col-sm-6 col-xs-12">
					<table class="table table-striped">
						<tbody>
						<tr>
						  <th scope="row">Invoice Discount ON / OFF</th>
						<td>
							<form id="discount_on_off" method="post" action="<?php echo base_url(); ?>account/save_invoice_num_prefix" enctype="multipart/form-data">
							<?php
							  $discount_Settings = $this->account_model->get_data('company_detail',array('id'=> $this->companyGroupId));
							   //pre($discount_Settings[0]['discount_on_off']);
								if($discount_Settings[0]['discount_on_off'] == '0'){//0 for OFF		
							?>
							<input type="hidden" value="1" name="discount_on_off" id="discount_on_off" >
							<input type="checkbox" class="js-switch change_status_discount"  data-switchery="true" value="" >
							<label for="subscribeNews"> Discount OFF</label>
							 <?php } else { //1 for ON ?>
							   <input type="hidden" value="0" name="discount_on_off" id="discount_on_off" >
    						   <input type="checkbox" class="js-switch change_status_discount"  data-switchery="true" value="" checked >
								<label for="subscribeNews"> Discount ON</label>
							   <?php } ?>
							</form>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
		   <label class="col-md-3 col-sm-3 col-xs-12" for="type">Multi Location ON/OFF<span class="required">*</span></label>
				<div class="col-md-9 col-sm-6 col-xs-12">
						<table class="table table-striped">
							<tbody>
								<tr>
		     					  <th scope="row">Multi Location ON / OFF</th>
							    <td>
									<form id="multi_loc_on_off" method="post" action="<?php echo base_url(); ?>account/save_invoice_num_prefix" enctype="multipart/form-data">
								<?php
								$discount_Settings = $this->account_model->get_data('company_detail',array('id'=> $this->companyGroupId));
							   //pre($discount_Settings[0]['discount_on_off']);
								if($discount_Settings[0]['multi_loc_on_off'] == '0'){//0 for OFF		
							   ?>
								<input type="hidden" value="1" name="multi_loc_on_off" id="multi_loc_on_off" >
								<input type="checkbox" class="js-switch change_status_location"  data-switchery="true" value="" >
							   <label for="subscribeNews"> Location OFF</label>
							<?php } else { //1 for ON ?>
							   <input type="hidden" value="0" name="multi_loc_on_off" id="multi_loc_on_off" >
							   <input type="checkbox" class="js-switch change_status_location"  data-switchery="true" value="" checked >
								<label for="subscribeNews"> Location ON</label>
						   <?php } ?>
						</form>
					</td>
				</tr>
		 </tbody>
	</table>
	</div>
	</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-3 col-xs-12" for="type">Item Code ON/OFF<span class="required">*</span></label>
			<div class="col-md-9 col-sm-6 col-xs-12">
				<table class="table table-striped">
				<tbody>
					<tr>
					  <th scope="row">Item Code ON / OFF</th>
					<td>
				<form id="item_code_on_off1" method="post" action="<?php echo base_url(); ?>account/save_invoice_num_prefix" enctype="multipart/form-data">
					<?php
						$item_code_Settings = $this->account_model->get_data('company_detail',array('id'=> $this->companyGroupId));
					   //pre($discount_Settings[0]['discount_on_off']);
						if($item_code_Settings[0]['item_code_on_off'] == '0'){//0 for OFF		
					?>
						<input type="hidden" value="1" name="item_code_on_off" id="item_code_on_off" >
						<input type="checkbox" class="js-switch change_status_item_code"  data-switchery="true" value="" >
					   <label for="subscribeNews"> Item Code OFF</label>
					 <?php } else { //1 for ON ?>
						<input type="hidden" value="0" name="item_code_on_off" id="item_code_on_off" >
						<input type="checkbox" class="js-switch change_status_item_code"  data-switchery="true" value="" checked >
						<label for="subscribeNews"> Item Code ON</label>
					<?php } ?>
				</form>
			</td>
			</tr>
		</tbody>
		</table>
	</div>
	</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
		  <label class="col-md-3 col-sm-3 col-xs-12" for="type">Invoice Cancel/Restore<span class="required">*</span></label>
			<div class="col-md-9 col-sm-6 col-xs-12">
				<table class="table table-striped">
					<tbody>
						<tr>
						<th scope="row">Invoice Cancel / Restore</th>
						<td>
						<form id="invoice_cancl_restor_form1" method="post" action="<?php echo base_url(); ?>account/save_invoice_num_prefix" enctype="multipart/form-data">
							 <?php
							   $item_code_Settings = $this->account_model->get_data('company_detail',array('id'=> $this->companyGroupId));
							   //pre($discount_Settings[0]['discount_on_off']);
								if($item_code_Settings[0]['invoice_cancl_restor'] == '0'){//0 for OFF		
								
							   ?>
						<input type="hidden" value="1" name="invoice_cancl_restor" id="invoice_cancl_restor" >
						<input type="checkbox" class="js-switch change_status_cancel_restor"  data-switchery="true" value="" >
						<label for="subscribeNews"> Invoice Cancel</label>
							<?php } else { //1 for ON ?>
						<input type="hidden" value="0" name="invoice_cancl_restor" id="invoice_cancl_restor" >
						<input type="checkbox" class="js-switch change_status_cancel_restor"  data-switchery="true" value="" checked >
						<label for="subscribeNews"> Invoice  Restore</label>
						<?php } ?>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		  <label class="col-md-3 col-sm-3 col-xs-12" for="type">Tax collected at source (TCS)<span class="required">*</span></label>
			<div class="col-md-9 col-sm-6 col-xs-12">
				<table class="table table-striped">
					<tbody>
						<tr>
						<th scope="row">Tax collected at source (TCS)</th>
						<td>
						<form id="tcs_onOff_formID" method="post" action="<?php echo base_url(); ?>account/save_invoice_num_prefix" enctype="multipart/form-data">
							 <?php
							   $item_code_Settings = $this->account_model->get_data('company_detail',array('id'=> $this->companyGroupId));
							   //pre($discount_Settings[0]['discount_on_off']);
								if($item_code_Settings[0]['tcs_onOff'] == '0'){//0 for OFF		
								
							   ?>
						<input type="hidden" value="1" name="tcs_onOff" id="tcs_onOffID" >
						<input type="checkbox" class="js-switch change_status_tcs_onOff"  data-switchery="true" value="" >
						<label for="subscribeNews"> TCS OFF</label>
							<?php } else { //1 for ON ?>
						<input type="hidden" value="0" name="tcs_onOff" id="tcs_onOffID" >
						<input type="checkbox" class="js-switch change_status_tcs_onOff"  data-switchery="true" value="" checked >
						<label for="subscribeNews"> TCS ON</label>
						<?php } ?>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		  <label class="col-md-3 col-sm-3 col-xs-12" for="type">TDS ON / OFF </label>
			<div class="col-md-9 col-sm-6 col-xs-12">
				<table class="table table-striped">
					<tbody>
						<tr>
						  <th scope="row">TDS ON / OFF</th>
						  <td>
							<form id="tdsonoff_form1" method="post" action="<?php echo base_url(); ?>account/save_invoice_num_prefix" enctype="multipart/form-data">
							  
							   <?php
							   $item_code_Settings = $this->account_model->get_data('company_detail',array('id'=> $_SESSION['loggedInUser']->c_id));
							   //pre($discount_Settings[0]['discount_on_off']);
								if($item_code_Settings[0]['tdsOFFON'] == '0'){//0 for OFF		
								
							   ?>
								<input type="hidden" value="1" name="tdsOFFON" id="tdsOFFON" >
								<input type="checkbox" class="js-switch change_tdsOFFON"  data-switchery="true" value="" >
							   <label for="subscribeNews"> TDS OFF</label>
							   <?php } else { //1 for ON ?>
							   <input type="hidden" value="0" name="tdsOFFON" id="tdsOFFON" >

							   <input type="checkbox" class="js-switch change_tdsOFFON"  data-switchery="true" value="" checked >
								<label for="subscribeNews"> TDS ON</label>
							   <?php } ?>
							</form>
							</td>
						</tr>
						
					 </tbody>
				</table>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
		  <label class="col-md-3 col-sm-3 col-xs-12" for="type">Ledger Limit ON / OFF </label>
			<div class="col-md-9 col-sm-6 col-xs-12">
				<table class="table table-striped">
					<tbody>
						<tr>
						  <th scope="row">Ledger Limit ON / OFF</th>
						  <td>
							<form id="ledgerLimit_form1" method="post" action="<?php echo base_url(); ?>account/save_invoice_num_prefix" enctype="multipart/form-data">
							  
							   <?php
							   $item_code_Settings = $this->account_model->get_data('company_detail',array('id'=> $_SESSION['loggedInUser']->c_id));
							   //pre($discount_Settings[0]['discount_on_off']);
								if($item_code_Settings[0]['ledger_crdit_limtOnOff'] == '0'){//0 for OFF		
								
							   ?>
								<input type="hidden" value="1" name="ledger_crdit_limtOnOff" id="ledger_crdit_limtOnOff" >
								<input type="checkbox" class="js-switch change_ledger_crdit_limtOnOff"  data-switchery="true" value="" >
							   <label for="subscribeNews"> Limit OFF</label>
							   <?php } else { //1 for ON ?>
							   <input type="hidden" value="0" name="ledger_crdit_limtOnOff" id="ledger_crdit_limtOnOff" >

							   <input type="checkbox" class="js-switch change_ledger_crdit_limtOnOff"  data-switchery="true" value="" checked >
								<label for="subscribeNews"> Limit ON</label>
							   <?php } ?>
							</form>
							</td>
						</tr>
						
					 </tbody>
				</table>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
		  <label class="col-md-3 col-sm-3 col-xs-12" for="type">QR Code<span class="required">*</span></label>
			<div class="col-md-9 col-sm-6 col-xs-12">
				<form id="qr_code_form" method="post" action="<?php echo base_url(); ?>account/save_invoice_num_prefix" enctype="multipart/form-data">
					<table class="table table-striped">
						<tbody>
							<tr>
								<th scope="row">QR Code ON/OFF</th>
								<td>
									 <?php
									   $item_code_Settings = $this->account_model->get_data('company_detail',array('id'=> $this->companyGroupId));
									   $imgExist = "";
										if($item_code_Settings[0]['qr_code']){
												$value = 1;
												$label = 'QR ON';
												$checked = "checked";
										}else {
											$value = 0;
											$label = 'QR OFF';
											$checked = "";
												
										}

										 ?>
										<input type="checkbox" class="js-switch qr_code" name="qr_code" data-switchery="true" value="<?= $value ?>" <?= $checked ?> >

										<label for="subscribeNews"><?= $label ?></label>
										<input type="hidden" name="qrCodeSubmit" value="1">
								</td>
							</tr>
							<?php $display = (!$item_code_Settings[0]['qr_code'])?'display:none':'';?>
							<tr id="qrImgTr" style="<?= $display ?>">
								<th scope="row">QR Code Image</th>
								<td>
									<?php
									$imgExist = "";
										if( $item_code_Settings[0]['qr_code_img'] ){
											$imgExist = "yes";
										}
									 ?>
									<input type="file" class="form-control" name="qr_code_img" id="qr_code_img">
									<?php if( isset($item_code_Settings[0]['qr_code_img']) && !empty($item_code_Settings[0]['qr_code_img']) ){ ?>
										<img src="<?= base_url('assets/modules/account/uploads/') ?><?= $item_code_Settings[0]['qr_code_img']??'' ?>" width="100px" height="100px">
									<?php } ?>
									
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
	</div>
	</div>
		<div role="tabpanel" class="col-md-8 col-sm-12 col-xs-12 vertical-border tab-pane fade " id="tab_content3" aria-labelledby="profile-tab2" style="clear: both;"> 
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom:20px;">
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="type">Aging  Email<span class="required">*</span></label>
						<div class="col-md-9 col-sm-6 col-xs-12">
						<?php 
							if(!empty($update_invoice_setting->aging_email_text)){
								$dataaging = json_decode($update_invoice_setting->aging_email_text,true);
							}	
						?>
						<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saveAgeingEmail" >
							<input type="text" value="<?php if(!empty($update_invoice_setting->aging_email_text)) echo $dataaging[0]['email_subject']; ?>" name="email_subject" id="email_subject" placeholder="Subject" class="form-control col-md-7 col-xs-12">
							<br/><br/><br/>
							<textarea  onkeyup="countChar_Aging(this)" col="160" rows="10" name="email_message" required="required" class="form-control col-md-7 col-xs-12" placeholder="Email Message"><?php if(!empty($update_invoice_setting->aging_email_text)) echo $dataaging[0]['email_message']; ?></textarea>
							<div id="charNum1"></div>
									<p class="text-muted font-13 m-b-30"></p>
									<input type="submit" class="btn btn-warning pull-right" value="Submit">
						</form> 
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
</div>
</div>
</div>
	