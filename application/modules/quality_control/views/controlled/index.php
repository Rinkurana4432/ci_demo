
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
					  <button type="button" class="btn btn-primary qualityTab addBtn" data-toggle="modal" id="addins" data-id="AddControlledReport">Add New Report</button>						
										  </div>
						<div class="col-md-12 col-xs-12 col-sm-12">
							
									
						
	<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
<p class="text-muted font-13 m-b-30"></p>    

<div id="print_div_content">  

	<table  id=""  class="table table-striped table-bordered account_index" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
		<thead>
			<tr>
			    
				<th>Id</th>
				<th>Report Name</th>
				<th>Order Type</th>
				<th>Material Name</th>
				<th>Actions</th>	
			</tr>
		</thead>
		<tbody>
	<?php $i=1; foreach($con as $val){?>
		<tr>
		    <td><?php echo $val['id'];?></td>
		     <td><?php echo $val['report_name'];?></td>
		     <td><?php echo $val['saleorder'];?></td>
		     <td><?php $this->Quality_control_model->get_row_value('material','id',$val['material_id']);?></td>
		     	<td>
	<button type="button" data-id="EditControlledReport" data-tooltip="Edit" class="btn btn-edit btn-xs qualityTab" data-toggle="modal" id="<?php echo $val['id'];?>">Edit</button>
	<button type="button" data-id="ViewControlledReport" data-tooltip="View" class="btn btn-edit btn-xs qualityTab" data-toggle="modal" id="<?php echo $val['id'];?>">View</button>
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
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">??</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Report Details</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
