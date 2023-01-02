 
<!--<a href="#" class="btn btn-primary hrmTab" data-toggle="modal" data-target="#Bulkmodal"><i class="" aria-hidden="true"></i>  Add Bulk WorkersAttendance</a>-->       <!-- <?php $empDatalesName = getNameById('worker',$attendancelist[0]['emp_id'],'id');  ?>   
                               <div><h5>Name:- <span> <?=$empDatalesName->name??'';?></span></h5> <h5> ID:- <span> <?=$empDatalesName->id??'';?></span></h5></div> -->
                                    <table id="" class="table table-striped table-bordered account_index" cellspacing="0" width="100%" style="margin-top:45px;">
                                        <thead>
                                            <tr>
                                                <th>Id </th>
                                                <th>Employee Name </th>
                                                <th>Emp Id </th>
                                                <th>Date<span class="resize-handle"></span></th>
                                                <th>Sign In<span class="resize-handle"></span></th>
                                                <th>Sign Out<span class="resize-handle"></span></th>
                                                <th>Working Hour<span class="resize-handle"></span></th> 
                                                <th>Total Working Hour<span class="resize-handle"></span></th> 
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
 
                                           <?php foreach($attendancelist as $value):  
                                               $empDatales = getNameById('user_detail',$value['emp_id'],'u_id'); 
                                                $Empkey=$value['emp_id'];    
                                                $where = "employeeId = '{$Empkey}' AND shiftChangeStartDate >= '{$startDate}' AND employeeShiftEndDate <= '{$endDate}'";   
                                                $employeeData  = $this->hrm_model->get_worker_data('employshiftChange',$where);
                                                
                                                foreach ($employeeData as $employeeshift) { 
                                                $shiftNameTime = getNameById('production_setting',$employeeshift['shift_id'],'id');
                                                   
                                                    }?>
                                            <tr>
                                                <td><?php echo $value['id']; ?></td>
                                                <td><?php echo $empDatales->name; ?></td>
                                                <td><?php echo $value['emp_id']; ?></td>
                                                <td><?php echo $value['atten_date']; ?></td>
                                                <td><?php echo $value['signin_time']; ?></td>
                                                <td><?php echo $value['signout_time']; ?></td>
                                                <td><?php echo $shiftNameTime->working_hrs;?></td>
                                                 
                                             <td><?php echo $OtHrsd=(float)$value['working_hour'];?></td>
                                            </tr>
                                            <?php endforeach;  echo $d;?>
                                        </tbody>
                                    </table>
 
