<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>bid_management/saveWorkdetail" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
	 <input type="hidden" name="id" value="<?php if($work_detail && !empty($work_detail)){ echo $work_detail->id;} ?>">
	 <input type="hidden" name="tender_id" value="<?php if(!empty($register_opportunity)){ echo $register_opportunity->id; }?>">
	 <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="work_detail">Job Name<span class="required">*</span> </label>
		<div class="col-md-7 col-sm-10 col-xs-8">
			<input type="text" id="work_detail" name="job_name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($work_detail) && $work_detail){ echo $work_detail->job_name; }?>" required="required">
		</div>
	</div>
  
	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="description">Job Description</label>
		<div class="col-md-7 col-sm-10 col-xs-8">
			<textarea type="text" id="description" name="work_description" class="form-control col-md-7 col-xs-12"><?php if(!empty($work_detail) && $work_detail){ echo $work_detail->work_description; }?></textarea>
		</div>
	</div>


						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
								<label class="col-md-3 col-sm-2 col-xs-4" for="description">Assigned To</label>		
                                  <div class="col-md-7 col-sm-10 col-xs-8">								
										<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="work_assigned_to" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $_SESSION['loggedInUser']->c_id; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">
											<option value="">Select Option</option>
											<?php
											if(!empty($work_detail)){												
												$owner = getNameById('user_detail',$work_detail->work_assigned_to,'u_id');
												echo '<option value="'.$work_detail->work_assigned_to.'" selected>'.$owner->name.'</option>';
											}
											?>
										</select>
										</div>
						</div>
</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class="col-md-3 col-sm-2 col-xs-4" for="description">Job End Time & Date</label>
		<div class="col-md-7 col-sm-10 col-xs-8">
			<?php
			 if(!empty($work_detail) && $work_detail->end_date_time!=''){ 
				$date = date("Y-m-d\TH:i:s", strtotime($work_detail->end_date_time));
			}
			else
			{
				$date = date("Y-m-d\TH:i:s");
			}
			
			?><input type="datetime-local" class="form-control has-feedback-left" name="end_date_time"  step="1" required="required">
			<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
		</div>
	</div>


					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">NPDM Product<span class="required">*</span></label>
								<div class="col-md-7 col-sm-9 col-xs-12">
									<select class="uom selectAjaxOption select2 form-control" name="npdm_name" data-id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="uom" data-where="created_by_cid = <?php echo $_SESSION['loggedInUser']->c_id; ?>">
								<option value="">Select Option</option>
								<?php if(!empty($work_detail)){
									$purchase_data_id = getNameById('npdm',$work_detail->npdm_id,'id');
									echo '<option value="'.$work_detail->npdm_id.'"selected >'.$purchase_data_id->product_name.'</option>';
								}?>
									</select>
								</div>
								
					</div>


								<div class="item form-group col-md-12 col-sm-12 col-xs-12">
									<label class="col-md-3 col-sm-2 col-xs-4" for="description">Work Status</label>
									<div class="col-md-7 col-sm-9 col-xs-12">
									<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="work_status" data-id="work_status" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true">
										<option value="">Select Option</option>
										 <?php
											if(!empty($work_detail)){
												$status = getNameById('work_status',$work_detail->work_status,'id');
												echo '<option value="'.$work_detail->work_status.'" selected>'.$status->name.'</option>';
											}
										?>
									</select>	
									</div>
								</div>

</div>
	
	<div class="modal-footer">
	<center>
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							  
	  <input type="submit" class="btn btn-warning" value="Submit">
	 </center>
	</div>
</form>