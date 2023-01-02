

<form method="post" action="<?=base_url();?>hrm/saveAttendance" id="holidayform" enctype="multipart/form-data">
   <input type="hidden" name="id" value="<?php if(!empty($attval)){ echo $attval->id; }?>">
    <input type="hidden" name="save_status" value="1" class="save_status">  
   <input type="hidden" name="loggedUser" value="<?php echo  $this->companyGroupId ?>" id="loggedUser">    
     <div class="modal-body">
	  <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
        <div class="form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Employee</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
           <select class="itemName form-control " name="emid" id="emp_id" required="required">
              <option value="">Select Option</option>
              <?php  foreach($users1 as $user){?>
				   	<option value="<?php echo $user['id'];?>"
					<?php if(!empty($attval)){ if($attval->emp_id==$user['id']){echo 'Selected';}}?>>
					<?php echo $user['name'];?></option>
					<?php
                 /* if(!empty($assign_emp)){                                               
                      $owner = getNameById('user_detail',$assign_emp->assign_id,'u_id');
                   echo '<option value="'.$assign_emp->assign_id.'" selected>'.$owner->name.'</option>';
                  }*/
			  								 }
                  ?>
            </select>
         </div>
        </div>     
 

		<div class="form-group">
        <label class="col-md-3 col-sm-12 col-xs-12">Select Date: </label>
        <div id="" class=" date" >
            <div class="col-md-6 col-sm-12 col-xs-12"><input name="attdate" type="date" id="set_prod_dispatch_date" class="form-control mydatetimepickerFull" value="<?php if(!empty($attval->atten_date)) { 
                $old_date_timestamp = strtotime($attval->atten_date);
                $new_date = date('Y-m-d', $old_date_timestamp);    
                echo $new_date; } ?>" required>
		    </div>
            </div>
		</div>
      <div class="form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Attendance</label>
           <div class="col-md-6 col-sm-12 col-xs-12"> <select class="form-control custom-select statusChange" data-placeholder="" tabindex="1" name="status" required>
               <option required value="">Select</option>
                <option value="P" <?php if(isset($attval->status) && $attval->status == "P") { echo "selected"; } ?>>Present</option>
                <option value="A"  <?php if(isset($attval->status) && $attval->status == "A") { echo "selected"; } ?>>Absent</option>
            </select>
            </div>
        </div> 
	</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
<div class="signInOut" style="display: block;">
          <div class="form-group" >
             <label  class="col-md-3 col-sm-12 col-xs-12">Sign In Time</label>
            <div class="clockpicker col-md-6 col-sm-12 col-xs-12">
             <input type="time" class="form-control" name="signin" id="single-input" value="<?php if(!empty($attval->signin_time)) { echo  $attval->signin_time;} ?>" placeholder="Now"  >
              </div>
         </div>  
         <div class="form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Sign Out Time</label>
            <div class="clockpicker col-md-6 col-sm-12 col-xs-12">
                <input  type="time" name="signout" class="form-control" value="<?php if(!empty($attval->signout_time)) { echo  $attval->signout_time;} ?>">
     </div>
        </div> 
</div>
        <div class="form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Place</label>
           <div class="col-md-6 col-sm-12 col-xs-12"> <select class="form-control custom-select" data-placeholder="" tabindex="1" name="place" required>
                <option value="office" <?php if(isset($attval->place) && $attval->place == "office") { echo "selected"; } ?>>Office</option>
                <option value="field"  <?php if(isset($attval->place) && $attval->place == "field") { echo "selected"; } ?>>Field</option>
            </select>
			</div>
        </div> 
		</div>
    </div>
<div style="display:none" id="show_msg" class="alert alert-warning " >
 <span id="show_atten_msg">  </span>
</div>
    <div class="modal-footer">

        <input type="hidden" name="id" value="<?php if(!empty($attval->id)){ echo  $attval->id;} ?>" class="form-control" id="recipient-name1">                                       

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        <button type="submit" id="attendanceUpdate" class="btn btn-primary">Submit</button>

    </div>

</form>

