 
<?php  $this->load->model('Quality_control_model');		
if($this->session->flashdata('message') != ''){?>                        
	<div class="alert alert-success col-md-6">                            
	<?php echo $this->session->flashdata('message');?> </div>                        
<?php }?>
<div class="x_content">
<div class="stik">
 <?php $str = base64_decode('YW5vZGl6ZSQxMjNfQCMhQA==');
      str_replace("_@#!@", "", $str);
	?>
</div>
	<div class="row">
				    <div class="col-md-3 datePick-right col-xs-12 ">
					  <button type="button" class="btn btn-primary qualityTab addBtn" data-toggle="modal" id="addins" data-id="AddPid">Add New Report</button>						
										  </div>
						<div class="col-md-12 col-xs-12 col-sm-12">
		<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
<p class="text-muted font-13 m-b-30"></p>    
<div id="print_div_content">  
		<table  id="datatable-buttons"  class="table table-striped table-bordered account_index" border="1" cellpadding="3" >
		<thead>
			<tr>
			    <th>Id</th>
				<th>Report Name</th>
				<th>Material Name</th>
				<th>Actions</th>	
			</tr>
		</thead>
		<tbody>
	<?php $i=1; foreach($pid as $val){?>
		<tr>
		    <td><?php echo $val['id'];?></td>
		     <td><?php echo $val['report_name'];?></td>
		     <td><?php $this->Quality_control_model->get_row_value('material','id',$val['material_id']);?></td>
		     	<td>
	<button type="button" data-id="AddGrn" data-tooltip="Edit" materialId="<?= $val['material_id']??'' ?>" class="btn btn-edit btn-xs qualityTab" data-toggle="modal" id="<?php echo $val['id'];?>"><i class="fa fa-pencil"></i></button>
	<button type="button" data-id="ViewGrn" data-tooltip="View" class="btn btn-view btn-xs qualityTab" data-toggle="modal" id="<?php echo $val['id'];?>"><i class="fa fa-eye"></i></button>
    <a href="<?php base_url();?>/quality_control/delete_pid/<?php echo $val['id'];?>" class="btn btn-delete btn-xs" ><i class="fa fa-trash"></i></a>
						</td>
		</tr>
		   
	
		<?php  $i++;} ?>				
				</tbody>                               
		</table>
	</div>
</div>

<div id="quality_modal" class="modal fade in"  role="dialog" >
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content" style="display:table;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Report Details</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
