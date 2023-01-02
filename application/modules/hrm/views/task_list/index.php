 

<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
<div class="x_content" style="overflow:auto;">
   <a href="<?php echo base_url();?>/hrm/work_detail/"><button class="btn btn-primary" data-toggle="modal">Add Job Detail</button></a>
   <p class="text-muted font-13 m-b-30"></p>
   <div class="container-fluid" style="">
      <form action="<?php echo base_url(); ?>hrm/task_list" method="post" style="display: inline-table;" class="ceracl-img">
         <button type="submit" class="btn btn-view  btn-xs" style="background: black; margin-bottom: 25px;">
         All
         </button>
      </form>
      <?php 
         if(!empty($user1)){
          foreach($user1 as $user){
         
            ?>
      <form action="<?php echo base_url(); ?>hrm/task_list" method="post" style="display: inline-table;" class="ceracl-img">
         <button type="submit" class="btn btn-view  btn-xs" style="background: black; margin-bottom: 25px;" title="<?php echo $user['name']; ?>">
         <?php // echo $user['name'];
            $words = explode(" ", $user['name']);
                      $acronym = "";
            
                      foreach ($words as $w) {
                        $acronym .= $w[0];
                      }
                    echo strtoupper($acronym);
                  
             ?>
         </button>
         <input type="hidden" name="user_id" value="<?php echo  $user['u_id'];?>">
      </form>
      <?php
         }
         
         }
         ?>
      <div class="dragg">
         <div id="sortableKanbanBoards" class="row">
            <?php 
               if(!empty($processdata)){
                 $i= 0;
               foreach($processdata as $process_data){
               //pre($process_data);
               
               ?>
            <!--sütun başlangıç-->
            <div class="panel panel-primary kanban-col" id="leadStyatus_<?php  echo $i; ?>" data-name="<?php echo $process_data['types']['name'];?>">
               <div class="panel-heading">
                  <input type="hidden" class='totalprice' value='<?php //echo count($process_data['process']); ?>'/>
                  <?php echo $process_data['types']['name'];?><span style="text-align:  left;" class="total11">
                  </span>
                  <i class="fa fa-2 fa-chevron-up pull-right process"></i>
               </div>
               <div class="panel-body" style="height: 100px;" >
                  <div id="<?php echo $process_data['types']['id'];?>" class="kanban-centered">
                     <?php  foreach($process_data['process'] as $pd){
                        // echo   count($pd['grand_total']); 
                        
                        ?>
                     <!--<article class="kanban-entry grab process" id="<?php //echo $pd['order_id'];?>" draggable="true" data-id="<?php //echo $pd['id'];?>">-->
                     <article class="kanban-entry grab process" id="<?php echo $pd['id'];?>" draggable="true" data-id="<?php //echo $pd['order_id'];?>">
                        <div class="kanban-entry-inner">
                           <div class="kanban-label" style="cursor: -webkit-grab;">
                              <h2><button type="button" data-id="editworkdetails" data-tooltip="Edit" data-id="<?php echo $pd["id"]; ?>" class="hrmTab btn btn-edit  btn-xs pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-pencil"></i></button>
                              <button type="button" data-id="viewworkdetails" data-tooltip="View" data-id="<?php echo $pd["id"]; ?>" class="hrmTab btn btn-view  btn-xs pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-eye"></i></button>
                              </h2>
                              <p>Job Name: <?php echo $pd['job_name'];?></p>
                              <p class="ee">Assigned To: <?php //echo $pd['work_assigned_to'];
                                 $usern = getNameById('user_detail',$pd['work_assigned_to'],'id');
                                 
                                 echo @ $usern->name;
                                 
                                 
                                 
                                 
                                 ?></p>
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
<!--<div id="1t" class="kanban-col"></div>
   <div id="2t" class="kanban-col"></div>
   <div id="3t" class="kanban-col"></div>
   <div id="4t" class="kanban-col"></div>
   <div id="5t" class="kanban-col"></div>
   <div id="6t" class="kanban-col"></div>-->
<!--<div id="kanban" class="container-fluid">
   <div class="row">
   <?php 
      /*if(!empty($processdata)){
      foreach($processdata as $process_data){
      ?>
     <div id="todo" data-id="<?php echo $process_data['types']['id']; ?>" class="col-sm-4">
       <div class="title">
         <h1 class="text-center"><?php echo $process_data['types']['process_type'];?></h1>
       </div>
       <div class="card-stack">
   
   	<?php foreach($process_data['process'] as $pd){
      ?>
   		<div>
   			<div class="card">
   				<?php echo $pd['process_name'];?>
   			</div>
   		</div>
   	<?php } ?>
        
      
       </div>
     </div>
   
   <?php }} */?>
   </div>
   
   </div>-->
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
<div id="hrm_modal" class="modal fade in"  role="dialog">
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title nxt_cls" id="myModalLabel">Work Details</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>

