<div class="row">
<?php if($this->session->flashdata('message') != ''){
      echo '<div class="alert alert-info">'.$this->session->flashdata('message').'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';

   }
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   ?>

   <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
   <div class="Process-card">
      <div class="col-md-6 col-xs-12 label-left">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Sale Order Number</label>
            <div class="col-md-6 col-sm-12 col-xs-6 form-group">
               <div><?php echo $work_order->sale_order_no; ?></div>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-xs-12 label-left">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Expected Delivery Date</label>
            <div class="col-md-6 col-sm-12 col-xs-6 form-group">
               <div><?php echo $work_order->expected_delivery_date; ?></div>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-xs-12 label-left">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Work Order No</label>
            <div class="col-md-6 col-sm-12 col-xs-6 form-group">
               <div><?php echo $work_order->work_order_no; ?></div>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-xs-12 label-left">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Work Order Name</label>
            <div class="col-md-6 col-sm-12 col-xs-6 form-group">
               <div><?php echo $work_order->workorder_name; ?></div>
            </div>
         </div>
      </div>
      <?php
      //pre($workOrder);die;
      /*
      $work_order_id= getNameById('purchase_indent',$work_order->id, 'work_order_id');

                         if (!empty($work_order_id)) { ?>

                         <?php  } else{ ?>
      <div class="col-md-6 col-xs-12 label-left">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Order Indent</label>
            <div class="col-md-6 col-sm-12 col-xs-6 form-group">
               <div><a href="<?=base_url();?>production/indent_edit/<?=$work_order->id;?>">Indent Create</a></div>
            </div>
         </div>
      </div>
       <?php } */?>

   </div>
</div>
<div class="row">

               <h3 class="Material-head">Materials</h3>
               <?php 
               $work_order_id= getNameById('purchase_indent',$work_order->id, 'work_order_id');
               if(empty($work_order_id)) { ?>
               <button class="btn btn-edit btn-xs indent productionTab indent_create_btn" id="<?=$work_order->id;?>" data-toggle="modal" data-id="indentEdit" style="display: none; float: right;margin-top: -37px; margin-right: 17px;">Indent Create </button> 
               <button class="btn btn-edit btn-xs auto_reserve_btn" id="<?=$work_order->id;?>" style="float: right;margin-top: -37px; margin-right: 115px;">Auto Reserve Material</button>
               <?php } ?>
               
               <?php 
                   $workOrderProductDetails=json_decode($work_order->product_detail,true);
                   $alljobcardqty=[];
                    if($workOrderProductDetails){
                              foreach($workOrderProductDetails as $keyVal => $workOrderProductDetail){

                                   $whereConditionJobCard  =  array('job_card_no' => $workOrderProductDetail['job_card'],'material_id' => '');
                                   $jobCardDetails         =  $this->production_model->get_job_card_data('job_card','material_name_id', $whereConditionJobCard);

                                   if($jobCardDetails){

                                      $alljobcardqty[$jobCardDetails['id']]=$jobCardDetails;
                                      $alljobcardqty[$jobCardDetails['id']]['transfer_quantity'] = $workOrderProductDetail['transfer_quantity'];


                                  }
                              }
                           }
             if($alljobcardqty):
                  foreach($alljobcardqty as $jobkey => $materialInfo12){

                    ?>
                  <h3 class="Jobcardname" style="border-top: 2px solid #ddd;padding: 1% 5px 5px 2.5%"> <?php if (!empty($materialInfo12)) {
                    echo  $materialInfo12['job_card_product_name'];
                   }?> </h3>


               <table class="wo_view_indent input_fields_wrap" id="mytable" style=" border: 1px solid #c1c1c1;">
               <div class="item form-group">
               <div class="col-md-12 input_holder middle-box">
			   <tr>
			       <th style="width: 2%;"><label style="padding: 6px;"><input type="checkbox" class="all_indent_create" value="" checked></label></th>
			       <th style="width: 14%;"><label>Material Name</label></th>
			       <th><label>Material Type</label></th>
			       <th><label>Available Quantity</label></th>
			       <th><label>UOM</label></th>
			       <th><label>Required Qty</label></th>
			       <th><label>Material Shortage</label></th>
			       <th><label>Reserved Qty</label></th>
			       <th><label>Reserve / Unreserve</label></th>
			       <th><label>Sub Bom</label></th>
			       <th style="width: 10%;"><label>Status</label></th>
			       <th><label>Action</label></th>
			   </tr>
                <?php
                       $jobCardMaterialss  = json_decode($materialInfo12['material_details'],true);
                       $res_detail_array="";
                       $i=1;
                                 foreach ($jobCardMaterialss as $key => $materialInfo) {
                         $newQuantityValuert = ($materialInfo12['lot_qty'] != 0 ) ? $materialInfo['quantity'] / $materialInfo12['lot_qty'] : 0;
                                $newQuantityValue= $newQuantityValuert * $materialInfo12['transfer_quantity'];
                                $expectedQuantity = ( $newQuantityValue > 0) ? $materialInfo['quantity'] * $newQuantityValue : $materialInfo['quantity'];
                                  $where = "reserved_material.mayerial_id = '".$materialInfo['material_name_id']."' AND reserved_material.created_by_cid ='".$this->companyId."' AND reserved_material.work_order_id ='".$work_order->id."' AND reserved_material.job_card_id =".$materialInfo12['id'];
                                $reservedData = $this->production_model->get_data_single('reserved_material', $where);
                                $reserved_quantitym = $reservedData ? $reservedData['quantity'] : 0;
                                $yu = getNameById_mat('mat_locations',$materialInfo['material_name_id'],'material_name_id');
                                $sum = 0;
                                if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                                        $unit = $materialInfo['unit'];
                                    $quantity_required = round($newQuantityValue,2);
                                     $reserved_quantity = $reserved_quantitym;
                                     $available_quantity = $sum - $reserved_quantitym;
                                     //pre($materialInfo12['Pending_quantity']);
                  $materialName     = getNameById('material',$materialInfo['material_name_id'],'id');
                   $productDetails   = getNameById('material_type',$materialInfo['material_type_id'],'id');
                  //pre($quantity_order);die();
                   $quantity_order   = getNameById('purchase_indent',$work_order->id,'work_order_id');
                    $materiyalData  = json_decode($quantity_order->material_name??'',true);
                  $sale_order_product_id = getNameById('material', $jobkey, 'job_card');
                  if($quantity_required < $available_quantity){
                  $material_shortage = '0';
                  } else if($quantity_required >= $available_quantity) {
                  $material_shortage = $quantity_required - $available_quantity;
                  }
         ?>

            <tr class="wo_well" id="wochkIndex_<?php echo $i; ?>" style="border-top: 1px solid #c1c1c1 !important;">
               <?php
               $indent_array = $materialInfo['material_type_id'].'~'.$materialInfo['material_name_id'].'~'.$work_order->id.'~'.$jobkey.'~'.$material_shortage;
               $res_detail_array = $materialInfo['material_type_id'].'~'.$materialInfo['material_name_id'].'~'.$work_order->id.'~'.$jobkey.'~'.$sale_order_product_id->id.'~'.$quantity_required.'~'.$available_quantity.'~'.$reserved_quantity;
                ?>
                <td class="form-group"  style="float: left; text-align: center;padding: 0px !important;margin: 0px;"></td>
                <?php  if($quantity_required > $available_quantity) { ?>
                <td class="form-group"  style="float: left; text-align: center; padding: 0px !important;margin: 0px;">
               <label style="padding: 6px; margin-bottom: 0px !important;"></label>
                <input type="checkbox" class="indent_create" value="<?php echo $indent_array;  ?>" checked>
              </td>
                <?php } ?>                
                <td class="col-md-1 col-sm-12 col-xs-12 form-group">
              
               <?php  if(!empty($materialName)){echo $materialName->material_name;}else{echo "N/A";} ?>
               <div class="expand_dropwon form-group">
               <?php 
               $material_data = getNameById('material', $materialInfo['material_name_id'],'id');
               $job_data = getNameById('job_card', $material_data->job_card,'id');
               if(!empty($material_data) && $material_data->job_card!=0 && !empty($job_data)){ ?>
                <span class="up_arrow" style="display: none;"><i style="font-size: 20px;font-weight: bold;"  onclick="expandWoBom(event,this);" wo_parent='parent' wo_exqty='1' jc_number="<?php echo $job_data->job_card_no;  ?>" lot_qty="<?php echo $job_data->lot_qty;  ?>" wo_id="<?php echo $work_order->id; ?>" jobkey="<?php echo $jobkey; ?>" transfer_quantity="<?php echo $materialInfo12['transfer_quantity']; ?>" fst_qty="<?php echo $material_shortage; ?>" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span><span class="down_arrow"><i onclick="expandWoBom(event,this);" wo_parent='parent' wo_exqty='1' jc_number="<?php echo $job_data->job_card_no;  ?>" lot_qty="<?php echo $job_data->lot_qty;  ?>" wo_id="<?php echo $work_order->id; ?>" jobkey="<?php echo $jobkey; ?>" transfer_quantity="<?php echo $materialInfo12['transfer_quantity']; ?>" fst_qty="<?php echo $material_shortage; ?>" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span>
               <?php } else { ?>
               <span class="up_arrow" style="display: none;"><i style="font-size: 20px;font-weight: bold;"  onclick="expandWoBom(event,this);" wo_parent='parent'  wo_exqty='1' jc_number="<?php echo $job_data->job_card_no;  ?>" lot_qty="<?php echo $job_data->lot_qty;  ?>" wo_id="<?php echo $work_order->id; ?>" jobkey="<?php echo $jobkey; ?>" transfer_quantity="<?php echo $materialInfo12['transfer_quantity']; ?>" fst_qty="<?php echo $material_shortage; ?>" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span><span class="down_arrow" style="display: none;"><i onclick="expandWoBom(event,this);" wo_parent='parent' wo_exqty='1' jc_number="<?php echo $job_data->job_card_no;  ?>" lot_qty="<?php echo $job_data->lot_qty;  ?>" wo_id="<?php echo $work_order->id; ?>" jobkey="<?php echo $jobkey; ?>" transfer_quantity="<?php echo $materialInfo12['transfer_quantity']; ?>" fst_qty="<?php echo $material_shortage; ?>" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span>
               <?php } ?> 
               </div> 
               </td>
               
               <td class="col-md-1 col-sm-12 col-xs-12 form-group">
              
               <?php  if(!empty($productDetails)){ echo $productDetails->name; }else{echo "N/A";} ?>
               </td>
               <td class="__availableQuantity col-md-1 col-sm-12 col-xs-12 form-group">
               
               <span class="material_qty_wochkIndex_<?php echo $i; ?>"><?php  echo $available_quantity; ?></span>
               </td>
               <td class="__uom col-md-1 col-sm-12 col-xs-12 form-group">
               
               <?php 
               $ww =  getNameById('uom', $materialName->uom,'id');
               echo $uom = !empty($ww)?$ww->uom_quantity:'N/A';
               ?>
               </td>
               <td class="__quantityRequired col-md-1 col-sm-12 col-xs-12 form-group">
               
               <?php  echo $quantity_required; ?>
               </td>
               <td class="__materialShortage col-md-1 col-sm-12 col-xs-12 form-group">
               
               <?php 
               if($quantity_required < $available_quantity){
               echo '0';
               } else if($quantity_required >= $available_quantity) {
               echo $quantity_required - $available_quantity;
               }
               ?>
               </td>
               <td class="reserved_quantity_main col-md-1 col-sm-12 col-xs-12 form-group">
               
               <span><?php  echo $reserved_quantity; ?></span>
              </td>
               <td class="reserve_unreserve_set col-md-1 col-sm-12 col-xs-12 form-group">
               
               <a id="<?php echo $res_detail_array; ?>" data-toggle="modal" data-id="material_availability_page" data-title="Reserve Material" data-tooltip="Reserved" class="reserve_set btn btn-view btn-xs productionTab reservedPopup <?php  //if($reserved_quantity > 0) { echo 'disabled'; }  ?>"><i class="fa fa-plus"></i></a> <a id="<?php echo $res_detail_array; ?>" data-toggle="modal" data-id="material_availability_page" data-title="Unreserve Material" data-tooltip="UnReserved" class="btn btn-view btn-xs productionTab reservedPopup <?php  //if($reserved_quantity > 0) { echo 'disabled'; }  ?>"><i class="fa fa-minus"></i></a>
              </td>
               <td class="col-md-1 col-sm-12 col-xs-12 form-group">
               
               <?php if(!empty($materialName) && $materialName->job_card==0){
               echo "N/A";
               } else { $job_data = getNameById('job_card', $materialName->job_card,'id'); echo $job_data->job_card_no; } ?>
              </td>
               <td class="col-md-1 col-sm-12 col-xs-12 form-group">
               
               <select name="action" class="action_materials form-control" style="border-left: none!important;border-bottom: none!important;background-color: transparent;color: #73879C;">
                  <?php if($quantity_required > $available_quantity){ ?> 
                  <option selected>Not Available</option>
                  <?php } else if($available_quantity >= $quantity_required){ ?>
                  <option selected>In Stock</option>
                  <?php } else if($reserved_quantity == $quantity_required){ ?>
                  <option selected>Reserved</option>
                  <?php } ?>
                  </select>
               </td>
               <td class="col-md-1 col-sm-12 col-xs-12 form-group action_chk">
              
                     <?php  if($quantity_required > $available_quantity  && $materialName->job_card==0 ) { ?>
                        <span>Create Indent</span>
                     <?php }elseif($quantity_required > $available_quantity  && $materialName->job_card!=0) { ?> <span>Initiate Work Order</span> <?php }elseif($available_quantity > $quantity_required || $reserved_quantity == $quantity_required) { ?>
                        <span>Issue material</span>
                     <?php } ?>
               </td>
            <!--<div class="expand_wobom_wochkIndex_</?php echo $i; ?>"></div>-->
            </tr>


         <?php $i++; } ?>
   </div></div></table><?php }  else: echo '<tr><td>No Material Found.</td></tr>'; endif; ?>

  </div>
  <div id="productionPI_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
           <h4 class="modal-title" id="myModalLabel">Create Work Order Indent</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
<div id="productionMR_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-small">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Reserve/ Unreserve Material</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
var array = [];
$('.action_chk').each(function(key, value) {
array.push($(this).find('span').text());
});
if ($.inArray('Create Indent', array) != -1){
$('.indent_create_btn').show();
} else {
$('.indent_create_btn').hide();
}
});
</script>