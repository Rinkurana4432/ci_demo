<form method="post" action="save_Applications" enctype="multipart/form-data">
                            <div class="modal-body">
                                    <input type="hidden" name="id" value="<?php if(!empty($empleave)){ echo $empleave->id ; }?>">
                                                <input type="hidden" name="created_by_cid" value="<?php echo $this->companyGroupId ?>" id="loggedUser">
												
							<div class="col-md-6 col-sm-12 col-xs-12  vertical-border">					
                                <div class=" itam form-group">
                                    <label class="col-md-3 col-sm-12 col-xs-12">Employee</label>
                                     <!--</?php pre($users1);    ?>-->
                                    <div class="col-md-6 col-sm-12 col-xs-12"> 
                                    <select class="itemName form-control " name="emid" required="required">
               <option value="">Select Option</option>
              
              
               <?php  foreach($users1 as $user){
               if(!empty($user['name'])){
               ?>
               
				   	<option value="<?php echo $user['id'];?>"
					<?php if(!empty($empleave)){ if($empleave->em_id==$user['id']){echo 'Selected';}}?>>
					<?php echo $user['name']."  &nbsp; &nbsp; &nbsp;  ( &nbsp;Emp Code :".$user['id'].")";?></option>
					<?php
               
			  								 }
			  								 }
                  ?>
            </select>
         <!--   <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible selectedEmployeeID" name="emid" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $this->companyGroupId; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">
                                                        <option value="">Select Option</option>
                                                        <?php
                                                        if(!empty($empleave)){                                               
                                                            $owner = getNameById('user_detail',$empleave->em_id,'u_id');
                                                            echo '<option value="'.$empleave->em_id.'" selected>'.$owner->name.'</option>';
                                                        }
                                                        ?>
                                        </select>-->
									</div>
                                </div>
                                <div class=" itamform-group">
                                    <label class="col-md-3 col-sm-12 col-xs-12">Leave Name</label>
                                    <div class="col-md-6 col-sm-12 col-xs-12"><select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible assignleave" name="typeid" data-id="leave_types" data-key="id" data-fieldname="name" data-where="created_by_cid = <?php echo $this->companyGroupId;?> AND status = 1" width="100%" tabindex="-1" aria-hidden="true" required="required">
                                                        <option value="">Select Option</option>
                                                        <?php
                                                        if(!empty($empleave)){                                               
                                                            $owner = getNameById('leave_types',$empleave->typeid,'id');
                                                            echo '<option value="'.$empleave->typeid.'" selected>'.$owner->name.'</option>';
                                                        }
                                                        ?>
                                    </select></div>
                                </div>
                                
								<div class=" itam form-group">
                                    <label class="col-md-3 col-sm-12 col-xs-12">Leave Duration</label><br>
                                    <div class="col-md-6 col-sm-12 col-xs-12"><input name="type" type="radio" id="radio_1" data-value="Half" class="duration" value="Half Day" checked="">
                                    <label for="radio_1">Hourly</label>
                                    <input name="type" type="radio" id="radio_2" data-value="Full" class="type" value="Full Day">
                                    <label for="radio_2">Full Day</label>
                                    <input name="type" type="radio" class="with-gap duration" id="radio_3" data-value="More" value="More than One day">
                                    <label for="radio_3">Above a Day</label>
									</div>
                                </div>
								<div class="form-group">
                                    <span style="color:red" id="total"></span>
                                    <div class="span pull-left">
                                        <button class="btn btn-info fetchLeaveTotal">Fetch Total Leave</button>
                                    </div>
                                    <br>
                                </div>
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
                                
                                <div class=" itam form-group">
                                    <label class="col-md-3 col-sm-12 col-xs-12" id="hourlyFix">Start Date</label>
                                    <div class="col-md-6 col-sm-12 col-xs-12"><input type="date" name="startdate" class="form-control mydatetimepickerFull" required value="<?php if(!empty($empleave)){ echo $empleave->start_date ; }?>"></div>
                                </div>
                                <div class=" itam form-group" id="enddate"> <!--style="display:none"-->
                                    <label class="col-md-3 col-sm-12 col-xs-12">End Date</label>
                                    <div class="col-md-6 col-sm-12 col-xs-12"><input required type="date" name="enddate" class="form-control mydatetimepickerFull" value="<?php if(!empty($empleave)){ echo $empleave->end_date ; }?>"></div>
                                </div>

                                <div class=" itam form-group" id="hourAmount">
                                    <label class="col-md-3 col-sm-12 col-xs-12">Length</label>
                                    <div class="col-md-6 col-sm-12 col-xs-12"><select  id="hourAmountVal" class=" form-control custom-select"  tabindex="1" name="hourAmount" required>
                                        <option value="">Select Hour</option>
                                        <option value="1">One hour</option>
                                        <option value="2">Two hour</option>
                                        <option value="3">Three hour</option>
                                        <option value="4">Four hour</option>
                                        <option value="5">Five hour</option>
                                        <option value="6">Six hour</option>
                                        <option value="7">Seven hour</option>
                                        <option value="8">Eight hour</option>
                                    </select></div>
                                </div>

                               <!--  <div class="form-group" >
                                    <label class="control-label">Duration</label>
                                    <input type="number" name="duration" class="form-control" id="leaveDuration">
                                </div> --> 
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-12 col-xs-12">Reason</label>
                                    <div class="col-md-6 col-sm-12 col-xs-12"><textarea class="form-control" name="reason" id="message-text1"></textarea></div>                                                
                                </div> 
                              </div>								
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>