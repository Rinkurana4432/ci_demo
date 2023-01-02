<?php 
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   ?>
<style>
   .Process-card {
   box-shadow: rgba(0, 0, 0, 1) 1px 1px 9px -4px;
   }
   .Process-card {
   clear: both;
   display: table;
   width: 99%;
   border: 1px solid #c1c1c1;
   padding: 15px;
   margin: 0px auto 20px;
   }
   .mobile-view3 {
   display: table-row;
   }
   .label-box {
   padding: 0px;
   }
   #print_divv #chkIndex_1 label {
   margin: 0px;
   padding: 8px 10px;
   text-align: center;
   border-right: 1px solid #c1c1c1;
   border-bottom: 1px solid #c1c1c1;
   background-color: #FFF;
   display: block;
   width: 100%;
   overflow: hidden;
   text-overflow: ellipsis;
   white-space: nowrap;
   display: block;
   border-left: 0px;
   }
   #print_divv #chkIndex_1 .form-group {
   margin-bottom: 0px;
   }
   #print_divv #chkIndex_1 .form-group {
   padding: 0px;
   }
   .mobile-view3 .form-group {
   display: table-cell;
   float: unset;
   width: 1%;
   }
   .view-page-mobile-view .form-group {
   width: 1%;
   float: unset;
   display: table-cell;
   padding: 8px !important;
   background-color: #fff !important;
   border-bottom: 1px solid #c1c1c1 !important;
   border-right: 1px solid #c1c1c1 !important;
   border-top: 0px !important;
   }
   .mobile-view label {
   display: none !important;
   }
   div {
   display: block;
   }
   .col-container {
   margin: 0px;
   display: table-row;
   width: 100%;
   padding: 0px;
   background: unset;
   border: 0px;
   float: unset;
   }
   .total-main .col {
   border-right: 0px !important;
   background-color: #DCDCDC !important;
   color: #2C3A61;
   }
</style>
<?php  #  pre($leave_app_details);die; ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/save_assign_emp" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
   <div style="width:100%" id="print_divv" border="1" cellpadding="2">
     
    
       
      
      
      <h3 class="Material-head">
         Application Details
         <hr>
      </h3>
      <div class="col-md-12 col-xs-12 col-sm-12" id="chkIndex_1" style="padding:0px; border-top:0px;">
         <div class="Process-card">
            <!--<h3 class="Material-head">Porduction Details<hr></h3>-->                              
            <div class="label-box mobile-view3">
               <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Employee Name</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Leave Type</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Apply Date</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Start Date</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>End Date</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Leave Status</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Created By</label></div>
            </div>
            <?php
           /* pre($leave_app_details);*/
            if(!empty($leave_app_details)){  ?>
                

                        <div class="row-padding col-container mobile-view view-page-mobile-view"   >
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group col" style="border-left: 1px solid #c1c1c1 !important;">
                              <label>Employee Name</label>
                              <div> <?php  $owner = getNameById('worker',$leave_app_details->em_id,'id'); ?>
                                    <?php if(!empty($owner)){echo $owner->name;} ?> 
                               </div> 
                           </div>
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                              <label>Leave Type</label>
                              
                                  <div> <?php  $owner2 = getNameById('leave_types',$leave_app_details->typeid,'id'); ?>
                                    <?php if(!empty($owner2)){echo $owner2->name;} ?>   
                               </div> 
                          
                           </div>
                         
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                              <label>Apply Date</label>
                              <div><?php if(!empty($leave_app_details)){ echo $leave_app_details->apply_date; } ?></div>
                           </div>
                              <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                              <label>Start Date</label>
                              <div><?php if(!empty($leave_app_details)){ echo $leave_app_details->start_date; } ?></div>
                           </div>
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                              <label>End Date</label>
                              <div><?php if(!empty($leave_app_details)){ echo $leave_app_details->end_date; } ?></div>
                           </div>           
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                              <label>Leave Status</label>
                              <div><?php if(!empty($leave_app_details)){ echo $leave_app_details->leave_status; } ?></div>
                           </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                              <label>Created By</label> 
                              <div> 
                              <?php  $owner = getNameById('user_detail',$leave_app_details->created_by,'u_id'); ?>
                                    <?php if(!empty($owner)){echo $owner->name;} ?> 
                              </div>
                           </div>
                           
                        </div>
            <?php     
                     
                    }   
              ?>

         </div>
      </div>
      <hr>
      <div class="bottom-bdr"></div>
        <div class="col-md-12 col-sm-12 col-xs-12  vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Reason For Leave</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($leave_app_details)){ echo $leave_app_details->reason; } ?>
            </div>
         </div>
       </div>
     
        <div class="col-md-12 col-sm-12 col-xs-12  vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Approved By</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($leave_app_details)){ 
                $approvevalue=  json_decode($leave_app_details->approve_status);
                if(!empty($approvevalue)){
                foreach ($approvevalue as $appvalue) {
                  $msg='';
                   $valueeToId=explode(' ', $appvalue);
                    $ownerw = getNameById('user_detail',$valueeToId[0],'u_id');
                    if ($valueeToId[1]=='Rejected') {
                        $msg='<i class="fa fa-times" aria-hidden="true" style="color:red;"></i>';
                     }else if($valueeToId[1]=='Approve'){
                         $msg='<i class="fa fa-check" aria-hidden="true" style="color:green;" ></i>';
                     } 
                    if(!empty($ownerw)){ echo $ownerw->name .' / '. $valueeToId[1] .' '. $msg .' </br> ';
                   }
                 }
                  
                }
                 } ?>
            </div>
         </div>
       </div>
      
    
   </div>
</form>