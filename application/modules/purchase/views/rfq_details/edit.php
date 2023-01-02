<?php 	
   $getcompanyName = getCompanyTableId('company_detail');
   $name = $getcompanyName->name;
   $CompanyName = substr($name , 0,6);
   $last_id = getLastTableId('purchase_indent');
   $rId = $last_id + 1;
   $indentCode = ($indents && !empty($indents))?$indents->indent_code:('Indent_'.rand(1, 1000000).'_'.$CompanyName.'_'.$rId);
   ?>
<?php
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ; ?>	
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/saveRfq" enctype="multipart/form-data" id="purchaseIndentForm" novalidate="novalidate">
   <input type="hidden" name="id" id="rfqQt" value="<?php if($indents && !empty($indents)){ echo $indents->id;} ?>" >	
   <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
   <?php if(empty($indents)){ ?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <?php }else{ ?>	
   <input type="hidden" name="created_by" value="<?php if($indents && !empty($indents)){ echo $indents->created_by;} ?>" >
   <?php } ?>
   <input type="hidden" name="save_status" value="1" class="save_status">
   <!-- <div class="col-md-6"></div> -->
   <div class=" col-md-6 col-xs-12 col-sm-6 label-left   " style="overflow:auto; padding:0px;">
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label for="material" class="col-md-5 col-sm-12 col-xs-6">Purchase Indent No.<span class="required">*</span></label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div><b>
               <?php  echo $indentCode; ?>
               </b>
            </div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label for="material" class="col-md-5 col-sm-12 col-xs-6">For Company Unit:<span class="required">*</span></label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div><b>
               <?php if(!empty($indents)){
                  $brnch_name = getNameById('company_address',$indents->company_unit,'compny_branch_id');
                   echo $brnch_name->company_unit;
                  } ?>
               </b>
            </div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label class="col-md-5 col-sm-12 col-xs-6">Inductor:</label>   
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div >
               <?php if(!empty($indents)){ echo $indents->inductor; } ?>                              
            </div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label class="col-md-5 col-sm-12 col-xs-6">Indent Number :</label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div >
               <?php echo $indents->indent_code; ?>                           
            </div>
         </div>
      </div>
      <!-- <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label>Preferred Supplier</label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div >
               <?php if(!empty($suppliername)){                                  
                  $indents->preffered_supplier;                                   
                  $supplierName=getNameById('supplier',$indents->preffered_supplier,'id');                     
                                  
                  ?>                      
               <?php if(!empty($supplierName)){echo $supplierName->name; } else {echo "N/A";}?>
               <?php }?>                        
            </div>
         </div>
      </div> -->
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label for="material" class="col-md-5 col-sm-12 col-xs-6">Delivery Address:<span class="required">*</span></label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div><b>
               <?php if(!empty($indents)){
                  $brnch_name = getNameById_with_cid('company_address', $indents->delivery_address, 'id','created_by_cid',$this->companyGroupId);
                   echo $brnch_name->location;
                  } ?>
               </b>
            </div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label class="col-md-5 col-sm-12 col-xs-6">Validate By</label>                      
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div >
               <?php 
                  // pre($indents);
                    if(!empty($indents)){                                  
                                               
                      $username = getNameById('user_detail',$indents->validated_by,'u_id');                     
                     echo $username->name??'N/A';
                    }
                     ?>                            
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-xs-12 col-sm-6 label-left " style=" padding:0px;">
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label for="material" class="col-md-5 col-sm-12 col-xs-6">Required Date:<span class="required">*</span></label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div ><?php if(!empty($indents)){ echo date("j F , Y", strtotime($indents->required_date)); } ?></div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label class="col-md-5 col-sm-12 col-xs-6">Created Date:</label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div ><?php if(!empty($indents)){ echo date("j F , Y", strtotime($indents->created_date)); } ?></div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label  class="col-md-5 col-sm-12 col-xs-6">Department:</label>   
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div >
               <?php if(!empty($indents)){ 
                  echo getNameById('department',$indents->departments,'id')->name??'N/A';
                  } ?>                             
            </div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label class="col-md-5 col-sm-12 col-xs-6">Others:</label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div>
               <?= $indents->other??''; ?>                           
            </div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label class="col-md-5 col-sm-12 col-xs-6">Specification:</label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div ><?= $indents->specification??''; ?>                      
            </div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label class="col-md-5 col-sm-12 col-xs-6">Type:</label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div ><?php 
               switch ($indents->purchase_type) {
                  case 1:
                     echo 'Import';
                     break;
                  default:
                     echo 'Domestic';
                  break;
               }
               ?>                      
            </div>
         </div>
      </div>
   </div>
   
   <hr>
   <div class="bottom-bdr"></div>
   <h3 class="Material-head" style="margin-bottom: 30px;">
      Material Details
      <hr>
   </h3>
   <div class="col-md-12 col-sm-12 col-xs-12 vertical-border">
      <!--div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="material">Material Type </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2"  name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php //echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type" disabled>
               <option value="">Select Option</option>
               <?php
                  // if (!empty($indents)) {
                  	// $material_type_id = getNameById('material_type', $indents->material_type_id, 'id');
                  	// echo '<option value="' . $indents->material_type_id . '" selected>' . $material_type_id->name . '</option>';
                  // }
                  ?>
            </select>
						  <input type="hidden" name="material_type_id" value="<?php //echo $indents->material_type_id; ?>">

         </div>
      </div-->
   </div>
   <?php  //pre($indents); ?>
   <div class="form-group" style="padding-bottom: 15px;">
      <div class="item form-group">
         <div class="goods_descr_wrapper">
            <div class="item form-group">
            </div>
            <div class="col-md-12 input_material middle-box ">
               <?php  if (!empty($indents) && $indents->material_name != '') {
                  $indentsDataDetail = json_decode($indents->material_name);
                  
                  if (!empty($indentsDataDetail)) {
                  	$i =  1;
                  	?>
               <div class="col-sm-12  col-md-12 label-box mobile-view2">
                  <label class="col-md-2 col-sm-12 col-xs-12">M. Type</label>
                  <label class="col-md-1 col-sm-12 col-xs-12">M. Name</label>
                  <label class="col-md-1 col-sm-12 col-xs-12">Alias</label>
                  <label class="col-md-2 col-sm-12 col-xs-6">Description</label>
                  <label class="col-md-2 col-sm-6 col-xs-6" >Quantity&nbsp;&nbsp;&nbsp; /UOM</label>
				  <label class="col-md-2 col-sm-12 col-xs-12">Last Purchase Price</label>
                  <label class="col-md-1 col-sm-6 col-xs-6">Piece Price</label>
                  <label class="col-md-1 col-sm-6 col-xs-12">Sub Total</label>
                  <!-- <label class="col-md-1 col-sm-6 col-xs-12">GST</label>
                     <label class="col-md-1 col-sm-6 col-xs-12">Sub Tax</label>
                     <label class="col-md-2 col-sm-6 col-xs-6" style="border-right: 1px solid #c1c1c1 !important;">Total</label>-->
               </div>
               <?php
                  foreach ($indentsDataDetail as $indents_Data_Details) {
                  	//if($indents_Data_Details->remaning_qty != 0){
                  	$material_name_id = getNameById('material', $indents_Data_Details->material_name_id, 'id');
                  	
                  	///pre($material_name_id);
                  	?>
               <div class="well <?php if($i==1){ echo 'edit-row1 mobile-view scend-tr ';}else{ echo 'scend-tr mobile-view';}?>" id="chkWell_<?php echo $i; ?>" >
			  <div class="col-md-2 col-sm-12 col-xs-6 form-group">
                           <label class="col-md-2 col-sm-12 col-xs-12">Material Type</label>
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class select2-width-imp" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type" readonly>
                              <option value="">Select Option</option>  
                               <?php
                                 if(!empty($indents_Data_Details->material_type_id)){
                                    $material_type_id1 = getNameById('material_type',$indents_Data_Details->material_type_id,'id');
                                    echo '<option value="'.$indents_Data_Details->material_type_id.'" selected>'.$material_type_id1->name.'</option>';
                                    }
                                 ?> 
                           </select>                               
                        </div>
                  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                     <label>M. Name </label>
                     <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 select2-width-imp" id="mat_name"  name="material_name[]" disabled onchange="getTax(event,this)" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND material_type_id = <?php echo $indents->material_type_id;?> AND status=1">
                        <option value="">Select Option</option>
                        <?php
                           echo '<option value="' . $indents_Data_Details->material_name_id . '" selected>' . $material_name_id->material_name . '</option>';
                           
                           ?>
                     </select>
					   <input type="hidden" name="material_name[]" value="<?php echo $indents_Data_Details->material_name_id; ?>">

                  </div>
				  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                     <label>Alias</label>
                      <input type="text" class="form-control col-md-7 col-xs-12 " name="material_name[]" value="">			
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Description</label>
                     <textarea readonly id="description" name="description[]" class="form-control col-md-7 col-xs-12 description"><?php if ($indents && !empty($indents)) {	echo $indents_Data_Details->description;	} ?></textarea>			
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                     <label style="float:left; width:100%">Quantity &nbsp; &nbsp; UOM</label>
                     <input readonly type="text" id="quantity_<?php echo $indents_Data_Details->material_name_id;?>" name="quantity[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event quantity" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" value="<?php if ($indents && !empty($indents)) { echo $indents_Data_Details->remaning_qty;} ?>"  min="0" onkeypress="return float_validation(event, this.value)">
                     <input type="hidden" value="1" name="po_or_not">
                     <input type="text" id="uom" name="uom1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12 uom" value="<?php 
                        if ($indents && !empty($indents)) {
                        $ww =  getNameById('uom', $indents_Data_Details->uom,'id');
                        $uom = !empty($ww)?$ww->ugc_code:'';
                        echo $uom;
                        }?>" readonly>
                     <input type="hidden" name="uom[]"  value="<?php echo $indents_Data_Details->uom; ?>">
                     <input type="hidden" id="description_check" name="description_check[]" placeholder="description_check" class="form-control col-md-7 col-xs-12" value="<?php if ($indents && !empty($indents)) { echo $indents_Data_Details->description;} ?>" readonly>
                  </div>
				  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                     <label>Last Purchase Price</label>
                      <input type="text" class="form-control col-md-7 col-xs-12 " name="material_name[]" value="">			
                  </div>
                  <?php $quantity =0;
                     $quantity =  $indents_Data_Details->remaning_qty;
					 $minprice ="";
						$minprice = GetMinExpectedPrice('purchase_rfq',$indents->id,$indents_Data_Details->material_name_id);
						$sub_total = $minprice*$quantity;

                                        ?>
                  <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>Piece Price</label>
                     <input type="text" name="price[]" id="price_<?php echo $indents_Data_Details->material_name_id;?>"  placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" value="<?php if($indents && !empty($indents)){ echo $minprice;} ?>"  min="0" onkeypress="return float_validation(event, this.value)" readonly>
                  </div>
                  <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>Sub Total</label>
                     <input type="text" name="sub_total[]" id="sub_total_<?php echo $indents_Data_Details->material_name_id;?>" placeholder="sub total" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php if($indents && !empty($indents)){ echo  $sub_total ;} ?>"  min="0">
                  </div>
                  <!--   <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>GST</label>
                     <input type="text" name="gst[]" placeholder="gst" class="form-control col-md-7 col-xs-12 key-up-event gst_tax" id="gst_tax" value="<?php if (!empty($material_name_id)) echo $material_name_id->tax; ?>" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"  min="0" onkeypress="return float_validation(event, this.value)">
                     </div>
                     <?php /* $sub_total= $ExpectedAmount->minprice*$quantity;
                        if(!empty($material_name_id) && $material_name_id->tax != ''   ){
                        	$subtax = $sub_total * $material_name_id->tax/100;
                        }else{
                        	$subtax = 0;
                        }
                        
                        $total = $sub_total + $subtax;
                         */
                        ?>
                     <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <label>Sub Tax</label>
                     <input type="text" name="sub_tax[]" placeholder="tax" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php echo $subtax; ?>"  min="0">
                     </div>
                     <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                     <label style="border-right: 1px solid #c1c1c1 !important;">Total</label>
                     <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="total[]" placeholder="total" class="form-control col-md-7 col-xs-12 key-up-event" readonly value="<?php echo $total; ?>"  min="0">
                     </div>
                     </div>-->
                  <?php $i++;
                    // }elseif($indents_Data_Details->remaning_qty == 0){ ?>
                  <input type="hidden" value="<?php echo $indents_Data_Details->material_name_id;?>" name="remove_mat" >
                  <?php	}
                     //}
                     }
                     }
                     
                     ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <h3 class="Material-head" style="margin-bottom: 30px;">
      Selected Supplier (By RFQ)
      <hr>
   </h3>
   <div class="item form-group">
      <div class=" input_holder middle-box col-md-12" >
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Supplier Name</th>
                  <th>GSTIN</th>
                  <th>Contact person</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Delivery Date</th>
               </tr>
            </thead>
            <tbody id="table_data1">
               <?php if(!empty($indents->rfq_supp)){
               
                  $rfq_supp_ids = json_decode($indents->rfq_supp, true);	
                  
                  for($i=0;$i<count($rfq_supp_ids);$i++){
                    $supplier = getNameById('supplier', $rfq_supp_ids[$i],'id'); 
                    $supplierContactDetail =json_decode($supplier->contact_detail);
                    $GetRFQSupplier = GetRFQSupplier('purchase_rfq',$indents->id,$supplier->id);
                    //pre($GetRFQSupplier);
				       //pre($GetRFQSupplier);<input type="hidden" name="supplier_details['.$supplier->id.']" value="" id="supplier_details_'.$supplier->id.'">
                    echo '<tr class="parent"  style="background-color:#ffe7db" title="Click to expand/collapse"  id="row_'.$supplier->id.'" style="cursor: pointer;">
                     <td class="details-control"><i class="fa fa-plus fa-clickable"></i></td>
                  <td>'.$supplier->name.'</td>
                  <td>'.$supplier->gstin.'</td>	
                  <td>'.$supplierContactDetail[0]->contact_detail.'</td>	
                  <td>'.$supplierContactDetail[0]->email.'</td>							
                  <td>'.$supplier->address.'</td>
                  <td>'.$GetRFQSupplier->supplier_expected_deliv_date.'</td>
                  <input type="hidden" name="supplier_details['.$supplier->id.']" value="" id="supplier_details_'.$supplier->id.'">
                 
                    </tr>';
                     echo '<tr id="ProTable_'.$supplier->id.'" class="child-row_'.$supplier->id.'"  >
                  <td colspan="6">
                  <form id="updateExpAmount'.$i.'">
                  <table class="table table-bordered" style="padding-left:50px;">
                  	<thead>
                  	   <tr>
                           <th></th>
                  		  <th>Material Type</th>
                  		  <th>Material Name</th>
                  		  <th>Description</th>
                  		  <th>Quantity</th>
                  		  <th>UOM</th>
                  		  <th>Expected Amount</th> 
                  	   </tr>
                  	</thead>
                  	<tbody>';
                   if(!empty($indents) && $indents->material_name !=''){ 
                  		$product_info = json_decode($indents->material_name);
                  		if(!empty($product_info)){
                  			foreach($product_info as $productInfo){
                  				$material_id = $productInfo->material_name_id;
                  				$materialName = getNameById('material',$material_id,'id');
                  				$ww =  getNameById('uom', $productInfo->uom,'id');
                  				$uom = !empty($ww)?$ww->ugc_code:'';
                  				$ExpectedAmount = GetExpectedPriceOFSupplier('purchase_rfq',$indents->id,$supplier->id,$material_id);
								if(!empty($ExpectedAmount->supplier_expected_amount)){
									$arrayOfPrices[$material_id][] = $ExpectedAmount->supplier_expected_amount;
									$min_price= min($arrayOfPrices[$material_id]);
									$checked = ($min_price == $ExpectedAmount->supplier_expected_amount) ? 'checked' : '';
									$setchecked = "";
								if($ExpectedAmount->selected_status == 1){	
									$Matarray[] =  $ExpectedAmount->product_id;
									$setchecked =  'checked';
								}
								  if(in_array($ExpectedAmount->product_id,$Matarray)){
													   $checked  = '';
								  }
								  $mat_type_id=getNameById('material_type',$productInfo->material_type_id,'id'); 
								  if (!empty($mat_type_id)) { $mattype_name = $mat_type_id->name;	}else{ $mattype_name =  $matriealtype_name; }
								  echo '<tr>
								  <td><input type="radio" class="pro_id" name="pro_id_'.$material_id.'" data-checked="'.$ExpectedAmount->id.'" value="'.$supplier->id.'_'.$material_id.'_'.$ExpectedAmount->supplier_expected_amount.'_'.$ExpectedAmount->id.'" '.(!empty($ExpectedAmount->selected_status)?"checked":"").'></td>
														 <td>'.$mattype_name.'</td>
														<td>'.$materialName->material_name.'</td>
														<td>'.$productInfo->description.'</td>	
														<td>'.$productInfo->quantity.'</td>	
														<td>'.$uom.'</td>
														<td>'.$ExpectedAmount->supplier_expected_amount.'</td>							
													</tr>';
							  }else{
								  echo '<tr><td>Please Update Price for '.$materialName->material_name.'  to select this Supplier</td></tr>';
							  }
                  			 }									 
                  		}
                  	 }
                  	echo '</tbody> 
                    </table></form></td></tr>';
                              } 
                  } ?>
            </tbody>
         </table>
      </div>
      <div class="col-md-12">
         <center>
            <input type="button" value="Finalize Quotation" class="btn edit-end-btn select_price_rfq">
         </center>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <!--<div class="heading">
      <h4>Material Details </h4>
      <div style="color:red"; class="msg1"></div>
      <div style="color:green"; class="msg2"></div>
      </div>-->
   <h3 class="Material-head" style="margin-bottom: 30px;">
      Send RFQ Details to Supplier
      <hr>
   </h3>
   <div class="col-md-12 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="material">Add Supplier to Send Email</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select  class="prefferedSupplier form-control col-md-2 col-xs-12 selectAjaxOption select2 add_more_Supplier select2-width-imp" id="preffered_suppliers"  name="preffered_suppliers" data-id="supplier" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true"  onchange="showRFQUser(this.value)" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND contact_detail !=''">
               <option value="">Select Supplier</option>
               <?php
                 /* $supplier_name_id = getNameById('supplier',$indents->preffered_supplier,'id');
                  if(!empty($indents) && $supplier_name_id !=''){
                  echo '<option value="'.$indents->preffered_supplier.'" selected>'.$supplier_name_id->name.'</option>';
                  }*/
                  
                  ?>	
            </select>
            <div id="supp_ids"></div>
         </div>
      </div>
   </div>
   <div class="item form-group">
      <div class=" input_holder middle-box col-md-12" >
         <table class="table table-striped table-bordered" id="detail_table">
            <thead>
               <tr>
                  <th>Action</th>
                  <th>Supplier Name</th>
                  <th>GSTIN</th>
                  <th>Contact person</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Delivery Date</th>
               </tr>
            </thead>
            <tbody id="table_data">
               <?php if(!empty($indents->rfq_supp)){
                  $rfq_supp_ids = json_decode($indents->rfq_supp, true);	
                  $j = 0;
                  for($i=0;$i<count($rfq_supp_ids);$i++){
                    $supplier = getNameById('supplier', $rfq_supp_ids[$i],'id'); 
                    $supplierContactDetail =json_decode($supplier->contact_detail);
                    $GetRFQSupplier = GetRFQSupplier('purchase_rfq',$indents->id,$supplier->id);
                  //pre($GetRFQSupplier);die;
                  
                    echo '<tr class="parent" title="Click to expand/collapse"  id="row_'.$supplier->id.'" style="cursor: pointer;">
                     <td class="details-control"><i class="fa fa-plus fa-clickable"></i></td>
                  <td>'.$supplier->name.'</td>
                  <td>'.$supplier->gstin.'</td>	
                  <td>'.$supplierContactDetail[0]->contact_detail.'</td>	
                  <td>'.$supplierContactDetail[0]->email.'</td>							
                  <td>'.$supplier->address.'</td>
                  <td>'.$GetRFQSupplier->supplier_expected_deliv_date.'</td>
                  
                    </tr>';
                     echo '<tr id="ProTable_'.$supplier->id.'" class="child-row_'.$supplier->id.'"  style="display: none;">
                  <td colspan="6">
                  <form id="updateExpAmount'.$i.'">
                  <table class="table table-bordered" style="padding-left:50px;">
                  	<thead>
                  	   <tr>
                  		  <th>Material Type</th>
                  		  <th>Material Name </th>
                  		  <th>Description</th>
                  		  <th>Quantity</th>
                  		  <th>UOM</th>
                  		  <th>Per Piece</th> 
                  		  <th>Update</th>
                  	   </tr>
                  	</thead>
                  	<tbody>';
                   if(!empty($indents) && $indents->material_name !=''){ 
                  		$product_info = json_decode($indents->material_name);
                  		if(!empty($product_info)){
                           $rowSpan = count($product_info);
                           $k = 0;
                  			foreach($product_info as $key => $productInfo){
								//pre($productInfo);
								$mat_type_id=getNameById('material_type',$productInfo->material_type_id,'id'); 
                  				$material_id = $productInfo->material_name_id;
                  				$materialName = getNameById('material',$material_id,'id');
                  				$ww =  getNameById('uom', $productInfo->uom,'id');
                  				$uom = !empty($ww)?$ww->ugc_code:'';
                  				$ExpectedAmount = GetExpectedPriceOFSupplier('purchase_rfq',$indents->id,$supplier->id,$material_id);
                                $ExpectedAmountValue = !empty($ExpectedAmount) ? $ExpectedAmount->supplier_expected_amount : "";                                
                  			   $rfq_id = !empty($ExpectedAmount) ? $ExpectedAmount->id : "";
							   if (!empty($mat_type_id)) { $mattype_name = $mat_type_id->name;	}else{ $mattype_name =  $matriealtype_name; }
                              $tableRows = "";
                  				$tableRows .= "<tr class='material_parent'>
                  					<td>{$mattype_name}</td>
                  					<td>{$materialName->material_name}</td>
                  					<td>{$productInfo->description}</td>	
                  					<td>{$productInfo->quantity}</td>	
                  					<td>{$uom}</td>							
                  					<td>
                  					<input type='hidden' name='supplierPrice[{$j}][product_induction_id]' class='product_induction_id getExpAmount' value='{$indents->id}'>
                  					<input type='hidden' name='supplierPrice[{$j}][supplier_id]' class='supplier_id getExpAmount' value='{$supplier->id}'>
                  					<input type='hidden' name='supplierPrice[{$j}][product_id]' class='product_id getExpAmount' value='{$material_id}'>
                  					<input type='hidden' name='supplierPrice[{$j}][rfq_id]' class='rfq_id getExpAmount' value='{$rfq_id}'>
                  					<input type='hidden' name='supplierPrice[{$j}][supplier_expected_deliv_date]' class='supplier_expected_deliv_date getExpAmount' value='{$GetRFQSupplier->supplier_expected_deliv_date}'>
                  					<input type='text' name='supplierPrice[{$j}][supplier_expected_amount]' class='supplier_expected_amount getExpAmount col-md-7 col-xs-12 key-up-event amount'  placeholder='expected amount' value='{$ExpectedAmountValue}'  min='0' onkeypress='return float_validation(event, this.value)'>	</td>";
                                 if( $k == 0 ){
                                    $tableRows .= "<td rowspan='{$rowSpan}' style='vertical-align: middle;'  ><a class='update_data btn-sm btn edit-end-btn '  href='javascript:void(0);' data-findForm='{$i}'>Update</a></td>";
                                 }
                  				$tableRows .= "</tr>";
                              echo $tableRows;
                              $j++;
                              $k++;
                  			 }									 
                  		}
                  	 }
                  	echo '</tbody> 
                    </table></form></td> </tr>';
                              } 
                  } ?>
            </tbody>
         </table>
      </div>
   </div>
   <hr>
   <div class="form-group">
      <div class="col-md-12">
         <center>
            <input type="submit" value="Send Email" disabled='disabled' id="enableOnInput" class="btn edit-end-btn">
            <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button> 
         </center>
      </div>
   </div>
</form>
<script>
   var measurementUnits = <?php echo json_encode(getUom()); ?>;		
</script>
<script></script>
<style>
   .fa-clickable {
   cursor:pointer;
   outline:none;
   }
   .productinfo {
   display: none;
   }
</style>
<!-- /page content -->