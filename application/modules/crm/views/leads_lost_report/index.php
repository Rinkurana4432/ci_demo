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
            <form action="<?php echo base_url(); ?>crm/leads_lost" method="get" id="date_range">
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>
	  </div>
</div>
   <div class="stik">
      <div class="col-md-12 export_div">
        
         <div class="btn-group" role="group" aria-label="Basic example">
             <a href="<?php echo base_url(); ?>crm/leads_lost" class="Reset-btn btn btn-success">
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
            <form action="<?php echo site_url(); ?>crm/leads_lost" method="get" id="export-form">
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
                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" style="margin-top: 40px;">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Leads Name</th>
                                        <th scope="col">Leads Lost Reason</th>
                                        <th scope="col">Leads Lost Date</th>
                                        <th scope="col">Lead Created Date</th>
                                        <th scope="col">Leads Cost</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     $totalsum = 0;
                                  if(!empty($leads_data)){

                                    foreach($leads_data as $value): 
                                         if($value['contacts'] !=''){
                                                $contacts_info = json_decode($value['contacts']);
                                                $primaryContact  = $contacts_info[0];                                           
                                         }
                                         $totalsum += floatval($value['grand_total']);
                                        ?>
                                    <tr style="vertical-align:top">
                                        <td data-label='Id:'><span><?php echo $value['id'] ?></span></td>
                                        <td data-label='Customer Name:'> <a href="javascript:void(0)" id="<?php echo $value["id"]; ?>" data-id="lead" class="add_crm_tabs"><?php  if(!empty($primaryContact)){ echo $primaryContact->first_name." ".$primaryContact->last_name; }else {echo '';} ?></a></td>
                                          <td data-label='Leads Name:'><?php echo $value['company']; ?></td>
                                          <td data-label='Leads Lost Reason:'><?php echo $value['status_comment']; ?></td>
                                          <th data-label='Leads Lost Date:'><?php echo $value['updated_date']; ?></th>
                                          <th data-label='Leads Lost Date:'><?php echo $value['created_date']; ?></th>
                                          <td data-label='Leads Cost:'><?php echo $value['grand_total']; ?></td>      
                                    </tr>
                                    <?php

                            $output[] = array(
                            'Customer Name' => !empty($primaryContact)?$primaryContact->first_name.' '.$primaryContact->last_name:'',
                            'Leads Name' => !empty($value['company'])?$value['company']:'',
                            'Leads Lost Reason' =>!empty($value['status_comment'])?htmlspecialchars(trim((strip_tags($value['status_comment'])))):'',
                            'Leads Lost Date' => $value['updated_date'],
                            'Leads Cost' => $value['grand_total']
                             );   

                                    ?>
                                    <?php endforeach; ?>
                             <?php  
                                  $data3  = $output;
                                  export_csv_excel($data3);
                              }
                                  
                             ?>       
                                    <tr>
                                       <td colspan="6">

                                       </td>
                                       <td>
                                     <?php echo $totalsum.".00"; ?>
                                       </td>
                                       </tr>   
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