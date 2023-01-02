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
                <tbody>
            <?php 
			   if(!empty($material_issue->mat_detail))
			   {
               		$products = json_decode($material_issue->mat_detail, true);
               		$locadd = '';
               		if(!empty($products)){
                   	   ?>
                   		 
                   	    <tr>
                   	        <td>Product Type</td>
                            <td>Product name</td> 
                            <td>Quantity</td>
                            <td>Uom</td>
                            <td>location</td>
                            <td>Work Order</td>
                            <td>NPDM</td>
                            <td>Machine Name</td> 
                   	    </tr>
                   	    <?php
                   		    
                   		        foreach($products as $material){
                   		            $work_order =  getNameById('work_order', $material['work_order'],'id');
                   		            $material_type = getNameById('material_type',$material['material_type_id'],'id');	
                   			        $mattype =  !empty($material_type) ?  $material_type->name:'';
                   		            $productDetail = getNameById('material',$material['material_id'],'id');
                   		            $materialName = !empty($productDetail) ? $productDetail->material_name:'';
                   		            $location_address = getNameById('company_address',$material['location'],'id');	
                   		            $location_address = !empty($location_address) ? $location_address->location:'';
                   		            $ww =  getNameById('uom', $material['uom'],'id');  
                   			        $uom = !empty($ww) ? $ww->ugc_code:'';
                   			        $npdm =  getNameById('npdm', $material['npdm'],'id');  
                                    $machine_name =  getNameById('add_machine', $material['machine_name'],'id');
                   		   ?>
                           	    <tr>
                           	        <td><?php echo $mattype; ?></td>
                                    <td><?php echo $materialName; ?></td> 
                                    <td><?php echo $material['quantity']; ?></td>
                                    <td><?php echo $uom; ?></td>
                                    <td><?php echo $location_address; ?></td>
                                    <td><?php echo $work_order->workorder_name .' ('. $work_order->work_order_no. ')'; ?></td>
                                    <td><?php echo $npdm->product_name; ?></td>
                                    <td><?php echo $machine_name->machine_name; ?></td> 
                           	    </tr>
                   		   <?php
                   		        }
                                
               		     
                    }
               }
			   ?>
                   	</tbody>
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
              
