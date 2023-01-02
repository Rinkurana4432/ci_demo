<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveProductionSetting" enctype="multipart/form-data" id="add_machine" novalidate="novalidate">
            <input type="hidden" name="id" value="<?php if($settingView && !empty($settingView)){ echo $settingView->id;} ?>">

   <div class="col-md-12 col-sm-12 col-xs-12">
   
    <div class="col-md-12 label-left" style=" padding:0px; margin-bottom:20px;">
	        
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Company Unit:</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($settingView)){ 
											$getUnitName= getNameById('company_address',$settingView->company_unit,'compny_branch_id');
												if(!empty($getUnitName)){
													echo $getUnitName->company_unit;
												}else{
													echo $settingView->company_unit;
												}													
											} ?>
										</div>
									</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Deaprtment:</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($settingView)){ 
											$deptname = getNameById('department',$settingView->department,'id');
												if(!empty($deptname)){
												echo $deptname->name; 
											} }?></div>
									</div>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Number of shift:</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($settingView)){ echo $settingView->shift_number; } ?></div>
									</div>
				</div>
			
	</div>
	<div class="col-md-12 label-left" style=" padding:0px; margin-bottom:20px;">
	        

		<table id="" class="table table-striped table-bordered account_index">
		<thead>
		<tr>
		<th>Shift Name</th>
		<th>Shift Duration</th>
		<th>Shift Start Time</th>
		<th>Shift End Time</th>
		<th>Week Off</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$j=0;
		$shift_name = json_decode($settingView->shift_name);
	   $shift_duration = json_decode($settingView->shift_duration);
	   $shift_start = json_decode($settingView->shift_start);
	   $shift_end = json_decode($settingView->shift_end);
	   $week_off = json_decode($settingView->week_off);
		for ($i=1; $i<=$settingView->shift_number; $i++) {
		?>

		<tr>
		<td><?php echo $shift_name[$j]; ?></td>
		<td><?php echo $shift_duration[$j]; ?></td>
		<td><?php echo $shift_start[$j]; ?></td>
		<td><?php echo $shift_end[$j]; ?></td>
		<td><?php echo implode(',', $week_off[$j]); ?></td>
		</tr>
		<?php $j++; } ?>
		</tbody>
		</table>
			
	</div>
   
	
   
      
   </div>
</div>
</form>