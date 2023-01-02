<div id="print_divv" class="print-div" style="margin-bottom:10px;">
   <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label for="material">Company unit:</label>
         <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <div><?php if(!empty($planningView)){ 
               $getUnitName= getNameById('company_address',$planningView->company_branch,'compny_branch_id');
               if(!empty($getUnitName)){
               	echo $getUnitName->company_unit;
               }												
               } ?>
            </div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label for="material">Supervisor Name:</label>
         <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <div><?php if(!empty($planningView)){ echo $planningView->supervisor_name; } ?></div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label for="material">Date:</label>
         <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <div><?php if(!empty($planningView)){ echo date("j F , Y", strtotime($planningView->date)); } ?></div>
         </div>
      </div>
   </div>
   <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label for="material">Shift:</label>
         <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <div><?php $shiftname = getNameById('production_setting',$planningView->shift,'id');
               if(!empty($shiftname)){ echo $shiftname->shift_name ; } 
               ?></div>
         </div>
      </div>
   </div>
   <h3 class="Material-head">
      Production Details
      <hr>
   </h3>
   <div class="col-md-12 col-xs-12 col-sm-12" id="chkIndex_1" style="padding:0px; display:table; float:unset;">
      <?php 
         if(!empty($planningView) && $planningView->planning_data !=''){	
         	$planningData =  json_decode($planningView->planning_data);	
         	$OveralloutputTotal = 0;
         	$workerArray = array();
         	//$k= 0;
         	$arrayvalue = array();
         	$unique_machine_grpArray = array();
         	foreach($planningData as  $production_plan){
         		//pre($production_plan->output);
         		$countMachineId  = !empty($production_plan->machine_name_id)?(count($production_plan->machine_name_id)):0;
         			for($k=0;$k<$countMachineId;$k++){
         				$overAllOutput = (int)($production_plan->output[$k]);
         				
         				$OveralloutputTotal += isset($overAllOutput)?$overAllOutput:'';
         				
         				//pre($OveralloutputTotal);
         			}
         			$machineGrp = $production_plan->machine_grp;
         			$unique_machine_grpArray[] = $machineGrp[0];
         			
         	}
         	$unique_mach_grp =  array_unique($unique_machine_grpArray);
         	foreach($unique_mach_grp as $machine_grp_id){
         		$outputTotal = 0;
         		echo '<div class="Process-card">
         		         	<!--<h3 class="Material-head">Porduction Details<hr></h3>-->
         		  
         		 <div class="label-box mobile-view3">			  
         			   <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Machine Name</label></div>
         			   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Party specification</label></div>
					    <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Work Order</label></div>
                  	 <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>BOM Routing Product</label></div>
                  	 <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Assign Process</label></div>

         			   <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Worker</label></div>
         			   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Output</label></div>
         			   </div>';
         		foreach($planningData as  $production_plan){
         			$countMachineId  = !empty($production_plan->machine_name_id)?(count($production_plan->machine_name_id)):0;
         			for($i=0;$i<$countMachineId;$i++){
         				//$OveralloutputTotal += isset($production_plan->output[$i])?$production_plan->output[$i]:0;
         				
         				$machineGrp = isset($production_plan->machine_grp[0])?($production_plan->machine_grp[0]):'';
         				$machine_id = isset($production_plan->machine_name_id[$i])?$production_plan->machine_name_id[$i]:'';
         				$machineData = ($machine_id!='' || $machine_id!=0)?getNameById('add_machine',$machine_id,'id'):array();
         				$jobCard = isset($production_plan->job_card_product_id[$i])?getNameById('job_card',$production_plan->job_card_product_id[$i],'id'):array();
         				$workOrder = isset($production_plan->work_order[$i])?getNameById('work_order',$production_plan->work_order[$i],'id'):array();  
                  		$process = isset($production_plan->process_name[$i])?getNameById('add_process',$production_plan->process_name[$i],'id'):array();  
         				if(array_key_exists("machine_grp",$production_plan) && $machine_grp_id == $machineGrp){
        ?>
      <div class="row-padding col-container mobile-view view-page-mobile-view">
         <div class="col-md-2 col-sm-12 col-xs-12 form-group col" style="border-left: 1px solid #c1c1c1 ;">
            <label>Machine Name</label>
            <div><?php  echo !empty($machineData)?$machineData->machine_name:''; ?></div>
         </div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
            <label>Party specification</label>
            <div><?php if(!empty($production_plan)){ echo $production_plan->specification[$i]; }?></div>
         </div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
            <label>Work order</label>
            <div><?php if(!empty($workOrder)){ echo $workOrder->workorder_name; }?></div>
         </div>      
		 <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
            <label>BOM Routing</label>
            <div><?php if(!empty($jobCard)){ echo $jobCard->job_card_no; }?></div>
         </div>         <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
            <label>Assign Process</label>
            <div><?php if(!empty($process)){ echo $process->process_name; }?></div>
         </div>
         <div class="col-md-4 col-sm-12 col-xs-12 form-group col">
            <label>Worker</label>
            <div><?php $workerName_id[$i] = isset($production_plan->worker[$i])?($production_plan->worker[$i]):'';
               $workerArray[] =  isset($production_plan->worker[$i])?($production_plan->worker[$i]):'';
               $WorkerNameWithCommaArray = array();
               if(!empty($workerName_id[$i])){
               	for($j=0;$j< count($workerName_id[$i]);$j++){
               		$Workername = getNameById('worker',$workerName_id[$i][$j],'id');
               		
               		$workername = !empty($Workername)?$Workername->name:'' ;
               		$WorkerNameWithCommaArray[$j] = $workername;
               		//pre(gettype($abc));
               		//$workername = rtrim($Workername->name ,',');
               		//echo !empty($workername)?$workername:'';
               	}
               	echo implode(',',$WorkerNameWithCommaArray);	
               }  	
               ?></div>
         </div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
            <label>Output</label>
            <div><?php echo isset($production_plan->output[$i])?$production_plan->output[$i]:'';?></div>
         </div>
      </div>
      <?php $outputTotal += $production_plan->output[$i]?$production_plan->output[$i]:0;
         }
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
         
         //pre($totalWorkers);
         }
       }
         ?>
      <div class="row-padding col-container mobile-view view-page-mobile-view total-main">
         <div class="col-md-2 col-sm-12 col-xs-12 form-group total-text col" >Total</div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
         <div class="col-md-4 col-sm-12 col-xs-12 form-group col"></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group total-number col" ><?php echo $outputTotal; ?></div>
		  <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
		 <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
      </div>
      <?php 
         //}  
         echo '</div> ';	
         } 
         
         }
         ?>
      <div class="row-padding col-container mobile-view view-page-mobile-view total-main" style="display: table;">
         <div class="col-md-2 col-sm-12 col-xs-12 form-group total-text col" >OverAll Total</div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
         <div class="col-md-4 col-sm-12 col-xs-12 form-group total-number col"><?php echo $totalWorkers?$totalWorkers:0; ?></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group total-number col" ><?php echo $OveralloutputTotal; ?></div>
		
      </div>
   </div>
   <div class="production" style="display:none;">
      <h5 style="float:left;">Supervisor:_____________</h5>
      <h5 style="float:right;">Production manager:_____________</h5>
   </div>
</div>
<!--<table class="fixed data table table-bordered no-margin" style="width:100%" id="print_divv" border="1" cellpadding="2">
   <thead>				
   <tbody>
   	<tr>
   	   <th>Supervisor Name:</th>
   	   <th></?php if(!empty($planningView)){ echo $planningView->supervisor_name; } ?></th>
   	   
   	</tr>
   	<tr>
   	   <th>Date:</th>
   	   <th></?php if(!empty($planningView)){ echo date("j F , Y", strtotime($planningView->date)); } ?></th>
   	   
   	</tr>
   	<tr>
   	   <th>Shift:</th>
   		<th>
   			</?php $shiftname = getNameById('production_setting',$planningView->shift,'id');
   				if(!empty($shiftname)){ echo $shiftname->shift_name ; } 
   			?>
   		</th>
   	</tr>
   	<tr>
   		<th>Porduction Details:</th>
   		<th>
   			<table class="fixed data table table-bordered no-margin" style="width:100%" border="1" cellpadding="2">
   			<thead>
   				<tr>
   					<th>Machine Name</th>
   					<th>Party specification</th>
   					<th>Job no</th>
   					<th>Worker</th>
   					<th>Output</th>
   				</tr>
   			</thead>					
   			<tbody>
   				<tr>
   				</?php 
   				if(!empty($planningView) && $planningView->planning_data !=''){	
   					$planningData =  json_decode($planningView->planning_data);	
   					$OveralloutputTotal = 0;
   					$workerArray = array();
   					//$k= 0;
   					$arrayvalue = array();
   					$unique_machine_grpArray = array();
   					foreach($planningData as  $production_plan){
   						//pre($production_plan->output);
   						$countMachineId  = !empty($production_plan->machine_name_id)?(count($production_plan->machine_name_id)):0;
   							for($k=0;$k<$countMachineId;$k++){
   								$overAllOutput = (int)($production_plan->output[$k]);
   								
   								$OveralloutputTotal += isset($overAllOutput)?$overAllOutput:'';
   								
   								//pre($OveralloutputTotal);
   							}
   							$machineGrp = $production_plan->machine_grp;
   							$unique_machine_grpArray[] = $machineGrp[0];
   							
   					}
   					$unique_mach_grp =  array_unique($unique_machine_grpArray);
   					foreach($unique_mach_grp as $machine_grp_id){
   						$outputTotal = 0;
   						foreach($planningData as  $production_plan){
   							$countMachineId  = !empty($production_plan->machine_name_id)?(count($production_plan->machine_name_id)):0;
   							for($i=0;$i<$countMachineId;$i++){
   								//$OveralloutputTotal += isset($production_plan->output[$i])?$production_plan->output[$i]:0;
   								
   								$machineGrp = isset($production_plan->machine_grp[0])?($production_plan->machine_grp[0]):'';
   								$machine_id = isset($production_plan->machine_name_id[$i])?$production_plan->machine_name_id[$i]:'';
   								$machineData = ($machine_id!='' || $machine_id!=0)?getNameById('add_machine',$machine_id,'id'):array();
   								$jobCard = isset($production_plan->job_card_product_name[$i])?getNameById('job_card',$production_plan->job_card_product_name[$i],'id'):array();
   								
   								if(array_key_exists("machine_grp",$production_plan) && $machine_grp_id == $machineGrp){
   									
   									
   								?>
   								<tr>
   									<td></?php  echo !empty($machineData)?$machineData->machine_name:''; ?><br /></td>
   									<td></?php if(!empty($production_plan)){ echo $production_plan->specification[$i]; }?></td>
   									<td></?php if(!empty($jobCard)){ echo $jobCard->job_card_product_name; }?></td>
   									<td></?php $workerName_id[$i] = isset($production_plan->worker[$i])?($production_plan->worker[$i]):'';
   										$workerArray[] =  isset($production_plan->worker[$i])?($production_plan->worker[$i]):'';
   										
   										if(!empty($workerName_id[$i])){
   											for($j=0;$j< count($workerName_id[$i]);$j++){
   												$Workername = getNameById('worker',$workerName_id[$i][$j],'id');
   												
   												$workername[$j] = !empty($Workername)?$Workername->name:'' ;
   												/* pre(gettype($workername));
   												echo explode(" ", $workername);
   												echo rtrim($workername,','); */
   												//echo !empty($workername)?$workername:'';
   											}
   											echo implode(',',$workername);	
   										}  	
   									?>
   									</td>
   									<td></?php echo isset($production_plan->output[$i])?$production_plan->output[$i]:'';?><br /></td>
   								</tr>
   								</?php $outputTotal += $production_plan->output[$i]?$production_plan->output[$i]:0;
   								}
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
   								
   							//pre($totalWorkers);
   							}
   							
   							
   							
   							
   						}
   								?>
   							<tr style="background-color:#DCDCDC; font-size:19px;"><th colspan="4">Total</th>
   							<th></?php echo $outputTotal; ?></th>
   						</?php 
   						//}   
   					}
   					
   				}
   					?>
   				</tr>
   				<tr>
   					<th colspan="3">OverAll Total</th>
   					<th></?php echo $totalWorkers?$totalWorkers:0; ?></th>
   					<th></?php echo $OveralloutputTotal; ?></th>
   					</tr>
   			</tbody>
   			</table>
   		</th>			
          </tr>
      </tbody>
      </thead>		
   </table>-->
<center>
   <button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
</center>