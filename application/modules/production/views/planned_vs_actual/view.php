<?php #pre($productionView); ?>
<div  style="width:100%" id="" border="1" cellpadding="2">
<thead>				
<div class="col-md-3 col-xs-12">		   
<div class="grand-tota2" style="border:0px;">Date:&nbsp;&nbsp;<?php if(!empty($productionView)){ echo date("j F , Y", strtotime($productionView->date)); } ?></div>
</div>
<tr>
<h3 class="Material-head">Actual VS Target Report<hr></h3>
<div class="col-md-12 col-xs-12 col-sm-12" id="chkIndex_1" style="padding:0px; border-top:0px;">
	<table  class="table table-bordered" data-id="user" border="1" cellpadding="3">	
		<?php 			
		#pre($productionView);	
		if($productionView->production_data != ''){
			$productionWagesData = json_decode($productionView->production_data);
			$OveralloutputTotal = $OverallLaborcostingTotal = 0;
			$unique_machine_grpArray= array();
			foreach($productionWagesData as $pwd){
				//pre($pwd);
					$wagesLength = !empty($pwd->machine_name_id)?(count($pwd->machine_name_id)):0;
					for($k=0;$k<$wagesLength;$k++){
						$OveralloutputTotal += $pwd->output[$k]!=""?(int)$pwd->output[$k]:0;
						$OverallLaborcostingTotal += $pwd->labour_costing[$k]!=""? (int)$pwd->labour_costing[$k]:0;	
					}	
					
					$machinegrpId = $pwd->machine_grp;
					$unique_machine_grpArray[] = $machinegrpId[0];	
			}
			$production_planning = getNameById('production_planning', $productionView->planning_id, 'id');
			$target_data= !empty($production_planning->planning_data) ? json_decode($production_planning->planning_data) : "";
			#pre($target_data);
			$unique_mach_grp =  array_unique($unique_machine_grpArray);
			//pre($unique_mach_grp);
			$z=0;
				foreach($unique_mach_grp as $machine_grp_id){
					echo '<div class="Process-card">
				         	<!--<h3 class="Material-head">Porduction Details<hr></h3>-->							  
				<div class="label-box mobile-view3">
						<!-- Start 04-03-2022 -->			  
					   <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1; display:none"><label>Wages/Per piece</label></div>
					   <!-- End 04-03-2022 -->
					   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Machine Name</label></div>
					   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Work Order Name</label></div>
					   <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="display: none;"><label>Sale Order</label></div>
					   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Product Name</label></div>
					   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Process Name</label></div>
					   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>BOM Routing Product</label></div>
					   <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="display: none"><label>Workers</label></div>
					   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Planning Output</label></div>
					   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Production Output</label></div>  
					   <!-- Start 04-03-2022 --> 
					   <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="display: none;"><label>Labour costing</label></div>
					   <!-- End 04-03-2022 -->
					   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Remarks</label></div>
				</div>';
				/* Start 07-03-2022 */
					$planingTotalOutPut = 0;
				/* End 07-03-2022 */								
					$outputTotal= $laborcostingTotal = $TargetOutputsum = 0;
					$z=0;
					foreach($productionWagesData as $pwd){
						//pre($pwd);
						
						if(!empty($pwd)){
							$wagesLength = !empty($pwd->machine_name_id)?(count($pwd->machine_name_id)):0;
								for($i=0;$i<$wagesLength;$i++){
									$machinegrp = isset($pwd->machine_grp[0])?$pwd->machine_grp[0]:'';
									//pre($machinegrp);
									$machine_id = isset($pwd->machine_name_id[$i])?$pwd->machine_name_id[$i]:'';
									$machineData = ($machine_id!='' || $machine_id!=0)?getNameById('add_machine',$machine_id,'id'):array();
									$jobCard = isset($pwd->job_card_product_id[$i])?getNameById('job_card',$pwd->job_card_product_id[$i],'id'):array();  
									if(array_key_exists("machine_grp",$pwd) && $machine_grp_id == $machinegrp){	
									
									$saleOrder = isset($pwd->sale_order[$i])?getNameById('sale_order',$pwd->sale_order[$i],'id'):array();  
									/* Start 04-03-2022*/
									/* Work Order name */
									$workOrderName = isset($pwd->work_order[$i])?$pwd->work_order[$i]:'';
									$wrkOdrNme = ($workOrderName!='' || $workOrderName!=0)?getNameById('work_order',$workOrderName,'id'):array();
									//echo !empty($wrkOdrNme)?$wrkOdrNme->workorder_name:'';
									$workOrderProductName = json_decode($wrkOdrNme->product_detail);
									/* Product Name */
									$wrkPrdctName = '';
									foreach($workOrderProductName as $productName){
										$prductName = getNameById('material',$productName->product,'id');
										$wrkPrdctName = $prductName->material_name;
									}
									/* Process name */
									$processName = isset($pwd->process_name[$i])?$pwd->process_name[$i]:'';
									$procsNme = ($processName!='' || $processName!=0)?getNameById('add_process',$processName,'id'):array();
									//echo !empty($procsNme)?$procsNme->process_name:'';

									/* End 04-03-2022 */  




									echo '<!-- Start 04-03-2022 --><div class="row-padding col-container mobile-view view-page-mobile-view" ><div class="col-md-1 col-sm-12 col-xs-12 form-group col" style="border-left: 1px solid #c1c1c1 !important; display:none;"><label>Wages/Per piece</label><div>'.$pwd->wages_or_per_piece[$i] .'</div></div> <!-- End 04-03-2022 -->';
									
									echo '<div class="col-md-1 col-sm-12 col-xs-12 form-group col"><label>Machine Name</label><div>'. ((!empty($machineData))?($machineData->machine_name):'') .'</div></div>';
									/* Start 04-03-2022 Work Order Name */
									echo '<div class="col-md-2 col-sm-12 col-xs-12 form-group col"><label>Work Order Name</label><div>'. ((!empty($wrkOdrNme))?($wrkOdrNme->workorder_name):'') .'</div></div>';
									/* End 04-03-2022 Work Order Name */
									
									echo '<div class="col-md-1 col-sm-12 col-xs-12 form-group col" style="display: none"><label>Sale order</label><div>'. ((!empty($saleOrder))?($saleOrder->so_order):'') .'</div></div>';
									/* Start 04-03-2022 Product Name */
									echo '<div class="col-md-1 col-sm-12 col-xs-12 form-group col"><label>Product Name</label><div>'. ((!empty($wrkPrdctName))?($wrkPrdctName):'') .'</div></div>';
									/* End 04-03-2022 Product Name */
									/* Start 04-03-2022 Process Name */
									echo '<div class="col-md-1 col-sm-12 col-xs-12 form-group col"><label>Process Name</label><div>'. ((!empty($procsNme))?($procsNme->process_name):'') .'</div></div>';
									/* End 04-03-2022 Process Name */
									echo '<div class="col-md-3 col-sm-12 col-xs-12 form-group col"><label>BOM Routing Product</label><div>'. ((!empty($jobCard))?($jobCard->job_card_product_name):'') .'</div></div>'; ?>
									<div class="col-md-3 col-sm-12 col-xs-12 form-group col" style="display: none;">
									    <label>Workers</label>
										<?php $workerName_id[$i] = isset($pwd->worker_id[$i])?($pwd->worker_id[$i]):'';
										$workerArray[] =  isset($pwd->worker_id[$i])?($pwd->worker_id[$i]):'';
										$salaryArray[] = isset($pwd->totalsalary[$i])?($pwd->totalsalary[$i]):'';													
											if(!empty($workerName_id[$i])){
												echo '<div class="label-box ineer-table">
															<div class="col-md-4 col-sm-12 col-xs-12 form-group"><label style="border-left:1px solid #c1c1c1 !important;">Worker</label></div>
															<div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Hours/percentage</label></div>
															<div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>total Salary</label></div>
															</div>';															
												for($j=0;$j< count($workerName_id[$i]);$j++){
													echo '<div class="row-padding ineer-row"><div class="col-md-4 col-sm-12 col-xs-12 abc" style="border-left:1px solid #c1c1c1 !important; padding: 6px 12px !important;">
		                                                  <div  >';
													$Workername = getNameById('worker',$workerName_id[$i][$j],'id');
													echo $Workername->name;
													echo '</div></div>';
													echo ' <div class="col-md-4 col-sm-12 col-xs-12 abc" style="padding: 6px 12px !important;">
		                                                   <div >'.$pwd->working_hrs[$i][$j].'</div></div>';
													echo ' <div class="col-md-4 col-sm-12 col-xs-12 abc" style="padding: 6px 12px !important;">
		                                                   <div>'.$pwd->totalsalary[$i][$j].'</div></div>';			   
												    echo "</div>";
												}		
											}  
										?>
									</div>
	                             <?php //echo $target_data[$z]->output[$i][0]; ?>
										<div class="col-md-3 col-sm-12 col-xs-12 form-group col" ><label>Planning Output</label><div>
										<!-- Start 04-03-2022 Planing Output -->	
										<div class="rTableCell">
										<?php 
											$targetMaterialName = getNameById('material',$target_data[$z]->product_name[$i],'id');
										?>
										<input style="width:70%; float:left;" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo isset( $targetMaterialName) ?  $targetMaterialName->material_name : 0; ?>" readonly="">
										<span style="width:30%; float:right;" class="form-control col-md-7 col-xs-12"><?php  echo isset( $target_data[$z]->output[$i][0]) ?  $target_data[$z]->output[$i][0] : 0;?></span>
										</div>
										<!-- End 04-03-2022 Planing Output -->
										</div>
									</div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group col" ><label>Production Output</label><div class="rTableCell">
									<!-- Start 04-03-2022 Production Data -->
									<?php
										//pre($prodplanData);
										$jobCardData = isset($pwd->job_card_product_id[$i])?(getNameById('job_card',$pwd->job_card_product_id[$i],'id')):'';
										
										$machine_details = json_decode($jobCardData->machine_details);
										$process = isset($pwd->process_name[$i])?getNameById('add_process',$pwd->process_name[$i],'id'):'';
										if($process->id != 0){
										$key = array_search($process->id, array_column($machine_details, 'processess'));
										if($key === 0 || $key >= 1){
										$detail_info = $machine_details[$key];
										$output_process_dtl = (!empty($detail_info->output_process) && isset($detail_info->output_process))?$detail_info->output_process:'';
										$process_sch_output = json_decode($output_process_dtl);
										}
										}
										$out = 0;
										foreach($process_sch_output as $val_output_sech){
										$material_id_output = $val_output_sech->material_output_name;
										$materialName_output = getNameById('material',$material_id_output,'id');
										#pre( $materialName_output);
										?>
										<input style="width:60%; float:left;" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $materialName_output->material_name; ?>" readonly="">
										<?php $out++; } ?>
                                        <input style="width:40%; float:left;" id="output" class="form-control col-md-7 col-xs-12 output" name="" placeholder="output"  type="text" value="<?php if(isset($pwd->output[$i][0])) echo $pwd->output[$i][0];?>">
										</div>
	  								<!-- End 04-03-2022 Production Data -->
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group col"  style="display:none"><label>Labour costing</label><div><?php if(!empty($pwd) && isset($pwd->labour_costing[$i])) echo (round($pwd->labour_costing[$i],2));?></div></div>
									<div class="col-md-1 col-sm-12 col-xs-12 form-group col" ><label>Remarks</label><div><?php  if(isset($pwd->remarks[$i])) echo $pwd->remarks[$i];?></div></div>
									</div><?php 
									$outputTotal += $pwd->output[$i]!=""? (int)$pwd->output[$i]:0;
									$laborcostingTotal += $pwd->labour_costing[$i]!=""?(int)$pwd->labour_costing[$i]:0;
								    $TargetOutputsum += isset($target_data[$z]->output[$i]) ? (int)$target_data[$z]->output[$i] : 0;
									}
									/* Start 07-03-2022 */
									$plngOutPut = !empty($target_data[$z]->output[$i])?(count($target_data[$z]->output[$i])):0;
										for($l=0;$l<$plngOutPut;$l++){
											$planingTotalOutPut += $target_data[$z]->output[$i]!=""?(int)$target_data[$z]->output[$i] : 0;
										}
									/* End 07-03-2022 */
									
									/*******************calculate total worker **********************/
									$mergeWorkerArray = [];    //megring multidimensional array
									if(!empty($workerArray)){
										
										foreach ($workerArray as $worker_array) {
											
											if(!empty($worker_array)){	
												if(gettype($worker_array) == 'string'){
													$worker_array = array($worker_array);
												}											
												foreach ($worker_array as $worker) { 
													$mergeWorkerArray[] = $worker; 
												} 
											} 
										
										}
									}
									$totalWorkers = count(array_unique($mergeWorkerArray));
									
									
									/*****************caluclate total salary ********************/
									$totalSalary = 0;
									$mergeSalaryArray = [];    //megring multidimensional array
									if(!empty($salaryArray)){
										foreach ($salaryArray as $salary_Array) {
											
											if(!empty($salary_Array)){	
												foreach ($salary_Array as $salaryTotal) { 
													$totalSalary += (float)($salaryTotal);  //$salaryTotal; 
												}
											}
										}
									}
									/****************end**************************************/
								}		
						} $z++;
					} ?>
					<div class="row-padding col-container mobile-view view-page-mobile-view total-main"><div class="col-md-1 col-sm-12 col-xs-12 form-group total-text col" >Total</div>
					<div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
					<div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
					<div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
					<div class="col-md-3 col-sm-12 col-xs-12 form-group col"></div>
					<div class="col-md-1 col-sm-12 col-xs-12 form-group total-number col" ><?php echo $TargetOutputsum ; ?></div>
					<div class="col-md-1 col-sm-12 col-xs-12 form-group total-number col" ><?php echo $outputTotal; ?></div>
					<div class="col-md-2 col-sm-12 col-xs-12 form-group total-number col" ><?php //echo round($laborcostingTotal,2); ?></div>
					<div class="col-md-1 col-sm-12 col-xs-12 form-group  col" ></div>
					</div>
					
					</div>
				<?php }
					
					
					
		}
		
		?>
		
		<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
       

		<div class="col-md-4 col-sm-5 col-xs-12 text-right grand-total3" style="float: right;">
			
		<div class="col-md-12 col-sm-5 col-xs-12 text-right">
			
			<div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2">
			<div class="col-md-12 col-sm-5 col-xs-6 form-group">
				OverAll Total 
				</div>
				
			</div>
			<div class="col-md-6 col-sm-5 col-xs-6 ">
				Worker &nbsp;:
				</div>
		    <div class="col-md-6 text-left"><?php echo $totalWorkers; ?></div>
              
            <div class="col-md-6 col-sm-5 col-xs-6 ">
				Total Salary &nbsp;:
				</div>
		    <div class="col-md-6 text-left"><?php echo $totalSalary;  ?></div>	
			<!-- Start 04-03-2022 -->
            <div class="col-md-6 col-sm-5 col-xs-6 " style="display:none">
				Labour Costing &nbsp;:
				</div>
			<!-- End 04-03-2022 -->
			<!-- Start 07-03-2022 -->
		    <div class="col-md-6 text-left" style="display:none"><?php //echo (round($OverallLaborcostingTotal,2)); ?></div> 
			<!-- End 07-03-2022 -->   
            <div class="col-md-6 col-sm-5 col-xs-6 ">
				Production Output &nbsp;:
				</div>
             <div class="col-md-6 text-left"><?php echo $OveralloutputTotal; ?></div>							
				<div class="col-md-6 col-sm-5 col-xs-6 ">
				Planning Output &nbsp;:
				</div>
			<!-- Start 07-03-2022 -->
		    <div class="col-md-6 text-left"><?php echo $planingTotalOutPut; ?></div>
			<!-- End 07-03-2022 -->
        <div class="col-md-6 col-sm-5 col-xs-6 ">
				Output Percentage &nbsp;:
				</div>
		    <div class="col-md-6 text-left"><?php 
				$TargetOutputsum = ($TargetOutputsum == 0) ? 100 : $TargetOutputsum;
				$percentage = ($OveralloutputTotal/$TargetOutputsum)*100;
			echo (round($percentage,2)); ?> %</div>						
				 
			
         
		</div>
			
		</div>
		
		
	</table>
</div>
</tr>
</tbody>
</thead>		
</div>






<!---<table class="table table-bordered" style="width:100%" id="print_divv" border="1" cellpadding="2">
<thead>				
<tbody>
<tr>
<th>Date:</th>
<th></?php if(!empty($productionView)){ echo date("j F , Y", strtotime($productionView->date)); } ?></th>
</tr>
<tr>
<th>Production Details:</th>
<th>
	<table  class="table table-bordered" data-id="user" border="1" cellpadding="3">								
		<thead>								
			<tr>		
				<th style="display: none;">Wages/Per piece</th>					
				<th>Machine</th>					
				<th>Job card Product</th>					
				<th>Workers</th>
				<th>Production Output</th>
				<th style="display: none;">Labour costing</th>
				<th>Remarks</th>
			</tr>
		</thead>								
		</?php 
	
		if($productionView->production_data != ''){
			$productionWagesData = json_decode($productionView->production_data);
			$OveralloutputTotal = $OverallLaborcostingTotal = 0;
			$unique_machine_grpArray= array();
			foreach($productionWagesData as $pwd){
				$wagesLength = !empty($pwd->wages_or_per_piece)?(count($pwd->wages_or_per_piece)):0;
					for($k=0;$k<$wagesLength;$k++){
						$OveralloutputTotal += $pwd->output[$k]!=""?$pwd->output[$k]:0;
						$OverallLaborcostingTotal += $pwd->labour_costing[$k]!=""?$pwd->labour_costing[$k]:0;	
					}
					
				$machinegrpId = $pwd->machine_grp;
				$unique_machine_grpArray[] = $machinegrpId[0];
				/*if(!empty($pwd->output)){
					foreach($pwd->output as $outputValue){								
						$OveralloutputTotal += $outputValue!=""?$outputValue:0;	
					}
				}
				foreach($pwd->labour_costing as $labourCostingValue){
					
						$OverallLaborcostingTotal += $labourCostingValue!=""?$labourCostingValue:0;
					
					}
				$convertToArray = array ($pwd);
				//get unique machine group id							
				$uniqueMachineGroupId = array_unique(array_map(function ($m) { return isset($m->machine_grp)?$m->machine_grp:''; }, $convertToArray));
					foreach($uniqueMachineGroupId as $machine_grp_id){
						$unique_machine_grpArray[] = $machine_grp_id[0];	
					}
					*/
				
			}
			$unique_mach_grp =  array_unique($unique_machine_grpArray);
			//pre($unique_mach_grp);
				foreach($unique_mach_grp as $machine_grp_id){
					$outputTotal= $laborcostingTotal = 0;
					foreach($productionWagesData as $pwd){	
						if(!empty($pwd)){
							$wagesLength = !empty($pwd->wages_or_per_piece)?(count($pwd->wages_or_per_piece)):0;
								for($i=0;$i<$wagesLength;$i++){
									$machinegrp = isset($pwd->machine_grp[0])?$pwd->machine_grp[0]:'';
									//pre($machinegrp);
									$machine_id = isset($pwd->machine_name_id[$i])?$pwd->machine_name_id[$i]:'';
									$machineData = ($machine_id!='' || $machine_id!=0)?getNameById('add_machine',$machine_id,'id'):array();
									$jobCard = isset($pwd->party_code[$i])?getNameById('job_card',$pwd->party_code[$i],'id'):array();  
									if(array_key_exists("machine_grp",$pwd) && $machine_grp_id == $machinegrp){	
										
									echo '<tr><td>'.$pwd->wages_or_per_piece[$i] .'</td>';
									
									echo '<td>'. ((!empty($machineData))?($machineData->machine_name):'') .'</td>';
									
									echo '<td>'. ((!empty($jobCard))?($jobCard->job_card_product_name):'') .'</td>'; ?>
									<td>
										</?php $workerName_id[$i] = isset($pwd->worker_id[$i])?($pwd->worker_id[$i]):'';
										$workerArray[] =  isset($pwd->worker_id[$i])?($pwd->worker_id[$i]):'';
										$salaryArray[] = isset($pwd->totalsalary[$i])?($pwd->totalsalary[$i]):'';
										
											if(!empty($workerName_id[$i])){
												echo '<table class="table table-bordered"><thead><tr><td>Worker</td><td>Hours/percentage</td><td>total Salary</td></tr></thead><tbody>';
												
												for($j=0;$j< count($workerName_id[$i]);$j++){
													echo '<tr><td>';
													$Workername = getNameById('worker',$workerName_id[$i][$j],'id');
													echo $Workername->name;
													echo '</td>';
													echo '<td>'.$pwd->working_hrs[$i][$j].'</td>';
													echo '<td>'.$pwd->totalsalary[$i][$j].'</td>';
												}											
												echo "</tr></tbody></table>";
												
												
											}  
										?> 
									</td>
									<td></?php if(isset($pwd->output[$i])) echo $pwd->output[$i];?></td>
									<td></?php if(!empty($pwd) && isset($pwd->labour_costing[$i])) echo (round($pwd->labour_costing[$i],2));?></td>
									<td></?php  if(isset($pwd->remarks[$i])) echo $pwd->remarks[$i];?></td>
									</tr></?php 
									$outputTotal += $pwd->output[$i]!=""?$pwd->output[$i]:0;
									$laborcostingTotal += $pwd->labour_costing[$i]!=""?$pwd->labour_costing[$i]:0;	
									}
									
									/*******************calculate total worker **********************/
									$mergeWorkerArray = [];    //megring multidimensional array
									if(!empty($workerArray)){
										
										foreach ($workerArray as $worker_array) {
											
											if(!empty($worker_array)){	
												if(gettype($worker_array) == 'string'){
													$worker_array = array($worker_array);
												}											
												foreach ($worker_array as $worker) { 
													$mergeWorkerArray[] = $worker; 
												} 
											} 
										
										}
									}
									$totalWorkers = count(array_unique($mergeWorkerArray));
									
									
									/*****************caluclate total salary ********************/
									$totalSalary = 0;
									$mergeSalaryArray = [];    //megring multidimensional array
									if(!empty($salaryArray)){
										foreach ($salaryArray as $salary_Array) {
											
											if(!empty($salary_Array)){	
												foreach ($salary_Array as $salaryTotal) { 
													$totalSalary += (float)($salaryTotal);  //$salaryTotal; 
												}
											}
										}
									}
									/****************end**************************************/
								}		
						}
					} ?>
					<tr style="background-color:#DCDCDC; font-size:19px;"><th colspan="4">Total</th>
					
					<th></?php echo $outputTotal; ?></th>
					<th></?php echo round($laborcostingTotal,2); ?></th>
					<th></th>
				</?php }
					
					
					
		}
		
		?><tr>
				<th colspan="3">OverAll Total</th>
				<th><table class="table table-bordered" data-id="user" border="1" cellpadding="3"><tr><td></?php echo $totalWorkers; ?></td><td></td><td></?php echo $totalSalary;  ?></td></tr></table></th>
				
				<th></?php echo $OveralloutputTotal; ?></th>
				<th></?php echo (round($OverallLaborcostingTotal,2)); ?></th>
				<th></th>
				
				
				
			</tr>
	</table>
</th>
</tr>
</tbody>
</thead>		
</table>-->


<center>
<button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>

</center>

<style>
.discls{
display: none;
}
@media print(){
.discls{
display:block
}
}

</style>
<?php #pre($productionView); ?>
<div  class="discls" style="width:100%" id="print_divv" border="1" cellpadding="2">

<div class="col-md-3 col-xs-12">		   
<div class="" style="border:0px;">Date:&nbsp;&nbsp;<h4><?php if(!empty($productionView)){ echo date("j F , Y", strtotime($productionView->date)); } ?></h4></div>
</div>

<h3 class="Material-head">Actual VS Target Report<hr></h3>
<div class="col-md-12 col-xs-12 col-sm-12" id="chkIndex_1" style="padding:0px; border-top:0px;">
<?php 			
		#pre($productionView);	
		if($productionView->production_data != ''){
			$productionWagesData = json_decode($productionView->production_data);
			$OveralloutputTotal = $OverallLaborcostingTotal = 0;
			$unique_machine_grpArray= array();
		
			foreach($productionWagesData as $pwd){
				#pre($pwd);
					$wagesLength = !empty($pwd->machine_name_id)?(count($pwd->machine_name_id)):0;
					for($k=0;$k<$wagesLength;$k++){
						$OveralloutputTotal += $pwd->output[$k]!=""?(int)$pwd->output[$k]:0;
						$OverallLaborcostingTotal += $pwd->labour_costing[$k]!=""? (int)$pwd->labour_costing[$k]:0;	
					}	
					
					$machinegrpId = $pwd->machine_grp;
					$unique_machine_grpArray[] = $machinegrpId[0];	
					
			}
			$production_planning = getNameById('production_planning', $productionView->planning_id, 'id');
			$target_data= !empty($production_planning->planning_data) ? json_decode($production_planning->planning_data) : "";
			#pre($target_data);
			
			
			$unique_mach_grp =  array_unique($unique_machine_grpArray);
			//pre($unique_mach_grp);
			$z=0;
			
				foreach($unique_mach_grp as $machine_grp_id){
					/* Start 07-03-2022 */
					$planingTotalOutPut = 0;
				/* End 07-03-2022 */								
					?>

	<table  class="table table-bordered" data-id="user" border="1" cellpadding="3" >	

        <thead>
		<tr>
			<th class="">Machine Name</th>
			<th class="">Work Order Name</th>
			<th class="">Product Name</th>
			<th class="">Process Name</th>
			<th class="">BOM Routing Product</th>
			<th class="">Planning Output</th>
			<th class="">Production Output</th>  
			<th class="">Remarks</th>
		</tr>
		</thead>
		<tbody>
		<?php

$outputTotal= $laborcostingTotal = $TargetOutputsum = 0;
$z=0;
foreach($productionWagesData as $pwd){
#pre($pwd);

if(!empty($pwd)){
$wagesLength = !empty($pwd->machine_name_id)?(count($pwd->machine_name_id)):0;
for($i=0;$i<$wagesLength;$i++){
	$machinegrp = isset($pwd->machine_grp[0])?$pwd->machine_grp[0]:'';
	//pre($machinegrp);
	$machine_id = isset($pwd->machine_name_id[$i])?$pwd->machine_name_id[$i]:'';
	$machineData = ($machine_id!='' || $machine_id!=0)?getNameById('add_machine',$machine_id,'id'):array();
	$jobCard = isset($pwd->job_card_product_id[$i])?getNameById('job_card',$pwd->job_card_product_id[$i],'id'):array();  
	if(array_key_exists("machine_grp",$pwd) && $machine_grp_id == $machinegrp){	
	
	$saleOrder = isset($pwd->sale_order[$i])?getNameById('sale_order',$pwd->sale_order[$i],'id'):array();  
	/* Start 04-03-2022*/
	/* Work Order name */
	$workOrderName = isset($pwd->work_order[$i])?$pwd->work_order[$i]:'';
	$wrkOdrNme = ($workOrderName!='' || $workOrderName!=0)?getNameById('work_order',$workOrderName,'id'):array();
	//echo !empty($wrkOdrNme)?$wrkOdrNme->workorder_name:'';
	$workOrderProductName = json_decode($wrkOdrNme->product_detail);
	/* Product Name */
	$wrkPrdctName = '';
	foreach($workOrderProductName as $productName){
		$prductName = getNameById('material',$productName->product,'id');
		$wrkPrdctName = $prductName->material_name;
	}
	/* Process name */
	$processName = isset($pwd->process_name[$i])?$pwd->process_name[$i]:'';
	$procsNme = ($processName!='' || $processName!=0)?getNameById('add_process',$processName,'id'):array();
	//echo !empty($procsNme)?$procsNme->process_name:'';

	/* End 04-03-2022 */  
?>
		
			<tr>
				<td><?php echo ((!empty($machineData))?($machineData->machine_name):''); ?></td>
				<td><?php echo ((!empty($wrkOdrNme))?($wrkOdrNme->workorder_name):''); ?></td>
				<td><?php echo ((!empty($wrkPrdctName))?($wrkPrdctName):''); ?></td>
				<td><?php echo ((!empty($procsNme))?($procsNme->process_name):''); ?></td>
				<td><?php echo ((!empty($jobCard))?($jobCard->job_card_product_name):''); ?></td>
				<?php 
					$targetMaterialName = getNameById('material',$target_data[$z]->product_name[$i],'id');
				?>
				<td>
					<table>
						<thead></thead>
						<tbody>
						<tr>
							<td><?php echo isset( $targetMaterialName) ?  $targetMaterialName->material_name : 0; ?></td>
							<td><?php  echo isset( $target_data[$z]->output[$i][0]) ?  $target_data[$z]->output[$i][0] : 0;?></td>
						</tr>
						</tbody>
					</table>
				</td>
				<td><?php
										//pre($prodplanData);
										$jobCardData = isset($pwd->job_card_product_id[$i])?(getNameById('job_card',$pwd->job_card_product_id[$i],'id')):'';
										
										$machine_details = json_decode($jobCardData->machine_details);
										$process = isset($pwd->process_name[$i])?getNameById('add_process',$pwd->process_name[$i],'id'):'';
										if($process->id != 0){
										$key = array_search($process->id, array_column($machine_details, 'processess'));
										if($key === 0 || $key >= 1){
										$detail_info = $machine_details[$key];
										$output_process_dtl = (!empty($detail_info->output_process) && isset($detail_info->output_process))?$detail_info->output_process:'';
										$process_sch_output = json_decode($output_process_dtl);
										}
										}
										$out = 0;
										foreach($process_sch_output as $val_output_sech){
										$material_id_output = $val_output_sech->material_output_name;
										$materialName_output = getNameById('material',$material_id_output,'id');
										#pre( $materialName_output);
										?>
										<table>
											<thead></thead>
											<tbody>
												<tr>
													<td><?php echo $materialName_output->material_name; ?></td>
													<td><?php if(isset($pwd->output[$i][0])) echo $pwd->output[$i][0];?></td>
												</tr>
											</tbody>
										</table>
										
										<?php $out++; } ?></td>
										<td><?php  if(isset($pwd->remarks[$i])) echo $pwd->remarks[$i];?></td>
				
				<?php 
									$outputTotal += $pwd->output[$i]!=""? (int)$pwd->output[$i]:0;
									$laborcostingTotal += $pwd->labour_costing[$i]!=""?(int)$pwd->labour_costing[$i]:0;
								    $TargetOutputsum += isset($target_data[$z]->output[$i]) ? (int)$target_data[$z]->output[$i] : 0;
									}
									/* Start 07-03-2022 */
									$plngOutPut = !empty($target_data[$z]->output[$i])?(count($target_data[$z]->output[$i])):0;
										for($l=0;$l<$plngOutPut;$l++){
											$planingTotalOutPut += $target_data[$z]->output[$i]!=""?(int)$target_data[$z]->output[$i] : 0;
										}
									/* End 07-03-2022 */
									
									/*******************calculate total worker **********************/
									$mergeWorkerArray = [];    //megring multidimensional array
									if(!empty($workerArray)){
										
										foreach ($workerArray as $worker_array) {
											
											if(!empty($worker_array)){	
												if(gettype($worker_array) == 'string'){
													$worker_array = array($worker_array);
												}											
												foreach ($worker_array as $worker) { 
													$mergeWorkerArray[] = $worker; 
												} 
											} 
										
										}
									}
									$totalWorkers = count(array_unique($mergeWorkerArray));
									
									
									/*****************caluclate total salary ********************/
									$totalSalary = 0;
									$mergeSalaryArray = [];    //megring multidimensional array
									if(!empty($salaryArray)){
										foreach ($salaryArray as $salary_Array) {
											
											if(!empty($salary_Array)){	
												foreach ($salary_Array as $salaryTotal) { 
													$totalSalary += (float)($salaryTotal);  //$salaryTotal; 
												}
											}
										}
									}
									/****************end**************************************/
								}		
						} $z++;
					} ?>
					
			
				
			</tr>
					
		</tbody>
	</table>
	<div class="row-padding col-container mobile-view view-page-mobile-view total-main"><div class="col-md-1 col-sm-12 col-xs-12 form-group total-text col">Total</div>
					<div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
					<div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
					<div class="col-md-1 col-sm-12 col-xs-12 form-group total-number col"><?php echo $TargetOutputsum ; ?></div>
					<div class="col-md-1 col-sm-12 col-xs-12 form-group total-number col"><?php echo $outputTotal; ?></div>
					<div class="col-md-2 col-sm-12 col-xs-12 form-group total-number col"></div>
					</div>
				
	<?php }
					
			
					
				}
				
				?>
	
    <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
       

		<div class="col-md-4 col-sm-5 col-xs-12 text-right grand-total3" style="float: right;">
			
		<div class="col-md-12 col-sm-5 col-xs-12 text-right">
			
			<div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2">
			<div class="col-md-12 col-sm-5 col-xs-6 form-group">
				OverAll Total 
				</div>
				
			</div>
			<div class="col-md-6 col-sm-5 col-xs-6 ">
				Worker &nbsp;:
				</div>
		    <div class="col-md-6 text-left"><?php echo $totalWorkers; ?></div>
              
            <div class="col-md-6 col-sm-5 col-xs-6 ">
				Total Salary &nbsp;:
				</div>
		    <div class="col-md-6 text-left"><?php echo $totalSalary;  ?></div>	
			<!-- Start 04-03-2022 -->
            <div class="col-md-6 col-sm-5 col-xs-6 " style="display:none">
				Labour Costing &nbsp;:
				</div>
			<!-- End 04-03-2022 -->
			<!-- Start 07-03-2022 -->
		    <div class="col-md-6 text-left" style="display:none"><?php //echo (round($OverallLaborcostingTotal,2)); ?></div>   
			<!-- End 07-03-2022 -->
            <div class="col-md-6 col-sm-5 col-xs-6 ">
				Production Output &nbsp;:
				</div>
             <div class="col-md-6 text-left"><?php echo $OveralloutputTotal; ?></div>							
				<div class="col-md-6 col-sm-5 col-xs-6 ">
				Planning Output &nbsp;:
				</div>
			<!-- Start 07-03-2022 -->
		    <div class="col-md-6 text-left"><?php echo $planingTotalOutPut; ?></div>
			<!-- End 07-03-2022 -->
        <div class="col-md-6 col-sm-5 col-xs-6 ">
				Output Percentage &nbsp;:
				</div>
		    <div class="col-md-6 text-left"><?php 
				$TargetOutputsum = ($TargetOutputsum == 0) ? 100 : $TargetOutputsum;
				$percentage = ($OveralloutputTotal/$TargetOutputsum)*100;
			echo (round($percentage,2)); ?> %</div>						
				 
			
         
		</div>
			
		</div>
</div>
	
</div>






