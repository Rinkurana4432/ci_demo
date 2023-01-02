<?php if($this->session->flashdata('message') != ''){?>                        

<div class="alert alert-success col-md-6">                            

   <?php echo $this->session->flashdata('message');?>

</div>

<?php }?>

<div class="x_content">

   <div class="row hidde_cls">

      <div class="col-md-12  export_div">

         <div class="col-md-4 col-xs-12 col-sm-6 datePick-left">

            <fieldset>

               <div class="control-group">

                  <div class="controls">

                     <div class="input-prepend input-group">

                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span >

                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="dailyreport/dailyreport_adjustment">  

                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="dailyreport/dailyreport_adjustment">  

                     </div>

                  </div>

               </div>

            </fieldset>

            <form action="summaryreport_adjustment" method="post" id="date_range">   

               <input type="hidden" value='' id='hidden-type' name='ExportType'/>

               <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>

               <input type="hidden" value='' class='start_date' name='start'/>

               <input type="hidden" value='' class='end_date' name='end'/>

               <input type="hidden" value='<?php // if(!empty($_POST['company_unit'])){echo $_POST['company_unit'] ;} ?>' class='company_unit' name='company_unit'/>

            </form>

            <?php  if(!empty($date['start_date'])){ ?>

                       <h4>Showing Results  <?php echo "From :  ".$date['start_date'] ."      To :   ". $date['end_date'] ?> </h4>

                            <?php } ?>

         </div>

                  

         <div class="btn-group"  role="group" aria-label="Basic example">

            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">

            </div>

         </div>

         <div class="col-md-3 col-xs-12 col-sm-6 datePick-right">

         </div>

      </div>

   </div> 



    <table id="attendance123" class="table table-striped table-bordered account_index" cellspacing="0" width="100%">





    <thead>

                                            <tr>

                                               

                                                <th>Employee Name</th>

                                                <th>Total Working Days</th>

                                                <td>

                                                <table>

                                                      <tr><th colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payable Days</th></tr>

                                                	  <tr><td>Worked Days</td><td>Paid Off</td></tr>

                                                </table>

                                                </td>

                                             <th>Un-Paid Days</th>

                                                 

                                                

                                                 

                                            </tr>

                                        </thead>

                                         

                                        <tbody>







                           <?php 

                           $paid_off = 0;

                     $check_duplicate_emp_id = array();

                     $sr_no = 1;

                    $present_date = array();

                    $final_key = array();

                    $paid_off_date = array();

                    $absent_status = array();

                    $left_out_days = array();



                    $start_date =   $date['start_date'];  

                    $end_date = $date['end_date'];  

            

             if(!empty($start_date) && !empty($end_date) )

             {

       

      

                  $from_date = new DateTime($start_date);

                  $to_date = new DateTime($end_date);                                                      

      

                  for ($date = $from_date; $date <= $to_date; $date->modify('+1 day')) {

                   $selected_days[] = $date->format('Y-m-d');

                   $selected_day_names[] = $date->format('D');

                  }

                 

               $left_out_days = $selected_days; 

      

      

            if($holiday=$this->session->userdata('holiday'))   // if holidays are included in dateRange

            {        

                

                 foreach ($holiday as $key => $val ) {

               

              

                 $from_date = new DateTime($val->from_date);

                  $to_date = new DateTime($val->to_date);                                                      

      

                  for ($date = $from_date; $date <= $to_date; $date->modify('+1 day')) {

                   $holiday_dates[] = $date->format('Y-m-d');

                                                   } 

      

                           

                          }

                       $left_out_days = array_diff($left_out_days, $holiday_dates);

                                      

                      

             }

      

      

                                                   /* pre($holiday_dates);     

                                                    pre($left_out_days); */    

         //   print_r($worked_days);



            if($paid_off_unpaid_days=$this->session->userdata('paid_off_unpaid_days'))

            {

                 //  print_r($paid_off_unpaid_days);





                  foreach ($paid_off_unpaid_days as $key => $val) {

                       if(  $val['attendance_status'] == 'leave')

                                     {

                                     $emp_id_on_leave[]       =   $val['emp_id'];

                                     $leave_count[]       =   $val['status_count'];

                                     }

                       if(  $val['attendance_status'] == 'absent')

                                     {

                                     $emp_id_on_absent[]       =   $val['emp_id'];

                                     $absent_count[]       =   $val['status_count'];

                                     }

                                     

                      }



                       

                    

            }





             if($worked_days=$this->session->userdata('worked_days'))

            {

                 



                  foreach ($worked_days as $key => $val) {

                       if(  $val['attendance_status'] == 'present')

                       {

                                     $worked_days_emp_id[]       =   $val['emp_id'];

                                     $worked_days_count[]       =   $val['status_count'];

                                     }

                                     

                      }

                     

            }

            $array3 = array_merge_recursive($worked_days , $paid_off_unpaid_days);

 







            if($week_off_emp=$this->session->userdata('week_off_emp'))    //  // if week_off are included in dateRange

            {        

               

                 foreach ($week_off_emp as $key => $val ) {

               

               

                   $week_off_days[]    = date('D',strtotime($val->day));

                 

                           

                          }

             }

                  foreach ($left_out_days as $key => $val) {

                $left_out_days_in_day[]    = date('D',strtotime($val));

                                   }      



           if(!empty($week_off_emp)){ 

                    $workable_days = array_diff($left_out_days_in_day, $week_off_days);

                    $workable_days  =     count($workable_days);

                     }

            if(empty($week_off_emp)) {

                     $workable_days =    count($left_out_days_in_day);

            }        

            

          $target_array =   getAttendanceById_twoDate('attendance','atten_date' ,$start_date,$end_date,$c_id);

         

          $all_data =   array_unique($target_array, SORT_REGULAR);



           if(!empty($all_data)){

                     $all_data = array_filter($all_data);

                         

                              $present_status =0;



                               $check = array();

                          #  pre($all_data);die;

                         foreach ($all_data as $key => $val) {

                       

                           $check[] =  $val->emp_id;

                         if (in_array($val->emp_id, $check)){

                             $y =8;

                         }else{

                          $y = 0;

                         }

                         

                          

                  @  $worked_days = count($present_status[$key]);

                    

                      $l = 0;$a=0;$p=0;$t=0;

                    

                     foreach ($array3 as $key => $value) {

                     

                       if($value['emp_id'] ==  $val->emp_id)

                       {

                          

                                    if($array3[$key]['attendance_status'] == 'leave')

                                    {

                                        $l = $l + $array3[$key]['status_count'];  

                                    }

                                    if( $array3[$key]['attendance_status'] == 'absent')

                                    {

                                        $a = $a + $array3[$key]['status_count'];

                                    }

                                    if( $array3[$key]['attendance_status'] == 'present')

                                    {

                                        $p = $p + $array3[$key]['status_count'];

                                    }

                                   

                                    

                               }   

                                           

                        }  

                    

                                 

                                         if (!in_array($val->emp_id, $check_duplicate_emp_id)) {

                                             array_push($check_duplicate_emp_id,$val->emp_id);

                                             $emp_name        =  $this->hrm_model->get_user_data_activeStatus($val->emp_id); 

                                             if(!empty($emp_name)){

                         ?>

                                        

                                       <tr>      

                                                   

                                                   

                                                    <td><mark><?php echo @ $emp_name->name  ?><?php echo $val->emp_id ?></mark></td> 

                                                    <?php   $e_l = getNameById('earned_leave',$val->emp_id,'em_id');

                                                     $paid_off = @ (int)$e_l->present_date;
                                                      
                                            $dummy_paid_off    =     $workable_days - $p ;
                                                         if($dummy_paid_off > $paid_off )
                                                         {
                                                                  $paid_off = $paid_off;        
                                                         }else{
                                                             $paid_off = $dummy_paid_off; 
                                                         }
                                                         $worked_days         =    $p;
                                                       
                                                       $total_paid_days = $worked_days + $paid_off ;
                                                       $total_unpaid_days = $workable_days - $total_paid_days;    
                                                   

                              ?>

                                                    <td><mark><?php echo $workable_days ?></mark></td>  

                                                    <td>

													<table>

													<td><mark><?php  echo $p;  ?></mark></td> 

                                                    <td><mark><?php  echo $paid_off;  ?></mark></td> 

													</table>

												    </td>

                                                    <td><mark><?php   

                                                       

                                                      /*if($unpaid > 0 )

                                                      {*/

                                                        echo $total_unpaid_days;

                                                      /*}else{ 

                                                         echo'0';

                                                       }*/

                                                     ?></mark></td>

                                                   

                                        

                                                     

                                        </tr>                                                       

               



                           <?php   }

                           }

                                                  $sr_no++;

                                                  $y = 0;

                              }   }else{   ?>    

    <div>

      <h2>No Attendance Data Found.</h2>

   </div>

     

                                                <?php   }  }   ?>



                                                  

                                        </tbody>

                                    </table>

                                                                  

 



                                        

                                    

                                </div>

                                                         

                               

 <?php #$this->load->view('backend/footer'); ?> 