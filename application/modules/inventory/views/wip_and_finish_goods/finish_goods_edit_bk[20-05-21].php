<?php
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveFinishGoods" enctype="multipart/form-data" id="" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php //if(!empty($get_account_freeze)) echo $get_account_freeze->id; ?>">
   <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
      <div class="item form-group ">
         <div class="col-md-12 col-sm-12 col-xs-12 recv_finish_goods_add">
            <div class="panel panel-default" style="overflow: hidden; padding-bottom: 35px;">
               <h3 class="Material-head">
                  Received Finish Goods<span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span>
                  <hr>
               </h3>
               <div >
                  <div class="col-md-12 middle-box2">
                     <div class="well" id="chkIndex_1" style="overflow:auto;" >
                        <div class="item form-group top-fild col-md-10 col-xs-12 col-sm-12 vertical-border">
                           <div class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Work Order</div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
							 <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId" required="required"  name="work_order_id[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" onchange="on_change_Work_order(event,this)" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND progress_status = 0 ">
                                 <option value="">Select Option</option>
                              </select>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <input type="text" id="total_Qty_Amount" name="total_Qty_Amount[]" class="form-control col-md-7 col-xs-12 totalQtyAmount"  placeholder="Quantity in total" value="" >
                           </div>
                        </div>
                        <div class="item form-group abc" style="border-top:1px solid #c1c1c1 !important; clear: both;">
                           <div class="label-box mobile-view2">
                              <div class="col-md-3 item form-group">
                                 <label class="col-md-12 col-sm-12 col-xs-12" for="mate">Product name</label>
                              </div>
                              <div class="col-md-2 item form-group">
                                 <label class="col-md-12 col-sm-12 col-xs-12" for="qty">Quantity</label>
                              </div>
                              <div class="col-md-2 item form-group">
                                 <label class="col-md-12 col-sm-12 col-xs-12" for="Uom">UOM</label>
                              </div>
							 <div class="col-md-3 item form-group">
                                 <label class="col-md-12 col-sm-12 col-xs-12" for="qty">Job Card</label>
                              </div>
                              <div class="col-md-2 item form-group" style="border-right:1px solid #c1c1c1 !important;">
                                 <label class="col-md-12 col-sm-12 col-xs-12" for="output" >Output</label>
                              </div>
                           </div>
                           <div class="item form-group">
                              <!--<div class="col-md-12">-->
                              <div class="col-md-12 input_holder form-group" id="input_holder">
                              </div>
                              <!--</div>-->
                           </div>
                        </div>
                        <div class="btn-row">
                           <div class="input-group-append">
                              <button class="btn edit-end-btn addmore_finish_workorder" type="button">Add</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!--<div class="item form-group">
      <div class="col-md-3 col-sm-6 col-xs-12">
      	<input type="hidden" id="total_qty" name="total_qty" class="form-control col-md-7 col-xs-12 total_qty"  placeholder="Total Quantity" value="" >
      </div>	
      </div>	-->
   <div class="item form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="scrap">Scrap Value</label>
      <div class="col-md-3 col-sm-6 col-xs-12">
         <input type="text" id="scrap_qty" name="scrap_qty" class="form-control col-md-7 col-xs-12"  placeholder="scrap" value="" >
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
         <select class="form-control selectAjaxOption select2 select2-hidden-accessible  select2 " name="material_scrap_id" data-id="material" data-key="id" data-fieldname="material_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND status = 1 AND material_type_id = 6"  id="material_name" >
            <option value="">Select Option</option>
            <?php /*if(!empty($materials)){
               $material_type_id = getNameById('material_type',$materials->material_type_id,'id');
               echo '<option value="'.$materials->material_type_id.'" material_type_prefix="'.$material_type_id->prefix.'" selected >'.$material_type_id->name.'</option>';
               }*/?>
         </select>
      </div>
   </div>
   <div class="ln_solid"></div>
   <div class="form-group">
      <div class="col-md- col-md-offset-3">
         <button type="reset" class="btn btn-default">Reset</button>
         <input type="submit" class="btn btn-warning check_mat_qty" value="Submit"> 
      </div>
   </div>
</form>