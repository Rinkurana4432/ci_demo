<div class="x_content">
<div role="tabpanel" data-example-id="togglable-tabs">			
<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">				
<li role="presentation" class="active "><a href="#open" role="tab" data-select="open" data-toggle="tab" id="open_tab" aria-expanded="true">Complaint Details</a></li>	
<?php if(!empty($edit)){?>			
<li role="presentation" class="close_complaint"><a href="#close" id="close_tab" role="tab" data-select="close" data-toggle="tab" aria-expanded="false">Quality Details</a></li>
<?php } ?>	
</ul>
<div id="myTabContent" class="tab-content"> 
<div role="tabpanel" class="tab-pane fade active in" id="open" aria-labelledby="open_tab">
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/save_ncr" enctype="multipart/form-data" id="NcrDetail" novalidate="novalidate" style="">
<input type="hidden" name="id" value="<?php if(!empty( $edit)){echo $edit->id;}?>">
<div class="col-md-12 col-sm-12 col-xs-12 ">				
				<div class="item form-group ">
							<label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Customer Name<span class="required">*</span></label>
							<div class="col-md-3 col-sm-12 col-xs-12">
								<select class="customerName selectAjaxOption select2" name="cust_id" data-id="account" data-key="id" data-fieldname="name" data-where="account_owner = <?php echo $this->companyGroupId; ?> AND save_status = 1" width="100%" id="account_id" onchange="get_saleorder();get_email();" required="required">
									<option value="">Select Option</option>
								<?php	if(!empty($edit->cust_id)){
									$usr_nam = getNameById('account',$edit->cust_id,'id');?>
									<option value="<?php echo $edit->cust_id;?>" selected>
									<?php echo $usr_nam->name; ?>
									</option>
								<?php }?>
								</select>
							</div>
		</div>
				<div class="col-md-12 col-sm-12 col-xs-12 ">				
	 <div class="item form-group">
		<label class="col-md-3 col-sm-3 col-xs-12">Email Id</label>
			<div class="col-md-3 col-sm-3 col-xs-6">
			<?php if(!empty($edit->email)){
				$email=json_decode($edit->email);
			if(!empty($email)){foreach($email as $email1){
			for($i=0;$i<count($email1);$i++){?>
			   <input type="email" class="form-control" id="email_id" name="email[]" value="<?php echo $email1[$i]; ?>" required> 
               <?php }}}}else{?>
               <input type="text" class="form-control " id="email_id" name="email[]" value="" required>    		<?php }?>
            </div>
		  <button class="btn field_button_email" type="button"><i class="fa fa-plus"></i></button>	
	</div>
    </div>
    	<div class="item form-group fields_wrap_email"></div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" >Sale Order <span class="required">*</span>
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
                    
			  <select id="custsaleorder" class="form-control selectAjaxOption select2"  data-id="saleorder" data-key="id" data-fieldname="name"name="saleorder_id" onchange="get_saleorder_products();">			<?php  if(!empty($edit->saleorder_id)){			$saleorder_nam = getNameById('sale_order',$edit->saleorder_id,'id');?> 			<option value="<?php echo $edit->saleorder_id ?>"><?php echo $saleorder_nam->so_order;?></option><?php }?>			  </select>	
              
   
   				</div>
				</div>		<div class="item form-group">		<label class="col-md-3 col-sm-3 col-xs-12" >Products Supplied<span class="required">*</span>				</label>		<div class="col-md-3 col-sm-3 col-xs-6">
			  <select id="custsaleorderproducts" class="form-control" name="product_id">			  	<?php  if(!empty($edit->product_id)){			$material_nam = getNameById('material',$edit->product_id,'id');?> 			<option value="<?php echo $edit->product_id ?>"><?php echo $material_nam->material_name;?></option><?php }?>			  </select>
					</div>
				</div>
                
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Date of Complaint</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						   <input type="date" class="form-control " name="complaint_date" value="<?php if(!empty($edit)){echo $edit->complaint_date;} ?>">
						</div>
				</div>
				 <div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Lot Size</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						   <input type="text" class="form-control " name="lot_size" value="<?php if(!empty($edit)){echo $edit->lot_size; }?>">
						</div>
				</div>
					<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">Complaints Priority<span class="required">*</span>
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
			         <select class="form-control" name="complaint_priority">
			             <option value="High"  <?php if(!empty($edit)){if($edit->complaint_priority=='High'){echo 'Selected';}}?>>High</option>
			             <option value="Medium"  <?php if(!empty($edit)){if($edit->complaint_priority=='Medium'){echo 'Selected';}}?>>Medium</option>
			             <option value="Low"  <?php if(!empty($edit)){if($edit->complaint_priority=='Low'){echo 'Selected';}}?>>Low</option>
			         </select>
					</div>
				</div>
                			<div class="col-md-12 col-sm-12 col-xs-12 ">				
	 <div class="item form-group">
		<label class="col-md-3 col-sm-3 col-xs-12">Problem</label>
			<div class="col-md-3 col-sm-3 col-xs-6">
            	<?php if(!empty($edit->problem)){
				$problem=json_decode($edit->problem);
			if(!empty($problem)){foreach($problem as $problem1){
			for($i=0;$i<count($problem1);$i++){?>
			   <input type="text" class="form-control " name="problem[]" value="<?php echo $problem1[$i]; ?>" required> 
               <?php }}}}else{?>
               <input type="text" class="form-control " name="problem[]" value=" " required>    
               <?php }?>
			</div>
		  <button class="btn field_button_prob" type="button"><i class="fa fa-plus"></i></button>	
	</div>
</div>

	<div class="item form-group fields_wrap_prob"></div>
	<center>
	    
	    	<div class="modal-footer">
						  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
						  <input type="submit" class="btn btn edit-end-btn " value="Submit">
						</div>
	</center>

</div>
	</form>
</div>
<div role="tabpanel" class="tab-pane fade" id="close" aria-labelledby="close_tab">
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/update_ncr" enctype="multipart/form-data" id="NcrDetail" novalidate="novalidate" style="">
<input type="hidden" name="id" value="<?php echo $_POST['id'];?>">
<div class="col-md-12 col-sm-12 col-xs-12 ">
<?php if(!empty($edit->cause)){
					$val=json_decode($edit->cause,true);
				
					foreach($val as $key=>$data){
						foreach($data as $data1){?>
					<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12">
					<?php  if($key=='root_cause'){
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
				
				
					<?php } }else {?>				
	 <div class="item form-group">
		<label class="col-md-3 col-sm-3 col-xs-12">Root Cause<span class="required">*</span></label>
			<div class="col-md-3 col-sm-3 col-xs-6">
			   <input type="text" class="form-control " name="root_cause[]" required> 
			</div>
		  <button class="btn field_buttondd" type="button"><i class="fa fa-plus"></i></button>	
	</div>
	<div class="item form-group fields_wrapdd"></div>
		 <div class="item form-group">
		<label class="col-md-3 col-sm-3 col-xs-12">Corrective Action</label>
			<div class="col-md-3 col-sm-3 col-xs-6">
			   <input type="text" class="form-control " name="corr_act[]">
			</div>
		<button class="btn field_button_corr" type="button"><i class="fa fa-plus"></i></button>	 
	</div>
	<div class="item form-group fields_wrap_corr"></div>
		 <div class="item form-group">
		<label class="col-md-3 col-sm-3 col-xs-12">Preventive Action</label>
			<div class="col-md-3 col-sm-3 col-xs-6">
			   <input type="text" class="form-control " name="prev_act[]" >
			 </div> 
			<button class="btn field_button_prev" type="button"><i class="fa fa-plus"></i></button>
	</div>
	<div class="item form-group fields_wrap_prev"></div>
					<?php }?>
</div>
	<center>	  
	    <div class="modal-footer">
		  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
		  <input type="submit" class="btn btn edit-end-btn " value="Submit">
		</div>
	</center>
	</form>                       
</div>
</div>
</div>
</div>
</div>
                        