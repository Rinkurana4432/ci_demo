<style>

</style>
<?php if(!empty($rating)){ $rating = $rating[0];}
//pre($rating);
 ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/saveRating" enctype="multipart/form-data" id="JobApplication" novalidate="novalidate" style="">
   <div class="col-md-12 col-sm-12 col-xs-12 ">
      <header id="header" class="info">
         <h2 class="">Interview Assessment Performance Evaluation</h2>
         <div class="">First Round</div>
      </header>
      <div class="item form-group">
         <input type="hidden" id="applicant_id " name="applicant_id" value="<?php if(!empty($job_application)){echo $job_application->id;} ?>"/>
         <input type="hidden" id="id" name="id" value="<?php if(!empty($rating)){ echo $rating['id'];} ?>"/>
         <input type="hidden" id="interview_step" name="interview_step" value="<?php if(!empty($job_application)){echo $job_application->status;} ?>"/>
         <label class="col-md-3 col-sm-3 col-xs-12" >Name 
         </label>
         <div class="col-md-3 col-sm-3 col-xs-6">
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
         <label class="col-md-3 col-sm-3 col-xs-12">Job Position<span class="required">*</span></label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <?php foreach($job_position as $job){?>
            <?php if(!empty($job_application)){ if($job_application->job_position_id== $job->id){echo $job->designation;}}?>
            <?php }?>
         </div>
      </div>
      <hr />
      <div class="bottom-bdr"></div>
      <table class="likert" cellspacing="0">
         <caption id="title2">
             Job Knowledge
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
                  <label  for="step_1">
                  Functional knowledge - Depth and breadth of reach
                  </label>
               </th>
               <td title="5">
                  <input  name="step_1" type="radio" role="radio" <?php  if(!empty($rating)){ echo set_value('step_1', $rating['step_1']) == 5 ? "checked" : ""; }  ?> tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);" >
                  <label for="Field2_5">5</label>
               </td>
               <td title="4">
                  <input  name="step_1" type="radio" <?php   if(!empty($rating)){  echo set_value('step_1', $rating['step_1']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                  <label for="Field2_4">4</label>
               </td>
               <td title="3">
                  <input  name="step_1" type="radio" role="radio" <?php if(!empty($rating)){  echo set_value('step_1', $rating['step_1']) == 3 ? "checked" : "";  } ?> tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                  <label for="Field2_3">3</label>
               </td>
               <td title="2">
                  <input  name="step_1" type="radio" role="radio" <?php if(!empty($rating)){ echo set_value('step_1', $rating['step_1']) == 2 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                  <label for="Field2_2">2</label>
               </td>
               <td title="1">
                  <input  name="step_1" type="radio" role="radio" <?php if(!empty($rating)){ echo set_value('step_1', $rating['step_1']) == 1 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                  <label for="Field2_1">1</label>
               </td>
            </tr>
            <tr role="radiogroup" aria-labelledby="Field-3" class="alt statement3">
               <th>
                  <label  for="step_2">
                  Delivering Superior Results- Go getter(initiative,energy,drive)
                  </label>
               </th>
               <td title="5">
                  <input  name="step_2" type="radio" <?php if(!empty($rating)){  echo set_value('step_2', $rating['step_2']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                  <label for="Field2_5">5</label>
               </td>
               <td title="4">
                  <input  name="step_2" <?php if(!empty($rating)){  echo set_value('step_2', $rating['step_2']) == 4 ? "checked" : ""; } ?> type="radio" role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                  <label for="Field2_4">4</label>
               </td>
               <td title="3">
                  <input  name="step_2" type="radio"  <?php if(!empty($rating)){  echo set_value('step_2', $rating['step_2']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                  <label for="Field2_3">3</label>
               </td>
               <td title="2">
                  <input  name="step_2" type="radio" role="radio"  <?php if(!empty($rating)){  echo set_value('step_2', $rating['step_2']) == 2 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                  <label for="Field2_2">2</label>
               </td>
               <td title="1">
                  <input  name="step_2" type="radio" role="radio"  <?php if(!empty($rating)){  echo set_value('step_2', $rating['step_2']) == 1 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                  <label for="Field2_1">1</label>
               </td>
            </tr>
            <tr role="radiogroup" aria-labelledby="step_3" class="statement4">
               <th>
                  <label id="Field-4" for="Field4">
                  Team involvement- cross functional orientation
                  </label>
               </th>
               <td title="5">
                  <input  name="step_3" type="radio" <?php if(!empty($rating)){  echo set_value('step_3', $rating['step_3']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                  <label for="Field2_5">5</label>
               </td>
               <td title="4">
                  <input  name="step_3" type="radio" <?php if(!empty($rating)){  echo set_value('step_3', $rating['step_3']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                  <label for="Field2_4">4</label>
               </td>
               <td title="3">
                  <input  name="step_3" type="radio" <?php if(!empty($rating)){  echo set_value('step_3', $rating['step_3']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                  <label for="Field2_3">3</label>
               </td>
               <td title="2">
                  <input  name="step_3" type="radio" <?php if(!empty($rating)){  echo set_value('step_3', $rating['step_3']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                  <label for="Field2_2">2</label>
               </td>
               <td title="1">
                  <input  name="step_3" type="radio" <?php  if(!empty($rating)){ echo set_value('step_3', $rating['step_3']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                  <label for="Field2_1">1</label>
               </td>
            </tr>
            <tr role="radiogroup" aria-labelledby="step_4" class="statement4">
               <th>
                  <label id="Field-4" for="Field4">
                  Continuous learning & application of learning
                  </label>
               </th>
               <td title="5">
                  <input  name="step_4" type="radio" <?php if(!empty($rating)){  echo set_value('step_4', $rating['step_4']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                  <label for="Field2_5">5</label>
               </td>
               <td title="4">
                  <input  name="step_4" type="radio" <?php  if(!empty($rating)){ echo set_value('step_4', $rating['step_4']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                  <label for="Field2_4">4</label>
               </td>
               <td title="3">
                  <input  name="step_4" type="radio" <?php  if(!empty($rating)){ echo set_value('step_4', $rating['step_4']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                  <label for="Field2_3">3</label>
               </td>
               <td title="2">
                  <input  name="step_4" type="radio" <?php if(!empty($rating)){  echo set_value('step_4', $rating['step_4']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                  <label for="Field2_2">2</label>
               </td>
               <td title="1">
                  <input  name="step_4" type="radio" <?php if(!empty($rating)){  echo set_value('step_4', $rating['step_4']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                  <label for="Field2_1">1</label>
               </td>
            </tr>
            <tr role="radiogroup" aria-labelledby="step_5" class="statement4">
               <th>
                  <label id="Field-4" for="Field4">
                  Communication Skills
                  </label>
               </th>
               <td title="5">
                  <input  name="step_5" type="radio" role="radio" <?php if(!empty($rating)){  echo set_value('step_5', $rating['step_5']) == 5 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                  <label for="Field2_5">5</label>
               </td>
               <td title="4">
                  <input  name="step_5" type="radio" <?php  if(!empty($rating)){ echo set_value('step_5', $rating['step_5']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                  <label for="Field2_4">4</label>
               </td>
               <td title="3">
                  <input  name="step_5" type="radio" <?php if(!empty($rating)){  echo set_value('step_5', $rating['step_5']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                  <label for="Field2_3">3</label>
               </td>
               <td title="2">
                  <input  name="step_5" type="radio" <?php if(!empty($rating)){  echo set_value('step_5', $rating['step_5']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                  <label for="Field2_2">2</label>
               </td>
               <td title="1">
                  <input  name="step_5" type="radio" role="radio" <?php if(!empty($rating)){  echo set_value('step_5', $rating['step_5']) == 1 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                  <label for="Field2_1">1</label>
               </td>
            </tr>
            <tr role="radiogroup" aria-labelledby="step_6" class="statement4">
               <th>
                  <label id="Field-4" for="Field4">
                  Maturity of thoughts and approach
                  </label>
               </th>
               <td title="5">
                  <input  name="step_6" type="radio" role="radio" <?php if(!empty($rating)){ echo set_value('step_6', $rating['step_6']) == 5 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                  <label for="Field2_5">5</label>
               </td>
               <td title="4">
                  <input  name="step_6" type="radio" <?php  if(!empty($rating)){ echo set_value('step_6', $rating['step_6']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                  <label for="Field2_4">4</label>
               </td>
               <td title="3">
                  <input  name="step_6" type="radio" role="radio" <?php if(!empty($rating)){  echo set_value('step_6', $rating['step_6']) == 3 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                  <label for="Field2_3">3</label>
               </td>
               <td title="2">
                  <input  name="step_6" type="radio" role="radio" <?php  if(!empty($rating)){ echo set_value('step_6', $rating['step_6']) == 2 ? "checked" : ""; } ?> tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                  <label for="Field2_2">2</label>
               </td>
               <td title="1">
                  <input  name="step_6" type="radio" <?php  if(!empty($rating)){ echo set_value('step_6', $rating['step_6']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                  <label for="Field2_1">1</label>
               </td>
            </tr>
            <tr role="radiogroup" aria-labelledby="step_7" class="statement4">
               <th>
                  <label id="Field-4" for="Field4">
                  Customer focus
                  </label>
               </th>
               <td title="5">
                  <input  name="step_7" type="radio" <?php if(!empty($rating)){  echo set_value('step_7', $rating['step_7']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                  <label for="Field2_5">5</label>
               </td>
               <td title="4">
                  <input  name="step_7" type="radio" <?php if(!empty($rating)){  echo set_value('step_7', $rating['step_7']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                  <label for="Field2_4">4</label>
               </td>
               <td title="3">
                  <input  name="step_7" type="radio" <?php if(!empty($rating)){  echo set_value('step_7', $rating['step_7']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                  <label for="Field2_3">3</label>
               </td>
               <td title="2">
                  <input  name="step_7" type="radio" <?php if(!empty($rating)){  echo set_value('step_7', $rating['step_7']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                  <label for="Field2_2">2</label>
               </td>
               <td title="1">
                  <input  name="step_7" type="radio" <?php  if(!empty($rating)){ echo set_value('step_7', $rating['step_7']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                  <label for="Field2_1">1</label>
               </td>
            </tr>
            <tr role="radiogroup" aria-labelledby="step_8" class="statement4">
               <th>
                  <label id="Field-4" for="Field4">
                  Adaptability
                  </label>
               </th>
               <td title="5">
                  <input  name="step_8" type="radio" <?php  if(!empty($rating)){ echo set_value('step_8', $rating['step_8']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                  <label for="Field2_5">5</label>
               </td>
               <td title="4">
                  <input  name="step_8" type="radio" <?php if(!empty($rating)){ echo set_value('step_8', $rating['step_8']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                  <label for="Field2_4">4</label>
               </td>
               <td title="3">
                  <input  name="step_8" type="radio" <?php  if(!empty($rating)){ echo set_value('step_8', $rating['step_8']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                  <label for="Field2_3">3</label>
               </td>
               <td title="2">
                  <input  name="step_8" type="radio" <?php  if(!empty($rating)){ echo set_value('step_8', $rating['step_8']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                  <label for="Field2_2">2</label>
               </td>
               <td title="1">
                  <input  name="step_8" type="radio" <?php if(!empty($rating)){  echo set_value('step_8', $rating['step_8']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
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
            <textarea name='overall_comment' class="form-control col-md-7 col-xs-12"><?php if(!empty($rating)){ echo $rating['overall_comment']; } ?>	</textarea>
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
                  <input  name="step_9" type="radio" <?php if(!empty($rating)){  echo set_value('step_9', $rating['step_9']) == 5 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="5" onchange="handleInput(this);">
                  <label for="Field2_5"></label>
               </td>
               <td title="4">
                  <input  name="step_9" type="radio" <?php if(!empty($rating)){  echo set_value('step_9', $rating['step_9']) == 4 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="4" onchange="handleInput(this);">
                  <label for="Field2_4"></label>
               </td>
               <td title="3">
                  <input  name="step_9" type="radio" <?php if(!empty($rating)){  echo set_value('step_9', $rating['step_9']) == 3 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="3" onchange="handleInput(this);">
                  <label for="Field2_3"></label>
               </td>
               <td title="2">
                  <input  name="step_9" type="radio" <?php if(!empty($rating)){  echo set_value('step_9', $rating['step_9']) == 2 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="2" onchange="handleInput(this);">
                  <label for="Field2_2"></label>
               </td>
               <td title="1">
                  <input  name="step_9" type="radio" <?php  if(!empty($rating)){ echo set_value('step_9', $rating['step_9']) == 1 ? "checked" : ""; } ?> role="radio" tabindex="0" aria-checked="false" value="1" onchange="handleInput(this);">
                  <label for="Field2_1"></label>
               </td>
            </tr>
         </tbody>
      </table>
	   <center>
         <div class="modal-footer">
            <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn edit-end-btn " value="Submit">
         </div>
      </center>
   </div>
</form>