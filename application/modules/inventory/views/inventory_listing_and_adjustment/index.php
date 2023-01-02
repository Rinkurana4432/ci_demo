<?php 
	if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-info col-md-6">                            
			<?php echo $this->session->flashdata('message');?> </div>    
			<?php
				$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
			?>                    
<?php }?>
<div class="x_content">

<div class="col-md-12 col-xs-12 for-mobile">
   <div class="Filter Filter-btn2">
   
     <!-- <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo" aria-expanded="true"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button> -->
	 <!-- <div id="demo" class="collapse " aria-expanded="true" style="">
         <div class="col-md-4 col-xs-12 col-sm-6 datePick-right">                
			<fieldset>
				<div class="control-group">
					<div class="controls">
						<div class="input-prepend input-group">
							<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							<input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="inventory/inventory_listing_and_adjustment">
						</div>
					</div>
				</div>
			</fieldset>
			<form action="<?php echo base_url(); ?>inventory/inventory_listing_and_adjustment" method="post" id="date_range">	
				<input type="hidden" value='' id='hidden-type' name='ExportType'/>
				<input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
				<input type="hidden" value='' class='start_date' name='start'/>
				<input type="hidden" value='' class='end_date' name='end'/>
				<input type="hidden" value='<?php if(!empty($_POST['company_unit'])){echo $_POST['company_unit'] ;} ?>' class='company_unit' name='company_unit'/>
			</form>	
			<form action="<?php echo base_url(); ?>inventory/inventory_listing_and_adjustment" method="post" >
							<input type="hidden" value='<?php if(!empty($_POST['start'])){echo $_POST['start'];} ?>' class='start_date' name='start'/>
							<input type="hidden" value='<?php if(!empty($_POST['end'])){echo $_POST['end'];} ?>' class='end_date' name='end'/>
							<input type="hidden" value='' name='ajax_var'/>
							<div class="row hidde_cls filter1 progress_filter" style="background-color: transparent;padding: 0px;">
								<div class="col-md-12">
									<div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
										<select style="border-right: 1px solid #c1c1c1;" class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="company_unit" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyId; ?>">
											<option></option>
										</select>
									</div>
								<input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="inventory/inventory_listing_and_adjustment" disabled="disabled">
								</div>
							</div>
			</form>
			</div>
			</div>
   </div> -->
</div>
	<div class="row hidde_cls">
		<div class="col-md-12  export_div">
			

			<div class="btn-group"  role="group" aria-label="Basic example">

						<form action="<?php echo base_url(); ?>inventory/inventory_listing_and_adjustment_excel" method="post">
						<input type="hidden" name="mat_id" id="mat_id" value="">
						<input type="submit" value="Export" class="btn btn-secondary dropdown-toggle btn-default">
						</form>			

			
			</div>
			<div class="col-md-3 col-xs-12 col-sm-6 datePick-right">
				<button type="buttton" class="btn btn-infoaddBtn" id="clickStockCheckBtn" >Stock Check </button>
			</div>
		</div>
	</div>	
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
			<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class="active"><a href="#tab_inventory_listing" id="invetory_listing_tab" role="tab" data-toggle="tab" aria-expanded="true">Inventory Listing </a></li>
				
				<li role="presentation" class=""><a href="#wip_listing12" role="tab" id="wip_listing" data-toggle="tab" aria-expanded="false">WIP Inventory Listing </a></li>
				<li role="presentation" class=""><a href="#third_type_inventory_listing" role="tab" id="third_type_inv_listing_tab" data-toggle="tab" aria-expanded="false">Third Party Inventory Listing </a></li>
			</ul>
		<div id="myTabContent" class="tab-content">

			<div role="tabpanel" class="tab-pane fade active in" id="tab_inventory_listing" aria-labelledby="invetory_listing_tab">
		
				<div class="" role="tabpanel" data-example-id="togglable-tabs">
				  <div class="container-full">
							<div id="custom_style_container1">
						<div id="tabs6" class="style1">
							<nav class="nav nav-tabs list mt-2 top-nav" id="myTab" role="tablist">
								<?php  $num = 0; 
								foreach ($type2 as $materialtype) {
								?>
								<a class="btn btn-primary get_data_btn" id="<?php echo $materialtype['id']; ?>"><?php if(!empty($materialtype)){echo $materialtype['name']; } ?></a>
								<?php
								$num++; }   ?>	
							</nav>
						</div>
							  </div>
							  <!--<p  class="ee">	
						      </p>-->

						  </div>
				
					<div class="container" >	
						<!--<div class="w-100 p-3">
						<div class="scroller scroller-left mt-2" style="display: block;"><i class="fa fa-chevron-left"></i></div>
						<div class="scroller scroller-right mt-2"><i class="fa fa-chevron-right"></i></div>
						<div class="wrapper">
							 <nav class="nav tt nav-tabs list mt-2 top-nav" id="myTab" role="tablist">
								<?php  $num = 0; 
								foreach ($type2 as $materialtype) {
								?>
								<a class="btn btn-primary get_data_btn" id="<?php echo $materialtype['id']; ?>"><?php if(!empty($materialtype)){echo $materialtype['name']; } ?></a>
								<?php
								$num++; }   ?>	
							</nav> -->
						</div>
						
						<p  class="ee">	
						</p>
						</div>
					</div>
				
			<div role="tabpanel" class="tab-pane fade" id="third_type_inventory_listing" aria-labelledby="third_type_inv_listing_tab">
				<div id="print_div_content">
				<table id="mytable2" class="table tblData table-striped table-bordered action-icons" data-order='[[0,"desc"]]' style="width:100%" border="1" cellpadding="3">
				<thead>
					<tr>
						<th>Id
						<!--span>
							<a href="<?php //echo base_url(); ?>inventory/inventory_listing_and_adjustment?sort=asc" class="up"></a>
							<a href="<?php //echo base_url(); ?>inventory/inventory_listing_and_adjustment?sort=desc" class="down"></a>
						</span-->
						</th>
						<th>Challan Number
						<!--span>
							<a href="<?php //echo base_url(); ?>inventory/inventory_listing_and_adjustment?sort=asc" class="up"></a>
							<a href="<?php //echo base_url(); ?>inventory/inventory_listing_and_adjustment?sort=desc" class="down"></a></span>
						</th-->
						<th>Party Name
						<!--span>
							<a href="<?php //echo base_url(); ?>inventory/inventory_listing_and_adjustment?sort=asc" class="up"></a>
							<a href="<?php //echo base_url(); ?>inventory/inventory_listing_and_adjustment?sort=desc" class="down"></a>
						</span-->
						</th>
						<!--th>Sale Ledger</th-->
						<th>Material</th>
						<th>Created By</th>
						<th class='hidde'>Created On</th>				
						<th class='hidde'>Action</th>
					</tr>
				</thead>
					<tbody>
						<?php  
							if(!empty($third_invt_type_data)){
							foreach($third_invt_type_data as $thr_prty_challan_dtl){
								
									$action = '';
								if($can_edit) {
									$action .=  '<a href="javascript:void(0)" id="'. $thr_prty_challan_dtl["id"] . '" data-id="third_party_view_details" class="view_third_party_view_tabs btn-view  btn  btn-xs" data-tooltip="View" id="' . $thr_prty_challan_dtl["id"] . '"><i class="fa fa-eye"></i>  </a>';
								}
								$material_id_datas_export = json_decode($thr_prty_challan_dtl['material_descr'],true);
							if($material_id_datas_export == ''){
								
								}else{
									$material_names_export = '';
									foreach($material_id_datas_export  as $matrial_new_id_export){
										$material_id_get_export = $matrial_new_id_export['material_id'];
										@$material_name_export = ($material_id_get_export!=0)?(getNameById('material',$material_id_get_export,'id')->material_name):'';
										@$material_names_export .= $material_name_export.' ';
									
									}
								}
					
				$party_name = getNameById('ledger',$thr_prty_challan_dtl['party_name'],'id');
				//<td><a href='javascript:void(0)' id='". $challan_dtl['sale_ledger'] . "' data-id='ledger_view' class='add_account_tabs'>".$sale_ledger_name->name."</a></td>
				echo "<tr>
					<td>".$thr_prty_challan_dtl['id']."</td>
					<td>".sprintf("%04s", $thr_prty_challan_dtl['challan_number'])."</td>
					<td><a href='javascript:void(0)' id='". $thr_prty_challan_dtl['party_name'] . "' data-id='ledger_view' class='add_account_tabs'>".$party_name->name."</a></td>
					
					<td>
						<table id='datatable-buttons addMore' class='table table-striped table-bordered action-icons' data-id='account'  border='1' cellpadding='3'>
							<tr>
								<th>Material Name</th>
								<th>HSN code</th>
								<th>Qty / UOM</th>
								<th>Rate</th>
							
							</tr>";
							$material_id_datas = json_decode($thr_prty_challan_dtl['material_descr'],true);
								$total_mat_id = 0;
								foreach ($material_id_datas as $value) {
								
									if($value["material_id"]){
										$total_mat_id = $total_mat_id+1;
									}
									
								}
								$countMaterialLength = $total_mat_id;
									$i = 1;
										foreach($material_id_datas as $materialData){
											//For not show discount detail in count											
											if($materialData['material_id']!='' && $materialData['quantity'] !=''  ){//For not show discount detail in count											
											$materialName = getNameById('material',$materialData['material_id'],'id');

											$ww =  getNameById('uom', $materialData['UOM'],'id');
											$uom = !empty($ww)?$ww->ugc_code:'';											
												if($i<=3){
													echo "
													<tr>
														<td ><a href='javascript:void(0)' id='".$materialData['material_id']."' data-id='material_view' class='inventory_tabs'>".$materialName->material_name."</a></td>
														<td>".$materialData['hsnsac']."</td>
														<td>".$materialData['quantity']." / ".$uom."</td>
														<td>".money_format('%!i',$materialData['rate'])."</td>";
													"</tr>";
												$i++;
												}
											}
										}
										if($countMaterialLength > 3){
											echo "<tr class='hidde'>
													<th colspan='6'>
														<a href='javascript:void(0)' id='". $thr_prty_challan_dtl["id"] . "' data-id='challan_view_details' class='add_challan_tabs ' data-tooltip='View' id='" . $thr_prty_challan_dtl["id"] . "' style='color:green;'>View More....</a>
													</th>
												</tr>";
										}

										
								echo"</table>
							</td>
							
							<td><a href='".base_url()."users/edit/".$thr_prty_challan_dtl['created_by']."' target='_blank'>".getNameById('user_detail',$thr_prty_challan_dtl['created_by'],'u_id')->name."</a></td>	
							<td class='hidde'>".date("j F , Y", strtotime($thr_prty_challan_dtl['created_date']))."</td>	
							<td class='hidde'>".$action."</td>	
						</tr>";
						
						$position=25;
						$Matrl_name = substr($material_names_export, 0, $position); 
						$output[] = array(
							   //'Challan Number' => $thr_prty_challan_dtl['challan_num'],
							   'Party Name'  => $party_name->name,
							  // 'Sale Ledger' => $sale_ledger_name->name,
							   'Material Name' => $Matrl_name,
							   'Created Date' => date("d-m-Y", strtotime($thr_prty_challan_dtl['created_date'])),
							);	
							$data3  = $output;
							export_csv_excel($data3); 
			   
		   }
	} 
	   ?>
	   
	  
		</tbody>                   
	</table><?php //echo $this->pagination->create_links(); ?>	
		
	</div>
			</div>


			<div role="tabpanel" class="tab-pane fade" id="wip_listing12" aria-labelledby="wip_listing">
				<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<div class="container">	
						<div class="w-100 p-3">
						<div class="scroller scroller-left mt-2" style="display: block;"><i class="fa fa-chevron-left"></i></div>
						<div class="scroller scroller-right mt-2"><i class="fa fa-chevron-right"></i></div>
						<div class="wrapper">
							<nav class="nav nav-tabs list mt-2 top-nav" id="myTab" role="tablist">
								<?php  $num = 0; 
								foreach ($type2 as $materialtype) {
									$hj = getNameById_mat('work_in_process_material',$materialtype['id'],'material_type_id');
									if(!empty($hj)){ 
                                            foreach ($hj as $ert1){
                                                if(empty($ert1['material_type_id'])){
                                                    $gh = "";
                                                   #$gh =  $er
                                                }
                                                else{
                                                    $gh = $ert1['material_type_id'];
                                                }
                                            }
                                	}   
									if(!empty($hj) && $gh == $materialtype['id']){
								?>
								<a class="btn btn-primary get_data_btnwip" id="<?php echo $materialtype['id']; ?>"><?php if(!empty($materialtype)){echo $materialtype['name']; } ?></a>
								<?php	}

								$num++; }   ?>	
							</nav>
						</div>
						<p  class="eewip">	
						</p>
						</div>
					</div>
				</div>
			</div>
</div>
			</div>

		</div>
	</div>


				<!---------------------------------end------------------------------------->
	<!--Scrap modal-->
		<div class="modal fade" role="dialog" id="scrap_modal">
			<div class="modal-dialog modal-large" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="scrap">Scrap Material</h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>
		<!--stock check modal-->
		<div class="modal fade"  role="dialog" id="stock_modal">
			<div class="modal-dialog modal-large" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="stock_check">Stock Check</h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>
		<!--consumed modal-->
		<div class="modal fade"  role="dialog" id="consumed_modal">
			<div class="modal-dialog modal-large" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="consumed">Consumed</h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>
 		<div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-refresh fa-5x fa-spin"></i>
                        <h4>Processing...</h4>
                    </div>
                </div>
            </div>
        </div>
    	</div>





    	<div id="myDivty" class="lodar-main" style="display: none;">
         <div class="lodar-ineer"><i class="fa fa-refresh fa-5x fa-spin"></i></div>
         <div class="blck">
         	
         </div>
    	</div>

		<!--move modal-->
		<div class="modal fade"  role="dialog" id="move_modal">
		  <div class="modal-dialog modal-large" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="move">Move </h4>
			  </div>
			 <div class="modal-body-content"></div>
			</div>
		  </div>
		</div>	
		<!--half full book modal-->
		<div class="modal fade"  role="dialog" id="book_modal">
			<div class="modal-dialog modal-large" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="book">Half/Full book </h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>	
		<!--Material conversion  modal-->
		<div class="modal fade" role="dialog" id="material_conversion">
			<div class="modal-dialog modal-large" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="book">Material Conversion</h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>
	<div id="inventory_add_modal" class="modal fade in"  class="modal fade in"  role="dialog" style="overflow:auto;" id="">
	<div class="modal-dialog modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Listing</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>

	<!--Scrap modal-->
		<div class="modal fade" role="dialog" id="rejected_modal">
			<div class="modal-dialog modal-large" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="scrap">Rejected Modal</h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>
		
		
		
<div id="challan_add_modal" class="modal fade in"  role="dialog">       
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Third Party Inventory Detail</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>	
</div>	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
  
    var tabs6 = null;
  
    $(document).ready(function(){
      
      
      tabs6 = $('#tabs6').scrollTabs();
      
    });
  </script>
<?php $this->load->view('common_modal'); ?>		
	
	
	
	
	
	
	
	