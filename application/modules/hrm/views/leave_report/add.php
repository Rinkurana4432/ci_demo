 

<form method="post" action="UpdateEarnLeave" id="deductionform" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if(!empty($earned_leave)){ echo $earned_leave->id; }?>">
                                            <input type="hidden" name="save_status" value="1" class="save_status">  
                                                <input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId ?>" id="loggedUser">
                                <div class="modal-body">
								<div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
                                    <div class="form-group item">
                                       <label class="col-md-3 col-sm-12 col-xs-12">Emp Code  </label>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
              <input class="form-control" readonly  type="text" id="emp_id" value="<?php print_r($emp_id); ?>">
                                        </div>
                                        </div> 
                                        <div class="form-group item">
                                      <label class="col-md-3 col-sm-12 col-xs-12">Number Of Days </label>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <input type="number"   name="days" id="days" class="form-control day"  required>
                                            </div>
                                        </div> 
										</div>
										 <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
                                        <div class="form-group item">
                                       <label class="col-md-3 col-sm-12 col-xs-12">Leave Type </label>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <select required name="leave_id" id="leave_id" onchange="leave_count()" class="form-control " >
                                                  <option value=" ">Select </option>
                                            <?php 
                                            
                                             foreach($leave_types  as $leaves ){  ?>   
                                           
                                             <option value="<?php print_r($leaves['id']); ?>"><?php print_r($leaves['name']); ?></option>   
                                                <?php }  ?>
                                            </select>
                                             </div>
                                        </div> 
</div>	 						
                                   </div>
                                    <div class="modal-footer">                               
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" id="leave_update" class="btn btn-primary">Submit</button>
                                    </div>
</form>
 

    

  