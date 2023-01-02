<style>
.removie-padding {
    padding: 0px;
}
.page-title,.clearfix {
    display: none;
}

</style>

<div class="x_content">
	<div class="row hidde_cls">
		
			<p class="text-muted font-13 m-b-30"></p>
			<div class="row hidde_cls">
				<div class="col-md-12">
					<center>
					<div class="export_div">
					    <div class="col-md-3 datePick-left col-xs-12 col-sm-12">               
							<fieldset>
								<div class="control-group">
								  <div class="controls">
									<div class="input-prepend input-group">
									  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
									  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/invoices"/>
									</div>
								  </div>
								</div>
							</fieldset>
							<form action="<?php echo base_url(); ?>account/invoices" method="post" id="date_range">	
							   <input type="hidden" value='' class='start_date' name='start'/>
							  <input type="hidden" value='' class='end_date' name='end'/>
							</form>	
						</div>
						<div class="btn-group"  role="group" aria-label="Basic example">
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
							<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
								<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu" id="export-menu">
										<li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
										<li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
										<!--li id="export-to-pdf"><a href="javascript:void(0);" title="Please check your open office Setting">Export to Pdf</a></li-->
										<li id="export-to-blank-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to Blank Excel</a></li>
									</ul>
							</div>
						</div>
						<div class="col-md-3 datePick-right col-xs-12 col-sm-12">
			<form action="<?php echo base_url(); ?>account/invoices" method="post" id="date_range">	
				 <input type="hidden" value='' class='start_date' name='start'/>
				 <input type="hidden" value='' class='end_date' name='end'/>
			</form>
				<form action="<?php echo site_url(); ?>account/invoices" method="post" id="export-form">
					<input type="hidden" value='' id='hidden-type' name='ExportType'/>
					<input type="hidden" value='' class='start_date' name='start'/>
					<input type="hidden" value='' class='end_date' name='end'/>
				</form>
				<form action="<?php echo site_url(); ?>account/Create_invoice_blankxls" method="post" id="export-form-blank">
					<input type="hidden" value='' id='hidden-type-blank-excel' name='ExportType_blank'/>
				</form>
				<form action="<?php echo site_url(); ?>account/create_pdf_all" method="post" id="export-form-pdf">
					<input type="hidden" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>"  name="login_c_id">
					<input type="hidden" value='' class='start_date' name='start'/>
					<input type="hidden" value='' class='end_date' name='end'/>
				</form>
				<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo3" aria-expanded="true">Import<span class="caret"></span></button>
				<?php if($can_add) {
					echo '<button type="button" class="btn btn-primary add_invoice_details" data-toggle="modal" id="add" data-id="invoice_details">Add</button>';
				} ?>
				<div id="demo3" class="collapse " aria-expanded="true" style="">
					<table  class="table table-striped table-bordered" data-id="account">
						<thead>
							<tr><th>Upload Invoices excel file</th></tr>
						</thead>
							<tbody>
								<tr>
									<td>
										<form action="<?php echo base_url();?>account/import_invoices" method="post" enctype="multipart/form-data">
											<input type="file" name="uploadFile" value="" />
											<input type="submit" name="upload_invoices_data" value="Upload" class="btn btn-primary" />
										</form>
									</td>
								</tr>
							</tbody>
					</table>
				</div>
			</div>
					</div>
					</center>
				</div>
			</div>
	</div>
	
	
	<div class="col-md-3 left-ember">
	 <ul id="ember2342" class="ember-view">        <li id="invoice-1129551" class="clickable active paid standard ember-view"><div class="row">
					  <h3>test</h3>
					  <div class="balance">
						<span id="ember2343" class="ember-view">  <span id="ember2344" class="ember-view">₹ <span id="ember2345" class="ember-view">0.00</span></span>
					</span>
					  </div>
					</div>

					<div class="row">
					  <div class="extra">
						<span class="identifier">INVOICE_38</span>
						<span>–</span>
						<span class="date"><span id="ember2346" class="sb-date ember-view">05 - Apr - 2020
					</span></span>
					  </div>
					  <div class="document-status invoice-status">
						<div id="ember2347" class="ember-view status-icon paid-status-icon icon-tooltip"><i class="fa fa-envelope" aria-hidden="true"></i>

					<!----></div>
					<div id="ember2349" class="status-icon paid-status-icon icon-tooltip ember-view"><i class="fa fa-pencil"></i>

					<!----></div>
					<div id="ember2350" class="status-icon type-icon icon-tooltip ember-view"><i class="fa fa-ioxhost"></i></div>
					  </div>
					</div>
					</li>

</ul>
	
	</div>
	<div class="col-md-9 invoice-view">
	
	  
						  
			<div class="status-ribbon">Paid</div>
				<div class=" form-group-2">
				
					<input type="hidden" name="id" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->id; ?>">
					
						
							<div>
							<?php
							setlocale(LC_MONETARY, 'en_IN');
							?>
							
							     
								
								<div>
									<div class="col-md-5 col-sm-6 col-xs-12 form-group label-left">
									<h3 class="Material-head"><?php if(!empty($invoice_detail)){
									  $sale_ledger_name = getNameById('ledger',$invoice_detail->sale_ledger,'id');
									 echo $sale_ledger_name->name;
										}?> </strong></h3>
										<div class="col-md-12 col-sm-12 col-xs-12 ">
										       <?php
																		$party_ledger = getNameById('ledger',$invoice_detail->party_name,'id');
	 																	   $party_add = json_decode($party_ledger->mailing_address,true);
																			   foreach ($party_add as $key => $detaild) {
																					if ($detaild['mailing_state'] == $invoice_detail->party_state_id) {
																						$mailing_address11 = $detaild['mailing_address'];
																						
																					}
																			   }
																	?>
																	<label>Party Mailing Address:</label><?php echo $mailing_address11; ?>
										       </div>
											   <div class="col-md-12 col-sm-12 col-xs-12 "><label>Buyer Order number:</label><?php if(!empty($invoice_detail)) echo $invoice_detail->buyer_order_no; ?></div>
										
										 <div class="col-md-12 col-sm-12 col-xs-12 ">
											   <label>Party Email:</label><?php 
																	  // pre($invoice_detail);
																	  
																	  if(!empty($invoice_detail)) echo $invoice_detail->email; ?>
										</div>
										
									
										
										<div class="col-md-12 col-sm-12 col-xs-12 ">
										       <label>Party:</label>
											   <?php
																	  if(!empty($invoice_detail)){
																		  $party_name = getNameById('ledger',$invoice_detail->party_name,'id');
																		 echo $party_name->name;
																	  }
																		?>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12 form-group">
										       <label>Dispatch Number:</label>
											   <?php if(!empty($invoice_detail)) echo $invoice_detail->dispatch_document_no ; ?>
										</div>
										
										
									</div>
									<div class="col-md-7 col-sm-6 col-xs-12 form-group label-left">
									<div class="col-md-12 col-sm-12 col-xs-12 form-group Material-head data">
										       <label>INVOICE</label>
											   <?php if(!empty($invoice_detail)) echo $invoice_detail->invoice_num; ?>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12 form-group data-date">
										       <label>Invoice Date</label>
											   <?php if(!empty($invoice_detail)) echo $invoice_detail->date_time_of_invoice_issue; ?></div>
										<!--<div class="col-md-12 col-sm-12 col-xs-12 form-group">
										       <label>Sale Ledger</label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group"></?php
																	  if(!empty($invoice_detail)){
																		  $sale_ledger_name = getNameById('ledger',$invoice_detail->sale_ledger,'id');
																		 echo $sale_ledger_name->name;
																	  }
																		?></div>
										</div>-->
										<div class="col-md-10 col-sm-12 col-xs-12 form-group blog-right">
										                           <?php
																		$get_party_state_data = getNameById('state',$invoice_detail->party_state_id,'state_id');
																		$party_ledger_purchaser11 = $get_party_state_data->state_name;				
																	?>
										       <label>Party Sate</label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php echo $party_ledger_purchaser11; ?></div>
										</div>
										<div class="col-md-10 col-sm-12 col-xs-12 form-group blog-right">
										       <label>Transport</label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail->transport)) { echo $invoice_detail->transport;}else{ echo 'N/A';} ?></div>
										</div>
										<div class="col-md-10 col-sm-12 col-xs-12 form-group blog-right">
										       <label>Vehicle Number</label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php  if(!empty($invoice_detail->vehicle_reg_no)){ echo $invoice_detail->vehicle_reg_no;}else{echo 'N/A';} ?></div>
										</div>
										<div class="col-md-10 col-sm-12 col-xs-12 form-group blog-right">
										       <label>Driver Phone Number</label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail->transport_driver_pno)){echo $invoice_detail->transport_driver_pno;}else{echo 'N/A';} ?></div>
										</div>
										<div class="col-md-10 col-sm-12 col-xs-12 form-group blog-right">
										       <label>Terms of Delivery</label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail->terms_of_delivery)){ echo $invoice_detail->terms_of_delivery;}else{echo 'N/A';} ?></div>
										</div>
										<div class="col-md-10 col-sm-12 col-xs-12 form-group blog-right">
										       <label>Pan</label>
											   <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($invoice_detail)) echo $invoice_detail->pan; ?></div>
										</div>
									</div>
									
									<div class="col-md-12 col-sm-12 col-xs-12 removie-padding">
									
										<div class="x_content">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">

	<div id="myTabContent" class="tab-content">
		<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
			<div class="col-md-12 col-sm-12 col-xs-12 removie-padding">
			<div class="table-responsive">
				
						<div class="table-responsive">
						
						 <div class="label-box mobile-view3">			  
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label" style="border-left: 1px solid #c1c1c1;">Item & Description</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">HSN/SAC</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Quantity</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Rate</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Taxable Amt.</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Dis' Type</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Dis' Amount</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">After Dis'</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Tax</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">UOM</div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Amount with Tax</div>
						 </div>      
						 
						   
						  <?php
							$invoice_matrial_details = json_decode($invoice_detail->descr_of_goods,true);
							$subtotal_all_invoice =0;
							foreach($invoice_matrial_details as $invoice_Data){ 
							
								$meterial_data = getNameById('material',$invoice_Data['material_id'],'id');
							?>
							<div class="row-padding col-container mobile-view view-page-mobile-view">
								  <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1 !important;">
								  <label>Item & Description</label>
								  <span><?php echo '<b>'.$meterial_data->material_name.'</b><br/>'.substr($invoice_Data['descr_of_goods'], 0, 50);?></span></div>
								 
								  <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>HSN/SAC</label><span><?php echo $invoice_Data['hsnsac']; ?></span></div>
								 <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Quantity</label><span><?php echo $invoice_Data['quantity']; ?></span></div>
								  <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Rate</label><span><?php echo $invoice_Data['rate']; ?></span></div>
								  <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Taxable Amt.</label><span><?php echo $taxable_amt = $invoice_Data['quantity'] * $invoice_Data['rate']; ?></span></div>
								  <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Discount Type</label><span><?php
								 if($invoice_Data['disctype'] == 'disc_precnt'){
										echo 'Percentage ( '. $invoice_Data['discamt']. ' % )';
									 }elseif($invoice_Data['disctype'] == 'discamt'){
										echo 'Discount Value ( '. $invoice_Data['discamt'] .' )';
									 }else{
										 echo 'N/A';
									 }
										 
								 ?></span></div>
								  <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Discount Amount</label><span><?php 
								
								 if($invoice_Data['discamt'] != ''){ 
											if($invoice_Data['disctype'] == 'disc_precnt'){
												$basic_amt = $invoice_Data['quantity']* $invoice_Data['rate'];
												$total_amt_in_percent = $basic_amt * $invoice_Data['discamt']/100;
												echo $total_amt_in_percent;
											}else{
												echo $invoice_Data['discamt'];
											}
										} else { 
											echo 'N/A'; 
										} 
									?></span></div>
								
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group">
								    <label>After Discount</label>
								  <span><?php 
								  
										if($invoice_Data['disctype'] !=''){
											if($invoice_Data['disctype'] == 'disc_precnt'){
											$basic_amt = $invoice_Data['quantity'] * $invoice_Data['rate'];
											$total_amt_in_percent = $basic_amt * $invoice_Data['discamt']/100;
											echo $taxable_amt - $total_amt_in_percent;
										}else{
											echo $taxable_amt - $invoice_Data['discamt'];
										}
										}else{
											echo 'N/A';
										}		
									?></span>	
							  </div>
							  <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Tax</label><span><?php echo $invoice_Data['tax']; ?></span></div>
							 <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>UOM</label><span><?php echo $invoice_Data['UOM']; ?></span></div>
								 <?php
									$subtotal_invoice_amt = $invoice_Data['quantity'] * $invoice_Data['rate'];
									 $subtotal_all_invoice 	+= $subtotal_invoice_amt;
											
								 ?>
								  <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Amount with Tax</label><span><?php if($invoice_Data['disctype'] == ''){ 
								 //echo number_format($subtotal_invoice_amt);
								//echo number_format((float)$subtotal_invoice_amt, 2, '.', '');
								echo money_format('%!i',$subtotal_invoice_amt);
								 }else{echo  $invoice_Data['amount_with_tax_after_disco'];}?></span></div>
							</div>
					<?php  } ?>
						   <div class="row-padding col-container mobile-view view-page-mobile-view">
							<?php 
							$data_charges_json = json_decode($invoice_detail->charges_added,true);
							// 
							if($data_charges_json !=''){
								$charge_subtotal = 0;
								$charges_total_for_outside = 0;
							   
								foreach($data_charges_json as $charge_Data1){
									
									$charges_name = getNameById('charges_lead',$charge_Data1['particular_charges_name'],'id');
									if(!empty($charges_name)){
									$charge_subtotal = $charge_Data1['amt_with_tax'] -  $charge_Data1['charges_added'];
									$total_added_charges = $charge_Data1['charges_added'];
									if($charges_name->type_charges == 'plus'){
										$charges_total_for_outside += $total_added_charges;
										$charges_total_tax_outside += $charge_subtotal;
									}
									
									  if($charges_name->type_charges == 'plus'){
							?>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1 !important;"><?php echo $charges_name->particular_charges . ' ' .$charges_name->tax_slab.' %'; ?></div>
									  <?php }else{ ?>
									  
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><?php echo $charges_name->particular_charges; ?></div>	  
									  <?php } ?>
						   
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><?php echo $charges_name->hsnsac; ?></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group">>N/A</div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><?php if($charges_name->tax_slab != 'Select Tax Slab'){echo $charges_name->tax_slab;}else{echo 'N/A';}; ?></div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
							<div class="col-md-1 col-sm-12 col-xs-12 form-group"><b> <?php  echo money_format('%!i',$total_added_charges); ?></b></div>
							</div>
							<?php
								}	
								} 
								}?>	
							
						  
						  
						  </div>
						
				
				<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both;  padding:0px; margin-bottom: 40px;" >


								<div class="col-md-5 col-sm-5 col-xs-12 text-right total-blog">
									
								<div class="col-md-12 col-sm-5 col-xs-12 text-right" style="padding: 0px;">
									
									
									<div class="col-md-6 col-sm-5 col-xs-6 text-left-1">
										Total : 
										</div>
								   <div class="col-md-6 text-left">
									<?php 
							
							 $amount_details = json_decode($invoice_detail->invoice_total_with_tax,true);
							
							//echo $subtotal_invoice_amt;
								if(!empty($data_charges_json)){
								$charge_amount_add = $charges_total_for_outside;
								}else{
									$charge_amount_add = 0;
								}
								//echo $charge_amount_add;
								$total_add = $amount_details[0]['total'] + $charge_amount_add;
							?>
								   <?php 
											//echo $total_add;
											//echo number_format((float)$total_add, 2, '.', '');
											echo money_format('%!i',$total_add);
												
											?></div>	
										 
									<div class="col-md-6 col-sm-5 col-xs-6 text-left-1">
										Tax : 
									</div>
									<div class="col-md-6 text-left">
										 <?php
											if(!empty($data_charges_json)){
												$charges_tax = $charges_total_tax_outside;
												}else{
													$charges_tax  = 0;
												}
												
												$tax_total3 = $amount_details[0]['totaltax'] + $charges_tax;

											
											echo money_format('%!i',$tax_total3);
											?>
									</div>
									 <?php
									 if($amount_details[0]['cess_all_total'] != 0 || $amount_details[0]['cess_all_total'] != ''){
									 ?>
									 <div class="col-md-6 col-sm-5 col-xs-6 text-left-1">
										CESS : 
									</div>
									<div class="col-md-6 text-left">
										   <?php 
											$cess_AMT = $amount_details[0]['cess_all_total'];
										
											echo money_format('%!i',$cess_AMT);
											?>
									</div>
									<?php } ?>
									<div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2">
									<div class="col-md-6 col-sm-5 col-xs-6 form-group text-left-1">
										Grand Total : 
										</div>
										<div class="col-md-6 text-left form-group"><?php 
							
											$prpr_totl = $total_add + $tax_total3 + $cess_AMT; 
											echo money_format('%!i',$prpr_totl);
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
				<!-- <div class="ln_solid"></div>----->
				
					<div class="form-group">
						<div class="modal-footer">
						<center>
						<?php if((!empty(invoice_detail) && $invoice_detail->save_status ==1)){ ?>
							<a href="<?php echo base_url(); ?>account/create_pdf/<?php echo $invoice_detail->id; ?>" target="_blank"><button class="btn btn-default">Generate PDF</button></a>
							<button class="btn btn-default sharevia_email_cls">Share Via Email</button>
						<?php } ?>
							
							</center>
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
						
						<textarea id="email_msg_id" name="email_msg"  class="form-control col-md-7 col-xs-12" placeholder="Message ..." ></textarea>
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
<!-- Add Party Modal-->

			
	       
	
	</div>
	
	
</div>
<div id="add_invoice_detail_modal" class="modal fade in"  role="dialog">  
	<div class="modal-dialog  modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Add Invoice Detail</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>

<div id="add_invoice_report_modal" class="modal fade in "  role="dialog">  
	<div class="modal-dialog modal-lg modal-large child-modal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Invoice Report</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
<?php $this->load->view('common_modal'); ?>
