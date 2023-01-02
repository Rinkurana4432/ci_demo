<Style>
	.custHeader h4 {
    border: 1px solid #c1c1c1;
    padding: 4px 10px;
    margin: 0px;
    border-bottom: 0px;
}
.custHeader h4 input.groupCustomer {
    float: right;
    margin-right: 20px;
}
.custList {
    border: 1px solid #c1c1c1;
}
#.custList span {
    width: 100% !important;
    display: table;
    padding: 6px 10px;
}
.custList span:nth-child(odd) {
    background-color: gainsboro;
}
.custList span {
    padding: 5px 10px;
    display: table;
    width: 100%;
}
.custList input.customerSelect1 {
    margin-right: 10px;
}

</Style>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/customer_discount_insert" enctype="multipart/form-data" id="AccountGroupForm" novalidate="novalidate">
	<input type="hidden" name="id" value="<?= $discount['id']??'' ?>">
	<div class="col-md-12 col-xs-12 col-sm-12 vertical-border">	
		<div class="required item form-group">
			<label class=" col-md-3 col-sm-2 col-xs-4" for="account_id">Discount Name<span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input name="discount_name" class="form-control" value="<?= $discount['discount_name']??'' ?>" required>
			</div>
		</div> 	
		<div class="item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="account_id">Customer Name</label>
			<div class="col-md-6 col-sm-12 col-xs-12" style="padding: 0px;">
				<div class="col-md-12" style="padding: 0px;">
					<div class="custContainer">
						<?php
							if( $customer ){
								if( isset($discount['party_name'] )){
									$customerEditId = json_decode($discount['party_name']);
								}
								foreach ($customer as $custKey => $custValue) {?>
										<div class="col-md-6">
											<div class="allCustomer">
												<div class="custHeader">
													<h4><?= $custValue['group_name'] ?><input type="checkbox" class="groupCustomer" groupId= "<?= $custValue['tocId'] ?>"></h4>		
												</div>
												<div class="custList">
													<?php
														if($custValue['customerDetails']){
															$i = 0;
															$check = '';
															foreach ($custValue['customerDetails'] as $custNameKey => $custNameValue) { 
																	if( isset($customerEditId) ){
																		if( in_array($custNameValue['ledger_id'],$customerEditId) ){
																			$check = 'checked';
																		}else{
																			$check = '';
																		}
																	}	
																?>
																<span>
																	<input type="checkbox"  name="custmerId[]" value="<?= $custNameValue['ledger_id'] ?>" class="customerSelect<?= $custValue['tocId'] ?>" <?= $check ?>>
																	<?= $custNameValue['customerName'] ?>
																</span>
																
														<?php $i++; }
														}


													 ?>
												</div>
											</div>
										</div>
								<?php }
							}

						 ?>
					</div>
				</div>
			</div>
		</div> 
		<div class="required item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="account_id">Discount Percentage</label>
			<div class="col-md-6 col-sm-12 col-xs-12" style="padding: 0px;">
				<div class="discount_percent">
					<div class="item form-group add-ro">
						<div class="col-md-12 input_descr_wrap label-box mobile-view2">
							<div class="col-md-6 col-xs-12 item form-group">
								<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Percentage % <span class="required">*</span></label>
							</div>
							<div class="col-md-6 col-xs-12 item form-group">
								<label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">No. of days <span class="required">*</span></label>
							</div>
						</div>
						<div class="col-md-12 input_descr_wrap middle-box mobile-view mailing-box mailing_box_appn addMorePerDays">
						<?php if( isset($discount['day_discount']) && !empty($discount['day_discount']) ){
								$dayData = json_decode($discount['day_discount'],true);
								$i = 1;
								foreach ($dayData as $key => $value) { ?>
											<div id="addMorePerDays">
												<div class="col-md-6 col-xs-12 item form-group">
													<input type="text" name="customerDis[row<?= $i ?>][percentage]" value="<?= $value['percentage'] ?>" class="form-control perNumber" onkeypress = "return float_validation(event, this.value)">
												</div>
												<div class="col-md-6 col-xs-12 item form-group">
													<input type="text" name="customerDis[row<?= $i ?>][days]" value="<?= $value['days'] ?>" class="form-control perDays" onkeypress="return float_validation(event, this.value)">
													<button class="btn btn-danger" id="btnShow" style="<?php if( $i > 1 ){ echo 'display:block;'; }else{ echo 'display:none;';} ?>position: absolute;right: -44px;z-index: 11;top: 0;" type="button"><i class="fa fa-minus"></i></button>
												</div>
											</div>

								<?php $i++; }

						}else{ ?>

							<div id="addMorePerDays">
								<div class="col-md-6 col-xs-12 item form-group">
									<input type="text" name="customerDis[row1][percentage]" value="<?= $value['percentage'] ?>" class="form-control perNumber" onkeypress = "return float_validation(event, this.value)">
								</div>
								<div class="col-md-6 col-xs-12 item form-group">
									<input type="text" name="customerDis[row1][days]" value="" class="form-control perDays" onkeypress="return float_validation(event, this.value)">
									<button class="btn btn-danger" id="btnShow" style="display:none;position: absolute;right: -44px;z-index: 11;top: 0;" type="button"><i class="fa fa-minus"></i></button>
								</div>
							</div>

						<?php } ?>
						</div>			
						<div class="col-sm-12">
							<div class="btn-container" style="padding-top: 10px;float: right;">
								<input type="hidden" id="countRow" value="<?= $i??2 ?>">
								<button class="btn btn-primary addPerDays" type="button">Add</button>	
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div> 
	</div>	
	<hr>
	<div class="form-group">
		<div class="col-md-6 col-md-offset-3">
		   <center>
			<button type="reset" class="btn btn-default">Reset</button>
			<input type="submit" class="btn btn-warning" value="Submit"> 
			</center>
		</div>
	</div>
</form>