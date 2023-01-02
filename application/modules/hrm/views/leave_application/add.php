                        <form method="post" action="<?=base_url();?>hrm/save_Applications" enctype="multipart/form-data">
                        <div class="modal-body">

                        <input type="hidden" name="id" value="<?php if(!empty($empleave)){ echo $empleave->id ; }?>">
                        <input type="hidden" name="created_by_cid" value="<?php echo $this->companyGroupId ?>" id="loggedUser">

                        <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">					
                        <div class=" itam form-group">
                        <label class="col-md-3 col-sm-12 col-xs-12">Employee</label>
                        <div class="col-md-6 col-sm-12 col-xs-12"> 
 

                        <input type="hidden" name="emid" id="emp_id" class="form-control" required="required" value="<?php echo $users1->u_id; ?>" >
                        <input type="text" name="namen" id="emp_id_name" class="form-control" required="required" value="<?php echo $users1->name." &nbsp;( &nbsp;Emp Code :".$users1->u_id.")";?>" readonly >

                        </div>
                        </div>
                        <div class=" itamform-group">
                        <label class="col-md-3 col-sm-12 col-xs-12">Leave Name<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-12 col-xs-12"><select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible assignleave show_leave_data" name="typeid" id="leave_id" data-id="leave_types" data-key="id" data-fieldname="name" data-where="created_by_cid = <?php echo $this->companyGroupId;?> AND status = 1" width="100%" tabindex="-1" aria-hidden="true" required="required">
                        <option value="">Select Option</option>
                        <?php
                        if(!empty($empleave)){                                               
                        $owner = getNameById('leave_types',$empleave->typeid,'id');
                        echo '<option value="'.$empleave->typeid.'" selected>'.$owner->name.'</option>';
                        }
                        ?>
                        </select></div>
                        </div>


                        <!-- <div class=" itam form-group">
                        <label class="col-md-3 col-sm-12 col-xs-12" id="hourlyFix">No of leaves Left :</label>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                        <span id="show_leave"></span>

                        </div>
                        </div> -->


                        <div class=" itam form-group">


                        </div>
                        <div class=" itam form-group">


                        </div>
                        <div class=" itam form-group">

                        <div class="col-md-6 col-sm-12 col-xs-12">


                        </div>
                        </div>
                        <div class=" itam form-group">

                        <div class="col-md-6 col-sm-12 col-xs-12">
                        <label class="col-md-3 col-sm-12 col-xs-12" id="hourlyFix"> </label>
                        <span id="show_cl_msg"></span>

                        </div>
                        </div> 
                    </div>
                        <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">

                        <div class=" itam form-group">
                        <label class="col-md-3 col-sm-12 col-xs-12" id="hourlyFix">Start Date<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-12 col-xs-12"><input type="date" name="startdate" id="startdate" class="form-control mydatetimepickerFull" required value="<?php if(!empty($empleave)){ echo $empleave->start_date ; }?>"></div>
                        </div>
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
                        <div class="form-group">
                        <label class="col-md-3 col-sm-12 col-xs-12">Reason <span class="required">*</span> </label>
                        <div class="col-md-6 col-sm-12 col-xs-12"><textarea class="form-control" required="required" name="reason" id="message-text1"><?php if(!empty($empleave)){ echo $empleave->reason ; } ?></textarea></div>                                                
                        </div> 
                        <div class=" itamform-group">
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
                        </div>
                        </div>								
                        </div>
                        <div class="modal-footer">
                        <input class="btn btn-default" type="reset" value="Reset">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit"   id="sub_btn1"  class="btn btn-primary">Submit</button>  

                        </div>
                        </form>