<form method="post" class="form-horizontal __productionDepartmentSetting" action="<?php echo base_url(); ?>production/save_production_department" enctype="multipart/form-data" id="myform" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($department)) echo $department->id; ?>">
	<?php
			if(empty($department)){
		?>
		<input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
		<?php }else{ ?>	
		<input type="hidden" name="created_by" value="<?php if($department && !empty($department)){ echo $department->created_by;} ?>" >
		<?php } ?>
		<div class="item form-group">
			<div class="col-md-6 col-sm-6 col-xs-12 " style="margin-bottom:10px;">  
				<select data-placeholder="Select Unit" class="form-control col-md-2 col-xs-12 selectAjaxOption select2" required="required" name="unit_name" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
					<option value="">Select Unit</option>
					<?php
					if(!empty($department)){
						$getUnitName = getNameById('company_address',$department->unit_name,'compny_branch_id');
						echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
					}
					
				?>
				</select>
				
				<!--select class="form-control  select2 get_location" required="required" name="unit_name" >
				<!--<select class="form-control  select2 get_unit" required="required" name="unit_name" >>
						<option value="">Select Option</option>
							<?php
							// pre($department);
									/*if(!empty($department)){
										
										echo '<option value="'.$department->unit_name.'" selected>'.$department->unit_name.'</option>';
									}*/
								?>
				</select-->
			</div>
			
<hr>
<div class="bottom-bdr"></div>
			<?php if(empty($department)){ ?>
			<div class="item form-group blog-mdl" style="padding-bottom: 15px;">
			<div class="col-md-12 col-sm-12 col-xs-12 departmentDiv middle-box">
				<div class="well" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkIndex_1">				
					<div class="col-md-12 col-sm-6 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1 !important;">
					<label >Department</label>
						<input type="text" id="deartmentName" name="name[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="Department Name" value="<?php if(!empty($department)) echo $department->name; ?>">
					</div>	
					<!--div class="col-md-12 btn-row">	
						<div class="input-group-append">
							<button class="btn edit-end-btn addMoreDepartment" type="button">Add</button>
						</div>
					</div-->
				</div>
			</div>
			<?php }else{ ?>
				<div class="col-md-10 col-sm-10 col-xs-12 departmentDiv">							
					<div class="col-md-3 col-sm-6 col-xs-12">
						<input type="text" id="departmentName" name="name" required="required" class="form-control col-md-7 col-xs-12" placeholder="Department name" value="<?php if(!empty($department)) echo $department->name; ?>">
					</div>	
			</div>
			<?php }			?>
			</div>
			
		</div>	
			<div class="ln_solid"></div>
				<div class="form-group">
					<div class="col-md-6 col-md-offset-3">
						<?php if(empty($department)){ ?>
							<button type="reset" class="btn btn-default edit-end-btn __shiftReset">Reset</button>
						<?php } ?>
						<button id="send" type="submit" class="btn btn-warning">Submit</button>
						<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>production/production_setting'">Cancel</a>
					</div>
				</div>
</form>
<script>
   $(document).ready(function() {
      $(document).on('click', '.__productionDepartmentSetting .__shiftReset', function(){
         $(".select2").val('').trigger('change');
      });
   });
</script>
