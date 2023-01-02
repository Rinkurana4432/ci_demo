<div class="x_content">
   <form method="post" class="form-horizontal" enctype="multipart/form-data" id="JobApplication" novalidate="novalidate" style="">
      <div class="col-md-12 col-sm-12 col-xs-12 ">
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12" >Name <span class="required">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <?php # pre($job_application);die; ?>
               <?php if(!empty($job_application)){echo $job_application->name;} ?>	
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12" >Email</label>
            <div class="col-md-3 col-sm-3 col-xs-6">
               <?php if(!empty($job_application)){echo $job_application->email;} ?>
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12" >Phone no</label>
            <div class="col-md-3 col-sm-3 col-xs-6">
               <?php if(!empty($job_application)){echo $job_application->phone_no;} ?>
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12">Resume Upload</label>
            <div class="col-md-3 col-sm-3 col-xs-6">
               <?php if(!empty($job_application)){ echo $job_application->resume_upload; echo '<a download="'.$job_application->resume_upload.'" href="'.base_url().'assets/modules/hrm/uploads/'.$job_application->resume_upload.'"><img style="display: block;" src="'.base_url().'assets/images/docX.png"  height="80" width="80"/><i class="fa fa-download"></i></a>'; }
			   ?>
			   
            </div>
         </div>
         <?php //
            if(!empty($attachments)){ ?>
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12" for="proof">Other Documents</label>
            <div class="col-md-3 col-sm-3 col-xs-6">			
               <?php 
                  foreach($attachments as $proofs){	
                  //pre($proofs);die;
                  	 $ext = pathinfo($proofs['file_name'], PATHINFO_EXTENSION);
                  	if($ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg' || $ext == 'png' || $ext == 'ico'){
                  		echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'" alt="image" height="80" width="80"/><i class="fa fa-download"></i> 
                  		<div class="mask">
                  				<a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'hrm/delete_doc/'.$proofs['id'].'/'.$job_application->id.'">
                  				<i class="fa fa-trash"></i>
                  				</a>
                  			</div></div></div>';			
                  	}else if($ext == 'ods' || $ext ==  'doc' || $ext ==  'docx' ){
                  		echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/docX.png"  height="80" width="80"/><i class="fa fa-download"></i> 
                  		<div class="mask">
                  				<a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'hrm/delete_doc/'.$proofs['id'].'/'.$job_application->id.'">
                  				<i class="fa fa-trash"></i>
                  				</a>
                  			</div></div></div>';	
                  	}else if($ext == 'pdf'){
                  		echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/PDF.png"  height="80" width="80"/><i class="fa fa-download"></i> 
                  		<div class="mask">
                  				<a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'hrm/delete_doc/'.$proofs['id'].'/'.$job_application->id.'">
                  				<i class="fa fa-trash"></i>
                  				</a>
                  			</div></div></div>';	
                  	}else if($ext == 'xlsx'){
                  		echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/excel.png"  height="80" width="80"/><i class="fa fa-download"></i> 
                  		<div class="mask">
                  				<a href="javascript:void(0)" class="delete_listing btn btn-danger" data-href="'.base_url().'hrm/delete_doc/'.$proofs['id'].'/'.$job_application->id.'">
                  				<i class="fa fa-trash"></i>
                  				</a>
                  		</div></div></div>';	
                  	}
                  }
                  
                  ?>				
            </div>
         </div>
         <?php } ?>
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12">Reference</label>
            <div class="col-md-3 col-sm-3 col-xs-6">
               <?php if(!empty($job_application)){echo $job_application->reference;} ?>
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12">Job Position</label>
            <div class="col-md-3 col-sm-3 col-xs-6">
               <?php foreach($job_position as $job){?>
               <?php if(!empty($job_application)){ if($job_application->job_position_id== $job['id']){echo $job['designation'];}}?>
               <?php }?>
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12">Short Intro</label>
            <div class="col-md-3 col-sm-3 col-xs-6">
               <?php if(!empty($job_application)){echo $job_application->short_intro;} ?>
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12">Expected Salary</label>
            <div class="col-md-3 col-sm-3 col-xs-6">
               <?php if(!empty($job_application)){echo $job_application->exp_salary;} ?>
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12">Created At </label>
            <div class="col-md-3 col-sm-3 col-xs-6">
               <?php if(!empty($job_application)){echo $job_application->created_date;} ?>
            </div>
         </div>
         <div class="item form-group">
            <label class="col-md-3 col-sm-3 col-xs-12">Modified At</label>
            <div class="col-md-3 col-sm-3 col-xs-6">
               <?php if(!empty($job_application)){echo $job_application->modified_date;} ?>
            </div>
         </div>
         <!--<center>
            <div class="modal-footer">
               <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>					  
            </div>
            </center>-->
      </div>
   </form>
   <hr />
   <div class="bottom-bdr"></div>
   <div class="" role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a href="#first_view" role="tab" id="first_tab" data-toggle="tab" aria-expanded="false">First Round</a></li>
         <li role="presentation" class=""><a href="#second_view" id="second_tab" role="tab" data-toggle="tab" aria-expanded="true">Second Round</a></li>
         <li role="presentation" class=""><a href="#third_view" id="third_tab" role="tab" data-toggle="tab" aria-expanded="true">Third Round</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <?php $first_round = $second_round = $third_round = array();
            if(!empty($rating_data)){ 
            foreach($rating_data as $rate){
            if($rate['interview_step'] == 5){
            $first_round  = $rate;
            }elseif($rate['interview_step'] == 6){
            $second_round  = $rate;
            }elseif($rate['interview_step'] == 7){
            $third_round = $rate;
            }
            }
             } ?>
         <div role="tabpanel" class="tab-pane fade active in" id="first_view" aria-labelledby="First_Round">
            <?php    if(!empty($first_round)){ 
               //pre($first_round);?>
            <form action="">
               <table class="likert" cellspacing="0">
                  <caption id="title2">
                     First Round Interview Assessment Performance Evaluation<
                  </caption>
                  <thead>
                     <tr>
                        <th>Success Factor</th>
                        <td>Exceeds Expectations</td>
                        <td>Partially exceeds expectations</td>
                        <td>Meets Expectations</td>
                        <td>Partially meets Expectation</td>
                        <td>Does not meets Expectation</td>
                     </tr>
                  </thead>
                  <tbody>
                     <tr role="radiogroup" aria-labelledby="Field-2" class="statement2">
                        <th>
                           <label   for="step_1">
                           Functional knowledge - Depth and breadth of reach
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_1" type="radio" role="radio" 
                              <?php   if($first_round['step_1']=='5') echo "checked='checked'";  ?> tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);" >
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_1" type="radio" <?php   if(!empty($first_round)){  echo set_value('step_1', $first_round['step_1']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_1" type="radio" role="radio" <?php if(!empty($first_round)){  echo set_value('step_1', $first_round['step_1']) == 3 ? "checked" : "";  } ?> tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_1" type="radio" role="radio" <?php if(!empty($first_round)){ echo set_value('step_1', $first_round['step_1']) == 2 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_1" type="radio" role="radio" <?php if(!empty($first_round)){ echo set_value('step_1', $first_round['step_1']) == 1 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="Field-3" class="alt statement3">
                        <th>
                           <label   for="step_2">
                           Delivering Superior Results- Go getter(initiative,energy,drive)
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_2" type="radio" <?php if(!empty($first_round)){  echo set_value('step_2', $first_round['step_2']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_2" <?php if(!empty($first_round)){  echo set_value('step_2', $first_round['step_2']) == 4 ? "checked" : ""; } ?> type="radio" role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_2" type="radio"  <?php if(!empty($first_round)){  echo set_value('step_2', $first_round['step_2']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_2" type="radio" role="radio"  <?php if(!empty($first_round)){  echo set_value('step_2', $first_round['step_2']) == 2 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_2" type="radio" role="radio"  <?php if(!empty($first_round)){  echo set_value('step_2', $first_round['step_2']) == 1 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_3" class="statement4">
                        <th>
                           <label  for="Field4">
                           Team involvement- cross functional orientation
                           </label>
                        </th>
                        <td title="5">
                           <input  name="step_3" type="radio" <?php if(!empty($first_round)){  echo set_value('step_3', $first_round['step_3']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_3" type="radio" <?php if(!empty($first_round)){  echo set_value('step_3', $first_round['step_3']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_3" type="radio" <?php if(!empty($first_round)){  echo set_value('step_3', $first_round['step_3']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_3" type="radio" <?php if(!empty($first_round)){  echo set_value('step_3', $first_round['step_3']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_3" type="radio" <?php  if(!empty($first_round)){ echo set_value('step_3', $first_round['step_3']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_4" class="statement4">
                        <th>
                           <label  for="Field4">
                           Continuous learning & application of learning
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_4" type="radio" <?php if(!empty($first_round)){  echo set_value('step_4', $first_round['step_4']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_4" type="radio" <?php  if(!empty($first_round)){ echo set_value('step_4', $first_round['step_4']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_4" type="radio" <?php  if(!empty($first_round)){ echo set_value('step_4', $first_round['step_4']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_4" type="radio" <?php if(!empty($first_round)){  echo set_value('step_4', $first_round['step_4']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_4" type="radio" <?php if(!empty($first_round)){  echo set_value('step_4', $first_round['step_4']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_5" class="statement4">
                        <th>
                           <label  for="Field4">
                           Communication Skills
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_5" type="radio" role="radio" <?php if(!empty($first_round)){  echo set_value('step_5', $first_round['step_5']) == 5 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_5" type="radio" <?php  if(!empty($first_round)){ echo set_value('step_5', $first_round['step_5']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_5" type="radio" <?php if(!empty($first_round)){  echo set_value('step_5', $first_round['step_5']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_5" type="radio" <?php if(!empty($first_round)){  echo set_value('step_5', $first_round['step_5']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_5" type="radio" role="radio" <?php if(!empty($first_round)){  echo set_value('step_5', $first_round['step_5']) == 1 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_6" class="statement4">
                        <th>
                           <label  for="Field4">
                           Maturity of thoughts and approach
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_6" type="radio" role="radio" <?php if(!empty($first_round)){ echo set_value('step_6', $first_round['step_6']) == 5 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_6" type="radio" <?php  if(!empty($first_round)){ echo set_value('step_6', $first_round['step_6']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_6" type="radio" role="radio" <?php if(!empty($first_round)){  echo set_value('step_6', $first_round['step_6']) == 3 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_6" type="radio" role="radio" <?php  if(!empty($first_round)){ echo set_value('step_6', $first_round['step_6']) == 2 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_6" type="radio" <?php  if(!empty($first_round)){ echo set_value('step_6', $first_round['step_6']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_7" class="statement4">
                        <th>
                           <label  for="Field4">
                           Customer focus
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_7" type="radio" <?php if(!empty($first_round)){  echo set_value('step_7', $first_round['step_7']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_7" type="radio" <?php if(!empty($first_round)){  echo set_value('step_7', $first_round['step_7']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_7" type="radio" <?php if(!empty($first_round)){  echo set_value('step_7', $first_round['step_7']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_7" type="radio" <?php if(!empty($first_round)){  echo set_value('step_7', $first_round['step_7']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_7" type="radio" <?php  if(!empty($first_round)){ echo set_value('step_7', $first_round['step_7']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_8" class="statement4">
                        <th>
                           <label  for="Field4">
                           Adaptability
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_8" type="radio" <?php  if(!empty($first_round)){ echo set_value('step_8', $first_round['step_8']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_8" type="radio" <?php if(!empty($first_round)){ echo set_value('step_8', $first_round['step_8']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_8" type="radio" <?php  if(!empty($first_round)){ echo set_value('step_8', $first_round['step_8']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_8" type="radio" <?php  if(!empty($first_round)){ echo set_value('step_8', $first_round['step_8']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_8" type="radio" <?php if(!empty($first_round)){  echo set_value('step_8', $first_round['step_8']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <hr />
               <div class="bottom-bdr"></div>
               <div class="item form-group">
                  <label class="col-md-2 col-sm-3 col-xs-12">Overall Comments</label>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                     <textarea name='overall_comment' class="form-control col-md-7 col-xs-12"><?php if(!empty($first_round)){ echo $first_round['overall_comment']; } ?>	</textarea>
                  </div>
               </div>
               <hr />
               <div class="bottom-bdr"></div>
               <table class="likert" cellspacing="0">
                  <caption id="title2">
                     Would you like to offer this person a position?
                  </caption>
                  <thead>
                     <tr>
                        <th>Yes</th>
                        <th>No</th>
                        <th>Not Sure</th>
                        <th>Suitable for any other Position</th>
                        <th>Not Suitable for any  Position</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr role="radiogroup" aria-labelledby="step_9" class="statement2">
                        <td title="5">
                           <input   name="step_9" type="radio" <?php if(!empty($first_round)){  echo set_value('step_9', $first_round['step_9']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5"></label>
                        </td>
                        <td title="4">
                           <input  name="step_9" type="radio" <?php if(!empty($first_round)){  echo set_value('step_9', $first_round['step_9']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4"></label>
                        </td>
                        <td title="3">
                           <input   name="step_9" type="radio" <?php if(!empty($first_round)){  echo set_value('step_9', $first_round['step_9']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3"></label>
                        </td>
                        <td title="2">
                           <input   name="step_9" type="radio" <?php if(!empty($first_round)){  echo set_value('step_9', $first_round['step_9']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2"></label>
                        </td>
                        <td title="1">
                           <input  name="step_9" type="radio" <?php  if(!empty($first_round)){ echo set_value('step_9', $first_round['step_9']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1"></label>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </form>
            <?php }else{ ?>
            <p>First Round Performance Evaluation Not Done Yet</p>
            <?php } ?>
         </div>
         <div role="tabpanel" class="tab-pane fade" id="second_view" aria-labelledby="Second_Round">
            <?php  if(!empty($second_round)){ ?>
            <form action="">
               <table class="likert" cellspacing="0">
                  <caption id="title2">
                     Second Round Interview Assessment Performance Evaluation
                  </caption>
                  <thead>
                     <tr>
                        <th>Success Factor</th>
                        <td>Exceeds Expectations</td>
                        <td>Partially exceeds expectations</td>
                        <td>Meets Expectations</td>
                        <td>Partially meets Expectation</td>
                        <td>Does not meets Expectation</td>
                     </tr>
                  </thead>
                  <tbody>
                     <tr role="radiogroup" aria-labelledby="Field-2" class="statement2">
                        <th>
                           <label   for="step_1">
                           Functional knowledge - Depth and breadth of reach
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_1" type="radio" role="radio" <?php  if(!empty($second_round)){ echo set_value('step_1', $second_round['step_1']) == 5 ? "checked" : ""; }  ?> tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);" >
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_1" type="radio" <?php   if(!empty($second_round)){  echo set_value('step_1', $second_round['step_1']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_1" type="radio" role="radio" <?php if(!empty($second_round)){  echo set_value('step_1', $second_round['step_1']) == 3 ? "checked" : "";  } ?> tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_1" type="radio" role="radio" <?php if(!empty($second_round)){ echo set_value('step_1', $second_round['step_1']) == 2 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_1" type="radio" role="radio" <?php if(!empty($second_round)){ echo set_value('step_1', $second_round['step_1']) == 1 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="Field-3" class="alt statement3">
                        <th>
                           <label   for="step_2">
                           Delivering Superior Results- Go getter(initiative,energy,drive)
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_2" type="radio" <?php if(!empty($second_round)){  echo set_value('step_2', $second_round['step_2']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_2" <?php if(!empty($second_round)){  echo set_value('step_2', $second_round['step_2']) == 4 ? "checked" : ""; } ?> type="radio" role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_2" type="radio"  <?php if(!empty($second_round)){  echo set_value('step_2', $second_round['step_2']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_2" type="radio" role="radio"  <?php if(!empty($second_round)){  echo set_value('step_2', $second_round['step_2']) == 2 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_2" type="radio" role="radio"  <?php if(!empty($second_round)){  echo set_value('step_2', $second_round['step_2']) == 1 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_3" class="statement4">
                        <th>
                           <label  for="Field4">
                           Team involvement- cross functional orientation
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_3" type="radio" <?php if(!empty($second_round)){  echo set_value('step_3', $second_round['step_3']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_3" type="radio" <?php if(!empty($second_round)){  echo set_value('step_3', $second_round['step_3']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_3" type="radio" <?php if(!empty($second_round)){  echo set_value('step_3', $second_round['step_3']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_3" type="radio" <?php if(!empty($second_round)){  echo set_value('step_3', $second_round['step_3']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_3" type="radio" <?php  if(!empty($second_round)){ echo set_value('step_3', $second_round['step_3']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_4" class="statement4">
                        <th>
                           <label  for="Field4">
                           Continuous learning & application of learning
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_4" type="radio" <?php if(!empty($second_round)){  echo set_value('step_4', $second_round['step_4']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_4" type="radio" <?php  if(!empty($second_round)){ echo set_value('step_4', $second_round['step_4']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_4" type="radio" <?php  if(!empty($second_round)){ echo set_value('step_4', $second_round['step_4']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_4" type="radio" <?php if(!empty($second_round)){  echo set_value('step_4', $second_round['step_4']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_4" type="radio" <?php if(!empty($second_round)){  echo set_value('step_4', $second_round['step_4']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_5" class="statement4">
                        <th>
                           <label  for="Field4">
                           Communication Skills
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_5" type="radio" role="radio" <?php if(!empty($second_round)){  echo set_value('step_5', $second_round['step_5']) == 5 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_5" type="radio" <?php  if(!empty($second_round)){ echo set_value('step_5', $second_round['step_5']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_5" type="radio" <?php if(!empty($second_round)){  echo set_value('step_5', $second_round['step_5']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_5" type="radio" <?php if(!empty($second_round)){  echo set_value('step_5', $second_round['step_5']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_5" type="radio" role="radio" <?php if(!empty($second_round)){  echo set_value('step_5', $second_round['step_5']) == 1 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_6" class="statement4">
                        <th>
                           <label  for="Field4">
                           Maturity of thoughts and approach
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_6" type="radio" role="radio" <?php if(!empty($second_round)){ echo set_value('step_6', $second_round['step_6']) == 5 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_6" type="radio" <?php  if(!empty($second_round)){ echo set_value('step_6', $second_round['step_6']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_6" type="radio" role="radio" <?php if(!empty($second_round)){  echo set_value('step_6', $second_round['step_6']) == 3 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_6" type="radio" role="radio" <?php  if(!empty($second_round)){ echo set_value('step_6', $second_round['step_6']) == 2 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_6" type="radio" <?php  if(!empty($second_round)){ echo set_value('step_6', $second_round['step_6']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_7" class="statement4">
                        <th>
                           <label  for="Field4">
                           Customer focus
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_7" type="radio" <?php if(!empty($second_round)){  echo set_value('step_7', $second_round['step_7']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_7" type="radio" <?php if(!empty($second_round)){  echo set_value('step_7', $second_round['step_7']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_7" type="radio" <?php if(!empty($second_round)){  echo set_value('step_7', $second_round['step_7']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_7" type="radio" <?php if(!empty($second_round)){  echo set_value('step_7', $second_round['step_7']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_7" type="radio" <?php  if(!empty($second_round)){ echo set_value('step_7', $second_round['step_7']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_8" class="statement4">
                        <th>
                           <label  for="Field4">
                           Adaptability
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_8" type="radio" <?php  if(!empty($second_round)){ echo set_value('step_8', $second_round['step_8']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_8" type="radio" <?php if(!empty($second_round)){ echo set_value('step_8', $second_round['step_8']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_8" type="radio" <?php  if(!empty($second_round)){ echo set_value('step_8', $second_round['step_8']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_8" type="radio" <?php  if(!empty($second_round)){ echo set_value('step_8', $second_round['step_8']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_8" type="radio" <?php if(!empty($second_round)){  echo set_value('step_8', $second_round['step_8']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <hr />
               <div class="bottom-bdr"></div>
               <div class="item form-group">
                  <label class="col-md-2 col-sm-3 col-xs-12">Overall Comments</label>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                     <textarea name='overall_comment' class="form-control col-md-7 col-xs-12"><?php if(!empty($second_round)){ echo $second_round['overall_comment']; } ?>	</textarea>
                  </div>
               </div>
               <hr />
               <div class="bottom-bdr"></div>
               <table class="likert" cellspacing="0">
                  <caption id="title2">
                     Would you like to offer this person a position?
                  </caption>
                  <thead>
                     <tr>
                        <th>Yes</th>
                        <th>No</th>
                        <th>Not Sure</th>
                        <th>Suitable for any other Position</th>
                        <th>Not Suitable for any  Position</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr role="radiogroup" aria-labelledby="step_9" class="statement2">
                        <td title="5">
                           <input   name="step_9" type="radio" <?php if(!empty($second_round)){  echo set_value('step_9', $second_round['step_9']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5"></label>
                        </td>
                        <td title="4">
                           <input  name="step_9" type="radio" <?php if(!empty($second_round)){  echo set_value('step_9', $second_round['step_9']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4"></label>
                        </td>
                        <td title="3">
                           <input   name="step_9" type="radio" <?php if(!empty($second_round)){  echo set_value('step_9', $second_round['step_9']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3"></label>
                        </td>
                        <td title="2">
                           <input   name="step_9" type="radio" <?php if(!empty($second_round)){  echo set_value('step_9', $second_round['step_9']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2"></label>
                        </td>
                        <td title="1">
                           <input  name="step_9" type="radio" <?php  if(!empty($second_round)){ echo set_value('step_9', $second_round['step_9']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1"></label>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </form>
            <?php }else{ ?>
            <p>Second Round Performance Evaluation Not Done Yet</p>
            <?php } ?>
         </div>
         <div role="tabpanel" class="tab-pane fade" id="third_view" aria-labelledby="Third_Round">
            <?php if(!empty($third_round)){ ?>
            <form action="">
               <table class="likert" cellspacing="0">
                  <caption id="title2">
                     Third Round Interview Assessment Performance Evaluation<
                  </caption>
                  <thead>
                     <tr>
                        <th>Success Factor</th>
                        <td>Exceeds Expectations</td>
                        <td>Partially exceeds expectations</td>
                        <td>Meets Expectations</td>
                        <td>Partially meets Expectation</td>
                        <td>Does not meets Expectation</td>
                     </tr>
                  </thead>
                  <tbody>
                     <tr role="radiogroup" aria-labelledby="Field-2" class="statement2">
                        <th>
                           <label   for="step_1">
                           Functional knowledge - Depth and breadth of reach
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_1" type="radio" role="radio" <?php  if(!empty($third_round)){ echo set_value('step_1', $third_round['step_1']) == 5 ? "checked" : ""; }  ?> tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);" >
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_1" type="radio" <?php   if(!empty($third_round)){  echo set_value('step_1', $third_round['step_1']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_1" type="radio" role="radio" <?php if(!empty($third_round)){  echo set_value('step_1', $third_round['step_1']) == 3 ? "checked" : "";  } ?> tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_1" type="radio" role="radio" <?php if(!empty($third_round)){ echo set_value('step_1', $third_round['step_1']) == 2 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_1" type="radio" role="radio" <?php if(!empty($third_round)){ echo set_value('step_1', $third_round['step_1']) == 1 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="Field-3" class="alt statement3">
                        <th>
                           <label   for="step_2">
                           Delivering Superior Results- Go getter(initiative,energy,drive)
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_2" type="radio" <?php if(!empty($third_round)){  echo set_value('step_2', $third_round['step_2']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_2" <?php if(!empty($third_round)){  echo set_value('step_2', $third_round['step_2']) == 4 ? "checked" : ""; } ?> type="radio" role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_2" type="radio"  <?php if(!empty($third_round)){  echo set_value('step_2', $third_round['step_2']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_2" type="radio" role="radio"  <?php if(!empty($third_round)){  echo set_value('step_2', $third_round['step_2']) == 2 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_2" type="radio" role="radio"  <?php if(!empty($third_round)){  echo set_value('step_2', $third_round['step_2']) == 1 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_3" class="statement4">
                        <th>
                           <label  for="Field4">
                           Team involvement- cross functional orientation
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_3" type="radio" <?php if(!empty($third_round)){  echo set_value('step_3', $third_round['step_3']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_3" type="radio" <?php if(!empty($third_round)){  echo set_value('step_3', $third_round['step_3']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_3" type="radio" <?php if(!empty($third_round)){  echo set_value('step_3', $third_round['step_3']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_3" type="radio" <?php if(!empty($third_round)){  echo set_value('step_3', $third_round['step_3']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_3" type="radio" <?php  if(!empty($third_round)){ echo set_value('step_3', $third_round['step_3']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_4" class="statement4">
                        <th>
                           <label  for="Field4">
                           Continuous learning & application of learning
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_4" type="radio" <?php if(!empty($third_round)){  echo set_value('step_4', $third_round['step_4']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_4" type="radio" <?php  if(!empty($third_round)){ echo set_value('step_4', $third_round['step_4']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_4" type="radio" <?php  if(!empty($third_round)){ echo set_value('step_4', $third_round['step_4']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_4" type="radio" <?php if(!empty($third_round)){  echo set_value('step_4', $third_round['step_4']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_4" type="radio" <?php if(!empty($third_round)){  echo set_value('step_4', $third_round['step_4']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_5" class="statement4">
                        <th>
                           <label  for="Field4">
                           Communication Skills
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_5" type="radio" role="radio" <?php if(!empty($third_round)){  echo set_value('step_5', $third_round['step_5']) == 5 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_5" type="radio" <?php  if(!empty($third_round)){ echo set_value('step_5', $third_round['step_5']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_5" type="radio" <?php if(!empty($third_round)){  echo set_value('step_5', $third_round['step_5']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_5" type="radio" <?php if(!empty($third_round)){  echo set_value('step_5', $third_round['step_5']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_5" type="radio" role="radio" <?php if(!empty($third_round)){  echo set_value('step_5', $third_round['step_5']) == 1 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_6" class="statement4">
                        <th>
                           <label  for="Field4">
                           Maturity of thoughts and approach
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_6" type="radio" role="radio" <?php if(!empty($third_round)){ echo set_value('step_6', $third_round['step_6']) == 5 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_6" type="radio" <?php  if(!empty($third_round)){ echo set_value('step_6', $third_round['step_6']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_6" type="radio" role="radio" <?php if(!empty($third_round)){  echo set_value('step_6', $third_round['step_6']) == 3 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_6" type="radio" role="radio" <?php  if(!empty($third_round)){ echo set_value('step_6', $third_round['step_6']) == 2 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_6" type="radio" <?php  if(!empty($third_round)){ echo set_value('step_6', $third_round['step_6']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_7" class="statement4">
                        <th>
                           <label  for="Field4">
                           Customer focus
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_7" type="radio" <?php if(!empty($third_round)){  echo set_value('step_7', $third_round['step_7']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_7" type="radio" <?php if(!empty($third_round)){  echo set_value('step_7', $third_round['step_7']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_7" type="radio" <?php if(!empty($third_round)){  echo set_value('step_7', $third_round['step_7']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_7" type="radio" <?php if(!empty($third_round)){  echo set_value('step_7', $third_round['step_7']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_7" type="radio" <?php  if(!empty($third_round)){ echo set_value('step_7', $third_round['step_7']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                     <tr role="radiogroup" aria-labelledby="step_8" class="statement4">
                        <th>
                           <label  for="Field4">
                           Adaptability
                           </label>
                        </th>
                        <td title="5">
                           <input   name="step_8" type="radio" <?php  if(!empty($third_round)){ echo set_value('step_8', $third_round['step_8']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5">5</label>
                        </td>
                        <td title="4">
                           <input  name="step_8" type="radio" <?php if(!empty($third_round)){ echo set_value('step_8', $third_round['step_8']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4">4</label>
                        </td>
                        <td title="3">
                           <input   name="step_8" type="radio" <?php  if(!empty($third_round)){ echo set_value('step_8', $third_round['step_8']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3">3</label>
                        </td>
                        <td title="2">
                           <input   name="step_8" type="radio" <?php  if(!empty($third_round)){ echo set_value('step_8', $third_round['step_8']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2">2</label>
                        </td>
                        <td title="1">
                           <input  name="step_8" type="radio" <?php if(!empty($third_round)){  echo set_value('step_8', $third_round['step_8']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1">1</label>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <hr />
               <div class="bottom-bdr"></div>
               <div class="item form-group">
                  <label class="col-md-2 col-sm-3 col-xs-12">Overall Comments</label>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                     <textarea name='overall_comment' class="form-control col-md-7 col-xs-12"><?php if(!empty($third_round)){ echo $third_round['overall_comment']; } ?>	</textarea>
                  </div>
               </div>
               <hr />
               <div class="bottom-bdr"></div>
               <table class="likert" cellspacing="0">
                  <caption id="title2">
                     Would you like to offer this person a position?
                  </caption>
                  <thead>
                     <tr>
                        <th>Yes</th>
                        <th>No</th>
                        <th>Not Sure</th>
                        <th>Suitable for any other Position</th>
                        <th>Not Suitable for any  Position</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr role="radiogroup" aria-labelledby="step_9" class="statement2">
                        <td title="5">
                           <input   name="step_9" type="radio" <?php if(!empty($third_round)){  echo set_value('step_9', $third_round['step_9']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                           <label for="Field2_5"></label>
                        </td>
                        <td title="4">
                           <input  name="step_9" type="radio" <?php if(!empty($third_round)){  echo set_value('step_9', $third_round['step_9']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                           <label for="Field2_4"></label>
                        </td>
                        <td title="3">
                           <input   name="step_9" type="radio" <?php if(!empty($third_round)){  echo set_value('step_9', $third_round['step_9']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                           <label for="Field2_3"></label>
                        </td>
                        <td title="2">
                           <input   name="step_9" type="radio" <?php if(!empty($third_round)){  echo set_value('step_9', $third_round['step_9']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                           <label for="Field2_2"></label>
                        </td>
                        <td title="1">
                           <input  name="step_9" type="radio" <?php  if(!empty($third_round)){ echo set_value('step_9', $third_round['step_9']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                           <label for="Field2_1"></label>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </form>
            <?php }else{ ?>
            <p>Third Round Performance Evaluation Not Done Yet</p>
            <?php } ?>
         </div>
      </div>
   </div>
</div>