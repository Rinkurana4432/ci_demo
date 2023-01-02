
<form method="post" action="saveLeavetype" id="leaveform" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php if(!empty($leavetype)){ echo $leavetype->id; }?>">
                                                <input type="hidden" name="created_by_cid" value="<?php echo $this->companyGroupId ?>" id="loggedUser">

                        <div class="modal-body">
                            <div class="vertical-border col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12">Leave name</label>
                                 <div class="col-md-6 col-sm-9 col-xs-12">
								 <?php if(!empty($leavetype)){ echo $leavetype->name; }?>
                                 </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12">Day</label>
                                <div class="col-md-6 col-sm-9 col-xs-12">
								<?php if(!empty($leavetype)){ echo $leavetype->leave_day ; }?>
                                </div>
                            </div>
							</div>
							<div class="vertical-border col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12">Status</label>
                               <div class="col-md-6 col-sm-9 col-xs-12"> 
							   <?php if(!empty($leavetype)){if($leavetype->status==1){echo 'Active';}
					else{echo 'InActive';}}?>
								</div>
                            </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>