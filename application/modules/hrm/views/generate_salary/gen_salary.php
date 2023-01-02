 <form method="post" action="pay_salary_add_record" id="generatePayrollForm" enctype="multipart/form-data">
            <div class="modal-body">
             
              <div class="row "> 
              <div class="col-md-6  vertical-border">
              <div class="form-group item ">
                <label class="col-md-3 col-sm-12 col-xs-12">Employee</label>
                <div class="col-md-6">
                <select class="itemName form-control selectAjaxOption select2  selectedEmployeeID" name="emid" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $this->companyGroupId; ?>" width="100%" tabindex="-1" aria-hidden="true" required="required">
                                                        <option value="">Select Option</option>
                                                        <?php
                                                        if(!empty($salary_data)){                                               
                                                            $owner = getNameById('user_detail',$salary_data['empid'],'u_id');
                                                            echo '<option selected value="'.$salary_data['empid'].'">  '.$owner->name.'</option>';
                                                        }
                                                        ?>
                                        </select>
				</div>
                </div>                                
              <div class="form-group item ">
                <label class="col-md-3 col-sm-12 col-xs-12">Month
                </label>
                <div class="col-md-6">
                <input type="hidden" name="year" value="<?php echo $salary_data['year']; ?>">
                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="month" id="salaryMonth" required>

                  <option value="#">Select Here
                  </option>
                  <option value="1">January
                  </option>
                  <option value="2">February
                  </option>
                  <option value="3">March
                  </option>
                  <option value="4">April
                  </option>
                  <option value="5">May
                  </option>
                  <option value="6">June
                  </option>
                  <option value="7">July
                  </option>
                  <option value="8">August
                  </option>
                  <option value="9">September
                  </option>
                  <option value="10">October
                  </option>
                  <option value="11">November
                  </option>
                  <option value="12">December
                  </option>
                </select>
                </div>
              </div>			  
              <div class="form-group item ">
                <label class=" col-md-3 col-sm-12 col-xs-12">Basic Salary
                </label>
                <div class="col-md-6">
                <input type="text" name="basic" class="form-control" id="" value="<?php echo $salary_data['basic_salary']; ?>">
              </div> 
              </div>                                     
              <div class="form-group item ">
                <label class="col-md-3 col-sm-12 col-xs-12">Working hours
                </label>
                <div class="col-md-6">
                    <input type="text" name="month_work_hours" class="form-control thour" value="<?php echo $salary_data['total_work_hours']; ?>" readonly>
                </div>
              </div>                                       
              <div class="form-group item ">
                <label class="col-md-3 col-sm-12 col-xs-12">Hours worked
                </label>
                <div class="col-md-6">
                <input type="text" name="hours_worked" class="form-control hours_worked" id="" value="<?php echo $salary_data['employee_actually_worked']; ?>">
                <span>Work Without Pay:</span><span class="wpay"><?php echo $salary_data['wpay']; ?></span> <span>hrs</span>
                </div>
              </div>                                       
              <div class="form-group item " style="display:none">
                <label class="col-md-3 col-sm-12 col-xs-12">
                </label>
                <div class="col-md-6">
                <input type="hidden" name="hrate" class="form-control hrate" id="hrate" value='<?php echo $salary_data['rate']; ?>'>
                </div>
              </div>                                    
              <div class="form-group item " id="addition">
                <label class="col-md-3 col-sm-12 col-xs-12">Addition
                </label>
                <div class="col-md-6">
                <input type="text" name="addition" class="form-control" id="" value="<?php echo $salary_data['addition']; ?>">
              </div>
              </div>
                          
              </div>
              <div class="col-md-6 vertical-border">  
				<div class="form-group item ">
                <label class="col-md-3 col-sm-12 col-xs-12">Pay Date
                </label>
                <div class="col-md-6">
                  <input type="date" name="paydate" class="form-control mydatetimepickerFull" id="" value="" required>
                </div>
              </div>  			  
              <div class="form-group item " id="diduction">
                <label class="col-md-3 col-sm-12 col-xs-12">Deduction
                </label>
                <div class="col-md-6">
                <input type="text" name="diduction" class="form-control diduction" id="" value="<?php echo $salary_data['diduction']; ?>">
              </div>                                      
              </div>                                      
              <div class="form-group item " id="loan">
                <label class="col-md-3 col-sm-12 col-xs-12">Loan
                </label>
                <div class="col-md-6">
                  <input type="text" name="loan" class="form-control loan" id="" value="">
                </div>
              </div>                                    
              <div class="form-group item ">
                <label class="col-md-3 col-sm-12 col-xs-12">Final Salary
                </label>
                <div class="col-md-6">
                   <input type="text" name="total_paid" class="form-control total_paid" id="" value="<?php echo $salary_data['final_salary']; ?>" required>
                </div>
              </div>
              <!--<div class="form-group row">
                <label class="control-label text-left col-md-5">Status
                </label>
                <div class="col-md-7">
                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="status" required>
                  <option value="#">Select Here
                  </option>
                  <option value="Paid">Paid
                  </option>
                  <option value="Process">Process
                  </option>
                </select>    
              </div>     
              </div>-->
				<div class="form-group item ">
					<label class="col-md-3 col-sm-12 col-xs-12">Status</label><br>
					<div class="col-md-6">
					<input name="status" type="radio" id="radio_1" data-value="Paid" class="duration" value="Paid" checked="checked">
					<label for="radio_1">Paid</label>
					<input name="status" type="radio" id="radio_2" data-value="Process" class="type" value="Process">
					<label for="radio_2">Process</label>
					</div>
				</div> 
              <div class="form-group item ">
					<label class="col-md-3 col-sm-12 col-xs-12">Paid Type</label><br>
					<div class="col-md-7">
					<input name="paid_type" type="radio" id="radio_3" data-value="Hand Cash" class="" value="Hand Cash" checked="checked">
					<label for="radio_3" style="margin-left: 20px">Hand Cash</label>
					<input name="paid_type" type="radio" id="radio_4" data-value="Bank" class="type" value="Bank">
					<label for="radio_4" style="margin-left: 20px">Bank</label>
					</div>
				</div> 				
              </div>              
              </div>   
              <!--<div class="form-group row" style="margin-top:                 <label class="control-label text-left col-md-3">Paid Type
                </label>
                <div class="col-md-9">
                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="paid_type" required>
                  <option value="#">Select Here
                  </option>
                  <option value="Hand Cash">Hand Cash
                  </option>
                  <option value="Bank">Bank
                  </option>
                </select>
                </div>                 
              </div>-->
				                            
            </div>
            <div class="modal-footer">
            <center>  <input type="hidden" name="action" value="add" class="form-control" id="formAction">              
              <input type="hidden" name="loan_id" value="" class="form-control" id="loanID">                                      
              <button type="button" class="btn btn-default" data-dismiss="modal">Close
              </button>
              <button type="submit" class="btn btn-primary">Submit
              </button>
			 </center>
            </div>
          </form>