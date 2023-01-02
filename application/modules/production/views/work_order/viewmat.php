<table class="fixed data table table-bordered no-margin" style="width:100%" id="print_divv" border="1" cellpadding="2">
   <thead>													
   <tbody>
      
            <table id="gg" class="table table-bordered" data-id="user" border="1" cellpadding="3">
               <?php 
                  $productDetail=json_decode($work_order->product_detail); ?>
               <thead>
                  <tr>
                     <th>Product name</th>
                     <th>Required Qty</th>
                     <th>WorkOrder Qty</th>
                     <th>UoM</th>
                     <th>Job Card</th>
                  </tr>
               </thead>
               <?php 
                  if(!empty($productDetail)){
                  	foreach($productDetail as $product_Detail){ 
                  	$materialName = getNameById('material',$product_Detail->product,'id');
                  ?>		
               <tbody>
                  <tr>
                     <th><?php if(!empty($materialName)){echo $materialName->material_name;}else{echo "N/A";} ?></th>
                     <th><?php  if(!empty($product_Detail)){echo $product_Detail->quantity;}else{echo "N/A";} ?></th>
                     <th><?php  if(!empty($product_Detail)){echo $product_Detail->transfer_quantity;}else{echo "N/A";} ?></th>
                     <th><?php  //if(!empty($product_Detail)){echo $product_Detail->uom;}else{echo "N/A";} 
                        $ww =  getNameById('uom', $product_Detail->uom,'id');
                        $uom = !empty($ww)?$ww->ugc_code:'';
                        
                        echo $uom;
                        
                        ?></th>
                     <th><?php  if(!empty($product_Detail)){echo $product_Detail->job_card;}else{echo "N/A";} ?></th>
                  </tr>
                  <?php }}?>
               </tbody>
            </table>
       
      </tr>
     
   </tbody>
   </thead>												
</table>
<center>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</center>