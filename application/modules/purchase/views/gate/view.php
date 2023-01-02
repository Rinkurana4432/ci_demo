<div class="container body">
   <div class="main_container">
      <div class="col-md-12 col-sm-12 col-xs-12" role="main">
         <div class="">
            <div class="clearfix"></div>
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                     <div class="x_content">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
<!-- Change Status work Start -->
<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv" style="padding:0px;">
   <h3 class="Material-head main-hd">
      Gate Entry Detail
      <hr>
   </h3>
   <div>
      <div class="col-md-6 col-xs-12 col-sm-6 label-left   "  style=" padding:0px; ">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Gate Entry No.</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?= $gateEnteryData[0]['gate_no']; ?></div>
            </div>
         </div>
      </div>
   </div>
   <div>
      <div class="col-md-6 col-xs-12 col-sm-6 label-left   "  style=" padding:0px; ">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Order Code</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?= $gateEnteryData[0]['order_code']; ?></div>
            </div>
         </div>
      </div>
   </div>
   <div>
      <div class="col-md-6 col-xs-12 col-sm-6 label-left   "  style=" padding:0px; ">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Supplier</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?= $gateEnteryData[0]['name']; ?></div>
            </div>
         </div>
      </div>
   </div>
   <div>
      <div class="col-md-6 col-xs-12 col-sm-6 label-left   "  style=" padding:0px; ">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Invoice No</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?= $gateEnteryData[0]['invoice_no']; ?></div>
            </div>
         </div>
      </div>
   </div>
   <div>
      <div class="col-md-6 col-xs-12 col-sm-6 label-left   "  style=" padding:0px; ">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Date</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?= $gateEnteryData[0]['created_at']; ?></div>
            </div>
         </div>
      </div>
   </div>



<div>
</div>
<div class="clearfix"></div>
</div>
<center>
   <button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
</center>