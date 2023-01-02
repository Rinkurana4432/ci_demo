<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/save_inspection_report" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
   <!--job card details-->
   <input type="hidden" name="incId" value="" />
   <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="parameter">Report Name 
         <span class="required">*</span></label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input id="report" class="form-control col-md-7 col-xs-12" name="report_name" value="<?= 'Manifacture_Report_Name_'.getLastIdIncerment('inspection_report_master'); ?>"  type="text" required>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="instrument">No. of Observation</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input id="ins" class="form-control col-md-7 col-xs-12" name="observations" type="number" required >
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="expectation">Per Lot Of Observation</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input class="form-control col-md-7 col-xs-12" name="per_lot_of"  type="number" required >
         </div>
         <label class="col-md-1 col-sm-3 col-xs-12" for="expectation">UOM</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <select class="uom  form-control selectAjaxOption select2" name="uom"  width="100%" id="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" data-where="created_by_cid='0' || created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" >
               <option>Select</option>
               <?php foreach($uom as $data){?>
               <option value="<?php echo $data->id;?>"><?php echo $data->uom_quantity;?></option>
               <?php }?>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <div class="col-md-3 col-sm-3 col-xs-6">
            <label>Manufacturing</label>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6" id="ins_sel"  >
            <select class="workorder  form-control selectAjaxOption select2" name="workorder_id"  width="100%" id="sale_order" data-id="work_order" data-key="id" data-fieldname="workorder_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" >
               <option>Select</option>
               <?php foreach($get_workorder as $work){?>
               <option value="<?php echo $work['id'];?>"><?php echo $work['workorder_name'];?></option>
               <?php }?>
            </select>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6" id="ins_sel">
            <select class="jobcard  form-control selectAjaxOption select2" name="job_card"  width="100%" id="sel_job" data-id="job_card" data-key="id" data-fieldname="job_card_no" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" >
            </select>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6">
            <select id="sel_process" class="form-control" name="process_id">
               <option value="">Select process</option>
            </select>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6">
            <select id="process_machine" class="form-control" name="machine_id">
               <option value="">Select Machine</option>
            </select>
         </div>
      </div>
   </div>
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
   <div class="machineData"></div>
   <div class="machineParameter"></div>
   <center>
         <label for="pass" class="btn edit-end-btn">
         <input type="radio" name="final_report" id="pass" value="1" >Pass</label>
         <label for="fail"  class="btn edit-end-btn">
         <input type="radio" name="final_report" id="fail" value="2" >Fail</label>
   </center>
   <center>
      <div class="modal-footer">
         <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
         <input type="submit" class="btn btn edit-end-btn " value="Submit">
      </div>
   </center>
</form>