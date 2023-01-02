
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-info">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }
   setlocale(LC_MONETARY, 'en_IN');
   ?>
<div class="x_content">
   <div class="row hidde_cls stik">
      <div class="col-md-12 col-sm-12 for-mobile">
         <div class="Filter Filter-btn2">
            <form class="form-search" method="get" action="<?= base_url() ?>purchase/aging_report">
               <div class="col-md-6">
                  <div class="input-group">
                     <span class="input-group-addon">
                     <i class="ace-icon fa fa-check"></i>
                     </span>
                     <input type="text" class="form-control search-query" placeholder="Enter Id,Bill no" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="purchase/aging_report">
                     <input type="hidden" value='<?php echo $_GET['tab']; ?>' name="tab"/>
                     <span class="input-group-btn">
                     <button type="submit" class="btn btn-purple btn-sm">
                     <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                     Search
                     </button>
                     <a href="<?php echo base_url(); ?>purchase/aging_report">
                     <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                     </span>
                  </div>
               </div>
            </form>
            <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>    
            <div id="demo" class="collapse">
               <!-- Filter div Start-->
               <div class="col-md-12  col-sm-12 datePick-left">
                  <fieldset>
                     <div class="control-group">
                        <div class="controls">
                           <div class="input-prepend input-group">
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="purchase/aging_report">
                           </div>
                        </div>
                     </div>
                  </fieldset>
                  <form action="<?php echo base_url(); ?>purchase/aging_report" method="GET" id="date_range">  
                     <input type="hidden" value='' class='start_date' name='start'/>
                     <input type="hidden" value='' class='end_date' name='end'/>
                  </form>
               </div>
               <div class="row filter1 Filter_div">
                  <form action="<?php echo base_url(); ?>purchase/aging_report" method="GET">
                     <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
                     <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
                     <div class="col-md-12">
                        <div class="btn-group"  role="group" aria-label="Basic example" >
                           <select class="form-control select_mat disbled_cls" name="material_type" data-id="material_type" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0">
                              <option value="">Select Material</option>
                           </select>
                        </div>
                        <div class="btn-group"  role="group" aria-label="Basic example" >
                           <select class="form-control supp_name disbled_cls select_supplier" name="supplier_name" data-id="supplier" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" >
                              <option value="">Select </option>
                           </select>
                        </div>
                        <div class="btn-group"  role="group" aria-label="Basic example" >
                           <select name="company_unit" class="form-control company_unit disbled_cls">
                              <option value=""> Select Category </option>
                              <?php
                                 if(!empty($company_unit_adress) ){
                                    foreach($company_unit_adress as $companyAdress){
                                    $getAddress = $companyAdress['address'];
                                    $getDecodeAddress = json_decode($getAddress);
                                    foreach($getDecodeAddress as $fetchAddress){
                                       $address = $fetchAddress->address;
                                       
                                    
                                 ?>
                              <option value="<?php echo $address; ?>" <?php if ($address == $_POST['company_unit']) echo "selected";?> ><?php echo $address; ?></option>
                              <?php }} } ?>        
                           </select>
                        </div>
                        <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
                           <select class="form-control" id="approved_material_type" name="purchase_type"  width="100%" tabindex="-1" aria-hidden="true" >
                              <option value="" style="color: #999 !important;"> Select Type</option>
                              <option value="2" >Domestic</option>
                              <option value="1">Import</option>
                           </select>
                        </div>
                        <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
                           <select class="form-control commanSelect2" name="report_type" width="100%">
                              <option value="">Select Report Type</option>
                              <option value="pass" <?= ($_GET['report_type'] == 'pass')?'selected':''; ?> >Pass</option>
                              <option value="fail" <?= ($_GET['report_type'] == 'fail')?'selected':''; ?>>Fail</option>
                           </select>
                        </div>
                        <input type="submit" value="Filter" class="btn filt1"  disabled="disabled">
                     </div>
                  </form>
               </div>
               <!-- Filter div End-->     
            </div>
            <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>purchase/aging_report">
               <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
            </form>
         </div>
         <form action="<?php echo base_url(); ?>purchase/aging_report?tab=<?php echo $_GET['tab']; ?>" method="GET" id="export-form">
            <input type="hidden" value='' id='hidden-type' name='ExportType' />
            <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
            <input type="hidden" value='' class='start_date' name='start' />
            <input type="hidden" value='' class='end_date' name='end' />
            <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
            <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
            <input type="hidden" value='<?php echo $_GET['material_type']; ?>' class='material_type' name='material_type'/>
            <input type="hidden" value='<?php echo $_GET['supplier_name']; ?>' class='supplier_name' name='supplier_name'/>
            <input type="hidden" value='<?php echo $_GET['favourites']; ?>' name="favourites"/>
            <input type="hidden" value='<?php echo $_GET['company_unit']; ?>' name="company_unit"/>
            <input type="hidden" value='<?php echo $_GET['tab']; ?>' name="tab"/>
            <input type="hidden" value='<?php echo $_GET['search']; ?>' name="search"/>
         </form>
         <!-- <div class="col-md-12 col-xs-12">
            <div class=" export_div">
               <div class="btn-group" role="group" aria-label="Basic example">
                 
                   
                  <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm print_clsss" id="<?= ( $_GET['tab'] == 'complete' )?'bbtn22':'bbtn'; ?>">Print</button>
                  <input type="hidden" value='mrn_detail' id="table" data-msg="Goods Receipt Note" data-path="purchase/aging_report"/>
                  <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                     <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                     <ul class="dropdown-menu" role="menu" id="export-menu">
                        <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                        <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                     </ul>
                  </div>
                 
                  
               </div>
            </div>
         </div> -->
      </div>
   </div>
   <p class="text-muted font-13 m-b-30"></p>
   <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id; ?>">
   <div role="tabpanel" data-example-id="togglable-tabs">
      
      <div id="myTabContent" class="tab-content">
         <div role="tabpanel" class="tab-pane fade active in" id="in_progress_tab" aria-labelledby="complete_tab">
            <p class="text-muted font-13 m-b-30"></p>
            <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>"> 
            <form id="mrninprocess_form"><input type="hidden" value="inprocess" name="tab"></form>
            <div id="print_div_content">
               <div class="table-responsive">
                  <?php /* <table id="example" style="width:100%;" class="table  table-bordered inprocess_div" data-id="user" data-order='[[1,"desc"]]' border="1" cellpadding="2" > */   ?>
                  <table id="" style="width:100%;" class="table  table-bordered inprocess_div" data-id="user"  border="1" cellpadding="2" >
                     <thead>
                        <tr>
                           
                           <th scope="col">Id
                              <span><a href="<?php echo base_url(); ?>purchase/aging_report?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/aging_report?tab=inprocess&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Bill No.
                              <span><a href="<?php echo base_url(); ?>purchase/aging_report?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/aging_report?sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Supplier Name
                              <span><a href="<?php echo base_url(); ?>purchase/aging_report?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/aging_report?sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Purchase Indent No. 
                              <span><a href="<?php echo base_url(); ?>purchase/aging_report?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/aging_report?tab=inprocess&sort=desc" class="down"></a></span> 
                           </th>
                         
                           <th scope="col">Grand Total</th>
                           <th scope="col">Payment Terms</th>
                           <th scope="col">Received Date</th>
                           <th scope="col">Order Date</th> 
                           <th scope="col">Due Days</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if (!empty($mrn)) { 
                           $total_sum=0;
                              foreach ($mrn as $MRN) { 
                               if($MRN['received_date'] != 0){
												$current_Date = date ("Y-m-d");
												$due_date = date("Y-m-d", strtotime($MRN['received_date']));
												$start = strtotime($current_Date);
												$end = strtotime($due_date);
												//$days_between = ceil(abs($end - $start) / 86400);
												$above_days_between = ($start - $end)/60/60/24; 
												$dueDate = date("d - M - Y", strtotime($MRN['received_date']));
											}else{
												$above_days_between = 'Day not Set';
												$dueDate =  '0000-00-00';
											}


                                 $supplierName = getNameById('supplier', $MRN['supplier_name'], 'id');
                                 $po_number = getNameById('purchase_order', $MRN['po_id'], 'id');
                                 $pi_number = getNameById('purchase_indent', $MRN['pi_id'], 'id');
                                 $matriealtype_name = ($MRN['material_type_id']!=0)?(getNameById('material_type',$MRN['material_type_id'],'id')->name):'';
                                 $deliveryAddress = getNameById('company_detail', $MRN['delivery_address'], 'id');
                                 $draftImage = '';
                                 if ($MRN['save_status'] == 0)
                                    $draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img class="img-responsive" src="'.base_url().'assets/images/draft.png" > </a>';
                                 
                                 ?>
                        <tr>
                           
                           <td data-label="id:"><?php echo $draftImage . $MRN['id']; ?></td>
                           <td data-label="Bill No:"><?php echo $MRN['bill_no']; ?></td>
                           <td data-label="Supplier Name:"><?php if (!empty($supplierName)) {
                              echo '<a href="javascript:void(0)" id="'.$MRN['supplier_name'].'" data-id="SupplierView" class="add_purchase_tabs">'.$supplierName->name.'</a>';
                              } ?></td>
                           <td data-label="Purchase Indent No. / Purchase Order No:"><?php 
                              if (!empty($po_number)) {
                                 echo '<a href="javascript:void(0)" id="'.$MRN['po_id'].'" data-id="OrderView" class="add_purchase_tabs">'.$po_number->order_code.'</a>';
                              }else{
                                 echo '<a href="javascript:void(0)" id="'.$MRN['pi_id'].'" data-id="indentView" class="add_purchase_tabs">'.$pi_number->indent_code.'</a>';
                              } 
                                 
                                 
                                 ?></td>
                          
                            
                           <td data-label="Grand Total:"><?php echo $MRN['grand_total']; ?></td>
                           <td data-label="Payment Terms:"><?php echo $MRN['payment_terms']; ?></td>
                           <td data-label="Received Date:"><?php if($MRN['received_date'] != '') echo date("j F , Y", strtotime($MRN['received_date'])); ?></td>
                           <td data-label="Received Date:"><?php if($MRN['date'] != '') echo date("j F , Y", strtotime($MRN['date'])); ?></td>
                           <td><?=$above_days_between;?></td>
                            
                          </td>
                        </tr>
                        <?php
                           $total_sum+=$MRN['grand_total'];
                           }
                           $data3  = $output;
                           //pre($data3);die();
                           export_csv_excel($data3);
                           
                           $data_balnk  = $output_blank;
                           export_csv_excel_blank($data_balnk); 
                           
                           
                           } ?>
                     </tbody>
                     <tr class="boot_strp_Data">
                        <th colspan="3" style="text-align:center;">Total</th>
                        <th  class="totlamt"><?php echo $total_sum;?></th>
                        <th colspan="5"></th>
                     </tr>
                  </table>
                  <?php  //$paginglinksInProcess;
                     //  echo $this->pagination->create_links(); ?>
               </div>
            </div>
         </div>
        
      </div>
   </div>
</div>
<?php echo $this->pagination->create_links(); ?>
<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;"><?php echo $result_count; ?></span></div>
<div id="printView">
   <div id="purchase_add_modal" class="modal fade in" role="dialog" style="overflow:auto;">
      <div class="modal-dialog modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title add_title" id="myModalLabel">GRN</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>
<?php $this->load->view('common_modal'); ?>