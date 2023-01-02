<?php if(!empty($register_opportunity)) { 

	?>
	<div class="row leadBasicData">
	<!--------code to display to lead converted to accounts/contact button at the time of edit----------------->
		
		<div class="bottom-bdr"></div>
		<!--------------displayed status of lead at the time of edit-------------------------------->	
		<div id="wizard" class="form_wizard wizard_horizontal ">
			<ul class="wizard_steps flex">
			<!--<div class="f1-progress">
				<div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3" style="width: 16.66%;"></div>
			</div>-->
			<?php foreach($tenderstatus as $tenderstatuss){ 	?>
				<li class="flex-item">
					<a>
						<span class="step_no <?php if ($tenderstatuss['id'] == $register_opportunity->tender_status){ echo 'active-status';} ?>" id="status_id_<?php echo $tenderstatuss['id']; ?>" style="background:<?php echo $tenderstatuss['id'] == $register_opportunity->tender_status?'':'#ccc'; ?>" onclick="changeStatus(<?php echo $register_opportunity->id ;?> , '<?php echo $tenderstatuss['id'] ;?>','<?php echo $register_opportunity->tender_status ;?>' )"><?php echo $tenderstatuss['name'] ;?></span>
					</a>
				</li>
			<?php } ?>				
			</ul>
		</div>
	</div>
	
	<?php

	 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	?>
	<!------------------------------display tabs of activity chatte detail------------------------------------------>
	<div class="row">
		<div class="col-md-12">		
			<div class="col-md-12 col-sm-12 col-xs-12">
				<!----------------display activity /chatter/detail tab--------------------->
				<ul class="nav nav-tabs bar_tabs tab-4" role="tablist" id="myTab">
                    <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Activity</a></li>			
					<li><a href="#chatter" data-toggle="tab" id="tChatter">Chatter</a></li>
					<li><a href="#detail" data-toggle="tab">Detail</a></li>
					<li><a href="#upload" data-toggle="tab">Upload</a></li>
					<?php /** if($register_opportunity->tender_status!=5){**/?>
					<li><a href="#loa" data-toggle="tab">LOA</a></li>
					<li><a href="#po" data-toggle="tab">PO</a></li>
					<?php /** }**/?>
				</ul>
				<!------------data display under activity /log a call/new task tab----------------------->
				<div class="tab-content" >
					<!-----------------start of activity tab--------------------------------------->
					<!--------------------start of chatter tab------------------------------------->
					<div class="tab-pane" id="chatter">
						<form method="post" id="callLogForm" class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>bid_management/save_register_opportunity_Activity">
							<input type="hidden" name="id" value="<?php // if(!empty($leadCallLog)) echo $leadCallLog->id; ?>">
							<input type="hidden" name="lead_id" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->id; ?>">	
							<input type="hidden" name="activity_type" value="Chatter">	
							<input type="hidden" name="subject" value="Chatter">	
							<h4>To : This Tender</h4>	
                             <div class="col-sm-12 col-md-6 col-xs-12">							
							<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
								<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Comments</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="comment" rows="6" id="comment" required="required" class="form-control col-md-7 col-xs-12"></textarea>
								</div>
							</div>					
							<div class="item form-group">
								<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Attachments</label>
								<div class="col-md-7 col-sm-9 col-xs-12 ">
									<input type="file" class="form-control col-md-2 col-sm-2 col-xs-12" name="attachment[]"> 
								</div>
								<button class="btn field_button" type="button"><i class="fa fa-plus"></i></button>
								
							</div>
							<div class="item form-group fields_wrap" >
								
								</div>
							</div>
							<br />
							<div class="ln_solid"></div>												
							<div class="form-group">													
								<div class="col-md-12 ">														
									<button type="reset" class="btn btn-default">Reset</button>														
									<input type="submit" class="btn chatter edit-end-btn" value="Save">													
								</div>												
							</div>			
						</form>
					<!--------------------------end of chatter tab --------------------------------->
					

	
				
					
</div>	
<!------------------ Edit lead form modal start-------------------->
					<div class="tab-pane" id="detail" >
						<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>bid_management/save_register_opportunity" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
							<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
							<input type="hidden" name="id" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->id; ?>">	
							<input type="hidden" name="save_status" value="1" class="save_status">	
							<div class="item form-group">
							<h3 class="Material-head">Tender Details<span class="required">*</span><hr></h3>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group input_holder middle-box">
								<?php if(empty($register_opportunity)){ ?>
                                     <div class="col-sm-12  col-md-12 label-box mobile-view2">
								   <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Tender Number<span class="required">*</span></label></div>
								   <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Department Name</label></div>
								   <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Tender Type</label></div>
								   
				   
									</div>
									
									<div class="well scend-tr mobile-view" id="chkIndex_1">
										<div class="item form-group col-md-3 col-xs-12">
											<label class="col-md-12 col-sm-12 col-xs-12" for="name">Tender Number<span class="required">*</span></label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<input id="name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($register_opportunity)) echo $lead->tender_name; ?>" name="tender_name[]" placeholder="Tender Number" required="required" type="text" > 
											</div>
										</div>
										<div class="item form-group col-md-3 col-xs-12">
											<label class="col-md-12 col-sm-12 col-xs-12" for="name">Department Name</label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<input id="last_name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->department_name; ?>" name="department_name[]" placeholder="Department Name" type="text">
											</div>
										</div>
										<div class="item form-group col-md-3 col-xs-12">
											<label class="col-md-12 col-sm-12 col-xs-12" for="email">Tender Type</label>
											<div class="col-md-10 col-sm-10 col-xs-12">
												<input type="email" id="email" name="tender_link[]"  class="form-control col-md-7 col-xs-12" placeholder="Tender Link" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->tender_link; ?>"> 
											</div>
										</div>   
										
										<button class="btn btn-danger remove_field" type="button"> <i class="fa fa-minus"></i></button>	
										
									</div>	
									<div class="col-sm-12 btn-row">
							            <div class="input-group-append">
											<button class="btn edit-end-btn addMoreLead" type="button">Add</button>
										</div>
										</div>
									<?php }
									if(!empty($register_opportunity)){ 
										$tenders_details = json_decode($register_opportunity->tender_detail);
										if(!empty($tenders_details)){ 
											$i =1;
											?>
											<div class="col-sm-12  col-md-12 label-box mobile-view2">
											  <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Tender Number<span class="required">*</span></label></div>
											   <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Department Name</label></div>
											   <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Tender Type</label></div>
											   				  
								           </div>
											<?php
											foreach($tenders_details as $td){	?>
												<div class="well <?php if($i==1){ echo 'edit-row1 scend-tr mobile-view';}else{ echo 'scend-tr mobile-view';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">
													<div class="item form-group col-md-4 col-xs-12">
														<label>Tender Number<span class="required">*</span></label>
														<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
															<input id="name" class="form-control col-md-7 col-xs-12" value="<?php  echo $td->tender_name; ?>" name="tender_name[]" placeholder="Tender Number" required="required" type="text" > 
														</div>
													</div>
													<div class="item form-group col-md-4 col-xs-12">
														<label>Department Name</label>
														<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
															<input id="last_name" class="form-control col-md-7 col-xs-12" value="<?php echo $td->department_name; ?>" name="department_name[]" placeholder="Department Name" type="text">
														</div>
													</div>
													<div class="item form-group col-md-4 col-xs-12">
														<label>Tender Type</label>
														<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
															<input type="email" id="email" name="tender_link[]" class="form-control col-md-7 col-xs-12" placeholder="Tender Link" value="<?php echo $td->tender_link; ?>"> 
														</div>
													</div>   
													
											
														<button class="btn btn-danger remove_field" type="button"> <i class="fa fa-minus"></i></button>					
													
												</div>
												<div class="col-sm-12 btn-row"><button style="float: left;" class="btn edit-end-btn addMoreLead" type="button">Add</button></div>
										<?php $i++; }									
										}
									} ?>									
								</div>									
							</div>
<hr>							
<div class="bottom-bdr"></div>							
<div class="container">
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Issue Date<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control has-feedback-left datePicker" name="issue_date" id="issue_date" value="<?php if(!empty($register_opportunity) && $register_opportunity->issue_date!=''){ echo $register_opportunity->issue_date; }else {echo date("d-m-Y");}?>" required="required">
					<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
				</div>						
		</div>


		<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Bid Closing Date<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control has-feedback-left datePicker" name="bidclossing_date" id="bidclossing_date" value="<?php if(!empty($register_opportunity) && $register_opportunity->clossing_date!=''){ echo $register_opportunity->clossing_date; }else {echo date("d-m-Y");}?>" required="required">
					<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
				</div>						
		</div>

		<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Bid Id<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control" name="bid_id" id="bid_id" value="<?php if(!empty($register_opportunity) && $register_opportunity->bid_id!=''){ echo $register_opportunity->bid_id; }?>" required="required">
					
				</div>						
		</div>

		<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">EMD Amount<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input id="emd_amount" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->emd_amount; ?>" name="emd_amount" placeholder="" required="required" type="text" > 
					
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
				</div>						
		</div>
         <div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">LPR Rate
            <span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control" name="lpr_rate" id="lpr_rate" value="<?php if(!empty($register_opportunity) && $register_opportunity->lpr_rate!=''){ echo $register_opportunity->lpr_rate; }?>" required="required">
					
				</div>						
		</div>
</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Tender Amount<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input id="emd_amount" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->tender_amount; ?>" name="tender_amount" placeholder="" required="required" type="text" > 
				
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
				</div>						
		</div>
 

 
 <div class="item form-group">
					<label class="col-md-3 col-sm-12 col-xs-12">Tender Status</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
					
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="tender_status" data-id="tender_status" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true">
							<option value="">Select Option</option>
							 <?php
								if(!empty($register_opportunity)){
									$status = getNameById('tender_status',$register_opportunity->tender_status,'id');
									echo '<option value="'.$register_opportunity->tender_status.'" selected>'.$status->name.'</option>';
								}
							?>
						</select>	
					
					
						
					</div>

				</div>
                 <div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12">Location<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control" name="bid_location" id="bid_location" value="<?php if(!empty($register_opportunity) && $register_opportunity->bid_location!=''){ echo $register_opportunity->bid_location; }?>" required="required">
					
				</div>						
		</div>
<div class="item form-group">
								<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Attachments</label>
								<div class="col-md-7 col-sm-9 col-xs-12 ">
									<input type="file" class="form-control col-md-2 col-sm-2 col-xs-12" name="attachment[]"> 
								</div>
								<button class="btn field_buttondd" type="button"><i class="fa fa-plus"></i></button>
								
							</div>
							<div class="item form-group fields_wrapdd" >
								
								</div>
			</div>


							
								<hr>							
<div class="bottom-bdr"></div>	



							
						<div class="item form-group">
						<h3 class="Material-head">Product Details <span class="required">*</span><hr></h3>
						
							<div class="item form-group col-md-6 col-sm-12 col-xs-12 vertical-border" style="margin-bottom: 20px;">
								<label class="col-md-3 col-sm-12 col-xs-12" for="material">Material Type <span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type_id" >
										<option value="">Select Option</option>
										<?php
										if (!empty($register_opportunity)) {
											$material_type_id = getNameById('material_type', $register_opportunity->material_type_id, 'id');
											echo '<option value="' . $register_opportunity->material_type_id . '" selected>' . $material_type_id->name . '</option>';
										}
										?>
									</select>
								</div>
							</div>
							
							<div class="col-md-12 col-sm-12 col-xs-12 form-group input_detail middle-box">
							<div class="col-sm-12  col-md-12 label-box mobile-view2">
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name<span class="required">*</span></label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label></div>
								   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Quantity &nbsp;&nbsp;UOM</label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Price</label></div>				  
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>GST </label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Total</label></div>
				                   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">GST Total</label></div>
				   
			                 </div>
							<?php if(!empty($register_opportunity) && $register_opportunity->product_detail !=''){ 
								$product_info = json_decode($register_opportunity->product_detail);
								
								if(!empty($product_info)){ 
								$i = 1;
								foreach($product_info as $productInfo){ 
								
								$materialName = getNameById('material',$productInfo->material_name_id,'id');
								
								?>		
							
								<div class="well <?php if($i==1){ echo 'edit-row1 scend-tr mobile-view';}else{ echo 'scend-tr mobile-view';}?>" id="chkIndex_<?php echo $i; ?>" style="overflow:auto; ">
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
									  <label>Material Name<span class="required">*</span></label>
										<select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name_id[]"  data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND material_type_id = <?php echo $lead->material_type_id;?> AND status=1" onchange="getTax(event,this)">
											<option value="">Select Option</option>
											<?php echo '<option value="'.$productInfo->material_name_id.'" selected>'.$materialName->material_name.'</option>';?>
										</select>
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
									    <label>Description</label>
										<textarea id="description" name="description[]" rows="1" class="form-control col-md-7 col-xs-12 description"><?php if(!empty($register_opportunity)) echo $productInfo->description; ?></textarea>					
									</div>	
									<div class="col-md-3 col-sm-6 col-xs-12 form-group">
										<label>Quantity &nbsp;&nbsp;UOM</label>
										<input type="text" id="quantity" name="qty[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" value="<?php if(!empty($register_opportunity)) echo $productInfo->qty; ?>" required="required">
										
										<input type="text" id="uom" name="uom_material1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($register_opportunity)) 

												$ww =  getNameById('uom', $productInfo->uom_material,'id');
														$uom = !empty($ww)?$ww->ugc_code:'';

														echo $uom;
									


										?>" readonly>

										<input type="hidden" id="uom1" name="uom_material[]" readonly>
									</div>

									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										<label>Price</label>
										<input type="text" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" value="<?php if(!empty($register_opportunity)) echo $productInfo->price; ?>">
									</div>
									
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									    <label>GST </label>
										<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="<?php if(!empty($register_opportunity) && isset($productInfo->gst)) echo $productInfo->gst; ?>" placeholder="gst" readonly>
									</div>				
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										    <label>Total</label>
											<input type="text" name="totals[]" placeholder="total" class="form-control col-md-7 col-xs-12 total" min="0" readonly value="<?php if(!empty($register_opportunity) && isset($productInfo->total)) echo $productInfo->total; ?>">
									</div>
									<div class="col-md-2 col-sm-6 col-xs-12 form-group">
										    <label >GST Total</label>
											<input style=" border-right: 1px solid #c1c1c1 !important;" type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="<?php if(!empty($register_opportunity) && isset($productInfo->TotalWithGst)) echo $productInfo->TotalWithGst; ?>" readonly>
									</div>		
										
											
								
									<button style="margin-right: 0px;" class="btn  btn-danger delete_btn" type="button"> <i class="fa fa-minus"></i></button>
									</div>
								     <div class="col-sm-12 btn-row"><button style="margin-top: 22px; float:left;" class="btn edit-end-btn addMoreButton " 	type="button" align="right">Add</button></div>
								
							<?php $i++;
										}
									}
								}else{ 
								?>
								
								<div class="well " id="chkIndex_1" style="overflow:auto; ">
								 
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
									
										<select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name_id[]" onchange="getUom(event,this)">
											<option value="">Select Option</option>
										</select>
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
									
										<textarea id="description" name="description[]" rows="1" class="form-control col-md-7 col-xs-12 description"></textarea>					
									</div>	
									<div class="col-md-3 col-sm-6 col-xs-12 form-group">
										
										<input type="text" id="quantity" name="qty[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">

										<input type="text" id="uom" name="uom_material1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12"   readonly>

										<input type="hidden" name="uom_material[]" readonly id="uom1">
									</div>

									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										
										<input type="text" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" value="">
									</div>
									
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									
										<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="<?php if(!empty($lead) && isset($productInfo->gst)) echo $productInfo->gst; ?>" placeholder="gst" readonly>
									</div>				
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										
											<input type="text" name="totals[]" placeholder="total" class="form-control col-md-7 col-xs-12 total" min="0" readonly value="<?php if(!empty($lead) && isset($productInfo->total)) echo $productInfo->total; ?>">
									</div>
									<div class="col-md-2 col-sm-6 col-xs-12 form-group">
										
											<input type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="<?php if(!empty($lead) && isset($productInfo->individualTotalWithGst)) echo $productInfo->TotalWithGst; ?>" readonly>
									</div>		

								</div>		
													
							<div class="col-sm-12 btn-row"><div class="input-group-append"><button style="margin-top: 22px; float:left;" class="btn edit-end-btn addMoreButton " type="button" align="right"><i class="fa fa-plus"></i></button></div></div>
									

							<?php }?>	
						
						</div>	
						</div>
						
				<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
                   

					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
						
					<div class="col-md-12 col-sm-5 col-xs-12 text-right">
						
						
						<div class="col-md-6 col-sm-5 col-xs-6 ">
							<input type="hidden"  name="total" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($register_opportunity)){ echo $register_opportunity->totalwithoutgst ; } ?>"> 
							<strong>Total:</strong>&nbsp;&nbsp;
							</div>
							<div class="col-md-6 text-left"> <span class="fa fa-rupee divSubTotal"><?php if(!empty($register_opportunity)){ echo $register_opportunity->totalwithoutgst ; } else{ echo 0; }?></div>	
							 
						
                         <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 20px;color: #2C3A61; border-top: 1px solid #2C3A61;">
						<div class="col-md-6 col-sm-5 col-xs-6 ">
							<input type="hidden"  name="grandTotal" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($register_opportunity)){ echo $register_opportunity->grand_total ; }?>"> 
							<strong>Grand Total:</strong>
							</div>
							<div class="col-md-6 text-left"><span class="fa fa-rupee divTotal"><?php if(!empty($register_opportunity)){ echo $register_opportunity->grand_total ;} else{ echo 0; }?></span></div>	
							 </div>
						</div>
					</div>
						
					</div>
<?php if(!empty($attachments)){?>
							<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							   <label class="col-md-1 col-sm-12 col-xs-12" for="certificate">Attachments</label>
								<div class="col-md-7 outline">
									<?php foreach($attachments as $attachment){
											$path = $attachment[ 'file_name'];
										$ext = pathinfo($path, PATHINFO_EXTENSION);
									if($ext='xls'||$ext='xlsx'||$ext='doc')
									{
echo '<div class="img-wrap col-md-4"><div class="col-md-12 img-outline"><a href="javascript:void(0)" class="delete_listing close-link cross" style="z-index:111;" data-href="'.base_url(). 'bid_management/deleteAttachment/'.$attachment[ 'id']. '"><i class="fa fa-trash" style="color:#e60a03;"></i></a><a href="'.base_url(). 'assets/modules/bid_management/uploads/'.$attachment[ 'file_name']. '" download><img style="height:30px;" src="'.base_url().'assets/modules/bid_management/uploads/download.png" alt="image" class="img-responsive"/></a></div></div>';									
										
									}else
									{
echo '<div class="img-wrap col-md-4"><div class="col-md-12 img-outline"><a href="javascript:void(0)" class="delete_listing close-link cross" style="z-index:111;" data-href="'.base_url(). 'bid_management/deleteAttachment/'.$attachment[ 'id']. '"><i class="fa fa-trash" style="color:#e60a03;"></i></a><a href="'.base_url(). 'assets/modules/bid_management/uploads/'.$attachment[ 'file_name']. '" download><img style="height:50px;" src="'.base_url(). 'assets/modules/bid_management/uploads/'.$attachment[ 'file_name']. '" alt="image" class="img-responsive"/></a></div></div>';									
									}
									} ?>
								</div>
							</div>
						<?php } ?>					


						
							<!--<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="grandtotal">Grand Total</label>
								<div class="col-md-10 col-sm-10 col-xs-12">
									<input type="text" id="grand_total" name="grand_total" required="required" class="form-control col-md-7 col-xs-12"  value="<?php //if(!empty($lead)) echo $lead->grand_total; ?>"> 
								</div>
							</div>-->
							<div class="ln_solid"></div>
							<div class="form-group">
								<div class="col-md-12">
								<center>
									<button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
									<button type="reset" class="btn btn-default">Reset</button>
									<?php if((!empty($register_opportunity) && $register_opportunity->save_status !=1) || empty($register_opportunity)){
										echo '<input type="submit" class="btn add_users_dataaa draftBtn" value="Save as draft">'; 
									}?> 
									<input type="submit" class="btn edit-end-btn" value="Submit">
									</center>
								</div>
							</div>
						</form>	
							</div>
</div>							
<div class="col-md-12 col-sm-12 col-xs-12 tab-pane active" id="activity">
				<div class="Activities">
					<div class="x_title">
					<h3 class="Material-head">Recent Activities<hr></h3>
						
						<div class="col-md-3 export_div">
											
							<div class="control-group">
								<div class="controls">
									<div class="input-prepend input-group">
										<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text"  name="activityDateRange" id="activityDateRange" class="form-control"/>
										<input type="hidden" name="activityRelId" value="<?php if(!empty($lead)){ echo $lead->id;   }?>">
										<input type="hidden" name="activityRelTable" value="lead_activity">
									</div>
								</div>
							</div>						
						</div>
						<div class="col-md-4 title_right">
						     
								<div class="col-md-12 col-sm-12 col-xs-12 form-group pull-right top_search">
								  <div class="input-group">
									<input type="text" class="form-control" placeholder="Search activities">
									<span class="input-group-btn">
									  <button class="btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i>
</button>
									</span>
								  </div>
								</div>
                              
						</div>
						<div class="clearfix"></div>
					</div>
					<div>
						<ul class=" messages activityMessage col-md-12 col-sm-12 col-xs-12">
							<?php if(!empty($tender_activities)){ 
								foreach($tender_activities as $activity){ 


									?>


								
									<li>
									    <div class="col-md-12 col-xs-12 head">
										<div class="col-md-4 col-xs-12">
										<span><img src="<?php if($activity['activity_type'] == 'New Task'){ echo '/assets/images/task.png';} else if($activity['activity_type'] == 'Call Log'){ echo '/assets/images/call-log.png';} else{ echo '/assets/images/chat-icon.png'; } ?>"></span>
										<div class="message_wrapper">
											<h4 class="heading">  <?php echo $activity['subject']; ?></h4>
										
										</div>
										</div>
										<div class="message_date col-md-4">
										  <?php echo $activity['created_date']; ?>
										</div>
									    </div>
										<div class="col-md-12 col-xs-12 " style="text-align: left;">
										<p class="message">  <?php echo $activity['comment']; ?></p>
										<?php if($activity['activity_type'] == 'New Task'){
											echo 'Due date : '. $activity['due_date'];
												} ?>											
											<?php if($activity['activity_type'] == 'Chatter'){
												$attachments  = getAttachmentsById('attachments',$activity['id'],'lead_activity');
												if(!empty($attachments)){
													echo '<div class="col-md-12">';
														foreach($attachments as $attachment){
															echo '
																	<div class="img-holder col-md-1">
																	<span id="mask" tabindex="1" onclick="myFunction()"></span>
																	<img id="pic" src="'.base_url(). 'assets/modules/bid_management/uploads/'.$attachment[ 'file_name']. '" tabindex="2">
																	</div>
																'; } 
													echo '</div>';
												}
											}
											  ?>
											  <br />
											  </div>
									</li>								 
								<?php }
								}else{
									echo '<div class="oops"><img src="http://busybanda.com/assets/images/no-activityes.jpg"></div>'; 
								} ?>
						</ul>
					</div>
				</div>
			</div>							

					
					<!------end of edit lead form ------------------>
					
	<div class="tab-pane" id="upload" >
	<?php if($register_opportunity->tender_status==5){?>
<form method="post" action="<?php echo base_url();?>bid_management/upload_counter_offer" enctype="multipart/form-data">
         	<input type="hidden" name="id" id="id" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->id; ?>">   
            <span style="float:right">Status:<?php if(!empty($register_opportunity)&& $register_opportunity->offer_is_accept==1){echo 'Accepted';}elseif(!empty($register_opportunity)&& $register_opportunity->offer_is_reject==1){echo 'Rejected';}else{echo '';}?></span>      
					<div class="item form-group">
								<label class="col-md-3 col-sm-2 col-xs-12" for="counter_offer">Counter offer</label>
								<div class="col-md-7 col-sm-9 col-xs-12 ">
								<?php if(!empty($register_opportunity->counter_offer)) {
	echo '<a target="_blank" href="'.base_url().'assets/modules/bid_management/uploads/'.$register_opportunity->counter_offer.'">'.$register_opportunity->counter_offer.'</a>';
					}else{?>
								<input type="file" name="counter_offer" id="counter_offer" />
				
					<?php }?>
						</div>
						</div>
						<?php if($register_opportunity->counter_offer!=''){?>
						<div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Reason</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="reason" rows="6" id="reason" required="required" class="form-control col-md-7 col-xs-12" <?php if($register_opportunity->reject_reason!=''){?>disabled<? }?>>
									<?php if(!empty($register_opportunity)) echo $register_opportunity->reject_reason; ?>
									</textarea>
								</div>
							</div>	
						<?php }?>
						<div class="ln_solid"></div>												
							<div class="form-group">													
								<div class="col-md-12 ">														
					<?php if($register_opportunity->counter_offer!=''){?>
						<?php if($register_opportunity->offer_is_accept==0){?>
				<button type="button" class="btn btn-success" onclick="accept_offer()">Accept</button>
						<?php }
						if(!empty($register_opportunity)&& $register_opportunity->offer_is_reject==0){?>
				<button type="button" class="btn btn-danger"  onclick="reject_offer()">Reject</button>
					<?php }}?>
                        <input type="submit" class="btn edit-end-btn" value="Save">	
                       	</div>												
							</div>	
				</form>
	<?php }?>
	<?php if($register_opportunity->tender_status==6){?>
	<div class="item form-group">
								<label class="col-md-3 col-sm-2 col-xs-12" for="counter_offer">Counter offer</label>
								<div class="col-md-7 col-sm-9 col-xs-12 ">
								<?php if(!empty($register_opportunity->counter_offer)) {
	echo '<a target="_blank" href="'.base_url().'assets/modules/bid_management/uploads/'.$register_opportunity->counter_offer.'">'.$register_opportunity->counter_offer.'</a>';
					}?>
						</div>
						</div>
	<?php } ?>
</div>	
					<div class="tab-pane" id="loa">
	<form method="post" class="form-horizontal form-label-left" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>bid_management/save_loa">
	<input type="hidden" name="id" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->id; ?>">		
		<h3 class="Material-head">LOA Details<hr></h3>
		<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	   <div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="loa">LOA number</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="number" class="form-control " name="loa_code" id="loa_code" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->loa_code; ?>">
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">		
		<label class="col-md-3 col-sm-12 col-xs-12" for="textarea">LOA Date</label>
		<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control has-feedback-left datePicker" name="loa_date" id="loa_date" value="<?php if(!empty($register_opportunity) && $register_opportunity->loa_date!=''){ echo $register_opportunity->loa_date; }else {echo date("d-m-Y");}?>" >
					<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
				</div>										
		</div>					
			<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="contact_person_name">Contact person name</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control" name="contact_person_name" id="contact_person_name" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->contact_person_name; ?>">
			</div>
		</div>	
				<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="email_id">Email ID</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="email" class="form-control " name="email_id" id="email_id" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->email_id; ?>">
			</div>
		</div>	
			<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="contact_number">Contact number</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control" name="contact_number" id="contact_number" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->contact_number; ?>">
			</div>
		</div>
	<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
				<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Consignee name</label>
				<div class="col-md-6 col-sm-12 col-xs-12">
				<?php if(!empty($register_opportunity)&&($register_opportunity->consignee)!='') {
				$val= json_decode($register_opportunity->consignee);
				$i=0;
				for($i=0;$i<count($val);$i++){
				?>
				<input type="text" class="form-control col-md-2 col-sm-2 col-xs-12" name="consignee[]" value="<?php if(!empty($register_opportunity)&&($register_opportunity->consignee)!='') echo $val[$i]; ?>"> 
				<?php } }else{?>
				<input type="text" class="form-control col-md-2 col-sm-2 col-xs-12" name="consignee[]" />
				<?php }?>
				</div>
				<button class="btn field_button_consignee" type="button"><i class="fa fa-plus"></i></button>
				<div class="item form-group fields_wrap_consignee" ></div>
	</div>
			   <div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Company address</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="company_address" rows="6" id="company_address" class="form-control col-md-7 col-xs-12">
                                    <?php if(!empty($register_opportunity)) echo $register_opportunity->company_address; ?>
									</textarea>
								</div>
		</div>				   
		   <div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Inspection agency</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="inspection_agency" rows="6" id="inspection_agency" class="form-control col-md-7 col-xs-12">
                                    <?php if(!empty($register_opportunity)) echo $register_opportunity->inspection_agency; ?>
									</textarea>
								</div>
		</div>
		   <div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Other Terms</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="other_terms" rows="6" id="other_terms" class="form-control col-md-7 col-xs-12">
                                    <?php if(!empty($register_opportunity)) echo $register_opportunity->other_terms; ?>
									</textarea>
								</div>
		</div>
  <div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">SVC Clause</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="svc_clause" rows="6" id="svc_clause" class="form-control col-md-7 col-xs-12">
                                              <?php if(!empty($register_opportunity)) echo $register_opportunity->svc_clause; ?>
									</textarea>
								</div>
		</div>	
	
</div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="freight">Payment Terms</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control" name="payment_terms" id="payment_terms" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->payment_terms; ?>">
			</div>
		</div>				
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="billing_name">Billing name</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control" name="billing_name" id="billing_name" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->billing_name; ?>">
			</div>
		</div>					
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">	
		<label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Delivery schedule</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control has-feedback-left datePicker" name="delivery_schedule" id="delivery_schedule" value="<?php if(!empty($register_opportunity) && $register_opportunity->delivery_schedule!='' && $register_opportunity->delivery_schedule!='0000-00-00 00:00:00'){ echo $register_opportunity->delivery_schedule; }else {echo date("d-m-Y");}?>">
					<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
				</div>								
		</div>   
	
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="freight">Security deposit Name</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control" name="deposit_name" id="deposit_name" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->deposit_name; ?>">
				
			</div>
		</div>		
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
			<label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Security deposit Date</label>
			
			<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control has-feedback-left datePicker" name="deposit_date" id="deposit_date" value="<?php if(!empty($register_opportunity) && $register_opportunity->deposit_date!='' && $register_opportunity->deposit_date!='0000-00-00 00:00:00'){ echo $register_opportunity->deposit_date; }else {echo date("d-m-Y");}?>" required="required">
					<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
				</div>	
												
		</div>		
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="item_rate">Item rate</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control " name="item_rate" id="item_rate" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->item_rate; ?>">
			</div>
		</div>					
		
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="advance_received">GST</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control discount_offered" name="loa_gst" id="loa_gst" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->loa_gst; ?>">
			</div>
		</div>	
			
			   <div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Item Description</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="item_desc" rows="6" id="item_desc" class="form-control col-md-7 col-xs-12">
                                    <?php if(!empty($register_opportunity)) echo $register_opportunity->item_desc; ?>
									</textarea>
								</div>
		</div>	
   <div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Rites Address</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="rites_add" rows="6" id="rites_add" class="form-control col-md-7 col-xs-12">
                                    <?php if(!empty($register_opportunity)) echo $register_opportunity->rites_add; ?>
									</textarea>
								</div>
		</div>	
  <div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Option Clause</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="option_clause" rows="6" id="option_clause" class="form-control col-md-7 col-xs-12">
                                    <?php if(!empty($register_opportunity)) echo $register_opportunity->option_clause; ?>
									</textarea>
								</div>
		</div>
<div class="item form-group">
	<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Attachments</label>
	<div class="col-md-6 col-sm-12 col-xs-12">
    	<?php foreach($attachments1 as $attachment){
												echo '<div class="img-wrap col-md-4"><div class="col-md-12 img-outline"><a href="javascript:void(0)" class="delete_listing close-link cross" style="z-index:111;" data-href="'.base_url(). 'crm/deleteAttachment/'.$attachment[ 'id']. '"><i class="fa fa-trash" style="color:#e60a03;"></i></a><a href="'.base_url(). 'assets/modules/bid_management/uploads/'.$attachment[ 'file_name']. '" download><img style="height:50px;" src="'.base_url(). 'assets/modules/bid_management/uploads/'.$attachment[ 'file_name']. '" alt="'.$attachment[ 'file_name'].'" class="img-responsive"/></a></div></div>';
									} ?>
		<input type="file" class="form-control col-md-2 col-sm-2 col-xs-12" name="attachment1[]"> 
	</div>
	<button class="btn field_button_attach" type="button"><i class="fa fa-plus"></i></button>
	<div class="item form-group fields_wrap_attach" ></div>
</div>	
							
</div>
							<br />
							<div class="ln_solid"></div>												
							<div class="form-group">													
								<div class="col-md-12 ">														
									<button type="reset" class="btn btn-default">Reset</button>														
									<input type="submit" class="btn chatter edit-end-btn" value="Save">													
								</div>												
							</div>			
						</form>
					<!--------------------------end of chatter tab --------------------------------->					</div>			
	<div class="tab-pane" id="po">
		<form method="post" class="form-horizontal form-label-left" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>bid_management/save_po">
							<input type="hidden" name="id" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->id; ?>">		
	   <h3 class="Material-head">PO Details<hr></h3>
	   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	   <div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="loa">PO number</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="number" class="form-control" name="po_code" id="po_code"  value="<?php if(!empty($register_opportunity)) echo $register_opportunity->po_code; ?>">
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">		
		<label class="col-md-3 col-sm-12 col-xs-12" for="textarea">PO Date</label>
		<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control has-feedback-left datePicker" name="po_date" id="po_date" value="<?php if(!empty($register_opportunity) && $register_opportunity->po_date!=''){ echo $register_opportunity->po_date; }else {echo date("d-m-Y");}?>">
					<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
				</div>										
		</div>					

			<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="contact_person_name">Contact person name</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control" name="po_contact_person_name" id="po_contact_person_name" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->po_contact_person_name; ?>">
			</div>
		</div>	
        	<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="po_contact_number">Contact number</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control" name="po_contact_number" id="po_contact_number" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->po_contact_number; ?>">
			</div>
		</div>
			    <div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="email_id">Email ID</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="email" class="form-control " name="po_email_id" id="po_email_id" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->po_email_id; ?>">
			</div>
		</div>  
		       		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="rites_case_number">Rites Case Number</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control" name="rites_case_number" id="rites_case_number" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->rites_case_number; ?>">
			</div>
		</div>	
	<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="po_contact_number">Bank details</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control" name="po_bank_details" id="po_bank_details" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->po_bank_details; ?>">
			</div>
		</div>
			   <div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Company address</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="po_company_address" rows="6" id="po_company_address" class="form-control col-md-7 col-xs-12">
                <?php if(!empty($register_opportunity)) echo $register_opportunity->po_company_address; ?>
									</textarea>
								</div>
		</div>				   
		   <div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Inspection agency</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="po_inspection_agency" rows="6" id="po_inspection_agency" class="form-control col-md-7 col-xs-12">
                <?php if(!empty($register_opportunity)) echo $register_opportunity->po_inspection_agency; ?>
									</textarea>
								</div>
		</div>
		   <div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Other Terms</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="po_other_terms" rows="6" id="po_other_terms" class="form-control col-md-7 col-xs-12">
                <?php if(!empty($register_opportunity)) echo $register_opportunity->po_other_terms; ?>
									</textarea>
								</div>
		</div>
  <div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">SVC Clause</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="po_svc_clause" rows="6" id="po_svc_clause"  class="form-control col-md-7 col-xs-12">
              <?php if(!empty($register_opportunity)) echo $register_opportunity->po_svc_clause; ?>
									</textarea>
								</div>
		</div>	
	
</div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">	

		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="freight">Payment Terms</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control" name="po_payment_terms" id="po_payment_terms" value="<?php if(!empty($register_opportunity)){ echo $register_opportunity->po_payment_terms;} ?>">
			</div>
		</div>				
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="billing_name">Billing name</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control" name="po_billing_name" id="po_billing_name" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->po_billing_name; ?>">
			</div>
		</div>					
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">	
		<label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Delivery schedule</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control has-feedback-left datePicker" name="po_delivery_schedule" id="po_delivery_schedule" value="<?php if(!empty($register_opportunity) && $register_opportunity->po_delivery_schedule!=''){ echo $register_opportunity->po_delivery_schedule; }else {echo date("d-m-Y");}?>" >
					<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
				</div>									
		</div>
				<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="contact_number">Amendments</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control" name="amendments" id="amendments" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->amendments; ?>" required> 
			</div>
		</div>		
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="freight">Item type</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control" name="po_item_type" id="po_item_type" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->po_item_type; ?>">
				
			</div>
		</div>			
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="item_rate">Item rate</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control" name="po_item_rate" id="po_item_rate" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->po_item_rate; ?>">
			</div>
		</div>					
		
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="advance_received">GST</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input type="text" class="form-control discount_offered" name="po_gst" id="po_gst" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->po_gst; ?>">
			</div>
		</div>	
 
			   <div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Item Description</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="po_item_desc" rows="6" id="po_item_desc" class="form-control col-md-7 col-xs-12">
                 <?php if(!empty($register_opportunity)) echo $register_opportunity->po_item_desc; ?>
									</textarea>
								</div>
		</div>	
   <div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Rites Address</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="po_rites_add" rows="6" id="po_rites_add" class="form-control col-md-7 col-xs-12">
                <?php if(!empty($register_opportunity)) echo $register_opportunity->po_rites_add; ?>
									</textarea>
								</div>
		</div>	
  <div class="col-md-12 col-sm-12 col-xs-12 item form-group"  >		
						<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Option Clause</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="po_option_clause" rows="6" id="po_option_clause" class="form-control col-md-7 col-xs-12">
         <?php if(!empty($register_opportunity)) echo $register_opportunity->po_option_clause; ?>
									</textarea>
								</div>
		</div>
<div class="item form-group">
	<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Attachments</label>
	<div class="col-md-6 col-sm-12 col-xs-12">
	<?php foreach($attachments2 as $attachment){
												echo '<div class="img-wrap col-md-4"><div class="col-md-12 img-outline"><a href="javascript:void(0)" class="delete_listing close-link cross" style="z-index:111;" data-href="'.base_url(). 'crm/deleteAttachment/'.$attachment[ 'id']. '"><i class="fa fa-trash" style="color:#e60a03;"></i></a><a href="'.base_url(). 'assets/modules/bid_management/uploads/'.$attachment[ 'file_name']. '" download><img style="height:50px;" src="'.base_url(). 'assets/modules/bid_management/uploads/'.$attachment[ 'file_name']. '" alt="'.$attachment[ 'file_name'].'" class="img-responsive"/></a></div></div>';
									} ?>
		<input type="file" class="form-control col-md-2 col-sm-2 col-xs-12" name="po_attachment[]"> 
	</div>
	<button class="btn field_button_po_attach" type="button"><i class="fa fa-plus"></i></button>
	<div class="item form-group fields_wrap_po_attach" ></div>
</div>	
<div class="item form-group">
	<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Consignee name</label>
	<div class="col-md-6 col-sm-12 col-xs-12">
      <?php if(!empty($register_opportunity)&&($register_opportunity->po_consignee)!=''){
	  $val= json_decode($register_opportunity->po_consignee);
	  $i=0;
	 for($i=0;$i<count($val);$i++){
	 ?>
		<input type="text" class="form-control col-md-2 col-sm-2 col-xs-12" name="po_consignee[]" value="<?php echo $val[$i];?>"> 
<?php }}else{?>
        <input type="text" class="form-control col-md-2 col-sm-2 col-xs-12" name="po_consignee[]" />
        <?php }?>
	</div>
	<button class="btn field_button_po_consignee" type="button"><i class="fa fa-plus"></i></button>
	<div class="item form-group fields_wrap_po_consignee" ></div>
	</div>							
</div>
							<br />
							<div class="ln_solid"></div>												
							<div class="form-group">													
								<div class="col-md-12 ">														
									<button type="reset" class="btn btn-default">Reset</button>														
									<input type="submit" class="btn chatter edit-end-btn" value="Save">													
								</div>												
							</div>			
						</form>
	<!--------------------------end of po tab --------------------------------->			
</div>				
			</div>
		

		</div>
			</div>
			
		</div>
	</div>
 <?php }else { ?>
 
 <!--<img src="http://busybanda.com/assets/images/no-activityes.jpg">-->

	<!-------------------------------------------add modal for leads--------------------------------------->
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>bid_management/save_register_opportunity" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
		<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
		<input type="hidden" name="id" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->id; ?>">		
		<input type="hidden" name="save_status" value="1" class="save_status">				
		<div class="item form-group">
			<h3 class="Material-head">Tender Details<hr></h3>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group input_holder middle-box">
					<?php if(empty($register_opportunity)){ ?>
					  <div class="col-sm-12  col-md-12 label-box mobile-view2">
											   <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Tender Number<span class="required">*</span></label></div>
											   <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Department Name</label></div>
											   <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Tender Type</label></div>
											  			  
								           </div>
										   
						<div class="well scend-tr mobile-view" id="chkIndex_1" >
							<div class="item form-group col-md-4 col-xs-12">
								<label class="col-md-12 col-sm-12 col-xs-12" for="name">Tender Number<span class="required">*</span></label>
									<div class="col-md-12 col-sm-12 col-xs-12 form-group">
										<input id="name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->tender_name; ?>" name="tender_name[]" placeholder="Tender Name" required="required" type="text" > 
									</div>
							</div>
							<div class="item form-group col-md-4 col-xs-12">
								<label class="col-md-12 col-sm-12 col-xs-12" for="name">Department Name</label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<input id="last_name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->department_name; ?>" name="department_name[]" placeholder="Department Name" type="text">
								</div>
							</div>
							<div class="item form-group col-md-4 col-xs-12">
								<label class="col-md-12 col-sm-12 col-xs-12" for="email">Tender Type</label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<input type="email" id="email" name="tender_link[]"   class="form-control col-md-7 col-xs-12" placeholder="Tender Link" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->tender_link; ?>" > 
								</div>
							</div>   
							
							<button class="btn btn-danger del_field" type="button"> <i class="fa fa-minus"></i></button>
						</div>	
						<div class="col-sm-12 btn-row"><div class="input-group-append">
								<button class="btn edit-end-btn addMoreLead" type="button">Add</button>
							</div></div>
					<?php }
					if(!empty($register_opportunity)){ 
						$tender_detail = json_decode($register_opportunity->tender_detail);
						if(!empty($tender_detail)){ 
						$i =1;
						?>
						<div class="col-sm-12  col-md-12 label-box mobile-view2">
											  <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Tender Number<span class="required">*</span></label></div>
											   <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Department Name</label></div>
											   <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Tender Type</label></div>			  
								           </div>
						<?php
						foreach($tender_detail as $tender_d_detail){	?>
							<div class="well scend-tr mobile-view" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">
								<div class="item form-group col-md-4 col-xs-12">
									<label class="col-md-12 col-sm-12 col-xs-12" for="name">Tender Number<span class="required">*</span></label>
									<div class="col-md-12 col-sm-12 col-xs-12 form-group">
										<input id="name" class="form-control col-md-7 col-xs-12" value="<?php  echo $tender_d_detail->tender_name; ?>" name="tender_name[]" placeholder="Tender Number" required="required" type="text" > 
									</div>
								</div>
								<div class="item form-group col-md-4 col-xs-12">
									<label class="col-md-12 col-sm-12 col-xs-12" for="name">Department Name</label>
									<div class="col-md-122 col-sm-12 col-xs-12 form-group">
										<input id="last_name" class="form-control col-md-7 col-xs-12" value="<?php echo $tender_d_detail->department_name; ?>" name="department_name[]" placeholder="Department Name" type="text">
									</div>
								</div>
								<div class="item form-group col-md-4 col-xs-12">
									<label class="col-md-12 col-sm-12 col-xs-12" for="email">Tender Type</label>
									<div class="col-md-12 col-sm-12 col-xs-12 form-group">
										<input type="email" id="email" name="tender_link[]"  class="form-control col-md-7 col-xs-12" placeholder="Tender Link" value="<?php echo $tender_d_detail->tender_link; ?>"> 
									</div>
								</div>   
								

								<button class="btn btn-danger del_field" type="button"> <i class="fa fa-minus"></i></button>
								
							</div>
							<div class="col-sm-12 btn-row">
							            <div class="input-group-append">
									<button class="btn edit-end-btn addMoreLead" type="button">Add</button>
															
								</div>
								</div>
						<?php $i++; }									
						}
					} ?>									
				</div>									
		</div>
		<hr>
		<div class="bottom-bdr"></div>
<div class="container">
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Issue Date<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control has-feedback-left datePicker" name="issue_date" id="issue_date" value="<?php if(!empty($register_opportunity) && $register_opportunity->issue_date!=''){ echo $register_opportunity->issue_date; }else {echo date("d-m-Y");}?>" required="required">
					<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
				</div>						
		</div>


		<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Bid Clossing Date<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control has-feedback-left datePicker" name="bidclossing_date" id="bidclossing_date" value="<?php if(!empty($register_opportunity) && $register_opportunity->clossing_date!=''){ echo $register_opportunity->clossing_date; }else {echo date("d-m-Y");}?>" required="required">
					<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
				</div>						
		</div>

<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Bid Id<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control" name="bid_id" id="bid_id" value="<?php if(!empty($register_opportunity) && $register_opportunity->bid_id!=''){ echo $register_opportunity->bid_id; }?>" required="required">
					
				</div>						
		</div>

		<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">EMD Amount<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input id="emd_amount" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->emd_amount; ?>" name="emd_amount" placeholder="" required="required" type="text" > 
					
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
				</div>						
		</div>
            <div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">LPR Rate
            <span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control" name="lpr_rate" id="lpr_rate" value="<?php if(!empty($register_opportunity) && $register_opportunity->lpr_rate!=''){ echo $register_opportunity->lpr_rate; }?>" required="required">
					
				</div>						
		</div>
</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Tender Amount<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input id="emd_amount" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->tender_amount; ?>" name="tender_amount" placeholder="" required="required" type="text" > 
				
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
				</div>						
		</div>
 <div class="item form-group">
					<label class="col-md-3 col-sm-12 col-xs-12">Tender Status</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
					
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="tender_status" data-id="tender_status" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true">
							<option value="">Select Option</option>
							 <?php
								if(!empty($register_opportunity)){
									$status = getNameById('tender_status',$register_opportunity->tender_status,'id');
									echo '<option value="'.$register_opportunity->tender_status.'" selected>'.$status->name.'</option>';
								}
							?>
						</select>		
					</div>					
				</div>
                <div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Bid Location<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control" name="bid_location" id="bid_location" value="<?php if(!empty($register_opportunity) && $register_opportunity->bid_location!=''){ echo $register_opportunity->bid_location; }?>" required="required">
					
				</div>						
		</div>
				<div class="item form-group">
								<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Attachments</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="file" class="form-control col-md-2 col-sm-2 col-xs-12" name="attachment[]"> 
								</div>
								<button class="btn field_buttondd" type="button"><i class="fa fa-plus"></i></button>
								
				</div>
							<div class="item form-group fields_wrapdd" >
								
								</div>
							</div>
			</div>


				
					<?php if(!empty($attachments)){?>
						<!--	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							   <label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label>
								<div class="col-md-7 outline">
									<?php foreach($attachments as $attachment){
												echo '<div class="img-wrap col-md-4"><div class="col-md-12 img-outline"><a href="javascript:void(0)" class="delete_listing close-link cross" style="z-index:111;" data-href="'.base_url(). 'bid_management/deleteAttachment/'.$attachment[ 'id']. '"><i class="fa fa-trash" style="color:#e60a03;"></i></a><a href="'.base_url(). 'assets/modules/bid_management/uploads/'.$attachment[ 'file_name']. '" download><img style="height:50px;" src="'.base_url(). 'assets/modules/bid_management/uploads/'.$attachment[ 'file_name']. '" alt="image" class="img-responsive"/></a></div></div>';
									} ?>
								</div>
							</div>-->
						<?php } ?>

	<div class="item form-group">
				<label class="" for="city">Is NPDM</label>
				<input type="checkbox" name="is_npdm" id="ert" value="">
			</div>

			<!--NPDM Start-->
			    <div class="box1" style="display:none;">
						<div class="box-inner" >
                        <!--h2 class="StepTitle">Step 3 Content</h2-->
                      <?php 
					  $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
					  ?>
						
						<h3 class="Material-head">NPDM Details<hr></h3>
							
							<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
		<input type="hidden" name="id" value="<?php if(!empty($npdm)) echo $npdm->id; ?>">		
		<input type="hidden" name="save_status" value="1" class="save_status">				
		<hr>
		<div class="bottom-bdr"></div>
		<div class="container">
         <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
			<div class=" item form-group">
				<label class="col-md-3 col-sm-3 col-xs-12" for="img">Product Name</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					
					<input id="product_name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($npdm)) echo $npdm->product_name; ?>" name="product_name" placeholder="" required="required" type="text"> 

				</div>
			</div>





		<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Product Requirement<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					
					<textarea id="product_require" rows="6" name="product_require" class="form-control col-md-7 col-xs-12" placeholder=""><?php if(!empty($npdm)) echo $npdm->product_require; ?></textarea>

				</div>						
		</div>



		<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Budget Assigned<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">					
					<input id="budget_assigned" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($npdm)) echo $npdm->budget_assigned; ?>" name="budget_assigned" placeholder="" required="required" type="text">
				</div>						
		</div>

</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
			<div class=" item form-group">
			         <label class="col-md-3 col-sm-2 col-xs-12" for="textarea">End Date<span class="required">*</span></label>			
						
						<div class="col-md-6 col-sm-12 col-xs-12">	
							<div class=" xdisplay_inputx form-group has-feedback">

							<input type="date" class="form-control has-feedback-left" name="end_date" id="end_date" aria-describedby="inputSuccess2Status3" value="<?php if(!empty($npdm)) echo $npdm->end_date ;?>">

							<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
							<span id="inputSuccess2Status3" class="sr-only">(success)</span>
						</div>
					</div>
					</div>
				<div class=" item form-group">
					<label class="col-md-3 col-sm-12 col-xs-12">NPDM Status</label>
					

					<div class="col-md-6 col-sm-12 col-xs-12">
					
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="npdm_status" data-id="npdm_status" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true">
							<option value="">Select Option</option>
							 <?php
								if(!empty($npdm)){
									$status = getNameById('npdm_status',$npdm->npdm_status,'id');
									echo '<option value="'.$npdm->npdm_status.'" selected>'.$status->name.'</option>';
								}
							?>
						</select>	
					
					</div>					
</div>

<div class=" item form-group">
								<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Attachments</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="file" class="form-control col-md-2 col-sm-2 col-xs-12" name="attachment[]"> 
								</div>
								<button class="btn field_button" type="button"><i class="fa fa-plus"></i></button>
								
								</div>
								<div class="item form-group fields_wrap" >
								
								</div>
						
		</div>
</div>
<div class="item form-group col-md-12 col-sm-12 col-xs-12"></div>		
				
					<?php if(!empty($attachments)){?>
							<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							   <label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label>
								<div class="col-md-7 outline">
									<?php foreach($attachments as $attachment){
												echo '<div class="img-wrap col-md-4"><div class="col-md-12 img-outline"><a href="javascript:void(0)" class="delete_listing close-link cross" style="z-index:111;" data-href="'.base_url(). 'crm/deleteAttachment/'.$attachment[ 'id']. '"><i class="fa fa-trash" style="color:#e60a03;"></i></a><a href="'.base_url(). 'assets/modules/crm/uploads/'.$attachment[ 'file_name']. '" download><img style="height:50px;" src="'.base_url(). 'assets/modules/crm/uploads/'.$attachment[ 'file_name']. '" alt="image" class="img-responsive"/></a></div></div>';
									} ?>
								</div>
							</div>
						<?php } ?>
						
					<div class="ln_solid"></div>


<!-- /page content -->
                   
          
                    </div>
	
</div>				
<hr>
<div class="bottom-bdr"></div>				
			<div class="item form-group">
				
				<h3 class="Material-head">Product Details<span class="required">*</span><hr></h3>

					<div class="item form-group col-md-6 col-sm-12 col-xs-12 vertical-border">
						<label class="col-md-3 col-sm-3 col-xs-12" >Liasoning Agent</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<select class="form-control selectAjaxOption select2 select2-hidden-accessible agent_id select2" name="agent_id" data-id="liasoning_agent" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" id="agent_id">
								<option value="">Select Option</option>
							<?php


								if (!empty($register_opportunity)) {
									$agent_id = get_data('liasoning_agent');
									echo '<option value="' . $agent_id['agent_id'] . '" selected>' . $agent_id['name'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
                    <div class="item form-group col-md-6 col-sm-12 col-xs-12 vertical-border">
						<label class="col-md-3 col-sm-3 col-xs-12" for="material">Material Type <span class="required">*</span></label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type_id">
								<option value="">Select Option</option>
								<?php


								if (!empty($register_opportunity)) {
									$material_type_id = getNameById('material_type', $register_opportunity->material_type_id, 'id');
									echo '<option value="' . $register_opportunity->material_type_id . '" selected>' . $material_type_id->name . '</option>';
								}
								?>
							</select>
						</div>
					</div>
			</div>

				
					<div class="col-md-12 col-sm-12 col-xs-12 form-group input_detail middle-box">
					<?php if(empty($register_opportunity)){ ?>
					   <div class="col-sm-12  col-md-12 label-box mobile-view2">
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name<span class="required">*</span></label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label></div>
								   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Quantity &nbsp;&nbsp;UOM</label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Price</label></div>				  
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>GST </label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Total</label></div>
				                   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">GST Total</label></div>
				   
			                 </div>
						
							<div class="well scend-tr mobile-view" id="chkIndex_1" style="overflow:auto; ">
								<div class="col-md-2 col-sm-12 col-xs-12 form-group">
								<label class="col-md-12 col-xs-12">Material Name <span class="required">*</span></label>
									<select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name_id[]" onchange="getUom(event,this)">
										<option value="">Select Option</option>
									</select>
								</div>
								<div class="col-md-2 col-sm-12 col-xs-12 form-group">
								<label class="col-md-12 col-xs-12">Description</label>
									<textarea id="description" name="description[]" rows="1" class="form-control col-md-7 col-xs-12 description"></textarea>					
								</div>	
								<div class="col-md-3 col-sm-6 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12" style="float: left;width: 100%;">Quantity &nbsp;&nbsp;UOM</label>
									<input type="text" id="quantity" name="qty[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
									<input type="text" id="uom" name="uom_material1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12 uom_material"   readonly>

									<input type="hidden" name="uom_material[]" readonly id="uom1">
								</div>

								<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12">Price</label>
									<input type="text" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" value="">
								</div>
								
								
								<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12">GST </label>
										<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="" placeholder="gst" readonly>
								</div>				
								<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12">Total</label>
										<input type="text" name="totals[]" placeholder="total" class="form-control col-md-7 col-xs-12 total" min="0" readonly value="">
								</div>
								<div class="col-md-2 col-sm-6 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12" style=" border-right: 1px solid #c1c1c1 !important;">GST Total </label>
										<input style=" border-right: 1px solid #c1c1c1 !important;" type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="" readonly>
								</div>	
                               <button  class="btn  btn-danger delete_btn" type="button"> <i class="fa fa-minus"></i></button>
					       
                               </div>
								<div class="col-sm-12 btn-row"><button style="margin-top: 22px;" class="btn edit-end-btn addMoreButton " type="button" align="right">Add</button></div>
								
						<?php } 
								if(!empty($register_opportunity) && $register_opportunity->product_detail !=''){ 
								$product_info = json_decode($register_opportunity->product_detail);
								
								if(!empty($product_info)){ 
								$i =1;
								?>
								 <div class="col-sm-12  col-md-12 label-box mobile-view2">
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name<span class="required">*</span></label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label></div>
								   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Quantity &nbsp;&nbsp;UOM</label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Price</label></div>				  
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>GST </label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Total</label></div>
				                   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">GST Total</label></div>
				   
			                 </div>
								<?php
								foreach($product_info as $productInfo){ 
								
								$materialName = getNameById('material',$productInfo->material_name_id,'id');
								
								?>		
							
								<div class="well scend-tr mobile-view" id="chkIndex_<?php echo $i; ?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12">Material Name <span class="required">*</span></label>
										<select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name_id[]"  data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND material_type_id = <?php echo $lead->material_type_id;?> AND status=1" onchange="getTax(event,this)">
											<option value="">Select Option</option>
											<?php echo '<option value="'.$productInfo->material_name_id.'" selected>'.$materialName->material_name.'</option>';?>
										</select>
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12">Description</label>
										<textarea id="description" name="description[]" rows="1" class="form-control col-md-7 col-xs-12 description"><?php if(!empty($lead)) echo $productInfo->description; ?></textarea>					
									</div>	
									<div class="col-md-3 col-sm-6 col-xs-12 form-group">
										<label class="col-md-12 col-xs-12" style="float: left;width: 100%;">Quantity &nbsp;&nbsp;UOM</label>
										<input type="text" id="quantity" name="qty[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" value="<?php if(!empty($lead)) echo $productInfo->qty; ?>">
										<input type="text" id="uom" name="uom_material1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($lead)) 


											$ww =  getNameById('uom',  $productInfo->uom_material,'id');
														$uom = !empty($ww)?$ww->ugc_code:'';
														echo $uom;
										?>" readonly>
										
										<input type="hidden" name="uom_material[]" readonly id="uom1">
									</div>

									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										<label class="col-md-12 col-xs-12">Price</label>
										<input type="text" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" value="<?php if(!empty($lead)) echo $productInfo->price; ?>">
									</div>
									
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12">GST </label>
										<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="<?php if(!empty($lead) && isset($productInfo->gst)) echo $productInfo->gst; ?>" placeholder="gst" readonly>
									</div>				
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										<label class="col-md-12 col-xs-12">Total</label>
											<input type="text" name="totals[]" placeholder="total" class="form-control col-md-7 col-xs-12 total" min="0" readonly value="<?php if(!empty($lead) && isset($productInfo->total)) echo $productInfo->total; ?>">
									</div>
									<div class="col-md-2 col-sm-6 col-xs-12 form-group">
										<label style="border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-xs-12">GST Total </label>
											<input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="<?php if(!empty($lead) && isset($productInfo->TotalWithGst)) echo $productInfo->TotalWithGst; ?>" readonly>
									</div>		
									
									
									
									
								
                              
									  <button style="margin-right: 0px;" class="btn  btn-danger delete_btn" type="button"> <i class="fa fa-minus"></i></button>
							  
							  </div>
								<div class="col-sm-12 btn-row">
							          <button style="margin-top: 22px;" class="btn edit-end-btn addMoreButton " 	type="button" align="right">Add</button></div>
							<?php $i++;
										}
									}
								}
								?>
									
					</div>									
				</div>
				
				<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
                   

					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
						
					<div class="col-md-12 col-sm-5 col-xs-12 text-right">
						
						
						<div class="col-md-6 col-sm-5 col-xs-6 ">
							<input type="hidden"  name="total" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($register_opportunity)){ echo $register_opportunity->totalwithoutgst ; } ?>"> 
							<strong>Total:</strong>&nbsp;&nbsp;
							</div>
							<div class="col-md-6 text-left"> <span class="fa fa-rupee divSubTotal"><?php if(!empty($register_opportunity)){ echo $register_opportunity->totalwithoutgst ; } else{ echo 0; }?></div>	
							 
						
                         <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 20px;color: #2C3A61; border-top: 1px solid #2C3A61;">
						<div class="col-md-6 col-sm-5 col-xs-6 ">
							<input type="hidden"  name="grandTotal" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($register_opportunity)){ echo $register_opportunity->grand_total ; }?>"> 
							<strong>Grand Total:</strong>
							</div>
							<div class="col-md-6 text-left"><span class="fa fa-rupee divTotal"><?php if(!empty($register_opportunity)){ echo $register_opportunity->grand_total ;} else{ echo 0; }?></span></div>	
							 </div>
						</div>
					</div>
						
					</div>
				
				
					<div class="ln_solid"></div>
					<div class="form-group">
					   <center>
						<div class="col-md-12 col-xs-12">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="reset" class="btn btn-default">Reset</button>
							<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">
							<input type="submit" class="btn edit-end-btn" value="Submit">
						</div>
						</center>
					</div>
	</form>	
<?php } ?>

<!------------------END Add / Edit lead form modal end-------------------->
<!----------------Change lead status modal start------------------>
<div class="modal fade leadStatusCommentModal" tabindex="-1" role="dialog" aria-hidden="true" style="position:absolute;">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel2">Status Comments</h4>
			</div>
			<div class="modal-body">
				<div class="item form-group">													
					<label class="control-label col-md-12 col-sm-12 col-xs-12" for="status_comment">Comments<span class="required">*</span></label>
					<div class="col-md-12 col-sm-12 col-xs-12">														
						<textarea id="status_comment" required="required" rows="6" name="status_comment" class="form-control col-md-7 col-xs-12" placeholder=""></textarea>
					</div>												
				</div>	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default close_unqstatus_model">Close</button>
				<button type="button" class="btn edit-end-btn" id="status_comment_btn">Save changes</button>
			</div>
		</div>
	</div>
</div>
<!----------------Change lead status modal end------------------>
<!--------------Quick add material code original----------------------->
	<div class="modal left fade lead_modal" id="myModal_Add_matrial_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Add Material Details</h4>
					<span id="mssg34"></span>
				</div>
				<form name="insert_party_data" name="ins"  id="insert_Matrial_data_id">
					<div class="modal-body">
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="name">Material Name <span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="material_name" name="material_name" required="required" class="form-control col-md-7 col-xs-12" value="">
								<span class="spanLeft control-label"></span>
							</div>
						</div> 
							<input type="hidden" name="material_type_id" id="materialtypeid"  class="form-control" value="">
						
						<!--<input type="hidden" name="material_type_id" id="material_type_id"  class="form-control" value="">-->
						<input type="hidden" name="prefix"  id="prefix">
						<span class="spanLeft control-label"></span>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">HSN Code </label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="hsn_code" name="hsn_code" class="form-control col-md-7 col-xs-12" value="" >
								<span class="spanLeft control-label"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="gst">GST</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="gst_tax" name="gst_tax" class="form-control col-md-7 col-xs-12" value="" onkeypress="return float_validation(event, this.value)">
								<span class="spanLeft control-label"></span>
							</div>
						</div>	
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">UOM</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<select class="uom selectAjaxOption select2 form-control" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php 	echo $this->companyGroupId; ?> OR created_by_cid = 0 AND active_inactive = 1">
							<option value="">Select Option</option>
								<?php 
			if(!empty($materials)){
			$materials = getNameById('uom',$materials->uom,'uom_quantity');
			echo '<option value="'.$material->id.'" selected>'.$material->uom_quantity.'</option>';
							 }
								?>
									</select>
								<span class="spanLeft control-label"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">Opening Balance</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="opening_balance_Sec" name="opening_balance" class="form-control col-md-7 col-xs-12" value="">
							<span class="spanLeft control-label"></span>
						</div>
					</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="gstin">Specification</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification"></textarea>
								<span class="spanLeft control-label"></span>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" id="add_matrial_Data_onthe_spot">
						<button type="button" class="btn btn-default close_sec_model" >Close</button>
						<button id="Add_matrial_details_on_button_click" type="button" class="btn edit-end-btn ">Submit</button>
					</div>
				</form>
			</div>
        </div>
    </div>
