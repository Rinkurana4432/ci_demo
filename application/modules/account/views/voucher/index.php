<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	        <form class="form-search" method="post" action="<?= base_url() ?>account/voucher_types">
			<div class="col-md-6">
			<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,name" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>" data-ctrl="account/voucher_types">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
						 <a href="<?php echo base_url(); ?>account/voucher_types"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
				</div>
			</form>	  
			<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>account/voucher_types">
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
					echo '<button type="button" class="btn btn-success addBtn add_voucher_tabs" data-toggle="modal" id="add" data-id="voucher"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
				} ?>
            </div>
</div>
	<p class="text-muted font-13 m-b-30"></p>
    
            <!------  datatable-buttons ----------> 
<!--<div class="col-md-6">
			<div class="input-group">
			<span class="input-group-addon">
						<i class="ace-icon fa fa-search"></i>
					</span>
			<input type="text" class="form-control search-query" placeholder="Type your search word" name="search" id="search" value="">
			</div></div>
			<hr>-->
					
	<table id="" class="table table-striped table-bordered" data-id="account" style="margin-top:40px;">
		<thead>
			<tr>
				<th scope="col">Id
		 <span><a href="<?php echo base_url(); ?>account/voucher_types?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/voucher_types?sort=desc" class="down"></a></span></th>
				<th scope="col">Name
		 <span><a href="<?php echo base_url(); ?>account/voucher_types?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/voucher_types?sort=desc" class="down"></a></span></th>
				<th scope="col">Description</th>
				<th scope="col">Created By</th>
				<th scope="col">Edited By</th>
				<th scope="col">created On</th>				
				<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody>
		   <?php  		  
		   if(!empty($voucher)){
			   foreach($voucher as $vouchers){ 
			   $action = '';
			   if($vouchers['created_by_uid'] == 0){
				   if($can_edit) { 
				   $created_by_name ='Admin';
					$action .=  '<a href="javascript:void(0)" id="" data-id="voucher" class=" btn btn-info btn-xs" data-tooltip="Edit" disabled="disabled"><i class="fa fa-pencil"></i></a>';
					$action .=  '<a href="javascript:void(0)" id="" data-id="voucher_view" class=" btn btn-warning btn-xs" data-tooltip="view" disabled="disabled"><i class="fa fa-eye"></i></a>';
					}
					if($can_delete) { 
						$action = $action.'<a href="javascript:void(0)" class="btn btn-danger  btn btn-info btn-xs" data-tooltip="delete" disabled="disabled"><i class="fa fa-trash"></i></a>';
					}
					$edited_by = ($vouchers['edited_by']!=0)?(getNameById('user_detail',$vouchers['edited_by'],'u_id')->name):'';
				   
			   }else{
				if($can_edit) { 
					$created_by_name = 	getNameById('user_detail',$vouchers['created_by_uid'],'u_id')->name;
					$action .=  '<a href="javascript:void(0)" id="'. $vouchers["id"] . '" data-id="voucher" data-tooltip="Edit" class="add_voucher_tabs btn btn-info btn-xs" id="' . $vouchers["id"] . '"><i class="fa fa-pencil"></i></a>';
					$action .=  '<a href="javascript:void(0)" id="'. $vouchers["id"] . '" data-id="voucher_view" data-tooltip="view" class="add_voucher_tabs btn btn-warning btn-xs" id="' . $vouchers["id"] . '"><i class="fa fa-eye"></i></a>';
					}
					if($can_delete) { 
						$action = $action.'<a href="javascript:void(0)" data-tooltip="delete" class="delete_listing btn btn-danger  btn btn-info btn-xs" data-href="'.base_url().'account/deleteVoucher/'.$vouchers["id"].'"><i class="fa fa-trash"></i></a>';
					}
					$edited_by = ($vouchers['edited_by']!=0)?(getNameById('user_detail',$vouchers['edited_by'],'u_id')->name):'';
			   }	
				echo "<tr>
					<td data-label='id:'>".$vouchers['id']."</td>
					<td data-label='Name:'>".$vouchers['voucher_name']."</td>  
					<td data-label='Description:'>".$vouchers['voucher_desc']."</td>
					<td data-label='Created By:'>".$created_by_name."</td>	
					<td data-label='Edited By:'>".$edited_by."</td>	
					<td data-label='created On:'>".date("j F , Y", strtotime($vouchers['created_date']))."</td>	
					<td data-label='Action:'>".$action."</td>	
				</tr>";
				}
		   }
	   ?>
		</tbody>                   
	</table>
    <?php echo $this->pagination->create_links(); ?>
	<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;"><?php echo $result_count; ?></span></div>
</div>

<div id="vaoucher_add_modal" class="modal fade in"  role="dialog">  
	<div class="modal-dialog modal-lg ">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Voucher </h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
  
    
