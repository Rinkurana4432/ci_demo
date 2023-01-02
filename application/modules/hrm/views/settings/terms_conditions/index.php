
<div class="x_content">
<?php
if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}

	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

 ?>
 <div class="col-md-12 col-sm-12 for-mobile">
         <div class="Filter Filter-btn2">
   <form class="form-search" method="get" action="<?= base_url() ?>hrm/hrmterms_condtn">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter Title,Content" name="search" id="search" data-ctrl="hrm/assets_category" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
         <a href="<?php echo base_url(); ?>hrm/hrmterms_condtn">
		 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
         </span>
      </div>
   </div>
</form>
</div>
</div>
<div class="stik">	
<form action="<?php echo site_url(); ?>crm/crmterms_condtn" method="get" id="export-form">
					<input type="hidden" value='' id='hidden-type' name='ExportType'/>
					<input type="hidden" value='' class='start_date' name='start'/>
					<input type="hidden" value='' class='end_date' name='end'/>
					<input type="hidden" value='<?php if(!empty($_GET['account_name'])){echo $_GET['account_name'] ;} ?>' class='account_name' name='account_name'/>
				</form>
		
</div>

	<div class="row hidde_cls export_div">
				<div class="col-md-12">
				<div class="col-md-3 datePick-right">
					 
					<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="editterms_condtn">Add</button>
              </div>	
					
				</div>
			</div>
	<p class="text-muted font-13 m-b-30"></p> 
<div id="print_div_content">

	<table id="" class="table table-striped table-bordered termscond_index"  style="width:100%" border="1" cellpadding="3">
		<thead>
			<tr>
				<th class="col-sm-1">Id
				<span><a href="<?php echo base_url(); ?>hrm/hrmterms_condtn?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/hrmterms_condtn?sort=desc" class="down"></a></span><span class="resize-handle"></span></th>
				<th>Title
				<span><a href="<?php echo base_url(); ?>hrm/hrmterms_condtn?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/hrmterms_condtn?sort=desc" class="down"></a></span><span class="resize-handle"></span></th>
				<th>Content
				<span><a href="<?php echo base_url(); ?>hrm/hrmterms_condtn?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/hrmterms_condtn?sort=desc" class="down"></a></span><span class="resize-handle"></span></th>
				<th>Created Date<span class="resize-handle"></span></th>
				<th class='hidde'>Action<span class="resize-handle"></span></th>
			</tr>
		</thead>
		<tbody>
					<?php foreach($termsconds as $term){?><tr>
					</tr>	
					<td><?php echo $term['id'];?></td>
							<td><?php echo $term['title'];?></td>
							<td><?php echo $term['terms_cond'];?></td>
							<td><?php echo date("j F , Y", strtotime($term['created_date']));?></td>	
							<td data-label='Action:' class='hidde acc-btn action'><i class='fa fa-cog' aria-hidden='true'></i><div class='on-hover-action'><a id="<?php echo $term['id'];?>" data-id="editterms_condtn" class="hrmTab btn btn-edit  btn-xs" data-toggle="modal" >Edit </a>
							<a id="<?php echo $term['id'];?>" data-id="viewterms_condtn" class="hrmTab btn btn-view btn-xs" >View</a>
                             <a href="<?php echo base_url(); ?>hrm/delete_terms_condtn/<?php echo $term['id']; ?>" class="btn btn-xs btn-delete" onclick="return confirm('Are you Sure?');">Delete</a>
							 </div>
                            </td>	
					   </tr>
					   <?php }?>
		</tbody>                   
	</table>
	<?php  echo $this->pagination->create_links(); ?>
<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
	</div>
</div>
<div id="hrm_modal" class="modal fade in"  role="dialog">
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