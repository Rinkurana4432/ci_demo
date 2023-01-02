<!-- Change Status work Start -->	
<style>
.addReadMore.showlesscontent .SecSec,
    .addReadMore.showlesscontent .readLess {
        display: none;
    }

    .addReadMore.showmorecontent .readMore {
        display: none;
    }

    .addReadMore .readMore,
    .addReadMore .readLess {
        font-weight: bold;
        margin-left: 2px;
        color: blue;
        cursor: pointer;
    }

    .addReadMoreWrapTxt.showmorecontent .SecSec,
    .addReadMoreWrapTxt.showmorecontent .readLess {
        display: block;
    }
   

</style>
<?php 	
   $orderCode = ($orders && !empty($orders))?$orders->order_code:'';
   $statusDetail = JSON_decode($orders->status);	
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
<div class="container body">
   <div class="main_container">
      <div class="col-md-12 col-sm-12 col-xs-12" role="main">
         <div class="">
            <div class="clearfix"></div>
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                     <div class="x_content">
                        <div id="wizard" class="form_wizard wizard_horizontal">
                           <ul class="wizard_steps list-top">
                              <li>
                                 <a href="javascript:void(0);">
                                 <span class="dsgn_cls">Purchase Indent</span>
                                 <span class="step_descr"><small></small></span>
                                 </a>
                              </li>
                              <li>
                                 <a href="javascript:void(0);">
                                 <span class="dsgn_cls">Purchase Order</span>
                                 <span class="step_descr"><small></small></span>
                                 </a>
                              </li>
                              <?php 
                                 if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form != '' || $statusDetail->MRN->mrn_code != '' ) || ($orders->mrn_or_not == 1)){ ?>
                              <li>
                                 <a href="javascript:void(0);">
                                    <span class="dsgn_cls">GRN</span>
                                    <span class="step_descr"><small></small></span>
                                 </a>
                              </li>
                              <?php } else { ?>  
                              <li>
                                 <a href="javascript:void(0);">
                                 <span class="not_value">GRN</span>
                                 <span class="step_descr"><small></small></span>
                                 </a>
                              </li>
                              <?php } ?>
                              <?php if($orders->ifbalance == 0){ // 0 Means Complete Payment ?>
                              <li>
                                 <span class="dsgn_cls slide-toggle">Payment <i class="fa fa-chevron-circle-down"></i></span>
                                 <span class="step_descr"><small></small></span>
                              </li>
                              <?php } elseif($orders->ifbalance == 1) { //1 Means Payment Not Complete ?>
                              <li>
                                 <span class="not_value slide-toggle">Payment <i class="fa fa-chevron-circle-down"></i></span>
                                 <span class="step_descr"><small></small></span>
                              </li>
                              <?php } ?> 
                           </ul>
                           <div class="box1" style="display:none;">
                              <div class="box-inner" >
                                 <!--h2 class="StepTitle">Step 3 Content</h2-->
                                 <div class="heading">
                                    <h4><?php  echo $orderCode; ?></h4>
                                 </div>
                                 <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/saveStatusPI" enctype="multipart/form-data" id="purchaseIndentForm" novalidate="novalidate">
                                    <input type="hidden" name="id" value="<?php if($orders && !empty($orders)){ echo $orders->id;} ?>" >	
                                    <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">
                                    <?php
                                       if(empty($orders)){
                                       ?>
                                    <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
                                    <?php }else{ ?>	
                                    <input type="hidden" name="created_by" value="<?php if($orders && !empty($orders)){ echo $orders->created_by;} ?>" >
                                    <?php } ?>
                                    <input type="hidden" value="Purch_order" name="frm_pruch_ordr">
                                    <div class="item form-group" <?php  if(!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete'){ } ?>>
                                       <!-- echo 'style="pointer-events:none;"' -->
                                       <?php /*<div class="item form-group" > */?>
                                       <div class="container">
                                          <div class="col-lg-12">
                                             <div class="col-xs-6">Status</div>
                                             <div style=" float:right;" class="pull-right col-xs-6">
                                                <p class="pull-right"><b>Purchase Order  ID : </b> <?php echo $orders->id; ?></p>
                                                <!--p class="pull-right"><b> PI Grand Total : </b> <?php //echo $indents->grand_total; ?></p>
                                                   <p><b>Balance : </b> <?php //echo $indents->ifbalance; ?></p-->
                                             </div>
                                          </div>
                                       </div>
                                       <div class="container view-paymt">
                                          <tbody>
                                             <div class="col-sm-12 col-xs-12 col-md-4">
                                                <?php  if( $orders->pi_id == 0){ ?>
                                                <div class="col-md-12 col-sm-12 col-xs-12 view-bg">
                                                   <center>PO  <input type="checkbox" name="pi_status[]" id="poCheck" value="po" checked <?php  if((!empty($statusDetail) && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->name == 'PO' &&  $statusDetail->PO->po_or_verbal != '' ||  $statusDetail->PO->po_code != '') || ($orders->po_or_not == 1)){ echo 'checked'; }  ?> style="pointer-events:<?php if( $orders->po_or_not == 1){ echo 'none'; } ?>"><br /></center>
                                                </div>
                                                <div class="poSection col-md-12" style="display:<?php  if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) &&  $statusDetail->PO->po_or_verbal != '') || ($orders->po_or_not == 1)){ echo 'block'; }else{ echo 'block';} ?>;">
                                                   <div class="col-md-12 col-sm-12 col-xs-12 border-rg">
                                                      <div class="radio">
                                                         <label>
                                                         <input type="radio" class="flat" name="po_or_verbal"   value="verbal" <?php  if(!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'verbal' || empty($po)){ echo 'checked'; }  if( $orders->po_or_not == 1){ ?>  onclick="return false" <?php } ?>> Verbal
                                                         </label>
                                                      </div>
                                                      <div class="radio">
                                                         <label>							
                                                         <input type="radio" class="flat po_code"  name="po_or_verbal" value="po_code" <?php  if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'po_code') && ($orders->po_or_not == 1) || !empty($po) ){ echo 'checked'; } ?>   <?php if( (!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'verbal') || ($orders->po_or_not == 1)){ ?>  onclick="return false" <?php } ?>> PO Code
                                                         </label>
                                                      </div>
                                                      <?php 
                                                         if(!empty($po)){
                                                         	if($po[0]['pi_id'] == 0){
                                                         		echo '<h5><b>Po Generated List</b></h5>';
                                                         			echo $po[0]['order_code'];
                                                         	}else{
                                                         	echo '<h5><b>PI Generated List</b></h5>';
                                                         		$pi_code = getNameById('purchase_indent', $po[0]['pi_id'], 'id');
                                                         		 // pre($pi_code);
                                                         		 echo '<a href="javascript:void(0)" id="'.$pi_code->id.'" data-id="indentView" class="add_purchase_tabs">'.$pi_code->indent_code.'</a>';
                                                         	}
                                                         }	
                                                         ?>
                                                   </div>
                                                </div>
                                                <?php }else{?>
                                                <div class="col-md-12 col-sm-12 col-xs-12 view-bg">
                                                   <center>PI <input type="checkbox" name="pi_status[]" id="poCheck" value="po" checked <?php  if((!empty($statusDetail) && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->name == 'PO' &&  $statusDetail->PO->po_or_verbal != '' ||  $statusDetail->PO->po_code != '') || ($orders->po_or_not == 1)){ echo 'checked'; }  ?> style="pointer-events:<?php if( $orders->po_or_not == 1){ echo 'none'; } ?>"><br />
                                                   </center>
                                                </div>
                                                <div class="poSection col-md-12" style="display:<?php  if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) &&  $statusDetail->PO->po_or_verbal != '') || ($orders->po_or_not == 1)){ echo 'block'; }else{ echo 'block';} ?>;">
                                                   <div class="col-md-12 col-sm-12 col-xs-12 border-rg">
                                                      <div class="radio">
                                                         <label>
                                                         <input type="radio" class="flat" name="po_or_verbal"   value="verbal" <?php  if(!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'verbal' || empty($po)){ echo 'checked'; }  if( $orders->po_or_not == 1){ ?>  onclick="return false" <?php } ?>> Verbal
                                                         </label>
                                                      </div>
                                                      <div class="radio">
                                                         <label>	
                                                         <input type="radio" class="flat po_code"  name="po_or_verbal" value="po_code" <?php  if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'po_code') && ($orders->po_or_not == 1) || !empty($po) ){ echo 'checked'; } ?>   <?php if( (!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'verbal') || ($orders->po_or_not == 1)){ ?>  onclick="return false" <?php } ?>> PI Code
                                                         </label>
                                                      </div>
                                                      <?php 
                                                         if(!empty($po)){
                                                         	echo '<h5><b>PI Generated List</b></h5>';
                                                         	$pi_code = getNameById('purchase_indent', $po[0]['pi_id'], 'id');
                                                         	echo '<a href="javascript:void(0)" id="'.$pi_code->id.'" data-id="indentView" class="add_purchase_tabs">'.$pi_code->indent_code.'</a>';
                                                         }	
                                                         ?>
                                                   </div>
                                                </div>
                                                <?php }?>
                                             </div>
                                             <div class="col-sm-12 col-xs-12 col-md-4">
                                                <div class="col-md-12 col-sm-12 col-xs-12 view-bg">
                                                   <center>GRN <input type="checkbox" name="pi_status[]" id="mrnCheck" value="mrn" <?php  if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->name == 'MRN' && $statusDetail->MRN->mrn_or_without_form != '' || $statusDetail->MRN->mrn_code != '') || ($orders->mrn_or_not == 1)){ echo 'checked'; } ?> style="pointer-events:<?php if( $orders->mrn_or_not == 1){ echo 'none'; } ?>"><br />
                                                   </center>
                                                </div>
                                                <div class="mrnSection col-md-12" style="display:<?php  if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form != '') || ($orders->mrn_or_not == 1)){ echo 'block'; }else { echo 'none'; }  ?>;">
                                                   <div class="col-md-12 col-sm-12 col-xs-12 border-rg">
                                                      <div class="radio">
                                                         <label>							
                                                         <input type="radio" class="flat mrnwithout_form"  name="mrn_or_without_form"  value="Without Form" <?php  if(!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form == 'Without Form' && $statusDetail->MRN->invoice_no == ''){ echo 'checked'; }  ?>> Without Form
                                                         </label>
                                                      </div>
                                                      <div class="radio">
                                                         <label>							
                                                         <input type="radio" class="flat mrninvoice_no"  name="mrn_or_without_form" value="mrn_code" 
                                                            <?php 
                                                               if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form == 'mrn_code') || ($orders->mrn_or_not == 1 && $statusDetail->MRN->invoice_no != '') ){ 
                                                               echo 'checked';
                                                               } 
                                                            ?>
                                                            > Invoice No.
                                                         </label>
                                                         <br/>
                                                      </div>
                                                      <?php
                                                         if(!empty($mrn)){
                                                         	echo '<h5><b>GRN Invoice No.</b></h5>';
                                                         	$invoice_no = '';
                                                         	foreach($mrn as $mrnVal){
                                                         		$invoice_no .= $mrnVal['bill_no'].'<br>';
                                                         		$invoice_id .= $mrnVal['id'].'<br>';
                                                         	}
                                                         	//echo $invoice_no;
                                                         	echo '<a href="javascript:void(0)" id="'.$invoice_id.'" data-id="MrnView" class="add_purchase_tabs">'.$invoice_no.'</a>';
                                                         }else{ 
                                                         
                                                         ?>
                                                      <p class="inptbtn">
                                                         <input type="text" name="invoice_no" class="form-control" value="<?php if($statusDetail->MRN->invoice_no != ''){echo $statusDetail->MRN->invoice_no;} ?>">	
                                                         Date <input type="text" id="inv_date" name="invoice_date" class="form-control" value="<?php if($statusDetail->MRN->invoice_date != ''){echo $statusDetail->MRN->invoice_date;} ?>">
                                                      </p>
                                                      <?php } ?>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-sm-12 col-xs-12 col-md-4">
                                                <div class="col-md-12 col-sm-12 col-xs-12 view-bg">
                                                   <center>Payment <input type="checkbox" name="pi_status[]" id="paymentCheck" value="payment" <?php  if((!empty($statusDetail)  && (array_key_exists("Payment",$statusDetail)) && $statusDetail->Payment[0]->name == 'Payment') || ($orders->pay_or_not == 1)){ echo 'checked'; } ?>><br />
                                                      <?php  if(!empty($statusDetail)  && (array_key_exists("Payment",$statusDetail)) && $statusDetail->Payment[0]->name == 'Payment'){
                                                         $previousPaymentData =  json_encode($statusDetail->Payment); 
                                                         
                                                         
                                                         
                                                         } ?>
                                                      <input type="hidden" name="previousPaymentData" value='<?php  if(!empty($statusDetail)  && (array_key_exists("Payment",$statusDetail)) && $statusDetail->Payment[0]->name == 'Payment'){ echo $previousPaymentData; } ?>'> 
                                                   </center>
                                                </div>
                                                <div class="paymentSection col-md-12 border-rg" style="display:<?php  if(!empty($statusDetail)  && (array_key_exists("Payment",$statusDetail)) && $statusDetail->Payment[0]->name == 'Payment'){ echo 'block'; } else{ echo 'none'; }?>;">
                                                   <?php
                                                      //pre($statusDetail->Payment);
                                                      if( !empty($statusDetail->Payment) ){
                                                      	echo '<h2>Previous payment details</h2>';
                                                      		echo '<table class="table table-bordered" id="example">
                                                      		  
                                                      		  <tbody>';
                                                      			 
                                                      				foreach($statusDetail->Payment as $paymentData){ 
                                                      				?>
                                                   <div class="item form-group" scope="row" contenteditable = 'true' >
                                                      <label class="col-md-12 col-sm-12 col-xs-12" for="amount">Amount<span class="required">*</span></label>
                                                      <div class="col-md-12 col-sm-12 col-xs-12">
                                                         <input type="text"  id="amount" name="edit_amount[]" class="form-control" placeholder="amount" value="<?php echo $paymentData->amount; ?>" required="required" onkeypress="return float_validation(event, this.value)" <?php if($statusDetail->Complete->name == 'Complete'){echo 'disabled';} ?> >
                                                      </div>
                                                   </div>
                                                   <!--td ><?php// echo $paymentData->balance; ?></td-->
                                                   <div class="item form-group">
                                                      <label class="col-md-12 col-sm-12 col-xs-12" for="req_date">Date<span class="required">*</span></label>
                                                      <div class="col-md-12 col-sm-12 col-xs-12">
                                                         <input type="text" id="req_date1" name="edit_required_date[]" class="form-control" placeholder="Date" value="<?php echo $paymentData->required_date; ?>" required="required" <?php if($statusDetail->Complete->name == 'Complete'){echo 'disabled';} ?>>
                                                      </div>
                                                   </div>
                                                   <div class="item form-group">
                                                      <label class="col-md-12 col-sm-12 col-xs-12" for="specification">Narration</label>
                                                      <div class="col-md-12 col-sm-12 col-xs-12">
                                                         <textarea  id="description" name="edit_description[]" class="form-control" placeholder="description" <?php if($statusDetail->Complete->name == 'Complete'){echo 'disabled';} ?>><?php echo $paymentData->description; ?></textarea>
                                                      </div>
                                                   </div>
                                                   <?php	} echo '</tbody>
                                                      </table>';
                                                      ?>
                                                   <input type="hidden" name="check_payment_complete" id="check_payment_complete" value="<?php if($orders->ifbalance == 0){ echo 'complete_payment';} ?>">
                                                   <?php }	
                                                      if( $orders->ifbalance !=0 ){
                                                      ?>
                                                   <div <?php  if(!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete' && $orders->pay_or_not = 1){ echo 'style="display:none;"'; } ?>  >
                                                      <?php /*<div > */?>
                                                      <div class="item form-group">
                                                         <label class="col-md-12 col-sm-12 col-xs-12" for="amount">Amount<span class="required">*</span></label>
                                                         <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <input type="text"  id="amount" name="amount" class="form-control" placeholder="amount" value="" onkeypress="return float_validation(event, this.value)" >
                                                         </div>
                                                      </div>
                                                      <div class="item form-group">
                                                         <label class="col-md-12 col-sm-12 col-xs-12" for="req_date">Date<span class="required">*</span></label>
                                                         <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <span class="add-on input-group-addon req-date1"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                                            <input type="text" id="req_date12" name="required_date" class="form-control" placeholder="Date" value=""  style="width:90%;">
                                                         </div>
                                                      </div>
                                                      <div class="item form-group">
                                                         <label class="col-md-12 col-sm-12 col-xs-12" for="specification">Narration</label>
                                                         <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <textarea  id="description" name="description" class="form-control" placeholder="description"></textarea>
                                                         </div>
                                                      </div>
                                                      <div class="item form-group">
                                                         <label class="col-md-12 col-sm-12 col-xs-12" for="specification">Payment </label>
                                                         <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <input type="checkbox" name="check_payment_complete" id="check_payment_complete" value="complete_payment"> Please check if Payment Complete<br>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <?php } ?>				
                                             <div class="col-sm-12 col-xs-12 col-md-12">
                                                <div class="view-bg bottam-check" >Complete :<input type="checkbox" name="pi_status[]" id="completeCheck" value="complete" <?php  if((!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete') || (($orders->po_or_not == 1) && ($orders->mrn_or_not == 1) && ($orders->pay_or_not == 1))){ echo 'checked'; } elseif($indents->ifbalance == 0){echo 'enabled';}else{ echo 'disabled';} ?> >	<br /></div>
                                             </div>
                                       </div>
                                    </div>
                                    <input type="hidden" value="<?php echo $orders->ifbalance; ?>" name="indent_grand_totl" id="get_balance">
                                    <input type="hidden" value="<?php echo $orders->grand_total; ?>" name="grand_total" >
                                    <!--div class="form-group" <?php  //if(!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete'){ echo 'style="display:none;"'; } ?>--> 
                                    <div class="form-group" <?php if($statusDetail->Complete->name == 'Complete'){echo 'style="display:none;"';} ?>> 
                                    <div class="form-group"> 
                                    <?php /*<div class="form-group" > */?>
                                    <div class="col-md-12">
                                    <center>
                                    <a class="btn  btn-default" onclick="location.href='<?php echo base_url();?>purchase/purchase_order'">Close</a>
                                    <button type="reset" class="btn edit-end-btn ">Reset</button>
                                    <?php if((!empty($orders) && $orders->save_status !=1) || empty($orders)){
                                       echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
                                       }?> 
                                    <input type="submit" value="submit" class="btn edit-end-btn">
                                    </center>
                                    </div>
                                    </div>
                                    </div>
                              </div>
                              </form>
                              <!-- /page content -->
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
<!-- Change Status work Start -->
<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv">
<h3 class="Material-head" style="margin-bottom: 30px;">Order Detail<hr></h3>
<div class="table-responsive" style="margin-top:20px;">
<div class=" col-md-6 col-xs-12 col-sm-6 label-left   "  style=" padding:0px;">
<?php if (($orders && !empty($orders)) && (($orders->pi_id != '') || ($orders->pi_id!=0))) { ?>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<label for="material">Purchase Indent Code<span class="required">*</span></label>
<div class="col-md-7 col-sm-7 col-xs-6">
<div ><?php 	$purchaseIndentData=getNameById('purchase_indent',$orders->pi_id,'id');
   if(!empty($purchaseIndentData)){ 
   		//echo $purchaseIndentData->indent_code;
		echo '<a href="javascript:void(0)" id="'.$orders->pi_id.'" data-id="indentView" class="add_purchase_tabs">'.$purchaseIndentData->indent_code.'</a>';
   }						
   ?></div>
</div>
</div>  
<?php } ?>	
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<label for="material">Order Code<span class="required">*</span></label>
<div class="col-md-7 col-sm-7 col-xs-6">
<div><?php if (!empty($orders)) {
   echo $orders->order_code; 
   } ?>
</div>
</div>
</div>	
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<label for="material">Order Date<span class="required">*</span></label>
<div class="col-md-7 col-sm-7 col-xs-6">
<div><?php if (!empty($orders)) {
   echo date("j F , Y", strtotime($orders->date));
   } ?>
</div>
</div>
</div>	
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<label for="material">For Company Unit<span class="required">*</span></label>
<div class="col-md-7 col-sm-7 col-xs-6">
<div><b><?php if(!empty($orders)){
   //pre($orders);
   /*$brnch_name = getNameById_with_cid('company_address', $orders->delivery_address, 'compny_branch_id','created_by_cid',$this->companyGroupId);
   			echo $brnch_name->location;*/

   $brnch_name = getNameById_with_cid('company_address', $orders->company_unit, 'compny_branch_id','created_by_cid',$this->companyGroupId);
            echo $brnch_name->company_unit;   			
   
   			} ?></b></div>
</div>
</div>	
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<label for="material">Supplier Name<span class="required">*</span></label>
<?php if (!empty($suppliername)) {
   $orders->supplier_name;
   $supplier_name = getNameById('supplier', $orders->supplier_name, 'id');
   }
   ?>
<div class="col-md-7 col-sm-12 col-xs-6">
<div><?php if ($supplier_name == null) {
   echo "N/A";
   } else {
   echo $supplier_name->name;
   }  ?></div>
</div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<label for="material">Address<span class="required">*</span></label>
<div class="col-md-7 col-sm-7 col-xs-6">
<div ><?php if ($supplier_name == null) {
   echo "N/A";
   } else {
   echo $supplier_name->address;
   }  ?></div>
</div>
</div>
   
<?= approvePoView($orders); ?>

</div>
<div class=" col-md-6 col-xs-12 col-sm-6 label-left   "  style=" padding:0px;">
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<label for="material">Delivery Address</label>
<?php if (!empty($orders)) {
	
	// $adress_data = json_decode($data[0]['address']);
	// pre($data);
	// foreach($adress_data as $val_add){
		  
		// if($val_add->id == $orders->delivery_address){
			// echo $val_add->address;
		// }
	// }
  }
   ?>
<div class="col-md-7 col-sm-7 col-xs-6">
<div><?php 
if (!empty($orders)) {
      $where = array('id' => $orders->delivery_address);
    $data = $this->purchase_model->get_data_byAddress('company_address', $where);
	echo $data[0]['location'];

}	?></div>
</div>
</div>  
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<label for="material">Expected Delivery Date</label>
<div class="col-md-7 col-sm-7 col-xs-6">
<div><?php if (!empty($orders) && $orders->expected_delivery_date!='') {
   echo date("j F , Y", strtotime($orders->expected_delivery_date));
   } ?>
</div>
</div>
</div>	
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<label for="material">Pay Mode</label>
<div class="col-md-7 col-sm-7 col-xs-6">
<div><?php if (!empty($orders)) {
   echo $orders->payment_terms;
   } ?>
</div>
</div>
</div>	
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<label for="material">Terms Of Delivery</label>
<div class="col-md-7 col-sm-7 col-xs-6">
<div ><?php if (!empty($orders)) {
   echo $orders->terms_delivery;
   } ?></div>
</div>
</div>	
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<label for="material">Terms And Conditons</label>									 
<div class="col-md-7 col-sm-7 col-xs-6">
<div ><p class="addReadMore showlesscontent"><?php if (!empty($orders)) {
   echo $orders->terms_conditions;
   
   
   } ?></p></div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<label for="material">Pay Date</label>
<div class="col-md-7 col-sm-7 col-xs-6">									
<div><?php if (!empty($orders) && $orders->payment_date != '') {
   echo date("j F , Y", strtotime($orders->payment_date));
   } ?></div>
</div>
</div>	
 <div class="col-md-12 col-sm-12 col-xs-12 form-group">
   <label>Type:</label>
   <div class="col-md-7 col-sm-12 col-xs-6">
      <div ><?php 
         switch ($mrnView->purchase_type) {
            case 1:
               echo 'Import';
               break;
            default:
               echo 'Domestic';
            break;
         }
       ?>                      
      </div>
   </div>
</div>		
</div>
</div>
<hr>
<div class="bottom-bdr"></div>							
<div class="container mt-3">
<h3 class="Material-head">Material Description<hr></h3>	
<div class="well pro-details for-leptop-1" id="chkIndex_1" >
<?php if(($orders->material_name != '') && ($orders->material_name != '	[{"material_name_id":"","uom":"","quantity":"","price":"","sub_tax":"","sub_total":"","gst":"","total":""}]')) {  ?>
<div class="col-container mobile-view2">
<div class="col-md-1 col-sm-12 col-xs-12 form-group">Material Name</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group">HSN</div>
<div class="col-md-1 col-sm-12 col-xs-6 form-group">Alias</div>
<div class="col-md-1 col-sm-12 col-xs-6 form-group">Img</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group">Special Description</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group">Quantity</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group">Price (₹)</div>

<div class="col-md-1 col-sm-12 col-xs-12 form-group">Sub Total (₹)</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group">GST</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group">Sub Tax</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group">Total (₹)</div>  
</div>
<?php
   if (!empty($orders) && $orders->material_name != '') {
   	$materialDetail =  json_decode($orders->material_name);
   	$subTotal = 0;
   	$Total = 0;
   	foreach ($materialDetail as $material_detail) {
		 if($material_detail->material_name_id != ''){

   	  
   		$subTotal += $material_detail->sub_total;
   		$Total += $material_detail->total;
   		$material_id = $material_detail->material_name_id;
   		$materialName = getNameById('material', $material_id, 'id');
		
   		$hsncode = getNameById('hsn_sac_master', $materialName->hsn_code, 'id');
		 // pre($hsncode);
   		$materialType = getNameById('material_type', $material_detail->material_type_id, 'id');
   		$materialType_old = getNameById('material_type', $orders->material_type_id, 'id');
		
   	?>
<div class="row-padding col-container mobile-view view-page-mobile-view">
<!-- <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
<label>Material Type</label>
<div><span><?php if (!empty($materialType)) {	echo $materialType->name;	}else{ echo $materialType_old->name;} ?></span></div>
</div> -->
<div class="col-md-1 col-sm-12 col-xs-12 form-group col">
<label>Material Name</label>
<div  ><span><?php if (!empty($materialName)) {	echo getPCode($material_id).$materialName->material_name;	} ?></div>
</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group col">
<label>HSN</label>
<div ><?php echo $hsncode->hsn_sac; ?></div>
</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group col">
<label>Alias</label>
<div ><?php echo $material_detail->aliasname; ?></div>
</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group col">
<label>Img.</label>
<div ><?php 
		$attachments = $this->purchase_model->get_image_by_materialId('attachments', 'rel_id', $material_detail->material_name_id);
		if(!empty($attachments)){
		echo '<img style="width: 50px; height: 37px; " src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
		}else{
			echo '<img style="width: 50px; height: 37px;" src="'.base_url().'assets/uplodimg/noimage.jpg">';
		}
	?></div>
</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group col">
<label>Description</label>
<div  ><span><?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?></div>
</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group col">
<label>Quantity</label>
<div ><?php if ($orders->is_purchase_date ==1 ) {
  echo 'Open';
}else{ echo  $material_detail->quantity; }?></div>
</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group col">
<label>Price (₹)</label>
<div  ><?php echo number_format($material_detail->price, ($material_detail->price == (int)$material_detail->price) ? 0 : 1); ?></div>
</div>

<div class="col-md-1 col-sm-12 col-xs-12 form-group col">
<label>Sub Total (₹)</label>
<div  ><?php echo $material_detail->sub_total; ?></div>
</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group col">
<label>GST</label>
<div  ><?php echo $material_detail->gst; ?></div>
</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group col">
<label>Sub Tax</label>
<div  ><?php echo $material_detail->sub_tax; ?></div>
</div>
<div class="col-md-1 col-sm-12 col-xs-12 form-group col">
<label>Total (₹)</label>
<div ><?php echo number_format($material_detail->total, ($material_detail->total == (int)$material_detail->total) ? 0 : 1); ?></div>
</div>
</div>
<?php
	}
   }	
}} ?>
</div>	


<table class="well pro-details for-print"  id="chkIndex_1" >
<?php if(($orders->material_name != '') && ($orders->material_name != '	[{"material_name_id":"","uom":"","quantity":"","price":"","sub_tax":"","sub_total":"","gst":"","total":""}]')) {  ?>
<tr>
<th>Material Name</th>
<th>HSN</th>
<th>Alias</th>
<th>Quantity</th> 
<th>Price (₹)</th> 
<th>Sub Total (₹)</th> 
<th>GST</th> 
<th>Sub Tax</th> 
<th>Total (₹)</th>  
</tr>
<?php
   if (!empty($orders) && $orders->material_name != '') {
   	$materialDetail =  json_decode($orders->material_name);
   	$subTotal = 0;
   	$Total = 0;
   	$sub_tax = 0;
   	foreach ($materialDetail as $material_detail) {
   	 if($material_detail->quantity != 0){
		$sub_tax += $material_detail->sub_tax;
   		$subTotal += $material_detail->sub_total;
   		$Total += $material_detail->total;
   		$material_id = $material_detail->material_name_id;
   		$materialName = getNameById('material', $material_id, 'id');
   		
   		?>
 <tbody>
 <tr>
<td>

<div  ><span><?php if (!empty($materialName)) {	echo getPCode($material_id).$materialName->material_name;	} ?>:</span>&nbsp;&nbsp;<?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?></div>
</td>
<td>
<div ><?php echo $material_detail->hsnCode; ?></div>
</td>
<td>
<div>asdfd</div>
</td>
<td>
<div ><?php echo $material_detail->quantity; ?></div>
</td>
<td>

<div  ><?php echo number_format($material_detail->price, ($material_detail->price == (int)$material_detail->price) ? 0 : 1); ?></div>
</td>

<td>

<div  ><?php echo $material_detail->sub_total; ?></div>
</td>
<td>

<div>sdfgsfg</div>
</td>
<td>

<div  ><?php echo $material_detail->gst; ?></div>
</td>
<td>

<div  ><?php echo $material_detail->sub_tax; ?></div>
</td>
<td>

<div ><?php echo number_format($material_detail->total, ($material_detail->total == (int)$material_detail->total) ? 0 : 1); ?></div>
</td>
</tr>
</tbody>
<?php
   }
   }	
   } ?>
</table>							
<div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">

<div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
<div class="col-md-12 col-sm-5 col-xs-12 text-right">
<div class="col-md-12 col-sm-12 col-xs-12 text-right">
<div class="col-md-6 col-sm-5 col-xs-6 text-right">
Sub Total (₹)
</div>
<div class="col-md-6 col-sm-5 col-xs-6 text-left">
<?php echo $subTotal; ?>
</div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 text-right cgst">
<div class="col-md-6 col-sm-5 col-xs-6 text-right">
Tax (₹)
</div>
<div class="col-md-6 col-sm-5 col-xs-6 text-left">
<?php echo $sub_tax; ?>
</div>
</div>
<?php 
   if($orders->freight !='' && $orders->freight != 0){
   if (!empty($orders) && $orders->terms_delivery == 'To be paid by customer') { 
   
   ?>
<div class="col-md-12 col-sm-12 col-xs-12 text-right sgst">
<div class="col-md-6 col-sm-5 col-xs-6 text-right">
Freight (₹) 
</div>
<div class="col-md-6 col-sm-5 col-xs-6 text-left">
<?php echo $orders->freight; ?>  
</div>
</div>
<?php } }?>
<?php if($orders->other_charges !='' && $orders->other_charges != 0){ ?>
<div class="col-md-12 col-sm-12 col-xs-12 text-right igst style='display:none;'" >
<div class="col-md-6 col-sm-5 col-xs-6 text-right">Other Charges with Tax(if any) (₹):</div>
<div class="col-md-6 col-sm-5 col-xs-6 text-left">
<?php if (!empty($orders)) {
   #echo number_format($charges_total);
   echo number_format($orders->other_charges, ($orders->other_charges == (int)$orders->other_charges) ? 0 : 1);
   } ?> 						 </div>
</div>
<?php }?>
<div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 20px;color: #2C3A61; border-top: 1px solid #2C3A61;">
<div class="col-md-6 col-sm-5 col-xs-6 text-right">
Grand Total (₹) 
</div>
<div class="col-md-6 col-sm-5 col-xs-6 text-left">
<span class="divSubTotal fa fa-rupee" aria-hidden="true"><?php if (!empty($orders)) {
   //echo number_format($orders->grand_total +  $charges_total);
   echo $orders->grand_total;
   } ?></span> 
</div>
</div>
</div>
</div>
</div>
<?php } ?>
</div>


<div class="inner">
<?php if (!empty($count)) {
   foreach ($count as $counts) { ?>
<h3><?php echo $counts; ?></h3>
<?php }
   } ?>
</div>
</div>
<center>

<!--button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button-->
<?php 
// $dataPdf['dataPdf'] = $this->purchase_model->get_data_byId('purchase_order', 'id', $orders->id);
// $html = $this->load->view('purchase_order/order_pdf_email', $dataPdf, true);

?>



<?php 
// pre($orders->disapprove);
if($orders->disapprove == 0 && $orders->disapprove != ''){
if ((!empty($orders) && $orders->save_status == 1) || empty($orders)) {
?>
<a href="<?php echo base_url(); ?>purchase/create_pdf/<?php echo $orders->id; ?>" target="_blank"><button class="btn edit-end-btn">Generate PDF</button></a>
<button class="btn edit-end-btn sharevia_email_cls ">Share Via Email</button>
<a href="<?php echo base_url(); ?>purchase/download_pdf/<?php echo $orders->id; ?>"><button class="btn edit-end-btn">Share via Whatsapp</button></a>
<?php 
	}
}
 ?>
</center>
<!-- share via Email -->
<div class="modal fade" id="myModal_share_email" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="myModalLabel">Share</h4>
<span id="mssg"></span>
</div>
<form name="form_share_viaEmail" name="share_form"  id="form_share_viaEmail_id">
<div class="modal-body">
<div class="item form-group col-md-12 col-sm-12 col-xs-12">
<input type="hidden" class="order_id" value='<?php echo $orders->id; ?>' name="order_id" >
<label class="col-md-2 col-sm-2 col-xs-4" for="name">Email<span class="required">*</span></label>
<div class="col-md-10 col-sm-10 col-xs-8 form-group">
<input type="text" name="email_name" id="email_name" required="required" class="form-control col-md-7 col-xs-12" value="">
<span class="spanLeft control-label"></span>
</div>
</div>
<div class="item form-group col-md-12 col-sm-12 col-xs-12">
<label class="col-md-2 col-sm-2 col-xs-4" for="name">Message</label>
<div class="col-md-10 col-sm-10 col-xs-8 form-group">
<textarea id="email_msg_id" name="email_msg"  class="form-control col-md-7 col-xs-12" placeholder="Message ..." ></textarea>
<span class="spanLeft control-label"></span>
</div>
</div>

<div class="modal-footer">
<input type="hidden" id="sale_ledger_data">
<button type="button" class="btn btn-default close_sec_model" >Close</button>
<button id="share_via_Email" type="button" class="btn btn-warning">Submit</button>
</div>
</form>
</div>
</div>
</div>
<!-- share via Email -->