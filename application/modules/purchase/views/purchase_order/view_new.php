	<div class="row">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Purchase Order No.</label>
            <div class="col-md-7 col-xs-12 rightborder">
                 <p> 	<?php 	$purchaseIndentData=getNameById('purchase_indent',$orders->pi_id,'id');
							if(!empty($purchaseIndentData)){ 
								echo $purchaseIndentData->indent_code; 
							}						
					 ?></p>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Supplier Name <span class="required">*</span></label>
	   <?php if (!empty($suppliername)) {
					$orders->supplier_name;
					$supplier_name = getNameById('supplier', $orders->supplier_name, 'id');
				}
				?>
            <div class="col-md-7 col-xs-12 rightborder">
                 <p><?php if ($supplier_name == null) {
						echo "N/A";
					} else {
						echo $supplier_name->name;
					}  ?></p>
            </div>
    </div>
	

  
  </div>
  <div class="col-md-6 col-xs-12">
<input type="hidden" value="" id="party_billing_state_id">
		<input type="hidden" value="<?php if(!empty($order)){ echo $supplier_name_id->state; } ?>" id="sale_company_state_id">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Address</label>
            <div class="col-md-7 col-xs-12 rightborder">
                <p> <?php if ($supplier_name == null) {
						echo "N/A";
					} else {
						echo $supplier_name->address;
					}  ?></p>
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
	   <?php if (!empty($materialType)) {
					$orders->material_type_id;
					$material_type = getNameById('material_type', $orders->material_type_id, 'id')->name;
				}
				?>
            <div class="col-md-8 rightborder">
                  <p><?php echo $material_type; ?></p>
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
	  
          </tr>
        </thead>
        <tbody class="test-body">
          <tr>
            <td class="pt-3-half" contenteditable="false">
			
			</td>
            <td class="pt-3-half" ></td>
            <td class="pt-3-half only-numbers" ></td>
            <td class="pt-3-half"></td>
			<td class="pt-3-half only-numbers" ></td>
            <td class="pt-3-half only-numbers"></td>
            <td class="pt-3-half only-numbers"></td>
            <td class="pt-3-half only-numbers"></td>
            <td class="pt-3-half"></td>
            
          </tr>
        </tbody>
      </table>
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
               <p><?php if (!empty($orders)) {
						echo $orders->payment_terms;
					} ?></p>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Delivery Address</label>
	  <?php if (!empty($orders)) {
					$deliveryAddress = $orders->delivery_address;
					//$deliveryAddress = getNameById('company_detail',$orders->delivery_address,'id');
				}
				?>
            <div class="col-md-7 col-xs-12 rightborder" >
           <p> <?php echo $deliveryAddress; ?></p>
		</div>
    </div>
<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Payment Date</label>
            <div class="col-md-7 col-xs-12 rightborder">
            <p><?php if (!empty($orders) && $orders->payment_date != '') {
						echo date("j F , Y", strtotime($orders->payment_date));
					} ?></p>
			</div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" for="rating" >Expected delivery date </label>
            <div class="col-md-7 col-xs-12 rightborder">
                <p><?php if (!empty($orders)) {
						echo date("j F , Y", strtotime($orders->expected_delivery));
					} ?></p>
			</div>
    </div>
  <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Order Date </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <p><?php if (!empty($orders)) {
						echo date("j F , Y", strtotime($orders->date));
					} ?></p>
			 </div>
    </div>
  </div>
  <div class="col-md-6 col-xs-12">
   <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Choose </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <p>
				<?php if (!empty($orders)) {
						echo $orders->freight;
					} ?>
			</p>
			 </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Terms and conditions </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <p><?php if (!empty($orders)) {
						echo $orders->terms_conditions;
					} ?></p>
			 </div>
    </div>
		<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Terms Of Delivery </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <p><?php if (!empty($orders)) {
						echo $orders->terms_delivery;
					} ?></td>
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
<center>
	<button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
	<?php if ((!empty(orders) && $orders->save_status == 1) || empty($orders)) { ?>
		<a href="<?php echo base_url(); ?>purchase/create_pdf/<?php echo $orders->id; ?>" target="_blank"><button class="btn edit-end-btn">Generate PDF</button></a>
	<?php } ?>
</center>