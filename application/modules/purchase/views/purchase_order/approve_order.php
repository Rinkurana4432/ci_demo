<div class="row">
   <form method="post" class="form-horizontal" id="orderApproveByUser" action="<?php echo base_url(); ?>purchase/orderApproveByUser" enctype="multipart/form-data" novalidate="novalidate">
     <input type="hidden" name="id" value="<?= $order_id ?>">
      <input type="hidden" id="stepNo" name="stepNo" value="">
         <?php if( $selectApproveUsers ){ 
                  foreach ($selectApproveUsers as $key => $value) { ?>
                     <div class="col-md-12 col-sm-12 col-xs-12 vertical-border">
                        <div class="item form-group">
                           <label class="col-md-3 col-sm-12 col-xs-12" for="supplier_name">
                                 <?=  getSingleAndWhere('name','user_detail',['u_id' => $value??'' ]) ?> Approve Status
                                 <span class="required">*</span>
                           </label>
                           <div class="col-md-6 col-sm-12 col-xs-12">
                              <select class="commanSelect2 form-control checkStepUser" data-step="<?= $key ?>" name="approveStatus[]" 
                                       <?php 
                                          if( $_SESSION['loggedInUser']->u_id != $value ){
                                             echo 'disabled';
                                          }else{
                                             if( isset($poApprovedata['status'][$key][$value])  ){
                                                   if( $poApprovedata['status'][$key][$value] == 'approved'   ){
                                                       echo 'disabled';
                                                   }
                                             }
                                             
                                          }
                                       ?>
                                     >
                                 <option value="">Select Order Status</option>
                                 <option value="approved" 
                                 <?php 
                                    if( isset($poApprovedata['status'][$key][$value])  ){
                                          if( $poApprovedata['status'][$key][$value] == 'approved'   ){
                                             echo 'selected';
                                          }
                                    }

                                 ?>  >Approved</option>
                                 <option value="disapproved"
                                    <?php 
                                       if( isset($poApprovedata['status'][$key][$value]) ){
                                             if( $poApprovedata['status'][$key][$value] == 'disapproved'  ){
                                                echo 'selected';
                                             }
                                       }
                                    ?>
                                 >DisApproved</option>
                              </select>   
                           </div>
                        </div>
                     </div>              
         <?php   } 
              }?>
         <div class="col-md-12">
            <input type="submit" value="Save" class="btn btn-success orderApproveSubmition" 
            <?php 
               foreach ($selectApproveUsers as $key => $value) { 
                  if( isset($poApprovedata['status'][$key][$value])  ){
                     $arrayKey = array_keys($poApprovedata['status'][$key]);
                     if( $value == $arrayKey[0] ){
                         if( $poApprovedata['status'][$key][$value] == 'approved'   ){
                           echo 'disabled';
                        }   
                     }
                  }
               } 
            ?>
            >
         </div>
         
   </from>
</div>