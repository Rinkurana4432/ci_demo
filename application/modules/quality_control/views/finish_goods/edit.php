<?php 
$ci = & get_instance();
	 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">				
	<div class="item form-group ">
		<div class="col-md-12 col-sm-12 col-xs-12 recv_finish_goods_add finish-mr middle-box2">
			<div class="panel panel-default">
				<h3 class="Material-head">Received Finish<span id="mat_msg" style="color: red;font-size: 13px;text-align: center;width: 100%;display: block;"></span><hr></b></h3>
					
					
<div class="panel-body middle-box2">
	<div class="col-md-12">
		<?php 
			$job_cardData = json_decode($edit->job_card_detail);
			foreach($job_cardData as $jc_dt){
		?>
		<div class="well" id="chkIndex_1" style="overflow:auto; margin-bottom: 20px;" >
			<div class="item " style="border-top: 1px solid #c1c1c1;padding:0px;">
				
					<div class="col-md-2 col-sm-6 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1 !important;">
					<label  for="mat_name">Job Card</label>
					<?php
						$ww =  getNameById('job_card', $jc_dt->job_card_no,'id');
						$job_card_no = !empty($ww)?$ww->job_card_no:'';
					?>
					<div><?php if(!empty($job_card_no)){ echo $job_card_no; } ?></div>
					</div>	
				<div class="col-md-2 col-sm-6 col-xs-12 form-group">
					<label  for="mat_name">Total Quantity</label>
					<div><?php if(!empty($jc_dt->totalAmountQty)){ echo $jc_dt->totalAmountQty; } ?></div>
				</div>
			
					<div class="col-md-2 item form-group">
						<label for="mate">Product name</label>
					<?php
						$ww =  getNameById('material', $jc_dt->material_id,'id');
						$material_n = !empty($ww)?$ww->material_name:'';
					?>
					<div><?php if(!empty($material_n)){ echo $material_n; } ?></div>
					</div>
					<div class="col-md-2 item form-group">
						<label for="qty">Quantity</label>
						<div><?php if(!empty($jc_dt->quantity)){ echo $jc_dt->quantity; } ?></div>
					</div>	
					<div class="col-md-2 item form-group">
						<label for="Uom">UOM</label>
					<?php
						$ww =  getNameById('uom', $jc_dt->uom,'id');
						$uom = !empty($ww)?$ww->ugc_code:'';
					?>
					<div><?php if(!empty($uom)){ echo $uom; } ?></div>
					</div>	
					<div class="col-md-2 item form-group">
						<label for="output">Output</label>
						<div><?php if(!empty($jc_dt->output)){ echo $jc_dt->output; } ?></div>
					</div>	
						<div class="col-md-2 item form-group">
						<label for="qty">Quantity Passed</label>
						<div>
						<input type="text" name="qty_pass" value="" />
						</div>
					</div>
					<div class="col-md-2 item form-group">
						<label for="qty">Quantity Rework</label>
						<div>
					 <input type="text" name="qty_rework" value="" />    
						</div>
					</div>
						<div class="col-md-2 item form-group">
						<label for="qty">Quantity Remarks</label>
						<div>
						 <input type="text" name="qty_remark" value="" />
						</div>
					</div>
			</div>
		</div>	

		<?php } ?>
				<button id="send" type="submit" class="btn edit-end-btn">Submit</button>
				<a class="btn edit-end-btn" >Cancel</a>
			</div>	
		</div>	
	</div>
</div>
</div>
</div>