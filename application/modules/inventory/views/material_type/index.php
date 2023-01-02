<?php if($this->session->flashdata('message') != ''){?>                        		
<div class="alert alert-info">                            		
  <?php echo $this->session->flashdata('message');?> 
</div>                        	
<?php }?>
<div class="x_content">	
	<?php //if($can_add){ echo '<button type="buttton" class="btn btn-info inventory_tabs addBtn" id="mtaerial_add" data-toggle="modal" data-id="editMaterial">Add</button>'; } ?>
	<button type="buttton" class="btn btn-info inventory_tabs addBtn" id="mtaerial_add" data-toggle="modal" data-id="editMaterialType">Add</button>
	
	<p class="text-muted font-13 m-b-30"></p>
<input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">	                   			
  <table id="datatable-buttons" class="table table-striped table-bordered user_index sale_order_index" data-id="user">				
    <thead>					
		<tr>						
			<th>Id</th>						
			<th>Material type</th>
			<th>Prefix</th>
			<th>Action</th>					
		</tr>				
    </thead>
	
		<tbody>	
			<?php if(!empty($material_type)){
				foreach($material_type as $materialType){ 
				$disable = ($materialType['status'] !=1 && $_SESSION['loggedInUser']->id == $materialType['created_by_cid']?'disabled':'');
				
				$disableClass = ($materialType['status'] !=1 && $_SESSION['loggedInUser']->id == $materialType['created_by_cid']?'disableBtnClick':'');
			
			?>		
			<tr>
			
				<td><?php echo $materialType['id']; ?></td>								
				<td><?php echo $materialType['name']; ?></td>								
				<td><?php echo $materialType['prefix']; ?></td>	
				<td>								
				<?php 
				if($can_edit) { 	
				//pre($disableClass);	
					if($disable){				
						echo '<button data-id="editMaterialType" id="'.$materialType["id"].'" class="btn btn-info btn-xs inventory_tabs" disabled ="'.$disable.'"><i class="fa fa-pencil"></i> Edit </button>';
					}else{	
					echo '<button data-id="editMaterialType" id="'.$materialType["id"].'" class="btn btn-info btn-xs inventory_tabs"><i class="fa fa-pencil"></i> Edit </button>';	
						}
				}									
				if($can_delete) { 
					if($disable){
						echo '<a href="javascript:void(0)" class="delete_listing										
						btn btn-danger btn-xs" data-href="'.base_url().'inventory/delete_materialType/'.$materialType["id"].'" "'.$disable.'"><i class="fa fa-trash"></i>Delete</a>';
					}else{
						echo '<a href="javascript:void(0)" class="delete_listing										
						btn btn-danger btn-xs" data-href="'.base_url().'inventory/delete_materialType/'.$materialType["id"].'" ><i class="fa fa-trash"></i>Delete</a>';
					}						
				}								
											
				?>
				</td>	
						
			</tr>	
			<?php }}?>	
		</tbody>                   			
	</table>
</div>	
<div id="inventory_add_modal" class="modal fade in"  class="modal fade in"  role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Type of Material</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>