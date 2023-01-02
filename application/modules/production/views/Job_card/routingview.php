<?php
$j =$index_id;
if(!empty($machine_detail_data)){
$detail_info = $machine_detail_data;
$parmeterName = $detail_info->parameter??'';

$uom = $detail_info->uom??'';
$values = $detail_info->value??'';
$document = (!empty($detail_info->doc) && isset($detail_info->doc))?$detail_info->doc:'';
$machine_paramenters = !empty($detail_info->machine_details)?json_decode($detail_info->machine_details):''; ?>
<div class="well  well2 <?php if($j==1){ echo 'edit-row1';}else{ echo 'scend-tr';}?>" id="chckIndex_<?php echo $j; ?>" data-id="frst_div_<?php echo $j; ?>">

<div class="box-div ">
<div class="container">
<ul class="nav tab-3 nav-tabs">
<li class="active"><a data-toggle="tab" href="#other_details_set" aria-expanded="true">Other Details</a></li>
<li class=""><a data-toggle="tab" href="#machine_parameter_set" aria-expanded="true">Machine Parameter</a></li>
<!--li class=""><a data-toggle="tab" href="#input_mat_set" aria-expanded="true">Input Material</a></li-->
<li class=""><a data-toggle="tab" href="#output_mat_set" aria-expanded="false">Output Material</a></li>
</ul>
</div>

<!---Tab Penal Start-->
<form id="routing_process_detail" action="">
 <input type="hidden" class="total_rows_set" name="total_rows_set" value="<?php  echo count((array)$machine_paramenters[0]->parameter_detials); ?>">
<div class="tab-content"> 

<!---Other Details Tab Start-->

<div id="other_details_set" class="tab-pane fade  active in" style="padding:20px;">
<h3 class="Material-head">Other Details<hr></h3>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
<div class="item form-group col-md-12">
<label class="col-md-3 col-sm-12 col-xs-12">Description1</label>
<div class="col-md-6 col-sm-12 col-xs-12">
<span><?php if(!empty($detail_info) && isset($detail_info->description)) echo $detail_info->description; ?></span>
</div>
</div> 
<div class="item form-group col-md-12">
<label class="col-md-3 col-sm-12 col-xs-12">Attachment</label>
</div>
<?php if(!empty($document)){
//pre($document);
foreach(json_decode($document) as $doc){
if(!empty($doc)){
echo '<div class="col-md-3 col-xs-3 col-sm-3"><img style="display: block; width: 100%;" src="'.base_url().'assets/modules/production/uploads/'.$doc.'" alt="image" class="undo" /></div>';
}else{

echo '<div class="col-md-3 col-xs-3 col-sm-3"><img style="display: block; width: 100%;" src="'.base_url().'assets/modules/production/uploads/no-image-available.jpg" alt="image" class="undo" ></div>';
}
}
}?>  
</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
<div class="item form-group col-md-12">
<label class="col-md-3 col-sm-12 col-xs-12">Do's</label>
<div class="col-md-6 col-sm-12 col-xs-12">
<span><?php if(!empty($detail_info)) echo $detail_info->dos; ?></span>
</div>
</div>
<div class="item form-group col-md-12">
<label class="col-md-3 col-sm-12 col-xs-12">Dont's</label>
<div class="col-md-6 col-sm-12 col-xs-12">
<span><?php if(!empty($detail_info)) echo $detail_info->donts; ?></span>
</div>
</div>
</div>
</div>

<!---Other Details Tab End-->

<!---Machine Parameter Tab -->
<div id="machine_parameter_set" class="tab-pane fade " style="padding:20px;">
<div class="container mt-3">
<div class="well" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">
<div class="label-box">
<div class="col-md-12" style="padding: 0px; border-left: 1px solid #c1c1c1;">
<label style="background: #f5f5f5;font-size: 16px;">Machine Parameter</label>
</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Machine name</label></div>
<div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Machine Parameter</label></div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Production per Shift</label></div>
<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Setup Time(hr:min:sec)</label></div>
<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Machine Time</label></div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Workers</label></div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Total Cost</label></div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Per Unit Cost</label></div>
</div>
<?php  if(!empty($machine_paramenters)){
$mach = 1;
$cc = 0;
foreach($machine_paramenters as $value){
foreach ($value->machine_id as $key => $value1) {
?>
<div class="row-padding" style="width: 100%; display: inline-block;">
<div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border: 1px solid #ccc;padding: 10px 10px 9px 10px;">
<span><?php
$machine_info = getNameById('add_machine',$value->machine_id->$value1,'id');
echo $machine_info->machine_name;
?></span>
</div>
<div class="col-md-3 col-sm-12 col-xs-12 form-group" style="border: 1px solid #ccc;padding: 10px 10px 9px 10px;">
<?php foreach($value->parameter_detials as $key => $parameter1){
if($value->machine_id->$value1 == $key){
$ch=0;
foreach($parameter1 as $parameter){
$ww =  getNameById('uom', $parameter->parameter_uom,'id');
$uom = !empty($ww)?$ww->ugc_code:'';
?>
<span style="background: #ccc;padding: 5px 5px 5px 5px;"><?php echo $parameter->parameter_name;?></span>
<span style="background: #ccc;padding: 5px 5px 5px 5px;"><?php echo $uom;?></span>
<span><?php echo $parameter->uom_value;?>  </span>
<?php  $ch++; if($ch >= 1){ echo "<br><br>";} } } } ?>
</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border: 1px solid #ccc;padding: 10px 10px 9px 10px;">
<span><?php if(!empty($value->production_shift->$value1)) echo $value->production_shift->$value1; ?></span>
</div>
<div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border: 1px solid #ccc;padding: 10px 10px 9px 10px;">
<span>
<?php 
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
echo $hr_set.':'.$mm_set.':'.$sec_set;  ?></span>
</div>
<div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border: 1px solid #ccc;padding: 10px 10px 9px 10px;">
<span><?php
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
echo $mt_hr_set.':'.$mt_mm_set.':'.$mt_sec_set;  ?></span>
</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border: 1px solid #ccc;padding: 10px 10px 9px 10px;">
<span><?php if(!empty($value->workers->$value1)) echo $value->workers->$value1; ?></span>
</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border: 1px solid #ccc;padding: 10px 10px 9px 10px;">
<span><?php if(!empty($value->avg_salary->$value1)) echo $value->avg_salary->$value1; ?></span>
</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border: 1px solid #ccc;padding: 10px 10px 28px 10px;">
<span style="display: none;"><?php if(!empty($value->total_cost->$value1)) echo $value->total_cost->$value1; ?></span>
<span><?php if(!empty($value->per_unit_cost->$value1)) echo $value->per_unit_cost->$value1; ?></span>
</div>
</div>
<?php $mach++; $cc++;} } } ?>


</div>
</div>
</div>


<!---Machine Parameter Tab End-->

<!---Input Tab Start-->
<div id="input_mat_set" class="tab-pane fade" style="padding:20px;"> 
<h3 class="Material-head">INPUT<hr></h3>
<?php

$input_process_dtl = (!empty($detail_info->input_process) && isset($detail_info->input_process))?$detail_info->input_process:'';

$process_sch_input = json_decode($input_process_dtl);
?>
<?php
if(!empty($process_sch_input)){
echo'<div>
  <label class="col col-md-3 col-xs-12 col-sm-12">Material Type</label>
  <label class="col col-md-3 col-xs-12 col-sm-12">Material Name</label>
  <label class="col col-md-3 col-xs-12 col-sm-12">Quantity</label>
  <label class="col col-md-3 col-xs-12 col-sm-12">UOM</label>
</div><div class="well_Sech_input">';
$in = 1;

$countin = count($process_sch_input);
foreach($process_sch_input as $val_input_sech){
$material_id_input = $val_input_sech->material_input_name;
$materialName_input = getNameById('material',$material_id_input,'id');

?>
   
     <div class="col-md-12 input_cls chk_idd_input" id="sechIndexinput_<?php echo $in; ?>">
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
           <!--label>Material Type</label-->
           <select disabled="disabled" class="form-control material_type_id" name="material_type_input_id[<?php echo $in; ?>]" id="material_type_input_id_<?php echo $j; ?>" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this),updateProcessId(event,this)" id="material_type">
              <option value="">Select Option</option>
              <?php
                    if(!empty($val_input_sech)){
                       $material_type_inputid = getNameById('material_type',$val_input_sech->material_type_input_id,'id');
                       echo '<option value="'.$val_input_sech->material_type_input_id.'" selected>'.$material_type_inputid->name.'</option>';
                    }
                    ?>
           </select>

        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
           <!--label>Material Name</label-->
           <select disabled="disabled" class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_input_name[<?php echo $in; ?>]" id="material_input_name_1" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $JobCard->material_type_id;?>  AND status=1" onchange="getUom_input(event,this);">
              <option value="">Select Option</option>
              <?php
echo '<option value="'.$val_input_sech->material_input_name.'" selected>'.$materialName_input->material_name.'</option>';
?>
           </select>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
           <!--label>Quantity</label-->
           <input  readonly="readonly" type="text" name="quantity_input[<?php echo $in; ?>]" id="quantity_input_1" class="form-control col-md-7 col-xs-12  qty_input actual_qty" placeholder="Qty." value="<?php echo $val_input_sech->quantity_input; ?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"> </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
           <!--label>UOM</label-->
           <?php
//pre($val_input_sech);
$ww =  getNameById('uom', $val_input_sech->uom_value_input,'id');
$uom = !empty($ww)?$ww->ugc_code:'';
?>
              <input type="text" name="uom_value_input1[<?php echo $in; ?>]" id="uom_value_input1_1" class="form-control col-md-7 col-xs-12  uom_input" placeholder="uom." value="<?php echo $uom; ?>" readonly>
              <input type="hidden" name="uom_value_input[<?php echo $in; ?>]" id="uom_value_input_1" class="uom_input_val" readonly value="<?php  echo $val_input_sech->uom_value_input; ?>"> </div>

     </div>
  
  <?php   $in++;} ?> </div> <?php  } ?>
</div>

<!---Input Tab End-->

<!---Output Tab Start-->

<div id="output_mat_set" class="tab-pane fade " style="padding:20px;">
     <h3 class="Material-head">OUTPUT<hr></h3>
<?php
$output_process_dtl = (!empty($detail_info->output_process) && isset($detail_info->output_process))?$detail_info->output_process:'';
$process_sch_output = json_decode($output_process_dtl);
?>
        <?php
if(!empty($process_sch_output)){
echo'<div>
           <label class="col col-md-3 col-xs-12 col-sm-12">Material Type</label>
           <label class="col col-md-3 col-xs-12 col-sm-12">Material Name</label>
           <label class="col col-md-3 col-xs-12 col-sm-12">Quantity</label>
           <label class="col col-md-3 col-xs-12 col-sm-12">UOM</label>
        </div> <div class="well_Sech_output">';
$ot = 1;
$countout= count($process_sch_output);
foreach($process_sch_output as $val_output_sech){
$material_id_output = $val_output_sech->material_output_name;
$materialName_output = getNameById('material',$material_id_output,'id');

?>
          
              <div class="col-md-12 output_cls chk_idd_output " id="sechIndexoutput_<?php echo $j; ?>" style="padding: 0px;">
                 <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                    <!--label>Material Type</label-->
                    <select disabled="disabled" class="form-control material_type_id" name="material_type_output_id[<?php echo $ot; ?>]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)">
                       <option value="">Select Option</option>
                       <?php  
if(!empty($val_output_sech) && isset($val_output_sech->material_type_output_id)){
$material_type_outputid = getNameById('material_type',$val_output_sech->material_type_output_id,'id');
echo '<option value="'.$val_output_sech->material_type_output_id.'" selected>'.$material_type_outputid->name.'</option>';
}
?>
                    </select>
                 </div>
                 <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                    <!--label>Material Name</label-->
                    <select disabled="disabled" class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_output_name[<?php echo $ot; ?>]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $JobCard->material_type_id;?>  AND status=1" onchange="getUom_output(event,this);">
                       <option value="">Select Option</option>
                       <?php
echo '<option value="'.$val_output_sech->material_output_name.'" selected>'.$materialName_output->material_name.'</option>';
              ?>
                    </select>
                 </div>
                 <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                    <!--label>Quantity</label-->
                    <input readonly="readonly" type="text" name="quantity_output[<?php echo $ot; ?>]" class="form-control col-md-7 col-xs-12  qty_output actual_qty" placeholder="Qty." value="<?php echo $val_output_sech->quantity_output; ?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"> </div>
                 <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                    <!--label>UOM</label-->
                    <?php
$ww_output =  getNameById('uom', $val_output_sech->uom_value_output,'id');
$uom_output = !empty($ww_output)?$ww_output->ugc_code:'';
?>
                       <input type="text" name="uom_value_output1[<?php echo $ot; ?>]" class="form-control col-md-7 col-xs-12  uom_output" placeholder="uom." value="<?php echo $uom_output; ?>" readonly>
                       <input type="hidden" name="uom_value_output[<?php echo $ot; ?>]" class="uom_output_val" readonly value="<?php echo $val_output_sech->uom_value_output; ?>"> </div>

              </div>
           
           <?php $ot++;  } ?> </div><?php  }?>
</div>

<!---Output Tab End-->

</div>

<!---Tab Penal End-->
</form>
</div>
</div>

<div class="col-md-12 col-xs-12">
<center>
<button type="button" class="btn edit-end-btn close_modal2" data-dismiss="modal">Close</button>
</center>
</div>



<?php  }  ?>
