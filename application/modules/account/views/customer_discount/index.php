<div class="x_content">
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="post" action="<?= base_url() ?>account/account_groups">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter id,Group Name" name="search" id="search" value="<?php if(!empty($_GET['search'])) echo $_GET['search'];?>" data-ctrl="account/customer_discount">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <a href="<?php echo base_url(); ?>account/customer_discount">
                  <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                  </span>
               </div>
            </div>
         </form>
         <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>account/customer_discount">
            <input type="hidden" name="order" id="order" value="<?php if($_POST['order']==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
         </form>
      </div>
   </div>
   <?php if($this->session->flashdata('message') != ''){
      echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
      }?>
   <div class="col-md-12 export_div">
      <div class="btn-group"  role="group" aria-label="Basic example">
         <?php if($can_add) {
            echo '<button type="button" class="btn btn-success addBtn add_account_tabs" data-toggle="modal" id="" data-id="customer_discount_add"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
            } ?>
      </div>
   </div>
   <p class="text-muted font-13 m-b-30"></p>
   <!---datatable-buttons--->
   <table id="" class="table  table-striped table-bordered account_group_index" data-id="account" style="margin-top:40px;">
      <thead>
         <tr>
            <th scope="col">Id
               <span><a href="<?php echo base_url(); ?>account/customer_discount?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>account/customer_discount?sort=desc" class="down"></a></span>
            </th>
            <th scope="col">Discount Name

            </th>
            <th scope="col">Customer
               <span>
                  <a href="<?php echo base_url(); ?>account/customer_discount?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>account/customer_discount?sort=desc" class="down"></a>
               </span>
            </th>
            <th scope="col">Payment Terms</th>
            <th scope="col">Created By</th>
            <th scope="col">Created date</th>
            <th scope="col">Action</th>
         </tr>
      </thead>
      <tbody>
         <?php
            if(!empty($discount)){
               foreach ($discount as $key => $value) { ?>
                  <tr>
                     <td><?= $value['id'] ?></td>
                     <td><?= $value['discount_name'] ?></td>
                     <td>
                        <?php
                           if( !empty($value['party_name']) ){
                              $name = json_decode($value['party_name']);
                              $i = 0;
                              foreach ($name as $Namekey => $Namevalue) {
                                 if( $i < 3 ){
                                   $getName = getSingleAndWhere('name','ledger',['id' => $Namevalue]);
                                   echo $getName;
                                   echo " | ";
                                   if( $i == 2 ){
                                     echo "<a href='javascript:void(0)' id='{$value['id']}' data-id='customer_discount_view'
                                            class='add_account_tabs' data-tooltip='View'> View More</a>";
                                   }
                                 }
                                 $i++;
                              }
                           }

                        ?>
                     </td>
                     <td>
                        <?php
                           $paymentTerm = json_decode($value['day_discount'],true);
                           if( !empty($paymentTerm) ){
                              foreach ($paymentTerm as $termKey => $termValue) {
                                 echo $termValue['percentage'].'% For '.$termValue['days'].' Day';
                                 echo '<br>';
                              }
                           }

                        ?>

                     </td>
                     <td><?= getSingleAndWhere('name','user_detail',['u_id' => $value['created_by'] ]); ?></td>
                     <td><?= $value['created_date'] ?></td>
                     <td>
                        <a href="javascript:void(0)" id="<?= $value['id'] ?>" data-id="customer_discount_add" class="add_account_tabs btn btn-info btn-xs" data-tooltip="Edit"><i class="fa fa-pencil"></i></a>
                        <a href="javascript:void(0)" id="<?= $value['id'] ?>" data-id="customer_discount_view" class="add_account_tabs btn btn-warning btn-xs" data-tooltip="View"><i class="fa fa-eye"></i></a>
                        <a href="javascript:void(0)" class="delete_listing btn btn-danger  btn btn-info btn-xs" data-href='<?= base_url("account/deleteCustDis/{$value['id']}") ?>'data-tooltip="Delete"><i class="fa fa-trash"></i></a>
                     </td>
                  </tr>
         <?php }
            }

         ?>
      </tbody>
   </table>
   <?php echo $this->pagination->create_links(); ?>
</div>
<div id="account_add_modal" class="modal fade in"  role="dialog">
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add Ledger</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
