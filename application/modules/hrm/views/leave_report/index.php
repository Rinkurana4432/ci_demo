
<?php if($this->session->flashdata('message') != ''){?>                        
        <div class="alert alert-success col-md-6">                            
            <?php echo $this->session->flashdata('message');?>
        </div>                        
<?php }?>

               
<div class="x_content">
    
    <p class="text-muted font-13 m-b-30"></p>    
  <h4>*TOTAL LEAVES : TL</h4>   
  <h4>*PENDING LEAVES : PL</h4>  <br><br> 
	 <?php foreach($earnleave as $val){ 
                            $emp_id[] = $val->emp_id;
                            $leave_id[] = $val->leave_id;
                            $opening_bal[] = $val->opening_bal;
                            $closing_bal[] = $val->closing_bal;
                }
                if(!empty($emp_id)){
                $emp_unique_id_arr =         array_unique($emp_id);
                
                foreach($emp_unique_id_arr as $jal){
                       $emp_id_keys[] = array_keys($emp_id,$jal) ;
                       $emp_keys_id[] = $jal ;
                } 
                
            #  pre($emp_id_keys);
               
                ?>
                            <table  class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                     <?php
                                        $loop_times= count($emp_keys_id);
                                        $t_head_loop_time = $loop_times-1;
                                        foreach($emp_keys_id as $key => $val_emp_id){ 
                                        if($key == $t_head_loop_time){
                                     ?>
                                    <tr>
                                        <th>Name </th>
                                        <th>Emp Code </th>
                                        
                                          <?php for($i = 0;  $i < count($emp_id_keys[$key]) ; $i++){  ?>  
                                           <?php     $leave_name = getNameById('leave_types',$leave_id[$emp_id_keys[$key][$i]],'id');    ?>
                                            <th><?php  @ print_r($leave_name->name);  ?></th>
                                        <?php } ?>    
                                       
                                    </tr>
                                     <?php }   } ?>    
                                </thead>
                                <tbody>
                                    
                                    
                                    <?php foreach($emp_keys_id as $key => $val_emp_id){  ?>
                                    
                                <tr>       
                                        <?php  $emp_name = getNameById('user_detail',$val_emp_id,'u_id');
                                        if(!empty($emp_name)){
                                        ?>
                                        
                                        <td><?php @ print_r($emp_name->name); ?></td>
                                        <td><?php echo $val_emp_id; ?></td>
                                    <?php for($i = 0;  $i < count($emp_id_keys[$key]) ; $i++){  ?>  
                                            <td><?php   echo "TL   : ".$opening_bal[$emp_id_keys[$key][$i]]."<br><br>"."PL: ".$closing_bal[$emp_id_keys[$key][$i]]; ?></td>
                                    <?php } ?>   
    <td><?php echo '<a href="javascript:void(0)" id="'. $val_emp_id . '" data-id="leave_allotment" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs"  ><i class="fa fa-pencil"></i></a>' ?></td>
                                      <?php }  ?>

                                </tr>
                                       
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php }else{  echo "<div> No Data Found </div> ";   } ?>
                         </div>
                            <div id="printThis">
<div id="hrm_modal" class="modal fade in btnPrint"  role="dialog">
    <div class="modal-dialog modal-lg modal-large">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Leave Type</h4>
            </div>
            <div class="modal-body-content"></div>
        </div>
    </div>
</div>
</div>         