<div class="box-div ">
<div class="container">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="item form-group col-md-12">
<label class="label_text col-md-12 col-sm-12 col-xs-12">Reserve / Unreserve Material</label><br>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="reserve_unreserve_material">
<input type="hidden" class="material_type" value="<?php echo $mat_data['material_type']; ?>">
<input type="hidden" class="material_id" value="<?php echo $mat_data['material_id']; ?>">
<input type="hidden" class="work_order_id" value="<?php echo $mat_data['work_order_id']; ?>">
<input type="hidden" class="job_card_id" value="<?php echo $mat_data['job_card_id']; ?>">
<input type="hidden" class="sale_order_product_id" value="<?php echo $mat_data['sale_order_product_id']; ?>">	
<input type="hidden" class="quantity_required" value="<?php echo $mat_data['quantity_required']; ?>">
<input type="hidden" class="available_quantity" value="<?php echo $mat_data['available_quantity']; ?>">
<input type="hidden" class="reserved_quantity" value="<?php echo $mat_data['reserved_quantity']; ?>">
<input type="hidden" class="mat_action" value="">
<input  onkeypress='validate_reun(event)' style="width: 100%; padding: 10px 10px 10px 10px; margin: 10px 0px 10px 0px;" type="text" class="reserve_unreserve_quantity" value="" placeholder="Enter Quantity Here">
<button style="padding: 2%; margin-top:2%;" type="button" class="btn btn-view btn-xs __reservedQuantity">Reserve / Unreserve</button>
</div>
</div>
</div>
</div>
</div>
</div>