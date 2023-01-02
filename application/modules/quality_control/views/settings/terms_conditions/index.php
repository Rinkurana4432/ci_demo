 
<div class="x_content">
<?php
if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}

	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

 ?>
<div class="stik">	
<form action="<?php echo site_url(); ?>crm/crmterms_condtn" method="post" id="export-form">
					<input type="hidden" value='' id='hidden-type' name='ExportType'/>
					<input type="hidden" value='' class='start_date' name='start'/>
					<input type="hidden" value='' class='end_date' name='end'/>
					<input type="hidden" value='<?php if(!empty($_POST['account_name'])){echo $_POST['account_name'] ;} ?>' class='account_name' name='account_name'/>
				</form>
		
</div>

	<div class="row hidde_cls export_div">
				<div class="col-md-12">
				<div class="col-md-3 datePick-right">
					<button type="button" class="btn btn-primary qualityTab addBtn" data-toggle="modal" id="add" data-id="editterms_condtn">Add</button>
              </div>	
					
				</div>
			</div>
	<p class="text-muted font-13 m-b-30"></p> 
<div id="print_div_content">	
	<table id="example" class="table table-striped table-bordered termscond_index"  style="width:100%" border="1" cellpadding="3">
		<thead>
			<tr>
				<th class="col-sm-1">Id</th>
				<th>Title</th>
				<th>Content</th>
				<th>Created Date</th>
				<th class='hidde'>Action</th>
			</tr>
		</thead>
		<tbody>
					<?php foreach($termsconds as $term){?><tr>
					</tr>	
					<td><?php echo $term->id;?></td>
							<td><?php echo $term->title;?></td>
							<td><?php echo $term->terms_cond;?></td>
							<td><?php echo date("j F , Y", strtotime($term->created_date));?></td>	
							<td><button id="<?php echo $term->id;?>" data-id="editterms_condtn" class="qualityTab btn btn-edit  btn-xs" data-toggle="modal" data-tooltip="Edit"><i class="fa fa-pencil"></i> </button>
							<button id="<?php echo $term->id;?>" data-id="viewterms_condtn" class="qualityTab btn btn-view btn-xs" data-toggle="modal" data-tooltip="View"><i class="fa fa-eye"></i> </button></td>	
					   </tr>
					   <?php }?>
		</tbody>                   
	</table>
	</div>
</div>
<div id="quality_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content" style="display:table;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
			</div>
			<div class="modal-body-content" ></div>
		</div>
	</div>
</div>