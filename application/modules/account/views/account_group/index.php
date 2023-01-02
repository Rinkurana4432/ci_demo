
<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	         <form class="form-search" method="post" action="<?= base_url() ?>account/account_groups">
	<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,Group Name" name="search" id="search" value="<?php if(!empty($_GET['search'])) echo $_GET['search'];?>" data-ctrl="account/account_groups">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
		<a href="<?php echo base_url(); ?>account/account_groups">
		<input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
</div>
			</form>	
			
				<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>account/account_groups">
			         <input type="hidden" name="order" id="order" value="<?php if($_POST['order']==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			   </form>
		<!--	   <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button> 
			 <div id="demo" class="collapse">
			        <div class="col-md-12 datePick-left col-xs-12 col-sm-12">                 
							<fieldset>
								<div class="control-group">
								  <div class="controls">
									<div class="input-prepend input-group">
									  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
									  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/invoices"/>
									</div>
								  </div>
								</div>
							</fieldset>
							<form action="<?php echo base_url(); ?>account/account_groups" method="get" id="date_range">	
							   <input type="hidden" value='' class='start_date' name='start'/>
							  <input type="hidden" value='' class='end_date' name='end'/>
							</form>	
						</div>
			 </div>-->
	  </div>
</div>

	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
	<div class="col-md-12 export_div">
		
			<div class="btn-group"  role="group" aria-label="Basic example">
	<?php if($can_add) {
		echo '<button type="button" class="btn btn-success addBtn addAccountGroup" data-toggle="modal" id="add"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
	} ?>
	</div>
	</div>
	<p class="text-muted font-13 m-b-30"></p>      
	
			
			<!---datatable-buttons--->
	<table id="" class="table  table-striped table-bordered account_group_index" data-id="account" style="margin-top:40px;">
		<thead>
			<tr>
				<th scope="col">Id
		 <span><a href="<?php echo base_url(); ?>account/account_groups?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/account_groups?sort=desc" class="down"></a></span></th>
				<th scope="col">Group Name
		 <span><a href="<?php echo base_url(); ?>account/account_groups?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/account_groups?sort=desc" class="down"></a></span></th>
				<th scope="col">Parent </th>
				<th scope="col">Account Group</th>
				<th scope="col">Created By</th>
				<th scope="col">created On</th>				
				<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody>
		   <?php  if(!empty($account_groups)){
			   $i = 1;
			   foreach($account_groups as $account_group){ 
			   $action = '';
				
				@$parentGroup = ($account_group['parent_group_id']!=0)?(getNameById('account_group',$account_group['parent_group_id'],'id')->name):'';
				@$accountGroup = ($account_group['acc_group_id']!=0)?(getNameById('account_group',$account_group['acc_group_id'],'id')->name):'';
				
				if($account_group['created_by'] == 0){
					$created_by_name ='Admin';
					if($can_edit) { 
					$action .=  '<a href="javascript:void(0)" id="" data-id="" class=" btn btn-info btn-xs" id="" disabled="disabled"><i class="fa fa-pencil"></i> </a>';					 
					}
					if($can_delete) { 
						$action = $action.'<a href="javascript:void(0)" class="
						btn btn-danger btn-xs" data-href="" disabled="disabled"><i class="fa fa-trash" ></i></a>';
					}
				}else{
					$created_by_name = getNameById('user_detail',$account_group['created_by'],'u_id')->name;
					if($can_edit) { 
					$action .=  '<a href="javascript:void(0)" id="'. $account_group["id"] . '" data-id="'.$account_group["id"].'" class="addAccountGroup btn btn-info btn-xs" data-tooltip="Edit"  id="' . $account_group["id"] . '"><i class="fa fa-pencil"></i></a>';					 
					}
					if($can_delete) { 
						$action = $action.'<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
						btn btn-danger btn-xs" data-href="'.base_url().'account/deleteAccountGroup/'.$account_group["id"].'"><i class="fa fa-trash"></i></a>';
					}
				}
				
				//$account_group['id']			
				echo "<tr>
					<td data-label='id:'>".$account_group['id']."</td>
					<td data-label='Group Name:'>".$account_group['name']."</td>
					<td data-label='Parent:'>".$parentGroup."</td>
					<td data-label='Account Group:'>".$accountGroup."</td>
					<td data-label='Created By:'>".$created_by_name."</td>	
					<td data-label='created On:'>".date("j F , Y", strtotime($account_group['created_date']))."</td>	
					<td data-label='action:'>".$action."</td>	
				</tr>";
				$i++;
				}
		   }
	   ?>
		</tbody>                   
	</table>
    <?php echo $this->pagination->create_links(); ?>	
	  <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
</div>
<div id="add_account_group" class="modal fade in"  role="dialog" style="overflow:hidden;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Add Account Group</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>



