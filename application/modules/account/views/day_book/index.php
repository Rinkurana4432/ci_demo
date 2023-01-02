<div class="col-md-12 item offset-md-8" >
   <input type="hidden" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="login_user_id">
   <p class="text-muted font-13 m-b-30"></p>
   <?php
      setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
      $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
      $company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');
      ?>
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="get" action="<?= base_url() ?>account/day_book/">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" data-ctrl="account/day_book" placeholder="Type Vouhcher Type" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <a href="<?php echo base_url(); ?>account/day_book"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                  </span>
               </div>
            </div>
         </form>
         <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         <div id="demo" class="collapse">
            <div class="col-md-12 col-xs-12">
               <fieldset>
                  <div class="control-group">
                     <div class="controls">
                        <div class="input-prepend input-group">
                           <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/day_book" readonly>
                        </div>
                     </div>
                  </div>
               </fieldset>
               <form action="<?php echo base_url(); ?>account/day_book" method="get" id="date_range">
                  <input type="hidden" value='' class='start_date' name='start'/>
                  <input type="hidden" value='' class='end_date' name='end'/>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="export_div col-md-12 col-xs-12 col-sm-12">
      <div class="btn-group"  role="group" aria-label="Basic example">
         <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
         <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
            <button class="btn btn-secondary dropdown-toggle btn-default" style="margin-right: 0px !important;" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" id="export-menu">
               <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
               <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
            </ul>
         </div>
      </div>
      <div class="col-md-4 col-xs-12 "></div>
   </div>
   <form action="<?php echo site_url(); ?>account/day_book?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>" method="get" id="export-form">
      <input type="hidden" value='' id='hidden-type' name='ExportType'/>
      <input type="hidden" value='<?php echo $_GET['start'];?>' class='start_date' name='start'/>
      <input type="hidden" value='<?php echo $_GET['end'];?>' class='end_date' name='end'/>
      <input type="hidden" value='<?php echo $_GET['tab'];?>' name='tab'/>
   </form>
   <div id="print_div_content">
      <center>
         <table style="display:none;" class="comp_name">
            <tr>
               <td><b style="font-size:18px;"><?php echo $company_brnaches->name; ?></b> <br/><br/><b> Day Book</b></td>
            </tr>
         </table>
      </center>
      <!---day_book_id--->
      <table id="" class="table table-striped table-bordered action-icons"  style="width:100%; margin-top:40px;" border="1" cellpadding="3">
         <thead>
            <tr>
               <th scope="col">S.No.
                  <span><a href="<?php echo base_url(); ?>account/day_book?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>account/day_book?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Date
                  <span><a href="<?php echo base_url(); ?>account/day_book?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>account/day_book?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Particulars
                  <span><a href="<?php echo base_url(); ?>account/day_book?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>account/day_book?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Voucher No.</th>
               <th scope="col">Voucher Type</th>
               <th scope="col">Credit <br><small>Outwards</small></th>
               <th scope="col">Debit <br><small>Inwards</small></th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <?php
                  if(!empty($day_data_val)){
					 $sno = 1;
					 if( $this->uri->segment(3) ){
						 $sno = ($this->uri->segment(3) * 10) - 9;
					 }
                  	 foreach($day_data_val as $dtl){

                  		 $added_invoice_id = '';
                  		if($dtl['type'] == 'purchase_bill_payment_recive'){
                  			$get_payment_details_from_payment_tbl	= getNameById('payment',$dtl['type_id'],'id');
                  			//pre($get_payment_details_from_payment_tbl);
                  				$data_json	= JSON_DECODE($get_payment_details_from_payment_tbl->payment_detail);

                  			foreach($data_json as $detail){

                  				$inovoice_detail['bill_id'] = $detail->bill_id;
                  				   $added_invoice_id .= "<a href='javascript:void(0)' id='".$inovoice_detail['bill_id']."' data-id='purchase_bill_view' class='add_purchase_bill_to_tabs'>".$inovoice_detail['bill_id'].'</a>';
                  				}
                  			}else if($dtl['type'] == 'Payment Receive'){
                  				$get_payment_details_from_payment_tbl	= getNameById('payment',$dtl['type_id'],'id');
                  				$data_json_invoice_payment_recive = JSON_DECODE($get_payment_details_from_payment_tbl->payment_detail);
                  				foreach($data_json_invoice_payment_recive as $detail_invoice){
                  					$inovoice_detail['invoice_id'] = $detail_invoice->invoice_id;
                     					$added_invoice_id .= "<a href='javascript:void(0)' id='".$inovoice_detail['invoice_id']."' data-id='invoice_view_details' class='add_invoice_details' style='float:left;'>".$inovoice_detail['invoice_id']."</a>";
                  				}

                  			}else if($dtl['type'] == 'invoice'){
                  				$added_invoice_id .= "<a href='javascript:void(0)' id='".$dtl['type_id']."' data-id='invoice_view_details' class='add_invoice_details' style='float:left;'>".$dtl['type_id']."</a>";
                  			}else if($dtl['type'] == 'purchase_bill'){
                  				 $added_invoice_id .= "<a href='javascript:void(0)' id='".$dtl['type_id']."' data-id='purchase_bill_view' class='add_purchase_bill_to_tabs'>".$dtl['type_id'].'</a>';
                  			}else if($dtl['type'] == 'creditnoteSaleReturn'){
                  				 $added_invoice_id .= "<a href='javascript:void(0)' id='".$dtl['type_id']."' data-id='crSaleReturn_view_details' class='add_CrSaleREturn_details'>".$dtl['type_id'].'</a>';
                  			}else{
                  				$added_invoice_id .= "<a href='javascript:void(0)' id='".$dtl['type_id']."' data-id='voucher_dtl_view' class='add_voucher_details_tabs'>".$dtl['type_id'].'</a>';
                  			}

                  		if($dtl['type'] == 'invoice'){
                  				$vcher_type = 'Invoice';
                  				$get_invoice_dtl = getNameById('invoice',$dtl['type_id'],'id');
                  				//pre($get_invoice_dtl);
                  				//$newDate = date("j F , Y", strtotime($get_invoice_dtl->date_time_of_invoice_issue));
                  				$newDate = date("j F , Y", strtotime($get_invoice_dtl->date_time_of_invoice_issue));
                  			}else if($dtl['type'] == 'purchase_bill'){
                  				$vcher_type = 'Purchase Bill';
                  				$get_purchase_bill_dtl = getNameById('purchase_bill',$dtl['type_id'],'id');
                  				$newDate = date("j F , Y", strtotime($get_purchase_bill_dtl->date));
                  			}else if($dtl['type'] == 'Payment Receive'){
                  				$vcher_type = 'Payment Receive';
                  				$get_payment_recive_dtl = getNameById('payment',$dtl['type_id'],'id');

                  				$newDate = date("j F , Y", strtotime($get_payment_recive_dtl->payment_date));
                  			}else if($dtl['type'] == 'purchase_bill_payment_recive'){
                  				$vcher_type = 'Payment Done';
                  				$newDate = date("j F , Y", strtotime($dtl['created_date']));
                  			}else if($dtl['type'] == 'creditnoteSaleReturn'){
                  				$vcher_type = 'Sale Return CN';
                  				$newDate = date("j F , Y", strtotime($dtl['created_date']));
                  			}else{
                  				$get_vaoucher_id = getNameById('voucher',$dtl['type_id'],'id');
                  				$get_vaoucher_name = getNameById('voucher_type',$get_vaoucher_id->voucher_name,'id');
                  				//pre($get_vaoucher_id);
                  				$vcher_type = $get_vaoucher_name->voucher_name;
                  				$newDate = date("j F , Y", strtotime($get_vaoucher_id->voucher_date));
                  			}
                  			$ledger_name = getNameById('ledger',$dtl['ledger_id'],'id');
                  			//pre($dtl);
                  ?>
               <td data-label='s.no:'><?php echo $sno; ?> </td>
               <td data-label='data:'><?php echo date('d-m-Y',strtotime($dtl['add_date'])); //$newDate; ?> </td>
               <td data-label='Particulars:'><?php echo $ledger_name->name; ?> </td>
               <td data-label='Voucher No.:'><?php echo $added_invoice_id; ?> </td>
               <td data-label='Voucher Type.:'><?php echo $vcher_type; ?></td>
               <td data-label='Credit Outwards.:'><?php echo money_format('%!i',$dtl['credit_dtl']);?></td>
               <!--td><?php //echo money_format('%!i',$dtl->credit_dtl); ?></td-->
               <td data-label='Debit Inwards.:'><?php echo money_format('%!i',$dtl['debit_dtl']); ?></td>
            </tr>
            <?php
               $output[] = array(
               			   'S.no' => $sno,
               			   'Date' => $newDate,
               			   'Particulars' => $ledger_name->name,
               			   'Voucher Type' => $vcher_type,
               			   'Credit' => money_format('%!i',$dtl['credit_dtl']),
               			   'Debit' => money_format('%!i',$dtl['debit_dtl'])
               			);





               	$sno++;
               	}
                   $data3  = $output;
               	export_csv_excel($data3);
               	}  else { ?>
            <tr>
               <td colspan="8"><b>No Data Available</b></td>
            </tr>
            <?php } ?>
         </tbody>
      </table>
      <?php echo $this->pagination->create_links(); ?>
      <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
         <?php echo $result_count; ?></span>
      </div>
   </div>
</div>
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
<?php
   $this->load->view('common_modal');
   ?>
