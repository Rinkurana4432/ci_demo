<div class="x_content">
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>	

	<?php //if(!empty($pis)){ ?>
			<div class="row hidde_cls  export_div">
				 
				<div class="col-md-12">
			<div class="col-md-3 datePick-left">      
				<input type="hidden" value='proforma_invoice' id="table" data-msg="Proforma Invoice" data-path="crm/proforma_invoice"/>  

				<input type="hidden" value='proforma_invoice' id="favr" data-msg="Proforma Invoice" data-path="crm/proforma_invoice" favour-sts="1"/>       
			<fieldset>
				<div class="control-group">
					<div class="controls">
						<div class="input-prepend input-group">
							<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							<?php /*<input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="" data-table="crm/proforma_invoice">*/?>
							<input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="crm/proforma_invoice">
						</div>
					</div>
				</div>
			</fieldset>
			<form action="<?php echo base_url(); ?>crm/proforma_invoice" method="post" id="date_range">	
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
							<form action="<?php echo base_url(); ?>crm/proforma_invoice" method="post" >
								<input type="hidden" value='1' name='favourites'/>
								 <input type="hidden" value='' class='start_date' name='start'/>
								 <input type="hidden" value='' class='end_date' name='end'/>
												
							 <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>

							</form>
                            <button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>




						</div>
					
					<div class="col-md-3 col-xs-12 datePick-right">
					
					    <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
								<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Import<span class="caret"></span></button>
									<ul class="dropdown-menu import-bar" role="menu" id="export-menu">
										<li ><form action="<?php echo base_url(); ?>crm/importpi" method="post" enctype="multipart/form-data">	
					
													<input type="file" class="form-control col-md-2" name="uploadFile" id="file" style="width: 70%">
													<input type="submit" class="form-control col-md-2" name="importe" value="Upload" style="width: 30%;" />

											</form></li>
									</ul>
							</div>
					
						<?php if($can_add) {
								echo '<button type="button" class="btn btn-primary add_crm_tabs addBtn" data-toggle="modal" id="add" data-id="proforma_invoice">Add</button>';
						} ?>			
						<form action="<?php echo site_url(); ?>crm/proforma_invoice" method="post" id="export-form">
							<input type="hidden" value='' id='hidden-type' name='ExportType'/>
							<input type="hidden" value='' class='start_date' name='start'/>
							<input type="hidden" value='' class='end_date' name='end'/>
						</form>
		           </div>
				</div>
			</div>
	<?php //} ?>	
	<p class="text-muted font-13 m-b-30"></p> 
	<div id="print_div_content">	
			<form class="form-search" method="post" action="<?= base_url() ?>crm/proforma_invoice/">
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
		<?php /* <table id="datatable-buttons" style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3"> */ ?>
		<table id="" style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3">
			<thead>
				<tr>
					<th>All<br><input id="selecctall" type="checkbox"></th>
					<?php /* <th>Id</th>
					<th>Proforma Invoice No.</th>
					<th>Account Name</th>
					<th>Contact Name</th> */ ?>
					<?php
					 foreach($sort_cols as $field_name => $field_display){ ?>
						<th><?php echo anchor('crm/proforma_invoice/'.$field_name.'/'.($sort_by == $field_name ? $sort_order : 'asc').'/'.$page, $field_display); ?></th>
					<?php }?>
					<th>Product</th>
					<th>Order Date</th>
					<th>Dispatch Date</th>
					<th>Payment Terms</th>
					<th>Created By</th>
					<th>Created Date</th>
					<th class='hidde'>Action</th>
				</tr>
			</thead>
			<tbody>
		   <?php if(!empty($pis)){
					foreach($pis as $pi){ 
					
					
					
					
						$action = '';
						if($can_edit)				 
							$action =  '<a href="javascript:void(0)" id="'. $pi["id"] . '" data-id="proforma_invoice" data-tooltip="Edit" class="add_crm_tabs btn btn-edit  btn-xs" id="' . $pi["id"] . '"><i class="fa fa-pencil"></i>  </a>';	
						#if($can_view)				 
							$action .=  '<a href="javascript:void(0)" id="'. $pi["id"] . '" data-id="proforma_invoice_view" data-tooltip="View" class="add_crm_tabs btn  btn-view  btn-xs" data-tooltip="View" id="' . $pi["id"] . '"><i class="fa fa-eye"></i>  </a>';
						
						if($can_delete) { 
											$action = $action.'<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'crm/deleteProformaInvoice/'.$pi["id"].'"><i class="fa fa-trash"></i></a>';
										}
						if($pi['save_status'] == 1)
							if($pi['sale_ordr_converted'] == 0 ){
								$action = $action.'<a href="javascript:void(0)" id="' . $pi["id"] . '" data-id="convertPiIntoSaleOrderview" data-tooltip="Convert into Sale Order" class="add_crm_tabs btn  convert  btn-xs"><img src="'.base_url().'/assets/modules/crm/uploads/convert.png"></a>';					
							 }
							 $action = $action.'<a href="javascript:void(0)" id="'. $pi["id"] . '"data-id="AddSimilarPI" data-tooltip="Add Similar Proforma Invoice" class="add_crm_tabs btn  add-machine  btn-xs"><i class="fa fa-clone" aria-hidden="true"></i></a>';
						$accountName = ($pi['account_id']!=0)?(getNameById('account',$pi['account_id'],'id')):'';
						$accountName = (!empty($accountName))?$accountName->name:'';						
						$contactName = ($pi['contact_id']!=0)?(getNameById('contacts',$pi['contact_id'],'id')):'';
						$contactName = (!empty($contactName))?($contactName->first_name.' '.$contactName->last_name):'';
						$draftImage = ($pi['save_status'] == 0)?('<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img src="'.base_url(). 'assets/images/draft.png"   class="img-responsive hidde"></a>'):'';
						
						$orderDate  = $pi['order_date']!=''?date("j F , Y", strtotime($pi['order_date'])):'';
						$dispatchDate  = $pi['dispatch_date']!=''?date("j F , Y", strtotime($pi['dispatch_date'])):'';
						
						
						
						
						echo "<tr>											   
											   		<td><input name='checkbox[]' class='checkbox1 checkbox[]' data-ai=".$pi['account_id']." type='checkbox'  value=".$pi['id'].">";
											   		if($pi['favourite_sts'] == '1'){
											   				echo "<input class='star' type='checkbox'  title='Mark Record' value=".$pi['id']."  checked = 'checked'><br/>";
											   				echo"<input type='hidden' value='proforma_invoice' id='favr' data-msg=''Proforma Invoice Unmarked' data-path='crm/proforma_invoice' favour-sts='0' id-recd=".$pi['id'].">";
											   		}else{
															echo "<input class='star' type='checkbox'  title='Mark Record' value=".$pi['id']."><br/>";
															echo"<input type='hidden' value='proforma_invoice' id='favr' data-msg='Proforma Invoice Marked' data-path='crm/proforma_invoice' favour-sts='1' id-recd =".$pi['id'].">";
											   		}
											   		
											   		echo "</td>


								<td>". $draftImage . $pi['id']."</td>
								<td>". $pi['pi_code']."</td>
								<td>".$accountName."</td>
								<td>".$contactName."</td>
								<td>";?>
									<table id="datatable-buttons" style="width:100%" class="table table-bordered product_index  bulk_action" data-id="user" border="1" cellpadding="3">
									<thead>
										<tr>
											<th>Product Name</th>
											<th>Quantity</th>
											<th>UOM</th>
											<th>Price</th>								
											<th>GST</th>								
											<th>Sub Total</th>								
											<th>Total</th>									
										</tr>
									</thead>
									<?php 
									if($pi['product'] !=''){
											$products = json_decode($pi['product']);


											//pre($pi['product']);


											//die;

											foreach($products as $product){
												$piCreatedBy = ($pi['created_by']!=0)?(getNameById('user_detail',$pi['created_by'],'u_id')):'';
												$createdByName = (!empty($piCreatedBy))?$piCreatedBy->name:'';
												

												//pre($product->product);

												$productDetail = getNameById('material',$product->product,'id');
											

												$materialName = !empty($productDetail)?$productDetail->material_name:'';
												$ww =  getNameById('uom', $product->uom,'id');
												$uom = !empty($ww)?$ww->ugc_code:'';

												echo "<tr>
														<td><h5>".$materialName.'</h5><br>'.(array_key_exists("description",$product)?$product->description:'')."</td>
														<td>".$product->quantity."</td>
														<td>".$uom."</td>
														<td>".$product->price."</td>
														<td>".$product->gst."</td>
														
														<td>".$product->individualTotal."</td>
														<td>".$product->individualTotalWithGst."</td>
													</tr>";
											} 
										}
										echo "<tr><td colspan='7'>Total : ".$pi['total']."</td></tr>
											 <tr><td colspan='7'>Grand Total : ".$pi['grandTotal']."</td></tr>";
										echo "</table></td>
											<td>".$orderDate."</td>
											<td>".$dispatchDate."</td>	
											<td>".$pi['payment_terms']."</td>	
											<td>".$createdByName."</td>	
											<td>".date("j F , Y", strtotime($pi['created_date']))."</td>
											<td class='hidde'>".$action."</td>	
								</tr>";
				$output[] = array(
							'Proforma Invoice' =>$pi['pi_code'],
							'Account Name' => $accountName,
						   	'Contact Name' => $contactName,
						  	'Order Date' =>   $orderDate,
						   	'Dispatch Date' =>$dispatchDate,
						   	'Sub Total' =>    $pi['total'],
						   	'Total' =>        $pi['grandTotal'],
						   	'Payment Terms' =>$pi['payment_terms'],
						   	'Created By' =>   $createdByName,
						   	'Created Date' => date("d-m-Y", strtotime($pi['created_date'])),
						);	
				}
				$data3  = $output;
				
				export_csv_excel_pi($data3);
		   } ?>
		</tbody>                   
	</table>
	<?php echo $showPage; 
	echo $paginglinks; ?>
	</div>
</div>
<div id="printThis">
<div id="crm_add_modal" class="modal fade in btnPrint"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title chng_lbl nxt_cls addtitle2" id="myModalLabel">Proforma Invoice</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
</div>
<script>
var measurementUnits = '<?php echo json_encode(measurementUnits()); ?>';

</script>
