<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-info">                            
			<?php echo $this->session->flashdata('message');?> 
		</div>                        
	<?php }
?>
<div class="x_content">
<form action="<?php echo site_url(); ?>purchase/suppliers" method="post" id="export-form">
				<input type="hidden" value='' id='hidden-type' name='ExportType'/>
				<input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
				<input type="hidden" value='' class='start_date' name='start'/>
				<input type="hidden" value='' class='end_date' name='end'/>
			</form>
<!--<div class="stik">
	<div class="col-md-12 datePick">
		<div class="col-md-6 col-xs-12 col-sm-6 datePick-left">
			<p>Date Range Picker    </p>                  
			<fieldset>
				<div class="control-group">
					<div class="controls">
						<div class="input-prepend input-group">
							<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							<input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="purchase/suppliers">
						</div>
					</div>
				</div>
			</fieldset>
			
		</div>
		<div class="col-md-6 col-xs-12 col-sm-6 datePick-right">
			<?php if($can_add) { 
				echo '<button type="buttton" class="btn btn-info add_purchase_tabs addBtn" id="sup_add" data-toggle="modal" data-id="editSupplier">Add</button>';
				#echo '<button type="buttton" class="btn btn-info add_purchase_tabs addBtn" id="sup_add" data-toggle="modal" data-id="editSupplierNew">Add New</button>';
			} 
			
			?>
			
		</div>
	</div>
</div>-->
	
	
	<div class="row hidde_cls stik">
		<div class="col-md-12">		
			<div class="export_div">
			<div class="col-md-3 col-xs-12 col-sm-3 datePick-left">                 
			<fieldset>
				<div class="control-group">
					<div class="controls">
						<div class="input-prepend input-group">
							<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							<input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="purchase/suppliers">
						</div>
					</div>
				</div>
			</fieldset>
			<form action="<?php echo base_url(); ?>purchase/suppliers" method="post" id="date_range">	
				 <input type="hidden" value='' class='start_date' name='start'/>
				 <input type="hidden" value='' class='end_date' name='end'/>
			</form>	
		</div>
		
				<div class="btn-group"  role="group" aria-label="Basic example">
					<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
					<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
					<input type="hidden" value='supplier' id="table" data-msg="Suppliers" data-path="purchase/suppliers"/>
					<button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
					<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
						<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
						<ul class="dropdown-menu" role="menu" id="export-menu">
							<li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
							<li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
							<li id="export-to-blank-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to Blank Excel</a></li>
						</ul>
					</div>
				
				<form action="<?php echo base_url(); ?>purchase/suppliers" method="post" >
					<input type="hidden" value='1' name='favourites'/>
					<input type="hidden" value='<?php if(!empty($_POST['start'])){echo $_POST['start'];}?>' class='start' name='start'/>
					<input type="hidden" value='<?php if(!empty($_POST['end'])){echo $_POST['end'];} ?>' class='end' name='end'/>
					<button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
				</form>
				<form action="<?php echo site_url(); ?>purchase/Create_suppliers_blankxls" method="post" id="export-form-blank">
					<input type="hidden" value='' id='hidden-type-blank-excel' name='ExportType_blank'/>
				</form>
			</div>
				<div class="col-md-3 col-xs-12 col-sm-6 datePick-right">
				     <?php if($can_add) { 
				echo '<button type="buttton" class="btn btn-info add_purchase_tabs addBtn" id="sup_add" data-toggle="modal" data-id="editSupplier">Add</button>';
				#echo '<button type="buttton" class="btn btn-info add_purchase_tabs addBtn" id="sup_add" data-toggle="modal" data-id="editSupplierNew">Add New</button>';
			} 
			
			?>
				</div>
			</div>
		</div>
	</div>
	<p class="text-muted font-13 m-b-30"></p>
	<input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">	 
	<div id="print_div_content">  

		  <form class="form-search" method="post" action="<?= base_url() ?>purchase/test_page/">
			<div class="input-group">
				<span class="input-group-addon">
					<i class="ace-icon fa fa-check"></i>
				</span>

				<input type="text" class="form-control search-query" placeholder="Type your search word" name="search" id="search" value="<?php echo $search_string;?>">
				<span class="input-group-btn">
					<button type="submit" class="btn btn-purple btn-sm">
						<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
						Search
					</button>
				</span>
			</div>
		</form> 
		
		
		<?php /* <form method='post' action="<?= base_url() ?>purchase/test_page" >
			 <input type='text' name='search' value='<?= $search ?>'>
			 <input type='submit' name='submit' value='Submit' class="form-search">
		</form> */ ?>
   
	
		<table id="" class="table  table-bordered user_index" style="width:100%" data-id="user" border="1" cellpadding="3">
			<thead>
				<tr>	
				<?php	/* <th><input id="selecctall" type="checkbox"></th>
					<th>Id</th>
					<th>Supplier Name</th>
					<th>Material Type</th>
					<th>Material Detail</th>
					<th>Contact person </th>
					<th class='hidde'>Created By / Edited By</th>
					<th>Created Date</th>
					<th class='hidde'>Action</th>
					 */ ?>
					<th><input id="selecctall" type="checkbox"></th>
					 <?php
					 foreach($sort_cols as $field_name => $field_display): ?>
						<th><?php echo anchor('purchase/test_page/'.$field_name.'/'.($sort_by == $field_name ? $sort_order : 'asc').'/'.$page, $field_display); ?></th>
					<?php endforeach;?>
					<th>Material Detail</th>
					<th>Contact person </th>
					<th class='hidde'>Created By / Edited By</th>
					<th>Created Date</th>
					<th class='hidde'>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($suppliers)){					
					foreach($suppliers as $supplier){		


						if($supplier['favourite_sts'] == '1'){
													$rr = 'checked';
												}else{
												$rr = '';
											}		
						$created_by = ($supplier['created_by']!=0)?(getNameById('user_detail',$supplier['created_by'],'u_id')->name):'';
						$edited_by = ($supplier['edited_by']!=0)?(getNameById('user_detail',$supplier['edited_by'],'u_id')->name):'';
						$materialType = getNameById('material_type',$supplier['material_type_id'],'id');
						$draftImage = '';
						if($supplier['save_status'] == 0)
						$draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';?>
						<tr>
							<td><?php if($supplier["used_status"]==0){echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$supplier['id'].">";}

								if($supplier['favourite_sts'] == '1'){
											   				echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$supplier['id']."  checked = 'checked'>";
											   				echo"<input type='hidden' value='supplier' id='favr' data-msg='Suppliers' data-path='purchase/test_page' favour-sts='0' id-recd=".$supplier['id'].">";
											   		}else{
															echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$supplier['id'].">";
															echo"<input type='hidden' value='supplier' id='favr' data-msg='Suppliers' data-path='purchase/test_page' favour-sts='1' id-recd =".$supplier['id'].">";
											   		}
							?>
								

							</td>
							<td><?php echo $draftImage.$supplier['id']; ?>
								

							


							</td>
							<td><?php echo $supplier['name']; ?></td>
							<td><?php  if(!empty($materialType)){echo $materialType->name;}else{echo 'N/A';} ?></td>
							<td>
								<?php if($supplier['material_name_id'] != '' && $supplier['material_name_id'] != '[{"material_name_id":"","uom":""}]' ){ ?>
										<table  style="width:100%" class="table table-bordered  bulk_action" data-id="user" border="1" cellpadding="3">
											<thead>								
											  <tr>								
												<th>Material Name</th>								
												<th>Uom</th>					
											  </tr>
											</thead>								
										<?php 								
											$materialDetail=json_decode($supplier['material_name_id']);
											$countMaterialDetailLength = count($materialDetail);
											$i =1;
											foreach($materialDetail as $materialdetail){									
												$material_id=$materialdetail->material_name_id;									
												$materialName=getNameById('material',$material_id,'id');

												$ww =  getNameById('uom', $materialdetail->uom,'id');
												$uom = !empty($ww)?$ww->ugc_code:'';					
												if($i<=3){
											?>	
												<tr>								
													<td>
														<a href="javascript:void(0)" id="<?php echo $material_id; ?>" data-id="material_view" class="inventory_tabs"><?php if(!empty($materialName)){echo $materialName->material_name;} else{ echo "Null";} ?></a>
													</td>								
												  <td>
														<?php echo $uom; ?>
												  </td>	
												</tr>								
											<?php 
											}
											$i++;
											$output[] = array(
											   'Supplier Name' => $supplier['name'],
											   'Material Type' => $materialType->name,
											   'Material Name' => $materialName->material_name,
											   'UOM' => $materialName->uom,
											   'Created Date' => date("d-m-Y", strtotime($supplier['created_date'])),
											);

										$output_blank[] = array(
												   'name' => '',
												   'address' => '',
												   'mailing_name' => '',
												   'gstin' => '',
												   'website' => '',
												   'branch_name' => '', 
												   'account_no' => '',
												   'ifsc_code' => '',
												   'other' => '',
											);	
									}
												if($countMaterialDetailLength > 3){
											
											if($can_view) {
												echo "<tr class='hidde'>
														<th colspan='6'>
															<a href='javascript:void(0)' id='". $supplier["id"] . "' data-id='SupplierView' class='add_purchase_tabs ' data-tooltip='View' id='" . $supplier["id"] . "' style='color:green;'>View More....</a>
														</th>
													</tr>";
													}
											}
											
						
										?>								
										</table>	 
									<?php } ?>							  
							</td>
							<td>
								<?php $contactPerson = json_decode($supplier['contact_detail']);
										if(!empty($contactPerson)){
											foreach($contactPerson as $contact_person){
												$PersonName= $contact_person->contact_detail;
												echo $PersonName; 
											}
										}
								?> 	
							</td>						
							<td class='hidde'><?php echo "<a href='".base_url()."users/edit/".$supplier['created_by']."' target='_blank'>".$created_by.'</a><a href="'.base_url().'users/edit/'.$supplier["edited_by"].'" target="_blank"><br>'.$edited_by."</a>"; ?></td>							
							<td><?php echo date("j F , Y", strtotime($supplier['created_date'])); ?></td>
							<td class='hidde'>
								<?php 
									if($can_edit)
										echo '<a href="javascript:void(0)" data-tooltip="Edit" class="btn btn-edit btn-xs add_purchase_tabs" data-toggle="modal" data-id="editSupplier" id="'.$supplier["id"].'"><i class="fa fa-pencil"></i>  </a>'; 
									if($can_view) 
										echo '<a href="javascript:void(0)" data-tooltip="View" class="btn btn-view btn-xs add_purchase_tabs" ata-toggle="modal" data-id="SupplierView" id="'.$supplier["id"].'"><i class="fa fa-eye"></i>  </a>';
									if($can_delete && $supplier["used_status"]==0)
										echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
									btn btn-delete btn-xs" data-href="'.base_url().'purchase/delete_supplier/'.$supplier["id"].'"><i class="fa fa-trash"></i></a>';
									
									#echo '<a href="javascript:void(0)" data-tooltip="View" class="btn btn-view btn-xs add_purchase_tabs" ata-toggle="modal" data-id="SupplierViewNew" id="'.$supplier["id"].'">View New  </a>';
								?>
							</td>
						</tr>
					<?php
						
					$data3  = $output;
					
				
					}
					// pre($output);
					export_csv_excel($data3);	
					$data_balnk  = $output_blank;
					export_csv_excel_blank($data_balnk); 	
				} ?>
			</tbody>  
			<?php echo $this->pagination->create_links(); ?>			
		</table>
		
	</div>
</div>
<div id="printView">
	<div id="purchase_add_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
		<div class="modal-dialog modal-large">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Suppliers</h4>
				</div>
				<div class="modal-body-content" style="height:auto;"></div>
			</div>
		</div>
	</div>
</div>




<?php $this->load->view('common_modal'); ?>	
