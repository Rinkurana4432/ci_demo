
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
<style>
.disable {
   pointer-events: none;
   cursor: default;
}
</style>
<div class="x_content">
   <p class="text-muted font-13 m-b-30"></p>
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="loggedInUserId">

   <div class="col-md-12  export_div">
      <div class="col-md-4 col-sm-12 datePick-right"> <?php if($can_add) {
         echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="AddSalaryComponent">Add Salary Component</button>';
         } ?></div>
   </div>
   <div class="container">
      <!-- Nav tabs -->
            <h2>Salary Component</h2>
            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Name</th>
                     <th>Abbr</th>
                     <th>Status</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
			   <?php foreach($salary_components_list as $value): ?>
                  <tr>
                     <td class="travel_id"><?php echo $value['id']; ?></td>
                     <td><?php echo $value['salary_component']; ?></td>
                     <td><span style="text-transform: uppercase;"><?php echo $value['salary_component_abbr']; ?></span></td>
					 <?php $disable = $can_edit?'':'disabled="disabled"'; ?>
					  <td align="left" valign="middle">
						<input class='validate_status' <?php echo $disable; ?> name="approve_status_<?php echo $value['id']; ?>" type="radio"  value="1" <?php if($value['approve_status']=='1'){ echo "checked=checked";}  ?>/> Approve
						<input <?php echo $disable; ?> name="approve_status_<?php echo $value['id']; ?>" class='validate_status' type="radio"  value="0" <?php if($value['approve_status']=='0'){ echo "checked=checked";}  ?>/> Disapprove
					</td>
                     
                     <td class="jsgrid-align-center ">
                        <a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="ViewSalaryComponent" data-tooltip="View" class="hrmTab btn btn-edit  btn-xs"><i class="fa fa-eye"></i>  </a>
						 <a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="AddSalaryComponent" data-tooltip="Edit" class="hrmTab btn btn-edit  btn-xs"><i class="fa fa-pencil"></i>  </a>
                     </td>
                  </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>
   </div>
<div id="printThis">
   <div id="hrm_modal" class="modal fade in btnPrint"  role="dialog">
      <div class="modal-dialog modal-lg modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Salary Component</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>
<?php #$this->load->view('backend/footer'); ?>
<script>

</script>