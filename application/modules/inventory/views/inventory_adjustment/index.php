
<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-info col-md-6">                            
		<?php echo $this->session->flashdata('message');?> </div>                        
	<?php }?>
<div class="x_content">
	<div class="col-md-12 datePick">
		Date Range Picker                      
		  <fieldset>
			<div class="control-group">
			  <div class="controls">
				<div class="input-prepend input-group">
				  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
				  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="inventory/inventory_adjustments">
				</div>
			  </div>
			</div>
		  </fieldset>    
			<form action="<?php echo base_url(); ?>inventory/inventory_adjustments" method="post" id="date_range">	
				<input type="hidden" value='' class='start_date' name='start'/>
				<input type="hidden" value='' class='end_date' name='end'/>
			</form>          
    </div>

	<form action="<?php echo site_url(); ?>inventory/inventory_adjustments" method="post" id="export-form">
				<input type="hidden" value='' id='hidden-type' name='ExportType'/>
				<input type="hidden" value='' class='start_date' name='start'/>
				<input type="hidden" value='' class='end_date' name='end'/>
				<input type="hidden" value='<?php if(!empty($_POST['material_type'])){echo $_POST['material_type'] ;} ?>' class='material_type' name='material_type'/>
				<input type="hidden" value='<?php if(!empty($_POST['action'])){echo $_POST['action'] ;} ?>' class='action_type' name='action'/>
			</form>
		</div>
	</div>

	<!-- Filter div Start-->  
		<form action="<?php echo base_url(); ?>inventory/inventory_adjustments" method="post" >
				<div class="row  hidde_cls1 filter1 progress_filter">
						<div class="col-md-12">
							<div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
								<select name="material_type" class="form-control">
									<option value=""> Select Category </option>
									<option value=""> All Category </option>
										<?php
										if(!empty($mat_type) ){
											foreach($mat_type as $mattype){
										?>
										<option value="<?php echo $mattype['id']; ?>"><?php echo $mattype['name']; ?></option>	

										<?php } } ?>			
								</select>
							</div>
							<div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
								<select class="form-control" name="action">
									<option value=""> Select Action</option>
									<option value="">All</option>
									<option value="scrap">Scrap</option>
									<option value="move">Move </option>
									<option value="half_full_book">Half book/Full book</option>
									
									<option value="consumed">Consumed</option>
									<option value="stock_check">Stock check</option>
								</select>
							</div>
							<input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="inventory/inventory_adjustments" disabled="disabled">
					</div>
			</div>
		</form>	
		<!-- Filter div End-->
		



	<?php if(!empty($inventory_adjustment)){ ?>
			<div class="row hidde_cls">
				<div class="col-md-12">
					<div class="col-md-4">
					</div>
					<div class="col-md-4">
						<div class="btn-group"  role="group" aria-label="Basic example">
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
							<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
								<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu" id="export-menu">
										<li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
										<li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
									</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php } ?>
	
		<p class="text-muted font-13 m-b-30"></p>  
<div id="print_div_content">		
			<table id="datatable-buttons_wrapper" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
				<thead>
					<tr>
						<th>Id</th>
						<th>Action Type</th>
						<th>Product Name</th>
						<th>Product Type</th>
						<th>Source</th>
						<th>Destination</th>
						<th>Quantity</th>
						<th>UOM</th>
						
						
					</tr>
				</thead>
				<tbody>
					
					<?php if(!empty($inventory_adjustment)){						
					foreach($inventory_adjustment as $inventoryAdjustment){	
					$materialName= getNameById('material',$inventoryAdjustment['material_name_id'],'id');
					$materialType= getNameById('material_type',$inventoryAdjustment['material_type_id'],'id');
					?>
					<tr>
						<td><?php echo $inventoryAdjustment['id']; ?></td>
						<td><?php echo $inventoryAdjustment['action_type']; ?></td>
						<td>
						<a href="javascript:void(0)" id="<?php echo $inventoryAdjustment['material_name_id'] ; ?>" data-id="material_view" class="inventory_tabs"><?php if (!empty($materialName)) {	echo $materialName->material_name;	} ?></a>
						</td>
						<td><?php if(!empty($materialType)){echo $materialType->name; } else{ echo "N/A";} ?></td>
						
						<td>
							<table id="gg" class="table  table-bordered " data-id="user">
								<?php 
									$sourceData=json_decode($inventoryAdjustment['source_location']);
										if($sourceData == ''){	}else{ ?>		
										<thead>
											<tr>
												<th>Address</th>
												<th>Storage Area</th>
												<th>Rack Number</th>
											</tr>
										</thead>
								<?php 
									foreach($sourceData as $source_data){  
								?>
								<tbody>
									<tr>
										<th><?php echo $source_data->source_location; ?></th>
										<th><?php echo $source_data->source_storage; ?></th>
										<th><?php echo $source_data->source_rack_no; ?></th>
									</tr>				
								<?php }}?>
								</tbody>
							</table>
						</td>
						<td>
							<table id="gg" class="table table-bordered" data-id="user" border="1" cellpadding="3">
							<?php 
								$destinationData=json_decode($inventoryAdjustment['location']);
									if($destinationData == ''){}else{ ?>
								<thead>
									<tr>
										<th>Address</th>
										<th>Storage Area</th>
										<th>Rack Number</th>
									</tr>
								</thead>
								<?php 
									if(!empty($destinationData)){
										foreach($destinationData as $destination_data){ 
										$destinationlocation = getNameById('location_settings',$destination_data->location,'id');
									?>		
								
								<tbody>
									<tr>
										<th><?php if(!empty($destinationlocation)){echo $destinationlocation->location;}else{echo "N/A";} ?></th>
										<th><?php echo $destination_data->Storage; ?></th>
										<th><?php echo $destination_data->RackNumber; ?></th>
									</tr>				
									<?php }}}?>
								</tbody>
							</table>
						</td>
						<td><?php echo $inventoryAdjustment['quantity']; ?></td>
						
						<td><?php echo $inventoryAdjustment['uom']; ?></td>
					
					</tr>
					<?php
					$output[] = array(
						   'Id' => $inventoryAdjustment['id'],
						   'Action Type' => $inventoryAdjustment['action_type'],
						   'Material Name' => @$materialName->material_name,
						   'Material Type' => $materialType->name,
						   'Quantity' => $inventoryAdjustment['quantity'],
						   'UOM' => $inventoryAdjustment['uom'],
						   'Created Date' => date("d-m-Y", strtotime($inventoryAdjustment['created_date'])),
						);	
				}
				$data3  = $output;
				export_csv_excel($data3);	
					} ?>
					
				</tbody>                   
			</table>
</div>
</div>
<?php $this->load->view('common_modal'); ?>	



				