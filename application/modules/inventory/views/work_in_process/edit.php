 <style>
    .well:hover .delete_mat_btn{
       display: block !important;
    }
 </style>
<?php  
 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   $last_id = getLastTableId('wip_request');
   $rId = $last_id + 1;
   $matCode = 'RMRQ_'.rand(1, 1000000).'_'.$rId; 
   ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveWorkInProcessMaterial" enctype="multipart/form-data" id="AccountGroupForm" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php //if(!empty($get_account_freeze)) echo $get_account_freeze->id; ?>">
   <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
   

   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
      <div class="item form-group vertical-border">
        <div class="col-md-6">  
          <label class="col-md-2 col-sm-3 col-xs-12" for="code">Request No.</label>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <input id="material_code" class="form-control col-md-7 col-xs-12" name="request_id" placeholder="Request No." type="text" value="<?php if(!empty($matCode)) echo $matCode;?>" readonly>
          </div>
        </div>
   

     </div>
     
      <div class="item form-group ">
         <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="panel-default">
               <h3 class="Material-head">
                  Product Detail <span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span>
                  <hr>
               </h3>


               <div class="panel-body goods_descr_wrapper middle-box2">
                <div class="__messageDetail"></div>
                  <div class="col-md-12 input_holder input_material_wrap" style="border-right: 1px solid #c1c1c1; border-top: 1px solid #c1c1c1; padding:0px;">
                    
                       
                         
                        
                           <div class="jobcard_product" id="materiyal_1">
                            <div class="well" id="materiyal_1">
                                 <div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Product Type</label></div>
                                 <div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Product name</label></div> 
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Quantity</label></div> 
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Uom</label></div>
                                 <div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>location</label></div> 
                                 <div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Work Order</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>NPDM</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Machine Name</label></div> 
                          </div>
                       <div id="clone_1" > 
                           <div class="well" id="materiyal_1" style="overflow:auto;">
                           <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                            <!-- selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requiredData -->
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requiredData"  name="material_type_id_1[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
                           <option value="">Select Option</option>
                            </select>
                        </div>  
                      
                        <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                           
                           <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name requiredData"  name="material_name_1[]" onchange="getUom(event,this);getlot(event,this);getMaterialQuantites(event,this,'material')" id="mat_id_funcs">
                              <option value="">Select Option</option>
                                  
                           </select>
                        </div>
                        
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           
                           <input type ="text"  id="qty" name="qty_1[]"  class="form-control col-md-7 col-xs-12 keyup_event" placeholder="quantity"   placeholder="Qty">
                        </div>

                         
                         
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group"> 
                           <input style="width:100% !important;" name="uom1_1[]" type="text"  placeholder="uom" class="form-control col-md-7 col-xs-12 uom1" readonly>
                           <input  type="hidden" id="uom" name="uom_1[]" class="form-control col-md-7 col-xs-12 uom"   readonly placeholder="uom">
                        </div>
                        <!--  locationselectAjaxOption select2 select2-hidden-accessible location requiredData -->
                        <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                           <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location requiredData" name="location_1[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
                              <option value="">Select Option</option>
                                
                           </select>
                        </div>
                        <!-- selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId -->
                        <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId " onchange=" getMaterialQuantites(event,this,'work_order')"   name="work_order_id_1[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND progress_status = 0 ">
                              <option value="">Select Option</option>
                         
                           </select> 
                   
                     <input type="hidden" class="SelectedSaleOrder" name="sale_order_id_1[]"  >
                        </div>
                       <!-- selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId -->
                         <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2" name="npdm_1[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="npdm" data-key="id" data-fieldname="product_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> ">
                              <option value="">Select Option</option>
                              
                           </select>  
                        </div>
                        <!-- selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId -->
                          <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 " name="machine_name_1[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="add_machine" data-key="id" data-fieldname="machine_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> ">
                              <option value="">Select Option</option>
                               
                           </select>  
                        </div>
                        
                          
                     </div>
                   </div>
                   <button class="btn btn-primary addmore" type="button"><i class="fa fa-plus"></i></button>
                 </div>  
                    
                  </div>
                  
               </div>
            </div>
         </div>
      </div>
   </div>
   <hr>
   <div class="form-group">
      <div class="col-md-12 col-xs-12">
         <center>
            <button type="reset" class="btn btn-default">Reset</button>
            <input type="submit" class="btn btn-warning submit rm_request" value="Submit"> 
            <button type="button" class="btn btn-close" data-dismiss="modal">Close</button>

         </center>
      </div>
   </div>
</form>
