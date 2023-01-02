                                <!-- <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset" ></a> -->
   <div class="x_content">
   
    <!-- <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm print_clsss" id="bbtn">Print</button> -->
     <div id="print_div_content">
	
			
            <!---------- datatable-buttons ------------->
<table id='' class='table table-striped table-bordered user_index' data-id='user' border='1' cellpadding='3'>
										<thead>
												<tr>
													<th>Location</th>
													<!--th>Area</th>
													<th>Rack no</th-->
													<th>Qty</th>
													<th>Uom</th>
													<th class='stock_check'>Physical Stock</th>
													<th class='stock_check'>Balance</th>
												</tr>
											</thead>
											<tbody>
											
											<!--td>" . $locationData['area'] . "</td>
											<td>" . $locationData['rack_no'] . "</td-->
				<?php		
				
                    $n = 0;
                    foreach ($mat_detail['location'] as $key1 => $locationData) {
                        #pre($locationData);
                        $ww = getNameById('uom', $locationData['Qtyuom'], 'id');
                        $uom = !empty($ww) ? $ww->ugc_code : '';
                        $locationName = getNameById('company_address', $locationData['location'], 'id');
                        //pre($locationName->location);
                        echo "<tr class='locRow' id='chkIndex_" . $n . "'>
														<td>" . (!empty($locationName->location) ? $locationName->location : '') . "<input type='hidden' class='locId' value='" . $locationData['location'] . "'></td>
														
														<td class=''>" . $locationData['qty'] . "<input type='hidden' class='locQty' value='" . $locationData['qty'] . "'</td>
														<td>" . $uom . "</td>
														<td class='physicalStock stock_check only-numbers' contenteditable = 'true' id='physical_stock'  placeholder='Value And Enter...' >" . $locationData['physical_stock'] . "</td>
														<td class='cal stock_check'>" . $locationData['balance'] . "</td>
														</tr>";
                    }
                    $n++;
				?>	
                  
		</tbody>                   
	</table>
    </div>
 </div>
         
   