
<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-info col-md-6">                            
		<?php echo $this->session->flashdata('message');?> </div>                        
	<?php }?>
<div class="x_content">
	<?php 
	/*if($can_add) { 
		echo'<button type="buttton" class="btn btn-info inventory_tabs" id="location_setting" data-toggle="modal" data-id="editLocation">Add</button>';
	}*/
	?>
	<p class="text-muted font-13 m-b-30"></p>     
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveLocationSetting" enctype="multipart/form-data" id="materialForm" novalidate="novalidate">
		<table class="table table-striped maintable" id="mytable">
			<thead>
				<tr>
					<th>Id</th>
					<th>Location</th>
					<th>Area</th>
					<th>Action</th>
				</tr>
		    </thead>
			<tbody>
			 <?php 
				if(!empty($location_setting)){
					
				    foreach($location_setting as $locationSetting){

						$AreaData = json_decode($locationSetting['area']);
						    $AreaArray='';
							if(!empty($AreaData)){
							foreach($AreaData as $area_data){
								$areaDetail = $area_data->area;
								$AreaArray .= $areaDetail.',';  
							}
							}		

						  
			?>
			<tr>
				<td><?php echo $locationSetting['id'];?></td>
				<td><?php echo $locationSetting['location'];?></td>
				<td><?php if(!empty($AreaArray)){echo $AreaArray;} else {echo "NULL";}?></td>
				<td>
					<?php 
					/*if($can_add) { 
						echo'<button type="buttton" class="btn btn-info inventory_tabs" id="'.$inventoryListing["id"].'" data-toggle="modal" data-id="editLocation">Add</button>';
					}*/
					
					if($can_edit) { 
						echo '<button class="btn btn-info btn-xs inventory_tabs" id="'.$locationSetting["id"].'" data-toggle="modal" data-id="editLocation"><i class="fa fa-pencil"></i> Edit </button>'; 
					}
					if($can_view) { 
						echo '<a href="javascript:void(0)" id="'.$locationSetting["id"] . '" data-id="location_view" class="inventory_tabs btn btn-warning btn-xs" id="'. $locationSetting["id"].'"><i class="fa fa-eye"></i> View </a>'; 
					}
					if($can_delete) { 
						echo '<a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'inventory/delete_location/'.$locationSetting["id"].'"><i class="fa fa-trash"></i></a>';
						}
					?>
				</td>
				</tr>
							<?php 	}}?>
			</tbody>                   
		</table>
</div>

<!-- modal-->
<div id="inventory_add_modal" class="modal fade in"  class="modal fade in"  role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">location Setting</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>

