<div class="x_content">				
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/savePurchaseBudgetLimit" enctype="multipart/form-data" id="myform"" novalidate="novalidate">
        <input type="hidden" name="id" value="<?php  if($purchase_budget && !empty($purchase_budget)){ echo $purchase_budget->id;} ?>">
		<div class="col-md-12 col-sm-12 col-xs-12 vertical-border ">
			<label class="col-md-3 col-sm-3 col-xs-12" for="budget_limit">Purchase Budget Limit<span class="required">*</span></label>
			<div>
				<div class="col-md-6 col-sm-6 col-xs-12 addPurchaseBudgetLimit">
					<?php if(empty($purchase_budget)){ ?>
				
					<div class="col-md-6 col-sm-6 col-xs-12 ">
						<input type="text" class="form-control col-md-7 col-xs-12" name="budget_limit" required="" value="">	
					</div>
				<?php	/* <button class="btn edit-end-btn addMorePurchaseBudgetLimitBtn plus-btn plus-btn" type="button"><i class="fa fa-plus"></i></button> */ ?>
					
				<?php	}else{  ?>
					<div class="col-md-6 col-sm-6 col-xs-12 ">
						<input type="text" class="form-control col-md-7 col-xs-12" name="budget_limit" required="" value="<?php if(!empty($purchase_budget)){echo $purchase_budget->budget_limit; }?>">	
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
		
		
		
		
		
		<hr>
		<div class="bottom-bdr"></div>
		<div class="form-group">
			<div class="col-md-6 col-md-offset-3">
				<button type="reset" class="btn btn-default">Reset</button>
				<button id="send" type="submit" class="btn btn-warning">Submit</button>
				<!-- <button type="button" class="close btn btn-danger" data-dismiss="modal">Cancel</button> -->
				<!-- <a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>production/purchase_setting'">Cancel</a> -->
			</div>
		</div>
    </form>
	
</div>