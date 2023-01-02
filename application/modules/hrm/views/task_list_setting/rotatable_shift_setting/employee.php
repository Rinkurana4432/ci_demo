<style>
table.filtertable td, table.filtertable th {
    padding: 5px;
    vertical-align: middle !important;
    line-height: 20px;
    background: #F2F2F2;
    border-top: 1px solid #d3d3d7;
    border-left: 1px solid #d3d3d7;}
table.filtertable {padding-top: 19px;
    border-right: 1px solid #d3d3d7;
    border-bottom: 1px solid #d3d3d7;
	width:100%;
}
.filtertable th {
    width: 230px;
}
.columsss .item.form-group {
    margin: 0px;
}
.columsss .col-xs-12 {
    width: 100%;
    padding: 0px;
}
.columsss .datess input {
    width: 100%;
    height: 36px;
}
.dataTables_length,.dataTables_info{
    width: auto;
    float: left;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 37px;
}
.filtertable th label {
    text-align: center !important;
    width: 100%;
}
.shiftss div {
    float: left;
}
.shift-data-table .dataTables_wrapper {
    margin-top: 15px;
}
</style>

<?php $users = $this->hrm_model->get_data('user', array('user.c_id' => $this->companyGroupId, 'user.role' => 2, 'user.status' => 1));
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
               <input type="hidden" value='' class='start_date' name='startEmp'/>
               <input type="hidden" value='' class='end_date' name='endEmp'/>
               <input type="hidden" value='<?php if(!empty($_GET['tab'])){echo $_GET['tab'];}?>' name='tab'/>
            </form>
         </div>
         <!-- Filter div Start-->  
           <form action="<?php echo base_url(); ?>hrm/hrm_setting" method="get" >
            <input type="hidden" value='<?php if(!empty($_GET['startEmp'])){echo $_GET['startEmp'];}?>' class='start' name='startEmp'/>
            <input type="hidden" value='<?php if(!empty($_GET['endEmp'])){echo $_GET['endEmp'];} ?>' class='end' name='endEmp'/>
         </form>  
         <!-- Filter div End-->
      </div> 
</div>
</div>
                  <form action="<?php echo base_url(); ?>hrm/employeeShiftChange" method="post">
                     <table id="employeeShiftChange" class="table table-striped table-bordered account_index" cellspacing="0" width="100%">
                        <thead>
                           <tr>
                              <th><input type="checkbox"  id="selecctallEmp"  ></th>
                              <th>Employee Name</th>
                              <th>Employee ID</th>
                              <th>Employee Biometric Id</th>
                              <th style="width: 700px;"> </th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $sn=1; foreach ($users as $userAllActive) { 
                              $userNameData = getNameById('user_detail',$userAllActive['id'],'u_id');
                           
                              //  $employeeShift=[];
                              //  foreach ($employshiftChange as $key => $employshiftChangevalue) {
                               
                              //   if ($userAllActive['id']==$employshiftChange['employeeId']) {
                              //    $employeeShift[$userAllActive['id']]= $employshiftChange;
                              // } }
                              
                              ?>
                           <tr >
                              <th style="border-bottom: 1px solid #c6ced6 !important;"><input type="checkbox" name="checkboxEmp[]" class="checkboxEmp checkboxEmp[]" value="<?=$userAllActive['id']??'';?>"  ></th>
                              <th style="border-bottom: 1px solid #c6ced6 !important;"><?php if (!empty($userNameData->name)) { echo $userNameData->name; } else{ echo"N/A";} ?></th>
                              <th style="border-bottom: 1px solid #c6ced6 !important;"><?php if (!empty($userAllActive['id'])) { echo $userAllActive['id']; }else{ echo"N/A";} ?></th>
                              <th style="border-bottom: 1px solid #c6ced6 !important;"><?php if (!empty($userNameData->biometric_id)) { echo $userNameData->biometric_id; }else{ echo"N/A";} ?></th>
                              <th style="border-bottom: 1px solid #c6ced6 !important;" class="shiftss">
                                <?php if (!empty($employshiftChange)): ?>
                                                <table>
                                                    <tr>
                                                      <th>Department</th>
                                                      <th>Shift</th>
                                                      <th>Start Date  To  End Date </th>
                                                    </tr> 
                                                    <?php foreach ($employshiftChange as $empIdkey => $Shiftvalue) {
                                                      
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
                                          <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 compny_unit" id="compny_unit" required="required" name="company_unit" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
                                             <option value="">Select Unit</option>
                                             <?php
                                                if(!empty($workers)){
                                                    $getUnitName = getNameById('company_address',$workers->company_unit,'compny_branch_id');
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
                                          <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" id="department"  required="required" name="department_id"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = '<?php echo (!empty($workers))?$workers->company_branch:''; ?>'" >
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
                                       <div class="radio_button"></div>
                                       <div class="Displaymessage"></div>
                                       <?php }else{
                                          if(!empty($productionSetting)){
                                          foreach($productionSetting as $ps){   
                                            if($workers->department_id == $ps['department']){
                                          ?>
                                       <div class="radio_edit">
                                          <label>
                                          <input type="radio" class="flat" name="shift_id" value="<?php echo $ps['id']; ?>" <?php if($workers->shift_id == $ps['id']){echo 'checked';} ?>><?php echo $ps['shift_name']; ?></br>
                                          </label>
                                       </div>
                                       <?php } 
                                          }}?>
                                       <div class="radio_button"></div>
                                       <div class="Displaymessage"></div>
                                       <?php }?> 
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="columsss">
                                    <div class="item form-group datess">
                                       <input type="date"  name="shiftChangeStartDate" placeholder="Start Date">
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="columsss">
                                    <div class="item form-group datess">
                                       <input type="date"  name="employeeShiftEndDate" placeholder="End Date">
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