<?php 

$ci = & get_instance();

	 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


?>

<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveFinishGoods" enctype="multipart/form-data" id="" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php //if(!empty($get_account_freeze)) echo $get_account_freeze->id; ?>">
	<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
			
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">				
		<div class="item form-group ">
            <div class="col-md-12 col-sm-12 col-xs-12 recv_finish_goods_add middle-box2">
				<div class="panel panel-default">
					<!--<div class="panel-heading"><h3 class="panel-title"><strong>Received Finish Goods</strong></h3><span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span></div>-->
					
					<h3 class="Material-head">Received Finish</h3><span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span><hr></b></h3>
					
						<div class="panel-body middle-box2">
							<div class="col-md-12">
									<div class="well" id="chkIndex_1" style="overflow:auto;" >
										<div class="item form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="mat_name">Job Card</label>
												<div class="col-md-3 col-sm-6 col-xs-12">
													<select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 job_card_class" required="required" name="job_card_no[]" data-id="job_card" data-key="id" data-fieldname="job_card_no" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" onchange="on_change_job_card(event,this)" id="job_card">
														<option value="">Select Option</option>
													</select>
												</div>
														
											<div class="col-md-3 col-sm-6 col-xs-12">
												<input type="text" id="total_Qty_Amount" name="total_Qty_Amount[]" class="form-control col-md-7 col-xs-12 totalQtyAmount"  placeholder="Quantity in total" value=""  onkeyup ="GetTotalValue(event,this);" onkeypress ="GetTotalValue(event,this);">
												
											</div>
										</div>	

										<div class="item form-group abc">
										
												<div class="col-md-3 item form-group">
													<label class="col-md-12 col-sm-12 col-xs-12" for="mate">Product name</label>
												</div>
												<div class="col-md-3 item form-group">
													<label class="col-md-12 col-sm-12 col-xs-12" for="qty">Quantity</label>
												</div>	
												<div class="col-md-3 item form-group">
													<label class="col-md-12 col-sm-12 col-xs-12" for="Uom">UOM</label>
												</div>	
												<div class="col-md-3 item form-group">
													<label class="col-md-12 col-sm-12 col-xs-12" for="output">Output</label>
												</div>	
												<div class="item form-group">
													<!--<div class="col-md-12">-->
														<div class="col-md-12 input_holder" id="input_holder">
																				
														</div>		
													<!--</div>-->
												</div>
										</div>
												
										
										<div class="col-md-2 col-sm-12 col-xs-12 form-group">	
											<div class="input-group-append">
												<button class="btn btn-primary add_more_finish_goods" type="button"><i class="fa fa-plus"></i></button>
											</div>
										</div>	
									</div>	
								</div>	
							</div>	
						</div>
				</div>
			</div>
		</div>
		<!--<div class="item form-group">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<input type="hidden" id="total_qty" name="total_qty" class="form-control col-md-7 col-xs-12 total_qty"  placeholder="Total Quantity" value="" >
			</div>	
		</div>	-->
	<div class="item form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="scrap">Scrap Value</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
				<input type="text" id="scrap_qty" name="scrap_qty" class="form-control col-md-7 col-xs-12"  placeholder="scrap" value="" onkeyup="GetTotalValue();">
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12">
				<select class="form-control selectAjaxOption select2 select2-hidden-accessible  select2 " name="material_scrap_id" data-id="material" data-key="id" data-fieldname="material_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> AND status = 1 AND material_type_id = 6"  id="material_name" >
					<option value="">Select Option</option>
						<?php /*if(!empty($materials)){
							$material_type_id = getNameById('material_type',$materials->material_type_id,'id');
							echo '<option value="'.$materials->material_type_id.'" material_type_prefix="'.$material_type_id->prefix.'" selected >'.$material_type_id->name.'</option>';
						}*/?>
				</select>
			</div>
	</div>		
							
							
	<div class="ln_solid"></div>
	<div class="form-group">
		<div class="col-md-12 col-md-offset-3">
			<button type="reset" class="btn btn-default">Reset</button>
			<input type="submit" class="btn btn-warning check_mat_qty" value="Submit"> 
		</div>
		
	</div>
</form>