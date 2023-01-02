<?php // pre($materials) ; ?>
		<div class="searchpageback">
			<div class="container">
			<?php if(isset($company) && !empty($company)){?>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft flex">
						<div class="home-category-info-header">
							<h2>Your Searched Result For Company</h2>
							<span class="home-category-info-header-line" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
						<?php foreach($company as $comp){  ?>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 animated wow fadeInLeft">
								<div class="home-list-pop">
									<!--POPULAR LISTINGS IMAGE
									<div class="col-md-3"> <img src="<?php/* echo base_url(); */?>assets/modules/home/uploads/companylogo.jpeg" alt=""> </div>-->
									<!--POPULAR LISTINGS: CONTENT-->
									<div class="pg-revi-re">
									<div class=" col-md-12">
										<img src="<?php echo base_url('assets/modules/company/uploads').'/'.(isset($comp['logo']) && $comp['logo'] != '' ?$comp['logo']:"company-logo.jpg");?>" alt="">
										</div>
										<div class="col-md-12 home-list-pop-desc"> 
											<a href="<?php echo base_url(); ?>company/view_profile/<?php echo $comp['id']; ?>"><h3><?php echo $comp['name']; ?></h3></a>
										</div>
									</div>
									<div class="pg-revi-re">
										<p>
											260 Products <span>252 Reviews , 909 Connections</span>
										</p>
										<div class="list-rat-ch list-room-rati pg-re-rat">
											<i class="fa fa-star" aria-hidden="true"></i> 
											<i class="fa fa-star" aria-hidden="true"></i> 
											<i class="fa fa-star" aria-hidden="true"></i> 
											<i class="fa fa-star" aria-hidden="true"></i> 
											<i class="fa fa-star-o" aria-hidden="true"></i>
										</div>
										
									</div>
									<p class="desc"><?php echo $comp['description']; ?></p>
									<span class="home-list-pop-rat">4.2</span>
									<div class="hom-list-share">
										
											<?php /*<li><a href="<?php echo base_url(); ?>company/non_connected_message"><i class="fa fa-arrows-alt" aria-hidden="true"></i> Connect</a></li>
											<li><a href="<?php echo base_url(); ?>company/message"><i class="fa fa-comments" aria-hidden="true"></i> Message</a></li>*/?>
											<a href="<?php echo base_url(); ?>company/view_profile/<?php echo $comp['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
										
									</div>
								</div>
							</div>
							<?php } ?>	
						</div>
					</div>
				</div> 
				<?php } ?>
				
				<div class="row">
				<?php if(isset($materials) &&  !empty($materials)) { ?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft flex">
						<div class="home-category-info-header">
							<h2>Your Searched Result For Products</h2>
							<span class="home-category-info-header-line" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						
							<!-- product -->						
							<?php 
										foreach($materials as $material){ ?>
							<div class="product-searchpage col-xs-12 col-sm-6 col-md-4 col-lg-3">
								<div class="product-img-searchpage">
									<img src="<?php echo base_url(); ?>assets/modules/inventory/uploads/<?php echo $material['featured_image']?$material['featured_image']:'product.png';  ?>" class="img-responsive" alt="">
									<div class="product-label-searchpage">
										<?php /*<span class="sale-searchpage">-30%</span>
										<span class="new-searchpage">New</span>*/?>
									</div>
								</div>
								<div class="product-body-searchpage">
									<h3 class="product-name-searchpage"><a href="<?php  echo base_url(); ?>home/product_detail?category=<?php echo $_GET['category'];  ?>&name=<?php echo $_GET['name']; ?>&material_id=<?php echo $material['id'];  ?>&company_id=<?php echo $material['created_by_cid'];  ?>"><?php echo $material['material_name'];  ?></a></h3>
									<div class="product-rating-searchpage">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
									</div>													
									<p class="product-category-searchpage">By:<a href="<?php  echo base_url(); ?>home/contactSupplier?category=<?php echo $_GET['category'];  ?>&name=<?php echo $_GET['name']; ?>&material_id=<?php echo $material['id'];  ?>&company_id=<?php echo $material['created_by_cid'];  ?>"><?php echo getNameById('company_detail',$material['created_by_cid'],'id')->name;  ?></a></p>
								</div>
								<div class="product-tags-searchpage">
									<p>
										<a href="#">Cotton Fabric &nbsp;</a>
										<a href="#">Travel Handy &nbsp;</a>
										<a href="#">Complete Kit &nbsp;</a>
									</p>
									<h4 class="product-price-searchpage"> <i class="fa fa-inr"></i> <?php echo $material['sales_price'];  ?><font class="product-min-order-searchpage"> Min. order of <?php echo $material['min_order']; ?> pieces.</font></h4>
								</div>													
								<div class="product-body-searchpage">
									<div class="product-btns-searchpage">
										<?php /*<a href="<?php  echo base_url(); ?>home/product_detail?material_id=<?php echo $material['id'];  ?>&company_id=<?php echo $material['created_by_cid'];  ?>"><button><i class="fa fa-eye"></i><span class="tooltipp-searchpage">quick view</span></button></a> */?> 
										<?php /*<a href="<?php  echo base_url(); ?>home/product_detail?category=<?php echo $_GET['category'];  ?>&name=<?php echo $_GET['name']; ?>&material_id=<?php echo $material['id'];  ?>&company_id=<?php echo $material['created_by_cid'];  ?>"><button><i class="fa fa-eye"></i><span class="tooltipp-searchpage">quick view</span></button></a>
										<?php /*<button><i class="fa fa-exchange"></i><span class="tooltipp-searchpage">add to compare</span></button>*/?>
										<?php /* <a href="<?php  echo base_url(); ?>home/contactSupplier?material_id=<?php echo $material['id'];  ?>&company_id=<?php echo $material['created_by_cid'];  ?>"><button><i class="fa fa-phone"></i><span class="tooltipp-searchpage">contact supplier</span></button></a> */?>
										<?php /*<a href="<?php  echo base_url(); ?>home/contactSupplier?category=<?php echo $_GET['category'];  ?>&name=<?php echo $_GET['name']; ?>&material_id=<?php echo $material['id'];  ?>&company_id=<?php echo $material['created_by_cid'];  ?>"><button><i class="fa fa-phone"></i><span class="tooltipp-searchpage">contact supplier</span></button></a>
										<?php /*<button><i class="fa fa-heart-o"></i><span class="tooltipp-searchpage">add to wishlist</span></button> */?>
										
										
										<button onclick="location.href='<?php  echo base_url(); ?>home/product_detail?category=<?php echo $_GET['category'];  ?>&name=<?php echo $_GET['name']; ?>&material_id=<?php echo $material['id'];  ?>&company_id=<?php echo $material['created_by_cid'];  ?>';" data-toggle="tooltip" data-placement="top" data-custom-class="tooltip" title="Quick View"><i class="fa fa-eye"></i></button>
														
										<button onclick="location.href='<?php  echo base_url(); ?>home/contactSupplier?category=<?php echo $_GET['category'];  ?>&name=<?php echo $_GET['name']; ?>&material_id=<?php echo $material['id'];  ?>&company_id=<?php echo $material['created_by_cid'];  ?>';" data-toggle="tooltip" data-placement="top" data-custom-class="tooltip" title="Contact Supplier"><i class="fa fa-phone"></i></button>
									</div>
								</div>
								<!-- <div class="add-to-cart">
									<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
								</div> -->
							</div>
							
							<?php	}
							//} ?>						
							<!-- /product -->					
						
					</div>
					<?php } ?>	
				</div>
			</div>
		</div>