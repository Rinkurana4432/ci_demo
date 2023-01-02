<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/saveNewWorkdetail" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
	 <input type="hidden" name="id" value="<?php if($work_detail && !empty($work_detail)){ echo $work_detail->id;} ?>">
	 <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
 	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-3 col-sm-2 col-xs-4" for="description">Assigned To</label>		
                          <div class="col-md-7 col-sm-10 col-xs-8">								
							<!--<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="work_assigned_to" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $this->companyGroupId; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">
									<option value="">Select Option</option>
									<?php
									/*if(!empty($work_detail)){												
										$owner = getNameById('user_detail',$work_detail->work_assigned_to,'u_id');
										echo '<option value="'.$work_detail->work_assigned_to.'" selected>'.$owner->name.'</option>';
									}*/
									?>
								</select>-->
			<select class="itemName form-control " name="work_assigned_to" id="work_assigned_to" required="required">
			<option value="">Select Option</option>

			<?php  foreach($users1 as $user){?>
			<option value="<?php echo $user['id'];?>"
			<?php if(!empty($work_detail)){ if($work_detail->work_assigned_to==$user['id']){echo 'Selected';}}?>>
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
	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="work_detail">  Name<span class="required">*</span> </label>
		<div class="col-md-7 col-sm-10 col-xs-8">
			<input type="text" id="work_detail" name="job_name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($work_detail) && $work_detail){ echo $work_detail->job_name; }?>" required="required">
		</div>
	</div>
  
	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="description">  Description</label>
		<div class="col-md-7 col-sm-10 col-xs-8">
			<textarea type="text" id="description" name="work_description" class="form-control col-md-7 col-xs-12"><?php if(!empty($work_detail) && $work_detail){ echo $work_detail->work_description; }?></textarea>
		</div>
	</div>

	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="description">  Repeatable</label>
		<div class="col-md-7 col-sm-10 col-xs-8">
          <select class="form-control" name="repeatable_days" onchange="get_repeatable_days(this);" width="100%" >
         	 <option value="0">No  </option> 
         	 <option value="1">Yes  </option> 
         	</select>
 		</div>
	</div>


					
</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
    	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
									<label class="col-md-3 col-sm-2 col-xs-4" for="description">  Status</label>
									<div class="col-md-7 col-sm-9 col-xs-12">
                                  	<select class="form-control selectAjaxOption select2" name="work_status" data-id="work_status" data-key="id" data-fieldname="name" width="100%" >
										 <?php
											if(!empty($work_detail)){
												$status = getNameById('work_status',$work_detail->work_status,'id');
												echo '<option value="'.$work_detail->work_status.'" selected>'.$status->name.'</option>';
											}
										?>
									</select>	
	                        		</div>
		</div>
	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class="col-md-3 col-sm-2 col-xs-4" for="description">Due Date & Time  </label>
		<div class="col-md-7 col-sm-10 col-xs-8">
			<?php
			 if(!empty($work_detail) && $work_detail->end_date_time!=''){ 
				$date = date("Y-m-d\TH:i:s", strtotime($work_detail->end_date_time));
			}
			else
			{
				$date = date("Y-m-d\TH:i:s");
			}
			
			?><input type="datetime-local" class="form-control has-feedback-left datePicker" name="end_date_time" id="order_date" value="<?php echo $date ;?>" required="required">
			<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status3" class="sr-only">(success)</span>
		</div>
	</div>


	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			
				<label class="col-md-3 col-sm-3 col-xs-12" for="name">NPDM Product<span class="required">*</span></label>
				<div class="col-md-7 col-sm-9 col-xs-12">
					<select class="uom selectAjaxOption select2 form-control" name="npdm_name" data-id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="uom" data-where="created_by_cid = <?php echo $this->companyGroupId; ?>">
				<option value="">Select Option</option>
				<?php if(!empty($work_detail)){
					$purchase_data_id = getNameById('npdm',$work_detail->npdm_id,'id');
					echo '<option value="'.$work_detail->npdm_id.'"selected >'.$purchase_data_id->product_name.'</option>';
				}?>
					</select>
				</div>
	</div>

<div id="repeating_days" style="display:none" class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="description">  Repeatation Time (Days)</label>
		<div class="col-md-7 col-sm-10 col-xs-8">
          <input type="number" class="form-control col-md-7 col-xs-12" name="repeation_days" >
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