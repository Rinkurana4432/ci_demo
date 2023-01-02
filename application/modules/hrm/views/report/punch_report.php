
<?php if($this->session->flashdata('message') != ''){?>                        
        <div class="alert alert-success col-md-6">                            
            <?php echo $this->session->flashdata('message');?>
        </div>                        
<?php }?>


<div class="x_content"><div class="col-md-12 col-xs-12 for-mobile">      <div class="Filter Filter-btn2">	        <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>			<div id="demo" class="collapse" style="padding:30px 10px">			     <div class="col-md-4 col-xs-12 col-sm-6 datePick-left">                            <fieldset>                <div class="control-group">                    <div class="controls">                        <div class="input-prepend input-group">                                                    <form action="<?php echo base_url(); ?>hrm/punchreport_adjustment" method="post">                          <div class="controls" style="margin-bottom: 14px;">                                 <div class="input-prepend input-group">                                    <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>                          <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="dailyreport/dailyreport_adjustment"> </div>						  </div>						                            <input type="text" style="width: 160px" placeholder="Emp Code" required name="emp_code" id="emp_code" class="form-control"  >                            <input type="submit" class="btn btn-success " style="background-color: #214162 !important; color:#fff;">                           </div>                       <!-- </?php if(!empty($date)){ ?>                       <h4>Showing Results For : </?php echo $date  ?></h4>                            </?php } ?>-->                    </div>                </div>            </fieldset>            <form action="<?php echo base_url(); ?>punchReport" method="post" id="date_range">                   <input type="hidden" value='' id='hidden-type' name='ExportType'/>                <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>                <input type="hidden" value='' class='start_date' name='start'/>                <input type="hidden" value='' class='end_date' name='end'/>                <input type="hidden" value='<?php // if(!empty($_POST['company_unit'])){echo $_POST['company_unit'] ;} ?>' class='company_unit' name='company_unit'/>            </form>             </div>			</div>	  </div></div>
    <div class="row hidde_cls">
        <div class="col-md-12  export_div">
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
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Punch In/Out Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>       <?php            
                                                            $signIn_signOut_status = "";
                                                            $count_date_available =array();
                                                            $sr_no = 1;
                                                            $l = 0;$a=0;$p=0;$t=0;$na=0;$show_data=0;
                                                            $userData = array_map('array_filter', $users);
                                                            $user_Data = array_filter($userData);  
                                                            
                                                            $status ="";
                                                        $dateRange_empCode  =  $this->session->userdata('dateRange_empCode');
                                                     #   pre($dateRange_empCode);die;
                                                         if(!empty($dateRange_empCode)){    if(!empty($dateRange_empCode)){
                                                            $previous_row_date = "";
                                                             foreach($dateRange_empCode as $value){ 
                                                                
                                                                     $biometric_id = getNameById('user_detail',$value->punchingcode,'biometric_id');
                                                         
                                                            $emp_id    =    @ $biometric_id->u_id;
                                                           
                                                           $emp_name =  $this->hrm_model->get_user_data_activeStatus($emp_id);
                                                    
                                            ?>
                                            <tr>
                                             
                                                   <td><mark><?php echo $sr_no ?></mark></td> 
                                                    <td><mark><?php if(isset($emp_id)){ echo $emp_id; } ?></mark></td>
                                                   <td><mark><?php if(isset($emp_name)){  echo $emp_name->name; } ?></mark></td>
                                                 
                                                 
                                                   <?php 
                                                   
                                            $signIn_signOut    = count(array_keys($count_date_available, $value->date));
                                                  
                                                 if($signIn_signOut % 2 == '0')
                                                       {
                                                            $signIn_signOut_status = "Punch In";
                                                       }else{
                                                            $signIn_signOut_status = "Punch Out";
                                                       }
                                                    
                                                   
                                                   ?>
                                                   
                                                   
                                                   <td><mark><?php if(isset($value->date)){  echo $value->date; } ?></mark></td>
                                                   <td><mark><?php if(isset($value->time)){  echo $value->time ; } ?></mark></td>
                                               
                                                   <td><mark><?php  echo $signIn_signOut_status ;  ?></mark></td>
                                                   
                                                
                                                  
                                                   <!--<td><mark></?php if(isset($value->signout_time)){ echo  $value->signout_time; } ?></mark></td>-->
                                                  
                                            </tr>
                                            <?php
                                             $count_date_available[]    =    $value->date ;
                                            $sr_no++; 
                                          #  $signIn_signOut++;
                                            
                                            }  }   }else{      ?>
        
   <div>
      <h2>No Attendance Data Found.</h2>
   </div>
   <?php    } ?>
                                        </tbody>
                                    </table>
                                   
                                    
                                </div>
                                                         
                               
 <?php #$this->load->view('backend/footer'); ?> 