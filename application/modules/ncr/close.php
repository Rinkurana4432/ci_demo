<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/update_ncr" enctype="multipart/form-data" id="NcrDetail" novalidate="novalidate" style="">
<input type="hidden" name="id" value="<?php echo $_POST['id'];?>">
<div class="col-md-12 col-sm-12 col-xs-12 ">				
	 <div class="item form-group">
		<label class="col-md-3 col-sm-3 col-xs-12">Root Cause<span class="required">*</span></label>
			<div class="col-md-3 col-sm-3 col-xs-6">
			   <input type="text" class="form-control " name="root_cause[]" required> 
			</div>
		  <button class="btn field_buttondd" type="button"><i class="fa fa-plus"></i></button>	
	</div>
	<div class="item form-group fields_wrapdd"></div>
		 <div class="item form-group">
		<label class="col-md-3 col-sm-3 col-xs-12">Corrective Action</label>
			<div class="col-md-3 col-sm-3 col-xs-6">
			   <input type="text" class="form-control " name="corr_act[]">
			</div>
		<button class="btn field_button_corr" type="button"><i class="fa fa-plus"></i></button>	 
	</div>
	<div class="item form-group fields_wrap_corr"></div>
		 <div class="item form-group">
		<label class="col-md-3 col-sm-3 col-xs-12">Preventive Action</label>
			<div class="col-md-3 col-sm-3 col-xs-6">
			   <input type="text" class="form-control " name="prev_act[]" >
			 </div> 
			<button class="btn field_button_prev" type="button"><i class="fa fa-plus"></i></button>
	</div>
	<div class="item form-group fields_wrap_prev"></div>
</div>
	<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
	<center>	  
	    <div class="modal-footer">
		  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
		  <input type="submit" class="btn btn edit-end-btn " value="Submit">
		</div>

	</center>

	</form>



                        