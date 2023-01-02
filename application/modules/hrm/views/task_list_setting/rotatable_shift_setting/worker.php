 <?php $users = $this->hrm_model->get_data('worker', array('worker.created_by_cid' => $this->companyGroupId,'worker.active_inactive' => 1));
  ?>
 



 <div class="x_content">
    <div class="row hidde_cls">
        <div class="col-md-12 export_div">
                 <div class="control-group">
                        <div class="controls">
                            <div class="shift-data-table">
                                 <div class="col-md-12 col-xs-12 for-mobile"> 
     
   <div class="Filter Filter-btn2">
<button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo" aria-expanded="true"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
      <div id="demo" class="collapse" aria-expanded="true" style="">
         <div class="col-md-12 col-xs-12 datePick-left">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="hrm/hrm_setting">
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>hrm/hrm_setting" method="get" id="date_range">  
               <input type="hidden" value='' class='start_date' name='startWorker'/>
               <input type="hidden" value='' class='end_date' name='endWorker'/>
               <input type="hidden" value='<?php if(!empty($_GET['tab'])){echo $_GET['tab'];}?>' name='tab'/>
            </form>
         </div>
         <!-- Filter div Start-->  
           <form action="<?php echo base_url(); ?>hrm/hrm_setting" method="get" >
            <input type="hidden" value='<?php if(!empty($_GET['startWorker'])){echo $_GET['startWorker'];}?>' class='start' name='startWorker'/>
            <input type="hidden" value='<?php if(!empty($_GET['endWorker'])){echo $_GET['endWorker'];} ?>' class='end' name='endWorker'/>
         </form>  
         <!-- Filter div End-->
      </div> 
</div>
</div>
                                <form action="<?php echo base_url(); ?>hrm/workerShiftChange" method="post">                                   
                                  <table id="workerShiftChange" class="table table-striped table-bordered account_index" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox"  id="selecctallWorker"></th> 
                                                <th>Employee Name</th>
                                                <th>Employee ID</th>
                                                <th>Employee Biometric Id</th> 
                                                <th style="width: 700px;">  </th>
                                            </tr>
                                        </thead>
                                          <tbody>
                                           <?php $sn=1; foreach ($users as $userAllActive) {  
                                            ?>
                                             <tr> 
                                                 <th style="border-bottom: 1px solid #c6ced6 !important;"><input type="checkbox" name="checkboxEmp[]" class="checkboxEmp checkboxEmp[]" value="<?=$userAllActive['id']??'';?>"></th>
                                                 <th  style="border-bottom: 1px solid #c6ced6 !important;"><?php if (!empty($userAllActive['name'])) { echo $userAllActive['name']; } else{ echo"N/A";} ?></th>
                                                <th style="border-bottom: 1px solid #c6ced6 !important;"><?php if (!empty($userAllActive['id'])) { echo $userAllActive['id']; }else{ echo"N/A";} ?></th> 
                                                <th style="border-bottom: 1px solid #c6ced6 !important;"><?php if (!empty($userAllActive['biometric_id'])) { echo $userAllActive['biometric_id']; }else{ echo"N/A";} ?></th> 
                                                <th style="border-bottom: 1px solid #c6ced6 !important;" class="shiftss">
                                     <?php if (!empty($workershiftChange)): ?>
                                                <table>
                                                    <tr>
                                                      <th>Department</th>
                                                      <th>Shift</th>
                                                      <th>Start Date  To  End Date </th>
                                                    </tr> 
                                                    <?php foreach ($workershiftChange as $empIdkey => $Shiftvalue) {
                                                      
                                                      if ($Shiftvalue['employeeId']==$userAllActive['id']) {
                                                      
                                                        if (!empty($Shiftvalue['shift_id'])){
                                                  $shiftNameTime = getNameById('production_setting',$Shiftvalue['shift_id'],'id');  
                                                  $department = getNameById('department',$Shiftvalue['department_id'],'id');
                                                  ?>
                                                    <tr>
                                                      <td><?= $department->name??'' ?></td>
                                                      <td><?= $shiftNameTime->shift_name??'' ?></td>
                                                      <td><?= $Shiftvalue['shiftChangeStartDate']??''; ?> To <?=  $Shiftvalue['employeeShiftEndDate']??''; ?></td>
                                                   </tr>
                                                   <?php }}}  ?>
                                                 </table>
                                      <?php endif ?>
                              </th>
                                            </tr> 
                                          <?php $sn++; } ?>
                                        </tbody>
                                  </table>
                               
					   <table class="filtertable">
						  <tr>
                              <th><label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label></th>
                              <th> <label class="col-md-3 col-sm-3 col-xs-12">Department <span class="required">*</span> </label></th>
                              <th> <label class="col-md-3 col-sm-12 col-xs-12" for="textarea" >Shift <span class="required">*</span></label></th>
                              <th> <label class="col-md-3 col-sm-12 col-xs-12" for="textarea" >Start Date  <span class="required">*</span></label></th>
                              <th><label class="col-md-3 col-sm-12 col-xs-12" for="textarea" >End Date  <span class="required">*</span></label></th>
							  <th></th>
                           </tr>
                           <tr>
                              <td>
                                 <div class="columsss">
                                    <div class="item form-group">
                                       <div class="col-md-6 col-sm-12 col-xs-12">
                                        <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 compny_unit" id="compny_unitWorker" required="required" name="company_unit" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDeptWorker(event,this)">
                                               <option value="">Select Unit</option>
                                               <?php
                                                  if(!empty($workers)){
                                                      $getUnitName = getNameById('company_address',$workers->company_unit,'compny_branch_id');
                                                     echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                                                     echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                                                  }
                                                  
                                                  ?>
                                            </select>
                                       </div>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="columsss">
                                    <div class="item form-group">
                                       <div class="col-md-6 col-sm-12 col-xs-12"> 
                                          <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 departmentWorker" id="departmentWorker"  required="required" name="department_id"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid=</?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = '</?php echo (!empty($workers))?$workers->company_branch:''; ?>'" >
                                               <option value="">Select Option</option>
                                               <?php
                                                  if(!empty($workers)){
                                                     $departmentData = getNameById('department',$workers->department_id,'id');
                                                     if(!empty($departmentData)){
                                                        echo '<option value="'.$departmentData->id.'" selected>'.$departmentData->name.'</option>';
                                                     }
                                                  }
                                                  ?>                      
                                            </select>
                                       </div>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="columsss">
                                    <div class="item form-group">
                                       <?php if(empty($workers)){?>
                                       <div class="radio_buttonWorker"></div>
                                            <div class="DisplaymessageWorker"></div>
                                       <?php }else{
                                          if(!empty($productionSetting)){
                                          foreach($productionSetting as $ps){   
                                            if($workers->department_id == $ps['department']){
                                          ?>
                                       <div class="radio_editWorker">
                                          <label>
                                          <input type="radio" class="flat" name="shift_id" value="<?php echo $ps['id']; ?>" <?php if($workers->shift_id == $ps['id']){echo 'checked';} ?>><?php echo $ps['shift_name']; ?></br>
                                          </label>
                                       </div>
                                       <?php } 
                                          }}?>
                                      <div class="radio_buttonWorker"></div>
                                            <div class="DisplaymessageWorker"></div>
                                       <?php }?> 
                                    </div>
                                 </div>
                              </td>
                             <td>
                                 <div class="columsss">
                                    <div class="item form-group datess">
                                       <input type="date"   name="shiftChangeStartDate" placeholder="Start Date">
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="columsss">
                                    <div class="item form-group datess">
                                       <input type="date"   name="employeeShiftEndDate" placeholder="End Date">
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="columsss">
                                    <input type="submit" style="color: #fff;" class="btn edit-end-btn addBtn" value="submit">
                                 </div>
                              </td>
                           </tr>
                           
                        </table>
                                </form>
                            </div>
                        </div>
                   </div>
              </div>
         </div>
    </div>
