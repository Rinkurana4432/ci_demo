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
            <form action="<?php echo base_url(); ?>crm/sale_orders_by_accounts" method="get" id="date_range">
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>
    </div>
</div>
   <div class="stik">
      <div class="col-md-12 export_div">
        
         <div class="btn-group" role="group" aria-label="Basic example">
          <a href="<?php echo base_url(); ?>crm/sale_orders_by_accounts" class="Reset-btn btn btn-success">
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
            <form action="<?php echo site_url(); ?>crm/sale_orders_by_accounts" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType' />
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>

      </div>
   </div> 
                                 <!-- <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset" ></a> -->
   <div class="x_content">
    
    <!-- Sale order by Accounts Print Function 10-03-2022 -->
    <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtnBtnSaleAccount">Print</button>
    <!-- Sale order by Accounts Print Function 10-03-2022 -->
     <div id="saleOrdAccnt">
      <table id="attendance123" class="table table-striped table-bordered account_index" cellspacing="0" width="100%" border="1">
         <thead>
            <tr>
               <th>Account Name</th>
               <th>Sale Order No.</th>
               <th>Order Date</th>
               <th>Phone No.</th>
               <th>Status</th>
               <th>Grand Total</th>
               <th>Created By</th>
               <th>Created Date</th>
            </tr>
         </thead>
            <tbody> 
            <?php if(!empty($saleorder)){
							
                           foreach($saleorder as $saleorders){

          							     $total = count($saleorders);
          								 $i=1;
                           $totalsum = 0;
								            foreach($saleorders as $sowner){
                              if(!empty($sowner) && $sowner['created_by'] !='' && $sowner['created_by'] != 0) {  
                                $user = getNameById('user_detail',$sowner['created_by'],'u_id');
                                $user_name = !empty($user)?$user->name:''; 
                              }else { $user_name = ''; }

                              if(!empty($sowner) && $sowner['account_id'] !='' && $sowner['account_id'] != 0) {  
                                $aownername = getNameById('account',$sowner['account_id'],'id');
                              #  pre($ownername);
                                $aowner_name = !empty($aownername)?$aownername->name:''; 
                                $awner_phone = !empty($aownername)?$aownername->phone:'';
                              }else { $aowner_name = '';  $awner_phone = '';}

                              if(!empty($sowner) && $sowner['approve'] !='' && $sowner['approve'] != 0){
                                $status = "Approved";
                              }else
                              {
                                $status = "Disapprove";
                              }
						?>
									  <tr>
                      <td> 
                        <?php 
    									   if($i == 1){
    									   echo $aowner_name." (".$total.")"; 
    									   }
									      ?>         
                      </td>
                        <td><?php echo $sowner['so_order']; ?></td>
                        <td><?php echo date("j F , Y", strtotime($sowner['order_date']));?></td>
                        <td><?php echo $awner_phone; ?></td>
                        <td><?php echo $status; ?></td>
                        <td><?php echo $sowner['grandTotal']; ?></td>
                        <td><?php echo $user_name;?></td>
                        <td><?php echo $sowner['created_date']; ?></td>
                    </tr>
                     <?php 
                      $output[] = array(
                        'Account Name' => !empty($aowner_name)?$aowner_name:'',
                        'Sale Order No.' => !empty($sowner['so_order'])?$sowner['so_order']:'',  
                        'Order Date' => !empty($sowner['order_date'])?$sowner['order_date']:'',
                        'Phone No.' => !empty($awner_phone)?$awner_phone:'',
                        'Status' => !empty($status)?$status:'',
                        'Grand Total' => !empty($sowner['grandTotal'])?$sowner['grandTotal']:'', 
                        'Created Date' => !empty($sowner['created_date'])?$sowner['created_date']:'',
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