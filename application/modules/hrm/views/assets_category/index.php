
<?php if($this->session->flashdata('message') != ''){?>                        
    <div class="alert alert-success col-md-6">                            
        <?php echo $this->session->flashdata('message');?>
    </div>                        
<?php }?>


<div class="x_content">

<div class="col-md-12 col-sm-12 for-mobile">
         <div class="Filter Filter-btn2">
   <form class="form-search" method="get" action="<?= base_url() ?>hrm/assets_category">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter Type,Name" name="search" id="search" data-ctrl="hrm/assets_category" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
		 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?php echo site_url(); ?>hrm/assets_category'" value="Reset">
         </span>
      </div>
   </div>
</form>
</div>
</div>
    <p class="text-muted font-13 m-b-30"></p>    
    <div class="col-md-12  export_div"> <div class="col-md-4 col-sm-12 datePick-right"><?php if($can_add) {
       echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="addAssets">Add Assets</button>';
   } ?></div>
  </div>
   <table id="" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID 
			<span><a href="<?php echo base_url(); ?>hrm/assets_category?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/assets_category?sort=desc" class="down"></a></span>
			</th>
            <th>Type
			<span><a href="<?php echo base_url(); ?>hrm/assets_category?sort=asc" class="up"></a>
			<a href="<?php echo base_url(); ?>hrm/assets_category?sort=desc" class="down"></a></span>
			</th>
            <th>Name 
			<span><a href="<?php echo base_url(); ?>hrm/assets_category?sort=asc" class="up"></a>
			<a href="<?php echo base_url(); ?>hrm/assets_category?sort=desc" class="down"></a></span>
			</th>
            <th>Created Date
			</th>
            <th>Action
			</th>
        </tr>
    </thead>
    <tbody>
     <?php foreach($catvalue as $value): ?>
        <tr>
            <td><?php echo $value['id']; ?></td>
            <td><?php echo $value['cat_status']; ?></td>
            <td><?php echo $value['cat_name']; ?></td>
            <td><?php echo $value['created_date'];?></td>
            <td class="jsgrid-align-center action">
			      <i class='fa fa-cog'></i>
							<div class='on-hover-action'>
                <a href="javascript:void(0);" title="Edit" class="hrmTab btn btn-edit  btn-xs" id="<?php echo $value['id']; ?>" data-id="addAssets">Edit</a>
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
                    <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Assets Category</h4>
                </div>
                <div class="modal-body-content"></div>
            </div>
        </div>
    </div>
</div>                         
<?php #$this->load->view('backend/footer'); ?>