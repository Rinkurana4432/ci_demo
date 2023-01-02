<?php 			
	$last_id = getLastTableId('add_machine');
	$rId = $last_id + 1;
	$MachineCode = 'Mac'.rand(1, 1000000).'_'.$rId;					
?>
 <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveAddMachine" enctype="multipart/form-data" id="purchaseIndentForm" novalidate="novalidate">
  	<div class="row">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Company Branch<span class="required">*</span></label>
            <div class="col-md-7 col-xs-12 rightborder pdd-bottom">
                   <select class="form-control  mrn-control select2 get_location compny_unit" required="required" name="company_branch" onChange="getDept(event,this)">
						<option value="">Select Option</option>
							<?php
								if(!empty($Addmachine)){
									echo '<option value="'.$Addmachine->company_branch.'" selected>'.$Addmachine->company_branch.'</option>';
									}
								?>
					</select>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Department<span class="required">*</span></label>
            <div class="col-md-7 col-xs-12 rightborder pdd-bottom">
                    <select class="form-control mrn-control select2 select2-hidden-accessible selectAjaxOption" id="department" required="required" name="department" width="100%" tabindex-1>									         </select>
			</div>
    </div>
	<div class="row">
       <label class="col-md-4 col-xs-12 col-form-label" >Machine Name<span class="required">*</span></label>
            <div class="col-md-7 col-xs-12 rightborder">
                   	<input id="machine_name" class="form-control mrn-control " name="machine_name" placeholder="Machine Name" required="required" type="text" value="<?php if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->machine_name; }?>">
		</div>
    </div>
	
  
  </div>
  <div class="col-md-6 col-xs-12">
  <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Machine Code </label>
            <div class="col-md-7 col-xs-12 rightborder">
                  <input id="machine_code" class="form-control mrn-control " name="machine_code" placeholder="Machine Code" required="required" type="text" value="<?php if(!empty($Addmachine)) echo $Addmachine->machine_code; else echo $MachineCode; ?>" readonly>
		</div>
    </div>
  <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Preventive Maintenance </label>
            <div class="col-md-7 col-xs-12 rightborder">
                <input id="preventive_maintenance" class="form-control mrn-control " name="preventive_maintenance" placeholder="Preventive maintenance" required="required" type="text" value="<?php if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->preventive_maintenance; }?>">
			</div>
    </div>
  </div>
</div>

<!-- Editable table -->
<div class="card">
   <ul class="nav nav-tabs">
    <li class="active"><a href="#">Machine Parameters<span class="required">*</span></a></li>
 </ul>
  <br>
 
  <div class="card-body">
    <div id="table_edit" class="table-editable">
      
	  <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
         <th scope="col">Machine Parameters <span class="required">*</span></th>
      <th scope="col">Unit</th>
	  <th scope="col"> Delete</th>
          </tr>
        </thead>
        <tbody class="test-body">
          <tr>
            <td class="pt-3-half" contenteditable></td>
            <td class="pt-3-half"><select class="form-control" name="uom[]">
										<option>Unit</option>
											<?php $checked ='';			
												$uom = getUom();											  
												foreach($uom as $unit) {												 
												if((!empty($Addmachine)) && ($machine_Parameter->uom == $unit)){ $checked = 'selected';}else{$checked = '';  }				
												echo "<option value='".$unit."' ".$checked.">".$unit."</option>";												
												}											
											?>		
									</select></td>

            <td>
              <span class="table-remove">
			  <a href="#!"  class="btn btn-delete btn-lg" >
			  <i class="fa fa-trash"></i></a>
			</span>
            </td>
          </tr>
        </tbody>
      </table>
	  </div>
	  <div class="table_add float-right mb-3 mr-2"><a href="#!" class="text-success">
	   <!---- <i class="fa fa-plus fa-2x" aria-hidden="true"></i>--------->
	   <p class="additem"> Add&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
	  </a>
	  </div>
	 
	  <div class="box">
	  </div>
    </div>
  </div>
</div>
<!-- Editable table -->
<div class="row payment-bottom">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Process Type</label>
            <div class="col-md-7 col-xs-12 rightborder pdd-bottom">
                <?php 
						if(!empty($Addmachine) && $Addmachine->process_type !=''){ 
							$processType = getNameById('process_type',$Addmachine->process_type,'id');
						}
						?>
									<select class="form-control mrn-control selectAjaxOption select2 select2-hidden-accessible processType_id select2" required="required" name="process_type" data-id="process_type" data-key="id" data-fieldname="process_type" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" tabindex="-1" aria-hidden="true" onchange="getProcess(event,this)">
										<option value="">Select Option</option>
										<?php	
										if(!empty($Addmachine) && $Addmachine->process_type !=''){ 
										echo '<option value="'.$Addmachine->process_type.'" selected>'.$processType->process_type.'</option>';
										}
										?>  
									</select>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label pdd-bottom" >Process Name</label>
            <div class="col-md-7 col-xs-12 rightborder  pdd-bottom" >
             <select class="form-control mrn-control selectAjaxOption select2 select2-hidden-accessible process_name_id" name="process_name" width="100%" tabindex="-1" aria-hidden="true" required="required" data-id="add_process" data-key="id" data-fieldname="process_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> <?php if(!empty($Addmachine) && $Addmachine->process_type !=''){  ?> AND process_type_id=<?php echo $Addmachine->process_type_id ; }?>">
							<option value="">Select Option</option>
								<?php
									if(!empty($Addmachine)){
									$processNameId = getNameById('add_process',$Addmachine->process_name,'id');
									echo '<option value="'.$Addmachine->process_name.'" selected >'.$processNameId->process_name.'</option>';
									}
								?>	
						</select>
		</div>
    </div>
<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Make And Model</label>
            <div class="col-md-7 col-xs-12 rightborder">
           <input type="text" id="make_model" name="make_model" class="form-control mrn-control " placeholder="2008; Bajaj finance" value="<?php if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->make_model; }?>"> 
			</div>
    </div>

  </div>
<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" for="rating" >Date Of Purchase </label>
            <div class="col-md-7 col-xs-12 rightborder">
               <?php /*<input type="text" id="year" name="year_purchase" class="form-control col-md-7 col-xs-12" placeholder="year" value="<?php if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->year_purchase; }?>" required="required">*/?>
						<div class=" xdisplay_inputx form-group has-feedback">
							<input type="text" class="form-control has-feedback-left machinePurchaseDate" name="year_purchase" id="" aria-describedby="inputSuccess2Status3" value="<?php if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->year_purchase; }?>">
							<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
							<span id="inputSuccess2Status3" class="sr-only">(success)</span>
						</div>
			</div>
    </div>
  <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Placement Of Machine </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <input type="text" id="placement" name="placement" class="form-control mrn-control " 	placeholder="Placement" value="<?php if(!empty($Addmachine) && $Addmachine){ echo $Addmachine->placement; }?>">
			 </div>
    </div>
</div>
</div>
<div class="bottom-form">
<p>&nbsp; &nbsp;Frieght:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<span>0.00<i class="fa fa-inr" aria-hidden="true"></i></span></p>
<p>&nbsp; &nbsp;Other Charges:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<span>50.00<i class="fa fa-inr" aria-hidden="true"></i></span></p>
<h3><span>&nbsp; &nbsp;Grand Total:&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</span><span>5000.00<i class="fa fa-inr" aria-hidden="true"></i></span></h3>
</div>
<div class="clearfix"></div>
  <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-12 sub-btns">
                        
							
                            
							<a class="btn btn-default " onclick="location.href='<?php echo base_url();?>purchase/suppliers'">Close</a>
							<button type="reset" class="btn edit-end-btn ">Reset</button>
							<?php if((!empty($suppliers) && $suppliers->save_status == 0) || empty($suppliers)){
								echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">';
							} ?>
							<input type="submit" class="btn edit-end-btn " value="submit">
                    </div>
                </div>
</form>
