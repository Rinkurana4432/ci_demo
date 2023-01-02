<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saverecept_Details" enctype="multipart/form-data" id="voucherForm" novalidate="novalidate">
<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

 ?>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<div class="panel panel-default">
						 <h3 class="Material-head" style="margin-bottom: 30px;">Information<hr></h3>
						<div class="panel-body">
						<input type="hidden" name="id" value="<?php if(!empty($payment_dtl)) echo $payment_dtl->id; ?>">

						<input type="hidden" name="u_id" id="user_id" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>">
						<div class="col-md-6 col-sm-12 col-xs-12 form-group vertical-border">
						<div class=" item form-group">
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Party Name<span class="required">*</span></label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<select class="itemName form-control selectAjaxOption select2 invoice_detail"  required="required" name="party_id" data-id="ledger" data-key="id" data-fieldname="name" data-where="(created_by_cid=<?php echo $this->companyGroupId; ?> or created_by_cid != 0) AND save_status=1 AND activ_status = 1" width="100%">
											<option value="">Select</option>
											<?php
											if(!empty($payment_dtl)){
													$ledger = getNameById('ledger',$payment_dtl->party_id,'id');
													echo '<option value="'.$ledger->id.'" selected>'.$ledger->name.'</option>';
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
												if(!empty($payment_dtl)){
													$party_name = getNameById('ledger',$payment_dtl->party_name,'id');
													$add_dtl = JSON_DECODE($party_name->mailing_address,true);
													foreach($add_dtl as $ad_dtl){
														echo '<option value="'.$ad_dtl['mailing_state'].'" selected>'.$ad_dtl['mailing_address'].'</option>';
													}
												}
											?>

									   </select>
									   <input type="hidden" value="<?php if(!empty($payment_dtl)) echo $payment_dtl->party_branch_id; ?>" name="party_branch_id" id="party_branch_id" >
									</div>
								</div>
						<div class=" item form-group">
							<div class="item form-group">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="name">Party GSTIN</label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<input type="email" id="party_branch_gstno"  name="party_branch_gstno"   class="form-control col-md-7 col-xs-12" placeholder="GSTIN" value="<?php if(!empty($payment_dtl)) echo $payment_dtl->party_branch_gstno; ?>"  readonly>
								</div>
							</div>
						</div>
						<div class=" item form-group">
							<div class="item form-group">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="name">Email</label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<input type="email" id="email_idd"  name="party_email"   class="form-control col-md-7 col-xs-12" placeholder="Email" value="<?php if(!empty($payment_dtl)) echo $payment_dtl->party_email; ?>" autocomplete="off">
								</div>
							</div>
						</div>
						<div class=" item form-group">
							<div class="item form-group">
								<label class="col-md-3 col-sm-4 col-xs-12" for="name">Payment Date<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="payment_date" name="payment_date" required="required"   class="form-control col-md-7 col-xs-12" placeholder="DD/MM/YY" value="<?php if(!empty($payment_dtl)) echo date("d-m-Y", strtotime($payment_dtl->payment_date)); ?>" >
								</div>
							</div>
						</div>
					</div>





					<div class="col-md-6 col-sm-12 col-xs-12 form-group vertical-border">
						<div class="item form-group">
							<div class="item form-group">
							<label class="col-md-3 col-sm-3 col-xs-12">Payment ledger  <span class="required">*</span></label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<select class="form-control selectAjaxOption select2 recive_ledger_add"  required="required" name="recieve_ledger_id" data-id="ledger" data-key="id" data-fieldname="name" data-where="(created_by_cid=<?php echo $this->companyGroupId; ?> AND created_by_cid != 0 ) AND save_status=1 AND activ_status = 1" width="100%">
										<option value="">Select</option>
											<?php
											if(!empty($payment_dtl)){
													$ledger1 = getNameById('ledger',$payment_dtl->recieve_ledger_id,'id');
													echo '<option value="'.$ledger1->id.'" selected>'.$ledger1->name.'</option>';
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
												if(!empty($payment_dtl)){

													$Ledger_address = getNameById('company_detail',$this->companyGroupId,'id');

													$add_dtl = JSON_DECODE($Ledger_address->address,true);

													foreach($add_dtl as $ad_dtl_Sale){
														//pre($ad_dtl_Sale);
														$selected = ($ad_dtl_Sale['add_id'] == $payment_dtl->comp_branch_id) ? ' selected="selected"' : '';

														echo '<option value="'.$ad_dtl_Sale['add_id'].'"  "'.$selected.'" data-gst="'.$ad_dtl_Sale['company_gstin'].'" branh-id = "'.$ad_dtl_Sale['add_id'].'">'.$ad_dtl_Sale['compny_branch_name'].'</option>';
													}

												}
											?>

									   </select>
									    <input type="hidden" value="<?php if(!empty($payment_dtl)) echo $payment_dtl->comp_branch_id; ?>" name="comp_branch_id" id="comp_branch_id" >
								</div>
							</div>
						<div class=" item form-group">
							<div class="item form-group">
								<label class=" col-md-3 col-sm-3 col-xs-12" for="name">Payment GSTIN</label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<input type="email" id="comp_brnch_gstno"  name="comp_brnch_gstno"   class="form-control col-md-7 col-xs-12" placeholder="GSTIN" value="<?php if(!empty($payment_dtl)) echo $payment_dtl->comp_brnch_gstno; ?>"  readonly>
								</div>
							</div>
						</div>
						<div class=" item form-group">
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Reference no. <span class="required">*</span></label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<input type="text" required  name="reference_no"  class="form-control col-md-7 col-xs-12" placeholder="Reference no" value="<?php if(!empty($payment_dtl)){
                    echo $payment_dtl->reference_no;}else{ echo lastRefrenceNo('reference_no','payment'); }  ?>" autocomplete="off">
								</div>
							</div>
						</div>
						<?php
							//pre($payment_dtl);
						?>
						<div class="item form-group">
							<div class="item form-group">
								<label class="col-md-3 col-sm-4 col-xs-12" for="name">Received Amount<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">

									<?php if(!empty($payment_dtl)) { ?>
									<input type="text"  name="added_amount" required="required"    class='form-control col-md-7 col-xs-12 addd_amount'
									placeholder='0.00' value="<?php echo $payment_dtl->added_amount; ?>" autocomplete='off'>
									<?php } else{ ?>
									<input type='text'  name='added_amount' required='required' id="ttl_amt"   class='form-control col-md-7 col-xs-12 addd_amount Add_advance_payment' placeholder='0.00' value="" autocomplete='off' >
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="bottom-bdr"></div>
					<?php if(empty($payment_dtl)) { ?>
					<span class="msg_sho"></span>
					 <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap invoice_div" style="display:none;">
							<div class=" panel-default">
								<div class="panel-body goods_descr_wrapper">
									<div class="item form-group">
									<div class="col-md-12 input_descr_wrap label-box mobile-view2">
									<!--div class="col-md-1 col-sm-12 col-xs-12 form-group">
										<input type="checkbox"  class="check_class select_all" />
									</div-->
										<div class="col-md-3 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>
										</div>
										<div class="col-md-3 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="due_Date">Due Date</label>
										</div>
										<div class="col-md-3 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="open_amount">Open Amount</label>
										</div>
										<div class="col-md-3 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="payment_amount" style="border-right: 1px solid #c1c1c1;">Payment</label>
										</div>

									</div>

										<div class="app_div">

										</div>
										<input type="hidden" name="invoice_count_val" id="invoice_count_val" value="">

											<!--span class="error_msg"></span-->
									<div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-8 amount_disp" style="display:none;">
										<div class="col-md-2">
											<p>Amount : </p>

											</div>
											<div class="col-md-2">
												<input type="text" required="required" name="amount_to_apply[]"   class="form-control col-md-7 col-xs-12 amount_applyd"  readonly  >
											</div>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-8 amount_disp" style="display:none;" >

										<div class="col-md-2">
											<p>Advanced Payment : </p>

											</div>
											<div class="col-md-2">
											<input type="hidden"  name="total_tax"  class="form-control col-md-7 col-xs-12 total_tax_cls"   readonly  value ="">
											<input type="text"  name="amount_to_credit"  class="form-control col-md-7 col-xs-12 credit_amount"   readonly value="" >
											<input type="hidden"  name="balance"   class="form-control col-md-7 col-xs-12 minus_balance_id"   readonly  value="">
											<input type="hidden"  name="total_amount"   class="form-control col-md-7 col-xs-12 total_amount_id_recipt" value=""  readonly  >
											</div>
									</div>
										<div class="col-md-12 col-sm-12 col-xs-12 amount_disp" style="display:none;" >
										<div class="col-md-8 blnc" ></div>
										<input type="hidden" data-user-id="" data-balac-amt="" id="add_vals">
										</div>
									</div>
							</div>
						</div>
						<hr>
					<div class="bottom-bdr"></div>
				    </div>
					<?php } if(!empty($payment_dtl)) { ?>
					 <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap invoice_div">
							<div class=" panel-default">
								<div class="panel-body goods_descr_wrapper">
									<div class="item form-group">
									<div class="col-md-12 input_descr_wrap  label-box">
									<!--div class="col-md-1 col-sm-12 col-xs-12 form-group">
										<input type="checkbox"  class="check_class select_all" />
									</div-->
										<div class="col-md-3 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>
										</div>
										<div class="col-md-3 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="due_Date">Due Date</label>
										</div>
										<div class="col-md-3 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="open_amount">Open Amount</label>
										</div>
										<div class="col-md-3 item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12" for="payment_amount" style="border-right: 1px solid #c1c1c1;">Payment</label>
										</div>

									</div>

										<?php

										$payment_data = json_decode($payment_dtl->payment_detail);
										$open_amount = '';
										$ccount= 0;
										foreach($payment_data as $edit_Data){

											$open_amout += $edit_Data->open_balance;


										?>
										<div class="col-md-12 input_descr_wrap middle-box">

												<!--input class="checkbox check_class" type="checkbox" name="select_Dataw"-->
													<input class="invoic_cls" type="hidden" name="invoice_id[]" value="<?php echo $edit_Data->invoice_id; ?>">

											<div class="col-md-3 col-sm-12 col-xs-12 form-group">
												<input type="text" name="description[]" class="form-control col-md-1" placeholder="" value="<?php echo 'Invoice No #'. $edit_Data->invoice_id; ?>" readonly>
											</div>
											<div class="col-md-3 col-sm-12 col-xs-12 form-group">
												<input type="text" name="due_date[]" class="form-control col-md-1" placeholder="" value="<?php echo $edit_Data->due_date; ?>" readonly>
											</div>
											<div class="col-md-3 col-sm-12 col-xs-12 form-group">
												<div class="">
													<input class="invoic_cls" type="hidden" name="invoice_id_foradd" value="'+id+'">
													<input type="text" name="open_balance[]" class="form-control col-md-1 checkindex_<?php echo $ccount; ?>" placeholder="" value="<?php echo $edit_Data->open_balance; ?>" readonly>
												</div>
											</div>
											<div class="col-md-3 col-sm-12 col-xs-12 form-group checktr">
												<div class="">
													<input type="text" name="payment_amount[]" class="form-control col-md-1 chg_amt" placeholder="" value="<?php echo $edit_Data->payment_amount; ?>" >
													<input type="hidden" value="" class="add_index_<?php echo $ccount;  ?>">
												</div>
											</div>
										</div>

										<?php
										$ccount++;
										}

										?>

										<input type="hidden" name="invoice_count_val" id="invoice_count_val" value="<?php echo $ccount; ?>">
									<div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-8 amount_disp" style="padding-top:10px;">
										<div class="col-md-2">
											<p>Amount to Apply</p>

											</div>
											<div class="col-md-2">
												<input type="text" required="required" name="amount_to_apply[]"   class="form-control col-md-7 col-xs-12 amount_applyd"  readonly  >
											</div>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-8 amount_disp" >
										<div class="col-md-2">
											<p>Amount to Credit</p>

											</div>
											<div class="col-md-2">
											<input type="text"  name="amount_to_credit"  class="form-control col-md-7 col-xs-12 credit_amount"   readonly  >
											<input type="hidden"  name="balance"   class="form-control col-md-7 col-xs-12 minus_balance_id"   readonly  >
											<input type="hidden"  name="total_amount" class="form-control col-md-7 col-xs-12 total_amount_id_recipt" value="<?php if(!empty($payment_dtl->payment_detail)){echo $open_amout;}?>" >

											</div>
									</div>
									</div>
							</div>
						</div>
				    </div>



					<?php } ?>



					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="col-md-6 col-sm-12 col-xs-12 form-group vertical-border">
							<label class="col-md-3 col-sm-6 col-xs-12" for="narration">Narration</label>
							<div class="col-md-6">
							<textarea class="form-control col-md-7 col-xs-12" name="narration"><?php if(!empty($payment_dtl)) echo $payment_dtl->narration; ?></textarea>
							</div>
						</div>
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

					<button type="reset" class="btn btn-default">Reset</button>

					<button id="su_btn" type="submit" class="btn btn-warning add_recive_payment" >Submit</button>
                </div>
	</form>
