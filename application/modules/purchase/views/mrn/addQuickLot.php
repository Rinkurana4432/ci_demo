<div class="modal left fade" id="myModal_lotdetails" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Lot Details</h4>
            <span id="mssg343"></span>
         </div>
         <form name="insert_party_data" name="ins"  id="insert_Matrial_data_id33">
            <div class="modal-body">
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-12" for="name">Lot No.<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="lotno" name="material_name" required="required" class="form-control col-md-7 col-xs-12" value="" >
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <input type="hidden" name="material_type_id" id="material_type_id22"  class="form-control" value="">
               <input type="hidden" name="material_name_id"  id="material_name_id">
               <span class="spanLeft control-label"></span>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-12" for="email">MOU Price</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="mou_price" name="hsn_code" class="form-control col-md-7 col-xs-12" value="" >
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-12" for="email">MRP Price</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="mrp_price" name="hsn_code" class="form-control col-md-7 col-xs-12" value="" >
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-10 col-sm-10 col-xs-12" for="email">Date</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="date" name="date" id="date" class="form-control col-md-7 col-xs-12 req_date" value="">
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <input type="hidden" id="add_matrial_Data_onthe_spot">
               <button type="button" class="btn btn-default close_sec_model" >Close</button>
               <button id="Add_lot_details_on_button_click_mrn" type="button" class="btn edit-end-btn ">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>