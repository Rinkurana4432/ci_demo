<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/saveTransitionAuthority" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">  
<!--  <input type="text" name="id" value="</?php if (!empty($authority_data)){ echo $authority_data->id;} ?>">
 -->   <input type="hidden" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">   <input type="hidden" value="<?php echo $row_id; ?>" name="row_id"> 
     <input type="hidden" value="<?php echo $col_id; ?>" name="col_id">  
          <?php if (empty($authority_data))
{ ?>    
  <!--div class="col-md-6 col-sm-12 col-xs-12 vertical-border">     
   <label class="col-md-3 col-xs-12">Role  <span class="required">*</span></label>   
      <div class="input_holder col-md-7 col-sm-12 col-xs-12">    
           <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" title="Select Option" name="role[]" data-id="task_list_role" data-key="id" data-fieldname="name" data-where="created_by_cid= <?php //echo $this->companyGroupId; ?>  OR created_by_cid=0" width="100%" tabindex="-1" aria-hidden="true" required="required">            <option value="">Select Option</option>         </select>      </div>  

		   </div-->   
           <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">      
           	<div class=" col-md-12 col-sm-12 col-xs-12">        
           	 <label class="col-md-3 col-xs-12">Assignee  <span class="required">*</span></label>      
           	    <div class="col-md-7 col-xs-7">        
           	     <!--    <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" title="Select Option" name="assignee" data-id="new_work_detail" data-key="id" data-fieldname="assigned_to" data-where="created_by_cid= </?php echo $this->companyGroupId; ?>  OR created_by_cid=0" width="100%" tabindex="-1" aria-hidden="true" required="required">               <option value="">Select Option</option>            </select>    -->
           	        <select class="form-control col-md-7 col-xs-12 change_repeation" name="assignee">
                            <option value="" disabled="" selected="">Choose option</option>
                            <option value="1">Yes</option>
                            <option  value="0">No</option>
                    </select> 
           	             </div>   
           	            </div>  
           	           </div>  	
           	        <div class="col-md-6 col-sm-12 col-xs-12 vertical-border" style="display:none;">    
           	          <div class=" col-md-12 col-sm-12 col-xs-12">     
           	             <label class="col-md-3 col-xs-12">Supervisor  <span class="required">*</span></label>   
           	              <div class="col-md-7 col-xs-7">      
           	                         <!--  <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="supervisor[]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=  </?php echo $this->companyGroupId; ?> OR created_by_cid=0"  id="material_type_id">               <option value="">Select Option</option>            </select>    -->   

           	                              <select class="form-control col-md-7 col-xs-12 change_repeation" name="supervisor">
                        							    <option value="" >Choose option</option>
                        							    <option value="1" selected>Yes</option>
                        							    <option  value="0">No</option>
                                           </select> 
           	                            </div>   
           	                     </div> 
           	              </div>
           	                             <div class="col-md-6 col-sm-12 col-xs-12 ">  
           	                              <div class="col-md-12 col-sm-12 col-xs-12"> 
           	                                <div class="input_holder1 middle-box col-md-12">                  
           	                                   <!--div class="col-sm-12 btn-row">
           	                                   	<button id="addMorefiledstransition_role" class="btn  plus-btn edit-end-btn addMorefiledstransition_role" type="button">Add Role</button>
           	                                   </div-->
									<?php
									}
									else
									{ ?> 
  <!--div class="col-md-6 col-sm-12 col-xs-12 vertical-border">  
      <label class="col-md-3 col-xs-12">Role  <span class="required">*</span></label>
        <div class="input_holder col-md-7 col-sm-12 col-xs-12">                          
			<?php
			$role = 0;
			$authority_data = $authority_data[0];
			$role = json_decode($authority_data['role']);
			foreach ($role as $val)
			{ 
			?>                           
			  <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible" title="Select Option" name="role[]" data-id="task_list_role" data-key="id" data-fieldname="name" data-where="created_by_cid= <?php echo $this->companyGroupId; ?> OR created_by_cid=0" width="100%" tabindex="-1" aria-hidden="true" required="required">        
				  <option value="">Select Option</option>                              
						 <?php if (!empty($authority_data)){

					$owner = getNameById('task_list_role', $val->role, 'id');
					if (!empty($owner))
					{
						echo '<option value="' . $val->role . '" selected>' . $owner->name . '</option>';
					}
								   } ?>           
			 </select>                       
						  <?php  } ?>  
			</div>   
		</div-->  
     <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">     
      <div class=" col-md-12 col-sm-12 col-xs-12">     
          <label class="col-md-3 col-xs-12">Assignee  <span class="required">*</span></label>   
                <div class="col-md-7 col-xs-7">    
   <?php 
             $selected_assignee_y = "";
             $selected_assignee_n = "";
             $selected_supervisor_y = "";
             $selected_supervisor_n = "";
      if (!empty($authority_data)){
              $assignee = $authority_data['assignee'];
              if($assignee == '1'){
              	$selected_assignee_y ="selected";
              }
              if($assignee == '0'){
              	$selected_assignee_n ="selected";
              }

        }  

        if (!empty($authority_data)){
              $supervisor = $authority_data['supervisor'];
              if($supervisor == '1'){
              	$selected_supervisor_y ="selected";
              }
              if($supervisor == '0'){
              	$selected_supervisor_n ="selected";
              }
           }   

          # pre($authority_data['supervisor']);
    ?>

                    <select class="form-control col-md-7 col-xs-12 change_repeation" name="assignee">
                            <option value="" disabled="" selected="">Choose option</option>
                            <option <?= $selected_assignee_y ?> value="1">Yes</option>
                            <option  <?= $selected_assignee_n ?> value="0">No</option>
                    </select> 

                      </div> 
         </div>   </div> 
          <div class="col-md-6 col-sm-12 col-xs-12 vertical-border" style="display:none;">    
            <div class=" col-md-12 col-sm-12 col-xs-12">     
                <label class="col-md-3 col-xs-12">Supervisor  <span class="required">*</span></label>     
                    <div class="col-md-7 col-xs-7">      
                          <?php                      
     
       ?>


         <select class="form-control col-md-7 col-xs-12 change_repeation" name="supervisor">
                            <option value="" disabled="" >Choose option</option>
                            <option <?= $selected_supervisor_y ?>  value="1" selected>Yes</option>
                            <option <?= $selected_supervisor_n ?>   value="0">No</option>
                    </select> 
      </div>    
        </div>  
         </div>   
    <div class="col-md-6 col-sm-12 col-xs-12 "> 
      <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="input_holder1 middle-box col-md-12">                    
           <!--div class="col-sm-12 btn-row">
           	<button id="addMorefiledstransition_role" class="btn  plus-btn edit-end-btn addMorefiledstransition_role" type="button">Add Role</button>
			</div-->
           	<?php
} ?>   <div class="modal-footer">    
			<center>         
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>				
			<input type="submit" class="btn btn-warning" value="Submit">   
			</center>
		   </div>
		</form>
