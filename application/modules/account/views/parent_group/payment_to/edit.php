<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/savepayment_to_Details" enctype="multipart/form-data" id="voucherForm" novalidate="novalidate">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<div class=" panel-default">
						
						<h3 class="Material-head">Information <hr></h3>
						<div class="panel-body">
						<input type="hidden" name="id" value="<?php if(!empty($payment_to_dtl)) echo $payment_to_dtl->id; ?>">
						<input type="hidden" name="u_id" id="user_id" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>">
						<input type="hidden" name="save_status" value="1" class="save_status">
						<div class="col-md-6 col-sm-12 col-xs-12 form-group vertical-border">
						<div class="col-md-12 item form-group">
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Deposit To<span class="required">*</span></label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<select class="itemName form-control selectAjaxOption select2 get_not_paid_purchase_bills"  required="required" name="party_id" data-id="ledger" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status=1" width="100%" onchange="getEmail(this,event);"> 										
											<option value="">Select</option>			
											<?php
											if(!empty($payment_to_dtl)){
													$supplier = getNameById('ledger',$payment_to_dtl->party_id,'id');
													echo '<option value="'.$supplier->id.'" selected>'.$supplier->name.'</option>';
												} 
											?>    
										</select> 	
								</div>
							</div>
						</div>
						<div class="item form-group">
									<label class="col-md-3 col-sm-12 col-xs-12" for="Addresses">Party Address<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
									   <select name="party_state_id" id="Party_address" class="itemName form-control" required="required">
									   <option value="">Select Address</option> 
											<?php
												if(!empty($payment_to_dtl)){
													$party_name = getNameById('ledger',$payment_to_dtl->party_name,'id');
													$add_dtl = JSON_DECODE($party_name->mailing_address,true);
													foreach($add_dtl as $ad_dtl){
														echo '<option value="'.$ad_dtl['mailing_state'].'" selected>'.$ad_dtl['mailing_address'].'</option>';
													}
												} 
											?>
										
									   </select>
									   <input type="hidden" value="<?php if(!empty($payment_to_dtl)) echo $payment_to_dtl->party_branch_id; ?>" name="party_branch_id" id="party_branch_id" >
							</div>
						</div>
						<div class=" item form-group">
							<div class="item form-group">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="name">Party GSTIN</label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<input type="email" id="party_branch_gstno"  name="party_branch_gstno"   class="form-control col-md-7 col-xs-12" placeholder="GSTIN" value="<?php if(!empty($payment_to_dtl)) echo $payment_to_dtl->party_branch_gstno; ?>"  readonly>
								</div>
							</div>
						</div>	
						
						<div class="col-md-12 item form-group">
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Email</label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<input type="email" id="email_idd"  name="party_email"   class="form-control col-md-7 col-xs-12" placeholder="Email" value="<?php if(!empty($payment_to_dtl)) echo $payment_to_dtl->party_email; ?>" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="col-md-12 item form-group">
							<div class="item form-group">
								<label class="col-md-3 col-sm-4 col-xs-12" for="name">Payment Date<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="payment_date" name="payment_date" required="required"   class="form-control col-md-7 col-xs-12" placeholder="DD/MM/YY" value="<?php if(!empty($payment_to_dtl)) echo date("d-m-Y", strtotime($payment_to_dtl->payment_date)); ?>" autocomplete="off">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12 form-group vertical-border">
						<div class="col-md-12 item form-group">
							<div class="item form-group">
							<label class="col-md-3 col-sm-3 col-xs-12">Payment From</label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<select class="form-control selectAjaxOption select2"  required="required" name="recieve_ledger_id" data-id="ledger" data-key="id" data-fieldname="name" data-where="(created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>) AND save_status=1" width="100%"> 										
										<option value="">Select</option>
											<?php
											if(!empty($payment_to_dtl)){
													$recieve_ledger = getNameById('ledger',$payment_to_dtl->recieve_ledger_id,'id');
													echo '<option value="'.$recieve_ledger->id.'" selected>'.$recieve_ledger->name.'</option>';
												} 
											?>  
										
									</select>	
								</div>
							</div>
						</div>
						<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Payment Address <span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<select name="comp_sate_id" id="comp_address" class="itemName form-control" required="required">
									   <option value="">Select Address</option> 
											<?php
												//if(!empty($invoice_detail)){
													$Ledger_address = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
												
													$add_dtl = JSON_DECODE($Ledger_address->address,true);
													
													foreach($add_dtl as $ad_dtl_Sale){
														$selected = ($ad_dtl_Sale['state'] == $payment_to_dtl->sale_L_state_id) ? ' selected="selected"' : '';
														
														echo '<option value="'.$ad_dtl_Sale['state'].'"  "'.$selected.'" data-gst="'.$ad_dtl_Sale['company_gstin'].'" branh-id = "'.$ad_dtl_Sale['add_id'].'">'.$ad_dtl_Sale['compny_branch_name'].'</option>';
													}
													
												//} 
											?>
										
									   </select>
									    <input type="hidden" value="<?php if(!empty($payment_to_dtl)) echo $payment_to_dtl->comp_branch_id; ?>" name="comp_branch_id" id="comp_branch_id" >
								</div>
							</div>
						<div class=" item form-group">
							<div class="item form-group">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="name">Payment GSTIN</label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<input type="email" id="comp_brnch_gstno"  name="comp_brnch_gstno"   class="form-control col-md-7 col-xs-12" placeholder="GSTIN" value="<?php if(!empty($payment_to_dtl)) echo $payment_to_dtl->comp_brnch_gstno; ?>"  readonly>
								</div>
							</div>
						</div>
						<!--<div class="col-md-4 item form-group">
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Payment Method<span class="required">*</span></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
								<!--select class="itemName form-control selectAjaxOption select2"  required="required" name="party_id" data-id="ledger" data-key="id" data-fieldname="name" data-where="created_by=<?php //echo $_SESSION['loggedInUser']->u_id; ?>" width="100%"> 										
											<option value="">Select</option>			
											<?php
											// if(!empty($payment_dtl)){
													// $ledger = getNameById('ledger',$payment_dtl->party_id,'id');
													// echo '<option value="'.$ledger->id.'" selected>'.$ledger->name.'</option>';
												// } 
											?>    
								</select-->

								<!--<select name="payment_method" class="form-control" required="required" >
								<option value="">Select Method </option>
								<option value="cash" <?php// if(!empty($payment_to_dtl)){ if($payment_to_dtl->payment_method == 'cash') { ?> selected="selected"<?php //} }?>>Cash</option>
								<option value="credit card" <?php //if(!empty($payment_to_dtl)){ if($payment_to_dtl->payment_method == 'credit card') { ?> selected="selected"<?php //} //}?>>Credit Card</option>
								<option value="debit card" <?php //if(!empty($payment_to_dtl)){ if($payment_to_dtl->payment_method == 'debit card') { ?> selected="selected"<?php //} }?>>Debit Card</option>
								</select>		
									
								</div>
							</div>
						</div>-->
						<div class="col-md-12 item form-group">
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Reference no.</label>
								<div class="col-md-6 col-sm-9 col-xs-12">
								
									<input type="text"  name="reference_no"  class="form-control col-md-7 col-xs-12" placeholder="Reference no" value="<?php if(!empty($payment_to_dtl)) echo $payment_to_dtl->reference_no; ?>" autocomplete="off">
								</div>
							</div>
						</div>
						
						<div class="col-md-12 item form-group">
					
							<div class="item form-group">
								<label class="col-md-3 col-sm-4 col-xs-12" for="name">To Amount<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								<input type='text'  name='added_amount' id="ttl_amt_payment_to" class='form-control col-md-7 col-xs-12 addd_payment_amount' placeholder='0.00' autocomplete='off' value="<?php if(!empty($payment_to_dtl)){
								echo $payment_to_dtl->added_amount;} ?>">
								 
								</div>
							</div>
						</div>	
					</div>
					
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						<!--div class="col-md-4 item form-group">
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Bank Name<span class="required">*</span></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
								<select class="bank_name form-control selectAjaxOption select2"  required="required" name="bank_name" data-id="bank_name" data-key="bankid" data-fieldname="bank_name" width="100%"> 										
											<option value="">Select</option>			
											<?php
											/*if(!empty($payment_dtl)){
												pre($payment_dtl);
													 $bankId = getNameById('bank_name',$payment_dtl->bank_name_id,'id');
													 echo '<option value="'.$bankId->bank_name_id.'" selected>'.$bankId->bank_name.'</option>';
												 } */
											?>    
								</select>
								<!--select name="payment_method" class="form-control" required="required" >
								<option value="">Select Method </option>
								<option value="" >HDFC Bank</option>
								<option value=" " >ICIC Bank</option>
								<option value=" ">PNB Bank</option>
								</select
									
								</div>
							</div>
						</div>-->		
						</div>
					
					
<hr>					
<div class="bottom-bdr"></div>						
					
					<span class="msg_sho_payment_to"></span>
					<?php if(empty($payment_to_dtl)) { ?>
					 <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap bills_div_header" style="display:none;">
							<div class=" panel-default">
								<div class="panel-body goods_descr_wrapper">
									<div class="item form-group">
									<div class="col-md-12 input_descr_wrap label-box mobile-view2">
									<!--div class="col-md-1 col-sm-12 col-xs-12 form-group">
										<input type="checkbox"  class="check_class select_all" />
									</div-->
									<div class="col-md-3 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">From</label>
										</div>
										<div class="col-md-3 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>
										</div>
										<div class="col-md-2 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="bill_date">Bill Date</label>
										</div>	
										<div class="col-md-2 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="open_amount">Open Amount</label>
										</div>	
										<div class="col-md-2 item form-group" style="border-right: 1px solid #c1c1c1;">
											<label class="col-md-12 col-sm-12 col-xs-12" for="payment_amount">Payment</label>
										</div >	
										<!--div class="col-md-2 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="payment_amount">Payment</label>
										</div-->	
										
									</div>
										<div class="bills_div">
									
										</div>
										<input type="hidden" name="invoice_count_val" id="purchase_bill_count_val" value="">
										<span class="error_msg"></span>
									<div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-8 bill_amount_disp" style="display:none;">
										<div class="col-md-2">
											<p>Amount to Apply</p>

											</div>
											<div class="col-md-2">
												<input type="text" required="required" name="amount_to_apply[]"   class="form-control col-md-7 col-xs-12 payment_to_amount_applyd"  readonly  >
											</div>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-8 bill_amount_disp" style="display:none;" >
										<div class="col-md-2">
											<p>Amount to Credit</p>

											</div>
											<div class="col-md-2">
											<input type="text"  name="amount_to_credit" value=""  class="form-control col-md-7 col-xs-12 credit_payment_amount"   readonly  >
											<input type="hidden"  name="balance"   class="form-control col-md-7 col-xs-12 minus_balance_id_payment_to"   readonly  >
											<input type="hidden"  name="total_amount"   class="form-control col-md-7 col-xs-12 total_amount_id_payment_to"   readonly  >
											</div>
									</div>
									<hr>					
                                    <div class="bottom-bdr"></div>		
									</div>
							</div>
						</div>
				    </div>
					<?php } if(!empty($payment_to_dtl)) { ?>
					 <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap invoice_div">
							<div class="panel panel-default">
								<div class="panel-body goods_descr_wrapper">
									<div class="item form-group">
									<div class="col-md-12 input_descr_wrap label-box">
									
									<!--div class="col-md-1 col-sm-12 col-xs-12 form-group">
										<input type="checkbox"  class="check_class select_all" />
									</div-->
									<div class="col-md-3 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">From</label>
										</div>
										<div class="col-md-3 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>
										</div>
										<div class="col-md-2 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="bill_date">Bill Date</label>
										</div>	
										<div class="col-md-2 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="open_amount">Open Amount</label>
										</div>	
										<div class="col-md-2 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="payment_amount">Payment</label>
										</div>	
										<!--div class="col-md-2 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="payment_amount">Payment</label>
										</div-->
										
									</div>
										
										<?php 
										
										$payment_data = json_decode($payment_to_dtl->payment_detail);
											$ccount= 0;	
										foreach($payment_data as $edit_Data){
										
											$open_amout += $edit_Data->open_balance;
											

										?>
										
										<div class="col-md-12 input_descr_wrap app_div ">
											<div class="col-md-3 col-sm-12 col-xs-12 form-group">
												<!--input class="checkbox check_class" type="checkbox" name="select_Dataw"-->
													<input class="invoic_cls" type="hidden" name="bill_id[]" value="<?php echo $edit_Data->bill_id; ?>">
											</div>
											<div class="col-md-3 col-sm-12 col-xs-12 form-group">
												<input type="text" name="description[]" class="form-control col-md-1" placeholder="" value="<?php echo 'Bill Id #'.' '.$edit_Data->bill_id; ?>" readonly>
											</div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group">
												<input type="text" name="date[]" class="form-control col-md-1" placeholder="" value="<?php echo $edit_Data->date; ?>" readonly>
											</div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group">
												<div class="input-group"> 
												
													<input type="text" name="open_balance[]" class="form-control col-md-1 checkindexP_<?php echo $ccount;  ?>" placeholder="" value="<?php echo $edit_Data->open_balance; ?>" readonly>
												</div>
											</div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group checktr">
												<div class="input-group">
													<input type="text" name="payment_amount[]" class="form-control col-md-1 change_payment_to_amount" placeholder="" value="<?php echo $edit_Data->payment_amount; ?>" >
													<input type="hidden" value="" class="add_indexP_<?php echo $ccount;  ?>">
												</div>
											</div>
										</div>
										<?php 
										$ccount++;
										} 
										
										?>
										<input type="hidden" name="invoice_count_val" id="purchase_bill_count_val" value="<?php echo $ccount; ?>">
										
									<div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-8 bill_amount_disp" >
										<div class="col-md-2">
											<p>Amount to Apply</p>

											</div>
											<div class="col-md-2">
												<input type="text" required="required" name="amount_to_apply[]"   class="form-control col-md-7 col-xs-12 payment_to_amount_applyd"  readonly  >
											</div>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-8 bill_amount_disp" >
										<div class="col-md-2">
											<p>Amount to Credit</p>

											</div>
											<div class="col-md-2">
											<input type="text"  name="amount_to_credit"  class="form-control col-md-7 col-xs-12 credit_payment_amount" value=""   readonly  >
											<input type="hidden"  name="balance"   class="form-control col-md-7 col-xs-12 minus_balance_id_payment_to"   readonly  >
											<input type="hidden"  name="total_amount" class="form-control col-md-7 col-xs-12 total_amount_id_payment_to" value="<?php if(!empty($payment_to_dtl->payment_detail)){echo $open_amout;}?>"  readonly  >
											</div>
									</div>
									<!--div class="col-md-12 col-sm-12 col-xs-12 form-group">
										<div class="col-md-4 item form-group">
											<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Deposit To<span class="required">*</span></label>
												<div class="col-md-9 col-sm-9 col-xs-12">
													<select class="itemName form-control selectAjaxOption select2"  required="required" name="party_id" data-id="ledger" data-key="id" data-fieldname="name" data-where="created_by=<?php //echo $_SESSION['loggedInUser']->u_id; ?>" width="100%"> 										
															<option value="">Select</option>			
															<?php
															// if(!empty($payment_dtl)){
																	// $ledger = getNameById('ledger',$payment_dtl->party_id,'id');
																	// echo '<option value="'.$ledger->id.'" selected>'.$ledger->name.'</option>';
																// } 
															?>    
												</select> 	
												</div>
											</div>
										</div>
									</div-->									
									</div>
							</div>
						</div>
				    </div>					
										
										
										
					<?php } ?>
					
				
					
						<div class="col-md-6 col-sm-12 col-xs-12 form-group vertical-border">
							<label class="col-md-3 col-sm-6 col-xs-12" for="narration">Narration</label>
							<div class="col-md-6 col-xs-12 col-sm-12"><textarea class="form-control col-md-7 col-xs-12" name="narration"><?php if(!empty($payment_to_dtl)) echo $payment_to_dtl->narration; ?></textarea></div>
						</div>
					
					<!--div class="col-md-12 col-sm-12 col-xs-12">
						<div class="col-md-8 item form-group">
							<label class="col-md-6 col-sm-6 col-xs-12" for="payment_attachment">Payment Attachment</label>
							<input type="file" class="form-control col-md-7 col-xs-12" name="payment_attachment_files[]">
						</div>
					</div-->
				</div>	
			</div>
		</div>
				<div class="modal-footer">
				    <button type="button" class="btn btn-default close_modal2" data-dismiss="modal" >Close</button>
					<button type="reset" class="btn btn-default">Reset</button>
					<button id="su_btn" type="submit" class="btn btn-warning disabl_cls add_payment_to" >Submit</button>
                </div>			
	</form>	
	
	