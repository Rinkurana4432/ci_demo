<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	         <form class="form-search" method="post" action="<?= base_url() ?>account/recvpayment/">
		<div class="col-md-6">
		<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,Ledger account" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>" data-ctrl="account/recvpayment">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
				   <a href="<?php echo base_url(); ?>account/recvpayment">
				  <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div></div>
			</form>
			<button style="margin-right: 0px !important;" type="button" class="btn btn-primary collapsed" data-toggle="collapse" data-target="#demo" aria-expanded="false"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         	<div id="demo" class="collapse" aria-expanded="false" style="height: 2px;">
	            <div class="col-md-12  col-xs-12 col-sm-12 datePick-left">
	               <fieldset>
	                  <div class="control-group">
	                     <div class="controls">
	                        <div class="input-prepend input-group">
	                           <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
	                           <input type="text" style="width: 200px" name="tabbingFilters" class="form-control daterange" value="" data-table="purchase/suppliers">
	                        </div>
	                     </div>
	                  </div>
	               </fieldset>
	               <form action="<?php echo site_url(); ?>account/recvpayment" method="GET" >
	               	  <input type="hidden" value='' id="start_date" class='start_date' name='start' value="<?= $_GET['start'] ?>"/>
			 		  <input type="hidden" value='' id="end_date" class='end_date' name='end' value="<?= $_GET['end'] ?>" />
	                  <div class="row hidde_cls filter1 progress_filter">
	                    <div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
	                        <select class="form-control commanSelect2" name="users" >
	                           <?= $users; ?>
	                        </select>
	                     </div>
	                     <input type="submit" value="Filter" class="btn filterBtn filt1"  disabled="disabled">
	                  </div>
	               </form>
	            </div>
	         </div>
	  </div>
</div>
<form action="<?php echo site_url(); ?>account/recvpayment" method="get" id="export-form">
		<input type="hidden" value='' id='hidden-type' name='ExportType'/>
		<input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start']?>' class='start_date' name='start'/>
		<input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end']?>' class='end_date' name='end'/>
      	<input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search']?>' name='search'/>
</form>
<!-- 	<form action="<?php echo base_url(); ?>account/recvpayment" method="get" id="date_range">
			 <input type="hidden" value='' class='start_date' name='start'/>
			 <input type="hidden" value='' class='end_date' name='end'/>
		</form> -->
		<?php if($this->session->flashdata('message') != ''){
							echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
						}?>
	<div class="row hidde_cls">
	<div class="col-md-12 export_div">

			<div class="btn-group"  role="group" aria-label="Basic example">

						<?php if($can_add) {
						//	echo '<button type="button" class="btn btn-success add_payment_tabs addBtn" data-toggle="modal" id="add" data-id="payment"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
						 echo '<a href="'.base_url().'account/receve_payment" class="btn btn-success addBtn"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</a>';
						} ?>
				<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
				<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
					<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
						<ul class="dropdown-menu" role="menu" id="export-menu">
							<li id="export-to-excel"><a href="#" title="Please check your open office Setting">Export to excel</a></li>
							<li id="export-to-csv"><a href="#" title="Please check your open office Setting">Export to csv</a></li>
							<!--li id="export-to-pdf"><a href="#" title="Please check your open office Setting">Export to Pdf</a></li-->
						</ul>
				</div>
			</div>


    </div>
	</div>
	<p class="text-muted font-13 m-b-30"></p>


 <div id="print_div_content">

			<!---datatable-buttons--->

			<hr>

	<table id="" class="table table-striped table-bordered" data-id="account" border="1" cellpadding="3">
		<thead>
			<tr>
				<th scope="col">Id
			<span><a href="<?php echo base_url(); ?>account/recvpayment?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/recvpayment?sort=desc" class="down"></a></span></th>
			<!-- 	<th scope="col">Invoice Number
		<span><a href="<?php //echo base_url(); ?>account/recvpayment?sort=asc" class="up"></a>
      <a href="<?php //echo base_url(); ?>account/recvpayment?sort=desc" class="down"></a></span></th> -->
				<th scope="col">Name
	<span><a href="<?php echo base_url(); ?>account/recvpayment?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/recvpayment?sort=desc" class="down"></a></span></th>

      			<th scope="col">Sale Person</th>
				<th scope="col">Receive Amount</th>
				<th scope="col">Balance</th>
				<th scope="col">Credited Amount</th>
				<th scope="col">Payment Ledger Account</th>
				<th scope="col">Created On</th>
				<th scope="col">Created By</th>
				<!--th scope="col" class='hidde'>Edited By</th-->
				<th scope="col" class='hidde'>Action</th>
			</tr>
		</thead>
		<tbody>
		   <?php
		   $date = $freeze_date->freeze_date;
		   if(!empty($payment_dtl)){
			   $paymentData ='';
			   $totalAmount = 0;
			   foreach($payment_dtl as $payment_dtls){
			   $payemnt_ledger_account = getNameById('ledger',$payment_dtls['recieve_ledger_id'],'id');
				if(!empty($payemnt_ledger_account)){
					$paymentData = $payemnt_ledger_account->name;
				}else{
					$paymentData ='N/A';
				}

			   $paid_invoice_details =  json_decode($payment_dtls['payment_detail']);
			   $inovoice_detail = array();
			   $added_invoice_id = '';

			   $invoiceCount = 0;
		   		$salePerson = [];
			   foreach($paid_invoice_details as $detail){
				   //$payment_receive = $detail->payment_amount;
					  $inovoice_detail['invoice_id'] = $detail->invoice_id;
					  $invoiceData = getNameById('invoice',$detail->invoice_id,'id');

					  if( !empty($invoiceData->invoice_num) && $detail->invoice_id == $invoiceData->id ){
					  		$saleName = getSingleAndWhere('name','user_detail',['u_id' => $invoiceData->sales_person]);
					  		$salePerson[$invoiceData->id] = ['invoice_num' => "<a href='javascript:void(0)' id='{$detail->invoice_id}' data-id='invoice_view_details'
					  														class='add_invoice_details'>{$invoiceData->invoice_num}</a>",
					  									 	'sale_person' => $saleName,
					  										 'invoice_num_without_html' => $invoiceData->invoice_num
					  									 	 ];
					  }
					  	$added_invoice_id .= "<a href='javascript:void(0)' id='".$detail->invoice_id."' data-id='invoice_view_details' class='add_invoice_details'>".$invoiceData->invoice_num.','."</a>";
				  $invoiceCount++;
			   }
			   if($inovoice_detail['invoice_id'] == ''){
				   $invoice_id_or_advanced = 'Advanced';
			   }else{
				   $invoice_id_or_advanced = $added_invoice_id;
			   }

			   $action = '';
				if($can_edit) {

					//$action .=  '<a href="javascript:void(0)" id="'. $payment_dtls["id"] . '" data-id="payment" class="add_payment_tabs btn btn-info btn-xs" id="' . $payment_dtls["id"] . '"><i class="fa fa-pencil"></i> Edit </a>';

					//$action .=  '<a href="'.base_url().'account/editrecvpayment_detail/'.$payment_dtls["id"].'"  class="btn btn-info btn-xs" data-tooltip="Edit"><i class="fa fa-pencil" ></i> </a>';

					$action .=  '<a href="javascript:void(0)" id="'. $payment_dtls["id"] . '" data-id="payment_view" class="add_payment_tabs btn btn-xs" id="' . $payment_dtls["id"] . '" >View</a>';

			}
					if($can_delete) {
						if($payment_dtls['created_date'] < $date){
							$action = $action.'<a href="javascript:void(0)" disabled="disabled" class="delete_listing btn  btn btn-info btn-xs" data-href="'.base_url().'account/deleterecipt/'.$payment_dtls["id"].'" >Delete</a>';
						}else{
							$action = $action.'<a href="javascript:void(0)" class="delete_listing btn   btn btn-info btn-xs" data-href="'.base_url().'account/deleterecipt/'.$payment_dtls["id"].'" >Delete</a>';
						}
					}
					$ledger_name = getNameById('ledger',$payment_dtls['party_id'],'id');
					$reciver_name = getNameById('ledger',$payment_dtls['recieve_ledger_id'],'id');

					$edited_by = ($payment_dtls['edited_by']!=0)?(getNameById('user_detail',$payment_dtls['edited_by'],'u_id')->name):'';
				 ?>
				<tr>
					<td data-label='id:'><?= $payment_dtls['id'] ?></td>
					<!-- <td data-label='Invoice Number:'><?= $invoice_id_or_advanced ?></td> -->
					<td data-label='Name:'><a href='javascript:void(0)' id='<?= $payment_dtls['party_id'] ?>' data-id='ledger_view' class='add_account_tabs'><?= $ledger_name->name ?></a></td><td>
						<?php
							$addMore = false;
							if( $salePerson ){
								$countSale = 1;
								$saleData = [];
								foreach ($salePerson as $saleKey => $saleValue) {
									$saleData[] = ['invoice_num' => $saleValue['invoice_num_without_html'],'sale_person' =>  $saleValue['sale_person']  ];
									if( $countSale < 3 ){
										?>
										<span><?= $saleValue['invoice_num'] ?></span><span><?= ' : '.$saleValue['sale_person'] ?></span>
										<br>
								<?php }else{
										$addMore = true;
									}
									$countSale++;
								}

								if( $addMore ){ ?>
										<span class="viewMoreSalePerson" data-salePerson='<?= json_encode($saleData) ?>' style="color:blue;cursor:pointer;">More</span>
								<?php }
							}
							?>


					</td>

					<td data-label='Receive Amount:'><?= $payment_dtls['added_amount'] ?><?php $totalAmount += $payment_dtls['added_amount']; ?></td>
					<td data-label='Balance:'><?= number_format((float)$payment_dtls['balance'], 2, '.', '') ?></td>
					<td data-label='Credited Amount:'><?= number_format((float)$payment_dtls['amount_to_credit'], 2, '.', '') ?></td>


					<td data-label='Payment Ledger Account:'><a href='javascript:void(0)' id='<?= $payment_dtls['recieve_ledger_id'] ?>' data-id='ledger_view' class='add_account_tabs'><?= $paymentData ?></a></td>
					<td data-label='Created On:'><?= date("j F , Y", strtotime($payment_dtls['created_date'])) ?></td>
					<td data-label='Created By:'><a href='<?= base_url()."users/edit/".$payment_dtls['created_by'] ?>' target='_blank'><?= getNameById('user_detail',$payment_dtls['created_by'],'u_id')->name ?></a></td>
					<!--td data-label='Edited By:' class='hidde'><a href='<? //= base_url()."users/edit/".$payment_dtls['edited_by'] ?>' target='_blank'><? //= $edited_by ?></a></td-->
					<td data-label='Action:' class='hidde action'><i class='fa fa-cog'></i><div class='on-hover-action'><?= $action ?></div></td>
				</tr>
				<?php $blnc = number_format((float)$payment_dtls['balance'], 2, '.', '');
				$output[] = array(
					   'Invoice ID' => $payment_dtls['id'],
					   'Receiver Name'  => $reciver_name->name,
					   'Name' => $ledger_name->name,
					   'Email' => $payment_dtls['party_email'],
					   'Balance' => $blnc,
					   'Created Date' => $payment_dtls['created_date'],
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

 <div><center><span style="font-size: 17px;"><b> Total Amount :  </b><?= !empty($totalAmount)?$totalAmount:0; ?></span></center></div>

<div id="payment_add_detail_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Receive Payment Detail</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>

<!-- all invoice and sale person -->

<div id="invoiceSalePerson" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">All Invoice And Sale Person</h4>
			</div>
			<div class="modal-body-content">

			</div>
		</div>
	</div>
</div>

<?php
$this->load->view('common_modal');
?>
