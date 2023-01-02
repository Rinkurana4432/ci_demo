<?php 
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$this->companyGroupId ;
   ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/saveAssignAssetsEmp" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php if(!empty($assign_emp)){ echo $assign_emp->id; }?>">
   <input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">  
   <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Employee Name<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12"  >
         <select class="itemName form-control " name="assign_id" required="required">
               <option value="">Select Option</option>
              
               <?php  foreach($users as $user){?>
                  <option value="<?php echo $user['id'];?>"
               <?php if(!empty($assign_emp)){ if($assign_emp->assign_id==$user['id']){echo 'Selected';}}?>>
               <?php echo $user['name'];?></option>
               <?php
                 /* if(!empty($assign_emp)){                                               
                      $owner = getNameById('user_detail',$assign_emp->assign_id,'u_id');
                   echo '<option value="'.$assign_emp->assign_id.'" selected>'.$owner->name.'</option>';
                  }*/
                                  }
                  ?>
            </select>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Start Date<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
         <input type="text" name="start_date" id="StartDate"  class="form-control has-feedback-left" required="required" value="<?php if(!empty($assign_emp) && $assign_emp->start_date!=''){ echo $assign_emp->start_date; }else {echo date("d-m-Y");}?>">

            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            <span id="inputSuccess2Status3" class="sr-only">(success)</span>
         </div>
      </div>
      <div class=" item form-group ">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">End Date<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" class="form-control has-feedback-left"  id="EndDate" name="end_date" id="end_date1" value="<?php if(!empty($assign_emp) && $assign_emp->end_date!=''){ echo $assign_emp->end_date; }else {echo date("d-m-Y");}?>" required="required">
            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            <span id="inputSuccess2Status3" class="sr-only">(success)</span>
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="container mt-3">
   <h3 class="Material-head">
      Assign Product Details
      <hr>
   </h3>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
   <div class="">
   <div class="">
   <div class="col-md-12 col-sm-12 col-xs-12 form-group input_productre middle-box">
      <?php if(empty($assign_emp)){ ?>
      <div class="col-sm-12  col-md-12 label-box mobile-view2">
         <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Product Name<span class="required">*</span></label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Model No.</label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Assets Code</label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Remarks</label></div>
      </div>
      <div class="well scend-tr mobile-view"   id="chkIndex_1">
         <div class="col-md-4 col-sm-12 col-xs-12 item form-group">
            <label class="col-md-12" terial Name>Product Name  <span class="required">*</span></label>                  
            <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible assets_name" name="product_name[]" data-id="assets_list" data-key="id" data-fieldname="ass_name" data-where="created_by_cid = <?php echo $this->companyGroupId; ?> AND in_stock != 0" width="100%" tabindex="-1" aria-hidden="true" required="required" id="assets_id" onchange="getAssetsValue(event,this)">
               <option value="">Select Option</option>
            </select>
         </div>
         <div class="col-md-2 col-sm-12 col-xs-12 item form-group">
            <label class="col-md-12">Model No.</label>
            <input type="text" name="model_no[]"  placeholder="Model No..." class="form-control col-md-7 col-xs-12" required="required" readonly>
         </div>
         <div class="col-md-2 col-sm-6 col-xs-12 form-group">
            <label class="col-md-12" >Assets Code</label>
            <input type="text" name="assets_code[]"  placeholder="Assets Code..." class="form-control col-md-7 col-xs-12"required="required" readonly>
         </div>
        <!-- <div class="col-md-2 col-sm-6 col-xs-12 form-group">
            <label class="col-md-12">Assign Quantity</label>
            <input type="text" name="assign_quantity[]" value="1"  placeholder="Assign Quantity..." class="form-control col-md-7 col-xs-12">
         </div>-->
         <div class="col-md-2 col-sm-6 col-xs-12 form-group">
            <label class="col-md-12">Remarks</label>
            <textarea name="remarks[]" placeholder="Remarks..." class="form-control col-md-7 col-xs-12" style="border-right:1px solid #c1c1c1 !important;"></textarea> 
         </div>
       <input type="hidden" name="return_remarks[]" value="">
         <button class="btn btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button>                  
      </div>
      <div class="col-sm-12 btn-row">
         <button class="btn addProductButtonre edit-end-btn" type="button" align="right">Add</button>
      </div>
      <?php } else{ 
         $products = json_decode($assign_emp->assets_products);
         ?>
      <div class="col-sm-12  col-md-12 label-box mobile-view2">
         <div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Product Name<span class="required">*</span></label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Model No.</label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Assets Code</label></div>
<!--         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Assign Quantity</label></div>-->
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Remarks</label></div>
      </div>
      <?php
         if(!empty($products)){ 
               $i =  1;
               foreach($products as $product){
               ?>
      <div class="well <?php if($i==1){ echo 'edit-row1 scend-tr mobile-view';}else{ echo 'scend-tr mobile-view';}?>"  id="chkWell_<?php echo $i; ?>" style="overflow:auto; ">
         <div class="col-md-4 col-sm-12 col-xs-12 item form-group">
            <label class="col-md-12" terial Name>Product Name  <span class="required">*</span></label>                  
            <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible assets_name" name="product_name[]" data-id="assets_list" data-key="id" data-fieldname="ass_name" data-where="created_by_cid = <?php echo $this->companyGroupId; ?>  AND in_stock != 0" width="100%" tabindex="-1" aria-hidden="true" required="required" id="assets_id" onchange="getAssetsValue(event,this)">
               <option value="">Select Option</option>
               <?php
                  if(!empty($product)){                                               
                      $pp = getNameById('assets_list',$product->product_name,'id');
                      echo '<option value="'.$product->product_name.'" selected>'.$pp->ass_name.'</option>';
                  }
                  ?>
            </select>
         </div>
         <div class="col-md-2 col-sm-12 col-xs-12 item form-group">
            <label class="col-md-12">Model No.</label>
            <input type="text" name="model_no[]"  placeholder="Model No..." class="form-control col-md-7 col-xs-12" required="required" readonly value="<?php echo $product->model_no ; ?>">
         </div>
         <div class="col-md-2 col-sm-6 col-xs-12 form-group">
            <label class="col-md-12" >Assets Code</label>
            <input type="text" name="assets_code[]"  placeholder="Assets Code..." class="form-control col-md-7 col-xs-12"required="required" readonly value="<?php echo $product->assets_code ; ?>">
         </div>
        <!-- <div class="col-md-2 col-sm-6 col-xs-12 form-group">
            <label class="col-md-12">Assign Quantity</label>
            <input type="text" name="assign_quantity[]"  placeholder="Assign Quantity..." class="form-control col-md-7 col-xs-12" value="<?php //echo $product->assign_quantity ; ?>">
         </div>-->
         <div class="col-md-2 col-sm-6 col-xs-12 form-group">
            <label class="col-md-12">Remarks</label>
            <textarea name="remarks[]" style="border-right:1px solid #c1c1c1 !important;" placeholder="Remarks..." class="form-control col-md-7 col-xs-12"><?php echo $product->remarks ; ?></textarea> 
         </div>
        <!-- <input type="hidden" name="back_quantity[]" value="<?php echo $product->back_quantity ; ?>">-->
            <input type="hidden" name="return_remarks[]" value="<?php echo $product->return_remarks ; ?>">

         <button class="btn btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button>
      </div>
      <?php $i++; }
         }
         }?>   
      <div class="col-sm-12 btn-row"><button class="btn addProductButtonre edit-end-btn" type="button">Add</button></div>
   </div>
   <hr>
   <div class="form-group">
      <div class="col-md-12 ">
         <center><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <input type="submit" class="btn edit-end-btn " value="Submit">
         </center>
      </div>
   </div>
</form>