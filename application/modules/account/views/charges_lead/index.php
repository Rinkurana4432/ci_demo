<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	         <form class="form-search" method="get" action="<?= base_url() ?>account/charges_lead">
			<div class="col-md-6">
            	<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,particulars" name="search" id="search" value="<?php if(!empty($_GET['search'])) echo $_GET['search'];?>" data-ctrl="account/charges_lead">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
						 <a href="<?php echo base_url(); ?>account/charges_lead"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
                </div>
			</form>	  
            <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>account/charges_lead">
			<input type="hidden" name="order" id="order" value="<?php if($_POST['order']==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			</form>
	  </div>
</div>
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
<div class="col-md-12 export_div">
		
			<div class="btn-group"  role="group" aria-label="Basic example">
	<?php if($can_add) {
		echo '<button type="button" class="btn btn-success addBtn add_charges_tabs_account" data-toggle="modal" id="add" data-id="add_charges"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
	} ?>
</div>
</div>
	<p class="text-muted font-13 m-b-30"></p>  
       
            <!-------------datatable-buttons--------->          
			
	<table id="" class="table table-striped table-bordered" data-id="account" style="margin-top:40px;">
		<thead>
			<tr>
				<th scope="col">Id
			<span><a href="<?php echo base_url(); ?>account/charges_lead?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/charges_lead?sort=desc" class="down"></a></span></th>
				<th scope="col">Particulars
		<span><a href="<?php echo base_url(); ?>account/charges_lead?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/charges_lead?sort=desc" class="down"></a></span></th>
				<!--th>HSN/SAC</th-->
				<th scope="col">Ledger Name
		<span><a href="<?php echo base_url(); ?>account/charges_lead?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/charges_lead?sort=desc" class="down"></a></span></th>
				<th scope="col">Amount Charges</th>
				<th scope="col">Type Charges</th>
				<th scope="col">Created By</th>
				<th scope="col">Edited By</th>
				<th scope="col">created On</th>				
				<th scope="col">Action</th>   
			</tr>
		</thead>
		<tbody>
		   <?php  if(!empty($charge_lead_Datas)){
			   foreach($charge_lead_Datas as $charge_lead_Data){ 
			  
			   $action = '';
			  // pre($charge_lead_Data);
			 
				if($can_edit) { 
					$created_by_name = 	getNameById('user_detail',$charge_lead_Data['created_by_uid'],'u_id')->name;
					$action .=  '<a href="javascript:void(0)" id="'. $charge_lead_Data["id"] . '" data-id="add_charges" class="add_charges_tabs_account btn btn-view btn-xs" data-tooltip="Edit" id="' . $vouchers["id"] . '"><i class="fa fa-pencil"></i></a>';
					//$action .=  '<a href="javascript:void(0)" id="'. $charge_lead_Data["id"] . '" data-id="voucher_view" class="add_voucher_tabs btn btn-warning btn-xs" id="' . $vouchers["id"] . '"><i class="fa fa-eye"></i> View </a>';
					}
					if($can_delete) { 
						$action = $action.'<a href="javascript:void(0)" data-tooltip="delete" class="delete_listing btn btn-danger  btn btn-info btn-xs" data-href="'.base_url().'account/deleteCharges_leads/'.$charge_lead_Data["id"].'"><i class="fa fa-trash"></i></a>';
					}
					$edited_by = ($charge_lead_Data['edited_by']!=0)?(getNameById('user_detail',$charge_lead_Data['edited_by'],'u_id')->name):'';
					$ledger_name = ($charge_lead_Data['ledger_id']!=0)?(getNameById('ledger',$charge_lead_Data['ledger_id'],'id')->name):'';
					if($charge_lead_Data['amount_of_charges'] == 'absoluteamount'){
						$amoutn_charge = 'Absolute Amount';
					}else{
						$amoutn_charge = $charge_lead_Data['amount_of_charges'];
					}
					$ledger_Data = getNameById('ledger',$charge_lead_Data['ledger_id'],'id');
					
				
				echo "<tr>
					<td data-label='id:'>".$charge_lead_Data['id']."</td>
					<td data-label='Particulars:'>".$charge_lead_Data['particular_charges']."</td>  
					<td data-label='Ledger Name:'>".$ledger_Data->name."</td>  
					<td data-label='Amount Charges:' style='text-transform:capitalize;'>".$amoutn_charge."</td>
					<td data-label='Type Charges:' style='text-transform:capitalize;'>".$charge_lead_Data['type_charges']."</td>
					<td data-label='Created By:'><a href='".base_url()."users/edit/".$charge_lead_Data['created_by_uid']."' target='_blank'>".$created_by_name."</a></td>	
					<td data-label='Edited By:'><a href='".base_url()."users/edit/".$charge_lead_Data['edited_by']."' target='_blank'>".$edited_by."</a></td>	
					<td data-label='created On:'>".date("j F , Y", strtotime($charge_lead_Data['created_date']))."</td>	
					<td data-label='action:' >".$action."</td>	
				</tr>";
				}
		   }
	   ?>
		</tbody>                   
	</table>
    	<?php echo $this->pagination->create_links(); ?>	
		<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;"><?php echo $result_count; ?></span></div>
</div>

<div id="charges_add_modal_account" class="modal fade in"  role="dialog">  
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Charges  Head</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
<?php $this->load->view('common_modal'); ?>