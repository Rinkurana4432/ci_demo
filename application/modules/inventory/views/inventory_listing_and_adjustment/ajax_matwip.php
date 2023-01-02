<?php 
 $this->companyId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
$i = 0;

if (!empty($subTypeArray)) {
    foreach ($subTypeArray as $subType_listing) {
        #pre($subType_listing);
        $materialTypeName = getNameById('material_type', $subType_listing['material_type_id'], 'id');
        $subtypeArray = array();
        $CombinedArray = array();
?>
					<table id="" class="table table-striped table-bordered user_index" data-id="user" border="1">
						<thead>
						<tr>
						<th>Product Sub-type With Product</th>
						<th>Quantity(Closing Balance)</th>
						<th>UOM</th>
					   <th>Location</th>
						 <th>View Adjustment</th>
						<th style="width: 50px !important;">Action</th>
						</tr>
						</thead>
					<tbody>
					<?php
        //pre($subType_listing);
        foreach ($subType_listing['material_detail'] as $key => $subType) {
            $subtypeArray[] = $subType['sub_type'];
            $uniqeArrayvalue = array_unique($subtypeArray);
            //pre($subType);
            foreach ($uniqeArrayvalue as $unique_value) {
                if ($unique_value == $subType['sub_type']) {
                    $CombinedArray[$subType["sub_type"]]['sub_type'] = $subType["sub_type"];
                    $CombinedArray[$subType["sub_type"]]['material'][] = array('material_name' => $subType["material_name"], 'material_name_id' => $subType["material_name_id"], 'uom' => $subType['uom'], 'location' => $subType['location']);
                }
            }
        }
        $k = 0;
        foreach ($CombinedArray as $combinedValue) {
            //pre($combinedValue);
            if ($combinedValue['sub_type'] != '') {
                echo "<tr class='parent' id='" . $k . "'>
								<td colspan='6'><span class='btn btn-default'><strong>" . $combinedValue['sub_type'] . "</strong></span></td>
								</tr>";
            } elseif ($combinedValue['sub_type'] == '') {
                echo "<tr class='parent' id='" . $k . "'>
								<td colspan='6'><span class='btn btn-default'><strong>Material</strong></span></td>
								</tr>";
            }
            $j = 0;
            foreach ($combinedValue['material'] as $key => $mat_detail) {
                $ww = getNameById('uom', $mat_detail['uom'], 'id');
                $uom = !empty($ww) ? $ww->ugc_code : '';
                $sum = 0;
                $sum1 = 0;
                $loc = "";
                 $out1 = 0;
                foreach ($mat_detail['location'] as $ert) {
                    $sum+= $ert['qty'];
                }

                $hj = getNameById_mat('work_in_process_material',$mat_detail['material_name_id'],'material_id');

                #pre($hj);
									if(!empty($hj)){ 
                                            foreach ($hj as $ert1){
                                                if(empty($ert1['material_id'])){
                                                    $gh = "";
                                                   #$gh =  $er
                                                }
                                                else{
                                                    $gh = $ert1['material_id'];
                                                    $sum1 += $ert1['quantity']; 
                                                    $loc = $ert1['location'];
                                                     $out1 += $ert1['output']; 
                                                }
                                            }
                                	}   

                                	#pre($gh);

                            #pre($gh);
                           # pre($mat_detail['material_name_id']);
                if (($sum > 0 || $sum < 0) && ((!empty($gh) && $mat_detail['material_name_id'] == $gh))){
                   # pre($ert1);
                	updateclosing_balace($sum,$mat_detail['material_name_id'],$this->companyId);
                    echo "<tr class='MainRow child_" . $k . "' id='index_" . $j . "'>
									<td> <a target='_BLANK' href='material_edit?id=".$mat_detail['material_name_id']."' class='' data-tooltip='View Product' data-href=''>".$mat_detail['material_name']."</a></td>
									<td class='qty'>" . ($sum1 - $out1) . "</td>

									<td>" . $uom . "</td>
								
							<td class='all-location'>
						     <h6>See all locations</h6>
                               <div class=' see-all-location '>	
									<table id='' class='table table-striped table-bordered user_index' data-id='user' border='1' cellpadding=''>
										<thead>
												<tr>
													<th>Location</th>
												    <!--	<th>Area</th>
													<th>Rack no</th>-->
											         <!--<th>Qty</th>-->
													<th>Uom</th>
													<!--<th class='stock_check'>Physical Stock</th>
													 <th class='stock_check'>Balance</th> -->
												</tr>
											</thead>
											<tbody>";
                    $n = 0;
                    #$loc[] = array();
           # if(array_unique($hj)){
                    $uniqueArray =  array();
                    foreach ($hj as $key1) {
                        #pre($key1);
                        if (!in_array($key1['location'], $uniqueArray)) {
                        $ww = getNameById('uom', $key1['uom'], 'id');
                        $uom = !empty($ww) ? $ww->ugc_code : '';
                        $locationName = getNameById('company_address', $key1['location'], 'id');
                        //pre($locationName->location);
                        echo "<tr class='locRow' id='chkIndex_" . $n . "'>
														<td>" . (!empty($locationName->location) ? $locationName->location : '') . "<input type='hidden' class='locId' value='" . $key1['location'] . "'></td>
                                                      <!--  <td class=''>" . $key1['quantity'] . "<input type='hidden' class='locQty' value='" . $key1['quantity'] . "'</td>-->
														<td>" . $uom . "</td>

														<!-- <td class='physicalStock stock_check only-numbers' contenteditable = 'true' id='physical_stock'  placeholder='Value And Enter...' >" . ""/*$locationData['physical_stock'] */. "</td>
														 <td class='cal stock_check'>" . ""/*$locationData['balance']*/ . "</td> -->
						
                        								</tr>";
                        
                        
                        $uniqueArray[] = $key1['location'];
                        $n++;
                        #exit;
                       }
                      }
                    echo "</tbody>
										
										</table>
										</div>
										
									</td>";
?>
								<td class="view-buttons"><?php
                              echo  '<a target="_BLANK"href="'.base_url().'inventory/inventory_adjustmentListing_view?id='.$mat_detail['material_name_id'].'"   data-href="" style="float:unset;"><h5><i class="fa fa-eye"></i> view </h5></a>'
                                    ?>
								</td>
							
										<td class="hidde action"><i class="fa fa-cog"></i>
                                            <div class="on-hover-action"  <?php //if(empty($locationData)){echo 'disabled';}
                     ?> >
                                                <a onclick="invet_action_get(event,this)" value="Move" id="<?php echo $mat_detail['material_name_id']; ?>" data-id="move" data-materialType-id="<?php echo $subType_listing["material_type_id"]; ?>" data-mat-name="<?php echo $mat_detail['material_name']; ?>" >Move</a>
                                          
                                                <a onclick="invet_action_get(event,this)" value="Scrap" id="<?php echo $mat_detail['material_name_id']; ?>" data-id="scrap" data-materialType-id="<?php echo $subType_listing["material_type_id"]; ?>" data-mat-name="<?php echo $mat_detail['material_name']; ?>">Scrap</a>
                                          
                                               <a onclick="invet_action_get(event,this)" value="Rejected" id="<?php echo $mat_detail['material_name_id']; ?>" data-id="Rejected" data-materialType-id="<?php echo $subType_listing["material_type_id"]; ?>" data-mat-name="<?php echo $mat_detail['material_name']; ?>">Rejected Quantity</a> 
											   
                                                <a onclick="invet_action_get(event,this)" value="Consumed" id="<?php echo $mat_detail['material_name_id']; ?>" data-id="consumed" data-materialType-id="<?php echo $subType_listing["material_type_id"]; ?>" data-mat-name="<?php echo $mat_detail['material_name']; ?>" data-uom ="<?php echo $mat_detail['uom']; ?>">Consumed</a>
                                          
                                                <a onclick="invet_action_get(event,this)" value="book" id="<?php echo $mat_detail['material_name_id']; ?>" data-id="half_full_book" data-materialType-id="<?php echo $subType_listing["material_type_id"]; ?>" data-mat-name="<?php echo $mat_detail['material_name']; ?>" data-mat-type-name="<?php //echo $materialTypeName->name;
                                                ?>" data-uom ="<?php echo $mat_detail['uom']; ?>">Half/Full Book</a>
                                          
                                                <a onclick="invet_action_get(event,this)" value="material_conversion" id="<?php echo $mat_detail['material_name_id']; ?>" data-id="material_conversion" data-materialType-id="<?php echo $subType_listing["material_type_id"]; ?>" data-mat-name="<?php echo $mat_detail['material_name']; ?>" data-mat-type-name="<?php //echo $materialTypeName->name;
                                                ?>" data-uom ="<?php echo $mat_detail['uom']; ?>" data-uomname = "<?php echo $uom; ?>" data-qty="<?php echo $sum; ?>">Material Conversion</a>
                                            </select>
											</div>
                                        </td> 
						<?php echo "</tr>";
                }
            }
            $j++;
            $k++;
        }
?>
					
					</tbody>
					</table>
				<?php
        $i++;
    }
} ?>
