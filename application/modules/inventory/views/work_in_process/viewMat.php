<?php

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

?>
	

    <div class="item form-group col-md-8 col-xs-12 vertical-border">												
</div>	
	
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">				
		<div class="item form-group ">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
				<div class="panel-default">
				 <table id="" style="width:100%" class="table table-bordered product_index  bulk_action" data-id="user" border="1" cellpadding="3">
            <thead>
               <tr>
                  <th>Product Type</th>
                  <th>Product Name</th>
                  <th>Location</th>
                  <th>Product status</th>
                  <th>Quantity</th>
                  <th>Uom</th>
               </tr>
            </thead>
            <?php 
		
               if($material_issue->mat_detail !=''){
				  
               		$products = json_decode($material_issue->mat_detail);
               		$locadd = '';
               		foreach($products as $product){
               		
               			$material_type = getNameById('material_type',$product->material_type_id,'id');	
               			if(!empty($material_type)){ $mattype =  $material_type->name;} else { echo "N/a";}
               			
               			$productDetail = getNameById('material',$product->material_id,'id');
               			$location_address = getNameById('company_address',$product->location,'id');	
               			if(!empty($location_address)){ $locadd =  $location_address->location;} else { echo "N/a";}
               			$materialName = !empty($productDetail)?$productDetail->material_name:'';
               			$ww =  getNameById('uom', $product->uom,'id');
               			$uom = !empty($ww)?$ww->ugc_code:'';
               
               			$mat_status = !empty($product)?$product->material_status:'';
               			$quanttyyy = !empty($product)?$product->quantity:'';
               
               			echo "<tr>
               					<td>".$mattype."</td>
               					<td>".$materialName."</td>
               					<td>".$locadd."</td>
               					<td>".$mat_status."</td>
               					<td>".$quanttyyy."</td>
               					<td>".$uom."</td>
               				</tr>";
                  }
                  }
				  ?>
               	</table>
				</div>
			</div>
		</div>
	</div>
	
<hr>
            
<div class="col-md-12 col-md-offset-3" style="margin-top: 20px;">
<center>
		<a class="btn edit-end-btn" onclick="location.href='<?php echo base_url();?>inventory/work_in_process'">Cancel</a>
 </div>
					</center>
              
