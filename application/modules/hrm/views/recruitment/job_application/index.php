
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
<div class="x_content">
<div class="col-md-12 col-sm-12 for-mobile">
      <div class="Filter Filter-btn2">
   <form class="form-search" method="get" action="<?= base_url() ?>hrm/job_application">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter Name,Email,Phone_no" name="search" id="search" data-ctrl="hrm/job_application" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
		 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?= base_url() ?>hrm/job_application'" value="Reset">
         </span>
      </div>
   </div>
</form>	

<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="addJobApplication">Add Job Application</button>
</div>
</div>
   <p class="text-muted font-13 m-b-30"></p>
   
   <table id="" data-sort-name="Id" data-sort-order="desc" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
         <tr>
            <th  data-field="Id">Id
			<span><a href="<?php echo base_url(); ?>hrm/job_application?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/job_application?sort=desc" class="down"></a></span></th>
            <th>Name
			<span><a href="<?php echo base_url(); ?>hrm/job_application?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/job_application?sort=desc" class="down"></a></span></th>
            <th>Email
			<span><a href="<?php echo base_url(); ?>hrm/job_application?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/job_application?sort=desc" class="down"></a></span></th>
            <th>Phone_no</th>
            <th>Created Date</th>
            <th>Modified Date</th>
          
            <th style='width:30px;'>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($job_application as $job){ 
       #  pre($job);
         ?>
         <tr>
            <td><?php echo $job['id'];?></td>
            <td><?php echo $job['name'];?></td>
            <td><?php echo $job['email'];?></td>
            <td><?php echo $job['phone_no'];?></td>
            <td><?php  echo $job['created_date']; ?></td>
            <td><?php  echo $job['modified_date']; ?></td>
         
         
         
         
            <td class="action">
			   <i class='fa fa-cog'></i>
			     <div class='on-hover-action'>
               <button type="button" data-id="editJobApplication"  class="btn btn-edit btn-xs hrmTab" data-toggle="modal" id="<?php echo $job['id'];?>">Edit</button>
               <button type="button" data-id="viewJobApplication"  class="btn btn-view btn-xs hrmTab" data-toggle="modal" id="<?php echo $job['id'];?>">View</button>
                 <a href="<?php base_url();?>hrm/delete_job_application/<?php echo $job['id'];?>" class="btn btn-delete btn-xs">Delete</a>
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
               <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Job Application</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>