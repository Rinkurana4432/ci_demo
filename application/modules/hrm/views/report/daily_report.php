
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
                          
                         <form action="<?php echo base_url(); ?>hrm/dailyreport_adjustment" method="post">
                          <input type="date" name="current_date" id="current_date">
                          <input type="submit">   
                        </div>
                        <?php if(!empty($date)){ ?>
                       <h4>Showing Results For : <?php echo $date  ?></h4>
                            <?php } ?>
                    </div>
                </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>dailyreport" method="post" id="date_range">   
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
                <!-- <button type="buttton" class="btn btn-infoaddBtn" id="clickStockCheckBtn" >Stock Check </button> -->
            </div>
        </div>
    </div> 

    <table id="attendance123" class="table table-striped table-bordered account_index" cellspacing="0" width="100%">

 
                                        <thead>
                                            <tr>
                                                <th>S No</th>
                                                <th>Emp Code</th>
                                                <th>Employee</th>
                                                <th>Punch In </th>
                                                <th>Punch Out </th>
                                                <th>Total Hours </th>
                                             <!--   <th>Leave Status</th>-->
                                                <th>P / A / L</th>
                                            </tr>
                                        </thead>
                                         
                                        <tbody>

                                           
                                                   <?php            
                                                         
                                                            $sr_no = 1;
                                                            $l = 0;$a=0;$p=0;$t=0;$na=0;$show_data=0;
                                                            $userData = array_map('array_filter', $users);
                                                            $user_Data = array_filter($userData);  
                                                            
                                                            $status ="";
                                                            #pre($user_Data);die;
                                                         if(!empty($date)){    if(!empty($user_Data)){ foreach($userData as $value){  
                                                           $getLeave = "";
                                                            $sign_out= "";
                                                            $date1= "";
                                                            $date2= "";
                                                            $sign_in= "";
                                                            $absent_present = getAttendanceById_Date('attendance',$date,'atten_date' ,$value['id'],'emp_id',$c_id); 
                                                        #  pre($absent_present);die;
                                                            if(!empty($absent_present)){ $show_data = '1'; }
                                                            if(!empty($absent_present))  {  $getLeave =   getEmpLeave('emp_leave',$value['id'] ,$date);  } 
                                                           if(!empty($absent_present)){ 
                                                            if($show_data){
                                            ?>
                                            <tr>
                                              
                                                   <td><mark><?php echo $sr_no ?></mark></td> 
                                                    <td><mark><?php if(isset($value['id'])){ echo  $value['id']; } ?></mark></td>
                                                   <td><mark><?php if(isset($value['name'])){  echo $value['name']; } ?></mark></td>
                                                   <td><mark><?php if(isset($absent_present)){  echo $sign_in =  $absent_present->signin_time; } ?></mark></td>
                                                   <td><mark><?php if(isset($absent_present)){  echo $sign_out =  $absent_present->signout_time; } ?></mark></td>
                                                   <td><mark><?php 
                                                    
                                                            $date1 = new DateTime($sign_in);
                                                            $date2 = new DateTime($sign_out);
                                                            
                                                            $interval = $date1->diff($date2);
                                                            echo  $interval->h . "." . $interval->i; 
                                               
                                                   ?></mark></td>
                                                   
                                                   <!--<td><mark></?php if(isset($getLeave->leave_status)){ echo  $getLeave->leave_status; } ?></mark></td>-->
                                                   <td><mark><?php 

                                                               if(@ $getLeave->leave_status == "Approve")
                                                               {
                                                                $l++ ;  
                                                                 $p++;    
                                                                echo 'L'."   (".   $getLeave->leave_status. ") ";
                                                               }elseif(@ $getLeave->leave_status == "Not Approve" || @ $getLeave->leave_status == "Rejected" )
                                                               {
                                                                $a++;
                                                                 echo 'A';
                                                               }elseif(@ $absent_present->status == 'P'){
                                                                   $p++;    
                                                                  echo 'P'; 
                                                                 }elseif(@ $absent_present->status == 'A'){
                                                                  $a++;
                                                                  echo 'A';
                                                                 }else{
                                                                  $a++;
                                                                  echo 'A';
                                                                 }
                                                    ?></mark></td> 
                                                 
                                            </tr>
                                            <?php  } $sr_no++; }   } } }else{      ?>
                                            
      
      
      
     
   <div>
      <h2>No Attendance Data Found.</h2>
   </div>
   <?php    } ?>

                                           
                                        </tbody>
                                    </table>
                                    <div>Present:<?php echo $p; ?></div>
                                    <div>Absent:<?php echo $a; ?></div>
                                    <div>Leave:<?php echo $l; ?></div>
                                    <div>N/A:<?php echo $na; ?></div>
                                    <div>Total:<?php echo $t = $p+$a+$l; ?></div>
                                    
                                </div>
                                                         
                               
 <?php #$this->load->view('backend/footer'); ?> 