<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv"  style="padding:0px;">
   <div class="table-responsive" >
      <h3 class="Material-head">
         BOM Routing
         <hr>
      </h3>
      <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">BOM Routing Number :</label>
            <div class="col-md-7 col-sm-12 col-xs-12 form-group">
               <div><?php if(!empty($jobView)){ echo $jobView->job_card_no; } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">BOM Routing Product Name :</label>
            <div class="col-md-7 col-sm-12 col-xs-12 form-group">
               <div ><b><?php if(!empty($jobView)){ echo $jobView->job_card_product_name; } ?></b></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Party Code :</label>
            <div class="col-md-7 col-sm-12 col-xs-12 form-group">
               <div ><?php if(!empty($jobView)){ echo $jobView->party_code; } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Product Name :</label>
            <div class="col-md-7 col-sm-12 col-xs-12 form-group">
               <div><?php if(!empty($jobView) && $jobView!=''){
                  $processType = getNameById('process_type',$jobView->process_type,'id');
                  	if(!empty($processType)){
                  		echo $processType->process_type; 
                  	}
                  } ?>
               </div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Product specification :</label>
            <div class="col-md-7 col-sm-12 col-xs-12 form-group">
               <div><?php if(!empty($jobView)){ echo $jobView->product_specification; } ?></div>
            </div>
         </div>
      </div>
      <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
         <!--<div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Material Type :</label>
            <div class="col-md-7 col-sm-12 col-xs-12 form-group">
             <?php if(!empty($jobView)){			
               $material_type=getNameById('material_type',$jobView->material_type_id,'id');
               }
                ?>
            	<div><?php if(!empty($material_type)){echo $material_type->name;} else{echo "";} ?></div>
            </div>
            </div>-->
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Lot Quantity :</label>
            <div class="col-md-7 col-sm-12 col-xs-12 form-group">
              <?php $lotuom = getNameById('uom',$jobView->lot_uom,'id'); 
              $uomlot = !empty($lotuom)?$lotuom->uom_quantity:'';
              ?>
               <div><?php if(!empty($jobView) && $jobView->lot_qty!=0){ echo $jobView->lot_qty."/".$uomlot; } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Test Certificate :</label>
            <div class="col-md-7 col-sm-12 col-xs-12 form-group">
               <div><?php if(!empty($jobView)){ echo $jobView->test_certificate; } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Party requirement :</label>
            <div class="col-md-7 col-sm-12 col-xs-12 form-group">
               <div><?php if(!empty($jobView)){ echo $jobView->party_requirement; } ?></div>
            </div>
         </div>
      </div>
      <hr>
      <div class="bottom-bdr"></div>
      <div class="container mt-3">
         <div class="well" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">
            <div class="label-box">
               <div class="col-md-12" style="padding: 0px; border-left: 1px solid #c1c1c1;"><label style="background: #f5f5f5;font-size: 16px;">Material Details</label></div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Material Type</label></div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material name</label></div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Qauntity</label></div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>UOM</label></div>
            </div>
            <?php 
               if(!empty($jobView) && $jobView->material_details !=''){
               	$material_detail =  json_decode($jobView->material_details);
               	foreach($material_detail as $matDetail){
               
               		$ww =  getNameById('uom', $matDetail->unit,'id');
               	    $uom = !empty($ww)?$ww->ugc_code:'';
               		
               		$material_id=$matDetail->material_name_id;
               		$materialName=getNameById('material',$material_id,'id'); 
               
               
               		if(isset($matDetail->material_type_id)){
               		$material_tid = $matDetail->material_type_id;
               		$materialtyName = getNameById('material_type',$material_tid,'id');
               		}
               
               		?>
            <div class="row-padding">
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                  <div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"><?php  if(empty($materialtyName)){echo ""; } else {echo $materialtyName->name; }?></div>
               </div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                  <div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"><?php  if(empty($materialName)){echo ""; } else {echo $materialName->material_name; }?></div>
               </div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                  <div  class="tab-div"><?php  echo $matDetail->quantity;  ?></div>
               </div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                  <div  class="tab-div"><?php  echo $uom;  ?></div>
               </div>
            </div>
            <?php }
               }					
               ?>
         </div>
      </div>

      <?php /* new view start */ ?>


<div class="container mt-3">
<div class="well" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">
<div class="label-box">
<div class="col-md-12" style="padding: 0px; border-left: 1px solid #c1c1c1;">
<label style="background: #f5f5f5;font-size: 16px;">Process Details</label>
</div>
<div class="col-md-3 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Process name</label></div>
<div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Setup Time</label></div>
<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Machining Time</label></div>
<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Labour Cost</label></div>
<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Action</label></div>
</div>
<div class="row-padding">
<?php
$Detailinfo = json_decode($jobView->machine_details);
$j =1;
if(!empty($Detailinfo)){
foreach($Detailinfo as $detail_info){
$parmeterName = $detail_info->parameter??'';
$uom = $detail_info->uom??'';
$values = $detail_info->value??'';
$document = (!empty($detail_info->doc) && isset($detail_info->doc))?$detail_info->doc:'';
$machine_paramenters = !empty($detail_info->machine_details)?json_decode($detail_info->machine_details):'';
?>
<div class="col-md-3 col-sm-12 col-xs-12 form-group">
<div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"><?php
$processName = getNameById('add_process',$detail_info->processess,'id');
echo $processName->process_name;
?></div>
</div>

<?php  if(!empty($machine_paramenters)){
$mach = 1;
$cc = 0;
foreach($machine_paramenters as $value){
foreach ($value->machine_id as $key => $value1) {
if($mach == 1){
?>

<div class="col-md-3 col-sm-12 col-xs-12 form-group">
<div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"><?php 
if(!empty($value->hr_set->$value1)){
$hr_set = $value->hr_set->$value1;
} else {
$hr_set = '00';
}
if(!empty($value->mm_set->$value1)){
$mm_set = $value->mm_set->$value1;
} else {
$mm_set = '00';
}
if(!empty($value->sec_set->$value1)){
$sec_set = $value->sec_set->$value1;
} else {
$sec_set = '00';
}
echo $hr_set.':'.$mm_set.':'.$sec_set;  ?></div>
</div>
<div class="col-md-2 col-sm-12 col-xs-12 form-group">
<div class="tab-div"><?php
if(!empty($value->mt_hr_set->$value1)){
$mt_hr_set = $value->mt_hr_set->$value1;
} else {
$mt_hr_set = "00";
}
if(!empty($value->mt_mm_set->$value1)){
$mt_mm_set = $value->mt_mm_set->$value1;
} else {
$mt_mm_set = '00';
}
if(!empty($value->mt_sec_set->$value1)){
$mt_sec_set = $value->mt_sec_set->$value1;
} else {
$mt_sec_set = '00';
}
echo $mt_hr_set.':'.$mt_mm_set.':'.$mt_sec_set;  ?></div>
</div>
<div class="col-md-2 col-sm-12 col-xs-12 form-group">
<div class="tab-div"><?php if(!empty($value->per_unit_cost->$value1)) echo $value->per_unit_cost->$value1; ?></div>
</div>
<?php } $mach++; $cc++;} } } ?>

<div class="col-md-2 col-sm-12 col-xs-12 form-group">
<div class="tab-div" style="text-align: center;"><a href="javascript:void(0)" class="btn btn-view btn-xs productionTab set_process_id" data-id="routingView" data-title="<?php echo $processName->process_name; ?>" data-tooltip="View" data-toggle="modal" id="<?php echo $jobView->id.' ~ '.$detail_info->processess.' ~ '.$j; ?>" data-chkval="<?php echo $jobView->id; ?>" data-index-id="<?php echo $j; ?>"><i class="fa fa-eye"></i></a></div>
</div>
<?php $j++; } } ?>
</div>
</div>
</div>

      <?php /* new view end */ ?>

      <?php /* old view start

      <div class="container mt-3">
         <?php 
            $paravalue = $Uomvalue = '';
            if(!empty($jobView) && $jobView->machine_details !=''){											
            	$machine_description =  json_decode($jobView->machine_details);
            
            		foreach($machine_description as $machineDesc){
            			$parameters = (isset($machineDesc->parameter))?$machineDesc->parameter:'';
            			$parameterLength = (!empty($parameters))?count($parameters):0;
            			$process_Id = $machineDesc->processess;
            			$processName = getNameById('add_process',$process_Id,'id');	
            			#$process_TypeId = $machineDesc->process_type_id;
            			#$processType = getNameById('process_type',$process_TypeId,'id');	
            			$machine_name = (isset($machineDesc->machine_name))?$machineDesc->machine_name:'';
            			$machineName = getNameById('add_machine',$machine_name,'id');	
						$machine_paramenters = !empty($machineDesc->machine_details)?json_decode($machineDesc->machine_details):'';
            //  pre($machine_paramenters);die;
                if(!empty($machine_paramenters)){  ?>
         <div class="Process-card">
            <h3 class="Material-head">
               <div class="test-hadding">
                  Product Name : 
                  <p><?php  if(empty($processName)){echo "";} else{echo $processName->process_name; } ?></p>
               </div>
               <hr>
            </h3>
            <div style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">
               <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <label>Description :</label>
                     <div class="col-md-7"><?php if(isset($machineDesc->description) && !empty($machineDesc->description)){ echo $machineDesc->description;  }  ?> </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="col-md-6 label-left" style=" margin-bottom:20px; border-right: 1px solid;">
                  <label style="width: 100%; text-align: center;">Do's </label>
                  <div class="col-md-12">
                     <div>  <?php if(!empty($machineDesc)){ echo $machineDesc->dos;  }  ?></div>
                  </div>
               </div>
               <div class="col-md-6 label-left" style="  margin-bottom:20px;">
                  <label style="width: 100%;   text-align: center;">Don'ts </label>				
                  <div class=" col-md-12">
                     <div><?php if(!empty($machineDesc)){ echo $machineDesc->donts;  }  ?> </div>
                  </div>
               </div>
            </div>
            <?php if(!empty($machineDesc)){ 
               if(!empty($machineDesc->doc)){
               ?>
            <div class="col-md-8 col-xs-12 col-sm-12 " style="margin-top: 12px;" >
               <div class="col-md-12 label-left">
                  <label style="width: auto;padding-top: 12px;font-size: 15px;">Attachments :</label>	
                  <div class="col-md-6 col-xs-12 col-sm-12"> 
                     <?php 
                        foreach($machineDesc->doc as $documents){
                        	if(!empty($documents)){
                        	echo '<div class="col-md-3"><img style="display: block; width: 60px; height: 60px;" src="'.base_url().'assets/modules/production/uploads/'.$documents.'" alt="image" class="undo" /></div>';
                        	}
                        }
                        
                        ?>
                  </div>
               </div>
            </div>
            <?php } } ?>			  
            <div class="well Paramenter " id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">
			<div class="col-md-12" style="padding: 0px; border-left: 1px solid #c1c1c1;"><label style="background: #f5f5f5;font-size: 16px;">Machine Details</label></div>
               <div class="label-box">
                  
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Machine Name</label></div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Paramenter</label></div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Production Per Shift</label></div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Workers</label></div>
               </div>
               <?php 
                  foreach($machine_paramenters as $value){ 
                  $machine_info = getNameById('add_machine',$value->machine_id,'id'); 
                  ?> 
               <div class="row-padding">
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <div ><?php echo $machine_info->machine_name; ?></div>
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     
                        <?php foreach($value->parameter_detials as $parameter){ ?>	
                        <div class="peramertors"><div class="col-md-4"><?php echo $parameter->parameter_name;?></div><div class="col-md-4"> <?php #echo $parameter->parameter_uom;

                                                   $ww =  getNameById('uom', $parameter->parameter_uom,'id');
                                                         $uom = !empty($ww)?$ww->ugc_code:'';

                                                         echo $uom;
                        ?></div><div class="col-md-4"><?php echo $parameter->uom_value;?></div></div>
                        <?php } ?>
                    
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <div><?php if(!empty($value->production_shift)) echo $value->production_shift; ?></div>
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <div><?php if(!empty($value->workers)) echo $value->workers; ?></div>
                  </div>
               </div>
               <?php } ?>
            </div>
            <?php $input_procss = json_decode($machineDesc->input_process,true);
               $output_procss = json_decode($machineDesc->output_process,true); 
			   
		   ?>
            <div class="well" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">
               <div class="label-box">
                  <div class="col-md-12" style="padding: 0px; border-left: 1px solid #c1c1c1;"><label style="background: #f5f5f5;font-size: 16px;">Input Material Details</label></div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Material Type</label></div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material name</label></div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Qauntity</label></div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>UOM</label></div>
               </div>
               <?php foreach($input_procss as $input){ ?>
                 <?php #pre($input); ?> 
               <div class="row-padding">
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"><?php 
					 $material_type_inputid = getNameById('material_type',$input['material_type_input_id'],'id');
					 if(!empty($material_type_inputid->name)) echo $material_type_inputid->name; ?></div>
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"><?php 
					  $materialName_input = getNameById('material',$input['material_input_name'],'id');
					 if(!empty($materialName_input->material_name)) echo $materialName_input->material_name; ?></div>
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <div class="tab-div"><?php if(!empty($input['quantity_input'])) echo $input['quantity_input']; ?></div>
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <div class="tab-div"><?php if(!empty($input['uom_value_input1'])) echo $input['uom_value_input1']; ?>  <?php #if(!empty($input['uom_value_input'])) echo $input['uom_value_input']; ?></div>
                  </div>
               </div>
               <?php } ?>
            </div>
            <div class="well" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">
               <div class="label-box">
                  <div class="col-md-12" style="padding: 0px; border-left: 1px solid #c1c1c1;"><label style="background: #f5f5f5;font-size: 16px;">Output Material Details</label></div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Material Type</label></div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material name</label></div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Qauntity</label></div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>UOM</label></div>
               </div>
               <?php foreach($output_procss as $output){ ?>
                    <div class="row-padding">
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"><?php 
					 $material_type_inputid = getNameById('material_type',$output['material_type_output_id'],'id');
					 if(!empty($material_type_inputid->name)) echo $material_type_inputid->name; ?></div>
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"><?php 
					  $materialName_input = getNameById('material',$output['material_output_name'],'id');
					 if(!empty($materialName_input->material_name)) echo $materialName_input->material_name; ?></div>
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <div class="tab-div"><?php if(!empty($output['quantity_output'])) echo $output['quantity_output']; ?></div>
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <div class="tab-div"><?php if(!empty($output['uom_value_output1'])) echo $output['uom_value_output1']; ?>  <?php #if(!empty($output['uom_value_output'])) echo $output['uom_value_output']; ?></div>
                  </div>
               </div>
               <?php } ?>
            </div>
         </div>
         <?php  }else{ ?>
         <div class="Process-card">
            <h3 class="Material-head">
               <div class="test-hadding">
                  Process Name : 
                  <p><?php  if(empty($processName)){echo "";} else{echo $processName->process_name; } ?></p>
               </div>
               <hr>
            </h3>
            <div style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">
               <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <label >Shift :</label>
                     <div class="col-md-7" ><?php if(!empty($machineDesc)){ echo @$machineDesc->production_shift;  }  ?></div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <label>Machine Name :</label>
                     <div  class="col-md-7">
                        <?php if(empty($machineName)){echo "";}else{ echo @$machineName->machine_name; } ?>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
                  <div class="col-md-12 col-sm-12 form-group">
                     <label>Workers :</label>
                     <div  class="col-md-7"><?php if(!empty($machineDesc)){ echo @$machineDesc->workers;  }  ?></div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <label>Description :</label>
                     <div  class="col-md-7"><?php if(isset($machineDesc->description) && !empty($machineDesc->description)){ echo $machineDesc->description;  }  ?></div>
                  </div>
               </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12" id="chkIndex_1" style=" padding:0px; border-radius: 0px !important; margin-bottom: 15px;">	
               <?php if(!empty($machineDesc->parameter)){
                  echo '<div class="label-box"><div class="col-md-12" style="padding: 0px; border-left: 1px solid #c1c1c1;"><label style="background: #f5f5f5;font-size: 16px;">Parameter</label></div><div class="col-md-4 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Parameter</label></div><div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>UOM</label></div><div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Value</label></div></div>';
                  	for($i=0; $i<$parameterLength; $i++){
                  
                  		$ww =  getNameById('uom', $machineDesc->uom[$i],'id');
                  		$uom = !empty($ww)?$ww->ugc_code:'';
                  		echo '<div class="row-padding"><div class="col-md-4 col-sm-12 col-xs-12 form-group" ><div style="border-left:1px solid #c1c1c1 !important;" class="tab-div">'.$machineDesc->parameter[$i].'</div></div><div class="col-md-4 col-sm-12 col-xs-12 form-group"><div  class="tab-div">'.$uom.'</div></div><div class="col-md-4 col-sm-12 col-xs-12 form-group"><div  class="tab-div">'.$machineDesc->value[$i].'</div></div></div>';	
                  	}	
                  }  ?>
            </div>
            <div class="col-md-12" >
               <div class="col-md-6 label-left" style=" margin-bottom:20px; border-right: 1px solid;" >
                  <label style="width: 100%; text-align: center;">Do's </label>
                  <div class="col-md-12">
                     <div> <?php if(!empty($machineDesc)){ echo $machineDesc->dos;  }  ?></div>
                  </div>
               </div>
               <div class="col-md-6 label-left" style="  margin-bottom:20px;"  >
                  <label style="width: 100%;   text-align: center;">Don'ts </label>				
                  <div class=" col-md-12">
                     <div><?php if(!empty($machineDesc)){ echo $machineDesc->donts;  }  ?></div>
                  </div>
               </div>
            </div>
            <?php 
               //$input_procss = json_decode($machineDesc->input_process,true);
              // $output_procss = json_decode($machineDesc->output_process,true);
               
               //pre($output_procss);
               ?>
            <?php if(!empty($machineDesc)){ 
               if(!empty($machineDesc->doc)){
               ?>
            <div class="col-md-8 col-xs-12 col-sm-12 " style="margin-top: 12px;" >
               <div class="col-md-12 label-left">
                  <label style="width: auto;padding-top: 12px;font-size: 15px;">Attachments :</label>	
                  <div class="col-md-6 col-xs-12 col-sm-12"> 
                     <?php 
                        foreach($machineDesc->doc as $documents){
                        	if(!empty($documents)){
                        	echo '<div class="col-md-3"><img style="display: block; width: 60px; height: 60px;" src="'.base_url().'assets/modules/production/uploads/'.$documents.'" alt="image" class="undo" /></div>';
                        	}
                        }
                        
                        ?>
                  </div>
               </div>
            </div>
            <?php } } ?>
         </div>
         <?php 	}
            }   } ?>
      </div> 
   
      old view end
      */ ?>
   </div>
</div>
<center>
   <!--button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button-->
   <?php /* if ((!empty($jobView) && $jobView->save_status == 1) || empty($jobView)) { ?>
   <a href="<?php echo base_url(); ?>production/create_pdf/<?php echo $jobView->id; ?>" target="_blank"><button class="btn edit-end-btn">Generate PDF</button></a>
   <?php } */ ?>
</center>