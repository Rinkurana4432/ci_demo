<div  style="width:100%" id="print_divv" border="1" cellpadding="2">
   <thead>
      <div class="col-md-3 col-xs-12">
         <div class="grand-tota2" style="border:0px;">Date:&nbsp;&nbsp;<?php if(!empty($productionView)){ echo date("j F , Y", strtotime($productionView->date)); } ?></div>
      </div>
      <tr>
         <h3 class="Material-head">
            Production Details
            <hr>
         </h3>
         <div class="col-md-12 col-xs-12 col-sm-12" id="chkIndex_1" style="padding:0px; border-top:0px; overflow-x:scroll;">
            <table  class="table table-bordered" data-id="user" border="1" cellpadding="3">
               <?php 				
                  if($productionView->production_data != ''){
                     // $production_planning = getNameById('production_planning',$productionView->planning_id,'id');
                     // $production_planning_data= json_decode($production_planning->planning_data);
                     //      $productionplaing=array();
                     //  foreach ($production_planning_data as  $production_planning_datavalue) {  
                     // 	$productionplaing[]= $production_planning_datavalue->output;
                     	 
                     // }  
                     // pre($productionplaing);
                  	$productionWagesData = json_decode($productionView->production_data);
                     // pre($productionWagesData);
                  	$OveralloutputTotal =   $OverallLaborcostingTotal = 0;
                  	$unique_machine_grpArray= array();
                  	foreach($productionWagesData as $pwd){
                  		//pre($pwd);
                  		$wagesLength = !empty($pwd->wages_or_per_piece)?(count($pwd->wages_or_per_piece)):0;
                  			for($k=0;$k<$wagesLength;$k++){
                  				$OveralloutputTotal += $pwd->output[$k]!=""?$pwd->output[$k]:0;

                  				$OverallLaborcostingTotal += $pwd->labour_costing[$k]!=""?$pwd->labour_costing[$k]:0;	
                  			}								
                  		$machinegrpId = $pwd->machine_grp;
                  		$unique_machine_grpArray[] = $machinegrpId[0];	
                  	}
                  	$unique_mach_grp =  array_unique($unique_machine_grpArray);
                  	//pre($unique_mach_grp);
                  foreach($unique_mach_grp as $machine_grp_id){
                  	echo '<div class="Process-card">
					<!--<h3 class="Material-head">Porduction Details<hr></h3>-->							  
                  		<div class="label-box mobile-view3">			  
                  			   <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Wages/Per piece</label></div>
                  			   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Machine</label></div>
                  			   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Work Order</label></div>
                  			   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>BOM Routing Product</label></div>
                  			   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Assign Process</label></div>
                  			   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Workers</label></div>
                  			    <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Production Planning</label></div>
                  			   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Production Output</label></div>
                              <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Estimated costing</label></div>
                  			   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Actual Labour costing</label></div>
                  			   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Remarks</label></div>
                  		</div>';								
                  			$outputTotal=$outputTotalplaing= $laborcostingTotal = 0;
                  			//$outputTotalplaning= $laborcostingTotal = 0;
							 //pre($productionWagesData);
                  			foreach($productionWagesData as $pwd){	
                  				if(!empty($pwd)){
                  					 $working_hrs = $totalsalary =array();
                  					   $working_hrs = json_decode(json_encode($pwd->working_hrs), true);
                  					   $totalsalary = json_decode(json_encode($pwd->totalsalary), true);
                  					 //  pre($pwd->working_hrs); pre($working_hrs);
                  					$wagesLength = !empty($pwd->wages_or_per_piece)?(count($pwd->wages_or_per_piece)):0;

                  						for($i=0;$i<$wagesLength;$i++){
                  							$machinegrp = isset($pwd->machine_grp[0])?$pwd->machine_grp[0]:'';
                  							//pre($machinegrp);
                  							$machine_id = isset($pwd->machine_name_id[$i])?$pwd->machine_name_id[$i]:'';
                                       //pre($pwd->machine_name_id[$i]);
                  							$machineData = ($machine_id!='' || $machine_id!=0)?getNameById('add_machine',$machine_id,'id'):array();
                  							$jobCard = isset($pwd->job_card_product_id[$i])?getNameById('job_card',$pwd->job_card_product_id[$i],'id'):array();
                                        $machine_paramenters = !empty($jobCard->machine_details)?json_decode($jobCard->machine_details):'';
                                          

                  							if(array_key_exists("machine_grp",$pwd) && $machine_grp_id == $machinegrp){	
                  							
                  							$workOrder = isset($pwd->work_order[$i])?getNameById('work_order',$pwd->work_order[$i],'id'):array();  
                  							$process = isset($pwd->process_name[$i])?getNameById('add_process',$pwd->process_name[$i],'id'):array();  
                  							
                  								
                  							echo '<div class="row-padding col-container mobile-view view-page-mobile-view"><div class="col-md-1 col-sm-12 col-xs-12 form-group col" style="border-left: 1px solid #c1c1c1 !important;"><label>Wages/Per piece</label><div>'.$pwd->wages_or_per_piece[$i] .'</div></div>';
                  							
                  							echo '<div class="col-md-2 col-sm-12 col-xs-12 form-group col"><label>Machine</label><div>'. ((!empty($machineData))?($machineData->machine_name):'') .'</div></div>';
                  							
                  							echo '<div class="col-md-2 col-sm-12 col-xs-12 form-group col"><label>Work order</label><div>'. ((!empty($workOrder))?($workOrder->workorder_name):'') .'</div></div>';
                  							
                  							echo '<div class="col-md-2 col-sm-12 col-xs-12 form-group col"><label>BOM Routing Product</label><div>'. ((!empty($jobCard))?($jobCard->job_card_no):'') .'</div></div>';
											echo '<div class="col-md-1 col-sm-12 col-xs-12 form-group col"><label>Assign Process</label><div>'. ((!empty($process))?($process->process_name):'') .'</div></div>'; ?>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group col" >
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
                                                                <div >'.$working_hrs[$i][$j].'</div></div>';
                     			echo ' <div class="col-md-4 col-sm-12 col-xs-12 abc" style="padding: 6px 12px !important;">
                                                                <div>'.$totalsalary[$i][$j].'</div></div>';			   
                     		    echo "</div>";
                     		}		
                     	}  
                     ?>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col" >
                  <label>Production Planning</label>
                  <div><?php if(isset($pwd->planing_output[$i])) echo $pwd->planing_output[$i];?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col" >
                  <label>Production Output</label>
                  <div><?php if(isset($pwd->output[$i])) echo $pwd->output[$i];?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col" >
                  <label>Estimated costing</label>
                  <div>
                        <?php
                             foreach ($machine_paramenters as $machine_paramentersvalue) {
                                   if ($pwd->machine_name_id[$i]==$machine_paramentersvalue->$machine_id[$i]) {
                                    echo (round($machine_paramentersvalue->total_cost[$i],2));
                                 }
                         }
                       ?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col" >
                  <label>Actual Labour costing</label>
                  <div><?php if(!empty($pwd) && isset($pwd->labour_costing[$i])) echo (round($pwd->labour_costing[$i],2));?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col" >
                  <label>Remarks</label>
                  <div><?php  if(isset($pwd->remarks[$i])) echo $pwd->remarks[$i];?></div>
               </div>
         </div>
         <?php 
            $outputTotal += $pwd->output[$i]!=""?$pwd->output[$i]:0;
            $outputTotalplaing += $pwd->planing_output[$i]!=""?$pwd->planing_output[$i]:0; 
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
         <div class="row-padding col-container mobile-view view-page-mobile-view total-main"><div class="col-md-1 col-sm-12 col-xs-12 form-group total-text col" >Total</div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
         <div class="col-md-3 col-sm-12 col-xs-12 form-group col"></div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group   col" > </div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group total-number   col" > <?php echo $outputTotalplaing; ?></div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group total-number col" ><?php echo $outputTotal; ?></div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group col" > </div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group total-number col" ><?php echo round($laborcostingTotal,2); ?></div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group  col" ></div> 
         </div>
</div>
<?php }
   }
   
   ?>
   <!-- <table class="bleow_tbl" style="display:none; width: 100%;" border="1" >
       
   <tr> 
      <th>Worker</th>
	   <th>Total Salary</th>
	   <th>Production Output</th>
	   <th>Labour Costing</th>
   </tr>
   <tr> 
      <td><?php echo $totalWorkers; ?></td>
      <td><?php echo $totalSalary;  ?></td>
      <td><?php echo $OveralloutputTotal; ?></td>
      <td><?php  $labour_costing_sub=$totalSalary/$OveralloutputTotal; echo (round($labour_costing_sub,2)); ?></td> 
   </tr>

   
   </table> -->
   
   
			<div class="col-md-12 col-sm-12 col-xs-12 " style="clear:both; margin-top:22px; ">
				<div class="col-md-4 col-sm-5 col-xs-12 text-right grand-total3 bleow_hide" style="float: right;">
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
						<div class="col-md-6 col-sm-5 col-xs-6 ">
						Production Output &nbsp;:
						</div>
						<div class="col-md-6 text-left"><?php echo $OveralloutputTotal; ?></div>
						<div class="col-md-6 col-sm-5 col-xs-6 ">
							Labour Costing &nbsp;:
						</div>
						<div class="col-md-6 text-left">
							<?php  $labour_costing_sub=$totalSalary/$OveralloutputTotal; echo (round($labour_costing_sub,2)); ?>
						</div>						
					</div>
				</div>
		</table>
	</div>
</tr>
</tbody>
</thead>		
</div>

<center>
   <button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
</center>