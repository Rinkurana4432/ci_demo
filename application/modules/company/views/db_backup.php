<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-info col-md-6">                            
		<?php echo $this->session->flashdata('message');?> </div>                        
	<?php }?>
<div class="x_content">	
			<?php if($can_add) { echo '<a href="javascript:void(0)" class="take_bkup btn btn-primary" data-href="'.base_url().'company/make_backup_db">Create Database Backup</a>';

echo '<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
				Set Database Backup Frequeny</button>
				<div class="collapse" id="collapseExample">
					<div class="card card-body">
						<form method="post" class="form-horizontal" action="'.base_url().'company/saveCompanyBackupFrequency" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
							<input type="hidden" value="'.(!empty($company_settings)?$company_settings->id:'').'" name="id">
							<input type="hidden" value="'.$_SESSION['loggedInUser']->c_id.'" name="c_id">
							<div class="item form-group">
									<label class="control-label col-md-2 col-sm-3 col-xs-12" for="gstin">Company backup frequency</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="radio" class="flat" name="backup_frequency" id="weekly" value="weekly" '.(!empty($company_settings && $company_settings->backup_frequency == 'weekly')?'checked':'') .' required /> Weekly &nbsp;
										<input type="radio" class="flat" name="backup_frequency" id="daily" value="daily"  '.(!empty($company_settings && $company_settings->backup_frequency == 'daily')?'checked':'') .'/> daily&nbsp;
									</div>
								</div>';															
							if($_SESSION['loggedInUser']->role !=3){					
							echo '<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<input type="submit" class="btn btn-warning" value="Submit"> 
							</div>';
							}
						echo '</form>
					</div>
				</div>';			} ?>
		<p class="text-muted font-13 m-b-30"></p>                   
		<table id="example" class="table  table-bordered user_index" style="width:100%" data-id="user" border="1" cellpadding="3">		
			
				<thead>
					<tr>
						<th>Backup</th>
						<th>Backup Size</th>
						<th>Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
						<tr>
							<tbody>
							<?php $backups = list_files('assets/modules/company/db_backup/'); 
							if(!empty($backups)){
								foreach($backups as $backup) {
									$_fullpath = 'assets/modules/company/db_backup/' . $backup; ?>
									<tr>
										<td>
											<a href="<?php echo base_url('assets/modules/company/db_backup/' . $backup); ?>"><?php echo $backup; ?></a>
										</td>
										<td>
											<?php echo bytesToSize($_fullpath); ?>
										</td>
										<td data-order="<?php echo strftime('%Y-%m-%d %H:%M:%S', filectime($_fullpath)); ?>">
											<?php echo date('M dS, Y, g:i a',filectime($_fullpath)); ?>
										</td>
										<td>												
											<a href="<?php echo base_url(); ?>company/delete_backup/<?php echo $backup; ?>" class="delete_listing_without btn btn-danger"><i class="fa fa-remove"></i></a>
										</td>
									</tr>
								<?php } 
							}?>
						</tbody>						
						</tr>
						
				</tbody>                   
			</table>
</div>





				