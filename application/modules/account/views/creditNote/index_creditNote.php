<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
		<form class="form-search" method="post" action="<?= base_url() ?>account/creditNoteview">
		<div class="col-md-6">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="ace-icon fa fa-check"></i>
						</span>
						<input type="text" class="form-control search-query" placeholder="Enter credit note Number" name="search" id="search" value="<?php if(!empty($_GET['search'])) echo $_GET['search'];?>" data-ctrl="account/creditNoteview">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-purple btn-sm">
								<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
								Search
							</button>
			<a href="<?php echo base_url(); ?>account/creditNoteview">
			<input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
						</span>
					</div>
		</div>
		</form>	
		<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>account/creditNoteview">
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
		echo '<a href="'.base_url().'account/creditNote_create/"><button type="button" class="btn btn-success addBtn" data-toggle="modal" data-id="edit_hsn_ledger"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button></a>';
	} ?>
	</div>
	</div>
	<p class="text-muted font-13 m-b-30"></p>      
	
			
			<!---datatable-buttons--->
	<table id="" class="table  table-striped table-bordered " data-id="account" style="margin-top:40px;">
		<thead>
			<tr>
				<th scope="col">S.no
		 <span><a href="<?php echo base_url(); ?>account/creditNoteview?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/creditNoteview?sort=desc" class="down"></a></span></th>
				<th scope="col">Credit note No
		 <span><a href="<?php echo base_url(); ?>account/creditNoteview?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/creditNoteview?sort=desc" class="down"></a></span></th>
				<th scope="col">Customer Name </th>
				<th scope="col">Ledger</th>
				<th scope="col">Total Amount</th>
				<th scope="col">Created On</th>	 			
				<th scope="col">Action</th>	 			
				
			</tr>
		</thead>
		<tbody>
		   <?php 
		   if(!empty($creditNoteNo)){
			   $i = 1;
			   foreach($creditNoteNo as $val){
				    $action = '';
					if($can_edit) {
						
						$action .=  '<a href="'.base_url().'account/editCreditNote_details/'.$val["id"].'"  class=" btn btn-edit  btn-xs" >Edit</a>';
					}
					$action .=  '<a href="javascript:void(0)" id="'. $val["id"] . '" data-id="crSaleReturn_view_details" class="add_CrSaleREturn_details btn  btn-xs" id="' . $val["id"] . '">View</a>';
					
					if($can_delete) {	
						$action = $action.'<a href="javascript:void(0)" class="delete_listing btn  btn  btn-xs" data-href="'.base_url().'account/deletecreditNote/'.$val["id"].'">Delete</a>';
					}
					
				$customerName = getNameById('ledger',$val['customer_id'],'id');
				$saleLedger_name = getNameById('ledger',$val['ledgerID'],'id');
				$amountDtl = json_decode($val['amountDtl']);
			
				echo '<tr>';
				echo '<td>'.$i.'</td>';
				echo '<td><b>'.$val['crditNoteNo'].'</b></td>';
				echo '<td>'.$customerName->name.'</td>';
				echo '<td>'.$saleLedger_name->name.'</td>';
				echo '<td>'.$val['creditAMt'].'</td>';
				
				echo '<td>'.date("j F , Y", strtotime($val['created_date'])).'</td>';
				echo '<td class="hidde action"><i class="fa fa-cog"></i><div class="on-hover-action">'.$action.'</div></td>';
				
				echo '</tr>';
				 $i++  ;
			   }
			   
		   }else{
			echo'<tr><td colspan="9" style="text-align:center;">No Data Available</td></tr>';
		   }
		   
			?>
		</tbody>                   
	</table>
    <?php //echo //$this->pagination->create_links(); ?>	
	  <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
</div>
<div id="add_crsaleReturn_detail_modal" class="modal fade in"  role="dialog">  
	<div class="modal-dialog  modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Credit Note</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>



