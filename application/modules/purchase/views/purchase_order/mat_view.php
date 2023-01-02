 
<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv" style="padding:0px;">   
<div class="container body">
   <div class="container mt-3">
      <h3 class="Material-head">
         Material Description
         <hr>
      </h3>
      <div class="well pro-details for-leptop-1" id="chkIndex_1" style="overflow:auto; padding:0px; borders-radius: 0px !important; borders:0px; margin-top: 15px; margin-bottom:0px;">
         <?php 
            if(($orders->material_name != '') && ($orders->material_name !='[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]')) {  ?>
         <div class="col-container mobile-view2">
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">Material Type</div>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">Material Name</div>
            <div class="col-md-1 col-sm-12 col-xs-12 form-group">Quantity</div>
           
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">Preffered Supplier</div>
            <div class="col-md-1 col-sm-12 col-xs-12 form-group">Expected Amount</div>
            <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="borders-right: 1px solid #c1c1c1;">Total Amount</div>
         </div>
         <?php 
            if(!empty($orders) && $orders->material_name !='' && $orders->material_name != '[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]'){					
            	$materialDetail =  json_decode($orders->material_name); 
            	$Total=0;									
            	foreach($materialDetail as $material_detail){
            	$material_id=$material_detail->material_name_id;
            	$materialtype= getNameById('material_type',$material_detail->material_type_id,'id');
               $materialName=getNameById('material',$material_id,'id');

            	$Total+=$material_detail->sub_total;
				
            	
            	
            	?>
         <div class="row-padding col-container mobile-view  view-page-mobile-view">
            <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
               <label>Material Type</label>
               <div><?php if (!empty($materialtype)) {   echo $materialtype->name;  } ?></div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group col">
               <label>Material Name</label>
               <div><?php if (!empty($materialName)) {	echo $materialName->material_name;	} ?></h5>&nbsp;&nbsp;<?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?></div>
            </div>
            <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
               <label>Quantity</label>
               <div ><?php echo $material_detail->quantity;?></div>
            </div>
            
            <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
               <label>Preferred Supplier</label>
               <div>
                  <?php if(!empty($orders)){                                  
                                                    
                     $supplierName=getNameById('supplier',$orders->supplier_name,'id');                     
                     ?>                      
                  <?php if(!empty($supplierName)){echo $supplierName->name; } else {echo "N/A";}?>
                  <?php }?>								
               </div>
            </div>
            <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
               <label>Expected Amount</label>								
               <div ><?php echo $material_detail->price;?></div>
            </div>
            <div class="col-md-1 col-sm-12 col-xs-12 form-group col" style="borders-right:1px solid #c1c1c1 ;">
               <label>Total Amount</label>								
               <div ><?php echo $material_detail->sub_total;?></div>
            </div>
         </div>
         <?php }                                     
            } }?>
      </div>
      <table class="well pro-details for-print" id="chkIndex_1" >
         <?php 
            if(($orders->material_name != '') && ($orders->material_name != '[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]')) {  ?>
         <tr>
            <th>Material Name</th>
            <th>Quantity</th>
            <th>Purpose</th>
            <th>Preffered Supplier</th>
            <th>Expected Amount</th>
            <th >Total Amount</th>
         </tr>
         <?php 
            if(!empty($orders) && $orders->material_name !='' && $orders->material_name != '[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]'){					
            	$materialDetail =  json_decode($orders->material_name); 
            	$Total=0;									
            	foreach($materialDetail as $material_detail){
            	$material_id=$material_detail->material_name_id;
            	$materialName=getNameById('material',$material_id,'id');
            	$Total+=$material_detail->sub_total;	
            	 
            	
            	?>
         <tbody>
            <tr>
               <td >
                  <div><?php if (!empty($materialName)) {	echo $materialName->material_name;	} ?></h5>&nbsp;&nbsp;<?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?></div>
               </td>
               <td >
                  <div><?php echo $material_detail->quantity;?></div>
               </td>
               <td>
                  <div><?php echo $material_detail->purpose;?></div>
               </td>
               <td>
                  <div>
                     <?php if(!empty($suppliername)){                                  
                        $orderss->preffered_supplier;                                   
                        $supplierName=getNameById('supplier',$orderss->preffered_supplier,'id');                     
                        ?>                      
                     <?php if(!empty($supplierName)){echo $supplierName->name; } else {echo "N/A";}?>
                     <?php }?>								
                  </div>
               </td>
               <td >
                  <div ><?php echo $material_detail->price;?></div>
               </td>
               <td>
                  <div ><?php echo $material_detail->sub_total;?></div>
               </td>
            </tr>
         </tbody>
         <?php }                                     
            }?>
      </table>
     
      <?php } ?>					
      
   </div>
   <br/>
     <br/>
 <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             
            </div>
</div>
</div>
