<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/save_ncr" enctype="multipart/form-data" id="NcrDetail" novalidate="novalidate" style="">
<div class="col-md-12 col-sm-12 col-xs-12 ">				
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" >Customer Name </label>
					<div class="col-md-3 col-sm-3 col-xs-6">
    			     <?php	if(!empty($edit->cust_id)){
									$usr_nam = getNameById('account',$edit->cust_id,'id');
									echo $usr_nam->name; 
									}?>
					</div>
				</div>
					<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" >Email id </label>
					<div class="col-md-3 col-sm-3 col-xs-6">
    			     <?php	if(!empty($edit->email)){
				$email=json_decode($edit->email);
			if(!empty($email)){foreach($email as $email1){
			for($i=0;$i<count($email1);$i++){
					 echo $email1[$i].',';}}}}?>
					</div>
				</div>
				<div class="item form-group">
				 <label class="col-md-3 col-sm-3 col-xs-12" >Sale Order </label>
				 <div class="col-md-3 col-sm-3 col-xs-6">
			<?php  if(!empty($edit->saleorder_id)){
			$saleorder_nam = getNameById('sale_order',$edit->saleorder_id,'id');
		echo @$saleorder_nam->so_order;
		}?>
			 </div>
				</div>
		<div class="item form-group">
		<label class="col-md-3 col-sm-3 col-xs-12" >Products Supplied</label>
		<div class="col-md-3 col-sm-3 col-xs-6">
			  	<?php  if(!empty($edit->product_id)){
			$material_nam = getNameById('material',$edit->product_id,'id'); 
			echo $material_nam->material_name; }?>
					</div>
				</div>
<div class="item form-group">
<label class="col-md-3 col-sm-3 col-xs-12">Date of Complaint</label>
	<div class="col-md-3 col-sm-3 col-xs-6">
		<?php if(!empty($edit)){echo date('d-m-Y',strtotime($edit->complaint_date));} ?>
					</div>
				</div>
				 <div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Lot Size</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
					<?php  if(!empty($edit)){echo $edit->lot_size;} ?>
					</div>
			</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Complaints Priority</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
			           <?php if($edit->complaint_priority=='High'){echo 'High';}?>
			           <?php if($edit->complaint_priority=='Medium'){echo 'Medium';}?>
			           <?php if($edit->complaint_priority=='Low'){echo 'Low';}?>
				</div>
				</div>
				<?php if(!empty($edit->cause)){
					$val=json_decode($edit->cause,true);
				
					foreach($val as $key=>$data){
						foreach($data as $data1){?>
					<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12"><?php  if($key=='root_cause'){
						echo "Root Cause";
					}elseif($key=='corr_act'){
						echo "Corrective Action";
					}elseif($key=='prev_act'){
						echo "Preventive Action";
					}
						?></label>
					<div class="col-md-3 col-sm-3 col-xs-6">
					<?php echo $data1;?>
					</div>
				</div>						<?php } ?>
				
				
					<?php } }?>
					<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" >Problems </label>
					<div class="col-md-3 col-sm-3 col-xs-6">
    			    <?php if(!empty($edit->problem)){
				$problem=json_decode($edit->problem);
			if(!empty($problem)){foreach($problem as $problem1){
			for($i=0;$i<count($problem1);$i++){
				echo $problem1[$i].',';
					}}}}?>
					</div>
				</div>
                <div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" >Validated Status </label>
					<div class="col-md-3 col-sm-3 col-xs-6">
    			  <?php
			if($edit->approve == 1){
							echo	$validated_by = 'approve';
			}elseif($edit->disapprove == 1){
							echo	$validated_by = 'disapprove';
							}else{
							echo	$validated_by= '';
						}?>
					</div>
				</div>
                <div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" >Validated By </label>
					<div class="col-md-3 col-sm-3 col-xs-6">
    			    <?php  $validatedByName =getNameById('user_detail',$edit->validated_by,'u_id');
					 if(!empty($validatedByName)){echo $validatedByName->name;}
					?>
					</div>
				</div>
</div>
	<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
	<center>
<div class="modal-footer">
						  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
			</div>
	</center>
	</form>                      