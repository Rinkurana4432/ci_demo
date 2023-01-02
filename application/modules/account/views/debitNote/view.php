<div class=" form-group">

		<div class=" form-group">
			<div class=" form-group">
							<div class="panel panel-default">
							<?php
							//pre($DNSalereturn_detail);
							setlocale(LC_MONETARY, 'en_IN');
							?>
							<?php
							if($DNSalereturn_detail->debitAMt > 0 ){
								echo '<h3 class="Material-head">Debit Note No : '.$DNSalereturn_detail->debitNoteNo.'</strong><hr></h3>';
							}else{
							?>
							     <h3 class="Material-head">Purchase Return No : <?php echo $DNSalereturn_detail->debitNoteNo; ?> </strong><hr></h3>
							<?php } ?>
								<div class="panel-body">
									<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">
										<div class="col-md-12 col-sm-12 col-xs-12 form-group">
										       <label>Date</label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group">
											   <?php echo date("j F , Y", strtotime($DNSalereturn_detail->date)); ?>
												</div>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12 form-group">
										       <label>Supplier Name</label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php
												if(!empty($DNSalereturn_detail)){
														$supplier_id = getNameById('ledger',$DNSalereturn_detail->supplier_id,'id');
														 echo $supplier_id->name;
												}

											   ?></div>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12 form-group">
										       <label>Supplier Email</label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($DNSalereturn_detail)) echo $DNSalereturn_detail->supplier_email; ?></div>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12 form-group">
										       <label>Supplier GST No</label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php 
											    $ledgerdata = getNameById('ledger',$DNSalereturn_detail->supplier_id,'id');
											           $ledgerdata =  json_decode($ledgerdata->mailing_address);
													   
											   if(!empty($$ledgerdata[0]->gstin_no)) echo $ledgerdata[0]->gstin_no; ?></div>
										</div>


									</div>
									<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">
										<div class="col-md-12 col-sm-12 col-xs-12 form-group">
										       <label>Buyer </label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php
												  if(!empty($DNSalereturn_detail)){
													  $Buyer_ledger_name = getNameById('ledger',$DNSalereturn_detail->buyerID,'id');
													 echo $Buyer_ledger_name->name;
												  }
											?></div>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12 form-group">
											   <label>Buyer GST No</label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php echo $DNSalereturn_detail->party_billing_state_id; ?></div>
										</div>
									<?php
										if($DNSalereturn_detail->debitAMt != 0 ){
										?>
										<div class="col-md-12 col-sm-12 col-xs-12 form-group">
											   <label>Debit Amount</label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php echo $DNSalereturn_detail->debitAMt; ?></div>
										</div>

										<?php } ?>

										<div class="col-md-12 col-sm-12 col-xs-12 form-group">
											   <label>Purchase No</label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php echo getSingleAndWhere('invoice_num','purchase_bill',['id' => $DNSalereturn_detail->PurchaseBill_no ]); ?></div>
										</div>

									</div>

									<div class="col-md-12 col-sm-12 col-xs-12">

										<div class="x_content">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">
<?php
	if($DNSalereturn_detail->debitAMt == 0 ){
	?>
	<div id="myTabContent" class="tab-content">
		<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
			<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped">
					<tbody>

						<div class="table-responsive">
						<table class="table table-striped">
						 <div class="label-box mobile-view3">
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label" style="border-left: 1px solid #c1c1c1;">Descriptions of <br> Goods and Services</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">HSN/SAC</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Quantity</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Rate</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Taxable Amt.</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Discount Type</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Discount Amount</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">After Discount</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Tax</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">UOM</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Amount with Tax</div>
						 </div>


						  <?php
							$invoice_matrial_details = json_decode($DNSalereturn_detail->productDtl,true);
							$subtotal_all_invoice =0;
							foreach($invoice_matrial_details as $invoice_Data){

								$meterial_data = getNameById('material',$invoice_Data['material_id'],'id');
							?>
							<div class="row-padding col-container mobile-view view-page-mobile-view">
								  <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1 !important;">
								  <label>Descriptions of <br> Goods and Services</label>
								  <?php echo '<span><b>'.$meterial_data->material_name.'</b><br/></span>'.substr($invoice_Data['descr_of_goods'], 0, 50);?></div>

								  <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>HSN/SAC</label><?php echo $invoice_Data['hsnsac']; ?></div>
								 <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Quantity</label><?php echo $invoice_Data['quantity']; ?></div>
								  <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Rate</label><?php echo $invoice_Data['rate']; ?></div>
								  <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Taxable Amt.</label><?php echo $taxable_amt = $invoice_Data['quantity'] * $invoice_Data['rate']; ?></div>
								  <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Discount Type</label><?php
								 if($invoice_Data['disctype'] == 'disc_precnt'){
										echo 'Percentage ( '. $invoice_Data['discamt']. ' % )';
									 }elseif($invoice_Data['disctype'] == 'disc_value'){
										echo 'Discount Value ( '. $invoice_Data['discamt'] .' )';
									 }else{
										 echo 'N/A';
									 }

								 ?></div>
								  <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Discount Amount</label><?php

								 if($invoice_Data['discamt'] != ''){
											if($invoice_Data['disctype'] == 'disc_precnt'){
												$basic_amt = $invoice_Data['quantity']* $invoice_Data['rate'];
												$total_amt_in_percent = $basic_amt * $invoice_Data['discamt']/100;
												echo $total_amt_in_percent;
											}else{
												echo $invoice_Data['discamt'];
											}
										} else {
											echo 'N/A';
										}
									?></div>

								   <div class="col-md-1 col-sm-12 col-xs-12 form-group">
								    <label>After Discount</label>
								  <?php

										if($invoice_Data['disctype'] !=''){
											if($invoice_Data['disctype'] == 'disc_precnt'){
											$basic_amt = $invoice_Data['quantity'] * $invoice_Data['rate'];
											$total_amt_in_percent = $basic_amt * $invoice_Data['discamt']/100;
											echo $taxable_amt - $total_amt_in_percent;
										}else{
											echo $taxable_amt - $invoice_Data['discamt'];
										}
										}else{
											echo 'N/A';
										}
											$ww =  getNameById('uom', $invoice_Data['UOM'],'id');
											$uom = !empty($ww)?$ww->ugc_code:'';


									?>
							  </div>
							  <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Tax</label><?php echo $invoice_Data['tax']; ?></div>
							 <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>UOM</label><?php echo $uom; ?></div>
								 <?php
									$subtotal_invoice_amt = $invoice_Data['quantity'] * $invoice_Data['rate'];
									 $subtotal_all_invoice 	+= $subtotal_invoice_amt;
									//pre($invoice_Data);
								 ?>
								  <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Amount with Tax</label><?php
								  if($invoice_Data['disctype'] == ''){
										echo money_format('%!i',$invoice_Data['amount']);
								 }else{
									 echo  $invoice_Data['amount_with_tax_after_disco'];
									 }?>
								</div>
							</div>
								<?php  } ?>



						  </table>
						  </div>
						</tr>

					 </tbody>
				</table>

				<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
						<div class="col-md-12 col-sm-5 col-xs-12 text-right">
							<div class="col-md-6 col-sm-5 col-xs-6 ">
								Total :
							</div>
							<div class="col-md-6 text-left">
								<?php

									 $amount_details = json_decode($DNSalereturn_detail->amountDtl,true);

										$total_add = $amount_details[0]['subtotal'];
									echo money_format('%!i',$total_add);
								?>
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 ">
								Tax :
							</div>
								<div class="col-md-6 text-left">
									 <?php
										if(!empty($data_charges_json)){
											$charges_tax = $charges_total_tax_outside;
											}else{
												$charges_tax  = 0;
											}
											$tax_total3 = $amount_details[0]['total_tax'];


										echo money_format('%!i',$tax_total3);
										?>
								</div>

									<div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2">
									<div class="col-md-6 col-sm-5 col-xs-6 form-group">
										Grand Total :
										</div>
										<div class="col-md-6 text-left form-group"><?php

											echo money_format('%!i',$amount_details[0]['grand_total']);
											?>
										</div>
									</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
<?php } ?>
	</div>
	</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<div class="form-group">
						<div class="modal-footer">

							<button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
							<!--button type="reset" class="btn btn-default">Reset</button>
							<input type="submit" class="btn btn-warning" value="Submit"-->
							</center>
						</div>
					</div>

			</div>
									</div>

								</div>

							</div>

						</div>

					</div>

			</div>
