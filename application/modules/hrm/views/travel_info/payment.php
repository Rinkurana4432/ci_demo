<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/payment_travel_info" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
   <div style="width:100%" id="print_divv" border="1" cellpadding="2">
      <h3>Payment Details</h3>
      <?php 	$paymentDetailsJson = array();
         if(!empty($travel_details->payment_details)){ 
                         $paymentDetailsJson = json_decode($travel_details->payment_details); 
         		 // pre($paymentDetailsJson);die;
           }
         ?>
	<?php foreach($paymentDetailsJson as $payment){ ?> 
      <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Amount</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($payment)){echo $payment->amount;} ?>	
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Payment Date</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
			<?php if(!empty($payment)){echo $payment->payment_date ;} ?>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Specification</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
						<?php if(!empty($payment)){echo $payment->payment_description;} ?>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Payment complete Status</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($payment) && $payment->balance =='0'){ echo "Complete"; }else{  echo "In Progress"; } ?>	
            </div>
         </div>
      </div>	  
	  <hr>
      <div class="bottom-bdr"></div>
	<?php } ?>
      <h3>Add Pending Payment</h3>
      <div class="paymentSection col-md-12 border-rg" style="">
         <input type="hidden" name="id" value="<?php if(!empty($travel_details)){ echo $travel_details->id; }?>">
         <input type="hidden" name="paidstatus_by" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>">
         <div class="item form-group">
            <label class="col-md-12 col-sm-12 col-xs-12" for="amount">Amount<span class="required">*</span></label>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <input type="number" id="amount" name="amount" required="required"  class="form-control" placeholder="amount" value="" onkeypress="return float_validation(event, this.value)">
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-12 col-sm-12 col-xs-12" for="req_date">Payment Date<span class="required">*</span></label>
            <div class="input-group date" data-provide="datepicker">
               <input type="text" class="form-control" required="required"  name="payment_date">
               <div class="input-group-addon">
                  <span class="glyphicon glyphicon-th"></span>
               </div>
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-12 col-sm-12 col-xs-12" for="specification">Specification</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <textarea id="description" name="payment_description" class="form-control" placeholder="description"></textarea>
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-12 col-sm-12 col-xs-12" for="specification">Payment </label>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <input type="checkbox" name="check_payment_complete" id="check_payment_complete" value="complete_payment"> Please check if Payment Complete<br>
            </div>
         </div>
         <hr>
         <div class="form-group">
            <div class="col-md-12 ">
               <center><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="reset" class="btn btn-default">Reset</button>
                  <input type="submit" class="btn edit-end-btn " value="Submit">
               </center>
            </div>
         </div>
      </div>
   </div>
</form>