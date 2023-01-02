
<?php if($this->session->flashdata('message') != ''){?>                        
    <div class="alert alert-success col-md-6">                            
        <?php echo $this->session->flashdata('message');?>
    </div>                        
<?php }?>


<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
   <form class="form-search" method="get" action="<?= base_url() ?>hrm/users_salary">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter Name,Salary" name="search" id="search" data-ctrl="hrm/users_salary" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
     <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?php echo site_url(); ?>hrm/users_salary'" value="Reset">
         </span>
      </div>
   </div>
</form>
</div>
</div>

<div class="row hidde_cls stik">
         <div class="col-md-12 col-xs-12 col-md-12">
            <div class="export_div">
<div class="btn-group" role="group" aria-label="Basic example">
    <p class="text-muted font-13 m-b-30"></p>    
    <?php if($can_add) {
       echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="usersalary">Add Employee Salary</button>';
   } ?>
</div>
</div>
</div>
</div>
   <table id="" class="display nowrap table table-hover table-striped table-bordered" style="margin-top: 50px;" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID
      <span><a href="<?php echo base_url(); ?>hrm/users_salary?sort=asc" class="up"></a>
       <a href="<?php echo base_url(); ?>hrm/users_salary?sort=desc" class="down"></a></span></th>
            <th>Employees Name
      <span><a href="<?php echo base_url(); ?>hrm/users_salary?sort=asc" class="up"></a>
       <a href="<?php echo base_url(); ?>hrm/users_salary?sort=desc" class="down"></a></span></th>
           <!-- <th>Salary Type</th>-->
            <th>Salary Amount
      <span><a href="<?php echo base_url(); ?>hrm/users_salary?sort=asc" class="up"></a>
       <a href="<?php echo base_url(); ?>hrm/users_salary?sort=desc" class="down"></a></span></th>
            <th>Created Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
     <?php $sNo=1;   foreach($catvalue as $value): 

         $owner = getNameById('user_detail',$value['emp_id'],'u_id');
         $salary_type = getNameById('salary_type',$value['type_id'],'id');

        ?>
        <tr>

            <td><?php echo $value['id']; ?></td>
           <!-- <td><?php echo $sNo; ?></td>-->
            <td><?php echo @ $owner->name; ?></td>
           <!-- <td></?php echo $salary_type->salary_type; ?></td>-->
            <td><?php echo @ $value['total']; ?></td>
            <td><?php echo @ $value['created_date'];?></td>
            <td class="jsgrid-align-center ">
              <a href="javascript:void(0);" onclick="add_class_view_users_sal('1');"  title="Edit" class="hrmTab btn btn-edit  btn-xs" id="<?php echo $value['id']; ?>" data-id="usersalary"><i class="fa fa-pencil-square-o"></i></a>
              <a href="javascript:void(0);"  title="Edit" class="hrmTab btn btn-edit  btn-xs" id="<?php echo $value['id']; ?>" data-id="viewusersalary"><i class="fa fa-eye"></i></a>
           <!--  <a href="javascript:void(0);" title="View" class="hrmTab btn btn-view  btn-xs" id="<?php echo $value['id']; ?>" data-id="viewusersalary"><i class="fa fa-eye"></i></a> -->
                <a href="<?php echo base_url();?>hrm/delete_users_salary/<?php echo $value['id']; ?>" class="btn btn-delete  btn-xs" onclick="confirm('Are you sure?');"><i class="fa fa-trash"></i></a>
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
    <div id="hrm_modal" class="modal fade in btnPrint "  role="dialog">
        <div class="modal-dialog modal-lg modal-large addToggle">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Employees Salary</h4>
                </div>
                <div class="modal-body-content"></div>
            </div>
        </div>
    </div>
</div>                         
<?php #$this->load->view('backend/footer'); ?>


