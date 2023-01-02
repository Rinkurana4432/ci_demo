
<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-success col-md-6">                            
		<?php echo $this->session->flashdata('message');?> </div>                        
	<?php }?>
<div class="x_content addProcess-2">
	
	<p class="text-muted font-13 m-b-30"></p>    
<a href="<?php echo base_url();?>/production/Add_Process_edit/"><button class="btn btn-primary editProcess" data-toggle="modal">Add process</button></a>
	<table id="datatable-buttons" class="table table-striped table-bordered account_index" data-id="account">
		<thead>
			<tr>
				<th>Id</th>
						<th>Process Type</th>
						<th>Process</th>
						<th>Action</th>
					</tr>
			</tr>
		</thead>
		<tbody>
		<?php if(!empty($addProcess)){
						foreach($addProcess as $add_Process){
					?>
						<tr>
							<td><?php echo $add_Process['id']; ?></td>
							<td><?php echo $add_Process['process_type']; ?></td>
							<td><?php echo $add_Process['Add_Process']; ?></td>
							<td>	 
							<?php 
							if($can_edit) { 
								echo '<a href="'.base_url().'production/Add_Process_edit/'.$add_Process['id'].'" data-tooltip="Edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>';
							}
                            if($can_delete){
								echo '<a href="javascript:void(0)" class="delete_listing
                                 btn btn-danger" data-tooltip="Delete" data-href="'.base_url().'production/delete/'.$add_Process['id'].'"><i class="fa fa-trash"></i></a>';
							}
							?>	
							
								
							</td>
						</tr>
						<?php }
								} ?>
				</tbody>                               
	</table>
</div>

    