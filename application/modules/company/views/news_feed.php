<div class="x_content">
	<div class="tab-content col-md-12">
				<div class="tab-pane active" id="home">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
							<div class="home-category-info-header">
								<h2>News Feed</h2>
								<span class="home-category-info-header-line" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
							</div>
						</div>
						<?php  $loggedInUser =  getNameById('user_detail',$_SESSION['loggedInUser']->u_id,'u_id'); ?>
						<?php /*<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft postfeed">
							<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
								<img src="<?php echo base_url('assets/modules/users/uploads').'/'.$loggedInUser->user_profile ;?>" alt="Company logo" class="img-responsive" style="height:30px; width:100%;">
							</div>
							<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11">
								<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>company/savePost" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
									<div class="item form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<textarea id="chat_message" name="description" class="form-control col-md-12 col-xs-12" placeholder="Type Your Message Here" required></textarea>
										</div>
									</div>
									<div class="item form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<input type="file" class="form-control col-md-7 col-xs-12" name="image" id="image">
											
										</div>
									</div>
									<button type="submit" class="btn btn-primary pull-right">Post</button>
								</form>
							</div>
						</div>	  */?>					
						<?php
						if(!empty($postCommentData)){
							foreach($postCommentData as $postComment){
								$postedByUserData = getNameById('user_detail',$postComment['post']['created_by'],'u_id');
								$userProfileImage = (!empty($postedByUserData) && $postedByUserData->user_profile!='')?$postedByUserData->user_profile:'userp.png';
								$postCommentCount = (!empty($postComment['comments']))?count($postComment['comments']):0;
								
								?>									
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft postfeed">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 brbtm">
								<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1 flex">
									<img src="<?php echo base_url('assets/modules/users/uploads').'/'.$userProfileImage;?>" alt="Company logo" class="img-responsive" style="height:30px; width:100%;">
								</div>
								<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11">
									<p><?php echo $postComment['post']['description']; ?></p> 
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 brbtm pt">
								<img src="<?php echo ($postComment['post']['image']!='')?base_url().'assets/modules/company/uploads/'.$postComment['post']['image']: base_url().'assets/modules/company/uploads/companybg.png';?>" alt="Company post Pic" class="img-responsive" width="100%;">
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 brbtm pt">
								<a data-toggle="collapse" href="#post_comment_<?php echo $postComment['post']['id']; ?>" aria-expanded="false"><i class="fa fa-comments-o"></i>&nbsp;Comments<sup><?php echo $postCommentCount; ?></sup></a> 
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt">
								<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
									<img src="<?php echo base_url('assets/modules/users/uploads').'/'.$loggedInUser->user_profile ;?>" alt="Company logo" class="img-responsive" style="height:30px; width:100%;">
								</div>
								<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11">
									<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>company/saveComment" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
										<input type="hidden" value="<?php if(!empty($loggedInUser)) echo $loggedInUser->u_id; ?>" name="created_by"> 
										<input type="hidden" value="<?php echo $postComment['post']['id']; ?>" name="post_id"> 
										<input type="hidden" value="newsFeed" name="commentFilter"> 
										<div class="item form-group">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<textarea id="chat_message" name="comment" class="form-control col-md-12 col-xs-12" placeholder="Type Your Message Here" required></textarea>
											</div>
										</div>
										<button type="submit" class="btn btn-primary pull-right">Comment</button>
									</form>
								</div>
							</div>
							<?php  if(!empty($postComment['comments'])){ ?>
							<div class="collapse multi-collapse col-xs-12 col-sm-12 col-md-12 col-lg-12 comment-section" id="post_comment_<?php echo $postComment['post']['id']; ?>">
							
							<?php  
								echo '<ul class="list-unstyled msg_list">';
								foreach($postComment['comments'] as $pc ){
									$commentedByUserData = getNameById('user_detail',$pc['created_by'],'u_id');
									$commentedByProfileImage = (!empty($commentedByUserData) && $commentedByUserData->user_profile!='')?$commentedByUserData->user_profile:'userp.png';
								?>			
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
									<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
										<img src="<?php echo base_url('assets/modules/users/uploads').'/'.$commentedByProfileImage;?>" alt="Company logo" class="img-responsive" style="height:30px; width:100%;">
									</div>
									<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11">
										<b><?php echo $commentedByUserData->name ;?></b>&nbsp;<sub><?php echo $pc['created_date'] ;?></sub>
										<p><?php echo $pc['comment']; ?></p>
									</div>
								</div>
								<?php }   ?>
							</div>
							 <?php } ?>
						</div>
						<?php }  } ?>
					</div>
				</div>		
				</div>		
				</div>		