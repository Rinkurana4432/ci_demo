
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }?>
<div class="x_content">
   
   <?php /*if(!empty($job_Card)){ */ ?>
<div    class="col-md-12 col-xs-12 for-mobile">
 <div class="Filter Filter-btn2">
     <!--  <form class="form-search " method="post" action="<?= base_url() ?>hrm/worker_Work/<?= $workerid ?>" >
      <div class="col-md-6">
         <div class="input-group">
            <span class="input-group-addon"> 
            <i class="ace-icon fa fa-check"></i>
            </span>
            <input type="text" class="form-control search-query" placeholder="Enter id,Routing Number,Product Name" id="search" name="search" value="<?php if(!empty($_GET['search'])) echo $_GET['search'];?>" data-ctrl="hrm/worker_Work">
            <span class="input-group-btn">
            <button type="submit" class="btn btn-purple btn-sm">
            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
            Search
            </button>
            <a href="<?php echo base_url(); ?>hrm/worker_Work/<?= $workerid ?>"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
            </span>
         </div>
      </div>
   </form> -->
    <a href="<?php echo base_url(); ?>hrm/monthly_best_workers_report/"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
   <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         <div id="demo" class="collapse">
             <div class="col-md-2 col-xs-12 col-sm-12">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="hrm/monthly_best_workers_report"/>
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>hrm/monthly_best_workers_report " method="get" id="date_range">   
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
       </div>
 </div>


<!-- 
     <div class="row hidde_cls export_div">
      <div class="col-md-12 col-xs-12 col-sm-12">
         
         <div class="btn-group"  role="group" aria-label="Basic example">
          <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
            
             <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown" aria-expanded="false">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div> 
             <form action="<?php //echo base_url(); ?>hrm/monthly_salary_report" method="get" >
                  <input type="hidden" value='1' name='favourites'/>
                  <input type="hidden" value='' class='start' name='start'/>
                  <input type="hidden" value='' class='end' name='end'/>
                   
               </form>
         </div>
                <div class="col-md-3 col-xs-12 col-md-12 datePick-right">
                         
               <form action="<?php //echo site_url(); ?>hrm/monthly_salary_report" method="get" id="export-form">
                  <input type="hidden" value='' id='hidden-type' name='ExportType'/>
                  <input type="hidden" value='<?php// echo $_GET['start']; ?>' class='start_date' name='start'/>
                  <input type="hidden" value='<?php //echo $_GET['end']; ?>' class='end_date' name='end'/>
                  <input type="hidden" value='<?php //echo $_GET['favourites'];?>' name='favourites'/>
                  <input type="hidden" value='<?php //echo $_GET['search'];?>' name='search'/>
               </form>
            </div>   
         
          
      </div>
   </div>  --> 
        


        <div class="row hidde_cls export_div">
         <div class="col-md-12">
            <div class="btn-group"  role="group" aria-label="Basic example">
             
               <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>  
               <input type="hidden" value='add_machine' id="table" data-msg="Machine" data-path="production/Add_machine"/>              
               <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                  <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu" id="export-menu">
                     <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                     <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                  </ul>
               </div>  
               <form action="<?php echo base_url(); ?>hrm/monthly_best_workers_report" method="get" >
                  <input type="hidden" value='1' name='favourites'/>
                  <input type="hidden" value='' class='start' name='start'/>
                  <input type="hidden" value='' class='end' name='end'/>
                   
               </form>
            </div>
           <div class="col-md-3 col-xs-12 col-md-12 datePick-right">
             <form action="<?php echo site_url(); ?>hrm/monthly_best_workers_report" method="get" id="export-form">
                 
              <?php if (@$_GET['start']==''){?>
                 <input type="hidden" value='' id='hidden-type' name='ExportType'/>
                  <?php }else if(@$_GET['start']!=''){  ?>
                    <input type="hidden" value='' id='hidden-type' name='ExportType'/>
                  <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
                  <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
                  <input type="hidden" value='<?php echo $_GET['favourites'];?>' name='favourites'/>
                  <input type="hidden" value='<?php echo $_GET['search'];?>' name='search'/>
                <?php }?>
               </form>
            </div>
         </div>
      </div>


</div>
 
<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
<p class="text-muted font-13 m-b-30"></p>
<div id="print_div_content"  style="margin-top: 58px;" >
   <table id="" class="table table-striped table-bordered account_index" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
      <thead>
         <tr>
            <th scope="col" style="width:60px;" >S No </th> 
            <th scope="col">Name</th>
            <th scope="col">Salary  </th>
            <th scope="col">Total  Per-Pices</th>
            <th scope="col">Total  Wages</th>
            <th scope="col">Total Target   Production</th> 
            <th scope="col" >Production In %</th>
            <th scope="col" style="width: 200px;" >Total Working Days</th> 
             <th scope="col" style="width: 200px;" >Total Salary</th>
         </tr>
      </thead>
      <tbody>
         <?php if (!empty($workerdata)) { 
            $i=1;  
            $totalWorker = 0;
            $wagessallery12=0;
            $persallery12=0;
            $overallsallery12=0;
            foreach ($workerdata as $workerid => $workernamevalue) {
              $workeridgfr = getNameById('worker',$workerid, 'id');
              $worker_hours =$workeridgfr->working_hrs;  
              

            ?>
      <tr>
         <td><?=$i;?></td>
         <td> <?php if($workeridgfr->name!=''){ echo $workeridgfr->name;} ?></td>
         <td><?=@$workeridgfr->salary;?></td>
          <td><?php $peroutput=0; foreach ($workernamevalue as  $wagesvalue) {    if ($wagesvalue['wages_or_per_piece']=='per_piece') {
             $worker_id=json_decode($wagesvalue['worker_id']);  

            foreach ($worker_id as $Wkey => $Wvalue) {
               if ($workerid==$Wvalue) { 
             
              if(!empty($wagesvalue['planing_output'])){
                  $peroutput +=$wagesvalue['planing_output'];
              } 
              } 
            }
           }
          } echo $peroutput; 
           ?></td>
          <td><?php $wagesoutput=0;foreach ($workernamevalue as  $wagesvalue) {
             if($wagesvalue['wages_or_per_piece']=='wages'){
                 $whorker=json_decode($wagesvalue['worker_id']);
                  $totalsalary=json_decode($wagesvalue['totalsalary']);  
                 foreach ($whorker as $wkey => $wvalue) {
                   if(!empty($wagesvalue['planing_output'])){
                       $wagesoutput += $wagesvalue['planing_output'];
              } 
           }
          }
        } echo $wagesoutput ?></td>
          <td><?php $totaloutput=0;foreach ($workernamevalue as  $pervalue) {
                $whorker=json_decode($pervalue['worker_id']);  
                 foreach ($whorker as $wkey => $wvalue) {
                   if ($workerid==$wvalue) {
                        @$totaloutput +=$pervalue['output'];
                    
                     }
                }
              
          } if(!empty($totaloutput)){ $persallery12 +=$totaloutput;
          echo @$amountper = money_format('%!i', $totaloutput);} ?></td>
         <td><?php  $outputtotal=$peroutput + $wagesoutput;
                    if ($outputtotal==0) {
                     $alloty='0';
                    }else{
                     $overalloutput=$outputtotal/ $totaloutput;
                     $alloty=$overalloutput*100;
                     $overallsallery12 +=$alloty;
                   }
                   if (!empty($alloty)) {  
                   echo (float)money_format('%!i', $alloty). '%';  
                 }else{
                  echo'-';}?></td>
                  <td><?php $workingdays=0; $persalary=0;foreach ($workernamevalue as  $pervalue) {
                   $whorker=json_decode($pervalue['worker_id']);
                  $totalsalary=json_decode($pervalue['totalsalary']);  
                  
                 foreach ($whorker as $wkey => $wvalue) {
                   if ($workerid==$wvalue) {
                        //$workingdays=sum($wvalue);
                    // echo $workingdays;  
                    $workingdays+=1;
                    //pre($wvalue);
                                      
                     }
                }
              
             } echo $workingdays .' '.'Days';?>
            
          </td>
                  <td><?php $persalary=0;foreach ($workernamevalue as  $pervalue) {
                   $whorker=json_decode($pervalue['worker_id']);
                  $totalsalary=json_decode($pervalue['totalsalary']);  
                 foreach ($whorker as $wkey => $wvalue) {
                   if ($workerid==$wvalue) {
                      foreach ($totalsalary as $salarykey => $salaryvalue) {
                          if ( $wkey== $salarykey) { 
                             @ $persalary +=$salaryvalue;
                          }
                      }
                    
                     }
                }
            
          } @$persallery12 +=$persalary;
          echo $amountper = money_format('%!i', $persalary);?></td>
      </tr>
       <?php $i++; 
      
         @$output[] = array( 
                     'Name' => @$workeridgfr->name,
                     'Salary' => @$workeridgfr->salary,
                     'Total Target Per-Pices' =>  $peroutput,
                     'Total Target Wages' =>$wagesoutput, 
                     'Production In %' =>$totaloutput.''.'%',  
                     'Total Working Days' => $workingdays .' '.'Days',
                     'Total Salary' => $persalary 
                  );      
 

            } 
                  $data3  = $output;
                  export_csv_excel($data3);  
           }?>  
      
      </tbody>
      <!-- <thead>
        <tr>
           <th scope="col" style="width:60px;" > </th> 
            <th scope="col">No of Worker <?= --$i;  ?></th>
            <th scope="col">   </th>
            <th scope="col"> </span></th>
            <th scope="col">Wages Salary  <?php echo money_format('%!i', $wagessallery12);?> </th> 
            <th scope="col" >Per-Piece  Salary  <?php echo money_format('%!i', $persallery12);?></th>
            <th scope="col" style="width: 200px;" >Total <?php echo money_format('%!i', $overallsallery12);?></th>
            <th></th>
            <th></th>
          </tr>
      </thead> -->
   </table>
   

</div>
</div>

<div id="production_modal" class="modal fade in bom-rutinga"  role="dialog" >
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content" style="display:table;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">BOM Routing Details</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
<div class="modal fade disapproveReasonModal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg  ">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Reason</h4>
         </div>
         <div class="modal-body">
            <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/disApproveJobCard" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
               <input type="hidden" name="id" value="" id="job_card_id">
               <input type="hidden" id="validated_by" name="validated_by" value="<?php echo $_SESSION['loggedInUser']->id; ?>">
               <input type="hidden" id="disapprove" name="disapprove" value="1">
               <input type="hidden" id="disapprove" name="approve" value="0">
               <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comments<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">                                        
                     <textarea id="disapprove_reason" required="required" rows="6" name="disapprove_reason" class="form-control col-md-7 col-xs-12" placeholder=""></textarea>                                       
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>                      
                  <input type="submit" class="btn btn edit-end-btn " value="Submit">
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
