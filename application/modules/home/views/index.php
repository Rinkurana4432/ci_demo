<!doctype html>
<html lang="en">  
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ERP | Home Page </title>
	<link href="https://fonts.googleapis.com/css?family=Arbutus+Slab" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- Index Page Style -->
    <link href="<?php echo base_url(); ?>assets/modules/home/css/style.css" rel="stylesheet">
	<!-- Animation css -->
	<link href="<?php echo base_url(); ?>assets/modules/home/css/animate.css" rel="stylesheet">
  </head>

	<body>  
  <nav class="navbar navbar-static-top erpbg">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
          <span class="sr-only">Toggle navigation</span>
          <i class="fa fa-bars"></i>
        </button>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
		<ul class="nav navbar-nav navbar-left">
          <li class="active"><a href="#" class="erpnavlink"><i class="fa fa-user"></i>&nbsp;1800 250 162</a></li>
          <li><a href="#" class="erpnavlink">How We Work</a></li>
		  <li class="dropdown menu-large nav-item"> <a href="#" class="dropdown-toggle nav-link erpnavlink" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Services & Maintenance <span class="caret"></span></a>
					<ul class="dropdown-menu megamenu erpmegamenu">
						<div class="row">
							<li class="col-md-4 dropdown-item">
								<ul>
									<li class="dropdown-header">Glyphicons</li>
									<li><a href="#" class="erplink">Available glyphs</a>
									</li>
									<li class="disabled"><a href="#" class="erplink">How to use</a>
									</li>
									<li><a href="#" class="erplink">Examples</a>
									</li>								
								</ul>
							</li>
							<li class="col-md-4 dropdown-item">
								<ul>
									<li class="dropdown-header">Button groups</li>
									<li><a href="#" class="erplink">Basic example</a>
									</li>
									<li><a href="#" class="erplink">Button toolbar</a>
									</li>
									<li><a href="#" class="erplink">Sizing</a>
									</li>
									<li><a href="#" class="erplink">Nesting</a>
									</li>
									<li><a href="#" class="erplink">Vertical variation</a>
									</li>
								</ul>
							</li>
							<li class="col-md-4 dropdown-item">
								<ul>
									<li class="dropdown-header">Input groups</li>
									<li><a href="#" class="erplink">Basic example</a>
									</li>
									<li><a href="#" class="erplink">Sizing</a>
									</li>
									<li><a href="#" class="erplink">Checkboxes and radio addons</a>
									</li>
								</ul>
							</li>
						</div>
					</ul>
				</li>
				<li class="dropdown">
				<a href="#" class="dropdown-toggle erpnavlink" data-toggle="dropdown" role="button" aria-expanded="false">Help Center <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
				  <li><a href="#" class="erplink">For Buyers</a></li>
				  <li><a href="#" class="erplink">For Suppliers</a></li>
				  <li><a href="#" class="erplink">For ERP Users</a></li>
				  <li class="divider"></li>
				  <li><a href="#" class="erplink">For New Users</a></li>
				</ul>
			  </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="active"><a href="#" class="erpnavlink"><i class="fa fa-youtube"></i>YouTube</a></li>
          <li class="dropdown">
			<?php if(isset($_SESSION['loggedInUser'])){
					echo '<a class="nav-link dropdown-toggle erpnavlink" href="'.base_url().'users/edit/'.$_SESSION['loggedInUser']->u_id.'" role="button" aria-haspopup="true" aria-expanded="true">Login as: '.$_SESSION['loggedInUser']->name.'</a>';
					}else{
			?>
		  
					  <a class="nav-link dropdown-toggle erpnavlink" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">Login <span class="caret"></span></a>
						<ul id="login-dp" class="dropdown-menu">
							<li>							
							
								 <div class="row">
										<div class="col-md-12 text-center">
											Login via
											<div class="social-buttons">
												<a href="#"><i class="fa fa-facebook-square fa-2x erpanchor"></i></a>
												<a href="#"><i class="fa fa-google-plus-square fa-2x erpanchor"></i></a>
												<a href="#"><i class="fa fa-linkedin-square fa-2x erpanchor"></i></a>
											</div>
											or
											 <form class="form" role="form" method="post" action="<?php echo base_url().'auth/auth_user'; ?>" accept-charset="UTF-8" id="login-nav">
													<div class="form-group">
														 <label class="sr-only" for="exampleInputEmail2">Email address</label>
														 <input type="email" class="form-control" id="exampleInputEmail2" name="email" placeholder="Email address" required>
													</div>
													<div class="form-group">
														 <label class="sr-only" for="exampleInputPassword2">Password</label>
														 <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" name="password"  required>
														 <div class="help-block text-right"><a class="erpanchor" href="<?php echo base_url().'auth/#resetreqpsd'; ?>">Forget the password ?</a></div>
													</div>
													<div class="form-group">
														 <button type="submit" class="btn btn-primary btn-block btnerpyellow-stylefull">Sign in</button>
													</div>
													<div class="checkbox">
														 <label>
														 <input type="checkbox"> Keep me logged-in
														 </label>
													</div>
											 </form>
										</div>
										<div class="col-md-12 bottom text-center">
											<p>New here ? <a class="erpanchor" href="<?php echo base_url().'auth/#signup'; ?>">Register Now</a>
										</div>
								 </div>
								 
							</li>
						</ul><?php } ?>
					</li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle erpnavlink" data-toggle="dropdown" role="button" aria-expanded="false">Language <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#" class="erplink">EN</a></li>
              <li><a href="#" class="erplink">Hindi</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
    <!--/.container-fluid -->
  </nav>
  
	<div class="header" id="fixedsearch">
		<div class="container">
			<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
				<a href="javasccript:void();"><img src="<?php echo base_url(); ?>assets/modules/home/uploads/logo.png"></a>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
				<nav class="navbar navbar-expand-lg navbar-light animated fadeInUp erppos">				  
					<div class="col-sm-12 col-md-12 col-lg-12 mtop">
						<div class="input-group">
							<div class="input-group-btn search-panel" data-search="categories">
								<button type="button" class="btn btn-default dropdown-toggle btnerp-style" data-toggle="dropdown">
									<span class="search_by">Categories</span> <span class="caret"></span>
								</button>
								<ul class="dropdown-menu erpw" role="menu">
								  <li><a data-search="agriculture" class="erp-left erplink">Agriculture</a></li>
								  <li><a data-search="apparel/textiles" class="erp-left erplink">Apparel/Textiles</a></li>
								  <li><a data-search="auto/" class="erp-left erplink">Auto/</a></li>
								  <li><a data-search="bags/shoes" class="erp-left erplink">Bags/Shoes</a></li>
								  <li><a data-search="electronics" class="erp-left erplink">Electronics</a></li>
								  <li><a data-search="electrical equipment" class="erp-left erplink">Electrical Equipment</a></li>
								  <li><a data-search="gifts, toys & sports" class="erp-left erplink">Gifts, Toys & Sports</a></li>
								  <li><a data-search="health & beauty" class="erp-left erplink">health & beauty</a></li>
								  <li><a data-search="home/light/construction" class="erp-left erplink">Home/Light/Construction</a></li>
								  <li><a data-search="metallurgy/chemicals" class="erp-left erplink">Metallurgy/Chemicals</a></li>
								  <li><a data-search="machinery,industrial parts & tools" class="erp-left erplink">Machinery,Industrial Parts & Tools</a></li>
								  <li><a data-search="packaging, advertising & offices" class="erp-left erplink">Packaging, Advertising & Offices</a></li>
								  <li class="divider"></li>
								  <li><a data-search="all" class="erp-left erplink">All</a></li>
								</ul>
							</div>   
							<form class="form-horizontal" method="GET" action="<?php  echo base_url(); ?>home/search">
								<input type="text" class="form-control srchw" name="product_name" placeholder="SEARCH...">
								<span class="input-group-btn">								
									<button type="submit" class="btn btn-primary btn btn-primary btnerp-stylefull"><i class="fa fa-search"></i></button>
								</span>
							</form>
						</div> 
					</div>
				</nav>
			</div>
		</div>
	</div>
	
	<div class="back">
		<div class="container">
			<div class="centerwhite">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div class="erp-quote animated wow fadeInLeft">							
							<h3> Request For A Quote</h3>
							<h5>We provide instant quote.</h5>
							<form class="form-horizontal" method="POST" action="<?php  echo base_url(); ?>home/rfq">
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
							<div class="item form-group">
								<div class="col-md-7 col-sm-7 col-xs-12">
										<input type="text" class="form-control col-md-7 col-xs-12" name="products" id="inputproduct" required="required" placeholder="Looking For..." >
									</div>
									
									<div class="col-md-3 col-sm-3 col-xs-12">
										<input type="text" class="form-control col-md-7 col-xs-12" name="quantity" id="inputquantity" placeholder="Qty." required="required">
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12">
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
							<?php /*	<button type="submit" class="btn btn-primary btnerp-stylefull col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin: 6px 0;">Get Quote</button> */?>
								<input type="submit" class="btn btn-primary btnerp-stylefull col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin: 6px 0;"></button>
							</form>
							<?php if($this->session->flashdata('message') != ''){
										echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
									}?>
						</div>						
					</div>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
						<div class="erpaddslider animated wow fadeInLeft">
							<div id="advertisecarousel" class="carousel slide" data-ride="carousel">
								<ol class="carousel-indicators">
									<li data-target="#advertisecarousel" data-slide-to="0" class="active erpindicator"></li>
									<li data-target="#advertisecarousel" data-slide-to="1" class="erpindicator"></li>
									<li data-target="#advertisecarousel" data-slide-to="2" class="erpindicator"></li>
									<li data-target="#advertisecarousel" data-slide-to="3" class="erpindicator"></li>
								</ol> 
							  <div class="carousel-inner">
								<div class="item active">
								  <img class="img-responsive" src="<?php echo base_url(); ?>assets/modules/home/uploads/slide1.png" alt="First slide">
								</div>
								<div class="item">
								  <img class="img-responsive" src="<?php echo base_url(); ?>assets/modules/home/uploads/slide2.png" alt="Second slide">
								</div>
								<div class="item">
								  <img class="img-responsive" src="<?php echo base_url(); ?>assets/modules/home/uploads/slide3.png" alt="Third slide">
								</div>
								<div class="item">
								  <img class="img-responsive" src="<?php echo base_url(); ?>assets/modules/home/uploads/slide4.png" alt="Fourth slide">
								</div>
							  </div>
							</div>
						</div>
					</div>
				</div>
				 
				<div class="row">
					<div class="product-section">
						<h1 class="col-xs-12 col-sm-12 col-md-12 col-lg-12 erp-gap animated wow fadeInUp"><span>FEATURED PRODUCTS</span></h1>									
						<div class="row product">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="row">								
								<?php if(!empty($materials)) {
									foreach($materials as $material){ ?>
										<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 erp-margin">
										<div class="erp-border-style erp-padding animated wow fadeInUp">
											<div class="separator">
												<p class="btn-add">
												<?php  $logo = getNameById('company_detail',$material['created_by_cid'],'id')->logo;
													   $logo =  $logo != ''?$logo:'company_logo.jpg';?> 
													<a href="#"><img src="<?php echo base_url(); ?>assets/modules/company/uploads/<?php echo $logo; ?>" class="img-responsive"></a>
												</p>
												<p class="btn-details">
													<a href="#"><?php echo getNameById('company_detail',$material['created_by_cid'],'id')->name;  ?></a>
												</p>
											</div>
											<div class="photo">
												<img src="<?php echo base_url(); ?>assets/modules/inventory/uploads/<?php echo $material['featured_image']?$material['featured_image']:'product.png';  ?>" class="img-responsive" alt="a" />
											</div>
											<div class="info">
												<div class="row">
													<div class="price col-lg-12">
														<h5 class="text-center text-uppercase"><?php echo $material['material_name'];  ?></h5>
														
													</div>															
												</div>
												<div class="clearfix">
												</div>
											</div>
										</div>
									</div>
								<?php	}

								} ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row hidden-xs hidden-sm">
					<div class="erp-process">
					<h1 class="col-xs-12 col-sm-12 col-md-12 col-lg-12 erp-gap animated wow fadeInUp"><span>KNOW OUR PROCESS</span></h1>
						<div class="process">
							<div class="process-row">
								<div class="process-step animated wow fadeInLeft">
									<img src="<?php echo base_url(); ?>assets/modules/home/uploads/s1.png" class="img-responsive erpcenter">
									<p>Create Your Account</p>
								</div>
								<div class="process-step animated wow fadeInLeft">
									<img src="<?php echo base_url(); ?>assets/modules/home/uploads/next.png" class="img-responsive">
								</div> 
								<div class="process-step animated wow fadeInLeft">
									<img src="<?php echo base_url(); ?>assets/modules/home/uploads/s2.png" class="img-responsive erpcenter">
									<p>Use ERP For FREE</p>
								</div>
								<div class="process-step animated wow fadeInLeft">
									<img src="<?php echo base_url(); ?>assets/modules/home/uploads/next.png" class="img-responsive">
								</div> 
								<div class="process-step animated wow fadeInLeft">
									<img src="<?php echo base_url(); ?>assets/modules/home/uploads/s3.png" class="img-responsive erpcenter">
									<p>Connect With Other Companies</p>
								</div> 
								<div class="process-step animated wow fadeInLeft">
									<img src="<?php echo base_url(); ?>assets/modules/home/uploads/next.png" class="img-responsive">
								</div> 
								 <div class="process-step animated wow fadeInLeft">
									<img src="<?php echo base_url(); ?>assets/modules/home/uploads/s4.png" class="img-responsive erpcenter">
									<p>Increase Profit</p>
								</div> 
							</div>
						</div>
					</div>
				</div>
				
				<div class="row hidden-md hidden-lg">
					<div class="erp-process">
					<h1 class="erp-gap animated wow fadeInUp"><span>KNOW OUR PROCESS</span></h1>
						<div class="col-sm-12">
							<div class="row col-sm-12 text-center">
								<div class="col-sm-6 animated wow fadeInUp">
									<img src="<?php echo base_url(); ?>assets/modules/home/uploads/s1.png" class="img-responsive erpcenter">
									<p>1. Create Your Account</p>
								</div> 
								<div class="col-sm-6 animated wow fadeInUp">
									<img src="<?php echo base_url(); ?>assets/modules/home/uploads/s2.png" class="img-responsive erpcenter">
									<p>2. Use ERP For FREE</p>
								</div>
							</div>
							<div class="row col-sm-12 text-center">
								<div class="col-sm-6 animated wow fadeInUp">
									<img src="<?php echo base_url(); ?>assets/modules/home/uploads/s3.png" class="img-responsive erpcenter">
									<p>3. Connect With Other Companies</p>
								</div> 
								<div class="col-sm-6 animated wow fadeInUp">
									<img src="<?php echo base_url(); ?>assets/modules/home/uploads/s4.png" class="img-responsive erpcenter">
									<p>4. Increase Profit</p>
								</div> 
							</div>
						</div>
					</div>
				</div>			
				<div class="row hidden-xs hidden-sm">
					<h1 class="col-md-12 col-lg-12 erp-gap animated wow fadeInUp"><span>OUR SERVICES</span></h1>
					<div class="row col-md-12 col-lg-12 erp-services">
						<div class="col-md-4 col-lg-4 erp-gap animated fadeInLeft">
							<div class="perma animated wow fadeInUp">
								<div class="card border-warning">
									<div class="card-header">Header</div>
									<div class="card-body text-warning">
										<h5 class="card-title">I am heading</h5>
										<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
									</div>
								</div>
							</div>
							<div class="div1 animated wow fadeInUp">
								<h2> Accounting</h2>
								<hr/>
								<p>
									Some quick example text to build on the card title and make up the bulk of the card's content.Some quick example text to build on the card title and make up the bulk of the card's content.
								</p>
							</div>
							<div class="div2 animated wow fadeInUp">second</div>
							<div class="div3 animated wow fadeInUp">third</div>
							<div class="div4 animated wow fadeInUp">fourth</div>
							<div class="div5 animated wow fadeInUp">fifth</div>
							<div class="div6 animated wow fadeInUp">sixth</div>
							<div class="div7 animated wow fadeInUp">seventh</div>
							<div class="div8 animated wow fadeInUp">eighth</div>
							<div class="div9 animated wow fadeInUp">nineth</div>
						</div>
						<div class="col-md-8 col-lg-8 erp-gap animated wow fadeInLeft">								
							<div class="col-md-8 col-lg-8 animated wow fadeInUp">
								<img src="<?php echo base_url(); ?>assets/modules/home/uploads/serviceshover.png" class="img-responsive" style="margin-left:27%;" alt="">
							</div>
							<div id="first" class="service1 zoomin animated wow fadeInUp">
								<img src="<?php echo base_url(); ?>assets/modules/home/uploads/accounting.png" class="img-responsive" alt="">
							</div>
							<div id="second" class="service2 zoomin animated wow fadeInUp">
								<img src="<?php echo base_url(); ?>assets/modules/home/uploads/businessintelligence.png" class="img-responsive" alt="">
							</div>
							<div id="third" class="service3 zoomin animated wow fadeInUp">
								<img src="<?php echo base_url(); ?>assets/modules/home/uploads/crm.png" class="img-responsive" alt="">
							</div>
							<div id="fourth" class="service4 zoomin animated wow fadeInUp">
								<img src="<?php echo base_url(); ?>assets/modules/home/uploads/hrm.png" class="img-responsive"  alt="">
							</div>
							<div id="fifth" class="service5 zoomin animated wow fadeInUp">
								<img src="<?php echo base_url(); ?>assets/modules/home/uploads/inventory.png" class="img-responsive" alt="">
							</div>
							<div id="sixth" class="service6 zoomin animated wow fadeInUp">
								<img src="<?php echo base_url(); ?>assets/modules/home/uploads/production.png" class="img-responsive" alt="">
							</div>
							<div id="seventh" class="service7 zoomin animated wow fadeInUp">
								<img src="<?php echo base_url(); ?>assets/modules/home/uploads/productivitytool.png" class="img-responsive" alt="">
							</div>
							<div id="eighth" class="service8 zoomin animated wow fadeInUp">
								<img src="<?php echo base_url(); ?>assets/modules/home/uploads/purchase.png" class="img-responsive" alt="">
							</div>
							<div id="nineth" class="service9 zoomin animated wow fadeInUp">
								<img src="<?php echo base_url(); ?>assets/modules/home/uploads/reporting.png" class="img-responsive" alt="">
							</div>
						</div>
					</div>
				</div>
				<div class="row hidden-md hidden-lg">
					<div class="erp-services">
					<h1 class="erp-gap"><span>OUR SERVICES</span></h1>
						<div class="col-xs-12 col-sm-12">
							<div class="row text-center">									
								<div class="col-xs-12 col-sm-6 animated wow fadeInUp">									
									<div class="col-xs-10 col-sm-12 erp-border-style erpheight erpboxgap">
										<div class="col-lg-12 erptopgap">
											<img src="<?php echo base_url(); ?>assets/modules/home/uploads/accounting.png" width="50%">
											<hr/>
											<p class="text-jusitfy">Food truck quinoa nesciunt laborum eiusmod.Food truck quinoa nesciunt laborum eiusmod.</p>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 animated wow fadeInUp">									
									<div class="col-xs-10 col-sm-12 erp-border-style erpheight erpboxgap">
										<div class="col-lg-12 erptopgap">
											<img src="<?php echo base_url(); ?>assets/modules/home/uploads/businessintelligence.png" width="50%">
											<hr/>
											<p class="text-jusitfy">Food truck quinoa nesciunt laborum eiusmod.Food truck quinoa nesciunt laborum eiusmod.</p>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 animated wow fadeInUp">									
									<div class="col-xs-10 col-sm-12 erp-border-style erpheight erpboxgap">
										<div class="col-lg-12 erptopgap">
											<img src="<?php echo base_url(); ?>assets/modules/home/uploads/crm.png" width="50%">
											<hr/>
											<p class="text-jusitfy">Food truck quinoa nesciunt laborum eiusmod.Food truck quinoa nesciunt laborum eiusmod.</p>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 animated wow fadeInUp">									
									<div class="col-xs-10 col-sm-12 erp-border-style erpheight erpboxgap">
										<div class="col-lg-12 erptopgap">
											<img src="<?php echo base_url(); ?>assets/modules/home/uploads/hrm.png" width="50%">
											<hr/>
											<p class="text-jusitfy">Food truck quinoa nesciunt laborum eiusmod.Food truck quinoa nesciunt laborum eiusmod.</p>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 animated wow fadeInUp">									
									<div class="col-xs-10 col-sm-12 erp-border-style erpheight erpboxgap">
										<div class="col-lg-12 erptopgap">
											<img src="<?php echo base_url(); ?>assets/modules/home/uploads/inventory.png" width="50%">
											<hr/>
											<p class="text-jusitfy">Food truck quinoa nesciunt laborum eiusmod.Food truck quinoa nesciunt laborum eiusmod.</p>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 animated wow fadeInUp">									
									<div class="col-xs-10 col-sm-12 erp-border-style erpheight erpboxgap">
										<div class="col-lg-12 erptopgap">
											<img src="<?php echo base_url(); ?>assets/modules/home/uploads/production.png" width="50%">
											<hr/>
											<p class="text-jusitfy">Food truck quinoa nesciunt laborum eiusmod.Food truck quinoa nesciunt laborum eiusmod.</p>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 animated wow fadeInUp">									
									<div class="col-xs-10 col-sm-12 erp-border-style erpheight erpboxgap">
										<div class="col-lg-12 erptopgap">
											<img src="<?php echo base_url(); ?>assets/modules/home/uploads/productivitytool.png" width="50%">
											<hr/>
											<p class="text-jusitfy">Food truck quinoa nesciunt laborum eiusmod.Food truck quinoa nesciunt laborum eiusmod.</p>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 animated wow fadeInUp">									
									<div class="col-xs-10 col-sm-12 erp-border-style erpheight erpboxgap">
										<div class="col-lg-12 erptopgap">
											<img src="<?php echo base_url(); ?>assets/modules/home/uploads/purchase.png" width="50%">
											<hr/>
											<p class="text-jusitfy">Food truck quinoa nesciunt laborum eiusmod.Food truck quinoa nesciunt laborum eiusmod.</p>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 animated wow fadeInUp">									
									<div class="col-xs-10 col-sm-12 erp-border-style erpheight erpboxgap">
										<div class="col-lg-12 erptopgap">
											<img src="<?php echo base_url(); ?>assets/modules/home/uploads/reporting.png" width="50%">
											<hr/>
											<p class="text-jusitfy">Food truck quinoa nesciunt laborum eiusmod.Food truck quinoa nesciunt laborum eiusmod.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<!-- <div class="row">
					<h1 class="col-xs-12 col-sm-12 col-md-12 col-lg-12 erp-gap animated wow fadeInUp"><span>FAQ's</span></h1>
					<div class="erp-faqs erp-bottom">
						<div class="center-accordion col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<div id="accordion" class="accordion">
								<div class="card mb-3 erp-border-style animated wow fadeInUp">
									<div class="card-header collapsed bg-white" data-toggle="collapse" href="#collapseOne">
										<a class="card-title">
											Why use erp Enterprise Resource Planning?
										</a>
									</div>
									<div id="collapseOne" class="card-body collapse text-secondary shadow p-3 bg-white rounded" data-parent="#accordion" >
										<p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt	aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat	craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
										</p>
									</div>
								</div>
								<div class="card mb-3 erp-border-style animated wow fadeInUp">
									<div class="card-header collapsed bg-white" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
										<a class="card-title">
											Can I use erp Enterprise Resource Planning for free?
										</a>
									</div>
									<div id="collapseTwo" class="card-body collapse text-secondary shadow p-3 bg-white rounded" data-parent="#accordion" >
										<p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt	aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat	craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
										</p>
									</div>
								</div>
								<div class="card mb-3 erp-border-style animated wow fadeInUp">
									<div class="card-header collapsed bg-white" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
										<a class="card-title">
											Item 3
										</a>
									</div>
									<div id="collapseThree" class="collapse" data-parent="#accordion" >
										<div class="card-body text-secondary shadow p-3 bg-white rounded">
											<p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. samus labore sustainable VHS.
											</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center animated wow fadeInUp">
								<a href="#" class="btn btn-primary btnerp-stylefull">View More </a>
							</div>
						</div>
					</div>
				</div> -->

				<div class="row">
					<h1 class="col-xs-12 col-sm-12 col-md-12 col-lg-12 erp-gap animated wow fadeInUp"><span>FAQ's</span></h1>
					<div class="erp-faqs">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
							<div class="panel-group" id="faqAccordion">
								<div class="panel panel-default erp-border-style animated wow fadeInUp">
									<div class="panel-heading accordion-toggle question-toggle collapsed erpouter" data-toggle="collapse" data-parent="#faqAccordion" data-target="#question0">
										 <h4 class="panel-title">
											Q: What is Lorem Ipsum?
									  </h4>

									</div>
									<div id="question0" class="panel-collapse collapse" style="height: 0px;">
										<div class="panel-body">
											<p class="faqAns">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
												</p>
										</div>
									</div>
								</div>
								<div class="panel panel-default erp-border-style animated wow fadeInUp">
									<div class="panel-heading accordion-toggle collapsed question-toggle erpouter" data-toggle="collapse" data-parent="#faqAccordion" data-target="#question1">
										 <h4 class="panel-title">
										Q: Why do we use it?
									  </h4>

									</div>
									<div id="question1" class="panel-collapse collapse" style="height: 0px;">
										<div class="panel-body">
											<p class="faqAns">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
										</div>
									</div>
								</div>
								<div class="panel panel-default erp-border-style animated wow fadeInUp">
									<div class="panel-heading accordion-toggle collapsed question-toggle erpouter" data-toggle="collapse" data-parent="#faqAccordion" data-target="#question2">
										 <h4 class="panel-title">
											Q: Where does it come from?
									  </h4>

									</div>
									<div id="question2" class="panel-collapse collapse" style="height: 0px;">
										<div class="panel-body">
											<p class="faqAns">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
										</div>
									</div>
								</div>
								<div class="panel panel-default erp-border-style animated wow fadeInUp">
									<div class="panel-heading accordion-toggle collapsed question-toggle erpouter" data-toggle="collapse" data-parent="#faqAccordion" data-target="#question3">
										 <h4 class="panel-title">
											Q: Where can I get some?
									  </h4>

									</div>
									<div id="question3" class="panel-collapse collapse" style="height: 0px;">
										<div class="panel-body">
											<p class="faqAns">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. </p>
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
		<footer class="footer">
			<div class="container bottom_border">
				<div class="row">
					<!-- <div class=" col-sm-4 col-md col-sm-4  col-12 col">
					<h5 class="headin5_amrc col_white_amrc pt2">Find us</h5>
					<!--headin5_amrc
					<p class="mb10">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
					<p><i class="fa fa-location-arrow"></i> 9878/25 sec 9 rohini 35 </p>
					<p><i class="fa fa-phone"></i>  +91-9999878398  </p>
					<p><i class="fa fa fa-envelope"></i> info@example.com  </p>
					</div>-->

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<h5 class="headin5_amrc col_white_amrc pt2">Company</h5>
						<!--headin5_amrc-->
						<ul class="footer_ul_amrc">
							<li><a href="#">About Us</a></li>
							<li><a href="#">Core Values</a></li>
							<li><a href="#">Careers</a></li>
							<li><a href="#">Blog</a></li>
							<li><a href="#">Sitemap</a></li>
						</ul>
						<!--footer_ul_amrc ends here-->
					</div>
			
			
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<h5 class="headin5_amrc col_white_amrc pt2">Policy Info</h5>
						<!--headin5_amrc-->
						<ul class="footer_ul_amrc">
							<li><a href="#">Privacy Policy</a></li>
							<li><a href="#">Terms Of Sale</a></li>
							<li><a href="#">Terms Of Use</a></li>
							<li><a href="#">Report Abuse</a></li>
							<li><a href="#">Take Down Policy</a></li>
						</ul>
						<!--footer_ul_amrc ends here-->
					</div>


					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<h5 class="headin5_amrc col_white_amrc pt2">Need Help?</h5>
						<!--headin5_amrc-->
						<ul class="footer_ul_amrc">
							<li><a href="#">FAQ's</a></li>
							<li><a href="#">Contact Us</a></li>
						</ul>
						<!--footer_ul_amrc ends here-->
					</div>


					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<h5 class="headin5_amrc col_white_amrc pt2">Subscribe</h5>
						<p>
								<div class="input-group">
								  <input type="text" class="form-control" placeholder="Get Subscription">
								  <span class="input-group-btn">
									<button class="btn btn-default" type="button"><span class="fa fa-envelope"></span></button>
								  </span>
								</div><!-- /input-group -->
						</p>
						<p>Register Now to get updates on promotions and coupons.</p>
						<!--headin5_amrc ends here
						<ul class="footer_ul2_amrc">
						<li><a href="#"><i class="fab fa-twitter fleft padding-right"></i> </a><p>Lorem Ipsum is simply dummy text of the printing...<a href="#">https://www.lipsum.com/</a></p></li>
						<li><a href="#"><i class="fab fa-twitter fleft padding-right"></i> </a><p>Lorem Ipsum is simply dummy text of the printing...<a href="#">https://www.lipsum.com/</a></p></li>
						<li><a href="#"><i class="fab fa-twitter fleft padding-right"></i> </a><p>Lorem Ipsum is simply dummy text of the printing...<a href="#">https://www.lipsum.com/</a></p></li>
						</ul>-->
						<!--footer_ul2_amrc ends here-->
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<!-- <ul class="foote_bottom_ul_amrc">
					<li><a href="#">Home</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">Services</a></li>
					<li><a href="#">Pricing</a></li>
					<li><a href="#">Blog</a></li>
					<li><a href="#">Contact</a></li>
					</ul>
					<!--foote_bottom_ul_amrc ends here-->
					<p class="text-center">Copyright @2018 | Designed With Love by <a href="#">Lasting Software Private Limited</a></p>

					<!-- <ul class="social_footer_ul">
					<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
					<li><a href="#"><i class="fab fa-twitter"></i></a></li>
					<li><a href="#"><i class="fab fa-linkedin"></i></a></li>
					<li><a href="#"><i class="fab fa-instagram"></i></a></li>
					</ul>
					<!--social_footer_ul ends here-->
				</div>
			</div>
		</footer>
	
	</body>
	
	<!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Main script -->
	<script src="<?php echo base_url(); ?>assets/modules/home/js/script.js"></script>
	<!-- popper script 
	<script src="../vendors/indexpage/js/popper.min.js"></script>-->
</html>