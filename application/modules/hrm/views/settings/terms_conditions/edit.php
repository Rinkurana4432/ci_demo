<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/saveterms_condtn" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">

<input type="hidden" name="created_date" value="<?php echo date("Y-m-d H:i:s");?>">
<input type="hidden" name="id" value="<?php if(!empty($termsconds)){ echo $termsconds->id; }?>">
<label class="col-md-2 col-sm-12 col-xs-12" for="address">Enter Title</label>
		<div class="col-md-3 col-sm-12 col-xs-12">
		<input type="tel" id="terms_tittle" name="title"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($termsconds)) echo $termsconds->title; ?>">	
		</div>
	<br>
	<br>
	<br>
<br>
<label class="col-md-2 col-sm-12 col-xs-12" for="address">Terms and Conditions</label>
		<div class="col-md-8 col-sm-12 col-xs-12">
						 <textarea id="terms_cond" name="terms_cond"> 
							 
							 <?php if(!empty($termsconds)) echo $termsconds->terms_cond; ?>
          					</textarea>
		</div>
	<div class="form-group">
		<div class="col-md-6 col-md-offset-3" style="margin-top: 50px;">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="reset" class="btn btn-default">Reset</button>
			<input type="submit" class="btn edit-end-btn " value="Submit">
		</div>
	</div>
</form>	

