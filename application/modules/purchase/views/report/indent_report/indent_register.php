 <style type="text/css">
   td.tdTextCenter {
       position: relative;
   }

   td.tdTextCenter span {
       position: absolute;
       top: 33%;
   }
   .table-responsive{
      height: 700px;
   }
   td.tdTextLeft{
      left: 0%;
   }
   .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #968a8a !important;
   }
   .indentDetails h4{
      margin-left: 10px;
   }
</style>
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-info">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }
   setlocale(LC_MONETARY, 'en_IN');
   ?>
<div class="indentDetails" style="display:inline-flex;">
   <h4><?= 'Total Indent : '.$poAnalysis['total']??00; ?></h4>
   <h4><?= 'In Progress : '.$poAnalysis['in_progress']??00; ?></h4>
   <h4><?= 'Complete : '.$poAnalysis['complete']??00; ?></h4>
   <h4><?= 'Convert to PO : '.$poAnalysis['conevrt_to_po']??00; ?></h4>
   <h4><?= 'Convert to GRN : '.$poAnalysis['conevrt_to_grn']??00; ?></h4>
   <h4><?= 'Convert to PO Pending : '.$poAnalysis['po_pending']??00; ?></h4>
   <h4><?= 'Convert to GRN Pending : '.$poAnalysis['grn_pending']??00; ?></h4>
</div>

<div class="x_content">
   <div class="row hidde_cls stik">
        <div class="col-md-12 col-sm-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="GET" action="">
            <div class="col-md-6">
               <div class="input-group" style="float: right;">
                  <a href="<?php echo base_url(); ?>purchase/purchase_report/indent_register"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
               </div>
            </div>
         </form>
         <button style="margin-right: 0px !important;" type="button" class="btn btn-primary collapsed" data-toggle="collapse" data-target="#demo" aria-expanded="false"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         <div id="demo" class="collapse" aria-expanded="false" style="height: 2px;">
            <div class="col-md-12  col-xs-12 col-sm-12 datePick-left">
               <fieldset>
                  <div class="control-group">
                     <div class="controls">
                        <div class="input-prepend input-group">
                           <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" style="width: 200px" name="tabbingFilters" class="form-control daterange" value="" data-table="purchase/suppliers">
                        </div>
                     </div>
                  </div>
               </fieldset>
               <form action="<?= base_url() ?>purchase/purchase_report/indent_register" method="GET" >
                  <input type="hidden" name="start" id="start_date">
                  <input type="hidden" name="end" id="end_date">
                  <div class="row hidde_cls filter1 progress_filter">
                     <div class="btn-group"  role="group" aria-label="Basic example">
                        <select class="form-control supp_name disbled_cls select_supplier" name="supplier" data-id="supplier" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" >
                           <option value="">Select Supplier</option>
                        </select>
                     </div>
                     <div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
                        <select class="form-control commanSelect2" name="material" >
                           <?= $material; ?>
                        </select>
                     </div>
                     <div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
                        <select class="form-control commanSelect2" name="status_type" >
                           <?= $purchaseStatus; ?>
                        </select>
                     </div>
                     <input type="submit" value="Filter" class="btn filterBtn filt1"  disabled="disabled">
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
                        <?= table_th(['Indent No.','Supplier Code','width: 40em;' => 'Indent Material','Grand Total','Created By','Created Date','Indent Status']); ?>
                        <tbody>
                           <?php

                              if( $poAnalysis ){
                                 unset($poAnalysis['po_pending'],$poAnalysis['grn_pending'],$poAnalysis['conevrt_to_po'],$poAnalysis['conevrt_to_grn'],$poAnalysis['complete'],$poAnalysis['total'],$poAnalysis['in_progress']);
                                 foreach ($poAnalysis as $grnKey => $grnValue) {
                                     ?>
                                       <tr>
                                          <td class="poOrderCode">
                                             <span>
                                                <a href="javascript:void(0)" class="add_purchase_tabs" data-id="indentView" id="<?= $grnValue['id'] ?>"><?= $grnValue['indent_code'] ?></a>
                                             </span>
                                          </td>
                                          <td class="supplierCode tdTextCenter" >
                                             <span>
                                                <a href="javascript:void(0)" class="add_purchase_tabs" ata-toggle="modal" data-id="SupplierView" id="<?= $grnValue['spId'] ?>"><?= $grnValue['supplier_code'] ?></a>
                                             </span>
                                          </td>
                                          <td class="materialCode">
                                             <?= $grnValue['material_name'] ?>
                                          </td>
                                          <td><?= $grnValue['grand_total'] ?></td>
                                          <td><?= getSingleAndWhere('name','user_detail',['u_id' => $grnValue['buyer']]); ?></td>
                                          <td><?= $grnValue['registerDate']; ?></td>
                                          <td><?= $grnValue['status']; ?></td>
                                       </tr>
                              <?php       
                                 }
                              }
                           ?>
                        </tbody>
                  </table>
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