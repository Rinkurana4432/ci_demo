 
<?php
 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
<style>
#sortableKanbanBoards .panel-body {
    overflow: unset !important;
}
</style>
<input type="hidden" id="loggedUser" value="<?= $this->companyGroupId ?>">
    <?php if($this->session->flashdata('message') != ''){ ?>
        <div class="alert alert-info col-md-12">
         <?php echo $this->session->flashdata('message');?>
        </div>
    <?php }?> 
            <div class="x_content">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
						<li role="presentation" class="active"><a href="#tab_content6" id="home-tab1" role="tab" data-toggle="tab" aria-expanded="true">Hrm Settings</a> </li>
                        <li role="presentation" ><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Pipeline</a> </li>
                        <li role="presentation"><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Transition</a> </li>
                        <!--li role="presentation"><a href="#tab_content3" role="tab" id="profile-tab1" data-toggle="tab" aria-expanded="false">Roles</a> </li>
                        <li role="presentation"><a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Sprint Duration</a> </li--->
                      <li role="presentation" ><a href="#worker_setting" id="home-tab1" role="tab" data-toggle="tab" aria-expanded="true">Worker Settings</a> </li>
                       <li role="presentation" ><a href="#approvel_setting" id="home-tab1" role="tab" data-toggle="tab" aria-expanded="true"> Approvel Setting</a> </li> 
                        <li role="presentation" ><a href="#rotatable_shift_setting" id="home-tab3" role="tab" data-toggle="tab" aria-expanded="true"> Rotational Shift Setting</a> </li>  
                       
                             </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane  " id="tab_content1" aria-labelledby="home-tab">

                           <div class="pull-left col-md-12">
                                <div class="col-md-4 col-sm-12 datePick-right"> <?php if($can_add) {
                echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="AddTaskListStatus">Add Task List Status</button>';
                } ?>
                </div>
                    </div>
                            <div class="col-md-6">
                            <p class="text-muted font-13 m-b-30"></p>
                          
                           
                     <div class="dragg">
         <div id="sortableKanbanBoards" class="row">
         
            <!--sütun başlangıç-->
            <div class="panel panel-primary kanban-col" >
               <div class="panel-heading">
                  <input type="hidden" class='totalprice' value='<?php //echo count($process_data['process']); ?>'/>
                  <span style="text-align:  left;" class="total11">
                  </span>
                  <i class="fa fa-2 fa-chevron-up pull-right process"></i>
               </div>
               
               <?php 
               if(!empty($data)){
					$i= 0;
					foreach($data as $process_data){
                ?>
                      <div class="panel-body" style="height: 50px;" >                 
                    <div id="<?php  echo $process_data->sequence_id; ?>" class="kanban-centered">
                     <article class="kanban-entry grab process" id="<?php echo $process_data->sequence_id ?>" draggable="true" data-id="<?php echo $process_data->name;?>">
                        <div class="kanban-entry-inner">
                           <div class="kanban-label" style="cursor: -webkit-grab;">
                               <p>Status Name: <?php echo $process_data->name;?></p>
                                <h2><button type="button" data-id="AddTaskListStatus" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs pull-right" data-toggle="modal" id="<?php echo $process_data->id;?>"><i class="fa fa-pencil"></i></button>
                              <button type="button" data-id="ViewTaskListStatus" data-tooltip="View" class="hrmTab btn btn-view  btn-xs pull-right" data-toggle="modal" id="<?php echo $process_data->id;?>"><i class="fa fa-eye"></i></button>
                              </h2>
                           </div>

                        </div>
                     </article>
                       </div>

                    </div>
                     <?php } $i++;}   ?>     
               <div class="panel-footer">
                  <a href="#"></a>
               </div>
            </div>
         </div>
      </div>        
      </div>      
               <div class="col-md-6">   
                    <p class="text-muted font-13 m-b-30"></p>
                 
                  <table id="" class="table table-striped table-bordered account_index" cellspacing="0" width="100%" style="margin-top:46px;">
      <thead>
         <tr>
            <th>Pipe Line Status  </th>
            <th>    </th>
        <!--   <th>  </th> -->
         </tr>
      </thead>
      <tbody>
         <?php foreach($all_pipeline_data as $process_data): ?>
         <tr>
            <td ><?php echo  $process_data->name ?></td>
             <td data-label="action:" class="jsgrid-align-center ">
               <button type="button" data-id="AddTaskListStatus" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs pull-right" data-toggle="modal" id="<?php echo $process_data->id;?>"><i class="fa fa-pencil"></i></button>
            </td>
          <!-- <td data-label="action:" class="jsgrid-align-center ">
              <?php  /*echo '<a  href="javascript:void(0)"  data-tooltip="Delete" class="delete_listing  btn btn-delete btn-xs" data-href="'.base_url().'hrm/deleteTaskListStatus/'.$process_data->id.'" ><i class="fa fa-trash"></i></a>';*/?>
            </td>-->
          </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
    </div>
 </div>
          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                       <!--  <p class="text-muted font-13 m-b-30"></p>-->
                 <a href="insert_data_transition_table"  class="btn btn-primary">Sync Transition </a>
               
    <table id="" class="table table-striped table-bordered account_index" cellspacing="0" width="100%" style="margin-top:46px;">
      <thead>
         <tr>
            <th>From  </th>
            <th>To </th>
            <th>Transition Status </th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($transition_data as $value):   
         
                  $from_status[] =      json_decode($value['from_status'],true);
                   $to_status[]   =      json_decode($value['to_status'],true);
                   $status[]   =      json_decode($value['status'],true);
        endforeach;   
         ?> 
         
         
         <?php
        // pre($to_status);
         if(isset($from_status)){
         foreach($from_status as $key3 => $value): ?>
         <?php  
             $new_arr_val =  array_keys($value);
             $new_arr_key =  array_values($value);
             /*-----------------------------------------*/
             
             
             
           if($new_arr_key[0] != '0'){
             $name = getNameById('task_list_status',$new_arr_val[0],'id');
         ?>
         <tr>
           
           <?php if(!empty($name->name)){   ?>
            <td ><?php echo @$name->name; ?></td>
            <td >
                
            
            <?php  
                    foreach($to_status[$key3] as $key4 => $value2 ){             
                    $new_arr_val2 =  array_keys($value2);
                    $new_arr_key2 =  array_values($value2); 
                    $name3 = getNameById('task_list_status',$new_arr_val2[0],'id'); 
                   // if($new_arr_key2[0] != '0'){
            ?>    
             <table> 
              <td><?php  echo @$name3->name."<br><br>"   ?></td>
              
              
              </table>      
              
            <?php 
			//} 
			}  
			?>
            
                
                
            </td>
            
           
            <td>
                
              <?php  
                    $z =1;
                    foreach($to_status[$key3] as $key4 => $value2 ){  
					$new_arr_val2 =  array_keys($value2);
                    $new_arr_key2 =  array_values($value2); 
                     $name3 = getNameById('task_list_status',$new_arr_val2[0],'id'); 
                   // if($new_arr_key2[0] != '0'){
                       $key4 = $key4 + $z;
            ?>    
              <table> 
                 <td>  <?php //pre($status[$key3][$key4]); ?> 
                           
                <form  id="form<?php echo $new_arr_val[0]; ?>">   <!--[$key4]-->
                    <input type="hidden" name="row_id" value="<?php echo $new_arr_val[0]; ?>">
                    <input type="radio"  <?php echo @ ($status[$key3][$key4][$new_arr_val2[0]]=='0')?'checked':'' ?>   id="radio[<?php echo $new_arr_val2[0]; ?>]" name="<?php echo $new_arr_val2[0]; ?>" value="0" ><label>No</label>
                    <input type="radio"  <?php echo @ ($status[$key3][$key4][$new_arr_val2[0]]=='1')?'checked':'' ?>  id="radio[<?php echo $new_arr_val2[0]; ?>]" name="<?php echo $new_arr_val2[0]; ?>" value="1" ><label>Yes</label>

              </td>
              </table> 
              
               <?php  //}   ?>
                
              <?php  }  ?>
                   <input class="btn btn-primary" onclick=sub_form(<?php echo $new_arr_val[0]; ?>); type="button" id="save" value="SAVE">
		</form>
            </td>
			<td >
            <?php  
                    foreach($to_status[$key3] as $key4 => $value2 ){             
                    $new_arr_val2 =  array_keys($value2);
                    $new_arr_key2 =  array_values($value2); 
                    $name3 = getNameById('task_list_status',$new_arr_val2[0],'id'); 
                   // if($new_arr_key2[0] != '0'){

            ?>    
             <table> 
           <!--   <td></?php  echo $name3->name."<br><br>"   ?></td>-->
              <!--td></td-->
              
               <!-- </?php  echo $xnew_arr_val2[0]."<br><br>"   ?>-->
<td><button type="button" data-id="transition_authority" data-tooltip="Edit" class="hrmTab2 btn btn-edit  btn-xs pull-right" data-toggle="modal" sec-id="<?php echo $new_arr_val2[0];?>" id="<?php echo $new_arr_val[0];?>"><i class="fa fa-pencil"></i></button>
    </td>
            
              </table>      
            <?php 
			//} 
			}  ?>            
            </td>
                       
           <?php  } ?>
          </tr>
       <?php }    endforeach;  }  ?>
      </tbody>
   </table>
 </div>
        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab1">
                <p class="text-muted font-13 m-b-30"></p>
                  <div class="pull-left">
                          <div class="col-md-4 col-sm-12 datePick-right"> <?php if($can_add) {
         echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="AddRole">Add Role</button>';
         } ?></div>
         
         <table id="" class="table table-striped table-bordered account_index" cellspacing="0" width="100%" style="margin-top:46px;">
      <thead>
         <tr>
            <th>Name </th>
            <th> Edit Role </th>
         <!--   <th> Edit User Role </th>-->
         </tr>
      </thead>
      <tbody>
         <?php foreach($role as $value): ?>
         <tr>
            <td data-label="name:"><?php echo $value->name ?></td>
             <td data-label="action:" class="jsgrid-align-center ">
               <?php echo  '<a href="javascript:void(0)" id="'. $value->id . '" data-id="AddRole_to_user_worker" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs" id="' . $value->id . '"><i class="fa fa-pencil"></i>  </a>'; ?>
               <?php  echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
                  btn btn-delete btn-xs" data-href="'.base_url().'hrm/del_task_list_role/'.$value->id.'" ><i class="fa fa-trash"></i></a>';?>
            </td>
          <!--  <td> <?php /*echo  '<a href="javascript:void(0)" id="'. $value->id . '" data-id="AddRole_to_user_worker" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs" id="' . $value->id . '"><i class="fa fa-pencil"></i>  </a>';*/ ?>  </td>-->
         </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
         
         
          </div>
                            
                            
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab2">
                    <button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="AddSprint">Add Sprint</button>        
                            
                
                 
         <table id="" class="table table-striped table-bordered account_index" cellspacing="0" width="100%" style="margin-top:46px;">
      <thead>
         <tr>
            <th>Days </th>
            <th> Edit Sprint </th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($sprint as $value): ?>
         <tr>
            <td data-label="name:"><?php echo $value->name ?></td>
             <td data-label="action:" class="jsgrid-align-center ">
               <?php echo  '<a href="javascript:void(0)" id="'. $value->id . '" data-id="AddSprint" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs" id="' . $value->id . '"><i class="fa fa-pencil"></i>  </a>'; ?>
               <?php  echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
                  btn btn-delete btn-xs" data-href="'.base_url().'hrm/deleteSprint/'.$value->id.'" ><i class="fa fa-trash"></i></a>';?>
            </td>
          </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
         
                
                
                            
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab2">
                            
                        <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                              <form action="<?php echo site_url(); ?>hrm/hrm_setting" method="get" id="export-form">
                 <input type="hidden" value='' id='hidden-type' name='ExportType'/>
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
               </ul>
               </form>
            </div>      
                               <div class="pull-left">
                                <div class="col-md-4 col-sm-12 datePick-right"> <?php if($can_add) {
         echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="AddTask">Add Task</button>';
         } ?></div>
         
          <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span >
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="dailyreport/dailyreport_adjustment">  
                      </div>
                  </div>
               </div>
            </fieldset>
           <form action="task_list_daterange" method="post" id="date_range">   
               <input type="hidden" value='' id='hidden-type' name='ExportType'/>
               <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
               <input type="hidden" value='<?php // if(!empty($_POST['company_unit'])){echo $_POST['company_unit'] ;} ?>' class='company_unit' name='company_unit'/>
            </form>
         
         
           <table id="example234" class="table table-striped table-bordered account_index" cellspacing="0" width="100%" style="margin-top:46px;">
      <thead>
         <tr>
            <th>Assigned To  </th>
            <th> Task Name </th>
            <th>Task Description </th>
            <th>Status</th>
            <th>Due date and time</th>
            <th>Aging Option</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php  
       /*    
               if(!empty($filter_task_list_data)){
                     foreach($new_work_detail as $value){
                         pre($value->superviser);
                         
                     }
                  
                   
               }
         ?>
         <?php foreach($new_work_detail as $value){ ?>*/
           
       $filter_task_list_data = $this->session->userdata('task_list_date_range');     
             $new_work_detail_filter  =   $filter_task_list_data['new_work_detail'];
              $work_detail ;
              
              
               if(!empty($filter_task_list_data)){
                   $work_detail = $new_work_detail_filter;
                   
               }else{
                    $work_detail = $new_work_detail;
               }
                  
                   
        if(!empty($work_detail)){
         ?>
         <?php foreach($work_detail as $value){ ?>
         <tr>
            <!-- </?php 	$owner = getNameById('user_detail',$value->assigned_to,'u_id');  ?>-->
             <?php 	$owner = getNameById('worker',$value->assigned_to,'id');  ?> 
             
            <td ><?php echo @ $owner->name ?></td>
            <td ><?php echo $value->task_name ?></td>
          
            <td ><?php echo $value->description ?></td>
            <?php $status = getNameById('task_list_status',$value->pipeline_status,'id');  ?>
            <td ><?php if(!empty($status->name)){ echo $status->name;  } ?></td>
            <td ><?php echo $value->due_date ?></td>
            <?php 
           $due_date  = date('Y-m-d', strtotime($value->due_date));
           $todays_date = date('Y-m-d');
            
            
            $date1 = new DateTime($todays_date);
            $date2 = new DateTime($due_date);
            $interval = $date1->diff($date2);
            ?>
            <td><?php   echo $interval->d." days "; ?></td>
             <td data-label="action:" class="jsgrid-align-center ">
               <?php echo  '<a href="javascript:void(0)" id="'. $value->id . '" data-id="AddTask" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs" id="' . $value->id . '"><i class="fa fa-pencil"></i>  </a>'; ?>
               <?php  echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
                  btn btn-delete btn-xs" data-href="'.base_url().'hrm/delete_new_work_detail/'.$value->id.'" ><i class="fa fa-trash"></i></a>';?>
            </td>
          </tr>
             <?php
                    $output[] = array(
                        'Assigned to ' =>@ $owner->name,
                        'Task Name' => $value->task_name ,
                        'Description' => $value->description,
                        'Status' => @ $status->name ,
                        'Due Date' => $value->due_date,
                        'Aging ' => $interval->d,
                       
                        );
                         ?>
            <?php }
				if(!empty($output)){
                        $data3  = $output;
                        export_csv_excel($data3);
				}				
                        $this->session->unset_userdata('task_list_date_range');
						
		 }			
                        ?>
      </tbody>
   </table>
			</div>
		</div>




   <div role="tabpanel" class="tab-pane  " id="worker_setting" aria-labelledby="profile-tab2">
<!--       <div class="col-md-12 col-sm-12 col-xs-12"  >
    <label class="col-md-2 col-sm-3 col-xs-12" for="type">Employee Working  Hrs<span class="required">*</span></label>
        <div class="col-md-6 col-sm-12 col-xs-12">
           <form  method="post" action="<?php echo base_url(); ?>hrm/empWorkingHrs" enctype="multipart/form-data">
            <?php $delivery = $this->hrm_model->get_compdata('company_detail',array('id'=> $this->companyGroupId)); 
            if (empty($delivery[0]['empWorkingHrs'])) { ?>
              <input type="hidden" name="id"  value="<?php  echo $delivery[0]['id']; ?>">
                <input type="text" required id="empWorkingHrs" name="empWorkingHrs"  class="form-control col-md-7 col-xs-12" placeholder="Working Hrs"  >
           <?php   } if (!empty($delivery[0]['empWorkingHrs'])) { ?>
              <input type="hidden" name="id"  value="<?php  echo $delivery[0]['id']; ?>">
            <input type="text" required id="empWorkingHrs" name="empWorkingHrs"  class="form-control col-md-7 col-xs-12" placeholder="Working Hrs" value="<?php   echo $delivery[0]['empWorkingHrs']; ?>">
          <?php }?>
            

             <button type="submit" class="btn btn-primary">Submit</button> 

           </form>
           </div>  
     </div> -->
    <div class="col-md-12 col-sm-12 col-xs-12"  >
    <label class="col-md-2 col-sm-3 col-xs-12" for="type">Worker Overtime Pay<span class="required">*</span></label>
        <div class="col-md-6 col-sm-12 col-xs-12">
           <form  method="post" action="<?php echo base_url(); ?>hrm/worker_ot_salary" enctype="multipart/form-data">
            <?php $delivery = $this->hrm_model->get_compdata('company_detail',array('id'=> $this->companyGroupId)); 
            if (empty($delivery[0]['hrm_worker_ot_salary'])) { ?>
              <input type="hidden" name="id"  value="<?php  echo $delivery[0]['id']; ?>">
                <input type="text" required id="hrm_worker_ot_salary" name="hrm_worker_ot_salary"  class="form-control col-md-7 col-xs-12" placeholder="Working Hrs"  >
           <?php   } if (!empty($delivery[0]['hrm_worker_ot_salary'])) { ?>
              <input type="hidden" name="id"  value="<?php  echo $delivery[0]['id']; ?>">
            <input type="text" required id="hrm_worker_ot_salary" name="hrm_worker_ot_salary"  class="form-control col-md-7 col-xs-12" placeholder="Working Hrs" value="<?php   echo $delivery[0]['hrm_worker_ot_salary']; ?>">
          <?php }?>
            

             <button type="submit" class="btn btn-primary">Submit</button> 

           </form>
           </div>  
     </div>
     <div class="col-md-12 col-sm-12 col-xs-12"  >
    <label class="col-md-2 col-sm-3 col-xs-12" for="type">Worker Total Month off<span class="required">*</span></label>
        <div class="col-md-6 col-sm-12 col-xs-12">
           <form  method="post" action="<?php echo base_url(); ?>hrm/worker_month_off" enctype="multipart/form-data">
            <?php $month_off = $this->hrm_model->get_compdata('company_detail',array('id'=> $this->companyGroupId)); 
            if (empty($month_off[0]['worker_week_off'])) { ?>
              <input type="hidden"  name="id" value="<?php  echo $month_off[0]['id']; ?>">
                <input type="text" required id="worker_week_off" name="worker_week_off"  class="form-control col-md-7 col-xs-12" placeholder="Worker Total Month off"  >
           <?php   } if (!empty($month_off[0]['worker_week_off'])) { ?>
              <input type="hidden" name="id"  value="<?php  echo $month_off[0]['id']; ?>">
            <input type="text" required id="worker_week_off" name="worker_week_off"  class="form-control col-md-7 col-xs-12" placeholder="Worker Total Month off" value="<?php   echo $month_off[0]['worker_week_off']; ?>">
          <?php }?>
            

             <button type="submit" class="btn btn-primary">Submit</button> 

           </form>
           </div>  
     </div>
   </div>


   <div role="tabpanel" class="tab-pane  " id="approvel_setting" aria-labelledby="profile-tab2">

 <div class="col-md-12 col-sm-12 col-xs-12"  >
    <label class="col-md-2 col-sm-3 col-xs-12" for="type">Make HR Permissions<span class="required">*</span></label>
     <div class="col-md-9 col-sm-6 col-xs-12">
     <div class=" itamform-group">
           <div class="col-md-3 col-sm-12 col-xs-12">
       <?php if(!empty($userDetail)){
         foreach($userDetail as $userDetailsaleval){    ?>
          <p scope="row"><?=$userDetailsaleval['name'];?> <a href="<?php echo base_url(); ?>hrm/change_hr_permissions_zero/<?=$userDetailsaleval['u_id'];?>"> <i class="fa fa-trash" aria-hidden="true"></i></a> </p>
      <?php }}  ?>  

           </div>
          <div class="col-md-6 col-sm-12 col-xs-12"> 
            <form  method="post" action="<?php echo base_url(); ?>hrm/change_hr_permissions" enctype="multipart/form-data">
            <select class=" form-control" name="id[]" id="hr_permissions"  multiple>
             <option value="">Select Option</option>
                <?php
                   foreach($user as $saleval){ 
                    echo '<option value="'.$saleval['u_id'].'" >'.$saleval['name'].'</option>';
                 } 
                ?>
             </select> 
              <br>
             <button type="submit" class="btn btn-primary">Submit</button>
            </form>
           </div>
            
       </div> 
      </div>
     </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
    <label class="col-md-2 col-sm-3 col-xs-12" for="type">Send Mail Permission in TA/DA<span class="required">*</span></label>
     <div class="col-md-9 col-sm-6 col-xs-12">
      <div class=" itamform-group">
      <div class="col-md-3 col-sm-12 col-xs-12">
      <?php if(!empty($userDetailtada)){
         foreach($userDetailtada as $userDetailtada2){    ?>
          <p scope="row"><?=$userDetailtada2['name'];?> <a href="<?php echo base_url(); ?>hrm/change_status_tada_permissions_zero/<?=$userDetailtada2['u_id'];?>"> <i class="fa fa-trash" aria-hidden="true"></i></a> </p>
      <?php }}  ?> 
     </div>


     <div class="col-md-6 col-sm-12 col-xs-12">
       <form  method="post" action="<?php echo base_url(); ?>hrm/change_status_tada_permissions_one" enctype="multipart/form-data">
         <select class=" form-control" name="id[]" id="hr_permissions"  multiple>
             <option value="">Select Option</option>
                <?php
                     foreach($user as $saleval){ 
                    echo '<option value="'.$saleval['u_id'].'" >'.$saleval['name'].'</option>';
                 } 
                ?>
             </select>
             <br>
             <button type="submit" class="btn btn-primary">Submit</button> 
           </form>
         </div>
            
         </div> 
        </div>
     </div>

   <div class="col-md-12 col-sm-12 col-xs-12"  >
    <label class="col-md-2 col-sm-3 col-xs-12" for="type">Send Mail Permission Acount<span class="required">*</span></label>
     <div class="col-md-9 col-sm-6 col-xs-12">
      <div class=" itamform-group">
        <div class="col-md-3 col-sm-12 col-xs-12">
         
     <?php if(!empty($userDetailacount)){
         foreach($userDetailacount as $userDetailtadaacount2){    ?>
          <p scope="row"><?=$userDetailtadaacount2['name'];?> <a href="<?php echo base_url(); ?>hrm/change_status_tada_permissionsAcount_zero/<?=$userDetailtadaacount2['u_id'];?>"> <i class="fa fa-trash" aria-hidden="true"></i></a> </p>
      <?php }}  ?> 
          </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
           <form  method="post" action="<?php echo base_url(); ?>hrm/change_status_tada_permissionsAcount" enctype="multipart/form-data">
          <select class=" form-control" name="id[]" id="hr_permissions"  multiple>
             <option value="">Select Option</option>
                <?php
                     foreach($user as $saleval){ 
                    echo '<option value="'.$saleval['u_id'].'" >'.$saleval['name'].'</option>';
                 } 
                ?>
             </select>
             <br>
             <button type="submit" class="btn btn-primary">Submit</button> 
           </form>
           </div>
            
         </div>
        </div>
 </div>
       <div class="col-md-8 col-sm-12 col-xs-12 vertical-border" style="clear: both;"> 
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label class="col-md-3 col-sm-3 col-xs-12" for="type">Multi Approve</label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <table class="table table-striped checkAction">
               <tbody>
                  <tr>
                    <th scope="row" style="width: 500px;">Multi Approve</th>
                    <td>
                        <label class="switch">
                          <input type="checkbox" value="1" class="onOffStatus" name="multi_approval_hrm" data-tbl="company_detail" data-where="id=<?= $this->companyGroupId ?>" id="onoffStatus" <?= ($month_off[0]['multi_approval_hrm'])?'checked':"";  ?>>
                          <span class="slider round"></span>
                        </label>
                     </td>
                  </tr>
                  
                </tbody>
            </table>
         </div>
      </div>
      </div>
      <?php if( isset($month_off[0]['multi_approval_hrm']) ){
            if( $month_off[0]['multi_approval_hrm'] > 0  ){ ?>
               <div class="col-md-8 col-sm-12 col-xs-12 vertical-border" style="clear: both;"> 
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-3 col-sm-3 col-xs-12" for="type">HRM  Approve Level</label>
                     <div class="col-md-9 col-sm-6 col-xs-12">
                        <table class="table table-striped checkAction">
                           <tbody>
                              <tr>
                                <td>
                                    <div class="row inputFieldArea">
                                       <div class="col-md-9">
                                         <input type="text" name="hrm_multi_lever_approve" data-tbl="company_detail" data-where="id=<?= $this->companyGroupId ?>" class='form-control' 
                                                value="<?= ($month_off[0]['hrm_multi_lever_approve'])?$month_off[0]['hrm_multi_lever_approve']:''; ?>" onkeypress="return float_validation(event, this.value)">
                                       </div>
                                       <div class="col-md-3">
                                          <button type="button" class="btn btn-success submitInputValue">Save</button>
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <?php 
                                          if( isset($month_off[0]['hrm_multi_lever_approve']) ){
                                             if( $month_off[0]['hrm_multi_lever_approve'] > 0 ){ ?>
                                                <h4 class="text-center">HRM Multi Approve By Users Select</h4>
                                                <form action="<?= base_url('hrm/hrm_approve_user') ?>" class="form-group row userApproveFrom" method="POST">
                                             <?php 
                                                $j = 0;
                                                $users = [];
                                                if( isset($month_off[0]['hrm_approve_users']) ){
                                                    $users = json_decode($month_off[0]['hrm_approve_users'],true);
                                                }
                                                for ($i=1; $i <= $month_off[0]['hrm_multi_lever_approve']; $i++) {
                                                      $user_name = "";
                                                   ?>
                                                   <div class="userSelectArea">
                                                     <h4 class="col-md-3" >HRM Approval <?= $i ?></h4>
                                                      <div class="col-md-9 ">
                                                        <select placeholder="Users" class="itemName form-control selectAjaxOption select2 select2-hidden-accessible   hrm_approve_users"   name="hrm_approve_users[<?= $j ?>][]"  id="u_id" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $this->companyGroupId;?>  " width="100%" tabindex="-1" aria-hidden="true" required="required" multiple>

                                                         <?php 
                                                            if( $user ){
                                                               foreach($user as $allKey => $allValue ){?>
                                                                  <option value="<?= $allValue['u_id'] ?>"
                                                                     <?php if( isset($users[$j]) ){
                                                                              if( in_array($allValue['u_id'],$users[$j]) ){
                                                                                 echo 'selected';
                                                                              }
                                                                     } ?>
                                                                  >
                                                                  <?= $allValue['name']??'' ?>
                                                                  </option>
                                                            <?php }

                                                            }

                                                         ?>
                                                        </select>
                                                      </div> 
                                                   </div>
                                             <?php $j++;
                                                 } ?>
                                                <div class="col-md-12">
                                                   <div class="form-group">
                                                      <input type="submit" class="btn btn-success" value="Save">
                                                   </div>
                                                </div>
                                                </form>
                                       <?php }       
                                          } ?>
                                    </div>
                                </td>
                              </tr>
                            </tbody>
                        </table>
                     </div>
                  </div>
               </div>
      <?php }
         } ?>


   </div>
   <!--rotatable shift-setting--> 
 <div role="tabpanel" class="tab-pane  " id="rotatable_shift_setting" aria-labelledby="profile-tab2">
    <div class="container">
       <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#Employee">Employee </a></li>
         <li><a data-toggle="tab" href="#Worker">Worker</a></li> 
       </ul>



     <div class="tab-content">
      <div id="Employee" class="tab-pane fade active in">
             <?php $this->load->view('task_list_setting/rotatable_shift_setting/employee'); ?>
        </div>
        <div id="Worker" class="tab-pane fade">
            <?php  $this->load->view('task_list_setting/rotatable_shift_setting/worker'); ?>
         </div>
       </div>
     </div> 
  </div>

<!--rotatable shift-setting close--> 















		 <div role="tabpanel" class="tab-pane  active" id="tab_content6" aria-labelledby="profile-tab2">
		 <div class="col-md-8 col-sm-12 col-xs-12">
		  <!--label class="col-md-3 col-sm-3 col-xs-12" for="type">Worker / Supervisor Setting<span class="required">*</span></label-->
			<div class="col-md-9 col-sm-6 col-xs-12">
				<table class="table table-striped">
					<tbody>
					<!tr>
						<td scope="row">Worker Data ON/OFF</td>
						<td>
						<form id="change_status_workerdata" method="post" action="<?php echo base_url(); ?>hrm/save_Settings" enctype="multipart/form-data">
							 <?php
								$workerdat = $this->hrm_model->get_Companydata('company_detail',array('id'=> $this->companyGroupId));
								
								if($workerdat[0]['hrm_worker_data'] == '0'){//0 for OFF		
								
							   ?>
						<input type="hidden" value="1" name="hrm_worker_data" id="hrm_worker_data" >
						<input type="checkbox" class="js-switch change_status_workerdata"  data-switchery="true" value="" >
						<label for="subscribeNews">Worker Data OFF</label>
							<?php } else { //1 for ON ?>
						<input type="hidden" value="0" name="hrm_worker_data" id="hrm_worker_data" >
						<input type="checkbox" class="js-switch change_status_workerdata"  data-switchery="true" value="" checked >
						<label for="subscribeNews">Worker Data OFF</label>
						<?php } ?>
						</form>
					</td>
				</tr>
						<tr>
						<td scope="row">Worker / Supervisor Setting</td>
						<td>
						<form id="change_status_supervisorworker1" method="post" action="<?php //echo base_url(); ?>hrm/save_Settings" enctype="multipart/form-data">
							 <?php
								$item_code_Settings = $this->hrm_model->get_Companydata('company_detail',array('id'=> $this->companyGroupId));
								if($item_code_Settings[0]['workerSupervisor_setting'] == '0'){//0 for OFF		
								
							   ?>
						<input type="hidden" value="1" name="workerSupervisor_setting" id="workerSupervisor_setting" >
						<input type="checkbox" class="js-switch change_status_supervisorworker"  data-switchery="true" value="" >
						<label for="subscribeNews">Supervisor OFF</label>
							<?php } else { //1 for ON ?>
						<input type="hidden" value="0" name="workerSupervisor_setting" id="workerSupervisor_setting" >
						<input type="checkbox" class="js-switch change_status_supervisorworker"  data-switchery="true" value="" checked >
						<label for="subscribeNews">Supervisor ON</label>
						<?php } ?>
						</form>
					</td>
				</tr-->
          <tr>
          <td scope="row">NPDM Setting</td>
            <td>
          <form id="change_status_npdm" method="post" action="<?php echo base_url(); ?>hrm/save_npdm_setting" enctype="multipart/form-data">
             <?php
                $item_code_Settings = $this->hrm_model->get_Companydata('company_detail',array('id'=> $this->companyGroupId));
                if($item_code_Settings[0]['npdm_on_off'] == '0'){//0 for OFF   
                
                 ?>
            <input type="hidden" value="1" name="npdm_setting" id="npdm_setting" >
            <input type="checkbox" class="js-switch change_status_npdmworker"  data-switchery="true" value="" >
            <label for="subscribeNews">NPDM OFF</label>
              <?php } else { //1 for ON ?>
            <input type="hidden" value="0" name="npdm_setting" id="npdm_setting" >
            <input type="checkbox" class="js-switch change_status_npdmworker"  data-switchery="true" value="" checked >
            <label for="subscribeNews">NPDM ON</label>
            <?php } ?>
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
			
          
<div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-body">
            <div class="text-center">
               <i class="fa fa-refresh fa-5x fa-spin"></i>
               <h4>Processing...</h4>
            </div>
         </div>
      </div>
   </div>
</div>    
        
<div id="hrm_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Add Task List status</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>

<!--Script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

 
$(function () {
	var kanbanCol = $('.panel-body');
	kanbanCol.css('max-height', (window.innerHeight - 150) + 'px');
	var kanbanColCount = parseInt(kanbanCol.length);
	$('.container-fluid').css('min-width', (kanbanColCount * 350) + 'px');
	var dragClass = $(".dragg");
	if (dragClass.hasClass('dragg')) {
		console.log("dfdf");
		draggableInit2();
	}

 
	$('.panel-heading').click(function () {
 
		if ($(this).find('i').hasClass("fa-chevron-up")) {
			$(this).find('i').removeClass("fa-chevron-up");
			$(this).find('i').addClass("fa-chevron-down");
			var $panelBody = $(this).parent().children('.panel-body');
			$panelBody.slideToggle();
		} else if ($(this).find('i').hasClass("fa-chevron-down")) {
			$(this).find('i').removeClass("fa-chevron-down");
			$(this).find('i').addClass("fa-chevron-up");
			var $panelBody = $(this).parent().children('.panel-body');
			$panelBody.slideToggle();
		}
	});
});


function draggableInit2() {

	var sourceId;
	$('[draggable=true]').bind('dragstart', function (event) {
		console.log('event===>>>', event);
		sourceId = $(this).parent().attr('id');
	
		event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
		console.log("sourceId=>>>xx", event.originalEvent.dataTransfer.getData("text/plain"));
	  
	});
	$('.panel-body').bind('dragover', function (event) {
		event.preventDefault();
	});
	$('.panel-body').bind('drop', function (event) {
		var children = $(this).children();
		var targetId = children.attr('id');
		console.log("targetid==>>", targetId);
		var status = $('#status').val();
	    console.log("before con==>>", 'ditionxx');
	 
	 
			var elementId = event.originalEvent.dataTransfer.getData("text/plain");
			console.log("elementId->>", elementId);

			$.ajax({
				url: site_url + 'hrm/set_task_list_status/',
				dataType: 'json',
				type: 'POST',
				data: {
					'processId': elementId,
					'target_id': targetId,
					'sourceId' : sourceId,
				},
				success: function (result) {
					        
				 
					//
                   
				 
				}
			});
			

			$('#processing-modal').modal('toggle'); 
		
			setTimeout(function () {

				var element = document.getElementById(elementId);
				children.prepend(element);
				$('#processing-modal').modal('toggle'); //  
        //location.reload();
		 
			}, 1000);
            
	
	});
	
}

 
function sendOrderToServer() {
	var order = [];
	$('.process').each(function (index, element) {
		order.push({
			id: $(this).attr('id'),
			position: index + 1
		});
	});
	var children = $(this).children();
	$.ajax({
		type: "POST",
		dataType: "json",
		url: site_url + 'crm/changeOrder/',
		data: {
			order: order,
		},
		success: function (response) {
			if (response.status == "success") {
				window.location.href = result.url;
			}
		}
	});
	$('#processing-modal').modal('toggle'); //before post
	// Post data 
	setTimeout(function () {
		var element = document.getElementById($(this).attr('id'));
		children.prepend(element);
		$('#processing-modal').modal('toggle'); // after post
	}, 1000);

}


 
</script-->