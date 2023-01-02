

<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
        <div class="col-md-4 datePick-right">
            <input type="hidden" value='leads' id="table" data-msg="Leads" data-path="crm/leads" />
            <input type="hidden" name="rating" id="rating" />
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <?php /* <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value=""  data-table="crm/leads"/>*/?>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="crm/leads" />
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>crm/invoice_by_status" method="get" id="date_range">
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>
    </div>
</div>
   <div class="stik">
      <div class="col-md-12 export_div">
        
         <div class="btn-group" role="group" aria-label="Basic example">

          <a href="<?php echo base_url(); ?>crm/invoice_by_status" class="Reset-btn btn btn-success">
        Reset
         </a>

             <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown" aria-expanded="false">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div>
         </div>
         <div class="col-md-4 col-sm-12 datePick-right">
            <form action="<?php echo site_url(); ?>crm/invoice_by_status" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType' />
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>

      </div>
   </div> 
                                 <!-- <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset" ></a> -->

   <div class="x_content">
    
    <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm print_clsss" id="bbtn">Print</button>
     <div id="print_div_content">
      <table id="attendance123" class="table table-striped table-bordered account_index" cellspacing="0" width="100%">
         <thead>
            <tr>
               <th>Invoice Status</th>
               <th>Account Name</th>
               <th>Invoice No.</th>
               <th>Invoice Issue Date</th> 
               <th>Party Phone</th>
               <th>Grand Total</th>
               <th>Created By</th>
            </tr>
         </thead>
            <tbody>
            
            <?php if(!empty($invoices11)){
                           foreach($invoices11 as $invoices11s){
                           # pre($invoices11s);
          							     $total = count($invoices11s);
              								 $i=1;
                               $totalsum = 0;
								            foreach($invoices11s as $invoices){
                             
                              if(!empty($invoices) && $invoices['created_by'] !='' && $invoices['created_by'] != 0) {  
                                $user = getNameById('user_detail',$invoices['created_by'],'u_id');
                                $user_name = !empty($user)?$user->name:''; 
                              }else { $user_name = ''; }


                              if(!empty($invoices) && $invoices['party_name'] !='' && $invoices['party_name'] != 0) {  
                                $aownername = getNameById('ledger',$invoices['party_name'],'id');

                                #pre($aownername);
                                $aowner_name = !empty($aownername)?$aownername->name:''; 
                              }else { $aowner_name = '';}


                              if(!empty($invoices) && $invoices['pay_or_not'] !='' && $invoices['pay_or_not'] != 0){
                                $status = "Paid";
                              }else
                              {
                                $status = "Not Paid";
                              }
						?>
									  <tr>
                          <td> 
                            <?php if($i == 1){echo $status." (".$total.")"; } ?>         
                          </td>
                          <td><?php  echo $aowner_name; ?></td>
                                    
                          <td><?php  echo $invoices['invoice_num']; ?></td>
                           <td><?php  echo date("j F , Y", strtotime($invoices['date_time_of_invoice_issue']));?></td>   
                          <td><?php  echo $invoices['party_phone']; ?></td>
                          <td><?php  echo $invoices['total_amount']; ?></td>
                          <td><?php  echo $user_name;?></td>
                    </tr>
                    <?php 
                      $output[] = array(
                  'Invoice Status' => !empty($status)?$status:'',
                  'Account Name' => !empty($aowner_name)?$aowner_name:'',
                  'Invoice No.' => !empty($invoices['invoice_num'])?$invoices['invoice_num']:'',
                  'Invoice Issue Date' => !empty($invoices['date_time_of_invoice_issue'])?$invoices['date_time_of_invoice_issue']:'',
  
                  'Party Phone No.' => !empty($invoices['party_phone'])?$invoices['party_phone']:'',
                  'Grand Total' => !empty($invoices['total_amount'])?$invoices['total_amount']:'',
                  'Created By' => !empty($user_name)?$user_name:'',
                      );   
                    ?>
								<?php $i++; } ?>
                <tr>
               </tr>   
						  <?php }
                 $data3  = $output;
                export_csv_excel($data3);
               ?>
             <?php  } ?>
            </tbody>
         </table>
   </div>
    </div>
</div>
<div id="printThis">
<div id="crm_add_modal" class="modal fade in"  role="dialog">
  <div class="modal-dialog modal-lg modal-large">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title nxt_cls" id="myModalLabel">Lead</h4>
      </div>
      <div class="modal-body-content"></div>
    </div>
  </div>
</div>         
   