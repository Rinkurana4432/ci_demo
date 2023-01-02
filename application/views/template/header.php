<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="companyGroupId" content="<?= $_SESSION['loggedInUser']->c_id; ?>">
	<link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon/favicon.png" type="image/ico" />
    <title>LERP! | </title>
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
    <link href="<?= base_url('assets/modules/custombox.min.css') ?>">


    <link rel="stylesheet" href="https://cdn.rawgit.com/pingcheng/bootstrap4-datetimepicker/master/build/css/bootstrap-datetimepicker.min.css">
    <link rel="manifest" href="<?php echo base_url(); ?>assets/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
	<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "bqzdi7sz1p");
	</script>
    <?php
			foreach($css as $styles){ ?>
				<link rel="stylesheet" href="<?php echo base_url() . $styles; ?>" type="text/css" /><?php
	} ?>
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.css" type="text/css" />



<?php /*
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
  fbq('init', '530970690856085');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=530970690856085&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->	*/?>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- top navigation -->
        <div class="top_nav">
		<div class="navbar nav_title" style="border: 0;">
              <a class="for-pc" href="<?php echo base_url(); ?>" class="site_title"><img class="img-responsive" src="<?php echo base_url(); ?>assets/images/beta-version-logo-navi.png"></a>
			  <!--<a class="for-pc" href="</?php echo base_url(); ?>" class="site_title"><img class="img-responsive" src="</?php echo base_url(); ?>assets/images/beta-version-logo-4.png"></a>-->
            </div>
          <div class="nav_menu">
            <nav>
            <!--<div id="sidebar-menu" class="main_menu_side hidden-print main_menu  top-menu-bar sidebar-menu">
              <div class="menu_section mynav">
                <h3>General</h3>
                <ul class="nav side-menu ">

                </ul>
              </div>
            </div>-->


				 <div class="for-side-menu-nav">
				 <div class="sidemenu-bar">
				  <ul id="men" class=" list-unstyled msg_list sidenew" role="menu">
				  <div id="menu1">
				 <?php

					if(($_SESSION['loggedInUser']->role == 1 && $_SESSION['loggedInCompany']->business_status == 1) || ($_SESSION['loggedInUser']->role == 2 ) ){
							$all_menus = menus_listing_all();
							// pre($all_menus);
							if(!empty($all_menus)){
							   
								foreach($all_menus as $menu){
									
									if(($menu['has_child'] == 1)  && (!empty($menu['submenu']))){
										echo '<li id="'.$menu["id"].'" class="module_menu">
											<span class="image"><img src="'.base_url().'assets/images/'.$menu["image_icon"].'" alt="Profile Image"></span>
											<a class="module_name">'.$menu["title"].'</a>
										</li>';
									}
								}
							}
						}
						else if($_SESSION['loggedInUser']->role == 3 && $_SESSION['loggedInCompany']->business_status == 0){
							$all_menus = menus_listing_all();

							
							if(!empty($all_menus)){
								foreach($all_menus as $menu){
									if(($menu['has_child'] == 1)  && (!empty($menu['submenu'])) && ($menu['id'] == 113 || $menu['id'] == 85 || $menu['id'] == 54)){
										echo '<li id="'.$menu["id"].'" class="module_menu">
											<span class="image"><img src="'.base_url().'assets/images/'.$menu["image_icon"].'" alt="Profile Image"></span>
											<a class="module_name">'.$menu["title"].'</a>
										</li>';
									}
								}
							}
						}
				  ?>
                  </div>
                  </ul>
			 <div id="sidebar-menu" class="main_menu_side hidden-print main_menu  sidebar-menu">
              <div class="menu_section mynav">
                <h3>General</h3>
                <ul class="nav side-menu ">

                </ul>
              </div>
            </div>
			</div>
			</div>



			<div class="toggle2" style="float:right;">
			    <a id="menu_toggle-3"><i class="fa fa-user"></i></a>
                <a id="menu_toggle-2"><i class="fa fa-bars"></i></a>
            </div>
              <ul class="nav navbar-nav navbar-right mobile-menu">


                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                 <img  class="img-responsive" src="<?php if(isset($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->user_profile !='' ){ echo base_url().'assets/modules/hrm/uploads/'.$_SESSION['loggedInUser']->user_profile; }else{ echo base_url().'assets/images/dummy.jpg' ; }?>" alt=""><?php   if(isset($_SESSION['loggedInUser'])){ echo $_SESSION['loggedInUser']->name; } ?>


                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                   <?php if(($_SESSION['loggedInUser']->role == 1 && $_SESSION['loggedInCompany']->business_status == 1) || ($_SESSION['loggedInUser']->role == 2 ) ){?>
						<li><a href="<?php if(isset($_SESSION['loggedInUser'])){ echo base_url().'hrm/editUser/'.$_SESSION['loggedInUser']->id; }  ?>"> Profile</a></li>
				<?php } ?>
                    <li><a href="<?php echo base_url(); ?>lasting_erp/contact-us/" target="_blank">Help</a></li>
                    <li><a href="<?php echo base_url(); ?>auth/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
				<li class="dropdown comany">
					<?php // pre(getCompaniesOfGroup()); ?>

					<?php /* <form method="post" class="form-horizontal" action="http://busybanda.com/company/changeDb" enctype="multipart/form-data" id="companyForm" novalidate="novalidate"> */ ?>
						<select name="companyName" onchange="changeCompanyFilter(this.value)">
							<?php

             # #$ee = trying();
              // pre($_SESSION);
              // die;
        if($_SESSION['loggedInUser']->role == 2 || $_SESSION['loggedInUser']->role == 3){
							$companies1 = getcompany_for_users();
							 //pre($companies1);
							$selected1 = '';
							if(!empty($companies1)){
								foreach($companies1 as $cg1){



									if($cg1["id"] == $_SESSION['loggedInUser']->c_id){
										if(!isset($_SESSION['companyGroupSessionId'])){
											$selected1 = 'selected';
										}
										echo '<option value="'.$cg1["comp_id"].'" '.$selected1.'>'.$cg1["name"].'</option>';
									}else{
										$selected1 = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] !='' && $_SESSION['companyGroupSessionId'] == $cg1["comp_id"])?'selected':'';
										echo '<option value="'.$cg1["comp_id"].'" '.$selected1.'>'.$cg1["name"].'</option>';
									}
								}
							}
          }
          else{
            $companies2 = getCompaniesOfGroup();
              $selected2 = '';
              if(!empty($companies2)){
                foreach($companies2 as $cg2){

                   # pre($cg2);

                  if($cg2["id"] == $_SESSION['loggedInUser']->c_id){
                    if(!isset($_SESSION['companyGroupSessionId'])){
                      $selected2 = 'selected';
                    }
                    echo '<option value="'.$cg2["id"].'" '.$selected2.'>'.$cg2["name"].'</option>';
                  }else{
                    $selected2 = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] !='' && $_SESSION['companyGroupSessionId'] == $cg2["id"])?'selected':'';
                    echo '<option value="'.$cg2["id"].'" '.$selected2.'>'.$cg2["name"].'</option>';
                  }
                }
              }
          }
              ?>
						<?php	/* <option value="azuka@gmail.com">Azuka Synthetics llp</option>
							<option value="mauliroy3@gmail.com">Matrix Infologics</option> */ ?>
						</select>
						<?php /* if(isset($_SESSION['companyGroupSessionId']) && !empty($_SESSION['companyGroupSessionId'])){ echo $_SESSION['companyGroupSessionId'];  } */ ?>
						<!--<input type="submit" value="change">-->
					<?php /* </form> */ ?>
				</li>

				<li role="presentation" class="dropdown back-roung for-all" data-toggle="tooltip" data-placement="bottom" title="My Apps">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="true">
                   <i class="fa fa-th" aria-hidden="true"></i>
                  </a>
                  <ul id="men" class="dropdown-menu list-unstyled msg_list" role="menu">
				  <div id="menu1">
				   
				 <?php
						
						if(($_SESSION['loggedInUser']->role == 1 && $_SESSION['loggedInCompany']->business_status == 1) || ($_SESSION['loggedInUser']->role == 2 ) ){
							$all_menus = menus_listing_all();
							if(!empty($all_menus)){
								foreach($all_menus as $menu){
									if(($menu['has_child'] == 1)  && (!empty($menu['submenu']))){
										echo '<li id="'.$menu["id"].'" class="module_menu">
											<span class="image"><img src="'.base_url().'assets/images/'.$menu["image_icon"].'" alt="Profile Image"></span>
											<span class="module_name">'.$menu["title"].'</span>
										</li>';
									}
								}
							}
						}else if($_SESSION['loggedInUser']->role == 3 && $_SESSION['loggedInCompany']->business_status == 0){
							$all_menus = menus_listing_all();
							if(!empty($all_menus)){
								foreach($all_menus as $menu){
									if(($menu['has_child'] == 1)  && (!empty($menu['submenu'])) && ($menu['id'] == 113 || $menu['id'] == 85 || $menu['id'] == 54)){
										echo '<li id="'.$menu["id"].'" class="module_menu">
											<span class="image"><img src="'.base_url().'assets/images/'.$menu["image_icon"].'" alt="Profile Image"></span>
											<span class="module_name">'.$menu["title"].'</span>
										</li>';
									}
								}
							}
						}
				  ?>
                  </div>
                  </ul>
				   <div class="modal-backdrop fade in"></div>
                </li>


				<li class="dropdown">
				<a href="#" class="dropdown-toggle dropdown-toggle-noti" data-toggle="dropdown">
					<span class="label label-pill label-danger count" style="border-radius:10px;"></span>
					<span class="glyphicon glyphicon-bell" style="font-size:18px;"></span>
				</a>
			   <ul class="dropdown-menu dropdown-menu-noti"></ul>
			</li>

                <!--<li role="presentation" class="dropdown back-roung" data-toggle="tooltip" data-placement="bottom" title="app store">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="true">
                   <img src="</?php echo base_url(); ?>assets/images/app-store.png" alt="Profile Image">

                  </a>
                  <div id="my-app" class="dropdown-menu list-unstyled msg_list" role="menu">
				     <div class="search-container">
						<form action="/action_page.php">
						  <button type="submit"><i class="fa fa-search"></i></button>
						  <input type="text" placeholder="Search.." name="search">
						</form>
					 </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
							 <div class="right col-xs-4 text-center">
                              <img src="</?php echo base_url(); ?>assets/images/dashboard-2.jpg" alt="" class=" img-responsive">
                            </div>
                            <div class="left col-xs-8">
                              <h2>Dashboard</h2>
                              <p>create your custom dashboard </p>
                              <p><i class="fa fa-usd" aria-hidden="true"></i>50 USD/Month</p>
                            </div>

                          </div>
                          <div class="col-xs-12 bottom text-center">
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <p class="ratings">

                              </p>
                            </div>
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <button type="button" class="btn btn-primary btn-xs">
                                 instal
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
					   </?php  if(($_SESSION['loggedInUser']->role == 1 && $_SESSION['loggedInCompany']->business_status == 1) || ($_SESSION['loggedInUser']->role == 2 ) ){
							$all_menus = menus_listing_all();
							if(!empty($all_menus)){
								foreach($all_menus as $menu){
									if(($menu['has_child'] == 1)  && (!empty($menu['submenu']))){ ?>
										<div class="col-md-4 col-sm-4 col-xs-12 profile_details">
											<div class="well profile_view">
												<div class="col-sm-12">
													 <div class="right col-xs-4 text-center">
													  <img src="</?php echo base_url(); ?>assets/images/</?php echo $menu["image_icon"]; ?>" alt="" class=" img-responsive">
													</div>
													<div class="left col-xs-8">
													  <h2> </?php echo $menu["title"]; ?></h2>
													  <p>create your custom dashboard </p>
													  <p><i class="fa fa-usd" aria-hidden="true"></i>50 USD/Month</p>
													</div>
												</div>
											  <div class="col-xs-12 bottom text-center">
												<div class="col-xs-12 col-sm-6 emphasis">
												  <p class="ratings">
												  </p>
												</div>
												<div class="col-xs-12 col-sm-6 emphasis">
												  <button type="button" class="btn btn-primary btn-xs">
													 install
												  </button>
												</div>
											  </div>
											</div>
										  </div>
									</?php	  }
								}
							}
						}
				  ?>

                  </div>

				   <div class="modal-backdrop fade in"></div>
                </li>-->

              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

		<div class="right_col" role="main" style="min-height: 3704px;">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h4><?php
				if(isset($breadcrumbs)){
					echo $breadcrumbs;
				}
				else{ ?>
					<div class="alert alert-error">
						<button class="close" data-dismiss="alert"></button>
						Warning: Breadcrumbs Not Defined in the Module
					</div><?php
				}	?> <small></small></h4>
			</div>

		</div>
        <div class="clearfix"></div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php if(isset($pageTitle)){
					echo $pageTitle;
				} ?><small></small></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="pull-right " id="for-add-btn"><i class="fa fa-ellipsis-h"></i></div>
				<div class="clearfix"></div>
			</div>
