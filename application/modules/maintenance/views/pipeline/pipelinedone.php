<h3 class="Material-head">Preventive Done<hr></h3>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>maintenance/updateprepipeline" enctype="multipart/form-data" id="similarmachine" novalidate="novalidate">

 <div class="item form-group" style="text-align: center; background-color: aliceblue; margin: 0px;">
  <div class="col-md-6 col-sm-12 col-xs-12" style="padding: 10px; border: 1px solid;">
    <label>preventive</label>
  </div>
  <div class="col-md-6 col-sm-12 col-xs-12" style="padding: 10px; border: 1px solid;">
    <div class="col-md-6 col-sm-12 col-xs-12">
    <span><label>Yes</label></span>
     </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
    <span><label>No</label></span>
     </div>
  </div>
 </div>
 <?php if(!empty($pipelinedone)){

          $prechecklist =  json_decode($pipelinedone->check_list);
       
          ?> 
      <input type="hidden" name="id" value="<?php echo $pipelinedone->id; ?>"> 
    <input type="hidden" name="start_date" value='<?php echo $pipelinedone->start_date; ?>'>
    <input type="hidden" name="upcomming_date" value='<?php echo $pipelinedone->upcomming_date; ?>'>
    <input type="hidden" name="work_status" value='<?php echo $pipelinedone->work_status; ?>'>
     <input type="hidden" name="machine_id" value='<?php echo $pipelinedone->machine_id; ?>'>
     <input type="hidden" name="frequency" value='<?php echo $pipelinedone->frequency; ?>'>
     <input type="hidden" name="check_list" value='<?php echo $pipelinedone->check_list; ?>'>
     <input type="hidden" name="material_detail" value='<?php echo $pipelinedone->material_detail; ?>'>
     <input type="hidden" name="pre_completed" value='<?php echo $pipelinedone->pre_completed; ?>'>
     <input type="hidden" name="preventiv_all_data" value='<?php echo $pipelinedone->preventiv_all_data; ?>'>
     <input type="hidden" name="worker" value='<?php echo $pipelinedone->worker; ?>'>
     <input type="hidden" name="schedule_date" value='<?php echo $pipelinedone->schedule_date; ?>'>
     <input type="hidden" name="shift" value='<?php echo $pipelinedone->shift; ?>'>
     <input type="hidden" name="end_time" value='<?php echo $pipelinedone->end_time; ?>'>

  <?php foreach($prechecklist as $prechecklistdata){ ?>
 <div class="item form-group" style="text-align: center; margin: 0px;">
     

  <div class="col-md-6 col-sm-12 col-xs-12" style="padding: 10px; border: 1px solid;">
    <label><?php echo $prechecklistdata->check_list_data; ?></label>
    <input type="hidden" name="chekeddataname[]" value="<?php echo $prechecklistdata->check_list_data; ?>">
  </div>
  <div class="col-md-6 col-sm-12 col-xs-12" style="padding: 10px; border: 1px solid;">
    <div class="col-md-6 col-sm-12 col-xs-12">
    <span><input type="checkbox" name="chekeddata[]" value="Yes" style="transform: scale(1.5);margin: 5px;"></span>
      </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
    <span><input type="checkbox" name="chekeddata[]" value="No" style="transform: scale(1.5);margin: 5px;"></span>
      </div>
  </div>

 </div>
    <?php  } 
}
?>
  <div class="item form-group">
    <div class="row" style="padding-top:20px;">
      <div class="col-md-12 col-sm-12 col-xs-12">
      <h3 class="Material-head">Material Details</h3>
      </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php $materildetails = $pipelinedone->material_detail; 
                   $materilallist = json_decode($materildetails);
            ?>
            <table class="table table-bordered" border="1" cellpadding="3">
              <thead>
                <tr>
                  <td><label>Material Name</label></td>
                  <td><label>Material Type</label></td>
                  <td><label>Material Quantity</label></td>
                </tr>
              </thead>
              <tbody>
                <?php  foreach($materilallist as $materilallists){ 

                      $material_id = $materilallists->material_name;
                    $materialName = getNameById('material',$material_id,'id'); 

                  if(isset($materilallists->material_type)){
                  $material_tid = $materilallists->material_type;
                  $materialtyName = getNameById('material_type',$material_tid,'id');
                  }   
            ?>
                  
                <tr>
                  <td><?php echo $materialName->material_name; ?></td>
                  <td><?php echo $materialtyName->name; ?></td>
                  <td><?php echo $materilallists->quantity; ?></td>
                </tr>

              <?php } ?>
              </tbody>
            </table>
        </div>
    </div>
  </div>

 </div>
 <div class="item form-group">
  <div class="row" style="padding-top:20px;">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="col-md-12 col-sm-12 col-xs-12">
      <label>Done By</label>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
      <input type="text" class="form-control col-md-7 col-xs-12" name="done_by" value="<?php echo $pipelinedone->worker; ?>">
    </div>
   </div>
  <div class="col-md-6 col-sm-12 col-xs-12">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <label>Remark</label>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
      <textarea id="remark" name="remark" style="width:100%;"></textarea>
    </div>
  </div>
  </div>

 </div>

 <div class="form-group">
        <div class="col-md-12 col-md-offset-3">
            <button type="reset" class="btn btn-default edit-end-btn">Reset</button>
      <!--input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft"-->
        
                <button id="send" type="submit" class="btn edit-end-btn">Submit</button>

                <a class="btn edit-end-btn" onclick="location.href='http://busybanda.com/maintenance/pipeline'">Cancel</a>
         </div>
   </div>

</form>