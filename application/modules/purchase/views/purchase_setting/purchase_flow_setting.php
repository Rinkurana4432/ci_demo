<div role="tabpanel" class="tab-pane fade " id="purchase_flow_setting" aria-labelledby="purchase_flow_setting-tab">
   <form id="purchase_flow_form"><input type="hidden" name="tab" value="purchase_flow_setting"/></form>
   <div class="col-md-8 col-sm-12 col-xs-12 vertical-border" style="clear: both;"> 
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label class="col-md-3 col-sm-3 col-xs-12" for="type">Auto Approve material</label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <table class="table table-striped checkAction">
               <tbody>
                  <tr>
                    <td>
                     <div class="row">
                        <div class="col-md-9">
                           <select class="form-control select2" id="approved_material_type" multiple="multiple" name="approved_material_type" data-action="add">
                           <option value="">Select Option</option>
                           <?php 
                              if( !empty($notApprovedMaterial) ){
                                 foreach ($notApprovedMaterial as $key => $value) {?>
                                    <option value="<?= $value['id'] ?>"><?= $value['name']; ?></option>
                                 <?php }
                              }
                           ?>   
                           </select>
                        </div>
                        <div class="col-md-3">
                           <button type="button" class="btn btn-success selected_material_save">Save</button>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <?php if( !empty($approvedmaterial )){ ?>
                           <h4 class="text-center">Approved Material Type</h4>
                           <div class="row">
                              <?php 
                              foreach ($approvedmaterial as $key => $value) { ?>
                                 <div class="col-md-3">
                                    <div class="materialDetails">
                                       <?= ucfirst($value['name']); ?>
                                       <span class="deleteApprovemat" data-id="<?= $value['id'] ?>" onclick="return confirm('Are Your Sure ?')" data-action="delete">
                                          <i class="fa fa-trash"></i>
                                       </span>
                                    </div>
                                 </div>   
                              <?php }
                             ?>
                           </div>
                        <?php } ?>
                     </div>
                     
                    </td>
                  </tr>
                </tbody>
            </table>
         </div>
      </div>
   </div>
   <div class="col-md-8 col-sm-12 col-xs-12 vertical-border" style="clear: both;"> 
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label class="col-md-3 col-sm-3 col-xs-12" for="type">Gate Entry</label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <table class="table table-striped checkAction">
               <tbody>
                  <tr>
                    <th scope="row" style="width: 500px;">Gate Entry</th>
                    <td>
                        <label class="switch">
                          <input type="checkbox" value="1" name="gateEntry" id="gateEntry" <?= ($gateEntry)?'checked':"";  ?>>
                          <span class="slider round"></span>
                        </label>
                     </td>
                  </tr>
                  
                </tbody>
            </table>
         </div>
      </div>
   </div>
   <div class="col-md-8 col-sm-12 col-xs-12 vertical-border" style="clear: both;"> 
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label class="col-md-3 col-sm-3 col-xs-12" for="type">Purchase Order DisApprove</label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <table class="table table-striped checkAction">
               <tbody>
                  <tr>
                    <th scope="row" style="width: 500px;">If user edit po order all approve status will remove</th>
                    <td>
                        <label class="switch">
                          <input type="checkbox" value="1" class="onOffStatus" name="po_disapprove_status" data-tbl="company_detail" data-where="id=<?= $this->companyGroupId ?>" id="onoffStatus" <?= ($po_approve_details['po_disapprove_status'])?'checked':"";  ?>>
                          <span class="slider round"></span>
                        </label>
                     </td>
                  </tr>
                  
                </tbody>
            </table>
         </div>
      </div>
   </div>
   <div class="col-md-8 col-sm-12 col-xs-12 vertical-border" style="clear: both;"> 
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label class="col-md-3 col-sm-3 col-xs-12" for="type">Purchase Order Approve</label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <table class="table table-striped checkAction">
               <tbody>
                  <tr>
                    <th scope="row" style="width: 500px;">Purchase Order Approve</th>
                    <td>
                        <label class="switch">
                          <input type="checkbox" value="1" class="onOffStatus" name="po_approve_status" data-tbl="company_detail" data-where="id=<?= $this->companyGroupId ?>" id="onoffStatus" <?= ($po_approve_details['po_approve_status'])?'checked':"";  ?>>
                          <span class="slider round"></span>
                        </label>
                     </td>
                  </tr>
                  
                </tbody>
            </table>
         </div>
      </div>
   </div>
   <?php if( isset($po_approve_details['po_approve_status']) ){
            if( $po_approve_details['po_approve_status'] > 0  ){ ?>
               <div class="col-md-8 col-sm-12 col-xs-12 vertical-border" style="clear: both;"> 
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-3 col-sm-3 col-xs-12" for="type">Purchase Order Approve Level</label>
                     <div class="col-md-9 col-sm-6 col-xs-12">
                        <table class="table table-striped checkAction">
                           <tbody>
                              <tr>
                                <td>
                                    <div class="row inputFieldArea">
                                       <div class="col-md-9">
                                          <input type="text" name="po_approve_level" data-tbl="company_detail" data-where="id=<?= $this->companyGroupId ?>" class='form-control' 
                                                value="<?= ($po_approve_details['po_approve_level'])?$po_approve_details['po_approve_level']:''; ?>" onkeypress="return float_validation(event, this.value)">
                                       </div>
                                       <div class="col-md-3">
                                          <button type="button" class="btn btn-success submitInputValue">Save</button>
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <?php 
                                          if( isset($po_approve_details['po_approve_level']) ){
                                             if( $po_approve_details['po_approve_level'] > 0 ){ ?>
                                                <h4 class="text-center">Purchase Order Approve By Users</h4>
                                                <form action="<?= base_url('purchase/purchase_order_approve_user') ?>" class="form-group row userApproveFrom" method="POST">
                                             <?php 
                                                $j = 0;
                                                $users = [];
                                                if( isset($po_approve_details['po_approve_users']) ){
                                                    $users = json_decode($po_approve_details['po_approve_users'],true);
                                                }
                                                for ($i=1; $i <= $po_approve_details['po_approve_level']; $i++) {
                                                      $user_name = "";
                                                   ?>
                                                   <div class="userSelectArea">
                                                     <h4 class="col-md-3" >Step Approval <?= $i ?></h4>
                                                      <div class="col-md-9 ">
                                                        <select placeholder="Users" class="form-control commanSelect2" multiple name="po_aprove_users[<?= $j ?>][]"  required>
                                                         <?php 
                                                            if( $allUsersData ){
                                                               foreach($allUsersData as $allKey => $allValue ){?>
                                                                  <option value="<?= $allValue['u_id'] ?>"
                                                                     <?php if( isset($users[$j]) ){
                                                                              if( in_array($allValue['u_id'],$users[$j]) ){
                                                                                 echo 'selected';
                                                                              }
                                                                     } ?>
                                                                  >
                                                                  <?= $allValue['name']??'' ?>
                                                                  </option>
                                                            <?php }

                                                            }

                                                         ?>
                                                        </select>
                                                      </div> 
                                                   </div>
                                             <?php $j++;
                                                 } ?>
                                                <div class="col-md-12">
                                                   <div class="form-group">
                                                      <input type="submit" class="btn btn-success" value="Save">
                                                   </div>
                                                </div>
                                                </form>
                                       <?php }       
                                          } ?>
                                    </div>
                                </td>
                              </tr>
                            </tbody>
                        </table>
                     </div>
                  </div>
               </div>
      <?php }
         } ?>
</div>