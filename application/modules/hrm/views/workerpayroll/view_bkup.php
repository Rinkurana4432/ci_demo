<?php   
  $emp_details    = getNameById('worker',$allData['id'],'id');  
 // pre($emp_details);
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
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Days Worked:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6">
                                            <div> <?php if(!empty($total_worked_paid_days_arr)){ echo $total_worked_paid_days_arr; } ?>
                                    </div>
                                    </div>
                    </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Total Paid Days: </label>
                                    <div class="col-md-7 col-sm-12 col-xs-6">
                                            <div> <?php if(!empty($allData['empWokingDays'])){ echo $allData['empWokingDays']; }else{echo 'N/A';} ?>
                                    </div>
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
                                        <div> <?php if(!empty($emp_details->uan_number)){ echo $emp_details->uan_number; } ?> </div>
                                    </div>
                    </div>
                 <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">ESI No:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6">
                                        <div> <?php if(!empty($emp_details->include_esi)){ echo $emp_details->include_esi; } ?> </div>
                                    </div>
                    </div>
                 <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">PAN No:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6">
                                        <div> <?php if(!empty($emp_details->panNo)){ echo $emp_details->panNo; } ?> </div>
                                    </div>
                    </div>
                 <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                      <label for="material">LOP :</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6">
                                        <div> <?php   echo 1;   ?> </div>
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
  if(!empty($emp_details->salarySlab)){
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
                <td><?php $basic=''; if(!empty($slab_structure->basic)){ echo $basic=$total_sal*$slab_structure->basic/100; }else{echo"0.00";} ?></td>
                 <td><?php $da=''; if(!empty($slab_structure->da)){ echo $da=$total_sal*$slab_structure->da/100;}else{echo"0.00";} ?></td>
                <td><?php $hra=''; if(!empty($slab_structure->hra)){ echo $hra=$total_sal*$slab_structure->hra/100;}else{echo"0.00";} ?></td>
                <td><?php $ca=''; if(!empty($slab_structure->ca)){ echo $ca=$total_sal*$slab_structure->ca/100;}else{echo"0.00";} ?></td>
                <td><?php $sa=''; if(!empty($slab_structure->sa)){ echo $sa=$total_sal*$slab_structure->sa/100;}else{echo"0.00";} ?></td>
                <td><?php $medical=''; if(!empty($slab_structure->medical)){ echo $medical=$total_sal*$slab_structure->medical/100;}else{echo"0.00";} ?></td> 
               <!--  <td><?php $incentive=''; if(!empty($slab_structure->incentive)){ echo $incentive=$total_sal*$slab_structure->incentive/100;}else{echo"0.00";} ?></td> -->
                <td><?php $others=''; if(!empty($slab_structure->others)){ echo $others=$total_sal*$slab_structure->others/100;}else{echo"0.00";} ?></td>                 
                <td><?php    echo $total= (float)$basic + (float)$hra + (float)$da + (float)$ca + (float)$sa +   (float)$medical+ (float)$others;  ?></td>

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
                    <?php 
                    $totalesic= (float)$basic + (float)$da + (float)$hra +(float)$ca + (float)$sa + (float)$medical+ (float)$others;
                         $esic='';
                          if(!empty($slab_structure->esic)){ 
                            if ($totalesic ) { 
                                echo $esic= $totalesic*$slab_structure->esic/100;
                            }else{
                                 echo $esic="0.00";
                            }
                            }else{
                                echo $esic="0.00";
                            } ?>
                 </td>
                  <td> 
                          <?php
                          $totalpf= (float)$basic + (float)$da + (float)$ca + (float)$sa + (float)$medical+ (float)$others;
                            $pf=''; 
                          if(!empty($slab_structure->pf)){
                            if ($totalpf ){
                                echo $pf=$totalpf*$slab_structure->pf/100; 
                            }else{
                                echo $pf="0.00";
                            }
                            }else{
                               echo $pf="0.00";
                             } 
                            ?>
                 </td> 
                <td><?php  $tds='';if(!empty($slab_structure->tds)){ echo $tds=$total_sal*$slab_structure->tds/100;}else{echo"0.00";} ?>
                    
                </td> 
                <td><?php  $lwf=''; if(!empty($slab_structure->lwf)){ echo $lwf=$slab_structure->lwf;}else{echo"0.00";} ?></td> 
                <td><?php   $totalD=(float)$esic+(float)$pf+(float)$tds+(float)$lwf; 
                              echo $netpay=$total-$totalD?>
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
                <?php $totalesic1 = (float)$basic + (float)$da + (float)$hra +(float)$ca + (float)$sa + (float)$medical+ (float)$others; ?>
                <td><?php $esic_employer=''; 
                  if(!empty($slab_structure->esic_employer)){
                    if ($totalesic1 ) {
                         echo $esic_employer=$totalesic1*$slab_structure->esic_employer/100;
                    }else{
                        echo $esic_employer="0.00";
                    }
                   }else{
                    echo $esic_employer="0.00";
                    }
                     ?></td>
                <td><?php $totalpf1 = (float)$basic + (float)$da +  (float)$ca + (float)$sa + (float)$medical+ (float)$others;
                   $pf_employer=''; 
                   if(!empty($slab_structure->pf_employer)){ 
                    if ($totalpf1) {
                       echo $pf_employer=$totalpf1*$slab_structure->pf_employer/100;
                    }else{
                      echo  $pf_employer="0.00";
                    }
                     }else{
                    echo $pf_employer="0.00";
                    } ?>
                 </td> 
                 <td><?php $slab_structure->lwf_employer==''; if(!empty($slab_structure->lwf_employer)){ echo $slab_structure->lwf_employer;}else{echo"0.00";} ?></td>
                <td><?php  echo $totlaE = (float)$esic_employer+(float)$pf_employer+(float)$slab_structure->lwf_employer;  ?></td> 
            </tr>
        </tbody>
    </table>
  <div  class="col-md-12 col-sm-12 col-xs-12" >
        <div class="item form-group col-md-2 col-sm-12 col-xs-12">
       Gross Pay :-  <h5><?php echo $Gross= (float)$allData['grossPay'];?> </h5> 
       </div>
     <div class="item form-group col-md-2 col-sm-12 col-xs-12">
        Net Pay :-  <h5><?php echo $Net_Pay= (float)$netpay;?></h5>  
    </div> 
    
    <div class="item form-group col-md-2 col-sm-12 col-xs-12">
        Employee Deduction  :-   <h5><?php if ($allData['totalLeave']>'1') {
               $employee = (float)$allData['totalLeave']*(float)$allData['oneDaysalary'];
             echo $employeeContribution=$employee-(float)$allData['oneDaysalary'];
          }else{ echo '0.00';} ?> </h5> 
        
    </div> 
    <div class="item form-group col-md-2 col-sm-12 col-xs-12">
         Over Time Salary  :-  <h5><?php if (!empty($allData['otSalary'])) {
              echo $otSalary = (float)$allData['otSalary'];
          }else{ echo '0.00';} ?> </h5> 
        
  </div> 
  <div class="item form-group col-md-2 col-sm-12 col-xs-12">
         Total Salary  :- <h5><?php if ($total_sal) {
             echo  $OverAllemployee = (float)$otSalary+(float)$total_sal;
               
          }else{ echo '0.00';} ?> </h5> 
        
    </div> 
</div>
<?php } } else{ ?>
  <?php $oneLevaveSalary='';   
      if ($allData['totalLeave']>='1') {  
               $oneLevaveSalary= 1*(float)$allData['oneDaysalary'];
          }

    $total_sal=(float)$allData['empWokingSalary']+(float)$oneLevaveSalary+(float)$allData['weekoff']??'' ;  
      ?>
  <h4>Gross Salary:- <?php  echo number_format($total_sal,2);    ?></h4>
  <form action="<?=base_url();?>hrm/workermonthalyslab" method="post" >
    <input type="hidden" name="worker_id" id="workerid" value="<?=$allData['id']??'';?>">
   <input type="hidden" name="empWokingSalary" id="empWokingSalary" value="<?=$allData['empWokingSalary']??'';?>">
   <input type="hidden" name="grossPay" id="grossPay" value="<?=$allData['grossPay']??'';?>">
   <input type="hidden" name="workingdays" id="workingdays" value="<?=$allData['empWokingDays']??'';?>">
   <input type="hidden" name="weekoff" id="weekoff" value="<?=$allData['weekoff']??'';?>">
   <input type="hidden" name="totalLeave" id="totalLeave" value="<?=$allData['totalLeave']??'';?>"> 
   <input type="hidden" name="oneDaysalary" id="oneDaysalary" value="<?=$allData['oneDaysalary']??'';?>">
   <input type="hidden" name="otSalary" id="otSalary" value="<?=$allData['otSalary']??'';?>">
      <input type="hidden" name="monthYear" id="monthYear" value="<?=$allData['monthYear']??'';?>">
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
                <th>Gross Pay</th>

            </tr>
        </thead>
        <tbody>
            <tr class="locRow">
                <td><input type="text" name="basic" id="basic" class="form-control col-md-7 col-xs-12" placeholder="Enter Basic" onkeyup="checkchargesworkerSlab()"></td>
                <td><input type="text" name="da" id="da" class="form-control col-md-7 col-xs-12" placeholder="Enter DA" onkeyup="checkchargesworkerSlab()"></td>
                <td><input type="text" name="hra" id="hra" class="form-control col-md-7 col-xs-12" placeholder="Enter HRA" onkeyup="checkchargesworkerSlab()"></td>
                <td><input type="text" name="ca" id="ca" class="form-control col-md-7 col-xs-12" placeholder="Enter CA" onkeyup="checkchargesworkerSlab()"></td>
                <td><input type="text" name="sa" id="sa" class="form-control col-md-7 col-xs-12" placeholder="Enter SA" onkeyup="checkchargesworkerSlab()"></td>
                <td><input type="text" name="medical" id="medical" class="form-control col-md-7 col-xs-12" placeholder="Enter Medical" onkeyup="checkchargesworkerSlab()"></td> 
                <td><input type="text" name="others" id="others" class="form-control col-md-7 col-xs-12" placeholder="Enter Others" onkeyup="checkchargesworkerSlab()"></td>
                <td><input type="text"   id="totalGr" class="form-control col-md-7 col-xs-12" placeholder="Total" readonly ></td>

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
                <td><input type="text" name="employee_esi" id="employee_esi" class="form-control col-md-7 col-xs-12" onkeyup="checkchargesworkerSlab()" placeholder="Enter Employees ESI"></td>
                <td><input type="text" name="employee_pf" id="employee_pf" class="form-control col-md-7 col-xs-12" onkeyup="checkchargesworkerSlab()" placeholder="Enter Employees EPF"></td> 
                <td><input type="text" name="employee_tds" id="employee_tds" class="form-control col-md-7 col-xs-12" onkeyup="checkchargesworkerSlab()" placeholder="Enter Employees TDS"></td> 
                <td><input type="text" name="employee_lwf" id="employee_lwf" class="form-control col-md-7 col-xs-12" onkeyup="checkchargesworkerSlab()" placeholder="Enter Employees LWF"></td> 
                <td><input type="text" name="netpay" id="netpay" class="form-control col-md-7 col-xs-12" placeholder="NET Pay" readonly></td> 

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
                <td><input type="text" name="employer_esi" id="employer_esi" onkeyup="checkchargesworkerSlab()" class="form-control col-md-7 col-xs-12" placeholder="Enter Employer ESI"></td>
                <td><input type="text" name="employer_pf" id="employer_pf" onkeyup="checkchargesworkerSlab()" class="form-control col-md-7 col-xs-12" placeholder="Enter Employer EPF"></td> 
                <td><input type="text" name="employer_lwf" id="employer_lwf" onkeyup="checkchargesworkerSlab()" class="form-control col-md-7 col-xs-12" placeholder="Enter Employer LWF"></td>
                <td><input type="text" name="employerdeduction" id="employerdeduction" class="form-control col-md-7 col-xs-12" placeholder="Employer Deduction"></td> 
            </tr>
        </tbody>
    </table>

  <div  class="col-md-12 col-sm-12 col-xs-12" >
        <div class="item form-group col-md-2 col-sm-12 col-xs-12">
       Gross Pay :-  <h5><?php echo $Gross= (float)$allData['grossPay'];?> </h5> 
       </div>
     <div class="item form-group col-md-2 col-sm-12 col-xs-12">
        Net Pay :-  <h5 id="netpay2"></h5>  
    </div> 
    
    <div class="item form-group col-md-2 col-sm-12 col-xs-12">
        Employee Deduction  :-   <h5><?php if ($allData['totalLeave']>'1') {
               $employee = (float)$allData['totalLeave']*(float)$allData['oneDaysalary'];
             echo $employeeContribution=$employee-(float)$allData['oneDaysalary'];
          }else{ echo '0.00';} ?> </h5> 
        
    </div> 
    <div class="item form-group col-md-2 col-sm-12 col-xs-12">
         Over Time Salary  :-  <h5><?php if (!empty($allData['otSalary'])) {
              echo $otSalary = (float)$allData['otSalary'];
          }else{ echo '0.00';} ?> </h5> 
        
  </div> 
  <div class="item form-group col-md-2 col-sm-12 col-xs-12">
         Total Salary  :- <h5> </h5> 
        
    </div> 
</div>
   <input type="submit" class="btn edit-end-btn" >   
 </form>
<?php } ?>
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