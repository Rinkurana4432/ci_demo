<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv" style="padding:0px;"> 
	<div class="table-responsive">
		<div class="col-md-12 col-xs-12">
			<h3 class="Material-head">Material Detail<hr></h3>	
			<div class="well col-md-12 pro-details" id="chkIndex_1" >
				 <?php if(!empty($supplier) && $supplier->material_name_id !=''  && $supplier->material_name_id != '[{"material_name_id":"","uom":""}]' ){ ?>
				   <div class="col-container mobile-view2">
						   <div class="col-md-7 col-sm-12 col-xs-12 form-group">Material Name</div>
						   <div class="col-md-5 col-sm-12 col-xs-12 form-group">UOM</div>
							   
					 </div>
					 <?php 
					
							$materialDetail =  json_decode($supplier->material_name_id);
							foreach($materialDetail as $material_detail){
								 // pre($material_detail);
								$material_id=$material_detail->material_name;
								$materialName=getNameById('material',$material_id,'id'); ?>	
								<div class="row-padding col-container mobile-view view-page-mobile-view">
									<div class="col-md-7 col-sm-12 col-xs-12 form-group col">
										<label>Material Name</label>
										<div><?php if(empty($materialName)){echo "Null";} else{ echo $materialName->material_name; }?></div>
										
									</div>
									<div class="col-md-5 col-sm-12 col-xs-12 form-group col">
									   <label>UOM</label>
										<div ><?php  $ww =  getNameById('uom', $materialName->uom,'id');
													$uom = !empty($ww)?$ww->ugc_code:''; 

													echo $uom;
													 ?></div>
										
									</div>
								</div>
					<?php  } ?>
					
					<?php } ?>
					 
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             
            </div>