<?php 	
   //$getcompanyName = getCompanyTableId('company_detail');
   $getcompanyName = getNameById('company_detail',$_SESSION['loggedInUser']->c_id ,'id');
   $name = $getcompanyName->name;
   $CompanyName = substr($name , 0,6);
   $last_id = getLastTableId('job_card');
   $rId = $last_id + 1;	
   //$jobCode = ($JobCard && !empty($JobCard))?$JobCard->job_card_no:('JC_'.rand(1, 1000000).'_'.$CompanyName.'_'.$rId);
   error_reporting(0);
   ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>maintenance/addsetpreventive" enctype="multipart/form-data" id="jobCardDetail" novalidate="novalidate" style="">
   <h3 class="Material-head">
      Process Details
      <hr>
   </h3>
   <input type="hidden" name="id" value="<?php if(!empty($JobCard)) echo $JobCard->id; ?>">
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">
   <input type="hidden" name="save_status" value="1" class="save_status">
   <?php
      if(empty($JobCard)){
      ?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <?php }else{ ?>	
   <input type="hidden" name="created_by" value="<?php if($JobCard && !empty($JobCard)){ echo $JobCard->created_by;} ?>" >
   <?php } ?>	
   <!------------Machine table data-----------------> 
   <input type="hidden" name="machine_id" value="<?php echo $Macpreventive->machine_id; ?>">
   <input type="hidden" name="set_unset" value="1">
   <input type="hidden" name="add_machine_id" value="<?php if($AddMachine && !empty($AddMachine)){ echo $AddMachine->id;} ?>">
   <input type="hidden" name="machine_name" value="<?php echo $AddMachine->machine_name; ?>">
   <input type="hidden" name="machine_group_id" value="<?php echo $AddMachine->machine_group_id; ?>">
   <input type="hidden" name="priority_order" value="<?php echo $AddMachine->priority_order; ?>">
   <input type="hidden" name="machine_code" value="<?php echo $AddMachine->machine_code; ?>">
   <input type="hidden" name="preventive_maintenance" value="<?php echo $AddMachine->preventive_maintenance; ?>">
   <input type="hidden" name="machine_parameter" value="<?php echo $AddMachine->machine_parameter; ?>">
   <input type="hidden" name="process" value="<?php echo $AddMachine->process; ?>">
   <input type="hidden" name="process_type" value="<?php echo $AddMachine->process_type; ?>">
   <input type="hidden" name="process_name" value="<?php echo $AddMachine->process_name; ?>">
   <input type="hidden" name="make_model" value="<?php echo $AddMachine->make_model; ?>">
   <input type="hidden" name="year_purchase" value="<?php echo $AddMachine->year_purchase; ?>">
   <input type="hidden" name="placement" value="<?php echo $AddMachine->placement; ?>">
   <input type="hidden" name="company_branch" value="<?php echo $AddMachine->company_branch; ?>">
   <input type="hidden" name="department" value="<?php echo $AddMachine->department; ?>">
   <input type="hidden" name="department_id" value="<?php echo $AddMachine->department_id; ?>">
   <input type="hidden" name="add_similar_machine" value="<?php echo $AddMachine->add_similar_machine; ?>">
   <input type="hidden" name="save_status" value="<?php echo $AddMachine->save_status; ?>">
   <input type="hidden" name="favourite_sts" value="<?php echo $AddMachine->favourite_sts; ?>">
   <input type="hidden" name="used_status" value="<?php echo $AddMachine->used_status; ?>">
   <input type="hidden" name="created_by_cid" value="<?php echo $AddMachine->created_by_cid; ?>">
   <input type="hidden" name="created_by" value="<?php echo $AddMachine->created_by; ?>">
   <input type="hidden" name="edited_by" value="<?php echo $AddMachine->edited_by; ?>">
   <input type="hidden" name="created_date" value="<?php echo $AddMachine->created_date; ?>">
   <input type="hidden" name="modified_date" value="<?php echo $AddMachine->modified_date; ?>">
   <!------------Machine table data end----------------->  
   <?php  //pre($Macpreventive);
      //$data = json_decode($Macpreventive->preventiv_all_data);
      
       //foreach ($data as $key => $value) {
       //  $values = $value->frequency_data;
       //	echo $values;
       //}
      
      ?>
   <div class="item form-group">
      <input type="hidden" name="work_status" value="4">
      <div class="col-md-12 col-sm-12 col-xs-12 form-group machine_fields select-container" style="padding-bottom: 25px;">
         <?php    if(empty($JobCard)){ ?>
         <div class="well2" id="chckIndex_1" data-id="frst_div_1" >
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12" for="product detail">Frequency<span class="required">*</span></label>	
                  <div class="col-md-6 col-sm-12 col-xs-12">
                     <select class="form-control" required="required" name="frequency_data[]">
                        <option value="" >Select Option</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="hafe yearly">Hafe Yearly</option>
                        <option value="yearly">Yearly</option>
                     </select>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-2 col-xs-4" for="description">Start date<span class="required">*</span></label>
                  <div class="col-md-7 col-sm-10 col-xs-8">
                     <input required="required" type="datetime-local" class="form-control has-feedback-left datePicker" name="start_date[]" id="start_date" value="">
                     <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                     <span id="inputSuccess2Status3" class="sr-only">(success)</span>
                  </div>
               </div>
            </div>
            <div class="item form-group ">
               <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
                  <div class="item form-group">
                     <div class="col-md-8 input_holder middle-box" style="margin: 0px auto; float: unset;">
                        <?php  if(empty($JobCard)){  ?>
                        <div class="well" id="chkIndex_1" style=" overflow:auto; border-top:1px solid #c1c1c1;">
                           <div class="col-md-11 col-sm-12 col-xs-12 form-group">
                              <label style="border-right: 1px solid #c1c1c1 !important;">Check List</label>
                              <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="check_list_data[]" class="form-control col-md-7 col-xs-12  check_list"  required="required"  placeholder="Check List" value="">	
                           </div>
                           <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                              <label style="border-right: 1px solid #c1c1c1 !important;">Action</label>
                              <div class="input-group-append1" style="padding: 4.4px;border-right: 1px solid #c1c1c1 !important;border-bottom: 1px solid #c1c1c1 !important;">
                                 <button class="btn edit-end-btn addmaterial" type="button"><i class="fa fa-plus"></i></button>
                              </div>
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
                           <div class="col-md-11 col-sm-12 col-xs-12 form-group" >
                              <label style="border-right: 1px solid #c1c1c1 !important;">Check List</label>
                              <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="check_list_data[]"  required="required"   class="form-control col-md-7 col-xs-12  check_list" placeholder="Check List"  value="">	
                           </div>
                           <div class="col-md-1 col-sm-12 col-xs-12 form-group" >
                              <label style="border-right: 1px solid #c1c1c1 !important;">Action</label>
                              <button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>
                           </div>
                        </div>
                        <div class="col-sm-12 btn-row"><button class="btn edit-end-btn  addmaterial" type="button"><i class="fa fa-plus"></i></button></div>
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
            <div class="item form-group ">
               <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap2">
                  <div class="item form-group2">
                     <div class="col-md-12 input_holder2 middle-box">
                        <?php  if(empty($JobCard)){  ?>
                        <div class="well chk_idd_input" id="chkIndex_1" style=" overflow:auto; border-top:1px solid #c1c1c1;">
                           <div class="col-md-4 col-sm-12 col-xs-12 form-group" style="padding: 0px;" >
                              <label style="border-right: 1px solid #c1c1c1 !important;">Material Type</label>
                              <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="material_type[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid='+ logged_user +' OR created_by_cid=0"  onchange="getMaterialName(event,this)" id="material_type">
                                 <option value="">Select Option</option>
                              </select>
                           </div>
                           <div class="col-md-4 col-sm-12 col-xs-12 form-group" style="padding: 0px;" >
                              <label style="border-right: 1px solid #c1c1c1 !important;">Material Name</label>
                              <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name"  name="material_name[]" onchange="getUom_input(event,this);">
                                 <option value="">Select Option</option>
                              </select>
                           </div>
                           <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="padding: 0px;" >
                              <label style="border-right: 1px solid #c1c1c1 !important;">Quantity</label>
                              <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="quantity[]" class="form-control col-md-7 col-xs-12  quantity" placeholder="Quantity"  value="">	
                           </div>
                           <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="padding: 0px;     border-right: 1px solid #c1c1c1 !important;" >
                              <label style="border-right: 1px solid #c1c1c1 !important;">Action</label>
                              <div class="input-group-append1">
                                 <button class="btn edit-end-btn addmaterial2" type="button"><i class="fa fa-plus"></i></button>
                              </div>
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
                        <div class="<?php if($i==1){ echo 'edit-row1';}else{ echo 'scend-tr mobile-view';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkIndex_<?php echo $i; ?>">
                           <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="padding: 0px;" >
                              <label style="border-right: 1px solid #c1c1c1 !important;">Material Type</label>
                              <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="material_type[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid='+ logged_user +' OR created_by_cid=0"  onchange="getMaterialName(event,this)" id="material_type">
                                 <option value="">Select Option</option>
                              </select>
                           </div>
                           <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="padding: 0px;" >
                              <label style="border-right: 1px solid #c1c1c1 !important;">Material Name</label>
                              <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name"  name="material_name[]" onchange="getUom_input(event,this);">
                                 <option value="">Select Option</option>
                              </select>
                           </div>
                           <div class="col-md-3 col-sm-12 col-xs-12 form-group" >
                              <label style="border-right: 1px solid #c1c1c1 !important;">Quantity</label>
                              <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="quantity[]" class="form-control col-md-7 col-xs-12  quantity" placeholder="Quantity"  value="">	
                           </div>
                           <div class="col-md-3 col-sm-12 col-xs-12 form-group" >
                              <button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>
                           </div>
                        </div>
                        <div class="col-sm-12 btn-row"><button class="btn edit-end-btn  addmaterial2" type="button"><i class="fa fa-plus"></i></button></div>
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
            	//pre($detail_info);
            ?>
         <div class=" well2 <?php if($j==1){ echo 'edit-row1';}else{ echo 'scend-tr';}?>"  id="chckIndex_<?php echo $j; ?>" data-id="frst_div_<?php echo $j; ?>">
            <div class="well2" id="chckIndex_1" data-id="frst_div_1" >
               <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                  <div class="item form-group">
                     <label class="col-md-3 col-sm-12 col-xs-12" for="product detail">Frequency<span class="required">*</span></label>	
                     <div class="col-md-6 col-sm-12 col-xs-12">
                        <select class="form-control" name="frequency_data[]">
                           <option value="">Select Option</option>
                           <option value="daily">Daily</option>
                           <option value="weekly">Weekly</option>
                           <option value="monthly">Monthly</option>
                           <option value="hafe yearly">Hafe Yearly</option>
                           <option value="yearly">Yearly</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="item form-group ">
                  <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
                     <div class="item form-group">
                        <div class="col-md-12 input_holder middle-box">
                           <?php  if(empty($JobCard)){  ?>
                           <div class="well " id="chkIndex_1" style=" overflow:auto;">
                              <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                 <label style="border-right: 1px solid #c1c1c1 !important;">Check List</label>
                                 <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="check_list_data[]" class="form-control col-md-7 col-xs-12  check_list" placeholder="Check List" value="">	
                              </div>
                              <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                 <div class="input-group-append">
                                    <button class="btn edit-end-btn addmaterial" type="button"><i class="fa fa-plus"></i></button>
                                 </div>
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
                              <div class="col-md-6 col-sm-12 col-xs-12 form-group" >
                                 <label style="border-right: 1px solid #c1c1c1 !important;">Check List</label>
                                 <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="check_list_data[]" class="form-control col-md-7 col-xs-12  check_list" placeholder="Check List"  value="">	
                              </div>
                              <div class="col-md-6 col-sm-12 col-xs-12 form-group" >
                                 <button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>
                              </div>
                           </div>
                           <div class="col-sm-12 btn-row"><button class="btn edit-end-btn  addmaterial" type="button"><i class="fa fa-plus"></i></button></div>
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
               <div class="item form-group ">
                  <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap2">
                     <div class="item form-group2">
                        <div class="col-md-12 input_holder2 middle-box">
                           <?php  if(empty($JobCard)){  ?>
                           <div class="well2" id="chkIndex_1" style=" overflow:auto;">
                              <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="padding: 0px;" >
                                 <label style="border-right: 1px solid #c1c1c1 !important;">Material Type</label>
                                 <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="material_type[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid='+ logged_user +' OR created_by_cid=0"  onchange="getMaterialName(event,this)" id="material_type">
                                    <option value="">Select Option</option>
                                 </select>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="padding: 0px;" >
                                 <label style="border-right: 1px solid #c1c1c1 !important;">Material Name</label>
                                 <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name"  name="material_name[]" onchange="getUom_input(event,this);">
                                    <option value="">Select Option</option>
                                 </select>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="padding: 0px;" >
                                 <label style="border-right: 1px solid #c1c1c1 !important;">Quantity</label>
                                 <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="quantity[]" class="form-control col-md-7 col-xs-12  quantity" placeholder="Quantity"  value="">	
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                 <div class="input-group-append">
                                    <button class="btn edit-end-btn addmaterial2" type="button"><i class="fa fa-plus"></i></button>
                                 </div>
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
                           <div class=" <?php if($i==1){ echo 'edit-row1';}else{ echo 'scend-tr mobile-view';}?>" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkIndex_<?php echo $i; ?>">
                              <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="padding: 0px;" >
                                 <label style="border-right: 1px solid #c1c1c1 !important;">Material Type</label>
                                 <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="material_type[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid='+ logged_user +' OR created_by_cid=0"  onchange="getMaterialName(event,this)" id="material_type">
                                    <option value="">Select Option</option>
                                 </select>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="padding: 0px;" >
                                 <label style="border-right: 1px solid #c1c1c1 !important;">Material Name</label>
                                 <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name"  name="material_name[]" onchange="getUom_input(event,this);">
                                    <option value="">Select Option</option>
                                 </select>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12 form-group" >
                                 <label style="border-right: 1px solid #c1c1c1 !important;">Quantity</label>
                                 <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="quantity[]" class="form-control col-md-7 col-xs-12  quantity" placeholder="Quantity"  value="">	
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12 form-group" >
                                 <button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>
                              </div>
                           </div>
                           <div class="col-sm-12 btn-row"><button class="btn edit-end-btn  addmaterial2" type="button"><i class="fa fa-plus"></i></button></div>
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
               <div class="col-sm-12 btn-row">
                  <div class="input-group-append">
                     <button class="btn edit-end-btn  addmachineFields" type="button">Add</button>
                  </div>
               </div>
               <!-- Inventory Process Sechduling Issues -->
            </div>
         </div>
         <?php $j++; } ?>
         <?php  } ?>
         <?php } ?>
      </div>
   </div>
   <div class="col-md-12 col-xs-12">
      <center>
         <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
         <button type="reset" class="btn edit-end-btn ">Reset</button>
         <button id="send" type="submit" class="btn edit-end-btn ">Submit</button>
      </center>
   </div>
</form>