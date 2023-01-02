 <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/" enctype="multipart/form-data" id="supplierForm" novalidate="novalidate">
 <input type="hidden" name="id" value="<?php //if(!empty($purchase_data)){ echo $purchase_data->id;} ?>">
  <div class="col-md-12 col-sm-12 col-xs-12">				
   <table id="datatable-buttons" class="table table-striped table-bordered" data-id="account">
		<thead>
			<tr>
				<th>S.no</th>
				<th>Unit Of Measurement</th>
				<th>Total Quantity</th>
			</tr>
		</thead>
		<tbody>
		   <?php
		   // pre();
		   error_reporting(0);
		   if(!empty($qtty_dtls)){
			 
			   $uom_details = array();
			   foreach($qtty_dtls as $val){	
				    $goods_descr = json_decode($val['descr_of_goods'],true);
					foreach ($goods_descr as $val) {
						$uom_details[] =  $val;
 					}
			   }	
					
					function product_id_exists($uom_details, $array) {
							$result = -1;
							for($i=0; $i<sizeof($array); $i++) {
								if ($array[$i]['UOM'] == $uom_details) {
									$result = $i;
									break;
								}
							}
							return $result;
						}
					$mat_details = array();
						foreach($uom_details as $bank) {
							$index = product_id_exists($bank['UOM'], $mat_details);
							if ($index < 0) {
								$mat_details[] = $bank;
							}
							else {
								$mat_details[$index]['quantity_mat'] +=  $bank['quantity'];
							}
						}
						$sno = 1;
						foreach($mat_details as $dtls){
							$uomname = getNameById('uom',$dtls['UOM'],'id');
							echo '<tr><td>'.$sno.'</td><td>'.$uomname->uom_quantity.'</td><td>'.$dtls['quantity_mat'].'</td></tr>';
							$sno++;
						}
		   
			   }
		   ?>
		</tbody>                   
	</table>
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
			<div class="form-group">
				<div class="modal-footer">
					<button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>	
 </div>
</form>	
