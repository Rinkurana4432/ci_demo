<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/purchase_report/save_report" enctype="multipart/form-data" id="purchaseIndentForm" novalidate="novalidate">
   <input type="hidden" name="updateSubmit" value="<?= $Existreport['updateSubmit']??'2' ?>">
   <input type="hidden" name="id" value="<?= $Existreport['id']??'' ?>">
   <div class="row">
      <div class="col-md-12 item form-group"> 
            <label>Report Name <span class="required">*</span></label>   
            <input type="text" name="report_name" value="<?= $Existreport['report_name']; ?>" class="form-control" required>   
      </div>
      <div class="col-md-12 item form-group">
            <label>Parent <span class="required">*</span></label>   
            <select class="form-control commanSelect2" name="parent">
               <option>Select</option>
               <?php 
                  if( $purchaseReport ){
                     foreach ($purchaseReport as $key => $value) { ?>
                           <option value="<?= $value['id'] ?>"
                                 <?php 
                                    if( isset($Existreport['parent']) ){
                                       if( $Existreport['parent'] == $value['id'] ){
                                          echo 'selected';
                                       }
                                    }

                                 ?>
                              ><?= ucfirst($value['report_name']) ?></option>
                  <?php }
                  }

               ?>
            </select>   
      </div>
      <div class="col-md-12 item form-group">
            <label>Url <span class="required">*</span></label>   
            <input type="text" name="url" class="form-control" value="<?= $Existreport['url']??'' ?>" <?php echo isset($Existreport['url'])?'readonly':''; ?> >
      </div>
      <div class="col-md-12 item form-group">
            <label>Description <span class="required">*</span></label>   
            <textarea class="form-control" name="description"><?= $Existreport['description']??'' ?></textarea>
      </div>
      <div class="col-md-12 item form-group">
            <label>Status <span class="required">*</span></label>   
            <select class="form-control" name="status" >
               <option>Select Status</option>
               <option value="1"
                  <?php 
                     if( isset($Existreport['status']) ){
                        if( $Existreport['status'] == 1 ){
                           echo 'selected';
                        }   
                     }
                  ?>
               >Active</option>
               <option value="2"
                     <?php 
                     if( isset($Existreport['status']) ){
                        if( $Existreport['status'] == 2 ){
                           echo 'selected';
                        }   
                     }
                  ?>
               >Unactive</option>
            </select>
      </div>
      <div class="col-md-12">
         <div class="form-group">
            <center>
               <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
               <input type="submit" value="submit" class="btn edit-end-btn">
            </center>
         </div>
      </div>
   </div>
</form>