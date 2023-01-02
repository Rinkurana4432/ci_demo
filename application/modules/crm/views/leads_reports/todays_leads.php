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
            <form action="<?php echo base_url(); ?>crm/todays_lead" method="get" id="date_range">
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>
    </div>
</div>
   <div class="stik">
      <div class="col-md-12 export_div">
        
         <div class="btn-group" role="group" aria-label="Basic example">
          <a href="<?php echo base_url(); ?>crm/todays_lead" class="Reset-btn btn btn-success">
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
            <form action="<?php echo site_url(); ?>crm/todays_lead" method="get" id="export-form">
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
               <th>SNo.</th>
               <th>Leads Date</th>
               <th>Leads Source</th>
               <th>Leads Status</th>
               <th>Leads Total Cost</th>
               <th>Full Name</th>
               <th>Country</th>
               <th>City</th>
               <th>Company</th>
               <th>Email</th>
               <th>Created By</th> 
            </tr>
         </thead>
            <tbody>
             <?php if(!empty($todays_leads)){
              #pre($todays_leads);
                           $i = 1;
                            $primaryContact = array();
                           foreach($todays_leads as $todaysleads){
                              if(!empty($todaysleads) && $todaysleads['lead_status'] !='' && $todaysleads['lead_status'] != 0) {  
                                $lead_status = getNameById('lead_status',$todaysleads['lead_status'],'id');
                                $leadStatus = !empty($lead_status)?$lead_status->name:''; 
                              }else { $leadStatus = ''; }
                              if(!empty($todaysleads) && $todaysleads['lead_source'] !='' && $todaysleads['lead_source'] != 0) {  
                                $lead_source = getNameById('add_lead_source',$todaysleads['lead_source'],'id');
                                $leadSource = !empty($lead_source)?$lead_source->leads_source_name:''; 
                              }else { $leadSource = ''; }
                              if(!empty($todaysleads) && $todaysleads['city'] !='' && $todaysleads['city'] != 0) {  
                                $leadcity = getNameById('city',$todaysleads['city'],'city_id');
                                $leadscity = !empty($leadcity)?$leadcity->city_name:''; 
                              }else { $leadscity = ''; }
                              if(!empty($todaysleads) && $todaysleads['country'] !='' && $todaysleads['country'] != 0) {  
                                $leadcountry = getNameById('country',$todaysleads['country'],'country_id');
                                $leads_country = !empty($leadcountry)?$leadcountry->country_name:''; 
                              }else { $leads_country = ''; }
                              if(!empty($todaysleads) && $todaysleads['created_by'] !='' && $todaysleads['created_by'] != 0) {  
                                $user = getNameById('user_detail',$todaysleads['created_by'],'u_id');
                                $user_name = !empty($user)?$user->name:''; 
                              }else { $user_name = ''; }

                                if($todaysleads['contacts'] !=''){
                                              $contacts_info = json_decode($todaysleads['contacts']);
                                              $primaryContact  = $contacts_info[0];                                           
                                }
                   if(!empty($primaryContact)){ $leadname = $primaryContact->first_name." ".$primaryContact->last_name; }else {$leadname = '';}
                   if(!empty($primaryContact)){ $email =  $primaryContact->email; }else {$email = '';}
            ?>
               <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo date("j F , Y", strtotime($todaysleads['created_date']))?></td>
                  <td><?php echo $leadSource; ?></td>
                  <td><?php echo $leadStatus;?></td>
                  <td><?php echo $todaysleads['grand_total']; ?></td>
                  <td><?php echo $leadname; ?></td>
                  <td><?php echo $leads_country; ?></td>
                  <td><?php echo $leadscity; ?></td>
                  <td><?php echo $todaysleads['company']?></td>
                  <td><?php echo $email; ?> </td>
                  <td><?php echo $user_name; ?></td>  
               </tr>
               <?php 
                      $output[] = array(     
                        'Leads Date' => !empty($todaysleads['created_date'])?$todaysleads['created_date']:'',  
                        'Leads Source' => !empty($leadSource)?$leadSource:'',
                        'Leads Status' => !empty($leadStatus)?$leadStatus:'',
                        'Leads Total Cost' => !empty($todaysleads['grand_total'])?$todaysleads['grand_total']:'',
                        'Full Name' => !empty($primaryContact)?$primaryContact->first_name.' '.$primaryContact->last_name:'',
                        'Country' => !empty($leads_country)?$leads_country:'',
                        'City' => !empty($leadscity)?$leadscity:'',
                        'Company' => !empty($todaysleads['company'])?$todaysleads['company']:'',
                        'Email' => !empty($email)?$email:'',
                        'Created By' => !empty($user_name)?$user_name:'',
                      );   
                ?>
             <?php  } 
              $data3  = $output;
                export_csv_excel($data3);
           }?>
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
   