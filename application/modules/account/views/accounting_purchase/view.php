<input type="hidden" name="id" value="<?php if(!empty($accounting_data)){ echo $accounting_data->id;} ?>">
  <div class="col-md-12 col-sm-12 col-xs-12">				
   
<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">	  

      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
		   <label scope="row">Party Name</label>
		 <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php 
			setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
			//
			  if(!empty($accounting_data)){
			     $name = getNameById('ledger',$accounting_data->party_name ,'id');
				 echo $name->name;
			  }
			
			?></div>
		</div>	
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
		   <label scope="row">Party state:</label>
		 <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php 
		$stateName = getNameById('state',$accounting_data->	party_state_id ,'state_id');
		 if(!empty($accounting_data)){ echo $stateName->state_name; } ?></div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		   <label scope="row">Invoice Number :</label>
		 <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($accounting_data)){
			echo $accounting_data->invoice_num; } ?></div>
		</div>
		
</div>						
<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">	
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
		   <label scope="row"> Date :</label>
		 <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($accounting_data)){
					$newDate = date("j F , Y", strtotime($accounting_data->date_time_of_invoice_issue));
				echo $newDate; } ?></div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		   <label scope="row">Party Phone :</label>
		 <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($accounting_data)){
			echo $accounting_data->party_phone; } ?></div>
		</div>
	  
</div>         					
          
		   
		  
       								

		
			
					 
					  <div class="label-box mobile-view3">			  
								  
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Ledger Name</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Description</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">HSN Code</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Tax</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Amount</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Total Tax.</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Amt with Tax</div>
																			  
																			   
					  </div>
					 
							
						<div class="row-padding col-container mobile-view view-page-mobile-view mailing-box">
							<div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Product Details</label><div><?php 
									$name = getNameById('ledger',$accounting_data->sale_ledger ,'id');
									echo $name->name;


							?></div></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Description</label><div>
							<?php  echo $accounting_data->description;  ?><br /></div></div>
								<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>HSN Code</label><div><?php  echo $accounting_data->hsn_code;  ?><br /></div></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Tax</label><div><?php  echo $accounting_data->taxvalue;  ?><br /></div></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Amount</label><div><?php  echo money_format('%!i',$accounting_data->added_amt);//echo $bill_details->rate;  ?><br /></div></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Total Tax</label><div><?php  echo money_format('%!i',$accounting_data->totaltaxAMT);//echo $bill_details->rate;  ?><br /></div></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Amt with Tax</label><div><?php 
								  echo money_format('%!i',$accounting_data->TotalWithTax);  
							?><br /></div></div>
									
						</div>
					<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
						<div class="col-md-5 col-sm-5 col-xs-12 text-right" style="float: right;">
							<div class="col-md-12 col-sm-5 col-xs-12 text-right">
								<div class="col-md-6 col-sm-5 col-xs-6 ">Total : <?php  echo money_format('%!i',$accounting_data->added_amt); ?></div>
								
									<div class="col-md-6 col-sm-5 col-xs-6 ">Tax : 
										
										<?php 
											echo money_format('%!i',$accounting_data->totaltaxAMT);
										?>
									
									</div>
									
									<div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2">
									<div class="col-md-6 col-sm-5 col-xs-6 form-group">Grand Total : </div>
									<div class="col-md-6 text-left form-group">
									<?php 
									echo money_format('%!i',$accounting_data->TotalWithTax);
								// echo money_format('%!i',$accounting_data->grand_total);
								
						?>
						</div>	
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8 col-sm-12 col-xs-12 label-left">
			<label>Message</label>
			<div class="col-md-6"><?php if(!empty($accounting_data)) echo $accounting_data->message; ?></div>
		</div>

	
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		<div class="form-group">
			<div class="modal-footer">
			<a href="<?php echo base_url(); ?>account/create_pdfacc/<?php echo $accounting_data->id; ?>" target="_blank"><button class="btn btn-default">Generate PDF</button></a>
				<button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
				
			</div>
		</div>
	</div>  
 

