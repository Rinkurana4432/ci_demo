<!-- Change Status work Start -->	
<?php 	
   //$orderCode = ($mrnView && !empty($mrnView))?$mrnView->order_code:'';
   $statusDetail = JSON_decode($mrnView->status);	
   // pre($statusDetail);
   // pre($mrnView);
   
   
   ?>  
<div class="container body">
  
<!-- Change Status work Start -->
<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv" style="padding:0px;">
   <h3 class="Material-head main-hd">
      GRN Detail
      <hr>
   </h3>
   <div >
      
      <div class="container mt-3">
         <h3 class="Material-head">
            Material Description
            <hr>
         </h3>
         <div class="well pro-details for-leptop-1" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; border:0px; margin-top: 15px;">
            <?php if(!empty($mrnView) && $mrnView->material_name !='' && $mrnView->material_name!= '[{"material_name_id":"","uom":"","quantity":"","price":"","sub_tax":"","sub_total":"","gst":"","total":"","defected":0,"defected_reason":"","received_quantity":""}]' ){ ?>
            <div class="col-container mobile-view2">
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Material Type</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Material Name</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Quantity</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Price (₹)</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Sub Total (₹)</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">GST</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Sub Tax</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Total (₹)</div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group">Received Quantity ff</div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1;">Approve /Disapprove with reason</div>
            </div>
            <?php 									  
               if(!empty($mrnView) && $mrnView->material_name !=''){

                		   
               $materialDetail =  json_decode($mrnView->material_name);	
               $subTotal=0;
               $Total=0;
               	foreach($materialDetail as $material_detail){
               		 if($material_detail->material_name_id != ''){
               			// pre($material_detail);
               		$subTotal+=$material_detail->sub_total;	
               		$Total+=$material_detail->total;						
               		$material_id=$material_detail->material_name_id;										
               		$materialName=getNameById('material',$material_id,'id');																		
               		$materialtype=getNameById('material_type',$material_detail->material_type_id,'id');																		
               		$materialtype_old=getNameById('material_type',$mrnView->material_type_id,'id');
																						
               ?>
            <div class="row-padding col-container mobile-view view-page-mobile-view">
				<div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Material Type</label>
                  <div ><span><?php if (!empty($materialtype)) {	echo $materialtype->name;	}else{ echo $materialtype_old->name; } ?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Material Name</label>
                  <div ><span><?php if (!empty($materialName)) {	echo $materialName->material_name;	} ?>:</span>&nbsp;&nbsp;<?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Quantity</label>
                  <div ><?php echo $material_detail->quantity; ?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Price (₹)</label>
                  <div ><?php echo number_format($material_detail->price); ?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Sub Total (₹)</label>
                  <div ><?php echo $material_detail->sub_total; ?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>GST</label>
                  <div ><?php echo $material_detail->gst; ?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Sub Tax</label> 
                  <div ><?php echo $material_detail->sub_tax; ?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Total (₹)</label>
                  <div ><?php echo number_format($material_detail->total); ?></div>
               </div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                  <label>Received Quantity</label>
                  <div ><?php echo $material_detail->received_quantity;?></div>
               </div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group col" style="border-right: 1px solid #c1c1c1;">
                  <label>Approve /Disapprove with reason</label>
                  <div ><?php echo ($material_detail->defected == 1)?$material_detail->defected_reason:'';?></div>
               </div>
            </div>
            <?php } }   } } ?>
         </div>
         <table class="well pro-details for-print" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; border:0px; margin-top: 15px;">
            <?php if(!empty($mrnView) && $mrnView->material_name !='' && $mrnView->material_name!= '[{"material_name_id":"","uom":"","quantity":"","price":"","sub_tax":"","sub_total":"","gst":"","total":"","defected":0,"defected_reason":"","received_quantity":""}]' ){?>
            <tr>
               <th class="col-md-2 col-sm-12 col-xs-12 form-group">Material Name</th>
               <th class="col-md-1 col-sm-12 col-xs-12 form-group">Quantity</th>
               <th class="col-md-1 col-sm-12 col-xs-12 form-group">Price (₹)</th>
               <th class="col-md-1 col-sm-12 col-xs-12 form-group">Sub Total (₹)</th>
               <th class="col-md-1 col-sm-12 col-xs-12 form-group">GST</th>
               <th class="col-md-1 col-sm-12 col-xs-12 form-group">Sub Tax</th>
               <th class="col-md-1 col-sm-12 col-xs-12 form-group">Total (₹)</th>
               <th class="col-md-2 col-sm-12 col-xs-12 form-group">Received Quantity</th>
               <th class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1;">Approve /Disapprove with reason</th>
            </tr>
            <?php 									  
               if(!empty($mrnView) && $mrnView->material_name !=''){																				   
               $materialDetail =  json_decode($mrnView->material_name);	
               $subTotal=0;
               $Total=0;
               	foreach($materialDetail as $material_detail){
               		 if($material_detail->remove_mat_id == 0){
               		//	pre($material_detail);
               		$subTotal+=$material_detail->sub_total;	
               		$Total+=$material_detail->total;						
               		$material_id=$material_detail->material_name_id;										
               		$materialName=getNameById('material',$material_id,'id');																		
               ?>
            <tbody>
               <tr>
                  <td>
                     <div ><span><?php if (!empty($materialName)) {	echo $materialName->material_name;	} ?>:</span>&nbsp;&nbsp;<?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?></div>
                  </td>
                  <td>
                     <div ><?php echo $material_detail->quantity; ?></div>
                  </td>
                  <td>
                     <div ><?php echo number_format($material_detail->price); ?></div>
                  </td>
                  <td>
                     <div ><?php echo $material_detail->sub_total; ?></div>
                  </td>
                  <td>
                     <div ><?php echo $material_detail->gst; ?></div>
                  </td>
                  <td>
                     <div ><?php echo $material_detail->sub_tax; ?></div>
                  </td>
                  </td>
                  <td>
                     <div ><?php echo number_format($material_detail->total); ?></div>
                  </td>
                  <td>
                  <div ><?php echo $material_detail->received_quantity;?></div>
                  </td>
                  <td>
                     <div ><?php echo ($material_detail->defected == 1)?$material_detail->defected_reason:'';?></div>
                  </td>
               </tr>
            </tbody>
            <?php }  }  }?>
         </table>
       
         <?php } ?>
         <hr>

      </div>
   </div>
</div>
<div>
</div>
<div class="clearfix"></div>
</div>
<center>
   <!--button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button-->
</center>