<?php  
	/***************** Purchase Graph As per requirement start **************************/
	if(!empty($user_dashboard)){
		/* Purchase User Graph   */
		$purchase_graph_approve_disapprove_key = array_search('purchase_graph_approve_disapprove', array_column($user_dashboard, 'graph_id'));
		$purchase_graph_month_wise_approve_disapprove_key = array_search('purchase_graph_month_wise_approve_disapprove', array_column($user_dashboard, 'graph_id'));
		$purchase_graph_grn_star_rating_key = array_search('purchase_graph_grn_star_rating', array_column($user_dashboard, 'graph_id'));
		$purchase_graph_pi_to_po_key = array_search('purchase_graph_pi_to_po', array_column($user_dashboard, 'graph_id'));
		$purchase_graph_po_to_grn_key = array_search('purchase_graph_po_to_grn', array_column($user_dashboard, 'graph_id'));
		$purchase_graph_po_key = array_search('purchase_graph_po', array_column($user_dashboard, 'graph_id'));		
		$purchase_graph_pi_key = array_search('purchase_graph_pi', array_column($user_dashboard, 'graph_id'));		
		$purchase_graph_grn_key = array_search('purchase_graph_grn', array_column($user_dashboard, 'graph_id'));
		
		/* Production User Graph   */		
		$production_data_month_wise_key = array_search('production_data_month_wise', array_column($user_dashboard, 'graph_id'));
		$production_planning_month_wise_key = array_search('production_planning_month_wise', array_column($user_dashboard, 'graph_id'));
		$production_data_planning_month_wise_key = array_search('production_data_planning_month_wise', array_column($user_dashboard, 'graph_id'));	
		
		/* CRM User Graph   */
		$crm_graph_lead_status_key = array_search('crm_graph_lead_status', array_column($user_dashboard, 'graph_id'));
		$crm_graph_month_wise_lead_status_key = array_search('crm_graph_month_wise_lead_status', array_column($user_dashboard, 'graph_id'));
		$crm_graph_leads_vs_status_key = array_search('crm_graph_leads_vs_status', array_column($user_dashboard, 'graph_id'));
		$crm_graph_lead_target_vs_acheived_key = array_search('crm_graph_lead_target_vs_acheived', array_column($user_dashboard, 'graph_id'));
		$crm_graph_sale_order_key = array_search('crm_graph_sale_order', array_column($user_dashboard, 'graph_id'));
		$crm_graph_sale_order_approved_vs_disapproved_key = array_search('crm_graph_sale_order_approved_vs_disapproved', array_column($user_dashboard, 'graph_id'));
		$crm_graph_recent_activities_key = array_search('crm_graph_recent_activities', array_column($user_dashboard, 'graph_id'));
		
		
		/*******Account user graph  ******/		
		$accounts_income_expance_key = array_search('accounts_income_expance', array_column($user_dashboard, 'graph_id'));
		$accounts_cashflow_payment_done_received_key = array_search('accounts_cashflow_payment_done_received', array_column($user_dashboard, 'graph_id'));
		$accounts_material_sale_key = array_search('accounts_material_sale', array_column($user_dashboard, 'graph_id'));
		
		/*********** Inventory User Graph***************/
		$inventory_monthWise_listing_adjustment_key = array_search('inventory_monthWise_listing_adjustment', array_column($user_dashboard, 'graph_id'));
		$inventory_material_category_with_amount_key = array_search('inventory_material_category_with_amount', array_column($user_dashboard, 'graph_id'));
		$inventory_scrapped_material_type_key = array_search('inventory_scrapped_material_type', array_column($user_dashboard, 'graph_id'));
		$inventory_material_move_key = array_search('inventory_material_move', array_column($user_dashboard, 'graph_id'));
		$inventory_material_DoNotmove_key = array_search('inventory_material_DoNotmove', array_column($user_dashboard, 'graph_id'));
	}		
	?>
<div class="row dashboard-main">
  <div class="col-md-12  export_div">
		<div class="col-md-6 col-xs-12 col-sm-6 datePick-left">
			<fieldset>
				<div class="control-group">
					<div class="controls">
						<div class="input-prepend input-group">
							<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							<input type="text" style="width: 200px; padding: 4px;" class="dashboardFilter" class="form-control" value="" data-filter-id="dashboardLeadTargetSetAcheived" />
						</div>
					</div>
				</div>
			</fieldset>
		</div>
		
	</div>
	<?php /*<div class="row top_tiles"></div>		*/?>
	<!-- pie chart-->
	<div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($purchase_graph_approve_disapprove_key) && $user_dashboard[$purchase_graph_approve_disapprove_key]['graph_id'] == 'purchase_graph_approve_disapprove' && $user_dashboard[$purchase_graph_approve_disapprove_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="x_panel">
			<div class="x_title">
				<h2>Purchase Indent<small>Approve/Disapprove</small></h2>
				<ul class="nav navbar-right panel_toolbox">					
				  <li><a class="collapse-link collapsePieGraph"><i class="fa fa-chevron-up"></i></a></li>
				  <li><a class="close-link"><i class="fa fa-close"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content2"  id="indentApprove">
				<div id="graph_donut_PI" style="width:100%; height:300px;"></div>
				<div class="emptyIndentStatusDiv" style="width:100%; height:300px; display:none; text_align:center;"><h2>No Data Available</h2></div>
			</div>
		</div>
	</div>		
	<!-- bar charts group -->
	<div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($purchase_graph_month_wise_approve_disapprove_key) && $user_dashboard[$purchase_graph_month_wise_approve_disapprove_key]['graph_id'] == 'purchase_graph_month_wise_approve_disapprove' && $user_dashboard[$purchase_graph_month_wise_approve_disapprove_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?> >
		<div class="x_panel">
			<div class="x_title">
				<h2>Month wise Puchase Indent<small>Approve/Disapprove</small></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link collapseBarGraph"><i class="fa fa-chevron-up"></i></a></li>                   
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content2" id="monthWiseGraph">
				<div id="graph_Indent" style="width:100%; height:300px;" ></div>
				<div class="emptyPurchaseIndentDiv" style="width:100%; height:300px; display:none; text_align:center;"><h2>No Data Available</h2></div>
			</div>
		</div>
	</div>
	<!-- Progress Bar -->
	<div class="col-md-6 col-sm-4 col-xs-12" <?php if( isset($purchase_graph_grn_star_rating_key) && $user_dashboard[$purchase_graph_grn_star_rating_key]['graph_id'] == 'purchase_graph_grn_star_rating' && $user_dashboard[$purchase_graph_grn_star_rating_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="x_panel tile">
			<div class="x_title">
				<h2>MRN Star ratings</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                  
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>		
			<div class="mrnStarRatingDiv" style="width:100%; height:300px;"></div>
		</div>
	</div> <!--/progress bar-->
		<!-- pie chart-->
	<div class="col-md-3 col-sm-4 col-xs-12" <?php if( isset($purchase_graph_pi_to_po_key) && $user_dashboard[$purchase_graph_pi_to_po_key]['graph_id'] == 'purchase_graph_pi_to_po' && $user_dashboard[$purchase_graph_pi_to_po_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="x_panel main-dash" >
			<div class="x_title">
				<h2>Purchase Indent to Purchase Order</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                      
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<canvas id="pieChart_Indent"></canvas>
				<div class="emptyPiToPoDiv" style="width:100%; height:300px; display:none; text_align:center;"><h2>No Data Available</h2></div>
			</div>
		</div>
	</div> <!--/pie chart-->
	<!-- pie chart-->
	<div class="col-md-3 col-sm-4 col-xs-12" <?php if( isset($purchase_graph_po_to_grn_key) && $user_dashboard[$purchase_graph_po_to_grn_key]['graph_id'] == 'purchase_graph_po_to_grn' && $user_dashboard[$purchase_graph_po_to_grn_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="x_panel main-dash">
			<div class="x_title">
				<h2>Purchase Order to MRN</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                      
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<canvas id="pieChart_order"></canvas>
				<div class="emptyPoToMrnDiv" style="width:100%; height:300px; display:none; text_align:center;"><h2>No Data Available</h2></div>
			</div>
		</div>
	</div>
	<!--/pie chart-->
	<!--donut chart of purchase order-->
	<div class="col-md-12 col-sm-12 col-xs-12" <?php if( isset($purchase_graph_po_key) && $user_dashboard[$purchase_graph_po_key]['graph_id'] == 'purchase_graph_po' && $user_dashboard[$purchase_graph_po_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="x_panel tile overflow_hidden">
			<div class="x_title">
				<h2>Purchase Order </h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                   
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="col-sm-4 col-md-4 col-xs-12 po-bottom_m">
					<h2>Material </h2>
					<canvas class="canvasDoughnut_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
					<div class="emptyPoCountMaterialDiv" style="width:100%; height:300px; display:none; text_align:center;"><h2>No Data Available</h2></div>
				</div>
				<div class="col-sm-8 col-md-8 col-xs-12 po-bottom"  id="MaterialAmount"></div>
			</div>
		</div>
	</div>	
	<!--donut chart of purchase order-->
	<div class="col-md-12 col-sm-12 col-xs-12"  <?php if( isset($purchase_graph_pi_key) && $user_dashboard[$purchase_graph_pi_key]['graph_id'] == 'purchase_graph_pi' && $user_dashboard[$purchase_graph_pi_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="x_panel tile overflow_hidden">
			<div class="x_title">
				<h2>Purchase Indent </h2>
				<ul class="nav navbar-right panel_toolbox">				
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                   
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="col-sm-4 col-md-4 col-xs-12 po-bottom_m">
					<h2>Material </h2>						 
					<canvas class="pi_material_type_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
					<div class="emptyPICompleteCountMaterialDiv" style="width:100%; height:300px; display:none; text_align:center;"><h2>No Data Available</h2></div>
				</div>
				<div class="col-sm-8 col-md-8 col-xs-12 po-bottom"  id="completePiMaterialAmount">	</div>				
			</div>
		</div>
	</div>	
	<!--donut chart of MRN-->
	<div class="col-md-12 col-sm-12 col-xs-12" <?php if( isset($purchase_graph_grn_key) && $user_dashboard[$purchase_graph_grn_key]['graph_id'] == 'purchase_graph_grn' && $user_dashboard[$purchase_graph_grn_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
        <div class="x_panel tile overflow_hidden">
            <div class="x_title">
                <h2>Goods Receipt Note</h2>
                <ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                   
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
			<div class="x_content">
				<div class="col-sm-4 col-md-4 col-xs-12 po-bottom_m">
					<h2>Material </h2>						 
					<canvas class="mrn_material_type_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
					<div class="emptyMrnCompleteCountMaterialDiv" style="width:100%; height:300px; display:none; text_align:center;"><h2>No Data Available</h2></div>
				</div>
				<div class="col-sm-8 col-md-8 col-xs-12 po-bottom"  id="completeMRNMaterialAmount"></div>				
			</div>
        </div>
    </div>
	
	
	
	
	
	
	
	
	
 <?php   /**************  Production Graph Section start ****************/ ?>
 
 
 <div class="row">	
	<!-- bar charts group -->
        <div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($production_data_month_wise_key) && $user_dashboard[$production_data_month_wise_key]['graph_id'] == 'production_data_month_wise' && $user_dashboard[$production_data_month_wise_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
            <div class="x_panel">
                <div class="x_title">
                    <h2>Month wise Production Data<small></small></h2>
						<ul class="nav navbar-right panel_toolbox">							
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
				  <?php /*<div id="graph_Indent" style="width:100%; height:300px;" ></div> */?>
				  <div id="graph_month_wise_production_data" style="width:100%; height:300px;" ></div>
                </div>
            </div>
        </div>
              <!-- /bar charts group -->
		
		<!-- bar charts group -->
        <div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($production_planning_month_wise_key) && $user_dashboard[$production_planning_month_wise_key]['graph_id'] == 'production_planning_month_wise' && $user_dashboard[$production_planning_month_wise_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
            <div class="x_panel">
                <div class="x_title">
                    <h2>Month wise Production planning<small></small></h2>
						<ul class="nav navbar-right panel_toolbox">							
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
				  <div id="graph_Indent1" style="width:100%; height:300px;" ></div>
                </div>
            </div>
        </div>
              <!-- /bar charts group -->
		 <!-- graph area -->
              <div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($production_data_planning_month_wise_key) && $user_dashboard[$production_data_planning_month_wise_key]['graph_id'] == 'production_data_planning_month_wise' && $user_dashboard[$production_data_planning_month_wise_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Production  <small>VS Planning</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">							
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content2">
                    <div id="graph_area1" style="width:100%; height:300px;"></div>
                  </div>
                </div>
              </div>
              <!-- /graph area -->
		
</div>
 
 
 
 
 
 
 
 
 
 
 
 <?php   /**************  CRM Graph Section start ****************/ ?>
	<div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($crm_graph_lead_status_key) && $user_dashboard[$crm_graph_lead_status_key]['graph_id'] == 'crm_graph_lead_status' && $user_dashboard[$crm_graph_lead_status_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="x_panel">
			<div class="x_title">
				<h2>Lead <small>Status</small></h2>
				<ul class="nav navbar-right panel_toolbox">
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
	<div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($crm_graph_month_wise_lead_status_key) && $user_dashboard[$crm_graph_month_wise_lead_status_key]['graph_id'] == 'crm_graph_month_wise_lead_status' && $user_dashboard[$crm_graph_month_wise_lead_status_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="x_panel">
			<div class="x_title">
				<h2>Month wise Lead <small>Status</small></h2>
				<ul class="nav navbar-right panel_toolbox">
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
	<div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($crm_graph_leads_vs_status_key) && $user_dashboard[$crm_graph_leads_vs_status_key]['graph_id'] == 'crm_graph_leads_vs_status' && $user_dashboard[$crm_graph_leads_vs_status_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="x_panel tile fixed_height_320">
			<div class="x_title">
				<h2>Total Leads Vs Success</h2>
				<ul class="nav navbar-right panel_toolbox">
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
	<div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($crm_graph_lead_target_vs_acheived_key) && $user_dashboard[$crm_graph_lead_target_vs_acheived_key]['graph_id'] == 'crm_graph_lead_target_vs_acheived' && $user_dashboard[$crm_graph_lead_target_vs_acheived_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="x_panel fixed_height_320">
			<div class="x_title">
				<h2>Leads<small>Target Vs Acheived</small></h2>
				<ul class="nav navbar-right panel_toolbox">
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
		<div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($crm_graph_sale_order_key) && $user_dashboard[$crm_graph_sale_order_key]['graph_id'] == 'crm_graph_sale_order' && $user_dashboard[$crm_graph_sale_order_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
			<div class="x_panel">
				<div class="x_title">
					<h2>Sale <small>Order</small></h2>
					<ul class="nav navbar-right panel_toolbox">
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
		<div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($crm_graph_sale_order_approved_vs_disapproved_key) && $user_dashboard[$crm_graph_sale_order_approved_vs_disapproved_key]['graph_id'] == 'crm_graph_sale_order_approved_vs_disapproved' && $user_dashboard[$crm_graph_sale_order_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
			<div class="x_panel">
				<div class="x_title">
					<h2>Sale Order<small>Approved Vs Disapproved</small></h2>
					<ul class="nav navbar-right panel_toolbox">
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
	<div class="row" <?php if( isset($crm_graph_recent_activities_key) && $user_dashboard[$crm_graph_recent_activities_key]['graph_id'] == 'crm_graph_recent_activities' && $user_dashboard[$crm_graph_recent_activities_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Recent Activities <small>Sessions</small></h2>
					<ul class="nav navbar-right panel_toolbox">
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
								<div id="myTabContent" class="tab-content">
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

	
	<?php   /****************************        Accounts graph      *******************************/?>	
    <div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($accounts_income_expance_key) && $user_dashboard[$accounts_income_expance_key]['graph_id'] == 'accounts_income_expance' && $user_dashboard[$accounts_income_expance_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Income Expense <small>Chart</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content1">
                    <div id="graph_income_expanse" style="width:100%; height:280px;"></div>
                  </div>
                </div>
              </div>


			

              <!-- Material sale chart -->
              <div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($accounts_material_sale_key) && $user_dashboard[$accounts_material_sale_key]['graph_id'] == 'accounts_material_sale' && $user_dashboard[$accounts_material_sale_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Material <small>Sale</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content2">
                    <div id="graph_material_sale" style="width:100%; height:300px;"></div>
                  </div>
                </div>
              </div>


			  
			      <div class="col-md-6 col-sm-6 col-xs-12"  <?php if( isset($accounts_cashflow_payment_done_received_key) && $user_dashboard[$accounts_cashflow_payment_done_received_key]['graph_id'] == 'accounts_cashflow_payment_done_received' && $user_dashboard[$accounts_cashflow_payment_done_received_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cash Flow <small>Payment Done / Received</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content1">
                    <div id="graph_payment_received_done" style="width:100%; height:280px;"></div>
                  </div>
                </div>
              </div>




<?php /*********************Inventory Graph***************************/?>
<!-------------------------------------------------------- bar charts group ---------------------------------------------->
    <div class="col-md-12 col-sm-12 col-xs-12" <?php if( isset($inventory_monthWise_listing_adjustment_key) && $user_dashboard[$inventory_monthWise_listing_adjustment_key]['graph_id'] == 'inventory_monthWise_listing_adjustment' && $user_dashboard[$inventory_monthWise_listing_adjustment_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="x_panel">
			<div class="x_title">
				<h2>Month wise Inventory listing<small>adjustment</small></h2>
					<ul class="nav navbar-right panel_toolbox">
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
			  <div id="month_Wise_graph" style="width:100%; height:300px;" ></div>
			</div>
		</div>
    </div>
    <!-------------------------------------------/bar charts graph ------------------------------------------>
<!------------------------------------------ pie chart for category fo material --------------------------------------------->
	<div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($inventory_material_category_with_amount_key) && $user_dashboard[$inventory_material_category_with_amount_key]['graph_id'] == 'inventory_material_category_with_amount' && $user_dashboard[$inventory_material_category_with_amount_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="x_panel">
			<div class="x_title">
				<h2>Category of Material<small>Total Amount</small></h2>
					<ul class="nav navbar-right panel_toolbox">
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
				<div id="material_type_graph_donut"  style="width:100%; height:250px;"></div>
			</div>
		</div>
	</div>
    <!------------------------------------------------- /Pie chart --------------------------------------------------------->
	
	
		
	<!-------------------------------------------- Progress Bar fro scrapped data ------------------------------------------------------>
	<div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($inventory_scrapped_material_type_key) && $user_dashboard[$inventory_scrapped_material_type_key]['graph_id'] == 'inventory_scrapped_material_type' && $user_dashboard[$inventory_scrapped_material_type_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
        <div class="x_panel tile fixed_height_320" style="height:405px;">
            <div class="x_title">
                <h2>Scrapped  Material List</h2>
					<ul class="nav navbar-right panel_toolbox">
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
            <div class="x_content" id="scrappedDiv"></div>
		</div>
    </div>   
	<!----------------------------------------------------------/progress bar------------------------------------------------------>
	
	<!-----------------------------------------tbale to display material move---------------------------------------------------->
	<div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($inventory_material_move_key) && $user_dashboard[$inventory_material_move_key]['graph_id'] == 'inventory_material_move' && $user_dashboard[$inventory_material_move_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="x_panel tile fixed_height_320">
            <div class="x_title">
                <h2>Material movement</h2>
					<ul class="nav navbar-right panel_toolbox">
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
				<table  class="table table-striped " data-id="user" border="0" cellpadding="3">
					<thead>
					<tr>
						<th>Material</th>
						<th>Quantity</th>
						<th>Current Location</th>
					</tr>
					</thead>
					<tbody>
						<?php if(!empty($materialMove)){
								foreach($materialMove as $material_move){
								$material_id=getNameById('material',$material_move['material_name_id'],'id');
						?>
						<tr>
							<td><?php echo $material_id->material_name; ?></td>
							<td><?php echo $material_move['quantity']."--".$material_move['uom']; ?></td>
							<td>
								<table class="table table-striped">
									<thead>
									<tr>
										<th>Location</th>
										<th>Storage</th>
										<th>Rack Number</th>
									</tr>
									</thead>
									<?php $location = json_decode($material_move['location']);
											if(!empty($location)){
												foreach($location as $location_data){
													
													$location_name = getNameById('location_settings',$location_data->location,'id');
									?>
									<tbody>
									<tr>
										<td><?php if(!empty($location_name)){echo $location_name->location;} else{ echo "";}?></td>
										<td><?php echo $location_data->Storage;?></td>
										<td><?php echo $location_data->RackNumber;?></td>
									</tr><?php }} ?>
									</tbody>
								</table>
							</td>
						</tr>
						<?php }}?>
					</tbody>
				</table>
			</div>
		</div>
    </div>
		
	<!----------------------------------------------last three month -------------------------------------------------->
	<div class="col-md-6 col-sm-6 col-xs-12" <?php if( isset($inventory_material_DoNotmove_key) && $user_dashboard[$inventory_material_DoNotmove_key]['graph_id'] == 'inventory_material_DoNotmove' && $user_dashboard[$inventory_material_DoNotmove_key]['show'] == 1){ echo 'style="display:block;"' ; } else { echo 'style="display:none;"' ;} ?>>
		<div class="x_panel tile fixed_height_320">
			<div class="x_title">
				<h2>Last Three Month Data</h2>
				<ul class="nav navbar-right panel_toolbox">
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
				<table class="table table-striped">
					<thead>
						<tr>
						<th>Material Name</th>
						<th>Quantity</th>
						
						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($materialDonotMove)){
							foreach($materialDonotMove as  $mat_not_move){
							$material_name = getNameById('material',$mat_not_move['material_name_id'],'id');	
						?>
						<tr>
							<td><?php echo $material_name->material_name; ?></td>
							<td><?php echo $material_name->opening_balance; ?></td>
						</tr>
						<?php }} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	
</div>		
	