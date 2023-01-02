<?php
setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
	?>
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saveinwordChallan_Details" enctype="multipart/form-data"  novalidate="novalidate">
		<input type="hidden" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="login_user_idddd">
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<input type="hidden" name="save_status" value="1" class="save_status">
				<input type="hidden" name="id" value="<?php if(!empty($delivery_data)) echo $delivery_data->id; ?>">
				<input type="hidden" name="branch_name" value="<?php if(!empty($delivery_data)) echo $delivery_data->branch_name; ?>">



<div class="container mt-3">

  <!-- Nav tabs -->
  <?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;



  ?>
  <h3 class="Material-head" style="margin-bottom: 30px;">Challan Information<hr></h3>
  <div class="tab-content">
 <div id="Information1" class="container tab-pane active">
 <div class="panel panel-default">

						<div class="panel-body">
						<input type="hidden" value="<?php echo $this->companyGroupId; ?>" id="company_login_id">
						<div class="col-sm-6 col-md-6 col-xs-12 vertical-border">
						<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Challan Type </label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<input type="radio" name="challan_type" value="1" <?php if(!empty($delivery_data)) echo ($delivery_data->challan_type ==1)?'checked':'' ?> id="non_return_type"> Non Returnable Challan<br>
										<input type="radio" name="challan_type" value="0" <?php if(!empty($delivery_data)) echo ($delivery_data->challan_type ==0)?'checked':'' ?> id="return_type"> Returnable Challan<br>
									</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Branch Name<span class="required">*</span></label>
								<?php
								$companyDetails = getNameById('company_detail',$this->companyGroupId,'id');

								?>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<select class="itemName form-control selectAjaxOption select2"   name="branch_name" data-id="company_detail" data-key="id" data-fieldname="name" data-where="parent_cid=<?php echo $companyDetails->parent_cid; ?>"  width="100%">
											<option value="">Select</option>
											<?php

												if(!empty($delivery_data)){
													$party_name = getNameById('company_detail',$delivery_data->branch_name,'id');
													//pre($party_name);
													echo '<option value="'.$party_name->id.'" selected>'.$party_name->name.'</option>';
												}
											?>
										</select>
									</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Receiver Name<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<select class="itemName form-control selectAjaxOption select2 add_option party_name_ledger_id_onchange" id="get_add_more_btn" required="required" name="reciver_name" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by=0) AND activ_status = 1"  width="100%">
											<option value="">Select</option>
											<?php
												if(!empty($delivery_data)){
													$party_name = getNameById('ledger',$delivery_data->reciver_name,'id');
													echo '<option value="'.$party_name->id.'" selected>'.$party_name->name.'</option>';
												}
											?>
										</select>
									</div>
							</div>
							<div class="item form-group">
									<label class="col-md-3 col-sm-12 col-xs-12" for="Addresses">Receiver Address</label>
									<div class="col-md-6 col-sm-12 col-xs-12">
									    <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="reciver_address" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" onchange="getArea(event,this);" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
										<option>Select Option</option>
										<?php
										if(!empty($delivery_data)){

										$locationArea = getNameById('company_address',$delivery_data->reciver_address,'id');
											echo '<option value="'.$locationArea->id.'" selected>'.$locationArea->location.'</option>';

										}
									?>
									</select>
									</div>
							</div>

							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Supplier Name<span class="required">*</span></label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<select class="itemName form-control selectAjaxOption select2 add_option party_name_ledger_id_onchange" id="get_add_more_btn" required="required" name="supplier_ledger" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by=0) AND activ_status = 1"  width="100%">
											<option value="">Select</option>
											<?php
												if(!empty($delivery_data)){
													$party_name = getNameById('ledger',$delivery_data->supplier_ledger,'id');
													echo '<option value="'.$party_name->id.'" selected>'.$party_name->name.'</option>';
												}
											?>
										</select>
									</div>
							</div>
							<div class="item form-group">
									<label class="col-md-3 col-sm-12 col-xs-12" for="Addresses">Supplier Address</label>
									<div class="col-md-6 col-sm-12 col-xs-12">
									    <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="supplier_address" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" onchange="getArea(event,this);" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
										<option>Select Option</option>
										<?php
										if(!empty($delivery_data)){

										$locationArea = getNameById('company_address',$delivery_data->supplier_address,'id');
											echo '<option value="'.$locationArea->id.'" selected>'.$locationArea->location.'</option>';

										}
										?>
									</select>
									</div>
								</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="name">Receiver Phone<span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="party_phone" name="party_phone" required="required"   class="form-control col-md-7 col-xs-12" placeholder="Receiver Phone No." value="<?php if(!empty($delivery_data)) echo $delivery_data->party_phone; ?>">
								</div>
							</div>

							</div>
							<?php
								if(!empty($delivery_data)){
								 $Challan_id = $delivery_data->challan_num;

								}else{

									$p_Data = get_challan_number_count('challan_dilivery_inword',$this->companyGroupId ,'branch_name');

									$Challan_id =  $p_Data->total_challan + 1; ?></center>
								<?php } ?>
							<div class="col-sm-6 col-md-6 col-xs-12 vertical-border">
							<div class="item form-group">
                                <label class="col-md-3 col-sm-12 col-xs-12" for="challan_num">Challan Number<span>*</span></label>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <input type="text"  name="challan_num" id="challan_num_id" Placeholder="Challan Number" class="form-control col-md-7 col-xs-12" required="required" value="<?php echo sprintf("%04s", $Challan_id); ?>">
                                </div>
							</div>


							<div class="item form-group">
										<?php
										date_default_timezone_set('Asia/Kolkata');
										$date = date('d-m-Y');
										?>
								<label class="col-md-3 col-sm-12 col-xs-12" for="challan_date">Date<span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="text" id="challan_date_id" name="challan_date" required="required" class="form-control col-md-7 col-xs-12" placeholder="Issue of Challan" value="<?php if(!empty($delivery_data)){ echo $delivery_data->challan_date;}else{ echo $date;} ?>" autocomplete="off">

								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="type">Vehicle Number</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="tel" id="vehicle_reg_no" name="vehicle_reg_no"  class="form-control col-md-7 col-xs-12" placeholder="Vehicle Number" value="<?php if(!empty($delivery_data)) echo $delivery_data->vehicle_reg_no; ?>">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="type">Transport Tel No. </label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="tel" id="transporter_phone" name="transporter_phone"  class="form-control col-md-7 col-xs-12" placeholder="Transport Tel No." value="<?php if(!empty($delivery_data)) echo $delivery_data->transporter_phone; ?>">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-3 col-sm-12 col-xs-12" for="terms_of_delivery">Terms of Delivery</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<textarea id="terms_of_delivery"  name="terms_of_delivery" class="form-control col-md-7 col-xs-12" placeholder="Terms of Delivery"><?php if(!empty($delivery_data)) echo $delivery_data->terms_of_delivery; ?></textarea>
								</div>
							</div>

							<div class="required item form-group">
							   <label class="col-md-3 col-sm-12 col-xs-4" for="comment">Comment</label>
							   <div class="col-md-6 col-sm-12 col-xs-12">
								   <textarea  type="text"  id="comment" name="comment" class="comment form-control" ><?php if(!empty($delivery_data)) echo $delivery_data->comment;  ?></textarea>
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


<h3 class="Material-head" style="margin-bottom: 30px;">Description<hr></h3>
<div class="tab-content">
 <div id="Description" class="container tab-pane active">
       <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">

					<div class="panel panel-default">

						<div class="panel-body goods_descr_wrapper">
						<div class="item form-group add-ro">
							<div class="col-md-12 input_descr_wrap label-box mobile-view2">
								<div class="col-md-2 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Material Name <span class="required">*</span></label>
								</div>
								<div class="col-md-2 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>
								</div>
								<div class="col-md-1 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC<span class="required">*</span></label>
								</div>
								<div class="col-md-1 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="quantity">Quantity<span class="required">*</span></label>
								</div>
								<div class="col-md-1 col-xs-12 item form-group">
									<label class="col-md-12 col-sm-12 col-xs-12" for="rate">Rate<span class="required">*</span></label>
								</div>


								<div class="<?php if($delivery_data->challan_type == 0){ echo 'col-md-1';}else{ echo 'col-md-2';}?> col-xs-12 item form-group totl_amt">
									<label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label>
								</div>
								<div class="<?php if($delivery_data->challan_type == 0){ echo 'col-md-1';}else{ echo 'col-md-2';}?> col-xs-12 item form-group totl_amt" style="overflow: hidden;">
									<label style="border-right: 1px solid #c1c1c1" class="col-md-12 col-sm-12 col-xs-12" for="amount">Total Amount<span class="required">*</span></label>
								</div>
								<div class="col-md-1 col-xs-12 item form-group <?php if($delivery_data->challan_type == 0){ echo 'show_cls';} else{ echo 'hid_cls';}?>" style="overflow: hidden;">
									<label style="border-right: 1px solid #c1c1c1" class="col-md-12 col-sm-12 col-xs-12" for="amount">BOM Number </label>
								</div>
								<div class="col-md-2 col-xs-12 item form-group <?php if($delivery_data->challan_type == 0){ echo 'show_cls';} else{ echo 'hid_cls';}?>" style="overflow: hidden;">
									<label style="border-right: 1px solid #c1c1c1" class="col-md-12 col-sm-12 col-xs-12" for="amount">Process Name </label>
								</div>


							</div>

							<?php  if(empty($delivery_data)){



							?>
								<div class="col-md-12 input_descr_wrap middle-box mailing-box mobile-view">

									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
										<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Martial Name <span class="required">*</span></label>
										<select class="itemName  form-control selectAjaxOption select2 get_val_challan matrial_details_id" id="add_matrial_onthe_spot"  required="required" name="material_id[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND status=1" width="100%">
											<option value="">Select</option>
											<?php
											if(!empty($delivery_data)){
											   $material_id_datas = json_decode($delivery_data->material_id,true);
												$material_names = '';
													foreach($material_id_datas  as $matrial_new_id){
														 $material_id_get = $matrial_new_id['material_id'];

															$meterial_data = getNameById('material',$material_id_get,'id');
															echo '<option value="'.$material_id_get.'" selected>'.$meterial_data->material_name.'</option>';
														}

													}
											?>
									</select>
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">	<label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>
										<input type="text" name="descr_of_goods[]"  class="form-control col-md-1" placeholder="Description Of Goods" value="">

									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
									   <label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC<span class="required">*</span></label>
										<input type="text" name="hsnsac[]" required="required" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC" value="">
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
									   <label class="col-md-12 col-sm-12 col-xs-12" for="quantity">Quantity<span class="required">*</span></label>
										<input type="text" name="quantity[]" required="required" class="form-control col-md-1 year goods_descr_section keyup_event_challan qty add_qty" placeholder="Quantity" value="">
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                         <label class="col-md-12 col-sm-12 col-xs-12" for="rate">Rate<span class="required">*</span></label>
										<div class="checktr">
											<input type="text" name="rate[]"  class="form-control col-md-1 goods_descr_section keyup_event_challan rate" placeholder="Rate" value="" >
										</div>
									</div>



									<div class="col-md-1 col-sm-12 col-xs-12 form-group totl_amt">
									    <label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label>
										<div >
										<?php
											$uoms = measurementUnits();
											$uoms_Json = json_encode($uoms);


										?>

										<!--<input type="" name="UOM[]" class="form-control col-md-1 goods_descr_section "  placeholder="UOM">-->


										<input type="text" name="UOM1[]" class="form-control col-md-1 goods_descr_section" placeholder="UOM" readonly>

										<input type="hidden" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly>


										</div>
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group totl_amt">
                                        <label style="border-right: 1px solid #c1c1c1" class="col-md-12 col-sm-12 col-xs-12" for="amount">Total Amount<span class="required">*</span></label>
										<div>
											<input type="text"   name="amount[]" class="form-control col-md-1 goods_descr_section"  placeholder="Amount" value="" readonly>

										</div>
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group show_cls">
                                         <label class="col-md-12 col-sm-12 col-xs-12" for="rate">BOM Number</label>
											<select class="itemName  form-control selectAjaxOption select2 goods_descr_section get_process_name" name="bom_number[]" data-id="job_card" data-key="id" data-fieldname="job_card_no" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND save_status=1" width="100%"><option value="">Select</option>
											</select>
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group show_cls">
                                         <label class="col-md-12 col-sm-12 col-xs-12" for="rate">Process Name</label>
										<select class="form-control process_name_id  goods_descr_section" name="process_name[]" tabindex="-1" aria-hidden="true"   id="process_name_id">
											   <option value="">Select Option</option>
										</select>
									</div>
								</div>
                                <!--div class="col-sm-12 btn-row"><button class="btn btn-primary add_description_detail_button_challan" type="button">Add</button></div-->
							<?php }


							if(!empty($delivery_data) && $delivery_data->descr_of_goods !=''){



								$challan_details = json_decode($delivery_data->descr_of_goods);
									if(!empty($challan_details)){
										$i = 0;
										foreach($challan_details as $delivery_datas){
								?>
							<div class="col-md-12 input_descr_wrap middle-box mailing-box mobile-view <?php if($i==0){ echo 'scend-tr edit-row1';}else{ echo ' scend-tr';}?>" style="margin-bottom: 0px; ">

							<div class="col-md-2 col-sm-12 col-xs-12 form-group">
							       <label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Material Name <span class="required">*</span></label>
									<select class="itemName form-control selectAjaxOption select2 get_val_challan matrial_details_id"  required="required" name="material_id[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>" width="100%" <?php if($delivery_data->auto_entry_po == 1){ echo"disabled";} ?>>
											<option value="">Select</option>
											<?php
											if(!empty($delivery_datas)){
													$material = getNameById('material',$delivery_datas->material_id,'id');
													echo '<option value="'.$delivery_datas->material_id.'" selected>'.$material->material_name.'</option>';
											}


											?>
										</select>
									</div>
								<div class="col-md-2 col-sm-12 col-xs-12 form-group">
								       <label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>
									   <input type="text" name="descr_of_goods[]"  class="form-control col-md-1" placeholder="Description Of Goods" value="<?php if(!empty($delivery_datas)) echo $delivery_datas->descr_of_goods; ?>">
										<!--textarea  name="descr_of_goods[]" class="form-control col-md-12 col-xs-12" placeholder="Description Of Goods"></textarea-->
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
									    <label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC<span class="required">*</span></label>
										<input type="text" name="hsnsac[]" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC" value="<?php if(!empty($delivery_datas)){ echo $delivery_datas->hsnsac;} ?>">
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
									   <label class="col-md-12 col-sm-12 col-xs-12" for="quantity">Quantity<span class="required">*</span></label>
										<input type="text"  required="required" name="quantity[]" class="form-control col-md-1 year goods_descr_section keyup_event_challan " placeholder="Quantity" value="<?php if(!empty($delivery_datas)){ echo $delivery_datas->quantity;} ?>" <?php if($delivery_data->auto_entry_po == 1){ echo"disabled";} ?>>
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="rate">Rate<span class="required">*</span></label>
										<div class="checktr">
											<input type="text" name="rate[]" class="form-control col-md-1 goods_descr_section keyup_event_challan" placeholder="Rate" value="<?php if(!empty($delivery_datas)){ echo $delivery_datas->rate;} ?>" <?php if($delivery_data->auto_entry_po == 1){ echo"disabled";} ?>>
										</div>
									</div>



								<div class="<?php if($delivery_data->challan_type == 0){ echo 'col-md-1';}else{ echo 'col-md-2';}?> col-sm-12 col-xs-12 form-group totl_amt">
									<label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label>
									<div>
										<?php
											$uoms = measurementUnits();
											$uoms_Json = json_encode($uoms);


										?>


										<!--<input type="" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly value="<?php //if(!empty($delivery_datas)){ echo $delivery_datas->UOM;} ?>">-->


										<input type="text" name="UOM1[]" class="form-control col-md-1 goods_descr_section " readonly

											value="<?php  $ww = getNameById('uom',$delivery_datas->UOM,'id'); echo $ww->ugc_code; ?>" >




										<input type="hidden" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly value="<?php echo $ww->id; ?>">
									</div>
									</div>
									<div class="<?php if($delivery_data->challan_type == 0){ echo 'col-md-1';}else{ echo 'col-md-2';}?> col-sm-12 col-xs-12 form-group totl_amt">
                                        <label style="border-right: 1px solid #c1c1c1" class="col-md-12 col-sm-12 col-xs-12" for="amount">Total Amount<span class="required">*</span></label>
										<div>
											<input type="text" id="amount"   name="amount[]" class="form-control col-md-1 goods_descr_section " readonly placeholder="Amount" value="<?php if(!empty($delivery_datas)){ echo $delivery_datas->amount;} ?>" readonly >

										</div>
									</div>

							<?php

								//pre($delivery_data);
							?>

						<div class="col-md-1 col-sm-12 col-xs-12 form-group <?php if($delivery_data->challan_type == 0){ echo 'show_cls';} else{ echo 'hid_cls';}?>" >
							 <label class="col-md-12 col-sm-12 col-xs-12" for="rate">BOM Number<span class="required">*</span></label>
							   <select class="itemName  form-control selectAjaxOption select2 goods_descr_section get_process_name" name="bom_number[]" data-id="job_card" data-key="id" data-fieldname="job_card_no" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND save_status=1" width="100%" <?php if($delivery_data->auto_entry_po == 1){ echo"disabled";} ?>>
								<option value="">Select</option>
								<?php
								if(!empty($delivery_data)){
								   $meterial_data = getNameById('job_card',$delivery_datas->bom_number,'id');
								   echo '<option value="'.$delivery_datas->bom_number.'" selected>'.$meterial_data->job_card_no.'</option>';
								}
								?>
							</select>

						</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group <?php if($delivery_data->challan_type == 0){ echo 'show_cls';} else{ echo 'hid_cls';}?>">
                                         <label class="col-md-12 col-sm-12 col-xs-12" for="rate">Process Name<span class="required">*</span></label>
									 		<select class="form-control process_name_id  goods_descr_section" required="required" name="process_name[]" tabindex="-1" aria-hidden="true" required="required"  id="process_name_id" <?php if($delivery_data->auto_entry_po == 1){ echo"disabled";} ?>>
											   <option value="">Select Option</option>
											   <?php

												  if(!empty($delivery_data)){
													$process_data = getNameById('add_process',$delivery_datas->process_name,'id');
													echo '<option value="'.$delivery_datas->process_name.'" selected>'.$process_data->process_name.'</option>';
												  }
												  ?>
											</select>

									</div>



							<?php

							// if($i==0){
									// echo '<div class="col-sm-12 btn-row"><button class="btn btn-primary add_description_detail_button_challan" type="button">Add</button></div>';
								// }else{
									// echo '<button class="btn btn-danger remove_descr_field_challan" type="button"> <i class="fa fa-minus"></i></button>';
							// }
							?>
								</div>
							<?php
							$i++;
								}
								}

							}?>




						</div>
						</div>

					</div>

                    </div>
 </div>

	</div>
</div>
<hr>
<div class="bottom-bdr"></div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">

<hr>


						<div class="col-md-4 col-sm-12 col-xs-12 text-right" style="font-size: 20px;color: #2C3A61; border-top: 1px solid #2C3A61; float:right;">
						<div class="col-md-6 col-sm-5 col-xs-6 text-right">
							GRAND TOTAL
							</div>
							<div class="col-md-6 col-sm-5 col-xs-6 text-left">
							<?php
							$total_amounty = money_format('%!i',$delivery_data->challan_total_amt);

							?>
							      <input type="text" value="<?php if(!empty($delivery_data)){ echo $total_amounty;} ?>" class="challan_total_amt3" style="border: none;"readonly >
							      <input type="hidden" value="<?php if(!empty($delivery_data)){ echo $delivery_data->challan_total_amt;} ?>" class="challan_total_amt" name="challan_total_amt" style="border: none;"readonly>
							</div>

						</div>
					</div>


				</div>
					<div class="form-group">

						<div class="modal-footer">
						<center>

							<!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
							<button type="reset" class="btn btn-default">Reset</button>
							<?php if((!empty($delivery_data) && $delivery_data->save_status ==0) || empty($delivery_data)){
									echo '<input type="submit" class="btn edit-end-btn draftBtn" name="save_draft" value="Save as draft">';
							}?>
							<button id="send" type="submit" class="btn btn-warning">Submit</button>
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
				    <button type="button" class="btn btn-default close_sec_model" >Close</button>
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
				    <button type="button" class="btn btn-default close_sec_model" >Close</button>
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
