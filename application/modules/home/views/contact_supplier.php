	<div class="back-contactsup">
		<div class="container">
			<div class="row">
				<?php /*<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="erp-quote animated wow fadeInLeft">							
								<h3> Request For A Quote</h3>
								<h5>We provide instant quote.</h5>
								<?php if($this->session->flashdata('message') != ''){
											echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
										}?>
								<form class="form-horizontal" method="POST" action="<?php  echo base_url(); ?>home/emailContactSupplier">
									<div class="item form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<input type="text" id="fnm" name="contacts" class="form-control" placeholder="Full Name" required="required" autofocus>
										</div>
									</div>
									<div class="item form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<input type="tel" id="phn" class="form-control" placeholder="Mobile" name="mobile"  required="required" autofocus>
										</div>
									</div>
									<div class="item form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email Id" required="required" autofocus>
										</div>
									</div>
									
									<div class="col-md-6 col-sm-6 col-xs-12">
										<?php if(!empty($material)){
										?>
										<img src="<?php echo base_url().'assets/modules/inventory/uploads/'.$material->featured_image ; ?>" alt="..." />
										<h2 class="prod_title"><?php if(!empty($material)) echo $material->material_name; ?>
										<?php }?>
									</div>
									<div class="item form-group">								
										<input type="hidden" class="form-control col-md-7 col-xs-12" name="products" id="inputproduct" value="<?php if(!empty($material)) echo $material->material_name; ?>" required="required" placeholder="Looking For..." >
										<input type="hidden" class="form-control col-md-7 col-xs-12" name="material_id" id="inputproduct" value="<?php if(!empty($material)) echo $material->id; ?>" required="required" placeholder="Looking For..." >
										<input type="hidden" class="form-control col-md-7 col-xs-12" name="company_id" id="inputproduct" value="<?php echo $company->id; ?>" required="required" placeholder="Looking For..." >
									
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" class="form-control col-md-7 col-xs-12" name="quantity" id="inputquantity" placeholder="Qty." required="required">
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select id="inputState" class="form-control" placeholder="Unit" name="uom" >
												<option selected>Unit</option>
												<?php
													$measurementUnits = measurementUnits();									
													foreach($measurementUnits as $measurementUnit){											
															echo '<option value="'.$measurementUnit.'">'.$measurementUnit.'</option>';
														
													}
													?>
											</select>
										</div>
									</div>		

									<div class="item form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<p>Enter product details such as color, size, materials tc. and other specification requirements to receive an accurate quote.</p>
											<textarea name="message" class="col-md-12 col-sm-12 col-xs-12"></textarea>
										</div>
									</div>										
									<?php /*	<button type="submit" class="btn btn-primary btnerp-stylefull col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin: 6px 0;">Get Quote</button> */?>
									<?php /*<input type="submit" class="btn btn-primary btnerp-stylefull col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin: 6px 0;"></button>
								</form>
								<?php if($this->session->flashdata('message') != ''){
									echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
								}?>
							</div>						
						</div>
					</div>
				</div> */?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
							<div class="home-category-info-header">
								<h2>Contact Supplier</h2>
								<span class="home-category-info-header-line" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 mb10 animated wow fadeInLeft">	
							<form class="form-horizontal" method="POST" action="<?php  echo base_url(); ?>home/emailContactSupplier">	
								<?php if($this->session->flashdata('message') != ''){
										echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
								}?>		
									<input type="hidden" class="form-control col-md-7 col-xs-12" name="products" id="inputproduct" value="<?php if(!empty($material)) echo $material->material_name; ?>" required="required" placeholder="Looking For..." >
									<input type="hidden" class="form-control col-md-7 col-xs-12" name="material_id" id="inputproduct" value="<?php if(!empty($material)) echo $material->id; ?>" required="required" placeholder="Looking For..." >
									<input type="hidden" class="form-control col-md-7 col-xs-12" name="company_id" id="inputproduct" value="<?php if(!empty($company)) echo $company->id; ?>" required="required" placeholder="Looking For..." >
																	
								<div class="panel-group" id="accordion">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">Company:
												<a class="panel-link" data-toggle="collapse" data-parent="#accordion" href="#suppliername">
												<?php if(!empty($company)) { echo $company->name; } ?>
												</a>
											</h4>
										</div>
										<div id="suppliername" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class="table-responsive hidden-sm hidden-xs">
													<table class="table">
														<tr>
															<th> 
																Product Detail
															</th>
															<th> 
																Qty.
															</th>
															<th> 
																Unit
															</th>											
														</tr>
														<tr>
															<td> 
																<div class="col-lg-12">
																	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
																		<img src="<?php echo base_url()?>assets/modules/inventory/uploads/<?php if(!empty($material) &&  $material->featured_image != ''){ echo $material->featured_image;  } else { echo 'battle-ropes-2_orig_3-850x850-0_1548402206.jpg'; } ?>" alt="..." class="img-responsive" width="100%" height="100px">
																	</div>
																	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
																		<?php  if(!empty($material)){ echo $material->specification; } ?>
																	</div>
																</div>
															</td>
															<td> 
																<input type="number" id="fnm" name="quantity" class="form-control" placeholder="Quantity" required="required" autofocus>
															</td>
															<td> 
																<select id="inputState" class="form-control" placeholder="Unit" name="uom" >
																	<option selected>Unit</option>
																	<?php
																		$measurementUnits = measurementUnits();									
																		foreach($measurementUnits as $measurementUnit){											
																				echo '<option value="'.$measurementUnit.'">'.$measurementUnit.'</option>';
																			
																		}
																	?>
																</select>
															</td>											
														</tr>
													</table>
												</div>
												<div class="col-sm-12 col-xs-12 hidden-lg hidden-md">
													<div class="col-sm-2 col-xs-12">
														<img src="<?php echo base_url()?>assets/modules/inventory/uploads/<?php if(!empty($material) &&  $material->featured_image != ''){ echo $material->featured_image;  } else { echo 'battle-ropes-2_orig_3-850x850-0_1548402206.jpg'; } ?>" alt="..." class="img-responsive" width="100%" height="100px">
													</div>
													<div class="col-sm-10 col-xs-12">
														&nbsp; Enter product details such as color, size, materials tc. and other specification requirements to receive an accurate quote.
													</div>
													<div class="col-sm-4 col-xs-6">
														<b> QTY:</b>&nbsp;100
													</div>
													<div class="col-sm-6 col-xs-6">
														<select id="inputState" class="form-control" placeholder="Unit" name="uom" >
															<option selected>Unit</option>
															<?php
																$measurementUnits = measurementUnits();									
																foreach($measurementUnits as $measurementUnit){											
																		echo '<option value="'.$measurementUnit.'">'.$measurementUnit.'</option>';
																	
																}
															?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>	
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 contact-sup">								
							<?php /*	<form class="form-horizontal" method="POST" action="<?php  echo base_url(); ?>home/emailContactSupplier"> */?>
									<div class="item form-group">
										<div class="col-md-4 col-sm-6 col-xs-12 erp-formb">
											<input type="text" id="fnm" name="contacts" class="form-control" placeholder="Full Name" required="required" autofocus>
										</div>
										<div class="col-md-4 col-sm-6 col-xs-12 erp-formb">
											<input type="tel" id="phn" class="form-control" placeholder="Mobile" name="mobile"  required="required" autofocus>
										</div>
										<div class="col-md-4 col-sm-12 col-xs-12 erp-formb">
											<input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email Id" required="required" autofocus>
										</div>
									</div>
									<div class="item form-group">
										<div class="col-md-12 col-sm-12 col-xs-12 erp-formb">
											<p>Enter product details such as color, size, materials tc and other specification requirements to receive an accurate quote.</p>
											<textarea name="message" class="col-md-12 col-sm-12 col-xs-12" row="12"></textarea>
										</div>
									</div>
									<?php /*	<div class="col-md-12 col-sm-12 col-xs-12">
											<input type="file" class="form-control col-md-7 col-xs-12" name="idproof[]" style=" margin: 25px 0 0 0;">
										</div>										
									</div> */ ?>										
									<?php /*<button type="submit" class="btn btn-primary btnerp-stylefull col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin: 6px 0;">Get Quote</button> */?>
									
									<input type="submit" class="btn btn-primary btnerp-stylefull col-xs-12 col-sm-12 col-md-4 col-lg-4" style="margin: 6px 0;"></button>										
										
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>