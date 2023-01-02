<div class="x_content">
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	       <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button> 
			 <div id="demo" class="collapse">
	        <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>bid_management/liasoning_report" enctype="multipart/form-data"  novalidate="novalidate">
	           <div class="item form-group col-md-12 col-sm-12 col-xs-12 r" style="text-align: center;">
						<label class="col-md-12 col-sm-12 col-xs-12" >Liasoning Agent</label>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<select class="form-control selectAjaxOption select2 select2-hidden-accessible agent_id select2"  name="agent_id" data-id="liasoning_agent" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" id="agent_id">
								<option value="">Select Option</option>
							<?php
								if (!empty($register_opportunity)) {
									$agent_id = get_data('liasoning_agent');
									echo '<option value="' . $agent_id['agent_id'] . '" selected>' . $agent_id['name'] . '</option>';
								}
								?>
							</select>
						</div>
						<input type="submit" class="btn edit-end-btn" value="Submit">
					</div>
			</form>	
			</div>
	  </div>
</div>	  

		
	<p class="text-muted font-13 m-b-30"></p>	
		<div class="x_content">
			<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<div id="myTabContent" class="tab-content">
					
					<div role="tabpanel" class="tab-pane fade active in" id="new_leads" aria-labelledby="new_lead_tab">
						<div id="print_div_content">
							<table id="datatable-buttons" class="table table-striped table-bordered user_index table-responsive" data-id="user" style="width:100%" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
								<thead>
									<tr>
										<th>Liasoning Agent</th>
										<th>Tender Number</th>
										<th>Phone no.</th>
										<th>Agreement no</th>
										<th>Meeting Date</th>
										<th>Meeting With</th>
										<th>Meeting Response</th>
										<th>Actual Bid</th>
										<th>Target Bid</th>
										<th>Units</th>
									</tr>
								</thead>
								<tbody>
								
                                <?php foreach($agent as $data){
									?>
							<tr>
							<td><?php echo $data['name'];?></td>												
								<td><?php 
								$tender = $this->bid_management_model->get_data_byId('register_opportunity','id',$data['tender_id']);
	
							$tender1=json_decode($tender->tender_detail,true);
						foreach($tender1 as $val){
							echo $val['tender_name'];
						}?></td>
								<td><?php echo $data['phone']; ?></td>
								<td><?php echo $data['agreement_no']; ?></td>
								<td><?php echo $data['meeting_date']; ?></td>
								<td><?php echo $data['meeting_person']; ?></td>
								<td><?php echo $data['message_detail']; ?></td>
								<td></td>
								<td></td>
								<td></td>
								</tr>
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
			   
			   
			   
		