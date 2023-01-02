 <?php 	
	//$getcompanyName = getCompanyTableId('company_detail');
	$getcompanyName = getNameById('company_detail',$_SESSION['loggedInUser']->c_id ,'id');
	$name = $getcompanyName->name;
	$CompanyName = substr($name , 0,6);
	$last_id = getLastTableId('job_card');
	$rId = $last_id + 1;	
	$jobCode = ($JobCard && !empty($JobCard))?$JobCard->job_card_no:('JC_'.rand(1, 1000000).'_'.$CompanyName.'_'.$rId);
	
?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveJobCard" enctype="multipart/form-data" id="jobCardDetail" novalidate="novalidate" style="">
  	<div class="row">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Job Card No<span class="required">*</span></label>
            <div class="col-md-7 col-xs-12 rightborder pdd-bottom">
                 <!--<input id="job_card_no" class="form-control col-md-7 col-xs-12" name="job_card_no" placeholder="JC0487" required="required" type="text" value="<?php //if(!empty($JobCard)) echo $JobCard->job_card_no; else{ echo $jobCode;} ?>" readonly>-->
						<input id="job_card_no" class="form-control col-md-7 col-xs-12" name="job_card_no" placeholder="JC0487" required="required" type="text" value="<?php  echo $jobCode; ?>" readonly>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Party Code<span class="required">*</span></label>
            <div class="col-md-7 col-xs-12 rightborder pdd-bottom">
                    <input id="party_name" class="form-control col-md-7 col-xs-12" name="party_code" placeholder="party code" required="required" type="text" value="<?php if(!empty($JobCard)) echo $JobCard->party_code; ?>">								         </select>
			</div>
    </div>
	<div class="row">
       <label class="col-md-4 col-xs-12 col-form-label" >Product Specification</label>
            <div class="col-md-7 col-xs-12 rightborder">
                   	<textarea id="product_specification" class="form-control col-md-7 col-xs-12" name="product_specification" placeholder="Enter Product Specification detail....."><?php if(!empty($JobCard)) echo $JobCard->product_specification; ?></textarea>	
		</div>
    </div>
	
  
  </div>
  <div class="col-md-6 col-xs-12">
  <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Party Requirements<span class="required">*</span> </label>
            <div class="col-md-7 col-xs-12 rightborder">
                  <textarea id="party_requirement" class="form-control col-md-7 col-xs-12" name="party_requirement" placeholder="party requirement"><?php if(!empty($JobCard)) echo $JobCard->party_requirement; ?></textarea>
		</div>
    </div>
  <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Test Certification</label>
            <div class="col-md-7 col-xs-12 rightborder">
                <textarea id="certification" name="test_certificate" class="form-control col-md-7 col-xs-12" 	placeholder="Required/Not required"><?php if(!empty($JobCard)) echo $JobCard->test_certificate; ?></textarea>
			</div>
    </div>
	 <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Lot Quantity</label>
            <div class="col-md-7 col-xs-12 rightborder">
                <input type="number" id="lot" name="lot_qty" class="form-control col-md-7 col-xs-12" placeholder="" value="<?php if(!empty($JobCard)) echo $JobCard->lot_qty; ?>">
			</div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Uom</label>
            <div class="col-md-7 col-xs-12 rightborder">
                <select class="form-control uom" name="lot_uom" id="uom">
								<option>Unit</option>
								<?php $checked ='';			
									$uom = getUom();											  
									foreach($uom as $unit) {
								
									if((!empty($JobCard)) && ($JobCard->lot_uom == $unit)){ $checked = 'selected';}else{$checked = '';  }	
									echo "<option value='".$unit."' ".$checked.">".$unit."</option>";												
									}										
								?>		
							</select>
			</div>
    </div>
  </div>
</div>

<!-- Editable table -->
<div class="card">

 
 <div class="row">
    	<div class="col-md-12">
            <div class="panel with-nav-tabs ">
                <div class="">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Material List</a></li>
                            <li><a href="#tab2default" data-toggle="tab">Machine Details</a></li>
                            
                        </ul>
                </div>
                <div class="panel-body-tabs ">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1default">
						<div id="table_edit" class="table-editable">
      <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Material Type </label>
            <div class="col-md-7 col-xs-12 rightborder pdd-bottom">
                <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id" data-id="material_type" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0 AND status = 1" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
								<option value="">Select Option</option>
								<?php
								if(!empty($JobCard)){
									$material_type_id = getNameById('material_type',$JobCard->material_type_id,'id');
									echo '<option value="'.$JobCard->material_type_id.'" selected>'.$material_type_id->name.'</option>';
									}
								?>	
						</select>
			 </div>
    </div>
	  <div class="table-responsive" style="margin-top: 1%;">
      <table class="table table-bordered">
        <thead>
          <tr>
         <th scope="col">Material Name<span class="required">*</span></th>
		 <th scope="col">Quantity</th>
		<th scope="col">UOM</th>
		<th>Delete</th>
		</tr>
        </thead>
        <tbody class="test-body">
          <tr>
            <td class="pt-3-half" contenteditable="false">
			<select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getUom(event,this);">
											<option value="">Select Option</option>
										</select> 
			</td>
          <td class="pt-3-half noeditable" contenteditable="false"><input type="text" id="qty" name="quantity[]" class="form-control col-md-7 col-xs-12  qty"  placeholder="Qty." value=""></td>
		  <td class="pt-3-half noeditable" contenteditable="false"><input type="text" id="uom" name="uom_value[]" class="form-control col-md-7 col-xs-12 uom"  placeholder="uom." value=""></td>
				<td>
              <span class="table-remove">
			  <a href="#!" class="btn btn-delete" >
			  <i class="fa fa-trash"></i></a>
			</span>
            </td>
          </tr>
        </tbody>
      </table>
	  </div>
	  <div class="table_add float-right mb-3 mr-2"><a href="#!" class="text-success">
	   <!---- <i class="fa fa-plus fa-2x" aria-hidden="true"></i>--------->
	   <p class="additem"> Add Item&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
	  
	  </a>
	  </div>
	 
	  <div class="box">
	  </div>
    </div></div>
                        <div class="tab-pane fade" id="tab2default">
						 <div class="card-body">
    <div id="table_edit_contact" class="table-editable">
      
	  <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
         <th scope="col">Process Type<span class="required">*</span></th>
      <th scope="col">Process Name<span class="required">*</span></th>
      <th scope="col">Machine Name<span class="required">*</span></th>
      <th scope="col">Production Shift<span class="required">*</span></th>
	  <th scope="col">Workers<span class="required">*</span></th>
	   <th scope="col">Do's & Dont's<span class="required">*</span></th>
	  <th scope="col"> Delete</th>
          </tr>
        </thead>
        <tbody class="test-body">
          <tr>
            <td class="pt-3-half" contenteditable><select class="form-control selectAjaxOption select2 select2-hidden-accessible processType_id select2" required="required" name="process_type[]" data-id="process_type" data-key="id" data-fieldname="process_type" tabindex="-1" aria-hidden="true" onchange="getProcess(event,this)" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
								<option value="">Select Option</option>
								</select></td>
            <td class="pt-3-half" contenteditable><select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id select2" required="required" name="process_name[]" tabindex="-1" aria-hidden="true" required="required" onchange="getMachineName(event,this)">
								<option value="">Select Option</option>
										 <?php
											if(!empty($JobCard)){
												$process_name_id = getNameById('add_process',$JobCard->add_process,'process_name_id');
												echo '<option value="'.$JobCard->process_name_id.'" selected>'.$process_name_id->process_name.'</option>';
											}
										?>
								</select></td>
            <td class="pt-3-half" contenteditable><select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id" required="required" name="machine_name[]" tabindex="-1" aria-hidden="true" required="required">
									<option value="">Select Option</option>
									 <?php
										if(!empty($JobCard)){
											$machine_name_id = getNameById('add_machine',$JobCard->machine_name,'machine_name_id');
											echo '<option value="'.$JobCard->machine_name_id.'" selected>'.$machine_name_id->machine_name.'</option>';
										}
									?>
								</select></td>
			<td class="pt-3-half" contenteditable></td>
            <td class="pt-3-half" contenteditable></td>
            <td class="pt-3-half only-numbers" contenteditable></td>
			<td>
              <span class="table-remove">
			  <a href="#!" class="btn btn-delete" >
			  <i class="fa fa-trash"></i></a>
			</span>
            </td>
          </tr>
        </tbody>
      </table>
	  </div>
	  <div class="table_contact_supplr float-right mb-3 mr-2"><a href="#!" class="text-success">
	   <!---- <i class="fa fa-plus fa-2x" aria-hidden="true"></i>--------->
	   <p class="addcontact"> Add Contact&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
	  
	  </a>
	  </div>
	 
	  <div class="box">
	  </div>
    </div>
  </div>
						</div>
                        
                    </div>
                </div>
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

                                
                        