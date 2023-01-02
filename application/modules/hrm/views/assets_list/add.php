<form method="post" action="saveAssetsList" enctype="multipart/form-data">
   <input type="hidden" name="id" value="<?php if(!empty($assets_list)){ echo $assets_list->id; }?>">
   <input type="hidden" name="save_status" value="1" class="save_status">  
   <input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId ?>" id="loggedUser">
   <div class="modal-body">
      <div  class="col-md-6 col-sm-12 col-xs-12 vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Assets Type <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12 ">
               <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible selectedEmployeeID" name="catid" data-id="assets_category" data-key="id" data-fieldname="cat_name" data-where="created_by_cid = <?php echo $this->companyGroupId; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">
                  <option value="">Select Option</option>
                  <?php
                     if(!empty($assets_list)){                                               
                         $cat_id = getNameById('assets_category',$assets_list->catid,'id');
                         echo '<option value="'.$assets_list->catid.'" selected>'.$cat_id->cat_name.'</option>';
                     }
                     ?>
               </select>
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Assets Name <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12 "><input type="text" name="ass_name" class="form-control"  placeholder="Assets name..." minlength="2"  required="required" value="<?php if(!empty($assets_list)){ echo $assets_list->ass_name; }?>"></div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Specification </label>
            <div class="col-md-6 col-sm-12 col-xs-12 "> <textarea class="form-control" name="configuration" placeholder="Configuration..."><?php if(!empty($assets_list)){ echo $assets_list->configuration; }?></textarea></div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Assets Brand <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12 "> <input type="text" name="ass_brand" class="form-control"  placeholder="Assets Brand" minlength="2"  required="required" value="<?php if(!empty($assets_list)){ echo $assets_list->ass_brand; }?>"></div>
         </div>
      </div>
      <div  class="col-md-6 col-sm-12 col-xs-12 vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Purchasing Date <span class="required">*</span></label>
            		<div class="col-md-6 col-sm-12 col-xs-12  input-group date" data-provide="datepicker">
				<input type="text" class="form-control" name="purchasing_date"  required="required" value="<?php if(!empty($assets_list)){ echo $assets_list->purchasing_date; }?>">
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-th"><i class="fa fa-calendar" aria-hidden="true"></i>
</span>
				</div>
			</div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Assets Model <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12 "> <input type="text" name="ass_model" class="form-control"  placeholder="Assets Model" minlength="2"  required="required" value="<?php if(!empty($assets_list)){ echo $assets_list->ass_model; }?>"></div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Assets Price <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12 "><input type="number" name="ass_price" class="form-control"  placeholder="Assets price"  required="required" value="<?php if(!empty($assets_list)){ echo $assets_list->ass_price; }?>"></div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Assets Code <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12 "><input type="text" name="ass_code" class="form-control"  placeholder="Assets Code" minlength="2"  required="required" value="<?php if(!empty($assets_list)){ echo $assets_list->ass_code; }?>"></div>
         </div>       
		 <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Availability</label>
            <div class="col-md-6 col-sm-12 col-xs-12 ">
				  <select class="form-control"  name="in_stock" id="availability">
				<option value="1" <?php  if(!empty($assets_list)){  echo ($assets_list->in_stock == 1)?'selected':''; } ?>>Yes</option>
				<option value="0"  <?php  if(!empty($assets_list)){  echo ($assets_list->in_stock == 0)?'selected':''; } ?>>No</option>
			  </select>
		</div>
         </div>
         <!--    <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Quantity</label>
            <div class="col-md-6 col-sm-12 col-xs-12 "><input type="text" name="ass_qty" class="form-control"  placeholder="Assets Quantity"required value="<?php // if(!empty($assets_list)){ echo $assets_list->ass_qty; }?>"></div>
            </div>-->
      </div>
   </div>
   <div class="modal-footer">
      <center><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-primary">Submit</button>
      </center>
   </div>
</form>