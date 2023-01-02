<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saveVoucher_Details" enctype="multipart/form-data" id="voucherForm" novalidate="novalidate">
<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
								/* For Financial Year*/
										$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId);//Fetch Data to Company Table
										$date_fcal = json_decode($date_fun->financial_year_date,true);
										
											if(empty($date_fcal)){
												if (date('m') <= 4) {//Upto June 2014-2015
													 $mydate = date(date('Y-04-01'));
													$lastyear = strtotime("-1 year", strtotime($mydate));
													$first_date = date("Y-m-d", $lastyear); 
													$date = date(date('Y-03-31'));
													$second_date = date('Y-m-d', strtotime("$date"));
												} else {//After June 2015-2016
													 $mydate = date(date('Y-04-01'));
													//$lastyear = strtotime("-1 year", strtotime($mydate));
													 $first_date = date("Y-m-d", strtotime($mydate));
													 $date = date(date('Y-03-31'));
													 $second_date22 = strtotime("+1 year", strtotime($date));
													 $second_date = date("Y-m-d", $second_date22); 
												}
											}else{
												
												if (date('m') <= 4) {//Upto June 2014-2015
													$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
													$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
													$first_date = date(date($s_Date));
													$date = date(date($e_Date));
													$second_date = date('Y-m-d', strtotime("$date"));
												} else {//After June 2015-2016
													$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
													$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
													$first_date = date(date($s_Date));
													$date = date(date($e_Date));
													 $second_date22 = strtotime("+1 year", strtotime($date));
													 $second_date = date('Y-m-d', $second_date22);
												}
											}	
							/* For Financial Year*/
							?>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<div class=" panel-default">
					    <h3 class="Material-head" style="margin-bottom: 30px;">Information<hr></h3>						
						<div class="panel-body">
						<input type="hidden" name="id" value="<?php if(!empty($voucher_dtls)) echo $voucher_dtls->id; ?>">
						<input type="hidden" name="u_id" id="user_id" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>">
						<input type="hidden" value="<?php echo $this->companyGroupId; ?>" id="company_login_id">
						<input type="hidden" name="save_status" value="1" class="save_status">
						<div class="col-md-6 col-xs-12 col-sm-12 vertical-border"> 
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="item form-group">
									<label class="col-md-3 col-sm-3 col-xs-12" for="name">Voucher Type<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										
										<select class="itemName form-control selectAjaxOption select2 add_option get_voucher_id"  required="required" name="voucher_name" data-id="voucher_type" data-key="id" data-fieldname="voucher_name" data-where="created_by_c_id=<?php echo $this->companyGroupId; ?> or created_by_c_id = 0" width="100%" id="get_add_more_btn_for_voucher"> 
										
												<option value="">Select</option>			
												<?php
													if(!empty($voucher_dtls)){
														$voucher_type = getNameById('voucher_type',$voucher_dtls->voucher_name,'id');
														echo '<option value="'.$voucher_type->id.'" selected>'.$voucher_type->voucher_name.'</option>';
													} 
												?>    
											</select> 	
									</div>
								</div>
							</div>
							<?php if(!empty($voucher_dtls) && $voucher_dtls->invoice_num_add != 0){ ?>
							<div class="col-md-12 col-sm-12 col-xs-12 invoice_drope" >
							<?php }else{ ?>
							<div class="col-md-12 col-sm-12 col-xs-12 invoice_drope" style="display:none;">
							<?php  } ?>
								<div class="item form-group">
									<label class="col-md-3 col-sm-3 col-xs-12" for="name">Invoice No.<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
									<?php 
										$whereInProcess = "( invoice.created_by_cid ='".$this->companyGroupId."') AND  (invoice.created_date >='".$first_date."' AND  invoice.created_date <='".$second_date."')";
									?>	
										<select class="itemName form-control selectAjaxOption select2"  required="required" 
										name="invoice_num_add" data-id="invoice" data-key="id" data-fieldname="invoice_num" data-where="<?php echo $whereInProcess; ?>" width="100%" id="invoice_num_check" > 
										
												<option value="">Select</option>			
												<?php
													if(!empty($voucher_dtls)){
														
														$invoice_num2 = getNameById('invoice',$voucher_dtls->invoice_num_add,'id');
														
														echo '<option value="'.$invoice_num2->id.'" selected>'.$invoice_num2->invoice_num.'</option>';
													} 
												?>    
											</select> 	
									</div>
								</div>
							</div>
							<?php if(!empty($voucher_dtls) && $voucher_dtls->purch_num_add != 0){ ?>
						<div class="col-md-12 col-sm-12 col-xs-12 purchase_bill_drope" >
							<?php }else{ ?>
							<div class="col-md-12 col-sm-12 col-xs-12 purchase_bill_drope" style="display:none;">
							<?php  } ?>
							
								<div class="item form-group">
									<label class="col-md-3 col-sm-3 col-xs-12" for="name">Purchase Bill No.<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
									<?php 
									
										
										$whereInProcess2 = "( purchase_bill.created_by_cid ='".$this->companyGroupId."') AND  (purchase_bill.created_date >='".$first_date."' AND  purchase_bill.created_date <='".$second_date."') AND (purchase_bill.auto_entry = 0)";
										
									?>	
										<select class="itemName form-control selectAjaxOption select2"  required="required" name="purch_num_add" data-id="purchase_bill" data-key="id" data-fieldname="invoice_num" data-where="<?php echo $whereInProcess2; ?>" width="100%" id="purchase_num_check" > 
										
												<option value="">Select</option>			
												<?php
													if(!empty($voucher_dtls)){
														$purch_num2 = getNameById('purchase_bill',$voucher_dtls->purch_num_add,'id');
														
														echo '<option value="'.$purch_num2->id.'" selected>'.$purch_num2->invoice_num.'</option>';
													} 
												?>    
											</select> 	
									</div>
								</div>
							</div>
							
							<!--div class="col-md-12 col-sm-12 col-xs-12 ">
								<div class="item form-group">
									<label class="col-md-3 col-sm-3 col-xs-12" for="name">Party Name<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<select class="itemName form-control selectAjaxOption select2 add_options add_ladger_button" id="party_Address_voucher"  required="required" name="party_id" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php //echo $_SESSION['loggedInUser']->c_id; ?> AND created_by_cid != 0 AND activ_status = 1 )"  width="100%"> 
										
											<option value="">Select</option>			
											<?php
												// if(!empty($voucher_dtls)){
													// $party_name = getNameById('ledger',$voucher_dtls->party_id,'id');
													// echo '<option value="'.$party_name->id.'" selected>'.$party_name->name.'</option>';
												// } 	
											?>    
										</select> 	
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 ">
								<div class="item form-group">
									<label class="col-md-3 col-sm-3 col-xs-12" for="name">Party Address<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<select id="Prty_vochr_address" name="party_state_id" class="itemName form-control" required="required">
									   <option value="">Select Address</option> 
											<?php
												// if(!empty($voucher_dtls)){
													// $party_name = getNameById('ledger',$voucher_dtls->party_id,'id');
													// $add_dtl = JSON_DECODE($party_name->mailing_address,true);
													
													// foreach($add_dtl as $ad_dtl){
														
														
														// $selected = ($ad_dtl['mailing_state'] == $voucher_dtls->party_state_id) ? ' selected="selected"' : '';
														// echo '<option value="'.$ad_dtl['mailing_state'].'"  "'.$selected.'" data-gst="'.$ad_dtl['gstin_no'].'">'.$ad_dtl['mailing_address'].'</option>';
													// }
													
												// } 
											?>
										
									   </select>
									</div>
								</div>
								<input type="hidden" name="party_branch_id" id="party_branch_id" value="<?php //if(!empty($voucher_dtls)) echo $voucher_dtls->party_branch_id; ?>" >
								
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 ">
								<div class="item form-group">
									<label class="col-md-3 col-sm-3 col-xs-12" for="name">GST<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<input type="text" name="party_gst" id="party_branch_gstno" required="required"   class="form-control col-md-7 col-xs-12" placeholder="GST Number" value="<?php //if(!empty($voucher_dtls)) echo $voucher_dtls->party_gst; ?>" readonly>
									</div>
								</div>
							</div-->
						
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="item form-group">
									<label class="col-md-3 col-sm-3 col-xs-12" for="name">Date<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										
										<input type="text" id="vocher_crtd_dt" name="voucher_date" required="required"   class="form-control col-md-7 col-xs-12" placeholder="mm-dd-yy" value="<?php if(!empty($voucher_dtls)) echo date("d-m-Y", strtotime($voucher_dtls->voucher_date)); ?>" >	
									</div>
								</div>
							</div>							
					</div>
											
						<div class="col-md-6 col-xs-12 col-sm-12 vertical-border"> 	
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Company Branch  </label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<select name="company_state_id" id="com_state_idds"  class="itemName form-control">
									   <option value="">Select Address</option> 
											<?php
											
												// if(!empty($voucher_dtls)){
													$voucher_address = getNameById('company_detail',$this->companyGroupId,'id');
													$add_dtl = JSON_DECODE($voucher_address->address,true);
													foreach($add_dtl as $ad_dtl_Pur){
														
														$selected = ($ad_dtl_Pur['add_id'] == $voucher_dtls->com_branch_id) ? ' selected="selected"' : '';
														
														echo '<option value="'.$ad_dtl_Pur['state'].'"   data-gst="'.$ad_dtl_Pur['company_gstin'].'" branh-id = "'.$ad_dtl_Pur['add_id'].'" "'.$selected.'" >'.$ad_dtl_Pur['compny_branch_name'].'</option>';
													}
													
												//} 
											?>
										
									   </select>
									   <input type="hidden" value="<?php if(!empty($voucher_dtls))  {echo $voucher_dtls->com_branch_id;}  ?>" name="com_branch_id" id="com_branch_id">
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Company GST <span class="required">*</span>  </label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="branch_gst" name="branch_gst" class="form-control col-md-7 col-xs-12 gstin" placeholder="GST No" value="<?php if(!empty($voucher_dtls)) echo $voucher_dtls->branch_gst; ?>" autocomplete="off" readonly>
								</div>
							</div>
						</div>
						
						</div>
						<hr>
						<div class="bottom-bdr"></div>
						<div class="col-md-12 input_descr_wrap label-box mobile-view2">
							<div class="col-md-3 col-sm-12 col-xs-12 item form-group">
								<label class="col-md-12 col-sm-12 col-xs-12" for="particulars">Type</label>
							</div>
								<div class="col-md-3 col-sm-12 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="particulars">Particulars</label>
								</div>
								<div class="col-md-3 col-sm-12 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="credit">Credit</label>
								</div>	
								<div class="col-md-3 col-sm-12 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="debit">Debit</label>
								</div>	
						</div>
						<div class="middle-box">
						<?php  if(empty($voucher_dtls)){ ?>
						
						<div class="col-md-12 input_descr_wrap add_credit_debit_voucher_details_div " style="padding-bottom: 30px;">
						<div class=" input_descr_wrap mobile-view mailing-box">
							
								<div class="col-md-3 col-sm-12 col-xs-12 item form-group">
								  <label>Type</label>
									<select name="cr_dr[]" class="form-control col-md-12 col-xs-12 select_type_d" >
										<option value="">Select</option>
										<option value="credit">Credit</option>
										<option value="debit">Debit</option>
									</select>
								</div>
									<div class="col-md-3 col-sm-12 col-xs-12 item form-group">
									    <label>Particulars</label>
										<select class="itemName form-control selectAjaxOption select2 dropdown1 add_ladger_button get_ladger_value"  required="required" name="credit_debit_party_dtl[]" data-id="ledger" data-key="id" data-fieldname="name" data-where="(created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid = 0) AND save_status=1 AND activ_status = 1" width="100%" >
											<option value="">Select</option>			
												
										</select>
									
									</div>
									<div class="col-md-3 col-sm-12 col-xs-12 item form-group">
									 <label>Credit</label>
									<input type="text" name="credit_1[]"  class="form-control col-md-7 col-xs-12 keyup_check_event disable_credit">
										
									</div>	
									<div class="col-md-3 col-sm-12 col-xs-12 item form-group" style="border-right: 1px solid #c1c1c1;">
										<label>Debit</label>
										<input type="text" name="debit_1[]" value=""  class="form-control col-md-7 col-xs-12 keyup_check_event  disable_debit"  autocomplete="off">
									</div>
									<span class='message'></span>
</div>	 									
									<div class="col-sm-12 btn-row"><button class="btn btn-primary add_voucher_credit_detailbutton" type="button">Add</button></div>
										
								
					</div>	

						<?php } ?>
						
						
							<?php
								if(!empty($voucher_dtls) && $voucher_dtls->credit_debit_party_dtl !=''){

								?>
					<div class="col-md-12 input_descr_wrap add_credit_debit_voucher_details_div " style="padding-bottom: 30px;">							
								<?php
								$cr_dr_datas = json_decode($voucher_dtls->credit_debit_party_dtl);	
										if(!empty($cr_dr_datas)){	
											$i = 0;
											foreach($cr_dr_datas as $cr_dr_data){
													
									
						?>
							<div class="input_descr_wrap  mobile-view mailing-box">
								<div class="col-md-3 col-sm-12 col-xs-12 item form-group">
								      <label>Type</label>
									<select name="cr_dr[]" class="form-control col-md-7 col-xs-12 select_type_d" >
										<option value="">Select</option>
										<option value="credit" <?php if($cr_dr_data->cr_dr == 'credit') { ?> selected="selected"<?php } ?>>Credit</option>
										<option value="debit" <?php if($cr_dr_data->cr_dr == 'debit') { ?> selected="selected"<?php } ?>>Debit</option>
									</select>
								</div>
									<div class="col-md-3 col-sm-12 col-xs-12 item form-group">
									     <label>Particulars</label>
										<select class="itemName form-control selectAjaxOption select2 dropdown1 add_ladger_button get_party_id get_ladger_value"  required="required" name="credit_debit_party_dtl[]" data-id="ledger" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid = 0" width="100%" >
											
											<option value="">Select</option>			
												<?php
												if(!empty($cr_dr_data)){
													
													if($cr_dr_data->cr_dr != 'debit'){
														$credit_party = getNameById('ledger',$cr_dr_data->credit_debit_party_dtl,'id');
														echo '<option value="'.$credit_party->id.'" selected>'.$credit_party->name.'</option>';
													}else{
														$credit_party = getNameById('ledger',$cr_dr_data->credit_debit_party_dtl,'id');
														
														echo '<option value="'.$credit_party->id.'" selected>'.$credit_party->name.'</option>';
														}
													} 
												?>  		
												
										</select>
										
									
									</div>
									<div class="col-md-3 col-sm-12 col-xs-12 item form-group">
									    <label>Credit</label>
										<input type="text" name="credit_1[]" value="<?php if(!empty($cr_dr_data)) echo $cr_dr_data->credit_1; ?>" <?php if(empty($cr_dr_data->credit_1)) //{echo "disabled";}  ?>  class="form-control col-md-7 col-xs-12 keyup_check_event disable_credit">
									</div>	
									<div class="col-md-3 col-sm-12 col-xs-12 item form-group" style="border-right: 1px solid #c1c1c1;">
									    <label>Debit</label>
										<input type="text" name="debit_1[]" value="<?php if(!empty($cr_dr_data)) echo $cr_dr_data->debit_1; ?>" <?php if(empty($cr_dr_data->debit_1)) //{ echo "disabled";}  ?> class="form-control col-md-7 col-xs-12 keyup_check_event  disable_debit"  autocomplete="off">
									</div>
									<span class='message'></span>	
									<?php if($i==0){
												echo '';
											}else{	
												echo '<button class="btn btn-danger remove_voucher_field" type="button"> <i class="fa fa-minus"></i></button>';
											} ?>
							</div>	
							 <?php if($i==0){
												echo '<div class="col-sm-12 btn-row"><button class="btn btn-primary add_voucher_credit_detailbutton" type="button">Add</button></div>';
											}else{	
												echo '';
											} ?>
							<?php 
								$i++;
								}} }
							?>						
					</div>	
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="col-md-2 col-md-offset-6">
							<input type="text"  id="credit_total" name="total"   class="form-control col-md-7 col-xs-12" style="border: none; background:#fff;" readonly  >
						</div>
						<div class="col-md-2 col-md-offset-1">
							<input type="text"  id="debit_total"   class="form-control col-md-7 col-xs-12" style="border: none; background:#fff;"  readonly  >
						</div>
					</div>	
 
                
					
						<div class="col-md-6 item form-group vertical-border">
							<label class="col-md-3 col-sm-12 col-xs-12" for="narration">Narration</label>
							<textarea class="col-md-6 col-xs-12" name="narration"><?php if(!empty($voucher_dtls)) echo $voucher_dtls->narration; ?></textarea>
						</div>
					
				
				</div>	
			</div>
			<input type="hidden" value="" name="credit_debit" id="credit_ya_debit">
			
		</div>
				<div class="col-md-12 modal-footer">
				   <center>
				   
					<button type="reset" class="btn btn-default">Reset</button>
					<button id="su_btn_voucher" type="submit" class="btn btn-warning" >Submit</button>
				   </center>
                </div>			
	</form>		


<!-- Add Ladger Modal-->

   
	
	<div class="modal left fade" id="myModal_Add_party" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
			<div class="modal-header">
		
                <h4 class="modal-title" id="myModalLabel">Add Party</h4>
				<span id="mssg"></span>
			</div>
			<form name="insert_party_data" name="ins"  id="insert_party_data_id">
                 <div class="modal-body">
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="name">Party Name <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" id="partyname" name="name" required="required" class="form-control col-md-7 col-xs-12 party_namee" value="">
						<input type="hidden" value="" id="fetch_pname">
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
				<div class="required item form-group company_brnch_div col-md-12 col-sm-12 col-xs-12" style="display:none;"  >
							<label class="col-md-2 col-sm-2 col-xs-4" for="company_branch">Company Branch <span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<select class="itemName form-control select_company_branch" required="required" name="compny_branch_id">
									<option value="">Select Type And Begin</option>
									   <?php
										$branch_add = getNameById('company_detail',$_SESSION['loggedInUser']->u_id,'u_id');				
										$data =  json_decode($branch_add->address,true);
											foreach($data as $brnch_name){
										?>
									 <option value="<?php echo $brnch_name['add_id'];  ?>"><?php echo $brnch_name['compny_branch_name']; ?></option>
									 <?php } ?>
								</select> 
								<span id="branch_dd"></span>		
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
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-4" for="opening_balances">Opening Balance </label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="opening_balance" name="opening_balance" class="form-control col-md-7 col-xs-12" value="" >
							<span class="spanLeft control-label"></span>
						</div>
					</div>
				</div>
                <div class="modal-footer">
				<input type="hidden" id="sale_ledger_data">
				    <button type="button" class="btn btn-default close_sec_model close_modal2" >Close</button>
					<button id="bbttn" type="button" class="btn btn-warning">Submit</button>
                </div>
				</form>
            </div>
        </div>
    </div>
<!-- Add Ladger Modal-->

<!--form method="post" class="form-horizontal" action="<?php //echo base_url(); ?>account/saveVoucher_type" enctype="multipart/form-data" id="companyForm" novalidate="novalidate"-->
	<div class="modal" id="myModal_Add_voucher" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
			<div class="modal-header">
		
                <h4 class="modal-title" id="myModalLabel">Add Voucher</h4>
				<span id="mssg_voucher"></span>
			</div>
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="item form-group col-md-12">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Voucher Name <b style="color:red;">*</b></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="voucher_name" name="voucher_name"  data-validate-length-range="4"  class="form-control col-md-7 col-xs-12" placeholder="Sale" value="">
								<span class="spanLeft control-label"></span>
							</div>
						</div>
						<div class="item form-group col-md-12">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Voucher Description <b style="color:red;">*</b> </label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							<textarea  name="voucher_desc" id='voucher_desc'  class="form-control col-md-7 col-xs-12" placeholder="Descriptions"></textarea> 
								<span class="spanLeft control-label"></span>							
							</div>
						</div>
					</div>
				</div>
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<div class="modal-footer">
				<button type="button" class="btn btn-default close_sec_model close_modal2" >Close</button>
				<button id="add_voucher_bbtn" type="button" class="btn btn-warning">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
				<!--/form>--
			</div>	
	
	
	