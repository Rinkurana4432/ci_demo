
<?php
 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
    <?php if($this->session->flashdata('message') != ''){ ?>
        <div class="alert alert-info col-md-12">
         <?php echo $this->session->flashdata('message');?>
        </div>
    <?php }?> 
            <div class="x_content">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Pipeline</a> </li>
                        <li role="presentation"><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Transition</a> </li>
                        <li role="presentation"><a href="#tab_content3" role="tab" id="profile-tab1" data-toggle="tab" aria-expanded="false">Roles</a> </li>
                        <li role="presentation"><a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Sprint Duration</a> </li>
                        <li role="presentation"><a href="#tab_content5" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">New Task</a> </li>
                             </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active " id="tab_content1" aria-labelledby="home-tab">
                            <p class="text-muted font-13 m-b-30"></p>
                           <div class="pull-left">
                                <div class="col-md-4 col-sm-12 datePick-right"> <?php if($can_add) {
         echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="AddTaskListStatus">Add Task List Status</button>';
         } ?></div>
          </div>
                           
                     <div class="dragg">
         <div id="sortableKanbanBoards" class="row">
         
            <!--sütun başlangıç-->
            <div class="panel panel-primary kanban-col" id="leadStyatus_<?php  echo $i; ?>" data-name="<?php echo"test"; ?>">
               <div class="panel-heading">
                  <input type="hidden" class='totalprice' value='<?php //echo count($process_data['process']); ?>'/>
                  <?php echo $process_data['types']['name'];?><span style="text-align:  left;" class="total11">
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
                               <p>Job Name: <?php echo $process_data->name;?></p>
                              <button type="button" data-id="AddTaskListStatus" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs pull-right" data-toggle="modal" id="<?php echo $process_data->id;?>"><i class="fa fa-pencil"></i></button>
                          <?php  echo '<a   data-tooltip="Delete" class="delete_listing  btn btn-delete btn-xs" data-href="'.base_url().'hrm/deleteTaskListStatus/'.$process_data->id.'" ><i class="fa fa-trash"></i></a>';?>
                 

                           </div>
                        </div>
                     </article>
                       </div>
                      </div>
                     <?php 
                             
                       }  
                     ?>     
                
               
               <div class="panel-footer">
                  <a href="#"></a>
               </div>
            </div>
            <?php 
               $i++;
               
               
               
                 }	
               
               
               
               
               
                  ?>   
         </div>
      </div>        
                            
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab"></div>
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
            <th>  </th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($role as $value): ?>
         <tr>
            <td data-label="name:"><?php echo $value->name ?></td>
             <td data-label="action:" class="jsgrid-align-center ">
               <?php echo  '<a href="javascript:void(0)" id="'. $value->id . '" data-id="AddRole" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs" id="' . $value->id . '"><i class="fa fa-pencil"></i>  </a>'; ?>
               <?php  echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
                  btn btn-delete btn-xs" data-href="'.base_url().'hrm/deleteHoliday/'.$value->id.'" ><i class="fa fa-trash"></i></a>';?>
            </td>
            <td> <?php echo  '<a href="javascript:void(0)" id="'. $value->id . '" data-id="AddRole_to_user_worker" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs" id="' . $value->id . '"><i class="fa fa-pencil"></i>  </a>'; ?>  </td>
         </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
         
         
          </div>
                            
                            
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab2"></div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab2">
                            
                            
                               <div class="pull-left">
                                <div class="col-md-4 col-sm-12 datePick-right"> <?php if($can_add) {
         echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="AddTask">Add Task</button>';
         } ?></div>
         
         
         
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
				<h4 class="modal-title" id="myModalLabel">PipeLine Status</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
<!--<div id="hrm_modal1" class="modal fade in"  role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Add Role</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>-->