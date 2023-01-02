<?php  
	if(!empty($user_dashboard)){
		$accounts_income_expance_key = array_search('accounts_income_expance', array_column($user_dashboard, 'graph_id'));
		$accounts_cashflow_payment_done_received_key = array_search('accounts_cashflow_payment_done_received', array_column($user_dashboard, 'graph_id'));
		$accounts_material_sale_key = array_search('accounts_material_sale', array_column($user_dashboard, 'graph_id'));
	}
?>
<div class="row dashboard-main">

	<div class="col-md-12 export_div">
	   <div class="col-md-2 datePick-right">
		<fieldset>
			<div class="control-group">
			  <div class="controls">
				<div class="input-prepend input-group">
				  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
				  <input type="text" style="width: 200px" class="dashboardFilter form-control" class="form-control" value="" data-filter-id="dashboardLeadTargetSetAcheived" />
				</div>
			  </div>
			</div>
		</fieldset>
		</div>
	</div>
    <div class="row top_tiles col-md-12 col-sm-12 col-xs-12">	</div>
			
			
    <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Income Expense <small>Chart</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" id="accounts_income_expance" class="graphCheckbox" <?php if( isset($accounts_income_expance_key) && $user_dashboard[$accounts_income_expance_key]['graph_id'] == 'accounts_income_expance' && $user_dashboard[$accounts_income_expance_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
							</div>
						</div>
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
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Material <small>Sale</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" id="accounts_material_sale" class="graphCheckbox"  <?php if( isset($accounts_material_sale_key) && $user_dashboard[$accounts_material_sale_key]['graph_id'] == 'accounts_material_sale' && $user_dashboard[$accounts_material_sale_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
							</div>
						</div>
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


			  
			      <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cash Flow <small>Payment Done / Received</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" id="accounts_cashflow_payment_done_received" class="graphCheckbox"  <?php if( isset($accounts_cashflow_payment_done_received_key) && $user_dashboard[$accounts_cashflow_payment_done_received_key]['graph_id'] == 'accounts_cashflow_payment_done_received' && $user_dashboard[$accounts_cashflow_payment_done_received_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
							</div>
						</div>
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
	

  
</div>



