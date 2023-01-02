<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	         <form class="form-search" method="get" action="<?= base_url() ?>account/account_recivable/">
			<div class="col-md-6">	<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,Name" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>"  data-ctrl="account/account_recivable">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
			<a href="<?php echo base_url(); ?>account/account_recivable"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>			
					</span></div>
				</div>
			</form>	
			<form action="<?php echo base_url(); ?>account/account_recivable" method="get" id="date_range">	
			 <input type="hidden" value='' class='start_date' name='start'/>
			 <input type="hidden" value='' class='end_date' name='end'/>
		</form>
            	<form class="form-search" id="orderby" method="get" action="<?= base_url() ?>account/account_recivable">
			<input type="hidden" name="order" id="order" value="<?php if($_POST['order']==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			</form>
			<button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button> 
			 <div id="demo" class="collapse">
			<div class="col-md-12">
		      <fieldset>
			<div class="control-group">
			  <div class="controls">
				<div class="input-prepend input-group">
				  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
				  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/account_recivable"/>
				</div>
			  </div>
			</div>
		  </fieldset>
		</div>
			 </div>
	  </div>
</div>
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}
	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	
	?>
	<input type="hidden" value="<?php echo  $_SESSION['loggedInUser']->u_id; ?>" id="login_user_id">
	<input type="hidden" value="yes" id="account_payable_side">
	
	
	
	<form action="<?php echo site_url(); ?>account/account_recivable" method="get" id="export-form">
		<input type="hidden" value='' id='hidden-type' name='ExportType'/>
		<input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
		<input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
		<input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
	</form>
	
	<p class="text-muted font-13 m-b-30"></p>                   
<div class="row hidde_cls">
	<div class="col-md-12  export_div">
		<div class="btn-group"  role="group" aria-label="Basic example">
			
				<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
				<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
					<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
						<ul class="dropdown-menu" role="menu" id="export-menu">
							<li id="export-to-excel"><a href="javascript:void()" title="Please check your open office Setting">Export to excel</a></li>
							<li id="export-to-csv"><a href="javascript:void()" title="Please check your open office Setting">Export to csv</a></li>
							<!--li id="export-to-pdf"><a href="#" title="Please check your open office Setting">Export to Pdf</a></li-->
						</ul>
				</div>
			</div>
		
	</div>
</div>
<div id="print_div_content">

<center><table style="display:none;" class="comp_name"> <tr><td><b style="font-size:18px;"><?php echo $company_brnaches->name; ?></b> <br/><br/><b> Account Receivable</b></td></tr></table></center>
<!---- datatable-buttons------>
			
			
	<table id="" class="table table-striped table-bordered user_index get_Data_fortbl" data-id="user" border="1" cellpadding="3" style="margin-top:40px;">
		<thead>
			<tr>
				<th scope="col">Id
			<span><a href="<?php echo base_url(); ?>account/account_recivable?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/account_recivable?sort=desc" class="down"></a></span></th>
				<th scope="col">Name
		<span><a href="<?php echo base_url(); ?>account/account_recivable?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/account_recivable?sort=desc" class="down"></a></span></th>
				<th scope="col">Account Group</th> 
				<th scope="col">Closing Balance Credit</th>
				<th scope="col">Closing Balance Debit</th>	
				<th scope="col">Phone No.</th>
				<th scope="col" class='hidde'>Action</th>		
						
			</tr>
		</thead>
		<tbody>
		   <?php 
		
		   if(!empty($reciva_data)){
			   foreach($reciva_data as $val_data){ 
			  // pre($val_data);
			    
			  	    $action = '';
			 		 $action .=  '<a href="javascript:void(0)" id="'. $val_data["id"] . '" data-id="'.$val_data['id'].'" data-type-transaction="invoice"  class="lager_rp_name btn btn-warning btn-xs" id="' . $val_data["id"] . '"><i class="fa fa-eye"></i> View Report </a>';

					 $action .=  '<a href="javascript:void(0)" id="'. $val_data["id"] . '" data-id="unpaid_invoice_view" class="add_unpaid_invoice_dtl btn btn-success btn-xs" id="' . $val_data["id"]  . '"><i class="fa fa-eye"></i> View unpaid Bills</a>';
					 
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
									// if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										// $closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
									// }else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										// $closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									// }
					//Calculate Closing Balance	
					 
					 
					$account_grp = 	getNameById('account_group',$val_data['account_group_id'],'id')->name;
					$state_nm = 	getNameById('state',$val_data['mailing_state'],'state_id')->state_name;
					$get_invoice_tbl_dtl = 	getNameById('invoice',$val_data['id'],'party_name');
					
			/*	if($closing_bal != '' && $get_invoice_tbl_dtl->party_name !=''){	*/
				
				echo "<tr>
					<td data-label='id:'>".$val_data["id"]."</td>
					
					 <td data-label='name:'><a href='javascript:void(0)' id='".$val_data["id"] ."' data-id='ledger_view' data-toggle='modal' class='add_account_tabs'><span style='font-size: 13px;text-transform: capitalize;font-weight:bold;'  data-name='".$val_data['name']."'>".$val_data['name']."</span></a></td>  
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
					  
			echo   "<td data-label='phone:'>".$val_data['phone_no']."</td>	 
					<td data-label='action' class='hidde'>".$action."</td>	
				</tr>";
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
</div>

<div id="ledger_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
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


<div id="unpaid_invoice_modal" class="modal fade in"  role="dialog">  
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Unpaid Invoice Details</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>


	
 

