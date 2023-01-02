<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/save_grn_report" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
   <div role="tabpanel" data-example-id="togglable-tabs">
   <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
      <li role="presentation" class="active"><a href="#controlled_report" id="controlled_tab" role="tab" data-toggle="tab" aria-expanded="true">Report</a></li>
      <li role="presentation" class="inspection "><a href="#product" role="tab" data-toggle="tab" id="inspection_tab" aria-expanded="false">Product</a></li>
   </ul>
   <div id="myTabContent" class="tab-content">
   <div role="tabpanel" class="tab-pane fade active in" id="controlled_report" aria-labelledby="controlled_tab">
      <!--job card details-->
      <input type="hidden" name="id" value="<?php if(!empty($grn)){echo $grn->id;}?>" />
      <input type="hidden" name="saleorder" value="grn" />
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12" for="parameter">Report Name <span class="required">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-6">
               <input id="para" class="form-control col-md-7 col-xs-12" name="report_name"  required="required" type="text" value="<?php  if(!empty($grn)){echo $grn->report_name;}else{ echo 'GRN_Report_Name_'.getLastIdIncerment('controlled_report_master'); };?>" readonly>	
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12" for="instrument">No. of Observation</label>
            <div class="col-md-3 col-sm-3 col-xs-6">
               <input id="ins" class="form-control col-md-7 col-xs-12 observations" name="observations"  type="number" value="<?php  if(!empty($grn)){echo $grn->observations;};?>">
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12" for="expectation">Per Lot Of Observation</label>
            <div class="col-md-3 col-sm-3 col-xs-6">
               <input class="form-control col-md-7 col-xs-12" name="per_lot_of" value="<?php  if(!empty($grn)){echo $grn->per_lot_of;};?>"  type="number" >
            </div>
            <label class="col-md-1 col-sm-3 col-xs-12" for="expectation">UOM</label>
            <div class="col-md-3 col-sm-3 col-xs-6">
               <select class="uom  form-control selectAjaxOption select2" name="uom"  width="100%" id="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" data-where="created_by_cid='0' || created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true"  >
                  <option>Select</option>
                  <?php foreach($uom as $data){

                     ?>
                  <option value="<?php echo $data->id;?>" <?php  if(!empty($grn)){if($grn->uom==$data->id){echo 'Selected';}}?>><?php echo $data->uom_quantity;?></option>
                  <?php }?>
               </select>
            </div>
         </div>
         <div class="item form-group">
            <div class="col-md-3 col-sm-3 col-xs-6">
               <?php 
               $grnValue = 'PDI';
               if( isset($grn->saleorder) ){
                    if( $grn->saleorder == 'grn' ){
                        $grnValue =  "GRN";
                   }   
               }elseif ( $this->uri->segment(2) == 'add_grn' || $this->uri->segment(2) == 'edit_grn' ) {
                      $grnValue =  "GRN";
                   } 
                ?>
               <label><?= $grnValue ?></label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
               <select class="materialNameId  form-control selectAjaxOption select2" required="required" name="material_id"  width="100%" id="sel_con1" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" onchange="get_material_table_values('grn');get_product_qty();get_material_name()">
                  <option value="">Select Material</option>
                  <?php foreach($material as $material_name){?>
                  <option value="<?php echo $material_name['id'];?>" <?php  if(!empty($grn)){if($grn->material_id==$material_name['id']){echo 'Selected';}}?>><?php echo $material_name['material_name'];?></option>
                  <?php }?>
               </select>
            </div>
         </div>
      </div>
      <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
      <div id="reportParameter">  
      </div>
      <center>
         <div class="modal-footer">
            <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>  
            <input type="submit" class="btn btn edit-end-btn " value="Submit">
         </div>
      </center>
   </div>
   <div role="tabpanel" class="tab-pane fade" id="product" aria-labelledby="controlled_tab">
      <div id="print_div_content">
         <table id="" class="table table-striped table-bordered" border="1" cellpadding="3">
            <thead>
               <tr>
                  <th>Product</th>
                  <th>Total Qty</th>
                  <th>Qty Passed</th>
                  <th>Qty Rejected</th>
                  <th>Rework Qty</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>
                     <div id="material_name"></div>
                  </td>
                  <?php if($grn->quantity_info){
                           $qtyInfo = json_decode($grn->quantity_info);
                  } ?>
                  <td><input type="number" name="tot_qty" id="tot_qty" readonly="readonly"/></td>
                  <td><input type="number" name="qty_pass" id="qty_pass" value="<?= $qtyInfo->qty_pass??'' ?>" onblur="chk_qty()" required="required"/></td>
                  <td><input type="number" name="qty_reject" id="qty_reject" value="<?= $qtyInfo->qty_reject??'' ?>" onblur="chk_qty()"  required="required"/></td>
                  <td><input type="number" name="qty_rework" id="qty_rework" value="<?= $qtyInfo->qty_rework??'' ?>" onblur="chk_qty()" required="required"/></td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
</form>