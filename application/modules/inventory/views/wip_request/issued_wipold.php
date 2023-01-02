								<?php

								$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

								?>

								<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveWorkInProcessMaterial" enctype="multipart/form-data" id="similarmachine" novalidate="novalidate">
								<div class="item form-group col-md-8 col-xs-12"></div>	
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">		
								<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="code">Request No.</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								<input id="material_code" class="form-control col-md-7 col-xs-12" name="request_id" placeholder="Request No." type="text" value="<?php if(!empty($materialissue)) echo $materialissue->request_id;?>" readonly>
								</div>
								</div>
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">	
								<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="code">Request date.</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="date" name="record_date" id="acknowledge" class="form-control col-md-7 col-xs-12 req_date">	
								</div>	
								</div>	  
								</div>	  
								<div class="item form-group ">
								<div class="col-md-12 col-sm-12 col-xs-12 ">
								<div class="panel-default">
								<h3 class="Material-head">Product Detail<span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span><hr></h3>

								<div class="panel-body goods_descr_wrapper  middle-box2">


								<?php
								$j = 0;  
								if($materialissue->mat_detail !=''){
								$workinpromat = json_decode($materialissue->mat_detail);   
								foreach($workinpromat as $key => $work_in_pro_mat){
								$j++;  
								$workinpromat2 = json_decode($work_in_pro_mat->input_process);
								$workorder_name =  getNameById('work_order', $work_in_pro_mat->work_order_id_select,'id');

								?>
								<div class="well" id="chkIndex_<?=$j;?>" style="overflow:auto;">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group">
								<label>Work Order <span class="required">*</span></label>
								<select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId" onchange="getMaterialOfWorkOrder(this.id,1);getMaterialQuantites(event,this,'work_order')" name="work_order_id_select[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND progress_status = 0" id="multipleSelect_<?=$j;?>"  >
								<option value="">Select Option</option>
								<?php if(!empty($work_in_pro_mat->work_order_id_select)){
								$workorder_name =  getNameById('work_order', $work_in_pro_mat->work_order_id_select,'id');
								echo '<option value="'.$work_in_pro_mat->work_order_id_select.'" selected >'.$workorder_name->workorder_name.'</option>';
								}?>
								</select> 
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 form-group">
								<label>Product Name <span class="required">*</span></label>
								<select class="form-control "   name="work_order_product[]"  id="work_order_product" >
								<option value="">Select Option</option>
								<?php if(!empty($work_in_pro_mat->work_order_product)){
								$material =  getNameById('material', $work_in_pro_mat->work_order_product,'id');
								echo '<option value="'.$work_in_pro_mat->work_order_product.'" selected >'.$material->material_name.'</option>';
								}?>
								</select>
								</div>   
								</div>
								<div class="col-md-12 input_holder input_material_wrap " style="border-top: 1px solid #c1c1c1; padding:0px;">
								<div class="well" id="chkIndex_11">
								<div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Product Type</label></div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Product name</label></div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Lot No.</label></div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Quantity</label></div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Uom</label></div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>location</label></div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Area</label></div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>RackNumber</label></div> 
								<div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Work Order</label></div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>NPDM</label></div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Machine Name</label></div>
								</div>
								<?php
								$i = 1;  
								foreach( $workinpromat2 as $workinpromatall ){ ?> 
								<div class="well" id="chkIndex_<?php echo $i; ?>" style="overflow:auto;">
								<div class="col-md-2 col-sm-6 col-xs-12 form-group">
								<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requiredData"   name="material_type_id_<?=$j;?>[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
								<option value="">Select Option</option>
								<?php if(!empty($workinpromatall->material_type_id)){
								$ww =  getNameById('material_type', $workinpromatall->material_type_id,'id');
								echo '<option value="'.$workinpromatall->material_type_id.'" selected >'.$ww->name.'</option>';
								}?>
								</select>
								</div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group">

								<select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name requiredData"  name="material_name_<?=$j;?>[]" onchange="getUom(event,this);getlot(event,this);getMaterialQuantites(event,this,'material')" id="mat_id_funcs">
								<option value="">Select Option</option>
								<?php if(!empty($workinpromatall->material_id)){
								$ww1 =  getNameById('material', $workinpromatall->material_id,'id');
								echo '<option value="'.$workinpromatall->material_id.'" selected >'.$ww1->material_name.'</option>';
								}?>
								</select>
								</div>
								<div class="col-md-1 col-sm-12 col-xs-6 form-group">

								<select class="lotno form-control col-md-2 col-xs-12 selectAjaxOption select2 requiredData" id="lotno" name="lotno_<?=$j;?>[]" data-id="lot_details" data-key="id" data-fieldname="lot_number" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND active_inactive=1">
								<option value="">Select Option</option>
								<?php
								if (!empty($workinpromatall->lot_id && $workinpromatall->lot_id)) {
								$material_type_id1 = getNameById('lot_details', $workinpromatall->lot_id, 'id');
								echo '<option value="' . $workinpromatall->lot_id . '" selected>' . $material_type_id1->lot_number . '</option>';
								} ?>
								</select>
								</div>

								<div class="col-md-1 col-sm-6 col-xs-12 form-group">

								<input type ="text"  id="qty" name="qty_<?=$j;?>[]"  class="form-control col-md-7 col-xs-12 keyup_event" placeholder="quantity" value="<?php if(!empty($workinpromatall->quantity)){ echo $workinpromatall->quantity; } ?>" placeholder="Qty">
								</div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group"> 
								<input style="width:100% !important;" name="uom1_<?=$j;?>[]" type="text" placeholder="uom" class="form-control col-md-7 col-xs-12 uom1" readonly>
								<input  type="hidden" id="uom" name="uom_<?=$j;?>[]" class="form-control col-md-7 col-xs-12 uom" value="<?php echo $workinpromatall->uom?>" readonly placeholder="uom">
								</div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group">
								<select class="location form-control selectAjaxOption select2 select2-hidden-accessible location requiredData" name="location_<?=$j;?>[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
								<option value="">Select Option</option>
								<?php 
								if(!empty($workinpromatall->location)){
								$ww11 =  getNameById('company_address', $workinpromatall->location,'id');
								echo '<option value="'.$workinpromatall->location.'" selected >'.$ww11->location.'</option>';
								} ?>
								</select>
								</div>

								<div class="col-md-1 col-sm-6 col-xs-12 form-group"> 												
								<select class="area form-control" name="storage_<?=$j;?>[]" onchange="getRackNo(event,this,this.value);">
								<option value="">Select Storage</option>
								</select>  
								</div>

								<div class="col-md-1 col-sm-6 col-xs-12 form-group"> 
								<select class="rack form-control" name="rackNumber_<?=$j;?>[]">
								<option value="1">Select Rack</option>
								</select>
								</div>								

								<div class="col-md-1 col-sm-6 col-xs-12 form-group">
								<select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId" onchange=" getMaterialQuantites(event,this,'work_order')" required="required"  name="work_order_id_<?=$j;?>[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND progress_status = 0 ">
								<option value="">Select Option</option>
								<?php if(!empty($workinpromatall->work_order_id)){
								$ww111 =  getNameById('work_order', $workinpromatall->work_order_id,'id');
								echo '<option value="'.$workinpromatall->work_order_id.'" selected >'.$ww111->workorder_name.'</option>';
								}?>
								</select> 

								<input type="hidden" class="SelectedSaleOrder" name="sale_order_id_<?=$j;?>[]"  value="<?php echo $workinpromatall->sale_order_id;?>">
								</div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group">
								<select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId"      name="npdm_<?=$i;?>[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="npdm" data-key="id" data-fieldname="product_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> ">
								<option value="">Select Option</option>
								<?php   if(!empty($workinpromatall->npdm)){
								$ww1113 =  getNameById('npdm', $workinpromatall->npdm,'id');
								echo '<option value="'.$workinpromatall->npdm.'" selected >'.$ww1113->product_name.'</option>';
								}?>
								</select>  
								</div>
								<div class="col-md-1 col-sm-6 col-xs-12 form-group">
								<select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId"      name="machine_name_<?=$j;?>[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="add_machine" data-key="id" data-fieldname="machine_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> ">
								<option value="">Select Option</option>
								<?php if(!empty($workinpromatall->machine_name)){
								$ww1112 =  getNameById('add_machine', $workinpromatall->machine_name,'id');
								echo '<option value="'.$workinpromatall->machine_name.'" selected >'.$ww1112->machine_name.'</option>';
								}?>
								</select>  
								</div>
								</div>

								<?php   $i++;  }?> <?php    } }?>
								</div>
								</div>
								</div>
								</div>
								</div>
								</div>

								<hr>

								<input type="hidden" name="wip_request_id" value="<?php if(!empty($materialissue->id)){ echo $materialissue->id; } ?>">
								<input type="hidden" name="mat_detail" value='<?php if(!empty($materialissue->mat_detail)){ echo $materialissue->mat_detail; } ?>'>
								<input type="hidden" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">

								<!-- <label class="col-md-3 col-sm-12 col-xs-12">Aknowledge Date</label>		
								<div class="col-md-6 col-sm-12 col-xs-12">
								<input type="date" name="acknowledege_date" id="acknowledge" class="form-control col-md-7 col-xs-12 req_date">				
								</div>
								</div>  -->
								<div class="col-md-12 col-md-offset-3" style="margin-top: 20px;">
								<center>
								<button type="reset" class="btn btn-default edit-end-btn">Reset</button>
								<!--input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft"-->
								<button id="send" type="submit" class="btn edit-end-btn check_mat_qty">Submit</button>
								<a class="btn edit-end-btn" onclick="location.href='<?php echo base_url();?>inventory/work_in_process'">Cancel</a>
								</center>		
								</div>

								</form> 