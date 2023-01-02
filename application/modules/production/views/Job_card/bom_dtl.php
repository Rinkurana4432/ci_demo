<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv"  style="padding:0px;"> 
	<div class="table-responsive" >
	<?php 
		//$parts = explode('_', $bom_View->job_card_no);
		//echo '<pre>';print_r($parts);
		//$mat_id =  end($parts);
		$mat_name = getNameById('material', $bom_View->id,'job_card');
	
	?>
		<h3 class="Material-head"><?php echo $mat_name->material_name; ?> BOM<hr></h3>
		<div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<label for="material">Material Code :</label>
				<div class="col-md-7 col-sm-12 col-xs-12 form-group">
					<div><?php echo $mat_name->material_code;?></div>
				</div>
			</div>
			
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="material">Process Type :</label>
				<div class="col-md-7 col-sm-12 col-xs-12 form-group">
					<div><?php if(!empty($bom_View) && $bom_View!=''){
						$processType = getNameById('process_type',$bom_View->process_type,'id');
							if(!empty($processType)){
								echo $processType->process_type; 
							}
						} ?>
					</div>
				</div>
			</div>
			
		</div>
		
	<hr>
	<div class="bottom-bdr"></div>		  
	<div class="container mt-3">
		<div class="well" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">	
			<div class="label-box">
				<div class="col-md-12" style="padding: 0px; border-left: 1px solid #c1c1c1;"><label style="background: #f5f5f5;font-size: 16px;">Materials  </label></div>

					<div class="col-md-3 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Material Type</label></div>
					<div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material name</label></div>
					<div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Quantity / UOM</label></div>			   
					<div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Average Cost</label></div>			   
			</div>
	

			<?php
		
				if(!empty($bom_View) && $bom_View->machine_details !=''){
					$input_process_dtls =  json_decode($bom_View->machine_details);
						
					foreach($input_process_dtls as $processDetail){
						$inp_process = 	json_decode($processDetail->input_process,true);
						$i=1;
						foreach($inp_process as $in_val){
							$mat_type_name = getNameById('material_type',$in_val['material_type_input_id'],'id');	
							$mat_name = getNameById('material',$in_val['material_input_name'],'id');
							//pre($in_val);
						?>

			<div class="row-padding" id="app_<?php echo $i; ?>" >
			    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
					<div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"><?php  if(empty($in_val)){echo ""; } else {echo $mat_type_name->name; }?></div>
				</div>

			    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
					<div style="border-left:1px solid #c1c1c1 !important;" class="tab-div get_mat_data_id_cls" data-id="<?php echo $mat_name->id;  ?>">
						<?php  if(empty($in_val)){echo ""; } else {echo $mat_name->material_name; }?>
					</div>
				</div>
				
				
			
				<div class="col-md-3 col-sm-12 col-xs-12 form-group">
					<div  class="tab-div"><?php  echo $in_val['quantity_input'] . ' / ' . $in_val['uom_value_input'];  ?></div>
				</div>
				<div class="col-md-3 col-sm-12 col-xs-12 form-group">
					<div  class="tab-div"><?php  
						 $cost_in = $in_val['quantity_input'] * $mat_name->cost_price; 
						 echo $cost_in;
						 $sum += $cost_in;
						 
					?>
					<input type="hidden" value="<?php echo $cost_in; ?>" class="cost_cls"> 
					</div>
				</div>
				<div class="col-md-12">
					<div class="append_cls"></div>
				</div>
				
			</div>
						
				
			<?php 
			
			$i++;	
			}
		
		}
		
		?>
		
<?php } ?>
					
				
			</div>
			<div class="col-md-12">
			   <div class="col-md-9">Total</div>
			   <div class="col-md-3 Grnd_total" ><?php echo $sum; ?></div>
			   
			</div>
		</div>
	</div>
</div>
<!--center>
	<button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
	
</center-->
