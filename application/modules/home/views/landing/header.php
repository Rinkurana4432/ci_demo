<!doctype html>
<html lang="en">    
  <head>    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
    <!-- Meta, title, CSS, favicons, etc. -->    
    <meta charset="utf-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="width=device-width, initial-scale=1">   
	<link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon/favicon.png" type="image/ico" />	
    <title>LastingERP-Cloud Based ERP Software</title>	
    <link href="https://fonts.googleapis.com/css?family=Arbutus+Slab" rel="stylesheet">  
    <!-- Favicon -------- -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@700&display=swap" rel="stylesheet">
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
	<meta name="description" content="LastingERP.com is an online marketplace and b2b trade portal that serve manufacturers, suppliers, retailers, service providers, exporters to trade with each other at an authentic and indisputable platform. This business directory is backed with the information received by our ERP.">
    <!-- Bootstrap -->    
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">		
    <!-- Slick 	<link type="text/css" rel="stylesheet" href="css/slick.css"/>	<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>	<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>-->    
    <!-- Font Awesome -->    
    <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">	
    <!-- Animation css -->	
    <link href="<?php echo base_url(); ?>assets/modules/home/css/animate.css" rel="stylesheet">	
    <!-- Index Page Style -->    
    <link href="<?php echo base_url(); ?>assets/modules/home/css/new_style.css" rel="stylesheet">  
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	
	
	
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
   <script>
$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
});
</script>
<style>
@media only screen and (max-width: 768px)
{
.desktop {
    display: none !important;
}
}
</style>
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
fbq('init', '861423427827538');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=861423427827538&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<!-- Global site tag (gtag.js) - Google Ads: 557237408 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-557237408"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

 

  gtag('config', 'AW-557237408');
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-0BY7WSHGRY"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-0BY7WSHGRY');
</script>
  </head>	
  <body> 		
 
    <nav id="fixedsearch" class="navbar navbar-static-top erpbg">
    <div class="top-header">
        <div class="container clearfix">
          <ul class="top-info">
            <li><i class="fa fa-phone"></i><a href="tel:+919888886589">+91-9888886589</a></li>
            <li> <a href="mailto:sales@lastingerp.com"><i class="fa fa-envelope"></i><span id="et-info-email">sales@lastingerp.com</span></a></li>
         </ul>

        <ul class="top-right">
         <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-10591"><a href="#">About Us</a></li>
		 <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-10693"><a href="#">Careers</a></li>
        </ul>
      </div>
    </div>
      <div class="container">				
        <div class="navbar-header">					
          <div class="visible-xs col-xs-6">						
            <a href="<?php echo base_url(); ?>">
              <img src="<?php echo base_url(); ?>assets/modules/home/uploads/logo.png" class="img-responsive" alt="Online ERP for small business">
			 
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
         <div class="hidden-xs col-sm-2 col-md-2 col-lg-2" >					
          <a href="<?php echo base_url(); ?>landing">
            <img src="<?php echo base_url(); ?>assets/modules/home/uploads/logo.png" class="img-responsive">
			
          </a>				
        </div>		
          <ul class="nav navbar-nav navbar-right">						
         									
           <li class="">
              <a href="<?php echo base_url(); ?>" class="erpnavlink ">Home
              </a>
            </li>
			 <li class="dropdown mobile-sub">
				<a class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Industries
				<span class="caret"></span></a>
				<ul class="dropdown-menu">
				  <li class="dropdown-submenu">
					<a class="test" tabindex="-1" href="#">Manufacturing Industry<span class="caret"></span></a>
					<ul class="dropdown-menu">
					 <li>
                  <a href="<?php echo base_url(); ?>lerp/steel-manufacturing/" class="erplink">Steel 
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/metal-fabrication-manufacturing/" class="erplink">Metal Fabrication 
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/automobile-industry-manufacturing/" class="erplink">Automobile Industry 
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/pharmaceutical-manufacturing-2/" class="erplink">Pharmaceutical 
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/packing-material-manufacturing/" class="erplink"> Packing Material 
                  </a>
                </li>

                 <li>
                  <a href="<?php echo base_url(); ?>lerp/food-beverages-manufacturing/" class="erplink">Food & Beverages 
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/plastic-manufacturing/" class="erplink">Plastic 
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/electronics-manufacturing/" class="erplink">Electronics 
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/furniture-manufacturing/" class="erplink">Furniture 
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/textile-manufacturing/" class="erplink">Textile 
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/chemical-manufacturing/" class="erplink">Chemical 
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/cosmetics-manufacturing/" class="erplink">Cosmetics
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/paint-manufacturing/" class="erplink">Paint
                  </a>
                </li>				
					</ul>
				  </li>
				  <li class="dropdown-submenu">
					<a class="test" tabindex="-1" href="#">Distribution Industry<span class="caret"></span></a>
					<ul class="dropdown-menu">
					   <li>
                  <a href="<?php echo base_url(); ?>lerp/pharma-distribution/" class="erplink">Pharma  
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/lubricants-distribution/" class="erplink">Lubricants
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/fmcg-distribution/" class="erplink">FMCG 
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/food-beverages-distribution/" class="erplink">Food & Beverages
                  </a>
                </li>				 
					</ul>
				  </li>
				  <li class="dropdown-submenu">
					<a class="test" tabindex="-1" href="#">Retail Industry<span class="caret"></span></a>
					<ul class="dropdown-menu">
					<li>
                   <a href="<?php echo base_url(); ?>lerp/pharmacy-shop/" class="erplink">Pharmacy 
                  </a>
                   </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/jewellery-shop/" class="erplink">Jewellery 
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/Stationary-Shop/" class="erplink">Stationery 
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/food-beverage-shop/" class="erplink">Food & Beverage 
                  </a>
                </li>	
                <li>
                  <a href="<?php echo base_url(); ?>lerp/garment-store/" class="erplink">Garment Store
                  </a>
                </li>							
                <li>
                  <a href="<?php echo base_url(); ?>lerp/supermarket/" class="erplink">Supermarket
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/mobile-electronics-shop/" class="erplink">Mobile & Electronics 
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/tiles-shop/" class="erplink">Tiles 
                  </a>
                </li>				
					</ul>
				  </li>
				  
				</ul>
			  </li>
             <li class="dropdown result desktop">
              <a href="#" class="dropdown-toggle erpnavlink " data-toggle="dropdown" role="button" aria-expanded="false">Industries</a>
			  <ul class="sub-menu dropdown-menu " role="menu">
			  <li class="main-tab">
			    <div class="link-menu"><img src="<?php echo base_url(); ?>assets/modules/home/uploads/manufacture55.png"><h3> Manufacturing Industry</h3></div>	
			   <div class="col-md-8 col-sm-8 col-xs-12 result 1 ">
			   <div class="col-md-6">
			    <ul>		
                  		  
                <li>
                  <a href="<?php echo base_url(); ?>lerp/steel-manufacturing/" class="erplink">Steel
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/metal-fabrication-manufacturing/" class="erplink">Metal Fabrication 
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/automobile-industry-manufacturing/" class="erplink">Automobile Industry 
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/pharmaceutical-manufacturing-2/" class="erplink">Pharmaceutical 
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/packing-material-manufacturing/" class="erplink"> Packing Material 
                  </a>
                </li>
				 <li>
                  <a href="<?php echo base_url(); ?>lerp/cosmetics-manufacturing/" class="erplink">Cosmetics
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/paint-manufacturing/" class="erplink">Paint
                  </a>
                </li>	
				</ul>
				</div>
<div class="col-md-6">
			    <ul>				
                <li>
                  <a href="<?php echo base_url(); ?>lerp/food-beverages-manufacturing/" class="erplink">Food & Beverages
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/plastic-manufacturing/" class="erplink">Plastic
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/electronics-manufacturing/" class="erplink">Electronics 
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/furniture-manufacturing/" class="erplink">Furniture 
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/textile-manufacturing/" class="erplink">Textile 
                  </a>
                </li>	
                 <li>
                  <a href="<?php echo base_url(); ?>lerp/chemical-manufacturing/" class="erplink">Chemical 
                  </a>
                </li>
               			
              </ul>
			  </div>
            </div>
		   </li>
		   <li class="main-tab">
			   <div class="link-menu"><img src="<?php echo base_url(); ?>assets/modules/home/uploads/distribution.png"><h3>Distribution Industry</h3></div>
			  <div class="col-md-8 col-sm-8 col-xs-12 result result_hover 3">
			  	
                 <div class="col-md-6"> 
                <ul >					 
                <li>
                  <a href="<?php echo base_url(); ?>lerp/pharma-distribution/" class="erplink">Pharma 
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/lubricants-distribution/" class="erplink">Lubricants
                </li>								
                <li>
				<a href="<?php echo base_url(); ?>lerp/fmcg-distribution/" class="erplink"> FMCG Distribution</a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/food-beverages-distribution/" class="erplink">Food & Beverages 
                  </a>
                </li>	
                </ul> 				
                </div>
				<div class="col-md-6">
				   <ul>
				      <li>
                  <a href="<?php echo base_url(); ?>lerp/Paint-distribution/" class="erplink">Paint
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/cement-distribution/" class="erplink">Cement
                </li>								
                <li><a href="<?php echo base_url(); ?>lerp/stationery-distribution/" class="erplink"> Stationery Distribution
                  </a>
                </li>								
				</ul>
				</div>
                				
              
			  </div>
			  </li>
		   <li class="main-tab">
		     <div class="link-menu"><img src="<?php echo base_url(); ?>assets/modules/home/uploads/shop22.png"><h3>Retail Industry</h3></div>	
			  <div class="col-md-8 col-sm-8 col-xs-12 result result_hover 2">
			   <div class="col-md-6">
			  <ul >		
                  			  
                <li>
                   <a href="<?php echo base_url(); ?>lerp/pharmacy-shop/" class="erplink">Pharmacy 
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/jewellery-shop/" class="erplink">Jewellery 
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/Stationary-Shop/" class="erplink">Stationery 
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/food-beverage-shop/" class="erplink">Food & Beverage
                  </a>
                </li>
				<li>
                  <a href="<?php echo base_url(); ?>lerp/apparel-footwear/" class="erplink">Apparel
                  </a>
                </li>
				</ul>
				</div>
<div class="col-md-6">
			  <ul >						
                <li>
                  <a href="<?php echo base_url(); ?>lerp/garment-store/" class="erplink">Garment 
                  </a>
                </li>							
                <li>
                  <a href="<?php echo base_url(); ?>lerp/supermarket/" class="erplink">Supermarket
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/mobile-electronics-shop/" class="erplink">Mobile & Electronics 
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/tiles-shop/" class="erplink">Tiles 
                  </a>
                </li>
				<li>
                  <a href="<?php echo base_url(); ?>lerp/auto-parts/" class="erplink">Auto Parts 
                  </a>
                </li>
                				
              </ul>
			  </div>
			  </div>
			  </li>
			  
			  
			  </ul>
			  <div class="sub-menu dropdown-menu " role="menu" style="display:none;">
			   
			  <!--<div class="col-md-4 col-sm-4 col-xs-12">
			  <ul >		
                   <h3> Manufacturing Industry</h3>			  
                <li>
                  <a href="<?php echo base_url(); ?>lerp/steel-manufacturing/" class="erplink">Steel Manufacturing
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/metal-fabrication-manufacturing/" class="erplink">Metal Fabrication Manufacturing
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/automobile-industry-manufacturing/" class="erplink">Automobile Industry Manufacturing
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/pharmaceutical-manufacturing-2/" class="erplink">Pharmaceutical Manufacturing
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/packing-material-manufacturing/" class="erplink"> Packing Material Manufacturing
                  </a>
                </li>							
                 <li>
                  <a href="<?php echo base_url(); ?>lerp/food-beverages-manufacturing/" class="erplink">Food & Beverages Manufacturing
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/plastic-manufacturing/" class="erplink">Plastic Manufacturing
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/electronics-manufacturing/" class="erplink">Electronics Manufacturing
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/furniture-manufacturing/" class="erplink">Furniture Manufacturing
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/textile-manufacturing/" class="erplink">Textile Manufacturing
                  </a>
                </li>				
              </ul>
           </div>
			  <div class="col-md-4 col-sm-4 col-xs-12">
			  <ul >		
                  <h3>Retail Industry</h3>				  
                <li>
                  <a href="<?php echo base_url(); ?>lerp/pharmacy-shop/" class="erplink">Pharmacy Shop
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/jewellery-shop/" class="erplink">Jewellery Shop
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/Stationary-Shop/" class="erplink">Stationery Shop
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/food-beverage-shop/" class="erplink">Food & Beverage Shop
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/garment-store/" class="erplink">Garment Store
                  </a>
                </li>							
                <li>
                  <a href="<?php echo base_url(); ?>lerp/supermarket/" class="erplink">Supermarket
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/mobile-electronics-shop/" class="erplink">Mobile & Electronics Shop
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>lerp/tiles-shop/" class="erplink">Tiles Shop
                  </a>
                </li>
                				
              </ul>
			  </div>
			  <div class="col-md-4 col-sm-4 col-xs-12">
			  <ul >		
                  <h3>Distribution Industry</h3>				  
                  <li>
                  <a href="<?php echo base_url(); ?>lerp/pharma-distribution/" class="erplink">Pharma Distribution
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/mandi-distribution/" class="erplink">Mandi Distribution
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/fmcg-distribution/" class="erplink">FMCG Distribution
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/food-beverages-distribution/" class="erplink">Food & Beverages Distribution
                  </a>
                </li>	
				
                
                				
              </ul>
			  </div>-->
			  </div>
            </li>	 
			 <li class="dropdown">							
              <a href="#" class="dropdown-toggle erpnavlink" data-toggle="dropdown" role="button" aria-expanded="false">Career
                <span class="caret">
                </span>
              </a>	
<div class="sub-menu dropdown-menu sub-menu2" role="menu">			  
              <ul  role="menu">								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/life-at-lasting/" class="erplink">Life At Lasting
                  </a>
                </li>								
                <li>
                  <a href="<?php echo base_url(); ?>lerp/apply-now/" class="erplink">Apply Now
                  </a>
                </li>								
                							
              </ul>	
</div>			  
            </li>
            
             <!--<li class="">
              <a href="</?php echo base_url(); ?>lerp/blog/" class="erpnavlink ">Pricing
              </a>
            </li>-->	
            <li class="">
              <a href="<?php echo base_url(); ?>lerp/features/" class="erpnavlink ">Features
              </a>
            </li>
			<li class="">
              <a href="<?php echo base_url(); ?>lerp/blog/" class="erpnavlink ">Blog
              </a>
            </li>
            <li class="">
              <a href="<?php echo base_url(); ?>lerp/learning/" class="erpnavlink ">Learning
              </a>
            </li>			
            							
                  						
                						
          				
            
			
           	<li class="contact-us">
			<div class="btn-grop right">									      
									      <button type="button" class="btn btn-primary Touch"><a href="<?php echo base_url(); ?>auth/#signup" class="erpnavlink ">Free Trial</a></button>
										  
						</div>
						</li>
          </ul>	
</div>			  
          
        </div>			  
        <!--/.nav-collapse -->			
      </div>			
      <!--/.container-fluid -->		
    </nav>	  		
