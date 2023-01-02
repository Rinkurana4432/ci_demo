<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveAddMachine" enctype="multipart/form-data" id="add_machine" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php //if($AddMachine && !empty($AddMachine)){ echo $AddMachine->id;} ?>">
   <div class="col-md-12 col-sm-12 col-xs-12" id="print_divv"  style="padding:0px;">
      <div class="table-responsive" >
         <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Machine Name :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div>
				  <?php $machine = getNameById('add_machine',$viewbreakdown->machine_id,'id');
				  echo (!empty($machine->machine_name))?$machine->machine_name:$viewbreakdown->machine_name; ?>
				  </div>
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Problem Type :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdown->machine_type)){ echo $viewbreakdown->machine_type; } ?></div>
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Requested By :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdown->requested_by)){ echo $viewbreakdown->requested_by; } ?></div>
               </div>
            </div>
         </div>
         <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Breakdown Causes :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdown->breakdown_couses)){ echo $viewbreakdown->breakdown_couses; } ?></div>
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Priority :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdown->priority)){ echo $viewbreakdown->priority; } ?></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
</form>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>maintenance/updateaknowledge" enctype="multipart/form-data" id="similarmachine" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php echo $viewbreakdown->id; ?>">
   <input type="hidden" name="machine_id" value="<?php echo $viewbreakdown->machine_id; ?>"> 
   <input type="hidden" name="machine_name" value="<?php echo $viewbreakdown->machine_name; ?>"> 
   <input type="hidden" name="machine_type" value="<?php echo $viewbreakdown->machine_type; ?>"> 
   <input type="hidden" name="breakdown_couses" value="<?php echo $viewbreakdown->breakdown_couses; ?>"> 
   <input type="hidden" name="priority" value="<?php echo $viewbreakdown->priority; ?>"> 
   <input type="hidden" name="request_status" value="<?php echo $viewbreakdown->request_status; ?>"> 
   <input type="hidden" name="requested_by" value="<?php echo $viewbreakdown->requested_by; ?>"> 
   <input type="hidden" name="save_status" value="1" class="save_status">	
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">  
   <input type="hidden" name="aknowlwdge_by" value="<?php echo $_SESSION['loggedInUser']->name; ?>" id="loggedUser"> 
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Acknowledge Date</label>		
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="date" name="acknowledge" id="acknowledge" class="form-control col-md-7 col-xs-12 req_date">
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Assign Worker</label>		
         <div class="col-md-6 col-sm-12 col-xs-12">

			  <select class="form-control selectAjaxOption select2 select2-hidden-accessible assign_worker select2" required="required" name="assign_worker" data-id="worker" data-key="id" data-fieldname="name" data-where="created_by_cid='<?php echo $_SESSION['loggedInUser']->c_id; ?>' AND worker_type='maintenance'" tabindex="-1" aria-hidden="true" >
               <option value="">Select option</option>
			   		<?php 
						if(!empty($viewbreakdown->assign_worker)){
						$workers = getNameById('worker',$viewbreakdown->assign_worker,'id');
						echo '<option value="'.$workers->id.'" selected>'.$workers->name.'</option>';
							 }
					?>
            </select>
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