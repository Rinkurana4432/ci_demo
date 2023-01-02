<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/savepurchase_bill_Details" enctype="multipart/form-data" id="voucherForm" novalidate="novalidate">

	<input type="hidden" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="login_user_idddd">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<div class=" panel-default">
					<h3 class="Material-head">Information <hr></h3>
						
						<?php 
						if(!empty($purchase_data)){
						?>
						<center>Voucher No: <?php echo sprintf("%04s", $purchase_data->id); ?></center>
						<?php
						}else{
							$p_Data = get_purchase_bill_count('purchase_bill',$_SESSION['loggedInUser']->c_id ,'created_by_cid');
								$purchase_bill_no = $p_Data->id + 1;
						?>
						<center>Voucher No: <?php echo sprintf("%04s", $purchase_bill_no); ?></center>
						<?php } ?>
						
						<div class="panel-body">
						<input type="hidden" name="id" value="<?php if(!empty($purchase_data)) echo $purchase_data->id; ?>">
						<input type="hidden" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="company_login_id">
						<input type="hidden" name="save_status" value="1" class="save_status">
						
						<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
							<div class="item form-group">
							
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Supplier Name<span class="required">*</span></label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<select class="itemName form-control selectAjaxOption select2 add_supplier_detials" id="add_suplier_btn"  required="required" name="supplier_name" data-id="ledger" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>  AND save_status=1 AND parent_group_id = 3 "  width="100%"> 	

											<option value="">Select</option>			
											<?php
											if(!empty($purchase_data)){
													//$supplier = getNameById('ledger',$purchase_data->supplier_name ,'supp_id');
													$supplier = getNameById('ledger',$purchase_data->supplier_name ,'id');
													
													echo '<option value="'.$supplier->id.'" selected>'.$supplier->name.'</option>';
												} 
											?>    
										</select> 	
								</div>
								
							</div>
							<div class="item form-group">
									<label class="col-md-3 col-sm-12 col-xs-12" for="Addresses">Supplier Address<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
									   <select  id="supp_address" class="itemName form-control" required="required">
									   <option value="">Select Address</option> 
											<?php
												if(!empty($purchase_data)){
													$supplier_name = getNameById('ledger',$purchase_data->supplier_name,'id');
													
													//$party_address = getNameById('invoice',$invoice_detail->party_state_id,'id');
													$add_dtl = JSON_DECODE($supplier_name->mailing_address,true);
													// pre($add_dtl);
													// pre($purchase_data);
													foreach($add_dtl as $ad_dtl){
														$selected = ($ad_dtl['mailing_state'] == $purchase_data->party_billing_state_id) ? ' selected="selected"' : '';
														echo '<option value="'.$ad_dtl['mailing_state'].'"  "'.$selected.'" data-gst="'.$ad_dtl['gstin_no'].'">'.$ad_dtl['mailing_address'].'</option>';
													}
													
												} 
											?>
										
									   </select>
									</div>
								</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">GSTIN<span class="required">*</span></label><!--Seller GSTIN-->
								<div class="col-md-6 col-sm-9 col-xs-12">
								<input type="text" id="gstin_id"  name="gstin" required="required"   class="form-control col-md-7 col-xs-12" placeholder="GSTIN" value="<?php if(!empty($purchase_data)) echo $purchase_data->gstin; ?>" autocomplete="off" onblur="fnValidateGSTIN(this)" readonly>
									
								</div>
							</div>
						
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Purchase Ledger<span class="required">*</span></label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<select class="itemName form-control selectAjaxOption select2 get_ledger_state_Purcahse_bill" required="required" name="party_name" data-id="ledger" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status=1 "  width="100%">	
										<option value="">Select</option>			
											<?php
											if(!empty($purchase_data)){
													$ledgerdtl = getNameById('ledger',$purchase_data->party_name ,'id');
													echo '<option value="'.$ledgerdtl->id.'" selected>'.$ledgerdtl->name.'</option>';
												} 
											?>    
									</select> 	
								</div>
								<input type="hidden" value="<?php if(!empty($purchase_data)){ echo $purchase_data->party_billing_state_id; }?>" id="party_billing_state_id" name="party_billing_state_id">
								<input type="hidden" value="<?php if(!empty($purchase_data)){ echo $purchase_data->sale_company_state_id;  }?>" id="sale_company_state_id"  name="sale_company_state_id">
								<input type="hidden" value="<?php if(!empty($purchase_data)){ echo $purchase_data->purchase_lger_brnch_id; }?>" id="purchase_lger_brnch_id" name="purchase_lger_brnch_id">
						</div>
								<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Purchase Address <span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<select name="purchase_company_state_id" id="purchase_address" class="itemName form-control" required="required">
									   <option value="">Select Address</option> 
											<?php
												if(!empty($purchase_data)){
													$PurLedger_address = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
													$add_dtl = JSON_DECODE($PurLedger_address->address,true);
													
													foreach($add_dtl as $ad_dtl_Pur){
														
														$selected = ($ad_dtl_Pur['add_id'] == $purchase_data->purchase_lger_brnch_id) ? ' selected="selected"' : '';
														
														echo '<option value="'.$ad_dtl_Pur['state'].'"   data-gst="'.$ad_dtl_Pur['company_gstin'].'" branh-id = "'.$ad_dtl_Pur['add_id'].'" "'.$selected.'" >'.$ad_dtl_Pur['compny_branch_name'].'</option>';
													}
													
												} 
											?>
										
									   </select>
								</div>
							</div>
							
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Purchase GSTIN</label>
								<div class="col-md-6 col-sm-9 col-xs-12">
								<input type="text" id="purchase_gstin"  name="purchase_gstin"    class="form-control col-md-7 col-xs-12" placeholder="Purchase GSTIN" value="<?php if(!empty($purchase_data)) echo $purchase_data->purchase_gstin; ?>" readonly>
									
								</div>
							</div>
							
							
						
						</div>
						
					
					
						
						<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
							
						
						<!--div class="col-md-4 item form-group">
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Ifsc Code<span class="required">*</span></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input type='text'  name='ifsc_code' required='required' id="ifsc_code"   class='form-control col-md-7 col-xs-12 addd_amount' placeholder='Ifsc Code' value="<?php //if(!empty($purchase_data)) echo $purchase_data->ifsc_code; ?>" autocomplete='off' >
								</div>
							</div>
						</div-->
						<?php
						
							if($purchase_data->auto_entry == 1){ ?>
								<input type='hidden'  name='auto_entry' value="1" >
						<?php }else{ ?>
						<input type='hidden'  name='auto_entry' value="0" >
						<?php } ?>
						
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Party Email</label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<input type='text'  name='p_email'  id="p_email"   class='form-control col-md-7 col-xs-12 addd_amount' placeholder='Email Id' value="<?php if(!empty($purchase_data)) echo $purchase_data->p_email; ?>" autocomplete='off' >
									
									
									
									
									
									
								</div>
							</div>
						
					
					
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Date<span class="required">*</span></label>
								<div class="col-md-6 col-sm-9 col-xs-12">
								<input type="text" id="bill_date" name="date" required="required"   class="form-control col-md-7 col-xs-12" placeholder="DD/MM/YY" value="<?php if(!empty($purchase_data)) echo $purchase_data->date; ?>" autocomplete="off">
								</div>
							</div>
						
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Invoice Number<span class="required">*</span></label><!-- Added by Maninder-->
								<div class="col-md-6 col-sm-9 col-xs-12">
									<input type='text'  name='invoice_num' required='required' id="invoice_num"   class='form-control col-md-7 col-xs-12 addd_amount' placeholder='Invoice Number' value="<?php if(!empty($purchase_data)) echo $purchase_data->invoice_num; ?>" autocomplete='off' >
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Vehicle Number.</label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									<input type="text"  name="vehicle_reg_no"    class="form-control col-md-7 col-xs-12" placeholder="Vehicle Number" value="<?php if(!empty($purchase_data)) echo $purchase_data->vehicle_reg_no; ?>" autocomplete="off">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Driver Phone</label>
								<div class="col-md-6 col-sm-9 col-xs-12">
								<input type="text" id="suplier_phone_id"  name="driver_phone"    class="form-control col-md-7 col-xs-12" placeholder="Driver Phone" value="<?php if(!empty($purchase_data)) echo $purchase_data->driver_phone; ?>" autocomplete="off">
									
								</div>
							</div>
						
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Address</label>
								<div class="col-md-6 col-sm-9 col-xs-12">
									
									<textarea  name="supp_address" id="supp_address" class="form-control col-md-12 col-xs-12" placeholder="Address"><?php if(!empty($purchase_data)) echo $purchase_data->supp_address; ?></textarea>
								</div>
							</div>
							
							</div>
						</div>
<hr>						
<div class="bottom-bdr"></div>						
<div class="container mt-3">

  <!-- Nav tabs -->
  <ul class="nav tab-3 nav-tabs">
    <li class="nav-item active">
      <a class="nav-link " data-toggle="tab" href="#Description" aria-expanded="true"><strong>Description</strong><span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span></a>
    </li>
<li class="nav-item">
      <a class="nav-link " data-toggle="tab" href="#Charges" aria-expanded="false"><strong>Add Charges</strong></a>
    </li>
  </ul>
  	<?php
		$get_discount_details = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
	?>
	
<div class="tab-content">
 <div id="Description" class="container tab-pane active">

       <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap invoice_div" >
							<div class=" panel-default">
								<div class="panel-body bills_descr_wrapper add-row-2">
									<div class="item form-group " style="margin:0px;">
								<div class="col-md-12 input_descr_wrap label-box mobile-view2">
								<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo 'col-md-2';} ?> item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="productdetails">Product Details<span class="required">*</span></label>
								</div>
								<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo 'col-md-2';} ?> item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description<span class="required">*</span></label>
								</div>	
								<div class="col-md-1 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="HSN/SAC">HSN/SAC<span class="required">*</span></label>
								</div>	
								<div class="col-md-1 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="Qty">Qty<span class="required">*</span></label>
								</div>	
								<div class="col-md-1 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label>
								</div>
								<div class="col-md-1 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="rate">Rate<span class="required">*</span></label>
								</div>
								<?php
									
									if($get_discount_details->discount_on_off == '1'){
								?>
								<div class="col-md-1 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Type">Disc. Type</label>
								</div>
								<div class="col-md-1 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Amount">Disc. Amt.</label>
								</div>
								<div class="col-md-1 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="Amount after desc">Amt. After Desc.</label>
								</div>
									<?php } ?>
								<div class="col-md-1 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="rate">Sub Total<span class="required">*</span></label>
								</div>
								<div class="col-md-1 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="tax">Tax<span class="required">*</span></label>
								</div>		
								
								<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo 'col-md-2';} ?> item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="amount">Amount with Tax<span class="required">*</span></label>
								</div>	
							
								
							</div>
						<?php  if(empty($purchase_data)){ ?>
								<div class="col-md-12 input_descr_wrap middle-box mobile-view  mailing-box">
									<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo 'col-md-2';} ?> col-sm-12 col-xs-12 form-group">	<label>Product Details</label>														
										<select class="itemName  form-control selectAjaxOption select2 add_product_onthe_spot select_material_dtl"  required="required" name="product_details[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND status=1" width="100%"> 										
											<option value="">Select</option>			
											   
										</select> 
											
									</div>
									<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo 'col-md-2';} ?> col-sm-12 col-xs-12 form-group">															
										<label>Description</label>
										
										<input type="text" name="descr_of_bills[]" class="form-control col-md-12 col-xs-12" placeholder="Description Of Bills" value="">		
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">	
									<label>HSN/SAC</label>														
										<input type="text" name="hsnsac[]" class="form-control col-md-1" placeholder="HSN/SAC" value="">	
									</div>	
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">	
									     <label>Qty</label>															
										<input type="text" name="qty[]" class="form-control col-md-1 bills_descr_section qty_cls" placeholder="Qty" value="">	
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                       <label>UOM</label>									
										<div>
										<?php
											$uoms = measurementUnits();
											$uoms_Json = json_encode($uoms);
										?>
										<!--select name="UOM[]"  class="form-control col-md-1 bills_descr_section">
										<option value="">Select</option>
										<?php //foreach($uoms as $uom){ ?>
										<option value="<?php// echo $uom; ?>"><?php //echo $uom; ?></option>
										<?php //} ?>
										</select-->
										<input type="text" name="UOM[]" class="form-control col-md-1 bills_descr_section"  value="" readonly>
										</div>
									</div>									
																						
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label>Rate</label>									
										<div class=" checktr">
											<input type="text" name="rate[]" class="form-control col-md-1 bills_descr_section rate rate_class" placeholder="Rate" value="">
											<input type="hidden" name="total_tax2[]" class="form-control col-md-1 bills_descr_section tax_amount2"  value="">														
											<input type="hidden" name="subtotal[]" class="form-control col-md-1 bills_descr_section basic_amt"  value="">
										</div>
									</div>
									<?php
										//$get_discount_details = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
										if($get_discount_details->discount_on_off == '1'){
									?>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label>Disc. Type</label>									
										<div class=" checktr">
											<!--input type="text" name="disctype[]" class="form-control col-md-1 goods_descr_section" placeholder="Disc Type" value=""-->
											<select name="disctype[]" class="form-control disc_type_cls_purchase"> 
												<option value="">Select</option>
												<option value="disc_precnt">Discount Percent</option>
												<option value="disc_value">Discount Value</option>
											</select>
										</div>
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                         <label>Disc. Amt.</label>									
										<div class=" checktr">
											<input type="text" name="discamt[]" class="form-control col-md-1 goods_descr_section added_discount_amt" readonly placeholder="Disc Amt" value="">
										</div>
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                       <label>Amt. After Desc.</label>										
										<div class=" checktr">
											<input type="text" name="after_desc_amt[]" class="form-control col-md-1 goods_descr_section" readonly placeholder="After Disc Amt" value="">
										</div>
									</div>
										<?php } ?>
										<input type="hidden" value="<?php echo $get_discount_details->discount_on_off;?>" id="get_discount_on_off">
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                         <label>Sub Total</label>									
										<div class=" checktr">
											<input type="text" class="form-control col-md-1 bills_descr_section SSubtotal"  placeholder="Subtotal" value="">
										
										</div>
									</div>
									
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label>Tax</label>									
										<div>
											<!--select name="tax[]" class="form-control col-md-1 bills_descr_section tax">
												<option value="">Select</option>
												<option value="5">05.0% GST(05%)</option>
												<option value="12">12.0% GST(12%)</option>
												<option value="18">18.0% GST(18%)</option>
												<option value="28">28.0% GST(28%)</option>
											</select-->
											<input type="text" name="tax[]" class="form-control col-md-1 bills_descr_section tax" value="" readonly>
											<input type="hidden" value="" name="added_tax_Row_val[]" >
										</div>
									</div>
									<input type="hidden" value="" name="totaltax_total_calculate" >
									<input type="hidden" value="" name="purchase_added_tax" class="added_tax_purchase">
									<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo 'col-md-2';} ?> col-sm-12 col-xs-12 form-group">
                                         <label>Amount with Tax</label>										
										<div >
											<input type="text"   name="amount[]" class="form-control col-md-1 bills_descr_section"  placeholder="Amount" value="">
											<input type="hidden"   name="total_amount" class="form-control col-md-1 bills_descr_section grand_total"  value="">
											<input type="hidden" value="" name="cess[]">
											<input type="hidden" value="" name="cess_tax_calculation[]">
											<input type="hidden" value="" name="valuation_type[]">
											
										</div>
									</div>
											
															
								</div>
                               <div class="col-sm-12 btn-row"><button class="btn btn-primary add_bills_detail_button" type="button">Add</button></div>								
							<?php } ?>
							<?php
									if(!empty($purchase_data) && $purchase_data->descr_of_bills !=''){									
										$billDetails = json_decode($purchase_data->descr_of_bills);	
										
										
										if(!empty($billDetails)){	
											$i = 0;
											foreach($billDetails as $billDetail){
												//pre($billDetail);
												
											//if($billDetail->descr_of_bills!='' && $billDetail->product_details!='' && $billDetail->qty !='' && $billDetail->UOM!='' && $billDetail->rate!='' && $billDetail->UOM!='' && $billDetail->tax!='' && $billDetail->amountwittax!=''){

												
													
							
							?>
							<div class="col-md-12 input_descr_wrap middle-box mobile-view mailing-box">
									<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo 'col-md-2';} ?> col-sm-12 col-xs-12 form-group">	
									
										<label>Product Details</label>
										<!--input type="text" required="required" class="form-control col-md-1 bills_descr_section" placeholder="Product Detail" name="product_details[]" value="<?php //if(!empty($billDetail)) echo $billDetail->product_details; ?>"-->
										<select class="itemName  form-control selectAjaxOption select2 get_val add_product_onthe_spot select_material_dtl"  required="required" name="product_details[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" width="100%"> 										
											<option value="">Select</option>			
											
												<?php
												if(!empty($billDetail)){
													
												
													$mat_idd = getNameById('material',$billDetail->product_details,'id');
													
													echo '<option value="'.$mat_idd->id.'" selected>'.$mat_idd->material_name.'</option>';
												} 
													
												
											?>  	
										 
										</select> 
									</div>
									<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo 'col-md-2';} ?> col-sm-12 col-xs-12 form-group">															
										<label>Description</label>
										<!--textarea required="required" name="descr_of_bills[]" class="form-control col-md-12 col-xs-12" placeholder="Description Of Bills"></textarea-->	
										<input type="text" name="descr_of_bills[]" class="form-control col-md-12 col-xs-12" placeholder="Description Of Bills" value="<?php if(!empty($billDetail)) echo $billDetail->descr_of_bills; ?>">		
									</div>	
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">	
									    <label>HSN/SAC</label>														
										<input type="text" name="hsnsac[]" class="form-control col-md-1" placeholder="HSN/SAC" value="<?php if(!empty($billDetail)) echo $billDetail->hsnsac; ?>">	
									</div>		
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">	
									    <label>Qty</label>															
										<input type="text" name="qty[]" class="form-control col-md-1 bills_descr_section qty_cls" placeholder="Qty" value="<?php if(!empty($billDetail)) echo $billDetail->qty; ?>" >														
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label>UOM</label>									
										<div>
										<!--select name="UOM[]"  class="form-control col-md-1 bills_descr_section">
										<option value="">Select</option>
										<?php 
										$uoms = measurementUnits();
										$uoms_Json = json_encode($uoms);
										//$uom_values_Selected ='';
										//foreach($uoms as $uom){ 
										//if($uom == $billDetail->UOM){
												//	$uom_values_Selected = 'selected';
												//}else{
											//		$uom_values_Selected='';
											//	}	
										?>
										<option value="<?php //echo $uom; ?>"<?php //echo $uom_values_Selected; ?>><?php //echo $uom; ?></option>
										<?php //} ?>
										</select-->
										<input type="text" name="UOM[]" class="form-control col-md-1 bills_descr_section"  value="<?php echo $billDetail->UOM; ?>" readonly>
										</div>
									</div>									
																						
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label>Rate</label>									
										<div class=" checktr">
											<input type="text" name="rate[]" class="form-control col-md-1 bills_descr_section rate rate_class" placeholder="Rate" value="<?php if(!empty($billDetail)) echo $billDetail->rate; ?>">
											<!--input type="hidden" name="subtotal[]" class="form-control col-md-1 bills_descr_section basic_amt" value=""-->
										</div>
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label>Disc. Type</label>									
										<div class=" checktr">
											<select name="disctype[]" class="form-control disc_type_cls"> 
												<option value="">Select</option>
												<option value="disc_precnt" <?php if($billDetail->disctype == 'disc_precnt') { ?> selected="selected"<?php } ?> >Discount Percent</option>
												<option value="disc_value" <?php if($billDetail->disctype == 'disc_value') { ?> selected="selected"<?php } ?> >Discount Value</option>
											</select>
										
										</div>
									</div>
									<?php
										//$get_discount_details = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
										if($get_discount_details->discount_on_off == '1'){

									?>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                         <label>Disc. Amt.</label>									
										<div class=" checktr">
										<input type="text" name="discamt[]" class="form-control col-md-1 goods_descr_section added_discount_amt" readonly placeholder="Disc Amt" value="<?php if(!empty($billDetail)){ echo $billDetail->discamt;}  ?>">
											<!--input type="text" name="disctype[]" class="form-control col-md-1 goods_descr_section" placeholder="Disc Type" value=""-->
											
										</div>
									</div>
									
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">	
									    <label>Amt. After Desc.</label>	
										<div class=" checktr">
										<input type="text" name="after_desc_amt[]" class="form-control col-md-1 goods_descr_section" readonly placeholder="After Disc Amt" value="<?php if(!empty($billDetail)){ echo $billDetail->after_desc_amt;}  ?>">
											
										</div>
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label>Sub Total</label>									
										<div class=" checktr">
										<input type="text" class="form-control col-md-1 bills_descr_section basic_amt"  name="subtotal[]" placeholder="Subtotal" value="<?php if(!empty($billDetail)) echo $billDetail->subtotal; ?>">
											
										</div>
									</div>
									<?php  } ?>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label>Tax</label>									
										<div class=" checktr">
											<input type="text" name="tax[]" class="form-control col-md-1 bills_descr_section tax" value="<?php echo $billDetail->tax; ?>" readonly>
											<input type="hidden" value="<?php if(!empty($billDetail)){ echo $billDetail->added_tax_Row_val;} ?>" name="added_tax_Row_val[]" >
											
										</div>
									</div>
										
									
									<!--<div class="col-md-1 col-sm-12 col-xs-12 form-group">	
									    	
										<div>
											<!--select name="tax[]" class="form-control col-md-1 bills_descr_section tax">
												<option value="">Select</option>
												<option value="5" </?php //if($billDetail->tax == '05'){echo 'selected';} ?>>05.0% GST(05%)</option>
												<option value="12" </?php //if($billDetail->tax == '12'){echo 'selected';} ?>>12.0% GST(12%)</option>
												<option value="18" </?php //if($billDetail->tax == '18'){echo 'selected';} ?>>18.0% GST(18%)</option>
												<option value="28" </?php// if($billDetail->tax == '28'){echo 'selected';} ?>>28.0% GST(28%)</option>
											</select-->
											<!--<input type="text" name="tax[]" class="form-control col-md-1 bills_descr_section tax" value="</?php echo $billDetail->tax; ?>" readonly>
											<input type="hidden" value="</?php if(!empty($billDetail)){ echo $billDetail->added_tax_Row_val;} ?>" name="added_tax_Row_val[]" >
										</div>
									</div>-->
									
									<input type="hidden" value="" name="totaltax_total_calculate" >
									
									<div class="<?php if($get_discount_details->discount_on_off == '1'){echo 'col-md-1';}else{echo 'col-md-2';} ?> col-sm-12 col-xs-12 form-group">	
									 <label>Amount with Tax</label>
										<div>
											<input type="text"   name="amount[]" class="form-control col-md-1 bills_descr_section"  placeholder="Amount" value="<?php if(!empty($billDetail)) echo $billDetail->amountwittax; ?>">
											
											<input type="hidden"   name="total_amount" class="form-control col-md-1 bills_descr_section grand_total"  value="<?php if(!empty($billDetail)) echo $purchase_data->total_amount; ?>">
											
											<input type="hidden" value="<?php if(!empty($billDetail)){ echo $billDetail->cess;}  ?>" name="cess[]">
											<input type="hidden" value="<?php if(!empty($billDetail)){ echo $billDetail->cess_tax_calculation;}  ?>"
											name="cess_tax_calculation[]">
											<input type="hidden" value="<?php if(!empty($billDetail)){ echo $billDetail->valuation_type;}  ?>" name="valuation_type[]">
										</div>
									</div>
											<!--button class="btn btn-primary add_bills_detail_button" type="button"><i class="fa fa-plus"></i></button-->
											<?php if($i==0){
												echo '';
											}else{	
												echo '<button class="btn btn-danger remove_descr_field" type="button"> <i class="fa fa-minus"></i></button>';
											} ?>
															
							</div>
							<?php if($i==0){
												echo '<div class="col-md-12 btn-row"><button class="btn btn-primary add_bills_detail_button" type="button">Add</button></div>';
											}else{	
												echo '';
											} ?>
												
							<?php //} 
								$i++;
								}} }?>				
						</div>
					</div>
				</div>
			</div>
 
</div>
<div id="Charges" class="container tab-pane">
          <div class="col-md-1 col-sm-1 col-xs-1 show_charges"  >Click to Add Charges</div>
						<div class="col-md-12 col-sm-12 col-xs-12 input_charges_wrap">
						<?php
							if($purchase_data->charges_added !=''){
								$charges_detail = json_decode($purchase_data->charges_added);
									if(!empty($charges_detail)){
										$kk = 0;
									foreach($charges_detail as $charges_details){
								if($charges_details->particular_charges_name !='' && $charges_details->charges_added !='' && $charges_details->amt_with_tax !='' ){
						?>
						<div class="col-md-12 input_charges_details charges_form"  >
						   <div class="testDh">
							<div class="col-md-2 item form-group">
								<label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Particulars.</label>
								<select class="itemName form-control selectAjaxOption select2 Add_charges_id"   required="required" name="particular_charges[]" data-id="charges_lead" data-key="id" data-fieldname="particular_charges" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND charges_for  = 0" width="100%">
									<option value="">Select</option>			
											<?php
											if(!empty($purchase_data)){												
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
								<div class="col-md-2 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Value of Exp.</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly charges_added" name="charges_added[]" value="<?php echo $charges_details->charges_added; ?>">
									<span class="aply_btn"></span>
									
								</div>
								<?php 
									if($charges_details->sgst_amt !='' && $charges_details->cgst_amt !=''){
										$total_taxAMUNT = $charges_details->sgst_amt + $charges_details->cgst_amt;
								?>	
								<input type="hidden" value="<?php echo $total_taxAMUNT; ?>" id="total_tax_slab">
								<div class="col-md-2 item form-group sgst_amt1">
									<label class="col-md-12 col-sm-12 col-xs-12" for="sgstamount">SGST Amount</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly sgst_amt"  name="sgst_amt[]" value="<?php echo $charges_details->sgst_amt; ?>">
								</div>	
								<div class="col-md-2 item form-group cgst_amt1">
									<label class="col-md-12 col-sm-12 col-xs-12" for="cgst Amount">CGST Amount</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly cgst_amt" name="cgst_amt[]" value="<?php echo $charges_details->cgst_amt; ?>" >
								</div>
									<?php } if($charges_details->igst_amt !=''){ ?>
									<input type="hidden" value="<?php echo $charges_details->igst_amt; ?>" id="total_tax_slab">
								<div class="col-md-2 item form-group igst_amt1">
									<label class="col-md-12 col-sm-12 col-xs-12" for="igstamount">IGST Amount</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly igst_amt" name="igst_amt[]"  value="<?php echo $charges_details->igst_amt; ?>" >
								</div>	
									<?php } ?>	
								<div class="col-md-2 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="addtaxamount">Amt. with Tax</label>
									<input type="text" class="form-control col-md-1 amt_with_tax ad_rm_readonly" name="amt_with_tax[]" value="<?php echo $charges_details->amt_with_tax; ?>">
									<input type="hidden" class="form-control col-md-1 tttl_TaX" name="amt_tax[]" value="<?php echo $charges_details->amt_tax; ?>">
								</div>
							</div>
								<?php if($kk==0){
										echo '<div class="col-sm-12 btn-row"><button class="btn btn-primary add_charges_detail_button" type="button">Add</button></div>';
									}else{	
										echo '<button class="btn btn-danger remove_charges_field" type="button"> <i class="fa fa-minus"></i></button>';
									} 
							$kk++;
								}
						}
						}
					}     
					if(empty($invoice_detail)){
			?>
								 <div class="col-md-12 input_charges_details charges_form" style="display:none;" >
								  <div class="testDh label-box  middle-box">
									<div class="col-md-2 item form-group">
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
								<div class="col-md-2 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Value of Exp.</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly charges_added" name="charges_added[]" value="">
									<span class="aply_btn"></span>
									<input type="hidden" value="" id="total_tax_slab">
								</div>	
								<div class="col-md-2 item form-group sgst_amt1">
									<label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="sgstamount">SGST Amount</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly sgst_amt"  name="sgst_amt[]" value="">
								</div>	
								<div class="col-md-2 item form-group cgst_amt1">
									<label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="cgst Amount">CGST Amount</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly cgst_amt" name="cgst_amt[]" value="" >
								</div>
								<div class="col-md-2 item form-group igst_amt1">
									<label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="igstamount">IGST Amount</label>
									<input type="text" class="form-control col-md-1 ad_rm_readonly igst_amt" name="igst_amt[]"  value="" >
								</div>		
								<div class="col-md-2 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12  for_discount_hide" for="addtaxamount">Amt. with Tax</label>
									<input type="text" class="form-control col-md-1 amt_with_tax ad_rm_readonly" name="amt_with_tax[]" value="">
									<input type="hidden" class="form-control col-md-1 tttl_TaX" name="amt_tax[]" value="">
								</div>
								<div class="col-sm-12 btn-row" style="margin:0px;"><button class="btn btn-primary add_charges_detail_button" type="button">Add</button></div>
							</div>
							</div>
							
					
						</div>
								<?php } ?>
					</div>
			</div>
		</div>
	</div> 
<hr>						
				<div class="bottom-bdr"></div>
					<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
							<label class="col-md-3 col-sm-6 col-xs-12" for="narration">Narration</label>
							<div class="col-md-6 col-xs-12">
							<textarea class="form-control col-md-7 col-xs-12" name="message_for_email"><?php if(!empty($purchase_data)) echo $purchase_data->message_for_email; ?></textarea>
						    </div>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
						
							<label class="col-md-3 col-sm-6 col-xs-12" for="payment_attachment">Attachment</label>
						<div class="col-md-6 item form-group">
							<input type="file" class="form-control col-md-7 col-xs-12" name="bill_attachment_files[]" multiple="multiple">
							
						</div>
					</div>
					
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
			<?php
					if(!empty($purchase_data)){
						$get_invoice_amount_and_tax_Details = json_decode($purchase_data->invoice_total_with_tax,true);
						//pre($get_invoice_amount_and_tax_Details);
					}	
					?>
			<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right">
						    <div class="col-md-6 col-sm-5 col-xs-6 text-right">
							TOTAL 
							</div>
							<input type="hidden" value="<?php if(!empty($purchase_data)) echo $get_invoice_amount_and_tax_Details[0]['total']; ?>" name="total_AMMT" class="total_amountt" style="border: none;"readonly> 
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							      <input type="text" value="<?php if(!empty($purchase_data)) echo $get_invoice_amount_and_tax_Details[0]['total']; ?>" name="total[]" class="total_amountt" style="border: none;"readonly> 
							</div>
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12 text-right cgst" >
						<div class="col-md-6 col-sm-5 col-xs-6 text-right">
							CGST  
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
						
                        
						<input type="text" value="<?php 
						if(!empty($purchase_data)){$all_tax =  $get_invoice_amount_and_tax_Details[0]['totaltax'];
						echo $divide = $all_tax/2;}?>" class="tax_class1 cgst" name="CGST" style="border: none;"readonly> 
							</div>
							<input type="hidden" value="<?php if(!empty($purchase_data)) echo $get_invoice_amount_and_tax_Details[0]['totaltax']; ?>" class="tax_class" name="totaltax[]" style="border: none;"readonly>  
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 text-right sgst" >
						<div class="col-md-6 col-sm-5 col-xs-6 text-right">
							SGST  
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							      <input type="text" value="<?php if(!empty($purchase_data)){$all_tax =  $get_invoice_amount_and_tax_Details[0]['totaltax'];
								 echo  $divide = $all_tax/2;}?>" class="tax_class2 sgst" name="SGST" style="border: none;"readonly>  
							</div>
							 
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12 text-right igst style='display:none;'">
							<div class="col-md-6 col-sm-5 col-xs-6 text-right">IGST </div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							<input type="text" value="<?php if(!empty($purchase_data)) echo $get_invoice_amount_and_tax_Details[0]['totaltax']; ?>" class="tax_class igst" name="IGST" style="border: none;display:none;"readonly >  						 </div>
						</div>
						
						<?php if(!empty($purchase_data) && $get_invoice_amount_and_tax_Details[0]['cess_all_total'] != ''){?>
						<div class="col-md-12 col-sm-12 col-xs-12 text-right cess" >
							<div class="col-md-6 col-sm-5 col-xs-6 text-right">CESS </div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							<input type="text" value="<?php if(!empty($purchase_data)) echo $get_invoice_amount_and_tax_Details[0]['cess_all_total']; ?>" class="cess_total_cls" name="cess_total" style="border: none;"readonly > 
							</div>
						</div>
						<?php }else { ?>
						<div class="col-md-12 col-sm-12 col-xs-12 text-right cess"  style="display:none;" >
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
							      <input type="text" value="<?php if(!empty($purchase_data)) echo $get_invoice_amount_and_tax_Details[0]['invoice_total_with_tax']; ?>" class="grand_total" name="invoice_total_with_tax[]" style="border: none;"readonly>  
							</div>
							 
						</div>
					</div>
				
			
				</div>
			
			</div>
				</div>	
			</div>
		</div>
				<input type="hidden" name="totaltax_total" class="totaltax_total" value="<?php if(!empty($purchase_data)) echo $purchase_data->totaltax_total; ?>">
				
				<div class="modal-footer">
				<div class="col-md-12">
				<center>
				   <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
				<?php if((!empty($purchase_data) && $purchase_data->save_status ==0) || empty($purchase_data)){
									echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
							}?> 
					
					<button id="su_btn" type="submit" class="btn btn-warning" >Submit</button>
					</center>
					
					</div>
                </div>			
	</form>
	
	
	<!-- Add Party Modal-->

    <div class="modal left fade" id="myModal_Add_supplier" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	 
        <div class="modal-dialog" role="document">
            <div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Add Supplier</h4>
				<span id="mssg"></span>
				
			</div>
			<form name="insert_supplier_data" name="ins"  id="insert_supplier_data_id">
                 <div class="modal-body">
				
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Supplier Name <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" id="suppliername" name="name" required="required" class="form-control col-md-7 col-xs-12" value="" placeholder="Supplier Name ">
						<input type="hidden" value="" id="fetch_sname">
						
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Account Group<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible acc_group_id"  required name="supp_account_group_id" data-id="account_group" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true" ></select>
				
						<span id="acc_grp_id"></span>
					</div>
				</div>
				
			
								<div class="item form-group col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-4" for="gstin">GSTIN<span class="required">*</span></label>
							
								<div class="col-md-10 col-sm-10 col-xs-8 form-group">
									<input type="text" id="suppgstin" name="gstin_no"  class="form-control col-md-7 col-xs-12" placeholder="GSTIN" value="">
									<span class="spanLeft control-label"></span>
								</div>
							</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">Country <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" id='cntry' required name="country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this)"></select>
						<span id="contry"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">State<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible state_id" name="state" required  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)"></select>
						<span id="state1"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">City<span class="required">*</span></label>
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
				

				</div>
                <div class="modal-footer">
				    <button type="button" class="btn btn-default close_sec_model" >Close</button>
					
					<button id="add_suplier_btn_id" type="button" class="btn btn-warning">Submit</button>
                </div>
				</form>
            </div>
        </div>
    </div>
<!-- Add Party Modal-->


<!-- Add MAtrial Popup -->
<div class="modal left fade" id="myModal_Add_matrial_details_purchse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Non Inventory Material <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="checkbox" id="non_inventry_material" name="non_inventry_material"  class="form-control col-md-7 col-xs-12" value="">
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Tax<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" id="tax" name="tax" required="required" class="form-control col-md-7 col-xs-12" value="" Placeholder="Tax">
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
						<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">Opening Balance</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="opening_balance_Sec" name="opening_balance" class="form-control col-md-7 col-xs-12" value="">
							<span class="spanLeft control-label"></span>
						</div>
					</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="specification">Specification</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						<textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification"></textarea>
					</div>
				</div>
				      
				</div>
                <div class="modal-footer">
				<input type="hidden" id="add_matrial_Data_onthe_spot">
				    <button type="button" class="btn btn-default close_sec_model" >Close</button>
					<button id="Add_matrial_details_on_button_click" type="button" class="btn btn-warning">Submit</button>
                </div>
				</form>
            </div>
        </div>
    </div>
<!-- Add MAtrial Popup -->
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
<script>
var uoms = <?php echo $uoms_Json; ?>;



			
</script>	