<form method="post" action="saveAssetsCat" id="assetsform" enctype="multipart/form-data">
    
    <input type="hidden" name="id" value="<?php if(!empty($assets_val)){ echo $assets_val->id; }?>">
    <input type="hidden" name="save_status" value="1" class="save_status">  
    <input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId ?>" id="loggedUser">
    <div class="modal-body">
         <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
        <div class="form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Category Type </label>
         <div class="col-md-6 col-sm-12 col-xs-12"><select name="cat_status" class="form-control custom-select" required>
            <option>Select Category</option>
            <option value="ASSETS">Assets</option>
            <option value="LOGISTIC">Logistice</option>
        </select>
		</div>
    </div>
	</div>
	 <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
    <div class="form-group">
        <label class="col-md-3 col-sm-12 col-xs-12">Category Name </label>
        <div class="col-md-6 col-sm-12 col-xs-12"><input type="text" name="cat_name" class="form-control"  placeholder="Category name..." minlength="2" required value="<?php if(!empty($assets_val)){ echo $assets_val->cat_name; }?>"></div>
    </div> 
</div>	
</div>
<div class="modal-footer">                                       
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>