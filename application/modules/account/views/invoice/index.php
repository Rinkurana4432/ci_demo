<div class="x_content">
<?php
	 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');

	?>
<div class="col-md-12 col-xs-12 for-mobile">
	<div class="__messages"></div>
      <div class="Filter Filter-btn2">
	       <form class="form-search" method="get" action="<?= base_url() ?>account/invoices">
			<div class="col-md-6">
			<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,invoice number,Material" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>" data-ctrl="account/invoices?tab=<?php if(!empty($_GET['tab'])){echo $_GET['tab'];}?>">
					<input type="hidden" name="tab" value="<?php if(!empty($_GET['tab'])){echo $_GET['tab'];}?>"/>
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
                        <a href="<?php echo base_url(); ?>account/invoices?tab=<?php if(isset($_GET['tab'])){echo $_GET['tab'];}?>"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
				</div>
			</form>
            	<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>account/invoices">
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
									  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/invoices"/>
									</div>
								  </div>
								</div>
							</fieldset>
							<form action="<?php echo base_url(); ?>account/invoices" method="get" id="date_range">
							   <input type="hidden" value='' class='start_date' name='start'/>
							  <input type="hidden" value='' class='end_date' name='end'/>
							</form>
						</div>


			 <?php

						if($company_brnaches->multi_loc_on_off == 1){
							if(!empty($company_brnaches)){
						?>
				<form action="<?php echo site_url(); ?>account/invoices" method="get" id="select_from_brnch">
					<div class="item form-group company_brnch_div2" >
						<label class="col-md-8 col-sm-8 col-xs-12 required control-label" for="company_branch">Company Branch</label>
						<div class="col-md-12 col-sm-12 col-xs-12">
						<select class="itemName form-control Get_data_accoriding_tobranch" name="selected_branch_idd"
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
						<label class="col-md-8 col-sm-8 col-xs-12 required control-label" for="company_branch">Sales Person</label>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<select class="itemName form-control selectAjaxOption select2 requiredData select2-hidden-accessible" placeholder="Sales Person" name="sales_person" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = 76" width="100%" tabindex="-1" aria-hidden="true">
									<option value="">Select Option</option>
							</select>
						</div>
						<input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
						<input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
						<!--button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
						<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="create_excel">Create Excel</button-->
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
							//echo '<button type="button" class="btn btn-success addBtn add_invoice_details" data-toggle="modal" id="add" data-id="invoice_details"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
							echo '<a href="'.base_url().'account/Create_invoice" class="btn btn-success addBtn"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</a>';
						} ?>
							<!-- <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button> -->
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
							<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
								<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu" id="export-menu">
										<li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
										<li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
										<!--li id="export-to-pdf"><a href="javascript:void(0);" title="Please check your open office Setting">Export to Pdf</a></li-->
										<li id="export-to-blank-excel"><a href="<?php echo base_url()?>account/Create_invoice_blankxls" title="Please check your open office Setting">Export to Blank Excel</a></li>
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
			<form action="<?php echo base_url(); ?>account/invoices" method="get" id="date_range">
				 <input type="hidden" value='' class='start_date' name='start'/>
				 <input type="hidden" value='' class='end_date' name='end'/>
			</form>
				<form action="<?php echo site_url(); ?>account/invoices" method="get" id="export-form">
					<input type="hidden" value='' id='hidden-type' name='ExportType'/>
					<input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
					<input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
					<input type="hidden" value='<?php if(isset($_GET['tab']))echo $_GET['tab'];?>' name='tab'/>
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
				<li role="presentation" class="active"><a href="#tab_content_accepted_invoice" id="invoice_tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="invoice();">Invoices</a></li>
				<!-- <li role="presentation" class=""><a href="#rejected_invoice_tab" role="tab" id="auto_entery_tab" data-toggle="tab" aria-expanded="false" onclick="reject_invoice();">Rejected Invoices</a></li> -->
				<!--li role="presentation" class=""><a href="#rejected_invoice_tab" role="tab" id="auto_entery_tab" data-toggle="tab" aria-expanded="false" onclick="reject_invoice();">Inactive Invoice</a></li-->
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
						<th scope="col">Sales Person</th>
						<th scope="col">Material</th>
						<th scope="col">Paid or Not</th>
						<th scope="col" class='hidde'>Issue Date</th>
						<th scope="col" >Created By</th>
						<th scope="col" class='hidde'>Edited By</th>
						<th scope="col" >Created On</th>
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
												if($invoice["inv_cancel_restore"] == '0'){
													$action .=  '<a href="javascript:void(0)" id="'. $invoice["id"] . '" data-id="invoice_details" class="btn btn-edit  btn-xs" id="' . $invoice["id"] . '" disabled>Edit</a>';
												}else{
													//$action .=  '<a href="javascript:void(0)" id="'. $invoice["id"] . '" data-id="invoice_details" class="add_invoice_details btn btn-edit  btn-xs" data-tooltip="Edit" id="' . $invoice["id"] . '"><i class="fa fa-pencil"></i>  </a>';
													if(empty($invoice['e_invoice_link']) && empty($invoice['e_way_bill_link'])){
														$action .=  '<a href="'.base_url().'account/editInvoice_details/'.$invoice["id"].'"  class=" btn btn-edit  btn-xs" onclick="usekeyupfun();" >Edit</a>';
													}
												}
													$action .=  '<a href="javascript:void(0)" id="'. $invoice["id"] . '" data-id="invoice_view_details" class="add_invoice_details btn-view  btn  btn-xs"  id="' . $invoice["id"] . '">View</a>';
												}

												$action .=  '<a href="javascript:void(0)" id="'. $invoice["id"] . '" data-id="invoice_report_details" class="check_invoice_report btn-view  btn  btn-xs"  id="' . $invoice["id"] . '">Report</a>';


											if($can_delete) {
													$action = $action.'<a href="javascript:void(0)"  class="delete_listing btn  btn-delete  btn  btn-xs"    data-href="'.base_url().'account/deleteInvoice_details/'.$invoice["id"].'/1" >Delete</a>';
											}
											// 0 means off cancel restore functionality 1 means ON Cancel restore Functionality
											if($get_invoice_cancel_restore_dtl->invoice_cancl_restor != 0 &&  $invoice["pay_or_not"] == 0){
												if($invoice["inv_cancel_restore"] == '' || $invoice["inv_cancel_restore"] == '1'){
												$action = $action.'<a href="javascript:void(0)"  class="cancel_and_restore_invoice btn  btn-delete  btn  btn-xs"   data-href="'.base_url().'account/cancelInvoice_details/'.$invoice["id"].'" >Cancel Invoice</a>';
												}else{
												$action = $action.'<a href="javascript:void(0)"  class="cancel_and_restore_invoice btn  btn-delete  btn  btn-xs"   data-href="'.base_url().'account/restoreInvoice_details/'.$invoice["id"].'" >Restore</a>';
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
					$material_id_datas_export = json_decode($invoice['descr_of_goods'],true);

					if($material_id_datas_export == ''){
					}else{
						$material_names_export = '';
						foreach($material_id_datas_export  as $matrial_new_id_export){
							$material_id_get_export = $matrial_new_id_export['material_id'];
							@$material_name_export = ($material_id_get_export!=0)?(getNameById('material',$material_id_get_export,'id')->material_name):'';
							@$material_names_export .= $material_name_export.' ';

						}
					}


					//$voucher_name = ($material_id_get!=0)?(getNameById('material',$material_id_get,'id')->material_name):'';
					//$invoice_count = count($vouchers['descr_of_goods']);

					$party_name = getNameById('ledger',$invoice['party_name'],'id');

					$sale_ledger_name = getNameById('ledger',$invoice['sale_ledger'],'id');

					if($invoice['pay_or_not'] =='1'){
						$paid_or_not =  'Paid';
					}else{
						$paid_or_not = 'Not Paid';
					}
				$draftImage = '';

				if($invoice['save_status'] == 0)
                $draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';
				$eInvoiceIcon = '';
				$eInvoiceIconAlone = '';
				$eEwayBillIcon = '';
				$selection = '';
				$selectionEway = '';
				$selectionInvoice = '';
				if($invoice['save_status'] != 0){
					if(!empty($invoice['e_invoice_link']) || !empty($invoice['e_way_bill_link'])){
						$selectionInvoice = 'disabled';
						$selection = 'disabled';
						$selectionEway = 'disabled';
					}

					$eInvoiceIcon = '<a href="javascript:void(0)"  class="__generateEInvoice btn  btn  btn-xs '.$selection.'" data-type="1"   data-href="" data-id="'.$invoice['id'].'">Create E-Invoice/E-Way Bill</a>';

					$eInvoiceIconAlone = '<a href="javascript:void(0)"  class="__generateEInvoice btn  btn  btn-xs '.$selection.'"   data-href="" data-type="2" data-id="'.$invoice['id'].'">Create E-Invoice</a>';


					$eEwayBillIcon = '<a href="javascript:void(0)"  class="__generateEwayBill btn  btn  btn-xs '.$selectionEway.'"    data-href="" data-id="'.$invoice['id'].'">Create E-Way Bill</a>';

					//$eWayBillIcon = '<a href="javascript:void(0)"  class="__generateEWayBill btn  btn  btn-xs" data-tooltip="Generate E-Way Bill"   data-href="" data-id="'.$invoice['id'].'"><i class="fa fa-file" aria-hidden="true"></i></a>';
				}
				$action = $action.' '.$eInvoiceIcon.' '.$eInvoiceIconAlone.' '.$eEwayBillIcon;
				echo "<tr>
					<td data-label='id:'>".$draftImage.$invoice['id']."</td>
					<td data-label='Invoice Number:'>".$invoice['invoice_num']."</td>
					<td data-label='Party Name:'><a href='javascript:void(0)' id='". $invoice['party_name'] . "' data-id='ledger_view' class='add_account_tabs'>".$party_name->name."</a></td>
					<td data-label='Sale Ledger:'><a href='javascript:void(0)' id='". $invoice['sale_ledger'] . "' data-id='ledger_view' class='add_account_tabs'>".$sale_ledger_name->name."</a></td>";
					echo '<td>'.$salePerson_name->name.'</td>';
					$material_id_datas = json_decode($invoice['descr_of_goods'],true);
							foreach($material_id_datas as $materialData){

									$ww =  getNameById('uom', $materialData['UOM'],'id');
									$uom = !empty($ww)?$ww->ugc_code:'';
										//For not show discount detail in count
							if($materialData['material_id']!=''  &&  $materialData['quantity'] !='' && $materialData['rate']!='' && $materialData['amount']!='' || $materialData['UOM']!=''){//For not show discount detail in count
								$materialName = getNameById('material',$materialData['material_id'],'id');



				}
				
				$output[] = array(
							   'Invoice ID' => $invoice['id'],
							   'Invoice Number' => $invoice['invoice_num'],
							   'Material Name' => $materialName->material_name,
							   //'Buyer Order No.' => $buyer_order_no,
							  // 'Email' => $invoice['email'],
							   'Party Name' => @$party_name->name,
							   'Sale Ledger' => @$sale_ledger_name->name,
							   'Amount' => @$invoice['total_amount'],
							   'Paid or Not' => @$paid_or_not,
							   //'Transport' => $invoice['transport'],
							   'Created Date' => date("d-m-Y", strtotime($invoice['created_date'])),
							);
			}

						echo "<td data-label='Material:'><a style='cursor: pointer;' class='add_invoice_details' id='".$invoice['id']."' data-toggle='modal' data-id='invoice_view_mat_details'>".$materialName->material_name."</a></td>
							<td data-label='Paid or Not:'>".$paid_or_not."</td>
							<td data-label='Issue Date:' class='hidde'>".date("j F , Y", strtotime($invoice['date_time_of_invoice_issue']))."</td>
							<td data-label='Created By:'><a href='".base_url()."users/edit/".$invoice['created_by']."' target='_blank'>".getNameById('user_detail',$invoice['created_by'],'u_id')->name."</a></td>
							<td data-label='Edited By:' class='hidde'>".$edited_by."</td>
							<td data-label='Created On:' >".date("j F , Y", strtotime($invoice['created_date']))."</td>
							<td data-label='Action:' class='hidde action'><i class='fa fa-cog'></i><div class='on-hover-action'>".$action."</div></td>
						</tr>";
						$position=25;
						$Matrl_name = substr(@$material_names_export, 0, $position);

						}


							$output_blank[] = array(
							   'Invoice ID' => '',
							   'Material Name' => '',
							   //'Buyer Order No.' => $buyer_order_no,
							  // 'Email' => $invoice['email'],
							   'Party Name' =>'',
							   'Sale Ledger' => '',
							   'Paid or Not' =>'',
							   //'Transport' => $invoice['transport'],
							   'Created Date' =>'',
							);
					}

			    $data3  = $output;

				$data_balnk3  = $output_blank;
				export_csv_excel_blank($data_balnk3);
				export_csv_excel($data3);
			 }

	   ?>


		</tbody>
	</table>
    <?php//echo $this->pagination->create_links(); ?>
	</div>
</div>
	<div role="tabpanel" class="tab-pane fade" id="rejected_invoice_tab" aria-labelledby="auto_entery_tab">

<!---<form class="form-search" method="get" action="<?= base_url() ?>account/invoices/">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Type your search word" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
					</span>
				</div>
			</form>
			<div class="col-md-6">
			<div class="input-group">
			<span class="input-group-addon">
						<i class="ace-icon fa fa-search"></i>
					</span>
			<input type="text" class="form-control search-query" placeholder="Type your search word" name="search" id="search" value="</?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>">
			</div></div>--->
	<form id="reject_invoice_form"><input type="hidden" value="reject_invoice" name="tab"></form>
	<table id="" class="table table-striped table-bordered action-icons" data-id="account" style="width:100%">
	<!---<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">---->
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
						<th scope="col">Sales Person</th>
						<th scope="col">Material</th>
						<th scope="col">Paid or Not</th>
						<th scope="col">Issue Date</th>
						<th scope="col" class='hidde'>Created By</th>
						<th scope="col" class='hidde'>Edited By</th>
						<th scope="col" class='hidde'>Created On</th>
						<th scope="col" class='hidde'>Action</th>
				<!-- <th scope="col">Id<span><a href="<?php echo base_url(); ?>account/invoices?tab=reject_invoice&sort=asc" class="up"></a>
					<a href="<?php echo base_url(); ?>account/invoices?tab=reject_invoice&sort=desc" class="down"></a></span>
				</th>
				<th scope="col">Party Name<span><a href="<?php echo base_url(); ?>account/invoices?tab=reject_invoice&sort=asc" class="up"></a>
					<a href="<?php echo base_url(); ?>account/invoices?tab=reject_invoice&sort=desc" class="down"></a></span>
				</th>
				<th scope="col">Sale Ledger<span><a href="<?php echo base_url(); ?>account/invoices?tab=reject_invoice&sort=asc" class="up"></a>
					<a href="<?php echo base_url(); ?>account/invoices?tab=reject_invoice&sort=desc" class="down"></a></span>
				</th>
				<th scope="col">Material<span><a href="<?php echo base_url(); ?>account/invoices?tab=reject_invoice&sort=asc" class="up"></a>
					<a href="<?php echo base_url(); ?>account/invoices?tab=reject_invoice&sort=desc" class="down"></a></span>
				</th>
				<th scope="col">Paid or Not</th>
				<th scope="col">Invoice Reject Reason</th>
				<th scope="col" class='hidde'>Created By</th>
				<th scope="col" class='hidde'>Created On</th>
				<th scope="col" class='hidde'>Action</th> -->
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
												 $action .=  '<a href="javascript:void(0)" id="'. $invoice["id"] . '" data-id="invoice_view_details" class="add_invoice_details btn-view  btn  btn-xs" data-tooltip="View" id="' . $invoice["id"] . '"><i class="fa fa-eye"></i>  </a>';
												}

									if($can_delete) {
													$action = $action.'<a href="javascript:void(0)"  class="delete_listing btn  btn-delete  btn  btn-xs" data-tooltip="Delete"   data-href="'.base_url().'account/deleteInvoice_details/'.$invoice["id"].'/0" ><i class="fa fa-undo"></i></a>';
											}

				$edited_by = ($invoice['edited_by']!=0)?(getNameById('user_detail',$invoice['edited_by'],'u_id')->name):'';

					$material_id_datas_export = json_decode($invoice['descr_of_goods'],true);

					if($material_id_datas_export == ''){
					}else{
						$material_names_export = '';
						foreach($material_id_datas_export  as $matrial_new_id_export){
							$material_id_get_export = $matrial_new_id_export['material_id'];
							@$material_name_export = ($material_id_get_export!=0)?(getNameById('material',$material_id_get_export,'id')->material_name):'';
							@$material_names_export .= $material_name_export.' ';
						}
					}

					//$voucher_name = ($material_id_get!=0)?(getNameById('material',$material_id_get,'id')->material_name):'';
					//$invoice_count = count($vouchers['descr_of_goods']);

					$party_name = getNameById('ledger',$invoice['party_name'],'id');

					$sale_ledger_name = getNameById('ledger',$invoice['sale_ledger'],'id');

					if($invoice['pay_or_not'] =='1'){
						$paid_or_not =  'Paid';
					}else{
						$paid_or_not = 'Not Paid';
					}
				$draftImage = '';

				if($invoice['save_status'] == 0)
                $draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';
				$eInvoiceIcon = '';
				$eInvoiceIconAlone = '';
				$eEwayBillIcon = '';
				$selection = '';
				$selectionEway = '';
				$selectionInvoice = '';
				if($invoice['save_status'] != 0){
					if(!empty($invoice['e_invoice_link']) || !empty($invoice['e_way_bill_link'])){
						$selectionInvoice = 'disabled';
						$selection = 'disabled';
						$selectionEway = 'disabled';
					}

					$eInvoiceIcon = '<a href="javascript:void(0)"  class="__generateEInvoice btn  btn  btn-xs '.$selection.'" data-tooltip="Create E-Invoice/E-Way Bill" data-type="1"   data-href="" data-id="'.$invoice['id'].'"><i class="fa fa-file" aria-hidden="true"></i></a>';

					$eInvoiceIconAlone = '<a href="javascript:void(0)"  class="__generateEInvoice btn  btn  btn-xs '.$selection.'" data-tooltip="Create E-Invoice"   data-href="" data-type="2" data-id="'.$invoice['id'].'"><i class="fa fa-file" aria-hidden="true"></i></a>';


					$eEwayBillIcon = '<a href="javascript:void(0)"  class="__generateEwayBill btn  btn  btn-xs '.$selectionEway.'" data-tooltip="Create E-Way Bill"   data-href="" data-id="'.$invoice['id'].'"><i class="fa fa-file" aria-hidden="true"></i></a>';

					//$eWayBillIcon = '<a href="javascript:void(0)"  class="__generateEWayBill btn  btn  btn-xs" data-tooltip="Generate E-Way Bill"   data-href="" data-id="'.$invoice['id'].'"><i class="fa fa-file" aria-hidden="true"></i></a>';
				}
				$action = $action;
				echo "<tr>
					<td data-label='id:'>".$draftImage.$invoice['id']."</td>
					<td data-label='Invoice Number:'>".$invoice['invoice_num']."</td>
					<td data-label='Party Name:'><a href='javascript:void(0)' id='". $invoice['party_name'] . "' data-id='ledger_view' class='add_account_tabs'>".$party_name->name."</a></td>
					<td data-label='Sale Ledger:'><a href='javascript:void(0)' id='". $invoice['sale_ledger'] . "' data-id='ledger_view' class='add_account_tabs'>".$sale_ledger_name->name."</a></td>";
					echo '<td>'.$salePerson_name->name.'</td>';
					$material_id_datas = json_decode($invoice['descr_of_goods'],true);
							foreach($material_id_datas as $materialData){

									$ww =  getNameById('uom', $materialData['UOM'],'id');
									$uom = !empty($ww)?$ww->ugc_code:'';
										//For not show discount detail in count
							if($materialData['material_id']!=''  &&  $materialData['quantity'] !='' && $materialData['rate']!='' && $materialData['amount']!='' || $materialData['UOM']!=''){//For not show discount detail in count
								$materialName = getNameById('material',$materialData['material_id'],'id');



				}
				$output[] = array(
							   'Invoice ID' => $invoice['id'],
							   'Invoice Number' => $invoice['invoice_num'],
							   'Material Name' => $materialName->material_name,
							   'Party Name' => @$party_name->name,
							   'Sale Ledger' => @$sale_ledger_name->name,
							   'Paid or Not' => @$paid_or_not,
							   'Created Date' => date("d-m-Y", strtotime($invoice['created_date'])),
							);
			}

						echo "<td data-label='Material:'><a style='cursor: pointer;' class='add_invoice_details' id='".$invoice['id']."' data-toggle='modal' data-id='invoice_view_mat_details'>".$materialName->material_name."</a></td>
							<td data-label='Paid or Not:'>".$paid_or_not."</td>
							<td data-label='Issue Date:' class='hidde'>".date("j F , Y", strtotime($invoice['date_time_of_invoice_issue']))."</td>
							<td data-label='Created By:'><a href='".base_url()."users/edit/".$invoice['created_by']."' target='_blank'>".getNameById('user_detail',$invoice['created_by'],'u_id')->name."</a></td>
							<td data-label='Edited By:' class='hidde'>".$edited_by."</td>
							<td data-label='Created On:' class='hidde'>".date("j F , Y", strtotime($invoice['created_date']))."</td>
							<td data-label='Action:' class='hidde'>".$action."</td>
						</tr>";
						$position=25;
						$Matrl_name = substr(@$material_names_export, 0, $position);

						}

							$output_blank[] = array(
							   'Invoice ID' => '',
							   'Material Name' => '',
							   //'Buyer Order No.' => $buyer_order_no,
							  // 'Email' => $invoice['email'],
							   'Party Name' =>'',
							   'Sale Ledger' => '',
							   'Paid or Not' =>'',
							   //'Transport' => $invoice['transport'],
							   'Created Date' =>'',
							);
					}

			    $data3  = $output;

				$data_balnk3  = $output_blank;
				export_csv_excel_blank($data_balnk3);
				export_csv_excel($data3);
			 }

	   ?>
		   <?php /* if(!empty($add_invoice_details)){
			  $count=0;
			   foreach($add_invoice_details as $invoice){
			  	    if($invoice['accept_reject'] != 0){
					   $action = '';
						if($can_edit) {
							if($invoice['pay_or_not'] !=1){
								$action .=  '<a href="javascript:void(0)" id="'. $invoice["id"] . '" data-id="invoice_details" class="add_invoice_details btn btn-edit   btn-xs" data-tooltip="Edit" id="' . $invoice["id"] . '"><i class="fa fa-pencil"></i>  </a>';
								}else{
								/* Class--->>> for click ===> add_invoice_details*/
								/*	$action .=  '<a disabled="disabled" href="javascript:void(0)" id="'. $invoice["id"] . '" data-id="invoice_details" class="btn btn-edit  btn-xs" data-tooltip="Edit" id="' . $invoice["id"] . '"><i class="fa fa-pencil"></i>  </a>';
								}
								$action .=  '<a href="javascript:void(0)" id="'. $invoice["id"] . '" data-id="invoice_view_details" class="add_invoice_details btn-view btn  btn-xs" data-tooltip="View" id="' . $invoice["id"] . '"><i class="fa fa-eye"></i>  </a>';
								}

							$action .=  '<a href="javascript:void(0)" id="'. $invoice["id"] . '" data-id="invoice_report_details" class="check_invoice_report btn-view  btn  btn-xs" data-tooltip="Report" id="' . $invoice["id"] . '"><i class="fa fa-ioxhost"></i></a>';


								if($can_delete) {
									$action = $action.'<a href="javascript:void(0)" class="delete_listing btn-delete btn btn btn-info btn-xs" data-tooltip="Delete"  data-href="'.base_url().'account/deleteInvoice_details/'.$invoice["id"].'"><i class="fa fa-trash"></i></a>';
								}
								$edited_by = ($invoice['edited_by']!=0)?(getNameById('user_detail',$invoice['edited_by'],'u_id')->name):'';



					/*$material_id_datas = json_decode($invoice['descr_of_goods'],true);
				// pre($material_id_datas);die();
					$material_names = '';
					foreach($material_id_datas  as $matrial_new_id){
						$material_id_get = $matrial_new_id['material_id'];
						$material_name = ($material_id_get!=0)?(getNameById('material',$material_id_get,'id')->material_name):'';
						$material_names .= $material_name.',';

					}*/



					//$voucher_name = ($material_id_get!=0)?(getNameById('material',$material_id_get,'id')->material_name):'';
					//$invoice_count = count($vouchers['descr_of_goods']);
				/*	$party_name = getNameById('ledger',$invoice['party_name'],'id');
					$sale_ledger_name = getNameById('ledger',$invoice['sale_ledger'],'id');

					if($invoice['pay_or_not'] =='1'){
						$paid_or_not =  'Paid';
					}else{
						$paid_or_not = 'Not Paid';
					}

				echo "<tr>
					<td data-label='id:'>".$invoice['id']."</td>
					<td data-label='Party Name:'><a href='javascript:void(0)' id='". $invoice['party_name'] . "' data-id='ledger_view' class='add_account_tabs'>".$party_name->name."</a></td>
					<td  data-label='Sale Ledger:'><a href='javascript:void(0)' id='". $invoice['sale_ledger'] . "' data-id='ledger_view' class='add_account_tabs'>".$sale_ledger_name->name."</a></td>
					<td data-label='Material:'>
						<table id='datatable-buttons addMore' class='table table-striped table-bordered action-icons' data-id='account'>
							<tr>
								<th>Material Name</th>
								<th>HSN code</th>
								<th>Qty</th>
								<th>Rate</th>
								<th>Tax</th>
								<th>Amount</th>
							</tr>";
								foreach($material_id_datas as $materialData ){
									$ww =  getNameById('uom', $materialData['UOM'],'id');
														$uom = !empty($ww)?$ww->ugc_code:'';
									$materialName = getNameById('material',$materialData['material_id'],'id');
						echo "<tr>
								<td ><a href='javascript:void(0)' id='".$materialData['material_id']."' data-id='material_view' class='inventory_tabs'>".$materialName->material_name."</a></td>
								<td>".$materialData['hsnsac']."</td>
								<td>".$materialData['quantity']."/".$uom."</td>
								<td>".$materialData['rate']."</td>
								<td>".$materialData['tax']."</td>
								<td>".money_format('%!i',$materialData['amount'])."</td>
							</tr>";
								}
						echo"
						</table>
					</td>
					<td data-label='Paid or Not:'>".$paid_or_not."</td>
					<td data-label='Invoice Reject Reason:'>".$invoice['reject_invoice']."</td>
					<td data-label='Created By:'><a href='".base_url()."users/edit/".$invoice['created_by']."'  target='_blank'>".getNameById('user_detail',$invoice['created_by'],'u_id')->name."</a></td>
					<td data-label='Created On:'>".date("j F , Y", strtotime($invoice['created_date']))."</td>
					<td data-label='action:'>".$action."</td>
				</tr>";
				}


			   }
			   $count++;
		   }*/
	   ?>
		</tbody>
	</table>

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
				<h4 class="modal-title" id="myModalLabel">Add Invoice Detail</h4>
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
