<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/save_inspection_report" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
   <!--job card details-->
   <?php foreach($edit as $edit1){ ?>
   <input type="hidden" name="incId" value="<?php echo $edit1->id;?>" />
   <div class="col-md-12 col-sm-12 col-xs-12 ">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="parameter">Report Name <span class="required">*</span>
         </label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input id="para" class="form-control col-md-7 col-xs-12" name="report_name" value="<?php echo $edit1->report_name; ?>"  type="text" required>      
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="instrument">No. of Observation</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input id="ins" class="form-control col-md-7 col-xs-12 observations" name="observations"  value="<?php echo $edit1->observations; ?>"  type="number" >
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="expectation">Per Lot Of Observation</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input class="form-control col-md-7 col-xs-12" name="per_lot_of" value="<?php echo $edit1->per_lot_of; ?>"  type="number" >
         </div>
         <label class="col-md-1 col-sm-3 col-xs-12" for="expectation">UOM</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <select class="uom  form-control selectAjaxOption select2" name="uom"  width="100%" id="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" data-where="created_by_cid='0' || created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" >
               <option>Select</option>
               <?php foreach($uom as $data){?>
               <option value="<?php echo $data->id;?>" <?php if($data->id==$edit1->uom){echo 'Selected';}?>><?php echo $data->uom_quantity;?></option>
               <?php }?>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <div class="col-md-3 col-sm-3 col-xs-6">
            <label>Manufacturing</label>
         </div>
         <div class="col-md-2 col-sm-2 col-xs-6" id="ins_sel"  >
            <select class="workorder  form-control selectAjaxOption select2" name="workorder_id"  width="100%" id="sale_order" data-id="work_order" data-key="id" data-fieldname="workorder_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" >
               <option>Select</option>
               <?php foreach($get_workorder as $work){?>
               <option value="<?php echo $work['id'];?>" <?php if($work['id']==$edit1->workorder_id){echo 'Selected';}?>>
                  <?php echo $work['workorder_name'];?>
               </option>
               <?php }?>
            </select>
         </div>
         <div class="col-md-2 col-sm-2 col-xs-6" id="ins_sel"  >
            <select id="sel_job" class="form-control " name="job_card">
               <option value="<?php echo $edit1->job_card;?>"><?php echo $edit1->job_card;?></option>
            </select>
         </div>
         <div class="col-md-2 col-sm-2 col-xs-6">
            <select id="sel_process" class="form-control" name="process_id">
               <?php $proc_nam = getNameById('add_process', $edit1->process_id,'id');?>
               <option value="<?php echo $edit1->process_id;?>"><?php if(!empty($proc_nam)){ echo $proc_nam->process_name;}?></option>
            </select>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6">
            <select id="process_machine" class="form-control" name="machine_id">
               <?php $add_machine = getNameById('add_machine', $edit1->machine_id,'id');?>
               <option value="<?php echo $add_machine->machine_id;?>"><?php if(!empty($add_machine)){ echo $add_machine->machine_name;}?></option>
            </select>
         </div>
      </div>
   </div>
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
   <div class="machineData"></div>
   <div class="machineParameter"></div>
   <center>
         <label for="pass" class="btn edit-end-btn">
         <input type="radio" name="final_report" id="pass" value="1" <?php if($edit1->final_report == '1'){echo 'checked';} ?> >Pass</label>
         <label for="fail"  class="btn edit-end-btn">
         <input type="radio" name="final_report" id="fail" value="2" <?php if($edit1->final_report == '2'){echo 'checked';} ?> >Fail</label>
   </center>
   <center>
      <div class="modal-footer">
         <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>                       
         <input type="submit" class="btn btn edit-end-btn " value="Submit">
      </div>
   </center>
   <?php }?>
</form>