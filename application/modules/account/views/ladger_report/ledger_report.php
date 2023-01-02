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


			$debitTotal = 0; $creditTotal = 0;
			foreach($ledger_dtl2 as $open_balance){
				$debitTotal += $open_balance->debit_dtl;
				$creditTotal += $open_balance->credit_dtl;
			}
			if($ledger_Data[0]->openingbalc_cr_dr == 1){ //opening Balance is in Credit

					$openg_balance = floor($ledger_Data[0]->opening_balance);
					$after_add_opening_bal_credit  = $openg_balance + $creditTotal;
					$bbl = $debitTotal - $after_add_opening_bal_credit;
				}else if($ledger_Data[0]->openingbalc_cr_dr == 0){
					$openg_balance = floor($ledger_Data[0]->opening_balance);
					$after_add_opening_bal_debit  = $debitTotal + $openg_balance;
					$bbl = $creditTotal - $after_add_opening_bal_debit;
				}

				$closingBalan = abs($bbl);
			if($closingBalan > floor($ledger_Data[0]->opening_balance)){
				$crdr = ' / DR';
				}else{
				$crdr = ' / CR';
			 }

			if($debitTotal == 0 && $creditTotal == 0){
		?>
					<input type="hidden" value="<?php if(!empty($ledger_Data)){ echo $ledger_Data[0]->openingbalc_cr_dr; }?>" id="opning_blnc_cr_dr">
					<input type="hidden" value="<?php if(!empty($ledger_Data)){ echo $ledger_Data[0]->opening_balance; }?>" id="opning_blnance">
			<?php }else{?>
					<input type="hidden" value="<?php echo $crdr;?>" id="opning_blnc_cr_dr">
					<input type="hidden" value="<?php echo $closingBalan;?>" id="opning_blnance">
			<?php } ?>
		<div class="col-md-12 export_div">
		<?php if($debitTotal == 0 && $creditTotal == 0){	 ?>
			 <div style="float:right;"> <label style="color:#000;">Opening Balance : </label><span class="opening_blance"><?php if(!empty($ledger_Data)){echo money_format('%!i',$ledger_Data[0]->opening_balance); }else{ echo '0.00';}  ?>  <?php   echo $opning_balance_Cr_Dr; ?></span> </div>
		<?php }else{ ?>
				<div style="float:right;"> <label style="color:#000;">Opening Balance : </label><span class="opening_blance"><?php echo money_format('%!i',$closingBalan);  ?>  <?php   echo $crdr; ?></span> </div>

		<?php } ?>
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
		  <form action="<?php echo base_url(); ?>account/get_ledger_account_detials" method="post" id="date_range">
			<input type="hidden" value='' class='start_date' name='start'/>
			<input type="hidden" value='' class='end_date' name='end'/>
			<input type="hidden" value='' class='ledgerID' name='ledger_party_id'/>
		</form>
	</div>
	 <!--form action="<?php //echo base_url(); ?>account/get_ledger_account_detials" method="post" id="date_range">	</form-->
			<input type="hidden" value='' id="clicked_ledger_idds"/>
			<!--input type="button" onclick="printDiv('print_div')" value="Print" /-->

			<table id="ledger_rprt" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Date</th>
						<th>Narration</th>
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
					$$debit_total_Amt = 0;
					 foreach($ledger_dtl as $dtl){
						 // pre($dtl);
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
								$get_invoice_number = getNameById('invoice',$dtl->type_id,'id');
								$added_invoice_id .= "<a href='javascript:void(0)' id='".$dtl->type_id."' data-id='invoice_view_details' class='add_invoice_details' style='float:left;'>".$get_invoice_number->invoice_num.','."</a>";
							}else if($dtl->type == 'purchase_bill'){
								 $added_invoice_id .= "<a href='javascript:void(0)' id='".$dtl->type_id."' data-id='purchase_bill_view' class='add_purchase_bill_to_tabs'>".$dtl->type_id.'</a>';
							}else if($dtl->type == 'debitNotePurchaseReturn' || $dtl->type == 'debitNote'){
								 $added_invoice_id .= "<a href='javascript:void(0)' id='".$dtl->type_id."' data-id='DRSaleReturn_view_details' class='add_CrSaleREturn_details'>".$dtl->type_id.'</a>';
							}else if($dtl->type == 'creditnoteSaleReturn' || $dtl->type == 'creditnote'){
								 $added_invoice_id .= "<a href='javascript:void(0)' id='".$dtl->type_id."' data-id='crSaleReturn_view_details' class='add_CrSaleREturn_details'>".$dtl->type_id.'</a>';
							}else{
								$added_invoice_id .= "<a href='javascript:void(0)' id='".$dtl->type_id."' data-id='voucher_dtl_view' class='add_voucher_details_tabs'>".$dtl->type_id.'</a>';

							}

				//GET voucher Type
				if($dtl->type == 'invoice'){
					$vcher_type = 'Invoice';
					$get_invoice_dtl = getNameById('invoice',$dtl->type_id,'id');
					$narrationn = $get_invoice_dtl->message_for_email;
					$ledger_data = getNameById('ledger',$get_invoice_dtl->party_name,'id');
					$namee = $ledger_data->name;
					$newDate = date("j F , Y", strtotime($get_invoice_dtl->date_time_of_invoice_issue));
					$ledger_data = getNameById('ledger',$get_invoice_dtl->party_name,'id');
					$namee = $ledger_data->name;
					/* particular column name */
					if( $get_invoice_dtl->sale_ledger != $currentLedger ){
						$particular = getSingleAndWhere('name','ledger',['id' => $get_invoice_dtl->sale_ledger ]);
					}else{
						$particular = $namee;
					}
				}else if($dtl->type == 'purchase_bill'){
					$vcher_type = 'Purchase Bill';
					//pre($dtl);
					$get_purchase_bill_dtl = getNameById('purchase_bill',$dtl->type_id,'id');

					$ledger_data = getNameById('ledger',$get_purchase_bill_dtl->supplier_name,'id');
					$narrationn = $get_purchase_bill_dtl->message_for_email;
					$namee = $ledger_data->name;
					$newDate = date("j F , Y", strtotime($get_purchase_bill_dtl->date));
					$ledger_data = getNameById('ledger',$get_invoice_dtl->party_name,'id');
					$namee = $ledger_data->name;

					if( $get_purchase_bill_dtl->party_name != $currentLedger ){
						$particular = getSingleAndWhere('name','ledger',['id' => $get_purchase_bill_dtl->party_name ]);
					}else{
						$particular = getSingleAndWhere('name','ledger',['id' => $get_purchase_bill_dtl->supplier_name ]);;
					}


				}else if($dtl->type == 'Payment Receive'){
					$vcher_type = 'Payment Receive';
					$get_payment_recive_dtl = getNameById('payment',$dtl->type_id,'id');

					$narrationn = $get_payment_recive_dtl->narration;
					$ledger_data = getNameById('ledger',$get_payment_recive_dtl->party_id,'id');
					$namee = $ledger_data->name;
					$newDate = date("j F , Y", strtotime($get_payment_recive_dtl->payment_date));

					if( $get_payment_recive_dtl->recieve_ledger_id != $currentLedger ){
						$particular = getSingleAndWhere('name','ledger',['id' => $get_payment_recive_dtl->recieve_ledger_id ]);
					}else{
						$particular = $namee;
					}

				}else if($dtl->type == 'purchase_bill_payment_recive'){
					$vcher_type = 'Payment Done';
					$newDate = date("j F , Y", strtotime($dtl->created_date));
					$get_paym0ent_payment_done_dtl = getNameById('payment',$dtl->type_id,'id');
					 $narrationn = $get_payment_payment_done_dtl->narration;
					$ledger_data = getNameById('ledger',$get_payment_payment_done_dtl->party_id,'id');
					$namee = $ledger_data->name;

					if( $get_paym0ent_payment_done_dtl->recieve_ledger_id != $currentLedger ){
						$particular = getSingleAndWhere('name','ledger',['id' => $get_paym0ent_payment_done_dtl->recieve_ledger_id ]);
					}else{
						$particular = $namee;
					}

				}else if($dtl->type == 'debitNotePurchaseReturn'){
					$vcher_type = 'Purchase Return';
					//pre($vcher_type);
					$get_PurchaseBillReturn = getNameById('debitnote_tbl',$dtl->type_id,'id');
					//pre($get_PurchaseBillReturn);
					//pre($get_PurchaseBillReturn);die();
					$namee = $ledger_data->name;
					$newDate = date("j F , Y", strtotime($get_PurchaseBillReturn->date));
					$ledger_data = getNameById('ledger',$get_invoice_dtl->party_name,'id');
					$namee = $ledger_data->name;

					if( $get_PurchaseBillReturn->buyerID != $currentLedger ){
						$particular = getSingleAndWhere('name','ledger',['id' => $get_PurchaseBillReturn->buyerID ]);
					}else{
						$particular = getSingleAndWhere('name','ledger',['id' => $get_PurchaseBillReturn->supplier_id ]);
					}

			    }else if($dtl->type == 'creditnoteSaleReturn'){
					$vcher_type = 'Sale Return';
					$namee = $ledger_data->name;
					$newDate = date("j F , Y", strtotime($get_invoice_dtl->date));
					$ledger_data = getNameById('ledger',$get_invoice_dtl->party_name,'id');
					$namee = $ledger_data->name;

					$get_invoice_dtl = getNameById('creditnote_tbl',$dtl->type_id,'id');

					if( $get_invoice_dtl->ledgerID != $currentLedger ){
						$particular = getSingleAndWhere('name','ledger',['id' => $get_invoice_dtl->ledgerID ]);
					}else{
						$particular = getSingleAndWhere('name','ledger',['id' => $get_invoice_dtl->customer_id ]);
					}

			    }else if($dtl->type == 'debitNote'){
					$vcher_type = 'Debit Note';
					$namee = $ledger_data->name;

					$get_invoice_dtl = getNameById('debitnote_tbl',$dtl->type_id,'id');

					$newDate = date("j F , Y", strtotime($get_invoice_dtl->date));
					/*$ledger_data = getNameById('ledger',$get_invoice_dtl->party_name,'id');
					$namee = $ledger_data->name; */
					if( $get_invoice_dtl->supplier_id != $currentLedger ){
						$particular = getSingleAndWhere('name','ledger',['id' => $get_invoice_dtl->supplier_id ]);
					}else{
						$particular = getSingleAndWhere('name','ledger',['id' => $get_invoice_dtl->buyerID ]);;
					}

			    }else if($dtl->type == 'creditnote'){
					$vcher_type = 'Credit Note';
					$namee = $ledger_data->name;
					$newDate = date("j F , Y", strtotime($get_invoice_dtl->date));
					$ledger_data = getNameById('ledger',$get_invoice_dtl->party_name,'id');
					$namee = $ledger_data->name;

					$get_invoice_dtl = getNameById('creditnote_tbl',$dtl->type_id,'id');

					if( $get_invoice_dtl->ledgerID != $currentLedger ){
						$particular = getSingleAndWhere('name','ledger',['id' => $get_invoice_dtl->ledgerID ]);
					}else{
						$particular = getSingleAndWhere('name','ledger',['id' => $get_invoice_dtl->customer_id ]);;
					}

			    }else if($dtl->type == 'tdsinwarddtl'){
					$vcher_type = 'Accounting Purchase';
					$namee = $ledger_data->name;
					$newDate = date("j F , Y", strtotime($get_invoice_dtl->date));
					$ledger_data = getNameById('ledger',$get_invoice_dtl->supplier_name,'id');
					$namee = $ledger_data->name;

			    	$tdsData = getNameById('tbl_tdsinward',$dtl->type_id,'id');

			    	if( $tdsData->sale_ledger != $currentLedger ){
			    		$particular = getSingleAndWhere('name','ledger',['id' => $tdsData->sale_ledger ]);
			    	}else{
			    		$particular = getSingleAndWhere('name','ledger',['id' => $tdsData->supplier_name ]);
			    	}



			    }else if($dtl->type == 'Charges'){
					$vcher_type = 'Charges';
					//pre($dtl);
					$get_purchase_bill_dtl = getNameById('purchase_bill',$dtl->type_id,'id');

					$ledger_data = getNameById('ledger',$get_purchase_bill_dtl->supplier_name,'id');
					$narrationn = $get_purchase_bill_dtl->message_for_email;
					$namee = $ledger_data->name;
					$newDate = date("j F , Y", strtotime($get_purchase_bill_dtl->date));
					$ledger_data = getNameById('ledger',$get_invoice_dtl->party_name,'id');
					$namee = $ledger_data->name;

					if( $get_purchase_bill_dtl->party_name != $currentLedger ){
						$particular = getSingleAndWhere('name','ledger',['id' => $get_purchase_bill_dtl->party_name ]);
					}else{
						$particular = getSingleAndWhere('name','ledger',['id' => $get_purchase_bill_dtl->supplier_name ]);;
					}



			    }else if($dtl->type == 'accountinginvoice'){
					$vcher_type = 'Accounting Invoice';
					// pre($dtl);
					$getnamedtl = getNameById('tbl_accounting_invoice',$dtl->type_id,'id');

					$ledger_data = getNameById('ledger',$getnamedtl->sale_ledger,'id');
					$narrationn = $getnamedtl->message_for_email;
					$namee = $ledger_data->name;
					$newDate = date("j F , Y", strtotime($getnamedtl->date));
					// $ledger_data = getNameById('ledger',$get_invoice_dtl->party_name,'id');
					// $namee = $ledger_data->name;

					if( $getnamedtl->party_name != $currentLedger ){
						$particular = getSingleAndWhere('name','ledger',['id' => $getnamedtl->party_name ]);
					}else{
						$particular = getSingleAndWhere('name','ledger',['id' => $getnamedtl->sale_ledger ]);;
					}



			    }else{
					$get_vaoucher_id = getNameById('voucher',$dtl->type_id,'id');
					$get_vaoucher_name = getNameById('voucher_type',$get_vaoucher_id->voucher_name,'id');
					$vcher_type = $get_vaoucher_name->voucher_name;
					$newDate = date("j F , Y", strtotime($get_vaoucher_id->voucher_date));
					$tdsData = getNameById('tbl_tdsinward',$dtl->type_id,'id');
			    	if( $tdsData->sale_ledger != $currentLedger ){
			    		$particular = getSingleAndWhere('name','ledger',['id' => $tdsData->sale_ledger ]);
			    	}else{
			    		$particular = getSingleAndWhere('name','ledger',['id' => $tdsData->supplier_name ]);
			    	}
				}

                if($narrationn == ''){
					$narrationn = 'N/A';
				}
			//GET Voucher Type
		?>
					<td><?php echo $sno; ?> </td>
					<td><?php echo  date("j F , Y", strtotime($dtl->add_date)); ?> </td>
					<td><?php echo $narrationn; ?> </td>
					<td><?php echo $particular; ?> </td>
					<td><?php echo $added_invoice_id; ?> </td>
					<td><?php echo $vcher_type; ?></td>
					<input type="hidden" value="<?php echo $dtl->credit_dtl;?>" name="credit_amt[]" >
					<td><?php echo money_format('%!i',$dtl->credit_dtl); ?></td>
					<input type="hidden" value="<?php echo $dtl->debit_dtl;?>" name="debit_amt[]">
					<td><?php echo money_format('%!i',$dtl->debit_dtl); ?></td>
				</tr>
				<?php
					$sno++;
						$debit_total_Amt += $dtl->debit_dtl;
						$credit_total_Amt += $dtl->credit_dtl;
					}
				}  else { ?>
				 <tr><td colspan="8"><b>No Data Available</b></td></tr>
				<?php } ?>
				</tbody>
          </table>
		     <input type="hidden" value="<?php echo $credit_total_Amt; ?>" id="CR_total_amt">
		     <input type="hidden" value="<?php echo $debit_total_Amt; ?>" id="DR_total_amt">
			<div class="col-md-12 col-sm-12 col-xs-12 data_tbl2" style="display:none;">
			<div class="col-md-6 col-sm-5 col-xs-12 text-right" style="float: right;">
				<div class="col-md-6 " style="padding:0px;">
				   <label class="col-md-6 col-sm-5 col-xs-6 " style="padding-top: 7px;">Credit :</label>
					<div class="col-md-6 col-sm-5 col-xs-6 " style="padding:0px;"><input type="text"  id="credit_total" name="total"   class="form-control col-md-7 col-xs-12" style="border: none; background:#fff;" readonly  ></div>
				</div>
				<div class="col-md-6" style="padding:0px;">
				  <label class="col-md-6 col-sm-5 col-xs-6 " style="padding-top: 7px; ">Debit :</label>
				<div class="col-md-6 col-sm-5 col-xs-6 " style="padding:0px;"><input type="text"  id="debit_total"   class="form-control col-md-7 col-xs-12" style="border: none; background:#fff;"  readonly   ></div>
				</div>
		<?php
		// pre($closingBalan);
		// pre($debitTotal);
		// pre($creditTotal);
		if($debitTotal == 0 && $creditTotal == 0){
		?>
			<div class="col-md-12 grand-tota2">
			    <label class="col-md-6 col-sm-5 col-xs-6 " style="padding:0px;">Closing Balance : </label>
				<div class="col-md-6 col-sm-5 col-xs-6 "><input type="text"  id="closing_balance" name="closing_balance"   class="form-control col-md-7 col-xs-12" style="border: none; background:#fff;float:right;" readonly  ></div>
			</div>
		<?php }else{?>
			<div class="col-md-12 grand-tota2">
			    <label class="col-md-6 col-sm-5 col-xs-6 " style="padding:0px;">Closing Balance : </label>
				<div class="col-md-6 col-sm-5 col-xs-6 "><input type="text"  value="<?php echo money_format('%!i',$closingBalan);?>" name="closing_balance"   class="form-control col-md-7 col-xs-12" style="border: none; background:#fff;float:right;" readonly  ></div>
			</div>

		<?php }
			?>
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


				<input type="hidden" value="<?php  echo isset($_POST['start']) ? $_POST['start'] : '' ?>"  class='start_date' name='start'/>
				<input type="hidden" value="<?php  echo isset($_POST['end']) ? $_POST['end'] : '' ?>" class='end_date' name='end'/>
				<input type="submit" class="btn btn-default " value="Generate PDF" style="float:right;">

			</form>


		<?php } ?>
			<!--<button type="button" class="btn btn-default close_modal2" data-dismiss="modal" style="float:right;">Close</button>-->

		</div>
		</center>

</div>
	<?php


$this->load->view('common_modal');
?>
   <div id="voucher_dtl_add_modal" class="modal fade in"  role="dialog">
      <div class="modal-dialog modal-lg modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title" id="myModalLabel">Voucher Detail</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
