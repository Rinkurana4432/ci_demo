
<?php  

	if(!empty($user_dashboard)){
		$production_data_month_wise_key = array_search('production_data_month_wise', array_column($user_dashboard, 'graph_id'));
		$production_planning_month_wise_key = array_search('production_planning_month_wise', array_column($user_dashboard, 'graph_id'));
		$production_data_planning_month_wise_key = array_search('production_data_planning_month_wise', array_column($user_dashboard, 'graph_id'));		
	}
?>
<div class="row dashboard-main">
  <div class="col-md-12  export_div">
	<div class="col-md-2 col-xs-12 col-sm-6 datePick-right">
		<fieldset>
			<div class="control-group col-md-10">
			  <div class="controls">
				<div class="input-prepend input-group">
				  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
				  <input type="text" style="width: 200px; padding: 4px;" class="dashboardFilter form-control" class="form-control" value="" data-filter-id="dashboardInventory" />
				</div>
			  </div>
			</div>
		</fieldset>
	</div>
 </div>
		<div class="row top_tiles col-md-12 col-sm-12 col-xs-12">
			<?php //if(!empty($work_order)){
			$tot_ava_mat = $tot_pro_out = $tot_wo_out = 0;
			$where_pset = array(
			'date' => date("d-m-Y")
			);
			$production_planning = $this->production_model->get_data('production_planning', $where_pset);
			$today_output = 0;
			foreach ($production_planning as $p_key => $data_val) {
			$decode_data = json_decode($data_val['planning_data'], true);
			foreach ($decode_data as $key => $data_chk) {
			$job_card = $data_chk['job_card_product_id'][0];
      $jobCardData = getNameById('job_card',$job_card,'id');
      $final_process = json_decode($jobCardData->final_process, true);
      $machine_details = json_decode($jobCardData->machine_details);
      foreach ($machine_details as $key_mac => $machine_details_data) {
			if($final_process[$machine_details_data->processess] == "yes" && $machine_details_data->processess == $data_chk['process_name'][0]){
			$pp_val = 0;
			foreach ($data_chk['output'] as $key_ot => $value) {
			foreach ($value as $key => $value1) {
			$pp_val +=  $value1;
			}
			}
			$today_output +=  $pp_val;
			}
			}
			}
			}
			foreach ($work_order as $key => $work_order_data) {
			$product_detail = json_decode($work_order_data['product_detail']);
			foreach ($product_detail as $p_key => $product_data) {
			$whereConditionJobCard  =  array('job_card_no' => $product_data->job_card,'material_id' => '');
			$jobCardDetails         =  $this->production_model->get_job_card_data('job_card','material_name_id', $whereConditionJobCard);
			if($jobCardDetails){
			$alljobcardqty[$jobCardDetails['id']]=$jobCardDetails;
			$alljobcardqty[$jobCardDetails['id']]['transfer_quantity'] = $product_data->transfer_quantity;
			$tot_wo_out += $product_data->transfer_quantity;
			}

			/**output Qty**/
			$job_card = $product_data->job_card;
            $jobCardData = getNameById('job_card',$job_card,'job_card_no');
            $machine_details = json_decode($jobCardData->machine_details);
            $out_qty = 0;
            foreach ($machine_details as $key_mac => $machine_details_data) {
            $output_process =   json_decode($machine_details_data->output_process,true);
            foreach($output_process as $output_process_info){
            $out_qty += $output_process_info['quantity_output'];
            }
            }
            $tot_pro_out += $out_qty;
			}	


			$status = $material_type = $material_name_detail = $available_quantity = $quantity_required = $reserved_quantity = $uom = "";
			$available_quantity_sum = 0;
			foreach($alljobcardqty as $jobkey => $materialInfo12){
			$jobCardMaterialss  = json_decode($materialInfo12['material_details'],true);
			//$cck = 1;
			//pre($jobCardMaterialss);
			foreach ($jobCardMaterialss as $key => $materialInfo) {
			//if($cck == 1){
			$newQuantityValuert = ($materialInfo12['lot_qty'] != 0 ) ? $materialInfo['quantity'] / $materialInfo12['lot_qty'] : 0;
			$newQuantityValue= $newQuantityValuert * $materialInfo12['transfer_quantity'];
			$expectedQuantity = ( $newQuantityValue > 0) ? $materialInfo['quantity'] * $newQuantityValue : $materialInfo['quantity'];
			$where = "reserved_material.mayerial_id = '".$materialInfo['material_name_id']."' AND reserved_material.created_by_cid ='".$this->companyId."' AND reserved_material.work_order_id ='".$work_order_data['id']."' AND reserved_material.job_card_id =".$materialInfo12['id']; 
			$reservedData = $this->production_model->get_data_single('reserved_material', $where);
			$reserved_quantitym = $reservedData ? $reservedData['quantity'] : 0;
			$yu = getNameById_mat('mat_locations',$materialInfo['material_name_id'],'material_name_id');
			$sum = 0;
			//pre($yu);
			if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
			$uom = !empty($ww)?$ww->uom_quantity:'N/A';
			$quantity_required = round($newQuantityValue,2);
			$reserved_quantity = $reserved_quantitym;
			$available_quantity = $sum - $reserved_quantitym;
			$available_quantity_sum += $available_quantity;
			//}
			//$cck++;
			}
			}
			$tot_ava_mat += $available_quantity_sum;
			}
			
			 ?>
			<div class="animated flipInY col-lg-3 col-md-2 col-sm-6 col-xs-12">
				<div class="tile-stats">
					<div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
					<div class="count"><?php echo count($work_order); ?></div>
					<p>Total Work Order</p>
				</div>
			</div>
			<?php /*
			<div class="animated flipInY col-lg-3 col-md-2 col-sm-6 col-xs-12">
				<div class="tile-stats">
					<div class="icon"><i class="fa fa-bank"></i></div>
					<div class="count"><?php echo $tot_ava_mat; ?></div>
					<p>Total Available Quantity</p>
				</div>
			</div> */ ?>
		<div class="animated flipInY col-lg-3 col-md-2 col-sm-6 col-xs-12">
				<div class="tile-stats">
					<div class="icon"><i class="fa fa-area-chart"></i></div>
					<div class="count"><?php echo $tot_wo_out;

					// $tot_pro_out; 

				?></div>
					<p>Fans Output From Work Order</p>
				</div>
			</div>
		<div class="animated flipInY col-lg-3 col-md-2 col-sm-6 col-xs-12">
				<div class="tile-stats">
					<div class="icon"><i class="fa fa-bank" style="color: #008000;"></i></div>
					<div class="count"><?php echo $today_output; ?></div>
					<p>Today Total Fan Output</p>
				</div>
			</div>
		<?php //} ?>
		</div>
	<!-- bar charts group -->

		<?php /*
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Month wise Production Data<small></small></h2>
						<ul class="nav navbar-right panel_toolbox">
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="checkbox">
									<label><input type="checkbox" id="production_data_month_wise" class="graphCheckbox"  <?php if( isset($production_data_month_wise_key) && $user_dashboard[$production_data_month_wise_key]['graph_id'] == 'production_data_month_wise' && $user_dashboard[$production_data_month_wise_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
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
				  <div id="graph_Indent" style="width:100%; height:300px;" ></div>
                </div>
            </div>
        </div>
              <!-- /bar charts group -->
		
		<!-- bar charts group -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Month wise Production planning<small></small></h2>
						<ul class="nav navbar-right panel_toolbox">
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="checkbox">
									<label><input type="checkbox" id="production_planning_month_wise" class="graphCheckbox"  <?php if( isset($production_planning_month_wise_key) && $user_dashboard[$production_planning_month_wise_key]['graph_id'] == 'production_planning_month_wise' && $user_dashboard[$production_planning_month_wise_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
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
				  <div id="graph_Indent1" style="width:100%; height:300px;" ></div>
                </div>
            </div>
        </div>
        */ ?>
              <!-- /bar charts group -->
		 <!-- graph area 
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Production  <small>VS Planning</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
						<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="checkbox">
									<label><input type="checkbox" id="production_data_planning_month_wise" class="graphCheckbox"  <?php //if( isset($production_data_planning_month_wise_key) && $user_dashboard[$production_data_planning_month_wise_key]['graph_id'] == 'production_data_planning_month_wise' && $user_dashboard[$production_data_planning_month_wise_key]['show'] == 1){ echo 'checked' ; } ?>> Check the option to show graph on main dashboard</label>
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
                    <div id="graph_area1" style="width:100%; height:300px;"></div>
                  </div>
                </div>
              </div>
              <!-- /graph area -->
		
</div>