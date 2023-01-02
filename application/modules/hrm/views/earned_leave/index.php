
<?php if($this->session->flashdata('message') != ''){?>                        
        <div class="alert alert-success col-md-6">                            
            <?php echo $this->session->flashdata('message');?>
        </div>                        
<?php }?>


<div class="x_content">
    
    <p class="text-muted font-13 m-b-30"></p>    
  <div class="col-md-12  export_div"> <div class="col-md-4 col-sm-12 datePick-right"> <?php if($can_add) {
     echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="addEarnedLeave">Add Earned Leave</button>';
    } ?></div></div>
<table id="" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Employee PIN</th>
                                                <th>Employee Name </th>
                                                <th>Total Day </th>
                                                <!--<th>Total Hour </th>-->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($earnleave as $value): ?>
                                            <tr>
                                                <td><?php echo $value->id ?></td>
                                                <td><?php echo $value->name; ?></td>
                                             <td><?php echo $value->present_date; ?></td>
                                                   <!--<td><?php echo $value->hour .' Hours' ?></td>-->
                                                <?php #if($value->present_date > 0){ ?>
                                               <td class="jsgrid-align-center">
                                                  <?php  echo '<a href="javascript:void(0)" id="'.$value->em_id.'" data-id="addEarnedLeave" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs"><i class="fa fa-pencil"></i>  </a>';
												  echo '<a href="javascript:void(0)" id="'.$value->em_id.'" data-id="viewEarnedLeave" data-tooltip="Edit" class="hrmTab btn btn-view  btn-xs"><i class="fa fa-eye"></i>  </a>';?>
								<a href="<?php echo base_url();?>hrm/delete_earned_leave/<?php echo $value->id;?>" onclick="return confirm('Are you sure?')" class=" btn btn-delete btn-xs"><i class="fa fa-trash"></i> </a>					  
                                                </td>
                                                <?php #} ?>
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
                <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Earned Leave</h4>
            </div>
            <div class="modal-body-content"></div>
        </div>
    </div>
</div>
</div>         