<?php
 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/saveNewWorkdetail" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php if($work_detail && !empty($work_detail)){ echo $work_detail->id;} ?>">
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group col-md-12 col-sm-12 col-xs-12">
         <label class="col-md-3 col-sm-2 col-xs-4" for="description">Assigned To<span class="required">*</span></label>		
         <div class="col-md-7 col-sm-10 col-xs-8">	
            <select class="form-control selectAjaxOption select2" id="workersID" name="assigned_to" data-id="user_detail" data-key="id" data-fieldname="name" width="100%"  data-where="c_id=<?php echo $this->companyGroupId ;?> and is_activated = 1" onchange="getSupervisorName(this.value)" required>
            <?php
               if(!empty($work_detail)){
                   
               	$status = getNameById('user_detail',$work_detail->assigned_to,'id');
               	echo '<option value="'.$work_detail->assigned_to.'" selected>'.$status->name.'</option>';
               }
               ?>
            </select>	     
         </div>
      </div>
   </div>
   <!--div class="col-md-6 col-sm-12 col-xs-12 ">
      <div class="item form-group col-md-12 col-sm-12 col-xs-12">
         <label class="col-md-3 col-sm-2 col-xs-4" for="description">  Supervisor </label>
         <div class="col-md-7 col-sm-9 col-xs-12">
            <select class="form-control selectAjaxOption select2 supervisor" id="supervisor" name="superviser" data-id="user_detail" data-key="id" data-fieldname="name" width="100%" data-where="c_id=<?php //echo $_SESSION['loggedInUser']->c_id;?> and is_activated=1">
            <?php
			
               // if(!empty($work_detail)&& $work_detail->superviser!=0){
                   
               	// $status = getNameById('user_detail',$work_detail->superviser,'id');
               	// if(!empty($status)) echo '<option value="'.$work_detail->superviser.'" selected>'.$status->name.'</option>';
               	 
               // }
               ?>
            </select>	
         </div>
      </div>
   </div-->
   <div class="col-md-12 col-sm-12 col-xs-12 input_holder" style="padding-bottom: 36px;">
      <?php if(empty($work_detail)){ ?>
      
      <div class="label-box mobile-view2 ">
         <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Task Name<span class="required">*</span></label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label></div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Status<span class="required">*</span></label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label >Start Date/ Task date <span class="required">*</span></label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Due Date and time</label></div>
         <?php
            $item_code_Settings = $this->hrm_model->get_Companydata('company_detail',array('id'=> $this->companyGroupId));
            if($item_code_Settings[0]['npdm_on_off'] == '1'){
            ?>				  
         <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">NPDM Product</label></div>
         <?php }?>		  
         <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Repeatable</label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Repeatation Time (Days)</label></div>
      </div>
      <div class="well scend-tr mobile-view middle-box" id="chkIndex_1" >
         <div class="item form-group col-md-1 col-xs-12">
            <label class="col-md-12 col-sm-12 col-xs-12" for="name">  Name<span class="required">*</span></label>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <input  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($work_detail)) echo $work_detail->task_name; ?>" name="task_name[]" placeholder="  Name" required="required" type="text" > 
            </div>
         </div>
         <div class="item form-group col-md-2 col-xs-12">
            <label class="col-md-12 col-sm-12 col-xs-12" for="name">Description</label>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <input  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($work_detail)) echo $work_detail->description; ?>" name="description[]" placeholder="Description" type="text">
            </div>
         </div>
         <div class="item form-group col-md-1 col-xs-12">
            <label class="col-md-12 col-sm-12 col-xs-12" for="email">Status  <span class="required">*</span></label>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <select class="  selectAjaxOption select2 form-control" name="pipeline_status[]" data-id="task_list_status" data-key="id" data-fieldname="name" width="100%"  data-where="created_by_cid = <?php echo $this->companyGroupId; ?>" required>
                  <option value="">Select Option</option>
                  <?php if(!empty($work_detail)){
                     $purchase_data_id = getNameById('npdm',$work_detail->npdm_id,'id');
                     echo '<option value="'.$work_detail->npdm_id.'"selected >'.$purchase_data_id->product_name.'</option>';
                     }?>
               </select>
            </div>
         </div>
         <div class="item form-group col-md-2 col-xs-12">
            <label  for="email">Start Date/ Task date <span class="required">*</span></label>
            <div class="col-sm-12 col-md-12 col-xs-12 form-group">
               <?php /*<input type="tel" id="phone_no" name="phone_no[]"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($work_detail)) echo $work_detail->phone_no; ?>" data-validate-length-range="10,12" required="required">*/?>
               <input  type="date"   name="start_date[]"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($work_detail)){echo $work_detail->task_date;}else {echo date('Y-m-d');} ?>"  required="required">
            </div>
         </div>
         <div class="item form-group col-md-2 col-xs-12">
            <label style=" border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-2 col-xs-12" for="email">Due Date and time </label>
            <div class="col-sm-12 col-md-12 col-xs-12 form-group">
               <input type="date" id="due_date" name="due_date[]" class="form-control col-md-7 col-xs-12" placeholder="Due Date" value="<?php if(!empty($work_detail)) echo $work_detail->due_date; ?>"> 
            </div>
         </div>
         <?php
            $item_code_Settings = $this->hrm_model->get_Companydata('company_detail',array('id'=> $this->companyGroupId));
            if($item_code_Settings[0]['npdm_on_off'] == '1'){
            ?>	
         <div class="item form-group col-md-1 col-xs-12">
            <label style=" border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-2 col-xs-12" for="email">NPDM Product<span class="required">*</span></label>
            <div class="col-sm-12 col-md-12 col-xs-12 form-group">
               <input type="hidden" id="form_npdm_setting" value="1"/>
               <select class="uom selectAjaxOption select2 form-control" name="npdm[]" data-id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="uom" data-where="created_by_cid = <?php echo $this->companyGroupId; ?>">
                  <option value="">Select Option</option>
                  <?php if(!empty($work_detail)){
                     $purchase_data_id = getNameById('npdm',$work_detail->npdm_id,'id');
                     echo '<option value="'.$work_detail->npdm_id.'"selected >'.$purchase_data_id->product_name.'</option>';
                     }?>
               </select>
            </div>
         </div>
         <?php }?>
         <div class="item form-group col-md-1 col-xs-12">
            <label style=" border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-2 col-xs-12" for="email">Repeatable</label>
            <div class="col-sm-12 col-md-12 col-xs-12 form-group">                                                    
               <select id ="1" id1 ="1"  class="form-control col-md-7 col-xs-12 change_repeation" name="repeat_task[]">
                  <option value="" disabled selected>Choose option</option>
                  <option value="1">Yes</option>
                  <option value="0">No</option>
               </select>
            </div>
         </div>
         <div class="item form-group col-md-2 col-xs-12">
            <label style=" border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-2 col-xs-12" for="email">Repeatation Time (Days)</label>
            <div class="col-sm-12 col-md-12 col-xs-12 form-group">
               <input type="number" id="repeatation_days1" name="repeatation_days[]" disabled class="form-control col-md-7 col-xs-12" placeholder="Repeatation Time" value="<?php if(!empty($work_detail)) echo $work_detail->repeatation_days; ?>"> 
            </div>
         </div>
         <button class="btn btn-danger remve_field" type="button"> <i class="fa fa-minus"></i></button>
      </div>
      <div class="col-sm-12 btn-row" style="margin-top: 20px;">
         <div class="input-group-append">
            <button id="addMoreLead" class="btn edit-end-btn  " type="button">Add</button>
         </div>
      </div>
      <?php } if(!empty($work_detail)){ ?>
      <div class="label-box mobile-view2 ">
         <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>  Task Name<span class="required">*</span></label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label></div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Status</label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Start Date/ Task date <span class="required">*</span></label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Due Date and time</label></div>
         <?php
            $item_code_Settings = $this->hrm_model->get_Companydata('company_detail',array('id'=> $this->companyGroupId));
            if($item_code_Settings[0]['npdm_on_off'] == '1'){
            ?>			  
         <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">NPDM Product<span class="required">*</span></label></div>
         <?php }?>				  
         <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Repeatable</label></div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Repeatation Time (Days)</div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style=" border-right: 1px solid #c1c1c1 !important;">Repeatation off</label></div>
      </div>
      <div class="well scend-tr mobile-view middle-box" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">
         <div class="item form-group col-md-1 col-xs-12">
            <label class="col-md-12 col-sm-12 col-xs-12" for="name">  Name<span class="required">*</span></label>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <input id="name" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($work_detail)) echo $work_detail->task_name; ?>" name="task_name" placeholder="  Name" required="required" type="text" > 
            </div>
         </div>
         <div class="item form-group col-md-2 col-xs-12">
            <label class="col-md-12 col-sm-12 col-xs-12" for="name">Description</label>
            <div class="col-md-122 col-sm-12 col-xs-12 form-group">
               <input id="last_name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($work_detail)) echo $work_detail->description; ?>" name="description" placeholder="Description" type="text">
            </div>
         </div>
         <div class="item form-group col-md-1 col-xs-12">
            <label class="col-md-12 col-sm-12 col-xs-12" for="email">Status </label>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <select class="selectAjaxOption select2 form-control" name="pipeline_status" data-id="task_list_status" data-key="id" data-fieldname="name" width="100%"  data-where="created_by_cid = <?php echo $this->companyGroupId; ?>" required>
                  <option value="">Select Option</option>
                  <?php if(!empty($work_detail)){
                     $purchase_data_id = getNameById('task_list_status',$work_detail->pipeline_status,'id');
                     echo '<option value="'.$work_detail->pipeline_status.'"selected >'.$purchase_data_id->name.'</option>';
                     }?>
               </select>
            </div>
         </div>
         <div class="item form-group col-md-2 col-xs-12">
            <label style="border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-12 col-xs-12" for="email">Start Date/ Task date<span class="required">*</span></label>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <input style="border-right: 1px solid #c1c1c1 !important;" type="date"   name="start_date" class="form-control col-md-7 col-xs-12"   value="<?php echo date('Y-m-d',strtotime($work_detail->start_date)) ?>"  required="required">
            </div>
         </div>
         <div class="item form-group col-md-2 col-xs-12">
            <label style="border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-12 col-xs-12" for="email">Due Date and time</label>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <input style="border-right: 1px solid #c1c1c1 !important;" type="date"   name="due_date"  class="form-control col-md-7 col-xs-12" value="<?php echo date('Y-m-d',strtotime($work_detail->due_date)) ?>">
            </div>
         </div>
         <?php
            $item_code_Settings = $this->hrm_model->get_Companydata('company_detail',array('id'=> $this->companyGroupId));
            if($item_code_Settings[0]['npdm_on_off'] == '1'){
            ?>	
         <div class="item form-group col-md-1 col-xs-12">
            <input type="hidden" id="form_npdm_setting" value="1"/>
            <label style="border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-12 col-xs-12" for="email">NPDM Product<span class="required">*</span></label>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <select class="uom selectAjaxOption select2 form-control" name="npdm" data-id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="uom" data-where="created_by_cid = <?php echo $this->companyGroupId; ?>">
                  <option value="">Select Option</option>
                  <?php if(!empty($work_detail)){
                     $purchase_data_id = getNameById('npdm',$work_detail->npdm,'id');
                     echo '<option value="'.$work_detail->npdm.'"selected >'.$purchase_data_id->product_name.'</option>';
                     }?>
               </select>
            </div>
         </div>
         <?php }?>
         <div class="item form-group col-md-1 col-xs-12">
            <label style="border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-12 col-xs-12" for="email">Repeatable</label>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <select id ="1" id1 ="1"  class="form-control col-md-7 col-xs-12 change_repeation" name="repeat_task">
                  <option value="" disabled selected>Choose option</option>
                  <option <?php echo ($work_detail->repeat_task =='1')?'selected':'' ?> value="1">Yes</option>
                  <option <?php echo ($work_detail->repeat_task =='0')?'selected':'' ?> value="0">No</option>
               </select>
            </div>
         </div>
         <div class="item form-group col-md-1 col-xs-12">
            <label style="border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-12 col-xs-12" for="email">Repeatation Time (Days)</label>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <?php  if($work_detail->repeat_task =='0'){
                  $dis = "disabled";
                  }else{
                  $dis = "";
                  }
                  
                  ?>
               <input <?php echo $dis;  ?> style="border-right: 1px solid #c1c1c1 !important;" type="number" id="repeatation_days1" name="repeatation_days"  class="form-control col-md-7 col-xs-12" value="<?php echo $work_detail->repeatation_days; ?>" >
            </div>
         </div>
         <div class="item form-group col-md-1 col-xs-12">
            <label style="border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-12 col-xs-12" for="email">Repeatation off</label>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <select <?php echo $dis;  ?> id="repeatation_on_off1" name="repeatation_on_off" class="form-control col-md-7 col-xs-12" >
                  <option value="" disabled selected>Choose option</option>
                  <option <?php echo ($work_detail->repeatation_on_off =='1')?'selected':'' ?> value="1">Yes</option>
                  <option <?php echo ($work_detail->repeatation_on_off =='0')?'selected':'' ?> value="0">No</option>
               </select>
            </div>
         </div>
           <input type="hidden" id="form_repeatation_on_off" value="1"/>
         <button class="btn btn-danger remve_field" type="button"> <i class="fa fa-minus"></i></button>
      </div>
       <!--  <div class="col-sm-12 btn-row ">
         <div class="input-group-append">
            <button id="addMoreLead" class="btn edit-end-btn" type="button">Add</button>
         </div>
      </div>-->

      <?php  									
         }
         ?>	
   </div>
   <?php if(!empty($work_detail)){ ?>
   <div class="item form-group col-md-12 col-xs-12" style="margin-top: 20px;">
         <div class="input-group-append">
            <label style="border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-12 col-xs-12" for="email">Add Comments...</label>
            <textarea class="form-control col-md-7 col-xs-12" name="comments" rows="2" cols="100">
            </textarea>							
         </div>
         <div class="input-group-append">
            <label style="border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-12 col-xs-12" for="email"></label>
            <?php if(!empty($comments)){    
               foreach($comments as $key => $val) {
               	   echo $val['comments']."<br>";
               }
               } ?>
         </div>
      </div>
  <?php }?>
   </div>
   <div class="modal-footer">
      <center>
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							  
         <input type="submit" class="btn btn-warning" value="Submit">
      </center>
   </div>
</form>