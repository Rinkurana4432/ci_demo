<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/savetagtypes" enctype="multipart/form-data" id="myform" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($tag_types)) echo $tag_types->id; ?>">
	<input type="hidden" name="created_date" value="<?php if(!empty($tag_types)) echo $tag_types->created_date; ?>">
		<hr>
		<div class="bottom-bdr"></div>
			<?php if(!empty($tag_types)){ ?>
				<div class="item form-group blog-mdl" style="padding-bottom: 15px;">
					<div class="col-md-6 col-sm-12 col-xs-12 processDiv middle-box">
	                    <div class="well " style="overflow:auto; overflow:auto;border-top: 1px solid #c1c1c1 !important;" >				
	                   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
						   <label style="border-right: 1px solid #c1c1c1 !important;">Tag Types</label>
						 <!--  <input type="hidden"  name="cust_typ" value="<?php //if(!empty($customer_type)) echo $customer_type->type_of_customer; ?>"> -->
						<input type="text" id="processName" name="tag_types[]" required="required" class="form-control col-md-12 col-xs-12" placeholder="Industry Name" value="<?php if(!empty($tag_types)) echo $tag_types->tag_types; ?>" style="border-right: 1px solid #c1c1c1 !important;"></div>
	                 </div>					 
				</div>
			<?php }	?>
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