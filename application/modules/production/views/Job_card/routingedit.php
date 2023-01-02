<style>
.table-bordered .select2-container--default .select2-selection--single {
    height: 30px !important;
    border-radius: 0px;
    border: 1px solid #aaa;
}
#routing_process_detail button.btn.edit-end-btn.add_moreoutputss, #routing_process_detail button.btn.btn-danger {
    background-color: #313f4d;
    color: #fff;
}
</style>
<?php
$j =$index_id;
if(!empty($machine_detail_data)){
$job_card_no = $JobCard->job_card_no;
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
<form id="routing_process_detail" action="" enctype="multipart/form-data">
 <input type="hidden" class="total_rows_set" name="total_rows_set" value="<?php  echo count((array)$machine_paramenters[0]->parameter_detials); ?>">
<div class="tab-content"> 

<!---Other Details Tab Start-->

<div id="other_details_set" class="tab-pane fade  active in" style="padding:20px;">
<h3 class="Material-head">Other Details<hr></h3>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
<div class="item form-group col-md-12">
<label class="col-md-3 col-sm-12 col-xs-12">Description</label>
<div class="col-md-6 col-sm-12 col-xs-12">
<textarea name="description" class="form-control col-md-7 col-xs-12 textarea" placeholder="Description"><?php if(!empty($detail_info) && isset($detail_info->description)) echo $detail_info->description; ?></textarea>
</div>
</div> 
<div class="item form-group col-md-12">
<label class="col-md-3 col-sm-12 col-xs-12">Attachment</label>
<div class="col-md-6 col-sm-12 col-xs-12">
<input type="hidden" name="old_doc_<?php echo $j; ?>" value='<?php if(!empty($detail_info) && !empty($detail_info->doc)){ echo json_encode($detail_info->doc); } ?>'>
<!--<input type="hidden" name="old_doc[]" value=''>-->
<div class="col-md-12 col-sm-12 col-xs-12 add_documents">
<div class="col-md-10 col-sm-12 col-xs-10 form-group doc" id="abc_1">
<input type="file" class="form-control col-md-7 col-xs-12">
<input type="hidden" class="file_name form-control col-md-7 col-xs-12" name="documentsAttach[1]" value="">
 </div>
<button class="btn edit-end-btn  add_moreDocs" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
</div>
</div>
</div>
<?php if(!empty($document)){
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
<textarea name="dos" class="form-control col-md-7 col-xs-12 textarea" placeholder="Do's" rows="3"><?php if(!empty($detail_info)) echo $detail_info->dos; ?></textarea>
</div>
</div>
<div class="item form-group col-md-12">
<label class="col-md-3 col-sm-12 col-xs-12">Dont's</label>
<div class="col-md-6 col-sm-12 col-xs-12">
<textarea name="donts" class="form-control col-md-7 col-xs-12 textarea" placeholder=" Dont's" rows="3"><?php if(!empty($detail_info)) echo $detail_info->donts; ?></textarea>
</div>
</div>
</div>
</div>

<!---Other Details Tab End-->

<!---Machine Parameter Tab -->

<div id="machine_parameter_set" class="tab-pane fade " style="padding:20px;">
<h3 class="Material-head">Machine Parameter<hr></h3>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border" style="display:none;">
<div class="item form-group ">
<label class="col-md-3 col-sm-12 col-xs-12">Process Name</label>
<div class="col-md-6 col-sm-12 col-xs-12">
  <select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id select2" name="process_name" tabindex="-1" aria-hidden="true" onchange="getMachineName(event,this),updateInputProcess(event,this)" data-id="add_process" data-key="id" data-fieldname="process_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND process_type_id = <?php echo $process_type_id;?>">
     <option value="">Select Option</option>
     <?php
$processName = getNameById('add_process',$detail_info->processess,'id');
echo '<option value="'.$detail_info->processess.'" selected>'.$processName->process_name.'</option>';
?>
  </select>
</div>
</div>
</div>
<div class="well col-container " style="display:table; clear:both; border-bottom:1px solid #c1c1c1;">
<?php  if(!empty($machine_paramenters)){
$mach = 1;
$cc = 0;
foreach($machine_paramenters as $value){
foreach ($value->machine_id as $key => $value1) {
?>
<div class="total_machines_ids" id="ParameterIndexinput_<?php echo $mach ?>">
   <input class="selected_mid" type="hidden" name="<?php echo $value->machine_id->$value1;?>" value="<?php echo $value->machine_id->$value1;?>">
  <div class="item form-group  col-md-1 col-xs-12">
   <?php if($mach == 1){ ?>
     <div class="col">
        <label>Machine name</label>
     </div>
  <?php } ?>
     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <div class="col-md-12 col-sm-6 col-xs-12 form-group machine_name_dispaly">
           <select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id" name="machine_name[<?php echo $mach ?>]" tabindex="-1" aria-hidden="true" data-id="add_machine" data-key="id" data-fieldname="machine_name" data-where="process LIKE &apos;%&quot;process&quot;:&quot;<?php echo $detail_info->processess;?>&quot;%&apos; AND save_status=1"  onchange="getMaterialName(event,this)">
              <option value="">Select Option</option>
              <?php
$machine_info = getNameById('add_machine',$value->machine_id->$value1,'id');
echo '<option value="'.$value->machine_id->$value1.'" selected>'.$machine_info->machine_name.'</option>';
?>
           </select>
        </div>
     </div>
  </div>
  <div class="item form-group col-md-2  col-xs-12">
   <?php if($mach == 1){ ?>
     <div class="col">
        <label>Machine Parameter</label>
     </div>
  <?php } ?>
     <div class="MachineParameterReplacement">
        <?php foreach($value->parameter_detials as $key => $parameter1){
         if($value->machine_id->$value1 == $key){
         $ch=0;
         foreach($parameter1 as $parameter){
           //pre($val_input_sech);
                 $ww =  getNameById('uom', $parameter->parameter_uom,'id');
                 $uom = !empty($ww)?$ww->ugc_code:'';
           ?>
           <input type="hidden" name="<?php echo $value->machine_id->$value1;?>" value="<?php echo $value->machine_id->$value1;?>">
           <div class="col-md-4 col-sm-6 col-xs-4 form-group">
              <div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name">
                 <input type="hidden" name="mp_length[<?php echo $value->machine_id->$value1;?>][0]" value="<?php echo count((array)$parameter1); ?>"><input type="text" class="form-control col-md-7 col-xs-12 parameter" name="parameter[<?php echo $value->machine_id->$value1;?>][0][<?php echo $ch ?>]" value="<?php echo $parameter->parameter_name;?>" readonly> </div>
           </div>
           <div class="col-md-4 col-sm-6 col-xs-4 form-group">
              <div class="col-md-12 col-sm-6 col-xs-12 form-group uom">
                 <input type="hidden" value="<?php echo $parameter->parameter_uom;?>" class="form-control col-md-7 col-xs-12 uom" name="uom[<?php echo $value->machine_id->$value1;?>][0][<?php echo $ch ?>]" readonly>

                 <input type="text" value="<?php echo $uom;?>" class="form-control col-md-7 col-xs-12 uom" name="" readonly>
              </div>
           </div>
           <div class="col-md-4 col-sm-6 col-xs-4 form-group">
              <div class="col-md-12 col-sm-6 col-xs-12 form-group value">
                 <input type="text" value="<?php echo $parameter->uom_value;?>" class="form-control col-md-7 col-xs-12 value" name="value[<?php echo $value->machine_id->$value1;?>][0][<?php echo $ch ?>]"> </div>
           </div>
           <?php  $ch++; } } } ?>
     </div>
  </div>
  <div class="item form-group  col-md-1 col-xs-12">
   <?php if($mach == 1){ ?>
     <div class="col">
        <label>Production per Shift</label>
     </div>
  <?php } ?>
     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="text" name="production_shift[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12 production_shift" placeholder="production per Shift" value="<?php if(!empty($value->production_shift->$value1)) echo $value->production_shift->$value1; ?>">
        <br>
        <br> </div>
  </div>
  <div class="item form-group  col-md-2 col-xs-12">
   <?php if($mach == 1){ ?>
     <div class="col">
        <label>Setup Time(hr:min:sec)</label>
     </div>
  <?php } ?>
     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="text" name="setup_hr[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 32%;" placeholder="HR" value="<?php if(!empty($value->hr_set->$value1)) echo $value->hr_set->$value1; ?>">
      <select name="setup_min[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 30%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option value="<?php echo sprintf("%02d", $i); ?>" <?php if(!empty($value->mm_set->$value1) && $value->mm_set->$value1 == $i ) echo "selected"; ?>><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
      <select name="setup_sec[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 30%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option <?php if(!empty($value->sec_set->$value1) && $value->sec_set->$value1 == $i ) echo "selected"; ?> value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
      <!--input type="time" name="setup_min[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 60%;" placeholder="MIN:SEC"-->
        <br>
        <br> </div>
  </div>
  <div class="item form-group  col-md-2 col-xs-12">
   <?php if($mach == 1){ ?>
     <div class="col">
        <label>Machine Time</label>
     </div>
  <?php } ?>
  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="text" name="machine_time_hr[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 32%;" placeholder="HR" value="<?php if(!empty($value->mt_hr_set->$value1)) echo $value->mt_hr_set->$value1; ?>">
      <select name="machine_time_min[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 30%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option value="<?php echo sprintf("%02d", $i); ?>" <?php if(!empty($value->mt_mm_set->$value1) && $value->mt_mm_set->$value1 == $i ) echo "selected"; ?>><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
      <select name="machine_time_sec[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 30%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option <?php if(!empty($value->mt_sec_set->$value1) && $value->mt_sec_set->$value1 == $i ) echo "selected"; ?> value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
        <br>
        <br> </div>
     <!--div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="text" name="machine_time[<?php //echo $mach ?>]" value="<?php //if(!empty($value->machine_time->$value1)) echo $value->machine_time->$value1; ?>" class="form-control col-md-7 col-xs-12 machine_time" placeholder="Machine Time">
        <br>
        <br> </div-->
  </div>
  <div class="item form-group  col-md-1 col-xs-12">
   <?php if($mach == 1){ ?>
     <div class="col">
        <label>Workers</label>
     </div>
  <?php } ?>
     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="text" name="workers[<?php echo $mach ?>]" value="<?php if(!empty($value->workers->$value1)) echo $value->workers->$value1; ?>" class="form-control col-md-7 col-xs-12 workers" placeholder="workers">
        <br>
        <br> </div>
  </div>
  <div class="item form-group  col-md-1 col-xs-12">
   <?php if($mach == 1){ ?>
     <div class="col">
        <label>Avg Salary</label>
     </div>
  <?php } ?>
     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="text" name="avg_salary[<?php echo $mach ?>]" value="<?php if(!empty($value->avg_salary->$value1)) echo $value->avg_salary->$value1; ?>" class="form-control col-md-7 col-xs-12 avg_salary" placeholder="Avg Salary">
        <br>
        <br> </div>
  </div>

  <div class="item form-group  col-md-1 col-xs-12">
   <?php if($mach == 1){ ?>
     <div class="col">
        <label>Total Cost</label>
     </div>
  <?php } ?>
     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input readonly="readonly" type="text" name="total_cost[<?php echo $mach ?>]" value="<?php if(!empty($value->total_cost->$value1)) echo $value->total_cost->$value1; ?>" class="form-control col-md-7 col-xs-12 total_cost" placeholder="Total Cost">
        <br>
        <br> </div>
  </div>


  <div class="item form-group  col-md-1 col-xs-12">
   <?php if($mach == 1){ ?>
     <div class="col">
        <label>Per Unit Cost</label>
     </div>
  <?php } ?>
     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input readonly="readonly" type="text" name="per_unit_cost[<?php echo $mach ?>]" value="<?php echo $value->per_unit_cost->$value1; ?>" class="form-control col-md-7 col-xs-12 per_unit_cost" placeholder="Per Unit Cost">
        <br>
        <br> </div>
  </div>
  <?php if($mach== 1){ ?>
     <div class="item form-group  col-md-1 col-xs-12">
      <?php if($mach == 1){ ?>
        <div class="col">
           <label>Action</label>
        </div>
     <?php } ?>
        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
           <button class="btn edit-end-btn  addmachineForProcesstype" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
        </div>
     </div>
     <?php }else{ ?>
        <div class="item form-group  col-md-1 col-xs-12 RemovemachineForProcesstype">
         <?php if($mach == 1){ ?>
           <div class="col">
              <label>Action</label>
           </div>
        <?php } ?>
           <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
              <button class="btn edit-end-btn " style="margin-bottom: 3%;" type="button"><i class="fa fa-minus"></i></button>
           </div>
        </div>
        <?php } ?>
</div>
<?php $mach++; $cc++;} } }else{
//pre($detail_info);die;
?>
  <div class="total_machines_ids" id="ParameterIndexinput_1">
   <input class="selected_mid" type="hidden" name="<?php echo $detail_info->machine_name;?>" value="<?php echo $detail_info->machine_name;?>">
     <div class="item form-group  col-md-1 col-xs-12">
        <div class="col">
           <label>Machine name</label>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
           <div class="col-md-12 col-sm-6 col-xs-12 form-group machine_name_dispaly">
              <select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id" name="machine_name[1]" tabindex="-1" aria-hidden="true" data-id="add_machine" data-key="id" data-fieldname="machine_name" data-where="process LIKE &apos;%&quot;process&quot;:&quot;<?php echo $detail_info->processess;?>&quot;%&apos; AND save_status=1"  onchange="getMaterialName(event,this)">
                 <option value="">Select Option</option>
                 <?php
$machine_info = getNameById('add_machine',$detail_info->machine_name,'id');
echo '<option value="'.$detail_info->machine_name.'" selected>'.$machine_info->machine_name.'</option>';
?>
              </select>
           </div>
        </div>
     </div>
     <div class="item form-group col-md-2 col-xs-12">
        <div class="col">
           <label>Machine Parameter</label>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4  form-group" style="border-right: 1px solid #c1c1c1;">
           <div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name form-group">
             <input type="hidden" class="selected_mid" name="<?php echo $detail_info->machine_name;?>" value="<?php echo $detail_info->machine_name;?>">
              <?php
if(!empty($parmeterName)){
foreach($parmeterName as $parameter_names){ ?>
                 <input type="text" class="form-control col-md-7 col-xs-12" name="parameter[<?php echo $detail_info->machine_name;?>][0][0]" value="<?php echo $parameter_names;?>" readonly>
                 <?php }}?>
           </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4  form-group" style="border-right: 1px solid #c1c1c1;">
           <div class="col-md-12 col-sm-6 col-xs-12 form-group uom">
              <?php
if(!empty($uom)){
//pre($uom);
foreach($uom as $uom_values){
?>
                 <input type="text" value="<?php echo $uom_values; ?>" class="form-control col-md-7 col-xs-12" name="uom[<?php echo $detail_info->machine_name;?>][0][0]" readonly>
                 <?php }}?>
           </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4  form-group">
           <div class="col-md-12 col-sm-6 col-xs-12 form-group value">
              <?php
if(!empty($values)){
foreach($values as $values_get){

?>
                 <input type="text" value="<?php  echo $values_get; ?>" class="form-control col-md-7 col-xs-12" name="value[<?php echo $detail_info->machine_name;?>][0][0]">
                 <?php }} ?>
           </div>
        </div>
     </div>
     <div class="item form-group  col-md-1 col-xs-12">
        <div class="col">
           <label>Production per Shift</label>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
           <input type="text" name="production_shift[1]" value="<?php if(!empty($detail_info)) echo $detail_info->production_shift; ?>" class="form-control col-md-7 col-xs-12 production_shift" placeholder="production per Shift">
           <br>
           <br> </div>
     </div>
     <div class="item form-group  col-md-2 col-xs-12">
     <div class="col">
        <label>Setup Time(hr:min:sec)</label>
     </div>
     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="text" name="setup_hr[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 32%;" placeholder="HR" value="<?php if(!empty($value->hr_set->$value1)) echo $value->hr_set->$value1; ?>">
      <select name="setup_min[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 30%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option value="<?php echo sprintf("%02d", $i); ?>" <?php if(!empty($value->mm_set->$value1) && $value->mm_set->$value1 == $i ) echo "selected"; ?>><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
      <select name="setup_sec[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 30%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option <?php if(!empty($value->sec_set->$value1) && $value->sec_set->$value1 == $i ) echo "selected"; ?> value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
      <!--input type="time" name="setup_min[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 60%;" placeholder="MIN:SEC"-->
        <br>
        <br> </div>
  </div>
  <div class="item form-group  col-md-2 col-xs-12">
     <div class="col">
        <label>Machine Time</label>
     </div>
  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="text" name="machine_time_hr[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 32%;" placeholder="HR" value="<?php if(!empty($value->mt_hr_set->$value1)) echo $value->mt_hr_set->$value1; ?>">
      <select name="machine_time_min[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 30%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option value="<?php echo sprintf("%02d", $i); ?>" <?php if(!empty($value->mt_mm_set->$value1) && $value->mt_mm_set->$value1 == $i ) echo "selected"; ?>><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
      <select name="machine_time_sec[<?php echo $mach ?>]" class="form-control col-md-7 col-xs-12" style="width: 30%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option <?php if(!empty($value->mt_sec_set->$value1) && $value->mt_sec_set->$value1 == $i ) echo "selected"; ?> value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
        <br>
        <br> </div>
     <!--div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="text" name="machine_time[<?php //echo $mach ?>]" value="<?php //if(!empty($value->machine_time->$value1)) echo $value->machine_time->$value1; ?>" class="form-control col-md-7 col-xs-12 machine_time" placeholder="Machine Time">
        <br>
        <br> </div-->
  </div>
     <div class="item form-group  col-md-1 col-xs-12">
        <div class="col">
           <label>Workers</label>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
           <input type="text" name="workers[1]" class="form-control col-md-7 col-xs-12 workers" value="<?php if(!empty($detail_info)) echo $detail_info->workers; ?>" placeholder="workers">
           <br>
           <br> </div>
     </div>
      <div class="item form-group  col-md-1 col-xs-12">
        <div class="col">
           <label>Avg Salary</label>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
           <input type="text" name="avg_salary[1]" class="form-control col-md-7 col-xs-12 avg_salary" value="<?php if(!empty($detail_info)) echo $detail_info->avg_salary; ?>" placeholder="Avg Salary">
           <br>
           <br> </div>
     </div>

     <div class="item form-group  col-md-1 col-xs-12">
        <div class="col">
           <label>Total Cost</label>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
           <input readonly="readonly" type="text" name="total_cost[1]" class="form-control col-md-7 col-xs-12 total_cost" value="<?php if(!empty($detail_info)) echo $detail_info->total_cost; ?>" placeholder="Total Cost">
           <br>
           <br> </div>
     </div>


     <div class="item form-group  col-md-1 col-xs-12">
        <div class="col">
           <label>Per Unit Cost</label>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
           <input readonly="readonly" type="text" name="per_unit_cost[1]" class="form-control col-md-7 col-xs-12 per_unit_cost" value="<?php if(!empty($detail_info)) echo $detail_info->per_unit_cost; ?>" placeholder="Per Unit Cost">
           <br>
           <br> </div>
     </div>
     <div class="item form-group  col-md-1 col-xs-12">
        <div class="col">
           <label>Action</label>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;border-bottom: 1px solid #aaa;">
           <button class="btn edit-end-btn  addmachineForProcesstype" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
        </div>
     </div>
  </div>
  <?php } ?>
</div>

</div>

<!---Machine Parameter Tab End-->

<!---Input Tab Start-->
<?php /*
<div id="input_mat_set" class="tab-pane fade" style="padding:20px;"> 
<h3 class="Material-head">INPUT<hr></h3>
<?php

$input_process_dtl = (!empty($detail_info->input_process) && isset($detail_info->input_process))?$detail_info->input_process:'';

$process_sch_input = json_decode($input_process_dtl);
?>

<?php
if(empty($process_sch_input)){ ?>
     <div class=" col-md-12 well_Sech_input" style="padding:0px;">
<div class="col-md-12 input_cls chk_idd_input" id="sechIndexinput_<?php echo $j; ?>" style="padding:0px;">
<div class="col-md-3 col-sm-12 col-xs-12 form-group">
<label class="col col-md-12 col-xs-12 col-sm-12">Material Type</label>
<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 material_type_input_id_<?php echo $j; ?>" name="material_type_input_id[1]" id="material_type_input_id_<?php echo $j; ?>"  data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)">
  <option value="">Select Option</option>
</select>
</div>
<div class="col-md-3 col-sm-12 col-xs-12 form-group">
<label class="col col-md-12 col-xs-12 col-sm-12">Material Name</label>
<select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot material_input_name_1" name="material_input_name[1]" id="material_input_name_1" onchange="getUom_input(event,this);">
  <option value="">Select Option</option>
</select>
</div>
<div class="col-md-3 col-sm-12 col-xs-12 form-group">
<label class="col col-md-12 col-xs-12 col-sm-12">Quantity</label>
<input type="text" name="quantity_input[1]" id="quantity_input_1" class="form-control col-md-7 col-xs-12  qty_input actual_qty quantity_input_1" placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"> </div>
<div class="col-md-2 col-sm-12 col-xs-12 form-group">
<label class="col col-md-12 col-xs-12 col-sm-12">UOM</label>
<input type="text" name="uom_value_input1[1]" id="uom_value_input1_1" class="form-control col-md-7 col-xs-12  uom_input uom_value_input1_1" placeholder="uom." value="" readonly>
<input type="hidden" name="uom_value_input[1]" id="uom_value_input_1" class="uom_input_val uom_value_input_1" readonly value=""> </div>
<div class="col-md-1 col-xs-12 col-sm-12 form-group" style="text-align: center;border-bottom: 1px solid #aaa;">
<label class="col col-md-12 col-xs-12 col-sm-12" style="padding: 17px 6px;"></label>
<button class="btn edit-end-btn  add_moreinputss" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
</div>
</div>
</div>
<?php }?>
<?php
if(!empty($process_sch_input)){
echo'<div>
  <label class="col col-md-3 col-xs-12 col-sm-12">Material Type</label>
  <label class="col col-md-3 col-xs-12 col-sm-12">Material Name</label>
  <label class="col col-md-3 col-xs-12 col-sm-12">Quantity</label>
  <label class="col col-md-2 col-xs-12 col-sm-12">UOM</label>
  <label class="col col-md-1 col-xs-12 col-sm-12" style="padding: 17px 6px;"></label>
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
           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="material_type_input_id[<?php echo $in; ?>]" id="material_type_input_id_<?php echo $j; ?>" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this),updateProcessId(event,this)" id="material_type">
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
           <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_input_name[<?php echo $in; ?>]" id="material_input_name_1" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $JobCard->material_type_id;?>  AND status=1" onchange="getUom_input(event,this);">
              <option value="">Select Option</option>
              <?php
echo '<option value="'.$val_input_sech->material_input_name.'" selected>'.$materialName_input->material_name.'</option>';
?>
           </select>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
           <!--label>Quantity</label-->
           <input type="text" name="quantity_input[<?php echo $in; ?>]" id="quantity_input_1" class="form-control col-md-7 col-xs-12  qty_input actual_qty" placeholder="Qty." value="<?php echo $val_input_sech->quantity_input; ?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"> </div>
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
           <!--label>UOM</label-->
           <?php
//pre($val_input_sech);
$ww =  getNameById('uom', $val_input_sech->uom_value_input,'id');
$uom = !empty($ww)?$ww->ugc_code:'';
?>
              <input type="text" name="uom_value_input1[<?php echo $in; ?>]" id="uom_value_input1_1" class="form-control col-md-7 col-xs-12  uom_input" placeholder="uom." value="<?php echo $uom; ?>" readonly>
              <input type="hidden" name="uom_value_input[<?php echo $in; ?>]" id="uom_value_input_1" class="uom_input_val" readonly value="<?php  echo $val_input_sech->uom_value_input; ?>"> </div>
      <?php   if($in==1){
echo '<div class="col-md-1 col-xs-12 col-sm-12 form-group" style="text-align: center;border-bottom: 1px solid #aaa;">
           <button class="btn edit-end-btn  add_moreinputss" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button></div>';
}else{
echo '<div class="col-md-1 col-xs-12 col-sm-12 form-group remv_inputss" style="text-align: center;border-bottom: 1px solid #aaa;"><button class="btn btn-danger " type="button"><i class="fa fa-times" aria-hidden="true"></i></button></div>';
} ?>
     </div>
  
  <?php   $in++;} ?> </div> <?php  } ?>
</div>
*/ ?>
<!---Input Tab End-->

<!---Output Tab Start-->

<div id="output_mat_set" class="tab-pane fade " style="padding:20px;">
     <h3 class="Material-head">OUTPUT<hr></h3>
<?php
$output_process_dtl = (!empty($detail_info->output_process) && isset($detail_info->output_process))?$detail_info->output_process:'';
$output_process_dtl = trim($output_process_dtl,'"');
$process_sch_output = json_decode($output_process_dtl);
?>






<?php
if(empty($process_sch_output)){ ?>
     <table class=" table table-striped table-bordered well_Sech_output" style="padding:0px;">
      <tr>
        <th><label>Material Type</label></th>
        <th><label>Material Name</label></th>
        <th> <label>Quantity</label></th>
        <th><label>UOM</label></th>
        <th style="width: 10%;">Price</th>
        <th style="width: 10%;">Total</th>
        <th><label>Sub Bom</label></th>
        <th><label>Action</label></th>
     </tr>
      <tr class="output_cls chk_idd_output" id="sechIndexoutput_<?php echo $j; ?>" style="padding:0px;">
         <td class="col-md-2 col-sm-12 col-xs-12 form-group">
           <div style="display:flex;"> <div class="expand_dropwon form-group">
          <span class="up_arrow" style="display: none;"><i style="font-size: 20px;font-weight: bold;"  onclick="expandOutputMat(event,this);" jc_number="" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span><span style="display: none;" class="down_arrow"><i onclick="expandOutputMat(event,this);" jc_number="" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span>
          </div>
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="material_type_output_id[1]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)">
               <option value="">Select Option</option>
            </select>
         </div>
         </td>
         <td class="col-md-2 col-sm-12 col-xs-12 form-group">
            
            <select class="materialNameId_sechIndexoutput_<?php echo $j; ?> materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_output_name[1]" onchange="getUom_output(event,this);   getOutputsubBom(event,this);">
               <option value="">Select Option</option>
            </select>
         </td>
         <td class="col-md-2 col-sm-12 col-xs-12 form-group">
           
            <input type="text" name="quantity_output[1]" class="form-control col-md-7 col-xs-12  qty_output actual_qty" placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"> </td>
         <td class="col-md-2 col-sm-12 col-xs-12 form-group">
            
            <input type="text" name="uom_value_output1[1]" class="form-control col-md-7 col-xs-12  uom_output" placeholder="uom." value="" readonly>
            <input type="hidden" name="uom_value_output[1]" class="uom_output_val" readonly value=""> </td>
         <td></td>
         <td></td>
         <td class="col-md-2 col-sm-12 col-xs-12 form-group">
         
         <input style="border-right: 1px solid #c1c1c1 !important;" type="text" id="sub_bom" class="form-control col-md-7 col-xs-12  total" placeholder="Sub-BOM" value="" readonly> 
         </td>
         <td class="col-md-1 col-xs-12 col-sm-12 form-group" style="text-align: center;border-bottom: 1px solid #aaa;">
           
            <button class="btn edit-end-btn  add_moreoutputss" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
         </td>
         <div class="expand_out_sechIndexoutput_<?php echo $j; ?>"></div>
      </tr>
   </table>
<?php }?>









        <?php
if(!empty($process_sch_output)){
echo'
 <table class="table table-bordered">
<tr>
           <th>Material Type</th>
           <th>Material Name</th>
           <th>Quantity</th>
           <th>UOM</th>
           <th style="width:150px;"></th>
           <th style="width:150px;"></th>
           <th>Sub Bom</th>
           <th style="width: 3%;">Action</th>
        </tr> ';
$ot = 1;
$countout= count($process_sch_output);
foreach($process_sch_output as $val_output_sech){
$material_id_output = $val_output_sech->material_output_name;
$materialName_output = getNameById('material',$material_id_output,'id');
$job_data = getNameById('job_card', $materialName_output->job_card,'id');
?>
          
              <tr class="output_cls chk_idd_output " id="sechIndexoutput_<?php echo $ot; ?>" style="padding: 0px;">
                 <td>
             <div style="display: flex;">
             <div class="expand_dropwon form-group">
               <?php if(!empty($materialName_output) && $materialName_output->job_card!=0 && !empty($job_data)){ ?> 
               <span class="2 up_arrow" style="display: none;"><i style="font-size: 20px;font-weight: bold;" onclick="expandOutputMat(event,this);" jc_number="<?php echo $job_data->job_card_no;  ?>" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span>
               <span class="down_arrow"><i onclick="expandOutputMat(event,this);" jc_number="<?php echo $job_data->job_card_no;  ?>" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span>
               <?php } else { ?>
               <span class="2 up_arrow" style="display: none;"><i style="font-size: 20px;font-weight: bold;" onclick="expandOutputMat(event,this);" jc_number="<?php echo $job_data->job_card_no;  ?>" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span>
               <span class="down_arrow" style="display: none;"><i onclick="expandOutputMat(event,this);" jc_number="<?php echo $job_data->job_card_no;  ?>" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span>
               <?php } ?>
               </div>
                    <!--label>Material Type</label-->
                    <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="material_type_output_id[<?php echo $ot; ?>]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)">
                       <option value="">Select Option</option>
                       <?php  
                  if(!empty($val_output_sech) && isset($val_output_sech->material_type_output_id)){
                  $material_type_outputid = getNameById('material_type',$val_output_sech->material_type_output_id,'id');
                  echo '<option value="'.$val_output_sech->material_type_output_id.'" selected>'.$material_type_outputid->name.'</option>';
                  }
                  ?>
                    </select>
                   </div>
                 </td>
                 <td >
                    <!--label>Material Name</label-->
                    <select class="materialNameId_sechIndexoutput_<?php echo $ot; ?> materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_output_name[<?php echo $ot; ?>]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $JobCard->material_type_id;?>  AND status=1" onchange="getUom_output(event,this);   getOutputsubBom(event,this);">
                       <option value="">Select Option</option>
                       <?php
echo '<option value="'.$val_output_sech->material_output_name.'" selected>'.$materialName_output->material_name.'</option>';
              ?>
                    </select>
                 </td>
                 <td >
                    <!--label>Quantity</label-->
                    <input type="text" name="quantity_output[<?php echo $ot; ?>]" class="form-control col-md-7 col-xs-12  qty_output actual_qty material_qty_sechIndexoutput_<?php echo $j; ?>" placeholder="Qty." value="<?php echo $val_output_sech->quantity_output; ?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"> </td>
                 <td>
                    <!--label>UOM</label-->
                    <?php
$ww_output =  getNameById('uom', $val_output_sech->uom_value_output,'id');
$uom_output = !empty($ww_output)?$ww_output->ugc_code:'';
?>
                       <input type="text" name="uom_value_output1[<?php echo $ot; ?>]" class="form-control col-md-7 col-xs-12  uom_output" placeholder="uom." value="<?php echo $uom_output; ?>" readonly>
                       <input type="hidden" name="uom_value_output[<?php echo $ot; ?>]" class="uom_output_val" readonly value="<?php echo $val_output_sech->uom_value_output; ?>"> </td>
                       <td></td><td></td><td>
                                       <input style="border-right: 1px solid #c1c1c1 !important;" type="text" id="sub_bom" class="form-control col-md-7 col-xs-12  total" placeholder="Sub-BOM" value="<?php if(!empty($materialName_output) && $materialName_output->job_card!=0 && !empty($job_data)){
                                         echo $job_data->job_card_no;
                                       } else {  echo "N/A";  } ?>" readonly> </td>
<td>
                       <?php   if($ot==1){
echo '<div class="col-md-2 col-xs-12 col-sm-12 form-group" style="text-align: center;border-bottom: 1px solid #aaa;">
                    <button class="btn edit-end-btn  add_moreoutputss" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
                 </div>';
}else{
// echo "ssssadasd";
echo '<div class="col-md-1 col-xs-12 col-sm-12 form-group remv_output" style="text-align: center;border-bottom: 1px solid #aaa;"><button class="btn btn-danger " type="button"><i class="fa fa-times" aria-hidden="true"></i></button></div>';
} ?>
</td>
              </tr>
           
           <?php $ot++;  } ?> </div><?php  }?>


<!---Output Tab End-->
</table>
</div>

<!---Tab Penal End-->
</form>
</div>
</div>

<div class="col-md-12 col-xs-12">
<center>
<button type="button" class="btn edit-end-btn close_modal2" data-dismiss="modal">Close</button>
<button id="continue_routing" type="button" data-setid="<?php echo $index_id; ?>" class="btn edit-end-btn continue_routing">Click Continue For Routing</button>
</center>
</div>



<?php  } else { ?>

<div class="well well2" id="chckIndex_<?php echo $j; ?>" data-id="frst_div_<?php echo $j; ?>">

<div class="box-div">
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
<input type="hidden" class="total_rows_set" name="total_rows_set" value="1">
<div class="tab-content">  

<!---Other Details Tab Start-->
<div id="other_details_set" class="tab-pane fade  active in" style="padding:20px;">
<h3 class="Material-head">Other Details<hr></h3>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
<div class="item form-group col-md-12 ">
<label class="col-md-3 col-sm-12 col-xs-12">Description</label>
<div class="col-md-6 col-sm-12 col-xs-12">
<textarea name="description" class="form-control col-md-7 col-xs-12 textarea" placeholder="Description"></textarea>
</div>
</div>
<div class="item form-group col-md-12 ">
<label class="col-md-3 col-sm-12 col-xs-12">Attachment</label>
<div class="col-md-6 col-sm-12 col-xs-12">
<input type="hidden" name="old_doc_1" value=''>
<!--<input type="hidden" name="old_doc[]" value=''>-->
<div class="col-md-12 col-sm-12 col-xs-12 add_documents">
<div class="col-md-10 col-sm-12 col-xs-10 form-group doc" id="abc_<?php echo $j; ?>">
<input type="file" class="form-control col-md-7 col-xs-12 documentsAttach_frst_div_<?php echo $j; ?>" name="documentsAttach" value=""> </div>
<button class="btn edit-end-btn  add_moreDocs" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
</div>
</div>
</div>   
</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
<div class="item form-group col-md-12 ">
<label class="col-md-3 col-sm-12 col-xs-12">Do's</label>
<div class="col-md-6 col-sm-12 col-xs-12">
<textarea name="dos" class="form-control col-md-7 col-xs-12 textarea" placeholder="Do's"></textarea>
</div>
</div>
<div class="item form-group col-md-12 ">
<label class="col-md-3 col-sm-12 col-xs-12">Dont's</label>
<div class="col-md-6 col-sm-12 col-xs-12">
<textarea name="donts" class="form-control col-md-7 col-xs-12 textarea" placeholder=" Dont's"></textarea>
</div>
</div>
</div>


</div>

<!---Other Details Tab End-->

<!---Machine Parameter Tab -->

<div id="machine_parameter_set" class="tab-pane fade " style="padding:20px;">
<h3 class="Material-head">Machine Parameter<hr></h3>
<div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border" style="display:none;">
      <div class="item form-group ">
         <label class="col-md-3 col-sm-12 col-xs-12">Process Name<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id input-2" name="process_name" tabindex="-1" aria-hidden="true" onchange="getMachineName(event,this),updateInputProcess(event,this)" id="process_name_id" data-where="process_type_id=<?php echo $process_type_id;?>" data-id="add_process" data-key="id" data-fieldname="process_name">
               <option value="">Select Option</option>
               <?php
         $processName = getNameById('add_process',$process_id,'id');
         echo '<option value="'.$process_id.'" selected>'.$processName->process_name.'</option>';
   ?>
            </select>
         </div>
      </div>
   </div>
</div>
<div class="well col-container " style="display:table; clear:both; border-bottom:1px solid #c1c1c1;">
   <div class="total_machines_ids" id="ParameterIndexinput_<?php echo $j; ?>">
      <input class="selected_mid" type="hidden" name="<?php echo $detail_info->machine_name;?>" value="<?php echo $detail_info->machine_name;?>">
      <div class="item form-group  col-md-1 col-xs-12">
         <div class="col">
            <label>Machine name</label>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <div class="col-md-12 col-sm-6 col-xs-12 form-group machine_name_dispaly">
               <select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id" name="machine_name[1]" tabindex="-1" aria-hidden="true" data-id="add_machine" data-key="id" data-fieldname="machine_name" data-where="process LIKE &apos;%&quot;process&quot;:&quot;<?php echo $process_id;?>&quot;%&apos; AND save_status=1"  onchange="getMaterialName(event,this)">
                  <option value="">Select Option</option>
               </select>
            </div>
         </div>
      </div>
      <div class="item form-group col-md-2 col-xs-12">
         <div class="col">
            <label>Machine Parameter</label>
         </div>
         <div class="col-md-4 col-sm-4 col-xs-4  form-group" style="border-right: 1px solid #c1c1c1;">
            <div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name form-group"></div>
         </div>
         <div class="col-md-4 col-sm-4 col-xs-4  form-group" style="border-right: 1px solid #c1c1c1;">
            <div class="col-md-12 col-sm-6 col-xs-12 form-group uom"></div>
         </div>
         <div class="col-md-4 col-sm-4 col-xs-4  form-group">
            <div class="col-md-12 col-sm-6 col-xs-12 form-group value"></div>
         </div>
      </div>
      <div class="item form-group  col-md-1 col-xs-12">
         <div class="col">
            <label>Production per Shift</label>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" name="production_shift[1]" class="form-control col-md-7 col-xs-12 production_shift" placeholder="production per Shift">
            <br>
            <br> </div>
      </div>

      <div class="item form-group  col-md-2 col-xs-12">
     <div class="col">
        <label>Setup Time(hr:min:sec)</label>
     </div>
     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="text" name="setup_hr[1]" class="form-control col-md-7 col-xs-12" style="width: 32%;" placeholder="HR" value="">
      <select name="setup_min[1]" class="form-control col-md-7 col-xs-12" style="width: 30%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
      <select name="setup_sec[1]" class="form-control col-md-7 col-xs-12" style="width: 30%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option  value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
        <br>
        <br> </div>
  </div>
  <div class="item form-group  col-md-2 col-xs-12">
     <div class="col">
        <label>Machine Time</label>
     </div>
  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="text" name="machine_time_hr[1]" class="form-control col-md-7 col-xs-12" style="width: 32%;" placeholder="HR" value="">
      <select name="machine_time_min[1]" class="form-control col-md-7 col-xs-12" style="width: 30%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
      <select name="machine_time_sec[1]" class="form-control col-md-7 col-xs-12" style="width: 30%;">
      <?php for ($i=0; $i < 60 ; $i++) { ?>
      <option  value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option>
      <?php } ?>
      </select>
        <br>
        <br> 
     </div>
  </div>
  
      <div class="item form-group  col-md-1 col-xs-12">
         <div class="col">
            <label>Workers</label>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" name="workers[1]" class="form-control col-md-7 col-xs-12 workers" placeholder="workers">
            <br>
            <br> </div>
      </div>
      <div class="item form-group  col-md-1 col-xs-12">
         <div class="col">
            <label>Avg Salary</label>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input type="text" name="avg_salary[1]" class="form-control col-md-7 col-xs-12 avg_salary" placeholder="Avg Salary">
            <br>
            <br> </div>
      </div>
      <div class="item form-group  col-md-1 col-xs-12">
         <div class="col">
            <label>Total Cost</label>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input readonly="readonly" type="text" name="total_cost[1]" class="form-control col-md-7 col-xs-12 total_cost" placeholder="Total Cost">
            <br>
            <br> </div>
      </div>
      <div class="item form-group  col-md-1 col-xs-12">
         <div class="col">
            <label>Per Unit Cost</label>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <input readonly="readonly" type="text" name="per_unit_cost[1]" class="form-control col-md-7 col-xs-12 per_unit_cost" placeholder="Per Unit Cost">
            <br>
            <br> </div>
      </div>
      <div class="item form-group  col-md-1 col-xs-12">
         <div class="col">
            <label>Action</label>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
            <button class="btn edit-end-btn  addmachineForProcesstype" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
         </div>
      </div>
   </div>
</div>
</div>

<!---Machine Parameter Tab End-->


<!---Output Tab Start-->

   <!-- Inventory Process Sechduling Issues -->
<div id="output_mat_set" class="tab-pane fade " style="padding:20px;">
   <h3 class="Material-head">  OUTPUT    <hr> </h3>
   <table class=" table table-striped table-bordered well_Sech_output" style="padding:0px;">
      <tr>
        <th><label>Material Type</label></th>
        <th><label>Material Name</label></th>
        <th> <label>Quantity</label></th>
        <th><label>UOM</label></th>
        <th style="width: 10%;">Price</th>
        <th style="width: 10%;">Total</th>
        <th><label>Sub Bom</label></th>
        <th><label>Action</label></th>
     </tr>
      <tr class="output_cls chk_idd_output" id="sechIndexoutput_<?php echo $j; ?>" style="padding:0px;">
         <td class="col-md-2 col-sm-12 col-xs-12 form-group">
           <div style="display:flex;"> <div class="expand_dropwon form-group">
          <span class="up_arrow" style="display: none;"><i style="font-size: 20px;font-weight: bold;"  onclick="expandOutputMat(event,this);" jc_number="" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span><span style="display: none;" class="down_arrow"><i onclick="expandOutputMat(event,this);" jc_number="" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span>
          </div>
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="material_type_output_id[1]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)">
               <option value="">Select Option</option>
            </select>
         </div>
         </td>
         <td class="col-md-2 col-sm-12 col-xs-12 form-group">
            
            <select class="materialNameId_sechIndexoutput_<?php echo $j; ?> materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_output_name[1]" onchange="getUom_output(event,this);   getOutputsubBom(event,this);">
               <option value="">Select Option</option>
            </select>
         </td>
         <td class="col-md-2 col-sm-12 col-xs-12 form-group">
           
            <input type="text" name="quantity_output[1]" class="form-control col-md-7 col-xs-12  qty_output actual_qty" placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"> </td>
         <td class="col-md-2 col-sm-12 col-xs-12 form-group">
            
            <input type="text" name="uom_value_output1[1]" class="form-control col-md-7 col-xs-12  uom_output" placeholder="uom." value="" readonly>
            <input type="hidden" name="uom_value_output[1]" class="uom_output_val" readonly value=""> </td>
         <td></td>
         <td></td>
         <td class="col-md-2 col-sm-12 col-xs-12 form-group">
         
         <input style="border-right: 1px solid #c1c1c1 !important;" type="text" id="sub_bom" class="form-control col-md-7 col-xs-12  total" placeholder="Sub-BOM" value="" readonly> 
         </td>
         <td class="col-md-1 col-xs-12 col-sm-12 form-group" style="text-align: center;border-bottom: 1px solid #aaa;">
           
            <button class="btn edit-end-btn  add_moreoutputss" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
         </td>
         <div class="expand_out_sechIndexoutput_<?php echo $j; ?>"></div>
      </tr>
   </table>
   </div>
<!---Output Tab End-->

</div>
</form>
<!---Tab Penal End-->

</div>



<!-- Inventory Process Sechduling Issues -->
</div>


<div class="col-md-12 col-xs-12">
<center>
<button type="button" class="btn edit-end-btn close_modal2" data-dismiss="modal">Close</button>
<button id="continue_routing" type="button" data-setid="<?php echo $index_id; ?>" class="btn edit-end-btn continue_routing">Click Continue For Routing</button>
</center>
</div>


<?php } ?>
