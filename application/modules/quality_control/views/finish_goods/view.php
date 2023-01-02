<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/save_ncr" enctype="multipart/form-data" id="NcrDetail" novalidate="novalidate" style="">
<div class="col-md-12 col-sm-12 col-xs-12 ">
<table id="example" class="table table-striped table-bordered" data-id="user" border="1" cellpadding="3">
							<tbody>
								<tr>
									<th>Job card</th>
									<th>Total Quantity</th>
									<th>Material Detail</th>
								</tr>
							</tbody>
							<tbody>
								<?php 
								
								$jobCardDetail= json_decode($datst->job_card_detail);
									if(!empty($jobCardDetail)){
										foreach($jobCardDetail as $job_card){
											
											if(!empty($job_card->material_id)){
											    
											
											@$material_detail_count = count($job_card->material_id);
											//pre($job_card->material_id);
											}
										@$jobCardname = getNameById('job_card',$job_card->job_card_no,'id')->job_card_product_name;
										
										// foreach($job_card->material_id as $material_detail);
													// Pre($material_detail);
												      // $materialName = getNameById('material',$material_detail->material_id,'id')->material_name;
								?>
				<tr>
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
							
								//foreach($job_card->material_id as $mat_detail){
								//$materialName = getNameById('material',$mat_detail->material_id,'id')->material_name;
								$materialName = getNameById('material',$job_card->material_id,'id')->material_name;
								
								//$ww =  getNameById('uom', $mat_detail->uom,'id');
								$ww =  getNameById('uom', $job_card->uom,'id');
								$uom = !empty($ww)?$ww->ugc_code:'';
							
							?>
						<tr>
						<td><?php if(!empty($materialName)){echo $materialName;} else{ echo "";}?></td>
						<td><?php echo $job_card->quantity; ?></td>
						<td><?php echo $uom; ?></td>
						<td><?php echo $job_card->output; ?></td>
						</tr>
						<?php //}
						} ?>
					</tbody>
				</table>
				</td>
			</tr>
			<?php }} ?>
			
		</tbody>
	</table>
			
</div>
	
	<center>
		<div class="modal-footer">
			 <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
			</div>
	</center>
</form>                      