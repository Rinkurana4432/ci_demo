<div class="box-div ">
<div class="container">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="item form-group col-md-12">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="reserve_unreserve_material">
<?php 
if(!empty($mca_data)){
$job_card_id = $mca_data['job_card_id'];
$selprocess_name = $mca_data['process_name'];
$selprocess_id = $mca_data['process_id'];
$selmachnine_nams = $mca_data['machnine_nams'];
$selmachnine_ids = $mca_data['machnine_ids'];
$seldepartment_id = $mca_data['department_id'];
$selcompny_id = $mca_data['compny_id'];
$req_output = $mca_data['req_output'];
$wo_name = $mca_data['wo_name'];
$wo_id = $mca_data['wo_id'];
$jc_name = $mca_data['jc_name'];
$material_name = $mca_data['material_name'];
$material_id = $mca_data['material_id'];
$machnine_grp_id = $mca_data['machnine_grp_id'];
$mt_time_seconds = $mca_data['shift_duration'];
$remain_qty = $mca_data['remain_qty'];
$output_set = explode(',', $mca_data['output']);
$job_card_data = $this->production_model->get_data_byId('job_card', 'id', $job_card_id);
$Detailinfo = json_decode($job_card_data->machine_details);
if(!empty($Detailinfo)){
foreach($Detailinfo as $detail_info){
if($detail_info->processess == $selprocess_id){
$machine_paramenters = !empty($detail_info->machine_details)?json_decode($detail_info->machine_details,true):'';
$output_process =   json_decode($detail_info->output_process,true);
foreach($machine_paramenters as $value){
foreach ($value['machine_id'] as $key => $value1) {
$machine_info = getNameById('add_machine',$value['machine_id'][$value1],'id');
if($machine_info->department == $seldepartment_id && $machine_info->company_branch == $selcompny_id){
$hhs = $value['hr_set'][$value1];
$mms = $value['mm_set'][$value1];
$sss = $value['sec_set'][$value1];
$setup_time = timeToSeconds($hhs.':'.$mms.':'.$sss);
$hhm = $value['mt_hr_set'][$value1];
$mmm = $value['mt_mm_set'][$value1];
$ssm = $value['mt_sec_set'][$value1];
$machine_time = timeToSeconds($hhm.':'.$mmm.':'.$ssm);
foreach($output_process as $output_process_info){
$process_output_qty = $output_process_info['quantity_output'];
}


if($remain_qty == $req_output){
$cal_time= $mt_time_seconds - $setup_time;
$cal_time1 = $machine_time * $process_output_qty;
$output = $cal_time / $cal_time1;
} elseif($remain_qty < $req_output){
$cal_time= $mt_time_seconds / $setup_time;
$cal_time1 = $process_output_qty;
$output = $cal_time * $cal_time1;
} elseif($remain_qty == $req_output){
$cal_time= $remain_time_seconds - $setup_time;
$cal_time1 = $machine_time * $process_output_qty;
$output = $cal_time / $cal_time1;
} elseif($remain_qty < $req_output){
$cal_time= $remain_time_seconds / $machine_time;
$cal_time1 = $process_output_qty;
$output = $cal_time / $cal_time1;
}


?>
<input type="radio" name="sel_mchine" class="sel_mchine" value="<?php echo $value['machine_id'][$value1]; ?>" data-mchID="<?php echo $selmachnine_ids; ?>" data-mchName="<?php echo $selmachnine_nams; ?>" data-woName="<?php echo $wo_name; ?>" data-woId="<?php echo $wo_id; ?>" data-pName="<?php echo $material_name; ?>" data-pId="<?php echo $material_id; ?>" data-jcName="<?php echo $jc_name; ?>" data-jcId="<?php echo $job_card_id; ?>" data-apName="<?php echo $selprocess_name; ?>" data-apId="<?php echo $selprocess_id; ?>" data-mchGID="<?php echo $machnine_grp_id; ?>" data-opName="<?php echo $output_set[0]; ?>" data-opVal="<?php echo $output; ?>" data-reqOut="<?php echo $req_output; ?>" <?php if($value['machine_id'][$value1] == $selmachnine_ids){ echo "checked"; } ?>>
<label for="html"><?php echo $machine_info->machine_name; ?></label><br>
<?php
}
}
}	
}
}
}
}
?>
<button style="padding: 2%; margin-top:2%;" type="button" class="btn btn-view btn-xs mc_available">Submit</button>
</div>
</div>
</div>
</div>
</div>
</div>