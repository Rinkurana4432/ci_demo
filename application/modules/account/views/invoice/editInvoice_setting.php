	<?php if($_SESSION['loggedInUser']->role != 2){ ?>						  
			<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saveInvoice_settings" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<div class="panel panel-default">
						<div class="panel-heading"><h3 class="panel-title"><strong>Company Terms And Conditions </strong></h3></div>
						<div class="panel-body">
						<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="type">Term And conditions<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									
									<textarea col="160" rows="10" name="term_and_conditions" required="required" class="form-control col-md-7 col-xs-12" placeholder="Term And conditions"><?php if(!empty($invoice_settingss)) echo $invoice_settingss->term_and_conditions; ?></textarea>  
								</div>
							</div>
						</div>
					</div>
				
			
		<?php } ?>	
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<div class="ln_solid"></div>
					<div class="form-group">
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="reset" class="btn btn-default">Reset</button>
							<!--input type="submit" class="btn btn-warning add_edit_account" value="Submit"-->
							<button id="send" type="submit" class="btn btn-warning">Submit</button>
						</div>
					</div>
				</form>
			</div>