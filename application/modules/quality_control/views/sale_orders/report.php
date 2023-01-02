<?php  $this->load->model('Quality_control_model');		
if($this->session->flashdata('message') != ''){?>                        
	<div class="alert alert-success col-md-6">                            
	<?php echo $this->session->flashdata('message');?> </div>                        
<?php }?>
<div class="x_content">
<div class="stik">

 <?php $str = base64_decode('YW5vZGl6ZSQxMjNfQCMhQA==');
      str_replace("_@#!@", "", $str);
	?>
</div>
	<div class="row">

						<div class="col-md-12 col-xs-12 col-sm-12">
							
									
						
	<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
<p class="text-muted font-13 m-b-30"></p>    

<div id="print_div_content">  

	<table  id="datatable-buttons"  class="table table-striped table-bordered account_index" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
		<thead>
			<tr>
				<th>Id</th>
				<th>Report Name</th>
				<th>Work order</th>
				<th>Job Card</th>
				<th>Process</th>
				<th>Actions</th>	
			</tr>
		</thead>
		<tbody>
	<?php $j=1;
	foreach($ins as $data){ ?>
		<tr>
		    <td><?php echo $j;?></td>
		     <td><?php echo $data->report_name;?></td>
		     <td><?php echo $this->Quality_control_model->get_row_value('work_order','id',$data->workorder_id);?></td>
		     <td><?php echo $data->job_card;?></td>
		     <td><?php echo $this->Quality_control_model->get_row_value('add_process','id',$data->process_id);?></td>
		     	<td>
	<button type="button" data-id="ViewInspectionReport" data-tooltip="View" class="btn btn-edit btn-xs qualityTab" data-toggle="modal" id="<?php echo $data->id;?>" jobCard="<?= $data->job_card??'' ?>" processId="<?= $data->process_id??''; ?>" machineId="<?= $data->machine_id??''; ?>">View</button>
						</td>
		</tr>
		<?php $j++; } ?>				
				</tbody>                               
		</table>
	</div>
</div>

<div id="quality_modal" class="modal fade in"  role="dialog" >
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content" style="display:table;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Report Details</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>