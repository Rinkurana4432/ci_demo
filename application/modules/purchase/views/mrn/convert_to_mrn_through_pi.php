<style type="text/css">
.label-for-laptop label {float: unset;}
</style>
<form method="post" class="form-horizontal convertPiToGrnForm" enctype="multipart/form-data" id="mrn-form" novalidate="novalidate" action="<?php echo base_url(); ?>purchase/saveMRN">
   <input type="hidden" name="id" value="<?php if ($mrn && !empty($mrn)) {
      echo $mrn->id;
      } ?>">
   <input type="hidden" name="pi_id" value="<?php if ($mrnOrder && !empty($mrnOrder)) {
      echo $mrnOrder->id;
      } else if ($mrn && !empty($mrn)) {
      echo $mrn->pi_id;
      } ?>">
   <?php
      $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
      
         ?>                               
   <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
   <input type="hidden" name="save_status" value="1" class="save_status">
   <input type="hidden" name="ifbalance" value="1" >
   <input type="hidden" name="pay_or_not" value="1" >
   <input type="hidden" name="convert_mrn_thgu_pi" value="convert_mrn_thgu_pi" >
   <div class="item form-group">
      <?php
         //pre($mrnOrder);
         if (!empty($mrnOrder)) {
            $newDate = date("d-m-Y", strtotime($mrnOrder->created_date));   
         
            ?>
      </br>
      <center><b>PI Number : </b> <?php echo $mrnOrder->indent_code; ?></center>
      <center><b>PI Created Date : </b> <?php echo $newDate; ?> </center>
      <br />
      <?php  } ?>
      <input type="hidden" value="<?php if ($mrnOrder && !empty($mrnOrder)) { echo $mrnOrder->pi_id;}?>" name="purchase_indent_id" >
      <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="Bill No">Invoice No.</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <input type="text" name="bill_no" class="form-control col-md-7 col-xs-12" placeholder="Invoice No" value="" required="required">
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="Bill No">Invoice Date.</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <input type="text" name="bill_date" class="form-control col-md-7 col-xs-12 bill_datee" placeholder="Invoice Date" value="<?php if ($mrn && !empty($mrn)) {echo $mrn->bill_date;} ?>" required="required">
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="company_unit">Company Unit<span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <select class="form-control  select2 address select2-width-imp" required="required" name="company_unit">
                  <option value="">Select Option</option>
                  <?php
                     if(!empty($mrnOrder)){
                        $getUnitName = getNameById('company_address',$mrnOrder->company_unit,'compny_branch_id');
                        echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                        }
                     ?>
               </select>
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="company_unit">Cost Center</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 select2-hidden-accessible select2-width-imp"
               name="cost_center" data-id="purchase_cost_center" data-key="id" data-fieldname="cost_center_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?= $_SESSION['loggedInUser']->c_id ?> AND status=1" placeholder="Select Cost Center">
                  <option value="">Select Cost Center</option>
               </select>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="supplier_name">Supplier Name <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <select class="supplierName form-control col-md-2 col-xs-12 selectAjaxOption select2 requrid_class add_more_Supplier select2-width-imp" id="supplier_name" required="required" name="supplier_name" data-id="supplier" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status=1" onchange="getSupplierAddress(event,this)">
                  <option value="">Select Supplier</option>
                  <?php
                     if (!empty($mrnOrder)) {
                        $supplier_name_id = getNameById('supplier', $mrnOrder->preffered_supplier, 'id');
                        echo '<option value="' . $mrnOrder->preffered_supplier . '" selected  data-id="' . $supplier_name_id->address . '">' . $supplier_name_id->name . '</option>';
                     }
                     ?>
               </select>
               <span class="spanLeft control-label"></span>
            </div>
         </div>
         <input type="hidden" value="" id="party_billing_state_id">
         <input type="hidden" value="<?php if(!empty($mrnOrder)){ echo $supplier_name_id->state; } ?>" id="sale_company_state_id">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="address">Address</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <textarea id="address" name="address" class="form-control col-md-7 col-xs-12" placeholder="Display when supplier is selected from above"><?php if ($mrnOrder  && !empty($mrnOrder)) {
                  $supplier_name_id = getNameById('supplier', $mrnOrder->supplier_name, 'id');
                  echo $supplier_name_id->address;} ?></textarea>         
            </div>
         </div>
      </div>
      <hr>
      <div class="bottom-bdr"></div>
      <!--<div class="heading">
         <h4>Material Details </h4>
         </div>-->
      <h3 class="Material-head" style="margin-bottom: 30px;">
         Material Details
         <hr>
      </h3>
         <div class="item form-group ">
            <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
               <div class="">
                  <div class="goods_descr_wrapper">
                     <div class="col-md-12 input_material middle-box for-bdr label-box label-for-laptop">
                        <?php
                           if (!empty($mrnOrder) && $mrnOrder->material_name != '') {
                              // pre($mrnOrder);
                               echo " ";
                              $OrderMaterialDetails = json_decode($mrnOrder->material_name);
                              if (!empty($OrderMaterialDetails)) {
                                 $i =  1;
                                 ?>
                                 <!-- <label class="col-md-1 col-sm-12 col-xs-6 ">M. Type <span class="required">*</span></label> -->
                                 <label class="col-md-2 col-sm-12 col-xs-6 ">M. Name <span class="required">*</span></label>
                                 <label class="col-md-1 col-sm-12 col-xs-6 ">Lot No.</label>
                                 <label class="col-md-1 col-sm-12 col-xs-12 ">Alias</label>
                                 <label class="col-md-1 col-sm-6 col-xs-6 textStart" >Qty&nbsp; &nbsp; &nbsp; UOM</label>
                                 <label class="col-md-1 col-sm-6 col-xs-6 ">price</label>
                                 <label class="col-md-1 col-sm-6 col-xs-12 ">GST</label>
                                 <label class="col-md-1 col-sm-6 col-xs-6 ">Tax</label>
                                 <!-- <label class="col-md-1 col-sm-6 col-xs-6">Total Tax</label> -->
                                 <label class="col-md-1 col-sm-6 col-xs-6 ">Rcv'd | Invoice Oty</label>
                                 <label class="col-md-1 col-sm-6 col-xs-12">Total</label>
                                 <!-- <label class="col-md-1 col-sm-6 col-xs-6 ">Defected:</label> -->
                                 <label class="col-md-2 col-sm-6 col-xs-6 textStart">Defected &nbsp;&nbsp; Qty&nbsp;&nbsp; Reason:</label>
						</div>
					<div class="col-md-12 input_material middle-box for-bdr " style="margin: 0px;padding: 0px;">
                     <?php
                        foreach ($OrderMaterialDetails as $OrderMaterialDetail) {
                           if($OrderMaterialDetail->remaning_qty != 0){
                           $material_id = $OrderMaterialDetail->material_name_id;
                           $materialName = getNameById('material', $material_id, 'id');

                           /* grn material details add in materialData.php */

                           $allData = ['mrnOrder' => $mrnOrder,'OrderMaterialDetail' => $OrderMaterialDetail,'materialName' => $materialName,'i' => $i,'typeGrn' => 'convert_pi_to_mrn' ];
                              echo $this->load->view('materialData',$allData);
                              
                      $i++;
                        }elseif($OrderMaterialDetail->remaning_qty == 0){ ?>
                     <input type="hidden" value="<?php echo $OrderMaterialDetail->material_name_id;?>" name="remove_mat" >
                     <?php }
                        }
                        } 
                        }  
                        ?>
                  </div>
                     <div class="col-sm-12 btn-row" style="bottom:-37px;"><button class="btn  plus-btn addButton  edit-end-btn" style="    margin: 0px;" type="button" disabled>Add</button></div>
                  </div>
               </div>
            </div>
         </div>
     
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="grand">Grand Total</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" class="form-control col-md-7 col-xs-12" id="subttot" name="grand_total" placeholder="Grand Total" value="<?php if (!empty($mrn)) {
               echo $mrn->grand_total;
               } else if (!empty($mrnOrder)) {
               echo $mrnOrder->grand_total;
               } ?>" <?php if (!empty($mrnOrder)) echo 'readonly'; ?>>
            <input type="hidden" name="total_amount_purchase" id="total_amount_purchase"  >                                                                                         
            <input type="hidden" name="total_tax" id="total_tax"  >                                                                                         
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="payment">Payment Mode</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="payment_terms" name="payment_terms" class="form-control col-md-7 col-xs-12" placeholder="Payment Terms" value="<?php if(!empty($mrnOrder)) echo $mrnOrder->payment_terms;?>">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="material">Delivery Address</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control  address get_state_id select2-width-imp" name="delivery_address"  id="address">
               <option value="">Select Option</option>
               <?php
                  if (!empty($mrnOrder)) {
                     $brnch_name = getNameById_with_cid('company_address', $mrnOrder->delivery_address, 'id','created_by_cid',$this->companyGroupId);
                     echo '<option value="' . $mrnOrder->delivery_address . '" selected>' . $brnch_name->location . '</option>';
                  }
                  ?>
            </select>
         </div>
      </div>
      <input type="hidden" value="" name="dilivery_add_state" id="state_id22">
     
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="expected_Del">Received Date</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="expected_delivery" name="received_date" class="form-control col-md-7 col-xs-12 delivery_date" placeholder="Received Date" value="<?php if ($mrnOrder && !empty($mrnOrder)) { echo $mrnOrder->received_date;  } ?>" required="required">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="pay">Payment Date</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="payment_date" name="payment_date" class="form-control col-md-7 col-xs-12 delivery_date" placeholder="Payment date" value="<?php if (!empty($mrnOrder)) {
               echo $mrnOrder->payment_date;
               } ?>" readonly>
         </div>
      </div>
     
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Choose</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <p>
               FOR:
               <input type="radio" class="flat" name="terms_delivery" id="for" value="FORPrice" checked="" required <?php if (!empty($mrnOrder) && $mrnOrder->terms_delivery == 'FORPrice') echo 'checked';else echo 'checked'; ?> />
               To be paid by customer:
               <input type="radio" class="flat" name="terms_delivery" id="exFact" value="To be paid by customer" <?php if (!empty($mrnOrder) && $mrnOrder->terms_delivery == 'To be paid by customer') echo 'checked'; ?> />
            </p>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-5 col-sm-12 col-xs-12" for="textarea">Purchase PI to GRN Conversation Complete</label>
         <div class="col-md-7 col-sm-12 col-xs-12">
            <input type="checkbox" name="purchaseComplete" value="1">
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group" id="freight1" >
         <label class="col-md-3 col-sm-12 col-xs-12" for="freight">Freight</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="freight" name="freight" class="form-control col-md-7 col-xs-12 key-up-event" placeholder="Freight"  value="<?php if (!empty($mrnOrder)) {echo $mrnOrder->freight;} ?>" onkeyup="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)">
         </div>
      </div>
      <div class="item form-group" id="other_charges">
         <label class="col-md-3 col-sm-12 col-xs-12" for="other_charges">Other Charges (Rs)</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="other_charges" name="other_charges" class="form-control col-md-7 col-xs-12 key-up-event" placeholder="Other Charges" value="<?php if (!empty($mrnOrder)) { echo $mrnOrder->other_charges;} ?>" onkeyup="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Terms and conditions </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea id="tnc" name="terms_conditions" class="form-control col-md-7 col-xs-12" placeholder="Terms And conditons" ><?php if (!empty($mrnOrder)) {
               echo $mrnOrder->terms_conditions;
               } ?></textarea>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="rating">Ratings</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="star-rating">
               <?php $countEmptyStar = 5-$mrnOrder->rating;
                  $i = 1;
                  while($i<=$mrnOrder->rating) {
                     echo '<s class="active"></s>';
                     $i++;
                  }
                  $j = 1;
                  while($j<=$countEmptyStar) {
                     echo '<s></s>';
                     $j++;
                  } ?>
            </div>
            <!--<div class="show-result">No stars selected yet.</div>-->
            <input type="hidden" name="rating" id="hidden_rating" class="form-control col-md-7 col-xs-12" placeholder="Rating" value="">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="rating"></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="hidden" name="rate" id="hide_rat" class="form-control col-md-7 col-xs-12" placeholder="Rating" value="<?php //if(!empty($mrn)) { echo "selected &nbsp;&nbsp;".$mrn->rating."&nbsp; &nbsp; Stars"; }  
               ?>" readonly>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="comment">Comments</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea id="comment" name="comments" class="form-control col-md-7 col-xs-12" placeholder="comments"></textarea>
         </div>
      </div>
	   <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="date">Order Date</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="current_date_2" name="date" class="form-control col-md-7 col-xs-12" placeholder="Display the Current Date" <?php if (!empty($mrnOrder)) echo 'readonly'; ?> value="<?php if (!empty($mrnOrder)) {   echo date("d-m-Y", strtotime($mrnOrder->required_date)); } ?>"> 
         </div>
      </div>
	<?php /*  
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="proof">Document </label>
         <div class="col-md-6 col-sm-12 col-xs-12 fields_wrap" >
            <div class="col-md-10 col-sm-11 col-xs-12"style="margin-bottom: 3%;     padding-left: 0px;">
               <input type="file" class="form-control col-md-7 col-xs-12" name="docss[]" >
            </div>
            <button class="btn edit-end-btn  add_more_docs" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button>
         </div>
      </div>
      <?php 
         if(!empty($docss)){
                     ?>
      <div class="item form-group">
         <label class="col-md-3 col-sm-2 col-xs-12" for="proof"></label>
         <div class="col-md-7">
            <?php
               $img = "";
               $imageExist = ['jpg','gif','jpeg','png','ico','jfif'];
               $docsExist  = ['ods','doc','docx'];
               foreach($docss as $proofs){   
               $ext = pathinfo($proofs['file_name'], PATHINFO_EXTENSION);
               if(in_array($ext,$imageExist)){
               $img = "assets/modules/purchase/uploads/{$proofs['file_name']}";
               }else if(in_array($ext,$docsExist)){
               $img = "assets/images/docX.png";
               }else if($ext == 'pdf'){
               $img = "assets/images/PDF.png";
               }else if($ext == 'xlsx'){
               $img = "assets/images/excel.png";   
               }
                  if( $img ){
                  echo '<div  class="col-md-4"><div class="image view view-first"><a download href="'.base_url().'assets/modules/purchase/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().$img.'" alt="image" height="100" width="100"/><i class="fa fa-download"></i></a>
                           <div class="mask">
                  <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'purchase/delete_doccs/'.$proofs['id'].'/'.$mrnOrder->id.'">
                  <i class="fa fa-trash"></i>
                  </a>
                  </div></div></div>'; 
                  }
               }
               
               ?>
         </div>
      </div>
      <?php }
         $checkedExist = false;
             if( $mrnOrder->purchase_type ){
                $checkedExist = true;
             }
         
          ?>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="proof">Type</label>
         <div class="col-md-6 col-sm-12 col-xs-12 fields_wrap" >
            <div class="col-md-9 col-sm-11 col-xs-12 purchase_type" style="margin-bottom: 3%;     padding-left: 0px; ">
               <input type="radio" class="validate" name="purchase_type" value="0" <?php if($checkedExist){ if(  !$mrnOrder->purchase_type ){ echo "checked";  } }else{ echo "checked"; } ?>  > Domestic
               <input type="radio" class="validate"  name="purchase_type" value="1" <?php  if( $mrnOrder->purchase_type ){ echo "checked";  }  ?>> Import
            </div>
         </div>
      </div>
   </div>
    */ ?>  
   </div>
   <hr>
   <div class="form-group">
      <div class="col-md-6 col-md-offset-3">
         <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
         <button type="reset" class="btn edit-end-btn ">Reset</button>
         <input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">
         <button id="send" type="submit" class="btn edit-end-btn">Submit</button>
      </div>
   </div>
</form>
<!-- /page content -->
<!---------------------------------------------------Add quick material code----------------------------------------------->
<?php $this->load->view('addQuickMaterial',$materials); ?>
<!-- Quick add supplier -->
<?php $this->load->view('addQuickSupplier') ?>
<!-- Quick add lot  -->
<?php $this->load->view('addQuickLot') ?>