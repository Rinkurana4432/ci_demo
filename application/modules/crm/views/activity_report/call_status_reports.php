

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
            <form action="<?php echo base_url(); ?>crm/call_status_reports" method="get" id="date_range">
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>
    </div>
</div>
<style>
#print_div_content {
  overflow: scroll;
  height: 700px;
}
</style>

   <div class="stik">
      <div class="col-md-12 export_div">
        
         <div class="btn-group" role="group" aria-label="Basic example">

          <a href="<?php echo base_url(); ?>crm/call_status_reports" class="Reset-btn btn btn-success">
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
            <form action="<?php echo site_url(); ?>crm/call_status_reports" method="get" id="export-form">
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
               <th>Lead Name</th>
               <th>Phone</th>
               <th>Subject</th>
               <th>Comments</th>
               <th>Created By</th>
               <th>Created Date</th>
            </tr>
         </thead>
            <tbody>
             <?php if(!empty($lead_frm_activity)){
							#pre($lead_frm_activity);
                           #foreach($lead_frm_activity as $leadsbyowner){

          							    # $total = count($leadsbyowner);
          								 $i=1;
                           $totalsum = 0;
								            foreach($lead_frm_activity as $owner){
                             
                              #pre
                  
                  $leads_info = getNameById('leads',$owner['lead_id'],'id');

                  #pre($leads_info);        
                  if(!empty($leads_info->contacts) && $leads_info->contacts !=''){
                    $contacts_info = json_decode($leads_info->contacts);
                    $primaryContact  = $contacts_info[0];                                           
                  }
                   if(!empty($primaryContact)){ $leadname = $primaryContact->first_name." ".$primaryContact->last_name; }else {$leadname = '';}

                    if(!empty($owner) && $owner['created_by'] !='' && $owner['created_by'] != 0) {  
                                $user = getNameById('user_detail',$owner['created_by'],'u_id');
                                $user_name = !empty($user)?$user->name:''; 
                                $contact_no = !empty($user)?$user->contact_no:''; 
                              }else { $user_name = $contact_no = ''; }
                          if(!empty($owner) && $owner['assigned_to'] !='' && $owner['assigned_to'] != 0) {  
                                $ownername1 = getNameById('user_detail',$owner['assigned_to'],'u_id');
                                #pre($ownername1);
                                $owner_name1 = !empty($ownername1)?$ownername1->name:''; 
                              }else { $owner_name1 = ''; }
									 ?>

									  <tr>
                      <!--<td> 
                        <?php 
    									   #if($i == 1){
    									   //echo $owner_name1;#" (".$total.")"; 
    									   #}
									      ?>         
                      </td>-->
                        <td><?php echo $leadname; ?></td>
                        <td><?php echo $contact_no; ?></td>
                       <td><?php echo $owner['subject']; ?></td>
                        <td width="30%"><?php echo $owner['comment']; ?></td>
                        <td><?php echo $user_name; ?></td>
                        <td><?php echo $owner['created_date']; ?></td>
                    </tr>
                    <?php 
                      $output[] = array(
                        'Call Owner' => !empty($owner_name1)?$owner_name1:'',
                        'Lead Name' => !empty($leadname)?$leadname:'',
                        'Due Date' => !empty($owner['due_date'])?$owner['due_date']:'',
                        'Comments' => !empty($owner['comment'])?$owner['comment']:'',
                        'Created By' => !empty($user_name)?$user_name:'',
                      );   
                    ?>
								<?php $i++; #} ?>
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
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">??</span>
        </button>
        <h4 class="modal-title nxt_cls" id="myModalLabel">Lead</h4>
      </div>
      <div class="modal-body-content"></div>
    </div>
  </div>
</div>         
   
   