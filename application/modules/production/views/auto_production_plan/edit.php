<style type="text/css">.rTableHead {width: 1%;}</style>
 <?php $companyId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ; ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveAutoProductionPlan" enctype="multipart/form-data" id="productionPlan" novalidate="novalidate">
   <input type="hidden" value="<?php if(!empty($production_plan)){ echo $production_plan->id ;}?>" name="id" id="edit_id">
   <input type="hidden" id="current_login_com_id" value="<?php  echo $companyId; ?>" >	
   <input type="hidden" name="save_status" value="1" class="save_status">
   <?php
      if(empty($production_plan)){
      ?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <?php }else{ ?>	
   <input type="hidden" name="created_by" value="<?php if($production_plan && !empty($production_plan)){ echo $production_plan->created_by;} ?>" >
   <?php } ?>
   <input type="hidden" name="logged_in_user" value="<?php echo $companyId; ?>" id="loggedUser">
   <div class="col-md-6 col-sm-12 col-sx-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 compny_unit" required="required" name="company_branch" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
               <option value="">Select Unit</option>
               <?php
                  if(!empty($production_plan)){
                  	$getUnitName = getNameById('company_address',$production_plan->company_branch,'compny_branch_id');
                  	echo '<option value="'.$production_plan->company_branch.'" selected>'.$getUnitName->company_unit.'</option>';
                  }
                  
                  ?>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12">Department</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
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
            <?php }
               }}?>
            <div class="radio_button"></div>
            <div class="Displaymessage"></div>
            <?php }?> 
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="date">Date<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input id="auto_planningDate" class="form-control col-md-2 col-xs-12 auto_date" name="date" placeholder="date" required="required" type="text" value="<?php if($production_plan && !empty($production_plan)){echo $production_plan->date; }?>" onkeydown="event.preventDefault()" autocomplete="off">
         </div>
      </div>
   </div>

   <!--div class="col-md-12 col-sm-12 col-sx-12">
   <div class="item form-group" style="text-align: center; margin: 1% 0% 2% 1%;">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <button id="autoplanningData" class="btn btn-warning" type="button">Submit</button>
         </div>
      </div>  
   </div-->

   <hr>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="item form-group">
      <div class="table table-striped dataTable mainPlantable btn_heading_hide rTable" id="prodPlan" style="display: none;">
        <button type="button" class="expandautoAllSection" onclick="expandautoAllSection(event,this);" data-val='more' style="display:none;">Expand All</button><button type="button" class="unexpandautoAllSection" onclick="expandautoAllSection(event,this);" data-val='less' style="display:none;">UnExpand All</button>
          <div class="app_div_planing ">
            <div class="rTableRow mobile-view2">
               <div class="rTableHead"><label>Machine Name<span class="required">*</span></label></div>
               <div class="rTableHead"><label>Work Order</label></div>
               <div class="rTableHead"><label>Product Name</label></div>
               <div class="rTableHead"><label>BOM Routing</label></div>
               <div class="rTableHead"><label>Assign Process</label></div>
               <div class="rTableHead"><label>NPDM</label></div>
               <div class="rTableHead"><label>Worker</label></div>
               <div class="rTableHead"><label>Output</label></div>
               <div class="rTableHead" ><label>Action</label></div>
            </div> 
            <?php if($production_plan){ 
               $productionPlan = json_decode($production_plan->planning_data);
               	if(!empty($productionPlan)){
               		$k=0;
               		foreach($productionPlan as $prodplanData){
               			$machineCount = count($prodplanData->machine_name_id);
               			for($i=0; $i<$machineCount ; $i++){
               				$jobCardData = isset($prodplanData->job_card_product_name[$i])?(getNameById('job_card',$prodplanData->job_card_product_name[$i],'id')):'';
               				$machineName = isset($prodplanData->machine_name_id[$i])?(getNameById('add_machine',$prodplanData->machine_name_id[$i],'id')):'';
               ?>
            <div class="rTableRow mobile-view" id="<?php echo ($i==0)?('index_'.$k):('addFunc_'.$i);?>">
               <div class="rTableCell">
                  <input class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Machine Name"  type="hidden" value="<?php if(!empty($machineName)){echo $machineName->id ;}?>" readonly>
                  <input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Machine Name"  type="text" value="<?php if(!empty($machineName)){echo $machineName->machine_name;} ?>" readonly>
                  <input  class="form-control col-md-2 col-xs-12 machine_grp" name="machine_grp[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Machine Name"  type="hidden" value="<?php echo $machineName->machine_group_id;?>" readonly>					
               </div>
			   <div class="rTableCell">
                <label>Work Order</label>	
				  <select class="form-control dis selectAjaxOption removefildswork select2 select2-hidden-accessible WorkOrderId"  name="work_order[<?php echo $k; ?>][<?php echo $i; ?>]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" onchange="getMaterialNameWorkorder(event,this)" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND progress_status = 0 AND company_branch_id=<?php echo $production_plan->company_branch; ?> AND department_id=<?php echo $production_plan->department_id; ?>">
                     <option value="">Select Option</option>
                     <?php 
                        if(!empty($prodplanData)){
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
                        		if(!empty($prodplanData)){
                        			
                        			$sale_order23 = isset($prodplanData->product_name[$i])?getNameById('material',$prodplanData->product_name[$i],'id'):'';
                        
                        			echo '<option value="'.$sale_order23->id.'" selected>'.$sale_order23->material_name.'</option>';
                        		}
                        ?>
                  </select>
               </div>
               <div class="rTableCell">
                  <label>BOM Routing</label>
                  <?php 
                     $jobCardData = isset($prodplanData->job_card_product_id[$i])?(getNameById('job_card',$prodplanData->job_card_product_id[$i],'id')):''; ?>
                  <input id="job_card_product_name" class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){ echo $jobCardData->job_card_no;} else{echo "";}?>">
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
               </div>
               <div class="rTableCell">
                  <?php echo ($i==0)?('<input type="button" class="addR_auto btn btn-success btn-xs" id="addR_auto" value="Add" />'):('<input type="button" id="btnDel" class="dele btn btn-danger btn-xs" value="Delete">');?>
               </div>
            </div>
            <?php } $k++;
               		}
               	}
               } ?>
         </div>
      </div>
   </div>
   <div class="form-group btn_heading_hide">
      <div class="col-md-6 col-md-offset-3">
         <div class="submit_section" style="display:none;">
         <a class="btn btn-default" onclick="location.href='<?php echo base_url();?>production/production_planning'">Close</a>
         <button type="reset" class="btn btn-default">Reset</button>
         <?php if((!empty($production_plan) && $production_plan->save_status !=1) || empty($production_plan)){
            echo '<input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft">'; 
            }?>
         <button id="send" type="submit" class="btn btn-warning disablesubmitBtn" id="go">Submit</button>
      </div>
      <div class="proceed_section" style="text-align: center;">
      <button id="proceed_process" type="button" class="btn btn-warning">Proceed</button>
      </div>
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
<div id="production_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-small">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Reserve/ Unreserve Material</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>

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