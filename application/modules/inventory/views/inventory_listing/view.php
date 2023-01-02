

            <input type="hidden" name="id" value="<?php if($InventoryAdjustmentView && !empty($InventoryAdjustmentView)){ echo $InventoryAdjustmentView->id;} ?>">
	<div class="col-md-12 col-sm-12 col-xs-12">               
		<table class="fixed data table table-striped no-margin">            
			<thead>               
				<tbody>                   
					<tr>                        
						                                              
						 <th>Source Data:</th>
						 <th>
						 <table class="fixed data table table-striped no-margin">
							 <thead>
							 <tbody>
								 <tr>
								 <th>Address</th>
								 <th>Storage Location</th>
								 <th>Rack Number</th>
								</tr>
								<?php 
								if(!empty($InventoryAdjustmentView) && $InventoryAdjustmentView->sourceAddress !=''){					
									$sourcedata =  json_decode($InventoryAdjustmentView->sourceAddress);  
									foreach($sourcedata as $source_data){
									?>		
								<tr>
									<td><?php echo $source_data->address; ?><br /></td>
									<td><?php echo $source_data->storage_area;?><br /></td>
									<td><?php echo $source_data->rack_no;?><br /></td>
								</tr>
								<?php }                                     
								}?>
								
							</tbody>
							</thead>
						</table>
						</th> 
					</tr>
					<tr>                                               
						 <th>Destination Data:</th>
						 <th>
						 <table class="fixed data table table-striped no-margin">
							 <thead>
							 <tbody>
								 <tr>
								 <th>Address</th>
								 <th>Storage Location</th>
								 <th>Rack Number</th>
								</tr>
								<?php 
								if(!empty($InventoryAdjustmentView) && $InventoryAdjustmentView->destinationAddress !=''){					
									$Destinationdata =  json_decode($InventoryAdjustmentView->destinationAddress);  
									foreach($Destinationdata as $Destination_data){
									?>		
								<tr>
									<td><?php echo $Destination_data->Destaddress; ?><br /></td>
									<td><?php echo $Destination_data->Deststorage_area;?><br /></td>
									<td><?php echo $Destination_data->DestRack_no;?><br /></td>
								</tr>
								<?php }                                     
								}?>
								
							</tbody>
							</thead>
						</table>
						</th> 
					</tr>
					<tr>
					<th>Physical Stock check</th>
					<td><?php if(!empty($InventoryAdjustmentView)){ echo $InventoryAdjustmentView->stock_check; } ?></td>
					</tr>
					<tr>
					<th>Scrap Adjustment</th>
					<td><?php if(!empty($InventoryAdjustmentView)){ echo $InventoryAdjustmentView->scrap_adjustment; } ?></td>
					</tr>
					<tr>
					<th>Consumed</th>
					<td><?php if(!empty($InventoryAdjustmentView)){ echo $InventoryAdjustmentView->consumed; } ?></td>
					</tr>
					
				</tbody>          
			</thead>      
		</table>                    
	</div>

​
