

<?php if($this->session->flashdata('message') != ''){?>                        
        <div class="alert alert-success col-md-6">                            
            <?php echo $this->session->flashdata('message');?>
        </div>                        
<?php }?>


<div class="x_content">
<div class="col-md-12 col-sm-12 for-mobile">
         <div class="Filter Filter-btn2">
       <form class="form-search" method="get" action="<?= base_url() ?>hrm/worker_Attendance">
      <div class="col-md-6">
         <div class="input-group">        
		 <span class="input-group-addon">        
		 <i class="ace-icon fa fa-check"></i>        
		 </span>         
		 <input type="text" class="form-control search-query" placeholder="Enter Workers Name" name="search" id="search" data-ctrl="hrm/worker_Attendance" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">        
		 <span class="input-group-btn">        
		 <button type="submit" class="btn btn-purple btn-sm">         
		 <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>      
		 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?php echo base_url(); ?>hrm/worker_Attendance'" value="Reset">      
		 </span>     
		 </div>
      </div>
   </form>
   </div>
   </div>
     
 <div class="col-md-12  export_div"> <div class="col-md-4 col-sm-12 datePick-right" style="padding: 0px;"> <?php if($can_add) {
     echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="attendanceAddWorkers">Add Workers Attendance</button>';
    } ?>
	</div>
	</div>
	  <p class="text-muted font-13 m-b-30"></p> 
<!--<a href="#" class="btn btn-primary hrmTab" data-toggle="modal" data-target="#Bulkmodal"><i class="" aria-hidden="true"></i>  Add Bulk WorkersAttendance</a>-->
                                    <table id="" class="table table-striped table-bordered account_index" cellspacing="0" width="100%" style="margin-top:45px;">
                                        <thead>
                                            <tr>
                                                <th>Id
			<span><a href="<?php echo base_url(); ?>hrm/worker_Attendance?sort=asc" class="up"></a>
			<a href="<?php echo base_url(); ?>hrm/worker_Attendance?sort=desc" class="down"></a></span></th>
                                                <th>Workers Name
		  	<span><a href="<?php echo base_url(); ?>hrm/worker_Attendance?sort=asc" class="up"></a>
			<a href="<?php echo base_url(); ?>hrm/worker_Attendance?sort=desc" class="down"></a></span><span class="resize-handle"></span></th>
                                                <th>Emp Id
			<span><a href="<?php echo base_url(); ?>hrm/worker_Attendance?sort=asc" class="up"></a>
			<a href="<?php echo base_url(); ?>hrm/worker_Attendance?sort=desc" class="down"></a></span><span class="resize-handle"></span></th>
                                                <th>Date<span class="resize-handle"></span></th>
                                                <th>Sign In<span class="resize-handle"></span></th>
                                                <th>Sign Out<span class="resize-handle"></span></th>
                                                <th>Working Hour<span class="resize-handle"></span></th>
                                                <th>OT Working Hour<span class="resize-handle"></span></th>
                                                <th>Total Working Hour<span class="resize-handle"></span></th>
                                                <th>Action<span class="resize-handle"></span> </th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>

                                            <?php  #pre($attendancelist); ?>
                                           <?php foreach($attendancelist as $value): 
                                             
                                                $empDatales = getNameById('worker',$value->emp_id,'id'); 
                                                $Empkey=$value->emp_id;
                                                $startdate=$value->atten_date;
                                                $where= "('{$startdate}' between shiftChangeStartDate AND employeeShiftEndDate) AND employeeId = {$Empkey}";  $employeeData  = $this->hrm_model->get_worker_data('workershiftChange',$where);
                                                foreach ($employeeData as $employeeshift) { 
                                                $shiftNameTime = getNameById('production_setting',$employeeshift['shift_id'],'id'); 
                                                $overTime=(float)$value->Hours-(float)$shiftNameTime->working_hrs;
                                                    }?>
                                            <tr>
                                                <td><?php echo $value->id; ?></td>
                                                <td><?php echo $value->name; ?></td>
                                                <td><?php echo $value->emp_id; ?></td>
                                                <td><?php echo $value->atten_date; ?></td>
                                                <td><?php echo $value->signin_time; ?></td>
                                                <td><?php echo $value->signout_time; ?></td>
                                                <td><?php echo $shiftNameTime->working_hrs .' '.'Hrs';?></td>
                                                <td><?php if($value->Hours > $shiftNameTime->working_hrs){ echo $overTime.' '.'Hrs';}else{echo'0.00 Hrs';} ?></td>
                                                <td><?php echo $value->Hours.' '.'Hrs'; ?></td>
                                               <td data-label="Action:" class="hidde acc-btn action jsgrid-align-center "><i class="fa fa-cog" aria-hidden="true"></i><div class="on-hover-action">
                                              <!--   <?php if($value->signout_time == '00:00:00') { ?>
                                                 <?php //echo '<a href="javascript:void(0)" id="'. $value->id . '" data-id="attendanceAdd"  class="hrmTab btn btn-edit  btn-xs" id="' . $value->id . '">Edit</a>'?> <br>                           
                                                <?php } ?> -->
                                                <?php
                                                  echo '<a href="javascript:void(0)" id="'. $value->id . '" data-id="attendanceAddWorkers"   class="hrmTab btn btn-edit  btn-xs" id="' . $value->id . '">Edit</a>' ?>
												  </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
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
                <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Add Workers Attendance</h4>
            </div>
            <div class="modal-body-content"></div>
        </div>
    </div>
</div>
</div>                         
<?php #$this->load->view('backend/footer'); ?>
