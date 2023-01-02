<form method="post" action="<?php echo base_url(); ?>hrm/savecancelapplication" enctype="multipart/form-data">
                            <div class="modal-body">
 <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">												
							<div class="col-md-6 col-sm-12 col-xs-12  vertical-border">					
                             <div class="form-group">
                                    <label class="col-md-3 col-sm-12 col-xs-12">Reason</label>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                    <textarea class="form-control" name="reason" >
                                  <?php if(!empty($assign_emp) && $assign_emp->cancel_reason!=''){ echo $assign_emp->cancel_reason; }?>  
                                    </textarea>
                                    </div>                                                
                                </div> 
                              </div>								
                            </div>
                            <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>