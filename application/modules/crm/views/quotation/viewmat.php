<?php 
pre('there');
?>

<div class="table-responsive">
<div class="container mt-3">
	<div class="well pro-details" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; ; margin-top: 15px;">
	<?php if(!empty($quotation) && $quotation->product!=''){ 
					$products = json_decode($quotation->product);
				?>
				<div class="col-container mobile-view2">
			       <div class="col-md-1 col-sm-12 col-xs-12 form-group">S.No</div>
				   <div class="col-md-2 col-sm-12 col-xs-12 form-group">Product Name</div>
				   <div class="col-md-1 col-sm-12 col-xs-12 form-group">Quantity</div>
				   <div class="col-md-2 col-sm-12 col-xs-12 form-group">UOM</div>
				   <div class="col-md-1 col-sm-12 col-xs-12 form-group">Price</div>
				   <div class="col-md-1 col-sm-12 col-xs-12 form-group">GST</div>
				   <div class="col-md-2 col-sm-12 col-xs-12 form-group">Total</div> 
				   <div class="col-md-2 col-sm-12 col-xs-12 form-group">Total With GST</div> 
				   </div>
                   <?php
									$i =1;
									foreach($products as $product){
										$productDetail = getNameById('material',$product->product,'id');
										$materialName = !empty($productDetail)?$productDetail->material_name:'';
								?>
								<div class="row-padding col-container mobile-view view-page-mobile-view">
									       <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
										   <label>S.No</label>
											<div><?php echo $i; ?></div>
									
								          </div>
										  <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
										    <label>Product Name</label>
											<div><h5><?php echo $materialName ; ?></h5><?php echo (array_key_exists("description",$product)?$product->description:'') ; ?></div>
									
								          </div>
										  <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
										    <label>Quantity</label>
											<div><?php echo $product->quantity; ?></div>
									
								          </div>
										   <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
										    <label>UOM</label>
											<div><?php

														$ww =  getNameById('uom', $product->uom,'id');
														$uom = !empty($ww)?$ww->ugc_code:'';

														echo $uom;


											 ?></div>
									
								          </div>
										  <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
										    <label>Price</label>
											<div><?php echo $product->price; ?></div>
									
								          </div>
										  <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
										    <label>GST</label>
											<div><?php echo $product->gst; ?></div>
									
								          </div>
										  <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
										    <label>Total</label>
											<div><?php echo $product->total; ?></div>
									
								          </div>
										  <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
										    <label>Total With GST</label>
											<div><?php echo $product->TotalWithGst; ?></div>
									
								          </div>
										 
                                </div>										  
									
									
									
				   <?php $i++;}?>				
												   
			 </div>
			 </div>
			<div class="modal-footer">
				<input type="hidden" id="add_contactPerson_Data_onthe_spot">
				<button type="button" class=" btn btn-default" data-dismiss="modal">Close</button>
				
			</div>
	<?php } ?>


						
 
	
					
