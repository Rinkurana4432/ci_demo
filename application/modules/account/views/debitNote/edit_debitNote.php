		<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/save_debitNote" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
		<?php
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

		?>
		<input type="hidden" name="id" value="<?php if(!empty($DRDNDtl)) echo $DRDNDtl->id; ?>" id="debitID">
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		     <h3 class="Material-head">Debit Note<hr></h3>
		     <div class="col-md-6 col-xs-12 col-sm-6 vertical-border">
			         <div class="panel-default">
						<div class="panel-body">
							<div class="item form-group">
								<label class=" col-md-3 col-sm-12 col-xs-12" for="debitNoteNo">Debit Note Number <span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input id="crnote_number" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($DRDNDtl)){ echo $DRDNDtl->debitNoteNo;}else{
										
										$p_Data = getDbitcrditNoteNumber('debitnote_tbl',$this->companyGroupId ,'created_by_cid',1);
										$purchase_bill_no = $p_Data->id + 1;
										echo sprintf("%04s", $purchase_bill_no);
										
										}  ?>" name="debitNoteNo" placeholder="005" required="required" >
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
								<select class="itemName form-control selectAjaxOption select2 select_supplier_dataOnchangedebitNote"  required="required" name="supplier_id" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $this->companyGroupId; ?> AND created_by_cid != 0 AND activ_status = 1 AND 	account_group_id = 55)"  width="100%" onchange="getcustomer_purchaseBill(event,this);">
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

							<!--div class="item form-group">
								<label class=" col-md-3 col-sm-12 col-xs-12" for="open_bal">Customer GST No</label>
								<div class="col-md-6 col-sm-12 col-xs-12 ">
									<select  class="itemName form-control customer_gstno" id="cust_gstID"  name="cgstno">
									<option value="">Select Customer GSTNo</option>
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
							<label class=" col-md-3 col-sm-12 col-xs-12" for="invoice_no">Purchase Bill No </label>
						<div class="col-md-6 col-sm-12 col-xs-12">
								<select class="itemName form-control selectAjaxOption select2 PurchaseIdSelect get_not_paid_PurchaseBill"   name="PurchaseBill_no"  width="100%">
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
						<input type="hidden" value="1" name="PurchaseReturn_DN_ornot">
						<div class="item form-group">
								<label class=" col-md-3 col-sm-12 col-xs-12" for="ledgerID">Buyer <span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12 ">
									<select class="itemName form-control selectAjaxOption select2 selectBuyerGSTno" required="required" name="buyerID" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid = 0 AND activ_status = 1)"  width="100%">
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
						<div class="item form-group">
								<label class=" col-md-3 col-sm-12 col-xs-12" for="ledgerID">Debit Amount <span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12 ">
									<input type="text" id="crAmt" class="form-control col-md-7 col-xs-12" name="debitAMt"  value="<?php 	if(!empty($DRDNDtl)){ echo $DRDNDtl->debitAMt;} ?>" Placeholder="Debit Note Amount" onkeypress="return float_validation(event, this.value)" />
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
