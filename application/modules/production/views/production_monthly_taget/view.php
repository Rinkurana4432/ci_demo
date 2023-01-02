<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css" type="text/css" />
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }  //pre($production_report);die;?>
<script>		
   var logged_user = <?php echo $_SESSION['loggedInUser']->c_id; ?>;		
</script>

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
				  <?php   if(!empty($production_report)){
								$getUnitName = getNameById('company_address',$production_report->company_branch,'compny_branch_id');
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
							  if(!empty($production_report)){
								$departmentData = getNameById('department',$production_report->department_id,'id');
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
                  <label class="col-md-3 col-sm-12 col-xs-12">Month</label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <?php echo date("F ,Y", strtotime($production_report->month)); ?>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12">No of Work Order</label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <?php echo $production_report->workorder_count; ?>
                  </div>
               </div>
            </div>         
			<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12"> Total Qty</label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <?php echo '<button type="buttton" class="btn btn-info productionTab addBtn" id="'.$production_report->id.'" data-toggle="modal" data-id="ProductionReportQty">View Total Qty</button>'; ?>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>
<div id="result"></div>
<div class="x_content">
   <p class="text-muted font-13 m-b-30"></p>
      <div id="print_div_content" class="table-responsive" style="clear: both;">
         <table id="ProductionReportDataTable" class="table table-striped  table-bordered user_index display" border="1" cellpadding="3" style="width:100%">
            <thead>
               <tr class="headings">
                     <th></th>
					   <th>Id</th>  
					   <th>WorkOrder Name</th>
					   <th>Sale Order</th>
					   <th>Customer Name</th>
					   <th>Product</th>
					   <th>Expected Date</th>
					   <th>Created By </th>
					   <th>Created Date</th>
               </tr>
            </thead>
			 <tbody>
            <?php $workOrdersIds =json_decode($production_report->workorder_ids,true);

			if(!empty($workOrdersIds)){
               foreach($workOrdersIds as $workOrderId){
				$workOrder = getNameById('work_order',  $workOrderId,'id');
               $accountName = getNameById('account',$workOrder->customer_name_id,'id');
               ?>
            <tr>
               <td><?php echo $workOrder->priority_order; ?></td>
               <td><?php echo $workOrder->id; ?></td>       
               <td><?php echo '<a href="javascript:void(0)" id="'.$workOrder->id.'" data-id="work_order_view" class="productionTab btn btn-warning btn-xs" > '.$workOrder->workorder_name.' </a>'; ?></td>
			   <td><a href="javascript:void(0)" id="<?php echo $workOrder->sale_order_id; ?>" data-id="dispatched_order_view" data-tooltip="View" class="productionTab btn btn-view btn-xs"><?php echo $workOrder->sale_order_no; ?></a></td>
               <td><?php if(!empty($accountName->name)){ echo $accountName->name; }else{ echo "";} ?></td>
               <td>
                  <table id="datatable-buttons" style="width:100%" class="table  table-bordered product_index bulk_action" data-id="user" border="1" cellpadding="3">
                     <thead>
                        <tr>
                           <th>Product Name</th>
                           <!--<th>Required Quantity</th>-->
                           <th>WorkOrder Qty</th>
                           <th>UOM</th>
                           <th>Job Card</th>
                        </tr>
                     </thead>
                     <?php 
                        if($workOrder->product_detail !=''){
                        	$products=json_decode($workOrder->product_detail);
                        	$createdByData = getNameById('user_detail',$workOrder->created_by,'u_id');
                        	if(!empty($createdByData)){
                        		$createdByName = $createdByData->name;
                        	}else{
                        	$createdByName = '';
                        	}
                        	
                        	foreach($products as $product){
                        	$productDetail = getNameById('material',$product->product,'id');
                        	$materialName = !empty($productDetail)?$productDetail->material_name:'';
                        	$ww =  getNameById('uom', $product->uom,'id');
                        		$uom = !empty($ww)?$ww->ugc_code:'';
                        		echo "<tr>
                        			<td><h5>".$materialName."</h5></td>
                        			<td>".((!empty($product->transfer_quantity))?$product->transfer_quantity:'')."</td>
                        			<td>".$uom."</td>
                        			<td>".$product->job_card."</td>
                        			
                        		</tr>";
                        	} 
                        }
                        echo "";
                        ?>
                  </table>
               </td>
               <td><?php echo date("j F , Y", strtotime($workOrder->expected_delivery_date)); ?></td>
               <td><?php echo $createdByName; ?></td>
               <td><?php echo date("j F , Y", strtotime($workOrder->created_date)); ?></td>
            </tr>
            <?php }} ?>
         </tbody>
         </table>
      </div>
      <div class="form-group col-md-12">
         <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="item form-group">
               <div class="col-md-8 col-sm-12 col-xs-12">
               </div>
            </div>
         </div>
      </div>
 
</div>

