<label class="col-md-2 col-sm-12 col-xs-12" for="address">Title</label>
		<div class="col-md-3 col-sm-12 col-xs-12">
							<div ><?php if(!empty($termsconds)) echo $termsconds->title; ?></div>
		</div>
	<br>
	<br>
	
<label class="col-md-2 col-sm-12 col-xs-12" for="address">Terms and Conditions</label>
		<div class="col-md-8 col-sm-12 col-xs-12">
		<?php if(!empty($termsconds)) echo $termsconds->terms_cond; ?>
		</div>
	<div class="form-group">
		<div class="col-md-6 col-md-offset-3" style="margin-top: 50px;">
		<button type="button" class="btn btn-default" data-dismiss="modal" style="text-align: center;">Close</button>	
		</div>
	</div>

