
<?php  
	if(!empty($user_dashboard)){
		$purchase_graph_approve_disapprove_key = array_search('purchase_graph_approve_disapprove', array_column($user_dashboard, 'graph_id'));
		$purchase_graph_month_wise_approve_disapprove_key = array_search('purchase_graph_month_wise_approve_disapprove', array_column($user_dashboard, 'graph_id'));
		$purchase_graph_grn_star_rating_key = array_search('purchase_graph_grn_star_rating', array_column($user_dashboard, 'graph_id'));
		$purchase_graph_pi_to_po_key = array_search('purchase_graph_pi_to_po', array_column($user_dashboard, 'graph_id'));
		$purchase_graph_po_to_grn_key = array_search('purchase_graph_po_to_grn', array_column($user_dashboard, 'graph_id'));
		$purchase_graph_po_key = array_search('purchase_graph_po', array_column($user_dashboard, 'graph_id'));		
		$purchase_graph_pi_key = array_search('purchase_graph_pi', array_column($user_dashboard, 'graph_id'));		
		$purchase_graph_grn_key = array_search('purchase_graph_grn', array_column($user_dashboard, 'graph_id'));		
	}
?>
<div class="row dashboard-main">
	<div class="col-md-12  export_div">
    <div class="col-md-2 col-xs-12 col-sm-6 datePick-right">	
		<fieldset>
			<div class="control-group col-md-10" style="float: right;">
				<div class="controls">
					<div class="input-prepend input-group">
						<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						<input type="text" style="width: 200px; padding: 4px;" class="dashboardFilter form-control"  value="" data-filter-id="dashboardLeadTargetSetAcheived" />
					</div>
				</div>
			</div>
		</fieldset>
    </div>
</div>
<div class="row top_tiles"></div>		
<!-- pie chart-->
<div class="col-md-6 col-sm-6 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Purchase Indent<small>Approve/Disapprove/Pending</small></h2>
			<ul class="nav navbar-right panel_toolbox">
				<div class="col-md-9 col-sm-9 col-xs-12">
					<div class="checkbox">
						<label><input type="checkbox" id="purchase_graph_approve_disapprove" class="graphCheckbox"  <?php if( isset($purchase_graph_approve_disapprove_key) && $user_dashboard[$purchase_graph_approve_disapprove_key]['graph_id'] == 'purchase_graph_approve_disapprove' && $user_dashboard[$purchase_graph_approve_disapprove_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
					</div>
				</div>
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
<div class="col-md-6 col-sm-6 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Month wise Puchase Indent<small>Approve/Disapprove</small></h2>
			<ul class="nav navbar-right panel_toolbox">
				<div class="col-md-9 col-sm-9 col-xs-12">
					<div class="checkbox">
						<label><input type="checkbox" id="purchase_graph_month_wise_approve_disapprove" class="graphCheckbox"  <?php if( isset($purchase_graph_month_wise_approve_disapprove_key) && $user_dashboard[$purchase_graph_month_wise_approve_disapprove_key]['graph_id'] == 'purchase_graph_month_wise_approve_disapprove' && $user_dashboard[$purchase_graph_month_wise_approve_disapprove_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
					</div>
				</div>
				<li><a class="collapse-link collapseBarGraph"><i class="fa fa-chevron-up"></i></a>
                    </li>                   
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
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
<div class="col-md-6 col-sm-4 col-xs-12">
	<div class="x_panel tile">
		<div class="x_title">
			<h2>GRN Star ratings</h2>
			<ul class="nav navbar-right panel_toolbox">
				<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="checkbox">
							<label><input type="checkbox" id="purchase_graph_grn_star_rating" class="graphCheckbox"  <?php if( isset($purchase_graph_grn_star_rating_key) && $user_dashboard[$purchase_graph_grn_star_rating_key]['graph_id'] == 'purchase_graph_grn_star_rating' && $user_dashboard[$purchase_graph_grn_star_rating_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
						</div>
				</div> 
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                  
				<li><a class="close-link"><i class="fa fa-close"></i></a></li>
			</ul>
			<div class="clearfix"></div>
		</div>
	
	<div class="mrnStarRatingDiv" style="width:100%; height:300px;"></div>
</div>
</div>   
<!--/progress bar-->
			
		<!-- pie chart-->
			 <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="x_panel main-dash" >
                  <div class="x_title">
                    <h2>Purchase Indent to Purchase Order</h2>
                    <ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" id="purchase_graph_pi_to_po" class="graphCheckbox"  <?php if( isset($purchase_graph_pi_to_po_key) && $user_dashboard[$purchase_graph_pi_to_po_key]['graph_id'] == 'purchase_graph_pi_to_po' && $user_dashboard[$purchase_graph_pi_to_po_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
							</div>
						</div> 
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <canvas id="pieChart_Indent"></canvas>
					<div class="emptyPiToPoDiv" style="width:100%; height:300px; display:none; text_align:center;"><h2>No Data Available</h2></div>
                  </div>
                </div>
              </div>
			  <!--/pie chart-->
		<!-- pie chart-->
			 <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="x_panel main-dash">
                  <div class="x_title">
                    <h2>Purchase Order to GRN</h2>
                    <ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" id="purchase_graph_po_to_grn" class="graphCheckbox"  <?php if( isset($purchase_graph_po_to_grn_key) && $user_dashboard[$purchase_graph_po_to_grn_key]['graph_id'] == 'purchase_graph_po_to_grn' && $user_dashboard[$purchase_graph_po_to_grn_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
							</div>
						</div> 
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
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
			<div class="col-md-6 col-sm-12 col-xs-12" style="clear:both;">
              <div class="x_panel tile overflow_hidden">
                <div class="x_title">
                  <h2>Purchase Order </h2>
                  <ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" id="purchase_graph_po" class="graphCheckbox"  <?php if( isset($purchase_graph_po) && $user_dashboard[$purchase_graph_po_key]['graph_id'] == 'purchase_graph_po' && $user_dashboard[$purchase_graph_po]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
							</div>
						</div> 
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>                   
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
				
				
				
				
                <div class="x_content">
					<div class="col-sm-4 col-md-4 col-xs-12 po-bottom_m">
						 <h2>Material </h2>
						 
						  <?php /*<canvas class="canvasDoughnut_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>*/?>
						    <div id="canvasDoughnut_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></div>
						<div class="emptyPoCountMaterialDiv" style="width:100%; height:300px; display:none; text_align:center;"><h2>No Data Available</h2></div>
						
					<canvas id="po_complete_incomplete_pie_chart"></canvas>
					<div class="emptyPOCompleteIncompleteDiv" style="width:100%; height:300px; display:none; text_align:center;"><h2>No Data Available</h2></div>
                  
				  
					</div>
					
					
					
					<div class="col-sm-8 col-md-8 col-xs-12 po-bottom"  id="MaterialAmount">
					
					</div>				
                
                </div>
				
				
				
				
				
              </div>
            </div>	


  	<!--donut chart of purchase order-->
			<div class="col-md-6 col-sm-12 col-xs-12"  >
              <div class="x_panel tile overflow_hidden">
                <div class="x_title">
                  <h2>Purchase Indent </h2>
                  <ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" id="purchase_graph_pi" class="graphCheckbox"  <?php if( isset($purchase_graph_pi_key) && $user_dashboard[$purchase_graph_pi_key]['graph_id'] == 'purchase_graph_pi' && $user_dashboard[$purchase_graph_pi_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
							</div>
						</div> 
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>                   
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content" style="height: 447px;">
					<div class="col-sm-4 col-md-4 col-xs-12 po-bottom_m">
						 <h2>Material </h2>						 
						 <?php /* <canvas class="pi_material_type_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>*/ ?>
						  <div id="pi_material_type_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></div>
						<div class="emptyPICompleteCountMaterialDiv" style="width:100%; height:300px; display:none; text_align:center;"><h2>No Data Available</h2></div>
						
						<canvas id="pi_complete_incomplete_pie_chart"></canvas>
						
					<div class="emptyPiCompleteIncompleteDiv" style="width:100%; height:300px; display:none; text_align:center;"><h2>No Data Available</h2></div>
                  
					</div>
					<div class="col-sm-8 col-md-8 col-xs-12 po-bottom"  id="completePiMaterialAmount">					
					</div>				
                </div>
              </div>
            </div>	


			
				<!--donut chart of MRN-->
	<div class="col-md-6 col-sm-12 col-xs-12" style="clear:both;">
        <div class="x_panel tile overflow_hidden">
            <div class="x_title">
                <h2>Goods Receipt Note</h2>
                <ul class="nav navbar-right panel_toolbox">
				<div class="col-md-9 col-sm-9 col-xs-12">
					<div class="checkbox">
						<label><input type="checkbox" id="purchase_graph_grn" class="graphCheckbox"  <?php if( isset($purchase_graph_grn_key) && $user_dashboard[$purchase_graph_grn_key]['graph_id'] == 'purchase_graph_grn' && $user_dashboard[$purchase_graph_grn_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
					</div>
				</div> 
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                   
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
			<div class="x_content">
				<div class="col-sm-4 col-md-4 col-xs-12 po-bottom_m">
					 <h2>Material </h2>						 
					  <?php /* <canvas class="mrn_material_type_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>*/?>
					   <div id="mrn_material_type_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></div>
					<div class="emptyMrnCompleteCountMaterialDiv" style="width:100%; height:300px; display:none; text_align:center;"><h2>No Data Available</h2></div>
					
					
                    <canvas id="mrn_complete_incomplete_pie_chart"></canvas>
					<div class="emptyMRNCompleteIncompleteDiv" style="width:100%; height:300px; display:none; text_align:center;"><h2>No Data Available</h2></div>
                  
					
					
					
				</div>
				<div class="col-sm-8 col-md-8 col-xs-12 po-bottom"  id="completeMRNMaterialAmount">					
				</div>				
			</div>
        </div>
	</div>
		
		
		
	