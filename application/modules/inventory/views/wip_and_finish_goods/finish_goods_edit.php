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
               <div class="col-md-12 col-sm-12 col-xs-12 vertical-border">		
                  <div class="col-md-5 col-sm-12 col-xs-12 form-group">	
                     <label>Voucher Date</label>		
                     <input type="date" required="required" name="voucher_date" id="voucher_date" class="form-control req_date">				
                  </div>   
                  <div class="col-md-5 col-sm-12 col-xs-12 form-group">
                     <label> Address</label>
                     <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location_id" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>" required="required">
                        <option>Select Address</option>
                     </select>
                  </div>
               </div>
               <div >
                  <div class="col-md-12 middle-box2 __finishGoodsModal">
                     <div class="well" id="chkIndex_1" style="overflow:auto;" >
                        <div class="item form-group top-fild col-md-10 col-xs-12 col-sm-12 vertical-border">
                           <div class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Work Order</div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
							 <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId" required="required"  name="work_order_id[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" onchange="on_change_Work_order(event,this),updateWorkOrderForScrap(event,this)" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND progress_status = 0 ">
                                 <option value="">Select Option</option>
                              </select>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12 cls_display_none">
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
                        <div class="">
                           <div class="input-group-append">
                              <button class="btn edit-end-btn addmore_finish_workorder" type="button">Add Workorder</button>
                           </div>
                        </div>
                        <hr>
                        <div class="item form-group">
                           <label style="border-top: 1px solid #c1c1c1;border-right: 1px solid #c1c1c1;margin-bottom:15px;text-align:center" class="control-label col-md-3 col-sm-3 col-xs-12" for="scrap">Scrap Value</label>
                           <div class="col-md-12 col-sm-12 col-xs-12 scrap_input_fields_wrap">
                              <div class="col-md-12 input_scrap_holder">
                                 <div class="well scrapWell" id="chkScarpIndex_1" style="overflow:auto;">
                                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                       <label style="border-top: 1px solid #c1c1c1 !important;">Material Type</label>
                                       <select required="required" class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" name="scrap_material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
                                          <option value="">Select Option</option>
                                    
                                       </select>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                       <label style="border-top: 1px solid #c1c1c1 !important;">Material Name</label>
                                       <select required="required" class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="scrap_material_name[]" onchange="getScrapUom(event,this);" id="mat_name">
                                          <option value="">Select Option</option>
                                        
                                       </select>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                       <label style="border-top: 1px solid #c1c1c1 !important;">Quantity</label>
                                       <input required="required" type="text" name="scrap_quantity[]" class="form-control col-md-7 col-xs-12  qty actual_qty keyup_event" placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"> 
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                       <label style="border-right: 1px solid #c1c1c1 !important;border-top: 1px solid #c1c1c1 !important;">UOM</label>
                                       <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="scrap_uom_value1[]" class="form-control col-md-7 col-xs-12  uom" placeholder="uom." value="" readonly>
                                       <input type="hidden" name="scrap_uom_value[]" class="uomid" readonly value=""> 
                                    </div>
                                    <input type="hidden" name="work_order_detail_id[]" class="__workOrderId" value="">
                                 </div>
                                 <div class="col-sm-12 btn-row" style="bottom: -32px">
                                    <div class="input-group-append">
                                       <button class="btn edit-end-btn addScrapButton" type="button">Add Scrap</button>
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
      </div>
   </div>
   <!--<div class="item form-group">
      <div class="col-md-3 col-sm-6 col-xs-12">
      	<input type="hidden" id="total_qty" name="total_qty" class="form-control col-md-7 col-xs-12 total_qty"  placeholder="Total Quantity" value="" >
      </div>	
      </div>	-->
   
   <div class="ln_solid"></div>
   <div class="form-group">
      <div class="col-md- col-md-offset-3">
         <button type="reset" class="btn btn-default">Reset</button>
         <input type="submit" class="btn btn-warning check_mat_qty" value="Submit"> 
      </div>
   </div>
</form>