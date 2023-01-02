<div class="x_content">

	<?php
		if($this->session->flashdata('message') != ''){
			
			
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
	<?php if($can_add) {
		/* For adding add this class in add Button */
		//addParentGroup 
		echo '<button type="button" class="btn btn-primary" data-toggle="modal" id="add">Add</button>';
	} ?>
	<p class="text-muted font-13 m-b-30"></p>                   
	<table id="datatable-buttons" class="table table-striped table-bordered account_group_index" data-id="account">
		<thead>
			<tr>
				<th>Id</th>
				<th>Group Name</th>
				<th>Created By</th>
				<th>Created On</th>				
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		    <?php  if(!empty($parent_groups)){
			   $i = 1;
			   foreach($parent_groups as $parent_group){ 
			   $action = '';
				
				
				if($parent_group['created_by'] == 0){
					$created_by_name ='Admin';
					if($can_edit) { 
					$action .=  '<a href="javascript:void(0)" id="" data-id="" class=" btn btn-info btn-xs" id="" disabled="disabled"><i class="fa fa-pencil"></i> Edit </a>';					 
					}
					if($can_delete) { 
						$action = $action.'<a href="javascript:void(0)" class="
						btn btn-danger" data-href="" disabled="disabled"><i class="fa fa-trash" ></i></a>';
					}
				}else{
					$created_by_name = getNameById('user_detail',$parent_group['created_by'],'u_id')->name;
					if($can_edit) { 
					$action .=  '<a href="javascript:void(0)" id="'. $parent_group["id"] . '" data-id="'.$parent_group["id"].'" class="addParentGroup btn btn-info btn-xs" id="' . $parent_group["id"] . '"><i class="fa fa-pencil"></i> Edit </a>';					 
					}
					if($can_delete) { 
						$action = $action.'<a href="javascript:void(0)" class="delete_listing
						btn btn-danger" data-href="'.base_url().'account/deleteParetGroup/'.$parent_group["id"].'"><i class="fa fa-trash"></i></a>';
					}
				}
				$newDate = date("d-M-Y", strtotime($parent_group['created_date']));
		
				echo "<tr>
					<td>".$i."</td>
					<td>".$parent_group['name']."</td>
					<td>".$created_by_name."</td>	
					<td>".$newDate."</td>	
					<td>".$action."</td>	
				</tr>";
				$i++;
				}
		   }
	   ?>
		</tbody>                   
	</table>
</div>

<div id="add_parent_group" class="modal fade in"  role="dialog" style="overflow:hidden;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Add Parent Group</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>



