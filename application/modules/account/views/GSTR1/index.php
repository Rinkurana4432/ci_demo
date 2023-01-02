<style type="text/css">
	.ui-datepicker-calendar {
    display: none !important;
    }
    .col-md-6.left-date {
    padding: 0px;
    display: block;
}
.col-md-6.left-date select.form-control.commanSelect2.select2-hidden-accessible {
    display: grid;
}
</style>
<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
<?php if(isset($_GET['start'])){
	echo date('d-M-Y',strtotime($_GET['start']));
	echo "&nbsp&nbsp To &nbsp&nbsp";
	$end = explode('-',$_GET['start']);
	$m = $end[1] + 1;
	$endDate = "{$end[0]}-{$m}-{$end[2]}";
	echo date('d-M-Y',strtotime($endDate));
} ?>			
</div>
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	         <div class="col-md-12  export_div">
		<div class="col-md-4">
		     <fieldset>
			<div class="control-group">
			    <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button> 
				 <div id="demo" class="collapse" style="width: 300px;top: 34px; padding: 0px;">
					<div class="col-md-12 datePick-left col-xs-12 col-sm-12">                 
							<fieldset>
								<div class="control-group">
								  <div class="controls">
									<div class="input-prepend input-group">
									  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
									 <!--  <?php
									   $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];	

									   ?>
									   <div class="col-md-6 left-date">
									   	<?php 
							   			for ($i=0; $i < 2 ; $i++) { ?>
							   				<select class="form-control commanSelect2" name="start_month">
											  	<option value="">Select Month</option>
											  	<?php 
											  	  foreach($months as $key => $mon){ ?>
											  	  	<option value="<?php echo $key+1 ?>"><?= $mon ?></option>
											  	<?php }
											  	?>
											</select>
											 <select class="form-control commanSelect2" name="end_month">
											  	<option value="">Select Month</option>
											  	<?php 
											  	  foreach($months as $key => $mon){ ?>
											  	  	<option value="<?php echo $key+1 ?>"><?= $mon ?></option>
											  	<?php }
											  	?>
											</select>
							   				
							   			<?php } ?>
									</div>
                                                      <div class="col-md-6 left-date">
                                                      	<?php for ($i=0; $i < 2 ; $i++) { ?>
										  <select class="form-control commanSelect2" name="start_year">
										  	<option value="">Select Year</option>
										  	<?php 
										  	for ($i=2018; $i <= date('Y'); $i++) { ?>
										  		<option value="<?= $i ?>"><?= $i ?></option>
										  	<?php } ?>
										  </select>
										  <select class="form-control commanSelect2" name="end_year">
										  	<option value="">Select Year</option>
										  	<?php 
										  	for ($i=2018; $i <= date('Y'); $i++) { ?>
										  		<option value="<?= $i ?>"><?= $i ?></option>
										  	<?php } ?>
										  </select>
										<?php } ?>
									</div> -->
									  <input type="text" style="width: 200px" name="" id="" class="form-control date-picker-month" value=""  data-table="account/Gstr_1/">
									</div>
								  </div>
								</div>
							</fieldset>
							<form action="<?php echo base_url(); ?>account/Gstr_1" method="get" id="date_range">	
							   <input type="hidden" value='' class='start_date' name='start'/>
							  <input type="hidden" value='' class='end_date' name='end'/>
							</form>	
						</div>
				 </div>
			</div>
		  </fieldset>
		</div>
	  </div>
</div>
<?php

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
//pre($_SESSION);
		$Login_user_id = $this->companyGroupId;
		$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');
	if($company_brnaches->multi_loc_on_off == 1){
		if(!empty($company_brnaches)){
	?>
	<form action="<?php echo site_url(); ?>account/Gstr_1" method="post" id="select_from_brnch">
		<div class="required item form-group company_brnch_div" >
			<label class="col-md-8 col-sm-8 col-xs-12 required control-label col-md-3 col-sm-2 col-xs-4" for="company_branch">Company GST Number</label>
			<div class="col-md-3 col-sm-3 col-xs-12">
			<select class="itemName form-control Get_data_accoriding_tobranch" name="select_GST_number" required="required" 
				name="compny_branch_id" width="100%">
				<option value=""> Select Company GST Number </option>
				<option >All</option>
				<?php
					 $branch_Add = json_decode($company_brnaches->address,true);
						$get_unique_gst_number =	array_diff_assoc($branch_Add, array_unique($branch_Add));
						$temp_array = array(); 
							  $i = 0; 
							  $key_array = array(); 
							  
							  foreach($branch_Add as $val) { 
								  if (!in_array($val['company_gstin'], $key_array)) { 
									  $key_array[$i] = $val['company_gstin']; 
									  $temp_array[$i] = $val; 
								  } 
								  $i++; 
							  } 
						
					foreach($temp_array as $val_branch){ 
					 
					 $state_data = getNameById('state',$val_branch['state'],'state_id');
					
					 ?>
					<option <?php if($val_branch['add_id'] == $_POST['select_GST_number']){ ?> selected="selected" <?php }?> value="<?php echo $val_branch['company_gstin']; ?>"><?php echo $val_branch['company_gstin'].' ( '.$state_data->state_name.' )'; ?> </option>
					
				</option>
			<?php } ?>
			</select>		
						
			</div>
			
			<input type="submit" value="Filter" class="btn btn-info">
		</div>
	</form>	
	<?php 
	} 
	}
	?> 	
<div class="row hidde_cls">
	
		<div class="col-md-12  export_div">
			<div class="btn-group"  role="group" aria-label="Basic example">
			    <a href="<?php echo base_url().'account/gstr1_validations'; ?>"><button class="btn btn-default" >Check Validations</button></a>
				<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
				<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
				<!--a class="btn btn-default buttons-copy buttons-html5 btn-sm" title="Please check your open office Setting" href="<?php //echo site_url(); ?>account/createXLS_GSTR1">Export to Excel</a-->
				<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
						<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
							<ul class="dropdown-menu" role="menu">
								<!--li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li-->
								
								
								<li><a class="btn btn-default buttons-copy buttons-html5 btn-sm" title="Please check your open office Setting"  href="<?php echo site_url(); ?>account/create_GSTR1_json">Export to JSON</a></li>
								<li><button class="bbttnn btn btn-default buttons-copy buttons-html5 btn-sm" onclick="tablesToExcel(['tbl1','tbl2','tbl4','tbl6','tbl8','tbl10','tbl12','tbl14','tbl16','tbl18','tbl19','tbl20'], ['Help instruction','b2b','b2cl','b2cs','cdnr','cdnur','exp','at','atadj','exemp','hsn','docs'], 'gstr_1.xls', 'Excel')">Export to Excel</button></li>
							</ul>
							
					</div>
					<!--form action="<?php //echo base_url(); ?>account/Gstr_1" method="post" id="date_range561fff" >
									<input type="hidden" name="create_excelGSTR1" value="checkk">
									<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="create_excel_gsrt1">Create Excel</button>
								</form-->
				
				
			</div>
				
		
		</div>
	</div>
</div>	
<p class="text-muted font-13 m-b-30"></p>

	<div id="print_div_content">
	<?php 
	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	
	$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');
	?>
	<center><table style="display:none;" class="comp_name"> <tr><td><b style="font-size:18px;"><?php echo $company_brnaches->name; ?></b> <br/><br/><b> GSTR 1</b></td></tr></table></center>
<!--id="datatable-buttons"-->
<div class="settin-tab" role="tabpanel" data-example-id="togglable-tabs">
	 <!--<h3 class="Material-head">Information<hr></h3>-->
	<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
		<!--li role="presentation" class="firstt active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Information</a>
		</li-->
		<li role="presentation" class="secc "><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Help Instructions</a></li>
		<li role="presentation" class="secc "><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">b2b</a></li>
		
		<li role="presentation" class="secc "><a href="#tab_content4" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">b2cl</a></li>
		
		<li role="presentation" class="secc "><a href="#tab_content5" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">b2cs</a></li>
		
		<li role="presentation" class="secc "><a href="#tab_content6" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">cdnr</a></li>
		
		<li role="presentation" class="secc "><a href="#tab_content7" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">cdnur</a></li>
		
		<li role="presentation" class="secc "><a href="#tab_content8" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">exp</a></li>
		
		<li role="presentation" class="secc "><a href="#tab_content9" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">at</a></li>
		
		<li role="presentation" class="secc "><a href="#tab_content10" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">atadj</a></li>
		
		<li role="presentation" class="secc "><a href="#tab_content11" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">exemp</a></li>
		<li role="presentation" class="secc "><a href="#tab_content12" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">hsn</a></li>
		<li role="presentation" class="secc "><a href="#tab_content13" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">docs</a></li>
</ul>
	<div id="myTabContent" class="tab-content list-vies-2" style="clear: both;">
	
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content2" aria-labelledby="profile-tab2" style="clear: both;"> 
	<b>Help Instructions</b>
	 <table class="table table-striped table-bordered table2excel" border="1" cellpadding="3" style="width:100%" id="tbl1">
			    <tr>
					<tr><th>1. The offline tool for generating the JSON file will not take the data available in the sheets exemp and docs.</th></tr>
					<tr><th>2. The values in these sheets are in the same order as in the portal.</th></tr>
					<tr><th>3. You can manually enter the data from these sheets directly into the GSTN portal.</th></tr>
				</tr>
				<tr><td></td></tr>
			    <tr>
					<tr><th>Visit LERP Help for more information on:</th></tr>
					<tr><th>1. GSTR1 Filing.</th></tr>
					<tr><th>2. Data captured in GSTR1 Return.</th></tr>
				</tr>
				<tr><td></td></tr>
				<tr><th>Please Note</th></tr>
			    <tr>
					<tr><th>1. This Excel workbook works best with Microsoft Excel 2003 or later. </th></tr>
					<tr><th>2. We recommend that you do not modify the data in Excel after exporting from LERP. </th></tr>
					<tr><th>3. Use separate Excel workbooks for each month, with the month name as a part of the file name. In case there are multiple uploads for a month, use Part A, Part B, and so on, in the file name to avoid confusion. Similarly, if you import invoice data multiple times in a tax period, follow a similar pattern for the JSON file name.</th></tr>
					<tr><th>4. If any data exists in the offline tool when you are importing data from Excel, all the existing data will be overwritten.</th></tr>
				</tr>
	</table>		
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content3" aria-labelledby="profile-tab2" style="clear: both;"> 
	<table class="table table-striped table-bordered table2excel" style="width:100%" border="1" cellpadding="3" id="tbl2" >
		<thead>
			<tr>
				<th style="font-weight: bold;">Summary For B2B(4)</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				
			</tr>
			<tr></tr>
			<tr></tr>
			<tr>
				<th>GSTIN/UIN of Recipient</th>
				<th>Receiver Name</th>
				<th>Invoice Number</th>
				<th>Invoice date</th>
				<th>Invoice Value</th>
				<th>Place Of Supply</th>
				<th>Reverse Charge</th>
				<th>Applicable % of Tax Rate</th>
				<th>Invoice Type</th>
				<th>E-Commerce GSTIN</th>
				<th>Rate</th>  
				<th>Taxable Value</th>
				<th>Cess Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach($invoice_data as $b2b_data){
					//&& $b2b_data['edited_by'] == 0
					if($b2b_data['gstin'] !='' ){
						$total_value = $b2b_data['total_amount'] -  $b2b_data['totaltax_total'];
						$states = getNameById('state',$b2b_data['party_state_id'],'state_id');
						if($b2b_data['invoice_type'] == 'domestic_invoice'){
							$invoiceTyppe = 'Regular';
						}elseif($b2b_data['invoice_type'] == 'export_invoice'){
							$invoiceTyppe = 'Deemed Exp';
						}
						
						$cess_total = json_decode($b2b_data['invoice_total_with_tax']);
						$get_tax = json_decode($b2b_data['descr_of_goods']);
						 $txx = array();
						foreach($get_tax as $get_grtor_tx){
							$txx[$get_grtor_tx->tax] = $get_grtor_tx->tax;
						}
						
						$tax_val = 0;
						foreach ($txx as $key=>$val) {
							if ($val > $tax_val) {
								$tax_val = $val;
							}
						}
						$check_rcm = getNameById('ledger',$b2b_data['sale_ledger'],'id');
						
						if($check_rcm->enble_disbl_rcm == '1'){
							$checek_rcm_enabl_dsbl = 'Y';
						}elseif($check_rcm->enble_disbl_rcm == '0'){
							$checek_rcm_enabl_dsbl = 'N';
						}
						$reciverName = getNameById('ledger',$b2b_data['party_name'],'id');
						
						echo '<tr>';
						echo '<td data-label="GSTIN/UIN of Recipient:">'.$b2b_data['gstin'].'</td>';
						echo '<td data-label="Receiver Name:">'.$reciverName->name.'</td>';
						echo '<td data-label="Invoice Number:">'.$b2b_data['invoice_num'].'</td>';
						echo '<td data-label="Invoice date:">'.date("d-M-Y", strtotime($b2b_data['date_time_of_invoice_issue'])).'</td>';
						echo '<td data-label="Invoice Value:">'.$b2b_data['total_amount'].'</td>';
						echo '<td data-label="Place Of Supply:">'.$b2b_data['party_state_id'].' - '.  $states->state_name  .'</td>';
						echo '<td data-label="Reverse Charge:">'.$checek_rcm_enabl_dsbl.'</td>';
						echo '<td data-label="Applicable % of Tax Rate:"></td>';
						echo '<td data-label="Invoice Type:">'.$invoiceTyppe.'</td>';
						echo '<td data-label="E-Commerce GSTIN:"></td>';
						echo '<td data-label="Rate:">'.$tax_val.'</td>';
						echo '<td data-label="Taxable Value:">'.$total_value.'</td>';
						echo '<td data-label="Cess Amount:">'.$cess_total[0]->cess_all_total.'</td>';
						
						echo '</tr>';
				}
			}
			?>
		</tbody>
	</table>	
	
	</div>
	
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content4" aria-labelledby="profile-tab2" style="clear: both;"> 
	<table class="table table-striped table-bordered table2excel" style="width:100%" border="1" cellpadding="3" id="tbl4">
		<thead>
		<tr>
				<th style="font-weight: bold;">Summary For B2CL(5)</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				
				
			</tr>
			<tr></tr>
			<tr></tr>
			<tr>
				<th>Invoice Number</th>
				<th>Invoice date</th>
				<th>Invoice Value</th>
				<th>Place Of Supply</th>
				<th>Applicable % of Tax Rate</th>
				<th>Rate</th>
				<th>Taxable Value</th>
				<th>Cess Amount</th>
				<th>E-Commerce GSTIN</th>
				<!--th scope="col">Sale from Bonded WH</th-->
				
			</tr>
		</thead>
		<tbody>
			<?php 
			 //if(!empty($invoice_data)){
				foreach($invoice_data as $b2cl_data){
					//pre($b2cl_data['total_amount']);250000  && $b2cl_data['edited_by'] == 0
					if($b2cl_data['gstin'] =='' && $b2cl_data['total_amount'] > 250000 ){
						$total_value = $b2cl_data['total_amount'] -  $b2cl_data['totaltax_total'];
						$states = getNameById('state',$b2cl_data['party_state_id'],'state_id');
						
						
						$cess_total = json_decode($b2cl_data['invoice_total_with_tax']);
						$get_tax = json_decode($b2cl_data['descr_of_goods']);
						$txx = array();
						foreach($get_tax as $get_grtor_tx){
							$txx[$get_grtor_tx->tax] = $get_grtor_tx->tax;
						}
						
						$tax_val = 0;
						foreach ($txx as $key=>$val) {
							if ($val > $tax_val) {
								$tax_val = $val;
							}
						}
						
						echo '<tr>';
						echo '<td data-label="Invoice Number:">'.$b2cl_data['invoice_num'].'</td>';
						echo '<td data-label="Invoice date:">'.date("d-M-Y", strtotime($b2cl_data['date_time_of_invoice_issue'])).'</td>';
						echo '<td data-label="Invoice Value:">'.$b2cl_data['total_amount'].'</td>';
						echo '<td data-label="Place Of Supply:">'.$b2cl_data['party_state_id'].' - '.  $states->state_name  .'</td>';
						echo '<td data-label="Applicable % of Tax Rate:"></td>';
						echo '<td data-label="Rate:">'.$tax_val.'</td>';
						echo '<td data-label="Taxable Value:">'.$total_value.'</td>';
						echo '<td data-label="Cess Amount:">'.$cess_total[0]->cess_all_total.'</td>';
						echo '<td data-label="E-Commerce GSTIN:"></td>';
						//echo '<td data-label="Sale from Bonded WH:"></td>';
						
						
						
						
						echo '</tr>';
						//pre($b2b_data);
					
				}
				// else{
					 // echo '<tr><td colspan="10"> No data Avilable</td></tr>';
				 // }
			}
	 
			?>
		</tbody>
	</table>
	
	</div>
	
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade  " id="tab_content5" aria-labelledby="profile-tab2" style="clear: both;"> 
	<table class="table table-striped table-bordered table2excel" style="width:100%" border="1" cellpadding="3" id="tbl6" >
		<thead>
			<tr>
				<th style="font-weight: bold;">Summary For B2CS(7)</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				
			</tr>
			<tr></tr>
			<tr></tr>
			<tr>
				<th>Type</th>
				<th>Place Of Supply</th>
				<th>Rate</th>
				<th>Taxable Value</th>
				<th>Cess Amount</th>
				<th>E-Commerce GSTIN</th>
				
			</tr>
		</thead>
		<tbody>
			<?php 
			 //if(!empty($invoice_data)){
				foreach($invoice_data as $b2cs_data){
					//pre($b2cs_data['total_amount']);
					if($b2cs_data['gstin'] =='' && $b2cs_data['total_amount'] < 250000 ){
						$total_value = $b2cs_data['total_amount'] -  $b2cs_data['totaltax_total'];
						$states = getNameById('state',$b2cs_data['party_state_id'],'state_id');
						
						
						$cess_total = json_decode($b2cs_data['invoice_total_with_tax']);
						$get_tax = json_decode($b2cs_data['descr_of_goods']);
						 $txx = array();
						foreach($get_tax as $get_grtor_tx){
							$txx[$get_grtor_tx->tax] = $get_grtor_tx->tax;
						}
						
						$tax_val = 0;
						foreach ($txx as $key=>$val) {
							if ($val > $tax_val) {
								$tax_val = $val;
							}
						}
						
						echo '<tr>';
						echo '<td data-label="Type:">OE</td>';
						
						echo '<td data-label="Place Of Supply:">'.$b2cs_data['party_state_id'].' - '.  $states->state_name  .'</td>';
					
						echo '<td data-label="Rate:">'.$tax_val.'</td>';
						echo '<td data-label="Taxable Value:">'.$b2cs_data['total_amount'].'</td>';
						echo '<td data-label="Cess Amount:">'.$cess_total[0]->cess_all_total.'</td>';
						echo '<td data-label="E-Commerce GSTIN:"></td>';
						
						echo '</tr>';
						//pre($b2b_data);
					
				}
				// else{
					 // echo '<tr><td colspan="10"> No data Avilable</td></tr>';
				 // }
			}
	 
			?>
		</tbody>
	</table>
	
	</div>
	
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content6" aria-labelledby="profile-tab2" style="clear: both;"> 
	<table class="table table-striped table-bordered table2excel" style="width:100%" border="1" cellpadding="3" id="tbl8" >
		<thead>
		<tr>
				<th style="font-weight: bold;">Summary For CDNR(9B)</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			<tr></tr>
			<tr></tr>
			<tr>
				<th>GSTIN/UIN of Recipient</th>
				<th>Receiver Name</th>
				<th>Note Number</th>
				<th>Note Date</th>
				<th>Note Type</th>
				<th>Place Of Supply</th>
				<th>Reverse Charge</th>
				<th>Note Supply Type</th>
				<th>Note Value</th>
				<th>Applicable % of Tax Rate</th>
				<th>Rate</th>
				<th>Taxable Value</th>
				<th>Cess Amount</th>
				
			</tr>
		</thead>
		<tbody>
		<?php 
		
			foreach($crdr_Data as $key => $data_cdnr){
				// if($data_cdnr['edited_by'] == 0){ 
				 
					
				if(!empty($data_cdnr)){
					
					$getCrDrdata = array_keys($data_cdnr);
					
					if($getCrDrdata[1] == 'crditNoteNo'){
						$customerGST = getNameById('ledger',$data_cdnr['customer_id'],'id');
						$customrGST = json_decode($customerGST->mailing_address);
						
						$CRDR = 'C';
						$cussuppname = $customerGST->name;
						
						$crdrno = $data_cdnr['crditNoteNo'];
						$states = getNameById('state',$data_cdnr['party_billing_state_id'],'state_id');
						$stateidName =  $data_cdnr['party_billing_state_id'].'-'.  $states->state_name;
						
						$check_rcm = getNameById('ledger',$data_cdnr['customer_id'],'id');
						if($check_rcm->enble_disbl_rcm == '1'){
							$checek_rcm_enabl_dsbl = 'Y';
						}elseif($check_rcm->enble_disbl_rcm == '0'){
							$checek_rcm_enabl_dsbl = 'N';
						}
						$invoiceNo = getNameById('invoice',$data_cdnr['invoice_no'],'id');
						// $invtypee = $invoiceNo->invoice_type;
						if($invoiceNo->invoice_type == 'domestic_invoice'){
							$invtypee = 'Regular';
						}elseif($invoiceNo->invoice_type == 'export_invoice'){
							$invtypee = 'Deemed Exp';
						}
						$TaxRate = getNameById('ledger',$data_cdnr['ledgerID'],'id');	
						$invoiceTaxrate = $TaxRate->name;
						$taxableValue = json_decode($data_cdnr['amountDtl']);
						
						$taxableValuedata =  $taxableValue[0]->subtotal;
						$withtaxValue =  $taxableValue[0]->grand_total;
						
						$cess_total = json_decode($invoiceNo->invoice_total_with_tax);
						 // pre($invoiceNo);
						
					}elseif($getCrDrdata[1] == 'debitNoteNo'){
						$supplierGST = getNameById('ledger',$data_cdnr['supplier_id'],'id');
						
						$cussuppname = $supplierGST->name;
						$crdrno = $data_cdnr['debitNoteNo'];
						$customrGST = json_decode($supplierGST->mailing_address);
						$CRDR = 'D';
						$states = getNameById('state',$data_cdnr['sale_company_state_id'],'state_id');
						$stateidName =  $data_cdnr['sale_company_state_id'].'-'.  $states->state_name;
						$check_rcm = getNameById('ledger',$data_cdnr['supplier_id'],'id');
						if($check_rcm->enble_disbl_rcm == '1'){
							$checek_rcm_enabl_dsbl = 'Y';
						}elseif($check_rcm->enble_disbl_rcm == '0'){
							$checek_rcm_enabl_dsbl = 'N';
						}
						
						//if($data_cdnr['sale_company_state_id'] != $data_cdnr['party_billing_state_id']){
							$invtypee = 'Intra-State supplies attracting IGST';
						//}elseif($data_cdnr['sale_company_state_id'] == $data_cdnr['party_billing_state_id']){
						//	$invtypee = 'Intra-State supplies attracting IGST';
					//	}
							$TaxRate = getNameById('ledger',$data_cdnr['buyerID'],'id');	
							$invoiceTaxrate = $TaxRate->name;
							$taxableValue2 = json_decode($data_cdnr['amountDtl']);
							$taxableValuedata =  $taxableValue2[0]->subtotal;
							$withtaxValue =  $taxableValue2[0]->grand_total;
						
								
					}
					echo '<tr>';
						echo '<td data-label="GSTIN/UIN of Recipient:">'.$customrGST[0]->gstin_no.'</td>';
						echo '<td data-label="Receiver Name:">'.$cussuppname.'</td>';
						echo '<td data-label="Note No:">'.$CRDR.$crdrno.'</td>'; 
						echo '<td data-label="Date:">'.date('d-M-Y',strtotime($data_cdnr['date'])).'</td>';
						echo '<td data-label="Note Type:">'.$CRDR.'</td>';
						echo '<td data-label="Place Of Supply:">'.$stateidName.'</td>';
						echo '<td data-label="Place Of Supply:">'.$checek_rcm_enabl_dsbl.'</td>';
						echo '<td data-label="Reverse:" style="text-transform:capitalize;">'.$invtypee.'</td>';
						echo '<td data-label="Note Value:" style="text-transform:capitalize;">'.$withtaxValue.'</td>';
						echo '<td data-label="Note Value:" style="text-transform:capitalize;"></td>';
						echo '<td data-label="Rate:" style="text-transform:capitalize;">'.substr($invoiceTaxrate, -3).'</td>';
						echo '<td data-label="Taxable Value :" style="text-transform:capitalize;">'.$taxableValuedata.'</td>';
						echo '<td data-label="Cess Value :" style="text-transform:capitalize;"></td>';
					echo '</tr>';
					
				 // pre($data_cdnr); 
				}
				// }	
			}	
		
		?>

		</tbody>
	</table>
	
	</div>
	
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content7" aria-labelledby="profile-tab2" style="clear: both;"> 
	
		<table class="table table-striped table-bordered table2excel" style="width:100%" border="1" cellpadding="3" id="tbl10" >
		<thead>
			<tr>
				<th style="font-weight: bold;">Summary For CDNUR(9B)</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				
			</tr>
			<tr></tr>
			<tr></tr>
			<tr>
				<th>UR Type</th>
				<th>Note Number</th>
				<th>Note Date</th>
				<th>Note Type</th>
				<th>Place Of Supply</th>
				<th>Note Value</th>
				<th>Applicable % of Tax Rate</th>
				<th>Rate</th>
				<th>Taxable Value</th>
				<th>Cess Amount</th>
				
			</tr>
		</thead>
		<tbody>
		<?php 
		$RevisedinvNo = 1;
			foreach($crdr_Data as $key => $data_cdnur){
				
				$customerGST = getNameById('ledger',$data_cdnur['customer_id'],'id');
				$supplierGST = getNameById('ledger',$data_cdnur['supplier_id'],'id');
				$cutomerGSTNo = json_decode($customerGST->mailing_address);
				$suppGSTNo = json_decode($supplierGST->mailing_address);
						
				 if( $cutomerGSTNo[0]->gstin_no =='' && $suppGSTNo[0]->gstin_no =='' ){	
				// if(!empty($data_cdnr)){
				
				$getCrDrdata = array_keys($data_cdnur);
					if($getCrDrdata[1] == 'crditNoteNo'){
						$customerGST = getNameById('ledger',$data_cdnur['customer_id'],'id');
						$customrGST = json_decode($customerGST->mailing_address);
						
						$CRDR = 'C';
						$cussuppname = $customerGST->name;
						
						$crdrno = $data_cdnur['crditNoteNo'];
						$states = getNameById('state',$data_cdnur['party_billing_state_id'],'state_id');
						$stateidName =  $data_cdnur['party_billing_state_id'].'-'.  $states->state_name;
						
						$check_rcm = getNameById('ledger',$data_cdnur['customer_id'],'id');
						if($check_rcm->enble_disbl_rcm == '1'){
							$checek_rcm_enabl_dsbl = 'Y';
						}elseif($check_rcm->enble_disbl_rcm == '0'){
							$checek_rcm_enabl_dsbl = 'N';
						}
						$invoiceNo = getNameById('invoice',$data_cdnur['invoice_no'],'id');
						$invtypee = $invoiceNo->invoice_type;
						$TaxRate = getNameById('ledger',$data_cdnur['ledgerID'],'id');	
						$invoiceTaxrate = $TaxRate->name;
						$taxableValue = json_decode($data_cdnur['amountDtl']);
						
						$taxableValuedata =  $taxableValue[0]->subtotal;
						$withtaxValue =  $taxableValue[0]->grand_total;
						
						// $cess_total = json_decode($invoiceNo->invoice_total_with_tax);
						 // pre($invoiceNo);
						
					}elseif($getCrDrdata[1] == 'debitNoteNo'){
						$supplierGST = getNameById('ledger',$data_cdnur['supplier_id'],'id');
						
						$cussuppname = $supplierGST->name;
						$crdrno = $data_cdnur['debitNoteNo'];
						$customrGST = json_decode($supplierGST->mailing_address);
						$CRDR = 'D';
						$states = getNameById('state',$data_cdnur['sale_company_state_id'],'state_id');
						$stateidName =  $data_cdnur['sale_company_state_id'].'-'.  $states->state_name;
						$check_rcm = getNameById('ledger',$data_cdnur['supplier_id'],'id');
						if($check_rcm->enble_disbl_rcm == '1'){
							$checek_rcm_enabl_dsbl = 'Y';
						}elseif($check_rcm->enble_disbl_rcm == '0'){
							$checek_rcm_enabl_dsbl = 'N';
						}
						
						//if($data_cdnur['sale_company_state_id'] != $data_cdnur['party_billing_state_id']){
							$invtypee = 'Intra-State supplies attracting IGST';
						//}elseif($data_cdnur['sale_company_state_id'] == $data_cdnur['party_billing_state_id']){
						//	$invtypee = 'Intra-State supplies attracting IGST';
					//	}
							$TaxRate = getNameById('ledger',$data_cdnur['buyerID'],'id');	
							$invoiceTaxrate = $TaxRate->name;
							$taxableValue2 = json_decode($data_cdnur['amountDtl']);
							$taxableValuedata =  $taxableValue2[0]->subtotal;
							$withtaxValue =  $taxableValue2[0]->grand_total;
						
								
					}
					echo '<tr>';
						echo '<td data-label="UR Type:">'.$cussuppname.'</td>';
						echo '<td data-label="Note Number:">'.$CRDR.$crdrno.'</td>';
						echo '<td data-label="Note Date:">'.date('d-M-Y',strtotime($data_cdnr['date'])).'</td>';
						echo '<td data-label="Note Type:">'.$CRDR.'</td>';
						echo '<td data-label="Place Of Supply:">'.$stateidName.'</td>';
						echo '<td data-label="Note Value:">'.$withtaxValue.'</td>';
						echo '<td data-label="Note Value:"></td>';
						echo '<td data-label="Rate:">'.substr($invoiceTaxrate, -3).'</td>';
						echo '<td data-label="Taxable Value:">'.$taxableValuedata.'</td>';
						echo '<td data-label="Cess Amount:"></td>';
						
					echo '</tr>';
					
				 // pre($data_cdnr); 
				// }	
				$RevisedinvNo++;
			}	
		
	}	
		
		?>

		</tbody>
	</table>
	
	</div>
	
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content8" aria-labelledby="profile-tab2" style="clear: both;">
		<table class="table table-striped table-bordered table2excel" style="width:100%" border="1" cellpadding="3" id="tbl12" >
			<thead>
			<tr>
				<th style="font-weight: bold;">Summary For EXP(6)</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>

			</tr>
			<tr></tr>
			<tr></tr>
				<tr>
					<th>Export Type</th>
					<th>Invoice Number</th>
					<th>Invoice date</th>
					<th>Invoice Value</th>
					<th>Port Code</th>
					<th>Shipping Bill Number</th>
					<th>Shipping Bill Date</th>
					<th>Rate</th>
					<th>Taxable Value</th>
					<th>Cess Amount</th>
					
				</tr>
			</thead>
		<tbody>
			<?php 
				$i=1;
				foreach($invoice_data as $exp_inv_data){
					
					if($exp_inv_data['gstin'] =='' && ($exp_inv_data['invoice_type']=='SEZSupplieswithPayment' || $exp_inv_data['invoice_type']=='SEZSupplieswithoutPayment') ){
						 // pre($exp_inv_data);
						$total_value = $exp_inv_data['total_amount'] -  $exp_inv_data['totaltax_total'];
						$cess_total = json_decode($exp_inv_data['invoice_total_with_tax']);
						$get_tax = json_decode($exp_inv_data['descr_of_goods']);
						$txx = array();
						foreach($get_tax as $get_grtor_tx){
							$txx[$get_grtor_tx->tax] = $get_grtor_tx->tax;
						}
						
						$tax_val = 0;
						foreach ($txx as $key=>$val) {
							if ($val > $tax_val) {
								$tax_val = $val;
							}
						}
						
						$TaxRate = getNameById('ledger',$exp_inv_data['sale_ledger'],'id');	
						$invoiceTaxrate = $TaxRate->name;
						
						if($exp_inv_data['invoice_type'] == 'SEZSupplieswithPayment'){
							$invoiceTYPE = 'WPAY';
						}elseif($exp_inv_data['invoice_type'] == 'SEZSupplieswithoutPayment'){
							$invoiceTYPE = 'WOPAY';
						}
							
							
							
							$datataxableValue = json_decode($exp_inv_data['invoice_total_with_tax']);
							
						//$exp_inv_data['port_loading']
						echo '<tr>';
						echo '<td data-label="Export Type:">'.$invoiceTYPE.'</td>';
						echo '<td data-label="Invoice Number:">'.$exp_inv_data['invoice_num'].'</td>';
						echo '<td data-label="Taxable Value:">'.date('d-M-Y',strtotime($exp_inv_data['date_time_of_invoice_issue'])).'</td>';
						echo '<td data-label="Invoice Value:">'.$exp_inv_data['total_amount'].'</td>';
						echo '<td data-label="Port Code:">INB'.$i.'</td>';
						echo '<td data-label="Shipping Bill Number:"></td>';
						echo '<td data-label="Shipping Bill Date:"></td>';
						echo '<td data-label="Rate:">'.substr($invoiceTaxrate, -3).'</td>';
						echo '<td data-label="Taxable Value:">'.$datataxableValue[0]->total.'</td>';
						echo '<td data-label="Cess Amount:">'.$cess_total[0]->cess_all_total.'</td>';
						echo '</tr>';
						//pre($b2b_data);
					$i++;	
					
				}
				// else{
					 // echo '<tr><td colspan="10"> No data Avilable</td></tr>';
				 // }
			}
	 
			?>
		</tbody>
	</table>
</div>

	
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content9" aria-labelledby="profile-tab2" style="clear: both;"> 
	<!-- at advance Recived -->
		<table class="table table-striped table-bordered table2excel" style="width:100%" border="1" cellpadding="3" id="tbl14">
		<thead>
			<tr>
				<th style="font-weight: bold;">Summary For Advance Received (11B)</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			<tr></tr>
			<tr></tr>
			<tr>
				<th>Place Of Supply</th>
				<th>Applicable % of Tax Rate</th>
				<th>Rate</th>
				<th>Gross Advance Received</th>
				<th>Cess Amount</th>
				
			</tr>
		</thead>
		<tbody>
				<?php 
					echo '<td data-label="Place Of Supply:"></td>';
					echo '<td data-label="Applicable % of Tax Rate:"></td>';
					echo '<td data-label="Rate:"></td>';
					echo '<td data-label="Gross Advance Received:"></td>';
					echo '<td data-label="Cess Amount:"></td>';
				?>
						
		</tbody>
	</table>
	
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content10" aria-labelledby="profile-tab2" style="clear: both;"> 
		<table class="table table-striped table-bordered table2excel" style="width:100%" border="1" cellpadding="3" id="tbl16" >
		<thead>
			<tr>
				<th style="font-weight: bold;">Summary For Advance Adjusted (11B) </th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			<tr></tr>
			<tr></tr>
			<tr>
				<th>Place Of Supply</th>
				<th>Applicable % of Tax Rate</th>
				<th>Rate</th>
				<th>Gross Advance Adjusted</th>
				<th>Cess Amount</th>
				
			</tr>
		</thead>
		<tbody>
					<?php 
					echo '<td data-label="Place Of Supply:"></td>';
					echo '<td data-label="Applicable % of Tax Rate:"></td>';
					echo '<td data-label="Rate:"></td>';
					echo '<td data-label="Gross Advance Received:"></td>';
					echo '<td data-label="Cess Amount:"></td>';

					
					?>
			</tbody>
		</table>
	</div>
	
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content11" aria-labelledby="profile-tab2" style="clear: both;"> 
	
	<!-- Nil Rated  exemp-->
	<table class="table-striped table-bordered table2excel" style="width:100%" border="1" cellpadding="3" id="tbl18" >
		<thead>
		<tr>
				<th style="font-weight: bold;">Summary For Nil rated, exempted and non GST outward supplies (8)</th>
				<th></th>
				<th></th>
				<th></th>
				
			</tr>
			<tr></tr>
			<tr></tr>
		
			<tr>
				<th>Description</th>
				<th>Nil Rated Supplies</th>
				<th>Exempted(other than nil rated/non GST supply)</th>
				<th>Non-GST Supplies</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach($invoice_data as $nill_rated_exp_data){
					
					if($nill_rated_exp_data['totaltax_total'] == '0' ||  $nill_rated_exp_data['invoice_type'] == 'nonGst'){
						
						
						
						 $saleledgerRegister = getNameById('ledger',$nill_rated_exp_data['party_name'],'id');
						
						$GSTdata = json_decode($saleledgerRegister->mailing_address);
						
						

						if($GSTdata[0]->gstin_no != ''){
							$registerPersonUnregisterd = 'registered persons';
						}else{
							$registerPersonUnregisterd = 'unregistered persons';
						}						
						
						if($nill_rated_exp_data['party_state_id'] != $nill_rated_exp_data['sale_L_state_id']){
							$interandIntra = 'Inter-State supplies to';
							//echo 'if';
						}else{
							$interandIntra = 'Intra-State supplies to';
							//echo 'else';
						}
						
					echo '<tr>';
					
					// echo '<td style="text-transform:capitalize;"> '.$nill_rated_exp_data['invoice_type'].'</td>';
					echo '<td style="text-transform:capitalize;">'.$interandIntra .' '. $registerPersonUnregisterd.'</td>';
					if($nill_rated_exp_data['invoice_type'] != 'nonGst'){
						echo '<td></td>';
						echo '<td>'.$nill_rated_exp_data['total_amount'].'</td>';
						
					}else{
							echo '<td></td>';
							echo '<td></td>';
						echo '<td>'.$nill_rated_exp_data['total_amount'].'</td>';
					}
					
					
					echo '<td></td>';
					echo '</tr>';
						
					}
			}
	 
			?>
		</tbody>
	</table>
	
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content12" aria-labelledby="profile-tab2" style="clear: both;"> 
	
	<!-- hsn  -->
	<table class="table table-striped table-bordered table2excel" style="width:100%" border="1" cellpadding="3" id="tbl19" >
		<thead>
			<tr>
				<th style="font-weight: bold;">Summary For HSN(12)</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			<tr></tr>
			<tr></tr>
			<tr>
				<th>HSN</th>
				<th>Description</th>
				<th>UQC</th>
				<th>Total Quantity</th>
				<th>Total Value</th>
				<th>Rate</th>
				<th>Taxable Value</th>
				<th>Integrated Tax Amount</th>
				<th>Central Tax Amount</th>
				<th>State/UT Tax Amount</th>
				<th>Cess Amount</th>
				
			</tr>
		</thead>
		<tbody>
			<?php 
			// pre($invoice_data);
			$finalArray = array();
			foreach($hsndata as $fkey => $dta){
			
			
				
			
				
				$product_qty = $amount = $igst = $camt =  $samt = 0;
				
				foreach($dta as $key => $hsnVal){
					
				
					$uom_nam = getNameById('uom',$hsnVal['UOM'],'id');
					
					
			
					if($hsnVal['IGST'] !='' && $hsnVal['SGST'] == '0.00' && $hsnVal['CGST'] == '0.00' ){	
							$igst += $hsnVal['IGST'];
						}elseif($hsnVal['IGST'] =='0.00' && $hsnVal['SGST']!= '' && $hsnVal['CGST'] != ''){	
							$camt += $hsnVal['CGST'];	
							$samt += $hsnVal['SGST'];
						}	
					// $hsnVal = (object)$hsnVal;
					if($fkey == $hsnVal['hsnsac']){
						$product_qty += $hsnVal['quantity'];
						$amount += $hsnVal['amount'];
						
					}
				}
				if($hsnVal['hsnsac'] != 'blank'){
				echo '<tr>';
				echo '<td data-label="HSN:">'.$hsnVal['hsnsac'].'</td>';
				echo '<td data-label="Description:">'.$hsnVal['descr_of_goods'].'</td>';
				echo '<td data-label="UQC:">'.$uom_nam->ugc_code.'-'. $uom_nam->uom_quantity .'</td>';
				echo '<td data-label="Total Quantity:">'.$product_qty.'</td>';
				echo '<td data-label="Total Value:">'.$amount.'</td>';
				echo '<td data-label="Total Rate:">'.$hsnVal['tax'].'.00</td>';
				echo '<td data-label="Taxable Value:">'.$dta->sale_amount.'</td>';
				echo '<td data-label="Integrated Tax Amount:" >'.$igst.'</td>';
				echo '<td  data-label="Central Tax Amount:">'.$camt.'</td>';
				echo '<td data-label="State/UT Tax Amount:">'.$samt.'</td>';
				echo '<td data-label="Cess Amount:">'.$dtl_prod->cess.'</td>';
				}
				
			}
			// foreach($invoice_data as $hsn_data){
					// $products = json_decode($hsn_data['descr_of_goods']);
						// if(!empty($products)){
							// $w = 0;
							// $mat_num = 1;
						// foreach($products as $dtl_prod){
							
							// pre($dtl_prod);

							// $uom_nam = getNameById('uom',$dtl_prod->UOM,'id');
							
						
						// if($uom_nam->id == $dtl_prod->UOM){
							// $product_qty = $dtl_prod->quantity;
						// }
						// $total_mat_amt = $dtl_prod->amount - $dtl_prod->added_tax_Row_val;
						// if($hsn_data['IGST'] !='' && $hsn_data['SGST'] == '0.00' && $hsn_data['CGST'] == '0.00' ){	
							// $igst = $hsn_data['IGST'];
						// }elseif($invoice['IGST'] =='0.00' && $invoice['SGST']!= '' && $invoice['CGST'] != ''){	
							// $camt = $hsn_data['CGST'];	
							// $samt = $hsn_data['SGST'];
						// }	
						// echo '<tr>';
						// echo '<td data-label="HSN:">'.$dtl_prod->hsnsac.'</td>';
						// echo '<td data-label="Description:">'.$dtl_prod->descr_of_goods.'</td>';
						// echo '<td data-label="UQC:">'.$uom_nam->ugc_code.' - '. $uom_nam->uom_quantity .'</td>';
						// echo '<td data-label="Total Quantity:">'.$product_qty.'</td>';
						// echo '<td data-label="Total Value:">'.$dtl_prod->amount.'</td>';
						// echo '<td data-label="Total Rate:">'.$dtl_prod->tax.'</td>';
						// echo '<td data-label="Taxable Value:">'.$total_mat_amt.'</td>';
						// echo '<td data-label="Integrated Tax Amount:" >'.$igst.'</td>';
						// echo '<td  data-label="Central Tax Amount:">'.$camt.'</td>';
						// echo '<td data-label="State/UT Tax Amount:">'.$samt.'</td>';
						// echo '<td data-label="Cess Amount:">'.$dtl_prod->cess.'</td>';
						
						
						// echo '</tr>';
					// }
					
			// }
								
					
			// }
			
				
			?>
		</tbody>
	</table>	
	
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content13" aria-labelledby="profile-tab2" style="clear: both;"> 
	<!-- Docs  -->
		<table class="table-striped table-bordered table2excel" style="width:100%" border="1" cellpadding="3" id="tbl20" >
		<thead>
				<tr>
				<th style="font-weight: bold;">Summary of documents issued during the tax period (13)</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				
			</tr>
			<tr></tr>
			<tr></tr>
			<tr>
				<th>Nature of Document</th>
				<th>Sr. No. From</th>
				<th>Sr. No. To</th>
				<th>Total Number</th>
				<th>Cancelled</th>
			</tr>
		</thead>
		<tbody>
			<?php 
					//$first_day_this_month = date('Y-m-01 h:m:i'); // hard-coded '01' for first day
					//echo $last_day_this_month  = date('Y-m-t');
					 $last_day_this_month  = date('m');
					 
					echo '<tr>';
					echo '<td>Invoices for outward supply</td>';
						
				$x = 1;
				$length = count($invoice_data);
				$getInvoiceData = [];
				foreach($invoice_data as $docsData){
					
					$invoiceDate = date('m',strtotime($docsData['created_date']));
						if($invoiceDate >= $last_day_this_month){
							if($x === 1){
						      $firstInvoiceno = $docsData['invoice_num'];
							}else if($x === $length){
								$lastInvoiceNo = $docsData['invoice_num'];
							}
							
							
						$getInvoiceData = array(
												'firstinvNo'=>$firstInvoiceno,
												'lastinvNo'=>$lastInvoiceNo,
												'length'=>$length,
												);	
							
							
						}
				  $x++;	
				}
				
				
							echo '<td>'.$getInvoiceData['firstinvNo'].'</td>';
							echo '<td>'.$getInvoiceData['lastinvNo'].'</td>';
							echo '<td>'.$getInvoiceData['length'].'</td>';
							echo '<td>0</td>';
							echo '</tr>';					
				
			?>
			</tbody>
		</table>
	</div>
</div>
		</div>
	</div>
</div>
