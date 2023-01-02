<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>Company View</h3>
			</div>
			<div class="title_right">
				<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Search for...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">Go!</button>
						</span>
					</div>
				</div>
			</div>
		</div>	
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Company View<small>Company Report</small></h2>
					<ul class="nav navbar-right panel_toolbox">
					  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>					  
					  <li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
						<div class="profile_img">
							<div id="crop-avatar">
								<!-- Current avatar -->
								<img class="img-responsive avatar-view" src="<?php echo base_url('assets/modules/company/uploads').'/'.(isset($company->logo) && $company->logo != '' ?$company->logo:"dummyLogo.png");?>" alt="Avatar" title="Change the avatar">
							</div>
						</div>
						<h3><?php if(!empty($company)) echo $company->name; ?></h3>
						<ul class="list-unstyled user_data">
							<li><i class="fa fa-envelope"></i>  <?php if(!empty($company)) echo $company->email; ?></li>
							<li><i class="fa fa-align-justify"></i> GSTIN : <?php if(!empty($company)) echo $company->gstin; ?></li>
						</ul>
						<a class="btn btn-success" href="<?php echo base_url().'company/edit/'.$company->companyId; ?>"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
						<br />
					</div>					
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="profile_title">
							<div class="col-md-6">
								<h2>Company Details</h2>
							</div>
						</div>
						<table class="fixed data table table-striped no-margin">
							<thead>
								<tbody>
									<tr>
										<th>Company Type:</th>
										<td><?php if(!empty($company)) echo $company->company_type; ?></td>									  
										<th>Website:</th>
										<td><?php if(!empty($company)) echo $company->website; ?></td>
									</tr>
									<tr>
										<th>Description</th>
										<td><?php if(!empty($company)) echo $company->description; ?></td>
										<th>Address:</th>
										<td><?php if(!empty($company)) echo $company->address1; ?></td>
									</tr>
									<tr>
									  <th>Key People</th>
									  <td>
									  <?php if(!empty($company) && $company->key_people !=''){
											$companyPeople =  json_decode($company->key_people);
											foreach($companyPeople as $cp){
												if($cp !='') echo $cp.'<br/>';
											}
										}	?>
									  </td>									  
									  <th>Address2:</th>
									  <td><?php if(!empty($company)) echo $company->address2; ?></td>
									</tr>
									<tr>
									  <th>Number Of Employees:</th>
									  <td><?php if(!empty($company)) echo $company->no_of_employees; ?></td> 
									</tr>									
								</tbody>
							</thead>
						</table>						
						<h4>Certification:</h4>						
						<div class="x_content">
							<div class="row">	
								<div class="col-md-6">
									<?php if(!empty($companyCertificate)){
										foreach($companyCertificate as $compCer){						
										echo '<div class="col-md-55">						   
										  <div class="image view view-first">
											<img style="width: 100%; display: block;" src="'.base_url().'assets/modules/company/uploads/'.$compCer['file_name'].'" alt="image" />								
										  </div>
										</div>';							
										 } } ?>	
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
</div>
<!-- /page content -->