<div class="x_content">
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
	
<?php if($can_add) {
		//echo '<a href="'.base_url().'crm/edit_lead/"><button type="buttton" class="btn btn-info">Add</button></a>'; 
		echo '<button type="button" class="btn btn-primary addBtn add_bid_mng_tabs" data-toggle="modal" id="add" data-id="meeting_edit">Add</button>';
	} ?>
		
	<p class="text-muted font-13 m-b-30"></p>	
		<div class="x_content">
			<div id="gridview">
		<div role="tabpanel" data-example-id="togglable-tabs">
			<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class="active"><a href="#meeting_schedule" data-select='users' id="usersActiveTab" role="tab" data-toggle="tab" aria-expanded="true">Meeting Schedule</a></li>
				<li role="presentation" class=""><a href="#meeting_done" data-select='users' id="usersInactiveTab" role="tab" data-toggle="tab" aria-expanded="true">Meeting Done</a></li>
			</ul>
			<div id="myTabContent" class="tab-content">
				<!---------------------------------Active user tab------------------------------------------------------------->
				<div role="tabpanel" class="tab-pane fade active in" id="meeting_schedule" aria-labelledby="usersActiveTab">
							<table id="datatable-buttons" class="table table-striped table-bordered user_index table-responsive" data-id="user" style="width:100%" border="1" cellpadding="3" >
								<thead>
									<tr>
										<th>Id</th>
										<th>Liasoning Agent</th>
										<th>Tender</th>
										<th>Meeting Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								
								<?php foreach($meeting as $data){?>
								<tr><td><?php echo $data['id'];?></td>
								<td><?php $val=$this->bid_management_model->get_data_byId('liasoning_agent','id',$data['agent_id']); 
								echo $val->name;?></td>
								<td><?php
							$tender = $this->bid_management_model->get_data_byId('register_opportunity','id',$data['tender_id']);
	
							$tender1 = json_decode($tender->tender_detail,true);
					//if(!empty($tender1)){
						foreach($tender1 as $val){
							echo $val['tender_name'];
						}
					//}
					?>
							</td>
							<td><?php echo date('d-m-Y',strtotime($data['meeting_date']));?></td>
                            <td class="hidde">
                 <a href="javascript:void(0)" id="<?php echo $data['id'];?>" data-id="meeting_edit" data-tooltip="Edit" class="add_bid_mng_tabs btn btn-edit  btn-xs"><i class="fa fa-pencil"></i></a>
				  <a href="javascript:void(0)" id="<?php echo $data['id'];?>" data-id="meeting_cancel" data-tooltip="Cancel" class="add_bid_mng_tabs btn btn-delete  btn-xs"><i class="fa fa-ban"></i></a>
                 <a href="javascript:void(0)" id="<?php echo $data['id'];?>" data-id="view_meeting" data-tooltip="View" class="add_bid_mng_tabs btn btn-view  btn-xs"><i class="fa fa-eye"></i></a>   
                   <a href="javascript:void(0)" id="<?php echo $data['id'];?>" data-id="meeting_detail" data-tooltip="Edit" class="add_bid_mng_tabs btn btn-edit  btn-xs">Meeting Details</a>  
                 </td>
						</tr>			<?php } ?>
			
								</tbody>                   
							</table>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="meeting_done" aria-labelledby="usersInactiveTab">
                        <table id="datatable-buttons" class="table table-striped table-bordered user_index table-responsive" data-id="user" style="width:100%" border="1" cellpadding="3" >
								<thead>
									<tr>
										<th>Id</th>
										<th>Liasoning Agent</th>
										<th>Tender</th>
										<th>Meeting Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								
								<?php foreach($meeting_done as $data){?>
                                <tr>
								<td><?php echo $data['id'];?></td>
								<td><?php $val=$this->bid_management_model->get_data_byId('liasoning_agent','id',$data['agent_id']); 
								echo $val->name;?></td>
								<td><?php
							$tender = $this->bid_management_model->get_data_byId('register_opportunity','id',$data['tender_id']);
	
							$tender1=json_decode($tender->tender_detail,true);
						foreach($tender1 as $val){
							echo $val['tender_name'];
						}
							 ?>
							</td>
							<td><?php echo date('d-m-Y',strtotime($data['meeting_date']));?></td>
                            <td class="hidde">            
                   <a href="javascript:void(0)" id="<?php echo $data['id'];?>" data-id="view_meeting_detail" data-tooltip="View" class="add_bid_mng_tabs btn btn-view  btn-xs"><i class="fa fa-eye"></i></a>  
                 </td>
					</tr>			<?php } ?>
				
								</tbody>                   
							</table>
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
				<h4 class="modal-title nxt_cls" id="myModalLabel">Meeting Scheduling</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>			   
			   
			   
			   
		