<div class="col-md-12 col-sm-12 col-xs-12">				
 <table id="unpaid_invoicesss" class="table table-striped table-bordered" data-id="account">
		<thead>
			<tr>
				<th>Id</th>
				<th>Material</th>
				<th>Buyer's Order No.</th>
				<th>Email.</th>
				<th>Party Name</th>
				<th>Sale Ledger</th>
				<th>Terms of Delivery</th>
				<th>Grand Total</th>
				<th>Total Tax</th>
				<th>Created On</th>				
				
			</tr>
		</thead>
		<tbody>
		   <?php  if(!empty($invoice_details_unpaid)){
			  foreach($invoice_details_unpaid as $invoice){ 
					$material_id_datas = json_decode($invoice['descr_of_goods'],true);
					if($material_id_datas == ''){
						
					}else{
						$material_names = '';
						foreach($material_id_datas  as $matrial_new_id){
							$material_id_get = $matrial_new_id['material_id'];
							@$material_name = ($material_id_get!=0)?(getNameById('material',$material_id_get,'id')->material_name):'';
							@$material_names .= $material_name.',';
						
						}
					}
					
					$party_name = getNameById('ledger',$invoice['party_name'],'id');
					$sale_ledger_name = getNameById('ledger',$invoice['sale_ledger'],'id');
					
				//pre($invoice);
					
				echo "<tr>
					<td>".$invoice['id']."</td>
					<td>".@$material_names."</td>  
					<td>".$invoice['buyer_order_no']."</td>  
					<td>".$invoice['email']."</td>
					<td><span style='font-size: 13px;text-transform: capitalize;font-weight:bold;'>".$party_name->name."</span></td>
					<td><span style='font-size: 13px;text-transform: capitalize;font-weight:bold;'>".@$sale_ledger_name->name."</span></td>
					<td>".$invoice['terms_of_delivery']."</td>
					<td>".$invoice['total_amount']."</td>
					<td>".$invoice['totaltax_total']."</td>
					<td>".date("j F , Y", strtotime($invoice['created_date']))."</td>	
					
				</tr>";
				
			   }
		   }else{
			   echo '<tr><td colspan="11"><b><center>No Unpaid Invoices</center> </b></td></tr>';
		   }
	   ?>
		</tbody> 
	<?php  if(!empty($invoice_details_unpaid)){	
	 echo "<tr>
		<td colspan='7'><center><b>Total</b></center></td>
		<td class='g_ttl' ></td>
		<td class='tax_ttl' colspan='2'></td></tr>";
	} ?>	
	</table>	
	
 </div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
	<div class="form-group">
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>
