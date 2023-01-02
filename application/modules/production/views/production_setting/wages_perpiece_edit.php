<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveWages_perpiece" enctype="multipart/form-data" id="myform" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($wages_perpiece)){echo $wages_perpiece->id;} ?>">
	<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">
	<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	<div class="item form-group">
		<label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 compny_unit" required="required" name="company_unit" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
					<option value="">Select Unit</option>
					<?php
					if(!empty($wages_perpiece)){
						$getUnitName = getNameById('company_address',$wages_perpiece->company_unit,'compny_branch_id');
						echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
					}
					
					?>
				</select>
						
				<!--select class="form-control  select2 get_location compny_unit" required="required" name="company_unit" onChange="getDept(event,this)">
					<option value="">Select Option</option>
						<?php
							/* if(!empty($wages_perpiece)){
								echo '<option value="'.$wages_perpiece->company_unit.'" selected>'.$wages_perpiece->company_unit.'</option>';
								} */
							?>
				</select-->
			</div>
	</div>
	<div class="item form-group">
		<label class="col-md-3 col-sm-12 col-xs-12">Department<span class="required">*</span></label>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="department"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid='<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = <?php echo $wages_perpiece->company_branch; ?>'">
				<option value="">Select Option</option>	
					<?php
						if(!empty($wages_perpiece)){
						$departmentData = getNameById('department',$wages_perpiece->department,'id');
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
		<label class="col-md-3 col-sm-12 col-xs-12">Department</label>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div id="wages" class="btn-group group-required" data-toggle="buttons">
				<p>			
					<h5><strong>Wages:
					<input type="radio" class="flat" name="wages_perpiece" id="wages" value="wages" <?php if(!empty($wages_perpiece->wages_perpiece) && isset($wages_perpiece->wages_perpiece)){ echo $wages_perpiece->wages_perpiece == 'wages' ?  "checked" : "" ;  }?>>
					Per piece:
					<input type="radio" class="flat" name="wages_perpiece" id="per_piece" value="per_piece" <?php if(!empty($wages_perpiece->wages_perpiece) && isset($wages_perpiece->wages_perpiece)){ echo $wages_perpiece->wages_perpiece == 'per_piece' ?  "checked" : "" ;  }?>>
					Both:
					<input type="radio" class="flat" name="wages_perpiece" id="per_piece" value="both" <?php if(!empty($wages_perpiece->wages_perpiece) && isset($wages_perpiece->wages_perpiece)){ echo $wages_perpiece->wages_perpiece == 'both' ?  "checked" : "" ;  }?>></h5></strong>
				</p>
			</div>
		</div>
	 </div>
	</div>
<hr>
<div class="bottom-bdr"></div>
	<div class="form-group">
		<div class="col-md-6 col-md-offset-3">
		
			<button id="send" type="submit" class="btn btn-warning">Submit</button>
			
		</div>
	</div>
</form>
