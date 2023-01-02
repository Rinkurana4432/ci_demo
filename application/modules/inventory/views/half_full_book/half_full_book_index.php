
	
<?php 
	if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-info col-md-6">                            
			<?php echo $this->session->flashdata('message');?> </div>                        
<?php }?>
<div class="x_content">
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
       <?php if(!empty($listing) && !empty($half_full_book)){
		   //pre($listing);
			$num = 0;	
		?>
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<?php foreach($listing as $list){ ?>
				<li <?php if($num == 0){ ?> class="active" <?php }else{?> class="" <?php }?>><a data-toggle="tab" href="#tab_<?php echo $list['material_type_id']; ?>"><?php echo $list['material_type_name'];?></a></li>
			<?php  $num++ ;} ?>
        </ul>
		<div id="myTabContent" class="tab-content">
			<?php $i = 0; 
				foreach($listing as $li){  
			
					$subtypeArray = array();
					$CombinedArray = array();
			?>
			<div id="tab_<?php echo $li['material_type_id']; ?>" <?php if($i == 0){ ?> class="tab-pane fade in active" <?php }else{?> class="tab-pane fade in" <?php }?> > 
				<table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
					<thead>
						<tr>
						<th>Product Sub-type With Product</th>
						<th>Quantity(Closing Balance)</th>
						<th>UOM</th>
						<th>Location</th>
						<th>FullBook/SaleOrder</th>
						
						</tr>
					</thead>
					<tbody>
					<?php 
					foreach($li['sub_type'] as $key => $val){
						$subtypeArray[] = $val['sub_type'];
						$uniqeArrayvalue = array_unique($subtypeArray);
							foreach($uniqeArrayvalue as $unique_value){
								if($unique_value == $val['sub_type']){
									$CombinedArray[$val["sub_type"]]["sub_type"] = $val["sub_type"];
									$CombinedArray[$val["sub_type"]]["material_name"][] = $val["material_name"];
									$CombinedArray[$val["sub_type"]]["material_name_id"][] = $val["material_name_id"];
									$CombinedArray[$val["sub_type"]]["uom"][] = $val["uom"];
									$CombinedArray[$val["sub_type"]]["location"][] = $val["location"];
									$CombinedArray[$val["sub_type"]]["actionType"][] = $val["half_full_book"];
								}
							}
						}
						$k = 0;
						foreach($CombinedArray as $combine_array_data){ 
							if(!empty($combine_array_data)){
								if($combine_array_data['sub_type'] != ''){
									echo "<tr class='parent' id='".$k."'>
										<td colspan='6'><span class='btn btn-default'><h5><strong>".$combine_array_data['sub_type']."</strong></h5></span></td>
										</tr>";
								}elseif($combine_array_data['sub_type'] == ''){
									echo "<tr class='parent' id='".$k."'>
										<td colspan='6'><span class='btn btn-default'>Material</span></td>
									</tr>";
								}	
							}
							foreach($combine_array_data['material_name_id'] as $key =>$mat_id){
								if(getClosingBalance($mat_id ,date('Y-m-d h:i:s')) != 0){
									foreach($combine_array_data['material_name'] as $key2 =>$mat){
										foreach($combine_array_data['uom'] as $key3 =>$uom_name){
											foreach($combine_array_data['location'] as $key4 => $location){
												if($key == $key2 && $key==$key3 && $key == $key4){
												$halfFullBook = $combine_array_data['actionType'][$key];
												$locationAddress = json_decode($location);
												echo "<tr class='child_".$k."'><td>".$mat."<input type='hidden' value='".$mat_id."' /></td>
													<td>".getClosingBalance($mat_id ,date('Y-m-d h:i:s'))."</td>
													<td>".$uom_name."</td>
													<td>";
														if($locationAddress == ''){ echo ' '; }else{
														echo "<table id='' class='table table-striped table-bordered user_index' data-id='user' border='1' cellpadding='3'>
															<thead>
																<tr>
																<th>Location</th>
																<th>Area</th>
																<th>Rack no</th>
																<th>Quantity</th>
																</tr>
															</thead>
															<tbody>";
																if(!empty($locationAddress)){
																	foreach($locationAddress as $loc){
																		$getLocationName = getNameById('location_settings',$loc->location,'id');
																		$location_name = !empty($getLocationName->location)?$getLocationName->location:'';
																		$qunatity = !empty($loc->quantity)?$loc->quantity:'';
																		echo "<tr>
																			<td>".$location_name."</td>
																			<td>".$loc->Storage."</td>
																			<td>".$loc->RackNumber."</td>
																			<td>".$qunatity."</td>
																		</tr>";
																	}
																}
														echo "</tbody>
														</table>";
														}
													echo "</td>
													<td>".$halfFullBook['half_or_full_book']."</td>";		
												echo "</tr>";
												}
											}
										}
									}
								}
							}
						$k++;
						}
					?>
					</tbody>
				</table>
			</div>
		<?php  $i++;} ?>
		</div>
	<?php } ?>	
	</div>
</div>

<?php $this->load->view('common_modal'); ?>		
	
	
	
	
	
	
	
	