 
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }?>
<div class="x_content">
   <div class="stik">
      <?php $str = base64_decode('YW5vZGl6ZSQxMjNfQCMhQA==');
         str_replace("_@#!@", "", $str);
         ?>
   </div>
   <?php /*if(!empty($job_Card)){ */ ?>
<div    class="col-md-12 col-xs-12 for-mobile">
 <div class="Filter Filter-btn2">
        <form class="form-search " method="post" action="<?= base_url() ?>hrm/worker_Work/<?= $workerid ?>" >
      <div class="col-md-6">
         <!-- <div class="input-group">
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
         </div> -->
      </div><!-- <a href="<?php echo base_url(); ?>hrm/monthly_salary_report/"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Back"></a> -->
   </form> 
   
   <!-- <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button> -->
         <div id="demo" class="collapse">
		       <div class="col-md-2 col-xs-12 col-sm-12">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="hrm/worker_Work/<?= $workerid ?>"/>
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>hrm/worker_Work/<?= $workerid ?>" method="get" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
		 </div>
 </div>
    <div class="row hidde_cls export_div">
         <div class="col-md-12">
            <div class="btn-group"  role="group" aria-label="Basic example">
             
               <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>  
               <input type="hidden" value='add_machine' id="table" data-msg="Machine" data-path="production/Add_machine"/>              
             <!--   <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                  <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu" id="export-menu">
                     <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                     <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                  </ul>
               </div>  --> 
               <form action="<?php echo base_url(); ?>hrm/monthly_salary_report" method="get" >
                  <input type="hidden" value='1' name='favourites'/>
                  <input type="hidden" value='' class='start' name='start'/>
                  <input type="hidden" value='' class='end' name='end'/>
                   
               </form>
            </div>
           <div class="col-md-3 col-xs-12 col-md-12 datePick-right">
             <form action="<?php echo site_url(); ?>hrm/monthly_salary_report" method="get" id="export-form">
                 
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

       <?php $workername = getNameById('worker', $workerid, 'id');?>  <h1><b><?= $workername->name; ?></b>   </h1>  
   <table id="" class="table table-striped table-bordered account_index" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
      <thead>
         <tr>
             
            <th scope="col" style="width:60px;" >S No </th> 
             <th scope="col">Date</th>
             <th scope="col">Wages/Per Piece</th>
            <th scope="col">Machine Name </th>
             <th scope="col">Work-order </th>
            <th scope="col">Production </th>
            <th scope="col">Per Piece Salary </th> 
            <th scope="col" >Wages Total Working Hrs  </th>
            <th scope="col" >Wages OT <span>( Over Time )</span>   </th>
            <th scope="col" >Wages OT Salary</th> 
            <th scope="col" >Salary</th> 
             <th scope="col" style="width: 200px;" >Total Amount </th> 
         </tr>
      </thead>
      <tbody>

         <?php  
             $i=0;
             $count=1; 
             $wagessallery=0;
             $per_picessallery=0;
             $workhr12=0;
             $totalamt=0;
             $wagessallery225=0;
              $othrs1='';
             if (!empty($workerdata)) {
               foreach ($workerdata as $keyj => $datavalue) {  
               // $shift= getNameById('production_setting', $workername->shift_id, 'id');
                 $worker_hours =$workername->working_hrs;  

                $add_machine= getNameById('add_machine', $datavalue['machine_name_id'], 'id')->machine_name;
                $worker_ot_salary=  $this->hrm_model->get_compdata('company_detail',array('id'=> $this->companyGroupId));
                $monthcount=date('t');
                 $monthday = $monthcount-$worker_ot_salary[0]['worker_week_off'];
                $work_order= getNameById('work_order', $datavalue['work_order'], 'id');
                 ?>
      <tr>   
         <td><?=$count;?></td>
         <td><?php $production_data = getNameById('production_data', $datavalue['production_id'], 'id')->date;
          echo date("j F , Y", strtotime($production_data)); ?></td>
         <td><?php echo $datavalue['wages_or_per_piece'];?></td>
         <td><?php echo $add_machine; ?> </td>
          <td><?php     if (!empty($work_order)) {
            echo $work_order->workorder_name;
          }else{
            echo" ";
          } ?></td>
         <td><?php echo $datavalue['output'];?></td>
         <td><?php    if ($datavalue['wages_or_per_piece']=='per_piece') {
            $persavalue='';
             $worker_id=json_decode($datavalue['worker_id']); 
            $totalsalary=json_decode($datavalue['totalsalary']);
            foreach ($worker_id as $Wkey => $Wvalue) {
               if ($workerid==$Wvalue) { 
               foreach ($totalsalary as $sakey => $persavalue) {
                  if ($Wkey==$sakey) {
                      $per_picessallery +=$persavalue;
                   echo @money_format('%!i',$persavalue);
                }
               }
              } 
            } 
          } ?></td>
            <td><?php   if ($datavalue['wages_or_per_piece']=='wages') {
             $worker_id=json_decode($datavalue['worker_id']); 
            $workerhrs=json_decode($datavalue['working_hrs']); 
            foreach ($worker_id as $Wkey => $Wvalue) {
               if ($workerid==$Wvalue) { 
              foreach ($workerhrs as $Hrskey => $Hrsvalue) {
                if ($Wkey== $Hrskey) {
                  if(!empty($Hrsvalue)){
                     echo @$Hrsvalue.' '.'Hrs';
                   }
                   }
                }
              } 
            }
           }
            
           ?></td>
         <td><?php   if ($datavalue['wages_or_per_piece']=='wages') {
             $worker_id=json_decode($datavalue['worker_id']); 
            $workerhrs=json_decode($datavalue['working_hrs']); 
            foreach ($worker_id as $Wkey => $Wvalue) {
               if ($workerid==$Wvalue) { 
              foreach ($workerhrs as $Hrskey => $Hrsvalue) {
                if ($Wkey== $Hrskey) {
                    if($Hrsvalue>$worker_hours){
                        echo @$othrs=$Hrsvalue-$worker_hours.' '.'Hrs';
                        @$workhr12 +=$othrs;
                      }else if($Hrsvalue<=$worker_hours){
                        echo '-';
                      } 
                   }
                }
              } 
            }
           }
            
           ?></td>

         <td>
          <?php if ($datavalue['wages_or_per_piece']=='wages') {
            $overallot='';
            $worker_id=json_decode($datavalue['worker_id']); 
            $workerhrs=json_decode($datavalue['working_hrs']); 
            foreach ($worker_id as $Wkey => $Wvalue) {
               if ($workerid==$Wvalue) { 
              foreach ($workerhrs as $Hrskey => $Hrsvalue) {
                if ($Wkey== $Hrskey) {
                 if($Hrsvalue>$worker_hours){
                   
                    $overtimehrs=$Hrsvalue-$worker_hours;
                     $allsalary=$workername->salary;
                    $onedaysalary=$allsalary/$monthday;
                     $workhrs=$onedaysalary/$worker_hours;
                   $overallot122=$overtimehrs*$workhrs;
                   $otsalary124=$worker_ot_salary[0]['hrm_worker_ot_salary']; 
                   $overallot= $otsalary124*$overallot122;
                   $wagessallery +=$overallot;    
                    echo @money_format('%!i', $overallot); 
                    }else if($Hrsvalue<=$worker_hours){
                        echo '-';
                      } 
                      

            
                 }
                }
              } 
            }
          }?>
            
         </td> 
         <td>
          <?php if ($datavalue['wages_or_per_piece']=='wages') {
            $onedaysalar1='';
             $worker_id=json_decode($datavalue['worker_id']); 
            $workerhrs=json_decode($datavalue['working_hrs']); 
            foreach ($worker_id as $Wkey => $Wvalue) {
               if ($workerid==$Wvalue) { 
              foreach ($workerhrs as $Hrskey => $Hrsvalue) {
                     if ($Wkey== $Hrskey) {
                            @$fulld='';
                          if($Hrsvalue>$worker_hours){
                            $othrs=$Hrsvalue-$worker_hours.' '.'Hrs';
                           @$workingvalue=$Hrsvalue-$othrs;
                            $allsalary=$workername->salary;
                             $onedaysalar1=$allsalary/$monthday;
                            $daysalary=$onedaysalar1/$worker_hours;
                             @$fulld= $daysalary*$workingvalue;  
                       }else if($Hrsvalue<=$worker_hours){
                           $allsalary=$workername->salary;
                             $onedaysalar1=$allsalary/$monthday;
                            $daysalary=$onedaysalar1/$worker_hours; 
                       @$fulld=$daysalary*$Hrsvalue;
                      } 
 
                 @$wagessallery225 +=$fulld;
                if ($fulld) {
                 echo @money_format('%!i', $fulld); 
                }else{
                  echo '-';
                }

            
                 }
                }
              } 
            }
          }?>
            
         </td> 
          

           <td>
          <?php     
             
              $worker_id=json_decode($datavalue['worker_id']); 
             $totalsalary=json_decode($datavalue['totalsalary']);
            foreach ($worker_id as $Wkey => $Wvalue) {
               if ($workerid==$Wvalue) { 
               foreach ($totalsalary as $sakey => $wagsavalue) {
                  if ($Wkey==$sakey) {
                       //$wagsavalueandovertime= $onedaysalar1+$overallot;

                     @$totalamt +=$wagsavalue;
                     echo @money_format('%!i',$wagsavalue);
                }
               }
              } 
            } 
            
            ?>
            
         </td>  
      </tr>
     <?php $i++; $count++; 
        
  }
 } 
?>
      
      </tbody>
      <thead>
           <tr>
             
            <th scope="col" style="width:60px;" > </th> 
             <th scope="col"> </th>
             <th scope="col"></th>
            <th scope="col"> </th>
             <th scope="col"> </th>
            <th scope="col">  </th>
            <th scope="col"><?php  echo 'Per-Piece'.' '. money_format('%!i',$per_picessallery); ?></th> 
            <th scope="col"></th>
            <th scope="col" > <?php  echo 'Hrs'.' '.money_format('%!i', $workhr12) .' '.'Hrs'; ?> </th>
            <th scope="col" > <?php echo 'Wages'.' '.money_format('%!i', $wagessallery); ?>  </th> 
            <th scope="col" > <?php echo 'Salary'.' '.money_format('%!i', $wagessallery225);  ?>  </th>  
            <th scope="col" style="width: 200px;" ><?php  echo 'Total'.' '. money_format('%!i',$totalamt);?> </th> 
         </tr> 
      </thead>
   </table>
     <div class="col-md-12 col-sm-12 col-xs-12 " style="clear:both; margin-top:22px; ">
        <div class="col-md-4 col-sm-5 col-xs-12 text-right grand-total3 bleow_hide" style="float: right;">
          <div class="col-md-12 col-sm-5 col-xs-12 text-right">
            <div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2">
              <div class="col-md-12 col-sm-5 col-xs-6 form-group">
              OverAll Total 
              </div> 
              <div class="col-md-6 text-left"><?php  echo  money_format('%!i',$totalamt);?> </div>  
            </div> 
             <div class="col-md-6 col-sm-5 col-xs-6 ">
             Basic Salary &nbsp;:
            </div>
            <div class="col-md-6 text-left"><?php echo $allsalary=$workername->salary;  ?></div>  
                         
          </div>
        </div>
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
