<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/update_instrument" enctype="multipart/form-data" id="InstrumentDetail" novalidate="novalidate" style="">	<?php foreach($ins as $data){?>	
<div class="col-md-12 col-sm-12 col-xs-12 ">
    		
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" >Name <span class="required">*</span>
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
				<?php echo $data->name; ?>		
					</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" >Range</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<?php echo $data->ins_range; ?> 
						<?php echo !empty($data->upper_range) ? ' - '.$data->upper_range:''; ?> 
						<?php echo $data->range_uom; ?>
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" >Least Count</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<?php echo $data->least_count; ?> 
						<?php echo $data->least_uom; ?>
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Date of Purchase</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					<?php echo date('d-m-Y',strtotime($data->date_of_purchase)); ?>
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Last Calibrated on</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					<?php echo  date('d-m-Y',strtotime($data->last_calibrated_on)); ?>
						</div>
				</div>	
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Calibrated Due Date</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					<?php echo  date('d-m-Y',strtotime($data->calibration_due_date)); ?>
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Instrument Assign to</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					<?php echo $data->ins_assign_to; ?>
						</div>
				</div>	
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Upload Calibration Certificate</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
                        <?php if($data->calibration_certificate!=''){
							$ext = pathinfo($data->calibration_certificate, PATHINFO_EXTENSION);
							if($ext=='pdf'||$ext=='xml'||$ext=='doc'){
                            echo $data->calibration_certificate;
                           }else{?>
						 <img src="<?php echo base_url();?>assets/modules/quality_control/uploads/<?php echo $data->calibration_certificate;?>" height="100" width="100"/>
                         <?php }}?>
						</div>
				</div>	
							
</div>
	<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
	<center>
	    	<div class="modal-footer">
						  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>				
						</div>
	</center>
<?php }?>	
	</form>

                        