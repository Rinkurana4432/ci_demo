						  
			<form>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<input type="hidden" name="id" value="<?php if(!empty($payment_to_dtl)) echo $payment_to_dtl->id; ?>">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<div class="panel panel-default">
							
								<div class="panel-heading"><h3 class="panel-title">
								<strong><?php //if(!empty($payment_to_dtl)) echo $material_names; ?> </strong></h3></div>
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
																	<tr>
																	  <th scope="row">Bill Number</th>
																	  <td><?php if(!empty($payment_to_dtl)) echo $payment_to_dtl->id; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Party Name</th>
																	  <td>
																	  <?php
																		if(!empty($payment_to_dtl)){
																			$name = getNameById('supplier',$payment_to_dtl->party_id,'id');
																			echo $name->name;
																		} 
																		?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Party Email</th>
																	  <td><?php if(!empty($payment_to_dtl)){
               																	echo $payment_to_dtl->party_email;
																				  }?>
																	  </td>
																	</tr>
																	<tr>
																	 <th scope="row">Paid Amount</th>
																	  <td><?php if(!empty($payment_to_dtl)){
               																	echo $payment_to_dtl->added_amount;
																				  }?>
																	  </td>
																	</tr>
																	<tr>
																	 <th scope="row">Total Amount</th>
																	  <td><?php if(!empty($payment_to_dtl)){
               																	echo $payment_to_dtl->total_amount;
																				  }?>
																	  </td>
																	</tr>
																	<tr>
																	 <th scope="row">Credited Amount</th>
																	  <td><?php if(!empty($payment_to_dtl)){
               																	echo $payment_to_dtl->amount_to_credit;
																				  }?>
																	  </td>
																	</tr>
																	<tr>
																	<td>
																	 <table class="fixed data table table-striped no-margin">
																		 <thead>
																		 <tbody>
																			 <tr>
																				<th>Bill ID</th>
																				<th>Open Balance</th>
																				<th>Payment Amount</th>
																				<th>Balance</th>
																				
																			</tr>
																			<?php 
																			if(!empty($payment_to_dtl)){
																					$bill_details = json_decode($payment_to_dtl->payment_detail);
																					foreach($bill_details as $bill_detail){
																				?>		
																				<tr>
																					<td><?php echo $bill_detail->bill_id;?></td>
																					<td><?php echo $bill_detail->open_balance;?></td>
																					<td><?php echo $bill_detail->payment_amount;?></td>
																					<td>
																					<?php
																					$balance = $bill_detail->payment_amount - $bill_detail->open_balance;
																					echo abs($balance);			
																					?>
																					
																					</td>
																			
																			</tr>
																			<?php }                                     
																			}?>
																			
																		</tbody>
																		</thead>
																	</table>
																	</td>
																	</tr>
																	
																	
																	
																	
																	<tr>
																	  <th scope="row">Narations</th>
																	  <td><?php if(!empty($payment_to_dtl)) echo $payment_to_dtl->narration; ?></td>
																	</tr>
																
																
																	
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
				<div class="ln_solid"></div>
				
					<div class="form-group">
						<div class="modal-footer">
						<!--a href="<?php// echo base_url(); ?>account/create_pdf/<?php //echo $invoice_detail->id; ?>"><button class="btn btn-default">Generate PDF</button></a-->
							<button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
							<!--button type="reset" class="btn btn-default">Reset</button>
							<input type="submit" class="btn btn-warning" value="Submit"-->
						</div>
					</div>
				
			</div>
	</form>		