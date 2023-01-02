<?php 

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>


<?php if(!empty($lead) && $lead->save_status == 1) {

?>


	<div class="row leadBasicData">
	<!--------code to display to lead converted to accounts/contact button at the time of edit----------------->
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-4 col-sm-6 col-xs-12 company-name" style="float:left"><img src="<?php echo base_url(); ?>assets/images/crown-icon.png"/><?php echo $lead->company; ?></b>					
		<input type="hidden" name="created_by" value="<?php echo $this->companyGroupId; ?>">							
		</div>

		<?php
     		//if($lead->existing_customer == 0) {   
			if(empty($lead)){
			?>	

		<div class="col-md-3 col-sm-6 col-xs-12 Convert-Companies-Contact" style="float:right;"><a href="<?php echo base_url().'crm/convertLeadIntoSO/'.$lead->id; ?>"><input type="button" class="btn " value="Convert into Sale Order" <?php if($lead->converted_to_account == 1 && $lead->converted_to_contact == 1) echo 'disabled'; ?>></a></div>
		<div class="col-md-3 col-sm-6 col-xs-12 Convert-Companies-Contact" style="float:right;"><a href="<?php echo base_url().'/crm/convertLead/'.$lead->id; ?>"><input type="button" class="btn " value="Convert into Companies and Contact" <?php if($lead->converted_to_account == 1 && $lead->converted_to_contact == 1) echo 'disabled'; ?>></a></div>
		<?php } ?>

		<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 15px;">
			<ul class="stats-overview">
				<?php  if($lead->contacts !=''){
						$contacts_info = json_decode($lead->contacts);
						if(!empty($contacts_info[0])){ 
							echo '<li>
										<span class="name"> Name :</span>
										<span class="value">'.$contacts_info[0]->first_name. ' '.$contacts_info[0]->last_name.'</span>
								  </li>			
								  <li class="hidden-phone">
										<span class="name">Phone :</span>
										<span class="value">'.$contacts_info[0]->phone_no.'</span>
								  </li>
									<li class="hidden-phone">
									<span class="name"> Email :</span>
									<span class="value">'.$contacts_info[0]->email.'</span>
								</li>';
						}
				} ?>
			</ul>
		</div>
		<div class="bottom-bdr"></div>
		<!--------------displayed status of lead at the time of edit-------------------------------->	
		<div id="wizard" class="form_wizard wizard_horizontal ">
			<ul class="wizard_steps flex">
			<!--<div class="f1-progress">
				<div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3" style="width: 16.66%;"></div>
			</div>-->
			<?php foreach($leadStatuses as $leadStatus){ 	?>
				<li class="flex-item">
					<a>
						<span class="step_no <?php if ($leadStatus['id'] == $lead->lead_status){ echo 'active-status';} ?>" id="status_id_<?php echo $leadStatus['id']; ?>" style="background:<?php echo $leadStatus['id'] == $lead->lead_status?'':'#ccc'; ?>" onclick="changeStatus(<?php echo $lead->id ;?> , '<?php echo $leadStatus['id'] ;?>','<?php echo $lead->lead_status ;?>' )"><?php echo $leadStatus['name'] ;?></span>
					</a>
				</li>
			<?php } ?>				
			</ul>
		</div>
	</div>
	
	<!------------------------------display tabs of activity chatte detail------------------------------------------>
	<div class="row">
		<div class="col-md-12">		
			<div class="col-md-12 col-sm-12 col-xs-12">
				<!----------------display activity /chatter/detail tab--------------------->
				<ul class="nav nav-tabs bar_tabs" role="tablist" id="myTab">
					<li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Activity</a></li>
					<li><a href="#log_a_call" data-toggle="tab"  aria-expanded="true">Log A Call</a></li>
					<li><a href="#new_task" data-toggle="tab">New Task</a></li>
					<li><a href="#chatter" data-toggle="tab" id="tChatter">Chatter</a></li>
					<li><a href="#detail" data-toggle="tab">Detail</a></li>
				</ul>
				<!------------data display under activity /log a call/new task tab----------------------->
				<div class="tab-content" >
					<!-----------------start of activity tab--------------------------------------->
					<!--<div class="tab-pane " id="activity">-->    
						<!--<ul class="nav nav-tabs bar_tabs" role="tablist" id="myTab">
							<li class="active"><a href="#log_a_call" data-toggle="tab"  aria-expanded="true">Log A Call</a></li>
							<li><a href="#new_task" data-toggle="tab">New Task</a></li>
						</ul>-->
						<div class="tab-content col-xs-12 tab-maine" >
							<!--------start log a call form display and tab --------------------->
							<div class="tab-pane" id="log_a_call">	
								<form method="post" id="callLogForm" class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url(); ?>crm/saveLeadActivity">	
									<br />					
									<input type="hidden" name="id" value="<?php // if(!empty($leadCallLog)) echo $leadCallLog->id; ?>">
									<input type="hidden" name="lead_id" value="<?php if(!empty($lead)) echo $lead->id; ?>">
									<input type="hidden" name="activity_type" value="Call Log">
									<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="item form-group">												
										<label class="col-md-3 col-sm-2 col-xs-12" for="Name">Company Name</label>
										<div class="col-md-7 col-sm-10 col-xs-12">												
											<input type="text" id="lead_id" name="" required="required" class="form-control col-md-7 col-xs-12" <?php  if(!empty($lead))  echo 'readonly'; ?> value="<?php if(!empty($lead))  echo $lead->company; ?>">
										</div>											
									</div>		  												
									<div class="item form-group">													
										<label class="col-md-3 col-sm-2 col-xs-12">Subject</label>
										<div class="col-md-7 col-sm-10 col-xs-12">														
											<select class="form-control" name="subject">	
												<option>Select</option>
												<?php 
													$leadActivityStatuses = leadActivityStatus();
													foreach($leadActivityStatuses as $leadActivityStatus) {	
														echo "<option value='".$leadActivityStatus."'>".$leadActivityStatus."</option>";	
													}
												?>														
											</select>													
										</div>												
									</div>	
                                    </div>	
                                  <div class="col-md-6 col-sm-12 col-xs-12">									
									<div class="item form-group">													
										<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Comments<span class="required">*</span></label>
										<div class="col-md-7 col-sm-10 col-xs-12">														
											<textarea id="address1" required="required" rows="6" name="comment" class="form-control col-md-7 col-xs-12" placeholder=""></textarea>
										</div>												
									</div>	
                                  </div>									
									<div class="ln_solid"></div>												
									<div class="form-group">													
										<div class="col-md-12  ">														
											<button type="reset" class="btn btn-default">Reset</button>														
											<input type="submit" class="btn edit-end-btn" value="Save">													
										</div>												
									</div>										
								</form>	
							
							</div>
							<!-------------------end of log a call form & tab------------------------>
							<!-------------------start of new task form------------------------------>
							<div class="tab-pane" id="new_task">					
								<form method="post" id="newTaskForm" class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>crm/saveLeadActivity">	
									<br />					
									<input type="hidden" name="id" value="<?php // if(!empty($leadCallLog)) echo $leadCallLog->id; ?>">
									<input type="hidden" name="lead_id" value="<?php if(!empty($lead)) echo $lead->id; ?>">
									<input type="hidden" name="activity_type" value="New Task">
									<div class="col-sm-12 col-md-6 col-xs-12">
									<div class="col-md-12 col-sm-12 col-xs-12 item form-group">										
										<label class=" col-md-3 col-sm-2 col-xs-12" for="Name">Company Name</label>
										<div class="col-md-7 col-sm-10 col-xs-12">												
											<input type="text" id="lead_id" name="" required="required" class="form-control col-md-7 col-xs-12" <?php  if(!empty($lead))  echo 'readonly'; ?> value="<?php  if(!empty($lead))  echo $lead->company; ?>">
										</div>											
									</div>		  												
									<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
										<label class=" col-md-3 col-sm-2 col-xs-12">Subject</label>
										<div class="col-md-7 col-sm-10 col-xs-12">														
											<select class="form-control" name="subject">	
												<option>Select</option>
												<?php 
													$leadActivityStatuses = leadActivityStatus();
													foreach($leadActivityStatuses as $leadActivityStatus) {	
														echo "<option value='".$leadActivityStatus."'>".$leadActivityStatus."</option>";	
													}
												?>														
											</select>													
										</div>												
									</div>
                                 </div>	
                               <div class="col-sm-12 col-md-6 col-xs-12">								 
									<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
										<label class=" col-md-3 col-sm-2 col-xs-12" for="textarea">Due Date<span class="required">*</span></label>
										<div class="col-md-7 col-sm-10 col-xs-12">	
										<fieldset>
											<div class="control-group">
												<div class="controls">
													<div class=" xdisplay_inputx form-group has-feedback">
														<input type="text" class="form-control has-feedback-left datePicker" name="due_date" id="single_cal3" aria-describedby="inputSuccess2Status3">
														<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
														<span id="inputSuccess2Status3" class="sr-only">(success)</span>
													</div>
												</div>
											</div>
										</fieldset>	
												</div>									
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
										<label class=" col-md-3 col-sm-2 col-xs-12" for="assigned_to">Assigned To<span class="required">*</span></label>
										<div class="col-md-7 col-sm-10 col-xs-12">													
											<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="assigned_to" required="required" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $this->companyGroupId; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">
												<option value="">Select Option</option>											 
											</select>										
										</div>															
									</div>
									</div>
									<div class="col-sm-12 col-md-6 col-xs-12">
									<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
										<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Comments</label>
										<div class="col-md-7 col-sm-10 col-xs-12">														
											<textarea id="comment" required="required" rows="6" name="comment" class="form-control col-md-7 col-xs-12" placeholder=""></textarea>
										</div>												
									</div>	
									</div>
									<div class="clearfix"> </div>						
									<div class="ln_solid"></div>											
									<div class="form-group">													
										<div class="col-md-12 ">														
											<button type="reset" class="btn btn-default">Reset</button>														
											<input type="submit" class="btn edit-end-btn " value="Save">													
										</div>												
									</div>										
								</form>	
							</div>
							<!------------End of new task form & tab------------------------------>
						<!--</div>-->
					<!--</div>-->
					<!-------------------end of activity tab------------------------------------->
					<!--------------------start of chatter tab------------------------------------->
					<div class="tab-pane" id="chatter">
						<form method="post" id="callLogForm" class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>crm/saveLeadActivity">
							<input type="hidden" name="id" value="<?php // if(!empty($leadCallLog)) echo $leadCallLog->id; ?>">
							<input type="hidden" name="lead_id" value="<?php if(!empty($lead)) echo $lead->id; ?>">	
							<input type="hidden" name="activity_type" value="Chatter">	
							<input type="hidden" name="subject" value="Chatter">	
							<h4>To : This Lead</h4>	
                             <div class="col-sm-12 col-md-6 col-xs-12">							
							<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
								<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Comments</label>
								<div class="col-md-7 col-sm-10 col-xs-12">	
									<textarea name="comment" rows="6" id="comment" required="required" class="form-control col-md-7 col-xs-12"></textarea>
								</div>
							</div>					
							<div class="item form-group">
								<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Attachments</label>
								<div class="col-md-7 col-sm-9 col-xs-12 ">
									<input type="file" class="form-control col-md-2 col-sm-2 col-xs-12" name="attachment[]"> 
								</div>
								<button class="btn field_button" type="button"><i class="fa fa-plus"></i></button>
								
							</div>
							<div class="item form-group fields_wrap" >
								
								</div>
							</div>
							<br />
							<div class="ln_solid"></div>												
							<div class="form-group">													
								<div class="col-md-12 ">														
									<button type="reset" class="btn btn-default">Reset</button>														
									<input type="submit" class="btn chatter edit-end-btn" value="Save">													
								</div>												
							</div>			
						</form>
					</div>
					<!--------------------------end of chatter tab --------------------------------->
					<!------------------ Edit lead form modal start-------------------->
					<div class="tab-pane" id="detail" >
						<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>crm/saveLead" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
							<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
							<input type="hidden" name="id" value="<?php if(!empty($lead)) echo $lead->id; ?>">	
							<input type="hidden" name="save_status" value="1" class="save_status">	
							<div class="item form-group">
							<h3 class="Material-head">Lead Details<span class="required">*</span><hr></h3>
<div class="item form-group ">
							<label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Existing Customer </label>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<select class="customerName selectAjaxOption select2" name="existing_customer" data-id="account" data-key="id" data-fieldname="name" data-where="account_owner = <?php echo $this->companyGroupId; ?> AND save_status = 1" width="100%" id="account_id">
									<option value="">Select Option</option>
									<?php 
									
										 if(!empty($lead)){
										 	$account = getNameById('account',$lead->existing_customer,'id');
											echo '<option value="'.$account->id.'" selected>'.$account->name.'</option>';
										 }
									?>
								</select>
							</div>
							</div>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group input_holder middle-box">

									

								<?php if(empty($lead)){ ?>
                                     <div class="col-sm-12  col-md-12 label-box mobile-view2">
								   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>First Name <span class="required">*</span></label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Last Name</label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Email</label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Phone No.<span class="required">*</span></label></div>
								   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Designation</label></div>
									</div>
									
									<div class="well  mobile-view" id="chkIndex_1">
										<div class="item form-group col-md-3 col-xs-12">
											<label class="col-md-12 col-sm-12 col-xs-12" for="name">First Name  <span class="required">*</span></label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<input id="name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($lead)) echo $lead->first_name; ?>" name="first_name[]" placeholder="ex. John f. Kennedy" required="required" type="text" > 
											</div>
										</div>
										<div class="item form-group col-md-2 col-xs-12">
											<label class="col-md-12 col-sm-12 col-xs-12" for="name">Last Name</label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<input id="last_name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($lead)) echo $lead->last_name; ?>" name="last_name[]" placeholder="ex. John f. Kennedy" type="text">
											</div>
										</div>
										<div class="item form-group col-md-2 col-xs-12">
											<label class="col-md-12 col-sm-12 col-xs-12" for="email">Email </label>
											<div class="col-md-10 col-sm-10 col-xs-12">
												<input type="email" id="email" name="email[]"  class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php if(!empty($lead)) echo $lead->email; ?>"> 
											</div>
										</div>   
										<div class="item form-group col-md-2 col-xs-12">
											<label class="col-md-12 col-sm-12 col-xs-12" for="email">Phone No. <span class="required">*</span></label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<input type="number" id="phone_no" name="phone_no[]"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($lead)) echo $lead->phone_no; ?>" required="required">
											</div>
										</div>
										<div class="item form-group col-md-3 col-xs-12">
											<label class="col-md-12 col-sm-12 col-xs-12" for="email">Designation</label>
											<div class="col-md-12 col-sm-12 col-xs-12">
											<input type="text" id="designation" name="designation[]" class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php if(!empty($lead)) echo $lead->designation; ?>"> 
											</div>
										</div>
										<button class="btn btn-danger remove_field" type="button"> <i class="fa fa-minus"></i></button>	
										
									</div>	
									<div class="col-sm-12 btn-row">
							            <div class="input-group-append">
											<button class="btn edit-end-btn addMoreLead" type="button">Add</button>
										</div>
										</div>
									<?php }
									if(!empty($lead)){ 
										$contacts_info = json_decode($lead->contacts);
										if(!empty($contacts_info)){ 
											$i =1;
											?>
											<div class="col-sm-12  col-md-12 label-box mobile-view2">
											   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>First Name <span class="required">*</span></label></div>
											   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Last Name</label></div>
											   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Email</label></div>
											   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Phone No.<span class="required">*</span></label></div>

											   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Designation</label></div>				  
								           </div>
											<?php
											#pre($contacts_info);
											foreach($contacts_info as $contact){	?>
												<div class="well <?php if($i==1){ echo 'edit-row1  mobile-view';}else{ echo 'scend-tr  mobile-view';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">
													<div class="item form-group col-md-3 col-xs-12">
														<label>First Name <span class="required">*</span></label>
														<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
															<input id="name" class="form-control col-md-7 col-xs-12" value="<?php  echo $contact->first_name; ?>" name="first_name[]" placeholder="ex. John f. Kennedy" required="required" type="text" > 
														</div>
													</div>
													<div class="item form-group col-md-2 col-xs-12">
														<label>Last Name</label>
														<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
															<input id="last_name" class="form-control col-md-7 col-xs-12" value="<?php echo $contact->last_name; ?>" name="last_name[]" placeholder="ex. John f. Kennedy" type="text">
														</div>
													</div>
													<div class="item form-group col-md-2 col-xs-12">
														<label>Email</label>
														<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
															<input type="email" id="email" name="email[]" class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php echo $contact->email; ?>"> 
														</div>
													</div>   
													<div class="item form-group col-md-2 col-xs-12">
														<label style=" border-right: 1px solid #c1c1c1 !important;">Phone No.<span class="required">*</span></label>
														<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
															<?php /*<input type="tel" id="phone_no" name="phone_no[]"  class="form-control col-md-7 col-xs-12" value="<?php echo $contact->phone_no; ?>" data-validate-length-range="10,12" required="required">*/?>
															<input style=" border-right: 1px solid #c1c1c1 !important;" type="number" id="phone_no" name="phone_no[]"  class="form-control col-md-7 col-xs-12" value="<?php echo $contact->phone_no; ?>"  required="required">
														</div>
													</div>
													<div class="item form-group col-md-3 col-xs-12">
														<label style=" border-right: 1px solid #c1c1c1 !important;">Designation.</label>
														<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
															<?php /*<input type="tel" id="phone_no" name="phone_no[]"  class="form-control col-md-7 col-xs-12" value="<?php echo $contact->phone_no; ?>" data-validate-length-range="10,12" required="required">*/?>
															<input style=" border-right: 1px solid #c1c1c1 !important;" type="text" id="phone_no" name="designation[]"  class="form-control col-md-7 col-xs-12" value="<?php echo @$contact->designation; ?>">
														</div>
													</div>
													
												
												
												 
														<button class="btn btn-danger del_field" type="button"> <i class="fa fa-minus"></i></button>					
													
												</div>
												<div class="col-sm-12 btn-row"><button style="float: left;" class="btn edit-end-btn addMoreLead" type="button">Add</button></div>
										<?php $i++; }									
										}
									} ?>									
								</div>									
							</div>
<hr>							
<div class="bottom-bdr"></div>							
<div class="container">

  <ul class="nav bar_tabs nav-tabs">
    <li class="active"><a data-toggle="tab" href="#Address">Address</a></li>
    <li><a data-toggle="tab" href="#Details">Other Details</a></li>
  </ul>

  <div class="tab-content">
    <div id="Address" class="tab-pane fade in active">
                 <div class="well" style="overflow: auto; background-color: unset;border: 0px !important;">



                              <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
								<div class="item form-group">
									<label class="col-md-3 col-sm-2 col-xs-12" for="email">Street</label>
									<div class="col-md-6 col-sm-12 col-xs-12">
										<input type="text" id="street" name="street" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($lead)) echo $lead->street; ?>"> 
									</div>
								</div>
								<div class="item form-group">
									<label class="col-md-3 col-sm-2 col-xs-12" for="city">Zipcode/Postal Code</label>
									<div class="col-md-6 col-sm-10 col-xs-12">
										<input type="text" id="zipcode" name="zipcode" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($lead)) echo $lead->zipcode; ?>"> 
									</div>
								</div>
							
								<div class="item form-group">						
									<label class="col-md-3 col-sm-2 col-xs-12">Country</label>
									<div class="col-md-6 col-sm-10 col-xs-12">
										<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this)">
										<option value="">Select Option</option>
										<?php
											if(!empty($lead)){
											$country = getNameById('country',$lead->country,'country_id');
											echo '<option value="'.$lead->country.'" selected>'.$country->country_name.'</option>';
											}
										?>
										</select>
									</div>
								</div>	
							    </div>
								
								<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
								<div class="item form-group">
									<label class="col-md-3 col-sm-2 col-xs-12" for="city">State/Province</label>
										<div class="col-md-6 col-sm-10 col-xs-12">									
											<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible state_id" name="state"  width="100%" tabindex="-1" aria-hidden="true" onchange="getCity(event,this)">
											<option value="">Select Option</option>
											<?php
												if(!empty($lead)){
													$state = getNameById('state',$lead->state,'state_id');
													echo '<option value="'.$lead->state.'" selected>'.$state->state_name.'</option>';
												}
											?>
											</select>
										</div>
								</div>
								<div class="item form-group">
									<label class="col-md-3 col-sm-2 col-xs-12" for="city">City</label>
										<div class="col-md-6 col-sm-10 col-xs-12">
											<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible city_id" name="city" width="100%" tabindex="-1" aria-hidden="true">
												<option value="">Select Option</option>
												<?php
													if(!empty($lead)){
														$city = getNameById('city',$lead->city,'city_id');
														echo '<option value="'.$lead->city.'" selected>'.$city->city_name.'</option>';
													}
												?>
											</select>
										</div>
								</div>
								<div class="item form-group">
								<label class="col-md-3 col-sm-2 col-xs-12" for="address2">Company <span class="required">*</span></label>
								<div class="col-md-6 col-sm-10 col-xs-12">
									<input type="text" id="company" name="company" required="required" class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php if(!empty($lead)) echo $lead->company; ?>"> 
								</div>
							   </div>
								</div>

								
							</div>
    </div>

    <div id="Details" class="tab-pane fade">
	                 <div class="well" style="overflow: auto;background-color: unset;border: 0px !important;">
	                     <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">  
                       
							
							<div class="item form-group">
								<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Website</label>
								<div class="col-md-6 col-sm-10 col-xs-12">
									<input type="url" id="website" name="website" class="optional form-control col-md-7 col-xs-12" placeholder="http://www.website.com" value="<?php if(!empty($lead)) echo $lead->website; ?>" data-validate-length-range="0"> 
								</div>
							</div>

							<div class="item form-group">
								<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">End Date <span class="required">*</span></label>
								<div class="col-md-6 col-sm-10 col-xs-12">
									<input type="date" id="website" name="end_date" class="optional form-control col-md-7 col-xs-12"  value="<?php if(!empty($lead)) echo $lead->end_date; ?>"> 
								</div>
							</div>
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
							<div class="item form-group">
								<?php $leadStatuses = leadStatus();  
								?>
									<label class="col-md-3 col-sm-2 col-xs-12">Lead Owner<span class="required">*</span></label>
									<div class="col-md-6 col-sm-10 col-xs-12">
										<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="lead_owner" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $this->companyGroupId; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">
											<option value="">Select Option</option>
											<?php
											if(!empty($lead)){												
												$owner = getNameById('user_detail',$lead->lead_owner,'u_id');
												if(!empty($owner)){
													echo '<option value="'.$lead->lead_owner.'" selected>'.$owner->name.'</option>';
												}
											}
											?>
										</select>
									</div>
							</div>		
							<div class="item form-group">
							<?php $leadStatuses = leadStatus();  ?>
								<label class="col-md-3 col-sm-2 col-xs-12">Lead Status</label>
								<div class="col-md-6 col-sm-10 col-xs-12">
									<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="lead_status" data-id="lead_status" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true">
										<option value="">Select Option</option>
										 <?php
											if(!empty($lead)){
												$status = getNameById('lead_status',$lead->lead_status,'id');
												echo '<option value="'.$lead->lead_status.'" selected>'.$status->name.'</option>';
											}
										?>
									</select>	
								</div>
							</div>
							
							<div class="item form-group">
								<?php $leadSources = leadSource();  ?>
								<label class="col-md-3 col-sm-2 col-xs-12">Lead Source</label>
								<div class="col-md-6 col-sm-10 col-xs-12">
									<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="lead_source" data-id="add_lead_source" data-key="id" data-fieldname="leads_source_name" width="100%" tabindex="-1" aria-hidden="true" data-where =" created_by_cid = 0 or created_by_cid = <?php echo $this->companyGroupId ?>">
										<option value="">Select Option</option>
										 <?php
											if(!empty($lead)){
												$status = getNameById('add_lead_source',$lead->lead_source,'id');
												echo '<option value="'.$lead->lead_source.'" selected>'.$status->leads_source_name.'</option>';
											}
										?>
									</select>							
								</div>
							</div>	

							<div class="item form-group">
								<?php $leadSources = leadSource();  ?>
								<label class="col-md-3 col-sm-2 col-xs-12">Leads Industry</label>
								<div class="col-md-6 col-sm-10 col-xs-12">
									<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="lead_industry" data-id="add_industry" data-key="id" data-fieldname="industry_detl" width="100%" tabindex="-1" aria-hidden="true" data-where ="active_inactive = 1 and created_by_cid = 0 or created_by_cid = <?php echo $this->companyGroupId ?>">
									  	<option value="">Select Option</option>
										<?php
											if(!empty($lead)){
												$status = getNameById('add_industry',$lead->lead_industry,'id');
												echo '<option value="'.$lead->lead_industry.'" selected>'.$status->industry_detl.'</option>';
											}
										?>
									</select>							
								</div>
							</div>	
							</div>
					</div>
    </div>
  </div>
</div>
<hr>							
<div class="bottom-bdr"></div>	
							
						
						<h3 class="Material-head">Product Details <hr></h3>
						
						            <?php  #pre($lead); 

										// echo $lead->material_type_id;
									?>
									<!--div class="item form-group">
							<div class="col-md-6 col-sm-12 col-xs-12 vertical-border" style="margin-bottom: 20px;">
								<label class="col-md-3 col-sm-12 col-xs-12" for="material">Material Type <span class="required">*</span></label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php //echo $this->companyGroupId; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type_id" >
										<option value="">Select Option</option>
										<?php
										/*if (!empty($lead)) {
											$material_type_id = getNameById('material_type', $lead->material_type_id, 'id');
											echo '<option value="' . $lead->material_type_id . '" selected>' . $material_type_id->name . '</option>';
										}*/
										?>
									</select>
								</div>
							</div>
							</div-->
							<div class="col-md-12 col-sm-12 col-xs-12 form-group input_detail middle-box">
							<div class="col-sm-12  col-md-12 label-box mobile-view2">
									<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Type<span class="required">*</span></label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name<span class="required">*</span></label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Quantity &nbsp;&nbsp;UOM</label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Price</label></div>				  
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>GST </label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Total</label></div>
				                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">GST Total</label></div>
				   
			                 </div>
							<?php if(!empty($lead) && $lead->product_detail !=''){ 
								$product_info = json_decode($lead->product_detail);
								
								if(!empty($product_info)){ 
								$i = 1;
								foreach($product_info as $productInfo){ 
								 //pre($productInfo);
								
								$materialName = getNameById('material',$productInfo->material_name_id,'id');
								
								?>		
							
								<div class="well <?php if($i==1){ echo 'edit-row1 scend-tr mobile-view';}else{ echo 'scend-tr mobile-view';}?>" id="chkIndex_<?php echo $i; ?>" style="overflow:auto; ">
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
									  <label>Material Type<span class="required">*</span></label>
										<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 select2-width-imp" name="material_type_id_val[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type_id" >
										<option value="">Select Option</option>
										<?php
										 if (!empty($productInfo->material_type_id)) {
										 	$material_type_id = getNameById('material_type', $productInfo->material_type_id, 'id');
										 	//pre($material_type_id);
											echo '<option value="' . $productInfo->material_type_id . '" selected>' . $material_type_id->name . '</option>';
										 }
										?>
									</select>
										</select>
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
									  <label>Material Name<span class="required">*</span></label>
										<select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name_id[]"  data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND material_type_id = <?php echo $lead->material_type_id;?> AND status=1" onchange="getUom(event,this)">
											<option value="">Select Option</option>
											<?php echo '<option value="'.$productInfo->material_name_id.'" selected>'.$materialName->material_name.'</option>';?>
										</select>
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
									    <label>Description</label>
										<textarea id="description" name="description[]" rows="1" class="form-control col-md-7 col-xs-12 description"><?php if(!empty($lead)) echo $productInfo->description; ?></textarea>					
									</div>	
									<div class="col-md-2 col-sm-6 col-xs-12 form-group">
										<label>Quantity &nbsp;&nbsp;UOM</label>
										<input type="text" id="quantity" name="qty[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" value="<?php if(!empty($lead)) echo $productInfo->qty; ?>" required="required">
										<input type="text" id="uom" name="uom_material1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($lead)) 

												$ww =  getNameById('uom', $productInfo->uom_material,'id');
												 // pre($ww);
														$uom = !empty($ww)?$ww->ugc_code:'';

														echo $uom;
									


										?>" readonly>

										<input type="hidden" name="uom_material[]" id="uomid" value="<?php if(!empty($ww)){echo $ww->id;} ?>" readonly>
									</div>

									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										<label>Price</label>
										<input type="text" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" value="<?php if(!empty($lead)) echo $productInfo->price; ?>">
									</div>
									
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									    <label>GST </label>
										<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="<?php if(!empty($lead) && isset($productInfo->gst)) echo $productInfo->gst; ?>" placeholder="gst" readonly>
									</div>				
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										    <label>Total</label>
											<input type="text" name="totals[]" placeholder="total" class="form-control col-md-7 col-xs-12 total" min="0" readonly value="<?php if(!empty($lead) && isset($productInfo->total)) echo $productInfo->total; ?>">
									</div>
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										    <label >GST Total</label>
											<input style=" border-right: 1px solid #c1c1c1 !important;" type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="<?php if(!empty($lead) && isset($productInfo->TotalWithGst)) echo $productInfo->TotalWithGst; ?>" readonly>
									</div>		
										
											
								
									<button style="margin-right: 0px;" class="btn  btn-danger delete_btn" type="button"> <i class="fa fa-minus"></i></button>
									</div>
								     <div class="col-sm-12 btn-row"><button style="margin-top: 22px; float:left;" class="btn edit-end-btn addMoreButton " 	type="button" align="right">Add</button></div>
								
							<?php $i++;
										}
									}
								}else{ 
								?>
								
								<div class="well " id="chkIndex_1" style="overflow:auto; ">
								 	<div class="col-md-2 col-sm-12 col-xs-12 form-group">
									  <label>Material Type<span class="required">*</span></label>
										<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 select2-width-imp" name="material_type_id_val[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type_id" >
										<option value="">Select Option</option>
									</select>
										</select>
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
									
										<select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name_id[]" onchange="getUom(event,this)">
											<option value="">Select Option</option>
										</select>
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
									
										<textarea id="description" name="description[]" rows="1" class="form-control col-md-7 col-xs-12 description"></textarea>					
									</div>	
									<div class="col-md-2 col-sm-6 col-xs-12 form-group">
										
										<input type="text" id="quantity" name="qty[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
										<input type="text" id="uom" name="uom_material1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12"   readonly>

										<input type="hidden" name="uom_material[]" id="uomid" readonly>
									</div>

									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										
										<input type="text" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" value="">
									</div>
									
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									
										<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="<?php if(!empty($lead) && isset($productInfo->gst)) echo $productInfo->gst; ?>" placeholder="gst" readonly>
									</div>				
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										
											<input type="text" name="totals[]" placeholder="total" class="form-control col-md-7 col-xs-12 total" min="0" readonly value="<?php if(!empty($lead) && isset($productInfo->total)) echo $productInfo->total; ?>">
									</div>
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										
											<input type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="<?php if(!empty($lead) && isset($productInfo->individualTotalWithGst)) echo $productInfo->TotalWithGst; ?>" readonly>
									</div>		

								</div>		
													
							<div class="col-sm-12 btn-row"><div class="input-group-append"><button style="margin-top: 22px; float:left;" class="btn edit-end-btn addMoreButton " type="button" align="right"><i class="fa fa-plus"></i></button></div></div>
									

							<?php }?>	
						
						</div>	
						
						
				<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
                   

					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
						
					<div class="col-md-12 col-sm-5 col-xs-12 text-right">
						
						
						<div class="col-md-6 col-sm-5 col-xs-6 ">
							<input type="hidden"  name="total" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($lead)){ echo $lead->totalwithoutgst ; } ?>"> 
							<strong>Total:</strong>&nbsp;&nbsp;
							</div>
							<div class="col-md-6 text-left"> <span class="fa fa-rupee divSubTotal"><?php if(!empty($lead)){ echo $lead->totalwithoutgst ; } else{ echo 0; }?></div>	
							 
						
                         <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 20px;color: #2C3A61; border-top: 1px solid #2C3A61;">
						<div class="col-md-6 col-sm-5 col-xs-6 ">
							<input type="hidden"  name="grandTotal" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($lead)){ echo $lead->grand_total ; }?>"> 
							<strong>Grand Total:</strong>
							</div>
							<div class="col-md-6 text-left"><span class="fa fa-rupee divTotalLead"><?php if(!empty($lead)){ echo $lead->grand_total ;} else{ echo 0; }?></span></div>	
							 </div>
						</div>
					</div>
						
					</div>
					
						
							<!--<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="grandtotal">Grand Total</label>
								<div class="col-md-10 col-sm-10 col-xs-12">
									<input type="text" id="grand_total" name="grand_total" required="required" class="form-control col-md-7 col-xs-12"  value="<?php //if(!empty($lead)) echo $lead->grand_total; ?>"> 
								</div>
							</div>-->
							<div class="ln_solid"></div>
							<div class="form-group">
								<div class="col-md-12">
									<button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
									<button type="reset" class="btn btn-default">Reset</button>
									<?php if((!empty($lead) && $lead->save_status !=1) || empty($lead)){
										echo '<input type="submit" class="btn add_users_dataaa draftBtn" value="Save as draft">'; 
									}?> 
									<input type="submit" class="btn edit-end-btn" value="Submit">
								</div>
							</div>
						</form>	
					</div>
					<!------end of edit lead form ------------------>
					
				
				<div class="col-md-12 col-sm-12 col-xs-12 tab-pane active" id="activity">
				<div class="Activities">
					<div class="x_title">
					<h3 class="Material-head">Recent Activities<hr></h3>
						
						<div class="col-md-3 export_div">
											
							<div class="control-group">
								<div class="controls">
									<div class="input-prepend input-group">
										<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text"  name="activityDateRange" id="activityDateRange" class="form-control"/>
										<input type="hidden" name="activityRelId" value="<?php if(!empty($lead)){ echo $lead->id;   }?>">
										<input type="hidden" name="activityRelTable" value="lead_activity">
									</div>
								</div>
							</div>						
						</div>
						<div class="col-md-4 title_right" style="display:none;">
						     
								<div class="col-md-12 col-sm-12 col-xs-12 form-group pull-right top_search">
								  <div class="input-group">
									<input type="text" class="form-control" placeholder="Search activities">
									<span class="input-group-btn">
									  <button class="btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i>
</button>
									</span>
								  </div>
								</div>
                              
						</div>
						<div class="clearfix"></div>
					</div>
					<div>
						<ul class=" messages activityMessage col-md-12 col-sm-12 col-xs-12">
							<?php if(!empty($lead_activities)){ 
								foreach($lead_activities as $activity){ ?>

									<?php #pre($activity); ?>
								
									<li>
									    <div class="col-md-12 col-xs-12 head">
										<div class="col-md-4 col-xs-12">
										<span><img src="<?php if($activity['activity_type'] == 'New Task'){ echo '/assets/images/task.png';} else if($activity['activity_type'] == 'Call Log'){ echo '/assets/images/call-log.png';} else{ echo '/assets/images/chat-icon.png'; } ?>"></span>
										<div class="message_wrapper">
											<h4 class="heading">  <?php echo $activity['subject']; ?></h4>
										
										</div>
										</div>
										<div class="message_date col-md-4">
										  <?php echo $activity['created_date']; ?>
										</div>
									    </div>
										<div class="col-md-12 col-xs-12 " style="text-align: left;">
										<p class="message">  <?php echo $activity['comment']; ?></p>
										<?php  $lead_status = getNameById('user_detail',$activity['created_by'],'u_id');?>
										
										<p> Created By:  <?php echo !empty($lead_status)?$lead_status->name:'';?></p>
										<?php if($activity['activity_type'] == 'New Task'){
											echo 'Due date : '. $activity['due_date'];

												} ?>											
											<?php if($activity['activity_type'] == 'Chatter'){
												$attachments  = getAttachmentsById('attachments',$activity['id'],'lead_activity');
												if(!empty($attachments)){
													echo '<div class="col-md-12">';
														foreach($attachments as $attachment){

															$ext = pathinfo($attachment['file_name'], PATHINFO_EXTENSION);
											                  	if($ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg' || $ext == 'png' || $ext == 'ico'){
											                  		echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$attachment['file_name'].'" href="'.base_url().'assets/modules/crm/uploads/'.$attachment['file_name'].'"><img style="display: block;" src="'.base_url().'assets/modules/crm/uploads/'.$attachment['file_name'].'" alt="image" height="80" width="80"/><i class="fa fa-download"></i> 
											                  			</div>
											                  			</div>';			
											                  	}else if($ext == 'ods' || $ext ==  'doc' || $ext ==  'docx' ){
											                  		echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$attachment['file_name'].'" href="'.base_url().'assets/modules/crm/uploads/'.$attachment['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/docX.png"  height="80" width="80"/><i class="fa fa-download"></i> 
											                  			</div></div>';	
											                  	}else if($ext == 'pdf'){
											                  		echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$attachment['file_name'].'" href="'.base_url().'assets/modules/crm/uploads/'.$attachment['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/PDF.png"  height="80" width="80"/><i class="fa fa-download"></i> 
											                  		</div></div>';	
											                  	}else if($ext == 'xlsx'){
											                  		echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$attachment['file_name'].'" href="'.base_url().'assets/modules/crm/uploads/'.$attachment['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/excel.png"  height="80" width="80"/><i class="fa fa-download"></i> 
											                  		</div></div>';	
											                  	}


															// echo '
															// 		<div class="img-holder col-md-1">
															// 		<span id="mask" tabindex="1" onclick="myFunction()"></span>
															// 		<img id="pic" src="'.base_url(). 'assets/modules/crm/uploads/'.$attachment[ 'file_name']. '" tabindex="2">
															// 		</div>
															// 	';
														 } 
													echo '</div>';
												}
											}
											  ?>
											  <br />
											  </div>
									</li>								 
								<?php }
								}else{
									echo '<div class="oops"><img src="http://busybanda.com/assets/images/no-activityes.jpg"></div>'; 
								} ?>
						</ul>
					</div>
				</div>
			</div>
			</div>
			</div>
			</div>
			
		</div>
	</div>
 <?php }else { ?>
 
 <!--<img src="http://busybanda.com/assets/images/no-activityes.jpg">-->

	<!-------------------------------------------add modal for leads--------------------------------------->
	
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>crm/saveLead" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
		<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
		<input type="hidden" name="id" value="<?php if(!empty($lead)) echo $lead->id; ?>">	
		<input type="hidden" name="save_status" value="1" class="save_status">				
		<div class="item form-group">
			<h3 class="Material-head">Lead Details<hr></h3>
			<div class="item form-group ">
							<label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Existing Customer </label>
							<div class="col-md-6 col-sm-12 col-xs-12">
							<!-- customerName -->
								<select class=" selectAjaxOption select2 exixting_c" name="existing_customer" data-id="account" data-key="id" data-fieldname="name" data-where="account_owner = <?php echo $this->companyGroupId; ?> AND save_status = 1" width="100%" id="account_id">
									<option value="">Select Option</option>
									<?php 
									
										 if(!empty($lead)){
										 	$account = getNameById('account',$lead->existing_customer,'id');
											pre($leads);
											echo '<option value="'.$account->id.'" selected>'.$account->name.'</option>';
										 }
									?>
								</select>
							</div>
		</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group input_holder middle-box">
					
					<?php if(empty($lead)){ ?>
					  <div class="col-sm-12  col-md-12 label-box mobile-view2">
											   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>First Name <span class="required">*</span></label></div>
											   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Last Name</label></div>
											   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Email</label></div>
											   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Phone No.<span class="required">*</span></label></div>

											   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Designation</label></div>				  
								           </div>
										   
						<div class="well  mobile-view" id="chkIndex_1" >
							<div class="item form-group col-md-3 col-xs-12">
								<label class="col-md-12 col-sm-12 col-xs-12" for="name">First Name <span class="required">*</span></label>
									<div class="col-md-12 col-sm-12 col-xs-12 form-group">
										<input id="name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($lead)) echo $lead->first_name; ?>" name="first_name[]" placeholder="ex. John f. Kennedy" required="required" type="text" > 
									</div>
							</div>
							<div class="item form-group col-md-2 col-xs-12">
								<label class="col-md-12 col-sm-12 col-xs-12" for="name">Last Name</label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<input id="last_name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($lead)) echo $lead->last_name; ?>" name="last_name[]" placeholder="ex. John f. Kennedy" type="text">
								</div>
							</div>
							<div class="item form-group col-md-2 col-xs-12">
								<label class="col-md-12 col-sm-12 col-xs-12" for="email">Email </label>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<input type="email" id="email" name="email[]"   class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php if(!empty($lead)) echo $lead->email; ?>" > 
								</div>
							</div>   
							<div class="item form-group col-md-2 col-xs-12">
								<label style=" border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-2 col-xs-12" for="email">Phone No. <span class="required">*</span></label>
								<div class="col-sm-12 col-md-12 col-xs-12 form-group">
									<?php /*<input type="tel" id="phone_no" name="phone_no[]"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($lead)) echo $lead->phone_no; ?>" data-validate-length-range="10,12" required="required">*/?>
									<input style=" border-right: 1px solid #c1c1c1 !important;" type="number" id="phone_no" name="phone_no[]"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($lead)) echo $lead->phone_no; ?>"  required="required">
								</div>
							</div>
							<div class="item form-group col-md-3 col-xs-12">
								<label style=" border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-2 col-xs-12" for="email">Designation.</label>
								<div class="col-sm-12 col-md-12 col-xs-12 form-group">
									<?php /*<input type="tel" id="phone_no" name="phone_no[]"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($lead)) echo $lead->phone_no; ?>" data-validate-length-range="10,12" required="required">*/?>
									<input type="text" id="designation" name="designation[]" class="form-control col-md-7 col-xs-12" placeholder="Designation" value="<?php if(!empty($lead)) echo $lead->designation; ?>"> 
								</div>
							</div>
							
							<button class="btn btn-danger del_field" type="button"> <i class="fa fa-minus"></i></button>
						</div>	
						<div class="col-sm-12 btn-row"><div class="input-group-append">
								<button class="btn edit-end-btn addMoreLead" type="button">Add</button>
							</div></div>
					<?php }
					if(!empty($lead)){ 
						$contacts_info = json_decode($lead->contacts);
						if(!empty($contacts_info)){ 
						$i =1;
						?>
						<div class="col-sm-12  col-md-12 label-box mobile-view2">
											   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>First Name <span class="required">*</span></label></div>
											   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Last Name</label></div>
											   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Email</label></div>
											   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Phone No.<span class="required">*</span></label></div>
												<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Designation</label></div>											   
								           </div>
						<?php
						foreach($contacts_info as $contact){	?>
							<div class="well  mobile-view" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">
								<div class="item form-group col-md-2 col-xs-12">
									<label class="col-md-12 col-sm-12 col-xs-12" for="name">First Name <span class="required">*</span></label>
									<div class="col-md-12 col-sm-12 col-xs-12 form-group">
										<input id="name" class="form-control col-md-7 col-xs-12" value="<?php  echo $contact->first_name; ?>" name="first_name[]" placeholder="ex. John f. Kennedy" required="required" type="text" > 
									</div>
								</div>
								<div class="item form-group col-md-2 col-xs-12">
									<label class="col-md-12 col-sm-12 col-xs-12" for="name">Last Name</label>
									<div class="col-md-122 col-sm-12 col-xs-12 form-group">
										<input id="last_name" class="form-control col-md-7 col-xs-12" value="<?php echo $contact->last_name; ?>" name="last_name[]" placeholder="ex. John f. Kennedy" type="text">
									</div>
								</div>
								<div class="item form-group col-md-3 col-xs-12">
									<label class="col-md-12 col-sm-12 col-xs-12" for="email">Email </label>
									<div class="col-md-12 col-sm-12 col-xs-12 form-group">
										<input type="email" id="email" name="email[]"  class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php echo $contact->email; ?>"> 
									</div>
								</div>   
								<div class="item form-group col-md-3 col-xs-12">
									<label style="border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-12 col-xs-12" for="email">Phone No. <span class="required">*</span></label>
									<div class="col-md-12 col-sm-12 col-xs-12 form-group">
										<?php /*<input type="tel" id="phone_no" name="phone_no[]"  class="form-control col-md-7 col-xs-12" value="<?php echo $contact->phone_no; ?>" data-validate-length-range="8,10" required="required">*/?>
										
										<input style="border-right: 1px solid #c1c1c1 !important;" type="number" id="phone_no" name="phone_no[]"  class="form-control col-md-7 col-xs-12" value="<?php echo $contact->phone_no; ?>" required="required">
									</div>
								</div>
								<div class="item form-group col-md-2 col-xs-12">
								<label style=" border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-2 col-xs-12" for="email">Designation.</label>
								<div class="col-sm-12 col-md-12 col-xs-12 form-group">
									<?php /*<input type="tel" id="phone_no" name="phone_no[]"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($lead)) echo $lead->phone_no; ?>" data-validate-length-range="10,12" required="required">*/?>
									<input type="text" id="designation" name="designation[]" class="form-control col-md-7 col-xs-12" placeholder="Designation" value="<?php if(!empty($lead)) echo $lead->designation; ?>"> 
								</div>
							</div>
								<button class="btn btn-danger del_field" type="button"> <i class="fa fa-minus"></i></button>
								
							</div>
							<div class="col-sm-12 btn-row">
							            <div class="input-group-append">
									<button class="btn edit-end-btn addMoreLead" type="button">Add</button>
															
								</div>
								</div>
						<?php $i++; }									
						}
					} ?>									
				</div>									
		</div>
		<hr>
		<div class="bottom-bdr"></div>
<div class="container">

  <ul class="nav tab-3 nav-tabs">
    <li class="active"><a data-toggle="tab" href="#Address2">Address</a></li>
    <li><a data-toggle="tab" href="#Details2">Other Details</a></li>
  </ul>

  <div class="tab-content">
    <div id="Address2" class="tab-pane fade in active">

	<div class="well" style="overflow: auto; background-color: unset;border: 0px !important;">
	        <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
				<div class="item form-group">
					<label class="col-md-3 col-sm-12 col-xs-12" for="email">Street</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<input type="text" id="street" name="street" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($lead)) echo $lead->street; ?>"> 
						</div>
				</div>

						<div class="item form-group">
								<label class="col-md-3 col-sm-2 col-xs-12" for="address2">Company<span class="required">*</span></label>
								<div class="col-md-6 col-sm-10 col-xs-12">
									<input type="text" id="company" name="company" required="required" class="form-control col-md-7 col-xs-12" placeholder="Company Name" value="<?php if(!empty($lead)) echo $lead->company; ?>"> 
								</div>
							</div>


				<div class="item form-group">
					<label class="col-md-3 col-sm-12 col-xs-12" for="city">Zipcode/Postal Code</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<input type="text" id="zipcode" name="zipcode" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($lead)) echo $lead->zipcode; ?>"> 
					</div>
				</div>
						
				<div class="item form-group">						
					<label class="col-md-3 col-sm-12 col-xs-12">Country</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
					<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this)">
						<option value="">Select Option</option>
						 <?php
							if(!empty($lead)){
								$country = getNameById('country',$lead->country,'country_id');
								echo '<option value="'.$lead->country.'" selected>'.$country->country_name.'</option>';
							}
						?>
					</select>
					</div>
				</div>	
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
				<div class="item form-group">
					<label class="col-md-3 col-sm-12 col-xs-12" for="city">State/Province</label>
					<div class="col-md-6 col-sm-12 col-xs-12">									
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible state_id" name="state"  width="100%" tabindex="-1" aria-hidden="true" onchange="getCity(event,this)">
						<option value="">Select Option</option>
						<?php
							if(!empty($lead)){
								$state = getNameById('state',$lead->state,'state_id');
								echo '<option value="'.$lead->state.'" selected>'.$state->state_name.'</option>';
							}
						?>
						</select>
					</div>
				</div>
				<div class="item form-group">
				<?php $leadStatuses = leadStatus();  ?>
					<label class="col-md-3 col-sm-12 col-xs-12">Lead Owner<span class="required">*</span></label>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="lead_owner" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $_SESSION['loggedInUser']->c_id; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">
							<option value="">Select Option</option>
							 <?php
							 if(!empty($lead)){												
												$owner = getNameById('user_detail',$lead->lead_owner,'u_id');
												if(!empty($owner)){
													echo '<option value="'.$lead->lead_owner.'" selected>'.$owner->name.'</option>';
												}
											}
								// if(!empty($lead)){
									// $owner = getNameById('user_detail',$lead->lead_owner,'id');
									// echo '<option value="'.$lead->lead_owner.'" selected>'.$owner->name.'</option>';
								// }
							?>
						</select>
						
					</div>
				</div>		
				<div class="item form-group">
					<label class="col-md-3 col-sm-12 col-xs-12" for="city">City</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible city_id" name="city" width="100%" tabindex="-1" aria-hidden="true">
						<option value="">Select Option</option>
							<?php
							if(!empty($lead)){
								$city = getNameById('city',$lead->city,'city_id');
								echo '<option value="'.$lead->city.'" selected>'.$city->city_name.'</option>';
							}
							?>
						</select>
					</div>
				</div>
				</div>
			</div>
			<!--div class="item form-group">
				<label class="" for="city">Is NPDM</label>
				<input type="checkbox" name="is_npdm" id="ert" value="">
			</div-->

			<!--NPDM Start-->
			    <div class="box1" style="display:none;">
						<div class="box-inner" >
                        <!--h2 class="StepTitle">Step 3 Content</h2-->
                      <?php 
					  $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
					  ?>
						
						<h3 class="Material-head">NPDM Details<hr></h3>
							
							<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
		<input type="hidden" name="id1" value="<?php if(!empty($npdm)) echo $npdm->id; ?>">		
		<input type="hidden" name="save_status" value="1" class="save_status">				
		<hr>
		<div class="bottom-bdr"></div>
		<div class="container">
         <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
			<div class=" item form-group">
				<label class="col-md-3 col-sm-3 col-xs-12" for="img">Product Name</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					
					<input id="product_name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($npdm)) echo $npdm->product_name; ?>" name="product_name" placeholder="" required="required" type="text"> 

				</div>
			</div>





		<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Product Requirement<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					
					<textarea id="product_require" rows="6" name="product_require" class="form-control col-md-7 col-xs-12" placeholder=""><?php if(!empty($npdm)) echo $npdm->product_require; ?></textarea>

				</div>						
		</div>



		<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Budget Assigned<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">					
					<input id="budget_assigned" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($npdm)) echo $npdm->budget_assigned; ?>" name="budget_assigned" placeholder="" required="required" type="text">
				</div>						
		</div>

</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
			<div class="form-group">
			         <label class="col-md-3 col-sm-2 col-xs-12" for="textarea">End Date</label>			
						
						<div class="col-md-6 col-sm-12 col-xs-12">	
							<div class=" xdisplay_inputx form-group has-feedback">

							<input type="date" class="form-control has-feedback-left" name="end_date" id="end_date" aria-describedby="inputSuccess2Status3" value="<?php if(!empty($npdm)) echo $npdm->end_date ;?>">

							<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
							<span id="inputSuccess2Status3" class="sr-only">(success)</span>
						</div>
					</div>
					</div>
				<div class=" item form-group">
					<label class="col-md-3 col-sm-12 col-xs-12">NPDM Status</label>
					

					<div class="col-md-6 col-sm-12 col-xs-12">
					
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="npdm_status" data-id="npdm_status" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true">
							<option value="">Select Option</option>
							 <?php
								if(!empty($npdm)){
									$status = getNameById('npdm_status',$npdm->npdm_status,'id');
									echo '<option value="'.$npdm->npdm_status.'" selected>'.$status->name.'</option>';
								}
							?>
						</select>	
					
					</div>					
</div>

<div class=" item form-group">
								<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Attachments</label>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<input type="file" class="form-control col-md-2 col-sm-2 col-xs-12" name="attachment[]"> 
								</div>
								<button class="btn field_button" type="button"><i class="fa fa-plus"></i></button>
								
								</div>
								<div class="item form-group fields_wrap" >
								
								</div>
						
		</div>
</div>
<div class="item form-group col-md-12 col-sm-12 col-xs-12"></div>		
				
					<?php if(!empty($attachments)){?>
							<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							   <label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label>
								<div class="col-md-7 outline">
									<?php foreach($attachments as $attachment){
												echo '<div class="img-wrap col-md-4"><div class="col-md-12 img-outline"><a href="javascript:void(0)" class="delete_listing close-link cross" style="z-index:111;" data-href="'.base_url(). 'crm/deleteAttachment/'.$attachment[ 'id']. '"><i class="fa fa-trash" style="color:#e60a03;"></i></a><a href="'.base_url(). 'assets/modules/crm/uploads/'.$attachment[ 'file_name']. '" download><img style="height:50px;" src="'.base_url(). 'assets/modules/crm/uploads/'.$attachment[ 'file_name']. '" alt="image" class="img-responsive"/></a></div></div>';
											}
									?>
								</div>
							</div>
						<?php } ?>
						
					<div class="ln_solid"></div>


<!-- /page content -->
                   
          
                    </div>
			<!--NPDm End-->
			</div>
		</div>
	

			<div id="Details2" class="tab-pane fade in " style="padding-top: 25px;">
			<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
			<!-- <div class="item form-group">
					<label class="col-md-3 col-sm-12 col-xs-12" for="address2">Designation</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<input type="text" id="designation" name="designation" class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value="<?php #if(!empty($lead)) echo $lead->designation; ?>"> 
					</div>
				</div> -->
				
				<?php /*<div class="item form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12" for="quantity"> Quantity </label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<input type="text" id="quantity" name="quantity" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($lead)) echo $lead->quantity; ?>" placeholder="0" > 
					</div>
				</div>
				<div class="item form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12" for="uom">Unit Of Measurment</label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<select class="form-control" name="uom" width="100%" tabindex="-1" aria-hidden="true">
							<option>Select Option</option>
							<?php
							$measurementUnits = measurementUnits();									
							foreach($measurementUnits as $measurementUnit){
									$selectedUom = '';
									if(!empty($lead) && $measurementUnit == $lead->uom){
										$selectedUom = 'selected';
									}else{
										$selectedUom = '';
									}
									echo '<option value="'.$measurementUnit.'" '.$selectedUom.'>'.$measurementUnit.'</option>';	
							}
							?>
						</select>	
					</div>
				</div>
					
				<div class="item form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12" for="address2">Products <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<input type="text" id="products" name="products" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($lead)) echo $lead->products; ?>"> 
					</div>
				</div> */?>
				<div class="item form-group">
					<label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Website</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<input type="url" id="website" name="website" class="optional form-control col-md-7 col-xs-12" placeholder="http://www.website.com" value="<?php if(!empty($lead)) echo $lead->website; ?>" data-validate-length-range="0"> 
					</div>
				</div>

				<div class="form-group">
								<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">End Date </label>
								<div class="col-md-6 col-sm-10 col-xs-12">
									<input type="date" name="end_date" class="optional form-control col-md-7 col-xs-12"  value="<?php if(!empty($lead)) echo $lead->end_date; ?>"> 
								</div>
							</div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">				
				<div class="item form-group">
				<?php $leadStatuses = leadStatus();  ?>
					<label class="col-md-3 col-sm-12 col-xs-12">Lead Status</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
					
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="lead_status" data-id="lead_status" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true">
							<option value="">Select Option</option>
							 <?php
								if(!empty($lead)){
									$status = getNameById('lead_status',$lead->lead_status,'id');
									echo '<option value="'.$lead->lead_status.'" selected>'.$status->name.'</option>';
								}
							?>
						</select>	
					
					
						
					</div>
				</div>		
				<div class="item form-group">
					<?php $leadSources = leadSource();  ?>
					<label class="col-md-3 col-sm-12 col-xs-12">Lead Source</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="lead_source" data-id="add_lead_source" data-key="id" data-fieldname="leads_source_name" width="100%"  data-where ="created_by_cid = 0 or created_by_cid = <?php echo $this->companyGroupId ?> ">
							<option value="">Select Option</option>
							 <?php
								if(!empty($lead)){
									$status = getNameById('add_lead_source',$lead->lead_source,'id');
									
									echo '<option value="'.$lead->lead_source.'" selected>'.$status->leads_source_name.'</option>';
								}
							?>
						</select>							
					</div>
				</div>

				<div class="item form-group">
								<?php $leadSources = leadSource();  ?>
								<label class="col-md-3 col-sm-2 col-xs-12">Leads Industry</label>
								<div class="col-md-6 col-sm-10 col-xs-12">
									<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="lead_industry" data-id="add_industry" data-key="id" data-fieldname="industry_detl" width="100%" tabindex="-1" aria-hidden="true" data-where ="active_inactive = 1 and created_by_cid = 0 or created_by_cid = <?php echo $this->companyGroupId ?>">
									  	<option value="">Select Option</option>
										<?php
											if(!empty($lead)){
												$status = getNameById('add_industry',$lead->lead_industry,'id');
												echo '<option value="'.$lead->lead_industry.'" selected>'.$status->industry_detl.'</option>';
											}
										?>
									</select>							
								</div>
							</div>	
				</div>
	</div>
   </div>
  </div>
</div>	
<hr>
<div class="bottom-bdr"></div>				
			
				
				<h3 class="Material-head">Product Details <hr></h3>

					<!--div class="item form-group col-md-6 col-sm-12 col-xs-12 vertical-border">
						<label class="col-md-3 col-sm-3 col-xs-12" for="material">Material Type <span class="required">*</span></label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type_id">
								<option value="">Select Option</option>
								<?php/*
								if (!empty($lead)) {
									$material_type_id = getNameById('material_type', $lead->material_type_id, 'id');
									echo '<option value="' . $lead->material_type_id . '" selected>' . $material_type_id->name . '</option>';
								}*/
								?>
							</select>
						</div>
					</div-->
			

				
					<div class="col-md-12 col-sm-12 col-xs-12 form-group input_detail middle-box">
					<?php if(empty($lead)){ ?>
					   <div class="col-sm-12  col-md-12 label-box mobile-view2">
					   				<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Type<span class="required">*</span></label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name<span class="required">*</span></label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Quantity &nbsp;&nbsp;UOM</label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Price</label></div>				  
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>GST </label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Total</label></div>
				                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">GST Total</label></div>
				   
			                 </div>
						
							<div class="well scend-tr mobile-view" id="chkIndex_1" style="overflow:auto; ">
								<div class="col-md-2 col-sm-12 col-xs-12 form-group">
								<label class="col-md-12 col-xs-12">Material Type<span class="required">*</span></label>
									<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 select2-width-imp" name="material_type_id_val[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type_id">
										<option value="">Select Option</option>
									</select>
								</div>
								<div class="col-md-2 col-sm-12 col-xs-12 form-group">
								<label class="col-md-12 col-xs-12">Material Name <span class="required">*</span></label>
									<select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name_id[]" onchange="getUom(event,this)">
										<option value="">Select Option</option>
									</select>
								</div>
								<div class="col-md-2 col-sm-12 col-xs-12 form-group">
								<label class="col-md-12 col-xs-12">Description</label>
									<textarea id="description" name="description[]" rows="1" class="form-control col-md-7 col-xs-12 description"></textarea>					
								</div>	
								<div class="col-md-2 col-sm-6 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12" style="float: left;width: 100%;">Quantity &nbsp;&nbsp;UOM</label>
									<input type="text" id="quantity" name="qty[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
									<input type="text" id="uom" name="uom_material1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12 uom_material"   readonly>

									<input type="hidden" name="uom_material[]" id="uomid" readonly>
								</div>

								<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12">Price</label>
									<input type="text" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" value="">
								</div>
								
								
								<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12">GST </label>
										<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="" placeholder="gst" readonly>
								</div>				
								<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12">Total</label>
										<input type="text" name="totals[]" placeholder="total" class="form-control col-md-7 col-xs-12 total" min="0" readonly value="">
								</div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12" style=" border-right: 1px solid #c1c1c1 !important;">GST Total </label>
										<input style=" border-right: 1px solid #c1c1c1 !important;" type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="" readonly>
								</div>	
                               <button  class="btn  btn-danger delete_btn" type="button"> <i class="fa fa-minus"></i></button>
					       
                               </div>
								<div class="col-sm-12 btn-row"><button style="margin-top: 22px;" class="btn edit-end-btn addMoreButton " type="button" align="right">Add</button></div>
								
						<?php } 
						
								if(!empty($lead) && $lead->product_detail !=''){ 
								$product_info = json_decode($lead->product_detail);
								
								if(!empty($product_info)){ 
								$i =1;
								?>
								 <div class="col-sm-12  col-md-12 label-box mobile-view2">
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name<span class="required">*</span></label></div>
								   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label></div>
								   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Quantity &nbsp;&nbsp;UOM</label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Price</label></div>				  
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>GST </label></div>
								   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Total</label></div>
				                   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">GST Total</label></div>
				   
			                 </div>
								<?php
								foreach($product_info as $productInfo){ 
								
								$materialName = getNameById('material',$productInfo->material_name_id,'id');
								
								?>		
							
								<div class="well scend-tr mobile-view" id="chkIndex_<?php echo $i; ?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12">Material Name <span class="required">*</span></label>
										<select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name_id[]"  data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND material_type_id = <?php echo $lead->material_type_id;?> AND status=1" onchange="getUom(event,this)">
											<option value="">Select Option</option>
											<?php echo '<option value="'.$productInfo->material_name_id.'" selected>'.$materialName->material_name.'</option>';?>
										</select>
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12">Description</label>
										<textarea id="description" name="description[]" rows="1" class="form-control col-md-7 col-xs-12 description"><?php if(!empty($lead)) echo $productInfo->description; ?></textarea>					
									</div>	
									<div class="col-md-3 col-sm-6 col-xs-12 form-group">
										<label class="col-md-12 col-xs-12" style="float: left;width: 100%;">Quantity &nbsp;&nbsp;UOM</label>
										<input type="text" id="quantity" name="qty[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" value="<?php if(!empty($lead)) echo $productInfo->qty; ?>">
										
										<input type="text" id="uom" name="uom_material1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($lead)) 


											$ww =  getNameById('uom',  $productInfo->uom_material,'id');
														$uom = !empty($ww)?$ww->ugc_code:'';
														echo $uom;
										?>" readonly>
										
										<input type="hidden" name="uom_material[]" id="uomid" readonly>
									</div>

									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										<label class="col-md-12 col-xs-12">Price</label>
										<input type="text" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" value="<?php if(!empty($lead)) echo $productInfo->price; ?>">
									</div>
									
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
									<label class="col-md-12 col-xs-12">GST </label>
										<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="<?php if(!empty($lead) && isset($productInfo->gst)) echo $productInfo->gst; ?>" placeholder="gst" readonly>
									</div>				
									<div class="col-md-1 col-sm-6 col-xs-12 form-group">
										<label class="col-md-12 col-xs-12">Total</label>
											<input type="text" name="totals[]" placeholder="total" class="form-control col-md-7 col-xs-12 total" min="0" readonly value="<?php if(!empty($lead) && isset($productInfo->total)) echo $productInfo->total; ?>">
									</div>
									<div class="col-md-2 col-sm-6 col-xs-12 form-group">
										<label style="border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-xs-12">GST Total </label>
											<input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="<?php if(!empty($lead) && isset($productInfo->TotalWithGst)) echo $productInfo->TotalWithGst; ?>" readonly>
									</div>		
									
									
									
									
								
                              
									  <button style="margin-right: 0px;" class="btn  btn-danger delete_btn" type="button"> <i class="fa fa-minus"></i></button>
							  
							  </div>
								<div class="col-sm-12 btn-row">
							          <button style="margin-top: 22px;" class="btn edit-end-btn addMoreButton " 	type="button" align="right">Add</button></div>
							<?php $i++;
										}
									}
								}
								?>
									
					</div>									
				</div>
				
				<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
                   

					<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
						
					<div class="col-md-12 col-sm-5 col-xs-12 text-right">
						
						
						<div class="col-md-6 col-sm-5 col-xs-6 ">
							<input type="hidden"  name="total" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($lead)){ echo $lead->totalwithoutgst ; } ?>"> 
							<strong>Total:</strong>&nbsp;&nbsp;
							</div>
							<div class="col-md-6 text-left"> <span class="fa fa-rupee divSubTotal"><?php if(!empty($lead)){ echo $lead->totalwithoutgst ; } else{ echo 0; }?></div>	
							 
						
                         <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 20px;color: #2C3A61; border-top: 1px solid #2C3A61;">
						<div class="col-md-6 col-sm-5 col-xs-6 ">
							<input type="hidden"  name="grandTotal" required="required" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($lead)){ echo $lead->grand_total ; }?>"> 
							<strong>Grand Total:</strong>
							</div>
							<div class="col-md-6 text-left"><span class="fa fa-rupee divTotalLead"><?php if(!empty($lead)){ echo $lead->grand_total ;} else{ echo 0; }?></span></div>	
							 </div>
						</div>
					</div>
						
					</div>
				
				<!--<div class="col-md-7 col-sm-5 col-xs-6 text-right">
						  <input type="hidden"  name="total" required="required" class="form-control col-md-7 col-xs-12"  value="</?php if(!empty($lead)){ echo $lead->totalwithoutgst ; } ?>"> 
							<strong>Total:</strong>&nbsp;&nbsp;
							<div class="col-md-5 col-sm-5 col-xs-6 text-left">
							      <span class="fa fa-rupee divSubTotal"></?php if(!empty($lead)){ echo $lead->totalwithoutgst ; } else{ echo 0; }?></span>
							</div>
							 
		


			
							<input type="hidden"  name="grandTotal" required="required" class="form-control col-md-7 col-xs-12"  value="</?php if(!empty($lead)){ echo $lead->grand_total ; }?>"> 
							<strong>Grand Total:</strong>&nbsp;
							
							<div class="col-md-5 col-sm-5 col-xs-6 text-left">
							     <span class="fa fa-rupee divTotalLead"></?php if(!empty($lead)){ echo $lead->grand_total ;} else{ echo 0; }?></span>
							</div>
				</div>-->
					<div class="ln_solid"></div>
					<div class="form-group">
					   <center>
						<div class="col-md-12 col-xs-12">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="reset" class="btn btn-default">Reset</button>
							<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">
							<input type="submit" class="btn edit-end-btn" value="Submit">
						</div>
						</center>
					</div>
	</form>	
<?php } ?>

<!------------------END Add / Edit lead form modal end-------------------->

<!--------------Quick add material code original----------------------->
	<div class="modal left fade lead_modal" id="myModal_Add_matrial_details" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Add Material Details</h4>
					<span id="mssg34"></span>
				</div>
				<form name="insert_party_data" name="ins"  id="insert_Matrial_data_id">
					<div class="modal-body">
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="name">Material Name <span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="material_name" name="material_name" required="required" class="form-control col-md-7 col-xs-12" value="">
								<span class="spanLeft control-label"></span>
							</div>
						</div> 
							<input type="hidden" name="tgytmaterial_type_id" id="materialtypeid"  class="form-control" value="">
						
						<!--<input type="hidden" name="material_type_id" id="material_type_id"  class="form-control" value="">-->
						<input type="hidden" name="prefix"  id="prefix">
						<span class="spanLeft control-label"></span>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">HSN Code </label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<!--input type="text" id="hsn_code" name="hsn_code" class="form-control col-md-7 col-xs-12" value="" -->
								 <select class="select2 form-control" id="hsn_code" name="hsn_code"  style="font-size:17px;" >
								 <option value="">Select Option</option>
								 <?php
								 //
								  $whereCompany = "(created_by_cid ='" . $this->companyGroupId . "')";
								  // pre($whereCompany);
								  $hsnmasterData = $this->crm_model->get_filter_details('hsn_sac_master', $whereCompany);
								 foreach($hsnmasterData as $hsnval){
									$totalVal = $hsnval['sgst'] + $hsnval['cgst'];
									$showVal = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$hsnval['sgst']. '  + ' . $hsnval['cgst']. '  + ' . $totalVal.'  G ';

									$valt = $hsnval['hsn_sac'].'   '.$showVal;
									
									 
									echo '<option value="'.$hsnval['id'].'"  data-id="'.$totalVal.'" >'.$valt.'</option>';
								 }
								 ?>
							   </select>
								<span class="spanLeft control-label"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="gst">GST</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="gst_tax" name="gst_tax" class="form-control col-md-7 col-xs-12" value="" onkeypress="return float_validation(event, this.value)">
								<span class="spanLeft control-label"></span>
							</div>
						</div>	
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">UOM</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<select class="uom selectAjaxOption select2 form-control" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php 	echo $this->companyGroupId; ?> OR created_by_cid = 0 AND active_inactive = 1">
							<option value="">Select Option</option>
								<?php 
			if(!empty($materials)){
			$materials = getNameById('uom',$materials->uom,'uom_quantity');
			echo '<option value="'.$material->id.'" selected>'.$material->uom_quantity.'</option>';
							 }
								?>
									</select>
								<span class="spanLeft control-label"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">Opening Balance</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="opening_balance_Sec" name="opening_balance" class="form-control col-md-7 col-xs-12" value="">
							<span class="spanLeft control-label"></span>
						</div>
					</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="gstin">Specification</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification"></textarea>
								<span class="spanLeft control-label"></span>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" id="add_matrial_Data_onthe_spot">
						<button type="button" class="btn btn-default close_sec_model" >Close</button>
						<button id="Add_matrial_details_on_button_click" type="button" class="btn edit-end-btn ">Submit</button>
					</div>
				</form>
			</div>
        </div>
    </div>



<!----------------Change lead status modal start------------------>

<!----------------Change lead status modal end------------------>