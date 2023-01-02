<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveVariantOption" enctype="multipart/form-data" novalidate="novalidate">
     	<div class="col-md-6 col-xs-12 col-sm-12 vertical-border" >
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="supp_code">Variant type</label>
            <div class="col-md-7 col-sm-12 col-xs-12">
               <input type="hidden" name="id" value="<?php echo $variant_options->id ?>">
               <!--select class="form-control selectAjaxOption select2 select2-hidden-accessible variantoptId" required="required" name="variant_type" data-id="variant_types" data-key="id" data-fieldname="varient_name" tabindex="-1" aria-hidden="true" data-where="" id="variant_type">
                  <option value="">Select Option</option>
                  <?php 
                  $variant_type = getNameById('variant_types',$variant_options->variant_type_id,'id');
                 // echo '<option value="'.$variant_type->id.'" selected >'.$variant_type->varient_name.'</option>';
                  ?>
               </select-->
			    <input type="hidden" name="variant_type" value="<?php echo $variant_options->variant_type_id ?>" readonly>
			    <input type="text" class="form-control" name="variant_typeName" value="<?php echo $variant_type->varient_name ?>" readonly>
            </div>
		</div>
		<div class="item form-group">
		 <label class="col-md-3 col-sm-12 col-xs-12" for="supp_code">Variant code</label>
            <div class="col-md-7 col-sm-12 col-xs-12">
               <input type="text" id="variant_option" name="variant_option" required="required" class="form-control col-md-12 col-xs-12" placeholder="Variant Option Name" value="<?php echo $variant_options->option_name; ?>" style="border-right: 1px solid #c1c1c1 !important;">
            </div>
          </div>
         </div>
	 <div class="col-md-6 col-xs-12 col-sm-12 vertical-border" >
	 <label class="col-md-3 col-sm-12 col-xs-12" for="supp_code">Images</label>
	 <div class="item form-group">
	    <div class="col-md-7 col-sm-12 col-xs-12">
           <input type="file" class="form-control col-md-7 col-xs-12" name="varient_option_img" onchange="loadFile(event)">
           <img id="output" style="width: 50px; height: 50px;" src="<?php echo base_url(); ?>assets/modules/inventory/varient_opt_img/<?php echo $variant_options->option_img_name; ?>">
		   <input type="hidden" name="variant_opt_img_old" value="<?php echo $variant_options->option_img_name; ?>" >
            </div>
           </div>
      </div>	
      <hr>
<div class="form-group">
	<div class="col-md-12 ">
	  <center>
		<button type="reset" class="btn btn-default">Reset</button>
		<button id="send" type="submit" class="btn btn-warning">Submit</button>
		<a class="btn btn-danger" data-dismiss="modal">Cancel</a>
		</center>
	</div>
</div>
</form>

<script>
  var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('output');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>