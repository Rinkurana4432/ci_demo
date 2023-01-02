
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
   <form class="form-search" method="get" action="<?= base_url() ?>hrm/Attendance">
      <div class="col-md-6">
         <div class="input-group">        
		 <span class="input-group-addon">        
		 <i class="ace-icon fa fa-check"></i>        
		 </span>         
		 <input type="text" class="form-control search-query" placeholder="Enter Emp_code,Name" name="search" id="search" data-ctrl="hrm/Attendance" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">        
		 <span class="input-group-btn">        
		 <button type="submit" class="btn btn-purple btn-sm">         
		 <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>      
		 <a href="<?php echo base_url(); ?>hrm/Attendance">
		 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>        
		 </span>     
		 </div>
      </div>
   </form>
</div>
</div>
   <p class="text-muted font-13 m-b-30"></p>
   <div class="col-md-12  export_div">
      <div class="col-md-12 col-sm-12 datePick-right"><?php if($can_add) {
         echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="attendanceAdd">Add Attendance</button>';
         } ?>
           <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                <!--   <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li> -->
              <li><a href="<?php echo base_url()?>assets/modules/hrm/download/attendance.xlsx" title="Please check your open office Setting">Export to Blank Excel</a></li>
               </ul>
            </div>
         <a href="#" class="btn btn-primary addBtn" data-toggle="modal" data-target="#Bulkmodal"><i class="" aria-hidden="true"></i>  Add Bulk Attendance<span class="resize-handle"></span></a>
      </div>
   </div>
   <table id="" class="table table-striped table-bordered account_index" cellspacing="0" width="100%" style="margin-top:46px;">
      <thead>
         <tr>
            <th scope="col">Emp Code
			<span><a href="<?php echo base_url(); ?>hrm/Attendance?sort=asc" class="up"></a>
			<a href="<?php echo base_url(); ?>hrm/Attendance?sort=desc" class="down"></a></span><span class="resize-handle"></span></th>
            <th scope="col">Employee Name
			<span><a href="<?php echo base_url(); ?>hrm/Attendance?sort=asc" class="up"></a>
			<a href="<?php echo base_url(); ?>hrm/Attendance?sort=desc" class="down"></a></span><span class="resize-handle"></span></th>
            <th scope="col">Atten Date 	
			<span><a href="<?php echo base_url(); ?>hrm/Attendance?sort=asc" class="up"></a>
			<a href="<?php echo base_url(); ?>hrm/Attendance?sort=desc" class="down"></a></span><span class="resize-handle"></span></th>
            <th scope="col">Sign In <span class="resize-handle"></span></th>
            <th scope="col">Sign Out<span class="resize-handle"></span></th>
            <th scope="col">Working Hour<span class="resize-handle"></span></th>
            <th scope="col">Action<span class="resize-handle"></span></th>
         </tr>
      </thead>
      <tbody>
         <?php   // pre($attendancelist); ?>
         <?php foreach($attendancelist as $value):
            $emp_name = getNameById('user_detail',$value->emp_id,'u_id')
            
            ?>
         <tr>
            <td data-label="Emp Code:"> <?php echo $value->emp_id; ?> </td>
            <td data-label="Employee Name:"> <?php echo $emp_name->name; ?> </td>
            <!-- <td></?php echo $value->emp_id; ?></td> --> 
            <td data-label="Atten Date:"><?php echo date("d-m-Y",strtotime($value->atten_date)); ?></td>
            <td data-label="Sign In:"><?php echo $sign_in =  $value->signin_time; ?></td>
            <td data-label="Sign Out:"><?php echo $sign_out =  $value->signout_time; ?></td>
            <td data-label="Working Hour:">
               <?php 
                  /*  $combinedDT_signin = date('Y-m-d H:i:s', strtotime("$date $time"));*/
                                                                       $date1 = new DateTime($sign_in);
                                                                       $date2 = new DateTime($sign_out);
                                                                       if($date1 =='00:00:00'){$date1 = '00:01:00'; }
                                                                       if($date2 =='00:00:00'){$date2 = '00:01:00'; }
                                                                       $interval = $date1->diff($date2);
                                                                       echo  $interval->h . "." . $interval->i; 
                                                               ?>
               <!-- <?php echo $value->Hours; ?>-->
            </td>
            <td data-label="Action:" class="hidde acc-btn action jsgrid-align-center "><i class="fa fa-cog" aria-hidden="true"></i><div class="on-hover-action">
               <?php
                  echo '<a href="javascript:void(0)" id="'. $value->id . '"  data-id="attendanceAdd"  class="hrmTab btn btn-edit  btn-xs"  id="'. $value->id . '" >Edit</a>' ?>
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
               <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Add Attendance</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>
<div id="Bulkmodal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- <form method="post" action="import" enctype="multipart/form-data"> -->
         <form method="post" action="<?=base_url();?>hrm/importAttendanceEmployee" enctype="multipart/form-data">
            <div class="modal-header">
               <div style="display:none" id="show_msg_bulk" class="alert alert-warning " >
                  <span id="show_atten_bulk_msg">  </span>
               </div>
               <h4 class="modal-title" id="myModalLabel">Upload Attendance</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <h4>Upload only Excel file(* Time in 24 Hrs Format only)</h4>
               <input type="date" name="attenDateStart"  required><br>
               <input type="date" name="attenDateEnd"  required> <br><br>
               <input type="file" name="uploadFile" value="" required />
               <br><br>
            </div>
            <div class="modal-footer">
               <input type="submit" id="attendance_bulk_Update" class="btn btn-primary" value="Upload" />
               <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
            </div>
         </form>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<?php #$this->load->view('backend/footer'); ?>