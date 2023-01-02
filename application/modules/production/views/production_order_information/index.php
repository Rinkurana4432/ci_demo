<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php } ?>
<div class="x_content">
   <div class="stik">
      <div class="col-md-12 ">
         <div class="col-md-6 datePick-right">
            <form action="<?php echo site_url(); ?>production/production_material_order_report" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType'/>
               <input type="hidden" value='<?php if($_GET['start'])echo $_GET['start'];?>' class='start_date' name='start'/>
               <input type="hidden" value='<?php if($_GET['end'])echo $_GET['end'];?>' class='end_date' name='end'/>
               <input type="hidden" value='<?php if($_GET['search'])echo $_GET['search'];?>' name='search'/>
            </form>
         </div>
      </div>
   </div>
<div class="col-md-12 col-xs-12 for-mobile">
 <div class="Filter Filter-btn2">
     <form class="form-search " method="get" action="<?= base_url() ?>production/production_material_order_report" >
         <div class="col-md-6">
            <div class="input-group">
               <span class="input-group-addon">
               <i class="ace-icon fa fa-check"></i>
               </span>
               <input type="text" class="form-control search-query" placeholder="Enter Workorder Number" name="search" value="<?php if(!empty($_GET['search'])) echo $_GET['search'];?>" data-ctrl="production/production_material_order_report">
               <span class="input-group-btn">
               <button type="submit" class="btn btn-purple btn-sm">
               <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
               Search
               </button>
               <a href="<?php echo base_url(); ?>production/production_material_order_report"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
               </span>
            </div>
         </div>
      </form>
	  
     <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         <div id="demo" class="collapse">
      <div class="col-md-2 col-xs-12">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="production/sale_order_with_production"/>
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>production/production_material_order_report" method="get" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
	 </div>
 </div>
   <div class="row hidde_cls ">
      <div class="col-md-12 export_div">
         <div class="btn-group"  role="group" aria-label="Basic example">
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
            <input type="hidden" value='work_order' id="table" data-msg="Work Order" data-path="production/work_order"/>
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div>
         </div>
         <div class="col-md-3 col-xs-12 datePick-right">
            <?php //if($can_add) { 										
               // echo '<button type="buttton" class="btn btn-info productionTab addBtn" id="ProductionReportAdd" data-toggle="modal" data-id="ProductionReportAdd">Add</button>';
                //}?>
         </div>
      </div>
   </div>
</div>
   <p class="text-muted font-13 m-b-30"></p>
   <div id="print_div_content" style="margin-top:58px;" class="table-responsive">
     
      <table class="table table-striped  table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
         <thead>
            <tr>
               <th scope="col">Sr no.</th>
               <th scope="col">Material Name</th>
               <th scope="col">Work Order Number<span><a href="<?php echo base_url(); ?>production/production_material_order_report?sort=asc" class="up"></a><a href="<?php echo base_url(); ?>production/production_material_order_report?sort=desc" class="down"></a></span></th>
               <th scope="col">Required Quantity</th>
               <th scope="col">Produced Quantity</th>
               <th scope="col">Plant</th>
               <th scope="col">Created Date</th>
            </tr>
         </thead>
         <tbody>
            <?php if(!empty($work_order_materials)){
                     foreach($work_order_materials as $ProductionReport){
                        $materialName   = getNameById('material',$ProductionReport['material_id'],'id');
                        $companyDetail  = getNameById('company_address',$ProductionReport['company_branch_id'],'compny_branch_id');
            ?>
            <tr>
               <td><?php    echo $ProductionReport['id']; ?></td>     
               <td><?php    if(!empty($materialName)){echo $materialName->material_name;}else{echo "N/A";} ?></td>
               <td><?php    echo $ProductionReport['work_order_no']; ?></td>
               <td><?php    echo $ProductionReport['transfer_quantity']; ?></td>
               <td><?php    echo $ProductionReport['produced_quantity']; ?></td>
               <td><?php    if(!empty($companyDetail)){echo $companyDetail->company_unit;}else{echo "N/A";} ?></td>
               <td><?php    echo date("j F , Y", strtotime($ProductionReport['created_date'])); ?></td>
            </tr>
            <?php  } } ?>
         </tbody>
      </table>
      
      <?php echo $pagination_links; ?>	
   </div>
</div>