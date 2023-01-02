
<div class="x_content">
	<div class="row hidde_cls">
		
			<?php if($this->session->flashdata('message') != ''){
					echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
					setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
				}?>
			<p class="text-muted font-13 m-b-30"></p>
			<div class="row hidde_cls">
				<div class="col-md-12">
					<center>
					<div class="export_div">
					    <div class="col-md-3 col-xs-12 datePick-left">               
							<fieldset>
								<div class="control-group">
								  <div class="controls">
									<div class="input-prepend input-group">
									  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
									  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/delivery_chln"/>
									</div>
								  </div>
								</div>
							</fieldset>
							<form action="<?php echo base_url(); ?>account/delivery_chln" method="post" id="date_range">	
							   <input type="hidden" value='' class='start_date' name='start'/>
							  <input type="hidden" value='' class='end_date' name='end'/>
							</form>	
						</div>
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
						<div class="col-md-3 datePick-right">
			<form action="<?php echo base_url(); ?>account/delivery_chln" method="post" id="date_range">	
				 <input type="hidden" value='' class='start_date' name='start'/>
				 <input type="hidden" value='' class='end_date' name='end'/>
			</form>
				<form action="<?php echo site_url(); ?>account/delivery_chln" method="post" id="export-form">
					<input type="hidden" value='' id='hidden-type' name='ExportType'/>
					<input type="hidden" value='' class='start_date' name='start'/>
					<input type="hidden" value='' class='end_date' name='end'/>
				</form>
				
			<?php if($can_add) {
		echo '<button type="button" class="btn btn-primary add_challan_tabs" data-toggle="modal" id="add" data-id="add_challan">Add</button>';
	} ?>
			</div>
					</div>
					</center>
				</div>
			</div>
	</div>
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
			<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class="active"><a href="#tab_content_accepted_invoice" id="invoice_tab" role="tab" data-toggle="tab" aria-expanded="true">Challan</a></li>
				<!--li role="presentation" class=""><a href="#rejected_invoice_tab" role="tab" id="auto_entery_tab" data-toggle="tab" aria-expanded="false">Rejected Invoices</a></li-->
			</ul>
		<div id="myTabContent" class="tab-content">
		<div role="tabpanel" class="tab-pane fade active in" id="tab_content_accepted_invoice" aria-labelledby="invoice_tab">
			
			<div id="print_div_content">
				<table id="datatable-buttons" class="table table-striped table-bordered action-icons" data-id="account" style="width:100%" border="1" cellpadding="3">
				<!--<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">---->
				<thead>
					<tr>
						<th>Id</th>
						<th>Challan Number</th>
						
						<!--th>Sale Ledger</th-->
						<th>Material</th>
						<th>Challan Issue Date</th>
						<th>Created By</th>
						<th class='hidde'>Edited By</th>
						<th class='hidde'>Created On</th>				
						<th class='hidde'>Action</th>
					</tr>
				</thead>
					<tbody>
						<?php  
						//$date = $freeze_date->freeze_date;
							if(!empty($delivery_data)){
								foreach($delivery_data as $challan_dtl){
									//pre($challan_dtl);
										$action = '';
										if($can_edit) {
												
												$action .=  '<a  href="javascript:void(0)" id="'. $challan_dtl["id"] . '" data-id="add_challan" class="btn btn-edit add_challan_tabs   btn-xs" data-tooltip="Edit" id="' . $challan_dtl["id"] . '"><i class="fa fa-pencil" ></i>  </a>';		
												
												$action .=  '<a href="javascript:void(0)" id="'. $challan_dtl["id"] . '" data-id="challan_view_details" class="add_challan_tabs btn-view  btn  btn-xs" data-tooltip="View" id="' . $challan_dtl["id"] . '"><i class="fa fa-eye"></i>  </a>';
												}
											if($can_delete) { 
												$action = $action.'<a href="javascript:void(0)"  class="delete_listing btn  btn-delete  btn  btn-xs" data-tooltip="Delete"   data-href="'.base_url().'account/deleteChallan_details/'.$challan_dtl["id"].'" ><i class="fa fa-trash"></i></a>';
											
											}
								$edited_by = ($challan_dtl['edited_by']!=0)?(getNameById('user_detail',$challan_dtl['edited_by'],'u_id')->name):'';
								
					$material_id_datas_export = json_decode($challan_dtl['descr_of_goods'],true);
					
					if($material_id_datas_export == ''){
					}else{
						$material_names_export = '';
						foreach($material_id_datas_export  as $matrial_new_id_export){
							$material_id_get_export = $matrial_new_id_export['material_id'];
							@$material_name_export = ($material_id_get_export!=0)?(getNameById('material',$material_id_get_export,'id')->material_name):'';
							@$material_names_export .= $material_name_export.' ';
						
						}
					}
					
				$draftImage = '';	
				if($challan_dtl['save_status'] == 0)
                $draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';
				
				$party_name = getNameById('ledger',$challan_dtl['party_name'],'id');
				//pre($challan_dtl['party_name']);
				//pre($party_name);
				$sale_ledger_name = getNameById('ledger',$challan_dtl['sale_ledger'],'id');
				//<td><a href='javascript:void(0)' id='". $challan_dtl['sale_ledger'] . "' data-id='ledger_view' class='add_account_tabs'>".$sale_ledger_name->name."</a></td>
				echo "<tr>
					<td>".$draftImage.$challan_dtl['id']."</td>
					<td>".$challan_dtl['challan_num']."</td>
					<td>
						<table id='datatable-buttons addMore' class='table table-striped table-bordered action-icons' data-id='account'  border='1' cellpadding='3'>
							<tr>
								<th>Material Name</th>
								<th>HSN code</th>
								<th>Qty / UOM</th>
								<th>Rate</th>
							
							</tr>";
							$material_id_datas = json_decode($challan_dtl['descr_of_goods'],true);
								$total_mat_id = 0;
								foreach ($material_id_datas as $value) {
									if($value["material_id"]){
										$total_mat_id = $total_mat_id+1;
									}
								}
								$countMaterialLength = $total_mat_id;
									$i = 1;
										foreach($material_id_datas as $materialData){
											//pre($materialData);
											
											//For not show discount detail in count											
											if($materialData['material_id']!='' && $materialData['quantity'] !=''  ){//For not show discount detail in count											
											$materialName = getNameById('material',$materialData['material_id'],'id');
											
												if($i<=3){
													echo "
													<tr>
														<td ><a href='javascript:void(0)' id='".$materialData['material_id']."' data-id='material_view' class='inventory_tabs'>".$materialName->material_name."</a></td>
														<td>".$materialData['hsnsac']."</td>
														<td>".$materialData['quantity']." / ".$materialData['UOM']."</td>
														<td>".money_format('%!i',$materialData['rate'])."</td>";
													"</tr>";
												$i++;
												}
											}
										}
										if($countMaterialLength > 3){
											echo "<tr class='hidde'>
													<th colspan='6'>
														<a href='javascript:void(0)' id='". $challan_dtl["id"] . "' data-id='challan_view_details' class='add_challan_tabs ' data-tooltip='View' id='" . $challan_dtl["id"] . "' style='color:green;'>View More....</a>
													</th>
												</tr>";
										}

										
								echo"</table>
							</td>
							
							<td class='hidde'>".date("j F , Y", strtotime($challan_dtl['challan_date']))."</td>	
							<td><a href='".base_url()."users/edit/".$challan_dtl['created_by']."' target='_blank'>".getNameById('user_detail',$challan_dtl['created_by'],'u_id')->name."</a></td>	
							<td class='hidde'>".$edited_by."</td>	
							<td class='hidde'>".date("j F , Y", strtotime($challan_dtl['created_date']))."</td>	
							<td class='hidde'>".$action."</td>	
						</tr>";
						
						$position=25;
						$Matrl_name = substr($material_names_export, 0, $position); 
						/* $output[] = array(
							   'Challan Number' => $challan_dtl['challan_num'],
							   //'Party Name'  => $party_name->name,
							   'Sale Ledger' => $sale_ledger_name->name,
							   'Material Name' => $Matrl_name,
							   'Created Date' => date("d-m-Y", strtotime($challan_dtl['created_date'])),
							);	
							$data3  = $output;
							export_csv_excel($data3);  */
			   
		   }
	} 
	   ?>
	   
	  
		</tbody>                   
	</table>
	</div>
</div>
	<div role="tabpanel" class="tab-pane fade" id="rejected_invoice_tab" aria-labelledby="auto_entery_tab">


	
	</div>
	</div>
	</div>
</div>
<div id="challan_add_modal" class="modal fade in"  role="dialog">  
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Challan Detail </h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
<?php $this->load->view('common_modal'); ?>

