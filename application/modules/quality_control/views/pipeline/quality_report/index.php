 

<?php if($this->session->flashdata('message') != ''){?>                        
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
					  <button type="button" class="btn btn-primary qualityTab addBtn" data-toggle="modal" id="add" data-id="AddNewReport">Add New Report</button>						
										  </div>
						<div class="col-md-12 col-xs-12 col-sm-12">
							
									
						
	<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
<p class="text-muted font-13 m-b-30"></p>    

<div id="print_div_content">  

	<table id="datatable-buttons" style="width:100%" class="table table-striped table-bordered" border="1" cellpadding="3">
		<thead>
			<tr>
			    
				<th>Id</th>
				<th>Report Name</th>
				<th>Type</th>
				<th>For</th>
				<th>Created Date</th>
				<th>Created By</th>				
				<th>Actions</th>	
			</tr>
		</thead>
		<tbody>
	
		
		    <?php foreach($report as $data1){?>
		    <tr>
		        	
						<td><?php echo $data1->id;?></td>
						<td><?php echo $data1->report_name;?> </td>
							<td><?php echo $data1->type;?></td>
						<td><?php if($data1->type=='manufacturing')
					{
					$this->Quality_control_model->get_row_value('add_process','id',$data1->report_for) ;
					} else {
					$this->Quality_control_model->get_row_value('material','id',$data1->report_for);
					}?></td>
							<td><?php echo $data1->created_date;?></td>
								<td><?php 	$this->Quality_control_model->get_user_name($data1->created_by,$data1->created_by_cid);?></td>
									<td>
	<button type="button" data-id="EditNewReport" data-tooltip="Edit" class="btn btn-edit btn-xs qualityTab" data-toggle="modal" id="<?php echo $data1->id;?>"><i class="fa fa-pencil"></i></button>
	<button type="button" data-id="ViewReport" data-tooltip="View" class="btn btn-view btn-xs qualityTab" data-toggle="modal" id="<?php echo $data1->id;?>"><i class="fa fa-eye"></i></button>
    <a href="quality_control/delete/<?php echo $data1->id;?>" class="btn btn-delete btn-xs qualityTab" data-toggle="modal" id="<?php echo $data1->id;?>"><i class="fa fa-trash"></i></a>
		</td>
						</tr>			<?php }?>
		
	
						
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

