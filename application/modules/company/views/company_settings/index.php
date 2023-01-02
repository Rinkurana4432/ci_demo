<?php

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

?>
<?php if($this->session->flashdata('message') != ''){?>                        
	<div class="alert alert-success col-md-6">                            
	<?php echo $this->session->flashdata('message');?> </div>                        
<?php }?>


  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_content">
			<div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <!--<li role="presentation" class="active"><a href="#shift_tab_content1" id="shift-tab" role="tab" data-toggle="tab" aria-expanded="true">Shift Setting</a></li>-->
                    <li role="presentation" class="active"><a href="#department_tab_content2" role="tab" id="department-tab" data-toggle="tab" aria-expanded="true">Department Setting</a>
                    </li>
				<!--	<li role="presentation" class=""><a href="#machine_ordering" role="tab" id="machineOrder-tab" data-toggle="tab" aria-expanded="true">Machine Ordering</a></li>
					<li role="presentation" class=""><a href="#machine_grouping" role="tab" id="machineGroup-tab" data-toggle="tab" aria-expanded="true">Machine Group</a></li>
					<li role="presentation" class=""><a href="#wages_perpiece" role="tab" id="wages_perpiece-tab" data-toggle="tab" aria-expanded="true">Wages Or Perpiece</a></li>
					<!--<li role="presentation" class=""><a href="#electr_unit_price" role="tab" id="electricityUnit-tab" data-toggle="tab" aria-expanded="false">Electricity Unit Price</a></li>-->
                </ul>
                <div id="myTabContent" class="tab-content">
					<!---------------------------------------------shift tab----------------------------------------------------->
                  	<!------------------------------------------deapartment tab---------------------------------------------------------->
                        <div role="tabpanel" class="tab-pane fade active in" id="department_tab_content2" aria-labelledby="department-tab">
                           <div class="x_content">
								<p class="text-muted font-13 m-b-30"></p>    
									<?php if($can_add){ 
										echo '<button type="button" class="btn btn-primary companyTab" data-toggle="modal" data-id="companydepartments_edit" id="add"><i class="fa fa-plus-circle">Add</i></button>'; 
									}
									?>
								<table id="example" class="table table-striped table-bordered" data-order='[[0,"desc"]]'>
									<thead>
										<tr>
											<th>Id</th>
											<th>Department</th>		
											<th>Unit</th>											
											<th>Created By / Edited By</th>
											<th>Created Date</th>	
											<th>Action</th>	
										</tr>
									</thead>
									<tbody>
										<?php
											if(!empty($company_departments)){
												
												foreach($company_departments as $companydepartments){
													
													// pre($companydepartments);
													
													
												$getunitName = '';	
												 // $getunitName = getNameById('company_address',$companydepartments['unit_name'],'compny_branch_id');
								$getunitName = $this->company_model->get_data_byId('company_address','compny_branch_id',$companydepartments['unit_name']);
												// pre($getunitName);  
										?>
										<tr>
											<td><?php echo $companydepartments['id']; ?></td>
											<td><?php echo $companydepartments['name'];  ?></td>
											<td><?php 
												#if(!empty($getunitName)){echo $getunitName->company_unit;} else{echo $companydepartments['unit_name'];} 
												if(!empty($getunitName)){echo $getunitName->company_unit;} else{echo $companydepartments['unit_name'];} 
											?></td>	
											<td><?php echo (($companydepartments['created_by']!=0)?(getNameById('user_detail',$companydepartments['created_by'],'u_id')->name):'').'<br>'.(($companydepartments['edited_by']!=0)?(getNameById('user_detail',$companydepartments['edited_by'],'u_id')->name):''); ?></td>
											<td><?php echo date("j F , Y", strtotime($companydepartments['created_date'])); ?></td>
											<td><?php
											if($can_edit){
												echo '<button type="button" class="btn btn-primary companyTab" data-toggle="modal" data-id="companydepartments_edit" id="'.$companydepartments['id'].'"><i class="fa fa-pencil">Edit</i></button>'; 
											}											
											if($can_delete){
												if($companydepartments['used_status']==1){
												echo '<a href="javascript:void(0)" class="
												btn btn-danger" data-href="'.base_url().'company/deleteDepartmentSetting/'.$companydepartments['id'].'" class="btn btn-danger" disabled="disabled"><i class="fa fa-trash"></i></a>';
												}else{
													echo '<a href="javascript:void(0)" class="delete_listing
													btn btn-danger" data-href="'.base_url().'company/deleteDepartmentSetting/'.$companydepartments['id'].'" class="btn btn-danger"><i class="fa fa-trash"></i></a>';
												}
											}
											?>
											</td>	
										</tr>
										   <?php }} ?>
									</tbody>
								</table>
							</div>
                        </div>
                        <!------------------------------------------tab for machine ordering--------------------------------------------->
					
						</div>
                    </div>
                </div>
            </div>
		</div>
    </div>
</div>



<div id="company_depart_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="float: left;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Company Department</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>

<div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-refresh fa-5x fa-spin"></i>
                        <h4>Processing...</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>