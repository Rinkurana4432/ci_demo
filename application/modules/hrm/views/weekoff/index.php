
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
   <form class="form-search" method="get" action="<?= base_url() ?>hrm/weekoff">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter Name" name="search" id="search" data-ctrl="hrm/weekoff" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
		 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?php echo site_url(); ?>hrm/weekoff'" value="Reset">
         </span>
      </div>
   </div>
</form>
</div>
</div>
   <p class="text-muted font-13 m-b-30"></p>
   <div class="col-md-12  export_div">
      <div class="col-md-4 col-sm-12 datePick-right"><?php if($can_add) {
         echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="weekoffAdd">Add Weekoff</button>';
         } ?></div>
   </div>
   <table id="" class="table table-striped table-bordered account_index" cellspacing="0" width="100%" style="margin-top:46px;">
      <thead>
         <tr>
            <th scope="col">ID
			<span><a href="<?php echo base_url(); ?>hrm/weekoff?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/weekoff?sort=desc" class="down"></a></span></th>
            <th scope="col">Name
			<span><a href="<?php echo base_url(); ?>hrm/weekoff?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/weekoff?sort=desc" class="down"></a></span></th>
            <th scope="col">Created Date </th>
            <th scope="col">Action</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($holidays as $value): ?>
         <tr>
            <td data-label="Id:"><?php echo $value->id ?></td>
            <td data-label="name:"><?php   if ($value->day=='1') {echo 'Monday';}elseif ($value->day=='2') {echo 'Tuesday';}elseif ($value->day=='3') {echo 'Wednesday';}elseif ($value->day=='4') {echo 'Thursday';}elseif ($value->day=='5') {echo 'Friday';}elseif ($value->day=='6') {echo 'Saturday';}elseif ($value->day=='7') {echo 'Sunday';}elseif ($value->day=='9') {echo 'Second Saturday / Fourth Saturday';}elseif ($value->day=='10') {echo 'Third Saturday / Fifth Saturday';} ?></td>
            <td data-label="Created Date :"><?php if(!empty($value->created_date)){ echo date('jS \of F Y',strtotime($value->created_date)); } ?></td>
            <td data-label="Action:" class="jsgrid-align-center hidde action"><i class='fa fa-cog'></i><div class='on-hover-action'>
               <?php echo  '<a href="javascript:void(0)" id="'. $value->id . '" data-id="weekoffAdd"  class="hrmTab btn btn-edit  btn-xs" id="' . $value->id . '">Edit</a>'; ?>
               <?php  echo '<a href="javascript:void(0)"  class="delete_listing
                  btn btn-delete btn-xs" data-href="'.base_url().'hrm/deleteweekoffHoliday/'.$value->id.'" >Delete</a>';?>
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
               <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Add Holiday</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>