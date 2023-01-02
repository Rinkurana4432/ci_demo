<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>


<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveInventoryListing" enctype="multipart/form-data" id="inventory_listing" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if($inventoryListing && !empty($inventoryListing)){ echo $inventoryListing->id; }?>">
		<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
				<input type="hidden" name="material_name_id" value="" id="material_id">
				<input type="hidden" name="material_type_id" value="" id="material_type_id">
		<div class="item form-group col-md-6 vertical-border">	
		<div class="item form-group">
			<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="hidden"  name="action_type" class="form-control col-md-7 col-xs-12" id="Actiontype" readonly value="">
			</div>
		</div>				
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12">Half / Full Book <span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="btn-group" data-toggle="buttons">
					<p>
					Half Book:
					<input type="radio" class="flat" name="half_full_book" id="sale" value="halfbook" checked required /> Full book:
					<input type="radio" class="flat" name="half_full_book" id="purchase" value="fullbook" />
					</p>
					</div>
				</div>
          </div>
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Party Name<span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="party_name" name="party_name" required="required" class="form-control col-md-7 col-xs-12" placeholder="party name" value="">
				</div>
		</div>

		
</div>

<div class="item form-group col-md-6 vertical-border">

		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Product Type</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text"  name="material_type" required="required" class="form-control col-md-7 col-xs-12 material_type" placeholder="Material type" value="" readonly>
				</div>
		</div>	
</div> 

<hr>
<div class="bottom-bdr"></div>

		<div class="col-md-12 col-sm-12 col-xs-12 form-group">				
			<div class="item form-group ">
                <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
					
					     <h3 class="Material-head">Product Detail<span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span><hr></h3>	
						 
						<!--<div class="panel-heading"><h3 class="panel-title"><strong>Product Detail</strong></h3><span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span></div>-->
						
							<div class="panel-body goods_descr_wrapper">
								<div class="item form-group middle-box2">
								<!--<div class="col-md-12">
									<div class="col-md-6 item form-group">
										<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Product Name<span class="required">*</span></label>
									</div>
									<div class="col-md-2 item form-group">
										<label class="col-md-12 col-sm-12 col-xs-12" for="Quantity">Quantity<span class="required">*</span></label>
									</div>	
									<div class="col-md-3 item form-group">
										<label class="col-md-12 col-sm-12 col-xs-12" for="Uom">Uom<span class="required">*</span></label>
									</div>	
								</div>-->
							
							<div class="col-md-12 material_detail">
								<div class="well" id="chkIndex_1" style="overflow:auto; border: 1px solid #c1c1c1;">
									<div class="col-md-6 col-sm-6 col-xs-12 form-group">
									    <label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Product Name<span class="required">*</span></label>
										<input type="text" id="material_name" name="material_name" required="required" class="form-control col-md-7 col-xs-12 material_name" placeholder="Material name" value="" readonly>
									</div>
									
									<div class="col-md-3 col-sm-12 col-xs-12 form-group">
									    <label class="col-md-12 col-sm-12 col-xs-12" for="Quantity">Quantity<span class="required">*</span></label>
										<input type="text" id="qty" name="quantity" class="form-control col-md-7 col-xs-12 keyup_check_qty"  placeholder="Qty." required="required">
									</div>														
									<div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                        <label class="col-md-12 col-sm-12 col-xs-12" for="Uom">Uom<span class="required">*</span></label>									
										<select class="form-control uom" name="uom" id="uom" readonly>
											<option>Unit</option>
											<?php $checked ='';			
												$uom = getUom();											  
												foreach($uom as $unit) {												 
												if((!empty($indents)) && ($indents->uom == $unit)){ $checked = 'selected';}else{$checked = '';  }	
												echo "<option value='".$unit."' ".$checked.">".$unit."</option>";												
												}									
											?>		
										</select>
									</div>		
								</div>			
							</div>
						</div>
					  </div>
					
				</div>
			</div>
		</div>
		<div class="item form-group col-md-6 vertical-border">	
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Time Period<span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="date" name="time_period" required="required" class="form-control col-md-7 col-xs-12">
				</div>
		</div>
		</div>
		<div class="item form-group col-md-6 vertical-border">	
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Description</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<textarea id="Description" name="reason"  class="form-control col-md-7 col-xs-12" placeholder="Description............."></textarea>
				</div>
		</div>
	  </div>
		<hr>
		<div class="form-group">
			<div class="col-md-12 col-xs-12 ">
			  <center>
				<input type="reset" class="btn btn-default" value="Reset">
					<input type="submit" class="btn btn-warning check_mat_qty" value="submit">
						<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>inventory/inventory_listing'">Cancel</a>
			  </center>
			</div>
		</div>
			
</form>
<script>
		var measurementUnits = <?php echo json_encode(getUom()); ?>;		
	</script>
                  