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
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/save_travel_info" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
   <div style="width:100%" id="print_divv" border="1" cellpadding="2">
   
      <div class="bottom-bdr"></div>
      <h3 class="Material-head">
         Travel Details
         <hr>
      </h3>
      <div class="col-md-12 col-xs-12 col-sm-12" id="chkIndex_1" style="padding:0px; border-top:0px;">
         <div class="Process-card">
            <!--<h3 class="Material-head">Porduction Details<hr></h3>-->							  
            <div class="label-box mobile-view3">
               <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Travel From</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Travel To</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Start Date</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>End Date</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Travel Mode</label></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Travel Cost</label></div>
            </div>
            <?php if(!empty($travel_info)){ 
               $total_cost = 0;
                             $travel_json = json_decode($travel_info->travel_details);
                             if(!empty($travel_json)){ 
                             		$i =  1;
                             		foreach($travel_json as $td){ ?>
            <div class="row-padding col-container mobile-view view-page-mobile-view"  id="chkWell_<?php echo $i; ?>">
               <div class="col-md-2 col-sm-12 col-xs-12 form-group col" style="border-left: 1px solid #c1c1c1 !important;">
                  <label>Travel From</label>
                  <div><?php echo $td->travel_from ; ?></div>
               </div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                  <label>Travel To</label>
                  <div><?php echo $td->travel_to ; ?></div>
               </div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                  <label>Start Date</label>
                  <div><?php echo $td->start_date ; ?></div>
               </div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                  <label>End Date</label>
                  <div><?php echo $td->end_date ; ?></div>
               </div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                  <label>Mode Of Travel</label>
                  <div><?php echo $td->travel_mode ; ?></div>
               </div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                  <label>Cost</label>
                  <div><?php echo $td->travel_cost ; ?></div>
               </div>
            </div>
            <?php  $total_cost += (isset($td->travel_cost)?round($td->travel_cost):0);
               $i++; 
               } 
               } 
               } ?>
            <div class="row-padding col-container mobile-view view-page-mobile-view total-main">
               <div class="col-md-2 col-sm-12 col-xs-12 form-group total-text col">Total</div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group col"></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group  col"></div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group total-number col" id="total_cost"><?php echo $total_cost ; ?></div>
            </div>
         </div>
      </div>
     
      <div class="bottom-bdr"></div>
	
      <hr>
   </div>
</form>