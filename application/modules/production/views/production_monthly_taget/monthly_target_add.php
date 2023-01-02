<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css" type="text/css" />
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }  //pre($production_report);die;?>
<script>		
   var logged_user = <?php echo $_SESSION['loggedInUser']->c_id; ?>;		
</script>
<form method="post"  class="form-horizontal" name="frmProductionReportDataTable" action="<?php echo base_url(); ?>production/saveMonthlyProuction" enctype="multipart/form-data" id="frm-ProductionReportDataTable" novalidate="novalidate">

<input type="hidden" name="logged_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">	
<input type="hidden" name="id" value="<?php echo $production_report->id; ?>" class="productionId">	
<div class="col-md-12 col-sm-12  ">
   <div class="x_panel">
      <div class="x_title">
         <h2><i class="fa fa-search"></i> Advaced Search</h2>
         <div class="clearfix"></div>
      </div>
      <div class="x_content">
         <div class="col-md-12 ">
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                     <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 compny_unit" required="required" name="company_branch" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
                        <option value="">Select Unit</option>
						  <?php
							  if(!empty($production_report)){
								$getUnitName = getNameById('company_address',$production_report->company_branch,'compny_branch_id');
								echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
							  }
							  ?>
                     </select>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12">Department</label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="department_id"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid =<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = '<?php echo (!empty($production_report))?$production_report->company_branch:''; ?>'" >
                        <option value="">Select Option</option>
							 <?php
							  if(!empty($production_report)){
								$departmentData = getNameById('department',$production_report->department_id,'id');
								if(!empty($departmentData)){
									echo '<option value="'.$departmentData->id.'" selected>'.$departmentData->name.'</option>';
								}
							  }
							 ?>
                     </select>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12">Month</label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                     <input  required="required"  type="text" id="month" name="month" class="monthPicker date-picker form-control Selectedmonth" value="<?php  if(!empty($production_report)){ echo $production_report->month; } ?>"/>
                  </div>
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="item form-group">
                  <div class="col-md-8 col-sm-12 col-xs-12">
                     <button type="button" class="btn btn-round btn-success btn-lg" name="SearchButton" id="SearchButton"> Search</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div id="result"></div>
<div class="x_content">
   <p class="text-muted font-13 m-b-30"></p>
      <div id="print_div_content" class="table-responsive" style="clear: both;">
         <table id="ProductionReportDataTable" class="table table-striped  table-bordered user_index display" border="1" cellpadding="3" style="width:100%">
            <thead>
               <tr class="headings">
                  <th class="column-title">Priority</th>
                  <th class="column-title">ID</th>
                  <th class="column-title">Work Order Name</th>
                  <th class="column-title">Sale Order</th>
                  <th class="column-title">Customer Name</th>
                  <!--<th>Work Order Qty </th>
                     <th>Production Qty</th>
                     <th>Expected Date</th>-->
                  <!--<th class='hidde'>Action</th>-->
                  <th class="column-title">
                     <input type="checkbox" name="select_all" value="1" id="ProductionReportDataTable-select-all"  class="flat" >
                  </th>
               </tr>
            </thead>
         </table>
      </div>
      <div class="form-group col-md-12">
         <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="item form-group">
               <div class="col-md-8 col-sm-12 col-xs-12">
               </div>
            </div>
         </div>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="item form-group">
               <div class="col-md-8 col-sm-12 col-xs-12">
                  <button type="submit" class="btn btn-primary btn-lg" >Submit</button>
               </div>
            </div>
         </div>
      </div>
 
</div>
  </form>

  