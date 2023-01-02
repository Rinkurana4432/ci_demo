	<?php 			
	$last_id = getLastTableId('add_machine');
		$rId = $last_id + 1;
			$MachineCode = 'Mac'.rand(1, 1000000).'_'.$rId; 
					
				?>


        <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveAddMachine" enctype="multipart/form-data" id="similarmachine" novalidate="novalidate">
             <input type="hidden" name="id" value=""> 
			 <input type="hidden" name="save_status" value="1" class="save_status">	
			<input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
			<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">  
          	<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">			
			<div class="item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12">Machine group</label>		
				<div class="col-md-6 col-sm-12 col-xs-12">
					
					
					
					
					<select class="machinegroup form-control " required="required" name="machine_group_id" data-id="machine_group" data-key="id" data-fieldname="machine_group_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" aria-hidden="true" >
							<option value="">Select Option</option>	
							<?php
								if(!empty($Addmachine)){
									
									$machinegroup = getNameById('machine_group',$Addmachine->machine_group_id,'id');
									
										if(!empty($machinegroup)){
											echo '<option value="'.$machinegroup->id.'" selected>'.$machinegroup->machine_group_name.'</option>';
									}
								}
							?>							
					</select>
					<input type="hidden" id="serchd_val">	  				
				</div>
			</div> 
			<div class="item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Branch<span class="required"> *</span></label>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<select class="form-control col-md-2 col-xs-12 selectAjaxOption select2" required="required" name="company_branch" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>"  onChange="getDept(event,this)">
						<option value="">Select Unit</option>
						<?php
						if(!empty($Addmachine)){
							$getUnitName = getNameById('company_address',$Addmachine->company_branch,'compny_branch_id');
							echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
						}
					?>
					</select>
					
					
				</div>
			</div>
			<?php /*<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="department">Department<span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<select name="department" class="itemName form-control select2 depart_cls" >
						<option value="">Select</option>
						 <?php 
							if(!empty($Addmachine)){
								echo '<option value="'.$Addmachine->department.'" selected>'.$Addmachine->department.'</option>';
							}
						?>
					</select>
				</div>
			</div>*/?>
			
			
			<div class="item form-group">
				<label class="col-md-3 col-sm-12 col-xs-12">Department</label>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<?php /*<select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="abc" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name='unit 2'" tabindex="-1" aria-hidden="true" >
							<option value="">Select Option</option>										
					</select>
					*/?>
						<select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="department"  tabindex="-1" aria-hidden="true">
								<option value="">Select Option</option>	
								<?php
									if(!empty($Addmachine)){
										$departmentData = getNameById('department',$Addmachine->department,'id');
										if(!empty($departmentData)){
											echo '<option value="'.$departmentData->id.'" selected>'.$departmentData->name.'</option>';
										}
									}
								?>								
						</select>
				</div>
			</div>
</div>
	<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">			
			
			
          <div class="item form-group">
				<label class="col-md-3 col-sm-12 col-xs-12" for="machine_name">Work Station Name<span class="required"> *</span>
				</label>
				<div class="col-md-6 col-sm-12 col-xs-12">
				<input id="machine_name" class="form-control col-md-7 col-xs-12" name="machine_name" placeholder="Work Station Name" required="required" type="text" value="<?php if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->machine_name; }?>">
				</div>
			</div>
							
            <div class="item form-group">
                <label class=" col-md-3 col-sm-3 col-xs-12" for="machine_code">Work Station Code</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
					<input id="machine_code" class="form-control col-md-7 col-xs-12" name="machine_code" placeholder="Work Station Code" required="required" type="text" value="<?php  echo $MachineCode; ?>" readonly>
                    </div>
            </div>
           
			<!--<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="usedproduct">Usd In Products</label>	
					<div class="col-md-6 col-sm-6 col-xs-12">
						<select class="form-control" name="usedin_product">
							<option>-- Material Type --</option>
								
								<option>a</option>
								
						</select>
					</div>
			</div>-->	
			<div class="item form-group">
                <label class="col-md-3 col-sm-3 col-xs-12" for="preventive">Preventive Maintenance</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
					<input id="preventive_maintenance" class="form-control col-md-7 col-xs-12" name="preventive_maintenance" placeholder="Preventive maintenance"  type="text" value="<?php if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->preventive_maintenance; }?>">
                    </div>
            </div>	
</div>
<hr>
<div class="bottom-bdr"></div>

<div class="container">

  <ul class="nav tab-3 nav-tabs">
    <li class="active"><a data-toggle="tab" href="#Machine-Parameters">Machine Parameters<span class="required">*</span></a></li>
    <li><a data-toggle="tab" href="#Process">Process<span class="required">*</span></a></li>
  </ul>

  <div class="tab-content" style="margin-top: 25px;">
    <div id="Machine-Parameters" class="tab-pane fade in active">		
			<div class="item form-group blog-mdl">

					<div class="col-md-12 col-sm-12 col-xs-12 form-group input_parameter middle-box">	
					<?php  if(empty($Addmachine)  || $Addmachine->machine_parameter == ''){  ?>
					    <div class="col-sm-12 label-box">
								   <div class="col-md-6 col-sm-12 col-xs-12 form-group"><label>Parameter<span class="required">*</span></label></div>
								   <div class="col-md-6 col-sm-12 col-xs-12 form-group"><label style="border-right: 1px solid #c1c1c1 !important;">UOM</label></div>
								  
				   
			                 </div>
						<div class="well"  style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkIndex_1" >
							<div class="col-md-6 col-sm-5 col-xs-12 form-group">
							
								<input type="text" class="form-control item_name" name="machine_parameter[]" id="machine_parameters" placeholder="Enter machine Parameters">
							 </div>
							 <div class="col-md-6 col-sm-5 col-xs-12 form-group">
								
								<select class="uom selectAjaxOption select2 form-control" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0 AND active_inactive = 1">
							<option value="">Select Option</option>
								<?php 
			if(!empty($materials)){
			$materials = getNameById('uom',$materials->uom,'uom_quantity');
			echo '<option value="'.$material->id.'" selected>'.$material->uom_quantity.'</option>';
							 }
								?>
									</select>
							</div>
							<div class="col-sm-12 btn-row"><div class="input-group-append">
								<button class="btn edit-end-btn addButton" type="button" align="right"><i class="fa fa-plus"></i></button>
							</div></div>											
						</div>
						<?php } else {?>
						<div class="col-sm-12 label-box">
								   <div class="col-md-6 col-sm-12 col-xs-12 form-group"><label>Parameter<span class="required">*</span></label></div>
								   <div class="col-md-6 col-sm-12 col-xs-12 form-group"><label style="border-right: 1px solid #c1c1c1 !important;">UOM</label></div>
								  
				   
			                 </div>
						<?php
							if(!empty($Addmachine) && $Addmachine->machine_parameter !=''){
								$machineParameter = json_decode($Addmachine->machine_parameter);
								   if(!empty($machineParameter)){
									   $i = 1;
										foreach($machineParameter as $machine_Parameter){
											if($machine_Parameter->machine_parameter !='' && $machine_Parameter->uom!=''){
						   ?>					  
							<div style=" border-top: 1px solid #c1c1c1 !important;" class="well scend-tr"  id="chkIndex_<?php echo $i; ?>"> 
								<div class="col-md-6 col-sm-12 col-xs-12 form-group">
									
									<input type="text" class="form-control item_name" name="machine_parameter[]" id="machine_parameters" placeholder="Enter machine Parameters" value="<?php if(!empty($Addmachine)){ echo $machine_Parameter->machine_parameter;} ?>">
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12 form-group">
									
									<!--<select class="form-control" name="uom[]">
										<option>Unit</option>
											<?php $checked ='';			
												$uom = getUom();											  
												foreach($uom as $unit) {												 
													if((!empty($Addmachine)) && ($machine_Parameter->uom == $unit)){ $checked = 'selected';}else{$checked = '';  }				
														echo "<option value='".$unit."' ".$checked.">".$unit."</option>";												
													}											
											?>		
									</select>-->

									<select class="uom selectAjaxOption select2 form-control" name="uom[]" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0 AND active_inactive = 1">
							<option value="">Select Option</option>
							
									<?php	
												if(!empty($Addmachine) && $machine_Parameter->uom !=''){ 
													$materials = getNameById('uom',$machine_Parameter->uom,'id');
													echo '<option value="'.$machine_Parameter->uom.'" selected>'.$materials->uom_quantity.'</option>';
											}
							
								?>
									</select>
								</div>
									<?php if($i==1){
										echo '<div class="col-sm-12 btn-row" style="display:none;"><button class="btn edit-end-btn addButton" type="button">Add</button></div>';
									}else{	
										echo '<button class="btn btn-danger remove_field" type="button"><i class="fa fa-minus"></i></button>';
									} ?>

						   </div>
						   <?php if($i==1){
										echo '<div class="col-sm-12 btn-row"><button class="btn edit-end-btn addButton" type="button">Add</button></div>';
									}else{	
										echo '<button class="btn btn-danger remove_field" type="button" style="display:none;"><i class="fa fa-minus"></i></button>';
									} ?>
						<?php } 
						$i++;
						}
						
						} } }?>							
					</div>
			</div>
</div>														
						
			<!-------------   Add more process and process type start-------------------->
<div id="Process" class="tab-pane fade in ">			
			   <div class="item form-group blog-mdl">

					<div class="col-md-12 col-sm-12 col-xs-12 form-group process_div middle-box">	
					<?php if(empty($Addmachine) || $Addmachine->process == ''){  ?>
					
						<div class="well"  style="overflow:auto;" id="chkIndex_1">
							<div class="col-md-5 col-sm-12 col-xs-12 form-group">
							<label>Process Type</label>
								<select class="form-control selectAjaxOption select2 select2-hidden-accessible processType_id select2" required="required" name="process_type[]" data-id="process_type" data-key="id" data-fieldname="process_type" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" tabindex="-1" aria-hidden="true" onchange="getProcess(event,this)">
										<option value="">Select Option</option>										
									</select>
							 </div>
							 <div class="col-md-5 col-sm-6 col-xs-12 form-group">
								<label>Process</label>								
								 <select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id" name="process_name[]" width="100%" tabindex="-1" aria-hidden="true" required="required" data-id="add_process" data-key="id" data-fieldname="process_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> <?php if(!empty($Addmachine) && $Addmachine->process_type !=''){  ?> AND process_type_id=<?php echo $Addmachine->process_type_id ; }?>">
									<option value="">Select Option</option>								
								</select>
							</div>
							<div class="col-sm-12 btn-row"><div class="input-group-append">
								<button class="btn edit-end-btn processAddButton" type="button" align="right">Add</button>
							</div></div>											
						</div>
						<?php } 
							 else {?>
							 <div class="col-sm-12 label-box">
								   <div class="col-md-6 col-sm-12 col-xs-12 form-group"><label>Product Type<span class="required">*</span></label></div>
								   <div class="col-md-6 col-sm-12 col-xs-12 form-group"><label style="border-right: 1px solid #c1c1c1 !important;">Process</label></div>
								  
				   
			                 </div>
						<?php
							if(!empty($Addmachine) && $Addmachine->process !=''){
								$machineProcess = json_decode($Addmachine->process);
								   if(!empty($machineProcess)){
									   $j = 1;
										foreach($machineProcess as $mcProcess){
											if(!empty($mcProcess) && $mcProcess->process_type !=''){ 
												$processType = getNameById('process_type',$mcProcess->process_type,'id');
											}	
											if($mcProcess->process_type !='' && $mcProcess->process!=''){
																									
						   ?>					  
							<div class="well scend-tr" style="overflow:auto;" id="chkIndex_<?php echo $j; ?>"> 
								<div class="col-md-6 col-sm-12 col-xs-12 form-group">
								
									<select class="form-control selectAjaxOption select2 select2-hidden-accessible processType_id select2" required="required" name="process_type[]" data-id="process_type" data-key="id" data-fieldname="process_type" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" tabindex="-1" aria-hidden="true" onchange="getProcess(event,this)">
											<option value="">Select Option</option>	
											<?php	
												if(!empty($Addmachine) && $mcProcess->process_type !=''){ 
													echo '<option value="'.$mcProcess->process_type.'" selected>'.$processType->process_type.'</option>';
											}
											?>  											
									</select>
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12 form-group">
																
								 <select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id" name="process_name[]" width="100%" tabindex="-1" aria-hidden="true" required="required" data-id="add_process" data-key="id" data-fieldname="process_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> <?php if(!empty($Addmachine) && $Addmachine->process_type !=''){  ?> AND process_type_id=<?php echo $mcProcess->process_type ; }?>">
									<option value="">Select Option</option>	
									<?php
									if(!empty($mcProcess) && $mcProcess->process!=''){
										$processData = getNameById('add_process',$mcProcess->process,'id');
										echo '<option value="'.$mcProcess->process.'" selected >'.$processData->process_name.'</option>';
									}	 ?>								
								</select>
								</div>
									<?php if($j==1){
										echo '<div class="col-sm-12 btn-row" style="display:none;"><button class="btn edit-end-btn processAddButton" type="button">Add</button></div>';
									}else{	
										echo '<button class="btn btn-danger remove_fieldss" type="button"><i class="fa fa-minus"></i></button>';
									} ?>
						   </div>
						   <?php if($j==1){
										echo '<div class="col-sm-12 btn-row"><button class="btn edit-end-btn processAddButton" type="button">Add</button></div>';
									}else{	
										echo '<button class="btn btn-danger remove_fieldss" type="button" style="display:none;"><i class="fa fa-minus"></i></button>';
									} ?>
						<?php } 
						$j++;
						}
						
						} } } ?>							
					</div>
			</div>
</div>
</div>
</div>
</div>			
<hr>
<div class="bottom-bdr"></div>			
			<!-------------   Add more process and process type end-------------------->
			
				

			
           <?php /* <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="process_name">Process Name</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
					    <select class="form-control selectAjaxOption select2 select2-hidden-accessible" name="process_name" width="100%" tabindex="-1" aria-hidden="true" required="required" data-id="add_process" data-key="id" data-fieldname="process_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
							<option value="">Select Option</option>
								<?php
									if(!empty($Addmachine)){
									$processNameId = getNameById('add_process',$Addmachine->process_name,'id');
									echo '<option value="'.$Addmachine->process_name.'" selected >'.$processNameId->process_name.'</option>';
									}
								?>	
						</select>
                       
					</div>
				</div> */?>
            <!--<div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment">Machine History</label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea id="history" name="machine_history"  class="form-control col-md-7 col-xs-12" placeholder="machine History"><?php //if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->machine_history; }?></textarea>
                    </div>
            </div>-->
            
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">	            
            <div class="item form-group">
                 <label class="col-md-3 col-sm-12 col-xs-12" for="model">Make And Model</label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="text" id="make_model" name="make_model" class="form-control col-md-7 col-xs-12" placeholder="2008; Bajaj finance" value="<?php if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->make_model; }?>"> 
                    </div>
             </div>
            <div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="year">Date Of Purchase</label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                      <div class=" xdisplay_inputx form-group has-feedback">
							<input type="text" class="form-control has-feedback-left machinePurchaseDate" name="year_purchase" id="" aria-describedby="inputSuccess2Status3" value="<?php if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->year_purchase; }?>"  required="required">
							<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
							<span id="inputSuccess2Status3" class="sr-only">(success)</span>
						</div>
					</div>
            </div>
            <div class="item form-group">
                 <label class="col-md-3 col-sm-3 col-xs-12" for="machine_capacity">Machine Capacity</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="machine_capacity" name="machine_capacity" class="form-control col-md-7 col-xs-12" placeholder="Machine Capacity" value="<?php if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->machine_capacity; }?>"> 
                    </div>
             </div>
             <div class="item form-group">
                 <label class="col-md-3 col-sm-3 col-xs-12" for="location">Machine Location</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="location" name="location" class="form-control col-md-7 col-xs-12" placeholder="Machine Location" value="<?php if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->location; }?>"> 
                    </div>
             </div>
</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">	
             <div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="purpose">Placement Of Machine</label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="text" id="placement" name="placement" class="form-control col-md-7 col-xs-12" 	placeholder="Placement" value="<?php if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->placement; }?>">
                    </div>
            </div>
</div> 
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">	
             <div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="remark">Remark</label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="text" id="remark" name="remark" class="form-control col-md-7 col-xs-12" 	placeholder="Remark" value="<?php if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->remark; }?>">
                    </div>
            </div>
</div> 
<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">	
			<div class="item form-group">
				<label class="col-md-3 col-sm-3 col-xs-12" for="img">Featured Image </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="hidden" class="form-control col-md-7 col-xs-12 hiddenImage" name="featured_image" id="hiddenImage" value="<?php echo isset($Addmachine->featured_image)?$Addmachine->featured_image: "";?>">
						<button type="button" class="btn" name="featured_image" id="image">Upload featured_image</button>
					</div>
			</div>
			<div class="item form-group">
				<label class="col-md-3 col-sm-3 col-xs-12" for="img"></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div id="uploaded_image_Add"></div>
					</div>
			</div>
			
				<?php if(!empty($Addmachine)){
				?>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="proof"></label>
						<div class="col-md-6">
							<?php 	if(!empty($Addmachine->featured_image)){
								echo '
								<div class="col-md-55">
									<div class="image view view-first">
										<div id="uploaded_image"><img style="width: 100%; display: block;" src="'.base_url().'assets/modules/inventory/uploads/'.$Addmachine->featured_image.'" alt="image" class="undo" id="uploaded_image"/></div>  
									</div>
								</div>'; }else{
									echo ' <div class="col-md-55">
									<div class="image view view-first">
										<div id="uploaded_image"><img style="width: 100%; display: block;" src="'.base_url().'assets/modules/inventory/uploads/product.png" alt="image" class="undo" id="uploaded_image"/></div>  
									</div>
								</div>';
								}
						?>
						</div>
				</div>
				
				<?php } ?>
</div>          
<hr>
<div class="bottom-bdr"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <button type="reset" class="btn btn-default edit-end-btn">Reset</button>
						<!--input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft"-->
							
                            <button id="send" type="submit" class="btn edit-end-btn">Submit</button>
                            <a class="btn edit-end-btn" onclick="location.href='<?php echo base_url();?>production/Add_machine'">Cancel</a>
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
			
			    