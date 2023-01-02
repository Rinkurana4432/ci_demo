<!doctype html>
<html lang="en">    
  <head>    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
    <!-- Meta, title, CSS, favicons, etc. -->    
    <meta charset="utf-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="width=device-width, initial-scale=1">   
	<link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon/favicon.png" type="image/ico" />	
    <title>Lasting ERP - Manufacturing Cloud ERP Software & B2B Marketplace</title>	
    <link href="https://fonts.googleapis.com/css?family=Arbutus+Slab" rel="stylesheet">  
    <!-- Favicon -------- -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url(); ?>assets/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>assets/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url(); ?>assets/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
	<meta name="description" content="Lasting ERP is Cloud ERP software & B2B Marketplace for manufacturers to improve their business ROI. Online erp software for Small & Medium Businesses.">
	<meta name="keywords" content="cloud erp,online erp software,free accounting software,enterprise resource planning software,production management software,Cloud Based ERP Software,customer relationship management crm software,hr management software,Free B2B marketplace" />
    <!-- Bootstrap -->    
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">		
    
    <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">	
    <!-- Animation css -->	
    <link href="<?php echo base_url(); ?>assets/modules/home/css/animate.css" rel="stylesheet">	
    <!-- Index Page Style -->    
    <link href="<?php echo base_url(); ?>assets/modules/home/css/style.css" rel="stylesheet">  
	<?php
	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	if (strpos($url,'company/view_profile')) {
		echo '<link href="'.base_url().'assets/modules/company/css/style.css" rel="stylesheet">';  
	} 
?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-140779405-1"></script>
<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());
 gtag('config', 'UA-140779405-1');
</script>

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '157902598998546');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=157902598998546&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
  </head>	
  <body> 		
    <div class="gradient-top">			
      <div class="container">				
       					
            <div class="row">							
                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 text-light top-font">
                    Want to manage your Company's operation on cloud?<br/>Join Today & be a part of the world's fastest growing B2B Network.
		 	    </div>
				<div class="col-xs-2 col-sm-2 col-md-1 col-lg-1 text-blue big">
					+
				</div>
				<div class="col-xs-5 col-sm-5 col-md-4 col-lg-4 top-font">
					Want to boost your company's sale? or<br> Do you want a kick Start for your Business?						
              </div>							
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">								
                <a href="<?php echo base_url(); ?>auth/#signup" class="btn btn-block btnerpblue-stylefull" target="_blank">Sign Up Now!
                </a>							
              </div>						
            </div>					
          			
      </div>				
    </div>		
    <nav class="navbar navbar-static-top erpbg">			
      <div class="container">				
        <div class="navbar-header">					
          <div class="visible-xs col-xs-6">						
            <a href="<?php echo base_url(); ?>">
              <img src="<?php echo base_url(); ?>assets/images/logo.png" class="img-responsive" alt="Online ERP for small business">
            </a>					
          </div>
<div class="col-xs-6">			  
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">						
            <span class="sr-only">Toggle navigation
            </span>						
            <i class="fa fa-bars">
            </i>					
          </button>	
</div>		  
        </div>				
        <div id="navbar" class="navbar-collapse collapse erpnavfont">					
          <ul class="nav navbar-nav navbar-left">						
            <li class="">
              <a href="tel:9888886589" class="erpnavlink">
                <i class="fa fa-phone">
                </i>&nbsp;+91 9888886589
              </a>
            </li>									
            <li class="dropdown">							
              <a href="#" class="dropdown-toggle erpnavlink" data-toggle="dropdown" role="button" aria-expanded="false">Support
                <span class="caret">
                </span>
              </a>							
              <ul class="dropdown-menu" role="menu">								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/implementation/" class="erplink">For Sales & Marketing
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/training/" class="erplink">For Technical Issues
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/become-a-partner/" class="erplink">For Partnership
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/contact-us/" class="erplink">For Contribution
                  </a>
                </li>								
                <li class="divider">
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/advertisement/" class="erplink">For Other Services
                  </a>
                </li>							
              </ul>						
            </li>						
            <li class="dropdown menu-large nav-item"> 
              <a href="#" class="dropdown-toggle nav-link erpnavlink" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Apps & Solutions 
                <span class="caret">
                </span>
              </a>							
              <ul class="dropdown-menu megamenu erpmegamenu">								
                <div class="row">									
                  <li class="col-md-4 dropdown-item">										
                    <ul>											
                      <!-- <li class="dropdown-header">Glyphicons</li> -->											
                      <li>
                        <a href="<?php echo base_url(); ?>lerp/accounting/" class="erplink">
                          <i class="fa fa-money">
                          </i>&nbsp;Accounting
                        </a>											
                      </li>											
                      <?php /*<li class="disabled">
                        <a href="<?php echo base_url(); ?>lerp/human-resource-management/" class="erplink">
                          <i class="fa fa-users">
                          </i>&nbsp;Human Resource Management
                        </a>											
                      </li>	 */ ?>										
                      <li>
                        <a href="<?php echo base_url(); ?>lerp/purchase" class="erplink">
                          <i class="fa fa-credit-card ">
                          </i>&nbsp;Purchase
                        </a>											
                      </li>																		
                    </ul>									
                  </li>									
                  <li class="col-md-4 dropdown-item">										
                    <ul>											
                      <!--<li class="dropdown-header">Button groups</li>-->											
                      <li>
                        <a href="<?php echo base_url(); ?>lerp/client-relationship-management/" class="erplink">
                          <i class="fa fa-thumbs-up">
                          </i>&nbsp;Client Relationship Management
                        </a>											
                      </li>											
                      <li>
                        <a href="<?php echo base_url(); ?>lerp/inventory-management/" class="erplink">
                          <i class="fa fa-cubes">
                          </i>&nbsp;Inventory Management
                        </a>											
                      </li>											
                      <!--<li><a href="#" class="erplink">Sizing</a>											</li>											<li><a href="#" class="erplink">Nesting</a>											</li>											<li><a href="#" class="erplink">Vertical variation</a>											</li>-->										
                    </ul>									
                  </li>									
                  <li class="col-md-4 dropdown-item">										
                    <ul>											
                      <!--<li class="dropdown-header">Input groups</li>-->											
                      <li>
                        <a href="<?php echo base_url(); ?>lerp/data-security/" class="erplink">
                          <i class="fa fa-database">
                          </i>&nbsp;Data Security
                        </a>											
                      </li>											
                      <li>
                        <a href="<?php echo base_url(); ?>lerp/accounting/production" class="erplink">
                          <i class="fa fa-gears">
                          </i>&nbsp;Production
                        </a>											
                      </li>											
                      <!--<li><a href="#" class="erplink">Checkboxes and radio addons</a>											</li>-->										
                    </ul>									
                  </li>								
                </div>							
              </ul>						
            </li>						
            <li class="">
              <a href="<?php echo base_url(); ?>home/pricing" class="erpnavlink">Pricing
              </a>
            </li>						
           			
          </ul>					
          <ul class="nav navbar-nav navbar-right">						
            <li class="">
              <a href="<?php echo base_url(); ?>lerp/getting-started/" class="erpnavlink erp-rborder">Getting Started
              </a>
            </li>						
            <li class="">
              <a href="<?php echo base_url(); ?>lerp/blog/" class="erpnavlink erp-rborder">News
              </a>
            </li>						
            <?php /* <li class="">
              <a href="<?php echo base_url(); ?>lerp/" class="erpnavlink erp-rborder">
                <i class="fa fa-mobile fa-lg">
                </i>&nbsp;Get The App
              </a>
            </li> */?>						
            <li class="dropdown">						
              <?php if(isset($_SESSION['loggedInUser'])){								echo '<a class="nav-link dropdown-toggle erpnavlink" href="'.base_url().'users/edit/'.$_SESSION['loggedInUser']->u_id.'" role="button" aria-haspopup="true" aria-expanded="true">Welcome, '.$_SESSION['loggedInUser']->name.'</a>';								}else{						?>					  							
              <a class="nav-link dropdown-toggle erpnavlink erp-rborder" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
                <i class="fa fa-user">
                </i>
				 Login
                <!--<span class="caret"></span>-->
              </a>							
              <ul id="login-dp" class="dropdown-menu">								
                <li>									
                  <div class="row">										
                    <div class="col-md-12 text-center">											Login <?php /*via											
                      <div class="social-buttons">												
                        <a href="<?php echo base_url(); ?>lerp/">
                          <i class="fa fa-facebook-square fa-2x erpanchor">
                          </i>
                        </a>												
                        <a href="<?php echo base_url(); ?>lerp/">
                          <i class="fa fa-google-plus-square fa-2x erpanchor">
                          </i>
                        </a>												
                        <a href="<?php echo base_url(); ?>lerp/">
                          <i class="fa fa-linkedin-square fa-2x erpanchor">
                          </i>
                        </a>											
                      </div>											or */	?>										 
                      <form class="form" role="form" method="post" action="<?php echo base_url().'auth/auth_user'; ?>" accept-charset="UTF-8" id="login-nav">													
                        <div class="form-group">														 
                          <label class="sr-only" for="exampleInputEmail2">Email address
                          </label>														 
                          <input type="email" class="form-control" id="exampleInputEmail2" name="email" placeholder="Email address" required>													
                        </div>													
                        <div class="form-group">														 
                          <label class="sr-only" for="exampleInputPassword2">Password
                          </label>														 
                          <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" name="password"  required>														 
                          <div class="help-block text-right">
                            <a class="erpanchor" href="<?php echo base_url().'auth/#resetreqpsd'; ?>">Forgot password ?
                            </a>
                          </div>													
                        </div>													
                        <div class="form-group">														
                          <button type="submit" class="btn btn-primary btn-block btnerpyellow-stylefull">Sign in
                          </button>													
                        </div>													
                        <!-- <div class="checkbox">														 
                          <label>														 
                            <input type="checkbox"> Keep me logged-in														 
                          </label>													
                        </div>	-->										 
                      </form>										
                    </div>										
                    <div class="col-md-12 bottom text-center">											
                      <p>New here ? 
                        <a class="erpanchor" href="<?php echo base_url().'auth/#signup'; ?>">Register Now
                        </a>										
                    </div>										
                    <!-- <div class="col-md-12 bottom">											<p><a class="erpanchor" href="#">Wishlist(5)</a>										</div>										<div class="col-md-12 bottom">											<p><a class="erpanchor" href="#">My Cart(2)</a>										</div>										<div class="col-md-12 bottom">											<p><a class="erpanchor" href="#">Checkout</a>										</div> -->									
                  </div>								 								
                </li>							
              </ul>
              <?php } ?>						
            </li>						
            <?php /*<li class="dropdown">							
              <a href="#" class="dropdown-toggle erpnavlink" data-toggle="dropdown" role="button" aria-expanded="false">En 
                <span class="caret">
                </span>
              </a>							
              <ul class="dropdown-menu" role="menu">								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/" class="erplink">EN
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/" class="erplink">Hindi
                  </a>
                </li>							
              </ul>						
            </li> */?>					
          </ul>				
        </div>			  
        <!--/.nav-collapse -->			
      </div>			
      <!--/.container-fluid -->		
    </nav>	  		
    <div id="fixedsearch" class="header">			
      <div class="container">			
      <div class="row">	
        <div class="hidden-xs col-sm-2 col-md-1 col-lg-1" >					
          <a href="<?php echo base_url(); ?>">
            <img src="<?php echo base_url(); ?>assets/images/logo.png" class="img-responsive" alt="LastingERP (Cloud ERP Software)">
          </a>				
        </div>				
        <div class="col-xs-12 col-sm-10 col-md-11 col-lg-11 mtop animated fadeInUp">				    
          <form class="form-inline" method="GET" action="<?php  echo base_url(); ?>home/search">					    
            <div class="input-group">                            
              <div class="form-group">                                
                <select class="form-control" name="category">                                    
                  <option <?php if((isset($_GET) && !empty($_GET)) && (isset($_GET['category']) && $_GET['category'] == 'Product')){ echo 'selected';  } ?>>Product
                  </option>                                    
                  <option <?php if((isset($_GET) && !empty($_GET)) && (isset($_GET['category']) && $_GET['category'] == 'Company')){ echo 'selected';  } ?>>Company
                  </option>                                
                </select>                             
              </div>                            
              <input type="text" class="form-control" name="name" placeholder="SEARCH..." value="<?php if((isset($_GET) && !empty($_GET)) && (isset($_GET['name']) &&  $_GET['name'] != '')){ echo $_GET['name'];  } ?>">                            
              <span class="input-group-btn">									
                <button type="submit" class="btn btn-primary btn btn-primary btnerp-stylefull">
                  <i class="fa fa-search">
                  </i>
                </button>							
              </span>                        
            </div>					
          </form>				
        </div>				
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">				
        </div>
        </div>

      </div>		
    </div>		
