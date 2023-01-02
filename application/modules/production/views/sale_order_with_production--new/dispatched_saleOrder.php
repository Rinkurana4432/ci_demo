<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveDispatchSaleOrder" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
		<input type="hidden" name="id" value="">
		<input type="hidden" name="sale_order_id" value="<?php if(!empty($sale_order)){ echo $sale_order->id; }?>">
		<input type="hidden" name="save_status" value="1" class="save_status">	
		<input type="hidden" name="account_id" value="<?php if(!empty($sale_order) && isset($sale_order->account_id)) echo $sale_order->account_id; ?>">	
		<input type="hidden" name="loggedUser" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">
		<div class="item form-group">
			<!-- <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product detail">Customer Details<span class="required">*</span></label>	 -->
			
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">		
		
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-2 col-xs-12" for="agt">Account Name. </label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<?php  if(!empty($sale_order) && $sale_order->account_id !=0){
							$accountData = getNameById('account',$sale_order->account_id,'id');
							if(!empty($accountData)) echo $accountData->name;
						}
					?>
			</div>
		</div>
		
		
		
		
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-2 col-xs-12" for="agt">Invoice No.<span class="required">*</span></label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="text" class="form-control has-feedback-left" name="invoice_no" id="invoice_no" required value="<?php if(!empty($sale_order) && isset($sale_order->invoice_no)) echo $sale_order->invoice_no; ?>">
			</div>
		</div>
</div>

<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">	
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-2 col-xs-12" for="agt">Transport Tel. No.<span class="required">*</span></label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="text" class="form-control has-feedback-left" name="transport_tel_no" id="transport_tel_no" required value="<?php if(!empty($sale_order) && isset($sale_order->transport_tel_no)) echo $sale_order->transport_tel_no; ?>">
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">
			<label class="col-md-3 col-sm-2 col-xs-12" for="agt">Vehicle No.<span class="required">*</span></label>
			<div class="col-md-6 col-sm-10 col-xs-12">
				<input type="text" class="form-control has-feedback-left" name="vehicle_no" id="vehicle_no" required value="<?php if(!empty($sale_order) && isset($sale_order->vehicle_no)) echo $sale_order->vehicle_no; ?>">
			</div>
		</div>
</div>		
		
	<hr>
<div class="bottom-bdr"></div>
<h3 class="Material-head">Dispatch history<hr></h3>		
		
		<?php if(!empty($sale_order_dispatch)){
			echo '<div class="col-md-12 col-sm-12 col-xs-12 item form-group">			
			<div class="col-md-12 col-sm-10 col-xs-12">';
					echo '<div class="x_content">
							<table class="table table-bordered">								
								<thead>
									<tr>
										<th>Invoice No</th>
										<th>Transport Tel No</th>
										<th>Vehicle No</th>
										<th>Material</th>
										<th>Description</th>
										<th>Quantity</th>
										<th>UOM</th>
										<th>Dispatch Date</th>
										<th>Date</th>
										<th>Comments</th>
									</tr>
								</thead>
							<tbody>';
					foreach($sale_order_dispatch as $sod){
						if($sod['product'] !=''){
							$productData = JSON_decode($sod['product']);
							if(!empty($productData)){
								#pre($productData);
								foreach($productData as $pd){

									$ww =  getNameById('uom', $pd->uom,'id');
														$uom = !empty($ww)?$ww->ugc_code:'';
									$material = getNameById('material',$pd->product,'id');
									$material_name	=	!empty($material)? $material->material_name:"";
									echo '<tr>
										<td>'.$sod["invoice_no"].'</td>
										<td>'.$sod["transport_tel_no"].'</td>
										<td>'.$sod["vehicle_no"].'</td>
										<td>'.$material_name.'</td>
										<td>'.$pd->description.'</td>
										<td>'.$pd->quantity.'</td>
										<td>'.$uom.'</td>
										<td>'.$sod['dispatch_date'].'</td>
										<td>'.$sod['created_date'].'</td>
										<td>'.$sod['comments'].'</td>
									</tr>';
								}
							
							}
						}
						
					}
					echo '</tbody>
					</table></div></div></div>';
					
			 } ?>
				
<hr>
<div class="bottom-bdr"></div>
	
<h3 class="Material-head">Material Details<hr></h3>			
			
		<div class="item form-group">
		<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<label class="col-md-3 col-sm-2 col-xs-12" for="material">Material Type <span class="required">*</span></label>
		<div class="col-md-7 col-sm-8 col-xs-12">
			
			
			<?php
				$material_type_name  = '';
				if(!empty($sale_order) && $sale_order->material_type_id !='' && $sale_order->material_type_id!=0){
					$material_type_data = getNameById('material_type',$sale_order->material_type_id,'id');
					$material_type_name = (!empty($material_type_data))? $material_type_data->name:'';
				}
				?>	
			<input type="hidden" name="material_type_id" data-id="material" width="100%" id="material" value="<?php if(!empty($sale_order)){ echo $sale_order->material_type_id;	} ?>"  >
			<input type="text" name="material_type_name" data-id="material_type" width="100%" id="material_type" readonly value="<?php  echo $material_type_name; ?>"  class="form-control col-md-7 col-xs-12">
				

			
			
			<span class="spanLeft control-label"></span>
		</div>
	</div>
	</div>					
		<div class="  form-group input_productre middle-box">	
		<?php if(empty($sale_order)){ ?>		
				<div class="well"  style="text-align: center;position: relative;padding-bottom: 20px;" id="chkIndex_1">
				<div class="item col-md-12 col-sm-12 col-xs-12 ">
					<div class="col-md-3 col-sm-12 col-xs-12 form-group">
					<label>Material Name<span class="required">*</span></label>
						<?php /*<select class="materialNameId  form-control selectAjaxOption select2 Add_mat_onthe_spot" required="required" name="product[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid = <?php echo $_SESSION['loggedInUser']->c_id; ?> AND status = 1" width="100%" onchange="getTax(event,this)" id="material" required>
						*/?>
						<select class="materialNameId  form-control selectAjaxOption select2 Add_mat_onthe_spot" required="required" name="product[]"  width="100%" onchange="getTax(event,this)" id="material" required readonly>
							<option value="">Select Option</option>
						</select>
						<input type="hidden" name="mat_idd_name" id="matrial_Iddd">	
							<input type="hidden" name="matrial_name" id="matrial_name">	  
							<input type="hidden" id="serchd_val">
					</div>
					<div class="col-md-3 col-sm-12 col-xs-12 item form-group">	
						<label>Description </label>
						<textarea name="description[]" placeholder="Description of material" class="form-control col-md-7 col-xs-12" class="description"></textarea> 
					</div>
					<div class="col-md-2 col-sm-6 col-xs-12 form-group">
					<label>QTY. </label>
						<input type="text" name="quantity[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12" class="quantity" onkeyup="poPriceCalculation(event,this)"  onchange="poPriceCalculation(event,this)">
					</div>
					<div class="col-md-2 col-sm-6 col-xs-12 form-group">
					<label>UOM</label>
						<input type="text" name="uom[]"  placeholder="uom" class="form-control col-md-7 col-xs-12" class="uom" readonly>
						
							<input type="text" name="uom1[]" placeholder="uom" class="form-control col-md-7 col-xs-12 uom1" value="" readonly>

											<input type="hidden" name="uom[]" readonly value="" class="uom">
						<?php /*<select class="form-control uom" name="uom[]" class="uom">
							<option>Select UOM</option>
							<?php 
								$measurementUnits = measurementUnits();
								foreach($measurementUnits as $mu){ 
									echo '<option value="'.$mu.'">'.$mu.'</option>';
								}
							?>
						</select> */?>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-12 form-group">
					<label>Price </label>
						<input type="text" name="price[]"  placeholder="Price" class="form-control col-md-7 col-xs-12" onkeyup="poPriceCalculation(event,this)" onchange="poPriceCalculation(event,this)">
					</div>
					<div style="display: none;">
			      <div class="col-md-1 col-sm-6 col-xs-12 form-group">
					<label>GST </label>
						<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="" placeholder="gst" readonly>
					</div>			
					<div class="col-md-2 col-sm-6 col-xs-12 form-group">
					<label>Total </label>
						<input type="text" name="individualTotal[]" class="form-control col-md-7 col-xs-12 individualTotal" value="" readonly>
					</div>	
					<div class="col-md-2 col-sm-6 col-xs-12 form-group">
					<label>GST Total </label>
						<input type="text" name="individualTotalWithGst[]" class="form-control col-md-7 col-xs-12 individualTotalWithGst" value="" readonly>
					</div>	
					</div>  	
					<div class="btn-row">
						<button class="btn edit-end-btn addProductButton" type="button" align="right" disabled><i class="fa fa-plus" ></i></button>
					</div>	
							</div>					
				</div>	
		<?php } else{ 
					$products = json_decode($sale_order->product);
					if(!empty($products)){ 
						$i =  1;
						foreach($products as $product){
						?>
							<div class="well"  id="chkIndex_<?php echo $i; ?>" style="text-align: center;position: relative;padding-bottom: 20px;">
								<div class="item col-md-3 col-sm-12 col-xs-12 form-group">
									<?php  if($i == 1){  echo '<label>	Material Name	</label>'; }  ?>	
									<?php /*<select class="form-control selectAjaxOption select2 materialNameId Add_mat_onthe_spot" required="required" name="product[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid = <?php echo $_SESSION['loggedInUser']->c_id; ?>" width="100%" onchange="getTax(event,this)" id="material" disabled="readonly" >
										<option value="">Select Option</option>
										<?php 
											if(!empty($product)){
												$material = getNameById('material',$product->product,'id');
												echo '<option value="'.$material->id.'" selected>'.$material->material_name.'</option>';
											}
										?>
									</select>*/?>
									<?php 
											if(!empty($product)){
												$material = getNameById('material',$product->product,'id');												
											}
										?>
									<input type="hidden" name="product[]" data-id="material" width="100%" id="material" value="<?php if(!empty($product)){ echo $product->product;	} ?>"  >
								 <input type="text" name="productName[]" data-id="productName" width="100%" id="productName" readonly value="<?php if(!empty($product) && !empty($material)){ echo $material->material_name;	} ?>"  class="form-control col-md-7 col-xs-12">
										
									
									
									<input type="hidden" name="mat_idd_name" id="matrial_Iddd">	
									<input type="hidden" name="matrial_name" id="matrial_name">	  
									<input type="hidden" id="serchd_val">
								</div>
								<div class="col-md-3 col-sm-12 col-xs-12 item form-group">
									<?php  if($i == 1){  echo '<label>	Description	</label>'; }  ?>	
									<textarea name="description[]" placeholder="Description of material" class="form-control col-md-7 col-xs-12" class="description"><?php echo $product->description ; ?></textarea> 
								</div>
								<div class="col-md-3 col-sm-6 col-xs-12 form-group">
								<?php  if($i == 1){  echo '<label>	Qty	</label>'; }  ?>
									<input type="text" name="quantity[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12 quantity" value="<?php echo $product->quantity ;?>" onkeyup="poPriceCalculation(event,this)" onchange="poPriceCalculation(event,this)">
								</div>
								<div class="col-md-3 col-sm-6 col-xs-12 form-group">
								<?php  if($i == 1){  echo '<label>	UOM	</label>'; }  ?>
							 <input type="text" name="uom1[]" placeholder="uom" class="form-control col-md-7 col-xs-12 uom1" value="<?php  $ww =  getNameById('uom', $product->uom,'id');
												$uom = !empty($ww)?$ww->ugc_code:'';
                                            echo $uom; ?>" readonly>

											<input type="hidden" name="uom[]" readonly value="<?php echo  $product->uom; ?>" class="uom">
								</div>
								<div style="display: none;">
								  <div class="col-md-2 col-sm-6 col-xs-12 form-group">
								<?php  if($i == 1){  echo '<label>	Price	</label>'; }  ?>
									<input type="text" name="price[]"  placeholder="Price" class="form-control col-md-7 col-xs-12" value="<?php echo $product->price ;?>" onkeyup="poPriceCalculation(event,this)" onchange="poPriceCalculation(event,this)">
								</div>  
							  	<div class="col-md-1 col-sm-6 col-xs-12 form-group">
								<?php  if($i == 1){  echo '<label>	GST	</label>'; }  ?>
									<input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="<?php echo $product->gst ;?>" placeholder="gst" readonly>
								</div>	 
								 <div class="col-md-2 col-sm-6 col-xs-12 form-group">
								<?php  if($i == 1){  echo '<label>	Total	</label>'; }  ?>
									<input type="text" name="individualTotal[]" class="form-control col-md-7 col-xs-12 individualTotal" value="<?php echo $product->individualTotal ;?>" readonly>
								</div>  
								  <div class="col-md-2 col-sm-6 col-xs-12 form-group">
								<?php  if($i == 1){  echo '<label>	GST	Total</label>'; }  ?>
									<input type="text" name="individualTotalWithGst[]" class="form-control col-md-7 col-xs-12 individualTotalWithGst" value="<?php echo $product->individualTotalWithGst ;?>" readonly>
								</div>  								
								</div>
									<?php if($i==1){
									echo '<div class="btn-row"><button class="btn edit-end-btn addProductButton" type="button" disabled>Add</button></div>';
									}else{	
									echo '<button class="btn btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button>';
									} ?>	
								
			</div>
			
<?php $i++; }}}?>
	
</div>	
<!-- <div class="col-md-12 col-sm-12 col-xs-12 form-group">
		<div class="col-md-9 col-sm-6 col-xs-12 form-group text-right">
		<input type="hidden" class="form-control has-feedback-left" name="total" id="total" value="<?php if(!empty($sale_order)) echo $sale_order->total; ?>">
			<strong>Total:</strong>&nbsp;&nbsp;<span class="divSubTotal fa fa-rupee">  <?php if(!empty($sale_order)){ echo '  '.$sale_order->total ; } else{ echo 0; }?></span>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 form-group">
			<input type="hidden" class="form-control has-feedback-left" name="grandTotal" id="grandTotal" value="  <?php if(!empty($sale_order)) echo $sale_order->grandTotal; ?>">
				<strong>Grand Total:</strong>&nbsp;<span class="divTotal fa fa-rupee">  <?php if(!empty($sale_order)){ echo '  '.$sale_order->grandTotal ; } else{ echo 0; }?></span>
			</div>
</div> -->	
<hr>
<div class="bottom-bdr"></div>
<h3 class="Material-head">Dispatch Details<hr></h3>
	<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">	
		<div class="col-md-12 col-sm-12 col-xs-12 item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" for="textarea">Dispatch Date</label>
			<div class="col-md-6 col-sm-10 col-xs-8">
			<fieldset>
				<div class="control-group">
					<div class="controls">
					  <div class="xdisplay_inputx form-group has-feedback">
						<input type="text" class="form-control has-feedback-left" id="dispatch_date"  name="dispatch_date" id="single_cal3" aria-describedby="inputSuccess2Status3" value="<?php if(!empty($sale_order) && $sale_order->dispatch_date!=''){ echo $sale_order->dispatch_date; }else {echo date("d-m-Y");}?>">
						<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
						<span id="inputSuccess2Status3" class="sr-only">(success)</span>
					  </div>
					</div>
				</div>
			</fieldset>	
            </div>			
		</div>
		
					
		
		
					   
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-4" for="dispatch_documents">Documents to submit with dispatch </label>
			<div class="col-md-6 col-sm-10 col-xs-8">
				<div class="checkbox" name="dispatch_documents">
					<?php 					
						$documentSubmitedWithDispatch = documentSubmitedWithDispatch();
						foreach($documentSubmitedWithDispatch as $dswd){ ?>
							<label><input type="checkbox" class="flat" value="<?php echo $dswd ;?>" name="dispatch_documents[]" 
							<?php
							if (!empty($sale_order)  && ($sale_order->dispatch_documents != 'null' ) && ($sale_order->dispatch_documents !=='')){
								
								if(in_array($dswd,json_decode($sale_order->dispatch_documents), TRUE)){
									echo "checked";
									}  	
							}
						?>><?php echo $dswd;?></label>
						<?php } ?>
			  </div>
			</div>
		</div>
</div>
<div class="col-md-6 col-sm-10 col-xs-8 vertical-border">		
		<div class="item form-group col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-3 col-sm-2 col-xs-4" for="comments">Comments</label>
			<div class="col-md-6 col-sm-10 col-xs-8">
				<textarea id="comments" rows="6" name="comments" class="form-control col-md-7 col-xs-12"><?php if(!empty($sale_order) && isset($sale_order->comments)) echo $sale_order->comments; ?></textarea>
			</div>
		</div>
		
			
			<?php 
				if(!empty($sale_order)){
					$disableCompleteCheck = (!empty($sale_order) && $sale_order->complete_status ==1 )?'disabled':'';
					$completeChecked = (!empty($sale_order) && $sale_order->complete_status ==1 )?'checked':'';
					echo '<div class="x_content"><label class="col-md-3 col-sm-2 col-xs-12" ></label>';
						echo '<div class="col-md-6 col-sm-10 col-xs-8">Sale Order Complete <input type="checkbox" name="sale_order_complete" id="sale_order_complete" value="" data-sale-order-id="'.$sale_order->id.'" data-loggedInUserId="'.$_SESSION['loggedInUser']->id.'" '.$disableCompleteCheck.' '. $completeChecked. '  ></div>';					
					echo '</div>';
					}else{
					echo '<p>Not Dispatched</p>';
					}?>
			
</div>				
				
				
			<div class="clearfix"></div>	
		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-12 col-xs-12">
			    <center>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="reset" class="btn btn-default">Reset</button>
				<?php if((!empty($sale_order) && $sale_order->save_status !=1) || empty($sale_order)){
						echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
					}?> 
				<input type="submit" class="btn edit-end-btn" value="Submit">
				</center>
			</div>
		</div>
	</form>	


