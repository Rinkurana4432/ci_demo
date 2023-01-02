<div class="col-md-12 col-sm-12 col-xs-12">				
   <table id="jobs" class="table table-striped table-bordered">
   
   
		<thead>
			<tr>
				<th>Id</th>
				<th>Supplier Name</th>
				<th>Party Name</th>
				<th>Vehicle Registration Number</th>
				<th>Ifsc Code</th>
				<th>GSTIN</th>
				<th>Grand Total</th>
				<th>Total Tax</th>
				<th>Bill Add Date</th>
				
			</tr>
		</thead>
		<tbody>
		    <?php  
			setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
			if(!empty($purchase_data)){
			   foreach($purchase_data as $purchase_datas){ 
			 	$supplier_data = getNameById('ledger',$purchase_datas['supplier_name'],'id');
					if($purchase_datas['party_name'] != '0'){
						$ledger_name = getNameById('ledger',$purchase_datas['party_name'],'id');
						$ledger_name->name;
					}else{
						@$ledger_name->name = '';
					}
					
					$billDAte = date("j F , Y", strtotime($purchase_datas['date']));
					$edited_by = ($purchase_datas['edited_by']!=0)?(getNameById('user_detail',$purchase_datas['edited_by'],'u_id')->name):'';
					
					if($purchase_datas['pay_or_not'] =='1'){
						$paid_or_not =  'Paid';
					}else{
						$paid_or_not = 'Not Paid';
					}
					
					if($purchase_datas['vehicle_reg_no']==''){
						$purchase_datas['vehicle_reg_no'] = 'N/A';
					}
					if($purchase_datas['ifsc_code']==''){
						$purchase_datas['ifsc_code'] = 'N/A';
					}
					if($purchase_datas['gstin']==''){
						$purchase_datas['gstin'] = 'N/A';
					}
					
				echo "<tr>
					<td>".$purchase_datas['id']."</td>
					<td><span style='font-size: 13px;text-transform: capitalize;font-weight:bold;'>".$supplier_data->name."</span></td>
					<td><span style='font-size: 13px;text-transform: capitalize;font-weight:bold;'>".$ledger_name->name."</span></td>
					<td>".$purchase_datas['vehicle_reg_no']."</td>  
					<td>".$purchase_datas['ifsc_code']."</td>
					<td>".$purchase_datas['gstin']."</td>
					<td>".money_format('%!i',$purchase_datas['total_amount'])."</td>
					<td>".money_format('%!i',$purchase_datas['totaltax_total'])."</td>
					<td>".$billDAte."</td>
				</tr>";
			 }
			  //
				
				
		   }else{
			   echo '<tr><td colspan="9"><b><center>No Unpaid Bills</center> </b></td></tr>';
		   }
	   ?>
		</tbody>
	<?php if(!empty($purchase_data)){ 
	echo "<tr>
		<td colspan='6'><center><b>Total</b></center></td>
		<td class='g_ttl' ></td>
		<td class='tax_ttl' colspan='2'></td>
	</tr>";
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

