<?php if($this->session->flashdata('message') != ''){?>                        
	<div class="alert alert-success col-md-6">                            
	<?php echo $this->session->flashdata('message');?> </div>                        
<?php }?>

			

<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	         <form class="form-search" method="post" action="<?= base_url() ?>maintenance/preventive">
	<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,Machine Name,Machine Code" name="search" id="search" value="<?php if(!empty($_POST['search'])) echo $_POST['search'];?>">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
					</span>
				</div>
</div>
			</form>	
				<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>maintenance/preventive">
			<input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			</form>
			<button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
			<div id="demo" class="collapse">
			      <div class="col-md-3 col-xs-12 col-sm-12 datepicker">
					     <fieldset>
				<div class="control-group">
					<div class="controls">
						<div class="input-prepend input-group">
						<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						<input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="maintenance/preventive"/>
					</div>
					</div>
				</div>
			</fieldset>
		<form action="<?php echo base_url(); ?>maintenance/preventive" method="post" id="date_range">	
			 <input type="hidden" value='' class='start_date' name='start'/>
			 <input type="hidden" value='' class='end_date' name='end'/>
		</form>
					</div>
			</div>
	  </div>
</div>
<!----
	<div class="col-md-12 datePick">
		Date Range Picker                      
		<fieldset>
			<div class="control-group">
				<div class="controls">
					<div class="input-prepend input-group">
						<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						<input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value=""  data-table="production/add_machine"/>
					</div>
				</div>
			</div>
		</fieldset>              
    </div>----->

	<div class="row hidde_cls export_div">
				<div class="col-md-12">
					
					
						<div class="btn-group"  role="group" aria-label="Basic example">
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
							<input type="hidden" value='add_machine' id="table" data-msg="Machine" data-path="maintenance/preventive"/>
					  <button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
							<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
								<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu" id="export-menu">
										<li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
										<li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
									</ul>
							</div>
							<form action="<?php echo base_url(); ?>maintenance/preventive" method="post" >
							<input type="hidden" value='1' name='favourites'/>
											<input type="hidden" value='<?php if(!empty($_POST['start'])){echo $_POST['start'];}?>' class='start' name='start'/>
											<input type="hidden" value='<?php if(!empty($_POST['end'])){echo $_POST['end'];} ?>' class='end' name='end'/>
						 <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>

						</form>
						</div>

						


					<div class="col-md-3 col-xs-12 col-md-12 datePick-right">
			<?php //if($can_add){ echo '<button class="btn btn-primary maintenanceTab addBtn" data-toggle="modal" id="add1" data-id="machineEdit">Add</button>'; }?>	
			<?php //if($can_add){ echo '<button class="btn btn-primary maintenanceTab addBtn" data-toggle="modal" id="add1" data-id="machineEditNew">Add New</button>'; }?>				
			<form action="<?php echo site_url(); ?>maintenance/preventive" method="post" id="export-form">
				<input type="hidden" value='' id='hidden-type' name='ExportType'/>
				<input type="hidden" value='' class='start_date' name='start'/>
				<input type="hidden" value='' class='end_date' name='end'/>
			</form>
		</div>
				</div>
			</div>
	
	<p class="text-muted font-13 m-b-30"></p>    


<div id="print_div_content" class="table-responsive">	

			<input type="hidden" id="visible_row" value=""/>
            <!------------------ datatable-buttons -------------->
	 <table id="" style="margin-top:40px;" class="table table-striped  table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>				
		<thead>
			<tr>
						<th><input id="selecctall" type="checkbox"></th>
						<th onclick="get_order();">Id</th>
						<th onclick="get_order();">Machine Name</th>
						<th onclick="get_order();" >Machine Code</th>
						<th  onclick="get_order();">Preventive Maintenance</th>
						<th>Machine Parameter</th>
						
						<th  onclick="get_order();">Make & Model</th>
						<th >Date of Purchase</th>
						<th >Placement</th>
						<th >Created By / Edited By</th>
						<th>Created Date</th>
						<th>Set/Unset</th>
						<th class='hidde'>Action</th>
						
					</tr>
			</tr>
		</thead>
		<tbody>
		<?php  if(!empty($AddMachine)){
			   foreach($AddMachine as $addMachine){
				$draftImage = ($addMachine['save_status'] == 0)?('<img src="'.base_url(). 'assets/images/draft.png"  width="25%" class="hidde">'):'';
				$created_by = ($addMachine['created_by']!=0)?(getNameById('user_detail',$addMachine['created_by'],'u_id')->name):'';
				$edited_by = ($addMachine['edited_by']!=0)?(getNameById('user_detail',$addMachine['edited_by'],'u_id')->name):'';     
			?>
			<tr>
			<td><?php if($addMachine["used_status"]==0){echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$addMachine['id'].">";}

										//else{echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$supplier['id'].">";}

			if($addMachine['favourite_sts'] == '1'){
					echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$addMachine['id']."  checked = 'checked'>";
					echo"<input type='hidden' value='add_machine' id='favr' data-msg='Machine' data-path='maintenance/preventive' favour-sts='0' id-recd=".$addMachine['id'].">";
			}else{
					echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$addMachine['id'].">";
					echo"<input type='hidden' value='add_machine' id='favr' data-msg='Machine' data-path='maintenance/preventive' favour-sts='1' id-recd =".$addMachine['id'].">";
			}
			?></td>
			<td><?php echo $draftImage.$addMachine['id']; ?></td>
			<!--<td><?php //echo $addMachine['machine_name']; ?></td>-->
			<td><a href="javascript:void(0)" id="<?php echo $addMachine['id']; ?>" data-id="machineView" class="maintenanceTab"><?php echo $addMachine['machine_name']; ?></td>
			<td><?php echo $addMachine['machine_code']; ?></td>
			
			<td><?php echo $addMachine['preventive_maintenance']; ?></td>
			<?php 
			 $machineParameter = JSON_decode($addMachine['machine_parameter']);							  
				$countParameterLength = count(array($machineParameter));
				
				if(!empty($machineParameter)){
				$i=1;
				 foreach($machineParameter as $Machine_parameter){
					$ww =  getNameById('uom', $Machine_parameter->uom,'id');
										$uom = !empty($ww)?$ww->ugc_code:'';

					
					}
				}
			
			?>
			
			<td><a href="#" id="<?php echo $addMachine['id'];?>" data-tooltip="View" class="maintenanceTab" data-id="viewpreventivedtl"><?php echo $Machine_parameter->machine_parameter; ?></a></td>
			
			
			<td><?php echo $addMachine['make_model']; ?></td>
			<td><?php echo date("j F , Y", strtotime($addMachine['year_purchase'])); ?></td>
			<td><?php echo $addMachine['placement']; ?></td>
			<td><?php echo "<a href='".base_url()."users/edit/".$addMachine['created_by']."' target='_blank'>".$created_by.'</a><a href="'.base_url().'users/edit/'.$addMachine["edited_by"].'" target="_blank"><br>'.$edited_by."</a>"; ?></td>
			<td><?php echo date("j F , Y", strtotime($addMachine['created_date'])); ?></td>
			<td><?php if($addMachine['set_unset'] =='0'){ echo 'Unset'; }else{ echo 'Set'; }?></td>
			<td class='hidde'>
            	<button id="<?php  echo $addMachine['id']; ?>" data-id="setpreventive" data-tooltip="Set Preventive" class="btn add-simi btn-xs maintenanceTab" data-toggle="modal"><i class="fa fa-check"></i></button>	
			<?php //if($can_edit) { 
				//echo '<button id="'.$addMachine['id'].'" data-id="editpreventive" data-tooltip="Edit" class="btn btn-edit btn-xs maintenanceTab" data-toggle="modal"><i class="fa fa-pencil"></i></button>';
				//}
				if($can_view){
				echo '<button id="'.$addMachine['id'].'" data-tooltip="View" class="btn btn-view btn-xs maintenanceTab" data-id="viewpreventive"><i class="fa fa-eye"></i></button>';
				//echo '<button id="'.$addMachine['id'].'" data-tooltip="View" class="btn btn-view btn-xs maintenanceTab" data-id="machineViewNew">View New</button>';
				}
				
			?>
			</td>
			</tr>
		<?php 
						@$output[] = array(
						   'Machine ID' => $addMachine['id'],
						   'Machine Name' => $addMachine['machine_name'],
						   'Machine Code' => $addMachine['machine_code'],
						   'Preventive Maintenance' => $addMachine['preventive_maintenance'],
						   'Machine Parameter' => $Machine_parameter->machine_parameter,
						  // 'Machine Parameter' => '',
						   'Machine UOM' =>  $uom,
						   //'Machine UOM' =>  '',
						   'Processes Name' => $addMachine['ProcesName'],
						   'Make & Model' => $addMachine['make_model'],
						   'Date of Purchase' => $addMachine['year_purchase'],
						   'Placement' => $addMachine['placement'],
						   'Created Date' => date("d-m-Y", strtotime($addMachine['created_date'])),
						);	
				}
				$data3  = $output;
		export_csv_excel($data3); 
			}

		
		?>
						
				</tbody>                               
	</table><?php //echo $this->pagination->create_links(); ?>
</div>
</div>
<div id="maintenance_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Preventive Details</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
    