<?php  $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
<?php if($this->session->flashdata('message') != ''){?>
<div class="alert alert-success col-md-6">
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
<div class="col-md-12 col-sm-12 col-xs-12">
   <div class="x_panel">
      <div class="col-md-12 col-xs-12 for-mobile">
         <div class="Filter Filter-btn2">
            <form class="form-search" method="get" action="<?= base_url() ?>production/production_setting">
               <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab'];?>"/>
               <div class="col-md-6">
                  <div class="input-group">
                     <span class="input-group-addon">
                     <i class="ace-icon fa fa-check"></i>
                     </span>
                     <input type="text" class="form-control search-query" placeholder="Dept,Shift,Machine Group" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="production/production_setting?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>">
                     <span class="input-group-btn">
                     <button type="submit" class="btn btn-purple btn-sm">
                     <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                     Search
                     </button>
                     <a href="<?php echo base_url(); ?>production/production_setting?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                     </span>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>production/production_setting">
         <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
      </form>
      <div class="x_content">
         <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
               <li role="presentation" class="active"><a href="#shift_tab_content1" id="shift-tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="submit_shift_settings()">Shift Setting</a></li>
               <li role="presentation" class=""><a href="#department_tab_content2" role="tab" id="department-tab" data-toggle="tab" aria-expanded="true" onClick="submit_department_settings()">Department Setting</a>
               </li>
               <li role="presentation" class=""><a href="#machine_ordering" role="tab" id="machineOrder-tab" data-toggle="tab" aria-expanded="true" >Machine Ordering</a></li>
               <li role="presentation" class=""><a href="#machine_grouping" role="tab" id="machineGroup-tab" data-toggle="tab" aria-expanded="true" onClick="submit_machine_group()">Machine Group</a></li>
               <li role="presentation" class=""><a href="#wages_perpiece" role="tab" id="wages_perpiece-tab" data-toggle="tab" aria-expanded="true" onClick="submit_wagesper_piece()">Wages Or Perpiece</a></li>
               <!--<li role="presentation" class=""><a href="#electr_unit_price" role="tab" id="electricityUnit-tab" data-toggle="tab" aria-expanded="false">Electricity Unit Price</a></li>-->
               <li role="presentation" class=""><a href="#inventory_settings" role="tab" id="inventory_settings-tab" data-toggle="tab" aria-expanded="true" onClick="inventory_settings()">Inventory setting</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
               <!---------------------------------------------shift tab----------------------------------------------------->
               <div role="tabpanel" class="tab-pane fade active in" id="shift_tab_content1" aria-labelledby="shift-tab">
                  <div class="x_content">
                     <p class="text-muted font-13 m-b-30"></p>
                     <?php if($can_add){
                        echo '<button type="button" class="btn btn-primary productionTab" data-toggle="modal" data-id="prodSettingEdit" id="add"><i class="fa fa-plus-circle">Add</i></button>';
                        }
                        ?>
                     <!--------- datatable-buttons------------->
                     <form id="shift_setting_frm">	<input type="hidden" value="shift_setting1" name="tab">	</form>
                     <table id="" class="table table-striped table-bordered account_index"  style="background-color: #f9f9f9;">
                        <thead>
                           

                           <tr>
                              <th>Id
                                 <span><a href="<?php echo base_url(); ?>production/production_setting?tab=shift_setting1&sort=asc" class="up"></a>
                                 <a href="<?php echo base_url(); ?>production/production_setting?tab=shift_setting1&sort=desc" class="down"></a></span>
                              </th>
                              <th>Company Unit
                                 <span><a href="<?php echo base_url(); ?>production/production_setting?tab=shift_setting1&sort=asc" class="up"></a>
                                 <a href="<?php echo base_url(); ?>production/production_setting?tab=shift_setting1&sort=desc" class="down"></a></span>
                              </th>
                              <th>Department
                                 <span><a href="<?php echo base_url(); ?>production/production_setting?tab=shift_setting1&sort=asc" class="up"></a>
                                 <a href="<?php echo base_url(); ?>production/production_setting?tab=shift_setting1&sort=desc" class="down"></a></span>
                              </th>
                              <th>Shift Number</th>
                              <th>Shift Name</th>
                              <th>Shift Duration</th>
                              <th>Shift Start Time</th>
                              <th>Shift End Time</th>
                              <th>Week Off</th>
                              <th>Created By / Edited By</th>
                              <th>Created Date</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                              if(!empty($productionSetting)){
                              	#pre($productionSetting);
                               $row_chk = 1;
                                foreach($productionSetting as $prodSetting){
                              	$depatName = getNameById('department',$prodSetting['department'],'id');
                              	#$unitName = getNameById('company_address',$prodSetting['company_unit'],'id');

                              	 if(getNameById('company_address',$prodSetting['company_unit'],'compny_branch_id')==''){
                              		 $unitName ='';
                              	  }else {
                              		$unitName =getNameById('company_address',$prodSetting['company_unit'],'compny_branch_id')->company_unit;
                              	 };
                              ?>

                           <?php
                           $j=0;
                           $shift_name = json_decode($prodSetting['shift_name']);
                           $shift_duration = json_decode($prodSetting['shift_duration']);
                           $shift_start = json_decode($prodSetting['shift_start']);
                           $shift_end = json_decode($prodSetting['shift_end']);
                           $week_off = json_decode($prodSetting['week_off']);
                           for ($i=1; $i<=$prodSetting['shift_number']; $i++) {
                           ?>

                           <tr <?php if($row_chk % 2 == 0){echo "style='background-color: #fff'"; } ?>>
                              <?php if($i == 1){ ?>
                              <td><?php echo $prodSetting['id']; ?></td>
                              <td><?php echo $unitName;?></td>
                              <td><?php if(!empty($depatName)){echo $depatName->name;}  ?></td>
                              <td><?php echo $prodSetting['shift_number'];  ?></td>
                              <?php } else {
                              echo "<td></td><td></td><td></td><td></td>";
                              } ?>
                              <td><?php echo $shift_name[$j]; ?></td>
                              <td><?php echo $shift_duration[$j]; ?></td>
                              <td><?php echo $shift_start[$j]; ?></td>
                              <td><?php echo $shift_end[$j]; ?></td>
                              <td><?php if(!empty($week_off)){echo implode(',', $week_off[$j]); } ?></td>
                              <?php if($i == 1){ ?>
                              <td>
                                 <?php if(getNameById('user_detail',$prodSetting['created_by'],'u_id')=='')
                                    {
                                    	$get_name='';
                                    }else{
                                    	$get_name=getNameById('user_detail',$prodSetting['created_by'],'u_id')->name;
                                    }

                                    if(getNameById('user_detail',$prodSetting['edited_by'],'u_id')=='')
                                    {
                                    	$get_name1='';
                                    }else{
                                    	$get_name1=getNameById('user_detail',$prodSetting['edited_by'],'u_id')->name;
                                    }
                                    ?>
                                 <?php echo (($prodSetting['created_by']!=0)?$get_name:'').'<br>'.(($prodSetting['edited_by']!=0)?$get_name1:''); ?>
                              </td>
                              <td><?php echo date("j F , Y", strtotime($prodSetting['created_date'])); ?></td>
                              <td><?php
                                 if($can_edit){
                                 	echo '<button type="button" class="btn btn-primary btn-xs btn-edit productionTab" data-toggle="modal" data-id="prodSettingEdit" id="'.$prodSetting['id'].'" data-tooltip="Edit"><i class="fa fa-pencil"></i></button>';
                                 }
                                 if($can_view){
                                 	echo '<button type="button" class="btn btn-success btn-view productionTab btn-xs" data-toggle="modal" data-id="prodSettingView" id="'.$prodSetting['id'].'" data-tooltip="View"><i class="fa fa-eye"></i></button>';
                                 }
                                 if($can_delete){
                                 	if($prodSetting['used_status'] ==1 ){
                                 		echo '<a href="javascript:void(0)" class="
                                 	   btn  btn-delete btn-xs" data-href="'.base_url().'production/deleteProductionSetting/'.$prodSetting['id'].'" class="btn btn-delete btn-xs" disabled="disabled" data-tooltip="Delete"><i class="fa fa-trash"></i></a>';
                                 	}else{
                                 		echo '<a href="javascript:void(0)" class="delete_listing
                                 	   btn btn-delete btn-xs" data-href="'.base_url().'production/deleteProductionSetting/'.$prodSetting['id'].'" class="btn  btn-delete" data-tooltip="Delete"><i class="fa fa-trash"></i></a>';
                                 	}
                                 }
                                 ?>
                              </td>
                           <?php } else {
                           echo "<td></td><td></td><td></td>";
                           } ?>
                           </tr>

                           <?php $j++; } ?>


                           <?php $row_chk++; }} ?>
                        </tbody>
                     </table>
                     <?php echo $this->pagination->create_links(); ?>
					  <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
                  </div>
               </div>
               <!------------------------------------------deapartment tab---------------------------------------------------------->
               <div role="tabpanel" class="tab-pane fade" id="department_tab_content2" aria-labelledby="department-tab">
                  <div class="x_content">
                     <p class="text-muted font-13 m-b-30"></p>
                     <?php if($can_add){
                        echo '<button type="button" class="btn btn-primary productionTab" data-toggle="modal" data-id="production_department_edit" id="add"><i class="fa fa-plus-circle">Add</i></button>';
                        }
                        ?>
                     <!--------- example ------------->
                     <form id="depart_setting_frm">	<input type="hidden" value="department_setting1" name="tab">	</form>
                     <table id="" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th>Id
                                 <span><a href="<?php echo base_url(); ?>production/production_setting?tab=department_setting1&sort=asc" class="up"></a>
                                 <a href="<?php echo base_url(); ?>production/production_setting?tab=department_setting1&sort=desc" class="down"></a></span>
                              </th>
                              <th>Department
                                 <span><a href="<?php echo base_url(); ?>production/production_setting?tab=department_setting1&sort=asc" class="up"></a>
                                 <a href="<?php echo base_url(); ?>production/production_setting?tab=department_setting1&sort=desc" class="down"></a></span>
                              </th>
                              <th>Unit</th>
                              <th>Created By / Edited By</th>
                              <th>Created Date</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                              if(!empty($production_departments)){
                              	foreach($production_departments as $production_department){
                              	$getunitName = getNameById('company_address',$production_department['unit_name'],'compny_branch_id');

                              ?>
                           <tr>
                              <td><?php echo $production_department['id']; ?></td>
                              <td><?php echo $production_department['name'];  ?></td>
                              <td><?php if(!empty($getunitName)){echo $getunitName->company_unit;} else{echo $production_department['unit_name'];} ?></td>
                              <td><?php echo (($production_department['created_by']!=0)?(getNameById('user_detail',$production_department['created_by'],'u_id')->name):'').'<br>'.(($production_department['edited_by']!=0)?(getNameById('user_detail',$production_department['edited_by'],'u_id')->name):''); ?></td>
                              <td><?php echo date("j F , Y", strtotime($production_department['created_date'])); ?></td>
                              <td><?php
                                 if($can_edit){
                                 	echo '<button type="button" class="btn btn-primary productionTab" data-toggle="modal" data-id="production_department_edit" id="'.$production_department['id'].'" data-tooltip="Edit"><i class="fa fa-pencil">Edit</i></button>';
                                 }
                                 if($can_delete){
                                 	if($production_department['used_status']==1){
                                 	//echo '<a href="javascript:void(0)" class="
                                 	//btn btn-danger" data-href="'.base_url().'production/deleteDepartmentSetting/'.$production_department['id'].'" class="btn btn-danger" disabled="disabled" data-tooltip="Delete"><i class="fa fa-trash"></i></a>';
                                 	}else{
                                 		//echo '<a href="javascript:void(0)" class="delete_listing
                                 		//btn btn-danger" data-href="'.base_url().'production/deleteDepartmentSetting/'.$production_department['id'].'" class="btn btn-danger" data-tooltip="Delete"><i class="fa fa-trash"></i></a>';
                                 	}
                                 }
                                 ?>
                              </td>
                           </tr>
                           <?php }} ?>
                        </tbody>
                     </table>
                     <?php echo $this->pagination->create_links(); ?>
					  <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
                  </div>
               </div>
               <!------------------------------------------tab for machine ordering--------------------------------------------->
               <div role="tabpanel" class="tab-pane fade" id="machine_ordering" aria-labelledby="machineOrder-tab">
                  <div class="x_content">
                     <div class="well">
                        <div class="row hidde_cls filter1 progress_filter">
                           <form>
                              <div class="item form-group">
                                 <div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
                                    <select class="form-control getBranch"  name="company_branch"  width="100%" tabindex="-1" aria-hidden="true">
                                       <option value=''>Select branch </option>
                                       <?php if(!empty($company_branch)){
                                          foreach($company_branch as $cb){
                                          	$address = $cb['address'];

                                          	$id = $cb['id'];
                                          	$data = json_decode($address);
                                          		foreach($data as $getAddress){
                                          			$branch_id = $getAddress->add_id;
                                          		$add = $getAddress->compny_branch_name;
                                          ?>
                                       <option value="<?php echo  $branch_id; ?>"><?php echo $add; ?></option>
                                       <?php
                                          }
                                          }
                                          }
                                          ?>
                                    </select>
                                 </div>
                                 <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" style="width:12%;">
                                    <select class="form-control department"  name="department_id"  tabindex="-1" aria-hidden="true" id ="departmentData">
                                       <option value=''>Select department</option>
                                    </select>
                                 </div>
                              </div>
                              <input type="submit" value="filter" class="btn btn-primary submitData" disabled="disabled">
                           </form>
                        </div>
                     </div>
                     <div id="sortableKanbanBoards" class="row">
                        <div class="panel panel-primary kanban-col" style="width:100%">
                           <div class="panel-heading">
                              Machine order
                              <i class="fa fa-2x fa-minus-circle pull-right machineOrder"></i>
                           </div>
                           <div class="panel-body">
                              <div id="machine_Order" class="kanban-centered">
                                 <h5>No data Avaialble</h5>
                                 <?php /*if(!empty($machine_order)){
                                    $i = 0;
                                    foreach($machine_order as $MachineDetail){
                                    $i++;
                                    ?>
                                 <article class="kanban-entry grab machine_order" id="item<?php echo $i; ?>" data_machine_id="<?php echo $MachineDetail['id'];?>"  data_machine_order_id="<?php echo $MachineDetail['priority_order'];?>" draggable="true">
                                    <div class="kanban-entry-inner">
                                       <div class="kanban-label" data_machine_order_id="<?php echo $MachineDetail['priority_order'];?>">
                                          <?php echo "<strong>Machine Id :</strong> ".$MachineDetail['id']." |
                                             <strong>Machine Name : </strong>".$MachineDetail['machine_name']. "|
                                             <strong>Machine code : </strong>".$MachineDetail['machine_code']." |
                                             <strong>Make And Model : </strong>".$MachineDetail['year_purchase']." |
                                             <strong>Placement Of machine : </strong>".$MachineDetail['placement']." |
                                             <strong>Created Date: </strong>".$MachineDetail['created_date']; ?>
                                       </div>
                                    </div>
                                 </article>
                                 <?php	}
                                    } */?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!---------------------close tab of machine ordering--------------------------------------------------->
               <!---------------------tab of machinegrouping--------------------------------------------------->
               <div role="tabpanel" class="tab-pane fade " id="machine_grouping" aria-labelledby="machineGroup-tab">
                  <div class="x_content">
                     <p class="text-muted font-13 m-b-30"></p>
                     <?php if($can_add){
                        echo '<button type="button" class="btn btn-primary productionTab" data-toggle="modal" data-id="prodGroupEdit" id="add"><i class="fa fa-plus-circle">Add</i></button>';
                        }
                        ?>
                     <!---- datatable ----------->
                     <form id="machinegrouping_setting_frm">	<input type="hidden" value="machinegrouping1" name="tab">	</form>
                     <table id="" class="table table-striped table-bordered" data-order='[[0,"desc"]]'>
                        <thead>
                           <tr>
                              <th>Id
                                 <span><a href="<?php echo base_url(); ?>production/production_setting?tab=machinegrouping1&sort=asc" class="up"></a>
                                 <a href="<?php echo base_url(); ?>production/production_setting?tab=machinegrouping1&sort=desc" class="down"></a></span>
                              </th>
                              <th>Machine Group
                                 <span><a href="<?php echo base_url(); ?>production/production_setting?tab=machinegrouping1&sort=asc" class="up"></a>
                                 <a href="<?php echo base_url(); ?>production/production_setting?tab=machinegrouping1&sort=desc" class="down"></a></span>
                              </th>
                              <th>Created Date</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php if(!empty($machine_group)){
                              foreach($machine_group as $machineGroup){
                              ?>
                           <tr>
                              <td><?php echo $machineGroup['id'];?></td>
                              <td><?php echo $machineGroup['machine_group_name'];?></td>
                              <td><?php echo date("j F , Y", strtotime($machineGroup['created_date'])); ?></td>
                              <td><?php
                                 if($can_edit){
                                 	echo '<button type="button" class="btn btn btn-xs btn-primary productionTab" data-toggle="modal" data-id="prodGroupEdit" id="'.$machineGroup['id'].'" data-tooltip="Edit"><i class="fa fa-pencil"></i></button>';
                                 }
                                 if($can_delete){

                                 	// if($machineGroup['used_status'] == 1){

                                 	// 	echo '<a href="javascript:void(0)" class="
                                 	// 	btn btn-danger" data-href="'.base_url().'production/deleteMachineGroup/'.$machineGroup['id'].'" class="btn btn-xs btn-danger" disabled="disabled" data-tooltip="Delete"><i class="fa fa-trash"></i></a>';
                                 	// }
                                 	// else{
                                 	// 	echo '<a href="javascript:void(0)" class="delete_listing
                                 	// 	btn btn-danger" data-href="'.base_url().'production/deleteMachineGroup/'.$machineGroup['id'].'" class="btn btn-danger" data-tooltip="Delete"><i class="fa fa-trash"></i></a>';
                                 	// }
                                 }
                                 ?>
                              </td>
                           </tr>
                           <?php }} ?>
                        </tbody>
                     </table>
                     <?php echo $this->pagination->create_links(); ?>
					  <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
                  </div>
               </div>
               <!----------------close tab for machine grouping------------------->
               <?php /*
                  <div role="tabpanel" class="tab-pane fade " id="electr_unit_price" aria-labelledby="electricityUnit-tab">
                  	<div class="x_content">
                  	<p class="text-muted font-13 m-b-30"></p>
                  	<p class="text-muted font-13 m-b-30"></p>
                  	<?php if($can_add){
                     echo '<button type="button" class="btn btn-primary productionTab" data-toggle="modal" data-id="prodElectrUnitPrice" id="add"><i class="fa fa-plus-circle">Add</i></button>';
                     }
                     ?>
               <table id="datatable-buttons" class="table table-striped table-bordered account_index">
                  <thead>
                     <tr>
                        <th>Id</th>
                        <th>Electricity Unit Price</th>
                        <th>Created Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($unit_price)){
                        foreach($unit_price as $unitPrice){
                        ?>
                     <tr>
                        <td><?php echo $unitPrice['id'];?></td>
                        <td><?php echo $unitPrice['electr_unit_price'];?></td>
                        <td><?php echo date("j F , Y", strtotime($unitPrice['created_date'])); ?></td>
                        <td><?php
                           if($can_edit){
                           	echo '<button type="button" class="btn btn btn-xs btn-primary productionTab" data-toggle="modal" data-id="prodElectrUnitPrice" id="'.$unitPrice['id'].'"><i class="fa fa-pencil"></i></button>';
                           }
                           if($can_delete){

                           	/*if($unitPrice['used_status'] == 1){

                           		echo '<a href="javascript:void(0)" class="
                           		btn btn-danger" data-href="'.base_url().'production/deleteMachineGroup/'.$unitPrice['id'].'" class="btn btn-xs btn-danger" disabled="disabled"><i class="fa fa-trash"></i></a>';
                           	}
                           	//else{
                           		echo '<a href="javascript:void(0)" class="delete_listing
                           		btn btn-danger" data-href="'.base_url().'production/deleteElectricityUnit/'.$unitPrice['id'].'" class="btn btn-danger"><i class="fa fa-trash"></i></a>';
                           	//}
                           }
                           ?>
                     </tr>
                     <?php }} ?>
                  </tbody>
               </table>
               */?>
               <!-------------------Start of per piece-------------------------------->
               <div role="tabpanel" class="tab-pane fade" id="wages_perpiece" aria-labelledby="wages_perpiece-tab">
                  <div class="x_content">
                     <p class="text-muted font-13 m-b-30"></p>
                     <?php if($can_add){
                        echo '<button type="button" class="btn btn-primary productionTab" data-toggle="modal" data-id="prodWages_perPiece" id="add"><i class="fa fa-plus-circle">Add</i></button>';
                        }
                        ?>
                     <form id="wagesperpice_setting_frm">	<input type="hidden" value="wages_per_pice" name="tab">	</form>
                     <!--------- datatable-responsive -------------->
                     <table id="" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th>Id
                                 <span><a href="<?php echo base_url(); ?>production/production_setting?tab=wages_per_pice&sort=asc" class="up"></a>
                                 <a href="<?php echo base_url(); ?>production/production_setting?tab=wages_per_pice&sort=desc" class="down"></a></span>
                              </th>
                              <th>Company Unit
                                 <span><a href="<?php echo base_url(); ?>production/production_setting?tab=wages_per_pice&sort=asc" class="up"></a>
                                 <a href="<?php echo base_url(); ?>production/production_setting?tab=wages_per_pice&sort=desc" class="down"></a></span>
                              </th>
                              <th>Department
                                 <span><a href="<?php echo base_url(); ?>production/production_setting?tab=wages_per_pice&sort=asc" class="up"></a>
                                 <a href="<?php echo base_url(); ?>production/production_setting?tab=wages_per_pice&sort=desc" class="down"></a></span>
                              </th>
                              <th>Wages Or PerPiece</th>
                              <th>Created Date</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                              if(!empty($wages_perpiece)){
                              	foreach($wages_perpiece as $wages_per_piece){
                              $department_name = getNameById('department',$wages_per_piece['department'],'id');
                               if(getNameById('company_address',$department_name->unit_name??'','compny_branch_id')==''){
                              	 $unitName ='';
                              }else {
                              	$unitName =getNameById('company_address',$department_name->unit_name,'compny_branch_id')->company_unit;
                              	};
                              	?>
                           <tr>
                              <td><?php echo $wages_per_piece['id']; ?></td>
                              <td><?php echo $unitName; ?></td>
                              <td><?php if(!empty($department_name)){echo $department_name->name; } ?></td>
                              <td><?php echo $wages_per_piece['wages_perpiece'];  ?></td>
                              <td><?php echo date("j F , Y", strtotime($wages_per_piece['created_date'])); ?></td>
                              <td><?php
                                 if($can_edit){
                                 	echo '<button type="button" class="btn btn-primary productionTab" data-toggle="modal" data-id="prodWages_perPiece" id="'.$wages_per_piece['id'].'" data-tooltip="Edit"><i class="fa fa-pencil">Edit</i></button>';
                                 }
                                 if($can_delete){
                                 	//if($production_department['used_status']==1){
                                 	echo '<a href="javascript:void(0)" class="delete_listing
                                 			btn btn-danger"  data-href="'.base_url().'production/deleteWagesSetting/'.$wages_per_piece['id'].'" class="btn btn-danger" data-tooltip="Delete"><i class="fa fa-trash"></i></a>';

                                 }
                                 ?>
                              </td>
                           </tr>
                           <?php }} ?>
                        </tbody>
                     </table>
                     <?php echo $this->pagination->create_links(); ?>
				 <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
                  </div>
               </div>
               <!--------------------------end of wages---------------------------------------------->
               <div role="tabpanel" class="tab-pane fade" id="inventory_settings" aria-labelledby="inventory_settings-tab">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <label class="col-md-12 col-sm-12 col-xs-12" for="type">Material conversion management<span class="required">*</span></label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <table class="table table-striped">
                           <tbody>
                              <tr>
                                 <th scope="row">Process wise OR Work in process (ON for Process Wise / OFF for Work in Process)</th>
                                 <td>
                                    <form id="material_conversion_on_off" method="post" action="" enctype="multipart/form-data">
                                       <?php


                                          $discount_Settings = $this->inventory_model->get_data('company_detail',array('id'=> $this->companyGroupId));

                                          $statusChecked = $discount_Settings[0]['material_conversion_on_off']==1?'checked':'';
                                          $onoff = $discount_Settings[0]['material_conversion_on_off']==1?'ON':'OFF';

                                          echo '<input type="checkbox" class="js-switch change_status_material_conversion"  data-switchery="true" style="display: none;" value="'.$discount_Settings[0]['material_conversion_on_off'].'" data-value="'.$this->companyGroupId.'"  '.$statusChecked .'>';
                                       ?>
                                       <label for="subscribeNews">
                                             <?php echo $onoff; ?>
                                       </label>
                                    </form>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
<div id="production_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content" style="float: left;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Production Setting</h4>
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
