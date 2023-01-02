
<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-success col-md-6">                            
			<?php echo $this->session->flashdata('message');?>
		</div>                        
<?php }?>


<div class="x_content addProcess-2" style="overflow:auto;">
	
	<p class="text-muted font-13 m-b-30"></p>    
	<a href="<?php echo base_url();?>production/process_type/"><button class="btn btn-primary" data-toggle="modal"><i class="fa fa-plus-circle">&nbsp; Process Type</i></button></a>
	
	<button type="button" class="btn btn-primary editProcessName" data-toggle="modal" id="add"><i class="fa fa-plus-circle">&nbsp; Add processes</i></button>
	

<div class="container-fluid" style="clear:both;">
<div class="dragg">
        <div id="sortableKanbanBoards" class="row">
<?php 
  if(!empty($processdata)){
	foreach($processdata as $process_data){
		//pre($process_data);
		
		?>
            <!--sütun başlangıç-->
            <div class="panel panel-primary kanban-col">
                <div class="panel-heading">
						<?php echo $process_data['types']['process_type'];?>
                    <i class="fa fa-2 fa-chevron-up pull-right process"></i>
                </div>
                <div class="panel-body">
                    <div id="<?php echo $process_data['types']['id'];?>" class="kanban-centered">
				<?php foreach($process_data['process'] as $pd){
					

				?>
                        <!--<article class="kanban-entry grab process" id="<?php //echo $pd['order_id'];?>" draggable="true" data-id="<?php //echo $pd['id'];?>">-->
                        <article class="kanban-entry grab process" id="<?php echo $pd['id'];?>" draggable="true" data-id="<?php echo $pd['order_id'];?>">
                            <div class="kanban-entry-inner">
                                <div class="kanban-label">
                                    <!--<h2><a href="<?php //echo base_url() ?>production/Add_process/edit/<?php //echo $mat['id']; ?>"><i class="fa fa-pencil-square-o pull-right"></i></a></h2>-->
                                 <!--<h2><a href="<?php //echo base_url() ?>production/Add_process/edit/<?php //echo $pd['id']; ?>"><button class="btn btn-warning pull-right" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-pencil-square-o"></i></button></a></h2>-->
									<h2><button type="button" data-id="<?php echo $pd["id"]; ?>" class="btn btn-default btn-xs editProcessName pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>" data-tooltip="Edit"><i class="fa fa-pencil"></i></button>
						<?php if($pd['used_status'] ==1){?>						
						<a href="javascript:void(0)" data-tooltip="Delete" class="
						btn btn-delete btn-xs pull-right" data-href="<?php echo base_url(); ?>production/deleteProcess/<?php echo $pd["id"];?>" disabled="disabled"><i class="fa fa-trash"></i></a>
						<?php }else{?>
							<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
							btn btn-delete btn-xs pull-right" data-href="<?php echo base_url(); ?>production/deleteProcess/<?php echo $pd["id"];?>"><i class="fa fa-trash"></i></a>
						<?php } ?>
									</h2>
                                    <p><?php echo $pd['process_name'];?></p>
									
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
  }	}
   ?>   

        </div>
    </div>


  
	
</div>	
</div>

  

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

 
<div id="process" class="modal fade in"  role="dialog" style="overflow:hidden;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Add Process Type</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>