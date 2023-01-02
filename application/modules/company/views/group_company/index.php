<div class="x_content">
	<div class="row hidde_cls">
			<?php if($this->session->flashdata('message') != ''){
					echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
					setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
				}?>
			<p class="text-muted font-13 m-b-30"></p>
			<div class="row hidde_cls">
					<div class="col-md-12 right">
				
						<?php if($can_add) {
							echo '<button type="button" class="btn btn-primary add_group_company_details" data-toggle="modal" id="add" data-id="company_group_details">Add</button>';
						} ?>
				</div>
			</div>
	</div>

			
			<div id="print_div_content">
				<table id="datatable-buttons" class="table table-striped table-bordered action-icons" data-id="account" style="width:100%" border="1" cellpadding="3">
				<thead>
					<tr>
						<th>S.no</th>
						<th>Group Name</th>
						<th>Email</th>
						<th>GST NO.</th>
						<th>Account Number</th>
						<th>IFSC No</th>
						<?php /*<th>Created By</th>
						<th class='hidde'>Created On</th>		 */ ?>		
						<th class='hidde'>Action</th>
					</tr>
				</thead>
					<tbody>
					<?php
					//pre($company_grp_dtl);
					$sno = 1 ;
					foreach($company_grp_dtl as $c_data){
						if($c_data['bank_details'] !=''){
						 		$bank_info = json_decode($c_data['bank_details']);
                                $bankinfo  = $bank_info[0];   
                            }		
                                #pre($bank_info[0]); 

						$action = '';
						$action .=  '<a href="javascript:void(0)" id="'.$c_data["id"] . '" data-id="company_group_view_details" class="add_group_company_details btn btn-warning btn-xs" id="'.$c_data["id"].'"><i class="fa fa-eye"></i></a>';
						//$created_by_name = getNameById('user_detail',$c_data['created_by'],'u_id');
						
						if($can_edit) {
							$action .=  '<a href="javascript:void(0)" id="'. $c_data["id"] . '" data-id="company_group_details" class="add_group_company_details btn btn-edit  btn-xs" data-tooltip="Edit" id="' . $c_data["id"] . '" ><i class="fa fa-pencil"></i>  </a>';		
						}
						/* if($can_delete) { 
							$action = $action.'<a href="javascript:void(0)"  class="delete_listing btn  btn-delete  btn  btn-xs" data-tooltip="Delete"   data-href="'.base_url().'company/deletegoup_company_details/'.$c_data["id"].'" ><i class="fa fa-trash"></i></a>';
						} */
						 
						 echo "<tr>
                                        <td>".$sno."</td>
                                        <td>".$c_data['name']."</td>
                                         <td>".$c_data['company_group_email']."</td>
                                         <td>".$c_data['gstin']."</td>
                                        <td>";
                                        if(!empty($bankinfo)){ echo $bankinfo->account_no; }else {echo '';}
                                        echo "</td>
                                        <td>";
                                        if(!empty($bankinfo)){ echo $bankinfo->account_ifsc_code; }else {echo '';}
                                        echo "</td>
                                        <td class='hidde'>".$action. "</td> 
                                    </tr>";
					$sno++;	
					}
					?>
					
					</tbody>                   
			</table>
	</div>
<div id="add_group_company_detail_modal" class="modal fade in"  role="dialog">  
	<div class="modal-dialog  modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Company Group Detail</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>