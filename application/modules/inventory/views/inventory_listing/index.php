
<?php 
	if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-info col-md-6">                            
			<?php echo $this->session->flashdata('message');?> </div>                        
<?php }?>
	<div class="x_content">
		<div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Inventory Listing</a></li>
                <li role="" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Work In Process</a></li>
            </ul>
			<div id="myTabContent" class="tab-content">
				<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
					<form action="<?php echo site_url(); ?>inventory/inventory_listing" method="post" id="export-form">
						<input type="hidden" value='' id='hidden-type' name='ExportType'/>
						<input type="hidden" value='' class='start_date' name='start'/>
						<input type="hidden" value='' class='end_date' name='end'/>
					</form>
				<?php if(!empty($inventory_listing)){ ?>
					<div class="row hidde_cls">
						<div class="col-md-12">
							<div class="col-md-4"></div>
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
						<table id="datatable-buttons" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3" width="100%">
							<thead>
								<tr>
									<th>Id</th>
									<th>Product Type</th>
									<th>Product Name</th>
									<th>Source Location</th>
									<th>Quantity</th>
									<th>UOM</th>
									<th class='hidde'>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php if(!empty($inventory_listing)){						
										foreach($inventory_listing as $inventoryListing){
										$materialType = getNameById('material_type',$inventoryListing['material_type_id'],'id'); 
								?>
								<tr>
									<td><?php echo $inventoryListing['id']; ?></td>
									<td><?php if(!empty($materialType)){echo $materialType->name;} else {echo "N/A";} ?></td>
									<td><a href="javascript:void(0)" id="<?php echo $inventoryListing['id']; ?>" data-id="material_view" class="inventory_tabs"><?php echo $inventoryListing['material_name']; ?></a></td>
									<td>
										<table id="datatable-buttons" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
											<?php 
											$sourceData=json_decode($inventoryListing['location']);
												if(!empty($sourceData)) {
													foreach($sourceData as $source_Data){	
													$locationName=getNameById('location_settings',$source_Data->location,'id');	
											?>
											<thead>
												<tr>
													<th>Address</th>
													<th>Storage</th>
													<th>Rack number</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th><?php if(!empty($locationName)){echo $locationName->location;} ?></th>
													<th><?php echo $source_Data->Storage; ?></th>
													<th><?php echo $source_Data->RackNumber; ?></th>
												</tr>
											</tbody>
										
											<?php }} ?>
										</table>
									</td>
									<td><?php echo $inventoryListing['closing_balance']; ?></td>
									<td><?php echo $inventoryListing['uom']; ?></td>
								
									<td class='hidde'>							
										<select class="form-control action"  onchange="getAction(event,this)">
										<option>Action</option>
											<option value="Move" id="<?php echo $inventoryListing["id"]; ?>" data-id="move" data-materialType-id="<?php echo $inventoryListing["material_type_id"]; ?>" data-mat-name="<?php echo $inventoryListing["material_name"]; ?>" >Move</option>
									  
											<option value="Scrap" id="<?php echo $inventoryListing["id"]; ?>" data-id="scrap" data-materialType-id="<?php echo $inventoryListing["material_type_id"]; ?>" data-mat-name="<?php echo $inventoryListing["material_name"]; ?>" >Scrap</option>
									  
											<option value="Stock_check" id="<?php echo $inventoryListing["id"]; ?>" data-id="stock_check" data-mat-name="<?php echo $inventoryListing["material_name"]; ?>" data-materialType-id="<?php echo $inventoryListing["material_type_id"]; ?>">Stock Check</option>
									  
											<option value="Consumed" id="<?php echo $inventoryListing["id"]; ?>" data-id="consumed" data-mat-name="<?php echo $inventoryListing["material_name"]; ?>" data-materialType-id="<?php echo $inventoryListing["material_type_id"]; ?>">Consumed</option>
									  
											<option value="book" id="<?php echo $inventoryListing["id"]; ?>" data-id="half_full_book" data-mat-type-name="<?php echo $materialType->name; ?>" data-mat-name="<?php echo $inventoryListing["material_name"]; ?>" data-uom="<?php echo $inventoryListing['uom']; ?>" data-materialType-id="<?php echo $inventoryListing["material_type_id"]; ?>">Half/Full Book</option>
									  
											<option value="material_conversion" id="<?php echo $inventoryListing["id"]; ?>" data-id="material_conversion" data-mat-type-name="<?php echo $materialType->name; ?>" data-mat-name="<?php echo $inventoryListing["material_name"]; ?>" data-uom="<?php echo $inventoryListing['uom']; ?>" data-materialType-id="<?php echo $inventoryListing["material_type_id"]; ?>">Material Conversion</option>
										</select>
									</td>		
								</tr>
								<?php 
									$output[] = array(
									   'Id' => $inventoryListing['id'],
									   //'Material Type' => $materialType->name,
									   'Material Name' => $inventoryListing['material_name'],
									   
									   'Quantity' => $inventoryListing['closing_balance'],
									   'UOM' => $inventoryListing['uom'],
									   
									   'Created Date' => date("d-m-Y", strtotime($inventoryListing['created_date'])),
									);	
								}
									$data3  = $output;
									export_csv_excel($data3);	
								} ?>
							</tbody>                   
						</table>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
				  <div id="print_div_content">		
						<table id="datatable-buttons" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
							<thead>
								<tr>
									<th>Id</th>
									<th>Product Type</th>
									<th>Product Name</th>
									<th>Location</th>
									<th>Product status</th>
									<th>Quantity</th>
									<th>Uom</th>
								</tr>
							</thead>
							<tbody>
								<?php if(!empty($material_issue)){	
									foreach($material_issue as $materialIssue){
									$material_type = getNameById('material_type',$materialIssue['material_type_id'],'id');	
									$material_name = getNameById('material',$materialIssue['material_id'],'id');	
									$location_address = getNameById('location_settings',$materialIssue['location'],'id');	
									
								?>
								<tr>
									<td><?php echo $materialIssue['id']; ?></td>
									<td><?php if(!empty($material_type)){ echo $material_type->name;} else { echo "N/a";} ?></td>
									<td><?php if(!empty($material_name)){ echo $material_name->material_name;} else { echo "N/a";} ?></td>
									<td><?php if(!empty($location_address)){ echo $location_address->location;} else { echo "N/a";} ?></td>
									<td><?php echo $materialIssue['material_status']; ?></td>
									<td><?php echo $materialIssue['quantity']; ?></td>
									<td><?php echo $materialIssue['uom']; ?></td>
									
									
									
								
									
								</tr>
								<?php }}?>
							</tbody>                   
						</table>
					</div>
				</div>
				
			</div>
        </div>

    </div>
	<!--Scrap modal-->
		<div class="modal fade" tabindex="-1" role="dialog" id="scrap_modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="scrap">Scrap Material</h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>

		<!--stock check modal-->
		<div class="modal fade" tabindex="-1" role="dialog" id="stock_modal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="stock_check">Stock Check</h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>
		<!--consumed modal-->
		<div class="modal fade" tabindex="-1" role="dialog" id="consumed_modal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="consumed">Consumed</h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>


		<!--move modal-->
		<div class="modal fade" tabindex="-1" role="dialog" id="move_modal">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="move">Move </h4>
			  </div>
			 <div class="modal-body-content"></div>
			</div>
		  </div>
		</div>	

		<!--half full book modal-->
		<div class="modal fade" tabindex="-1" role="dialog" id="book_modal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="book">Half/Full book </h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>	


		<!--Material conversion  modal-->
		<div class="modal fade" tabindex="-1" role="dialog" id="material_conversion">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="book">Material Conversion</h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>	
		
<?php $this->load->view('common_modal'); ?>		
	
	
	
	
	
	
	
	