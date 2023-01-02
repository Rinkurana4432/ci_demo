<div class="x_content">
   <div class="" role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
       <!--  <li role="presentation" class="active"><a href="#view" role="tab" id="dispatch_history" data-toggle="tab" aria-expanded="false">View Sale Order</a></li>
          <li role="presentation" class=""><a href="#ViewWorkorder" role="tab" id="ViewWorkorder_tab" data-toggle="tab" aria-expanded="false">View Work Order</a></li>
         <li role="presentation" class=""><a href="#dispatch_history" id="dispatch_history_tab" role="tab" data-toggle="tab" aria-expanded="true">Dispatch History</a></li>-->
      </ul> 
      
         
         
         <!-------------------tab leads------------------------------->
         
               <table id="datatable-buttons" style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3">
                  <thead>
                     <tr>
                        <th>Machine Name</th>
                        <th>Product Name</th>
                        <th>Process Name</th>
                        <th style="width: 120px;" >Actual Result</th>  
                        
                     </tr>
                  </thead>
                  <tbody>
                  
                        	 
                  </tbody>
                  <?php if (!empty($AddMachine)) { 
                      
                       $machine_id = getNameById('add_machine',$AddMachine['machine_id'],'id');
                       $add_process = getNameById('add_process',$AddMachine['process_id'],'id');
                       $process_type= getNameById('process_type',$add_process->process_type_id,'id');  
                       $data= json_decode($AddMachine['input_process']);
                       $material='';
                        ?>
                   <tr>

                      <td><?=$machine_id->machine_name;?></td>
                      <td><?=$process_type->process_type;?></td>
                     <td><?=$add_process->process_name;?></td>
                     <td><?php if ($AddMachine['final_report']==1) {   ?>

                      <button type="button" data-id="ViewInspectionReport" data-tooltip="View"  class="btn btn-view btn-xs qualityTab" data-toggle="modal"
                           id="<?php echo $AddMachine['id'];?>" jobCard="<?= @$AddMachine['job_card']??'' ?>" processId="<?= @$AddMachine['process_id']; ?>" machineId="<?= @$AddMachine['machine_id']; ?>" >Pass</button>



                    <!--   <button id="<?php echo $AddMachine['id'];?>" result="<?php echo $AddMachine['final_report'];?>" data-tooltip="View Result" class="btn btn-view btn-xs qualityTab" data-id="machineid">Pass</button>  -->
                    <?php  }elseif ($AddMachine['final_report']==2) { ?>
                   <button type="button" data-id="ViewInspectionReport" data-tooltip="View"  class="btn btn-view btn-xs qualityTab" data-toggle="modal"
                           id="<?php echo $AddMachine['id'];?>" jobCard="<?= @$AddMachine['job_card']??'' ?>" processId="<?= @$AddMachine['process_id']; ?>" machineId="<?= @$AddMachine['machine_id']; ?>" >Fail</button>

                      <!--  <button id="<?php echo $AddMachine['id'];?>" result="<?php echo $AddMachine['final_report'];?>"  data-tooltip="View Result" class="btn btn-view btn-xs qualityTab" data-id="ViewInspectionReport">Fail </button>  -->
                    <?php  } ?></td> 
                   </tr>
                <?php  }   ?>
               </table>
            
         <!-----------------------------end tab------------------------------------>
      
   </div>
</div>


  <div id="quality_modal" class="modal fade in" role="dialog">
      <div class="modal-dialog modal-lg modal-large">
        <div class="modal-content" style="display:table;">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Over View  </h4>
          </div>
          <div class="modal-body-content"></div>
        </div>
      </div>
    </div>