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
         <form class="form-search" method="GET" action="">
            <div class="col-md-6">
               <div class="input-group" style="float: right;">
                  <a href="<?php echo base_url(); ?>purchase/purchase_report/monitor_supplier_confirmation_report"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
               </div>
            </div>
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
               <form action="<?= base_url() ?>purchase/purchase_report/monitor_supplier_confirmation_report" method="GET" >
                  <div class="row hidde_cls filter1 progress_filter">
                     <div class="btn-group"  role="group" aria-label="Basic example">
                        <select class="form-control supp_name disbled_cls commanSelect2" name="supplier" >
                           <?= $supplier ?>
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
                     <?php $baseUrl = base_url('/purchase/purchase_report/monitor_supplier_confirmation_report?rating_sort'); 
                           $sortHtml = "<span>
                                             <a href='{$baseUrl}=asc' class='up'></a>
                                             <a href='{$baseUrl}=desc' class='down'></a>
                                       </span>";

                     ?>
                        <?= table_th(['width:200px;'=>'Supplier Code','Supplier Name','Material Code','width:130px;'=>"Rating {$sortHtml}"]); ?>
                        <tbody>
                           <?php 
                              if( $poAnalysis ){
                                 foreach ($poAnalysis as $grnKey => $grnValue) {
                                     ?>
                                       <tr>
                                          <td class="supplierCode tdTextCenter tdTextLeft" >
                                             <span>
                                                <a href="javascript:void(0)" class="add_purchase_tabs" ata-toggle="modal" data-id="SupplierView" id="<?= $grnValue['spId'] ?>"><?= $grnValue['supplier_code'] ?></a>
                                             </span>
                                          </td>

                                          <td>
                                             <p><?= $grnValue['supplier_name'] ?></p>
                                          </td>
                                          <td class=" tdTextCenter">
                                             <p>
                                                   <?php $mData = array_unique($grnValue['material_code']); ?>
                                                   <?= implode(" || ", $mData ); ?>
                                             </p>
                                          </td>
                                          <td> 
                                          <?php 
                                             
                                             $starRating = $grnValue['mrndetails']['rating']??'nan';
                                             if( $starRating == 'nan' ){
                                                 $starRating = 0;
                                             }
                                             $starShow = round($starRating);
                                             for ($i=1; $i <= 5; $i++) { 
                                                if( $starShow >= $i ){
                                                   echo '<i class="fa fa-star" style="color:#c5aa1a;"></i>';
                                                }else{
                                                   echo '<i class="fa fa-star"></i>';
                                                }
                                             }
                                             
                                          ?> 
                                          </td>
                                             
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