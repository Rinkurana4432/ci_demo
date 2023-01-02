<form method="post" class="form-horizontal" enctype="multipart/form-data" id="gate-form" novalidate="novalidate" action="<?php echo base_url(); ?>purchase/convertPoToGate">
   <input name="convert_to_gate" value="<?= $convert_to_gate ?>" type="hidden">
   <input name="po_id" value="<?= $po_id; ?>" type="hidden">
   <input type="hidden" name="gateId" value="<?= $editData[0]['id']??'' ?>">
      <div class="item form-group">
      <?php
      if (!empty($mrnOrder)) {
         $newDate = date("d-m-Y", strtotime($mrnOrder->created_date));
         ?>
         </br>
         <center><b>Order Number : </b> <?php echo $mrnOrder->order_code; ?></center>
         <center><b>Order Created Date : </b> <?php echo $newDate; ?> </center><br />
      <?php  } ?>
   <?php
      $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ; ?>	
   <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
      <div class="col-md-12 col-sm-12 col-xs-12 vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="company_unit">Gate Entry No.</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <input type="text" name="gate_no" class="form-control col-md-7 col-xs-12" placeholder="Gate Entry No" value="<?= $editData[0]['gate_no']??$gateEntryNo ?>" readonly required="required">
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="Bill No">Supplier Name 
            <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <select class="jsSelect2 form-control select2-width-imp" name="supplier" required>
                  <option value="">Select Supplier</option>
                  <?php 
                     if( $suppliers ){
                        foreach ($suppliers as $key => $value) { ?>
                           <option value="<?= $value['id'] ?>"
                                 <?php if( isset($editData[0]['supplier']) ){
                                          if( $editData[0]['supplier'] == $value['id']  ){
                                             echo "selected";
                                          }
                                 } ?>
                              ><?= ucfirst($value['name']) ?></option>           
                     <?php }
                     }
                  ?>
               </select>
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="Bill No">Invoice No. 
            <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <input type="text" name="invoice_no" class="form-control col-md-7 col-xs-12" placeholder="Invoice No" value="<?= $editData[0]['invoice_no']??'' ?>" required="required">
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="Bill No">Date.
            <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <input type="text" name="currentDate" class="form-control col-md-7 col-xs-12 bill_datee predaterange" readonly placeholder="Date" value="<?= $editData[0]['created_at']??'' ?>">
            </div>
         </div>
      </div>
   </div>
   <hr>
   <div class="form-group">
      <div class="col-md-6 col-md-offset-3">
         <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
         <button id="send" type="submit" class="btn edit-end-btn">Submit</button>
      </div>
   </div>
</form>
<script type="text/javascript">
   $(document).ready(function() {
  $('.jsSelect2').select2();
});   
</script>

<!-- /page content -->
