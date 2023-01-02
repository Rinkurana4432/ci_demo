
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
<div class="x_content">
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="get" action="<?= base_url() ?>hrm/holiday">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter Name" name="search" id="search" data-ctrl="hrm/holiday" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?= base_url() ?>hrm/holiday'" value="Reset">
                  </span>
               </div>
            </div>
         </form>
      </div>
   </div>
   <p class="text-muted font-13 m-b-30"></p>
   <div class="col-md-12  export_div">
      <div class="col-md-4 col-sm-12 datePick-right"><?php if($can_add) {
         echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="holidayAdd">Add Holiday</button>';
         } ?></div>
   </div>
   <table id="" class="table table-striped table-bordered account_index" cellspacing="0" width="100%" style="margin-top:46px;">
      <thead>
         <tr>
            <th scope="col">Name
               <span><a href="<?php echo base_url(); ?>hrm/holiday?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>hrm/holiday?sort=desc" class="down"></a></span>
			   <span class="resize-handle"></span>
            </th>
            <th scope="col">Start Date 
               <span><a href="<?php echo base_url(); ?>hrm/holiday?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>hrm/holiday?sort=desc" class="down"></a></span>
			   <span class="resize-handle"></span>
            </th>
            <th scope="col">End Date 
               <span><a href="<?php echo base_url(); ?>hrm/holiday?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>hrm/holiday?sort=desc" class="down"></a></span>
			   <span class="resize-handle"></span>
            </th>
            <th scope="col">Number of days
               <span><a href="<?php echo base_url(); ?>hrm/holiday?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>hrm/holiday?sort=desc" class="down"></a></span>
			   <span class="resize-handle"></span>
            </th>
            <th scope="col">Year
               <span><a href="<?php echo base_url(); ?>hrm/holiday?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>hrm/holiday?sort=desc" class="down"></a></span>
			   <span class="resize-handle"></span>
            </th>
            <th scope="col">Action
               <span><a href="<?php echo base_url(); ?>hrm/holiday?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>hrm/holiday?sort=desc" class="down"></a></span>
			   <span class="resize-handle"></span>
            </th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($holidays as $value): ?>
         <tr>
            <td data-label="name:"><?php echo $value->holiday_name ?></td>
            <td data-label="start date:"><?php echo date('jS \of F Y',strtotime($value->from_date)); ?></td>
            <td data-label="end date:"><?php if(!empty($value->to_date)){ echo date('jS \of F Y',strtotime($value->to_date)); } ?></td>
            <td data-label="Number of days:"><?php echo $value->number_of_days; ?></td>
            <td data-label="Year:"><?php echo $value->year; ?></td>
            <td data-label="Action:" class="hidde acc-btn action jsgrid-align-center "><i class="fa fa-cog" aria-hidden="true"></i><div class="on-hover-action">
               <?php echo  '<a href="javascript:void(0)" id="'. $value->id . '" data-id="holidayAdd" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs" id="' . $value->id . '">Edit</a>'; ?>
               <?php  echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
                  btn btn-delete btn-xs" data-href="'.base_url().'hrm/deleteHoliday/'.$value->id.'" >Delete</a>';?>
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
               <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Add Holiday</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>