 
<?php if($this->session->flashdata('message') != ''){?>                        
    <div class="alert alert-success col-md-6">                            
      <?php echo $this->session->flashdata('message');?>
    </div>                        
<?php }?>

<div role="tabpanel" data-example-id="togglable-tabs">
			<ul id="myTab" class="nav nav-tabs" role="tablist">

				<li role="presentation" class="active "><a href="#inspection_report" role="tab" data-select="inspection" data-toggle="tab" id="inspection_tab" aria-expanded="true">Manufacturing</a></li>
				<li role="presentation" class="grn"><a href="#grn_report" id="grn_tab" role="tab" data-select="grn" data-toggle="tab" aria-expanded="false">GRN</a></li>
				<li role="presentation" class="pid"><a href="#pid_report" id="pid_tab" role="tab" data-select="pdi" data-toggle="tab" aria-expanded="false">PDI</a></li>
			</ul>
<div id="myTabContent" class="tab-content"> 
<div role="tabpanel" class="tab-pane fade active in" id="inspection_report" aria-labelledby="grn_tab">
<div class="x_content" style="overflow:auto;">
<p class="text-muted font-13 m-b-30"></p>    
<div class="container-fluid" style="">
<div class="dragg">
    <div id="sortableKanbanBoards" class="row">
<?php 
  if(!empty($processdata1)){
    $i= 0;
  foreach($processdata1 as $process_data){ ?>
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
                        <article class="kanban-entry grab process" id="<?php echo $pd['id'];?>" <?php if($process_data['types']['status']=='Quality Fail'){?>draggable="true"<?php }?> data-id="<?php //echo $pd['order_id'];?>">
                            <div class="kanban-entry-inner">
                                <div class="kanban-label" style="cursor: -webkit-grab;">
                  <h2><?php if($process_data['types']['status']=='Quality Pending'){?>
      <button type="button" data-id="EditInspectionReport" data-tooltip="Edit" data-id="<?php echo $pd["id"];?>" class="btn btn-edit btn-xs qualityTab pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-pencil"></i></button>
       <?php }else{?>
       <button type="button" data-id="ViewInspectionReport" data-tooltip="View" data-id="<?php echo $pd["id"]; ?>" class="btn btn-view btn-xs qualityTab pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-eye"></i></button>
       <?php }?>
       </h2>
                    <p><?php  echo $pd['report_name'];
					if($pd['workorder_id']!=''&& $pd['workorder_id']!=0)
					{
					$workorder_nam = getNameById('work_order',$pd['workorder_id'] ,'id');
					echo '-'.$workorder_nam->workorder_name;
					}?>  
                    </p>
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
</div>
 <div role="tabpanel" class="tab-pane fade" id="grn_report" aria-labelledby="grn_tab">
<div class="x_content" style="overflow:auto;">
<p class="text-muted font-13 m-b-30"></p>    
<div class="container-fluid" style="">
<div class="dragggrn">
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
                <div class="panel-body-grn" style="height: 100px;" >
               
                    <div id="<?php echo $process_data['types']['id'];?>" class="kanban-centered">
                         <?php  foreach($process_data['process'] as $pd){?>
                        <!--<article class="kanban-entry grab process" id="<?php //echo $pd['order_id'];?>" draggable="true" data-id="<?php //echo $pd['id'];?>">-->
                        <article class="kanban-entry grab process" id="<?php echo $pd['id'];?>" <?php if($process_data['types']['status']=='Quality Fail'){?>draggable="true"<?php }?> data-id="<?php //echo $pd['order_id'];?>">
                            <div class="kanban-entry-inner">
                                <div class="kanban-label" style="cursor: -webkit-grab;">
                  <h2><?php if($process_data['types']['status']=='Quality Pending'){?>
      <button type="button" data-id="AddGrn" data-tooltip="Edit" data-id="<?php echo $pd["id"];?>" class="btn btn-edit btn-xs qualityTab pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-pencil"></i></button>
       <?php }else{?>
       <button type="button" data-id="ViewGrn" data-tooltip="View" data-id="<?php echo $pd["id"]; ?>" class="btn btn-view btn-xs qualityTab pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-eye"></i></button>
       <?php }?>
       </h2>
                    <p><?php  echo $pd['report_name'];
					if($pd['material_id']!=''&& $pd['material_id']!=0)
					{
					$material_nam = getNameById('material',$pd['material_id'] ,'id');
					echo '-'.$material_nam->material_name;
					}?></p>
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
</div> 
 <div role="tabpanel" class="tab-pane fade " id="pid_report" aria-labelledby="pid_tab">
<div class="x_content" style="overflow:auto;">
<p class="text-muted font-13 m-b-30"></p>    
<div class="container-fluid" style="">
<div class="draggpdi">
    <div id="sortableKanbanBoards" class="row">
<?php 
  if(!empty($processdata2)){
    $i= 0;
  foreach($processdata2 as $process_data){ ?>
  <input type="hidden" name="status" id="status" value="<?php echo $process_data['types']['status'];?>"/>
            <div class="panel panel-primary kanban-col" id="leadStyatus_<?php  echo $i; ?>" data-name="<?php echo $process_data['types']['status'];?>">
                <div class="panel-heading">
            <?php echo $process_data['types']['status'];?><span style="text-align:  left;" class="total11">
            </span>
            <i class="fa fa-2 fa-chevron-up pull-right process"></i>
                </div>
                <div class="panel-body-pdi" style="height: 100px;" >
               
                    <div id="<?php echo $process_data['types']['id'];?>" class="kanban-centered">
                         <?php  foreach($process_data['process'] as $pd){?>
                        <!--<article class="kanban-entry grab process" id="<?php //echo $pd['order_id'];?>" draggable="true" data-id="<?php //echo $pd['id'];?>">-->
                        <article class="kanban-entry grab process" id="<?php echo $pd['id'];?>" <?php if($process_data['types']['status']=='Quality Fail'){?>draggable="true"<?php }?> data-id="<?php //echo $pd['order_id'];?>">
                            <div class="kanban-entry-inner">
                                <div class="kanban-label" style="cursor: -webkit-grab;">
                  <h2><?php if($process_data['types']['status']=='Quality Pending'){?>
      <button type="button" data-id="AddPid" data-tooltip="Edit" data-id="<?php echo $pd["id"];?>" class="btn btn-edit btn-xs qualityTab pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-pencil"></i></button>
       <?php }else{?>
       <button type="button" data-id="ViewPid" data-tooltip="View" data-id="<?php echo $pd["id"]; ?>" class="btn btn-view btn-xs qualityTab pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-eye"></i></button>
       <?php }?>
       </h2>
                    <p><?php  echo $pd['report_name'];
					if($pd['material_id']!=''&& $pd['material_id']!=0)
					{
					$material_nam = getNameById('material',$pd['material_id'] ,'id');
					echo '-'.$material_nam->material_name;
					}?></p>
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
			<div class="modal-header">
        <h4 class="modal-title nxt_cls" id="myModalLabel">Add Comment</h4>
      </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-commenting"></i>
                        <form method="post" action="<?php echo base_url();?>quality_control/add_comment">
                            <input type="hidden" name="status" id="status" value="<?php echo $process_data['types']['status'];?>"/>
                            <input type="hidden" name="id" id="id" value=""/>
							<input type="hidden" name="active_tab" id="active_tab" value=""/>
                            <h4>Comment</h4>
                        <textarea class="form-control col-md-7 col-xs-12" name="comment" ></textarea>
                        <br>
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
      <div class="modal-body-content">
	
	  
	  </div>
    </div>
  </div>
</div>


