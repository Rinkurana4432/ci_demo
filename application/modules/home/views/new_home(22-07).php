
<div class="back">
<div class="container-fulled baneer-div">
   <div class="container baneer">
      <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 flex">
            <div class="animated wow fadeInLeft">
			    <video style="height: 100%;width: 100%; padding: 20px; padding-left: 0px;" width="650" height="450" autoplay loop muted playsinline>
				  <source src="<?php echo base_url(); ?>assets/modules/home/uploads/erpVideo.mp4" type="video/mp4">
				</video>
			
               <!--<iframe width="1280" height="750" src="https://www.youtube.com/embed/S12N-Iodbno?autoplay=1&loop=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>--->
			    

            </div>
         </div>
         <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="padding-top: 48px;">
								
							
							<div class="baneer-hadding"> 
							       
									  <div class="modal-content get-in-touch col-md-9" style="float: right;  width: 100%; text-align: center;">
										
										<?php 
										if(isset($_SESSION['loggedInUser'])){
                      header("Location: /dashboard");

									 
									
										}else{		
										?>					  											
              							<div class="modal-header" ><h4 class="modal-title" style="text-align: center;">Login</h4></div>		
								  <div class="row" style="margin-top:20px;">
								  
									<div class="col-md-12 text-center">										 
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
										<div class="form-group col-md-6" style="padding-left: 0px;">														
										  <button type="submit" class="btn btn-primary btn-block btnerpyellow-stylefull">Sign in
										  </button>													
										</div>													
										<div class="col-md-6 bottom text-center">											
									      <button type="button" class="btn btn-primary btn-block btnerpyellow-stylefull" data-toggle="modal" data-target="#myModal" style="width:auto; margin:0px auto;">Request a call back</button>								
									</div>									 
									  </form>										
									</div>										
																			
																
								  </div>								 								
							   
							  <?php } ?>	
									  </div>
									  
									
							</div>
						</div>
      </div>
   </div>
</div>


<div class="container-fulled ">
   <div class="video-box">
      <h3 class="hadding-main">
         It’s All Under One Roof
      </h3>
	  <div class="container">
      <img src="<?php echo base_url(); ?>assets/modules/home/uploads/baneer-img.png">
	  </div>
   </div>
</div>
<div class="container-fulled">
   <div class="container">
      <h3 class="hadding-main">
         Benefits of Implementing ERP Software
      </h3>
      <!--<p class="hadding-child">A complete operations platform for brands, retailers and wholesalers</p>-->
      <div class="col-md-12" style="padding: 0px;">
	  <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/shopping-cart.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3>E-Commerce Integration</h3>
            </div>
         </div>
         <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/track.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3>Track Communication</h3>
            </div>
         </div>
         <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/success.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3>No Skilled Staff <br>Required</h3>
            </div>
         </div>
         <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/shopping-bag.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3>Streamlined Sales <br>Cycle</h3>
            </div>
         </div>
         <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/income.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3>Optimize Recurring <br>Revenue</h3>
            </div>
         </div>
      </div>
      <div class="col-md-12" style="padding: 0px;">
         <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/global.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3>Manage Global <br>Financials </h3>
            </div>
         </div>
         <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/health-check.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3>Cost Calculator</h3>
            </div>
         </div>
         <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/automation.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3>Flexible User<br>Permission</h3>
            </div>
         </div>
         <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/lightbulb.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3>Automate Subscription</h3>
            </div>
         </div>
		 <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/user-interface.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3> Mobile App</h3>
            </div>
         </div>
      </div>
	  <div class="col-md-12" style="padding: 0px;">
         <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/document.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3>100+ Reports</h3>
            </div>
         </div>
         <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/360-degree.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3>360° View of Business</h3>
            </div>
         </div>
         <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/compliant.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3>Government complaint</h3>
            </div>
         </div>
         <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/cyber-security.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3>Highly Secure</h3>
            </div>
         </div>
		 <div class="col-md-2 col-sm-6 col-xs-6 m-1 modual-box">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/save-money.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <h3> Save More <br>Time</h3>
            </div>
         </div>
      </div>
   </div>
</div>





<div class="container-fulled lspl-simle">
   <div class="container">
      <h3 class="hadding-main">
        Going beyond the benchmark
      </h3>
      <div class="col-md-12">

	   <div class="col-md-3 col-sm-6 col-xs-12">
         <div class="col-md-12 col-sm-12 col-xs-12 m-1 lspl-1" style="padding: 20px 7%;">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/time.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12" style="padding: 16px 0px;padding-top: 0px;">
			   <h2><span class="countfect" data-num="6"></span>+</h2>
               <h3>Years Of Excellence</h3>
            </div>
         </div>
       </div>
	   <div class="col-md-3 col-sm-6 col-xs-12">
         <div class="col-md-12 col-sm-12 col-xs-12 m-1 lspl-1" style="padding: 20px 7%;">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/threedot.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12" style="padding: 16px 0px;padding-top: 0px;">
			   <h2><span class="countfect" data-num="100"></span>+</h2>
               <h3>Implementations</h3>
            </div>
         </div>
       </div>
	   <div class="col-md-3 col-sm-6 col-xs-12">
         <div class="col-md-12 col-sm-12 col-xs-12 m-1 lspl-1" style="padding: 20px 7%;">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/kajakkazahaj.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12" style="padding: 16px 0px;padding-top: 0px;">
			    <h2><span class="countfect" data-num="50"></span>+</h2>
               <h3>Strong Workforce</h3>
            </div>
         </div>
       </div>
	   	  <div class="col-md-3 col-sm-6 col-xs-12">
         <div class="col-md-12 col-sm-12 col-xs-12 m-1 lspl-1" style="padding: 20px 7%;">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
               <div class="row">
                  <img src="<?php echo base_url(); ?>assets/modules/home/uploads/add-user.png" alt="purchase order software for small business" class="img-responsive">
               </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12" style="padding: 16px 0px;padding-top: 0px;">
			  <h2><span class="countfect" data-num="7000"></span>+</h2>
               <h3>Users</h3>
            </div>
         </div>
       </div>
	  </div>
    </div>
</div>










<div class="container-fulled employee">
   <div class="container">
      <h3 class="hadding-main">
         Teamwork makes the Dreamwork
      </h3>
   </div>
   <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 back-ground-baneer" >
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">	
								<div class="topsearchedSlider slider sliderm">
									<!-- product -->
									<div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-1-of.png" alt="purchase order software for small business" class="img-responsive">
							  
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-2-of.png" alt="purchase order software for small business" class="img-responsive">
							   
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-3-of.png" alt="purchase order software for small business" class="img-responsive">
							  
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-4-of.png" alt="purchase order software for small business" class="img-responsive">
							   
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-5-of.png" alt="purchase order software for small business" class="img-responsive">
							 
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-6-of.png" alt="purchase order software for small business" class="img-responsive">
							  
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-7-of.png" alt="purchase order software for small business" class="img-responsive">
							   
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-8-of.png" alt="purchase order software for small business" class="img-responsive">
							  
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-9-of.png" alt="purchase order software for small business" class="img-responsive">
							   
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-10-of.png" alt="purchase order software for small business" class="img-responsive">
							 
						   </div>
						   <div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-11-of.png" alt="purchase order software for small business" class="img-responsive">
							   
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-12-of.png" alt="purchase order software for small business" class="img-responsive">
							 
						   </div>
						   <div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-13-of.png" alt="purchase order software for small business" class="img-responsive">
							  
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-14-of.png" alt="purchase order software for small business" class="img-responsive">
							   
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-15-of.png" alt="purchase order software for small business" class="img-responsive">
							  
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-16-of.png" alt="purchase order software for small business" class="img-responsive">
							   
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-17-of.png" alt="purchase order software for small business" class="img-responsive">
							 
						   </div>
						   <div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-18-of.png" alt="purchase order software for small business" class="img-responsive">
							   
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-19-of.png" alt="purchase order software for small business" class="img-responsive">
							 
						   </div>
						   <div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-20-of.png" alt="purchase order software for small business" class="img-responsive">
							  
						   </div>
						   <div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-21-of.png" alt="purchase order software for small business" class="img-responsive">
							 
						   </div>
						   <div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-22-of.png" alt="purchase order software for small business" class="img-responsive">
							   
						   </div><div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-23-of.png" alt="purchase order software for small business" class="img-responsive">
							 
						   </div>
						   <div class="col-md-1 reviews-bar">
						       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/img-24-of.png" alt="purchase order software for small business" class="img-responsive">
							  
						   </div>
									<!-- /product -->
								</div>						
							</div>
							<!-- /col -->
						
					</div>
</div>


<section id="trusted-customers">
<div class="container">
        <h3 class="hadding-main">
         Our Clients Our Pride
      </h3>

<div class="no-padding">
		<ul id="customers-list">
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/azuka-logo.png" alt="mankind uneecops client">	
			</li>
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/Jindal.png" alt="cars 24 uneecops client">	
			</li>
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/logo44.png" alt="King koil uneecops client">	
			</li>
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/indaco.png" alt="Bharat petrolium uneecops client">	
			</li>
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/milestone.png" alt="Mother dairy uneecops client">	
			</li>
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/Logo_PNG.png" alt="jcb uneecops client">	
			</li>
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/ntc.png" alt="Haier uneecops client">	
			</li>
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/Pride Fleet Solutions.png" alt="ColdEX uneecops client">	
			</li>
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/sterling.png" alt="Apollo Munich uneecops client">	
			</li>
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/bimla.jpg" alt="Maharaja Whiteline uneecops client">	
			</li>
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/oxera.png" alt="Haier uneecops client">	
			</li>
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/jk.png" alt="ColdEX uneecops client">	
			</li>
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/katora-1.jpg" alt="Apollo Munich uneecops client">	
			</li>
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/inflame.png" alt="Maharaja Whiteline uneecops client">	
			</li>
			<li class="valign-wrapper center-align">
				<img src="<?php echo base_url(); ?>assets/modules/home/uploads/ganpati.png" alt="Maharaja Whiteline uneecops client">	
			</li>
		</ul>
	</div>
</div>
</section>

 <div class="modal" id="myModal">
    <div class="modal-dialog" style="width: 40.7%; margin: 167px auto;">
      <div class="modal-content back-mg">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Simply fill out the form and we’ll be in touch</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="overflow: hidden; padding: 40px 25px;">
		
		<div class="col-md-6 image-box-form">
       <div class="row">		
		<div class="col-md-6">
		      <img src="<?php echo base_url(); ?>assets/modules/home/uploads/alert.png">
		       <h3>Avoid Mistakes</h3>   
		</div>
		<div class="col-md-6">
		      <img src="<?php echo base_url(); ?>assets/modules/home/uploads/save-money55.png">
		      <h3>Save Time & Money</h3> 
		</div>
		</div>
		<div class="row">		
		<div class="col-md-6">
		       <img src="<?php echo base_url(); ?>assets/modules/home/uploads/cyber-security.png">
		       <h3>Cloud Security</h3>   
		</div>
		<div class="col-md-6">
		      <img src="<?php echo base_url(); ?>assets/modules/home/uploads/high-visibility.png">
		      <h3>Total Visibility</h3> 
		</div>
		</div>
		</div>
		
		<div class="col-md-6 form-box-register">
          <form id="regForm" method="post" action="">

  <!-- One "tab" for each step in the form: -->
  <div class="tab" id="tab1">  	
    <p><input placeholder="Name..." oninput="this.className = ''" id="name" name="Name" ></p>
    <p><input placeholder="E-mail..." oninput="this.className = ''" id="email" name="email"></p>
    <span id="email-error"></span>
	<p><input id="phone" name="phone" type="tel" style="width: 100%;padding-left: 96px !important;"></p>
	 <!--<div data-type="image" class="g-recaptcha" data-sitekey="6LdbydgaAAAAAORMO_9-GYZAn0_M35Eea93OFlBe" id="captcha1" style="overflow: hidden;margin-bottom: 10px;"></div>-->
	 <div data-type="image" class="g-recaptcha" data-sitekey="6LcZVpIbAAAAAINYE_ajxM2FU517uO5CBsVBjuvY" id="captcha1" style="overflow: hidden;margin-bottom: 10px;"></div>
  <span id="captcha_error1"></span>
	<button type="button" class="btn btn-danger" id="nextBtn1" onclick="nextPrev(1)">Submit</button>
  </div>
  <div class="tab">
    <p><input placeholder="Company Name" oninput="this.className = ''" id="company_name" name="cNeme"></p>
	<p><select id="industry" class="popup_desk_field sidebar_form_input" required="1" name="ssleadpost[industry]" aria-label="industry">
		<option value="">-- Select Industry --</option>
		<option value="Accounting / CPA">Accounting / CPA</option>
		<option value="Advertising">Advertising</option>
		<option value="Agriculture">Agriculture</option>
		<option value="Architecture">Architecture</option>
		<option value="Auto Dealership" >Auto Dealership</option>
		<option value="Banking">Banking</option>
		<option value="Banking &amp; Mortgage">Banking &amp; Mortgage</option>
		<option value="Construction / Contracting">Construction / Contracting</option>
		<option value="Consulting">Consulting</option>
		<option value="Distribution">Distribution</option>
		<option value="Education">Education</option>
		<option value="Engineering">Engineering</option>
		<option value="Food / Beverage">Food / Beverage</option>
		<option value="Government Agencies">Government Agencies</option>
		<option value="Government Contractors">Government Contractors</option>
		<option value="Healthcare / Social Services">Healthcare / Social Services</option>
		<option value="Hospitality / Travel">Hospitality / Travel</option>
		<option value="Insurance">Insurance</option>
		<option value="Legal / Law Firm">Legal / Law Firm</option>
		<option value="Marketing Services">Marketing Services</option>
		<option value="Maintenance / Field Service">Maintenance / Field Service</option>
		<option value="Manufacturing">Manufacturing</option>
		<option value="Media &amp; Newspaper">Media &amp; Newspaper</option>
		<option value="Nonprofit">Nonprofit</option>
		<option value="Oil &amp; Gas">Oil &amp; Gas</option>
		<option value="Pharmaceuticals">Pharmaceuticals</option>
		<option value="Property Management">Property Management</option>
		<option value="Real Estate">Real Estate</option>
		<option value="Retail">Retail</option>
		<option value="Software / Technology">Software / Technology</option>
		<option value="Transportation">Transportation</option>
		<option value="Telecommunications">Telecommunications</option>
		<option value="Utilities">Utilities</option>
		<option value="Other">Other</option>
		</select></p>
	<p><input placeholder="City" oninput="this.className = ''" id="city" name="city"></p>
    <p><textarea placeholder="Requirements" id="requirements" oninput="this.className = ''" name="Requirements"></textarea></p>
    <button type="button" class="btn btn-danger" id="nextBtn2" onclick="nextPrev(2)">Submit</button>

  </div>
  <div class="tab">
    <p><select id="designation" class="popup_desk_field sidebar_form_input" required="1" name="ssleadpost[designation]" aria-label="designation">
<option value="">-- Select Designation --</option>
<option value="Accountant">Accountant</option>
<option value="President">President</option>
<option value="Chairman">Chairman</option>
<option value="Consultant">Consultant</option>
<option value="CEO">CEO</option>
<option value="CXO">CXO</option>
<option value="Designer">Designer</option>
<option value="Developer">Developer</option>
<option value="Assistant Manager">Assistant Manager</option>
<option value="Doctor">Doctor</option>
<option value="Director">Director</option>
<option value="Engineer">Engineer</option>
<option value="Executive">Executive</option>
<option value="Freelancer">Freelancer</option>
<option value="General Manager">General Manager</option>
<option value="Clerk">Clerk</option>
<option value="Managing Director">Managing Director</option>
<option value="Chief Financial officer">Chief Financial officer</option>
<option value="IT Manager">IT Manager</option>
<option value="Manager">Manager</option>
<option value="Owner/Proprietor">Owner/Proprietor</option>
<option value="Supervisor">Supervisor</option>
<option value="Vice President">Vice President</option>
<option value="Committee Member">Committee Member</option>
<option value="Society Member">Society Member</option>
<option value="Trustee">Trustee</option>
<option value="Secretary">Secretary</option>
<option value="Partner">Partner</option>
<option value="HR Manager">HR Manager</option>
<option value="HR Executive">HR Executive</option>
<option value="Admin">Admin</option>
<option value="Principal">Principal</option>
<option value="Regional Director">Regional Director</option>
<option value="Regional Manager">Regional Manager</option>
</select></p>
    <p><select id="employees" class="popup_desk_field sidebar_form_input" required="1" name="ssleadpost[no_of_employees]" aria-label="no_of_employees">
<option value="">-- Select No. of Employees --</option>
<option value="Less than 50
                    ">Less than 50</option>
<option value="50-100" >50-100</option>
<option value="100-500">100-500</option>
<option value="500-1000">500-1000</option>
<option value="More than 1000">More than 1000</option>
</select></p>
    <p><select id="users" class="popup_desk_field sidebar_form_input" required="1" name="ssleadpost[no_of_users]" aria-label="no_of_users">
<option value="">-- No. of Software Users --</option>
<option value="1 - 5 Users">1 - 5 Users</option>
<option value="6 - 9 Users">6 - 9 Users</option>
<option value="10 - 19  Users" >10 - 19 Users</option>
<option value="20 - 29 Users">20 - 29 Users</option>
<option value="30 - 39  Users">30 - 39 Users</option>
<option value="40 - 49  Users">40 - 49 Users</option>
<option value="50 - 99  Users">50 - 99 Users</option>
<option value="100 -199  Users">100 -199 Users</option>
<option value="200 - 499 Users">200 - 499 Users</option>
<option value="500 - 999 Users">500 - 999 Users</option>
<option value="1000 Users and Above">1000 Users and Above</option>
</select></p>
    <p><select id="call_time" class="popup_desk_field sidebar_form_input" required="1" name="ssleadpost[prefer_time_to_call]" aria-label="prefer_time_to_call">
<option value="">-- Select Preferred Time To Call --</option>
<option value="All Day">All Day</option>
<option value="Morning">Morning</option>
<option value="Noon">Noon</option>
<option value="Evening">Evening</option>
</select></p>

   <button type="button" class="btn btn-danger" id="nextBtn3" onclick="nextPrev(3)">Submit</button>
  </div>
  <div class="tab" id="tab4">
    <p><select id="deployment" class="popup_desk_field sidebar_form_input" required="1" name="ssleadpost[deployment]" aria-label="deployment">
<option value="">-- Select Deployment --</option>
<option value="Cloud Based">Cloud Based</option>
<option value="On Premises" >On Premises</option>
<option value="Hybrid">Hybrid</option>
<option value="Any">Any</option>
</select></p>
    <p><input placeholder="Current software" oninput="this.className = ''" id="current_software" name="pword" type="csoftware"></p>
    <p><input placeholder="Reason to changes" oninput="this.className = ''" id="reason" name="pword" type="Reason"></p>
    <button type="button" class="btn btn-danger" id="nextBtn" onclick="nextPrev(4)">Submit</button>
  </div>
  <div style="overflow:auto;">
    <div style="text-align: center;">
    	<span id="msg-success" style="display: none;font-size:14px;color:green">Thankyou for your interest in ERP.Will Contact soon</span>
      <!--<button type="button" id="prevBtn" onclick="nextPrev(-1)" style="display:none;">Previous</button>-->
     <!-- <button type="button" class="btn btn-danger" id="nextBtn" onclick="nextPrev(1)">Submit</button>-->
    </div>
  </div>
  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px; display:none;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
  </div>
</form>
</div>
        </div>
        
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>
  
</div>
<script src='https://www.google.com/recaptcha/api.js' async defer ></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
<script>
   
$( document ).ready(function() {

 $("#phone").intlTelInput({
 	initialCountry:"in",
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
    }); 


});
function validateEmail(email) {
  const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");

  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
 /* if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }*/
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
     document.getElementById("nextBtn1").innerHTML = "Next";
     document.getElementById("nextBtn2").innerHTML = "Next";
     document.getElementById("nextBtn3").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
	if(n==1){
		var email=$('#email').val();
		 if (validateEmail(email)) {
		 	
		 }else{
		$('#email-error').html('Invalid email').css("color", "red");
		return false;
		 }
		$('#tab1').css('display:block');
		  var captcha = $( '#captcha1' ),
      response = grecaptcha.getResponse();
  	if (response.length === 0) 
		{
			$('#captcha_error1').html('Please verify captcha').css('color','red');
			return false;
		}else{
			 $.ajax({
        url: '<?php echo base_url();?>home/submit_captcha',
        data: {'g-recaptcha-response': response,'key':'6LdCx0wbAAAAAHTH8qfzeP8tDIMGOlY3UiM1eKmb'}, // change this to send js object
        type: "post",
        success: function(data){
        	grecaptcha.reset();
		var name=$('#name').val();
		var email=$('#email').val();
		var phone=$('#phone').val();
	 $.ajax({
        url: '<?php echo base_url();?>home/send_request_mail',
        data: {'name': name,'email':email,'phone':phone}, // change this to send js object
        type: "post",
        dataType : "json",
        success: function(data){
				
        }
      });
	}
})
}
}
	if(n==4){ 
		$('#tab4').css('display:block');		
	        var name=$('#name').val();
			var email=$('#email').val();
			var phone=$('#phone').val();
			var industry=$('#industry').val();
			var company_name=$('#company_name').val();
			var city=$('#city').val();
			var requirements=$('#requirements').val();
			var current_software=$('#current_software').val();
			var reason=$('#reason').val();
			var employees=$('#employees').val();
			var designation=$('#designation').val();
			var deployment=$('#deployment').val();
			var call_time=$('#call_time').val();
			var users=$('#users').val();
		 $.ajax({
	        url: '<?php echo base_url();?>home/send_request_callback_mail',
	        data: {'name': name,'email':email,'phone':phone,'industry':industry,'company_name':company_name,'city':city,'requirements':requirements,'current_software':current_software,'reason':reason,'employees':employees,'designation':designation,'deployment':deployment,
	        'call_time':call_time,'users':users}, // change this to send js object
	        type: "post",
	        dataType : "json",
	        error: function(error){
	        	//$('#msg-success').show();
	        	//console.log( error );
	        	//location.reload();
	        },
	        success: function(data){
	        	
	        	//console.log( data );
	        //	location.reload();
	        }
	      });
	}
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  if (n == 2 && !validateForm()) return false;
  if (n == 3 && !validateForm()) return false;
  if (n == 4 && !validateForm()) return false;

 
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
  	$('#msg-success').show();
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab
if(currentTab==4){
$('#tab4').show();
}
showTab(currentTab); 
 
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += "invalid";
      // and set the current valid status to false
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}
</script>
	<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script><script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>