	<?php error_reporting(0);?>
    				<div class="tab-pane" id="detail" >
						<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>bid_management/save_competitor_result" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
							<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
							<input type="hidden" name="id" id="id" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->id; ?>">	
							<input type="hidden" name="save_status" value="1" class="save_status">	
                            <div class="col-md-6 col-sm-12 col-xs-12">	
				<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12">Result</label>			
				<div class="col-md-12 col-sm-12 col-xs-12">
					<textarea rows="4" cols="80" name="result1">
                   <?php if(!empty($register_opportunity)) echo $register_opportunity->result; ?>
                    </textarea>
				</div>						
		</div>
        	<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12">Attachment</label>			
				<div class="col-md-8 col-sm-12 col-xs-12">
               <input type="file" name="attachment" value=""/>
                <input type="hidden" name="attach" value="<?php if(!empty($register_opportunity)) echo $register_opportunity->attachment; ?>"/>
				</div>		
			<?php	$ext = pathinfo($register_opportunity->attachment, PATHINFO_EXTENSION);
			if($ext=='jpg'||$ext=='png'||$ext=='JPG'||$ext=='PNG')
			{
			 if(!empty($register_opportunity)) echo $register_opportunity->attachment;?>
			<a href="https://busybanda.com/assets/modules/bid_management/uploads/<?php if(!empty($register_opportunity))echo $register_opportunity->attachment;?>" target="_blank"><img style="height:50px;" 
				src="https://busybanda.com/assets/modules/bid_management/uploads/<?php if(!empty($register_opportunity))echo $register_opportunity->attachment;?>" alt="image" class="img-responsive">	</a>
			<?php }else {if(!empty($register_opportunity)) echo $register_opportunity->attachment;?>
			<a href="https://busybanda.com/assets/modules/bid_management/uploads/<?php if(!empty($register_opportunity))echo $register_opportunity->attachment;?>" target="_blank"><img style="height:50px;" 
				src="https://busybanda.com/assets/modules/bid_management/uploads/download.png" alt="image" class="img-responsive">	</a>
			<?php	} ?>
				
                		
		</div>
		</div>				
	 <div class="add_competitor input_holder1 ">
     <div class="main_div">
	  <div class="col-sm-12"><button class="btn edit-end-btn  addcomp" type="button" style="float:right">Add</button></div>
       <?php
            if(!empty($register_opportunity)){
					 $comp=json_decode($register_opportunity->bid_comp_price_info,true);
					// pre($comp['result']);
					 if(!empty($comp)){				
						foreach($comp as $val){
							$comp_product = json_decode($val['comp_product'],true);
						
		   ?>
	 <h3 class="Material-head" style="margin-bottom: 30px;">
      Competitor Price Information
      <hr>
   </h3>
     	 
   <div class="required item form-group col-md-12 col-sm-12 col-xs-12">
         <label class="required col-md-3 col-sm-12 col-xs-12" for="account_id">Competitor Name </label>
         <div class="required col-md-6 col-sm-12 col-xs-12">
          
           <select class="itemName form-control selectAjaxOption select2" id="account_id" name="account_id[]" data-id="bid_competitor_details" data-key="id" data-fieldname="name" onchange="getProductDetails()"  data-where="account_owner = <?php echo $this->companyGroupId ; ?> AND save_status = 1" width="100%" disabled="disabled">
  				<?php $comp_name=$this->bid_management_model->get_data_byId('bid_competitor_details', 'id', $val['account_id']);
     echo '<option value="'.$val['account_id'].'" selected>'.$comp_name->name.'</option>';
			 ?>
              </select>
         </div>
      </div>
<div class="item form-group col-md-12 col-sm-12 col-xs-12">
<label class="required col-md-3 col-sm-12 col-xs-12" for="result">Result</label>
<div class="col-md-8 col-sm-12 col-xs-12">
<textarea class="form-control" rows="4" cols="60" name="result[]"><?php echo $val['result'];?></textarea>
</div>
</div>
   <!-- <div class="ln_solid"></div> -->
   <h3 class="Material-head">
      Product Details
      <hr>
   </h3>
   <div class="item form-group ">
      <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
         <div class="item form-group">
            <div class="col-md-12  input_holder2 middle-box">
              <div class="well1 welldata" id="chkIndex_1" style="overflow:auto; ">
           	   <?php if(isset($comp_product)){
				   for($i=0;$i<count($comp_product);$i++){
					// echo $val['account_id']; ?>
<div class="well scend-tr mobile-view">
<div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material Name</label>
<select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[<?php echo $val['account_id']?>][<?php echo $i?>]">
	<option value="">Select Option</option>
		<?php
			$materialName = getNameById('material',$comp_product[$i]['material_name'],'id');
		echo '<option value="'.$comp_product[$i]['material_name'].'" selected>'.$materialName->material_name.'</option>';
		?>
	</select> 	
</div>

<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label><input id="qty" class="form-control col-md-7 col-xs-12" name="disc[<?php echo $val['account_id']?>][<?php echo $i?>]" placeholder="Disc" required="required" type="text" value="<?php echo $comp_product[$i]['disc'];?>"></div>

<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>UOM</label>
<input type="text" name="uom_value1[<?php echo $val['account_id']?>][<?php echo $i?>]" class="form-control col-md-7 col-xs-12" value="<?php echo $comp_product[$i]['qty'];?>" readonly>
</div>
<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Price</label>
<input type="text" name="price[<?php echo $val['account_id']?>][<?php echo $i?>]" class="form-control col-md-7 col-xs-12 " placeholder="Price" value="<?php echo $comp_product[$i]['price'];?>">
</div>
</div>
				   <?php }}?> 
         </div>
      </div>
   </div> 
   </div>
   </div>
		<?php }}}?>				
</div>
		</div>				
							<!--<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="grandtotal">Grand Total</label>
								<div class="col-md-10 col-sm-10 col-xs-12">
									<input type="text" id="grand_total" name="grand_total" required="required" class="form-control col-md-7 col-xs-12"  value="<?php //if(!empty($lead)) echo $lead->grand_total; ?>"> 
								</div>
							</div>-->
							<div class="ln_solid"></div>
							<div class="form-group">
								<div class="col-md-12">
								<center>
									<button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
									<button type="reset" class="btn btn-default">Reset</button>
									<?php if((!empty($register_opportunity) && $register_opportunity->save_status !=1) || empty($register_opportunity)){
										echo '<input type="submit" class="btn add_users_dataaa draftBtn" value="Save as draft">'; 
									}?> 
									<input type="submit" class="btn edit-end-btn" value="Submit">
									</center>
								</div>
							</div>
						</form>	
							</div>
