<?php    $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
$materialissue=$this->inventory_model->get_data_byId('wip_request','id',$id);?>
 <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/UpdateInProcessMaterial_request" enctype="multipart/form-data" id="AccountGroupForm" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php echo $id; ?>">
   <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
   

   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
      <div class="item form-group vertical-border">
      <label class="col-md-2 col-sm-3 col-xs-12" for="code">Request No.</label>
      <div class="col-md-4 col-sm-6 col-xs-12">
         <input id="material_code" class="form-control col-md-7 col-xs-12" name="request_id" placeholder="Request No." type="text" value="<?php if(!empty($materialissue)) echo $materialissue->request_id;?>" readonly>
      </div>
      </div>
      <div class="item form-group ">
         <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="panel-default">
               <h3 class="Material-head">
                  Product Detail<span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span>
                  <hr>
               </h3>

               <div class="panel-body goods_descr_wrapper middle-box2">
                <div class="__messageDetail"></div>  
                 <div class="col-md-12 input_holder input_material_wrap" style="border-right: 1px solid #c1c1c1; border-top: 1px solid #c1c1c1; padding:0px;">
                    <?php
                         $j = 0;  
                         if($materialissue->mat_detail !=''){
                          $workinpromat = json_decode($materialissue->mat_detail);   
                         foreach($workinpromat as $key => $work_in_pro_mat){
                           $j++;  
                            $workinpromat2 = json_decode($work_in_pro_mat->input_process);
                          $workorder_name =  getNameById('work_order', $work_in_pro_mat->work_order_id_select,'id');
                          
                           ?>
               <div class="well" id="chkIndex_<?=$j;?>" style="overflow:auto;">
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                         <label>Work Order <span class="required">*</span></label>
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId" onchange="getMaterialOfWorkOrder(this.id,1);getMaterialQuantites(event,this,'work_order')" name="work_order_id_select[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND progress_status = 0" id="multipleSelect_<?=$j;?>"  >
                        <option value="">Select Option</option>
                          <?php if(!empty($work_in_pro_mat->work_order_id_select)){
                             $workorder_name =  getNameById('work_order', $work_in_pro_mat->work_order_id_select,'id');
                             echo '<option value="'.$work_in_pro_mat->work_order_id_select.'" selected >'.$workorder_name->workorder_name.'</option>';
                             }?>
                         </select> 
                      </div>
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                     <label>Product Name <span class="required">*</span></label>
                        <select class="form-control "   name="work_order_product[]"  id="work_order_product" >
                       <option value="">Select Option</option>
                        <?php if(!empty($work_in_pro_mat->work_order_product)){
                             $material =  getNameById('material', $work_in_pro_mat->work_order_product,'id');
                             echo '<option value="'.$work_in_pro_mat->work_order_product.'" selected >'.$material->material_name.'</option>';
                             }?>
                       </select>
                   </div>   
               </div>
                         
              <div class="jobcard_product" id="materiyal_<?=$j;?>">
                    <div class="well" id="materiyal_1">
                                 <div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Product Type</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Product name</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Lot No.</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Quantity</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Uom</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>location</label></div> 
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Work Order</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>NPDM</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Machine Name</label></div>
                              <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Req Qty</label></div> 
                             <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Issued Qty</label></div>
                          </div>
                         <?php
                         $i = 1;  
                          foreach( $workinpromat2 as $workinpromatall ){ ?>  

                     <div class="well" id="materiyal_<?=$i;?>" style="overflow:auto;">
                        <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requiredData"   name="material_type_id_<?=$j;?>[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
                              <option value="">Select Option</option>
                                <?php if(!empty($workinpromatall->material_type_id)){
                                   $ww =  getNameById('material_type', $workinpromatall->material_type_id,'id');
                                      echo '<option value="'.$workinpromatall->material_type_id.'" selected >'.$ww->name.'</option>';
                                                }?>
                           </select>
                        </div>
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           
                           <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name requiredData"  name="material_name_<?=$j;?>[]" onchange="getUom(event,this);getlot(event,this);getMaterialQuantites(event,this,'material')" id="mat_id_funcs">
                              <option value="">Select Option</option>
                                     <?php if(!empty($workinpromatall->material_id)){
                                        $ww1 =  getNameById('material', $workinpromatall->material_id,'id');
                                        echo '<option value="'.$workinpromatall->material_id.'" selected >'.$ww1->material_name.'</option>';
                                        }?>
                           </select>
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                           
                          <select class="lotno form-control col-md-2 col-xs-12 selectAjaxOption select2 requiredData" id="lotno" name="lotno_<?=$j;?>[]" data-id="lot_details" data-key="id" data-fieldname="lot_number" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND active_inactive=1">
                              <option value="">Select Option</option>
                                        <?php
                                           if (!empty($workinpromatall->lot_id && $workinpromatall->lot_id)) {
                                           $material_type_id1 = getNameById('lot_details', $workinpromatall->lot_id, 'id');
                                           echo '<option value="' . $workinpromatall->lot_id . '" selected>' . $material_type_id1->lot_number . '</option>';
                                            } ?>
                           </select>
                        </div>
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           
                           <input type ="text"  id="qty" name="qty_<?=$j;?>[]"  class="form-control col-md-7 col-xs-12 keyup_event" placeholder="quantity" value="<?php if(!empty($workinpromatall->quantity)){ echo $workinpromatall->quantity; } ?>" placeholder="Qty">
                        </div>
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group"> 
                           <input style="width:100% !important;" name="uom1_<?=$j;?>[]" type="text" placeholder="uom" class="form-control col-md-7 col-xs-12 uom1" readonly>
                           <input  type="hidden" id="uom" name="uom_<?=$j;?>[]" class="form-control col-md-7 col-xs-12 uom" value="<?php echo $workinpromatall->uom?>" readonly placeholder="uom">
                        </div>
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location requiredData" name="location_<?=$j;?>[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
                              <option value="">Select Option</option>
                                <?php 
                                       if(!empty($workinpromatall->location)){
                                          $ww11 =  getNameById('company_address', $workinpromatall->location,'id');
                                                echo '<option value="'.$workinpromatall->location.'" selected >'.$ww11->location.'</option>';
                                            } ?>
                           </select>
                        </div>
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId" onchange=" getMaterialQuantites(event,this,'work_order')" required="required"  name="work_order_id_<?=$j;?>[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND progress_status = 0 ">
                              <option value="">Select Option</option>
                              <?php if(!empty($workinpromatall->work_order_id)){
                                 $ww111 =  getNameById('work_order', $workinpromatall->work_order_id,'id');
                                  echo '<option value="'.$workinpromatall->work_order_id.'" selected >'.$ww111->workorder_name.'</option>';
                                 }?>
                           </select> 
                   
                     <input type="hidden" class="SelectedSaleOrder" name="sale_order_id_<?=$j;?>[]"  value="<?php echo $workinpromatall->sale_order_id;?>">
                        </div>
                         <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId"      name="npdm_<?=$i;?>[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="npdm" data-key="id" data-fieldname="product_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> ">
                              <option value="">Select Option</option>
                              <?php   if(!empty($workinpromatall->npdm)){
                                 $ww1113 =  getNameById('npdm', $workinpromatall->npdm,'id');
                                 echo '<option value="'.$workinpromatall->npdm.'" selected >'.$ww1113->product_name.'</option>';
                                            }?>
                           </select>  
                        </div>
                          <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId"      name="machine_name_<?=$j;?>[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="add_machine" data-key="id" data-fieldname="machine_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> ">
                              <option value="">Select Option</option>
                              <?php if(!empty($workinpromatall->machine_name)){
                                    $ww1112 =  getNameById('add_machine', $workinpromatall->machine_name,'id');
                                     echo '<option value="'.$workinpromatall->machine_name.'" selected >'.$ww1112->machine_name.'</option>';
                                 }?>
                           </select>  
                        </div>
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           <input name="required_quantity_<?=$j;?>[]" type="text"  class="form-control col-md-7 col-xs-12 required_quantity"  value="<?php echo $workinpromatall->required_quantity;?>" readonly>
                        </div>

                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           <input name="issued_quantity_<?=$j;?>[]" type="text"  class="form-control col-md-7 col-xs-12 issued_quantity"   value="<?php echo $workinpromatall->issued_quantity;?>" readonly>
                        </div>
                        
                          <button class="btn btn-danger delete_mat_btn" type="button"><i class="fa fa-minus"></i></button>
                         
                         
                          
             </div>
            <?php   $i++;  }?> <?php    } }?>

                  </div>
                <div class="btn-row">
                     <div class="input-group-append">
                        <button class="btn btn-primary addMoreMaterial" type="button">Add</button>
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
            <input type="submit" class="btn btn-warning submit" value="Submit"> 
         </center>
      </div>
   </div>
</form>
 
