
<?php if($this->session->flashdata('message') != ''){?>                        
        <div class="alert alert-success col-md-6">                            
            <?php echo $this->session->flashdata('message');?>
        </div>                        
<?php }?>


<div class="x_content">
    
    <p class="text-muted font-13 m-b-30"></p>    
  
                                    <table id="example235" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="hide">SL </th>
                                                <th>PIN </th>
                                                <th>Employee </th>
                                                <th>Month </th>
                                                <th>Salary </th>
                                                <th>Total hours </th>
                                                <th>Deduction</th>
                                                <th>Total Paid</th>
                                                <th>Pay Date</th>
                                                <th>Status</th>
                                                <th class="jsgrid-align-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                           <?php $i =0; foreach($salary_info as $individual_info): ?>
                                            <tr>
                                                <td class="hide"><?php $i++; echo $i;?></td>
                                                <td><?php echo $individual_info->id; ?></td>
                                                <td><?php echo $individual_info->name ?></td>
                                                <td><?php echo $individual_info->month.' '.$individual_info->year; ?></td>
                                                <td><?php echo $individual_info->basic; ?></td>
                                                <td><?php echo $individual_info->total_days; ?></td>
                                                <!--<td><?php echo $individual_info->addition; ?></td>-->
                                                <td><?php echo $individual_info->diduction; ?></td>
                                                <td><?php echo $individual_info->total_pay; ?></td>
                                                <td><?php echo $individual_info->paid_date; ?></td>
                                                <td><?php echo $individual_info->status; ?></td>
                                                <td class="jsgrid-align-center ">

                                                    <button data-tooltip="View Report" class="btn btn-sm btn-info waves-effect waves-light PayslipGenerate" data-employeeId="<?php echo $individual_info->emp_id; ?>"  data-id="<?php echo $individual_info->pay_id; ?>">View Report</button>

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
                <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Pay Slip Report</h4>
            </div>
            <div class="modal-body-content"></div>
        </div>
    </div>
</div>
</div>         
                        
                                                        
