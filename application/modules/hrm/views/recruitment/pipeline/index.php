

<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
<div class="x_content" style="overflow:auto;">
   <p class="text-muted font-13 m-b-30"></p>
   <div class="container-fluid" style="">
      <form method="post" action="<?php echo base_url() ?>hrm/job_position_pipeline/">
         <div class="col-md-6 col-sm-6 col-xs-6 ">
            <div class="item form-group">
               <label class="col-md-1 col-sm-1 col-xs-1">Job Position</label>
               <div class="col-md-2 col-sm-2 col-xs-2">
                  <select class="form-control col-md-4 col-xs-8"  name="job_position_id">
                     <option>Select</option>
                     <?php foreach($job_position as $job){?>
                     <option value="<?php echo $job['id']; ?>" ><?php echo $job['designation']; ?></option>
                     <?php }?>
                  </select>
               </div>
               <div class="col-md-2 col-sm-2 col-xs-2">
                  <input type="submit" class="btn" value="Search">
               </div>
            </div>
         </div>
      </form>
      <br>
      <div class="dragg">
         <div id="sortableKanbanBoards" class="row">
            <?php 
               if(!empty($processdata)){
                 $i= 0;
               foreach($processdata as $process_data){ ?>
     
            <div class="panel panel-primary kanban-col" id="leadStyatus_<?php  echo $i; ?>" data-name="<?php echo $process_data['types']['status'];?>">
               <div class="panel-heading">
			          <input type="hidden" name="status" id="status" value="<?php echo $process_data['types']['status'];?>"/>
                  <?php echo $process_data['types']['status'];?><span style="text-align:  left;" class="total11">
                  </span>
                  <i class="fa fa-2 fa-chevron-up pull-right process"></i>
               </div>
               <div class="panel-body" style="height: 100px;" >
                  <div id="<?php echo $process_data['types']['id'];?>" class="kanban-centered">
                     <?php  if(!empty($process_data['process'])){
					 foreach($process_data['process'] as $pd){?>
                     <article class="kanban-entry grab process" id="<?php echo $pd['id'];?>" draggable="true" data-id="<?php //echo $pd['order_id'];?>">
                        <div class="kanban-entry-inner">
                           <div class="kanban-label" style="cursor: -webkit-grab;">
                              <h2>
							  <?php //pre()
							  if($pd["status"] == 5 || $pd["status"] == 6 || $pd["status"] == 7 ){ ?>
							  <div class="refresh" >
                                 <button type="button" data-id="RateJobApplication" data-tooltip="Rate Applicant" class="btn btn-view btn-xs hrmTab pull-right" data-toggle="modal"  data-id="<?php echo $pd["id"]; ?>" id="<?php echo $pd["id"]; ?>"><i class="fa fa-pencil"></i></button></div>
								   <?php  }else{ ?>
								   <div class="refresh" style="display: none;">   <button type="button" data-id="RateJobApplication" data-tooltip="Rate Applicant" class="btn btn-view btn-xs hrmTab pull-right" data-toggle="modal"  data-id="<?php echo $pd["id"]; ?>" id="<?php echo $pd["id"]; ?>"><i class="fa fa-pencil"></i></button></div>
								   <?php } ?>
                                 <button type="button" data-id="viewJobApplication" data-tooltip="View" data-id="<?php echo $pd["id"]; ?>" class="btn btn-edit btn-xs hrmTab pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-eye"></i></button>
                              </h2>
                              <p><?php echo  $pd['name'];?>
                                 <?php if($process_data['types']['status']=='Contract proposal'){
									 if($pd['email']!='')
									 {
                                    $chk=$this->hrm_model->chk_usr('user','email',$pd['email']);
                                    
                                    echo $pd['email'];
                                    echo $chk;
                                    if($chk=='1'){?>
                                 <button type="button" class="btn btn-warning">Converted</button>
									 <?php }else { ?>
                                 <button type="button"  data-id="convertUser" class="btn btn-warning hrmTab" data-toggle="modal"  id="<?php echo $pd["id"]; ?>">Convert to User</button>
                                 <?php }}else
								 {?>
				<button type="button"  data-id="convertUser" class="btn btn-warning hrmTab" data-toggle="modal"  id="<?php echo $pd["id"]; ?>">Convert to User</button>
			 <?php	 }
							 }?>
                              </p>
                           </div>
                        </div>
                     </article>
                     <?php } } ?>     
                  </div>
               </div>
               <div class="panel-footer"> <a href="#"></a>
               </div>
            </div>
            <?php 
               $i++;
                 } 
               } ?>   
         </div>
      </div>
   </div>
</div>
<div class="clearfix"></div>
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
<div class="modal fade in" id="convertUser_modal"  role="dialog" >
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title" id="myModalLabel">Add User</h4>
            </div>
			<div class="modal-body-content">fdgfg</div>
			
      </div>
   </div>
</div>
<div id="hrm_modal" class="modal fade in"  role="dialog">
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title nxt_cls" id="myModalLabel">Job Details</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>

