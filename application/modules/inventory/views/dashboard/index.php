
<?php  
#pre($user_dashboard);

	if(!empty($user_dashboard)){
		$inventory_monthWise_listing_adjustment_key = array_search('inventory_monthWise_listing_adjustment', array_column($user_dashboard, 'graph_id'));
		$inventory_material_category_with_amount_key = array_search('inventory_material_category_with_amount', array_column($user_dashboard, 'graph_id'));
		$inventory_scrapped_material_type_key = array_search('inventory_scrapped_material_type', array_column($user_dashboard, 'graph_id'));
		$inventory_material_move_key = array_search('inventory_material_move', array_column($user_dashboard, 'graph_id'));
		$inventory_material_DoNotmove_key = array_search('inventory_material_DoNotmove', array_column($user_dashboard, 'graph_id'));
	}
?>

<div class="row dashboard-main">
	<div class="col-md-12 export_div">
	<div class="col-md-2 datePick-right">
		<fieldset>
			<div class="control-group">
			  <div class="controls col-md-4">
				<div class="input-prepend input-group">
				  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
				  <input type="text" style="width: 200px" class="dashboardFilter form-control" class="form-control" value="" data-filter-id="dashboardInventory" />
				</div>
			  </div>
			</div>
		</fieldset>
	</div>
	</div>
	<div class="row top_tiles col-md-12 col-sm-12 col-xs-12">
	</div>
		
	<!-------------------------------------------------------- bar charts group ---------------------------------------------->
    <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Month wise Inventory listing<small>adjustment</small></h2>
					<ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" id="inventory_monthWise_listing_adjustment_adjustment" class="graphCheckbox"  <?php if( isset($inventory_monthWise_listing_adjustment_key) && $user_dashboard[$inventory_monthWise_listing_adjustment_key]['graph_id'] == 'inventory_monthWise_listing_adjustment' && $user_dashboard[$inventory_monthWise_listing_adjustment_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
							</div>
						</div>
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Settings 1</a></li>
								<li><a href="#">Settings 2</a></li>
							</ul>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content2">
			  <div id="month_Wise_graph" style="width:100%; height:300px;" ></div>
			</div>
		</div>
    </div>
    <!-------------------------------------------/bar charts graph ------------------------------------------>
<!------------------------------------------ pie chart for category fo material --------------------------------------------->
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Category of Product<small>Total Amount</small></h2>
					<ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" id="inventory_material_category_with_amount" class="graphCheckbox"  <?php if( isset($inventory_material_category_with_amount_key) && $user_dashboard[$inventory_material_category_with_amount_key]['graph_id'] == 'inventory_material_category_with_amount' && $user_dashboard[$inventory_material_category_with_amount_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
							</div>
						</div>
						
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#">Settings 1</a></li>
										<li><a href="#">Settings 2</a></li>
									</ul>
							</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div id="material_type_graph_donut"  style="width:100%; height:250px;"></div>
			</div>
		</div>
	</div>
    <!------------------------------------------------- /Pie chart --------------------------------------------------------->
	
	
		
	<!-------------------------------------------- Progress Bar fro scrapped data ------------------------------------------------------>
	<div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel tile fixed_height_320" style="height:405px;">
            <div class="x_title">
                <h2>Scrapped  Product List</h2>
					<ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" id="inventory_scrapped_material_type" class="graphCheckbox"  <?php if( isset($inventory_scrapped_material_type_key) && $user_dashboard[$inventory_scrapped_material_type_key]['graph_id'] == 'inventory_scrapped_material_type' && $user_dashboard[$inventory_scrapped_material_type_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
							</div>
						</div>
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Settings 1</a></li>
								<li><a href="#">Settings 2</a></li>
							</ul>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
            </div>
            <div class="x_content" id="scrappedDiv"></div>
		</div>
    </div>   
	<!----------------------------------------------------------/progress bar------------------------------------------------------>
	
	<!-----------------------------------------tbale to display material move---------------------------------------------------->
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_panel tile fixed_height_320">
            <div class="x_title">
                <h2>Product movement</h2>
					<ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" id="inventory_material_move" class="graphCheckbox"  <?php if( isset($inventory_material_move_key) && $user_dashboard[$inventory_material_move_key]['graph_id'] == 'inventory_material_move' && $user_dashboard[$inventory_material_move_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
							</div>
						</div>
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Settings 1</a></li>
								<li><a href="#">Settings 2</a></li>
							</ul>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
            </div>
            <div class="x_content">
				<table  class="table table-striped " data-id="user" border="0" cellpadding="3">
					<thead>
					<tr>
						<th>Product</th>
						<th>Quantity</th>
						<th>Current Location</th>
					</tr>
					</thead>
					<tbody>
						<?php if(!empty($materialMove)){
								foreach($materialMove as $material_move){
								$material_id=getNameById('material',$material_move['material_name_id'],'id');
						?>
						<tr>
							<td><?php echo $material_id->material_name; ?></td>
							<td><?php echo $material_move['quantity']."--".$material_move['uom']; ?></td>
							<td>
								<table class="table table-striped">
									<thead>
									<tr>
										<th>Location</th>
										<th>Storage</th>
										<th>Rack Number</th>
									</tr>
									</thead>
									<?php $location = json_decode($material_move['location']);
											if(!empty($location)){
												foreach($location as $location_data){
													
													$location_name = getNameById('location_settings',$location_data->location,'id');
									?>
									<tbody>
									<tr>
										<td><?php if(!empty($location_name)){echo $location_name->location;} else{ echo "";}?></td>
										<td><?php echo $location_data->Storage;?></td>
										<td><?php echo $location_data->RackNumber;?></td>
									</tr><?php }} ?>
									</tbody>
								</table>
							</td>
						</tr>
						<?php }}?>
					</tbody>
				</table>
			</div>
		</div>
    </div>
		
	<!----------------------------------------------last three month -------------------------------------------------->
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_panel tile fixed_height_320">
			<div class="x_title">
				<h2>Last Three Month Data</h2>
				<ul class="nav navbar-right panel_toolbox">
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="checkbox">
							<label><input type="checkbox" id="inventory_material_DoNotmove" class="graphCheckbox"  <?php if( isset($inventory_material_DoNotmove_key) && $user_dashboard[$inventory_material_DoNotmove_key]['graph_id'] == 'inventory_material_DoNotmove' && $user_dashboard[$inventory_material_DoNotmove_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
						</div>
					</div>
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Settings 1</a></li>
							<li><a href="#">Settings 2</a></li>
						</ul>
				</li>
				<li><a class="close-link"><i class="fa fa-close"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<table class="table table-striped">
					<thead>
						<tr>
						<th>Product Name</th>
						<th>Quantity</th>
						
						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($materialDonotMove)){
							foreach($materialDonotMove as  $mat_not_move){
							$material_name = getNameById('material',$mat_not_move['material_name_id'],'id');	
						?>
						<tr>
							<td><?php echo $material_name->material_name; ?></td>
							<td><?php echo $material_name->opening_balance; ?></td>
						</tr>
						<?php }} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
    
</div>
           
			  
			  

                   


            



            



          
     