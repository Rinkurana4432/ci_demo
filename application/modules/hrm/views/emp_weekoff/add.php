<form method="post" action="empsaveWeekoff" id="holidayform" enctype="multipart/form-data">
   <input type="hidden" name="id" value="<?php if(!empty($holiday)){ echo $holiday->id; }?>">
   <input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId ?>" id="loggedUser">                                
   <div class="modal-body">
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class=" col-md-3 col-sm-12 col-xs-12">Week Off Day</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <?php $dayNames = array(
               
               1=>'Monday', 
               2=>'Tuesday', 
               3=>'Wednesday', 
               4=>'Thursday', 
               5=>'Friday', 
               6=>'Saturday', 
               7=>'Sunday',
               9=>'Second Saturday / Fourth Saturday', 
              10=>'Third Saturday / Fifth Saturday', 
               ); 
              ?>

              <select class='form-control custom-select' name=day>
              <option value=''>Select Weekday</option>
               <?php foreach($dayNames as $nokey => $day){ 
              ?><option value="<?php echo $nokey;?>"><?php echo $day;?></option>
              <?php }?>
              </select>
               
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary">Submit</button>
   </div>
</form>