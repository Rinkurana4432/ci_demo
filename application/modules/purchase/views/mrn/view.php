<style>
.col, .col-container .form-group {
    width: 6%;
}
</style>
<!-- Change Status work Start -->
<?php
   //$orderCode = ($mrnView && !empty($mrnView))?$mrnView->order_code:'';
   $statusDetail = JSON_decode($mrnView->status);
   // pre($statusDetail);
   // pre($mrnView);


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
                        <!-- Smart Wizard -->
                        <!--p>This is a basic form wizard example that inherits the colors from the selected scheme.</p-->
                        <div id="wizard" class="form_wizard wizard_horizontal">
                           <ul class="wizard_steps list-top">
                              <li>
                                 <a href="javascript:void(0);">
                                 <span class="dsgn_cls">Purchase Indent</span>
                                 <span class="step_descr"><small></small></span>
                                 </a>
                              </li>
                              <?php //This conditions is check po created or not
                                 //pre($statusDetail);

                                 if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) &&  $statusDetail->PO->po_or_verbal != '' ||  $statusDetail->PO->po_code != '') || ($po!= '')){

                                 ?>
                              <li>
                                 <a href="javascript:void(0);">
                                 <span class="dsgn_cls">Purchase Order</span>
                                 <span class="step_descr"><small></small></span>
                                 </a>
                              </li>
                              <?php }else{ ?>
                              <li>
                                 <a href="javascript:void(0);">
                                 <span class="not_value">Purchase Order</span>
                                 <span class="step_descr"><small></small></span>
                                 </a>
                              </li>
                              <?php }
                                 if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->name == 'MRN' || $statusDetail->MRN->mrn_or_without_form != '' && $statusDetail->MRN->mrn_code != '' ) || ($mrn != '')){ ?>
                              <li>
                                 <a href="javascript:void(0);">
                                    <!-- not_value -->
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
                              <?php if($mrnView->ifbalance == 0){ // 0 Means Complete Payment ?>
                              <li>
                                 <span class="dsgn_cls slide-toggle">Payment <i class="fa fa-chevron-circle-down"></i></span>
                                 <span class="step_descr"><small></small></span>
                              </li>
                              <?php } elseif($mrnView->ifbalance == 1) { //1 Means Payment Not Complete ?>
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
                                    <h4><?php
                                       if ($mrnView && !empty($mrnView) && $mrnView->po_id != 0 ) {
                                       	$purchaseOrderData=getNameById('purchase_order',$mrnView->po_id,'id');
                                       	if(!empty($purchaseOrderData)){
                                       		echo $purchaseOrderData->order_code;
                                       		}
                                       }else{
                                       $purchaseindentData=getNameById('purchase_indent',$mrnView->pi_id,'id');
                                       	if(!empty($purchaseindentData)){
                                       		echo $purchaseindentData->indent_code;
                                       		}

                                       }

                                       ?></h4>
                                    <?php
                                       $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

                                       	?>
                                 </div>
                                 <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/saveStatusPI" enctype="multipart/form-data" id="purchaseIndentForm" novalidate="novalidate">
                                    <input type="hidden" name="id" value="<?php if($mrnView && !empty($mrnView)){ echo $mrnView->id;} ?>" >
                                    <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
                                    <?php
                                       if(empty($mrnView)){
                                       ?>
                                    <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
                                    <?php }else{ ?>
                                    <input type="hidden" name="created_by" value="<?php if($mrnView && !empty($mrnView)){ echo $mrnView->created_by;} ?>" >
                                    <?php } ?>
                                    <div class="item form-group" <?php  if(!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete'){ } ?>>
                                       <!-- echo 'style="pointer-events:none;"' -->
                                       <?php /*<div class="item form-group" > */?>
                                       <div class="container">
                                          <div class="col-lg-12 col-xs-12">
                                             <div class="col-xs-6">Status</div>
                                             <div style=" float:right;" class="pull-right col-xs-6">
                                                <p class="pull-right"><b>MRN ID : </b> <?php echo $mrnView->id; ?></p>
                                                <!--p class="pull-right"><b> PI Grand Total : </b> <?php //echo $indents->grand_total; ?></p>
                                                   <p><b>Balance : </b> <?php //echo $indents->ifbalance; ?></p-->
                                             </div>
                                          </div>
                                       </div>
                                       <div class="container view-paymt">
                                          <tbody>
                                             <div class="col-sm-12 col-xs-12 col-md-4">
                                                <?php if( $mrnView->po_id != 0) {?>
                                                <div class="col-md-12 col-sm-12 col-xs-12 view-bg">
                                                   <center>PO  <input type="checkbox" name="pi_status[]" id="poCheck"  value="po" <?php  if((!empty($statusDetail) && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->name == 'PO' &&  $statusDetail->PO->po_or_verbal != '' ||  $po[0]['po_id'] != '') || ($mrnView->po_or_not == 1)){ echo 'checked'; }  ?> style="pointer-events:<?php if( $mrnView->po_or_not == 1){ echo 'none'; } ?>"><br />
                                                   </center>
                                                </div>
                                                <div class="poSection col-md-12 col-xs-12" style="display:<?php  if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) ||  $statusDetail->PO->po_or_verbal != '') || ( $po[0]['po_id'] != '')){ echo 'block'; }else{ echo 'none';} ?>;">
                                                   <div class="col-md-12 col-sm-12 col-xs-12 border-rg">
                                                      <div class="radio">
                                                         <label>
                                                         <input type="radio" class="flat" name="po_or_verbal"   value="verbal" <?php  if(!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'verbal' || empty($po)){ echo 'checked'; }  if( $mrnView->po_or_not == 1){ ?>  onclick="return false" <?php } ?>> Verbal
                                                         </label>
                                                      </div>
                                                      <div class="radio">
                                                         <label>
                                                         <input type="radio" class="flat po_code"  name="po_or_verbal" value="po_code" <?php  if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'po_code') && ($mrnView->po_or_not == 1) || !empty($po) ){ echo 'checked'; } ?>   <?php if( (!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'verbal') || ($mrnView->po_or_not == 1)){ ?>  onclick="return false" <?php } ?>> PO Code
                                                         </label>
                                                      </div>
                                                      <?php if(!empty($po)){
                                                         echo '<h5><b>Po Generated List</b></h5>';
                                                         $purchaseOrderData=getNameById('purchase_order',$po[0]['po_id'],'id');
                                                         	if(!empty($purchaseOrderData)){
                                                         	echo '<a href="javascript:void(0)" id="'.$po[0]['po_id'].'" data-id="OrderView" class="add_purchase_tabs">'.$purchaseOrderData->order_code.'</a>';
                                                         	}
                                                         }
                                                         ?>
                                                   </div>
                                                </div>
                                                <?php } elseif($mrnView->pi_id != 0){?>
                                                <div class="col-md-12 col-sm-12 col-xs-12 view-bg">
                                                   <center>
                                                      PI <input type="checkbox" name="pi_status[]" id="poCheck"  value="po" <?php  if((!empty($statusDetail) && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->name == 'PO' &&  $statusDetail->PO->po_or_verbal != '' ||  $po[0]['po_id'] != '') || ($mrnView->po_or_not == 1)){ echo 'checked'; }  ?> style="pointer-events:<?php if( $mrnView->po_or_not == 1){ echo 'none'; } ?>"><br />
                                                   </center>
                                                </div>
                                                <div class="poSection col-md-12 col-xs-12" style="display:<?php  if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) ||  $statusDetail->PO->po_or_verbal != '') || ( $po[0]['po_id'] != '')){ echo 'block'; }else{ echo 'none';} ?>;">
                                                   <div class="col-md-12 col-sm-12 col-xs-12 border-rg">
                                                      <div class="radio">
                                                         <label>
                                                         <input type="radio" class="flat" name="po_or_verbal"   value="verbal" <?php  if(!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'verbal' || empty($po)){ echo 'checked'; }  if( $mrnView->po_or_not == 1){ ?>  onclick="return false" <?php } ?>> Verbal
                                                         </label>
                                                      </div>
                                                      <div class="radio">
                                                         <label>
                                                         <?php /* <input type="radio" class="flat po_code"  name="po_or_verbal" value="po_code" <?php  if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'po_code') || ($indents->po_or_not == 1)){ echo 'checked'; }elseif( !empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'verbal'){ echo 'disabled'; } ?>> PO Code */
                                                         // pre($statusDetail);
                                                         ?>
                                                         <input type="radio" class="flat po_code"  name="po_or_verbal" value="po_code" <?php  if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'po_code') && ($mrnView->po_or_not == 1) || !empty($po) ){ echo 'checked'; } ?>   <?php if( (!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'verbal') || ($mrnView->po_or_not == 1)){ ?>  onclick="return false" <?php } ?>> PI Code
                                                         </label>
                                                      </div>
                                                      <?php if(!empty($po)){
                                                         echo '<h5><b>PI Generated List</b></h5>';
                                                         $purchaseindentData=getNameById('purchase_indent',$po[0]['pi_id'],'id');
                                                         	if(!empty($purchaseindentData)){
                                                         		echo '<a href="javascript:void(0)" id="'.$po[0]['pi_id'].'" data-id="indentView" class="add_purchase_tabs">'.$purchaseindentData->indent_code.'</a>';
                                                         	}
                                                         }
                                                         ?>
                                                   </div>
                                                </div>
                                                <?php }else{ echo "Mrn Created directly";} 
												
												?>
                                             </div>
					 <div class="col-sm-12 col-xs-12 col-md-4">
						<div class="col-md-12 col-sm-12 col-xs-12 view-bg">
						   <center>GRN <input type="checkbox" name="pi_status[]" id="mrnCheck" value="mrn" <?php  if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->name == 'MRN' && $statusDetail->MRN->mrn_or_without_form != '' || $statusDetail->MRN->mrn_code != '') || ($mrn != '')){ echo 'checked'; } ?> style="pointer-events:<?php if($mrn != ''){ echo 'none'; } ?>"><br />
						   </center>
						</div>
							<div class="mrnSection col-md-12 col-xs-12" checked style="display:<?php  if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form != '') || ($mrn != '')){ echo 'block'; }else { echo 'none'; }  ?>;">
							   <div class="col-md-12 col-sm-12 col-xs-12 border-rg">
								  <div class="radio">
									 <label>
									 <input type="radio" class="flat"  name="mrn_or_without_form"  value="Without Form" <?php  if(!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form == 'Without Form'){ echo 'checked'; }  if($mrnView->mrn_or_not == 1){ ?>onclick="return false" <?php } ?>> Without Form
									 </label>
								  </div>
								  <div class="radio">
									 <label>
									 <input type="radio" class="flat mrninvoice_no"  name="mrn_or_without_form" value="mrn_code"
										<?php
										   if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form == 'mrn_code') || ($indents->mrn_or_not == 1) || ($mrn->pi_id == 0) || ($mrn->po_id == 0)){
										   echo 'checked';
										   }
										   /*if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) || $statusDetail->MRN->mrn_or_without_form == 'Without Form')){

											?>  <?php }  */?>> Invoice No.
									 </label>
									 <br/>
								  </div>
								  <?php /*<input type="text"  id="mrn_code" name="mrn_code" class="form-control " placeholder="Enter Invoice No." value="<?php  if(!empty($statusDetail)  && ((array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form != '')){ echo $statusDetail->MRN->mrn_code; } ?>" style="display:<?php  if(!empty($statusDetail)  && ((array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form == 'mrn_code')){ echo 'block'; }else { echo 'none'; }  ?>;"> */?>
								  <?php
									 if(!empty($mrn)){
										echo '<h5><b>GRN Invoice No.</b></h5>';
										// $invoice_no = '';
										// foreach($mrn as $mrnVal){
											// $invoice_no .= $mrnVal['bill_no'].'<br>';
										// }
										// echo $invoice_no;
										echo $mrn[0]['bill_no'];
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
                                             <input type="hidden" value="mrn_Data" name="frm_mrn_data">
                                             <tr>
                                                <div class="col-sm-12 col-xs-12 col-md-4">
                                                   <div class="col-md-12 col-sm-12 col-xs-12 view-bg">
                                                      <center>Payment <input type="checkbox" name="pi_status[]" id="paymentCheck" value="payment" <?php  if((!empty($statusDetail)  && (array_key_exists("Payment",$statusDetail)) && $statusDetail->Payment[0]->name == 'Payment') || ($mrnView->pay_or_not == 1)){ echo 'checked'; } ?>><br />
                                                         <?php  if(!empty($statusDetail)  && (array_key_exists("Payment",$statusDetail)) && $statusDetail->Payment[0]->name == 'Payment'){
                                                            $previousPaymentData =  json_encode($statusDetail->Payment);



                                                            } ?>
                                                         <input type="hidden" name="previousPaymentData" value='<?php  if(!empty($statusDetail)  && (array_key_exists("Payment",$statusDetail)) && $statusDetail->Payment[0]->name == 'Payment'){ echo $previousPaymentData; } ?>'>
                                                      </center>
                                                   </div>
                                                   <div class="paymentSection col-md-12 col-xs-12 border-rg" style="display:<?php  if(!empty($statusDetail)  && (array_key_exists("Payment",$statusDetail)) && $statusDetail->Payment[0]->name == 'Payment'){ echo 'block'; } else{ echo 'none'; }?>;">
                                                      <?php
                                                         //pre($statusDetail->Payment);
                                                         if( !empty($statusDetail->Payment) ){
                                                         	echo '<h2>Previous payment details</h2>';
                                                         		echo '<table class="table table-bordered" id="example">

                                                         		  <tbody>';

                                                         				foreach($statusDetail->Payment as $paymentData){
                                                         				//pre($paymentData);
                                                         				?>
                                                      <!--th scope="row" contenteditable = 'true' ><?php //echo $paymentData->amount; ?></th>
                                                         <td ><?php //echo $paymentData->balance; ?></td>
                                                         <td><?php //echo $paymentData->required_date; ?></td>
                                                         <td><?php  //echo $paymentData->description; ?></td-->
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
                                                      <input type="hidden" name="check_payment_complete" id="check_payment_complete" value="<?php if($mrnView->ifbalance == 0){ echo 'complete_payment';} ?>">
                                                      <?php }
                                                         if( $mrnView->ifbalance !=0 ){
                                                         ?>
                                                      <div <?php  if(!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete' && $mrnView->pay_or_not = 1){ echo 'style="display:none;"'; } ?>  >
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
                                                   <div class="view-bg bottam-check" >Complete <input type="checkbox" name="pi_status[]" id="completeCheck" value="complete" <?php  if((!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete') || (($mrnView->po_or_not == 1) && ($mrnView->mrn_or_not == 1) && ($mrnView->pay_or_not == 1))){ echo 'checked'; }elseif($indents->ifbalance == 0){echo 'enabled';}else{ echo 'disabled';} ?>>	<br /></div>
                                                </div>
                                             </tr>
                                          </tbody>
                                       </div>
                                    </div>
                                    <input type="hidden" value="<?php echo $mrnView->ifbalance; ?>" name="indent_grand_totl" id="get_balance">
                                    <input type="hidden" value="<?php echo $mrnView->grand_total; ?>" name="grand_total" >
                                    <!--div class="form-group" <?php // if(!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete'){ echo 'style="display:none;"'; } ?>-->
                                    <div class="form-group" <?php if($statusDetail->Complete->name == 'Complete'){echo 'style="display:none;"';} ?>>
                                       <div class="form-group">
                                          <?php /*<div class="form-group" > */?>
                                          <div class="col-md-12 col-xs-12">
                                             <center>
                                                <a class="btn  btn-default" onclick="location.href='<?php echo base_url();?>purchase/purchase_order'">Close</a>
                                                <button type="reset" class="btn edit-end-btn ">Reset</button>
                                                <?php if((!empty($mrnView) && $mrnView->save_status !=1) || empty($mrnView)){
                                                   echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">';
                                                   }?>
                                                <input type="submit" value="submit" class="btn edit-end-btn">
                                             </center>
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
</div>
<!-- Change Status work Start -->
<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv" style="padding:0px;">
   <h3 class="Material-head main-hd">
      GRN Detail
      <hr>
   </h3>
   <div >
      <div class="col-md-6 col-xs-12 col-sm-6 label-left   "  style=" padding:0px; ">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Invoice No.</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?php if ($mrnView && !empty($mrnView)) {echo $mrnView->bill_no;} ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Invoice Date</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?php if(!empty($mrnView) && $mrnView->bill_date!=''){ echo date("j F , Y", strtotime($mrnView->bill_date)); } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Purchase order Code :</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div ><?php
                  if ($mrnView && !empty($mrnView) && $mrnView->po_id != 0 ) {
                  	$purchaseOrderData=getNameById('purchase_order',$mrnView->po_id,'id');
                  	if(!empty($purchaseOrderData)){
                  		//echo $purchaseOrderData->order_code;
						 echo '<a href="javascript:void(0)" id="'.$mrnView->po_id.'" data-id="OrderView" class="add_purchase_tabs">'.$purchaseOrderData->order_code.'</a>';
                  		}
                  }else{
                  $purchaseindentData=getNameById('purchase_indent',$mrnView->pi_id,'id');
                  	if(!empty($purchaseindentData)){
                  		//echo $purchaseindentData->indent_code;
						echo '<a href="javascript:void(0)" id="'.$mrnView->pi_id.'" data-id="indentView" class="add_purchase_tabs">'.$purchaseindentData->indent_code.'</a>';
                  		}

                  }



                  ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">For Company Unit</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><b><?php
			   if(!empty($mrnView)){
					$brnch_name = getNameById_with_cid('company_address', $mrnView->company_unit, 'compny_branch_id','created_by_cid',$this->companyGroupId);
					 echo $brnch_name->company_unit;
   			}
			   //if(!empty($mrnView)){ echo $mrnView->company_unit; }

?></b></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Supplier Name</label>
            <?php if(!empty($suppliername)){
               $mrnView->supplier_name;
               $supplier_name=getNameById('supplier',$mrnView->supplier_name,'id');
               }
               ?>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div ><?php if($supplier_name == null){echo "N/A";}else {echo $supplier_name->name;  }  ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Address</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?php if($supplier_name == null){echo "N/A";}else {echo $supplier_name->address;  }  ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Terms And Conditons</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?php if(!empty($mrnView)){ echo $mrnView->terms_conditions; } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group" style="display:none;">
            <label for="material">Cost Center</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?= getSingleAndWhere('cost_center_name','purchase_cost_center',['id' => $mrnView->cost_center]); ?></div>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-xs-12 col-sm-6 label-left   " style=" padding:0px; ">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Grand Total</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?php if(!empty($mrnView)){ echo $mrnView->grand_total; } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Pay Mode</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div ><?php if(!empty($mrnView)){ echo $mrnView->payment_terms; } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Delivery Address</label>
            <?php if(!empty($mrnView)){
              $deliveryAddress = $mrnView->delivery_address;
               $deliveryAddress = getNameById('company_address',$mrnView->delivery_address,'id');
               }
			   if (!empty($mrnView)) {
					$where = array('id' => $this->companyGroupId);
					$data = $this->purchase_model->get_data_byAddress('company_detail', $where);

					$adress_data = json_decode($data[0]['address']);
					foreach($adress_data as $val_add){
						if($val_add->add_id == $mrnView->delivery_address){
							echo $val_add->address;
						}
					}
				  }
               ?>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?php echo $deliveryAddress->location;  //echo $deliveryAddress; ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Received Date</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?php if(!empty($mrnView) && $mrnView->received_date!=''){ echo date("j F , Y", strtotime($mrnView->received_date)); } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Order Date</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?php if(!empty($mrnView) && $mrnView->date!=''){ echo date("j F , Y", strtotime($mrnView->date)); } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Terms Of Delivery</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?php if(!empty($mrnView)){ echo $mrnView->terms_delivery; } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Pay Date</label>
            <div class="col-md-7 col-sm-7 col-xs-6">
               <div><?php if(!empty($mrnView) && $mrnView->payment_date != ''){ echo date("j F , Y", strtotime($mrnView->payment_date)) ; } ?></div>
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
      <hr>
      <div class="bottom-bdr"></div>
      <div class="container mt-3">
         <h3 class="Material-head">
            Material Description
            <hr>
         </h3>
         <div class="well pro-details for-leptop-1" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; border:0px; margin-top: 15px;">
            <?php if(!empty($mrnView) && $mrnView->material_name !='' && $mrnView->material_name!= '[{"material_name_id":"","uom":"","quantity":"","price":"","sub_tax":"","sub_total":"","gst":"","total":"","defected":0,"defected_reason":"","received_quantity":""}]' ){ ?>
            <div class="col-container mobile-view2">
               <!-- <div class="col-md-1 col-sm-12 col-xs-12 form-group">Material Type</div> -->
               <div class="col-md-2 col-sm-12 col-xs-12 form-group">Material Name</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Img.</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Alias</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Quantity</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Price (₹)</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Sub Total (₹)</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">GST</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Sub Tax</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Total (₹)</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Rc'd | Invoice Qty</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group">Defected Qty</div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1;">Approve /Disapprove with reason</div>
            </div>
            <?php
               if(!empty($mrnView) && $mrnView->material_name !=''){

               $materialDetail =  json_decode($mrnView->material_name);


               $subTotal=0;
               $Total=0;
               	foreach($materialDetail as $material_detail){
					if($material_detail->material_name_id != ''){
						
               		$subTotal+=$material_detail->sub_total;
               		$Total+=$material_detail->total;
               		$material_id=$material_detail->material_name_id;
               		$materialName=getNameById('material',$material_id,'id');
               		$materialtype=getNameById('material_type',$material_detail->material_type_id,'id');
               		$materialtype_old=getNameById('material_type',$mrnView->material_type_id,'id');
                     $lotnodetails=getNameById('lot_details',$material_detail->lotno,'id');

               ?>
            <div class="row-padding col-container mobile-view view-page-mobile-view">
				<!-- <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Material Type</label>
                  <div ><span><?php if (!empty($materialtype)) {	echo $materialtype->name;	}else{ echo $materialtype_old->name; } ?></div>
            </div> -->


               <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                  <label>Material Name</label>
                  <div ><span><?php if (!empty($materialName)) {	echo getPCode($material_id).$materialName->material_name;	} ?>:</span>&nbsp;&nbsp;<?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?></div>
               </div>

               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <div ><?php 
					$attachments = $this->purchase_model->get_image_by_materialId('attachments', 'rel_id', $material_detail->material_name_id);
					if(!empty($attachments)){
					echo '<img style="width: 50px; height: 37px; " src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
					}else{
						echo '<img style="width: 50px; height: 37px;" src="'.base_url().'assets/uplodimg/noimage.jpg">';
					}?></div>
               </div>
			   <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Alias</label>
                 
				  <div ><?php if (!empty($material_detail)) { echo $material_detail->aliasname;} ?></div>
               </div>

               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Quantity</label>
                  <div ><?php  if (!empty($material_detail)) { echo $material_detail->quantity;} ?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Price (₹)</label>
                  <div ><?php  if (!empty($material_detail)) { echo number_format($material_detail->price); } ?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Sub Total (₹)</label>
                  <div ><?php  if (!empty($material_detail)) { echo $material_detail->sub_total; } ?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>GST</label>
                  <div ><?php  if (!empty($material_detail)) { echo $material_detail->gst;} ?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Sub Tax</label>
                  <div ><?php  if (!empty($material_detail)) { echo $material_detail->sub_tax; } ?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Total (₹)</label>
                  <div ><?php  if (!empty($material_detail)) { echo number_format($material_detail->total); } ?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Received Quantity</label>
                  <div ><?php  if (!empty($material_detail)) { echo $material_detail->received_quantity;?> <?php echo ' | '.$material_detail->invoice_quantity; }?></div>
               </div>
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <div ><?php  if (!empty($material_detail)) { echo $material_detail->defectedQty??'0'; } ?></div>
               </div>
               <!-- <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                  <label>Invoice Quantity</label>
                  <div ><?php  if (!empty($material_detail)) { echo $material_detail->invoice_quantity;  }?></div>
               </div> -->
               <div class="col-md-1 col-sm-12 col-xs-12 form-group col" style="border-right: 1px solid #c1c1c1;">
                  <label>Approve /Disapprove with reason</label>
                  <div ><?php echo ($material_detail->defected == 1)?$material_detail->defected_reason:'';?></div>
               </div>
            </div>
        <?php  }  }   } } ?>
         </div>
         <table class="well pro-details for-print" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; border:0px; margin-top: 15px;">
            <?php



			if(!empty($mrnView) && $mrnView->material_name !=''){?>
            <tr>
               <th class="col-md-2 col-sm-12 col-xs-12 form-group">Material Name</th>
               <th class="col-md-2 col-sm-12 col-xs-12 form-group">Img.</th>
               <th class="col-md-2 col-sm-12 col-xs-12 form-group">Alias</th>
               <th class="col-md-1 col-sm-12 col-xs-12 form-group">Quantity</th>
               <th class="col-md-1 col-sm-12 col-xs-12 form-group">Price (₹)</th>
               <th class="col-md-1 col-sm-12 col-xs-12 form-group">Sub Total (₹)</th>
               <th class="col-md-1 col-sm-12 col-xs-12 form-group">GST</th>
               <th class="col-md-1 col-sm-12 col-xs-12 form-group">Sub Tax</th>
               <th class="col-md-1 col-sm-12 col-xs-12 form-group">Total (₹)</th>
               <th class="col-md-2 col-sm-12 col-xs-12 form-group">Received Quantity</th>
               <th class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1;">Approve /Disapprove with reason</th>
            </tr>
            <?php
               if(!empty($mrnView) && $mrnView->material_name !=''){
				 
               $materialDetail =  json_decode($mrnView->material_name);
               $subTotal=0;
               $Total=0;
               	foreach($materialDetail as $material_detail){
					    // pre($material_detail);
               		 // if($material_detail->remove_mat_id != 0){
               		  if($material_detail->material_name_id != 0){
               			 // pre($material_detail);
               		$subTotal+=$material_detail->sub_total;
               		$Total+=$material_detail->total;
               		$material_id=$material_detail->material_name_id;
               		$materialName=getNameById('material',$material_id,'id');
               ?>
            <tbody>
               <tr>
                  <td>
                     <div ><span><?php if (!empty($materialName)) {	echo getPCode($material_id).$materialName->material_name;	} ?>:</span>&nbsp;&nbsp;<?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?></div>
                  </td>
				  <td>
                     <div ><?php 
					$attachments = $this->purchase_model->get_image_by_materialId('attachments', 'rel_id', $material_detail->material_name_id);
					if(!empty($attachments)){
					echo '<img style="width: 50px; height: 37px; " src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
					}else{
						echo '<img style="width: 50px; height: 37px;" src="'.base_url().'assets/uplodimg/noimage.jpg">';
					}?></div>
                  </td>
				  <td>
                     <div ><?php if (!empty($material_detail)) { echo $material_detail->aliasname;} ?></div>
                  </td>
                  <td>
                     <div ><?php echo $material_detail->quantity; ?></div>
                  </td>
                  <td>
                     <div ><?php echo number_format($material_detail->price); ?></div>
                  </td>
                  <td>
                     <div ><?php echo $material_detail->sub_total; ?></div>
                  </td>
                  <td>
                     <div ><?php echo $material_detail->gst; ?></div>
                  </td>
                  <td>
                     <div ><?php echo $material_detail->sub_tax; ?></div>
                  </td>

                  <td>
                     <div ><?php echo number_format($material_detail->total); ?></div>
                  </td>
                  <td>
                  <div ><?php echo $material_detail->received_quantity;?></div>
                  </td>
                  <td>
                     <div ><?php echo ($material_detail->defected == 1)?$material_detail->defected_reason:'';?></div>
                  </td>
               </tr>
            </tbody>
            <?php }  }  }?>
         </table>
         <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
            
            <div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
               <div class="col-md-12 col-sm-5 col-xs-12 text-right">
                  <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                     <div class="col-md-6 col-sm-5 col-xs-6 text-right">
                        Sub Total (₹)
                     </div>
                     <div class="col-md-6 col-sm-5 col-xs-6 text-left">
                        <?php echo number_format($subTotal); ?>
                     </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12 text-right cgst">
                     <div class="col-md-6 col-sm-5 col-xs-6 text-right">
                        Total (₹)
                     </div>
                     <div class="col-md-6 col-sm-5 col-xs-6 text-left">
                        <?php echo number_format($Total); ?>
                     </div>
                  </div>
                  <?php
                     $charges_Data = json_decode($mrnView->charges_added,true);
                     $charges_total = 0;
                     foreach($charges_Data as $val_charges){
                        $charges_name = $val_charges['particular_charges_name'];
                        $charges_total+= $val_charges['amt_with_tax'];
                     }
                     ?>
                  <?php if($mrnView->other_charges !='' && $mrnView->other_charges != 0){ ?>
                  <div class="col-md-12 col-sm-12 col-xs-12 text-right igst style='display:none;'" >
                     <div class="col-md-6 col-sm-5 col-xs-6 text-right">Other Charges with Tax(if any) (₹):</div>
                     <div class="col-md-6 col-sm-5 col-xs-6 text-left"><?php if(!empty($mrnView)){echo number_format($mrnView->other_charges);} ?></div>
                  </div>
                  <?php } ?>
                  <?php if($mrnView->freight !='' && $mrnView->freight != 0){ ?>
                  <div class="col-md-12 col-sm-12 col-xs-12 text-right sgst">
                     <div class="col-md-6 col-sm-5 col-xs-6 text-right">
                        Freight (₹)
                     </div>
                     <div class="col-md-6 col-sm-5 col-xs-6 text-left">
                        <?php if(!empty($mrnView)){echo number_format($mrnView->freight);} ?>
                     </div>
                  </div>
                  <?php }?>
                  <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 20px;color: #2C3A61; border-top: 1px solid #2C3A61;">
                     <div class="col-md-6 col-sm-5 col-xs-6 ">
                        Grand Total (₹)
                     </div>
                     <div class="col-md-6 text-left"><?php if(!empty($mrnView)){ echo number_format($mrnView->grand_total); } ?></div>
                  </div>
               </div>
            </div>
         </div>
         <?php } ?>
         <hr>
         <div class="bottom-bdr"></div>
		 <?php /*
         <div class="container" style="clear: both;">
            <div class="card" style="margin-top: 0px; margin-bottom: 3%;">
               <div class="card-body" style="box-shadow: rgba(0, 0, 0, 1) 1px 1px 9px -4px;padding: 10px;">
                  <div class="row">
                     <div class="col-md-10">
                        <p style="float: left;">
                           <a class="float-left" ><strong>Ratings&nbsp;&nbsp;:</strong></a>
                        <div class="star-rating" style="margin-top: -18px;">
                           <?php
                              for($i = 1; $i <= $mrnView->rating ; $i++) {
                              	echo '<i class="fa fa-star" aria-hidden="true"></i>&nbsp;';
                              }
                              /* $j = 1;
                              while($j<=$countEmptyStar) {
                              	echo '<s style="line-height: 13px;"></s>';
                              	$j++;
                              } 
                              ?>
                        </div>
                        </p>
                        <div class="clearfix"></div>
                        <label class="col-md-12 col-sm-12 col-xs-12" for="rating" style="padding: 0px;">Comments</label>
                        <p><?php if(!empty($mrnView)){ echo $mrnView->comments; } ?></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
		 */?>
      </div>
   </div>
</div>
<div>
</div>
<div class="clearfix"></div>
</div>
<center>
   <button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
</center>


