<?php //if($_SESSION['loggedInUser']->role != 2){
	?>						  
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/
	saveSaleOrderInvoice_Details" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
		<input type="hidden" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="login_user_idddd">
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<input type="hidden" name="save_status" value="1" class="save_status">
				<input type="hidden" name="" value="<?php if(!empty($sale_order)) //echo $sale_order->id; ?>">
<?php #pre($sale_order); #die();

?>
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
  <?php 
  $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
  ?>
  <div class="tab-content">	
 <div id="Information1" class="container tab-pane active">
 <div class="panel panel-default">
 <?php 
 $ledgerid_name = getNameById('account',$sale_order->account_id,'id');
  $party_name = getNameById('ledger',$ledgerid_name->ledger_id,'id');

 ?>

						
						<div class="panel-body">
						<input type="hidden" value="<?php echo $this->companyGroupId; ?>" id="company_login_id">
						<div class="col-sm-6 col-md-6 col-xs-12 vertical-border">
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Party Name<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<select class="itemName form-control selectAjaxOption select2 add_option party_name_ledger_id_onchange" id="get_add_more_btn" required="required" name="party_name" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND created_by_cid != 0 AND activ_status = 1)"  width="100%"> 										
											<option value="">Select</option>			
											<?php
												if(!empty($sale_order)){
													
													 $party_name = getNameById('ledger',$ledgerid_name->ledger_id,'id');
													echo '<option value="'.$party_name->id.'" selected>'.$party_name->name.'</option>';
												} 	
											?>    
										</select> 	
									</div>
							</div>
							<div class="item form-group">
									<label class="col-md-3 col-sm-12 col-xs-12" for="Addresses">Party Address<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
									   <select name="party_state_id" id="P_address" class="itemName form-control" >
									   <option value="">Select Address</option> 
											<?php
												if(!empty($sale_order)){
													$party_name = getNameById('ledger',$party_name->id,'id');
													
													
													//$party_address = getNameById('invoice',$sale_order->party_state_id,'id');
													$add_dtl = JSON_DECODE($party_name->mailing_address,true);
													
													foreach($add_dtl as $ad_dtl){
														
														// echo '<option value="'.$ad_dtl['mailing_state'].'" selected>'.$ad_dtl['mailing_address'].'</option>';
														$selected = ($ad_dtl['mailing_state'] == $sale_order->party_state_id) ? ' selected="selected"' : '';
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
										<input type="checkbox"  name="consignee_address_check"  class="js-switch" id="consignee_address_check" <?php if(!empty($sale_order->consignee_address)) {echo "checked";}?>>Check For Different Consignee Address
									</div>
								</div>
								<?php if(!empty($sale_order)){?>
								<div class="item form-group address" id="consignee_address">
									<label class="col-md-3 col-sm-12 col-xs-12" for="address_c">Name & Address</label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<textarea id="consignee_address" name="consignee_address"  class="form-control col-md-7 col-xs-12" placeholder="consignee_address" ></textarea>
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
										$party_name3 = getNameById_bywith_ledgers('ledger',$this->companyGroupId,'created_by_cid');
									?>
									<select class="itemName form-control selectAjaxOption select2 sale_ledger_id_onchange" id="get_add_more_btn_forsale_ledger" required="required" name="sale_ledger" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND activ_status = 1 AND account_group_id = 7 OR parent_group_id = 7)"  width="100%"> 
										<option value="">Select</option>			
											<?php
											if(empty($sale_order)){  
												echo '<option value="'.$party_name3->id.'" selected>'.$party_name3->name.'</option>';
											}
											if(!empty($sale_order)){
													$party_name = getNameById('ledger',$sale_order->sale_ledger,'id');
													echo '<option value="'.$party_name->id.'" selected>'.$party_name->name.'</option>';
												} 
										?>    
										</select> 	
								</div>
							</div>
	                    	<input type="hidden"  id="sale_ledger_company_branch_id" name="sale_lger_brnch_id"  value="<?php if(!empty($sale_order)) //echo $sale_order->sale_lger_brnch_id; ?>">
	                    	<!--input type="hidden"  id="sale_ledger_state_id" name="sale_ledger_state_id"-->
	                    	<input type="hidden"  id="sale_leger_gstin_no" name="sale_leger_gstin_no" value="<?php if(!empty($sale_order)) //echo $sale_order->sale_leger_gstin_no; ?>">
							
							
							<input type="hidden" value="<?php if(!empty($sale_order)){ 
								//echo $sale_order->party_state_id;
								 } ?>" id="party_billing_state_id" name="party_billing_state_id">
									
							<input type="hidden" value="<?php if(!empty($sale_order)){  //echo $sale_order->sale_L_state_id;  
							}?>" id="sale_company_state_id" name ="sale_company_state_id">
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Sale Address</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<select name="sale_L_state_id" id="sale_address" class="itemName form-control" required="required">
									   <option value="">Select Address</option> 
											<?php
												if(!empty($sale_order)){
													$saleLedger_address = getNameById('company_detail',$this->companyGroupId,'id');
												//pre($saleLedger_address);
													$add_dtl = JSON_DECODE($saleLedger_address->address,true);
													
													foreach($add_dtl as $ad_dtl_Sale){
													
														echo '<option value="'.$ad_dtl_Sale['state'].'" data-gst="'.$ad_dtl_Sale['company_gstin'].'" branh-id = "'.$ad_dtl_Sale['add_id'].'" >'.$ad_dtl_Sale['compny_branch_name'].'</option>';
													}
													
												} 
											?>
										
									   </select>
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Buyer Order No</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="buyer_order_no" name="buyer_order_no"   class="form-control col-md-7 col-xs-12" placeholder="Buyer Order No." value="<?php if(!empty($sale_order)) //echo $sale_order->buyer_order_no; ?>">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Buyer Order Date</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="buyer_order_date" name="buyer_order_date"   class="form-control col-md-7 col-xs-12" placeholder="Buyer Order Date." value="<?php if(!empty($sale_order)) //echo $sale_order->buyer_order_date; ?>">
								</div>
							</div>
							</div>
							<div class="col-sm-6 col-md-6 col-xs-12 vertical-border">
							<div class="item form-group">
							<?php 
                                	$last = $this->db->order_by('id',"desc")
									->get('invoice')
									->row();
									$ccount = $last->id + 1;
									$invoiceNumber = 'INVOICE/'.$ccount;
                                ?>
                                <label class="col-md-3 col-sm-12 col-xs-12" for="date_time_of_invoice_issue">Invoice Number<span>*</span></label>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <input type="text"  name="invoice_num" id="invoice_num" Placeholder="Invoice Number" class="form-control col-md-7 col-xs-12" required="required" value="<?php if(!empty($sale_order)) echo  $invoiceNumber; ?>">
                                </div>
							</div>
							
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="type">Transport Tel No. </label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="tel" id="transport_driver_pno" name="transport_driver_pno"  class="form-control col-md-7 col-xs-12" placeholder="Transport Tel No." value="<?php if(!empty($sale_order)) //echo $sale_order->transport_driver_pno; ?>">
								</div>
							</div>
							<div class="item form-group">
                                <label class="col-md-3 col-sm-12 col-xs-12" for="date_time_of_invoice_issue">e-way bill number</label>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <input type="text"  name="eway_bill" id="eway_bill_no" Placeholder="e-way bill number" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($sale_order)) //echo $sale_order->eway_bill_no; ?>">
									<span id="eway_bill_msg" style="color:red;"></span>
                                </div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="type">Vehicle Number</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="tel" id="vehicle_reg_no" name="vehicle_reg_no"  class="form-control col-md-7 col-xs-12" placeholder="Vehicle Number" value="<?php if(!empty($sale_order)) //echo $sale_order->vehicle_reg_no; ?>">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="date_time_of_invoice_issue">Date Time issue of Invoice<span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12">
								
									<input type="hidden" id="date12"  name="v_date"  class="form-control col-md-7 col-xs-12" placeholder="Date" value="<?php if(!empty($sale_order)){ //echo $sale_order->v_date;
									} ?>" autocomplete="off">
									<?php
									date_default_timezone_set('Asia/Kolkata');
									
									?>
									<input type="text" id="date_time_of_invoice_issue" name="date_time_of_invoice_issue" required="required" class="form-control col-md-7 col-xs-12" placeholder="Issue of Invoice" value="<?php
										if(!empty($sale_order)) //echo date("d-m-Y", strtotime($sale_order->date_time_of_invoice_issue));
										if(empty($sale_order)){ 
											//echo date('d-m-Y');
										}
										?>" autocomplete="off">
									
								</div>
							</div>
							
							<div class="item form-group">
								<!--label class="col-md-3 col-sm-12 col-xs-12" for="type">Mode of Payment</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<!--input type="text"   name="mode_of_payment" required="required" class="form-control col-md-7 col-xs-12" placeholder="Mode of Payment" value="<?php //if(!empty($sale_order)) echo $sale_order->mode_of_payment; ?>"-->
									<!--select name="mode_of_payment" class="form-control col-md-7 col-xs-12" >
									<option value=""> Select Mode of Payment </option>
										<option value="cash" <?php //if(!empty($sale_order)) if($sale_order->mode_of_payment == 'cash'){echo 'selected';} ?>>Cash</option>
										<option value="advance" <?php //if(!empty($sale_order)) if($sale_order->mode_of_payment == 'advance'){echo 'selected';} ?>>Advance</option>
										<option value="credit" <?php //if(!empty($sale_order)) if($sale_order->mode_of_payment == 'credit'){echo 'selected';} ?>>Credit </option>
										
									</select>
								</div-->	
									
									
									
									
									
									
									<input type="hidden" value="<?php if(!empty($sale_order)){// echo $sale_order->reject_invoice;
									} ?>" name="reject_invoice">
									<input type="hidden" value="<?php if(!empty($sale_order)){ //echo $sale_order->accept_reject;
									} ?>" name="accept_reject">
									<input type="hidden" value="<?php if(!empty($sale_order)){ //echo $sale_order->party_conn_company;
									} ?>" name="party_conn_company" id="conn_company_id">
										
								
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Party Phone</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="party_phone" name="party_phone" class="form-control col-md-7 col-xs-12" placeholder="Party Phone No." value="<?php if(!empty($sale_order)) //echo $sale_order->party_phone; ?>">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="type">Invoice Type</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
								
									<select name="invoice_type" id="invoice_type_id" class="form-control col-md-7 col-xs-12">
										<option value=""> Select Invoice Type </option>
										<option value="export_invoice" >Export Invoice</option>
										<option value="domestic_invoice" >Domestic invoice</option>
									</select>
								</div>	
							</div>
							
							<?php 
							// pre($sale_order);
							?>
							 <div class=" item form-group form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <label class="col-md-3 col-sm-12 col-xs-12" for="freight">Type</label>
                                       <div class="col-md-6 col-sm-12 col-xs-12" style="top: 5px;">
									   <?php //echo ($sex=='Male')?'checked':'' ?>
                                         Part Load:<input type="radio" class="flat calcDiscount" name="load_type" id="genderM" value="part_load" <?php if(!empty($sale_order->load_type) && $sale_order->load_type == "part_load"){ 	echo "checked=checked"; } ?>>
											Full Load:<input type="radio" class="flat calcDiscount" name="load_type" id="genderF" value="full_load" <?php if(!empty($sale_order->load_type) && $sale_order->load_type == "full_load"){ echo "checked=checked"; } ?>>
											None:<input type="radio" class="flat calcDiscount" name="load_type" id="" value="none" <?php if(!empty($sale_order->load_type) && $sale_order->load_type == "none"){ echo "checked=checked"; } ?>>
                                       </div>
                                    </div>
								<div class="exprt_div" <?php 
									echo 'style="display: none"';
								?>>
									<div class="item form-group">
										<label class="col-md-3 col-sm-12 col-xs-12" for="port">Port of Loading</label>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<input type="text" id="port_loading"  name="port_loading"  class="form-control col-md-7 col-xs-12" placeholder="Port loading" value="<?php if(!empty($sale_order)) //echo $sale_order->port_loading; ?>">
										</div>
									</div>
									
									<div class="item form-group">
										<label class="col-md-3 col-sm-12 col-xs-12" for="port">Port of Discharge</label>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<input type="text" id="port_discharge"  name="port_discharge"  class="form-control col-md-7 col-xs-12" placeholder="Port discharge" value="<?php if(!empty($sale_order)) //echo $sale_order->port_discharge; ?>">
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
									<input type="text" id="transport" name="transport"  class="form-control col-md-7 col-xs-12" placeholder="Transport Type" value="<?php if(!empty($sale_order)) //echo $sale_order->transport; ?>">
								</div>
							</div>
						
						
						
						<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="date_time_of_invoice_issue">Email</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="email_id" name="email" class="form-control col-md-7 col-xs-12" placeholder="Email" value="<?php if(!empty($sale_order)) //echo $sale_order->email; ?>">
								</div>
							</div>
							
								
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="date_time_removel_of_goods">Date Time Removal of Goods</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="date_time_removel_of_goods" name="date_time_removel_of_goods" class="form-control col-md-7 col-xs-12" placeholder="Removal of Goods" value="<?php if(!empty($sale_order)){ //echo $sale_order->date_time_removel_of_goods;
									}else{ //echo date('d-m-Y');
									} ?>" autocomplete="off">
								</div>
							</div>									
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="pan">Dispatch Document Number</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input id="pan" class="form-control col-md-7 col-xs-12" data-validate-length-range="4"  value="<?php if(!empty($sale_order)) //echo $sale_order->dispatch_document_no; ?>" name="dispatch_document_no" placeholder="Dispatch Document Number"  type="text"> 
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="pan">Dispatch Document Date</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input id="dispatch_document_date" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($sale_order)) //echo $sale_order->dispatch_document_date; ?>" name="dispatch_document_date" placeholder="Dispatch Document Date"  type="text"> 
								</div>
							</div>
						</div>	
					<div class="col-sm-6 col-md-6 col-xs-12">
							<div class="item form-group">
                                <label class="col-md-3 col-sm-12 col-xs-12" for="gr">GR No.</label>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <input id="grno" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($sale_order)) //echo $sale_order->gr_no; ?>" name="gr_no" placeholder="GR number"  type="text">
                                </div>
                            </div>
                            
                            <div class="item form-group">
                                <label class="col-md-3 col-sm-12 col-xs-12" for="grDate">GR Date</label>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                      <!--input type="text" id="date" data-validation="date" name="gr_date"  class="form-control col-md-7 col-xs-12" placeholder="GR Date" value="<?php //if(!empty($sale_order)) echo $sale_order->gr_date; ?>"-->
									<input type="text" id="date12" name="gr_date"  class="form-control col-md-7 col-xs-12" placeholder="GR Date" value="<?php if(!empty($sale_order)) //echo $sale_order->gr_date; ?>" autocomplete="off">
                                </div>
                            </div>
							
							
							
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="pan">Company PAN</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input id="pan" class="form-control col-md-7 col-xs-12" data-validate-length-range="10"  value="<?php if(!empty($sale_order)) //echo $sale_order->pan; ?>" name="pan" placeholder="ABCDFA87565B"  type="text"> 
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="gstin">GSTIN</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input id="gstin" class="form-control col-md-7 col-xs-12" data-validate-length-range="15"  value="<?php if(!empty($sale_order)) //echo $sale_order->gstin; ?>" name="gstin" placeholder="EKKPPLO87565B"  type="text"> 
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="terms_of_delivery">Terms of Delivery</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<textarea id="terms_of_delivery"  name="terms_of_delivery" class="form-control col-md-7 col-xs-12" placeholder="Terms of Delivery"><?php if(!empty($sale_order)) //echo $sale_order->terms_of_delivery; ?></textarea>
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
					
					<div class=" panel-default">
					<?php
					$get_discount_details = getNameById('company_detail',$this->companyGroupId,'id');
					
					?>
					<input type="hidden" value="<?php echo $get_discount_details->discount_on_off;?>" id="get_discount_on_off">
					<input type="hidden" value="<?php echo $get_discount_details->item_code_on_off;?>" id="item_code_on_off">
						<div class="goods_descr_wrapper">
							<div class="item form-group add-ro">
							<div class="col-sm-12  col-md-12 label-box mobile-view2">
								   <?php	if($get_discount_details->item_code_on_off == 1 ){ ?>
								<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo 'col-md-1';} ?> col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Item Code <span class="required">*</span></label>
								</div>
							<?php } ?>	
								<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-2';}else{echo 'col-md-3';} ?> col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Material Name <span class="required">*</span></label>
								</div>
								<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Pro-Image</label></div>
								
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
								<div class="col-md-1 col-xs-12 item for`m-group">
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
								<div class="col-md-1 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label>
								</div>
								<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo  'col-md-2';} ?> col-xs-12 item form-group" style="overflow: hidden;">
									<label style="border-right: 1px solid #c1c1c1" class="col-md-12 col-sm-12 col-xs-12" for="amount">Amount with Tax<span class="required">*</span></label>
								</div>	

								</div>				
							<?php 
							
							$products = json_decode($sale_order->product);
									if(!empty($products)){ 
											$i =  1;

											foreach($products as $product){
												// $hsn = getNameById('hsn_sac_master',$product->hsncode,'id');
												   // pre($product);
														
											// if($invoiceDetails->material_id!='' && $invoiceDetails->descr_of_goods!='' && $invoiceDetails->hsnsac!='' && $invoiceDetails->quantity !='' && $invoiceDetails->rate!='' && $invoiceDetails->amount!='' && $invoiceDetails->UOM!='' && $invoiceDetails->tax!=''){			
						
							
							?>
							 
							<div class="col-md-12 input_descr_wrap middle-box mailing-box mobile-view <?php if($i==1){ echo 'scend-tr';}else{ echo 'edit-row1';}?>" style="margin-bottom: 0px; ">
							<?php	if($get_discount_details->item_code_on_off == 1 ){ ?>	
							<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo  'col-md-1';} ?> col-sm-12 col-xs-12 form-group">
                                  <label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Item Code <span class="required">*</span></label>
							      <input type="text" name="item_code[]"  class="form-control col-md-1 mat_item_code" placeholder="Item Code" value="<?php if(!empty($invoiceDetails)) echo $invoiceDetails->item_code; ?>" >
							</div>
							<?php } 
							
							
							
							?>	
							<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-2';}else{echo  'col-md-3';} ?> col-sm-12 col-xs-12 form-group">															
									<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Material Name <span class="required">*</span></label>	
									<select class="materialNameId  form-control selectAjaxOption select2 Add_mat_onthe_spot set_mat_name" required="required" name="material_id[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid = <?php echo $this->companyGroupId; ?>" width="100%" onchange="getTax(event,this)" id="material">
												<option value="">Select Option</option>
												<?php
													if(!empty($product)){
														$materialdata = getNameById('material',$product->product,'id');
														
														echo '<option value="'.$materialdata->id.'" selected>'.$materialdata->material_name.'</option>';
													}
												?>
											</select>	
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 item form-group">
											<label>Pro-Image</label>
											<div class="Product_Image col-xs-12">
											<?php
											
											$mat_name = $product->product;
											$mat_details = getNameById('material', $mat_name, 'id');
											$mat_id = $mat_details->id;
											$attachments = $this->crm_model->get_image_by_materialId('attachments', 'rel_id', $mat_id);
												 if($attachments){			
												echo '<img style="width: 50px; height: 50px;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
												 }else{
													echo '<img style="width: 50px; height: 50px;" src='.base_url().'assets/images/noimage.png>';
												 }	
											
											?>
											</div>
										</div>
								
										<input type="hidden" name="descr_of_goods[]"  class="form-control col-md-1" placeholder="Description Of Goods" value="<?php echo $product->description ; ?>">
																						
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">	 
									    <label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC </label>					
										<!--input type="text" name="hsnsac[]" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC" value="<?php //if(!empty($invoiceDetails)){ echo $invoiceDetails->hsnsac;} ?>" -->
										<?php 
										$matdata = getNameById('material',$product->product,'id');
										
										?>
	<input type="text" name="hsnsac[]" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC" value="
	<?php 
	// 
		
		$hsn = getNameById('hsn_sac_master',$matdata->hsn_code,'id');
				
		if(!empty($hsn)){echo $hsn->hsn_sac;}
		?>" readonly >										
									</div>														
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">	 
									    <label class="col-md-12 col-sm-12 col-xs-12" for="quantity">Quantity<span class="required">*</span></label>															
										<input type="text"  required="required" name="quantity[]" class="form-control col-md-1 year goods_descr_section keyup_event qty" placeholder="Quantity" value="<?php echo $product->quantity ;?>">														
									</div>														
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="rate">Rate<span class="required">*</span></label>									
										<div class="checktr">
											<input type="text" name="rate[]" class="form-control col-md-1 goods_descr_section keyup_event rate" placeholder="Rate" value="<?php echo $product->price ;?>">
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
												<option value="disc_precnt">Discount Percent</option>
												<option value="disc_value">Discount Value</option>
											</select>
										</div>
									</div>
									
									<div class="col-md-1 col-sm-12 col-xs-12 form-group" >
                                         <label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Amount">Disc. Amt.</label>									
										<div class="checktr">
											<input type="text" name="discamt[]" class="form-control col-md-1 goods_descr_section added_discount_amt" placeholder="Disc Amt" value="">
										</div>
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="Amount after desc">Amt. After Desc.</label>
										<div class="checktr">
											<input type="text" name="after_desc_amt[]" class="form-control col-md-1 goods_descr_section asdfsa" placeholder="After Disc Amt" value="">
										</div>
									</div>
									
								<?php  } ?>
								<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="tax">Tax</label>								
										<div class="checktr">
											<input type="text" name="tax[]" class="form-control col-md-1 goods_descr_section tax"   placeholder="Tax" value="<?php echo $product->gst ;?>" readonly>
											<input type="hidden" value="" name="added_tax" class="added_tax" >
											<input type="hidden" value="<?php echo $product->gst ;?>" name="added_tax_Row_val[]" >
										</div>
									</div>	
								<div class="col-md-1 col-sm-12 col-xs-12 form-group">
									 <label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label>							
									<div>
										<?php
											$uoms = measurementUnits();
											$uoms_Json = json_encode($uoms);	
										?>
										<input type="" name="UOM1[]" class="form-control col-md-1 goods_descr_section " readonly value="<?php 
												$ww =  getNameById('uom', $product->uom,'id');
												$uom = !empty($ww)?$ww->ugc_code:'';
												echo $uom;
											 ?>">

										<input type="hidden" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly value="<?php echo  $product->uom; ?>"> 
									</div>
								</div>
									<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo  'col-md-2';} ?> col-sm-12 col-xs-12 form-group">
                                        <label style="border-right: 1px solid #c1c1c1" class="col-md-12 col-sm-12 col-xs-12" for="amount">Amount with Tax<span class="required">*</span></label>									
										<div>

										<?php  
								   	if(!empty($sale_order)){
										$i =  1;
										$ck = 0;
										$subtotal = 0;
										$gst = 0;
										$total_cbf_set = $total_weight_set = 0;
										foreach($products as $product){
										$subtotal += $product->individualTotal;
										$gst += $product->individualTotal*($product->gst/100);
								   	$account = getNameById('account',$sale_order->account_id,'id');
									   /* 08-03-2022 Start Resolve issue  */
								   	$type_of_customer = (int)$account->type_of_customer;
									   /* 08-03-2022 End Resolve issue  */
										$type_of_customer_data = $this->crm_model->get_data_byId('types_of_customer', 'id', $type_of_customer);
										/* 08-03-2022 Start Resolve issue  */
										$calcDiscount_val = (int)$sale_order->load_type;
										/* 08-03-2022 End Resolve issue  */
										$sale_order_cbf = $sale_order->pi_cbf;
										$sale_order_weight = $sale_order->pi_weight;
										$sale_order_paymode = $sale_order->pi_paymode;
										$sale_order_permitted = $sale_order->pi_permitted;
										$special_discount = $sale_order->special_discount;
										$freightCharges = $sale_order->freightCharges;
										$advance_received = $sale_order->advance_received;
										if($calcDiscount_val == 'none'){
										$discount_rate = "0";
										} else {
											/* 08-03-2022 Start Resolve issue  */
										$discount_rate = (int)$type_of_customer_data-(int)$calcDiscount_val;/* 08-03-2022 End Resolve issue  */	
										}
										$discount_value = $subtotal*($discount_rate/100);
										$spd_value = $subtotal*($special_discount/100);
										$total = $subtotal - $discount_value - $spd_value;
										$gfc = $freightCharges*28/100;
										$grand_total = $total+$gst+$freightCharges+$gfc;
										/* 08-03-2022 Start Resolve issue  */
										$remain_balance = (int)$grand_total-(int)$advance_received;
										/* 08-03-2022 End Resolve issue  */
									}
								}
										?>
											<input type="text" id="amount"   name="amount[]" class="form-control col-md-1 goods_descr_section AMunt" readonly placeholder="Amount" value="<?php echo !empty($grand_total)?$grand_total:''; ?>" >

											<input type="hidden" value="<?php echo !empty($grand_total)?$grand_total:''; ?>" name="cess[]">
											
											<input type="hidden" value=""
											name="cess_tax_calculation[]">
											
											<input type="hidden" value="" name="valuation_type[]">
											
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
								}}?>								
						</div>
						</div>
					</div>
                    </div>
 </div>
 
 <hr>
<div class="bottom-bdr"></div>	

 <!-- <h3 class="Material-head" style="margin-bottom: 30px;">Add Charges / Discount<hr></h3>
  <div id="Charges" class="container tab-pane active">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="col-md-1 col-sm-1 col-xs-1 show_charges"  >Click to Add Charges</div>
						<div class="col-md-12 col-sm-12 col-xs-12 input_charges_wrap" style="padding: 0px;">
						<?php
						$charges_detail = json_decode($sale_order->charges_added);
						if($sale_order->charges_added !=''){
							$charges_detail = json_decode($sale_order->charges_added);
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
											if(!empty($sale_order)){												
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
							//if(empty($sale_order)){
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
</div>-->

			
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
                <div class="col-sm-6 col-md-6 col-xs-12 vertical-border">				
				<div class="item form-group ">
                <!--label for="multi_first" class="control-label col-md-2 col-sm-2 col-xs-12">Description Of Goods<span class="required">*</span></label-->

					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="col-md-3 col-sm-12 col-xs-12">
									Message 
									
						</div>
						<div class="col-md-7 col-sm-7 col-xs-12">
								<textarea  name="message_for_email" class="form-control col-md-12 col-xs-12" placeholder="Message displayed on invoice "><?php if(!empty($sale_order)){ //echo $sale_order->message_for_email;
								} ?></textarea>	
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
						$get_invoice_amount_and_tax_Details = json_decode($sale_order->invoice_total_with_tax,true);
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
							      <input type="text" value="<?php if(!empty($sale_order)) echo $sale_order->total; ?>" name="total[]" class="total_amountt" style="border: none;"readonly> 
							</div>
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12 text-right cgst" >
						<div class="col-md-6 col-sm-5 col-xs-6 text-right">
							CGST  
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
						<input type="hidden" value="<?php if(!empty($invoiceDetails)) //echo $get_invoice_amount_and_tax_Details[0]['cess_total']; ?>" 
						class="cess_total_cls" name="cess_all_total[]" style="border: none;"readonly> 
						
						<input type="hidden" value="<?php if(!empty($invoiceDetails)) echo $get_invoice_amount_and_tax_Details[0]['totaltax']; ?>" class="tax_class" name="totaltax[]" style="border: none;"readonly> 
						
						
						
						<input type="hidden" value="<?php if(!empty($sale_order)){ //echo $sale_order->totaltax_total; 
						} ?>" class="tax_class" name="totaltax_total" style="border: none;"readonly> 
                        
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
							<div class="col-md-6 col-sm-5 col-xs-6 text-right">IGST</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							<input type="text" value="<?php if(!empty($sale_order)) //echo $get_invoice_amount_and_tax_Details[0]['totaltax']; ?>" class="tax_class igst" name="IGST" style="border: none;display:none;"readonly > 
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
						<?php } 
						
						if(!empty($invoiceDetails)){
							$charges_data = json_decode($sale_order->charges_added,true);
							$total_charge_Data = 0;
							foreach($charges_data as $charg_Data){
								$total_charge_Data += $charg_Data['amt_with_tax'];
							}
							//echo ;
						}
						
						if(!empty($invoiceDetails) && $total_charge_Data != ''){
					?>
						<div class="col-md-12 col-sm-12 col-xs-12 text-right" >
							<div class="col-md-6 col-sm-5 col-xs-6 text-right">CHARGES WITH TAX </div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							<input type="text" value="<?php if(!empty($invoiceDetails)) echo $total_charge_Data; ?>" class="total_charges_cls" style="border: none;"readonly > 
							</div>
						</div>
						<?php }else { ?>
						<div class="col-md-12 col-sm-12 col-xs-12 text-right charges_head_div"  style="display:none;" >
							<div class="col-md-6 col-sm-5 col-xs-6 text-right">CHARGES WITH TAX </div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							<input type="text" value="" class="total_charges_cls"  style="border: none;"readonly > 
							 
							</div>
						</div>
					<?php } ?>	
						<div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 18px;color: #2C3A61; border-top: 1px solid #2C3A61;">
						<div class="col-md-6 col-sm-5 col-xs-6 text-right">
							GRAND TOTAL 
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							      <input type="text" value="<?php if(!empty($sale_order)) echo $sale_order->grandTotal; ?>" class="grand_total" name="invoice_total_with_tax[]" style="border: none;"readonly> 
								  <!-- 09-03-2022 Start Resolve issue --> 
								  <input type="hidden" value="<?php if(!empty($sale_order)) echo $sale_order->grandTotal; ?>" class="grand_total" name="total_amount" style="border: none;"readonly> 
								  <!-- 09-03-2022 End Resolve issue -->
							</div>
							 
						</div>
					</div>
				
			
				</div>
					<div class="form-group">
					  
						<div class="modal-footer">
						<center>
							<input type="hidden" value="<?php if(!empty($sale_order)){ //echo $sale_order->total_amount;
							} ?>"  name="total_amout_with_tax_on_keyup" id="total_amout_with_tax_on_keyup"> 
							<input type="hidden" value="<?php if(!empty($sale_order)){ //echo $sale_order->totaltax_total;
							} ?>"  name="total_amout_without_tax_on_keyup" id="total_amout_without_tax_on_keyup"> 
							<button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
							<!--button type="reset" class="btn btn-default">Reset</button-->
							<?php //if((!empty($sale_order) && $sale_order->save_status ==0) || empty($invoiceDetails)){
									//echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
							//}?> 
							<button id="send" type="submit" class="btn btn-warning add_requried_t chrk_mat_qty">Submit</button>
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
				<div class="item form-group">
				
					<div class="item form-group">		
						<label class="col-md-3 col-sm-3 col-xs-12" for="non_inventry_material">Inventory Type </label>
						<div class="col-md-6 col-sm-6 col-xs-12">	
							Inventory: <input type="radio" class="flat" name="non_inventry_material" id="genderM" value="0" /> 
							Non-Inventory: <input type="radio" class="flat" name="non_inventry_material" id="genderF" value="1"  checked />										
						</div>
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
					<select class="uom selectAjaxOption select2 form-control  col-md-1" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php 	echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0 AND active_inactive = 1">
							<option value="">Select Option</option>
								<?php 
								
								$uomdd = getNameById('uom',$materials->uom,'uom_quantity');
								echo '<option value="'.$uomdd->id.'" selected>'.$uomdd->uom_quantity.'</option>';
							
								?>
					</select>
					<!--select name="uom" id="uom"  class="form-control col-md-1">
						<option value="">Select</option>
						<?php //foreach($uoms as $uom){ ?>
						<option value="<?php //echo $uom; ?>"><?php //echo $uom; ?></option>
						<?php //} ?>
					</select-->
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