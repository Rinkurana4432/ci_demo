<div class="x_content">
   <div class="" role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a href="#view" role="tab" id="view_tab" data-toggle="tab" aria-expanded="false">View Sale Order</a></li>
         <li role="presentation" class=""><a href="#ViewWorkorder" role="tab" id="ViewWorkorder_tab" data-toggle="tab" aria-expanded="false">View Work Order</a></li>
         <li role="presentation" class=""><a href="#dispatch_history" id="dispatch_history_tab" role="tab" data-toggle="tab" aria-expanded="true">Dispatch History</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <div role="tabpanel" class="tab-pane fade active in" id="view" aria-labelledby="inprocess_sale_order_tab">
            <div id="print_divv">
               <table id="datatable-buttons" style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3" id=" print_divv">
                  <div class="col-md-6 col-xs-12 label-left">
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Company Unit</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                           <div><?php  if(!empty($sale_order)){echo $sale_order->company_unit; } ?></div>
                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Account</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                           <div><?php if(!empty($sale_order) && $sale_order->account_id !=0){
                              $accountData = getNameById('account',$sale_order->account_id,'id');
                              if(!empty($accountData)) echo $accountData->name;
                              }
                              ?></div>
                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Contact</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                           <div><?php if(!empty($sale_order) && $sale_order->contact_id !=0){
                              $contactData = getNameById('contacts',$sale_order->contact_id,'id');
                              if(!empty($contactData)) echo $contactData->first_name.' '.$contactData->last_name;
                              }
                              ?>	</div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-xs-12 label-left">
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Party Reference</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                           <div><?php if(!empty($sale_order)) $sale_order->party_ref; ?></div>
                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Order Date</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                           <div><?php if(!empty($sale_order) && $sale_order->order_date!='') echo date("j F , Y", strtotime($sale_order->order_date)); ?></div>
                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Dispatch Date</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                           <div><?php if(!empty($sale_order) && $sale_order->dispatch_date!='') echo date("j F , Y", strtotime($sale_order->dispatch_date)); ?></div>
                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material"> Approve Date And Approve By </label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                          <?php $datanadby=json_decode($sale_order->production_dispatch_date);
                              foreach ($datanadby->dispatch_date as $keys => $dispatch_date) { ?> 
                               <div>  <?=@$dispatch_date;?> </div>
                             <?php  } foreach ($datanadby->approveby as $keys => $approveby) { ?> <div>  <?=@$approveby;?> </div> <?php  }
                            ?>
                           
                        </div>
                      </div>
                  </div>
                  <hr>
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
              $Delivery = $this->crm_model->get_compdata('company_detail',array('id'=> $this->companyId));  

                           ?>
                        <div class="col-container mobile-view3 label-box">
                           <?php  
               if ($Delivery[0]['crm_delivery_setting']==1) { ?>
                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>S.No</label></div>
                 <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Product Name</label></div>
                 <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Delivery Adderss</label></div>
                   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label></div> 
                 <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Quantity</label></div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>UOM</label></div> 
            <?php  }else if($Delivery[0]['crm_delivery_setting']==0) { ?>
                <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>S.No</label></div>
                 <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Product Name</label></div>
                   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Description</label></div> 
                 <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Quantity</label></div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>UOM</label></div>
            <?php  }?>
                           
                        </div>
                        <?php
                           $i =1;
                           foreach($products as $product){	
                           	$productDetail = getNameById('material',$product->product,'id');
                           	$materialName = !empty($productDetail)?$productDetail->material_name:'';
                           ?>					  
                        <div class="row-padding col-container mobile-view view-page-mobile-view">
                           
                      <?php  
               if ($Delivery[0]['crm_delivery_setting']==1) { ?>
                            <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                              <label>S.No</label>
                              <div><?php echo $i; ?></div>
                           </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                              <label>Product Name</label>
                              <div>
                                 <h5><?php echo $materialName ; ?></h5>
                              </div>
                           </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group col">
                              <label>Delivery Adderss</label>
                              <div> 
                                  <h5><?php echo  $product->delivery_Add; ?></h5>
                              </div>
                           </div>
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                              <label>Description</label>
                              <div> 
                                  <h5><?php echo (array_key_exists("description",$product)?$product->description:'') ; ?></h5>
                              </div>
                           </div>
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                              <label>Quantity</label>
                              <div><?php echo $product->quantity; ?></div>
                           </div>
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                              <label>UOM</label>
                              <div><?php //echo $product->uom; 
                                 $ww =  getNameById('uom', $product->uom,'id');
                                 $uom = !empty($ww)?$ww->ugc_code:'';
                                 
                                 echo $uom;
                                 
                                 
                                 ?>
                                    
                                 </div>
                           </div>
                      <?php  }else if($Delivery[0]['crm_delivery_setting']==0){ ?>
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                              <label>S.No</label>
                              <div><?php echo $i; ?></div>
                           </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 form-group col">
                              <label>Product Name</label>
                              <div>
                                 <h5><?php echo $materialName ; ?></h5>
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-12 col-xs-12 form-group col">
                              <label>Description</label>
                              <div> 
                                  <h5><?php echo (array_key_exists("description",$product)?$product->description:'') ; ?></h5>
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-12 col-xs-12 form-group col">
                              <label>Quantity</label>
                              <div><?php echo $product->quantity; ?></div>
                           </div>
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                              <label>UOM</label>
                              <div><?php //echo $product->uom; 
                                 $ww =  getNameById('uom', $product->uom,'id');
                                 $uom = !empty($ww)?$ww->ugc_code:'';
                                 
                                 echo $uom;
                                 
                                 
                                 ?>
                                    
                                 </div>
                           </div>
                         <?php  }?>
                           
                            
                             
                        </div>
                        <?php $i++;
                           }?>
                     </div>

                     <?php } ?>
                    <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
                           <div class="col-md-5 col-sm-5 col-xs-12 text-right" style="float: right;">
                              <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 17px;color: #2C3A61; border-bottom: 1px solid #2C3A61;font-weight: normal; padding-bottom: 10px;">
                                 <label class="col-md-5 col-sm-12 col-xs-12" for="qty">Total Qty :</label>
                                 <div class="col-md-6 col-sm-12 col-xs-12 text-left">
                 <button style="color:#fff;" type="buttton" class="btn btn-info productionTab addBtn" id="<?php if(!empty($sale_order)){ echo $sale_order->id; } else {  echo '';  }  ?>" data-toggle="modal" data-id="RawMaterialReportQtysaleorder">View Total Qty</button> 
           
                              </div>
                           </div>
                        </div>
                     <hr>
                     <div class="bottom-bdr"></div>
                     <div class="col-md-6 col-xs-12 label-left">
                        <!-- <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Other Taxes</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order)) echo $sale_order->agt; ?></div>
                           </div>
                        </div> 
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Freight</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order)) echo $sale_order->freight; ?></div>
                           </div>
                        </div>-->
                      <!--   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Payment Terms</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order) && $sale_order->payment_terms != ''){
                                 echo $sale_order->payment_terms;
                                 }?></div>
                           </div>
                        </div> -->
                       <!--  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Advance Received</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order)) echo $sale_order->advance_received; ?></div>
                           </div>
                        </div> -->
                        <!-- <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Cash Discount</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order)) echo $sale_order->cash_discount; ?></div>
                           </div>
                        </div> -->
                       <!--  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Discount Offered</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order) && $sale_order->discount_offered != 'null'){
                                 $discount_offered = json_decode($sale_order->discount_offered);
                                 $discount = '';
                                 if(!empty($discount_offered)){
                                 	foreach($discount_offered as $do){
                                 		$discount .= $do. ' ,'; 
                                 	}
                                 }
                                 echo $discount = rtrim($discount,',');
                                 }?></div>
                           </div>
                        </div> -->
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Approve</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order)) echo $sale_order->approve==1?'Yes':'No'; ?></div>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">DisApprove</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order)) echo $sale_order->disapprove==1?'Yes':'No'; ?></div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 col-xs-12 label-left">
                        <!-- <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Other Expenses</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order)) echo $sale_order->label_printing_express; ?></div>
                           </div>
                        </div> -->
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Brand Label</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order)) echo $sale_order->brand_label; ?></div>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Dispatch Documents</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order) && $sale_order->dispatch_documents != 'null'){
                                 $dispatch_documents = json_decode($sale_order->dispatch_documents);
                                 if(!empty($dispatch_documents)){
                                 	$documents = '';
                                 	foreach($dispatch_documents as $dispatch_document){
                                 		$documents .= $dispatch_document. ' ,'; 
                                 		
                                 	}
                                 	echo $documents = rtrim($documents,',');
                                 }
                                 }
                                 ?></div>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Product Application</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order)) echo $sale_order->product_application; ?></div>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Guarantee</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order)) echo $sale_order->guarantee; ?></div>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Created By</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order)) echo getNameById('user_detail',$sale_order->created_by,'u_id')->name; ?></div>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Disapprove Reason</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order)) echo $sale_order->disapprove_reason; ?></div>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label for="material">Validated By</label>
                           <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                              <div><?php if(!empty($sale_order) && $sale_order->validated_by != 0) echo getNameById('user_detail',$sale_order->validated_by,'u_id')->name;  ?></div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both;">
                        <div class="col-md-8 col-sm-5 col-xs-12" style="float:left;">
                           <h6><b>Attachments:</b></h6>
                           <div class="x_content">
                              <div class="row">
                                 <div class="col-md-6">									
                                    <?php foreach($attachments as $attachment){
                                       echo '<div class="col-md-4"><a href="'.base_url(). 'assets/modules/crm/uploads/'.$attachment[ 'file_name']. '" download><img style="height:50px;" src="'.base_url(). 'assets/modules/crm/uploads/'.$attachment[ 'file_name']. '" alt="image" class="img-responsive" style="width:200px; max-width: none;"/></a></div>';
                                       } ?>						
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </tbody>
                  </thead>		                
               </table>
            </div>
          <!--   <center>
               <button id="btnPrint" type="button" class="btn btn-default">Print</button>
               <?php  if(!empty($sale_order) && $sale_order->save_status == 1) { echo '<a href="'.base_url().'production/create_sale_order_pdf/'.$sale_order->id.'" target="_blank"><button class="btn edit-end-btn ">Generate PDF</button></a>'; } ?>	
            </center> -->
         </div>
         <div role="tabpanel" class="tab-pane fade active in" id="ViewWorkorder" aria-labelledby="inprocess_sale_order_tab">
            <div id="print_divv">
               <div class="col-md-6 col-xs-12 label-left">
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <label for="material">Customer name</label>
                     <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                        <div><?php if(!empty($sale_order)){echo $sale_order->company_unit; } ?></div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-xs-12 label-left">
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <label for="material">Sale order No.</label>
                     <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                        <div><?php 
                           if(!empty($sale_order)) echo $sale_order->so_order;
                           ?></div>
                     </div>
                  </div>
               </div>
               <hr>
               <div class="bottom-bdr"></div>
               <h3 class="Material-head">
                  Work Order Details
                  <hr>
               </h3>
                  <?php foreach($work_orders as $order){ ?>
				                 <div class="Process-card">

                  <div class="col-md-6 col-xs-12 label-left">
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Work Order No</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                           <div><?php if(!empty($order['work_order_no'] && isset($order['work_order_no'] ))) echo $order['work_order_no'] ;?></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-xs-12 label-left">
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Expected Date</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                           <div><?php if(!empty($order) && $order['expected_delivery_date']!='') echo date("j F , Y", strtotime($order['expected_delivery_date'])); ?></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-xs-12 label-left">
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Work Order Name</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                           <div><?php if(!empty($order['workorder_name'] && isset($order['workorder_name'] ))) echo $order['workorder_name'] ;?></div>
                        </div>
                     </div>
                  </div>               
				  <div class="col-md-6 col-xs-12 label-left">
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Work Order Progess Status</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                           <div><?php if($order['progress_status'] !=='') echo (($order['progress_status'] == '1')?'Completed':'In Progress') ;?></div>
                        </div>
                     </div>
                  </div>
                  <table id="datatable-buttons" style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3" id=" print_divv">
                     <thead>													
                     <tbody>
                           <?php if(!empty($order['product_detail'])){ 
                              $products = json_decode($order['product_detail']);
                              ?>
						  <div class="well pro-details" id="chkIndex_1" style="padding:0px;">

                           <div class="col-container mobile-view3 label-box">
                              <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>S.No</label></div>
                              <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name</label></div>
                              <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Required Qty</label></div>
                              <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Pending Qty</label></div>
                              <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>WorkOrder Qty</label></div>
                              <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>UOM</label></div>
                              <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Job card</label></div>
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
                                 <label>Material Name</label>
                                 <div>
                                    <h5><?php echo $materialName ; ?></h5>
                                    <br><?php echo (array_key_exists("description",$product)?$product->description:'') ; ?>
                                 </div>
                              </div>
                              <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                                 <label>Required Qty</label>
                                 <div><?php echo $product->quantity; ?></div>
                              </div>
                              <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                                 <label>Pending Qty</label>
                                 <div><?php echo $product->Pending_quantity; ?></div>
                              </div>
                              <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                                 <label>WorkOrder Qty</label>
                                 <div><?php echo $product->transfer_quantity; ?></div>
                              </div>
                              <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                                 <label>UOM</label>
                                 <div><?php //echo $product->uom; 
                                    $ww =  getNameById('uom', $product->uom,'id');
                                    $uom = !empty($ww)?$ww->ugc_code:'';
                                    
                                    echo $uom;
                                    
                                    
                                    ?></div>
                              </div>
                              <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                                 <label>Job card</label>
                                 <div><?php echo $product->job_card;  ?></div>
                              </div>
                           </div>
                           <?php $i++;
                              }?>
                        </div>
                        <?php } ?>
                     </tbody>
                     </thead>	  
                  </table>
                        <div class="col-md-6 col-xs-12 label-left">
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Specification</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                           <div><?php if(!empty($order['specification'] && isset($order['specification'] ))) echo $order['specification'] ;?></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-xs-12 label-left">
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Stoke</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                           <div><?php if(!empty($order['stock_saleOrder'] && isset($order['stock_saleOrder'] ))) echo $order['stock_saleOrder'] ;?></div>
                        </div>
                     </div>
                  </div>
			   </div>
               <?php } ?>
            </div>
            <center>
               <button id="btnPrint" type="button" class="btn btn-default">Print</button>
               <?php  if(!empty($sale_order) && $sale_order->save_status == 1) { echo '<a href="'.base_url().'production/create_sale_order_pdf/'.$sale_order->id.'" target="_blank"><button class="btn edit-end-btn ">Generate PDF</button></a>'; } ?>	
            </center>
         </div>
         <!-------------------tab leads------------------------------->
         <div role="tabpanel" class="tab-pane fade" id="dispatch_history" aria-labelledby="complete_sale_order_tab">
            <div id="print_div_content">
               <?php if(!empty($sale_order_dispatch)){ ?>
               <table id="datatable-buttons" style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3">
                  <thead>
                     <tr>
                        <th>Invoice no</th>
                        <th>Transport Tel no</th>
                        <th>Vehicle no</th>
                        <th>Product Details</th>
                        <th>Dispatch date</th>
                        <th>Created Date</th>
                        <th>Comments</th>
                        <th>Created By</th>
                        <th>Attachments</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        foreach($sale_order_dispatch as $sod){
                        	foreach($sod as $sale_dispatch){
                        		if(!empty($sale_dispatch['product'])){
                        		$abc = getNameById('user_detail',$sale_dispatch['created_by'],'u_id');
                        			echo '<tr>
                        					<td>'.$sale_dispatch["invoice_no"].'</td>
                        					<td>'.$sale_dispatch["transport_tel_no"].'</td>
                        					<td>'.$sale_dispatch["vehicle_no"].'</td>
                        					<td><table class="table table-bordered ">
                        					<thead>
                        					<tr>
                        						<th>Material name</th>
                        						<th>Description</th>
                        						<th>Quantity</th>
                        						<th>Uom</th>
                        					</tr>
                        					</thead>';
                        					$productData = JSON_decode($sale_dispatch['product']);
                        					if(!empty($productData)){
                        						foreach($productData as $pd){
                        						$material = getNameById('material',$pd->product,'id');
                        						$material_name	=	!empty($material)? $material->material_name:"";
                        						echo '<tbody>
                        								<tr>
                        								<td>'.$material_name.'</td>
                        								<td>'.$pd->description.'</td>
                        								<td>'.$pd->quantity.'</td>
                        								<td>'.$pd->uom.'</td>
                        								</tr>
                        							</tbody>';
                        						}
                        					}
                        					echo '</table></td>
                        					<td>'.$sale_dispatch['dispatch_date'].'</td>
                        					<td>'.date("j F , Y", strtotime($sale_dispatch['created_date'])).'</td>
                        					<td>'.$sale_dispatch['comments'].'</td>
                        					<td></td>';
                        					if(!empty($sod['file_name'])){
                        					$img = $sod['file_name'];
                        					echo '<td colspan="'.count($img).'">';
                        						foreach($img as $image){
                        							echo '<a href="'.base_url(). 'assets/modules/crm/uploads/'.$image. '" download><img style="height:50px;" src="'.base_url(). 'assets/modules/crm/uploads/'.$image. '" alt="image" class="img-responsive"/></a>';
                        						}
                        					echo '</td>';
                        					}else{
                        						echo '<td></td>';
                        					}
                        					echo '</tr>';
                        			}
                        		}
                        	}?>
                  </tbody>
               </table>
               <?php } ?>
            </div>
         </div>
         <!-----------------------------end tab------------------------------------>
      </div>
   </div>
</div>




<div id="work_order_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close workOrderModal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Raw Material Quantity Details</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>