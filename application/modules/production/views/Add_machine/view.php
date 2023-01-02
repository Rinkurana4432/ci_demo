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
                                     <label for="material">Work Station Name :</label>
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div><?php if(!empty($AddMachine)){ echo $AddMachine->machine_name; } ?></div>
									</div>
				</div>
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Work Station Code :</label>
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


<div class="container mt-3">
<h3 class="Material-head">Machine Process<hr></h3>

<div class="well dtailes" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">	

				<?php if(empty($AddMachine) || $AddMachine->process !=''){  
					echo '<div class="label-box"><div class="col-md-6 col-sm-12 col-xs-12 form-group"><label style="border-left:1px solid #c1c1c1 !important;">Product Type</label></div><div class="col-md-6 col-sm-12 col-xs-12 form-group"><label>Process</label></div></div>';
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


			 

			  
</div>	  
</div>
   <!--<div class="col-md-12 col-sm-12 col-xs-12">
      <table class="fixed data table table-bordered no-margin">
         <thead>				
         <tbody>
		  <tr>
			   <th>Machine Group:</th>
               <td><?php if(!empty($AddMachine) && $AddMachine->machine_group_id !=''){ 
							$machineGroup = getNameById('machine_group',$AddMachine->machine_group_id,'id');
			   echo (!empty($machineGroup))?$machineGroup->machine_group_name:'';  }?></td>
			</tr>
            <tr>
			   <th>Machine Name:</th>
               <td><?php if(!empty($AddMachine)){ echo $AddMachine->machine_name; } ?></td>
			</tr>
			   <tr><th>Machine Code:</th>
               <td><?php if(!empty($AddMachine)){ echo $AddMachine->machine_code; } ?></td>
			</tr>
			
			<tr>
				<th>Company Branch:</th>
				<td><?php if(!empty($AddMachine)){ echo $AddMachine->company_branch; } ?></td></tr>
				</tr><th>Department:</th>
				<td><?php 						
						if(!empty($AddMachine) && $AddMachine->department !=''){ 
							$departmentData = getNameById('department',$AddMachine->department,'id');
							echo (!empty($departmentData))?$departmentData->name:''; 										
					} ?>
				</td>
			</tr>
			
			<tr>
               
               <th>Preventive Maintenance:</th>
                <td><?php if(!empty($AddMachine)){ echo $AddMachine->preventive_maintenance; } ?></td>
            </tr>
            <tr>	
				<th>Machine Parameter:</th>
				<td>
				<?php if(empty($AddMachine) || $AddMachine->machine_parameter !=''){  ?>
					<table class="fixed data table table-bordered no-margin" border="1">
						<thead>
							<tbody>
								<tr>
								<th>Parameter</th>
								<th>UOm</th>
								</tr>
									<?php 
									   if(!empty($AddMachine) && $AddMachine->machine_parameter !=''){											
									   $machineParameter =  json_decode($AddMachine->machine_parameter);	
									   if(!empty($machineParameter)){									
									   foreach($machineParameter as $machine_Parameter){												
									   						
									?>		
								<tr>
								<td><?php echo $machine_Parameter->machine_parameter; ?><br /></td>
								<td><?php echo $machine_Parameter->uom;?><br /></td>
								</tr>
								<?php }  }                                   
								}?>
								
								
							</tbody>
							</thead>
						</table> 
						<?php } ?>
						</td>
			</tr>
			
			<tr>	
				<th>Machine Process:</th>
				<td>
				<?php if(empty($AddMachine) || $AddMachine->process !=''){  
					echo '<table class="fixed data table table-bordered no-margin" border="1"><thead><tbody><tr><th>Process Type</th><th>Process</th></tr>';
						if(!empty($AddMachine) && $AddMachine->process !=''){
							$machineProcessData =  json_decode($AddMachine->process);	
							if(!empty($machineProcessData)){									
								foreach($machineProcessData as $mcProcess){	
									echo '<tr><td>';
									if(!empty($AddMachine) && $mcProcess->process_type !=''){ 
										if(!empty($mcProcess) && $mcProcess->process_type !=''){ 
											$processType = getNameById('process_type',$mcProcess->process_type,'id');
										}
										echo $processType->process_type;
									}
									echo '<br /></td><td>';
									if(!empty($mcProcess) && $mcProcess->process!=''){
										$processData = getNameById('add_process',$mcProcess->process,'id');
										echo $processData->process_name;
									}	
									echo '<br /></td></tr>';
								}
							}                                   
						}								
							echo '</tbody></thead></table>';
						} ?>
				</td>
			</tr>
			
			
						<?php /*<tr>
							<th>Process Name:</th>
							<?php if(!empty($AddMachine)){							
							   $AddMachine->process_name;							
							$processName = getNameById('add_process',$AddMachine->process_name,'id'); }?>
						   <td><?php  if(!empty($processName)){echo $processName->process_name;} else {echo "NULL";}?></td>
						  
			</tr>*/?>
            <tr>	
               <th>Make & Model:</th>
			   <td><?php if(!empty($AddMachine)){ echo $AddMachine->make_model; } ?></td>	
            </tr>
            <tr>
               <th>Date Of Purchase:</th>
               <td><?php if(!empty($AddMachine)){ echo date("j F , Y", strtotime($AddMachine->year_purchase)); } ?></td></tr>
			   <tr>
			   <th>Placement:</th>
				<td><?php if(!empty($AddMachine)){ echo $AddMachine->placement; } ?></td>
            </tr>
          
			
         </tbody>
         </thead>		
      </table>
	
   
      
   </div>-->
</div>
</form>

<center>
	<button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
</center>