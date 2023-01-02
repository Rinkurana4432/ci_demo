<form method="post" class="form-horizontal" action="" id="add_machine" novalidate="novalidate">
            <input type="hidden" name="id" value="<?php if($AddMachine && !empty($AddMachine)){ echo $AddMachine->id;} ?>">
			
<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv"  style="padding:0px;"> 
		<div class="table-responsive" >
		     

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


			 

			  
</div>	  
</div>
  
</div>
</form>
