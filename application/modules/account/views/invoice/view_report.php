<div class="x_content">

	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	} ?>
	</div>
	<div class="col-md-12 item form-group offset-md-12">
		<div class="col-md-12 item form-group offset-md-8" id="print_div">
			<p class="text-muted font-13 m-b-30"></p>  

				<?php setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format ?>
			<table id="datatable-buttons" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Date</th>
						<th>Ledger Name</th>
						<th>Voucher Type</th>
						<th>Credit</th>
						<th>Debit</th>
					</tr>
				</thead>
				<tbody>
				<tr>
			<?php
				if(!empty($invoice_dtl_report)){
						$sno = 1;
						 foreach($invoice_dtl_report as $dtl){
							 $ledger_name = getNameById('ledger',$dtl->ledger_id,'id');
					?>
					<td><?php echo $sno; ?> </td>
					<td><?php echo date("j F , Y", strtotime($dtl->add_date)); ?> </td>
					<td><?php echo $ledger_name->name ?> </td>
					<td style=" text-transform: capitalize;"><?php echo $dtl->type;?></td>
					<td><?php echo money_format('%!i',$dtl->credit_dtl); ?></td>
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
</div>

