<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-success col-md-6">                            
			<?php echo $this->session->flashdata('message');?>
		</div>                        
<?php }?>


<div class="x_content">
	
	<p class="text-muted font-13 m-b-30"></p>  
   <div class="row hidde_cls export_div">
      <div class="col-md-12">
        <div class="btn-group"  role="group" aria-label="Basic example">	
<button type="button" class="btn btn-info  add_crm_tabs addBtn" data-toggle="modal" id="add" data-id="customer_Type">Add</button>
</div>
</div>
</div>
	<table id="datatable-buttons12" class="table table-striped table-bordered account_index" data-id="account">
		<thead>
			<tr>
				        <th>Id</th>
						<th>Customer Type</th>
						<th>Full Load</th>
						<th>Part Load</th>
						<th>Created By/Edited By</th>
						<th>Created Date</th>
						<th>Action</th>
					</tr>
			</tr>
		</thead>
		<tbody>
		   <?php if(!empty($customerType)){

		   												


						foreach($customerType as $customer_Type){		
					
					$statusChecked = $customer_Type['active_inactive']==1?'checked':'';
					//$statusChecked = "";			
					$action = '';
					
					$createdByData = getNameById('user_detail',$customer_Type['created_by'],'u_id');
														if(!empty($createdByData)){
															$createdByName = $createdByData->name;
														}else{
														$createdByName = '';
														}

				 		
							$action = '<input type="checkbox" class="js-switch change_status_uom"  data-switchery="true" style="display: none;" value="'.$customer_Type['active_inactive'].'" 
										data-value="'.$customer_Type['id'].'"  '.$statusChecked .'>';
									
						
							$action .= '<button type="button" data-process-id="'.$customer_Type["id"].'" id="'.$customer_Type["id"].'" data-id="customer_Type" class="btn add_crm_tabs" data-toggle="modal">Edit</button>';
						
						
						/*if($process_Type['used_status'] == 1){
							$action = $action.'<a href="javascript:void(0)" class="
							btn btn-danger" data-href="'.base_url().'production/deleteProcessType/'.$process_Type["id"].'" disabled="disabled"><i class="fa fa-trash"></i></a>';
						}else{
							$action = $action.'<a href="javascript:void(0)" class="delete_listing
							btn btn-danger" data-href="'.base_url().'production/deleteProcessType/'.$process_Type["id"].'" ><i class="fa fa-trash"></i></a>';
						}*/

					echo "<tr>
						<td>".$customer_Type['id']."</td>
						<td>".$customer_Type['type_of_customer']."</td>
						<td>".$customer_Type['full_load']."</td>
						<td>".$customer_Type['part_load']."</td>
						<td>".$createdByName."</td>
						<td>".$customer_Type['created_date']."</td>
						<td class='hidde action'>
			      <i class='fa fa-cog'></i>
				    <div class='on-hover-action'>".$action."</div></td>	
					</tr>";
				}
		   } ?>
		</tbody>                   
	</table>
</div>

   <!--<div class="modal fade editProcessType production_modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Add process Type</h4>
                        </div>
                        <div class="modal-body">
							<form method="post" class="form-horizontal" action="<?php ///echo base_url(); ?>production/saveProcessType" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
							<input type="hidden" id="id" name="id" value="">
							<div class="item form-group col-md-12 col-sm-12 col-xs-12">
								<label class="control-label col-md-2 col-sm-2 col-xs-4" for="process_type">Process Type : </label>
								<div class="col-md-10 col-sm-10 col-xs-8">
									<input type="text" id="process_type" name="process_type" class="form-control col-md-7 col-xs-12" value="">
								</div>
							</div>
						  
							<div class="item form-group col-md-12 col-sm-12 col-xs-12">
								<label class="control-label col-md-2 col-sm-2 col-xs-4" for="description">Description</label>
								<div class="col-md-10 col-sm-10 col-xs-8">
									<textarea type="text" id="description" name="description" class="form-control col-md-7 col-xs-12" value=""></textarea>
								</div>
							</div>
							
							<div class="modal-footer">
							  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							  
							  <input type="submit" class="btn btn-warning" value="Submit">
							</div>
							</form>
                        </div>
                       

                      </div>
                    </div>
                  </div>-->
<div id="crm_add_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog ">
		<div class="modal-content" style="display:table;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Customer Types</h4>
			</div>
			<div class="modal-body-content" ></div>
		</div>
	</div>
</div>