<div class=" form-group">
	<input type="hidden" name="id" value="<?php if(!empty($delivery_data)) echo $delivery_data->id; ?>">
	<div class=" form-group">	
			<div class=" form-group">
				<div class="panel panel-default">
						<?php
							setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
						?>
						<div>
						<div class="col-md-12 col-sm-12 col-xs-12">
						 <h3 class="Material-head">
							 Material Description
							 <hr>
						  </h3> 
							<div class="x_content">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<div id="myTabContent" class="tab-content">
								<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
								<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="table-responsive">
									<table class="table table-striped">
										<tbody>
										
								<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">	
								    
									<div class="table-responsive">
										<table class="table table-striped">
									    <div class="label-box mobile-view3">
											<div class="col-md-3 col-sm-12 col-xs-12 form-group label" style="border-left: 1px solid #c1c1c1;">Descriptions of <br> Goods </div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group label">HSN/SAC</div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group label">Quantity</div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group label">Rate</div>
											<div class="col-md-1 col-sm-12 col-xs-12 form-group label">UOM</div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group label">Total Amount</div>
										</div>
										  <?php
											$invoice_matrial_details = json_decode($delivery_data->descr_of_goods,true);
											$subtotal_all_invoice =0;
											foreach($invoice_matrial_details as $chaln_Data){ 
											
												$meterial_data = getNameById('material',$chaln_Data['material_id'],'id');
											?>
										<div class="row-padding col-container mobile-view view-page-mobile-view mailing-box">
											<div class="col-md-3 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1 !important;"><label>Descriptions of <br> Goods </label><?php echo '<span><b>'.$meterial_data->material_name.'</b><br/></span>'.substr($chaln_Data['descr_of_goods'], 0, 50);?></div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group "><label>HSN/SAC</label><?php echo $chaln_Data['hsnsac']; ?></div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group "><label>Quantity</label><?php echo $chaln_Data['quantity']; ?></div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group "><label>Rate</label><?php echo money_format('%!i',$chaln_Data['rate']); ?></div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group "><label>UOM</label><?php echo $chaln_Data['UOM']; ?></div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group "><label>Total Amount</label><?php
											  $taxable_amt = $chaln_Data['quantity'] * $chaln_Data['rate'];
													echo money_format('%!i',$taxable_amt);
											 ?></div>
										</div>
										<?php  } ?>
									 <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
											 <div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
												<div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2">
													<div class="col-md-6 col-sm-5 col-xs-6 form-group">
														Grand Total : 
														</div>
														<div class="col-md-6 text-left form-group"><?php echo money_format('%!i',$delivery_data->challan_total_amt); ?></div>	
													</div>
													</div>
										</div>     
								</table>
							  </div>
							</tr>
							
						 </tbody>
					</table>
				</div>
				</div>
			</div>
			
			
		
			
		</div>
	</div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<!-- <div class="ln_solid"></div>----->

	<div class="form-group">
		<div class="modal-footer">
		<?php //if((!empty(delivery_data) && $delivery_data->save_status ==1)){ ?>
			<!--a href="<?php echo base_url(); ?>account/create_challan_pdf/<?php //echo $delivery_data->id; ?>" target="_blank"><button class="btn btn-default">//Generate PDF</button></a-->
		<?php //} ?>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			
		</div>
	</div>

</div>	
</div>

</div>

</div>

</div>

</div>

</div>
	