<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveWorkInProcessMaterial" enctype="multipart/form-data" id="AccountGroupForm" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php //if(!empty($get_account_freeze)) echo $get_account_freeze->id; ?>">
	<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">
			
	<div class="item form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="material_type">Product Type <span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
						<option value="">Select Option</option>
						
				</select>
			</div>
	</div>
	
	
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">				
		<div class="item form-group ">
            <div class="col-md-12 col-sm-12 col-xs-12 input_material_wrap">
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title"><strong>Product Detail</strong></h3><span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span></div>
						<div class="panel-body goods_descr_wrapper">
							<div class="item form-group">
								<div class="col-md-12">
									
									
									
									<div class="col-md-12 input_holder">
										<div class="well" id="chkIndex_1" style="overflow:auto;">
											<div class="col-md-4 col-sm-6 col-xs-12">
												<select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name" id="mat_name"  name="material_name[]" onchange="getUom_location(event,this);">
													<option value="">Select Option</option>
												</select> 	
											</div>
											<div class="col-md-2 col-sm-6 col-xs-12">
												<input type ="text"  id="qty" name="qty[]"  class="form-control col-md-7 col-xs-12 keyup_event" placeholder="quantity" value="" placeholder="Qty">
											</div>
											<div class="col-md-2 col-sm-6 col-xs-12">
												<input type="text" id="uom" name="uom[]" class="form-control col-md-7 col-xs-12 uom" readonly placeholder="uom">
											</div>
											<div class="col-md-4 col-sm-6 col-xs-12">
												<select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" data-where="created_by_cid='<?php echo $_SESSION['loggedInUser']->c_id; ?>'">
												</select>
											</div>
											<div class="col-md-2 col-sm-12 col-xs-12 form-group">	
												<div class="input-group-append">
													<button class="btn btn-primary addMoreMaterial" type="button"><i class="fa fa-plus"></i></button>
												</div>
											</div>
										</div>												
									</div>		
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-6 col-md-offset-3">
				<button type="reset" class="btn btn-default">Reset</button>
				<input type="submit" class="btn btn-warning check_mat_qty" value="Submit"> </div>
		</div>
</form>