
<?php if($this->session->flashdata('message') != ''){?>  
<div class="alert alert-success col-md-6"> 
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
<div class="x_content">
   <div class="row hidde_cls">
    <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
        <a href="<?=base_url();?>hrm/attendanceBiometric">Refresh</a>
    <form action="worker_process_payroll" method="post" id="date_range" style="display: flex;">   
                                            <select required name="month" size="1" class="form-control" style=" border-color: #313f4d !important;">
                                            <option value="">Month</option>
                                            <option value="1">January</option>
                                            <option value="2">Feb</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                            </select>
                                            <input class="btn btn-form-control"  type="submit" style="margin: 0px;"> 
          </form>
      </div>
    </div>
      <div class="col-md-12  export_div">
         <div class="col-md-4 col-xs-12 col-sm-6 datePick-left" style="position:unset;">
            
            <?php  if(!empty($start_date)){ ?>
            <h4   style="margin-top: 0px;">Showing Results  <?php echo "From :  ".$start_date ."      To :   ". $end_date ?> </h4>
            <?php } ?>
         </div> 
       </div>
   </div> 
   <div class="total-box">
    <?php 
      $weekOff = [];      
            if (!empty($week_off_emp)) { 
             foreach ($week_off_emp as $weekkey => $weekOffValue) {               
                if ($weekOffValue->day=='1'  || $weekOffValue->day=='2' || $weekOffValue->day=='3' || $weekOffValue->day=='4' || $weekOffValue->day=='5' || $weekOffValue->day=='6' || $weekOffValue->day=='7') {
                        $date = $start_end_date_summary['start_date'];
                        $first_day = date('N',strtotime($date));
                        $first_day = $weekOffValue->day - $first_day + 1;
                        $last_day =  date('t',strtotime($date)); 
                    for($i=$first_day; $i<=$last_day; $i=$i+7 ){
                      $weekOff[$weekOffValue->day][] = $i; 
                    } 
                  
                }elseif($weekOffValue->day=='9'){
                         $date = $start_end_date_summary['start_date'];
                         $month = date('M',strtotime($date)); 
                         $secondSat[]=date('d', strtotime('Second sat of '.$month.' 2021'));
                         $secondSat[]=date('d', strtotime('Fourth sat of '.$month.' 2021'));
                         $weekOff[$weekOffValue->day] = $secondSat;
                 }elseif($weekOffValue->day=='10'){
                          $date = $start_end_date_summary['start_date'];
                          $month = date('M',strtotime($date)); 
                         $fifth[]=date('d', strtotime('First sat of '.$month.' 2021'));
                         $fifth[]=date('d', strtotime('Third sat of '.$month.' 2021'));                        
                         $weekOff[$weekOffValue->day] = $fifth;
                } 
              } 
            }
             $finalWeekend = array();
             if (!empty($weekOff)) { 
               foreach ($weekOff as $key => $weekends) {
                foreach ($weekends as $key1 => $weekvalue) {
                   $finalWeekend[] = $weekvalue;
                }               
              }
             }
            $Holidaysdatas = [];
            if (!empty($holidays)) {
            foreach ($holidays as $holkey => $holidayvalue) {  
                  $Holidaysdatas[]= date('d',strtotime($holidayvalue->from_date));

             } 
           }
             $alla= array_merge($finalWeekend??'',$Holidaysdatas??''); 
             $allWeek=array_unique($alla);
            $allholidays= count($allWeek);
            if(!empty($work_days)){
             $workingDays=$work_days-$allholidays;
           }
         if (!empty($workingDays) ) {?>
               <b> <?php  echo 'Total Days : '.$work_days??''."<br>";  ?>  </b>
              <b> <?php  echo 'Total Working Days : '.$workingDays??''."<br>";  ?>  </b> 
      <?php   }  ?> 
  </div>
  <table id="attendance1231" class="table table-striped table-bordered account_index" cellspacing="0" width="100%"  >
      <thead>
        <tr>
            <th>Worker Name</th>
            <th>Worker Code</th>
            <th>Worker Salary</th>
            <th>Office Working Days </th>
            <th>Paid Leave </th>
            <th>LOP </th>
            <th>Emp Working Days</th>
            <th>Without OT Salary</th> 
            <th>Worker OT HRS</th>
            <th>With  OT Salary</th>
            <th>Salary</th>
            <th>Total Salary</th>
            <th> </th>
        </tr>
     </thead>
          <tbody>
            <?php  
            
       if (!empty($get_attendance_p_a)) { 
        $workerOtHrs = $this->hrm_model->get_compdata('company_detail',array('id'=> $this->companyGroupId));
        $workerOtHrsValue=$workerOtHrs[0]['hrm_worker_ot_salary'];
            foreach ($get_attendance_p_a as $empKey => $empDataValue) { 
                      $empWorkingDays=count($empDataValue);
                      $empDatales = getNameById('worker',$empKey,'id'); 
                       
                       $allsalary='';
                       $overallOtSalary='';
                         foreach ($empDataValue as $key => $workervalue) { 
                             
                          } 
                      $start = date('Y-m-d ',strtotime($start_date));
                      $end =date('Y-m-d ',strtotime($end_date));
                      $where2 = "leave_status = 'Approve' AND em_id = '{$empKey}' AND start_date >= '{$start}' AND end_date <= '{$end}'";  
                      $empleaveData  = $this->hrm_model->get_worker_data('work_leave',$where2);
                     $allweek = 0;
                     foreach ($empleaveData as $key => $WorkerLeavevalue) {
                        $date1=date_create($WorkerLeavevalue['start_date']);
                        $date2=date_create($WorkerLeavevalue['end_date']);
                        $diff=date_diff($date1,$date2);
                        $alldays = $diff->format("%R%a");
                        $allweek +=(float)$alldays+'1';
                     } 
                     // $allweek= count($empleaveData);
                      // $emp_sal = getNameById('emp_salary',$empKey,'emp_id');
                      
 
         ?>
           <tr>
                  <td><a href="javascript:void(0)"  id="<?=$empKey??'';?>" start="<?=$start_date??''?>" end="<?=$end_date??''?>" class="workerviewAtt  btn-xs" ><?= ($empDatales->name)?$empDatales->name:'N/A'; ?></a></td>
                  <td><?php if (!empty($empKey)) { echo $empKey;}else{echo'NA';}?></td>
                  <td><?php if (!empty($empDatales->salary)) { echo $empDatales->salary;}else{echo'0.00';}?> </td>
                  <td><?php if(!empty($workingDays)){echo $workingDays; }   ?></td>
                  <td><?php if(!empty($allweek)){ if ($allweek==1) {  echo $allweek; }elseif ($allweek>1) {  echo '1'; } }else{echo '0';} ?></td>
                  <td><?php if(!empty($allweek)){ if ($allweek>1) {  echo $allweek-1;  }elseif ($allweek=1) {  echo '0';  } }else{echo '0';} ?></td>
                  <td><a href="javascript:void(0)"  id="<?=$empKey??'';?>" start="<?=$start_date??''?>" end="<?=$end_date??''?>" class="workerviewAtt  btn-xs" ><?php if(!empty($empWorkingDays)){echo $empWorkingDays; }  ?></a></td>
                  <td><?php 
                                      $salaryOneDay = $empDatales->salary/$work_days;
                                     $allsalary=$workerOvertime = $overallOtSalary=0; 
                                     foreach ($empDataValue as  $Empvalue) {  
                                      $Empkey=$Empvalue['emp_id'];
                                      $startdate=$Empvalue['atten_date'];
                                      //$where= "('{$startdate}' between shiftChangeStartDate AND employeeShiftEndDate) AND employeeId = {$Empkey}"; 
                            $where = "employeeId = '{$Empkey}' AND shiftChangeStartDate >= '{$start_date}' AND employeeShiftEndDate <= '{$end_date}'";  
                                       $employeeData  = $this->hrm_model->get_worker_data('workershiftChange',$where);
                                        foreach ($employeeData as $employeeshift) { 
                                           $shiftNameTime = getNameById('production_setting',$employeeshift['shift_id'],'id');
                                           $hrs= explode('h', $Empvalue['working_hour']);
                                             $empWorkingHrsNew=$shiftNameTime->working_hrs;
                                              $oneHrsSalary = $salaryOneDay/$empWorkingHrsNew; 

                                            if ((float)$Empvalue['working_hour'] > (float)$shiftNameTime->working_hrs) {
                                                 $overTime=(float)$Empvalue['working_hour']-(float)$shiftNameTime->working_hrs;
                                                  $workerOvertime +=$overTime;   
                                          } 

                                          if(!empty($salaryOneDay)){ $oneHrssalary=$salaryOneDay/(float)$shiftNameTime->working_hrs;  
                                           if ((float)$Empvalue['working_hour'] > (float)$shiftNameTime->working_hrs) {
                                            $overTime2=(float)$Empvalue['working_hour']-(float)$shiftNameTime->working_hrs;
                                            $otSalary= $oneHrssalary * $overTime2; 
                                             $overallOtSalary +=$otSalary; 
                                            }  
                                         }  
                                         if((float)$hrs[0] == (float)1 || (float)$hrs[0] == (float)2 || (float)$hrs[0] == (float)3 || (float)$hrs[0] == (float)4 || (float)$hrs[0] == (float)5 || (float)$hrs[0] == (float)6) {
                                             $allsalary +=(float)$hrs[0]*(float)($oneHrsSalary);
                                         }elseif((float)$hrs[0] >= (float)7) {
                                            $allsalary +=(float)$empWorkingHrsNew*(float)($oneHrsSalary);
                                         }
                                      }
                                   }  
                                  if(!empty($empDatales->salary)) {       
                                       if($empWorkingDays > $workingDays){ 
                                           $weekendsalary=$allholidays*$salaryOneDay??''; 
                                           echo number_format(($allsalary),2); 
                                        }elseif($empWorkingDays > $workingDays-'2' ||$empWorkingDays >= $workingDays-'3' ||$empWorkingDays >= $workingDays-'4' ||$empWorkingDays >= $workingDays-'5' ||$empWorkingDays >= $workingDays-'6'){ 
                                        
                                          $weekendsalary=$allholidays*$salaryOneDay??''; 
                                          echo number_format(($allsalary),2); 
                                         }elseif($empWorkingDays >= $workingDays-'11'){
                                           
                                           $weekendsalary='2'*$salaryOneDay ?? ''; 
                                            echo number_format(($allsalary),2);  
                                          }elseif($empWorkingDays < $workingDays-'25' || $empWorkingDays < $workingDays-'26' || $empWorkingDays < $workingDays-'27' || $empWorkingDays < $workingDays-'28'){
                                             $weekendsalary='0'*$salaryOneDay ?? ''; 
                                            echo number_format(($allsalary),2); 
                                        }elseif ($empWorkingDays < $workingDays-'15') { 
                                            $weekendsalary='0'*$salaryOneDay ?? ''; 
                                            echo number_format(($allsalary),2); 
                                         }elseif($empWorkingDays <= $workingDays-'10'){

                                            $weekendsalary='2'*$salaryOneDay ?? ''; 
                                            echo number_format(($allsalary),2);  
                                          }
                                  }else{
                                    echo'0.00';
                                  }
                                   ?>

                                  
                  </td> 
                  <td><?php if(!empty($workerOvertime)){echo $workerOvertime.' '.'Hrs'; }  ?></td>
                  <td><?php if(!empty($salaryOneDay)){ echo number_format($overallOtSalary,2); }  ?></td>
                  <td><?php if(!empty($allsalary)){  echo number_format(($allsalary) + ($overallOtSalary),2);  }  ?></td>
                    <td><?php $allsalary12=''; 
                    if ($allweek>='1'){
                       $allsalary12=$allsalary+$weekendsalary+$salaryOneDay+$overallOtSalary;
                    }else{
                       $allsalary12=$allsalary+$weekendsalary+$overallOtSalary;
                    }
                    echo number_format(($allsalary12),2); ?>
                      
                    </td>
                   <td> 
                     
                    <a href="javascript:void(0)" id="<?=$empKey??'';?>" grossPay="<?=$empDatales->salary??'';?>" empWokingDays="<?=$empWorkingDays??'';?>" empWokingSalary="<?=$allsalary??'';?>" weekend="<?=$weekendsalary??'';?>"  oneDaysalary="<?=$salaryOneDay??'';?>" totalLeave="<?=$allweek??'';?>" class="workerDataView btn btn-view  btn-xs" otSalary="<?=$overallOtSalary??'';?>" monthYear="<?=$startmonthy = date('Y-m',strtotime($start_date))??'';?>" >View</a>
                    
                   </td>
             </tr>
    <?php  } }else{ ?>
               <tr>
                 <td colspan="12"> <h2 style="text-align:center;top: 35px;"   >DATA NOT FOUND !?</h2></td>
               </tr>
     <?php  } ?>
      </tbody>
   </table>
 </div>

     <div id="hrm_modal" class="modal fade in btnPrint"  role="dialog">
        <div class="modal-dialog modal-lg modal-large">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Salary Details   </h4>
                </div>
                <div class="modal-body-content"></div>
            </div>
        </div>
    </div>                                                 

                               
 