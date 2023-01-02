<?php 
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   ?>
<style>
   .Process-card {
   box-shadow: rgba(0, 0, 0, 1) 1px 1px 9px -4px;
   }
   .Process-card {
   clear: both;
   display: table;
   width: 99%;
   border: 1px solid #c1c1c1;
   padding: 15px;
   margin: 0px auto 20px;
   }
   .mobile-view3 {
   display: table-row;
   }
   .label-box {
   padding: 0px;
   }
   #print_divv #chkIndex_1 label {
   margin: 0px;
   padding: 8px 10px;
   text-align: center;
   border-right: 1px solid #c1c1c1;
   border-bottom: 1px solid #c1c1c1;
   background-color: #FFF;
   display: block;
   width: 100%;
   overflow: hidden;
   text-overflow: ellipsis;
   white-space: nowrap;
   display: block;
   border-left: 0px;
   }
   #print_divv #chkIndex_1 .form-group {
   margin-bottom: 0px;
   }
   #print_divv #chkIndex_1 .form-group {
   padding: 0px;
   }
   .mobile-view3 .form-group {
   display: table-cell;
   float: unset;
   width: 1%;
   }
   .view-page-mobile-view .form-group {
   width: 1%;
   float: unset;
   display: table-cell;
   padding: 8px !important;
   background-color: #fff !important;
   border-bottom: 1px solid #c1c1c1 !important;
   border-right: 1px solid #c1c1c1 !important;
   border-top: 0px !important;
   }
   .mobile-view label {
   display: none !important;
   }
   div {
   display: block;
   }
   .col-container {
   margin: 0px;
   display: table-row;
   width: 100%;
   padding: 0px;
   background: unset;
   border: 0px;
   float: unset;
   }
   .total-main .col {
   border-right: 0px !important;
   background-color: #DCDCDC !important;
   color: #2C3A61;
   }
</style>
<?php //pre($assign_emp);die; ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/save_assign_emp" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
   <div style="width:100%" id="print_divv" border="1" cellpadding="2">
      <h3>Employee Details</h3>
      <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Employee Name</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php  $owner = getNameById('user_detail',$assign_emp->assign_id,'u_id'); ?>
               <?php if(!empty($owner)){echo $owner->name;} ?>	
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for=""></label>
            <div class="col-md-6 col-sm-12 col-xs-12">
            </div>
         </div>
      </div>     
	  <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Start Date</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($assign_emp)){ echo $assign_emp->start_date; } ?>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">End Date</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($assign_emp)){echo $assign_emp->end_date;} ?>	
            </div>
         </div>
      </div>    
	  <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Retrun Date</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($assign_emp)){echo $assign_emp->back_date;} ?>	
            </div>
         </div>
      </div>
      <hr>
      <div class="bottom-bdr"></div>
      <h3 class="Material-head">
         Asset Details
         <hr>
      </h3>
      <div class="col-md-12 col-xs-12 col-sm-12" id="chkIndex_1" style="padding:0px; border-top:0px;">
         <div class="Process-card">
            <!--<h3 class="Material-head">Porduction Details<hr></h3>-->							  
            <div class="label-box mobile-view3">
               <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Product Name</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Model No</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Assets Code</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Remarks</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Retrun Remarks</label></div>
            </div>
            <?php if(!empty($assign_emp)){ 
                $assets_products = json_decode($assign_emp->assets_products);
                    if(!empty($assets_products)){ 
					  $i=0;
                           foreach($assets_products as $td){ ?>
						     <?php  $asset_detail = getNameById('assets_list',$td->product_name,'id');
							// pre($asset_detail);
							 ?>

						<div class="row-padding col-container mobile-view view-page-mobile-view"  id="chkWell_<?php echo $i; ?>">
						   <div class="col-md-2 col-sm-12 col-xs-12 form-group col" style="border-left: 1px solid #c1c1c1 !important;">
							  <label>Product Name</label>
							  <div><?php echo $asset_detail->ass_name; ?></div>
						   </div>
						   <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
							  <label>Model No</label>
							  <div><?php echo $td->model_no; ?></div>
						   </div>
						   <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
							  <label>Assets Code</label>
							  <div><?php echo $td->assets_code; ?></div>
						   </div>
						   <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
							  <label>Remarks</label>
							  <div><?php echo $td->remarks ; ?></div>
						   </div>           
						   <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
							  <label>Return Remarks</label>
							  <div><?php echo (isset($td->return_remarks)?$td->return_remarks:''); ?></div>
						   </div>
						   
						</div>
            <?php    $i++;
						} 
					} 
               } ?>

         </div>
      </div>
    
   </div>
</form>