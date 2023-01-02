	<?php if($_SESSION['loggedInUser']->role != 2){ ?>						  
			
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<input type="hidden" name="id" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->id; ?>">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<div class="panel panel-default">
							<?php
							$material_id_datas = json_decode($invoice_detail->descr_of_goods,true);
							
								$material_names = '';
									foreach($material_id_datas  as $matrial_new_id){
										$material_id_get = $matrial_new_id['material_id'];
										$material_name = ($material_id_get!=0)?(getNameById('material',$material_id_get,'id')->material_name):'';
										$material_names .= $material_name.',';
									
									}
							?>
								<div class="panel-heading"><h3 class="panel-title"><strong><?php if(!empty($invoice_detail)) echo $material_names; ?> </strong></h3></div>
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
																	  <th scope="row">Invoice Number</th>
																	  <td><?php if(!empty($invoice_detail)) echo $invoice_detail->id; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Invoice Date</th>
																	  <td><?php if(!empty($invoice_detail)) echo $invoice_detail->v_date; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Buyer Order number</th>
																	  <td><?php if(!empty($invoice_detail)) echo $invoice_detail->buyer_order_no; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Dispatch Document Number</th>
																	  <td><?php if(!empty($invoice_detail)) echo $invoice_detail->dispatch_document_no ; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Party</th>
																	  <td><?php if(!empty($invoice_detail)) echo $invoice_detail->party_name; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Transport</th>
																	  <td><?php if(!empty($invoice_detail)) echo $invoice_detail->transport; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Transport Driver Phone Number</th>
																	  <td><?php if(!empty($invoice_detail)) echo $invoice_detail->transport_driver_pno; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Terms of Delivery</th>
																	  <td><?php if(!empty($invoice_detail)) echo $invoice_detail->terms_of_delivery; ?></td>
																	</tr>
																	<tr>
																	  <th scope="row">Pan</th>
																	  <td><?php if(!empty($invoice_detail)) echo $invoice_detail->pan; ?></td>
																	</tr>
																	<table class="table table-striped">
																
																	 
																	   <tr>
																		   <th>Matrial Name</th>
																		   <th>Descriptions</th>
																		   <th>HSN/SAC Code</th>
																		   <th>Quantity</th>
																			<th>Rate</th>																		  
																			<th>Tax</th>
																		   <th>UOM</th>
																		   <th>Amount with Tax</th>
																	   </tr>
																	  <?php
																		$invoice_matrial_details = json_decode($invoice_detail->descr_of_goods,true);
																		foreach($invoice_matrial_details as $invoice_Data){  
																			$meterial_data = getNameById('material',$invoice_Data['material_id'],'id');
																		?>
																			 <tr>
																			 <td><?php echo $meterial_data->material_name; ?></td>
																			 <td><?php echo $invoice_Data['descr_of_goods']; ?></td>
																			 <td><?php echo $invoice_Data['hsnsac']; ?></td>
																			 <td><?php echo $invoice_Data['quantity']; ?></td>
																			 <td><?php echo $invoice_Data['rate']; ?></td>
																			 <td><?php echo $invoice_Data['tax']; ?></td>
																			 <td><?php echo $invoice_Data['UOM']; ?></td>
																			 <td><?php echo $invoice_Data['amount']; ?></td>
																		</tr>
																<?php } ?>
																		<tr>
																        <td></td>
																        <td></td>
																        <td></td>
																        <td></td>
																        <td></td>
																        <td></td>
																        <td><b>Total</b></td>
																		<?php 
																		 $amount_details = json_decode($invoice_detail->invoice_total_with_tax,true);
																			
																		?>
																        <td><b><?php echo $amount_details[0]['total']; ?></b></td>
																		
																	  </tr>
																	  <tr>
																        <td></td>
																        <td></td>
																        <td></td>
																        <td></td>
																        <td></td>
																        <td></td>
																        <td><b>Tax</b></td>
																		
																        <td><b><?php echo $amount_details[0]['tax']; ?></b></td>
																		
																	  </tr>
																	   <tr>
																        <td></td>
																        <td></td>
																        <td></td>
																        <td></td>
																        <td></td>
																        <td></td>
																        <td><b>Grand Total</b></td>
																		
																        <td><b><?php echo $amount_details[0]['invoice_total_with_tax']; ?></b></td>
																		
																	  </tr>
																	  
																	  </table>
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
		<?php } ?>	
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<div class="ln_solid"></div>
				
					<div class="form-group">
						<div class="modal-footer">
						<a href="<?php echo base_url(); ?>account/create_pdf/<?php echo $invoice_detail->id; ?>"><button class="btn btn-default">Generate PDF</button></a>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<!--button type="reset" class="btn btn-default">Reset</button>
							<input type="submit" class="btn btn-warning" value="Submit"-->
						</div>
					</div>
				
			</div>
			