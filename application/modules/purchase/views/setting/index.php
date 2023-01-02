 
<div class="x_content">

	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
	<?php if($can_add) {
		echo '<button type="button" class="btn edit-end-btn add_charges_tabs" data-toggle="modal" id="add" data-id="add_charges">Add</button>';
	} ?>
	<p class="text-muted font-13 m-b-30"></p>                   
	<table id="datatable-buttons" class="table table-striped table-bordered" data-id="account">
		<thead>
			<tr>
				<th>Id</th>
				<th>Particulars</th>
				<th>Amount Charges</th>
				<th>Type Charges</th>
				<th>Created By</th>
				<th>Edited By</th>
				<th>created On</th>				
				<th>Action</th>   
			</tr>
		</thead>
		<tbody>
		   <?php  if(!empty($other_charges)){
			   foreach($other_charges as $charges_Data){ 
			  
			   $action = '';
			  
				if($can_edit) { 
					$created_by_name = 	getNameById('user_detail',$charges_Data['created_by_uid'],'u_id')->name;
					$action .=  '<a href="javasSearch:cript:void(0)" id="'. $charges_Data["id"] . '" data-id="add_charges" class="add_charges_tabs btn btn-edit btn-xs" id="' . $vouchers["id"] . '"><i class="fa fa-pencil"></i>  </a>';
					//$action .=  '<a href="javascript:void(0)" id="'. $charge_lead_Data["id"] . '" data-id="voucher_view" class="add_voucher_tabs btn btn-warning btn-xs" id="' . $vouchers["id"] . '"><i class="fa fa-eye"></i> View </a>';
					}
					if($can_delete) { 
						$action = $action.'<a href="javascript:void(0)" class="delete_listing btn btn-delete btn btn-info btn-xs" data-href="'.base_url().'purchase/deleteCharges_leads/'.$charges_Data["id"].'"><i class="fa fa-trash"></i></a>';
					}
					$edited_by = ($charges_Data['edited_by']!=0)?(getNameById('user_detail',$charges_Data['edited_by'],'u_id')->name):'';
					$ledger_name = ($charges_Data['ledger_id']!=0)?(getNameById('ledger',$charges_Data['ledger_id'],'id')->name):'';
					if($charges_Data['amount_of_charges'] == 'absoluteamount'){
						$amoutn_charge = 'Absolute Amount';
					}else{
						$amoutn_charge = $charges_Data['amount_of_charges'];
					}
						
				
				
				echo "<tr>
					<td>".$charges_Data['id']."</td>
					<td>".$charges_Data['particular_charges']."</td>  
					<td style='text-transform:capitalize;'>".$amoutn_charge."</td>
					<td style='text-transform:capitalize;'>".$charges_Data['type_charges']."</td>
					<td><a href='".base_url()."users/edit/".$charges_Data['created_by_uid']."' target='_blank'>".$created_by_name."</a></td>	
					<td><a href='".base_url()."users/edit/".$charges_Data['edited_by']."' target='_blank'>".$edited_by."</a></td>	
					<td>".date("j F , Y", strtotime($charges_Data['created_date']))."</td>	
					<td>".$action."</td>	
				</tr>";
				}
		   }
	   ?>
		</tbody>                   
	</table>
</div>

<div id="charges_add_modal" class="modal fade in"  role="dialog">  
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Add Charges</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
