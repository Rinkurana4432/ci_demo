<table class="table table-bordered" style="width:100%" id="print_divv" border="1" cellpadding="2">
    <thead>				
		<tbody>
		<tr>
		   <th>Date:</th>
		   <th><?php if(!empty($productionView)){ echo date("j F , Y", strtotime($productionView->date)); } ?></th>
		</tr>
		<tr>
			<th>Production Details:</th>
			<th>
				<table class="fixed data table table-bordered no-margin" style="width:100%" border="1" cellpadding="2">
				<thead>
					<tr>
						<th>Machine Name</th>
						<th>Job card Product Name</th>
						<th>Worker</th>
						<th>Material Consumed</th>
						<th>Wastage</th>
						<th>Output</th>
						<th>Electricity</th>
						<th>Costing</th>
						<th>Labour Costing</th>
						<th>Remarks</th>
					</tr>
				</thead>		
				<tbody>
					<?php 
					if(!empty($productionView) && $productionView->production_data !=''){
						$production_Data =  json_decode($productionView->production_data);
						$OverallmaterialconsumedTotal = $OveralloutputTotal = $OverallwastageTotal = $OverallelectricityTotal = $OverallcostingTotal = $OverallLabourCostingTotal = 0;
						$workerArray = array();
						$unique_machine_grpArray= array();
						foreach($production_Data as  $productionData){							
							$OverallmaterialconsumedTotal += $productionData->material_consumed!=""?$productionData->material_consumed:0;
							$OveralloutputTotal += $productionData->output!=""?$productionData->output:0;
							$OverallwastageTotal +=  $productionData->wastage!=""?$productionData->wastage:0;
							$OverallelectricityTotal += (int)$productionData->electricity !="" ?$productionData->electricity:0;
							//$OverallelectricityTotal += ($productionData->electricity !="" && gettype($productionData->electricity) != 'string')?$productionData->electricity:0;
							$OverallcostingTotal += $productionData->costing!=""?$productionData->costing:0;
							$OverallLabourCostingTotal += $productionData->labour_costing!=""?$productionData->labour_costing:0;
							$convertToArray = array ($productionData);
							//get unique machine group id
							$uniqueMachineGroupId = array_unique(array_map(function ($i) { return isset($i->machine_grp)?$i->machine_grp:''; }, $convertToArray));
							$unique_machine_grpArray[] = $uniqueMachineGroupId[0];	
						}						
						$unique_mach_grp =  array_unique($unique_machine_grpArray);
						foreach($unique_mach_grp as $machine_grp_id){
							$materialconsumedTotal = $outputTotal = $wastageTotal = $electricityTotal = $costingTotal = 0;$totalWorkers = $labourCostingTotal= 0;
							foreach($production_Data as $productionData){
								
								
								$machineName = getNameById('add_machine',$productionData->machine_name_id,'id');
								$jobCard = getNameById('job_card',$productionData->job_card_product_id,'id');
								if(isset($productionData->machine_grp) && $machine_grp_id == $productionData->machine_grp){?>
								<tr>
									<td><?php  echo !empty($machineName)?$machineName->machine_name:''; ?><br /></td>
									<td><?php if(!empty($jobCard)){ echo $jobCard->job_card_product_name; }?></td>
									<td>
									<?php 
									$workerArray[] = $productionData->worker_id;
									$workerid = $productionData->worker_id;
										if(!empty($workerid)){
											$workerName = ''; 
										 foreach($workerid as $work){
											if (is_numeric($work)){
												$worker_name = getNameById('worker',$work,'id'); 
												if(!empty($worker_name)){
													$workerName .= $worker_name->name.',';
												}
											}else{
											   $workerName .= $work.',';
											}
										 }
										echo rtrim($workerName, ',');		
									}
									?>
									</td>
									<td><?php echo $productionData->material_consumed;?><br /></td>
									<td><?php echo $productionData->wastage;?><br /></td>
									<td><?php echo $productionData->output;?><br /></td>
									<td><?php echo $productionData->electricity;?><br /></td>
									<td><?php echo $productionData->costing;?><br /></td>
									<td><?php echo $productionData->labour_costing;?><br /></td>
									<td><?php echo $productionData->remarks;?><br /></td>
								</tr>	
								<?php 
									$materialconsumedTotal += $productionData->material_consumed!=""?$productionData->material_consumed:0;
									$outputTotal += $productionData->output!=""?$productionData->output:0;
									$wastageTotal +=  $productionData->wastage!=""?$productionData->wastage:0;
									//$electricityTotal += ($productionData->electricity!="" && gettype($productionData->electricity) !='string')?$productionData->electricity:0;
									$electricityTotal += (int)$productionData->electricity!=""?$productionData->electricity:0;
									//pre($electricityTotal);
									$costingTotal += $productionData->costing!=""?$productionData->costing:0;
									$labourCostingTotal += $productionData->labour_costing!=""?$productionData->labour_costing:0;
									
								}
								//code to get only unique name count 
								$mergeWorkerArray = [];    //megring multidimensional array
									if(!empty($workerArray)){
										foreach ($workerArray as $worker_array) {
											if(!empty($worker_array)){												
												foreach ($worker_array as $worker) { 
												//pre($worker);
												$mergeWorkerArray[] = $worker; 
												} 
											} 
										}
									}
									
									$totalWorkers = count(array_unique($mergeWorkerArray));
							}
													
							?>
								<tr style="background-color:#DCDCDC; font-size:19px;"><th colspan="2">Total</th>
								<th><?php //echo $totalWorkers; ?></th>	
								<th><?php echo $materialconsumedTotal; ?></th>
								<th><?php echo $wastageTotal; ?></th>
								<th><?php echo $outputTotal; ?></th>
								
								<th><?php echo $electricityTotal; ?></th>
								<th><?php echo $costingTotal; ?></th>
								<th><?php echo $labourCostingTotal; ?></th>
								<th></th></tr>
							<?php 	}	
						}
						?>
						<tr>
							<th colspan="2">OverAll Total</th>
							<th><?php echo $totalWorkers; ?></th>
							<th><?php echo $OverallmaterialconsumedTotal; ?></th>
							<th><?php echo $OverallwastageTotal; ?></th>
							<th><?php echo $OveralloutputTotal; ?></th>
							
							<th><?php echo $OverallelectricityTotal; ?></th>
							<th><?php echo $OverallcostingTotal; ?></th>
							<th><?php echo $OverallLabourCostingTotal; ?></th>
							<th></th>
						</tr>
				</tbody>
				</table>
				<!--<table class="fixed data table table-bordered no-margin" style="width:100%" border="1" cellpadding="2">
					<tr>
					<th>Total Workers</th>
					<th><?php //echo $totalWorkers; ?></th>
					</tr>
				</table>-->
			</th>
			
		</tr>
			
		</tbody>
	</thead>		
</table>


<center>
	<button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
	
</center>