<div class="col-md-12">
   <?php if($this->session->flashdata('message') != ''){?>                        
   <div class="alert alert-success col-md-6">                            
      <?php echo $this->session->flashdata('message');?> 
   </div>
   <?php }?>
</div>
<div role="tabpanel" data-example-id="togglable-tabs">
   <ul id="myTab" class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#in_progress_tab" data-select='progress' id="complete_tab" role="tab" data-toggle="tab" aria-expanded="true">In Process</a></li>
      <li role="presentation" class="complte "><a href="#Complete_content_tab" role="tab" data-select='complete' id="auto_entery_tab" data-toggle="tab" aria-expanded="false">Complete</a></li>
   </ul>
   <div id="myTabContent" class="tab-content">
      <div role="tabpanel" class="tab-pane fade active in" id="in_progress_tab" aria-labelledby="complete_tab">
         <div class="x_content">
            <div class="row hidde_cls export_div">
               <div class="col-md-12">
                  
                  <div class="btn-group"  role="group" aria-label="Basic example">
				     <?php if($can_add){ echo '<button class="btn btn-success addBtn maintenanceTab addBtn" data-toggle="modal" id="add1" data-id="addbreakdown">Add</button>'; }?>
                     <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
                     <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
                     <input type="hidden" value='add_bd_request' id="table" data-msg="Breakdown" data-path="maintenance/breakdown"/>
                     <button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
                     <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                        <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu" id="export-menu">
                           <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                           <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                        </ul>
                     </div>
                     <form action="<?php echo base_url(); ?>maintenance/breakdown" method="post" >
                        <input type="hidden" value='1' name='favourites'/>
                        <input type="hidden" value='<?php if(!empty($_POST['start'])){echo $_POST['start'];}?>' class='start' name='start'/>
                        <input type="hidden" value='<?php if(!empty($_POST['end'])){echo $_POST['end'];} ?>' class='end' name='end'/>
                        <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
                     </form>
                  </div>
                  <div class="col-md-3 col-xs-12 col-md-12 datePick-right">
                     					
                     <form action="<?php echo site_url(); ?>maintenance/breakdown" method="post" id="export-form">
                        <input type="hidden" value='' id='hidden-type' name='ExportType'/>
                        <input type="hidden" value='' class='start_date' name='start'/>
                        <input type="hidden" value='' class='end_date' name='end'/>
                     </form>
                  </div>
               </div>
            </div>
            <p class="text-muted font-13 m-b-30"></p>
            <div id="print_div_content" class="table-responsive">
			
			<div class="form-search2">
			<div class="col-md-9">
               <form class="form-search" method="post" action="<?= base_url() ?>maintenance/breakdown">
                  <div class="col-md-6">
                     <div class="input-group">
                        <span class="input-group-addon">
                        <i class="ace-icon fa fa-check"></i>
                        </span>
                        <input type="text" class="form-control search-query" placeholder="Enter id,Machine Name,Machine Type" name="search" id="search" value="<?php if(!empty($_POST['search'])) echo $_POST['search'];?>">
                        <span class="input-group-btn">
                        <button type="submit" class="btn btn-purple btn-sm">
                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                        Search
                        </button>
                        </span>
                     </div>
                  </div>
				  
               </form>
               <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>maintenance/breakdown">
                  <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
               </form>
			   </div>
			   <div class="col-md-3 col-xs-12 col-sm-12 datepicker">
                     <fieldset>
                        <div class="control-group">
                           <div class="controls">
                              <div class="input-prepend input-group">
                                 <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                 <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="maintenance/breakdown"/>
                              </div>
                           </div>
                        </div>
                     </fieldset>
                     <form action="<?php echo base_url(); ?>maintenance/breakdown" method="post" id="date_range">	
                        <input type="hidden" value='' class='start_date' name='start'/>
                        <input type="hidden" value='' class='end_date' name='end'/>
                     </form>
                  </div>
			   </div>
               <input type="hidden" id="visible_row" value=""/>
               <!------------------ datatable-buttons -------------->
               <table id="" class="table table-striped  table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
                  <thead>
                     <tr>
                        <th><input id="selecctall" type="checkbox"></th>
                        <th>Id</th>
                        <th>Purchase Id</th>
                        <th>Machine Name</th>
                        <th>Breakdown Causes</th>
                        <th>Machine Type</th>
                        <th>Priority</th>
                        <th>Request user</th>
                        <th>Created Date</th>
                        <th>Created By</th>
                        <th>Acknowledge Date</th>
                        <th>Acknowledge By</th>
                        <th>Worker</th>
                        <th>Action</th>
                     </tr>
                     </tr>
                  </thead>
                  <tbody>
                     <?php  if(!empty($user_breakdown)){ ?>
                     <?foreach($user_breakdown as $user_breakdownkey => $user_breakdowns){ ?>
                     
                     <tr>
                        <td><input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value="<?php echo $user_breakdowns['id']; ?>">
                           <?php if($user_breakdowns['favourite_sts'] == '1'){
                              echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$user_breakdowns['id']."  checked = 'checked'>";
                              echo"<input type='hidden' value='add_bd_request' id='favr' data-msg='Breakdown ' data-path='maintenance/breakdown' favour-sts='0' id-recd=".$user_breakdowns['id'].">";
                              }else{
                              echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$user_breakdowns['id'].">";
                              echo"<input type='hidden' value='add_bd_request' id='favr' data-msg='Breakdown ' data-path='maintenance/breakdown' favour-sts='1' id-recd =".$user_breakdowns['id'].">";
                              }
                              ?>  
                        </td>
                        <td><?php echo $user_breakdowns['id']; ?></td>
                        <td> <?php if(!empty($user_breakdowns['purchase_id'])){ ?>
                           <button id="<?php echo $user_breakdowns['purchase_id']; ?>" data-tooltip="View Purchase" class="btn btn-xs maintenanceTab" data-id="viewpurchase"><?php echo $user_breakdowns['purchase_id']; ?></button>
                        </td>
                        <?php } ?>
                        </td>
                        <!--<td><?php //echo $addMachine['machine_name']; ?></td>-->
                       <?php $machine = array();
						$machine = getNameById('add_machine', $user_breakdowns['machine_id'],'id'); 
						
						$createdBYY =  getNameById('user_detail', $user_breakdowns['created_by'],'u_id');
						$crtd_by_name = !empty($createdBYY)?$createdBYY->name:'Others';	
						//pre($machine);
						?>

                        <td>
                           <a href="javascript:void(0)" id="<?php echo $user_breakdowns['id']; ?>" data-id="machineView" class="maintenanceTab">
                              <?php echo !empty($machine->machine_name)?$machine->machine_name:$user_breakdowns['machine_name']; ?>
                        </td>
                        <td><?php echo $user_breakdowns['breakdown_couses']; ?></td>
                        <td><?php echo $user_breakdowns['machine_type']; ?></td>
                        <td><?php echo $user_breakdowns['priority']; ?></td>
                        <td><?php echo $user_breakdowns['requested_by']; ?></td>
                        
                        <td><?php echo date("j F , Y", strtotime($user_breakdowns['created_date'])) ?></td>
                         <td><?php echo $crtd_by_name; ?></td>
                        <td><?php echo $user_breakdowns['acknowledge']; ?></td>
                        <td><?php echo $user_breakdowns['aknowlwdge_by']; ?></td>
                       
                        <td><?php if(!empty($user_breakdowns['assign_worker'])){ 
                           $workers = array();
                           $workers = getNameById('worker',$user_breakdowns['assign_worker'],'id');
                           	echo isset($workers->name)?$workers->name:''; } ?></td>
                        <td class='hidde'>
                        <button id="<?php echo $user_breakdowns['id']; ?>" data-id="addSimilarbreakdown" data-tooltip="Add Similar Breakdown" class="btn btn-xs maintenanceTab add-machine add-simi"> <i class="fa fa-clone" aria-hidden="true"></i></button>			
                        <?php if($can_edit) { 
                           echo '<button id="'.$user_breakdowns['id'].'" data-id="editbreakdown" data-tooltip="Edit" class="btn btn-edit btn-xs maintenanceTab" data-toggle="modal"><i class="fa fa-pencil"></i></button>';
                           }
                           
                           echo '<button id="'.$user_breakdowns['id'].'" data-tooltip="View" class="btn btn-view btn-xs maintenanceTab" data-id="viewbreakdown"><i class="fa fa-eye"></i></button>';
                           
                           if($can_delete){
                           		echo '<a href="javascript:void(0)" data-tooltip="Delete" data-id="deletebreakdown" class="delete_listing btn btn-delete btn-xs" data-href="'.base_url().'maintenance/deletemaintenance/'.$user_breakdowns['id'].'"><i class="fa fa-trash"></i></a>';
                           }	
                              
                           ?>
                        <button id="<?php echo $user_breakdowns['id']; ?>" data-id="acknowledgedate" data-tooltip="Acknowledge" class="btn btn-xs maintenanceTab add-machine add-simi"> <i class="fa fa-calendar" aria-hidden="true"></i></button>
                        <button id="<?php echo $user_breakdowns['id']; ?>" data-id="purchase" data-tooltip="Purchase" class="btn btn-xs maintenanceTab add-machine btn-view"> <i class="fa fa-shopping-cart" aria-hidden="true"></i></button>
                        <button id="<?php echo $user_breakdowns['id']; ?>" data-id="completedbreakdown" data-tooltip="complete" class="btn btn-xs maintenanceTab add-machine btn-edit"> <i class="fa fa-check" aria-hidden="true"></i></button>
                        </td>
                     </tr>
                     <?php 
                        @$output[] = array(
                           'ID' => $user_breakdowns['id'],
                           'Purchase Id' => $user_breakdowns['machine_name'],
                           'Machine Name' => $user_breakdowns['machine_code'],
                           'Breakdown Causes' => $user_breakdowns['breakdown_couses'],
                           'Machine Type' =>  $user_breakdowns['machine_type'],
                           'Priority' => $user_breakdowns['priority'],
                           'Request User' => $user_breakdowns['requested_by'],
                           'Acknowledge Date' => $user_breakdowns['acknowledge'],
                           'Acknowledge By' => $user_breakdowns['aknowlwdge_by'],
                           
                        );	
                        }
                        $data3  = $output;
                        export_csv_excel($data3); 
                        }
                        
                        
                        ?>
                  </tbody>
               </table>
               <?php //echo $this->pagination->create_links(); ?>
            </div>
         </div>
      </div>
      <!----------complete tab--------->
      <div role="tabpanel" class="tab-pane fade" id="Complete_content_tab" aria-labelledby="complete_tab">
      <div class="x_content">
      <div class="row hidde_cls export_div">
      <div class="col-md-12">
      
      <div class="btn-group"  role="group" aria-label="Basic example">
      <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
      <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
      <input type="hidden" value='add_bd_request' id="table" data-msg="Breakdown" data-path="maintenance/breakdown"/>
      <button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
      <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
      <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
      <ul class="dropdown-menu" role="menu" id="export-menu">
      <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
      <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
      </ul>
      </div>
      <form action="<?php echo base_url(); ?>maintenance/breakdown" method="post" >
      <input type="hidden" value='1' name='favourites'/>
      <input type="hidden" value='<?php if(!empty($_POST['start'])){echo $_POST['start'];}?>' class='start' name='start'/>
      <input type="hidden" value='<?php if(!empty($_POST['end'])){echo $_POST['end'];} ?>' class='end' name='end'/>
      <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
      </form>
      </div>
      <div class="col-md-3 col-xs-12 col-md-12 datePick-right">
      <form action="<?php echo site_url(); ?>maintenance/breakdown" method="post" id="export-form">
      <input type="hidden" value='' id='hidden-type' name='ExportType'/>
      <input type="hidden" value='' class='start_date' name='start'/>
      <input type="hidden" value='' class='end_date' name='end'/>
      </form>
      </div>
      </div>
      </div>
      <p class="text-muted font-13 m-b-30"></p>    
      <div id="print_div_content" class="table-responsive">	
	  <div class="form-search2">
			<div class="col-md-9">
      <form class="form-search" method="post" action="<?= base_url() ?>maintenance/breakdown">
      <div class="col-md-6">
      <div class="input-group">
      <span class="input-group-addon">
      <i class="ace-icon fa fa-check"></i>
      </span>
      <input type="text" class="form-control search-query" placeholder="Enter id,Breakdown Name,Breakdown Type" name="search" id="search" value="<?php if(!empty($_POST['search'])) echo $_POST['search'];?>">
      <span class="input-group-btn">
      <button type="submit" class="btn btn-purple btn-sm">
      <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
      Search
      </button>
      </span>
      </div>
      </div>
      </form>	
      <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>maintenance/breakdown">
      <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
      </form>
	  </div>
	  <div class="col-md-3 col-xs-12 col-sm-12 datepicker">
      <fieldset>
      <div class="control-group">
      <div class="controls">
      <div class="input-prepend input-group">
      <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
      <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="maintenance/breakdown"/>
      </div>
      </div>
      </div>
      </fieldset>
      <form action="<?php echo base_url(); ?>maintenance/breakdown" method="post" id="date_range">	
      <input type="hidden" value='' class='start_date' name='start'/>
      <input type="hidden" value='' class='end_date' name='end'/>
      </form>
      </div>
	  </div>
      <input type="hidden" id="visible_row" value=""/>
      <!------------------ datatable-buttons -------------->
      <table id="" class="table table-striped  table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>				
      <thead>
      <tr>
      <th></th>
      <th>Id</th>
      <th>Ref.Id</th>
      <th>Machine Name</th>
      <th>Breakdown Causes</th>
      <th>Machine Type</th>
      <th>Priority</th>
      <th>Request user</th>
      <th>Created Date</th>
                        <th>Created By</th>
      <th>Acknowledge Date</th>
      <th>Acknowledge By</th>
      <th>Worker Assign</th>
      <th>Connective Entry</th>
      <th>Action</th>
      </tr>
      </tr>
      </thead>
      <tbody>
      <?php  if(!empty($user_breakdown_complete)){ ?>
      <?foreach($user_breakdown_complete as $user_breakdown_compkey => $user_breakdown_completes){ ?>
      <tr>
      <td>
      <?php if($user_breakdown_completes['favourite_sts'] == '1'){
         echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$user_breakdown_completes['id']."  checked = 'checked'>";
         echo"<input type='hidden' value='add_bd_request' id='favr' data-msg='Breakdown ' data-path='maintenance/breakdown' favour-sts='0' id-recd=".$user_breakdown_completes['id'].">";
         }else{
         echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$user_breakdown_completes['id'].">";
         echo"<input type='hidden' value='add_bd_request' id='favr' data-msg='Breakdown ' data-path='maintenance/breakdown' favour-sts='1' id-recd =".$user_breakdown_completes['id'].">";
         }
         $createdBYY =  getNameById('user_detail', $user_breakdown_completes['created_by'],'u_id');
						$crtd_by_name = !empty($createdBYY)?$createdBYY->name:'Others';	
         
         ?>  
      </td>
      <td><?php echo $user_breakdown_completes['id']; ?></td>
      <td>
      <?php if(!empty($user_breakdown_completes['purchase_id'])){ ?>
      <button id="<?php echo $user_breakdown_completes['purchase_id']; ?>" data-tooltip="View" class="btn btn-xs maintenanceTab" data-id="viewpurchase"><?php echo $user_breakdown_completes['purchase_id']; ?></button></td> <?php } ?>  
      <!--<td><?php //echo $addMachine['machine_name']; ?></td>-->
	  	<?php $machine = array();
			$machine = getNameById('add_machine', $user_breakdown_completes['machine_id'],'id');
			?>

			<td>
			   <a href="javascript:void(0)" id="<?php echo $user_breakdown_completes['id']; ?>" data-id="machineView" class="maintenanceTab">
				  <?php echo !empty($machine->machine_name)?$machine->machine_name:$user_breakdown_completes['machine_name']; ?>
			</td>
      <td><?php echo $user_breakdown_completes['breakdown_couses']; ?></td>
      <td><?php echo $user_breakdown_completes['machine_type']; ?></td>
      <td><?php echo $user_breakdown_completes['priority']; ?></td>
      <td><?php echo $user_breakdown_completes['requested_by']; ?></td>
       <td><?php echo date("j F , Y", strtotime($user_breakdown_completes['created_date'])) ?></td>
       <td><?php echo $crtd_by_name; ?></td>
      <td><?php echo $user_breakdown_completes['acknowledge']; ?></td>
      <td><?php echo $user_breakdown_completes['aknowlwdge_by']; ?></td>
      <td><?php if(!empty($user_breakdown_completes['assign_worker'])){ 
         $workers = array();
         $workers = getNameById('worker',$user_breakdown_completes['assign_worker'],'id');
         echo isset($workers->name)?$workers->name:''; } ?></td>
      <td><?php echo $user_breakdown_completes['conective_entry']; ?></td>
      <td class='hidde'>
      <!---<button id="<?php echo $user_breakdown_completes['id']; ?>" data-id="addSimilarbreakdown" data-tooltip="Add Similar Breakdown" class="btn btn-xs maintenanceTab add-machine"> <i class="fa fa-clone" aria-hidden="true"></i></button>---->			
      <?php //if($can_edit) { 
         //echo '<button id="'.$user_breakdown_completes['id'].'" data-id="editbreakdown" data-tooltip="Edit" class="btn btn-edit btn-xs maintenanceTab" data-toggle="modal"><i class="fa fa-pencil"></i></button>';
         //}
         
         echo '<button id="'.$user_breakdown_completes['id'].'" data-tooltip="View" class="btn btn-view btn-xs maintenanceTab" data-id="viewbreakdowncom"><i class="fa fa-eye"></i></button>';
         
         //if($can_delete){
         	   
         		//echo '<a href="javascript:void(0)" data-tooltip="Delete" data-id="deletebreakdown" class="delete_listing
                            //btn btn-delete btn-xs" data-href="'.base_url().'maintenance/deletemaintenance/'.$user_breakdown_completes['id'].'"><i class="fa fa-trash"></i></a>';
         //}	
            
         ?>
      <!---<button id="<?php echo $user_breakdown_completes['id']; ?>" data-id="acknowledgedate" data-tooltip="Acknowledge" class="btn btn-xs maintenanceTab add-machine"> <i class="fa fa-calendar" aria-hidden="true"></i></button>
         <button id="<?php echo $user_breakdown_completes['id']; ?>" data-id="purchase" data-tooltip="Purchase" class="btn btn-xs maintenanceTab add-machine"> <i class="fa fa-shopping-cart" aria-hidden="true"></i></button>
         
         <button id="<?php echo $user_breakdown_completes['id']; ?>" data-id="completedbreakdown" data-tooltip="complete" class="btn btn-xs maintenanceTab add-machine"> <i class="fa fa-check" aria-hidden="true"></i></button>------>
      </td>
      </tr>
      <?php 
         @$output[] = array(
            'ID' => $user_breakdown_completes['id'],
            'Purchase Id' => $user_breakdown_completes['machine_name'],
            'Machine Name' => $user_breakdown_completes['machine_code'],
            'Breakdown Causes' => $user_breakdown_completes['breakdown_couses'],
            'Machine Type' =>  $user_breakdown_completes['machine_type'],
            'Priority' => $user_breakdown_completes['priority'],
            'Request User' => $user_breakdown_completes['requested_by'],
            'Acknowledge Date' => $user_breakdown_completes['acknowledge'],
            'Acknowledge By' => $user_breakdown_completes['aknowlwdge_by'],
            
         );	
         }
         $data3  = $output;
         export_csv_excel($data3); 
         
         }
         
         
         ?>
      </tbody>  
      </table><?php //echo $this->pagination->create_links(); ?>
      </div>
      </div>
      </div>
      <div id="maintenance_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
         <div class="modal-dialog modal-large">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel">Breakdown Details</h4>
               </div>
               <div class="modal-body-content"></div>
            </div>
         </div>
      </div>
   </div>
</div>
<style>
.form-search2 {
    position: absolute;
    top: -128px;
    right: 0;
}
.export_div{top:-76px;}
#myTab {
    margin-top: 44px;
}
.form-search2 .datepicker {padding-top: 0px;
    width: 243px;
    float: right;
}
.form-search2 .col-md-9 {
    width: 570px;
}
</style>