<div class=" form-group">
	<input type="hidden" name="id" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->id; ?>">
		<div class=" form-group">
			<div class=" form-group">
				<div class="panel panel-default">
					<?php
					setlocale(LC_MONETARY, 'en_IN');
					?>
			    <h3 class="Material-head">Ledger : <?php if(!empty($invoice_detail)){
					$sale_ledger_name = getNameById('ledger',$invoice_detail->sale_ledger,'id');
					echo $sale_ledger_name->name;
					}?>
				</h3>
				<div class="panel-body">
					<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<label>Party Email</label>
							<div class="col-md-7 col-sm-12 col-xs-6 form-group">
								<?php  if(!empty($invoice_detail)) echo $invoice_detail->email; ?>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						    <label>Invoice Number</label>
						   <div class="col-md-7 col-sm-12 col-xs-6 form-group">
						   <?php if(!empty($invoice_detail)) echo $invoice_detail->invoice_num; ?></div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						    <label>Date Time issue of Invoice</label>
							<div class="col-md-7 col-sm-12 col-xs-6 form-group">
							<?php if(!empty($invoice_detail)) echo date("d - M - Y", strtotime($invoice_detail->date_time_of_invoice_issue)); ?></div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						    <label>Buyer Order number</label>
							<div class="col-md-7 col-sm-12 col-xs-6 form-group">
							<?php if(!empty($invoice_detail)) echo $invoice_detail->buyer_order_no; ?></div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						    <label>Dispatch Document Number</label>
						    <div class="col-md-7 col-sm-12 col-xs-6 form-group">
							<?php if(!empty($invoice_detail)) echo $invoice_detail->dispatch_document_no ; ?></div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						    <label>Party</label>
						    <div class="col-md-7 col-sm-12 col-xs-6 form-group">
							<?php
							  if(!empty($invoice_detail)){
								  $party_name = getNameById('ledger',$invoice_detail->party_name,'id');
								 echo $party_name->name;
							  }
							?>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						    <?php
								$party_ledger = getNameById('ledger',$invoice_detail->party_name,'id');
								   $party_add = json_decode($party_ledger->mailing_address,true);
									   foreach ($party_add as $key => $detaild) {
											if ($detaild['mailing_state'] == $invoice_detail->party_state_id) {
												$mailing_address11 = $detaild['mailing_address'];

											}
									   }
							?>
							<label>Party Mailing Address</label>
							<div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php echo $mailing_address11; ?></div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<label>Sale Ledger</label>
							<div class="col-md-7 col-sm-12 col-xs-6 form-group">
								<?php
										if(!empty($invoice_detail)){
										$sale_ledger_name = getNameById('ledger',$invoice_detail->sale_ledger,'id');
										echo $sale_ledger_name->name;
										}
								?>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						   <?php
								$get_party_state_data = getNameById('state',$invoice_detail->party_state_id,'state_id');
								$party_ledger_purchaser11 = $get_party_state_data->state_name;
							?>
							<label>Party Sate</label>
							<div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php echo $party_ledger_purchaser11; ?></div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						    <label>Transport</label>
						    <div class="col-md-7 col-sm-12 col-xs-6 form-group">
								 <?php
									if(!empty($invoice_detail) && $invoice_detail->transport == '1' )
											{ echo 'Road' ; }
										else if (!empty($invoice_detail) && $invoice_detail->transport == '2' )
										{ echo 'Rail'; }
										else if (!empty($invoice_detail) && $invoice_detail->transport == '3' )
										{ echo 'Air'; }
										else if (!empty($invoice_detail) && $invoice_detail->transport == '4' )
										{ echo 'Ship'; }
										else {  echo 'N/A'; }
									?>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							   <label>Vehicle Number</label>
							   <div class="col-md-7 col-sm-12 col-xs-6 form-group">
									<?php  if(!empty($invoice_detail->vehicle_reg_no)){
										echo $invoice_detail->vehicle_reg_no;}else{echo 'N/A';}
									?>
								</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							   <label>Transport Driver Phone Number</label>
							   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail->transport_driver_pno)){echo $invoice_detail->transport_driver_pno;}else{echo 'N/A';} ?></div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							   <label>Terms of Delivery</label>
							   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail->terms_of_delivery)){ echo $invoice_detail->terms_of_delivery;}else{echo 'N/A';} ?></div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							   <label>Pan</label>
							   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail)) echo $invoice_detail->pan; ?></div>
						</div>
					</div>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_content">
<div class="" role="tabpanel" data-example-id="togglable-tabs">
	<div id="myTabContent" class="tab-content">
		<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped">
					<tbody>
						<div class="table-responsive">
							<table class="table table-striped">
							 <div class="label-box mobile-view3">
							   <div class="col-md-2 col-sm-12 col-xs-12 form-group label" style="border-left: 1px solid #c1c1c1;">Material Name</div>
							   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">HSN/SAC</div>
							   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Quantity</div>
							   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Rate</div>
							   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Discount Type</div>
							   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Discount Amount</div>
							   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">After Discount</div>
							   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Tax</div>
							   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">UOM</div>
							   <div class="col-md-1 col-sm-12 col-xs-12 form-group label" style="border-right: 1px solid #c1c1c1;">Amount with Tax</div>
							 </div>
					<?php
						$invoice_matrial_details = json_decode($invoice_detail->descr_of_goods,true);
						$subtotal_all_invoice =0;
						foreach($invoice_matrial_details as $invoice_Data){
							$meterial_data = getNameById('material',$invoice_Data['material_id'],'id');
					?>
			<div class="row-padding col-container mobile-view view-page-mobile-view" style="display: table-row !important;">
				<div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1 !important;">
				    <label>Material Name</label>
						<?php echo '<span><b>'.$meterial_data->material_name.'</b><br/></span>'.substr($invoice_Data['descr_of_goods'], 0, 50);?>
				</div>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">
					<label>HSN/SAC</label>
						<?php echo $invoice_Data['hsnsac']; ?>
				</div>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">
					<label>Quantity</label>
						<?php echo $invoice_Data['quantity']; ?>
				</div>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">
					<label>Rate</label>
						<?php echo $invoice_Data['rate']; ?>
				</div>

				<div class="col-md-1 col-sm-12 col-xs-12 form-group">
					<label>Discount Type</label>
						<?php
						 if($invoice_Data['disctype'] == 'disc_precnt'){
								echo 'Percentage ( '. $invoice_Data['discamt']. ' % )';
							 }elseif($invoice_Data['disctype'] == 'disc_value'){
								echo 'Discount Value ( '. $invoice_Data['discamt'] .' )';
							 }else{
								 echo 'N/A';
							 }
						?>
				</div>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">
					<label>Discount Amount</label>
						<?php
							$discountValues = 0;
							$basic_amt = $invoice_Data['quantity'] * $invoice_Data['rate'];
							if($invoice_Data['discamt'] != ''){
								if($invoice_Data['disctype'] == 'disc_precnt'){
									$total_amt_in_percent = $basic_amt * $invoice_Data['discamt']/100;
									$totalDisWithCharge += $total_amt_in_percent + chargeAmountPerMat($invoice_detail->charges_added,($basic_amt - $total_amt_in_percent ),$invoice_detail->descr_of_goods);
									echo  $discountValues = $total_amt_in_percent + chargeAmountPerMat($invoice_detail->charges_added,($basic_amt - $total_amt_in_percent ),$invoice_detail->descr_of_goods);
								}else{
									$valueDiscount = $invoice_Data['quantity'] * $invoice_Data['discamt'];
									$totalDisWithCharge += $valueDiscount + chargeAmountPerMat($invoice_detail->charges_added,($basic_amt - $valueDiscount ),$invoice_detail->descr_of_goods);
									echo  $discountValues = ($valueDiscount ) + chargeAmountPerMat($invoice_detail->charges_added,($basic_amt - $valueDiscount ),$invoice_detail->descr_of_goods);
								}
							} else {
								$totalDisWithCharge += chargeAmountPerMat($invoice_detail->charges_added,$basic_amt,$invoice_detail->descr_of_goods);
								echo chargeAmountPerMat($invoice_detail->charges_added,$basic_amt,$invoice_detail->descr_of_goods);
							}
						?>
				</div>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">
					<label>After Discount</label>
						<?php
							$matAfterDiscount = $basic_amt;
							if( $invoice_Data['after_desc_amt'] ){
								$matAfterDiscount = $invoice_Data['after_desc_amt'];
							}
							echo $matAfterDiscount - chargeAmountPerMat($invoice_detail->charges_added,($basic_amt - $discountValues ),$invoice_detail->descr_of_goods);
							$ww =  getNameById('uom', $invoice_Data['UOM'],'id');
							$uom = !empty($ww)?$ww->ugc_code:'';
						?>
				</div>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">
					<label>Tax</label>
						<?php echo $invoice_Data['tax'];
							  $totaltaxRowVal += $invoice_Data['added_tax_Row_val'];
						?>
				</div>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">
					<label>UOM</label>
						<?php echo $uom.'<br/><small>'.$invoice_Data['alterqty'].'</small>' ; ?>
				</div>
					 <?php
						$subtotal_invoice_amt = $invoice_Data['quantity'] * $invoice_Data['rate'];
						 $subtotal_all_invoice 	+= $subtotal_invoice_amt;
						 $totalWithAllCharge 	+= $subtotal_invoice_amt;
					 ?>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1;"><label>Amount with Tax</label>
					<?php
						if($invoice_Data['disctype'] == ''){
							/* Testing issue 09-03 */
							echo $invoice_Data['amount'];
						}else{
							echo floor($invoice_Data['amount_with_tax_after_disco']*100)/100;
						 }
					?>
				</div>
			</div>
		<?php  } ?>

				<?php
					$data_charges_json = json_decode($invoice_detail->charges_added,true);
						if($data_charges_json !=''){
							$charge_subtotal = 0;
							$charges_total_for_outside = 0;
								foreach($data_charges_json as $charge_Data1){
									?>
										<div class="row-padding col-container mobile-view view-page-mobile-view" style="display: table-row !important;">
								<?php $charges_name = getNameById('charges_lead',$charge_Data1['particular_charges_name'],'id');
									if(!empty($charges_name) && $charges_name->type_charges == 'plus'){
									$charge_subtotal = $charge_Data1['amt_with_tax'] -  $charge_Data1['charges_added'];
									//$charge_subtotal = $charge_Data1['amt_with_tax'];
									$total_added_charges = $charge_Data1['charges_added'];
									//$chargesAmt_withtax = $charge_Data1['charges_added'];
									if($charges_name->type_charges == 'plus'){
										$charges_total_for_outside += $total_added_charges;
										$charges_total_tax_outside += $charge_subtotal;
										$totalcharges += $charge_Data1['amt_with_tax'];
										$totaltaxRowVal += $charge_Data1['amt_tax'];
										$totalWithAllCharge += $total_added_charges;
									}
					if($charges_name->type_charges == 'plus'){
				?>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1 !important;">
					<?php
						echo $charges_name->particular_charges . ' ' .$charges_name->tax_slab.' %';
					?>
				</div>
				<?php }else{ ?>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">
					<?php echo $charges_name->particular_charges; ?>
				</div>
				<?php } ?>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">
					<?php echo $charges_name->hsnsac; ?>
				</div>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">
					<?php echo $charge_Data1['charges_added']; ?>
				</div>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">
					<?php echo $charge_Data1['charges_added']; ?>
				</div>
				<!-- <div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div> -->
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
				<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
					<div class="col-md-1 col-sm-12 col-xs-12 form-group">
						<?php if($charges_name->tax_slab != 'Select Tax Slab'){
							echo $charges_name->tax_slab;
							}else{
								echo 'N/A';
							}
						?>
					</div>
					<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>

					<?php

					?>
					<div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1;">
					<b>
					<?php
					if($charge_Data1['type_charges'] == 'plus'){
						echo $charge_Data1['amt_with_tax'];
					}else{
						echo $charge_Data1['charges_added'];
					}
					?>
						</b>
					</div>
			</div>
				<?php
			}
		}
	}
		?>
	</table>
	  </div>
	</tr>

 </tbody>
</table>
	<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
		<div class="col-md-6 col-sm-5 col-xs-12 text-right" style="float: right;">
		<div class="col-md-12 col-sm-5 col-xs-12 text-right">
			<div class="col-md-6 col-sm-5 col-xs-6 ">
				Total :
			</div>
			<div class="col-md-6 text-left">
				<?php
					$total = $totalWithAllCharge;
					/* Testing issue 09-03 */
					echo $total;
				?>
			</div>
			<?php
				$data_charges_jsone = json_decode($invoice_detail->charges_added,true);

				if($data_charges_jsone !=''){
					$chargesTotal = 0;
					$plusCharge = 0;
					$minusCharge = 0;
					foreach($data_charges_jsone as $chrgDATA){
					$chargesName = getNameById('charges_lead',$chrgDATA['particular_charges_name'],'id');
					$chargesTotal = $chrgDATA['amt_with_tax'];
					if($chargesName !=''  ){
			?>
            <div class="col-md-12">
			<div class='col-md-6 col-sm-5 col-xs-6' style="<?php if( $chrgDATA['type_charges'] == 'plus' ){ echo 'display:none';  } ?>">
				<?php echo 'Total '. $chargesName->particular_charges.':'; ?>
			</div>
			<div class="col-md-6 text-left" style="display: flex; <?php if( $chrgDATA['type_charges'] == 'plus' ){ echo 'display:none';  } ?>">
				<?php
					if($chrgDATA['type_charges'] == 'plus'){
						echo $chrgDATA['amt_with_tax'];
						$plusCharge += $chrgDATA['amt_with_tax'];
						if( $chrgDATA['amount_of_charges'] == 'percentage' ){
							echo "<span>%</span>";
						}
					}else{
						$minusCharge += $chrgDATA['amt_with_tax'];
						echo $totalDisWithCharge;
					}
				?>
			</div>
			</div>

			<?php  }else{?>
				<div class="col-md-12">
					<div class='col-md-6 col-sm-5 col-xs-6'>
						Total Discount
					</div>
					<div class="col-md-6 text-left" style="display: flex;">
						<?= $totalDisWithCharge; ?>
					</div>
				</div>
			<?php }
			 } } ?>
			<div class="col-md-6 col-sm-5 col-xs-6 ">
				After Discount :
			</div>
			<div class="col-md-6 text-left">
				<!-- Testing issue 09-03 -->
				<?= $afterDiscount = $totalWithAllCharge - $totalDisWithCharge; ?>
			</div>
			<div class="col-md-6 col-sm-5 col-xs-6 ">
				Tax :
			</div>
 			<div class="col-md-6 text-left">
				 <?php
				 /* Testing issue 09-03 */
					echo $tax = $totaltaxRowVal;
					?>
			</div>
				<?php
					if($amount_details[0]['tds_tax'] != 0){
				?>
				<div class="col-md-12 col-sm-12 col-xs-12 text-right" style="width:100%;padding: 0px;">
					<div class="col-md-6 col-sm-5 col-xs-6 form-group">
						TCS :
					</div>
					<div class="col-md-6 text-left form-group">
							<?php
							/* Testing issue 09-03 */
								echo $tds = $amount_details[0]['tds_tax'];
							?>
					</div>
				</div>
				<?php }
			 if($amount_details[0]['cess_all_total'] != 0 || $amount_details[0]['cess_all_total'] != ''){
			 ?>
			 <div class="col-md-6 col-sm-5 col-xs-6 ">
				CESS :
			</div>
			<div class="col-md-6 text-left">
				   <?php
					$cess_AMT = $amount_details[0]['cess_all_total'];
					/* Testing issue 09-03 */
					echo $cess_AMT;
					?>
			</div>
			<?php }

			$grandTotalPoint = $afterDiscount + $plusCharge + $tax + $tds + $cess_AMT;

			$roundOf = $grandTotalPoint - (int)$grandTotalPoint;

			?>
			<div class="col-md-12 col-sm-12 col-xs-12" >
				<div class="col-md-6 col-sm-5 col-xs-6 ">
					Round Off :
				</div>
				<div class="col-md-6 col-sm-5 col-xs-6 ">
					<input type="text" class="rounoffCls" value="<?php if(!empty($invoice_detail)){
						echo round($roundOf,2);//round(($totalWithAllCharge - $totalDisWithCharge + $totaltaxRowVal ) - (int)$invoice_detail->total_amount,2);
					  }
					  ?>"  style="border: none;"readonly>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2">
				<div class="col-md-6 col-sm-5 col-xs-6 form-group">
					Grand Total :
				</div>
				<div class="col-md-6 text-left form-group"><?php
				/* Testing issue 09-03 */
					echo (int)$invoice_detail->total_amount;
					?>
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
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		<div class="form-group">
			<div class="modal-footer">
			<center>
			<?php if((!empty(invoice_detail) && $invoice_detail->save_status ==1)){ ?>
				<a href="<?php echo base_url(); ?>account/create_pdf/<?php echo $invoice_detail->id; ?>" target="_blank"><button class="btn btn-default">Generate PDF</button></a>
				<button class="btn btn-default sharevia_email_cls">Share Via Email</button>
			<?php } ?>
			<?php if((!empty(invoice_detail) && $invoice_detail->e_invoice_link)){ ?>
							<a href="<?php echo base_url(); ?>account/viewEinvoice/?url=<?php echo $invoice_detail->e_invoice_link; ?>" target="_blank"><button class="btn btn-default">E-Invoice</button></a>

						<?php } ?>
						<?php if((!empty(invoice_detail) && $invoice_detail->e_way_bill_link)){ ?>
							<a href="<?php echo base_url(); ?>account/viewEwayBill/?url=<?php echo $invoice_detail->e_way_bill_link; ?>" target="_blank"><button class="btn btn-default">E-Way Bill</button></a>

						<?php } ?>
				<button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
				<!--button type="reset" class="btn btn-default">Reset</button>
				<input type="submit" class="btn btn-warning" value="Submit"-->
				</center>
			</div>
		</div>

</div>
									</div>

								</div>

							</div>

						</div>

					</div>

			</div>

	<!-- Add Party Modal-->
	<div class="modal fade" id="myModal_share_email" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
           <div class="modal-content">
			<div class="modal-header">
	            <h4 class="modal-title" id="myModalLabel">Share</h4>
				<span id="mssg"></span>
			</div>
			<form name="form_share_viaEmail" name="share_form"  id="form_share_viaEmail_id">
                 <div class="modal-body">
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
				 <?php
				  $party_email =   getNameById('ledger',$invoice_detail->party_name,'id');
				//echo $party_email->email;
				 ?>
					<label class="col-md-2 col-sm-2 col-xs-4" for="name">Email<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" name="email_name" id="email_name" required="required" class="form-control col-md-7 col-xs-12" value="">
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="name">Message</label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">

						<textarea id="email_msg_id" name="email_msg"  class="form-control col-md-7 col-xs-12" placeholder="Message ...." ></textarea>
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				<?php
					echo '<input type="hidden" id="invoice_id" value="'.$invoice_detail->id.'">';
				?>
			    <div class="modal-footer">
					<input type="hidden" id="sale_ledger_data">
				    <button type="button" class="btn btn-default close_sec_model" >Close</button>
					<button id="share_via_Email_invoice" type="button" class="btn btn-warning">Submit</button>
                </div>
			</form>
         </div>
        </div>
    </div>
</div>

<!-- Add Party Modal-->
