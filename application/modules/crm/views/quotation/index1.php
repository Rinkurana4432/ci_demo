<div class="x_content">
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>		
			<div class="row hidde_cls  export_div">
				 
				<div class="col-md-12">
			<div class="col-md-3 datePick-left">    
			<input type="hidden" value='quotation' id="table" data-msg="Quotation" data-path="crm/quotation"/>     

			<input type="hidden" value='quotation' id="favr" data-msg="Quotation" data-path="crm/quotation" favour-sts="1"/>           
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
			<form action="<?php echo base_url(); ?>crm/quotation" method="post" id="date_range">	
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
		<form action="<?php echo base_url(); ?>crm/quotation" method="post" >
				<input type="hidden" value='1' name='favourites'/>
								
			 <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>

			</form>
							<button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
						</div>
					
					<div class="col-md-3 col-xs-12 datePick-right">
						<?php if($can_add) {
								echo '<button type="button" class="btn btn-primary add_crm_tabs addBtn" data-toggle="modal" id="add" data-id="quotation_edit">Add</button>';
						} ?>			
						<form action="<?php echo site_url(); ?>crm/quotation" method="post" id="export-form">
							<input type="hidden" value='' id='hidden-type' name='ExportType'/>
							<input type="hidden" value='' class='start_date' name='start'/>
							<input type="hidden" value='' class='end_date' name='end'/>
						</form>
		           </div>
				</div>
			</div>
	<p class="text-muted font-13 m-b-30"></p> 
	<div id="print_div_content">		
		<form class="form-search" method="post" action="<?= base_url() ?>crm/quotation/">
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
		<?php 	/* <table id="datatable-buttons" style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3"> */ ?>
		<table id="" style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3">
			<thead>
				<tr>
					<th>All<input id="selecctall" type="checkbox"></th>
					<?php /* <th>Id</th>
					<th>Account Name</th>
					<th>Contact Name</th> */ ?>
					<?php
					 foreach($sort_cols as $field_name => $field_display){ ?>
						<th><?php echo anchor('crm/quotation/'.$field_name.'/'.($sort_by == $field_name ? $sort_order : 'asc').'/'.$page, $field_display); ?></th>
				<?php }?>
					<th>Product</th>
					<th>Order Date</th>
					<th>Payment Terms</th>
					<th>Created By</th>
					<th>Created Date</th>
					<th class='hidde'>Action</th>
				</tr>
			</thead>
			<tbody>
		   <?php if(!empty($quotation)){
					foreach($quotation as $quot){ 
						
						$action = '';
						if($can_edit)	
						{

							$action =  '<a href="javascript:void(0)" id="'. $quot["id"] . '" data-id="quotation_edit" data-tooltip="Edit" class="add_crm_tabs btn btn-edit  btn-xs" id="' . $quot["id"] . '"><i class="fa fa-pencil"></i>  </a>';	
						#if($can_view)				 
							$action .=  '<a href="javascript:void(0)" id="'. $quot["id"] . '" data-id="quotation_view" data-tooltip="View" class="add_crm_tabs btn  btn-view  btn-xs" data-tooltip="View" id="' . $quot["id"] . '"><i class="fa fa-eye"></i>  </a>';
						}

						if($can_delete) { 
											$action = $action.'<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'crm/deletequotation/'.$quot["id"].'"><i class="fa fa-trash"></i></a>';
										}

						
						if($quot['save_status'] == 1)
						if($quot['converted_to_proinvc'] == 0 ){
								$action = $action.'<a href="javascript:void(0)" id="' . $quot["id"] . '" data-id="convert_to_pi" data-tooltip="Convert into Proforma Invoice" class="add_crm_tabs btn    btn-xs convert"  id="89"><img src="'.base_url().'/assets/modules/crm/uploads/convert.png"></a>';					
							 }
					
							if($quot['sale_ordr_converted'] == 0 ){
								$action = $action.'<a href="javascript:void(0)" id="' . $quot["id"] . '" data-id="convert_to_so" data-tooltip="Convert into Sale Order convert" class="add_crm_tabs btn  convert btn-xs"><img src="'.base_url().'/assets/modules/crm/uploads/convert.png"></a>';					
							 }

							$action = $action.'<a href="javascript:void(0)" id="'. $quot["id"] . '"data-id="AddSimilarQuot" data-tooltip="Add Similar Quotation" class="add_crm_tabs btn  add-machine  btn-xs"><i class="fa fa-clone" aria-hidden="true"></i></a>';
						
						$accountName = ($quot['account_id']!=0)?(getNameById('account',$quot['account_id'],'id')):'';
						$accountName = (!empty($accountName))?$accountName->name:'';						
						$contactName = ($quot['contact_id']!=0)?(getNameById('contacts',$quot['contact_id'],'id')):'';
						$contactName = (!empty($contactName))?($contactName->first_name.' '.$contactName->last_name):'';
						$draftImage = ($quot['save_status'] == 0)?('<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img src="'.base_url(). 'assets/images/draft.png"   class="img-responsive hidde"></a>'):'';
						
						$orderDate  = $quot['order_date']!=''?date("j F , Y", strtotime($quot['order_date'])):'';
						$validdate = $quot['valid_date']!=''?date("j F , Y", strtotime($quot['valid_date'])):'';
						
						
						echo "<tr>											   
											   		<td><input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox' data-ai=".$quot['account_id']."  value=".$quot['id'].">";
											   		if($quot['favourite_sts'] == '1'){
											   				echo "<input class='star' type='checkbox'  title='Mark Record' value=".$quot['id']."  checked = 'checked'><br/>";
											   				echo"<input type='hidden' value='quotation' id='favr' data-msg=''Quotation Unmarked' data-path='crm/quotation' favour-sts='0' id-recd=".$quot['id'].">";
											   		}else{
															echo "<input class='star' type='checkbox'  title='Mark Record' value=".$quot['id']."><br/>";
															echo"<input type='hidden' value='quotation' id='favr' data-msg='Quotation Marked' data-path='crm/quotation' favour-sts='1' id-recd =".$quot['id'].">";
											   		}
											   		
											   		echo "</td>
								<td>". $draftImage . $quot['id']."</td>
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
										</tr>
									</thead>
									<?php 
									if($quot['product'] !=''){
											$products = json_decode($quot['product']);
											foreach($products as $product){
												$quotCreatedBy = ($quot['created_by']!=0)?(getNameById('user_detail',$quot['created_by'],'u_id')):'';
												$createdByName = (!empty($quotCreatedBy))?$quotCreatedBy->name:'';
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
													</tr>";
											} 
										}
										echo "<tr><td colspan='7'>Total : ".$quot['total']."</td></tr>
											 <tr><td colspan='7'>Grand Total : ".$quot['grandTotal']."</td></tr>";
										echo "</table></td>
											<td>".$orderDate."</td>
											<td>".$quot['payment_terms']."</td>	
											<td>".$createdByName."</td>	
											<td>".date("j F , Y", strtotime($quot['created_date']))."</td>
											<td class='hidde'>".$action."</td>	


								</tr>";
				$output[] = array(
						  	'Account Name' => $accountName,
						   	'Contact Name' => $contactName,
						  	'Order Date' =>   $orderDate,
						   	'Valid Date' =>   $validdate,
						   	'Sub Total' =>    $quot['total'],
						   	'Total' =>        $quot['grandTotal'],
						   	'Payment Terms' =>$quot['payment_terms'],
						   	'Created By' =>   $createdByName,
						   	'Created Date' => date("d-m-Y", strtotime($quot['created_date'])),


						);	
				}
				$data3  = $output;
				
				export_csv_excel_quot($data3);
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
				<h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Quotation</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
</div>
<style type="text/css">
	
.similarbtn {
 background:transparent;
color:#169F85;
padding: 4px 52px;
border: 1px solid;
}
</style>
<script>
var measurementUnits = '<?php echo json_encode(measurementUnits()); ?>';

</script>


