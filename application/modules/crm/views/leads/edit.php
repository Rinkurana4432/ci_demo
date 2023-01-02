<?php
	if(!empty($account)) { echo '<span class="section" style="text-align: left;"><img src="/assets/images/crown-icon.png"/>'.$account->name.'</span>'; ?>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<ul class="stats-overview acc-name">

		
		
		

			<li>
				<span class="name"> Website </span>
				<span class="value text-success"> <?php echo $account->website; ?> </span>
			</li>
			<li class="hidden-phone">
				<span class="name">Phone </span>
				<span class="value text-success"><?php echo $account->phone; ?> </span>
			</li>
			<li class="hidden-phone">
			    <span class="name"> Company Owner </span>
			    <span class="value text-success"> 
				<?php $accountOwner =  getNameById('user_detail',$account->account_owner,'u_id');
					if(!empty($accountOwner)) echo $accountOwner->name; ?> 
				</span>
			</li>
		</ul>
	</div>
	<div class="bottom-bdr"></div>
	<br/><br/>
	<?php } ?>
	<!--    Tabs Start      -->
    <?php if(!empty($account)) { ?>
	<div class="col-md-12 col-sm-12 col-xs-12">
	<ul class="nav nav-tabs bar_tabs tab-2" role="tablist" id="myTab">
        <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
		<li><a href="#log_a_call" data-toggle="tab">Log A Call</a></li>
		<li><a href="#new_task" data-toggle="tab">New Task</a></li>
        <li><a href="#chatter" data-toggle="tab" id="tChatter">Chatter</a></li>
        <li><a href="#detail" data-toggle="tab">Detail</a></li>
    </ul>
    <div class="tab-content" id="account-main">
        <!--<div class="tab-pane active" id="activity">-->    
			<!--<ul class="nav nav-tabs bar_tabs" role="tablist" id="myTab">
				<li><a href="#log_a_call" data-toggle="tab">Log A Call</a></li>
				<li><a href="#new_task" data-toggle="tab">New Task</a></li>
			</ul>-->
			<div class="tab-content col-xs-12" style="border: 1px solid #807e7e;overflow: hidden;padding: 18px; ">
				<div class="tab-pane " id="log_a_call">
					<?php /*<form method="post" id="callLogForm" class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>crm/saveLeadCallLog">*/ ?>	
					<form method="post" id="callLogForm" class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>crm/saveAccountActivity">	
						<br />					
						<input type="hidden" name="id" value="<?php // if(!empty($leadCallLog)) echo $leadCallLog->id; ?>">
						<input type="hidden" name="account_id" value="<?php if(!empty($account)) echo $account->id; ?>">
						<input type="hidden" name="activity_type" value="Call Log">
						<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="item form-group">												
							<label class="col-md-3 col-sm-2 col-xs-12" for="Name">Name</label>
							<div class="col-md-6 col-sm-10 col-xs-12">												
								<input type="text" id="account_id" name="" required="required" class="form-control col-md-7 col-xs-12" <?php  if(!empty($account))  echo 'readonly'; ?> value="<?php  if(!empty($account))  echo $account->name; ?>">
							</div>											
						</div>		  												
						<div class="item form-group">													
							<label class="col-md-3 col-sm-2 col-xs-12">Subject</label>
							<div class="col-md-6 col-sm-10 col-xs-12">														
								<select class="form-control" name="subject">	
									<option value="">Select</option>
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
							<div class="col-md-6 col-sm-10 col-xs-12">														
								<textarea id="address1" required="required" rows="6" name="comment" class="form-control col-md-7 col-xs-12" placeholder=""></textarea>													
							</div>												
						</div>
                     </div>						
						 <div class="ln_solid"></div>												
						<div class="form-group">													
							<div class="col-md-12 " style="text-align: center;">														
								<button type="reset" class="btn btn-default">Reset</button>														
								<input type="submit" class="btn edit-end-btn value="Save">													
							</div>												
						</div>										
					</form>	
				</div>
				<div class="tab-pane" id="new_task">
					<form method="post" id="newTaskForm" class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>crm/saveAccountActivity">	
						<br />					
						<input type="hidden" name="id" value="<?php // if(!empty($leadCallLog)) echo $leadCallLog->id; ?>">
						<input type="hidden" name="account_id" value="<?php if(!empty($account)) echo $account->id; ?>">
						<input type="hidden" name="activity_type" value="New Task">
						<div class="col-md-6 col-sm-12 col-xs-12">	
						<div class="col-md-12 col-sm-12 col-xs-12 item form-group">										
							<label class="col-md-3 col-sm-2 col-xs-12" for="Name">Name</label>
							<div class="col-md-6 col-sm-10 col-xs-12">												
								<input type="text" id="account_id" name="" required="required" class="form-control col-md-7 col-xs-12" <?php  if(!empty($account))  echo 'readonly'; ?> value="<?php  if(!empty($account))  echo $account->name; ?>">
							</div>											
						</div>		  												
						<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
							<label class="col-md-3 col-sm-2 col-xs-12">Subject</label>
							<div class="col-md-6 col-sm-10 col-xs-12">														
								<select class="form-control" name="subject">	
									<option value="">Select</option>
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
						<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
							<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Due Date<span class="required">*</span></label>
							<fieldset class="col-md-6 col-sm-10 col-xs-12">
								<div class="control-group">
									<div class="controls">
									  <div class=" xdisplay_inputx form-group has-feedback">
										<input type="text" class="form-control has-feedback-left col-md-12 col-sm-12 col-xs-12 datePicker" name="due_date" id="single_cal3" aria-describedby="inputSuccess2Status3">
										<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
										<span id="inputSuccess2Status3" class="sr-only">(success)</span>
									  </div>
									</div>
								</div>
							</fieldset>										
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
							<label class="col-md-3 col-sm-2 col-xs-12" for="assigned_to">Assigned To<span class="required">*</span></label>
							<div class="col-md-6 col-sm-10 col-xs-12">													
								
										<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="assigned_to" required="required" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $_SESSION['loggedInUser']->c_id; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">
											<option value="">Select Option</option>											 
										</select>	

								
							</div>															
						</div>	
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12">	
						<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
							<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Comments</label>
							<div class="col-md-6 col-sm-10 col-xs-12">														
								<textarea id="comment" required="required" rows="6" name="comment" class="form-control col-md-7 col-xs-12" placeholder=""></textarea>													
							</div>												
						</div>
                       </div>	
					    <div class="ln_solid"></div>	
						<div class="col-md-12 col-sm-12 col-xs-12">												
						<div class="form-group">													
							<div class="col-md-12 " style="text-align: center;">														
								<button type="reset" class="btn btn-default">Reset</button>														
								<input type="submit" class="btn edit-end-btn value="Save">													
							</div>												
						</div>	
						</div>									
					</form>	
				</div>
			
      	<div class="tab-pane" id="chatter">
			<form method="post" id="callLogForm" class="form-horizontal form-label-left input_mask User" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo base_url();?>crm/saveAccountActivity">
				<input type="hidden" name="id" value="<?php // if(!empty($leadCallLog)) echo $leadCallLog->id; ?>">
				<input type="hidden" name="account_id" value="<?php if(!empty($account)) echo $account->id; ?>">	
				<input type="hidden" name="activity_type" value="Chatter">	
				<input type="hidden" name="subject" value="Chatter">	
				<h4>To : This Account</h4>	
                <div class="col-md-6 col-sm-12 col-xs-12">					
				<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
							<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Comments</label>
							<div class="col-md-7 col-sm-10 col-xs-12">	
				<textarea name="comment" rows="6" id="comment" required="required" class="form-control col-md-7 col-xs-12"></textarea>
				</div></div>
				
				
				<div class="">
						<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Attachments</label>
						<div class="col-md-7 col-sm-8 col-xs-12  field-attach">
							<input type="file" class="form-control " name="attachment[]"> </div>
							<div class="col-md-1 col-sm-2 col-xs-12 ">
						<button class="btn edit-end-btn field_button" type="button"><i class="fa fa-plus"></i></button></div>
						
				</div>
				<div class="item form-group fields_wrap" ></div>
				</div>		
						
			
			   <div class="ln_solid"></div>									
				<div class="form-group">													
					<div class="col-md-12 " style="text-align: center;">														
						<button type="reset" class="btn btn-default">Reset</button>														
						<input type="submit" class="btn edit-end-btn chatter" value="Save">													
					</div>												
				</div>			
			</form>
        </div>
		
			<div class="tab-pane" id="detail"> <?php } ?>
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>crm/saveAccount" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
		<input type="hidden" name="id" value="<?php if(!empty($account)){ echo $account->id;   }?>">
			<input type="hidden" name="created_by" value="<?php if(!empty($account)){ echo $account->created_by;   }?>">
		<input type="hidden" name="save_status" value="1" class="save_status">	
		
		<h3 class="Material-head" style="margin-bottom: 30px;">Information<hr></h3>
		 <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class="form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-4" for="first-name">Company Owner</label>
			<div class="col-md-6 col-sm-10 col-xs-8"> 
			
				 <span class="com-name"><?php if(!empty($_SESSION['loggedInUser'])) echo $_SESSION['loggedInUser']->name ;?></span> 
			</div>
		</div>
		
		
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="gstin">GSTIN </label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="text" id="gstin" name="gstin" class="form-control col-md-7 col-xs-12 gstin" value="<?php if(!empty($account)) echo $account->gstin ;?>" onblur="fnValidateGSTIN(this)" >  
			</div>
		</div>
		
		
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="email">Email </label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="email" id="email" name="email" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($account)) echo $account->email ;?>" >
			</div>
		</div>
		
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="phone">Phone <span class="required">*</span></label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="tel" id="phone" name="phone" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($account)) echo $account->phone ;?>"  required>
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="name">Company Name </label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="text" id="name" name="name"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($account)) echo $account->name ;?>">
			</div>
		</div>
		<?php /*<div class="item form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label col-md-2 col-sm-2 col-xs-4" for="phone">Fax</label>
			<div class="col-md-10 col-sm-10 col-xs-8">
				<input type="number" id="fax" name="fax" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($account)) echo $account->fax ;?>">
			</div>
		</div>*/?>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="parent_account">Parent Account</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<select class="itemName selectAjaxOption select2" name="parent_account" data-id="account" data-key="id" data-fieldname="name" data-where="account_owner = <?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status = 1" width="100%">
					<option value="">Select Option</option>
					<?php 
						if(!empty($account) && $account->parent_account!=0){
							$account_parent = getNameById('account',$account->parent_account,'parent_account');
							echo '<option value="'.$account->parent_account.'" selected>'.$account_parent->name.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class=" col-md-3 col-sm-2 col-xs-12" for="website">Website</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="url" id="website" name="website" class="optional form-control col-md-7 col-xs-12" value="<?php if(!empty($account)) echo $account->website ;?>">
			</div>
		</div>
		
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="type">Type</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<select class="form-control" name="type">	
					<option value="">Select</option>
					<?php 
						$accountTypes = accountType();
						$selectedType = '';
						foreach($accountTypes as $accountType) {
							if($accountType == $account->type){
								$selectedType = 'selected';
							}else{
								$selectedType = '';
							}
							echo "<option value='".$accountType."' ".$selectedType.">".$accountType."</option>";	
						}
					?>														
				</select>
			</div>
		</div>
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="employee">Employees</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="number" id="employee" name="employee" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($account)) echo $account->employee ;?>">
			</div>
		</div>
		
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="phone">Industry</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<select class="form-control" name="industry">	
					<option value="">Select</option>
					<?php 
						$selectedIndustry = '';
						$industries = industries();
						foreach($industries as $industry) {
							if($industry == $account->industry){
								$selectedIndustry = 'selected';
							}else{
								$selectedIndustry = '';
							}						
							echo "<option value='".$industry."' ".$selectedIndustry.">".$industry."</option>";	
						}
					?>														
				</select>
				
			</div>
		</div>
		
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="revenue">Annual Revenue</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="text" id="revenue" name="revenue" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($account)) echo $account->revenue ;?>">
			</div>
		</div>
		
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="description">Description</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<textarea id="description" rows="6" name="description" class="form-control col-md-7 col-xs-12" placeholder=""><?php if(!empty($account)) echo $account->description ;?></textarea>
			</div>
	   </div>

	   
		</div>
		<hr>
		<div class="bottom-bdr"></div>
<div class="container mt-3">

  <!-- Nav tabs -->
  <ul class="nav tab-3 nav-tabs">
    

    <li class="nav-item active">
      <a class="nav-link" data-toggle="tab" href="#Shipping">Shipping Address</a>
  

  </li>

<li class="nav-item ">
      <a class="nav-link " data-toggle="tab" href="#Address">Billing Address</a>
    </li>


</ul>
<div class="tab-content">
<div class="col-md-6 col-sm-12 col-xs-12 " style="margin-top: 20px;">  
  <div class="item form-group col-md-12 col-sm-12 col-xs-12">
	
			<div class="col-md-7 col-sm-10 col-xs-12">										
				<input type="checkbox" id="same_address" name="same_address" value="same_address" <?php if(!empty($account) && $account->billing_city == $account->shipping_city && $account->billing_city != 0 &&  $account->shipping_city != 0){echo 'checked';} ?>  >
					<label for="subscribeNews">Please Check if you have same address</label>
			</div>
		</div>
</div>
 <div id="Address" class="container tab-pane">
 <div class="col-md-12 col-sm-12 col-xs-12 Billing ">
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
			<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="billing_street">Billing Street</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<textarea id="billing_street" rows="6" name="billing_street" class="form-control col-md-7 col-xs-12" placeholder=""><?php if(!empty($account)) echo $account->billing_street ;?></textarea>
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="billing_zipcode">Billing Zip/Postal Code</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="number" id="billing_zipcode" name="billing_zipcode" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($account)) echo $account->billing_zipcode ;?>">
			</div>
		</div>
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="billing_country">Billing Country</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
			<?php #pre($account); ?>
				<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="billing_country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this,'billing')">
					<option value="">Select Option</option>
					 <?php
						if(!empty($account) && $account->billing_country !=0){
							$country = getNameById('country',$account->billing_country,'country_id');
							echo '<option value="'.$account->billing_country.'" selected>'.$country->country_name.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="billing_state">Billing State&nbsp;/ &nbsp;Province</label>
			<div class="col-md-6 col-sm-10 col-xs-12">								
				<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible billing state_id" name="billing_state"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this,'billing')">
					<option value="">Select Option</option>
					 <?php
						if(!empty($account) && $account->billing_state !=0){
							$state = getNameById('state',$account->billing_state,'state_id');
							echo '<option value="'.$account->billing_state.'" selected>'.$state->state_name.'</option>';
						}
					?>
				</select>
			</div>
		</div>
			
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="city">Billing City</label>
			<div class="col-md-6 col-sm-10 col-xs-12">										
				<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible billing city_id" name="billing_city"  width="100%" tabindex="-1" aria-hidden="true" >
					<option value="">Select Option</option>
					 <?php
						if(!empty($account) && $account->billing_city !=0){
							$city = getNameById('city',$account->billing_city,'city_id');
							echo '<option value="'.$account->billing_city.'" selected>'.$city->city_name.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		
		</div>
		</div>
</div>

 <div id="Shipping" class="container tab-pane active" >
 <div class="col-md-12 col-sm-12 col-xs-12 Shipping" style="border-left: 0px !important;">
	 <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="shipping_street">Shipping Street</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<textarea id="shipping_street" rows="6" name="shipping_street" class="form-control col-md-7 col-xs-12" placeholder=""><?php if(!empty($account)) echo $account->shipping_street ;?></textarea>
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="phone">shipping Zip/Postal Code</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="text" id="shipping_zipcode" name="shipping_zipcode" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($account)) echo $account->shipping_zipcode ;?>">
			</div>
		</div>
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="shipping_country">Shipping Country</label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="shipping_country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this,'shipping')">
					<option value="">Select Option</option>
					 <?php
						if(!empty($account) && $account->shipping_country!=0){
							$country = getNameById('country',$account->shipping_country,'country_id');
							echo '<option value="'.$account->shipping_country.'" selected>'.$country->country_name.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="shipping_state">Shipping State&nbsp;/ &nbsp;Province</label>
			<div class="col-md-6 col-sm-10 col-xs-12">								
				<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible shipping state_id" name="shipping_state"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this,'shipping')">
					<option value="">Select Option</option>
					 <?php
						if(!empty($account) && $account->shipping_state!=0){
							$state = getNameById('state',$account->shipping_state,'state_id');
							echo '<option value="'.$account->shipping_state.'" selected>'.$state->state_name.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-12" for="shipping_city">Shipping City</label>
			<div class="col-md-6 col-sm-10 col-xs-12">										
				<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible shipping city_id" name="shipping_city"  width="100%" tabindex="-1" aria-hidden="true">
					<option value="">Select Option</option>
					 <?php
						if(!empty($account) && $account->shipping_city!=0){
							$city = getNameById('city',$account->shipping_city,'city_id');
							echo '<option value="'.$account->shipping_city.'" selected>'.$city->city_name.'</option>';
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
	   
		
		
	   
	 
	  <!-- <div class="ln_solid"></div> -->
	  <div class="form-group" style="text-align:center;">
			<div class="col-md-12 col-xs-12">
			       <center>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="reset" class="btn btn-default">Reset</button>
					<?php if((!empty($account) && $account->save_status !=1) || empty($account)){
						echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
					}?> 
				   <input type="submit" class="btn edit-end-btn value="Submit">
				   </center>
			</div>
		</div>

	</form>
			<?php if(!empty($account)) {?> </div>
			
	<div id="activity" class="col-md-12 col-sm-12 col-xs-12 tab-pane active">
	<!-- <div class="x_title">	 -->
	<div class="Activities" >	
                          <h3 class="Material-head">Recent Activities<hr></h3>
						  
						  <div class="col-md-3 export_div">
											
					<div class="control-group ">
					  <div class="controls">
						<div class="input-prepend input-group">
						  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						  <input type="text"  name="activityDateRange" id="activityDateRange" class="form-control"/>
						  <input type="hidden" name="activityRelId" value="<?php if(!empty($account)){ echo $account->id;   }?>">
						  <input type="hidden" name="activityRelTable" value="account_activity">
						</div>
					  </div>
					</div>						
						</div>
						 <div class="col-md-4 title_right">
						     
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
		
						  <!-- <div class="clearfix"></div> -->
						  
						  <ul class="messages activityMessage col-md-12 col-sm-12 col-xs-12">
		 <?php if(!empty($account_activities)){ 
			foreach($account_activities as $activity){?>
                         
                                
			
			<li>                <div class="col-md-12 col-xs-12 head">
			                    <div class="col-md-4 col-xs-12">
			                     <!--<i class="fa </?php if($activity['activity_type'] == 'New Task'){ echo 'fa-tasks';} else if($activity['activity_type'] == 'Call Log'){ echo 'fa-phone';} else{ echo 'fa-wechat'; } ?>"></i>-->
                                <span></span>
                                <div class="message_wrapper">
								   <?php echo $activity['description']; ?>
								  </div>
								  </div>
								  <div class="message_date col-md-4">
                                  <?php echo $activity['date']; ?>
								</div>
								</div>
								<div class="col-md-12 col-xs-12 " style="text-align: left;">
								<p class="message">  <?php echo $activity['rel_type']; ?></p>
								  
                                  
								 <div class="oops"><img src="http://busybanda.com/assets/images/no-activityes.jpg"></div> 
                                 
								</div>
								
                              </li>
                             
<?php }





} ?>
                            </ul>
                        
	    
							</div>			
	<?php } 

								
									echo '<div class="oops"><img src="http://busybanda.com/assets/images/no-activityes.jpg"></div>'; 
								

	?>
	
	</div>
</div>
	
</div>
</div>
	
            <!-- /page content -->