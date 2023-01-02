                        <div class="well" id="materiyal_<?=$noofrow;?>">
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
                    <div id="clone_<?=$noofrow;?>">
                    <?php
        $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
                      $i = 1;
                      if($sale_order_data !=''){

                            $id='';
                            $materiyal_array=array();
                            $lotqty='';
                            foreach($sale_order_data as $product){
                                $materiyal_array[]= json_decode($product['material_details'],true);
                                $id = $product['id'];
                                $lotqty=$product['lot_qty'];
                            }
                            $workOrderID[] = $WorkOrderID;
                            $newArray = [];
                            if($materiyal_array){
                                foreach($materiyal_array as $mTkey => $mTvalue){
                                    foreach ($mTvalue as $mt2key => $mt2value){
                                      $newArray[] =  $mt2value;
                                    }
                                }
                            }
$asswhere = "`job_card_id`='{$id}' AND `work_order_id` ='{$WorkOrderID}'  AND `saleorder_product` ='{$productId}'AND `created_by_cid`='{$this->companyGroupId}' ";
               $get_job_card_dtl = $this->inventory_model->get_datafor_res('reserved_material', $asswhere);

               $materialDataAcc = $materiyal_array;

               $matWithQty = []; 

               foreach ($materialDataAcc as $key => $value) {
                   foreach ($value as $key2 => $value2) {
                       $matWithQty[$key2] = $value2 + ['quantity_resived' => ''];
                       foreach ($get_job_card_dtl as $keyjob => $valuejob) {
                           if( $valuejob->mayerial_id == $value2['material_name_id']  ){
                               $matWithQty[$key2] = $value2 + ['quantity_resived' => $valuejob->quantity];
                           }
                       } 
                   }
               }
                            $data = mergeMultiDemArray($newArray ,[$WorkOrderID]);
                           
                            $materiyal_array = $newArray;
                            $newQuantityValue = 0;
                         
                            foreach($matWithQty as $keyon => $work_in_pro_mat ){

                             $ww1113 =  getNameById('work_order', $WorkOrderID,'id');
                             $productDetail = getNameById('material',$work_in_pro_mat['material_name_id'],'id');
                            $mat_locations = getNameById('mat_locations',$productDetail->id,'material_name_id');



                          ?>

                          <div class="well" id="materiyal_<?=$noofrow;?>" style="overflow:auto;">
                           <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                            <!-- selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requiredData -->
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requiredData" name="material_type_id_<?=$noofrow;?>[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid='<?php echo $this->companyGroupId; ?>' OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type_<?=$i;?>">
                           <option value="">Select Option</option>
                            <?php if(!empty($work_in_pro_mat['material_type_id'])){  $ww =  getNameById('material_type', $work_in_pro_mat['material_type_id'],'id');
                               echo '<option value="'.$work_in_pro_mat['material_type_id'].'" selected >'.$ww->name.'</option>'; }?>
                           </select>
                        </div>

                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">

                           <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name requiredData" name="material_name_<?=$noofrow;?>[]" onchange="getUom(event,this);getlot(event,this);getMaterialQuantites(event,this,'material')" id="mat_id_funcs">
                              <option value="">Select Option</option>
                                    <?php if(!empty($work_in_pro_mat['material_name_id'])){
                                        $ww1 =  getNameById('material', $work_in_pro_mat['material_name_id'],'id');
                                        echo '<option value="'.$work_in_pro_mat['material_name_id'].'" selected >'.$ww1->material_name.'</option>';
                                    }?>
                           </select>
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-6 form-group">

                           <select class="lotno form-control col-md-2 col-xs-12 selectAjaxOption select2 requiredData" id="lotno" name="lotno_<?=$noofrow;?>[]" data-id="lot_details" data-key="id" data-fieldname="lot_number" data-where="created_by_cid='<?php echo $this->companyGroupId; ?>' AND active_inactive=1">
                              <option value="">Select Option</option>
                       <?php
                      if (!empty($mat_locations->lot_no && $mat_locations->lot_no)) {
                           $material_type_id1 = getNameById('lot_details', $mat_locations->lot_no, 'id');
                          echo '<option value="' . $mat_locations->lot_no . '" selected>' . $material_type_id1->lot_number . '</option>';
                          } ?>
                           </select>
                        </div>
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">

                           <input type ="text"  id="qty" name="qty_<?=$noofrow;?>[]"  class="form-control col-md-7 col-xs-12 keyup_event" placeholder="quantity" value="<?php echo $work_in_pro_mat['quantity_resived']??'';?>" placeholder="Qty">
                        </div>
                         <?php
                         $uom = "";
                         if( isset($work_in_pro_mat['uom']) ){
                             $ww =  getNameById('uom', $work_in_pro_mat['uom'],'id');
                             $uom = !empty($ww)?$ww->ugc_code:'';
                         }
                         ?>
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           <input style="width:100% !important;" name="uom1_<?=$noofrow;?>[]" type="text" value="<?php echo @$uom;?>" placeholder="uom" class="form-control col-md-7 col-xs-12 uom1" readonly>
                           <input  type="hidden" id="uom" name="uom_<?=$noofrow;?>[]" class="form-control col-md-7 col-xs-12 uom" value="<?php echo @$work_in_pro_mat['uom'];?>" readonly placeholder="uom">
                        </div>
                        <!--  locationselectAjaxOption select2 select2-hidden-accessible location requiredData -->
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location requiredData" name="location_<?=$noofrow;?>[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" data-where="created_by_cid='<?php echo $this->companyGroupId; ?>'">
                              <option value="">Select Option</option>
                                <?php
                                 if(!empty($mat_locations->location_id)){
                                          $ww11 =  getNameById('company_address',$mat_locations->location_id,'id');
                                                echo '<option value="'.$mat_locations->location_id.'" selected >'.$ww11->location.'</option>';
                                  } ?>
                           </select>
                        </div>
                        <!-- selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId -->
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId " onchange="getMaterialQuantites(event,this,'work_order')"   name="work_order_id_<?=$noofrow;?>[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid='<?php echo $this->companyGroupId; ?>' AND progress_status = 0">
                              <option value="">Select Option</option>
                          <!--     <?php   if(!empty($WorkOrderID)){
                                 foreach ($getworkID  as  $getworkIDvalue) {
                                echo '<option value="'.$getworkIDvalue['id'].'" selected >'.$getworkIDvalue['workorder_name'].'</option>';
                                    }
                              }
                            ?> -->
                             <?php   if(!empty($WorkOrderID)){

                                 echo '<option value="'.$WorkOrderID.'" selected >'.$ww1113->workorder_name.'</option>';
                              }?>
                           </select>

                     <input type="hidden" class="SelectedSaleOrder" name="sale_order_id_<?=$noofrow;?>[]" value="<?php echo $ww1113->sale_order_id;?>">
                        </div>
                       <!-- selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId -->
                         <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2" name="npdm_<?=$noofrow;?>[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="npdm" data-key="id" data-fieldname="product_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid='<?php echo $this->companyGroupId; ?>'">
                              <option value="">Select Option</option>
                              <?php   if(!empty($work_in_pro_mat->npdm)){
                                 $ww1113 =  getNameById('npdm', $work_in_pro_mat->npdm,'id');
                                 echo '<option value="'.$work_in_pro_mat->npdm.'" selected >'.$ww1113->product_name.'</option>';
                              }?>
                           </select>
                        </div>
                        <!-- selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId -->
                          <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 " name="machine_name_<?=$noofrow;?>[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="add_machine" data-key="id" data-fieldname="machine_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid='<?php echo $this->companyGroupId; ?>'">
                              <option value="">Select Option</option>
                              <?php if(!empty($work_in_pro_mat->machine_name)){
                                    $ww1112 =  getNameById('add_machine', $work_in_pro_mat->machine_name,'id');
                                     echo '<option value="'.$work_in_pro_mat->machine_name.'" selected >'.$ww1112->machine_name.'</option>';
                                 }?>
                           </select>
                        </div>
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           <input name="required_quantity_<?=$noofrow;?>[]" type="text"  class="form-control col-md-7 col-xs-12
                            required_quantity"  value="<?php echo $work_in_pro_mat['required_quantity']??'';?>" readonly>
                        </div>

                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           <input name="issued_quantity_<?=$noofrow;?>[]" type="text"  class="form-control col-md-7 col-xs-12 issued_quantity"
                             value="<?php echo $work_in_pro_mat['issued_quantity']??'';?>" readonly>
                        </div>
                          <button class="btn btn-danger addmore_delete" type="button" id="addmore_delete_<?=$i;?>"><i class="fa fa-minus"></i></button>
                     </div>
        <?php
            $i++;  }
        } ?>
            </div>
            <button class="btn btn-primary addmore" type="button" id="addmore_1"><i class="fa fa-plus"></i></button>
