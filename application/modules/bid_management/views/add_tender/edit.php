					<div class="tab-pane" id="detail" >
						<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>bid_management/save_register_opportunity" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
							<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
							<input type="hidden" name="id" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->id; ?>">
                        <input type="hidden" name="comp_status" value="1" >	
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
										<div class="item form-group col-md-4 col-xs-12">
											<label class="col-md-12 col-sm-12 col-xs-12" for="name">Tender Number<span class="required">*</span></label>
											
												<input id="name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($register_opportunity)) echo $lead->tender_name; ?>" name="tender_name[]" placeholder="ex. John f. Kennedy" required="required" type="text" > 
											
										</div>
										<div class="item form-group col-md-4 col-xs-12">
											<label class="col-md-12 col-sm-12 col-xs-12" for="name">Department Name</label>
											
												<input id="last_name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->department_name; ?>" name="department_name[]" placeholder="ex. John f. Kennedy" type="text">
											
										</div>
										<div class="item form-group col-md-4 col-xs-12">
											<label class="col-md-12 col-sm-12 col-xs-12" for="email">Tender Type</label>
											
												<input style="border-right: 1px solid #c1c1c1 !important;" type="email" id="email" name="tender_link[]"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->tender_link; ?>"> 
											
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
															<input id="name" class="form-control col-md-7 col-xs-12" value="<?php  echo $td->tender_name; ?>" name="tender_name[]" placeholder="ex. John f. Kennedy" required="required" type="text" > 
														</div>
													</div>
													<div class="item form-group col-md-4 col-xs-12">
														<label>Department Name</label>
														<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
															<input id="last_name" class="form-control col-md-7 col-xs-12" value="<?php echo $td->department_name; ?>" name="department_name[]" placeholder="ex. John f. Kennedy" type="text">
														</div>
													</div>
													<div class="item form-group col-md-4 col-xs-12">
														<label>Tender Type</label>
														<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
															<input type="email" id="email" name="tender_link[]" class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php echo $td->tender_link; ?>"> 
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
						<div class="item form-group col-md-6 col-sm-12 col-xs-12 vertical-border">
						<label class="col-md-3 col-sm-3 col-xs-12" >Liasoning Agent<span class="required">*</span></label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<select class="form-control selectAjaxOption select2 select2-hidden-accessible agent_id select2" required="required" name="agent_id" data-id="liasoning_agent" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" id="agent_id">
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
												echo '<div class="img-wrap col-md-4"><div class="col-md-12 img-outline"><a href="javascript:void(0)" class="delete_listing close-link cross" style="z-index:111;" data-href="'.base_url(). 'bid_management/deleteAttachment/'.$attachment[ 'id']. '"><i class="fa fa-trash" style="color:#e60a03;"></i></a><a href="'.base_url(). 'assets/modules/bid_management/uploads/'.$attachment[ 'file_name']. '" download><img style="height:50px;" src="'.base_url(). 'assets/modules/bid_management/uploads/'.$attachment[ 'file_name']. '" alt="image" class="img-responsive"/></a></div></div>';
									} ?>
								</div>
							</div>
						<?php } ?>					
	 <div class="add_competitor input_holder1 ">
     <div class="main_div">
	  <div class="col-sm-12"><button class="btn edit-end-btn  addcomp" type="button" style="float:right">Add</button></div>
	  <h3 class="Material-head" style="margin-bottom: 30px;">
      Competitor Price Information
      <hr>
   </h3>
   <div class="required item form-group col-md-12 col-sm-12 col-xs-12">
         <label class="required col-md-3 col-sm-12 col-xs-12" for="account_id">Competitor Name </label>
         <div class="required col-md-6 col-sm-12 col-xs-12">
            <select class="itemName form-control selectAjaxOption select2" id="account_id" name="account_id[]" data-id="bid_competitor_details" data-key="id" data-fieldname="name" onchange="getProductDetails(this.value)"  data-where="account_owner = <?php echo $this->companyGroupId ; ?> AND save_status = 1" width="100%">
               
        
            </select>
         </div>
      </div>

   <!-- <div class="ln_solid"></div> -->
   <h3 class="Material-head">
      Product Details
      <hr>
   </h3>
   <div class="item form-group ">
      <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
         <div class="item form-group">
            <div class="col-md-12  input_holder2 middle-box">
              <div class="well1 welldata" id="chkIndex_1" style="overflow:auto; ">
              
         </div>
      </div>
   </div> 
   </div>
   </div>
	
</div>
		</div>				
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