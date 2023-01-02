
<?php if($this->session->flashdata('message') != ''){?>                        
        <div class="alert alert-success col-md-6">                            
            <?php echo $this->session->flashdata('message');?>
        </div>                        
<?php }?>


<div class="x_content">
<div class="col-md-12 col-sm-12 for-mobile">
         <div class="Filter Filter-btn2">
             <form class="form-search" method="get" action="<?= base_url() ?>hrm/leave_application_worker">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter Type" name="search" id="search" data-ctrl="hrm/leave_application_worker" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?php echo base_url(); ?>hrm/leave_application_worker'" value="Reset">
                  </span>
               </div>
            </div>
         </form>
</div>
</div>
    <p class="text-muted font-13 m-b-30"></p>    
   <div class="col-md-12  export_div"> <div class="col-md-4 col-sm-12 datePick-right"><?php if($can_add) {
     echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="addWorkApplication">Add Application</button>';
    } ?></div></div>
                            <table id="" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                      <th>ID
        <span><a href="<?php echo base_url(); ?>hrm/leave_application_worker?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>hrm/leave_application_worker?sort=desc" class="down"></a></span></th>
                                        <th>Worker Name
        <span><a href="<?php echo base_url(); ?>hrm/leave_application_worker?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>hrm/leave_application_worker?sort=desc" class="down"></a></span></th>
                                        
                                        <th>Leave Type</th>
                                        <th>Apply Date</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Duration</th>
                                        <th>Leave Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($application as $value):
                                     $leave_app_details = getNameById('work_leave',$value->id,'id');
                                      $approvevalue=  json_decode($leave_app_details->approvedby_id);
                                      $StatusApprove=  json_decode($leave_app_details->approve_status);
                                      $typeStatus = "";
                                      foreach($StatusApprove as $Status){
                                          $valueeToId=explode(' ', $Status); 
                                           if( $valueeToId[0] == $_SESSION['loggedInUser']->id ){
                                            $typeStatus = $valueeToId[1];
                                          }
                                        }
                                       

                                      
                                      ?>
                                    <tr style="vertical-align:top">
                                       <td><?php echo $value->id; ?></td>
                                        <td><span><?php echo $value->name;   ?> </span></td>
                                        <td><?php echo $value->leave_type; ?></td>
                                        <td><?php echo date('d-m-Y',strtotime($value->apply_date)); ?></td>
                                        <td><?php echo date('d-m-Y',strtotime($value->start_date)); ?></td>
                                        <td><?php echo date('d-m-Y',strtotime($value->end_date)); ?></td>
                                        <td data-label="Duration:">
               <!-- Duration filtering -->
               <?php
                  if($value->leave_duration > 8) {
                      $originalDays = $value->leave_duration;
                      $days = $originalDays / 8;
                      $hour = 0;
                      // 120 / 8 = 15 // 15 day
                      // 13 - (1*8) = 5 hour
                      if(is_float($days)) {
                            $days = floor($days); // 1
                          $hour = $value->leave_duration - ($days * 8); // 5
                      }
                  } else {
                      $days = 0;
                      $hour = $value->leave_duration;
                  }
                   $daysDenom = ($days == 1) ? " day " : " days ";
                  $hourDenom = ($hour == 1) ? " hour " : " hours ";
                  if($days > 0) {
                      echo $days . $daysDenom;
                  } else {
                      echo $hour . $hourDenom;
                  }
                  ?>
            </td>
              <td data-label="Leave Status:">  
              <?php if(!empty($approvevalue)){ 
                  if (in_array($_SESSION['loggedInUser']->id, $approvevalue)) {
                     echo $typeStatus;
                  }else{ echo $value->leave_status;}
                        
                     }   ?>   </td>
         <td data-label="Action:" class="jsgrid-align-center hidde action" style="width:30px;"><i class='fa fa-cog'></i><div class='on-hover-action'> 
              <?php if($_SESSION['loggedInUser']->role == 2 && $_SESSION['loggedInUser']->hr_permissions == 0 ){
               foreach ($approve_by as $asvalue) { 
                foreach ($asvalue as $key => $valuewq) { 
                  if ($_SESSION['loggedInUser']->id==$valuewq) { 
                    if($value->leave_status =='Approve'){   ?>
                <a href="javascript:void(0)" id="<?php  echo $value->id ?>" data-id="viewWorkerLeavApp"  class="hrmTab btn btn-view  btn-xs">View</a>
               <?php }elseif($value->leave_status =='Not Approve'){
                
                if(!empty($approvevalue)){

                  foreach ($approvevalue as $appvalue) {
                   if ($appvalue==$_SESSION['loggedInUser']->id) {  echo ''; goto end2;
                     }else{  
                      ?>
             <button  class="btn btn-sm btn-info waves-effect waves-light StatusW" data-employeeId="<?php echo $value->em_id; ?>"  data-id="<?php echo $value->id; ?>" data-value="Approve" approvedby="<?php echo $_SESSION['loggedInUser']->id;?>" data-duration="<?php echo $value->leave_duration; ?>" data-type="<?php echo $value->typeid; ?>">Approve</button>
              <?php   }  }  
               end2:}elseif (empty($approvevalue)) {?>
                 <button  class="btn btn-sm btn-info waves-effect waves-light StatusW" data-employeeId="<?php echo $value->em_id; ?>"  data-id="<?php echo $value->id; ?>" data-value="Approve" approvedby="<?php echo $_SESSION['loggedInUser']->id;?>" data-duration="<?php echo $value->leave_duration; ?>" data-type="<?php echo $value->typeid; ?>">Approve</button>
               <?php } ?>
               <!-- <button  class="btn btn-sm btn-info waves-effect waves-light StatusW" data-employeeId="<?php echo $value->em_id; ?>"  data-id="<?php echo $value->id; ?>" data-value="Approve" approvedby="<?php echo $_SESSION['loggedInUser']->id;?>" data-duration="<?php echo $value->leave_duration; ?>" data-type="<?php echo $value->typeid; ?>">Approve</button> -->
                <button  class="btn btn-sm btn-info waves-effect waves-light StatusW" approvedby="<?php echo $_SESSION['loggedInUser']->id;?>" data-id = "<?php echo $value->id; ?>" data-value="Rejected">Reject</button>
               <a href="javascript:void(0)"    class="btn btnhrmTab btn   btn-xs StatusW" approvedby="<?php echo $_SESSION['loggedInUser']->id;?>" data-id = "<?php  echo $value->id ?>" data-value="Cancel"> Cancel</a>
               <a href="javascript:void(0)" id="<?php  echo $value->id ?>" data-id="viewWorkerLeavApp"  class="hrmTab btn btn-view  btn-xs">View</a>
              <?php   }  elseif($value->leave_status =='Rejected' || $value->leave_status =='Cancel'){ ?>
             <a href="javascript:void(0)" id="<?php  echo $value->id ?>" data-id="viewWorkerLeavApp"  class="hrmTab btn btn-view  btn-xs">View</a>
              <?php   }  elseif ($value->leave_status =='Approve') { ?>
              <a href="javascript:void(0)" id="<?php  echo $value->id ?>" data-id="viewWorkerLeavApp"  class="hrmTab btn btn-view  btn-xs">View</a>   <?php  } }elseif( in_array($_SESSION['loggedInUser']->id, $approve_by)){
              if($value->leave_status == 'Not Approve'){ ?>
               
               <a href="" approvedby="<?php echo $_SESSION['loggedInUser']->id;?>" title="Edit" class="btn btn-edit btn-xs waves-effect waves-light hrmTab" data-id="addApplication" id="<?php echo $value->id; ?>" >Edit <?php echo $_SESSION['loggedInUser']->id;  ?></a>
             <a href="javascript:void(0)"  approvedby="<?php echo $_SESSION['loggedInUser']->id;?>"  class="btn btnhrmTab btn btn-xs StatusW"data-id = "<?php  echo $value->id ?>" data-value="Cancel"> Cancel <?php echo $valuewq; ?></a>
            <a href="javascript:void(0)" id="<?php  echo $value->id ?>" data-id="viewWorkerLeavApp"  class="hrmTab btn btn-view  btn-xs">View</a>
               <?php }elseif($value->leave_status == 'Approve'){ ?>
            <a href="javascript:void(0)" id="<?php  echo $value->id ?>" data-id="viewWorkerLeavApp"  class="hrmTab btn btn-view  btn-xs">View</a>

            <?php }
                  }
               }
             }
               
                 } elseif($_SESSION['loggedInUser']->role == 1  || !empty($can_edit)){ ?>  
                <?php if($value->leave_status =='Approve'){  ?>

                <a href="javascript:void(0)" id="<?php  echo $value->id ?>" data-id="viewWorkerLeavApp"  class="hrmTab btn btn-view  btn-xs">View</a>
               <?php } elseif($value->leave_status =='Not Approve'){ ?>
               <button  class="btn btn-sm btn-info waves-effect waves-light StatusW" data-employeeId="<?php echo $value->em_id; ?>"  data-id="<?php echo $value->id; ?>" approvedby="<?php echo $_SESSION['loggedInUser']->id;?>" data-value="Approve" data-duration="<?php echo $value->leave_duration; ?>" data-type="<?php echo $value->typeid; ?>">Approve</button>
                <button  class="btn btn-sm btn-info waves-effect waves-light StatusW" approvedby="<?php echo $_SESSION['loggedInUser']->id;?>" data-id = "<?php echo $value->id; ?>" data-value="Rejected">Reject</button>
               <a href="javascript:void(0)"    class="btn btnhrmTab btn   btn-xs StatusW" approvedby="<?php echo $_SESSION['loggedInUser']->id;?>" data-id = "<?php  echo $value->id ?>" data-value="Cancel"> Cancel</a>
               <a href="javascript:void(0)" id="<?php  echo $value->id ?>" data-id="viewWorkerLeavApp"  class="hrmTab btn btn-view  btn-xs">View</a>
              <?php } elseif($value->leave_status =='Rejected' || $value->leave_status =='Cancel'){ ?>
             <a href="javascript:void(0)" id="<?php  echo $value->id ?>" data-id="viewWorkerLeavApp"  class="hrmTab btn btn-view  btn-xs">View</a>
               <?php }  }elseif($_SESSION['loggedInUser']->role == 2 && $_SESSION['loggedInUser']->hr_permissions == 1){ ?>
             <?php if($value->leave_status =='Approve'){ ?>
                <a href="javascript:void(0)" id="<?php  echo $value->id ?>" data-id="viewWorkerLeavApp"  class="hrmTab btn btn-view  btn-xs">View</a>
               <?php } elseif($value->leave_status =='Not Approve'){  ?>

               <button  class="btn btn-sm btn-info waves-effect waves-light StatusW" data-employeeId="<?php echo $value->em_id; ?>"  data-id="<?php echo $value->id; ?>" data-value="Approve" approvedby="<?php echo $_SESSION['loggedInUser']->id;?>" data-duration="<?php echo $value->leave_duration; ?>" data-type="<?php echo $value->typeid; ?>">Approve</button>
                <button  class="btn btn-sm btn-info waves-effect waves-light StatusW" approvedby="<?php echo $_SESSION['loggedInUser']->id;?>" data-id = "<?php echo $value->id; ?>" data-value="Rejected">Reject</button>
               <a href="javascript:void(0)"    class="btn btnhrmTab btn   btn-xs StatusW" approvedby="<?php echo $_SESSION['loggedInUser']->id;?>" data-id = "<?php  echo $value->id ?>" data-value="Cancel"> Cancel</a>
               <a href="javascript:void(0)" id="<?php  echo $value->id ?>" data-id="viewWorkerLeavApp"  class="hrmTab btn btn-view  btn-xs">View</a>
              <?php } elseif($value->leave_status =='Rejected' || $value->leave_status =='Cancel'){ ?>
             <a href="javascript:void(0)" id="<?php  echo $value->id ?>" data-id="viewWorkerLeavApp"  class="hrmTab btn btn-view  btn-xs">View</a>
              <?php   } }  ?>
              </div>
            </td> 
         </tr>
         <?php endforeach; ?>
                                </tbody>
                            </table>
        <?php  echo $this->pagination->create_links(); ?>
   <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">  
   <?php echo $result_count; ?></span></div>
                       </div>
                            <div id="printThis">
<div id="hrm_modal" class="modal fade in btnPrint"  role="dialog">
    <div class="modal-dialog modal-lg modal-large">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Worker Leave Application</h4>
            </div>
            <div class="modal-body-content"></div>
        </div>
    </div>
</div>
</div>         