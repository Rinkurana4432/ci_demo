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
				  echo (!empty($machine->machine_name))?$machine->machine_name:$viewbreakdown->machine_name; ?></div>
               </div>
            </div>
            <?php if(!empty($viewbreakdown->machine_type)){ ?>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Problem Type :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php echo $viewbreakdown->machine_type; ?></div>
               </div>
            </div>
            <?php } ?>
            <?php if(!empty($viewbreakdown->requested_by)){ ?>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Request By :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php echo $viewbreakdown->requested_by; ?></div>
               </div>
            </div>
            <?php } ?>
            <?php if(!empty($viewbreakdown->acknowledge)){ ?>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Acknowledge Date :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php echo $viewbreakdown->acknowledge; ?></div>
               </div>
            </div>
            <?php } ?>
            <?php if(!empty($viewbreakdown->conective_entry)){ ?>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Connective Entry :</label>
               <div class="col-md-6 col-sm-12 cl-xs-12 form-group">
                  <div><?php echo $viewbreakdown->conective_entry; ?></div>
               </div>
            </div>
            <?php } ?>
			<?php if(!empty($viewbreakdown->required_time)){ ?>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Required Assign Time :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdown->required_time)){ 
						echo $viewbreakdown->required_time; } ?></div>
               </div>
            </div>
            <?php } ?> 		
         </div>
         <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
            <?php if(!empty($viewbreakdown->breakdown_couses)){ ?>		
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Breakdown Causes :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php echo $viewbreakdown->breakdown_couses; ?></div>
               </div>
            </div>
            <?php } ?>
            <?php if(!empty($viewbreakdown->priority)){ ?>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Priority :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php echo $viewbreakdown->priority; ?></div>
               </div>
            </div>
            <?php } ?>
            <?php if(!empty($viewbreakdown->aknowlwdge_by)){ ?>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Acknowledge By :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php echo $viewbreakdown->aknowlwdge_by; ?></div>
               </div>
            </div>
            <?php } ?>             
			<?php if(!empty($viewbreakdown->assign_worker)){ ?>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Assigned Worker :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdown->assign_worker)){ 
						$workers = getNameById('worker',$viewbreakdown->assign_worker,'id');
						echo isset($workers->name)?$workers->name:''; } ?></div>
               </div>
            </div>
            <?php } ?> 			
	
			<?php if(!empty($viewbreakdown->complete_time)){ ?>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Actual Time Taken :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div><?php if(!empty($viewbreakdown->complete_time)){ 
						echo $viewbreakdown->complete_time; } ?></div>
               </div>
            </div>
            <?php } ?> 
         </div>
      </div>
   </div>
   </div>
</form>
<center>
   <button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
</center>