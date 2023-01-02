<form method="post" style="padding:0px;"class="form-horizontal" action="<?php echo base_url(); ?>crm/saveSaleTarget" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
	<div class="item form-group col-md-12 col-sm-12 col-xs-12 sale-datepick export_div">
		<div class="col-md-4  col-xs-6">
	
			<fieldset>
				<div class="control-group">
					<div class="controls">
						<div class="col-md-11 xdisplay_inputx form-group has-feedback">
							<input type="text" class="form-control has-feedback-left" name="start_date" id="start_date" placeholder="select date" aria-describedby="inputSuccess2Status3" value="<?php if(!empty($userSaleTarget))  echo $userSaleTarget[0]['start_date'];  ?>">
							<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
							<span id="inputSuccess2Status3" class="sr-only">(success)</span>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>					
	<table class="table   table-responsive bulk_action">		
		<thead> <th></th><th>User</th><th></th><th>Sale Target</th><th>Lead Generaion Target</th><th>Payment Target</th></thead>
		<tbody>	
			<?php
			if(!empty($userSaleTarget)){
				foreach($userSaleTarget as $ust){
					echo '<tr>	
						<td><input type="hidden" id="userId" name="id[]" class="form-control col-md-7 col-xs-12" value="'.$ust["id"].'"></td>
						<td width="15%"><strong>'.$ust['name'].'</strong></td>
						<td><input type="hidden" id="userId" name="user_id[]" class="form-control col-md-7 col-xs-12" value="'.$ust["u_id"].'"><input type="hidden" name="save_status" value="1" class="save_status"></td>
						<td>'; ?>
						<input type="number" id="sale_target" name="sale_target[]" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($ust)) echo $ust['sale_target']; ?>"></td>
						<td><input type="number" id="lead_generation_target" name="lead_generation_target[]" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($ust)) echo $ust['lead_generation_target']; ?>"></td>
						<td><input type="number" id="payment_target" name="payment_target[]" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($ust)) echo $ust['payment_target']; ?>"></td>
						
					</tr>
				<?php }
				}
				?>							
		</tbody>										
	</table>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="reset" class="btn btn-default">Reset</button>
		<!--<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft"> -->							  
		<input type="submit" class="btn edit-end-btn" value="Submit">
	</div>
</form>