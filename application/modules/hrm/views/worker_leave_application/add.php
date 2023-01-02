   <form method="post" action="save_Applications_worker" enctype="multipart/form-data">
                            <div class="modal-body">
                                    <input type="hidden" name="id" value="<?php if(!empty($empleave)){ echo $empleave->id ; }?>">
                                                <input type="hidden" name="created_by_cid" value="<?php echo $this->companyGroupId ?>" id="loggedUser">
												
								<div class="col-md-6 col-sm-12 col-xs-12  vertical-border">					
                                <div class="itam form-group">
                                    <label class="col-md-3 col-sm-12 col-xs-12">Worker <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-12 col-xs-12"> <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible selectedEmployeeID" name="emid" data-id="worker" data-key="id" data-fieldname="name" data-where="created_by_cid = <?php echo $this->companyGroupId; ?> AND active_inactive = 1" width="100%" tabindex="-1" aria-hidden="true" required="required">
                                                            <option value="">Select Option</option>
                                                            <?php
                                                            if(!empty($empleave)){                                               
                                                                $owner = getNameById('worker',$empleave->em_id,'id');
                                                                echo '<option value="'.$empleave->em_id.'" selected>'.$owner->name.'</option>';
                                                            }
                                                            ?>
                                                        </select>
									</div>
                                </div>
                                <div class="itam form-group">
                                    <label class="col-md-3 col-sm-12 col-xs-12">Leave Name <span class="required">*</span></label>
                                   <div class="col-md-6 col-sm-12 col-xs-12"> <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible assignleave" name="typeid" data-id="leave_types" data-key="id" data-fieldname="name" data-where="created_by_cid = <?php echo $this->companyGroupId;?> AND status = 1" width="100%" tabindex="-1" aria-hidden="true" required="required">
                                                        <option value="">Select Option</option>
                                                        <?php
                                                        if(!empty($empleave)){                                               
                                                            $owner = getNameById('leave_types',$empleave->typeid,'id');
                                                            echo '<option value="'.$empleave->typeid.'" selected>'.$owner->name.'</option>';
                                                        }
                                                        ?>
                                    </select>
									</div>
                                </div>
                                
                                <div class="itam form-group">
                                    <label class="col-md-3 col-sm-12 col-xs-12" >Leave Duration <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-12 col-xs-12"><input name="type" type="radio" id="radio_1" data-value="Half" class="duration" value="Half Day" checked=""  required="required">
                                    <label for="radio_1">Hourly</label>
                                    <input name="type" type="radio" id="radio_2" data-value="Full" class="type" value="Full Day">
                                    <label for="radio_2">Full Day</label>
                                    <input name="type" type="radio" class="with-gap duration" id="radio_3" data-value="More" value="More than One day">
                                    <label for="radio_3">Above a Day</label>
									</div>
                                </div>
                                <!-- <div class=" itamform-group">
                        <label class="col-md-3 col-sm-12 col-xs-12">Cc<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-12 col-xs-12"><select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible   mail_id" name="mail_id[]" id="u_id" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $this->companyGroupId;?>  " width="100%" tabindex="-1" aria-hidden="true" required="required" multiple>
                        <option value="">Select Option</option>
                        
                        <?php
                                           if(!empty($empleave)){
                                                 //   
                                                 $salesData = json_decode($empleave->mail_id);
                                                 
                                                foreach($salesData as $saleval){
                                                      $usersdata = getNameById('user_detail',$saleval,'u_id');
                                                      if(!empty($usersdata)){
                                                            echo '<option value="'.$saleval.'" selected>'.$usersdata->name.'</option>';
                                                      }
                                                }     
                                          }
                                          ?>
                        </select></div>
                        </div> -->
					 <div class=" itam form-group">
                         <label class="col-md-3 col-sm-12 col-xs-12" id="hourlyFix">Start Date<span class="required">*</span></label>
                          <div class="col-md-6 col-sm-12 col-xs-12"><input type="date" name="startdate" id="startdate" class="form-control mydatetimepickerFull" required value="<?php if(!empty($empleave)){ echo $empleave->start_date ; }?>"></div>
                        </div>
                               </div>
								<div class="col-md-6 col-sm-12 col-xs-12  vertical-border">	
                        
                        <div class=" itam form-group" id="xenddate"> <!--style="display:none"-->
                         <label class="col-md-3 col-sm-12 col-xs-12">End Date<span class="required">*</span></label>
                         <div class="col-md-6 col-sm-12 col-xs-12"><input required type="date" name="enddate" id="enddate" class="form-control mydatetimepickerFull" value="<?php if(!empty($empleave)){ echo $empleave->end_date ; }?>"></div>
                        </div>

                        <div class=" itam form-group"  >
                         <label class="col-md-3 col-sm-12 col-xs-12">Length ( In Hours )<br> (1 day = 8 hrs)<!-- <br>(1/2 day = 4 hrs) --> <span class="required">*</span></label>
                         <div class="col-md-6 col-sm-12 col-xs-12"> 
                        <input required type="number" name="leave_duration" id="leave_duration" class="form-control" value="<?php if(!empty($empleave)){ echo $empleave->leave_duration ; }?>" readonly >
                        </div>
                        </div> 

                               <!--  <div class="form-group" id="hourAmount">
                                    <label class="col-md-3 col-sm-12 col-xs-12">Length <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <select  id="hourAmountVal" class=" form-control custom-select"  tabindex="1" name="hourAmount" required>
                                        <option value="">Select Hour</option>
                                        <option value="1">One hour</option>
                                        <option value="2">Two hour</option>
                                        <option value="3">Three hour</option>
                                        <option value="4">Four hour</option>
                                        <option value="5">Five hour</option>
                                        <option value="6">Six hour</option>
                                        <option value="7">Seven hour</option>
                                        <option value="8">Eight hour</option>
                                    </select>
									</div>
                                </div> -->

                               <!--  <div class="form-group" >
                                    <label class="control-label">Duration</label>
                                    <input type="number" name="duration" class="form-control" id="leaveDuration">
                                </div> --> 
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-12 col-xs-12">Reason <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <textarea class="form-control" required name="reason" id="message-text1"><?php if(!empty($empleave)){ echo $empleave->reason ; }?></textarea> </div>                                               
                                </div>  
                    
                                  <!-- <div class="form-group">
                                    <label class="col-md-3 col-sm-12 col-xs-12">Upload Document</label>
                                    <div class="col-md-6 col-sm-12 col-xs-12"><input type="file" class="form-control col-md-2 col-sm-2 col-xs-12" name="attachment[]"></div>                                                 
                                </div>  -->   
                            </div>								
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>


                     <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                        <label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label>
                        <div class="col-md-8 col-sm-12 col-xs-12 ">
                            <?php if(!empty($attachments)){?>
                            <div class="col-md-10 col-md-offset-2 outline">
                                <?php foreach($attachments as $attachment){
                                    echo '<div class="img-wrap col-md-3">
                                    <div class="col-md-12 img-outline">
                                    <a href="javascript:void(0)" class="delete_listing close-link cross" style="z-index:111;" data-href="'.base_url(). 'crm/deleteAttachment/'.$attachment[ 'id']. '">
                                    <i class="fa fa-trash" style="color:#e60a03;"></i></a><a  href="'.base_url(). 'assets/modules/hrm/uploads/'.$attachment[ 'file_name']. '" download>
                                    <img  src="'.base_url(). 'assets/modules/hrm/uploads/'.$attachment[ 'file_name']. '" alt="image" class="img-responsive zoom"/></a></div></div>';
                                } ?>
                            </div>
                        <?php } ?>
                        </div>