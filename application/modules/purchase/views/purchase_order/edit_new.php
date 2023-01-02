<?php
$last_id = getLastTableId('purchase_order');
$rId = $last_id + 1;
$poCode = 'PUR_' . rand(1, 1000000) . '_' . $rId;
/************** Revised Purchase order generation ******************/
$currentRevisedPOChar = 'A';
$nextRevisedPOChar = chr(ord($currentRevisedPOChar) + 1); 
$revisedPOCode = '';
if ($order && $order->save_status ==1) {
	$po_code_array = explode('_', $order->order_code, 4);	
	if($po_code_array[3] == ''){
		$currentRevisedPOChar = 'A';
		#$nextRevisedPOChar = chr(ord($currentRevisedPOChar) + 1); 
		$revisedPOCode = $order->order_code.'_'.$currentRevisedPOChar.'(Revised)';
	}else if($po_code_array[3] != ''){
		#echo $po_code_array[2];
		$orignalOrderCode = $po_code_array[0].'_'.$po_code_array[1].'_'.$po_code_array[2];
		$currentRevisedPOChar = explode('(', $po_code_array[3], 2);
		$nextRevisedPOChar = chr(ord($currentRevisedPOChar[0]) + 1); 
		$revisedPOCode = $orignalOrderCode.'_'.$nextRevisedPOChar.'(Revised)';
	}	
} 
/************** /Revised Purchase order generation ******************/

?>

<form method="post" class="form-horizontal" id="purchaseIndentForm" action="<?php echo base_url(); ?>purchase/saveOrder" enctype="multipart/form-data" novalidate="novalidate">
	<div class="row">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Purchase Order No.</label>
            <div class="col-md-7 col-xs-12 rightborder">
                  <input id="Purchase_code" class="form-control mrn-control" name="order_code" placeholder="ABC239894"  type="text" value="<?php if($order && (!empty($order))){ echo $order->order_code;} else { echo $poCode; } ?>" readonly>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Supplier Name <span class="required">*</span></label>
            <div class="col-md-7 col-xs-12 rightborder">
                    <select class="supplierName form-control mrn-control selectAjaxOption select2 " id="supplier_name" required="required" name="supplier_name" data-id="supplier" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onchange="getSupplierAddress(event,this)">
				<option value="">Select Supplier</option>
				<?php
				if (!empty($order)) {
					$supplier_name_id = getNameById('supplier', $order->supplier_name, 'id');
					echo '<option value="' . $order->supplier_name . '" selected  data-id="' . $supplier_name_id->address . '">' . $supplier_name_id->name . '</option>';
				}
				?>
			</select>
            </div>
    </div>
	

  
  </div>
  <div class="col-md-6 col-xs-12">
<input type="hidden" value="" id="party_billing_state_id">
		<input type="hidden" value="<?php if(!empty($order)){ echo $supplier_name_id->state; } ?>" id="sale_company_state_id">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Address</label>
            <div class="col-md-7 col-xs-12 rightborder">
                 <textarea id="address" name="address" class="form-control mrn-control requrid_class" placeholder="Display when supplier is selected from above"><?php if ($order && !empty($order) && !empty($order)) {$supplier_name_id = getNameById('supplier', $order->supplier_name, 'id');
			echo $supplier_name_id->address;} ?></textarea>
			<span class="spanLeft control-label"></span>
		</div>
    </div>
  </div>
  
</div>

<!-- Editable table -->
<div class="card">
   <ul class="nav nav-tabs">
    <li class="active"><a href="#">Material Detail</a></li>
 </ul>
  <br>
  <div class="row M-type">
       <label class="col-md-3 col-form-label" >Material Type <span class="required">*</span></label>
            <div class="col-md-8 rightborder">
                  <select class="form-control mrn-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
				<option value="">Select Option</option>
				<?php
				if (!empty($order)) {
					$material_type_id = getNameById('material_type', $order->material_type_id, 'id');
					echo '<option value="' . $order->material_type_id . '" selected>' . $material_type_id->name . '</option>';
				}
				?>
			</select>
            </div>
    </div>
  <div class="card-body">
    <div id="table_edit" class="table-editable">
      
	  <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
         <th scope="col">Item<span class="required">*</span></th>
      <th scope="col">Description</th>
      <th scope="col">Quantity</th>
      <th scope="col">UOM</th>
	  <th scope="col">Price</th>
	  <th scope="col">Sub Total</th>
	  <th scope="col">GST%</th>
	  <th scope="col">Sub Tax</th>
	  <th scope="col">Total</th>
	   <th scope="col">Delete</th>
          </tr>
        </thead>
        <tbody class="test-body">
          <tr>
            <td class="pt-3-half" contenteditable="false">
			<select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)">
											<option value="">Select Option</option>
										</select>
			</td>
            <td class="pt-3-half" contenteditable></td>
            <td class="pt-3-half only-numbers" contenteditable></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
			<td class="pt-3-half only-numbers" contenteditable></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
            <td class="pt-3-half only-numbers" contenteditable></td>
            <td class="pt-3-half only-numbers" contenteditable></td>
            <td class="pt-3-half" contenteditable="true"></td>
            <td>
              <span class="table-remove">
			  <a href="#!"  class="btn btn-delete btn-lg" >
			  <i class="fa fa-trash"></i></a>
			</span>
            </td>
          </tr>
        </tbody>
      </table>
	  </div>
	  <div class="table_add float-right mb-3 mr-2"><a href="#!" class="text-success">
	   <!---- <i class="fa fa-plus fa-2x" aria-hidden="true"></i>--------->
	   <p class="additem"> Add Item&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
	   <span id='add-row'> Add Charges</span>
	  </a>
	  </div>
	 
	  <div class="box">
	  </div>
    </div>
  </div>
</div>
<!-- Editable table -->
<div class="row payment-bottom">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Payment Mode</label>
            <div class="col-md-7 col-xs-12 rightborder ">
                <select class="form-control mrn-control" name="payment_terms">
				<option>-- Payment --</option>
				<option value="Advance" <?php if(!empty($order) && $order->payment_terms == 'Advance'){ echo 'selected'; } ?>>Advance
				</option>
				<option value="Credit" <?php if(!empty($order) && $order->payment_terms == 'Credit'){ echo 'selected'; } ?>>Credit </option>
				<option value="30days" <?php if(!empty($order) && $order->payment_terms == '30days'){ echo 'selected'; } ?>>30days </option>
				<option value="45days" <?php if(!empty($order) && $order->payment_terms == '45days'){ echo 'selected'; } ?>>45days </option>
				<option value="60days" <?php if(!empty($order) && $order->payment_terms == '60days'){ echo 'selected'; } ?>>60days </option>
				<option value="90days" <?php if(!empty($order) && $order->payment_terms == '90days'){ echo 'selected'; } ?>>90days </option>
				<option value="Against_PDC" <?php if(!empty($order) && $order->payment_terms == 'Against_PDC'){ echo 'selected'; } ?>>Against_PDC </option>

			</select>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Delivery Address</label>
            <div class="col-md-7 col-xs-12 rightborder pdd-bottom" >
            <select class="form-control  mrn-control address get_state_id" name="delivery_address" onchange="getAddress(event,this)" id="address">
				<option value="">Select Option</option>
				<?php if(!empty($order)){
									echo '<option value="'.$order->delivery_address.'">'.$order->delivery_address.'</option>';
								   
									}
								?>	
			</select>
		</div>
    </div>
<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Payment Date</label>
            <div class="col-md-7 col-xs-12 rightborder">
            <input type="text" id="delivery_date" name="payment_date" class="form-control mrn-control delivery_date" placeholder="Payment date" value="<?php if(!empty($order)) echo $order->payment_date;?>">
			</div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" for="rating" >Expected delivery date </label>
            <div class="col-md-7 col-xs-12 rightborder">
                <input type="text" id="delivery_date" name="expected_delivery" class="form-control mrn-control delivery_date" placeholder="Expected Delivery" value="<?php if($order && !empty($order) ){ echo $order->expected_delivery;} ?>">
			</div>
    </div>
  <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Order Date </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <input type="text" id="current_date" name="date" class="form-control mrn-control" placeholder="Display the Current Date" value="<?php if($order && !empty($order)){ echo $order->date;} ?>">
			 </div>
    </div>
  </div>
  <div class="col-md-6 col-xs-12">
   <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Choose </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <p>
				FOR:
				<input type="radio" class="flat" name="terms_delivery" id="for" value="FORPrice" checked <?php if(!empty($order) && $order->terms_delivery == 'FORPrice'){ echo 'selected'; } ?> required />
				EX-To be paid by customer:
				<input type="radio" class="flat" name="terms_delivery" id="exFact" value="To be paid by customer" <?php if(!empty($order) && $order->terms_delivery == 'To be paid by customer'){ echo 'checked'; } ?>/>
			</p>
			 </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Terms and conditions </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <textarea id="tnc" name="terms_conditions" class="form-control mrn-control" placeholder="Terms And conditons"><?php if($order && !empty($order)){ echo $order->terms_conditions;} ?></textarea>
			 </div>
    </div>

  </div>
</div>
<div class="bottom-form">
<p>&nbsp; &nbsp;Frieght:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<span>0.00<i class="fa fa-inr" aria-hidden="true"></i></span></p>
<p>&nbsp; &nbsp;Other Charges:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<span>50.00<i class="fa fa-inr" aria-hidden="true"></i></span></p>
<h3><span>&nbsp; &nbsp;Grand Total:&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</span><span>5000.00<i class="fa fa-inr" aria-hidden="true"></i></span></h3>
</div>
<div class="clearfix"></div>
  <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-12 sub-btns">
                        
							
                            
							<a class="btn btn-default " onclick="location.href='<?php echo base_url();?>purchase/suppliers'">Close</a>
							<button type="reset" class="btn edit-end-btn ">Reset</button>
							<?php if((!empty($suppliers) && $suppliers->save_status == 0) || empty($suppliers)){
								echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">';
							} ?>
							<input type="submit" class="btn edit-end-btn " value="submit">
                    </div>
                </div>	

</form>
<!------------------------------------------------------------------------------Add quick material code------------------------------------------------------------------->
<div class="modal left fade" id="myModal_Add_matrial_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Add Material Details</h4>
				<span id="mssg34"></span>
			</div>
			<form name="insert_party_data" name="ins" id="insert_Matrial_data_id">
				<div class="modal-body">
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Material Name <span class="required">*</span></label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="material_name" name="material_name" required="required" class="form-control col-md-7 col-xs-12" value="">
							<span class="spanLeft control-label"></span>
						</div>
					</div>				
					<input type="hidden" name="material_type_id" id="material_type_id" class="form-control" value="">
					<input type="hidden" name="prefix" id="prefix">
					<span class="spanLeft control-label"></span>
					
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-2 col-sm-2 col-xs-4" for="email">HSN Code </label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="hsn_code" name="hsn_code" class="form-control col-md-7 col-xs-12" value="">
							<span class="spanLeft control-label"></span>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-2 col-sm-2 col-xs-4" for="email">UOM</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<select name="uom" id="uom_id" class="form-control col-md-1">
								<option value="">Select</option>
								<?php
								$uom = getUom();
								foreach ($uom as $unit) {
									?>
									<option value="<?php echo $unit; ?>"><?php echo $unit; ?></option>
								<?php
								}
								?>
							</select>
							<span class="spanLeft control-label"></span>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">Specification</label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						
							<textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification"></textarea>
							<span class="spanLeft control-label"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="add_matrial_Data_onthe_spot">
					<button type="button" class="btn btn-default close_sec_model">Close</button>
					<button id="Add_matrial_details_on_button_click" type="button" class="btn edit-end-btn">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal left fade" id="myModal_Add_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Add Supplier</h4>
				<span id="mssg"></span>
			</div>
			<form name="insert_supplier_data" name="ins" id="insert_supplier_data_id">
				<div class="modal-body">

					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Supplier Name <span class="required">*</span></label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="suppliername" name="name" required="required" class="form-control col-md-7 col-xs-12" value="" placeholder="Supplier Name ">

							<span class="spanLeft control-label"></span>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Account Group<span class="required">*</span></label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible acc_group_id" required name="supp_account_group_id" data-id="account_group" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true"></select>
							<span id="acc_grp_id"></span>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">GSTIN <span class="required">*</span></label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<input type="text" id="suppgstin" name="gstin" class="form-control col-md-7 col-xs-12" value="" required placeholder="GSTIN">
							<span class="spanLeft control-label"></span>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">Country <span class="required">*</span></label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" id='cntry' required name="country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this)"></select>
							<span id="contry"></span>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">State<span class="required">*</span></label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible state_id" name="state" required width="100%" tabindex="-1" aria-hidden="true" onchange="getCity(event,this)"></select>
							<span id="state1"></span>
						</div>
					</div>
					<div class="item form-group col-md-12 col-sm-12 col-xs-12">
						<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">City<span class="required">*</span></label>
						<div class="col-md-10 col-sm-10 col-xs-8 form-group">
							<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible city_id" name="city" required width="100%" tabindex="-1" aria-hidden="true"></select>
							<span id="city1"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default close_sec_model">Close</button>

					<button id="add_suplier_btn_id" type="button" class="btn edit-end-btn">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>