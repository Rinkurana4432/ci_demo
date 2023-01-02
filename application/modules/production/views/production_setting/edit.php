<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveProductionSetting" enctype="multipart/form-data" id="purchaseIndentForm" novalidate="novalidate">
   <input type="hidden" value="<?php if(!empty($prodSetting)){ echo $prodSetting->id ;}?>" name="id">
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">
   <?php
      if(empty($prodSetting)){
      ?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <?php }else{ ?>   
   <input type="hidden" name="created_by" value="<?php if($prodSetting && !empty($prodSetting)){ echo $prodSetting->created_by;} ?>" >
   <?php } ?>

   <div class="col-md-12 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="shift">Company Unit</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select data-placeholder="Select Unit" class="company_unit form-control col-md-2 col-xs-12 selectAjaxOption select2" required="required" name="company_unit" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
               <option value="">Select Unit</option>
               <?php
                  if(!empty($prodSetting)){
                     $getUnitName = getNameById('company_address',$prodSetting->company_unit,'compny_branch_id');
                     echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                  }
                  
                  ?>
            </select>               
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Department</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select data-placeholder="Select Option" class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="department"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid =<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = '<?php echo $prodSetting->company_unit; ?>'" onChange="chkShiftData(event,this)">
               <option value="">Select Option</option>
               <?php
                  if(!empty($prodSetting)){
                     $departmentData = getNameById('department',$prodSetting->department,'id');
                     if(!empty($departmentData)){
                        echo '<option value="'.$departmentData->id.'" selected>'.$departmentData->name.'</option>';
                     }
                  }
                  ?>                      
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="shift">Number of Shift
         </label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="shift_number" class="form-control col-md-7 col-xs-12" name="shift_number" placeholder="Number of shift" type="number" value="<?php if(!empty($prodSetting) && $prodSetting){ echo $prodSetting->shift_number; } else { echo "1"; }?>">
         </div>
      </div>
   </div>

   <div class="multiple_shift">

   <?php 
   if(!empty($prodSetting)){
   $j=0;
   $shift_name = json_decode($prodSetting->shift_name);
   $shift_duration = json_decode($prodSetting->shift_duration);
   $shift_start = json_decode($prodSetting->shift_start);
   $shift_end = json_decode($prodSetting->shift_end);
   $week_off = json_decode($prodSetting->week_off);
   for ($i=1; $i<=$prodSetting->shift_number; $i++) {
   if($i==2){ echo '<div class="add_multi_shift">';}
   ?>

   <h3>Shift <?php echo $i; ?> :</h3>
   <div class="col-md-12 col-sm-12 col-xs-12 vertical-border main_index">

   <div class="item form-group">
   <label class="col-md-3 col-sm-3 col-xs-12" for="shift">Shift Name<span class="required">*</span>
   </label>
   <div class="col-md-6 col-sm-6 col-xs-12">
      <input id="shift_name" class="form-control col-md-7 col-xs-12" name="shift_name[<?php echo $i; ?>]" placeholder="Shift Name" required="required" type="text" value="<?php if(!empty($prodSetting) && $prodSetting){ echo $shift_name[$j]; }?>">
   </div>
   </div>

   <div class="item form-group">
   <label class="col-md-3 col-sm-3 col-xs-12" for="shift">Shift Duration<span class="required">*</span>
   </label>
   <div class="col-md-6 col-sm-6 col-xs-12">
      <input id="shift_duration" class="form-control col-md-7 col-xs-12" name="shift_duration[<?php echo $i; ?>]" placeholder="Shift duration based on Hrs and Mins" required="required" type="text" value="<?php if(!empty($prodSetting) && $prodSetting){ echo $shift_duration[$j]; }?>">
   </div>
   </div>

   <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="shift">Shift Timings<span class="required">*</span>
         </label>
         <div class='col-sm-4'>
            <div class="form-group">
               <div class='input-group date start_time' data-chk="end_time_<?php echo $i; ?>">
                  <input type='text' class="form-control" required="required" value="<?php if(!empty($prodSetting) && $prodSetting){ echo $shift_start[$j]; }?>" name="shift_start[<?php echo $i; ?>]" placeholder="Start Shift Timing"/>
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                  </span>
               </div>
            </div>
         </div>
         <div class='col-sm-4'>
            <div class="form-group">
               <div class='input-group date end_time' id="end_time_<?php echo $i; ?>">
                  <input type='text' class="end_time_input form-control" required="required" name="shift_end[<?php echo $i; ?>]"  value="<?php if(!empty($prodSetting) && $prodSetting){ echo $shift_end[$j]; }?>" placeholder="End Shift Timing"/>
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                  </span>
               </div>
            </div>
         </div>
      </div>

      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="week">Week off
         </label>
         <div class="col-md-6 col-sm-6 col-xs-12 week_off_set">
            <?php $weeks = getWeekdays();         //function call from helper
               $html = '';                   
               foreach($weeks as $dayName) {          //foreach on array 
                  if(!empty($dayName) && !empty($prodSetting->week_off)){     //call at the time of edit      
                      if(in_array($dayName, $week_off[$j])){
                        echo '<input type="checkbox" name="week_off['.$i.'][]" value="'.$dayName.'" checked>'.$dayName.'<br>';
                     }else{
                        echo '<input type="checkbox" name="week_off['.$i.'][]" value="'.$dayName.'" >'.$dayName.'<br>';
                     }
                  //call at the time of add
                  }else{
                     echo '<input type="checkbox" name="week_off['.$i.'][]" value="'.$dayName.'" >'.$dayName.'<br>';
                     
                  }
               }
               
               ?> 
         </div>
      </div>
   </div><script>$("#end_time_<?php echo $i; ?>").find(".end_time_input").prop("readonly", true);$(".start_time").datetimepicker({format: 'HH:mm', useCurrent: false, }); $("#end_time_<?php echo $i; ?>").datetimepicker({format: 'HH:mm', useCurrent: false,});</script>

   <?php $j++; if($i==$prodSetting->shift_number){ echo '</div>';} } } else { ?>
   <h3>Shift 1 :</h3>
   <div class="col-md-12 col-sm-12 col-xs-12 vertical-border main_index">

   <div class="item form-group">
   <label class="col-md-3 col-sm-3 col-xs-12" for="shift">Shift Name<span class="required">*</span>
   </label>
   <div class="col-md-6 col-sm-6 col-xs-12">
      <input id="shift_name" class="form-control col-md-7 col-xs-12" name="shift_name[1]" placeholder="Shift Name" required="required" type="text" value="">
   </div>
   </div>

   <div class="item form-group">
   <label class="col-md-3 col-sm-3 col-xs-12" for="shift">Shift Duration<span class="required">*</span>
   </label>
   <div class="col-md-6 col-sm-6 col-xs-12">
      <input id="shift_duration" class="form-control col-md-7 col-xs-12" name="shift_duration[1]" placeholder="Shift duration based on Hrs and Mins" required="required" type="text" value="">
   </div>
   </div>

   <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="shift">Shift Timings<span class="required">*</span>
         </label>
         <div class='col-sm-4'>
            <div class="form-group">
               <div class='input-group date start_time' data-chk="end_time_1">
                  <input type='text' class="form-control" required="required" value="" name="shift_start[1]" placeholder="Start Shift Timing"/>
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                  </span>
               </div>
            </div>
         </div>
         <div class='col-sm-4'>
            <div class="form-group">
               <div class='input-group date end_time' id="end_time_1">
                  <input type='text' class="end_time_input form-control" required="required" name="shift_end[1]"  value="" placeholder="End Shift Timing"/>
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                  </span>
               </div>
            </div>
         </div>
      </div>

      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="week">Week off
         </label>
         <div class="col-md-6 col-sm-6 col-xs-12 week_off_set">
            <?php $weeks = getWeekdays();         //function call from helper
               $html = '';                   
               foreach($weeks as $dayName) {  
                     echo '<input type="checkbox" name="week_off[1][]" value="'.$dayName.'" >'.$dayName.'<br>';
               }
               
               ?> 
         </div>
      </div>
   </div>
   <div class="add_multi_shift"></div>
   <?php } ?>

   
   </div>



   <div class="form-group">
      <div class="col-md-6 col-md-offset-3">
         <center>
         <?php if(empty($prodSetting)){ ?>
               <button type="reset" class="btn btn-default edit-end-btn __shiftReset">Reset</button>
            <?php } ?>
            <button style="display:none;" id="send" type="submit" class="btn btn-warning edit-end-btn __shiftSettingButton">Submit</button>
            <a class="btn edit-end-btn" onclick="location.href='<?php echo base_url();?>production/production_setting'">Cancel</a>
         </center>
      </div>
   </div>
</form>
<!-- /page content -->
<script>
$(document).ready(function() {
   $('.end_time').find('.end_time_input').prop('readonly', true);
   $('.start_time').datetimepicker({
    format: 'HH:mm',
   useCurrent: false,
   });
   
   $('.end_time').datetimepicker({
     format: 'HH:mm',
     useCurrent: false,
   });
   
   $(document).on("dp.change", ".start_time", function (e) {
     if($(this).parents().prev().find('#shift_duration').val() == ""){
      alert('Please Fill Shift Duration Field First');
       $(this).find('input').val('');
     } else {
     var duration = $(this).parents('.item').prev('.item').find('#shift_duration').val();
     var end_time = $(this).attr('data-chk');
     var result = end_time.split('_');
     var next_id = 'start_time_'+(parseInt(result[2]) + parseInt('1'));
     $('#'+end_time).next('.end_time_input').prop('disabled', false);
     if( e.date ){
      const d = new Date(e.date);
      var h = addZero(d.getHours());
      var m = addZero(d.getMinutes());
      // var ampm = h >= 12 ? 'PM' : 'AM';
      // h = h % 12;
      // h = h ? h : 12; // the hour '0' should be '12'
      // m = m < 10 ? '0'+m : m;
      // var time = h + ':' + m + ' ' + ampm;
      var time = h + ":" + m;
      var startArray = [];
      var startArray1 = [];
      $('.multiple_shift .start_time input').each(function (i) {
      var end_time1 = $(this).parent().attr('data-chk');
      var end_time2 = $(this).parents('.col-sm-4').next('.col-sm-4').find('.end_time_input').val();
      if(end_time != end_time1){
      if($(this).val() != "" && end_time2 != ""){
      startArray1.push($(this).val(), end_time2, time);
      startArray.push(compare($(this).val(), end_time2, time));
      }
      }
      });
      // console.log(startArray);
      // console.log(startArray1);
      if(checkValue('true', startArray) == "Exist"){
      $(this).find('input').val('');
      alert('Shift Timings Already Exist');
      }
      $('#'+end_time).data("DateTimePicker").date(e.date.add(convertH2M(duration), 'minutes'));
      $('.'+next_id).find("input").val($('#'+end_time).find("input").val());
     } else {
     $('#'+end_time).data("DateTimePicker").minDate(e.date);
     $('.'+next_id).find("input").val($('#'+end_time).find("input").val()); 
     }   
     
   }
   });
   
   $(document).on('change', '.week_off_set', function() {
     //var total_chk = $(this).find('checked').length; 
     var total_chk = $(this).find("input:checked").length;
     if(total_chk == 7){
      alert('All days can not be assigned as Week off.');
      $(this).find("input:checked").prop('checked', false);
    }     
   });


    $(document).on('click', '#purchaseIndentForm .__shiftSettingButton', function(event){
      $('#purchaseIndentForm').submit(true);
         return true;
      // var total = $('input[name="week_off[]"]:checked').length;
      // if(total == 7){
      //    alert('All days can not be assigned as Week off.');
      //    $('#purchaseIndentForm').submit(false);
      //    return false;
      // } else {
      //    $('#purchaseIndentForm').submit(true);
      //    return true;
      // }
   });
   
   $(document).on('click', '#purchaseIndentForm .__shiftReset', function(){
      $(".select2").val('').trigger('change');
   });
   
});
</script>
