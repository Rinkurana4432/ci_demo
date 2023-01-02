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
            <form action="userreport_adjustment" method="post" id="date_range">   
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
  <table id="attendance123" class="table table-striped table-bordered account_index" cellspacing="0" width="100%">


    <thead>
                                            <tr>
                                                  <th>Id</th>
                                                  <th>Date</th>
                                                  <th>First In</th>
                                                  <th>First Out</th>
                                                  <th>Total Hours</th>
                                              
                                                 
                                            </tr>
                                        </thead>
                                         
                                        <tbody>



                           <?php 

                   

                    $start_date =   $date['start_date'];  
                    $end_date = $date['end_date'];  

       
      
                  $from_date = new DateTime($start_date);
                  $to_date = new DateTime($end_date);                                                      
      
                  for ($date = $from_date; $date <= $to_date; $date->modify('+1 day')) {
                   $selected_days[] = $date->format('Y-m-d');
                   $selected_day_names[] = $date->format('D');
                  }
                 
              

             
         
     
            $target_array =   getAttendanceById_twoDate('attendance','atten_date' ,$start_date,$end_date);
            
              $all_data =   array_unique($target_array, SORT_REGULAR);

                    if(!empty($all_data)){
                     $all_data = array_filter($all_data);
                         
                              $present_status =0;

                               $check = array();
     
                               if(!empty($selected_days))
                               {
                                $first_in = ""; $first_out = ""; 
                        foreach ($selected_days as $key => $val) {
                            

                               $show_data[] =   getCommonAttendanceById_Date('attendance',0 ,'created_by_cid' , $val , 'atten_date');
                                          $run = 'notok';
                                          foreach($show_data as $value){
                                          if(is_array($value)) {
                                            if(sizeof($value) == 0)
                                            {
                                              $run = 'notok';
                                            }else
                                            {
                                                  $first_in = array();
                                                  $last_out = array();  

                                                 for ($i=0; $i < count($value); $i++) { 
                                                    $first_in[]  =   $value[$i]->signin_time ;
                                                    $last_out[]  =   $value[$i]->signout_time ;
                                                    $datee[]  =      $value[$i]->atten_date ;
                                                   } 


                                              
                                            $run = 'ok';   
                                            }
                                           
                                          }
                                          }

                                          if($run == 'ok')
                                          {  
                            
                                          $first_inx  = min($first_in);
                                          $last_outx =  max($last_out); 
                                          
                                          $checkTime = strtotime($first_inx);
                                          $loginTime = strtotime($last_outx);  
                                          $diff = $checkTime - $loginTime;
                                          $timeDiff  = date('H:i:s', $diff); 
                                           }   
                                           if($run == 'notok')
                                           {
                                             $first_inx = "--:--";
                                             $last_outx = "--:--";
                                             $timeDiff   = "--:--";
                                            
                                           }

                                     

                           
                                  ?>
                                       
                                            <tr>
                                                   <td><mark><?php // if(!empty($datee)){ echo $datee[$keyx]; }  ?></mark></td>  

                                                    <td><mark><?php   echo $val;  ?></mark></td> 
                                                   
                                                    <td><mark><?php if(!empty($first_inx)){  echo $first_inx; } ?></mark></td> 
                                                    <td><mark><?php if(!empty($last_outx)){  echo $last_outx; } ?></mark></td> 
                                                     
                                                    <td><mark><?php     ?></mark></td> 
                                                     
                                         </tr>         
                                                                                               
                         

                           <?php    
                                                  
                            
                             }  
                             
                           }   

                                                                             
                             
 
                                                             }          ?>

                                                  
                                        </tbody>
                                    </table>
                                                                  
 

                     


                                      


                                          
                                        
                                    
                                </div>
                                                         
                               
 <?php #$this->load->view('backend/footer'); ?> 