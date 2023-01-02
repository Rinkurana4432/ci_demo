<h3 class="Material-head">Preventive Schedule<hr></h3>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>maintenance/updateprepipeline" enctype="multipart/form-data" id="similarmachine" novalidate="novalidate">
   <?php //pre($preventivepipeline); ?>
  <input type="hidden" name="id" value="<?php echo $preventivepipeline->id; ?>"> 
    <input type="hidden" name="start_date" value='<?php echo $preventivepipeline->start_date; ?>'>
    <input type="hidden" name="upcomming_date" value='<?php echo $preventivepipeline->upcomming_date; ?>'>
    <input type="hidden" name="work_status" value='<?php echo $preventivepipeline->work_status; ?>'>
     <input type="hidden" name="machine_id" value='<?php echo $preventivepipeline->machine_id; ?>'>
     <input type="hidden" name="frequency" value='<?php echo $preventivepipeline->frequency; ?>'>
     <input type="hidden" name="check_list" value='<?php echo $preventivepipeline->check_list; ?>'>
     <input type="hidden" name="material_detail" value='<?php echo $preventivepipeline->material_detail; ?>'>
     <input type="hidden" name="pre_completed" value='<?php echo $preventivepipeline->pre_completed; ?>'>
     <input type="hidden" name="preventiv_all_data" value='<?php echo $preventivepipeline->preventiv_all_data; ?>'>

   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">     
       
      <div class="item form-group">
        <label class="col-md-3 col-sm-2 col-xs-4" for="description">Date</label>
        <div class="col-md-7 col-sm-10 col-xs-8">
          <input type="datetime-local" class="form-control has-feedback-left datePicker" name="schedule_date" id="order_date" value="2020-08-06">
          <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
              <span id="inputSuccess2Status3" class="sr-only">(success)</span>
        </div>
      </div> 
      <div class="item form-group">
        <label class="col-md-3 col-sm-2 col-xs-4" for="description">End Time</label>
        <div class="col-md-7 col-sm-10 col-xs-8">
          <input type="datetime-local" class="form-control has-feedback-left datePicker" name="end_time" id="order_date" value="2020-08-06">
          <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
              <span id="inputSuccess2Status3" class="sr-only">(success)</span>
        </div>
      </div> 

</div>

<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">      

      <div class="item form-group">
      <label class="col-md-3 col-sm-12 col-xs-12">Shift</label>    
        <div class="col-md-6 col-sm-12 col-xs-12">
          <select class="form-control" name="shift">
            
            <option value="day">Day</option>
            <option value="night">Night</option>
            <option value="evening">Evening</option>

          </select>     
        </div>
      </div>

      <div class="item form-group">
      <label class="col-md-3 col-sm-12 col-xs-12">Worker</label>    
        <div class="col-md-6 col-sm-12 col-xs-12">
          <select class="form-control col-md-7 col-xs-12" name="worker">
              <?php foreach($get_worker as $get_workers){ ?>
              <option><?php echo $get_workers['name']." (".$get_workers['department'].")"; ?></option>
            <?php } ?>
            </select>     
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