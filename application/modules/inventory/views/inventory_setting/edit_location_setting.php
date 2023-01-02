<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveLocationSetting" enctype="multipart/form-data" id="materialForm" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($company_address)) {echo $company_address->id;} else{echo '';} ?>">
		 
		<?php #$locationName = getNameById('company_address',$company_address->id,'id'); 
		
		
		#pre($company_address);
		#die();
		?>
		 
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="code">Location</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="location" class="form-control col-md-7 col-xs-12" name="location" placeholder="" type="text" value="<?php if(!empty($company_address)) echo $company_address->location;?>" readonly>
					<input id="location" class="form-control col-md-7 col-xs-12" name="location_id" placeholder="" type="hidden" value="<?php if(!empty($company_address)) echo $company_address->id;?>" readonly>
				</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12 area_div">
			<?php if(!empty($company_address) && $company_address->area !=''){ 			
				$locationArea=json_decode($company_address->area);
				if(!empty($locationArea)){
					$i = 1;
					foreach($locationArea as $loc_area){
						
						//$Area = $loc_area->area;
				?>
			<div class="well"  style="overflow:auto; padding:0px;" id="chkIndex_<?php echo $i; ?>">
				<div class="col-md-10 col-sm-12 col-xs-12 form-group" style="width: 90%;">
					<input type="text" class="form-control col-md-2 col-xs-12 areaName" name="area[]" placeholder="area" required="required" value="<?php if(!empty($loc_area)){echo $loc_area->area; } 



					?>">
				</div>
				<?php 
				if($i==1){
					echo '<button class="btn btn-primary addArea" type="button" align="right"><i class="fa fa-plus"></i></button>';
				}else{	
					echo '<button class="btn btn-danger remove_area" type="button"> <i class="fa fa-minus"></i></button>';
				} ?>
					
			</div>
			<?php  $i++;}
			}} else{  ?>
			<div class="well"  style="overflow:auto; padding:0px;" id="chkIndex_1">
				<div class="col-md-10 col-sm-12 col-xs-12 form-group">
					<input type="text" class="form-control col-md-2 col-xs-12 areaName" name="area[]" placeholder="area" required="required" value="">
				</div>	
				<div class="input-group-append">
					<button class="btn btn-primary addArea" type="button" align="right"><i class="fa fa-plus"></i></button>
				</div>		
			</div>
		 <?php } ?>
		</div>
		
	
<hr>
			<div class="form-group">
				<div class="col-md-12 col-xs-12">
                   <center>
					<input type="reset" class="btn btn-default" value="Reset">
					<input type="submit" class="btn btn-warning signUpBtn" value="submit">
					<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>inventory/inventory_setting'">Cancel</a>
                   </center>
				</div>
			</div>	
</form>