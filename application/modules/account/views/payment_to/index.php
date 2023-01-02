<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	            <form class="form-search" method="post" action="<?= base_url() ?>account/paymentto/">
			<div class="col-md-6">	
            <div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,Name" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="account/paymentto">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
						<a href="<?php echo base_url(); ?>account/paymentto"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
                </div>
			</form>	
            <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>account/paymentto">
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
				  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/paymentto"/>
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
		}?>
	

	<form action="<?php echo site_url(); ?>account/paymentto" method="get" id="export-form">
		<input type="hidden" value='' id='hidden-type' name='ExportType'/>
		<input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
		<input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
		<input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
	</form>
	<form action="<?php echo base_url(); ?>account/paymentto" method="get" id="date_range">	 
			 <input type="hidden" value='' class='start_date' name='start'/>
			 <input type="hidden" value='' class='end_date' name='end'/>
		</form>
	
	<p class="text-muted font-13 m-b-30"></p> 
<div class="row hidde_cls">
	<div class="col-md-12 export_div">
		
			<div class="btn-group"  role="group" aria-label="Basic example">
				<?php if($can_add) {
					//echo '<button type="button" class="btn btn-success addBtn add_payment_to_tabs" data-toggle="modal" id="add" data-id="payment_to"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
					echo '<a href="'.base_url().'account/payment_to_ctrl" class="btn btn-success addBtn"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</a>';
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
 <div id="print_div_content">
	 
			<!---datatable-buttons---> 
			
	<table id="" class="table table-striped table-bordered" data-id="account"  border="1" cellpadding="3" style="margin-top:40px;">
		<thead>
			<tr>
				<th scope="col">Id
		<span><a href="<?php echo base_url(); ?>account/paymentto?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/paymentto?sort=desc" class="down"></a></span></th>
      <th scope="col">Invoice id</th>
           <th scope="col">Name
		<span><a href="<?php echo base_url(); ?>account/paymentto?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/paymentto?sort=desc" class="down"></a></span></th>
				<th scope="col">Balance</th>
				<th scope="col">Credited Amount</th>
				<th scope="col">Paid Amount</th>
				<th scope="col">Created On</th>	
				<th scope="col">Created By</th>
				<!--th class='hidde'>Edited By</th-->
				<th scope="col" class='hidde'>Action</th>
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
						//$action .=  '<a href="javascript:void(0)" disabled="disabled" id="'. $payment_dtls["id"] . '" data-id="payment_to" class="add_payment_to_tabs btn btn-info btn-xs" id="' . $payment_dtls["id"] . '"><i class="fa fa-pencil"></i></a>';
						
						$action .=  '<a href="'.base_url().'account/editpayment_to_detail/'.$payment_dtls["id"].'"  class="btn btn-info btn-xs"  data-tooltip="Edit"><i class="fa fa-pencil"></i></a>';
					}else{
						//$action .=  '<a href="javascript:void(0)" id="'. $payment_dtls["id"] . '" data-id="payment_to" class="add_payment_to_tabs btn btn-info btn-xs" id="' . $payment_dtls["id"] . '"><i class="fa fa-pencil"></i></a>';
						$action .=  '<a href="'.base_url().'account/editpayment_to_detail/'.$payment_dtls["id"].'"  class="btn  btn-xs"  >Edit</a>';
					}
					
				}
				if($can_delete) { 
					if($payment_dtls['created_date'] < $date){
						$action .=  '<a href="javascript:void(0)" id="'. $payment_dtls["id"] . '" data-id="payment_to_view" class="add_payment_to_tabs btn  btn-xs" id="' . $payment_dtls["id"] . '" >View</a>';
						
						
						
						$action = $action.'<a href="javascript:void(0)" disabled="disabled" class="delete_listing btn  btn btn-info btn-xs" data-href="'.base_url().'account/delete_payment_to/'.$payment_dtls["id"].'" >Delete</a>';
						
					}else{
						$action .=  '<a href="javascript:void(0)" id="'. $payment_dtls["id"] . '" data-id="payment_to_view" class="add_payment_to_tabs btn  btn-xs" id="' . $payment_dtls["id"] . '" >View</a>';
						
						$action = $action.'<a href="javascript:void(0)" class="delete_listing btn   btn btn-info btn-xs" data-href="'.base_url().'account/delete_payment_to/'.$payment_dtls["id"].'" >Delete</a>';
					}
				}
					
					$name = getNameById('ledger',$payment_dtls['party_id'],'id');
					$paymentname = getNameById('ledger',$payment_dtls['recieve_ledger_id'],'id');
					
					$edited_by = ($payment_dtls['edited_by']!=0)?(getNameById('user_detail',$payment_dtls['edited_by'],'u_id')->name):'';
				
				$draftImage = '';	
				if($payment_dtls['save_status'] == 0)
                $draftImage = '<img src="'.base_url(). 'assets/images/draft_placeholder.png" class="img-circle" width="25%">';
				
				echo "<tr>
					<td data-label='id:'>".$draftImage.$payment_dtls['id']."</td>
					<td data-label='Invoice id:'>".$invoice_id_or_advanced."</td>
					<td data-label='Name:'><a href='javascript:void(0)' id='".$payment_dtls['party_id'] ."' data-id='ledger_view' ata-toggle='modal' class='add_account_tabs'>".@$name->name."</a></td>  
					
					<td data-label='Balance:'>".abs($payment_dtls['balance'])."</td>
					<td data-label='Credited Amount:'>".abs($payment_dtls['amount_to_credit'])."</td>
					<td data-label='Paid Amount:'>".abs($payment_dtls['added_amount'])."</td>
					
					<td data-label='Created on:'>".date("j F , Y", strtotime($payment_dtls['created_date']))."</td>
					<td data-label='Created By:'><a href='".base_url()."users/edit/".$payment_dtls['created_by']."' target='_blank'>".getNameById('user_detail',$payment_dtls['created_by'],'u_id')->name."</a></td>	
					<td data-label='action:' class='hidde action' ><i class='fa fa-cog'></i><div class='on-hover-action'>".$action."</div></td></tr>";
				
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
		<?php echo $this->pagination->create_links(); ?>	
		 <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
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