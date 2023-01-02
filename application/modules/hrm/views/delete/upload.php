
<?php if($this->session->flashdata('message') != ''){?>                        
        <div class="alert alert-success col-md-6">                            
            <?php echo $this->session->flashdata('message');?>
        </div>                        
<?php }?>


<div class="x_content">
    
    <p class="text-muted font-13 m-b-30"></p>    
  <div class="col-md-12  export_div"> <div class="col-md-4 col-sm-12 datePick-right"><?php if($can_add) {
     echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="attendanceAdd">Add Attendance</button>';
    } ?>
    <a href="#" class="btn btn-primary addBtn" data-toggle="modal" data-target="#Bulkmodal"><i class="" aria-hidden="true"></i>  Add Bulk Attendance</a>
	</div>
	</div>

                                    <table id="attendance123" class="table table-striped table-bordered account_index" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                
                                                <th>Emp Code</th>
                                                <th>Employee Name</th>
                                              
                                               <th>Atten Date </th> 
                                                <th>Sign In</th>
                                                <th>Sign Out</th>
                                                <th>Working Hour</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>

                                            <?php  # pre($attendancelist); ?>
                                           <?php foreach($attendancelist as $value):
                                                    $emp_name = getNameById('user_detail',$value->emp_id,'u_id')
                                           
                                           ?>
                                            <tr>
                                                
                                                <td><mark><?php echo $value->emp_id; ?></mark></td>
                                                <td><mark><?php echo $emp_name->name; ?></mark></td>
                                                <!-- <td></?php echo $value->emp_id; ?></td> -->
                                                <td><?php echo $value->atten_date; ?></td>
                                                <td><?php echo $sign_in =  $value->signin_time; ?></td>
                                                <td><?php echo $sign_out =  $value->signout_time; ?></td>
                                                <td>
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
                                                <td class="jsgrid-align-center ">
                                                <?php if($value->signout_time == '00:00:00') { ?>
                                                 <?php echo '<a href="javascript:void(0)" id="'. $value->id . '"  data-id="attendanceAdd" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs"  id="'. $value->id . '" ><i class="fa fa-pencil"></i>  </a>'?> <br>                           
                                                <?php } ?>
                                                <?php
                                                  echo '<a href="javascript:void(0)" id="'. $value->id . '"  data-id="attendanceAdd" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs"  id="'. $value->id . '" ><i class="fa fa-pencil"></i>  </a>' ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
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
                <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Add Attendance</h4>
            </div>
            <div class="modal-body-content"></div>
        </div>
    </div>
</div>
</div>

<!--DLETE-->


<div id="Bulkmodal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                           <!-- <form method="post" action="import" enctype="multipart/form-data"> -->
                                            <form method="post" action="uploadDatadelete" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Upload Dummy</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Upload only Excel file(* Time in 24 Hrs Format only)</h4>
                                             
                                              <input type="date" name="atten_date" required> <br><br>
                                              <input type="file" name="uploadFile" value="" required />
                                            <br><br>
                                                                                        
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit"  value="Upload" />
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>                               
<?php #$this->load->view('backend/footer'); ?>
 