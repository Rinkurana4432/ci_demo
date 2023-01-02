	<form>
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		<input type="hidden" name="id" value="<?php if(!empty($voucher_dtls)) echo $voucher_dtls->id; ?>">
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
				<div class=" panel-default">
					<div class="x_content">
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="label-box mobile-view3">			  
										   <div class="col-md-4 col-sm-12 col-xs-12 form-group label" style="border-left: 1px solid #c1c1c1;">Ladger Name</div>
										   <div class="col-md-4 col-sm-12 col-xs-12 form-group label">Credited Amount</div>
										   <div class="col-md-4 col-sm-12 col-xs-12 form-group label">Debited Amount</div>
								</div>
								<?php 
								if(!empty($voucher_dtls)){
										$credit_debit_amount = json_decode($voucher_dtls->credit_debit_party_dtl);
										foreach($credit_debit_amount as $cr_dr_amount){
									?>		
								<div class="row-padding col-container mobile-view view-page-mobile-view mailing-box">
								<div class="col-md-4 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Ladger Name</label><div><?php
									$credit_party = getNameById('ledger',$cr_dr_amount->credit_debit_party_dtl,'id');
									echo $credit_party->name;
								?></div></div>
								<div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Credited Amount</label><div><?php if($cr_dr_amount->credit_1 != ''){echo $cr_dr_amount->credit_1;}else{ echo 'N/A';}?></div></div>
								<div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Debited Amount</label><div><?php if($cr_dr_amount->debit_1 != ''){ echo $cr_dr_amount->debit_1;}else{echo 'N/A';}?></div></div>
								
								</div>
								<?php }                                     
								}?> 
								
							</div>
							
						
						
					
					
						
					
			</div>
		</div>
		
		
	</div>
	</div>
</div>
							
</div>
</div>

</div>   
	
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<hr>
				
					<div class="form-group">
						<div>
						<div class="col-md-12 col-xs-12">
						<center>
					
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							
						 </center>
						</div>
						</div>
					</div>
				
			</div>
	</form>		