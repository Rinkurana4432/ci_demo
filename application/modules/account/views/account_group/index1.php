
<div class="x_content">

	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
	<?php if($can_add) {
		echo '<button type="button" class="btn btn-primary addAccountGroup" data-toggle="modal" id="add">Add</button>';
	} ?>
	<p class="text-muted font-13 m-b-30"></p>      
	 <!--- <form class="form-search" method="get" action="<?= base_url() ?>account/account_groups/">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Type your search word" name="search" id="search" value="<?php echo $search_string;?>">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
					</span>
				</div>
			</form>	
			<!---datatable-buttons--->
			<div class="col-md-6">
			<div class="input-group">
			<span class="input-group-addon">
						<i class="ace-icon fa fa-search"></i>
					</span>
			<input type="text" class="form-control search-query" placeholder="Type your search word" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>">
			</div></div>
			<hr>
			<input type="hidden" id="visible_row" value=""/>
	<table id="mytable" class="table tblData table-striped table-bordered account_group_index" data-id="account">
		<thead>
			<tr>
				<th>Id</th>
				<th>Group Name</th>
				<th>Parent </th>
				<th>Account Group</th>
				<th>Created By</th>
				<th>created On</th>				
				<th>Action</th>
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
					$action .=  '<a href="javascript:void(0)" id="" data-id="" class=" btn btn-info btn-xs" id="" disabled="disabled"><i class="fa fa-pencil"></i> Edit </a>';					 
					}
					if($can_delete) { 
						$action = $action.'<a href="javascript:void(0)" class="
						btn btn-danger" data-href="" disabled="disabled"><i class="fa fa-trash" ></i></a>';
					}
				}else{
					$created_by_name = getNameById('user_detail',$account_group['created_by'],'u_id')->name;
					if($can_edit) { 
					$action .=  '<a href="javascript:void(0)" id="'. $account_group["id"] . '" data-id="'.$account_group["id"].'" class="addAccountGroup btn btn-info btn-xs" id="' . $account_group["id"] . '"><i class="fa fa-pencil"></i> Edit </a>';					 
					}
					if($can_delete) { 
						$action = $action.'<a href="javascript:void(0)" class="delete_listing
						btn btn-danger" data-href="'.base_url().'account/deleteAccountGroup/'.$account_group["id"].'"><i class="fa fa-trash"></i></a>';
					}
				}
				
				//$account_group['id']			
				echo "<tr>
					<td>".$account_group['id']."</td>
					<td>".$account_group['name']."</td>
					<td>".$parentGroup."</td>
					<td>".$accountGroup."</td>
					<td>".$created_by_name."</td>	
					<td>".date("j F , Y", strtotime($account_group['created_date']))."</td>	
					<td>".$action."</td>	
				</tr>";
				$i++;
				}
		   }
	   ?>
		</tbody>                   
	</table>
						<?php echo $this->pagination->create_links(); ?>	

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



