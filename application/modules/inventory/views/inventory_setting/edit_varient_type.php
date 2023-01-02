<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveVariantType" enctype="multipart/form-data" novalidate="novalidate">
   <div class="col-md-7 col-xs-12 col-sm-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="supp_code">Variant Types</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
          <input type="hidden" name="id" value="<?php echo $variant_type->id ?>">
          <input type="text" id="variant_type" name="variant_type" required="required" class="form-control col-md-12 col-xs-12" placeholder="Variant Types" value="<?php echo $variant_type->varient_name ?>" style="border-right: 1px solid #c1c1c1 !important;">
         </div>
      </div>
   </div>
   <div class="col-md-12 " style="margin: 20px 0px;">
      <center>
         <button type="reset" class="btn btn-default">Reset</button>
         <button id="send" type="submit" class="btn btn-warning">Submit</button> <a class="btn btn-danger" data-dismiss="modal">Cancel</a> 
      </center>
   </div>
</form>