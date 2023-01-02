
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
<div class="x_content">
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="get" action="<?= base_url() ?>hrm/leave_type">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter Type" name="search" id="search" data-ctrl="hrm/leave_type" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?= base_url() ?>hrm/leave_type'" value="Reset">
                  </span>
               </div>
            </div>
         </form>
      </div>
   </div>
   <p class="text-muted font-13 m-b-30"></p>
   <div class="col-md-12  export_div">
      <div class="col-md-4 col-sm-12 datePick-right"><?php if($can_add) {
         echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="leavetype">Add Leave Type</button>';
         } ?>
      </div>
   </div>
   <table id="" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" style="margin-top:46px;">
      <thead>
         <tr>
            <th scope="col">ID
               <span><a href="<?php echo base_url(); ?>hrm/leave_type?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>hrm/leave_type?sort=desc" class="down"></a></span>										
            </th>
            <th scope="col">Leave Type
               <span><a href="<?php echo base_url(); ?>hrm/leave_type?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>hrm/leave_type?sort=desc" class="down"></a></span>
            </th>
            <th scope="col">Number Of Days
               <span><a href="<?php echo base_url(); ?>hrm/leave_type?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>hrm/leave_type?sort=desc" class="down"></a></span>
            </th>
            <th scope="col">Leave Status
            </th>
            <th scope="col">Action</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($leavetypes as $value): ?>
         <tr>
            <td data-label="Id:"><?php echo $value['id']; ?></td>
            <td data-label="Leave Type:"><?php echo $value['name'] ?></td>
            <td data-label="Number Of Days:"><?php echo $value['leave_day'] ?></td>
            <td data-label="Leave Status:"><?php if($value['status'] == 1){echo "Active"; }else{echo "In Active";}?></td>
            <td data-label="Action:" class="jsgrid-align-center hidde action" style="width:30px;"><i class='fa fa-cog'></i><div class='on-hover-action'>
               <?php echo  '<a href="javascript:void(0)" id="'. $value['id'] . '" data-id="leavetype"  class="hrmTab btn btn-edit  btn-xs" id="' . $value['id'] . '">Edit</a>'; 
                  echo '<a href="javascript:void(0)" id="'.$value['id'].'" data-id="viewleavetype"  class="hrmTab btn btn-view  btn-xs">View</a>';?>
               <a href="<?php echo base_url();?>hrm/delete_leave_type/<?php echo $value['id'];?>" onclick="return confirm('Are you sure?')" class=" btn btn-delete btn-xs">Delete</a>
              </div>			   
            </td>
         </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
   <?php  echo $this->pagination->create_links(); ?>
   <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
      <?php echo $result_count; ?></span>
   </div>
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