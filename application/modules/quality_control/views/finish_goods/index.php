 
<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-info">                            
			<?php echo $this->session->flashdata('message');?> 
		</div>                        
	<?php }
?>
<div class="x_content">
<div class="stik">
	
</div>	
	<p class="text-muted font-13 m-b-30"></p>
	<input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">
	<div id="print_div_content">
    <!---------- datatable-buttons    ---------->		
		<table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
			<thead>
				<tr>
					<th>Id
      <span><a href="<?php echo base_url(); ?>inventory/finish_goods?sort=asc" class="up"></a>
	<a href="<?php echo base_url(); ?>inventory/finish_goods?sort=desc" class="down"></a></span> </th>
					<th>Job card Detail
      <span><a href="<?php echo base_url(); ?>inventory/finish_goods?sort=asc" class="up"></a>
	<a href="<?php echo base_url(); ?>inventory/finish_goods?sort=desc" class="down"></a></span></th>
					<th>Scrap Qty</th>
					<th>Scrap Material Name</th>
					<th>Acknowledge By</th>
					<th>Acknowledge Date</th>
					<th>Action</th>					
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($finish_goods)){	
					foreach($finish_goods as $finish_good){
						
							
					$scrap_material_name = getNameById('material',$finish_good['material_scrap_id'],'id');	
					
				?>
				<tr>
					<td><?php echo $finish_good['id']; ?></td>
					
						<?php $jobCardDetail= json_decode($finish_good['job_card_detail']);
							if(!empty($jobCardDetail)){
								foreach($jobCardDetail as $job_card){
									if(!empty($job_card->material_id)){
									@$material_detail_count = count($job_card->material_id);
									}
								@$jobCardname = getNameById('job_card',$job_card->job_card_no,'id')->job_card_product_name;
								}			
							}	
					?>
					
						<td><a href="javascript:void(0)" id="<?php echo $finish_good['id']; ?>" data-id="jobcard_details" class="qualityTab" data-toggle= "modal"><?php echo $jobCardname; ?></a></td>
						

	<td><?php echo $finish_good['scrap_qty']; ?></td>
	<td><?php if(!empty($scrap_material_name)){echo $scrap_material_name->material_name; } else{ echo "";}?></td>
	<th><?php echo $finish_good['aknowlwdge_by']; ?></th>
	<th><?php echo $finish_good['acknowledge_date']; ?></th>
	<th><button type="button" data-id="EditGood" data-tooltip="Edit" class="btn btn-edit btn-xs qualityTab" data-toggle="modal" id="<?php echo $finish_good['id']; ?>">Edit</button></th>		
</tr>
<?php }}?>
</tbody>                   
</table> <?php //echo $this->pagination->create_links(); ?>	
	</div>
</div>
<div id="printView">
	<div id="quality_modal" class="modal fade in" role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Finish Goods</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
</div>				