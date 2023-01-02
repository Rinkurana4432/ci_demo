<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 50%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>


<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/savetdsInward_Details" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
		<input type="hidden" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="login_user_idddd">
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<input type="hidden" name="save_status" value="1" class="save_status">
				<input type="hidden" name="id" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->id; ?>">
				<!-- <input type="hidden" name="invoiceid" id="invoiceidaccounting" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->id; ?>"> -->
				<div class="container mt-3">
				  <!-- Nav tabs -->
				  <ul class="nav tab-3 nav-tabs">
					<li class="nav-item active">
					  <a class="nav-link " data-toggle="tab" href="#Information1"><strong> Information </strong></a>
					</li>


				  </ul>
  <?php 
  $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
  ?>
		<div class="tab-content">	
			<div id="Information1" class="container tab-pane active">
			<div class="panel panel-default">
				<div class="panel-body">
					<input type="hidden" value="<?php echo $this->companyGroupId; ?>" id="company_login_id">
					<div class="col-sm-6 col-md-6 col-xs-12 vertical-border">
					<div class="item form-group">
						<label class="col-md-3 col-sm-12 col-xs-12" for="name">Supplier Name<span class="required">*</span></label>
						<div class="col-md-6 col-sm-12 col-xs-12">
						<select class="itemName form-control selectAjaxOption select2 add_supplier_detials" id="add_suplier_btn"  required="required" name="supplier_name" data-id="ledger" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>  AND save_status=1 AND parent_group_id = 3 "  width="100%"> 	
											<option value="">Select</option>			
											<?php
											if(!empty($invoice_detail)){
													//$supplier = getNameById('ledger',$purchase_data->supplier_name ,'supp_id');
													$supplier = getNameById('ledger',$invoice_detail->supplier_name ,'id');
													
													echo '<option value="'.$supplier->id.'" selected>'.$supplier->name.'</option>';
												} 
											?>    
										</select> 
						</div>
					</div> 
				
						<!-- <div class="item form-group">
							<label class="col-md-3 col-sm-12 col-xs-12" for="name">Consignee Address</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<input type="checkbox"  name="consignee_address_check"   id="consignee_address_check" <?php if(!empty($invoice_detail->consignee_address)) {echo "checked";}?>>Check For Different Consignee Address
							</div>
						</div>
						<?php if(!empty($invoice_detail)){?>
						<div class="item form-group" id="consignee_address">
							<label class="col-md-3 col-sm-12 col-xs-12" for="address_c">Name & Address</label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<textarea id="consignee_address" name="consignee_address"  class="form-control col-md-7 col-xs-12" placeholder="consignee_address" ><?php   echo $invoice_detail->consignee_address; ?></textarea>
							</div>
						</div>
						<?php }else{?>
						<div class="item form-group" id="consignee_address" style="display:none;">
							<label class="col-md-3 col-sm-12 col-xs-12" for="address_c">Name & Address </label>
							<div class="col-md-6 col-sm-12 col-xs-12">
							<textarea id="consignee_address" name="consignee_address"  class="form-control col-md-7 col-xs-12" placeholder="consignee_address" ></textarea>
							</div>
						</div>
						<?php }?>
						
						<input type="hidden"  id="sale_ledger_company_branch_id" name="sale_lger_brnch_id"  value="<?php if(!empty($invoice_detail)) echo $invoice_detail->sale_lger_brnch_id; ?>">
						input type="hidden"  id="sale_ledger_state_id" name="sale_ledger_state_id"
						<input type="hidden"  id="sale_leger_gstin_no" name="sale_leger_gstin_no" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->sale_leger_gstin_no; ?>">-->
						
						
						<input type="hidden" value="<?php if(!empty($invoice_detail)){ echo $invoice_detail->party_state_id; } ?>" id="party_billing_state_id" name="party_billing_state_id">
									
						<input type="hidden" value="<?php if(!empty($invoice_detail)){  echo $invoice_detail->sale_L_state_id;  }?>" id="sale_company_state_id" name ="sale_company_state_id">
						 
				 <div class="item form-group">
					<label class="col-md-3 col-sm-12 col-xs-12" for="pan">Supplier Pan No</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<input type="text" id="supplier_panNo" name="supplier_panNo" class="form-control col-md-7 col-xs-12" placeholder="Supplier Pan No." value="<?php if(!empty($invoice_detail)) echo $invoice_detail->supplier_panNo; ?>">
					</div>
				</div>
						<div class="item form-group">
					<label class="col-md-3 col-sm-12 col-xs-12" for="name">Supplier Phone</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<input type="text" id="party_phone" name="supplier_phone" class="form-control col-md-7 col-xs-12" placeholder="Supplier Phone No." value="<?php if(!empty($invoice_detail)) echo $invoice_detail->supplier_phone; ?>">
					</div>
				</div>
						
							
					</div>
					<div class="col-sm-6 col-md-6 col-xs-12 vertical-border">
							<div class="item form-group">
							<label class="col-md-3 col-sm-12 col-xs-12" for="Addresses">Supplier Address<span class="required">*</span></label>
							<div class="col-md-6 col-sm-12 col-xs-12">
							    <select  id="supp_address" name="supplier_state_id" class="itemName form-control" required="required">
									   <option value="">Select Address</option> 
											<?php
												if(!empty($invoice_detail)){
													$supplier_name = getNameById('ledger',$invoice_detail->supplier_name,'id');
													$add_dtl = JSON_DECODE($supplier_name->mailing_address,true);
													// pre($add_dtl);
													// pre($purchase_data);
													foreach($add_dtl as $ad_dtl){
													
														$selected = ($ad_dtl['mailing_state'] == $invoice_detail->supplier_state_id) ? ' selected="selected"' : '';
														
														
														echo '<option value="'.$ad_dtl['mailing_state'].'"  "'.$selected.'" data-gst="'.$ad_dtl['gstin_no'].'">'.$ad_dtl['mailing_address'].'</option>';
														
														
													}
													
												} 
											?>
										
									   </select>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-md-3 col-sm-12 col-xs-12" for="date_time_of_invoice_issue">Purchase Bill<span>*</span></label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<input type="text"  name="purchase_bill" id="" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->purchase_bill; ?>" Placeholder="Purchase Bill" class="form-control col-md-7 col-xs-12" required="required" >
							</div>
						</div>
						
					
						<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="date_time_of_invoice_issue">Date <span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12">
								
									<?php
									date_default_timezone_set('Asia/Kolkata');
									
									?>
									<input type="text" id="date_time_of_invoice_issue" name="date_time_of_invoice_issue" required="required" class="form-control col-md-7 col-xs-12" placeholder="Issue of Invoice" value="<?php
										if(!empty($invoice_detail)) echo date("d-m-Y", strtotime($invoice_detail->date_time_of_invoice_issue));
										if(empty($invoice_detail)){ echo date('d-m-Y');}
										?>" autocomplete="off">
									
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
<h3 class="Material-head" style="margin-bottom: 30px;">Description<hr></h3>
	<div class="tab-content">
		<div id="Description" class="container tab-pane active">
			<div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
					<div class="panel panel-default">
						<div class="panel-body goods_descr_wrapper">
						<div class="item form-group add-ro">
							<div class="col-md-12 input_descr_wrap label-box mobile-view2">
								<div class=" item col-md-2 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Ledger<span class="required">*</span></label>
								</div>
								<div class=" item col-md-2 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Ledger Address<span class="required">*</span></label>
								</div>
								<div class="col-md-2 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>
								</div>	
								<div class="col-md-2 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC<span class="required">*</span></label>
								</div>	
								<div class="col-md-1 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="Amount">Amount<span class="required">*</span></label>
								</div>	
								<div class="col-md-1 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="rate">Tax<span class="required">*</span></label>
								</div>
								<div class="col-md-2 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="rate">Amount with Tax<span class="required">*</span></label>
								</div>
								
									
								
								
							</div>			
						</div>
						<div class="col-md-12 input_descr_wrap middle-box mailing-box mobile-view">
							<div class=" col-md-2 col-sm-12 col-xs-12 form-group">
							
							<?php
									$party_name3 = getNameById_bywith_ledgers('ledger',$this->companyGroupId,'created_by_cid');
									//AND account_group_id = 7 OR parent_group_id = 7
								?>
								<select class="itemName form-control selectAjaxOption select2 sale_ledger_id_onchange" id="get_add_more_btn_forsale_ledger" required="required" name="sale_ledger" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid =0  AND activ_status = 1 )"  width="100%"> 
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
							<div class="col-md-2 col-sm-12 col-xs-12 form-group">
							<select name="sale_L_state_id" id="sale_address" class="itemName form-control" required="required">
								   <option value="">Select Address</option> 
										<?php
										//pre($invoice_detail);
											if(!empty($invoice_detail)){
												$saleLedger_address = getNameById('company_detail',$this->companyGroupId,'id');
											//pre($saleLedger_address);
												$add_dtl = JSON_DECODE($saleLedger_address->address,true);
												
												foreach($add_dtl as $ad_dtl_Sale){
												
													//$selected = ($ad_dtl_Sale['state'] == $invoice_detail->sale_L_state_id) ? ' selected="selected"' : '';
													$selected = ($ad_dtl_Sale['add_id'] == $invoice_detail->sale_lger_brnch_id) ? ' selected="selected"' : '';
													echo '<option value="'.$ad_dtl_Sale['state'].'"  "'.$selected.'" data-gst="'.$ad_dtl_Sale['company_gstin'].'" branh-id = "'.$ad_dtl_Sale['add_id'].'" >'.$ad_dtl_Sale['compny_branch_name'].'</option>';
												}
												
											} 
										?>
									
								   </select>
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">	<label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>														
										<input type="text" name="description"  class="form-control col-md-1" placeholder="Description Of Goods" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->description; ?>">
																					
									</div>														
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">	
									   <label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC<span class="required">*</span></label>														
										<select class="select2 form-control" id="HSNSacMasterID" name="hsn_code" required="required" style="font-size:17px;">
											<option value="">Select Option</option>
											<?php 
											//pre($materials->hsn_code);
											 $whereCompany = "(created_by_cid ='" . $this->companyGroupId . "')";

											 $hsnmasterData = $this->account_model->get_data('hsn_sac_master', $whereCompany);
											foreach($hsnmasterData as $hsnval){
												$totalVal = $hsnval['sgst'] + $hsnval['cgst'];
												$showVal = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$hsnval['sgst']. '  + ' . $hsnval['cgst']. '  + ' . $totalVal.'  G ';
												
												$valt = $hsnval['hsn_sac'].'   '.$showVal;
												 $SelectedVal = '';
													if($invoice_detail->hsn_code == $hsnval['hsn_sac']){ 
														$SelectedVal =  'selected';
													}
												echo '<option value="'.$hsnval['id'].'" '.$SelectedVal.' data-gst="'.$totalVal.'" data-hsncode="'.$hsnval['hsn_sac'].'">'.$valt.'</option>';
											}
											
											?>
										 </select>	
											<input type="hidden" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->hsn_code; ?>" name="hsn_code" id="hsn_code_id">	
											<input type="hidden" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->taxvalue; ?>" name="taxvalue" id="taxvalue_id">	
											<input type="hidden" name="TDS_value" id="tdsAmount" class="tdskeyV" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->TDS_value; ?>">
												<input type="hidden" name="Edu_cess" class="education" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->Edu_cess; ?>">
									</div>	
<!-- TDS script Moduls Code -->
      							<div class="col-md-1 col-sm-12 col-xs-12 form-group">	 
									 	<input type="number"  value="<?php if(!empty($invoice_detail)) echo $invoice_detail->added_amt; ?>"  name="added_amt"  id="invoice_amt"  class="form-control col-md-7 col-xs-12 check_amount" placeholder="Amount."  required="required" >														
									</div>														
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">								
										<div class="checktr">
											<input type="text" name="totaltaxAMT" id="totalTaxacc_inv"  class="form-control col-md-1 goods_descr_section " placeholder="Tax" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->totaltaxAMT; ?>" readonly >
										</div>
									</div>
									
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                   							
										<div>
											<input type="text" id="grand_total_amount"   name="TotalWithTax" class="form-control col-md-1 goods_descr_section"  placeholder="Amount" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->TotalWithTax; ?>" readonly>
											
										</div>
									</div>
								
								</div>
					</div>
				</div>
			</div>
		</div>
	</div>


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
								<textarea  name="message" class="form-control col-md-12 col-xs-12" placeholder="Message "><?php if(!empty($invoice_detail)){ echo $invoice_detail->message;} ?></textarea>
								
								
						</div>
					  
					</div>
				</div>
			
</div>			

<hr>
	
<div class="bottom-bdr"></div>
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<div class="tdskeyzV" style="display:none;">
					
		
   <table >
  <tr>
    <th></th>
    <th>Debit</th>
    <th>Credit</th>
  </tr>
  <?php 
 
		if(!empty($invoice_detail)){
			
			$edtiDtl = json_decode($invoice_detail->tds_details);
			// 
		}
		
	
		$tdsledger_name = getNameById('ledger',$edtiDtl[0]->suppler_name,'id');
		$supplier_idname = getNameById('ledger',$edtiDtl[0]->supplier_id,'id');
		$saleLedgername = getNameById('ledger',$invoice_detail->sale_ledger,'id');
		  $totleamountawithouttds=$invoice_detail->TotalWithTax;
		   $submountoftds=$edtiDtl[0]->subvalueintds;
		   $tds_cessvalue=$edtiDtl[0]->tdschareginvalid;
		   $subvaluein_ids=$totleamountawithouttds ;
		?>
  <tr>
    <td id="supplier_namewew"><?= $supplier_idname->name??'' ?></td>
    <td></td>
    <?php if ($edtiDtl){ ?>
    	 <td><?php if(!empty($invoice_detail)){ echo $edtiDtl[0]->subvalueinsubtds; } ?></td>
    <?php }else{ ?>
    <td id="tdsChargeSubxValcue"></td>
  <?php } ?>
  </tr>
  <tr>
    <td id="ledger_namesaa"><?php  if(!empty($invoice_detail)) {echo $tdsledger_name->name;} ?> </td>
    <td></td>
<?php if ($edtiDtl){?>
	 <td><?php if(!empty($invoice_detail)){ echo $edtiDtl[0]->tdscharegeinallvelue; } ?></td>
<?php }else{ ?>
    <td id="tdsCharxgeddcc"></td>
<?php } ?>
  </tr>
  <tr>
    <td id="get_ledger"><?php  if(!empty($invoice_detail)) {echo $saleLedgername->name;} ?></td>
    <td id="total_amounttclss"><?php if(!empty($invoice_detail)) {echo $invoice_detail->added_amt;} ?></td>
    <td></td>
  </tr>
  
	<?php  if(!empty($invoice_detail) && $invoice_detail->sale_L_state_id == $invoice_detail->party_state_id) { ?>
  <tr>
    <td class="sgstt"> </td>
    <td id="sgst"><?php if(!empty($invoice_detail) && $invoice_detail->SGST != '0.00' ){echo $invoice_detail->SGST;}?></td>
    <td></td>
  </tr>
  <tr>
    <td class="cgstt"></td>
    <td id="cgst"><?php	if(!empty($invoice_detail) && $invoice_detail->CGST != '0.00'){echo $invoice_detail->CGST;}?></td>
    <td></td>
  </tr>
  <?php }else{ ?>
   <tr>
    <td class="igstt"></td>
    <td id="igst"><?php	if(!empty($invoice_detail) && $invoice_detail->IGST != '0.00'){echo $invoice_detail->IGST;}?></td>
    <td></td>
  </tr>

  <?php }  if(empty($invoice_detail) ) {  ?>
  <tr class="taxRow2">
    <td class="sgstt"> </td>
    <td id="sgst"></td>
    <td></td>
  </tr>
  <tr class="taxRow2">
    <td class="cgstt"></td>
    <td id="cgst"></td>
    <td></td>
  </tr>
  <?php }else if(empty($invoice_detail) ) { ?>
   <tr class="taxRow1">
    <td class="igstt"></td>
    <td id="igst"></td>
    <td></td>
  </tr>
  <?php } ?>
  <tr>
    <td></td>
    <td id="grand_totalaccountingnb"><?php  if(!empty($invoice_detail)){ echo $invoice_detail->TotalWithTax;   }  ?></td>
    <td class="grand_totalaccountinggg"><?php  if(!empty($invoice_detail)){ echo $invoice_detail->TotalWithTax;   }  ?></td>
  </tr>
</table>


		</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right">
						    <div class="col-md-6 col-sm-5 col-xs-6 text-right">
							Sub Total 
							</div>
							<?php
							// pre();
							?>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							      <input type="text" value="<?php if(!empty($invoice_detail)) {echo $invoice_detail->added_amt;} ?>" name="added_amt" class="total_amounttclss" style="border: none;"readonly> 
							</div>
						</div>
				
						
					<div class="col-md-12 col-sm-12 col-xs-12 text-right cgst" style="border: none; display: none; ">
						<div class="col-md-6 col-sm-5 col-xs-6 text-right">
							CGST  
							</div>
						<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							<input type="text" value="<?php 
								if(!empty($invoice_detail) && $invoice_detail->CGST != '0.00'){echo $invoice_detail->CGST;}?>" class="cgst" name="CGST" style="border: none;"readonly> 
						</div>
					</div>
						<div class="col-md-12 col-sm-12 col-xs-12 text-right sgst" style="border: none; display: none; ">
						<div class="col-md-6 col-sm-5 col-xs-6 text-right">
							SGST  
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							      <input type="text" value="<?php if(!empty($invoice_detail) && $invoice_detail->SGST != '0.00' ){echo $invoice_detail->SGST;}?>" class="sgst" name="SGST" style="border: none;"readonly>  
							</div>
							 
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12 text-right igst" style="display:none;">
							<div class="col-md-6 col-sm-5 col-xs-6 text-right">IGST </div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							<input type="text" value="<?php if(!empty($invoice_detail) && $invoice_detail->IGST != '0.00' ){echo $invoice_detail->IGST;} ?>" class="igst" name="IGST" style="border: none;display:none;"readonly > 
							</div>
						</div>
						
				  <input type="hidden" name="tds_details" class="tds_details" value="">
					<div class="col-md-12 col-sm-12 col-xs-12 text-right gTotle" style="font-size: 18px;color: #2C3A61; border-top: 1px solid #2C3A61;">
						<div class="col-md-6 col-sm-5 col-xs-6 text-right">
							GRAND TOTAL 
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							    <input type="text" value="<?php 
								
								if(!empty($invoice_detail)){
									
										echo $invoice_detail->TotalWithTax;
									
								  }
								  ?>" class="grand_totalaccounting"  style="border: none;"readonly>  
							</div>
							 
					</div>
				
					
				</div>
			</div>
					<div class="form-group">
					  
						<div class="modal-footer">
						<center>
							
							<!--button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button-->
							<button type="reset" class="btn btn-default" onclick="window.location.reload()">Reset</button>
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

    <div class="modal left fade new-modal" id="myModal_Add_party" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<div class="modal left fade" id="myModal_Add_matrial_details" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog scond-modal" role="document">
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
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="emairrl">UOM<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
					<select class="uom selectAjaxOption select2 form-control  col-md-1" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php 	echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0 AND active_inactive = 1">
							<option value="">Select Option</option>
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
	
	
	  <div class="modal left fade new-modal" id="myModal_Add_salesPerson" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
			<div class="modal-header">
		
                <h4 class="modal-title" id="myModalLabel">Add Sales Person</h4>
				<span id="mssg"></span>
			</div>
			<form name="insert_salesPerson_data" name="ins"  id="insert_salesPerson_data">
                 <div class="modal-body">
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="name">User Name <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						 <input id="salesPersonname" class="form-control col-md-7 col-xs-12" name="name" placeholder="both name(s) e.g Jon Doe" required="required" type="text" value="">
						 <span class="spanLeft control-label"></span>
					</div>
				</div>
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="email">Email </label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						 <input type="email" id="salesemail" name="email" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter email"  value="">
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="name">Gender<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<div class="col-md-6 col-sm-6 col-xs-12"> 
                                    Male: <input type="radio" class="flat" name="gender" id="genderM" value="Male"  required /> 
                                    Female: <input type="radio" class="flat" name="gender" id="genderF" value="Female"  />                            
                                 </div>
				
						<span id="acc_grp_id"></span>
					</div>
				</div>
			
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-4" for="gstin">Phone</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="tel" id="salesphone" name="contact_no" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter mobile number" value="">
							<span class="spanLeft control-label"></span>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="gstin">Designation <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						 <input type="text" id="salesdesignation" name="designation" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter designation" value="">        
						<span id="contry"></span>
					</div>
				</div>
				
				</div>
                <div class="modal-footer">
				<input type="hidden" id="sale_ledger_data">
				    <button type="button" class="btn btn-default close_sec_model close_modal2" >Close</button>
					<button id="bbttnSalePerson" type="button" class="btn btn-warning">Submit</button>
                </div>
				</form>
            </div>
        </div>
    </div>
	
	
	 <div class="modal left fade new-modal " id="myModal_Add_Charges" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
			<div class="modal-header">
		
                <h4 class="modal-title" id="myModalLabel">Add Charges</h4>
				<span id="mssg_charges"></span>
			</div>
			<form name="insert_charges_data" name="ins"  id="insert_charges_data" style="padding: 25px 0px;">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<input type="hidden" name="id" value="">
					
					
						 <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Charges Heading<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="particular_charges" name="particular_charges" required="required" data-validate-length-range="4"  class="form-control col-md-7 col-xs-12" placeholder="Charges Headings" value="">
								</div>
							</div>
							<div class="item form-group"> 
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Ledger Name<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="itemName form-control selectAjaxOption select2 add_option party_name_ledger_id_onchange" id="chargesledgerName" required="required" name="ledger_id" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $this->companyGroupId; ?>) AND activ_status = 1"  width="100%"> 
										<option value="">Select And Begin Typing</option>
										
									</select>    
								</div>
							</div>
														
							
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Type of Charges<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									 <p>
										Plus:
										<input type="radio" class="flat typecharges" name="type_charges"  value="plus"  required  /> Minus:
										<input type="radio" class="flat typecharges" name="type_charges"  value="minus"  />
									  </p>
								</div>
							</div>
						</div>
						
						<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">	
							 <div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12">Amount of charges to be fed as <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <p>
									Absolute Amount:
									<input type="radio" class="flat chargesFedas" id="chargesFedasID" name="amount_of_charges"  value="absoluteamount"   autofocus required  /><br/> Percentage:
									<input type="radio" class="flat chargesFedas" id="chargesFedasID" name="amount_of_charges"  value="percentage"  /><br/>
									
								  </p>
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Tax<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select name="tax_slab" id="taxVal" class="form-control itemName select2" required="required">
										<option name="" value="0">Select Tax Slab</option>
										<option value="0" >0  % </option>
										<option value="5" >05 % </option>
										<option value="12">12 % </option>
										<option value="18">18 % </option>
										<option value="28">28 % </option>
									</select>
								</div>
							</div>
						</div>
		
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<div class="form-group">
						<div class="modal-footer">
						<center>
							<button type="button" class="btn btn-default close_sec_model close_modal2" >Close</button>
							<button id="bbttnCharges" type="button" class="btn btn-warning">Submit</button>
							<!--button id="send" type="submit" class="btn btn-warning">Submit</button-->
						</center>
						</div>
					</div>
				</form>
			</div>
            </div>
        </div>
    </div>
 </div>
<!-- Add MAtrial Popup -->
<style> .alert{display:none;}</style>


<!-- TDS Module -->

<div class="modal fade" id="myModalTDS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> TDS Inward</h4>
      </div>
      <div class="modal-body">

        <form name="insert_TDS"  id="insert_TDS" method="post">
		
		
                 <div class="modal-body">
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="name">Ledger to Credit<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<!-- <select class="itemName form-control selectAjaxOption select2 add_supplier_detials" id="ledger_name"  required="required" name="ledger_name" data-id="ledger" data-key="id" data-fieldname="name" data-where="created_by_cid=0  AND save_status=1  "  width="100%"> 	
											<option value="">Select</option>			
											<?php
											if(!empty($invoice_detail)){
													//$supplier = getNameById('ledger',$purchase_data->supplier_name ,'supp_id');
													$supplier = getNameById('ledger','7' ,'id');
													
													echo '<option value="'.$supplier->id.'" selected>'.$supplier->name.'</option>';
												} 
											?>    
										</select>  -->
										<select class="itemName form-control  select2 " id="ledger_name"  required="required" name="ledger_name" width="100%"> 	
											<option value="7">TDS</option>			
										<!-- 	<?php
											//if(!empty($invoice_detail)){
													//$supplier = getNameById('ledger',$purchase_data->supplier_name ,'supp_id');
													$supplier = getNameById('ledger','7' ,'id');
													
													//echo '<option value="'.$supplier->id.'" selected>'.$supplier->name.'</option>';
												//} 
											?>     -->
										</select> 
					<!-- 	 <input id="supplier_name" readonly="readonly" class="form-control col-md-7 col-xs-12" name="supplier_name" placeholder="both name(s) e.g Jon Doe" required="required" type="text" value="<?php if(!empty($invoice_detail)){ echo $edtiDtl[0]->suppler_name; } ?>"> -->
						 <input type="hidden" name="supplier_id" id="add_suplier_id"  value="<?php if(!empty($invoice_detail)){ echo $edtiDtl[0]->supplier_id; } ?>" >
						 <span class="spanLeft control-label"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-4" for="panno">Pan No.</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="pan_no" name="pan_no" required="required"  class="form-control col-md-7 col-xs-12" placeholder="Pan No." value="<?php if(!empty($invoice_detail)){ echo $edtiDtl[0]->pan_no; } ?>">
							<span class="spanLeft control-label"></span>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-4" for="natureofpayment">Nature of Payment</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="nature_of_payment" name="nature_of_payment" required="required" class="form-control col-md-7 col-xs-12" placeholder="Nature of Payment" value="<?php if(!empty($invoice_detail)){ echo $edtiDtl[0]->nature_of_payment; } ?>">
							<span class="spanLeft control-label"></span>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-4" for="amountcredit">Amount Credited</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="number" id="amount_credit" name="amount_credit" required="required" class="form-control col-md-7 col-xs-12" placeholder="Amount Credited" value="<?php if(!empty($invoice_detail)){ echo $edtiDtl[0]->amount_credit; } ?>">
							<span class="spanLeft control-label"></span>
						</div>
					</div>
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="tds">TDS % </label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						 <input type="number" onkeyup="tdsVaCha(this);" id="tdsvalue" value="<?php if(!empty($invoice_detail)){ echo $edtiDtl[0]->tdsvalue; } ?>" name="tdsvalue"  required="required" class="form-control col-md-7 col-xs-12" placeholder="TDS %" >
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="educationcess">Education Cess %</label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						 <input type="number" onkeyup="tdsVaCha(this);" value="<?php if(!empty($invoice_detail)){ echo $edtiDtl[0]->education_cess; } ?>" id="education_cess" name="education_cess" required="required" class="form-control col-md-7 col-xs-12" placeholder="Education Cess" >
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="email">Challan No. </label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						 <input type="text" id="challan_no" name="challan_no" required="required" class="form-control col-md-7 col-xs-12" placeholder="Challan No."  value="<?php if(!empty($invoice_detail)){ echo $edtiDtl[0]->challan_no; } ?>">
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="email">Challan Date</label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						 <input type="date" id="challan_date" name="challan_date" required="required" class="form-control col-md-7 col-xs-12" placeholder="Challan Date"  value="<?php if(!empty($invoice_detail)){ echo $edtiDtl[0]->challan_date; } ?>">
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="email">BSR Code </label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						 <input type="text" id="bsrcode" name="bsrcode" required="required" class="form-control col-md-7 col-xs-12" placeholder="BSR Code"  value="<?php if(!empty($invoice_detail)){ echo $edtiDtl[0]->bsrcode; } ?>">
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="email">Chq/DD No</label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						 <input type="number" id="chq_dd" name="chq_dd" required="required" class="form-control col-md-7 col-xs-12" placeholder="Chq/DD No" value="<?php if(!empty($invoice_detail)){ echo $edtiDtl[0]->chq_dd; } ?>">
						<span class="spanLeft control-label"></span>
					</div>
				</div>
			 </div>
        


        <div class="modal-footer">
     <div class="tdskeyzV"  style="display:none;">
   <table>
  <tr>
    <th>TDS</th>
    <th>Education Cess</th>
    <th>Total</th>
  </tr>
  <tr>
    <td id="tdskeyV"></td>
    <td id="education"></td>
    <td id="totletdsamt"></td>
  </tr>
</table>
      </div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="SaveTDS_Data();" class="btn btn-primary">Save changes</button>
      </div>

				</form>
      </div>
     
    </div>
  </div>
</div>