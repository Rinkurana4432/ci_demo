<div class="x_content">
	<?php if($this->session->flashdata('message') != ''){
			echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
		}					
	?>
	
	
	
	<div class="alert alert-error proof_alert_message" style="display:none;"></div>	
	<?php if(!empty($company) && $company->business_certificate!=''){ ?><div class="row">	
			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Last Documents uploaded</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<div class="col-md-12">
						Document Type Uploaded : <?php   echo isset($company->id)?$company->business_certificate_type:"";?><br>
						Document Uploaded : <img src="<?php echo base_url().'assets/modules/company/uploads/'.$company->business_certificate;?>" class="img-responsive avatar-view"/>
					</div>
				</div>
			</div>
	</div>
	<?php }else{ echo '<div class="item form-group"><h1>Documents not uploaded.</h1></div>'; } ?>
	
	<hr>

	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>company/saveCompanyProofs" enctype="multipart/form-data" id="companyForm" novalidate="novalidate" <?php if(!empty($company) && $company->business_status==1){ echo 'disabled'; echo  ' style="pointer-events:none"'; } ?>>
	
	
	<div class="row">	
		<div class="item form-group">
			<h2>Select any option by which you can want to verify your business *:</h2>
				<div class="col-sm-4 col-xs-12">
					<label class="back-bg">
						<input type="radio" class="" name="business_certificate_type" id="genderM" value="GST REG 06" checked="" required onchange="showBusinessCertificateSection(event,this);"/>GST REG 06 (Provisional Registration Certificate)
					</label>				 
						
								
						</div>
					<div class="col-sm-4 col-xs-12">
									<label class="back-bg">
										<input type="radio" class="" name="business_certificate_type" id="genderF" value="Udhyog Aadhar" onchange="showBusinessCertificateSection(event,this);"/>Udhyog Aadhar
									</label>
					
					</div>
					
									<div class="col-sm-4 col-xs-12">
									<label class="back-bg">
										<input type="radio" class="" name="business_certificate_type" id="" value="incorporation certificate" onclick="showBusinessCertificateSection(event,this);"/>Incorporation certificate
									</label>
								
									</div>
						</div>
					</div>
<div class="" id="gstSection">	
						<div class="row">	
							<div class="item form-group">
								<label class=" col-md-12 col-sm-12 col-xs-12">GST REG 06 (Provisional Registration Certificate)</label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="col-md-12">
										<div class="col-md-2 col-sm-2 col-xs-12 profile_left">
											<div class="profile_img">
												<div id="crop-avatar">
												  <!-- Current avatar -->
													<img data-toggle="modal" data-target="#myModal" class="img-responsive avatar-view" src="<?php echo base_url(); ?>assets/modules/company/uploads/gst-certificate-format.jpg" alt="Avatar" title="Change the avatar">
												</div>
											</div>
										</div>
										
										<div class="col-md-10 col-sm-10 col-xs-12 profile_left">
										<h2>Certificate must show</h2>
											<ul class="list-unstyled user_data">
												<li><i class="fa fa-circle"></i>GSTIN</li>
												<li><i class="fa fa-circle"></i>PAN</li>
												<li><i class="fa fa-circle"></i>Legal Name</li>
												<li><i class="fa fa-circle"></i>Trade Name</li>
											</ul>
											
								<div class="row">	
								
								<div class="item form-group">
									<!-- <label class="control-label col-md-5 col-sm-12 col-xs-12" for="email">GSTIN No<span class="required">*</span></label> -->
									<div class="col-md-12 col-sm-12 col-xs-12">
										<?php /*<input type="text" class="form-control" placeholder="Enter GSTIN" name="gstin" required="required"  pattern="\d{2}[A-Z]{5}\d{4}[A-Z]{1}\d[Z]{1}[A-Z\d]{1}"/>*/?>
										<input type="text" class="form-control gstin" placeholder="Enter GSTIN" name="gstin" onblur="fnValidateGSTIN(this)"/ value="<?php if(!empty($company)) echo $company->gstin; ?>">
									</div>
								</div>
								
							    <div class="item form-group">
								<label class=" col-md-12 col-sm-12 col-xs-12">Upload GSTIN Certificate</label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="col-md-12">
                                        <?php /*<input type="hidden" name="fileOldCoverPhoto" value="<?php echo isset($company->id)?$company->cover_photo: " ";?>">*/?>
                                        <input type="hidden" name="file_old_gstin_certificate" value="<?php // echo isset($company->id)?$company->gstin_certificate: " ";?>">
                                    <?php /* <input type="hidden" name="id" value="<?php if(!empty($company)) echo $company->c_id; ?>">
                                        <input type="hidden" name="u_id" value="<?php if(!empty($company)) echo $company->u_id; ?>">*/?>
                                        <input type="file" class="form-control col-md-7 col-xs-12 business_certificate" name="business_certificate[]">
                                        <input type="hidden" name="id" value="<?php if(!empty($company)) echo $company->id; ?>">
                                        <input type="hidden" name="u_id" value="<?php if(!empty($company)) echo $company->u_id; ?>">
                                        <input type="hidden" name="c_id" value="<?php if(!empty($company)) echo $company->c_id; ?>">
                                    </div>
								</div>
								
								<div class="col-sm-12 navi">
										      <h3>NOTE:</h3><h4> Wrong Documents </h4>
											  <ul class="nav nav-bar">
											       <li>Annexure </li>
												   <li>Invoice</li>
												   <li>Shop Boards</li>
												   <li>Selfies </li>
											  
											  </ul>
										</div>
							</div>
						</div>
										</div>
														
									
									
									</div>
								<div class="modal fade" id="myModal" role="dialog">
									<div class="modal-dialog">
									
									  <!-- Modal content-->
									  <div class="modal-content">
										<div class="modal-header">
										  <button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<img class="img-responsive avatar-view" src="<?php echo base_url(); ?>assets/modules/company/uploads/gst-certificate-format.jpg" alt="Avatar" title="Change the avatar">
									  </div>
									  
									</div>
								  </div>
								</div>
							</div>
						</div>
						
						</div>						
<div class="hideProofSection" id="udyogSection">	
						<div class="row">	
							<div class="item form-group">
								<label class=" col-md-12 col-sm-12 col-xs-12">Upload Udhyog Aadhaar</label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="col-md-12">
										<div class="col-md-2 col-sm-2 col-xs-12 profile_left">
											<div class="profile_img">
												<div id="crop-avatar">
												  <!-- Current avatar -->
													<img data-toggle="modal" data-target="#myModal2" class="img-responsive avatar-view" src="<?php echo base_url(); ?>assets/modules/company/uploads/udyog-aadhar-format.png" alt="Avatar" title="Change the avatar">
												</div>
											</div>
										</div>
										<div class="col-sm-10">
										<div class="row">	
										<div class="item form-group">
											<label class="col-md-12 col-sm-12 col-xs-12">Upload Udhyog Aadhaar</label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="col-md-12">
													<?php /*<input type="hidden" name="fileOldCoverPhoto" value="<?php echo isset($company->id)?$company->cover_photo: " ";?>">*/?>
													<input type="hidden" name="file_old_gstin_certificate" value="<?php // echo isset($company->id)?$company->gstin_certificate: " ";?>">									
													<input type="file" class="form-control col-md-7 col-xs-12 business_certificate" name="business_certificate[]">
												</div>
											</div>
											<div class="col-sm-12 navi">
										      <h3>NOTE:</h3>
											  <h4>Expired documents will not be accepted, check expiry date before uploading the document.</h4>
											  <h4> Wrong Documents </h4>
											  <ul class="nav nav-bar">
											       <li>Personal Aadhar </li>
												   <li>Invoice</li>
												   <li>Shop Boards</li>
												   <li>Selfies </li>
											  
											  </ul>
										</div>
										</div>
						            </div>
												
									</div>
									
									</div>
								</div>
								
								<div class="modal fade" id="myModal2" role="dialog">
									<div class="modal-dialog">
									
									  <!-- Modal content-->
									  <div class="modal-content">
										<div class="modal-header">
										  <button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<img class="img-responsive avatar-view" src="<?php echo base_url(); ?>assets/modules/company/uploads/udyog-aadhar-format.png" alt="Avatar" title="Change the avatar">
									  </div>
									  
									</div>
								</div>
							</div>
						</div>
						
				    </div>
					
<div class="hideProofSection" id="incorporationSection">			
									<div class="row">	
							<div class="item form-group">
								<label class=" col-md-12 col-sm-12 col-xs-12">Incorporation certificate</label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="col-md-12">
										<div class="col-md-2 col-sm-2 col-xs-12 profile_left">
											<div class="profile_img">
												<div id="crop-avatar">
												  <!-- Current avatar -->
													<img data-toggle="modal" data-target="#myModal3" class="img-responsive avatar-view" src="<?php echo base_url(); ?>assets/modules/company/uploads/incorporation-certificate-format.jpg" alt="Avatar" title="Change the avatar">
												</div>
											</div>
										</div>
										<div class="col-sm-10">
										<div class="row">	
											<div class="item form-group">
												<label class="col-md-12 col-sm-12 col-xs-12">Incorporation certificate</label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="col-md-12">										
														<input type="hidden" name="file_old_gstin_certificate" value="<?php // echo isset($company->id)?$company->gstin_certificate: " ";?>">
														<input type="file" class="form-control col-md-7 col-xs-12 business_certificate" name="business_certificate[]" >
													</div>
												</div>
											</div>
										<div class="col-sm-12 navi">
										   <h3>NOTE:</h3>
											  <h4>Expired documents will not be accepted, check expiry date before uploading the document.</h4>
											  <h4> Wrong Documents </h4>
											  <ul class="nav nav-bar">
											       <li>Personal Aadhar </li>
												   <li>Invoice</li>
												   <li>Shop Boards</li>
												   <li>Selfies </li>
											  
											  </ul>
										</div>	
										
						                 </div>
										 </div>
												
										<div class="modal fade" id="myModal3" role="dialog">
											<div class="modal-dialog">
											
											  <!-- Modal content-->
											  <div class="modal-content">
												<div class="modal-header">
												  <button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>
												<img class="img-responsive avatar-view" src="<?php echo base_url(); ?>assets/modules/company/uploads/incorporation-certificate-format.jpg" alt="Avatar" title="Change the avatar">
											  </div>
											  
											</div>
										</div>									
									
									</div>
								</div>
							</div>
						</div>
						
									</div>
						
					<br>	
	

						
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="submit" class="btn btn-warning" value="Submit" id="submit_business_proof"> 
		</div>
	</form>
	
	

	
</div>




<!--           Old design starts from here         -->
<?php /*

<div class="x_content">
	<?php if($this->session->flashdata('message') != ''){
			echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
		}					
	?>
	
	
	
		
	<?php if(!empty($company) && $company->business_certificate!=''){ ?><div class="row">	
			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Last Documents uploaded</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<div class="col-md-12">
						Document Type Uploaded : <?php   echo isset($company->id)?$company->business_certificate_type:"";?><br>
						Document Uploaded : <img src="<?php echo base_url().'assets/modules/company/uploads/'.$company->business_certificate;?>" class="img-responsive avatar-view"/>
					</div>
				</div>
			</div>
	</div>
	<?php }else{ echo '<div class="item form-group"><h1>Documents not uploaded.</h1></div>'; } ?>
	
	<hr>
	<hr>

	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>company/saveCompanyProofs" enctype="multipart/form-data" id="companyForm" novalidate="novalidate" <?php if(!empty($company) && $company->business_status==1){ echo 'disabled'; echo  ' style="pointer-events:none"'; } ?>>
	
	
	<div class="row">	
		<div class="item form-group">
			<h2>Select any option by which you can want to verify your business *:</h2>
				<div class="">
					<label>
						<input type="radio" class="" name="business_certificate_type" id="genderM" value="GST REG 06" checked="" required onchange="showBusinessCertificateSection(event,this);"/>GST REG 06 (Provisional Registration Certificate)
					</label>				 
						<div class="" id="gstSection">	
						<div class="row">	
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">GST REG 25 (Provisional Registration Certificate)</label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="col-md-12">
										<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
											<div class="profile_img">
												<div id="crop-avatar">
												  <!-- Current avatar -->
													<img class="img-responsive avatar-view" src="<?php echo base_url(); ?>assets/modules/company/uploads/gst-certificate-format.jpg" alt="Avatar" title="Change the avatar">
												</div>
											</div>
										</div>
										
										<div class="col-md-6 col-sm-6 col-xs-12 profile_left">
										<h2>Certificate must show</h2>
											<ul class="list-unstyled user_data">
												<li><i class="fa fa-circle"></i>GSTIN</li>
												<li><i class="fa fa-circle"></i>PAN</li>
												<li><i class="fa fa-circle"></i>Legal Name</li>
												<li><i class="fa fa-circle"></i>Trade Name</li>
											</ul>
										</div>
														
									
									
									</div>
								</div>
							</div>
						</div>
						<div class="row">	
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Upload GSTIN Certificate</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="col-md-12">
										<?php /*<input type="hidden" name="fileOldCoverPhoto" value="<?php echo isset($company->id)?$company->cover_photo: " ";?>">*//*?>
										<input type="hidden" name="file_old_gstin_certificate" value="<?php // echo isset($company->id)?$company->gstin_certificate: " ";?>">
									<?php /*	<input type="hidden" name="id" value="<?php if(!empty($company)) echo $company->c_id; ?>">
										<input type="hidden" name="u_id" value="<?php if(!empty($company)) echo $company->u_id; ?>">*//*?>
										<input type="file" class="form-control col-md-7 col-xs-12" name="business_certificate[]">
										<input type="hidden" name="id" value="<?php if(!empty($company)) echo $company->id; ?>">
										<input type="hidden" name="u_id" value="<?php if(!empty($company)) echo $company->u_id; ?>">
										<input type="hidden" name="c_id" value="<?php if(!empty($company)) echo $company->c_id; ?>">
									</div>
								</div>
							</div>
						</div>
						</div>
								
						</div>
						<hr>
					<div class="">
									<label>
										<input type="radio" class="" name="business_certificate_type" id="genderF" value="Udhyog Aadhar" onchange="showBusinessCertificateSection(event,this);"/>Udhyog Aadhar
									</label>
					<div class="hideProofSection" id="udyogSection">	
						<div class="row">	
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Udhyog Aadhaar</label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="col-md-12">
										<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
											<div class="profile_img">
												<div id="crop-avatar">
												  <!-- Current avatar -->
													<img class="img-responsive avatar-view" src="<?php echo base_url(); ?>assets/modules/company/uploads/udyog-aadhar-format.png" alt="Avatar" title="Change the avatar">
												</div>
											</div>
										</div>
												
									
									
									</div>
								</div>
							</div>
						</div>
						<div class="row">	
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Udhyog Aadhaar</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="col-md-12">
										<?php /*<input type="hidden" name="fileOldCoverPhoto" value="<?php echo isset($company->id)?$company->cover_photo: " ";?>">*//*?>
										<input type="hidden" name="file_old_gstin_certificate" value="<?php // echo isset($company->id)?$company->gstin_certificate: " ";?>">									
										<input type="file" class="form-control col-md-7 col-xs-12" name="business_certificate[]">
									</div>
								</div>
							</div>
						</div>
								</div>
					</div>
								<hr>
									<div class="">
									<label>
										<input type="radio" class="" name="business_certificate_type" id="" value="incorporation certificate" onclick="showBusinessCertificateSection(event,this);"/>Incorporation certificate
									</label>
								<div class="hideProofSection" id="incorporationSection">			
									<div class="row">	
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Incorporation certificate</label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="col-md-12">
										<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
											<div class="profile_img">
												<div id="crop-avatar">
												  <!-- Current avatar -->
													<img class="img-responsive avatar-view" src="<?php echo base_url(); ?>assets/modules/company/uploads/incorporation-certificate-format.jpg" alt="Avatar" title="Change the avatar">
												</div>
											</div>
										</div>
												
									
									
									</div>
								</div>
							</div>
						</div>
						<div class="row">	
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Incorporation certificate</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="col-md-12">										
										<input type="hidden" name="file_old_gstin_certificate" value="<?php // echo isset($company->id)?$company->gstin_certificate: " ";?>">
										<input type="file" class="form-control col-md-7 col-xs-12" name="business_certificate[]" >
									</div>
								</div>
							</div>
						</div>
									</div>
									</div>
						</div>
					</div>	
					<br>								
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="submit" class="btn btn-warning" value="Submit"> 
		</div>
	</form>
	
	

	
</div>*/?>