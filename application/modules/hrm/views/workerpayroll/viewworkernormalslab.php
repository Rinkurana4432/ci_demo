<?php    
  $emp_details    = getNameById('worker',$allData['worker_id'],'id');  
 $empslab=getNameById('workermonthalislab',$allData['id'],'id');
 $slab=json_decode($empslab->slabinfo);
 
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
   
  <h4>Gross Salary:-  </h4> 
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
                <td><?=$slab->basic??'';?></td>
                <td><?=$slab->da??'';?></td>
                <td><?=$slab->hra??'';?></td>
                <td><?=$slab->ca??'';?></td>
                <td><?=$slab->sa??'';?></td>
                <td><?=$slab->medical??'';?></td> 
                <td><?=$slab->others??'';?></td>
                <td><?=$slab->basic??'';?></td>

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
                <td><?=$slab->employee_esi??'';?></td>
                <td><?=$slab->employee_pf??'';?></td> 
                <td><?=$slab->employee_tds??'';?></td> 
                <td><?=$slab->employee_lwf??'';?></td> 
                <td><?=$slab->netpay??'';?></td> 

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
                <td><?=$slab->employer_esi??'';?></td>
                <td><?=$slab->employer_pf??'';?></td> 
                <td><?=$slab->employer_lwf??'';?></td>
                <td><?=$slab->employerdeduction??'';?></td> 
            </tr>
        </tbody>
    </table>

  <div  class="col-md-12 col-sm-12 col-xs-12" >
        <div class="item form-group col-md-2 col-sm-12 col-xs-12">
       Gross Pay :-  <h5> <?=$empslab->grossPay??'';?></h5> 
       </div>
     <div class="item form-group col-md-2 col-sm-12 col-xs-12">
        Net Pay :-  <h5 id="netpay2"> <?=$empslab->netpay??'';?></h5>  
    </div> 
    
    <div class="item form-group col-md-2 col-sm-12 col-xs-12">
        Employee Deduction  :-   <h5><?=$slab->employerdeduction??'';?></h5> 
        
    </div> 
    <div class="item form-group col-md-2 col-sm-12 col-xs-12">
         Over Time Salary  :-  <h5> <?=$empslab->otSalary??'';?></h5> 
        
  </div> 
  <div class="item form-group col-md-2 col-sm-12 col-xs-12">
         Total Salary  :- <h5><?=$empslab->grossPay??'';?> </h5> 
        
    </div> 
</div>
 
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