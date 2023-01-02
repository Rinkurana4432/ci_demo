<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
        <div class="col-md-4 datePick-right">
            <input type="hidden" value='leads' id="table" data-msg="Leads" data-path="crm/leads" />
            <input type="hidden" name="rating" id="rating" />
            <fieldset>
               <!-- <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <?php /* <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value=""  data-table="crm/leads"/>*/?>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="crm/leads" />
                     </div>
                  </div>
               </div> -->
            </fieldset>
            <form action="<?php echo base_url(); ?>crm/Sales_Cycle_Duration_across_Leads_Source" method="get" id="date_range">
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>
    </div>
</div>
   <div class="stik">
      <div class="col-md-12 export_div">
        
         <div class="btn-group" role="group" aria-label="Basic example">
           
             <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown" aria-expanded="false">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div>
         </div>
         <div class="col-md-4 col-sm-12 datePick-right">
            <form action="<?php echo site_url(); ?>crm/Sales_Cycle_Duration_across_Leads_Source" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType' />
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>

      </div>
   </div> 
   <div class="x_content">
    <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm print_clsss" id="bbtn">Print</button>
     <div id="print_div_content">
      <table id="attendance123" class="table table-striped table-bordered account_index" cellspacing="0" width="100%">
         <thead>
            <tr>
               <th>Lead Source</th>
               <th><?php echo date('M Y', strtotime("last month"));?></th>
               <th>AVG OF SALES CYCLE DURATION IN DAY(S)</th>
            </tr>
         </thead>
          <tbody>   
            <?php if(!empty($invoices11)){
						#	array_unique($invoices112);
              $pageNos = array();
                           foreach($invoices11 as $invoices112){
          							     $total = count($invoices112);
              								 $i=1;
                               $totalsum = 0;
                              foreach($invoices112 as $ert){
                              if(!empty($ert) && $ert->lead_source !='' && $ert->lead_source != 0) {  
                                $user = getNameById('add_lead_source',$ert->lead_source,'id');
                                $user_name = !empty($user)?$user->leads_source_name:''; 
                              }else { $user_name = 'N/A'; }                    
						?>
                  <?php
                   if(!in_array($ert->lead_source, $pageNos)){ 
                    array_push($pageNos,$ert->lead_source);
                  ?>
									  <tr>
                      <td> 
                        <?php 
    									   echo $user_name; 
    									  #}
									      ?>         
                      </td>
                      <td><?php echo $total; ?></td>
                      <td><?php $yh = date("t", mktime(0,0,0, date("n") - 1));
                     #echo $total / $yh;
                     echo bcdiv($total / $yh, 1, 2)
                      #echo round($total / $yh) ;
                      ?></td>
                    </tr>
                    <?php 
                      $output[] = array(
                        'Lead Source' => !empty($user_name)?$user_name:'',
                       date('M Y', strtotime("last month"))
                         => !empty($total)?$total:'',
                        'AVG OF SALES CYCLE DURATION IN DAY(S)' => bcdiv($total / $yh, 1, 2),
                      );   
                    ?>
            <?php } ?>        
								    <?php }}
                    $data3  = $output;
                      export_csv_excel($data3);
                     ?>    
             <?php  } ?>
            </tbody>
         </table>
   </div>
</div>
   