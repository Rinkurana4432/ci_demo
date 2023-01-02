<?php 	

	$indentCode = ($indents && !empty($indents))?$indents->indent_code:'';
	$statusDetail = JSON_decode($indents->status);	
	// pre($indents);
//pre($indents->grand_total);
	#pre($po);
?>

<div class="heading"></div></h2>
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/saveStatusPI" enctype="multipart/form-data" id="purchaseIndentForm" novalidate="novalidate">
		<input type="hidden" name="id" value="<?php if($indents && !empty($indents)){ echo $indents->id;} ?>" >	
		<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">
		<?php
			if(empty($indents)){
		?>
		<input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
		<?php }else{ ?>	
		<input type="hidden" name="created_by" value="<?php if($indents && !empty($indents)){ echo $indents->created_by;} ?>" >
		<?php } ?>
		
	
	<div class="item form-group" <?php  if(!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete'){ ; } ?>> 
	<!-- echo 'style="pointer-events:none;"' -->
	<?php /*<div class="item form-group" > */?>
	<div class="container">
  <h4><?php  echo $indentCode; ?></h4>
   
<div class="col-lg-12">

    <div class="col-xs-6">Status</div>
    <div style="width: 227px; height: 90px; float:right;" class="pull-right col-xs-6">
	<p><b>Purchase Indent  ID : </b> <?php echo $indents->id; ?></p>
	<p><b>Grand Total : </b> <?php echo $indents->grand_total; ?></p>
	<p><b>Balance : </b> <?php echo $indents->ifbalance; ?></p>
	</div>

</div>
</div>  
  <table class="table table-bordered">
    <tbody>
		<?php /*<tr>
			<td>
				<?php if(!empty($po)){
					echo '<h5><b>Po Generated List</b></h5>';
					$po_code = '';
					foreach($po as $poVal){
						$po_code .= $poVal['order_code'].'<br>';
					}
					echo $po_code;
				}	?>
			</td>			
			<td>
			<?php if(!empty($mrn)){
					echo '<h5><b>MRN Invoice No.</b></h5>';
					$invoice_no = '';
					foreach($mrn as $mrnVal){
						$invoice_no .= $mrnVal['bill_no'].'<br>';
					}
					echo $invoice_no;
				}	?>
			</td>
		</tr> */?>
      <tr>
        <td class="status-table-td"><div class="col-md-2 col-sm-2 col-xs-2">				 
		
				<?php /*	PO  <input type="checkbox" name="pi_status[]" id="poCheck" value="po" <?php  if((!empty($statusDetail) && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->name == 'PO') || ($indents->po_or_not == 1)){ echo 'checked'; }  if( $indents->po_or_not == 1){ echo ' disabled'; } ?>><br />*/?>
					
					PO  <input type="checkbox" name="pi_status[]" id="poCheck" value="po" <?php  if((!empty($statusDetail) && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->name == 'PO') && ($indents->po_or_not == 1)){ echo 'checked'; }  ?> style="pointer-events:<?php if( $indents->po_or_not == 1){ echo 'none'; } ?>"><br />
				</div>
				<div class="poSection col-md-7" style="display:<?php  if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) &&  $statusDetail->PO->po_or_verbal != '') && ($indents->po_or_not == 1)){ echo 'block'; }else{ echo 'none';} ?>;">
					
					<div class="col-md-8 col-sm-8 col-xs-12 border-rg">
					
                          <div class="radio">
                            <label>
                              <input type="radio" class="flat" name="po_or_verbal" checked  value="verbal" <?php  if(!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'verbal'){ echo 'checked'; }  if( $indents->po_or_not == 1){ ?>  onclick="return false" <?php } ?>> Verbal
                            </label>
                          </div>
						  <div class="radio">
                            <label>							
                             <?php /* <input type="radio" class="flat po_code"  name="po_or_verbal" value="po_code" <?php  if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'po_code') || ($indents->po_or_not == 1)){ echo 'checked'; }elseif( !empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'verbal'){ echo 'disabled'; } ?>> PO Code */?>
							 
							 <input type="radio" class="flat po_code"  name="po_or_verbal" value="po_code" <?php  if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'po_code') && ($indents->po_or_not == 1)){ echo 'checked'; } ?>   <?php if( (!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'verbal') || ($indents->po_or_not == 1)){ ?>  onclick="return false" <?php } ?>> PO Code
                            </label>
                          </div>

						  <?php if(!empty($po)){
								echo '<h5><b>Po Generated List</b></h5>';
								$po_code = '';
								foreach($po as $poVal){
									$po_code .= $poVal['order_code'].'<br>';
								}
								echo $po_code;
							}	?>
						  
						<?php /* <input type="text"  id="po_code" name="po_code" class="form-control " placeholder="Enter PO Code" value="<?php  if(!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal != ''){ echo $statusDetail->PO->po_code; } ?>" style="display:<?php  if(!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'po_code'){ echo 'block'; }else{ echo 'none';  } ?>"> */?>
					 
					</div>
				</div></td>
        <td class="status-table-td"><div class="col-md-2 col-sm-2 col-xs-2">
					MRN <input type="checkbox" name="pi_status[]" id="mrnCheck" value="mrn" <?php  if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->name == 'MRN') && ($indents->mrn_or_not == 1)){ echo 'checked'; } ?> style="pointer-events:<?php if( $indents->mrn_or_not == 1){ echo 'none'; } ?>"><br />
				</div>
				
				<div class="mrnSection col-md-9" style="display:<?php  if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form != '') && ($indents->mrn_or_not == 1)){ echo 'block'; }else { echo 'none'; }  ?>;">
					<div class="col-md-8 col-sm-8 col-xs-12 border-rg">
						<div class="radio">
                            <label>							
                              <input type="radio" class="flat" checked name="mrn_or_without_form"  value="Without Form" <?php  if(!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form == 'Without Form'){ echo 'checked'; }  if($indents->mrn_or_not == 1){ ?>onclick="return false" <?php } ?>> Without Form
                            </label>
                          </div>
						<div class="radio">
                            <label>							
                              <input type="radio" class="flat mrn_code"  name="mrn_or_without_form" value="mrn_code" <?php  if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form == 'mrn_code') || ($indents->mrn_or_not == 1)){ echo 'checked'; } ?> <?php if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form == 'Without Form') || ($indents->mrn_or_not == 1)){ ?>  onclick="return false"<?php }  ?>> Invoice No.
                            </label>							
							
                          </div>
                          
					<?php /*<input type="text"  id="mrn_code" name="mrn_code" class="form-control " placeholder="Enter Invoice No." value="<?php  if(!empty($statusDetail)  && ((array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form != '')){ echo $statusDetail->MRN->mrn_code; } ?>" style="display:<?php  if(!empty($statusDetail)  && ((array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form == 'mrn_code')){ echo 'block'; }else { echo 'none'; }  ?>;"> */?>
					
						<?php if(!empty($mrn)){
							echo '<h5><b>MRN Invoice No.</b></h5>';
							$invoice_no = '';
							foreach($mrn as $mrnVal){
								$invoice_no .= $mrnVal['bill_no'].'<br>';
							}
							echo $invoice_no;
						}	?>
					</div>
				</div></td>
        
      </tr>
      <tr>
        <td class="status-table-td"><div class="col-md-2 col-sm-2 col-xs-2">
					Payment <input type="checkbox" name="pi_status[]" id="paymentCheck" value="payment" <?php  if((!empty($statusDetail)  && (array_key_exists("Payment",$statusDetail)) && $statusDetail->Payment[0]->name == 'Payment') || ($indents->pay_or_not == 1)){ echo 'checked'; } ?>><br />
					<?php  if(!empty($statusDetail)  && (array_key_exists("Payment",$statusDetail)) && $statusDetail->Payment[0]->name == 'Payment'){
						$previousPaymentData =  json_encode($statusDetail->Payment); 
						
						
						
					} ?>
					
				<input type="hidden" name="previousPaymentData" value='<?php  if(!empty($statusDetail)  && (array_key_exists("Payment",$statusDetail)) && $statusDetail->Payment[0]->name == 'Payment'){ echo $previousPaymentData; } ?>'> 
				</div>
				<div class="paymentSection col-md-10 border-rg" style="display:<?php  if(!empty($statusDetail)  && (array_key_exists("Payment",$statusDetail)) && $statusDetail->Payment[0]->name == 'Payment'){ echo 'block'; } else{ echo 'none'; }?>;"> 
				

				<?php
				//pre($statusDetail->Payment);
				if( !empty($statusDetail->Payment) ){
					echo '<h2>Previous payment details</h2>';
						echo '<table class="table table-bordered" id="example">
						  <thead>
							<tr>
							  <th scope="col">Amount</th>
							 
							  <th scope="col">Required Date</th>
							  <th scope="col">Description</th>
							</tr>
						  </thead>
						  <tbody>';
							 
								foreach($statusDetail->Payment as $paymentData){ 
								//pre($paymentData);
								?>
									<tr>
										<!--th scope="row" contenteditable = 'true' ><?php //echo $paymentData->amount; ?></th>
										<td ><?php //echo $paymentData->balance; ?></td>
										<td><?php //echo $paymentData->required_date; ?></td>
										<td><?php  //echo $paymentData->description; ?></td-->
										<th scope="row" contenteditable = 'true' >
										<input type="text"  id="amount" name="edit_amount[]" class="form-control" placeholder="amount" value="<?php echo $paymentData->amount; ?>" required="required" >
										</th>
										<!--td ><?php// echo $paymentData->balance; ?></td-->
										<td><input type="text" id="req_date1" name="edit_required_date[]" class="form-control" placeholder="Date" value="<?php echo $paymentData->required_date; ?>" required="required"></td>
										<td><textarea  id="description" name="edit_description[]" class="form-control" placeholder="description"><?php echo $paymentData->description; ?></textarea></td>
									</tr>
						<?php	} echo '</tbody>
						</table>';
						?>
			<?php }	
				if( $indents->ifbalance !=0 ){
			?>
			<div <?php  if(!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete' && $indents->pay_or_not = 1){ echo 'style="display:none;"'; } ?>  >
				<?php /*<div > */?>
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Amount<span class="required">*</span></label>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text"  id="amount" name="amount" class="form-control" placeholder="amount" value="" >
						</div>
				</div>
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="req_date">Date<span class="required">*</span></label>
						<div class="col-md-8 col-sm-8 col-xs-12">
						<span class="add-on input-group-addon req-date1"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							<input type="text" id="req_date12" name="required_date" class="form-control" placeholder="Date" value=""  style="width:90%;">
						</div>		
				</div>
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="specification">Specification</label>
					<div class="col-md-8 col-sm-8 col-xs-12">
						<textarea  id="description" name="description" class="form-control" placeholder="description"></textarea>
					</div>
				</div>
					</div>
			</div></td>
<?php } ?>				
        <td class="status-table-td">Complete <input type="checkbox" name="pi_status[]" id="completeCheck" value="complete" <?php  if((!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete') || (($indents->po_or_not == 1) && ($indents->mrn_or_not == 1) && ($indents->pay_or_not == 1))){ echo 'checked'; } ?>>	<br /></td>
      </tr>
    </tbody>
  </table>
</div>
	<input type="hidden" value="<?php echo $indents->ifbalance; ?>" name="indent_grand_totl" id="get_balance">
	<input type="hidden" value="<?php echo $indents->grand_total; ?>" name="grand_total" >

	<!--div class="form-group" <?php // if(!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete'){ echo 'style="display:none;"'; } ?>--> 
	<div class="form-group"> 
	<?php /*<div class="form-group" > */?>
		<div class="col-md-12">
		<center>
			<a class="btn  btn-default" onclick="location.href='<?php echo base_url();?>purchase/purchase_indent'">Close</a>
			<button type="reset" class="btn edit-end-btn ">Reset</button>
			<?php if((!empty($indents) && $indents->save_status !=1) || empty($indents)){
					echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
			}?> 
			<input type="submit" value="submit" class="btn edit-end-btn">
			</center>
		</div>
	</div>
	</div>
</form>


<!-- /page content -->