<?php //pre($sale_orders); ?>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
		<?php   /* kan Ban */   ?>
		 <div class="container-fluid">
        <div id="sortableKanbanBoards" class="row">
            <!--sütun başlangıç-->
            <div class="panel panel-primary kanban-col" style="width:100%">
                <div class="panel-heading">
                    Set Sale order Priority
                    <i class="fa fa-2x fa-plus-circle pull-right"></i>
                </div>
               <?php /* <div class="panel-body droptarget"> */?>
                <div class="panel-body">
					<div id="TODO" class="kanban-centered">
						<?php if(!empty($sale_orders)){
								    $i = 0;
								    foreach($sale_orders as $sale_order){ 
										$i++;
										$accountName = ($sale_order['account_id']!=0)?(getNameById('account',$sale_order['account_id'],'id')):'';
										$accountName = !empty($accountName)?$accountName->name:'';										
										$contactName = ($sale_order['contact_id']!=0)?(getNameById('contacts',$sale_order['contact_id'],'id')):'';
										if(!empty($contactName)){
											$contactName = $contactName->first_name.' '.$contactName->last_name;
										}else{
											$contactName = '';
										}
										
										$validatedBy = ($sale_order['validated_by']!=0)?(getNameById('user_detail',$sale_order['validated_by'],'id')):'';
										if(!empty($validatedBy)){
											$validatedByName = $validatedBy->name;
										}else{
											$validatedByName = '';
										}				
										
										$selectApprove = $sale_order['approve']==1?'checked':'';
										$selectDisapprove = $sale_order['disapprove']==1?'checked':'';
										$products = json_decode($sale_order['product']);
										
										
										$createdByData = getNameById('user_detail',$sale_order['created_by'],'u_id');
										if(!empty($createdByData)){
											$createdByName = $createdByData->name;
										}else{
										$createdByName = '';
										}?>
										<article class="kanban-entry grab saleOrder" id="item<?php echo $i; ?>" data_sale_order_priority_id="<?php echo $sale_order['sale_order_priority_id'];?>"  data_sale_order_id="<?php echo $sale_order['sale_order_id'];?>" draggable="true" data-product="<?php echo $sale_order['product']; ?>" data_priority="<?php echo $sale_order['priority']; ?>">
										<div class="kanban-entry-inner">
											<div class="kanban-label" data_sale_order_id="<?php echo $sale_order['sale_order_id'];?>">	
												<?php echo "Sale Order Priority Id : ".$sale_order['sale_order_priority_id']."                   |                   Sale Order Id : ".$sale_order['sale_order_id']."                   |                   Account Name : ".$accountName. "                  |                   Contact Name : ".$contactName."                   |                   Order Date : ".$sale_order['order_date']."                   |                   Dispatch Date : ".$sale_order['dispatch_date']."                   |                   Payment Terms : ".$sale_order['payment_terms']."                   |                   Disapprove Reason : ".$sale_order['disapprove_reason']."                   |                   Validated By : ".$validatedByName."                   |                   Created By : ".$createdByName."                   |                   Created Date: ".$sale_order['created_date']."<br>Product Name : ".getNameById('material',$sale_order['product_id'],'id')->material_name."                   |                   Quantity :".$sale_order['quantity']."                   |                   UOM : ".$sale_order['uom']."                   |                   Price :".$sale_order['price']."                   |                   GST: ".$sale_order['gst']."                   |                   Price: ".$sale_order['individualTotal']."                   |                   Total Price: ".$sale_order['individualTotalWithGst']; ?>
												</div>
											</div>
									</article>															
								<?php echo "</tr>";?>

										<?php	} } ?>
						
                    </div>
					
					
                </div>
            </div>
        </div>
    </div>
	
<input type="button" value="Schedule your production" id="pro">
<?php if(empty($productionSetting)){
	echo '<h2>Please add shifts from production scheduling first.</h2>';

}	?>
    <!-- Static Modal -->
    <div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-refresh fa-5x fa-spin"></i>
                        <h4>Processing...</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
		
		<?php   /* kan Ban */ ?>
		
	
			<form method="post" class="form-horizontal" action="" enctype="multipart/form-data" id="productionScheduling" novalidate="novalidate" style="">	
			<input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>">	
			<input type="hidden" name="save_status" value="1" class="save_status">	
				<div class='col-sm-4'>
                    Only Date Picker
                    <div class="form-group">
                        <div class='input-group date' id='psMonthYear'>
                            <input type='text' class="form-control" id="selectedMonth" name="date"/>
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
				</div>
									
					  <div class="x_content" style="overflow:scroll;">
					  <div class="abc">
						 <table class="table table-bordered " id="days"  class="display">
							<thead>
							  <tr> <!--<th colspan="3"><input type="text" name="abc">
								  </th>-->
							  </tr>
							   <tr>  
								  <th><?php 
									$shifts = json_encode($productionSetting);
									?>
								  </th>
							   </tr>
							 </thead>
							 <tbody>
								<tr>
									<th><?php $machine_name = json_encode($machineName);  ?><?php $machine_id = json_encode($machineName);?></th>
									
								</tr>
							</tbody>
						   </table> 
						  </div>
						   
						   
					  </div>               
					<div class="shifts" style="display:none;"><?php echo $shifts; ?></div>
					<div class="machine_name" style="display:none;"><?php echo $machine_name; ?></div>
					<div class="machine_id" style="display:none;"><?php echo $machine_id; ?></div>
					<input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft">	
					<input type="submit" value="Save" id="save">
				</form>
				
		</div>
	</div>
</div>



<?php /*
<div class="droptarget" style="float: left; width: 100px;  height: 35px; margin: 15px; padding: 10px; border: 1px solid #aaaaaa;">
  <p draggable="true" id="dragtarget">Drag me!</p>
</div>
<div class="droptarget" style="float: left; width: 100px;  height: 35px; margin: 15px; padding: 10px; border: 1px solid #aaaaaa;"></div>
<div class="droptarget" style="float: left; width: 100px;  height: 35px; margin: 15px; padding: 10px; border: 1px solid #aaaaaa;"></div>
<p style="clear:both;"><strong>Note:</strong> drag events are not supported in Internet Explorer 8 and earlier versions or Safari 5.1 and earlier versions.</p>
<p id="demo"></p> */?>


<script>
		var measurementUnits = <?php echo json_encode(getUom()); ?>;	
		var jobCards = '<?php echo json_encode($jobCards); ?>';	
		var machines = '<?php echo json_encode($machines); ?>';	

	</script>
