
<?php if($this->session->flashdata('message') != ''){?>                        
    <div class="alert alert-success col-md-6">                            
        <?php echo $this->session->flashdata('message');?>
    </div>                        
<?php }?>


<div class="x_content">
<div class="col-md-12 col-sm-12 for-mobile">
         <div class="Filter Filter-btn2">
   <form class="form-search" method="get" action="<?= base_url() ?>hrm/salary_slab">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter Salary From,Salary To" name="search" id="search" data-ctrl="hrm/salary_slab" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
		 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?= base_url() ?>hrm/salary_slab'" value="Reset">
         </span>
      </div>
   </div>
</form>	
</div>
</div>
    <p class="text-muted font-13 m-b-30"></p>  
<div class="row hidde_cls stik">
            <div class="col-md-12 col-xs-12">
               <div class="export_div">
                  
                  <div class="btn-group" role="group" aria-label="Basic example">	
    <?php if($can_add) {
       echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="salarySlab">Add Salary Slab</button>';
   } ?>
 </div>
 </div>
 </div>
 </div>
   <table id="" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID
			<span><a href="<?php echo base_url(); ?>hrm/salary_slab?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/salary_slab?sort=desc" class="down"></a></span></th>
		   <th>Name</th>
            <th>Slab Start Date
			<span><a href="<?php echo base_url(); ?>hrm/salary_slab?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/salary_slab?sort=desc" class="down"></a></span></th>
            <th>Slab End Date
			<span><a href="<?php echo base_url(); ?>hrm/salary_slab?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/salary_slab?sort=desc" class="down"></a></span></th>
           <th>Salary From
		   <span><a href="<?php echo base_url(); ?>hrm/salary_slab?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/salary_slab?sort=desc" class="down"></a></span></th>
            <th>Salary To
			<span><a href="<?php echo base_url(); ?>hrm/salary_slab?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/salary_slab?sort=desc" class="down"></a></span></th>
            <th>Created/Updated Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
     <?php   /* pre($catvalue);die;*/ $sNo=1;   foreach($catvalue as $value): 

       

        ?>
        <tr>

           
            <td><?php echo $value['id']; ?></td>
            <td><?php echo $value['slabname']; ?></td>
           <td><?php echo date('d-m-y',strtotime($value['slab_start_date'])); ?></td>
           <td><?php echo date('d-m-y',strtotime($value['slab_end_date']));?></td>
           <td><?php echo $value['salary_from']; ?></td>
           <td><?php echo $value['salary_to']; ?></td>
          <td><?php echo date('d-m-y',strtotime($value['created_date'])); ?></td>
           
            
            <td class="jsgrid-align-center hidde action"><i class='fa fa-cog'></i><div class='on-hover-action'>
                <a href="javascript:void(0);" title="Edit" class="hrmTab btn btn-edit  btn-xs" id="<?php echo $value['id']; ?>" data-id="salarySlab">Edit</a>
                <a href="javascript:void(0);" title="View" class="hrmTab btn btn-view  btn-xs" id="<?php echo $value['id']; ?>" data-id="viewsalarySlab">View</a>
                <a href="<?php echo base_url();?>hrm/delete_salary_slab/<?php echo $value['id']; ?>" class="btn btn-delete  btn-xs" onclick="confirm('Are you sure?');">Delete</a>
				</div>
           </td>
        </tr>
    <?php $sNo++;  endforeach; ?>
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
                    <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Salary Slab</h4>
                </div>
                <div class="modal-body-content"></div>
            </div>
        </div>
    </div>
</div>                         
<?php #$this->load->view('backend/footer'); ?>