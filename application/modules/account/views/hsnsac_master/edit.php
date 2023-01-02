<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saveHSNSAC_master" enctype="multipart/form-data" id="AccountGroupForm" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($hsn_master_data)) echo $hsn_master_data->id; ?>">
	<div class="col-md-6 col-xs-12 col-sm-12 vertical-border ">
		<div class="required item form-group">
			<label class=" col-md-3 col-sm-2 col-xs-4" for="hsn_sac">HSN / SAC<span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<!-- data-validate-length-range="4" -->
				<input id="name" class="form-control col-md-7 col-xs-12"   value="<?php if(!empty($hsn_master_data)) echo $hsn_master_data->hsn_sac; ?>" name="hsn_sac" type="number"  required="required" onKeyPress="return check(event,value)" onInput="checkLength(8,this)" id="txtF">
			</div>
		</div>

		<div class="required item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="account_id">Short Name <span class="required">*</span></label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input id="name" class="form-control col-md-7 col-xs-12" required  value="<?php if(!empty($hsn_master_data)) echo $hsn_master_data->short_name; ?>" name="short_name" type="text"  >
			</div>
		</div>
	</div>
	<div class="col-md-6 col-xs-12 col-sm-12 vertical-border ">




	<div class="item form-group">
		<label class="col-md-3 col-sm-2 col-xs-12" for="name">CESS </label>
		<div class="col-md-6 col-sm-6 col-xs-12">
		<input  class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($hsn_master_data)) echo $hsn_master_data->cess; ?>" name="cess" type="text" > </div>
	</div>

</div>
<hr>
<div class="col-md-12" style="margin-top: 30px;">

<div class="col-md-4 col-xs-12 col-sm-12 vertical-border ">
<div class="item form-group">
			<label class="col-md-3 col-sm-2 col-xs-12" for="name">Type </label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<select class="itemName form-control  select2"  name="type"  width="100%">
					<option value="">Select And Begin Typing</option>
					<option value="goods"  <?php if(!empty($hsn_master_data)) { if($hsn_master_data->type == 'goods') echo 'selected'; }?>> Goods </option>
					<option value="service" <?php if(!empty($hsn_master_data)) { if($hsn_master_data->type == 'service') echo 'selected'; }?>> Service </option>
				</select>
			</div>
	</div></div>
<div class="col-md-4 col-xs-12 col-sm-12 vertical-border ">
    <div class="item form-group">
			<label class="col-md-3 col-sm-2 col-xs-12" for="name">IGST </label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<input id="igst_keyup" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($hsn_master_data)) echo $hsn_master_data->igst; ?>" name="igst" type="text" > </div>
		</div>

		<div class="item form-group" >
			<label class="col-md-3 col-sm-2 col-xs-12" for="name">SGST </label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<input id="sgst_keyup" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($hsn_master_data)) echo $hsn_master_data->sgst; ?>" name="sgst" type="text" > </div>
		</div>
</div>
<div class="col-md-4 col-xs-12 col-sm-12 vertical-border ">
       <div class="item form-group" style="margin-top: 43px;">
			<label class="col-md-3 col-sm-2 col-xs-12" for="name">CGST </label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<input id="cgst_hsnmaster" class="form-control col-md-7 col-xs-12"  value="<?php if(!empty($hsn_master_data)) echo $hsn_master_data->cgst; ?>" name="cgst" type="text" > </div>
		</div>
</div>
</div>
<hr>
	<div class="form-group">
		<div class="col-md-6 col-md-offset-3">
		   <center>
			<button type="button" class="btn btn-default" data-dismiss="modal"><a href="<?= base_url('account/hsnsacmaster') ?>">Close</a></button>
			<button type="reset" class="btn btn-default">Reset</button>
			<input type="submit" class="btn btn-warning" value="Submit"> </div>
			</center>
	</div>
</form>
