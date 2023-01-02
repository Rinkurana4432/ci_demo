<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saveAccountGroup" enctype="multipart/form-data" id="AccountGroupForm" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($account_group)) echo $account_group->id; ?>">
	<div class="col-md-12 col-xs-12 col-sm-12 vertical-border ">	
	<div class="required item form-group">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="account_id">Parent Account<span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
		<?php
			//pre($account_group);
		?>
			<select class="itemName form-control selectAjaxOption select2"  name="parent_group_id" data-id="account_group" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND created_by=0 OR status=1" width="100%"  required="required">
			
				<option value="">Select And Begin Typing</option>
				<?php 
				//
					if(!empty($account_group) && $account_group->parent_group_id!=0){
						$parent_group = getNameById('account_group',$account_group->parent_group_id,'id');
					
						echo '<option value="'.$parent_group->id.'" selected>'.$parent_group->name.'</option>';
					}
				 ?>
			</select> 			
		</div>
	</div> 
		
	<div class="required item form-group">
		<label class="col-md-3 col-sm-12 col-xs-12" for="account_id">Account Under</label>
		<div class="col-md-6 col-sm-12 col-xs-12">
		<select class="itemName form-control selectAjaxOption select2"  name="acc_group_id" data-id="account_group" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND status=1" width="100%">
				<option value="">Select And Begin Typing</option>
				<?php 
					if(!empty($account_group) && $account_group->acc_group_id!=0){
						
						$parent_group = getNameById('account_group',$account_group->acc_group_id,'id');
						echo '<option value="'.$parent_group->id.'" selected>'.$parent_group->name.'</option>';
					}
				 ?>
			</select> 			
		</div>
	</div> 
	<div class="item form-group">
			<label class="col-md-3 col-sm-2 col-xs-12" for="name">Account Name<span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="4"  value="<?php if(!empty($account_group)) echo $account_group->name; ?>" name="name" type="text"  required="required"> </div>
	</div>
		
	</div>
	
	
	
	
	
	
	<hr>
	<div class="form-group">
		<div class="col-md-6 col-md-offset-3">
		   <center>
			<button type="reset" class="btn btn-default">Reset</button>
			
			
			<input type="submit" class="btn btn-warning" value="Submit"> </div>
			</center>
	</div>
</form>