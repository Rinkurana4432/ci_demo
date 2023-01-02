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
                    <?php echo '<button type="buttton" class="btn btn-info productionTab addBtn" id="'.$production_report->id.'" data-toggle="modal" data-id="ProductionMonthlyPlannedVsActualReportQty">View Total Qty</button>'; ?>
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
	  <div id="status"  class="alert alert-primary"  style="display: none;">WorkOrder Qty Updated</div>
         <table id="ProductionReportDataTable" class="table table-striped  table-bordered user_index display" border="1" cellpadding="3" style="width:100%">
            <thead>
               <tr class="headings">
                     <th></th>
					   <th>Id</th>  
					   <th>WorkOrder Name</th>
					   <th>Sale Order</th>
					   <th>Customer Name</th>
					   <th>Product</th>
					   <th>Output</th>
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
                          <th>S.no</th>
						   <th>Product Name</th>
						   <th>BOM Rounting</th>
						   <th>WorkOrder Quantity</th>        
						   <th>Complete</th>
						   <th>Process  Output</th>
						   <th>Unit Of Measurement</th>
                        </tr>
                     </thead>
                     <?php 
                        if($workOrder->product_detail !=''){
                        	$products=json_decode($workOrder->product_detail);
							$production_data = get_production_data($workOrder->id);
							$finishgoods_data = get_finishgoods_data($workOrder->id);

                        	$createdByData = getNameById('user_detail',$workOrder->created_by,'u_id');
                        	if(!empty($createdByData)){
                        		$createdByName = $createdByData->name;
                        	}else{
                        	$createdByName = '';
                        	}
                        	$output_array = array();
							 if(!empty($production_data)){
								 foreach($production_data as $pro_data){
									$production_detail =json_decode($pro_data->production_data,true);
									foreach($production_detail as $work_Order){								 
										if($work_Order['work_order'][0] == $workOrder->id){
											$output_array[$work_Order['party_code'][0]][$work_Order['process_name'][0]][] = $work_Order['output'][0];
										}
									}
								 }
							 }				
							 $actualOutput_array = array();
							 if(!empty($finishgoods_data)){
								 foreach($finishgoods_data as $pro_data){
									$job_card_detail =json_decode($pro_data->job_card_detail,true);
									foreach($job_card_detail as $work_Order){	
									
										if($work_Order['work_order_id'] == $workOrder->id){
										//	pre($workOrder);
											$actualOutput_array[$work_Order['material_id']][] = $work_Order['output'];
										}
									}
								 }
							 }
							$qty_count = array();
							$sno = 1;
                        	foreach($products as $product){
                        	$productDetail = getNameById('material',$product->product,'id');
                        	$materialName = !empty($productDetail)?$productDetail->material_name:'';
                        	$ww =  getNameById('uom', $product->uom,'id');
                        	$uom = !empty($ww)?$ww->ugc_code:'';
							$bomRouting_detail = get_data_byId_fromMaterial('material','id',$product->product);

                        		echo "<tr><td>".$sno."</td>
                        			<td><h5>".$materialName."</h5></td>
									<td>".$product->job_card."</td>
                        			<td class='onckicedit' ><span class='text-info' id='".$workOrder->id.'_'.$product->product."'>".((!empty($product->transfer_quantity))?$product->transfer_quantity:'')." </span> <i class='fa fa-pencil'></i></td>
                        			<td>".array_sum($actualOutput_array[$product->product])."</td>"; ?>
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
										$requiredQty = $product->transfer_quantity;
										$process_qty=$compeleteQty = $pendingQty= 0;
										foreach($process as $proces){
											$per_process_output = json_decode($proces['output_process'],true);
											$outputsum = array_sum(array_column($per_process_output, 'quantity_output'));
											$process_qty = round(($outputsum/$alotQty)*$requiredQty);
											$process_details = getNameById('add_process',$proces['processess'],'id');
											$compeleteQty = array_sum($output_array[$product->product][$process_details->id]);
											$pendingQty = $process_qty - $compeleteQty ;
											echo "<tr><td>".$process_details->process_name."</td><td>".$process_qty."</td><td>". $pendingQty."</td><td>".$compeleteQty."</td>";
										}
										$process_details = getNameById('add_process',$proces['processess'],'id');?>
									  </table>
								</td>
									
                        		<?php	echo "<td>".$uom."</td>
                        		</tr>";$sno++;
                        	} 
                        }
                        echo "";
                        ?>
                  </table>
               </td>
               <td><?php echo '<button type="buttton" class="btn btn-info productionTab addBtn" id="'.$workOrder->id.'" data-toggle="modal" data-id="ProductionOutputReport">View Output</button>'; ?></td>
               <td><?php echo $createdByName; ?></td>
               <td><?php echo date("j F , Y", strtotime($workOrder->created_date)); ?></td>
            </tr>
            <?php }} ?>
         </tbody>
         </table>
      </div>
 
</div>
<style>

td.onckicedit span:focus {
	 outline: -webkit-focus-ring-color auto 1px;
    padding: 10px;
} 
</style>
<script>
$(function(){
    //acknowledgement message
    var message_status = $("#status");	
	
	$('td.onckicedit .fa-pencil').click(function() {
		// var text = $('.text-info').text();		
		 var qty = $(this).parent('.onckicedit').find('.text-info').text();
		 //alert(qty);
		 var input = $('<input  required="required" type="number" value="' + qty + '" />')
		//  console.log(input);
		  $(this).parent('.onckicedit').find('.text-info').text('').append(input);
		 input.select();

		 input.blur(function() {
			var qty =$(this).val();
			var field_ids = $(this).parent('span').attr("id");
			var arr = field_ids.split('_');
			var workOrder_id= arr[0];
			var pro_id= arr[1];	
		   $(this).parent().text(qty);
		      $.post(site_url + 'production/editWorkOrderQty' , {
   			id: workOrder_id,	pro_id: pro_id,	transfer_quantity: qty,
   			}, function(data){
				if(data != '')
				{
					message_status.show();
					message_status.text(data);
					//hide the message
					setTimeout(function(){message_status.hide()},3000);
				}
			});
		   $(this).remove();
		 });
		});
});
</script>