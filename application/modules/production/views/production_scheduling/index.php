
<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-success col-md-6">                            
		<?php echo $this->session->flashdata('message');?> </div>                        
	<?php }?>
<div class="x_content">
<form action="<?php echo site_url(); ?>production/production_scheduling" method="post" id="export-form">
		<input type="hidden" value='' id='hidden-type' name='ExportType'/>
		<input type="hidden" value='' class='start_date' name='start'/>
		<input type="hidden" value='' class='end_date' name='end'/>
	</form>	
	<?php if(!empty($productionScheduling)){ ?>
	<div class="row hidde_cls">
				<div class="col-md-12">
					<div class="col-md-4">
					</div>
					<div class="col-md-4">
						<div class="btn-group"  role="group" aria-label="Basic example">
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
							<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
								<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu" id="export-menu">
										<li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
										<li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
									</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php } ?>		
	<p class="text-muted font-13 m-b-30"></p>    
	<a href="<?php echo base_url();?>/production/add_production_scheduling/"><button class="btn btn-primary" data-toggle="modal" id = "btn">Add Production scheduling</button></a>
<div id="print_div_content"> 	
	<table id="datatable-buttons" class="table table-striped table-bordered account_index" data-id="account" border="1" cellpadding="3">
		<thead>
			<tr>
				<th>Id</th>
				<th>Date</th>				
				<th>Created By / Edited By</th>
				<th>Created Date</th>	
				<th class='hidde'>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php if(!empty($productionScheduling)){
						foreach($productionScheduling as $ps){	
							$draftImage = ($ps['save_status'] == 0)?('<img src="'.base_url(). 'assets/images/draft.png"  width="25%" class="hidde">'):'';							
							$createdByCid = getNameById('user_detail',$ps['created_by_cid'],'c_id');
							if(!empty($createdByCid)){
								$createdByName = $createdByCid->name;
							}else{
								$createdByName = '';
							}
					?>
						<tr>
							<td><?php echo $draftImage.$ps['id']; ?></td>
							<td><?php echo $ps['date'] ; ?></td>
							<td><?php echo (($ps['created_by']!=0)?(getNameById('user_detail',$ps['created_by'],'u_id')->name):'').'<br>'.(($ps['edited_by']!=0)?(getNameById('user_detail',$ps['edited_by'],'u_id')->name):''); ?></td>
				<td><?php echo date("j F , Y", strtotime($ps['created_date'])); ?></td>
							<td class='hidde'>	 
							<?php 
								if($can_edit) { 
									echo '<a href="'.base_url().'production/editProductionScheduling/'.$ps['id'].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>';
								}
								if($can_delete){
									echo '<a href="javascript:void(0)" class="delete_listing
									 btn btn-danger" data-href="'.base_url().'production/delete/'.$ps['id'].'"><i class="fa fa-trash"></i></a>';
								}
							?>	
							</td>
						</tr>
						<?php 
						
						$output11[] = array(
							   'Production Planing ID' => $ps['id'],
							   'Date' => $ps['date'],
							   'Created By' => $createdByName,
							   
							   );


							}
						$data3  = $output11;		
						export_csv_excel($data3);		
								
								} ?>
				</tbody>                               
	</table>
	</div>
</div>


    