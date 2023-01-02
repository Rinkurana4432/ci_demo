<?php
//pre($comapny_group_details);
// die();
 ?>
<input type="hidden" name="id" value="<?php if(!empty($comapny_group_details)){ echo $comapny_group_details->id;} ?>">
  <div class="col-md-12 col-sm-12 col-xs-12">				
   
<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">	  
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		   <label scope="row">Company Logo:</label>
		 <div class="col-md-7 col-sm-12 col-xs-6 form-group">
		 <?php
		 #pre($comapny_group_details);
		 if(!empty($comapny_group_details)){?>
		 
			<img src="<?php  echo base_url('assets/modules/company/uploads/'.$comapny_group_details->logo);?>">
			<?php
			} 
			?>
			</div>
		</div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
		   <label scope="row">Group Name</label>
		 <div class="col-md-7 col-sm-12 col-xs-6 form-group">
		 <?php echo  $comapny_group_details->name; ?>
		 </div>
		</div>	
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
		   <label scope="row">Email:</label>
		 <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($comapny_group_details)){ echo  $comapny_group_details->company_group_email; } ?></div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		   <label scope="row">PAN Number:</label>
		 <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($comapny_group_details)){ echo  $comapny_group_details->company_pan; } ?></div>
		</div>	
</div>						
<div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">	
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
		   <label scope="row">Employees :</label>
		 <div class="col-md-7 col-sm-12 col-xs-6 form-group">
		<?php
		 if(!empty($comapny_group_details)){
			echo $comapny_group_details->no_of_employees; } 
			?>
				 
				 </div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		   <label scope="row">Year of Establish :</label>
		 <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php
		 if(!empty($comapny_group_details)){
			echo $comapny_group_details->year_of_establish; } 
			?></div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
		   <label scope="row">Phone Number :</label>
		 <div class="col-md-7 col-sm-12 col-xs-6 form-group">
		 <?php
		 if(!empty($comapny_group_details)){
			echo $comapny_group_details->phone; } 
			?>
			</div>
		</div>
	  
</div>         					
          

		</div>
		
		
		<center><b>Bank Account Details</b></center>
		  <table id="datatable-buttons" class="table table-striped table-bordered action-icons" style="width:100%" border="1" cellpadding="3">
			<tr style="background:#ddd;">
				<th>Account Name</th>
				<th>Account Number</th>
				<th>Bank IFSC Code</th>
				<th>Bank Name</th>
				<th>Bank Branch</th>
			<tr>
		<?php
		if(!empty($comapny_group_details)){
							$bank_detail = json_decode($comapny_group_details->bank_details);
							if(!empty($bank_detail)){
									foreach($bank_detail as $dtl){
										$acc_nme = !empty($dtl->account_name)?$dtl->account_name:'';
										$acc_no = !empty($dtl->account_no)?$dtl->account_no:'';
										$acc_ifsc = !empty($dtl->account_ifsc_code)?$dtl->account_ifsc_code:'';
										$acc_bnknm = !empty($dtl->bank_name)?$dtl->bank_name:'';
										$acc_brnch = !empty($dtl->branch)?$dtl->branch:'';

											echo '<tr><td>'.$acc_nme.'</td>';
											echo '<td>'.$acc_no.'</td>';
											echo '<td>'.$acc_ifsc.'</td>';
											echo '<td>'.$acc_bnknm.'</td>';
											echo '<td>'.$acc_brnch.'</td></tr>';
									}
							}
							else{
								echo "No Data Available";
							}
		} ?>			
		</table>
	  
</div>         					
          

		</div>
		
		<center><b>Group Address Detail</b></center>
		<table id="datatable-buttons" class="table table-striped table-bordered action-icons" style="width:100%" border="1" cellpadding="3">
		<tr style="background:#ddd;">
			<th>Company group Name</th>
			<th>Address</th>
			<th>Country</th>
			<th>State</th>
			<th>City</th>
			<th>Postal/Zipcode</th>
			<th>GSTIN</th>
		<tr>
		<?php
		#pre($comapny_group_details);
		if(!empty($comapny_group_details)){
							$adress_dtl = json_decode($comapny_group_details->address);
							if(!empty($comapny_group_details->address)){
								foreach($adress_dtl as $dtl){
							$state_name = getNameById('state',$dtl->state,'state_id')->state_name;
							$city_name = getNameById('city',$dtl->city,'city_id')->city_name;
							$country_name = getNameById('country',$dtl->country,'country_id')->country_name;		
								
							echo '<tr><td>'.$dtl->compny_branch_name.'</td>';
							echo '<td>'.$dtl->address.'</td>';
							echo '<td>'.$country_name.'</td>';
							echo '<td>'.$state_name.'</td>';
							echo '<td>'.$city_name.'</td>';
							echo '<td>'.$dtl->postal_zipcode.'</td>';
							echo '<td>'.$dtl->company_gstin.'</td></tr>';
								}
					 }
					 } ?>	
				
</table>
			
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<div class="form-group">
					<div class="modal-footer">
						<button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>  
 </div>

