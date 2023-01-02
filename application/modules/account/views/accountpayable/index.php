<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	       <form class="form-search" method="get" action="<?= base_url() ?>account/account_payable/">
				<div class="col-md-6">	<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,Name" name="search" id="search" value="<?php if(!empty($_GET['search'])) echo $_GET['search'];?>" data-ctrl="account/account_payable">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
						 <a href="<?php echo base_url(); ?>account/account_payable"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div></div>
			</form>	
				<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>account/account_payable/">
			<input type="hidden" name="order" id="order" value="<?php if($_POST['order']==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			</form>
	  </div>
</div>
<div class="export_div col-md-12 col-xs-12 col-sm-12">
   <div class="btn-group"  role="group" aria-label="Basic example">
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
	<?php 
	// if($can_add) {
		// echo '<button type="button" class="btn btn-success  addBtn addAccountGroup" data-toggle="modal" id="add"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
	// } 
	?>
	</div>
</div>
	<p class="text-muted font-13 m-b-30"></p>      
	
			<!---datatable-buttons--->
	<table id="" class="table  table-striped table-bordered account_group_index" data-id="account" style="margin-top: 45px;">
		<thead>
			<tr>
				<th scope="col">Id
	  <span><a href="<?php echo base_url(); ?>account/account_payable?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/account_payable?sort=desc" class="down"></a></span></th>
				<th scope="col">Name
		<span><a href="<?php echo base_url(); ?>account/account_payable?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/account_payable?sort=desc" class="down"></a></span></th>
				<th scope="col">Account Group</th> 
				<th scope="col">Closing Balance Credit</th>
				<th scope="col">Closing Balance Debit</th>	
				<th scope="col">Phone No.</th>
				<th scope="col" class='hidde'>Action</th>		
						
			</tr>
		</thead>
		<tbody>
		   <?php 
		
		   if(!empty($payable_Data)){
			   foreach($payable_Data as $val_data){ 
			    
			  	    $action = '';
			 		 $action .=  '<a href="javascript:void(0)" id="'. $val_data["id"] . '" data-id="'.$val_data['id'].'" data-type-transaction="invoice"  class="lager_rp_name btn btn-warning btn-xs" id="' . $val_data["id"] . '"><i class="fa fa-eye"></i> View Report </a>';

					 $action .=  '<a href="javascript:void(0)" id="'. $val_data["id"] . '" data-id="add_unpaid_PurchaseBill_dtl" class="add_purchase_unpaid_bill btn btn-success btn-xs" id="' . $val_data["id"]  . '"><i class="fa fa-eye"></i> View unpaid Bills</a>';
					 
					 //Calculate Closing Balance
							$amount_total = get_total_user_amount_debit('transaction_dtl',$val_data["id"],$this->companyGroupId);
							$amount_total_credit = get_total_user_amount_crdt('transaction_dtl',$val_data["id"],$this->companyGroupId);
							$ledger_details = get_closing_balance($val_data["id"],$this->companyGroupId);
								foreach($ledger_details as $ledger_dtls){
									if($ledger_dtls['openingbalc_cr_dr'] == 1 ){
										 	$leger_debit_ttl = $amount_total['sum(debit_dtl)'];
											$opening_balance =  $ledger_dtls['opening_balance'];
											$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
									    	$ledger_amt_aftr_calcu_cr = $leger_credit_ttl + $opening_balance;
											$ledger_amt_aftr_calcu_dr = $leger_debit_ttl;
										}
									if($ledger_dtls['openingbalc_cr_dr'] == 0 ){
										$leger_debit_ttl = $amount_total['sum(debit_dtl)'];
										$opening_balance =  $ledger_dtls['opening_balance'];
										$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
										$ledger_amt_aftr_calcu_dr = $leger_debit_ttl + $opening_balance;
										$ledger_amt_aftr_calcu_cr = $leger_credit_ttl;
									}
								}	
									if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									}
					//Calculate Closing Balance	
					 
					 
					$account_grp = 	getNameById('account_group',$val_data['account_group_id'],'id')->name;
					$state_nm = 	getNameById('state',$val_data['mailing_state'],'state_id')->state_name;
					$get_invoice_tbl_dtl = 	getNameById('invoice',$val_data['id'],'party_name');
					
				/*if($closing_bal != '' && $get_invoice_tbl_dtl->party_name !=''){*/
				echo "<tr>
					<td data-label='id:'>".$val_data["id"]."</td>
					
					 <td data-label='Name:'><a href='javascript:void(0)' id='".$val_data["id"] ."' data-id='ledger_view' data-toggle='modal' class='add_account_tabs'><span style='font-size: 13px;text-transform: capitalize;font-weight:bold;'  data-name='".$val_data['name']."'>".$val_data['name']."</span></a></td>  
					<td data-label='Account Group:'>".$account_grp."</td>";
					if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
					$closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
						
						echo '<td data-label="Closing Balance Credit:">'.money_format('%!i', $closing_bal).'</td>';//Credit
						echo '<td data-label="Closing Balance Credit:">0.00</td>';
					}else if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
						$closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
						 echo '<td data-label="Closing Balance Credit:">0.00</td>';
						 echo '<td data-label="Closing Balance Credit:">' .money_format('%!i',$closing_bal).'</td>';//Debit
						 
					}else{
						 echo '<td data-label="Closing Balance Debit:">0.00</td>';
						  echo '<td data-label="Closing Balance Debit:">0.00</td>';
					}
					  
			echo   "<td data-label='Phone:'>".$val_data['phone_no']."</td>	 
					<td data-label='action:' class='hidde'>".$action."</td>	
				</tr>";
			/*	}	*/
				$output[] = array(
					   'ID' => $val_data["id"],
					   'Name' => $val_data['name'],
					   'Account Group' => $account_grp,
					   'State Name' => $state_nm,
					   'Mobile No.' => $val_data['phone_no'],
					   'Created Date' => date("d-m-Y", strtotime($val_data['created_date'])),
					);	 
				}
				  $data3  = $output;
				export_csv_excel($data3); 
		   }
	   ?>
		</tbody>          
	</table>
    <?php echo $this->pagination->create_links(); ?>	
	  <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
</div>

<div id="ledger_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-large modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Ledger Details</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>

<div id="unpaid_invoice_modal" class="modal fade in"  role="dialog" style="overflow:hidden;">
	<div class="modal-dialog modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">UnPaid Bill</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>



