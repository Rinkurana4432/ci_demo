<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id;
$mvid = isset($_GET['id']) ? $_GET['id']:'';
?>

		<form action="<?php echo base_url() ?>inventory/update_variant_materials" method="post" id="variantMaterialsForm" enctype="multipart/form-data" >    
			<div class="col-md-12">
    		    <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
                    <div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="item_code">Item Code</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-7 col-xs-12" id="item_code" name="item_code" value="<?php echo !empty($variants->item_code) ? $variants->item_code:''; ?>" placeholder="Enter Item Code" readonly="readonly"></div>
                    </div>

			        <div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="name">Material name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="hidden" name="id" value="<?php echo !empty($variants->id) ? $variants->id:''; ?>">    
                        <input type="text" id="temp_material_name" name="temp_material_name" value="<?php echo !empty($variants->temp_material_name) ? $variants->temp_material_name:''; ?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Material name" required="required">
                        </div>
                    </div>
                    
                    <?php
                    $material_data = !empty($variants->temp_material_data) ? json_decode($variants->temp_material_data):'';
                    ?>
                    
				    <div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="type">Material Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible materialTypeId" id="material_type_id" name="material_type_id" required="required" data-id="material_type" data-key="id" data-fieldname="name" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" onchange="ChangePrefix_and_subType();">
                           <option value="">Select Option</option>
                           <?php
                                if(!empty($material_data->material_type_id)){
                                   $material_type = getNameById('material_type',$material_data->material_type_id,'id');
                                   echo '<option value="'.$material_data->material_type_id.'" selected>'.$material_type->name.'</option>';
                                }
                            ?>
                        </select>
                        </div>
                    </div>
				   <div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="subtype">Material Sub Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control select2 subtype" name="sub_type" id="sub_type">
                            <option>Select Sub type</option>
                              <?php 
                              if(!empty($material_data->sub_type)){
                                    echo '<option value="'.$material_data->sub_type.'" selected>'.$material_data->sub_type.'</option>';
                              }
                              ?>
                          </select>
                          <span id="selectedMaterialSubType" style="display:none;"><?php echo !empty($material_data) ? $material_data->sub_type:''; ?></span>
                        </div>
                    </div>	
    			</div>
    			<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
    			     <div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="uom">Unit of Measure</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control selectAjaxOption select2 select2-hidden-accessible uom" id="uom_type" name="uom_type" data-id="uom" data-key="id" required="required" data-fieldname="uom_quantity" data-where="(created_by_cid = <?php echo $this->companyGroupId; ?> OR created_by_cid = 0) AND (active_inactive = 1)">
                            <option value="">Select Option</option>
                            <?php
                                if(!empty($material_data->uom_type)){
                                   $uom_type = getNameById('uom',$material_data->uom_type,'id');
                                   echo '<option value="'.$material_data->uom_type.'" selected>'.$uom_type->uom_quantity.'</option>';
                                }
                            ?>
                          </select>
                        </div>
                    </div>
			        <div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="hsncode">HSN Code</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
						    <select class="select2 form-control" id="HSNSacMasterID" name="hsn_code" required="required"  style="font-size:17px;">
    							<option value="">Select Option</option>
    							<?php
    							$whereCompany = "(created_by_cid ='" . $this->companyGroupId . "')";
    							$hsnmasterData = $this->inventory_model->get_filter_details('hsn_sac_master', $whereCompany);
    							foreach($hsnmasterData as $hsnval){
    								$totalVal = $hsnval['sgst'] + $hsnval['cgst'];
    								$showVal = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$hsnval['sgst']. '  + ' . $hsnval['cgst']. '  + ' . $totalVal.'  G ';
    
    								$valt = $hsnval['hsn_sac'].'   '.$showVal;
    								 $SelectedVal = '';
    									if($material_data->hsn_code == $hsnval['id']){
    										$SelectedVal =  'selected';
    									}
    								echo '<option value="'.$hsnval['id'].'" '.$SelectedVal.' data-id="'.$totalVal.'" >'.$valt.'</option>';
    							}
    							?>
    						 </select>
    					</div>
    					<!--<a href="javascript:void(0)" data-id="HSNADD_view" class="hsnMAt_mat_view">Add More</a>	 -->
                    </div>
                    <div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="taxrate">Tax Rate</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="tax" value="<?php if(!empty($material_data)) echo $material_data->tax; ?>" class="form-control tacClass" readonly>
						</div>
                    </div>
					
					<div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="taxrate">Standard Packing</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="StandardPacking" name="standard_packing" class="form-control" value="<?php if(!empty($material_data)) echo $material_data->standard_packing; ?>">
						</div>
                    </div>
    			</div>
    			<hr>
				<div class="bottom-bdr"></div>
				<h3 class="Material-head">
					 Packaging
					  <hr>
				   </h3>
				<div class="col-md-8 col-sm-6 col-xs-12 form-group add_multiple_location middle-box2" style="margin: 0px auto;display: table;float: unset;">
				   <div class="well pk edit-row1" style="overflow:auto; border-top: 1px solid #c1c1c1;" id="chkIndex_1">
					  <input type="hidden" name="id_loc[]" value="15835">
					  <?php
                        $packing_data = !empty($variants->packing_data) ? json_decode($variants->packing_data):'';
                         if(!empty($packing_data)){
                        $j = 1;
                        foreach ($packing_data as $key => $packing_value) {
                        $material = getNameById('material',$packing_value->packing_mat,'id');
                        ?>
                      <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <?php if($j == 1){ ?>
						 <label>Name</label>
                        <?php } ?>
						 <select class="location form-control selectAjaxOption select2 location select2-hidden-accessible" name="packing_mat[]" data-id="material" data-key="id" data-fieldname="material_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getcbf(event,this);" data-where="dimension_length !='' && dimension_width !='' && dimension_height !='' && total_cbf != ''">
							<option>Select Option</option>
                            <option selected value="<?php echo $material->id; ?>"><?php echo $material->material_name; ?></option>
						 </select>
					   </div>
					  <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                        <?php if($j == 1){ ?>
						 <label>Box Qty</label>
                         <?php } ?>
						 <input type="text" id="Quantity" class="form-control col-md-7 col-xs-12" placeholder="Quantity" value="<?php echo $packing_value->packing_qty; ?>" name="packing_qty[]">
					  </div>
					   <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                        <?php if($j == 1){ ?>
						 <label>Standard Pack</label>
                         <?php } ?>
						<input type="text" id="box_id" name="stand_pack[]" class="form-control col-md-7 col-xs-12" placeholder="Standard Pack." value="<?php echo $packing_value->stand_pack; ?>"> 
					  </div>
					  <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                        <?php if($j == 1){ ?>
						 <label>Weight</label>
                         <?php } ?>
						 <input type="text" id="rack" class="form-control col-md-7 col-xs-12" placeholder="Weight" value="<?php echo $packing_value->packing_weight; ?>" name="packing_weight[]"> 
					  </div>
					  <div class="cbf_set col-md-3 col-sm-6 col-xs-12 form-group" style="border-right:1px solid #c1c1c1 !important">
                        <?php if($j == 1){ ?>
						 <label>CBF</label>
                         <?php } ?>
						 <input type="text" class="packing_cbf form-control col-md-7 col-xs-12" placeholder="CBF" value="<?php echo $packing_value->packing_cbf; ?>" readonly  name="packing_cbf[]"> 
					  </div>
                        <?php $j++; } ?>
                        <?php } else { ?>
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                   <label>Name</label>
                   <select class="location form-control selectAjaxOption select2 location select2-hidden-accessible" name="packing_mat[]" data-id="material" data-key="id" data-fieldname="material_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getcbf(event,this);" data-where="dimension_length !='' && dimension_width !='' && dimension_height !='' && total_cbf != ''">
                     <option>Select Option</option>
                   </select>
                  </div>
                 <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                   <label>Box Qty</label>
                   <input type="text" id="Quantity" name="packing_qty[]" class="form-control col-md-7 col-xs-12" placeholder="Quantity" value="">
                 </div>
				  <div class="col-md-2 col-sm-6 col-xs-12 form-group">
					<label>Standard Pack</label>
					 <input type="text" id="box_id" name="stand_pack[]" class="form-control col-md-7 col-xs-12" placeholder="Standard Packing." value="">
				</div>
                 <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                   <label>Weight</label>
                   <input type="text" id="rack" name="packing_weight[]" class="form-control col-md-7 col-xs-12" placeholder="Weight" value=""> 
                 </div>
                 <div class="cbf_set col-md-3 col-sm-6 col-xs-12 form-group" style="border-right:1px solid #c1c1c1 !important">
                   <label>CBF</label>
                   <input type="text" id="rack" name="packing_cbf[]" class="packing_cbf form-control col-md-7 col-xs-12" placeholder="CBF" value=""> 
                 </div>
                  <?php } ?>
                      <div id="multiple_packing"></div>
					  <div class="btn-row"><button class="btn  plus-btn edit-end-btn add_More_btn" onclick="addPRow(event,this)" type="button">Add</button></div>
				   </div>
				</div>
				
				
				<hr>
				<div class="bottom-bdr"></div>
                <div class="col-md-12 item form-group" style="padding-top: 30px;">
                    <label class="col-md-6 col-sm-12 col-xs-12 MuiTypography-root MuiTypography-caption _elevio_underline" for="code">Variants</label>
                    <div class="col-md-8">
					    <div class="MuiFormControlLabel-root">
							<button class="btn btn-light" type="button" id="yesMultipleBtn">
    					        <span class="MuiButton-label">Open configuration...</span>
    					        <span class="MuiTouchRipple-root"></span>
    					   </button>
					    </div>
					</div>
					<div class="col-md-2">
						<input type="text" class="form-control update_salePriceFor" Placeholder="From">
						<br/>
						<input type="number" class="form-control update_salePrice" Placeholder="Price">
						<br/>
						<button id="update_salePrice" type="button" class="btn edit-end-btn">Update</button>
					
					</div>
                </div>
                
    			<div class="col-md-8 col-sm-6 col-xs-12 form-group add_multiple_Variant_row middle-box2" style="margin: 0px auto;display: table;float: unset;">
    			    <div id="multiple_variant_materials">
    			        
    			     <?php if(!empty($variants)){ ?>
    			        
                        <table border='1' id='updateSale_price_updatde'>
    			            <thead>
    			                <tr>
    			                  <?php
    			                    $variants_data = !empty($variants->variants_data) ? json_decode($variants->variants_data, true):'';
                                    $variant_key = !empty($variants_data['variant_key']) ? $variants_data['variant_key']:array();
    			                    $variantKeyCount = count($variant_key);
    			                    for($k=1; $k<=$variantKeyCount; $k++){
                                        $tableheader = !empty($variant_key[$k][0]) ? $variant_key[$k][0] : $k;
                                        echo "<th>". ucfirst($tableheader) ."</th>";
                                    }
									 // pre($variant_key);
    			                   ?>
    			                    <th>Variant code / SKU</th>
    			                    <th>Default sales Price</th>
    			                    <!--th></th-->
    			                </tr>
    			            </thead>
    			            <tbody>
    			              <?php 
    			                if(!empty($materials)){
									
    			                    $i = 1;
    			                    foreach($materials as $material){
    			                        $specification = $material['specification'];
    			                        $explodeArray = !empty($material['material_name']) ? explode('_', $material['material_name']):array();
										
    			                ?>  
    			                <tr id="<?php echo $i; ?>">
    			                    <?php 
    			                    #Show coloums according to variants type [Exist/Saved variants]
    			                    if(!empty($explodeArray)){
										
        			                    for($t=1; $t<=$variantKeyCount; $t++){
        			                        $fieldname = $variant_key[$t][0];
											
        			                        $selectedOption = !empty($explodeArray[$t]) ? '<option value="'.$explodeArray[$t].'" selected>'.$explodeArray[$t].'</option>' :'';
											//pre($selectedOption);
											if($explodeArray[$t] == 'PU'){
												 $cls = 'addcls';
												$cls2 = 'addcls2';												 
											}else{
												 $cls = '';	 
												 $cls2 = '';	 
											}
                                            echo '<td style="padding: 0px;">
											<select id="'.$fieldname.'_'.$i.'" class="form-control dynamic '. $cls .'" name="'.$fieldname.'['.$material['id'].']" data-id="material_variants" data-fieldname="variants_data" data-where=" id='.$mvid.'" data-key="'.$t.'">
                                                        <option value="">Select</option>'.$selectedOption.'</select>
                                                  </td>';
                                        }
                                        
                                        /*foreach($explodeArray as $ky => $tdrow){
        			                       if($ky == 0){
        			                           continue;
        			                       }
        			                       echo "<td>".$tdrow."</td>";
        			                    }*/
    			                    }
    			                    
    			                    #Show more coloums according to variants type [New variants]
    			                    $explodeArrCount = count($explodeArray);
                                    $afterSkipFirst = $explodeArrCount - 1;    //Skip first element from array (first element is main material name)
                                    $variantKeyCount;
                                    if($variantKeyCount < $afterSkipFirst){
                                        $extraColumn = $variantKeyCount - $afterSkipFirst;
                                        $sameArrayCount = $variantKeyCount - $extraColumn;
                                        for($t=1; $t<=$variantKeyCount; $t++){
                                            if($t > $sameArrayCount){
                                                $fieldname = $variant_key[$t][0];
                                                echo '<td style="padding: 0px;"><select id="'.$fieldname.'_'.$i.'" class="form-control dynamic" name="'.$fieldname.'['.$material['id'].']" data-id="material_variants" data-fieldname="variants_data" data-where="id='.$mvid.'" data-key="'.$t.'">
                                                        <option value="">Select</option>
                                                        </select>
                                                      </td>';
                                            }
                                        }
                                    }
    			                    ?> 
    			                    <td style="padding: 0px;"><input type="hidden" id="material_id_<?php echo $i; ?>" name="material_id[<?php echo $i; ?>]" class="form-control" value="<?php echo $material['id']; ?>">
    			                        <input type="hidden" id="material_name_<?php echo $i; ?>" name="material_name[<?php echo $material['id']; ?>]" class="form-control" value="<?php echo $material['material_name']; ?>">
        			                    <input type="text" id="variant_sku_<?php echo $i; ?>" name="variant_sku[<?php echo $material['id']; ?>]" class="form-control col-md-7 col-xs-12 sku" value="<?php echo $material['mat_sku']; ?>" onkeyup="checksku(this)" placeholder="E.g. P-1, M-1">
        			                    <p style="color:red;float:left;"></p></td>
    			                    <td style="padding: 0px;"><input type="text" id="sales_price_<?php echo $i; ?>" name="sales_price[<?php echo $material['id']; ?>]" class="form-control col-md-7 col-xs-12 change_PriceVal <?php echo $cls2; ?> " value="<?php echo $material['sales_price']; ?>" pattern="[0-9]+" placeholder="Type sales price"></td>
    			                    <!--td><button type="button" id="remove_<?php //echo $i; ?>" onclick="return deleteMaterial(this);"><i class="fa fa-trash"></i></button></td-->
    			                </tr>
    			              <?php 
    			                       $i++;
    			                    } 
    			                }
                                else
                                {
                                ?> 
                                
                                <tr id="1">
                                <?php
                                    $variantKeyCount = count($variant_key);
                                    for($t=1; $t<=$variantKeyCount; $t++){
                                        $fieldname = $variant_key[$t][0];
                                        echo '<td><select id="'.$fieldname.'_'.$t.'" class="form-control dynamic " name="'.$fieldname.'[1]" data-id="material_variants" data-fieldname="variants_data" data-where="id='.$mvid.'" data-key="'.$t.'">
                                                    <option value="">Select</option></select>
                                              </td>';
                                    }
                                   ?>    
                                    <td><input type="hidden" id="material_id_1" name="new_material[]" class="form-control" value="1">
                                        <input type="hidden" id="material_name_1" name="material_name[1]" class="form-control">
    			                        <input type="text" id="variant_sku_1" name="variant_sku[1]" class="form-control col-md-7 col-xs-12 sku" onkeyup="checksku(this)" placeholder="E.g. P-1, M-1">
    			                        <p style="color:red;float:left;"></p></td>
			                        <td><input type="text" id="sales_price_1" name="sales_price[1]" class="form-control col-md-7 col-xs-12 change_PriceVal" placeholder="Type sales price"></td>
			                        <!--td><button type="button" id="remove_1" onclick="return deleteMaterial(this);"><i class="fa fa-trash"></i></button></td-->
			                    </tr>
			                    
                            <?php } ?>
    			            </tbody>
    			            
    			        </table>
    			        
                        <?php } ?>
                        
                    </div>  
                    <!--button class="btn plus-btn edit-end-btn" type="button" onclick="addMRow(event,this)"> Add more </button-->
                </div>
    			<div class="col-md-12 item form-group" style="padding-top: 30px;">
                    <label class="col-md-12 col-sm-12 col-xs-12 MuiTypography-root MuiTypography-caption _elevio_underline ctxUnderline" for="code">Material Image</label>
                    <div class="col-md-3">
                        <input type="file" class="form-control col-md-7 col-xs-12" name="materialImage">
                    <?php 
                    $attachments = $this->inventory_model->get_image_by_materialId('attachments', 'rel_id', $mvid);
					 // pre($mvid);
                    if(!empty($attachments)){
						echo '<img style="width: 50px; display: block;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'" alt="image" class="undo" height="50px" />';
                    }
                    ?>
                    </div>
                </div>
    			<div class="col-md-12 item form-group" style="padding-top: 30px;">
                    <label class="col-md-12 col-sm-12 col-xs-12 MuiTypography-root MuiTypography-caption _elevio_underline ctxUnderline" for="code">Additional info</label>
                    <div class="col-md-12">
						<textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification"><?php echo $specification; ?></textarea>
					</div>
                </div>
    		</div>
    		
            <center><button type="button" class="btn btn-secondary" onclick="goback();">Close</button>
            <button type="button" class="btn btn-primary" id="vmsave" onclick="return submitForm();">Save changes</button></center>
          
        </form>
 
  


    <!----------------------- Modal-2-start ------------------------->
    <div class="modal fade" id="variantsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="margin: 12% auto;">
        <div class="modal-content">
            
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Material variant setup</h4>
          </div>
          <form id="variantsForm">
          <div class="modal-body">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group add_multiple_Variant middle-box2">
                <div id="multiple_variant">
                    <div class="well" style="overflow:auto;border-top: 1px solid #c1c1c1;border-right: 1px solid #c1c1c1;">
                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <label>Variant Type</label>
                        </div>
                        <div class="col-md-7 col-sm-11 col-xs-11 form-group">
                            <label>Variant Option</label>
                        </div> 	
                        <div class="col-md-1 col-sm-1 col-xs-1 form-group">
                            <label>&nbsp;</label>
                        </div>   
                    </div>
                    
                    <?php
                    if(!empty($variants->variants_data)){
                        $variants_data = json_decode($variants->variants_data, true);
                        $variant_key = !empty($variants_data['variant_key']) ? $variants_data['variant_key']:array();
                        $variantKeyCount = count($variant_key);
                        $variant_value = !empty($variants_data['variant_value']) ? $variants_data['variant_value']:array();
                        for($i=1; $i<=$variantKeyCount; $i++)
                        {
                    ?>
                    <div class="well vm" style="overflow:auto;border-right: 1px solid #c1c1c1;" id="variant_<?php echo $i; ?>">
                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <select class="form-control selectAjaxOption select2 select2-hidden-accessible variantoptId variant_key" required="required" name="variant_key[<?php echo $i; ?>][]" data-id="variant_types" data-key="varient_name" data-fieldname="varient_name" tabindex="-1" aria-hidden="true" data-where="" id="variant_key_<?php echo $i; ?>" onchange="getVarientOption(event,this)">
                              <option value="">Select Option</option>
                              <option value="<?php echo $variant_key[$i][0]; ?>" selected><?php echo $variant_key[$i][0]; ?></option>
                           </select>
                        </div>
                        <div class="col-md-7 col-sm-11 col-xs-11 form-group">
						<!-- selectAjaxOption -->
    						<select multiple class="  select2 select2-hidden-accessible col-md-2 col-xs-12 variant_value VariantOptionId" id="variant_value_<?php echo $i; ?>" name="variant_value[<?php echo $i; ?>][]" width="100%" required>
                                <option>Select Option</option>
                                <?php 
                                if(!empty($variant_value[$i])){
                                    foreach($variant_value[$i] as $option){
                                        echo "<option value=".$option." selected>".$option."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div> 	
                       
                            <button class="btn minus-btn edit-end-btn remove_variant" type="button" id="removeVariant"> - </button> <?php //echo $i; ?>
                         
                    </div>
                    
                    <?php 
                        }
                      }
                    else
                      { 
                    ?>
                    
                    <div class="well vm" style="overflow:auto;border-right: 1px solid #c1c1c1;" id="variant_1">
                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <input type="text" class="form-control col-md-7 col-xs-12 variant_key" id="variant_key_1" name="variant_key[1][]" placeholder="E.g. color/size/type" required> 
                        </div>
                        <div class="col-md-7 col-sm-11 col-xs-11 form-group">
    						<select multiple class="form-control col-md-2 col-xs-12 variant_value" id="variant_value_1" name="variant_value[1][]" width="100%" required>
                                <option>Select Option</option>
                            </select>
                        </div> 	
                        <div class="col-md-1 col-sm-1 col-xs-1 form-group">
                            <button class="btn minus-btn edit-end-btn remove_variant" type="button" id="removeVariant_1"> - </button>
                        </div>   
                    </div>
                    <?php } ?>
                    
                </div>
                <button class="btn plus-btn edit-end-btn" type="button" onclick="addVRow(event,this)"> + </button>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="closed">Close</button>
            <button type="button" class="btn btn-primary" onclick="getVariantsMatrixEdit('<?php echo $mvid; ?>')">Generate material variants</button>
          </div>
          </form>
          
        </div>
      </div>
    </div>
    <!----------------------- Modal-2-end ------------------------->
    
    
<style>
span.select2.select2-container.select2-container--default.select2-container--below, span.select2-selection.select2-selection--multiple {
    height: 38px;
    border: 0px;
    border-left: 1px solid #c1c1c1 !important;
    border-bottom: 1px solid #c1c1c1 !important;
    border-radius: 0px;
    resize: none;
}
span.select2.select2-container.select2-container--default {
    border-right: 1px solid #c1c1c1 !important;
}
.item.form-group {
    overflow: hidden;
}
.ctxUnderline {
    cursor: help;
    border-bottom: 1px dotted #aaa;
}
.MuiTypography-caption {
    font-size: 11px;
    font-family: Open Sans, sans-serif;
    font-weight: 400;
    line-height: 1.66;
}
.MuiSvgIcon-root {
    fill: currentColor;
    width: 1em;
    height: 1em;
    display: inline-block;
    font-size: 1.5rem;
    transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
    flex-shrink: 0;
    user-select: none;
}
.jss37 {
    top: 0;
    left: 0;
    width: 100%;
    cursor: inherit;
    height: 100%;
    margin: 0;
    opacity: 0;
    padding: 0;
    z-index: 1;
    position: absolute;
}
.add_multiple_Variant .vm ul.select2-selection__rendered
 {
    overflow-y: scroll;
    height: 120px !important;}
.add_multiple_Variant .vm .select2-container--default .select2-selection--single{height: 120px !important;}
	
.add_multiple_Variant .vm span.select2.select2-container.select2-container--default.select2-container--below, .add_multiple_Variant .vm span.select2-selection.select2-selection--multiple,.add_multiple_Variant .newvmspan.select2-selection.select2-selection--multiple,.add_multiple_Variant .vm .middle-box2 .form-control,.add_multiple_Variant .vm .middle-box2 .select2-container--default .select2-selection--single {height: 120px !important;
}
</style>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    
    $("form").attr('autocomplete', 'off');
    
    //material name required
    $item_code = $('#item_code').val();
    $material_name = $('#temp_material_name').val();
    if($item_code != '' && $material_name != ''){
        $('#yesMultiple').attr('disabled', false);
    }
    $('#temp_material_name').on('keyup', function(e){
        if($(this).val() != ''){
            $('#item_code').val($(this).val());
            $('#yesMultipleBtn').attr('disabled', false);
        }else{
            $('#item_code').val('');
            $('#yesMultipleBtn').attr('disabled', true);
        }
    });
    
    //onclick - show variant modal 
    $('#yesMultipleBtn').on('click', function(e){
        $('#variantsModal').modal();
    });

    init_variants();
    init_dynamic_variants();
    $(document).on('change', '.variant_value', function(){
        $($(".variant_value").select2("container")).addClass("select2-container--open");
    });
    $().on('click', '.select2-selection__choice__remove', function(){
        $(this).parent('li').remove();
    });
	
	
	 $('#update_salePrice').on('click', function(){
		var PriceUpate = $('.update_salePrice').val();
	//alert($('.update_salePriceFor').val());
	if($('.update_salePrice').val() != '' &&  $('.update_salePriceFor').val() == ''){
		var PriceUpate = $('.update_salePrice').val();
		$('#updateSale_price_updatde tr ').each(function(){
		$('.change_PriceVal').val(PriceUpate);
	});
	}else if($('.update_salePrice').val() != '' &&  $('.update_salePriceFor').val() != ''){
		var PriceUpate = $('.update_salePrice').val();
		//alert(PriceUpate);
		var salePriceFor = $('.update_salePriceFor').val();
		// alert(salePriceFor);
		$('#updateSale_price_updatde tr').each(function(){
			var Currenttext = $(this).find('.addcls').attr('data-idVal');
			// var Currenttext = $(this).find('.addcls').html();
			//alert(Currenttext);
			//if(Currenttext == salePriceFor){
				//$('.change_PriceVal').val(PriceUpate);
				$('.addcls2').val(PriceUpate);
			//}
	});
	} else {
		// alert('Please enter the Number.');
		swal({
			  icon: 'error',
			  title: 'Oops...',
			  text: 'Please Add Some Value!',
			  // footer: '<a href="">Why do I have this issue?</a>'
			})
	}
});
    
    
});


function submitForm(){
    var error = 0;
    $('.sku').each(function(){
        var eid = $(this).attr('id');
        if($(this).val() == ''){
            //$(this).siblings('p').text('required');
            error = 0;
        }else{
            $(this).siblings('p').text('');
        }
    });
    if(error == 0){
        $("#variantMaterialsForm").submit();
    }else{
        return false;
    }
}


function init_variants(){
    $('.variant_value').select2({
        tags: true,
        allowClear: true,
        closeOnSelect: false,
        placeholder: 'Option value',
    });
}


//fetch variants data and show option in select option field
function init_dynamic_variants(){
    $('.dynamic').select2({
        allowClear: true,
        placeholder: 'Select',
        ajax: {
            url: site_url + 'inventory/newAjaxSelect2search',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                    table: $(this).attr("data-id"),
                    fieldname: $(this).attr("data-fieldname"),
                    fieldwhere: $(this).attr("data-where"),
                    field: $(this).attr("data-key")
                };
            },
            processResults: function(data) {
                return {
                    //results: data
                    results: $.map(data, function(obj) {
                        return { id: obj, text: obj };
                    })
                };
            },
            cache: true,
        },

        language: {
            noResults: function() {
                var searched_value = $('.select2-search__field').val();
                $('.dynamic').val(searched_value);
            }
        },

        escapeMarkup: function(markup) {
            return markup;
        }
    });
}


/* check material sku exist or not */
function checksku(t){
    var fieldId = $(t).attr('id');
    var value = $(t).val();
    if(value != ''){
        $.ajax({
            type: "POST",
            url: site_url + 'inventory/check_material_sku',
            data: {sku:value},
            success: function(data){
                if(data == 1){
                    $(t).siblings('p').text('This sku is already exist.');
                    $('#vmsave').attr('disabled', true);
                }else{
                    $(t).siblings('p').text('');
                    $('#vmsave').attr('disabled', false);
                }
            }
        });
    }else{
        $(t).siblings('p').text('');
        $('#vmsave').attr('disabled', false);
    }
}


/* Generate variants matrix */
function getVariantsMatrixEdit(mvid){	
    var materialName = $('#temp_material_name').val();
    var serialized = $('#variantsForm').serialize();
    
    //validate fields
    var error = 0;
    $('.variant_key').each(function(index) {
       var keyFieldId = $(this).attr('id');
       if($('#'+ keyFieldId).val() == ''){
           $('#'+ keyFieldId).focus();
           error = 1; 
       }
    });
    
    if(error == 1){
        alert('Variant option field is required with options value');
        return false;
    }else{
        var datastring = serialized + "&materialName=" + materialName + "&mvid=" + mvid;
        $.ajax({
            type: "POST",
            url: site_url + 'inventory/generate_matrix_edit',
            data: datastring,
            success: function(data){
                //console.log(data);
                $('#variantsModal').modal('hide');
                $('#vmsave').attr('disabled', false);
                $('#multiple_variant_materials').empty();
                $('#multiple_variant_materials').html(data);
                init_dynamic_variants();
            },
            error: function() {
                alert('something went wrong');
            }
        });
    }
}


/* Delete material */
function deleteMaterial(t){
    var rmid = $(t).attr('id');
    var result = rmid.split('_');
    var rowId = result[1];
    var matId = $('#material_id_'+rowId).val(); 
    if(rowId != '' && typeof(rowId) != 'undefined'){
        var checkstr = confirm('Are you sure you want to delete this?');
        if(checkstr == true){
            /* if material id is valid, then change status - inactive */ 
            if(matId != '' && typeof(matId) != 'undefined' && matId != 'new'){
                $.ajax({
                    type: "POST",
                    url: site_url + 'inventory/common_function_change_status',
                    data: {id:matId,source:'material',status:'0'},
                    success: function(data){
                        if(data == 1){
                            $('#' + rowId).remove();
                        }
                    },
                    error: function() {
                        alert('something went wrong');
                    }
                }); 
            }else{
                //$('#'+rowId).remove();
                $(t).closest('tr').remove();
            }
        }else{
            return false;
        }
    }else{
        alert('Something went wrong');
    }
}

function goback(){
    window.history.back();
}


/* Create multiple row (clone last table row) */
function addMRow(evt , t){
	var logged_user = ''; //$('#loggedUser').val();		
	var x;
	var lastid = $('table tr:last').attr('id');
	if(lastid != '' && typeof(lastid) != 'undefined'){
		x = parseInt(lastid);
	}	
						
	var maximum = 100; 	//maximum input boxes allowed
	if(x < maximum){    //max input box allowed
		x++; 
		
		var newRow = $('table tr:last').clone();  //clone of last tr
		newRow.find("span").remove();             //Remove cloned select2 
		newRow.find("select").select2();          //reinit select2   
        $('table tr:last').after(newRow);         //append after last tr
        
        newRow.attr('id',x);    //change tr id
        
        //change each field's id
        newRow.find('[id]')
            .each(function(){
                var eid = $(this).attr('id');
                if(eid != '' && typeof(eid) != 'undefined'){
                    var id = eid.slice(0, -1) + x;
                    $(this).attr('id', id);
                }
            });
        
        //change each field's name
        newRow.find('[name]')
            .each(function(){
                var ename = $(this).attr('name');
                if(ename != '' && typeof(ename) != 'undefined'){
                    var nname = ename.substring(0, ename.indexOf('['));
                    if(nname == 'material_id' || nname == 'new_material'){
                        $(this).attr('name', 'new_material[' + x + ']');
                        $(this).val('new');
                    }else{
                        $(this).attr('name', nname + '[' + x + ']');
                        $(this).val('');
                    }
                }
            });
	}	
	init_dynamic_variants();
}


/* Create multiple row (clone variants rows) */
function addVRow(evt , t){
	var logged_user = ''; //$('#loggedUser').val();		
	var x;
	var lastid = $(".vm:last").attr("id");
	if(lastid != '' && typeof(lastid) != 'undefined'){
		var lastIdVal= lastid.split('_');		
		x = parseInt(lastIdVal[1]);		
	}	
						
	var maximum = 15; 	//maximum input boxes allowed
	if(x < maximum){    //max input box allowed
		x++; 
		var wrap = $("#multiple_variant");
		$("#multiple_variant").append(variantRowHtml(x,logged_user));
	}
	$(wrap).on("click", ".remove_variant", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		x--;
	})	
	
	$(".add_multiple_Variant").on("click",".remove_variant", function(e){ //user click on remove text
		e.preventDefault(); 
		var removeId = $(this).attr('id');
    	if(removeId != '' && typeof(removeId) != 'undefined'){
    		var delIdVal= removeId.split('_');		
    		var rv = parseInt(delIdVal[1]);	
    		if(rv != 1){    //delete row, except first row
    		    $("#variant_"+rv).remove();	
    		}
    		x--;
    	}	
	});	
	init_variants();
	init_select2();	
}

function variantRowHtml(x,logged_user){
    return Html = `<div class="well vm newvm" style="overflow:auto;border-right: 1px solid #c1c1c1;" id="variant_${x}">
                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible variantoptId variant_key" required="required" name="variant_key[${x}][]" data-id="variant_types" data-key="varient_name" data-fieldname="varient_name" tabindex="-1" aria-hidden="true" data-where="" id="variant_key_${x}" onchange="getVarientOption(event,this)">
                        <option value="">Select Option</option>
                        </select>  
                    </div>
                    <div class="col-md-7 col-sm-11 col-xs-11 form-group">
						<!--select multiple class="form-control selectAjaxOption select2 select2-hidden-accessible col-md-2 col-xs-12 select2-hidden-accessible variant_value VariantOptionId" id="variant_value_${x}" name="variant_value[${x}][]" width="100%"-->
						<select multiple class="form-control  col-md-2 col-xs-12 variant_value VariantOptionId" id="variant_value_${x}" name="variant_value[${x}][]" width="100%" required >
                            <option>Select Option</option>
                        </select>
                           
                    </div> 
                    
                        <button class="btn minus-btn edit-end-btn remove_variant" type="button" id="removeVariant_${x}"> - </button>
                   
                </div>`;
}


function addPRow(evt , t){
var logged_user = ''; //$('#loggedUser').val();     
    var x;
    var lastid = $(".pk:last").attr("id");
    if(lastid != '' && typeof(lastid) != 'undefined'){
        var lastIdVal= lastid.split('_');       
        x = parseInt(lastIdVal[1]);     
    }   
                        
    var maximum = 15;   //maximum input boxes allowed
    if(x < maximum){    //max input box allowed
        x++; 
        $("#multiple_packing").append(packingRowHtml(x,logged_user));
    } 
		$(packingRowHtml).on("click",".remove_field", function(e){ //user click on remove text
			e.preventDefault(); $(this).parent('div').remove(); x--;
		});		
    
    $(".add_multiple_Variant").on("click",".remove_variant", function(e){ //user click on remove text
        e.preventDefault(); 
        var removeId = $(this).attr('id');
        if(removeId != '' && typeof(removeId) != 'undefined'){
            var delIdVal= removeId.split('_');      
            var rv = parseInt(delIdVal[1]); 
            if(rv != 1){    //delete row, except first row
                $("#variant_"+rv).remove(); 
            }
            x--;
        }   
    }); 
    init_select2();
}
function packingRowHtml(x,logged_user){
    return Html = `<div class="well pk scend-tr" style="overflow:auto;border-right: 1px solid #c1c1c1;" id="variant_${x}">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
<select class="location form-control selectAjaxOption select2 location select2-hidden-accessible" name="packing_mat[]" data-id="material" data-key="id" data-fieldname="material_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getcbf(event,this);" data-where="dimension_length !='' && dimension_width !='' && dimension_height !='' && total_cbf != ''">
<option>Select Option</option>
</select>
</div>
<div class="col-md-2 col-sm-6 col-xs-12 form-group">
<input type="text" id="Quantity" class="form-control col-md-7 col-xs-12" placeholder="Quantity" value="" name="packing_qty[]">
</div>
 <div class="col-md-2 col-sm-6 col-xs-12 form-group">
	 <input type="text" id="box_id" name="stand_pack[]" class="form-control col-md-7 col-xs-12" placeholder="Standard Packing." value="">
</div>
<div class="col-md-2 col-sm-6 col-xs-12 form-group">
<input type="text" id="rack" class="form-control col-md-7 col-xs-12" placeholder="Weight" value="" name="packing_weight[]"> 
</div>
<div class="cbf_set col-md-3 col-sm-6 col-xs-12 form-group" style="border-right:1px solid #c1c1c1 !important">
<input type="text" class="packing_cbf form-control col-md-7 col-xs-12" placeholder="CBF" value=""  name="packing_cbf[]"> 
</div><button style="margin-right: 0px;" class="btn btn-danger remove_field" type="button"> <i class="fa fa-minus"></i></button>   
                </div>`;
}
$(document).on('keyup', '#StandardPacking', function(e){
if (/\D/g.test(this.value)){
this.value = this.value.replace(/\D/g, '');
}
});
</script>