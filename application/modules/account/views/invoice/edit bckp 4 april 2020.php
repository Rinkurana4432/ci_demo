<?php //if($_SESSION['loggedInUser']->role != 2){
	?>						  
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saveInvoice_Details" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
		<input type="hidden" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="login_user_idddd">
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<input type="hidden" name="save_status" value="1" class="save_status">
				<input type="hidden" name="id" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->id; ?>">
				
<div class="container mt-3">

  <!-- Nav tabs -->
  <ul class="nav tab-3 nav-tabs">
    <li class="nav-item active">
      <a class="nav-link " data-toggle="tab" href="#Information1"><strong>Invoice Information </strong></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#Information2"><strong>Delivery Information </strong></a>
     </li>

  </ul>
  <div class="tab-content">	
 <div id="Information1" class="container tab-pane active">
 <div class="panel panel-default">
						
						<div class="panel-body">
						<input type="hidden" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="company_login_id">
						<div class="col-sm-6 col-md-6 col-xs-12 vertical-border">
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Party Name<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<select class="itemName form-control selectAjaxOption select2 add_option party_name_ledger_id_onchange" id="get_add_more_btn" required="required" name="party_name" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND created_by_cid != 0 )"  width="100%"> 										
											<option value="">Select</option>			
											<?php
												if(!empty($invoice_detail)){
													$party_name = getNameById('ledger',$invoice_detail->party_name,'id');
													echo '<option value="'.$party_name->id.'" selected>'.$party_name->name.'</option>';
												} 	
											?>    
										</select> 	
									</div>
							</div>
							<div class="item form-group">
									<label class="col-md-3 col-sm-12 col-xs-12" for="Addresses">Party Address<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
									   <select name="party_state_id" id="P_address" class="itemName form-control" required="required">
									   <option value="">Select Address</option> 
											<?php
												if(!empty($invoice_detail)){
													$party_name = getNameById('ledger',$invoice_detail->party_name,'id');
													//$party_address = getNameById('invoice',$invoice_detail->party_state_id,'id');
													$add_dtl = JSON_DECODE($party_name->mailing_address,true);
													
													foreach($add_dtl as $ad_dtl){
														
														// echo '<option value="'.$ad_dtl['mailing_state'].'" selected>'.$ad_dtl['mailing_address'].'</option>';
														$selected = ($ad_dtl['mailing_state'] == $invoice_detail->party_state_id) ? ' selected="selected"' : '';
														echo '<option value="'.$ad_dtl['mailing_state'].'"  "'.$selected.'" data-gst="'.$ad_dtl['gstin_no'].'">'.$ad_dtl['mailing_address'].'</option>';
													}
													
												} 
											?>
										
									   </select>
									</div>
								</div>
							
								<div class="item form-group">
									<label class="col-md-3 col-sm-12 col-xs-12" for="name">Consignee Address</label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<input type="checkbox"  name="consignee_address_check"  class="js-switch" id="consignee_address_check" <?php if(!empty($invoice_detail->consignee_address)) {echo "checked";}?>>Check For Different Consignee Address
									</div>
								</div>
								<?php if(!empty($invoice_detail)){?>
								<div class="item form-group address" id="consignee_address">
									<label class="col-md-3 col-sm-12 col-xs-12" for="address_c">Name & Address</label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<textarea id="consignee_address" name="consignee_address"  class="form-control col-md-7 col-xs-12" placeholder="consignee_address" ><?php   echo $invoice_detail->consignee_address; ?></textarea>
									</div>
								</div>
								<?php }else{?>
								<div class="item form-group" id="consignee_address" style="display:none;">
									<label class="col-md-3 col-sm-12 col-xs-12" for="address_c">Name & Address</label>
									<div class="col-md-6 col-sm-12 col-xs-12">
									<textarea id="consignee_address" name="consignee_address"  class="form-control col-md-7 col-xs-12" placeholder="consignee_address" ></textarea>
									</div>
								</div>
								<?php }?>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Sale Ledger<span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<?php
										$party_name3 = getNameById_bywith_ledgers('ledger',$_SESSION['loggedInUser']->c_id,'created_by_cid');
									?>
									<select class="itemName form-control selectAjaxOption select2 sale_ledger_id_onchange" id="get_add_more_btn_forsale_ledger" required="required" name="sale_ledger" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND account_group_id = 7)"  width="100%"> 
										<option value="">Select</option>			
											<?php
											if(empty($invoice_detail)){
												echo '<option value="'.$party_name3->id.'" selected>'.$party_name3->name.'</option>';
											}
											if(!empty($invoice_detail)){
													$party_name = getNameById('ledger',$invoice_detail->sale_ledger,'id');
													echo '<option value="'.$party_name->id.'" selected>'.$party_name->name.'</option>';
												} 
										?>    
										</select> 	
								</div>
							</div>
	                    	<input type="hidden"  id="sale_ledger_company_branch_id" name="sale_lger_brnch_id">
	                    	<!--input type="hidden"  id="sale_ledger_state_id" name="sale_ledger_state_id"-->
	                    	<input type="hidden"  id="sale_leger_gstin_no" name="sale_leger_gstin_no" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->sale_leger_gstin_no; ?>">
							
							
							<input type="hidden" value="<?php if(!empty($invoice_detail)){ echo $invoice_detail->party_state_id; } ?>" id="party_billing_state_id" name="party_billing_state_id">
									
							<input type="hidden" value="<?php if(!empty($invoice_detail)){  echo $invoice_detail->sale_L_state_id;  }?>" id="sale_company_state_id" name ="sale_company_state_id">
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Sale Address</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<select name="sale_L_state_id" id="sale_address" class="itemName form-control" required="required">
									   <option value="">Select Address</option> 
											<?php
												if(!empty($invoice_detail)){
													$saleLedger_address = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
												//pre($saleLedger_address);
													$add_dtl = JSON_DECODE($saleLedger_address->address,true);
													
													foreach($add_dtl as $ad_dtl_Sale){
													
														$selected = ($ad_dtl_Sale['state'] == $invoice_detail->sale_L_state_id) ? ' selected="selected"' : '';
														
														echo '<option value="'.$ad_dtl_Sale['state'].'"  "'.$selected.'" data-gst="'.$ad_dtl_Sale['company_gstin'].'" branh-id = "'.$ad_dtl_Sale['add_id'].'" >'.$ad_dtl_Sale['compny_branch_name'].'</option>';
													}
													
												} 
											?>
										
									   </select>
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Buyer Order No</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="buyer_order_no" name="buyer_order_no"   class="form-control col-md-7 col-xs-12" placeholder="Buyer Order No." value="<?php if(!empty($invoice_detail)) echo $invoice_detail->buyer_order_no; ?>">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Buyer Order Date</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="buyer_order_date" name="buyer_order_date"   class="form-control col-md-7 col-xs-12" placeholder="Buyer Order Date." value="<?php if(!empty($invoice_detail)) echo $invoice_detail->buyer_order_date; ?>">
								</div>
							</div>
							</div>
							<div class="col-sm-6 col-md-6 col-xs-12 vertical-border">
							<div class="item form-group">
                                <label class="col-md-3 col-sm-12 col-xs-12" for="date_time_of_invoice_issue">Invoice Number<span>*</span></label>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <input type="text"  name="invoice_num" id="invoice_num" Placeholder="Invoice Number" class="form-control col-md-7 col-xs-12" required="required" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->invoice_num; ?>">
                                </div>
							</div>
							
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="type">Transport Tel No. </label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="tel" id="transport_driver_pno" name="transport_driver_pno"  class="form-control col-md-7 col-xs-12" placeholder="Transport Tel No." value="<?php if(!empty($invoice_detail)) echo $invoice_detail->transport_driver_pno; ?>">
								</div>
							</div>
							<div class="item form-group">
                                <label class="col-md-3 col-sm-12 col-xs-12" for="date_time_of_invoice_issue">e-way bill number</label>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <input type="text"  name="eway_bill" id="eway_bill_no" Placeholder="e-way bill number" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($invoice_detail)) echo $invoice_detail->eway_bill_no; ?>">
									<span id="eway_bill_msg" style="color:red;"></span>
                                </div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="type">Vehicle Number</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="tel" id="vehicle_reg_no" name="vehicle_reg_no"  class="form-control col-md-7 col-xs-12" placeholder="Vehicle Number" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->vehicle_reg_no; ?>">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="date_time_of_invoice_issue">Date Time issue of Invoice<span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12">
								
									<input type="hidden" id="date12"  name="v_date"  class="form-control col-md-7 col-xs-12" placeholder="Date" value="<?php if(!empty($invoice_detail)){ echo $invoice_detail->v_date;} ?>" autocomplete="off">
									<?php
									date_default_timezone_set('Asia/Kolkata');
									
									?>
									<input type="text" id="date_time_of_invoice_issue" name="date_time_of_invoice_issue" required="required" class="form-control col-md-7 col-xs-12" placeholder="Issue of Invoice" value="<?php
										if(!empty($invoice_detail)) echo $invoice_detail->date_time_of_invoice_issue;
										if(empty($invoice_detail)){ echo date('d-m-Y');}
										?>" autocomplete="off">
									
								</div>
							</div>
							
							<div class="item form-group">
								<!--label class="col-md-3 col-sm-12 col-xs-12" for="type">Mode of Payment</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<!--input type="text"   name="mode_of_payment" required="required" class="form-control col-md-7 col-xs-12" placeholder="Mode of Payment" value="<?php //if(!empty($invoice_detail)) echo $invoice_detail->mode_of_payment; ?>"-->
									<!--select name="mode_of_payment" class="form-control col-md-7 col-xs-12" >
									<option value=""> Select Mode of Payment </option>
										<option value="cash" <?php //if(!empty($invoice_detail)) if($invoice_detail->mode_of_payment == 'cash'){echo 'selected';} ?>>Cash</option>
										<option value="advance" <?php //if(!empty($invoice_detail)) if($invoice_detail->mode_of_payment == 'advance'){echo 'selected';} ?>>Advance</option>
										<option value="credit" <?php //if(!empty($invoice_detail)) if($invoice_detail->mode_of_payment == 'credit'){echo 'selected';} ?>>Credit </option>
										
									</select>
								</div-->	
									
									
									
									
									
									
									<input type="hidden" value="<?php if(!empty($invoice_detail)){ echo $invoice_detail->reject_invoice;} ?>" name="reject_invoice">
									<input type="hidden" value="<?php if(!empty($invoice_detail)){ echo $invoice_detail->accept_reject;} ?>" name="accept_reject">
									<input type="hidden" value="<?php if(!empty($invoice_detail)){ echo $invoice_detail->party_conn_company;} ?>" name="party_conn_company" id="conn_company_id">
										
								
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Party Phone</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="party_phone" name="party_phone" class="form-control col-md-7 col-xs-12" placeholder="Party Phone No." value="<?php if(!empty($invoice_detail)) echo $invoice_detail->party_phone; ?>">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="type">Invoice Type</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
								
									<select name="invoice_type" id="invoice_type_id" class="form-control col-md-7 col-xs-12">
										<option value=""> Select Invoice Type </option>
										<option value="export_invoice" <?php if(!empty($invoice_detail)){ if($invoice_detail->invoice_type == 'export_invoice'){echo 'selected';} }?>>Export Invoice</option>
										<option value="domestic_invoice" <?php if(!empty($invoice_detail)) {if($invoice_detail->invoice_type == 'domestic_invoice'){echo 'selected';} }elseif(empty($invoice_detail)){echo 'selected';}?>>Domestic invoice</option>
									</select>
								</div>	
							</div>
								<div class="exprt_div" <?php if(!empty($invoice_detail) && $invoice_detail->invoice_type == 'export_invoice' ){ echo 'style="display: block"';}else{ echo 'style="display: none"';} ?>>
									<div class="item form-group">
										<label class="col-md-3 col-sm-12 col-xs-12" for="port">Port of Loading</label>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<input type="text" id="port_loading"  name="port_loading"  class="form-control col-md-7 col-xs-12" placeholder="Port loading" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->port_loading; ?>">
										</div>
									</div>
									
									<div class="item form-group">
										<label class="col-md-3 col-sm-12 col-xs-12" for="port">Port of Discharge</label>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<input type="text" id="port_discharge"  name="port_discharge"  class="form-control col-md-7 col-xs-12" placeholder="Port discharge" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->port_discharge; ?>">
										</div>
									</div>
								</div>
							</div>
								
							
						</div>
					</div>
</div>
 <div id="Information2" class="container tab-pane">
 <div class="col-md-12 col-sm-12 col-xs-12 form-group" style="padding: 0px;">
				<div class="panel panel-default">
						
						<div class="panel-body">
					<div class="col-sm-6 col-md-6 col-xs-12">
						<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="type">Transport Type </label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="transport" name="transport"  class="form-control col-md-7 col-xs-12" placeholder="Transport Type" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->transport; ?>">
								</div>
							</div>
						
						
						
						<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="date_time_of_invoice_issue">Email</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="email_id" name="email" class="form-control col-md-7 col-xs-12" placeholder="Email" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->email; ?>">
								</div>
							</div>
							
								
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="date_time_removel_of_goods">Date Time Removal of Goods</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="date_time_removel_of_goods" name="date_time_removel_of_goods" class="form-control col-md-7 col-xs-12" placeholder="Removal of Goods" value="<?php if(!empty($invoice_detail)){ echo $invoice_detail->date_time_removel_of_goods;}else{ echo date('d-m-Y');} ?>" autocomplete="off">
								</div>
							</div>									
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="pan">Dispatch Document Number</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input id="pan" class="form-control col-md-7 col-xs-12" data-validate-length-range="4"  value="<?php if(!empty($invoice_detail)) echo $invoice_detail->dispatch_document_no; ?>" name="dispatch_document_no" placeholder="Dispatch Document Number"  type="text"> 
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="pan">Dispatch Document Date</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input id="dispatch_document_date" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($invoice_detail)) echo $invoice_detail->dispatch_document_date; ?>" name="dispatch_document_date" placeholder="Dispatch Document Date"  type="text"> 
								</div>
							</div>
						</div>	
					<div class="col-sm-6 col-md-6 col-xs-12">
							<div class="item form-group">
                                <label class="col-md-3 col-sm-12 col-xs-12" for="gr">GR No.</label>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <input id="grno" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($invoice_detail)) echo $invoice_detail->gr_no; ?>" name="gr_no" placeholder="GR number"  type="text">
                                </div>
                            </div>
                            
                            <div class="item form-group">
                                <label class="col-md-3 col-sm-12 col-xs-12" for="grDate">GR Date</label>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                      <!--input type="text" id="date" data-validation="date" name="gr_date"  class="form-control col-md-7 col-xs-12" placeholder="GR Date" value="<?php //if(!empty($invoice_detail)) echo $invoice_detail->gr_date; ?>"-->
									<input type="text" id="date12" name="gr_date"  class="form-control col-md-7 col-xs-12" placeholder="GR Date" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->gr_date; ?>" autocomplete="off">
                                </div>
                            </div>
							
							
							
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="pan">Company PAN</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input id="pan" class="form-control col-md-7 col-xs-12" data-validate-length-range="10"  value="<?php if(!empty($invoice_detail)) echo $invoice_detail->pan; ?>" name="pan" placeholder="ABCDFA87565B"  type="text"> 
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="gstin">GSTIN</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input id="gstin" class="form-control col-md-7 col-xs-12" data-validate-length-range="15"  value="<?php if(!empty($invoice_detail)) echo $invoice_detail->gstin; ?>" name="gstin" placeholder="EKKPPLO87565B"  type="text"> 
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="terms_of_delivery">Terms of Delivery</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<textarea id="terms_of_delivery"  name="terms_of_delivery" class="form-control col-md-7 col-xs-12" placeholder="Terms of Delivery"><?php if(!empty($invoice_detail)) echo $invoice_detail->terms_of_delivery; ?></textarea>
								</div>
							</div>
						</div>
						</div>
					</div>
				
				</div>
			</div>
		</div> 
</div>  
<hr>
<div class="bottom-bdr"></div>				
				
					
				
			</div>
				
<div class="container mt-3">

  <!-- Nav tabs -->
  <!--<ul class="nav tab-3 nav-tabs">
    <li class="nav-item active">
      <a class="nav-link " data-toggle="tab" href="#Description"><strong>Description</strong><span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span></a>
    </li>
<li class="nav-item">
      <a class="nav-link " data-toggle="tab" href="#Charges"><strong>Add Charges / Discount</strong></h3></a>
    </li>
   
  

  </ul>-->
  <h3 class="Material-head" style="margin-bottom: 30px;">Description<hr></h3>
<div class="tab-content">
 <div id="Description" class="container tab-pane active">
       <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
					
					<div class="panel panel-default">
					<?php
					$get_discount_details = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
					
					?>
					
					<input type="hidden" value="<?php echo $get_discount_details->discount_on_off;?>" id="get_discount_on_off">
					<input type="hidden" value="<?php echo $get_discount_details->item_code_on_off;?>" id="item_code_on_off">
						<div class="panel-body goods_descr_wrapper">
							<div class="item form-group add-ro">
							<div class="col-md-12 input_descr_wrap label-box mobile-view2">
							<?php	if($get_discount_details->item_code_on_off == 1 ){ ?>
								<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo 'col-md-1';} ?> col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Item Code <span class="required">*</span></label>
								</div>
							<?php } ?>	
								<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo 'col-md-2';} ?> col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Material Name <span class="required">*</span></label>
								</div>
								<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo  'col-md-2';} ?> col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>
								</div>	
								<div class="col-md-1 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC </label>
								</div>	
								<div class="col-md-1 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="quantity">Quantity<span class="required">*</span></label>
								</div>	
								<div class="col-md-1 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="rate">Rate<span class="required">*</span></label>
								</div>
								<?php
									
									if($get_discount_details->discount_on_off == '1'){
								?>
								<div class="col-md-1 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Type">Disc. Type</label>
								</div>
								<div class="col-md-1 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Amount">Disc. Amt.</label>
								</div>
								<div class="col-md-1 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="Amount after desc">Amt. After Desc.</label>
								</div>
									<?php } ?>
								<div class="col-md-1 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="tax">Tax </label>
								</div>		
								<div class="<?php if($get_discount_details->discount_on_off == '1' ||  $get_discount_details->item_code_on_off){echo 'col-md-1';}else{echo  'col-md-2';} ?> col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label>
								</div>
								<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo  'col-md-2';} ?> col-xs-12 item form-group" style="overflow: hidden;">
									<label style="border-right: 1px solid #c1c1c1" class="col-md-12 col-sm-12 col-xs-12" for="amount">Amount with Tax<span class="required">*</span></label>
								</div>	
							
								
							</div>
							<input type="hidden" value="<?php if(!empty($invoice_detail)){ echo $invoice_detail->total_amount;} ?>" name="total_amount" class="total_amount_save" >
							<?php  if(empty($invoice_detail)){ ?>
								<div class="col-md-12 input_descr_wrap middle-box mobile-view mailing-box">
									<?php
									if($get_discount_details->item_code_on_off == 1 ){
									?>	
									<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo  'col-md-1';} ?> col-sm-12 col-xs-12 form-group">
									    <label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Item Code <span class="required">*</span></label>
										<input type="text" name="item_code[]"  class="form-control col-md-1 mat_item_code" placeholder="Item Code" value="" >
									</div>
								<?php  } ?>			
									<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo  'col-md-2';} ?> col-sm-12 col-xs-12 form-group">															
										<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Material Name <span class="required">*</span></label>
										<select class="itemName  form-control selectAjaxOption select2 get_val matrial_details_id" id="add_matrial_onthe_spot"  required="required" name="material_id[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND status=1" width="100%"> 										
											<option value="">Select</option>			
											<?php
											if(!empty($invoice_detail)){
											   $material_id_datas = json_decode($invoice_detail->material_id,true);
												// pre($material_id_datas);
												$material_names = '';
													foreach($material_id_datas  as $matrial_new_id){
														 $material_id_get = $matrial_new_id['material_id'];
														
															$meterial_data = getNameById('material',$material_id_get,'id');
															echo '<option value="'.$material_id_get.'" selected>'.$meterial_data->material_name.'</option>';
														}
													
													} 
											?>    
									</select> 
											<input type="hidden" name="mat_idd_name" id="matrial_Iddd">	
									</div>
									<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo  'col-md-2';} ?> col-sm-12 col-xs-12 form-group">	
									   <label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>														
										<input type="text" name="descr_of_goods[]"  class="form-control col-md-1" placeholder="Description Of Goods" value="">
										<!--textarea required="required" name="descr_of_goods[]"  class="form-control col-md-12 col-xs-12" placeholder="Description Of Goods"></textarea-->												
									</div>														
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">	 
									  <label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC </label>														
										<input type="text" name="hsnsac[]"  class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC" value="">														
									</div>														
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">	 
									<label class="col-md-12 col-sm-12 col-xs-12" for="quantity">Quantity<span class="required">*</span></label>													
										<input type="text" name="quantity[]" required="required" class="form-control col-md-1 year goods_descr_section keyup_event qty add_qty" placeholder="Quantity" value="">														
									</div>														
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="rate">Rate<span class="required">*</span></label>									
										<div class="checktr">
											<input type="text" name="rate[]" required="required" class="form-control col-md-1 goods_descr_section keyup_event rate" placeholder="Rate" value="" >
										</div>
									</div>
									<?php
										$get_discount_details = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
										if($get_discount_details->discount_on_off == '1'){
									?>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Type">Disc. Type</label>									
										<div class="checktr">
											<!--input type="text" name="disctype[]" class="form-control col-md-1 goods_descr_section" placeholder="Disc Type" value=""-->
											<select name="disctype[]" class="form-control disc_type_cls"> 
												<option value="">Select</option>
												<option value="disc_precnt">Discount Percent</option>
												<option value="disc_value">Discount Value</option>
											</select>
										</div>
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">	
									    <label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Amount">Disc. Amt.</label>
										<div class="checktr">
											<input type="text" name="discamt[]" class="form-control col-md-1 goods_descr_section added_discount_amt" readonly placeholder="Disc Amt" value="">
										</div>
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">	
									    <label class="col-md-12 col-sm-12 col-xs-12" for="Amount after desc">Amt. After Desc.</label>
										<div class="checktr">
											<input type="text" name="after_desc_amt[]" class="form-control col-md-1 goods_descr_section" readonly placeholder="After Disc Amt" value="">
										</div>
									</div>
										<?php } ?>
										
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="tax">Tax<span class="required">*</span></label>
										<div>
											<input type="text" name="tax[]"  class="form-control col-md-1 goods_descr_section tax tax_key_up_event" placeholder="Tax" value="" readonly >
											<input type="hidden" value="" name="added_tax" class="added_tax">
											<input type="hidden" value="" name="added_tax_Row_val[]" >
										</div>
									</div>
									<div class="<?php if($get_discount_details->discount_on_off == '1' ||  $get_discount_details->item_code_on_off){echo 'col-md-1';}else{echo  'col-md-2';} ?> col-sm-12 col-xs-12 form-group">
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label>									
										<div >
										<?php
											$uoms = measurementUnits();
											$uoms_Json = json_encode($uoms);
											
											
										?>
										<!--select name="UOM[]"  class="form-control col-md-1 goods_descr_section " readonly>
										<option value="">Select</option>
										<?php //foreach($uoms as $uom){ ?>
										<option value="<?php// echo $uom; ?>"><?php //echo $uom; ?></option>
										<?php //} ?>
										</select-->
										<input type="" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly>
										</div>
									</div>
									<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo  'col-md-2';} ?> col-sm-12 col-xs-12 form-group">
                                        <label style="border-right: 1px solid #c1c1c1" class="col-md-12 col-sm-12 col-xs-12" for="amount">Amount with Tax<span class="required">*</span></label>									
										<div>
											<input type="text"   name="amount[]" class="form-control col-md-1 goods_descr_section AMunt" readonly placeholder="Amount" value="">
											<input type="hidden" value="" name="sale_amount" class="sale_amount">
											<input type="hidden" value="" name="cess[]">
											<input type="hidden" value="" name="cess_tax_calculation[]">
											<input type="hidden" value="" name="valuation_type[]">
											
										</div>
									</div>
									
											
															
								</div>
                                <div class="col-sm-12 btn-row"><button class="btn btn-primary add_description_detail_button" type="button">Add</button></div>								
							<?php } 
							
							if(!empty($invoice_detail) && $invoice_detail->descr_of_goods !=''){
								
										$invoiceDetail = json_decode($invoice_detail->descr_of_goods);	
										
										if(!empty($invoiceDetail)){	
											$i = 0;
											foreach($invoiceDetail as $invoiceDetails){	
											
											// if($invoiceDetails->material_id!='' && $invoiceDetails->descr_of_goods!='' && $invoiceDetails->hsnsac!='' && $invoiceDetails->quantity !='' && $invoiceDetails->rate!='' && $invoiceDetails->amount!='' && $invoiceDetails->UOM!='' && $invoiceDetails->tax!=''){			
						
							
							?>
							
							<div class="col-md-12 input_descr_wrap middle-box mailing-box mobile-view <?php if($i==1){ echo 'scend-tr';}else{ echo 'edit-row1';}?>" style="margin-bottom: 0px; ">
							<?php	if($get_discount_details->item_code_on_off == 1 ){ ?>	
							<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo  'col-md-1';} ?> col-sm-12 col-xs-12 form-group">
                                  <label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Item Code <span class="required">*</span></label>
							      <input type="text" name="item_code[]"  class="form-control col-md-1 mat_item_code" placeholder="Item Code" value="<?php if(!empty($invoiceDetails)) echo $invoiceDetails->item_code; ?>" >
							</div>
							<?php } ?>	
							<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo  'col-md-2';} ?> col-sm-12 col-xs-12 form-group">															
									<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Material Name <span class="required">*</span></label>	
									<select class="itemName form-control selectAjaxOption select2 get_val matrial_details_id"  required="required" name="material_id[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" width="100%"> 										
											<option value="">Select</option>			
											<?php
											if(!empty($invoice_detail)){												
													$material = getNameById('material',$invoiceDetails->material_id,'id');
													echo '<option value="'.$invoiceDetails->material_id.'" selected>'.$material->material_name.'</option>';
											} 
													
												
											?>  
										</select> 	
									</div>
								<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo  'col-md-2';} ?> col-sm-12 col-xs-12 form-group">
								        <label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>
										<input type="text" name="descr_of_goods[]"  class="form-control col-md-1" placeholder="Description Of Goods" value="<?php if(!empty($invoiceDetails)) echo $invoiceDetails->descr_of_goods; ?>">
										<!--textarea  name="descr_of_goods[]" class="form-control col-md-12 col-xs-12" placeholder="Description Of Goods"></textarea-->												
								</div>														
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">	 
									    <label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC </label>														
										<input type="text" name="hsnsac[]" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC" value="<?php if(!empty($invoiceDetails)){ echo $invoiceDetails->hsnsac;} ?>" >														
									</div>														
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">	 
									    <label class="col-md-12 col-sm-12 col-xs-12" for="quantity">Quantity<span class="required">*</span></label>															
										<input type="text"  required="required" name="quantity[]" class="form-control col-md-1 year goods_descr_section keyup_event qty" placeholder="Quantity" value="<?php if(!empty($invoiceDetails)){ echo $invoiceDetails->quantity;} ?>">														
									</div>														
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="rate">Rate<span class="required">*</span></label>									
										<div class="checktr">
											<input type="text" name="rate[]" class="form-control col-md-1 goods_descr_section keyup_event rate" placeholder="Rate" value="<?php if(!empty($invoiceDetails)){ echo $invoiceDetails->rate;} ?>">
										</div>
									</div>
									
									<?php
										//$get_discount_details = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
										if($get_discount_details->discount_on_off == '1'){
									?>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Type">Disc. Type</label>									
										<div class="checktr">
											<!--input type="text" name="disctype[]" class="form-control col-md-1 goods_descr_section" placeholder="Disc Type" value=""-->
											<select name="disctype[]" class="form-control disc_type_cls"> 
												<option value="">Select</option>
												<option value="disc_precnt" <?php if($invoiceDetails->disctype == 'disc_precnt') { ?> selected="selected"<?php } ?> >Discount Percent</option>
												<option value="disc_value" <?php if($invoiceDetails->disctype == 'disc_value') { ?> selected="selected"<?php } ?> >Discount Value</option>
											</select>
										</div>
									</div>
									
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                         <label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Amount">Disc. Amt.</label>									
										<div class="checktr">
											<input type="text" name="discamt[]" class="form-control col-md-1 goods_descr_section added_discount_amt" readonly placeholder="Disc Amt" value="<?php if(!empty($invoiceDetails)){ echo $invoiceDetails->discamt;}  ?>">
										</div>
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="Amount after desc">Amt. After Desc.</label>
										<div class="checktr">
											<input type="text" name="after_desc_amt[]" class="form-control col-md-1 goods_descr_section" readonly placeholder="After Disc Amt" value="<?php if(!empty($invoiceDetails)){ echo $invoiceDetails->after_desc_amt;}  ?>">
										</div>
									</div>
									
								<?php  } ?>
								<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="tax">Tax</label>								
										<div class="checktr">
											<input type="text" name="tax[]" class="form-control col-md-1 goods_descr_section tax"   placeholder="Tax" value="<?php if(!empty($invoiceDetails)){ echo $invoiceDetails->tax;} ?>" readonly>
											<input type="hidden" value="" name="added_tax" class="added_tax" >
											<input type="hidden" value="<?php if(!empty($invoiceDetails)){ echo $invoiceDetails->added_tax_Row_val;} ?>" name="added_tax_Row_val[]" >
										</div>
									</div>	
								<div class="<?php if($get_discount_details->discount_on_off == '1' ||  $get_discount_details->item_code_on_off){echo 'col-md-1';}else{echo  'col-md-2';} ?> col-sm-12 col-xs-12 form-group">
									 <label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label>							
									<div>
										<?php
											$uoms = measurementUnits();
											$uoms_Json = json_encode($uoms);
											
											
										?>
										
										
										<input type="" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly value="<?php if(!empty($invoiceDetails)){ echo $invoiceDetails->UOM;} ?>">
									</div>
									</div>
									<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo  'col-md-2';} ?> col-sm-12 col-xs-12 form-group">
                                        <label style="border-right: 1px solid #c1c1c1" class="col-md-12 col-sm-12 col-xs-12" for="amount">Amount with Tax<span class="required">*</span></label>									
										<div>
											<input type="text" id="amount"   name="amount[]" class="form-control col-md-1 goods_descr_section AMunt" readonly placeholder="Amount" value="<?php if(!empty($invoiceDetails)){ echo $invoiceDetails->amount;} ?>" >
											
											<input type="hidden" value="<?php if(!empty($invoiceDetails)){ echo $invoiceDetails->cess;}  ?>" name="cess[]">
											<input type="hidden" value="<?php if(!empty($invoiceDetails)){ echo $invoiceDetails->cess_tax_calculation;}  ?>"
											name="cess_tax_calculation[]">
											<input type="hidden" value="<?php if(!empty($invoiceDetails)){ echo $invoiceDetails->valuation_type;}  ?>" name="valuation_type[]">
											<?php 
											if(!empty($invoiceDetails)){
												$saleAmount = $invoiceDetails->quantity *  $invoiceDetails->rate;
												echo '<input type="hidden" value="'.$saleAmount.'" name="sale_amount" class="sale_amount">';
											}
											?>
											
											
										
											
										</div>
									</div>
											
															
							
							<?php if($i==0){
												echo '<div class="col-sm-12 btn-row"><button class="btn btn-primary add_description_detail_button" type="button">Add</button></div>';
											}else{	
												echo '<button class="btn btn-danger remove_descr_field" type="button"> <i class="fa fa-minus"></i></button>';
											} ?>
								</div>
							<?php
							$i++;
								}} }?>								
						
						</div>
						</div>
					
					</div>
						
                    </div>
 </div>
 
 <hr>
<div class="bottom-bdr"></div>	

  <h3 class="Material-head" style="margin-bottom: 30px;">Add Charges / Discount<hr></h3>
  <div id="Charges" class="container tab-pane active">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="col-md-1 col-sm-1 col-xs-1 show_charges"  >Click to Add Charges</div>
						<div class="col-md-12 col-sm-12 col-xs-12 input_charges_wrap" style="padding: 0px;">
						<?php
						$charges_detail = json_decode($invoice_detail->charges_added);
						if($invoice_detail->charges_added !=''){
							$charges_detail = json_decode($invoice_detail->charges_added);
								if(!empty($charges_detail)){
								$kk = 0;
								foreach($charges_detail as $charges_details){
									if($charges_details->particular_charges_name !='' && $charges_details->charges_added !='' && $charges_details->amt_with_tax !='' ){
									
							?>
						   <div class="col-md-12 input_charges_details charges_form"   style="padding: 0px; display:block;">
						   	   <div class="testDh middle-box label-box mailing-box">
								<div class="col-md-2 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Particulars</label>
									<select class="itemName form-control selectAjaxOption select2 Add_charges_id"   required="required" name="particular_charges[]" data-id="charges_lead" data-key="id" data-fieldname="particular_charges" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND charges_for = 0" width="100%">
									<option value="">Select</option>			
											<?php
											if(!empty($invoice_detail)){												
													$charge_dtl = getNameById('charges_lead',$charges_details->particular_charges_name,'id');
													echo '<option value="'.$charge_dtl->id.'" selected>'.$charge_dtl->particular_charges.'</option>';
											} 
										?>  			
									</select> 	
								</div>	
								<div class="col-md-2 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Ledger Name.</label>
									<input type="text" class="form-control col-md-1 ledgr_nam" name="ledger_name[]" value="<?php echo $charges_details->ledger_name; ?>">
									<input type="hidden" class="form-control col-md-1 ledgr_nam_id" name="ledger_name_id[]" value="<?php echo $charges_details->ledger_name_id; ?>" readonly>
									<input type="hidden" class="form-control col-md-1 type_charges" name="type_charges[]" value="<?php echo $charges_details->type_charges; ?>" readonly>
									
								</div>
								<div class="col-md-2 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Value of Exp.</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly charges_added" name="charges_added[]" value="<?php echo $charges_details->charges_added; ?>">
									<span class="aply_btn"></span>
									
								</div>
								<?php 
								
									if($charges_details->sgst_amt !='' && $charges_details->cgst_amt !=''){
										$total_taxAMUNT = $charges_details->sgst_amt + $charges_details->cgst_amt;
										
								?>
									<input type="hidden" value="<?php echo $total_taxAMUNT; ?>" id="total_tax_slab">								
								<div class="col-md-2 col-xs-12item form-group sgst_amt1">
									<label class="col-md-12 col-sm-12 col-xs-12" for="sgstamount">SGST Amount</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly sgst_amt"  name="sgst_amt[]" value="<?php echo $charges_details->sgst_amt; ?>">
								</div>	
								<div class="col-md-2 col-xs-12 item form-group cgst_amt1">
									<label class="col-md-12 col-sm-12 col-xs-12" for="cgst Amount">CGST Amount</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly cgst_amt" name="cgst_amt[]" value="<?php echo $charges_details->cgst_amt; ?>" >
								</div>
									<?php } if($charges_details->igst_amt !=''){ ?>
									<input type="hidden" value="<?php echo $charges_details->igst_amt; ?>" id="total_tax_slab">
								<div class="col-md-2 col-xs-12 item form-group igst_amt1">
									<label class="col-md-12 col-sm-12 col-xs-12" for="igstamount">IGST Amount</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly igst_amt" name="igst_amt[]"  value="<?php echo $charges_details->igst_amt; ?>" >
								</div>	
									<?php } ?>	
								<div class="col-md-2 col-xs-12 item form-group" style="border-right: 1px solid #c1c1c1;">
									<label class="col-md-12 col-sm-12 col-xs-12" for="addtaxamount">Amt. with Tax</label>
									<input type="text" class="form-control col-md-1 amt_with_tax ad_rm_readonly" name="amt_with_tax[]" value="<?php echo $charges_details->amt_with_tax; ?>">
									<input type="hidden" class="form-control col-md-1 tttl_TaX" name="amt_tax[]" value="<?php echo $charges_details->amt_tax; ?>">
								</div>
							</div>
						
							<?php if($kk==0){
												echo '<button class="btn btn-primary add_charges_detail_button" type="button"><i class="fa fa-plus"></i></button>';
											}else{	
												echo '<button class="btn btn-danger remove_charges_field" type="button"> <i class="fa fa-minus"></i></button>';
											} 
										$kk++;
											}
										}
									}
								}
							//if(empty($invoice_detail)){
							?>
							<div class="col-md-12 input_charges_details charges_form" style="display:none; padding: 0px;"  >
								<div class="testDh middle-box label-box mailing-box">
									<div class="col-md-2 col-xs-12 item form-group">
										<label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Particulars.</label>
										<select class="itemName form-control selectAjaxOption select2 Add_charges_id"  required="required" name="particular_charges[]" data-id="charges_lead" data-key="id" data-fieldname="particular_charges" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND charges_for = 0" width="100%">
											<option value="">Select</option>			
										</select> 	
									</div>
									<div class="col-md-2 col-xs-12 item form-group">
										<label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Ledger Name.</label>
										<input type="text" class="form-control col-md-1 ledgr_nam" name="ledger_name[]" value="" readonly>
										<input type="hidden" class="form-control col-md-1 ledgr_nam_id" name="ledger_name_id[]" value="" readonly>
										<input type="hidden" class="form-control col-md-1 type_charges" name="type_charges[]" value="" readonly>
									</div>	
									<div class="col-md-2 col-xs-12 item form-group">
										<label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Value of Exp.</label>
										<input type="text" class="form-control col-md-1 ad_rm_readonly charges_added" name="charges_added[]" value="">
										<span class="aply_btn"></span>
										<input type="hidden" value="" id="total_tax_slab">
									</div>	
									<div class="col-md-2 col-xs-12 item form-group sgst_amt1">
										<label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="sgstamount">SGST Amount</label>
										<input type="text" class="form-control col-md-1 ad_rm_readonly sgst_amt"  name="sgst_amt[]" value="">
									</div>	
									<div class="col-md-2 col-xs-12 item form-group cgst_amt1">
										<label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="cgst Amount">CGST Amount</label>
										<input type="text" class="form-control col-md-1 ad_rm_readonly cgst_amt" name="cgst_amt[]" value="" >
									</div>
									<div class="col-md-2 col-xs-12 item form-group igst_amt1">
										<label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="igstamount">IGST Amount</label>
										<input type="text" class="form-control col-md-1 ad_rm_readonly igst_amt" name="igst_amt[]"  value="" >
									</div>		
									<div class="col-md-2 col-xs-12 item form-group" style="border-right: 1px solid #c1c1c1;">
										<label class="col-md-12 col-sm-12 col-xs-12  for_discount_hide" for="addtaxamount">Amt. with Tax</label>
										<input type="text" class="form-control col-md-1 amt_with_tax ad_rm_readonly" name="amt_with_tax[]" value="">
										<input type="hidden" class="form-control col-md-1 tttl_TaX" name="amt_tax[]" value="">
									</div>
								<div class="col-sm-12 btn-row" style="bottom: -38px; margin-left: 0px;"><button class="btn btn-primary add_charges_detail_button" type="button">Add</div>
							</div>
						</div>
					</div>
				<?php //} ?>
					</div>
					</div>
			</div>
		</div>
	</div>  
</div>
<hr>
<div class="bottom-bdr"></div>				
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
                <div class="col-sm-6 col-md-6 col-xs-12 vertical-border">				
				<div class="item form-group ">
                <!--label for="multi_first" class="control-label col-md-2 col-sm-2 col-xs-12">Description Of Goods<span class="required">*</span></label-->

					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="col-md-3 col-sm-12 col-xs-12">
									Message 
									
						</div>
						<div class="col-md-7 col-sm-7 col-xs-12">
								<textarea  name="message_for_email" class="form-control col-md-12 col-xs-12" placeholder="Message displayed on invoice "><?php if(!empty($invoice_detail)){ echo $invoice_detail->message_for_email;} ?></textarea>
								
								
						</div>
					  
					</div>
				</div>
				<div class="item form-group ">
				
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="col-md-3 col-sm-12 col-xs-12">
						Attachment 
						</div>
						<div class="col-md-7 col-sm-7 col-xs-12">
						
							<input type="file" class="form-control col-md-7 col-xs-12" name="file_attachment[]" multiple="multiple"  >							
						</div>
					</div>
				
            </div> 
</div>			
	<?php //} ?>	
<hr>
	<?php
					if(!empty($invoiceDetails)){
						$get_invoice_amount_and_tax_Details = json_decode($invoice_detail->invoice_total_with_tax,true);
						//pre($get_invoice_amount_and_tax_Details);
					}	
					?>
<div class="bottom-bdr"></div>
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
			<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right">
						    <div class="col-md-6 col-sm-5 col-xs-6 text-right">
							TOTAL 
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							      <input type="text" value="<?php if(!empty($invoiceDetails)) echo $get_invoice_amount_and_tax_Details[0]['total']; ?>" name="total[]" class="total_amountt" style="border: none;"readonly> 
							</div>
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12 text-right cgst" >
						<div class="col-md-6 col-sm-5 col-xs-6 text-right">
							CGST  
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
						<input type="hidden" value="<?php if(!empty($invoiceDetails)) echo $get_invoice_amount_and_tax_Details[0]['cess_total']; ?>" 
						class="cess_total_cls" name="cess_all_total[]" style="border: none;"readonly> 
						
						<input type="hidden" value="<?php if(!empty($invoiceDetails)) echo $get_invoice_amount_and_tax_Details[0]['totaltax']; ?>" class="tax_class" name="totaltax[]" style="border: none;"readonly> 
						
						
						
						<input type="hidden" value="<?php if(!empty($invoice_detail)){ echo $invoice_detail->totaltax_total;} ?>" class="tax_class" name="totaltax_total" style="border: none;"readonly> 
                        
						<input type="text" value="<?php 
						if(!empty($invoiceDetails)){$all_tax =  $get_invoice_amount_and_tax_Details[0]['totaltax'];$divide = $all_tax/2;}?>" class="tax_class1 cgst" name="CGST" style="border: none;"readonly> 
							</div>
							 
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 text-right sgst" >
						<div class="col-md-6 col-sm-5 col-xs-6 text-right">
							SGST  
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							      <input type="text" value="<?php if(!empty($invoiceDetails)){$all_tax =  $get_invoice_amount_and_tax_Details[0]['totaltax'];$divide = $all_tax/2;}?>" class="tax_class2 sgst" name="SGST" style="border: none;"readonly>  
							</div>
							 
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12 text-right igst style='display:none;'">
							<div class="col-md-6 col-sm-5 col-xs-6 text-right">IGST </div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							<input type="text" value="<?php if(!empty($invoiceDetails)) echo $get_invoice_amount_and_tax_Details[0]['totaltax']; ?>" class="tax_class igst" name="IGST" style="border: none;display:none;"readonly > 
							</div>
						</div>
						<?php if(!empty($invoiceDetails) && $get_invoice_amount_and_tax_Details[0]['cess_all_total'] != ''){?>
							<div class="col-md-12 col-sm-12 col-xs-12 text-right cess">
								<div class="col-md-6 col-sm-5 col-xs-6 text-right">CESS </div>
								<div class="col-md-6 col-sm-5 col-xs-6 text-left">
								<input type="text" value="<?php if(!empty($invoiceDetails)) echo $get_invoice_amount_and_tax_Details[0]['cess_all_total']; ?>" class="cess_total_cls" name="cess_total" style="border: none;"readonly > 
								</div>
							</div>
						<?php }else{ ?>
							<div class="col-md-12 col-sm-12 col-xs-12 text-right cess" style="display:none;">
								<div class="col-md-6 col-sm-5 col-xs-6 text-right">CESS </div>
								<div class="col-md-6 col-sm-5 col-xs-6 text-left">
								<input type="text" value="" class="cess_total_cls" name="cess_total" style="border: none;"readonly > 
								</div>
							</div>
						<?php } ?>
						<div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 20px;color: #2C3A61; border-top: 1px solid #2C3A61;">
						<div class="col-md-6 col-sm-5 col-xs-6 text-right">
							GRAND TOTAL 
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							      <input type="text" value="<?php if(!empty($invoiceDetails)) echo $get_invoice_amount_and_tax_Details[0]['invoice_total_with_tax']; ?>" class="grand_total" name="invoice_total_with_tax[]" style="border: none;"readonly>  
							</div>
							 
						</div>
					</div>
				
			
				</div>
					<div class="form-group">
					  
						<div class="modal-footer">
						<center>
							<input type="hidden" value="<?php if(!empty($invoice_detail)){ echo $invoice_detail->total_amount;} ?>"  name="total_amout_with_tax_on_keyup" id="total_amout_with_tax_on_keyup"> 
							<input type="hidden" value="<?php if(!empty($invoice_detail)){ echo $invoice_detail->totaltax_total;} ?>"  name="total_amout_without_tax_on_keyup" id="total_amout_without_tax_on_keyup"> 
							<button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
							<button type="reset" class="btn btn-default">Reset</button>
							<?php if((!empty($invoice_detail) && $invoice_detail->save_status ==0) || empty($invoiceDetails)){
									echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
							}?> 
							<button id="send" type="submit" class="btn btn-warning add_requried chrk_mat_qty">Submit</button>
							</center>
						</div>
					
					</div>
				</form>
			</div>
			
			


<!-- Add Party Modal-->

    <div class="modal left fade" id="myModal_Add_party" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
			<div class="modal-header">
		
                <h4 class="modal-title" id="myModalLabel">Add Party</h4>
				<span id="mssg"></span>
			</div>
			<form name="insert_party_data" name="ins"  id="insert_party_data_id">
                 <div class="modal-body">
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="name">Party Name <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" id="partyname" name="name" required="required" class="form-control col-md-7 col-xs-12 party_namee" value="">
						<input type="hidden" value="" id="fetch_pname">
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="email">Email </label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="email" id="partyemail" name="email" class="form-control col-md-7 col-xs-12" value="" >
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="name">Account Group<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible acc_group_id"  required name="account_group_id" data-id="account_group" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true" ></select>
				
						<span id="acc_grp_id"></span>
					</div>
				</div>
				<div class="required item form-group company_brnch_div col-md-12 col-sm-12 col-xs-12" style="display:none;"  >
							<label class="col-md-2 col-sm-2 col-xs-4" for="company_branch">Company Branch <span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<select class="itemName form-control select_company_branch" required="required" name="compny_branch_id">
									<option value="">Select Type And Begin</option>
									   <?php
										$branch_add = getNameById('company_detail',$_SESSION['loggedInUser']->u_id,'u_id');				
										$data =  json_decode($branch_add->address,true);
											foreach($data as $brnch_name){
										?>
									 <option value="<?php echo $brnch_name['add_id'];  ?>"><?php echo $brnch_name['compny_branch_name']; ?></option>
									 <?php } ?>
								</select> 
								<span id="branch_dd"></span>		
							</div>
						</div> 
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-4" for="gstin">GSTIN</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="partygstin" name="gstin" class="form-control col-md-7 col-xs-12" value="">
							<span class="spanLeft control-label"></span>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="gstin">Country <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" id='cntry' required name="country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this)"></select>
						<span id="contry"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="gstin">State<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible state_id" name="state" required  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)"></select>
						
						<span id="state1"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="gstin">City<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						 <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible city_id" name="city" required width="100%" tabindex="-1" aria-hidden="true"></select>
						<span id="city1"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="gstin">Address<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						  <textarea id="mailing_address" required="required" name="mailing_address" class="form-control col-md-7 col-xs-12" placeholder="Mailing Address"></textarea>
						<span class="spanLeft control-label"></span>
					</div>
				</div> 
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-4" for="opening_balances">Opening Balance </label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="opening_balance" name="opening_balance" class="form-control col-md-7 col-xs-12" value="" >
							<span class="spanLeft control-label"></span>
						</div>
					</div>
				</div>
                <div class="modal-footer">
				<input type="hidden" id="sale_ledger_data">
				    <button type="button" class="btn btn-default close_sec_model close_modal2" >Close</button>
					<button id="bbttn" type="button" class="btn btn-warning">Submit</button>
                </div>
				</form>
            </div>
        </div>
    </div>
<!-- Add Party Modal-->
<!-- Add MAtrial Popup -->
<div class="modal left fade" id="myModal_Add_matrial_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Add Material Details</h4>
					<span id="mssg34"></span>
			</div>
			<form name="insert_party_data" name="ins"  id="insert_Matrial_data_id">
                 <div class="modal-body">
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Material Name <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" id="material_name" name="material_name" required="required" class="form-control col-md-7 col-xs-12" value="">
						<span class="spanLeft control-label"></span>
					</div>
				</div> 
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Material Type <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">

					<select name="material_type_id"  width="100%" id="material_type_id" class="form-control">
					<option value="">Select Material Type </option>
				
					</select>
					<input type="hidden" name="prefix"  id="prefix">
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="email">HSN Code <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" id="hsn_code" name="hsn_code" class="form-control col-md-7 col-xs-12" value="" required>
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="email">Tax<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" id="tax" name="tax" class="form-control col-md-7 col-xs-12" value="" required>
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="email">UOM<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
					<select name="uom" id="uom"  class="form-control col-md-1">
						<option value="">Select</option>
						<?php foreach($uoms as $uom){ ?>
						<option value="<?php echo $uom; ?>"><?php echo $uom; ?></option>
						<?php } ?>
					</select>
						<span class="spanLeft control-label"></span>
					</div>
				</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">Specification</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<!--input type="text" id="opening_balance_Sec" name="opening_balance" class="form-control col-md-7 col-xs-12" value=""-->
							<textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification"></textarea>
							<span class="spanLeft control-label"></span>
						</div>
					</div>
				      
				</div>
                <div class="modal-footer">
				<input type="hidden" id="add_matrial_Data_onthe_spot">
				    <button type="button" class="btn btn-default close_sec_model close_modal2" >Close</button>
					<button id="Add_matrial_details_on_button_click" type="button" class="btn btn-warning">Submit</button>
                </div>
				</form>
            </div>
        </div>
    </div>
<!-- Add MAtrial Popup -->
<style> .alert{display:none;}</style>

<script>
var uoms = <?php echo $uoms_Json; ?>;



			
</script>