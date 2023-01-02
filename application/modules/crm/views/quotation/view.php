
		<div class="table-responsive">
<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
					<!-- Smart Wizard -->
                    <!--p>This is a basic form wizard example that inherits the colors from the selected scheme.</p-->
                    <div id="wizard " class="form_wizard wizard_horizontal status-1">

		      	<ul class="wizard_steps status" style="margin: 0 -28px 20px;">
                        <li>
                          <a href="javascript:void(0)" id="<?php echo $quotation->id ?>" data-id="quotation_view" data-dismiss="modal">
                            <span class="dsgn_cls">Ouotation</span>
                            <span class="step_descr"><small></small></span>
                          </a>
                        </li>
						<?php //This conditions is check po created or not 
						
							if(!empty($quotation)  && $quotation->save_status == 1 && $quotation->converted_to_proinvc == 1)
							{

						?>
                        <li> 
                          <a href="javascript:void(0);">
                            <span class="dsgn_cls">Proforma Invoice</span>
                            <span class="step_descr"><small></small></span>
                          </a>
                        </li>
					<?php }

					else { 

						?>
						<li>
                          <a href="javascript:void(0);">
                            <span class="not_value">Proforma Invoice</span>
                            <span class="step_descr"><small></small></span>
                          </a>
                        </li>
					<?php } 
					if(!empty($quotation) && $quotation->save_status == 1 && $quotation->sale_ordr_converted == 1)
							{

						?>
                        <li>
                         <a href="javascript:void(0);">
						  <!-- not_value -->
                            <span class="dsgn_cls">Sale Order</span>
                            <span class="step_descr"><small></small></span>
                        </a>
                        </li>
					<?php } else { ?>  
						<li>
                         <a href="javascript:void(0);">
						    <span class="not_value">Sale Order</span>
                            <span class="step_descr"><small></small></span>
                        </a>
                        </li>
					<?php } ?>
                    </ul>
				</div>

						</div>

									</div>

												</div>
<hr>
<div class="bottom-bdr"></div>				 
<div id="print_divv" class="col-md-12 col-sm-12 col-xs-12"  style="padding:0px;"> 


	
<h3 class="Material-head">Company Details<hr></h3>	
		      <div class="col-md-6 col-xs-12 col-sm-6 label-left ">
			           <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Company</label>
									<div class="col-md-6 col-sm-12 col-xs-6 form-group">
										<div><?php if(!empty($quotation)){
															$accountData = getNameById('account',$quotation->account_id,'id'); 
															if(!empty($accountData)) {
																echo $accountData->name ; 
															}
														}?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Contact</label>
									<div class="col-md-6 col-sm-12 col-xs-6 form-group">
										<div><?php if(!empty($quotation) && !empty($account)) echo $account->phone; ?></div>
									</div>
						</div>
						</div>
						<div class="col-md-6 col-xs-12 col-sm-6 label-left ">
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Order Date</label>
									<div class="col-md-6 col-sm-12 col-xs-6 form-group">
										<div><?php if(!empty($quotation) && $quotation->order_date!='') echo date("j F , Y", strtotime($quotation->order_date)); ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Valid Date</label>
									<div class="col-md-6 col-sm-12 col-xs-6 form-group">
										<div><?php if(!empty($quotation) && $quotation->valid_date!='') echo date("j F , Y", strtotime($quotation->valid_date)); ?></div>
									</div>
						</div>
			  
			  </div>
<hr>
<div class="bottom-bdr"></div>			  

<div class="container mt-3">
    <h3 class="Material-head">Product Details<hr></h3>	
	<div class="well pro-details" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; ; margin-top: 15px;">
	<?php if(!empty($quotation) && $quotation->product!=''){ 
					$products = json_decode($quotation->product);
				?>
				<div class="col-container mobile-view2">
			       <div class="col-md-1 col-sm-12 col-xs-12 form-group">S.No</div>
				   <div class="col-md-2 col-sm-12 col-xs-12 form-group">Product Name</div>
				   <div class="col-md-1 col-sm-12 col-xs-12 form-group">Quantity</div>
				   <div class="col-md-2 col-sm-12 col-xs-12 form-group">UOM</div>
				   <div class="col-md-1 col-sm-12 col-xs-12 form-group">Price</div>
				   <div class="col-md-1 col-sm-12 col-xs-12 form-group">GST</div>
				   <div class="col-md-2 col-sm-12 col-xs-12 form-group">Total</div> 
				   <div class="col-md-2 col-sm-12 col-xs-12 form-group">Total With GST</div> 
				   </div>
                   <?php
									$i =1;
									foreach($products as $product){
										$productDetail = getNameById('material',$product->product,'id');
										$materialName = !empty($productDetail)?$productDetail->material_name:'';
								?>
								<div class="row-padding col-container mobile-view view-page-mobile-view">
									       <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
										   <label>S.No</label>
											<div><?php echo $i; ?></div>
									
								          </div>
										  <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
										    <label>Product Name</label>
											<div><h5><?php echo $materialName ; ?></h5><?php echo (array_key_exists("description",$product)?$product->description:'') ; ?></div>
									
								          </div>
										  <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
										    <label>Quantity</label>
											<div><?php echo $product->quantity; ?></div>
									
								          </div>
										   <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
										    <label>UOM</label>
											<div><?php

														$ww =  getNameById('uom', $product->uom,'id');
														$uom = !empty($ww)?$ww->ugc_code:'';

														echo $uom;


											 ?></div>
									
								          </div>
										  <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
										    <label>Price</label>
											<div><?php echo $product->price; ?></div>
									
								          </div>
										  <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
										    <label>GST</label>
											<div><?php echo $product->gst; ?></div>
									
								          </div>
										  <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
										    <label>Total</label>
											<div><?php echo $product->total; ?></div>
									
								          </div>
										  <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
										    <label>Total With GST</label>
											<div><?php echo $product->TotalWithGst; ?></div>
									
								          </div>
										 
                                </div>										  
									
									
									
				   <?php $i++;}?>				
												   
			 </div>
			 </div>
			 <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
        
					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
						
					<div class="col-md-12 col-sm-5 col-xs-12 text-right">
						
							<div class="col-md-12 col-sm-12 col-xs-12 text-right igst style='display:none;'">
							<div class="col-md-6 col-sm-5 col-xs-6 text-right">Total :</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
											<?php echo $quotation->total; ?></div>
						</div>
					    <div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2" >
						<div class="col-md-6 col-sm-5 col-xs-6 text-right form-group">
							Grand Total : 
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left form-group">
							      <span class="divSubTotal fa fa-rupee" aria-hidden="true"><?php echo $quotation->grandTotal; ?></span> 
							</div>
							 
						</div>
					</div>
						
					</div>
				
			
				</div>
	<?php } ?>
<hr>
<div class="bottom-bdr"></div>
<h3 class="Material-head">Payment Details<hr></h3>
 <div class="col-md-6 col-xs-12 col-sm-6 label-left ">
			           <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Other Taxes</label>
									<div class="col-md-6 col-sm-12 col-xs-6 form-group">
										<div><?php if(!empty($quotation)) echo $quotation->agt; ?></div>
									</div>
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Payment Terms</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php /* if(!empty($quotation) && $quotation->payment_terms != ''){
															$payment_terms = json_decode($quotation->payment_terms);
																$payment_term = '';
																foreach($payment_terms as $pt){
																	$payment_term .= $pt. ' ,'; 
																	
																}
																echo $payment_term = rtrim($payment_term,',');
														}*/
														echo  $quotation->payment_terms; ?></div>
									</div>
						</div>
						</div>
 <div class="col-md-6 col-xs-12 col-sm-6 label-left ">						
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Cash Discount</label>
									<div class="col-md-6 col-sm-12 col-xs-6 form-group">
										<div><?php if(!empty($quotation)) echo $quotation->cash_discount; ?></div>
									</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Discount Offered</label>
									<div class="col-md-6 col-sm-12 col-xs-6 form-group">
										<div><?php if(!empty($quotation)) echo $quotation->discount_offered; ?></div>
									</div>
						</div>
			  
			  </div>	
</div>	



			  
			  </div>
								
									</div>							
								</div>                          						
							</div>
					</div>

				</div>			  
        </div>
						<div class="col-md-6 col-sm-12 col-xs-12 form-group label-left">
                                     <label for="material">Terms & Conditions</label>
									<div class="col-md-6 col-sm-12 col-xs-6 form-group">
										<?php if(!empty($quotation)) echo $quotation->terms_conditions; ?>
									</div>
						</div>	
</div>

</div>
 <!--<table class="table table-bordered" style="width:100%"  border="1" cellpadding="2">						
	<thead>													
		<tbody>
			<tr>														
				<th>Account:</th>													
				<td><?php if(!empty($pi)){
					$accountData = getNameById('account',$pi->account_id,'id'); 
					if(!empty($accountData)) {
						echo $accountData->name ; 
					}
				}?></td>									
															
			</tr>	
			<tr>															
				<th>Contact:</th>														
				<td>									
				<?php if(!empty($pi) && $pi->contact_id !=0){
					$contactData = getNameById('contacts',$pi->contact_id,'id');
					if(!empty($contactData))
						echo $contactData->first_name.' '.$contactData->last_name;
					}
				?>
				</td>													
			</tr>	
			<tr>														
				<th>Order Date:</th>													
				<td><?php if(!empty($pi) && $pi->order_date!='') echo date("j F , Y", strtotime($pi->order_date)); ?></td>
			</tr>
			<tr>														
				<th>Dispatch Date :</th>													
				<td><?php if(!empty($pi) && $pi->dispatch_date!='') echo date("j F , Y", strtotime($pi->dispatch_date)); ?></td>														
			</tr>
			<tr>   
				<?php if(!empty($pi) && $pi->product!=''){ 
					$products = json_decode($pi->product);
				?>
					<th>Product details	: </th>	
					<td><div class="x_content">
						<table class="table table-bordered table-responsive" border="1" cellpadding="2">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Product Name</th>
									<th>Quantity</th>
									<th>UOM</th>
									<th>Price</th>
									<th>GST</th>
									<th>Total</th>
									<th>Total With GST</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$i =1;
									foreach($products as $product){
										$productDetail = getNameById('material',$product->product,'id');
										$materialName = !empty($productDetail)?$productDetail->material_name:'';
								?>					  
									<tr>
										<th scope="row"><?php echo $i; ?></th>
										<td><h5><?php echo $materialName ; ?></h5><br><?php echo (array_key_exists("description",$product)?$product->description:'') ; ?></td>
										<td><?php echo $product->quantity; ?></td>
										<td><?php echo $product->uom; ?></td>
										<td><?php echo $product->price; ?></td>
										<td><?php echo $product->gst; ?></td>
										<td><?php echo $product->individualTotal; ?></td>
										<td><?php echo $product->individualTotalWithGst; ?></td>
									</tr>
								<?php $i++;}?>
									<tr><td colspan='8'>Total : <?php echo $pi->total; ?></td></tr>
									<tr><td colspan='8'>Grand Total :<?php echo $pi->grandTotal; ?></td></tr>													
							</tbody>
						</table>
					</div></td>
				<?php } ?>
			</tr>														
			<tr>			
				<th>Other Taxes:</th>														
				<td><?php if(!empty($pi)) echo $pi->agt; ?></td>	
			</tr>	
			<tr>			
				<th>Freight:</th>														
				<td><?php if(!empty($pi)) echo $pi->freight; ?></td>									
			</tr>	
			<tr>			
				<th>Payment Terms:</th>														
				<td><?php /* if(!empty($pi) && $pi->payment_terms != ''){
							$payment_terms = json_decode($pi->payment_terms);
								$payment_term = '';
								foreach($payment_terms as $pt){
									$payment_term .= $pt. ' ,'; 
									
								}
								echo $payment_term = rtrim($payment_term,',');
						}*/
						echo  $pi->payment_terms; ?>
				</td>	
			</tr>
			<tr>								
				<th>Advance Received:</th>														
				<td><?php if(!empty($pi)) echo $pi->advance_received; ?></td>														
			</tr>
			<tr>			
				<th>Cash Discount:</th>														
				<td><?php if(!empty($pi)) echo $pi->cash_discount; ?></td>	
			</tr>
			<tr>								
				<th>Discount Offered:</th>														
				<td><?php if(!empty($pi) && $pi->discount_offered != 'null'){
					$discount_offered = json_decode($pi->discount_offered);
					$discount = '';
					if(!empty($discount_offered)){
						foreach($discount_offered as $do){
							$discount .= $do. ' ,'; 
											
						}
					}
					echo $discount = rtrim($discount,',');
					}?>
				</td>													
			</tr>	
			<tr>			
				<th>Other Expenses:</th>														
				<td><?php if(!empty($pi)) echo $pi->label_printing_express; ?></td>	
			</tr>
			<tr>								
				<th>Brand Label:</th>														
				<td><?php if(!empty($pi)) echo $pi->brand_label; ?></td>									
																
			</tr>	
			<tr>			
				<th>Dispatch Documents:</th>														
				<td><?php if(!empty($pi) && $pi->dispatch_documents != 'null'){
							$dispatch_documents = json_decode($pi->dispatch_documents);
							if(!empty($dispatch_documents)){
								$documents = '';
								foreach($dispatch_documents as $dispatch_document){
									$documents .= $dispatch_document. ' ,'; 
									
								}
								echo $documents = rtrim($documents,',');
							}	
						}?>
				</td>	
			</tr>
			<tr>
				<th>Product Application:</th>														
				<td><?php if(!empty($pi)) echo $pi->product_application; ?></td>									
			</tr>
			<tr>														
				<th>Guarantee: </th>														
				<td><?php if(!empty($pi)) echo $pi->guarantee; ?></td>
			</tr>
			<tr>														
				<th>Created By: </th>										
				<td><?php
				if(!empty($pi)){
					$piCreatedBy = ($pi->created_by!=0)?(getNameById('user_detail',$pi->created_by,'u_id')):'';
					if(!empty($piCreatedBy)){
						$createdByName = $piCreatedBy->name;
					}else{
						$createdByName = '';
					}									
					echo $createdByName; 
				}?></td>													
			</tr>	

			<tr>														
				<th>Attachments:</th>	 
				<td>    <div class="col-md-12 outline">
				<?php foreach($attachments as $attachment){
							

							echo '<div class="img-wrap"><div class="col-md-1 img-outline"><a href="'.base_url(). 'assets/modules/crm/uploads/'.$attachment[ 'file_name']. '" download><img src="'.base_url(). 'assets/modules/crm/uploads/'.$attachment[ 'file_name']. '" alt="image" class="img-responsive zoom"/></a></div></div>';
				} ?>
			</div></td>											
			</tr>								
		</tbody>												
	</thead>												
</table>-->
	<div class="col-md-12 col-xs-12"><center>

		
        <?php /* <button  type="button"  class="btn btn-default" onclick="printJS('<?php echo base_url().'crm/Quotcreate_pdf/'.$quotation->id ?>')">Print</button> */ ?>
		<button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button> 



		<?php  if(!empty($quotation) && $quotation->save_status == 1) { echo '<a href="'.base_url().'crm/Quotcreate_pdf/'.$quotation->id.'" target="_blank"><button class="btn edit-end-btn ">Generate PDF</button></a>'; } ?>	
	</center>
	</div>
					
