<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>maintenance/updatebdpipeline" enctype="multipart/form-data" id="similarmachine" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php echo $editbdpipeline->id; ?>"> 
   <input type="hidden" name="save_status" value="1" class="save_status">	
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">  
   <input type="hidden" name="aknowlwdge_by" value="<?php echo $editbdpipeline->aknowlwdge_by; ?>" id="aknowlwdge_by"> 
   <input type="hidden" name="requested_by" value="<?php echo $editbdpipeline->requested_by; ?>" id="requested_by">  
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Machine Name</label>		
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select name="machine_name" id="machine_name" class="form-control col-md-7 col-xs-12">
               <?php foreach($machinename as $machinekey => $machinenames){ ?>
               <option value="<?php echo $machinenames['machine_name'];?>" <?php if($machinenames['machine_name'] == $editbdpipeline->machine_name){ echo "selected"; } ?> ><?php echo $machinenames['machine_name']; ?></option>
               <?php } ?>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Problem Type</label>		
         <div class="col-md-6 col-sm-12 col-xs-12">
            <label class="radio-inline">
            <input type="radio" value="electronic" name="machine_type" <?php if($editbdpipeline->machine_type =='electronic' ){ echo "checked"; } ?> >Electronic
            </label>
            <label class="radio-inline">
            <input type="radio" value="machnical" <?php if($editbdpipeline->machine_type =='machnical' ){ echo "checked"; } ?> name="machine_type">Machnical
            </label>
            <label class="radio-inline">
            <input type="radio" value="electronic & machnical" <?php if($editbdpipeline->machine_type =='electronic & machnical' ){ echo "checked"; } ?> name="machine_type">Both
            </label> 				
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Work Status</label>		
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control" name="work_status">
               <option value="1" <?php if($editbdpipeline->work_status =='1'){ echo "selected"; } ?> >Pending</option>
               <option value="2" <?php if($editbdpipeline->work_status =='2'){ echo "selected"; } ?> >Backlog</option>
               <option value="3" <?php if($editbdpipeline->work_status =='3'){ echo "selected"; } ?> >Repaired</option>
            </select>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Breakdown Causes</label>		
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input id="breakdown_couses" class="form-control col-md-7 col-xs-12" name="breakdown_couses" placeholder="Breakdown Couses" required="required" type="text" value="<?php echo $editbdpipeline->breakdown_couses; ?>"> 				
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Priority</label>		
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control" name="priority">
               <option value="high" <?php if($editbdpipeline->priority =='high'){ echo "selected"; } ?> >High</option>
               <option value="medium" <?php if($editbdpipeline->priority =='medium'){ echo "selected"; } ?> >Medium</option>
               <option value="low" <?php if($editbdpipeline->priority =='low'){ echo "selected"; } ?> >Low</option>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-2 col-xs-4" for="description">Job End Time &amp; Date</label>
         <div class="col-md-7 col-sm-10 col-xs-8">
            <input type="datetime-local" class="form-control has-feedback-left datePicker" name="acknowledge" id="order_date" value="<?php echo $editbdpipeline->acknowledge;?>">
            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            <span id="inputSuccess2Status3" class="sr-only">(success)</span>
         </div>
      </div>
   </div>
   <div class="form-group">
      <div class="col-md-6 col-md-offset-3">
         <button type="reset" class="btn btn-default edit-end-btn">Reset</button>
         <!--input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft"-->
         <button id="send" type="submit" class="btn edit-end-btn">Submit</button>
		  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>
      </div>
   </div>
</form>
<script>
   var measurementUnits = <?php echo json_encode(getUom()); ?>;
   var logged_user = <?php echo $_SESSION['loggedInUser']->c_id; ?>;				
</script>
<!---------------------------------add machine group on the spot----------------------------------------------------->	
<div class="modal left fade" id="myModal_Add_machine_group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="position:absolute;">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Machine Group</h4>
            <span id="mssg34"></span>
         </div>
         <form name="insert_worker_data" name="ins"  id="insert_worker_data_id">
            <div class="modal-body">
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Machine group<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="machine_group_id" name="machine_group_name" required="required" class="form-control col-md-7 col-xs-12" value="">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <input type="hidden" id="add_machine_group_onthe_spot">
                  <button type="button" class="btn btn-default close_sec_model" >Close</button>
                  <button id="Add_group_details_on_button_click" type="button" class="btn edit-end-btn ">Submit</button>
               </center>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- /page content -->