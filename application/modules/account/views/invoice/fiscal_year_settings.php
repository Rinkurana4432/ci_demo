<style>
.controls input {
    height: 38px;
}
</style>
<?php
if ($_SESSION['loggedInUser']->role != 2) {
    if ($this->session->flashdata('message') != '') {
        echo '<div class="alert alert-info">' . $this->session->flashdata('message') . '</div>';
    }
?>
<div class="alert alert-info" id="message_Sucess" style="display:none;"></div>				  
		       <input type="hidden" name="id" value="<?php ?>">
						<div class="col-md-12  export_div" style="padding: 0px;">						
							<div class="col-md-3" style="float:right;">
								<fieldset>
									<div class="control-group">
									<div class="controls">
										   <div class="input-prepend input-group">
												  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
													  <?php
														$date_Decoded = json_decode($update_invoice_setting->financial_year_date, true);
														$s_date = date("m/d/Y", strtotime($date_Decoded[0]['start']));
														$end_date = date("m/d/Y", strtotime($date_Decoded[0]['end']));
														$ddttee = $s_date . ' - ' . $end_date;
													?>
											<input type="text" style="width: 232px" name="financial_year_date" id="financial_year_date" class="form-control" value="<?php if (!empty($date_Decoded)) echo $ddttee; ?>" data-table='account/add_financial_year_date'/>
											<?php if (!empty($date_Decoded)) { ?>
												<form method="post" class="form-horizontal" style="float:right;" action="" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
													<input type="hidden" name="remove_Date"value='remove_Date'>
													<a class=" btn btn-warning " href="javascript:;" style="margin: 0px; padding: 9px 14px;" onclick="return isconfirm('<?php echo base_url(); ?>account/remove_financial_year_date');">Default Date setting</a>
												</form>
											<?php } ?>
										</div>
									</div>
								</div>
							</fieldset>
				        </div>														   
				</div>
		<?php
} ?>	
			