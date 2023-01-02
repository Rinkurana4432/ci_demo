<div class="stik">		
<!-- <form action="<?php echo base_url(); ?>crm/price_list" method="post" enctype="multipart/form-data">
     <div class="col-md-3">
	  <label class="col-md-2" style="padding:8px;">Product Name</label>
		<div class="col-md-10">
		<input type="text" name="pro_name" class="optional form-control col-md-7 col-xs-12" data-validate-length-range="0" > 
		</div>
    </div> -->

	<!-- <div class="col-md-3">
	  <label class="col-md-2" style="padding:8px;">Product SKU</label>
		<div class="col-md-10">
		<input type="text" name="pro_sku" class="optional form-control col-md-7 col-xs-12" data-validate-length-range="0" > 
		</div>
    </div>
	
	<div class="col-md-3">
	   <label class="col-md-2" style="padding:8px;">Customer Type</label>
		<div class="col-md-10">
		<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="customer_type" data-id="types_of_customer" data-key="id" data-fieldname="type_of_customer" data-where="created_by_cid = <?php echo $this->companyGroupId; ?> AND active_inactive = 1" width="100%" tabindex="-1" aria-hidden="true">
			<option value="">Select Option</option>
		</select> 
		</div>
    </div>
		<div class="col-md-3">
		<input type="submit" class="form-control col-md-12" name="importe" value="Filter" />
		</div>
		<div class="col-md-3">
		<div class="btn-group" role="group" aria-label="Basic example">
           <a href="<?php echo base_url(); ?>crm/price_list" class="Reset-btn btn btn-success">
        Reset
         </a>     
		</div>
</form>	 -->
</div>
<div class="col-md-12 col-xs-12 for-mobile">
      
	<p class="text-muted font-13 m-b-30"></p> 
<div id="print_div_content">		

<table class="table table-striped maintable" id="mytable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Lot Number</th>
                                    <th>Material Type</th>
                                    <th>Material Name</th>
                                    <th>MOU Price</th>
                                    <th>MRP Price</th>
                                    <th>Avail. Quantity</th>
                                    <th>Date</th>
                                    <th>Created by</th>
                                    <th>Created Date</th>
                                   <!--  <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
									if(!empty($lot_details)){
										foreach($lot_details as $lotdetails){		
											$rty = getNameById('user_detail',$lotdetails['created_by'],'u_id');
											$usernme = !empty($rty)?$rty->name:'';
                                            $matype = getNameById('material_type',$lotdetails['mat_type_id'],'id');
                                            $mat_type = !empty($matype)?$matype->name:'';
                                            $manme = getNameById('material',$lotdetails['mat_id'],'id');
                                            $mat_nme = !empty($manme)?$manme->material_name:'';
                                            $statusChecked = $lotdetails['active_inactive']==1?'checked':'';
								?>
                                <tr>
                                    <td>
                                        <?php echo $lotdetails['id'];?>
                                    </td>
                                    <td>
                                        <?php echo $lotdetails['lot_number'];?>
                                    </td>
                                    <td>
                                        <?php echo $mat_type; ?>
                                    </td>
                                    <td>
                                        <?php  echo $mat_nme; ?>    
                                    </td>
                                    <td>
                                        <?php echo $lotdetails['mou_price']; ?>
                                    </td>
                                    <td>
                                        <?php echo $lotdetails['mrp_price']; ?>
                                    </td>
                                    <td>
                                        <?php echo $lotdetails['quantity']; ?>
                                    </td>
                                    <td>
                                    <?php echo $lotdetails['date']; ?>
                                    </td>
                                    <td>
                                        <?php echo $usernme;?>
                                    </td>
                                    <td>
                                        <?php echo $lotdetails['created_date'];?>
                                    </td>
                                   <!--  <td>
                                        <?php 
											// if($can_edit) { 
											// 	echo '<button class="btn btn-info btn-xs inventory_tabs" data-tooltip="Edit" id="'.$lotdetails["id"].'" data-toggle="modal" data-id="editlotmanagement"><i class="fa fa-pencil"></i> </button>'; 
											// }
											// // if($can_view) { 
											// 	// echo '<a href="javascript:void(0)" id="'.$dailyreportsetting["id"] . '" data-id="location_view" class="inventory_tabs btn btn-warning btn-xs" id="'. $dailyreportsetting["id"].'"><i class="fa fa-eye"></i> View </a>'; 
											// // }

           //                                  echo '<input type="checkbox" class="js-switch change_status_lot"  data-switchery="true" style="display: none;" value="'.$lotdetails['active_inactive'].'" 
           //                              data-value="'.$lotdetails['id'].'"  '.$statusChecked .'>';

											// if($can_delete) { 
											// 	echo ' <a href="javascript:void(0)" data-tooltip="delete" class="delete_listing btn-xs btn btn-danger" data-href="'.base_url().'inventory/delete_reports/'.$lotdetails["id"].'"><i class="fa fa-trash"></i></a>';
											// 	}
											?>
                                    </td> -->
                                </tr>
                                <?php }}?>
                            </tbody>
                        </table>
	<?php #echo $this->pagination->create_links(); ?>	
	</div>
</div>
<script>
var measurementUnits = '';
</script>
