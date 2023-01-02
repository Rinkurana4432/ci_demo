<div>
<?php //pre($mrnView); ?>
	<div class="row">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Invoice No.</label>
            <div class="col-md-7 col-xs-12 rightborder">
				<p><?php if ($mrnView && !empty($mrnView)) {echo $mrnView->bill_no;} ?></p>
                    <!--<P>0002917-IN</P>----->
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Supplier Name <span class="required">*</span></label>
            <div class="col-md-7 col-xs-12 rightborder">
			<?php if(!empty($suppliername)){										   
					$mrnView->supplier_name;										   
					$supplier_name=getNameById('supplier',$mrnView->supplier_name,'id');										  
					}									   
				?>	
                    <P><?php if($supplier_name == null){echo "N/A";}else {echo $supplier_name->name;  }  ?></P>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Order Date</label>
            <div class="col-md-7 col-xs-12 rightborder">
                   <p><?php if(!empty($mrnView)){ echo date("j F , Y", strtotime($mrnView->date)); } ?></p>
		</div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Expected delivery Date </label>
            <div class="col-md-7 col-xs-12 rightborder">
                  <p><?php if(!empty($mrnView)){ echo date("j F , Y", strtotime($mrnView->expected_delivery)); } ?></p>
		</div>
    </div>
  
  </div>
  <div class="col-md-6 col-xs-12">
  <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Invoice Date </label>
            <div class="col-md-7 col-xs-12 rightborder">
                <p><?php if(!empty($mrnView) && $mrnView->bill_date!=''){ echo date("j F , Y", strtotime($mrnView->bill_date)); } ?></P>
			</div>
    </div>
   <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Address </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <p><?php if($supplier_name == null){echo "N/A";}else {echo $supplier_name->address;  }  ?></p>
			 </div>
    </div>
	 <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Delivery Address </label>
	   <?php if(!empty($mrnView)){							
					$deliveryAddress = $mrnView->delivery_address;							
					//$deliveryAddress = getNameById('company_detail',$mrnView->delivery_address,'id');
					}
				?>
            <div class="col-md-7 col-xs-12 rightborder">
                <?php  echo $deliveryAddress; ?>
			 </div>
    </div>
  </div>
</div>
<!--  table -->
<div class="card">
   <ul class="nav nav-tabs">
    <li class="active"><a href="#">Material Detail</a></li>
 </ul>
  <br>
    <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Material Type <span class="required">*</span> </label>
	   <?php if(!empty($materialType)){												   
						$mrnView->material_type_id;												  
						$material_type=getNameById('material_type',$mrnView->material_type_id,'id')->name;									
					}									  
					?>
            <div class="col-md-7 col-xs-12 rightborder">
                 <?php echo $material_type;?>
		</div>
    </div>
  <div class="table-responsive">
<table class="table table-bordered ">
    <thead>
       <tr>
         <th scope="col">Material Name<span class="required">*</span></th>
      <th scope="col">Description</th>
      <th scope="col">Quantity</th>
      <th scope="col">UOM</th>
	  <th scope="col">Price</th>
	  <th scope="col">GST</th>
	  <th scope="col">Rcv'd Qty</th>
	  <th scope="col">Total</th>
	  <th scope="col">Defected</th>
	  <th scope="col">Def Reason</th>
          </tr>
    </thead>
    <tbody>
      <tr>
            <td class="pt-3-half">1</td>
            <td class="pt-3-half">2</td>
            <td class="pt-3-half">3</td>
            <td class="pt-3-half">4</td>
			<td class="pt-3-half">5</td>
            <td class="pt-3-half">6</td>
            <td class="pt-3-half">7</td>
            <td class="pt-3-half">8</td>
			<td class="pt-3-half">9</td>
            <td class="pt-3-half">10</td>
          
            </td>
          </tr>
    </tbody>
  </table>
  </div>
	<div class="box">
	  </div>

</div>

<!--  table -->
<div class="row payment-bottom">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Payment Mode</label>
            <div class="col-md-7 col-xs-12 rightborder ">
               <p> <?php if(!empty($mrnView)){ echo $mrnView->payment_terms; } ?></p>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Payment Date</label>
            <div class="col-md-7 col-xs-12 rightborder" >
            <p><?php if(!empty($mrnView)){ echo date("j F , Y", strtotime($mrnView->payment_date)) ; } ?></p>
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


  </div>
  <div class="col-md-6 col-xs-12">

   <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Terms and Conditions </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <p><?php if(!empty($mrnView)){ echo $mrnView->terms_conditions; } ?></p>
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
</div>
<div class="clearfix"></div>
  <div class="ln_solid"></div>
<center>
	<button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
</center>


