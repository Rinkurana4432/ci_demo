<div class="x_content">
<?php
if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}
?>
<?php 
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
<div class="stik">		
<form action="<?php echo base_url(); ?>crm/price_list" method="post" enctype="multipart/form-data" style="margin-top: 54px;">
   <!--  <div class="col-md-3">
	  <label class="col-md-2" style="padding:8px;">Product Name</label>
		<div class="col-md-10">
		<input type="text" name="pro_name" class="optional form-control col-md-7 col-xs-12" data-validate-length-range="0" > 
		</div>
    </div> -->

	<div class="col-md-3">
	  <label class="col-md-2" style="padding:8px;">Product SKU</label>
		<div class="col-md-10">
		<input type="text" name="pro_sku" class="optional form-control col-md-7 col-xs-12" data-validate-length-range="0" > 
		</div>
    </div>
	
	<div class="col-md-3">
	   <label class="col-md-2" style="padding:8px;">Customer Type</label>
		<div class="col-md-10">
		<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="customer_type" data-id="types_of_customer" data-key="id" data-fieldname="type_of_customer" data-where="created_by_cid = <?php echo $this->companyGroupId; ?> AND active_inactive = 1" width="100%" tabindex="-1" aria-hidden="true">
			<option value="">Select Option</option>
		</select> 
		</div>
    </div>
		<div class="col-md-3">
		<input type="submit" class="form-control col-md-12" name="importe" value="Filter" />
		</div>
		<div class="col-md-3">
		<div class="btn-group" role="group" aria-label="Basic example">
           <a href="<?php echo base_url(); ?>crm/price_list" class="Reset-btn btn btn-success">
        Reset
         </a>     
		</div>
</form>	
</div>
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	        <form class="form-search" method="post" action="<?= base_url() ?>inventory/uom_list">
			<div class="col-md-12">	
	  		</div>
	  </div>
	<div class="row hidde_cls export_div">
				<div class="col-md-12">
				<div class="col-md-3 datePick-right">
					<!-- <button type="button" class="btn btn-success add_crm_tabs addBtn" data-toggle="modal" id="add" data-id="add_leads_source"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button> -->
              	</div>		
				</div>
	</div>
	<p class="text-muted font-13 m-b-30"></p> 
<div id="print_div_content">		
            <!---------- datatable-buttons ------------->
<table id="" style="width:100%;margin-top: 44px;" class="table table-striped table-bordered account_index" data-id="account">
				<thead>
					<tr>
						<th scope="col">S.No.</th>
						<th scope="col">Product SKU</th>
						<th scope="col">Customer Type</th>
						<th scope="col">Selling Price</th>
						<th scope="col">Cost Price</th>	
						<th scope="col">MOU Price</th>
						<th scope="col">MRP Price</th>
						<th scope="col">From</th>
						<th scope="col">To</th>
						<th scope="col">Created By</th>
					</tr>
			</tr>
		</thead>
		<tbody>
		   <?php if(!empty($price_list)){
		   	#pre($price_list);
		   	#die;
		   	$i = 1;
						foreach($price_list as $pricelist){		
					
					#$statusChecked = $industrydata['active_inactive']==1?'checked':'';
					//$statusChecked = "";			
					$action = '';
										$createdBYY =  getNameById('user_detail', $pricelist['created_by'],'u_id');
										$crtd_by_name = !empty($createdBYY)?$createdBYY->name:'Others';	
										$tyu = getNameById('types_of_customer',$pricelist['customer_type'], 'id');
										$cutmrtyp = !empty($tyu) ? $tyu->type_of_customer : '-';
										#$action = '<input type="checkbox" class="js-switch change_status_uom"  data-switchery="true" style="display: none;" value="'.$industrydata['active_inactive'].'" 
										#data-value="'.$industrydata['id'].'"  '.$statusChecked .'>';
										#$action .= '<a href="javascript:void(0)" id="'.$industrydata['id'].'" data-id="add_leads_source" data-tooltip="Edit" class="add_crm_tabs btn btn-edit  btn-xs"><i class="fa fa-pencil"></i>  </a>';	
									

			   echo "<tr>
						<td data-label='SNo:'>".$i++."</td>
						<td data-label='product_sku:'>".$pricelist['product_sku']."</td>
						<td data-label='Customer type:'>".$cutmrtyp."</td>
						<td data-label='Customer type:'>".$pricelist['selling_price']."</td>
						<td data-label='Cost Price:'>".$pricelist['cost_price']."</td>
						<td data-label='Cost Price:'>".$pricelist['mou_price']."</td>
						<td data-label='Cost Price:'>".$pricelist['mrp_price']."</td>
						<td data-label='Cost Price:'>".$pricelist['from_date']."</td>
						<td data-label='Cost Price:'>".$pricelist['to_date']."</td>
						<td data-label='Action:'>".$crtd_by_name."</td>	
					</tr>";
				}
		   } ?>
		</tbody>                   
	</table>
    <?php #echo $this->pagination->create_links(); ?>	
	</div>
</div>
<script>
var measurementUnits = '';
</script>
