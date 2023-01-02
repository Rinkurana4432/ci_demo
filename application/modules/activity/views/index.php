<div class="right_col" role="main" style="min-height: 3704px;">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3> <small></small></h3>
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
		 <?php if($this->session->flashdata("message")){?>
						<div class="alert alert-info">      
							<?php echo $this->session->flashdata("message")?>
						</div>
						<?php } ?>
        <div class="clearfix"></div>
            <div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Activity Log</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
									<ul class="dropdown-menu" role="menu">
									  <li><a href="#">Settings 1</a>
									  </li>
									  <li><a href="#">Settings 2</a>
									  </li>
									</ul>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
						
							<p class="text-muted font-13 m-b-30"></p> 

					<?php  if(is_admin()){ ?>
						<div class="col-md-8 m-t-15">
					  <a href="javascript:void(0)" class="delete_listing btn btn-danger pull-right" data-href="<?php echo base_url() ?>activity/clear_activity_log">Clear Activity Log</a>
                    </div>
					<?php  } ?>							
							<table id="datatable-buttons" class="table table-striped table-bordered user_index" data-id="user">
								<thead>
									<tr>
										<th>Description</th>
										<th>Date</th>
										<th>Done By</th>
									</tr>
								</thead>
								<tbody>
								   <?php if(!empty($activities)){
									   foreach($activities as $activity){
										?>
									   <tr>
											<td><?php echo $activity['description'].' ['.$activity['rel_id'].']'; ?></td>
											<td><?php echo $activity['date']; ?></td>											
											<td><?php echo $activity['name']; ?></td>
									   </tr>
									   <?php }
								   } ?>
							</tbody>                   
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>