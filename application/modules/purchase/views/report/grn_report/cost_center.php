 <?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-info">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }
   setlocale(LC_MONETARY, 'en_IN');
   ?>

<div class="x_content">
   <div class="row hidde_cls stik purchaseReportCss">
        <div class="col-md-12 col-sm-12 for-mobile">
         
      <div class="Filter Filter-btn2">
         <form class="form-search" method="GET" action="">
            <div class="col-md-6">
               <!-- <?php 
                  if( !empty($_GET['start']) && !empty($_GET['end']) ){
                     $start = date('01 M Y',strtotime($_GET['start']));
                     $end = date('t M Y',strtotime($_GET['end']));
                  }else{
                     $start = date('01 M Y'); $end = date('t M Y');
                  }
               ?>
               <p><b><?= $start ?> TO <?= $end ?></b></p> -->
               <div class="input-group" style="float: right;">
                  <a href="<?php echo base_url(); ?>purchase/purchase_report/cost_center_report"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
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
                           <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control disbled_cls" value="" data-table="purchase/suppliers">
                        </div>
                     </div>
                  </div>
               </fieldset>
               <form action="<?= base_url() ?>purchase/purchase_report/cost_center_report" method="GET" >
               	<input type="hidden" name="start" class="start_date">
               	<input type="hidden" name="end" class="end_date">
                  <div class="row hidde_cls filter1 progress_filter">
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
                        <?= table_th(['Cost Center','Total Amount']); ?>
                        <tbody>
                           <?php
                              if($cost_center){
                                 foreach ($cost_center as $key => $value) { ?>
                                    <tr>
                                       <td><?= ucfirst($value['cost_center_name']) ?></td>
                                       <td><?= $value['total_amount']??0; ?></td>
                                    </tr>
                           <?php } 
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