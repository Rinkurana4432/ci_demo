<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ERP| </title>
		<!-- Bootstrap -->
		<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- NProgress -->
		<link href="<?php echo base_url(); ?>assets/plugins/nprogress/nprogress.css" rel="stylesheet">
		<!-- Animate.css -->
		<link href="<?php echo base_url(); ?>assets/plugins/animate.css/animate.min.css" rel="stylesheet">
		<!-- Custom Theme Style -->
		<link href="<?php echo base_url(); ?>assets/css/custom.min.css" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Oleo Script Swash Caps' rel='stylesheet'>
		<link href="<?php echo base_url(); ?>assets/modules/auth/css/style.css" rel="stylesheet">
		 <script src='https://www.google.com/recaptcha/api.js'></script>
		
	</head>
	<body class="login">
		
			<a class="hiddenanchor" id="signup"></a>
			<a class="hiddenanchor" id="resetreqpsd"></a>
			<a class="hiddenanchor" id="changepassword"></a>
			<a class="hiddenanchor" id="signin"></a>
			<div class="login_wrapper">
			
				<!-- --------------------------------------------------- Login Form ----------------------------------------------------- -->
					
				
				<div class="animate form login_form creative">
					<div class="logo-space">
						<a href="<?php echo base_url();?>"><h1><img src="<?php echo base_url('assets/images/logo.png');?>"></h1></a>
					</div>
					<section class="login_content">
						<?php if($this->session->flashdata("messagePr")){?>
						<div class="alert alert-info">      
							<?php echo $this->session->flashdata("messagePr")?>
						</div>
						<?php } ?>
						<form action="<?php echo base_url();?>auth/auth_user" method="post" id="loginCompany" novalidate="novalidate">
							<h1>Login Form </h1>						 
							<div class="item form-group">
								<!-- <label class="control-label col-md-5 col-sm-12 col-xs-12" for="email">Company Email<span class="required">*</span></label> -->
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="email" id="email2" name="email" required="required" class="form-control col-md-7 col-xs-12" placeholder="abc@gmail.com" />
								</div>
							</div>
							<div class="item form-group">
								<!-- <label class="control-label col-md-5 col-sm-12 col-xs-12" for="password">Password<span class="required">*</span></label>  data-validate-length="6,8"-->
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input id="password2" type="password" name="password"  class="form-control col-md-7 col-xs-12" required="required" placeholder="Enter Password" />
								</div>
							</div>
							<div>
								<input type="submit" value="Login" class="btn btn-warning lspl-form" />							
							</div>
							<div class="clearfix"></div>
							<div class="separator">
								<p class="change_link">Lost Password ?
									<a href="#resetreqpsd" class="to_register"> Click Here </a>
								</p>
								<p class="change_link">New member ?
									<a href="#signup" class="to_register"> Create Account </a>
								</p>
							</div>
						</form>
					</section>
					<div class="form-copy">
						© <?php echo date("Y"); ?> All Rights Reserved. ERP! is a Company Software. Privacy and Terms
					</div>
				</div> 	
						
										
				<!-- --------------------------------------------------- Request Password Form ----------------------------------------------------- -->
				<div class="animate form resetpsd_form creative">
					<div class="logo-space">
						<a href="<?php echo base_url();?>"><h1><img src="<?php echo base_url('assets/images/logo.png');?>"></h1></a>
					</div>
				<?php if($this->session->flashdata("messageForgetPassword")){?>
						<div class="alert alert-info">      
							<?php echo $this->session->flashdata("messageForgetPassword")?>
						</div>
						<?php } ?>
					<section class="login_content">
						<form action="<?php echo base_url();?>auth/ForgotPassword" method="post" id="forgot_password" novalidate="novalidate">
							<h1>Request Password</h1>						 
							<div class="item form-group">
								<input type="email" class="form-control" placeholder="Enter Your Registered Email" required="required" name="email"/>
							</div>
							<div>
								<input type="submit" value="Reset" class="btn btn-warning lspl-form" />							
								<!-- <a href="#signin" class="to_register"> Log in </a>
								<a href="#changepassword" class="to_register">Or Change Password </a>-->
							</div>
							<div class="clearfix"></div>
							<div class="separator">
								<p class="change_link">Already a member ?
									<a href="#signin" class="to_register"> Log in </a>
								</p>
								<p class="change_link">New member ?
									<a href="#signup" class="to_register"> Create Account </a>
								</p>
								<div class="clearfix"></div>
							</div>
						</form>
					</section>
					<div class="form-copy">
						© <?php echo date("Y"); ?> All Rights Reserved. ERP! is a Company Software. Privacy and Terms
					</div>
				</div>
				
				<!-- --------------------------------------------------- Change Password Form ----------------------------------------------------- -->
				<div class="animate form confirmpsd_form creative">
					<div class="logo-space">
						<a href="<?php echo base_url();?>"><h1><img src="<?php echo base_url('assets/images/logo.png');?>"></h1></a>
					</div>
				<?php if($this->session->flashdata("messageForgetPassword")){?>
						<div class="alert alert-info">      
							<?php echo $this->session->flashdata("messageForgetPassword")?>
						</div>
						<?php } ?>
					<section class="login_content">
						<form action="<?php echo base_url();?>auth/change_password" method="post" id="change_password" novalidate="novalidate">
							<h1>Change Password </h1>
							 
							<div class="item form-group">
								<input type="password" class="form-control" placeholder="Enter New password" required="required" name="password"/>
							</div>
							<div class="item form-group">
								<input type="password" class="form-control" placeholder="Enter confirm password" required="required" name="c_password"/>
							</div>
							<div>
								<input type="submit" value="Reset" class="btn btn-warning" />
								<a href="#signin" class="to_register"> Log in </a>
							</div>

							<div class="clearfix"></div>

							<div class="separator">
								<p class="change_link">New to site?
								  <a href="#signup" class="to_register"> Create Account </a>
								</p>

								<div class="clearfix"></div>
							</div>
						</form>
					</section>
					<div class="form-copy">
						© <?php echo date("Y"); ?> All Rights Reserved. ERP! is a Company Software. Privacy and Terms
					</div>
				</div>
				
				<!-- --------------------------------------------------- Registration Form ----------------------------------------------------- -->
				<div id="register" class="animate form registration_form creative">
					<div class="logo-space">
						<a href="<?php echo base_url();?>"><h1><img src="<?php echo base_url('assets/images/logo.png');?>"></h1></a>
					</div>
				
					<section class="login_content">	
						<?php if($this->session->flashdata("messageRegister")){?>
						<div class="alert alert-info">      
							<?php echo $this->session->flashdata("messageRegister")?>
						</div>
						<?php } ?>
						<form action="<?php echo base_url();?>auth/register" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data" novalidate="novalidate" id="companyRegister">
							<h1>Create Account</h1>
							<div class="item form-group">
								<!-- <label class="control-label col-md-5 col-sm-12 col-xs-12" for="name">Company Name<span class="required">*</span></label>-->
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input id="name" class="form-control" data-validate-length-range="15" name="name"  required="required" type="text" placeholder="Your Company Name" />
								</div>
							</div>							
							<div class="item form-group">
								<!-- <label class="control-label col-md-5 col-sm-12 col-xs-12" for="email">Company Email<span class="required">*</span></label> -->
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" placeholder="Company Email" />
								</div>
							</div>
							<div class="item form-group">
								<!-- <label class="control-label col-md-5 col-sm-12 col-xs-12" for="password">Password<span class="required">*</span></label> -->
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input id="password" type="password" name="password" class="form-control col-md-7 col-xs-12" required="required" placeholder="Enter Password" onblur="fnValidatePassword(this)"/>
								</div>
							</div>
							<div class="item form-group">
								<!-- <label class="control-label col-md-5 col-sm-12 col-xs-12" for="password">Confirm password<span class="required">*</span></label> -->
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input id="password23" type="password" name="c_password" class="form-control col-md-7 col-xs-12" required="required" placeholder="Confirm Password"  onblur="fnValidatePassword(this)"/>
								</div>
							</div>
							<div class="item form-group">
								<!-- <label class="control-label col-md-5 col-sm-12 col-xs-12" for="email">GSTIN No<span class="required">*</span></label> -->
								<div class="col-md-12 col-sm-12 col-xs-12">
									<?php /*<input type="text" class="form-control" placeholder="Enter GSTIN" name="gstin" required="required"  pattern="\d{2}[A-Z]{5}\d{4}[A-Z]{1}\d[Z]{1}[A-Z\d]{1}"/>*/?>
								<?php /*	<input type="text" class="form-control gstin" placeholder="Enter GSTIN" name="gstin" required="required"  onblur="fnValidateGSTIN(this)"/>*/?>
									<?php /* 	<input type="text" class="form-control gstin" placeholder="Enter GSTIN" name="gstin" onblur="fnValidateGSTIN(this)"/> */?>
									<input type="text" class="form-control gstin" placeholder="Enter GSTIN" name="gstin"  />
								</div>
							</div>
							<div class="item form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="text" class="form-control" placeholder="Enter Phone No." name="phone"/>
								</div>
							</div>
							 <div class="g-recaptcha"  data-sitekey="<?php echo $this->config->item('google_key') ?>" data-callback="recaptchaCallback"></div>
							<div>
									<!--input type="submit" class="btn btn-warning lspl-form" value="Submit" /-->
									<button type="submit" class="btn btn-warning lspl-form signUpBtn" >Submit</button>
							</div>
							<div class="clearfix"></div>
							<div class="separator">
								<p class="change_link">Already a member ?
								  <a href="#signin" class="to_register"> Log in </a>
								</p>
								<div class="clearfix"></div>
							</div>
						</form>
					</section>
					<div class="form-copy">
						© <?php echo date("Y"); ?> All Rights Reserved. ERP! is a Company Software. Privacy and Terms
					</div>
				</div>				
			</div>	
		
		<script>		var site_url = '<?php echo base_url(); ?>';	</script>		   
		<script src="<?php echo base_url();?>assets/plugins/jquery/dist/jquery.min.js"></script>			
		<script src="<?php echo base_url();?>assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>									
		<script src="<?php echo base_url();?>assets/plugins/validator/validator.js"></script>			
		<script src="<?php echo base_url();?>assets/js/custom.min.js"></script>			
		<script src="<?php echo base_url();?>assets/js/custom/global_script.js"></script>			
		<!--script src="<?php //echo base_url();?>assets/js/custom/ajax_script.js"></script-->
		<script src="<?php echo base_url();?>assets/modules/auth/js/script.js"></script>
		
	</body>
</html>
