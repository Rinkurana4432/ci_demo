<div class="x_content">
<?php
setlocale(LC_MONETARY, 'en_IN.UTF-8');//Function for Indian currency format
	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');

?>
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	           <form class="form-search" method="get" action="<?= base_url() ?>account/sale_register/">
			<div class="col-md-6">
            	<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,Material Name" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>" data-ctrl="account/sale_register">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
						  <a href="<?php echo base_url(); ?>account/sale_register"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
                </div>
			</form>
            <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>account/sale_register">
			<input type="hidden" name="order" id="order" value="<?php if($_POST['order']==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			</form>
			<button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
			 <div id="demo" class="collapse">
			       <div class="col-md-4">
				<fieldset>
					<div class="control-group">
					  <div class="controls">
						<div class="input-prepend input-group">
						  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/sale_register"/>
						</div>
					  </div>
					</div>
				  </fieldset>
				   <form action="<?php echo base_url(); ?>account/sale_register?tab=<?php echo $_GET['tab']; ?>" method="GET" >
						<div class="row hidde_cls filter1 progress_filter">
							<div class="col-md-12 col-xs-12">
							  <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
								<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="sales_person" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $this->companyGroupId; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">

								 </select>
							  </div>
							   <input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="account/sale_register" disabled="disabled">
							</form>
						</div>
					</div>
				</div>
			</div>
  </div>
</div>
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
	<p class="text-muted font-13 m-b-30"></p>

	<br/>
	<form action="<?php echo site_url(); ?>account/sale_register" method="get" id="export-form">
		<input type="hidden" value='' id='hidden-type' name='ExportType'/>
		<input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
		<input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
		<input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
	</form>
	<form action="<?php echo site_url(); ?>account/create_pdf_all" method="get" id="export-form-pdf">
		<input type="hidden" value="<?php echo $this->companyGroupId; ?>"  name="login_c_id">
		<input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
		<input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
		<input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
	</form>
	<form action="<?php echo base_url(); ?>account/sale_register" method="get" id="date_range">
	<input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
		<input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
	</form>
<div class="row hidde_cls">
	<div class="col-md-12 export_div">

			<div class="btn-group"  role="group" aria-label="Basic example">
				<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
				<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
				<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
					<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
						<ul class="dropdown-menu" role="menu" id="export-menu">
							<li id="export-to-excel"><a href="javascript:void();" title="Please check your open office Setting">Export to excel</a></li>
							<li id="export-to-csv"><a href="javascript:void();" title="Please check your open office Setting">Export to csv</a></li>
							<!--li id="export-to-pdf"><a href="javascript:void();" title="Please check your open office Setting">Export to Pdf</a></li-->
						</ul>
				</div>
				<!--<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
					<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Company Branch <span class="caret"></span></button>
						<ul class="dropdown-menu" role="menu" id="export-menu">
							<li id="export-to-excel">
							<a href="javascript:void();" title="Please check your open office Setting">Export to excel</a>
							</li>


						</ul>
				</div>-->

		</div>
	</div>
</div>
  <div id="print_div_content">


         <table id="" class="table table-striped table-bordered get_Data_fortbl" data-id="account"  border="1"  data-order='[[1,"desc"]]' style="margin-top:30px;">
			<thead>
			<tr>
				<th scope="col">Id
					<span>
						<a href="<?php echo base_url(); ?>account/sale_register?sort=asc" class="up"></a>
						<a href="<?php echo base_url(); ?>account/sale_register?sort=desc" class="down"></a>
					</span>
				</th>
				<!-- <th scope="col">Material
					<span>
						<a href="<?php echo base_url(); ?>account/sale_register?sort=asc" class="up"></a>
						<a href="<?php echo base_url(); ?>account/sale_register?sort=desc" class="down"></a>
					</span>
				</th> -->
				<th scope="col">Invoice No.
					<span><!--
						<a href="<?php echo base_url(); ?>account/sale_register?sort=asc" class="up"></a>
						<a href="<?php echo base_url(); ?>account/sale_register?sort=desc" class="down"></a> -->

					</span>
				</th>
				<th scope="col">Party Name
					<span>
						<a href="<?php echo base_url(); ?>account/sale_register?sort=asc" class="up"></a>
						<a href="<?php echo base_url(); ?>account/sale_register?sort=desc" class="down"></a>
					</span>
				</th>
				<th scope="col">Sales Person</th>
				<th scope="col">Total</th>
				<th scope="col">Tax</th>
				<th scope="col">Amount With Tax</th>
				<th scope="col">Alt Quantity <!-- / UOM --></th>
				<th scope="col">Paid or Not</th>
				<th scope="col">Created By</th>
				<th scope="col">Voucher Date</th>
				<th scope="col" class='hidde'>Action</th>
			</tr>
		</thead>
		<tbody>

		   <?php

		   if(!empty($saleReg_Data)){

				$sum_tax = $sum_total = $sum_total_with_tax = 0;

				$total = $totaltax = $toalAmountWithTax = 0;


			   foreach($saleReg_Data as $invoice){
				 $salePerson_name = getNameById('user_detail',$invoice['sales_person'],'u_id');
				$action = '';

					$action .=  '<a href="javascript:void(0)" id="'. $invoice["id"] . '" data-id="sale_ledger_details" class="sale_ledger_details btn btn-warning btn-xs" id="' . $invoice["id"] . '" data-tooltip="View"><i class="fa fa-eye"></i></a>';


					$edited_by = ($invoice['edited_by']!=0)?(getNameById('user_detail',$invoice['edited_by'],'u_id')->name):'';

					$total_tax_dtl = json_decode($invoice['invoice_total_with_tax']);

					 $sum_tax+= (int)$total_tax_dtl[0]->totaltax;
					 $sum_total+= (int)$total_tax_dtl[0]->total;
					 $sum_total_with_tax+= (int)$total_tax_dtl[0]->invoice_total_with_tax;
					 $dd = count($descr_of_goods_qty_rate_tax);


					$material_id_datas = json_decode($invoice['descr_of_goods'],true);

					if($material_id_datas == ''){

					}else{
						$material_names = '';
						foreach($material_id_datas  as $matrial_new_id){
							$material_id_get = $matrial_new_id['material_id'];
							@$material_name = ($material_id_get!=0)?(getNameById('material',$material_id_get,'id')->material_name):'';
							@$material_names1 .= $material_name.',';
							@$material_names .= '<a href="javascript:void(0)" id="'.$material_id_get.'" data-id="material_view" class="inventory_tabs"> '.$material_name.'</a>,';
							$output[] = array(
								   'Invoice No.' => $invoice['id'],
								   'Material Name'  => $material_name,
								   'Party Name' => $party_name->name,
								   'Sub Total' => money_format('%!i',$total_tax_dtl[0]->total),
								   'Tax' => money_format('%!i',$total_tax_dtl[0]->totaltax),
								   'Amount With Tax' => money_format('%!i',$total_tax_dtl[0]->invoice_total_with_tax),
								   'Paid Or Not' => $paid_or_not,
								   'Registration Type' => getNameById('user_detail',$invoice['created_by'],'u_id')->name,
								   'Created Date' => date("d-m-Y", strtotime($invoice['date_time_of_invoice_issue'])),
								);

						}
					}

					$party_name = getNameById('ledger',$invoice['party_name'],'id');
					$sale_ledger_name = getNameById('ledger',$invoice['sale_ledger'],'id');

					if($invoice['pay_or_not'] =='1'){
						$paid_or_not =  'Paid';
					}else{
						$paid_or_not = 'Not Paid';
					}
					$descr_of_goods_qty_rate_tax = json_decode($invoice['descr_of_goods']);






				$alterqty = "N/A";
				foreach($descr_of_goods_qty_rate_tax as $get_qty_uom){

						$alterqty = $get_qty_uom->alterqty;


					 $qqty = $get_qty_uom->quantity;
					 $uuom = $get_qty_uom->UOM;
					 $uom_name = getNameById('uom',$uuom,'id');

				}

				if($dd > 1){
						$Details_view = '<a inv-id="'.$invoice['id'].'" href="javascript:void(0)" class="get_quantity_details"><span style="font-size:11px;"> View Detail </span></a>';
						}else{
							$Details_view = '';
						}
						//$resultss = substr_count( $material_names, ",");

				echo "<tr>
					<td data-label='id:'>".$invoice['id']."</td>

					<td data-label='Material:'>".$invoice['invoice_num']."</td>
					<td data-label='Party Name:'><a href='javascript:void(0)' id='". $invoice['party_name'] . "' data-id='ledger_view' class='add_account_tabs'>".$party_name->name."</a></td>
					<td>".$salePerson_name->name."</td>
					<td data-label='Total:'>".money_format('%!i',(int)$total_tax_dtl[0]->total)."</td>

					<td data-label='Tax:' class='txxx'>".money_format('%!i',(int)$total_tax_dtl[0]->totaltax)."</td>
					<td data-label='Amount With Tax:'>".money_format('%!i',(int)$total_tax_dtl[0]->invoice_total_with_tax)."</td>
					<td data-label='Quantity:'>".$alterqty.//$qqty.' / '.$uom_name->uom_quantity."</td>

					"</td>
					<td data-label='Paid or Not:'>".$paid_or_not."</td>
					<td data-label='Created By:'><a href='".base_url()."users/edit/".$invoice['created_by']."'>".getNameById('user_detail',$invoice['created_by'],'u_id')->name."</a></td>
					<td data-label='Voucher Date:'>". date("j F , Y", strtotime($invoice['date_time_of_invoice_issue']))."</td>
					<td data-label='Action:' class='hidde'>".$action."</td>
				</tr>";
				$total += (int)$total_tax_dtl[0]->total;
				$totaltax += (int)$total_tax_dtl[0]->totaltax;
				$toalAmountWithTax += (int)$total_tax_dtl[0]->invoice_total_with_tax;


			}
		$data3  = $output;
		//pre($data3);
		export_csv_excel($data3);
	   ?>
			 </tbody>

			<tr  class='php_ddta'>

                <th colspan="4" style="text-align:right;">Total  </th>
                <th class="tx_cls_php"><?php echo money_format('%!i',(int)$sum_total); ?></th>
				<th  class="totlamt_php"><?php echo money_format('%!i',(int)$sum_tax); ?></th>
                <th class="totltxamt_php"><?php echo money_format('%!i',($sum_tax + $sum_total )); ?></th>
				 <!--th><a href="javascript:void(0)" class="get_quantity_details">Quantity Details</a></th-->
				<th colspan="6"></th>
            </tr>
			<?php
				$totalw = $totaltax_w = $total_with_tax = 0;



				foreach($allSaleRegData as $invoice){
					$grandData = json_decode($invoice['invoice_total_with_tax']);
					 $grandsum_tax+= (int)$grandData[0]->totaltax;
					 $grandsum_total+= (int)$grandData[0]->total;
					 $grandsum_total_with_tax+= (int)$grandData[0]->invoice_total_with_tax;
				}
			?>
			 <tr><td colspan="12"></td></tr>
			 <tr>

				 <th colspan="4" style="text-align:right;">Grand  </th>
                 <th  class="totlamt_php"><?php echo money_format('%!i',(int)$grandsum_total); ?></th>
                 <th class="tx_cls_php"><?php echo money_format('%!i',(int)$grandsum_tax); ?></th>
                 <th class="totltxamt_php"><?php echo money_format('%!i',($grandsum_total + $grandsum_tax )); ?></th>

            </tr>

			<?php }else{ ?>
			    <tr><td colspan="12" style="text-align:center;">No Data Avilable.</td></tr>
			<?php } ?>


	</table>








	<!--table class="table table-dark table-striped table-bordered"  border="1" cellpadding="3" style="width: 50%;text-align: center;">
	  <thead>
			<tr>
				<th style="text-align: center;">Total</th>
				<th style="text-align: center;">Tax Total</th>
				<th style="text-align: center;">Grand Total</th>
			</tr>

		</thead>
	<tbody>
		  <?php
		  $totalw = $totaltax_w = $total_with_tax = 0;
			foreach($saleReg_Data as $total_amt){
			$in_ttl = json_decode($total_amt['invoice_total_with_tax']);
			$totalw += $in_ttl[0]->total;
			$totaltax_w += $in_ttl[0]->totaltax;
			$total_with_tax += $in_ttl[0]->invoice_total_with_tax;
			}
		  ?>
	  <tr class="chks" >
		<td><?php //echo money_format('%!i',$totalw); ?></td>
		<td><?php //echo money_format('%!i',$totaltax_w);?></td>
		<td><?php //echo money_format('%!i',$total_with_tax); ?></td>
	 </tr>
	  </tbody>
	</table-->
</div>
</div>
  <?php echo $this->pagination->create_links(); ?>
    <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
<div id="add_invoice_detail_modal_sale" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Invoice Detail</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>

<div id="Quantity_details" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Quantity Details</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
	</div>



<?php
 $this->load->view('common_modal');
?>
