<?php 
$ci = & get_instance();
	 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">				
		<div class="item form-group ">
            <div class="col-md-12 col-sm-12 col-xs-12 recv_finish_goods_add finish-mr middle-box2">
				<div class="panel panel-default">
					<h3 class="Material-head">Received Finish<span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span><hr></b></h3>
					
					
						<div class="panel-body middle-box2">
							<div class="col-md-12">
								<div class="vertical-border __voucherDateDetails">
									<div class="col-md-5 col-sm-12 col-xs-12 form-group">				
										<label class="">Voucher Date</label>		
										<input class="form-control" type="text" readonly value="<?php if(!empty($ackn_fg->voucher_date)){  echo date("j F , Y", strtotime($ackn_fg->voucher_date));}else{echo "";} ?>">				
									</div>
									<div class="col-md-5 col-sm-12 col-xs-12 form-group">				
										<label class="">Location</label>		
										<input class="form-control" type="text" readonly value="<?php if(!empty($company_details)){  echo $company_details->location;}else{echo "";} ?>">				
									</div>
								</div>
								<?php $job_cardData = json_decode($ackn_fg->job_card_detail);

									#pre($ackn_fg);
									foreach($job_cardData as $jc_dt){
								?>
									<div class="well" id="chkIndex_1" style="overflow:auto; margin-bottom: 20px;" >
										<div class="item " style="border-top: 1px solid #c1c1c1;padding:0px;">
												
												<div class="col-md-2 item form-group">
													<label for="mate">Work Order name</label>
												<?php
													$ww =  getNameById('work_order', $jc_dt->work_order_id,'id');
													$material_n = !empty($ww)?$ww->workorder_name:'';
												?>
												<div><?php if(!empty($material_n)){ echo $material_n; } ?></div>
												</div>


												<div class="col-md-2 col-sm-6 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1 !important;">
												<label  for="mat_name">Job Card</label>
												<?php
													$ww =  getNameById('job_card', $jc_dt->job_card_no,'id');
													$job_card_no = !empty($ww)?$ww->job_card_no:'';
												?>
												<div><?php if(!empty($job_card_no)){ echo $job_card_no; } ?></div>
												</div>	
											<div class="col-md-2 col-sm-6 col-xs-12 form-group">
												<label  for="mat_name">Total Quantity</label>
												<div><?php if(!empty($jc_dt->totalAmountQty)){ echo $jc_dt->totalAmountQty; } ?></div>
											</div>
										
												<div class="col-md-2 item form-group">
													<label for="mate">Product name</label>
												<?php
													$ww =  getNameById('material', $jc_dt->material_id,'id');
													$material_n = !empty($ww)?$ww->material_name:'';
												?>
												<div><?php if(!empty($material_n)){ echo $material_n; } ?></div>
												</div>
												<div class="col-md-2 item form-group">
													<label for="qty">Quantity</label>
													<div><?php if(!empty($jc_dt->quantity)){ echo $jc_dt->quantity; } ?></div>
												</div>	
												<div class="col-md-2 item form-group">
													<label for="Uom">UOM</label>
												<?php
													$ww =  getNameById('uom', $jc_dt->uom,'id');
													$uom = !empty($ww)?$ww->ugc_code:'';
												?>
												<div><?php if(!empty($uom)){ echo $uom; } ?></div>
												</div>	
												<div class="col-md-2 item form-group">
													<label for="output">Output</label>
													<div><?php if(!empty($jc_dt->output)){ echo $jc_dt->output; } ?></div>
												</div>	
												
										</div>
									</div>	

								<?php } ?>
                                <?php 	$scrapData = json_decode($ackn_fg->scrap_material_detail,true);  
										if($scrapData){
								?>		
									<div class="item ">
										<div class="col-md-12 col-sm-12 col-xs-12"><h3 class="Material-head">Scrap Details<hr></h3></div>
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Sr.no</th>
													<th>Work Order</th>
													<th>Material Type</th>
													<th>Material Name</th>
													<th>Quantity</th>
													<th>UOM</th>
												</tr>	
											</thead>
											<tbody>
												<?php 
													$i=1;
													foreach($scrapData as $scrapDetail){  
													$materialName     = getNameById('material',$scrapDetail['material_name_id'],'id');
													$productDetails   = getNameById('material_type',$scrapDetail['material_type_id'],'id');   
													$uomname          = getNameById('uom',$scrapDetail['unit'],'id');
													$workOrderDetails = getNameById('work_order', $scrapDetail['work_order_id'],'id');
												?>
												<tr>
													<td><?php   echo $i; ?></td>
													<td><?php   if(!empty($workOrderDetails)){echo $workOrderDetails->workorder_name;}else{echo "";} ?></td>
													<td><?php   if(!empty($materialName)){echo $materialName->material_name;}else{echo "";} ?></td>
													<td><?php   if(!empty($productDetails)){echo $productDetails->name;}else{echo "";} ?></td>
													<td><?php   echo $scrapDetail['quantity']; ?></td>
													<td><?php   if(!empty($uomname)){echo $uomname->uom_quantity;}else{echo "";} ?></td>
												</tr>
											<?php $i++; } ?>		
											</tbody>	
										</table>		
										
									</div>
								<?php } ?>        
                                        
                                        
                                        
		<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/fg_updateaknowledge" enctype="multipart/form-data" id="similarmachine" novalidate="novalidate">
             <input type="hidden" name="id" value="<?php if(!empty($ackn_fg->id)){ echo $ackn_fg->id; } ?>">
             <input type="hidden" name="job_card_detail" value='<?php echo !empty($ackn_fg->job_card_detail)?$ackn_fg->job_card_detail:'' ?>'> 
             <input type="hidden" name="scrap_qty" value="<?php if(!empty($ackn_fg->scrap_qty)){ echo $ackn_fg->scrap_qty; } ?>"> 
             <input type="hidden" name="material_scrap_id" value="<?php if(!empty($ackn_fg->material_scrap_id)){ echo $ackn_fg->material_scrap_id; } ?>"> 
			 <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
			 <input type="hidden" name="aknowlwdge_by" value="<?php echo $_SESSION['loggedInUser']->name; ?>" id="loggedUser"> 
          <div class="col-md-8 col-sm-12 col-xs-12 vertical-border">			
			
			<label class="col-md-3 col-sm-12 col-xs-12">Acknowledge Date</label>		
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="date" name="acknowledge_date" id="acknowledge" class="form-control col-md-7 col-xs-12 req_date">				
				</div>
			
           </div>
                <hr>
                    <div class="col-md-12 col-md-offset-3">
					<center>
                        <button type="reset" class="btn btn-default edit-end-btn">Reset</button>
						<!--input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft"-->
                            <button id="send" type="submit" class="btn edit-end-btn">Submit</button>
                            <a class="btn edit-end-btn" onclick="location.href='<?php echo base_url();?>inventory/finish_goods'">Cancel</a>
                     </div>
                </center>
</form>
								</div>	
							</div>	
						</div>
				</div>
			</div>
		</div>
