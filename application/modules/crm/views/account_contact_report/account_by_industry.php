
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
            <form action="<?php echo base_url(); ?>crm/account_by_industry" method="get" id="date_range">
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>
    </div>
</div>
   <div class="stik">
      <div class="col-md-12 export_div">
        
         <div class="btn-group" role="group" aria-label="Basic example">
          <a href="<?php echo base_url(); ?>crm/account_by_industry" class="Reset-btn btn btn-success">
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
            <form action="<?php echo site_url(); ?>crm/account_by_industry" method="get" id="export-form">
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
               <th>Industry</th>
               <th>Account Name</th>
               <th>Full Name</th>
               <th>Phone</th>
               <th>Email</th>
               <th>Mailing Street</th>
               <th>mailing City</th>
               <th>Mailing State</th>
               <th>Mailing Country</th>
               <th>Mailing Zip</th>
               <th>Created by</th>
               <th>Created Date</th>
          </tr>
         </thead>
            <tbody>
            <?php if(!empty($contactsgrp)){
             # pre($contactsgrp);
                           foreach($contactsgrp as $contactsgrps){
            							   $total = count($contactsgrps);
            								 $i=1;
                             $totalsum = 0;
								            foreach($contactsgrps as $contactsgrps11){
                              if(!empty($contactsgrps11) && $contactsgrps11['industry'] !='' && $contactsgrps11['industry'] != 0){
                                $inds = getNameById('add_industry',$contactsgrps11['industry'],'id');
                                $indsss = !empty($inds)?$inds->industry_detl:''; 
                              }else { $indsss = ''; }


                              if(!empty($contactsgrps11) && $contactsgrps11['created_by'] !='' && $contactsgrps11['created_by'] != 0){
                                $user = getNameById('user_detail',$contactsgrps11['created_by'],'u_id');
                                $user_name = !empty($user)?$user->name:''; 
                              }else { $user_name = ''; }

                              if(!empty($contactsgrps11) && $contactsgrps11['account_owner'] !='' && $contactsgrps11['account_owner'] != 0){
                                $aownername = getNameById('account',$contactsgrps11['account_owner'],'account_owner');
                               # pre($aownername);
                                $aowner_name = !empty($aownername)?$aownername->name:''; 
                                $awner_phone = !empty($aownername)?$aownername->phone:'';
                              }else{ $aowner_name = '';  $awner_phone = '';}

                              if(!empty($contactsgrps11) && $contactsgrps11['billing_city'] !='' && $contactsgrps11['billing_city'] != 0){
                                $city = getNameById('city',$contactsgrps11['billing_city'],'city_id');
                              #  pre($ownername);
                                $city_name = !empty($city)?$city->city_name:''; 
                              }else{ $city_name = '';}

                              if(!empty($contactsgrps11) && $contactsgrps11['billing_state'] !='' && $contactsgrps11['billing_state'] != 0){
                                $state = getNameById('state',$contactsgrps11['billing_state'],'state_id');
                              #  pre($ownername);
                                $state_name = !empty($state)?$state->state_name:''; 
                              }else{ $state_name = '';}

                              if(!empty($contactsgrps11) && $contactsgrps11['billing_country'] !='' && $contactsgrps11['billing_country'] != 0){
                                $country = getNameById('country',$contactsgrps11['billing_country'],'country_id');
                              #  pre($ownername);
                                $country_name = !empty($country)?$country->country_name:''; 
                              }else{ $country_name = '';}
						?>
									  <tr>
                        <td> 
                          <?php 
      									   if($i == 1){
      									   echo $indsss." (".$total.")"; 
      									   }
  									      ?>         
                        </td>
                        <td><?php echo $aowner_name; ?></td>
                        <td><?php echo $contactsgrps11['name'];?></td>
                        <td><?php echo $contactsgrps11['phone']; ?></td>
                        <td><?php echo $contactsgrps11['email']; ?></td>
                        <td><?php echo $contactsgrps11['billing_street']; ?></td>
                        <td><?php echo $city_name; ?></td>
                        <td><?php echo $state_name; ?></td>
                        <td><?php echo $country_name; ?></td>
                        <td><?php echo $contactsgrps11['billing_zipcode']; ?></td>
                        <td><?php echo $user_name;?></td>
                        <td><?php echo date("j F , Y", strtotime($contactsgrps11['created_date']));?></td>
                    </tr>
                    <?php 
                      $output[] = array(
                        'Industry' => !empty($indsss)?$indsss:'',
                        'Account Name' => !empty($aowner_name)?$aowner_name:'',  
                        'Full Name' => !empty($contactsgrps11['name'])?$contactsgrps11['name']:'',
                        'Phone No.' => !empty($contactsgrps11['phone'])?$contactsgrps11['phone']:'',
                        'Email' => !empty($contactsgrps11['email'])?$contactsgrps11['email']:'',
                        'Mailing Street' => !empty($contactsgrps11['billing_street'])?$contactsgrps11['billing_street']:'',
                        'Mailing City' => !empty($city_name)?$city_name:'',
                        'Mailing State' => !empty($state_name)?$state_name:'',
                        'Mailing Country' => !empty($country_name)?$country_name:'',
                        'Mailing Zip' => !empty($contactsgrps11['billing_zipcode'])?$contactsgrps11['billing_zipcode']:'',
                        'Created By' => !empty($user_name)?$user_name:'',
                        'Created Date' => !empty($contactsgrps11['created_date'])?$contactsgrps11['created_date']:'',
                      );   
                    ?>
								<?php $i++; } ?>
                <tr>
               </tr>   
						  <?php }
              $data3  = $output;
                export_csv_excel($data3);
               ?>
             <?php  } #else{?>
              <!-- <tr>
                <td colspan="12" style="text-align: center;">No Data Available</td>
               </tr>  -->

             <?php #}?>
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