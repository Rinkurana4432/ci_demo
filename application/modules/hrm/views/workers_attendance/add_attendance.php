
<form method="post" action="<?=base_url();?>/hrm/saveAttendanceWorker" id="holidayform" enctype="multipart/form-data"> 
    <input type="hidden" name="id" value="<?php if(!empty($attval)){ echo $attval->id; }?>">
    <input type="hidden" name="save_status" value="1" class="save_status">  
    <input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId ?>" id="loggedUser">    

    <div class="modal-body">
        <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
		<div  class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Workers Name</label>
            <div class="col-md-6 col-sm-12 col-xs-12"><select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="emid" data-id="worker" data-key="id" data-fieldname="name" id="workerid" data-where="created_by_cid = <?php echo $this->companyGroupId; ?> AND active_inactive = 1" width="100%" tabindex="-1" aria-hidden="true" required="required">
                <option value="">Select Option</option>
                <?php
                if(!empty($attval)){                                               
                    $owner = getNameById('worker',$attval->emp_id,'id');
                    echo '<option value="'.$attval->emp_id.'" selected>'.$owner->name.'</option>';
                }
                ?>
            </select>
        </div>
		</div>
		<!--<div class="form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Employee Type</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
			<select class="form-control custom-select" data-placeholder="" tabindex="1" name="emp_type" required>
                <option value="">Select Employee Type</option>
				<option value="on_roll" <?php if(isset($attval->emp_type) && $attval->emp_type == "on_roll") { echo "selected"; } ?> >On Roll</option>
				<option value="temporary"  <?php if(isset($attval->emp_type) && $attval->emp_type == "temporary") { echo "selected"; } ?> >Temporary</option>	
				<option value="contractor_roll"  <?php if(isset($attval->emp_type) && $attval->emp_type == "contractor_roll") { echo "selected"; } ?> >Contractor Roll</option>
         
            </select></div>
        </div>-->
		<div  class="item form-group">
        <label class="col-md-3 col-sm-12 col-xs-12">Select Date: </label>
        <div id="" class="date col-md-6 col-sm-12 col-xs-12" >
            <input name="attdate"  type="date" class="form-control mydatetimepickerFull" value="<?php if(!empty($attval->atten_date)) { 
                $old_date_timestamp = strtotime($attval->atten_date);
                $new_date = date('Y-m-d', $old_date_timestamp);    
                echo $new_date; } ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Attendance</label>
           <div class="col-md-6 col-sm-12 col-xs-12  "> <select class="form-control custom-select statusChange" data-placeholder="" tabindex="1" name="status" required>
               <option required value="">Select</option>
                <option value="P" <?php if(isset($attval->status) && $attval->status == "P") { echo "selected"; } ?>>Present</option>
                <option value="A"  <?php if(isset($attval->status) && $attval->status == "A") { echo "selected"; } ?>>Absent</option>
            </select>
            </div>
      </div> 
		
     </div>
         <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
            <div class="signInOut" style="display: block;">
        <div  class="item form-group">
             <label class="col-md-3 col-sm-12 col-xs-12">Sign In Time</label>
             <div class="date col-md-6 col-sm-12 col-xs-12 clockpicker" >
             <input class="form-control" type="time" name="signin" id="single-input" value="<?php if(!empty($attval->signin_time)) { echo  $attval->signin_time;} ?>" placeholder="Now"  >
             </div>
        </div>
		 <div  class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Sign Out Time</label>
            <div class="date col-md-6 col-sm-12 col-xs-12 clockpicker" >
                <input type="time" name="signout" class="form-control" value="<?php if(!empty($attval->signout_time)) { echo  $attval->signout_time;} ?>">
            </div>
        </div>
        </div>
		<div  class="item form-group">
        
            <label class="col-md-3 col-sm-12 col-xs-12">Place</label>
            <div class="date col-md-6 col-sm-12 col-xs-12"><select class="form-control custom-select" data-placeholder="" tabindex="1" name="place" required>
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
       <center> <input type="hidden" name="id" value="<?php if(!empty($attval->id)){ echo  $attval->id;} ?>" class="form-control" id="recipient-name1">                                       
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="attendanceUpdate" class="btn btn-primary">Submit</button>
		</center>
    </div>
</form>
