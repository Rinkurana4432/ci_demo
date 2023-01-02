<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id;
?>
    
		<form action="<?php echo base_url() ?>inventory/save_variant_materials" method="post" id="variantMaterialsForm" enctype="multipart/form-data">    
			<div class="col-md-12">
    		    <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
                    <div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="item_code">Item Code</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-7 col-xs-12" id="item_code" name="item_code" placeholder="Enter Item Code" readonly="readonly"></div>
                    </div>
			        <div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="name">Material name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-7 col-xs-12" id="temp_material_name" name="temp_material_name" placeholder="Enter Material name" required="required"></div>
                    </div>
				    <div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="type">Material Type <span class="required"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible materialTypeId" id="material_type_id" name="material_type_id" required="required" data-id="material_type" data-key="id" data-fieldname="name" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" onchange="ChangePrefix_and_subType();">
                           <option value="">Select Option</option>
                        </select>
                        </div>
                    </div>
				   <div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="subtype">Material Sub Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="subtype form-control" name="sub_type">
                            <option value="">Select Sub type</option>
                              <?php 
                               /*if(!empty($materials)){
                                    echo '<option value="'.$materials->sub_type.'" selected>'.$materials->sub_type.'</option>';
                               }*/
                              ?>
                          </select>
                        </div>
                    </div>	
    			</div>
    			<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
    			     <div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="uom">Unit of Measure <span class="required"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control selectAjaxOption select2 select2-hidden-accessible uom" id="uom_type" name="uom_type" data-id="uom" data-key="id" required="required" data-fieldname="uom_quantity" data-where="(created_by_cid = <?php echo $this->companyGroupId; ?> OR created_by_cid = 0) AND (active_inactive = 1)">
                            <option value="">Select Option</option>
                            <?php
                                /*if(!empty($materials->alternateuom)){
                                   $material_type_id = getNameById('uom',$materials->alternateuom,'id');
                                   echo '<option value="'.$materials->alternateuom.'"selected >'.$material_type_id->uom_quantity.'</option>';
                                }*/
                            ?>
                          </select>
                        </div>
                    </div>
			        <div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="hsncode">HSN Code <span class="required"> *</span></label>
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
    									if($materials->hsn_code == $hsnval['id']){
    										$SelectedVal =  'selected';
    									}
    								echo '<option value="'.$hsnval['id'].'" '.$SelectedVal.' data-id="'.$totalVal.'" >'.$valt.'</option>';
    							}
    							?>
    						 </select>
    					  </div>
    					  <!--<a href="javascript:void(0)" data-id="HSNADD_view" class="hsnMAt_mat_view">Add More</a>-->
                    </div>
                    <div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="taxrate">Tax Rate</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="tax" name="tax" class="form-control tacClass" readonly>
						</div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12" for="taxrate">Standard Packing</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="StandardPacking" name="standard_packing" class="form-control">
						</div>
                    </div>
					<div class="item form-group">
                        <!--label class="col-md-3 col-sm-3 col-xs-12" for="taxrate">Location <span class="required"> *</span></label-->
                        <div class="col-md-6 col-sm-6 col-xs-12">
						<?php 
							$cmp_location = getNameById('company_address',$this->companyGroupId,'created_by_cid');
							
						?>
						<input type="hidden" name="location" class="form-control" value="<?php echo $cmp_location->id; ?>">
                           	<!--select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location" data-id="company_address" data-key="id" data-fieldname="location" width="100%"  aria-hidden="true"  data-where="created_by_cid=<?php //echo $this->companyGroupId; ?>" required="required">
							   <option value="">Select Option</option>
							</select-->
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
				   <div class="well pk edit-row1 " style="overflow:auto; border-top: 1px solid #c1c1c1;" id="chkIndex_1">
					  <input type="hidden" name="id_loc[]" value="">
					  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
						 <label>Name</label>
						 <select class="location form-control selectAjaxOption select2 location select2-hidden-accessible" name="packing_mat[]" data-id="material" data-key="id" data-fieldname="material_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getcbf(event,this);" data-where="dimension_length !='' && dimension_width !='' && dimension_height !='' && total_cbf != ''">
							<option>Select Option</option>
						 </select>
					   </div>
					   <div class="col-md-2 col-sm-6 col-xs-12 form-group">
						 <label>Box Qty</label>
						 <input type="text" id="Quantity" name="packing_qty[]" class="form-control col-md-7 col-xs-12" placeholder="Quantity" value="">
					  </div>
					    <div class="col-md-2 col-sm-6 col-xs-12 form-group">
							 <label>Standard Pack</label>
							 <input type="text" id="box_id" name="stand_pack[]" class="form-control col-md-7 col-xs-12" placeholder="Standard Packing." value="">
						</div>
					  
					  <div class="col-md-2 col-sm-6 col-xs-12 form-group">
						 <label>Weight</label>
						 <input type="text" id="rack" name="packing_weight[]" class="form-control col-md-7 col-xs-12" placeholder="Weight" value=""> 
					  </div>
					  <div class="cbf_set col-md-3 col-sm-6 col-xs-12 form-group" style="border-right:1px solid #c1c1c1 !important">
						 <label>CBF</label>
						 <input type="text" id="rack" name="packing_cbf[]" class="packing_cbf form-control col-md-7 col-xs-12" placeholder="CBF" value=""> 
					  </div>
                      <div id="multiple_packing"></div>
					  <div class="btn-row"><button class="btn  plus-btn edit-end-btn add_More_btn" onclick="addPRow(event,this)" type="button">Add</button></div>
				   </div>
				</div>
				
				
				<hr>
				<div class="bottom-bdr"></div>
				
				
				
    			
    			<div class="col-md-12 item form-group" style="padding-top: 30px;" id="checkboxDiv">
                    <label class="col-md-6 col-sm-12 col-xs-12 MuiTypography-root MuiTypography-caption _elevio_underline ctxUnderline" for="code">Does this material come in different colors, sizes or similar?</label>
                    <div class="col-md-8">
						<div class="MuiFormControlLabel-root">
							<span class="MuiButtonBase-root MuiIconButton-root jss333 MuiCheckbox-root MuiCheckbox-colorPrimary MuiIconButton-colorPrimary" aria-disabled="false">
							    <span class="MuiIconButton-label"><input type="checkbox" id="yesMultiple"/></span>
							    <span class="MuiTouchRipple-root"></span>
							</span>
							<span class="MuiTypography-root MuiFormControlLabel-label MuiTypography-body1">Yes, this material has multiple variants</span>
					    </div>
					</div>
                </div>
                
                <div class="col-md-12 item form-group" style="padding-top: 30px;display:none;" id="buttonDiv">
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
    			        <table border='1' id='updateSale_price_updatde'>
    			            <thead>
    			                <tr>
    			                    <th>Variant code / SKU</th>
    			                    <th>Default sales price</th>
    			                    <!--<th>Default purchase price</th>-->
    			                    <!--<th>In stock</th>-->
    			                </tr>
    			            </thead>
    			            <tbody>
    			                <tr>
    			                    <td style="padding: 0px;"><input type="hidden" id="material_name_1" name="material_name[]" class="form-control">
        			                    <input type="text" id="variant_sku_1" name="variant_sku[]" class="form-control col-md-7 col-xs-12" placeholder="E.g. P-1, M-1" disabled></td>
    			                    <td style="padding: 0px;"><input type="text" id="sales_price_1" name="sales_price[]" class="form-control col-md-7 col-xs-12 change_PriceVal" placeholder="Type sales price" disabled></td>
    			                    <!--<td><input type="text" id="cost_price_1" name="cost_price[]" class="form-control col-md-7 col-xs-12" placeholder="Type cost price"></td>-->
    			                    <!--<td><input type="text" id="quantity_1" name="quantity[]" class="form-control col-md-7 col-xs-12" placeholder="In stock"></td>-->
    			                </tr>
    			            </tbody>
    			        </table>
                    </div>    
                </div>
    			<div class="col-md-12 item form-group" style="padding-top: 30px;">
                    <label class="col-md-12 col-sm-12 col-xs-12 MuiTypography-root MuiTypography-caption _elevio_underline ctxUnderline" for="code">Material Image</label>
                    <div class="col-md-3">
                        <input type="file" class="form-control col-md-7 col-xs-12" name="materialImage">
                    </div>
                </div>
    			<div class="col-md-12 item form-group" style="padding-top: 30px;">
                    <label class="col-md-12 col-sm-12 col-xs-12 MuiTypography-root MuiTypography-caption _elevio_underline ctxUnderline" for="code">Additional info</label>
                    <div class="col-md-12">
						<textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification"></textarea>
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
            <h4 class="modal-title" id="myModalLabel">Material Variant Setup</h4>
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
                    <div class="well vm" style="overflow:auto;border-right: 1px solid #c1c1c1;" id="variant_1">
                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <!--input type="text" class="form-control col-md-7 col-xs-12 variant_key" id="variant_key_1" name="variant_key[1][]" placeholder="E.g. color/size/type" required--> 
                            <select class="form-control selectAjaxOption select2 select2-hidden-accessible variantoptId variant_key" required="required" name="variant_key[1][]" data-id="variant_types" data-key="varient_name" data-fieldname="varient_name" tabindex="-1" aria-hidden="true" data-where="" id="variant_key_1" onchange="getVarientOption(event,this)">
                              <option value="">Select Option</option>
                           </select>
                        </div>
                        <div class="col-md-7 col-sm-11 col-xs-11 form-group">
    						<select multiple class="form-control  col-md-2 col-xs-12 variant_value VariantOptionId" id="variant_value_1" name="variant_value[1][]" width="100%" required >
                               
                            </select><!--input type="checkbox" class="checkbox" >Select All	-->
                        </div>
													
                        <div class="col-md-1 col-sm-1 col-xs-1 form-group">
                            <button class="btn minus-btn edit-end-btn remove_variant" type="button" id="removeVariant_1"> - </button>
                        </div>   
                    </div>
                </div>
                <button class="btn plus-btn edit-end-btn" type="button" onclick="addVRow(event,this)"> + </button>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="closed">Close</button>
            <button type="button" class="btn btn-primary" onclick="getVariantsMatrix()">Generate material variants</button>
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
/*
----------------------------------------------
                  CHECKBOX
----------------------------------------------
*/
/* Base for label styling */

[type="checkbox"]:not(:checked) + label,
[type="checkbox"]:checked + label {
    position: relative;
    padding-left: 25px;
    cursor: pointer;
}

/* checkbox aspect */
[type="checkbox"]:checked + label:before {
    content: '';
    position: absolute;
    left:0; top: 0px;
    width: 20px; height: 20px;
    /*//border: 1px solid #aaa;*/
    background: #09ad7e;
    border-radius: 3px;
    /*//box-shadow: inset 0 1px 3px rgba(0,0,0,.3)*/
}
[type="checkbox"]:not(:checked) + label:before {
    content: '';
    position: absolute;
    left:0; top: 0px;
    width: 20px; height: 20px;
    /*//border: 1px solid #fff;*/
    background: #eee;
    border-radius: 3px;
    /*//box-shadow: inset 0 1px 3px rgba(0,0,0,.3)*/
}
/* checked mark aspect */

[type="checkbox"]:checked + label:after {
    content: '✔';
    position: absolute;
    top: 0; left: 4px;
    font-size: 14px;
    color: #f8f8f8;
    transition: all .2s;
}
[type="checkbox"]:not(:checked) + label:after {
    content: '✔';
    position: absolute;
    top: 0; left: 4px;
    font-size: 14px;
    color: #ddd;
    transition: all .2s;
}
/* checked mark aspect changes */
[type="checkbox"]:not(:checked) + label:after {
    opacity: 1;
    transform: scale(1);
}
[type="checkbox"]:checked + label:after {
    opacity: 1;
    transform: scale(1);
}
/* disabled checkbox */
[type="checkbox"]:disabled:not(:checked) + label:before,
[type="checkbox"]:disabled:checked + label:before {
    box-shadow: none;
    border-color: #bbb;
    background-color: #ddd;
}
[type="checkbox"]:disabled:checked + label:after {
    color: #999;
}
[type="checkbox"]:disabled + label {
    color: #aaa;
}
/* accessibility */
[type="checkbox"]:checked:focus + label:before,
[type="checkbox"]:not(:checked):focus + label:before {
    outline: none !important;
}

/* hover style just for information */
label:hover:before {
    /*border: 1px solid #4778d9!important;*/
}

[type="checkbox"]:not(:checked) + label {
    color: #ddd;
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
    
    $('#yesMultiple').attr('disabled', true);
    $('#vmsave').attr('disabled', true);
    
    //material name required
    $item_code = $('#item_code').val();
    $material_name = $('#temp_material_name').val();
    if($item_code != '' && $material_name != ''){
        $('#yesMultiple').attr('disabled', false);
    }
    $('#temp_material_name').on('keyup', function(e){
        if($(this).val() != ''){
            $('#item_code').val($(this).val());
            $('#yesMultiple').attr('disabled', false);
        }else{
            $('#item_code').val('');
            $('#yesMultiple').attr('disabled', true);
        }
    });
    
    //onchange - show variant modal 
    $('#yesMultiple').on('change', function(e){
        if(e.target.checked){
            $('#variantsModal').modal();
        }
    });
    
    //onclick - show variant modal 
    $('#yesMultipleBtn').on('click', function(e){
        $('#variantsModal').modal();
    });

    $('#closed').click(function() {
        $('#yesMultiple').attr('checked', false);
    });
    
    init_variants();
    // $('#myID').on('open',function(){
    //     $($("#myID").select2("container")).removeClass("error");
    // });
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
		var salePriceFor = $('.update_salePriceFor').val();
		$('#updateSale_price_updatde tr').each(function(){
			// var Currenttext = $(this).find('.addcls').html();
			var Currenttext = $(this).find('.addcls').attr('data-idVal');
			//var AttrClass = $('.change_PriceVal').attr('data-idd');
			 console.log('Currenttext===>',Currenttext);
			 console.log('salePriceFor===>',salePriceFor);
			// alert(salePriceFor);
			if(Currenttext == salePriceFor){
				//$('.change_PriceVal').val(PriceUpate);
				$('.addcls2').val(PriceUpate);
				// $('.'+AttrClass).val(PriceUpate);
			}
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
function getVariantsMatrix(){	
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
        var datastring = serialized + "&materialName=" + materialName;
        $.ajax({
            type: "POST",
            url: site_url + 'inventory/generate_matrix',
            data: datastring,
            success: function(data){
                $('#variantsModal').modal('hide');
                $('#checkboxDiv').hide();
                $('#buttonDiv').show();
                $('#vmsave').attr('disabled', false);
                $('#multiple_variant_materials').empty();
                $('#multiple_variant_materials').html(data);
            },
            error: function() {
                alert('something went wrong');
            }
        });
    }
}


/* Delete table row */
function deleteMaterial(t){
    var rmid = $(t).attr('id');
    var result = rmid.split('_');
    var rowId = result[1];
    if(rowId != '' && typeof(rowId) != 'undefined'){
        var checkstr = confirm('Are you sure you want to delete this?');
        if(checkstr == true){
            $('#' + rowId).remove();
        }
    }else{
        alert('Something went wrong');
    }
}

function goback(){
    window.history.back();
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
		$("#multiple_variant").append(variantRowHtml(x,logged_user));
	}								
	
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
						<!--select multiple class="form-control selectAjaxOption select2 select2-hidden-accessible col-md-2 col-xs-12 select2-hidden-accessible variant_value VariantOptionId" id="variant_value_${x}" name="variant_value[${x}][]" width="100%">
                            <option>Select Option</option>
                        </select-->
						
						<select multiple class="form-control  col-md-2 col-xs-12 variant_value VariantOptionId" id="variant_value_${x}" name="variant_value[${x}][]" width="100%" required >
                            <option>Select Option</option>
                        </select>
                    </div> 
                    <div class="col-md-1 col-sm-1 col-xs-1 form-group">
                        <button class="btn minus-btn edit-end-btn remove_variant" type="button" id="removeVariant_${x}"> - </button>
                    </div>   
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
    return Html = `<div class="well scend-tr mobile-view pk" style="overflow:auto;border-right: 1px solid #c1c1c1;" id="variant_${x}">
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
</div> 
<button style="margin-right: 0px;" class="btn btn-danger remove_field" type="button"> <i class="fa fa-minus"></i></button> 
                </div>`;
}
$(document).on('keyup', '#StandardPacking', function(e){
if (/\D/g.test(this.value)){
this.value = this.value.replace(/\D/g, '');
}
});
</script>