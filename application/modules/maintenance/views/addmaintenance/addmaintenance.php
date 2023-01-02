<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>maintenance/savebreakdown" enctype="multipart/form-data" id="similarmachine" novalidate="novalidate">
   <input type="hidden" name="id" value=""> 
   <input type="hidden" name="save_status" value="1" class="save_status">	
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser"> 
   <input type="hidden" name="requested_by" value="<?php echo $_SESSION['loggedInUser']->name; ?>" id="loggedUser"> 
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Machine Name</label>		
         <div class="col-md-6 col-sm-12 col-xs-12">
       
			<select class="form-control selectAjaxOption select2 select2-hidden-accessible get_machine_id_select select2" required="required" name="machine_id" data-id="add_machine" data-key="id" data-fieldname="machine_name" data-where="created_by_cid='<?php echo $_SESSION['loggedInUser']->c_id; ?>'" tabindex="-1" aria-hidden="true" >
               <option value="">Select option</option>
            </select>
         </div>
         
      </div>
      <script>
        /*<input type="hidden" name="machine_id" id="select_machine_id" value="">
		$('select.get_machine_id_select').change(function(){
         	    var machine_id = $(this).children('option:selected').data('id');
         	    $('#select_machine_id').val(machine_id);
          });
          */
      </script>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Problem Type</label>		
         <div class="col-md-6 col-sm-12 col-xs-12">
            <label class="radio-inline">
            <input type="radio" value="electronic" name="machine_type" checked>Electronic
            </label>
            <label class="radio-inline">
            <input type="radio" value="machnical" name="machine_type">Machnical
            </label>
            <label class="radio-inline">
            <input type="radio" value="electronic & machnical" name="machine_type">Both
            </label> 				
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Breakdown Causes</label>		
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input id="breakdown_couses" class="form-control col-md-7 col-xs-12" name="breakdown_couses" placeholder="Breakdown Causes" required="required" type="text" value=""> 				
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Priority</label>		
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control" name="priority">
               <option value="high">High</option>
               <option value="medium">Medium</option>
               <option value="low">Low</option>
            </select>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Assigned Worker</label>		
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible assign_worker select2" name="assign_worker" data-id="worker" data-key="id" data-fieldname="name" data-where="created_by_cid='<?php echo $_SESSION['loggedInUser']->c_id; ?>' AND worker_type='maintenance'" tabindex="-1" aria-hidden="true" >
               <option value="">Select option</option>
            </select>
         </div>
      </div>

   </div>  
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Required Time</label>		
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" name="required_time" class="form-control col-md-7 col-xs-12"  placeholder="Required Time" required="required" />
         </div>
      </div>
   </div>  

   <div class="form-group">
      <div class="col-md-6 col-md-offset-3">
         <button type="reset" class="btn btn-default edit-end-btn">Reset</button>
         <!--input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft"-->
         <button id="send" type="submit" class="btn edit-end-btn">Submit</button>
         <a class="btn edit-end-btn" onclick="location.href='<?php echo base_url();?>maintenance/breakdown'">Cancel</a>
      </div>
   </div>
</form>
<script>
   var measurementUnits = <?php echo json_encode(getUom()); ?>;
   var logged_user = <?php echo $_SESSION['loggedInUser']->c_id; ?>;				
</script>
<!---------------------add machine group on the spot---------------------------->	
<div class="modal left fade" id="myModal_Add_machine_group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="position:absolute;">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Machine Group</h4>
            <span id="mssg34"></span>
         </div>
         <form name="insert_worker_data" name="ins"  id="insert_worker_data_id">
            <div class="modal-body">
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Machine group<span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="machine_group_id" name="machine_group_name" required="required" class="form-control col-md-7 col-xs-12" value="">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <input type="hidden" id="add_machine_group_onthe_spot">
                  <button type="button" class="btn btn-default close_sec_model" >Close</button>
                  <button id="Add_group_details_on_button_click" type="button" class="btn edit-end-btn ">Submit</button>
               </center>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- /page content -->
<script>
   $(function() {
     $('input[name="required_time"]').daterangepicker({
       timePicker: true,
       startDate: moment().startOf('hour'),
       endDate: moment().startOf('hour').add(32, 'hour'),
       locale: {
         format: 'M/DD hh:mm A'
       }
     });
   });
</script>