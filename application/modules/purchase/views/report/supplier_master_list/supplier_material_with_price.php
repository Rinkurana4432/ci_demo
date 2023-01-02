 
<style type="text/css">
   td.materialTypeReport span {
       position: absolute;
       top: 33%;
   }

   td.materialTypeReport,td.materialNameReport {
       position: relative;
   }

   td.materialNameReport span {
       position: absolute;
       top: 33%;
   }
   .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #968a8a !important;
   }
</style>

<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-info">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }
   setlocale(LC_MONETARY, 'en_IN');
   ?>
<div class="x_content">
   <div class="row hidde_cls stik">
        <div class="col-md-12 col-sm-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form action="<?php echo site_url(); ?>purchase/suppliers" method="GET" id="export-form" style="visibility: hidden;">
            <input type="hidden" value='' id='hidden-type' name='ExportType'/>
            <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
            <input type="hidden" value='' class='start_date' name='start'/>
            <input type="hidden" value='' class='end_date' name='end'/> 
            <input type="hidden" value='<?php echo $_GET['start']; ?>'  class='start_date' name='start'/>
            <input type="hidden" value='<?php echo $_GET['favourites']; ?>' name="favourites"/>
            <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
            <input type="hidden" value='<?php echo $_GET['search']; ?>' name="search"/>
         </form>
         <form class="form-search" method="GET" action="<?= base_url() ?>purchase/suppliers">
            <div class="col-md-6">
               <div class="input-group" style="float: right;">
                  <a href="<?php echo base_url(); ?>purchase/purchase_report/supplier_material"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
               </div>
            </div>
         </form>
         <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>purchase/suppliers">
            <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])=='' || $_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
            <input type="hidden" name="url" id="url" value="<?php echo $this->uri->segment(3);?>" />
         </form>
         <button style="margin-right: 0px !important;" type="button" class="btn btn-primary collapsed" data-toggle="collapse" data-target="#demo" aria-expanded="false"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         <div id="demo" class="collapse" aria-expanded="false" style="height: 2px;">
            <div class="col-md-12  col-xs-12 col-sm-12 datePick-left">
               <fieldset>
                  <div class="control-group">
                     <div class="controls">
                        <div class="input-prepend input-group" style="visibility: hidden;">
                           <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" style="width: 200px" name="tabbingFilters" class="form-control daterange" value="" data-table="purchase/suppliers">
                        </div>
                     </div>
                  </div>
               </fieldset>
               <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
               <form action="<?= base_url() ?>purchase/purchase_report/supplier_material" method="GET" >
                  <div class="row hidde_cls filter1 progress_filter">
                   <div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
                        <select class="form-control commanSelect2" name="supplier">
                              <?= $supplier; ?> 
                        </select>
                     </div>
                     <div class="col-md-12 col-xs-12 well" id="chkIndex_1" style="padding:0;margin-bottom:0;background-color:transparent;border:none;">
                        <div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId" name="material_type" data-id="material_type" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true" placeholder="Select Material"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0" onchange="getMaterialName(event,this)">
                              <option value="">Select Material</option>
                           </select>
                        </div>
                        <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
                           <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name Add_mat_onthe_spot" id="mat_name"  name="material_name">
                              <option value="">Select Material Name</option>
                           </select>
                        </div>
                        <input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="purchase/purchase_indent" disabled="disabled">
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   </div>
   <p class="text-muted font-13 m-b-30"></p>
   <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id; ?>">
   <div role="tabpanel" data-example-id="togglable-tabs">
      <div id="myTabContent" class="tab-content">
         <div role="tabpanel" class="tab-pane fade active in" id="in_progress_tab" aria-labelledby="complete_tab">
            <p class="text-muted font-13 m-b-30"></p>
            <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>"> 
            <form id="mrninprocess_form"><input type="hidden" value="inprocess" name="tab"></form>
            <div id="print_div_content">
               <div class="table-responsive">
                  <table id="" style="width:100%;" class="table  table-bordered inprocess_div" data-id="user"  border="1" cellpadding="2" >
                        <?= table_th(['Material Type','Material Name','Suppliers','Price']); ?>
                        <tbody>
                           <?php 
                              if( $supplierMaterialName ){
                                 // pre($supplierMaterialName);
                                 $i = 1;
                                 foreach ($supplierMaterialName as $firstKey => $firstValue) {
                                    foreach ($firstValue['supplier'] as $secondKey => $secondValue) { ?>
                                                <tr>
                                                   <td class="materialTypeReport"><span><?= $secondValue['material_type_name']; ?></span></td>
                                                   <td class="materialNameReport"><span><?= $secondValue['material_name']; ?></span></td>

                                                   
                                                   <td> <a href="javascript:void(0)" data-tooltip="View" class="btn btn-view btn-xs add_purchase_tabs" ata-toggle="modal" data-id="SupplierView" id="<?= $secondValue['supplier_id'] ?>"><?= $secondValue['supplier_name'] ?></a>
                                                   </td>
                                                   <td><?= $secondValue['price'] ?></td>
                                                </tr>
                                    <?php }
                                    
                                 }
                              }

                           ?>
                        </tbody>
                  </table>
                  <?php //echo $this->pagination->create_links(); ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php //echo $this->pagination->create_links(); ?>
<div id="printView">
   <div id="purchase_add_modal" class="modal fade in" role="dialog" style="overflow:auto;">
      <div class="modal-dialog modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title add_title" id="myModalLabel">Report</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>
<?php $this->load->view('common_modal'); ?>