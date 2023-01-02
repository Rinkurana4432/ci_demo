<?php  
  $emp_details    = getNameById('user_detail',$allData['id'],'u_id'); 
  $bank_details =  json_decode($emp_details->bankDetails);
  $payment_mode  = json_decode($emp_details->paymentMode);
 $emp_sal_data = getNameById('emp_salary',$allData['id'],'emp_id');  
?>
 
			   

<div id="print_divv" class="col-md-12 col-sm-12 col-xs-12"  style="padding:0px;"> 
		<div class="table-responsive">
		       <h4 style='text-align:center'> Salary Slip<br><br> <b>LSPL</b>(Plot No.39, Industrial Area Phase 1, Panchkula, Haryana 134113)<br><br><br> </h4>
		        <h3 class="Material-head"> Employee Details :<?php if(!empty($lead) && $lead->lead_owner != 0){ 
													$leadOwner  = getNameById('user_detail',$lead->lead_owner,'u_id'); 
													if(!empty($leadOwner)) echo $leadOwner->name;
												}?><hr></h3>
		      <div class="col-md-6 col-xs-12 col-sm-6 label-left " >
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material"> Employee Code:</label>
									<div class="col-md-7 col-sm-12 col-xs-6 ">
										<div> <?php  if(!empty($emp_details->u_id)){ echo $emp_details->u_id ; }  ?></div>
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
										<div><?php if(!empty($emp_details->date_joining)) echo $emp_details->date_joining; ?></div>
									</div>
					</div>
					
                   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Department</label>
									<div class="col-md-7 col-sm-12 col-xs-6">
										<div> </div>
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
                                     <label for="material">Bank Name:</label>
									<div class="col-md-7 col-sm-12 col-xs-6">
										<div><?php if(!empty($payment_mode->bank_name)){ echo $payment_mode->bank_name; } ?> </div>
									</div>
					</div>	
                   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Bank Acc/No</label>
									<div class="col-md-7 col-sm-12 col-xs-6">
										<div><?php if(!empty($payment_mode->account_no)){ echo $payment_mode->account_no; } ?></div>
									</div>
					</div> 
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">PF No:</label>
									<div class="col-md-7 col-sm-12 col-xs-6">
										<div> <?php if(!empty($bank_details->pf_number)){ echo $bank_details->pf_number; } ?> </div>
					             	</div>
					</div>
				  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">UAN No:</label>
									<div class="col-md-7 col-sm-12 col-xs-6">
										<div> <?php if(!empty($bank_details->uan_number)){ echo $bank_details->uan_number; } ?> </div>
					             	</div>
					</div>
				 <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">ESI No:</label>
									<div class="col-md-7 col-sm-12 col-xs-6">
										<div> <?php if(!empty($bank_details->include_esi)){ echo $bank_details->include_esi; } ?> </div>
					             	</div>
					</div>
		    	 <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                         <label for="material">PAN No:</label>
									<div class="col-md-7 col-sm-12 col-xs-6">
										<div> <?php if(!empty($bank_details->pan_number)){ echo $bank_details->pan_number; } ?> </div>
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
  if(!empty($emp_sal_data->slab_id!='0')){
   $salary_slabs =   getNameById('salary_slab',$emp_sal_data->slab_id,'id');
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
      <h4>Salary:- <?php echo number_format($total_sal,2); ?></h4>
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
                <td><?php $basic=''; if(!empty($slab_structure->basic)){   $basic=$total_sal*$slab_structure->basic/100; }else{echo"0.00";}
                echo number_format($basic,2); ?></td>
                 <td><?php $da=''; if(!empty($slab_structure->da)){   $da=$total_sal*$slab_structure->da/100;}else{echo"0.00";}  
                 echo number_format($da,2); ?></td>
                <td><?php $hra=''; if(!empty($slab_structure->hra)){   $hra=$total_sal*$slab_structure->hra/100;}else{echo"0.00";} echo number_format($hra,2);?></td>
                <td><?php $ca=''; if(!empty($slab_structure->ca)){   $ca=$total_sal*$slab_structure->ca/100;}else{echo"0.00";} echo number_format($ca,2); ?></td>
                <td><?php $sa=''; if(!empty($slab_structure->sa)){   $sa=$total_sal*$slab_structure->sa/100;}else{echo"0.00";} echo number_format($sa,2);?></td>
                <td><?php $medical=''; if(!empty($slab_structure->medical)){   $medical=$total_sal*$slab_structure->medical/100;}else{echo"0.00";} echo number_format($medical,2);?></td> 
               <!--  <td><?php $incentive=''; if(!empty($slab_structure->incentive)){ echo $incentive=$total_sal*$slab_structure->incentive/100;}else{echo"0.00";} ?></td> -->
                <td><?php $others=''; if(!empty($slab_structure->others)){   $others=$total_sal*$slab_structure->others/100;}else{echo"0.00";} echo number_format($others,2);?></td>                 
                <td><?php      $total= (float)$basic + (float)$hra + (float)$da + (float)$ca + (float)$sa +   (float)$medical+ (float)$others;  echo number_format($total,2); ?></td>

            </tr>
        </tbody>
    </table>
     <h4 style="color: #140104db;" >Employee Contribution </h4>
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
                <td> <?php   
                $totalesi= (float)$basic + (float)$hra +(float)$da + (float)$ca + (float)$sa + (float)$medical+ (float)$others; 
                         $esic='';
                          if(!empty($slab_structure->esic)){ 
                            if ($totalesi) {
                                  $esic=$totalesi*$slab_structure->esic/100;
                            }else{
                                   $esic="0.00";
                            }
                            }else{
                                  $esic="0.00";
                            } echo number_format($esic,2);?>
                 </td>
                  <td> 
                          <?php 
                          $totalpf = (float)$basic;
                            $pf=''; 
                          if(!empty($slab_structure->pf)){
                            if ($totalpf){
                                  $pf=$totalpf*$slab_structure->pf/100; 
                            }else{
                                  $pf="0.00";
                            }
                            }else{
                                 $pf="0.00";
                             } 
                             echo number_format($pf,2);
                            ?>
                 </td> 
                <td><?php  $tds='';if(!empty($slab_structure->tds)){   $tds=$total_sal*$slab_structure->tds/100;}else{echo"0.00";} echo number_format($tds,2);?>
                    
                </td> 
                <td><?php  $lwf=''; if(!empty($slab_structure->lwf)){   $lwf=$slab_structure->lwf;}else{echo"0.00";} echo number_format($lwf,2); ?></td> 
                <td><?php   $totalD=(float)$esic+(float)$pf+(float)$tds+(float)$lwf; 
                                $netpay=$total-$totalD; echo number_format($netpay,2);?>
                </td> 

            </tr>
        </tbody>
    </table>
    <h4 style="color: #140104db;" >Employer Contribution</h4>
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
                <?php $totalpf1= (float)$basic + (float)$da + (float)$hra + (float)$ca + (float)$sa +  (float)$medical+ (float)$others;?>
                <td><?php $esic_employer=''; 
                  if(!empty($slab_structure->esic_employer)){
                    if ($totalpf1) {
                           $esic_employer=$totalpf1*$slab_structure->esic_employer/100;
                    }else{
                          $esic_employer="0.00";
                    }
                   }else{
                      $esic_employer="0.00";
                    } echo number_format($esic_employer,2);
                     ?></td>
                <td><?php $totalpf1= (float)$basic;
                   $pf_employer=''; 
                   if(!empty($slab_structure->pf_employer)){ 
                    if ($totalpf1) {
                         $pf_employer=$totalpf1*$slab_structure->pf_employer/100;
                    }else{
                         $pf_employer="0.00";
                    }
                     }else{
                      $pf_employer="0.00";
                    } echo number_format($pf_employer,2);?>
                 </td> 
                 <td><?php $slab_structure->lwf_employer==''; if(!empty($slab_structure->lwf_employer)){ echo $slab_structure->lwf_employer;}else{echo"0.00";} ?></td>
                <td><?php    $totlaE = (float)$esic_employer+(float)$pf_employer+(float)$slab_structure->lwf_employer; echo number_format($totlaE,2); ?></td> 
            </tr>
        </tbody>
    </table>
  <div  class="col-md-12 col-sm-12 col-xs-12" >
        <div class="item form-group col-md-3 col-sm-12 col-xs-12">
      <span><label> Gross Pay :- </label><?php   $Gross= (float)$allData['grossPay']; echo number_format($Gross,2);?> </span>
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
<?php } }  elseif ($emp_sal_data->slab_id=='0') {  
  if(!empty($emp_sal_data->salary_details)){ 
   $slab_structure = json_decode($emp_sal_data->salary_details);   
if (!empty($slab_structure)) { 
 $oneLevaveSalary='';   
      if ($allData['totalLeave']>='1') {  
               $oneLevaveSalary= 1*(float)$allData['oneDaysalary'];
          }

    $total_sal=(float)$allData['empWokingSalary']+(float)$oneLevaveSalary+(float)$allData['weekoff']??'' ;  
      ?>
      <h4>Salary:- <?php echo number_format($total_sal,2); ?></h4>
    <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
        <thead>
            <tr>
                <th>Basic</th>
                <th>Dearness Allowance</th>
                <th>HRA</th>
                <th>Conveyance Allowance</th>
                <th>Special Allowance</th>
                <th>Medical</th>
                <!-- <th>Incentives</th> -->
                <th>Others</th>
                <th>Gross Pay</th>

            </tr>
        </thead>
        <tbody>
            <tr class="locRow">
                <td><?php $basic=''; if(!empty($slab_structure->basic)){   $basic=$total_sal*$slab_structure->basic/100;}else{echo"0.00";} echo number_format($basic,2);?></td>
                 <td><?php $da=''; if(!empty($slab_structure->da)){   $da=$total_sal*$slab_structure->da/100;}else{echo"0.00";}echo number_format($da,2); ?></td>
                <td><?php $hra=''; if(!empty($slab_structure->hra)){   $hra=$total_sal*$slab_structure->hra/100;}else{echo"0.00";} echo number_format($basic,2);?></td>
                <td><?php $ca=''; if(!empty($slab_structure->ca)){   $ca=$total_sal*$slab_structure->ca/100;}else{echo"0.00";} echo number_format($ca,2);?></td>
                <td><?php $sa=''; if(!empty($slab_structure->sa)){   $sa=$total_sal*$slab_structure->sa/100;}else{echo"0.00";}echo number_format($sa,2); ?></td>
                <td><?php $medical=''; if(!empty($slab_structure->medical)){   $medical=$total_sal*$slab_structure->medical/100;}else{echo"0.00";} echo number_format($medical,2);?></td> 
               <!--  <td><?php $incentive=''; if(!empty($slab_structure->incentive)){ echo $incentive=$total_sal*$slab_structure->incentive/100;}else{echo"0.00";} ?></td> -->
                <td><?php $others=''; if(!empty($slab_structure->others)){   $others=$total_sal*$slab_structure->others/100;}else{echo"0.00";} echo number_format($others,2);?></td>                 
                <td><?php      $total= (float)$basic + (float)$hra + (float)$da + (float)$ca + (float)$sa +   (float)$medical+ (float)$others;  echo number_format($total,2);?></td>

            </tr>
        </tbody>
    </table>
     <h4 style="color: #140104db;" >Employee Contribution </h4>
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
                <td> <?php   
                $totalesi= (float)$basic + (float)$hra +(float)$da + (float)$ca + (float)$sa + (float)$medical+ (float)$others; 
                         $esic='';
                          if(!empty($slab_structure->esic)){ 
                            if ($totalesi) {
                                  $esic=$totalesi*$slab_structure->esic/100;
                            }else{
                                   $esic="0.00";
                            }
                            }else{
                                  $esic="0.00";
                            } echo number_format($esic,2);?>
                 </td>
                  <td> 
                          <?php 
                          $totalpf = (float)$basic;
                            $pf=''; 
                          if(!empty($slab_structure->pf)){
                            if ($totalpf){
                                  $pf=$totalpf*$slab_structure->pf/100; 
                            }else{
                                  $pf="0.00";
                            }
                            }else{
                                 $pf="0.00";
                             } 
                             echo number_format($pf,2);
                            ?>
                 </td> 
                <td><?php  $tds='';if(!empty($slab_structure->tds)){   $tds=$total_sal*$slab_structure->tds/100;}else{echo"0.00";} echo number_format($tds,2);?>
                    
                </td> 
                <td><?php  $lwf=''; if(!empty($slab_structure->lwf)){ echo $lwf=$slab_structure->lwf;}else{echo"0.00";} ?></td> 
                <td><?php   $totalD=(float)$esic+(float)$pf+(float)$tds+(float)$lwf; 
                                $netpay=$total-$totalD; echo number_format($netpay,2);?>
                </td> 

            </tr>
        </tbody>
    </table>
    <h4 style="color: #140104db;" >Employer Contribution</h4>
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
                <?php $totalpf1= (float)$basic + (float)$da + (float)$hra + (float)$ca + (float)$sa +  (float)$medical+ (float)$others;?>
                <td><?php $esic_employer=''; 
                  if(!empty($slab_structure->esic_employer)){
                    if ($totalpf1) {
                           $esic_employer=$totalpf1*$slab_structure->esic_employer/100;
                    }else{
                          $esic_employer="0.00";
                    }
                   }else{
                      $esic_employer="0.00";
                    } echo number_format($esic_employer,2);
                     ?></td>
                <td><?php $totalpf1= (float)$basic;
                   $pf_employer=''; 
                   if(!empty($slab_structure->pf_employer)){ 
                    if ($totalpf1) {
                         $pf_employer=$totalpf1*$slab_structure->pf_employer/100;
                    }else{
                         $pf_employer="0.00";
                    }
                     }else{
                        $pf_employer=" 0.00 ";
                    } echo number_format($pf_employer,2); ?>
                 </td> 
                 <td><?php $slab_structure->lwf_employer==''; if(!empty($slab_structure->lwf_employer)){ echo $slab_structure->lwf_employer;}else{echo"0.00";} ?></td>
                <td><?php    $totlaE = (float)$esic_employer+(float)$pf_employer+(float)$slab_structure->lwf_employer; echo number_format((float)$totlaE,2); ?></td> 
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
<?php } } } ?>
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