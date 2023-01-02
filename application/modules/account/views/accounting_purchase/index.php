<div class="x_content">
<?php
	 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');

	?>
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	       <form class="form-search" method="get" action="<?= base_url() ?>account/accounting_purchase">
			<div class="col-md-6">
			<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,invoice number" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>" data-ctrl="account/accounting_purchase">

					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
                        <a href="<?php echo base_url(); ?>account/accounting_purchase"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
				</div>
			</form>
            	<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>account/accounting_purchase">
			<input type="hidden" name="order" id="order" value="<?php if($_POST['order']==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			</form>
			<button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
			 <div id="demo" class="collapse">
			        <div class="col-md-12 datePick-left col-xs-12 col-sm-12">
							<fieldset>
								<div class="control-group">
								  <div class="controls">
									<div class="input-prepend input-group">
									  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
									  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/accounting_purchase"/>
									</div>
								  </div>
								</div>
							</fieldset>
							<form action="<?php echo base_url(); ?>account/accounting_purchase" method="get" id="date_range">
							   <input type="hidden" value='' class='start_date' name='start'/>
							  <input type="hidden" value='' class='end_date' name='end'/>
							</form>
						</div>


			 <?php

						if($company_brnaches->multi_loc_on_off == 1){
							if(!empty($company_brnaches)){
						?>
				<form action="<?php echo site_url(); ?>account/accounting_purchase" method="get" id="select_from_brnch">
					<div class="required item form-group company_brnch_div2" >
						<label class="col-md-8 col-sm-8 col-xs-12 required control-label" for="company_branch">Company Branch</label>
						<div class="col-md-12 col-sm-12 col-xs-12">
						<select class="itemName form-control Get_data_accoriding_tobranch" name="selected_branch_idd" required="required"
							name="compny_branch_id" width="100%">
							<option value=""> Select Company Branch </option>
							<option >All</option>
							<?php
								 $branch_Add = json_decode($company_brnaches->address);
								 foreach($branch_Add as $val_branch){ ?>
								<option <?php if($val_branch->add_id == $_POST['selected_branch_idd']){ ?> selected="selected" <?php }?> value="<?php echo $val_branch->add_id; ?>"><?php echo $val_branch->compny_branch_name; $_POST['compny_branch_id']; ?> </option>

							</option>
						<?php } ?>
						</select>

						</div>
						<input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
						<input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>

						<div class="col-md-12"><input type="submit" value="Filter" class="btn btn-info"></div>
					</div>
				</form>
				<?php
				}
				}
				?>
				</div>
	  </div>
</div>

	<div class="row hidde_cls">

			<?php

			$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

			if($this->session->flashdata('message') != ''){
					echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
					setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
				}?>
			<p class="text-muted font-13 m-b-30"></p>
			<div class="row hidde_cls">
				<div class="col-md-12">
					<center>
					<div class="export_div">

						<div class="btn-group"  role="group" aria-label="Basic example">
						   <?php if($can_add) {

							echo '<a href="'.base_url().'account/Create_accounting_purchase" class="btn btn-success addBtn"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</a>';
						} ?>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
							<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
								<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu" id="export-menu">
										<li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
										<li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>

									</ul>
							</div>
							<!--button type="button" class="btn btn-default " data-toggle="collapse" data-target="#demo3" aria-expanded="true">Import<span class="caret"></span></button>

				<div id="demo3" class="collapse " aria-expanded="true" style="">
					<table  class="table table-striped table-bordered" data-id="account">
						<thead>
							<tr><th>Upload Invoices excel file</th></tr>
						</thead>
							<tbody>
								<tr>
									<td>
										<form action="<?php //echo base_url();?>account/import_invoices" method="post" enctype="multipart/form-data">
											<input type="file" name="uploadFile" value="" />
											<input type="submit" name="upload_invoices_data" value="Upload" class="btn btn-primary" />
										</form>
									</td>
								</tr>
							</tbody>
					</table>
				</div-->
						</div>
			<div class="col-md-3 datePick-right col-xs-12 col-sm-12">
			<form action="<?php echo base_url(); ?>account/accounting_purchase" method="get" id="date_range">
				 <input type="hidden" value='' class='start_date' name='start'/>
				 <input type="hidden" value='' class='end_date' name='end'/>
			</form>
				<form action="<?php echo site_url(); ?>account/accounting_purchase" method="get" id="export-form">
					<input type="hidden" value='' id='hidden-type' name='ExportType'/>
					<input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
					<input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
                    <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
				</form>
				<form action="<?php echo site_url(); ?>account/Create_invoice_blankxls" method="get" id="export-form-blank">
					<input type="hidden" value='' id='hidden-type-blank-excel' name='ExportType_blank'/>
				</form>
				<form action="<?php echo site_url(); ?>account/create_pdf_all" method="get" id="export-form-pdf">
					<input type="hidden" value="<?php echo $this->companyGroupId; ?>"  name="login_c_id">
					<input type="hidden" value='' class='start_date' name='start'/>
					<input type="hidden" value='' class='end_date' name='end'/>
				</form>

			</div>
					</div>
					</center>
				</div>
			</div>

	</div>


	<div class="" role="tabpanel" data-example-id="togglable-tabs">
			<ul id="myTab" class="nav nav-tabs bar_tabs invoice-tab" role="tablist">
				<li role="presentation" class="active"><a href="#tab_content_accepted_invoice" id="invoice_tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="invoice();">Accounting Purchase</a></li>

			</ul>
		<div id="myTabContent" class="tab-content">
		<div role="tabpanel" class="tab-pane fade active in" id="tab_content_accepted_invoice" aria-labelledby="invoice_tab">

	    <form id="invoice_form"><input type="hidden" value="invoice" name="tab"></form>
		<!------datatable-buttons----->
		<div id="print_div_content">
				<table  class="table table-striped table-bordered action-icons " data-id="account" style="width:100%" border="1" cellpadding="3">
				<!--<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">---->
				<thead>
					<tr>
						<th scope="col">Id<span><a href="<?php echo base_url(); ?>account/invoices?tab=invoice&sort=asc" class="up"></a>
							<a href="<?php echo base_url(); ?>account/invoices?tab=invoice&sort=desc" class="down"></a></span>
						</th>
						<th scope="col">Invoice Number<span><a href="<?php echo base_url(); ?>account/invoices?tab=invoice&sort=asc" class="up"></a>
							<a href="<?php echo base_url(); ?>account/invoices?tab=invoice&sort=desc" class="down"></a></span>
							</th>
						<th scope="col">Party Name<span><a href="<?php echo base_url(); ?>account/invoices?tab=invoice&sort=asc" class="up"></a>
							<a href="<?php echo base_url(); ?>account/invoices?tab=invoice&sort=desc" class="down"></a></span>
						</th>
						<th scope="col">Sale Ledger<span><a href="<?php echo base_url(); ?>account/invoices?tab=invoice&sort=asc" class="up"></a>
						<a href="<?php echo base_url(); ?>account/invoices?tab=invoice&sort=desc" class="down"></a></span>
						</th>

						<th scope="col">Tax</th>
						<th scope="col">Amount</th>
						<th scope="col">Issue Date</th>
						<th scope="col" class='hidde'>Created By</th>
						<th scope="col" class='hidde'>Edited By</th>
						<th scope="col" class='hidde'>Created On</th>
						<th scope="col" class='hidde'>Action</th>
					</tr>
				</thead>
					<tbody>
						<?php
							$date = $freeze_date->freeze_date;
							if(!empty($add_invoice_details)){
								foreach($add_invoice_details as $invoice){


									 $salePerson_name = getNameById('user_detail',$invoice['sales_person'],'u_id');
								if($invoice['accept_reject'] != 1 ){	//'0','for accept','1','reject'
										$action = '';
										$get_invoice_cancel_restore_dtl = getNameById('company_detail',$this->companyGroupId,'id');

										if($can_edit) {
												if($invoice['created_date'] < $date){
													//$action .=  '<a disabled="disabled" href="javascript:void(0)" id="'. $invoice["id"] . '" data-id="invoice_details" class="btn btn-edit   btn-xs" data-tooltip="Edit" id="' . $invoice["id"] . '"><i class="fa fa-pencil" ></i>  </a>';
												}
												else{

													$action .=  '<a href="'.base_url().'account/editaccountingPurchase_details/'.$invoice["id"].'"  class=" btn btn-edit  btn-xs" data-tooltip="Edit"><i class="fa fa-pencil"></i>  </a>';
												}
													$action .=  '<a href="javascript:void(0)" id="'. $invoice["id"] . '" data-id="accountingpurchase_view_details" class="add_invoice_details btn-view  btn  btn-xs" data-tooltip="View" id="' . $invoice["id"] . '"><i class="fa fa-eye"></i>  </a>';
												}



											if($can_delete) {
													$action = $action.'<a href="javascript:void(0)"  class="delete_listing btn  btn-delete  btn  btn-xs" data-tooltip="Delete"   data-href="'.base_url().'account/deleteaccPurchase_details/'.$invoice["id"].'" ><i class="fa fa-trash"></i></a>';
											}
											// 0 means off cancel restore functionality 1 means ON Cancel restore Functionality
											if($get_invoice_cancel_restore_dtl->invoice_cancl_restor != 0 &&  $invoice["pay_or_not"] == 0){
												if($invoice["inv_cancel_restore"] == '' || $invoice["inv_cancel_restore"] == '1'){
												$action = $action.'<a href="javascript:void(0)"  class="cancel_and_restore_invoice btn  btn-delete  btn  btn-xs" data-tooltip="Cancel Invoice"   data-href="'.base_url().'account/cancelPurchase_details/'.$invoice["id"].'" ><i class="fa fa-times" aria-hidden="true"></i></a>';
												}else{
												$action = $action.'<a href="javascript:void(0)"  class="cancel_and_restore_invoice btn  btn-delete  btn  btn-xs" data-tooltip="Restore"   data-href="'.base_url().'account/restorePurchase_details/'.$invoice["id"].'" ><i class="fa fa-undo" aria-hidden="true"></i></a>';
												}
											}


								$edited_by = ($invoice['edited_by']!=0)?(getNameById('user_detail',$invoice['edited_by'],'u_id')->name):'';
								/*$material_id_datas = json_decode($invoice['descr_of_goods'],true);
								if($material_id_datas == ''){

								}else{
									$material_names = '';
									foreach($material_id_datas  as $matrial_new_id){
										$material_id_get = $matrial_new_id['material_id'];
										@$material_name = ($material_id_get!=0)?(getNameById('material',$material_id_get,'id')->material_name):'';
										@$material_names .= $material_name.',';

									}
								}*/


					$party_name = getNameById('ledger',$invoice['party_name'],'id');

					$sale_ledger_name = getNameById('ledger',$invoice['sale_ledger'],'id');


				$draftImage = '';
				if($invoice['save_status'] == 0)
                $draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';

				echo "<tr>
					<td data-label='id:'>".$draftImage.$invoice['id']."</td>
					<td data-label='Invoice Number:'>".$invoice['invoice_num']."</td>
					<td data-label='Party Name:'><a href='javascript:void(0)' id='". $invoice['party_name'] . "' data-id='ledger_view' class='add_account_tabs'>".$party_name->name."</a></td>
					<td data-label='Sale Ledger:'><a href='javascript:void(0)' id='". $invoice['sale_ledger'] . "' data-id='ledger_view' class='add_account_tabs'>".$sale_ledger_name->name."</a></td>
					<td data-label='tax:'>".$invoice['totaltaxAMT']."</td><td data-label='tax:'>".$invoice['TotalWithTax']."</td>";


				$output[] = array(
							   'Purchase ID' => $invoice['id'],
							   'Invoice Number' => $invoice['invoice_num'],
							   'Party Name' => @$party_name->name,
							   'Ledger' => @$sale_ledger_name->name,
							   'Tax % ' => $invoice['taxvalue'],
							   'Total Tax' => $invoice['totaltaxAMT'],
							   'Grand Total' => $invoice['TotalWithTax'],
							   'Created Date' => date("d-m-Y", strtotime($invoice['date_time_of_invoice_issue'])),
							);


						echo "<td data-label='Issue Date:' class='hidde'>".date("j F , Y", strtotime($invoice['date_time_of_invoice_issue']))."</td>
							<td data-label='Created By:'><a href='".base_url()."users/edit/".$invoice['created_by']."' target='_blank'>".getNameById('user_detail',$invoice['created_by'],'u_id')->name."</a></td>
							<td data-label='Edited By:' class='hidde'>".$edited_by."</td>
							<td data-label='Created On:' class='hidde'>".date("j F , Y", strtotime($invoice['created_date']))."</td>
							<td data-label='Action:' class='hidde'>".$action."</td>
						</tr>";
				}



					}

			    $data3  = $output;

				export_csv_excel($data3);
			 }

	   ?>


		</tbody>
	</table>
    <?php//echo $this->pagination->create_links(); ?>
	</div>
</div>

	</div>
	<?php echo $this->pagination->create_links(); ?>
		  <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;"><?php echo $result_count; ?></span></div>
</div>
</div>
<div id="add_invoice_detail_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog  modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">  Detail</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>

<div id="add_invoice_report_modal" class="modal fade in "  role="dialog">
	<div class="modal-dialog modal-lg modal-large child-modal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Invoice Report</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
<?php $this->load->view('common_modal'); ?>
