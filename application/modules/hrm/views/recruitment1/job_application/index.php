
<?php if($this->session->flashdata('message') != ''){?>                        
        <div class="alert alert-success col-md-6">                            
            <?php echo $this->session->flashdata('message');?>
        </div>                        
<?php }?>
<div class="x_content">
    <p class="text-muted font-13 m-b-30"></p>    
 <button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="addJobApplication">Add Job Application</button>

                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone_no</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php foreach($job_application as $job){ ?>
                                    <tr >
                                        <td><?php echo $job['id'];?></td>
                                        <td><?php echo $job['name'];?></td>
                                        <td><?php echo $job['email'];?></td>
                                        <td><?php echo $job['phone_no'];?></td>
                                        <td>
    <button type="button" data-id="editJobApplication" data-tooltip="Edit" class="btn btn-edit btn-xs hrmTab" data-toggle="modal" id="<?php echo $job['id'];?>">Edit</button>
	<button type="button" data-id="viewJobApplication" data-tooltip="View" class="btn btn-edit btn-xs hrmTab" data-toggle="modal" id="<?php echo $job['id'];?>">View</button>
	</td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
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