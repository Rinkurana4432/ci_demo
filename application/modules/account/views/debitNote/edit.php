<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/savePurchase_return_DebitNote" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

?>
<input type="hidden" name="id" value="<?php if(!empty($DRDNDtl)) echo $DRDNDtl->id; ?>" id="debitID">
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		<h3 class="Material-head">Debit Note Purchase Return <hr></h3>
     <div class="col-md-6 col-xs-12 col-sm-6 vertical-border">
	      <div class="panel-default">
						<div class="panel-body">
								<div class="item form-group">
									<label class=" col-md-3 col-sm-12 col-xs-12" for="debitNoteNo">Debit Note Number <span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<input id="crnote_number" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($DRDNDtl)) echo $DRDNDtl->debitNoteNo;  ?>" name="debitNoteNo" placeholder="005" required="required" >
									</div>
								</div>
								<div class="item form-group">
									<label class=" col-md-3 col-sm-12 col-xs-12" for="date">Debit Note Date</label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<input type="text" id="cr_date" class="form-control col-md-7 col-xs-12" name="date"  value="<?php if(!empty($DRDNDtl)) echo date("d-m-Y", strtotime($DRDNDtl->date));
											if(empty($DRDNDtl)){ echo date('d-m-Y');} ?>" Placeholder="Credit Note Date" />

									</div>
								</div>
								<div class="required item form-group">
									<label class="col-md-3 col-sm-12 col-xs-4" for="parent_ledger">Supplier</label>
									<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="hidden" value="<?php echo $this->companyGroupId; ?>" id="company_login_id">
									<select class="itemName form-control selectAjaxOption select2 select_supplier_dataOnchange"  required="required" name="supplier_id" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $this->companyGroupId; ?> AND created_by_cid != 0 AND activ_status = 1   AND 	account_group_id = 55)"  width="100%" onchange="getcustomer_purchaseBill(event,this);">
									<option value="">Select</option>
												<?php
													if(!empty($DRDNDtl)){
														$party_name = getNameById('ledger',$DRDNDtl->supplier_id,'id');
														echo '<option value="'.$party_name->id.'" selected>'.$party_name->name.'</option>';
													}
												?>
											</select>
									</div>
								</div>
								<div class="required item form-group">
									<label class="col-md-3 col-sm-12 col-xs-4" for="supplier_email">Email</label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<input type="text" value="<?php if(!empty($DRDNDtl)) echo $DRDNDtl->supplier_email;  ?>" id="supplier_email" name="supplier_email" class="itemName form-control" >
									</div>
								</div>
						</div>
			   </div>
	    </div>
      <div class="col-sm-6 col-sm-6 col-xs-12 vertical-border">
		      <div class=" panel-default">
							<div class="panel-body">
									<div class="item form-group">
												<label class=" col-md-3 col-sm-12 col-xs-12" for="invoice_no">Purchase Bill No <span class="required">*</span></label>
												<div class="col-md-6 col-sm-12 col-xs-12">
														<select class="itemName form-control selectAjaxOption select2 PurchaseIdSelect get_not_paid_PurchaseBill"  required="required" name="PurchaseBill_no"  width="100%">
														<option value="">Select</option>
														<?php
															if(!empty($DRDNDtl)){
																$invoiceID = getNameById('purchase_bill',$DRDNDtl->PurchaseBill_no,'id');
																//pre($invoiceID->invoice_num);
																echo '<option value="'.$DRDNDtl->PurchaseBill_no.'" selected>'.$invoiceID->invoice_num.'</option>';
															}
														?>
														</select>
												 </div>
									</div>
									<input type="hidden" value="0" name="PurchaseReturn_DN_ornot">
								  <div class="item form-group">
										<label class=" col-md-3 col-sm-12 col-xs-12" for="ledgerID">Buyer <span class="required">*</span></label>
										<div class="col-md-6 col-sm-12 col-xs-12 ">
											<select class="itemName form-control selectAjaxOption select2" required="required" name="buyerID" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid = 0 AND activ_status = 1)"  width="100%">
												<option value="">Select</option>
												<?php
													if(!empty($DRDNDtl)){
														$saleLedgerID = getNameById('ledger',$DRDNDtl->buyerID,'id');
														echo '<option value="'.$saleLedgerID->id.'" selected>'.$saleLedgerID->name.'</option>';
													}
												?>
											</select>
										</div>
									</div>
									<div class="required item form-group">
									 <label class="col-md-3 col-sm-12 col-xs-4" for="comment">Refrence No.<span class="required">*</span></label>
									 <div class="col-md-6 col-sm-12 col-xs-12">
										 <input required="required"  type="text"  id="refrence" name="refrence" class="refrence form-control" value="<?php if(!empty($DRDNDtl)){
											 			echo $DRDNDtl->refrence;}else{ echo lastRefrenceNo('refrence','debitnote_tbl'); }  ?>" >
									 </div>
								 </div>
								 <div class="required item form-group">
									<label class="col-md-3 col-sm-12 col-xs-4" for="comment">Comment</label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<textarea  type="text"  id="comment" name="comment" class="comment form-control" ><?php if(!empty($DRDNDtl)) echo $DRDNDtl->comment;  ?></textarea>
									</div>
								</div>
				     </div>
			    </div>
	   </div>
</div>
<hr>
<div class="bottom-bdr"></div>
<input type="hidden" value="<?php if(!empty($DRDNDtl)){ echo $DRDNDtl->party_billing_state_id; } ?>" id="party_billing_state_id" name="party_billing_state_id">
<input type="hidden" value="<?php if(!empty($DRDNDtl)){  echo $DRDNDtl->sale_company_state_id;  }?>" id="sale_company_state_id" name ="sale_company_state_id">
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		<div class="panel-default tbllHead" <?php if(empty($DRDNDtl)){ ?> style="display:none;" <?php } ?>>
					<h3 class="Material-head">Product Details  <hr></h3>
					<div class="add-credit-new middle-box panel-body label-box " >
					<?php if(!empty($DRDNDtl)){ ?>
								 <div class="col-md-12 input_descr_wrap label-box mobile-view2 row_head">
											 <?php $produtDtl = json_decode($DRDNDtl->productDtl);

											 $discountColumn = false;
											 foreach($produtDtl as $val){
													if( isset($val->after_desc_amt) ){
														 $discountColumn = true;
														 goto end;
													}
											 }
											 end:
								 		 	?>
											<div class="col-md-1 item form-group">
												<label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Material Name</label>
											</div>
											<div class="col-md-2 item form-group">
												<label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>
											</div>
											<div class="col-md-1 item form-group">
												<label class="col-md-12 col-sm-12 col-xs-12" for="HSN/SAC">HSN/SAC</label>
											</div>
											<div class="col-md-1 item form-group">
												<label class="col-md-12 col-sm-12 col-xs-12" for="Quantity">Quantity</label>
											</div>
											<div class="col-md-1 item form-group">
												<label class="col-md-12 col-sm-12 col-xs-12" for="Rate">Rate</label>
											</div>
											<?php
												 if($discountColumn){
														echo    '<div class="col-md-1 item form-group">
																				<label class="col-md-12 col-sm-12 col-xs-12" for="Rate">Disc. Type</label>
																		 </div>
																		 <div class="col-md-1 item form-group">
																				<label class="col-md-12 col-sm-12 col-xs-12" for="Rate">Disc. Amt.</label>
																		 </div>
																		 <div class="col-md-1 item form-group">
																				<label class="col-md-12 col-sm-12 col-xs-12" for="Rate">Amt. After Desc.</label>
																		 </div>';
												 }

											?>
											<div class="col-md-1 item form-group">
												<label class="col-md-12 col-sm-12 col-xs-12" for="Tax">Tax</label>
											</div>
											<div class="col-md-1 item form-group">
												<label class="col-md-12 col-sm-12 col-xs-12" for="UOM">UOM</label>
											</div>
											<div class="col-md-1 item form-group" style="border-right: 1px solid #c1c1c1;">
												<label class="col-md-12 col-sm-12 col-xs-12" for="Amount with Tax">Amount with Tax</label>
											</div>
					        </div>
					<?php if(!empty($DRDNDtl)){
								  $produtDtl = json_decode($DRDNDtl->productDtl);
									foreach($produtDtl as $pDtl){
										$matName = getNameById('material',$pDtl->material_id,'id');
										$uomName = getNameById('uom',$pDtl->UOM,'id'); ?>
						       <div class="add_more_credit_note_row scend-tr mailing-box col-md-12" >
											<div class="item form-group col-md-1 col-sm-12 col-xs-12">
														<div class="col-md-12 col-sm-12 col-xs-12 form-group">
															<input type="hidden" class="itemName form-control"   name="material_id[]" value="<?php echo $pDtl->material_id; ?>">
															<input type="text" class="itemName form-control"  required="required" name="material_name[]" value="<?php echo $matName->material_name; ?>" readonly >
														</div>
											</div>
											<div class="item form-group col-md-2 col-sm-12 col-xs-12">
														<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																<input type="text" name="descr_of_goods[]"  class="form-control col-md-1 goods_descr_section" placeholder="Description Of Goods" value="<?php echo $pDtl->descr_of_goods; ?>" readonly>
														</div>
											</div>
											<div class="item form-group col-md-1 col-sm-12 col-xs-12">
													<div class="col-md-12 col-sm-12 col-xs-12 form-group">
															<input type="text" name="hsnsac[]" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC" value="<?php echo $pDtl->hsnsac; ?>" readonly >
													</div>
											</div>
											<div class="item form-group col-md-1 col-sm-12 col-xs-12">
														<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																<input type="text"  required="required" name="quantity[]" class="form-control col-md-1 year goods_descr_section keyup_event_crnote" placeholder="Quantity" value="<?php echo $pDtl->quantity; ?>" readonly>
														</div>
											</div>
											<div class="item form-group col-md-1 col-sm-12 col-xs-12">
														<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	<input type="text" name="rate[]" class="form-control col-md-1 goods_descr_section keyup_event_crnote" placeholder="Rate" value="<?php echo $pDtl->rate; ?>" readonly>
																	<input type="hidden" name="basic_Amt[]" class="form-control col-md-1 goods_descr_section" placeholder="Rate" value="<?php echo $pDtl->basic_Amt; ?>">
																	<input type="hidden" name="cess_tax_calculation[]" class="form-control col-md-1 goods_descr_section" placeholder="Rate" value="<?= $pDtl->cess_tax_calculation??'' ?>">
								      						<input type="hidden" name="cess[]" class="form-control col-md-1 goods_descr_section" placeholder="Rate" value="<?= $pDtl->cess??'' ?>">
								      						<input type="hidden" name="old_sale_amount[]" class="form-control col-md-1 goods_descr_section" placeholder="Rate" value="<?= $pDtl->old_sale_amount??'' ?>">
														</div>
											</div>
											<?php
									 			if($discountColumn){ ?>
											 <div class="col-md-1 col-sm-12 col-xs-12 form-group">
													<div class="checktr">
														 <input type="text" name="disctype[]" class="form-control col-md-1 goods_descr_section disc_type_cls"  value="<?= ($pDtl->disctype == 'disc_precnt' )?'disc_precnt':'disc_value'; ?>" readonly >
													</div>
											 </div>
											 <div class="col-md-1 col-sm-12 col-xs-12 form-group">
													<div class="checktr">
														 <input type="text" name="discamt[]" class="form-control col-md-1 goods_descr_section added_discount_amt" readonly="" placeholder="Disc Amt" value="<?= $pDtl->discamt ?>">
													</div>
											 </div>
											 <div class="col-md-1 col-sm-12 col-xs-12 form-group">
													<div class="checktr">
														 <input type="text" name="after_desc_amt[]" class="form-control col-md-1 goods_descr_section" readonly="" placeholder="After Disc Amt" value="<?= $pDtl->after_desc_amt ?>">
													</div>
											 </div>
									<?php } ?>
											<div class="item form-group col-md-1 col-sm-12 col-xs-12">
														<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																<input type="text" name="tax[]" class="form-control col-md-1 goods_descr_section tax"   placeholder="Tax" value="<?php echo $pDtl->tax; ?>" readonly>
																<input type="hidden" value="<?php echo $pDtl->added_tax_Row_val; ?>" name="added_tax_Row_val[]" >
														</div>
											</div>
											<div class="item form-group col-md-1 col-sm-12 col-xs-12">
														<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	<input type="text" name="UOM1[]" class="form-control col-md-1 goods_descr_section " readonly value="<?php echo $uomName->uom_quantity; ?>">
																	<input type="hidden" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly value="<?php echo $pDtl->UOM ?>">
														</div>
											</div>
											<div class="item form-group col-md-1 col-sm-12 col-xs-12">
														<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	<input type="text" id="amount"   name="amount[]" class="form-control col-md-1 goods_descr_section AMunt" readonly placeholder="Amount" value="<?php echo $pDtl->amount; ?>" >
														</div>
											</div>
											<button class="btn btn-danger remove_cradd_add_field" type="button"><i class="fa fa-minus"></i></button>
									</div>
					<?php }
						}
				} ?>
			</div>
		</div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		<div class="col-md-12 col-sm-12 col-xs-12 tbllFooter" <?php if(empty($DRDNDtl)){ ?> style="display:none;" <?php } ?>>
				<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right">
						    <div class="col-md-6 col-sm-5 col-xs-6 text-right">
											<span style="font-size:18px;font-weight:bold;">Subtotal  </span>
								</div>
							<?php
							if(!empty($DRDNDtl)){
								$amountDtl = json_decode($DRDNDtl->amountDtl);
								//pre($amountDtl);
							}
							?>
								<div class="col-md-6 col-sm-5 col-xs-6 text-left">
								      <input type="text" value="<?php if(!empty($DRDNDtl)){  echo $amountDtl[0]->subtotal;  }  ?>" name="subtotal[]" class="crnote_subtotal" style="border: none;"readonly>
									  <input type="hidden" value="<?php if(!empty($DRDNDtl)){  echo $amountDtl[0]->subtotal;  }  ?>" id="subTotal_Amt" name="subTotal_Amt">
								</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 text-right charges_amount_row" style="display: none;">
						</div>
				<?php if(!empty($DRDNDtl)){
									$charges = json_decode($DRDNDtl->amountDtl);
									if( $charges[0]->charges ){
										$kia = 0;
										echo '<div class="col-md-12 col-sm-12 col-xs-12 text-right charges_amount_row">';
										foreach($charges[0]->charges as $values){
											?>
												<div class="col-md-6 col-sm-5 col-xs-6 text-right">
													<span style="font-size:18px;font-weight:bold;">Discount</span>
												</div>
												<div class="col-md-6 col-sm-5 col-xs-6 text-left">
												      <input type="text" value="<?= $values->amount ?>" data-disType="<?= $values->type ?>" name="charges_amount[<?= $kia ?>][amount]" class="charges_amount" style="border: none;" readonly>
													  <input type="hidden" value="<?= $values->type ?>" id="charges_amount" name="charges_amount[<?= $kia ?>][type]">
												</div>
										<?php $kia++; }
										echo '</div>';
									}
					 } ?>
			<?php if(!empty($DRDNDtl) && $DRDNDtl->IGST != 0){ ?>
				<div class="col-md-12 col-sm-12 col-xs-12 text-right igstt">
						<div class="col-md-6 col-sm-5 col-xs-6 text-right">
								<span style="font-size:18px;font-weight:bold;">IGST </span>
						</div>
						<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							  <input type="text" value="<?php echo $DRDNDtl->IGST;  ?>" name="total_tax_IGST" class="crnote-total-taxIGST" style="border: none;"readonly>
						</div>
				</div>
			<?php }else if(empty($DRDNDtl)){ ?>
				<div class="col-md-12 col-sm-12 col-xs-12 text-right igstt">
							<div class="col-md-6 col-sm-5 col-xs-6 text-right">
									<span style="font-size:18px;font-weight:bold;">IGST </span>
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
								  <input type="text" value="" name="total_tax_IGST" class="crnote-total-taxIGST" style="border: none;"readonly>
							</div>
				</div>
			<?php  } if(!empty($DRDNDtl) && $DRDNDtl->SGST != 0 && $DRDNDtl->CGST != 0){?>
				<div class="col-md-12 col-sm-12 col-xs-12 text-right sgstt">
						<div class="col-md-6 col-sm-5 col-xs-6 text-right">
								<span style="font-size:18px;font-weight:bold;">SGST </span>
						</div>
						<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							  <input type="text" value="<?php echo $DRDNDtl->SGST; ?>" name="total_tax_SGST" class="crnote-total-taxSGST" style="border: none;"readonly>
						</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 text-right cgstt">
						<div class="col-md-6 col-sm-5 col-xs-6 text-right">
								<span style="font-size:18px;font-weight:bold;">CGST </span>
						</div>
						<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							  <input type="text" value="<?php echo $DRDNDtl->CGST; ?>" name="total_tax_CGST" class="crnote-total-taxCGST" style="border: none;"readonly>
						</div>
				</div>
			<?php }else if(empty($DRDNDtl)){ ?>

				<div class="col-md-12 col-sm-12 col-xs-12 text-right sgstt">
			    <div class="col-md-6 col-sm-5 col-xs-6 text-right">
							<span style="font-size:18px;font-weight:bold;">SGST </span>
					</div>
					<div class="col-md-6 col-sm-5 col-xs-6 text-left">
					      <input type="text" value="<?php  ?>" name="total_tax_SGST" class="crnote-total-taxSGST" style="border: none;"readonly>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 text-right cgstt">
				    <div class="col-md-6 col-sm-5 col-xs-6 text-right">
								<span style="font-size:18px;font-weight:bold;">CGST </span>
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							      <input type="text" value="<?php  ?>" name="total_tax_CGST" class="crnote-total-taxCGST" style="border: none;"readonly>
							</div>
				</div>
			<?php } ?>
				<div class="col-md-12 col-sm-12 col-xs-12 text-right">
				    <div class="col-md-6 col-sm-5 col-xs-6 text-right">
								<span style="font-size:18px;font-weight:bold;">Grand Total  </span>
						</div>
						<div class="col-md-6 col-sm-5 col-xs-6 text-left">
						      <input type="text" value=" <?php if(!empty($DRDNDtl)){  echo $amountDtl[0]->grand_total;  }  ?>" name="grand_total" class="crnote_Total_grandtotal_Val" style="border: none;"readonly>
						</div>
				</div>
		</div>
	</div>
</div>
<hr>
<!--div class="bottom-bdr"></div-->
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
	<div class="form-group">
		<div class="modal-footer">
		<center>

			<button type="reset" class="btn btn-default">Reset</button>
				<?php if((!empty($ledger) && $ledger->save_status !=1) || empty($ledger)){
					//echo '<input type="submit" class="btn btn-warning draftBtn" value="Save as draft">';
				}?>
			<button id="send" type="submit" class="btn btn-warning">Submit</button>
		</center>
			</div>
	</div>
</form>
</div>
