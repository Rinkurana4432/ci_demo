<?php 
$ci = & get_instance();
	 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">				
		<div class="item form-group ">
            <div class="col-md-12 col-sm-12 col-xs-12 recv_finish_goods_add finish-mr middle-box2">
				<div class="panel panel-default">
					
					
					
						<div class="panel-body middle-box2">
							<div class="col-md-12">
								<table id="" class="table table-striped table-bordered" data-id="user" border="1" cellpadding="3">
							<tbody>
								<tr>
									<th>Work Order Name</th>
									<th>Job card</th>
									<th>Total Quantity</th>
									<th>Material Detail</th>
								</tr>
							</tbody>
							<tbody>
								<?php $jobCardDetail= json_decode($finish_good->job_card_detail);
									if(!empty($jobCardDetail)){
										foreach($jobCardDetail as $job_card){
											if(!empty($job_card->material_id)){
											@$material_detail_count = count($job_card->material_id);
											}
										@$jobCardname = getNameById('job_card',$job_card->job_card_no,'id')->job_card_product_name;
										$wrkordr = getNameById('work_order',$job_card->work_order_id,'id');
										
								?>
								<tr>
									<td><?php if(!empty($wrkordr)){echo $wrkordr->workorder_name;}else{echo "";} ?></td>
									<td><?php if(!empty($jobCardname)){echo $jobCardname;}else{echo "";} ?></td>
									<td><?php echo $job_card->totalAmountQty; ?></td>
									<td>
                                    <!-------- datatable-buttons ----------->
										<table id="" class="table table-striped table-bordered" data-id="user" border="1" cellpadding="3">
											<thead>
												<tr>
													<th>Product name</th>
													<th>Quantity</th>
													<th>UOM</th>
													<th>Output</th>
												</tr>
											</thead>
											<tbody>
												<?php if($material_detail_count >0){
														$materialName = getNameById('material',$job_card->material_id,'id')->material_name;
														$ww =  getNameById('uom', $job_card->uom,'id');
														$uom = !empty($ww)?$ww->ugc_code:'';
													?>
												<tr>
												<td><?php if(!empty($materialName)){echo $materialName;} else{ echo "";}?></td>
												<td><?php echo $job_card->quantity; ?></td>
												<td><?php echo $uom; ?></td>
												<td><?php echo $job_card->output; ?></td>
												</tr>
												<?php 
										 }
									 ?>
											</tbody>
										</table>
									</td>
								</tr>
								<?php }		}  ?>
								
							</tbody>
						</table>
		
          
        
                    <div class="col-md-12 col-md-offset-3">
					<center>
              
						<!--input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft"-->
                  
                            <a class="btn edit-end-btn" onclick="location.href='<?php echo base_url();?>inventory/finish_goods'">Cancel</a>
                     </div>
                </center>
								</div>	
							</div>	
						</div>
				</div>
			</div>
		</div>