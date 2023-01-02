  <?php 
	   if(!empty($work_order)){
	   $work_order_no = $work_order->work_order_no;
	   }else{
		  $Order_no = get_workOrder_number_count('work_order',$_SESSION['loggedInUser']->c_id ,'created_by_cid');
		  $work_order_no =  $Order_no->total_challan + 1;
		  $work_order_no = sprintf("WorkOrderNo_%04s", $work_order_no);
	   }

		$this->companyId         = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;	   
	   ?>
  <input type="hidden" value="<?php echo $this->companyId ?>" id="company_login_id">	   
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveWorkOrder" enctype="multipart/form-data" novalidate="novalidate">
   <input type="hidden" name="id" id="work_order_id" value="<?php if($work_order && !empty($work_order)){ echo $work_order->id;} ?>">
   <input type="hidden" name="save_status" value="1" class="save_status">
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">   
     
   <?php
      if(empty($work_order)){
      
      ?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <?php }else{ ?>   
   <input type="hidden" name="created_by" value="<?php if($work_order && !empty($work_order)){ echo $work_order->created_by;} ?>" >
   <?php } ?>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="work_no">Work Order Number<span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
           
            <input  id="work_order_no" class="form-control col-md-7 col-xs-12" name="work_order_no" placeholder="Work Order Number" type="text" value="<?php echo $work_order_no;  ?>" readonly >
         </div>
      </div>
      <input type="hidden" class="flat" name="stock_saleOrder" id="stock" value="stock" <?php if(!empty($work_order->stock_saleOrder) && isset($work_order->stock_saleOrder)){ echo $work_order->stock_saleOrder == 'stock' ?  "checked" : "" ;  }?> onclick="stockWorkOrder(event,this);" >
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control col-md-7 col-xs-12 selectAjaxOption select2 compny_unit" required="required" name="company_branch_id" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
               <option value="">Select Unit</option>
               <?php
                  if(!empty($work_order)){
                     $getUnitName = getNameById('company_address',$work_order->company_branch_id,'compny_branch_id');
                     echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                  }
                  ?>
            </select>
         </div>
      </div>
       
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="work_no">Work Order Name<span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <input  id="workorder_name" class="form-control col-md-7 col-xs-12" name="workorder_name" placeholder="Work Order Name" type="text" value="<?php if($work_order && !empty($work_order)){ echo $work_order->workorder_name;}?>" required >
         </div>
      </div>
   </div>
  

   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="date">Expected Date <span class="required">*</span></label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <div class=" xdisplay_inputx form-group has-feedback">
               <input type="text" class="form-control has-feedback-left machinePurchaseDate" name="expected_delivery_date" id="expected_date" aria-describedby="inputSuccess2Status3"  value="<?php if(!empty($work_order) && $work_order){ echo $work_order->expected_delivery_date; }else{echo date('d-m-Y');}?>" required>
               <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
               <span id="inputSuccess2Status3" class="sr-only">(success)</span>
            </div>
         </div>
      </div>
   <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Department</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control  col-md-7 col-xs-12  selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="department_id"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid =<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = '<?php echo (!empty($work_order))?$work_order->company_branch_id:''; ?>'" >
               <option value="">Select Option</option>
               <?php
                  if(!empty($work_order)){
                     $departmentData = getNameById('department',$work_order->department_id,'id');
                     if(!empty($departmentData)){
                        echo '<option value="'.$departmentData->id.'" selected>'.$departmentData->name.'</option>';
                     }
                  }
                  ?>
            </select>
         </div>
      </div>

      

      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="work_no">Work Order Progress Status</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <?php $progress_status = array('0' => 'In Progress','1'=>'Complete' );
               # pre($work_order);
                   $checked_status = !empty($work_order->inprocess_complete)?$work_order->inprocess_complete:'0';
                   ?>
            <select class="form-control col-md-2 col-xs-12" title="Prgress Status" name="inprocess_complete">
               <?php foreach ($progress_status as $key => $value) { ?>
               <option value="<?php echo $key;?>" <?php echo ($key ==  $checked_status) ? ' selected="selected"' : '';?>><?php echo $value;?></option>
               <?php } ?>
            </select>
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <h3 class="Material-head">
      Material Details
      <hr>

   </h3>

  
      <div class="col-md-12 input_holder middle-box" id="divstock">
   <div class="well edit-row1" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkIndex_1">
	<div style="display:none;">
	<label>Material Type</label>
         <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onchange="getMaterialName(event,this)" id="material_type">
            <option value="">Select Option</option> 
          </select>
	</div>	  
      <div class="col-md-2 col-sm-12 col-xs-12 form-group" >
         <label>Material </label>
		  
		  <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 " id="mat_name" required="required" name="material_name[]"  data-id="material" data-key="id" data-fieldname="material_name" 
		   data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND status=1" onchange="getUom(event,this)">
			  <option value="">Select Option</option>
			 
		   </select>
       </div>
       
      <div class="col-md-3 col-sm-12 col-xs-12 form-group">
         <label>WorkOrder Qty&nbsp;&nbsp;&nbsp;<span style="color:red;"></span></label>
         <input type="number" name="transfer_quantity[]" class="form-control col-md-7 col-xs-12 transfer_quantity" placeholder="WorkOrder Qty">
       </div>
      <div class="col-md-3 col-sm-12 col-xs-12 form-group">
         <label>UOM</label>
         <input type="text" class="form-control col-md-7 col-xs-12 uom" placeholder="uom."  readonly="">
         <input type="hidden" name="uom[]" class="form-control col-md-7 col-xs-12  uomid"  >
      </div>
      <div class="col-md-4 col-sm-12 col-xs-12 form-group">
         <label>Job card</label>
         <input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12  job_card" placeholder="Job card" value="" readonly="">
      </div>
	   <button style="margin-right: 0px;" class="btn btn-danger remove_field" type="button"> <i class="fa fa-minus"></i></button>
   </div>
   <br/>
   <div class="col-sm-12 btn-row"><button class="btn  plus-btn edit-end-btn addMorefileds" type="button">Add</button></div>





 </div>
</div>






 
   <hr>
   <div class="bottom-bdr"></div>
   
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="note">Note</label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <textarea  id="specification" name="specification" class="form-control col-md-7 col-xs-12"   placeholder="" value=""><?php if(!empty($work_order) && $work_order){ echo $work_order->specification; }?></textarea>
         </div>
      </div>
   </div>
   
   <hr>
    <div class="form-group">
      <div class="col-md-12 ">
         <center>
             <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
             <button id="send" type="submit" class="btn edit-end-btn" >Submit</button>
         </center>
      </div>
   </div>  
</form>
<!-- /page content -->