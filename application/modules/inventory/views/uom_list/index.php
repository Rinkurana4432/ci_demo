<div class="x_content">
<?php
if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}

 ?>
<div class="col-md-12 col-xs-12 for-mobile">
   <div class="Filter Filter-btn2">
          <form class="form-search" method="post" action="<?= base_url() ?>inventory/uom_list">
	<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,Quantity,Quantity Type" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="inventory/uom_list">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>	
              <a href="<?php echo base_url(); ?>inventory/uom_list"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
</div>
			</form>	
				<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>inventory/uom_list">
			<input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			</form>
   </div>
 </div>

	<div class="row hidde_cls export_div">

		 

				<div class="col-md-12"><?/**
					<div class="col-md-3 datePick-left">  
					<input type="hidden" value='termscond' id="table" data-msg="Terms & Conditions" data-path="crm/crmterms_condtn"/>


					<input type="hidden" value='termscond' id="favr" data-msg="Terms & Conditions" data-path="crm/crmterms_condtn" favour-sts="1"/>              
				<fieldset>
					<div class="control-group">
					  <div class="controls">
						<div class="input-prepend input-group">
						  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						<?php /*  <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="" data-table="crm/termscond"> */?>
				<?php /**		  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="crm/crmterms_condtn">
						</div>
					  </div>
					</div>
				</fieldset>
			</div><?php **/?>

						
				<div class="btn-group">
					
					<button type="button" class="btn btn-success inventory_tabs addBtn" data-toggle="modal" id="add" data-id="inventory_uom_type"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>
              </div>	
					
				</div>
			</div>
	<p class="text-muted font-13 m-b-30"></p> 
<div id="print_div_content">	
	
			
            <!---------- datatable-buttons ------------->
<table id="" class="table table-striped table-bordered account_index" data-id="account" style="margin-top:40px;">
				<thead>
			<tr>
				<th scope="col">Id
     <span><a href="<?php echo base_url(); ?>inventory/uom_list?sort=asc" class="up"></a>
	<a href="<?php echo base_url(); ?>inventory/uom_list?sort=desc" class="down"></a></span></th>
						<th scope="col">UOM Quantity
       <span><a href="<?php echo base_url(); ?>inventory/uom_list?sort=asc" class="up"></a>
	<a href="<?php echo base_url(); ?>inventory/uom_list?sort=desc" class="down"></a></span></th>
						<th scope="col">UOM Quantity Type
        <span><a href="<?php echo base_url(); ?>inventory/uom_list?sort=asc" class="up"></a>
	<a href="<?php echo base_url(); ?>inventory/uom_list?sort=desc" class="down"></a></span></th>
						<th scope="col">UQC code</th>
						<th scope="col">Created by</th>
						<th scope="col">Created Date</th>	
						<th scope="col">Action</th>
					</tr>
			</tr>
		</thead>
		<tbody>
		   <?php if(!empty($uom_list1)){
						foreach($uom_list1 as $uomlist){		
					
					$statusChecked = $uomlist['active_inactive']==1?'checked':'';
					//$statusChecked = "";			
					$action = '';


					

									$createdBYY =  getNameById('user_detail', $uomlist['created_by'],'u_id');

									$crtd_by_name = !empty($createdBYY)?$createdBYY->name:'Others';	
				 		
							$action = '<input type="checkbox" class="js-switch change_status_uom"  data-switchery="true" style="display: none;" value="'.$uomlist['active_inactive'].'" 
										data-value="'.$uomlist['id'].'"  '.$statusChecked .'>';

										$action .= '<a href="javascript:void(0)" id="'.$uomlist['id'].'" data-id="inventory_uom_type" data-tooltip="Edit" class="inventory_tabs btn btn-edit  btn-xs"><i class="fa fa-pencil"></i>  </a>';	
									
						
							//$action .= '<button type="button" data-process-id="'.$customer_Type["id"].'" id="'.$customer_Type["id"].'" data-id="customer_Type" class="btn btn-primary add_crm_tabs" data-toggle="modal">Edit</button>';
						
						
						/*if($process_Type['used_status'] == 1){
							$action = $action.'<a href="javascript:void(0)" class="
							btn btn-danger" data-href="'.base_url().'production/deleteProcessType/'.$process_Type["id"].'" disabled="disabled"><i class="fa fa-trash"></i></a>';
						}else{
							$action = $action.'<a href="javascript:void(0)" class="delete_listing
							btn btn-danger" data-href="'.base_url().'production/deleteProcessType/'.$process_Type["id"].'" ><i class="fa fa-trash"></i></a>';
						}*/

					echo "<tr>
						<td data-label='Id:'>".$uomlist['id']."</td>
						<td data-label='UOM Quantity:'>".$uomlist['uom_quantity']."</td>
						<td data-label='UOM Quantity Type:'>".$uomlist['uom_quantity_type']."</td>
						<td data-label='UQC code:'>".$uomlist['ugc_code']."</td>
						<td data-label='Created by:'>".$crtd_by_name."</td>
						<td data-label='Created Date:'>".$uomlist['created_date']."</td>
						<td data-label='action:'>".$action."</td>	
					</tr>";
				}
		   } ?>
		</tbody>                   
	</table>
    <?php echo $this->pagination->create_links(); ?>	
	 <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
	</div>
</div>
<div id="inventory_add_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content" style="display:table;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">UOM List</h4>
			</div>
			<div class="modal-body-content" ></div>
		</div>
	</div>
</div>
<script>
var measurementUnits = '';

</script>
