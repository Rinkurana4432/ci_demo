	<?php 
	setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
	if($_SESSION['loggedInUser']->role != 2){ ?>						  
			
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<input type="hidden" name="id" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->id; ?>">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group" style="padding:0px;">	
					
							<div class=" panel-default">
							<?php
						
							$material_id_datas = json_decode($invoice_detail->descr_of_goods,true);
							
								$material_names = '';
									foreach($material_id_datas  as $matrial_new_id){
										$material_id_get = $matrial_new_id['material_id'];
										$material_name = ($material_id_get!=0)?(getNameById('material',$material_id_get,'id')->material_name):'';
										$material_names .= $material_name.',';
									
									}
									$party_name = getNameById('ledger',$invoice_detail->party_name,'id');
									
							?>
								
								<h3 class="Material-head"><?php if(!empty($invoice_detail)) echo $party_name->name; ?> <hr></h3>
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
															<table class="table table-striped">
																<tbody>
																 <div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">
																   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Party Email :</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail)) echo $invoice_detail->email; ?></div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Invoice Number :</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail)) echo $invoice_detail->invoice_num; ?></div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Invoice Date :</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail)) echo date("j F , Y", strtotime($invoice_detail->date_time_of_invoice_issue)); ?></div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Buyer Order number :</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail)) echo $invoice_detail->buyer_order_no; ?></div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Dispatch Document Number :</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail)) echo $invoice_detail->dispatch_document_no ; ?></div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Materials :</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php
																	  if(!empty($invoice_detail)){
																		  // $party_name = getNameById('ledger',$invoice_detail->party_name,'id');
																		 echo $material_names;
																	  }
																		?></div>
																	</div>
																	
																	</div>
																	<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Sale Ledger :</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php
																	  if(!empty($invoice_detail)){
																		  $sale_ledger_name = getNameById('ledger',$invoice_detail->sale_ledger,'id');
																		 echo $sale_ledger_name->name;
																	  }
																		?></div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Transport :</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail)) echo $invoice_detail->transport; ?></div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Vehicle Number :</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php  if(!empty($invoice_detail)) echo $invoice_detail->vehicle_reg_no; ?></div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Transport Driver Phone Number :</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail)) echo $invoice_detail->transport_driver_pno; ?></div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Terms of Delivery :</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail)) echo $invoice_detail->terms_of_delivery; ?></div>
																	</div>
																	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
																	  <label scope="row">Pan :</label>
																	  <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail)) echo $invoice_detail->pan; ?></div>
																	</div>
																	
																	
																	
																	
																	</div>
																	<table class="table table-striped">
																
																	 
																	   <div class="label-box mobile-view3">
																		   <div class="col-md-2 col-sm-12 col-xs-12 form-group label" style="border-left: 1px solid #c1c1c1;">Matrial Name</div>
																		   <div class="col-md-2 col-sm-12 col-xs-12 form-group label">Descriptions</div>
																		   <div class="col-md-2 col-sm-12 col-xs-12 form-group label">HSN/SAC Code</div>
																		   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Quantity</div>
																		   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Rate</div>
																		   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Tax</div>
																		   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">UOM</div>
																		   <div class="col-md-2 col-sm-12 col-xs-12 form-group label">Amount with Tax</div>
																	   </div>
																	  <?php
																		$invoice_matrial_details = json_decode($invoice_detail->descr_of_goods,true);
																		foreach($invoice_matrial_details as $invoice_Data){  
																			$meterial_data = getNameById('material',$invoice_Data['material_id'],'id');
																		?>
						<div class="row-padding col-container mobile-view view-page-mobile-view mailing-box">
							 <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1 !important;"><label>Matrial Name</label><?php echo $meterial_data->material_name; ?></div>
							 <div class="col-md-2 col-sm-12 col-xs-12 form-group "><label>Descriptions</label><?php echo $invoice_Data['descr_of_goods']; ?></div>
							 <div class="col-md-2 col-sm-12 col-xs-12 form-group "><label>HSN/SAC Code</label><?php echo $invoice_Data['hsnsac']; ?></div>
							 <div class="col-md-1 col-sm-12 col-xs-12 form-group "><label>Quantity</label><?php echo $invoice_Data['quantity']; ?></div>
							 <div class="col-md-1 col-sm-12 col-xs-12 form-group "><label>Rate</label><?php echo money_format('%!i',$invoice_Data['rate']); ?></div>
							 <div class="col-md-1 col-sm-12 col-xs-12 form-group "><label>Tax</label><?php echo money_format('%!i',$invoice_Data['tax']); ?></div>
							 <div class="col-md-1 col-sm-12 col-xs-12 form-group "><label>UOM</label><?php 
							$ww = getNameById('uom',$invoice_Data['UOM'],'id');	
																				
												echo $ww->ugc_code; 
						?></div>
							 <div class="col-md-2 col-sm-12 col-xs-12 form-group "><label>Amount with Tax</label><?php echo money_format('%!i',$invoice_Data['amount']); ?></div>
						</div>
			<?php } ?>
					
				  <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">                 
					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
							<div class="col-md-12 col-sm-5 col-xs-12 text-right">
							<div class="col-md-6 col-sm-5 col-xs-6 ">Total : </div>
							<?php $amount_details = json_decode($invoice_detail->invoice_total_with_tax,true);?>
							<div class="col-md-6 text-left"><?php echo money_format('%!i',$amount_details[0]['total']); ?></div>
							<div class="col-md-6 col-sm-5 col-xs-6 ">Tax : </div>
							<div class="col-md-6 text-left"><?php echo money_format('%!i',$amount_details[0]['totaltax']); ?></div>	
							<div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2">
							<div class="col-md-6 col-sm-5 col-xs-6 form-group">Grand Total : </div>
							<div class="col-md-6 text-left form-group"><?php echo money_format('%!i',$amount_details[0]['invoice_total_with_tax']); ?></div>	
							</div>
							</div>
					</div>
				 </div>
				  
				  </table>
				</tr>
				
			 </tbody>
		</table>
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
						<a href="<?php echo base_url(); ?>account/create_pdf/<?php echo $invoice_detail->id; ?>" target="_blank">
						<input type="button" class="btn btn-default"  value="Generate PDF">
						
						</a>
							<button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
							<!--button type="reset" class="btn btn-default">Reset</button>
							<input type="submit" class="btn btn-warning" value="Submit"-->
						</div>
					</div>
					<?php } ?>	
			</div>
			