<div class="x_content">
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
	
<div class="stik">	
			<div class="btn-group" role="group" aria-label="Basic example" style="text-align: right;">
			<?php if($can_add) {
		//echo '<a href="'.base_url().'crm/edit_lead/"><button type="buttton" class="btn btn-info">Add</button></a>'; 
		echo '<button type="button" class="btn btn-primary addBtn add_bid_mng_tabs" data-toggle="modal" id="add" data-id="liasoning_agent_edit">Add</button>';
	} ?>

				<form action="<?php echo site_url(); ?>bid_management/register_opportunity" method="post" id="export-form">
					<input type="hidden" value='' id='hidden-type' name='ExportType'/>
					<input type="hidden" value='' class='start_date' name='start'/>
					<input type="hidden" value='' class='end_date' name='end'/>
				</form>
				
	</div>	
</div>
	
	
			</select>
	</div>
<?php //} ?>
		
	<p class="text-muted font-13 m-b-30"></p>	
		<div class="x_content">
			<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<div id="myTabContent" class="tab-content">
					
					<div role="tabpanel" class="tab-pane fade active in" id="new_leads" aria-labelledby="new_lead_tab">
						<div id="print_div_content">
							<table id="datatable-buttons" class="table table-striped table-bordered user_index table-responsive" data-id="user" style="width:100%" border="1" cellpadding="3">
								<thead>
									<tr>
										<th>Id</th>
										<th>Name</th>
										<th>Phone no.</th>
										<th>Email</th>
										<th>Agreement no</th>
										<th class='hidde'>Action</th>
									</tr>
								</thead>
								<tbody>
                                
					<?php foreach($agent_data as $data){ ?><tr>
					<td><?php echo $data['id'];?></td>
					<td><?php echo $data['name'];?></td>
					<td><?php echo $data['phone'];?></td>
					<td><?php echo $data['email'];?></td>
					<td><?php echo $data['agreement_no'];?></td>
					<td class="hidde">
                 <a href="javascript:void(0)" id="<?php echo $data['id'];?>" data-id="liasoning_agent_edit" data-tooltip="Edit" class="add_bid_mng_tabs btn btn-edit  btn-xs"><i class="fa fa-pencil"></i></a>   
                    <a href="<?php echo base_url();?>bid_management/delete_liasoning_agent/<?php echo $data['id'];?>" class=" btn btn-xs btn-delete" data-href=""><i class="fa fa-trash"></i></a>
                    <a href="javascript:void(0)" id="<?php echo $data['id'];?>" data-id="liasoning_agent_view" data-tooltip="View" class="add_bid_mng_tabs btn btn-edit  btn-xs"><i class="fa fa-eye"></i></a> 
                    </td></tr>
					<?php } ?>
					
								</tbody>                   
							</table>
						</div>
					</div>
						</div>
					
				</div>
			</div>   
</div>   
			   


<div id="crm_add_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title nxt_cls" id="myModalLabel">Liasoning Agent Details</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>			   
			   
			   
			   
		