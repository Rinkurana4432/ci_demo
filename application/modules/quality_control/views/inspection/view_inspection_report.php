<form class="form-horizontal"  enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
<div id="print_divv">
   <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="parameter">Report Name 
         </label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php echo $edit->report_name; ?>
         </div>
         <label class="col-md-2 col-sm-2 col-xs-12" for="expectation">Manufacturing Date</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php echo date('d-m-Y',strtotime($edit->created_date)); ?>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="instrument">No. of Observation</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php echo $edit->observations; ?>
         </div>
         <label class="col-md-2 col-sm-2 col-xs-12" for="expectation">Inspection date</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php 
               if( isset($edit->created_date) ){
                  echo date('d-m-Y',strtotime($edit->created_date)); 
               }
            ?>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="expectation">Per Lot Of Observation</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php echo $edit->per_lot_of; ?>
         </div>
         <label class="col-md-2 col-sm-3 col-xs-12" for="expectation">UOM</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php foreach($uom as $data){?>
            <?php if($data->id==$edit->uom){ echo $data->uom_quantity; }}?>
         </div>
      </div>
      <div class="item form-group">
         <div class="col-md-3 col-sm-3 col-xs-6">
            <label>Manufacturing:-</label>
         </div>
      </div>
      <div class="item form-group">
         <div class="col-md-3 col-sm-3 col-xs-6">
            <label>Work Order</label>
         </div>
         <div class="col-md-3 col-sm-3 col-xs-6" id="ins_sel">
            <?php foreach($get_workorder as $work){
               if( isset($edit->workorder_id) ) {
                  if($work['id'] == $edit->workorder_id ) { echo $work['work_order_no']; }
               }
             }?>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <div class="col-md-3 col-sm-3 col-xs-6">
            <label>JobCard</label>
         </div>
         <div class="col-md-3 col-sm-3 col-xs-6" id="ins_sel"  >
            <?php echo $edit->job_card;?>
         </div>
      </div>
      <div class="item form-group">
         <div class="col-md-3 col-sm-3 col-xs-6">
            <label>Process</label>
         </div>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($edit->process_id)){
               $proc_nam = getNameById('add_process', $edit->process_id,'id');
               if(!empty($proc_nam)){echo $proc_nam->process_name;}}?>
         </div>
      </div>
      <div class="item form-group">
         <div class="col-md-3 col-sm-3 col-xs-6">
            <label>Machine Name</label>
         </div>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php if(!empty($edit->machine_id)){
               $proc_nam = getNameById('add_machine', $edit->machine_id,'id');
               if(!empty($proc_nam)){echo $proc_nam->machine_name;}}?>
         </div>
      </div>
      <?php if(!empty($edit->comment)){?>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="instrument">Comments</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php echo $edit->comment; ?>
         </div>
      </div>
      <?php } ?>
   </div>
   <div class="machineData"></div>
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
      <table id="example" class="table table-striped table-bordered" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
         <thead>
            <tr>
               <th>Sno.</th>
               <th>Parameters</th>
               <th>Instrument</th>
               <th>Uom</th>
               <th>Expectation</th>
               <th>Deviation minimum</th>
               <th>Deviation maximum</th>
               <th>Expectation with minimum Deviation</th>
               <th>Expectation with maximum Deviation</th>
               <th>Result</th>
               <th>Remark</th>
               <th>Pass/Fail</th>
            </tr>
         </thead>
         <tbody id="table_data">
            <?php $i=1;
            foreach($trans as $key => $val){
               ?>
            <tr>
               <td><?php echo $i; ?></td>
               <td>
                  <?= $val->parameter;?>
               </td>
               <td>
                  <?php foreach($ins as $value){
                     if($value['id']==$val->instrument){ echo $value['name']; } 
                     //echo $val->instrument;
                  } ?> 
               </td>
               <td>
                  <?php foreach($uom as $umoVal){?>
                    <?php if($umoVal->id==$val->uom1){ echo $umoVal->uom_quantity; } ?></option>
                  <?php } ?>
                  </select>
               </td>
               <td>
                  <?= $val->expectation; ?>
               </td>
               <td>
                  <?php echo $val->deviation_min; ?>
               </td>
               <td>
                  <?php echo $val->deviation_max; ?>
               </td>
               <td>
                  <?php echo $val->exp_min_dev; ?>
               </td>
               <td>
                  <?php echo $val->exp_max_dev; ?>
               </td>
               <td><?php echo $val->result; ?></td>
               <td><?php echo $val->remark; ?></td>
               <td>
                  <?php if( isset($val->pf) ){
                        echo ucfirst($val->pf);
                  } ?>
               </td>

            </tr>
            <?php $i++;}?>
         </tbody>
      </table>
      <?php if(  isset($edit->final_report ) ) { ?>
      <center>
         <label for="pass" class="btn edit-end-btn">
         <input type="radio" name="final_report" id="pass" checked />
            <?php if( $edit->final_report == 1  ){ echo 'Pass'; }else{ echo 'Fail'; } ?>
         </label>
      </center>
   <?php } ?>
   </div>
   <center>
      <div class="modal-footer">
          <?php $edit->machine_id = $edit->machine_id??'';
                $edit->job_card = $edit->job_card??'';
                $edit->process_id = $edit->process_id??'';

           ?>
          <?php $url = "id={$edit->id}&jobCard={$edit->job_card}&processId={$edit->process_id}&machineId={$edit->machine_id}"; ?>
          <button type="button"  class="btn edit-end-btn hidden-print"  ><a class="edit-end-btn" target="_blank" href="<?= base_url('quality_control/qualityInspationReportPdf?').$url; ?>">PDF</a></button>
         <button type="button"  class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
         <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
      </div>
   </center>
</div>
</form>