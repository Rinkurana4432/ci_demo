<?php

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

?>
	

    <div class="item form-group col-md-8 col-xs-12 vertical-border">												
</div>	
	
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">				
		<div class="item form-group ">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
				<div class="panel-default">
				<h3 class="Material-head">Current Location<hr></h3>
				 <table id="" style="width:100%" class="table table-bordered product_index  bulk_action" data-id="user" border="1" cellpadding="3">
								<thead>
										<tr>
											<th>Address</th>
											<th>Storage</th>
											<th>Rack No.</th>
											<th>Quantity</th>																							
										</tr>
								</thead>
								<?php 
									if($mat_trans->current_location !=''){
											$loc1 = json_decode($mat_trans->current_location);
											foreach($loc1 as $loc){
												$location = getNameById('company_address',$loc->location,'id');
												echo "<tr>
														<td><h5>".((!empty($location))?($location->location):'')."<h5></td>
														<td>".((!empty($loc))?($loc->Storage):'')."</td>
														<td>".((!empty($loc))?($loc->RackNumber):'')."</td>
														<td>".((!empty($loc))?($loc->quantity):'')."</td>
													</tr>";
											} 
									}
									else{
										echo "<tr><td colspan='7'>"."No Data Available"."</td></tr>";
									}
					echo "</table></td><td  data-label='New Location:'>";
						?>
						<h3 class="Material-head">New Location<hr></h3>
					<table id="" style="width:100%" class="table table-bordered product_index  bulk_action" data-id="user" border="1" cellpadding="3">
								<thead>
										<tr>
											<th>Address</th>
											<th>Storage</th>
											<th>Rack No.</th>
											<th>Quantity</th>																							
										</tr>
								</thead>
								<?php 
									if($mat_trans->new_location !=''){
											$loc2 = json_decode($mat_trans->new_location);
											foreach($loc2 as $locc){
												$location = getNameById('company_address',$locc->location,'id');
												echo "<tr>
														<td><h5>".((!empty($location))?($location->location):'')."<h5></td>
														<td>".((!empty($locc))?($locc->Storage):'')."</td>
														<td>".((!empty($locc))?($locc->RackNumber):'')."</td>
														<td>".((!empty($locc))?($locc->quantity):'')."</td>
													</tr>";
											} 
									}
									else{
										echo "<tr><td colspan='7'>"."No Data Available"."</td></tr>";
									}
										echo "</table>";
						?>				
				</div>
			</div>
		</div>
	</div>
	
<hr>
            
<div class="col-md-12 col-md-offset-3" style="margin-top: 20px;">
<center>
		<a class="btn edit-end-btn" onclick="location.href='<?php echo base_url();?>inventory/mat_trans'">Cancel</a>
 </div>
					</center>
              
