
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }?>
<div class="x_content">
 <div class="col-md-12 col-xs-12 for-mobile">
       <div class="Filter Filter-btn2">
          <form class="form-search" method="post" action="<?= base_url() ?>quality_control/day_line_wise_inspection">
             <div class="col-md-6">
              <!--  <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter id,Product Name,Product Type" name="search" id="search" data-ctrl="quality_control/day_line_wise_inspection" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  
                  </span>
               </div> --> 
            </div> 
         </form> <a href="<?php echo base_url(); ?>quality_control/day_line_wise_inspection"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
         <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>quality_control/day_line_wise_inspection">
            <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
         </form>
       <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
          <div id="demo" class="collapse">
       <div class="col-md-4 col-xs-12 col-sm-6 datePick-left">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="quality_control/day_line_wise_inspection">
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>quality_control/day_line_wise_inspection" method="get" id="date_range"> <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'] ;} ?>' class='start_date' name='start'/>
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'] ;} ?>' class='end_date' name='end'/>
            </form>
         </div>
        <ul style="padding: 0px; text-align: center;">
                  <li id="export-to-excel">
                     <form action="<?php echo base_url(); ?>quality_control/day_line_wise_inspection" method="get" >
                        <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start'/>
                        <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end'/>
                        <div >
                           <div class="col-md-12">
                              <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
        <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 "   name="company_branch" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>"  onChange="getDept(event,this)" title="Select Department">
                                     <span>Select Department</span>
                                 </select>
                              </div>
                           <!-- <div class="btn-group  "  role="group" aria-label="Basic example" >
                                 <select class="form-control  status  " name="status"  >
                                    <option> </option>
                                     <option value="Inactive">In-active</option>
                                      <option value="Active">Active</option>
                                 </select>
                              </div> -->
                                  
                             
                              <input type="submit" value="Filter" class="btn filterBtn filt1"  >
                           </div>
                        </div>
                     </form>
                  </li>
               </ul>
       </div>
      </div>
      <div class="row hidde_cls export_div">
         <div class="col-md-12">
            <div class="btn-group"  role="group" aria-label="Basic example">
            
               <!-- <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>-->
               <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button> 
               <input type="hidden" value='add_machine' id="table" data-msg="Machine" data-path="production/Add_machine"/>              
               <!-- <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                  <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu" id="export-menu">
                     <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                     <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                  </ul>
               </div> -->  
               <form action="<?php echo base_url(); ?>quality_control/day_line_wise_inspection" method="get" >
                  <input type="hidden" value='1' name='favourites'/>
                  <input type="hidden" value='' class='start' name='start'/>
                  <input type="hidden" value='' class='end' name='end'/>
                  <!-- <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button> -->
               </form>
            </div>
            <div class="col-md-3 col-xs-12 col-md-12 datePick-right">
               <?php //if($can_add){ echo '<button class="btn btn-primary productionTab addBtn" data-toggle="modal" id="add1" data-id="machineEditNew">Add New</button>'; }?>          
               <form action="<?php echo site_url(); ?>quality_control/day_line_wise_inspection" method="get" id="export-form">
                  <input type="hidden" value='' id='hidden-type' name='ExportType'/>
                  <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
                  <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
                  <input type="hidden" value='<?php echo $_GET['favourites'];?>' name='favourites'/>
                  <input type="hidden" value='<?php echo $_GET['search'];?>' name='search'/>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div id="myTabContent">
      <p class="text-muted font-13 m-b-30"></p>
      <div id="print_div_content" class="table-responsive" style="margin-top: 58px;">
         <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>quality_control/day_line_wise_inspection">
            <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
         </form>
         <!------------------ datatable-buttons -------------->
         <table id="" class="table table-striped  table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
            <thead>
             <tr> 
                   <th>Machine Name</th>
                   <th scope="col">  </th>
                  <th scope="col"> </th>
                   <th scope="col"> </th>
                   <th scope="col"> </th>
                   <th scope="col"> </th>  
                   <th></th>
                   <th></th>
                   <th></th>
               </tr>
               <tr>  
                    <th></th>
                   <th>ID</th>
                   <th scope="col">Work Order </th>
                  <th scope="col">Product</th>
                   <th scope="col">Process</th>
                   <th scope="col">Plant Name</th>
                   <th scope="col">Date </th> 
                   <th scope="col">Shift </th> 
                    <th scope="col" style="width: 150px;">Result  </th> 
               </tr> 
            </thead>
            <tbody>
   <?php  
if(!empty($AddMachine)){ 
   
 foreach($AddMachine as $key =>$addMac){ 
   $machine_id = getNameById('add_machine',$key,'id');
    
  ?> 

                 <tr>
                   <td><b><?=@$machine_id->machine_name;?></b></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                </tr>
              <?php foreach ($addMac as $addMacvalue) {  
                  $add_process = getNameById('add_process',$addMacvalue['process_id'],'id');
                  $work_order = getNameById('work_order',$addMacvalue['workorder_id'],'id');
                  $process_type= getNameById('process_type',$add_process->process_type_id,'id');
                $production_setting = getNameById('production_setting',$addMacvalue['department_id'],'department'); 
                 
                  $company_branch = getNameById('company_address',$addMacvalue['company_branch'],'compny_branch_id'); ?>
                <tr>
                   <td></td>
                   <td><?=@$addMacvalue['id']?></td>
                   <td><?=@$work_order->workorder_name;?></td>
                   <td><?=@$process_type->process_type;?></td>
                   <td><?=@$add_process->process_name;?></td>
                   <td><?php echo $company_branch->company_unit; ?></td>
                   <td><?php echo date("d-m-Y",strtotime($addMacvalue['created_date']));?></td>
                   <td> <?php if ($addMacvalue['shift']==$production_setting->id){  
                              echo $production_setting->shift_name;
                              }?></td>
                   <td><?php if ($addMacvalue['final_report']==1) {   ?>

                      <button type="button" data-id="ViewInspectionReport" data-tooltip="View"  class="btn btn-view btn-xs qualityTab  " data-toggle="modal"   id="<?php echo $addMacvalue['id'];?>" jobCard="<?= @$addMacvalue['job_card']??'' ?>" processId="<?= @$addMacvalue['process_id']; ?>" machineId="<?= @$addMacvalue['machine_id']; ?>" >Pass</button>
                  
                    <?php  }elseif ($addMacvalue['final_report']==2) { ?>
                   <button type="button" data-id="ViewInspectionReport" data-tooltip="View"  class="btn btn-view btn-xs qualityTab  " data-toggle="modal" id="<?php echo $addMacvalue['id'];?>" jobCard="<?= @$addMacvalue['job_card']??'' ?>" processId="<?= @$addMacvalue['process_id']; ?>" machineId="<?= @$addMacvalue['machine_id']; ?>" >Fail</button>
 
                    <?php  } ?></td> 
                </tr>
        


         <?php } } } ?>  
            </tbody>
         </table> 
       <div id="quality_modal" class="modal fade in" role="dialog">
      <div class="modal-dialog modal-lg modal-large">
        <div class="modal-content" style="display:table;">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Instrument Details</h4>
          </div>
          <div class="modal-body-content"></div>
        </div>
      </div>
    </div>
