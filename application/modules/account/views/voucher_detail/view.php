					  
			<form>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<input type="hidden" name="id" value="<?php if(!empty($voucher_dtls)) echo $voucher_dtls->id; ?>">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
						
							<div class=" panel-default">
							<?php
							//pre($voucher_dtls);die();
							// $credit_debit_Data = json_decode($voucher_dtls->voucher_detls,true);
							// pre($credit_debit_Data);die();
							?>
								
								<h3 class="Material-head"><strong><?php if(!empty($invoice_detail)) echo $material_names; ?></h3>
								<div>
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
									
										<div class="x_content">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">

												<div id="myTabContent" class="tab-content">
													<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
														<div class="col-md-12 col-sm-12 col-xs-12">
															
																   <div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	   <label scope="row">Voucher Number</label>
																	 <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($voucher_dtls)) echo $voucher_dtls->id; ?></div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Voucher Type</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group">
																	  <?php
																		if(!empty($voucher_dtls)){
																			$get_voucher_type = getNameById('voucher_type',$voucher_dtls->voucher_name,'id');
																			echo $get_voucher_type->voucher_name;
																		} 
																		?></div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	   <label scope="row">Voucher Date</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($voucher_dtls)){
               																	$created_date = date("j F , Y", strtotime($voucher_dtls->voucher_date));  
																				  echo $created_date;
																				  }?>
																	  </div>
																	</div>
																	</div>
																	<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">
																	  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	   <label scope="row">Narration</label>
																	 <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($voucher_dtls)) echo $voucher_dtls->narration; ?></div>
																	</div>
																	
																	</div>
																	
																		 <div class="col-md-12 col-sm-12 col-xs-12">
																    <div class="label-box mobile-view3">			  
																			   <div class="col-md-4 col-sm-12 col-xs-12 form-group label" style="border-left: 1px solid #c1c1c1;">Ledger Name</div>
																			   <div class="col-md-4 col-sm-12 col-xs-12 form-group label">Credited Amount</div>
																			   <div class="col-md-4 col-sm-12 col-xs-12 form-group label">Debited Amount</div>
																			  
																			   
																     </div>
																			
																			<?php 
																			if(!empty($voucher_dtls)){
																					$credit_debit_amount = json_decode($voucher_dtls->credit_debit_party_dtl);
																					
																					
																					foreach($credit_debit_amount as $cr_dr_amount){
																					
																				?>		
																			<div class="row-padding col-container mobile-view view-page-mobile-view mailing-box">
																			<div class="col-md-4 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Ladger Name</label><div><?php
																				$credit_party = getNameById('ledger',$cr_dr_amount->credit_debit_party_dtl,'id');
																				echo $credit_party->name;
																			?></div></div>
																			<div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Credited Amount</label><div><?php if($cr_dr_amount->credit_1 != ''){echo $cr_dr_amount->credit_1;}else{ echo 'N/A';}?></div></div>
																			<div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Debited Amount</label><div><?php if($cr_dr_amount->debit_1 != ''){ echo $cr_dr_amount->debit_1;}else{echo 'N/A';}?></div></div>
																			
																			</div>
																			<?php }                                     
																			}?>
																			
																		</div>
																		
																	
																	
																
																
																	
																
														</div>
													</div>
													
													
												</div>
											</div>
										</div>
																	
								</div>
							</div>
						
					</div>
	
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<hr>
				
					<div class="form-group">
						<div>
						<div class="col-md-12 col-xs-12">
						<center>
						<!--a href="<?php// echo base_url(); ?>account/create_pdf/<?php //echo $invoice_detail->id; ?>"><button class="btn btn-default">Generate PDF</button></a-->
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<!--button type="reset" class="btn btn-default">Reset</button>
							<input type="submit" class="btn btn-warning" value="Submit"-->
						 </center>
						</div>
						</div>
					</div>
				
			</div>
	</form>		