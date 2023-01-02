<div class="row">
   <form method="post" class="form-horizontal" id="orderApproveByUser" action="<?php echo base_url(); ?>purchase/orderApproveByUser" enctype="multipart/form-data" novalidate="novalidate">
     <input type="hidden" name="id" value="<?= $order_id ?>">
         <?php if( $companyPoApproveUser ){ 
                  //pre($_SESSION);
                  foreach ($companyPoApproveUser as $key => $value) { ?>
                     <div class="col-md-12 col-sm-12 col-xs-12 vertical-border">
                        <div class="item form-group">
                           <label class="col-md-3 col-sm-12 col-xs-12" for="supplier_name">
                                 <?=  getSingleAndWhere('name','user_detail',['u_id' => $value ]) ?> Approve Status
                                 <span class="required">*</span>
                           </label>
                           <div class="col-md-6 col-sm-12 col-xs-12">
                              <select class="commanSelect2 form-control" name="approveStatus" 
                                    <?= ( ( $value != $_SESSION['loggedInUser']->u_id) || 
                                          ( $poApprovedata['status'][$value] == 'approved' || 
                                            in_array('disapproved',$poApprovedata['status']) ) )?'disabled':'id="userApproveOption"'; ?> >
                                 <option value="">Select Order Status</option>
                                 <option value="approved" 
                                 <?php 
                                    if( isset($poApprovedata['status'][$value])  ){
                                          if( $poApprovedata['status'][$value] == 'approved'   ){
                                             echo 'selected';
                                          }
                                    }

                                 ?>  >Approved</option>
                                 <option value="disapproved"
                                    <?php 
                                       if( isset($poApprovedata['status'][$value]) ){
                                             if( $poApprovedata['status'][$value] == 'disapproved'  ){
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
            <?= (!in_array($_SESSION['loggedInUser']->u_id,$companyPoApproveUser) || 
                  in_array('disapproved',$poApprovedata['status']) )?'disabled':''; ?>>
         </div>
         
   </from>
</div>