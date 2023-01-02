<?php

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

?>

<div class="col-md-12 item form-group offset-md-8" >
		<input type="hidden" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="login_user_id">
		
		<p class="text-muted font-13 m-b-30"></p>  

			<center id="messagee" style="color:green;"></center>
	 <div id="print_div_content">
<!-- <form class="form-search" method="post" action="<?= base_url() ?>inventory/mrp">
	<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,Name" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="inventory/mrp">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
						<a href="<?php echo base_url(); ?>inventory/mrp"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
					
				</div>
</div>
			</form>	 -->
				<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>inventory/mrp">
			<input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			</form>
			
            <!----------- datatable-buttons ------------->
		<table id="example084" class="table table-striped table-bordered action-icons"  style="width:100%" border="1" cellpadding="3">
			<thead>
				<tr>
					<!-- <th><input type="checkbox" name="select_all[]" value="1" id="ProductionReportDataTable-select-all"  class="flat" ></th> -->
					<th>S.No.</th>
					<th>Material Name</th>
					<th>UOM</th>
					<th>In Stock</th>
					<th>Required</th>
					<th>Total Order</th>
					<!-- <th>Action</th> -->
				</tr>
			</thead>
			<tbody>
			
				<?php
				if(!empty($work_ordr)){
					#pre($mrpdtl);
					#pre($work_ordr);
				$product_detll = array();
				#$branch = array();
					foreach($work_ordr as $workordr){
						#pre($workordr);
						#$branch[] = $sale_orders['company_unit'];
						$prdt_dtl = $workordr['product_detail'];
						$new_product_Data = json_decode($prdt_dtl,true);
						#pre($prdt_dtl);

						#pre($new_product_Data);
						
						if($new_product_Data !=''){
							foreach($new_product_Data as $data_prdt){
								
								$product_detll[] = $data_prdt;
							}
						}
					}
					#echo "main_data".pre($product_detll);
					
					function product_id_exists($product_detll, $array) {
							$result = -1;
							for($i=0; $i<sizeof($array); $i++) {
								if ($array[$i]['product'] == $product_detll) {
									$result = $i;
									break;
								}
							}
							return $result;
						}
					$mat_details = array();
						foreach($product_detll as $bank) {
							$index = product_id_exists($bank['product'], $mat_details);
							if ($index < 0) {
								$mat_details[] = $bank;
							}
							else {
								@$mat_details[$index]['transfer_quantity'] +=  $bank['transfer_quantity'];
							}
						}
						#echo "trsnfqntydtd".pre($mat_details);
						$sno= 1;
						foreach($mat_details as $ttl_dtl){	
							$uom = getNameById('uom',$ttl_dtl['uom'],'id');
							$uom_name = !empty($uom)?$uom:'';
						    $mat_total_detail = get_mat_data('material',$ttl_dtl['product'],'id');
						    #pre($mat_total_detail);
								if(!empty($mat_total_detail)){
									$job_card_data = getNameById('job_card',$mat_total_detail->job_card,'id');

									#pre($job_card_data);

									//$lot_quantity = json_decode($job_card_data->material_details);
									if(!empty($job_card_data)){
										$lot_quantity = json_decode($job_card_data->material_details);
										foreach($lot_quantity as $mat_Data){
											$materl = getNameById('material',$mat_Data->material_name_id,'id');
												$B = $job_card_data->lot_qty; // job card lot qty
												#pre($ttl_dtl);
												$A = @$ttl_dtl['transfer_quantity'];//sale order
												$RM = $mat_Data->quantity;
												#pre($A);
												#pre($B);
												#pre($RM);

												#die;
												 // Required Quantity
												if($B != 0 && $B != NULL){
												$rquried_mat = ($A / $B) * $RM;
												}
												$total_order = $rquried_mat - $mat_total_detail->closing_balance;
												if($total_order > 0){



										?>	
										<tr class="row_selectd">
											<!-- <td><input type="checkbox" name="select_all1[]" value="<?php  echo $sno; ?>" id="ProductionReportDataTable-select-all"  class="workOrderIDscheckbox" ></td> -->
											<td><?php  echo $sno; ?></td>
											<td><?php echo @$materl->material_name; ?></td>
											<td><?php echo @$uom_name->uom_quantity; ?></td>
											<td><?php echo $mat_total_detail->closing_balance; ?></td>
											<td><?php echo round($rquried_mat); ?></td>
											<?php $total_order = $rquried_mat - $mat_total_detail->closing_balance;
													if ( $total_order > 0 ) { //Check order is in minus or in Plus
														$total_order2 = $total_order;
														} elseif( $total_order < 0 ) {
														$total_order2 = 0;	
													  }
											?>
											<input type="hidden" value="<?php echo $materl->id; ?>" id="mat_idd" name="mat_idd[<?php  echo $sno; ?>][]">
											<input type="hidden" value="<?php echo round($total_order2,2); ?>" id="totl_ordr" name="totl_ordr[<?php  echo $sno; ?>][]">
											<input type="hidden" value="<?php if(!empty($uom_name->id)) {echo $uom_name->id;}?>" id="uom_selected_id" name="uom_selected_id[<?php  echo $sno; ?>][]">
											


											<td><?php echo round($total_order2); ?></td>
											<?php
													// if ( $total_order > 0 ) {
													// 	echo '<td><button  data-tooltip="Convert into PI" class="btn  btn-xs  indent inventory_tabs_click" data-id="convert_to_pi_through_mrp"><img src="'.base_url().'assets/modules/crm/uploads/convert.png"></button></td>';
													// 	} elseif( $total_order < 0 ) {
													// 	echo '<td><button  disabled class="btn  btn-xs indent" ><img src="'.base_url().'assets/modules/crm/uploads/convert.png"></button></td>';
													//   }

											?>
										
										</tr>
									<?php
									$sno++;	
									}
									}
								}
						}
				}
						
						
				//echo '<div class="createPO"><button  data-tooltip="Convert into PI" class="btn  btn-xs convert indent inventory_tabs active" data-id="convert_to_pi_through_mrp"><img src="http://busybanda.com/assets/modules/crm/uploads/convert.png"></button></div>';
					
			} 
			?>
				</tbody>  
              		
			</table>
		<?php #echo $this->pagination->create_links(); ?>	
	</div>
</div>
<div id="inventory_add_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content" style="display:table;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Convert To PI Through MRP</h4>
			</div>
			<div class="modal-body-content" ></div>
		</div>
	</div>
</div>