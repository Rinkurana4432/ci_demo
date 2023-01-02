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
            <form action="<?php echo base_url(); ?>crm/lead_by_qwnership" method="get" id="date_range">
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>
    </div>
</div>
   <div class="stik">
      <div class="col-md-12 export_div">
        
         <div class="btn-group" role="group" aria-label="Basic example">
           <a href="<?php echo base_url(); ?>crm/lead_by_qwnership" class="Reset-btn btn btn-success">
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
            <form action="<?php echo site_url(); ?>crm/lead_by_qwnership" method="get" id="export-form">
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
               <th>Leads Owner</th>
               <th>Leads Status</th>
               <th>Full Name</th>
               <th>Country</th>
               <th>City</th>
               <th>Company</th>
               <th>Email</th>
               <th>Created By</th> 
               <th>Created Date</th>
               <th>Leads Total Cost</th>
            </tr>
         </thead>
            <tbody>
             <?php if(!empty($lead_by_owner)){
             # pre($lead_by_owner);
                           $i = 1;
                            $primaryContact = array();
							
                           foreach($lead_by_owner as $leadsbyowner){

          							     $total = count($leadsbyowner);
          								 $i=1;
                           $totalsum = 0;
								            foreach($leadsbyowner as $owner){
                              if(!empty($owner) && $owner['lead_status'] !='' && $owner['lead_status'] != 0) {  
                                $lead_status = getNameById('lead_status',$owner['lead_status'],'id');
                                $leadStatus = !empty($lead_status)?$lead_status->name:''; 
                              }else { $leadStatus = ''; }
                              if(!empty($owner) && $owner['lead_owner'] !='' && $owner['lead_owner'] != 0) {  
                                $ownername = getNameById('user_detail',$owner['lead_owner'],'u_id');
                                $owner_name = !empty($ownername)?$ownername->name:''; 
                              }else { $owner_name = ''; }
                              // if(!empty($owner) && $owner['lead_source'] !='' && $owner['lead_source'] != 0) {  
                              //   $lead_source = getNameById('lead_source',$sourc['lead_source'],'id');
                              //   $leadSource = !empty($lead_source)?$lead_source->source_name:''; 
                              // }else { $leadSource = ''; }

                              if(!empty($owner) && $owner['city'] !='' && $owner['city'] != 0) {  
                                $leadcity = getNameById('city',$owner['city'],'city_id');
                                $leadscity = !empty($leadcity)?$leadcity->city_name:''; 
                              }else { $leadscity = ''; }
                              if(!empty($owner) && $owner['country'] !='' && $owner['country'] != 0) {  
                                $leadcountry = getNameById('country',$owner['country'],'country_id');
                                $leads_country = !empty($leadcountry)?$leadcountry->country_name:''; 
                              }else { $leads_country = ''; }
                              if(!empty($owner) && $owner['created_by'] !='' && $owner['created_by'] != 0) {  
                                $user = getNameById('user_detail',$owner['created_by'],'u_id');
                                $user_name = !empty($user)?$user->name:''; 
                              }else { $user_name = ''; }
                              $totalsum += floatval($owner['grand_total']);

                  if($owner['contacts'] !=''){
                                $contacts_info = json_decode($owner['contacts']);
                                $primaryContact  = $contacts_info[0];                                           
                  }
                   if(!empty($primaryContact)){ $leadname = $primaryContact->first_name." ".$primaryContact->last_name; }else {$leadname = '';}
                   if(!empty($primaryContact)){ $email =  $primaryContact->email; }else {$email = '';}
                            #pre($owner);
									 ?>
									  <tr>
                      <td> 
                        <?php 
    									   if($i == 1){
    									   echo $owner_name." (".$total.")"; 
    									   }
									      ?>         
                      </td>
                        <td><?php echo $leadStatus;?></td>
                        <td><?php echo $leadname; ?></td>
                        <td><?php echo $leads_country; ?></td>
                        <td><?php echo $leadscity; ?></td>
                        <td><?php echo $owner['company'];?></td>
                        <td><?php echo $email; ?> </td>
                        <td><?php echo $user_name; ?></td>
                        <td><?php echo $owner['created_date']; ?></td>
                        <td><?php echo $owner['grand_total']; #echo $totalsum;?></td>
                    </tr>

                     <?php 
                      $output[] = array(
                        'Leads Owner' => !empty($owner_name)?$owner_name:'',
                        'Leads Status' => !empty($leadStatus)?$leadStatus:'',  
                        'Full Name' => !empty($primaryContact)?$primaryContact->first_name.' '.$primaryContact->last_name:'',
                        'Country' => !empty($leads_country)?$leads_country:'',
                        'City' => !empty($leadscity)?$leadscity:'',
                        'Company' => !empty($owner['company'])?$owner['company']:'',
                        'Email' => !empty($email)?$email:'',
                        'Created By' => !empty($user_name)?$user_name:'',
                        'Created Date' => !empty($owner['created_date'])?$owner['created_date']:'',
                        'Leads total Cost' => !empty($owner['grand_total'])?$owner['grand_total']:'',
                      );   
                    ?>


								<?php $i++; } ?>
                <tr>
               <td colspan="8">
               </td>
               <td>
                 <?php echo $totalsum.".00"; ?>
               </td>
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
   