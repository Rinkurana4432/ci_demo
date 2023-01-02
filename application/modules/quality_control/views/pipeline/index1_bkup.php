 
<?php if($this->session->flashdata('message') != ''){?>                        
    <div class="alert alert-success col-md-6">                            
      <?php echo $this->session->flashdata('message');?>
    </div>                        
<?php }?>


<div class="x_content" style="overflow:auto;">
<p class="text-muted font-13 m-b-30"></p>    
<div class="container-fluid" style="">
<div class="dragg">
    <div id="sortableKanbanBoards" class="row">
<?php 
  if(!empty($processdata)){
    $i= 0;
  foreach($processdata as $process_data){ ?>
  <input type="hidden" name="status" id="status" value="<?php echo $process_data['types']['status'];?>"/>
            <div class="panel panel-primary kanban-col" id="leadStyatus_<?php  echo $i; ?>" data-name="<?php echo $process_data['types']['status'];?>">
                <div class="panel-heading">
            <?php echo $process_data['types']['status'];?><span style="text-align:  left;" class="total11">
            </span>
            <i class="fa fa-2 fa-chevron-up pull-right process"></i>
                </div>
                <div class="panel-body" style="height: 100px;" >
                    <div id="<?php echo $process_data['types']['id'];?>" class="kanban-centered">
                         <?php  foreach($process_data['process'] as $pd){?>
                        <!--<article class="kanban-entry grab process" id="<?php //echo $pd['order_id'];?>" draggable="true" data-id="<?php //echo $pd['id'];?>">-->
                        <article class="kanban-entry grab process" id="<?php echo $pd['id'];?>" <?php	if($process_data['types']['status']==='inspection_fail'||$process_data['types']['status']==='controlled_fail'){?>draggable="true"<?php }?> data-id="<?php //echo $pd['order_id'];?>">
                            <div class="kanban-entry-inner">
                                <div class="kanban-label" style="cursor: -webkit-grab;">
                  <h2><?php	if($process_data['types']['status']==='inspection_fail'||$process_data['types']['status']==='inspection_corrected')
		{?><button type="button" data-id="ViewInspectionReport" data-tooltip="View" data-id="<?php echo $pd["id"]; ?>" class="btn btn-edit btn-xs qualityTab pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-pencil"></i></button>
       <?php } else{?>
       <button type="button" data-id="ViewControlledReport" data-tooltip="View" data-id="<?php echo $pd["id"]; ?>" class="btn btn-edit btn-xs qualityTab pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-pencil"></i></button>
       <?php }?></h2>
                    <p><?php  echo $pd['report_name'];?><br>
                    Comment:<?php if(isset($pd['comment'])) echo $pd['comment'];?></p>
                                </div>
                            </div>
                        </article>
        <?php }?>     
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
 <div class="modal modal-static fade" id="comment" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-refresh fa-5x fa-spin"></i>
                        <form method="post" action="<?php echo base_url();?>quality_control/add_comment">
                            <input type="hidden" name="status" id="status" value="<?php echo $process_data['types']['status'];?>"/>
                            <input type="hidden" name="id" id="id" value=""/>
                            <h4>Comment</h4>
                        <textarea class="form-control col-md-7 col-xs-12" name="comment" ></textarea>
                        <input type="submit" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
<div id="quality_modal" class="modal fade in"  role="dialog">
  <div class="modal-dialog modal-lg modal-large">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title nxt_cls" id="myModalLabel">Report</h4>
      </div>
      <div class="modal-body-content"></div>
    </div>
  </div>
</div>


