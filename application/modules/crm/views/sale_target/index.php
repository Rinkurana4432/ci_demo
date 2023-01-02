<div class="x_content">
<?php
if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}
?>	
	<div class="col-md-12">
	
	 <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
			<div class="col-md-4 col-sm-12 datePick-right">
			    <fieldset>
					<div class="control-group">
					  <div class="controls">
						<div class="input-prepend input-group">
						  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						  <input type="text" style="width: 200px" name="start_date_filter" id="start_date_filter" class="form-control" value="" data-table="crm/sale_targets">
						   
						</div>
					  </div>
					</div>
				</fieldset>
			<form action="<?php echo base_url(); ?>crm/sale_targets" method="post" id="date_range">	
				 <input type="hidden" value='' class='start_date' name='start'/>
				 <input type="hidden" value='' class='end_date' name='end'/>
			</form>		
			</div>
	    </div>
	</div>
			<div class="row hidde_cls stik">
               <div class="col-md-12 col-xs-12 col-md-12">
                   <div class="export_div" style="position: relative;">
				   <div class="btn-group"  role="group" aria-label="Basic example">
			<?php
//pre($saleTargetData);

	 if($can_add) {
		//echo '<a href="'.base_url().'crm/edit_lead/"><button type="buttton" class="btn btn-info" id="add" data-id="sale_target">Add</button></a>'; 
		echo '<button type="button" class="btn btn-success indent addBtn add_crm_tabs" data-toggle="modal" id="add" data-id="sale_target"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
	} ?>
				
			</div>
			</div>
			</div>
			</div>
		</div>
	<p class="text-muted font-13 m-b-30"></p> 
     <!-------------datatable-buttons--------->          
		  
	<table id="datatable-buttons" class="table table-striped table-bordered sale_target_index" style="width:100%;margin-top: 40px;" data-id="user_sale_target">
		<thead>
			<tr>
				<?php /*<th>Id</th>
				<th>Target Id</th>
				<th>User Name</th>*/?>
				<th scope="col">Month</th>
				<th scope="col" class="priority-2">Acheived / Set Sale Target</th>
				<th scope="col" class="priority-3">Acheived / Set Lead Generation Target</th>
				<th scope="col" class="priority-4">Acheived / Set Payment Tagret</th>
				
				<?php /*<th>Created Date</th>*/?>
				<th scope="col" class="priority-5">Action</th>
			</tr>
		</thead>
		<tbody>
		   <?php /* if(!empty($sale_targets)){
				foreach($sale_targets as $user_target){	
					$sale_target = 	$user_target['sale_target'];	
					$action = '';
					if($can_edit) { 
						 //$action = $action.'<a href="'.base_url().'crm/editAccount/'.$account["id"].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'; 
						 $action =  '<a href="javascript:void(0)" id="'. $sale_target["id"] . '" data-id="sale_target" class="add_crm_tabs btn btn-info btn-xs" id="' . $sale_target["id"] . '" data-date="'.$sale_target["start_date"].'"><i class="fa fa-pencil"></i> Edit </a>';					 
									
						}
						if($can_delete) { 
							$action = $action.'<a href="javascript:void(0)" class="delete_listing
							btn btn-danger" data-href="'.base_url().'crm/deleteSaleTagett/'.$sale_target["id"].'"><i class="fa fa-trash"></i></a>';
					}
						$SaletargetUserName = ($sale_target['user_id']!=0)?(getNameById('user_detail',$sale_target['user_id'],'u_id')):'';
						if(!empty($SaletargetUserName)){
							$SaletargetUserName = $SaletargetUserName->name;
						}else{
							$SaletargetUserName = '';
						}
						echo "<tr>
							<td>".$sale_target['id']."</td>						
							<td>".$SaletargetUserName."</td>
							<td>". $user_target['acheivedSaleTarget']." / ".$sale_target['sale_target']."</td>
							<td>". $user_target['acheivedLeadtarget']." / ".$sale_target['lead_generation_target']."</td>
							<td>". $user_target['paymentTargetAcheived']." / ".$sale_target['payment_target']."</td>					
							<td>".$sale_target['created_date']."</td>	
							<td>".$action."</td>	
						</tr>";
				}
			} */?>
			
			<?php //pre($saleTargetData); ?>
				<?php /*if(!empty($saleTargetData)){
					foreach($saleTargetData as $saleTarget){	
						$sale_target = 	(!empty($saleTarget['sale_target']))?$saleTarget['sale_target'][0]:array();	
						$action = '';
						if($can_edit) { 
							 //$action = $action.'<a href="'.base_url().'crm/editAccount/'.$account["id"].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'; 
							 $action =  '<a href="javascript:void(0)" id="'. (!empty($sale_target))?$sale_target["id"]:"" . '" data-id="sale_target" class="add_crm_tabs btn btn-info btn-xs" id="' . (!empty($sale_target))?$sale_target["id"]:"" . '" data-date="'.(!empty($sale_target))?$sale_target["start_date"]:"".'"><i class="fa fa-pencil"></i> Edit </a>';	
							$action =  '<a href="javascript:void(0)" id="'. $saleTarget["userId"] . '" data-id="sale_target" class="add_crm_tabs btn btn-info btn-xs" id="' . $saleTarget["userId"]. '" data-date="'.$saleTarget["userId"].'"><i class="fa fa-pencil"></i> Edit </a>';	
										
							}
							if($can_delete) { 
								$action = $action.'<a href="javascript:void(0)" class="delete_listing
								btn btn-danger" data-href="'.base_url().'crm/deleteSaleTagett/'.$sale_target["id"].'"><i class="fa fa-trash"></i></a>';
						}
							$saleTargetUserName = ($saleTarget['userId']!=0)?(getNameById('user_detail',$saleTarget['userId'],'u_id')):'';
							if(!empty($saleTargetUserName)){
								$saleTargetUserName = $saleTargetUserName->name;
							}else{
								$saleTargetUserName = '';
							}
							echo "<tr>
								<td>".$sale_target['id']."</td>						
								<td>".$saleTargetUserName."</td>
								<td>". $saleTarget['acheivedSaleTarget']." / ".$sale_target['sale_target']."</td>
								<td>". $saleTarget['acheivedLeadtarget']." / ".$sale_target['lead_generation_target']."</td>
								<td>". $saleTarget['paymentTargetAcheived']." / ".$sale_target['payment_target']."</td>					
								<td>".$sale_target['created_date']."</td>	
								<td>".$action."</td>	
							</tr>";
					}
				}  */?>
			 <?php //pre($saleTargetData); 
			 if(!empty($saleTargetData)){
				foreach($saleTargetData as $std){
					$action = '';
					if($can_edit) { 
						$action .=  '<a href="javascript:void(0)" id="sale_target" data-id="sale_target" data-tooltip="Edit" class="add_crm_tabs btn btn-edit  btn-xs" data-date="'.$std['saleTarget']['start_date'].'"><i class="fa fa-pencil"></i>  </a>';	
				   } 
				   if($can_view) { 					
						$action .=  '<a href="javascript:void(0)" id="sale_target_view"  data-id="sale_target_view" data-tooltip="View" class="add_crm_tabs btn btn-view   btn-xs" data-date="'.$std['saleTarget']['start_date'].'"><i class="fa fa-eye"></i>  </a>';	
				   } 
					$std['acheivedPaymentTarget']	= $std['acheivedPaymentTarget']?$std['acheivedPaymentTarget']:0;
						echo "<tr>		
							<td data-label='Month:'>".date("F , Y", strtotime($std['saleTarget']['start_date']))."<span style='display:none;'>".$std['saleTarget']['start_date']."</span></td>
							<td data-label='Acheived / Set Sale Target:' class='priority-2'>". $std['acheivedSaleTarget']." / ".$std['saleTarget']['saleTarget']."</td>
							<td data-label='Acheived / Set Lead Generation Target:' class='priority-3'>". $std['acheivedLeadTarget']['leadAcheivedTarget']." / ".$std['saleTarget']['leadGenerationTarget']."</td>
							<td data-label='Acheived / Set Payment Tagret:' class='priority-4'>". $std['acheivedPaymentTarget']." / ".$std['saleTarget']['paymentTarget']."</td>
							<td data-label='Action:' class='priority-5 hidde' >".$action."</td>	
						</tr>";
				}
			} ?>
			
		</tbody>                   
	</table><?php //echo $this->pagination->create_links(); ?>	
</div>

<div id="crm_add_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Set Sale Target</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>