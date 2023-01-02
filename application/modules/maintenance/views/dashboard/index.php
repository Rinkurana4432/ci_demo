<?php  
   if(!empty($user_dashboard)){
   	$production_data_month_wise_key = array_search('production_data_month_wise', array_column($user_dashboard, 'graph_id'));
   	$production_planning_month_wise_key = array_search('production_planning_month_wise', array_column($user_dashboard, 'graph_id'));
   	$production_data_planning_month_wise_key = array_search('production_data_planning_month_wise', array_column($user_dashboard, 'graph_id'));		
   }
   ?>
   
<div class="row">
   <div class="col-md-12 datePick">
      Select Month Range
      <fieldset>
         <div class="control-group">
            <div class="controls">
               <div class="input-prepend input-group">
                  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                  <input type="text" style="width: 200px" class="dashboardFilter" class="form-control" value="" data-filter-id="dashboardInventory" />
               </div>
            </div>
         </div>
      </fieldset>
   </div>
   <div class="row top_tiles"></div>
   <div class="col-md-6 col-sm-6  ">
      <div class="x_panel">
         <div class="x_title">
            <h2>BreakDown <small>Taget Vs Actual</small></h2>
            <ul class="nav navbar-right panel_toolbox">
               <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                     <a class="dropdown-item" href="#">Settings 1</a>
                     <a class="dropdown-item" href="#">Settings 2</a>
                  </div>
               </li>
               <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
         </div>
         <div class="x_content">
            <iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
            <canvas id="myChart" width="765" height="382" style="width: 765px; height: 382px;"></canvas>
         </div>
      </div>
   </div>  
   <div class="col-md-6 col-sm-6  ">
      <div class="x_panel">
         <div class="x_title">
            <h2>BreakDown <small>BreakDown Purchanse Graph</small></h2>
            <ul class="nav navbar-right panel_toolbox">
               <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                     <a class="dropdown-item" href="#">Settings 1</a>
                     <a class="dropdown-item" href="#">Settings 2</a>
                  </div>
               </li>
               <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
         </div>
         <div class="x_content">
            <iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
            <canvas id="BreakDownPurchase" width="765" height="382" style="width: 765px; height: 382px;"></canvas>
         </div>
      </div>
   </div>
</div>
<script>

window.onload = function() {
    getDashboardCount();
    getPoductionDataListingGraph();
    getBreakDownTargetVSActualListingGraph();
    getBreakDownPurchanseGraph();
}; 
</script>