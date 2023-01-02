<div class="x_content">
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" class="active"><a href="#tab_content_request_sent" id="request_sent_tab" role="tab" data-toggle="tab" aria-expanded="true">Request Sent</a>
			</li>
			<li role="presentation" class=""><a href="#tab_content_request_received" role="tab" id="request_received_tab" data-toggle="tab" aria-expanded="false">Request Received</a>
			</li>
			<li role="presentation" class=""><a href="#tab_content_company_connected" role="tab" id="company_connected_tab" data-toggle="tab" aria-expanded="false">Connected Company</a>
			</li>                       
		</ul>
		<div id="myTabContent" class="tab-content">
			<div role="tabpanel" class="tab-pane fade active in" id="tab_content_request_sent" aria-labelledby="request_sent_tab">
			 <?php if(!empty($connection_request_sent)){
			 echo '<ul class="list-unstyled msg_list">';
					foreach($connection_request_sent as $crs){		
						$requestSentUser =  getNameById('company_detail',$crs['requested_to'],'id'); 
						if(!empty($requestSentUser)){
						?>							
							<li>
							  <a>
								<span class="image">
								  <img src="<?php echo base_url('assets/modules/company/uploads').'/'.(isset($requestSentUser->logo) && $requestSentUser->logo != '' ?$requestSentUser->logo:"company-logo.jpg");?>" alt="img">
								</span>
								<span>
									<span><?php echo $requestSentUser->name; ?></span>
									<span class="time"><?php 
										if($crs['status'] == 1){
											echo '<button type="submit" class="btn btn-warning pull-right">Connected</i></button>';	
										}else{
											echo '<button type="submit" class="btn btn-warning pull-right">Request Sent</i></button>';	
										}
									?>
									</span>
								</span>
								<span class="message"><?php echo $requestSentUser->description; ?></span>
							  </a>
							</li>
						<?php
						}
					}
					echo '</ul>';
			 }else{
				echo '<h3><b>Empty Result. </b></h3>';
				}			 ?>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="tab_content_request_received" aria-labelledby="request_received_tab">
				  <?php if(!empty($connection_request_received)){
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
				 } else{
					echo '<h3><b>Empty Result. </b></h3>';
				}?>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="tab_content_company_connected" aria-labelledby="company_connected_tab">
				  <?php if(!empty($connected_company)){
				 echo '<ul class="list-unstyled msg_list">'; ?>
						<div class="x_content">
		<p class="text-muted font-13 m-b-30"></p>                   
		<table id="datatable-buttons" class="table table-striped table-bordered user_index" data-id="company">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Email</th>
					<th>GSTIN</th>
					<th>Year Of Establishment</th>
					<th>Website</th>
					<th>Number of Employees</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			   <?php 
				   foreach($connected_company as $comp){
				   #pre($comp);
					
					//$user['user_profile'] = $user['user_profile']?$user['user_profile']:'dummy.jpg';?>
				   <tr>
						<td><?php echo $comp['id']; ?></td>
						<td><?php echo $comp['name']; ?></td>
						
						<td><?php echo $comp['email']; ?></td>
						<td><?php echo $comp['gstin']; ?></td>
						<td><?php echo $comp['year_of_establish']; ?></td>
						<td><?php echo $comp['website']; ?></td>
						<td><?php echo $comp['no_of_employees']; ?></td>
						<td>
							<a href="<?php echo base_url(); ?>company/view/<?php echo $comp['u_id']; ?>" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i> View </a>
							<?php /*<a href="javascript:void(0)" id="<?php echo $comp['id']; ?>" data-id="company_view" class="add_company_tabs btn btn-warning btn-xs"><i class="fa fa-eye"></i> View </a>*/?>
							<?php /*<a href="<?php echo base_url(); ?>company/edit/<?php echo $comp['id']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>*/?>
							<?php /*<a href="javascript:void(0)" class="delete_listing_without
							btn btn-danger" data-href="<?php //echo base_url(); ?>company/delete/<?php // echo $comp['id']; ?>"><i class="fa fa-trash"></i></a>*/?>
						</td>
				   </tr>
				   <?php }
			   ?>
		</tbody>                   
	</table>
</div>

<div id="company_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Company</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
					<?php	echo '</ul>';
				 }else{
					echo '<h3><b>Empty Result. </b></h3>';
				} ?>
			</div>
		</div>
	</div>
</div>
