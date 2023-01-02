<div class="col-md-12">
   <?php if($this->session->flashdata('message') != ''){?>                        
   <div class="alert alert-success col-md-6">                            
      <?php echo $this->session->flashdata('message');?> 
   </div>
   <?php }?>
</div>
<div role="tabpanel" data-example-id="togglable-tabs">
   <ul id="myTab" class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#in_progress_tab" data-select='progress' id="complete_tab" role="tab" data-toggle="tab" aria-expanded="true">Breakdown</a></li>
      <li role="presentation" class="complte "><a href="#Complete_content_tab" role="tab" data-select='complete' id="auto_entery_tab" data-toggle="tab" aria-expanded="false">Preventive</a></li>
   </ul>
   <div id="myTabContent" class="tab-content">
      <div role="tabpanel" class="tab-pane fade active in" id="in_progress_tab" aria-labelledby="complete_tab">
         <div class="x_content">
            <div class="x_content" style="overflow:auto;">
               <p class="text-muted font-13 m-b-30"></p>
               <div class="container-fluid" style="">
                  <div class="dragg">
                     <div id="sortableKanbanBoards" class="row">
                        <?php 
                           if(!empty($processdata)){
                             $i= 0;
								foreach($processdata as $process_data){?>
								<!--sütun başlangıç-->
								<div class="panel panel-primary kanban-col" id="leadStyatus_<?php  echo $i; ?>" data-name="<?php echo $process_data['types']['name'];?>">
								   <div class="panel-heading">
									  <input type="hidden" class='totalprice' value='<?php //echo count($process_data['process']); ?>'/>
									  <?php echo $process_data['types']['name'];?><span style="text-align:  left;" class="total11">
									  </span>
									  <i class="fa fa-2 fa-chevron-up pull-right process"></i>
								   </div>
								   <div class="panel-body" style="height: 100px;" >
									  <div id="<?php echo $process_data['types']['Id'];?>" class="kanban-centered">
										 <?php  foreach($process_data['process'] as $pd){
											?>
										 <article class="kanban-entry grab process" id="<?php echo $pd['id'];?>" draggable="true" data-id="<?php //echo $pd['order_id'];?>">
											<div class="kanban-entry-inner">
											   <div class="kanban-label" style="cursor: -webkit-grab;">
												  <?php
													 echo '<h2><button id="'.$pd['id'].'" data-id="editpipline" data-tooltip="Edit" class="btn btn-view  btn-xs maintenanceTab pull-right" data-toggle="modal"><i class="fa fa-pencil"></i></button></h2>';
													 ?>
													<?php $machine = array();
														$machine = getNameById('add_machine', $pd['machine_id'],'id'); 
														?> 
												  <p><?php echo !empty($machine->machine_name)?$machine->machine_name:$pd['machine_name']; ?></p>
												  <p class="ee"><?php echo $pd['acknowledge'];?></p>
											   </div>
											</div>
										 </article>
										 <?php }?>     
									  </div>
								   </div>
								   <div class="panel-footer">
									  <a href="#"></a>
								   </div>
								</div>
                        <?php 
                           $i++;
                             }	
                           }
                       ?>   
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!----------complete tab--------->
      <div role="tabpanel" class="tab-pane fade" id="Complete_content_tab" aria-labelledby="complete_tab">
         <div class="x_content">
            <div class="x_content" style="overflow:auto;">
               <p class="text-muted font-13 m-b-30"></p>
               <div class="container-fluid" style="">
                  <div class="draggpreventive">
                     <div id="sortableKanbanBoards" class="row">
                        <?php
                           if(!empty($preventivedata)){
                             $i= 0;
							 
                           foreach($preventivedata as $process_data){
                           
                           
                           ?>
                        <!--sütun başlangıç-->
                        <div class="panel panel-primary kanban-col" id="leadStyatus_<?php  echo $i; ?>" data-name="<?php echo $process_data['preventivetypes']['name'];?>">
                           <div class="panel-heading">
                              <input type="hidden" class='totalprice' value='<?php //echo count($process_data['process']); ?>'/>
                              <?php echo $process_data['preventivetypes']['name'];?><span style="text-align:  left;" class="total11">
                              </span>
                              <i class="fa fa-2 fa-chevron-up pull-right process"></i>
                           </div>
                           <div class="panel-body" style="height: 100px;" >
                              <div id="<?php echo $process_data['preventivetypes']['Id'];?>" class="kanban-centered">
                                 <?php  foreach($process_data['prventiveprocess'] as $pd){
                                    ?>
                                 <article class="kanban-entry grab process" id="<?php echo $pd['id'];?>" draggable="true" data-id="<?php //echo $pd['order_id'];?>">
                                    <div class="kanban-entry-inner">
                                       <div class="kanban-label" style="cursor: -webkit-grab;">
                                          <?php
                                             if($pd['work_status'] == '4'){
                                              
                                               ?>
                                          <h2><button type="button" data-id="prepipeline" data-tooltip="View" data-id="<?php echo $pd["id"]; ?>" class="maintenanceTab btn btn-view  btn-xs pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-pencil"></i></button>
                                          </h2>
                                          <?php
                                             }else if($pd['work_status'] == '5'){
                                             
                                                ?>
                                          <h2><button type="button" data-id="prepipelinesedule" data-tooltip="View" data-id="<?php echo $pd["id"]; ?>" class="maintenanceTab btn btn-view  btn-xs pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-pencil"></i></button>
                                          </h2>
                                          <?php
                                             }else if($pd['work_status'] == '7'){
                                             
                                                ?>
                                          <h2><button type="button" data-id="prepipelinedone" data-tooltip="View" data-id="<?php echo $pd["id"]; ?>" class="maintenanceTab btn btn-view  btn-xs pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-pencil"></i></button>
                                          </h2>
                                          <?php
                                             }
                                             
                                             ?>
                                          <p><?php $machine_id = $pd['machine_id'];
                                             $machinedata = getNameById('add_machine', $machine_id, 'id');
                                             
                                             if(!empty($machinedata)){
                                             	echo $machinedata->machine_name;
                                             }
                                             
                                             ?></p>
                                          <p class="ee"><?php echo date('d-m-Y',strtotime($pd['end_time']));?></p>
                                       </div>
                                    </div>
                                 </article>
                                 <?php }?>     
                              </div>
                           </div>
                           <div class="panel-footer">
                              <a href="#"></a>
                           </div>
                        </div>
                        <?php 
                           $i++;
                           
                           
                           
                             }	
                           
                           
                           
                           
                           }
                              ?>   
                     </div>
                  </div>
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
   <div id="maintenance_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
      <div class="modal-dialog modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title" id="myModalLabel">Pipeline Details</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>