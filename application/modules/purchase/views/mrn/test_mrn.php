<form method="post" class="form-horizontal"  id="mrn-form"  >
	<div class="row">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Invoice No.</label>
            <div class="col-md-7 col-xs-12 rightborder">
                    <input type="text" class="form-control mrn-control" name="contact_name" required="" value="">
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Supplier Name <span class="required">*</span></label>
            <div class="col-md-7 col-xs-12 rightborder">
                    <input type="text" class="form-control mrn-control" name="contact_name" required="" value="">
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Order Date</label>
            <div class="col-md-7 col-xs-12 rightborder">
                   <input type="text" id="current_date" name="date" class="form-control mrn-control col-md-7 col-xs-12" placeholder="Display the Current Date" value="<?php if($order && !empty($order)){ echo $order->date;} ?>">
		</div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Expected delivery Date </label>
            <div class="col-md-7 col-xs-12 rightborder">
                  <input type="text" id="delivery_date" name="expected_delivery" class="form-control mrn-control col-md-7 col-xs-12 delivery_date" placeholder="10-08-2019" value="<?php if($order && !empty($order) ){ echo $order->expected_delivery;} ?>">
		</div>
    </div>
  
  </div>
  <div class="col-md-6 col-xs-12">
  <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Invoice Date </label>
            <div class="col-md-7 col-xs-12 rightborder">
                <input type="text" name="bill_date" class="form-control mrn-control col-md-7 col-xs-12 bill_datee" placeholder="10-08-2019" value="<?php if ($mrn && !empty($mrn)) {echo $mrn->bill_date;} ?>">
			</div>
    </div>
   <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Address </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <textarea class="form-control mrn-control" id="" rows="2"></textarea>
			 </div>
    </div>
	 <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Delivery Address </label>
            <div class="col-md-7 col-xs-12 rightborder">
                <textarea class="form-control mrn-control" id="" rows="2"></textarea>
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
  <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Material Type <span class="required">*</span> </label>
            <div class="col-md-7 col-xs-12 rightborder">
                 <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type">
				<option value="">Select Option</option>
				<?php
				if (!empty($mrn)) {
					$material_type_id = getNameById('material_type', $mrn->material_type_id, 'id');
					echo '<option value="' . $mrn->material_type_id . '" selected>' . $material_type_id->name . '</option>';
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
	  <th scope="col">GST%</th>
	  <th scope="col">Rcv'd Qty</th>
	  <th scope="col">Total</th>
	  <th scope="col">Defected</th>
	  <th scope="col">Def Reason</th>
	  <th scope="col"> Delete</th>
          </tr>
        </thead>
        <tbody class="test-body">
          <tr>
            <td class="pt-3-half" contenteditable="false">
			<select class="materialNameId form-control  selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND status=1" >
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
			<td class="pt-3-half defected" contenteditable>
			
			<select>
				<option value="Defected">Defected</option>
				<option value="Accepted">Accepted</option>

			</select>
			</td>
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
                    <select class="form-control mrn-control" name="payment_terms" <?php if (!empty($mrn)) echo 'readonly'; ?>>
				<option>-- Payment --</option>
				<option value="Advance" <?php if (!empty($mrn) && $mrn->payment_terms == 'Advance') { echo 'selected';} ?>>Advance </option>
				<option value="Credit" <?php if (!empty($mrn) && $mrn->payment_terms == 'Credit') {echo 'selected';} ?>>Credit </option>
				<option value="30days" <?php if (!empty($mrn) && $mrn->payment_terms == '30days') {echo 'selected';} ?>>30days </option>
				<option value="45days" <?php if (!empty($mrn) && $mrn->payment_terms == '45days') {echo 'selected';} ?>>45days </option>
				<option value="60days" <?php if (!empty($mrn) && $mrn->payment_terms == '60days') {echo 'selected';} ?>>60days </option>
				<option value="90days" <?php if (!empty($mrn) && $mrn->payment_terms == '90days') {echo 'selected';} ?>>90days </option>
				<option value="Against_PDC" <?php if (!empty($mrn) && $mrn->payment_terms == 'Against_PDC') {echo 'selected';} ?>>Against_PDC </option>
			</select>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Payment Date</label>
            <div class="col-md-7 col-xs-12 rightborder" >
            <input type="text" id="payment_date" name="payment_date" class="form-control mrn-control col-md-7 col-xs-12 delivery_date" placeholder="Payment date" value="<?php if (!empty($mrn)) { echo $mrn->payment_date; } ?>" readonly>
		</div>
    </div>
<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Choose</label>
            <div class="col-md-7 col-xs-12 rightborder">
            <p>
				FOR:
				<input type="radio" class="flat" name="terms_delivery" id="for" value="FORPrice" checked="" required <?php if (!empty($mrn) && $mrn->terms_delivery == 'FORPrice') echo 'checked';
																														else echo 'checked'; ?> />
				To be paid by customer:
				<input type="radio" class="flat" name="terms_delivery" id="exFact" value="To be paid by customer" <?php if (!empty($mrn) && $mrn->terms_delivery == 'To be paid by customer') echo 'checked'; ?> />
			</p>
			</div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" for="rating" >Ratings </label>
            <div class="col-md-7 col-xs-12 rightborder">
                <div class="star-rating">
			<?php 
				$countEmptyStar = 5-$mrn->rating;
				$i = 1;
				while($i<=$mrn->rating) {
					echo '<s class="active"></s>';
					$i++;
				}
				$j = 1;
				while($j<=$countEmptyStar) {
					echo '<s></s>';
					$j++;
				}?>
		</div>
			<!--<div class="show-result">No stars selected yet.</div>-->
			<input type="hidden" name="rating" id="hidden_rating" class="form-control col-md-7 col-xs-12" placeholder="Rating" value="">
			</div>
    </div>
  <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Comment </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <textarea class="form-control mrn-control" id="" rows="2"></textarea>
			 </div>
    </div>
  </div>
  <div class="col-md-6 col-xs-12">
   <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Terms and Conditions </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <textarea class="form-control mrn-control" id="" rows="2"></textarea>
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



<!-- /page content -->