
<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-success col-md-6">                            
			<?php echo $this->session->flashdata('message');?>
		</div>                        
<?php }
/*$str = 'Nzg1NTQ5Mjc3X0AjIUA=';
$str = base64_decode($str);
    echo str_replace("_@#!@", "", $str);*/

?>
<div class="x_content">
	
	<div class="col-md-12 col-sm-12 for-mobile">
       <div class="Filter Filter-btn2">
<form class="form-search" method="get" action="<?= base_url() ?>hrm/workers_pms/<?=$this->uri->segment(3)?>">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter Id" name="search" id="search" data-ctrl="hrm/workers_pms" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
		 <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
		 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?= base_url() ?>hrm/workers_pms/<?=$this->uri->segment(3)?>'" value="Reset"></a>
      </div>
   </div>
</form>	
<!-- <button style="margin-right: 0px !important;" type="button" class="btn btn-primary collapsed" data-toggle="collapse" data-target="#Filter" aria-expanded="false"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
-->            
            
         <!--   <div id="Filter" class="collapse">
               
			<div class="col-md-12 col-xs-12 col-sm-12 datePick-right">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="hrm/workers">
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>hrm/workers_pms/<?=$this->uri->segment(3)?>" method="get" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
               <input type="hidden" value='' class='ExportType' name='ExportType'/>
            </form>
         </div>
		 
               <form action="<?php echo base_url(); ?>hrm/workers_pms/<?=$this->uri->segment(3)?>" method="get" >
                  <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start'/>
                  <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end']; }?>' class='end_date' name='end'/>	
					<div class="row hidde_cls filter1 progress_filter">
                     <div class="col-md-12">
                        <input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="hrm/workers">
                     </div>
                  </div>
               </form>
              
            </div>-->
        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="dailyreport/dailyreport_adjustment">  
               <form action="<?php echo base_url(); ?>hrm/workers_pms/<?=$this->uri->segment(3)?>" method="post" id="date_range" >  
               <input type="hidden" value='' class='start_date' name='start_date'/>
               <input type="hidden" value='' class='end_date' name='end_date'/>
             </form>
</div>
    </div>
		<form action="<?php echo site_url(); ?>hrm/workers_pms/<?=$this->uri->segment(3)?>" method="get" id="export-form">
      <input type="hidden" value='' id='hidden-type' name='ExportType'/>
      <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
      <input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start']; ?>' class='start_date' name='start'/>
      <input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end']; ?>' class='end_date' name='end'/>
		</form>	
		<?php # if(!empty($productionData)){ ?>
				<div class="row hidde_cls export_div">
					<div class="col-md-12">            							
						<div class="btn-group"  role="group" aria-label="Basic example">
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
							<input type="hidden" value='production_data' id="table" data-msg="Production Data" data-path="production/production_data"/>
				<!--	  <button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>-->
				<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
					<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
						<ul class="dropdown-menu" role="menu" id="export-menu">
							<li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
							<li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
						</ul>
				</div>
				 <form action="<?php echo base_url(); ?>production/production_data" method="get" >
                        <input type="hidden" value="" class="start_date" name="start">
                         <input type="hidden" value="" class="end_date" name="end">             
				</form>
							</div>
						<div class="col-md-3 col-xs-12 col-sm-12 datePick-right">
						     <?php if($can_add) { 										
			  '<button type="button" class="btn btn-primary productionTab addBtn" data-id="productEdit" id="add" data-toggle="modal">Add</button>';
		}?>
						</div>
					</div>
				</div>
		<?php # } ?>		
	<p class="text-muted font-13 m-b-30"></p>  
	<div id="print_div_content">  
    <!---datatable-buttons--->
		
			<hr>
			<input type="hidden" id="visible_row" value=""/>
		<table id="mytable" class="table tblData table-striped table-bordered" border="1" cellpadding="3" style="width:100%;" data-order='[[1,"desc"]]'>
			<thead>
				<tr>
					<th><!--<input id="selecctall" type="checkbox">--></th>
					<th>Id</th>
					<th>Date</th>	
					<th>Shift</th>	
					<th>Production Data</th>	
					<th>PMS %</th>	
					<th>Created By / Edited By</th>
					<th>Created Date</th>							
												
							
					<!--<th class='hidde'>Action</th>-->	
				</tr>
			</thead>
			<tbody class="prodData">
				<?php 
				if(!empty($productionData)){
				    $total_actualOutputsum = 0;
				$total_targetOutputsum = 0;
					foreach($productionData as $production_data){	
						$draftImage = ($production_data['save_status'] == 0)?('<img src="'.base_url(). 'assets/images/draft.png"  width="25%" class="hidde">'):'';	
						$shift = ''; 
						if($production_data['shift']!=0 || $production_data['shift']!=''){							
							$shiftData = getNameById(' production_setting',$production_data['shift'],'id');
							$shift = !empty($shiftData)?$shiftData->shift_name:'';
						}
						?>
					<tr>
						<td><?php   "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$production_data['id'].">";

							if($production_data['favourite_sts'] == '1'){
									    "<input class='star-1' type='checkbox'  title='Mark Record' value=".$production_data['id']."  checked = 'checked'>";
									  "<input type='hidden' value='production_data' id='favr' data-msg='Job card' data-path='production/production_data' favour-sts='0' id-recd=".$production_data['id'].">";
							}else{
									  "<input class='star-1' type='checkbox'  title='Mark Record' value=".$production_data['id'].">";
									 "<input type='hidden' value='production_data' id='favr' data-msg='job Card' data-path='production/production_data' favour-sts='1' id-recd =".$production_data['id'].">";
							}
							?></td>
						<td><?php echo $draftImage.$production_data['id'];  ?></td>
						<td><?php if($production_data['date'] != '') { echo date("j F , Y", strtotime($production_data['date'])); }?> </td>		
						<td><?php echo $shift;?> </td>		
						<td>
						<!-- prodData -->
							<div class="x_content">
                            <!------------ datatable-buttons ----------------->
								<table  id="" class="table table-bordered" data-id="user" border="1" cellpadding="3">		
									<thead>								
										<tr>		
											<th>Wages/Per piece</th>					
											<th>Machine</th>					
											<th>BOM Routing Product</th>					
											<th>Workers</th>
											<th>Production Output</th>
											<th>Planning Output</th>
											<th>Labour costing</th>
											<th>Remarks</th>
										</tr>
									</thead>
									<tbody>									
									<?php
									if($production_data['production_data'] != ''){
										$productionWagesData = json_decode($production_data['production_data']);
										$prodData_lengthCount = count($productionWagesData);
										$productionPlanning = array();
										$productionPlanning=json_decode($production_data['planning_data']);	
									$TargetOutputsum = 0;
									$ActualOutputsum = 0;
										//pre($productionWagesData);
									//	pre($productionPlanning); 
											$k=0;
										//	pre($productionWagesData);
											if(!empty($productionWagesData)){
		

												$production_array = filter_array($productionWagesData,$workerView->id);
	                                                    
												foreach($production_array as $pwd){
													//pre($pwd);die;
													if(!empty($pwd)){
														$wagesLength = !empty($pwd->wages_or_per_piece)?(count($pwd->wages_or_per_piece)):0;
														for($i=0;$i<$wagesLength;$i++){
														
															echo '<tr><td>'.$pwd->wages_or_per_piece[$i] .'</td>';
															$machine_id = isset($pwd->machine_name_id[$i])?$pwd->machine_name_id[$i]:'';
															$machineData = ($machine_id!='' || $machine_id!=0)?getNameById('add_machine',$machine_id,'id'):array();
															echo '<td>'. ((!empty($machineData))?($machineData->machine_name):'') .'</td>';
															$jobCard = isset($pwd->job_card_product_id[$i])?getNameById('job_card',$pwd->job_card_product_id[$i],'id'):array();  
															echo '<td>'. ((!empty($jobCard))?($jobCard->job_card_product_name):'') .'</td>'; ?>
															<td>
															<?php $workerName_id[$i] = isset($pwd->worker_id[$i])?($pwd->worker_id[$i]):'';
															if(!empty($workerName_id[$i])){
																echo '<table class="table table-bordered" class="table table-bordered" data-id="user" border="1" cellpadding="3"><thead><tr><td>Worker</td><td>Hours/percentage</td><td>total Salary</td></tr></thead><tbody>';
																	for($j=0;$j< count($workerName_id[$i]);$j++){
																		echo '<tr><td>';
																		$Workername = getNameById('worker',$workerName_id[$i][$j],'id');
																		echo !empty($Workername)?$Workername->name:'';
																		echo '</td>';
																		echo '<td>'.$pwd->working_hrs[$i][$j].'</td>';
																		echo '<td>'.$pwd->totalsalary[$i][$j].'</td></tr>';
																	}											
															echo "</tbody></table>";
															}  	
															?> 
															</td>
															<td><?php  if(isset($pwd->output[$i])) echo $pwd->output[$i];?></td><td><?php 
								
															echo isset($productionPlanning[$k]->output)?$productionPlanning[$k]->output[$i]:'0';
															?></td>															
															<td><?php if(!empty($pwd) && isset($pwd->labour_costing[$i])) echo $pwd->labour_costing[$i];?></td>
															<td><?php  if(isset($pwd->remarks[$i])) echo $pwd->remarks[$i];?></td>
															</tr><?php 
															$TargetOutputsum += isset($productionPlanning[$k]->output) ? $productionPlanning[$k]->output[$i] : 0;
															$ActualOutputsum += is_numeric($pwd->output[$i]) ? $pwd->output[$i] : 0;
													@$output[] = array('Id' =>$production_data['id'],
																	'Date' =>date("j F , Y", strtotime($production_data['date'])),
																	'Shift'=>$shift,
																	'Wages/Per Piece'=>$pwd->wages_or_per_piece[$i],
																	'Machine'=>$machineData->machine_name,
																	'BOM Routing Product'=>$jobCard->job_card_product_name,
																	'Production Output'=>$pwd->output[$i],
																	'Planning Output'=>$productionPlanning[$k]->output[$i],
																	'Labour Costing'=>$pwd->labour_costing[$i],
																	'Remarks'=>$pwd->remarks[$i],
																	'Created By/Edited By'=>(($production_data['created_by']!=0)?(getNameById('user_detail',$production_data['created_by'],'u_id')->name):'').'/'.(($production_data['edited_by']!=0)?(getNameById('user_detail',$production_data['edited_by'],'u_id')->name):''),
																	'Created Date'=>date("j F , Y", strtotime($production_data['created_date'])),
																	);			
														}$k++;	
													}
												}
											}
									}
									
									/*if($prodData_lengthCount > 3){
							
											if($can_view) {
											 echo "<tr class='hidde'>
												<th colspan='8'>
													<a href='javascript:void(0)' id='". $production_data["id"] . "' data-id='productView' class='productionTab' data-tooltip='View' style='color:green;'>View More....</a>
													</th>
												</tr>";
											}
										 
									} */?><tr>
									<td></td><td></td><td></td>
									<td></td><td>Total Prodcution Output:<?php echo $ActualOutputsum;?></td>
									<td>Total Planning Output:<?php echo "".$TargetOutputsum;?></td>
							</tr>
									</tbody>
								</table>
							</div>								
						</td>
				<?php		$pms_per = ( $ActualOutputsum / $TargetOutputsum ) *100; 
				      $total_actualOutputsum = $total_actualOutputsum +   $ActualOutputsum;
				      $total_targetOutputsum = $total_targetOutputsum + $TargetOutputsum;
				?>
				             
						<?php $percentageOfOutput = percentageOfOutput($productionWagesData , $productionPlanning,$workerView->id); ?>
						<!--<td></?php  echo $percentageOfOutput; ?>%</td>-->
						<td><?php  echo $pms_per; ?>%</td>
						<td><?php echo (($production_data['created_by']!=0)?(getNameById('user_detail',$production_data['created_by'],'u_id')->name):'').'<br>'.(($production_data['edited_by']!=0)?(getNameById('user_detail',$production_data['edited_by'],'u_id')->name):''); ?></td>
						<td><?php echo date("j F , Y", strtotime($production_data['created_date'])); ?></td>
						<!--<td><button id="</?php echo $production_data['id']; ?>" data-id="AddSimilarProdData" data-tooltip="Add Similar Data" class="btn btn-xs productionTab add-machine"><i class="fa fa-plus"></i></button></td>-->
						
					<!--	<td class='hidde'>
						    <button id="<?php echo $production_data['id']; ?>" data-id="AddSimilarProdData" data-tooltip="Add Similar Data" class="btn btn-xs productionTab add-machine"><i class="fa fa-clone" aria-hidden="true"></i></button>
							<?php /* if($can_edit) 
								echo '<button  id="'.$production_data['id'].'" data-id="productEdit" class="btn btn-edit btn-xs productionTab" data-toggle="modal" data-tooltip="Edit"><i class="fa fa-pencil"></i></button>';
								if($can_delete) 
									echo '<a href="javascript:void(0)" class="delete_listing
										   btn btn-delete btn-xs" data-tooltip="Delete" data-href="'.base_url().'production/production_data_delete/'.$production_data['id'].'" ><i class="fa fa-trash" ></i></a>';
								if($can_view) 
									echo '<button class="btn btn-view btn-xs productionTab" data-id="productView" id="'.$production_data["id"].'" data-toggle="modal" data-tooltip="View"><i class="fa fa-eye"></i></button>';
							*/?>
						</td>-->
					</tr>
					<?php
					}
						$total_av_percentage = ( $total_actualOutputsum / $total_targetOutputsum ) *100; 
					
					?>
				             	Total Average Percentage = <?php echo $total_av_percentage."%" ;  ?>
					
			<?php
                        $data3  = $output;
                        export_csv_excel($data3);	
                        //$data_balnk  = $output_blank;
                        //export_csv_excel_blank($data_balnk); 	
                        } ?>
			</tbody> 
		</table><?php echo $this->pagination->create_links(); ?>	
	</div>
</div>
<div id="production_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-large">
		<div class="modal-content ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel">Production Data</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
