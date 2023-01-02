						  
			<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saveSupply_type" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<input type="hidden" name="id" value="<?php if(!empty($supply_type)) echo $supply_type->id; ?>">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
						<div class=" form-group">
							<div>
								<!--div class="panel-heading"><h3 class="panel-title"><strong><?php //if(!empty($voucher)) echo $voucher->voucher_name; ?> </strong></h3></div-->
								<div>
									<!--div class="col-md-6 col-sm-6 col-xs-12 form-group">
										<div class="item form-group">													
											<label class="control-label col-md-3 col-sm-3 col-xs-12">GSTIN</label>														
											<div class="col-md-6 col-sm-6 col-xs-12">														
												<p><?php //if(!empty($ledger)) echo $ledger->gstin; ?></p>												
											</div>												
										</div>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12 form-group">
										<div class="item form-group">													
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>														
											<div class="col-md-6 col-sm-6 col-xs-12">														
												<p><?php //if(!empty($ledger)) echo $ledger->email; ?></p>													
											</div>												
										</div>
									</div-->
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="x_content">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">
												<!--ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
													<li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Information</a>
													</li>
													<li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Mailing Details</a>
													</li>
													<li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Account Details</a>
													</li>
													<li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Company Details</a>
													</li>
													<li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Contact Person Details</a>
													</li>
												</ul-->
												<div id="myTabContent" class="tab-content ledger-2">
												<h3 class="Material-head">Information <hr></h3>
													<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
														<div class="col-md-12 col-sm-12 col-xs-12">
															
																	<div class="col-md-6 col-xs-12 col-sm-12 vertical-border ">
																	  <label class=" col-md-6 col-sm-6 col-xs-12"scope="row">Supply Type Name</label>
																	  <div class="col-md-6 col-sm-6 col-xs-12"><?php if(!empty($supply_type)) echo $supply_type->supply_type_name; ?></div>
																	</div>
																	
																
														</div>
													</div>
												
												</div>
											</div>
										</div>
									</div>									
								</div>
							</div>
						</div>
					</div>
		
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				
					<div class="form-group">
						<div class="modal-footer">
						    <center>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="reset" class="btn btn-default">Reset</button>
							<!--input type="submit" class="btn btn-warning" value="Submit"-->
							</center>
						</div>
					</div>
				</form>
			</div>