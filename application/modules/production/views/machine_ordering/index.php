
<div id="sortableKanbanBoards" class="row">
	<div class="panel panel-primary kanban-col" style="width:100%">
		<div class="panel-heading">
           Machine order
         <i class="fa fa-2x fa-plus-circle pull-right"></i>
        </div>
            <div class="panel-body">
				<div id="TODO" class="kanban-centered">
					<?php if(!empty($machine_order)){
						  $i = 0;
						   foreach($machine_order as $MachineDetail){
							   $i++;
							?>
						<article class="kanban-entry grab machine_order" id="item<?php echo $i; ?>" data_machine_id="<?php echo $MachineDetail['id'];?>"  data_machine_order_id="<?php echo $MachineDetail['priority_order'];?>" draggable="true">
							<div class="kanban-entry-inner">
								<div class="kanban-label" data_machine_order_id="<?php echo $MachineDetail['priority_order'];?>">	
									<?php echo "<strong>Machine Id :</strong> ".$MachineDetail['id']." |                   
												<strong>Machine Name : </strong>".$MachineDetail['machine_name']. "|          
												<strong>Machine code : </strong>".$MachineDetail['machine_code']." |                  
												<strong>Make And Model : </strong>".$MachineDetail['year_purchase']." |                
												<strong>Placement Of machine : </strong>".$MachineDetail['placement']." |                
												<strong>Created Date: </strong>".$MachineDetail['created_date']; ?>
								</div>
							</div>
						</article>															
							<?php	} 
										} ?>
						
                    </div>
					
					
                </div>
            </div>
</div>
   <!-- Static Modal -->
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