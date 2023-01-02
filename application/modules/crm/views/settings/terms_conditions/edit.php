
<?php

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right" style="margin: 10px 0;">	
	<?php  
	//if(!empty($termsconds) && $termsconds->save_status == 1) { echo '<a href="'.base_url().'crm/create_pdf/'.$termsconds->id.'"><button class="btn edit-end-btn btn-sm">Generate PDF</button></a>'; } ?>
</div>


<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>crm/saveterms_condtn" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">

<input type="hidden" name="created_date" value="<?php echo date("Y-m-d H:i:s");?>">
<input type="hidden" name="id" value="<?php if(!empty($termsconds)){ echo $termsconds->id; }?>">
	<input type="hidden" name="save_status" value="1" class="save_status">	
	<input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">	

<label class="col-md-2 col-sm-12 col-xs-12" for="address">Enter Tittle   <span class="required">*</span></label>
		<div class="col-md-3 col-sm-12 col-xs-12">
							<input type="text" id="terms_tittle" name="terms_tittle"  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($termsconds)) echo $termsconds->terms_tittle; ?>" required="required">	
		</div>
	<br>
	<br>
	<br>
<br>
<label class="col-md-2 col-sm-12 col-xs-12" for="address">Terms and Conditions</label>
		<div class="col-md-8 col-sm-12 col-xs-12">
								
							<textarea id="content" name="content">
							 <?php if(!empty($termsconds)) echo $termsconds->content; ?>
          					</textarea>
		</div>







	<div class="form-group">
		<div class="col-md-6 col-md-offset-3" style="margin-top: 50px;">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="reset" class="btn btn-default">Reset</button>
			<?php if((!empty($termsconds) && $termsconds->save_status !=1) || empty($termsconds)){
					echo '<input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft">'; 
				}?> 
			<input type="submit" class="btn edit-end-btn " value="Submit">
		</div>
	</div>
</form>	

