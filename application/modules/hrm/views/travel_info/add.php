<?php 
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/save_travel_info" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php if(!empty($travel_details)){ echo $travel_details->id; }?>">
   <input type="hidden" name="approve_status" value="<?php if(!empty($travel_details)){echo $travel_details->approve_status;}else{ echo '2'; }  ?>" > 
   <input type="hidden" name="created_by" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="loggedUser"> 
   <input type="hidden" name="u_id" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="loggedUser"> 
   <input type="hidden" name="created_by_cid" value="<?php echo $this->companyGroupId; ?>" > 
   <h3>Employee Details</h3>
   <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Employee Name<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
         <?php  if(!empty($travel_details->u_id)){    ?>       
          <?php $owner = getNameById('user_detail',$travel_details->u_id,'u_id'); ?>
                <?php }else{  ?>
            <?php  $owner = getNameById('user_detail',$_SESSION['loggedInUser']->u_id,'u_id');   }?>                                   
          <input class="form-control col-md-7 col-xs-12" readonly name="name" value="<?php if(!empty($owner)){ echo $owner->name;} ?>" type="text">      
          <!-- <input class="form-control col-md-7 col-xs-12" readonly name="name" value="<?php if(!empty($owner)){echo $owner->name;} ?>" type="text"> -->    
         <!--  <input class="form-control col-md-7 col-xs-12" readonly name="name" value="<?php // echo $_SESSION['loggedInUser']->u_id ?>" type="text">  -->  

         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Purpose Of Visit<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea name='Purpose_of_visit' required="required" class="form-control col-md-7 col-xs-12"><?php if(!empty($travel_details)){echo $travel_details->Purpose_of_visit;} ?></textarea>
         </div>
      </div>
   </div>
      <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">No Of Days</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
          <input  class="form-control col-md-7 col-xs-12" name="no_of_days" value="<?php if(!empty($travel_details)){echo $travel_details->no_of_days;} ?>" type="number">    

         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="container mt-3">
   <h3 class="Material-head">
      Travel Details
      <hr>
   </h3>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
   <div class="">
   <div class="">
   <div class="col-md-12 col-sm-12 col-xs-12 form-group input_travel middle-box">
      <?php if(empty($travel_details)){ ?>
      <div class="col-sm-12  col-md-12 label-box mobile-view2">
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>From<span class="required">*</span></label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>To</label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Start Date</label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>End Date</label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Mode</label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Cost</label></div>
      </div>
      <div class="well scend-tr mobile-view"  style="border-top: 1px solid;" id="chkIndex_1">
         <div class="col-md-2 col-sm-12 col-xs-12 item form-group">
            <label class="col-md-12">From<span class="required">*</span></label>                
            <input type="text" name="travel_from[]"  placeholder="Travel From" class="form-control col-md-7 col-xs-12" required="required" >

         </div>
         <div class="col-md-2 col-sm-12 col-xs-12 item form-group">
            <label class="col-md-12">To</label>
            <input type="text" name="travel_to[]"  placeholder="Travel To" class="form-control col-md-7 col-xs-12" required="required" >
         </div>
         <div class="col-md-2 col-sm-6 col-xs-12 form-group">
            <label class="col-md-12" >Start</label>
            <input type="text"  placeholder="Start Date" class="form-control has-feedback-left datePicker start_travel" name="start_date[]" id="fromDate_0" value="" >
            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            <span id="inputSuccess2Status3" class="sr-only">(success)</span>
         </div>        
       <div class="col-md-2 col-sm-6 col-xs-12 form-group">
            <label class="col-md-12" >End</label>
             <input type="text"  placeholder="End Date"  class="form-control has-feedback-left datePicker end_travel" name="end_date[]" id="toDate_0" value="" >
            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            <span id="inputSuccess2Status3" class="sr-only">(success)</span>

        </div>

         <div class="col-md-2 col-sm-6 col-xs-12 form-group">
            <label class="col-md-12">Mode Of Travel</label>
            <select name="travel_mode[]" class="form-control col-md-7 col-xs-12" >
            <option value="Roadways">Roadways</option>
            <option value="Railways">Railways</option>
            <option value="Airways">Airways</option>
            </select>
         </div>
         <div class="col-md-2 col-sm-6 col-xs-12 form-group">
            <label class="col-md-12">Cost</label>
            <textarea name="travel_cost[]" placeholder="Travel Cost" class="form-control col-md-7 col-xs-12" style="border-right:1px solid #c1c1c1 !important;"></textarea> 
         </div>
         <button class="btn btn-danger remove_travel" type="button"> <i class="fa fa-minus"></i></button>                  
      </div>
      <div class="col-sm-12 btn-row form-group" style="clear:both; margin-top:22px;">
         <button class="btn addMoreTravelDetails edit-end-btn" type="button" align="right">Add</button>
      </div>
      <?php } else{ 
         $travel_json = json_decode($travel_details->travel_details);
         ?>
        <div class="col-sm-12  col-md-12 label-box mobile-view2">
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>From<span class="required">*</span></label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>To</label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Start Date</label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>End Date</label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Mode</label></div>
         <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Cost</label></div>
      </div>
      <?php
         if(!empty($travel_json)){ 
               $i =  1;
               foreach($travel_json as $td){
               ?>
      <div class="well <?php if($i==1){ echo 'edit-row1 scend-tr mobile-view';}else{ echo 'scend-tr mobile-view';}?>"  id="chkWell_<?php echo $i; ?>" style="overflow:auto; ">
         <div class="col-md-2 col-sm-12 col-xs-12 item form-group">
            <label class="col-md-12">From  <span class="required">*</span></label>                 
            <input type="text" name="travel_from[]"  placeholder="Travel From" Value="<?php echo $td->travel_from ; ?>" class="form-control col-md-7 col-xs-12" required="required" >

         </div>
         <div class="col-md-2 col-sm-12 col-xs-12 item form-group">
            <label class="col-md-12">To</label>
            <input type="text" name="travel_to[]" Value="<?php echo $td->travel_to ; ?>" placeholder="Travel To" class="form-control col-md-7 col-xs-12" required="required" >
         </div>
         <div class="col-md-2 col-sm-6 col-xs-12 form-group">
            <label class="col-md-12" >Start</label>
            <input type="text" class="form-control has-feedback-left datePicker start_travel" Value="<?php echo $td->start_date ; ?>" name="start_date[]" id="fromDate_<?php echo $i ?>" >
            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            <span id="inputSuccess2Status3" class="sr-only">(success)</span>
           </div>        
       <div class="col-md-2 col-sm-6 col-xs-12 form-group">
            <label class="col-md-12" >End</label>
             <input type="text" class="form-control has-feedback-left datePicker end_travel" Value="<?php echo $td->end_date ; ?>" name="end_date[]" id="toDate_<?php echo $i ?>" >
            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            <span id="inputSuccess2Status3" class="sr-only">(success)</span>

        </div>
         <div class="col-md-2 col-sm-6 col-xs-12 form-group">
            <label class="col-md-12">Mode Of Travel</label>
            <select id="mode" name="travel_mode[]" class="form-control col-md-7 col-xs-12" >
            <option value="Roadways" <?php if($td->travel_mode == 'Roadways'){ echo ' selected="selected"'; } ?>>Roadways</option>
            <option value="Railways" <?php if($td->travel_mode == 'Railways'){ echo ' selected="selected"'; } ?>>Railways</option>
            <option value="Airways" <?php if($td->travel_mode == 'Airways'){ echo ' selected="selected"'; } ?>>Airways</option>
            </select>
         </div>
         <div class="col-md-2 col-sm-6 col-xs-12 form-group">
            <label class="col-md-12">Cost</label>
          <input type="number" name="travel_cost[]" Value="<?php echo $td->travel_cost ; ?>" placeholder="Travel To" class="form-control col-md-7 col-xs-12"  >
         </div>
         <button class="btn btn-danger remove_travel" type="button"> <i class="fa fa-minus"></i></button>
      </div>
      <?php $i++; }
         }
         }?>   
      <div class="col-sm-12 btn-row"><button class="btn addMoreTravelDetails edit-end-btn" type="button">Add</button></div>
   </div>
   <hr>
      <div class="bottom-bdr"></div>
      <h3>Travel Related Attachments</h3>   
      <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12">Documents Upload</label>
     
      <div class="col-md-3 col-sm-3 col-xs-6 cand_document_wrapper">
         <div class="col-md-9 col-sm-11 col-xs-12" style="margin-bottom: 3%;     padding-left: 0px; ">
            <input class="form-control col-md-7 col-xs-12" id="document_1" name="attachment[]" type="file">
         </div>
         <a href="javascript:void(0);" class="btn edit-end-btn  add_more_docs" id="add_cand_document_btn">Add</a>
      </div>
   </div>
    <?php //
    if(!empty($attachments)){ ?>
   <div class="item form-group">
      <label class="control-label col-md-3 col-sm-2 col-xs-12" for="proof"></label>
      <div class="col-md-7">        
         <?php // pre($attachments);die;
         foreach($attachments as $proofs){   
         
             $ext = pathinfo($proofs['file_name'], PATHINFO_EXTENSION);
            if($ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg' || $ext == 'png' || $ext == 'ico'){
               echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'" alt="image" height="80" width="80"/><i class="fa fa-download"></i> 
               <div class="mask">
                  <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'hrm/delete_doc/'.$proofs['id'].'/'.$travel_details->id.'">
                     <i class="fa fa-trash"></i>
                     </a>
                  </div></div></div>';       
            }else if($ext == 'ods' || $ext ==  'doc' || $ext ==  'docx' ){
               echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/docX.png"  height="80" width="80"/><i class="fa fa-download"></i> 
               <div class="mask">
                     <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'hrm/delete_doc/'.$proofs['id'].'/'.$travel_details->id.'">
                     <i class="fa fa-trash"></i>
                     </a>
                  </div></div></div>'; 
            }else if($ext == 'pdf'){
               echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/PDF.png"  height="80" width="80"/><i class="fa fa-download"></i> 
               <div class="mask">
                     <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'hrm/delete_doc/'.$proofs['id'].'/'.$travel_details->id.'">
                     <i class="fa fa-trash"></i>
                     </a>
                  </div></div></div>'; 
               }else if($ext == 'xlsx' || $ext ==  'csv' || $ext ==  'xls' ){
               echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/excel.png"  height="80" width="80"/><i class="fa fa-download"></i> 
               <div class="mask">
                     <a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'hrm/delete_doc/'.$proofs['id'].'/'.$travel_details->id.'">
                     <i class="fa fa-trash"></i>
                     </a>
               </div></div></div>'; 
            }
         }

      ?>          
      </div>
   </div>
   <?php } ?>  
     <hr>
      <div class="bottom-bdr"></div>
      <h3>Travel and Other Expenses</h3>
   <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Daily Allowance Charge<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" name="daily_allowance" required="required" type="number" value="<?php if(!empty($travel_details)){echo $travel_details->daily_allowance;} ?>">      

         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Local Conveyance Allowance<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" name="local_conveyance" required="required" type="number" value="<?php if(!empty($travel_details)){echo $travel_details->local_conveyance;} ?>">    
         </div>
      </div>
   </div>   
   <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Gross Charges Incurred<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" name="gross_charge" required="required" type="number" value="<?php if(!empty($travel_details)){echo $travel_details->gross_charge;} ?>">      

         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Advance Taken Payment<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" name="advance_taken" required="required" type="number" value="<?php if(!empty($travel_details)){echo $travel_details->advance_taken;} ?>">    
         </div>
      </div>
   </div>   
   <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Net Claimed<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" name="net_claim" required="required" type="number" value="<?php if(!empty($travel_details)){echo $travel_details->net_claim;} ?>">      
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Remarks</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea name='remarks' class="form-control col-md-7 col-xs-12"><?php if(!empty($travel_details)){echo $travel_details->remarks;} ?></textarea>
         </div>
      </div>
   </div>  
   <div class="col-md-12 col-sm-12 col-xs-12 item form-group vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Paid Status</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input class='validate_status' name="paid_status" disabled type="radio" id="approve_status" value="1" <?php if(!empty($travel_details)){ if($travel_details->paid_status=='1'){ echo "checked=checked";}  } ?>/> Paid
            <input name="paid_status" class='validate_status' disabled type="radio" id="disapprove_status" value="0" <?php  if(!empty($travel_details)){ if($travel_details->paid_status =='0'){ echo "checked=checked";} } ?>/> Upaid
         </div>
      </div>
   </div>
   <hr>
   <div class="form-group">
      <div class="col-md-12 ">
         <center><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <input type="submit" class="btn edit-end-btn " value="Submit">
         </center>
      </div>
   </div>
</form>
<script>
 $(document).ready(function(){
      $('body').on('focus',".start_travel", function(){
        // Print entered value in a div box
      var date_id = $(this).attr('id');
      //alert(date_id);
      var arr = date_id.split('_');
        $(this).datepicker({
            dateFormat: 'dd-mm-yyyy',
            autoclose: true,
         }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#toDate_'+arr[1]).datepicker('setStartDate', minDate);
         });
    });

   $('body').on('focus',".end_travel", function(){
        // Print entered value in a div box
      var date_id = $(this).attr('id');
      var arr = date_id.split('_');
         $(this).datepicker({
            dateFormat: 'dd-mm-yyyy',
              debug: true,
         }).on('changeDate', function (selected) {
               var minDate = new Date(selected.date.valueOf());
               $('#fromDate_'+arr[1]).datepicker('setEndDate', minDate);
         });
       });
   // Document Upload
    var x = 1;
      var max_fields = 15; 
      $("#add_cand_document_btn").click(function(e){
         e.preventDefault();
         //$(".cand_document_wrapper")
          if(x < max_fields){ //max input box allowed
              x++; 
         $(".cand_document_wrapper").append('<div style="padding:0px;" class="item form-group col-md-12 col-sm-12 col-xs-12"><div class="col-md-9 col-sm-11 col-xs-12" style="padding-left: 0px;"><input class="form-control col-md-7 col-xs-12" name="attachment[]" type="file"></div><button class="btn btn-danger remove_cand_document_btn" type="button"><i class="fa fa-minus"></i></button></div>');
          }
      });
   
      $(".cand_document_wrapper").on("click",".remove_cand_document_btn", function(e){ //user click on remove text
          e.preventDefault(); 
          $(this).parent('div').remove(); 
          x--;
      });
   // Add more Travel Details
   var maximum = 10; //maximum input boxes allowed
   var wrap_material = $(".input_travel"); //Fields wrapper
   var button_add = $(".addMoreTravelDetails"); //Add button ID
   var x = 1; //initlal text box count 
   $(button_add).click(function (e) {
      //on add input button click
      e.preventDefault();
      if (x < maximum) { //max input box allowed
         x++;
         //var dataWhere = $("#material").attr("data-where");
         $(wrap_material).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_' + x + '"><div class="col-md-2 col-sm-12 col-xs-12 item form-group"> <label class="col-md-12">From<span class="required">*</span></label> <input type="text" name="travel_from[]" placeholder="Travel From" class="form-control col-md-7 col-xs-12" required="required" > </div><div class="col-md-2 col-sm-12 col-xs-12 item form-group"> <label class="col-md-12">To</label> <input type="text" name="travel_to[]" placeholder="Travel To" class="form-control col-md-7 col-xs-12" required="required" > </div><div class="col-md-2 col-sm-6 col-xs-12 form-group"> <label class="col-md-12" >Start</label> <input type="text" placeholder="Start Date" class="form-control has-feedback-left datePicker start_travel" name="start_date[]" id="fromDate_' + x + '" value="" > <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span> <span id="inputSuccess2Status3" class="sr-only">(success)</span> </div><div class="col-md-2 col-sm-6 col-xs-12 form-group"> <label class="col-md-12" >End</label> <input type="text" placeholder="End Date" class="form-control has-feedback-left datePicker end_travel" name="end_date[]" id="toDate_' + x + '" value="" "> <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span> <span id="inputSuccess2Status3" class="sr-only">(success)</span> </div><div class="col-md-2 col-sm-6 col-xs-12 form-group"> <label class="col-md-12">Mode Of Travel</label> <select id="mode" name="travel_mode[]" class="form-control col-md-7 col-xs-12" ><option value="Roadways">Roadways</option><option value="Railways">Railways</option><option value="Airways">Airways</option></select> </div><div class="col-md-2 col-sm-6 col-xs-12 form-group"> <label class="col-md-12">Cost</label> <textarea name="travel_cost[]" placeholder="Travel Cost" class="form-control col-md-7 col-xs-12" style="border-right:1px solid #c1c1c1 !important;"></textarea> </div><button class="btn btn-danger remove_travel" type="button"> <i class="fa fa-minus"></i></button> </div>');

      }
      //getMaterials(x);
   });
   $(wrap_material).on("click", ".remove_travel", function (e) { //user click on remove text
      e.preventDefault();
      $(this).parent('div').remove();
      x--;
      /*keyupFunction(event,this);
      remove_calculation_quot_pi_so();*/
   });
});
</script>