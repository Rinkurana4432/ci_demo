<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/save_instrument"
	enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
	<div class="col-md-12 col-sm-12 col-xs-12 ">
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span>
			</label>
			<div class="col-md-3 col-sm-3 col-xs-6">
				<input id="para" class="form-control col-md-7 col-xs-12" name="name" required="required" type="text">
			</div>
		</div>
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12">Range</label>
			<div class="col-md-2 col-sm-3 col-xs-6">
				<input id="ins" class="form-control col-md-7 col-xs-12" name="ins_range" type="text" placeholder="Lower Range">
			</div>
			<div class="col-md-2 col-sm-3 col-xs-6">
				<input id="ins" class="form-control col-md-7 col-xs-12" name="upper_range" type="text" placeholder="Upper Range">
			</div>
			<div class="col-md-2 col-sm-3 col-xs-6">
				<input id="ins" class="form-control col-md-7 col-xs-12" name="range_uom" type="text" placeholder="Units, Kg etc">
			</div>
		</div>
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12">Least Count</label>
			<div class="col-md-2 col-sm-2 col-xs-6">
				<input class="form-control col-md-7 col-xs-12" name="least_count" type="text" placeholder="Least Count">
			</div>
			<div class="col-md-2 col-sm-2 col-xs-6">
				<input class="form-control col-md-7 col-xs-12" name="least_uom" type="text" placeholder="Units, Kg etc">
			</div>
		</div>
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12">Date of Purchase</label>
			<div class="col-md-3 col-sm-3 col-xs-6">
				<input class="form-control col-md-7 col-xs-12" name="date_of_purchase" type="date">
			</div>
		</div>
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12">Last Calibrated on</label>
			<div class="col-md-3 col-sm-3 col-xs-6">
				<input class="form-control col-md-7 col-xs-12" name="last_calibrated_on" type="date">
			</div>
		</div>
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12">Calibrated Due Date</label>
			<div class="col-md-3 col-sm-3 col-xs-6">
				<input class="form-control col-md-7 col-xs-12" name="calibration_due_date" type="date">
			</div>
		</div>
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12">Instrument Assign to</label>
			<div class="col-md-3 col-sm-3 col-xs-6">
				<input class="form-control col-md-7 col-xs-12" name="ins_assign_to" type="text">
			</div>
		</div>
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12">Upload Calibration Certificate</label>
			<div class="col-md-3 col-sm-3 col-xs-6">
				<input class="form-control col-md-7 col-xs-12" name="calibration_certificate" type="file">
			</div>
		</div>
	</div>
	<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>"
		id="loggedInUserId">
	<center>

		<div class="modal-footer">
			<button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>
			<input type="submit" class="btn btn edit-end-btn " value="Submit">
		</div>
	</center>
</form>