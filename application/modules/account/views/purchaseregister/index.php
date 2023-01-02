<div class="x_content">
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="post" action="<?= base_url() ?>account/prchase_register/">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter id,Supplier Name" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>" data-ctrl="account/prchase_register">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <a href="<?php echo base_url(); ?>account/prchase_register"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                  </span>
               </div>
            </div>
         </form>
         <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button> 
         <div id="demo" class="collapse">
		    <div class="col-md-12">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/prchase_register"/>
                     </div>
                  </div>
               </div>
            </fieldset>
         </div>
            <?php 
            /*   setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
               if($this->session->flashdata('message') != ''){
               	echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
               }
               
               $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
               //echo $this->companyGroupId;
               	$company_brnaches = getNameById('company_detail',$this->companyGroupId ,'id');
               	if(!empty($company_brnaches)){
               ?>
            <form action="<?php echo site_url(); ?>account/prchase_register" method="get" id="select_from_brnch">
               <div class="required item form-group company_brnch_div" >
                  <label class="required control-label col-md-12 col-sm-12 col-xs-4" for="company_branch">Select Company Branch</label>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <select class="itemName form-control Get_data_accoriding_tobranch" name="selected_branch_idd" name="compny_branch_id" width="100%">
                        <!--option value=""> Select Company Branch </option-->
                        <option Value ="All">Company Branch All</option>
                        <?php
                           $branch_Add = json_decode($company_brnaches->address);
                           foreach($branch_Add as $val_branch){ ?>
                        <option <?php if($val_branch->add_id == $_POST['selected_branch_idd']){ ?> selected="selected" <?php }?> value="<?php echo $val_branch->add_id; ?>"><?php echo $val_branch->compny_branch_name; ?> </option>
                        </option>
                        <?php } ?>
                     </select>
                  </div>
                  <input type="hidden" value='' class='start_date' name='start'/>
                  <input type="hidden" value='' class='end_date' name='end'/>
                  <input type="submit" value="Filter" class="btn btn-info filt1" style="clear: both;display: table;margin: 3px auto;">
               </div>
            </form>
            <?php } */?>
         </div>
      </div>
   </div>
   <p class="text-muted font-13 m-b-30"></p>
   <form action="<?php echo site_url(); ?>account/prchase_register" method="get" id="export-form">
      <input type="hidden" value='' id='hidden-type' name='ExportType'/>
      <input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
      <input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>   
	  <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
</form>
   <form action="<?php echo base_url(); ?>account/prchase_register" method="get" id="date_range">	
      <input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
      <input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
      <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
   </form>
   <div class="row hidde_cls">
      <div class="col-md-12 export_div">
         
         
            <div class="btn-group"  role="group" aria-label="Basic example">
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
      <table id="" class="table table-striped table-bordered" data-id="account" border="1" cellpadding="3" data-order='[[1,"desc"]]' style="margin-top:40px;">
         <thead>
            <tr>
               <th scope="col">Id 
                  <span>
                  <a href="<?php echo base_url(); ?>account/prchase_register?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>account/prchase_register?sort=desc" class="down"></a>
                  </span>
               </th>
               <th scope="col">Supplier Name
                  <span>
                  <a href="<?php echo base_url(); ?>account/prchase_register?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>account/prchase_register?sort=desc" class="down"></a>
                  </span>
               </th>
               <th scope="col">Party Name
                  <span>
                  <a href="<?php echo base_url(); ?>account/prchase_register?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>account/prchase_register?sort=desc" class="down"></a>
                  </span>
               </th>
               <th scope="col">Total</th>
               <th scope="col">Tax</th>
               <th scope="col">Amount With Tax</th>
               <th scope="col">Paid or Not</th>
               <th scope="col">Created By</th>
               <th scope="col">Voucher Date</th>
               <th scope="col" class='hidde'>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php  
               if(!empty($purchaseReg_Data)){
               	$sum_tax = $sum_total = $sum_total_with_tax = 0;
                  foreach($purchaseReg_Data as $purchase_datas){ 
               
                 $action = '';
               
               		$action .=  '<a href="javascript:void(0)" id="'.$purchase_datas["id"] . '" data-id="purchaseregister_bill_view" class="view_purchase_register_dital btn btn-warning btn-xs" id="'.$purchase_datas["id"].'" data-tooltip="View"><i class="fa fa-eye"></i> View </a>';
               	
               		$supplier_data = getNameById('ledger',$purchase_datas['supplier_name'],'id');
               	
               		if($purchase_datas['party_name'] != '0'){
               			$ledger_name = getNameById('ledger',$purchase_datas['party_name'],'id');
               			$ledger_name->name;
               		}else{
               			@$ledger_name->name = '';
               		}
               		
               		$billDAte = date("j F , Y", strtotime($purchase_datas['date']));
               		$edited_by = ($purchase_datas['edited_by']!=0)?(getNameById('user_detail',$purchase_datas['edited_by'],'u_id')->name):'';
               		
               		if($purchase_datas['pay_or_not'] =='1'){
               			$paid_or_not =  'Paid';
               		}else{
               			$paid_or_not = 'Not Paid';
               		}
               		$total_tax_dtl = json_decode($purchase_datas['invoice_total_with_tax']);
               		
               		$sum_tax+= @$total_tax_dtl[0]->totaltax;
               		$sum_total+= @$total_tax_dtl[0]->total;
               		$sum_total_with_tax+= @$total_tax_dtl[0]->invoice_total_with_tax;
               	   echo "<tr>
               		<td data-label='id:'>".$purchase_datas['id']."</td>
               		<td data-label='Supplier Name:'>".$supplier_data->name."</td>
               		<td data-label='Party Name:'><a href='javascript:void(0)' id='". $purchase_datas['party_name'] . "' data-id='ledger_view' class='add_account_tabs'>".$ledger_name->name."</a></td>
               		<td data-label='Total:'>".money_format('%!i',$total_tax_dtl[0]->total)."</td>
               		<td data-label='Tax:' class='txxx'>".money_format('%!i',$total_tax_dtl[0]->totaltax)."</td>
               		<td data-label='Amount With Tax:'>".money_format('%!i',$total_tax_dtl[0]->invoice_total_with_tax)."</td>
               		<td data-label='Paid or Not:'>".$paid_or_not."</td>
               		<td data-label='Created By:'><a href='".base_url()."users/edit/".$purchase_datas['created_by']."' target='_blank'>".getNameById('user_detail',$purchase_datas['created_by'],'u_id')->name."</a></td>
               		<td data-label='Voucher Date:'>".$billDAte."</td>
               		<td data-label='action:' class='hidde'>".$action."</td>	
               	</tr>";
               	 $output[] = array(
               		   'ID' => $purchase_datas['id'],
               		   'Supplier Name' => $supplier_data->name,
               		   'Sale Ledger Name' => $ledger_name->name,
               		   'Sub Total' => $total_tax_dtl[0]->invoice_total_with_tax, 
               		   'GSTIN' => $purchase_datas['gstin'],
               		   'Paid or Not' =>$paid_or_not,  
               		   'Created Date' => date("d-m-Y", strtotime($purchase_datas['created_date'])),
               		);	
               	 }
               	 $data3  = $output;
               	 export_csv_excel($data3); 
               ?>
         </tbody>
         <!--tr><td colspan="12"></td></tr-->
         <!--tr class="boot_strp_Data">
            <th colspan="3" style="text-align:center;">Total</th>
            <th  class="totlamt"></th>
            <th class="tx_cls"></th>
            <th class="totltxamt"></th>
            <th colspan="6"></th>
            </tr-->
         <tr class='php_ddta'>
            <th colspan="3" style="text-align:right;">Total  </th>
            <th  class="totlamt_php"><?php echo money_format('%!i',$sum_total); ?></th>
            <th class="tx_cls_php"><?php echo money_format('%!i',$sum_tax); ?></th>
            <th class="totltxamt_php"><?php echo money_format('%!i',$sum_total_with_tax); ?></th>
            <th colspan="6"></th>
         </tr>
         <?php
            $totalw = $totaltax_w = $total_with_tax = 0;
            foreach($purchaseReg_Data as $total_amt){ 
            $in_ttl = json_decode($total_amt['invoice_total_with_tax']);
            $totalw += @$in_ttl[0]->total;
            $totaltax_w += @$in_ttl[0]->totaltax;
            $total_with_tax += @$in_ttl[0]->invoice_total_with_tax;
            }
             ?>
         <tr>
            <td colspan="12"></td>
         </tr>
         <tr>
            <th colspan="3" style="text-align:right;">Grand Total  </th>
            <th  class="totlamt_php"><?php echo money_format('%!i',$totalw); ?></th>
            <th class="tx_cls_php"><?php echo money_format('%!i',$totaltax_w); ?></th>
            <th class="totltxamt_php"><?php echo money_format('%!i',$total_with_tax); ?></th>
            <th colspan="6"></th>
         </tr>
      </table>
      <?php }  ?>
   </div>
</div>


<?php  echo $this->pagination->create_links(); ?>
<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
   <?php echo $result_count; ?></span>
</div>
<div id="purchase_bill_modal" class="modal fade in"  role="dialog">
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Bill Details</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
<?php
   $this->load->view('common_modal'); 
   ?>
 