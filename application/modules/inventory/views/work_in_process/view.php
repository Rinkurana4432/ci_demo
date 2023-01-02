<?php

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

?>
	

    <div class="item form-group col-md-8 col-xs-12 vertical-border">												
</div>	
	
	<div class="col-md-12 col-sm-12 col-xs-12 form-group">				
		<div class="item form-group ">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
				<div class="panel-default">
					<h3 class="Material-head">Product Detail<span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span><hr></h3>
					
						<div class="panel-body goods_descr_wrapper mr-goods middle-box2">

									<div class="col-md-12 input_holder input_material_wrap" style="border-top: 1px solid #c1c1c1; padding:0px;">
									<div class="well" id="chkIndex_1" style="overflow:auto;">
										<div class="col-md-2 col-sm-6 col-xs-12 form-group"> <label>Product Type</label></div>
										<div class="col-md-2 col-sm-6 col-xs-12 form-group">   <label>Product name</label></div>
										<div class="col-md-2 col-sm-6 col-xs-12 form-group">    <label>Quantity</label></div>
										 <div class="col-md-2 col-sm-6 col-xs-12 form-group">    <label>Uom</label></div>
										   <div class="col-md-2 col-sm-6 col-xs-12 form-group">   <label>location</label></div>
										    <div class="col-md-2 col-sm-6 col-xs-12 form-group">    <label>Work Order</label> </div>
										</div>
										<?php

											if($materialissue->mat_detail !=''){
											$workinpromat = json_decode($materialissue->mat_detail);
											foreach($workinpromat as $work_in_pro_mat){
										?>
										<div class="well" id="chkIndex_1" style="overflow:auto;">
											<div class="col-md-2 col-sm-6 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1 !important;">
											  
												<div class="col-md-6 col-sm-12 col-xs-12 ">
												<?php
													$ww =  getNameById('material_type', $work_in_pro_mat->material_type_id,'id');
													$material_type = !empty($ww)?$ww->name:'';
												?>
												<div><?php if(!empty($material_type)){ echo $material_type; } ?></div>
											</div>
											</div>
											<div class="col-md-2 col-sm-6 col-xs-12 form-group">
												<?php
													$ww =  getNameById('material', $work_in_pro_mat->material_id,'id');
													$material_n = !empty($ww)?$ww->material_name:'';
												?>
											 
												<div><?php if(!empty($material_n)){ echo $material_n; } ?></div>
											</div>
											<div class="col-md-2 col-sm-6 col-xs-12 form-group">
											   
												<div><?php if(!empty($work_in_pro_mat->quantity)){ echo $work_in_pro_mat->quantity; } ?></div>
											</div>
											<div class="col-md-2 col-sm-6 col-xs-12 form-group">
											  
												<?php
													$ww =  getNameById('uom', $work_in_pro_mat->uom,'id');
													$uom = !empty($ww)?$ww->ugc_code:'';
												?>
												<div><?php if(!empty($uom)){ echo $uom; } ?></div>
											</div>
											<div class="col-md-2 col-sm-6 col-xs-12 form-group">
											   
												<?php
													$ww =  getNameById('company_address',$work_in_pro_mat->location,'id');	
													$location = !empty($ww)?$ww->location:'';
												?>
												<div><?php if(!empty($location)){ echo $location; } ?></div>
											</div>
											<div class="col-md-2 col-sm-6 col-xs-12 form-group">
											 
												<?php
													$ww =  getNameById('work_order',$work_in_pro_mat->work_order_id,'id');	
													$wo_order = !empty($ww)?$ww->workorder_name:'';
												?>
												<div><?php if(!empty($wo_order)){ echo $wo_order; } ?></div>
											</div>
											</div>
											</div>
					<?php	
						}

					}
					?>
						</div>
											<div class="col-md-2 col-sm-6 col-xs-12 form-group">
											   <label>Acknowledge by.</label>
												<?php
													$acknowledge_by = ($materialissue->acknowledge_by!=0)?(getNameById('user_detail',$materialissue->acknowledge_by,'u_id')):'';
												$ackname = (!empty($acknowledge_by))?$acknowledge_by->name:'';
												?>
												<div><?php
													echo $ackname;
												?></div>
											</div>

											<div class="col-md-2 col-sm-6 col-xs-12 form-group">
											   <label>Acknowledge Date.</label>
												<?php
													$ack_date = ($materialissue->acknowledege_date!=0)?date("j F , Y", strtotime($materialissue->acknowledege_date)):'N/A';
												?>
												<div><?php
													echo $ack_date;
												?></div>
											</div>
				</div>
			</div>
		</div>
	</div>
	
<hr>
               
                    <div class="col-md-12 col-md-offset-3" style="margin-top: 20px;">
					<center>
                            <a class="btn edit-end-btn" onclick="location.href='<?php echo base_url();?>inventory/work_in_process'">Cancel</a>
                     </div>
					</center>
              
