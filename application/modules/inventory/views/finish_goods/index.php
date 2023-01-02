
<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-info">                            
			<?php echo $this->session->flashdata('message');?> 
		</div>                        
	<?php }
?>
<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
   <div class="Filter Filter-btn2"> 
           <form class="form-search" method="post" action="<?= base_url() ?>inventory/finish_goods">
				<div class="col-md-6">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="ace-icon fa fa-check"></i>
						</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,JobCard,Product Name" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="inventory/finish_goods">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
                        <a href="<?php echo base_url(); ?>inventory/finish_goods"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
			</div>
		</form>	
				<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>inventory/finish_goods">
					<input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
				</form>	
				<button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
		<div id="demo" class="collapse">
			<div class="col-md-3 col-xs-12 col-sm-6 datePick-left">                 
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
				<form action="<?php echo base_url(); ?>inventory/finish_goods" method="get" id="date_range">	
					 <input type="hidden" value='' class='start_date' name='start'/>
					 <input type="hidden" value='' class='end_date' name='end'/>
				</form>	
			</div>
	  </div>
   </div>
</div>
	<div class="row hidde_cls">
		<div class="col-md-12  export_div">
			
			
		<div class="btn-group"  role="group" aria-label="Basic example">
		    <?php if($can_add) { 
					echo '<button type="buttton" class="btn btn-info inventory_tabs addBtn" id="finish_add" data-toggle="modal" data-id="finish_goods">Add</button>';
				} 
			?>
			<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
			<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
				<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" id="export-menu">
					<li id="export-to-excel"><a href="javascript:void(0);">Export to excel</a></li>
					<li id="export-to-csv"><a href="javascript:void(0);">Export to csv</a></li>
					<li id="export-to-blank-excel"><a href="javascript:void(0);">Export to Blank Excel</a></li>
				</ul>
			</div>
		</div>	
		<div class="col-md-3 col-xs-12 col-sm-6 datePick-right">
			<form action="<?= site_url() ?>inventory/finish_goods" method="get" id="export-form">
				<input type="hidden" value='' id='hidden-type' name='ExportType'/>
				<input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
				<input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
                <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
			</form>
		</div>
		
		<!--form action="<?php //echo base_url(); ?>inventory/finish_goods" method="post" >
				<input type="hidden" value='<?php //echo $_POST['start']; ?>' class='start_date' name='start'/>
				<input type="hidden" value='<?php //echo $_POST['end']; ?>' class='end_date' name='end'/>
					<div class="row hidde_cls filter1 progress_filter">
							<div class="col-md-12">
								<div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
									<select name="company_unit" class="form-control company_unit">
										<option value=""> Select Category </option>
											<?php
											/*if(!empty($company_unit_adress) ){
												foreach($company_unit_adress as $companyAdress){
												$getAddress = $companyAdress['address'];
												$getDecodeAddress = json_decode($getAddress);
												foreach($getDecodeAddress as $fetchAddress){
													$address = $fetchAddress->address;
													
												
											?>
											<option value="<?php echo $address; ?>"><?php echo $address; ?></option>	

											<?php }} }*/ ?>			
									</select>
								</div>
								<input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="purchase/purchase_indent" disabled="disabled">
							</div>
				</div>
			</form-->
		
		</div>
		
	</div>	
	<p class="text-muted font-13 m-b-30"></p>
	<input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">
	<div id="print_div_content">
    <!---------- datatable-buttons    ---------->
   
		<table id="" style="margin-top:40px;" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
			<thead>
				<tr>
					<th scope="col">Id
      <span><a href="<?php echo base_url(); ?>inventory/finish_goods?sort=asc" class="up"></a>
	<a href="<?php echo base_url(); ?>inventory/finish_goods?sort=desc" class="down"></a></span> </th>
					
					<th scope="col">Job card Detail
      <span><a href="<?php echo base_url(); ?>inventory/finish_goods?sort=asc" class="up"></a>
	<a href="<?php echo base_url(); ?>inventory/finish_goods?sort=desc" class="down"></a></span></th>
<!--
					<th scope="col">Scrap Qty</th>
					<th scope="col">Scrap Material Name</th>
-->
					<th scope="col">Voucher Date</th>
					<th scope="col">Acknowledge By</th>
					<th scope="col">Created By</th>
					<th scope="col">Acknowledge Date</th>

					<th scope="col">Created Date</th>

					<th scope="col">Action</th>					
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($finish_goods)){	
					#
					foreach($finish_goods as $finish_good){
						
						//pre($finish_goods);

						
						$quotCreatedBy = ($finish_good['created_by']!=0)?(getNameById('user_detail',$finish_good['created_by'],'u_id')):'';
            							$createdByName = (!empty($quotCreatedBy))?$quotCreatedBy->name:'';		
					$scrap_material_name = getNameById('material',$finish_good['material_scrap_id'],'id');	
					
				?>
				<tr>
					<td data-label='Id:'><?php echo $finish_good['id']; ?></td>
					
					
						<td data-label='Job card Detail:'>
						<!-------- datatable-buttons ----------->
						
						<?php
								$jobCardDetail= json_decode($finish_good['job_card_detail']);
									if(!empty($jobCardDetail)){
										foreach($jobCardDetail as $job_card){
											if(!empty($job_card->material_id)){
											@$material_detail_count = count($job_card->material_id);
											}
										@$jobCardname = getNameById('job_card',$job_card->job_card_no,'id')->job_card_product_name;
										$wrkordr = getNameById('work_order',$job_card->work_order_id,'id');
									if($material_detail_count >0){
										$materialName = getNameById('material',$job_card->material_id,'id')->material_name;
										$ww =  getNameById('uom', $job_card->uom,'id');
										$uom = !empty($ww)?$ww->ugc_code:'';
											$output[] = array(
												'id'=>$finish_good['id'],
												'JobCard' => $jobCardname,
												'Product Name' =>$materialName,
												'Uom' => $uom,
												'Output'=>$job_card->output,
											);
											
											
											
											//}
													
										 }
									 }		
								
								} 

								?>
							
						<a href="javascript:void(0);" id="<?php echo $finish_good['id']; ?>" data-id="fg_Matview" data-tooltip="View Detail" class="inventory_tabs add-machine "><?php if(!empty($jobCardname)){echo $jobCardname;}else{echo "";}?></a></td>
<!--
						<td data-label='Scrap Qty:'><?php echo $finish_good['scrap_qty']; ?></td>
						<td data-label='Scrap Material Name:'><?php if(!empty($scrap_material_name)){echo $scrap_material_name->material_name; } else{ echo "";}?></td>
-->
						<th data-label='Voucher Date:'><?php if(!empty($finish_good['voucher_date'])){  echo date("j F , Y", strtotime($finish_good['voucher_date']));}else{echo "";} ?></th>
						<th data-label='Acknowledge By:'><?php echo $finish_good['aknowlwdge_by']; ?></th>
						<th data-label='Created By:'><?php echo $createdByName; ?></th>
						<th data-label='Acknowledge Date:'><?php echo $finish_good['acknowledge_date']; ?></th>
						
						<th data-label='Created Date:'><?php echo date("j F , Y", strtotime($finish_good['created_date'])); ?></th>
						<th  data-label='Action:'><button id="<?php echo $finish_good['id']; ?>" data-id="fg_acknowledgedate" data-tooltip="Acknowledge" class="btn btn-xs inventory_tabs add-machine add-simi"><i class="fa fa-calendar" aria-hidden="true"></i></button>

							<button id="<?php echo $finish_good['id']; ?>" data-id="fg_view" data-tooltip="View" class="btn btn-xs inventory_tabs add-machine add-simi"><i class="fa fa-eye" aria-hidden="true"></i></button>
						</th>		
				</tr>
				<?php }$data3  = $output;	
										export_csv_excel($data3);}?>
			</tbody>                   
		</table> <?php echo $this->pagination->create_links(); ?>	
		 <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
	</div>
</div>
<div id="printView">
	<div id="inventory_add_modal" class="modal fade in" role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Finish Goods</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
</div>				
