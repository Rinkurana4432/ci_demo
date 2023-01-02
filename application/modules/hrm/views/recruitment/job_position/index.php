
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
<div class="x_content">
<div class="col-md-12 col-sm-12 for-mobile">
      <div class="Filter Filter-btn2">
		   <form class="form-search" method="get" action="<?= base_url() ?>hrm/recruitment">
		   <div class="col-md-6">
			  <div class="input-group">
				 <span class="input-group-addon">
				 <i class="ace-icon fa fa-check"></i>
				 </span>
				 <input type="text" class="form-control search-query" placeholder="Enter Designation,Department" name="search" id="search" data-ctrl="hrm/recruitment" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
				 <span class="input-group-btn">
				 <button type="submit" class="btn btn-purple btn-sm">
				 <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
				 Search
				 </button>
				 <a href="<?php echo base_url(); ?>hrm/recruitment">
				 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
				 </span>
			  </div>
		   </div>
		</form>	
		<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="addJobPosition">Add Job Position</button>
</div>
</div>
</div>

<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="loggedInUserId">
    
   <table id="" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
         <tr>
            <th>Id
			<span><a href="<?php echo base_url(); ?>hrm/recruitment?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/recruitment?sort=desc" class="down"></a></span></th>
            <th>Designation
			<span><a href="<?php echo base_url(); ?>hrm/recruitment?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/recruitment?sort=desc" class="down"></a></span></th>
            <th>Department
			<span><a href="<?php echo base_url(); ?>hrm/recruitment?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/recruitment?sort=desc" class="down"></a></span></th>
            <th>Location
			<span><a href="<?php echo base_url(); ?>hrm/recruitment?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/recruitment?sort=desc" class="down"></a></span></th>
            <th>Created Date</th>
            <th>Modified Date</th>
		 	<th class='hidde'>Validate</th> 
            <th>Action</th>
			
         </tr>
      </thead>
      <tbody>
         <?php 
                            $can_edit   = edit_permissions();
         foreach($job_position as $job){
# pre($job); 
			 ?>
         <tr>
            <td class="job_position_id"><?php echo $job['id'];?></td>
            <td><?php echo $job['designation'];?></td>
            <td><?php echo $job['department'];?></td>
            <td><?php echo $job['location'];?></td>
            <td><?php echo $job['created_date'];?></td>
            <td><?php echo $job['modified_date'];?></td> 
            
            <?php $can_validate = ""; ?>
				<td class='hidde'> 
				<?php 
		       if($can_edit){
				$disable = ($job["approve"] == 1)?'disabled':''; // if PI is in draft than it will not be approved or disapprove
					$disableEdit = (($job["approve"] == 1))?'disabled':''; // if job card is in draft than it will not be approved or disapprove
					$validatedBy = ($job['validated_by']!=0)?(getNameById('user_detail',$job['validated_by'],'u_id')):''; 
					$validatedByName = (!empty($validatedBy))?$validatedBy->name:''; // get the name of user who validate the PI	
							$selectApprove = $job['approve']==1?'checked':'';
							$selectDisapprove = $job['disapprove']==1?'checked':'';
							if($selectApprove =='checked'){

							echo "
							Approve:
								<input type='radio' class='validate' name='status_".$job['id']."' value='Approve'/ ".$selectApprove." ".$disable."> 
							Disapprove:
								<input type='radio' class='disapprove' name='status_".$job['id']."' value='Disapprove'/ ".$selectDisapprove.$disable." disabled>
								
								<p class='validatedBy'>Validated By: ".$validatedByName."</p>";
							}else{
								echo "
								Approve:
								<input type='radio' class='validate' name='status_".$job['id']."' value='Approve'/ ".$selectApprove.$disable."> Disapprove:
								<input type='radio' class='disapprove' name='status_".$job['id']."' value='Disapprove'/ ".$selectDisapprove.$disable.">
								<p class='disapprove_reason'>".$job['disapprove_reason']."</p>
								<p class='validatedBy'>Validated By: ".$validatedByName."</p>";
						 
							}
							}else{     if($job['approve'] == '1') { echo 'Approved';   }elseif($job['approve'] == '0'){ echo "Disapproved"; }        }
				?>
			</td>
			<td class="action">
			   <i class='fa fa-cog'></i>
			    <div class='on-hover-action'>
               <button type="button" data-id="editJobPosition"  class="btn btn-edit btn-xs hrmTab" data-toggle="modal" id="<?php echo $job['id'];?>">Edit</button>
               <button type="button" data-id="viewJobPosition"  class="btn btn-view btn-xs hrmTab" data-toggle="modal" id="<?php echo $job['id'];?>">View</button>
               <a href="<?php base_url();?>hrm/delete_job_position/<?php echo $job['id'];?>" class="btn btn-delete btn-xs">Delete</a>
			  </div>
            </td>
         </tr>
         <?php }?>
      </tbody>
   </table>
     <?php  echo $this->pagination->create_links(); ?>
<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
</div>
<div id="printThis">
   <div id="hrm_modal" class="modal fade in btnPrint"  role="dialog">
      <div class="modal-dialog modal-lg modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Job Position</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade disapproveReasonModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg  ">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Reason</h4>
				</div>
				<div class="modal-body">
					<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/disApproveJobPosition" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
					<input type="hidden" name="id" value="" id="job_position_id">
					<input type="hidden" id="validated_by" name="validated_by" value="<?php echo $_SESSION['loggedInUser']->id; ?>">
					<input type="hidden" id="disapprove" name="disapprove" value="1">
					<input type="hidden" id="approve" name="approve" value="0">
					<div class="item form-group">													
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comments<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">														
							<textarea id="disapprove_reason" required="required" rows="6" name="disapprove_reason" class="form-control col-md-7 col-xs-12" placeholder=""></textarea>													
							</div>												
						</div>							
						<div class="modal-footer">
						  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
						  <input type="submit" class="btn btn edit-end-btn " value="Submit">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>