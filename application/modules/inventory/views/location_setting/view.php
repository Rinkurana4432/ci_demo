<div class="col-md-12 col-sm-12 col-xs-12">
   <table class="fixed data table table-striped no-margin">
      <thead>				
         
			<tr>
				<th>Location</th>
				<th>Area</th>
			</tr>
		
			<tbody>
				<?php if($location_setting_view){
					$location = $location_setting_view->location;
					$area = json_decode($location_setting_view->area);
					 $AreaArray='';
						foreach($area as $area_data){ 
							$AreasValue= $area_data->area;
							$AreaArray .= $AreasValue.',';  
						}

				?>
			<tr>
				<td><?php echo $location;?></td>
				<td><?php echo $AreaArray; ?></td>
			</tr>
				<?php } ?>
			</tbody>
		 </thead>		
	</table>
</div>     