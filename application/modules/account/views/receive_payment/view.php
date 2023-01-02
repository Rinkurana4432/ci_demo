					  
			<form>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<input type="hidden" name="id" value="<?php if(!empty($payment_dtl)) echo $payment_dtl->id; ?>">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<div class=" panel-default">
							
								<div class="panel-heading"><h3 class="panel-title">
								<strong><?php //if(!empty($payment_dtl)) echo $material_names; ?> </strong></h3></div>
								<div class="panel-body">
									<div class="col-md-6 col-sm-6 col-xs-12 form-group">
										<!--div class="item form-group">													
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Buyer's Number</label>														
											<div class="col-md-6 col-sm-6 col-xs-12">														
												<p></p>												
											</div>												
										</div-->
									</div>
									<!--div class="col-md-6 col-sm-6 col-xs-12 form-group">
										<div class="item form-group">													
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>														
											<div class="col-md-6 col-sm-6 col-xs-12">														
												<p><?php //if(!empty($ledger)) echo $ledger->email; ?></p>													
											</div>												
										</div>
									</div-->
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="x_content">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">

												<div id="myTabContent" class="tab-content">
													<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
														<div class="col-md-12 col-sm-12 col-xs-12">
															<table class="table table-striped">
																<tbody>
																<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Receipt Number</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($payment_dtl)) echo $payment_dtl->id; ?></div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Party Name</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group">
																	  <?php
																		if(!empty($payment_dtl)){
																			$party_name = getNameById('ledger',$payment_dtl->party_id,'id');
																			echo $party_name->name;
																		} 
																		?></div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Party Email</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($payment_dtl)){
               																	echo $payment_dtl->party_email;
																				  }?>
																	  </div>
																	</div>
																	</div>
																	<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	 <label scope="row">Paid Amount</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($payment_dtl)){
               																	echo $payment_dtl->added_amount;
																				  }?>
																	  </div>
																	</div>
																	<?php
																		if(!empty($payment_dtl->amount_to_credit)){
																	?>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	 <label scope="row">Advanced Amount</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($payment_dtl)){
               																	echo $payment_dtl->amount_to_credit;
																				  }?>
																	  </div>
																	</div>
																		<?php }else{ ?>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	 <label scope="row">Total Amount</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($payment_dtl)){
																			echo $payment_dtl->added_amount + $payment_dtl->balance;
																		}?>
																	  </div>
																	</div>
																		<?php } ?>
																	</div>
																	
																	<?php
																		if(!empty($payment_dtl->payment_detail)){
																	?>
<hr>																	
<div class="bottom-bdr"></div>											 
													 
													<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="label-box mobile-view3">			  
																			   <div class="col-md-2 col-sm-12 col-xs-12 form-group label" style="border-left: 1px solid #c1c1c1;">Invoice ID</div>
																			   <div class="col-md-2 col-sm-12 col-xs-12 form-group label">Invoice No.</div>
																			   <div class="col-md-2 col-sm-12 col-xs-12 form-group label">Open Balance</div>
																			   <div class="col-md-2 col-sm-12 col-xs-12 form-group label">Credited Amount</div>
																			   <div class="col-md-2 col-sm-12 col-xs-12 form-group label">Balance</div>
																			   
																     </div>
													
													<?php 
												
														if(!empty($payment_dtl)){
														
																$receipt_details = json_decode($payment_dtl->payment_detail);
																foreach($receipt_details as $receipt_detail){
																   $invc_num =	getNameById('invoice',$receipt_detail->invoice_id,'id');
																
															?>		
															<div class="row-padding col-container mobile-view view-page-mobile-view">
																<div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><?php echo $receipt_detail->invoice_id;?></div>
																<div class="col-md-2 col-sm-12 col-xs-12 form-group"><?php if($invc_num->invoice_num != ''){echo $invc_num->invoice_num;}else{ echo 'N/A';}?></div>
																<div class="col-md-2 col-sm-12 col-xs-12 form-group"><?php echo number_format($receipt_detail->open_balance);?></div>
																
																 <div class="col-md-2 col-sm-12 col-xs-12 form-group">
																 <?php
																
																	if($receipt_detail->open_balance < $receipt_detail->payment_amount){
																		echo $credit_amt = $receipt_detail->payment_amount -  $receipt_detail->open_balance;
																	}else{
																		echo $credit_amt = '0.00';
																	}
																?>
																  </div>
																 <div class="col-md-2 col-sm-12 col-xs-12 form-group"> 
																	<?php
																	if($receipt_detail->open_balance >= $receipt_detail->payment_amount){
																		$balance = $receipt_detail->payment_amount - $receipt_detail->open_balance;
																		echo abs($balance);
																	}else{
																		echo abs($balance);
																	}
																	?>
																</div>
														
														</div>
													<?php
																						
													}
												}	
											}		
											?>
											</div>	
										
										
<hr>																	
<div class="bottom-bdr"></div>										
										
										                            <div class="col-md-8 col-xs-12 label-left">
																	  <label scope="row">Narations</label>
																	  <div class="col-md-8 col-sm-12 col-xs-6 form-group"><?php if(!empty($payment_dtl)) echo $payment_dtl->narration; ?></div>
																	</div>
																
																
																	
																 </tbody>
															</table>
														</div>
													</div>
													
													
													
													<!--div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab2">
														<div class="col-md-6 col-sm-6 col-xs-12">
															<table class="table table-striped">
																<tbody>
																	<tr>
																	  <th scope="row">Account Name</th>
																	  <td><?php// if(!empty($ledger)) echo $ledger->mailing_name; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Account Number</th>
																	  <td><?php// if(!empty($ledger)) echo $ledger->mailing_address; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Bank Name</th>
																	  <td><?php //if(!empty($ledger)) echo $ledger->mailing_city; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">IFSC Code</th>
																	  <td><?php //if(!empty($ledger)) echo $ledger->mailing_state; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">MICR Code</th>
																	  <td><?php //if(!empty($ledger)) echo $ledger->mailing_pincode; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Bank Branch</th>
																	  <td><?php //if(!empty($ledger)) echo $ledger->mailing_country; ?></td>
																	</tr>
																 </tbody>
															</table>
														</div>
													</div>
													
													<div role="tabpanel" class="tab-pane fade active in" id="tab_content4" aria-labelledby="profile-tab3">
														<div class="col-md-6 col-sm-6 col-xs-12">
															<table class="table table-striped">
																<tbody>
																	<tr>
																	  <th scope="row">Website</th>
																	  <td><?php //if(!empty($ledger)) echo $ledger->website; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Registration Type</th>
																	  <td><?php //if(!empty($ledger)) echo $ledger->registration_type; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">GSTIN</th>
																	  <td><?php //if(!empty($ledger)) echo $ledger->gstin; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Company PAN</th>
																	  <td><?php //if(!empty($ledger)) echo $ledger->pan; ?></td>
																	</tr>
																 </tbody>
															</table>
														</div>
													</div-->
													
												</div>
											</div>
										</div>
									</div>									
								</div>
							</div>
						</div>
					</div>
	
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">

				
					<div class="form-group">
						<div class="modal-footer">
						<!--a href="<?php// echo base_url(); ?>account/create_pdf/<?php //echo $invoice_detail->id; ?>"><button class="btn btn-default">Generate PDF</button></a-->
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<!--button type="reset" class="btn btn-default">Reset</button>
							<input type="submit" class="btn btn-warning" value="Submit"-->
						</div>
					</div>
				
			</div>
	</form>		