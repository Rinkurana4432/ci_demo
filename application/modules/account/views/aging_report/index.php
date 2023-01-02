<div class="x_content">
    <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	          <form class="form-search" method="get" action="<?= base_url() ?>account/aging_report">
				<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,Party Name,sales Person" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>" data-ctrl="account/aging_report">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
						<a href="<?php echo base_url(); ?>account/aging_report"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
				</div>
			</form>
			<button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button> 
			 <div id="demo" class="collapse">
			       <div class="col-md-4">
				
				   <form action="<?php echo base_url(); ?>account/aging_report?tab=<?php echo $_GET['tab']; ?>" method="GET" >
						<div class="row hidde_cls filter1 progress_filter">
							<div class="col-md-12 col-xs-12">
							  <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
								<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" name="sales_person" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $this->companyGroupId; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">
								  
								 </select>
							  </div>
							   <input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="account/aging_report" disabled="disabled">
							</form>  
						</div>  
					</div>
				</div>
			</div>			
	  </div>
	</div>
	<?php 
		setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
	?>
	<span class="mesg"></span>

	 <p class="text-muted font-13 m-b-30"></p>
	<div class="row hidde_cls">
		<div class="col-md-12 export_div">
			<div class="btn-group"  role="group" aria-label="Basic example">
			    <a href="<?php echo site_url(); ?>account/ageing_report_over_due">
				<button type="submit" class="btn btn-default buttons-html5 btn-sm " >Check Over Due</button></a>
				
				<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
				<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
					<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
						<ul class="dropdown-menu" role="menu" id="export-menu">
							<li id="export-to-excel"><a href="javascript:void()" title="Please check your open office Setting">Export to excel</a></li>
							<li id="export-to-csv"><a href="javascript:void()" title="Please check your open office Setting">Export to csv</a></li>
							<li id="exportToPDF"><a href="javascript:void()">Export to PDF</a></li>
							
						</ul>
				</div>
			</div>
		</div>
	</div>
	<form action="<?php echo site_url(); ?>account/aging_report" method="get" id="export-PDFform" target="_blank">
	<input type="hidden" value='' id='hidden-type' name='ExportType'/>
		<input type="hidden" value='aging_reportdata'  name='ExportTypePDF'/>
		
    </form>
	<form action="<?php echo site_url(); ?>account/aging_report" method="get" id="export-form">
		<input type="hidden" value='' id='hidden-type' name='ExportType'/>
        <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search']?>' name='search'/>
	</form>
	<form action="<?php echo site_url(); ?>account/Create_ledgers_blankxls" method="post" id="export-form-blank">
		<input type="hidden" value='' id='hidden-type-blank-excel' name='ExportType_blank'/>
	</form>
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<div id="myTabContent" class="tab-content">
			<div role="tabpanel" class="tab-pane fade active in" id="ledger_Active" aria-labelledby="home-tab">
			<div id="print_div_content">
				<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>account/aging_report">
					<input type="hidden" name="order" id="order" value="<?php if($_POST['order']==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
				</form>
				<table style="display:none;" class="comp_name"> <tr><td><b style="font-size:18px;"> Invoice Aging Report</b> <br/><br/></td></tr></table> <br/>
				<table id="" class="table table-striped table-bordered cls_Added_csv" data-id="account" border="1" cellpadding="3" style="margin-top:46px;">
					<thead>
						<tr>
							<th scope="col">Id
								<span>
								<a href="<?php echo base_url(); ?>account/aging_report?sort=asc" class="up"></a>
								<a href="<?php echo base_url(); ?>account/aging_report?sort=desc" class="down"></a>
								</span>
							</th> 
							<th scope="col">Invoice Date
								<span>
									<a href="<?php echo base_url(); ?>account/aging_report?sort=asc" class="up"></a>
									<a href="<?php echo base_url(); ?>account/aging_report?sort=desc" class="down"></a>
								</span>
							</th>
							<th scope="col">Invoice #</th>
							<th scope="col">Party Name</th>
							<th scope="col">Sales Person</th>
							<th scope="col">Invoice Amount</th>
							<th scope="col">Due Date</th>
							<th scope="col" class="hidde">Days Over Due </th><!--above due Date-->
							<!--th scope="col">Above Due Date</th-->
						</tr>
					</thead>
						<tbody>
								<?php
									if(!empty($add_invoice_details)){
										$total_amount_sum = 0;
										foreach($add_invoice_details as $aging_Rpt_val){
											
										
											$total_amount_sum += $aging_Rpt_val['total_amount'];
											if($aging_Rpt_val['due_date'] != 0){
												$current_Date = date ("Y-m-d");
												$due_date = date("Y-m-d", strtotime($aging_Rpt_val['due_date']));
												$start = strtotime($current_Date);
												$end = strtotime($due_date);
												//$days_between = ceil(abs($end - $start) / 86400);
												$above_days_between = ($start - $end)/60/60/24; 
												$dueDate = date("d - M - Y", strtotime($aging_Rpt_val['due_date']));
											}else{
												$above_days_between = 'Day not Set';
												$dueDate =  '0000-00-00';
											}
											$party_name = getNameById('ledger',$aging_Rpt_val['party_name'],'id');
																					
											$sales_person = getNameById('user_detail',$aging_Rpt_val['sales_person'],'u_id');
											
											if (substr(strval($above_days_between), 0, 1) == "-"){
													$check_box_show = '<input type="checkbox" name="send_email[]" value="'.$party_name->email.'" data-invoice="'.$aging_Rpt_val['id'].'" data-id="'.$aging_Rpt_val['party_name'].'" class="mailbtn" >';
												} else {
													$check_box_show = '';
												}
										
										
										echo '<tr>';
										echo '<td>'.$aging_Rpt_val['id'].'</td>';
										echo '<td>'.date("d - M - Y", strtotime($aging_Rpt_val['date_time_of_invoice_issue'])).'</td>';
										
										echo '<td><a href="javascript:void(0)" id="'.$aging_Rpt_val['id'].'" data-id="invoice_view_details" class="add_invoice_details" >'.$aging_Rpt_val['invoice_num'].'</a></td>';
										
										echo '<td><a href="javascript:void(0)" id="'.$aging_Rpt_val['party_name'].'" data-id="ledger_view" class="add_account_tabs">'.$party_name->name.'</a></td>';
										echo '<td>'.$sales_person->name.'</td>';
										
										echo '<td>'.money_format('%!i',$aging_Rpt_val['total_amount']).'</td>';
										echo '<td>'.$dueDate.'</td>';
										echo '<td>'.$above_days_between.'</td>';
										//echo '<td>'.$check_box_show.'</td>';
										echo '<tr>';
										
										/******************* For Export In Excel *****************/
											$output[] = array(
												   'ID' => $aging_Rpt_val['id'],
												   'Invoice Date' => date("d-M-Y", strtotime($aging_Rpt_val['date_time_of_invoice_issue'])),
												   'Invoice #' => $aging_Rpt_val['invoice_num'],
												   'Party Name' => $party_name->name,
												   'Invoice Amount' => $aging_Rpt_val['total_amount'],
												   'Due Date' => date("d-m-Y", strtotime($aging_Rpt_val['due_date'])),
												);
										/******************* For Export In Excel *****************/	
										
									}
										echo '<tr><td colspan="5" align="right"><b>Total :- </b></td><td>'.money_format('%!i',$total_amount_sum).'</td><td></td><td></td></tr>';
									
									
								/******************* For Export In Excel *****************/	
									 $data3  = $output;
									 export_csv_excel($data3); 	
								/******************* For Export In Excel *****************/	
										
										
										
								}else{
									echo "<tr><td colspan='9' style='text-align:center;'>No record found</td></tr>";
								}						
				  
								?>
						</tbody>                   
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
echo $this->pagination->create_links();
// pre($result_count);

?>
		<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;"><?php echo $result_count; ?></div>
		<div id="account_add_modal" class="modal fade in"  role="dialog">
			<div class="modal-dialog modal-lg modal-large">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">View Party Detail</h4>
					</div>
					<div class="modal-body-content"></div>
				</div>
			</div>
		</div>
		<div id="add_invoice_detail_modal" class="modal fade in"  role="dialog">  
			<div class="modal-dialog  modal-large">
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
		
 <div class="modal fade" id="myModal_share_email_aging_report" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
			<div class="modal-header">
		
                <h4 class="modal-title" id="myModalLabel">Send Email</h4>
				<span id="mssg"></span>
			</div>
			<form name="form_share_viaEmail" name="share_form"  id="form_email_send_aging_report">
                 <div class="modal-body">
				 <div class="item form-group col-md-12 col-sm-12 col-xs-12">
				 <?php
				//  $party_email =   getNameById('ledger',$invoice_detail->party_name,'id');
				//echo $party_email->email; 
				 ?>
					<label class="col-md-2 col-sm-2 col-xs-4" for="name">Email<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" name="email_name" id="email_name" required="required" class="form-control col-md-7 col-xs-12" value="">
						<span class="spanLeft control-label"></span>
					</div>
					<label class="col-md-2 col-sm-2 col-xs-4" for="name">Subject<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						<input type="text" name="email_subject" id="email_subject" required="required" class="form-control col-md-7 col-xs-12" value="">
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				<div class="item form-group col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-4" for="name">Message</label>
					<div class="col-md-10 col-sm-10 col-xs-8 form-group">
						
						<textarea id="email_message" name="email_message"  class="form-control col-md-7 col-xs-12" placeholder="Message ..." ></textarea>
						<span class="spanLeft control-label"></span>
					</div>
				</div>
				<?php
					//echo '<input type="hidden" id="invoice_id" value="'.$invoice_detail->id.'">';
				?>
				
                <div class="modal-footer">
				<input type="hidden" id="sale_ledger_data">
				    <button type="button" class="btn btn-default close_sec_model_aging" >Close</button>
					<button id="send_aging_report_email" type="button" class="btn btn-warning">Submit</button>
                </div>
				</form>
            </div>
        </div>
    </div>
</div>		
		
		


