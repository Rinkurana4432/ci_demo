<?php 
if($this->session->flashdata('message') != ''){ ?>                        
	<div class="alert alert-info col-md-6">                            
	<?php echo $this->session->flashdata('message');?> 
	</div>    
<?php
	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
 } ?>
 
<div class="x_content">

<div class="col-md-12 col-xs-12 for-mobile">

	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" class="active"><a href="#tab_inventory_listing" id="invetory_listing_tab" role="tab" data-toggle="tab" aria-expanded="true">Inventory Listing </a></li>
			<li role="presentation" class=""><a href="#wip_listing12" role="tab" id="wip_listing" data-toggle="tab" aria-expanded="false">WIP Inventory Listing </a></li>
			<li role="presentation" class=""><a href="#third_type_inventory_listing" role="tab" id="third_type_inv_listing_tab" data-toggle="tab" aria-expanded="false">Third Party Inventory Listing </a></li>
		</ul>
			
		<div id="myTabContent" class="tab-content">
		
			<div role="tabpanel" class="tab-pane fade active in" id="tab_inventory_listing" aria-labelledby="invetory_listing_tab">
			
			    <div class="form-group row">
					<div class="col-md-1 datePick-right">
						<!--form action="<?php //echo base_url(); ?>inventory/inventory_listing_and_adjustment_new" method="post"-->
						<form action="<?php echo base_url(); ?>inventory/stock" method="post">
							<input type="hidden" name="export" id="export" value="exportInventoryList">
							<input type="hidden" name="location_id" id="set_location" value="">
							<input type="hidden" name="sdate" id="sdateFilter" value="">
							<input type="hidden" name="stopDate" id="sdatestop" value="">
							<!--input type="submit" value="Export" class="btn btn-secondary dropdown-toggle btn-default"-->
						</form>			
					</div>
					
					<div class="col-md-1 datePick-right">
						<button type="button" id="clearAll" class="btn btn-view">
						<i class="fa fa-asterisk"></i>Clear All</button>
					</div>
					
					<!-- <div class="col-md-2 datePick-right">
						<select class="form-control" id="location" onchange="getInventoryDataByLocation(this.value)">
							<option value="0">All Location Wise</option>
							<?php //foreach($company_address as $companyAddress){ ?>
								<option value="<?php// echo $companyAddress['id']; ?>"><?php //echo $companyAddress['location']; ?></option>
							<?php //} ?>
						</select>
					</div> -->
					
					<div class="col-md-1 datePick-right">
						  <input type="text" name="sDate" id="ivDate" class="form-control" autocomplete="off" style="width:95px;" Placeholder="Date Wise">   
						 
					</div>
 
					<!--<div class="col-md-1 datePick-right">
						<button type="buttton" class="btn btn-infoaddBtn" id="clickStockCheckBtn">Stock Check</button>
					</div>-->
				</div>
				
				<p class="ee"></p>

				<div class="InventoryListDiv">
					<?php include('new_inventory_listing.php'); ?>
				</div>
			</div>
			
			
			<div role="tabpanel" class="tab-pane fade" id="third_type_inventory_listing" aria-labelledby="third_type_inv_listing_tab">
			    
			    <div class="form-group row">
            		<div class="col-md-1 datePick-right">
            			<div class="btn-group"  role="group" aria-label="Basic example">
            				<form action="<?php echo base_url(); ?>inventory/inventory_listing_and_adjustment_excel" method="post">
            					<input type="hidden" name="third_party" id="third_party" value="third_party_listing">
            					<input type="submit" value="Export" class="btn btn-secondary dropdown-toggle btn-default">
            				</form>			
            			</div>
            		</div>
            	</div>	
			    
				<div id="print_div_content">
				<table id="mytable2" class="table tblData table-striped table-bordered action-icons" data-order='[[0,"desc"]]' style="width:100%" border="1" cellpadding="3">
    				<thead>
    					<tr>
    						<th>Id</th>
    						<th>Challan Number</th>
    						<th>Party Name</th>
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
													<td>".sprintf('%01.2f',$materialData['rate'])."</td>";  //money_format('%!i',$materialData['rate'])
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
								echo "</table>
								
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
            	</table>
            		
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
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">??</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Listing</h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>
		<div id="challan_add_modal" class="modal fade in"  role="dialog">       
			<div class="modal-dialog modal-lg modal-large">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">??</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Third Party Inventory Detail</h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>	
</div>	
<!--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
var tabs6 = null;
$(document).ready(function(){
  tabs6 = $('#tabs6').scrollTabs();
});
</script>
<?php $this->load->view('common_modal'); ?>		
	
	
	
	
	
	
	
	