<div class="x_content">
	<div class="" role="tabpanel" data-example-id="togglable-tabs">   
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" class="active"><a href="#view" role="tab" id="view_tab" data-toggle="tab" aria-expanded="false">View Work Order</a></li>
			<li role="presentation" class=""><a href="#ViewLabourCost" role="tab" id="ViewLabourCost_tab" data-toggle="tab" aria-expanded="false">View Labour Costing</a></li>
			<li role="presentation" class=""><a href="#ViewProcessWiseReport" role="tab" id="ViewProcessWiseReport_tab" data-toggle="tab" aria-expanded="false">Process wise report</a></li>
			<li role="presentation" class=""><a href="#ViewRawMaterialIssued" role="tab" id="ViewRawMaterialIssued_tab" data-toggle="tab" aria-expanded="false">Raw Material Issued</a></li>
			<li role="presentation" class=""><a href="#ViewBomScrapDetails" role="tab" id="ViewBomScrapDetails_tab" data-toggle="tab" aria-expanded="false">Scrap Details</a></li>
		</ul>
		<div id="myTabContent" class="tab-content">
			<div role="tabpanel" class="tab-pane fade active in" id="view" aria-labelledby="">
				<table class="fixed data table table-bordered no-margin" style="width:100%" id="print_divv" border="1" cellpadding="2">
				   <thead>													
				   <tbody>
					  <tr>
						 <th>Customer name:</th>
						 <td><?php if(!empty($work_order)){
							$customerName =  getNameById('account',$work_order->customer_name_id,'id');	
								if(!empty($customerName)){
									echo $customerName->name; 
									}
								else{
									echo $work_order->customer_name;
								}	
							}					?></td>
					  </tr>
					  <tr>
						 <th>Work Order Name:</th>
						 <td><?php if(!empty($work_order)){ echo $work_order->workorder_name; } ?>
						 </td>
					  </tr>     
					  <tr>
						 <th>Work Order No:</th>
						 <td><?php if(!empty($work_order)){ echo $work_order->work_order_no; } ?>
						 </td>
					  </tr>
					  <tr>
						 <th>Material Type</th>
						 <td><?php if(!empty($work_order)){ 
							$materialTypeName = getNameById('material_type',$work_order->material_type_id,'id'); 
								if(!empty($materialTypeName)){echo $materialTypeName->name;}
							} ?>
						 </td>
					  </tr>
					  <tr>
						 <th>Product:</th>
						 <td>
							<table id="gg" class="table table-bordered" data-id="user" border="1" cellpadding="3">
							   <?php 
								  $productDetail=json_decode($work_order->product_detail); ?>
							   <thead>
								  <tr>
									 <th>Product name</th>
									 <th>Required Qty</th>
									 <th>WorkOrder Qty</th>
									 <th>UoM</th>
									 <th>Job Card</th>
								  </tr>
							   </thead>
							   <?php 
								  if(!empty($productDetail)){
									foreach($productDetail as $product_Detail){ 
									$materialName = getNameById('material',$product_Detail->product,'id');
								  ?>		
							   <tbody>
								  <tr>
									 <th><?php if(!empty($materialName)){echo $materialName->material_name;}else{echo "N/A";} ?></th>
									 <th><?php  if(!empty($product_Detail)){echo $product_Detail->quantity;}else{echo "N/A";} ?></th>
									 <th><?php  if(!empty($product_Detail)){echo $product_Detail->transfer_quantity??'';}else{echo "N/A";} ?></th>
									 <th><?php  //if(!empty($product_Detail)){echo $product_Detail->uom;}else{echo "N/A";} 
										$ww =  getNameById('uom', $product_Detail->uom,'id');
										$uom = !empty($ww)?$ww->ugc_code:'';
										
										echo $uom;
										
										?></th>
									 <th><?php  if(!empty($product_Detail)){echo $product_Detail->job_card;}else{echo "N/A";} ?></th>
								  </tr>
								  <?php }}?>
							   </tbody>
							</table>
						 </td>
					  </tr>
					  <tr>
						 <th>WorkOrder Status:</th>
						 <td><?php //if(!empty($work_order)){ echo $work_order->progress_status; }  ?>
						 <?php if($work_order->progress_status!=='') echo (($work_order->progress_status == '1')?'Completed':'In Progress') ;?></td>
					  </tr>      <tr>
						 <th>Stock OR Sale Order:</th>
						 <td><?php if(!empty($work_order)){ echo $work_order->stock_saleOrder; }  ?></td>
					  </tr>
					  <th>Specification:</th>
					  <td><?php if(!empty($work_order)){ echo $work_order->specification; }  ?></td>
					  </tr>
					  <tr>
						 <th>Expected Delivery date:</th>
						 <td><?php if(!empty($work_order)){ echo $work_order->expected_delivery_date; }  ?>
						 </td>
					  </tr>
				   </tbody>
				   </thead>												
				</table>
				<center>
				   <button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
				</center>
			</div>
         <div role="tabpanel" class="tab-pane fade" id="ViewLabourCost" aria-labelledby="">
            <?php if(!empty($labour_costing)){ ?>
				<table id="" class="table table-bordered" data-id="" border="1" cellpadding="3">
					<thead>
						<tr>
							<th>Sr.no</th>
							<th>Date</th>  
							<th>Machine name</th> 
							<th>Work Order name</th>                
							<th>Product name</th>
							<th>Process Name</th>
							<th>Worker's Name</th>
							<th>Labour Cost</th>
							<th>Quantity</th>
							<th>Per Unit Cost</th>
						</tr>
					</thead>
					<?php 
						if(!empty($labour_costing)){
							$i = 1;
							$totalLabourCost = 0;
							foreach($labour_costing as $labour_detail){ 
								$materialName = getNameById('material',$labour_detail['party_code'],'id');
								$processName  = getNameById('add_process',$labour_detail['process_name'],'id');
								$machineName  = getNameById('add_machine',$labour_detail['machine_name_id'],'id');
								$workerName   = '';
								if($labour_detail['worker_id']){
								   foreach($labour_detail['worker_id'] as $workerIds){
									  $worker_details   = getNameById('worker',$workerIds,'id');
									  $workerName       .= $worker_details->name.', ';
								   }
								}
								$subTotalSalary = 0;
								if($labour_detail['totalsalary']){
								   foreach($labour_detail['totalsalary'] as $workerSalary){
									  $subTotalSalary += $workerSalary;
								   }
								}
								$per_unit_cost = round($labour_detail['per_unit_cost'],2);
								$totalLabourCost += $subTotalSalary;
					?>		
					<tbody>
						<tr>
							<td><?php echo $i;  ?></td>   
							<td><?php echo $labour_detail['date'];  ?></td> 
							<td><?php if(!empty($machineName)){echo $machineName->machine_name;}else{echo "N/A";} ?></td>
							<td><?php if(!empty($work_order)){ echo $work_order->workorder_name; } ?></td>
							<td><?php if(!empty($materialName)){echo $materialName->material_name;}else{echo "N/A";} ?></td>
							<td><?php if(!empty($processName)){ echo $processName->process_name; }else{echo "N/A";} ?></td>
							<td><?php  $workerName = trim($workerName, ', '); echo $workerName; ?></td>
							<td><?php echo $subTotalSalary; ?></td>
							<td><?php echo $labour_detail['output_quantity'][0]; ?></td>
							<td><?php echo $per_unit_cost; ?></td>
						</tr>
                     <?php  $i++; }  ?>
					</tbody>
					<tfoot>
						<tr>
							<td><strong>Total</strong></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><strong><?php echo $totalLabourCost;  ?></strong></td>
							<td></td>
							<td></td>
						</tr>
					</tfoot>
                  <?php } ?>
				</table>
				<?php } else { ?>
                  <p>No Data Found.</p>
				<?php } ?> 
			</div>
			<div role="tabpanel" class="tab-pane fade" id="ViewProcessWiseReport" aria-labelledby="">
			 <?php
			 //if(!empty($process_wise_report)){
			    /*?>
				   <table id="" class="table table-bordered" data-id="" border="1" cellpadding="3">
					  <thead>
						 <tr>
							<th>Sr.no</th>
							<th>Work Order name</th>                
							<th>Product name</th>
							<th>Process Name</th>
							<th>Required Quantity</th>
							<th>Completed Quantity</th>
							<th>Remaining Quantity</th>
							<th>Labour Cost</th>
							<th>Per Unit Labour Cost</th>
						 </tr>
					  </thead>
					  <?php 
						 if(!empty($process_wise_report)){
							$i = 1;
							$totalLabourCost = 0;
							foreach($process_wise_report as $process_wise_detail){ 
							$materialName = getNameById('material',$process_wise_detail['party_code'],'id');
							$processName  = getNameById('add_process',$process_wise_detail['process_name'],'id');
							
							$totalSalary = 0;
							if($labour_detail['totalsalary']){
							   foreach($process_wise_detail['totalsalary'] as $workerSalary){
								  $totalSalary += $workerSalary;
							   }
							}
							$inputProcessDetails    = '';
							$getDetails             =  getRequiredQuantityForProcess('job_card',$process_wise_detail['job_card_product_id'],'processess',$process_wise_detail['process_name']);
							if($getDetails){
							   $decodeDetails   = json_decode($getDetails['machine_details'],true);
							   if( $decodeDetails ){
								  foreach($decodeDetails as $innerDetails){
									 if($innerDetails['input_process']){
										$inputProcessDetails   = json_decode($innerDetails['input_process'],true);
									 }
								  }
							   }
							}
							$requiredQuantity       =  0;
							if($inputProcessDetails){
							   foreach($inputProcessDetails as $inputQuantityDetails){
								  $requiredQuantity += $inputQuantityDetails['quantity_input'];
							   }
							}
							// $remainingQuantity      =  $requiredQuantity  -  $process_wise_detail['output_quantity'];
							// $per_unit_labour_cost   =  round(($totalSalary / $process_wise_detail['output_quantity']),2);
						 ?>		
					  <tbody>
						 <tr>
							<td><?php echo $i;  ?></td>   
							<td><?php if(!empty($work_order)){ echo $work_order->workorder_name; } ?></td>
							<td><?php if(!empty($materialName)){echo $materialName->material_name;}else{echo "N/A";} ?></td>
							<td><?php if(!empty($processName)){ echo $processName->process_name; }else{echo "N/A";} ?></td>
							<td><?php echo $requiredQuantity; ?></td>
							<td><?php echo $process_wise_detail['output_quantity']; ?></td>
							<td><?php //echo $remainingQuantity; ?></td>
							<td><?php echo $totalSalary; ?></td>
							<td><?php //echo $per_unit_labour_cost; ?></td>

						 </tr>
						 <?php $i++; } ?>
					  </tbody>
					  <?php }  ?>
				   </table> */ /*  ?>
				  <h3><?php if(!empty($materialName)){echo $materialName->material_name;}else{echo "N/A";} ?></h3>
				  <table id="" class="table table-bordered" data-id="" border="1" cellpadding="3">
					  <thead>
						 <tr>
							<th>Process</th>
							<th>Output Material</th>                
							<th>Req. Output</th>
							<th>Completed Qty</th>
							<th>In Progress Qty</th>
							<th>Remaining Qty</th>
							<th>Remaining Time</th>
							<th>Labour Cost</th>
							<th>Status</th>
						 </tr>
					  </thead>
					  <tbody>
					  	<?php
					  	//$jobCardData = isset($productionDetail->job_card_product_id[$i])?(getNameById('job_card',$productionDetail->job_card_product_id[$i],'id')):'';
						$where = array(
						'company_branch' => $work_order->company_branch_id,
						'department_id' => $work_order->department_id,
						);
					  	$production_data = $this->production_model->get_data('production_data', $where);
					  	$production_planning = $this->production_model->get_data('production_planning', $where);
					  	 if(!empty($process_wise_report)){
						 	foreach($process_wise_report as $process_wise_detail){ 
							$materialName = getNameById('material',$process_wise_detail['party_code'],'id');
							$processName  = getNameById('add_process',$process_wise_detail['process_name'],'id');
							$totalSalary = 0;
							if($labour_detail['totalsalary']){
							   foreach($process_wise_detail['totalsalary'] as $workerSalary){
								  $totalSalary += $workerSalary;
							   }
							}

							$outputProcessDetails = $hr_set    = array();
							$getDetails             =  getRequiredQuantityForProcess('job_card',$process_wise_detail['job_card_product_id'],'processess',$process_wise_detail['process_name']);
							if($getDetails){
							   $decodeDetails   = json_decode($getDetails['machine_details'],true);
							   if( $decodeDetails ){
								  foreach($decodeDetails as $innerDetails){
									 if($innerDetails['output_process']){
										$outputProcessDetails[$innerDetails['processess']]   = json_decode($innerDetails['output_process'],true);
									 }
								$machine_paramenters = json_decode($innerDetails['machine_details'],true);
								$hr_set_array =$mm_set_array =$sec_set_array =$mt_hr_array =$mt_mm_array =$mt_sec_array = array();
								foreach($machine_paramenters as $value){
								foreach ($value['machine_id'] as $key => $value1) {
								$hr_set_array[] = $value['hr_set'][$value1];
								$mm_set_array[] = $value['mm_set'][$value1];
								$sec_set_array[] = $value['sec_set'][$value1];
								$mt_hr_array[] = $value['mt_hr_set'][$value1];
								$mt_mm_array[] = $value['mt_mm_set'][$value1];
								$mt_sec_array[] = $value['mt_sec_set'][$value1];
								//$machine_time_array[] = $value['machine_time'][$value1];
								}
								$hr_set[$innerDetails['processess']] = $hr_set_array;
								$mm_set[$innerDetails['processess']] = $mm_set_array;
								$sec_set[$innerDetails['processess']] = $sec_set_array;
								$mt_hr_set[$innerDetails['processess']] = $mt_hr_array;
								$mt_mm_set[$innerDetails['processess']] = $mt_mm_array;
								$mt_sec_set[$innerDetails['processess']] = $mt_sec_array;
								//$machine_time[$innerDetails['processess']] = $machine_time_array;
								}
								  }
							   }
							}

							// $total_output_quantity = 0;
							// foreach ($process_wise_detail['output_quantity'] as $output_quantity) {
							// $total_output_quantity += $output_quantity;
							// }
							$hr_inc = 1;
							foreach($hr_set[$process_wise_detail['process_name']] as $ket_v => $hr_setDetails){
								$hh = $hr_setDetails;	
								$mm = $mm_set[$process_wise_detail['process_name']][$ket_v];	
								$ss = $sec_set[$process_wise_detail['process_name']][$ket_v];
								if($hr_inc == 1){
								$setup_time = timeToSeconds($hh.':'.$mm.':'.$ss);
								}
								$hr_inc++;	}
							$mt_inc = 1;
							foreach($mt_hr_set[$process_wise_detail['process_name']] as $ket_v => $mt_hr_setDetails){
								$hh = $mt_hr_setDetails;	
								$mm = $mt_mm_set[$process_wise_detail['process_name']][$ket_v];	
								$ss = $mt_sec_set[$process_wise_detail['process_name']][$ket_v];
								if($mt_inc == 1){
								$machine_time = timeToSeconds($hh.':'.$mm.':'.$ss);
								}
								$mt_inc++; }

							if($outputProcessDetails){
								$out_process = 1;
								$chk = 0;
								foreach($outputProcessDetails[$process_wise_detail['process_name']] as $outputQuantityDetails){
							   $material_id_output = $outputQuantityDetails['material_output_name'];
								$materialName_output = getNameById('material',$material_id_output,'id');
								$process_output_qty = $outputQuantityDetails['quantity_output'];
								$lot_qty = $getDetails['lot_qty'];
								$productDetail=json_decode($work_order->product_detail);
								foreach($productDetail as $product_Detail){ 
								$wo_qty = $product_Detail->quantity;
								}
								$req_output = $wo_qty*$process_output_qty/$lot_qty;


								?>
								<tr>
								<td><?php  if($out_process <= 1){ if(!empty($processName)){ echo $processName->process_name; }else{echo "N/A";} } ?></td>
								<td><?php echo $materialName_output->material_name; ?></td>
								<td><?php echo $req_output; ?></td>
								<td><?php
								$sum_com = 0;
								foreach ($production_data as $p_key => $data_val) {
								$decode_data = json_decode($data_val['production_data'], true);
								foreach ($decode_data as $key => $data_chk) {
								if($process_wise_detail['job_card_product_id'] == $data_chk['job_card_product_id'][0]){
								//$sum_com += $data_chk['output'][0][$chk];
								foreach ($data_chk['output'] as $key_ot => $value) {
								$sum_com += $value[$chk];
								}
								}
								}
								}
								echo $sum_com;
								 //echo $process_wise_detail['output_quantity'][$chk]; ?></td>
								<td><?php
								$sum_pp = 0;
								foreach ($production_planning as $p_key => $data_val) {
								$decode_data = json_decode($data_val['planning_data'], true);
								foreach ($decode_data as $key => $data_chk) {
								if($process_wise_detail['job_card_product_id'] == $data_chk['job_card_product_id'][0]){
								foreach ($data_chk['output'] as $key_ot => $value) {
								$sum_pp += $value[$chk];
								}
								}
								}
								}
								echo $sum_pp;
								?></td>
								<td><?php echo $remain_qty = $req_output-$sum_com-$sum_pp; ?></td>
								<td><?php

								if($remain_qty == $req_output){
								$seconds =  $setup_time + ($remain_qty/$process_output_qty*$machine_time);
								echo sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60);
								} elseif($remain_qty < $req_output){
								$seconds = $remain_qty/$process_output_qty*$machine_time;
								echo sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60);
								} elseif($remain_qty <= 0){
								echo '00:00:00';
								}
								?></td>
								<td><?php echo $totalSalary; ?></td>
								<td><?php
								if($remain_qty == 0 || $sum_pp == 0){
								echo "Completed";
								} elseif($remain_qty ==$req_output){
								echo "Pending";
								} else {
								echo "In Progress";
								}

								?></td>
						 		</tr>
							<?php $chk++; $out_process++; 
							}
							}

							?>

						 
						<?php } } ?>
						</tbody>
				   </table>
				   <?php } else {   */?>
				    <?php 
				    foreach($productDetail as $product_Detail){ 
				    $materialName = getNameById('material',$product_Detail->product,'id');
				    ?>
					 <h3><?php if(!empty($materialName)){echo $materialName->material_name;}else{echo "N/A";} ?></h3>
					 <table id="" class="table table-bordered" data-id="" border="1" cellpadding="3">
					  <thead>
						 <tr>
							<th>Process</th>
							<th>Output Material</th>                
							<th>Req. Output</th>
							<th>Completed Qty</th>
							<th>In Progress Qty</th>
							<th>Remaining Qty</th>
							<th>Remaining Time</th>
							<th>Labour Cost</th>
							<th>Status</th>
						 </tr>
					  </thead>
					  <tbody>
					  	<?php
					  	$where = array(
						'company_branch' => $work_order->company_branch_id,
						'department_id' => $work_order->department_id,
						);
						$production_data = $this->production_model->get_data('production_data', $where);
						$production_planning = $this->production_model->get_data('production_planning', $where);
						$jobCardData = isset($materialName->job_card)?(getNameById('job_card',$materialName->job_card,'id')):'';
							$Detailinfo = json_decode($jobCardData->machine_details);
						$totalSalary = 0;
							if($labour_detail['totalsalary']){
							   foreach($process_wise_detail['totalsalary'] as $workerSalary){
								  $totalSalary += $workerSalary;
							   }
							}
							$ic = 0;
					  	foreach($Detailinfo as $detail_info){
					  	$processName = getNameById('add_process',$detail_info->processess,'id');
					   $output_process =	json_decode($detail_info->output_process,true);

						$machine_paramenters = json_decode($detail_info->machine_details,true);
						$hr_set_array =$mm_set_array =$sec_set_array =$mt_hr_array =$mt_mm_array =$mt_sec_array = array();
						foreach($machine_paramenters as $value){
						foreach ($value['machine_id'] as $key => $value1) {
						$hr_set_array[] = $value['hr_set'][$value1];
						$mm_set_array[] = $value['mm_set'][$value1];
						$sec_set_array[] = $value['sec_set'][$value1];
						$mt_hr_array[] = $value['mt_hr_set'][$value1];
						$mt_mm_array[] = $value['mt_mm_set'][$value1];
						$mt_sec_array[] = $value['mt_sec_set'][$value1];
						break;
						}
						$hr_set[$detail_info->processess] = $hr_set_array;
						$mm_set[$detail_info->processess] = $mm_set_array;
						$sec_set[$detail_info->processess] = $sec_set_array;
						$mt_hr_set[$detail_info->processess] = $mt_hr_array;
						$mt_mm_set[$detail_info->processess] = $mt_mm_array;
						$mt_sec_set[$detail_info->processess] = $mt_sec_array;
						}
						$hr_inc = 1;
						$setup_time = array();
						foreach($hr_set[$detail_info->processess] as $ket_v => $hr_setDetails){
						$hh = $hr_setDetails;	
						$mm = $mm_set[$detail_info->processess][$ket_v];	
						$ss = $sec_set[$detail_info->processess][$ket_v];
						//if($hr_inc == 1){
						$setup_time[] = timeToSeconds($hh.':'.$mm.':'.$ss);
						//}
						$hr_inc++;	}
						$mt_inc = 1;
						$machine_time = array();
						foreach($mt_hr_set[$detail_info->processess] as $ket_v => $mt_hr_setDetails){
						$hh = $mt_hr_setDetails;	
						$mm = $mt_mm_set[$detail_info->processess][$ket_v];	
						$ss = $mt_sec_set[$detail_info->processess][$ket_v];
						//if($mt_inc == 1){
						$machine_time[] = timeToSeconds($hh.':'.$mm.':'.$ss);
						//}
						$mt_inc++; 
						}
						$i = 1;
					   $chk = 0;
					  	foreach($output_process as $output_process_info){
					  	$material_id_output = $output_process_info['material_output_name'];
						$materialName_output = getNameById('material',$material_id_output,'id');
						$process_output_qty = $output_process_info['quantity_output'];
						$lot_qty = $jobCardData->lot_qty;
						$wo_qty = $product_Detail->transfer_quantity;
						?>
					  	
					  	<tr>
					  	<td><?php if($i == 1){ echo $processName->process_name; } ?> </td>
					  	<td><?php echo $materialName_output->material_name; ?></td>
					  	<td><?php echo $req_output = $wo_qty*$process_output_qty/$lot_qty; ?> </td>
					  	<td><?php
						$sum_com = 0;
						foreach ($production_data as $p_key => $data_val) {
						$decode_data = json_decode($data_val['production_data'], true);
						foreach ($decode_data as $key => $data_chk) {
						if(count($data_chk['output']) > 1){
						$icc = $ic;
						} else {
						$icc = 0;	
						}
						if($materialName->job_card == $data_chk['job_card_product_id'][$icc] && $detail_info->processess == $data_chk['process_name'][$icc]){
						$sum_com =  $data_chk['output'][$icc][$chk];
						// foreach ($data_chk['output'] as $key_ot => $value) {
						// $sum_com += $value[$chk];
						// }
						}
						}
						}
						if(empty($production_data)){ echo "0";} else {echo $sum_com;}
						?></td>
						<td><?php
						$sum_pp = 0;
						foreach ($production_planning as $p_key => $data_val) {
						$decode_data = json_decode($data_val['planning_data'], true);
						foreach ($decode_data as $key => $data_chk) {
						if(count($data_chk['output']) > 1){
						$icc = $ic;
						} else {
						$icc = 0;	
						}
						if($materialName->job_card == $data_chk['job_card_product_id'][$icc] && $detail_info->processess == $data_chk['process_name'][$icc]){
							//pre($data_chk['output']);
						$sum_pp =  $data_chk['output'][$icc][$chk];
						// foreach ($data_chk['output'] as $key_ot => $value) {
						// echo $value[$chk];
						// }
						}
						}
						}
						if(empty($production_planning)){ echo "0";} else {echo $sum_pp;}
						?></td>
						<td><?php echo $remain_qty = $req_output-$sum_com-$sum_pp; ?></td>
						<td><?php
						if($remain_qty == $req_output){
						$seconds =  $setup_time[0] + ($remain_qty/$process_output_qty*$machine_time[0]);
						echo sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60);
						} elseif($remain_qty < $req_output){
						$seconds = $remain_qty/$process_output_qty*$machine_time[0];
						echo sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60);
						} elseif($remain_qty <= 0){
						echo '00:00:00';
						}
						?></td>
						<td><?php echo $totalSalary; ?></td>
						<td><?php
						if($remain_qty == 0 || $sum_pp == 0){
						echo "Completed";
						} elseif($remain_qty ==$req_output){
						echo "Pending";
						} else {
						echo "In Progress";
						}

						?></td>
					   </tr>
					  	<?php $i++; $chk++;}  $ic++; }
					  	?>


					  </tbody>
					</table>

					<?php } ?>
				  <?php //} ?> 
			</div>
			 <div role="tabpanel" class="tab-pane fade" id="ViewRawMaterialIssued" aria-labelledby="">
         <?php  if($new_rmissue){ ?>
            <table id="" class="table table-bordered" data-id="" border="1" cellpadding="3">
               <thead>
                  <tr>
                     <th>Sr.no</th>             
                     <th>Product name</th>
                     <th>Product Type</th>
                     <th>Product Lot Number</th>
					 		<th>Required Quantity</th>
                     <th>Total Issued Quantity</th>
                     <th>Unit Price</th>
                     <th>Total Cost</th>
                  </tr>
               </thead>
               <?php  
                  if(!empty($new_rmissue)){
                     $i = 1;
                     $combindedTotalCost = 0;
                     $totalCombinedQuantity = 0;
                     $uomArray = array();
                     foreach($new_rmissue as $material_total_detail){ 
                        $materialName     = getNameById('material',$material_total_detail['material_id'],'id');
                        $productDetails   = getNameById('material_type',$material_total_detail['material_type_id'],'id');   
                        $newUomArray[]    = $material_total_detail['uom'];     
                        $totalCombinedQuantity += $material_total_detail['quantity'];	
                        $lot_details   = getNameById('lot_details',$material_total_detail['lot_id'],'id');      
               ?>		
               <tbody>
                  <tr>
                     <td><?php   echo $i;  ?></td>  
                     <td><?php   if(!empty($materialName)){echo $materialName->material_name;}else{echo "N/A";} ?></td>
                     <td><?php   if(!empty($productDetails)){ echo $productDetails->name; }else{echo "N/A";} ?></td>
                     <td><?php   if(!empty($lot_details)){ echo $lot_details->lot_number; }else{echo "N/A";} ?></td>
                     <td><?php   echo $material_total_detail['required_quantity'];  ?></td>
                     <td><?php   echo $material_total_detail['quantity'];  ?></td>
                     <td><?php   echo $lot_details->mou_price;  ?></td>   
                     <td><?php   $totalCostPrice =  ($lot_details->mou_price * $material_total_detail['quantity']);  
                                 $combindedTotalCost     += $totalCostPrice;
                                 echo $totalCostPrice;
                     ?></td>
                  </tr>
                  <?php $i++; } 
                        $uomStatus = '2';
                        if(count(array_unique($newUomArray)) == 1){
                           $uomStatus = '1';
                        }
                  
                  ?>
               </tbody>
               <tfoot>
                  <tr>
                     <td><strong>Total</strong></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td>
                     <?php  if($uomStatus == 1) { ?>
                           <strong><?php echo $totalCombinedQuantity;  ?></strong>
                        <?php } else { ?>
                           <button style="color:#fff;" type="buttton" class="btn btn-info productionTab addBtn" id="<?php if(!empty($work_order)){ echo $work_order->id; } else {  echo '';  }  ?>" data-toggle="modal" data-id="RawMaterialReportQty">View Total Qty</button>
                        <?php } ?> 
                     </td>
                     <td></td>
                     <td><strong><?php echo $combindedTotalCost;  ?></strong></td>
                  </tr>
               </tfoot>
               <?php } ?>
            </table>
         <?php } ?>
         <?php /* 
         if(!empty($material_issue_report)){ ?>
               <table id="" class="table table-bordered" data-id="" border="1" cellpadding="3">
                  <thead>
                     <tr>
                        <th>Sr.no</th>
                        <th>Date</th>                
                        <th>Product name</th>
                        <th>Product Type</th>
                        <th>Product Lot Number</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Cost</th>
                     </tr>
                  </thead>
                  <?php 
                     if(!empty($material_issue_report)){
                        $i = 1;
                        $totalQuantity = 0;
                        $totalCost = 0;
                        $uomArray = array();
                        foreach($material_issue_report as $material_wise_detail){ 
                           $materialName = getNameById('material',$material_wise_detail['material_id'],'id');
                           $productDetails = getNameById('material_type',$material_wise_detail['material_type_id'],'id');  
                           $totalQuantity += $material_wise_detail['quantity'];
                           $newUomArray[]    = $material_wise_detail['uom'];  
                     ?>		
                  <tbody>
                     <tr>
                        <td><?php   echo $i;  ?></td>  
                        <td><?php   echo $material_wise_detail['date'];  ?></td>   
                        <td><?php   if(!empty($materialName)){echo $materialName->material_name;}else{echo "N/A";} ?></td>
                        <td><?php   if(!empty($productDetails)){ echo $productDetails->name; }else{echo "N/A";} ?></td>
                        <td><?php   echo $material_wise_detail['lot_number'];  ?></td>
                        <td><?php   echo $material_wise_detail['quantity'];  ?></td>
                        <td><?php   echo $material_wise_detail['unit_price'];  ?></td>   
                        <td><?php   $costPrice =  ($material_wise_detail['unit_price'] * $material_wise_detail['quantity']);  
                                    $totalCost     += $costPrice; 
                                    echo $costPrice;
                        ?></td>
                     </tr>
                     <?php $i++; } 
                        $uomStatus = '2';
                        if(count(array_unique($newUomArray)) == 1){
                           $uomStatus = '1';
                        }
                     ?>
                  </tbody>
                  <tfoot>
                     <tr>
                        <td><strong>Total</strong></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                        <?php  if($uomStatus == 1) { ?>
                           <strong><?php echo $totalQuantity;  ?></strong>
                        <?php } else { ?>
                           <button style="color:#fff;" type="buttton" class="btn btn-info productionTab addBtn" id="<?php if(!empty($work_order)){ echo $work_order->id; } else {  echo '';  }  ?>" data-toggle="modal" data-id="RawMaterialReportQty">View Total Qty</button>
                        <?php } ?>  
                        </td>
                        <td></td>
                        <td><strong><?php echo $totalCost;  ?></strong></td>
                     </tr>
                  </tfoot>
                  <?php } ?>
               </table>
              <?php } else { ?>
                  <p>No Data Found.</p>
              <?php } */ ?> 
         </div>
      
			<div role="tabpanel" class="tab-pane fade" id="ViewBomScrapDetails" aria-labelledby="">
            <?php if(!empty($scrap_data_report)){ ?>
               <table id="" class="table table-bordered" data-id="" border="1" cellpadding="3">
                  <thead>
                     <tr>
                        <th>Sr.no</th>
                        <th>Product Type</th>
                        <th>Product Name</th>
                        <?php /*<th>Expected Scrap Quantity</th> */ ?>
                        <th>Actual Scrap Quantity</th>
                        <th>UOM</th>
                     </tr>
                  </thead>
                  <?php 
                     if(!empty($scrap_data_report)){
                        $i = 1;
                        foreach($scrap_data_report as $scrap_report){ 
                           $materialName     = getNameById('material',$scrap_report['material_name_id'],'id');
                           $productDetails   = getNameById('material_type',$scrap_report['material_type_id'],'id');   
                           $uomname          = getNameById('uom',$scrap_report['unit'],'id');
                     ?>		
                  <tbody>
                     <tr>
                        <td><?php echo $i;  ?></td>   
                        
                        <td data-material-id="<?php echo $scrap_report['material_name_id'];  ?>"><?php   if(!empty($productDetails)){ echo $productDetails->name; }else{echo "N/A";} ?></td>
                        <td><?php   if(!empty($materialName)){echo $materialName->material_name;}else{echo "N/A";} ?></td>
                        <td><?php echo $scrap_report['quantity']; ?></td>
                        <?php /*<td><?php echo $scrap_report['actual_scrap_quantity']; ?></td> */?>
                        <td><?php echo $uomname->uom_quantity; ?></td>
                     </tr>
                     <?php $i++; } ?>
                  </tbody>
                  <?php } ?>
               </table>
              <?php } else { ?>
                  <p>No Data Found.</p>
              <?php } ?> 
         </div>
      </div>      
   </div>
</div>  
<div id="work_order_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close workOrderModal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Raw Material Quantity Details</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>	
