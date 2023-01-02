<?php   
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   
   ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>bid_management/save_price_prodct" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php if(!empty($account)){ echo $account->id;   }?>">
   <input type="hidden" id="loggedUser" value="<?php echo $this->companyGroupId; ?>">
   <input type="hidden" name="created_by" value="<?php if(!empty($account)){ echo $account->created_by;   }?>">
   <input type="hidden" name="save_status" value="1" class="save_status">	
   <h3 class="Material-head" style="margin-bottom: 30px;">
      Competitor Price Information
      <hr>
   </h3>

   <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <label>Material Type</label>
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 mmnm" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialNameCA(event,this)" id="material_type">
                        <option value="">Select Option</option>
                        <?php
                           if(!empty($product_detail)){
                              $material_type_id = getNameById('material_type',$product_detail->material_type_id,'id');
                              echo '<option value="'.$product_detail->material_type_id.'" selected>'.$material_type_id->name.'</option>';
                              }
                           ?> 
                     </select>
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <label>Material Name</label>
                     <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name" onchange="getUomCA(event,this);">
                        <option value="">Select Option</option>
                     </select>
                  </div>
   <hr>
   <div class="bottom-bdr"></div>
   <!-- <div class="ln_solid"></div> -->
   <h3 class="Material-head">
      Product Details
      <hr>
   </h3>
   <div class="item form-group ">
      <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
         <div class="item form-group">
            <div class="col-md-12 input_holder middle-box">
               <div class="well " id="chkIndex_1" style=" overflow:auto;">

               <div class="col-sm-12 btn-row"><button class="btn edit-end-btn  add_price_prodct_row" type="button">Add</button></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="form-group" style="text-align:center;">
      <div class="col-md-12 col-xs-12">
         <center>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <input type="submit" class="btn edit-end-btn" value="Submit">
         </center>
      </div>
   </div>
</form>