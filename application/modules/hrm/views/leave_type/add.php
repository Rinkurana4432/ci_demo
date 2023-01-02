<!--</?php  pre($leavetype);die;  ?>-->
<form method="post" action="saveLeavetype" id="leaveform" enctype="multipart/form-data" autocomplete="off" >
                <input type="hidden" name="id" value="<?php if(!empty($leavetype)){ echo $leavetype->id; }?>">
                                                <input type="hidden" name="created_by_cid" value="<?php echo $this->companyGroupId ?>" id="loggedUser">

                        <div class="modal-body">
                            <div class="vertical-border col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12">Leave Type</label>
                                 <div class="col-md-6 col-sm-9 col-xs-12"><input type="text" name="name" class="form-control" minlength="1" maxlength="35" value="<?php if(!empty($leavetype)){ echo $leavetype->name; }?>" required></div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12">Day</label>
                                <div class="col-md-6 col-sm-9 col-xs-12"><input required  type="number" name="leave_day" class="form-control" value="<?php if(!empty($leavetype)){ echo $leavetype->leave_day ; }?>"></div>
                            </div>
						 <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12">Automatically Assign Leave</label>
                                <div  class="col-md-6 col-sm-9 col-xs-12"><?php if(!empty($leavetype)){ if($leavetype->automatically_assign_leave =='1'){ echo "Leaves Already Assigned"; }else{  echo"<input required  type='checkbox' name='automatically_assign_leave' value='1'>";  } }else{ echo"<input required  type='checkbox' name='automatically_assign_leave' value='1'>";} ?>  </div>
                            </div>
							</div>
							<div class="vertical-border col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12">Status</label>
                               <div class="col-md-6 col-sm-9 col-xs-12"> <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="status" required>
                                    <option value="">Select Here</option>
                 <option value="1" <?php if(!empty($leavetype->status)){ if($leavetype->status==1){echo 'Selected';}}?>>Active</option>
                 <option value="0" <?php if(!empty($leavetype->status)){ if($leavetype->status==0){echo 'Selected';}}?>>In Active</option>
                                </select>
								</div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12">Carry Forward Leave</label>
                               <div class="col-md-6 col-sm-9 col-xs-12"> <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="carry_forward_leave" required>
                                    <option value="">Select Here</option>
                 <option value="1" <?php if(!empty($leavetype->carry_forward_leave)){ if($leavetype->carry_forward_leave==1){echo 'Selected';}}?>>Yes</option>
                 <option value="0" <?php if(!empty($leavetype->carry_forward_leave)){ if($leavetype->carry_forward_leave==0){echo 'Selected';}}?>>No</option>
                                </select>
								</div>
                            </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>