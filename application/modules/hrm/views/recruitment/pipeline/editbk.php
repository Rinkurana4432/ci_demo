
<?php if(!empty($rating)){ $rating = $rating[0];} ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/saveRating" enctype="multipart/form-data" id="JobApplication" novalidate="novalidate" style="">
   <div class="col-md-12 col-sm-12 col-xs-12 ">
      <div class="item form-group">
         <input type="hidden" id="applicant_id " name="applicant_id" value="<?php if(!empty($job_application)){echo $job_application->id;} ?>"/>
		<input type="hidden" id="id" name="id" value="<?php if(!empty($rating)){echo $rating['id'];} ?>"/>
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
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="rating">Qualification (s)</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="star-rating">
               <?php $rating1 = (!empty($rating)) ? $rating['qualification'] : 0; 
                  $countEmptyStar = 5-$rating1;
                  $i = 1;
                  while($i<=$rating1) {
                  echo '<s class="active"></s>';
                  $i++;
                  }
                  $j = 1;
                  while($j<=$countEmptyStar) {
                  echo '<s></s>';
                  $j++;
                  } ?>
				  <input type="hidden" name="qualification" id="hidden_qualification" class="form-control col-md-7 col-xs-12" placeholder="Qualification Rating" value="<?php if(!empty($rating)){echo $rating['qualification'];} ?>">

            </div>
            <!--<div class="show-result">No stars selected yet.</div>-->
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="rating">Job Knowledge</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="star-rating">
               <?php $rating2 = (!empty($rating)) ? $rating['job_Knowledge'] : 0; 
                  $countEmptyStar = 5-$rating2;
                  $i = 1;
                  while($i<=$rating2) {
                  echo '<s class="active"></s>';
                  $i++;
                  }
                  $j = 1;
                  while($j<=$countEmptyStar) {
                  echo '<s></s>';
                  $j++;
                  } ?>
				 <input type="hidden" name="job_Knowledge" id="hidden_Knowledge" class="form-control col-md-7 col-xs-12" placeholder="Rating" value="<?php if(!empty($rating)){echo $rating['job_Knowledge'];} ?>">

            </div>
            <!--<div class="show-result">No stars selected yet.</div>-->
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="rating">Experience Profile & Consistency in jobs</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="star-rating">
               <?php  $rating3 = (!empty($rating)) ? $rating['experience'] : 0; 
                  $countEmptyStar = 5-$rating3;
                  $i = 1;
                  while($i<=$rating3) {
                  echo '<s class="active"></s>';
                  $i++;
                  }
                  $j = 1;
                  while($j<=$countEmptyStar) {
                  echo '<s></s>';
                  $j++;
                  } ?>
				 <input type="hidden" name="experience" id="hidden_experience" class="form-control col-md-7 col-xs-12" placeholder="Rating" value="<?php if(!empty($rating)){echo $rating['experience'];} ?>">

            </div>
            <!--<div class="show-result">No stars selected yet.</div>-->
         </div>
      </div>

      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="rating">Awareness about Technical Dynamics</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="star-rating">
               <?php $rating4 = (!empty($rating)) ? $rating['technical_dynamics'] : 0; 
                  $countEmptyStar = 5-$rating4;
                  $i = 1;
                  while($i<=$rating4) {
                  echo '<s class="active"></s>';
                  $i++;
                  }
                  $j = 1;
                  while($j<=$countEmptyStar) {
                  echo '<s></s>';
                  $j++;
                  } ?>
		   <input type="hidden" name="technical_dynamics" id="hidden_technical_dynamics" class="form-control col-md-7 col-xs-12" placeholder="Awareness about Technical Dynamics" value="<?php if(!empty($rating)){echo $rating['technical_dynamics'];} ?>">

            </div>
            <!--<div class="show-result">No stars selected yet.</div>-->
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="rating">Interpersonal Skills/team spirit</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="star-rating">
               <?php $rating5 = (!empty($rating)) ? $rating['interpersonal_skills'] : 0; 
                  $countEmptyStar = 5-$rating5;
                  $i = 1;
                  while($i<=$rating5) {
                  echo '<s class="active"></s>';
                  $i++;
                  }
                  $j = 1;
                  while($j<=$countEmptyStar) {
                  echo '<s></s>';
                  $j++;
                  } ?>
				 <input type="hidden" name="interpersonal_skills" id="hidden_interpersonal_skills" class="form-control col-md-7 col-xs-12" placeholder="Interpersonal Skills" value="<?php if(!empty($rating)){echo $rating['interpersonal_skills'];} ?>">

            </div>
            <!--<div class="show-result">No stars selected yet.</div>-->
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="rating">Clarity Of Thoughts</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="star-rating">
               <?php $rating6 = (!empty($rating)) ? $rating['clarity_thoughts'] : 0; 
                  $countEmptyStar = 5-$rating6;
                  $i = 1;
                  while($i<=$rating6) {
                  echo '<s class="active"></s>';
                  $i++;
                  }
                  $j = 1;
                  while($j<=$countEmptyStar) {
                  echo '<s></s>';
                  $j++;
                  } ?>
				 <input type="hidden" name="clarity_thoughts" id="hidden_clarity_Of_thoughts" class="form-control col-md-7 col-xs-12" placeholder="Clarity Of Thoughts" value="<?php if(!empty($rating)){echo $rating['clarity_thoughts'];} ?>">

            </div>
            <!--<div class="show-result">No stars selected yet.</div>-->
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="rating">Achievement Orientation</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="star-rating">
               <?php $rating7 = (!empty($rating)) ? $rating['achievement_orientation'] : 0; 
                  $countEmptyStar = 5-$rating7;
                  $i = 1;
                  while($i<=$rating7) {
                  echo '<s class="active"></s>';
                  $i++;
                  }
                  $j = 1;
                  while($j<=$countEmptyStar) {
                  echo '<s></s>';
                  $j++;
                  } ?>
			  <input type="hidden" name="achievement_orientation" id="hidden_achievement_orientation" class="form-control col-md-7 col-xs-12" placeholder="Achievement Orientation" value="<?php if(!empty($rating)){echo $rating['achievement_orientation'];} ?>">
            </div>
            <!--<div class="show-result">No stars selected yet.</div>-->

         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="rating">Conceptual Clarity</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="star-rating">
               <?php $rating8 = (!empty($rating)) ? $rating['conceptual_clarity'] : 0; 
                  $countEmptyStar = 5-$rating8;
                  $i = 1;
                  while($i<=$rating8) {
                  echo '<s class="active"></s>';
                  $i++;
                  }
                  $j = 1;
                  while($j<=$countEmptyStar) {
                  echo '<s></s>';
                  $j++;
                  } ?>
				   <input type="hidden" name="conceptual_clarity" id="hidden_conceptual_clarity" class="form-control col-md-7 col-xs-12" placeholder="Conceptual Clarity" value="<?php if(!empty($rating)){echo $rating['conceptual_clarity'];} ?>">
            </div>
            <!--<div class="show-result">No stars selected yet.</div>-->

         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="rating">Leadership Ability/Pro-activeness</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="star-rating">
               <?php $rating9 = (!empty($rating)) ? $rating['leadership_ability'] : 0; 
                  $countEmptyStar = 5-$rating9;
                  $i = 1;
                  while($i<=$rating9) {
                  echo '<s class="active"></s>';
                  $i++;
                  }
                  $j = 1;
                  while($j<=$countEmptyStar) {
                  echo '<s></s>';
                  $j++;
                  } ?>
				  <input type="hidden" name="leadership_ability" id="hidden_leadership_ability" class="form-control col-md-7 col-xs-12" placeholder="Leadership Ability/Pro-activeness" value="<?php if(!empty($rating)){echo $rating['leadership_ability'];} ?>">

            </div>
            <!--<div class="show-result">No stars selected yet.</div>-->
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="rating">Convincing Power</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="star-rating">
               <?php $rating10 = (!empty($rating)) ? $rating['convincing_power'] : 0; 
                  $countEmptyStar = 5-$rating10;
                  $i = 1;
                  while($i<=$rating10) {
                  echo '<s class="active"></s>';
                  $i++;
                  }
                  $j = 1;
                  while($j<=$countEmptyStar) {
                  echo '<s></s>';
                  $j++;
                  } ?>
			<input type="hidden" name="convincing_power" id="hidden_convincing_power" class="form-control col-md-7 col-xs-12" placeholder="Convincing Power" value="<?php if(!empty($rating)){echo $rating['convincing_power'];} ?>">

            </div>
            <!--<div class="show-result">No stars selected yet.</div>-->
         </div>
      </div>
      <center>
         <div class="modal-footer">
            <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn edit-end-btn " value="Submit">
         </div>
      </center>
   </div>
</form>
<!-- //devlerp59@gmail.com --> 
<script type="text/javascript">
$(document).ready(function () {
	$("div.star-rating > s, div.star-rating-rtl > s").on("click", function (e) {
		// remove all active classes first, needed if user clicks multiple times
		$(this).closest('div').find('.active').removeClass('active');
		//$(e.target).parentsUntil("div").addClass('active'); // all elements up from the clicked one excluding self
		$(e.target).prevAll('s').addClass('active'); // all elements up from the clicked one excluding self	
		$(e.target).addClass('active'); // the element user has clicked on
		console.log('rrrrr=>>>', $(e.target).prevAll('s').length + 1);
		//var numStars = $(e.target).parentsUntil("div").length+1;
		var numStars = $(e.target).prevAll('s').length + 1;
		//alert(numStars)
		// var hidden_field = $(this).closest("div").find("input[type='hidden']").attr('id');
		// alert(hidden_field)
		$(this).closest("div").find("input[type='hidden']").val(numStars);
		//$('#hidden_rating').val(numStars);
	});
});
</script>

