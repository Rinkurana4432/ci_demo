<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/save_job_application" enctype="multipart/form-data" id="JobApplication" novalidate="novalidate" style="">
   <div class="col-md-12 col-sm-12 col-xs-12 ">
   <div class="item form-group">
      <input type="hidden" id="id" name="id" value="<?php if(!empty($job_application)){echo $job_application->id;} ?>"/>
      <label class="col-md-3 col-sm-3 col-xs-12" >Name <span class="required">*</span>
      </label>
      <div class="col-md-3 col-sm-3 col-xs-6">
         <input id="para" class="form-control col-md-7 col-xs-12" name="name" value="<?php if(!empty($job_application)){echo $job_application->name;} ?>" type="text" required>		
      </div>
   </div>
   <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12" >Email</label>
      <div class="col-md-3 col-sm-3 col-xs-6">
         <input id="ins" class="form-control col-md-7 col-xs-12" value="<?php if(!empty($job_application)){echo $job_application->email;} ?>" name="email" type="email" >
      </div>
   </div>
   <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12" >Phone no</label>
      <div class="col-md-3 col-sm-3 col-xs-6">
         <input class="form-control col-md-7 col-xs-12" name="phone_no" value="<?php if(!empty($job_application)){echo $job_application->phone_no;} ?>" type="number" >
      </div>
   </div>
   <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12">Resume Upload</label>
      <div class="col-md-3 col-sm-3 col-xs-6">
          <input class="form-control col-md-7 col-xs-12"  name="resume_upload" type="file">
         <?php if(!empty($job_application)){echo $job_application->resume_upload;} ?>
         <input name="resume_upload1" type="hidden" value="<?php if(!empty($job_application)){echo $job_application->resume_upload;} ?>">
      </div>
   </div>
   <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12">Other Documents Upload</label>
	  
      <div class="col-md-3 col-sm-3 col-xs-6 cand_document_wrapper">
         <div class="col-md-9 col-sm-11 col-xs-12" style="margin-bottom: 3%;     padding-left: 0px; ">
            <input class="form-control col-md-7 col-xs-12" id="document_1" name="attachment[]" type="file">
         </div>
         <a href="javascript:void(0);" class="btn edit-end-btn  add_more_docs" id="add_cand_document_btn">Add</a>
      </div>
   </div>
    <?php //
	 if(!empty($attachments)){ ?>
	<div class="item form-group">
		<label class="control-label col-md-3 col-sm-2 col-xs-12" for="proof"></label>
		<div class="col-md-7">			
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
         <input class="form-control col-md-7 col-xs-12" name="reference" type="text" value="<?php if(!empty($job_application)){echo $job_application->reference;} ?>">
      </div>
   </div>
   <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12">Job Position<span class="required">*</span></label>
      <div class="col-md-3 col-sm-3 col-xs-6">
         <select class="form-control col-md-7 col-xs-12"  name="job_position_id" required>
            <option>Select</option>
            <?php foreach($job_position as $job){?>
            <option value="<?php echo $job['id']; ?>" <?php if(!empty($job_application)){ if($job_application->job_position_id== $job['id']){echo 'selected';}}?>><?php echo $job['designation']; ?></option>
            <?php }?>
         </select>
      </div>
   </div>
   <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12">Short Intro</label>
      <div class="col-md-3 col-sm-3 col-xs-6">
         <textarea name="short_intro" class="form-control col-md-7 col-xs-12" rows="4" cols="12"><?php if(!empty($job_application)){echo $job_application->short_intro;} ?></textarea>
      </div>
   </div>
   <div class="item form-group">
      <label class="col-md-3 col-sm-3 col-xs-12">Expected Salary</label>
      <div class="col-md-3 col-sm-3 col-xs-6">
         <input class="form-control col-md-7 col-xs-12" name="exp_salary" type="number" value="<?php if(!empty($job_application)){echo $job_application->exp_salary;} ?>">
      </div>
   </div>
   <center>
      <div class="modal-footer">
         <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>
         <input type="submit" class="btn btn edit-end-btn " value="Submit">
      </div>
   </center>
</form>
<!-- //devlerp59@gmail.com --> 
<script type="text/javascript">
   $(document).ready(function(){
   	var x = 1;
   	var max_fields = 15; 
   	$("#add_cand_document_btn").click(function(e){
   		e.preventDefault();
   		//$(".cand_document_wrapper")
          if(x < max_fields){ //max input box allowed
              x++; 
   		$(".cand_document_wrapper").append('<div style="padding:0px;" class="item form-group col-md-12 col-sm-12 col-xs-12"><div class="col-md-9 col-sm-11 col-xs-12" style="padding-left: 0px;"><input class="form-control col-md-7 col-xs-12" name="attachment[]" type="file"></div><button class="btn btn-danger remove_cand_document_btn" type="button"><i class="fa fa-minus"></i></button></div>');
          }
   	});
   
   	$(".cand_document_wrapper").on("click",".remove_cand_document_btn", function(e){ //user click on remove text
   	    e.preventDefault(); 
   	    $(this).parent('div').remove(); 
   	    x--;
   	});
   });
</script>