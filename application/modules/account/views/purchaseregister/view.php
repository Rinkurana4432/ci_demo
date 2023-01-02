<input type="hidden" name="id" value="<?php if(!empty($purchase_data)){ echo $purchase_data->id;} ?>">
  <div class="col-md-12 col-sm-12 col-xs-12">				
   					
       	<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">	
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">		
          <label>Supplier Name</label>						
          <div class="col-md-7 col-sm-12 col-xs-6 form-group">
          
			<?php 
			
			setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
			  if(!empty($purchase_data)){
			     $name = getNameById('ledger',$purchase_data->supplier_name ,'id');
				 echo $name->name;
			  }
			?>
          </div>	
         </div>	
<div class="col-md-12 col-sm-12 col-xs-12 form-group">		 
          <label>Supplier Address:</label>						
          <div class="col-md-7 col-sm-12 col-xs-6 form-group">
            <?php if(!empty($purchase_data)){ echo $purchase_data->supp_address; } ?>
          </div>	
</div>		  
        </div>
		<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">	
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
          <label>IFSC CODE:
          </label>						
          <div class="col-md-7 col-sm-12 col-xs-6 form-group">
            <?php if(!empty($purchase_data)){ echo $purchase_data->ifsc_code; } ?>
          </div>
		  </div>
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">		  
          <label>Bill Date :
          </label>	
			<div class="col-md-7 col-sm-12 col-xs-6 form-group">
            <?php if(!empty($purchase_data)){
					$newDate = date("j F , Y", strtotime($purchase_data->date));
				echo $newDate; } ?>
          </div>
       	</div>						
        </div>
		
			
					 <div class="label-box mobile-view3">
						   <div class="col-md-2 col-sm-12 col-xs-12 form-group label" style="border-left: 1px solid #c1c1c1;">Product Details</div>
						   <div class="col-md-2 col-sm-12 col-xs-12 form-group label">Descriptions</div>
						   <div class="col-md-2 col-sm-12 col-xs-12 form-group label">Quantity</div>
						   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Unit of Measurement</div>
						   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Rate</div>
						   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Tax</div>
						   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Subtotal</div>
						   <div class="col-md-2 col-sm-12 col-xs-12 form-group label">Amount with Tax</div>
					</div>
					 
						<?php 
						
						if(!empty($purchase_data)){
							$bill_detail = json_decode($purchase_data->descr_of_bills);
								foreach($bill_detail as $bill_details){
						?>		
						<div class="row-padding col-container mobile-view view-page-mobile-view mailing-box">
							<div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1 !important;"><label>Product Details</label><?php 
									$name = getNameById('material',$bill_details->product_details,'id');
							echo $name->material_name;


							?></div>
							<div class="col-md-2 col-sm-12 col-xs-12 form-group "><label>Descriptions</label><?php  echo $bill_details->descr_of_bills;  ?><br /></div>
							<div class="col-md-2 col-sm-12 col-xs-12 form-group "><label>Quantity</label><?php  echo $bill_details->qty;  ?><br /></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group "><label>Unit of Measurement</label>
							<?php 
								$ww =  getNameById('uom', $bill_details->UOM,'id');
								$uom = !empty($ww)?$ww->ugc_code:'';
								echo $uom;  
								
								
								?><br /></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group "><label>Rate</label><?php  echo money_format('%!i',$bill_details->rate);  ?><br /></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group "><label>Tax</label><?php if($bill_details->tax == ''){echo 'N/A';}else{ echo money_format('%!i',$bill_details->tax); } ?><br /></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group "><label>Subtotal</label><?php  echo money_format('%!i',$bill_details->subtotal);  ?><br /></div>
							<div class="col-md-2 col-sm-12 col-xs-12 form-group "><label>Amount with Tax</label><?php  echo money_format('%!i',$bill_details->amountwittax);  ?><br /></div>
						
						</div>
						<?php } ?>
						
						<?php } ?>
						<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">                 
										<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
												<div class="col-md-12 col-sm-5 col-xs-12 text-right">
												<div class="col-md-6 col-sm-5 col-xs-6 ">Sub Total : </div>
												<?php 
												
												 $amount_details = json_decode($purchase_data->invoice_total_with_tax,true);
													
												?>
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
<hr>																	 
<div class="bottom-bdr"></div>				
				<div class="col-md-8 col-xs-12 label-left">
					<label>Message</label>
					<div class="col-md-8 col-sm-12 col-xs-6 form-group"><?php if(!empty($purchase_data)) echo $purchase_data->message_for_email; ?></div>
				</div>
				

<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		<div class="form-group">
			<div class="modal-footer">
				<button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
			</div>
		</div>
</div>		
 </div>
			
