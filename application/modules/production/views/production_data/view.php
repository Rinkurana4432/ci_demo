<style>
   .production-card-print{
    display: none;
}
@media print {
.production-card-print {display:block}
}
</style>
<div  style="width:100%" id="" border="1" cellpadding="2">
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
               $overall_tot = 0;           
                  if($productionView->production_data != ''){
                     $productionWagesData = json_decode($productionView->production_data);
                     $OveralloutputTotal = $OverallLaborcostingTotal = 0;
                     $unique_machine_grpArray= array();
                     //pre($productionWagesData); die;
                     foreach($productionWagesData as $pwd){
                        $wagesLength = !empty($pwd->wages_or_per_piece)?(count($pwd->wages_or_per_piece)):0;
                        $out = 0;
                           for($k=0;$k<$wagesLength;$k++){
                              $OveralloutputTotal += $pwd->output[$k][$out]!=""?$pwd->output[$k][$out]:0;
                              $OverallLaborcostingTotal += $pwd->labour_costing[$k]!=""?$pwd->labour_costing[$k]:0;  
                        $out++;  
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
                              <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Assign Process</label></div>
                              <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Workers</label></div>
                              <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Production Output</label></div>
                              <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Estimated costing</label></div>
                              <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Actual Labour costing</label></div>
                              <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Remarks</label></div>
                        </div>';                      
                           $outputTotal= $laborcostingTotal = 0;
                      //pre($productionWagesData);
                           foreach($productionWagesData as $pwd){ 
                              if(!empty($pwd)){
                                  $working_hrs = $totalsalary =array();
                                    $working_hrs = json_decode(json_encode($pwd->working_hrs), true);
                                    $totalsalary = json_decode(json_encode($pwd->totalsalary), true);
                                  //  pre($pwd->working_hrs); pre($working_hrs);
                                 $wagesLength = !empty($pwd->wages_or_per_piece)?(count($pwd->wages_or_per_piece)):0;
                                    $out1 = 0;
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
                                 echo '<div class="col-md-2 col-sm-12 col-xs-12 form-group col"><label>Assign Process</label><div>'. ((!empty($process))?($process->process_name):'') .'</div></div>'; ?>
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

               <div class="col-md-3 col-sm-12 col-xs-12 form-group col">
               <label>Production Output</label>
               <div class="label-box ineer-table">
               <div class="col-md-6 col-sm-12 col-xs-12 form-group"><label style="border-left:1px solid #c1c1c1 !important;">Material Name</label></div>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group"><label>Value</label></div>
               </div>
               <?php
                  $machine_details = json_decode($jobCard->machine_details);
                  if($process->id != 0){
                  $key = array_search($process->id, array_column($machine_details, 'processess'));
                  if($key === 0 || $key >= 1){
                  $detail_info = $machine_details[$key];
                  $output_process_dtl = (!empty($detail_info->output_process) && isset($detail_info->output_process))?$detail_info->output_process:'';
                  $process_sch_output = json_decode($output_process_dtl);
                  }
                  }
                  $out2 = 0;
                  foreach($process_sch_output as $val_output_sech){
                  $material_id_output = $val_output_sech->material_output_name;
                  $materialName_output = getNameById('material',$material_id_output,'id');
                 ?>
               <div class="row-padding ineer-row">
               <div class="col-md-6 col-sm-12 col-xs-12 abc" style="border-left:1px solid #c1c1c1 !important; padding: 6px 12px !important;">
               <div><?php echo $materialName_output->material_name; ?></div>
               </div>
               <div class="col-md-6 col-sm-12 col-xs-12 abc" style="padding: 6px 12px !important;">
               <div><?php echo $pwd->output[$i][$out2]; ?></div>
               </div>
               </div>
               <?php $outputTotal += $pwd->output[$i][$out2]; $out2++; } ?>               
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
           // $outputTotal += $pwd->output[$i][$out1]!=""?$pwd->output[$i][$out1]:0;
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
            $out1++; }     
            }
            } ?>
         <div class="row-padding col-container mobile-view view-page-mobile-view total-main"><div class="col-md-1 col-sm-12 col-xs-12 form-group total-text col" >Total</div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
         <div class="col-md-3 col-sm-12 col-xs-12 form-group col"></div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group   col" > </div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group total-number col" ><?php echo $outputTotal;
         $overall_tot += $outputTotal;
          ?></div>
          
         <div class="col-md-1 col-sm-12 col-xs-12 form-group   col" > </div>
          
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
            <div class="col-md-4 col-sm-5 col-xs-12 text-right grand-total3 " style="float: right;">
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
                  <div class="col-md-6 text-left"><?php echo $overall_tot; //echo $OveralloutputTotal; ?></div>
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




<!-- html -->

<div  style="" id="print_divv" class="print-div production-card-print">
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
                   $overall_tot = 0;       
                  if($productionView->production_data != ''){
                     $productionWagesData = json_decode($productionView->production_data);
                     $OveralloutputTotal = $OverallLaborcostingTotal = 0;
                     $unique_machine_grpArray= array();
                     //pre($productionWagesData); die;
                     foreach($productionWagesData as $pwd){
                        $wagesLength = !empty($pwd->wages_or_per_piece)?(count($pwd->wages_or_per_piece)):0;
                        $out = 0;
                           for($k=0;$k<$wagesLength;$k++){
                              $OveralloutputTotal += $pwd->output[$k][$out]!=""?$pwd->output[$k][$out]:0;
                              $OverallLaborcostingTotal += $pwd->labour_costing[$k]!=""?$pwd->labour_costing[$k]:0;  
                        $out++;  
                           }                       
                        $machinegrpId = $pwd->machine_grp;
                        $unique_machine_grpArray[] = $machinegrpId[0];  
                     }
                     $unique_mach_grp =  array_unique($unique_machine_grpArray);
                     //pre($unique_mach_grp);
                      $printID = 0;
            $attbute = 0;
            $printBtn = 0;
                  foreach($unique_mach_grp as $machine_grp_id){
                     echo '<div class="Process-card">
               <table class="printBtn_'.$printBtn++.'  well" id="" attbute="printAttr_'.$attbute++.'"> <thead>
                      <tr>                   
                              <td>Wages/Per piece</td>
                              <td>Machine</td>
                              <td>Work Order</td>
                              <td>BOM Routing Product</td>
                              <td>Assign Process</td>
                              <td>Workers</td>
                              <td>Production Output</td>
                              <td>Estimated costing</td>
                              <td>Actual Labour costing</td>
                              <td>Remarks</td>
                        </tr>
                  </thead><tbody>';                      
                           $outputTotal= $laborcostingTotal = 0;
                      //pre($productionWagesData);
                           foreach($productionWagesData as $pwd){ 
                              if(!empty($pwd)){
                                  $working_hrs = $totalsalary =array();
                                    $working_hrs = json_decode(json_encode($pwd->working_hrs), true);
                                    $totalsalary = json_decode(json_encode($pwd->totalsalary), true);
                                  //  pre($pwd->working_hrs); pre($working_hrs);
                                 $wagesLength = !empty($pwd->wages_or_per_piece)?(count($pwd->wages_or_per_piece)):0;
                                    $out1 = 0;
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
                                       
                                          
                                       echo '</tr><td>'.$pwd->wages_or_per_piece[$i] .'</td>';
                                       
                                       echo '<td>'. ((!empty($machineData))?($machineData->machine_name):'') .'</td>';
                                       
                                       echo '<td>'. ((!empty($workOrder))?($workOrder->workorder_name):'') .'</td>';
                                       
                                       echo '<td>'. ((!empty($jobCard))?($jobCard->job_card_no):'') .'</td>';
                                 echo '<td>'. ((!empty($process))?($process->process_name):'') .'</td>'; ?>
               <td>
                  <?php $workerName_id[$i] = isset($pwd->worker_id[$i])?($pwd->worker_id[$i]):'';
                     $workerArray[] =  isset($pwd->worker_id[$i])?($pwd->worker_id[$i]):'';
                     $salaryArray[] = isset($pwd->totalsalary[$i])?($pwd->totalsalary[$i]):'';                                      
                        if(!empty($workerName_id[$i])){
                           echo '<table>
                                    <thead><tr><td>Worker</td>
                                    <td>Hours/percentage</td>
                                    <td>total Salary</td>
                                    </tr></thead><tbody><tr>';                                           
                           for($j=0;$j< count($workerName_id[$i]);$j++){
                              echo '<td>';
                              $Workername = getNameById('worker',$workerName_id[$i][$j],'id');
                              echo $Workername->name;
                              echo '</td>';
                              echo ' <td>'.$working_hrs[$i][$j].'</td>';
                              echo ' <td>'.$totalsalary[$i][$j].'</td>';          
                               echo "</tr></tbody></table>";
                           }     
                        }  
                     ?>
               </td>

               <td>
                  <table>
                     <thead>
                        <tr>
                           <td>Material Name</td>
                           <td>Value</td>
                        </tr>
                     </thead>
                     <tbody>
                         <?php
                  $machine_details = json_decode($jobCard->machine_details);
                  if($process->id != 0){
                  $key = array_search($process->id, array_column($machine_details, 'processess'));
                  if($key === 0 || $key >= 1){
                  $detail_info = $machine_details[$key];
                  $output_process_dtl = (!empty($detail_info->output_process) && isset($detail_info->output_process))?$detail_info->output_process:'';
                  $process_sch_output = json_decode($output_process_dtl);
                  }
                  }
                  $out2 = 0;
                  foreach($process_sch_output as $val_output_sech){
                  $material_id_output = $val_output_sech->material_output_name;
                  $materialName_output = getNameById('material',$material_id_output,'id');
                  ?>
                  <tr>
                     <td><?php echo $materialName_output->material_name; ?></td>
                     <td><?php echo $pwd->output[$i][$out2]; ?></td>
                  </tr>
                  <?php $outputTotal += $pwd->output[$i][$out2]; $out2++; } ?>
                     </tbody>
                  </table>
               </td>
               <td>
               <?php
                 foreach ($machine_paramenters as $machine_paramentersvalue) {
                  if ($pwd->machine_name_id[$i]==$machine_paramentersvalue->$machine_id[$i]) {
                     echo (round($machine_paramentersvalue->total_cost[$i],2));
                  }
                }
              ?>
               </td>
               <td class="col-md-1 col-sm-12 col-xs-12 form-group col" >
                  <?php if(!empty($pwd) && isset($pwd->labour_costing[$i])) echo (round($pwd->labour_costing[$i],2));?>
               </td>
               <td class="col-md-1 col-sm-12 col-xs-12 form-group col" >
                 <?php  if(isset($pwd->remarks[$i])) echo $pwd->remarks[$i];?>
               </td>
        
         <?php 
           // $outputTotal += $pwd->output[$i][$out1]!=""?$pwd->output[$i][$out1]:0;
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
            $out1++; }     
            }
            } ?>
            

         <?php 
        //}  
        echo '</tr>';  
        ?>
         <td>Total
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td ><?php echo $outputTotal; ?></td>
            <td> </td>
            <td><?php echo round($laborcostingTotal,2); ?></td>
            <td> </td>
         </td>
        <?php
        $overall_tot += $outputTotal; } 
        ?>
<td>
         
        <?php
        echo '</tbody></table>';  
        }
        ?>

<div class="col-md-12 col-sm-12 col-xs-12 " style="clear:both; margin-top:22px; ">
            <div class="col-md-4 col-sm-5 col-xs-12 text-right grand-total3 " style="float: right;">
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
                  <div class="col-md-6 text-left"><?php echo $overall_tot; //echo $OveralloutputTotal; ?></div>
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

