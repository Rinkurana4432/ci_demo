<div class="x_content">
   <div class="" role="tabpanel" data-example-id="togglable-tabs">
    <div id="myTabContent" class="tab-content">
         <div role="tabpanel" class="tab-pane fade active in" id="view" aria-labelledby="inprocess_sale_order_tab">
            
                  <div class="bottom-bdr"></div>
                  <h3 class="Material-head">
                     Product details
                     <hr>
                  </h3>
                  <thead>													
                  <tbody>
                     <div class="well pro-details" id="chkIndex_1" style="padding:0px;">
                        <?php if(!empty($sale_order) && $sale_order->product!=''){ 
                           $products = json_decode($sale_order->product);
                           ?>
                        <div class="col-container mobile-view3 label-box">
                           <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>S.No</label></div>
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Product Name</label></div>
                           <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Quantity</label></div>
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>UOM</label></div>
                           <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Price</label></div>
                           <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>GST</label></div>
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Total</label></div>
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Total With GST</label></div>
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
                              <div>
                                 <h5><?php echo $materialName ; ?></h5>
                                 <br><?php echo (array_key_exists("description",$product)?$product->description:'') ; ?>
                              </div>
                           </div>
                           <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                              <label>Quantity</label>
                              <div><?php echo $product->quantity; ?></div>
                           </div>
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                              <label>UOM</label>
                              <div><?php //echo $product->uom; 
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
                              <div><?php echo $product->individualTotal; ?></div>
                           </div>
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                              <label>Total With GST</label>
                              <div ><?php echo $product->individualTotalWithGst; ?></div>
                           </div>
                        </div>
                        <?php $i++;
                           }?>
                     </div>
                     <?php } ?>
                     <div class="col-md-12 col-sm-12 col-xs-12 " style="clear:both; margin-top:22px;">
                        <div class="col-md-4 col-sm-5 col-xs-12 text-right grand-total3" style="float: right;">
                           <div class="col-md-12 col-sm-5 col-xs-12 text-right">
                              <div class="col-md-12 col-sm-12 col-xs-12 text-right igst style='display:none;'">
                                 <div class="col-md-6 col-sm-5 col-xs-6 text-right">Total :</div>
                                 <div class="col-md-6 col-sm-5 col-xs-6 text-left">
                                    <?php echo $sale_order->total; ?>
                                 </div>
                              </div>
                              <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 20px;color: #2C3A61; border-top: 1px solid #2C3A61;">
                                 <div class="col-md-6 col-sm-5 col-xs-6 text-right">
                                    Grand Total : 
                                 </div>
                                 <div class="col-md-6 col-sm-5 col-xs-6 text-left">
                                    <span class="divSubTotal fa fa-rupee" aria-hidden="true"><?php echo $sale_order->grandTotal; ?></span> 
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <hr>

                  </tbody>
                  </thead>		                
               </table>
            </div>
          
         </div>
       
         <!-----------------------------end tab------------------------------------>
      </div>
   </div>
</div>