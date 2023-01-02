<input type="hidden" name="id" value="<?php if(!empty($purchase_data)){ echo $purchase_data->id;} ?>">
  <div class="col-md-12 col-sm-12 col-xs-12">
 <h3 class="Material-head">
         Material Description
         <hr>
      </h3>  
		<div class="label-box mobile-view3">			  
			   <div class="col-md-2 col-sm-12 col-xs-12 form-group label" style="border-left: 1px solid #c1c1c1;">Product Details</div>
			   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Description</div>
			   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Unit of Measurement</div>
			   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Quantity</div>
			   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Rate</div>
			   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Taxable Amt.</div>
			   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Discount Type</div>
			   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Discount Amount</div>
			   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">After Discount</div>
			   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Tax %</div>
			   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Subtotal</div>
		</div>
					 
			<?php 
			
			if(!empty($purchase_data)){
				$bill_detail = json_decode($purchase_data->descr_of_bills);
					foreach($bill_detail as $bill_details){
						//pre($bill_details);
					
			?>		
						<div class="row-padding col-container mobile-view view-page-mobile-view mailing-box">
							<div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Product Details</label><div><?php 
									$name = getNameById('material',$bill_details->product_details,'id');
							echo $name->material_name;


							?></div></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Description</label><div><?php  echo $bill_details->descr_of_bills;  ?><br /></div></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Unit of Measurement</label><div><?php  

								$ww =  getNameById('uom', $bill_details->UOM,'id');
														$uom = !empty($ww)?$ww->ugc_code:'';

														echo $uom; ?><br /></div></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Quantity</label><div><?php  echo $bill_details->qty;  ?><br /></div></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Rate</label><div><?php  echo money_format('%!i',$bill_details->rate);//echo $bill_details->rate;  ?><br /></div></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Taxable Amt.</label><div><?php 
								$taxable_amt = $bill_details->qty * $bill_details->rate; 
								//echo $taxable_amt;
								echo money_format('%!i',$taxable_amt);
							?><br /></div></div>
									
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Discount Type</label><div><?php 
									if($bill_details->disctype !=''){
										if($bill_details->disctype == 'disc_precnt'){
											echo 'Percentage ( '. $bill_details->discamt. ' % )';
										}else{
											echo 'Discount Value ( '. $bill_details->discamt .' )';
											} 
										}else{ echo 'N/A';}
									?></div></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Discount Amount</label><div><?php 
								if($bill_details->discamt != ''){ 
									if($bill_details->disctype == 'disc_precnt'){
										$basic_amt = $bill_details->qty * $bill_details->rate;
										$total_amt_in_percent = $basic_amt * $bill_details->discamt/100;
										//echo $total_amt_in_percent;
										echo money_format('%!i',$total_amt_in_percent);
									}else{
										//echo $bill_details->discamt;
										echo money_format('%!i',$bill_details->discamt);
									}
								} else { 
									echo 'N/A'; 
								} 
							?></div>
							</div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>After Discount</label><div><?php 
									if($bill_details->disctype !=''){
										if($bill_details->disctype == 'disc_precnt'){
										$basic_amt = $bill_details->qty * $bill_details->rate;
										$total_amt_in_percent = $basic_amt * $bill_details->discamt/100;
										//echo $taxable_amt - $total_amt_in_percent;
										$Tax_able_amt =  $taxable_amt - $total_amt_in_percent;
										echo money_format('%!i',$Tax_able_amt);
									}else{
										//echo $taxable_amt - $bill_details->discamt;
										$Tax_able_amt =  $taxable_amt - $bill_details->discamt;
										echo money_format('%!i',$Tax_able_amt);
									}
									}else{
										echo 'N/A';
									}		
								?></div>		
							</div>	
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Tax %</label><div><?php if($bill_details->tax == ''){echo 'N/A';}else{ echo $bill_details->tax; } ?><br /></div></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Subtotal</label><div><?php echo money_format('%!i',$bill_details->subtotal);?><br /></div></div>
							
						</div>
						<?php } 
						$data_charges_json = json_decode($purchase_data->charges_added,true);
					
							if($data_charges_json[0]['particular_charges_name'] !=''){
								$charge_subtotal = 0;
								$charges_total_for_outside = 0;
								$charge_Discount = 0;
							   
								foreach($data_charges_json as $charge_Data1){
								
						?>
						<div class="row-padding col-container mobile-view view-page-mobile-view">
							<?php 
									$charges_name = getNameById('charges_lead',$charge_Data1['particular_charges_name'],'id');
									 if(!empty($charges_name)){
									$charge_subtotal = $charge_Data1['amt_with_tax'] -  $charge_Data1['charges_added'];
									$total_added_charges = $charge_Data1['charges_added'];
									if($charges_name->type_charges == 'plus'){
										$charges_total_for_outside += $total_added_charges;
										$charges_total_tax_outside += $charge_subtotal;
									}
									if($charges_name->type_charges == 'minus'){
										$total_added_discount_charges = $charge_Data1['charges_added'];
										$charge_Discount += $total_added_discount_charges;
									}
									
									  if($charges_name->type_charges == 'plus'){
									?>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><?php echo $charges_name->particular_charges . ' ' .$charges_name->tax_slab.' %'; ?></div>
									  <?php }else{ ?>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group"><?php echo $charges_name->particular_charges; ?></div>	  
									  <?php } ?>
									
									<div class="col-md-1 col-sm-12 col-xs-12 form-group"><?php echo $charges_name->hsnsac; ?></div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group"><b><?php if($charges_name->tax_slab != 'Select Tax Slab'){echo $charges_name->tax_slab;}else{echo 'N/A';}; ?>  </b></div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group"><b><?php echo money_format('%!i',$total_added_charges); ?></b></div>
							</div>
							<?php
							}	
							} 
							}?>	
						
							  
							
							
						
						
						
						<?php } ?>
						
					
				
				
				<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
                   

<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">

<div class="col-md-12 col-sm-5 col-xs-12 text-right">


<div class="col-md-6 col-sm-5 col-xs-6 ">Total : </div>
<div class="col-md-6 text-left"><?php 
							//pre($purchase_data);
								$amount_details = json_decode($purchase_data->invoice_total_with_tax,true);
								if(!empty($data_charges_json)){
									$charge_amount_add = $charges_total_for_outside;
									}else{
										$charge_amount_add = 0;
									}
									$total_add = $amount_details[0]['total'] + $charge_amount_add;
							
								if($charge_Discount == 0){
									//echo number_format($total_add);
									//echo number_format((float)$total_add, 2, '.', '');
									echo money_format('%!i',$total_add);
								}else{
									$after_discount = $total_add - $charge_Discount;
									//echo number_format($after_discount);
									//echo number_format((float)$after_discount, 2, '.', '');
									echo money_format('%!i',$after_discount);
								}


							 ?></div>	

<div class="col-md-6 col-sm-5 col-xs-6 ">Tax : </div>
<div class="col-md-6 text-left"><?php 
								
								// if(!empty($data_charges_json)){
									// pre($data_charges_json);
									// $charges_tax = $charges_total_tax_outside;
									// }else{
										// $charges_tax  = 0;
									// }
																			
									$tax_total3 = $amount_details[0]['totaltax'];
								//echo number_format($tax_total3);
								//echo number_format((float)$tax_totalcess, 2, '.', '');
								echo money_format('%!i',$tax_total3);



								?></div>
 <?php
								if($amount_details[0]['cess_all_total'] != 0){	
							  ?>
<div class="col-md-6 col-sm-5 col-xs-6 ">CESS : </div>
<div class="col-md-6 text-left"><?php 
									$tax_totalcess = $amount_details[0]['cess_all_total'];
									echo money_format('%!i',$tax_totalcess);
								?></div><?php } ?>
<div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2">
<div class="col-md-6 col-sm-5 col-xs-6 form-group">Grand Total : </div>
<div class="col-md-6 text-left form-group"><?php 
									if($charge_Discount == 0){
									//echo number_format($total_add + $tax_total3);
									$tttt = $total_add + $tax_total3 + $tax_totalcess;
									//echo number_format((float)$tttt, 2, '.', '');
									echo money_format('%!i',$tttt);
								}else{
									
									//echo number_format($after_discount + $tax_total3);
									$ddt = $after_discount + $tax_total3 + $tax_totalcess;
									//echo number_format((float)$ddt, 2, '.', '');
									echo money_format('%!i',$ddt);
								}
								
								



								?></div>	
</div>
</div>
</div>
																				
													    </div>
				<div class="col-md-8 col-sm-12 col-xs-12 label-left">
					<label>Message</label>
					<div class="col-md-6"><?php if(!empty($purchase_data)) echo $purchase_data->message_for_email; ?></div>
				</div>
			
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<div class="form-group">
					<div class="modal-footer">
						<button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>  
 </div>

