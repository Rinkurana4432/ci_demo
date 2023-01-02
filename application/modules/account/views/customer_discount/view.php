<!-- page content -->
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
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">				
		<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">	  
		     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
				   <label scope="row">Discount Name</label>
					<div class="col-md-7 col-sm-12 col-xs-6 form-group"><?= $discount['discount_name'] ?></div>
			 </div>		
	         <div class="col-md-12 col-sm-12 col-xs-12 form-group"> 
			   	<label scope="row">Ledger:</label>
			 	<div class="col-md-7 col-sm-12 col-xs-6 form-group">
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
																	<input type="checkbox"  name="custmerId[]" value="<?= $custNameValue['ledger_id'] ?>" class="customerSelect<?= $custValue['tocId'] ?>" <?= $check ?> disabled>
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
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
			   <label scope="row">Created Date :</label>
			 	<div class="col-md-7 col-sm-12 col-xs-6 form-group"><?= date('d M Y',strtotime($discount['created_date'])); ?></div>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12 form-group">						
			<div class="label-box mobile-view3">			  
			   <div class="col-md-3 col-sm-12 col-xs-12 form-group label">Percentage %</div>
			   <div class="col-md-3 col-sm-12 col-xs-12 form-group label">Days</div>
			</div>
				<?php 
					$daysData = json_decode($discount['day_discount'],true);
					if( !empty($daysData) ){
						foreach ($daysData as $key => $value) { ?>
							<div class="label-box mobile-view3">
							   <div class="col-md-3 col-sm-12 col-xs-12 form-group label"><?= $value['percentage'] ?></div>
							   <div class="col-md-3 col-sm-12 col-xs-12 form-group label"><?= $value['days'] ?></div>					
							</div>
				 <?php  }
					}
				?>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
			<div class="form-group">
				<div class="modal-footer">
					<button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>  
	</div>
</div>
<!-- /page content -->