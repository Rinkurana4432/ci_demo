<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveProductiondata" enctype="multipart/form-data" id="purchaseIndentForm" novalidate="novalidate">
	<input type="hidden" value="<?php if(!empty($production_data)){ echo $production_data->id ;}?>" name="id">
	<input type="hidden" id="current_login_com_id" value="<?php  echo $_SESSION['loggedInUser']->c_id; ?>" >
	<input type="hidden" name="save_status" value="1" class="save_status">	
	<input type="hidden" name="planning_id" value="" class="">	
	<?php
		if(empty($production_data)){
	?>
		<input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
		<input type="hidden" value="<?php echo '0'; ?>" id="edit_id" >
		<?php }else{ ?>	
		<input type="hidden" name="created_by" value="<?php if($production_data && !empty($production_data)){ echo $production_data->created_by;} ?>" >
		<input type="hidden" value="<?php echo $production_data->id; ?>" id="edit_id">
		<?php } ?>
	<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">
	<div class="item form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
			<div class="col-md-3 col-sm-3 col-xs-12">
				<select class="form-control  select2 get_location compny_unit" required="required" name="company_branch" onChange="getDept(event,this)">
					<option value="">Select Option</option>
						<?php
							if(!empty($production_data)){
								echo '<option value="'.$production_data->company_branch.'" selected>'.$production_data->company_branch.'</option>';
								}
							?>
				</select>
			</div>
		</div>
		<div class="item form-group">
				<label class="control-label col-md-2 col-sm-2 col-xs-12">Department</label>
				<div class="col-md-3 col-sm-3 col-xs-12">
						<select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="department_id"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = <?php echo "'$production_data->company_branch'"; ?>" >
								<option value="">Select Option</option>	
								<?php
									if(!empty($production_data)){
										$departmentData = getNameById('department',$production_data->department_id,'id');
										if(!empty($departmentData)){
											echo '<option value="'.$departmentData->id.'" selected>'.$departmentData->name.'</option>';
										}
									}
								?>								
						</select>
				</div>
			</div>
			<?php if(!empty($electr_unit_price)){
						foreach($electr_unit_price as $unit_price){	 ?>
						<input id="electr_unit_price" class="form-control col-md-3 col-xs-12" name="electr_unit_price" placeholder="electrcity unit price"  type="hidden" value="<?php echo $unit_price['electr_unit_price'];?>">
					<?php 	}
					} ?>    
	<div class="item form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12" for="shift">Shift<span class="required">*</span></label>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<?php if(!empty($productionSetting)){
					foreach($productionSetting as $ps){	 ?>
						<div class="radio">
							<label>
								<input type="radio" class="flat" name="shift" value="<?php echo $ps['id']; ?>" checked = checked[0] ><?php echo $ps['shift_name']; ?></br>
							</label>
						</div>
			<?php 	}
			} ?>      
		</div>
	</div>
	<div class="item form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12" for="machine_name">Date<span class="required">*</span></label>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<input id="date" class="form-control col-md-2 col-xs-12" name="date" placeholder="date" required="required" type="text" value="<?php if($production_data && !empty($production_data)){echo $production_data->date; }?>" onkeydown="event.preventDefault()">
		</div>
	</div>
	<div class="item form-group" style="overflow:auto;">
	<table class="table table-striped maintable btn_heading_hide" id="mytable" style="display:none;">
		<thead>
			<tr>
				<th>Machine Name</th>
				<th>Party Code</th>
				<th>Job card Product Name</th>
				<th>Worker</th>
				<th>Overtime</th>
				<th>Salary(Rs)</th>
				<th>material consumed</th>
				<th>Production Output</th>
				<th>Wastage</th>
				<th>Electricity(Watts)</th>
				<th>Costing</th>
				<th>Down Time</th>
				<th>Labour costing</th>
				<th>Per piece rate</th>
				<th>Remarks</th>
			</tr>
		</thead>
		<tbody class="app_div">
			<?php 
				if($production_data){ 
					$production_detail = json_decode($production_data->production_data);
					if(!empty($production_detail)){
						$i=0;
						$k=0;
						foreach($production_detail as $productionDetail){
						#pre($productionDetail);
							if(!empty($productionDetail)){
							$machine_id = $productionDetail->machine_name_id;
							@$machineName = getNameById('add_machine',$machine_id,'id');
							
							$jobCardData = getNameById('job_card',$productionDetail->job_card_product_id,'id');								
							$workerName_id = $productionDetail->worker_id;
							//$job_cardId = $productionDetail->job_no;
							
			?>	
							<tr id="index_<?php echo $k;?>">  
								<td>
									<input id="machine_name_id" class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[]" placeholder="Machine Name" type="hidden" value="<?php echo @$machineName->id ;?>" readonly >
									<input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[]" placeholder="Machine Name"  type="text" value="<?php echo @$machineName->machine_name;?>" readonly>
									<input  class="form-control col-md-2 col-xs-12 machnine_grp" name="machine_grp[]" placeholder="Machine Name"  type="hidden" value="<?php echo @$machineName->machine_group_id;?>"readonly>
								</td>
								<!--td>
									<select class="form-control selectAjaxOption select2 select2-hidden-accessible job_card_no" name="job_no[]" width="100%" tabindex="-1" aria-hidden="true" required="required" data-id="job_card" data-key="id" data-fieldname="job_card_no" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status = 1">
									
										<option value="">Select Option</option>
											<?php  //echo '<option value="'.$job_cardId.'" selected>'.$jobcard_data->job_card_no.'</option>'; ?>   
									</select>
								</td-->
								<td>
									<select class="form-control selectAjaxOption select2 select2-hidden-accessible party_code_cls" id ="party_code" name="party_code[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="job_card" data-key="id" data-fieldname="party_code" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status = 1">
									<option>Select Option</option>
									<?php 
											 if(!empty($productionDetail)){
													$jobCard = getNameById('job_card',$productionDetail->party_code,'id');
													echo '<option value="'.$jobCard->id.'" selected>'.$jobCard->party_code.'</option>';
											 }


									 ?>  
									
								</select>
								</td>
								<td>
									<?php /*<input id="job_no" class="form-control col-md-2 col-xs-12" name="job_no[]" placeholder="Job Card Number" readonly required="required" type="text" value="<?php echo $productionDetail->job_no;?>">*/?>
									<input id="job_card_product_name" class="form-control col-md-2 col-xs-12" name="job_card_product_name[]" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){echo $jobCardData->job_card_product_name;} else{echo "";}?>">
									
									<input type="hidden" id="job_card_product_id" class="form-control col-md-2 col-xs-12" name="job_card_product_id[]" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){echo $jobCardData->id;} else{echo "";}?>">
								</td>
								<td>
								<select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker"  name="worker_name[<?php echo $i ;?>][]" data-id="worker" data-key="id" data-fieldname="name" width="100%" tabindex="-1"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
										<option>Select Option</option>	
											<?php  
												if(!empty($workerName_id)){
													
													foreach($workerName_id as $worker_Name){
														$Workername = getNameById('worker',$worker_Name,'id');
														echo '<option value="'.$worker_Name.'" selected>'.$Workername->name.'</option>';
													}
												}  	
											?>    
									</select>
									<?php /*<select multiple class="form-control col-md-2 col-xs-12 selectAjaxOption select2" id="worker"  name="worker_name[<?php echo $i ;?>][]" data-id="worker" data-key="id" data-fieldname="name" width="100%" tabindex="-1"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND active_inactive = 1">
										<option>Select Option</option>	
											<?php  
												if(!empty($workerName_id)){
													
													foreach($workerName_id as $worker_Name){
														$Workername = getNameById('worker',$worker_Name,'id');
														echo '<option value="'.$worker_Name.'" selected>'.$Workername->name.'</option>';
													}
												}  	
											?>    
									</select>*/?>
								</td>
								<td>
									<input id="overtime" class="form-control col-md-7 col-xs-12" name="overtime[]" placeholder="overtime"  type="text" value="<?php if(!empty($productionDetail) && isset($productionDetail->overtime)){echo $productionDetail->overtime; }?>" onkeypress="return float_validation(event, this.value)">
								</td>
								<td>
									<input id="salary" class="form-control col-md-7 col-xs-12" name="salary[]" placeholder="salary"  type="text" value="<?php if(!empty($productionDetail) && isset($productionDetail->salary)){ echo $productionDetail->salary; } ?>" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)">
								</td>
								<td>
									<input id="material_consumed" class="form-control col-md-7 col-xs-12" name="material_consumed[]" placeholder="material_consumed"  type="text" value="<?php echo $productionDetail->material_consumed; ?>"  onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)">
								</td>								
								<td>
									<input id="output" class="form-control col-md-7 col-xs-12" name="output[]" placeholder="output"  type="text" value="<?php echo $productionDetail->output;?>" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)">
								</td>
								<td>
									<input id="wastage" class="form-control col-md-7 col-xs-12" name="wastage[]" placeholder="wastage"  type="text" value="<?php echo $productionDetail->wastage;?>"  onkeypress="return float_validation(event, this.value)" readonly>
								</td>
								<td>
									<input id="electricity" class="form-control col-md-7 col-xs-12" name="electricity[]" placeholder="electricity"  type="text" value="<?php echo $productionDetail->electricity;?>" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)">
								</td>
								<td>
									<input id="costing" class="form-control col-md-7 col-xs-12" name="costing[]" placeholder="costing"  type="text" value="<?php echo $productionDetail->costing;?>" readonly>
								</td>
								<td>
									<input id="downtime" class="form-control col-md-7 col-xs-12" name="downtime[]" placeholder="downtime"  type="text" value="<?php echo $productionDetail->downtime;?>" onkeypress="return float_validation(event, this.value)">
								</td>
								<td>
									<input id="labour_costing" class="form-control col-md-7 col-xs-12" name="labour_costing[]" placeholder="labour_costing"  type="text" value="<?php if(!empty($productionDetail) && isset($productionDetail->labour_costing)) echo $productionDetail->labour_costing;?>" onkeypress="return float_validation(event, this.value)">
								</td>
								<td>
									<input id="per_piece_rate" class="form-control col-md-7 col-xs-12" name="per_piece_rate[]" placeholder="per piece rate"  type="text" value="<?php if(!empty($productionDetail->per_piece_rate)){echo  $productionDetail->per_piece_rate;} ?>" onkeypress="return float_validation(event, this.value)">
								</td>
								<td>
									<textarea id="remarks" class="form-control col-md-7 col-xs-12" name="remarks[]" placeholder="remarks"  type="text" value="" ><?php echo $productionDetail->remarks;?></textarea>
								</td>
								<td>
									<input type="button" class="addRow btn btn-success btn-xs" id="addR" value="Add" />
								</td>
							</tr>
							
						<?php 
						$i++;
						$k++;
						}
						}
					}
				} ?>
		</tbody>
	</table>
	</div>
	<div class="form-group btn_heading_hide" style="display:none;">
		<div class="col-md-6 col-md-offset-3">
			<a class="btn btn-default" onclick="location.href='<?php echo base_url();?>production/production_data'">Close</a>
			<button type="reset" class="btn btn-default">Reset</button>
			<?php if((!empty($production_data) && $production_data->save_status !=1) || empty($production_data)){
					echo '<input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft">'; 
			}?>
			<button id="send" type="submit" class="btn btn-warning disablesubmitBtn">Submit</button>
			
		</div>
	</div>
</form>

<!-- Static Modal -->

    <div class="modal loader fade" id="processing_loader" role="dialog" aria-hidden="true">
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
		var logged_user = <?php echo $_SESSION['loggedInUser']->c_id; ?>;		
	</script>
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
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="Mobile">Mobile number</label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" id="mobile_number" name="mobile_number" class="form-control col-md-7 col-xs-12" value="" >
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-2 col-sm-2 col-xs-4" for="salary">Salary</label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" id="worker_salary" name="salary" class="form-control col-md-7 col-xs-12" value="">
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