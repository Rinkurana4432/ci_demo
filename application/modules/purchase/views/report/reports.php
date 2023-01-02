 <style type="text/css">
    .mb-2, .my-2 {
       margin-bottom: .5rem!important;
   }
   .input-group {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-box-align: stretch;
    -ms-flex-align: stretch;
    align-items: stretch;
    width: 100%;
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
            <div class="col-md-9">
              <?php if($can_add) { 
                  echo '<button type="buttton" class="btn btn-danger indent" id="delete_data" style="display:none;" data-table="purchase_indent" data-where="id" onclick="return confirm("Press a button!");"><i class="fa fa-trash btnTitle-icon"></i> Delete</button></a>';

                  echo '<button type="buttton" style="margin-right: 0px !important; float: right;" class="btn btn-success add_purchase_tabs" id="" data-tooltip="Add" data-toggle="modal" data-id="purchaseReport" ><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button></a>'; 
               } ?>  
            </div>
            <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>    
            <div id="demo" class="collapse">
               <!-- Filter div Start-->
               <div class="col-md-12  col-sm-12 datePick-left">
                  <fieldset>
                     <div class="control-group">
                        <div class="controls">
                           <div class="input-prepend input-group">
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              <input type="text" style="width: 200px" name="tabbingFilters" class="form-control daterange" value="<?= date('d-m-Y',strtotime($_GET['start'])).' - '.date('d-m-Y',strtotime($_GET['end'])) ?>">
                           </div>
                        </div>
                     </div>
                  </fieldset>
                  <form action="<?php echo base_url(); ?>purchase/mrn" method="GET" id="date_range">  
                     <input type="hidden" value='' class='start_date' name='start'/>
                     <input type="hidden" value='' class='end_date' name='end'/>
                  </form>
               </div>
               <div class="row filter1 Filter_div">
                  <form action="<?php echo base_url(); ?>purchase/order_report" method="GET">
                     <input type="hidden" value='<?php echo $_POST['start']; ?>' class='start_date' id="start_date" name='start'/>
                     <input type="hidden" value='<?php echo $_POST['end']; ?>' class='end_date' id="end_date" name='end'/>
                     <div class="col-md-12">
                        <div class="btn-group"  role="group" aria-label="Basic example" >
                           <select class="form-control" name="report_type" width="100%">
                              <option value="">Select Report Type</option>
                              <option value="pass" <?= ($_GET['report_type'] == 'pass')?'selected':''; ?> >Pass</option>
                              <option value="fail" <?= ($_GET['report_type'] == 'fail')?'selected':''; ?>>Fail</option>
                           </select>
                        </div>
                        <input type="submit" value="Filter" class="btn filt1">
                     </div>
                  </form>
               </div>
               <!-- Filter div End-->     
            </div>
            <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>purchase/mrn">
               <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
            </form>
         </div>
         <form action="<?php echo base_url(); ?>purchase/order_report?tab=<?php echo $_GET['tab']; ?>" method="GET" id="export-form">
            <input type="hidden" value='' id='hidden-type' name='ExportType' />
            <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
            <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
            <input type="hidden" value='<?php echo $_GET['tab']; ?>' name="tab"/>
         </form>
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
                        <?= table_th(['#','Report Name','Description','Parent','Url','Status','Action']); ?>
                        <tbody>
                        <?php 
                           if( $purchaseReport ){
                              foreach ($purchaseReport as $key => $value) { ?>
                                 <tr>
                                    <td><?= $value['id']; ?></td>
                                    <td><?= $value['report_name']; ?></td>
                                    <td><?= $value['description']; ?></td>
                                    <td><?= getSingleAndWhere('report_name','purchase_reports',['id' => $value['parent'] ])??$value['report_name']; ?></td>
                                    <td><?= $value['url']; ?></td>
                                    <td><?= ($value['status'])?'Active':'Unactive'; ?></td>
                                    <td><button id="<?= $value['id'] ?>" class="btn btn-edit btn-xs add_purchase_tabs" data-id="purchaseReport"><i class="fa fa-pencil"></i></button></td>
                                 </tr>
                                    
                           <?php }
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
 <div id="purchase_add_modal" class="modal fade in"  role="dialog" >
      <div class="modal-dialog modal-large">
         <div class="modal-content" style="overflow:auto;">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title chng_lbl nxt_cls addtitle2" id="myModalLabel">Purchase Indent</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>