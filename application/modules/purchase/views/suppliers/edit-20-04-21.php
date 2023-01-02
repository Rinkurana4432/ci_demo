<?php 
$last_id = getLastTableId('supplier');
$rId = $last_id + 1;
$supCode = 'SUPP_'.rand(1, 1000000).'_'.$rId; 
?>
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/saveSupplier" enctype="multipart/form-data" id="supplierForm" novalidate="novalidate">
        <input type="hidden" name="id" value="<?php if(!empty($suppliers)){ echo $suppliers->id;} ?>">
		<input type="hidden" name="save_status" value="1" class="save_status">
		<?php
			if(empty($suppliers)){
		?>
		<input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
		<?php }else{ ?>	
		<input type="hidden" name="created_by" value="<?php if($suppliers && !empty($suppliers)){ echo $suppliers->created_by;} ?>" >
		<?php }

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		?>
        <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
		
		<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
            <div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="supp_code">Supplier Code</label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="text" id="supplier_code" class="form-control col-md-7 col-xs-12" name="supplier_code" placeholder="AB001"   value="<?php if(!empty($suppliers)) echo $suppliers->supplier_code; else  echo $supCode; ?>" readonly>
                    </div>
            </div>
            <div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="supp_name">Supplier Name  <span class="required" style="color:red;">*</span></label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="text" id="supplier" name="name" required="required" class="form-control col-md-7 col-xs-12" placeholder="Supplier Name" value="<?php if(!empty($suppliers)) echo $suppliers->name; ?>">
                    </div>
            </div>
			<div class="item form-group">
                <label class="col-md-3 col-sm-2 col-xs-12" for="accnt_grp">Account Group  <span class="required" style="color:red;">*</span></label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="hidden" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="getlogin_ids">
						<select class="itemName form-control selectAjaxOption_account_group_accordingly select2 cls_add_select2 opt_Data" id="select2Opt" required="required" name="supp_account_group_id">
							<option value="">Select Type And Begin</option>
								<?php 
									if(!empty($suppliers) && $suppliers->supp_account_group_id!=0){
										$parent_group = getNameById('account_group',$suppliers->supp_account_group_id,'id');
											echo '<option value="'.$parent_group->id.'" selected>'.$parent_group->name.'</option>';
									}
								?>
						</select>  
                    </div>
            </div>
            
            <div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="gstin">GSTIN </label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="text" id="gstin" name="gstin"  class="form-control col-md-7 col-xs-12 gstin" placeholder="Enter GSTIN " value="<?php if(!empty($suppliers)) echo $suppliers->gstin; ?>"  onblur="fnValidateGSTIN(this)"/>
                    </div>
            </div>
			<div class="item form-group">
				<label class="col-md-3 col-sm-12 col-xs-12" for="mailing_name">Mailing Name <span style="color:red;">*</span></label>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" id="mailing_name" name="mailing_name" required="required" class="form-control col-md-7 col-xs-12" placeholder="Mailing Name" value="<?php if(!empty($suppliers)) echo $suppliers->mailing_name; ?>">
				</div>
			</div>
			<div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="website">Website</label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="url" id="website" name="website" class="form-control col-md-7 col-xs-12" placeholder="//www.website.com"  value="<?php if(!empty($suppliers)) echo $suppliers->website; ?>">
                    </div>
            </div>
           
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
			
							
			
			<div class="item form-group">						
				<label class="col-md-3 col-sm-12 col-xs-12">Country</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this)">
							<option value="">Select Option</option>
								<?php
									if(!empty($suppliers)){
									$country = getNameById('country',$suppliers->country,'country_id');
									echo '<option value="'.$suppliers->country.'" selected>'.$country->country_name.'</option>';
									}
								?>
						</select>
					</div>
			</div>	
			
			<div class="item form-group">
				<label class="col-md-3 col-sm-2 col-xs-12" for="state">State/Province</label>
					<div class="col-md-6 col-sm-12 col-xs-12">									
						<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible state_id" name="state"  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)">
							<option value="">Select Option</option>
								 <?php
									if(!empty($suppliers)){
										$state = getNameById('state',$suppliers->state,'state_id');
										echo '<option value="'.$suppliers->state.'" selected>'.$state->state_name.'</option>';
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
									if(!empty($suppliers)){
										$city = getNameById('city',$suppliers->city,'city_id');
										echo '<option value="'.$suppliers->city.'" selected>'.$city->city_name.'</option>';
									}
								?>
						</select>
					</div>
			</div>
			<div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="address">Address </label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <textarea type="text" name="address" class="form-control col-md-7 col-xs-12" placeholder="Address" rows="4" id="address"><?php if(!empty($suppliers)) echo $suppliers->address; ?></textarea>
                    </div>
            </div>
			
			
            
            
			
			</div>
			
<hr>			
<div class="bottom-bdr"></div>		

<div class="container">

  <ul class="nav tab-3 nav-tabs">
    <li class="active"><a data-toggle="tab" href="#Material-List">Material List</a></li>
    <li><a data-toggle="tab" href="#Contact-Details">Contact Details</a></li>
  </ul>

  <div class="tab-content">
  <div class="col-md-6 col-sm-12 col-xs-12 vertical-border" style="margin-top: 20px;">
        <div class="item form-group">
				<label class="col-md-3 col-sm-12 col-xs-12" for="materail_type">Material Type<span class="required" style="color:red;">*</span></label>
					 <div class="col-md-6 col-sm-12 col-xs-12">
						 <select class="form-control selectAjaxOption select2 select2-hidden-accessible materialTypeId select2 add_material_cls material_type_id" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="(created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0)" onchange="getMaterialName(event,this)" id = "material_type">
								<option value="">Select Option</option>
								<?php
									if(!empty($suppliers)){
									$material_type_id = getNameById('material_type',$suppliers->material_type_id,'id');
									echo '<option value="'.$suppliers->material_type_id.'" selected>'.$material_type_id->name.'</option>';
									}
								?>	
						</select>
					</div>
			</div>
  </div>
    <div id="Material-List" class="tab-pane fade in active">
	<div class="item form-group blog-mdl" style="padding-bottom: 15px;">
				
				  <div class="col-md-12 col-sm-12 col-xs-12 input_Material middle-box">
				  <?php 
					if(empty($suppliers) || (!empty($suppliers) && $suppliers->material_name_id =='')){						
						?>
						
					<div class="col-sm-12  col-md-12 label-box mobile-view2">
					   <label class="col-md-8 col-sm-12 col-xs-12 ">Material Name</label>
					   <label style=" border-right: 1px solid #c1c1c1 !important;" class="col-md-4 col-sm-12 col-xs-12">UOM</label>
					</div>
					<div class="well mobile-view" style="border-top: 1px solid #c1c1c1 !important;" id="chkIndex_1">
						 <div class="col-md-8 col-sm-8 col-xs-12 input-group" style="float:left;">
						 <label class="col-md-12 col-sm-12 col-xs-12 ">Material Name</label>
							<!-- <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name_id[]" onchange="getTax(event,this)"> -->
							<select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name_id[]">
									<option value="">Select Option</option> 
							</select>
							<input type="hidden" name="mat_idd_name" id="matrial_Iddd">	
							<input type="hidden" id="serchd_val">	  
							<input type="hidden" name="matrial_name" id="matrial_name">	 
							
							
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12 form-group">
						<label class="col-md-12 col-sm-12 col-xs-12">UOM</label>
							<input style="width:100%; border-right: 1px solid #c1c1c1 !important;" type="text" id="uom" name="uom1[]" class="form-control col-md-7 col-xs-12 uom1" readonly>


							<input type="hidden" name="uom[]" readonly class="uom">


						</div>
						
						</div>
						
								<div class="col-sm-12 btn-row"><button class="btn edit-end-btn addMoreMaterial plus-btn plus-btn" type="button">Add</button></div>
						
			       
				   
					<?php }?>
				  <?php 
					if(!empty($suppliers) && $suppliers->material_name_id !=''){ 
						$material_name = json_decode($suppliers->material_name_id);						
							if(!empty($material_name)){ 
								$i =1;
								?>
								<div class="col-sm-12  col-md-12 label-box mobile-view2">
					   <label class="col-md-8 col-sm-12 col-xs-12 ">Material Name</label>
					    <label style=" border-right: 1px solid #c1c1c1 !important;" class="col-md-4 col-sm-12 col-xs-12">UOM</label>
					</div>
								<?php
									foreach($material_name as $materialName){
										
										$material_id = $materialName->material_name_id;
											$materialname = getNameById('material',$material_id,'id');
											
						?>
					<div class="well <?php if($i==1){ echo 'edit-row1 mobile-view';}else{ echo 'scend-tr mobile-view';}?>" style="border-top: 1px solid #c1c1c1 !important;" id="chkIndex_<?php echo $i; ?>">
						 <div class="col-md-8 col-sm-8 col-xs-12 form-group">
						    <div ><label>Material Name</label></div>
							<select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name_id[]" onchange="getTax(event,this)"  data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $suppliers->material_type_id;?> AND status=1" >
								<option value="">Select Option</option>
									<?php
										echo '<option value="'.$materialName->material_name_id.'" selected>'.$materialname->material_name.'</option>';
									?>
							</select>
							<input type="hidden" name="mat_idd_name" id="matrial_Iddd" >    
							<input type="hidden" name="matrial_name" id="matrial_name">    
							<input type="hidden" id="serchd_val">   
							
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12 form-group">
						    <div  ><label style=" border-right: 1px solid #c1c1c1 !important;">UOM</label></div>
							<input style=" border-right: 1px solid #c1c1c1 !important; width:100%;" type="text" id="uom" name="uom1[]" class="form-control col-md-7 col-xs-12 uom1" readonly value="<?php echo  


												$ww =  getNameById('uom', $materialName->uom,'id');
												$uom = !empty($ww)?$ww->ugc_code:'';

								echo $uom;				

							?>">

							<input type="hidden" name="uom[]" readonly class="uom" value="<?php echo $materialName->uom; ?>">

						</div>
						
						<?php if($i==1){
								echo '<div class="col-sm-12 btn-row"><button class="btn edit-end-btn  addMoreMaterial plus-btn" type="button">Add</button></div>';
								}else{	
									echo '<button class="btn btn-danger remve_field plus-btn " type="button"><i class="fa fa-minus"></i></button>';
								} ?>		
			       </div>
					<?php  $i++;}}} ?>
					
				</div>
			</div>
	</div>
	<div id="Contact-Details" class="tab-pane fade in ">
	<div class="form-group">
                
                    <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap middle-box">
						<?php  if((empty($suppliers)) || (!empty($suppliers) && $suppliers->contact_detail =='')){  ?>
						    <div class="col-sm-12  col-md-12 label-box mobile-view2">
							   <label class="col-md-3 col-sm-12 col-xs-12 ">Name</label>
							   <label class="col-md-3 col-sm-12 col-xs-12 ">Email</label>
							   <label class="col-md-3 col-sm-12 col-xs-12 ">Designation</label>
							   <label style=" border-right: 1px solid #c1c1c1 !important;" class="col-md-3 col-sm-12 col-xs-12">Contact Number</label>
							</div>
							<div class="well mobile-view" id="chkIndex_1" style="border-top: 1px solid #c1c1c1 !important;">
							   
								<div class="col-md-3 col-sm-12 col-xs-12 form-group item">
								<label class="col-md-12 col-xs-12">Name</label>
									<input type="text" name="contact_detail[]"  id="multi_first" placeholder="Name" class="form-control col-md-7 col-xs-12" >
								</div>
								<div class="col-md-3 col-sm-12 col-xs-12 form-group item">
								<label class="col-md-12 col-xs-12">Email</label>
									<input type="email" name="email[]" placeholder="Email" class="form-control col-md-7 col-xs-12 optional" >
								</div>
								<div class="col-md-3 col-sm-12 col-xs-12 form-group item">
								  <label class="col-md-12 col-xs-12">Designation</label>
									<input type="text" name="designation[]" placeholder="Designation" class="form-control col-md-7 col-xs-12" >
								</div>
								<div class="col-md-3 col-sm-12 col-xs-12 form-group item">
								<label  class="col-md-12 col-xs-12">Contact Number</label>
									<input style=" border-right: 1px solid #c1c1c1 !important;" type="tel" name="mobile[]"  maxlength="10" placeholder="Contact number" class="form-control col-md-7 col-xs-12 optional" >
								</div>
								
							</div>
							<div class="col-sm-12 btn-row"><div class="input-group-append">
									<button class="btn edit-end-btn add_field_button plus-btn" type="button" align="right">Add</button>
								</div></div>
							
						<?php	
						}else{								
							if(!empty($suppliers) && $suppliers->contact_detail !=''){
								$contactDetail = json_decode($suppliers->contact_detail);									
									if(!empty($contactDetail)){	
										$i = 1;
										?>
										<div class="col-sm-12  col-md-12 label-box mobile-view2">
							   <label class="col-md-3 col-sm-12 col-xs-12 ">Name</label>
							   <label class="col-md-3 col-sm-12 col-xs-12 ">Email</label>
							   <label class="col-md-3 col-sm-12 col-xs-12 ">Designation</label>
							   <label style=" border-right: 1px solid #c1c1c1 !important;" class="col-md-3 col-sm-12 col-xs-12">Contact Number</label>
							</div>
										<?php
										foreach($contactDetail as $contactDetails){									
								?>
                        <div class="well <?php if($i==1){ echo 'edit-row1 mobile-view';}else{ echo 'scend-tr mobile-view';}?>" id="chkIndex_<?php echo $i; ?>">
							<div class="col-md-3 col-sm-12 col-xs-12 form-group item">
								<label>Name<span class="required">*</span></label>
                                <input type="text" name="contact_detail[]"  id="multi_first" placeholder="Name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($suppliers)){ echo $contactDetails->contact_detail;} ?>">
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group item">
								<label>Email</label>
                                <input type="email" name="email[]"  placeholder="Email" class="optional form-control col-md-7 col-xs-12" value="<?php if(!empty($suppliers)){ echo $contactDetails->email;} ?>">
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group item">
							    <label>Designation</label>
                                <input type="text" name="designation[]"  placeholder="Designation" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($suppliers)){ echo $contactDetails->designation;} ?>">
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group item">
							    <label style=" border-right: 1px solid #c1c1c1 !important;">Contact Number</label>
                                <input style=" border-right: 1px solid #c1c1c1 !important;" type="text" name="mobile[]"  placeholder="Contact number" class="optional form-control col-md-7 col-xs-12" value="<?php if(!empty($suppliers)){ echo $contactDetails->mobile;} ?>" >
                            </div>
							
						
											
											
							<?php if($i==1){
								echo '<div class="col-sm-12 btn-row"><button class="btn edit-end-btn add_field_button plus-btn" type="button">Add</button></div>';
							}else{	
								echo '<button class="btn btn-danger remove_field plus-btn" type="button"> <i class="fa fa-minus"></i></button>';
							}?>
							
							
                        </div>
                        <?php $i++;} 
						 }} } ?>
						
                    </div>
            </div>
	</div>
  </div>

</div>	
			
			
            
 <hr>			
<div class="bottom-bdr"></div>	   

<h3 class="Material-head">Bank Details<hr></h3>   
     <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
			<div class="item form-group">						
				<label class="col-md-3 col-sm-12 col-xs-12" for="bank_name">Bank Name</label>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<select class="bankName form-control selectAjaxOption select2 select2-hidden-accessible bank_id" name="bank_name" data-id="bank_name" data-key="bankid" data-fieldname="bank_name" width="100%" tabindex="-1" aria-hidden="true" >
							<option value="">Select Option</option>
								<?php
									if(!empty($suppliers)){
									$bankName = getNameById('bank_name',$suppliers->bank_name,'bankid');
									echo '<option value="'.$suppliers->bank_name.'" selected>'.$bankName->bank_name.'</option>';
									}
								?>
						</select>
					</div>
			</div>
			
			
            <div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Branch Name</label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="text" id="branch_name" name="branch_name"  class="form-control col-md-7 col-xs-12" placeholder="Branch_Name" value="<?php if(!empty($suppliers)) echo $suppliers->branch_name; ?>">
                    </div>
            </div>
            <div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Account Number</label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="text" id="Account_number" name="account_no"  class="form-control col-md-7 col-xs-12" placeholder="Account_number" data-validate-length-range="11,16" value="<?php if(!empty($suppliers)) echo $suppliers->account_no; ?>" maxlength="16">
                    </div>
            </div>
            <div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">IFSC Code</label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
						<input type="text" id="ifsc_code" name="ifsc_code"  class="form-control col-md-7 col-xs-12 ifsc_code" placeholder="IFSC Code" value="<?php if(!empty($suppliers)) echo $suppliers->ifsc_code; ?>" onblur="AllowIFSC(this)">
                    </div>
            </div>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
            <div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Other</label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <textarea  id="other" name="other"  class="form-control col-md-7 col-xs-12" placeholder="other" rows="4"><?php if(!empty($suppliers)) echo $suppliers->other; ?></textarea>
                    </div>
            </div>
            <div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="proof">Id Proof</label>
                    <div class="col-md-6 col-sm-12 col-xs-12 fields_wrap" >
						<div class="col-md-9 col-sm-11 col-xs-12"style="margin-bottom: 3%;     padding-left: 0px;">
                        <input type="file" class="form-control col-md-7 col-xs-12" name="idproof[]" >
						</div>
						<button class="btn edit-end-btn  field_button" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
                    </div>
                    
            </div>
                <?php if(!empty($idproof)){
					
					?>
                    <div class="item form-group">
                        <label class="col-md-3 col-sm-12 col-xs-12" for="proof"></label>
							<div class="col-md-7">
                                <?php
									foreach($idproof as $proof){	
							
										echo '<div class="col-md-4">
                                            <div class="image view view-first">
                                                <img style="display: block;" src="'.base_url().'assets/modules/purchase/uploads/'.$proof['file_name'].'" alt="image" class="undo" height="100" width="100"/>
                                            <div class="mask">
                                                <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'purchase/delete_idproof/'.$proof['id'].'/'.$suppliers->id.'">
                                                <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                            </div>
                                            </div>';									 
								} ?>
                            </div>
                    </div>
				<?php } ?>
	</div>
            <hr>
                <div class="form-group">
                    <div class="col-md-12 col-xs-12">
                        
							
                            <center>
							
							<button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
							<button type="reset" class="btn edit-end-btn ">Reset</button>
							<?php if((!empty($suppliers) && $suppliers->save_status == 0) || empty($suppliers)){
								echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">';
							} ?>
							<input type="submit" class="btn edit-end-btn " value="Submit">
							</center>
                    </div>
                </div>
    </form>
	
	
	
	
	
	<!---------------------------------------------------Add quick material code----------------------------------------------->
	<div class="modal left fade" id="myModal_Add_matrial_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Add Material Details</h4>
					<span id="mssg34"></span>
			</div>
			<form name="insert_party_data" name="ins"  id="insert_Matrial_data_id">
                 <div class="modal-body">
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-4 col-sm-4 col-xs-4" for="name">Material Name <span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" id="material_name" name="material_name" required="required" class="form-control col-md-7 col-xs-12" value="">
						<span class="spanLeft control-label"></span>
					</div>
				</div> 
				
					<input type="hidden" name="material_type_id" id="material_type_id"  class="form-control" value="">
					<input type="hidden" name="prefix"  id="prefix">
						<span class="spanLeft control-label"></span>
					
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-4 col-sm-4 col-xs-4" for="email">HSN Code </label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" id="hsn_code" name="hsn_code" class="form-control col-md-7 col-xs-12" value="" >
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="control-label col-md-4 col-sm-4 col-xs-4" for="email">UOM</label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
					<select class="uom selectAjaxOption select2 form-control" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php 	echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0 AND active_inactive = 1">
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
						<label class="control-label col-md-6 col-sm-6 col-xs-6" for="gstin">Opening Balance</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="opening_balance_Sec" name="opening_balance" class="form-control col-md-7 col-xs-12" value="">
							<span class="spanLeft control-label"></span>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-10 col-sm-10 col-xs-10" for="specification">Specification</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification"></textarea>
								<span class="spanLeft control-label"></span>
							</div>
						</div>
				      
				</div>
                <div class="modal-footer">
				<div class="col-md-12 col-xs-12"><center>
					<input type="hidden" id="add_matrial_Data_onthe_spot">
				    <button type="button" class="btn btn-default close_sec_model" >Close</button>
					<button id="Add_matrial_details_on_button_click" type="button" class="btn edit-end-btn ">Submit</button>
					</center>
				</div>
                </div>
				</form>
            </div>
        </div>
    </div>
