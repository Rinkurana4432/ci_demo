<div class="x_content">
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" class="active"><a href="#tab_content_message_sent" id="message_sent_tab" role="tab" data-toggle="tab" aria-expanded="true">Sent</a>
			</li>
			<li role="presentation" class=""><a href="#tab_content_request_received" role="tab" id="request_received_tab" data-toggle="tab" aria-expanded="false">Inbox</a>
			</li>
			<li role="presentation" class=""><a href="#tab_content_company_connected" role="tab" id="company_connected_tab" data-toggle="tab" aria-expanded="false">Connected Company</a>
			</li>                       
		</ul>
		<div id="myTabContent" class="tab-content">
			<div role="tabpanel" class="tab-pane fade active in" id="tab_content_message_sent" aria-labelledby="message_sent_tab">
			 <?php if(!empty($messages_sent)){
			 echo '<ul class="list-unstyled msg_list">';
					foreach($messages_sent as $ms){		
						$messageSentUser =  getNameById('company_detail',$ms['created_by'],'id'); 
						if(!empty($messageSentUser)){
						?>							
							<li>
							  <a>
								<span class="image">
								  <img src="<?php echo base_url('assets/modules/company/uploads').'/'.(isset($messageSentUser->logo) && $messageSentUser->logo != '' ?$messageSentUser->logo:"company-logo.jpg");?>" alt="img">
								</span>
								<span>
									<span><?php echo $messageSentUser->name; ?></span>
									<span class="time"><?php 
									/*	if($ms['status'] == 1){
											echo '<button type="submit" class="btn btn-warning pull-right">Connected</i></button>';	
										}else{
											echo '<button type="submit" class="btn btn-warning pull-right">Request Sent</i></button>';	
										} */
									?>
									</span>
								</span>
								<span class="message"><?php echo $messageSentUser->description; ?></span>
							  </a>
							</li>
						<?php
						}
					}
					echo '</ul>';
			 } ?>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="tab_content_request_received" aria-labelledby="request_received_tab">
				  <?php /* if(!empty($messages_received)){
				 echo '<ul class="list-unstyled msg_list">';
						foreach($messages_received as $mr){		
							$requestReceivedUser =  getNameById('company_detail',$mr['requested_by'],'id'); 
							if(!empty($requestReceivedUser)){
							?>							
								<li>
								  <a>
									<span class="image">
									  <img src="<?php echo base_url('assets/modules/company/uploads').'/'.(isset($requestReceivedUser->logo) && $requestReceivedUser->logo != '' ?$requestReceivedUser->logo:"company-logo.jpg");?>" alt="img">
									</span>
									<span>
										<span><?php echo $requestReceivedUser->name; ?></span>
										<span class="time">
										
										
										
										</span>
									</span>
									<span class="message"><?php echo $requestReceivedUser->description; ?></span>
								  </a>
								</li>
							<?php
							}
						}
						echo '</ul>';
				 } */ ?>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="tab_content_company_connected" aria-labelledby="company_connected_tab">
				  <?php /* if(!empty($connection_request_received)){
				 echo '<ul class="list-unstyled msg_list">';
						foreach($connection_request_received as $crr){		
							$requestReceivedUser =  getNameById('company_detail',$crr['requested_by'],'id'); 
							if(!empty($requestReceivedUser)){
							?>							
								<li>
								  <a>
									<span class="image">
									  <img src="<?php echo base_url('assets/modules/company/uploads').'/'.(isset($requestReceivedUser->logo) && $requestReceivedUser->logo != '' ?$requestReceivedUser->logo:"company-logo.jpg");?>" alt="img">
									</span>
									<span>
										<span><?php echo $requestReceivedUser->name; ?></span>
										<span class="time"><?php 
											if($crr['status'] == 1){
												echo '<button type="submit" class="btn btn-warning pull-right">Connected</i></button>';	
											}else{
												echo '<button type="button" class="btn btn-warning pull-right acceptConnection" data-code="'.$crr['connection_activation_code'].'">New Request </i></button>';	
											}
										?>
										</span>
									</span>
									<span class="message"><?php echo $requestReceivedUser->description; ?></span>
								  </a>
								</li>
							<?php
							}
						}
						echo '</ul>';
				 } */?>
			</div>
		</div>
	</div>
</div>
