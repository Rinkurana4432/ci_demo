<div id="print_divv">
<div class="x_content" id="">

	<div class="col-md-7 col-sm-7 col-xs-12">
		<div class="product-image Material">
			<?php
			if(!empty($materialView)){
			$imagePath = $materialView->featured_image;
			
			
				if(!empty($materialView->featured_image) && $materialView->featured_image != ''){
					echo '<img src="'.base_url().'assets/modules/inventory/uploads/'.$materialView->featured_image.'"/>';
				}else{
					echo '<img src="'.base_url().'assets/uplodimg/noimage.jpg" />';
					
				}
			}
			?>
		</div>
		<div class="product_gallery">
			<?php
			if(!empty($imageUploads)){
				foreach($imageUploads as $Uploads){
				$ext = pathinfo($Uploads['file_name'], PATHINFO_EXTENSION);
				if($ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg' || $ext == 'png' || $ext == 'ico'){
				echo '<div class="col-md-3">
					<div class="image view view-first">
					<img style="width: 100%; display: block; border:2px 2px 2px solid;" src="'.base_url().'assets/modules/inventory/uploads/'.$Uploads['file_name'].'" alt="image" width="60px"  height="60px"/>
					</div>
					</div>';
				}
				}
			}
			?>
		</div>
	</div>
	<?php  ?>
	<div class="col-md-5 col-sm-5 col-xs-12" style="border:0px solid #e5e5e5;">
		<h2 class="prod_title"><?php if(!empty($materialView)) echo $materialView->material_name; ?>&nbsp; &nbsp;</h2>
		   <h4>Material Code:&nbsp;<small><?php if(!empty($materialView)) echo $materialView->material_code; ?></small></h4>

			<h4>Specification:&nbsp;<small><?php if(!empty($materialView)) echo $materialView->specification; ?></small></h4>
				<div class="">
					<h2>HSN code:&nbsp;<small><?php 
					
					if(!empty($materialView)){
							$hsn = getNameById('hsn_sac_master',$materialView->hsn_code,'id');
						echo $hsn->hsn_sac;} ?></small></h2>
				</div>
				<div class="">
					<?php
						if(!empty($material_type)){
						$mat = getNameById('material_type',$materialView->material_type_id,'id');
						}
					?>
					<h2>Type:&nbsp;<small><?php if(!empty($mat)){echo $mat->name; }?></small></h2>
				</div>

				<div class="">
					<?php
						$id = $materialView ->id;
						$matTags = get_tags_html($id,'material');
					?>
					<h2 class="cls_display_none">Tags:&nbsp;<small><?php echo $matTags; ?></small></h2>
					<?php
						if(!empty($material_type)){
						$lotNumber = getNameById('lot_details',$materialView->id,'mat_id');
						}
					?>
					
				</div>

				<div class="">
					<div class="product_price">
						<h3>Cost price:<span class="price-tax"><?php if(!empty($materialView)) echo $materialView->cost_price; ?></span></h3>
						<h3>Sales price:<span class="price-tax"><?php if(!empty($materialView)) echo $materialView->sales_price; ?></span></h3>
						<h5 style="color:#73879C;font-size: 18px;">Tax:<span class="price-tax"><?php if(!empty($materialView)) echo $materialView->tax; ?>%</span></h5>
						</br>
					</div>
				</div>
				<div class="product_social">
					<ul class="list-inline">
					<?php
						if(!empty($materialView) && $materialView->facebook!='')
							echo '<li><a href="'.$materialView->facebook.'"><i class="fa fa-facebook-square"></i></a></li>';
						if(!empty($materialView) && $materialView->twitter!='')
							echo '<li><a href="'.$materialView->twitter.'"><i class="fa fa-twitter-square"></i></a></li>';
						if(!empty($materialView) && $materialView->instagram!='')
							echo '<li><a href="'.$materialView->instagram.'"><i class="fa fa-envelope-square"></i></a></li>';
						if(!empty($materialView) && $materialView->linkedin!='')
							echo '<li><a href="'.$materialView->linkedin.'"><i class="fa fa-rss-square"></i></a></li>';
					?>
					</ul>
				</div>
	</div>

	<div class="x_content">
        <div class="list-tab tab-list" role="tabpanel" data-example-id="togglable-tabs">
			<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Details</a></li>
				<li role="presentation"><a href="#tab_content2" id="home-tab2" role="tab" data-toggle="tab" aria-expanded="true">Purchase History</a></li>
				<li role="presentation"><a href="#tab_content3" id="home-tab2" role="tab" data-toggle="tab" aria-expanded="true">Selling Price History</a></li>
			</ul>
			<div id="myTabContent" class="tab-content">
			    <!--h3>Product Purchase details</h3-->
				<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
				    <ul class="col-sm-3 col-xs-12">
					<h4>Details :</h4>
					<table class='table table-striped table-bordered user_index'>
					<thead>
					       <tr>
						        <th>Route</th>
						        <th>Closing Balance</th>
						        <th class="cls_display_none">Lead Time</th>
						   </tr>
					</thead>
					<tbody>
					<tr>
					    <td>
							<?php
							
							if(!empty($materialView))
								$sale_purchase = (($materialView->sale_purchase != '')?(json_decode($materialView->sale_purchase)):'');
							if($materialView->sale_purchase != ''){
								echo "Sale ";
							}
							
							if($materialView->route != ''){
								echo "  Purchase";
							}
							 // if (in_array("Sale", $materialView->sale_purchase)) {
									// echo "Sale";
								// }else if(in_array("Purchase", $materialView->route)){
									// echo "Purchase";
								// }
				?>

						</td>
						<?php
							#pre($materialView->id);
						$yu = getNameById_mat('mat_locations',$materialView->id,'material_name_id');

						#pre($yu);
						$sum = 0;

						 if(!empty($yu)){

						 	foreach ($yu as $ert) {

						 	$sum += $ert['quantity'];

						 	}
						 }

						 else{ echo "N/A";}
						?>
						<td><?php echo $sum;?>
					</td>
						<td class="cls_display_none"><?php if(!empty($materialView)) echo $materialView->lead_time."&nbsp;&nbsp;".$materialView->time_period; ?></td>
						</tr>
					<tbody>
					</table>
					 </ul>
					<ul class="col-sm-6 col-xs-12">
					<h4>Storage Location:</h4>
						<table id='' class='table table-striped table-bordered user_index' data-id='user' border='1' cellpadding='3'>
										<thead>
												<tr>
													<th>Location</th>
													<!--th>Area</th>
													<th>Rack no</th-->
													<th>Qty</th>
													<th>Uom</th>
												</tr>
											</thead>
											<tbody>
											
					<?php
					// <td>" . $locationData['RackNumber'] . "</td>
                    $n = 0;
                    foreach ($locations as $locationData) {
                       // pre($locationData);
                        $ww = getNameById('uom', $locationData['Qtyuom'], 'id');
                        $uom = !empty($ww) ? $ww->ugc_code : '';
                        $locationName = getNameById('company_address', $locationData['location_id'], 'id');
                        //pre($locationName->location);
                        echo "<tr class='locRow' id='chkIndex_" . $n . "'>
							<td>" . (!empty($locationName->location) ? $locationName->location : '') . "<input type='hidden' class='locId' value='" . $locationData['location_id'] . "'></td><td class=''>" . $locationData['quantity'] . "<input type='hidden' class='locQty' value='" . $locationData['quantity'] . "'</td>
							<td>" . $uom . "</td>
							</tr>";
                    }
                    $n++;
                    echo "</tbody>
										</table>";
					?>
					</ul>
				</div>
				<div role="tabpanel" class="tab-pane fade " id="tab_content2" aria-labelledby="home-tab" style="padding: 22px 0px;">
				<div class="col-sm-8 col-xs-12">
				<table class="table table-striped table-bordered user_index">

                   <thead>
				        <tr>
						    <th>S.no. </th>
						    <th>Last Purchase </th>
						    <th>Quantity </th>
						    <th>Total Amount</th>
						</tr>
				   </thead>
				   <tbody>
					 <?php
						if(!empty($materialhistory)){
							$sno= 1;
							foreach($materialhistory as $val){
								
								$mat_qty = json_decode($val->material_name);
								@$qtty = array_sum(array_column($mat_qty,'quantity'));
								// $change_status_dtl = json_decode($val['status']);
								// $payment_dtl = $change_status_dtl->Payment;
								$paymentAndQTY = json_decode($val['material_name']);
								// pre();
								$date_created_complete = date("d-M-Y", strtotime($val['created_date']));
								$Total_amount = array_sum(array_column($payment_dtl,'amount'));

								if($Total_amount != ''){
									$amount = $Total_amount;
								}else{
									$amount = 'N/A';
								}
					?>           <tr>
									<td><?php echo $sno; ?></td>
									<td><?php echo $date_created_complete; ?></td>
									<td><?php echo $paymentAndQTY[0]->quantity; ?></td>
									<td><?php echo $paymentAndQTY[0]->price; ?> </td>
								</tr>
							<?php
												$sno++;

										}
									}else{

										echo '<tr><td colspan="4"><span>No Data Available</span></td></tr>';
									}

								?>
						<tbody>
				</table>
				</div>
				</div>
				<div role="tabpanel" class="tab-pane fade " id="tab_content3" aria-labelledby="home-tab" style="padding: 22px 0px;">
				<div class="col-sm-8 col-xs-12">
				
				<table class="table table-striped table-bordered user_index">
	                     <thead>
					        <tr>
							    <th>S.no.</th>
							    <th>Price From</th>
							    <th>Price To</th>
							    <th>User Name</th>
							    <th>Date</th>
							</tr>
					   </thead>
					  <tbody>
					  	<?php 
					  	$serialNo = 1;
					  	if(!empty($materialSalesPrice)){
					  	foreach ($materialSalesPrice as $materialSalesPricevalue) {
					  		$created_by = ($materialSalesPricevalue['created_by']!=0)?(getNameById('user_detail',$materialSalesPricevalue['created_by'],'u_id')->name):'';
					  	?>
						 <tr>
						   <td><?php echo $serialNo; ?></td>
						   <td><?php echo $materialSalesPricevalue['old_sales_price']; ?></td>
						   <td><?php echo $materialSalesPricevalue['new_sales_price']; ?></td>
						   <td><?php echo $created_by; ?></td>
						   <td><?php echo date("j F , Y h:i:s", strtotime($materialSalesPricevalue['created_date'])); ?></td>
						 </tr>	
						 <?php 
						 $serialNo++;
					}
							
						}else{
							?>
							<?php
							echo '<tr><td colspan="5" class="text-center"><span>No Data Available</span></td></tr>';
						}
					  	 ?>					
					</tbody>
	          </table>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<center>
<button type="button" class="btn edit-end-btn" data-dismiss="modal" aria-label="Close">Close</button>
	<!--button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button-->
</center>
