<?php   
  $emp_details    = getNameById('worker',$allData['id'],'id');   
?>
 
               

<div id="print_divv" class="col-md-12 col-sm-12 col-xs-12"  style="padding:0px;"> 
        <div class="table-responsive">
               <h4 style='text-align:center'> Salary Slip<br><br> <b>LSPL</b>(Plot No.39, Industrial Area Phase 1, Panchkula, Haryana 134113)<br><br><br> </h4>
                <h3 class="Material-head"> Employee Details :<?php if(!empty($emp_details->name)) echo $emp_details->name .' '.$emp_details->id; ?><hr></h3>
              <div class="col-md-6 col-xs-12 col-sm-6 label-left " >
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material"> Employee Code:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6 ">
                                        <div> <?php  if(!empty($emp_details->id)){ echo $emp_details->id ; }  ?></div>
                                    </div>
                                </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Employee Name:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6 ">
                                        <div><?php if(!empty($emp_details->name)) echo $emp_details->name; ?></div>
                                    </div>
                    </div> 
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Date Of Joining:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6 ">
                                        <div><?php if(!empty($emp_details->date_of_joining)) echo $emp_details->date_of_joining; ?></div>
                                    </div>
                    </div>
                    
                   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Department</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6">
                                        <div> <?php if(!empty($emp_details->department)) echo $emp_details->department; ?></div>
                                    </div>
                    </div>  
                   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Designation</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6">
                                        <div><?php if(!empty($emp_details->designation)) echo $emp_details->designation; ?></div>
                                    </div>
                    </div>  
                     
          
              </div>
             
              <div class="col-md-6 col-xs-12 col-sm-6 label-left">
                   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Branch Name:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6">
                                        <div><?php if(!empty($emp_details->branch_name)){ echo $emp_details->branch_name; } ?> </div>
                                    </div>
                    </div>  
                   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Bank Acc/No</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6">
                                        <div><?php if(!empty($emp_details->account_no)){ echo $emp_details->account_no; } ?></div>
                                    </div>
                    </div> 
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">PF No:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6">
                                        <div> <?php if(!empty($emp_details->ifsc_code)){ echo $emp_details->ifsc_code; } ?> </div>
                                    </div>
                    </div>
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">UAN No:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6">
                                        <div> <?php if(!empty($emp_details->uan_no)){ echo $emp_details->uan_no; } ?> </div>
                                    </div>
                    </div>
                 <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">ESI No:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6">
                                        <div> <?php if(!empty($emp_details->esic_no)){ echo $emp_details->esic_no; } ?> </div>
                                    </div>
                    </div>
                 <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">PAN No:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6">
                                        <div> <?php if(!empty($emp_details->panNo)){ echo $emp_details->panNo; } ?> </div>
                                    </div>
                    </div>
             
                    
                    
                    
              </div>
              
<hr>
<div class="bottom-bdr"></div>
              
<div class="container mt-3">
<h3 class="Material-head">Salary Description<hr></h3>   
        <div class="well pro-details" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; border:0px; margin-top: 15px;">

<ul class="col-sm-12 col-xs-12">
  <?php 
  if(!empty($emp_details->salarySlab!='0')){ 

   $salary_slabs =   getNameById('salary_slab',$emp_details->salarySlab,'id');
   if (!empty($salary_slabs)) {
    $slab_structure= json_decode($salary_slabs->slab_structure); 
      } 
 if (!empty($slab_structure)) { 
 $oneLevaveSalary='';   
      if ($allData['totalLeave']>='1') {  
               $oneLevaveSalary= 1*(float)$allData['oneDaysalary'];
          }
 
    $total_sal=(float)$allData['empWokingSalary']+(float)$oneLevaveSalary+(float)$allData['weekoff']??'' ;  
      ?>
      <h4>Salary:- <?php echo number_format($total_sal,2);    ?></h4>
    <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
        <thead>
            <tr>
                <th>Basic</th>
                <th>Dearness Allowance</th> 
                <th>HRA</th>
                <th>Conveyance Allowance</th>
                <th>Special Allowance</th>
                <th>Medical</th> 
                <th>Others</th>
                <th>Pay</th>

            </tr>
        </thead>
        <tbody>
            <tr class="locRow">
                <td><?php $basic=''; if(!empty($slab_structure->basic)){ $basic=$total_sal*$slab_structure->basic/100;echo number_format($basic,2); }else{echo"0.00";} ?></td>
                 <td><?php $da=''; if(!empty($slab_structure->da)){   $da=$total_sal*$slab_structure->da/100; echo number_format($da,2);}else{echo"0.00";} ?></td>
                <td><?php $hra=''; if(!empty($slab_structure->hra)){   $hra=$total_sal*$slab_structure->hra/100; echo number_format($hra,2);}else{echo"0.00";} ?></td>
                <td><?php $ca=''; if(!empty($slab_structure->ca)){   $ca=$total_sal*$slab_structure->ca/100; echo number_format($ca,2);}else{echo"0.00";} ?></td>
                <td><?php $sa=''; if(!empty($slab_structure->sa)){   $sa=$total_sal*$slab_structure->sa/100; echo number_format($sa,2);}else{echo"0.00";} ?></td>
                <td><?php $medical=''; if(!empty($slab_structure->medical)){   $medical=$total_sal*$slab_structure->medical/100; echo number_format($medical,2);}else{echo"0.00";} ?></td> 
               <!--  <td><?php $incentive=''; if(!empty($slab_structure->incentive)){ echo $incentive=$total_sal*$slab_structure->incentive/100;}else{echo"0.00";} ?></td> -->
                <td><?php $others=''; if(!empty($slab_structure->others)){   $others=$total_sal*$slab_structure->others/100; echo number_format($others,2); }else{echo"0.00";} ?></td>                 
                <td><?php  $total= (float)$basic + (float)$hra + (float)$da + (float)$ca + (float)$sa +   (float)$medical+ (float)$others; echo number_format($total,2); ?></td>

            </tr>
        </tbody>
    </table>
    <h4 style="color: #140104db;" >Employee Deduction  </h4>
    <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
        <thead>
            <tr>
                <th>ESI (Employees State Insurance Corporation)</th>
                <th>EPF (Provident Fund )</th>
                <th>TDS (Tax Deducted at Source)</th> 
                <th>LWF (Labour Welfare Fund)</th> 
                <th>Net Pay</th> 

            </tr>
        </thead>
        <tbody>
            <tr class="locRow"> 
                <td>
                  <span style="margin-left: 5px;"><label>Salary ESI Charges:-</label>
                    <?php 
                         $totalesic= (float)$basic + (float)$da + (float)$hra +(float)$ca + (float)$sa + (float)$medical+ (float)$others;
                         $esic='';
                          if(!empty($slab_structure->esic)){ 
                            if ($totalesic ) { 
                                  $esic= $totalesic*$slab_structure->esic/100; echo number_format($esic,2);
                            }else{
                                 echo $esic="0.00";
                            }
                            }else{
                                echo $esic="0.00";
                           } ?></span>
                    <span style="margin-left: 10px;"><label>OT ESI Charges:-</label>
                      <?php  
                         $esicOt='';
                          if(!empty($slab_structure->esic)){ 
                            if ((float)$allData['otSalary']) { 
                                  $esicOt= (float)$allData['otSalary']*$slab_structure->esic/100; echo number_format($esicOt,2);
                            }else{
                                 echo $esicOt="0.00";
                            }
                            }else{
                                echo $esicOt="0.00";
                           } ?></span>
                 <span style="margin-left: 10px;"><label>Total ESI Charges:-</label><?php echo number_format(($esicOt+$esic),2);?></span> 
                </td>
                  <td> 
                          <?php
                          $totalpf= (float)$basic;
                            $pf=''; 
                          if(!empty($slab_structure->pf)){
                            if ($totalpf ){
                                  $pf=$totalpf*$slab_structure->pf/100; echo number_format($pf,2);
                            }else{
                                echo $pf="0.00";
                            }
                            }else{
                               echo $pf="0.00";
                             } 
                            ?>
                 </td> 
                <td><?php  $tds='';if(!empty($slab_structure->tds)){   $tds=$total_sal*$slab_structure->tds/100; echo number_format($tds,2);}else{echo"0.00";} ?>
                    
                </td> 
                <td><?php  $lwf=''; if(!empty($slab_structure->lwf)){   $lwf=$slab_structure->lwf; echo number_format($lwf,2);}else{echo"0.00";} ?></td> 
                <td><?php   $totalD=(float)$esic+(float)$pf+(float)$tds+(float)$lwf; 
                                $netpay=$total-$totalD; echo number_format($netpay,2);?>
                </td> 

            </tr>
        </tbody>
    </table>
    <h4 style="color: #140104db;" >Employer Deduction</h4>
    <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
        <thead>
            <tr>
                <th>ESI (Employees State Insurance Corporation)</th>
                <th>EPF (Provident Fund )</th>
                <th>LWF (Labour Welfare Fund)</th>
                <th>Total</th>  

            </tr>
        </thead>
        <tbody>
            <tr class="locRow"> 
                <td>
                  <span style="margin-left: 5px;" ><label>Salary ESI Charges:-</label>
                    <?php 
                         $totalesic= (float)$basic + (float)$da + (float)$hra +(float)$ca + (float)$sa + (float)$medical+ (float)$others;
                         $esicemployer='';
                          if(!empty($slab_structure->esic_employer)){ 
                            if ($totalesic ) { 
                                  $esicemployer= $totalesic*$slab_structure->esic_employer/100; echo number_format($esicemployer,2);
                            }else{
                                 echo $esicemployer="0.00";
                            }
                            }else{
                                echo $esicemployer="0.00";
                           } ?></span>
                    <span  style="margin-left: 10px;" ><label>OT ESI Charges:-</label>
                      <?php  
                         $esicOtemployer='';
                          if(!empty($slab_structure->esic_employer)){ 
                            if ((float)$allData['otSalary']) { 
                                  $esicOtemployer= (float)$allData['otSalary']*$slab_structure->esic_employer/100; echo number_format($esicOtemployer,2);
                            }else{
                                 echo $esicOtemployer="0.00";
                            }
                            }else{
                                 echo $esicOtemployer="0.00";
                           } ?></span>
                 <span><label  style="margin-left: 10px;" >Total ESI Charges:-</label><?php echo number_format(($esicOtemployer+$esicemployer),2);?></span> 

               </td>
                <td><?php $totalpf1 = (float)$basic;
                   $pf_employer=''; 
                   if(!empty($slab_structure->pf_employer)){ 
                    if ($totalpf1) {
                         $pf_employer=$totalpf1*$slab_structure->pf_employer/100; echo number_format($pf_employer,2);
                    }else{
                      echo  $pf_employer="0.00";
                    }
                     }else{
                    echo $pf_employer="0.00";
                    } ?>
                 </td> 
                 <td><?php $slab_structure->lwf_employer==''; if(!empty($slab_structure->lwf_employer)){ echo $slab_structure->lwf_employer; }else{echo"0.00";} ?></td>
                <td><?php    $totlaE = (float)$esic_employer+(float)$pf_employer+(float)$slab_structure->lwf_employer; echo number_format($totlaE,2); ?></td> 
            </tr>
        </tbody>
    </table>
  <div  class="col-md-12 col-sm-12 col-xs-12" >
        <div class="item form-group col-md-3 col-sm-12 col-xs-12">
      <span><label> Gross Pay :- </label><?php echo $Gross= (float)$allData['grossPay'];?> </span>
       </div>
     <div class="item form-group col-md-3 col-sm-12 col-xs-12">
      <span><label>   Net Pay :-  </label><?php   $Net_Pay= (float)$netpay; echo number_format($Net_Pay,2);?></span>  
    </div>   
    <div class="item form-group col-md-3 col-sm-12 col-xs-12">
        <span><label>  Over Time Salary  :-  </label><?php if (!empty($allData['otSalary'])) {
                $otSalary = (float)$allData['otSalary']-(float)$esicOt;  echo number_format($otSalary,2);
          }else{ echo '0.00';} ?> </span> 
        
    </div> 
  <div class="item form-group col-md-3 col-sm-12 col-xs-12">
       <span><label> Total Salary  :- </label><?php if ($total_sal) {
                $OverAllemployee = (float)$otSalary+(float)$Net_Pay;
               echo number_format($OverAllemployee,2);
          }else{ echo '0.00';} ?> </span> 
     </div> 
</div>
<div class="col-md-12 col-sm-12 col-xs-12" >
       <div class="item form-group col-md-3 col-sm-12 col-xs-12">
       <span><label>  Employee Leave Deduction  :-  </label><?php if ($allData['totalLeave']>'1') {
               $employee = (float)$allData['totalLeave']*(float)$allData['oneDaysalary'];
               $employeeContribution=$employee-(float)$allData['oneDaysalary'];
         echo number_format($employeeContribution,2);  }else{ echo '0.00';} ?> </span> 
        
    </div> 
     <div class="item form-group col-md-3 col-sm-12 col-xs-12">
      <span><label>   Employee Deduction  :-   </label><?php if ($totalD) {
               $employeeD = $totalD+$esicOt??''; 
         echo number_format($employeeD,2);  }else{ echo '0.00';} ?> </span> 
        
    </div>   
    <div class="item form-group col-md-3 col-sm-12 col-xs-12">
       <span><label>  Employer Deduction  :-   </label><?php if ($totlaE) {
               $employerD = (float)$totlaE+(float)$esicOtemployer??''; 
         echo number_format($employerD,2);  }else{ echo '0.00';} ?> </span> 
        
    </div>  
  <div class="item form-group col-md-3 col-sm-12 col-xs-12">
      <span><label>   Total Deduction Company :-   </label><?php echo number_format(($employeeD+$employerD),2);  ?> </span> 
        
    </div>  
</div>
<?php } } elseif(!empty($emp_details->salarySlab=='0')){  
  
     if (!empty($emp_details->workerSlabData)) {
    $slab_structure= json_decode($emp_details->workerSlabData); 
       }
     if (!empty($slab_structure)) { 
 $oneLevaveSalary='';   
      if ($allData['totalLeave']>='1') {  
               $oneLevaveSalary= 1*(float)$allData['oneDaysalary'];
          }

    $total_sal=(float)$allData['empWokingSalary']+(float)$oneLevaveSalary+(float)$allData['weekoff']??'' ;  
    
      ?>
      <h4>Salary:- <?php echo number_format($total_sal,2);    ?></h4>
  <h4>Over Time Salary  :-  <?php if (!empty($allData['otSalary'])) {
                $otSalary = (float)$allData['otSalary'];  echo number_format($otSalary,2);
          }else{ echo '0.00';} ?>   </h4>   
  <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
        <thead>
            <tr>
                <th>Basic</th>
                <th>Dearness Allowance</th> 
                <th>HRA</th>
                <th>Conveyance Allowance</th>
                <th>Special Allowance</th>
                <th>Medical</th> 
                <th>Others</th>
                <th>Pay</th>

            </tr>
        </thead>
        <tbody>
            <tr class="locRow">
                <td><?php $basic=''; if(!empty($slab_structure->basic)){ $basic=$total_sal*$slab_structure->basic/100;echo number_format($basic,2); }else{echo"0.00";} ?></td>
                 <td><?php $da=''; if(!empty($slab_structure->da)){   $da=$total_sal*$slab_structure->da/100; echo number_format($da,2);}else{echo"0.00";} ?></td>
                <td><?php $hra=''; if(!empty($slab_structure->hra)){   $hra=$total_sal*$slab_structure->hra/100; echo number_format($hra,2);}else{echo"0.00";} ?></td>
                <td><?php $ca=''; if(!empty($slab_structure->ca)){   $ca=$total_sal*$slab_structure->ca/100; echo number_format($ca,2);}else{echo"0.00";} ?></td>
                <td><?php $sa=''; if(!empty($slab_structure->sa)){   $sa=$total_sal*$slab_structure->sa/100; echo number_format($sa,2);}else{echo"0.00";} ?></td>
                <td><?php $medical=''; if(!empty($slab_structure->medical)){   $medical=$total_sal*$slab_structure->medical/100; echo number_format($medical,2);}else{echo"0.00";} ?></td> 
               <!--  <td><?php $incentive=''; if(!empty($slab_structure->incentive)){ echo $incentive=$total_sal*$slab_structure->incentive/100;}else{echo"0.00";} ?></td> -->
                <td><?php $others=''; if(!empty($slab_structure->others)){   $others=$total_sal*$slab_structure->others/100; echo number_format($others,2); }else{echo"0.00";} ?></td>                 
                <td><?php  $total= (float)$basic + (float)$hra + (float)$da + (float)$ca + (float)$sa +   (float)$medical+ (float)$others; echo number_format($total,2); ?></td>

            </tr>
        </tbody>
    </table>
    <h4 style="color: #140104db;" >Employee Deduction  </h4>
    <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
        <thead>
            <tr>
                <th>ESI (Employees State Insurance Corporation)</th>
                <th>EPF (Provident Fund )</th>
                <th>TDS (Tax Deducted at Source)</th> 
                <th>LWF (Labour Welfare Fund)</th> 
                <th>Net Pay</th> 

            </tr>
        </thead>
        <tbody>
            <tr class="locRow"> 
                <td>
                  <span style="margin-left: 5px;"><label>Salary ESI Charges:-</label>
                    <?php 
                         $totalesic= (float)$basic + (float)$da + (float)$hra +(float)$ca + (float)$sa + (float)$medical+ (float)$others;
                         $esic='';
                          if(!empty($slab_structure->esic)){ 
                            if ($totalesic ) { 
                                  $esic= $totalesic*$slab_structure->esic/100; echo number_format($esic,2);
                            }else{
                                 echo $esic="0.00";
                            }
                            }else{
                                echo $esic="0.00";
                           } ?></span>
                    <span style="margin-left: 10px;"><label>OT ESI Charges:-</label>
                      <?php  
                         $esicOt='';
                          if(!empty($slab_structure->esic)){ 
                            if ((float)$allData['otSalary']) { 
                                  $esicOt= (float)$allData['otSalary']*$slab_structure->esic/100; echo number_format($esicOt,2);
                            }else{
                                 echo $esicOt="0.00";
                            }
                            }else{
                                echo $esicOt="0.00";
                           } ?></span>
                 <span style="margin-left: 10px;"><label>Total ESI Charges:-</label><?php $totalesigr=$esicOt+$esic;echo number_format(($totalesigr),2);?></span> 
                </td>
                  <td> 
                          <?php
                          $totalpf= (float)$basic ;
                            $pf=''; 
                          if(!empty($slab_structure->pf)){
                            if ($totalpf ){
                                  $pf=$totalpf*$slab_structure->pf/100; echo number_format($pf,2);
                            }else{
                                echo $pf="0.00";
                            }
                            }else{
                               echo $pf="0.00";
                             } 
                            ?>
                 </td> 
                <td><?php  $tds='';if(!empty($slab_structure->tds)){   $tds=$total_sal*$slab_structure->tds/100; echo number_format($tds,2);}else{echo"0.00";} ?>
                    
                </td> 
                <td><?php  $lwf=''; if(!empty($slab_structure->lwf)){   $lwf=$slab_structure->lwf; echo number_format($lwf,2);}else{echo"0.00";} ?></td> 
                <td><?php   $totalD=(float)$totalesigr+(float)$pf+(float)$tds+(float)$lwf; 
                                $netpay=$total-$totalD; echo number_format($netpay,2);?>
                </td> 

            </tr>
        </tbody>
    </table>
    <h4 style="color: #140104db;" >Employer Deduction</h4>
    <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
        <thead>
            <tr>
                <th>ESI (Employees State Insurance Corporation)</th>
                <th>EPF (Provident Fund )</th>
                <th>LWF (Labour Welfare Fund)</th>
                <th>Total</th>  

            </tr>
        </thead>
        <tbody>
            <tr class="locRow"> 
                <td>
                  <span style="margin-left: 5px;" ><label>Salary ESI Charges:-</label>
                    <?php 
                         $totalesic= (float)$basic + (float)$da + (float)$hra +(float)$ca + (float)$sa + (float)$medical+ (float)$others;
                         $esic_employer='';
                          if(!empty($slab_structure->esic_employer)){ 
                            if ($totalesic ) { 
                                  $esic_employer= $totalesic*$slab_structure->esic_employer/100; echo number_format($esic_employer,2);
                            }else{
                                 echo $esic_employer="0.00";
                            }
                            }else{
                                echo $esic_employer="0.00";
                           } ?></span>
                    <span  style="margin-left: 10px;" ><label>OT ESI Charges:-</label>
                      <?php  
                         $esicOtemployer='';
                          if(!empty($slab_structure->esic_employer)){ 
                            if ((float)$allData['otSalary']) { 
                                  $esicOtemployer= (float)$allData['otSalary']*$slab_structure->esic_employer/100; echo number_format($esicOtemployer,2);
                            }else{
                                 echo $esicOtemployer="0.00";
                            }
                            }else{
                                 echo $esicOtemployer="0.00";
                           } ?></span>
                 <span><label  style="margin-left: 10px;" >Total ESI Charges:-</label><?php $totalEsiCharges=$esicOtemployer+$esic_employer;
                 echo number_format($totalEsiCharges,2);?></span> 

               </td>
                <td><?php $totalpf1 = (float)$basic ;
                   $pf_employer=''; 
                   if(!empty($slab_structure->pf_employer)){ 
                    if ($totalpf1) {
                         $pf_employer=$totalpf1*$slab_structure->pf_employer/100; echo number_format($pf_employer,2);
                    }else{
                      echo  $pf_employer="0.00";
                    }
                     }else{
                    echo $pf_employer="0.00";
                    } ?>
                 </td> 
                 <td><?php $slab_structure->lwf_employer==''; if(!empty($slab_structure->lwf_employer)){ echo $slab_structure->lwf_employer; }else{echo"0.00";} ?></td>
                <td><?php    $totlaE = (float)$totalEsiCharges+(float)$pf_employer+(float)$slab_structure->lwf_employer; echo number_format($totlaE,2); ?></td> 
            </tr>
        </tbody>
    </table>
  <div  class="col-md-12 col-sm-12 col-xs-12" >
        <div class="item form-group col-md-3 col-sm-12 col-xs-12">
      <span><label> Gross Pay :- </label><?php echo $Gross= (float)$allData['grossPay'];?> </span>
       </div>
     <div class="item form-group col-md-3 col-sm-12 col-xs-12">
      <span><label>   Net Pay :-  </label><?php   $Net_Pay= (float)$netpay; echo number_format($Net_Pay,2);?></span>  
    </div>   
    <div class="item form-group col-md-3 col-sm-12 col-xs-12">
        <span><label>  Over Time Salary  :-  </label><?php if (!empty($allData['otSalary'])) {
                $otSalary = (float)$allData['otSalary']-(float)$esicOt;  echo number_format($otSalary,2);
          }else{ echo '0.00';} ?> </span> 
        
    </div> 
  <div class="item form-group col-md-3 col-sm-12 col-xs-12">
       <span><label>   Total Salary  :- </label><?php if ($total_sal) {
                $OverAllemployee = (float)$otSalary+(float)$Net_Pay;
               echo number_format($OverAllemployee,2);
          }else{ echo '0.00';} ?> </span> 
     </div> 
</div>
<div  class="col-md-12 col-sm-12 col-xs-12" >
       <div class="item form-group col-md-3 col-sm-12 col-xs-12">
       <span><label>  Employee Leave Deduction  :-   </label><?php if ($allData['totalLeave']>'1') {
               $employee = (float)$allData['totalLeave']*(float)$allData['oneDaysalary'];
               $employeeContribution=$employee-(float)$allData['oneDaysalary'];
         echo number_format($employeeContribution,2);  }else{ echo '0.00';} ?> </span> 
        
    </div> 
     <div class="item form-group col-md-3 col-sm-12 col-xs-12">
      <span><label>   Employee Deduction  :-   </label><?php if ($totalD) {
               $employeeD = $totalD+$esicOt??''; 
         echo number_format($employeeD,2);  }else{ echo '0.00';} ?> </span> 
        
    </div>   
    <div class="item form-group col-md-3 col-sm-12 col-xs-12">
       <span><label>  Employer Deduction  :-   </label><?php if ($totlaE) {
               $employerD = (float)$totlaE+(float)$esicOtemployer??''; 
         echo number_format($employerD,2);  }else{ echo '0.00';} ?> </span> 
        
    </div>  
  <div class="item form-group col-md-3 col-sm-12 col-xs-12">
      <span><label>   Total Deduction Company :-   </label><?php echo number_format(($employeeD+$employerD),2);  ?> </span> 
        
    </div>  
</div>
<?php } }?>
</ul>                   
 </div> 

</div>           
<hr>
<div class="bottom-bdr"></div>
</div>
        </div>
  
<center>
    <button class="btn edit-end-btn hidden-print" onclick="Print_data_new()"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
</center>