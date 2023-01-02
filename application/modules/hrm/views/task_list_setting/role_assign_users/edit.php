<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/saveRoleAssignedtoDetails" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
     <input type="hidden" name="id" value="<?php if(!empty($role_data)){ echo $role_data->id;} ?>">
      <input type="hidden" value="<?php  echo $this->companyGroupId; ?>" id="loggedUser">
     <div class="col-md-4 col-sm-12 col-xs-12 vertical-border">
  <div class="col-sm-12 btn-row">
  <!--   <button id="addMorefileds_user" class="btn  plus-btn edit-end-btn " type="button">Add User</button> -->
    <button id="addMorefileds_worker" class="btn  plus-btn edit-end-btn addMorefileds" type="button">Add Worker</button>
</div> 
    <div class="item form-group col-md-12 col-sm-12 col-xs-12">
        <label class=" col-md-3 col-sm-2 col-xs-4" for="work_detail">  Name<span class="required">*</span> </label>
        <div class="col-md-7 col-sm-10 col-xs-8">   
          
          <?php   $role_name = getNameById('task_list_role',$id,'id');  ?>
            <input type="text" readonly id=""  class="form-control col-md-7 col-xs-12" value="<?php if(!empty($role_name)){ echo $role_name->name;} ?>" required="required">
            <input type="hidden" id="" name="name" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($role_name)){ echo $role_name->id;} ?>" >
        </div>
    </div>
  
     
</div>

  <div class="col-md-6 col-sm-10 col-xs-8">
      <div class="input_holder middle-box col-md-12">
                     <?php  if(empty($role_data)){ ?>
                     <div class="col-sm-12  col-md-12 label-box mobile-view2">
                        
                        
                        <label class="col-md-12 col-xs-12">Worker   <span class="required">*</span></label> 
                     <div class="well mobile-view" id="chkIndex_1" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">
                    
                  
              <label class="col-md-12 col-xs-12">User   <span class="required">*</span></label>
                     <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                      
                      
                <div class="col-md-6">            
                <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="assigned_to_worker[]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid = <?php echo $this->companyGroupId;?> and active_inactive = 1 "  id="material_type_id">
                <option value="">Select Option</option>
                              </select>
                      </div>
                </div>
                         <?php }else{ 
                         
                         ?>
                                   <div class="col-sm-12  col-md-6 label-box mobile-view2">
                        <label class="col-md-2 col-sm-12 col-xs-12 "> Worker Name <span class="required">*</span></label>
                       
                    
                     <div class="well mobile-view" id="chkIndex_1" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">


     <?php
                       
                         $users_workers = json_decode($role_data->assigned_to_worker);
                   
                        if(isset($users_workers)){
                         foreach($users_workers as $assigned_to_worker){

                        ?>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label class="col-md-12 col-xs-12">Worker   Name <span class="required">*</span></label>
                     
                
                      <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="assigned_to_worker[]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid= <?php echo $this->companyGroupId;?>  and active_inactive = 1 "  id="material_type_id">
                                            <option value="">Select Option</option>
                                         <?php
                                            if(!empty($assigned_to_worker)){                                                
                                                $worker = getNameById('worker',$assigned_to_worker->assigned_to_worker,'id');
                                                if($worker->name!=''){
                                                    echo '<option value="'.$worker->id.'" selected>'.$worker->name.'</option>';
                                                }
                                            }
                                            ?>
                
                                                
                              </select>
                   
                    <button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button>
                    <?php }  ?>
                                   </div>
                     <?php }  }  ?>
                       
                       
                    
</div>
</div>            

 
</div>
</div>
 
</div>  

<!-- 
  <div class="col-md-6 col-sm-10 col-xs-8">
      <div class="input_holder1 middle-box col-md-12">
                     </?php  if(empty($role_data)){ ?>
                     <div class="col-sm-12  col-md-12 label-box mobile-view2">
                        
                        
                        <label class="col-md-12 col-xs-12">Worker   <span class="required">*</span></label> 
                     <div class="well mobile-view" id="chkIndex_1" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">
                    
                  
              <label class="col-md-12 col-xs-12">User   <span class="required">*</span></label>
                     <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                      
                      
                <div class="col-md-6">            
              <select class="itemName form-control " name="emid" id="emp_id" required="required">
               <option value="">Select Option</option>
              
               </?php  foreach($users1 as $user){?>
                    <option value="</?php echo $user['id'];?>"
                    </?php if(!empty($attval)){ if($attval->emp_id==$user['id']){echo 'Selected';}}?>>
                    </?php echo $user['name'];?></option>
                    </?php
             
                                             }
                  ?>
            </select>
                      </div>
                </div>
                         </?php }else{ 
                         
                         ?>
                                   <div class="col-sm-12  col-md-6 label-box mobile-view2">
                        <label class="col-md-2 col-sm-12 col-xs-12 ">  User Name <span class="required">*</span></label>
                       
                    
                     <div class="well mobile-view" id="chkIndex_1" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;">


     </?php
                       
                         $users_workers = json_decode($role_data->assigned_to_worker);
                   //   pre($users_workers);
                        if(isset($users_workers)){
                         foreach($users_workers as $assigned_to_worker){
                        ?>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label class="col-md-12 col-xs-12">Worker   Name <span class="required">*</span></label>
                     
                
                      <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="assigned_to_worker[]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid= </?php echo $this->companyGroupId;?>  and active_inactive = 1 "  id="material_type_id">
                                            <option value="">Select Option</option>
                                         </?php
                                            if(!empty($assigned_to_worker)){                                                
                                                $worker = getNameById('worker',$assigned_to_worker->assigned_to_worker,'id');
                                                if(!empty($owner)){
                                                    echo '<option value="'.$worker->id.'" selected>'.$worker->name.'</option>';
                                                }
                                            }
                                            ?>
                
                                                
                              </select>
                   
                    <button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button>
               





                           
                         </?php }  ?>
                                   </div>
                     </?php }  }  ?>

</div>  
</div>  
</div>  
</div>  
</div>  
</div>  
 -->
</div>

    <div class="modal-footer">
    <center>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                           
      <input type="submit" class="btn btn-warning" value="Submit">
     </center>
    </div>
</form>

 