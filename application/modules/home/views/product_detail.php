<?php /*<div class="centerwhite">
<div class="back">
	<div class="container">
		<div class="centerwhite">
			<div class="row">

							<input type="hidden" name="id" value="<?php if(!empty($materials)) echo $materials->id; ?>">		
                    <div class="col-md-7 col-sm-7 col-xs-12">
                      <div class="product-image">
					 
							<?php if(!empty($material)){
								?>
                        <!--<img src="<?php //echo base_url().'assets/modules/inventory/uploads/'.$imageUploads[0]['file_name'] ; ?>" alt="..." />-->
                       <img src="<?php echo base_url().'assets/modules/inventory/uploads/'.$material->featured_image ; ?>" alt="..." />
							<?php }?>
                      </div><br>
                      <div class="product_gallery">
                        <?php if(!empty($imageUploads)){
								
								foreach($imageUploads as $Uploads){	
								echo '<div class="col-md-55">						   										  
										<div class="image view view-first">											
											<img style="width: 100%; display: block;" src="'.base_url().'assets/modules/inventory/uploads/'.$Uploads['file_name'].'" alt="image"/>									
										</div>								
								</div>';																	
								} } ?>	
													
                      </div>
                    </div>

                    <div class="col-md-5 col-sm-5 col-xs-12" style="border:0px solid #e5e5e5;">
						
							<h2 class="prod_title"><?php if(!empty($material)) echo $material->material_name; ?>&nbsp; &nbsp;<small><?php if(!empty($material)) echo $material->material_code; ?></small></h2>
							<h4><?php if(!empty($material)) echo $material->sale_purchase; ?></h4>
							<p><?php if(!empty($material)) echo $material->specification; ?></p>
                      <br />

                      <div class="">
                        <h2>HSN code</h2>
						 <p><?php if(!empty($material)) echo $material->hsn_code; ?>
						 </p>
                        
                      </div>
                      <br />

                      <div class="">
					  <?php 										
							if(!empty($material) && $material->material_type_id !=''){						
								$mat = getNameById('material_type',$material->material_type_id,'id')->name;			
								echo '<h2>Type:'. $mat.'</h2>';
							}												
							?>
                            
                      </div>
                      <br />
                      <div class="">
                        <div class="product_price">
                          <h3>Cost price:<span class="price-tax"><?php if(!empty($material)) echo $material->cost_price; ?></span></h3>
                          
						  <h3>Sales price:<span class="price-tax"><?php if(!empty($material)) echo $material->sales_price; ?></span></h3>
                           <h5 style="color:green;">Tax:<span class="price-tax"><?php if(!empty($material)) echo $material->tax; ?>%</span></h5>
                          <br>
                        </div>
                      </div>

                      
					  

                      <div class="product_social">
                        <ul class="list-inline">
                          <li><a href="<?php if(!empty($material)) echo $material->facebook; ?>"><i class="fa fa-facebook-square"></i></a>
                          </li>
                          <li><a href="<?php if(!empty($material)) echo $material->twitter; ?>"><i class="fa fa-twitter-square"></i></a>
                          </li>
                          <li><a href="<?php if(!empty($material)) echo $material->instagram; ?>"><i class="fa fa-envelope-square"></i></a>
                          </li>
                          <li><a href="<?php if(!empty($material)) echo $material->linkedin; ?>"><i class="fa fa-rss-square"></i></a>
                          </li>
                        </ul>
                      </div>

                    </div>
					
					
					<a href="<?php echo base_url(); ?>home/contactSupplier?material_id=<?php echo $material->id;  ?>&company_id=<?php echo $material->created_by_cid;  ?>"><button type="buttton" class="btn btn-info materials">Contact Supplier</button></a>
					
					
				<div class="x_content">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Company Detail</a>
							</li>
						</ul>
						<div id="myTabContent" class="tab-content">
							<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
												  
					  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 about-phone" id="about-detail1">
				<div class="x_panel">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
						<table class="table table-bordered">
							<!-- <thead>
								<tr>
									<th>Row</th>
									<th>Bill</th>
								</tr>
							</thead> -->
							<tbody>
								<tr class="active">
									<th colspan="2"><h2>Information</h2></th>
								</tr>
								<tr>
									<th>GSTIN</th>
									<th><?php if(!empty($company)) echo $company->gstin; ?></th>
								</tr>
								<tr>
									<th>PAN</th>
									<th><?php if(!empty($company)) echo $company->company_pan; ?></th>
								</tr>
								<tr>
									<th>Company Type</th>
									<th><?php if(!empty($company)) echo $company->company_type; ?></th>
								</tr>
								<tr class="active">
									<th colspan="2"><h2>About</h2></th>
								</tr>
								<tr>
									<th>Year Of Establishment</th>
									<th><?php if(!empty($company)) echo $company->year_of_establish; ?></th>
								</tr>
								<tr>
									<th>Employees</th>
									<th><?php if(!empty($company)) echo $company->no_of_employees; ?></th>
								</tr>
								<tr>
									<th>Key People</th>
									<th>
												<?php 
												if(!empty($company)) {
														$keyPeoples = json_decode($company->key_people);
														foreach($keyPeoples as $keyPeople){
															if($keyPeople != ''){
																echo $keyPeople. '<br>'; 
															}
														}
													} ?>
									</th>
								</tr>
								<tr>
									<th>Revenue</th>
									<th><?php if(!empty($company)) echo $company->revenue; ?></th>
								</tr>
								<tr>
									<th>Description</th>
									<th><?php if(!empty($company)) echo $company->description; ?></th>
								</tr>
								<tr class="active">
									<th colspan="2"><h2>Address</h2></th>
								</tr>
								<tr>
									<th colspan="2"> 
										<ul>
											<?php 
												if(!empty($company)) {
														$addresses = json_decode($company->address);
														foreach($addresses as $compAddress){	
															$city = getNameById('city',$compAddress->city,'city_id');
															$cityName = (!empty($city))?$city->city_name:'';
															$state = getNameById('state',$compAddress->state,'state_id');
															$stateName = (!empty($state))?$state->state_name:'';
															$country = getNameById('country',$compAddress->country,'country_id');
															$countryName = (!empty($country))?$country->country_name:'';
															if($compAddress != ''){
																echo '<li>'.$compAddress->address.' , '.$cityName.' , '.$stateName.' , '.$countryName.' , '.$compAddress->postal_zipcode.'</li>'; 
															}
														}
													} ?>
										
											
										</ul>
									</th>
								</tr>
								
								
								
								
								<tr class="active">
									<th colspan="2"><h2>Certifications</h2></th>
								</tr>
								<tr>
									<th colspan="2">
										<?php if(!empty($companyCertificate)){?>
											<div class="item form-group">
												<div class="col-md-12">
													<?php foreach($companyCertificate as $compCer){
														echo '<div class="col-md-2 img-outline">
														<img style="height:50px;" src="'.base_url(). 'assets/modules/company/uploads/'.$compCer[ 'file_name']. '" alt="image" class="img-responsive"/>
														</div>';
													} ?>
												</div>
											</div>
										<?php } ?>	
									</th>
								</tr>
								
								<div class="x_panel">
					<div class="x_title">
						<h2>Contact Us</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<ul class="list-unstyled user_data">
							<?php if(!empty($company)){
								$addresses = json_decode($company->address);								
							
							if($company->phone != ''){ 
								echo '<li><i class="fa fa-phone user-profile-icon"></i>&nbsp; '.$company->phone.'</li>';
							}
							
								$companyUser  = getNameById('user',$company->u_id,'id');
								echo '<li><i class="fa fa-envelope user-profile-icon"></i>&nbsp; '.$companyUser->email.'</li>';
							
							 if($company->website != ''){ 
								echo '<li class="m-top-xs"><i class="fa fa-external-link user-profile-icon"></i><a href="'.$company->website.'" target="_blank">&nbsp; '.$company->website.'</a></li>';
							}
							 } ?>
						</ul>
					</div>
				</div>
			</div>
							</tbody>
						</table>
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
                </div> */?>
		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<ul class="breadcrumb-tree">
							<li><a href="#">Home</a></li>
							<li><a href="#">Product</a></li>
							<li><a href="#"><?php echo $material->material_name; ?></a></li>
							
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->
		
		
		<div class="back">
			<div class="container">
				<div class="row">
					<!-- Product main img -->
					<div class="col-md-5 col-md-push-2">
						<div id="product-main-img">
						
						<?php 
							//echo '<div class="product-preview"><img src="'.base_url().'assets/modules/inventory/uploads/dummyImg.png" alt=""></div>';
						
						
						
						if(!empty($imageUploads)){
							//pre($imageUploads);
								foreach($imageUploads as $Uploads){	
								    if($Uploads['featured_image'] != ''){
										echo '<div class="product-preview"><img src="'.base_url().'assets/modules/inventory/uploads/'.$Uploads['featured_image'].'" alt=""></div>';
									}else{
										echo '<div class="product-preview"><img src="'.base_url().'assets/modules/inventory/uploads/dummyImg.png" alt=""></div>';
									}
								}
							}
												

							/*?>

							<div class="product-preview">
								<img src="<?php echo base_url(); ?>assets/modules/home/uploads/product03.png" alt="">
							</div>

							<div class="product-preview">
								<img src="<?php echo base_url(); ?>assets/modules/home/uploads/product06.png" alt="">
							</div>

							<div class="product-preview">
								<img src="<?php echo base_url(); ?>assets/modules/home/uploads/product08.png" alt="">
							</div> */?>
						</div>
					</div>
					<!-- /Product main img -->

					<!-- Product thumb imgs -->
					<div class="col-md-2  col-md-pull-5">
						<div id="product-imgs">
						<?php if(!empty($imageUploads)){
							
								foreach($imageUploads as $Uploads){	
									if($Uploads['featured_image'] != ''){
										echo '<div class="product-preview"><img src="'.base_url().'assets/modules/inventory/uploads/'.$Uploads['featured_image'].'" alt=""></div>';
									}else{
										echo '<div class="product-preview"><img src="'.base_url().'assets/modules/inventory/uploads/dummyImg.png" alt=""></div>';
									}
								}
							} ?>
							<!--<div class="product-preview">
								<img src="<?php //echo base_url(); ?>assets/modules/home/uploads/product01.png" alt="">
							</div>

							<div class="product-preview">
								<img src="<?php //echo base_url(); ?>assets/modules/home/uploads/product03.png" alt="">
							</div>

							<div class="product-preview">
								<img src="<?php //echo base_url(); ?>assets/modules/home/uploads/product06.png" alt="">
							</div>

							<div class="product-preview">
								<img src="<?php //echo base_url(); ?>assets/modules/home/uploads/product08.png" alt="">
							</div> -->
						</div>
					</div>
					<!-- /Product thumb imgs -->

					<!-- Product details -->
					<div class="col-md-5">
						<div class="product-details">
							<h2 class="product-name"><?php echo $material->material_name; ?></h2>
							<h5><?php echo $material->material_code; ?></h5>
							<div>
								
									<?php if(!empty($countRating)){
											foreach($countRating as $Average){
												$avgcount = $Average['average'];
												//pre(is_float($avgcount));
												?>
										<div class="product-rating">
											<?php for($i = 1; $i<=$avgcount; $i++){
													echo '<i class="fa fa-star"></i>';
													}
												if(strpos($avgcount,'.')){
													echo '<i class="fa fa-star-half-empty"></i>';
													$i++;
												}
												while($i<=5) {
													echo '<i class="fa fa-star-o empty"></i>';$i++;
												}	
											?>
										</div>
									<?php }}?>
									<!--<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-o"></i>-->
								<?php if(!empty($countReviews)){
									 foreach($countReviews as $TotalReview){
										
								?>
								<a class="review-link" href="#reviews"><?php echo $TotalReview['Review']; ?> Review(s) | Add your review</a>
									 <?php }}?>
							</div>
							<div>
								<h3 class="product-price"> <i class="fa fa-inr"></i> <?php echo $material->sales_price; ?> <del class="product-old-price"><i class="fa fa-inr"></i>990.00</del>&nbsp;<span class="badge badge-warning">Tax:&nbsp; <?php echo $material->tax; ?>%</span></h3>
							</div>
							<?php /*<div>
								<span class="product-available">In Stock</span> |    <span class="badge badge-active">Purchase</span>
							</div>*/?>
							<p>
								<h4> Type: 	<?php if(!empty($material)){
									$salePurchaseTag = json_decode($material->sale_purchase);
									$DisplayType = implode(',',$salePurchaseTag);
									echo $DisplayType;
								}?>  </h4>
								<h3> HSN Code: <?php echo $material->hsn_code; ?> </h3>
							</p>
							<p><?php echo $material->specification; ?></p>
							
							<!-- <div class="add-to-cart">
								<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
							</div> -->
							<div class="add-to-cart">
								<a href="<?php echo base_url(); ?>home/contactSupplier?category=<?php if((isset($_GET) && !empty($_GET)) && (isset($_GET['category']) && $_GET['category']!= '')) echo $_GET['category'];  ?>&name=<?php if((isset($_GET) && !empty($_GET)) && (isset($_GET['name']) && $_GET['name']!= '')) echo $_GET['name']; ?>&material_id=<?php echo $material->id;  ?>&company_id=<?php echo $material->created_by_cid;  ?>"><button class="add-to-cart-btn"><i class="fa fa-phone"></i> Contact Supplier</button></a>
							</div>

							<?php /*<div class="product-options">
								<label>
									Size
									<select class="input-select">
										<option value="0">X</option>
									</select>
								</label>
								<label>
									Color
									<select class="input-select">
										<option value="0">Red</option>
									</select>
								</label>
							</div>

							<div class="add-to-cart">
								<div class="qty-label">
									Qty
									<div class="input-number">
										<input type="number">
										<span class="qty-up">+</span>
										<span class="qty-down">-</span>
									</div>
								</div>
								<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
							</div> */?>

							<ul class="product-btns">
								<?php /*<li><a href="#"><i class="fa fa-heart-o"></i> add to wishlist</a></li>
								<li><a href="#"><i class="fa fa-exchange"></i> add to compare</a></li> */?>
							</ul>

							<ul class="product-links">
								<li>Category:</li>
								<?php echo get_tags_html($material->id,'material'); ?>
							</ul>

							<ul class="product-links">
								<li>Share:</li> 
								<?php if(!empty($material)){
										if($material->facebook != ''){ echo '<li><a href="'.$material->facebook.'"><i class="fa fa-facebook"></i></a></li>'; }
										if($material->twitter != ''){ echo '<li><a href="'.$material->twitter.'"><i class="fa fa-twitter"></i></a></li>'; }
										if($material->instagram != ''){ echo '<li><a href="'.$material->instagram.'"><i class="fa fa-google-plus"></i></a></li>'; }
										if($material->linkedin != ''){ echo '<li><a href="'.$material->linkedin.'"><i class="fa fa-envelope"></i></a></li>'; }
								}?>
								
							</ul>

						</div>
					</div>
					<!-- /Product details -->
					
					<div class="col-md-12"> 
						<!-- Nav tabs -->
						<div class="card">							
							<!-- Tab panes -->
							<div class="tab-content abc">
								<ul class="nav nav-tabs" role="tablist" id="myTab">
									<li role="presentation" class="active"><a href="#specification" aria-controls="specification" role="tab" data-toggle="tab"><span>Specification</span></a></li>
									<li role="presentation"><a href="#detail" aria-controls="detail" role="tab" data-toggle="tab">Detail</span></a></li>
									<li role="presentation"><a href="#manufacturerdetail" aria-controls="manufacturerdetail" role="tab" data-toggle="tab"><span>Manufacturer Detail</span></a></li>
									<!--<li role="presentation"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab"><span>Reviews</span></a></li>-->
									<li role="presentation"><a data-toggle="tab" href="#reviews"><span>Reviews</span></a></li>
								</ul>
								<div role="tabpanel" class="tab-pane active" id="specification">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tab-contentp">
										<div class="row">
											<div class="col-md-12">
												<p><?php if(!empty($material)){ echo $material->specification; } ?></p>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="detail">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tab-contentp">
										<div class="row">										
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
												<table class="table table-bordered">
													<tbody>
														<tr>
															<td>Material Code</td>
															<td><?php if(!empty($material)){ echo $material->material_code; } ?></td>
														</tr>
														<tr>
															<td>Material Type</td>
															<td><?php
															if( !empty($material) && $material->material_type_id != '' ){ 															
																$materialType  = getNameById('material_type',$material->material_type_id,'id');
																if(!empty($materialType)){
																	echo $materialType->name; 
																}
															} ?></td>
														</tr>
														<tr>
															<td>Purpose</td>
															<td><?php if(!empty($material)){ echo $material->sale_purchase; } ?></td>
														</tr>
														<tr>
															<td>Material Name</td>
															<td><?php if(!empty($material)){ echo $material->material_name; } ?></td>
														</tr>
														<tr>
															<td>HSN Code</td>
															<td><?php if(!empty($material)){ echo $material->hsn_code; } ?></td>
														</tr>
														<?php /*<tr>
															<td>Opening Balance</td>
															<td><?php if(!empty($material)){ echo $material->opening_balance; } ?></td>
														</tr>*/?>
														<tr>
															<td>Lead Time</td>
															<td><?php if(!empty($material)){ echo $material->lead_time; } ?></td>
														</tr>
														<?php /*<tr>
															<td>Minimum Inventory</td>
															<td>06AAMFN3764A2ZD</td>
														</tr>
														<tr>
															<td>Maximum Inventory</td>
															<td><?php if(!empty($material)){ echo $material->max_inventory; } ?></td>
														</tr>
														<tr>
															<td>Storage Location</td>
															<td>06AAMFN3764A2ZD</td>
														</tr>
														<tr>
															<td>Route</td>
															<td>06AAMFN3764A2ZD</td>
														</tr>	*/?>													
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="manufacturerdetail">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tab-contentp">
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
												<div class="home-category-info-header">
													<h2>About Us</h2>
													<span class="home-category-info-header-line" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
												</div>
											</div>
											<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
												<table class="table table-bordered">
												<?php // pre($company); ?>
													<!-- <thead>
														<tr>
															<th>Row</th>
															<th>Bill</th>
														</tr>
													</thead> -->
													<tbody>
														<tr class="active">
															<th colspan="2"><h4>Information</h4></th>
														</tr>
														<tr>
															<td>GSTIN</td>
															<td><?php if(!empty($company) && $company->gstin !='' ){ echo $company->gstin;  } ?></td>
														</tr>
														<tr>
															<td>PAN</td>
															<td><?php if(!empty($company) && $company->gstin !='' ){ echo $company->company_pan;  } ?></td>
														</tr>
														<tr>
															<td>Company Type</td>
															<td><?php if(!empty($company) && $company->gstin !='' ){ echo $company->company_type;  } ?></td>
														</tr>
														<tr class="active">
															<th colspan="2"><h4>About</h4></th>
														</tr>
														<tr>
															<td>Year Of Establishment</td>
															<td><?php if(!empty($company) && $company->gstin !='' ){ echo $company->year_of_establish;  } ?></td>
														</tr>
														<tr>
															<td>Employees</td>
															<td><?php if(!empty($company) && $company->gstin !='' ){ echo $company->no_of_employees;  } ?></td>
														</tr>
														<tr>
															<td>Key People</td>
															<td>
															<?php 
																if(!empty($company) && $company->key_people != '') {
																	$keyPeoples = json_decode($company->key_people);
																	if(!empty($keyPeoples)){
																		foreach($keyPeoples as $keyPeople){
																			if($keyPeople != ''){
																				echo $keyPeople. '<br>'; 
																			}
																		}
																	}
																} ?>
														</tr>
														<tr>
															<td>Revenue</td>
															<td><?php if(!empty($company) && $company->gstin !='' ){ echo $company->revenue;  } ?></td>
														</tr>
														<tr class="active">
															<th colspan="2"><h4>Address</h4></th>
														</tr>
														<tr>
															<td colspan="2"> 
																<ul>																
																	<?php if(!empty($company) && $company->address != ''){
																		$addresses = json_decode($company->address);
																		foreach($addresses as $compAddress){	
																			$city = getNameById('city',$compAddress->city,'city_id');
																			$cityName = (!empty($city))?$city->city_name:'';
																			$state = getNameById('state',$compAddress->state,'state_id');
																			$stateName = (!empty($state))?$state->state_name:'';
																			$country = getNameById('country',$compAddress->country,'country_id');
																			$countryName = (!empty($country))?$country->country_name:'';
																			if($compAddress != ''){
																				echo '<li>'.$compAddress->address.' , '.$cityName.' , '.$stateName.' , '.$countryName.' , '.$compAddress->postal_zipcode.'</li>'; 
																			}
																		}
																	} ?>
																</ul>
															</td>
														</tr>
														
														
														
														<tr class="active">
															<th colspan="2"><h4>Bank Account Information</h4></th>
														</tr>
														<tr>
															<td>Account Name</td>
															<td><?php if(!empty($company) && $company->gstin !='' ){ echo $company->account_name;  } ?></td>
														</tr>
														<tr>
															<td>Account Number</td>
															<td><?php if(!empty($company) && $company->gstin !='' ){ echo $company->account_no;  } ?></td>
														</tr>
														<tr>
															<td>IFSC Code</td>
															<td><?php if(!empty($company) && $company->gstin !='' ){ echo $company->account_ifsc_code;  } ?></td>
														</tr>
														<tr>
															<td>Bank</td>
															<td> <?php if(!empty($company) && $company->gstin !='' ){ echo $company->bank_name;  } ?></td>
														</tr>
														<tr>
															<td>Branch</td>
															<td><?php if(!empty($company) && $company->gstin !='' ){ echo $company->branch;  } ?></td>
														</tr>
														
														<tr class="active">
															<th colspan="2"><h4>Certifications</h4></th>
														</tr>
														<tr>
															<th colspan="2">
																<?php if(!empty($companyCertificate)){?>
																	<div class="item form-group">
																		<div class="col-md-12">
																			<?php foreach($companyCertificate as $compCer){
																				$companyCertificateName  = $compCer[ 'file_name'] != ''?$compCer[ 'file_name']:'';
																				echo '<div class="col-md-2 img-outline">
																				<img style="height:50px;" src="'.base_url(). 'assets/modules/company/uploads/'.$companyCertificateName. '" alt="image" class="img-responsive"/>
																				</div>';
																			} ?>
																		</div>
																	</div>
																<?php } else{ echo '<h4>No Certifications</h4>'; } ?>
															</th>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 animated wow fadeInLeft">
												<div class="home-category-info-header">
													<h2>Our Products</h2>
													<span class="home-category-info-header-line" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
												</div>
											</div>
											<div class="col-md-12 col-sm-12 col-xs-12">	
												<div class="about-ourproSlider slider sliderm">
													<!-- product -->					
													<?php if(isset($companyProducts) &&  !empty($companyProducts)) {
																foreach($companyProducts as $product){ ?>
																	<div class="product-searchpage col-xs-6 col-sm-6 col-md-4 col-lg-3">
																		<div class="product-img-searchpage">
																			<img src="<?php echo base_url(); ?>assets/modules/inventory/uploads/<?php echo $product['featured_image']?$product['featured_image']:'product.png';  ?>" class="img-responsive" alt="">
																			<div class="product-label-searchpage">
																				<?php /*<span class="sale-searchpage">-30%</span>
																				<span class="new-searchpage">New</span>*/?>
																			</div>
																		</div>
																		<div class="product-body-searchpage">
																			<h3 class="product-name-searchpage"><a href="#"><?php echo $product['material_name'];  ?></a></h3>
																			<div class="product-rating-searchpage">
																				<i class="fa fa-star"></i>
																				<i class="fa fa-star"></i>
																				<i class="fa fa-star"></i>
																				<i class="fa fa-star"></i>
																				<i class="fa fa-star"></i>
																			</div>													
																			<p class="product-category-searchpage">By:<a href="#"><?php echo getNameById('company_detail',$product['created_by_cid'],'id')->name;  ?></a></p>
																		</div>
																		<div class="product-tags-searchpage">
																			<p>
																				<a href="#">Cotton Fabric &nbsp;</a>
																				<a href="#">Travel Handy &nbsp;</a>
																				<a href="#">Complete Kit &nbsp;</a>
																			</p>
																			<h4 class="product-price-searchpage"> <i class="fa fa-inr"></i> <?php echo $product['sales_price'];  ?><font class="product-min-order-searchpage">Min. order of <?php echo $product['min_order']; ?> pieces.</font></h4>
																		</div>													
																		<div class="product-body-searchpage">
																			<div class="product-btns-searchpage">
																			
																			
																			
																				<?php /*<a href="<?php  echo base_url(); ?>home/product_detail?category=<?php if((isset($_GET) && !empty($_GET)) && (isset($_GET['category']) && $_GET['category']!= '')) echo $_GET['category'];  ?>&name=<?php if((isset($_GET) && !empty($_GET)) && (isset($_GET['name']) && $_GET['name']!= '')) echo $_GET['name']; ?>&material_id=<?php echo $product['id'];  ?>&company_id=<?php echo $product['created_by_cid'];  ?>"><button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button></a>
																				<a href="<?php echo base_url(); ?>home/contactSupplier?category=<?php if((isset($_GET) && !empty($_GET)) && (isset($_GET['category']) && $_GET['category']!= '')) echo $_GET['category'];  ?>&name=<?php if((isset($_GET) && !empty($_GET)) && (isset($_GET['name']) && $_GET['name']!= '')) echo $_GET['name']; ?>&material_id=<?php echo $material->id;  ?>&company_id=<?php echo $material->created_by_cid;  ?>"><button><i class="fa fa-phone"></i><span class="tooltipp-searchpage">contact supplier</span></button></a> */?>
																				<button onclick="location.href='<?php  echo base_url(); ?>home/product_detail?category=<?php if((isset($_GET) && !empty($_GET)) && (isset($_GET['category']) && $_GET['category']!= '')) echo $_GET['category'];  ?>&name=<?php if((isset($_GET) && !empty($_GET)) && (isset($_GET['name']) && $_GET['name']!= '')) echo $_GET['name']; ?>&material_id=<?php echo $product['id'];  ?>&company_id=<?php echo $product['created_by_cid'];  ?>';" data-toggle="tooltip" data-placement="top" data-custom-class="tooltip" title="Quick View"><i class="fa fa-eye"></i></button>
														
																				<button onclick="location.href='<?php echo base_url(); ?>home/contactSupplier?category=<?php if((isset($_GET) && !empty($_GET)) && (isset($_GET['category']) && $_GET['category']!= '')) echo $_GET['category'];  ?>&name=<?php if((isset($_GET) && !empty($_GET)) && (isset($_GET['name']) && $_GET['name']!= '')) echo $_GET['name']; ?>&material_id=<?php echo $material->id;  ?>&company_id=<?php echo $material->created_by_cid;  ?>';" data-toggle="tooltip" data-placement="top" data-custom-class="tooltip" title="Contact Supplier"><i class="fa fa-phone"></i></button>
																				
																			</div>
																		</div>
																		<!-- <div class="add-to-cart">
																			<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
																		</div> -->
																	</div>
													
													<?php	}
													} ?>
													
													
												
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="reviews">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tab-contentp">
										<div class="row">
											<!-- Rating -->
											<div class="col-md-3">
												<div id="rating">
													<div class="rating-avg">
													<?php if(!empty($countRating)){
														foreach($countRating as $Average){
														    $avgcount = $Average['average'];
															?>
														<span><?php echo $avgcount;?></span>
														
														<div class="rating-stars">
															<?php for($i = 1; $i<=$avgcount; $i++){
																	echo '<i class="fa fa-star"></i>';
																	}
																if(strpos($avgcount,'.')){
																	echo '<i class="fa fa-star-half-empty"></i>';
																	$i++;
																}
																while($i<=5) {
																	echo '<i class="fa fa-star-o empty"></i>';$i++;
																}	
															?>
														</div>
													<?php }}?>
													</div>
													<ul class="rating">
													<?php if(!empty($countRating)){
													    foreach($countRating as $ratingStar){
														   $fiveStar = $ratingStar['fivestar'];
														   $fourStar = $ratingStar['fourstar'];
														   $threeStar = $ratingStar['threestar'];
														   $twoStar = $ratingStar['twostar'];
														   $oneStar = $ratingStar['onestar'];
														   ?>
														
														<li>
															<div class="rating-stars">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
															</div>
															<div class="rating-progress">
																<div style="width: 80%;"></div>
															</div>
															<span class="sum"><?php echo $fiveStar; ?></span>
														</li>
														<li>
															<div class="rating-stars">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star-o"></i>
															</div>
															<div class="rating-progress">
																<div style="width: 60%;"></div>
															</div>
															<span class="sum"><?php echo $fourStar; ?></span>
														</li>
														<li>
															<div class="rating-stars">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star-o"></i>
																<i class="fa fa-star-o"></i>
															</div>
															<div class="rating-progress">
																<div></div>
															</div>
															<span class="sum"><?php echo $threeStar; ?></span>
														</li>
														<li>
															<div class="rating-stars">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star-o"></i>
																<i class="fa fa-star-o"></i>
																<i class="fa fa-star-o"></i>
															</div>
															<div class="rating-progress">
																<div></div>
															</div>
															<span class="sum"><?php echo $twoStar; ?></span>
														</li>
														<li>
															<div class="rating-stars">
																<i class="fa fa-star"></i>
																<i class="fa fa-star-o"></i>
																<i class="fa fa-star-o"></i>
																<i class="fa fa-star-o"></i>
																<i class="fa fa-star-o"></i>
															</div>
															<div class="rating-progress">
																<div></div>
															</div>
															<span class="sum"><?php echo $oneStar; ?></span>
														</li>
													<?php }
													}?>
													</ul>
												</div>
											</div>
											<!-- /Rating -->
											
											<!-- Reviews -->
											<!--<div class="col-md-6">  
											<div class="x_content">
												<p class="text-muted font-13 m-b-30"></p>
												<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
													<thead>
													<?php /*
													if(!empty($users_data)){
														foreach($users_data as $usersdata){
															$userName = getNameById('company_detail',$usersdata->created_by_cid,'id');
															$name= $userName->name;
															$rating = $usersdata->rating;
													?>
													<tr class="reviews">
														<th>
														<?php echo $name ."</br></br>".$usersdata->comments."</br></br>".$usersdata->created_date."</br></br>";?>
														</th>
														<div class="review-rating">
														<th>
															
																<?php for($i = 1; $i<=5 ; $i++){
																	if($i<=$rating){
																		echo '<i class="fa fa-star"></i>';
																	}
																else{
																	echo '<i class="fa fa-star-o empty"></i>';
																	}	
																}*/
															?>
															
														</th></div>
													</tr>
													<?php //}} ?>
													</thead>
												</table>												
												</div>
											</div>-->
											
											
											<div class="col-md-6">
												<div id="reviews" >
													<ul id="reviews_content">
														<?php //pre($users_data);
														if(!empty($users_data)){
														//pre($users_data);
															foreach($users_data as $usersdata){
																$userName = getNameById('company_detail',$usersdata->created_by_cid,'id');
																$name= $userName->name;
																$rating = $usersdata->rating;
														?>
														<li>
															<div class="review-heading" >
																<h5 class="name"><?php echo $name;?></h5>
																<p class="date"><?php echo $usersdata->created_date;?></p>
																<div class="review-rating">
																	<?php for($i = 1; $i<=5 ; $i++){
																			if($i<=$rating){
																				echo '<i class="fa fa-star"></i>';
																			}
																		else{
																			echo '<i class="fa fa-star-o empty"></i>';
																			}	
																		}
																	?>
																</div>
															</div>
															<div class="review-body">
																<p><?php echo $usersdata->comments;?></p>
															</div>
														</li>
													<?php }} else{
															echo "No reviews";
													}?>
													</ul>
													<ul class="pagination">
													<?php 
														if(isset($links) & !empty($links)){
														 //pre($links);
														 ?>
														<li align="center" rowspan="5" style="padding:0px 0 0 0;"><a href="#reviews"><?php echo $links; ?></a></li>
													<?php } ?>
													</ul>
														
													
												</div>
											</div>
											<!-- /Reviews -->

											<!-- Review Form -->
											<div class="col-md-3">
												<div id="review-form">
												<?php  if(!empty($_SESSION['loggedInUser'])){?>
													<form class="review-form" action="<?php echo base_url(); ?>home/saveReviews"  id="" novalidate="novalidate" method="post">
														<input type="hidden" name="company_id" value="<?php echo $product['created_by_cid'];  ?>">
														<!--<input class="input" type="text" placeholder="Your Name" name="name">
														<input class="input" type="text" placeholder="Your Email" name="email">-->
														<textarea class="input" placeholder="Your Review" name="comments"></textarea>
														<input type="hidden" name="material_id" value="<?php if(!empty($material)){ echo $material->id; } ?>" >
														<div class="input-rating">
															<span>Your Rating: </span>
															<div class="stars">
																<input id="star5" name="rating" value="5" type="radio"><label for="star5"></label>
																<input id="star4" name="rating" value="4" type="radio"><label for="star4"></label>
																<input id="star3" name="rating" value="3" type="radio"><label for="star3"></label>
																<input id="star2" name="rating" value="2" type="radio"><label for="star2"></label>
																<input id="star1" name="rating" value="1" type="radio"><label for="star1"></label>
															</div>
														</div>
														<input type="submit" class="btn btn-primary" value="Submit">
														<?php 
															/*if(empty($_SESSION['loggedInUser'])){
															echo '<input type="submit" class="btn btn-primary" value="Submit"  disabled ="disabled">';
															echo '<span style="color:red;font-size:14px;">Please Login first</span>';
															}else {
															 echo '<input type="submit" class="btn btn-primary" value="Submit">';
															}*/?>
													</form>
												<?php }?>
												</div>
											</div>
											<!-- /Review Form -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					
					
					
					
					
					<?php /*<!-- Product tab -->
					<div class="col-md-12">
						<div id="product-tab">
							<!-- product tab nav -->
							<ul class="tab-nav">
								<li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
								<li><a data-toggle="tab" href="#tab2">Details</a></li>
								<li><a data-toggle="tab" href="#tab3">Reviews (3)</a></li>
							</ul>
							<!-- /product tab nav -->

							<!-- product tab content -->
							<div class="tab-content">
								<!-- tab1  -->
								<div id="tab1" class="tab-pane fade in active">
									<div class="row">
										<div class="col-md-12">
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
										</div>
									</div>
								</div>
								<!-- /tab1  -->

								<!-- tab2  -->
								<div id="tab2" class="tab-pane fade in">
									<div class="row">
										<div class="col-md-12">
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
										</div>
									</div>
								</div>
								<!-- /tab2  -->

								<!-- tab3  -->
								<div id="tab3" class="tab-pane fade in">
									<div class="row">
										<!-- Rating -->
										<div class="col-md-3">
											<div id="rating">
												<div class="rating-avg">
													<span>4.5</span>
													<div class="rating-stars">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
													</div>
												</div>
												<ul class="rating">
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
														</div>
														<div class="rating-progress">
															<div style="width: 80%;"></div>
														</div>
														<span class="sum">3</span>
													</li>
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
														</div>
														<div class="rating-progress">
															<div style="width: 60%;"></div>
														</div>
														<span class="sum">2</span>
													</li>
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														</div>
														<div class="rating-progress">
															<div></div>
														</div>
														<span class="sum">0</span>
													</li>
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														</div>
														<div class="rating-progress">
															<div></div>
														</div>
														<span class="sum">0</span>
													</li>
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														</div>
														<div class="rating-progress">
															<div></div>
														</div>
														<span class="sum">0</span>
													</li>
												</ul>
											</div>
										</div>
										<!-- /Rating -->

										<!-- Reviews -->
										<div class="col-md-6">
											<div id="reviews">
												<ul class="reviews">
													<li>
														<div class="review-heading">
															<h5 class="name">John</h5>
															<p class="date">27 DEC 2018, 8:0 PM</p>
															<div class="review-rating">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star-o empty"></i>
															</div>
														</div>
														<div class="review-body">
															<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
														</div>
													</li>
													<li>
														<div class="review-heading">
															<h5 class="name">John</h5>
															<p class="date">27 DEC 2018, 8:0 PM</p>
															<div class="review-rating">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star-o empty"></i>
															</div>
														</div>
														<div class="review-body">
															<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
														</div>
													</li>
													<li>
														<div class="review-heading">
															<h5 class="name">John</h5>
															<p class="date">27 DEC 2018, 8:0 PM</p>
															<div class="review-rating">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star-o empty"></i>
															</div>
														</div>
														<div class="review-body">
															<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
														</div>
													</li>
												</ul>
												<ul class="reviews-pagination">
													<li class="active">1</li>
													<li><a href="#">2</a></li>
													<li><a href="#">3</a></li>
													<li><a href="#">4</a></li>
													<li><a href="#"><i class="fa fa-angle-right"></i></a></li>
												</ul>
											</div>
										</div>
										<!-- /Reviews -->

										<!-- Review Form -->
										<div class="col-md-3">
											<div id="review-form">
												<form class="review-form">
													<input class="input" type="text" placeholder="Your Name">
													<input class="input" type="email" placeholder="Your Email">
													<textarea class="input" placeholder="Your Review"></textarea>
													<div class="input-rating">
														<span>Your Rating: </span>
														<div class="stars">
															<input id="star5" name="rating" value="5" type="radio"><label for="star5"></label>
															<input id="star4" name="rating" value="4" type="radio"><label for="star4"></label>
															<input id="star3" name="rating" value="3" type="radio"><label for="star3"></label>
															<input id="star2" name="rating" value="2" type="radio"><label for="star2"></label>
															<input id="star1" name="rating" value="1" type="radio"><label for="star1"></label>
														</div>
													</div>
													<button class="primary-btn">Submit</button>
												</form>
											</div>
										</div>
										<!-- /Review Form -->
									</div>
								</div>
								<!-- /tab3  -->
							</div>
							<!-- /product tab content  -->
						</div>
					</div>
					<!-- /product tab --> */?>
				</div>
			</div>
		</div>