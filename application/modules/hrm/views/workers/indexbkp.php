
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-info">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }
   ?>
<div class="x_content">
<div class="col-md-12 col-sm-12 for-mobile">
         <div class="Filter Filter-btn2">
<form class="form-search" method="get" action="<?= base_url() ?>hrm/workers">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter Type,Name" name="search" id="search" data-ctrl="hrm/workers?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?> " value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab']; ?>"/>
		 <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
		 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?= base_url() ?>hrm/workers?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?> '" value="Reset"></a>
      </div>
   </div>
</form>	
 <button style="margin-right: 0px !important;" type="button" class="btn btn-primary collapsed" data-toggle="collapse" data-target="#Filter" aria-expanded="false"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
            <div id="Filter" class="collapse">
               
			<div class="col-md-12 col-xs-12 col-sm-12 datePick-right">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="hrm/workers">
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>hrm/workers" method="get" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
               <input type="hidden" value='' class='company_unit' name='company_unit'/>
               <input type="hidden" value='' class='ExportType' name='ExportType'/>
			   	<input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab']; ?>"/>
			   	<input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab']; ?>"/>
            </form>
         </div>
		 <!-- Filter div Start-->  
               <form action="<?php echo base_url(); ?>hrm/workers" method="get" >
                  <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start'/>
                  <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end']; }?>' class='end_date' name='end'/>	
                 <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab']; ?>"/>
<div class="row hidde_cls filter1 progress_filter">
                     <div class="col-md-12">
                        <div class="btn-group disbled_cls "  role="group" aria-label="Basic example" style="width:100%;">
                           <select name="company_unit" class="form-control company_unit">
                              <option value=""> Select Category </option>
                              <?php
                                 if(!empty($company_unit_adress) ){
                                 	foreach($company_unit_adress as $companyUnit){
                                 	$getUnit = $companyUnit['address'];
                                 	$getDecodeUnit = json_decode($getUnit);
                                 	foreach($getDecodeUnit as $fetchUnit){
                                 		$address = $fetchUnit->compny_branch_name;
                                 ?>
                              <option value="<?php echo $address; ?>"><?php echo $address; ?></option>
                              <?php }} } ?>			
                           </select>
                        </div>
                        <input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="hrm/workers">
                     </div>
                  </div>
               </form>
               <!-- Filter div End-->
            </div>
</div>
</div>
   <form action="<?php echo site_url(); ?>hrm/workers" method="get" id="export-form">
      <input type="hidden" value='' id='hidden-type' name='ExportType'/>
      <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
      <input type="hidden" value='' class='start_date' name='start'/>
      <input type="hidden" value='' class='end_date' name='end'/>
	  <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab']; ?>"/>
      <input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start']; ?>' class='start_date' name='start'/>
      <input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end']; ?>' class='end_date' name='end'/>
      <input type="hidden" value='<?php if(!empty($_GET['company_unit'])){echo $_GET['company_unit']; }?>' class='company_unit' name='company_unit'/>
	  <input type="hidden" value='<?php if(!empty($_GET['search'])){echo $_GET['search']; }?>' class='search' name='search'/>
   </form>
   <div class="col-md-12 col-xs-12 for-mobile">
     
   <div class="row hidde_cls export_div">
      <div class="col-md-12">
         
         <div class="btn-group"  role="group" aria-label="Basic example">
		     <?php if($can_add) { 
               echo '<button type="buttton" class="btn btn-info hrmTab addBtn" id="worker_add" data-toggle="modal" data-id="workerEdit">Add</button>';
               } 
               ?>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
            <input type="hidden" value='worker' id="table" data-msg="Workers" data-path="hrm/workers"/>
            <button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
				  <li id="export-to-blank-excel"><a href="<?php echo base_url()?>hrm/worker_blankxls" title="Please check your open office Setting">Export to Blank Excel</a></li>
                  
               </ul>
            </div>
			
            
			 <form action="<?php echo base_url(); ?>hrm/workers" method="get" >
               <input type="hidden" value='1' name='favourites'/>
               <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];}?>' class='start' name='start'/>
               <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];} ?>' class='end' name='end'/>
               	<input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab']; ?>"/>
			   <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
            </form>
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#worker_type">Worker Type<span class="caret"></span></button>
            <div id="worker_type" class="collapse"  style="clear:both;">
               <!-- Filter div Start-->  
               <form action="<?php echo base_url(); ?>hrm/workers" method="get" >
                  <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start'/>
                  <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end']; }?>' class='end_date' name='end'/>	
                  <input type="hidden" value='<?php if(!empty($_GET['company_unit'])){echo $_GET['company_unit'];} ?>' class='company_unit' name='company_unit'/>
                  <input type="hidden" value='<?php if(!empty($_GET['ExportType'])){echo $_GET['ExportType']; }?>' class='ExportType' name='ExportType'/>	
                <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab']; ?>"/>
		<div class="row hidde_cls filter1 progress_filter">
                     <div class="col-md-12">
                        <div class="btn-group disbled_cls "  role="group" aria-label="Basic example" style="width:100%;">
                           <select name="worker_type" class="form-control company_unit">
                              <option value="">Select Employee Type</option>
                              <option value="on_roll" >On Roll</option>
                              <option value="temporary" >Temporary</option>
                              <option value="contractor_roll" >Contractor Roll</option>
                              <option value="maintenance" >Maintenance</option>
                           </select>
                        </div>
                        <input type="submit" value="Search" class="btn filterBtn filt1"  data-table="hrm/workers">
                     </div>
                  </div>
               </form>
               <!-- Filter div End-->
            </div>
           <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#demo3" aria-expanded="true">Import<span class="caret"></span></button>
						<div id="demo3" class="collapse " aria-expanded="true" style="">
							<table  class="table table-striped table-bordered" data-id="inventory">
								<thead>
									<tr><th>Upload excel file</th></tr>
								</thead>
									<tbody>
										<tr>
											<td>
												<form action="<?php echo base_url();?>hrm/import_workers" method="post" enctype="multipart/form-data">
												    <label>Upload Workers</label>
													<input type="file" name="uploadFile" value="" /><br><br>
													<input type="submit" name="submit_material_data" value="Upload" class="btn btn-primary" />
												</form>
											</td>
										</tr>
										
									</tbody>
							</table>
						</div>
         </div>
		 
         
      </div>
   </div>
   </div>
   <div role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a onclick="submit_worker_active();" href="#worker_active" data-select='worker' id="workerActiveTab" role="tab" data-toggle="tab" aria-expanded="true">Worker Active</a></li>
         <li role="presentation" class=""><a onclick="submit_worker_inactive();" href="#woker_inactive" data-select='worker' id="workerInactiveTab" role="tab" data-toggle="tab" aria-expanded="true">Worker Inactive</a></li>
         
      </ul>
      <div id="myTabContent" class="tab-content">
         <!-----------------Active Tab in workers----------------------------------------------------------->
         <div role="tabpanel" class="tab-pane fade active in" id="worker_active" aria-labelledby="workerActiveTab">
            <p class="text-muted font-13 m-b-30"></p>
            <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">	 
            <div id="print_div_content">
			<form id="assets_worker_active"><input type="hidden" value="worker_active" name="tab">	</form>
               <table id="" class="table  table-bordered user_index" style="width:100%" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
                  <thead>
                     <tr>
                        <th><input id="selecctall" type="checkbox"></th>
                        <th>Id
						<span><a href="<?php echo base_url(); ?>hrm/workers?sort=asc&tab=worker_active" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/workers?sort=desc&tab=worker_active" class="down"></a></span></th>
                        <th>Worker Type
						<span><a href="<?php echo base_url(); ?>hrm/workers?sort=asc&tab=worker_active" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/workers?sort=desc&tab=worker_active" class="down"></a></span></th>
                        <th>Worker Name
			<span><a href="<?php echo base_url(); ?>hrm/workers?sort=asc&tab=worker_active" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/workers?sort=desc&tab=worker_active" class="down"></a></span></th>
                        <th>Address</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Bank Name</th>
                        <th>Branch Name</th>
                        <th>Salary</th>
                        <th class='hidde'>Created By / Edited By</th>
                        <th>Created Date</th>
                        <th class='hidde'>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($active_workers)){					
                        foreach($active_workers as $worker){
                        	$statusChecked = $worker['active_inactive']==1?'checked':'';
                        	$created_by = ($worker['created_by']!=0)?(getNameById('user_detail',$worker['created_by'],'u_id')->name):'';
                        	$edited_by = ($worker['edited_by']!=0)?(getNameById('user_detail',$worker['edited_by'],'u_id')->name):'';
                        	$state = getNameById('state',$worker['state'],'state_id');
                        	$city = getNameById('city',$worker['city'],'city_id');
                        	$bank_name = getNameById('bank_name',$worker['bank_name'],'bankid');
                        	$draftImage = '';
                        	if($worker['save_status'] == 0)
                        	$draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';
                        ?>
                     <tr>
                        <td><?php echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$worker['id'].">";
                           if($worker['favourite_sts'] == '1'){
                           			   				echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$worker['id']."  checked = 'checked'>";
                           			   				echo"<input type='hidden' value='worker' id='favr' data-msg='Worker' data-path='hrm/workers' favour-sts='0' id-recd=".$worker['id'].">";
                           			   		}else{
                           							echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$worker['id'].">";
                           							echo"<input type='hidden' value='worker' id='favr' data-msg='Worker' data-path='hrm/workers' favour-sts='1' id-recd =".$worker['id'].">";
                           			   		}
                           ?></td>
                        <td><?php echo $draftImage.$worker['id']; ?></td>
                        <td><?php if($worker['worker_type']=="on_roll"){
                           echo "On Roll"; 
                           }elseif($worker['worker_type']=="temporary"){
                           echo "Temporary"; 
                           }elseif($worker['worker_type']=="contractor_roll"){
                           echo "Contractor Roll"; 
                           }elseif($worker['worker_type']=="maintenance"){
                           echo "Maintenance"; 
                           }
                           ?>
                        </td>
                        <td><?php echo $worker['name']; ?></td>
                        <td><?php echo $worker['address']; ?></td>
                        <td><?php if(!empty($state)){ echo $state->state_name; }  else{echo "N/A";}?></td>
                        <td><?php if(!empty($city)){ echo $city->city_name;} else{echo "N/A";} ?></td>
                        <td><?php if(!empty($bank_name)){ echo $bank_name->bank_name;} else{echo "N/A";} ?></td>
                        <td><?php echo $worker['branch_name']; ?></td>
                        <td><?php echo $worker['salary']; ?></td>
                        <td class='hidde'><?php echo "<a href='".base_url()."users/edit/".$worker['created_by']."' target='_blank'>".$created_by.'</a><a href="'.base_url().'users/edit/'.$worker["edited_by"].'" target="_blank"><br>'.$edited_by."</a>"; ?></td>
                        <td><?php echo date("j F , Y", strtotime($worker['created_date'])); ?></td>
                        <td class='hidde'>
                           <?php 
                              if($worker['save_status'] ==1){
                              	echo '<input type="checkbox" class="js-switch change_status_worker"  data-switchery="true" style="display: none;" value="'.$worker['active_inactive'].'" 
                              	data-value="'.$worker['id'].'"  '.$statusChecked .'>';	
                              }
                              if($can_edit)
                              	echo '<a href="javascript:void(0)" data-tooltip="Edit" class="btn btn-edit btn-xs hrmTab" data-toggle="modal" data-id="workerEdit" id="'.$worker["id"].'"><i class="fa fa-pencil"></i></a>'; 
                              if($can_view) 
                              	echo '<a href="javascript:void(0)" data-tooltip="View" class="btn btn-view btn-xs hrmTab" ata-toggle="modal" data-id="workerView" id="'.$worker["id"].'"><i class="fa fa-eye"></i>  </a>';
                              if($can_delete && $worker["used_status"]==1){
                              	echo '<a href="javascript:void(0)" data-tooltip="Delete" class="
                              	btn btn-delete btn-xs" data-href="'.base_url().'hrm/deleteWorker/'.$worker["id"].'" disabled="disabled"><i class="fa fa-trash"></i></a>';
                              }elseif($can_delete){
                              	echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
                              	btn btn-delete btn-xs" data-href="'.base_url().'hrm/deleteWorker/'.$worker["id"].'" ><i class="fa fa-trash"></i></a>';
                              }
							echo '<a href="'.base_url().'hrm/workers_pms/'.$worker["id"].'" class="btn btn-edit btn-xs">PMS</a>';
							echo '<a href="'.base_url().'hrm/worker_worked_view/'.$worker["id"].'" class="btn btn-edit btn-xs">Work Done</a>';
							#	echo '<a href="javascript:void(0)" data-tooltip="View" class="btn btn-view btn-xs hrmTab" ata-toggle="modal" data-id="workerWorkedView" id="'.$worker["id"].'">Work Done </a>';
						 
                             
                              ?>
                        </td>
                     </tr>
                     <?php
                        @$output[] = array(
                        'Worker name' => $worker['name'],
                        'Address' => $worker['address'],
                        'Mobile number' => $worker['mobile_number'],
                        'State' => $state->state_name,
                        'City' =>  $city->city_name,
                        'Bank name' => $bank_name->bank_name,
                        'Branch Name' => $worker['branch_name'],
                        'Salary' => $worker['salary'],
                        'Created Date' => date("d-m-Y", strtotime($worker['created_date'])),
                        );	
                        
                        }
                        $data3  = $output;
                        export_csv_excel($data3);	
                        //$data_balnk  = $output_blank;
                        //export_csv_excel_blank($data_balnk); 	
                        } ?>
                  </tbody>
               </table>
            </div>
         </div>
         <!--------------------------------end of active tab worker-------------------------------------------------->
         <!--------------------------------Inactive tab worker-------------------------------------------------->
         <div role="tabpanel" class="tab-pane fade" id="woker_inactive" aria-labelledby="workerInactiveTab">
            <p class="text-muted font-13 m-b-30"></p>
            <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>" />	 
            <div id="print_div_content">
			<form id="assets_worker_inactive"><input type="hidden" value="worker_inactive" name="tab">	</form>
               <table id="" class="table  table-bordered user_index" style="width:100%" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
                  <thead>
                     <tr>
                        <th><input id="selecctall" type="checkbox"></th>
                        <th>Id
						<span><a href="<?php echo base_url(); ?>hrm/workers?sort=asc&tab=worker_inactive" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/workers?sort=desc&tab=worker_inactive" class="down"></a></span></th>
                        <th>Worker Type
						<span><a href="<?php echo base_url(); ?>hrm/workers?sort=asc&tab=worker_inactive" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/workers?sort=desc&tab=worker_inactive" class="down"></a></span></th>
                        <th>Worker Name
						<span><a href="<?php echo base_url(); ?>hrm/workers?sort=asc&tab=worker_inactive" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/workers?sort=desc&tab=worker_inactive" class="down"></a></span></th>
                        <th>Address</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Bank Name</th>
                        <th>Branch Name</th>
                        <th>Salary</th>
                        <th class='hidde'>Created By / Edited By</th>
                        <th>Created Date</th>
                        <th class='hidde'>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($inactive_workers)){					
                        foreach($inactive_workers as $inactive){
                        	
                        	$statusChecked = $inactive['active_inactive']==1?'checked':'';
                        	$created_by = ($inactive['created_by']!=0)?(getNameById('user_detail',$inactive['created_by'],'u_id')->name):'';
                        	$edited_by = ($inactive['edited_by']!=0)?(getNameById('user_detail',$inactive['edited_by'],'u_id')->name):'';
                        	$state = getNameById('state',$inactive['state'],'state_id');
                        	$city = getNameById('city',$inactive['city'],'city_id');
                        	$bank_name = getNameById('bank_name',$inactive['bank_name'],'bankid');
                        	$draftImage = '';
                        	if($inactive['save_status'] == 0)
                        	$draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';
                        ?>
                     <tr>
                        <td><?php echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$inactive['id'].">";
                           //else{echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$supplier['id'].">";}
                           ?></td>
                        <td><?php echo $draftImage.$inactive['id']; ?></td>
                        <td><?php if($inactive['worker_type']=="on_roll"){
                           echo "On Roll"; 
                           }elseif($inactive['worker_type']=="temporary"){
                           echo "Temporary"; 
                           }elseif($inactive['worker_type']=="contractor_roll"){
                           echo "Contractor Roll"; 
                           }elseif($inactive['worker_type']=="maintenance"){
                           echo "Maintenance"; 
                           }
                           ?>
                        </td>
                        <td><?php echo $inactive['name']; ?></td>
                        <td><?php echo $inactive['address']; ?></td>
                        <td><?php if(!empty($state)){ echo $state->state_name; }  else{echo "N/A";}?></td>
                        <td><?php if(!empty($city)){ echo $city->city_name;} else{echo "N/A";} ?></td>
                        <td><?php if(!empty($bank_name)){ echo $bank_name->bank_name;} else{echo "N/A";} ?></td>
                        <td><?php echo $inactive['branch_name']; ?></td>
                        <td><?php echo $inactive['salary']; ?></td>
                        <td class='hidde'><?php echo "<a href='".base_url()."users/edit/".$inactive['created_by']."' target='_blank'>".$created_by.'</a><a href="'.base_url().'users/edit/'.$inactive["edited_by"].'" target="_blank"><br>'.$edited_by."</a>"; ?></td>
                        <td><?php echo date("j F , Y", strtotime($inactive['created_date'])); ?></td>
                        <td class='hidde'>
                           <?php 
                              if($inactive['save_status'] ==1){
                              	echo '<input type="checkbox" class="js-switch change_status_worker"  data-switchery="true" style="display: none;" value="'.$inactive['active_inactive'].'" 
                              	data-value="'.$inactive['id'].'"  '.$statusChecked .'>';	
                              }
                              if($can_edit)
                              	echo '<a href="javascript:void(0)" data-tooltip="Edit" class="btn btn-edit btn-xs hrmTab" data-toggle="modal" data-id="workerEdit" id="'.$inactive["id"].'"><i class="fa fa-pencil"></i></a>'; 
                              if($can_view) 
                              	echo '<a href="javascript:void(0)" data-tooltip="View" class="btn btn-view btn-xs hrmTab" ata-toggle="modal" data-id="workerView" id="'.$inactive["id"].'"><i class="fa fa-eye"></i>  </a>';
                              if($can_delete && $inactive["used_status"]==1){
                              	echo '<a href="javascript:void(0)" data-tooltip="Delete" class="
                              	btn btn-delete btn-xs" data-href="'.base_url().'hrm/deleteWorker/'.$inactive["id"].'" disabled="disabled"><i class="fa fa-trash"></i></a>';
                              }elseif($can_delete){
                              	echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
                              	btn btn-delete btn-xs" data-href="'.base_url().'hrm/deleteWorker/'.$inactive["id"].'" ><i class="fa fa-trash"></i></a>';
                              }
                              ?>
                        </td>
                     </tr>
                     <?php
                        @$output[] = array(
                        'Worker name' => $inactive['name'],
                        'Address' => $inactive['address'],
                        'Mobile number' => $inactive['mobile_number'],
                        'State' => $state->state_name,
                        'City' =>  $city->city_name,
                        'Bank name' => $bank_name->bank_name,
                        'Branch Name' => $inactive['branch_name'],
                        'Salary' => $inactive['salary'],
                        'Created Date' => date("d-m-Y", strtotime($inactive['created_date'])),
                        );	
                        }
                        $data3  = $output;
                        //pre($data3);
                        export_csv_excel($data3);
                        //$data_balnk  = $output_blank;
                        //export_csv_excel_blank($data_balnk); 	
                        } ?>
                  </tbody>
               </table>
			  
            </div>
         </div>
		  <?php  echo $this->pagination->create_links(); ?>
<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
         <!-----------------------------end of inactive tab--------------------------------------------->
      </div>
   </div>
</div>
<div id="printView">
   <div id="hrm_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
      <div class="modal-dialog modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title" id="myModalLabel">Worker Information</h4>
            </div>
            <div class="modal-body-content" style="height:auto;"></div>
         </div>
      </div>
   </div>
</div>