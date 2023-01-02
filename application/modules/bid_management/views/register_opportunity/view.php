<div id="print_divv" class="col-md-12 col-sm-12 col-xs-12"  style="padding:0px;"> 
		<div class="table-responsive">
		           
					</div>
                    					
			  
			  </div>
			  
			  <div class="col-md-6 col-xs-12 col-sm-6 label-left">
			   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Issue Date :</label>
									<div class="col-md-7 col-sm-12 col-xs-6 form-group">
										
										<div><?php if(!empty($register_opportunity)) { 										
																echo $register_opportunity->issue_date; 
																}
															?></div>

										</div>
									</div>
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Bid Clossing Date :</label>
									<div class="col-md-7 col-sm-12 col-xs-6 form-group">
										<div><?php if(!empty($register_opportunity)) { 										
																echo $register_opportunity->clossing_date; 
																}
															?></div>

									</div>
					</div>
			        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">EMD Amount :</label>
									<div class="col-md-7 col-sm-12 col-xs-6 form-group">
										<div><?php if(!empty($register_opportunity)) { 										
																echo $register_opportunity->emd_amount; 
																}
															?></div>
									</div>
								</div> 
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Bid ID :</label>
									<div class="col-md-7 col-sm-12 col-xs-6 form-group">
										<div><?php if(!empty($register_opportunity)) { 										
																echo $register_opportunity->bid_id; 
																}
															?></div>
									</div>
								</div> 
								 <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Validated by:</label>
									<div class="col-md-7 col-sm-12 col-xs-6 form-group">
										<div><?php 
						$createdBy = getNameById('user_detail',$register_opportunity->created_by,'u_id');
						if(!empty($createdBy)){
							echo $validatedBy = $createdBy->name;
						}else{
							echo $validatedBy = '';
						}
															?></div>
									</div>
								</div> 
					</div>

<div class="col-md-6 col-xs-12 col-sm-6 label-left">
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Tender Amount :</label>
									<div class="col-md-7 col-sm-12 col-xs-6 form-group">
										<div><?php if(!empty($register_opportunity)) { 										
																echo $register_opportunity->tender_amount; 
																}
															?></div>
									</div>
								</div> 



                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Tender Status :</label>
									<div class="col-md-7 col-sm-12 col-xs-6 form-group">
										<div><?php if(!empty($register_opportunity) && $register_opportunity->tender_status !=''   && $register_opportunity->tender_status != 0) { 
										$lead_status = getNameById('tender_status',$register_opportunity->tender_status,'id'); 
										echo $lead_status->name; 
										}
									?></div>
									</div>
					</div>	
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Tender Comment :</label>
									<div class="col-md-7 col-sm-12 col-xs-6 form-group">
										<div><?php if(!empty($register_opportunity)) echo $register_opportunity->status_comment; ?></div>
									</div>
					</div>
                         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Location :</label>
									<div class="col-md-7 col-sm-12 col-xs-6 form-group">
										<div><?php if(!empty($register_opportunity)) echo $register_opportunity->bid_location; ?></div>
									</div>
					</div>					
			  
			  </div>
			  
<hr>
<div class="bottom-bdr"></div>
			  
<div class="container mt-3">
<h3 class="Material-head">Tender Details<hr></h3>	
		<div class="well pro-details" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; border:0px; margin-top: 15px;">
           <?php if(!empty($register_opportunity) && $register_opportunity->tender_detail!=''){ 
										$contacts = json_decode($register_opportunity->tender_detail);
									?>
			 <div class="col-container mobile-view2">
			       <div class="col-md-1 col-sm-12 col-xs-12 form-group">S.no</div>
				   <div class="col-md-4 col-sm-12 col-xs-12 form-group">Tender Name</div>
				   <div class="col-md-4 col-sm-12 col-xs-12 form-group">Department Name</div>
				   <div class="col-md-3 col-sm-12 col-xs-12 form-group">Tender Link</div>
                 				   
			 </div>	
             <?php
														$i =1;
														foreach($contacts as $contact){
															
													?>
				<div class="row-padding col-container mobile-view view-page-mobile-view">
				         <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
						                    <label>S.no</label>
											<div  ><?php echo $i; ?></div>
						  </div>
						  <div class="col-md-4 col-sm-12 col-xs-12 form-group col">
						                    <label>Tender Name</label>
											<div ><?php echo $contact->tender_name ; ?></div>
						  </div>
						  <div class="col-md-4 col-sm-12 col-xs-12 form-group col">
						                    <label>Tender Department</label>
											<div ><?php echo $contact->department_name; ?></div>
						  </div>
						  <div class="col-md-3 col-sm-12 col-xs-12 form-group col">
						                    <label>Tender Link</label>
											<div style="border-right:1px solid #c1c1c1 !important;"><?php echo $contact->tender_link; ?></div>
						  </div>
				     
				</div>


             <?php $i++;}?>													

           <?php } ?>								
		</div>

</div>			  
<hr>
<div class="bottom-bdr"></div>

<div class="container mt-3">
<h3 class="Material-head">Product Information<hr></h3>
    <?php
		if (!empty($register_opportunity->material_type_id)) 
		{
		$material_type_id = getNameById('material_type', $register_opportunity->material_type_id, 'id');
		echo 'Material Type-'.$material_type_id->name;
		}
								?>
<div class="well pro-details" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; border:0px; margin-top: 15px; border-right:1px solid #c1c1c1 !important;">
<?php 
										if(!empty($register_opportunity) && $register_opportunity->product_detail!=''){ 
											$productDetail = json_decode($register_opportunity->product_detail);
										?>
   <div class="col-container mobile-view2">
			       <div class="col-md-1 col-sm-12 col-xs-12 form-group ">S.no</div>
				   <div class="col-md-2 col-sm-12 col-xs-12 form-group">Material Name</div>
				   <div class="col-md-3 col-sm-12 col-xs-12 form-group">Description</div>
				   <div class="col-md-2 col-sm-12 col-xs-12 form-group">Quantity/Uom</div>
				   <div class="col-md-2 col-sm-12 col-xs-12 form-group">Price</div>
				   <div class="col-md-2 col-sm-12 col-xs-12 form-group">GST</div>
				   <div class="col-md-2 col-sm-12 col-xs-12 form-group">Total</div>
                 				   
			 </div>
         
	<?php
	
														$i =1;
														foreach($productDetail as $product_detail){	
														$materialName = getNameById('material',$product_detail->material_name_id ,'id');
													?>
	 <div class="row-padding col-container mobile-view view-page-mobile-view" style="border-right:1px solid #c1c1c1 !important;">
									       <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
										   <label>S.no</label>
											<div><b><?php echo $i; ?></b></div>
									
								          </div>
										  <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
										   <label>Material Name</label>
											<div><?php if(!empty($materialName)){echo $materialName->material_name;} ?></div>
									
								          </div>
										  <div class="col-md-3 col-sm-12 col-xs-12 form-group col">
										    <label>Description</label>
											<div><?php echo $product_detail->description; ?></div>
									
								          </div>
										  <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
										    <label>Quantity/Uom</label>

										    <?php

										    	$ww =  getNameById('uom', $product_detail->uom_material,'id');
														$uom = !empty($ww)?$ww->ugc_code:'';

														
									
										    ?>
											<div><?php echo $product_detail->qty."/".$uom; ?></div>


								          </div>
								          
										  <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
										  <label>Price</label>
											<div> <?php if(!empty($product_detail) && isset($product_detail->price)) echo $product_detail->price;?></div>
									
								          </div>
								          <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
										  <label>GST</label>
											<div> <?php if(!empty($product_detail) && isset($product_detail->gst)) echo chop($product_detail->gst,"%");?></div>
									
								          </div>
										  <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
										    <label>Total</label>
											<div ><?php if(!empty($product_detail) && isset($product_detail->TotalWithGst)) echo $product_detail->TotalWithGst;?></div>
									       </div>
	 </div>
	 
	<?php $i++;}?>	
<?php }?>
</div>
<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
                   

					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
						
					<div class="col-md-12 col-sm-5 col-xs-12 text-right">
						
						
						<div class="col-md-6 col-sm-5 col-xs-6 ">
							Total without GST : 
							</div>
							<div class="col-md-6 text-left"><?php if(!empty($register_opportunity)){echo $register_opportunity->totalwithoutgst; }?></div>	
							 
						
<div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2" >
						<div class="col-md-6 col-sm-5 col-xs-6 form-group">
							Grand Total : 
							</div>
							<div class="col-md-6 text-left form-group"><?php if(!empty($register_opportunity)){echo $register_opportunity->grand_total; }?></div>	
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
			
				</div>	



</div>

	
			  
        </div>
</div>

</div>





 <!--<table class="fixed data table table-bordered no-margin">												
						<thead>													
							<tbody>	
								<tr>														
									<th>Lead Owner:</th>													
									<td><?php if(!empty($lead) && $lead->lead_owner != 0){ 
													$leadOwner  = getNameById('user_detail',$lead->lead_owner,'u_id'); 
													if(!empty($leadOwner)) echo $leadOwner->name;
												}?></td>									
																						
								</tr>							
								<tr>														
																		
									<th>Lead Generated By:</th>			
									
									<td><?php if(!empty($lead) && $lead->created_by != 0){
												$leadGeneratedBy  =  getNameById('user_detail',$lead->created_by,'u_id'); 
												if(!empty($leadGeneratedBy)) echo $leadGeneratedBy->name;
											}?></td>													
								</tr>							
								<tr>														
									<th>Street:</th>														
									<td><?php if(!empty($lead)) echo $lead->street; ?></td>									
																					
								</tr>													
								<tr>														
																
									<th>City:</th>														
									<td><?php if(!empty($lead) && $lead->city !=''  && $lead->city != 0) { 
										$city = getNameById('city',$lead->city,'city_id'); 
										echo $city->city_name; 
										}
									?></td>													
								</tr>													
								<tr>														
									<th>Zipcode / Postalcode</th>														
									<td><?php if(!empty($lead)) echo $lead->zipcode; ?></td>														
																			
								</tr>													
								<tr>														
																						
									<th>State/Province:</th>														
									<td><?php if(!empty($lead) && $lead->state !=''  && $lead->state != 0) { 
										$state = getNameById('state',$lead->state,'state_id'); 
										echo $state->state_name; 
										}
									?></td>												
								</tr>													
								<tr>														
									<th>Country:</th>	
									<td><?php if(!empty($lead) && $lead->country !=''   && $lead->country != 0) { 
										$country = getNameById('country',$lead->country,'country_id'); 
										echo $country->country_name; 
										}
									?></td>								
																					
								</tr>	
								<tr>														
									<th>Website:</th>	
									<td><?php if(!empty($lead)) { 										
										echo $lead->website; 
										}
									?></td>								
																					
								</tr>									
								<tr>														
																
									<th>Products:</th>														
									<td><?php if(!empty($lead)) echo $lead->products; ?></td>													
								</tr>													
								<tr>														
									<th>Lead Source: </th>														
									<td><?php if(!empty($lead) && $lead->lead_source !='') { 
										$lead_source = getNameById('lead_source',$lead->lead_source,'id'); 
										echo $lead_source->source_name; 
										}
									?></td>			
									 											
								</tr>	
								<tr>														
									
									<th>Quantity: </th>														
									<td><?php if(!empty($lead)) echo $lead->quantity; ?></td> 											
								</tr>	
								<tr>														
									<th>Lead Status: </th>														
									<td><?php if(!empty($lead) && $lead->lead_status !=''   && $lead->lead_status != 0) { 
										$lead_status = getNameById('lead_status',$lead->lead_status,'id'); 
										echo $lead_status->name; 
										}
									?></td>		
																				
								</tr>	
								<tr>														
										
									<th>Lead Status Comment: </th>														
									<td><?php if(!empty($lead)) echo $lead->status_comment; ?></td> 											
								</tr>
								<tr>														
									<th>Product Information: </th>														
									<td>
										<?php 
										if(!empty($lead) && $lead->product_detail!=''){ 
											$productDetail = json_decode($lead->product_detail);
										?>
										<div class="x_content">
											<table class="table table-bordered data">
												<thead>
													<tr>
														<th>S.no</th>
														<th>Material Name</th>
														<th>Description</th>
														<th>Quantity/Uom</th>
														<th>Price</th>
														<th>Total</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$i =1;
														foreach($productDetail as $product_detail){	
														$materialName = getNameById('material',$product_detail->material_name_id ,'id');
													?>		
													<tr>
														<th scope="row"><?php echo $i; ?></th>
														<td><?php if(!empty($materialName)){echo $materialName->material_name;} ?></td>
														<td><?php echo $product_detail->description; ?></td>
														<td><?php echo $product_detail->qty."/".$product_detail->uom_material; ?></td>
														<td><?php echo $product_detail->price; ?></td>
														<td><?php echo $product_detail->total; ?></td>
													</tr>
														<?php $i++;}?>
													<tr><td colspan="5"><strong>Grand Total</strong></td>
														<td><?php if(!empty($lead)){echo $lead->grand_total; }?></td></tr>	
												</tbody>
											</table>
										</div>
										<?php }?>
									</td> 											
								</tr>
								<tr>   
									<?php if(!empty($lead) && $lead->contacts!=''){ 
										$contacts = json_decode($lead->contacts);
									?>
										<th>contacts	: </th>
										<td></td>	
										<div class="x_content">
											<table class="table table-bordered data">
												<thead>
													<tr>
														<th>S.No</th>
														<th>Name</th>
														<th>Email</th>
														<th>Phone</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$i =1;
														foreach($contacts as $contact){
															
													?>					  
														<tr>
															<th scope="row"><?php echo $i; ?></th>
															<td><?php echo $contact->first_name . ' '.$contact->last_name ; ?></td>
															<td><?php echo $contact->email; ?></td>
															<td><?php echo $contact->phone_no; ?></td>
														</tr>
													<?php $i++;}?>									
												</tbody>
											</table>
										</div>
									<?php } ?>
								</tr>						
							</tbody>												
						</thead>												
                    </table>-->
					
					
<center>
	<button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
	
</center>