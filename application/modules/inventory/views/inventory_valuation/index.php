<style type="text/css">	
   .invRadio span {
   padding: 10px;
   }
   .invRadioContainer {
   width: auto;
   display: table;
   margin-left: 348px;
   float: left;
   margin-top: 10px;
   }
   .invRadio span input[type="radio"] {
   margin-right: 6px;
   }
   .invRadioContainer .invRadio {
   float: left;
   margin: 0px 5px;
   }
   .invRadioContainer .invRadio label {
   width: auto;
   }
</style>
<div class="x_content">
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
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
      </div>
   </div>
   <div class=" col-md-12 export_div">
      <div class="invRadioContainer">
            <div class="invRadio">
                  <label for="icp">Inventory Cost/Sale Price</label>
                  <input type="radio" name="accordingToInventory" onclick="window.location='<?= base_url('inventory/inventory_valuation') ?>';" 
                        value="1" id="icp" <?= (!$checkRadio)?'checked':''; ?>>
            </div>
            <div class="invRadio">
                  <label for="lsp">Last Sale Price</label>
                  <input type="radio" name="accordingToInventory" onclick="window.location='<?= base_url('inventory/inventory_valuation/2') ?>';" 
                           value="2" id="lsp" <?= ($checkRadio == 2 )?'checked':''; ?> >
            </div>
            <div class="invRadio">
                  <label for="lpp">Last Purchase Price</label>
                  <input type="radio" name="accordingToInventory" onclick="window.location='<?= base_url('inventory/inventory_valuation/3') ?>';" 
                     id="lpp" <?= ($checkRadio == 3)?'checked':''; ?>> 
            </div>
      </div>   
         
      <div class="btn-group"><button class = "btn  btn-success addBtn save" style="float:right;">Save</button></div>
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
                     <th scope="col">Product Type</th>
                     <th scope="col">Total</th>
                     <th scope="col">Product Code</th>
                     <th scope="col">Product</th>
                     <th scope="col">Cost Price</th>
                     <th scope="col">Sales Price</th>
                     <th scope="col">Quantity</th>
                     <th scope="col">Product Evaluation</th>
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
                     			foreach($unique_material_type_id as $mat_type_id){
                     				$costPrice  = 0;
                     				$sales_price  = 0;
                     				foreach($inventory_valuation as $inventoryData){
                     					#pre($inventoryData);
                     					if($mat_type_id == $inventoryData['material_type_id']){
                     						$CostPricePerItem = $inventoryData['cost_price'];
                     						$SalePricePerItem = $inventoryData['sales_price'];
                     						$QtyPerItem = getclosingbb($inventoryData['id']);
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
                     						$valuationArray[$i]['closing_balance'][] = getclosingbb($inventoryData['id']);
                     						$valuationArray[$i]['uom'][] = $inventoryData['uom'];		
                     						//$EvaluationArray[$i][$inventoryData['material_type_id']]['cooco'][] += $costPrice;	
                     						//$EvaluationArray[$i]['cost_price'][] += $costPrice;
                     						//$EvaluationArray[$inventoryData['material_type_id']]['costPrice'] += $costPrice;					
                     					}								
                     					
                     				}
                     				$i++;
                     			}
                     			#pre($valuationArray);
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
                                    <td data-label='Product Type:' rowspan="<?php echo $countMat; ?>"><?php if(!empty($materialType)){echo $materialType->name;} ?></td>
                                    <td data-label='Total:' rowspan="<?php echo $countMat; ?>"><?php echo number_format($TotalvaluationCost);?></td>
                                    <?php for ($i = 0; $i < $countMat; $i++){ ?>
                                    <td data-label='Product Code:'><?php echo $matCode[$i];?></td>
                                    <td data-label='Product:'><a href="javascript:void(0)" id="<?php echo $materialId[$i]; ?>" data-id="material_view" class="inventory_tabs"><?php echo $materialname[$i]; ?></a></td>
                                    <td data-label='Cost Price:' contenteditable = 'true' class="only-numbers cp" id="<?php echo $materialId[$i]; ?>"><?php echo $CostPrice[$i];?></td>
                                    <td data-label='Sales Price:' contenteditable = 'true' class="only-numbers sp" id="<?php echo $materialId[$i]; ?>" ><?php echo $SalePrice[$i];?></td>
                                    <td data-label='Quantity:'><?php echo getclosingbb($materialId[$i]);//echo $qty[$i];?></td>
                                    <td data-label='Product Evaluation:'><?php echo $valuationPerMaterial[$i];?></td>
                                 </tr>
                                    <?php  
                                    }
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
                     <th scope="col">Type of Material</th>
                     <th scope="col">Total</th>
                     <th scope="col">Material Code</th>
                     <th scope="col">Material</th>
                     <th scope="col">Cost Price</th>
                     <th scope="col">Sales Price</th>
                     <th scope="col">Quantity</th>
                     <th scope="col">Material Evaluation</th>
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
                     						$Qty_Per_Item = getclosingbb($inventory_Data['id']);
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
                     						$valuation_zero_Array[$j]['closing_balance'][] = getclosingbb($inventory_Data['id']);
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
                                    <td data-label='Type of Material:' rowspan="<?php echo $count_Mat; ?>"><?php if(!empty($materialType))echo $materialType->name; ?></td>
                                    <td data-label='Total:' rowspan="<?php echo $count_Mat; ?>"><?php echo number_format($Total_valuationCost);?></td>
                                    <?php for ($k = 0; $k < $count_Mat; $k++){ ?>
                                    <td data-label='Material Code:'><?php echo $matCode[$k];?></td>
                                    <td data-label='Material:'><a href="javascript:void(0)" id="<?php echo $materialId[$k]; ?>" data-id="material_view" class="inventory_tabs"><?php echo $materialname[$k]; ?></a></td>
                                    <td data-label='Cost Price:' contenteditable = 'true' class="only-numbers cp" id="<?php echo $materialId[$k]; ?>"><?php echo $CostPrice[$k];?></td>
                                    <td data-label='sale Price:' contenteditable = 'true' class="only-numbers sp" id="<?php echo $materialId[$k]; ?>" ><?php echo $SalePrice[$k];?></td>
                                    <td data-label='Quantity:'><?php echo getclosingbb($materialId[$k]);//echo $qty[$k];?></td>
                                    <td data-label='Material Evaluation:'><?php echo $valuation_Per_Material[$k];?></td>
                                 </tr>
                  <?php  	}
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