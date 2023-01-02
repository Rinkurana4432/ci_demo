<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
		<form class="form-search" method="post" action="<?= base_url() ?>account/hsnsacmaster">
		<div class="col-md-6">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="ace-icon fa fa-check"></i>
						</span>
						<input type="text" class="form-control search-query" placeholder="Enter HSN / SAC  Name" name="search" id="search" value="<?php if(!empty($_GET['search'])) echo $_GET['search'];?>" data-ctrl="account/hsnsacmaster">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-purple btn-sm">
								<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
								Search
							</button>
			<a href="<?php echo base_url(); ?>account/hsnsacmaster">
			<input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
						</span>
					</div>
		</div>
		</form>
		<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>account/hsnsacmaster">
		   <input type="hidden" name="order" id="order" value="<?php if($_POST['order']==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
		</form>

	  </div>
</div>

	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
	<div class="col-md-12 export_div">

			<div class="btn-group"  role="group" aria-label="Basic example">
	<?php if($can_add) {
		//echo '<button type="button" class="btn btn-success addBtn addHSNSAC" data-toggle="modal" data-id="edit_hsn_ledger"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
		echo '<a href="'.base_url().'account/createHSNSAC_master" class="btn btn-success addBtn"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</a>';
	} ?>
	</div>
	</div>
	<p class="text-muted font-13 m-b-30"></p>


			<!---datatable-buttons--->
	<table id="" class="table  table-striped table-bordered " data-id="account" style="margin-top:40px;">
		<thead>
			<tr>
				<th scope="col">Id
		 <span><a href="<?php echo base_url(); ?>account/hsnsacmaster?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/hsnsacmaster?sort=desc" class="down"></a></span></th>
				<th scope="col">HSN / SAC
		 <span><a href="<?php echo base_url(); ?>account/hsnsacmaster?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/hsnsacmaster?sort=desc" class="down"></a></span></th>
				<th scope="col">Short Name </th>
				<th scope="col">IGST</th>
				<th scope="col">SGST/CGST</th>
				<th scope="col">Type</th>
				<th scope="col">Cess</th>
				<th scope="col">Created On</th>
				<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody>
		   <?php
		   if(!empty($hsn_master_data)){
			   foreach($hsn_master_data as $val){

				    $action = '';
					if($can_edit) {
						$action .=  '<a href="javascript:void(0)" id="'. $val["id"] . '" data-id="edit_hsn_ledger" class="addHSNSAC btn btn-info btn-xs" id="' . $val["id"] . '"><i class="fa fa-pencil"></i></a>';
					}
				if($can_delete) {
					$action = $action.'<a href="javascript:void(0)" class="delete_listing btn btn-danger  btn btn-info btn-xs" data-href="'.base_url().'account/deleteHSNSAC/'.$val["id"].'"><i class="fa fa-trash"></i></a>';
				}
				    //$action .=  '<a href="javascript:void(0)" id="'. $ledger["id"] . '" data-id="ledger" class="add_account_tabs btn btn-info btn-xs" id="' . $ledger["id"] . '"><i class="fa fa-pencil"></i></a>';
				echo '<tr>';
				echo '<td>#'.$val['id'].'</td>';
				echo '<td>'.$val['hsn_sac'].'</td>';
				echo '<td>'.$val['short_name'].'</td>';
				echo '<td>'.$val['igst'].'</td>';
				echo '<td>'.$val['sgst']. '      ---       ' . $val['cgst'].'</td>';
				echo '<td>'.$val['type'].'</td>';
				echo '<td>'.$val['cess'].'</td>';
				echo '<td>'.date("j F , Y", strtotime($val['created_date'])).'</td>';
				echo '<td>'.$action.'</td>';

				echo '</tr>';

			   }

		   }else{
			echo'<tr><td colspan="9" style="text-align:center;">No Data Available</td></tr>';
		   }

			?>
		</tbody>
	</table>
    <?php echo $this->pagination->create_links(); ?>
	  <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
</div>
<div id="add_HSN_SAC_master" class="modal fade in"  role="dialog" style="overflow:hidden;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">HSN/SAC Master </h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
