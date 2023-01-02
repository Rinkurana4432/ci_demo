<div class="x_content">
		<p class="text-muted font-13 m-b-30"></p>                   
		<table id="datatable-buttons" class="table table-striped table-bordered user_index" data-id="company">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Email</th>
					<th>GSTIN</th>
					<th>Year Of Establishment</th>
					<th>Website</th>
					<th>Number of Employees</th>
					<th>Email Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			   <?php if(!empty($company)){
				   foreach($company as $comp){
					//$user['user_profile'] = $user['user_profile']?$user['user_profile']:'dummy.jpg';?>
				   <tr>
						<td><?php echo $comp['id']; ?></td>
						<td><?php echo $comp['name']; ?></td>
						
						<td><?php echo $comp['email']; ?></td>
						<td><?php echo $comp['gstin']; ?></td>
						<td><?php echo $comp['year_of_establish']; ?></td>
						<td><?php echo $comp['website']; ?></td>
						<td><?php echo $comp['no_of_employees']; ?></td>
						<td><?php echo $comp['email_status']; ?></td>	
						<td>
							<a href="<?php echo base_url(); ?>company/view/<?php echo $comp['id']; ?>" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i> View </a>
							<?php /*<a href="javascript:void(0)" id="<?php echo $comp['id']; ?>" data-id="company_view" class="add_company_tabs btn btn-warning btn-xs"><i class="fa fa-eye"></i> View </a>*/?>
							<?php /*<a href="<?php echo base_url(); ?>company/edit/<?php echo $comp['id']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>*/?>
							<?php /*<a href="javascript:void(0)" class="delete_listing_without
							btn btn-danger" data-href="<?php //echo base_url(); ?>company/delete/<?php // echo $comp['id']; ?>"><i class="fa fa-trash"></i></a>*/?>
						</td>
				   </tr>
				   <?php }
			   } ?>
		</tbody>                   
	</table>
</div>

<div id="company_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Company</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>