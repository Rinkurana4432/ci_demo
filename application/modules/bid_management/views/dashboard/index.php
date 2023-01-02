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
		<div class="col-md-2 datePick-right">
			<fieldset>
				<div class="control-group">
					<div class="controls col-md-3">
						<div class="input-prepend input-group">
							<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							<input type="text" style="padding: 4px;" class="dashboardFilter" class="form-control" value="" data-filter-id="dashboardLeadTargetSetAcheived" />
						</div>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="col-md-6 datePick-right"></div>
	</div>
	<div class="row top_tiles col-md-12 col-sm-12 col-xs-12"></div>
	<!-- pie chart 
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Bid <small>Status</small></h2>
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
	</div>-->
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_panel fixed_height_320">
			<div class="x_title">
				<h2>Month wise Bid <small>Status</small></h2>
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
				<h2>Total Bids Vs Success</h2>
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
				<h4>Successful Bids Vs Total Bids</h4>
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
	
	