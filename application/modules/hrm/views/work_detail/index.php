

<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-success col-md-6">                            
			<?php echo $this->session->flashdata('message');?>
		</div>                        
<?php }?>


<div class="x_content">
	<form class="form-search" method="get" action="<?= base_url() ?>hrm/work_detail">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter Job Name" name="search" id="search" data-ctrl="hrm/work_detail" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
		 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?= base_url() ?>hrm/work_detail'" value="Reset">
         </span>
      </div>
   </div>
</form>	
	<p class="text-muted font-13 m-b-30"></p>    
<button class="btn btn-primary hrmTab" data-toggle="modal" id="addwork" data-id="editworkdetails">Add</button>
<a href="<?php echo base_url();?>/hrm/task_list/"><button class="btn btn-primary" data-toggle="modal">Task List</button></a>
	<table id="" class="table table-striped table-bordered account_index" data-id="account">
		<thead>
			<tr>
				<th>Id
				<span><a href="<?php echo base_url(); ?>hrm/work_detail?sort=asc" class="up"></a>
				<a href="<?php echo base_url(); ?>hrm/work_detail?sort=desc" class="down"></a></span></th>
						<th>Job Name
			    <span><a href="<?php echo base_url(); ?>hrm/work_detail?sort=asc" class="up"></a>
				<a href="<?php echo base_url(); ?>hrm/work_detail?sort=desc" class="down"></a></span></th>
						<th>Description
			    <span><a href="<?php echo base_url(); ?>hrm/work_detail?sort=asc" class="up"></a>
				<a href="<?php echo base_url(); ?>hrm/work_detail?sort=desc" class="down"></a></span></th>
						<th>Due Date</th>
						<th>Action</th>
					</tr>
			</tr>
		</thead>
		<tbody>
		   <?php if(!empty($work_detail)){
						foreach($work_detail as $workdetail){		
								
					$action = '';
					
						$action = '<button type="button" data-process-id="'.$workdetail["id"].'" id="'.$workdetail["id"].'" data-id="editworkdetails" class="btn btn-primary hrmTab" data-toggle="modal">Edit</button>';
						
							$action = $action.'<a href="javascript:void(0)" class="delete_listing
							btn btn-danger" data-href="'.base_url().'hrm/deleteWorkdetail/'.$workdetail["id"].'" ><i class="fa fa-trash"></i></a>';
						
					echo "<tr>
						<td>".$workdetail['id']."</td>
						<td>".$workdetail['job_name']."</td>
						<td>".$workdetail['work_description']."</td>

						<td>".$workdetail['end_date_time']."</td>
						<td>".$action."</td>	
					</tr>";
				}
		   } ?>
		</tbody>                   
	</table>
 <?php  echo $this->pagination->create_links(); ?>
<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
</div>

   <!--<div class="modal fade editProcessType production_modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Add process Type</h4>
                        </div>
                        <div class="modal-body">
							<form method="post" class="form-horizontal" action="<?php ///echo base_url(); ?>production/saveProcessType" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
							<input type="hidden" id="id" name="id" value="">
							<div class="item form-group col-md-12 col-sm-12 col-xs-12">
								<label class="control-label col-md-2 col-sm-2 col-xs-4" for="process_type">Process Type : </label>
								<div class="col-md-10 col-sm-10 col-xs-8">
									<input type="text" id="process_type" name="process_type" class="form-control col-md-7 col-xs-12" value="">
								</div>
							</div>
						  
							<div class="item form-group col-md-12 col-sm-12 col-xs-12">
								<label class="control-label col-md-2 col-sm-2 col-xs-4" for="description">Description</label>
								<div class="col-md-10 col-sm-10 col-xs-8">
									<textarea type="text" id="description" name="description" class="form-control col-md-7 col-xs-12" value=""></textarea>
								</div>
							</div>
							
							<div class="modal-footer">
							  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							  
							  <input type="submit" class="btn btn-warning" value="Submit">
							</div>
							</form>
                        </div>
                       

                      </div>
                    </div>
                  </div>-->
<div id="hrm_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Work Details</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
