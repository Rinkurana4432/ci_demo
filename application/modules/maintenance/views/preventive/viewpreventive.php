<div role="tabpanel" data-example-id="togglable-tabs">
			<ul id="myTab" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#in_progress_tab" data-select='progress' id="complete_tab" role="tab" data-toggle="tab" aria-expanded="true">Machine</a></li>
				<li role="presentation" class="complte "><a href="#Complete_content_tab" role="tab" data-select='complete' id="auto_entery_tab" data-toggle="tab" aria-expanded="false">Preventive History</a></li>
				<li role="presentation" class="complte "><a href="#Complete_breakdown_tab" role="tab" data-select='complete' id="auto_entery_tab" data-toggle="tab" aria-expanded="false">Breakdown History</a></li>
			</ul>

<div id="myTabContent" class="tab-content">
  <div role="tabpanel" class="tab-pane fade active in" id="in_progress_tab" aria-labelledby="complete_tab">
	<div class="x_content">
		<div id="print_div_content" class="table-responsive">
			   <h3 class="Material-head">Machine Details<hr></h3> 
			<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveAddMachine" enctype="multipart/form-data" id="add_machine" novalidate="novalidate">
            <input type="hidden" name="id" value="<?php if($AddMachine && !empty($AddMachine)){ echo $AddMachine->id;} ?>">
						
			<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv"  style="padding:0px;">

					<div class="table-responsive" >
					      <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
						  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
			                                     <label for="material">Machine Group :</label>
												<div class="col-md-6 col-sm-12 col-xs-12 form-group">
													<div><?php if(!empty($AddMachine) && $AddMachine->machine_group_id !=''){ 
										$machineGroup = getNameById('machine_group',$AddMachine->machine_group_id,'id');
						   echo (!empty($machineGroup))?$machineGroup->machine_group_name:'';  }?></div>
												</div>
							</div>
			                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
			                                     <label for="material">Machine Name :</label>
												<div class="col-md-6 col-sm-12 col-xs-12 form-group">
													<div><?php if(!empty($AddMachine)){ echo $AddMachine->machine_name; } ?></div>
												</div>
							</div>
			                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
			                                     <label for="material">Machine Code :</label>
												<div class="col-md-6 col-sm-12 col-xs-12 form-group">
													<div><?php if(!empty($AddMachine)){ echo $AddMachine->machine_code; } ?></div>
												</div>
							</div>
							 <div class="col-md-12 col-sm-12 col-xs-12 form-group">
			                                     <label for="material">Make & Model :</label>
												<div class="col-md-6 col-sm-12 col-xs-12 form-group">
													<div><?php if(!empty($AddMachine)){ echo $AddMachine->make_model; } ?></div>
												</div>
							</div>
			                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
			                                     <label for="material">Date Of Purchase :</label>
												<div class="col-md-6 col-sm-12 col-xs-12 form-group">
													<div><?php if(!empty($AddMachine)){ echo date("j F , Y", strtotime($AddMachine->year_purchase)); } ?></div>
												</div>
							</div>
			               
							</div>
							<div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
			                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
			                                     <label for="material">Company Branch :</label>
												<div class="col-md-6 col-sm-12 col-xs-12 form-group">
													<div>
													<?php if(!empty($AddMachine)){ 
														$getUnitName= getNameById('company_address',$AddMachine->company_branch,'compny_branch_id');
															if(!empty($getUnitName)){
																echo $getUnitName->company_unit;
															}else{
																echo $AddMachine->company_branch;
															}													
														} ?>
													
													</div>
												</div>
							</div>		
			                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
			                                     <label for="material">Department :</label>
												<div class="col-md-6 col-sm-12 col-xs-12 form-group">
													<div><?php 						
																		if(!empty($AddMachine) && $AddMachine->department !=''){ 
																			$departmentData = getNameById('department',$AddMachine->department,'id');
																			echo (!empty($departmentData))?$departmentData->name:''; 										
																	} ?></div>
												</div>
							</div>
			                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
			                                     <label for="material">Preventive Maintenance :</label>
												<div class="col-md-6 col-sm-12 col-xs-12 form-group">
													<div><?php if(!empty($AddMachine)){ echo $AddMachine->preventive_maintenance; } ?></div>
												</div>
							</div>				
						     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
			                                     <label for="material">Placement :</label>
												<div class="col-md-6 col-sm-12 col-xs-12 form-group">
													<div><?php if(!empty($AddMachine)){ echo $AddMachine->placement; } ?></div>
												</div>
							</div>
						  </div>
					</div>
						  
					<hr>
					<div class="bottom-bdr"></div>

					<div class="container mt-3">
					<h3 class="Material-head">Machine Parameter<hr></h3>

					<div class="well dtailes" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">	
					<?php if(empty($AddMachine) || $AddMachine->machine_parameter !=''){  ?>
							  <div class="label-box">
									   <div class="col-md-6 col-sm-12 col-xs-12 form-group"><label style="border-left:1px solid #c1c1c1 !important;">Parameter</label></div>
									   <div class="col-md-6 col-sm-12 col-xs-12 form-group"><label>UOM</label></div>			   
								 </div>
								 <?php 
														   if(!empty($AddMachine) && $AddMachine->machine_parameter !=''){											
														   $machineParameter =  json_decode($AddMachine->machine_parameter);	
														   if(!empty($machineParameter)){									
														   foreach($machineParameter as $machine_Parameter){												
																				
														?>	
								 <div class="row-padding">
										  <div class="col-md-6 col-sm-12 col-xs-12 form-group">
										  <div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"><?php echo $machine_Parameter->machine_parameter; ?></b></div>
														
										 </div>
										 <div class="col-md-6 col-sm-12 col-xs-12 form-group">

										  <div  class="tab-div"><?php 


												$ww =  getNameById('uom', $machine_Parameter->uom,'id');
																	$uom = !empty($ww)?$ww->ugc_code:'';

																	echo $uom;





										  ?></b></div>
														
										 </div>
								 </div>
								 <?php }  }                                   
											}?>
								
					<?php } ?>

					</div>
					</div>		  

					<hr>
					<div class="bottom-bdr"></div>


					<div class="container mt-3">
					<h3 class="Material-head">Machine Process<hr></h3>

					<div class="well dtailes" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">	

									<?php if(empty($AddMachine) || $AddMachine->process !=''){  
										echo '<div class="label-box"><div class="col-md-6 col-sm-12 col-xs-12 form-group"><label style="border-left:1px solid #c1c1c1 !important;">Parameter</label></div><div class="col-md-6 col-sm-12 col-xs-12 form-group"><label>UOM</label></div></div>';
											if(!empty($AddMachine) && $AddMachine->process !=''){
												$machineProcessData =  json_decode($AddMachine->process);	
												if(!empty($machineProcessData)){									
													foreach($machineProcessData as $mcProcess){	
														echo '<div class="row-padding"><div class="col-md-6 col-sm-12 col-xs-12 form-group">
										  <div style="border-left:1px solid #c1c1c1 !important;" class="tab-div">';
														if(!empty($AddMachine) && $mcProcess->process_type !=''){ 
															if(!empty($mcProcess) && $mcProcess->process_type !=''){ 
																$processType = getNameById('process_type',$mcProcess->process_type,'id');
															}
															echo $processType->process_type;
														}
														echo '<br /></div></div><div class="col-md-6 col-sm-12 col-xs-12 form-group">
										  <div  class="tab-div">';
														if(!empty($mcProcess) && $mcProcess->process!=''){
															$processData = getNameById('add_process',$mcProcess->process,'id');
															echo $processData->process_name;
														}	
														echo '<br /></td></div></div></div>';
													}
												}                                   
											}								
												
											} ?>
									


					</div>
					</div>	

					<hr>
					<div class="bottom-bdr"></div>


			<div class="container mt-3">
				<div class="well dtailes" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">	
			<h3 class="Material-head">Preventive Machine Details<hr></h3>

				<div class="well dtailes" style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">	
					
					<?php if(!empty($setperiventdmac)){

			          $machpriventiveData1 =  json_decode($setperiventdmac->check_list);
			          
			          ?>
			             <table class="table table-striped table-bordered account_index" border="1" cellpadding="3">
			             	<thead>
			             	<tr>
			             		<th><label style="border:none;">Frequency</label></th>
			             	</tr>
			               </thead>
			               <tbody>
			             <?php 
			             $preventivefrequency =  json_decode($setperiventdmac->frequency);
			            
			             if(is_array($preventivefrequency)){     
			          foreach($preventivefrequency as $preventivefrequencys){
			             
			               ?>
			              
			              <tr>
			              	<td><?php echo $preventivefrequencys->frequency_data; ?></td>
			              </tr>
			              
			           <?php         
			          
			          } 

			      }
			      ?>
			             </tbody>
			          </table>

			             <table class="table table-striped table-bordered account_index" border="1" cellpadding="3">
			             	<thead>
			             	<tr>
			             		<th><label style="border:none;">Check list</label></th>
			             	</tr>
			               </thead>
			             <tbody>
			          <?php      
			          foreach($machpriventiveData1 as $machpriventiveData1s){
			               ?>
			              <tr>
			              	<td><?php echo $machpriventiveData1s->check_list_data; ?></td>
			              </tr>

			           <?php         
			          
			          } ?>
			           </tbody>
			          </table>
			            
			             <table class="table table-striped table-bordered account_index" border="1" cellpadding="3">
			             	<thead>
			             	<tr>
			             		<th><label style="border:none;">Material Type</label></th>
			             		<th><label style="border:none;">Material Name</label></th>
			             		<th><label style="border:none;">Material Quantity</label></th>
			             	</tr>
			               </thead>
			               <tbody>
			             <?php 
			             $preventivematerial =  json_decode($setperiventdmac->material_detail);

			             if(is_array($preventivematerial)){     
			          foreach($preventivematerial as $preventivematerials){
			                 
			                       $material_id=$preventivematerials->material_name;
									$materialName = getNameById('material',$material_id,'id'); 

									if(isset($preventivematerials->material_type)){
									$material_tid = $preventivematerials->material_type;
									$materialtyName = getNameById('material_type',$material_tid,'id');
									}

			               ?>
			              
			              <tr>
			              	<td><?php echo $materialtyName->name; ?></td>
			              	<td><?php echo $materialName->material_name; ?></td>
			              	<td><?php echo $preventivematerials->quantity; ?></td>
			              </tr>
			              
			           <?php         
			          
			          } 

			      }
			      ?>
			             </tbody>
			          </table>				

			<?php } ?>
				</div>
			</div>
			</div>

			</div>

			</form>

			<center>
				<button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
			</center>
		</div>
	</div>
  </div>



<!--*************Preventive*****************----->


  <div role="tabpanel" class="tab-pane fade" id="Complete_content_tab" aria-labelledby="complete_tab">
	<div class="x_content">
		<div id="print_div_content" class="table-responsive">
			<h3 class="Material-head">Preventive History<hr></h3>
			<div class="maindata_table">
				<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveAddMachine" enctype="multipart/form-data" id="add_machine" novalidate="novalidate">
		
					   <div class="col-md-12 col-sm-12 col-xs-12" id="print_divv"  style="padding:0px;">

		                </div>
				</form>
				<center>
				<button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
			</center>
			</div>
		</div>
	</div>
  </div>


<!--*************breakdown*****************----->

  <div role="tabpanel" class="tab-pane fade" id="Complete_breakdown_tab" aria-labelledby="complete_tab">
	<div class="x_content">
		<div id="print_div_content" class="table-responsive">
			<h3 class="Material-head">Breakdown History<hr></h3>
		        <div class="maindata_table">
					<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveAddMachine" enctype="multipart/form-data" id="add_machine" novalidate="novalidate">
					<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv"  style="padding:0px;">
                         <table class="table table-striped  table-bordered user_index">
                         	<thead>
                         		<tr>
                         		<td>Date</td>
                         		<td>Breakdown Causes</td>
                         		<td>Machine name</td>
                         		<td>Aknowledge Date</td>
                         		<td>Worker</td>
                         		<td>Work Status</td>
                         		<td>Correction Action</td>
                         	</tr>
                         	</thead>
                         	<tbody>
                         		<?php if(!empty($machine_history)){ ?> 
                         		<tr>
                         		<td><?php echo $machine_history->created_date; ?></td>
                         		<td><?php echo $machine_history->breakdown_couses; ?></td>
                         		<td><?php echo $machine_history->machine_name; ?></td>
                         		<td><?php echo $machine_history->acknowledge; ?></td>
                         		<td><?php echo $machine_history->assign_worker; ?></td>
                         		<td><?php  if($machine_history->work_status == 1){
                                                echo "Pending";
					                 		}else if($machine_history->work_status == 2){
					                               echo "Backlog";
					                 		}else if($machine_history->work_status == 3){
					                                echo "Repaired";
					                 		}
                         		?></td>
                         		<td><?php echo $machine_history->conective_entry; ?></td>
                         	</tr>
                         <?php } ?>
                         	</tbody>
                         	
                         </table>              
			        </div>
					</form>
					<center>
					<button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
				    </center>
			    </div>
		</div>
	</div>
  </div>


</div>
</div>






