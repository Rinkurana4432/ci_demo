<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>	
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/save_reserved_material" enctype="multipart/form-data" id="similarmachine" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php echo  !empty($reserved_mat->id)?$reserved_mat->id:''; ?>">
    <div class="item form-group col-md-8 col-xs-12 vertical-border">												
</div>	
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
	<div class="item form-group vertical-border">
      </div>			 
		<div class="item form-group ">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
				<div class="panel-default">
					<h3 class="Material-head">Reserved Material For Customers<span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span><hr></h3>
						<div class="panel-body add_multiple_customer_reserv  middle-box2">			
							<?php if(empty($reserved_mat)){ ?>
			                    <div class="well " style="overflow:auto; border-top: 1px solid #c1c1c1 ; border-right: 1px solid #c1c1c1 ;" id="chkIndex_1">
			                       <input type="hidden" name="id_loc[]" value="">
			                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
			                           <label>Customer Type</label>
			                           <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="customer_type[]" data-id="types_of_customer" data-key="id" data-fieldname="type_of_customer" width="100%" tabindex="-1" aria-hidden="true" data-where="active_inactive = 1 AND created_by_cid=<?php echo $this->companyGroupId; ?>">
			                              <option value="">Select Option</option>
			                           </select>
			                        </div>
			                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
			                           <label style=" border-right: 1px solid #c1c1c1 !important;">Quantity</label>
			                           <input style=" border-right: 1px solid #c1c1c1 !important;" type="text" id="qty" name="quantityn[]" class="form-control col-md-7 col-xs-12" placeholder="Quantity"> 
			                        </div>
			                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
			                           <label>Product Type <span class="required">*</span></label>
			                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
			                              <option value="">Select Option</option>
			                           </select>
			                        </div>
			                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
			                           <label>Product name <span class="required">*</span></label>
			                           <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name" id="mat_name"  name="material_name[]" onchange="getUom(event,this);">
			                              <option value="">Select Option</option>
			                           </select>
			                        </div>
			                        <div class="btn-row"><button class="btn plus-btn edit-end-btn add_More_btn_reserv" type="button">Add</div>
			                    </div>
                     			<?php } else{ ?>

                     			<div class="well " style="overflow:auto; border-top: 1px solid #c1c1c1 ; border-right: 1px solid #c1c1c1 ;" id="chkIndex_1">
			                        <input type="hidden" name="id_loc[]" value="">
			                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
			                           <label>Customer Type</label>
			                           <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="customer_type[]" data-id="types_of_customer" data-key="id" data-fieldname="type_of_customer" width="100%" tabindex="-1" aria-hidden="true" data-where="active_inactive = 1 AND created_by_cid=<?php echo $this->companyGroupId; ?>">
			                              <option value="">Select Option</option>
			                              <?php 
			                              	$custmrdata = getNameById('types_of_customer',$reserved_mat->customer_id,'id');
			                                 if(!empty($custmrdata)){   
			                                    echo '<option value="'.$custmrdata->id.'" selected>'.$custmrdata->type_of_customer.'</option>';  
			                                 }
			                                 ?>
			                           </select>
			                        </div>
			                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
			                           <label style=" border-right: 1px solid #c1c1c1 !important;">Quantity</label>
			                           <input style=" border-right: 1px solid #c1c1c1 !important;" type="text" id="qty" name="quantityn[]" class="form-control col-md-7 col-xs-12" placeholder="Quantity"
			                           value="<?php echo  !empty($reserved_mat->quantity)?$reserved_mat->quantity:'' ?>"
			                           > 
			                        </div>
			                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
			                           <label>Product Type <span class="required">*</span></label>
			                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
			                              <option value="">Select Option</option>
			                              <?php 
			                              	$mat_type = getNameById('material_type',$reserved_mat->material_type,'id');
			                                 if(!empty($mat_type)){   
			                                    echo '<option value="'.$mat_type->id.'" selected>'.$mat_type->name.'</option>';  
			                                 }
			                              ?>
			                           </select>
			                        </div>
			                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
			                           <label>Product name <span class="required">*</span></label>
			                           <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name" id="mat_name"  name="material_name[]" onchange="getUom(event,this);">
			                              <option value="">Select Option</option>
			                              <?php 
			                              	$matid = getNameById('material',$reserved_mat->mayerial_id,'id');
			                                 if(!empty($matid)){   
			                                    echo '<option value="'.$matid->id.'" selected>'.$matid->material_name.'</option>';  
			                                 }
			                              ?>
			                           </select>
			                        </div>
			                        <div class="btn-row"><button class="btn plus-btn edit-end-btn add_More_btn_reserv" type="button">Add</div>
			                    </div>
			              <?php }#}?>
						</div>
				</div>
			</div>
		</div>
	</div>	
<hr>

             <input type="hidden" name="wip_request_id" value="<?php if(!empty($materialissue->id)){ echo $materialissue->id; } ?>">
			<input type="hidden" name="mat_detail" value='<?php if(!empty($materialissue->mat_detail)){ echo $materialissue->mat_detail; } ?>'>
			 <input type="hidden" name="acknowledge_by" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
	          	<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">		
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
                            <a class="btn edit-end-btn" onclick="location.href='<?php echo base_url();?>inventory/reserved_material'">Cancel</a>
                 </div>
					</center>
              
</form>