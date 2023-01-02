<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/" enctype="multipart/form-data" id="supplierForm" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php //if(!empty($purchase_data)){ echo $purchase_data->id;} ?>">
   <div class="col-md-12 col-sm-12 col-xs-12">
      <table id="datatable-buttons" class="table table-striped table-bordered" data-id="account">
         <thead>
			<tr>
				<th>S.no</th>
				<th>Unit Of Measurement</th>
				<th>Total WorkOrder Quantity</th>
				<th>Complete WorkOrder Quantity</th>
				<!--<th>Pending WorkOrder Quantity</th>-->
            </tr>
         </thead>
         <tbody>
            <?php  // pre($production_report->workorder_ids);die;
				$workorder_ids =json_decode($production_report->workorder_ids,true);
                if(!empty($workorder_ids)){
					$qty_count = array();
					$actualOutput_array = array();
				   foreach ($workorder_ids as $val) {
					   $qty_count = getWorkOrderTotalQty('work_order',$val,'id');
					   $finishgoods_data = get_finishgoods_data($val);
						 if(!empty($finishgoods_data)){
							 foreach($finishgoods_data as $pro_data){
								$job_card_detail =json_decode($pro_data->job_card_detail,true);
								foreach($job_card_detail as $work_Order){	
									$actualOutput_array[$work_Order['uom']][] = $work_Order['output'];
								}
							 }
						 }
					 
					   foreach($qty_count as $pro){
						   $array_qty[$pro->uom][] = $pro->transfer_quantity;
					   }
					}
					// pre($actualOutput_array);pre($array_qty);die;
					$sno = 1;
					foreach($array_qty as $key=>$val){
						$uomname = getNameById('uom',$key,'id');
						echo '<tr><td>'.$sno.'</td><td>'.$uomname->uom_quantity.'</td><td>'.array_sum($val).'</td><td>'.array_sum($actualOutput_array[$key]).'</td></tr>';
						$sno++;
					}
				}
               ?>
         </tbody>
      </table>
   </div>
</form>