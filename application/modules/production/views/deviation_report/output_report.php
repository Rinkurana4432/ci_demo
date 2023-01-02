<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/" enctype="multipart/form-data" id="supplierForm" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php //if(!empty($purchase_data)){ echo $purchase_data->id;} ?>">

   <div class="col-md-12 col-sm-12  ">
   <div class="x_panel">
      <div class="x_title">
         <h2><i class="fa fa-search"></i> Production Details</h2>
         <div class="clearfix"></div>
      </div>
      <div class="x_content">
         <div class="col-md-12 ">
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
				  <?php   if(!empty($work_order)){
								$getUnitName = getNameById('company_address',$work_order->company_branch_id,'compny_branch_id');
								echo $getUnitName->company_unit; 
						} ?>
                     
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12">Department</label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
				   <?php
							  if(!empty($work_order)){
								$departmentData = getNameById('department',$work_order->department_id,'id');
								if(!empty($departmentData)){
									echo $departmentData->name;
								}
							  }
							 ?>
 
                  </div>
               </div>
            </div>       
			<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12"> Work Order name</label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <?php echo $work_order->workorder_name;  ?>
                  </div>
               </div>
            </div> 
         </div>
      </div>
   </div>
</div>
   <div class="col-md-12 col-sm-12 col-xs-12">
      <table id="datatable-buttons" class="table table-striped table-bordered" data-id="account">
         <thead>
            <tr>
               <th>S.no</th>
               <th>Product Name</th>
               <th>BOM Rounting</th>
               <th>Required Quantity</th>        
			   <th>Complete</th>
               <th>Process  Output</th>
			   <th>Unit Of Measurement</th>
            </tr>
         </thead>
         <tbody>
		    <?php $product_detail =json_decode($work_order->product_detail,true); 
				 $production_data = get_production_data($work_order->id);
				 $finishgoods_data = get_finishgoods_data($work_order->id);
				// pre($finishgoods_data);
				$output_array = array();
				 if(!empty($production_data)){
					 foreach($production_data as $pro_data){
						$production_detail =json_decode($pro_data->production_data,true);
						foreach($production_detail as $workOrder){								 
							if($workOrder['work_order'][0] == $work_order->id){
								$output_array[$workOrder['party_code'][0]][$workOrder['process_name'][0]][] = $workOrder['output'][0];
							}
						}
					 }
				 }				
				 $actualOutput_array = array();
				 if(!empty($finishgoods_data)){
					 foreach($finishgoods_data as $pro_data){
						$job_card_detail =json_decode($pro_data->job_card_detail,true);
						foreach($job_card_detail as $workOrder){	
						
							if($workOrder['work_order_id'] == $work_order->id){
							//	pre($workOrder);
								$actualOutput_array[$workOrder['material_id']][] = $workOrder['output'];
							}
						}
					 }
				 }
				
			?>
            <?php  
                if(!empty($product_detail)){
					$qty_count = array();
					$sno = 1;
					foreach($product_detail as $val){
						$uomname = getNameById('uom',$val['uom'],'id');
						$bomRouting_detail = get_data_byId_fromMaterial('material','id',$val['product']);
						$productDetail = getNameById('material',$val['product'],'id');
						 $materialName = !empty($productDetail)?$productDetail->material_name:'';

						echo '<tr><td>'.$sno.'</td><td>'.$materialName.'</td><td>'.$val['job_card'].'</td><td>'.((!empty($val['transfer_quantity']))?$val['transfer_quantity']:'').'</td><td>'.array_sum($actualOutput_array[$val['product']]).'</td>'; ?>
						 <td>
						  <table id="datatable-buttons" style="width:100%" class="table  table-bordered product_index bulk_action" data-id="user" border="1" cellpadding="3">
							 <thead>
								<tr>
								   <th>Process</th> 
								   <th>Required</th> 
								   <th>Pending</th>
								   <th>completed</th>
								</tr>
							</thead>
						 <?php 
							$process = json_decode($bomRouting_detail->machine_details,true);
							$alotQty= $bomRouting_detail->lot_qty;
							$requiredQty = $val['transfer_quantity'];
							$process_qty=$compeleteQty = $pendingQty= 0;
							foreach($process as $proces){
								$per_process_output = json_decode($proces['output_process'],true);
								$outputsum = array_sum(array_column($per_process_output, 'quantity_output'));
                                $process_qty = round(($outputsum/$alotQty)*$requiredQty);
								$process_details = getNameById('add_process',$proces['processess'],'id');
								$compeleteQty = array_sum($output_array[$val['product']][$process_details->id]);
								$pendingQty = $process_qty - $compeleteQty ;
								echo "<tr><td>".$process_details->process_name."</td><td>".$process_qty."</td><td>". $pendingQty."</td><td>".$compeleteQty."</td>";
							}
							$process_details = getNameById('add_process',$proces['processess'],'id');?>
							  </table>
						   </td>
						<?php	echo '<td>'.$uomname->uom_quantity.'</td></tr>';
			
						$sno++;
					}
				}
               ?>
         </tbody>
      </table>
   </div>
</form>