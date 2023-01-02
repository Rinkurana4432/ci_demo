 <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>#/" enctype="multipart/form-data"  novalidate="novalidate">
        <input type="hidden" name="id" value="<?php if(!empty($auto_invoice_data)){ echo $auto_invoice_data->id;} ?>">
  <div class="col-md-12 col-sm-12 col-xs-12">
		<center id="msg_Show"></center>
		
    <table class="fixed data table table-striped no-margin">			
      <thead>				
      <tbody>	
<?php
setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format

 ?>	  
       	<tr>						
          <th>Company Name</th>						
          <td>
          <?php 
			  if(!empty($auto_invoice_data)){
			     $name_company = getNameById('company_detail',$auto_invoice_data->party_conn_company ,'id');
				 echo '<span style="text-transform: capitalize;">'.$name_company->name.'</span>';
			  }
			?>
			
          </td>
		 <th>Supplier Name</th>
			<td>
			<?php 
			  if(!empty($auto_invoice_data)){
			     $name = getNameById('ledger',$auto_invoice_data->sale_ledger ,'id');
				 echo '<span style="text-transform: capitalize;">'.$name->name.'</span>';
			  }
			?>
			</td>
          				
        </tr>
		<tr>						
          <th>Supplier Phone:
          </th>						
          <td>
            <?php if(!empty($auto_invoice_data)){ echo $name->phone_no; } ?>
          </td>							
          <th>Invoice Date :
          </th>	
			<td>
            <?php if(!empty($auto_invoice_data)){
					$newDate = date("d-m-Y", strtotime($auto_invoice_data->created_date));
				echo $newDate; } ?>
          </td>
       								
        </tr>
		
			<tr>
			<table class="table table-striped">
			<tbody>
			<tr>
				<td>
				
				 <table  class="table table-striped table-bordered ">
					 <thead>
					 <tbody>
						 <tr>
						    <th>S.no </th>
							<th>Product Details</th>
							<th>Description</th>
							<th>Unit of Masurment</th>
							<th>Quantity</th>
							<th>Rate</th>
							<th>Tax</th>
							<th>Total</th>
						</tr>
						<?php 
						
						if(!empty($auto_invoice_data)){
							$invooice_dtl = json_decode($auto_invoice_data->descr_of_goods);
							$sno=1;
								foreach($invooice_dtl as $invoice_details){
								?>		
						<tr>
							<td><?php echo $sno; ?></td>
							<td><?php $name =  getNameById('material',$invoice_details->material_id,'id');
								echo $name->material_name;
								?></td>
							<td><?php  echo $invoice_details->descr_of_goods;  ?><br /></td>
							<td><?php  echo $invoice_details->UOM;  ?><br /></td>
							<td><?php  echo $invoice_details->quantity;  ?><br /></td>
							<td><?php  echo money_format('%!i',$invoice_details->rate);  ?><br /></td>
							<td><?php if($invoice_details->tax == ''){echo 'N/A';}else{ echo $invoice_details->tax; } ?><br /></td>
							<td><?php  echo money_format('%!i',$invoice_details->amount);  ?><br /></td>
							
						</tr>
						<?php $sno++; }}  ?>
						
					</tbody>
					</thead>
				</table>
			</tr>
			</td>
		</tr>
					
				
			</tbody>
</table>
				<div id='reject_msg_div' class="col-md-6 col-xs-12" style="display:none;">
						<span id="msgg"></span>
					<textarea class="form-control col-md-7 col-xs-12" name="rejection_message" id="msagge"></textarea>
					
				</div>
			
			
			
      </tbody>			
      </thead>	
	  
    </table>


 </div>
</form>
 <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<div class="form-group">
						<div class="modal-footer">
						<?php if($auto_invoice_data->accept_reject == '0'){ ?>
							<button class="btn btn-default" id="accept_msg" disabled>Accept</button>
							<button class="btn btn-default" id="reject_msg" disabled>Reject</button>
							<button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
						<?php }else{ ?>
							<button class="btn btn-default" id="accept_msg" data-idd="<?php echo $auto_invoice_data->id; ?>">Accept</button>
							<button class="btn btn-default" id="reject_msg" data-idd="<?php echo $auto_invoice_data->id; ?>">Reject</button>
							<button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
						<?php } ?>	
						</div>
					</div>
				
			</div>
	
