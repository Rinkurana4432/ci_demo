<style>
.export .btn {
    margin: 0px;
}
.export {
    position: absolute;
    top: 0;
    right: 5px;
}
</style>
<?php
 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
<!-- <style>
#sortableKanbanBoards .panel-body {
    overflow: unset !important;
}
</style> -->
<input type="hidden" id="loggedUser" value="<?= $this->companyGroupId ?>">
    <?php if($this->session->flashdata('message') != ''){ ?>
        <div class="alert alert-info col-md-12">
         <?php echo $this->session->flashdata('message');?>
        </div>
    <?php }?> 
            <div class="x_content">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                      <li role="presentation"><a href="#tab_content5" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="true">Listing</a> </li>
                        <li ><a href="#tab_content6" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">New PipeLine</a> </li>
                             </ul>
            <div class="tab-content">
                 <div role="tabpanel" class="tab-pane  active" id="tab_content5" aria-labelledby="profile-tab2">
                    
           <div class="export">
          <?php if($can_add) {
         echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="AddTask">Add Task</button>';
         } ?>		   
		   <div class="btn-group">
               <form action="<?php echo site_url(); ?>hrm/task_list_workers" method="get" id="export-form">
					<input type="hidden" value='' id='hidden-type' name='ExportType'/>
					<input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'] ?>' name='start'/>
					<input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'] ?>' name='end'/>
					<input type="hidden" value='<?php if(isset($_GET['supervisor']))echo $_GET['supervisor'] ?>' name='supervisor'/>
					<input type="hidden" value='<?php if(isset($_GET['assigned_to']))echo $_GET['assigned_to'] ?>' name='assigned_to'/>
          <input type="hidden" value='<?php if(isset($_GET['status']))echo $_GET['status'] ?>' name='status'/>
				   <button class="btn btn-primary addBtn dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
				   <ul class="dropdown-menu" role="menu" id="export-menu">
				   <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
				   </ul>
               </form>
            </div>  
		   <a href="<?php echo base_url();?>hrm/task_list_workers">
		 <input type="button" name="submitSearchReset" class="btn btn-primary addBtn btn-outline-secondary" value="Reset"></a> 
		 
		 </div>
         
         <div class="Filter Filter-btn2"> 
  <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo" aria-expanded="true"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button> 
  <div id="demo" class="collapse" aria-expanded="true" style="">
     <div class="col-md-12 datePick-left">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="">
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url();?>hrm/task_list_workers" method="get" id="date_range">
               <input type="hidden" value="" class="start_date" name="start">
               <input type="hidden" value="" class="end_date" name="end">
			   <input type="hidden" value='' id='hidden-type' name='ExportType'/>
            </form>
         </div>
         <form action="<?php echo base_url();?>hrm/task_list_workers" method="get">  
     <div class="col-md-12">
          <label class="col-md-12" style="padding:8px;">Assigned To</label>
            <div class="col-md-12">
               <select class="form-control selectAjaxOption select2" name="assigned_to" data-id="user_detail" data-key="id" data-fieldname="name" width="100%"  data-where="c_id=<?php echo $_SESSION['loggedInUser']->c_id;?> and is_activated=1" onchange="getSupervisorName(this.value)" ></select>
            </div>
    </div>
	<div class="col-md-12">
          <label class="col-md-12" style="padding:8px;">Status</label>
            <div class="col-md-12">
                 <select class="form-control" name="status">
				  <option value="">Select</option>
				 <option value="completed">Completed</option></select>
            </div>
    </div>
<br><br>
  <div class="col-md-12" style="padding: 20px;">
    <input type="submit" class="form-control col-md-12" name="importe" value="Submit">
  </div>  
   </form>
    </div>
  </div>
         
    <table class="table table-striped table-bordered account_index" cellspacing="0" width="100%">
      <thead>
         <tr>
            <th>ID 
            <span>
             <a href="<?php echo base_url(); ?>hrm/task_list_workers?sort=asc" class="up"></a>
             <a href="<?php echo base_url(); ?>hrm/task_list_workers?sort=desc" class="down"></a>
           </span>
           </th>
            <th>Assigned To 
            <span>
             <a href="<?php echo base_url(); ?>hrm/task_list_workers?sort=asc" class="up"></a>
             <a href="<?php echo base_url(); ?>hrm/task_list_workers?sort=desc" class="down"></a>
           </span>
           </th>
            <th>Task Name 
            <span>
             <a href="<?php echo base_url(); ?>hrm/task_list_workers?sort=asc" class="up"></a>
             <a href="<?php echo base_url(); ?>hrm/task_list_workers?sort=desc" class="down"></a>
           </span>
            </th>
            <th>Task Description </th>
            <th>Status</th>
            <th>Due date and time</th>
            <th>Aging Option</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php  
       // $filter_task_list_data = $this->session->userdata('task_list_date_range');     
       //       $new_work_detail_filter  =   $filter_task_list_data['new_work_detail'];
       //        $work_detail ;
              
       //         if(!empty($filter_task_list_data)){
       //             $work_detail = $new_work_detail_filter;
                   
       //         }else{
       //              $work_detail = $new_work_detail;
       //         }
                  
      //  if(!empty($work_detail)){
         ?>
         <?php $k=1;
         foreach($work_detail as $value){ ?>
         <tr>
            <!-- </?php 	$owner = getNameById('user_detail',$value->assigned_to,'u_id');  ?>-->
             <?php 	$owner = getNameById('user_detail',$value['assigned_to'],'id');  ?> 
             <td><?php echo  $value['id'];?></td>
            <td><?php echo @ $owner->name ?></td>
            <td><?php echo $value['task_name']; ?></td>
            <td><?php echo $value['description']; ?></td>
            <?php $status = getNameById('task_list_status',$value['pipeline_status'],'id');  ?>
            <td><?php if(!empty($status->name)){ echo $status->name;  } ?></td>
            <td><?php if(!empty($value['due_date']) && $value['due_date']!='0000-00-00 00:00:00' && $value['due_date']!=null){echo date('d-m-Y',strtotime($value['due_date']));} ?></td>
            <?php  
             $due_date  = date('Y-m-d', strtotime($value['due_date']));
             $todays_date = date('Y-m-d');
            
            $date1 = new DateTime($todays_date);
            $date2 = new DateTime($due_date);
            $interval = $date1->diff($date2);
            ?>
            <td><?php  if(($status->name=='Completed')){echo '0 days';}elseif(!empty($value['due_date']) && $value['due_date']!='0000-00-00 00:00:00' && ($date1>$date2)){echo $interval->d." days ";}else {echo '0 days';} ?></td>

             <td data-label="action:" class="jsgrid-align-center action">
			  <i class="fa fa-cog" aria-hidden="true"></i>
				  <div class="on-hover-action">
               <?php echo  '<a href="javascript:void(0)" id="'.$value['id'].'" data-id="AddTask"  class="hrmTab btn btn-edit  btn-xs" id="'.$value['id'].'">Edit</a>'; ?>
               <?php  echo '<a href="javascript:void(0)"  class="delete_listing
                  btn btn-delete btn-xs" data-href="'.base_url().'hrm/delete_new_work_detail/'.$value['id'].'" >Delete</a>';?>
				 </div>
            </td>

          </tr>
             <?php 
                    $output[] = array(
                        'ID'=>$value['id'],
                        'Assigned to ' =>@ $owner->name,
                        'Task Name' => $value['task_name'] ,
                        'Description' => $value['description'],
                        'Status' => @ $status->name ,
                        'Start Date' => !empty($value['start_date']) && ($value['start_date']!='0000-00-00 00:00:00')?$value['start_date']:'',
                       // 'Aging ' =>  !empty($value['due_date']) && ($value['due_date']!='0000-00-00 00:00:00')?$interval->d:'',
                       
                        );
                         ?>
            <?php $k++;}
				if(!empty($output)){
                        $data3  = $output;
                        export_csv_excel($data3);
				}				
                     //   $this->session->unset_userdata('task_list_date_range');
						
		 //}			
                        ?>
      </tbody>
   </table>
			<?php echo $this->pagination->create_links();?>
       <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true"
       aria-label="Show more messages" style="user-select: none;">
       <?php echo $result_count; ?></span></div>
		</div>                      

	<div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="profile-tab3">
		
      <div class="export">
	  <a href="<?php echo base_url();?>hrm/empty_task_list" class="btn btn-primary addBtn">Empty PipeLine</a>
      <button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="AddTask">Add Task</button>
      </div>
	  
	  <div class="Filter Filter-btn2">
	  <div class="form-search">
       <div class="col-md-2 col-sm-2 col-xs-2"><label>Assigned To:</label></div>
        <div class="col-md-6 col-sm-6 col-xs-6">
      <form action="<?php echo base_url().'hrm/task_list_workers'?>" method="get" style="width: 83%;float: left;" class="ceracl-img">
      <select class="form-control selectAjaxOption select2" id="workersID" name="assigned_to" data-id="user_detail" data-key="id" data-fieldname="name" width="100%" data-where="c_id=<?php echo $_SESSION['loggedInUser']->c_id;?> and is_activated=1" onchange="this.form.submit()" ></select>
      <input type="hidden" name="status" value=""/>
      </form>
      <a href="<?php echo base_url(); ?>hrm/task_list_workers" style=" width: 19%; float: right; ">
        <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"  ></a>
    </div>
	</div>
	</div>

<div class="x_content" style="overflow:auto;">
   <div class="container-fluid" style="">
      
<?php 

if(isset($processdata)){ ?>
      <div class="dragg2">
      <div id="sortableKanbanBoards" class="row">
            <?php 
				$i= 0;
               foreach($processdata as $process_data){
				
                $pipeline_id    = $process_data['types']['id'];             
               $rows_returned =   $this->hrm_model->get_transition_data('transition_authority',$pipeline_id); 
               if(isset($rows_returned)){
               $col_id = $rows_returned->col_id;
               $role = $rows_returned->role;          
               $rows_returned2 =   $this->hrm_model->get_transition_data('transition_tasklist',$pipeline_id);
               $active_inactive_status_json = $rows_returned2->status;
               $active_inactive_status_arr =  json_decode($active_inactive_status_json);

                          if(isset($active_inactive_status_arr)){
                          foreach($active_inactive_status_arr as $key2 =>$val2)
                               {

                               }
                               
                          }
                  }
               ?>

            

            <div class="panel panel-primary kanban-col" id="leadStyatus_<?php  echo $i; ?>" data-name="<?php echo $process_data['types']['name'];?>">

               <div class="panel-heading">

                  <input type="hidden" class='totalprice' value='<?php //echo count($process_data['process']); ?>'/>

                  <?php echo $process_data['types']['name'];?><span style="text-align:  left;" class="total11">
            
                  </span>

                  <i class="fa fa-2 fa-chevron-up pull-right process"></i>

               </div>

               <div class="panel-body " style="height: 100px;" >
            

                  <div id="<?php echo $process_data['types']['id'];?>" class="kanban-centered">

              

                     <?php  foreach($process_data['process'] as $pd){

                         

                      //  $usern = getNameById('user_detail',$pd['assigned_to'],'u_id');
                        $usern = getNameById('worker',$pd['assigned_to'],'id');

                       $data =        $this->hrm_model->get_data('worker', [
                                                            'worker.created_by_cid' => $this->companyGroupId,
                                                            'worker.active_inactive' => 1,
                                                            'worker.id' => $pd['assigned_to'],
                                                           
                                                        ]);
														
												

                     //   $data = $this->hrm_model->get_active_user($this->companyGroupId,$pd['assigned_to']);

                         if(!empty($data)){ $can_drag = 'draggable ="true"';?>

                    

                     <article class="kanban-entry grab process" id="<?php echo $pd['id'];?>"   <?php echo $can_drag; ?> data-id="<?php echo @ $pd['order_id'];?>">
                        <div class="kanban-entry-inner">
                           <div class="kanban-label" style="cursor: -webkit-grab;">

                              <h2>
                                  <a href="javascript:void(0)" id="<?php echo $pd["id"]; ?>" data-id="AddTask" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs pull-right"><i class="fa fa-pencil"></i>  </a>
 
                              <button type="button" data-id="view_new_workdetails" data-tooltip="View" class="hrmTab btn btn-view  btn-xs pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-eye"></i></button>

                            </h2>

                              <p>Job Name: <?php echo $pd['task_name'];?></p>
                              <p><?php echo $pd['description'];?></p>
                           <?php //  foreach($comments as $task_comment){
                            $comment=getCommentById('new_work_details_comments',$pd['id'],'new_work_detail_id');
                          echo  (!empty($comment))? '<p class="ee">Comments:'.$comment[0]->comments.'</p>':'';
                            /*foreach ($comment as $value) {
                              echo (!empty($value))?$value->comments:'';
                            }*/
                            

                              //echo '<p class="ee">Comments:'.$task_comment->comments[0].'</p>';
                          //  }
                              ?>
<!--                               
 -->                           </div>
                        </div>
                     </article>
                     <?php 

                       }  }

                     ?>     
                  </div>
               </div>
               <div class="panel-footer">
                  <a href="#"></a>
               </div>
            </div>
            <?php $i++;}  ?>   
         </div>
      </div>
   <?php }?>
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
				<h4 class="modal-title" id="myModalLabel">PipeLine</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>