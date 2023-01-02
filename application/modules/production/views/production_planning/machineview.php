<div id="print_divv" class="print-div" style="margin-bottom:10px;">
  
  
   <h3 class="Material-head">
      Production Details
      <hr>
   </h3>
   <div class="col-md-12 col-xs-12 col-sm-12" id="chkIndex_1" style="padding:0px; display:table; float:unset;">
     <table id="" class="table table-bordered " data-id="user" border="1" cellpadding="2">
                     <thead>
                        <tr>
                           <th>Machine Name</th>
                           <th>BOM Routing Number</th>
                           <th>Worker</th>
                           <th>NPDM Product</th>
                           <th>Output</th>
                        </tr>
                     </thead>
                     <?php 
					
                        $productionPlanning=json_decode($planningView->planning_data);	
                        $prodPlan_lengthCount = count($productionPlanning);
                        //pre($prodPlan_lengthCount);
                        $k = 1;
                        foreach($productionPlanning as $production_planning){
                        	
                        		
                        	$countMachineId  = !empty($production_planning->machine_name_id)?(count($production_planning->machine_name_id)):0;
                        	
                        	for($i=0;$i<$countMachineId;$i++){
                        	
                        		
                        	$machine_id = isset($production_planning->machine_name_id[$i])?$production_planning->machine_name_id[$i]:'';
                        	$machineData = ($machine_id!='' || $machine_id!=0)?getNameById('add_machine',$machine_id,'id'):array();
                        	echo '<tr><td>'. ((!empty($machineData))?($machineData->machine_name):'') .'</td>';
                        	$jobCard = isset($production_planning->job_card_product_id[$i])?getNameById('job_card',$production_planning->job_card_product_id[$i],'id'):array();  
                        	echo '<td>'. ((!empty($jobCard))?($jobCard->job_card_no):'') .'</td>'; 
                        ?>		
                     <td>
                        <?php $workerName_id[$i] = isset($production_planning->worker[$i])?($production_planning->worker[$i]):'';
                           $workerArrayData = array();
                           if(!empty($workerName_id[$i])){
                           	//echo '';
                           		for($j=0;$j< count($workerName_id[$i]);$j++){
                           			$Workername = getNameById('worker',$workerName_id[$i][$j],'id');
                           			$worker_name = !empty($Workername)?$Workername->name:'';
                           			$workerArrayData[$j] = $worker_name;
                           			//echo !empty($Workername)?$Workername->name:'';
                           		}	
                           		echo implode(',',$workerArrayData);
                           	}  	
                           ?> 
                     </td>
                     <?php
                        $npdm = isset($production_planning->npdm[$i])?getNameById('npdm',$production_planning->npdm[$i],'id'):array();  
                        echo '<td>'. ((!empty($npdm))?($npdm->product_name):'') .'</td>';
                        
                        
                        ?>
                     <td><?php echo isset($production_planning->output[$i])?$production_planning->output[$i]:'';?></td>
                     <?php 
                       
                      
                        	}
                        
                        	$output11[] = array(
							   'Id'=>$production_plan['id'],
                        	   'Date' => $production_plan['date'],
                        	   'Shift' =>$shiftname->shift_name,
                        	   'Supervisor Name'=>$production_plan['supervisor_name'],
							   'Machine Name'=>((!empty($machineData))?($machineData->machine_name):''),
							   'Bom Routing No.'=>((!empty($jobCard))?($jobCard->job_card_no):''),
                        	   'Worker' =>$Workername->name,
							   'Created Date'=>date("d-m-Y", strtotime($production_plan['created_date']))
                        	   );
                        }
                        
                        	 
                        ?>
                    
                  </table>
  
</div>

