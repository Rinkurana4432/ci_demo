<div class="modal left fade" id="myModal_Add_matrial_details" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Material Details</h4>
            <span id="mssg34"></span>
         </div>
         <form name="insert_party_data" name="ins"  id="insert_Matrial_data_id">
            <div class="modal-body">
            <div id="errorMsg" style="width: 80%;text-align: center;"></div>
			<div class="item col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-4 col-sm-4 col-xs-4" for="name">Material Type <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8">
                    <select class="selectAjaxOption select2 form-control" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" width="100%" id="material_type_id" data-where="created_by_cid = <?php 	echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0">
                        <option value="">Select Option</option>
                     </select>
                  </div>
               </div>
               <div class="item col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="name">Material Name <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8">
                     <input type="text" id="material_name" name="material_name" class="form-control col-md-7 col-xs-12" value="">
                  </div>
               </div>
               <!--div class="item col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="name">Code<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8">
                     <input type="text" id="product_code" name="product_name" class="form-control col-md-7 col-xs-12" value="">
                  </div>
               </div-->
               <input type="hidden" name="prefix"  id="prefix">
               <div class="item col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">HSN Code </label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="selectAjaxOption select2 form-control" name="hsn_code" data-id="hsn_sac_master" data-key="id" data-fieldname="concat(hsn_sac,' - ',igst)" width="100%" id="hsn_code_quick_add" data-where="created_by_cid = <?php   echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0">
                        <option value="">Select Option</option>
                     </select>
                  </div>
               </div>
               <input type="hidden" name="tax" value="" id="tax_quick_add">
               <div class="item col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="email">UOM</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <select class="uom selectAjaxOption select2 form-control" name="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" id="uom" data-where="created_by_cid = <?php 	echo $this->companyGroupId; ?> OR created_by_cid = 0 AND active_inactive = 1" tabindex="-1" aria-hidden="true">
                        <option value="">Select Option</option>
                     </select>
                  </div>
               </div>
               <div class="item col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-12 col-sm-2 col-xs-4" for="gstin">Opening Balance</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="opening_balance_Sec" name="opening_balance" class="form-control col-md-7 col-xs-12" value="">
                  </div>
               </div>
               <div class="item col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-10" for="gstin">Specification</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification"></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <input type="hidden" id="add_matrial_Data_onthe_spot">
               <button type="button" class="btn btn-default close_sec_model" >Close</button>
               <button id="Add_matrial_details_on_button_click_purchase" type="button" class="btn edit-end-btn ">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>