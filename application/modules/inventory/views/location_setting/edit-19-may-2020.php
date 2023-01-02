<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveLocationSetting" enctype="multipart/form-data" id="materialForm" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($location_setting)) echo $location_setting->id; ?>">
		<div class="col-md-6 col-sm-6 col-xs-12 area_div">
		 <?php if(!empty($location_setting)){ 
				$locationArea=json_decode($location_setting->area);
				   if(!empty($locationArea)){
				$i = 1;
				 foreach($locationArea as $loc_area){
				    $Area = $loc_area->area;
		 ?>
		<div class="well"  style="overflow:auto;" id="chkIndex_<?php echo $i; ?>">
			<div class="col-md-6 col-sm-12 col-xs-12 form-group">
				<input type="text" class="form-control col-md-2 col-xs-12 areaName" name="area[]" placeholder="area" required="required" value="<?php echo $Area;?>">
			</div>	
			<div class="input-group-append">
				<?php 
				if($i==1){
					echo '<button class="btn btn-primary addArea" type="button" align="right"><i class="fa fa-plus"></i></button>';
				}else{	
					echo '<button class="btn btn-danger remove_area" type="button"> <i class="fa fa-minus"></i></button>';
				} ?>
				</div>		
				<!--<div class="input-group-append">
					<button class="btn btn-primary addArea" type="button" align="right"><i class="fa fa-plus"></i></button>
				</div>-->		
			</div>
		
		
		 <?php } $i++;} else{ 
		 
			 ?>
			<div class="well"  style="overflow:auto;" id="chkIndex_1">
				<div class="col-md-6 col-sm-12 col-xs-12 form-group">
					<input type="text" class="form-control col-md-2 col-xs-12 areaName" name="area[]" placeholder="area" required="required" value="">
				</div>	
				<div class="input-group-append">
					<button class="btn btn-primary addArea" type="button" align="right"><i class="fa fa-plus"></i></button>
				</div>		
			</div>
		 <?php }} ?>
		</div>
		
	
<hr>
			<div class="form-group">
				<div class="col-md-12 col-xs-12">
					<input type="reset" class="btn btn-default" value="Reset">
					<input type="submit" class="btn btn-warning signUpBtn" value="submit">
					<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>inventory/location_setting'">Cancel</a>
				</div>
			</div>	
</form>
						
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	<?php /*<div id="div_form" class="location"> 
			<?php
				if(!empty($address)){
					$data_address = $address[0]['address'];
						$dataArray = json_decode($data_address);
							foreach($dataArray as $addressValue){
								$AddressArray = $addressValue->address;	
			?>
				<div class="well"  style="overflow:auto;" id="chkIndex_1">
					<div class="col-md-6 col-sm-12 col-xs-12 form-group">
						<textarea class="form-control col-md-2 col-xs-12 addressName" name="address[]" placeholder="Address" required="required" readonly><?php echo $AddressArray; ?></textarea>
					</div>
				
						<div id="add_area"></div>
							<div class="m_buttons">
								<input type="button" value="Add area" class="f_addArea" id="f_addModule" onclick="addArea(event,this);"/>
								<input type="button" value="Delete Area" class="delete_area" />
							</div>
				</div>
			
				<?php }} ?>	
				
			
		</div>
		
		*/?>	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
			<?php /*<div id="div_form" class="location"> 
			 <?php  if(empty($location_setting)){  ?>
			 <?php $i=0;?>
				<div class="well"  style="overflow:auto;" id="chkIndex_1">
					<div class="col-md-6 col-sm-12 col-xs-12 form-group">
						<select class="form-control address" data-counter="<?php echo $i; ?>" id="address" required="required" name="loc[<?php echo $i; ?>][location].location[]" tabindex="-1" aria-hidden="true" onchange="getAddress();" id="p_name" class="p_fields">
							<option>Select Option</option>
						</select>
					</div>
						<div id="add_area"></div>
							<div class="m_buttons">
								<input type="button" value="Add area" class="f_addArea" id="f_addModule" onclick="addArea(event,this);"/>
								<input type="button" value="Delete Area" class="delete_area" />
							</div>
				</div>
			<?php $i++; ?>
					
				<div class="input-group-append">
					<button class="btn btn-primary add_location" id="add_location" type="button" align="right"><i class="fa fa-plus"></i></button>
				</div>	
			<?php  } else {
				  if(!empty($location_setting) && $location_setting->location !=''){
						$location_detail = json_decode($location_setting->location);
							if(!empty($location_detail)){ 
							$i =1;
								foreach($location_detail as $locationDetail){
								$locationValue=$locationDetail->location;	
								$storage = $locationDetail->storage;
								$k=1;
							
				?>
				<div class="well"  style="overflow:auto;" id="chkIndex_1">
					<div class="col-md-6 col-sm-12 col-xs-12 form-group">
					<select class="form-control address select2-hidden-accessible" data-counter="<?php echo $i; ?>" id="address" required="required" name="loc[<?php echo $i; ?>][location].location[]" tabindex="-1" aria-hidden="true" onchange="getAddress();">
							<option>Select Option</option>
							<?php
								echo '<option value="'.$locationValue.'" selected>'.$locationValue.'</option>';
							?>
				</select>
					</div>
					
					<?php 	foreach($storage as $Storage_area){
									$AreaValue = $Storage_area;
					?>
					<div id="add_area">
						<div class="p_module" id="chkIndex_1">
							<label for="m_name">Area: </label>
							<input type="text" class="m_name p_fields form-control area" name="loc[<?php echo $i; ?>][storage][].storage[][<?php echo $k; ?>][storage]" data-count="<?php echo $k; ?>" id="area" value="<?php echo $AreaValue; ?>"><br>
						</div>
					</div>
					<div class="m_buttons">
								<input type="button" value="Add area" class="f_addArea" id="f_addModule" onclick="addArea(event,this);"/>
								<input type="button" value="Delete Area" class="delete_area" />
							</div>
				
			<?php $k++;} echo '</div>';$i++;}}}}?>	
			</div>
		
*/?>
		
		