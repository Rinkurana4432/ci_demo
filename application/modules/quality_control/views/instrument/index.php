 
<?php  $this->load->model('Quality_control_model');		
if($this->session->flashdata('message') != ''){?>                        
	<div class="alert alert-success col-md-6">                            
	<?php echo $this->session->flashdata('message');?> </div>                        
<?php } ?>
<div class="x_content">
<div class="stik">
 <?php $str = base64_decode('YW5vZGl6ZSQxMjNfQCMhQA==');
      str_replace("_@#!@", "", $str);
	?>
</div>
	<div class="row">
		<div class="col-md-3 datePick-right col-xs-12 ">
			<button type="button" class="btn btn-primary qualityTab addBtn" data-toggle="modal" id="addins"
				data-id="AddInstrument">Add Instrument</button>
		</div>
		<div class="col-md-12 col-xs-12 col-sm-12">

			<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>"
				id="loggedInUserId">
			<p class="text-muted font-13 m-b-30"></p>

			<div id="print_div_content">
				<table id="datatable-buttons" class="table table-striped table-bordered account_index" border="1"
					cellpadding="3">
					<thead>
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>Range</th>
							<th>Instrument Assigned</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($ins as $val){?>
						<tr>
							<td><?php echo $val['id'];?></td>
							<td><?php echo $val['name'];?></td>
							<td><?php echo $val['ins_range'];?>
								<?php echo !empty($val['upper_range']) ? '-'.$val['upper_range']:'';?>
								<?php echo $val['range_uom'];?>							
							</td>
							<td><?php echo $val['ins_assign_to'];?></td>
							<td>
								<button type="button" data-id="EditInstrument" data-tooltip="Edit"
									class="btn btn-edit btn-xs qualityTab" data-toggle="modal"
									id="<?php echo $val['id'];?>"><i class="fa fa-pencil"></i></button>
								<button type="button" data-id="ViewInstrument" data-tooltip="View"
									class="btn btn-view btn-xs qualityTab" data-toggle="modal"
									id="<?php echo $val['id'];?>"><i class="fa fa-eye"></i></button>
								<a href="<?php echo base_url(); ?>quality_control/delete_instrument/<?php echo $val['id'];?>"
									class="btn btn-delete btn-xs"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

		<div id="quality_modal" class="modal fade in" role="dialog">
			<div class="modal-dialog modal-lg modal-large">
				<div class="modal-content" style="display:table;">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Instrument Details</h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>
