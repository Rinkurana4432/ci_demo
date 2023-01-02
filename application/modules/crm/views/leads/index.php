
<div class="x_content">
   <?php if($this->session->flashdata('message') != ''){
      echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
      }?>
   <div class="leadBasicData">
      <div class="alert alert-info" style="display:none;">Lead status changed successfully</div>
   </div>
    
	<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2"> 
	        <form class="form-search" method="get" action="<?= base_url() ?>crm/leads">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter id,Name,Company" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="crm/leads?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>">
         <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab'];?>"/>
         <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span> Search
         </button>
         <a href="<?php echo base_url(); ?>crm/leads?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>">
         <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset">
         </a>
         </span>
      </div>
   </div>
</form>
  <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button> 
  <div id="demo" class="collapse">
     <div class="col-md-12 datePick-left">
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
            <form action="<?php echo base_url(); ?>crm/leads" method="get" id="date_range">
               <input type="hidden" value='<?php if(!empty($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(!empty($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end' />
               <input type="hidden" value='<?php if(!empty($_GET['tab']))echo $_GET['tab'];?>'  name='tab' />
            </form>
         </div>
   </div>
	  </div>
	</div>
   
   <div class="stik">
      <div class="col-md-12 export_div">
         
         <div class="btn-group" role="group" aria-label="Basic example">
		   <?php if($can_add) {
               //echo '<a href="'.base_url().'crm/edit_lead/"><button type="buttton" class="btn btn-info">Add</button></a>'; 
               echo '<button type="button" class="btn btn-success addBtn add_crm_tabs" data-toggle="modal" id="add" data-id="lead"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
               } ?>
			   <select class="form-control" id="lead_status_filter" width="100%" tabindex="-1" aria-hidden="true" style="width: 130px;float: right;height: auto;">               
			  <?php         
				 echo '<option value="">All</option>';              
				 foreach($leadStatus as $ls){
						echo '<option value="'.$ls['id'].'">'.$ls['name'].'</option>';                  
				 }              
				 ?>
			  </select>
			   <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <ul class="dropdown-menu import-bar" role="menu" id="export-menu">
                  <form action="<?php echo base_url(); ?>crm/importLeads" method="post" enctype="multipart/form-data">
                     <input type="file" class="form-control col-md-2" name="uploadFile" id="file" style="width: 70%">
                     <input type="submit" class="form-control col-md-2" name="importe" value="Import" style="width: 30%" />
                  </form>
               </ul>
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Import<span class="caret"></span></button>
            </div>
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
			   
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown" aria-expanded="false">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                  <li id="export-to-blank-excel"><a href="<?php echo base_url()?>/assets/modules/crm/downloads/importexcel.xls" title="Please check your open office Setting" download>Export to Blank Excel</a></li>
               </ul>
            </div>
            <form action="<?php echo base_url(); ?>crm/leads" method="get" style="display: inline-block;">
               <input type="hidden" value='1' name='favourites' />
               <input type="hidden" value='<?php if(!empty($_GET[' start '])){echo $_GET['start '];}?>' class='start' name='start' />
               <input type="hidden" value='<?php if(!empty($_GET[' end '])){echo $_GET['end '];} ?>' class='end' name='end' />
               <input type="hidden" value='<?php if(!empty($_GET['tab']))echo $_GET['tab'];?>'  name='tab' />
               <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
            </form>
            <!--<button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>-->
           
            <!--<select  class="form-control" id="staus" tabindex="-1" aria-hidden="true">
               <option value="">Change Status</option>
               <option value="1">New</option>
               <option value="2">Contacted</option>
               <option value="3">Qualified</option>
               <option value="4">Unqualified</option>
               <option value="5">Win</option>
               <option value="6">Loose</option>
            </select>-->
         </div>
         <div class="col-md-4 col-sm-12 datePick-right">
            
            <form action="<?php echo site_url(); ?>crm/leads?tab=<?php if(!empty($_GET['tab']))echo $_GET['tab'];?>" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType' />
               <input type="hidden" value='<?php if(!empty($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(!empty($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end' />
               <input type="hidden" value='<?php if(!empty($_GET['favourites']))echo $_GET['favourites'];?>' name='favourites' />
               <input type="hidden" value='<?php if(!empty($_GET['search']))echo $_GET['search'];?>'  name='search' />
               <input type="hidden" value='<?php if(!empty($_GET['tab']))echo $_GET['tab'];?>'  name='tab' />
            </form>
         </div>
      </div>
   </div>
   
   <?php if(!empty($leads) && $can_view){ ?>
   <div class="col-md-6 col-sm-6 col-xs-12">
      Filter By Lead Owner
      <select class="form-control" id="lead_owner_filter" width="100%" tabindex="-1" aria-hidden="true">
      <?php 
         echo '<option value="">All</option>';                  
         foreach($lead_owner as $lo){
                echo '<option value="'.$lo['id'].'">'.$lo['name'].'</option>';                  
         }
         ?>
      </select>
   </div>
   <?php } ?>
   <p class="text-muted font-13 m-b-30"></p>
   <?php if(!empty($leads)){ ?>
   <div class="row hidde_cls">
      <div class="col-md-12">
         <div class="col-md-4">
         </div>
         <div class="col-md-4">
            <!--<div class="btn-group" role="group" aria-label="Basic example">-->
            <!--   <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>-->
            <!--   <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>-->
            <!--   <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">-->
            <!--      <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>-->
            <!--      <ul class="dropdown-menu" role="menu" id="export-menu">-->
            <!--         <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>-->
            <!--         <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>-->
            <!--         <li id="export-to-blank-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to Blank Excel</a></li>-->
            <!--      </ul>-->
            <!--   </div>-->
            <!--</div>-->
         </div>
      </div>
   </div>
   <?php } ?>
   <div class="x_content">
      <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>crm/leads">
         <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
      </form>
      <div class="" role="tabpanel" data-example-id="togglable-tabs">
         <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class="active"><a href="#new_leads" role="tab" id="new_lead_tab" data-toggle="tab" aria-expanded="false" onClick="inProcess2_leads();">In Process Leads</a></li>
            <li role="presentation" class=""><a href="#leads" id="lead_tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="complete2_leads();">Complete Leads</a></li>
            <li role="presentation" class=""><a href="#auto_leads" role="tab" id="auto_lead_tab" data-toggle="tab" aria-expanded="false" onClick="auto2_leads();">Auto leads</a></li>
            <!--li role="presentation" class=""><a href="#bid_mang_leads" role="tab" id="bid" data-toggle="tab" aria-expanded="false" onClick="bidmgm2_leads();">Bid Management Leads</a></li-->
         </ul>
         <div id="myTabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane fade active in" id="new_leads" aria-labelledby="new_lead_tab">
               <div id="print_div_content">
                  <form id="inprocess_lead_frm">    <input type="hidden" value="inProcess_leads" name="tab">    </form>
                  <?php /* <table id="datatable-buttons" class="table table-striped table-bordered user_index table-responsive" data-id="user" style="width:100%" border="1" cellpadding="3"> */ ?>
                  <table id="datatable-buttonschk" class="table table-striped table-bordered user_index table-responsive sdsd" data-id="user" style="width:100%" border="1" cellpadding="3">
                     <thead>
                        <tr>
                           <th></th>
                           <th scope="col">Id<span><a href="<?php echo base_url(); ?>crm/leads?tab=inProcess_leads&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>crm/leads?tab=inProcess_leads&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Company<span><a href="<?php echo base_url(); ?>crm/leads?sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>crm/leads?tab=inProcess_leads&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Name<span><a href="<?php echo base_url(); ?>crm/leads?tab=inProcess_leads&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>crm/leads?tab=inProcess_leads&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Email<span><a href="<?php echo base_url(); ?>crm/leads?tab=inProcess_leads&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>crm/leads?tab=inProcess_leads&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Phone No.</th>
                           <th scope="col">Lead Industry</th>
                           <th scope="col">Lead Owner</th>

                           <th scope="col">Lead Head / Created By </th>
                           <th scope="col">Lead Status</th>
                           <th scope="col">Status Comment</th>
                           <th scope="col" class='hidde'>Created Date</th>
                           <th scope="col" class='hidde'>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
						
						if(!empty($in_process_leads)){
                         # pre($in_process_leads);
                           foreach($in_process_leads as $in_process_lead){
                            $primaryContact = array();
                            if(!empty($in_process_lead) && $in_process_lead['lead_status'] !='' && $in_process_lead['lead_status'] != 0) {  
                                $lead_status = getNameById('lead_status',$in_process_lead['lead_status'],'id');
                                $leadStatus = !empty($lead_status)?$lead_status->name:''; 
                            }else { $leadStatus = ''; }
                            if($in_process_lead['contacts'] !=''){
                                $contacts_info = json_decode($in_process_lead['contacts']);
                                $primaryContact  = $contacts_info[0];                                           
                            }
                            if($in_process_lead['lead_industry'] !=''){
                              $lead_inds = getNameById('add_industry',$in_process_lead['lead_industry'],'id');
                                $leadinds = !empty($lead_inds)?$lead_inds->industry_detl:''; 
                            }
                            $action = '';
                            if($can_edit) { 
                                //$action = $action.'<a href="'.base_url().'crm/edit_lead/'.$in_process_lead["id"].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>';      
                                $convertedLeadDisabled = ($in_process_lead['converted_to_account'] == 1 || $in_process_lead['converted_to_contact'] == 1)?'disableBtnClick':'';
                                $convertedLeadDisableEdit = ($in_process_lead['converted_to_account'] == 1 || $in_process_lead['converted_to_contact'] == 1)?'disabled':'';
                                $action =  '<a href="javascript:void(0)" id="'. $in_process_lead["id"] . '" data-id="lead" data-tooltip="Edit" class="add_crm_tabs btn btn-edit  btn-xs '.$convertedLeadDisabled.'" id="' . $in_process_lead["id"] . '" '.$convertedLeadDisableEdit.'><i class="fa fa-pencil"></i> </a>';
                            }
                           #    if($can_view) {
                                $action .=  '<a href="javascript:void(0)" id="'. $in_process_lead["id"] . '" data-id="lead_view"  data-tooltip="View" class="add_crm_tabs btn btn-view  btn-xs" id="' . $in_process_lead["id"] . '"><i class="fa fa-eye"></i> </a>';
                           #    }
                           
                                if($can_delete) { 
                                $action = $action.'<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'crm/deleteLead/'.$in_process_lead["id"].'"><i class="fa fa-trash"></i></a>';
                            }
                           
                                $action .='';
                            #echo $in_process_lead['favourite_sts'];
                                    if($in_process_lead['favourite_sts'] == '1'){
                                        $rr = 'checked';
                                    }else{
                                    $rr = '';
                                }
                           
                            $convertedLeadColor = ($in_process_lead['converted_to_account'] == 1 || $in_process_lead['converted_to_contact'] == 1)?'#de1a1a30':'';
                            $draftImage = '';
                            if($in_process_lead['save_status'] == 0)
                                $draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft">
                                <img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';
                           
                                                              if(date('Y-m-d') > $in_process_lead['end_date']){
                           
                                                              $tyu = "tyu";
                           
                                                              }
                                                              else
                                                              {
                                                                  $tyu = "axsxsx";
                                                              }
															//  <input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox' data-ai=".$in_process_lead['id']."  value=".$in_process_lead['id']."  data-status=".$in_process_lead['lead_status'].">
                                   echo "<tr>
                                   <td>";
                                        if($in_process_lead['favourite_sts'] == '1'){
                                                echo "<input class='star' type='checkbox'  title='Mark Record' value=".$in_process_lead['id']."  checked = 'checked'><br/>";
                                                echo"<input type='hidden' value='leads' id='favr' data-msg='Leads ' data-path='crm/leads' favour-sts='0' id-recd=".$in_process_lead['id'].">";
                                        }else{
                                                echo "<input class='star' type='checkbox'  title='Mark Record' value=".$in_process_lead['id']."><br/>";
                                                echo"<input type='hidden' value='leads' id='favr' data-msg='Leads ' data-path='crm/leads' favour-sts='1' id-recd =".$in_process_lead['id'].">";
                                        }
                                        
                                        echo "</td>
                                        <td data-label='Id:'>".$draftImage . $in_process_lead['id']."</td>
                                        <td data-label='Company:'>".$in_process_lead['company']."</td>
                                        <td data-label='Name:'>";
                                        if(!empty($primaryContact)){ echo $primaryContact->first_name." ".$primaryContact->last_name; }else {echo '';}
                                        echo "</td>
                                        <td data-label='Email:'>";
                                        if(!empty($primaryContact)){ echo $primaryContact->email; }else {echo '';}
                                        echo "</td>
                                        <td data-label='Phone no:'>";
                                        if(!empty($primaryContact)){ echo $primaryContact->phone_no; }else{echo '';}
                                        echo "</td>
                                        <td data-label='Industry:'>";
                                        if(!empty($leadinds)){ echo $leadinds; }else{echo '';}
                                        echo "</td>
                                        <td data-label='Lead Owner:'>".$in_process_lead['leadOwnerName']."</td>
                                        <td data-label='Lead Head / Created By :'>".$in_process_lead['createdByName']."</td>
                                        <td data-label='Lead Status :'>".$leadStatus."</td>    
                                        <td data-label='Status Comment:'>".$in_process_lead['status_comment']."</td> 
                                        <td data-label='Created Date:' class='hidde'>".date("j F , Y", strtotime($in_process_lead['created_date']))."</td> 
                                        <td data-label='action:' class='hidde'>".$action. "</td> 
                                    </tr>";
                           $output[] = array(
                            'Company' => $in_process_lead['company'],
                            'Name' => !empty($primaryContact)?$primaryContact->first_name.' '.$primaryContact->last_name:'',
                            'Email' => !empty($primaryContact)?$primaryContact->email:'',
                            'Phone No.' => !empty($primaryContact)?$primaryContact->phone_no:'',
                            'Leads Industry' =>!empty($leadinds)?$leadinds:'',
                            'Lead Owner' => $in_process_lead['leadOwnerName'],
                            'Created By' => $in_process_lead['createdByName'],
                            'Lead Status' => $leadStatus,
                            'Lead Commnets' => $in_process_lead['status_comment'],
                            'Created Date' => date("d-m-Y", strtotime($in_process_lead['created_date'])),
                           );   
                           }
                                $data3  = $output;
                                export_csv_excel($data3);
                           }
                           ?>
                     </tbody>
                  </table>
                  <?php echo $this->pagination->create_links();   //echo $showPage1; 
                     //echo $paginglinks1; ?>
               </div>
            </div>
            <input type="hidden" name="rating" id="hidden_rating" class="form-control col-md-7 col-xs-12" placeholder="Rating" value="">
            <!-------------------tab leads------------------------------->
            <div role="tabpanel" class="tab-pane fade" id="leads" aria-labelledby="lead_tab">
               <div id="print_div_content">
                  <?php /*  <table id="datatable-buttons1" class="table table-striped table-bordered user_index table-responsive" data-id="user" style="width:100%" border="1" cellpadding="3"> */ ?>
                  <form id="complete_lead_frm"> <input type="hidden" value="complete_leadss" name="tab">    </form>
                  <table id="compleetleed" class="table table-striped table-bordered user_index table-responsive" data-id="user" style="width:100%" border="1" cellpadding="3">
                     <thead>
                        <tr>
                           <th></th>
                           <th scope="col">Id
                              <span><a href="<?php echo base_url(); ?>crm/leads?tab=complete_leadss&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>crm/leads?tab=complete_leadss&sort=desc" class="down"></a></span>
                           </th>
                           <?php
                              /*foreach($sort_cols as $field_name => $field_display){ ?>
                           <th>
                              <?php echo anchor('crm/leads/'.$field_name.'/'.($sort_by == $field_name ? $sort_order : 'asc').'/'.$page2, $field_display); ?>
                           </th>
                           <?php }*/?>
                           <th scope="col">Company
                              <span><a href="<?php echo base_url(); ?>crm/leads?tab=complete_leadss&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>crm/leads?tab=complete_leadss&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Name
                              <span><a href="<?php echo base_url(); ?>crm/leads?tab=complete_leadss&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>crm/leads?tab=complete_leadss&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Email
                              <span><a href="<?php echo base_url(); ?>crm/leads?tab=complete_leadss&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>crm/leads?tab=complete_leadss&sort=desc" class="down"></a></span>
                           </th>

                           <th scope="col">Phone No.</th>
                           <th scope="col">Leads Industry</th>
                           <th scope="col">Lead Owner</th>
                           <th scope="col">Lead Head / Created By </th>
                           <th scope="col">Lead Status</th>
                           <th scope="col">Status Comment</th>
                           <th scope="col" class='hidde'>Created Date</th>
                           <th scope="col" class='hidde'>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(!empty($complete_leads)){
                           foreach($complete_leads as $complete_lead){
                            $primaryContact = array();
                            if(!empty($complete_lead) && $complete_lead['lead_status'] !='' && $complete_lead['lead_status'] != 0) {    
                                $lead_status = getNameById('lead_status',$complete_lead['lead_status'],'id');
                                $leadStatus = $lead_status->name; 
                            }else { $leadStatus = '';  }
                            if($complete_lead['contacts'] !=''){
                                $contacts_info = json_decode($complete_lead['contacts']);
                                $primaryContact  = $contacts_info[0];
                            }
                             if($complete_lead['lead_industry'] !=''){
                              $lead_inds = getNameById('add_industry',$complete_lead['lead_industry'],'id');
                                $leadinds = !empty($lead_inds)?$lead_inds->industry_detl:''; 
                            }
                            $action = '';
                            if($can_edit) { 
                                //$action = $action.'<a href="'.base_url().'crm/edit_lead/'.$complete_lead["id"].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>';        
                                $convertedLeadDisabled = ($complete_lead['converted_to_account'] == 1 || $complete_lead['converted_to_contact'] == 1)?'disableBtnClick':'';
                                $convertedLeadDisableEdit = ($complete_lead['converted_to_account'] == 1 || $complete_lead['converted_to_contact'] == 1)?'disabled':'';
                                $action =  '<a href="javascript:void(0)" id="'. $complete_lead["id"] . '" data-id="lead" data-tooltip="Edit" class="add_crm_tabs btn btn-edit  btn-xs '.$convertedLeadDisabled.'" id="' . $complete_lead["id"] . '" '.$convertedLeadDisableEdit.'><i class="fa fa-pencil"></i> </a>';
                            }
                           #    if($can_view) {
                                $action .=  '<a href="javascript:void(0)" id="'. $complete_lead["id"] . '" data-id="lead_view"  data-tooltip="View" class="add_crm_tabs btn btn-view  btn-xs" id="' . $complete_lead["id"] . '"><i class="fa fa-eye"></i> </a>';
                           #    }
                            if($can_delete) { 
                                $action = $action.'<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'crm/deleteLead/'.$complete_lead["id"].'"><i class="fa fa-trash"></i></a>';
                            }
                           
                           if($complete_lead['lead_status'] =='5')
                           {
                           
                           if($complete_lead['converted_to_quotation'] == '0' ){
                          // $action = $action.'<a href="javascript:void(0)" id="' . $complete_lead["id"] . '" data-id="convertLeads_to_quot" data-tooltip="Convert into Quotation" class="add_crm_tabs btn  btn-view  btn-xs"  id="89"><img src="'.base_url().'/assets/modules/crm/uploads/convert.png"></a>';                   
                           }
                           
                           if($complete_lead['converted_to_proinvc'] == '0' ){
                           //$action = $action.'<a href="javascript:void(0)" id="' . $complete_lead["id"] . '" data-id="lead_to_pi" data-tooltip="Convert into Proforma Invoice" class="add_crm_tabs btn  btn-view  btn-xs"  id="89"><img src="'.base_url().'/assets/modules/crm/uploads/convert.png"></a>';                  
                           }
                           
                           if($complete_lead['converted_to_so'] == '0' ){
                          // $action = $action.'<a href="javascript:void(0)" id="' . $complete_lead["id"] . '" data-id="lead_to_so" data-tooltip="Convert into Sale Order" class="add_crm_tabs btn  btn-view  btn-xs"><img src="'.base_url().'/assets/modules/crm/uploads/convert.png"></a>';                 
                           }
                           
                           
                           }
                          // array('leads.created_by_cid' => $this->companyGroupId, 'leads.lead_status!= ' => 1, 'leads.lead_status != ' => 2, 'leads.lead_status !=' => 3, 'favourite_sts' => 1);
                           
                           //<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox' data-ai=".$complete_lead['id']."  value=".$complete_lead['id'].">
                            $convertedLeadColor = ($complete_lead['converted_to_account'] == 1 || $complete_lead['converted_to_contact'] == 1)?'#de1a1a30':'';
                            $draftImage = '';
                            if($complete_lead['save_status'] == 0)
                                $draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft">
                                <img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';
                                 echo "<tr>                                            
                                        <td>";
                                        if($complete_lead['favourite_sts'] == '1'){
                                                echo "<input class='star' type='checkbox'  title='Mark Record' value=".$complete_lead['id']."  checked = 'checked'><br/>";
                                                echo"<input type='hidden' value='leads' id='favr' data-msg='Leads Unmarked' data-path='crm/leads' favour-sts='0' id-recd=".$complete_lead['id'].">";
                                        }else{
                                                echo "<input class='star' type='checkbox'  title='Mark Record' value=".$complete_lead['id']."><br/>";
                                                echo"<input type='hidden' value='leads' id='favr' data-msg='Leads Marked' data-path='crm/leads' favour-sts='1' id-recd =".$complete_lead['id'].">";
                                        }
                                        
                                        echo "</td>
                                        <td data-label='Id:'>".$draftImage . $complete_lead['id']."</td>
                                        <td data-label='Company:'>".$complete_lead['company']."</td>
                                        <td data-label='Name:'>";
                                        if(!empty($primaryContact)){ echo $primaryContact->first_name." ".$primaryContact->last_name; }else {echo '';}
                                        echo "</td>
                                        <td data-label='email:'>";
                                        if(!empty($primaryContact)){ echo $primaryContact->email; }else {echo '';}
                                        echo "</td>
                                        <td data-label='Phone no:'>";
                                        if(!empty($primaryContact)){ echo $primaryContact->phone_no; }else {echo '';}
                                        echo "</td>
                                        <td data-label='Industry:'>";
                                        if(!empty($leadinds)){ echo $leadinds; }else{echo '';}
                                        echo "</td>
                                        <td data-label='Lead Owner:'>".$complete_lead['leadOwnerName']."</td>
                                        <td data-label='Lead Head / Created By:'>".$complete_lead['createdByName']."</td>
                                        <td data-label='Lead Status:'>".$leadStatus."</td>    
                                        <td data-label='Status Comment:'>".$complete_lead['status_comment']."</td>   
                                        <td data-label='Created Date:' class='hidde'>".date("j F , Y", strtotime($complete_lead['created_date']))."</td>   
                                        <td data-label='action:' class='hidde'>".$action."</td>  
                                    </tr>";
                                    $output[] = array(
                                           'Company' => $complete_lead['company'],
                                           'Name' =>  !empty($primaryContact)?$primaryContact->first_name." ".$primaryContact->last_name:'',
                                           //'Buyer Order No.' => $buyer_order_no,
                                           'Email' =>!empty($primaryContact)?$primaryContact->email:'',
                                           'Phone No' =>!empty($primaryContact)?$primaryContact->phone_no:'',
                                           'Leads Industry' =>!empty($leadinds)?$leadinds:'',
                                           'Lead Owner' => $complete_lead['leadOwnerName'],
                                           'Created By' => $complete_lead['createdByName'],
                                           'Lead Status' => $leadStatus,
                                           'Created Date' => date("d-m-Y", strtotime($complete_lead['created_date'])),
                                        );  
                           }
                                $data3  = $output;
                                export_csv_excel($data3);
                           }
                           ?>
                     </tbody>
                  </table>
                  <?php echo $this->pagination->create_links(); ?>
                  <?php //  echo $showPage2; 
                     //echo $paginglinks2; ?>
               </div>
            </div>
            <!-----------------------auto lead tab--------------------------------------------->
            <div role="tabpanel" class="tab-pane fade" id="auto_leads" aria-labelledby="auto_lead_tab">
               <form id="auto_lead_frm">    <input type="hidden" value="auto_leadss" name="tab">    </form>
               <!---------datatable-buttons--------->
               <table id="" class="table table-striped table-bordered user_index table-responsive" data-id="user" style="width:100%" border="1" cellpadding="3">
                  <thead>
                     <tr>
                        <th>Id
                           <span><a href="<?php echo base_url(); ?>crm/leads?tab=auto_leadss&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>crm/leads?tab=auto_leadss&sort=desc" class="down"></a></span>
                        </th>
                        <th>Name
                           <span><a href="<?php echo base_url(); ?>crm/leads?tab=auto_leadss&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>crm/leads?tab=auto_leadss&sort=desc" class="down"></a></span>
                        </th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Uom</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        if(!empty($auto_leads)){
                            foreach($auto_leads as $autoLead){
                                //pre($autoLead);
                        ?>
                     <tr>
                        <td>
                           <?php echo $autoLead['id'];?>
                        </td>
                        <td>
                           <?php echo $autoLead['contacts'];?>
                        </td>
                        <td>
                           <?php echo $autoLead['email'];?>
                        </td>
                        <td>
                           <?php echo $autoLead['mobile'];?>
                        </td>
                        <td>
                           <?php echo $autoLead['products'];?>
                        </td>
                        <td>
                           <?php echo $autoLead['quantity'];?>
                        </td>
                        <td>
                           <?php echo $autoLead['uom'];?>
                        </td>
                     </tr>
                     <?php 
                        $output[] = array(
										'Id' => $autoLead['id'],
										'Contact' => $autoLead['contacts'],
										'Email' =>$autoLead['email'],
										'Phone No.' =>$autoLead['mobile'],
										'Products' =>$autoLead['products'],
                                    );   
                                           }
                                                $data3  = $output;
                                                export_csv_excel($data3);
                                           } ?>
                  </tbody>
               </table>
               <?php //echo $this->pagination->create_links(); ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="bid_mang_leads" aria-labelledby="bid">
               <form id="bidmgmt_frm">  <input type="hidden" value="bid_mangment" name="tab">   </form>
               <div id="print_div_content">
                  <?php /*  <table id="datatable-buttons1" class="table table-striped table-bordered user_index table-responsive" data-id="user" style="width:100%" border="1" cellpadding="3"> */ ?>
                  <table id="" class="table table-striped table-bordered user_index table-responsive" data-id="user" style="width:100%" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
                     <thead>
                        <tr>
                           <th>All<br><input id="selecctall" type="checkbox"></th>
                           <th scope="col">Id
                              <span><a href="<?php echo base_url(); ?>crm/leads?tab=bid_mangment&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>crm/leads?tab=bid_mangment&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Tender Name
                              <span><a href="<?php echo base_url(); ?>crm/leads?tab=bid_mangment&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>crm/leads?tab=bid_mangment&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Tender Link
                              <span><a href="<?php echo base_url(); ?>crm/leads?sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>crm/leads?tab=bid_mangment&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Issue Date</th>
                           <th scope="col">Bid Clossing Date</th>
                           <th scope="col">EMD Amount</th>
                           <th scope="col">Tender Amount</th>
                           <th scope="col">Tender Status</th>
                           <th scope="col">Status Comment</th>
                           <th scope="col" class='hidde'>Created Date</th>
                           <th scope="col" class='hidde'>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(!empty($register_opportunity)){
                           foreach($register_opportunity as $register_fr_opportunity){
                            $primaryname = array();
                            if(!empty($register_fr_opportunity) && $register_fr_opportunity['tender_status'] !='' && $register_fr_opportunity['tender_status'] != 0) {  
                                $tender_status = getNameById('tender_status',$register_fr_opportunity['tender_status'],'id');
                             if(!empty($tender_status)){ $tenderStatus =  $tender_status->name;}else {$tenderStatus = '';}
                           
                            }
                           
                            if($register_fr_opportunity['tender_detail'] !=''){
                                $contacts_info = json_decode($register_fr_opportunity['tender_detail']);
                                $primaryname     = $contacts_info[0];
                            }
                           
                            $action = '';
                            if($can_edit) { 
                                
                                $action =  '<a href="javascript:void(0)" id="'. $register_fr_opportunity["id"] . '" data-id="register_opportunity_edit" data-tooltip="Edit" class="add_crm_tabs btn btn-edit  btn-xs">
                                <i class="fa fa-pencil"></i> </a>';
                           
                            }
                           #    if($can_view) {
                                $action .=  '<a href="javascript:void(0)" id="'. $register_fr_opportunity["id"] . '" data-id="register_opportunity_view"  data-tooltip="View" class="add_crm_tabs btn btn-view  btn-xs" id="' . $register_fr_opportunity["id"] . '"><i class="fa fa-eye"></i> </a>';
                           #    }
                           
                                if($can_delete) { 
                                $action = $action.'<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'crm/delete_register_opportunity/'.$register_fr_opportunity["id"].'"><i class="fa fa-trash"></i></a>';
                            }
                           
                           
                           
                                $action .='';
                           
                           
                            #echo $in_process_lead['favourite_sts'];
                           
                                    if($register_fr_opportunity['favourite_sts'] == '1'){
                                        $rr = 'checked';
                                    }else{
                                    $rr = '';
                                }
                           
                           
                            $draftImage = '';
                            if($register_fr_opportunity['save_status'] == 0)
                                $draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft">
                                <img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';
                                   echo "<tr>                                              
                                        <td><input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox' data-ai=".$register_fr_opportunity['id']."  value=".$register_fr_opportunity['id'].">";
                                        if($register_fr_opportunity['favourite_sts'] == '1'){
                                                echo "<input class='star' type='checkbox'  title='Mark Record' value=".$register_fr_opportunity['id']."  checked = 'checked'><br/>";
                                                echo"<input type='hidden' value='register_opportunity' id='favr' data-msg='Tenders Unmarked' data-path='bid_management/register_opportunity' favour-sts='0' id-recd=".$register_fr_opportunity['id'].">";
                                        }else{
                                                echo "<input class='star' type='checkbox'  title='Mark Record' value=".$register_fr_opportunity['id']."><br/>";
                                                echo"<input type='hidden' value='register_opportunity' id='favr' data-msg='Register Opurtunity Marked' data-path='bid_management/register_opportunity' favour-sts='1' id-recd =".$register_fr_opportunity['id'].">";
                                        }
                                        
                                        echo "</td>
                                        <td data-label='Id:'>".$draftImage . $register_fr_opportunity['id']."</td>
                                        <td data-label='tender name:'>";
                                        if(!empty($primaryname)){ echo $primaryname->tender_name;}else {echo '';}
                                        echo "</td>
                                        <td data-label='tender link:'>";
                                        if(!empty($primaryname)){ echo $primaryname->tender_link;}else {echo '';}
                                        echo "</td>
                                        
                                        <td data-label='issue date:'>".$register_fr_opportunity['issue_date']."</td>
                                        <td data-label='Bid Clossing Date:'>".$register_fr_opportunity['clossing_date']."</td>
                                        <td data-label='EMD Amount:'>".$register_fr_opportunity['emd_amount']."</td>
                                        <td data-label='Tender Amount:'>".$register_fr_opportunity['tender_amount']."</td>
                                        <td data-label='Tender Status:'>".$register_fr_opportunity['tender_status']."</td>  
                                        <td data-label='Status Comment:'>".$register_fr_opportunity['status_comment']."</td> 
                                        <td data-label='Created Date:' class='hidde'>".date("j F , Y", strtotime($register_fr_opportunity['created_date']))."</td> 
                                        <td data-label='Action:' class='hidde'>".$action. "</td> 
                                    </tr>";
                           
                           if(!empty($primaryname)){
                           $tender_name=$primaryname->tender_name;
                           $tender_link=$primaryname->tender_link;}else {
                           $tender_name='';$tender_link='';}
                                    $output[] = array(
                            'Id' => $register_fr_opportunity['id'],
                            'Tender Name' =>$tender_name,
                            'Tender Link' =>$tender_link,
                            'Issue Date' =>$register_fr_opportunity['issue_date'],
                            'Close Date' =>$register_fr_opportunity['clossing_date'],
                           'Emd Amount' =>$register_fr_opportunity['emd_amount'],
                           'Tender Amount' =>$register_fr_opportunity['tender_amount'],
                           );   
                           }
                                $data3  = $output;
                                export_csv_excel($data3);
                           }
                           
                           ?>
                     </tbody>
                  </table>
                  <?php //  echo $showPage2; 
                     //echo $paginglinks2; ?>
               </div>
            </div>
            <!-----------------------------end tab------------------------------------>
         </div>
      </div>
      <?php //echo $this->pagination->create_links(); ?>
   </div>
</div>
<div id="crm_form_modal" tabindex="-1" class="modal fade in" role="dialog" style="overflow:hidden;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Lead</h4>
         </div>
         <div class="modal_body_content"></div>
      </div>
   </div>
</div>
<div id="crm_add_modal" class="modal fade in" role="dialog">
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
<?php   
   /*
   if(isset($_POST["ExportType"]))
   {
   
    ob_end_clean();
       switch($_POST['ExportType'])
       {
        case "export-to-excel" :
               // Submission from
               $filename = $_POST["ExportType"] . ".xlsx";       
               header("Content-Type: application/vnd.ms-excel");
               header("Content-Disposition: attachment; filename=\"$filename\"");
            //pre($data3);die();
            ExportFile($data3);
               exit();
           case "export-to-csv" :
               // Submission from
               $filename = $_POST["ExportType"] . ".csv";            
               header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
               header("Content-type: text/csv");
               header("Content-Disposition: attachment; filename=\"$filename\"");
               header("Expires: 0");
               ExportCSVFile($data3);
               //$_POST["ExportType"] = '';
               exit();
        default :         
               die("Unknown action : ".$_POST["action"]);
               break;
       }
   }
    
   function ExportCSVFile($records) {
       // create a file pointer connected to the output stream
       $fh = fopen( 'php://output', 'w' );
       $heading = false;
           if(!empty($records))
            ob_end_clean();
             foreach($records as $row) {
               if(!$heading) {
                 // output the column headings
                 fputcsv($fh, array_keys($row));
                 $heading = true;
               }
               // loop over the rows, outputting them
                fputcsv($fh, array_values($row));
                 
             }
             fclose($fh);
   }
    
   function ExportFile($records) {
       $heading = false;
       if(!empty($records))
        //ob_end_clean();
         foreach($records as $row) {
           if(!$heading) {
             // display field/column names as a first row
             echo implode("\t", array_keys($row)) . "\n";
             $heading = true;
           }
           echo implode("\t", array_values($row)) . "\n";
         }
       exit;
   }
   */
   ?>
<script>
   var measurementUnits = '';
</script>


<div class="modal fade leadStatusCommentModal" id="comntmodal"  aria-hidden="true" style="position:absolute;">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close_unqstatus_model"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel2">Status Comments</h4>
			</div>
			<div class="modal-body">
				<div class="item form-group">													
					<label class="control-label col-md-12 col-sm-12 col-xs-12" for="status_comment">Comments<span class="required">*</span></label>
					<div class="col-md-12 col-sm-12 col-xs-12">														
						<textarea id="status_comment" required="required" rows="6" name="status_comment" class="form-control col-md-7 col-xs-12" placeholder=""></textarea>
					</div>												
				</div>	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default close_unqstatus_model">Close</button>
				<button type="button" class="btn edit-end-btn" id="status_comment_btn">Save changes</button>
			</div>
		</div>
	</div>
</div>