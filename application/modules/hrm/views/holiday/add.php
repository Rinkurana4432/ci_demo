<form method="post" action="saveHolidays" id="holidayform" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php if(!empty($holiday)){ echo $holiday->id; }?>">
              <input type="hidden" name="save_status" value="1" class="save_status">  
              <input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId ?>" id="loggedUser">                                
                                    <div class="modal-body">
                                        <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                                            <div class="item form-group">
                                                <label class=" col-md-3 col-sm-12 col-xs-12">Holidays name</label>
                                                <div class="col-md-6 col-sm-12 col-xs-12"><input type="text" name="holiname" class="form-control" id="recipient-name1" minlength="4" maxlength="25" value="<?php if(!empty($holiday)){ echo $holiday->holiday_name; }?>" required></div>
                                            </div>
                                            <div class="item form-group">
                                                <label class=" col-md-3 col-sm-12 col-xs-12">Holidays Start Date</label>
                                                <div class="col-md-6 col-sm-12 col-xs-12"><input type="date" name="startdate" class="form-control col-md-2 col-xs-12 date hasDatepicker" id="startfrom"  value="<?php if(!empty($holiday)){ echo $holiday->from_date; }?>"></div>
                                            </div>
											</div>
											 <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Holidays End Date</label>
                                                <div class="col-md-6 col-sm-12 col-xs-12"><input type="date" name="enddate" class="form-control col-md-2 col-xs-12 date hasDatepicker" id="startto" value="<?php if(!empty($holiday)){ echo $holiday->to_date; }?>"></div>
                                            </div>
											<!--
                                            <div class="form-group">
                                                <label class="control-label">Number of Days</label>
                                                <input type="number" name="nofdate" class="form-control" id="recipient-name1" readonly required>
                                            </div>-->
                                            <!--<div class="form-group">
                                                <label for="message-text" class="control-label"> Year</label>
                                                <input class="form-control mydatetimepicker" name="year" id="message-text1" required>
                                            </div> -->                                          
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                   <!-- <input type="hidden" name="id" value="" class="form-control" id="recipient-name1">                 -->                      
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    </form>