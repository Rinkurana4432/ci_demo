<div class="x_content">
<?php
if($this->session->flashdata('message') != ''){
	echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
}
?>
    <div class="col-md-12 col-xs-12 for-mobile">
	
		<div class="stik">
			<!--<div class="col-md-12 export_div">
				 <div class="btn-group" role="group" aria-label="Basic example">
					<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
					   <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown" aria-expanded="false" style="display: none;">Export<span class="caret"></span></button>
					   <ul class="dropdown-menu" role="menu" id="export-menu">
						  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
						  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
					   </ul>
					</div>
				 </div>	
			  </div>-->
		  
			<?php if(!isset($_GET['my'])){ ?>
				<div class="col-md-2 datePick-right">
					<a href="<?php echo base_url(); ?>inventory/view_inventory_adjustmentHistory?id=<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>" class="Reset-btn btn btn-success">
						Reset
					</a>
				</div>	
				
				<!-- Datewise filter -->			
				<div class="col-md-2 datePick-right">
				   <div class="control-group">
					  <div class="controls">
						 <div class="input-prepend input-group">
							<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							<input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="crm/leads" />
						 </div>
					  </div>
					  <form action="<?php echo base_url(); ?>inventory/view_inventory_adjustmentHistory?id=<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>" method="get" id="date_range">
						   <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
						   <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
						   <input type="hidden" name="id" value="<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>">
					   </form>
				   </div>
				</div>
			<?php } ?>		
			
	   </div>
	   

		<div class="" role="tabpanel" data-example-id="togglable-tabs">
			<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class="active"><a href="#tab_inventory_transaction" id="invetory_transaction" role="tab" data-toggle="tab" aria-expanded="true">Transaction History</a></li>
				<li role="presentation" class=""><a href="#tab_monthwise_list" role="tab" id="monthwise_list" data-toggle="tab" aria-expanded="false">View Stock</a></li>
				<!--li role="presentation" class=""><a href="#tab_lot_report" role="tab" id="lot_report" data-toggle="tab" aria-expanded="false">View Lot</a></li-->
				<li role="presentation" class=""><a href="#tab_mat_availbility" role="tab" id="mat_availbility" data-toggle="tab" aria-expanded="false">View Availbility</a></li>
			</ul>
			
				
			<div id="myTabContent" class="tab-content">
			
				<!---------- Transaction History ------------->
				<div role="tabpanel" class="tab-pane fade active in" id="tab_inventory_transaction" aria-labelledby="invetory_transaction">
					<div id="print_div_content">
						<table id="transactionHistory" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th scope="col">Id</th>
									<th scope="col">Material Type</th>
									<th scope="col">Material Sub Type</th>
									<th scope="col">Material Name</th>
									<th scope="col">Action</th>
									<th scope="col">Ref ID</th>
									<th scope="col">Opening Stock</th>
									<th scope="col">Material <br>(IN)</th>
									<th scope="col">Material (OUT)</th>
									<th scope="col">Closing Stock</th>
									<th scope="col">UOM</th>
									<th scope="col">Location In</th>
									<th scope="col">Location Out</th>
									<th scope="col">Created by</th>
									<th scope="col">Created Date</th>
								</tr>
							</thead>
							<tbody>
								<?php if(!empty($mat_trans)){
										foreach($mat_trans as $mattrans){		
										
											$moved = "";		
											$action = '';
											if($mattrans['through'] == "Moved"){$moved = "(Material Moved from Current to new Location)";} 
											$matInfo =  getNameById('material', $mattrans['material_id'],'id');
											$material_type_id = !empty($matInfo) ? $matInfo->material_type_id:'';
											$mtInfo =  getNameById('material_type', $material_type_id,'id');
											$materialTypeName = !empty($mtInfo) ? $mtInfo->name:'';
											
											$sub_type = !empty($matInfo) ? $matInfo->sub_type:'';	
											$material_name = !empty($matInfo) ? $matInfo->material_name:'';	
											
											$uomInfo =  getNameById('uom', $mattrans['uom'],'id');
											$uom = !empty($uomInfo) ? $uomInfo->ugc_code:'-';

											$matin = !empty($mattrans['material_in'])?$mattrans['material_in']:'-';
											$matout = !empty($mattrans['material_out'])?$mattrans['material_out']:'-';

											$userInfo =  getNameById('user_detail', $mattrans['created_by'],'u_id');
											$uname = !empty($userInfo) ? $userInfo->name:'';

											$dt =  date("j F , Y", strtotime($mattrans['created_date'])); 
										

									echo "<tr>
										<td data-label='id:'>".$mattrans['id']."</td>
										<td data-label='Material Type:'>".$materialTypeName."</td>
										<td data-label='Material Sub Type:'>".$sub_type."</td>
										<td data-label='Material Name:'>".$material_name."</td>
										<td data-label='Action:'>".$mattrans['through']."<br> ".$moved."</td>
										<td data-label='Ref ID:'>".$mattrans['ref_id']."</td>	
										<td data-label='Opening Stock:'>".$mattrans['opening_blnc']."</td>
										<td data-label='Material in:'>".$matin."</td>
										<td data-label='Material out:'>".$matout."</td>
										<td data-label='Closing Stock:'>".$mattrans['closing_blnc']."</td>
										<td data-label='uom:'>".$uom."</td>
										<td data-label='New Location:'>";
										?>

								<table id="" style="width:100%" class="table table-bordered product_index  bulk_action" data-id="user"
									border="1" cellpadding="3">
									<thead>
										<tr>
											<th>Address</th>
											<th>Storage</th>
											<!--th>Rack No.</th>
											<!--<th>Quantity</th>-->
										</tr>
									</thead>
									<tbody>
									<?php 
											if($mattrans['new_location'] !=''){
													$loc1 = json_decode($mattrans['new_location']);
													foreach($loc1 as $loc){
														$location = getNameById('company_address',$loc->location,'id');
														echo "<tr>
																<td><h5>".((!empty($location))?($location->location):'')."<h5></td>
																<td>".((!empty($loc))?($loc->Storage):'')."</td>
																
															</tr>";
															// <td>".((!empty($loc))?($loc->RackNumber):'')."</td>
														//<td>".((!empty($loc))?($loc->quantity):'')."</td>	
													} 
											}
											else{
												echo "<tr><td colspan='7'>"."No Data Available"."</td></tr>";
											}
										echo "</tbody></table></td><td data-label='Current Location:'>"; ?>
									
								<table id="" style="width:100%" class="table table-bordered product_index  bulk_action" data-id="user" border="1" cellpadding="3">
									<thead>
											<tr>
												<th>Address</th>
												<th>Storage</th>
												<!--th>Rack No.</th>
												<th>Quantity</th>-->													
											</tr>
									</thead>
									<tbody>
									<?php 
										if($mattrans['current_location'] !=''){
												$loc2 = json_decode($mattrans['current_location']);
												foreach($loc2 as $locc){
													$location = getNameById('company_address',$locc->location,'id');
													echo "<tr>
															<td><h5>".((!empty($location))?($location->location):'')."<h5></td>
															<td>".((!empty($locc))?($locc->Storage):'')."</td>
															
														</tr>";
													//<td>".((!empty($locc))?($locc->quantity):'')."</td>
													// <td>".((!empty($locc))?($locc->RackNumber):'')."</td>
												} 
										}
										else{
											echo "<tr><td colspan='7'>"."No Data Available"."</td></tr>";
										}
										echo "</tbody></table></td>										
										<td data-label='Created by:'>".$uname."</td>	
										<td data-label='Created Date:'>".$dt."</td>	
									</tr>";
								}
						   } ?>
							</tbody>
						</table>
						<?php #echo $this->pagination->create_links(); ?>
					</div>
				</div>
				<!----------End Transaction History ------------->
				
				
				<!---------- View Stock ------------->
				<div role="tabpanel" class="tab-pane fade" id="tab_monthwise_list" aria-labelledby="monthwise_list">		
					<div id="print_div_content1">
						<table id="monthwiseList" class="table table-striped table-bordered">
							<thead>
								<tr>
									<?php if(!isset($_GET['my']) && !isset($_GET['start'])){ ?>
										<th>Month wise</th>
									<?php }else{ ?>
										<th>Date wise</th>
									<?php } ?>
									<th>Opening Stock</th>
									<th>Inwards</th>
									<th>Outwards</th>
									<th>Closing Stock</th>
									<?php if(!isset($_GET['my']) && !isset($_GET['start'])){ ?>
										<th>View</th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
						<?php 
						//Sorting data ascending order function 									
						function sortByOrder($a, $b) {
							return $a['id'] - $b['id'];
						}

						if(!empty($monthwise_trans)){
							if(!isset($_GET['my']) && !isset($_GET['start'])){															
								foreach($monthwise_trans as $my => $monthwise){																				
									$year = substr($my, 0, 4); 
									$month = substr($my, 4, 2); 										
									$month_name = date("F", mktime(0, 0, 0, $month, 10));
									$monthYear = $month_name.', '.$year;
									
									usort($monthwise, 'sortByOrder');
									#pre($monthwise);
									if(!empty($monthwise)){
										$first = current($monthwise);
										$last = end($monthwise);

										$material_in = '0';
										$material_out = '0';																					
										foreach($monthwise as $rows){												
											$month =  !empty($rows['created_date']) ? date("Ym", strtotime($rows['created_date'])):'';
											if($my == $month){
												$material_id = $rows['material_id'];
												$material_in += intval($rows['material_in']);
												$material_out += intval($rows['material_out']);      
											}												
										}																					
									}										
									?>
									<tr>
										<td data-label='Created Date:'><?php echo $monthYear; ?></td>	
										<td data-label='Opening stock:'><?php echo $first['opening_blnc']; ?></td>
										<td data-label='Material in:'><?php echo $material_in; ?></td>
										<td data-label='Material out:'><?php echo $material_out; ?></td>
										<td data-label='closing stock:'><?php echo $last['closing_blnc']; ?></td>
										
										<?php if(!isset($_GET['my']) && !isset($_GET['start'])){ ?>
										<td data-label='Closing Stock:'>
										  	<a target="_BLANK" href="<?php echo base_url(); ?>inventory/view_inventory_adjustmentHistory?id=<?php echo $rows['material_id']; ?>&my=<?php echo $my;?>" class="btn btn-delete btn-xs" data-tooltip="View Details" data-href=""><i class="fa fa-eye"></i>View Details</a>
										</td>	
										<?php } ?>									
									</tr>
								<?php									
								}								
							}else{				
								usort($monthwise_trans, 'sortByOrder');
								#pre($monthwise_trans);								  
								foreach($monthwise_trans as $rows){	
									$monthYear =  !empty($rows['created_date']) ? date("j F , Y", strtotime($rows['created_date'])):''; 																
							?>							   
								<tr>
									<td data-label='Created Date:'><?php echo $monthYear; ?></td>	
									<td data-label='Opening Stock:'><?php echo $rows['opening_blnc']; ?></td>
									<td data-label='Material in:'><?php echo $rows['material_in']; ?></td>
									<td data-label='Material out:'><?php echo $rows['material_out']; ?></td>
									<td data-label='Material out:'><?php echo $rows['closing_blnc']; ?></td>																											
								</tr>
							<?php									
								}
							} 
						}
						?>
							</tbody>                   
						</table>
					</div>
				</div>
				<!----------End View Stock ------------->
				
				
				<!---------- View Lot ------------->
				<div role="tabpanel" class="tab-pane fade" id="tab_lot_report" aria-labelledby="lot_report">
										
					<div id="print_div_content2">
						<table id="lotReport" class="table table-striped table-bordered">
							 <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Lot Number</th>
                                    <th>Material Type</th>
                                    <th>Material Name</th>
                                    <th>MOU Price</th>
                                    <th>MRP Price</th>
                                    <th>Avail. Quantity</th>
                                    <th>Date</th>
                                    <th>Created by</th>
                                    <th>Created Date</th>
                                   <!--  <th>Action</th> -->
                                </tr>
                            </thead>
							<tbody>
                            <?php 
							if(!empty($lot_details)){
								foreach($lot_details as $lotdetails){		
									$rty = getNameById('user_detail',$lotdetails['created_by'],'u_id');
									$usernme = !empty($rty)?$rty->name:'';
									$matype = getNameById('material_type',$lotdetails['mat_type_id'],'id');
									$mat_type = !empty($matype)?$matype->name:'';
									$manme = getNameById('material',$lotdetails['mat_id'],'id');
									$mat_nme = !empty($manme)?$manme->material_name:'';
									$statusChecked = $lotdetails['active_inactive']==1?'checked':'';
								?>
                                <tr>
                                    <td><?php echo $lotdetails['id'];?></td>
                                    <td><?php echo $lotdetails['lot_number'];?></td>
                                    <td><?php echo $mat_type; ?></td>
                                    <td><?php echo $mat_nme; ?></td>
                                    <td><?php echo $lotdetails['mou_price']; ?></td>
                                    <td><?php echo $lotdetails['mrp_price']; ?></td>
                                    <td><?php echo $lotdetails['quantity']; ?></td>
                                    <td><?php echo $lotdetails['date']; ?></td>
                                    <td><?php echo $usernme;?></td>
                                    <td><?php echo $lotdetails['created_date'];?></td>
                                </tr>
                            <?php }} ?>
                            </tbody>                   
						</table>
					</div>
				</div>
				<!----------End View Lot ------------->
				
				
				<!---------- view mat availability ------------->
				<div role="tabpanel" class="tab-pane fade" id="tab_mat_availbility" aria-labelledby="mat_availbility">
										
					<div id="print_div_content3">
						<table id="matAvailbility" class="table table-striped table-bordered">
							 <thead>
                                <tr>
									<th>Id</th>
									<th>Customer Type</th>
									<th>Material Type</th>
									<th>Material Name</th>
									<th>Total Quantity</th>
									<th>Reserved Quantity</th>
									<th>Available Quantity</th>
									<th>Created by</th>
									<th>Created Date</th>
								</tr>
                            </thead>
							<tbody>
                            <?php 
                            if(!empty($reserved_material)){
								foreach($reserved_material as $reservedmaterial){       
									$rty1 = getNameById('types_of_customer',$reservedmaterial['customer_id'],'id');
									$custmr = !empty($rty1)?$rty1->type_of_customer:'';
									$rty = getNameById('user_detail',$reservedmaterial['created_by'],'u_id');
									$usernme = !empty($rty)?$rty->name:'';
									$matype = getNameById('material_type',$reservedmaterial['material_type'],'id');
									$mat_type = !empty($matype)?$matype->name:'';
									$manme = getNameById('material',$reservedmaterial['mayerial_id'],'id');
									$mat_nme = !empty($manme)?$manme->material_name:'';

									$yu = getNameById_mat('mat_locations',$reservedmaterial['mayerial_id'],'material_name_id');
									$sum = 0;
									 if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
									 else{ echo "";}
									 $blnc = $sum - $reservedmaterial['quantity'];
                            ?>
								<tr>
									<td><?php echo $reservedmaterial['id'];?></td>
									<td><?php echo $custmr; ?></td>
									<td><?php echo $mat_type; ?></td>
									<td><?php echo $mat_nme; ?></td>
									<td><?php echo $sum; ?></td>
									<td><?php echo $reservedmaterial['quantity']; ?></td>
									<td><?php echo $blnc; ?></td>
									<td><?php echo $usernme;?></td>
									<td><?php echo $reservedmaterial['created_date'];?></td>
								</tr>
							<?php }}?>
                            </tbody>                   
						</table>
					</div>
				</div>
				<!----------End view mat availability ------------->
				
			</div>
		</div>
    </div>
	
    <p class="text-muted font-13 m-b-30"></p>
</div>

<div id="inventory_add_modal" class="modal fade in" role="dialog">
    <div class="modal-dialog modal-lg modal-large">
        <div class="modal-content" style="display:table;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">UOM List</h4>
            </div>
            <div class="modal-body-content"></div>
        </div>
    </div>
</div>
<script>
    var measurementUnits = '';
</script>