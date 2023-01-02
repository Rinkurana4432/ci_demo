<?php 	
   //$getcompanyName = getCompanyTableId('company_detail');
   $getcompanyName = getNameById('company_detail',$_SESSION['loggedInUser']->c_id ,'id');
   $name = $getcompanyName->name;
   $CompanyName = substr($name , 0,6);
   $last_id = getLastTableId('job_card');
   $rId = $last_id + 1;	
   $jobCode = ('JC_'.rand(1, 1000000).'_'.$CompanyName.'_'.$rId);
   error_reporting(0);
   ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveJobCard" enctype="multipart/form-data" id="jobCardDetail" novalidate="novalidate" style="">
   <input type="hidden" name="id" value="">
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">
   <input type="hidden" name="save_status" value="1" class="save_status">
   <?php
      if(empty($JobCard)){
   ?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <?php }else{ ?>	
   <input type="hidden" name="created_by" value="<?php if($JobCard && !empty($JobCard)){ echo $JobCard->created_by;} ?>" >
   <?php } ?>		
   <!--job card details-->
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="card_no">BOM Routing No<span class="required">*</span>
         </label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <?php
               #pre($jobCode);
            ?>
            <!--<input id="job_card_no" class="form-control col-md-7 col-xs-12" name="job_card_no" placeholder="JC0487" required="required" type="text" value="<?php //if(!empty($JobCard)) echo $JobCard->job_card_no; else{ echo $jobCode;} ?>" readonly>-->
            <input id="job_card_no" class="form-control col-md-7 col-xs-12" name="job_card_no" placeholder="JC0487" required="required" type="text" value="<?php  echo $jobCode; ?>" readonly>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="party_name">BOM Routing Product Name<span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <input  class="form-control col-md-7 col-xs-12" name="job_card_product_name" placeholder="Job Card Product Name" required="required" type="text" value="<?php if(!empty($JobCard)) echo $JobCard->job_card_product_name; ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="party_name">Party Code<span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" name="party_code" placeholder="party code" required="required" type="text" value="<?php if(!empty($JobCard)) echo $JobCard->party_code; ?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="requirement">Party Requirements<span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <textarea id="party_requirement" class="form-control col-md-7 col-xs-12" name="party_requirement" placeholder="party requirement" required="required"><?php if(!empty($JobCard)) echo $JobCard->party_requirement; ?></textarea>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="usedproduct">Product Specification</label>	
         <div class="col-md-6 col-sm-6 col-xs-12">
            <textarea id="product_specification" class="form-control col-md-7 col-xs-12" name="product_specification" placeholder="Enter Product Specification detail....."><?php if(!empty($JobCard)) echo $JobCard->product_specification; ?></textarea>	
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="certification">Test Certification</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <textarea id="certification" name="test_certificate" class="form-control col-md-7 col-xs-12" 	placeholder="Required/Not required"><?php if(!empty($JobCard)) echo $JobCard->test_certificate; ?></textarea>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="lot">Lot Quantity</label>
         <div class="col-md-3 col-sm-6 col-xs-12">
            <input type="text" id="lot" name="lot_qty" class="form-control col-md-7 col-xs-12" placeholder="" value="<?php if(!empty($JobCard)) echo $JobCard->lot_qty; ?>" onkeypress="return float_validation(event, this.value)">
         </div>
         <div class="col-md-3 col-sm-6 col-xs-12">
            <!--<select class="form-control uom" name="lot_uom" id="uom">
               <option>Select UOM</option>
               <?php $checked ='';			
                  $uom = getUom();											  
                  foreach($uom as $unit) {
                  
                  if((!empty($JobCard)) && ($JobCard->lot_uom == $unit)){ $checked = 'selected';}else{$checked = '';  }	
                  echo "<option value='".$unit."' ".$checked.">".$unit."</option>";												
                  }										
                  ?>		
               </select> -->
             <select class="uom selectAjaxOption select2 form-control" name="lot_uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" data-where="created_by_cid = <?php    echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0 AND active_inactive = 1">
               <option value="">Select Option</option>
               <?php 
                  if(!empty($JobCard)){
                  $lotuom = getNameById('uom',$JobCard->lot_uom,'id');
                  echo '<option value="'.$lotuom->id.'" selected>'.$lotuom->uom_quantity.'</option>';
                               }
                  ?>
            </select>
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <h3 class="Material-head">
      Material Details
        <span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span>
      <hr>
   </h3>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <!--<div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="material">Material Type <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
         	<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
         		<option value="">Select Option</option>
         		<?php
            if(!empty($JobCard)){
            	$material_type_id = getNameById('material_type',$JobCard->material_type_id,'id');
            	echo '<option value="'.$JobCard->material_type_id.'" selected>'.$material_type_id->name.'</option>';
            	}
            ?>	
         	</select>
         </div>
         </div> -->
   </div>
   <div class="item form-group ">
      <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
         <div class="item form-group">
            <div class="col-md-12 input_holder middle-box">
               <?php  if(empty($JobCard)){  ?>
               <div class="well " id="chkIndex_1" style=" overflow:auto;">
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Material Type</label>
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2"  name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
                        <option value="">Select Option</option>
                        <?php
                           if(!empty($JobCard)){
                           	$material_type_id = getNameById('material_type',$JobCard->material_type_id,'id');
                           	echo '<option value="'.$JobCard->material_type_id.'" selected>'.$material_type_id->name.'</option>';
                           	}
                           ?>	
                     </select>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Material Name</label>
                     <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_name[]" onchange="getUom(event,this);" id="mat_name">
                        <option value="">Select Option</option>
                        <?php
                           echo '<option value="'.$materialInfo->material_name_id.'" selected>'.$materialName->material_name.'</option>';
                           ?>
                     </select>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Quantity</label>								
                     <input type="text"  name="quantity[]" class="form-control col-md-7 col-xs-12  qty actual_qty keyup_event"  placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)">
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>UOM</label>
                     <input type="text" name="uom_value1[]" class="form-control col-md-7 col-xs-12  uom" placeholder="uom." value="" readonly><input type="hidden" name="uom_value[]" class="uom" readonly value="">						
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Price</label>	
                     <input type="text" name="price[]" class="form-control col-md-7 col-xs-12 priceValue" placeholder="Price" value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)">	
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label style="border-right: 1px solid #c1c1c1 !important;">Total</label>
                     <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="total[]" class="form-control col-md-7 col-xs-12  total" placeholder="Total Amount" value="" readonly>	
                  </div>
               </div>
               <div class="col-sm-12 btn-row" >
                  <div class="input-group-append">
                     <button class="btn edit-end-btn addmaterial" type="button">Add</button>
                  </div>
               </div>
               <?php }
                  else{ 
                  if(!empty($JobCard) && $JobCard->material_details !=''){ 
                  $material_info = json_decode($JobCard->material_details);
                  
                  if(!empty($material_info)){ 
                  
                  $i =1;
                  	foreach($material_info as $materialInfo){
                  	$material_id = $materialInfo->material_name_id;
                  	$materialName = getNameById('material',$material_id,'id');
                  
                  ?>
               <div class="well <?php if($i==1){ echo 'edit-row1';}else{ echo 'scend-tr mobile-view';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkIndex_<?php echo $i; ?>">
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Material Type</label>
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2"  name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
                        <option value="">Select Option</option>
                        <?php
                           if(!empty($materialInfo) && isset($materialInfo->material_type_id)){
                           	$material_type_id = getNameById('material_type',$materialInfo->material_type_id,'id');
                           	echo '<option value="'.$materialInfo->material_type_id.'" selected>'.$material_type_id->name.'</option>';
                           }
                           ?>	
                     </select>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Material Name</label>
                     <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot"  name="material_name[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $JobCard->material_type_id;?>  AND status=1" onchange="getUom(event,this);">
                        <option value="">Select Option</option>
                        <?php
                           echo '<option value="'.$materialInfo->material_name_id.'" selected>'.$materialName->material_name.'</option>';
                           ?>
                     </select>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                     <label>Quantity</label>
                     <input type="number"  name="quantity[]"  class="form-control col-md-7 col-xs-12 qty actual_qty" placeholder="Enter Quantity" value="<?php if(!empty($JobCard)) echo $materialInfo->quantity; ?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)">
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>UOM</label>
                     <?php
                        $ww =  getNameById('uom', $materialInfo->unit,'id');
                        $uom = !empty($ww)?$ww->ugc_code:'';
                        ?>
                     <input type="text" name="uom_value1[]" class="form-control col-md-7 col-xs-12  uom1" placeholder="uom." value="<?php echo $uom; ?>" readonly>														
                     <input type="hidden" name="uom_value[]" class="uom" readonly value="<?php if(!empty($JobCard)) echo $materialInfo->unit; ?>">
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Price</label>
                     <input type="text" name="price[]" class="form-control col-md-7 col-xs-12 priceValue" placeholder="Price" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" value="<?php if(!empty($JobCard)){ echo $materialInfo->price; }?>" onkeypress="return float_validation(event, this.value)">	
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group" >
                     <label style="border-right: 1px solid #c1c1c1 !important;">Total</label>
                     <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="total[]" class="form-control col-md-7 col-xs-12  total" placeholder="Total Amount"  value="<?php if(!empty($JobCard)){ echo $materialInfo->total; }?>" readonly>	
                  </div>
                  <button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>
               </div>
               <div class="col-sm-12 btn-row" ><button class="btn edit-end-btn  addmaterial" type="button">Add</button></div>
               <!--</?php if($i==1){
                  echo '<div class="col-sm-12 btn-row"><button class="btn edit-end-btn  addmaterial" type="button">Add</button></div>';
                  	}else{	
                  echo '<button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>';
                  } ?>-->
               <?php 
                  $i++;
                  		}}}}?>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
               <div class="col-md-5 col-sm-5 col-xs-12 text-right" style="float: right;">
                  <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 17px;color: #2C3A61; border-bottom: 1px solid #2C3A61;font-weight: normal; padding-bottom: 10px;">
                     <label class="col-md-5 col-sm-12 col-xs-12" for="total">Material Costing :</label>
                     <div class="col-md-6 col-sm-12 col-xs-12 text-left">
                        <input disabled type="text" id="material_costing" name="material_costing" class="form-control col-md-7 col-xs-12" 	placeholder="material_costing" value="<?php if(!empty($JobCard)){ echo $JobCard->material_costing; }?>">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <h3 class="Material-head">
      Process Details
      <hr>
   </h3>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="product detail">Product Name<span class="required">*</span></label>	
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible processType_id select2"  name="process_type" data-id="process_type" data-key="id" data-fieldname="process_type" tabindex="-1" aria-hidden="true" onchange="getProcess(event,this)" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
               <option value="">Select Option</option>
               <?php  if(!empty($JobCard) && $JobCard->process_type !=''){ 
                  $processType = getNameById('process_type',$JobCard->process_type,'id'); 
                  echo '<option value="'.$JobCard->process_type.'" selected>'.$processType->process_type.'</option>';
                  }
                  ?>
            </select>
         </div>
      </div>
   </div>
   <!--machinedetail-->
   <div class="item form-group">
      <div class="col-md-12 col-sm-12 col-xs-12 form-group machine_fields select-container" style="padding-bottom: 25px;">
         <?php if(empty($JobCard)){ ?>
         <div class="well well2" id="chckIndex_1" data-id="frst_div_1">
            <div>
               <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                  <div class="item form-group ">
                     <label class="col-md-3 col-sm-12 col-xs-12">Process Name<span class="required">*</span></label>						
                     <div class="col-md-6 col-sm-12 col-xs-12">
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id input-2" name="process_name[]" tabindex="-1" aria-hidden="true"  onchange="getMachineName(event,this)" id="process_name_id">
                           <option value="">Select Option</option>
                           <?php
                              if(!empty($JobCard)){
                              	$process_name_id = getNameById('add_process',$JobCard->add_process,'process_name_id');
                              	echo '<option value="'.$JobCard->process_name_id.'" selected>'.$process_name_id->process_name.'</option>';
                              }
                              ?>
                        </select>
                     </div>
                  </div>
                  <div class="item form-group ">
                     <label class="col-md-3 col-sm-12 col-xs-12">Description<span class="required">*</span></label>						
                     <div class="col-md-6 col-sm-12 col-xs-12">
                        <textarea  name="description[]" class="form-control col-md-7 col-xs-12 textarea" placeholder="Description"></textarea>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                  <div class="item form-group ">
                     <label class="col-md-3 col-sm-12 col-xs-12">Do's</label>
                     <div class="col-md-6 col-sm-12 col-xs-12"><textarea name="dos[]" class="form-control col-md-7 col-xs-12 textarea" placeholder="Do's"></textarea></div>
                  </div>
                  <div class="item form-group ">
                     <label class="col-md-3 col-sm-12 col-xs-12">Dont's</label>
                     <div class="col-md-6 col-sm-12 col-xs-12"><textarea name="donts[]" class="form-control col-md-7 col-xs-12 textarea" placeholder=" Dont's"></textarea></div>
                  </div>
               </div>
               <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                  <div class="item form-group ">
                     <label class="col-md-3 col-sm-12 col-xs-12">Attachment</label>
                     <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="hidden" name="old_doc_1" value=''>
                        <!--<input type="hidden" name="old_doc[]" value=''>-->
                        <div class="col-md-12 col-sm-12 col-xs-12 add_documents" >
                           <div class="col-md-10 col-sm-12 col-xs-10 form-group doc" id="abc_1">
                              <input type="file" class="form-control col-md-7 col-xs-12 documentsAttach_frst_div_1" name="documentsAttach[]" value="">
                           </div>
                           <button class="btn edit-end-btn  add_moreDocs" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="well col-container " style="display:table; clear:both; border-bottom:1px solid #c1c1c1;">
               <div class="total_machines_ids" id="ParameterIndexinput_1">
                  <div class="item form-group  col-md-1 col-xs-12" >
                     <div class="col" ><label>Machine name</label></div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group" >
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group machine_name_dispaly">
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id"  name="machine_name[]" tabindex="-1" aria-hidden="true" >
                              <option value="">Select Option</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="item form-group col-md-3 col-xs-12">
                     <div class="col"><label>Machine Parameter</label></div>
                     <div class="col-md-4 col-sm-4 col-xs-4  form-group" style="border-right: 1px solid #c1c1c1;">
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name form-group"></div>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-4  form-group" style="border-right: 1px solid #c1c1c1;">
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group uom"></div>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-4  form-group">
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group value"></div>
                     </div>
                  </div>
                  <div class="item form-group  col-md-2 col-xs-12" >
                     <div class="col" ><label>Production per Shift</label></div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group" >
                        <input type="text" name="production_shift[]" class="form-control col-md-7 col-xs-12 production_shift" placeholder="production per Shift"><br><br>
                     </div>
                  </div>
                  <div class="item form-group  col-md-2 col-xs-12" >
                     <div class="col" ><label>Workers</label></div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group" >
                        <input type="text" name="workers[]" class="form-control col-md-7 col-xs-12 workers" placeholder="workers"><br><br>
                     </div>
                  </div>
                  <div class="item form-group  col-md-2 col-xs-12" >
                     <div class="col" ><label>Action</label></div>
                     <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;border-bottom: 1px solid #aaa;" >
                        <button class="btn edit-end-btn  addmachineForProcesstype" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
                     </div>
                  </div>
               </div>
            </div>
            <div class="box-div">
               <h3 class="Material-head">
                  INPUT
                  <hr>
               </h3>
               <div class=" col-md-12 well_Sech_input" style="padding:0px;">
                  <div class="col-md-12 input_cls chk_idd_input" id="sechIndexinput_1" style="padding:0px;">
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <label class="col col-md-12 col-xs-12 col-sm-12">Material Type</label>
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2"  name="material_type_input_id_1[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" >
                           <option value="">Select Option</option>
                        </select>
                     </div>
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <label class="col col-md-12 col-xs-12 col-sm-12">Material Name</label>
                        <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot"   name="material_input_name_1[]" onchange="getUom_input(event,this);">
                           <option value="">Select Option</option>
                        </select>
                     </div>
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <label class="col col-md-12 col-xs-12 col-sm-12">Quantity</label>								
                        <input type="text"  name="quantity_input_1[]" class="form-control col-md-7 col-xs-12  qty_input actual_qty"  placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)">
                     </div>
                     <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                        <label class="col col-md-12 col-xs-12 col-sm-12">UOM</label>
                        <input type="text" name="uom_value_input1_1[]" class="form-control col-md-7 col-xs-12  uom_input" placeholder="uom." value="" readonly>
                        <input type="hidden" name="uom_value_input_1[]" class="uom_input_val" readonly value="">	
                     </div>
                     <div class="col-md-1 col-xs-12 col-sm-12 form-group" style="text-align: center;border-bottom: 1px solid #aaa;"> 
                        <label class="col col-md-12 col-xs-12 col-sm-12" style="padding: 17px 6px;"></label>									
                        <button class="btn edit-end-btn  add_moreinputss" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
                     </div>
                  </div>
               </div>
               <!-- Inventory Process Sechduling Issues -->
               <h3 class="Material-head">
                  OUTPUT
                  <hr>
               </h3>
               <div class=" col-md-12 well_Sech_output"  style="padding:0px;">
                  <div  class="col-md-12 output_cls chk_idd_output" id="sechIndexoutput_1" style="padding:0px;">
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <label class="col col-md-12 col-xs-12 col-sm-12">Material Type</label>
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2"  name="material_type_output_id_1[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)">
                           <option value="">Select Option</option>
                        </select>
                     </div>
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <label class="col col-md-12 col-xs-12 col-sm-12">Material Name</label>
                        <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot"  name="material_output_name_1[]" onchange="getUom_output(event,this);">
                           <option value="">Select Option</option>
                        </select>
                     </div>
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <label class="col col-md-12 col-xs-12 col-sm-12">Quantity</label>								
                        <input type="text" name="quantity_output_1[]" class="form-control col-md-7 col-xs-12  qty_output actual_qty"  placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)">
                     </div>
                     <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                        <label class="col col-md-12 col-xs-12 col-sm-12">UOM</label>
                        <input type="text" name="uom_value_output1_1[]" class="form-control col-md-7 col-xs-12  uom_output" placeholder="uom." value="" readonly>
                        <input type="hidden" name="uom_value_output_1[]" class="uom_output_val" readonly value="">						
                     </div>
                     <div class="col-md-1 col-xs-12 col-sm-12 form-group" style="text-align: center;border-bottom: 1px solid #aaa;"> 
                        <label class="col col-md-12 col-xs-12 col-sm-12" style="padding: 17px 6px;"></label>
                        <button class="btn edit-end-btn  add_moreoutputss" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 btn-row">
               <div class="input-group-append">
                  <button class="btn edit-end-btn  addmachineFields" type="button">Add</button>
               </div>
            </div>
            <!-- Inventory Process Sechduling Issues -->
         </div>
         <?php } else {  ?>	
         <?php 
            $Detailinfo = json_decode($JobCard->machine_details);
            $j =1;
            if(!empty($Detailinfo)){ 
            foreach($Detailinfo as $detail_info){	
            	$parmeterName = $detail_info->parameter;
                $uom = $detail_info->uom;
            	$values = $detail_info->value;
            	$document = (!empty($detail_info->doc) && isset($detail_info->doc))?$detail_info->doc:'';
            $machine_paramenters = !empty($detail_info->machine_details)?json_decode($detail_info->machine_details):''; ?>
         <div class="well  well2 <?php if($j==1){ echo 'edit-row1';}else{ echo 'scend-tr';}?>"  id="chckIndex_<?php echo $j; ?>" data-id="frst_div_<?php echo $j; ?>">
            <div  class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group ">
                  <label class="col-md-3 col-sm-12 col-xs-12">Process Name<span class="required">*</span></label>						
                  <div class="col-md-6 col-sm-12 col-xs-12">
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id select2"  name="process_name[]" tabindex="-1" aria-hidden="true"  onchange="getMachineName(event,this)" data-id="add_process" data-key="id" data-fieldname="process_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND process_type_id = <?php echo $JobCard->process_type;?>">
                        <option value="">Select Option</option>
                        <?php
                           $processName = getNameById('add_process',$detail_info->processess,'id'); 
                           echo '<option value="'.$detail_info->processess.'" selected>'.$processName->process_name.'</option>';
                           ?>		
                     </select>
                  </div>
               </div>
               <div class="item form-group ">
                  <label class="col-md-3 col-sm-12 col-xs-12">Description<span class="required">*</span></label>						
                  <div class="col-md-6 col-sm-12 col-xs-12">
                     <textarea name="description[]" class="form-control col-md-7 col-xs-12 textarea" placeholder="Description"><?php if(!empty($detail_info) && isset($detail_info->description)) echo $detail_info->description; ?></textarea>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group ">
                  <label class="col-md-3 col-sm-12 col-xs-12">Do's</label>
                  <div class="col-md-6 col-sm-12 col-xs-12"><textarea  name="dos[]" class="form-control col-md-7 col-xs-12 textarea" placeholder="Do's"  rows="3"><?php if(!empty($detail_info)) echo $detail_info->dos; ?></textarea></div>
               </div>
               <div class="item form-group ">
                  <label class="col-md-3 col-sm-12 col-xs-12">Dont's</label>
                  <div class="col-md-6 col-sm-12 col-xs-12"><textarea name="donts[]" class="form-control col-md-7 col-xs-12 textarea" placeholder=" Dont's"  rows="3"><?php if(!empty($detail_info)) echo $detail_info->donts; ?></textarea></div>
               </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group ">
                  <label class="col-md-3 col-sm-12 col-xs-12">Attachment</label>
                  <div class="col-md-6 col-sm-12 col-xs-12">
                     <input type="hidden" name="old_doc_<?php echo $j; ?>" value='<?php if(!empty($detail_info) && !empty($detail_info->doc)){ echo json_encode($detail_info->doc); } ?>'> 
                     <!--<input type="hidden" name="old_doc[]" value=''>-->
                     <div class="col-md-12 col-sm-12 col-xs-12 add_documents" >
                        <div class="col-md-10 col-sm-12 col-xs-10 form-group doc" id="abc_1">
                           <input type="file" class="form-control col-md-7 col-xs-12" name="documentsAttach_frst_div_<?php echo $j; ?>[]" value="">
                        </div>
                        <button class="btn edit-end-btn  add_moreDocs" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
                     </div>
                  </div>
               </div>
               <?php if(!empty($document)){
                  //pre($document);
                  	foreach($document as $doc){
                  		if(!empty($doc)){
                  		  echo '<div class="col-md-3 col-xs-3 col-sm-3"><img style="display: block; width: 100%;" src="'.base_url().'assets/modules/production/uploads/'.$doc.'" alt="image" class="undo" /></div>';
                  		}else{
                  	
                  			echo '<div class="col-md-3 col-xs-3 col-sm-3"><img style="display: block; width: 100%;" src="'.base_url().'assets/modules/production/uploads/no-image-available.jpg" alt="image" class="undo" ></div>';
                  			}
                  	}
                  }?>
            </div>
            <div class="well col-container " style="display:table; clear:both; border-bottom:1px solid #c1c1c1;">
               <?php if(!empty($machine_paramenters)){
                  $mach = 1;
                             foreach($machine_paramenters as $value){ ?> 
               <div class="total_machines_ids" id="ParameterIndexinput_<?php echo $mach ?>">
                  <div class="item form-group  col-md-1 col-xs-12" >
                     <div class="col" ><label>Machine name</label></div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group" >
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group machine_name_dispaly">
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id"  name="machine_name[<?php echo $detail_info->processess;?>][]" tabindex="-1" aria-hidden="true" data-id="add_machine" data-key="id" data-fieldname="machine_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND process_name = <?php echo $detail_info->processess;?> AND save_status=1">
                              <option value="">Select Option</option>
                              <?php
                                 $machine_info = getNameById('add_machine',$value->machine_id,'id'); 
                                 echo '<option value="'.$value->machine_id.'" selected>'.$machine_info->machine_name.'</option>';	
                                 ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="item form-group col-md-3  col-xs-12">
                     <div class="col"><label>Machine Parameter</label></div>
                     <div class="MachineParameterReplacement">
                        <?php foreach($value->parameter_detials as $parameter){ 
                                                   #pre($parameter);
                                                   //pre($val_input_sech);
                                                         $ww =  getNameById('uom', $parameter->parameter_uom,'id');
                                                         $uom = !empty($ww)?$ww->ugc_code:'';
                                                   ?>
                        <div class="col-md-4 col-sm-6 col-xs-4 form-group">
                           <div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name">
                              <input type="text" class="form-control col-md-7 col-xs-12 parameter" name="parameter[<?php echo $detail_info->processess;?>][<?php echo $value->machine_id;?>][]" value="<?php echo $parameter->parameter_name;?>" readonly>
                           </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-4 form-group">
                           <div class="col-md-12 col-sm-6 col-xs-12 form-group uom" >	
                             <input type="hidden" value="<?php echo $parameter->parameter_uom;?>" class="form-control col-md-7 col-xs-12 uom" name="uom[<?php echo $detail_info->processess;?>][<?php echo $value->machine_id;?>][]" readonly> 

                                                         <input type="text" value="<?php echo $uom;?>" class="form-control col-md-7 col-xs-12 uom" name="" readonly> 
                           </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-4 form-group">
                           <div class="col-md-12 col-sm-6 col-xs-12 form-group value">	
                              <input type="text" value="<?php echo $parameter->uom_value;?>" class="form-control col-md-7 col-xs-12 value" name="value[<?php echo $detail_info->processess;?>][<?php echo $value->machine_id;?>][]">
                           </div>
                        </div>
                        <?php } ?>
                     </div>
                  </div>
                  <div class="item form-group  col-md-2 col-xs-12" >
                     <div class="col" ><label>Production per Shift</label></div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group" >
                        <input type="text" name="production_shift[<?php echo $detail_info->processess;?>][<?php echo $value->machine_id;?>]" class="form-control col-md-7 col-xs-12 production_shift" placeholder="production per Shift" value="<?php if(!empty($value->production_shift)) echo $value->production_shift; ?>"><br><br>
                     </div>
                  </div>
                  <div class="item form-group  col-md-2 col-xs-12" >
                     <div class="col" ><label>Workers</label></div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group" >
                        <input type="text" name="workers[<?php echo $detail_info->processess;?>][<?php echo $value->machine_id;?>]"  value="<?php if(!empty($value->workers)) echo $value->workers; ?>" class="form-control col-md-7 col-xs-12 workers" placeholder="workers"><br><br>
                     </div>
                  </div>
                  <?php if($mach== 1){ ?>
                  <div class="item form-group  col-md-2 col-xs-12" >
                     <div class="col" ><label>Action</label></div>
                     <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;border-bottom: 1px solid #aaa;" >
                        <button class="btn edit-end-btn  addmachineForProcesstype" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
                     </div>
                  </div>
                  <?php }else{ ?>
                  <div class="item form-group  col-md-2 col-xs-12 RemovemachineForProcesstype" >
                     <div class="col" ><label>Action</label></div>
                     <div class="col-md-12 col-sm-12 col-xs-12"  style="text-align: center;border-bottom: 1px solid #aaa;"> <button class="btn edit-end-btn " style="margin-bottom: 3%;" type="button"><i class="fa fa-minus"></i></button> </div>
                  </div>
                  <?php } ?>
               </div>
               <?php $mach++; } }else{
                  //pre($detail_info);die;
                  				?> 
               <div class="total_machines_ids" id="ParameterIndexinput_1">
                  <div class="item form-group  col-md-1 col-xs-12" >
                     <div class="col" ><label>Machine name</label></div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group" >
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group machine_name_dispaly">
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id"  name="machine_name[<?php echo $detail_info->processess;?>][]" tabindex="-1" aria-hidden="true" data-id="add_machine" data-key="id" data-fieldname="machine_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND process_name = <?php echo $detail_info->processess;?> AND save_status=1">
                              <option value="">Select Option</option>
                              <?php
                                 $machine_info = getNameById('add_machine',$detail_info->machine_name,'id'); 
                                 echo '<option value="'.$detail_info->machine_name.'" selected>'.$machine_info->machine_name.'</option>';	
                                 ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="item form-group col-md-3 col-xs-12">
                     <div class="col"><label>Machine Parameter</label></div>
                     <div class="col-md-4 col-sm-4 col-xs-4  form-group" style="border-right: 1px solid #c1c1c1;">
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name form-group"> <?php
                           if(!empty($parmeterName)){ 
                           	foreach($parmeterName as $parameter_names){ ?>	
                           <input type="text" class="form-control col-md-7 col-xs-12" name="parameter[<?php echo $detail_info->processess;?>][<?php echo $detail_info->machine_name;?>][]" value="<?php echo $parameter_names;?>" readonly>
                           <?php }}?>
                        </div>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-4  form-group" style="border-right: 1px solid #c1c1c1;">
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group uom"><?php
                           if(!empty($uom)){ 
                           //pre($uom);
                           	foreach($uom as $uom_values){
                           			?>		
                           <input type="text" value="<?php echo $uom_values; ?>" class="form-control col-md-7 col-xs-12" name="uom[<?php echo $detail_info->processess;?>][<?php echo $detail_info->machine_name;?>][]" readonly>
                           <?php }}?>
                        </div>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-4  form-group">
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group value"><?php
                           if(!empty($values)){ 
                           	foreach($values as $values_get){
                           
                           ?>	
                           <input type="text" value="<?php  echo $values_get; ?>" class="form-control col-md-7 col-xs-12" name="value[<?php echo $detail_info->processess;?>][<?php echo $detail_info->machine_name;?>][]">
                           <?php }} ?>
                        </div>
                     </div>
                  </div>
                  <div class="item form-group  col-md-2 col-xs-12" >
                     <div class="col" ><label>Production per Shift</label></div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group" >
                        <input type="text" name="production_shift[<?php echo $detail_info->processess;?>][<?php echo $detail_info->machine_name;?>]"  value="<?php if(!empty($detail_info)) echo $detail_info->production_shift; ?>" class="form-control col-md-7 col-xs-12 production_shift" placeholder="production per Shift"><br><br>
                     </div>
                  </div>
                  <div class="item form-group  col-md-2 col-xs-12" >
                     <div class="col" ><label>Workers</label></div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group" >
                        <input type="text" name="workers[<?php echo $detail_info->processess;?>][<?php echo $detail_info->machine_name;?>]" class="form-control col-md-7 col-xs-12 workers"  value="<?php if(!empty($detail_info)) echo $detail_info->workers; ?>" placeholder="workers"><br><br>
                     </div>
                  </div>
                  <div class="item form-group  col-md-2 col-xs-12" >
                     <div class="col" ><label>Action</label></div>
                     <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;border-bottom: 1px solid #aaa;" >
                        <button class="btn edit-end-btn  addmachineForProcesstype" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
                     </div>
                  </div>
               </div>
               <?php } ?>
            </div>
            <div class="box-div ">
               <h3 class="Material-head">
                  INPUT
                  <hr>
               </h3>
               <?php
                  $input_process_dtl = (!empty($detail_info->input_process) && isset($detail_info->input_process))?$detail_info->input_process:'';
                   
                  	$process_sch_input = json_decode($input_process_dtl);
                  ?>
               <div>
                  <label class="col col-md-3">Material Type</label>
                  <label class="col col-md-3">Material Name</label>
                  <label class="col col-md-3">Quantity</label>
                  <label class="col col-md-3">UOM</label>
               </div>
               <?php	
                  if(!empty($process_sch_input)){
                  	$in = 1;
                  	
                  	foreach($process_sch_input as $val_input_sech){
                  		$countin+= count($val_input_sech);
                  		$material_id_input = $val_input_sech->material_input_name;
                  		$materialName_input = getNameById('material',$material_id_input,'id');
                  		
                  ?>
               <div class="well_Sech_input"  >
                  <div class="col-md-12 input_cls chk_idd_input" id="sechIndexinput_<?php echo $countin; ?>">
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <!--label>Material Type</label-->
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2"  name="material_type_input_id_<?php echo $j;?>[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
                           <option value="">Select Option</option>
                           <?php
                              if(!empty($val_input_sech)){
                              	$material_type_inputid = getNameById('material_type',$val_input_sech->material_type_input_id,'id');
                              	echo '<option value="'.$val_input_sech->material_type_input_id.'" selected>'.$material_type_inputid->name.'</option>';
                              }
                              ?>	
                        </select>
                     </div>
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <!--label>Material Name</label-->
                        <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot"  name="material_input_name_<?php echo $j;?>[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $JobCard->material_type_id;?>  AND status=1" onchange="getUom_input(event,this);">
                           <option value="">Select Option</option>
                           <?php
                              echo '<option value="'.$val_input_sech->material_input_name.'" selected>'.$materialName_input->material_name.'</option>';
                              ?>
                        </select>
                     </div>
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <!--label>Quantity</label-->								
                        <input type="text" name="quantity_input_<?php echo $j;?>[]" class="form-control col-md-7 col-xs-12  qty_input actual_qty"  placeholder="Qty." value="<?php if(!empty($JobCard)) echo $val_input_sech->quantity_input; ?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)">
                     </div>
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <!--label>UOM</label-->
                        <?php
                           //pre($val_input_sech);
                           		$ww =  getNameById('uom', $val_input_sech->uom_value_input,'id');
                           		$uom = !empty($ww)?$ww->ugc_code:'';
                           	 ?>
                        <input type="text" name="uom_value_input1_<?php echo $j;?>[]" class="form-control col-md-7 col-xs-12  uom_input" placeholder="uom." value="<?php echo $uom; ?>" readonly>
                        <input type="hidden" name="uom_value_input_<?php echo $j;?>[]" class="uom_input_val" readonly value="<?php if(!empty($JobCard)) echo $val_input_sech->uom_value_input1; ?>">	
                     </div>
                     <!--button class="btn edit-end-btn  add_moreinputss" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button-->
                  </div>
               </div>
               <?php 
                  $in++;} }
                  
                  
                  ?>
               <h3 class="Material-head">
                  OUTPUT
                  <hr>
               </h3>
               <?php
                  $output_process_dtl = (!empty($detail_info->output_process) && isset($detail_info->output_process))?$detail_info->output_process:'';
                  	$process_sch_output = json_decode($output_process_dtl);
                  	?>
               <div>
                  <label class="col col-md-3">Material Type</label>
                  <label class="col col-md-3">Material Name</label>
                  <label class="col col-md-3">Quantity</label>
                  <label class="col col-md-3">UOM</label>
               </div>
               <?php
                  if(!empty($process_sch_output)){
                  	$ot = 1;
                  foreach($process_sch_output as $val_output_sech){
                  	$countout+= count($val_output_sech);
                  	$material_id_output = $val_output_sech->material_output_name;
                      $materialName_output = getNameById('material',$material_id_output,'id');
                  
                  ?>
               <div class="well_Sech_output"  >
                  <div class="col-md-12 output_cls chk_idd_output " id="sechIndexoutput_<?php echo $countout; ?>" style="padding: 0px;">
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <!--label>Material Type</label-->
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2"  name="material_type_output_id_<?php echo $j; ?>[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" >
                           <option value="">Select Option</option>
                           <?php
                              if(!empty($val_output_sech) && isset($val_output_sech->material_type_output_id)){
                              	$material_type_outputid = getNameById('material_type',$val_output_sech->material_type_output_id,'id');
                              	echo '<option value="'.$val_output_sech->material_type_output_id.'" selected>'.$material_type_outputid->name.'</option>';
                              }
                              ?>	
                        </select>
                     </div>
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <!--label>Material Name</label-->
                        <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot"  name="material_output_name_<?php echo $j; ?>[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $JobCard->material_type_id;?>  AND status=1" onchange="getUom_output(event,this);">
                           <option value="">Select Option</option>
                           <?php
                              echo '<option value="'.$val_output_sech->material_output_name.'" selected>'.$materialName_output->material_name.'</option>';
                              								?>
                        </select>
                     </div>
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <!--label>Quantity</label-->								
                        <input type="text" name="quantity_output_<?php echo $j; ?>[]" class="form-control col-md-7 col-xs-12  qty_output actual_qty"  placeholder="Qty." value="<?php if(!empty($JobCard)) echo $val_output_sech->quantity_output; ?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)">
                     </div>
                     <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <!--label>UOM</label-->
                        <?php
                           $ww_output =  getNameById('uom', $val_output_sech->uom_value_output,'id');
                           $uom_output = !empty($ww_output)?$ww_output->ugc_code:'';
                           ?>
                        <input type="text" name="uom_value_output1_<?php echo $j; ?>[]" class="form-control col-md-7 col-xs-12  uom_output" placeholder="uom." value="<?php echo $uom_output; ?>" readonly>
                        <input type="hidden" name="uom_value_output_<?php echo $j; ?>[]" class="uom_output_val" readonly value="<?php if(!empty($JobCard)) echo $val_output_sech->uom_value_output; ?>">						
                     </div>
                     <!--button class="btn edit-end-btn  add_moreoutputss" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button-->
                  </div>
               </div>
               <?php $ot++; } }?>	
            </div>
            <?php if($j==1){
               //echo "sss";
               	echo '<div class="col-sm-12 btn-row"><button class="btn edit-end-btn  addmachineFields" type="button">Add</button></div>';
               }else{	
               //echo "ssssadasd";
               	echo '<button class="btn btn-primary btn-danger remove_machine" type="button"><i class="fa fa-minus"></i></button>';
               } ?>
         </div>
         <?php $j++; } ?>
         <?php  } ?>
         <?php } ?>
         <?php /*else{ ?>
         <div class="well" id="chckIndex_1" data-id="frst_div_1" style="overflow:auto;">
            <div class="item form-group">
               <label class="control-label col-md-4 col-sm-3 col-xs-12" for="product detail">Process Name<span class="required">*</span></label>	
               <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id select2" required="required" name="process_name[]" tabindex="-1" aria-hidden="true" required="required" onchange="getMachineName(event,this)">
                     <option value="">Select Option</option>
                  </select>
               </div>
            </div>
            <div class="item form-group">
               <label class="control-label col-md-4 col-sm-3 col-xs-12" for="product detail">Machine Name<span class="required">*</span></label>	
               <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id" required="required" name="machine_name[]" tabindex="-1" aria-hidden="true" required="required">
                     <option value="">Select Option</option>
                  </select>
               </div>
            </div>
            <div class="item form-group ">
               <label class="control-label col-md-4 col-sm-3 col-xs-12" for="product detail">Machine Parameter</label>
               <div class="col-md-2 col-sm-6 col-xs-12">
                  <div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name"></div>
               </div>
               <div class="col-md-2 col-sm-6 col-xs-12">
                  <div class="col-md-12 col-sm-6 col-xs-12 form-group uom"></div>
               </div>
               <div class="col-md-2 col-sm-6 col-xs-12">
                  <div class="col-md-12 col-sm-6 col-xs-12 form-group value"></div>
               </div>
            </div>
            <div class="item form-group">
               <label class="control-label col-md-4 col-sm-3 col-xs-12" for="product detail">Production/Shift</label>	
               <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                  <input type="production" id="production" name="production_shift[]" class="form-control col-md-7 col-xs-12" placeholder="production per Shift">
               </div>
            </div>
            <div class="item form-group">
               <label class="control-label col-md-4 col-sm-3 col-xs-12" for="product detail">Workers</label>	
               <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                  <input type="workers" id="workers" name="workers[]" class="form-control col-md-7 col-xs-12" placeholder="workers Needed">
               </div>
            </div>
            <div class="item form-group">
               <label class="control-label col-md-4 col-sm-3 col-xs-12" for="product detail">Do's & Dont's</label>
               <div id="content">
                  <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                     <textarea id="purpose"  name="dos[]" class="form-control col-md-1" placeholder="Do's"></textarea><br><br>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                  <textarea id="purpose"  name="donts[]" class="form-control col-md-1" placeholder=" Dont's"></textarea><br><br>
               </div>
            </div>
            <div class="item form-group  col-md-2" >
               <div class="col" ><label>Attachment</label></div>
               <div class="col-md-6 col-sm-12 col-xs-12 add_documents" >
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group" >
                     <input type="file" class="form-control col-md-7 col-xs-12" name="documentsAttach[]" value="">
                  </div>
                  <button class="btn edit-end-btn  add_moreDocs" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
               </div>
            </div>
            <div class="input-group-append">
               <button class="btn edit-end-btn  addmachineFields" type="button"><i class="fa fa-plus"></i></button>
            </div>
         </div>
         <?php } } */?>
      </div>
   </div>
   <!--<div class="item form-group">
      <div class="col-md-12 col-sm-12 col-xs-12 form-group machine_fields select-container" style="padding-bottom: 25px;">
      	<?php    /*if(empty($JobCard)){ ?>
      	
      	  <div class="  col-container">
             <div class=" col"><label>Process Name<span class="required">*</span></label></div>
      	   <div class="col"><label>Machine Name</label></div>				   
      	   <div class="col"><label>Machine Parameter</label></div>
      	   <div class="col"><label>Shift</label></div>
      	   <div class="col"><label>Workers</label></div>
      	   <div class="col" style="border-right: 1px solid #c1c1c1;"><label>Do's & Dont's</label></div>				   
      	   </div>
      	
      	
      	
      	
      		<div class="well col-container " id="chckIndex_1" data-id="frst_div_1" style="overflow:auto; border-top: 1px solid #c1c1c1;">
      		
      			<div class="item form-group ">							
      					<div class=" form-group col-md-12 col-sm-12 col-xs-12">
      					<select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id input-2" required="required" name="process_name[]" tabindex="-1" aria-hidden="true" required="required" onchange="getMachineName(event,this)" id="process_name_id">
      					<option value="">Select Option</option>
      							 <?php
         if(!empty($JobCard)){
         	$process_name_id = getNameById('add_process',$JobCard->add_process,'process_name_id');
         	echo '<option value="'.$JobCard->process_name_id.'" selected>'.$process_name_id->process_name.'</option>';
         }
         ?>
      					</select>
      					</div>	
      			</div>	
      			<div class="item form-group">	
      					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
      					<select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id" required="required" name="machine_name[]" tabindex="-1" aria-hidden="true" required="required">
      						<option value="">Select Option</option>
      						 <?php
         if(!empty($JobCard)){
         	$machine_name_id = getNameById('add_machine',$JobCard->machine_name,'machine_name_id');
         	echo '<option value="'.$JobCard->machine_name_id.'" selected>'.$machine_name_id->machine_name.'</option>';
         }
         ?>
      					</select>
      					</div>	
      			</div>	
      			<div class="item form-group">
      					<div class="col-md-4 col-sm-12 col-xs-12  form-group" style="border-right: 1px solid #c1c1c1;">
      						<div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name form-group"></div>	
      					</div>	
      					<div class="col-md-4 col-sm-12 col-xs-12  form-group" style="border-right: 1px solid #c1c1c1;">
      						<div class="col-md-12 col-sm-6 col-xs-12 form-group uom"></div>	
      					</div>	
      					<div class="col-md-4 col-sm-12 col-xs-12  form-group">
      						<div class="col-md-12 col-sm-6 col-xs-12 form-group value"></div>	
      					</div>	
      			</div>
      			<div class="item form-group input-2">
      					<input type="production" id="production" name="production_shift[]" class="form-control col-md-7 col-xs-12" placeholder="production per Shift">
      			</div>
      			<div class="item form-group input-2">
      				<input type="workers" id="workers" name="workers[]" class="form-control col-md-7 col-xs-12" placeholder="workers">
      			</div>
      			<div class="item form-group input-2" style="border-right: 1px solid #c1c1c1;">
      				<div class="col-md-6 col-sm-6 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1;">
      					<textarea id="purpose"  name="dos[]" class="form-control col-md-7 col-xs-12 purpose" placeholder="Do's"></textarea><br><br>
      				</div>
      				<div class="col-md-6 col-sm-6 col-xs-12 form-group">
      					<textarea id="purpose"  name="donts[]" class="form-control col-md-7 col-xs-12 purpose" placeholder=" Dont's"></textarea><br><br>
      				</div>
      			</div>
      		
      			
      			<div class="col-sm-12 btn-row">
      					<div class="input-group-append">
      							<button class="btn edit-end-btn  addmachineFields" type="button">Add</button>
      					</div>
      			</div>
      		</div>
      
      
      		<?php } else {  ?>	
      			<?php 
         //if(!empty($JobCard) && $JobCard->machine_details !=''){ 
         $Detailinfo = json_decode($JobCard->machine_details);
         
         $j =1;
         ?>
      				<div class="  col-container">
             <div class="col"><label>Process Name<span class="required">*</span></label></div>
      	   <div class="col"><label>Machine Name</label></div>				   
      	   <div class="col"><label>Machine Parameter</label></div>
      	   <div class="col"><label>Shift</label></div>
      	   <div class="col"><label>Workers</label></div>
      	   <div class="col" style="border-right: 1px solid #c1c1c1;"><label>Do's & Dont's</label></div>				   
      	   </div>
      				<?php
         if(!empty($Detailinfo)){ 
         
         foreach($Detailinfo as $detail_info){	
         	$parmeterName = $detail_info->parameter;
             $uom = $detail_info->uom;
         	$values = $detail_info->value;
         	
         
         ?>
      		
      		<div class="well col-container scend-tr" style="overflow:auto;" id="chckIndex_<?php echo $j; ?>" data-id="frst_div_<?php echo $j; ?>">
      			
      			<div class="item form-group ">	
      					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
      					<select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id select2" required="required" name="process_name[]" tabindex="-1" aria-hidden="true"  onchange="getMachineName(event,this)" data-id="add_process" data-key="id" data-fieldname="process_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND process_type_id = <?php echo $JobCard->process_type;?>">
      						<option value="">Select Option</option>
      							 <?php
         $processName = getNameById('add_process',$detail_info->processess,'id'); 
         echo '<option value="'.$detail_info->processess.'" selected>'.$processName->process_name.'</option>';
         ?>		
      					</select>
      					</div>	
      			</div>	
      			<div class="item form-group ">	
      					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
      					<select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id" required="required" name="machine_name[]" tabindex="-1" aria-hidden="true" data-id="add_machine" data-key="id" data-fieldname="machine_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND process_name = <?php echo $detail_info->processess;?> AND save_status=1">
      					<option value="">Select Option</option>
      						 <?php
         $machine_name_id = getNameById('add_machine',$detail_info->machine_name,'id'); 
         echo '<option value="'.$detail_info->machine_name.'" selected>'.$machine_name_id->machine_name.'</option>';	
         ?>
      					</select>
      					</div>	
      			</div>	
      		
      			<div class="item form-group ">
      				<div class="col-md-4 col-sm-6 col-xs-12 form-group">
      					<div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name">
      						<?php
         if(!empty($parmeterName)){ 
         	foreach($parmeterName as $parameter_names){
         			?>	
      						<input type="text" class="form-control col-md-7 col-xs-12" name="parameter_frst_div_<?php echo $j; ?>[]" value="<?php echo $parameter_names;?>" readonly>
      					<?php }}?>
      					</div>	
      				</div>	
      				<div class="col-md-4 col-sm-6 col-xs-12 form-group">
      					<div class="col-md-12 col-sm-6 col-xs-12 form-group uom" >
      						<?php
         if(!empty($uom)){ 
         	foreach($uom as $uom_values){
         			?>		
      						<input type="text" value="<?php echo $uom_values; ?>" class="form-control col-md-7 col-xs-12" name="uom_frst_div_<?php echo $j; ?>[]" readonly>
      							<?php }}?>
      					</div>	
      				</div>
      				<div class="col-md-4 col-sm-6 col-xs-12 form-group">
      					<div class="col-md-12 col-sm-6 col-xs-12 form-group value">
      						<?php
         if(!empty($values)){ 
         	foreach($values as $values_get){
         
         ?>	
      						<input type="text" value="<?php  echo $values_get; ?>" class="form-control col-md-7 col-xs-12" name="value_frst_div_<?php echo $j; ?>[]">
      							<?php }} ?>
      					</div>	
      				</div>	
      			</div>	
      		   
                            <div class="item form-group  input-2">
      					<input type="production" id="production" name="production_shift[]" class="form-control col-md-7 col-xs-12" placeholder="production per Shift" value="<?php if(!empty($detail_info)) echo $detail_info->production_shift; ?>">
      			</div>
      			<div class="item form-group  input-2">
      				<input type="workers" id="workers" name="workers[]" class="form-control col-md-7 col-xs-12" placeholder="workers" value="<?php if(!empty($detail_info)) echo $detail_info->workers; ?>">
      			</div>
      			<div class="item form-group  input-2" style="border-right: 1px solid #c1c1c1;">
      				<div class="col-md-6 col-sm-6 col-xs-12 form-group">
      					<textarea id="purpose"  name="dos[]" class="form-control col-md-7 col-xs-12 purpose" placeholder="Do's"><?php if(!empty($detail_info)) echo $detail_info->dos; ?></textarea><br><br>
      				</div>
      				<div class="col-md-6 col-sm-6 col-xs-12 form-group">
      					<textarea id="purpose"  name="donts[]" class="form-control col-md-7 col-xs-12 purpose" placeholder=" Dont's"><?php if(!empty($detail_info)) echo $detail_info->donts; ?></textarea><br><br>
      				</div>
      			</div>
                          
      			
      				<?php if($j==1){
         echo '<div class="col-sm-12 btn-row"><button class="btn edit-end-btn  addmachineFields" type="button">Add</button></div>';
         }else{	
         echo '<button class="btn btn-danger remove_machine" type="button"> <i class="fa fa-minus"></i></button>';
         } ?>		
      			
      		</div>
      
      	<?php $j++; }   }else{ ?>
      	<div class="well" id="chckIndex_1" data-id="frst_div_1" style="overflow:auto;">
      		
      			<div class="item form-group">
      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="product detail">Process Name<span class="required">*</span></label>	
      					<div class="col-md-6 col-sm-6 col-xs-12">
      					<select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id select2" required="required" name="process_name[]" tabindex="-1" aria-hidden="true" required="required" onchange="getMachineName(event,this)">
      					<option value="">Select Option</option>
      							 
      					</select>
      					</div>	
      			</div>	
      			<div class="item form-group">
      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="product detail">Machine Name<span class="required">*</span></label>	
      					<div class="col-md-6 col-sm-6 col-xs-12">
      					<select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id" required="required" name="machine_name[]" tabindex="-1" aria-hidden="true" required="required">
      						<option value="">Select Option</option>
      						
      					</select>
      					</div>	
      			</div>	
      			<div class="item form-group ">
      			<label class="control-label col-md-4 col-sm-3 col-xs-12" for="product detail">Machine Parameter</label>
      					<div class="col-md-2 col-sm-6 col-xs-12">
      						<div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name"></div>	
      					</div>	
      					<div class="col-md-2 col-sm-6 col-xs-12">
      						<div class="col-md-12 col-sm-6 col-xs-12 form-group uom"></div>	
      					</div>	
      					<div class="col-md-2 col-sm-6 col-xs-12">
      						<div class="col-md-12 col-sm-6 col-xs-12 form-group value"></div>	
      					</div>	
      			</div>	
      		
      			<div class="item form-group">
      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="product detail">Production/Shift</label>	
      					<div class="col-md-6 col-sm-6 col-xs-12 form-group">
      						<input type="production" id="production" name="production_shift[]" class="form-control col-md-7 col-xs-12" placeholder="production per Shift">
      					</div>
      			</div>	
      			<div class="item form-group">
      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="product detail">Workers</label>	
      					<div class="col-md-6 col-sm-6 col-xs-12 form-group">
      						<input type="workers" id="workers" name="workers[]" class="form-control col-md-7 col-xs-12" placeholder="workers Needed">
      					</div>	
      			</div>	
      			<div class="item form-group">
      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="product detail">Do's & Dont's</label>
      					<div class="col-md-3 col-sm-6 col-xs-12 form-group">
      						<textarea id="purpose"  name="dos[]" class="form-control col-md-1" placeholder="Do's"></textarea><br><br>
      					</div>
      					<div class="col-md-3 col-sm-6 col-xs-12 form-group">
      						<textarea id="purpose"  name="donts[]" class="form-control col-md-1" placeholder=" Dont's"></textarea><br><br>
      					</div>
      			</div>
      			<div class="input-group-append">
      					<button class="btn edit-end-btn  addmachineFields" type="button"><i class="fa fa-plus"></i></button>
      			</div>
      		</div>
      	
      				<?php } } */?>
      </div>
      </div>-->
   <div class="ln_solid"></div>
   <div class="item form-group ">
   	<h3 class="Material-head">
                  Material Linked with BOM
                  <hr>
               </h3>
      <div class="col-md-8 col-sm-12 col-xs-12 input_fields_wrap11">
         <div class="item form-group">
   <div class="col-md-6 input_holder11 middle-box">
   <?php  if(empty($JobCard)){  ?>
      <div class="well " id="chkIndex_1" style=" overflow:auto;">
         <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <label>Material Type</label>
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="material_type_id11[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
               <option value="">Select Option</option>
            </select>
         </div>
         <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <label>Material Name</label>
            <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_name11[]" id="mat_name">
               <option value="">Select Option</option>
            </select>
         </div>
      </div>
      <div class="col-sm-12 btn-row">
         <div class="input-group-append">
            <button class="btn edit-end-btn addmaterial11" type="button">Add</button>
         </div>
      </div>
      <?php }
                  else{ 
                  if(!empty($JobCard) && $JobCard->linked_material_details !=''){ 
                  $material_info = json_decode($JobCard->linked_material_details);
                  
                  if(!empty($material_info)){ 
                  
                  $i =1;
                     foreach($material_info as $materialInfo){
                     $material_id = $materialInfo->material_name_id;
                     $materialName = getNameById('material',$material_id,'id');
                  
                  ?>
         <div class="well <?php if($i==1){ echo 'edit-row1';}else{ echo 'scend-tr mobile-view';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkIndex_<?php echo $i; ?>">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
               <label>Material Type</label>
               <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="material_type_id11[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
                  <option value="">Select Option</option>
                  <?php
                           if(!empty($materialInfo) && isset($materialInfo->material_type_id)){
                              $material_type_id = getNameById('material_type',$materialInfo->material_type_id,'id');
                              echo '<option value="'.$materialInfo->material_type_id.'" selected>'.$material_type_id->name.'</option>';
                           }
                           ?>
               </select>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
               <label>Material Name</label>
               <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_name11[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $JobCard->material_type_id;?>  AND status=1">
                  <option value="">Select Option</option>
                  <?php
                           echo '<option value="'.$materialInfo->material_name_id.'" selected>'.$materialName->material_name.'</option>';
                           ?>
               </select>
            </div>
            <button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>
         </div>
         <div class="col-sm-12 btn-row">
            <button class="btn edit-end-btn  addmaterial11" type="button">Add</button>
         </div>
         <!--</?php if($i==1){
                  echo '<div class="col-sm-12 btn-row"><button class="btn edit-end-btn  addmaterial" type="button">Add</button></div>';
                     }else{   
                  echo '<button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>';
                  } ?>-->
         <?php 
                  $i++;
                        }}}}?>
   </div>
</div>
</div>
</div>

   <div class="form-group">
      <div class="col-md-12 col-xs-12">
         <center>
            <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
            <button type="reset" class="btn edit-end-btn ">Reset</button>
            <?php if((!empty($JobCard) && $JobCard->save_status !=1) || empty($JobCard)){
               echo '<input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft">'; 
               }?> 
            <button id="send" type="submit" class="btn edit-end-btn ">Submit</button>
         </center>
      </div>
   </div>
</form>
<!--------------Quick add material code original----------------------->
<div class="modal left fade" id="myModal_Add_matrial_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
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
                     <input type="text" id="material_name" name="material_name" class="form-control col-md-7 col-xs-12" value="">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <input type="hidden" name="material_type_id" id="material_type_id"  class="form-control" value="">
               <input type="hidden" name="prefix"  id="prefix">
               <span class="spanLeft control-label"></span>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">HSN Code </label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="hsn_code" name="hsn_code" class="form-control col-md-7 col-xs-12" value="" >
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">UOM</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="uom selectAjaxOption select2 form-control" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" data-where="created_by_cid = <?php 	echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0 AND active_inactive = 1">
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
                  <label class="control-label col-md-12 col-sm-2 col-xs-4" for="gstin">Opening Balance</label>
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
<script>
   var measurementUnits = <?php echo json_encode(getUom()); ?>;		
</script>