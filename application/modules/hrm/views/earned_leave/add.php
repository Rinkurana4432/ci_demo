<?php if(!empty($earned_leave) && $earned_leave->save_status == 1) { ?>

<form method="post" action="UpdateEarnLeave" id="deductionform" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if(!empty($earned_leave)){ echo $earned_leave->id; }?>">
                                            <input type="hidden" name="save_status" value="1" class="save_status">  
                                                <input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId ?>" id="loggedUser">
                                <div class="modal-body">
								<div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
                                    <div class="form-group item">
                                       <label class="col-md-3 col-sm-12 col-xs-12">Employee </label>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
              <select class="itemName form-control " name="employee" required="required">
               <option value="">Select Option</option>
              
               <?php  foreach($users as $user){?>
				   	<option value="<?php echo $user['id'];?>"
					<?php if(!empty($earned_leave)){ if($earned_leave->em_id==$user['id']){echo 'Selected';}}?>>
					<?php echo $user['name'];?></option>
					<?php
               
			  								 }
                  ?>
            </select>                 
             <!--  <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible selectedEmployeeID" name="employee" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $this->companyGroupId; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">
                                                        <option value="">Select Option</option>
                                                        <?php /**
                                                        if(!empty($earned_leave)){                                               
                                                            $owner = getNameById('user_detail',$earned_leave->em_id,'u_id');
                                                            echo '<option value="'.$earned_leave->em_id.'" selected>'.$owner->name.'</option>';
                                                        }**/
                                                        ?>
                                        </select>-->
                                        </div>
                                        </div> 
                                        <div class="form-group item">
                                      <label class="col-md-3 col-sm-12 col-xs-12">Number Of Days </label>
                                        <div class="col-md-6 col-sm-12 col-xs-12"><input type="number" min="0" name="day" class="form-control day" value="<?php if(!empty($earned_leave)){ echo $earned_leave->present_date; }?>" required></div>
                                        </div> 
										</div>
										<!--<div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
                                        <div class="form-group item">
                                       <label class="col-md-3 col-sm-12 col-xs-12">Hour </label>
                                        <div class="col-md-6 col-sm-12 col-xs-12"><input type="text" name="hour" class="form-control hour" value="<?php if(!empty($earned_leave)){ echo $earned_leave->hour; }?>" readonly></div>
                                        </div> 
</div>		-->								
                                   </div>
                                    <div class="modal-footer">                               
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
</form>
<?php  }else{ ?>

    <form method="post" action="saveEarnedLeave" id="deductionform" enctype="multipart/form-data">
                                    <div class="modal-body">
                                      <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">									
                                        <div class="form-group item">
                                        <label class="col-md-3 col-sm-12 col-xs-12">Employee </label>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                        <!--<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible selectedEmployeeID" name="emid" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $this->companyGroupId; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">
                                                        <option value="">Select Option</option>
                                        </select>-->
       <select class="itemName form-control " name="emid" required="required">
               <option value="">Select Option</option>
              
               <?php  foreach($users as $user){?>
				   	<option value="<?php echo $user['id'];?>">
					<?php echo $user['name'];?></option>
					<?php	 } ?>
            </select>                                  
                                        </div>
                                        </div> 
                                        <!--<div class="form-group item">
                                       <label class="col-md-3 col-sm-12 col-xs-12">Start Date</label>
                                        <div class="col-md-6 col-sm-12 col-xs-12"><input type="date" min="0" name="startdate" class="form-control day" value="" required></div>
                                        </div>--> 
										<div class="form-group item">
                                       <label class="col-md-3 col-sm-12 col-xs-12">Days</label>
                                        <div class="col-md-6 col-sm-12 col-xs-12"><input type="text" min="0" name="present_date" class="form-control day" value="" required></div>
                                        </div>
										</div>
										<!--<div class="col-md-6 col-sm-12 col-xs-12  vertical-border">	
                                        <div class="form-group item">
                                       <label class="col-md-3 col-sm-12 col-xs-12">End Date</label>
                                        <div class="col-md-6 col-sm-12 col-xs-12"><input type="date" name="enddate" class="form-control hour" value=""></div>
                                        </div>
																				
                                       </div>-->
                                    <div class="modal-footer">
                                      <center>  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
										</center>
                                    </div>
                                    </form>

<?php  } ?>