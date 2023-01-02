<! ========================  
   Pricing Page 	 
  ========================	!>
  <section class="header01 cid-ro4BJkHfRs mbr-fullscreen" id="header01-1b">

    

    <div class="mbr-overlay" style="opacity: 0.3;background-color: rgb(35, 35, 35);"></div>

    <div class="container align-left">
        <div class="row">
            <div class="mbr-white col-lg-12 col-md-12">
                <div class="wrapper">
                    <h2 class="mbr-section-title mbr-bold pb-2 mbr-fonts-style display-2">We Provide Flexible Pricing To Our Awesome Clients Across World.</h2>
                    <img src="<?php echo base_url();?>assets/modules/home/uploads/signature.png" alt="Website Simple HTML Example">
                </div>
            </div>
        </div>
    </div>
    
</section>
<div id="generic_price_table">   
<section>

        <div class="container">
            
            <!--BLOCK ROW START-->
            <div class="row">
                <div class="col-md-4">
                
                	<!--PRICE CONTENT START-->
                    <div class="generic_content clearfix">
                        
                        <!--HEAD PRICE DETAIL START-->
                        <div class="generic_head_price clearfix">
                        
                            <!--HEAD CONTENT START-->
                            <div class="generic_head_content clearfix">
                            
                            	<!--HEAD START-->
                                <div class="head_bg"></div>
                                <div class="head">
                                    <span>Basic</span>
                                </div>
                                <!--//HEAD END-->
                                
                            </div>
                            <!--//HEAD CONTENT END-->
                            
                            <!--PRICE START-->
                            <div class="generic_price_tag clearfix">	
                                <span class="price">
                                    <span class="sign"></span>
                                    <span class="currency">Free</span>
                                    <span class="cent"></span>
                                    <span class="month"></span>
                                </span>
                            </div>
                            <!--//PRICE END-->
                            
                        </div>                            
                        <!--//HEAD PRICE DETAIL END-->
                        
                        <!--FEATURE LIST START-->
                        <div class="generic_feature_list">
                        	<ul>
                            	<li><span>3</span> Months free trial</li>
                                <li><span></span> -</li>
                                <li><span></span> -</li>
                                <li><span></span> -</li>
                            </ul>
                        </div>
                        <!--//FEATURE LIST END-->
                        
                        <!--BUTTON START-->
                        <div class="generic_price_btn clearfix">
                        	<a class="" href="">TRY IT</a>
                        </div>
                        <!--//BUTTON END-->
                        
                    </div>
                    <!--//PRICE CONTENT END-->
                        
                </div>
                
                <div class="col-md-4">
                
                	<!--PRICE CONTENT START-->
                    <div class="generic_content active clearfix">
                        
                        <!--HEAD PRICE DETAIL START-->
                        <div class="generic_head_price clearfix">
                        
                            <!--HEAD CONTENT START-->
                            <div class="generic_head_content clearfix">
                            
                            	<!--HEAD START-->
                                <div class="head_bg"></div>
                                <div class="head">
                                    <span>Startup</span>
                                </div>
                                <!--//HEAD END-->
                                
                            </div>
                            <!--//HEAD CONTENT END-->
                            
                            <!--PRICE START-->
                            <div class="generic_price_tag clearfix">	
                                <span class="price">
                                    <span class="sign">Rs</span>
                                    <span class="currency">20,000</span>
                                    <span class="cent"></span>
                                    <span class="month">/YEAR</span>
                                </span>
                            </div>
                            <!--//PRICE END-->
                            
                        </div>                            
                        <!--//HEAD PRICE DETAIL END-->
                        
                        <!--FEATURE LIST START-->
                        <div class="generic_feature_list">
                        	<ul>
                                <li><span></span> Support via Email</li>
                                <li><span></span> Upto 10 users</li>
                                <li><span></span> -</li>
                                <li><span></span> -</li>
                            </ul>
                        </div>
                        <!--//FEATURE LIST END-->
                        
                        <!--BUTTON START-->
                        <div class="generic_price_btn clearfix">
						 <?php if(isset($_SESSION['loggedInUser'])){ ?>
                        	<a class="" href="<?php echo base_url('home/buy/premium_plan/20000'); ?>">Buy Now</a>
							<?php }else{?>
								<a class="" href="<?php echo base_url('auth/#signin'); ?>">Sign In</a>
						<?php 	}?>
                        </div>
                        <!--//BUTTON END-->
                        
                    </div>
                    <!--//PRICE CONTENT END-->
                        
                </div>
                <div class="col-md-4">
                
                	<!--PRICE CONTENT START-->
                    <div class="generic_content clearfix">
                        
                        <!--HEAD PRICE DETAIL START-->
                        <div class="generic_head_price clearfix">
                        
                            <!--HEAD CONTENT START-->
                            <div class="generic_head_content clearfix">
                            
                            	<!--HEAD START-->
                                <div class="head_bg"></div>
                                <div class="head">
                                    <span>Enterprise</span>
                                </div>
                                <!--//HEAD END-->
                                
                            </div>
                            <!--//HEAD CONTENT END-->
                            
                            <!--PRICE START-->
                            <div class="generic_price_tag clearfix">	
                                <span class="price">
                                <span class="sign">Rs</span>
                                    <span class="currency">50,000</span>
                                    <span class="cent"></span>
                                    <span class="month">/YEAR</span>
                                </span>
                            </div>
                            <!--//PRICE END-->
                            
                        </div>                            
                        <!--//HEAD PRICE DETAIL END-->
                        
                        <!--FEATURE LIST START-->
                        <div class="generic_feature_list">
                        	<ul>
                                <li><span></span> Phone Support</li>
                                <li><span></span> Customisation of 50 Hrs</li>
                                <li><span></span>Extended Database</li>
                                <li><span></span> Upto 50 Users</li>
                            </ul>
                        </div>
                        <!--//FEATURE LIST END-->
                        
                        <!--BUTTON START-->
                        <div class="generic_price_btn clearfix">
						 <?php if(isset($_SESSION['loggedInUser'])){ ?>
                        		<a class="" href="<?php echo base_url('home/buy/developer_plan/50000'); ?>">Buy Now</a>
								<?php }else{?>
										<a class="" href="<?php echo base_url('auth/#signin'); ?>">Sign In</a>
								<?php 	}?>
                        </div>
                        <!--//BUTTON END-->
                        
                    </div>
                    <!--//PRICE CONTENT END-->
                        
                </div>
            </div>	
            <!--//BLOCK ROW END-->
            
        </div>
    </section>             

</div>




<?php /*
<div class="col-lg-12">
<!-- List all products -->
<?php if(!empty($products)){ foreach($products as $row){ ?>
   <div class="col-sm-4 col-lg-4 col-md-4">
       <div class="thumbnail">
           <img src="<?php echo base_url('assets/images/'.$row['image']); ?>" />
           <div class="caption">
               <h4 class="pull-right">$<?php echo $row['price']; ?> USD</h4>
               <h4><a href="javascript:void(0);"><?php echo $row['name']; ?></a></h4>
               <p>See more snippets like this online store item at <a href="http://www.codexworld.com">CodexWorld</a>.</p>
           </div>
           <div class="ratings">
               <a href="<?php echo base_url('home/buy/'.$row['id']); ?>">
                   <img src="<?php echo base_url('assets/images/x-click-but01.gif'); ?>" />
               </a>
               <p class="pull-right">15 reviews</p>
               <p>
                   <span class="glyphicon glyphicon-star"></span>
                   <span class="glyphicon glyphicon-star"></span>
                   <span class="glyphicon glyphicon-star"></span>
                   <span class="glyphicon glyphicon-star"></span>
                   <span class="glyphicon glyphicon-star"></span>
               </p>
           </div>
       </div>
   </div>
<?php } }else{ ?>
   <p>Product(s) not found...</p>
<?php } ?>
</div>*/?>