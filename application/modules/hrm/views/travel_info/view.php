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
      <h3>Employee Details</h3>
      <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Employee Name</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
             <?php $owner = getNameById('user_detail',$_SESSION['loggedInUser']->u_id,'u_id'); ?>
             <?php $u_id = getNameById('user_detail',$travel_info->u_id,'u_id'); ?>
                <input type="text" name="u_id" value="<?php if(!empty($travel_info->u_id)){ echo $u_id->name; }else{ echo $owner->name; } ?>">
               <?php /**$owner = getNameById('user_detail',$_SESSION['loggedInUser']->u_id,'u_id'); ?>
               <?php $u_id = getNameById('user_detail',$travel_info->u_id,'u_id'); ?>
                 <?php if(!empty($travel_info)){ echo $u_id->name; }else{if(!empty($owner)){echo $owner->name;}} **/?>	
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Purpose Of Visit</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($travel_info)){ echo $travel_info->Purpose_of_visit; } ?>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">No Of Days</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($travel_info)){echo $travel_info->no_of_days;} ?>	
            </div>
         </div>
      </div>
      <hr>
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
      <hr>
      <div class="bottom-bdr"></div>
      <h3>Travel Related Attachments</h3>
      <?php //
         if(!empty($attachments)){ ?>
      <div class="item form-group">
         <label class="control-label col-md-3 col-sm-2 col-xs-12" for="proof"></label>
         <div class="col-md-7">			
            <?php // pre($attachments);die;
               foreach($attachments as $proofs){	
               
               	 $ext = pathinfo($proofs['file_name'], PATHINFO_EXTENSION);
               	if($ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg' || $ext == 'png' || $ext == 'ico'){
               		echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'" alt="image" height="80" width="80"/><i class="fa fa-download"></i> </a></div></div>';			
               	}else if($ext == 'ods' || $ext ==  'doc' || $ext ==  'docx' ){
               		echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/docX.png"  height="80" width="80"/><i class="fa fa-download"></i> </a></div></div>';	
               	}else if($ext == 'pdf'){
               		echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/PDF.png"  height="80" width="80"/><i class="fa fa-download"></i></a> </div></div>';	
               	}else if($ext == 'xlsx' || $ext ==  'csv' || $ext ==  'xls' ){
               		echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/hrm/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/excel.png"  height="80" width="80"/><i class="fa fa-download"></i></a></div></div>';	
               	}
               }
               
               ?>				
         </div>
      </div>
      <?php } ?>  
      <hr>
      <div class="bottom-bdr"></div>
      <h3>Travel and Other Expenses</h3>
      <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Daily Allowance Charge</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($travel_info)){echo $travel_info->daily_allowance;} ?>	
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Local Conveyance Allowance</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($travel_info)){echo $travel_info->local_conveyance;} ?>      
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Gross Charges Incurred</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($travel_info)){echo $travel_info->gross_charge;} ?>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Advance Taken Payment</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($travel_info)){echo $travel_info->advance_taken;} ?>	
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Net Claimed</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($travel_info)){echo $travel_info->net_claim;} ?>	
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Remarks</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($travel_info)){echo $travel_info->remarks;} ?>
            </div>
         </div>
      </div>
	  <hr>
      <div class="bottom-bdr"></div>
      <h3>Payment Details</h3>
	   <?php 	$paymentDetailsJson = array();
		if(!empty($travel_info->payment_details)){ 
                  $paymentDetailsJson = json_decode($travel_info->payment_details); 
				//  pre($paymentDetailsJson);die;
	   }
		?>
	<?php foreach($paymentDetailsJson as $payment){ ?> 
      <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Amount</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($payment)){echo $payment->amount;} ?>	
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Payment Date</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
			<?php if(!empty($payment)){echo $payment->payment_date ;} ?>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12 item form-group vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="textarea">Specification</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
						<?php if(!empty($payment)){echo $payment->payment_description;} ?>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12  vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="parent_account">Payment complete Status</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
               <?php if(!empty($payment) && $payment->balance =='0'){ echo "Complete"; }else{  echo "In Progress"; } ?>	
            </div>
         </div>
      </div>	  
	  <hr>
      <div class="bottom-bdr"></div>
	<?php } ?>
      <hr>
   </div>
</form>
  <center>
	<button class="btn edit-end-btn hidden-print" onclick="Print_data_new()"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
  </center>
