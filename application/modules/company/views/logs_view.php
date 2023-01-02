	<div class="x_content">
		<?php if($this->session->flashdata('message') != ''){
				echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
			}					
		?>
		
	<style>
	    .form-inline {
          display: flex;
        }
        
        .date-form {
          display: flex;
          flex: 1 0 auto;
        }
        
        .date_picker {
          width: 100%;
        }
	</style>
	<!-- ------ Activity Log Page ------- -->
	<div class="row">
		<div class=" col-md-12 col-sm-12 col-xs-12 companyv">
			<ul class="nav nav-tabs col-md-12 col-sm-12 col-xs-12 check_cls" class="cpm">
				<li class="active"><a href="#activity" data-toggle="tab"><i class="fa fa-home"></i> <span>Activity Logs</span></a></li>
				<li><a href="#visiting" data-toggle="tab"><i class="fa fa-info"></i> <span>Visiting Logs</span></a></li>
				<li>
				    <form class="form-inline" action="<?php echo base_url(); ?>company/activity_log" method="post">
                      <div class="form-group date-form"> 
                      Date: <input type="date" name="sdate" class="form-control date_picker" value="<?php echo isset($_POST['sdate']) ? $_POST['sdate']:''; ?>"> 
                      </div> 
                      &nbsp;&nbsp;&nbsp;
                      <div class="form-group"> <input type="submit" name="view" value="View" class="btn btn-default"> </div>
                    </form>
				</li>
			</ul>
			<!-- tab content -->
			<div class="tab-content container">
			    
		        <div class="tab-pane active" id="activity">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
						<div class="home-category-info-header">
							<h2>Activity Logs</h2>
							<span class="home-category-info-header-line"></span>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
								
								<table id="alogs" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>SN</th>
											<th>Date</th>
											<th>Activity</th>
											<th>Created By / Edited By</th>
										</tr>
									</thead>
									<tbody>
										<?php
											if(!empty($activity_logs)){
											    $sr = 1; 
												foreach($activity_logs as $activitylog){
												$link = 'type='.$activitylog['rel_type'].'&rel='.$activitylog['rel_id'];    
										?>
										<tr>
											<td><?php echo $sr; //echo $activitylog['id']; ?></td>
											<td><?php echo $activitylog['date'];  ?></td>
											<!--<td><?php //echo date("j F , Y", strtotime($activitylog['date'])); ?></td>-->
											<td>
											    <!--<a href="<?php echo base_url(); ?>company/view_log?<?php echo $link; ?>" target="_blank" title="View detail">-->
											        <?php echo $activitylog['description']; ?>
											    <!--</a>-->
											</td>	
											<td><?php echo (($activitylog['userid']!=0)?(getNameById('user_detail',$activitylog['userid'],'u_id')->name):''); ?></td>
										</tr>
										   <?php $sr++; }} ?>
									</tbody>
								</table>
								
							</div>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="visiting">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated wow fadeInLeft">
						<div class="home-category-info-header">
							<h2>Visiting Logs</h2>
							<span class="home-category-info-header-line" data-spm-anchor-id="a2700.8293689.categoryInfoIndustry-1.i0.2ce265aaxlh2Wj"></span>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
							
							    <table id="vlogs" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>SN</th>
											<th>Date</th>
											<th>URL</th>
											<th>Section</th>
											<th>Visited By</th>	
										</tr>
									</thead>
									<tbody>
										<?php
											if(!empty($visiting_logs)){
											    $sr = 1; 
												foreach($visiting_logs as $visitinglog){	
										?>
										<tr>
											<td><?php echo $sr; //echo $visitinglog['id']; ?></td>
											<td><?php echo $visitinglog['date'];  ?></td>
											<td><?php echo $visitinglog['uri']; ?></td>	
											<td><?php echo $visitinglog['section'];  ?></td>
											<td><?php echo (($visitinglog['user_id']!=0)?(getNameById('user_detail',$visitinglog['user_id'],'u_id')->name):''); ?></td>
										</tr>
										   <?php $sr++; }} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				
			</div>
			<!-- tab content -->
		</div>
		
	</div>
</div>