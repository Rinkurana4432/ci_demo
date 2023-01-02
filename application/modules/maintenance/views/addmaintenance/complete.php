<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>maintenance/updateaknowledge" enctype="multipart/form-data" id="similarmachine" novalidate="novalidate">
<?php //pre($viewbreakdowncom);die; ?>
   <input type="hidden" name="b_id" value="<?php //if($AddMachine && !empty($AddMachine)){ echo $AddMachine->id;} ?>">
   <div class="col-md-12 col-sm-12 col-xs-12" id="print_divv"  style="padding:0px;">
      <div class="table-responsive" >
         <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Machine Name :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php //if(!empty($viewbreakdowncom->machine_name)){ echo $viewbreakdowncom->machine_name; } ?>
				  <?php $machine = getNameById('add_machine',$viewbreakdowncom->machine_id,'id');
				  echo (!empty($machine->machine_name))?$machine->machine_name:$viewbreakdowncom->machine_name; ?>
				  </div>
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Problem Type :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdowncom->machine_type)){ echo $viewbreakdowncom->machine_type; } ?></div>
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Requested By :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdowncom->requested_by)){ echo $viewbreakdowncom->requested_by; } ?></div>
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Acknowledge Date :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdowncom->acknowledge)){ echo $viewbreakdowncom->acknowledge; } ?></div>
               </div>
            </div>     
			
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Required Assign Time:</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdowncom->required_time)){ echo $viewbreakdowncom->required_time; } ?></div>
               </div>
            </div>
         </div>
         <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Breakdown Causes :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdowncom->breakdown_couses)){ echo $viewbreakdowncom->breakdown_couses; } ?></div>
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Priority :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdowncom->priority)){ echo $viewbreakdowncom->priority; } ?></div>
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Acknowledge By :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdowncom->acknowledge)){ echo $viewbreakdowncom->acknowledge; } ?></div>
               </div>
            </div>         
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="worker">Assigned Worker:</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdowncom->assign_worker)){ 
						$workers = getNameById('worker',$viewbreakdowncom->assign_worker,'id');
						echo isset($workers->name)?$workers->name:''; } ?></div>
               </div>
            </div>
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Actual Time Taken:</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div> <input type="text" name="complete_time" class="form-control col-md-7 col-xs-12"  placeholder="Actual Time Taken" value="<?php if(!empty($viewbreakdowncom->complete_time)){ echo $viewbreakdowncom->complete_time; } ?>" /></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>

   <input type="hidden" name="id" value="<?php echo $viewbreakdowncom->id; ?>">
   <input type="hidden" name="machine_name" value="<?php echo $viewbreakdowncom->machine_name; ?>"> 
   <input type="hidden" name="machine_type" value="<?php echo $viewbreakdowncom->machine_type; ?>"> 
   <input type="hidden" name="priority" value="<?php echo $viewbreakdowncom->priority; ?>"> 
   <input type="hidden" name="request_status" value="1"> 
   <input type="hidden" name="requested_by" value="<?php echo $viewbreakdowncom->requested_by; ?>"> 
   <input type="hidden" name="acknowledge" value="<?php echo $viewbreakdowncom->acknowledge; ?>">
   <input type="hidden" name="aknowlwdge_by" value="<?php echo $viewbreakdowncom->aknowlwdge_by; ?>">
   <input type="hidden" name="assign_worker" value="<?php echo $viewbreakdowncom->assign_worker; ?>">
   <input type="hidden" name="save_status" value="1" class="save_status">
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">  
   <input type="hidden" name="aknowlwdge_by" value="<?php echo $_SESSION['loggedInUser']->name; ?>" id="loggedUser"> 
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Reason failure</label>		
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea calss="form-control col-md-7 col-xs-12" name="breakdown_couses" id="breakdown_couses"><?php echo $viewbreakdowncom->breakdown_couses; ?></textarea>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12"> Connective Entry </label>		
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea calss="form-control col-md-7 col-xs-12" name="conective_entry" id=""></textarea>
         </div>
      </div>
   </div>
   </div>
   <div class="form-group">
      <div class="col-md-6 col-md-offset-3">
         <button type="reset" class="btn btn-default edit-end-btn">Reset</button>
         <!--input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft"-->
         <button id="send" type="submit" class="btn edit-end-btn">Submit</button>
         <a class="btn edit-end-btn" onclick="location.href='<?php echo base_url();?>maintenance/breakdown'">Cancel</a>
      </div>
   </div>
</form>
<script>
   $(function() {
     $('input[name="complete_time"]').daterangepicker({
       timePicker: true,
       startDate: moment().startOf('hour'),
       endDate: moment().startOf('hour').add(32, 'hour'),
       locale: {
         format: 'M/DD hh:mm A'
       }
     });
   });
</script>