<table id="InventoryListTable" class="table table-striped table-bordered display">
	<thead>
		<tr>
			<th>Material Code</th> 
			<th>Material Name</th>
			<th>Material Type</th>
			<th>Material Sub Type</th>
			<!-- <th>Sale Price </th> -->
			<th>Purchase Price </th>
			<th>Quantity <br> (Closing Balance)</th>
			<th>Sub Total</th>
			<th>Sub Total Purchase Price And Closing Balance</th>
			<th>UOM</th>
			<!--th>Reserved Quantity</th-->
			<th>Availble Quantity</th>
			<th>View</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody class="InventoryListTbody">
	<?php
	setlocale(LC_MONETARY, 'en_IN');
	//updateclosing_balace($sumafd,$rows['material_name_id'],$this->companyId);
 
	if(!empty($materailListingData)){ 
		$overAllclosing_balance = $totalSalePrice = $subTotalSalePriceClosingBall = $totalcostprice = $subTotalcost_priceClosingBall=0;				
		foreach($materailListingData as $rows){
			 
			  $materialId = getNameById('material', $rows['material_id'], 'id');
				$getuom = getNameById('uom', $rows['uom'], 'id');
				$uom = !empty($getuom) ? $getuom->ugc_code : '';
				$totalSalePrice +=$materialId->sales_price;
				$totalcostprice +=$materialId->cost_price;
			
				$sum = 0;
				foreach ($rows['location'] as $ert){
					$sum+= !empty($ert['qty']) ? $ert['qty']:0;
				}
				//$closing_balance = $rows['closing_balance']; 			
				$closing_balance = $rows['inventoryflowClosingblance']; 			
			
				#if quentity is not equal 0 then
				#if($sum > 0){
				
					//reserved quentity
					$rsvQty = 0;
					if(!empty($rows['reserved_material'])){
						$tempArr = array_unique(array_column($rows['reserved_material'], 'id'));
						$reserved_material = array_intersect_key($rows['reserved_material'], $tempArr); 					
						foreach($reserved_material as $rqty) {
							// pre($rqty);
							$rsvQty += !empty($rqty['quantity']) ? $rqty['quantity']:0;
						}
					}
					
					// pre($rsvQty);
					// pre($closing_balance);
					//$overAllclosing_balance += $sum;
					$overAllclosing_balance += $closing_balance;
					$avaible_balance = $closing_balance - $rsvQty; 
					$subTotalSalePriceClosingBall += ($materialId->sales_price) * ($closing_balance);
					$subTotalcost_priceClosingBall += ($materialId->cost_price) * ($closing_balance);
		?>
		<tr>
			<td><?php echo $materialId->material_code; ?></td>  
			<td><?php echo wordwrap($rows['material_name'],15,"<br>\n"); ?></td>   
			<td><?php echo $rows['material_type_name']; ?></td>
			<td><?php echo $rows['sub_type']; ?></td>
			<!-- <td class="salePrice"><?php echo $materialId->sales_price; ?></td> -->
			<td class="costPrice"><?php echo $materialId->cost_price; ?></td>
			<td  class="pageTotal"><?php echo $closing_balance; ?></td>
			<td class="subTotalSalePriceClosingBall"><?php echo ($materialId->sales_price) * ($closing_balance); ?></td>
			<td class="subTotalCostPriceClosingBall"><?php echo ($materialId->cost_price) * ($closing_balance); ?></td>
			<td><?php echo $uom; ?></td>
			<!--td><?php //echo $rsvQty; ?></td-->
			<td><?php echo $avaible_balance; ?></td>
			<td>
			<?php
				#echo  '<a target="_BLANK"href="'.base_url().'inventory/inventory_adjustmentListing_view?id='.$rows['material_name_id'].'" class="btn btn-delete btn-xs" data-tooltip="View Stock" data-href="" ><i class="fa fa-eye"></i>View Stock</a>';

				#echo  '<a target="_BLANK"href="'.base_url().'inventory/view_lot_report?id='.$rows['material_name_id'].'" class="btn btn-delete btn-xs" data-tooltip="View Lot" data-href="" ><i class="fa fa-eye"></i>View Lot</a>';

				#echo  '<a target="_BLANK"href="'.base_url().'inventory/mat_availbility?id='.$rows['material_name_id'].'" class="btn btn-delete btn-xs" data-tooltip="View Availbility" data-href="" ><i class="fa fa-eye"></i>View Availbility</a>';
				
				#echo  '<a target="_BLANK"href="'.base_url().'inventory/view_inventory_adjustmentHistory?id='.$rows['material_name_id'].'" class="btn btn-delete btn-xs" data-tooltip="Transaction History" data-href="" ><i class="fa fa-eye"></i>Transaction History</a>';
				
				echo  '<a target="_BLANK"href="'.base_url().'inventory/view_inventory_adjustmentHistory?id='.$rows['material_name_id'].'" class="btn btn-delete btn-xs" data-tooltip="View Details" data-href="" ><i class="fa fa-eye"></i>View Details</a>';
				?>
			</td>
			
			<td>
				<select class="form-control action"  onchange="getAction(event,this)">
				<option>Action</option>
					<option value="Move" id="<?php echo $rows['material_name_id']; ?>" data-id="move" data-materialType-id="<?php echo $rows["material_type_id"]; ?>" data-mat-name="<?php echo $rows['material_name']; ?>" >Move</option>
			  
					<option value="Scrap" id="<?php echo $rows['material_name_id']; ?>" data-id="scrap" data-materialType-id="<?php echo $rows["material_type_id"]; ?>" data-mat-name="<?php echo $rows['material_name']; ?>">Scrap</option>
			  
					<option value="Consumed" id="<?php echo $rows['material_name_id']; ?>" data-id="consumed" data-materialType-id="<?php echo $rows["material_type_id"]; ?>" data-mat-name="<?php echo $rows['material_name']; ?>" data-uom ="<?php echo $rows['uom']; ?>">Consumed</option>
			  
					<!--option value="book" id="<?php echo $rows['material_name_id']; ?>" data-id="half_full_book" data-materialType-id="<?php echo $rows["material_type_id"]; ?>" data-mat-name="<?php echo $rows['material_name']; ?>" data-mat-type-name="<?php //echo $rows['material_type_name'];
					?>" data-uom ="<?php //echo $rows['uom']; ?>">Half/Full Book</option-->
			  
					<option value="material_conversion" id="<?php echo $rows['material_name_id']; ?>" data-id="material_conversion" data-materialType-id="<?php echo $rows["material_type_id"]; ?>" data-mat-name="<?php echo $rows['material_name']; ?>" data-mat-type-name="<?php echo $rows['material_type_name'];
					?>" data-uom ="<?php echo $rows['uom']; ?>" data-uomname = "<?php echo $uom; ?>" data-qty="<?php echo $sum; ?>">Material Conversion</option>
				</select>
			</td> 
			
		</tr>
	<?php #}
}} ?>
	</tbody>
</table>
  <table border="1" class="table table-striped table-bordered">
    <tr>
      <td style="width: 34%;float: left;"><b>Total Closing Balance Number : </b></td>
      <td id="Grandtotal"><b><?=money_format('%!i',(int)$overAllclosing_balance);?></b></td>
      <td></td>
      <td></td>
    </tr>
	 
     <!-- <tr>
      <td style="width: 34%;float: left;"><b>Grand Total Sale Price And Closing Balance (As on <?php if(!empty($stopDate)){ echo $stopDate; } else { echo date('d-m-Y');} ?>):</b></td>
      <td id="GrandTotalSalePriceClosingBall"><b><?= money_format('%!i',(int)$subTotalSalePriceClosingBall);?></b></td>
      <td></td>
      <td></td>
    </tr> -->
    <tr>
      <td style="width: 34%;float: left;"><b>Total stock value (As on <?php if(!empty($stopDate)){ echo $stopDate; } else { echo date('d-m-Y');} ?>):</b></td>
      <td id="GrandTotalCostPriceClosingBall"><b><?= money_format('%!i',(int)$subTotalcost_priceClosingBall);?></b></td>
      <td></td>
      <td></td>
    </tr>

<?php 	
	if(!empty($materailListingData_Tilldate)){ 
		$overAllclosing_balance1 = $totalSalePrice1 = 0;
		$subTotalSalePriceClosingBal_T = $totalcostprice1 = $subTotalcost_priceClosingBal_T=0;
		foreach($materailListingData_Tilldate as $rows){
			$materialId_t = getNameById('material', $rows['materialId'], 'id');							
			$totalSalePrice1 +=$materialId_t->sales_price;
			$totalcostprice1 +=$materialId_t->cost_price;
		
			$sum1 = 0;
			foreach ($rows['location'] as $ert){
				$sum1 += !empty($ert['qty']) ? $ert['qty']:0;
			}
			$closing_balance1 = $rows['closing_balance']; 			
		
			#if quentity is not equal 0 then
			if($sum1 > 0){

				//reserved quentity
				$rsvQty1 = 0;
				if(!empty($rows['reserved_material'])){
					$tempArr1 = array_unique(array_column($rows['reserved_material'], 'id'));
					$reserved_material1 = array_intersect_key($rows['reserved_material'], $tempArr1); 					
					foreach($reserved_material1 as $rqty) {
						$rsvQty1 += !empty($rqty['quantity']) ? $rqty['quantity']:0;
					}
				}
				$overAllclosing_balance1 += $sum1;
				$avaible_balance1 = $closing_balance1 - $rsvQty1; 
				$subTotalSalePriceClosingBal_T += ($materialId_t->sales_price) * ($closing_balance1);
				$subTotalcost_priceClosingBal_T += ($materialId_t->cost_price) * ($closing_balance1);
 			}
 		}
 	} 	
 	/*
?>
    <tr>
      <td style="width: 34%;float: left;"><b>Grand Total Sale Price And Closing Balance (As on <?php echo $stopDate; ?>):</b></td>
      <td id="GrandTotalSalePriceClosingBall"><b><?= money_format('%!i',(int)$subTotalSalePriceClosingBal_T);?></b></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td style="width: 34%;float: left;"><b>Grand Total Purchase Price And Closing Balance (As on <?php echo $stopDate; ?>):</b></td>
      <td id="GrandTotalCostPriceClosingBall"><b><?= money_format('%!i',(int)$subTotalcost_priceClosingBal_T);?></b></td>
      <td></td>
      <td></td>
    </tr>
  <?php */ ?>
</table> 