<?php
if (!empty($user_dashboard)) {
	$crm_graph_lead_status_key = array_search('crm_graph_lead_status', array_column($user_dashboard, 'graph_id'));
	$crm_graph_month_wise_lead_status_key = array_search('crm_graph_month_wise_lead_status', array_column($user_dashboard, 'graph_id'));
	$crm_graph_leads_vs_status_key = array_search('crm_graph_leads_vs_status', array_column($user_dashboard, 'graph_id'));
	$crm_graph_lead_target_vs_acheived_key = array_search('crm_graph_lead_target_vs_acheived', array_column($user_dashboard, 'graph_id'));
	$crm_graph_sale_order_key = array_search('crm_graph_sale_order', array_column($user_dashboard, 'graph_id'));
	$crm_graph_sale_order_approved_vs_disapproved_key = array_search('crm_graph_sale_order_approved_vs_disapproved', array_column($user_dashboard, 'graph_id'));
	$crm_graph_recent_activities_key = array_search('crm_graph_recent_activities', array_column($user_dashboard, 'graph_id'));
}
?>
<div class="row dashboard-main">
	<div class="col-md-12  export_div">
		<div class="col-md-2 col-xs-12 col-sm-6 datePick-right">
			<fieldset>
				<div class="control-group col-md-10">
					<div class="controls ">
						<div class="input-prepend input-group">
							<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							<!--input type="text" style="width: 200px; padding: 4px;" class="dashboardFilter form-control"  value="" data-filter-id="dashboardLeadTargetSetAcheived" /-->
							 <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="crm/dashboard" />
						</div>
						<a href="<?php echo base_url(); ?>crm/dashboard">
							<input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset">
					</div>
				</div>
				 <form action="<?php echo base_url(); ?>crm/graphDashboardData" method="get" id="date_rangewww">
               <input type="hidden" value='<?php if(!empty($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(!empty($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end' />
    
            </form>
			</fieldset>
		</div>
		<div class="col-md-6 datePick-right"></div>
	</div>
	<div class="row top_tiles col-md-12 col-sm-12 col-xs-12" style="padding: 0px;">
	
	
	</div>
	<!-- pie chart -->
	<!--<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Lead <small>Status</small></h2>
				<ul class="nav navbar-right panel_toolbox">
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="checkbox">
							<label><input type="checkbox" id="crm_graph_lead_status" class="graphCheckbox" <?php if (isset($crm_graph_lead_status_key) && $user_dashboard[$crm_graph_lead_status_key]['graph_id'] == 'crm_graph_lead_status' && $user_dashboard[$crm_graph_lead_status_key]['show'] == 1) {  echo 'checked';} ?>> Check the option to show graph on main dashboard</label>
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
				<div id="graph_donut_lead" style="width:100%; height:300px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Month wise Lead <small>Status</small></h2>
				<ul class="nav navbar-right panel_toolbox">
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="checkbox">
							<label><input type="checkbox" id="crm_graph_month_wise_lead_status" class="graphCheckbox" <?php if (isset($crm_graph_month_wise_lead_status_key) && $user_dashboard[$crm_graph_month_wise_lead_status_key]['graph_id'] == 'crm_graph_month_wise_lead_status' && $user_dashboard[$crm_graph_month_wise_lead_status_key]['show'] == 1) {	echo 'checked'; } ?>> Check the option to show graph on main dashboard</label>
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
			<div class="x_content1">
				<?php $where = '';
					$group = " group by date_format( created_date, '%Y-%m' )";
				?>
				<input type="hidden" value="<?php echo total_rows('leads', 'lead_status=1' . $where . ' AND DATE_FORMAT(created_date, "%Y") = YEAR (CURDATE())' . $group); ?>" id="group_lead_new">
				<div id="graph_bar_group_lead" style="width:100%; height:300px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_panel tile fixed_height_320">
			<div class="x_title">
				<h2>Total Leads Vs Success</h2>
				<ul class="nav navbar-right panel_toolbox">
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="checkbox">
							<label><input type="checkbox" id="crm_graph_leads_vs_status" class="graphCheckbox" <?php if (isset($crm_graph_leads_vs_status_key) && $user_dashboard[$crm_graph_leads_vs_status_key]['graph_id'] == 'crm_graph_leads_vs_status' && $user_dashboard[$crm_graph_leads_vs_status_key]['show'] == 1) { echo 'checked'; } ?>> Check the option to show graph on main dashboard</label>
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
				<h4>Successful leads Vs Total Leads</h4>
				<div class="widget_summary">
					<div class="w_left w_25">
						<span class="win"></span>
					</div>
					<div class="w_center w_55">
						<div class="progress">
							<div class="progress-bar bg-green" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
								<span class="sr-only">20% Complete</span>
							</div>
						</div>
					</div>
					<div class="w_right w_20">
						<span class="total"></span>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_panel fixed_height_320">
			<div class="x_title">
				<h2>Leads<small>Target Vs Acheived</small></h2>
				<ul class="nav navbar-right panel_toolbox">
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="checkbox">
							<label><input type="checkbox" id="crm_graph_lead_target_vs_acheived" class="graphCheckbox" <?php if (isset($crm_graph_lead_target_vs_acheived_key) && $user_dashboard[$crm_graph_lead_target_vs_acheived_key]['graph_id'] == 'crm_graph_lead_target_vs_acheived' && $user_dashboard[$crm_graph_lead_target_vs_acheived_key]['show'] == 1) {	echo 'checked'; } ?>> Check the option to show graph on main dashboard</label>
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
				<canvas id="lineChart1"></canvas>
			</div>
		</div>
	</div>
	<?php #echo $saleOrderGraphPermission;  
	if ($saleOrderGraphPermission  == 1) { ?>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Sale <small>Order</small></h2>
					<ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" id="crm_graph_sale_order" class="graphCheckbox" <?php if (isset($crm_graph_sale_order_key) && $user_dashboard[$crm_graph_sale_order_key]['graph_id'] == 'crm_graph_sale_order' && $user_dashboard[$crm_graph_sale_order_key]['show'] == 1) {	echo 'checked';	} ?>> Check the option to show graph on main dashboard</label>
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
				<div class="x_content1">
					<?php $where = '';
						$group = " group by date_format( created_date, '%Y-%m' )";
					?>
					<div id="graph_sale_order" style="width:100%; height:280px;"></div>
				</div>
			</div>
		</div>
	<?php }
	if ($saleOrderGraphPermission  == 1) { ?>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Sale Order<small>Approved Vs Disapproved</small></h2>
					<ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" id="crm_graph_sale_order_approved_vs_disapproved" class="graphCheckbox" <?php if (isset($crm_graph_sale_order_approved_vs_disapproved_key) && $user_dashboard[$crm_graph_sale_order_approved_vs_disapproved_key]['graph_id'] == 'crm_graph_sale_order_approved_vs_disapproved' && $user_dashboard[$crm_graph_sale_order_approved_vs_disapproved_key]['show'] == 1) { echo 'checked'; } ?>> Check the option to show graph on main dashboard</label>
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
				<div class="x_content1">
					<?php $where = '';
						$group = " group by date_format( created_date, '%Y-%m' )";
					?>
					<div id="graph_sale_order_count" style="width:100%; height:280px;"></div>
				</div>
			</div>
		</div>
	<?php } ?>
	<div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Recent Activities <small>Sessions</small></h2>
					<ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" id="crm_graph_recent_activities" class="graphCheckbox" <?php if (isset($crm_graph_recent_activities_key) && $user_dashboard[$crm_graph_recent_activities_key]['graph_id'] == 'crm_graph_recent_activities' && $user_dashboard[$crm_graph_recent_activities_key]['show'] == 1) {	echo 'checked'; } ?>> Check the option to show graph on main dashboard</label>
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
					<div class="dashboard-widget-content">
						<div class="x_content">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active"><a href="#leadActivity" id="leadActivity-tab" role="tab" data-toggle="tab" aria-expanded="true">Lead Activity</a></li>
									<?php if ($accountGraphPermission  == 1) {
										echo '<li role="presentation" class=""><a href="#accountActivity" role="tab" id="accountActivity-tab" data-toggle="tab" aria-expanded="false">Accounts Activity</a></li>';
									}
									if ($saleOrderGraphPermission  == 1) {
										echo '<li role="presentation" class=""><a href="#saleOrderActivity" role="tab" id="saleOrderActivity-tab" data-toggle="tab" aria-expanded="false">Sale Order  Activity</a></li>';
									} ?>
								</ul>
								<div id="myTabContent" class="tab-content"  style="padding: 0px;">
									<div role="tabpanel" class="tab-pane fade active in" id="leadActivity" aria-labelledby="leadActivity-tab">
										<ul class="list-unstyled timeline widget leadDashboardActivity"> </ul>
									</div>
									<?php if ($accountGraphPermission  == 1) {
										echo '<div role="tabpanel" class="tab-pane fade" id="accountActivity" aria-labelledby="accountActivity-tab">
										<ul class="list-unstyled timeline widget accountDashboardActivity"></ul>
									</div>';
									}
									if ($saleOrderGraphPermission  == 1) {
										echo '<div role="tabpanel" class="tab-pane fade" id="saleOrderActivity" aria-labelledby="saleOrderActivity-tab">
											<ul class="list-unstyled timeline widget saleOrderDashboardActivity"></ul>
										</div>';
									} ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="x_content">
		<div class="dash-tab" role="tabpanel" data-example-id="togglable-tabs">
			<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class="active"><a href="#leads" id="leads-tab" role="tab" data-toggle="tab" aria-expanded="true">Leads</a></li>
				<?php if ($contactGraphPermission  == 1) {
					echo '<li role="presentation" class=""><a href="#contacts" role="tab" id="contacts-tab" data-toggle="tab" aria-expanded="false">Contacts</a></li>';
				}
				if ($accountGraphPermission  == 1) {
					echo '<li role="presentation" class=""><a href="#accounts" role="tab" id="accounts-tab" data-toggle="tab" aria-expanded="false">Accounts</a></li>';
				}
				if ($saleOrderGraphPermission  == 1) {
					echo '<li role="presentation" class=""><a href="#sale_orders" role="tab" id="sale_orders-tab" data-toggle="tab" aria-expanded="false">Sale Orders</a></li>';
				} ?>
			</ul>
			<div id="myTabContent" class="tab-content" style="padding:0px;">
				<div role="tabpanel" class="tab-pane fade active in" id="leads" aria-labelledby="leads-tab">
					<table id="datatable-buttons" class="table  table-bordered user_index table-responsive" style="width:100%;" data-id="user">
						<thead>
							<tr>
								<th>Id</th>
								<th>Company</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone No.</th>
								<th>Lead Owner</th>
								<th>Lead Head / Created By </th>
								<th>Lead Status</th>
								<th>Status Comment</th>
							</tr>
						</thead>
						<tbody>
						<?php if (!empty($leads)) {
									foreach ($leads as $lead) {
										$primaryContact = array();
										if (!empty($lead) && $lead['lead_status'] != '' && $lead['lead_status'] != 0) {
											$lead_status = getNameById('lead_status', $lead['lead_status'], 'id');
											$leadStatus = $lead_status->name;
										}
										if ($lead['contacts'] != '') {
											$contacts_info = json_decode($lead['contacts']);
											$primaryContact	 = $contacts_info[0];
										}
										echo "<tr>
												<td>" . $lead['id'] . "</td>
												<td>" . $lead['company'] . "</td>
												<td>";
													if (!empty($primaryContact)) {
														echo $primaryContact->first_name . " " . $primaryContact->last_name;
													} else {
														echo '';
													}
												echo "</td>
												<td>";
													if (!empty($primaryContact)) {
														echo $primaryContact->email;
													} else {
														echo '';
													}
												echo "</td>
												<td>";
													if (!empty($primaryContact)) {
														echo $primaryContact->phone_no;
													} else {
														echo '';
													}
												echo "</td>
												<td>" . $lead['leadOwnerName'] . "</td>
												<td>" . $lead['createdByName'] . "</td>
												<td>" . $leadStatus . "</td>	
												<td>" . $lead['status_comment'] . "</td>
											</tr>";
									}
							} ?>
						</tbody>
					</table>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="contacts" aria-labelledby="contacts-tab">
					<table id="datatable-buttons" class="table table-bordered account_index table-responsive" style="width:100%" data-id="account">
						<thead>
							<tr>
								<th>Id</th>
								<th>Contact Name</th>
								<th>Account Name</th>
								<th>Phone</th>
								<th>Email</th>
								<th>Created Date</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($contacts)) {
									foreach ($contacts as $contact) {
										$accountName = ($contact['account_id'] != 0) ? (getNameById('account', $contact['account_id'], 'id')) : '';
										if (!empty($accountName)) {
											$name = $accountName->name;
										} else {
											$name = $contact['company'];
										}
										echo "<tr>
											<td>" . $contact['id'] . "</td>
											<td>" . $contact['first_name'] . " " . $contact['last_name'] . "</td>
											<td>" . $name . "</td>
											<td>" . $contact['phone'] . "</td>
											<td>" . $contact['email'] . "</td>
											<td>" . $contact['created_date'] . "</td>						
									   </tr>";
									}
								} ?>
						</tbody>
					</table>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="accounts" aria-labelledby="accounts-tab">
					<table id="datatable-buttons" class="table table-bordered account_index table-responsive" style="width:100%" data-id="account">
						<thead>
							<tr>
								<th>Id</th>
								<th>Account Name</th>
								<th>Phone</th>
								<th>Created By</th>
								<th>Created Date</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($accounts)) {
								foreach ($accounts as $account) {
									$accountData = ($account['created_by'] != 0) ? (getNameById('user_detail', $account['created_by'], 'u_id')) : '';
									if (!empty($accountData)) {
										$accountName = $accountData->name;
									} else {
										$accountName = '';
									}
									echo "<tr>
											<td>" . $account['id'] . "</td>
											<td>" . $account['name'] . "</td>
											<td>" . $account['phone'] . "</td>
											<td>" . $accountName . "</td>
											<td>" . $account['created_date'] . "</td>	
									   </tr>";
								}
							} ?>
						</tbody>
					</table>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="sale_orders" aria-labelledby="sale_orders-tab">
					<table id="datatable-buttons" style="width:100%" class="table table-responsive table-bordered sale_order_index" data-id="account">
						<thead>
							<tr>
								<th>Id</th>
								<th>Account Name</th>
								<th>Contact Name</th>
								<th>Product</th>
								<th>Order Date</th>
								<th>Dispatch Date</th>
								<th>Payment Terms</th>
								<th>Validate</th>
								<th>Created By</th>
								<th>Created Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>					
						   <?php if(!empty($sale_orders)){
										foreach($sale_orders as $sale_order){ 								  
											$accountName = ($sale_order['account_id']!=0)?(getNameById('account',$sale_order['account_id'],'id')):'';
											if(!empty($accountName)){
												$accountName = $accountName->name;
											}else{
												$accountName = '';
											}
											$contactName = ($sale_order['contact_id']!=0)?(getNameById('contacts',$sale_order['contact_id'],'id')):'';
											if(!empty($contactName)){
												$contactName = $contactName->first_name.' '.$contactName->last_name;
											}else{
												$contactName = '';
											}									
											$validatedBy = ($sale_order['validated_by']!=0)?(getNameById('user_detail',$sale_order['validated_by'],'id')):'';
											if(!empty($validatedBy)){
												$validatedByName = $validatedBy->name;
											}else{
												$validatedByName = '';
											}
											$selectApprove = $sale_order['approve']==1?'checked':'';
											$selectDisapprove = $sale_order['disapprove']==1?'checked':'';
											$draftImage = '';
											if($sale_order['save_status'] == 0)
											$draftImage = '<img src="'.base_url(). 'assets/images/draft.png" width="25%">';
											echo "<tr>
												<td class='sale_order_id' >". $draftImage . $sale_order['id']."</td>
												<td>".$accountName."</td>
												<td>".$contactName."</td>
												<td>";?>										
													<table id="datatable-buttons" style="width:100%" class="table table-responsive  table-bordered product_index bulk_action" data-id="user">
														<thead>
															<tr>
																<th>Product Name</th>
																<th>Quantity</th>
																<th>UOM</th>
																<th>Price</th>								
																<th>GST</th>								
																<th>Sub Total</th>								
																<th>Total</th>								
															</tr>
														</thead>													
														<?php	if($sale_order['product'] !=''){
																	$products=json_decode($sale_order['product']);
																	$createdByData = getNameById('user_detail',$sale_order['created_by'],'u_id');
																	if(!empty($createdByData)){
																		$createdByName = $createdByData->name;
																	}else{
																		$createdByName = '';
																	}															
																	foreach($products as $product){
																		$productDetail = getNameById('material',$product->product,'id');
																		$materialName = !empty($productDetail)?$productDetail->material_name:'';
																			echo "<tr>
																				<td>".$materialName."</td>
																				<td>".$product->quantity."</td>
																				<td>".$product->uom."</td>
																				<td>".$product->price."</td>
																				<td>".$product->gst."</td>
																				<td>".$product->individualTotal."</td>
																				<td>".$product->individualTotalWithGst."</td>
																			</tr>";
																	} 
																}
																echo "<tr><td colspan='7'>Total : ".$sale_order['total']."</td></tr>
																		<tr><td colspan='7'>Grand Total : ".$sale_order['grandTotal']."</td></tr>";
																echo "</table></td>
																		<td>".$sale_order['order_date']."</td>
																		<td>".$sale_order['dispatch_date']."</td>	
																		<td>".$sale_order['payment_terms']."</td>	
																		<td><p>
																	Approve:
																	<input type='radio' class='validate' name='gender_".$sale_order['id']."' value='Approve'/ ".$selectApprove."> Disapprove:
																	<input type='radio' class='disapprove' name='gender_".$sale_order['id']."' value='Disapprove'/ ".$selectDisapprove.">
																  </p><p class='disapprove_reason'>".$sale_order['disapprove_reason']."</p><p class='validatedBy'>Validated By: ".$validatedByName."</p></td>	
															<td>aaa</td>	
															<td>".$sale_order['created_date']."</td>	
															<td></td>	
														</tr>";
										}
									} ?>
						</tbody>                   
					</table>
				</div>
			</div>
		</div>
	</div>-->
</div>