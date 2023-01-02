<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/saveWorker" enctype="multipart/form-data" id="workerForm" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php if(!empty($workers)){ echo $workers->id;} ?>">
   <input type="hidden" name="save_status" value="1" class="save_status">
   <?php
      if(empty($workers)){
      ?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <?php }else{ ?>	
   <input type="hidden" name="created_by" value="<?php if($workers && !empty($workers)){ echo $workers->created_by;} ?>" >
   <?php } ?>
   <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
     


<div class="item form-group">
        <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 compny_unit" id="compny_unit" required="required" name="company_unit" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
               <option value="">Select Unit</option>
               <?php
                  if(!empty($workers)){
                      $getUnitName = getNameById('company_address',$workers->company_unit,'compny_branch_id');
                     #echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                     echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                  }
                  
                  ?>
            </select>
           
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12">Department <span class="required">*</span> </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <!--<select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="department_id"  tabindex="-1" aria-hidden="true">-->
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" id="department"  required="required" name="department_id"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = '<?php echo (!empty($workers))?$workers->company_branch:''; ?>'" >
               <option value="">Select Option</option>
               <?php
                  if(!empty($workers)){
                     $departmentData = getNameById('department',$workers->department_id,'id');
                     if(!empty($departmentData)){
                        echo '<option value="'.$departmentData->id.'" selected>'.$departmentData->name.'</option>';
                     }
                  }
                  ?>                      
            </select>
         </div>
      </div> 

     <div class="item form-group">
     <label class="col-md-3 col-sm-12 col-xs-12" for="textarea" >Shift <span class="required">*</span></label>
       <?php if(empty($workers)){?>
            <div class="radio_button"></div>
            <div class="Displaymessage"></div>
            <?php }else{
               if(!empty($productionSetting)){
               foreach($productionSetting as $ps){   
                 if($workers->department_id == $ps['department']){
               ?>
            <div class="radio_edit">
               <label>
               <input type="radio" class="flat" name="shift_id" value="<?php echo $ps['id']; ?>" <?php if($workers->shift_id == $ps['id']){echo 'checked';} ?>><?php echo $ps['shift_name']; ?></br>
               </label>
            </div>
            <?php } 
               }}?>
            <div class="radio_button"></div>
            <div class="Displaymessage"></div>
            <?php }?> 



       </div>  
       <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="biomatricid">Biometric ID </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="number" id="biomatricid" name="biomatricid"   class="form-control col-md-7 col-xs-12" placeholder="Biomatric ID" value="<?php if(!empty($workers)) echo $workers->biomatricid; ?>">
         </div>
      </div>
		<div class="form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Employee Type</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control custom-select" data-placeholder="" tabindex="1" name="worker_type" required>
               <option value="">Select Employee Type</option>
               <option value="on_roll" <?php if(isset($workers->worker_type) && $workers->worker_type == "on_roll") { echo "selected"; } ?> >On Roll</option>
               <option value="temporary"  <?php if(isset($workers->worker_type) && $workers->worker_type == "temporary") { echo "selected"; } ?> >Temporary</option>
               <option value="contractor_roll"  <?php if(isset($workers->worker_type) && $workers->worker_type == "contractor_roll") { echo "selected"; } ?> >Contractor Roll</option>
               <option value="maintenance"  <?php if(isset($workers->worker_type) && $workers->worker_type == "maintenance") { echo "selected"; } ?> >Maintenance</option>
               <option value="worker"  <?php if(isset($workers->worker_type) && $workers->worker_type == "worker") { echo "selected"; } ?> >Worker</option>
            </select>
         </div>
      </div>
	   <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="worker_name">Department</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
             <?php   //pre($workers);  ?>
            <input type="text" id="department" name="department" class="form-control col-md-7 col-xs-12" placeholder="Department" value="<?php if(!empty($workers)) echo $workers->department; ?>">
         </div>
      </div>
	   <?php
			$HRMSettings = $this->hrm_model->get_Companydata('company_detail',array('id'=> $this->companyGroupId));
			if($HRMSettings[0]['workerSupervisor_setting']  == 1){	
		?>
	  <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="worker_name">Worker / Supervisor  <span class="required" style="color:red;">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            
			  Worker: <input type="radio" class="flat" name="worker_supervisor"  value="0" <?php if(!empty($workers) && $workers->worker_supervisor == '0')  echo 'checked'; ?> required /> 
              Supervisor: <input type="radio" class="flat" name="worker_supervisor"  value="1"  <?php if(!empty($workers) && $workers->worker_supervisor == '1')  echo 'checked'; ?>/>  
         </div>
      </div>
	  <div class="item form-group">
	   <label class="col-md-3 col-sm-12 col-xs-12" for="worker_name">Supervisor  </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="bankName form-control selectAjaxOption select2 select2-hidden-accessible" name="suervisorID" data-id="worker" data-key="id" data-fieldname="name" data-where="(created_by_cid=<?php echo $this->companyGroupId; ?> AND worker_supervisor = 1)" width="100%" >
               <option value="">Select Option</option>
               <?php
                  if(!empty($workers)){
                  $supervisorname = getNameById('worker',$workers->suervisorID,'id');
				 
                  echo '<option value="'.$supervisorname->id.'" selected>'.$supervisorname->name.'</option>';
                  }
                  ?>
            </select>
         </div>
      </div>
	<?php }else{ ?>
		<input type="hidden" class="flat" name="worker_supervisor"  value="0" >
		<input type="hidden" class="flat" name="suervisorID"  value="0" >
	<?php } ?>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="worker_name">Worker Name  <span class="required" style="color:red;">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="worker_name" name="name" required="required" class="form-control col-md-7 col-xs-12" placeholder="Worker Name" value="<?php if(!empty($workers)) echo $workers->name; ?>">
         </div>
      </div>
	   <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="worker_name">Emp Father Name  <span class="required" style="color:red;">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="father_name" name="fathername" required="required" class="form-control col-md-7 col-xs-12" placeholder="Father Name" value="<?php if(!empty($workers)) echo $workers->name; ?>">
         </div>
      </div>
	  	<div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="worker_name">Designation  </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="designation" name="designation" class="form-control col-md-7 col-xs-12" placeholder="Designation" value="<?php if(!empty($workers)) echo $workers->designation; ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="address">Address </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea type="text" name="address" class="form-control col-md-7 col-xs-12" placeholder="Address" rows="4" id="address"><?php if(!empty($workers)) echo $workers->address; ?></textarea>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="worker_name">Phone Detail</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="number" id="mobile_number" name="mobile_number"  class="form-control col-md-7 col-xs-12" placeholder="Mobile number" value="<?php if(!empty($workers)) echo $workers->mobile_number; ?>" maxlength ="10">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Country</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this)">
               <option value="">Select Option</option>
               <?php
                  if(!empty($workers)){
                  $countryName = getNameById('country',$workers->country,'country_id');
                  echo '<option value="'.$countryName->country_id.'" selected>'.$countryName->country_name.'</option>';
                  }
                  ?>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="state">State/Province</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible state_id" name="state"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)">
               <option value="">Select Option</option>
               <?php
                  if(!empty($workers)){
                  	$state = getNameById('state',$workers->state,'state_id');
                  	echo '<option value="'.$state->state_id.'" selected>'.$state->state_name.'</option>';
                  }
                  ?>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="city">city</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible city_id" name="city" width="100%" tabindex="-1" aria-hidden="true">
               <option value="">Select Option</option>
               <?php
                  if(!empty($workers)){
                  	$city = getNameById('city',$workers->city,'city_id');
                  	
                  	echo '<option value="'.$city->city_id.'" selected>'.$city->city_name.'</option>';
                  }
                  ?>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="bank_name">Bank Name</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="bankName form-control selectAjaxOption select2 select2-hidden-accessible bank_id" name="bank_name" data-id="bank_name" data-key="bankid" data-fieldname="bank_name" width="100%" tabindex="-1" aria-hidden="true" >
               <option value="">Select Option</option>
               <?php
                  if(!empty($workers)){
                  $bankName = getNameById('bank_name',$workers->bank_name,'bankid');
                  echo '<option value="'.$bankName->bankid.'" selected>'.$bankName->bank_name.'</option>';
                  }
                  ?>
            </select>
         </div>
      </div>
    </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Branch Name</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="branch_name" name="branch_name"  class="form-control col-md-7 col-xs-12" placeholder="Branch_Name" value="<?php if(!empty($workers)){ echo $workers->branch_name;} ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Account Number</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <!--<input type="text" id="Account_number" name="account_no"  class="form-control col-md-7 col-xs-12" placeholder="Account_number"  value="<?php //if(!empty($workers)) echo $workers->account_no; ?>" maxlength="16" data-validate-length ="11,16">-->
            <input type="text" id="Account_number" name="account_no"  class="form-control col-md-7 col-xs-12" placeholder="Account_number"  value="<?php if(!empty($workers)) echo $workers->account_no; ?>" minlength="8" maxlength="16">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">IFSC Code</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="ifsc_code" name="ifsc_code"  class="form-control col-md-7 col-xs-12 ifsc_code" placeholder="IFSC Code" value="<?php if(!empty($workers)) echo $workers->ifsc_code; ?>" onblur="AllowIFSC(this);">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Aadhar No</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="adharNo" name="adharNo"  class="form-control col-md-7 col-xs-12" placeholder="Aadhar No" value="<?php if(!empty($workers)){ echo $workers->adharNo;} ?>"> 
             <p style="color: red;" class="msgOnAAdhar" ></p>
          </div>
         
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">PAN No</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="panNo" name="panNo"  class="form-control col-md-7 col-xs-12" placeholder="PAN No" value="<?php if(!empty($workers)){ echo $workers->panNo;} ?>">
            <p style="color: red;" class="msgOnPan" ></p>
         </div>
      </div>
     <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="working_hrs">Working Hrs <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="number" required id="working_hrs" name="working_hrs"  class="form-control col-md-7 col-xs-12" placeholder="Working Hrs" value="<?php if(!empty($workers)) echo $workers->working_hrs; ?>">
         </div>
      </div> 
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="salary">Salary <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="number" id="salary" name="salary" required class="form-control col-md-7 col-xs-12" placeholder="Salary Of Worker" value="<?php if(!empty($workers)) echo $workers->salary; ?>">
         </div>  
      </div>  
     <!--  <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="Basic">Basic </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="number" id="Basic" name="Basic"   class="form-control col-md-7 col-xs-12" placeholder="Basic  " value="<?php if(!empty($workers)) echo $workers->Basic; ?>">
         </div>
      </div><div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="HRA">HRA </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="number" id="HRA" name="HRA"   class="form-control col-md-7 col-xs-12" placeholder="HRA  " value="<?php if(!empty($workers)) echo $workers->HRA; ?>">
         </div>
      </div><div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="Dearness_Allowance">Dearness Allowance</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="number" id="Dearness_Allowance" name="Dearness_Allowance"   class="form-control col-md-7 col-xs-12" placeholder="Dearness Allowance " value="<?php if(!empty($workers)) echo $workers->Dearness_Allowance; ?>">
         </div>
      </div><div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="Conveyance_Allowance">Conveyance Allowance</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="number" id="Conveyance_Allowance" name="Conveyance_Allowance"   class="form-control col-md-7 col-xs-12" placeholder="Conveyance Allowance " value="<?php if(!empty($workers)) echo $workers->Conveyance_Allowance; ?>">
         </div>
      </div><div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="Special_Allowance">Special Allowance</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="number" id="Special_Allowance" name="Special_Allowance"   class="form-control col-md-7 col-xs-12" placeholder="Special Allowance " value="<?php if(!empty($workers)) echo $workers->Special_Allowance; ?>">
         </div>
      </div> -->
	   
      
	   <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="joining">Date Of Birth <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="date" id="dob" name="date_of_birth" class="form-control col-md-7 col-xs-12 mydatetimepickerFull"  value="<?php if(!empty($workers)) echo $workers->date_of_birth; ?>" placeholder="Date of Birth" >
          
           <!-- <input type="text" id="date_of_join" name="date_of_joining" class="form-control col-md-7 col-xs-12 date_of_join" placeholder="Date of joining" value="<?php if(!empty($workers)) echo $workers->date_of_joining; ?>"  >-->
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="joining">Date Of Joining <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="date" id="date_of_join" name="date_of_joining" class="form-control col-md-7 col-xs-12 mydatetimepickerFull"  value="<?php if(!empty($workers)) echo $workers->date_of_joining; ?>" placeholder="Date of joining" >
          
           <!-- <input type="text" id="date_of_join" name="date_of_joining" class="form-control col-md-7 col-xs-12 date_of_join" placeholder="Date of joining" value="<?php if(!empty($workers)) echo $workers->date_of_joining; ?>"  >-->
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="relieving">Date Of Relieving</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
          <input type="date" id="date_of_reliev" name="date_of_relieving" class="form-control col-md-7 col-xs-12 mydatetimepickerFull"  value="<?php if(!empty($workers)) echo $workers->date_of_relieving; ?>" placeholder="Date of relieving" >
           <!-- <input type="text" id="date_of_reliev" name="date_of_relieving"  class="form-control col-md-7 col-xs-12 date_of_reliev" placeholder="Date of relieving" value="<?php if(!empty($workers)) echo $workers->date_of_relieving; ?>"  >-->
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Other</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea  id="other" name="other"  class="form-control col-md-7 col-xs-12" placeholder="other" rows="4"><?php if(!empty($workers)) echo $workers->other; ?></textarea>
         </div>
      </div>

			<div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="Education">Education</label>
                
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <input type="text"  name="education" class="form-control col-md-7 col-xs-12 "  value="<?php if(!empty($workers)) echo $workers->education; ?>" placeholder="Education" >
                </div>
              </div>
              <div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="plantLocation">Plant Location</label>
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <input type="text"  name="plantLocation" class="form-control col-md-7 col-xs-12 "  value="<?php if(!empty($workers)) echo $workers->plantLocation; ?>" placeholder="Plant Location" >
                </div>
              </div>
  
			
  
			<?php
		
				$workerMoreDetails = $this->hrm_model->get_Companydata('company_detail',array('id'=> $this->companyGroupId));
					if($HRMSettings[0]['hrm_worker_data']  == 1){
			?>
			<!--div class="col-md-6 col-sm-12 col-xs-12">
			   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Add More Details</button>
            </div-->
				 <div class="item form-group">
					 <label class="col-md-3 col-sm-12 col-xs-12" for="salary">Salary Slab <span class="required">*</span></label>
					 <div class="col-md-6 col-sm-12 col-xs-12">
						
						<select class="itemName selectAjaxOption select2" name="salarySlab" data-id="salary_slab" data-key="id" data-fieldname="slabname" data-where="created_by_cid = <?php echo $_SESSION['loggedInUser']->c_id; ?> " width="100%">
								<option value="">Select Option</option>
								<?php 
									if(!empty($workers) && $workers->salarySlab!=0){
										$slabNamearray = getNameById('salary_slab',$workers->salarySlab,'id');
										
										echo '<option value="'.$workers->salarySlab.'" selected>'.$slabNamearray->slabname.'</option>';
									}
								?>
							</select>
					 </div>
				  </div>
				
		<?php } ?>

</div>	
   <hr>
		<!-- Modal -->
		<!--div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h3 class="modal-title" id="exampleModalLongTitle">Worker More Details</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
					<div class="item form-group">
					 <label class="col-md-3 col-sm-12 col-xs-12" for="Education">Education</label>
					 <div class="col-md-6 col-sm-12 col-xs-12">
						<input type="text"  name="education" class="form-control col-md-7 col-xs-12 "  value="<?php if(!empty($workers)) echo $workers->education; ?>" placeholder="Education" >
					 </div>
				  </div>
				  <div class="item form-group">
					 <label class="col-md-3 col-sm-12 col-xs-12" for="plantLocation">Plant Location</label>
					 <div class="col-md-6 col-sm-12 col-xs-12">
						<input type="text"  name="plantLocation" class="form-control col-md-7 col-xs-12 "  value="<?php if(!empty($workers)) echo $workers->plantLocation; ?>" placeholder="Plant Location" >
					 </div>
				  </div>
				  <div class="item form-group">
					 <label class="col-md-3 col-sm-12 col-xs-12" for="plantLocation">Plant Location</label>
					 <div class="col-md-6 col-sm-12 col-xs-12">
						<input type="text"  name="plantLocation" class="form-control col-md-7 col-xs-12 "  value="<?php if(!empty($workers)) echo $workers->plantLocation; ?>" placeholder="Plant Location" >
					 </div>
				  </div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" >Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			  </div>
			</div>
		  </div>
		</div-->
   
   
   
   
   
   
   <div class="form-group">
      <div class="col-md-6 col-md-offset-3">
         <!--a class="btn btn-default " onclick="location.href='<?php //echo base_url();?>production/workers'">Close</a-->
         <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
         <button type="reset" class="btn edit-end-btn ">Reset</button>
         <?php if((!empty($workers) && $workers->save_status == 0) || empty($workers)){
            echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">';
            } ?>
         <input type="submit" class="btn edit-end-btn " value="submit">
      </div>
   </div>
</form>