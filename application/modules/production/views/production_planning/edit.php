 <?php $companyId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ; ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveProductionPlanning" enctype="multipart/form-data" id="productionPlan" novalidate="novalidate">
   <input type="hidden" value="<?php if(!empty($production_plan)){ echo $production_plan->id ;}?>" name="id" id="edit_id">
   <?php /*<input type="hidden" id="current_login_com_id" value="<?php  echo $_SESSION['loggedInUser']->c_id; ?>" > */ ?>	
   <input type="hidden" id="current_login_com_id" value="<?php  echo $companyId; ?>" >	
   <input type="hidden" name="save_status" value="1" class="save_status">
   <?php
      if(empty($production_plan)){
      ?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <?php }else{ ?>	
   <input type="hidden" name="created_by" value="<?php if($production_plan && !empty($production_plan)){ echo $production_plan->created_by;} ?>" >
   <?php } ?>
   <?php /*	<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser"> */ ?>
   <input type="hidden" name="logged_in_user" value="<?php echo $companyId; ?>" id="loggedUser">
   <div class="col-md-6 col-sm-12 col-sx-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-2 col-xs-12" for="worker_name">Supervisor Name </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <!--input type="text" id="supervisor_name" name="supervisor_name"  class="form-control col-md-7 col-xs-12" placeholder="Supervisor Name" value="<?php //if(!empty($production_plan)) echo $production_plan->supervisor_name; ?>"-->
			<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="supervisor_name" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $_SESSION['loggedInUser']->c_id; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">
				<option value="">Select Option</option>
				 <?php
					if(!empty($production_plan)){
						$owner = getNameById('user_detail',$production_plan->supervisor_name,'u_id');
						// pre($owner);
						echo '<option value="'.$production_plan->supervisor_name.'" selected>'.$owner->name.'</option>';
					}
				?>
			</select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 compny_unit" required="required" name="company_branch" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
               <option value="">Select Unit</option>
               <?php
                  if(!empty($production_plan)){
                  	#$getUnitName = getNameById('company_address',$production_plan->unit_name,'compny_branch_id');
                  	$getUnitName = getNameById('company_address',$production_plan->company_branch,'compny_branch_id');
                  	#echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                  	echo '<option value="'.$production_plan->company_branch.'" selected>'.$getUnitName->company_unit.'</option>';
                  }
                  
                  ?>
            </select>
            <!--select class="form-control  select2 get_location compny_unit" required="required" name="company_branch" onChange="getDept(event,this)">
               <option value="">Select Option</option>
               	<?php
                  /* if(!empty($production_plan)){
                  	echo '<option value="'.$production_plan->company_branch.'" selected>'.$production_plan->company_branch.'</option>';
                  	} */
                  ?>
               </select-->
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12">Department</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <!--<select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="department_id"  tabindex="-1" aria-hidden="true">-->
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="department_id"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = '<?php echo (!empty($production_plan))?$production_plan->company_branch:''; ?>'" >
               <option value="">Select Option</option>
               <?php
                  if(!empty($production_plan)){
                  	$departmentData = getNameById('department',$production_plan->department_id,'id');
                  	if(!empty($departmentData)){
                  		echo '<option value="'.$departmentData->id.'" selected>'.$departmentData->name.'</option>';
                  	}
                  }
                  ?>								
            </select>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-sx-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="shift">Shift<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <?php if(empty($production_plan)){?>
            <div class="radio_button"></div>
            <div class="Displaymessage"></div>
            <?php }else{
               if(!empty($productionSetting)){
               foreach($productionSetting as $ps){	 
                 if($production_plan->department_id == $ps['department']){
               ?>
            <div class="radio_edit">
               <label>
               <?php
               foreach (json_decode($ps['shift_name']) as $key => $value) {
               ?>
               <input type="hidden" class="flat" name="shift" value="<?php echo $ps['id']; ?>"><input type="radio" class="flat" name="shift_name" value="<?php echo $value; ?>" <?php if($production_plan->shift_name == $value){ echo 'checked'; } ?>  ><?php echo $value; ?></br>
               <?php
               }
               ?>
               </label>
            </div>
            <?php }/*else{?>
            <div class="radio_edit">
               <label>
               <input type="radio" class="flat" name="shift" value="<?php echo $ps['id']; ?>" <?php //if($production_plan->shift == $ps['id']){echo 'checked';} ?>><?php echo $ps['shift_name']; ?></br>
               </label>
            </div>
            <?php }*/
               }}?>
            <div class="radio_button"></div>
            <div class="Displaymessage"></div>
            <?php }?> 
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="date">Date<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input id="planningDate" class="form-control col-md-2 col-xs-12 date" name="date" placeholder="date" required="required" type="text" value="<?php if($production_plan && !empty($production_plan)){echo $production_plan->date; }?>" onkeydown="event.preventDefault()">
         </div>
      </div>
   </div>
   <hr>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="item form-group" style="overflow-y: scroll;">
      <div class="table table-striped dataTable mainPlantable btn_heading_hide rTable" id="prodPlan" style="display: none;">
         <div class="app_div_planing ">
            <div class="rTableRow mobile-view2">
               <div class="rTableHead"><label>Machine Name<span class="required">*</span></label></div>
               <div class="rTableHead"><label>Party Specification</label></div>
               <div class="rTableHead"><label>Work Order</label></div>
               <div class="rTableHead"><label>Product Name</label></div>
               <div class="rTableHead"><label>BOM Routing</label></div>
               <div class="rTableHead"><label>Assign Process</label></div>
               <div class="rTableHead"><label>NPDM</label></div>
               <div class="rTableHead"><label>Worker</label></div>
               <div class="rTableHead"><label>Output</label></div>
               <div class="rTableHead" ><label></label></div>
            </div> 
            <?php if($production_plan){ 
               $productionPlan = json_decode($production_plan->planning_data);
               	if(!empty($productionPlan)){
               		//$i=0;
               		$k=0;
               		foreach($productionPlan as $prodplanData){
               			//pre($prodplanData);
               			$machineCount = count($prodplanData->machine_name_id);
               			//pre($machineCount);
               			for($i=0; $i<$machineCount ; $i++){
               				//pre($i);
               				$jobCardData = isset($prodplanData->job_card_product_name[$i])?(getNameById('job_card',$prodplanData->job_card_product_name[$i],'id')):'';
               				$machineName = isset($prodplanData->machine_name_id[$i])?(getNameById('add_machine',$prodplanData->machine_name_id[$i],'id')):'';
               				//$workerId = $prodplanData->worker;
               			  //pre($iobCardData);
               			  //pre($machineName);
               			 // pre($iobCardData);
               ?>
            <div class="rTableRow mobile-view" id="<?php echo ($i==0)?('index_'.$k):('addFunc_'.$i);?>">
               <div class="rTableCell">
                  <input class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Machine Name"  type="hidden" value="<?php if(!empty($machineName)){echo $machineName->id ;}?>" readonly>
                  <input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Machine Name"  type="text" value="<?php if(!empty($machineName)){echo $machineName->machine_name;} ?>" readonly>
                  <input  class="form-control col-md-2 col-xs-12 machine_grp" name="machine_grp[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Machine Name"  type="hidden" value="<?php echo $machineName->machine_group_id;?>" readonly>					
               </div>
               <div class="rTableCell">
                  <textarea id= "specification" class="form-control col-md-2 col-xs-12" Placeholder ="Add Specification" name="specification[<?php echo $k; ?>][<?php echo $i; ?>]"><?php if(isset($prodplanData->specification[$i])) echo $prodplanData->specification[$i]; ?></textarea> 
               </div>
<?php /*                <div class="rTableCell">
                  <label>Sale order</label>
                  <select class="form-control dis selectAjaxOption select2 select2-hidden-accessible sale_order_cls" id ="sale_order" name="sale_order[<?php echo $k; ?>][<?php echo $i; ?>]" width="100%" tabindex="-1" aria-hidden="true"  data-id="sale_order" data-key="id" data-fieldname="so_order" tabindex="-1" onchange="getMaterialNamesaleorder(event,this)" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status = 1 AND save_status = 1 OR approve = 1 OR complete_status = 1 AND disapprove = 0">
                     <option>Select Option</option>
                     <?php 
                        if(!empty($prodplanData)){
                        	//pre($productionDetail);
                        	$sale_order = isset($prodplanData->sale_order[$i])?getNameById('sale_order',$prodplanData->sale_order[$i],'id'):'';
                        	echo '<option value="'.$sale_order->id.'" selected>'.$sale_order->so_order.'</option>';
                        }
                        ?>
                  </select>
               </div> */ ?>
			   <div class="rTableCell">
                <label>Work Order</label>	
				  <select class="form-control dis selectAjaxOption removefildswork select2 select2-hidden-accessible WorkOrderId"  name="work_order[<?php echo $k; ?>][<?php echo $i; ?>]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" onchange="getMaterialNameWorkorder(event,this)" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND progress_status = 0 AND company_branch_id=<?php echo $production_plan->company_branch; ?> AND department_id=<?php echo $production_plan->department_id; ?>">
                     <option value="">Select Option</option>
                     <?php 
                        if(!empty($prodplanData)){
                        	//pre($productionDetail);
                        	$work_order = isset($prodplanData->work_order[$i])?getNameById('work_order',$prodplanData->work_order[$i],'id'):'';
                        	echo '<option value="'.$work_order->id.'" selected>'.$work_order->workorder_name.'</option>';
                        }
                        ?>
                  </select>
				  <input type="hidden"  name="sale_order[<?php echo $k; ?>][<?php echo $i; ?>]"  value="<?php echo isset($prodplanData->sale_order[$i])?$prodplanData->sale_order[$i]:''; ?>" class="SelectedSaleOrder">

               </div>
               <div class="rTableCell">
                  <label>Product Name</label>	
                  <select class="form-control party_code_cls selectAjaxOption24 select2 productNameId dis"  name="product_name[<?php echo $k; ?>][<?php echo $i; ?>]" width="100%"  id="product_name">
                     <option value="">Select Option</option>
                     <?php 
                        #pre($prodplanData->product_name);
                        		if(!empty($prodplanData)){
                        			
                        			$sale_order23 = isset($prodplanData->product_name[$i])?getNameById('material',$prodplanData->product_name[$i],'id'):'';
                        
                        			echo '<option value="'.$sale_order23->id.'" selected>'.$sale_order23->material_name.'</option>';
                        		}
                        ?>
                  </select>
               </div>
               <div class="rTableCell">
                  <label>BOM Routing Product Name</label>
                  <?php 
                     //pre($jobCardData);
                     $jobCardData = isset($prodplanData->job_card_product_id[$i])?(getNameById('job_card',$prodplanData->job_card_product_id[$i],'id')):''; ?>
                  <?php /*<input id="job_card_product_name" class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[]" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){ echo $jobCardData->job_card_product_name;} else{echo "";}?>">*/?>
                  <input id="job_card_product_name" class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){ echo $jobCardData->job_card_no;} else{echo "";}?>">
                  <?php /*	<input type="hidden" id="job_card_product_id" class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[<?php echo $k; ?>][<?php echo $i; ?>]_<?php echo $k; ?>" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){echo $jobCardData->id;} else{echo "";}?>">*/?>
                  <input type="hidden" id="job_card_product_id" class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[<?php echo $k; ?>][<?php echo $i; ?>]_<?php echo $k; ?>" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){echo $jobCardData->id;} else{echo "";}?>">
               </div>
               <div class="rTableCell">
                  <label>Assign Process</label>	       
                  <select onchange="get_outputPP(event,this);"  class="form-control process_name" name="process_name[<?php echo $k; ?>][<?php echo $i; ?>]" id="process_name">
                     <option value="">Select Option</option>
                     <?php if(!empty($prodplanData)){
                        $process = isset($prodplanData->process_name[$i])?getNameById('add_process',$prodplanData->process_name[$i],'id'):'';
                        echo '<option value="'.$process->id.'" selected>'.$process->process_name.'</option>';
                        }?>
                  </select>
                  <input type="hidden" name="inpt_outpt_process[<?php echo $k; ?>][<?php echo $i; ?>]" id="inpt_outpt_process" value="">
               </div>
               <div class="rTableCell">
                  <label>NPDM</label>	
                  <select class="selectAjaxOption select2 form-control npdm" name="npdm_name[<?php echo $k; ?>][<?php echo $i; ?>]" data-id="npdm" id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm" data-where="created_by_cid = <?php echo $_SESSION['loggedInUser']->c_id; ?>">
                     <option value="">Select Option</option>
                     <?php if(!empty($prodplanData)){
                        //pre($productionDetail);
                        		$npdm1 = isset($prodplanData->npdm[$i])?getNameById('npdm',$prodplanData->npdm[$i],'id'):'';
                        		echo '<option value="'.$npdm1->id.'" selected>'.$npdm1->product_name.'</option>';
                        }?>
                  </select>
               </div>
               <div class="rTableCell worker-row">
                  <?php $workerName_id[$i] = isset($prodplanData->worker[$i])?($prodplanData->worker[$i]):'';  ?>
                  <select multiple class="worker_name form-control col-md-2 col-xs-12 "   name="worker_name[<?php echo $k; ?>][<?php echo $i; ?>][]"  data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
                  <?php 
                     if(!empty($workerName_id[$i])){
                     	foreach($workerName_id[$i] as $worker_Name){
                     		$Workername = getNameById('worker',$worker_Name,'id');
                     		echo '<option value="'.$worker_Name.'" selected>'.$Workername->name.'</option>';
                     	}
                     } 
                     ?> 	
                  </select>
               </div>
               <div class="rTableCell">

                  <?php
                  //pre($prodplanData);
                  $jobCardData = isset($prodplanData->job_card_product_id[$i])?(getNameById('job_card',$prodplanData->job_card_product_id[$i],'id')):'';
                  $machine_details = json_decode($jobCardData->machine_details);
                  if($process->id != 0){
                  $key = array_search($process->id, array_column($machine_details, 'processess'));
                  if($key === 0 || $key >= 1){
                  $detail_info = $machine_details[$key];
                  $output_process_dtl = (!empty($detail_info->output_process) && isset($detail_info->output_process))?$detail_info->output_process:'';
                  $process_sch_output = json_decode($output_process_dtl);
                  }
                  }
                  $out = 0;
                  foreach($process_sch_output as $val_output_sech){
                  $material_id_output = $val_output_sech->material_output_name;
                  $materialName_output = getNameById('material',$material_id_output,'id');
                  ?>
                  <input style="width:50%; float:left;" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $materialName_output->material_name; ?>" readonly="">
                  <input style="width:50%; float:left;" id="output" class="form-control col-md-7 col-xs-12 output" name="output[<?php echo $k; ?>][<?php echo $i; ?>][<?php echo $out; ?>]" placeholder="output"  type="text" value="<?php if(isset($prodplanData->output[$i][$out])) echo $prodplanData->output[$i][$out];?>" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)">
                  <?php $out++; } ?>


                  <!--input id="output" class="form-control col-md-2 col-xs-12" name="output[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="output" type="number" value="<?php if(isset($prodplanData->output[$i])) echo $prodplanData->output[$i]; ?>"-->
               </div>
               <div class="rTableCell">
                  <?php echo ($i==0)?('<input type="button" class="addR btn btn-success btn-xs" id="addR" value="Add" />'):('<input type="button" id="btnDel" class="dele btn btn-danger btn-xs" value="Delete">');?>
               </div>
               <?php /*<div class="rTableCell"><input type="button" class="addR btn btn-success btn-xs" id="addR" value="Add" /></div>*/ ?>
            </div>
            <?php 
               //$i++;
               
               			}$k++;
               		}
               	}
               } ?>
         </div>
      </div>
   </div>
   <div class="form-group btn_heading_hide">
      <div class="col-md-6 col-md-offset-3">
         <a class="btn btn-default" onclick="location.href='<?php echo base_url();?>production/production_planning'">Close</a>
         <button type="reset" class="btn btn-default">Reset</button>
         <?php if((!empty($production_plan) && $production_plan->save_status !=1) || empty($production_plan)){
            echo '<input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft">'; 
            }?>
         <button id="send" type="submit" class="btn btn-warning disablesubmitBtn" id="go">Submit</button>
      </div>
   </div>
</form>
<div class="modal loader fade" id="processing_loader2" role="dialog" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-body">
            <div class="text-center">
               <i class="fa fa-refresh fa-5x fa-spin"></i>
               <h4>Processing...</h4>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   var measurementUnits = <?php echo json_encode(getUom()); ?>;		
   var logged_user = <?php echo $_SESSION['loggedInUser']->c_id; ?>;		
</script>
<!-------------------------------------------------------Quick add worker ----------------------------------------------------------------->
<div class="modal left fade" id="myModal_Add_worker_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="position:absolute;">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Worker</h4>
            <span id="mssg34"></span>
         </div>
         <form name="insert_worker_data" name="ins"  id="insert_worker_data_id">
            <div class="modal-body">
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Worker Name <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="worker_name" name="worker_name" required="required" class="form-control col-md-7 col-xs-12" value="">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="email">Mobile number</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="mobile_number" name="mobile_number" class="form-control col-md-7 col-xs-12" value="" >
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">Salary</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="salary" name="salary" class="form-control col-md-7 col-xs-12" value="">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <input type="hidden" id="add_worker_Data_onthe_spot">
                  <button type="button" class="btn btn-default close_sec_model" >Close</button>
                  <button id="Add_worker_details_on_button_click" type="button" class="btn edit-end-btn ">Submit</button>
               </center>
            </div>
         </form>
      </div>
   </div>
</div>
<!--<table class="table table-striped dataTable btn_heading_hide" id="prodPlan">
   <thead>
   <div class="  col-container">
   <div class="col-md-2 col-sm-12 col-xs-12 col"><label>Process Name<span class="required">*</span></label></div>
   <div class="col-md-2 col-sm-12 col-xs-12 col"><label>Machine Name</label></div>				   
   <div class="col-md-3 col-sm-12 col-xs-12 col"><label>Machine Parameter</label></div>
   <div class="col-md-2 col-sm-12 col-xs-12 col"><label>Production/Shift</label></div>
   <div class="col-md-1 col-sm-12 col-xs-12 col"><label>Workers</label></div>
   <div class="col-md-2 col-sm-12 col-xs-12 col" style="border-right: 1px solid #c1c1c1;"><label>Do's &amp; Dont's</label></div>
      </div>
   
   </thead>
   <tbody class="app_div_planing"> 
   <?php /*if($production_plan){ 
      $productionPlan = json_decode($production_plan->planning_data);
      	if(!empty($productionPlan)){
      		$i=0;
      		foreach($productionPlan as $prodplanData){
      			//pre($prodplanData);
      			$machineName = getNameById('add_machine',$prodplanData->machine_name_id,'id');	
      			//$iobcard_data = getNameById('job_card',$prodplanData->job_no,'id');
      			   $workerId = $prodplanData->worker;
      			  
      ?>		
        <tr>
   <td>
   <input id="machine_name_id" class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[]" placeholder="Machine Name"  type="hidden" value="<?php echo $machineName->id ;?>" readonly>
   <input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[]" placeholder="Machine Name"  type="text" value="<?php echo $machineName->machine_name;?>" readonly>
   <input  class="form-control col-md-2 col-xs-12 machine_grp" name="machine_grp[]" placeholder="Machine Name"  type="hidden" value="<?php echo @$machineName->machine_group_id;?>"readonly>					
   </td>
          
   <td>
   <textarea id= "specification" class="form-control col-md-2 col-xs-12" Placeholder ="Add Specification" name="specification[]"><?php echo $prodplanData->specification; ?></textarea> 
   
   </td>
   <td>
   <select class="form-control selectAjaxOption select2 select2-hidden-accessible" id ="job_no" name="job_card_product_name[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="job_card" data-key="id" data-fieldname="job_card_product_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status = 1">
   <option value="">Select Option</option>
   <?php
      if(!empty($prodplanData)){
      $iobCardProductName = getNameById('job_card',$prodplanData->job_card_product_name,'id');
      echo '<option value="'.$iobCardProductName->id.'" selected>'.$iobCardProductName->job_card_product_name.'</option>';
      }  
      ?>
   </select>
   
   </td>
   
         <td>
   
   <select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker"  name="worker_name[<?Php echo $i ;?>][]"  data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
    
   <?php 
      if(!empty($workerId)){
      	foreach($workerId as $worker_Name){
      		$Workername = getNameById('worker',$worker_Name,'id');
      		echo '<option value="'.$worker_Name.'" selected>'.$Workername->name.'</option>';
      	}
      }  	
      ?>    
   
   
   
   </select>
   </td>
   <td><input id="output" class="form-control col-md-2 col-xs-12" name="output[]" placeholder="output" type="number" value="<?php echo $prodplanData->output;?>"></td>
   <td><input type="button" class="addR btn btn-success btn-xs" id="addR" value="Add" /></td>
   </tr>
   <?php 
      $i++; }}} */?>
                 
        </tbody>
   </table>-->
<!-- /page content -->
