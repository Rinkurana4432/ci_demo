<div class="x_content">

	<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

	if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	} ?>
</div>
		<div class="col-md-12 item form-group offset-md-12" style="min-height: 900px;">
		<div class="col-md-3 item form-group offset-md-3 left-menu-2">
			<!--select class="itemName form-control selectAjaxOption select2" id="get_ladger_details"  required="required" name="supplier_name" data-id="ledger" data-key="id" data-fieldname="name" data-where="created_by=<?php //echo $_SESSION['loggedInUser']->u_id; ?>"  width="100%"></select--> 
				<!--a href='<?//= //base_url() ?>/account/exportCSV'>Export</a-->
			<input type="text"  id="textbox" placeholder="Search..." class="itemName form-control">
	        <div id="result"></div>
			<?php
				foreach($get_Data as $dtial){
					
					/* Get all Data from Ledger Table*/
								$amount_totalgd = get_total_user_amount_debit('transaction_dtl',$dtial['id'],$Login_user_id);
								$amount_total_credit = get_total_user_amount_crdt('transaction_dtl',$dtial['id'],$Login_user_id);
								$ledger_detailsGD = get_closing_balance($dtial['id'],$Login_user_id);
								foreach($ledger_detailsGD as $ledger_dtlsgd){
									if($ledger_dtlsgd['openingbalc_cr_dr'] == 1 ){
										 	$leger_debit_ttl = $amount_totalgd['sum(debit_dtl)'];
											$opening_balance =  $ledger_dtlsgd['opening_balance'];
											$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
									    	$ledger_amt_aftr_calcu_cr = $leger_credit_ttl + $opening_balance;
											$ledger_amt_aftr_calcu_dr = $leger_debit_ttl;
										}
									if($ledger_dtlsgd['openingbalc_cr_dr'] == 0 ){
										$leger_debit_ttl = $amount_totalgd['sum(debit_dtl)'];
										$opening_balance =  $ledger_dtlsgd['opening_balance'];
										$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
										$ledger_amt_aftr_calcu_dr = $leger_debit_ttl + $opening_balance;
										$ledger_amt_aftr_calcu_cr = $leger_credit_ttl;
									}
									
									//pre($ledger_dtlsgd);
								}	
									// if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										// $closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
									// }else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										// $closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									// }
									
									
					
			?>
			<p class="lager_rp_name trigger" data-id='<?php echo $dtial['id']; ?>' > <span class="ledger_namee"><?php  echo @$dtial['name']; ?></span> </p>
			
				<?php  }


				  // if($dtial['supp_id'] == '0'){
				 ?>
				<!--p class="lager_rp_name" data-id='<?php //echo $dtial['id']; ?>' data-type-transaction='invoice'> <span class="ledger_namee"><?php // echo @$dtial['name']; ?></span> </p-->	
				
				<?php //}else{ ?>
						<!--p class="lager_rp_name" data-id='<?php //echo $dtial['supp_id']; ?>' data-type-transaction='purchase_bill'> <span class="ledger_namee"><?php  //echo @$dtial['name']; ?></span> </p-->	
							
				<?php //	} ?>
				<span class="ldgernam"></span>
		<!--p class="ldger_idd lager_rp_name"><span class="ldgernam "></span></p-->
		<?php echo $this->pagination->create_links(); ?>
		</div>
		
			<input type="hidden" value="<?php echo $this->companyGroupId; ?>" id="login_user_id">
		
	
		
		



<div id="ledger_modal" class="modal fade in ledger-1"  role="dialog" style="display:none; ">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<!--<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">??</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Ledger Report</h4>
			</div>-->
			<div class="modal-body-content main-modal">
			           <div class="x_content">

	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	} ?>
	</div>

		<div class="col-md-12 item form-group offset-md-12">
	
	<div class="col-md-12 item form-group offset-md-8" id="print_div">
		<input type="hidden" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="login_user_id">
		<input type="hidden" value="" id="p_idd">
		<p class="text-muted font-13 m-b-30"></p>  
<!--id="datatable-buttons"-->
			<center><b class="party_nname"></b></center><br/>
		
		<!--input type="button" value="print" onclick="PrintDiv();" /-->
		
		<?php
		
		
		setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
		
			if($ledger_Data[0]->openingbalc_cr_dr == '0'){
				$opning_balance_Cr_Dr = ' / DR';
			}else if($ledger_Data[0]->openingbalc_cr_dr == '1'){
				$opning_balance_Cr_Dr =  ' / CR';
			}else if($ledger_Data[0]->openingbalc_cr_dr == ''){
				$opning_balance_Cr_Dr =  '';
			}
			
		?>
		<input type="hidden" value="<?php if(!empty($ledger_Data)){ echo $ledger_Data[0]->openingbalc_cr_dr; }?>" id="opning_blnc_cr_dr">
		<input type="hidden" value="<?php if(!empty($ledger_Data)){ echo $ledger_Data[0]->opening_balance; }?>" id="opning_blnance">
			
		<div class="col-md-12 export_div">
		
			 <div style="float:right;"> <label style="color:#fff;">Opening Balance : </label><span class="opening_blance"><?php if(!empty($ledger_Data)){echo money_format('%!i',$ledger_Data[0]->opening_balance); }else{ echo '0.00';}  ?>  <?php   echo $opning_balance_Cr_Dr; ?></span> </div>   
		                   
		  <fieldset>
			<div class="control-group">
			  <div class="controls">
				<div class="input-prepend input-group">
				  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
				  <input type="text" style="width: 200px" name="tabbingFilters33" id="tabbingFilters33" class="form-control" value=""  data-table="account/get_ledger_account_detials" readonly>
				</div>
			  </div>
			</div>
		  </fieldset>
	</div>
	 <!--form action="<?php //echo base_url(); ?>account/get_ledger_account_detials" method="post" id="date_range">	</form-->	
			
			<input type="hidden" value='' id="clicked_ledger_idds"/>
	
			<!--input type="button" onclick="printDiv('print_div')" value="Print" /-->
			
			<table id="ledger_rprt" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Date</th>
						<th>Particulars</th>
						<th>Voucher No.</th>
						<th>Voucher Type</th>
						<!--th>Advance</th-->
						<th>Credit</th>
						<th>Debit</th>
						
					</tr>
				</thead>
				<tbody>
				<tr>
				<?php
				if(!empty($ledger_dtl)){
					$sno = 1;
					 foreach($ledger_dtl as $dtl){
						 
						$added_invoice_id = '';
						if($dtl->type == 'purchase_bill_payment_recive'){
							$get_payment_details_from_payment_tbl	= getNameById('payment',$dtl->type_id,'id');
								$data_json	= JSON_DECODE($get_payment_details_from_payment_tbl->payment_detail); 
							
							foreach($data_json as $detail){
								
								$inovoice_detail['bill_id'] = $detail->bill_id;
								   $added_invoice_id .= "<a href='javascript:void(0)' id='".$inovoice_detail['bill_id']."' data-id='purchase_bill_view' class='add_purchase_bill_to_tabs'>".$inovoice_detail['bill_id'].'</a>,';
								}
							}else if($dtl->type == 'Payment Receive'){
								$get_payment_details_from_payment_tbl	= getNameById('payment',$dtl->type_id,'id');
								$data_json_invoice_payment_recive = JSON_DECODE($get_payment_details_from_payment_tbl->payment_detail); 
								foreach($data_json_invoice_payment_recive as $detail_invoice){
									$inovoice_detail['invoice_id'] = $detail_invoice->invoice_id;
				   					$added_invoice_id .= "<a href='javascript:void(0)' id='".$inovoice_detail['invoice_id']."' data-id='invoice_view_details' class='add_invoice_details' style='float:left;'>".$inovoice_detail['invoice_id'].','."</a>";
								}
								
							}else if($dtl->type == 'invoice'){
								$added_invoice_id .= "<a href='javascript:void(0)' id='".$dtl->type_id."' data-id='invoice_view_details' class='add_invoice_details' style='float:left;'>".$dtl->type_id.','."</a>";	
							}else if($dtl->type == 'purchase_bill'){
								 $added_invoice_id .= "<a href='javascript:void(0)' id='".$dtl->type_id."' data-id='purchase_bill_view' class='add_purchase_bill_to_tabs'>".$dtl->type_id.'</a>';
								 $narrationdata = getNameById('purchase_bill',$dtl->type_id,'id');
							}else{
								$added_invoice_id .= "<a href='javascript:void(0)' id='".$dtl->type_id."' data-id='voucher_dtl_view' class='add_voucher_details_tabs'>".$dtl->type_id.'</a>';
								
							}
					
		?>
					<td><?php echo $sno; ?> </td>
					<td><?php echo  date("j F , Y", strtotime($dtl->add_date)); ?> </td>
					<td><?php if($dtl->narration == ''){echo 'N/A';}else{echo $dtl->narration; }; ?> </td>
					<td><?php echo $added_invoice_id; ?> </td>
					<td><?php echo $vcher_type; ?></td>
					<input type="hidden" value="<?php echo $dtl->credit_dtl;?>" name="credit_amt[]">	
					<td><?php echo money_format('%!i',$dtl->credit_dtl); ?></td>
					<input type="hidden" value="<?php echo $dtl->debit_dtl;?>" name="debit_amt[]">
					<td><?php echo money_format('%!i',$dtl->debit_dtl); ?></td>
				</tr>
				<?php 
					$sno++;
					}
					
					}  else { ?>
				 <tr><td colspan="8"><b>No Data Available</b></td></tr>
				<?php } ?>
				</tbody>  
          </table>
			<div class="col-md-12 col-sm-12 col-xs-12 data_tbl2" style="display:none;">
			<div class="col-md-5 col-sm-5 col-xs-12 text-right" style="float: right;">
				<div class="col-md-6 ">
				   <label class="col-md-6 col-sm-5 col-xs-6 " style="padding-top: 7px;">Credit :</label>
					<div class="col-md-6 col-sm-5 col-xs-6 "><input type="text"  id="credit_total" name="total"   class="form-control col-md-7 col-xs-12" style="border: none; background:#fff;" readonly  ></div>
				</div>
				<div class="col-md-6">
				  <label class="col-md-6 col-sm-5 col-xs-6 " style="padding-top: 7px;">Debit :</label>
				<div class="col-md-6 col-sm-5 col-xs-6 "><input type="text"  id="debit_total"   class="form-control col-md-7 col-xs-12" style="border: none; background:#fff;"  readonly  ></div>
				</div>
			<div class="col-md-12 grand-tota2"> 
			    <label class="col-md-7 col-sm-5 col-xs-6 ">Closing Balance : </label>
				<div class="col-md-5 col-sm-5 col-xs-6 "><input type="text"  id="closing_balance" name="closing_balance"   class="form-control col-md-7 col-xs-12" style="border: none; background:#fff;float:right;" readonly  ></div>
			</div>
			</div>
		</div>
		

</div>
<hr>					
<div class="bottom-bdr"></div>	
<div class="form-group">
 
	<center>
		<div class="col-md-12">
		
		<?php if((!empty($ledger_Data) && $ledger_Data[0]->save_status ==1)){ 
		
		?>
			<!--a href="<?php //echo base_url(); ?>account/get_ledger_account_detials/<?php //echo $ledger_Data[0]->id; ?>" target="_blank"><button class="btn btn-default Click_for_pdf">Generate PDF</button></a-->
			<form method="POST" name="for_pdf" action="<?php echo base_url(); ?>account/get_pdf_for_ledger_report/<?php echo $ledger_Data[0]->id; ?>" target="_blank" style="float:right;">
			   
				
				<input type="hidden" value='' class='start_date' name='start'/>
				<input type="hidden" value='' class='end_date' name='end'/>
				<input type="submit" class="btn btn-default " value="Generate PDF" style="float:right;">
			
			</form>
			
			
		<?php } ?>
			<button type="button" class="btn btn-default close_modal2" data-dismiss="modal" style="float:right;">Close</button>
		
		</div>
		</center>
	
</div>
	<?php
$this->load->view('common_modal');
?>

			</div>
		</div>
	</div>

</div>
</div>
</div>