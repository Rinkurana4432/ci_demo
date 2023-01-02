<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/save_cost_center" enctype="multipart/form-data" id="myform" novalidate="novalidate">
	<input type="hidden" name="id" value="<?= $costCenter['id']??'' ?>">
	<hr>
	<div class="bottom-bdr"></div>
	<div class="item form-group" style="padding-bottom: 15px;">
		<div class="col-md-12 col-sm-12 col-xs-12 processDiv middle-box">
			<div class="well" style="overflow:auto; overflow:auto;border-top: 1px solid #c1c1c1 !important;">				
                 <div class="col-md-12 col-sm-12 col-xs-12 form-group costCenterArea">
				  	<label style="border-right: 1px solid #c1c1c1 !important;">Cost Center Name</label>
				  	<div class="costCenterInput well">
				  		<input type="text" id="costCenterName" <?= (isset($costCenter['cost_center_name']))?'name="costCenterName"':'name="costCenterName[]"'; ?> name="costCenterName[]" required="required" class="form-control col-md-12 col-xs-12" placeholder="Cost Center Name" value="<?= $costCenter['cost_center_name']??'' ?>" style="border-right: 1px solid #c1c1c1 !important;">
				  		<button class="btn btn-danger remve_field remove_btn plus-btn" type="button"><i class="fa fa-minus"></i></button>	
				  	</div>
					
				 </div>	
				 <?php if(!isset($costCenter['cost_center_name'])){ ?>
			 			<div class="col-md-12 col-sm-12 btn-row">
							<div class="input-group-append">
							<button class="btn edit-end-btn addMoreCostName" type="button">Add</button>
							</div>
						</div>
				 <?php } ?>				
				
			</div>
		</div>
	</div>
	<hr>
	<div class="form-group">
		<div class="col-md-12 ">
		  <center>
		  	<?php if(!isset($costCenter['cost_center_name'])){ ?>
				<button type="reset" class="btn btn-default">Reset</button>
			<?php } ?>
			<button id="send" type="submit" class="btn btn-warning">Submit</button>
			<a class="btn btn-danger" data-dismiss="modal">Cancel</a>
			</center>
		</div>
	</div>
</form>