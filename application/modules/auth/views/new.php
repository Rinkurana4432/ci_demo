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
		<link href="<?php echo base_url(); ?>assets/modules/auth/css/style.css" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Oleo Script Swash Caps' rel='stylesheet'>
		
	</head>
	<body class="login">
		<div>
			<a class="hiddenanchor" id="signup"></a>
			<a class="hiddenanchor" id="resetreqpsd"></a>
			<a class="hiddenanchor" id="changepassword"></a>
			<a class="hiddenanchor" id="signin"></a>
			<div class="login_wrapper">
			
				<div class="container">
					<div class="row">
						<div class="col-lg-6">
							<div class="col-lg-4">
								<form action="<?php echo base_url();?>auth/auth_user" method="post" id="loginCompany" novalidate="novalidate">
									<h1>Login Form </h1>						 
									<div class="item form-group">
										<!-- <label class="control-label col-md-5 col-sm-12 col-xs-12" for="email">Company Email<span class="required">*</span></label> -->
										<div class="col-md-12 col-sm-12 col-xs-12">
											<input type="email" id="email2" name="email" required="required" class="form-control col-md-7 col-xs-12" placeholder="abc@gmail.com" />
										</div>
									</div>
									<div class="item form-group">
										<!-- <label class="control-label col-md-5 col-sm-12 col-xs-12" for="password">Password<span class="required">*</span></label> data-validate-length="6,8"-->
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
							<div>
							<div class="col-lg-2">
								<div class="col" style="background: #ccc; color: #000;">
									Register
								</div>
								<div class="col" style="background: red; color: #000;">
									Forgot Password
								</div>
								<div class="col" style="background: green; color: #000;">
									Sign In
								</div>
							<div>
						</div>
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
