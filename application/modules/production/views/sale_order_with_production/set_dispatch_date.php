<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveDispatchDate" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($set_dispatch_date)){echo $set_dispatch_date->id;}?>">
	
	<?php if(!empty($set_dispatch_date)){
		//pre($set_dispatch_date);
		$getPrevousSetDate =  json_decode($set_dispatch_date->production_dispatch_date);
		if(!empty($getPrevousSetDate)){
		foreach($getPrevousSetDate->dispatch_date  as $date){?> 
			<div class="item form-group">
		<label class="control-label col-md-4 col-sm-3 col-xs-12" for="previus_dates">Previous Date</label>	
			 <div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" class="form-control prevous_date" value="<?php echo $date; ?>" name="production_dispatch_date[]" readonly>
		    </div>
	</div>
          <?php } foreach($getPrevousSetDate->approveby  as $approveby){?> 
       
				<input type="hidden" class="form-control  " value="<?php echo $approveby; ?>" name="approveby[]"  >
		   
		<?php } }}?>
	<div class="item form-group">
		<label class="control-label col-md-4 col-sm-3 col-xs-12">Set Dispatch Date</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="col-md-11 xdisplay_inputx form-group has-feedback ">
				<input type="text" class="form-control has-feedback-left" id="set_prod_dispatch_date" placeholder="Date" aria-describedby="inputSuccess2Status2" name="production_dispatch_date[]" value="">
				<input type="hidden" name="approveby[]" value="<?php echo $_SESSION['loggedInUser']->name;?>">
				<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
				<span id="" class="sr-only">(success)</span>
			</div>
		</div>
	</div></br></br>
	<div class="form-group">
		<div class="col-md-3 col-md-offset-3">
			<input type="submit" class="btn edit-end-btn" value="Submit">
		</div>
	</div>
</form>