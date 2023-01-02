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
            <form action="<?php echo base_url(); ?>crm/lead_by_source" method="get" id="date_range">
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>
    </div>
</div>
   <div class="stik">
      <div class="col-md-12 export_div">
        
         <div class="btn-group" role="group" aria-label="Basic example">
          <a href="<?php echo base_url(); ?>crm/lead_by_source" class="Reset-btn btn btn-success">
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
            <form action="<?php echo site_url(); ?>crm/lead_by_source" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType' />
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>

      </div>
   </div> 
                                 <!-- <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset" ></a> -->

  
   <div class="x_content">
   <!--  <input type="button" onclick="<?php echo base_url(); ?>purchase/purchase_indent" value="Reset" /> -->
    <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm print_clsss" id="bbtn">Print</button>
     <div id="print_div_content">
      <table id="attendance123" class="table table-striped table-bordered account_index" cellspacing="0" width="100%">
         <thead>
            <tr>
               <th>Leads Source</th>
               <th>Lead Owner</th>
               <th>Leads Status</th>
               <th>Full Name</th>
               <th>Country</th>
               <th>City</th>
               <th>Company</th>
               <th>Email</th>
               <th>Created By</th> 
               <th>Created Date</th>
               <th>Leads Total Cost</th>
			   <th>Action</th>
            </tr>
         </thead>
            <tbody>
             <?php if(!empty($lead_by_source)){
                           $i = 1;
                            $primaryContact = array();
							
                           foreach($lead_by_source as $leadsbysource){
          							     $total = count($leadsbysource);
          								 $i=1;
                           $totalsum = 0;
							foreach($leadsbysource as $sourc){
							
                              if(!empty($sourc) && $sourc['lead_status'] !='' && $sourc['lead_status'] != 0) {  
                                $lead_status = getNameById('lead_status',$sourc['lead_status'],'id');
                                $leadStatus = !empty($lead_status)?$lead_status->name:''; 
                              }else { $leadStatus = ''; }
                              if(!empty($sourc) && $sourc['lead_source'] !='' && $sourc['lead_source'] != 0) {  
                                $lead_source = getNameById('add_lead_source',$sourc['lead_source'],'id');
                                $leadSource = !empty($lead_source)?$lead_source->leads_source_name:''; 
                              }else { $leadSource = ''; }
                              if(!empty($sourc) && $sourc['city'] !='' && $sourc['city'] != 0) {  
                                $leadcity = getNameById('city',$sourc['city'],'city_id');
                                $leadscity = !empty($leadcity)?$leadcity->city_name:''; 
                              }else { $leadscity = ''; }
                              if(!empty($sourc) && $sourc['country'] !='' && $sourc['country'] != 0) {  
                                $leadcountry = getNameById('country',$sourc['country'],'country_id');
                                $leads_country = !empty($leadcountry)?$leadcountry->country_name:''; 
                              }else { $leads_country = ''; }
                              if(!empty($sourc) && $sourc['created_by'] !='' && $sourc['created_by'] != 0) {  
                                $user = getNameById('user_detail',$sourc['created_by'],'u_id');
                                $user_name = !empty($user)?$user->name:''; 
                              }if(!empty($sourc) && $sourc['lead_owner'] !='' && $sourc['lead_owner'] != 0) {  
                                $leadowner = getNameById('user_detail',$sourc['lead_owner'],'u_id');
                                $leadowner_name = !empty($leadowner)?$leadowner->name:''; 
                              }else { $user_name = ''; }
                              $totalsum += floatval($sourc['grand_total']);

                  if($sourc['contacts'] !=''){
                                $contacts_info = json_decode($sourc['contacts']);
                                $primaryContact  = $contacts_info[0];                                           
                  }
                   if(!empty($primaryContact)){ $leadname = $primaryContact->first_name." ".$primaryContact->last_name; }else {$leadname = '';}
                   if(!empty($primaryContact)){ $email =  $primaryContact->email; }else {$email = '';}
                            #pre($sourc);
					if($can_edit) { 
					   $action =  '<a href="javascript:void(0)" id="'. $sourc["id"] . '" data-id="lead" data-tooltip="Edit" class="add_crm_tabs btn btn-edit  btn-xs  id="' . $sourc["id"] . '" ><i class="fa fa-pencil"></i> </a>';
					}			
							
							
	 ?>
									  <tr>
                      <td> 
                        <?php 
    									   if($i == 1){
    									   echo $leadSource." (".$total.")"; 
    									   }
									      ?>         
                      </td>
                        <td><?php echo $leadowner_name;?></td>
                        <td><?php echo $leadStatus;?></td>
                        <td><?php echo $leadname; ?></td>
                        <td><?php echo $leads_country; ?></td>
                        <td><?php echo $leadscity; ?></td>
                        <td><?php echo $sourc['company']?></td>
                        <td><?php echo $email; ?> </td>
                        <td><?php echo $user_name; ?></td>
                        <td><?php echo $sourc['created_date']; #echo $totalsum;?></td>
                        <td><?php echo $sourc['grand_total']; #echo $totalsum;?></td>
                        <td><?php echo $action;?></td>
                    </tr>
                    <?php 
                      $output[] = array(
                        'Leads Source' => !empty($leadSource)?$leadSource:'',
                        'Leads Status' => !empty($leadStatus)?$leadStatus:'',  
                        'Full Name' => !empty($primaryContact)?$primaryContact->first_name.' '.$primaryContact->last_name:'',
                        'Country' => !empty($leads_country)?$leads_country:'',
                        'City' => !empty($leadscity)?$leadscity:'',
                        'Company' => !empty($sourc['company'])?$sourc['company']:'',
                        'Email' => !empty($email)?$email:'',
                        'Created By' => !empty($user_name)?$user_name:'',
                        'Created Date' => !empty($sourc['created_date'])?$sourc['created_date']:'',
                        'Leads total Cost' => !empty($sourc['grand_total'])?$sourc['grand_total']:'',
                      );   
                    ?>
								<?php $i++; } ?>
                <tr>
               <td colspan="9">
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