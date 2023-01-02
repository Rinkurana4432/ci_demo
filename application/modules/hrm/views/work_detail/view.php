<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/saveWorkdetail" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
	 <input type="hidden" name="id" value="<?php if($work_detail && !empty($work_detail)){ echo $work_detail->id;} ?>">
	 <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="work_detail">Job Name</label>
		<div class="col-md-7 col-sm-10 col-xs-8">
			<?php if(!empty($work_detail) && $work_detail){ echo $work_detail->job_name; }?>
		</div>
	</div>
  
	<div class="item form-group col-md-12 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="description">Job Description</label>
		<div class="col-md-7 col-sm-10 col-xs-8">
			<?php if(!empty($work_detail) && $work_detail){ echo $work_detail->work_description; }?>
		</div>
	</div>


						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
								<label class="col-md-3 col-sm-2 col-xs-4" for="description">Assigned To</label>		
                                  <div class="col-md-7 col-sm-10 col-xs-8">								
										
											<?php
											if(!empty($work_detail)){												
												$owner = getNameById('user_detail',$work_detail->work_assigned_to,'u_id');
												echo '<option value="'.$work_detail->work_assigned_to.'" selected>'.$owner->name.'</option>';
											}
											?>
										
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
			
			?><?php echo $date ;?>
		</div>
	</div>


					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">NPDM Product<span class="required">*</span></label>
								<div class="col-md-7 col-sm-9 col-xs-12">
								
								<?php if(!empty($work_detail)){
									$purchase_data_id = getNameById('npdm',$work_detail->npdm_id,'id');
								if($purchase_data_id==''){
									echo '';
									}else{
										echo $purchase_data_id->product_name;}
								}?>
									
								</div>
								
					</div>


								<div class="item form-group col-md-12 col-sm-12 col-xs-12">
									<label class="col-md-3 col-sm-2 col-xs-4" for="description">Work Status</label>
									<div class="col-md-7 col-sm-9 col-xs-12">
									
										 <?php
											if(!empty($work_detail)){
												$status = getNameById('work_status',$work_detail->work_status,'id');
												echo $status->name;
											}
										?>
									
									</div>
								</div>

</div>
	
	<div class="modal-footer">
	<center>
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>						
	 </center>
	</div>
</form>