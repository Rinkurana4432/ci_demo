		<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/save_creditNote" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
		<?php
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

		?>
		<input type="hidden" name="id" value="<?php if(!empty($CrCNDtl)) echo $CrCNDtl->id; ?>" id="creditID">
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		     <h3 class="Material-head">Credit Note  <hr></h3>
		     <div class="col-md-6 col-xs-12 col-sm-6 vertical-border">
			         <div class="panel-default">
						<div class="panel-body">
							<div class="item form-group">
								<label class=" col-md-3 col-sm-12 col-xs-12" for="crditNoteNo">Credit Note Number <span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input id="crnote_number" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($CrCNDtl)) echo $CrCNDtl->crditNoteNo;  ?>" name="crditNoteNo" placeholder="005" required="required" >
								</div>
							</div>
							<div class="item form-group">
								<label class=" col-md-3 col-sm-12 col-xs-12" for="date">Credit Note Date</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="cr_date" class="form-control col-md-7 col-xs-12" name="date"  value="<?php if(!empty($CrCNDtl)) echo date("d-m-Y", strtotime($CrCNDtl->date));
										if(empty($CrCNDtl)){ echo date('d-m-Y');} ?>" Placeholder="Credit Note Date" />

								</div>
							</div>
							<div class="required item form-group">
								<label class="col-md-3 col-sm-12 col-xs-4" for="parent_ledger">Customer</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
								<input type="hidden" value="<?php echo $this->companyGroupId; ?>" id="company_login_id">
								<select class="itemName form-control selectAjaxOption select2 select_customer_dataOnchangeCreditNote"  required="required" name="customer_id" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $this->companyGroupId; ?> AND created_by_cid != 0 AND activ_status = 1 AND 	account_group_id = 54)"  width="100%" onchange="getcustomer_invoice(event,this);"> 		<option value="">Select</option>
											<?php
												if(!empty($CrCNDtl)){
													$party_name = getNameById('ledger',$CrCNDtl->customer_id,'id');
													echo '<option value="'.$party_name->id.'" selected>'.$party_name->name.'</option>';
												}
											?>
										</select>
								</div>
							</div>
							<div class="required item form-group">
								<label class="col-md-3 col-sm-12 col-xs-4" for="custmer_email">Email</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" value="<?php if(!empty($CrCNDtl)) echo $CrCNDtl->custmer_email;  ?>" id="custmer_email" name="custmer_email" class="itemName form-control" >
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
							<label class=" col-md-3 col-sm-12 col-xs-12" for="invoice_no">Invoice No </label>
						<div class="col-md-6 col-sm-12 col-xs-12">
								<select class="itemName form-control selectAjaxOption select2 invoiceIdSelect get_not_paid_INvoice"  name="invoice_no"  width="100%">
								<option value="">Select</option>
								<?php
									if(!empty($CrCNDtl)){
										$invoiceID = getNameById('invoice',$CrCNDtl->invoice_no,'id');
										//pre($invoiceID->invoice_num);
										echo '<option value="'.$CrCNDtl->invoice_no.'" selected>'.$invoiceID->invoice_num.'</option>';
									}
								?>
								</select>
							</div>
						</div>
						<input type="hidden" value="1" name="saleReturn_CN_ornot">
						<div class="item form-group">
								<label class=" col-md-3 col-sm-12 col-xs-12" for="ledgerID">Ledger <span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12 ">
									<select class="itemName form-control selectAjaxOption select2 select_saleCompGSTNO" required="required" name="ledgerID" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid = 0 AND activ_status = 1)"  width="100%">
										<option value="">Select</option>
										<?php
											if(!empty($CrCNDtl)){
												$saleLedgerID = getNameById('ledger',$CrCNDtl->ledgerID,'id');
												echo '<option value="'.$saleLedgerID->id.'" selected>'.$saleLedgerID->name.'</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="item form-group">
								<label class=" col-md-3 col-sm-12 col-xs-12" for="ledgerID">Credit Amount <span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12 ">
									<input type="text" id="crAmt" class="form-control col-md-7 col-xs-12" name="creditAMt"  value="<?php 	if(!empty($CrCNDtl)){ echo $CrCNDtl->creditAMt;} ?>" Placeholder="Credit Note Amount" onkeypress="return float_validation(event, this.value)" />
								</div>

							</div>
							<div class="required item form-group">
							   <label class="col-md-3 col-sm-12 col-xs-4" for="comment">Comment</label>
							   <div class="col-md-6 col-sm-12 col-xs-12">
								   <textarea  type="text"  id="comment" name="comment" class="comment form-control" ><?php if(!empty($CrCNDtl)) echo $CrCNDtl->comment;  ?></textarea>
							   </div>
						   </div>
					</div>
				</div>
			</div>
	</div>
<hr>

<div class="bottom-bdr"></div>
<input type="hidden" value="<?php if(!empty($CrCNDtl)){ echo $CrCNDtl->party_billing_state_id; } ?>" id="party_billing_state_id" name="party_billing_state_id">
<input type="hidden" value="<?php if(!empty($CrCNDtl)){  echo $CrCNDtl->sale_company_state_id;  }?>" id="sale_company_state_id" name ="sale_company_state_id">


		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
			<div class="form-group">
				<div class="modal-footer">
				<center>

					<button type="reset" class="btn btn-default">Reset</button>
						<?php if((!empty($ledger) && $ledger->save_status !=1) || empty($ledger)){
							//echo '<input type="submit" class="btn btn-warning draftBtn" value="Save as draft">';
						}?>
					<button id="send" type="submit" class="btn btn-warning add_edit_account">Submit</button>
				</center>
					</div>
			</div>
		</form>
	</div>
