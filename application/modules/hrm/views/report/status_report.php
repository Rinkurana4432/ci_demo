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
<!--                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="dailyreport/dailyreport_adjustment">  
-->                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="statusreport_adjustment" method="post" id="date_range">   
               <input type="hidden" value='' id='hidden-type' name='ExportType'/>
               <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
               <input type="hidden" value='<?php // if(!empty($_POST['company_unit'])){echo $_POST['company_unit'] ;} ?>' class='company_unit' name='company_unit'/>
            </form>
         </div>
         <div class="btn-group"  role="group" aria-label="Basic example">
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
            </div>
         </div>
         <div class="col-md-3 col-xs-12 col-sm-6 datePick-right">
         </div>
      </div>
   </div>
   <!--<table id="attendance123" class="table table-striped table-bordered account_index" cellspacing="0" width="100%">-->
   <?php 
      $final_key = array();
      $start_date =   $date['start_date'];  
      $end_date = $date['end_date'];  
      $from_date = new DateTime($start_date);
      $to_date = new DateTime($end_date);                                                      
      
      for ($date = $from_date; $date <= $to_date; $date->modify('+1 day')) {
                        $selected_days[] = $date->format('Y-m-d');
                        $selected_day_names[] = $date->format('D');
                                                                            }
      
            if($holiday=$this->session->userdata('holiday'))
            { 
                foreach ($holiday as $key => $val ) {
                 $from_date = new DateTime($val->from_date);
                 $to_date = new DateTime($val->to_date);                                                      
      
                  for ($date = $from_date; $date <= $to_date; $date->modify('+1 day')) {
                   $holiday_dates[] = $date->format('Y-m-d');
                                                   } 
      
                           
                          }
                                       $common_dates_selected = array_intersect($selected_days, $holiday_dates);
                               
                                   
      
                                            $holiday_final_keyx = array_keys($common_dates_selected);
                                       
                     
             }
      
     //   pre($common_dates_selected);    
      //                                              pre($holiday_final_keyx);    
      
      
            $all_data =   getAttendanceById_twoDate('attendance','atten_date' ,$start_date,$end_date,$c_id);
      
      if(!empty($all_data)){
                     $all_data = array_filter($all_data);
               
                        foreach ($all_data as $key => $val) {
      
                              foreach($val as $field => $value) {
                              $recNew[$field][] = $value;
                                                                 }
                                                             }
      
                                             
                                         
      echo "<div style='overflow-x: scroll;width: 100%; !important'><table  id='attendance123' class='table table-striped table-bordered account_index' cellspacing='0' width='100%'>";
      
                                              echo " <thead><div id='selected_dates'><tr>";
                                          echo "<th> Emp Name</th>";
                                   
      
      
                                          foreach ($selected_days as $keyx => $date)  
                                          {   
                                               $selected_days_key[] =   $keyx;   
                                               
                                          echo "<th>&nbsp;&nbsp;&nbsp;".date('M',strtotime($date))."&nbsp;&nbsp;&nbsp;".date('d',strtotime($date)) ."<br>"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($selected_day_names[$keyx]) . "<br><br>"."</th>";  
                                          
                                          }  
      
                                          echo"</tr></div></thead><tbody> "; 
                                   
                                   if(!empty($recNew['atten_date'])){
                                             $final_selectd_days = array_intersect($selected_days,$recNew['atten_date']);
                                    
                                            $placed_final_key = array_keys($final_selectd_days);
                                            }
      
      
      
                                          foreach (array_unique($recNew['emp_id']) as $i => $values)  
                                          {
                                           echo "";
                                                   $emp_name     =  $this->hrm_model->get_user_data_activeStatus($values);
                                          # $emp_name     = getNameById('user_detail',$values,'u_id');
                                          if(!empty($emp_name)){
                                           echo "<tr><div id='selected_emp'><td><br>" . @ $emp_name->name. "</td></div>";
                                            
                                           for ($s=0; $s < count($selected_days) ; $s++) { 
                                          $holiday="";
                                          $leave ="";
                               
                                 if(!empty($holiday_final_keyx)){
                                 foreach($holiday_final_keyx as $val)
                                 {
                                            if($s == $val)
                                            {
                                                $holiday ="H";
                                            }
                                 }
                                 }
                                                                               
      
                                
      @   $atten_keyz = $s;
      @   $absent_present = getAttendanceById_Date('attendance',$selected_days[$atten_keyz],'atten_date' ,$values,'emp_id',$c_id); 
                 
                       $getLeave =   getEmpLeave('emp_leave',$values ,$selected_days[$atten_keyz]);  
                       // find Leave 
                        if(@ $getLeave->leave_status == "Approve")
                         {                                                                 
                          $leave = 'L';
                         }
                        
                        if(@ $getLeave->leave_status == "Not Approve" || @ $getLeave->leave_status == "Rejected" )
                         {
                         
                            $leave = 'A';
                         }
                        if(!empty($holiday))
                        {
                      echo"<td>". $holiday. "</td> " ; 
                         }elseif(!empty($leave)){
                          echo"<td>". $leave."</td> " ;
                         }else{
                           echo"<td>".  @ $absent_present->status."</td> " ;
                         }
                           }
      
                             echo "</tr>";
                                }        
                                }        
                                echo "</tbody></div></table></div>";
                                   }else{  ?>
   <div>
      <h2>No Attendance Data Found.</h2>
   </div>
   <?php   }?>
</div>
<?php #$this->load->view('backend/footer'); ?>